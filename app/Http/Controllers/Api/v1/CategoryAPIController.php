<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Review;
use App\Models\Seller;
use Illuminate\Support\Str;
use File;
use Illuminate\Support\Facades\DB;

class CategoryAPIController extends Controller
{

    public function categoryList()
    {
        $response['status'] = true;
        $response['message'] = 'Category Found';
        $response['data'] = Category::where('active', 1)->get();
        return response($response, 200);
    }
    public function sellerByCategory($id)
    {
        try {

            $response['status'] = true;
            $response['message'] = 'Sellers Found';
            $categories = Category::with('sellers.offers')->where('id', $id)->get();
            if (!sizeof($categories)) {
                $response['status'] = true;
                $response['message'] = 'Category not found';
                $response['data'] = (object)[];
                return response($response, 200);
            }
            $category = Category::where('id', $id)->get()->first();
            $categories = $categories->first();
            $arr = [];
            foreach ($categories['sellers'] as $oneSeller) {
                if (sizeof($oneSeller->offers)) {

                    $review = Review::select(DB::Raw("avg(review) as total_review, COUNT(user_id) no_of_users"))
                        ->where(["seller_id" => $oneSeller->id])
                        ->groupBy('seller_id')
                        ->get()
                        ->first();
                    $oneSeller['review'] = $review;
                    $oneSeller['category'] = $category;
                    array_push($arr, $oneSeller);
                }
            }
            unset($categories['sellers']);
            $response['message'] = sizeof($arr) ? 'Sellers Found' : 'Sellers Not Found';
            $categories['sellers'] = $arr;

            $response['data'] = $categories;
            // $response['data']['sellers'] = $arr;
            return response($response, 200);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = $th->getMessage();
            return response($response, 400);
        }
    }
    public function feedByCity($city = null)
    {
        try {
            if ($city == null) {
                $response['status'] = true;
                $response['message'] = 'Sellers Found';
                $categories = Category::with('sellers.offers')->get();
                $response['data'] = $this->extractSellerHavingOffers($categories);
                return response($response, 200);
            }
            $response['status'] = true;
            $response['message'] = 'Sellers Found';
            $categories = Category::with('sellers.offers')->whereHas('sellers', function ($q) use ($city) {
                $q->where('city', 'LIKE', '%' . $city . '%');
            })->get();
            $response['data'] = $this->extractSellerHavingOffers($categories);
            return response($response, 200);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = $th->getMessage();
            return response($response, 400);
        }
    }
    public function extractSellerHavingOffers($categories)
    {

        for ($i = 0; $i < sizeof($categories); $i++) {
            $arr = [];
            foreach ($categories[$i]['sellers'] as $oneSeller) {
                if (sizeof($oneSeller->offers)) {
                    $review = Review::select(DB::Raw("avg(review) as total_review, COUNT(user_id) no_of_users"))
                        ->where(["seller_id" => $oneSeller->id])
                        ->groupBy('seller_id')
                        ->get()
                        ->first();
                    $oneSeller['review'] = $review;
                    array_push($arr, $oneSeller);
                }
            }
            unset($categories[$i]['sellers']);
            $categories[$i]['sellers'] = $arr;
        }
        return $categories;
    }
}

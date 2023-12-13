<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Review;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchAPIController extends Controller
{
    /**
     * Get all Sellers list
     */
    public function searchSeller(Request $req)
    {
        $location   = $req->loc;
        $s          = $req->s;
        $response   = array();
        $cond       = array();
        // $state      = array();

        try {
            // if (!auth()->user()) {
            //     $response['status'] = false;
            //     $response['message'] = 'Unautherized Access';
            //     return response($response, 401);
            // }
            $name = [];
            if ($s != null)
                $name = ['business_name' => '%' . preg_replace('/\s+/', '%', $s) . '%'];

            if ($location != null) {
                $location = preg_replace('/\s+/', '%', $location);
                $cond =  [
                    'city'      => '%' .  $location . '%',
                    'area'      => '%' .  $location . '%',
                    'address'   => '%' .  $location . '%',
                    'zip'       => '%' .  $location . '%',
                    'state'     => '%' .  $location . '%',
                    'address'   => '%' .  $location . '%',
                ];
            }
            $status = ['status' => 'Active'];
            $response['status'] = true;
            $response['message'] = 'Sellers Found';
            $response['data'] = $this->allSellerDataByCond($cond, $name, $status);
            return  response($response, 200);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = 'Sellers Found';
            $response['error'] = $th->getMessage();
            return  response($response, 500);
        }
    }
    /**
     * Get seller data from by searching and status
     * @param Array $cond
     * @param Array $status
     * @return Object
     */
    public function allSellerDataByCond(array $cond, array $name, array $status,)
    {
        $finalData = array();

        $sellers =   Seller::with('category', 'offers')->where(function ($query) use ($cond) {
            foreach ($cond as $key => $value) {
                $query->orWhere($key, 'LIKE', $value);
            }
        })
            ->where($status)
            ->where(function ($query) use ($name) {
                foreach ($name as $key => $value) {
                    $query->where($key, 'LIKE', $value);
                }
            })
            ->get()
            ->makeHidden([
                'longitude',
                'latitude',
                'business_email',
                'business_phone',
                'email_verified',
                'phone_verified',
                'document_img_url',
                'verified',
                'status',
                'owner_name',
                'shop_contact',
                'weekly_timing',
                'created_at',
                'updated_at',
                'created_at'
            ]);
        foreach ($sellers as $seller) {
            $seller['weekly_timing'] = json_decode($seller['weekly_timing']);
            array_push($finalData, $seller);
        }
        $arr = [];
        foreach ($finalData as $oneSeller) {
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
        return $arr;
    }
    /**
     * Find seller by logitude latitude
     */
    public function findSellerNear(Request $req)
    {
        try {

            $longitude = $req->long;
            $latitude = $req->lat;
            if ($latitude &&  $longitude) {
                $distance = $req->dis ? $req->dis : 15;
                $sellers = Seller::select(DB::Raw("(6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) AS distance"), 'id', 'FK_user_id', 'FK_category_id', 'business_name', 'business_email', 'business_phone', 'email_verified', 'phone_verified', 'document_img_url', 'status', 'verified', 'created_at', 'updated_at', 'shop_logo_url', 'shop_id', 'owner_name', 'area', 'zip', 'city', 'state', 'address', 'longitude', 'latitude', 'shop_contact', 'shop_cover_image', 'weekly_timing', 'is_open')
                    ->where(['status' => 'Active'])
                    ->with('category', 'offers')
                    ->whereRaw("(6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
                    ->orderBy('distance', 'asc')
                    ->take(10)
                    ->get();
                $arr = [];
                foreach ($sellers as $oneSeller) {
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

                $response['status'] = true;
                $response['message'] = 'Sellers Found';
                $response['result'] = $arr;
                return  response($response, 200);
            }
            $sellers = Seller::with('offers', 'category')->where(['status' => 'Active'])->get();
            $arr = [];
            foreach ($sellers as $oneSeller) {
                if (sizeof($oneSeller->offers)) {
                    // $oneSeller['shop_cover_image'] = $
                    $review = Review::select(DB::Raw("avg(review) as total_review, COUNT(user_id) no_of_users"))
                        ->where(["seller_id" => $oneSeller->id])
                        ->groupBy('seller_id')
                        ->get()
                        ->first();
                    $oneSeller['review'] = $review;
                    array_push($arr, $oneSeller);
                }
            }
            $response['status'] = true;
            $response['message'] = 'Sellers Found';
            $response['result'] = $arr;

            return  response($response, 200);
        } catch (\Throwable $th) {
            $response['error'] = $th->getMessage();
            return  response($response, 500);
        }
    }
}

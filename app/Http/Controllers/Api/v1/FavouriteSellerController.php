<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FavouriteSeller;
use App\Models\FavSellersOffer;
use App\Models\Review;
use App\Models\Seller;
use Illuminate\Support\Facades\DB;
use Validator;

class FavouriteSellerController extends Controller
{
    public function addToMyFav(Request $request)
    {
        try {
            if (!auth()->user()) {
                $response['status'] = false;
                $response['message'] = 'Unautherized Access';
                return response($response, 401);
            }
            $isAlreadyExist = FavouriteSeller::where([
                'user_id' => auth()->user()->id, 'seller_id' => $request->seller_id
            ])->get()->count();
            if ($isAlreadyExist)
                return response()->json(['status' => true, 'message' => 'Seller already in your favorite.'], 200);
            $fav = new FavouriteSeller();
            $fav->user_id = auth()->user()->id;
            $fav->seller_id = $request->seller_id;
            $fav->save();
            return response()->json(['status' => true, 'message' => 'Seller added in favorite successfully!'], 200);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = 'Something went wrong';
            return response($response, 400);
        }
    }
    public function removeToFav(Request $request)
    {
        try {
            if (!auth()->user()) {
                $response['status'] = false;
                $response['message'] = 'Unautherized Access';
                return response($response, 401);
            }
            $fav = FavouriteSeller::where(['user_id' => auth()->user()->id, 'seller_id' => $request->seller_id]);
            $fav->delete();
            return response()->json(['status' => true, 'message' => 'Seller removed from favorite successfully!'], 200);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] =
                $th->getMessage();
            return response($response, 400);
        }
    }
    public function allFav(Request $req)
    {
        try {
            if (!auth()->user()) {
                $response['status'] = false;
                $response['message'] = 'Unautherized Access';
                return response($response, 401);
            }
            $favs = FavouriteSeller::where('user_id', auth()->user()->id)->get();
            $arr = [];
            foreach ($favs as $fav) {
                $seller = Seller::with('offers', 'category')->where(['id' => $fav->seller_id, 'status' => 'Active'])->get()->first();
                $review = Review::select(DB::Raw("avg(review) as total_review, COUNT(user_id) no_of_users"))
                ->where(["seller_id" => $seller->id])
                    ->groupBy('seller_id')
                    ->get()
                    ->first();
                $seller['review'] = $review;
                $fav['seller'] = $seller;
                array_push($arr, $fav);
            }
            $response['status'] = true;
            $response['message'] = sizeof($arr) ? 'Found' : 'Empty';
            $response['data'] = $arr;
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = $th->getMessage();
            return response($response, 400);
        }
    }
    public function offersFromShop(Request $req)
    {
        try {
            if (!auth()->user()) {
                $response['status'] = false;
                $response['message'] = 'Unautherized Access';
                return response($response, 401);
            }
            $fav = FavouriteSeller::with('seller')->where('user_id', auth()->user()->id)->get('seller_id');
            $response['status'] = true;
            $response['message'] = sizeof($fav) ? 'Found' : 'Empty';
            $response['data'] = $fav;
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = $th->getMessage();
            return response($response, 400);
        }
    }
    public function offerNotification(Request $req)
    {
        try {
            if (!auth()->user()) {
                $response['status'] = false;
                $response['message'] = 'Unautherized Access';
                return response($response, 401);
            }
            $fav = FavSellersOffer::with('offer.seller.category')->where('FK_user_id', auth()->user()->id)->get();
            $response['status'] = true;
            $response['message'] = 'Notifications Found';
            $response['data'] = $fav;
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = $th->getMessage();
            return response($response, 400);
        }
    }
    public function offerUpdateNotificationStatus(Request $req)
    {
        try {
            if (!auth()->user()) {
                $response['status'] = false;
                $response['message'] = 'Unautherized Access';
                return response($response, 401);
            }
            $validator = Validator::make($req->all(), [
                'id' => 'numeric|required'
            ]);
            // $request['offer'] = json_decode($request->offer);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()], 400);
            }
            FavSellersOffer::where(['FK_user_id' => auth()->user()->id, 'id' => $req->id])->update(['is_seen' => 'seen']);
            $response['status'] = true;
            $response['message'] = 'Notifications Status updated';
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = $th->getMessage();
            return response($response, 400);
        }
    }
}

<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PushController;
use App\Models\AppSetting;
use App\Models\Offer;
use App\Models\OfferScan;
use App\Models\Reward;
use App\Models\Seller;
use App\Models\User;
use App\Models\Voucher;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QRController extends Controller
{
    public function getQR($id = '')
    {
        try {
            $seller = Seller::with('offers', 'category')->where('shop_id', $id)->get()->first();
            if (!auth()->user() || $id == '' || !$seller) {
                $playUrl = AppSetting::where('title', 'play_url')->first()->description;
                $iosUrl = AppSetting::where('title', 'ios_url')->first()->description;
                return view('helper.download', compact('playUrl', 'iosUrl'));
            }
            $allOffers =  $seller->offers;
            unset($seller->offers);
            $seller['offer'] = sizeof($allOffers) ? $allOffers[rand(0, sizeof($allOffers) - 1)] : 'No active offer found';
            $response['status'] = true;
            $response['message'] = 'Offer found';
            $response['data'] = $seller;
            return response($response, 200);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = 'Something went wrong';
            return response($response, 400);
        }
    }

    public function voucher(Request $request)
    {
        try {
            $id = $request->id;
            $seller = Seller::with('open_vouchers', 'category')->where('shop_id', $id)->get()->first();
            if (!auth()->user() || $id == '' || !$seller) {
                $playUrl = AppSetting::where('title', 'play_url')->first()->description;
                $iosUrl = AppSetting::where('title', 'ios_url')->first()->description;
                return view('helper.download', compact('playUrl', 'iosUrl'));
            }
            $validator = Validator::make(['id' => $request->id],  [
                "id"             => "string|required|exists:sellers,shop_id",
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'Invalid QR'], 400);
            }
            $validator2 = Validator::make($request->all(),  [
                "purchase_amount"             => "numeric|required",
            ]);
            if ($validator2->fails()) {
                return response()->json(['status' => false, 'message' => 'Enter valid purchase amount'], 400);
            }

            $allVouchers = Voucher::where('FK_seller_id', $seller->id)
                ->where('from_amount', '<=', $request->purchase_amount)
                ->where('to_amount', '>=', $request->purchase_amount)
                ->where('status', '=', 'Active')
                ->get();

            // Check if already scanned  QR today
            $reward = Reward::where([
                'FK_user_id' => auth()->user()->id,
                'FK_seller_id' => $seller->id
            ])
                ->where(DB::raw(' CAST(created_at as date) '), '=', date('Y-m-d'))
                ->get();

            // if (sizeof($reward)) {
            //     $response['status'] = false;
            //     $response['message'] = 'You can get reward only once in a day.';
            //     return response($response, 200);
            // }


            $response['status'] = true;
            $response['message'] = 'Voucher found';
            unset($seller->open_vouchers);


            // check if voucher is available at shop or not
            $seller['voucher'] = sizeof($allVouchers) ? $allVouchers[rand(0, sizeof($allVouchers) - 1)] : 'No active voucher found';

            if (!sizeof($allVouchers)) {
                $response['status'] = false;
                $response['message'] = 'Voucher Not Found For This Amount';
                return response($response, 200);
            }
            // Added to user rewards section
            if (gettype($seller['voucher']) != 'string') {
                Reward::create([
                    'FK_user_id' => auth()->user()->id,
                    'FK_seller_id' => $seller->id,
                    'FK_voucher_id' => $seller['voucher']->id,
                ]);
            }
            $response['data'] = $seller;

            return response()->json(['data' => $seller, 'status' => true, 'message' => 'Voucher found']);
        } catch (\Throwable $th) {
            $response['status'] = false;
            // $response['message'] = 'Something went wrong';
            $response['message'] = $th->getMessage();
            return response($response, 400);
        }
    }
    public function postQR(Request $request)
    {
        if (!auth()->user()) {
            $response['status'] = false;
            $response['message'] = 'Unautherized Access';
            return response($response, 401);
        }
        $validator = Validator::make(['id' => $request->id],  [
            "id"             => "string|required|exists:sellers,shop_id",
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Invalid QR'], 400);
        }
        $validator = Validator::make($request->all(),  [
            "offer_id"       => "numeric|required|exists:offers,id",
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 400);
        }
        $seller = Seller::where(['shop_id' => $request->id])->get()->first();

        $isCreatedId = OfferScan::create([
            'FK_user_id' => auth()->user()->id,
            'FK_seller_id' => $seller->id,
            'FK_offer_id' => $request->offer_id,
        ])->id;

        if ($isCreatedId) {
            // sending offer
            $userName = auth()->user()->name;
            $sellerToken = Seller::where(['id' => $seller->id,])->get('FK_user_id')->first()->FK_user_id;
            $sellerDeviceToken = User::where(['id' => $sellerToken])->get('device_token')->first()->device_token;
            $offerInfo = Offer::where(['id' => $request->offer_id])->get()->first();
            if ($sellerDeviceToken) {
                $pushNotification = new PushController();
                $pushNotification->sendNotificationParam(
                    [$sellerDeviceToken],
                    $userName . ' has grab offer',
                    $offerInfo->offer_title . ' offer is scanned by ' . $userName
                );
            }
            $response['status'] = true;
            $response['message'] = 'Offer Applied';
            return response()->json($response, 200);
        }
        $response['status'] = false;
        $response['message'] = 'Something went wrong';
        return response()->json($response, 400);
    }
    public function offerHistory(Request $request)
    {
        try {
            if (!auth()->user()) {
                $response['status'] = false;
                $response['message'] = 'Unautherized Access';
                return response($response, 401);
            }
            $offers = OfferScan::with('offer')->where(['FK_user_id' => auth()->user()->id])->get();
            $response['status'] = true;
            $response['message'] = 'Offers found found';
            $response['data'] = $offers;
            return response($response, 200);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = $th->getMessage();
            return response($response, 400);
        }
    }
}

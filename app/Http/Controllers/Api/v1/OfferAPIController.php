<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;

use App\Exceptions\CustomException;
use App\Models\Notification;
use App\Models\Offer;
use App\Models\OffersTemplate;
use App\Models\Seller;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class OfferAPIController extends Controller
{
    private $seller;

    public function offerTempalteList()
    {
        try {
            $offers =  OffersTemplate::all();
            for ($i = 0; $i < sizeof($offers); $i++) {
                $offers[$i]['offer_type']  = json_decode($offers[$i]['offer_type']);
            }
            $response['status'] = true;
            $response['message'] = 'Template found';
            $response['data'] = $offers;
            return response($response, 200);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = $th->getMessage();
            return response($response, 400);
        }
    }


    /**
     * Convert template to 
     * @param Array $replacements
     * @param String $template - with replacement
     */
    function bind_to_template($replacements, $template)
    {
        try {
            return preg_replace_callback('/{{(.+?)}}/', function ($matches) use ($replacements) {
                return $replacements[$matches[1]];
            }, $template);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = $th->getMessage();
            return response($response, 400);
        }
    }

    /**
     * Add Offers By Seller
     */
    public function add(Request $request)
    {
        $response = array();
        try {
            if (!auth()->user()) {
                $response['status'] = false;
                $response['message'] = 'Unautherized Access';
                return response($response, 401);
            }
            if (auth()->user()) {
                $seller = Seller::where(['FK_user_id' => auth()->user()->id])->get()[0];
            }

            $todayDate = date('d-m-Y');

            $validator = Validator::make($request->all(), [
                "offerCode"             => "string|required|exists:offers_templates,offer_code",
                "offerType"             => Rule::in(['Rs', '%', '']),
                "offerTitle"            => "string|required",
                "offerDescription"      => "string|required",
                "offer"                 => ["json"],
                "startDate"             => 'required|date_format:d-m-Y|after_or_equal:' . $todayDate,
                "endDate"               => 'required|date_format:d-m-Y|after:startDate'
            ]);
            // $request['offer'] = json_decode($request->offer);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()], 400);
            }
            $offer = array();
            $startDate = date("Y-m-d", strtotime($request->startDate));
            $endDate = date("Y-m-d", strtotime($request->endDate));

            $offerTemplate = OffersTemplate::where('offer_code', $request->offerCode)->get()[0];


            $offerX_Y_val = (array) json_decode($request->offer);
            if (array_key_exists('x', $offerX_Y_val)) {
                $offerX_Y_val['x'] = $offerX_Y_val['x'] . $request->offerType;
            }
            if (array_key_exists('y', $offerX_Y_val)) {
                $offerX_Y_val['y'] = $offerX_Y_val['y'] . $request->offerType;
            }

            $offer['offer_type'] = $this->bind_to_template($offerX_Y_val, $offerTemplate->offer_template);
            $offer['offer_title'] = $request->offerTitle;
            $offer['offer_description'] = $request->offerDescription;
            $offer['offer_start_date'] = $startDate;
            $offer['offer_end_date'] = $endDate;
            $offer['offer_status'] = 'Inactive';
            $offer['create_by'] = auth()->user()->id;
            $offer['FK_shop_id'] = $seller->shop_id;


            $isOfferAdded = Offer::create($offer);
            $response['token'] = explode(" ", $request->header('Authorization'))[1];
            if ($isOfferAdded) {
                Notification::create(["notification_type" => "offers", "message" => "Please Verify <b>Offer: " . $offer['offer_title'] . "</b>."]);
                $response['status'] = true;
                $response['message'] = 'Offer Added Successfully Our Team will Review to Activate.';
                return response($response, 201);
            }
            $response['status'] = false;
            $response['message'] = 'something went wrong';
            return  response($response, 400);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = $th->getMessage();
            return response($response, 400);
        }
    }
    public function destroy($id)
    {
        $offer = Offer::where('id', $id)->first();
        if(!$offer){
            return response()->json(['status' => false, 'message' => 'Offer not found'], 404);
        }
        $offer->delete();
        return response()->json(['status' => true, 'message' => 'Offer deleted successfully'], 200);
    }
    private function checkAutherization()
    {
    }

    public function uploadDoc($request, $uploadName)
    {
        if ($request->hasFile($uploadName)) {
            $file = $request->file($uploadName);
            $fileName =  Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->move('upload/files/', $fileName);
            return [true, 'upload/files/' . $fileName];
        } else {
            return [false];
        }
    }
}

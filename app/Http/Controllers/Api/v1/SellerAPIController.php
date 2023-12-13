<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PushController;
use App\Models\Category;
use App\Models\Categorydefault;
use App\Models\Notification;
use App\Models\Offer;
use App\Models\Review;
use App\Models\Seller;
use App\Models\User;
use DateTime;
use Dotenv\Validator as DotenvValidator;
use Illuminate\Http\Request;
use StatusMessages as message;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use File;
use Illuminate\Support\Facades\DB;

class SellerAPIController extends Controller
{

    public function becomeSeller(Request $request)
    {
        $response = array();
        try {
            if (!auth()->user()) {
                $response['status'] = false;
                $response['message'] = 'Unautherized Access';
                return response($response, 401);
            }
            $validator = Validator::make($request->all(), [
                'document'      =>  'required|image|max:10240',
                'business_name' =>  'required|string',
                'business_email' => 'required|email',
                'seller_phone'  =>  'required|digits:10',
                'category'      =>  'required|numeric',
                'city'          =>  'required|string',
                'state'         =>  'required|string',
                'area'          =>  'string',
                'address'       =>  'string',
                'owner_name'    =>  'nullable|string',
                'zip'           =>  'required|digits:6',
                'latitude'      =>  ['nullable', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
                'longitude'     =>  ['nullable', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/']
            ]);
            $messages =  $validator->errors()->toArray();
            $obj = [];
            $d = array_values($messages);

            // array_values($messages)
            if ($validator->fails()) {
                return response(
                    [
                        'status' => false,
                        'message' => 'Please Enter Valid Information'
                    ],
                    400
                );
            }
            $activeSeller = Seller::where(['FK_user_id' => auth()->user()->id, 'status' => 'Active'])->get()->count();
            if ($activeSeller) {
                $response['status'] = true;
                $response['message'] = 'Account Already Activated. Please Complete Your Business Profile.';
                $response['token'] = explode(" ", $request->header('Authorization'))[1];
                return  response($response, 200);
            }
            $updoc = $this->uploadDoc($request, 'document');
            if (!$updoc[0]) {
                $response['status'] = false;
                $response['messsage'] = 'File not found';
                return response($response, 401);
            }

            $categoryImage = Categorydefault::where('cat_id', $request['category'])->get()->first()->image;
            $logoUrl = 'admin/assets/img/logo.png';
            $sellerInfo = [
                'business_name'     => $request['business_name'],
                'document_img_url'  => $updoc[1],
                'business_email'    => $request['business_email'],
                'business_phone'    => $request['seller_phone'],
                'FK_category_id'    => $request['category'],
                'city'              => $request['city'],
                'area'              => $request['area'],
                'address'           => $request['address'],
                'state'             => $request['state'],
                'zip'               => $request['zip'],
                'FK_user_id'        => auth()->user()->id,
                'shop_cover_image'  => $categoryImage,
                'shop_logo_url'     => $logoUrl,
                'weekly_timing'     => '{"MON": {"is_open":true,"open": "10AM","close":"8PM"} ,"TUES":{"is_open":true,"open":"10AM","close":"8PM"},"WED":{"is_open":true,"open":"10AM","close":"8PM"},"THUS":{"is_open":true,"open":"10AM","close":"8PM"},"FRI":{"is_open":true,"open":"10AM","close":"8PM"},"SAT":{"is_open":true,"open":"10AM","close":"8PM"},"SUN":{"is_open":false,"open":"","close":""}}'
            ];
            if ($request['latitude'] &&  $request['longitude']) {
                $sellerInfo['latitude'] = $request['latitude'];
                $sellerInfo['longitude'] = $request['longitude'];
            }
            if ($request['owner_name']) {
                $sellerInfo['owner_name'] = $request['owner_name'];
            }

            $activeSeller = Seller::where(['FK_user_id' => auth()->user()->id, 'status' => 'Active'])->get()->count();
            $seller = Seller::where(['FK_user_id' => auth()->user()->id, 'status' => 'Inactive'])->get();

            if ($activeSeller) {
                $response['status'] = true;
                $response['message'] = 'Account Already Activated. Please Complete Your Business Profile.';
                $response['token'] = explode(" ", $request->header('Authorization'))[1];
                return  response($response, 200);
            }
            // Create new Seller Account
            if (count($seller)  == 0) {
                Seller::create($sellerInfo);
                Notification::create(["notification_type" => "sellers", "message" => "Please Verify <b>Seller: " . $sellerInfo['business_name'] . "</b>."]);
                $sellerDeviceToken = auth()->user()->device_token;
                if ($sellerDeviceToken) {
                    $pushNotification = new PushController();
                    $result =  $pushNotification->sendNotificationParam(
                        [$sellerDeviceToken],
                        'Become Seller Request Is Under Review',
                        'Our Team Will Contact You to Verify Your Request.'
                    );
                }
                $response['status'] = true;
                $response['message'] = 'Our Team Will Contact You to Verify Your Request.';
                $response['token'] = explode(" ", $request->header('Authorization'))[1];
                return  response($response, 200);
            } else {
                Seller::where(['FK_user_id' => auth()->user()->id])->update($sellerInfo);
                $response['status'] = true;
                $response['message'] = 'Request Updated.';
                $response['token'] = explode(" ", $request->header('Authorization'))[1];
                return  response($response, 200);
            }
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = (string) $th;
            return  response($response, 400);
        }
    }
    public function updateSellerProfile(Request $request)
    {
        $response = array();
        try {
            if (!auth()->user()) {
                $response['status'] = false;
                $response['message'] = 'Unautherized Access';
                return response($response, 401);
            }
            $validator = Validator::make($request->all(), [
                'business_email'   => 'nullable|email',
                'seller_phone'     => 'nullable|digits:10',
                'city'             => 'nullable|string',
                'state'            => 'nullable|string',
                'zip'              => 'nullable|digits:6',
                'latitude'         => ['nullable', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
                'longitude'        => ['nullable', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
                'owner_name'       => 'nullable|string',
                'business_email'   => 'nullable|email',
                'shop_cover_image' => 'nullable|image|max:10240|mimes:png,jpg,jpeg',
                'shop_logo_url'    => 'nullable|image|max:10240|mimes:png,jpg,jpeg',
                'shop_contact'     => 'nullable|digits:10',
            ]);
            if ($validator->fails()) {
                return response(
                    [
                        'status' => false,
                        'message' => $validator->errors()
                    ],
                    400
                );
            }
            $seller = Seller::where(['FK_user_id' => auth()->user()->id, 'status' => 'Active'])->get()->first();
            $updateDataOfSeller =  array_filter($request->all());
            if ($request->hasFile('shop_cover_image')) {
                if (File::exists($seller['shop_cover_image'])) {
                    unlink($seller['shop_cover_image']);
                }
                $file = $request->file('shop_cover_image');
                $fileName =  Str::uuid() . '.' . $file->getClientOriginalExtension();
                $file->move('upload/cover/', $fileName);
                $updateDataOfSeller['shop_cover_image'] = 'upload/cover/' . $fileName;
            }
            if ($request->hasFile('shop_logo_url')) {
                if (File::exists($seller['shop_logo_url'])) {
                    unlink($seller['shop_logo_url']);
                }
                $file_logo = $request->file('shop_logo_url');
                $fileLogoName =  Str::uuid() . '.' . $file_logo->getClientOriginalExtension();
                $file_logo->move('upload/logo/', $fileLogoName);
                $updateDataOfSeller['shop_logo_url'] = 'upload/logo/' . $fileLogoName;
            }
            $isUpdated = Seller::where(['FK_user_id' => auth()->user()->id, 'status' => 'Active'])->update($updateDataOfSeller);
            if ($isUpdated) {

                $response['status'] = true;
                $response['message'] = 'Profile Updated';
                return  response($response, 200);
            }
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = $th->getMessage();
            return  response($response, 400);
        }
    }
    public function updateSellerInfo(Request $request)
    {
        try {
            if (!auth()->user()) {
                $response['status'] = false;
                $response['message'] = 'Unautherized Access';
                return response($response, 401);
            }
            $validator = Validator::make($request->all(), [
                'owner_name'                 => 'nullable|string',
                'business_email'             => 'nullable|email',
                'shop_cover_image'           => 'nullable|image|max:10240|mimes:png,jpg,jpeg',
                'shop_logo_url'              => 'nullable|image|max:10240|mimes:png,jpg,jpeg',
                'shop_contact'               => 'nullable|digits:10',
                // 'weekly_timing'              => ['required', 'json']
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()], 400);
            }
            $businessInfo =  $request->all();
            $seller = Seller::where(['FK_user_id' => auth()->user()->id, 'status' => 'Active'])->get()->first();
            if ($seller) {
                if ($request->hasFile('shop_cover_image')) {
                    if (File::exists($seller['shop_cover_image'])) {
                        unlink($seller['shop_cover_image']);
                    }
                    $file = $request->file('shop_cover_image');
                    $fileName =  Str::uuid() . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/cover/', $fileName);
                    $businessInfo['shop_cover_image'] = 'upload/cover/' . $fileName;
                } else {
                    $cover_url = Categorydefault::where('cat_id', $seller->FK_category_id)->get()->first()->image;
                    $businessInfo['shop_cover_image'] = $cover_url;
                }
                if ($request->hasFile('shop_logo_url')) {
                    if (File::exists($seller['shop_logo_url'])) {
                        unlink($seller['shop_logo_url']);
                    }
                    $file_logo = $request->file('shop_logo_url');
                    $fileLogoName =  Str::uuid() . '.' . $file_logo->getClientOriginalExtension();
                    $file_logo->move('upload/logo/', $fileLogoName);
                    $businessInfo['shop_logo_url'] = 'upload/logo/' . $fileLogoName;
                }
                if (!$businessInfo['business_email']) unset($businessInfo['business_email']);
                if (!$businessInfo['owner_name']) unset($businessInfo['owner_name']);
                if (!$businessInfo['shop_contact']) unset($businessInfo['shop_contact']);
                Seller::where(['FK_user_id' => auth()->user()->id, 'status' => 'Active'])->update($businessInfo);
                $response['status'] = true;
                $response['message'] = 'Profile Updated.';
                $response['token'] = explode(" ", $request->header('Authorization'))[1];
                return  response($response, 200);
            } else {
                $response['status'] = false;
                $response['message'] = 'Not seller account found';
                $response['token'] = explode(" ", $request->header('Authorization'))[1];
                return  response($response, 400);
            }
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = $th->getMessage();
            return  response($response, 500);
        }
    }

    public function becomeSellerGetRequest(Request $request)
    {
        $response = array();
        try {

            $response['status'] = true;
            $response['message'] = "Seller Details Found.";
            $response['data'] = $this->sellerDataById(auth()->user()->id);
            $response['token'] = explode(" ", $request->header('Authorization'))[1];
            return  response($response, 200);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['error'] = $th->getMessage();
            return  response($response, 500);
        }
    }

    public function AddBussinessInfo(Request $request)
    {

        $response = array();
        try {
            $validator = Validator::make($request->all(), [
                'weekly_timing'              => ['nullable', 'json'],
                'owner_name'                 => 'nullable|string',
                'business_email'             => 'nullable|email',
                'shop_cover_image'           => 'nullable|image|max:10240|mimes:png,jpg,jpeg',
                'shop_logo_url'              => 'nullable|image|max:10240|mimes:png,jpg,jpeg'
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()], 400);
            }
            $businessInfo =  $request->all();
            $seller = Seller::where(['FK_user_id' => auth()->user()->id, 'status' => 'Active'])->get();
            if (count($seller)  == 1) {
                if ($request->hasFile('shop_cover_image')) {
                    $file = $request->file('shop_cover_image');
                    $fileName =  Str::uuid() . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/cover/', $fileName);
                    $businessInfo['shop_cover_image'] = 'upload/cover/' . $fileName;
                } else {

                    $cover_url = Categorydefault::where('cat_id', $seller->first()->FK_category_id)->get()->first()->image;
                    $businessInfo['shop_cover_image'] = $cover_url;
                }
                if ($request->hasFile('shop_logo_url')) {
                    $file_logo = $request->file('shop_logo_url');
                    $fileLogoName =  Str::uuid() . '.' . $file_logo->getClientOriginalExtension();
                    $file_logo->move('upload/logo/', $fileLogoName);
                    $businessInfo['shop_logo_url'] = 'upload/logo/' . $fileLogoName;
                } else {
                    $businessInfo['shop_logo_url'] = '/admin/assets/img/logo.png';
                }
                Seller::where(['FK_user_id' => auth()->user()->id, 'status' => 'Active'])->update($businessInfo);
                $response['status'] = true;
                $response['message'] = 'Profile Updated.';
                $response['token'] = explode(" ", $request->header('Authorization'))[1];
                return  response($response, 200);
            } else {
                $response['status'] = false;
                $response['message'] = 'Your account has Not activated.';
                $response['token'] = explode(" ", $request->header('Authorization'))[1];
                return  response($response, 200);
            }
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = $th->getMessage();
            return  response($response, 500);
        }
    }

    /**
     * Formate the date
     */
    public function getReadAbleDate($date)
    {
        // return 'ggg';
        return  DateTime::createFromFormat('d-F-Y H:i:s', $date);
    }

    /**
     * Get all Sellers list
     */
    public function allSellers(Request $request, $status = 'all', $s = null)
    {
        $response = array();
        $cond = array();
        $state = array();

        try {
            if ($s)
                $cond = ['business_name' => '%' . $s . '%', 'owner_name' => '%' . $s . '%'];

            if ($status == 'Active' || $status == 'Inactive' || $status == 'Reject')
                $state = ['status' => $status];
            $response['status'] = true;
            $response['message'] = 'seller found';
            $response['data'] = $this->allSellerDataByCond($cond, $state);
            return  response($response, 200);
        } catch (\Throwable $th) {
            $response['message'] = $th->getMessage();
            return  response($response, 500);
        }
    }
    /**
     * Get seller data from id
     * @param int $id
     * @return Object
     */
    public function sellerDataById($id)
    {
        $finalData = array();
        $sellerInfo = Seller::with('category', 'user', 'all_offer')->where(['FK_user_id' => $id])->get();
        foreach ($sellerInfo as $seller) {
            $seller['offers'] = sizeof($seller['all_offer']) ? $seller['all_offer'] : null;
            unset($seller->all_offer);
            $seller['created_at'] =  $this->getReadAbleDate($seller['created_at']);
            $seller['updated_at'] =  $this->getReadAbleDate($seller['updated_at']);
            $seller['weekly_timing'] = json_decode($seller['weekly_timing']);
            array_push($finalData, $seller);
        }
        return $finalData;
    }
    /**
     * Get seller data from by searching and status
     * @param Array $cond
     * @param Array $status
     * @return Object
     */
    public function allSellerDataByCond(array $cond, array $status)
    {
        $finalData = array();

        $sellers =   Seller::with('category')->where(function ($query) use ($cond) {
            foreach ($cond as $key => $value) {
                $query->orWhere($key, 'LIKE', $value);
            }
        })->where($status)->get();
        foreach ($sellers as $seller) {
            $seller['weekly_timing'] = json_decode($seller['weekly_timing']);
            array_push($finalData, $seller);
        }
        return $finalData;
    }
    /**
     * Upload file and return file new name
     * @param  Request $request 
     * @param  String $uploadName fieldname
     * @return Array [ Boolean, $filename ] 
     */
    public function uploadDoc($request, $uploadName)
    {
        if ($request->hasFile($uploadName)) {
            $file = $request->file($uploadName);
            $fileName =  Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->move('upload/doc/', $fileName);
            return [true, 'upload/doc/' . $fileName];
        } else {
            return [false];
        }
    }
    public function get($id)
    {
        try {
            $finalData = array();
            $sellerInfo = Seller::with(['category', 'offers'])->where(['id' => $id])->get();
            foreach ($sellerInfo as $seller) {
                $seller['weekly_timing'] = json_decode($seller['weekly_timing']);
                array_push($finalData, $seller);
            }
            $response['status'] = true;
            $response['message'] = 'Seller found';
            $response['data'] = $finalData;
            return response($response, 200);
        } catch (\Throwable $th) {
            // $response['status'] = 'Something Went Wrong.';
            $response['status'] = false;
            $response['message'] = $th->getMessage();
            return response($response, 400);
        }
    }

    // For web

    /**
     * @param Number $id
     * @return array
     */
    public function showSellerInfo($id)
    {
        $seller = Seller::with('user', 'category', 'offers')->where(['id' => $id])->get()[0];
        return ['message' => $seller];
    }


    public function isOpen($id)
    {
        try {
            $seller = Seller::where(['id' => $id])->get(['business_name', "is_open"])->first();
            $response['status'] = true;
            $response['message'] = 'Status found';
            $seller['is_open'] = (int) $seller->is_open;
            $response['data'] = $seller;
            return response($response, 200);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = $th->getMessage();
            return response($response, 400);
        }
    }
    public function isOpenToken(Request $req)
    {
        try {
            if (!auth()->user()) {
                $response['status'] = false;
                $response['message'] = 'Unautherized Access';
                return response($response, 401);
            }
            $seller = Seller::where(['FK_user_id' => auth()->user()->id])->get(['business_name', "is_open"])->first();
            $response['status'] = true;
            $response['message'] = 'Status found';
            $seller['is_open'] = (int) $seller->is_open;
            $response['data'] = $seller;
            return response($response, 200);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = $th->getMessage();
            return response($response, 400);
        }
    }
    public function updateOpenStatus(Request $req)
    {
        try {
            if (!auth()->user()) {
                $response['status'] = false;
                $response['message'] = 'Unautherized Access';
                return response($response, 401);
            }
            $validator = Validator::make($req->all(), [
                'status'                 => ['required', Rule::in([1, 0, '0', '1'])]
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()], 400);
            }
            $changedStatus = (string) $req->status;
            Seller::where(['FK_user_id' => auth()->user()->id])->update(['is_open' => $changedStatus]);
            $seller = Seller::where(['FK_user_id' => auth()->user()->id])->get(['business_name', "is_open"])->first();
            $response['status'] = true;
            $response['message'] = 'Status updated.';
            $seller['is_open'] = (int) $seller->is_open;
            $response['data'] = $seller;
            return response($response, 200);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = $th->getMessage();
            return response($response, 400);
        }
    }
    public function forYou($city = null)
    {
        try {
            if ($city == null) {
                $response['status'] = true;
                $response['message'] = 'Sellers Found';
                $sellers = Seller::with('offers', 'category')->where(['status' => 'Active'])->get();
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

                $response['data'] = $arr;
                return response($response, 200);
            }
            $response['status'] = true;
            $response['message'] = 'Sellers Found';
            $sellers =  Seller::with('offers', 'category')
                ->where('city', 'LIKE', '%' . $city . '%')
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
            $response['data'] = $arr;
            return response($response, 200);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = $th->getMessage();
            return response($response, 400);
        }
    }
    public function forYou2(Request $request)
    {
        try {
            $query = Seller::query()->with('offers', 'category');
            if ($city = $request->city) {
                $query->whereRaw("city LIKE '%" . $city . "%'");
            }
            if ($category = $request->category) {
                $query->whereRaw("FK_category_id = ?", [$category]);
            }
            $perpage = 10;
            $page = $request->page ?? 1;
            $total = $query->count();
            $arr = [];
            $result = $query->offset(($page - 1) * $perpage)->limit($perpage)->get();
            foreach ($result as $oneSeller) {
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
            return [
                'status' => true,
                'data' => $arr,
                'page' => $page,
                'last_page' => ceil($total / $perpage)
            ];
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = $th->getMessage();
            return response($response, 400);
        }
    }
    public function userType(Request $req)
    {
        try {
            if (!auth()->user()) {
                $response['status'] = false;
                $response['message'] = 'Unautherized Access';
                return response($response, 401);
            }
            $isSeller = auth()->user()->code == 'seller' ? true : false;
            return response([
                'status' => true,
                'message' => 'User type found!',
                'is_seller' => $isSeller,
                'code' => auth()->user()->code
            ], 200);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = $th->getMessage();
            return response($response, 401);
        }
    }
    public function offer_priority($offer_id)
    {
        $offer = Offer::where('id', $offer_id)->first();
        if(!$offer){
            $response['status'] = false;
            $response['message'] = 'Offer Not found';
            return response($response, 400);
        }
        $offer->offer_priority = $offer->offer_priority ? 0 : 1;
        $offer->update();

        $response['status'] = false;
        $response['message'] = 'Offer priority updated';
        return response($response, 200);
    }
}

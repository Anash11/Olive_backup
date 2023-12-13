<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\Notification;
use App\Models\Seller;
use App\Models\User;
use DateTime;
use Dotenv\Validator as DotenvValidator;
use Illuminate\Http\Request;
use StatusMessages as message;
use Validator;
use Illuminate\Support\Str;

class SellerController extends Controller
{

    public function becomeSeller(Request $request)
    {
        $response = array();
        try {
            $validator = Validator::make($request->all(), [
                'document'      =>  'required|image|max:10240',
                'business_name' =>  'required|string',
                'business_email' => 'required|email',
                'seller_phone'  =>  'required|digits:10',
                'category'      =>  'required|numeric',
                'city'          => 'required|string',
                'state'         => 'required|string',
                'area'          => 'string',
                'zip'           => 'required|digits:6',
                'latitude'      => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
                'longitude'     => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/']
            ]);
            if ($validator->fails()) {
                return back()->with(
                    [
                        'status' => false,
                        'message' => $validator->errors()
                    ],
                    400
                );
            }
            // $seller = Seller::where(['FK_user_id' => auth()->user()->id, 'status' => 'Inactive'])->get();

            // if (count($seller)) {
            //     $response['status'] = 'Account Already Activated. Please Complete Your Business Profile.';
            //     $response['token'] = explode(" ", $request->header('Authorization'))[1];
            //     return  response($response, 201);
            // }
            $activeSeller = Seller::where(['FK_user_id' => auth()->user()->id, 'status' => 'Active'])->get()->count();

            if ($activeSeller) {
                $response['status'] = true;
                $response['message'] = 'Account Already Activated. Please Complete Your Business Profile.';
                $response['token'] = explode(" ", $request->header('Authorization'))[1];
                return  response($response, 201);
            }
            $updoc = $this->uploadDoc($request, 'document');
            if (!$updoc[0]) {
                $response['status'] = false;
                $response['messsage'] = 'File not found';
                return response($response, 401);
            }

            $sellerInfo = [
                'business_name'     => $request['business_name'],
                'document_img_url'  => $updoc[1],
                'business_email'    => $request['business_email'],
                'business_phone'    => $request['seller_phone'],
                'latitude'          => $request['latitude'],
                'longitude'         => $request['longitude'],
                'FK_category_id'    => $request['category'],
                'city'              => $request['city'],
                'area'              => $request['area'],
                'state'             => $request['state'],
                'zip'               => $request['zip'],
                'FK_user_id'        => auth()->user()->id,
                'weekly_timing'     => '{"MON": {"is_open":true,"open": "10AM","close":"8PM"} ,"TUES":{"is_open":true,"open":"10AM","close":"8PM"},"WED":{"is_open":true,"open":"10AM","close":"8PM"},"THUS":{"is_open":true,"open":"10AM","close":"8PM"},"FRI":{"is_open":true,"open":"10AM","close":"8PM"},"SAT":{"is_open":true,"open":"10AM","close":"8PM"},"SUN":{"is_open":false,"open":"","close":""}}'
            ];
            $activeSeller = Seller::where(['FK_user_id' => auth()->user()->id, 'status' => 'Active'])->get()->count();
            $seller = Seller::where(['FK_user_id' => auth()->user()->id, 'status' => 'Inactive'])->get();
            if ($activeSeller) {
                $response['status'] = true;
                $response['message'] = 'Account Already Activated. Please Complete Your Business Profile.';
                $response['token'] = explode(" ", $request->header('Authorization'))[1];
                return  response($response, 201);
            }
            if (count($seller)  == 0) {
                User::where('id', auth()->user()->id)->update(['code' => 'seller']);
                Seller::create($sellerInfo);
                Notification::create(["notification_type" => "sellers", "message" => "Please Verify <b>Seller: " . $seller['business_name'] . "</b>."]);
                $response['status'] = true;
                $response['message'] = 'Our Team Will Contact You to Verify Your Request.';
                $response['token'] = explode(" ", $request->header('Authorization'))[1];
                return  response($response, 201);
            } else {
                User::where('id', auth()->user()->id)->update(['code' => 'seller']);
                Seller::where(['FK_user_id' => auth()->user()->id])->update($sellerInfo);
                $response['status'] = true;
                $response['message'] = 'Request Updated.';
                $response['token'] = explode(" ", $request->header('Authorization'))[1];
                return  response($response, 201);
            }
        } catch (\Throwable $th) {
            $response['status'] = true;
            $response['message'] = $th->getMessage();
            return  response($response, 400);
        }
    }

    public function becomeSellerGetRequest(Request $request)
    {
        $response = array();
        try {

            $response['data'] = $this->sellerDataById(auth()->user()->id);
            $response['token'] = explode(" ", $request->header('Authorization'))[1];
            return  response($response, 200);
        } catch (\Throwable $th) {
            $response['error'] = $th->getMessage();
            return  response($response, 500);
        }
    }

    public function AddBussinessInfo(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'owner_name'                 => 'required|string',
                'shop_cover_image'           => 'required|image|max:10240|mimes:png,jpg,jpeg',
                'shop_logo_url'              => 'required|image|max:10240|mimes:png,jpg,jpeg',
                'shop_contact'               => 'required|digits:10|unique:sellers',
                'weekly_timing'              => ['required', 'json'],
                /***
                'weekly_timing.MON.is_open'  => 'required|boolean',
                'weekly_timing.TUES'         => 'required|json',
                'weekly_timing.TUES.is_open' => 'required|boolean',
                'weekly_timing.WED'          => 'required|json',
                'weekly_timing.WED.is_open'  => 'required|boolean',
                'weekly_timing.THUS'         => 'required|json',
                'weekly_timing.THUS.is_open' => 'required|boolean',
                'weekly_timing.FRI'          => 'required|json',
                'weekly_timing.FRI.is_open'  => 'required|boolean',
                'weekly_timing.SAT'          => 'required|json',
                'weekly_timing.SAT.is_open'  => 'required|boolean',
                'weekly_timing.SUN'          => 'required|json',
                'weekly_timing.SUN.is_open'  => 'required|boolean',
             */
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
                }
                if ($request->hasFile('shop_logo_url')) {
                    $file_logo = $request->file('shop_logo_url');
                    $fileLogoName =  Str::uuid() . '.' . $file_logo->getClientOriginalExtension();
                    $file_logo->move('upload/logo/', $fileLogoName);
                    $businessInfo['shop_logo_url'] = 'upload/logo/' . $fileLogoName;
                }
                Seller::where(['FK_user_id' => auth()->user()->id, 'status' => 'Active'])->update($businessInfo);
                $response['status'] = true;
                $response['message'] = 'Profile Updated.';
                $response['token'] = explode(" ", $request->header('Authorization'))[1];
                return  response($response, 201);
            } else {
                $response['status'] = false;
                $response['message'] = 'Your account has Not activated.';
                $response['token'] = explode(" ", $request->header('Authorization'))[1];
                return  response($response, 201);
            }
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = "Something went Wrong";
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
        $sellerInfo = Seller::with('category', 'user')->where(['FK_user_id' => $id])->get();
        foreach ($sellerInfo as $seller) {
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
            $sellerInfo = Seller::with('category', 'offers')->where(['id' => $id])->get();
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
            $response['status'] = $th->getMessage();
            return response($response, 400);
        }
    }

    // For web

    public function index()
    {
        $sellers = Seller::with('user', 'category')->orderBy('id', 'DESC')->get();
        return view('seller.sellers', compact('sellers'));
    }
    /**
     * @param Number $id
     * @return array
     */
    public function showSellerInfo($id)
    {
        $seller = Seller::with('user', 'category', 'offers')->where(['id' => $id])->get()[0];
        return ['message' => $seller];
    }
    public function showEditSeller($id)
    {
        $seller = Seller::with('user')->where('id', $id)->get()->first();
        return view('seller/edit-seller', compact('seller'));
    }
    public function editSeller(Request $req)
    {

        $validatedData = $req->validate([
            'business_name' =>  'required|string',
            'owner_name' =>  'required|string',
            'business_email' => 'required|email',
            'business_phone'  =>  'required|digits:10',
            'shop_contact'  =>  'required|digits:10',
            'city'          => 'required|string',
            'state'         => 'required|string',
            'area'          => 'nullable|string',
            'address'       => 'nullable|string',
            'zip'           => 'required|digits:6',
            'latitude'         => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'longitude'        => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/']
        ]);
        Seller::where('id', $req->id)->update($req->all('business_name', 'owner_name', 'business_email', 'business_phone', 'shop_contact', 'address', 'city', 'state', 'area', 'zip'));
        return back()->with('success', 'Seller Updated');
    }
    public function updateStatus(Request $req)
    {

        $validatedData = $req->validate([
            'id'               => 'required|numeric',
            'status'           => 'required|string',
        ]);
        $userId = Seller::where('id', $req->id)->get('FK_user_id')->first()->FK_user_id;
        $code =  $req->status == 'Active' ? 'seller' : 'user';
        User::where('id', $userId)->update(['code' => $code]);
        Seller::where('id', $req->id)->update(['status' => $req->status]);
        return redirect('sellers')->with('success', 'Status Updated');
    }
    public function addSellershow()
    {
        return view('seller.add-seller');
    }
    public function addSeller(Request $req)
    {
        // $req->validate([
        //     'bname' => 'required',
        //     'oname' => 'required',
        //     'adhar_no' => 'required|min:12|max:12',
        //     'phone_no' => 'required|min:10|max:10',
        //     'phone_no2' => 'required|min:10|max:10',
        //     'email' => 'required|email',
        //     'oname' => 'required',
        //     'oname' => 'required',
        //     'oname' => 'required',
        //     'oname' => 'required',
        //     'oname' => 'required',
        //     'oname' => 'required',
        //     'oname' => 'required'
        // ]);
    }
    public function createSellerUserProfile(Request $req)
    {
        // dd($req->all());
        $req->validate([
            'category'         =>  'required|numeric',
            'document'         =>  'required|image|max:10240',
            'business_name'    =>  'required|string',
            'owner_name'       =>  'required|string',
            'business_email'   =>  'required|email',
            'shop_cover_image' =>  'required|image|max:10240',
            'shop_logo'        =>  'required|image|max:10240',
            'personal_phone'   =>  'required|digits:10|unique:users,phone',
            'category'         =>  'required|numeric',
            'city'             =>  'required|string',
            'state'            =>  'required|string',
            'status'           => 'required|string',
            'address'          =>  'string|required',
            'zip'              => 'required|digits:6',
            'latitude'         => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'longitude'        => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/']
        ]);
        $upSellerDoc = $this->uploadImage($req, 'document');
        if (!$upSellerDoc[0]) {
            dd('Somthing went wrong1');
        }
        $upShopCover = $this->uploadImage($req, 'shop_cover_image', 'upload/cover/');
        if (!$upShopCover[0]) {
            dd('Somthing went wrong2');
        }
        $upShopLogo = $this->uploadImage($req, 'shop_logo', 'upload/logo/');
        if (!$upShopLogo[0]) {
            dd('Somthing went wrong3');
        }
        $userTableData = [
            'name'          => $req->owner_name,
            'phone'         => $req->personal_phone,
            'email'         => $req->personal_email,
            'pincode'       => $req->zip,
            'city'          => $req->city,
            'status'        => 1,
            'otp'           => 123456,
            'state'         => $req->state,
            'code'          => 'seller',
            'address_info'  => $req->owner_name,
        ];
        $createdUserId = User::create($userTableData)->id;


        $sellerData = [
            'FK_user_id'       => $createdUserId,
            'FK_category_id'   => $req->category,
            'business_name'    => $req->business_name,
            'document_img_url' => $upSellerDoc[1],
            'owner_name'       => $req->owner_name,
            'business_email'   => $req->business_email,
            'shop_cover_image' => $upShopCover[1],
            'shop_logo_url'    => $upShopLogo[1],
            'business_phone'     => $req->phone1,
            'shop_contact'     => $req->phone2,
            'category'         => $req->category,
            'zip'              => $req->zip,
            'city'             => $req->city,
            'state'            => $req->state,
            'status'           => $req->status,
            'address'          => $req->address,
            'latitude'         => $req->latitude,
            'longitude'        => $req->longitude
        ];
        $isSellerAdded = Seller::create($sellerData);

        return redirect('sellers')->with('success', 'Seller Added successfully');
    }
    public function uploadImage($request, $uploadName, $path = 'upload/files/')
    {

        if ($request->hasFile($uploadName)) {
            $file = $request->file($uploadName);
            $fileName =  Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $fileName);
            return [true, $path . $fileName];
        } else {
            return [false];
        }
    }
}

<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Category;
use App\Models\FavouriteSeller;
use App\Models\FavSellersOffer;
use App\Models\Seller;
use App\Models\User;
use Auth;
use Cookie;
use DB;

class AdminController extends Controller
{

    public function index()
    {
        if (Session()->has('loginId')) {
            $admin = Admin::where('email', '=', session('loginId'))->first();

            //    $data = [
            //         'loginId' => $admin
            //    ];
            return view('layouts.header', $data);
        }
    }

    // public function dashboard()
    // {
    //     $category = Category::all();
    //     $seller = Seller::all();
    //     $users = User::orderBy('created_at', 'DESC')
    //         ->take(7)->get();
    //     // dd($allcategory);

    //     return view('dashboard', compact('category', 'seller', 'users'));
    // }

    // Show Admins
    public function showAdmin()
    {
        $admin_data = Admin::where('email', '=', session('loginId'))->first();

        if (!($admin_data->admin_type == 'super-admin' && $admin_data->status == 1)) {
            return back();
        } else {
            $admins = Admin::orderBy('created_at', 'desc')->where('admin_type', 'admin')->get();
            return view('admins.admins', compact('admins', 'admin_data'));
        }
    }

    public function showAdminData($id)
    {
        $admin = Admin::where('id', $id)->get();
        return response()->json($admin, 200);
    }

    // Create New Admin
    public function addAdmin(Request $request)
    {
        // dd($request->all());
        $validateDate = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:admins'],
            'phone_no' => ['required', 'string', 'min:10'],
            'state' => ['required', 'string'],
            'city' => ['required', 'string'],
            'adhar_no' => ['required', 'string', 'min:12', 'max:12'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        $data = new Admin();

        $data->name = $request->username;
        $data->email = $request->email;
        $data->phone_no = $request->phone_no;
        $data->admin_type = $request->admin_type;
        $data->adhar_no = $request->adhar_no;
        $data->state = $request->state;
        $data->city = $request->city;
        $data->dob = date('Y-m-d H:i:s', strtotime($request->dob));
        $data->area_of_operation = $request->area_oper;
        $data->password = Hash::make($request->password);

        // dd($data);
        $data->save();

        return redirect('admins')->with('success', 'New Admin Created.');
    }


    public function showEditAdmin($id)
    {
        $data = Admin::where('id', $id)->first();
        return view('admins.edit-admin', compact('data'));
    }

    // Edit Admin
    public function editAdmin(Request $request, $id)
    {
        $validateDate = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255',],
            'phone_no' => ['required', 'string', 'min:10'],
            'state' => ['required', 'string'],
            'city' => ['required', 'string'],
            'adhar' => ['required', 'string', 'min:12', 'max:12'],
        ]);

        $data = Admin::where('id', $id)->first();
        $data->name = $request->username;
        $data->email = $request->email;
        $data->phone_no = $request->phone_no;
        $data->admin_type = $request->admin_type;
        $data->adhar_no = $request->adhar;
        $data->state = $request->state;
        $data->city = $request->city;
        $data->status = $request->status;
        $data->dob = date('Y-m-d H:i:s', strtotime($request->dob));
        $data->area_of_operation = $request->area_oper;

        $data->save();
        notify()->success("Success notification test", "Success", "topRight");
        return redirect('admins')->with('status', 'New Admin Created.');
    }

    // Delete Admin
    public function deleteAdmin($id)
    {
        $data = Admin::find($id);
        // Alert::success('Congrats', 'You\'ve Successfully Registered');
        // dd($data);
        $data->delete();
        return redirect('admins');
    }
    // Logout
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
    public function updateAdminStatus(Request $req)
    {
        return ['status' => Admin::where('id', $req->id)->update(['status' => $req->status])];
    }

    public function login(Request $req)
    {
        $credentials  = $this->validate($req, [
            'username'  => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $admin = Admin::where('email', $req->username)->first();
        $remember_me = $req->has('remember') ? true : false;
        if ($req->has('remember')) {
            Cookie::queue('username', $req->username, 1440);
            Cookie::queue('password', $req->password, 1440);
        }

        if ($admin && Hash::check($req->password, $admin->password) || $remember_me) {
            if ($admin->status) {
                $req->session()->put('loginId', $admin->email);
                return redirect('/dashboard');
            }
            return back()->with('status', 'You are not verified by Super-admin.');
        } else {
            return back()->with('status', 'Please enter correct email and password.');
        }
    }
    public function showProfile()
    {
        $admin = Admin::where('email', '=', session('loginId'))->first();
        return view('admins.profile', compact('admin'));
    }
    public function updateProfile(Request $req)
    {
        $validate = $req->validate([
            'name' => 'required',
            'phone_no' => 'required|min:10|max:10',
            'city' => 'required',
            'state' => 'required',
            'address_info' => 'required',
        ]);

        if (!$validate) {
            return redirect('profile')->with('failed', 'Something went wrong');
        }

        $data = Admin::where('id', $req->id)->first();
        $data->name = $req->name;
        $data->phone_no = $req->phone_no;
        $data->city = $req->city;
        $data->state = $req->state;
        $data->address_info = $req->address_info;

        $data->update();
        return redirect('profile')->with('success', 'Profile updated successfully');
    }


    function updatePassword(Request $req)
    {
        $admin = Admin::where('email', $req->email)->first();
        // dd(Hash::check($req->current_password, $admin->password));
        $validatedData = $req->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|min:8|same:new_password'
        ]);

        if (!($admin && Hash::check($req->current_password, $admin->password))) {
            return redirect('profile')->with("failed", "Your current password does not matches with the password you provided. Please try again.");
        }

        if (strcmp($req->get('current_password'), $req->get('new_password')) == 0) {
            return redirect('profile')->with("failed", "New Password cannot be same as your current password. Please choose a different password.");
        }

        //Change Password
        $admin->password = Hash::make($req->new_password);
        $admin->update();

        return redirect('profile')->with("success", "Password changed successfully !");
    }

    public function offersPage()
    {
        $offers = Offer::with('seller')->orderBy('id', 'DESC')->get();
        return view('offers.offers', compact('offers'));
    }

    public function updateOfferStatus(Request $req)
    {
        if ($req->status == 'Active') {
            $offer = Offer::with('seller')->where('id', $req->id)->get()->first();
            $sellerId = $offer->seller->id;
            $offerId = $req->id;
            $message = "Offer '" . $offer->offer_type . "' is added by " . $offer->seller->business_name;
            $favList = FavouriteSeller::where('seller_id', $sellerId)->get();
            foreach ($favList as $fav) {
                FavSellersOffer::create([
                    'FK_user_id' => $fav->user_id,
                    'FK_offer_id' => $offerId,
                    'message' => $message,
                ]);
            }
        }
        return ['status' => Offer::where('id', $req->id)->update(['offer_status' => $req->status])];
    }

    public function showOffer($id)
    {
        return ['status' => true, 'data' => Offer::with('seller')->where('id', $id)->get()[0]];
    }

    public function showEditOffer($id)
    {
        $offer = Offer::with('seller')->where('id', $id)->get()->first();
        return view('offers/edit-offer', compact('offer'));
    }
    public function editOffer(Request $req)
    {

        $validatedData = $req->validate([
            'id' => 'required|numeric',
            'offer_title' => 'required|string',
            'offer_type' => 'required|string',
            'offer_description' => 'string',
            'offer_priority' => 'required'
        ]);
        Offer::where(['id' => $req->id])->update($req->all('offer_title', 'offer_type', 'offer_description', 'offer_priority'));
        return redirect('offers')->with('success', 'Offer updated successfully');
    }
    public function dropExpire(Request $req)
    {
        $count = DB::statement('select count(*) from offers where offer_end_date < CURDATE()');
        DB::statement('delete from offers where offer_end_date < CURDATE()');
        return redirect('offers')->with('success', $count . ' Expired Offer Deleted Successfully');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function Symfony\Component\String\b;

class LoginController extends Controller
{

    public function login(Request $req)
    {
        $this->validate($req, [
            'username'  => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $admin = Admin::where('email', $req->username)->first();

        if ($admin && Hash::check($req->password, $admin->password)) {
            if ($admin->status && $admin->admin_type == 'super-admin') {
                $req->session()->put('loginId', $admin->name);
                return redirect('/dashboard');
            }
            elseif($admin->status && $admin->admin_type == 'admin'){
                $req->session()->put('NormalAdminId', $admin->name);
                return redirect('/dashboard');
            }
            else{
                return back()->with('status', 'You are not verified by Super-admin.');
            }
        } else {
            return back()->with('status', 'Please enter correct email and password.');
        }
    }
    public function logout()
    {
        if(session()->has('loginId'))
        {
            session()->pull('loginId');
            return redirect('login');
        }
    }
}

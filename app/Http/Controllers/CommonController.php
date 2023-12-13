<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use App\Models\Category;
use App\Models\Seller;
use App\Models\Offer;
use App\Models\Notification;


class CommonController extends Controller
{
    public function dashboard()
    {
        $category = Category::all();
        $seller = Seller::all();
        $userall = User::all();
        $offers = Offer::all();
        $users = User::orderBy('created_at', 'DESC')
            ->take(7)->get();
        $notifications = Notification::orderBy('created_at', 'DESC')
        ->take(5)->get();
        // dd($notifications);

        return view('dashboard', compact('category', 'seller', 'users', 'userall', 'offers', 'notifications'));
    }
}

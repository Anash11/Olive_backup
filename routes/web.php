<?php

use App\Http\Controllers\admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategorydefaultController;


// use App\ForgotPasswordController;
// use App\Http\Controllers\ForgotPasswordController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return view('welcome');
});



Route::get('/login', function () {
    return view('auth.login');
})->middleware('LoggedIn');

Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');



Route::group(['middleware' => 'isLogged'], function () {
    // Notification
    Route::get('/show-notification', [NotificationController::class, 'showSomeNotification']);
    Route::get('/show-all-notification/{sort?}', [NotificationController::class, 'getAll']);
    Route::post('/update-notification-status', [NotificationController::class, 'seen']);
    Route::group(['prefix' => 'notifications'], function () {
        Route::get('/{note?}/{count?}', function ($note = 'Seller', $count = 10) {
            return view('notifications', compact('note', 'count'));
        });
        Route::get('get/{note?}/{count?}', [NotificationController::class, 'notificationPage']);
    });

    // All logged route
    Route::get('/layouts', [AdminController::class, 'index']);
    Route::get('/dashboard', [CommonController::class, 'dashboard']);
    Route::get('/admins', [AdminController::class, 'showAdmin']);
    Route::get('/admindata/{id}', [AdminController::class, 'showAdminData'])->name('admindata');

    // Update admin status
    Route::post('/update-admin-status', [AdminController::class, 'updateAdminStatus']);
    // Add admin
    Route::get('/addadmin', function () {
        return view('admins.add-admin');
    });
    Route::post('/addadmin', [AdminController::class, 'addAdmin']);
    // Edit Admin
    Route::get('/editadmin/{id}', [AdminController::class, 'showEditAdmin']);
    Route::post('/editadmin/{id}', [AdminController::class, 'editAdmin']);
    // Delete Admin
    Route::get('/deleteadmin/{id}', [AdminController::class, 'deleteAdmin']);

    // Categoty Routes
    Route::get('/categories', [CategoryController::class, 'showCategory']);
    // Add Category
    Route::get('/addcategory', function () {
        return view('category.add-category');
    });
    Route::post('/addcategory', [CategoryController::class, 'addCategory']);
    Route::get('/editcategory/{id}', [CategoryController::class, 'editCategory']);
    Route::post('/updatecategory', [CategoryController::class, 'updateCategory']);
    Route::get('/deletecategory/{id}', [CategoryController::class, 'deleteCategory']);

    Route::get('/category/status/{id}', [CategoryController::class, 'Status']);
    Route::post('/category/status/update', [CategoryController::class, 'updateStatus'])->name('update.category.status');

    Route::get('/category/default/add', [CategorydefaultController::class, 'index']);
    Route::post('/adddefaultimg', [CategorydefaultController::class, 'create']);
    Route::get('/category/default/all/{cat_id}', [CategorydefaultController::class, 'getAll']);
    Route::get('/category/default/delete/{cat_id}', [CategorydefaultController::class, 'delete']);
    Route::post('/category/default/update', [CategorydefaultController::class, 'defaultImageUpdate'])->name('category.default.update');


    Route::get('/profile', [AdminController::class, 'showProfile']);
    Route::post('/updateprofile', [AdminController::class, 'updateProfile']);
    Route::post('/updatepassword', [AdminController::class, 'updatePassword']);

    // Users
    Route::get('/users', [UserController::class, 'allUser']);
    Route::get('/edituser/{id}', [UserController::class, 'editStatus']);
    Route::post('/updateuser', [UserController::class, 'updateStatus']);


    Route::get('/offers', [AdminController::class, 'offersPage'])->name('all.offers');
    Route::post('/update-offer-status', [AdminController::class, 'updateOfferStatus']);
    Route::get('/offer/{id}', [AdminController::class, 'showOffer']);
    Route::get('/edit-offer/{id}', [AdminController::class, 'showEditOffer']);
    Route::post('/edit-offer', [AdminController::class, 'editOffer']);
    Route::get('/drop-expire-offer', [AdminController::class, 'dropExpire']);   

    // seller
    // -----------working-------------//
    Route::get('sellers', [SellerController::class, 'index']);
    Route::get('/seller/{id}', [SellerController::class, 'showSellerInfo']);
    Route::get('/edit-seller/{id}', [SellerController::class, 'showEditSeller']);
    Route::post('/edit-seller', [SellerController::class, 'editSeller']);
    Route::post('/edit-seller-status', [SellerController::class, 'updateStatus']);
    // -------------Add seller from dashboard part----------------//
    Route::get('addseller', [SellerController::class, 'addSellershow']);
    Route::post('create-seller-user-profile', [SellerController::class, 'createSellerUserProfile']);
    Route::post('updateseller', [SellerController::class, 'updateSeller']);
    Route::get('deleteseller', [SellerController::class, 'deleteSeller']);

    // Banners
    Route::get('banners', [BannerController::class, 'index']);
    Route::get('addbanner', [BannerController::class, 'ShowaddBanner']);
    Route::post('addbanner', [BannerController::class, 'addBanner']);
    Route::get('editbanner/{id}', [BannerController::class, 'editBanner']);
    Route::post('updatebanner', [BannerController::class, 'updateBanner']);
    Route::get('deletebanner/{id}', [BannerController::class, 'delete']);

    // App Setting
    Route::get('/appsettings', [SettingController::class, 'appsettings']);
    Route::post('/updatesetting', [SettingController::class, 'updatesetting']);

    // FAQ's
    Route::group(['prefix' => 'faq'], function () {
        Route::get('/', [FaqController::class, 'index']);
        Route::get('/add', [FaqController::class, 'add']);
        Route::post('/store', [FaqController::class, 'store']);
        Route::get('/edit/{id}', [FaqController::class, 'edit']);
        Route::post('/update', [FaqController::class, 'update']);
        Route::get('/delete/{id}', [FaqController::class, 'delete']);
    });
});
Route::get('/privacy-policy', function () {
    return view('privacy_policy');
});

Route::get('/terms-conditions', function () {
    return view('terms_conditions');
});

Route::post('/login', [AdminController::class, 'login'])->name('login');

Route::post('/register', [AdminController::class, 'register'])->name('register');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', [CommonController::class, 'index'])->name('dashboard');
});

//logged out
Route::get('/logout', [LoginController::class, 'logout']);


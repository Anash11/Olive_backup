<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\AuthAPIController;
use App\Http\Controllers\Api\v1\CategoryAPIController;
use App\Http\Controllers\Api\v1\OfferAPIController;
use App\Http\Controllers\Api\v1\SearchAPIController;
use App\Http\Controllers\Api\v1\SellerAPIController;
use App\Http\Controllers\Api\v1\UserAPIController;
use App\Http\Controllers\Api\v1\BannerController;
use App\Http\Controllers\Api\v1\SettingController;
use App\Http\Controllers\Api\v1\ReviewController;
use App\Http\Controllers\Api\v1\FavouriteSellerController;
use App\Http\Controllers\Api\v1\FaqController;
use App\Http\Controllers\Api\v1\QRController;
use App\Http\Controllers\Api\v1\RewardController;
use App\Http\Controllers\Api\v1\ScanController;
use App\Http\Controllers\Api\v1\VoucherController;
use App\Http\Controllers\PushController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// V1 apis
Route::group(['prefix' => '/v1', 'middleware' => 'api',], function () {


    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', [AuthAPIController::class, 'login']);
        Route::post('/register', [AuthAPIController::class, 'register']);
        Route::post('/logout', [AuthAPIController::class, 'logout']);
        Route::post('/refresh', [AuthAPIController::class, 'refresh']);
        Route::post('/verify-otp', [AuthAPIController::class, 'verifyOtp']);
        Route::get('/user-profile', [AuthAPIController::class, 'userProfile']);
    });


    Route::group(['prefix' => 'user'], function () {
        Route::post('/add-info', [UserAPIController::class, 'addNameEmail']);
        Route::post('/update-info', [UserAPIController::class, 'addNameEmail']);
        // User Routes
        Route::delete('/delete', [UserAPIController::class, 'userDelete']);
    });
    Route::get('/user/user-status', [SellerAPIController::class, 'userType']);
    Route::group(['prefix' => 'seller'], function () {
        Route::post('/become-seller', [SellerAPIController::class, 'becomeSeller']); // Step 1
        Route::post('/bussiness-info/add', [SellerAPIController::class, 'AddBussinessInfo']); // Step 2
        Route::get('/profile', [SellerAPIController::class, 'becomeSellerGetRequest']);
        Route::get('/{id?}', [SellerAPIController::class, 'get']);
        Route::put('offer-priority/{id}', [SellerAPIController::class, 'offer_priority']);
        // Bussiness Info
        Route::post('/bussiness-info/update', [SellerAPIController::class, 'updateSellerInfo']);


        // Update Bussiness Info
        Route::post('/update-seller-all-info', [SellerAPIController::class, 'updateSellerProfile']);


        // Shop open or close
        Route::get('/is_open/{id}', [SellerAPIController::class, 'isOpen']);
        Route::get('shop/is_open', [SellerAPIController::class, 'isOpenToken']);
        Route::post('/is_open', [SellerAPIController::class, 'updateOpenStatus']);
    });

    Route::group(['prefix' => 'sellers'], function () {
        Route::get('/list/{state?}/search/{s?}', [SellerAPIController::class, 'allSellers']);
    });

    Route::group(
        ['prefix' => 'offers'],
        function () {
            Route::get('/offer-template-list', [OfferAPIController::class, 'offerTempalteList']);
            Route::post('/add', [OfferAPIController::class, 'add']);
            Route::get('delete/{offer_id}', [OfferAPIController::class, 'destroy']);
            // Offers History
            Route::get('/offer-history', [QRController::class, 'offerHistory']);
        }
    );

    Route::group(['prefix' => 'category'], function () {
        Route::get('/all', [CategoryAPIController::class, 'categoryList']);
        Route::get('/get-seller/{id}', [CategoryAPIController::class, 'sellerByCategory']);
    });
    // Voucher API's 
    Route::group(['prefix' => 'voucher'], function () {
        Route::post('/add', [VoucherController::class, 'create']);
        Route::get('/get/{amount}/{shopId}', [VoucherController::class, 'get']);
        Route::post('/update-status', [VoucherController::class, 'changeStatus']);
        Route::get('/all', [VoucherController::class, 'allVouchers']);
        Route::get('/{id}', [VoucherController::class, 'oneVouchers']);
        Route::get('/delete/{id}', [VoucherController::class, 'deleteVoucher']);
        Route::post('/edit', [VoucherController::class, 'update']);
    });

    // Rewards API's 
    Route::group(['prefix' => 'reward'], function () {
        // Route::post('/change-status', [RewardController::class, 'create']);
        Route::get('/all', [RewardController::class, 'allRewards']);
        // Route::post('/update-status', [VoucherController::class, 'changeStatus']);
    });

    Route::group(
        ['prefix' => 'search'],
        function () {
            Route::get('/seller', [SearchAPIController::class, 'searchSeller']);
        }
    );
    Route::group(['prefix' => 'feed'], function () {
        Route::get('/all', [CategoryAPIController::class, 'categoryList']);
        Route::get('/by-city/{city?}', [CategoryAPIController::class, 'feedByCity']);
        Route::get('/for-you/{city?}', [SellerAPIController::class, 'forYou']);
        Route::get('/for-you-new', [SellerAPIController::class, 'forYou2']);
    });

    Route::group(['prefix' => 'review'], function () {
        Route::post('/store', [ReviewController::class, 'create']);
        Route::get('/show/{seller_id}', [ReviewController::class, 'show']);
        Route::get('/review-avrg/{seller_id}', [ReviewController::class, 'showAvrg']);
    });
    Route::get('/favseller/all', [FavouriteSellerController::class, 'allFav'])->name('All_FavSellers');
    Route::group(['prefix' => 'favseller'], function () {
        Route::post('/add', [FavouriteSellerController::class, 'addToMyFav'])->name('Add_FavSellers');
        Route::post('/destroy', [FavouriteSellerController::class, 'removeToFav']);
        Route::get('/offer', [FavouriteSellerController::class, 'offersFromShop']);
    });
    Route::get('/faqs', [FaqController::class, 'getFaq']);

    Route::get('/banners', [BannerController::class, 'getBanner']);
    Route::get('/banners/get-seller-by-id', [BannerController::class, 'getBanner']);
    Route::group(['prefix' => 'nearby'], function () {
        Route::get('/shopes', [SearchAPIController::class, 'findSellerNear']);
        // Route::get('/by-city/{city?}', [CategoryAPIController::class, 'feedByCity']);
    });
    Route::get('/setting/{title?}', [SettingController::class, 'getSetting']);
    Route::group(['prefix' => 'qr'], function () {
        Route::get('/{id?}', [QRController::class, 'getQR']);
        Route::post('/{id?}', [QRController::class, 'voucher']);
        // Route::post('/{id?}', [QRController::class, 'postQR']);
    });
    Route::group(['prefix' => 'scans'], function () {
        Route::get('/all', [ScanController::class, 'all']);
    });
    Route::group(['prefix' => 'user'], function () {
        Route::get('/notifications', [FavouriteSellerController::class, 'offerNotification']);
        Route::post('/update-notification', [FavouriteSellerController::class, 'offerUpdateNotificationStatus']);
    });
    Route::group(['prefix' => 'send-notification'], function () {
        Route::post('/notifications', [PushController::class, 'sendNotification']);
    });
});

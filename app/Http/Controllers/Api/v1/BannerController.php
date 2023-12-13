<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    public function getBanner()
    {
        try {
            $banner = Banner::where('status', 1)->get();
            $response['status'] = true;
            $response['messaage'] = "banners found";
            $response['data'] = $banner;
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response['status'] = false;
            $response['error'] = $e->getMessage();
            return response($response, 400);
        }
    }
}

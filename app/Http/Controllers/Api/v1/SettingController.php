<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppSetting;


class SettingController extends Controller
{
    public function getSetting($title = null)
    {
        try {
            $data = $title ?
                AppSetting::where('title', $title)
                ->where('status', 1)
                ->first()
                : AppSetting::where('status', 1)->get();
            $response['status'] = true;
            $response['message'] = "setting found";
            $response['data'] = $data;
            return  response()->json($response, 200);
        } catch (\Exception $e) {
            $response['status'] = true;
            $response['message'] = $e->getMessage();
            return response($response, 400);
        }
    }
}

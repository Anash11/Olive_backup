<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppSetting;

class SettingController extends Controller
{
    public function appsettings()
    {
        $privacy = AppSetting::where('title','privacy_policy')->first();
        $tnc = AppSetting::where('title','terms_conditions')->first();
        $about = AppSetting::where('title','about')->first();
        $play = AppSetting::where('title','play_url')->first();
        $ios = AppSetting::where('title','ios_url')->first();
        $app_qr = AppSetting::where('title','app_qr_code')->first();
        return view('general-setting', compact('privacy','tnc','about','play','ios', 'app_qr'));
    }
    public function updatesetting(Request $request)
    {  
        $data = AppSetting::where('id',$request->id)->first();
        
            $data->status = $request->status;
            $data->description = $request->summary;
            $data->update();
            return redirect()->back()->with('success', 'App setting updated successfully');
    
    }
}

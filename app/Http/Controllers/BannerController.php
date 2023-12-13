<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Seller;
use File;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::with('seller')->get();
        return view('banners.index', compact('banners'));
    }
    public function ShowaddBanner()
    {
        $sellers = Seller::Active()->get();
        return view('banners.add-banner', compact('sellers'));
    }
    public function addBanner(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg',
            'description' => 'nullable|string'
        ]);

        $banner = new Banner();
        $banner->name = $request->name;
        $banner->seller_id = $request->seller_id;
        $banner->description = $request->description;
        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $bannername = date('dmYHis') . "." . $file->getClientOriginalExtension();
            $file->move('images/banners/', $bannername);
            $banner->image = 'images/banners/' . $bannername;
        }
        $banner->save();

        return redirect('banners')->with('success', 'Banner created successfully');
    }
    public function editBanner($id)
    {
        $sellers = Seller::Active()->get();
        $banner = Banner::where('id', $id)->first();
        return view('banners.edit-banner', compact('banner', 'sellers'));
    }
    public function updateBanner(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'mimes:png,jpg,jpeg',
            'description' => 'nullable|string'
        ]);

        $banner = Banner::where('id', $request->id)->first();

        $banner->name = $request->name;
        $banner->seller_id = $request->seller_id;
        $banner->description = $request->description;
        $banner->status = $request->status;

        if ($request->hasFile('image') && $request->image != "") {
            $imagePath = public_path('images/banners/' . $banner->image);
            if (File::exists($imagePath)) {
                unlink($imagePath);
            }
            $file = $request->file('image');
            $bannername = date('dmYHis') . "." . $file->getClientOriginalExtension();
            $file->move('images/banners/', $bannername);
            $banner->image = 'images/banners/' . $bannername;
        }
        $banner->update();

        return redirect('banners')->with('success', 'Banner updated successfully');
    }
    public function delete($id)
    {
        $banner = Banner::find($id);
        if ($banner->image != "" || $banner->image != NULL) {
            $imagePath = public_path('images/banners/' . $banner->image);
            if (($imagePath && File::exists($imagePath))) {
                unlink($imagePath);
            }
        }
        $banner->delete();
        return redirect('banners')->with('success', 'Banner deleted successfully');
    }
}

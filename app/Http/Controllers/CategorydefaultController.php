<?php

namespace App\Http\Controllers;

use App\Models\Categorydefault;
use App\Models\Category;
use Illuminate\Http\Request;
use File;

class CategorydefaultController extends Controller
{
    
    public function index()
    {
        $categories = Category::all();
        return view('category.add-default-image', compact('categories'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'cat_id' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg,svg|max:3024',
        ]);
        
        $image = array();
        if($file = $request->file('image')){
            $def_img = new Categorydefault();
            $image_name = md5(rand(100000,999999));
            $image_full_name = $image_name.'.'.$file->getClientOriginalExtension();
            $uploade_path = 'upload/category/default/';
            $image_url = $uploade_path.$image_full_name;
            $file->move($uploade_path,$image_full_name);
            $def_img->cat_id = $request->cat_id;
            $def_img->image = $image_url;
            $def_img->save();
        }
        return redirect('category/default/add')->with('success', 'Created successfully');       

    }

    public function getAll($id)
    {
        
        $categories = Categorydefault::where('cat_id', $id)->get();
        // dd($id);
        // if($categories)
        return response()->json($categories, 200);
        
    }
    public function delete($id)
    {
        $category = Categorydefault::where('id', $id)->first();
        if ($category->image != "" || $category->image != NULL) {
            $imagePath = public_path($category->image);
            if (($imagePath && File::exists($imagePath))) {
                unlink($imagePath);
            }
        }
        $category->delete();
        return response()->json([
            'status'=>200,
            'success'=>'Image deleted successfully',
        ]);

    }

}

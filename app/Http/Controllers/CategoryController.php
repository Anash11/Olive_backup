<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use File;

class CategoryController extends Controller
{
    public function showCategory()
    {
        $categories = Category::all();
        return view('category.categories', compact('categories'));
    }
    public function addCategory(Request $req)
    {
        // dd($req->all());
        $req->validate([
            'title' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'summary' => 'required|string'
        ]);

        $category = new Category();
        $category->title = $req->title;
        // dd(date('dmYHis'));

        if ($req->hasFile('image')) {
            $file = $req->file('image');
            $profileImage = date('dmYHis') . "." . $file->getClientOriginalExtension();
            $file->move('upload/category/', $profileImage);
            $category->image_url = 'upload/category/' . $profileImage;
        }
        $category->FK_admin_id = $req->FK_admin_id;
        $category->summary = $req->summary;
        $category->save();

        return redirect('categories')->with('success', 'Category added successfully');
    }
    public function editCategory($id)
    {
        $category = Category::find($id);
        return view('category.edit-category', compact('category'));
    }
    public function updateCategory(Request $req)
    {
        $category = Category::where('id', $req->id)->first();
        $req->validate([
            'title' => 'required',
            'summary' => 'required'
        ]);
        if (request()->hasFile('image')) {
            // dd($category);
            $imagePath = public_path('upload/category/' . $category->image_url);
            if (File::exists($imagePath)) {
                unlink($imagePath);
            }
            $file = $req->file('image');
            $profileImage = date('dmYHis') . "." . $file->getClientOriginalExtension();
            $file->move('upload/category/', $profileImage);
            $category->image_url = 'upload/category/' . $profileImage;
        }
        $category->title = $req->title;
        $category->summary = $req->summary;
        $category->update();
        return redirect('categories')->with('success', 'Category updated successfully');
    }

    public function deleteCategory($id)
    {
        // dd('text');
        $category = Category::find($id);
        if ($category->image_url != "" || $category->image_url != NULL) {
            $imagePath = public_path('images/category/' . $category->image_url);
            if (($imagePath && File::exists($imagePath))) {
                unlink($imagePath);
            }
        }
        $category->delete();
        return redirect('categories')->with('success', 'Category deleted successfully');
    }

    public function categoryList()
    {
        $response['status'] = true;
        $response['message'] = 'Category Found';
        $response['data'] = Category::where('active', 1)->get();
        return response($response, 200);
    }
    public function sellerByCategory($id)
    {
        try {

            $response['status'] = true;
            $response['message'] = 'Sellers Found';
            $response['data'] = Category::with('seller.offers')->where('id', $id)->get();
            return response($response, 200);
        } catch (\Throwable $th) {
            $response['status'] = true;
            $response['message'] = $th->getMessage();
            return response($response, 400);
        }
    }
    public function feedByCity($city = null)
    {
        try {
            if ($city == null) {
                $response['status'] = true;
                $response['message'] = 'Sellers Found';
                $response['data'] = Category::with('sellers.offers')->get();
                return response($response, 200);
            }
            $response['status'] = true;
            $response['message'] = 'Sellers Found';
            $response['data'] = Category::with('sellers.offers')->whereHas('sellers', function ($q) use ($city) {
                $q->where('city', 'LIKE', '%' . $city . '%');
            })->get();
            return response($response, 200);
        } catch (\Throwable $th) {
            $response['status'] = true;
            $response['message'] = $th->getMessage();
            return response($response, 400);
        }
    }

    // status

    public function Status($id)
    {
        $category = Category::where('id', $id)->first();
        return response()->json([
            'status'=>200,
            'category'=>$category,
        ]);

    }
    public function updateStatus(Request $request)
    {
        $category = Category::where('id', $request->id)->first();
        // dd($category);
        $category->active = $request->active;
        $category->update();
        return response()->json([
            'status'=>200,
            'success'=>'Status changed successfully',
        ]);

    }
}

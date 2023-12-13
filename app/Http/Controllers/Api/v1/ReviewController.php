<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function index()
    {
        return response()->json('test');
    }
    public function create(Request $request)
    {
        try {
            if (!auth()->user()) {
                $response['status'] = false;
                $response['message'] = 'Unautherized Access';
                return response($response, 401);
            }
            $validator = Validator::make($request->all(), [
                'review'                     => 'required|numeric',
                'message'                    => 'nullable|string',
                'seller_id'                  => 'required|numeric|exists:sellers,id',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()], 400);
            }

            $review = new Review();
            $review->review = $request->review;
            $review->message = $request->message;
            $review->seller_id = $request->seller_id;
            $review->user_id = auth()->user()->id;
            $review->save();
            $response['status'] = true;
            $response['message'] = 'Your review has been added successfully!';
            return response($response, 200);
        } catch (\Throwable $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
            return response($response, 400);
        }
    }
    public function show($seller_id)
    {
        try {
            $review = Review::with('user')->where('seller_id', $seller_id)->get();
            $response['status'] = true;
            $response['message'] = 'Review Found';
            $response['data'] = $review;
            return response()->json($response, 200);
        } catch (\Throwable $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
            return response($response, 400);
        }
    }
    public function showAvrg($seller_id)
    {
        try {
            $review = DB::select("SELECT avg(review) as total_review, COUNT(user_id) no_of_users from reviews where seller_id = ? GROUP by seller_id", [$seller_id])[0];
            $response['status'] = true;
            $response['message'] = 'Review Found';
            $response['data'] = $review;
            return response()->json($response, 200);
        } catch (\Throwable $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
            return response($response, 400);
        }
    }
}

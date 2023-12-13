<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use App\Models\Voucher;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function changeStatus(Request $request)
    {

        try {
            if (!auth()->user()) {
                $response['status'] = false;
                $response['message'] = 'Unautherized Access';
                return response($response, 401);
            }
            $validator = Validator::make($request->all(), [
                "is_scratched"        => [Rule::in(['Yes', 'No']), 'required'],
                "voucher_id"    => 'required|numeric|exists:vouchers,id'
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()], 400);
            }

            if ($validator->fails()) {
                return response()->json([
                    'status'    => false,
                    'message'   => $validator->errors()
                ], 400);
            }
            Reward::where(['id' => $request->voucher_id])
                ->update(['is_scratched' => $request->is_scratched]);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = $th->getMessage();
            return  response($response, 500);
        }
    }
    /**
     * Return all rewards of user
     */
    public function allRewards(Request $request)
    {
        try {
            if (!auth()->user()) {
                $response['status'] = false;
                $response['message'] = 'Unautherized Access';
                return response($response, 401);
            }
            $response['status'] = true;
            $response['message'] = 'All Rewards';
            $response['data'] =  Reward::with('seller','voucher')->where(['FK_user_id' => auth()->user()->id])->get();
            return  response($response, 200);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = $th->getMessage();
            return  response($response, 500);
        }
    }

}

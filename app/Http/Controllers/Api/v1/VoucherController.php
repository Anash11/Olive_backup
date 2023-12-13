<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;

class VoucherController extends Controller
{
    public function create(Request $request)
    {
        try {

            if (!auth()->user()) {
                $response['status'] = false;
                $response['message'] = 'Unautherized Access';
                return response($response, 401);
            }

            $validator = Validator::make($request->all(), [
                "title"                 => "string|required",
                "terms"                 => "nullable|string",
                "description"           => "string|nullable",
                "from_amount"           => "numeric|required",
                "to_amount"             => "numeric|required",
                // "status"                => [Rule::in(['Active', 'Inactive']), 'nullable'],
                "create_by"             => "string|required"
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()], 400);
            }
            $shopId = Seller::where(['FK_user_id' => auth()->user()->id])->get()[0]->id;
            $voucherData = [
                "FK_seller_id"          =>  $shopId,
                "title"               =>  $request["title"],
                "terms"               =>  $request["terms"],
                "description"         =>  $request["description"],
                "from_amount"         =>  $request["from_amount"],
                "to_amount"           =>  $request["to_amount"],
                // "status"              =>  $request["status"],
                "create_by"           =>  $request["create_by"]
            ];
            // return $voucherData;
            Voucher::create($voucherData);
            $response['status'] = true;
            $response['message'] = 'Voucher created';
            return response($response, 200);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = $th->getMessage();
            return response($response, 400);
        }
    }
    public function update(Request $request)
    {
        try {

            if (!auth()->user()) {
                $response['status'] = false;
                $response['message'] = 'Unautherized Access';
                return response($response, 401);
            }

            $validator = Validator::make($request->all(), [
                "voucher_id"            => "numeric|required|exists:vouchers,id",
                "title"                 => "string|required",
                "terms"                 => "nullable|string",
                "description"           => "string|nullable",
                "from_amount"           => "numeric|required",
                "to_amount"             => "numeric|required",
                "status"                => [Rule::in(['Active', 'Inactive']), 'nullable'],

            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()], 400);
            }
            $shopId = Seller::where(['FK_user_id' => auth()->user()->id])->get()[0]->id;
            $voucherData = [
                "FK_seller_id"          =>  $shopId,
                "title"               =>  $request["title"],
                "terms"               =>  $request["terms"],
                "description"         =>  $request["description"],
                "from_amount"         =>  $request["from_amount"],
                "to_amount"           =>  $request["to_amount"],
                "status"              =>  $request["status"]
            ];
            // return $voucherData;
            Voucher::where(['id' => $request->voucher_id])->update($voucherData);
            $response['status'] = true;
            $response['message'] = 'Voucher Updated';
            return response($response, 201);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = $th->getMessage();
            return response($response, 400);
        }
    }
    public function get($amount, $shopId)
    {
        try {
            if (!auth()->user()) {
                $response['status'] = false;
                $response['message'] = 'Unautherized Access';
                return response($response, 401);
            }
            $vouchers = Voucher::where('FK_seller_id', $shopId)
                ->where('status', '=', 'Active')
                ->where('from_amount', '<=', $amount)
                ->where('to_amount', '>=', $amount)
                ->get();
            $voucher = sizeof($vouchers) ? $vouchers[rand(0, sizeof($vouchers) - 1)] : 'No Voucher found';
            // $response['status'] = true;
            // $response['message'] = 'Template found';
            // $response['data'] = '';
            // return response($response, 200);
            return $voucher;
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = $th->getMessage();
            return response($response, 400);
        }
    }
    /**
     * Update voucher status by seller
     */
    public function changeStatus(Request $request)
    {
        try {

            if (!auth()->user()) {
                $response['status'] = false;
                $response['message'] = 'Unautherized Access';
                return response($response, 401);
            }
            $validator = Validator::make($request->all(), [
                "voucher_id"            => "numeric|required|exists:vouchers,id",
                "status"                => Rule::in(['Active', 'Inactive']),
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()], 400);
            }
            $shop = Seller::where(['FK_user_id' => auth()->user()->id])->get();
            $voucher = Voucher::where('FK_seller_id', '=', $shop[0]->id)
                ->where('id', '=', $request->voucher_id)
                ->get()
                ->first();
            $isUpdated = $voucher->update(['status' => 'status']);
            $response['status'] = true;
            $response['message'] = 'Voucher Updated';
            $response['data'] = '';
            return response($response, 201);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = $th->getMessage();
            return response($response, 400);
        }
    }
    /**
     * It will return list of all vouchers
     * 
     */
    public function allVouchers(Request $req)
    {
        try {
            if (!auth()->user()) {
                $response['status'] = false;
                $response['message'] = 'Unautherized Access';
                return response($response, 401);
            }
            $seller = Seller::where(['FK_user_id' => auth()->user()->id, 'status' => 'Active'])->get()->first();
            $vouchers = Voucher::where('FK_seller_id', $seller->id)
                ->get();
            $response['status'] = true;
            $response['message'] = sizeof($vouchers) ?  sizeof($vouchers) . ' Vouchers Found' : 'You have no any voucher.';
            $response['data'] = $vouchers;
            return response($response, 200);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = $th->getMessage();
            return response($response, 400);
        }
    }
    public function oneVouchers($id)
    {
        try {
            if (!auth()->user()) {
                $response['status'] = false;
                $response['message'] = 'Unautherized Access';
                return response($response, 401);
            }
            $seller = Seller::where(['FK_user_id' => auth()->user()->id, 'status' => 'Active'])->get()->first();

            $vouchers = Voucher::where([
                'FK_seller_id' => $seller->id,
                'id' => $id
            ])->get()->first();
            $response['status'] = true;
            $response['message'] = $vouchers ? 'Vouchers Found' : 'No voucher data found';
            $response['data'] = $vouchers;
            return response($response, 200);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = (string)$th;
            return response($response, 400);
        }
    }
    public function deleteVoucher($id)
    {
        try {
            if (!auth()->user()) {
                $response['status'] = false;
                $response['message'] = 'Unautherized Access';
                return response($response, 401);
            }
            $seller = Seller::where(['FK_user_id' => auth()->user()->id, 'status' => 'Active'])->get()->first();

            $vouchers = Voucher::where([
                'FK_seller_id' => $seller->id,
                'id' => $id
            ]);
            if (!sizeof($vouchers->get())) {
                $response['status'] = false;
                $response['message'] = 'Voucher is not in your List';
                return response($response, 401);
            }
            $vouchers->delete();
            $response['status'] = true;
            $response['message'] =  'Voucher Deleted.';
            return response($response, 200);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = (string)$th;
            return response($response, 400);
        }
    }
}

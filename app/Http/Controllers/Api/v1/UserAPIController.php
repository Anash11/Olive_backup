<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;


class UserAPIController extends Controller
{

    /**
     * Create a new AuthControllerAPI instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }


    /**
     * Add email and name info
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addNameEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' =>  'required|string',
            'email' =>  'required|email',
            'state' =>  'string',
            'city' =>  'string',
            'pincode' =>  ['required', 'digits:6', 'numeric'],
            'address_info' =>  'string',
            // 'dob' => 'date_format:d/m/Y'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 400);
        }
        $response = array();
        if (auth()->user()->status) {
            $response['status'] = true;
            $response['message'] = 'User info updated';
            User::where('id', auth()->user()->id)->update($request->all());
            $response['data'] = User::where('id', auth()->user()->id)->get()->first();
            $response['token'] = explode(" ", $request->header('Authorization'))[1];
            return response()->json($response, 200);
        } else {
            $response['status'] = false;
            $response['message'] = 'Phone number not verified';
            $response['token'] = explode(" ", $request->header('Authorization'))[1];
            return response()->json($response, 500);
        }
    }

    public function userDelete() {
        $user = Auth::user();
        $user->delete();
        auth()->logout();
        return response()->json(["message" => "Account deactivated", "status" => true], 200);
    }
}

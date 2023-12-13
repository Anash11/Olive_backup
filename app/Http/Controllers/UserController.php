<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;


class UserController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => []]);
    // }


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

    public function allUser()
    {
        $users = User::withTrashed()->orderBy('id', 'desc')->get();
        return view('users.users', compact('users'));
    }
    public function editStatus($id)
    {
        $user = User::withTrashed()->where('id', $id)->first();
        return view('users.edit-user', compact('user'));
    }
    public function updateStatus(Request $request)
    {
        $user = User::withTrashed()->where('id', $request->id)->first();
        $user->status = $request->status;
        $user->deleted_at = $request->deleted_at;
        $user->update();
        return redirect('users')->with('success', 'User status updated successfully');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;


class AuthController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'verifyOtp']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login($phone)
    {
        $user = User::where('phone', $phone)->first();
        if (!$token = Auth::login($user)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response([
            'status' => true,
            'message' => 'OTP sent successfully'
        ], 201);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' =>  'required|digits:10'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 400);
        }
        $otp = 123456;
        $phone = $request->phone;
        if (User::where('phone', $phone)->count()) { // Already exists
            $user = User::where('phone', $phone)->first();
            User::where('phone', $phone)->update(['otp' => $otp]);
        } else {         // Create New 
            $user = User::create(array_merge(
                $validator->validated(),
                ['otp' => $otp]
            ));
        }
        return $this->login($phone);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->json(auth()->user());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyOtp(Request $request)
    {

        $response = array();
        try {
            $validator = Validator::make($request->all(), [
                'phone' =>  'required|digits:10',
                'otp' =>  'required|digits:6'
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()], 400);
            }
            $user = User::where(['phone' => $request->phone])->get()[0];
            if ($user->otp == $request->otp) {
                User::where('phone', $request->phone)->update(['status' => 1]);
                if ($user->name == null)
                    $response['profile_complete'] = false;
                else
                    $response['profile_complete'] = true;
                if (!$token = Auth::login($user)) {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
                $response['status'] = true;
                $response['message'] = 'OTP verified';
                $response['data'] = $user;
                $response['token_type'] = 'Bearer';
                $response['token'] = $token;
                return response()->json($response, 200);
            } else {
                $response['status'] = false;
                $response['message'] = 'Invalid OTP';
                // return response()->json(["status" => "Invalid OTP"], 401);
                return response()->json($response, 401);
            }
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['error'] = $th->getMessage();
            return response($response, 401);
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        $ttl_time_min =  2880;
        return response()->json([
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * $ttl_time_min,
            'user' => auth()->user(),
            'token' => $token,
        ]);
    }
}

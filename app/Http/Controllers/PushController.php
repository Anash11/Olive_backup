<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\v1\FirebaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class PushController extends Controller
{
    public function sendNotification(Request $request)
    {
        try {
            $validator = $request->validate([
                'device_tokens' =>  'required|array',
                'title' =>  'required|string',
                'description' =>  'required|string',
                'image' =>  'required|string'
            ]);

            if (!$validator) {
                return response()->json(['status' => false, 'message' => 'Invalid'], 400);
            }

            $msg["title"] = $request->title;
            $msg["body"] = $request->description;
            $msg["image"] = $request->image;
            $msg["target_id"] = NULL;
            $msg["redirect_to"] = $request->redirect_to;
            $push = $this->sendNotificationParam($request->device_tokens, $request->title, $request->description);
            return $push;
        } catch (\Throwable $th) {
            return $th;
        }
    }






    public function sendNotificationParam(
        $device_tokens_array,
        $title,
        $body,
        $image ='',
        $redirect_to = '/'
    ) {
        try {          

            $msg["title"] = $title;
            $msg["body"] = $body;
            $msg["image"] = $image;
            $msg["target_id"] = NULL;
            $msg["redirect_to"] = $redirect_to;
            $push = FirebaseController::sendFireBaseNotification($device_tokens_array, $msg);
            return $push;
        } catch (\Throwable $th) {
            return $th;
        }
    }

    // public function submit(Request $request)
    // {
    //     $receiver_ids = NULL;
    //     if ($request->receiver_type == 'Custom') {
    //         $receiver_ids = implode(',', $request->receiver_ids);
    //     }
    //     // dd($receiver_ids);

    //     $notification = new Notification;
    //     $notification->title = $request->title;
    //     $notification->description = $request->description;
    //     $notification->image = $request->image;
    //     $notification->message_type = "mannual";
    //     $notification->receiver_type = $request->receiver_type;
    //     $notification->receiver_ids = $receiver_ids;
    //     $notification->redirect_to = 'notifications';
    //     $save = $notification->save();

    //     if ($save) {
    //         $user_token = User::whereNotNull('device_token')
    //             ->where("is_active", "Yes")
    //             ->where("status", "Active")
    //             ->pluck('device_token');

    //         if (!empty($user_token)) {
    //             $imagePath = NULL;
    //             if (isset($image)) {
    //                 $imagePath = asset("public/storage/notifications/" . $image);
    //             }

    //             $msg["title"] = $request->title;
    //             $msg["body"] = $request->description;
    //             $msg["image"] = $imagePath;
    //             $msg["target_id"] = NULL;
    //             $msg["redirect_to"] = 'notifications';

    //             $push = FirebaseController::sendFireBaseNotification($user_token, $msg);
    //         }

    //         $result = ["status" => true, "response" => "success", "message" => "Notification pushed successfully !"];
    //     } else {
    //         $result = ["status" => false, "response" => "error", "message" => "Something went wrong !"];
    //     }

    //     return response()->json($result);
    // }
}

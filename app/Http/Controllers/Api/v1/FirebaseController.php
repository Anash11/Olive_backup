<?php



namespace App\Http\Controllers\Api\v1;



use App\Http\Controllers\Controller;




class FirebaseController extends Controller

{

    public static function sendFireBaseNotification($tokens, $msgData)
    {
        $server_api_key = env('FIREBASE_SERVER_KEY');
        $url = "https://fcm.googleapis.com/fcm/send";
        $header = [
            'authorization: key=' . $server_api_key,
            'content-type: application/json'
        ];
        $data = [
            "registration_ids" => $tokens,
            "notification" => [
                "title" => $msgData['title'],
                "body" => $msgData['body'],
                "datetime" => date("d-m-Y h:i A"),
            ],
            "data" => [
                "image_url" => $msgData['image'],
                "target_id" => $msgData['target_id'],
                "redirect_to" => $msgData['redirect_to']
            ]
        ];

        $postdata = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($ch);

        curl_close($ch);
        return $result;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function create($path,$message)
    {
        return Notification::create(["notification_type" => $path, 'message' => $message]);
    }

    public function seen(Request $req)
    {
        $req->validate([
            'id' => 'numeric|required'
        ]);

        $isUpdate = DB::table('notifications')
            ->where('id', $req->id)
            ->update(['status' => 1]);
        return ['status' => $isUpdate];
    }
    public function showSomeNotification()
    {
        return DB::table('notifications')
            ->limit(10)
            ->orderByDesc('id')
            ->get();
    }
    public function getAll($sort = false)
    {
        if ($sort)
            return DB::table('notifications')
                ->limit(10)
                ->orderByDesc('status')
                ->get();

        return DB::table('notifications')
            ->orderByDesc('id')
            ->get();
    }
    public function notificationPage($note = 'seller', $count = 10)
    {
        $notification  = DB::table('notifications')
            ->limit($count)
            ->where('message', 'LIKE', '%' . $note . '%')
            ->orderByDesc('id')
            ->get();
        return $notification;
    }
}

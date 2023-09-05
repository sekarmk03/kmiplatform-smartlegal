<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getNotification(){
        return response()->json([
            'status' => 'success',
            'data' => Auth::user()->notifications
        ], 200);
    }

    public function countNotification(){
        return response()->json([
            'status' => 'success',
            'count' => Auth::user()->unreadNotifications->count()
        ], 200);
    }
    public function readNotification(){
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json([
            'status' => 'success',
            'message' => 'Notification has been read'
        ], 200);
    }
}

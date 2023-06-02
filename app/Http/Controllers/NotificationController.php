<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    protected $has_read = [];
    public function _array_user()
    {        
        $read = DB::table('tr_user_has_read')
            ->select('intNotification_ID')
            ->where('user_id', Auth::user()->id)
            ->get();
        foreach ($read as $val) {
            $this->has_read[] = $val->intNotification_ID;
        }
    }
    public function countNotification()
    {
        $this->_array_user();
        return Notification::whereNotIn('intNotification_ID', $this->has_read)->count();
    }
    public function getNotification()
    {
        $this->_array_user();
        return response()->json([
            'status' => 'success',
            'data' => Notification::leftJoin('tr_user_has_read AS has_read', 'has_read.intNotification_ID', '=', 'mnotifications.intNotification_ID')->get(['mnotifications.*', 'has_read.intNotification_ID AS has_read'])
        ], 200);
    }
    public static function storeNotification($message)
    {
        return DB::table('mnotifications')->insert([
            'txtnotification' => $message
        ]);
    }
    public function onclickNotif()
    {
        $this->_array_user();
        $result = [];
        $data = Notification::whereNotIn('intNotification_ID', $this->has_read)->get();
        foreach ($data as $row) {
            $result[] = [
                'intNotification_ID' => $row->intNotification_ID,
                'user_id' => Auth::user()->id
            ];
        }
        DB::table('tr_user_has_read')->insert($result);
        return response()->json([
            'status' => 'success',
            'message' => 'Notification has Read'
        ], 200);
    }
}

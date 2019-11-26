<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Resources\NotificationResource;



class NotificationController extends Controller
{

    public function index(Request $request){
        $notifications = $request->user()->notifications()->paginate(2);

        return NotificationResource::collection($notifications);
    }

    //// 通知统计
    public function stats(Request $request){
        return response()->json([
            'unread_count'  =>  $request->user()->notification_count,
        ]);
    }
    //
}

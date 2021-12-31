<?php

namespace App\Http\Controllers;


use App\Models\Notification;

class NotificationsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    static function getNotifications($id)
    {
        $my_notifications = Notification::where('user_id','=',$id)->where('seen', '=', false)->get();
        $my_notifications = json_decode($my_notifications, true);
        return array_reverse($my_notifications);
    }

}

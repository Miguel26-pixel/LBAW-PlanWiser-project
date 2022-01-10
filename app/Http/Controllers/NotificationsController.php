<?php

namespace App\Http\Controllers;


use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

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

    public function managerNotification($id) {
        $notification = Notification::find($id);
        $notification->seen = true;
        $notification->save();
        return redirect('/project/'.$notification->invitation_project_id.'/members');
    }
}

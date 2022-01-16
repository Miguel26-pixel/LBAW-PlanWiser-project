<?php

namespace App\Http\Controllers;


use App\Models\Notification;
use App\Models\Task;
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
        $my_notifications = Notification::where('user_id','=',$id)->where('seen', '=', false)->orderByDesc('created_at')->get();
        return $my_notifications;
    }

    public function managerNotification($id) {
        $notification = Notification::find($id);
        $notification->seen = true;
        $notification->save();
        return redirect('/project/'.$notification->invitation_project_id.'/members');
    }

    public function taskClosedNotification($id) {
        $notification = Notification::find($id);
        $notification->seen = true;
        $notification->save();
        $task = Task::find($notification->task_id);
        return redirect('/project/'.$task->project_id.'/task/'.$task->id);
    }

    public function assignNotification($id) {
        $notification = Notification::find($id);
        $notification->seen = true;
        $notification->save();
        $task = Task::find($notification->task_id);
        return redirect('/project/'.$task->project_id.'/task/'.$task->id);
    }

    public function clearNotifications($id) {
        $notifications = Notification::where('user_id','=',$id)->get();
        foreach ($notifications as $notification) {
            $notification->seen = true;
            $notification->save();
        }
        return redirect()->back();
    }
}

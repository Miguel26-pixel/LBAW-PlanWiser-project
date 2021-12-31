<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProjectUser;
use App\Models\User;
use App\Models\Project;
use App\Models\Invitation;
use App\Models\Report;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

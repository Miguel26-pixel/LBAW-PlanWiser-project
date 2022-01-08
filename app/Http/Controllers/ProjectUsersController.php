<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ProjectUsersController extends Controller
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

    static public function getProjectUsers($project_id){
        $myusers = DB::table('users')
                        ->join('projectusers', 'users.id', '=', 'projectusers.user_id')
                        ->where('projectusers.project_id', $project_id)
                        ->get(['user_id', 'username','email','user_role']);
        $myusers = json_decode($myusers,true);

        return $myusers;
    }

    public function showProjectUsers($project_id)
    {
        Gate::authorize('inProject',Project::find($project_id));
        $notifications = NotificationsController::getNotifications(Auth::id());

        $myusers = $this->getProjectUsers($project_id);
        $user_role = ProjectUser::find(['user_id' => Auth::id(),'project_id' => $project_id])->user_role;

        return view('pages.projectUsers',['user_role' => $user_role, 'project_users' => $myusers,'project' => Project::find($project_id), 'notifications' => $notifications]);
    }
}

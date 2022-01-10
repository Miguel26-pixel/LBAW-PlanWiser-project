<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Project;
use App\Models\ProjectUser;
use Illuminate\Http\Request;
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

    public function updateUserRole($id,$user_id, Request $request) {
        Gate::authorize('isActive',Project::find($id));
        Gate::authorize('manager',Project::find($id));
        $project_user = ProjectUser::find(['user_id' => $user_id, 'project_id' => $id]);
        $project_user->user_role = $request->role;
        $project_user->save();
        return redirect()->back();
    }

    public function removeUserRole($id,$user_id) {
        Gate::authorize('isActive',Project::find($id));
        Gate::authorize('manager',Project::find($id));
        $project_user = ProjectUser::find(['user_id' => $user_id, 'project_id' => $id]);
        if ($project_user->user_role == "MANAGER") {
            return redirect()->back()->withErrors("You can't remove this user because the user is manager of the project");
        }
        $invite = Invitation::where('project_id', '=', $id)->where('user_id', '=', $user_id)->where('accept','=',true)->first();
        if ($invite) {
            $invite->delete();
        }
        $project_user->delete();
        return redirect()->back();
    }

    public function searchProjectMembers($project_id, Request $request) {
        $users = DB::table('users')
            ->join('projectusers', 'users.id', '=','projectusers.user_id')
            ->join('projects', 'projectusers.project_id', '=','projects.id')
            ->where('projects.id','=',$project_id)
            ->whereRaw("(users.username like '%".$request->search."%'
                                                or users.email like '%".$request->search."%'
                                                or CAST(user_role AS VARCHAR) like '".$request->search."%')")
            ->get(['user_id', 'username','email','user_role']);

        $users = json_decode($users,true);
        $notifications = NotificationsController::getNotifications(Auth::id());
        $user_role = ProjectUser::find(['user_id' => Auth::id(),'project_id' => $project_id])->user_role;
        return view('pages.projectUsers',['user_role' => $user_role, 'project_users' => $users,'project' => Project::find($project_id), 'notifications' => $notifications]);
    }
}

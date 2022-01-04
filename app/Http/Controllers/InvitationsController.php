<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\FavoriteProject;
use App\Models\Project;
use App\Models\Notification;
use App\Models\ProjectUser;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitationsController extends Controller
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

    public function showInvitationForm($id)
    {
        $notifications = NotificationsController::getNotifications(Auth::id());
        return view('pages.invitationsCreate', ['project' => Project::find($id), 'notifications' => $notifications]);
    }



    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     *
     */
    protected function create(int $project_id, Request $request)
    {

        $notifications = NotificationsController::getNotifications(Auth::id());
        $project = Project::find($project_id);
        $user = Auth::user();
        $admins = $project->managers;
        $members = $project->members;
        $guests = $project->guests;
        $num_favs = $project->getNumFavs();
        $is_fav = FavoriteProject::where('user_id' ,'=', $user->id)->where('project_id','=',$project_id)->exists();

        $user_id = User::where('username', '=', $request->username)->get('id');

        $user_id = json_decode($user_id, true);

        $old_invite = Invitation::where('project_id', '=', $project_id)
                                    ->where('user_id', '=', $user_id[0]['id'])->get();

        $old_invite = json_decode($old_invite, true);

        if($old_invite !== [])
            return view('pages.project',['project' => Project::find($project_id), 'notifications' => $notifications,'admins' => $admins, 'members' => $members, 'guests' => $guests, 'is_fav' => $is_fav, 'num_favs' => $num_favs]);

        if($user_id !== null) {

            $invitation = new Invitation;
            $invitation->user_id = $user_id[0]['id'];
            $invitation->project_id = $project_id;
            $invitation->accept = false;
            $invitation->user_role = $request->user_role;;
            $invitation->save();

        }

        return view('pages.project',['project' => Project::find($project_id), 'notifications' => $notifications,'admins' => $admins, 'members' => $members, 'guests' => $guests, 'is_fav' => $is_fav, 'num_favs' => $num_favs]);
    }


    public function showInvite(int $id)
    {

        $notifications = NotificationsController::getNotifications(Auth::id());
        $not = Notification::find($id);
        $invitation = Invitation::where('user_id', '=', $not->invitation_user_id)
                                    ->where('project_id', '=', $not->invitation_project_id)->get();
        $project = Project::find($not->invitation_project_id);

        return view('pages.invitationProject',['project' => $project, 'notifications' => $notifications, 'not' => $not, 'invite' => $invitation]);
    }

    public function dealWithInvite(int $id, Request $request)
    {
        $public_projects = ProjectsController::getPublicProjects(6);
        $notifications = NotificationsController::getNotifications(Auth::id());
        $not = Notification::find($id);
        $invitation = Invitation::where('user_id', '=', $not->invitation_user_id)
                                    ->where('project_id', '=', $not->invitation_project_id)->get();
        $project = Project::find($not->invitation_project_id);
        $projectU = ProjectUser::where('user_id', '=', $not->user_id)
                                    ->where('project_id', '=', $not->invitation_project_id)->get();

        $projectU = json_decode($projectU, true);                            
        if($projectU == []){
            if ($request->action == 'accept') {
                $invitation[0]->accept = true;
                $invitation[0]->save();
            }
        }

        $not->seen = true;
        $not->save();
        $notifications = NotificationsController::getNotifications(Auth::id());


        return view('pages.homepage', ['notifications' => $notifications, 'public_projects' => $public_projects]);
    }
}




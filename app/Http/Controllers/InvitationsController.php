<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\FavoriteProject;
use App\Models\Project;
use App\Models\Notification;
use App\Models\ProjectUser;
use App\Models\Invitation;
use App\Events\Invite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
        Gate::authorize('manager',Project::find($id));
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
        Gate::authorize('manager',Project::find($project_id));
        $notifications = NotificationsController::getNotifications(Auth::id());
        $project = Project::find($project_id);
        $user = Auth::user();
        $admins = $project->managers;
        $members = $project->members;
        $guests = $project->guests;
        $num_favs = $project->getNumFavs();
        $is_fav = FavoriteProject::where('user_id' ,'=', $user->id)->where('project_id','=',$project_id)->exists();

        $user_id = User::where('username', '=', $request->username)->get('id');

        //dd($user_id);

        $user_id = json_decode($user_id, true);
        if ($user_id === []) {
            return redirect()->back()->withErrors('User does not exist');
        }
        //dd($user_id);

        $old_invite = Invitation::where('project_id', '=', $project_id)
                                    ->where('user_id', '=', $user_id[0]['id'])->where('accept','=',true)->get();
        //dd($old_invite);
        $old_invite = json_decode($old_invite, true);

        if($old_invite !== []) {
            return redirect('/project/' . $project_id.'/members');
        }

        if($user_id !== null) {

            $invitation = new Invitation;
            $invitation->user_id = $user_id[0]['id'];
            $invitation->project_id = $project_id;
            $invitation->accept = false;
            $invitation->user_role = $request->user_role;;
            $invitation->save();

            $notification = Notification::where('notification_type', '=', 'INVITE')
                                            ->where('invitation_user_id', $user_id[0]['id'])
                                            ->where('invitation_project_id', $project_id)
                                            ->first();

            event(new Invite($project->title,$user_id[0]['id'], $notification->id));

        }

        return redirect('/project/' . $project_id.'/members');
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
        $not = Notification::find($id);
        $invitation = Invitation::where('user_id', '=', $not->invitation_user_id)
                                    ->where('project_id', '=', $not->invitation_project_id)->first();
        $projectU = ProjectUser::where('user_id', '=', $not->user_id)
                                    ->where('project_id', '=', $not->invitation_project_id)->first();
        if(!$projectU){
            if ($request->action == 'accept') {
                $invitation->accept = true;
                $invitation->save();
                $not->seen = true;
                $not->save();
                return redirect('/project/'.$not->invitation_project_id);
            }
        }
        $not->seen = true;
        $not->save();
        return redirect('/projects');
    }
}




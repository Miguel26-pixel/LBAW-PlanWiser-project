<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Project;
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

        $user_id = User::where('username', '=', $request->username)->get('id');

        //dd($user_id);

        $user_id = json_decode($user_id, true);

        //dd($user_id);

        $old_invite = Invitation::where('project_id', '=', $project_id)
                                    ->where('user_id', '=', $user_id[0]['id'])->get();

        $old_invite = json_decode($old_invite, true);

        if($old_invite !== [])
            return view('pages.project',['project' => Project::find($project_id), 'notifications' => $notifications]);

        if($user_id !== null) {

            $invitation = new Invitation;
            $invitation->user_id = $user_id[0]['id'];
            $invitation->project_id = $project_id;
            $invitation->accept = false;
            $invitation->user_role = $request->user_role;;
            $invitation->save();

        }

        return view('pages.project',['project' => Project::find($project_id), 'notifications' => $notifications]);
    }
}

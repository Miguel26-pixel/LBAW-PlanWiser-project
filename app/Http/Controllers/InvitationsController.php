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
        return view('pages.invitationsCreate', ['project' => Project::find($id)]);
    }



    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     *
     */
    protected function create(int $project_id, Request $request)
    {
        $user_id = User::where('username', '=', $request->username)->get('id');

        $user_id = json_decode($user_id, true);

        $old_invite = Invitation::where('project_id', '=', $project_id)
                                    ->where('user_id', '=', $user_id[0]['id'])->get();

        if($old_invite !== null)
            return view('pages.project',['project' => Project::find($project_id)]);

        if($user_id !== null) {

            $invitation = new Invitation;
            $invitation->user_id = $user_id[0]['id'];
            $invitation->project_id = $project_id;
            $invitation->accept = false;
            $invitation->user_role = $request->user_role;
            $invitation->save();

        }

        return view('pages.project',['project' => Project::find($project_id)]);
    }
}

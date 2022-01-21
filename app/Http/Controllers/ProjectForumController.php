<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectMessage;
use App\Models\ProjectUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProjectForumController extends Controller
{
    function show($id) {
        $project = Project::find($id);
        Gate::authorize('inProject',$project);
        Gate::authorize('notGuestOrAdmin',$project);
        $user = Auth::user();
        $notifications = NotificationsController::getNotifications(Auth::id());
        $messages = ProjectMessage::where('project_id','=',$id)->orderByDesc('created_at')->paginate(7);
        $project_user = ProjectUser::find(['user_id' => $user->id,'project_id' => $project->id]);
        if (!$project_user) {
            $user_role = 'VISITOR';
        } else {
            $user_role = $project_user->user_role;
        }
        return view('pages.projectForum',['project' => $project, 'notifications' => $notifications,'messages' => $messages,'user_role' => $user_role]);
    }

    function sendMessage($id, Request $request) {
        Gate::authorize('isActive',Project::find($id));
        Gate::authorize('notGuest',Project::find($id));
        $message = new ProjectMessage();

        $message->user_id = Auth::id();
        $message->project_id = $id;
        $message->message = $request->message;
        $message->created_at = now();

        $message->save();

        return redirect()->back();
    }
}

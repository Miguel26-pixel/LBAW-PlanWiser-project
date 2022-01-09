<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProjectForumController extends Controller
{
    function show($id) {
        $project = Project::find($id);
        Gate::authorize('notGuest',$project);
        $notifications = NotificationsController::getNotifications(Auth::id());
        $messages = ProjectMessage::where('project_id','=',$id)->orderByDesc('created_at')->paginate(7);
        return view('pages.projectForum',['project' => $project, 'notifications' => $notifications,'messages' => $messages]);
    }

    function sendMessage($id, Request $request) {
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

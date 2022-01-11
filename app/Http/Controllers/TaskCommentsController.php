<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\ProjectMessage;
use App\Models\TaskComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TaskCommentsController extends Controller
{
    public static function getTaskComments($id) {
        return TaskComment::where('task_id','=',$id)->orderByDesc('created_at')->paginate(7);
    }

    public function sendComment($id, $task_id, Request $request) {

        Gate::authorize('update',Task::find($task_id));
        $task_comment = new TaskComment();

        $task_comment->user_id = Auth::id();
        $task_comment->task_id = $task_id;
        $task_comment->comment = $request->comment;
        $task_comment->created_at = now();

        $task_comment->save();

        return redirect()->back();
    }
}

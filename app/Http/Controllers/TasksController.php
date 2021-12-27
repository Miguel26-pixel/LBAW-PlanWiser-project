<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DateTime;
use App\Models\Task;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TasksController extends Controller
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

    /*public function showProject($id) {
        $user = Auth::user();
        $projects = $user->projects;
        $project = Project::find($id);
        $check = false;
        foreach ($projects as $p) {
            if ($p->id == $project->id) $check=true;
            if (!(Auth::user()->is_admin || $check || $p->public)) {
                return redirect('/');
        }
    }
        if (!(Auth::user()->is_admin || $check || $project->public)) {
            return redirect('/');
        }
        return view('pages.project',['project' => Project::find($id)]);
    }*/

    public function showTaskForm()
    {
        return view('pages.tasksCreate');
    }

    protected function validator()
    {
        return  [
            'name' => ['required','string'],
            'description' => ['required','string'],
        ];
    }



    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     *
     */
    protected function create(Request $request)
    {

        $validator = $request->validate($this->validator());

        $task = new Task;
        $task->name = $request->name;
        $task->description = $request->description;
        $task->due_date = $request->due_date;
        $task->reminder_date = $request->reminder_date;
        $task->tag = $request->tag;
        //$task->project_id = $request->project_id;
        $task->creator_id = Auth::id();
        $task->created_at = Carbon::now();
        $task->save();

        return redirect()->back();
    }
}

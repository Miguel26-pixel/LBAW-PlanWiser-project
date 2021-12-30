<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tasks;
use App\Models\Project;
use App\Models\Notification;
use App\Models\UserAssigns;
use Carbon\Carbon;
use DB;
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

    public function showTaskForm(int $id)
    {
        return view('pages.tasksCreate',['project' => Project::find($id)]);
    }

    protected function validator()
    {
        return  [
            'name' => ['required','string'],
            'description' => ['required','string'],
        ];
    }

    public function showTask(int $project_id, int $id)
    {
        return view('pages.task',['project' => Project::find($project_id), 'task' => Tasks::find($id)]);
    }


    public function updateTask(int $project_id, int $id, Request $request) {
        if (!(Auth::id() == $id || Auth::user()->is_admin)) {
            $public_projects = ProjectsController::searchPublicProjects($request);
            return view('pages.homepage', ['public_projects' => $public_projects]);
        }
        $validator = $request->validate($this->validator());

        $task = Tasks::find($id);
        $task->name = $request->name;
        $task->description = $request->description;
        $task->due_date = $request->due_date;
        $task->tag = $request->tag;
        $task->save();

        return redirect()->back();
    }

    public function showTasks($project_id)
    {
        $my_ALL = DB::table('tasks')
                        ->leftjoin('userassigns', 'tasks.id', '=', 'userassigns.task_id')
                        ->leftjoin('users', 'users.id', '=', 'userassigns.user_id')
                        ->where('tasks.project_id', $project_id)
                        ->get(['tasks.id','name','description','due_date','username', 'tasks.tag']);
        $my_ALL = json_decode($my_ALL,true);
        //dd($my_ALL);
        $my_TODO = DB::table('tasks')
                        ->leftjoin('userassigns', 'tasks.id', '=', 'userassigns.task_id')
                        ->leftjoin('users', 'users.id', '=', 'userassigns.user_id')
                        ->where('tasks.project_id', $project_id)
                        ->where('tasks.tag', 'TODO')
                        ->get(['tasks.id','name','description','due_date','username']);
        $my_TODO = json_decode($my_TODO,true);
        //dd($my_TODO);
        $my_DOING = DB::table('tasks')
                        ->leftjoin('userassigns', 'tasks.id', '=', 'userassigns.task_id')
                        ->leftjoin('users', 'users.id', '=', 'userassigns.user_id')
                        ->where('tasks.project_id', $project_id)
                        ->where('tasks.tag', 'DOING')
                        ->get(['tasks.id', 'name','description','due_date','username']);
        $my_DOING = json_decode($my_DOING,true);
        //dd($my_DOING);
        $my_REVIEW = DB::table('tasks')
                        ->leftjoin('userassigns', 'tasks.id', '=', 'userassigns.task_id')
                        ->leftjoin('users', 'users.id', '=', 'userassigns.user_id')
                        ->where('tasks.project_id', $project_id)
                        ->where('tasks.tag', 'REVIEW')
                        ->get(['tasks.id', 'name','description','due_date','username']);
        $my_REVIEW = json_decode($my_REVIEW,true);
        //dd($my_REVIEW);
        $my_CLOSED = DB::table('tasks')
                        ->leftjoin('userassigns', 'tasks.id', '=', 'userassigns.task_id')
                        ->leftjoin('users', 'users.id', '=', 'userassigns.user_id')
                        ->where('tasks.project_id', $project_id)
                        ->where('tasks.tag', 'CLOSED')
                        ->get(['tasks.id', 'name','description','due_date','username']);
        $my_CLOSED = json_decode($my_CLOSED,true);
        //dd($my_CLOSED);
        return view('pages.tasks',['tasks_ALL' => $my_ALL, 'tasks_ALL', 'tasks_TODO' => $my_TODO, 'tasks_DOING' => $my_DOING,'tasks_REVIEW' => $my_REVIEW,'tasks_CLOSED' => $my_CLOSED,'project' => Project::find($project_id)]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     *
     */
    protected function create(Request $request)
    {
        //dd($request);
        $validator = $request->validate($this->validator());

        $task = new Tasks;
        $task->name = $request->name;
        $task->description = $request->description;
        $task->due_date = $request->due_date;
        $task->reminder_date = $request->reminder_date;
        $task->tag = $request->tag;
        $task->project_id = $request->project_id;
        $task->creator_id = Auth::id();
        $task->created_at = Carbon::now();
        $task->save();

        return redirect()->back();
    }
}

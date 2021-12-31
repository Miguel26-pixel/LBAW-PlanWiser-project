<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function showTaskForm(int $id)
    {
        $notifications = NotificationsController::getNotifications(Auth::id());
        return view('pages.tasksCreate',['project' => Project::find($id), 'notifications' => $notifications]);
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
        $notifications = NotificationsController::getNotifications(Auth::id());
        return view('pages.task',['project' => Project::find($project_id), 'task' => Tasks::find($id), 'notifications' => $notifications]);
    }


    public function updateTask(int $project_id, int $id, Request $request) {
        $notifications = NotificationsController::getNotifications(Auth::id());

        switch ($request->input('action'))
        {
            case 'update':
                $validator = $request->validate($this->validator());

                $task = Tasks::find($id);
                $task->name = $request->name;
                $task->description = $request->description;
                $task->due_date = $request->due_date;
                $task->tag = $request->tag;
                $task->save();
                break;

            case 'delete':
                $task=Tasks::find($id);
                $task->delete(); //returns true/false
                break;
        }

       return redirect()->action([TasksController::class,'showTasks'], ['id'=> $task->project_id, 'notifications' => $notifications]);
    }

    public function showTasks($project_id)
    {
        $notifications = NotificationsController::getNotifications(Auth::id());

        $my_TASKS = DB::table('tasks')
                        ->leftjoin('userassigns', 'tasks.id', '=', 'userassigns.task_id')
                        ->leftjoin('users', 'users.id', '=', 'userassigns.user_id')
                        ->where('tasks.project_id', $project_id)
                        ->get(['tasks.id','name','description','due_date','username', 'tasks.tag']);
        $my_TASKS = json_decode($my_TASKS,true);

        /*
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
        return view('pages.tasks',['tasks_TODO' => $my_TODO, 'tasks_DOING' => $my_DOING,'tasks_REVIEW' => $my_REVIEW,'tasks_CLOSED' => $my_CLOSED,'project' => Project::find($project_id), 'notifications' => $notifications]);

        return view('pages.tasks',['tasks' => $my_TASKS, 'tasks', 'tasks_TODO' => $my_TODO, 'tasks_DOING' => $my_DOING,'tasks_REVIEW' => $my_REVIEW,'tasks_CLOSED' => $my_CLOSED,'project' => Project::find($project_id)]);
        */

        return view('pages.tasks',['tasks' => $my_TASKS, 'tasks', 'project' => Project::find($project_id), 'notifications' => $notifications]);

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     *
     */
    protected function create(Request $request)
    {
        $notifications = NotificationsController::getNotifications(Auth::id());
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

        return redirect()->action([TasksController::class,'showTasks'], ['id'=> $task->project_id]);
    }
/*
    static function getProjectTasks($project_id) {
        return (new Tasks())->where('project_id','=',$project_id)->orderBy('due_date');
    }
*/
    public function searchProjectTasks(int $project_id, Request $request)
    {
        $notifications = NotificationsController::getNotifications(Auth::id());

        $tasks_result = Tasks::where('project_id', '=', $project_id)
                               ->where('name','like',"%{$request->search}%")
                               ->orWhere('description','like',"%{$request->search}%")
                               ->orWhere('due_date','like',"%{$request->search}%")
                               ->orWhere('tag','like',"%{$request->search}%")
                               ->orderBy('due_date')
                               ->paginate(10);

        return view('pages.tasks',['tasks' => $tasks_result, 'project' => Project::find($project_id), 'notifications' => $notifications]);
    }
}

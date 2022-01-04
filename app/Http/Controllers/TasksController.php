<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\UserAssign;
use Exception;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

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
        Gate::authorize('manager',Project::find($id));
        $notifications = NotificationsController::getNotifications(Auth::id());

        $users = ProjectUsersController::getProjectUsers($id);

        return view('pages.tasksCreate',['project' => Project::find($id), 'notifications' => $notifications, 'users' => $users]);
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
        Gate::authorize('show',Task::find($id));
        $notifications = NotificationsController::getNotifications(Auth::id());

        $users = ProjectUsersController::getProjectUsers($project_id);

        $user_assigned = DB::table('userassigns')
                            ->leftjoin('users', 'users.id', '=', 'userassigns.user_id')
                            ->where('task_id', '=', $id)
                            ->get(['userassigns.user_id','users.username']);

        $user_assigned = json_decode($user_assigned, true);

        return view('pages.task',['project' => Project::find($project_id),
                                    'task' => Task::find($id),
                                    'notifications' => $notifications,
                                    'users' => $users,
                                    'user_assigned' => $user_assigned]);
    }


    public function updateTask(int $project_id, int $id, Request $request) {

        $notifications = NotificationsController::getNotifications(Auth::id());

        switch ($request->input('action'))
        {
            case 'update':
                Gate::authorize('update',Task::find($id));
                $validator = $request->validate($this->validator());
                try{
                    $task = Task::find($id);
                    $task->name = $request->name;
                    $task->description = $request->description;
                    $task->due_date = $request->due_date;
                    $task->reminder_date = $request->reminder_date;
                    $task->tag = $request->tag;
                    $task->save();
                } catch (QueryException $e){
                    return redirect()->back()->withErrors('Due and reminder dates are both required. You should also verify that selected reminder date is before due date and that both after today.');
                }
                
                if ($request->user_id == -1){
                    $user_assigned = UserAssign::where('task_id', '=', $id)
                                            ->delete(['user_id'=>$request->user_id]);
                    break;
                }

                $user_assigned = UserAssign::where('task_id', '=', $id)
                                            ->update(['user_id'=>$request->user_id]);

                $user_assigned = json_decode($user_assigned, true);

                if (!$user_assigned){
                    $user_assign = new UserAssign;
                    $user_assign->task_id = $task->id;
                    $user_assign->user_id = $request->user_id;
                    $user_assign->save();
                }

                break;

            case 'delete':
                Gate::authorize('manager',Project::find($project_id));

                $task=Task::find($id);

                $user_assigned = UserAssign::where('task_id', '=', $id)
                                            ->delete(['user_id'=>$request->user_id]);

                $task->delete();
                
                break;
        }

       return redirect('project/'.$project_id.'/tasks');
    }

    public function showTasks($project_id)
    {
        Gate::authorize('inProject',Project::find($project_id));
        $notifications = NotificationsController::getNotifications(Auth::id());

        $my_TASKS = DB::table('tasks')
                        ->leftjoin('userassigns', 'tasks.id', '=', 'userassigns.task_id')
                        ->leftjoin('users', 'users.id', '=', 'userassigns.user_id')
                        ->where('tasks.project_id', $project_id)
                        ->orderby('tasks.due_date')
                        ->get(['tasks.id','name','description','due_date','username', 'tasks.tag']);
        $my_TASKS = json_decode($my_TASKS,true);

        return view('pages.tasks',['tasks' => $my_TASKS, 'tasks', 'project' => Project::find($project_id), 'notifications' => $notifications]);

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     *
     */
    protected function createTask(Request $request)
    {
        Gate::authorize('manager',Project::find($request->project_id));
        try {
            $notifications = NotificationsController::getNotifications(Auth::id());
            $validator = $request->validate($this->validator());

            $task = new Task();
            $task->name = $request->name;
            $task->description = $request->description;
            $task->due_date = $request->due_date;
            $task->reminder_date = $request->reminder_date;
            $task->tag = $request->tag;
            $task->project_id = $request->project_id;
            $task->creator_id = Auth::id();
            $task->created_at = Carbon::now();
            $task->save();
        } catch (QueryException $e){
            return redirect()->back()->withErrors('Due and reminder dates are both required. You should also verify that selected reminder date is before due date and that both after today.');
        }

        return redirect('project/'.$request->project_id.'/tasks');
    }

    public function searchProjectTasks(int $project_id, Request $request)
    {
        return DB::table('tasks')
                            ->where('project_id', '=', $project_id)
                            ->whereRaw("(name like '%".$request->search."%'
                                                or description like '%".$request->search."%'
                                                or CAST(due_date AS VARCHAR) like '%".$request->search."%'
                                                or CAST(tag AS VARCHAR) like '".$request->search."%')")
                            ->orderBy('due_date')
                            ->paginate(10);
    }
}

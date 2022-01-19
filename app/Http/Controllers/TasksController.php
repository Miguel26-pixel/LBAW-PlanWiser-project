<?php

namespace App\Http\Controllers;

use App\Models\ProjectUser;
use App\Models\Task;
use App\Models\Project;
use App\Models\UserAssign;
use App\Models\TaskComment;
use App\Models\Notification;
use App\Events\AssignTask;
use App\Events\ClosedTask;
use Illuminate\Support\Facades\Config;
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
        Gate::authorize('isActive',Project::find($id));
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

        $taskComments = TaskCommentsController::getTaskComments($id);

        $user_assigned = DB::table('userassigns')
                            ->leftjoin('users', 'users.id', '=', 'userassigns.user_id')
                            ->where('task_id', '=', $id)
                            ->get(['userassigns.user_id','users.username']);

        $user_assigned = json_decode($user_assigned, true);

        $project_user = ProjectUser::find(['user_id' => Auth::id(),'project_id' => $project_id]);
        if (!$project_user) {
            $user_role = 'GUEST';
        } else {
            $user_role = $project_user->user_role;
        }

        return view('pages.task',['user_role' => $user_role,
                                    'project' => Project::find($project_id),
                                    'task' => Task::find($id),
                                    'notifications' => $notifications,
                                    'users' => $users,
                                    'user_assigned' => $user_assigned,
                                    'task_comments' => $taskComments]);
    }


    public function updateTask(int $project_id, int $id, Request $request) {
        Gate::authorize('isActive',Project::find($project_id));
        $notifications = NotificationsController::getNotifications(Auth::id());
        switch ($request->input('action'))
        {
            case 'update':
                Gate::authorize('update',Task::find($id));
                $validator = $request->validate($this->validator());
                $proj = Project::find($project_id);
                try {
                    $task = Task::find($id);
                    $task->name = $request->name;
                    $task->description = $request->description;
                    $task->due_date = $request->due_date;
                    $task->reminder_date = $request->reminder_date;
                    $task->tag = $request->tag;

                    if($request->tag == 'CLOSED') {
                        $managers = Project::find($project_id)->managers;
                        $assignee = $task->assignee;
                        $notification = new Notification();
                        $notification->user_id = $assignee->user_id;
                        $notification->notification_type = 'COMPLETE_TASK';
                        $notification->task_id = $task->id;
                        $notification->created_at = now();
                        $notification->save();

                        event(new ClosedTask($request->name, $proj->title, $assignee->user_id, $notification->id));

                        foreach ($managers as $manager) {
                            $notification = new Notification();
                            $notification->notification_type = 'COMPLETE_TASK';
                            $notification->user_id = $manager->id;
                            $notification->task_id = $task->id;
                            $notification->created_at = now();
                            $notification->save();

                            event(new ClosedTask($request->name, $proj->title, $manager->id, $notification->id));
                        }
                    }

                    $task->save();
                } catch (QueryException $e){
                    return redirect()->back()->withErrors('Due and reminder dates are both required. You should also verify that selected reminder date is before due date and that both after today.');
                }

                if ($request->user_id == -1){
                    UserAssign::where('task_id', '=', $id)->delete(['user_id' =>$request->user_id]);
                    break;
                }

                $user_assigned = UserAssign::where('task_id', '=', $id)
                                            ->update(['user_id' =>$request->user_id]);

                $user_assigned = json_decode($user_assigned, true);

                if (!$user_assigned){
                    $user_assign = new UserAssign;
                    $user_assign->task_id = $task->id;
                    $user_assign->user_id = $request->user_id;

                    $notification = new Notification();
                    $notification->user_id = $request->user_id;
                    $notification->notification_type = 'ASSIGN';
                    $notification->task_id = $task->id;
                    $notification->created_at = now();
                    $notification->save();


                    $user_assign->save();

                    event(new AssignTask($request->name, $proj->title, $request->user_id, $notification->id));
                }

                break;

            case 'delete':
                Gate::authorize('manager',Project::find($project_id));
                $task=Task::find($id);
                $task->delete(); //returns true/false
        }

        return redirect('project/'.$project_id.'/tasks');
    }

    public function showTasks($project_id)
    {
        Gate::authorize('show',Project::find($project_id));
        $notifications = NotificationsController::getNotifications(Auth::id());
        $users = ProjectUsersController::getProjectUsers($project_id);
        $project_user = ProjectUser::find(['user_id' => Auth::id(),'project_id' => $project_id]);
        if (!$project_user) {
            $user_role = 'GUEST';
        } else {
            $user_role = $project_user->user_role;
        }

        $my_TASKS = DB::table('tasks')
                        ->leftjoin('userassigns', 'tasks.id', '=', 'userassigns.task_id')
                        ->leftjoin('users', 'users.id', '=', 'userassigns.user_id')
                        ->where('tasks.project_id', $project_id)
                        ->orderby('tasks.due_date')
                        ->get(['tasks.id','name','description','due_date','username', 'tasks.tag']);
        $my_TASKS = json_decode($my_TASKS,true);
        return view('pages.tasks',['user_role' => $user_role,'tasks' => $my_TASKS, 'tasks', 'project' => Project::find($project_id), 'notifications' => $notifications, 'users' => $users]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     *
     */
    protected function create(Request $request)
    {
        $proj = Project::find($request->project_id);
        Gate::authorize('isActive',$proj);
        Gate::authorize('manager',$proj);
        try {
            $notifications = NotificationsController::getNotifications(Auth::id());
            $validator = $request->validate($this->validator());
            $task = new Task;
            $task->name = $request->name;
            $task->description = $request->description;
            $task->due_date = $request->due_date;
            $task->reminder_date = $request->reminder_date;
            $task->tag = $request->tag;
            $task->project_id = $request->project_id;
            $task->creator_id = Auth::id();
            $task->created_at = Carbon::now();
            $task->save();

            if ($request->user_id != -1) {
                $user_assign = new UserAssign;
                $user_assign->task_id = $task->id;
                $user_assign->user_id = $request->user_id;
                //dd(Config::get('broadcasting'));

                $notification = new Notification();
                $notification->user_id = $request->user_id;
                $notification->notification_type = 'ASSIGN';
                $notification->task_id = $task->id;
                $notification->created_at = now();
                $notification->save();

                $user_assign->save();

                event(new AssignTask($request->name, $proj->title, $request->user_id, $notification->id));
            }
        } catch (QueryException $e){
            return redirect()->back()->withErrors('Due and reminder dates are both required. You should also verify that selected reminder date is before due date and that both after today.');
        }
        return redirect()->action([TasksController::class,'showTasks'], ['id'=> $task->project_id]);
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
                            ->get();
    }
}

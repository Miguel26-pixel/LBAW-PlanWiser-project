<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProjectsController extends Controller
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

    static function getMyProjects(){
        $project_users = ProjectUser::where('user_id','=',Auth::id())->pluck('project_id');
        //dd($project_users);
        $myprojects = Project::whereIn('id', $project_users)->paginate(10);
        return $myprojects;
    }

    static function getPublicProjects($pag_num) {
        return (new Project())->where('public','=',true)->orderByDesc('created_at')->paginate($pag_num);
    }

    public function showProjects()
    {
        $project_users = ProjectUser::where('user_id','=',Auth::id())->pluck('project_id');
        $projects = Project::where('public','=',true)
                            ->orWhereIn('id', $project_users)
                            ->orderByDesc('created_at')
                            ->paginate(10);
        $notifications = NotificationsController::getNotifications(Auth::id());
        return view('pages.projects',['my_projects' => $projects, 'notifications' => $notifications]);
    }

    public static function searchPublicProjects(Request $request){
        return DB::table('projects')
                            ->where('public','=',true)
                            ->whereRaw('(title like \'%'.$request->search.'%\' or description like \'%'.$request->search.'%\' or search @@ plainto_tsquery(\'english\', ?))',[$request->search])
                            ->orderByDesc('created_at')
                            ->get();
    }

    public function searchMyProjects(Request $request){
        $project_users = ProjectUser::where('user_id','=',Auth::id())->pluck('project_id');
        if($request->myprojects === "true"){
            return  DB::table('projects')
                ->whereIn('id', $project_users)
                ->whereRaw('(title like \'%'.$request->search.'%\' or description like \'%'.$request->search.'%\' or search @@ plainto_tsquery(\'english\', ?))',[$request->search])
                ->orderByDesc('created_at')
                ->get();
        } else {
            $s = "(";
            foreach ($project_users as $project_user) { $s .= $project_user.','; }
            $s = substr_replace($s ,")",-1);
            return DB::table('projects')
                            ->whereRaw('(public is true or id in '.$s.')')
                            ->whereRaw('(title like \'%'.$request->search.'%\' or description like \'%'.$request->search.'%\' or search @@ plainto_tsquery(\'english\', ?))',[$request->search])
                            ->orderByDesc('created_at')
                            ->get();
        }
    }
}

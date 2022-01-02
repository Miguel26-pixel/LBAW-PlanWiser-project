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
        $myprojects = Project::whereIn('id', $project_users)->paginate(10);
        return $myprojects;
    }

    static function getPublicProjects($pag_num) {
        return (new Project())->where('public','=',true)->orderBy('created_at')->paginate($pag_num);
    }

    public function showProjects()
    {
        $projects = self::getPublicProjects(10);
        $myprojects = self::getMyProjects();
        $notifications = NotificationsController::getNotifications(Auth::id());
        return view('pages.projects',['public_projects' => $projects, 'my_projects' => $myprojects, 'notifications' => $notifications]);
    }

    public static function searchPublicProjects(Request $request){
        return DB::table('projects')
                            ->where('public','=',true)
                            ->whereRaw('(title like \'%'.$request->search.'%\' or description like \'%'.$request->search.'%\' or search @@ to_tsquery(\'english\', ?))',[$request->search])
                            ->orderBy('created_at')
                            ->paginate(10);
    }

    public function searchMyProjects(Request $request){
        $project_users = ProjectUser::where('user_id','=',Auth::id())->pluck('project_id');
        return  DB::table('projects')
                    ->whereIn('id', $project_users)
                    ->whereRaw('(title like \'%'.$request->search.'%\' or description like \'%'.$request->search.'%\' or search @@ to_tsquery(\'english\', ?))',[$request->search])
                    ->orderBy('created_at')
                    ->paginate(10);
    }
}

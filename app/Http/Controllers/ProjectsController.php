<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    public function showProjects()
    {
        $project_users = ProjectUser::where('user_id','=',Auth::id())->pluck('project_id');
        $myprojects = Project::whereIn('id', $project_users)->paginate(10);
        $projects = self::getPublicProjects(10);
        return view('pages.projects',['public_projects' => $projects, 'my_projects' => $myprojects]);
    }

    static function getPublicProjects($pag_num) {
        return (new Project())->where('public','=',true)->orderBy('created_at')->paginate($pag_num);
    }
}

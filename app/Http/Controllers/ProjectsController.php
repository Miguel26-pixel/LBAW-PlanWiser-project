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
    public function showProjects()
    {
        $project_users = ProjectUser::where('user_id','=',Auth::id())->pluck('project_id');
        $myprojects = Project::whereIn('id', $project_users)->paginate(10);
        $projects = self::getPublicProjects();
        return view('pages.projects',['public_projects' => $projects, 'my_projects' => $myprojects]);
    }

    public function showProjectsForm()
    {
        return view('pages.projectsCreate');
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function validator()
    {
       return  [
            'title' => ['required','string'],
            'description' => ['required','string'],
            'public' => 'boolean',
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

        $project = new Project;

        $project->title = $request->title;
        $project->description = $request->description;
        $project->public = $request->public;
        $project->active = true;
        $project->created_at = Carbon::now();
        $project->save();
        $project = Project::where('title','=',$request->title)->first();

        $project_user = new ProjectUser();

        $project_user->project_id = $project->id;
        $project_user->user_id = Auth::id();
        $project_user->user_role = 'MANAGER';

        $project_user->save();

        return redirect()->back();
    }

    static function getPublicProjects() {
        return (new Project())->where('public','=',true)->orderBy('created_at')->paginate(10);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
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

    public function showProject($id) {
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
    }

    public function showProjectForm()
    {
        return view('pages.projectsCreate');
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

        if($request->public == "True")
            $project->public = true;
        else 
            $project->public = false;

        $project->active = true;
        $project->created_at = Carbon::now();
        $project->save();
        $project = Project::where('title','=',$request->title)->first();

        $project_user = new ProjectUser();

        $project_user->project_id = $project->id;
        $project_user->user_id = Auth::id();
        $project_user->user_role = 'MANAGER';

        $project_user->save();

        return redirect("/projects");
    }

}


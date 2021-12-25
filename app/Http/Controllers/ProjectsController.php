<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProjectsController extends Controller
{

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

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator()
    {
       return  [
            'title' => ['required','string'],
            'description' => ['required','string'],
            'public' => 'boolean',
            'active' => 'boolean',
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
        $project->active = $request->active;
        $project->save();

        return redirect()->back();
    }
}

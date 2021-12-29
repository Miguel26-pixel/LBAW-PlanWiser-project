<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Project;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class HomepageController extends Controller
{

    public function show()
    {
        $public_projects = ProjectsController::getPublicProjects(6);
        return view('pages.homepage',['public_projects'=> $public_projects]);
    }

    public function searchProjects(Request $request){
        $public_projects=ProjectsController::searchPublicProjects($request);
        return view('pages.homepage',['public_projects'=> $public_projects]);

    }
}

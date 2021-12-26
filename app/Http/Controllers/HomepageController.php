<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Project;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class HomepageController extends Controller
{

    public function show()
    {
        $projects = ProjectsController::getPublicProjects(6);
        return view('pages.homepage', $projects);
    }
}

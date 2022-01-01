<?php

namespace App\Http\Controllers;


class AdminController extends Controller
{

    public function show()
    {
        $public_projects = ProjectsController::getPublicProjects(6);
        return view('pages.admin.user');
    }

}

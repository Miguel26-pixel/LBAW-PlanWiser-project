<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomepageController extends Controller
{

    public function show()
    {
        $public_projects = ProjectsController::getPublicProjects(6);
        $notifications = NotificationsController::getNotifications(Auth::id());
        $view = Auth::user()->is_admin ? view('pages.admin.user', ['public_projects' => $public_projects, 'notifications' => $notifications]) : view('pages.homepage', ['public_projects' => $public_projects, 'notifications' => $notifications]);
        return $view;
    }

    public function searchProjects(Request $request)
    {
        //dd($request);
        return ProjectsController::searchPublicProjects($request);
    }
}

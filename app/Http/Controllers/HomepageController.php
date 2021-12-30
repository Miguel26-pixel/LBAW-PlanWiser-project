<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Project;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\NotificationsController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
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
        $public_projects = ProjectsController::searchPublicProjects($request);
        $notifications = NotificationsController::getNotifications(Auth::id());
        return view('pages.homepage', ['public_projects' => $public_projects, 'notifications' => $notifications]);
    }
}
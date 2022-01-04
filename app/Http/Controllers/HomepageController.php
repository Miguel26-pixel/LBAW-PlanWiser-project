<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomepageController extends Controller
{

    public function show()
    {
        if(Auth::user() == null){
            return redirect('/');
        }
        $public_projects = ProjectsController::getPublicProjects(6);
        $notifications = NotificationsController::getNotifications(Auth::id());
        if(Auth::user()->is_admin){
           return redirect('/admin');
        }
        return view('pages.homepage', ['public_projects' => $public_projects, 'notifications' => $notifications]);
    }

    public function searchProjects(Request $request)
    {
        //dd($request);
        return ProjectsController::searchPublicProjects($request);
    }
}

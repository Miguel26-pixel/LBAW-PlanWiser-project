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
        if(Auth::user()->is_admin){
           $users = UsersController::getUsers();
           return redirect()->action([AdminController::class,'show'], ['users'=> $users, 'public_projects' => $public_projects,'notifications' => $notifications]);
        }
        $view = view('pages.homepage', ['public_projects' => $public_projects, 'notifications' => $notifications]);
        return $view;
    }

    public function searchProjects(Request $request)
    {
        return ProjectsController::searchPublicProjects($request);
    }
}

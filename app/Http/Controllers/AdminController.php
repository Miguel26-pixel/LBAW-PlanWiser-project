<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function show()
    {
        $public_projects = ProjectsController::getPublicProjects(6);
        $users = UsersController::getUsers();
        return view('pages.admin.home', ['public_projects'=>$public_projects, 'users'=>$users]);
    }

    public function showReports()
    {
        $public_projects = ReportsController::getReports();
        return view('pages.admin.reports', ['public_projects'=>$public_projects]);

    }

    public function showUsersManagement()
    {
        $users = UsersController::getUsers();
        return view('pages.admin.manageUsers',['users' => $users]);
    }

    public function showProjects()
    {
        $public_projects = ProjectsController::getPublicProjects(6);
        return view('pages.admin.projects', ['public_projects'=>$public_projects]);
    }

    public function showProfile(int $id)
    {
        $user = UsersController::getUser($id);
        return view('pages.admin.profile',['user' => $user]);
    }

    public function showUsers()
    {
        $users = UsersController::getUsers();
        return view('pages.admin.manageUsers',['users' => $users]);
    }

    public function searchUsers(Request $request){
        $users = UsersController::getUsersSearch($request);
        return view('pages.admin.manageUsers', ['users'=>$users]);  
    }

    public function showUsersForm()
    {
        return view('pages.admin.createUser');
    }

    public function createUser(Request $request)
    {
        $user = UsersController::createUser($request);
        return redirect()->action([self::class,'showProfile'], ['id'=> $user->id]);

    }

}

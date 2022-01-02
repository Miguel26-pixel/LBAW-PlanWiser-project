<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{

    public function show()
    {
        Gate::authorize('admin',User::class);
        $public_projects = ProjectsController::getPublicProjects(6);
        $users = UsersController::getUsers();
        return view('pages.admin.home', ['public_projects'=>$public_projects, 'users'=>$users]);
    }

    public function showReports()
    {
        Gate::authorize('admin',User::class);
        $public_projects = ReportsController::getReports();
        return view('pages.admin.reports', ['public_projects'=>$public_projects]);

    }

    public function showUsersManagement()
    {
        Gate::authorize('admin',User::class);
        $users = UsersController::getUsers();
        return view('pages.admin.manageUsers',['users' => $users]);
    }

    public function showProjects()
    {
        Gate::authorize('admin',User::class);
        $public_projects = ProjectsController::getPublicProjects(6);
        return view('pages.admin.projects', ['public_projects'=>$public_projects]);
    }

    public function showProfile(int $id)
    {
        Gate::authorize('admin',User::class);
        $user = UsersController::getUser($id);
        return view('pages.admin.profile',['user' => $user]);
    }

    public function showUsers()
    {
        Gate::authorize('admin',User::class);
        $users = UsersController::getUsers();
        return view('pages.admin.manageUsers',['users' => $users]);
    }

    public function searchUsers(Request $request){
        Gate::authorize('admin',User::class);
        $users = UsersController::getUsersSearch($request);
        return view('pages.admin.manageUsers', ['users'=>$users]);
    }

    public function showUsersForm()
    {
        Gate::authorize('admin',User::class);
        return view('pages.admin.createUser');
    }

    public function createUser(Request $request)
    {
        Gate::authorize('admin',User::class);
        $user = UsersController::createUser($request);
        return redirect()->action([self::class,'showProfile'], ['id'=> $user->id]);

    }

}

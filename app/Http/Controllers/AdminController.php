<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    private function validation()
    {
        return Auth::user()->is_admin;
    }

    public function show()
    {
        if (!$this->validation()) 
            return redirect('/home');

        Gate::authorize('admin',User::class);
        $public_projects = ProjectsController::getPublicProjects(6);
        $users = UsersController::getUsers();
        return view('pages.admin.home', ['public_projects'=>$public_projects, 'users'=>$users]);
    }

    public function showReports()
    {
        if (!$this->validation()) 
            return redirect('/home');

        Gate::authorize('admin',User::class);
        $public_projects = ReportsController::getReports();
        return view('pages.admin.reports', ['public_projects'=>$public_projects]);

    }

    public function showUsersManagement()
    {
        if (!$this->validation()) 
            return redirect('/home');

        Gate::authorize('admin',User::class);
        $users = UsersController::getUsers();
        return view('pages.admin.manageUsers',['users' => $users]);
    }

    public function showProjects()
    {
        if (!$this->validation()) 
            return redirect('/home');

        Gate::authorize('admin',User::class);
        $public_projects = ProjectsController::getPublicProjects(6);
        return view('pages.admin.projects', ['public_projects'=>$public_projects]);
    }

    public function showProfile(int $id)
    {
        if (!$this->validation()) 
            return redirect('/home');

        Gate::authorize('admin',User::class);
        $user = UsersController::getUser($id);
        return view('pages.admin.profile',['user' => $user]);
    }

    public function showUsers()
    {
        if (!$this->validation()) 
            return redirect('/home');

        Gate::authorize('admin',User::class);
        $users = UsersController::getUsers();
        return view('pages.admin.manageUsers',['users' => $users]);
    }

    public function searchUsers(Request $request){
        if (!$this->validation()) 
            return redirect('/home');

        Gate::authorize('admin',User::class);
        $users = UsersController::getUsersSearch($request);
        return view('pages.admin.manageUsers', ['users'=>$users]);
    }

    public function showUsersForm()
    {
        if (!$this->validation()) 
            return redirect('/home');

        Gate::authorize('admin',User::class);
        return view('pages.admin.createUser');
    }

    public function createUser(Request $request)
    {
        if (!$this->validation()) 
            return redirect('/home');

        $user = UsersController::createUser($request);

        return redirect('admin/profile/'.$user->id);
        Gate::authorize('admin',User::class);
        $user = UsersController::createUser($request);
        return redirect()->action([self::class,'showProfile'], ['id'=> $user->id]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

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

        $public_projects = ProjectsController::getPublicProjects(6);
        $users = UsersController::getUsers();
        return view('pages.admin.home', ['public_projects'=>$public_projects, 'users'=>$users]);
    }

    public function showReports()
    {
        if (!$this->validation()) 
            return redirect('/home');

        $public_projects = ReportsController::getReports();
        return view('pages.admin.reports', ['public_projects'=>$public_projects]);

    }

    public function showUsersManagement()
    {
        if (!$this->validation()) 
            return redirect('/home');

        $users = UsersController::getUsers();
        return view('pages.admin.manageUsers',['users' => $users]);
    }

    public function showProjects()
    {
        if (!$this->validation()) 
            return redirect('/home');

        $public_projects = ProjectsController::getPublicProjects(6);
        return view('pages.admin.projects', ['public_projects'=>$public_projects]);
    }

    public function showProfile(int $id)
    {
        if (!$this->validation()) 
            return redirect('/home');

        $user = UsersController::getUser($id);
        return view('pages.admin.profile',['user' => $user]);
    }

    public function showUsers()
    {
        if (!$this->validation()) 
            return redirect('/home');

        $users = UsersController::getUsers();
        return view('pages.admin.manageUsers',['users' => $users]);
    }

    public function searchUsers(Request $request){
        if (!$this->validation()) 
            return redirect('/home');

        $users = UsersController::getUsersSearch($request);
        return view('pages.admin.manageUsers', ['users'=>$users]);  
    }

    public function showUsersForm()
    {
        if (!$this->validation()) 
            return redirect('/home');

        return view('pages.admin.createUser');
    }

    public function createUser(Request $request)
    {
        if (!$this->validation()) 
            return redirect('/home');

        $user = UsersController::createUser($request);

        return redirect('admin/profile/'.$user->id);
    }

}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ProjectsController;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function getUser(){
        return $request->user();
    }

    public function home() {
        $public_projects = ProjectsController::getPublicProjects(6);
        $view = Auth::user()->is_admin ? view('pages.admin.user', ['public_projects' => $public_projects]) : view('pages.homepage', ['public_projects' => $public_projects]);
        return $view;
    }
}

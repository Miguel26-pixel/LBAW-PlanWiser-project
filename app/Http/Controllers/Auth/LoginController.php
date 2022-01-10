<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\UsersController;
use App\Mail\RecoverPassword;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function getUser(Request $request){
        return $request->user();
    }

    public function home() {
        dd(1);
        $public_projects=ProjectsController::getPublicProjects(6);
        $notifications = NotificationsController::getNotifications(Auth::id());
        return view('pages.homepage', ['public_projects' => $public_projects, 'notifications' => $notifications]);
    }

    public function recoverPassword(Request $request) {
        request()->validate(['email' => 'required|email']);
        $user = User::where('email','=',$request->email)->first();
        if (!$user)  {
            return redirect()->back()->withErrors('There are no users with the email. Please enter a valid email');
        }
        $pass = Str::random(15);
        $user->password = Hash::make($pass);
        $user->save();
        Mail::to($request->email)->send(new RecoverPassword($user,$pass));

        return redirect('/');
    }

    public function showRecoverForm() {
        return view('auth.recover');
    }
}

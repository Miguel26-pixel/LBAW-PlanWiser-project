<?php

namespace App\Http\Controllers;

use App\Mail\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HomepageController extends Controller
{

    public function show()
    {
        if(Auth::user() == null){
            return redirect('/');
        }
        $public_projects = ProjectsController::getPublicProjects(6);
        $notifications = NotificationsController::getNotifications(Auth::id());
        return view('pages.homepage', ['public_projects' => $public_projects, 'notifications' => $notifications]);
    }

    public function searchProjects(Request $request)
    {
        //dd($request);
        return ProjectsController::searchPublicProjects($request);
    }

    public function sendEmail(Request $request) {
        request()->validate(['email' => 'required|email']);

        Mail::to(env('MAIL_SUPPORT_ADDRESS'))->send(new ContactUs($request));

        return redirect()->back();
    }
}

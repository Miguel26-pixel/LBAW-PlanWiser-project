<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class ReportsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showReportBugForm()
    {
        $notifications = NotificationsController::getNotifications(Auth::id());
        return view('pages.reportBug', ['notifications' => $notifications]);
    }

    public function showReportUserForm($id)
    {
        $notifications = NotificationsController::getNotifications(Auth::id());
        $reported = User::find($id);
        return view('pages.reportUser', ['notifications' => $notifications,'reported' => $reported]);
    }

    protected function validator()
    {
        return  [
            'text' => ['required','string'],
        ];
    }



    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     *
     */
    protected function create(Request $request)
    {
        $notifications = NotificationsController::getNotifications(Auth::id());

        $validator = $request->validate($this->validator());

        $report = new Report();
        $report->text = $request->text;
        $report->user_id = Auth::id();
        $report->report_type = $request->radio;
        $report->created_at = Carbon::now();
        Gate::authorize('create',$report);

        if ($request->radio == "USER") {
            $reported = User::where('username','=',$request->username)->first();
            if (!$reported) {
                return redirect()->back()->withErrors('There are no users with the given username');
            }
            $report->reported_user_id = $reported->id;
        } else {
            $reported = null;
        }
        $report->save();

        Mail::to(env('MAIL_FROM_ADDRESS'))->send(new \App\Mail\Report($report,User::find(Auth::id()),$reported));

        return redirect('/profile/'.Auth::id());
    }

    public function reportBug(Request $request) {
        $validator = $request->validate($this->validator());

        $report = new Report();
        $report->text = $request->text;
        $report->user_id = Auth::id();
        $report->report_type = "BUG";
        $report->created_at = Carbon::now();
        Gate::authorize('create',$report);
        $report->save();
        Mail::to(env('MAIL_FROM_ADDRESS'))->send(new \App\Mail\Report($report,User::find(Auth::id()),null));
        return redirect('/profile/'.Auth::id());
    }

    public function reportUser($id,Request $request) {
        $validator = $request->validate($this->validator());

        $report = new Report();
        $report->text = $request->text;
        $report->user_id = Auth::id();
        $report->report_type = "USER";
        $report->created_at = Carbon::now();
        Gate::authorize('create',$report);
        $reported = User::find($id);
        if (!$reported) {
            return redirect()->back()->withErrors('There are no users with the given username');
        }
        if (Auth::id() == $reported->id) {
            return redirect()->back()->withErrors("You can't report your own account");
        }
        $report->reported_user_id = $reported->id;
        $report->save();
        Mail::to(env('MAIL_FROM_ADDRESS'))->send(new \App\Mail\Report($report,User::find(Auth::id()),$reported));
        return redirect('/profile/'.$id.'/view');
    }

    static function getReports()
    {
        return Report::orderBy('created_at')->paginate(10);
    }
}

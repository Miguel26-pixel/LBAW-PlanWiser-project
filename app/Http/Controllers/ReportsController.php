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

    public function showReportForm()
    {
        $notifications = NotificationsController::getNotifications(Auth::id());
        return view('pages.reportsCreate', ['notifications' => $notifications]);
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

        return redirect()->back();
    }

    static function getReports()
    {
        return Report::orderBy('created_at')
                       ->paginate(10);

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $report = new Report;
        $report->text = $request->text;
        $report->user_id = Auth::id();
        $report->report_type = $request->report_type;
        $report->created_at = Carbon::now();
        $report->save();

        return redirect()->back();
    }
}

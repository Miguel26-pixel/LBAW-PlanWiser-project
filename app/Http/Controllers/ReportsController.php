<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Report;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    /*public function showProject($id) {
        $user = Auth::user();
        $projects = $user->projects;
        $project = Project::find($id);
        $check = false;
        foreach ($projects as $p) {
            if ($p->id == $project->id) $check=true;
            if (!(Auth::user()->is_admin || $check || $p->public)) {
                return redirect('/');
        }
    }
        if (!(Auth::user()->is_admin || $check || $project->public)) {
            return redirect('/');
        }
        return view('pages.project',['project' => Project::find($id)]);
    }*/

    public function showReportForm()
    {
        return view('pages.reportsCreate');
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

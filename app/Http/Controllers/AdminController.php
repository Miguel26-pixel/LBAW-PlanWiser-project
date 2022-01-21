<?php

namespace App\Http\Controllers;

use App\Mail\ReportAnswer;
use App\Models\Project;
use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    public function show()
    {
        Gate::authorize('admin',User::class);
        $public_projects = Project::orderByDesc('created_at')->take(5)->get();
        $users = User::orderByDesc('id')->take(3)->get();
        return view('pages.admin.home', ['public_projects'=>$public_projects, 'users'=>$users]);
    }

    public function showReports()
    {
        Gate::authorize('admin',User::class);
        $reports = ReportsController::getReports();
        return view('pages.admin.reports', ['reports'=>$reports,'pending' => false,'type' => ""]);
    }

    public function showReportForm($id) {
        Gate::authorize('admin',User::class);
        $report = Report::find($id);
        return view('pages.admin.answer_report', ['report'=>$report]);
    }

    public function answerReport($id, Request $request) {
        switch ($request->action) {
            case 'done':
                if ($request->message == null) {
                    return redirect()->back()->withErrors('Answer cannot be empty');
                }
                $report = Report::find($id);
                Mail::to($report->user->email)->send(new ReportAnswer($request->message,$report,$report->user));
                $report->report_state = 'DONE';
                $report->save();
                break;
            case 'ignore':
                $report = Report::find($id);
                $report->report_state = 'IGNORED';
                $report->save();
                break;
        }
        return redirect('/admin/reports');
    }

    public function searchReports(Request $request) {
        Gate::authorize('admin',User::class);
        if ($request->pending == 'on') {
            $reports = Report::join('users','reports.user_id','=','users.id')
                ->where('report_state','=','PENDING')
                ->where('report_type','=',$request->type)
                ->whereRaw('(users.username like \'%'.$request->search.'%\' or reports.text like \'%'.$request->search.'%\')')
                ->paginate(10);
        } else {
            $reports = Report::join('users','reports.user_id','=','users.id')
                                ->where('report_type','=',$request->type)
                                ->whereRaw('(users.username like \'%'.$request->search.'%\' or reports.text like \'%'.$request->search.'%\')')
                                ->paginate(10);
        }
        return view('pages.admin.reports', ['reports'=>$reports,'pending' => $request->pending == 'on','type' => $request->type]);
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
        $projects = Project::orderByDesc('created_at')->paginate(10);
        return view('pages.admin.projects', ['public_projects'=>$projects]);
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

    protected function validator()
    {
        return [
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|unique:users|string|min:4',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    public function createUser(Request $request)
    {
        Gate::authorize('admin',User::class);
        $request->validate($this->validator());
        $user = new User();
        $user->fullname = $request->fullname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        if ($request->is_admin === "true") {
            $user->is_admin = true;
        }
        $user->save();

        return redirect('/admin/profile/'.$user->id);
    }

    public function deleteUser($id)
    {
        Gate::authorize('admin',User::class);
        $user = User::find($id);
        $count = User::where('email','like','%@deleted_user.com')->count();
        $user->fullname = "Deleted User";
        $user->username = "deleted_user_".$count;
        $user->email = "deleted_user_".$count."@deleted_user.com";
        $user->password = Hash::make('139cd5119d398d06f6535f42d775986a683a90e16ce129a5fb7f48870613a1a5');
        $user->img_url = null;
        $user->is_admin = false;
        $user->search = null;
        $user->save();
        return redirect('/admin/manageUsers');
    }

    public function banUser($id) {
        Gate::authorize('admin',User::class);
        $user = User::find($id);
        if ($user->is_admin) {
            return redirect()->back()->withErrors("This user is an an admin so you can't ban his account");
        }
        $user->is_banned = true;
        $user->save();
        return redirect()->back();
    }

    public function unbanUser($id) {
        Gate::authorize('admin',User::class);
        $user = User::find($id);
        $user->is_banned = false;
        $user->save();
        return redirect()->back();
    }
}

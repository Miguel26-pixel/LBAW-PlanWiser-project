<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use App\Models\UserAssigns;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProjectUsersController extends Controller
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

    public function showProjectUsers($project_id)
    {
        $myusers = DB::table('users')
                        ->join('projectusers', 'users.id', '=', 'projectusers.user_id')
                        ->where('projectusers.project_id', $project_id)
                        ->get(['username','email','user_role']);
        $myusers = json_decode($myusers,true);
        return view('pages.projectUsers',['project_users' => $myusers,'project' => Project::find($project_id)]);
    }

    static function getPublicProjects($pag_num) {
        return (new Project())->where('public','=',true)->orderBy('created_at')->paginate($pag_num);
    }
}

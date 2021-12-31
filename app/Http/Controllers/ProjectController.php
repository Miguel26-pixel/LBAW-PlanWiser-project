<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FavoriteProject;
use App\Models\Project;
use App\Models\ProjectFile;
use App\Models\ProjectUser;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Notification;
use App\Http\Controllers\NotificationsController;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use ZipArchive;

class ProjectController extends Controller
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

    public function showProject($id) {
        $notifications = NotificationsController::getNotifications(Auth::id());        
        $check = $this->checkUserInProject($id);
        $project = Project::find($id);
        $user = Auth::user();
        if (!(Auth::user()->is_admin || $check || $project->public)) { return redirect('/'); }
        $admins = $project->managers;
        $members = $project->members;
        $guests = $project->guests;
        $num_favs = $project->getNumFavs();
        $is_fav = FavoriteProject::where('user_id' ,'=', $user->id)->where('project_id','=',$id)->exists();
        return view('pages.project',['project' => $project,'admins' => $admins, 'members' => $members, 'guests' => $guests, 'is_fav' => $is_fav, 'num_favs' => $num_favs, 'notifications' => $notifications]);
    }

    public function showProjectFiles($id) {
        $notifications = NotificationsController::getNotifications(Auth::id());  
        $check = $this->checkUserInProject($id);
        $project = Project::find($id);
        if (!(Auth::user()->is_admin || $check || $project->public)) { return redirect('/'); }
        $files = $project->files;
        return view('pages.projectFiles',['project' => $project,'files' => $files, 'notifications' => $notifications]);
    }

    public function showProjectForm()
    {
        $notifications = NotificationsController::getNotifications(Auth::id());
        return view('pages.projectsCreate', ['notifications' => $notifications]);
    }

    public function addFavorite($id) {
        $check = $this->checkUserInProject($id);
        if ($check) {
            $fav = new FavoriteProject();
            $fav->project_id = $id;
            $fav->user_id = Auth::id();
            $fav->save();
        }
        return redirect()->back();
    }

    public function removeFavorite($id) {
        $check = $this->checkUserInProject($id);
        if ($check) {
            $fav = FavoriteProject::find(['user_id' => Auth::id(),'project_id' => $id]);
            $fav->delete();
        }
        return redirect()->back();
    }

    protected function validator()
    {
        return  [
            'title' => ['required','string'],
            'description' => ['required','string'],
            'public' => 'boolean',
        ];
    }

    protected function create(Request $request)
    {

        $notifications = NotificationsController::getNotifications(Auth::id());
        $validator = $request->validate($this->validator());

        $project = new Project;

        $project->title = $request->title;
        $project->description = $request->description;

        if($request->public == "True")
            $project->public = true;
        else
            $project->public = false;

        $project->active = true;
        $project->created_at = Carbon::now();
        $project->save();
        $project = Project::where('title','=',$request->title)->first();

        $project_user = new ProjectUser();

        $project_user->project_id = $project->id;
        $project_user->user_id = Auth::id();
        $project_user->user_role = 'MANAGER';

        $project_user->save();

        return redirect("/projects", ['notifications' => $notifications]);
    }

    public function uploadFiles($id, Request $request) {
        $check = $this->checkUserInProject($id);
        if (!$check) {
            return redirect()->back();
        }
        foreach ($request->input_files as $file) {
            $pfile = new ProjectFile();
            $pfile->name = $file->getClientOriginalName();
            $this->checkFileName($id,$pfile->name);
            $pfile->url = 'project_'.$id.'/'.$file->hashName();
            $pfile->project_id = $id;
            Storage::disk('public')->putFile('project_'.$id, $file);
            $pfile->save();
        }
        return redirect()->back();
    }

    private function checkFileName($id,$name) {
        $files = Project::find($id)->files;
        foreach ($files as $file) {
            if ($file->name == $name){
                Storage::disk('public')->delete($file->url);
                $file->delete();
            }
        }
    }

    public function downloadFile($id,$file_id) {
        $check = $this->checkUserInProject($id);
        if (!$check) {
            return redirect()->back();
        }
        $file = ProjectFile::find($file_id);
        return Storage::disk('public')->download($file->url,$file->name);
    }

    public function deleteFile($id,$file_id) {
        $check = $this->checkUserInProject($id);
        if (!$check) {
            return redirect()->back();
        }
        $file = ProjectFile::find($file_id);
        Storage::disk('public')->delete($file->url);
        $file->delete();
        return redirect()->back();
    }

    private function checkUserInProject($id) {
        $project = Project::find($id);
        $users = $project->users;
        $check = false;
        foreach ($users as $user) { if ($user->id == Auth::id()) $check = true; }
        return $check;
    }

    public function uploadFolder($id,Request $request) {
        /*$check = $this->checkUserInProject($id);
        if (!$check) {
            return redirect()->back();
        }
        dd($request);
        foreach ($request->input_folder as $file) {
            dd($file->webkitRelativePath);
        }*/
    }

    public function downloadZIP($id) {
        $check = $this->checkUserInProject($id);
        if (!$check) {
            return redirect()->back();
        }
        $files = Project::find($id)->files;

        $zip = new ZipArchive();
        if ($zip->open(storage_path('app/public/project_'.$id.'/project_'.$id.'.zip'),(ZipArchive::CREATE | ZipArchive::OVERWRITE)) !== TRUE) {
            return redirect()->back();
        }
        foreach ($files as $file) {
            $zip->addFile(storage_path('app/public/'.$file->url),$file->name);
        }
        $zip->close();
        return response()->download(storage_path('app/public/project_'.$id.'/project_'.$id.'.zip'));
    }
}


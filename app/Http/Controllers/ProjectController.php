<?php

namespace App\Http\Controllers;

use App\Models\FavoriteProject;
use App\Models\Project;
use App\Models\ProjectFile;
use App\Models\ProjectUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
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
        $project = Project::find($id);
        $user = Auth::user();
        Gate::authorize('show',$project);
        $project_user = ProjectUser::find(['user_id' => $user->id,'project_id' => $project->id]);
        if (!$project_user) {
            $user_role = 'GUEST';
        } else {
            $user_role = $project_user->user_role;
        }
        $admins = $project->managers;
        $members = $project->members;
        $guests = $project->guests;
        $num_favs = $project->getNumFavs();
        $is_fav = FavoriteProject::where('user_id' ,'=', $user->id)->where('project_id','=',$id)->exists();
        return view('pages.project',['user_role' => $user_role,'project' => $project,'admins' => $admins, 'members' => $members, 'guests' => $guests, 'is_fav' => $is_fav, 'num_favs' => $num_favs, 'notifications' => $notifications]);
    }

    public function showProjectFiles($id) {
        $notifications = NotificationsController::getNotifications(Auth::id());
        $project = Project::find($id);
        $user = Auth::user();
        Gate::authorize('show',$project);
        $files = $project->files;
        $project_user = ProjectUser::find(['user_id' => $user->id,'project_id' => $project->id]);
        if (!$project_user) {
            $user_role = 'GUEST';
        } else {
            $user_role = $project_user->user_role;
        }
        return view('pages.projectFiles',['user_role' => $user_role,'project' => $project,'files' => $files, 'notifications' => $notifications]);
    }

    public function showProjectForm()
    {
        $notifications = NotificationsController::getNotifications(Auth::id());
        return view('pages.projectsCreate', ['notifications' => $notifications]);
    }

    public function addFavorite($id) {
        Gate::authorize('isPublic',Project::find($id));

        $fav = new FavoriteProject();
        $fav->project_id = $id;
        $fav->user_id = Auth::id();
        $fav->save();

        return redirect()->back();
    }

    public function removeFavorite($id) {
        Gate::authorize('isPublic',Project::find($id));
        $fav = FavoriteProject::find(['user_id' => Auth::id(),'project_id' => $id]);
        $fav->delete();
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
        $validator = $request->validate($this->validator());

        $project = new Project;

        $project->title = $request->title;
        $project->description = $request->description;

        if($request->public == "1")
            $project->public = true;
        else
            $project->public = false;

        $project->active = true;
        $project->created_at = Carbon::now();
        $project->save();

        $project_user = new ProjectUser();

        $project_user->project_id = $project->id;
        $project_user->user_id = Auth::id();
        $project_user->user_role = 'MANAGER';

        $project_user->save();

        return redirect("/projects");
    }

    public function updateProject(int $id, Request $request)
    {
        Gate::authorize('update',Project::find($id));

        $notifications = NotificationsController::getNotifications(Auth::id());

        $project = Project::find($id);

        switch ($request->input('action'))
        {
            case 'update':

                $project->title = $request->title;
                $project->description = $request->description;

                $project->public = $request->public == "True";
                $project->active = $request->active == "True";

                $project->save();

                break;

            case 'delete':

                $project_user = ProjectUser::where('project_id', '=', $id)
                    ->delete(['user_id'=>$request->user_id]);

                $project->delete();

                return redirect("/projects");
        }
        return redirect()->back();
    }

    public function leaveProject($id) {
        $project_user = ProjectUser::find(['user_id' => Auth::id(), 'project_id' => $id]);
        if ($project_user->user_role == "MANAGER" && Project::find($id)->managers()->count() < 2) {
            return redirect()->back()->withErrors("You can't leave the project because you are the only manager of the project");
        }
        $project_user->delete();
        return redirect('/projects');
    }

    public function uploadFiles($id, Request $request) {
        Gate::authorize('isActive',Project::find($id));
        Gate::authorize('notGuest',Project::find($id));


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
        Gate::authorize('isPublic',Project::find($id));
        $file = ProjectFile::find($file_id);
        return Storage::disk('public')->download($file->url,$file->name);
    }

    public function deleteFile($id,$file_id) {
        Gate::authorize('isActive',Project::find($id));
        Gate::authorize('notGuest',Project::find($id));
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
        Gate::authorize('isPublic',Project::find($id));
        $files = Project::find($id)->files;

        $zip = new ZipArchive();
        if ($zip->open(storage_path('app/public/project_'.$id.'/project_'.$id.'.zip'),(ZipArchive::CREATE | ZipArchive::OVERWRITE)) !== TRUE) {
            return redirect()->back();
        }
        foreach ($files as $file) {
            $zip->addFile(storage_path('app/public/'.$file->url),$file->name);
        }
        if ($zip->close() && file_exists(storage_path('app/public/project_'.$id.'/project_'.$id.'.zip'))) {
            return response()->download(storage_path('app/public/project_'.$id.'/project_'.$id.'.zip'));
        } else {
            return redirect()->back();
        }
    }
}


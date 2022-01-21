<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function show(User $user, Project $project)
    {
        return $user->is_admin || $this->checkUserInProject($user,$project) || $project->public;
    }

    public function showUsers(User $user, Project $project)
    {
        return $user->is_admin || $this->checkUserInProject($user,$project);
    }

    public function isPublic(User $user, Project $project) {
        return $user->is_admin || $this->checkUserInProject($user,$project) || $project->public;
    }

    public function inProject(User $user, Project $project) {
        return $this->checkUserInProject($user,$project);
    }

    public function inProjectOrAdmin(User $user, Project $project) {
        return $user->is_admin || $this->checkUserInProject($user,$project);
    }

    public function update(User $user, Project $project) {
        return ($this->checkUserInProject($user,$project) && ProjectUser::find(['user_id' => $user->id,'project_id' => $project->id])->user_role == 'MANAGER') || $project->active;;
    }

    private function checkUserInProject(User $user, Project $project) {
        $users = $project->users;
        $check = false;
        foreach ($users as $u) { if ($u->id == $user->id) $check = true; }
        return $check;
    }

    public function notGuest(User $user, Project $project) {
        $projectUser = ProjectUser::find(['user_id' => $user->id,'project_id' => $project->id]);
        if (!$projectUser) return false;
        return ($this->checkUserInProject($user,$project) && $projectUser->user_role !== 'GUEST' && $projectUser->user_role !== 'VISITOR');
    }

    public function notGuestOrAdmin(User $user, Project $project) {
        if ($user->is_admin) return true;
        $projectUser = ProjectUser::find(['user_id' => $user->id,'project_id' => $project->id]);
        if (!$projectUser) return false;
        return ($this->checkUserInProject($user,$project) && $projectUser->user_role !== 'GUEST' && $projectUser->user_role !== 'VISITOR');
    }

    public function manager(User $user, Project $project) {
        return ($this->checkUserInProject($user,$project) && ProjectUser::find(['user_id' => $user->id,'project_id' => $project->id])->user_role == 'MANAGER');
    }

    public function isActive(User $user, Project $project) {
        return $project->active;
    }
}

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

    public function isPublic(User $user, Project $project) {
        return $this->checkUserInProject($user,$project) || $project->public;
    }

    public function inProject(User $user, Project $project) {
        return $this->checkUserInProject($user,$project);
    }

    private function checkUserInProject(User $user, Project $project) {
        $users = $project->users;
        $check = false;
        foreach ($users as $u) { if ($u->id == $user->id) $check = true; }
        return $check;
    }

    public function manager(User $user, Project $project) {
        return ProjectUser::find(['user_id' => $user->id,'project_id' => $project->id])->user_role == 'MANAGER';
    }
}

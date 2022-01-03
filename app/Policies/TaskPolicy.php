<?php
namespace App\Policies;

use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Report;
use App\Models\Task;
use App\Models\User;

use App\Models\UserAssign;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function show(User $user, Task $task) {
        return $user->is_admin || $this->checkUserInProject($user, $task->project);
    }

    public function update(User $user, Task $task) {
        return $user->is_admin
            || ($this->checkUserInProject($user,$task->project) && ProjectUser::find(['user_id' => $user->id,'project_id' => $task->project->id])->user_role == 'MANAGER')
            || ($this->checkUserInProject($user, $task->project) && UserAssign::find(['user_id' => $user->id, 'task_id', $task->id]));
    }

    private function checkUserInProject(User $user, Project $project) {
        $users = $project->users;
        $check = false;
        foreach ($users as $u) { if ($u->id == $user->id) $check = true; }
        return $check;
    }
}

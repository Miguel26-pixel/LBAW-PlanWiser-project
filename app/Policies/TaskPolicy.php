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
        return $user->is_admin || UserAssign::find(['user_id' => $user->id, 'task_id' => $task->id])->exists();
    }
}

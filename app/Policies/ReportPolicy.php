<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
{
    use HandlesAuthorization;

    public function create(User $user, Report $report) {
        return $user->id == $report->user_id;
    }
}

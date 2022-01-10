<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;

    public function show(User $auth, User $user)
    {
        return $auth !== null;
    }

    public function update(User $auth, User $user)
    {
        return $user->id == $auth->id || $auth->is_admin;
    }

    public function delete(User $auth, User $user)
    {
        return $user->id == $auth->id || $auth->is_admin;
    }

    public function admin(User $user) {
        return $user->is_admin;
    }
}

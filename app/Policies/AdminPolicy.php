<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    public function accessAdmin(User $user)
    {
        return in_array($user->rol_id, [1, 2]);
    }
}

<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Application $application)
    {
        return $user->id === 1;
    }

    public function delete(User $user, Application $application)
    {
        return $user->id === 1;
    }

}

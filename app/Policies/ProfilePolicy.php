<?php

namespace App\Policies;

use App\Profile;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProfilePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
    /**
     * Determine if the given profile can be updated by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Profile  $post
     * @return bool
     */
    public function update(User $user, Profile $profile)
    {
        return false;
    }
}

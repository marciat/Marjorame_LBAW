<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy {
    use HandlesAuthorization;

    public function showPublic(User $user, User $other) {
        // All authenticated users can access it
        return $user->id && !$other->admin && $other->active();
    }

    public function showPrivate(User $user, User $other) {
        // Only owner can see it
        return $user->id == $other->id && !$other->admin && !$user->admin && $other->active();
    }

    public function showOwnerAdmin(User $user, User $other){
        // Only owner and admins can see it
        return ($user->id == $other->id || $user->admin) && !$other->admin && $other->active();
    }

    public function showAdmin(User $user){
        // Only owner and admins can see it
        return $user->admin;
    }
}

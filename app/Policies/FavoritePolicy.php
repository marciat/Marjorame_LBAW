<?php

namespace App\Policies;

use App\Favorite;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FavoritePolicy {
    use HandlesAuthorization;

    public function list(User $user, Favorite $favorite) {
        return $user->id == $favorite->buyer_id;
    }

    public function delete(User $user, Favorite $favorite) {
        return $user->id == $favorite->buyer_id;
    }
}

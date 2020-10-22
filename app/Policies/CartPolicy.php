<?php

namespace App\Policies;

use App\User;
use App\Cart;
use Illuminate\Auth\Access\HandlesAuthorization;

class CartPolicy {
    use HandlesAuthorization;


    public function delete(User $user, Cart $cart){
        // Only an authenticated user can delete his own cart item
        return $user->buyer && $cart->buyer == $user->buyer->id;
    }
}

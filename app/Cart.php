<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model {
    // Don't add create and update timestamps in database.
    public $timestamps = false;

    public $table = 'cart';

    /**
     * The user who added product to cart
     */
    public function buyer() {
        return $this->hasOne('App\Buyer');
    }

    /**
     * The product in cart
     */
    public function cart() {
        return $this->hasOne('App\Product');
    }

}

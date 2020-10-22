<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model {
    // Don't add create and update timestamps in database.
    public $timestamps = false;

    protected $table = 'favorite';

    /**
     * The user who's favorited a product
     */
    public function user() {
        return $this->hasOne('App\Buyer');
    }

    /**
     * The favorited product
     */
    public function product() {
        return $this->hasOne('App\Product');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchased_product extends Model {
    // Don't add create and update timestamps in database.
    public $timestamps = false;

    public $table = 'purchased_product';

}
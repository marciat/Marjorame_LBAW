<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipping_address extends Model {
    // Don't add create and update timestamps in database.
    public $timestamps = false;

    public $table = 'shipping_address';
}

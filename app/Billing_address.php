<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billing_address extends Model {
    // Don't add create and update timestamps in database.
    public $timestamps = false;

    public $table = 'billing_address';
}

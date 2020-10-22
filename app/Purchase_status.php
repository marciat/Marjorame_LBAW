<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase_status extends Model {
    // Don't add create and update timestamps in database.
    public $timestamps = false;

    public $table = 'purchase_status';


}
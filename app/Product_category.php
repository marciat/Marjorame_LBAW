<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_category extends Model {
    // Don't add create and update timestamps in database.
    public $timestamps = false;

    public $table = 'product_category';


}
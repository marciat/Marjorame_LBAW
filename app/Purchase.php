<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model {
    // Don't add create and update timestamps in database.
    public $timestamps = false;

    public $table = 'purchase';


    public function product()
    {
        return $this->belongsToMany('App\Product', 'purchased_product', 'purchase', 'product')
            ->withPivot('quantity');
    }

}
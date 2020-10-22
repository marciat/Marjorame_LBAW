<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_color extends Model {
    // Don't add create and update timestamps in database.
    public $timestamps = false;

    public $table = 'product_color';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'color_id', 'product_id'
    ];

}
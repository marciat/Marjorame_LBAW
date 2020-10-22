<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_size extends Model {
    // Don't add create and update timestamps in database.
    public $timestamps = false;

    public $table = 'product_size';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'size_id', 'product_id'
    ];


}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model {
    // Don't add create and update timestamps in database.
    public $timestamps = false;

    public $table = 'review';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date', 'buyer', 'product', 'rating', 'title', 'description'
    ];

}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Size extends Model {
    // Don't add create and update timestamps in database.
    public $timestamps = false;

    public $table = 'size';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'size'
    ];


}

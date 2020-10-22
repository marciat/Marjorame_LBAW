<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model {
    // Don't add create and update timestamps in database.
    public $timestamps = false;

    public $table = 'color';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'color'
    ];


}

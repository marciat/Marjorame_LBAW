<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Extra_characteristic extends Model {
    // Don't add create and update timestamps in database.
    public $timestamps = false;

    public $table = 'extra_characteristic';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'option1', 'option2', 'option3', 'option4'
    ];
}
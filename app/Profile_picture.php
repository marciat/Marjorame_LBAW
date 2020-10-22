<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile_picture extends Model {
    // Don't add create and update timestamps in database.
    public $timestamps = false;

    public $table = 'profile_picture';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'photo_id'
    ];

    public function src(){
        return $this->belongsTo('App\Photo');
    } 


}

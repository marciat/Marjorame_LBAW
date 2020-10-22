<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_photo extends Model {
    // Don't add create and update timestamps in database.
    public $timestamps = false;

    public $table = 'product_photo';

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

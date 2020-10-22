<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'status', 'phone_number', 'vat', 'picture_id', 'country_id', 'shipping_address'
    ];

    public function cart()
    {
        return $this->belongsToMany('App\Product', 'cart', 'buyer', 'product')
                    ->withPivot('quantity', "id");
    }

    public function favorites()
    {
        return $this->belongsToMany('App\Product', 'favorite', 'buyer', 'product');
    }

    public function review()
    {
        return $this->belongsToMany('App\Product', 'review', 'buyer', 'product')
            ->withPivot('date', 'rating', 'title', 'description');
    }

    public function purchases()
    {
        return $this->hasMany('App\Purchase', 'buyer');
    }

    protected $table = 'buyer';
}

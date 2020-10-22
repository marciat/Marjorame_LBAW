<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    // Don't add create and update timestamps in database.
    public $timestamps = false;

    public $table = 'product';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'price', 'stock', 'rating', 'active', 'extra_characteristic_id', 'category_id',
        'extra_characteristic_id', 'photo_id', 'photo2_id', 'photo3_id', 'photo4_id', 'photo5_id'
    ];

    protected $searchable = [
        'name', 'description'
    ];

    public function getPhoto($id){
        $product_photo = Product_photo::find($id);
        if(is_null($product_photo))
            return null;

        $photo = Photo::find($product_photo->photo_id);

        return $photo->src;
    }

    public function size(){
        return $this->belongsToMany('App\Size', 'product_size', 'product_id', 'size_id');
    }

    public function color(){
        return $this->belongsToMany('App\Color', 'product_color', 'product_id', 'color_id');
    }

    public function extra_characteristic(){
        return $this->belongsTo('App\Extra_characteristic', 'extra_characteristic_id', 'id');
    }

    public function product_category(){
        return $this->belongsTo('App\Product_category', 'category_id', 'id');
    }


}

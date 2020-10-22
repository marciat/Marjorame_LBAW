<?php

namespace App\Policies;

use App\User;
use App\Review;
use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy {
    use HandlesAuthorization;

    public function purchased(User $user, Product $product) {
        // Only an authenticated user that purchased the product may review it
        if($user == NULL || $product == NULL){
            return false;
        }
        
        $buyer_purchases = DB::table('purchase')
        ->where('buyer', '=', $user->buyer->id)
        ->select('id');
  
        $product_purchases = DB::table('purchased_product')
        ->where('product', '=', $product->id)
        ->joinSub($buyer_purchases, 'buyer_purchases', function ($join) {
        $join->on('purchased_product.purchase', '=', 'buyer_purchases.id');
        })
        ->get();

        $purchased = count($product_purchases) != 0;

        return $purchased;
    }

    public function reviewer(User $user, Review $review){
        // Only an authenticated user that authored the review (or an admin) may change or delete it
        $buyer = DB::table('buyer')
                ->where('user_id', '=', $user->id)
                ->first();

        return $user->admin || $buyer->id == $review->buyer;
    }
}

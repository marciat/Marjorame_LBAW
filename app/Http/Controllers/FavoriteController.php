<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{

  /**
   * @throws \Illuminate\Auth\Access\AuthorizationException
   */
  public function favorites($id)
  {

    $user = User::findOrFail($id);

    $this->authorize('showPublic', $user);

    if (!Auth::check() || $user->admin)
      return redirect('/');

    $products = $user->buyer->favorites()->paginate(9);

    return view('pages.favorites', ['user' => $user], ['products' => $products]);
  }

  /**
   * Shows all favorites.
   *
   * @return Response
   */
  public function list($id)
  {
    if (!Auth::check()) return redirect('/');

    $this->authorize('list', Favorite::class);

    $buyer = DB::table('buyer')->where('user_id', '=', Auth::user()->id)->get();

    $favorites = DB::table('favorite')->where('buyer_id', '=', $buyer->id)->get();

    $products = array();
    foreach ($favorites as $favorite) {
      array_push($products, Product::find($favorite->product));
    }

    return view('pages.favorites', ['products' => $products]);
  }

  /**
   * R206: Add product to favorites action [/product/{id}/favorite]
   */
  public function add_favorites_action(Request $request, $id)
  {
    $product = Product::findOrFail($id);

    //check permissions
    if (Auth::user() == null){
        return redirect()->back()
            ->with('error_add_favorite', 'Please login or create an account in order to favorite a product');
    }

      if (Auth::user()->admin){
          return redirect()->back()
              ->with('error_add_favorite', "Admins can't have favorite products");
      }

      $favorite = DB::table('favorite')
          ->where('buyer', '=', Auth::user()->buyer->id)
          ->where('product', "=",  $id)
          ->get();

      try{
          error_log($favorite);
          if(count($favorite) == 0){
              $favorite = new Favorite();
              $favorite->buyer = Auth::user()->buyer->id;
              $favorite->product = $id;
              $favorite->save();
          }else{
              DB::table('favorite')
                  ->where('buyer', '=', Auth::user()->buyer->id)
                  ->where('product', "=",  $id)
                  ->delete();
              return redirect()->back()
                  ->with('success_add_favorite', 'Product removed from favorites!');
          }
      }catch(\Exception $e){
          return redirect()->back()
              ->with('error_add_favorite', 'Error adding product to favorites');
      }


    return redirect()->back()
                     ->with('success_add_favorite', 'Product added to favorites!');
  }

  public function delete(Request $request, $id)
  {
    $favorite = Favorite::find($id);

    $this->authorize('delete', $favorite);

    $favorite->delete();

  }
}

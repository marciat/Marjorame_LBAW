<?php

namespace App\Http\Controllers;

use App\Product;
use App\Product_category;
use App\Photo;
use App\Product_photo;
use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\FullTextSearch;


class ProductController extends Controller
{

  public function subcategory($category, $subcategory)
  {

    $category = DB::table('category')
      ->where('category', $category)
      ->first();

      if(is_null($category)){
          return redirect()->to('/');
      }

    $subcategory = DB::table('category')
      ->where('category', $subcategory)
      ->first();

      if(is_null($subcategory)){
          return redirect()->to('/');
      }

    $product_category =  DB::table('product_category')
      ->select('id')
      ->where('category', '=', $category->id)
      ->where('subcategory1', '=', $subcategory->id);

      $products = Product::whereIn('category_id', $product_category)->paginate(9);

    $page_title = "{$category->category} > {$subcategory->category}";
    if ($category->category == 'Beauty') {
      return view('pages.beauty', ['products' => $products, 'page_title' => $page_title]);
    } else if ($category->category == 'Fashion') {
      return view('pages.fashion', ['products' => $products, 'page_title' => $page_title]);
    } else {
      return view('pages.decor', ['products' => $products, 'page_title' => $page_title]);
    }
  }

  public function subcategory1($category, $subcategory, $subcategory1)
  {

    $category = DB::table('category')
      ->where('category', $category)
      ->first();

      if(is_null($category)){
          return redirect()->to('/');
      }

    $subcategory = DB::table('category')
      ->where('category', $subcategory)
      ->first();

      if(is_null($subcategory)){
          return redirect()->to('/');
      }

    $subcategory1 = DB::table('category')
      ->where('category', $subcategory1)
      ->first();

      if(is_null($subcategory1)){
          return redirect()->to('/');
      }


      $product_category =  DB::table('product_category')
      ->select('id')
      ->where('category', '=', $category->id)
      ->where('subcategory1', '=', $subcategory->id)
      ->where('subcategory2', '=', $subcategory1->id);

    $products = Product::whereIn('category_id', $product_category)->paginate(9);


    $page_title = "{$category->category} > {$subcategory->category} > {$subcategory1->category}";
    if ($category->category == 'Beauty') {
      return view('pages.beauty', ['products' => $products, 'page_title' => $page_title]);
    } else if ($category->category == 'Fashion') {
      return view('pages.fashion', ['products' => $products, 'page_title' => $page_title]);
    } else {
      return view('pages.decor', ['products' => $products, 'page_title' => $page_title]);
    }
  }

  public function category($category) {

    $category = DB::table('category')
    ->where('category',"=", $category)
    ->first();

    if(is_null($category)){
        return redirect()->to('/');
    }

    $product_category =  DB::table('product_category')
      ->select('id')
      ->where('category', '=', $category->id);


    $products = Product::whereIn('category_id', $product_category)
      ->paginate(9);
    
    $page_title = "{$category->category}";

    if ($category->category == 'Beauty') {
      return view('pages.beauty', ['products' => $products, 'page_title' => $page_title]);
    } else if ($category->category == 'Fashion') {
      return view('pages.fashion', ['products' => $products, 'page_title' => $page_title]);
    } else {
      return view('pages.decor', ['products' => $products, 'page_title' => $page_title]);
    }
  }

  /**
   * R201: View product [/product/{id}]
   */
  public function view_product($id)
  {
    //General product info
    $product = Product::findOrFail($id);

    //Product photos
    $photo1 = $product->getPhoto($product->photo_id);
    $photo2 = $product->getPhoto($product->photo2_id);
    $photo3 = $product->getPhoto($product->photo3_id);
    $photo4 = $product->getPhoto($product->photo4_id);
    $photo5 = $product->getPhoto($product->photo5_id);

    $photoUrls = [];
    array_push($photoUrls, $photo1, $photo2, $photo3, $photo4, $photo5);

    //Product reviews
    $user_names = DB::table('user')
      ->join('buyer', 'user.id', '=', 'user_id')
      ->select('buyer.id', 'username');

    $reviews = DB::table('review')
      ->where('product', '=', $id)
      ->joinSub($user_names, 'user_names', function ($join) {
        $join->on('review.buyer', '=', 'user_names.id');
      })
      ->select('review.id AS id', 'date', 'username', 'rating', 'title', 'description', 'buyer')
        ->get();

    $user = Auth::user();

    $purchased = false;
    if ($user != NULL && $user->buyer) {
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
    }
    
    return view('pages.product')->with(['product' => $product, 'photos' => $photoUrls, 'reviews' => $reviews, 'purchased' => $purchased, 'user' => Auth::user()]);
  }

  public function get_reviews($id)
  {
    //Product reviews
    $user_names = DB::table('user')
      ->join('buyer', 'user.id', '=', 'user_id')
      ->select('buyer.id', 'username');

    $reviews = DB::table('review')
      ->where('product', '=', $id)
      ->joinSub($user_names, 'user_names', function ($join) {
        $join->on('review.buyer', '=', 'user_names.id');
      })
      ->select('review.id AS id', 'date', 'username', 'rating', 'title', 'description', 'buyer')
      ->get();

    return view('partials.reviews')->with(['reviews' => $reviews, 'user' => Auth::user()]);
  }

  /**
   * R202: Search Product [/search]
   */
  public function search_product(Request $request)
  {

    $search = trim(htmlspecialchars($request->input('search')));



    $products = Product::where('name','ilike', '%'.$search.'%')
      ->paginate(9);


    return view('pages.fashion', ['products' => $products, 'page_title' => "Search results"]);
  }
/*
  public function search_user(Request $request)
  {
    $search = $request->input('search');

    if ($search == "")
      return view('pages.about_us');

    $users = DB::table('user')
      ->whereRaw('first_name @@ to_tsquery(\'english\', "?")', [$search])
      ->orderByRaw('ts_rank( to_tsvector(\'english\',  first_name || last_name), to_tsquery(\'english\', "?")) DESC', [$search])
      ->get();
  }
*/

  /**
   * R204: Delete review [/product/{id}/review/{reviewerId}]
   */
  public function delete_review(Request $request, $id)
  {
  }

  /**
   * R205: Edit review action (including rate) [/product/{id}/review/{reviewerId}]
   */
  public function edit_review_action(Request $request, $id)
  {
    $user = Auth::user();
    $product = Product::findOrFail($id);
    $this->authorize('purchased', [Review::class, $product]);


    $updateResult = DB::table('review')
      ->where('buyer', $user->buyer->id)
      ->where('product', $id)
      ->update(
        [
          'rating' => $request->input('rating'),
          'title' => $request->input('title'),
          'description' => $request->input('description')
        ]
      );

    if ($updateResult == 0) {
      $createResult = DB::table('review')
        ->insertGetId(
          [
            'date' => date("m/d/Y"),
            'buyer' => $user->buyer->id,
            'product' => $id,
            'rating' => $request->input('rating'),
            'title' => $request->input('title'),
            'description' => $request->input('description')
          ]
        );

      if ($createResult != NULL) {
        return response('', 201)->header('Content-Type', 'text/plain');
      } else {
        return response('', 500)->header('Content-Type', 'text/plain');
      }
    } else {
      return response('', 200)->header('Content-Type', 'text/plain');
    }
  }

  /**
   * R206: Add product to cart action [/product/{id}/cart]
   */
  public function add_cart_action(Request $request, $id)
  {
  }

  public function filter(Request $request, $category) {

    $category = DB::table('category')
    ->where('category',"=", $category)
    ->first();

    if(is_null($category)){
        return redirect()->to('/');
    }

    $product_category =  DB::table('product_category')
      ->select('id')
      ->where('category', '=', $category->id);

    $rate = $_POST["rating"];
    $price = $_POST["price"];
    
    $products = Product::whereIn('category_id', $product_category)
      ->where('rating', '>=', $rate)
      ->where('price', '<=', $price) 
      ->paginate(9);
    
    $page_title = "{$category->category}";

    if ($category->category == 'Beauty') {
      return view('pages.beauty', ['products' => $products, 'page_title' => $page_title]);
    } else if ($category->category == 'Fashion') {
      return view('pages.fashion', ['products' => $products, 'page_title' => $page_title]);
    } else {
      return view('pages.decor', ['products' => $products, 'page_title' => $page_title]);
    }

  }
}

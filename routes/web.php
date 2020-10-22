<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@home');


// M1: Authentication
Route::post('login', 'Auth\LoginController@login')->name("login");
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::post('register', 'Auth\RegisterController@register')->name('register');


//Module 2: Products and Categories
Route::get('products/{category}', 'ProductController@category');
Route::get('products/{category}/{subcategory}', 'ProductController@subcategory');
Route::get('products/{category}/{subcategory}/{subcategory1}', 'ProductController@subcategory1');
Route::get('product/{id}', 'ProductController@view_product');
Route::get('search', 'ProductController@search_product');
Route::post('filter/{category}', 'ProductController@filter');
Route::get('product/{id}/review/', 'ProductController@get_reviews');
Route::delete('product/{id}/review/', 'ProductController@delete_review');
Route::put('product/{id}/review/', 'ProductController@edit_review_action');
Route::post('product/{id}/review/', 'ProductController@add_review_action');
Route::post('product/{id}/cart', 'ProductController@add_cart_action');


//Module 3: Management Area
Route::get('add_product', 'ManagementController@add_product');
Route::post('add_product', 'ManagementController@add_product_action')->name('add_product');
Route::post('manage_product/{id}', 'ManagementController@product');
Route::get('control_users', 'ManagementController@control_users');
Route::post('control_users', 'ManagementController@ban_users');
Route::post('review/{id}', 'ManagementController@edit_review');
Route::post('user/{id}/ban', 'ManagementController@ban_user');
Route::post('user/{id}/unban', 'ManagementController@unban_user');
Route::get('users','ManagementController@get_users');

// M4: Static pages
Route::get('home', 'HomeController@list')->name('home');
Route::get('about_us', 'StaticPageController@listAboutUs');
Route::get('contacts', 'StaticPageController@listContacts');
Route::post('contacts', 'StaticPageController@sendContactsEmail');
Route::get('sell_your_product', 'StaticPageController@listSellProduct');
Route::post('sell_your_product', 'StaticPageController@SellProductAction');
Route::get('privacy_policy', 'StaticPageController@listPrivacyPolicy');


//Module 5: Profile and favorite's
Route::get('user/{id}', 'ProfileController@user_profile');
Route::get('user/{id}/edit_profile', 'ProfileController@edit_profile');
Route::post('edit_profile', 'ProfileController@edit_profile_action')->name('edit_profile');
Route::post('edit_profile_address', 'ProfileController@edit_address_profile_action')->name('edit_profile_address');
Route::get('change_password/{id}', 'Auth\ChangePasswordController@showChangePasswordForm');
Route::post('change_password', 'Auth\ChangePasswordController@change_password')->name('change_password');
Route::post('deactivate_account', 'ProfileController@deactivate_account_action')->name('deactivate_account');
Route::get('user/{id}/deactivate_account', 'ProfileController@deactivate_account');
Route::post('delete_account', 'ProfileController@delete_account')->name('delete_account');
Route::get('user/{id}/review_history', 'ProfileController@review_history');
Route::get('user/{id}/purchase_history', 'ProfileController@purchase_history');
Route::get('user/{id}/favorites', 'FavoriteController@favorites');
Route::post('product/{id}/favorite', 'FavoriteController@add_favorites_action')->name('favorite');
Route::delete('user/{id}/delete_favorite', 'FavoriteController@delete');

// Module 6: Cart and Checkout
Route::get('cart', 'PurchaseController@cart');
Route::get('cart/items', 'PurchaseController@cart_items');
Route::put('cart/{id}', 'PurchaseController@update_cart_quantity');
Route::delete('cart/{id}', 'PurchaseController@delete_cart');
Route::post('cart/add/{id}', 'PurchaseController@add_to_cart');
Route::get('checkout', 'PurchaseController@checkout');
Route::post('checkout', 'PurchaseController@checkout_action')->name('checkout');


?>
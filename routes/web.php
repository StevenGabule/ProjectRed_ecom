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


Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/vendor-register', 'HomeController@becomeVendor')->name('vendor.register');
Route::post('/vendor-register', 'VendorController@store')->name('vendor.store');

Route::get('/', 'ProductController@index')->name('product.all');
Route::get('/home', 'ProductController@index')->name('product.all');
Route::get('/vendors', 'VendorController@index')->name('vendor.all');

Route::get('/vendor/products', 'ProductController@VendorProduct')->name('vendor.products');

Route::get('/vendor/product/create', 'ProductController@create')->name('vendor.product.create');
Route::post('/vendor/product/store/{vendor_id}', 'ProductController@store')->name('vendor.product.store');

Route::get('/vendor/product/edit/{product}', 'ProductController@edit')->name('vendor.product.edit');
Route::post('/vendor/product/update/{vendor}/{product}', 'ProductController@update')->name('vendor.product.update');

Route::get('/vendor/product/delete/{vendId}/{prodId}', 'ProductController@destroy')->name('vendor.product.destroy');
Route::get('/vendor/product/multiDelete', 'ProductController@multiDestroy')->name('vendor.products.multiples.destroy');


Route::get('/vendor/product/loadAll', 'ProductController@getProducts')->name('products.loadAll');

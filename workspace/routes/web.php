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


//login,logout
Auth::routes();

// stamp.image
Route::get('/stamp-images/{image_id}', 'ImageController@stampImage')->name("stamp.image");

//help
Route::get('/help', 'HelpController@index')->name('help');

//home
Route::get('/{any}', 'HomeController@index')->where('any','.*')->name('home');
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

//home
Route::get('/', 'HomeController@index')->name('home');

//help
Route::get('/help', 'HelpController@index')->name('help');


//login,logout
Auth::routes();

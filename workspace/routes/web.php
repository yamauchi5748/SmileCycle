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


//login
Route::get('/login', 'Auth\LoginController@index')->name("login.page");
Route::post('/login', 'Auth\LoginController@authenticate')->name("login");

// stamp.image
Route::get('/stamp-images/{image_id}', 'ImageController@stampImage')->name("stamp.image");

// member.image
Route::get('/members/{member_id}/profile-image', 'ImageController@memberImage')->name("member.image");

// invitation.image
Route::get('/invitations/{invitation_id}/images/{image_id}', 'ImageController@invitationImage')->name("invitation.image");

// forum.image
Route::get('/forums/{forum_id}/images/{image_id}', 'ImageController@forumImage')->name("forum.image");

// chat.image
Route::get('/chat-rooms/{chat_room_id}/images/{image_id}', 'ImageController@chatRoomImage')->name("chat_room.image");

//home
Route::get('/{any}', 'HomeController@index')->where('any','.*')->name('home');
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

//login

//logout

//help
Route::get('/help', 'HelpController@index')->name('help');

//***リソースコントローラ***//
//members
Route::resource('members', 'MemberController')->only([
    "index", "edit", "update"
])->names([
    "index" => "members.index",
    "edit" => "members.edit",
    "update" => "members.update"
]);

//member.bulletin_boards
Route::resource('members/{member_id}/bulletin_boards', 'MemberBulletinBoardController')->only([
    "index"
])->names([
    "index" => "member.bulletin_boards.index"
]);

//informations
Route::resource('informations', 'InformationController')->only([
    "index", "show", "update"
])->names([
    "index" => "informations.index"
]);

//bulletin_boards
Route::resource('bulletin_boards', 'BulletinBoardController')->only([
    "index", "show", "create", "store"
])->names([
    "index" => "bulletin_boards.index",
    "show" => "bulletin_boards.show",
    "create" => "bulletin_boards.ceate",
    "store" => "bulletin_boards.store"
]);

//chats
Route::resource('chats', 'ChatController')->only([
    "index"
])->names([
    "index" => "chat.index"
]);

//admin.home
Route::get('/admin', 'AdminHomeController@index')->name('admin.home');

//admin.members
Route::resource('admin/members', 'Admin\MemberController')->only([
    "index", "edit", "create", "store", "update", "destroy"
])->names([
    "index" => "admin.members.index",
    "edit" => "admin.members.edit",
    "create" => "admin.members.ceate",
    "store" => "admin.members.store",
    "update" => "admin.members.update",
    "destory" => "admin.members.destroy"
]);

//admin.companies
Route::resource('admin/companies', 'Admin\CompanyController')->only([
    "index", "edit", "create", "store", "update", "destroy"
])->names([
    "index" => "admin.companies.index",
    "edit" => "admin.companies.edit",
    "create" => "admin.companies.ceate",
    "store" => "admin.companies.store",
    "update" => "admin.companies.update",
    "destory" => "admin.companies.destroy"
]);

//admin.stamp_groups
Route::delete('admin/stamp_groups', 'Admin\StampGroupController@destroy')->name("admin.stamp_groups.destroy");
Route::resource('admin/stamp_groups', 'Admin\StampGroupController')->only([
    "index", "create", "store"
])->names([
    "index" => "admin.stamp_groups.index",
    "create" => "admin.stamp_groups.ceate",
    "store" => "admin.stamp_groups.store",
]);

//admin.informations
Route::resource('admin/informations', 'Admin\InformationController')->only([
    "index", "create", "store", "show"
])->names([
    "index" => "admin.informations.index",
    "create" => "admin.informations.ceate",
    "store" => "admin.informations.store",
    "show" => "admin.informations.show"
]);

Auth::routes();

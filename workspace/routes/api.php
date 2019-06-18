<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

//members
Route::apiResource('members', 'API\MemberController')->only([
    "index", "show"
])->names([
    "index" => "members.index",
    "show" => "members.show"
]);

//simple_members
Route::apiResource('simple/members', 'API\SimpleMemberController')->only([
    "index"
])->names([
    "index" => "simple_members.index"
]);

//member.bulletin_boards
Route::apiResource('members/{member_id}/bulletin_boards', 'API\MemberBulletinBoardController')->only([
    "index"
])->names([
    "index" => "member.bulletin_boards.index"
]);

//member.stamp_groups
Route::apiResource('members/{member_id}/stamp_groups', 'API\MemberStampGroupController')->only([
    "index"
])->names([
    "index" => "member.stamp_groups.index"
]);

//companies
Route::apiResource('companies', 'API\CompanyController')->only([
    "index"
])->names([
    "index" => "companies.index"
]);

//informations
Route::apiResource('informations', 'API\InformationController')->only([
    "index", "show"
])->names([
    "index" => "informations.index",
    "show" => "informations.show"
]);

//bulletin_boards
Route::apiResource('bulletin_boards', 'API\BulletinBoardController')->only([
    "index", "show"
])->names([
    "index" => "bulletin_boards.index",
    "show" => "bulletin_boards.show"
]);

//bulletin_board.comments
Route::apiResource('bulletin_boards/{bulletin_board_id}/comments', 'API\BulletinBoardCommentController')->only([
    "index", "store"
])->names([
    "index" => "bulletin_board.comments.index",
    "store" => "bulletin_boards.comments.store"
]);

//chats
Route::apiResource('chats', 'API\ChatController');

//chat.contents
Route::apiResource('chats/{chat_room_id}/contents', 'API\ChatContentController')->only([
    "index", "store"
])->names([
    "index" => "chat.contents.index",
    "store" => "chat.contents.store"
]);

//chat.members
Route::delete('chats/{chat_room_id}/members', 'API\ChatMemberController@destroies')->name("chat.members.destroies");
Route::apiResource('chats/{chat_room_id}/members', 'API\ChatMemberController')->only([
    "index", "store", "destroy", "destroies"
])->names([
    "index" => "chat.members.index",
    "store" => "chat.members.store",
    "destroy" => "chat.members.destroy"
]);

//admin.members
Route::apiResource('admin/members', 'API\admin\MemberController')->only([
    "show"
])->names([
    "show" => "admin.members.show"
]);

//admin.companies
Route::apiResource('admin/companies', 'API\admin\CompanyController')->only([
    "show"
])->names([
    "show" => "admin.companies.show"
]);

//admin.stamp_groups
Route::apiResource('admin/stamp_groups', 'API\admin\StampGroupController')->only([
    "index", "show"
])->names([
    "index" => "admin.stamp_groups.index",
    "show" => "admin.stamp_groups.show"
]);

//admin.informations
Route::apiResource('admin/informations', 'API\admin\InformationController')->only([
    "index", "show"
])->names([
    "index" => "admin.informations.index",
    "show" => "admin.informations.show"
]);
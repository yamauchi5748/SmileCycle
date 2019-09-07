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

//admin.members
Route::apiResource('members', 'API\admin\MemberController')->only([
    "store", "update", "destroy"
])->names([
    "store" => "admin.members.store",
    "update" => "admin.members.update",
    "destory" => "admin.members.destory",
]);

//members
Route::apiResource('members', 'API\MemberController')->only([
    "index", "show"
])->names([
    "index" => "members.index",
    "show" => "members.show",
]);

//settings
Route::put('settings', 'API\SettingController@update')->name('settings.update');
Route::apiResource('settings', 'API\SettingController')->only([
    "index"
])->names([
    "index" => "settings.index",
]);

//admin.member.stamp_groups
Route::apiResource('members/{member_id}/stamp_groups', 'API\admin\MemberStampGroupController')->only([
    "index"
])->names([
    "index" => "member.stamp_groups.index",
]);

//admin.companies
Route::apiResource('companies', 'API\admin\CompanyController')->only([
    "store", "update", "destroy"
])->names([
    "store" => "admin.companies.store",
    "update" => "admin.companies.update",
    "destroy" => "admin.companies.destroy",
]);

//companies
Route::apiResource('companies', 'API\CompanyController')->only([
    "index", "show"
])->names([
    "index" => "companies.index",
    "show" => "companies.show",
]);

//admin.stamp_groups
Route::delete('stamp-groups', 'API\admin\StampGroupController@destroy')->name('admin.stamp_groups.destroy');
Route::apiResource('stamp-groups', 'API\admin\StampGroupController')->only([
    "store"
])->names([
    "store" => "admin.stamp_groups.store",
]);

//stamp_groups
Route::apiResource('stamp-groups', 'API\StampGroupController')->only([
    "index"
])->names([
    "index" => "stamp_groups.index",
]);

//admin.invitations
Route::apiResource('invitations', 'API\admin\InvitationController')->only([
    "store"
])->names([
    "store" => "admin.invitations.store",
]);

//invitations
Route::apiResource('invitations', 'API\InvitationController')->only([
    "index", "show"
])->names([
    "index" => "invitations.index",
    "show" => "invitations.show"
]);

//invitation.members
Route::apiResource('invitations/{invitation_id}/members', 'API\InvitationMemberController')->only([
    "update"
])->names([
    "update" => "invitation.members.update",
]);

//forums
Route::apiResource('forums', 'API\ForumController')->only([
    "index", "show", "store"
])->names([
    "index" => "forums.index",
    "show" => "forums.show",
    "store" => "forums.store",
]);

//forum.comments
Route::apiResource('forums/{forum_id}/comments', 'API\ForumCommentController')->only([
    "index", "store"
])->names([
    "index" => "forum.comments.index",
    "store" => "forum.comments.store"
]);

//chat_rooms
Route::apiResource('chat-rooms', 'API\ChatRoomController');

//chat_room.contents
Route::apiResource('chat-rooms/{chat_room_id}/contents', 'API\ChatRoomContentController')->only([
    "index", "store"
])->names([
    "index" => "chat_room.contents.index",
    "store" => "chat_room.contents.store"
]);

//chat.members
Route::delete('chat-rooms/{chat_room_id}/members', 'API\ChatRoomMemberController@destroies')->name("chat_room.members.destroies");
Route::apiResource('chat-rooms/{chat_room_id}/members', 'API\ChatRoomMemberController')->only([
    "index", "store", "destroy"
])->names([
    "index" => "chat_room.members.index",
    "store" => "chat_room.members.store",
    "destroy" => "chat_room.members.destroy"
]);
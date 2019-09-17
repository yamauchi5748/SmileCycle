<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Str;
use App\Http\Requests\InvitationPost;
use Carbon\Carbon;
use App\Models\Member;
use App\Models\ChatRoom;

class ChatRoomController extends AuthController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return [ "response" => "return chat_rooms.index"];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /** チャットグループ作成 **/
        // モデル作成
        $chat_group = [
            '_id' => (string) Str::uuid(),              // チャットグループのid
            'is_group' => $request->is_group,           // チャットグループの種類
            'admin_member_id' => $this->author->_id,    // チャットグループの管理者
            'group_name' => $request->group_name,       // チャットグループのグループ名
            'members' => $request->members,             // チャットグループの会員
            'contents' => [],
        ];

        // 投稿者もグループ会員に追加
        $chat_group['members'][] = $this->author->_id;

        /* DBにモデル登録 */
        ChatRoom::raw()->insertOne($chat_group);
        return $chat_group;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($chat_room_id)
    {
        return [ "response" => "return chat_rooms.show"];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $chat_room_id)
    {
        return [ "response" => "return chat_rooms.update"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($chat_room_id)
    {
        return [ "response" => "return chat_rooms.destroy"];
    }
}

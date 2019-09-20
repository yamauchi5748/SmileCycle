<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController;
use App\Models\Member;
use App\Models\ChatRoom;

class ChatRoomMemberController extends AuthController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($chat_room_id)
    {
        return [ "response" => "return chat_room.members.index"];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $chat_room_id)
    {
        /** 会員をルームに追加する **/
        /* 会員の情報を取得 */
        $members = Member::raw()->aggregate([
            [
                '$match' => [
                    '_id' => [
                        '$in' => $request->add_members
                    ]
                ]
            ],
            [
                '$project' => [
                    '_id' => 1,
                    'name' => 1
                ]
            ]
        ])->toArray();

        /* ルーム更新 */
        ChatRoom::raw()->updateOne(
            [
                '_id' => $chat_room_id,
                /* ルームの管理者認証 */
                'admin_member_id' => $this->author->_id
            ],
            [
                '$push' => [
                    'members' => [
                        '$each' => $members
                    ]
                ]
            ]
        );
        
        /* 更新したルーム情報を取得 */
        $room_corsor = ChatRoom::raw()->aggregate([
            /* ルームを指定 */
            [
                '$match' => [
                    '_id' => $chat_room_id,
                    'admin_member_id' => $this->author->_id
                ]
            ],
            [
                '$project' => [
                    '_id' => 1,
                    'members' => 1,

                ]
            ]
        ])->toArray();

        /* 返すレスポンスデータを整形 */
        $room = head($room_corsor);
        if($room){
            $this->response['room'] = $room;
        }else{
            $this->response['result'] = false;
        }

        return response()->json(
            $this->response,
            200,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($chat_room_id, $member_id)
    {
        return [ "response" => "return chat_room.members.show"];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $chat_room_id, $member_id)
    {
        return [ "response" => "return chat_room.members.update"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($chat_room_id, $member_id)
    {
        return [ "response" => "return chat_room.members.destroy"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroies(Request $request, $chat_room_id)
    {
        /** 会員をルームから退出させる **/
        /* 会員の情報を取得 */
        $members = Member::raw()->aggregate([
            [
                '$match' => [
                    '_id' => [
                        '$in' => $request->delete_members
                    ]
                ]
            ],
            [
                '$project' => [
                    '_id' => 1,
                    'name' => 1
                ]
            ]
        ])->toArray();

        /* ルーム更新 */
        ChatRoom::raw()->updateOne(
            [
                '_id' => $chat_room_id,
                /* ルームの管理者認証 */
                'admin_member_id' => $this->author->_id,
                'admin_member_id' => [
                    '$not' => [
                        '$in' => $request->delete_members
                    ]
                ]
            ],
            [
                '$pullAll' => [
                    'members' => $members
                ]
            ]
        );
        
        /* 更新したルーム情報を取得 */
        $room_corsor = ChatRoom::raw()->aggregate([
            /* ルームを指定 */
            [
                '$match' => [
                    '_id' => $chat_room_id,
                    /* 管理者認証、管理者が削除されてないか */
                    'admin_member_id' => $this->author->_id,
                    'admin_member_id' => [
                        '$not' => [
                            '$in' => $request->delete_members
                        ]
                    ]
                ]
            ],
            [
                '$project' => [
                    '_id' => 1,
                    'members' => 1,

                ]
            ]
        ])->toArray();

        /* 返すレスポンスデータを整形 */
        $room = head($room_corsor);
        if($room){
            $this->response['room'] = $room;
        }else{
            $this->response['result'] = false;
        }

        return response()->json(
            $this->response,
            200,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }
}

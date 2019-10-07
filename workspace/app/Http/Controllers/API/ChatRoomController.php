<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Requests\ChatRoomPost;
use App\Http\Requests\ChatRoomPut;
use App\Http\Requests\ChatRoomDelete;
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
        /* 会員が属しているルームを返す */
        $rooms_corsor = ChatRoom::raw()->aggregate([
            /* 会員のルームを指定 */
            [
                '$match' => [
                    'members._id' => [
                        '$in' => [$this->author->_id, '$members._id']
                    ],
                ]
            ],
            // コンテンツを最大10件取得
            [
                '$project' => [
                    '_id' => 1,
                    'is_group' => 1,
                    'is_department' => 1,
                    'admin_member_id' => 1,
                    'group_name' => 1,
                    'members' => 1,
                    'contents' => [
                        '$slice' => [ '$contents', 0, 10]
                    ],
                    'contents' => [
                        '$cond' => [
                            'if' => [
                                '$eq' => ['$contents', []]
                            ],
                            'then' => [
                                [
                                    'already_read' => []
                                ]
                            ],
                            'else' => '$contents'
                        ]
                    ]
                ]
            ],
            /* コンテンツを展開 */
            [
                '$unwind' => '$contents'
            ],
            /* 既読数,未読数をセット */
            [
                '$set' => [
                    'contents.unread' => [
                        '$in' => [ $this->author->_id, '$contents.already_read']
                    ],
                    'contents.already_read' => [
                        '$cond' => [
                            'if' => [
                                '$eq' => ['$contents.sender_id', $this->author->_id]
                            ],
                            'then' => [
                                '$size' => '$contents.already_read'
                            ],
                            'else' => -1
                        ]
                    ],
                ]
            ],
            /* ルームをまとめる */
            [
                '$group' => [
                    '_id' => '$_id',
                    'is_group' => [
                        '$first' => '$is_group'
                    ],
                    'is_department' => [
                        '$first' => '$is_department'
                    ],
                    'admin_member_id' => [
                        '$first' => '$admin_member_id'
                    ],
                    'group_name' => [
                        '$first' => '$group_name'
                    ],
                    'members' => [
                        '$first' => '$members'
                    ],
                    'contents' => [
                        '$push' => '$contents'
                    ]
                ]
            ],
            /* コンテンツの投稿日時順にソート */
            [
                '$sort' => [
                    'is_department' => -1,
                    'contents.0.created_at' => -1
                ]
            ]
        ])->toArray();
        
        /* 返すレスポンスデータを整形 */
        $head_corsor = head($rooms_corsor);
        if ($head_corsor) {
            $this->response['rooms'] = $rooms_corsor;
        } else {
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChatRoomPost $request)
    {
        /** チャットグループ作成 **/
        // モデル作成
        $chat_group = [
            '_id' => (string) Str::uuid(),              // チャットグループのid
            'is_group' => $request->is_group,           // チャットグループの種類
            'is_department' => 0,                       // 部門チャットグループであるか
            'admin_member_id' => $this->author->_id,    // チャットグループの管理者
            'group_name' => $request->group_name,       // チャットグループのグループ名
            'members' => $request->members,             // チャットグループの会員
            'contents' => [],
        ];

        // 投稿者もグループ会員に追加
        $chat_group['members'][] = $this->author->_id;
        
        /* 会員の情報を取得 */
        $members = Member::raw()->aggregate([
            [
                '$match' => [
                    '_id' => [
                        '$in' => $chat_group['members']
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
        $chat_group['members'] = $members;

        // チャットグループのアイコン画像をストレージに保存
        Storage::copy('images/boy_3.png', 'private/images/chats/' . $chat_group['_id'] . '.png');

        /* DBにモデル登録 */
        ChatRoom::raw()->insertOne($chat_group);

        /* 返すレスポンスデータを整形 */
        $this->response['chat_room'] = $chat_group;
        
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
    public function update(ChatRoomPut $request, $chat_room_id)
    {
        $rooms = ChatRoom::raw()->aggregate([
            [
                '$match' => [
                    '_id' => $chat_room_id,
                    'is_department' => 0,
                    'admin_member_id' => $this->author->_id
                ]
            ]
        ])->toArray();
        $room = head($rooms);

        /* 不正なリクエストでルームが取得できなかった場合 */
        if (!$room) {
            $this->response['result'] = false;
            return $this->response;
        }

        /** グループ名を更新 **/
        ChatRoom::raw()->updateOne(
            [
                '_id' => $chat_room_id,
                'is_department' => 0,
                'admin_member_id' => $this->author->_id
            ],
            [
                '$set' => [
                    'group_name' => $request->new_group_name
                ]
            ]
        );

        /* グループアイコン画像変更 */
        if ($request->new_icon) {
            Storage::putFileAs('private/images/chats', $request->new_icon, $room['_id'] . '.png', 'private');
        }

        /* 更新したルーム情報を取得 */
        $rooms = ChatRoom::raw()->aggregate([
            /* ルームを指定 */
            [
                '$match' => [
                    '_id' => $chat_room_id
                ]
            ],
            [
                '$project' => [
                    '_id' => 1,
                    'group_name' => 1,

                ]
            ]
        ])->toArray();

        /* 返すレスポンスデータを整形 */
        $room = head($rooms);
        if ($room) {
            $this->response['room'] = $room;
        } else {
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChatRoomDelete $request, $chat_room_id)
    {
        /** ルームを削除 **/
        ChatRoom::raw()->deleteOne(
            [
                '_id' => $chat_room_id,
                'is_department' => 0,
                'admin_member_id' => $this->author->_id
            ]
        );
        
        /* ルームを取得 存在チェックのため */
        $room_corsor = ChatRoom::raw()->aggregate([
            /* ルームを指定 */
            [
                '$match' => [
                    '_id' => $chat_room_id,
                ]
            ]
        ])->toArray();

        /* ルームが削除されたか */
        $room = head($room_corsor);
        if ($room) {
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

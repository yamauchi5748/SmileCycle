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
            // 個チャ用に一人目の会員と二人目の会員を保持
            [
                '$set' => [
                    'first_member' => [
                        '$arrayElemAt' => ['$members', 0]
                    ],
                    'last_member' => [
                        '$arrayElemAt' => ['$members', 1]
                    ],
                ]
            ],
            [
                '$project' => [
                    '_id' => 1,
                    'is_group' => 1,
                    'is_department' => 1,
                    'admin_member_id' => 1,
                    // 個チャならば相手の名前をグループ名にセット
                    'group_name' => [
                        '$cond' => [
                            'if' => [
                                '$eq' => ['$is_group', true]
                            ],
                            'then' => '$group_name',
                            'else' => [
                                '$cond' => [
                                    'if' => [
                                        '$eq' => ['$first_member._id', $this->author->_id]
                                    ],
                                    'then' => '$last_member.name',
                                    'else' => '$first_member.name'
                                ]
                            ]
                        ]
                    ],
                    'members' => 1,
                    'contents' => 1
                ]
            ],
            // コンテンツが空でないかの処理
            [
                '$set' => [
                    'contents' => [
                        '$cond' => [
                            'if' => [
                                '$eq' => ['$contents', []]
                            ],
                            'then' => [
                                [
                                    'is_none' => true
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
                        '$cond' => [
                            'if' => [
                                '$or' => [
                                    [
                                        '$eq' => ['$contents.is_none', true]
                                    ],
                                    [
                                        '$eq' => ['$contents.sender_id', $this->author->_id]
                                    ]
                                ]
                            ],
                            'then' => false,
                            'else' => [
                                '$not' => [
                                    '$in' => [ $this->author->_id, '$contents.already_read']
                                ]
                            ]
                        ]
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
                    ],
                    'unread' => [
                        '$sum' => [
                            '$cond' => [
                                'if' => '$contents.unread',
                                'then' => 1,
                                'else' => 0
                            ]
                        ]
                    ]
                ]
            ],
            /* コンテンツの中身をリバースする */
            [
                '$set' => [
                    'contents' => [
                        '$reverseArray' => [
                            // コンテンツを最大10件取得
                            '$slice' => [ '$contents', 0, 10]
                        ]
                    ]
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
            'contents' => []
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
        $chat_group['contents'][] = [
            'is_none' => true,
            'unread' => false,
            'already_read' => -1
        ];
        $chat_group['unread'] = 0;
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

        $room =
        /* 返すレスポンスデータを整形 */
        $this->response['room'] = [
            '_id' => $chat_room_id,
            'group_name' => $request->new_group_name
        ];

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

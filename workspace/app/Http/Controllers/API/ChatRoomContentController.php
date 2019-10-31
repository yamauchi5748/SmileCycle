<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Http\Requests\ChatRoomContentGet;
use App\Http\Requests\ChatRoomContentPost;
use App\Http\Requests\ChatRoomContentPut;
use Carbon\Carbon;
use App\Models\Member;
use App\Models\ChatRoom;
use App\Events\ChatRecieved;
use App\jobs\ProcessPodcast;

class ChatRoomContentController extends AuthController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ChatRoomContentGet $request, $chat_room_id)
    {
        /** ルームのコンテンツを返す **/
        $contents_corsor = ChatRoom::raw()->aggregate([
            /* ルームを指定 */
            [
                '$match' => [
                    '_id' => $chat_room_id,
                    'members._id' => [
                        '$in' => [ $this->author->_id, '$members._id']
                    ]
                ]
            ],
            /* コンテンツを展開 */
            [
                '$unwind' => '$contents'
            ],
            /* 既読数をセット */
            [
                '$set' => [
                    'contents.unread' => [
                        '$cond' => [
                            'if' => [
                                [
                                    '$eq' => ['$contents.sender_id', $this->author->_id]
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
                    ]
                ]
            ],
            /* コンテンツをまとめる */
            [
                '$group' => [
                    '_id' => '$_id',
                    'contents' => [
                        '$push' => '$contents'
                    ]
                ]
            ],
            // コンテンツを最大10件取得
            [
                '$project' => [
                    'contents' => [
                        '$reverseArray' => [
                            '$slice' => [ '$contents', (int) $request->content_count, 10]
                        ]
                    ]
                ]
            ]
        ])->toArray();

        /* 返すレスポンスデータを整形 */
        $head_corsor = head($contents_corsor);
        if ($head_corsor && head($head_corsor['contents'])) {
            $this->response['contents'] = $head_corsor['contents'];
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
    public function store(ChatRoomContentPost $request, $chat_room_id)
    {
        /* 不正なリクエストかどうか */
        $room = head(ChatRoom::raw()->aggregate([
            [
                '$match' => [
                    '_id' => $chat_room_id
                ]
            ],
            [
                '$project' => [
                    '_id' => 0,
                    'is_auth' => [
                        '$in' => [$this->author->_id, '$members._id']
                    ]
                ]
            ]
        ])->toArray());
        if (!$room['is_auth']) {
            $this->response['auth'] = false;
            $this->response['result'] = false;
            return $this->response;
        }

        $now  = (string) Carbon::now('Asia/Tokyo');     // 現在時刻

        /** チャットコンテンツ投稿 **/
        /* チャットモデル */
        $chat = [
            '_id' => (string) Str::uuid(),              // チャットid
            'is_hurry' => $request->is_hurry,           // 急ぎチャットかどうか
            'content_type' => $request->content_type,   // チャットの種類
            'sender_id' => $this->author->_id,          // 送信者のid
            'created_at' => $now,                       // 送信日時
            'already_read' => []                        // 既読した会員のidを格納
        ];

        // チャットコンテンツのタイプによって処理
        switch ($chat['content_type']) {
            case '1':
                // メッセージ
                $chat['message'] = $request->message;
                break;
            case '2':
                // スタンプ
                $chat['stamp_id'] = $request->stamp_id;
                break;
            case '3':
                // 画像
                /* 画像のuuidを生成 */
                $image_id = (string) Str::uuid();
    
                /* 画像を保存 */
                Storage::putFileAs('private/images/chats', $request->image, $image_id . '.png', 'private');
            
                /* モデルに画像のidを追加 */
                $chat['content_id'] = $image_id;
                break;
            case '4':
                // 動画
                /* 動画のuuidを生成 */
                $video_id = (string) Str::uuid();
    
                /* 動画を保存 */
                Storage::putFileAs('private/videos/', $request->video, $video_id . '.' . $request->video->extension(), 'private');
            
                /* モデルに動画のidを追加 */
                $chat['content_id'] = $video_id;
                break;
        }

        /* 会員の情報を取得 */
        $sender_corsor = Member::raw()->aggregate([
            [
                '$match' => [
                    '_id' => $chat['sender_id']
                ]
            ],
            [
                '$project' => [
                    '_id' => 1,
                    'name' => 1
                ]
            ]
        ])->toArray();
        $chat['sender_name'] = head($sender_corsor)->name;

        /* DBにモデル登録 */
        ChatRoom::raw()->updateOne(
            [
                '_id' => $chat_room_id
            ],
            [
                '$push' => [
                    'contents' => [
                        '$each' => [$chat],
                        '$position' => 0
                    ]
                ]
            ]
        );

        /* 急ぎチャットならばメール通知ジョブをバックグラウンドで実行 */
        if ($chat['is_hurry']) {
            
            /* ルーム情報を取得 */
            $room = head(ChatRoom::raw()->aggregate([
                [
                    '$match' => [
                        '_id' => $chat_room_id
                    ]
                ],
                [
                    '$project' => [
                        '_id' => 0,
                        'group_name' => 1,
                        'members' => 1,
                    ]
                ]
            ])->toArray());

            $to_members = $room['members'];
        
            /* ルーム会員に送信するメール情報をセット */
            foreach ($to_members as $to_member) {
                $to_member = head(Member::raw()->aggregate([
                    [
                        '$match' => [
                            '_id' => $to_member->_id
                        ]
                    ],
                    [
                        '$project' => [
                            'name' => 1,
                            'mail' => 1
                        ]
                    ]
                ])->toArray());

                /* メール通知を飛ばす */
                $job = (new ProcessPodcast($room, $chat, $to_member));

                // jobs テーブルに登録
                dispatch($job);
            }
        }

        /* 返すレスポンスデータを整形 */
        $this->response['content'] = $chat;

        /* チャット内にブロードキャスト */
        broadcast(new ChatRecieved($chat_room_id, $chat))->toOthers();
        
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
    public function show($chat_room_id, $content_id)
    {
        return [ "response" => "return chat_room.contents.show"];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ChatRoomContentPut $request, $chat_room_id)
    {
        /** 既読処理 **/
        /* コンテンツ取得 */
        $contents = ChatRoom::raw()->aggregate([
            [
                '$match' => [
                    '_id' => $chat_room_id,
                    'contents._id' => [
                        '$in' => $request->unread_contents
                    ]
                ]
            ],
            [
                '$project' => [
                    '_id' => 0,
                    'contents' => 1
                ]
            ]
        ])->toArray();
        $unread_contents = head($contents)['contents'];
        
        /* 対象のコンテンツを探索し、認証ユーザーを追加 */
        foreach ($unread_contents as $content) {
            /* 既に既読しているかチェック */
            $contains = Arr::first($content->already_read, function ($value, $key) {
                return $value == $this->author->_id;
            }, false);
            if ($contains) {
                $this->response['result'] = false;
            } else {
                $content->already_read[] = $this->author->_id;
            }
        }

        /* DBを更新 */
        ChatRoom::raw()->updateMany(
            [
                '_id' => $chat_room_id
            ],
            [
                '$set' => [
                    'contents' => $unread_contents
                ]
            ]
        );
        
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
    public function destroy($chat_room_id, $content_id)
    {
        return [ "response" => "return chat_room.contents.destroy"];
    }
}

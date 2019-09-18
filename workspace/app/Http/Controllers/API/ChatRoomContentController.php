<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Requests\InvitationPost;
use Carbon\Carbon;
use App\Models\Member;
use App\Models\ChatRoom;

class ChatRoomContentController extends AuthController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($chat_room_id)
    {
        /* 会員が属しているルームを返す */
        $contents_corsor = ChatRoom::raw()->aggregate([
            /* 会員のルームを指定 */
            [
                '$match' => [
                    '_id' => $chat_room_id,
                    'members' => [
                        '$in' => [$this->author->_id, '$members']
                    ]
                ]
            ],
            /* 各コンテンツを展開 */
            [
                '$unwind' => '$contents'
            ],
            /* membersコレクションと結合 */
            [
                '$lookup' => [
                    'from' => 'members',
                    'localField' => 'contents.sender_id',
                    'foreignField' => '_id',
                    'as' => 'Members'
                ]
            ],
            [
                '$project' => [
                    'contents' => [
                        '_id' => 1,
                        'content_type' => 1,
                        'created_at' => 1,
                        'already_read' => [
                            '$size' => '$contents.already_read'
                        ],
                        'message' => 1,
                        'stamp_id' => 1,
                        'content_id' => 1,
                        'sender_id' => 1,
                        'sender_name' => [
                            '$arrayElemAt' => ['$Members.name', 0]
                        ],
                    ]
                ]
            ],
            /* コンテンツの投稿日時順にソート */
            [
                '$sort' => [
                    'contents.created_at' => 1
                ]
            ],
            /* 展開したプロパティをまとめる */
            [
                '$group' => [
                    '_id' => '$_id',
                    'contents' => [
                        '$push' => '$contents'
                    ]
                ]
            ],
            [
                '$sort' => [
                    'contents.created_at' => 1
                ]
            ],
            /* 返すプロパティを指定 */
            [
                '$project' => [
                    '_id' => 0,
                    'contents' => [
                        '$slice' => ['$contents', 0, 10]
                    ]
                ]
            ]
        ])->toArray();

        /* 返すレスポンスデータを整形 */
        $head_corsor = head($contents_corsor);
        if($head_corsor && head($head_corsor['contents'])){
            $this->response['contents'] = $head_corsor['contents'];
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $chat_room_id)
    {
        $now  = (string) Carbon::now('Asia/Tokyo')->format('Y/m/d H:i'); // 現在時刻

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
                Storage::putFileAs('private/images/chats', $request->content, $image_id . '.png', 'private');
            
                /* モデルに画像のidを追加 */
                $chat['content_id'] = $image_id;
                break;
            case '4':
                // 動画
                /* 動画のuuidを生成 */
                $video_id = (string) Str::uuid();
    
                /* 動画を保存 */
                Storage::putFileAs('private/videos/', $request->content, $video_id . '.' . $request->content->extension(), 'private');
            
                /* モデルに動画のidを追加 */
                $chat['content_id'] = $video_id;
                break;
        }

        /* DBにモデル登録 */
        ChatRoom::raw()->updateOne(
            [
                '_id' => $chat_room_id
            ],
            [
                '$push' => [
                    'contents' => $chat 
                ]
            ]
        );
        
        return $chat;
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
    public function update(Request $request, $chat_room_id, $content_id)
    {
        return [ "response" => "return chat_room.contents.update"];
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

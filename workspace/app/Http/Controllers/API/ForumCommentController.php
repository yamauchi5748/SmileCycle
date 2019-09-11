<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\ForumCommentPost;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Forum;

class ForumCommentController extends AuthController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($forum_id)
    {
        return [ "response" => "return forum.comments.index"];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($forum_id, ForumCommentPost $request)
    {
        /** 掲示板にコメント投稿 **/
        $now  = (string) Carbon::now('Asia/Tokyo'); // 現在時刻

        /* コメントのモデル */
        $comment = [
            '_id' => (string) Str::uuid(),              // コメントのid
            'sender_id' => $this->author->_id,          // コメントの投稿者id
            'sender_name' => $this->author->name,       // コメントの投稿者名
            'comment_type' => $request->comment_type,   // コメントのタイプ
            'created_at' => $now                        // コメント投稿日
        ];

        /* コメントタイプ別に処理 */
        if($comment['comment_type'] == 1)
        {
            /* テキスト */
            $comment['text'] = $request->text;
        }else if($comment['comment_type'] == 2)
        {
            /* スタンプ */
            $comment['stamp_id'] = $request->stamp_id;
        }

        /* コメントを掲示板に追加 */
        Forum::raw()->updateOne(
            [
                '_id' => $forum_id
            ],
            [
                '$push' => [
                    'comments' => $comment
                ]
            ]
        );

        /* 返すレスポンスデータを整形 */
        $this->response['comment'] = $comment;
        
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
    public function show($forum_id, $forum_comment_id)
    {
        return [ "response" => "return forum.comments.show"];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($forum_id, Request $request, $forum_comment_id)
    {
        return [ "response" => "return forum.comments.update"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($forum_id, $forum_comment_id)
    {
        return [ "response" => "return forum.comments.delete"];
    }
}

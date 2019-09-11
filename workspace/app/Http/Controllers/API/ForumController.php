<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\ForumPost;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Forum;

class ForumController extends AuthController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return [ "response" => "return forums.index"];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ForumPost $request)
    {
        /** 掲示板を登録 **/
        $now  = (string) Carbon::now('Asia/Tokyo'); // 現在時刻

        /* 掲示板のモデル */
        $forum = [
            '_id' => (string) Str::uuid(),          // 掲示板のid
            'sender_id' => $this->author->_id,      // 掲示板の投稿者id
            'sender_name' => $this->author->name,   // 掲示板の投稿者名
            'title' => $request->title,             // 掲示板のタイトル
            'text' => $request->text,               // 掲示板のテキスト
            'images' => [],                         // 掲示板の画像
            'comments' => [],                       // 掲示板のコメント
            'created_at' => $now                    // 掲示板投稿日
        ];

        /* 画像コンテンツの処理 */
        if ($request->images) {
            foreach ($request->images as $image) {
                /* 画像のuuidを生成 */
                $image_id = (string) Str::uuid();
    
                /* 画像を保存 */
                Storage::putFileAs('public/images/forums', $image, $image_id . '.png', 'private');
            
                /* モデルに画像のidを追加 */
                $forum['images'][] = $image_id;
            }
        }

        /* モデルをDBに登録 */
        Forum::raw()->insertOne($forum);

        /* 返すレスポンスデータを整形 */
        if($forum){
            $this->response['forum'] = $forum;
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
    public function show($forum_id)
    {
        return [ "response" => "return forums.show"];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $forum_id)
    {
        return [ "response" => "return forums.update"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($forum_id)
    {
        return [ "response" => "return forums.destroy"];
    }
}

<?php

namespace App\Http\Controllers\API\admin;

use Illuminate\Http\Request;
use App\Http\Requests\AdminForumPut;
use App\Http\Controllers\Auth\AdminAuthController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Models\Forum;

class ForumController extends AdminAuthController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminForumPut $request, $forum_id)
    {
        /* リクエストのパラメタをチェック */
        if (!$request->add_images) {
            $request->add_images = [];
        }
        if (!$request->delete_images) {
            $request->delete_images = [];
        }

        /** 掲示板を編集 **/

        /* 掲示板モデル */
        $forum = head(Forum::raw()->aggregate([
            [
                '$match' => [
                    '_id' => $forum_id
                ]
            ]
        ])->toArray());
        
        $forum['title'] = $request->title;
        $forum['text'] = $request->text;

        /* 画像追加 */
        foreach ($request->add_images as $new_image) {
            /* 画像のuuidを生成 */
            $image_id = (string) Str::uuid();

            /* 画像を保存 */
            Storage::putFileAs('private/images/forums', $new_image, $image_id . '.png', 'private');
        
            /* モデルに画像のidを追加 */
            $forum['images'][] = $image_id;
        }

        /* 画像削除 */
        foreach ($request->delete_images as $image_id) {
            Storage::delete('private/images/forums/' . $image_id . '.png');
        }

        /* 掲示板更新 */
        Forum::raw()->updateOne(
            [
                '_id' => $forum_id
            ],
            [
                '$set' => $forum
            ]
        );

        /* 掲示板更新 */
        Forum::raw()->updateOne(
            [
                '_id' => $forum_id
            ],
            [
                '$pullAll' => [
                    'images' => $request->delete_images
                ]
            ]
        );

        $this->response['forum'] = head(Forum::raw()->aggregate([
            [
                '$match' => [
                    '_id' => $forum_id
                ]
            ]
        ])->toArray());


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
    public function destroy($forum_id)
    {
        /* 掲示板削除 */
        Forum::raw()->deleteOne(
            [
                '_id' => $forum_id
            ]
        );

        return response()->json(
            $this->response,
            200,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }
}

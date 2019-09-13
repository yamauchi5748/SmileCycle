<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Auth\AuthController;
use App\Models\StampGroup;
use App\Models\Forum;

class ImageController extends AuthController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->response['result'] = false;
    }

    /**
     * 特定の掲示板に投稿されたスタンプ
     * 認可されたスタンプ画像を返す
    **/
    public function forumStamp($forum_id, $stamp_id)
    {
        /* スタンプが掲示板に投稿されているかチェック */
        $has_stamp_corsor = Forum::raw()->aggregate([
            [
                '$match' => [
                    '_id' => $forum_id 
                ]
            ],
            [
                '$project' => [
                    'stamp' => [
                        '$in' => [ $stamp_id, '$comments.stamp_id' ]
                    ]
                ]
            ]
        ])->toArray();

        /* 認可できれば画像を返す */
        return head($has_stamp_corsor)['stamp'] ? 
            Storage::download('private/images/stamps/' . $stamp_id . '.png') : $this->response;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Auth\AuthController;
use App\Models\Member;
use App\Models\StampGroup;
use App\Models\Forum;
use App\Models\Invitation;
use App\Models\ChatRoom;

class ImageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->author = Auth::user();
    }

    /**
     * 特定の会員のプロフィール画像
     * 認可された画像を返す
    **/
    public function memberImage($member_id)
    {
        /* 会員が存在するかチェック */
        $has_member_corsor = Member::raw()->aggregate([
            [
                '$match' => [
                    '_id' => $member_id
                ]
            ]
        ])->toArray();

        /* 認可できれば画像を返す */
        if(head($has_member_corsor)){
            $image = storage_path('app/private/images/profile_images/' . $image_id . '.png');

            return response()->file($image);
        }
    }

    /**
     * スタンプ画像
     * 認可されたスタンプ画像を返す
    **/
    public function stampImage($image_id)
    {
        /* スタンプが存在するかチェック */
        $has_stamp_corsor = StampGroup::raw()->aggregate([
            [
                '$match' => [
                    '$or' => [
                        [
                            'tab_image_id' => $image_id,
                        ],
                        [
                            'stamps' => $image_id
                        ]
                    ]
                ]
            ]
        ])->toArray();

        /* 認可できればスタンプを返す */
        if(head($has_stamp_corsor)){
            $image = storage_path('app/private/images/stamps/' . $image_id . '.png');

            return response()->file($image);
        }
    }

    /**
     * 特定の掲示板に投稿された画像
     * 認可された画像を返す
    **/
    public function forumImage($forum_id, $image_id)
    {
        /* 画像が掲示板に投稿されているかチェック */
        $has_image_corsor = Forum::raw()->aggregate([
            [
                '$match' => [
                    '_id' => $forum_id
                ]
            ],
            [
                '$project' => [
                    'image' => [
                        '$in' => [ $image_id, '$images' ]
                    ]
                ]
            ]
        ])->toArray();

        /* 認可できれば画像を返す */
        if(head($has_image_corsor)){
            $image = storage_path('app/private/images/forums/' . $image_id . '.png');

            return response()->file($image);
        }
    }
    
    /**
     * 特定の会のご案内に投稿された画像
     * 認可された画像を返す
    **/
    public function invitationImage($invitation_id, $image_id)
    {
        /* 画像が会のご案内に投稿されているかチェック */
        /* 認証会員が会のご案内に招待されているかチェック */
        $has_image_corsor = Invitation::raw()->aggregate([
            [
                '$match' => [
                    '_id' => $invitation_id
                ]
            ],
            [
                '$project' => [
                    'image' => [
                        '$in' => [ $image_id, '$images' ]
                    ],
                    'member' => [
                        '$in' => [ $this->author->_id, '$attend_members._id' ]
                    ]
                ]
            ]
        ])->toArray();
        
        /* 管理者もしくは、認可できれば画像を返す */
        if(head($has_image_corsor)){
            $image = storage_path('app/private/images/invitations/' . $image_id . '.png');

            return response()->file($image);
        }
    }

     /**
     * 特定のチャットルームに投稿された画像
     * 認可された画像を返す
    **/
    public function chatRoomImage($chat_room_id, $image_id)
    {
        /* 画像がチャットルームに投稿されているかチェック */
        /* 認証会員がチャットルームに属しているかチェック */
        $has_image_corsor = ChatRoom::raw()->aggregate([
            [
                '$match' => [
                    '_id' => $chat_room_id,
                    'members._id' => $this->author->_id
                ]
            ],
            [
                '$project' => [
                    'image' => [
                        '$in' => [ $image_id, '$contents.content_id' ]
                    ]
                ]
            ]
        ])->toArray();
        
        /* 認可できれば画像を返す */
        if(head($has_image_corsor)){
            $image = storage_path('app/private/images/chats/' . $image_id . '.png');

            return response()->file($image);
        }
    }
}

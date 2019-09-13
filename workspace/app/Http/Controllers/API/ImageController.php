<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Auth\AuthController;
use App\Models\Member;
use App\Models\StampGroup;
use App\Models\Forum;
use App\Models\Invitation;

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
        return head($has_member_corsor) ? 
            Storage::download('private/images/profile_images/' . $member_id . '.png') : $this->response;
    }

    /**
     * 特定の掲示板に投稿されたスタンプ
     * 認可されたスタンプを返す
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

        /* 認可できればスタンプを返す */
        return head($has_stamp_corsor)['stamp'] ? 
            Storage::download('private/images/stamps/' . $stamp_id . '.png') : $this->response;
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
        return head($has_image_corsor)['image'] ? 
            Storage::download('private/images/forums/' . $image_id . '.png') : $this->response;
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
        if(head($has_image_corsor)['image'] && ($this->author->is_admin || head($has_image_corsor)['member']) ){
            return Storage::download('private/images/invitations/' . $image_id . '.png');
        }
        return $this->response;
    }
}

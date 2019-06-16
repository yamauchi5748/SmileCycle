<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    // テーブル名
    protected $table = 'members';

    //　主キーのタイプを指定
    protected $keyType = string;

    //　自動インクリメントを無効
    public $incrementing = false;

    //　memberプロパティ
    protected $fillable = [
        'id', 'name', 'ruby', 'post', 'mail', 'api_token', 'password', 'profile_text', 'profile_image_url',
        'company_id', 'department_name', 'is_notification', 'notification_interval', 'is_admin'
    ];

    //　jsonなどに表示しないプロパティ
    protected $hidden = [
        'password'
    ];

    /*** modelの紐づけ ***/
    public function bulletinBoards()
    {
        return $this->hasMany('App\BulletinBoard');
    }

    public function bulletinBoardComments()
    {
        return $this->hasMany('App\BulletinBoardComment');
    }

    public function informations()
    {
        return $this->hasMany('App\Information');
    }

    public function informationAttends()
    {
        return $this->hasMany('App\InfomationAttends');
    }

    public function chats()
    {
        return $this->hasMany('App\Chat');
    }

    public function chatRooms()
    {
        return $this->hasMany('App\ChatRoom');
    }

    public function chatRoomMember()
    {
        return $this->hasMany('App\ChatRoomMember');
    }

    public function memberStamp()
    {
        return $this->hasMany('App\MemberStamp');
    }

    public function companies()
    {
        return $this->belongsTo('App\Company');
    }
}

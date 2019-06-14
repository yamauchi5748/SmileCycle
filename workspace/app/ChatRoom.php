<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    // テーブル名
    protected $table = 'chat_rooms';

    //　主キーのタイプを指定
    protected $keyType = string;

    //　自動インクリメントを無効
    public $incrementing = false;

    //　stamp_groupプロパティ
    protected $fillable = [
        'id', 'is_group', 'group_name', 'admin_member_id'
    ];

    /*** modelの紐づけ ***/
    public function chats()
    {
        return $this->hasMany('App\Chat');
    }

    public function chatRoomMembers()
    {
        return $this->hasMany('App\ChatRoomMember');
    }

    public function member()
    {
        return $this->belongsTo('App\Member');
    }
}

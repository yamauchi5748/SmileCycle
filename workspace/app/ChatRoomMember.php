<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatRoomMember extends Model
{
    // テーブル名
    protected $table = 'chat_rooms_members';

    protected $primaryKey = ['chat_room_id', 'member_id'];

    //　主キーのタイプを指定
    protected $keyType = string;

    //　自動インクリメントを無効
    public $incrementing = false;

    //　member_stampプロパティ
    protected $fillable = [
        'chat_room_id', 'member_id', 'checked_at'
    ];

    /*** modelの紐づけ ***/
    public function chatRoom()
    {
        return $this->belongsTo('App\ChatRoom');
    }

    public function member()
    {
        return $this->belongsTo('App\Member');
    }
}

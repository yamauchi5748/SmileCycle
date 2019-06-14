<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class chat extends Model
{
    // テーブル名
    protected $table = 'chats';

    //　主キーのタイプを指定
    protected $keyType = string;

    //　自動インクリメントを無効
    public $incrementing = false;

    //　stamp_groupプロパティ
    protected $fillable = [
        'id', 'chat_room_id', 'send_member_id', 'message', 'stamp_id', 'content_url', 'content_type', 'is_hurry', 'creted_at'
    ];
}

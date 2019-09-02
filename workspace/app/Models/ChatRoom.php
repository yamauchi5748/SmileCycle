<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ChatRoom extends Eloquent
{
    // テーブル名
    protected $collection = 'chat_rooms';

    // timestmapの自動付与を無効
    public $timestamps = false;

    //　stamp_groupプロパティ
    protected $fillable = [
        '_id', 'is_group', 'group_name', 'admin_member_id', 'chat', 'members'
    ];
}

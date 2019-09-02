<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Forum extends Eloquent
{
    // テーブル名
    protected $collection = 'forums';

    // timestmapの自動付与を無効
    public $timestamps = false;

    //　stamp_groupプロパティ
    protected $fillable = [
        'id', 'post_member_id', 'title', 'text', 'images', 'created_at', 'comments'
    ];
}

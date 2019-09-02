<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Invitation extends Eloquent
{
    // テーブル名
    protected $collection = 'invitation';

    // timestmapの自動付与を無効
    public $timestamps = false;

    //　stamp_groupプロパティ
    protected $fillable = [
        'id', 'post_member_id', 'title', 'text', 'images', 'deadline_at', 'created_at', 'attends'
    ];
}

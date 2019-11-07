<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Invitation extends Eloquent
{
    // テーブル名
    protected $collection = 'invitations';

    // timestmapの自動付与を無効
    public $timestamps = false;

    //　stamp_groupプロパティ
    protected $fillable = [
        '_id', 'title', 'text', 'images', 'deadline_at', 'created_at', 'attend_members'
    ];
}

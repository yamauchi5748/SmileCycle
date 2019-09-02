<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class StampGroup extends Eloquent
{
    // テーブル名
    protected $collection = 'stamp_groups';

    // timestmapの自動付与を無効
    public $timestamps = false;

    //　stamp_groupプロパティ
    protected $fillable = [
        '_id', 'tab_image_url', 'is_all', 'stamps', 'members'
    ];
}

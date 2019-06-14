<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StampGroup extends Model
{
    // テーブル名
    protected $table = 'stamp_groups';

    //　主キーのタイプを指定
    protected $keyType = string;

    //　自動インクリメントを無効
    public $incrementing = false;

    //　stamp_groupプロパティ
    protected $fillable = [
        'id', 'tab_image_url', 'is_all'
    ];
}

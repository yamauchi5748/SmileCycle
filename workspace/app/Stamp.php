<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stamp extends Model
{
    // テーブル名
    protected $table = 'stamps';

    //　主キーのタイプを指定
    protected $keyType = string;

    //　自動インクリメントを無効
    public $incrementing = false;

    //　stamp_groupプロパティ
    protected $fillable = [
        'id', 'stamp_group_id', 'image_url'
    ];
}

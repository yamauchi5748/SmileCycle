<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InformationContent extends Model
{
    // テーブル名
    protected $table = 'informations_contents';

    protected $primaryKey = ['informations_id', 'placement_id'];

    //　主キーのタイプを指定
    protected $keyType = string;

    //　自動インクリメントを無効
    public $incrementing = false;

    //　stamp_groupプロパティ
    protected $fillable = [
        'information_id', 'placement_id', 'text', 'image_url', 'cotent_type'
    ];
}

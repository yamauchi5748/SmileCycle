<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InformationAttend extends Model
{
    /// テーブル名
    protected $table = 'informations_attends';

    protected $primaryKey = ['information_id', 'member_id'];

    //　主キーのタイプを指定
    protected $keyType = string;

    //　自動インクリメントを無効
    public $incrementing = false;

    //　member_stampプロパティ
    protected $fillable = [
        'information_id', 'member_id', 'attend_status'
    ];
}

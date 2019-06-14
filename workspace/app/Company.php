<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    // テーブル名
    protected $table = 'companies';

    //　主キーのタイプを指定
    protected $keyType = string;

    //　自動インクリメントを無効
    public $incrementing = false;

    //　companyプロパティ
    protected $fillable = [
        'id', 'name', 'address', 'telephone_number'
    ];
}

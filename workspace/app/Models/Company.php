<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Company extends Eloquent
{
    // テーブル名
    protected $collection = 'companies';

    // timestmapの自動付与を無効
    public $timestamps = false;

    //　companyプロパティ
    protected $fillable = [
        '_id', 'name', 'address', 'telephone_number', 'members'
    ];
}

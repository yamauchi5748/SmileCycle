<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Company extends Eloquent
{
    // テーブル名
    protected $collection = 'companies';

    // timestmapの自動付与を無効
    public $timestamps = false;

    //　companyプロパティ
    protected $fillable = [
        'id', 'name', 'address', 'fax', 'tel'
    ];

    /*** modelの紐づけ ***/
    public function members()
    {
        return $this->hasMany('App\Member');
    }
}

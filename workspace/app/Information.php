<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    // テーブル名
    protected $table = 'informations';

    //　主キーのタイプを指定
    protected $keyType = string;

    //　自動インクリメントを無効
    public $incrementing = false;

    //　stamp_groupプロパティ
    protected $fillable = [
        'id', 'post_member_id', 'title', 'template', 'deadline_at', 'created_at'
    ];

    /*** modelの紐づけ ***/
    public function informationAttends()
    {
        return $this->hasMany('App\InformationAttend');
    }

    public function informationContents()
    {
        return $this->hasMany('App\InformationContent');
    }

    public function member()
    {
        return $this->belongsTo('App\Member');
    }
}

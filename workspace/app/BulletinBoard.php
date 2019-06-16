<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BulletinBoard extends Model
{
    // テーブル名
    protected $table = 'bulletin_boards';

    //　主キーのタイプを指定
    protected $keyType = string;

    //　自動インクリメントを無効
    public $incrementing = false;

    //　stamp_groupプロパティ
    protected $fillable = [
        'id', 'post_member_id', 'title', 'template', 'created_at'
    ];

    /*** modelの紐づけ ***/
    public function bulletinBoardComments()
    {
        return $this->hasMany('App\BulletinBoardComment');
    }

    public function bulletinBoardContents()
    {
        return $this->hasMany('App\BulletinBoardContent');
    }

    public function member()
    {
        return $this->belongsTo('App\Member');
    }
}

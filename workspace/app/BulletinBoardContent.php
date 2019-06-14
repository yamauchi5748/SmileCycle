<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BulletinBoardContent extends Model
{
    // テーブル名
    protected $table = 'bulletin_boards_contents';

    protected $primaryKey = ['bulletin_board_id', 'placement_id'];

    //　主キーのタイプを指定
    protected $keyType = string;

    //　自動インクリメントを無効
    public $incrementing = false;

    //　stamp_groupプロパティ
    protected $fillable = [
        'bulletin_board_id', 'placement_id', 'text', 'image_url', 'cotent_type'
    ];

    /*** modelの紐づけ ***/
    public function bulletinBoard()
    {
        return $this->belongsTo('App\BulletinBoard');
    }
}

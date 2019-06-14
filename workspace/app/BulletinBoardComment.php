<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BulletinBoardComment extends Model
{
    // テーブル名
    protected $table = 'bulletin_boards_comments';

    //　主キーのタイプを指定
    protected $keyType = string;

    //　自動インクリメントを無効
    public $incrementing = false;

    //　stamp_groupプロパティ
    protected $fillable = [
        'id', 'bulletin_board_id', 'member_id', 'text', 'stamp_id', 'comment_type', 'created_at'
    ];
}

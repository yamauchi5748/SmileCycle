<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberStamp extends Model
{
    // テーブル名
    protected $table = 'members_stamps';

    protected $primaryKey = ['stamp_group_id', 'member_id'];

    //　主キーのタイプを指定
    protected $keyType = string;

    //　自動インクリメントを無効
    public $incrementing = false;

    //　member_stampプロパティ
    protected $fillable = [
        'stamp_group_id', 'member_id'
    ];

    /*** modelの紐づけ ***/
    public function stampGroup()
    {
        return $this->belongsTo('App\stampGroup');
    }

    public function stamp()
    {
        return $this->belongsTo('App\Stamp');
    }
}

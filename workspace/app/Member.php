<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    // テーブル名
    protected $table = 'members';

    //　主キーのタイプを指定
    protected $keyType = string;

    //　自動インクリメントを無効
    public $incrementing = false;

    //　memberプロパティ
    protected $fillable = [
        'id', 'name', 'ruby', 'post', 'mail', 'api_token', 'password', 'profile_text', 'profile_image_url',
        'company_id', 'department_name', 'is_notification', 'notification_interval', 'is_admin'
    ];

    //　jsonなどに表示しないプロパティ
    protected $hidden = [
        'password'
    ];
}

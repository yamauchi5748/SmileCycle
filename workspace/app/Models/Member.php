<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    use Notifiable;

    // テーブル名
    protected $collection = 'members';

    // timestmapの自動付与を無効
    public $timestamps = false;

    //　memberプロパティ
    protected $fillable = [
        '_id', 'name', 'ruby', 'post', 'mail', 'api_token', 'password', 'telephone_number',
        'stamp_groups', 'department_name', 'is_notification', 'notification_interval', 'is_admin', 'invitations'
    ];

    //　jsonなどに表示しないプロパティ
    protected $hidden = [
        'password'
    ];
}

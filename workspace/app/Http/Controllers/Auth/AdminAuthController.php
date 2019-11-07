<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends AuthController
{
    /* 認証ユーザーを保持 */
    protected $author;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->author = Auth::guard('api')->user();
        // MiddlewareのAdminAuthority.phpを経由
        $this->middleware('admin_authority');
    }
}

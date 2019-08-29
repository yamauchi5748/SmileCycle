<?php

namespace App\Http\Controllers\Auth;

class AdminAuthController extends AuthController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // MiddlewareのAdminAuthority.phpを経由
        $this->middleware('admin_authority');
    }
}

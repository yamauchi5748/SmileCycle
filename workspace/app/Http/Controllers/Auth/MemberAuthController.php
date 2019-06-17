<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberAuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web,api');

        if($Auth::user()->is_admin)
        {
            return response()
            ->view('error', null, 401)
            ->header('Content-Type', "text/html");
        }
    }
}

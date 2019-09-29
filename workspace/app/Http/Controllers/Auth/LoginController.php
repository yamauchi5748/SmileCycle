<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * get Login View.
     *
     * @return view
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * 認証を処理する
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('name', 'password');

        // 継続的ログイン
        if (Auth::attempt($credentials, true)) {
            // 認証に成功した
            return redirect()->intended('/');
        }

        return redirect()->intended('/login');
    }
}

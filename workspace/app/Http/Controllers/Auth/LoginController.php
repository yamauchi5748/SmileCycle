<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
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
        $data = [
            'name' => $request->name,
            'password' => $request->password,
        ];

        $rules = [
            'name' => ['required', 'string', 'exists:members'],
            'password' => ['required', 'string', 'min:1', 'max:100'],
        ];

        $messages = [
            'name.required' => '会員名が入力されていません',
            'name.string' => '形式が間違っています',
            'name.exists' => '該当する会員が存在しません',
            'password.required' => 'パスワードが入力されていません',
            'password.string' => '形式が間違っています',
            'password.min' => 'パスワードが短すぎます',
            'password.min' => 'パスワードが長すぎます'
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return redirect('login')
                        ->withErrors($validator)
                        ->withInput();
        }

        $credentials = $request->only('name', 'password');

        // 継続的ログイン
        if (Auth::attempt($credentials, true)) {
            // 認証に成功した
            return redirect()->intended('/');
        }

        return redirect()->intended('/login');
    }

    /**
     * post Logout.
     *
     * @return string
     */
    public function logout()
    {
        $member = Auth::user();

        // api_tokenの更新
        $member->api_token = Str::random(60);
        $member->save();

        Auth::logout();
        return 'successed logout';
    }
}

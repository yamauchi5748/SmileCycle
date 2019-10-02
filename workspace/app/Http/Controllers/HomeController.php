<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Http\Controllers\Auth\AuthController;
use App\Mail\ContactMail;
use App\jobs\ProcessPodcast;

class HomeController extends AuthController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application home.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // 認証された会員を取得
        $member = Auth::user();

        // api_tokenの更新
        $member->api_token = Str::random(60);
        $member->save();

        return view('home', [ "member" => $member]);
    }
}

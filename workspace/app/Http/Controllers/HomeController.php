<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

        /* メール通知を飛ばす */
        $mail = [
            'from'    => env('MAIL_FROM_ADDRESS', ''),
            'f_name'  => env('MAIL_FROM_NAME', ''),
            'to'      => env('MAIL_TO_NAME', ''),
            'to_name' => env('MAIL_TO_NAME', ''),
            'subject' => 'テストメールです'
        ];

        $job = (new ProcessPodcast('contact.mail', ['count' => 10], $mail))->delay(10);
        // jobs テーブルに登録
        dispatch($job);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $member = Auth::user();
        return view('home', [ "member" => $member]);
    }
}

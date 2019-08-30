<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /* 認証ユーザーを保持 */
    protected $auther;

    /* レスポンスの枠組み変数 */
    protected $response = [
        "auth" => true,
        "result" => true
    ];
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->auther= Auth::guard('api')->user();
        $this->middleware('auth:api');
    }
}

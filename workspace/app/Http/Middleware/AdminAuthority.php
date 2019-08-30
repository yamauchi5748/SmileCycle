<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuthority
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /* 認証された会員を取得 */
        $auther =  Auth::guard('api')->user();


        /* 認証された会員が管理者かチェック */
        if(!$auther['is_admin'])
        {
            abort(403);
        }

        return $next($request);
    }
}

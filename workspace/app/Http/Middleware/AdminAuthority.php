<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;

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
        $author =  Auth::guard('api')->user();

        /* 認証された会員が管理者かチェック */
        if (!$author['is_admin']) {
            
            throw new AuthenticationException('管理者認証エラー');
        }

        return $next($request);
    }
}

<?php

namespace Modules\Homedy\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class Auth
{

    public function handle($request, Closure $next)
    {
        if ($request->hasHeader('Authorization')) {
            $token = trim($request->header('Authorization'));
            $token = str_replace('Bearer ', '', $token);
            if ($token == config('homedy.secret_key')) {
                return $next($request);
            }
        }
        return response()->json([
            'status' => Response::HTTP_UNAUTHORIZED,
            'error' => 'Bạn phải đăng nhập để vào truy cập'
        ]);
    }
}

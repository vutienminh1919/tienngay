<?php


namespace Modules\AssetTienNgay\Http\Middleware;

use Closure;

class CheckDoc
{
    public function handle($request, Closure $next)
    {
        if (env('APP_ENV') !== 'product') {
            return $next($request);
        } else {
            abort(403,'Không có quyền truy cập');
        }
    }
}

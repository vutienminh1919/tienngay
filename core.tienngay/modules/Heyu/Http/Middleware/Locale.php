<?php

namespace Modules\Heyu\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Lang;

class Locale extends Middleware
{
    public function handle($request, Closure $next)
    {
        $lang = !empty($request->lang) ? $request->lang : 'vi';
        Lang::setLocale($lang);
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;

class Authenticate
{

    public function handle($request, Closure $next)
    {
        $user = $request->session()->get('user');
        if ($user) {
            return $next($request);
        }
        return redirect()->route('auth_login');
    }

}

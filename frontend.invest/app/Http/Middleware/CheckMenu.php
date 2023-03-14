<?php


namespace App\Http\Middleware;

use App\Service\Api;
use Closure;
use Illuminate\Support\Facades\Session;

class CheckMenu
{
    public function handle($request, Closure $next)
    {
        if (Session::has('user')) {
            $response = Api::post('menu/sidebar');
            $data_uri_user = [];
            foreach ($response['data'] as $datum) {
                if ($datum['url']) {
                    $data_uri_user[] = $datum['url'];
                }
            }
            $uri_current = $request->path();
            if (Session::get('user')['is_admin'] == 1) {
                return $next($request);
            } else {
                if (in_array($uri_current, $data_uri_user)) {
                    return $next($request);
                } else {
                    return abort(403, 'Bạn không có quyền này');
                }
            }
        } else {
            return redirect()->route('auth_login');
        }
    }
}

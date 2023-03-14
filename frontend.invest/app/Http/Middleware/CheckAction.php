<?php


namespace App\Http\Middleware;

use App\Service\Api;
use Closure;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class CheckAction
{
    public function handle($request, Closure $next)
    {
        $uri = $request->path();
        $response = Api::post('user/get_action_user', ['id' => Session::get('user')['id'], 'uri' => $uri]);
        if ($response['is_admin'] == 1) {
            $check = true;
        }else{
            $check = isset($response['check']) ? $response['check'] : false;
        }
        $result = Gate::forUser($check)->allows('checkAction');
        if ($result !== true) {
            return abort(403, 'Bạn không có quyền này');
        } else {
            return $next($request);
        }
    }
}

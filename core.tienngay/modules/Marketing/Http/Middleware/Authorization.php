<?php

namespace Modules\Marketing\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;

class Authorization
{

    public function __construct() {
        //
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $auth = $request->header('Authorization');
        Log::channel('marketing')->info('Auth: ' . $auth);
        $authDecode = base64_decode(substr($auth,6));
        Log::channel('marketing')->info('AuthDecode: ' . $authDecode);
        $explode = explode(":",$authDecode);
        $userName = isset($explode[0]) ? $explode[0] : "";
        $password = isset($explode[1]) ? $explode[1] : "";
        $targetCompare = $userName . ':' . env(strtoupper('PARTNER_'.$userName));
        Log::channel('marketing')->info('$argetCompare: ' . $targetCompare);
        if ($authDecode !== $targetCompare) {
            $response = [
                'status' => Response::HTTP_UNAUTHORIZED,
                'data' => [],
                'message' => __('Marketing::messages.auth_failed')
            ];
            Log::channel('marketing')->info('Auth failed response: ' . print_r($response, true));
            return response()->json($response);
        }
        Log::channel('marketing')->info('Auth success');
        return $next($request);
    }



}

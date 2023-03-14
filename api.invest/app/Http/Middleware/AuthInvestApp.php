<?php


namespace App\Http\Middleware;


use App\Http\Controllers\Controller;
use App\Repository\UserRepositoryInterface;
use App\Service\Auth\Authorization;
use Closure;

class AuthInvestApp
{
    public function __construct(
        UserRepositoryInterface $user
    )
    {
        $this->user_model = $user;
    }

    public function handle($request, Closure $next)
    {
        if ($request->hasHeader('Authority')) {
            $string = $request->header('Authority');
            $key = env('SECRET_KEY_INTERNAL');
            $token = openssl_decrypt($string, "AES-256-ECB", $key);
            $arr = explode('+', $token);
            if ($arr[0] == env('STRING_INTERNAL')) {
                return $next($request);
            }
        }
        return response()->json([
            'status' => Controller::HTTP_UNAUTHORIZED,
            'message' => 'Xác thực không hợp lệ'
        ]);
    }
}

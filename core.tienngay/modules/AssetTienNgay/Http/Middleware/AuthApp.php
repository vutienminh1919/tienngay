<?php


namespace Modules\AssetTienNgay\Http\Middleware;


use Modules\AssetTienNgay\Http\Controllers\BaseController;
use Modules\AssetTienNgay\Http\Repository\UserRepository;
use Modules\AssetTienNgay\Http\Service\Authorization;
use Closure;
use Modules\AssetTienNgay\Model\User;

class AuthApp
{
    public function __construct(
        UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    public function handle($request, Closure $next)
    {
        if ($request->hasHeader('Authorization')) {
            $token = Authorization::validateToken($request->header('Authorization'));
            if (!empty($token)) {
                $user = $this->userRepository->findOne([
                    User::EMAIL => $token->email,
                    User::TOKEN_APP => $request->header('Authorization'),
                    User::STATUS => User::ACTIVE
                ]);
                if ($user) {
                    $request->user_info = $user;
                    return $next($request);
                } else {
                    return response()->json([
                        BaseController::STATUS => BaseController::HTTP_FORBIDDEN,
                        BaseController::MESSAGE => 'Xác thực không hợp lệ'
                    ]);
                }
            } else {
                return response()->json([
                    BaseController::STATUS => BaseController::HTTP_FORBIDDEN,
                    BaseController::MESSAGE => 'Xác thực không hợp lệ'
                ]);
            }
        } else {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_FORBIDDEN,
                BaseController::MESSAGE => 'Xác thực không hợp lệ'
            ]);
        }

    }
}

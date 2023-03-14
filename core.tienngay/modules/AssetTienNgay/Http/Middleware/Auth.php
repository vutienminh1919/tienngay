<?php


namespace Modules\AssetTienNgay\Http\Middleware;


use Closure;
use Modules\AssetTienNgay\Http\Controllers\BaseController;
use Modules\AssetTienNgay\Http\Repository\UserRepository;
use Modules\AssetTienNgay\Http\Service\Authorization;
use Modules\AssetTienNgay\Model\User;

class Auth
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
            if ($token) {
                $data = [
                    User::EMAIL => $token->email,
                    User::TOKEN_WEB => $request->header('Authorization'),
                    User::STATUS => User::ACTIVE
                ];
                $user = $this->userRepository->findOne($data);
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

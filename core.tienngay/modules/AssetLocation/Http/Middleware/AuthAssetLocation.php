<?php


namespace Modules\AssetLocation\Http\Middleware;


use Closure;
use Modules\AssetLocation\Http\Controllers\BaseController;
use Modules\AssetLocation\Http\Repository\UserRepository;
use Modules\AssetLocation\Http\Service\Authorization;
use Modules\AssetLocation\Model\User;

class AuthAssetLocation
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
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
                    User::STATUS => User::STATUS_ACTIVE
                ];
                $user = $this->userRepository->findOne($data);
                if ($user) {
                    $request->user = $user;
                    return $next($request);
                } else {
                    return BaseController::send_response(BaseController::HTTP_FORBIDDEN, BaseController::FORBIDDEN);
                }
            } else {
                return BaseController::send_response(BaseController::HTTP_FORBIDDEN, BaseController::FORBIDDEN);
            }
        } else {
            return BaseController::send_response(BaseController::HTTP_FORBIDDEN, BaseController::FORBIDDEN);
        }
    }
}

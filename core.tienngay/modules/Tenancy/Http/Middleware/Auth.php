<?php


namespace Modules\Tenancy\Http\Middleware;


use Closure;
use Modules\MongodbCore\Repositories\UserCpanelRepository;
use Modules\Tenancy\Http\Controllers\BaseController;
use Modules\Tenancy\Service\Authorization;


class Auth
{
    public function __construct(
        UserCpanelRepository $userCpanelRepository
    )
    {
        $this->userCpanelRepository = $userCpanelRepository;
    }

    public function handle($request, Closure $next)
    {
        if ($request->hasHeader('Authorization')) {
            $token = Authorization::validateToken($request->header('Authorization'));
            if ($token) {
                $data = [
                    'email' => $token->email,
                    'token_web' => $request->header('Authorization'),
                    'status' => 'active'
                ];
                $user = $this->userCpanelRepository->find_user_active($data);
                if ($user) {
                    $request->user = $user;
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

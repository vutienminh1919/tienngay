<?php


namespace Modules\CtvTienNgay\Http\Middleware;


use Closure;
use Modules\CtvTienNgay\Http\Controllers\BaseController;
use Modules\CtvTienNgay\Service\Authorization;
use Modules\MongodbCore\Entities\Collaborator;

class AuthCtv
{
    public function handle($request, Closure $next)
    {
        if ($request->hasHeader('Authorization')) {
            $token = Authorization::validateToken($request->header('Authorization'));
            if ($token) {
                $user = Collaborator::where(Collaborator::COLUMN_ID, $token->id)
                    ->where(Collaborator::COLUMN_TOKEN_APP, $request->header('Authorization'))
                    ->where(Collaborator::COLUMN_STATUS, Collaborator::STATUS_ACTIVE)
                    ->first();
                if ($user) {
                    $request->user_info = $user;
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

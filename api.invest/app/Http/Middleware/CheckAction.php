<?php


namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use App\Repository\ActionRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Service\Auth\Authorization;
use Closure;

class CheckAction
{
    public function __construct(
        UserRepositoryInterface $user,
        ActionRepositoryInterface $action
    )
    {
        $this->user_model = $user;
        $this->action_model = $action;
    }

    public function handle($request, Closure $next)
    {
        if ($request->hasHeader('Authorization')) {
            $token = Authorization::validateToken($request->header('Authorization'));
            if ($token) {
                $user = $this->user_model->checkLoginUser($token->email, $token->phone, $request->header('Authorization'));
                $action = [];
                foreach ($user->menu as $key => $menu) {
                    $arr = explode(',', $menu->pivot->action);
                    foreach ($arr as $value) {
                        if ($value != 0) {
                            $url_action = $this->action_model->find($value);
                            array_push($action, $url_action->url);
                        }
                    }
                }
                $uri = $request->path();
                if (in_array($uri, $action)) {
                    return $next($request);
                } else {
                    return response()->json([
                        'status' => Controller::HTTP_FORBIDDEN,
                        'message' => 'Bạn không có quyền này'
                    ]);
                }
            }
        }
    }
}

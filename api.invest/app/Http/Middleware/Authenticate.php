<?php

namespace App\Http\Middleware;

use Closure;
use App\Repository\UserRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Service\Auth\Authorization;

class Authenticate
{

	public function __construct(
		UserRepositoryInterface $user
	) {
		$this->user_model = $user;
	}

	public function handle($request, Closure $next)
	{
		if ($request->hasHeader('Authorization')) {
			$token = Authorization::validateToken($request->header('Authorization'));
			if ($token) {
				$user = $this->user_model->checkLoginUser($token->email, $token->phone, $request->header('Authorization'));
				if ($user) {
					return $next($request);
				}
			}
		}
		return response()->json([
			'status' => Controller::HTTP_UNAUTHORIZED,
			'message' => 'Bạn phải đăng nhập để vào truy cập'
		]);
	}

}

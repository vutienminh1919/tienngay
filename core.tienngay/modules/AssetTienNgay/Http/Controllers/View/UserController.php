<?php


namespace Modules\AssetTienNgay\Http\Controllers\View;


use Illuminate\Http\Request;
use Modules\AssetTienNgay\Http\Controllers\BaseController;
use Modules\AssetTienNgay\Http\Service\RoleService;
use Modules\AssetTienNgay\Http\Service\UserService;

class UserController extends BaseController
{
    protected $userService;
    protected $roleService;

    public function __construct(UserService $userService,
                                RoleService $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    public function login(Request $request)
    {
        $validate = $this->userService->validate_login($request);
        if ($validate->fails()) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $validate->errors()->first()
            ]);
        }

        $data = $this->userService->check_login($request);
        if (isset($data['message'])) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $data['message']
            ]);
        } else {
            $token = $this->userService->login($data['user'], $request);
            $data['user']['token'] = $token;
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
                BaseController::DATA => $data['user'],
            ]);
        }
    }

    public function get_user(Request $request)
    {
        $data = $this->userService->get_user($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data,
        ]);
    }

    public function get_user_add_role(Request $request)
    {
        $data = $this->userService->get_user_add_role($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data,
        ]);
    }
}

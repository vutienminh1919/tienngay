<?php


namespace Modules\AssetTienNgay\Http\Controllers\View;


use Illuminate\Http\Request;
use Modules\AssetTienNgay\Http\Controllers\BaseController;
use Modules\AssetTienNgay\Http\Service\ActionUserService;
use Modules\AssetTienNgay\Http\Service\RoleService;

class ActionUserController extends BaseController
{
    protected $actionUserService;
    protected $roleService;

    public function __construct(ActionUserService $actionUserService,
                                RoleService $roleService)
    {
        $this->actionUserService = $actionUserService;
        $this->roleService = $roleService;
    }

    public function create(Request $request)
    {
        $this->actionUserService->create($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
        ]);
    }

    public function show_action_user(Request $request)
    {
        $data = $this->actionUserService->show($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data,
        ]);
    }

    public function get_slug_action_user(Request $request)
    {
        $data = $this->actionUserService->get_slug_action_user($request);
        $check_van_hanh = $this->roleService->check_van_hanh($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data,
            'van_hanh' => $check_van_hanh,
        ]);
    }
}

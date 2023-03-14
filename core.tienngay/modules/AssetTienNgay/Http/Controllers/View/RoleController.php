<?php


namespace Modules\AssetTienNgay\Http\Controllers\View;


use Illuminate\Http\Request;
use Modules\AssetTienNgay\Http\Controllers\BaseController;
use Modules\AssetTienNgay\Http\Service\RoleService;

class RoleController extends BaseController
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function create(Request $request)
    {
        $message = $this->roleService->validate_create($request);
        if (count($message) > 0) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $message[0],
            ]);
        }

        $this->roleService->create($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
        ]);
    }

    public function update(Request $request)
    {
        $this->roleService->update($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
        ]);
    }

    public function get_menu_user(Request $request)
    {
        $data = $this->roleService->get_menu_user($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data,
        ]);
    }

    public function get_all(Request $request)
    {
        $data = $this->roleService->get_all($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data,
        ]);
    }

    public function show(Request $request)
    {
        $data = $this->roleService->show($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data,
        ]);
    }

    public function view_dashboard(Request $request)
    {
        $data = $this->roleService->view_dashboard($request->user_info->_id);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data,
        ]);
    }

    public function get_all_user_role()
    {
        $data = $this->roleService->get_all_user_role();
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    public function test()
    {
        $data = $this->roleService->get_user_manager_supplies('619f5a5f393300009a00730a');
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
}

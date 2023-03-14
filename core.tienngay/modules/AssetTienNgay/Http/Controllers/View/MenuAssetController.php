<?php


namespace Modules\AssetTienNgay\Http\Controllers\View;


use Modules\AssetTienNgay\Http\Controllers\BaseController;
use Modules\AssetTienNgay\Http\Service\MenuAssetService;
use Illuminate\Http\Request;

class MenuAssetController extends BaseController
{
    protected $menuAssetService;

    public function __construct(MenuAssetService $menuAssetService)
    {
        $this->menuAssetService = $menuAssetService;
    }

    public function create(Request $request)
    {
        $message = $this->menuAssetService->validate_create($request);
        if (count($message) > 0) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $message[0],
            ]);
        }

        $result = $this->menuAssetService->create($request);
        if ($result == false) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => "Tạo menu không hợp lệ",
            ]);
        } else {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
            ]);
        }
    }

    public function get_list_ware_house()
    {
        $data = $this->menuAssetService->get_list_ware_house();
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    public function get_list_equipment()
    {
        $data = $this->menuAssetService->get_list_equipment();
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    public function show(Request $request)
    {
        $data = $this->menuAssetService->show($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    public function get_child(Request $request)
    {
        $data = $this->menuAssetService->get_child($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    public function get_menu(Request $request)
    {
        $data = $this->menuAssetService->get_menu($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    public function get_menu_parent(Request $request)
    {
        $data = $this->menuAssetService->get_menu_parent($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    public function get_menu_add_role(Request $request)
    {
        $data = $this->menuAssetService->get_menu_add_role($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data,
        ]);
    }

    public function get_list_department()
    {
        $data = $this->menuAssetService->get_list_department();
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    public function toggle_status(Request $request)
    {
        $message = $this->menuAssetService->toggle_status($request);
        if (count($message) > 0) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $message[0],
            ]);
        } else {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
            ]);
        }
    }

    public function transfer_user(Request $request)
    {
        $message = $this->menuAssetService->transfer_user($request);
        if (count($message) > 0) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $message[0],
            ]);
        } else {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
            ]);
        }
    }

    public function detail(Request $request)
    {
        $data = $this->menuAssetService->detail($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    public function transfer_menu(Request $request)
    {
        $message = $this->menuAssetService->transfer_menu($request);
        if (count($message) > 0) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $message[0],
            ]);
        } else {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_OK,
                BaseController::MESSAGE => BaseController::SUCCESS,
            ]);
        }
    }

    public function show_by_user(Request $request)
    {
        $data = $this->menuAssetService->show_by_user($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    public function rename(Request $request)
    {
        $this->menuAssetService->rename($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
        ]);
    }

    public function sw_user_depart(Request $request)
    {
        $this->menuAssetService->sw_user_depart($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
        ]);
    }

    public function update_sign(Request $request)
    {
        $this->menuAssetService->update_sign($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
        ]);
    }
}

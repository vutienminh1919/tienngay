<?php


namespace Modules\AssetTienNgay\Http\Controllers\View;


use Modules\AssetTienNgay\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Modules\AssetTienNgay\Http\Service\EquipmentService;

class EquipmentController extends BaseController
{
    protected $equipmentService;

    public function __construct(EquipmentService $equipmentService)
    {
        $this->equipmentService = $equipmentService;
    }

    public function create(Request $request)
    {
        $this->equipmentService->create($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS
        ]);
    }

    public function add_equip(Request $request)
    {
        $this->equipmentService->add_equip($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS
        ]);
    }

    public function get_parent()
    {
        $data = $this->equipmentService->get_parent();
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    public function get_child(Request $request)
    {
        $data = $this->equipmentService->get_child($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }
}

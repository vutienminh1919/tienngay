<?php


namespace Modules\AssetTienNgay\Http\Controllers\View;


use Modules\AssetTienNgay\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Modules\AssetTienNgay\Http\Service\WarehouseService;

class WarehouseController extends BaseController
{
    protected $warehouseService;

    public function __construct(WarehouseService $warehouseService)
    {
        $this->warehouseService = $warehouseService;
    }

    public function create(Request $request)
    {
        $this->warehouseService->create($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS
        ]);
    }

    public function list()
    {
        $data = $this->warehouseService->getAll();
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }
}

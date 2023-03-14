<?php


namespace Modules\AssetLocation\Http\Controllers;


use Illuminate\Http\Request;
use Modules\AssetLocation\Http\Service\ReportService;
use Modules\AssetLocation\Http\Service\WarehouseService;

class WarehouseController extends BaseController
{
    protected $warehouseService;
    protected $reportService;

    public function __construct(WarehouseService $warehouseService,
                                ReportService $reportService)
    {
        $this->warehouseService = $warehouseService;
        $this->reportService = $reportService;
    }

    public function create_warehouse_pgd(Request $request)
    {
        $validate = $this->warehouseService->validate_create($request);
        if (count($validate) > 0) {
            return BaseController::send_response(self::HTTP_BAD_REQUEST, $validate[0]);
        }

        $this->warehouseService->create_warehouse_pgd($request);
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS);
    }

    public function create_warehouse_general(Request $request)
    {
        $validate = $this->warehouseService->validate_create_general($request);
        if (count($validate) > 0) {
            return BaseController::send_response(self::HTTP_BAD_REQUEST, $validate[0]);
        }

        $warehouse = $this->warehouseService->create_warehouse_general($request);
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $warehouse);
    }

    public function list(Request $request)
    {
        $data = $this->warehouseService->list();
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    public function report_warehouse(Request $request)
    {
        $data = $this->warehouseService->report_warehouse();
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    public function report_all(Request $request)
    {
        $data = $this->reportService->report_all($request);
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    public function report_partial(Request $request)
    {
        $data = $this->reportService->report_partial($request);
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    public function contract_disbursement(Request $request)
    {
        $data = $this->warehouseService->contract_disbursement($request);
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    public function warehouse_local(Request $request)
    {
        $data = $this->warehouseService->warehouse_local($request);
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    public function detail(Request $request)
    {
        $data = $this->warehouseService->detail($request);
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    public function history(Request $request)
    {
        $data = $this->warehouseService->history($request);
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    public function backup(Request $request)
    {
        $data = $this->warehouseService->backup($request);
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }

    public function view_all(Request $request)
    {
        $data = $this->warehouseService->view_all($request);
        return BaseController::send_response(self::HTTP_OK, self::SUCCESS, $data);
    }
}

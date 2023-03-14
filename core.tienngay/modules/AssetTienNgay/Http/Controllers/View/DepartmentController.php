<?php


namespace Modules\AssetTienNgay\Http\Controllers\View;


use Modules\AssetTienNgay\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Modules\AssetTienNgay\Http\Service\DepartmentService;

class DepartmentController extends BaseController
{
    protected $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function create(Request $request)
    {
        $message = $this->departmentService->check_unique($request);
        if (count($message) > 0) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $message[0]
            ]);
        }
        $this->departmentService->create($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS
        ]);
    }

    public function add_user(Request $request)
    {
        $this->departmentService->add_user($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS
        ]);
    }

    public function get_depart()
    {
        $data = $this->departmentService->get_depart();
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    public function get_user_depart(Request $request)
    {
        $data = $this->departmentService->get_user_depart($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    public function show(Request $request)
    {
        $data = $this->departmentService->show($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }
}

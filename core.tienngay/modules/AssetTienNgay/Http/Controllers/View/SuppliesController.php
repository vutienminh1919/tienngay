<?php


namespace Modules\AssetTienNgay\Http\Controllers\View;


use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Modules\AssetTienNgay\Http\Controllers\BaseController;
use Modules\AssetTienNgay\Http\Service\SuppliesService;
use Illuminate\Http\Request;

class SuppliesController extends BaseController
{
    protected $suppliesService;

    public function __construct(SuppliesService $suppliesService)
    {
        $this->suppliesService = $suppliesService;
    }

    public function create(Request $request)
    {
        $validate = $this->suppliesService->validate_create($request);
        if ($validate->fails()) {
            return response()->json([
                BaseController::STATUS => Response::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $validate->errors()->first()
            ]);
        }
        $this->suppliesService->create($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS
        ]);
    }

    public function get_all_paginate(Request $request)
    {
        $data = $this->suppliesService->get_all_paginate($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    public function get_count_all(Request $request)
    {
        $data = $this->suppliesService->get_count_all($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    public function show(Request $request)
    {
        $data = $this->suppliesService->show($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    public function get_all(Request $request)
    {
        $data = $this->suppliesService->get_all($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    public function assign_user(Request $request)
    {
        $validate = $this->suppliesService->validate_assign_user($request);
        if ($validate->fails()) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $validate->errors()->first()
            ]);
        }
        $this->suppliesService->assign_user($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
        ]);
    }

    public function change_user(Request $request)
    {
        $validate = $this->suppliesService->validate_change_user($request);
        if ($validate->fails()) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $validate->errors()->first()
            ]);
        }
        $this->suppliesService->change_user($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
        ]);
    }

    public function storage(Request $request)
    {
        $validate = $this->suppliesService->validate_storage($request);
        if ($validate->fails()) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $validate->errors()->first()
            ]);
        }
        $this->suppliesService->storage($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
        ]);
    }

    public function broken(Request $request)
    {
        $validate = $this->suppliesService->validate_broken($request);
        if ($validate->fails()) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $validate->errors()->first()
            ]);
        }
        $this->suppliesService->broken($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
        ]);
    }

    public function accept(Request $request)
    {
        $this->suppliesService->accept($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
        ]);
    }

    public function update_info(Request $request)
    {
        $validate = $this->suppliesService->validate_update_info($request);
        if ($validate->fails()) {
            return response()->json([
                BaseController::STATUS => Response::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $validate->errors()->first()
            ]);
        }
        $this->suppliesService->update_info($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS
        ]);
    }

    public function verified(Request $request)
    {
        $validate = $this->suppliesService->validate_verified($request);
        if ($validate->fails()) {
            return response()->json([
                BaseController::STATUS => Response::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $validate->errors()->first()
            ]);
        }
        $this->suppliesService->verified($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS
        ]);
    }

    public function update_image(Request $request)
    {
        $validate = $this->suppliesService->validate_update_image($request);
        if ($validate->fails()) {
            return response()->json([
                BaseController::STATUS => Response::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $validate->errors()->first()
            ]);
        }
        $this->suppliesService->update_image($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS
        ]);
    }

    public function import_use(Request $request)
    {
        $validate = $this->suppliesService->validate_import_use($request);
        if ($validate->fails()) {
            return response()->json([
                BaseController::STATUS => Response::HTTP_OK,
                BaseController::MESSAGE => $validate->errors()->first(),
                BaseController::DATA => $request->key
            ]);
        }
        $message = $this->suppliesService->import_use($request);
        if (count($message) > 0) {
            return response()->json([
                BaseController::STATUS => Response::HTTP_OK,
                BaseController::MESSAGE => $message[0],
                BaseController::DATA => $request->key
            ]);
        }
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS
        ]);
    }

    public function import_save(Request $request)
    {
        $validate = $this->suppliesService->validate_import_save($request);
        if ($validate->fails()) {
            return response()->json([
                BaseController::STATUS => Response::HTTP_OK,
                BaseController::MESSAGE => $validate->errors()->first(),
                BaseController::DATA => $request->key
            ]);
        }
        $message = $this->suppliesService->import_save($request);
        if (count($message) > 0) {
            return response()->json([
                BaseController::STATUS => Response::HTTP_OK,
                BaseController::MESSAGE => $message[0],
                BaseController::DATA => $request->key
            ]);
        }
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS
        ]);
    }

    public function import_fail(Request $request)
    {
        $validate = $this->suppliesService->validate_import_fail($request);
        if ($validate->fails()) {
            return response()->json([
                BaseController::STATUS => Response::HTTP_OK,
                BaseController::MESSAGE => $validate->errors()->first(),
                BaseController::DATA => $request->key
            ]);
        }
        $message = $this->suppliesService->import_fail($request);
        if (count($message) > 0) {
            return response()->json([
                BaseController::STATUS => Response::HTTP_OK,
                BaseController::MESSAGE => $message[0],
                BaseController::DATA => $request->key
            ]);
        }
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS
        ]);
    }

    public function get_all_paginate_dashboard(Request $request)
    {
        $data = $this->suppliesService->get_all_paginate_dashboard($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    public function get_all_dashboard(Request $request)
    {
        $data = $this->suppliesService->get_all_dashboard($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    public function get_count_all_dashboard(Request $request)
    {
        $data = $this->suppliesService->get_count_all_dashboard($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    public function update_info_general(Request $request)
    {
        $validate = $this->suppliesService->validate_update_info_general($request);
        if ($validate->fails()) {
            return response()->json([
                BaseController::STATUS => Response::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $validate->errors()->first()
            ]);
        }
        $this->suppliesService->update_info_general($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS
        ]);
    }

    public function clear_supplies(Request $request)
    {
        $this->suppliesService->clear_supplies($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS
        ]);
    }

    public function assign_many(Request $request)
    {
        $validate = $this->suppliesService->validate_assign_many($request);
        if ($validate->fails()) {
            return response()->json([
                BaseController::STATUS => Response::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $validate->errors()->first()
            ]);
        }
        $this->suppliesService->assign_many($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS
        ]);
    }

    public function office_confirm(Request $request)
    {
        if (empty($request->supplies_id)) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => 'Không tìm thấy thiết bị'
            ]);
        }
        $this->suppliesService->office_confirm($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS
        ]);
    }

    public function update_status_supplies(Request $request)
    {
        if (empty($request->supplies_id)) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => 'Không tìm thấy thiết bị'
            ]);
        }
        $this->suppliesService->update_status_supplies($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS
        ]);
    }

    public function report(Request $request)
    {
        $message = $this->suppliesService->validate_report($request);
        if (count($message) > 0) {
            return response()->json([
                BaseController::STATUS => Response::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $message[0]
            ]);
        }
        $data = $this->suppliesService->report($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    public function transfer_department(Request $request)
    {
        $this->suppliesService->transfer_department($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
        ]);
    }

    public function get_warehouse_paginate(Request $request)
    {
        $data = $this->suppliesService->get_warehouse_paginate($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    public function get_count_warehouse(Request $request)
    {
        $data = $this->suppliesService->get_count_warehouse($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    public function general_code()
    {
        $this->suppliesService->general_code();
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS
        ]);
    }

    public function get_all_data(Request $request)
    {
        $data = $this->suppliesService->get_all_data($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    public function recall_many(Request $request)
    {
        $validate = $this->suppliesService->validate_recall_many($request);
        if ($validate->fails()) {
            return response()->json([
                BaseController::STATUS => Response::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $validate->errors()->first()
            ]);
        }
        $this->suppliesService->recall_many($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS
        ]);
    }

    public function verify_many(Request $request)
    {
        $validate = $this->suppliesService->validate_verify_many($request);
        if ($validate->fails()) {
            return response()->json([
                BaseController::STATUS => Response::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $validate->errors()->first()
            ]);
        }
        $this->suppliesService->verify_many($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS
        ]);
    }

}

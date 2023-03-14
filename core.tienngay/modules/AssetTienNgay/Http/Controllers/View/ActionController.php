<?php


namespace Modules\AssetTienNgay\Http\Controllers\View;


use Illuminate\Http\Request;
use Modules\AssetTienNgay\Http\Controllers\BaseController;
use Modules\AssetTienNgay\Http\Service\ActionService;

class ActionController extends BaseController
{
    protected $actionService;

    public function __construct(ActionService $actionService)
    {
        $this->actionService = $actionService;
    }

    public function create(Request $request)
    {
        $message = $this->actionService->validate_create($request);
        if (count($message) > 0) {
            return response()->json([
                BaseController::STATUS => BaseController::HTTP_BAD_REQUEST,
                BaseController::MESSAGE => $message[0],
            ]);
        }

        $this->actionService->create($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
        ]);
    }

    public function list(Request $request)
    {
        $data = $this->actionService->list($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data,
        ]);
    }

    public function get_action_add_user(Request $request)
    {
        $data = $this->actionService->get_action_add_user($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data,
        ]);
    }
}

<?php


namespace Modules\AssetTienNgay\Http\Controllers\View;


use Illuminate\Http\Request;
use Modules\AssetTienNgay\Http\Controllers\BaseController;
use Modules\AssetTienNgay\Http\Service\NotificationService;

class NotificationController extends BaseController
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function badge(Request $request)
    {
        $data = $this->notificationService->badge($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    public function notification_web(Request $request)
    {
        $data = $this->notificationService->notification_web($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }

    public function read_notification(Request $request)
    {
        $this->notificationService->read_notification($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
        ]);
    }

    public function notification_limit(Request $request)
    {
        $data = $this->notificationService->notification_limit($request);
        return response()->json([
            BaseController::STATUS => BaseController::HTTP_OK,
            BaseController::MESSAGE => BaseController::SUCCESS,
            BaseController::DATA => $data
        ]);
    }
}

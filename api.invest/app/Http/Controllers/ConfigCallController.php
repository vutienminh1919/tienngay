<?php

namespace App\Http\Controllers;

use App\Repository\ConfigCallRepositoryInterface;
use App\Service\ConfigCallService;
use Illuminate\Http\Request;

class ConfigCallController extends Controller
{
    protected $configCallService;

    public function __construct(ConfigCallService $configCallService)
    {
        $this->configCallService = $configCallService;
    }

    public function config_call(Request $request)
    {
        $validate = $this->configCallService->validate_config_call($request);
        if ($validate->fails()) {
            return response()->json([
                'status' => Controller::HTTP_BAD_REQUEST,
                'message' => $validate->errors()->first()
            ]);
        }
        $this->configCallService->config_call($request);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'message' => "Cập nhật thành công"
        ]);
    }

}

<?php

namespace App\Http\Controllers;

use App\Service\ToolService;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    protected $toolService;

    public function __construct(ToolService $toolService)
    {
        $this->toolService = $toolService;
    }

    public function tool_calculator_interest(Request $request)
    {
        $data = $this->toolService->tool_calculator_interest($request);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'data' => $data,
            'message' => 'success',
        ]);
    }

    public function tool_calculator_commission(Request $request)
    {
        $data = $this->toolService->tool_calculator_commission($request);
        return response()->json([
            'status' => Controller::HTTP_OK,
            'data' => $data,
            'message' => 'success',
        ]);
    }
}

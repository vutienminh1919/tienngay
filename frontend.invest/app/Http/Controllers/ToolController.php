<?php

namespace App\Http\Controllers;

use App\Service\Api;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function tool_calculator_interest(Request $request)
    {
        $data = [
            'number_day_loan' => $request->number_day_loan,
            'amount_money' => trim(str_replace(array(',', '.',), '', $request->amount_money)),
            'type_interest' => $request->type_interest,
            'created_at' => $request->created_at,
        ];
        $response = Api::post('tool/tool_calculator_interest', $data);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => 'Thành công',
                'data' => $response['data']
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => isset($response['status']) ? $response['status'] : 'Thất bại'
            ]);
        }
    }

    public function index()
    {
        return view('tool.tool_calculator_interest');
    }

    public function index_commission()
    {
        return view('tool.tool_calculator_commission');
    }

    public function tool_calculator_commission(Request $request)
    {
        $data = [
            'period' => $request->number_day_loan,
            'amount' => trim(str_replace(array(',', '.',), '', $request->amount_money)),
            'start_date' => $request->created_at,
        ];

        if (trim(str_replace(array(',', '.',), '', $request->amount_money)) > 300000000) {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => "Số tiền tối đa 300,000,000"
            ]);
        }
        $response = Api::post('tool/tool_calculator_commission', $data);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => 'Thành công',
                'data' => $response['data']
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => isset($response['status']) ? $response['status'] : 'Thất bại'
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Service\Api;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    const DU_NO_GIAM_DAN = '1';
    const LAI_HANG_THANG_GOC_CUOI_KY = '2';

    //type
    const HOP_DONG_DA_GN = 1;
    const HOP_DONG_GOI_VON = 2;

    const STATUS_ACTIVE = 'active';
    const STATUS_BLOCK = 'block';

    public function index(Request $request)
    {
        $page = $request->get('page') ? $request->get('page') : 1;
        $response = Api::post('investment/get_investment?page=' . $page);
        $data = [];
        $paginate = null;
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $res_data = $response['data'];
            $data = isset($res_data['data']) ? collect($res_data['data']) : [];
            $paginate = page_render($data, $res_data['per_page'] ?? 15, $res_data['total'] ?? 0)->appends($request->query());
        }
        return view('investment.list', compact('data', 'paginate'));
    }

    public function create(Request $request)
    {
        $data = [
            'amount_money' => trim(str_replace(array(',', '.',), '', $request->amount_money)),
            'type_interest' => $request->type_interest,
            'month' => $request->month,
            'quantity' => $request->quantity,
        ];
        $response = Api::post('investment/create', $data);
        if (isset($response['status']) && $response['status'] == 200) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => 'Thêm mới thành công'
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => !empty($response['message']) ? $response['message'] : 'Thêm mới không thành công'
            ]);
        }
    }
}

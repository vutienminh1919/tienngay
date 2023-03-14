<?php

namespace App\Http\Controllers;

use App\Service\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InterestController extends Controller
{
    public function list(Request $request)
    {
        $response = Api::post('interest/get_list_interest_general');
        $data = [];
        $periods = [];
        $bieu_do = [];
        $thong_ke = [];
        $thong_ke1 = [];
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $data = isset($response['data']) ? $response['data'] : [];
        }
        $response1 = Api::post('interest/thong_ke_hop_dong');
        if (isset($response1['status']) && $response1['status'] == Api::HTTP_OK) {
            $bieu_do = isset($response1['bieu_do']) ? $response1['bieu_do'] : [];
//            $bieu_do2 = isset($response1['bieu_do2']) ? $response1['bieu_do2'] : [];
            $thong_ke = isset($response1['thong_ke']) ? $response1['thong_ke'] : [];
            $thong_ke1 = isset($response1['thong_ke1']) ? $response1['thong_ke1'] : [];
        }
        $response2 = Api::post('interest/get_interest_period');
        if (isset($response2['status']) && $response2['status'] == Api::HTTP_OK) {
            $periods = isset($response2['data']) ? $response2['data'] : [];
        }
        return view('interest.list', compact('data', 'bieu_do', 'thong_ke', 'periods', 'thong_ke1'));
    }

    public function create_interest_general(Request $request)
    {
        $interest = isset($request->interest) ? $request->interest : '';
        if (empty($interest)) {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => 'Lãi suất không để trống'
            ]);
        }
        $response = Api::post('interest/create_interest_general', ['interest' => $interest, 'created_by' => Session::get('user')['email']]);
        if (isset($response['status']) && $response['status'] == 200) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => 'Thêm mới thành công'
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => $response['message'] ? $response['message'] : 'Thêm mới không thành công'
            ]);
        }
    }

    public function active_interest_general(Request $request)
    {
        $response = Api::post('interest/active_interest_general', ['id' => $request->id, 'created_by' => Session::get('user')['email']]);
        if (isset($response['status']) && $response['status'] == 200) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => 'Kích hoạt thành công'
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => 'Kích hoạt không thành công'
            ]);
        }
    }

    public function detail_show(Request $request)
    {
        $response1 = Api::post('interest/show', ['id' => $request->id]);
        $interest = [];
        if (isset($response1['status']) && $response1['status'] == Api::HTTP_OK) {
            $interest = isset($response1['interest']) ? $response1['interest'] : [];
        }
        $page = $request->get('page') ? $request->get('page') : 1;
        $response = Api::post('interest/show_contract?page=' . $page, ['id' => $request->id]);
        $contracts = [];
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $contracts = isset($response['contracts']['data']) ? $response['contracts']['data'] : [];
            $paginate = page_render($contracts, $response['contracts']['per_page'] ?? 15, $response['contracts']['total'] ?? 0)->appends($request->query());
        }
        return view('interest.show', compact('interest', 'paginate', 'contracts'));
    }

    public function create_interest_period(Request $request)
    {
        $response = Api::post('interest/create_interest_period',
            [
                'interest' => $request->interest,
                'period' => $request->period,
                'type_interest' => $request->type_interest
            ]
        );
        if (isset($response['status']) && $response['status'] == 200) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => $request['message']
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => isset($response['message']) ? $response['message'] : 'Cập nhật không thành công'
            ]);
        }
    }

    public function update_interest_period(Request $request)
    {
        $response = Api::post('interest/update_interest_period', ['id' => $request->id]);
        if (isset($response['status']) && $response['status'] == 200) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => "Thành công"
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => "Thất bại"
            ]);
        }
    }

    public function show(Request $request)
    {
        $response = Api::post('interest/show', ['id' => $request->id]);
        $interest = isset($response['interest']) ? $response['interest'] : [];
        return response()->json([
            'status' => Api::HTTP_OK,
            'data' => $interest
        ]);
    }

    public function edit_add_interest_period(Request $request)
    {
        $response = Api::post('interest/edit_add_interest_period', ['id' => $request->id, 'interest' => $request->interest]);
        if (isset($response['status']) && $response['status'] == 200) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => "Thành công"
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => !empty($response['message']) ? $response['message'] : 'Thất bại'
            ]);
        }
    }


}

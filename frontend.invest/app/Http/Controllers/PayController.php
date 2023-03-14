<?php

namespace App\Http\Controllers;

use App\Service\Api;
use App\Service\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PayController extends Controller
{
    const HOP_DONG_UY_QUYEN = 'UQ';
    const HOP_DONG_DAU_TU_APP = 'APP';

    public function __construct(Excel $excel)
    {
        $this->sheet = $excel;
    }

    public function index(Request $request)
    {
        // Filter
        $filter = [];
        if (!empty($request->has('fdate')) && $request->get('fdate') != '') {
            $filter['fdate'] = $request->get('fdate');
        }

        if (!empty($request->has('tdate')) && $request->get('tdate') != '') {
            $filter['tdate'] = $request->get('tdate');
        }
        if (strtotime($request->get('fdate')) > strtotime($request->get('tdate'))) {
            return redirect()->route('pay.list')->with('error', 'Ngày bắt đầu không được lớn hơn ngày kết thúc');
        }
        if (!empty($request->has('code_contract')) && $request->get('code_contract') != '') {
            $filter['code_contract'] = $request->get('code_contract');
        }

        if ($request->has('investor_code') && $request->get('investor_code') != '') {
            $filter['investor_code'] = $request->get('investor_code');
        }

        if ($request->has('full_name') && $request->get('full_name') != '') {
            $filter['full_name'] = $request->get('full_name');
        }

        if ($request->has('status') && $request->get('status') != '') {
            $filter['status'] = $request->get('status');
        }
        $filter['type'] = self::HOP_DONG_DAU_TU_APP;
        // Page
        $page = $request->get('page') ? $request->get('page') : 1;

        // List
        $response = Api::post('pay/get_all_pay_app_v2?page=' . $page, $filter);
        $data = [];
        $paginate = null;
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $res_data = $response['data'];
            $data = isset($res_data['data']) ? collect($res_data['data']) : [];
            $overview = isset($response['overview']) ? ($response['overview']) : [];
            $paginate = page_render($data, $res_data['per_page'] ?? 15, $res_data['total'] ?? 0)->appends($request->query());
        }
        return view('pay.list', compact('data', 'paginate', 'overview'));
    }

    public function detail_paypal(Request $request)
    {
        $response = Api::post('pay/detail_paypal', ['id' => $request->id]);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $pay = isset($response['data']) ? ($response['data']) : [];
            $lai = [];
            $tong_lai = 0;
            $tong_goc_lai = 0;
            foreach ($pay['contract']['pays'] as $value) {
                $tong_lai += $value['lai_ky'];
                $tong_goc_lai += $value['goc_lai_1ky'];
            }
            $lai['tong_lai'] = round($tong_lai);
            $lai['tong_goc_lai'] = round($tong_goc_lai);
        }
        return view('pay.paypal', compact('pay', 'lai'));
    }

    public function paypal_investor(Request $request)
    {
        $data = [
            'id' => $request->id,
            'note' => $request->note,
            'created_by' => Session::get('user')['email'],
        ];
        $response = Api::post('pay/paypal_investor', $data);
        if (isset($response['status']) && $response['status'] == 200) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => "Thanh toán thành công"
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => $response['message'] ? $response['message'] : 'Thanh toán không thành công'
            ]);
        }
    }

    public function list_uq(Request $request)
    {
        // Filter
        $filter = [];
        if (!empty($request->has('fdate')) && $request->get('fdate') != '') {
            $filter['fdate'] = $request->get('fdate');
        }

        if (!empty($request->has('tdate')) && $request->get('tdate') != '') {
            $filter['tdate'] = $request->get('tdate');
        }
        if (strtotime($request->get('fdate')) > strtotime($request->get('tdate'))) {
            return redirect()->route('pay.list_uq')->with('error', 'Ngày bắt đầu không được lớn hơn ngày kết thúc');
        }
        if (!empty($request->has('code_contract')) && $request->get('code_contract') != '') {
            $filter['code_contract'] = $request->get('code_contract');
        }

        if ($request->has('full_name') && $request->get('full_name') != '') {
            $filter['full_name'] = $request->get('full_name');
        }
        $filter['type'] = self::HOP_DONG_UY_QUYEN;
        // Page
        $page = $request->get('page') ? $request->get('page') : 1;

        // List
        $response = Api::post('pay/get_all_pay_app_v2?page=' . $page, $filter);
        $data = [];
        $paginate = null;
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $res_data = $response['data'];
            $data = isset($res_data['data']) ? collect($res_data['data']) : [];
            $overview = isset($response['overview']) ? ($response['overview']) : [];
            $paginate = page_render($data, $res_data['per_page'] ?? 15, $res_data['total'] ?? 0)->appends($request->query());
        }
        return view('pay.list_uq', compact('data', 'paginate', 'overview'));
    }

    public function detail_paypal_hd_uq(Request $request)
    {
        $response = Api::post('pay/detail_paypal', ['id' => $request->id]);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $response['data']['goc_lai_1ky'] = number_format(round($response['data']['goc_lai_1ky']));
            $response['data']['tien_goc_1ky'] = number_format(round($response['data']['tien_goc_1ky']));
            $response['data']['lai_ky'] = number_format(round($response['data']['lai_ky']));
            $response['data']['unix_ky_tra'] = $response['data']['ngay_ky_tra'];
            $response['data']['ngay_ky_tra'] = date('d/m/Y', $response['data']['ngay_ky_tra']);
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => 'Thành công',
                'data' => $response['data']
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => 'Thất bại'
            ]);
        }
    }

    public function cap_nhat_ki_thanh_toan_ndt_uq(Request $request)
    {
        $response = Api::post('pay/cap_nhat_ki_thanh_toan_ndt_uq', ['id' => $request->id, 'date_pay' => strtotime($request->date_pay)]);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => 'Thành công',
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => isset($response['message']) ? $response['message'] : 'Thất bại'
            ]);
        }
    }

    public function excel_pay_app(Request $request)
    {
        // Filter
        $filter = [];
        if (!empty($request->has('fdate')) && $request->get('fdate') != '') {
            $filter['fdate'] = $request->get('fdate');
        }

        if (!empty($request->has('tdate')) && $request->get('tdate') != '') {
            $filter['tdate'] = $request->get('tdate');
        }
        if (strtotime($request->get('fdate')) > strtotime($request->get('tdate'))) {
            return redirect()->route('pay.list')->with('error', 'Ngày bắt đầu không được lớn hơn ngày kết thúc');
        }
        if (!empty($request->has('code_contract')) && $request->get('code_contract') != '') {
            $filter['code_contract'] = $request->get('code_contract');
        }

        if ($request->has('investor_code') && $request->get('investor_code') != '') {
            $filter['investor_code'] = $request->get('investor_code');
        }

        if ($request->has('full_name') && $request->get('full_name') != '') {
            $filter['full_name'] = $request->get('full_name');
        }
        $filter['type'] = self::HOP_DONG_DAU_TU_APP;
        $filter['excel'] = true;

        // List
        $response = Api::post('pay/get_all_pay_app_v2', $filter);
        $data = [];
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $data = isset($response['data']) ? $response['data'] : [];
            $this->sheet->setCellValue('A1', 'Nhà đầu tư');
            $this->sheet->setCellValue('B1', 'Mã hợp đồng');
            $this->sheet->setCellValue('C1', 'Tiền đầu tư');
            $this->sheet->setCellValue('D1', 'Kì trả');
            $this->sheet->setCellValue('E1', 'Tiền gốc trả');
            $this->sheet->setCellValue('F1', 'Tiền lãi trả');
            $this->sheet->setCellValue('G1', 'Tổng tiền trả');
            $this->sheet->setCellValue('H1', 'Ngày trả');
            $this->sheet->setCellValue('I1', 'Trạng thái');
            $this->sheet->setCellValue('J1', 'Hình thức trả lãi');
            $this->sheet->setCellValue('K1', 'ID');

            $this->sheet->setStyle("A1");
            $this->sheet->setStyle("B1");
            $this->sheet->setStyle("C1");
            $this->sheet->setStyle("D1");
            $this->sheet->setStyle("E1");
            $this->sheet->setStyle("F1");
            $this->sheet->setStyle("G1");
            $this->sheet->setStyle("H1");
            $this->sheet->setStyle("I1");
            $this->sheet->setStyle("J1");
            $this->sheet->setStyle("K1");
            $i = 2;
            foreach ($data as $item) {
                $status = '';
                if ($item['status'] == 1) {
                    $status = 'Chưa thanh toán';
                } elseif ($item['status'] == 2) {
                    $status = 'Đã thanh toán';
                } else {
                    $status = 'Chờ xử lý';
                }
                $this->sheet->setCellValue('A' . $i, !empty($item['name']) ? $item['name'] : '');
                $this->sheet->setCellValue('B' . $i, !empty($item['code_contract_disbursement']) ? $item['code_contract_disbursement'] : '');
                $this->sheet->setCellValue('C' . $i, !empty($item['investment_amount']) ? $item['investment_amount'] : 0, true);
                $this->sheet->setCellValue('D' . $i, !empty($item['ky_tra']) ? "Kì " . $item['ky_tra'] : "");
                $this->sheet->setCellValue('E' . $i, !empty($item['tien_goc_1ky_phai_tra']) ? (round($item['tien_goc_1ky_phai_tra'])) : 0, true);
                $this->sheet->setCellValue('F' . $i, !empty($item['tien_lai_1ky_phai_tra']) ? (round($item['tien_lai_1ky_phai_tra'])) : 0, true);
                $this->sheet->setCellValue('G' . $i, !empty($item['goc_lai_1ky']) ? (round($item['goc_lai_1ky'])) : 0, true);
                $this->sheet->setCellValue('H' . $i, !empty($item['ngay_ky_tra']) ? date('d/m/Y', $item['ngay_ky_tra']) : '');
                $this->sheet->setCellValue('I' . $i, $status);
                $this->sheet->setCellValue('J' . $i, $item['type_interest_receiving_account'] == 'vimo' ? 'vimo' : 'nganluong');
                $this->sheet->setCellValue('K' . $i, !empty($item['id']) ? $item['id'] : '');
                $i++;
            }
            $this->sheet->callLibExcel('data-pay-app-' . time() . '.xlsx');
        } else {
            redirect()->route('pay.list')->with('error', 'Không có dữ liệu để xuất excel');
        }
    }

    public function excel_pay_uq(Request $request)
    {
        // Filter
        $filter = [];
        if (!empty($request->has('fdate')) && $request->get('fdate') != '') {
            $filter['fdate'] = $request->get('fdate');
        }

        if (!empty($request->has('tdate')) && $request->get('tdate') != '') {
            $filter['tdate'] = $request->get('tdate');
        }
        if (strtotime($request->get('fdate')) > strtotime($request->get('tdate'))) {
            return redirect()->route('pay.list')->with('error', 'Ngày bắt đầu không được lớn hơn ngày kết thúc');
        }
        if (!empty($request->has('code_contract')) && $request->get('code_contract') != '') {
            $filter['code_contract'] = $request->get('code_contract');
        }

        if ($request->has('investor_code') && $request->get('investor_code') != '') {
            $filter['investor_code'] = $request->get('investor_code');
        }

        if ($request->has('full_name') && $request->get('full_name') != '') {
            $filter['full_name'] = $request->get('full_name');
        }
        $filter['type'] = self::HOP_DONG_UY_QUYEN;
        $filter['excel'] = true;

        // List
        $response = Api::post('pay/get_all_pay_app_v2', $filter);
        $data = [];
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $data = isset($response['data']) ? $response['data'] : [];
            $this->sheet->setCellValue('A1', 'Nhà đầu tư');
            $this->sheet->setCellValue('B1', 'Mã hợp đồng');
            $this->sheet->setCellValue('C1', 'Tiền đầu tư');
            $this->sheet->setCellValue('D1', 'Kì trả');
            $this->sheet->setCellValue('E1', 'Tiền gốc trả');
            $this->sheet->setCellValue('F1', 'Tiền lãi trả');
            $this->sheet->setCellValue('G1', 'Tổng tiền trả');
            $this->sheet->setCellValue('H1', 'Ngày trả');
            $this->sheet->setCellValue('I1', 'Trạng thái');
            $this->sheet->setCellValue('J1', 'Kì trả lãi');

            $this->sheet->setStyle("A1");
            $this->sheet->setStyle("B1");
            $this->sheet->setStyle("C1");
            $this->sheet->setStyle("D1");
            $this->sheet->setStyle("E1");
            $this->sheet->setStyle("F1");
            $this->sheet->setStyle("G1");
            $this->sheet->setStyle("H1");
            $this->sheet->setStyle("I1");
            $this->sheet->setStyle("J1");
            $i = 2;
            foreach ($data as $item) {
                $status = '';
                if ($item['status'] == 1) {
                    $status = 'Chưa thanh toán';
                } elseif ($item['status'] == 2) {
                    $status = 'Đã thanh toán';
                } else {
                    $status = 'Chờ xử lý';
                }
                $this->sheet->setCellValue('A' . $i, !empty($item['name']) ? $item['name'] : '');
                $this->sheet->setCellValue('B' . $i, !empty($item['code_contract_disbursement']) ? $item['code_contract_disbursement'] : '');
                $this->sheet->setCellValue('C' . $i, !empty($item['investment_amount']) ? $item['investment_amount'] : 0, true);
                $this->sheet->setCellValue('D' . $i, !empty($item['ky_tra']) ? "Kì " . $item['ky_tra'] : "");
                $this->sheet->setCellValue('E' . $i, !empty($item['tien_goc_1ky_phai_tra']) ? (round($item['tien_goc_1ky_phai_tra'])) : 0, true);
                $this->sheet->setCellValue('F' . $i, !empty($item['tien_lai_1ky_phai_tra']) ? (round($item['tien_lai_1ky_phai_tra'])) : 0, true);
                $this->sheet->setCellValue('G' . $i, !empty($item['goc_lai_1ky']) ? (round($item['goc_lai_1ky'])) : 0, true);
                $this->sheet->setCellValue('H' . $i, !empty($item['ngay_ky_tra']) ? date('d/m/Y', $item['ngay_ky_tra']) : '');
                $this->sheet->setCellValue('I' . $i, $status);
                $this->sheet->setCellValue('J' . $i, !empty($item['interest_period']) ? date('d/m/Y', $item['interest_period']) : '');
                $i++;
            }
            $this->sheet->callLibExcel('data-pay-uq-' . time() . '.xlsx');
        } else {
            redirect()->route('pay.list_uq')->with('error', 'Không có dữ liệu để xuất excel');
        }
    }

    public function update_wait_payment(Request $request, $id)
    {
        $response = Api::post('pay/check_transaction_nl', ['id' => $id]);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => 'Thành công',
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => isset($response['message']) ? $response['message'] : 'Thất bại'
            ]);
        }
    }

    public function expire_contract(Request $request)
    {
        $data = [
            'code_contract' => $request->code_contract_new ?? '',
            'type_interest' => $request->type_interest_new ?? '',
            'number_day_loan' => $request->number_day_loan_new ?? '',
            'interest' => $request->interest_new ?? '',
            'pay_id' => $request->id ?? '',
            'type_extend' => $request->type_extend ?? '',
            'amount_money' => !empty($request->amount_money_new) ? trim(str_replace(array(',', '.',), '', $request->amount_money_new)) : '',
            'created_at' => !empty($request->created_at) ? strtotime($request->created_at) : '',
        ];
        $response = Api::post('contract/expire_contract', $data);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => 'Thành công',
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => isset($response['message']) ? $response['message'] : 'Thất bại'
            ]);
        }
    }

}

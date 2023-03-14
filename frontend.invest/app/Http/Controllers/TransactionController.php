<?php

namespace App\Http\Controllers;

use App\Service\Api;
use App\Service\ApiUrl;
use App\Service\Excel;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    const DAU_TU = '1';
    const TRA_LAI = '2';
    const HOP_DONG_UY_QUYEN = 'UQ';
    const HOP_DONG_DAU_TU_APP = 'APP';

    public function __construct(Excel $excel)
    {
        $this->sheet = $excel;
    }

    public function proceeds(Request $request)
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
            return redirect()->route('transaction.proceeds')->with('error', 'Ngày bắt đầu không được lớn hơn ngày kết thúc');
        }
        if (!empty($request->has('order_code')) && $request->get('order_code') != '') {
            $filter['order_code'] = $request->get('order_code');
        }

        if ($request->has('investor_code') && $request->get('investor_code') != '') {
            $filter['investor_code'] = $request->get('investor_code');
        }

        if ($request->has('full_name') && $request->get('full_name') != '') {
            $filter['full_name'] = $request->get('full_name');
        }
        $filter['type_contract'] = self::HOP_DONG_DAU_TU_APP;
        // Page
        $page = $request->get('page') ? $request->get('page') : 1;
        // List
        $response = Api::post('transaction/money_management_v2?page=' . $page, $filter);
        $data = [];
        $paginate = null;
        $roles = [];
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $res_data = $response['data'];
            $data = isset($res_data['data']) ? collect($res_data['data']) : [];
            $paginate = page_render($data, $res_data['per_page'] ?? 15, $res_data['total'] ?? 0)->appends($request->query());
            $roles = !empty($response['role']) ? $response['role'] : [];
        }
        $response1 = Api::post('transaction/overview_transaction_proceeds', ['type_contract' => self::HOP_DONG_DAU_TU_APP]);
        $overview = [];
        if (isset($response1['status']) && $response1['status'] == Api::HTTP_OK) {
            $overview = $response1['data'] ? $response1['data'] : [];
        }
        if ($overview['tong_tien_thu_duoc_theo_tung_thang'] == 0) {
            if ($overview['tong_tien_thu_duoc_theo_thang'] == 0) {
                $xu_the = 0;
                $tang_truong = 0 . '%';
            } else {
                $xu_the = 2;
                $tang_truong = 100 . '%';
            }
        } else {
            if ($overview['tong_tien_thu_duoc_theo_tung_thang'] < $overview['tong_tien_thu_duoc_theo_thang']) {
                $xu_the = 2;
                $tang_truong = round(((($overview['tong_tien_thu_duoc_theo_thang'] / $overview['tong_tien_thu_duoc_theo_tung_thang']) * 100) - 100), 2) . '%';
            } elseif ($overview['tong_tien_thu_duoc_theo_tung_thang'] > $overview['tong_tien_thu_duoc_theo_thang']) {
                $xu_the = 1;
                $tang_truong = round((100 - (($overview['tong_tien_thu_duoc_theo_thang'] / $overview['tong_tien_thu_duoc_theo_tung_thang']) * 100)), 2) . '%';
            } else {
                $xu_the = 0;
                $tang_truong = 0 . '%';
            }
        }
        return view('transaction.proceeds', compact('data', 'paginate', 'overview', 'xu_the', 'tang_truong', 'roles'));
    }

    public function payment(Request $request)
    {
        $filter = [];
        if (!empty($request->has('fdate')) && $request->get('fdate') != '') {
            $filter['fdate'] = $request->get('fdate');
        }

        if (!empty($request->has('tdate')) && $request->get('tdate') != '') {
            $filter['tdate'] = $request->get('tdate');
        }
        if (strtotime($request->get('fdate')) > strtotime($request->get('tdate'))) {
            return redirect()->route('transaction.proceeds')->with('error', 'Ngày bắt đầu không được lớn hơn ngày kết thúc');
        }
        $page = ($request->has('page') && $request->get('page') != '') ? $request->get('page') : 1;
        // Count All
        $response = Api::post(ApiUrl::TRANSACTION_COUNT_ALL_TIME, ['type_contract' => self::HOP_DONG_DAU_TU_APP]);
        $count_all_time = 0;
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $count_all_time = $response['data'] ?? 0;
        }
        // Count Month
        $response = Api::post(ApiUrl::TRANSACTION_COUNT_MONTH, ['type_contract' => self::HOP_DONG_DAU_TU_APP]);
        $count_month = 0;
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $count_month = $response['data'] ?? 0;
        }
        // List
        $paginate = null;
        $data = [];
        $filter['type_contract'] = self::HOP_DONG_DAU_TU_APP;
        $response = Api::post(ApiUrl::TRANSACTION_MONEY_PAYMENT . '?page=' . $page, $filter);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $res_data = $response['data'];
            $data = isset($res_data['data']) ? collect($res_data['data']) : [];
            $paginate = page_render($data, $res_data['per_page'] ?? 15, $res_data['total'] ?? 0)->appends($request->query());
        }
        return view('transaction.payment', compact('data', 'paginate', 'count_all_time', 'count_month'));

    }

    public function excelTransactionInvest(Request $request)
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
            return redirect()->route('transaction.proceeds')->with('error', 'Ngày bắt đầu không được lớn hơn ngày kết thúc');
        }
        if (!empty($request->has('order_code')) && $request->get('order_code') != '') {
            $filter['order_code'] = $request->get('order_code');
        }

        if ($request->has('investor_code') && $request->get('investor_code') != '') {
            $filter['investor_code'] = $request->get('investor_code');
        }

        if ($request->has('full_name') && $request->get('full_name') != '') {
            $filter['full_name'] = $request->get('full_name');
        }
        $filter['type_contract'] = self::HOP_DONG_DAU_TU_APP;
        $filter['excel'] = true;
        $response = Api::post('transaction/money_management_v2', $filter);
        $data = [];
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $roles = !empty($response['role']) ? $response['role'] : [];
            $data = isset($response['data']) ? $response['data'] : [];
            $this->sheet->setCellValue('A1', 'Nhà đầu tư');
            $this->sheet->setCellValue('B1', 'Mã giao dịch');
            $this->sheet->setCellValue('C1', 'Mã hợp đồng');
            $this->sheet->setCellValue('D1', 'Số tiền');
            $this->sheet->setCellValue('E1', 'Lãi suất');
            $this->sheet->setCellValue('F1', 'Hình thức trả lãi');
            $this->sheet->setCellValue('G1', 'Tổng tiền lãi');
            $this->sheet->setCellValue('H1', 'Số tháng đầu tư');
            $this->sheet->setCellValue('I1', 'Ngày giao dịch');
            $this->sheet->setCellValue('J1', 'Loại giao dịch');
            if (in_array('telesales', $roles)) {
                $this->sheet->setCellValue('K1', 'TLS');
            }

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
            if (in_array('telesales', $roles)) {
                $this->sheet->setStyle("K1");
            }
            $i = 2;
            foreach ($data as $item) {
                ;
                if (!empty($item['payment_source']) && $item['payment_source'] != null) {
                    $source = $item['payment_source'];
                } else {
                    $source = 'vimo';
                }
                $this->sheet->setCellValue('A' . $i, !empty($item['name']) ? $item['name'] : '');
                $this->sheet->setCellValue('B' . $i, !empty($item['transaction_vimo']) ? $item['transaction_vimo'] : $item['trading_code']);
                $this->sheet->setCellValue('C' . $i, !empty($item['code_contract_disbursement']) ? $item['code_contract_disbursement'] : "");
                $this->sheet->setCellValue('D' . $i, !empty($item['investment_amount']) ? $item['investment_amount'] : 0, true);
                $this->sheet->setCellValue('E' . $i, !empty($item['interest']) ? data_get(json_decode($item['interest'], true), 'interest') : "");
                $this->sheet->setCellValue('F' . $i, type_interest($item['type_interest']));
                $this->sheet->setCellValue('G' . $i, !empty($item['tong_tien_lai']) ? (round($item['tong_tien_lai'])) : 0, true);
                $this->sheet->setCellValue('H' . $i, !empty($item['number_day_loan']) ? $item['number_day_loan'] / 30 . ' tháng' : "");
                $this->sheet->setCellValue('I' . $i, !empty($item['created_at']) ? date('d/m/Y H:i:s', strtotime($item['created_at'])) : '');
                $this->sheet->setCellValue('J' . $i, $source);
                if (in_array('telesales', $roles)) {
                    $this->sheet->setCellValue('K' . $i, !empty($item['user_call']) ? $item['user_call'] : "");
                }
                $i++;
            }
            $this->sheet->callLibExcel('data-transaction-investor-' . time() . '.xlsx');
        } else {
            redirect()->route('transaction.proceeds')->with('error', 'Không có dữ liệu để xuất excel');
        }
    }

    public function excelTransactionPayment(Request $request)
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
            return redirect()->route('transaction.payment_uq')->with('error', 'Ngày bắt đầu không được lớn hơn ngày kết thúc');
        }
        $filter['code_contract'] = $request->code_contract ?? "";
        $filter['full_name'] = $request->full_name ?? "";
        $filter['type_contract'] = self::HOP_DONG_DAU_TU_APP;
        $filter['excel'] = true;
        $response = Api::post('transaction/money_payment_v2', $filter);

        $data = [];
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $data = isset($response['data']) ? $response['data'] : [];
            $this->sheet->setCellValue('A1', 'Nhà đầu tư');
            $this->sheet->setCellValue('B1', 'Mã giao dịch');
            $this->sheet->setCellValue('C1', 'Mã hợp đồng');
            $this->sheet->setCellValue('D1', 'Tiền đầu tư');
            $this->sheet->setCellValue('E1', 'Tiền gốc trả');
            $this->sheet->setCellValue('F1', 'Tiền lãi trả');
            $this->sheet->setCellValue('G1', 'Tổng tiền trả');
            $this->sheet->setCellValue('H1', 'Ngày thanh toán');
            $this->sheet->setCellValue('I1', 'Loại giao dịch');

            $this->sheet->setStyle("A1");
            $this->sheet->setStyle("B1");
            $this->sheet->setStyle("C1");
            $this->sheet->setStyle("D1");
            $this->sheet->setStyle("E1");
            $this->sheet->setStyle("F1");
            $this->sheet->setStyle("G1");
            $this->sheet->setStyle("H1");
            $this->sheet->setStyle("I1");
            $i = 2;
            foreach ($data as $item) {
                if (!empty($item['payment_source']) && $item['payment_source'] != null) {
                    $source = $item['payment_source'];
                } else {
                    $source = 'vimo';
                }

                $this->sheet->setCellValue('A' . $i, !empty($item['investor_name']) ? $item['investor_name'] : '');
                $this->sheet->setCellValue('B' . $i, !empty($item['transaction_vimo']) ? $item['transaction_vimo'] : $item['trading_code']);
                $this->sheet->setCellValue('C' . $i, !empty($item['code_contract_disbursement']) ? $item['code_contract_disbursement'] : "");
                $this->sheet->setCellValue('D' . $i, !empty($item['contract_amount_money']) ? ($item['contract_amount_money']) : 0, true);
                $this->sheet->setCellValue('E' . $i, !empty($item['tien_goc']) ? (round($item['tien_goc'])) : 0, true);
                $this->sheet->setCellValue('F' . $i, !empty($item['tien_lai']) ? (round($item['tien_lai'])) : 0, true);
                $this->sheet->setCellValue('G' . $i, !empty($item['tong_goc_lai']) ? (round($item['tong_goc_lai'])) : 0, true);
                $this->sheet->setCellValue('H' . $i, !empty($item['created_at']) ? date('d/m/Y H:i:s', strtotime($item['created_at'])) : '');
                $this->sheet->setCellValue('I' . $i, $source);
                $i++;
            }
            $this->sheet->callLibExcel('data-transaction-payment-' . time() . '.xlsx');
        } else {
            redirect()->route('transaction.payment')->with('error', 'Không có dữ liệu để xuất excel');
        }
    }

    public function proceeds_uq(Request $request)
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
            return redirect()->route('transaction.proceeds')->with('error', 'Ngày bắt đầu không được lớn hơn ngày kết thúc');
        }
        if (!empty($request->has('order_code')) && $request->get('order_code') != '') {
            $filter['order_code'] = $request->get('order_code');
        }

        if ($request->has('investor_code') && $request->get('investor_code') != '') {
            $filter['investor_code'] = $request->get('investor_code');
        }

        if ($request->has('full_name') && $request->get('full_name') != '') {
            $filter['full_name'] = $request->get('full_name');
        }
        $filter['type_contract'] = self::HOP_DONG_UY_QUYEN;
        // Page
        $page = $request->get('page') ? $request->get('page') : 1;
        // List
        $response = Api::post('transaction/money_management_v2?page=' . $page, $filter);
        $data = [];
        $paginate = null;
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $res_data = $response['data'];
            $data = isset($res_data['data']) ? collect($res_data['data']) : [];
            $paginate = page_render($data, $res_data['per_page'] ?? 15, $res_data['total'] ?? 0)->appends($request->query());
        }

        $response1 = Api::post('transaction/overview_transaction_proceeds', ['type_contract' => self::HOP_DONG_UY_QUYEN]);
        $overview = [];
        if (isset($response1['status']) && $response1['status'] == Api::HTTP_OK) {
            $overview = $response1['data'] ? $response1['data'] : [];
        }
        return view('transaction.processds_uq', compact('data', 'paginate', 'overview'));
    }

    public function payment_uq(Request $request)
    {
        $filter = [];
        if (!empty($request->has('fdate')) && $request->get('fdate') != '') {
            $filter['fdate'] = $request->get('fdate');
        }

        if (!empty($request->has('tdate')) && $request->get('tdate') != '') {
            $filter['tdate'] = $request->get('tdate');
        }
        if (strtotime($request->get('fdate')) > strtotime($request->get('tdate'))) {
            return redirect()->route('transaction.proceeds')->with('error', 'Ngày bắt đầu không được lớn hơn ngày kết thúc');
        }

        $filter['code_contract'] = $request->code_contract ?? "";
        $filter['full_name'] = $request->full_name ?? "";
        $page = ($request->has('page') && $request->get('page') != '') ? $request->get('page') : 1;

        $paginate = null;
        $data = [];
        $filter['type_contract'] = self::HOP_DONG_UY_QUYEN;
        $response = Api::post(ApiUrl::TRANSACTION_MONEY_PAYMENT . '?page=' . $page, $filter);
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $res_data = $response['data'];
            $data = isset($res_data['data']) ? collect($res_data['data']) : [];
            $paginate = page_render($data, $res_data['per_page'] ?? 15, $res_data['total'] ?? 0)->appends($request->query());
        }
        return view('transaction.payment_uq', compact('data', 'paginate'));

    }
}

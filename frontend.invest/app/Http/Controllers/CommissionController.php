<?php

namespace App\Http\Controllers;

use App\Service\Api;
use App\Service\Excel;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function __construct(Excel $excel)
    {
        $this->sheet = $excel;
    }

    public function list(Request $request)
    {
        $filter = [];
        $filter['month'] = $request->month ?? "";
        $filter['name'] = $request->name ?? "";

        // Page
        $page = $request->get('page') ? $request->get('page') : 1;
        // List
        $response = Api::post('commission/get_all_commission' . '?page=' . $page, $filter);
        $data = [];
        $paginate = null;
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $res_data = $response['data'];
            $data = isset($res_data['data']) ? collect($res_data['data']) : [];
            $paginate = page_render($data, $res_data['per_page'] ?? 15, $res_data['total'] ?? 0)->appends($request->query());
        }
        return view('commission.list', compact('data', 'paginate'));
    }

    public function detail(Request $request)
    {
        $filter = [];
        $filter['month'] = $request->month ?? "";
        $filter['id'] = $request->id ?? "";

        $response = Api::post('commission/detail_commission_investor', $filter);
        $data = [];
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $data = isset($response['data']) ? collect($response['data']) : [];
        }
        return view('commission.detail', compact('data'));
    }

    public function excel(Request $request)
    {
        $filter = [];
        $filter['month'] = $request->month ?? "";
        $response = Api::post('commission/excel_all_commission', $filter);
        $data = [];
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $data = isset($response['data']) ? $response['data'] : [];
            $this->sheet->setCellValue('A1', 'CSKH');
            $this->sheet->setCellValue('B1', 'Người giới thiệu');
            $this->sheet->setCellValue('C1', 'Tên nhà đầu tư');
            $this->sheet->setCellValue('D1', 'Mã hợp đồng');
            $this->sheet->setCellValue('E1', 'Tiền đầu tư');
            $this->sheet->setCellValue('F1', 'Số tiền tính hoa hồng');
            $this->sheet->setCellValue('G1', 'Ngày giao dịch');
            $this->sheet->setCellValue('H1', 'Thời gian');
            $this->sheet->setCellValue('I1', 'Hình thức đầu tư');
            $this->sheet->setCellValue('J1', 'Tỉ lệ thưởng');
            $this->sheet->setCellValue('K1', 'Tiền thưởng');

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
                $this->sheet->setCellValue('A' . $i, $item['call'] ?? "");
                $this->sheet->setCellValue('B' . $i, $item['ref']['full_name'] ?? "");
                $this->sheet->setCellValue('C' . $i, $item['full_name'] ?? "");
                $this->sheet->setCellValue('D' . $i, $item['code_contract_disbursement'] ?? "");
                $this->sheet->setCellValue('E' . $i, !empty($item['amount_money']) ? $item['amount_money'] : "", true);
                $this->sheet->setCellValue('F' . $i, !empty($item['total_money']) ? $item['total_money'] : "", true);
                $this->sheet->setCellValue('G' . $i, !empty($item['contract_created_at']) ? date('d/m/Y', strtotime($item['contract_created_at'])) : "");
                $this->sheet->setCellValue('H' . $i, !empty($item['number_day_loan']) ? $item['number_day_loan'] / 30 . ' tháng' : "");
                $this->sheet->setCellValue('I' . $i,  type_interest($item['type_interest']));
                $this->sheet->setCellValue('J' . $i, !empty($item['commission']) ? $item['commission'] . '%' : "");
                $this->sheet->setCellValue('K' . $i, !empty($item['money_commission']) ? $item['money_commission'] : 0, true);
                $i++;
            }
            $this->sheet->callLibExcel('data-commission-' . time() . '.xlsx');
        } else {
            redirect()->route('commission')->with('error', 'Không có dữ liệu để xuất excel');
        }
    }

    public function excel_detail(Request $request)
    {
        $filter = [];
        $filter['month'] = $request->month ?? "";
        $filter['id'] = $request->id ?? "";

        $response = Api::post('commission/detail_commission_investor', $filter);
        $data = [];
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $data = isset($response['data']) ? $response['data'] : [];
            $this->sheet->setCellValue('A1', 'Người giới thiệu');
            $this->sheet->setCellValue('B1', 'Tên nhà đầu tư');
            $this->sheet->setCellValue('C1', 'Mã hợp đồng');
            $this->sheet->setCellValue('D1', 'Số tiền tính hoa hồng');
            $this->sheet->setCellValue('E1', 'Ngày giao dịch');
            $this->sheet->setCellValue('F1', 'Thời gian');
            $this->sheet->setCellValue('G1', 'Hình thức đầu tư');
            $this->sheet->setCellValue('H1', 'Tỉ lệ thưởng');
            $this->sheet->setCellValue('I1', 'Tiền thưởng');

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
            foreach ($data['detail'] as $item) {
                $this->sheet->setCellValue('A' . $i, $data['total']['full_name'] ?? "");
                $this->sheet->setCellValue('B' . $i, $item['nha_dau_tu'] ?? "");
                $this->sheet->setCellValue('C' . $i, $item['ma_hop_dong'] ?? "");
                $this->sheet->setCellValue('D' . $i, !empty($item['so_tien']) ? number_format($item['so_tien']) : "", true);
                $this->sheet->setCellValue('E' . $i, !empty($item['ngay_giao_dich']) ? date('d-m-Y', strtotime($item['ngay_giao_dich'])) : "");
                $this->sheet->setCellValue('F' . $i, !empty($item['thoi_gian']) ? $item['thoi_gian'] . ' tháng' : "");
                $this->sheet->setCellValue('G' . $i, !empty($item['hinh_thuc']) ? $item['hinh_thuc'] : "");
                $this->sheet->setCellValue('H' . $i, !empty($item['ti_le_thuong']) ? $item['ti_le_thuong'] . '%' : "");
                $this->sheet->setCellValue('I' . $i, !empty($item['tien_thuong']) ? number_format($item['tien_thuong']) : 0, true);
                $i++;
            }
            $this->sheet->callLibExcel('data-commission-detail' . time() . '.xlsx');
        } else {
            redirect()->route('commission')->with('error', 'Không có dữ liệu để xuất excel');
        }
    }
}

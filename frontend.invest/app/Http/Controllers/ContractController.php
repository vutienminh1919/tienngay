<?php


namespace App\Http\Controllers;

use App\Exports\ContractExport;
use App\Service\Api;
use App\Service\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

//use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ContractController extends Controller
{
    const DU_NO_GIAM_DAN = '1';
    const GOC_CUOI_KY = '2';
    const GOC_LAI_CUOI_KI = '4';
    const LAI_3THANG_GOC_CUOI_KY = '3';
    const LAI_CUOI_THANG = '5';

    const HOP_DONG_UY_QUYEN = 'UQ';
    const HOP_DONG_DAU_TU_APP = 'APP';

    public function __construct(Excel $excel)
    {
        $this->sheet = $excel;
    }

    public function list(Request $request)
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
            return redirect()->route('contract.list')->with('error', 'Ngày bắt đầu không được lớn hơn ngày kết thúc');
        }
        if (!empty($request->has('code_contract')) && $request->get('code_contract') != '') {
            $filter['code_contract'] = $request->get('code_contract');
        }

        if ($request->has('investor_code') && $request->get('investor_code') != '') {
            $filter['investor_code'] = $request->get('investor_code');
        }

        $filter['status'] = $request->status ?? '';
        $filter['action'] = 'get';
        // Page
        $page = $request->get('page') ? $request->get('page') : 1;

        // List
        $response = Api::post('contract/get_all_contract?page=' . $page, $filter);
        $data = [];
        $paginate = null;
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $res_data = $response['data'];
            $data = isset($res_data['data']) ? collect($res_data['data']) : [];
            $paginate = page_render($data, $res_data['per_page'] ?? 15, $res_data['total'] ?? 0)->appends($request->query());
        }
        return view('contract.list', compact('data', 'paginate'));
    }

    public function show(Request $request)
    {
        $response = Api::post('contract/contract_payment_schedule', ['code' => $request->code]);
        $contract = [];
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $contract = isset($response['data']) ? $response['data'] : [];
            $tong_lai = 0;
            $tong_goc_lai = 0;
            foreach ($contract['pays'] as $c) {
                $tong_lai += $c['lai_ky'];
                $tong_goc_lai += $c['goc_lai_1ky'];
            }
            $contract['tong_lai'] = ($tong_lai);
            $contract['tong_goc_lai'] = ($tong_goc_lai);
        }
        return view('contract.show', compact('contract'));
    }

    public function excelContract(Request $request)
    {
        $filter = [];
        if (!empty($request->has('fdate')) && $request->get('fdate') != '') {
            $filter['fdate'] = $request->get('fdate');
        }

        if (!empty($request->has('tdate')) && $request->get('tdate') != '') {
            $filter['tdate'] = $request->get('tdate');
        }
        if (strtotime($request->get('fdate')) > strtotime($request->get('tdate'))) {
            return redirect()->route('contract.list')->with('error', 'Ngày bắt đầu không được lớn hơn ngày kết thúc');
        }
        if (!empty($request->has('code_contract')) && $request->get('code_contract') != '') {
            $filter['code_contract'] = $request->get('code_contract');
        }

        if ($request->has('investor_code') && $request->get('investor_code') != '') {
            $filter['investor_code'] = $request->get('investor_code');
        }

        $filter['status'] = $request->status ?? '';
        $filter['action'] = 'excel';

        $filter['type'] = $request->type ?? "";
        $response = Api::post('contract/get_all_contract', $filter);
        $contracts = [];
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $contracts = isset($response['data']) ? $response['data'] : [];
            $this->sheet->setCellValue('A1', 'Mã phiếu ghi');
            $this->sheet->setCellValue('B1', 'Mã hợp đồng');
            $this->sheet->setCellValue('C1', 'Nhà đầu tư');
            $this->sheet->setCellValue('D1', 'Số tiền đầu tư');
            $this->sheet->setCellValue('E1', 'Lãi suất/năm');
            $this->sheet->setCellValue('F1', 'Số tháng đầu tư');
            $this->sheet->setCellValue('G1', 'Số kỳ đã thanh toán');
            $this->sheet->setCellValue('H1', 'Ngày đầu tư');
            $this->sheet->setCellValue('I1', 'Hình thức');
            $this->sheet->setCellValue('J1', 'Tình trạng');
            $this->sheet->setCellValue('K1', 'Tổng lãi');
            $this->sheet->setCellValue('L1', 'Lãi đã trả');
            $this->sheet->setCellValue('M1', 'Gốc đã trả');
            $this->sheet->setCellValue('N1', 'Ngày đáo hạn dự kiến');
            $this->sheet->setCellValue('O1', 'Ngày đáo hạn thực tế');

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
            $this->sheet->setStyle("L1");
            $this->sheet->setStyle("M1");
            $this->sheet->setStyle("N1");
            $this->sheet->setStyle("O1");
            $i = 2;
            foreach ($contracts as $item) {
                $this->sheet->setCellValue('A' . $i, !empty($item['code_contract']) ? $item['code_contract'] : '');
                $this->sheet->setCellValue('B' . $i, !empty($item['code_contract_disbursement']) ? $item['code_contract_disbursement'] : '');
                $this->sheet->setCellValue('C' . $i, !empty($item['investor_name']) ? $item['investor_name'] : "");
                $this->sheet->setCellValue('D' . $i, !empty($item['amount_money']) ? ($item['amount_money']) : "", true);
                $this->sheet->setCellValue('E' . $i, !empty($item['interest']) ? convert_interest(data_get(json_decode($item['interest'], true), 'interest')) : '');
                $this->sheet->setCellValue('F' . $i, !empty($item['number_day_loan']) ? $item['number_day_loan'] / 30 . ' tháng' : "");
                $this->sheet->setCellValue('G' . $i, !empty($item['da_thanh_toan']) ? $item['da_thanh_toan'] : 0);
                $this->sheet->setCellValue('H' . $i, !empty($item['start_date']) ? date('d-m-Y', $item['start_date']) : '');
                $this->sheet->setCellValue('I' . $i, !empty($item['type_interest']) ? type_interest($item['type_interest']) : '');
                $this->sheet->setCellValue('J' . $i, $item['status_contract'] == 1 ? "Đang đầu tư" : "Đã đáo hạn");
                $this->sheet->setCellValue('K' . $i, !empty($item['tong_lai']) ? ($item['tong_lai']) : "", true);
                $this->sheet->setCellValue('L' . $i, !empty($item['lai_da_tra']) ? ($item['lai_da_tra']) : "", true);
                $this->sheet->setCellValue('M' . $i, !empty($item['goc_da_tra']) ? ($item['goc_da_tra']) : "", true);
                $this->sheet->setCellValue('N' . $i, !empty($item['due_date']) ? date('d-m-Y', $item['due_date']) : '');
                $this->sheet->setCellValue('O' . $i, !empty($item['date_expire']) ? date('d-m-Y', $item['date_expire']) : '');
                $i++;
            }
            $this->sheet->callLibExcel('data-contract-investor-' . time() . '.xlsx');
        } else {
            redirect()->route('contract.list')->with('error', 'Không có dữ liệu để xuất excel');
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
            return redirect()->route('contract.list')->with('error', 'Ngày bắt đầu không được lớn hơn ngày kết thúc');
        }
        if (!empty($request->has('code_contract')) && $request->get('code_contract') != '') {
            $filter['code_contract'] = $request->get('code_contract');
        }

        if ($request->has('investor_code') && $request->get('investor_code') != '') {
            $filter['investor_code'] = $request->get('investor_code');
        }

        $filter['type'] = self::HOP_DONG_UY_QUYEN;
        $filter['action'] = 'get';
        // Page
        $page = $request->get('page') ? $request->get('page') : 1;

        // List
        $response = Api::post('contract/get_all_contract?page=' . $page, $filter);
        $data = [];
        $paginate = null;
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $res_data = $response['data'];
            $data = isset($res_data['data']) ? collect($res_data['data']) : [];
            $paginate = page_render($data, $res_data['per_page'] ?? 30, $res_data['total'] ?? 0)->appends($request->query());
        }
        return view('contract.list_uq', compact('data', 'paginate'));
    }

    public function payment_many(Request $request)
    {
        $data = [
            'contract_id' => $request->contract_id,
        ];
        $response = Api::post('contract/payment_many', $data);
        if (!empty($response['status']) && $response['status'] == Api::HTTP_OK) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => 'Cập nhật thành công'
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => !empty($response['message']) ? $response['message'] : 'Thất bại'
            ]);
        }
    }

    public function report_uq(Request $request)
    {
        $filter = [];
        $filter['month'] = $request->month ?? date('Y-m');
        $filter['full_name'] = $request->full_name ?? '';
        $filter['action'] = 'paginate';
        // Page
        $page = $request->get('page') ? $request->get('page') : 1;

        // List
        $response = Api::post('contract/report_contract_uq?page=' . $page, $filter);
        $data = [];
        $paginate = null;
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $res_data = $response['data'];
            $data = isset($res_data['data']) ? collect($res_data['data']) : [];
            $paginate = page_render($data, $res_data['per_page'] ?? 15, $res_data['total'] ?? 0)->appends($request->query());
        }
        return view('contract.report_uq', compact('data', 'paginate'));
    }

    public function excel_report_uq(Request $request)
    {
        $filter = [];
        $filter['month'] = $request->month ?? date('Y-m');
        $filter['full_name'] = $request->full_name ?? '';
        $filter['action'] = 'get';
        $response = Api::post('contract/report_contract_uq', $filter);
        $contracts = [];
        if (isset($response['status']) && $response['status'] == Api::HTTP_OK) {
            $contracts = isset($response['data']) ? $response['data'] : [];
            $this->sheet->setCellValue('A1', 'Nhà đầu tư');
            $this->sheet->setCellValue('B1', 'Phụ lục');
            $this->sheet->setCellValue('C1', 'Số tiền đầu tư');
            $this->sheet->setCellValue('D1', 'Kỳ hạn/tháng');
            $this->sheet->setCellValue('E1', 'Lãi suất đúng hạn/năm');
            $this->sheet->setCellValue('F1', 'Lãi suất trước hạn/năm');
            $this->sheet->setCellValue('G1', 'Hình thức trả lãi');
            $this->sheet->setCellValue('H1', 'Ngày đầu tư');
            $this->sheet->setCellValue('I1', 'Ngày đáo dự kiến');
            $this->sheet->setCellValue('J1', 'Ngày đáo thực tế');
            $this->sheet->setCellValue('K1', 'Trạng thái');
            $this->sheet->setCellValue('L1', 'Số ngày tính lãi trong tháng');
            $this->sheet->setCellValue('M1', 'Lãi suất thực tế phải trả/năm');
            $this->sheet->setCellValue('N1', 'Lãi tạm trích trước trong tháng');
            $this->sheet->setCellValue('O1', 'Gốc đã trả');
            $this->sheet->setCellValue('P1', 'Lãi đã trả');
            $this->sheet->setCellValue('Q1', 'Lãi đã trả đến tháng báo cáo');

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
            $this->sheet->setStyle("L1");
            $this->sheet->setStyle("M1");
            $this->sheet->setStyle("N1");
            $this->sheet->setStyle("O1");
            $this->sheet->setStyle("P1");
            $this->sheet->setStyle("Q1");
            $i = 2;
            foreach ($contracts as $item) {
                $lai_truoc_han = 0;
                if ($item['status_contract'] == 2) {
                    $lai_truoc_han = !empty(data_get(json_decode($item['interest'], true), 'early_interest_year')) ? data_get(json_decode($item['interest'], true), 'early_interest_year') : data_get(json_decode($item['interest'], true), 'interest_year');
                }
                $this->sheet->setCellValue('A' . $i, $item['investor_name'] ?? "");
                $this->sheet->setCellValue('B' . $i, $item['code_contract'] ?? "");
                $this->sheet->setCellValue('C' . $i, !empty($item['amount_money']) ? ($item['amount_money']) : '', true);
                $this->sheet->setCellValue('D' . $i, $item['number_day_loan'] / 30 ?? "");
                $this->sheet->setCellValue('E' . $i, !empty($item['interest']) ? data_get(json_decode($item['interest'], true), 'interest_year') : '');
                $this->sheet->setCellValue('F' . $i, 0.2);
                $this->sheet->setCellValue('G' . $i, type_interest($item['type_interest']));
                $this->sheet->setCellValue('H' . $i, !empty($item['start_date']) ? date('d-m-Y', $item['start_date']) : '');
                $this->sheet->setCellValue('I' . $i, !empty($item['due_date']) ? date('d-m-Y', $item['due_date']) : '');
                $this->sheet->setCellValue('J' . $i, !empty($item['date_expire']) ? date('d-m-Y', $item['date_expire']) : '');
                $this->sheet->setCellValue('K' . $i, status_contract($item['status_contract']));
                $this->sheet->setCellValue('L' . $i, !empty($item['date_diff']) ? $item['date_diff'] : 0);
                $this->sheet->setCellValue('M' . $i, $lai_truoc_han);
                $this->sheet->setCellValue('N' . $i, !empty($item['interest_profit']) ? ($item['interest_profit']) : 0, true);
                $this->sheet->setCellValue('O' . $i, !empty($item['goc_da_tra']) ? ($item['goc_da_tra']) : 0, true);
                $this->sheet->setCellValue('P' . $i, !empty($item['lai_da_tra']) ? ($item['lai_da_tra']) : 0, true);
                $this->sheet->setCellValue('Q' . $i, !empty($item['lai_da_tra_toi_ngay_bao_cao']) ? ($item['lai_da_tra_toi_ngay_bao_cao']) : 0, true);
                $i++;
            }
            $this->sheet->callLibExcel('data-report-contract-uq-investor-' . time() . '.xlsx');
        } else {
            redirect()->route('contract.report_uq')->with('error', 'Không có dữ liệu để xuất excel');
        }
    }

    public function calculator_due_before_maturity(Request $request)
    {
        $data = [
            'id' => $request->id,
            'punish' => $request->punish,
            'expire_date' => $request->expire_date,
            'early_interest' => $request->early_interest,
        ];
        $response = Api::post('contract/calculator_due_before_maturity', $data);
        if (!empty($response['status']) && $response['status'] == Api::HTTP_OK) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => 'Thành công',
                'data' => $response['data']
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => !empty($response['message']) ? $response['message'] : 'Thất bại'
            ]);
        }
    }

    public function detail_contract($id)
    {
        $response = Api::post('contract/detail_contract', ['id' => $id]);
        if (!empty($response['status']) && $response['status'] == Api::HTTP_OK) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => 'Thành công',
                'data' => $response['data']
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => !empty($response['message']) ? $response['message'] : 'Thất bại'
            ]);
        }
    }

    public function due_before_maturity(Request $request)
    {
        $data = [
            'id' => $request->id,
            'punish' => $request->punish,
            'expire_date' => $request->expire_date,
            'early_interest' => $request->early_interest,
        ];
        $response = Api::post('contract/due_before_maturity', $data);
        if (!empty($response['status']) && $response['status'] == Api::HTTP_OK) {
            return response()->json([
                'status' => Api::HTTP_OK,
                'message' => 'Thành công',
                'data' => $response['data']
            ]);
        } else {
            return response()->json([
                'status' => Api::HTTP_ERROR,
                'message' => !empty($response['message']) ? $response['message'] : 'Thất bại'
            ]);
        }
    }
}


<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AccountingSystem extends MY_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        $this->load->model("store_model");
        $this->load->model("time_model");
        $this->load->model("contract_model");
        $this->load->library('pagination');
        $this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
        if (!$this->is_superadmin) {
            $paramController = $this->uri->segment(1);
            $param = strtolower($paramController);
            if (!in_array($param, $this->paramMenus)) {
                $this->session->set_flashdata('error', $this->lang->line('not_have_permission').' '.$paramController .'!');
                redirect(base_url('app'));
                return;
            }
        }
        $this->spreadsheet = new Spreadsheet();
        $this->sheet = $this->spreadsheet->getActiveSheet();
    }
    
    private $startMonth, $endMonth, $getStyle, $startColumnMergeFirstRow, $spreadsheet, $sheet, $colEx, $colExLoanInfor, $colExFeeTable, $colExValue;
    
    public function summaryTotal() {
        $this->data["pageName"] = "Form tổng theo dõi";
        $this->data['template'] = 'web/accounting_system/summary_total/index';
        $res = $this->api->apiPost($this->user['token'], "accountingSystem/summary_total");
        $this->data['data'] = $res->data;
        $this->load->view('template', isset($this->data) ? $this->data:NULL);
    }
    
//    public function reportExpire($codeContract="") {
//        $this->data["pageName"] = "Lãi+ phí phải thu khách hàng từ thời điểm vay đến thời điểm đáo hạn";
//        $this->data['template'] = 'web/accounting_system/report_expire/index';
//        $res = $this->api->apiPost($this->user['token'], "accountingSystem/report_expire", array("code_contract"=>$codeContract));
//        $this->data['data'] = $res->data;
//        $this->load->view('template', isset($this->data) ? $this->data:NULL);
//    }
    
    public function payInvestor() {
        $data = $this->input->post();
        if(empty($data['plan_id']) || empty($data['resource_pay']) || empty($data['date_pay']) || empty($data['amount_interest_paid']) || empty($data['amount_root_paid'])) {
            $this->pushJson('200', json_encode(array(
                "status" => "201", 
                "message" => "Dữ liệu không thể để trống"
            )));
            return;
        }
        $data['plan_id'] = $this->security->xss_clean($data['plan_id']);
        $data['resource_pay'] = $this->security->xss_clean($data['resource_pay']);
        $data['date_pay'] = $this->security->xss_clean($data['date_pay']);
        $data['amount_interest_paid'] = $this->security->xss_clean($data['amount_interest_paid']);
        $data['amount_root_paid'] = $this->security->xss_clean($data['amount_root_paid']);
        //Call API
        $post = array(
            'plan_id' => $data['plan_id'],
            'resource_pay' => $data['resource_pay'],
            'date_pay' => $data['date_pay'],
            'amount_interest_paid' => $data['amount_interest_paid'],
            'amount_root_paid' => $data['amount_root_paid']
        );
        $res = $this->api->apiPost($this->user['token'], "accountingSystem/pay_investor", $post);
        $this->pushJson('200', json_encode(array("code" => "200", "message" => $res->data)));
    }
    
    public function searchSummaryTotal() {
        $start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
        $end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
        if(strtotime($start) > strtotime($end)){
            $this->session->set_flashdata('error', "Ngày bắt đầu phải nhỏ hơn ngày kết thúc");
            redirect(base_url('accountingSystem/summaryTotal'));
        }
        $data = array();
        if(!empty($start)) $data['start'] = $start;
        if(!empty($end)) $data['end'] = $end;
        $contractData = $this->api->apiPost($this->userInfo['token'], "accountingSystem/search_summary_total", $data);
        if(!empty($contractData->status) && $contractData->status == 200){
            $this->data['data'] = $contractData->data;
        }else{
            $this->data['data'] = array();
        }
        $this->data["pageName"] = "Form tổng theo dõi";
        $this->data['template'] = 'web/accounting_system/summary_total/index';
        $this->load->view('template', isset($this->data) ? $this->data:NULL);
    }
    
    public function export() {
        $start = !empty($_GET['fdate_export']) ? $_GET['fdate_export'] : "";
        $end = !empty($_GET['tdate_export']) ? $_GET['tdate_export'] : "";
        if(!empty($start) && !empty($end) && strtotime($start) > strtotime($end)){
            $this->session->set_flashdata('error_excel', "Tháng bắt đầu phải nhỏ hơn tháng kết thúc");
            redirect(base_url('accountingSystem/summaryTotal'));
        }
//        if(!empty($start) && !empty($end) && strtotime($start) == strtotime($end)){
//            $this->session->set_flashdata('error_excel', "Tháng kết thúc phải lớn hơn tháng bắt đầu");
//            redirect(base_url('accountingSystem/summaryTotal'));
//        }
        
        if(empty($start) || empty($end)){
            $this->session->set_flashdata('error_excel', "Chọn tháng bắt đầu và tháng kết thúc");
            redirect(base_url('accountingSystem/summaryTotal'));
        }
        
        $data = array();
        if(!empty($start)) $data['start'] = $start;
        if(!empty($end)) $data['end'] = $end;
        $contractData = $this->api->apiPost($this->userInfo['token'], "accountingSystem/export_summary_total", $data);
        
        //Calculate to export excel
        if(!empty($contractData->data)) {
            $this->startMonth = $start;
            $this->endMonth = $end;
            $this->doExport($contractData->data);
        } else {
            $this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
            redirect(base_url('accountingSystem/summaryTotal'));
        }
    }
    
    private function doExport($contracts) {
        //Thông tin khoản vay
        $this->getExcelLoanInfor($contracts);
        //Bảng phí
        $this->getExcelFee($contracts);
        //Lãi+ phí phải thu khách hàng từ thời điểm vay đến thời điểm đáo hạn
        $this->getExcelFeeInterestToExpire($contracts);
        //Lãi + phí tính đến thời điểm cuối mỗi tháng T
        $this->getExcelEndMonthT($contracts);
        //Thu hồi khoản vay
        $this->getExcelRevokeLoan($contracts);
        //Thanh toán lãi và gốc cho NĐT
        $this->getExcelPayInvestor($contracts, 8);
        //Thông tin khách hàng
        $this->getExcelCustomerInfor($contracts);
        //Thông tin NĐT
        $this->getExcelInvestorInfor($contracts);
        //---------------------------------------------------------------------
        $this->callLibExcel('data-summary-'.time().'.xlsx');
    }
    
    private function getExcelLoanInfor($contracts) {
        $this->colExLoanInfor = 18;
        $this->startColumnMergeFirstRow = $this->startColumnMergeFirstRow + 18;
        $this->sheet->mergeCells("A1:R1");
        $this->sheet->setCellValue('A1', 'Thông tin hợp đồng vay');
        $this->sheet->setCellValue('A2', 'STT');
        $this->sheet->setCellValue('B2', 'Mã giao dịch');
        $this->sheet->setCellValue('C2', 'Mã Hợp đồng vay');
        $this->sheet->setCellValue('D2', 'Thời hạn vay (ngày)');
        $this->sheet->setCellValue('E2', 'Ngày giải ngân');
        $this->sheet->setCellValue('F2', 'Ngày đáo hạn');
        $this->sheet->setCellValue('G2', 'Tên người vay');
        $this->sheet->setCellValue('H2', 'Mã người vay ( trùng CMT)');
        $this->sheet->setCellValue('I2', 'Tên nhà đầu tư');
        $this->sheet->setCellValue('J2', 'Mã NĐT');
        $this->sheet->setCellValue('K2', 'Phòng giao dịch giải ngân');
        $this->sheet->setCellValue('L2', 'Hình thức cầm cố');
        $this->sheet->setCellValue('M2', 'Số tiền giải ngân');
        $this->sheet->setCellValue('N2', 'Số tiền gia hạn');
        $this->sheet->setCellValue('O2', 'Tổng giải ngân lũy kế');
        $this->sheet->setCellValue('P2', 'Tổng Volume lũy kế');
        $this->sheet->setCellValue('Q2', 'Mã phụ lục gia hạn');
        $this->sheet->setCellValue('R2', 'Hình thức trả');
        
        //Set style
        $this->setStyle("A1:R1");
        
        $i = 4;
        $index = 1;
        $totalDisburseAccumulated = 0; // Tổng giải ngân lũy kế
        $totalVolumeAccumulated = 0; // Tổng volume lũy kế
        foreach($contracts as $item){
            //Số tiền giải ngân
            $amount = 0;
            if(empty($item->count_extend)) {
                $amount = !empty($item->receiver_infor->amount) ? $item->receiver_infor->amount : 0;
            }
            $amountExtend = !empty($item->amount_extend) ? $item->amount_extend : 0;
            $this->sheet->setCellValue('A'.$i, $index);
            $index++;
            $codeTransaction = "";
            if(!empty($item->investor_code) && $item->investor_code == 'vimo' && $item->status_create_withdrawal == 'success') {
                $codeTransaction = $item->response_get_transaction_withdrawal_status->withdrawal_transaction_id;
            }
            $this->sheet->setCellValue('B'.$i, $codeTransaction); 
            $this->sheet->setCellValue('C'.$i, !empty($item->code_contract) ? $item->code_contract : ""); 
            $this->sheet->setCellValue('D'.$i, $item->loan_infor->number_day_loan); 
            $this->sheet->setCellValue('E'.$i, !empty($item->disbursement_date) ? $this->time_model->convertTimestampToDatetime($item->disbursement_date) : ""); 
            $this->sheet->setCellValue('F'.$i, !empty($item->expire_date) ? $this->time_model->convertTimestampToDatetime($item->expire_date) : "");
            $this->sheet->setCellValue('G'.$i, $item->customer_infor->customer_name);
            $this->sheet->setCellValue('H'.$i, $item->customer_infor->customer_identify);
            $this->sheet->setCellValue('I'.$i, !empty($item->investor_infor->name) ? $item->investor_infor->name : "");
            $this->sheet->setCellValue('J'.$i, !empty($item->investor_infor->code) ? $item->investor_infor->code : "");
            $this->sheet->setCellValue('K'.$i, !empty($item->store->name) ? $item->store->name : "");
            $this->sheet->setCellValue('L'.$i, !empty($item->loan_infor) && !empty($item->loan_infor->type_loan->code) && !empty($item->loan_infor->type_property->code) ? $item->loan_infor->type_loan->code.'-'.$item->loan_infor->type_property->code : "");
            
            $this->sheet->setCellValue('M'.$i, $amount);
            $this->sheet->setCellValue('N'.$i, $amountExtend);
            //Tổng giải ngân lũy kế
            $totalDisburseAccumulated = $totalDisburseAccumulated + $amount;
            $this->sheet->setCellValue('O'.$i, $totalDisburseAccumulated);
            //Tổng Volume lũy kế
            $totalVolumeAccumulated = $totalVolumeAccumulated + $amount + $amountExtend;
            $this->sheet->setCellValue('P'.$i, $totalVolumeAccumulated);
            $this->sheet->setCellValue('Q'.$i, !empty($item->code_contract_extend) ? $item->code_contract_extend : "");
            //Hình thức trả
            $typePay = "";
            $type_interest = !empty($item->loan_infor->type_interest) ? $item->loan_infor->type_interest: "";
            if($type_interest == 1){
                $typePay = "Lãi hàng tháng, gốc hàng tháng";
            }else{
                $typePay = "Lãi hàng tháng, gốc cuối kỳ";
            }
            $this->sheet->setCellValue('R'.$i, $typePay);
            $i++;
        }
    }
    
    private function getExcelFee($contracts) {
        $this->colExFeeTable = 9;
        $this->startColumnMergeFirstRow = $this->startColumnMergeFirstRow + 9;
        $this->sheet->mergeCells('S1:AA1');
        $this->sheet->setCellValue('S1', 'Biểu phí');
        $this->sheet->setCellValue('S2', '% lãi vay/tháng');
        $this->sheet->setCellValue('T2', '% phí tư vấn/tháng');
        $this->sheet->setCellValue('U2', '% phí thẩm định, quản lý ');
        $this->sheet->setCellValue('V2', '% Phí trả chậm');
        $this->sheet->setCellValue('W2', 'Số tiền phí trả chậm');
        $this->sheet->setCellValue('X2', '% Phí trả trước 1/3 thời hạn vay');
        $this->sheet->setCellValue('Y2', '% Phí trả trước 2/3 thời hạn vay');
        $this->sheet->setCellValue('Z2', '% Phí trả trước trong các TH còn lại');
        $this->sheet->setCellValue('AA2', 'Phí gia hạn khoản vay');
        
        //Set style
        $this->setStyle("S1:AA1");
        
        $i = 4;
        foreach($contracts as $contract){
            //$this->sheet->setCellValue('S'.$i, !empty($contract->fee->percent_interest_investor) ? $contract->fee->percent_interest_investor : 0); 
            $this->sheet->setCellValue('S'.$i, !empty($contract->fee->percent_interest_customer) ? $contract->fee->percent_interest_customer : 0);
            $this->sheet->setCellValue('T'.$i, !empty($contract->fee->percent_advisory) ? (string)$contract->fee->percent_advisory : 0); 
            $this->sheet->setCellValue('U'.$i, !empty($contract->fee->percent_expertise) ? $contract->fee->percent_expertise : 0); 
            $this->sheet->setCellValue('V'.$i, !empty($contract->fee->penalty_percent) ? $contract->fee->penalty_percent : 0); 
            $this->sheet->setCellValue('W'.$i, !empty($contract->fee->penalty_amount) ? formatNumber($contract->fee->penalty_amount) : 0); 
            $this->sheet->setCellValue('X'.$i, !empty($contract->fee->percent_prepay_phase_1) ? $contract->fee->percent_prepay_phase_1 : 0); 
            $this->sheet->setCellValue('Y'.$i, !empty($contract->fee->percent_prepay_phase_2) ? $contract->fee->percent_prepay_phase_2 : 0); 
            $this->sheet->setCellValue('Z'.$i, !empty($contract->fee->percent_prepay_phase_3) ? $contract->fee->percent_prepay_phase_3 : 0); 
            $this->sheet->setCellValue('AA'.$i, !empty($contract->fee->extend) ? formatNumber($contract->fee->extend) : 0); 
            $i++;
        }
    }
    
    private function getExcelFeeInterestToExpire($contracts) {
        $rowMerge = 2;
        $rowTitle = 3;
        $step = 8;
        $rowValue = 4;
        $this->colEx = $this->colExFeeTable + $this->colExLoanInfor;
        $this->colExValue = $this->colExFeeTable + $this->colExLoanInfor;
        
        //Step 1: Tổng hợp các kỳ vào biến $month
        $dataMonth = $this->getDataMonth($contracts);
        
        $startMegeFirstColumn = $this->colExValue + 1;
        
        //Step 2: For biến $month
        foreach($dataMonth as $key=>$value1) {
            //1. cột tăng lên 9 ( khi hết 1 vòng for )
            //2. init lại hàng ( khi hết 1 vòng for )
            $this->startColumnMergeFirstRow = $this->startColumnMergeFirstRow + $step;
            //Merge cell
            $this->sheet->mergeCells($this->cellsToMergeByColsRow($this->colEx + 1, $this->colEx + $step, $rowMerge));
            $this->sheet->setCellValueByColumnAndRow($this->colEx + 1, $rowMerge, $key); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Gốc phải thu mỗi tháng'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Lãi vay phải trả NĐT'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Phí tư vấn quản lý'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Phí thẩm định và lưu trữ tài sản đảm bảo'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Phí trả chậm'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Phí trả trước'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Phí gia hạn khoản vay'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Tổng phải thu lãi, gốc tháng T'); $this->colEx++;
            //Foreach các kỳ trong 1 tháng : cột giữ nguyên, hàng tăng lên 1 ( khi hết 1 vòng for)
            foreach($value1 as $value) {
                $rowValue_ = $rowValue;
                foreach($contracts as $contract) {
                    $amountCalculate = !empty($contract->amount_extend) ? $contract->amount_extend : $contract->receiver_infor->amount;
                    //$feeInvestor = !empty($contract->fee) && !empty($contract->fee->percent_interest_investor) ? $contract->fee->percent_interest_investor : 0;
                    $feeInvestor = !empty($contract->fee) && !empty($contract->fee->percent_interest_customer) ? $contract->fee->percent_interest_customer : 0;
                    $feeAdvisory = !empty($contract->fee) && !empty($contract->fee->percent_advisory) ? $contract->fee->percent_advisory : 0;
                    $feeExpertise = !empty($contract->fee) && !empty($contract->fee->percent_expertise) ? $contract->fee->percent_expertise : 0;
                    if($value->code_contract == $contract->code_contract) {
                        $amountFeeDelayPay = !empty($value->fee_delay_pay) ? $value->fee_delay_pay : 0;
                        //$total37 = $total37 + $amountFeeDelayPay;
                        $amountFeePrePay = !empty($value->fee_prepay) ? $value->fee_prepay : 0;
                        //$total38 = $total38 + $amountFeePrePay;
                        $amountFeeExtend = !empty($value->fee_extend) ? $value->fee_extend : 0;
                        //$total39 = $total39 + $amountFeeExtend;
                        //Start
                        $amountFeeInvestor = $this->getLaiVayPhaiTraNDT_nodevice($amountCalculate, $feeInvestor);
                        //$total41 = $total41 + $amountFeeInvestor;
                        //End
                        //Start
                        $amountFeeAdvisory = $this->getLaiVayPhaiTraNDT_nodevice($amountCalculate, $feeAdvisory);
                        //$total35 = $total35 + $amountFeeAdvisory;
                        //End
                        //Start
                        $amountFeeExpertise = $this->getLaiVayPhaiTraNDT_nodevice($amountCalculate, $feeExpertise);
                        //$total36 = $total36 + $amountFeeExpertise;
                        //End
                        $total40 = $value->tien_goc_1thang + $amountFeeInvestor + $amountFeeAdvisory + $amountFeeExpertise + $amountFeeDelayPay + $amountFeePrePay + $amountFeeExtend;
                        //End fill title

                        //$total42 = $total35 + $total36 + $total37 + $total38 + $total39;
                        //$total43 = $amountCalculate + $total41 + $total42;
                        
                        //Start fill value
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 1, $rowValue_, $value->tien_goc_1thang); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 2, $rowValue_, $amountFeeInvestor); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 3, $rowValue_, $amountFeeAdvisory);
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 4, $rowValue_, $amountFeeExpertise); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 5, $rowValue_, $amountFeeDelayPay); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 6, $rowValue_, $amountFeePrePay); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 7, $rowValue_, $amountFeeExtend); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 8, $rowValue_, $total40);
                    } else {
                        $rowValue_++;
                    }
                }
                //$rowValue++;
            }
            $this->colExValue = $this->colExValue + 9;
            //$rowValue = 4;
        }
        
        $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Tổng phải thu lãi NĐT từ khi  giải ngân đến thời điểm đáo hạn'); $this->colEx++;
        $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Tổng phải thu phí TCV từ khi  giải ngân đến thời điểm đáo hạn'); $this->colEx++;
        $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Tổng phải thu (gốc và lãi, phí) từ khi  giải ngân đến thời điểm đáo hạn'); $this->colEx++;
        
        //$rowValue = 4;
        $total414243 = $this->getTotal414243($contracts);
        
        //hàng tăng 1
        foreach($total414243 as $key=>$value) {
            //Tổng phải thu lãi NĐT từ khi  giải ngân đến thời điểm đáo hạn
            $this->sheet->setCellValueByColumnAndRow($this->colExValue + 0, $rowValue, $value['total41']); 
            //Tổng phải thu phí TCV từ khi  giải ngân đến thời điểm đáo hạn
            $this->sheet->setCellValueByColumnAndRow($this->colExValue + 1, $rowValue, $value['total42']);
            //Tổng phải thu (gốc và lãi, phí) từ khi  giải ngân đến thời điểm đáo hạn
            $this->sheet->setCellValueByColumnAndRow($this->colExValue + 2, $rowValue, $value['total43']);
            $rowValue++;
        }
        $this->colExValue = $this->colExValue + 3;
        $this->startColumnMergeFirstRow = $this->startColumnMergeFirstRow + 6;
        
        //Merge cell
        $this->sheet->mergeCells($this->cellsToMergeByColsRow($startMegeFirstColumn, $this->startColumnMergeFirstRow, 1));
        $this->sheet->setCellValueByColumnAndRow($startMegeFirstColumn, 1, "Lãi+ phí phải thu khách hàng từ thời điểm vay đến thời điểm đáo hạn");
        
        $this->sheet->getCellByColumnAndRow($startMegeFirstColumn,1)->getStyle()->applyFromArray($this->getStyle)->getAlignment()->setHorizontal('center');
    }
    
    private function getLaiVayPhaiTraNDT_nodevice($amountCalculate, $fee) {
        $amountFeeInvestor = 0;
        if($fee > 0) {
            $amountFeeInvestor = $amountCalculate * $fee / 100;
        }
        return $amountFeeInvestor;
    }
    
    private function pushJson($code, $data) {
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($code)
            ->set_output($data);
    }
    
    private function getDataMonth($contracts) {
        $data = array();
        $start    = (new DateTime($this->startMonth))->modify('first day of this month');
        $end      = (new DateTime($this->endMonth))->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $period   = new DatePeriod($start, $interval, $end);
        foreach ($period as $dt) {
            $format = $dt->format("m/Y"); // 01/2020
            $data[$format] = array();
            foreach($contracts as $contract) {
                foreach($contract->plan_contract as $plan) {
                    if($format == $plan->time) {
                        array_push($data[$format], $plan);
                    }
                }
            }
            //Unset month if no have plan
            if(count($data[$format]) == 0) unset($data[$format]);
        }
        
//        echo"<pre>";
//        var_dump($data);
//        die;
        
        return $data;
    }
    
    private function cellsToMergeByColsRow($start = -1, $end = -1, $row = -1){
        $merge = 'A1:A1';
        if($start>=0 && $end>=0 && $row>=0){
            $start = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($start);
            $end = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($end);
            $merge = "$start{$row}:$end{$row}";
        }
        return $merge;
    }
    
    private function getTotal414243($contracts) {
        $arr = array();
        
//        echo"<pre>";
//        var_dump($contracts);
//        die;
        
        //$contracts->code_contract = "HĐCC/ĐKXM/HN42TB/2002/19";
        
        foreach($contracts as $contract) {
            $arr[$contract->code_contract] = array();
            
            $arr[$contract->code_contract]['total35'] = 0;
            $arr[$contract->code_contract]['total36'] = 0;
            $arr[$contract->code_contract]['total37'] = 0;
            $arr[$contract->code_contract]['total38'] = 0;
            $arr[$contract->code_contract]['total39'] = 0;
            $arr[$contract->code_contract]['total40'] = 0;
            $arr[$contract->code_contract]['total41'] = 0;
            $arr[$contract->code_contract]['total42'] = 0;
            $arr[$contract->code_contract]['total43'] = 0;
            $arr[$contract->code_contract]['total45'] = 0;
            $arr[$contract->code_contract]['total47'] = 0;
            $arr[$contract->code_contract]['total48'] = 0;
            $arr[$contract->code_contract]['total49'] = 0;
            $arr[$contract->code_contract]['total50'] = 0;
            $arr[$contract->code_contract]['total51'] = 0;
            $arr[$contract->code_contract]['total52'] = 0;
            
            $amountCalculate = !empty($contract->amount_extend) ? $contract->amount_extend : $contract->receiver_infor->amount;
            //$feeInvestor = !empty($contract->fee) && !empty($contract->fee->percent_interest_investor) ? $contract->fee->percent_interest_investor : 0;
            $feeInvestor = !empty($contract->fee) && !empty($contract->fee->percent_interest_customer) ? $contract->fee->percent_interest_customer : 0;
            $feeAdvisory = !empty($contract->fee) && !empty($contract->fee->percent_advisory) ? $contract->fee->percent_advisory : 0;
            $feeExpertise = !empty($contract->fee) && !empty($contract->fee->percent_expertise) ? $contract->fee->percent_expertise : 0;
            $type_interest = !empty($contract->loan_infor->type_interest) ? $contract->loan_infor->type_interest: "";
            
            foreach($contract->plan_contract as $planContract) {
                //Start
                //$feeInvestor = !empty($contract->fee) ? $contract->fee->percent_interest_investor : 0;
                $amountFeeInvestor = $feeInvestor > 0 ? $amountCalculate * $feeInvestor / 100 : 0;
                $arr[$contract->code_contract]['total41'] = $arr[$contract->code_contract]['total41'] + $amountFeeInvestor;
                //End
                
                //Start
                //$feeAdvisory = !empty($contract->fee->percent_advisory) ? $contract->fee->percent_advisory: 0;
                $amountFeeAdvisory = $amountCalculate * $feeAdvisory / 100;
                $arr[$contract->code_contract]['total35'] = $arr[$contract->code_contract]['total35'] + $amountFeeAdvisory;
                //End
                
                //Start
                //$feeExpertise = !empty($contract->fee->percent_expertise) ? $contract->fee->percent_expertise : 0;
                $amountFeeExpertise = $amountCalculate * $feeExpertise / 100;
                $arr[$contract->code_contract]['total36'] = $arr[$contract->code_contract]['total36'] + $amountFeeExpertise;
                //End
                
                //Start
                $amountFeeDelayPay = !empty($contract->fee_delay_pay) ? $contract->fee_delay_pay : 0;
                $arr[$contract->code_contract]['total37'] = $arr[$contract->code_contract]['total37'] + $amountFeeDelayPay;
                //End
                
                //Start
                $amountFeePrePay = !empty($planContract->fee_prepay) ? $planContract->fee_prepay : 0;
                $arr[$contract->code_contract]['total38'] = $arr[$contract->code_contract]['total38'] + $amountFeePrePay;
                //End
                
                //Start
                $amountFeeExtend = !empty($planContract->fee_extend) ? $planContract->fee_extend : 0;
                $arr[$contract->code_contract]['total39'] = $arr[$contract->code_contract]['total39'] + $amountFeeExtend;
                //End
                
                //Start
                $calLaivayphaitraNDT = $planContract->tien_goc_1thang + $planContract->tien_goc_con_thang;
                $total45 = getLaiVayPhaiTraNDT($type_interest, $amountCalculate, $feeInvestor, $calLaivayphaitraNDT, $planContract->count_date_interest);
                $arr[$contract->code_contract]['total45'] = $arr[$contract->code_contract]['total45'] + $total45;
                //End
                
                //Start
                $amountFeeAdvisory_end_month = $amountCalculate * $feeAdvisory / 100;
                $amountFeeAdvisory_end_month = $amountFeeAdvisory_end_month / 30 * $planContract->count_date_interest;
                $arr[$contract->code_contract]['total47'] = $arr[$contract->code_contract]['total47'] + $amountFeeAdvisory_end_month;
                //End
                
                //Start
                $amountFeeExpertise_end_month = $amountCalculate * $feeExpertise / 100;
                $amountFeeExpertise_end_month = $amountFeeExpertise_end_month / 30 * $planContract->count_date_interest;
                $arr[$contract->code_contract]['total48'] = $arr[$contract->code_contract]['total48'] + $amountFeeExpertise_end_month;
                //End
                
                //Start
                $amountFeeDelayPay_end_month = !empty($planContract->fee_delay_pay) ? $planContract->fee_delay_pay : 0;
                $arr[$contract->code_contract]['total49'] = $arr[$contract->code_contract]['total49'] + $amountFeeDelayPay_end_month;
                //End
                
                //Start
                $amountFeePrePay_end_month = !empty($planContract->fee_prepay) ? $planContract->fee_prepay : 0;
                $arr[$contract->code_contract]['total50'] = $arr[$contract->code_contract]['total50'] + $amountFeePrePay_end_month;
                //End
                
                //Start
                $amountFeeExtend_end_month = !empty($planContract->fee_extend) ? $planContract->fee_extend : 0;
                $arr[$contract->code_contract]['total51'] = $arr[$contract->code_contract]['total51'] + $amountFeeExtend_end_month;
                //End
                
                //Start
                $total52 =  $total45 +
                            $amountFeeAdvisory_end_month +
                            $amountFeeExpertise_end_month +
                            $amountFeeDelayPay_end_month +
                            $amountFeePrePay_end_month +
                            $amountFeeExtend_end_month;
                $arr[$contract->code_contract]['total52'] = $arr[$contract->code_contract]['total52'] + $total52;
                //End
                
                //Start
                $arr[$contract->code_contract]['total42'] = $arr[$contract->code_contract]['total35'] +
                                                            $arr[$contract->code_contract]['total36'] +
                                                            $arr[$contract->code_contract]['total37'] +
                                                            $arr[$contract->code_contract]['total38'] +
                                                            $arr[$contract->code_contract]['total39'];
                //End
                
                //Start
                $arr[$contract->code_contract]['total43'] = $amountCalculate + $arr[$contract->code_contract]['total41'] + $arr[$contract->code_contract]['total42'];
                //End
            }
        }
        
//        echo"<pre>";
//        var_dump($arr);
//        die;
        
        return $arr;
    }
    
    private function getExcelEndMonthT($contracts) {
        $rowValue = 4;
        $rowMerge = 2;
        $rowTitle = 3;
        $step = 10;
        
        $startMegeFirstColumn = $this->colEx + 1;
        
        //Step 1: Tổng hợp các kỳ vào biến $month
        $dataMonth = $this->getDataMonth($contracts);
        //Step 2: For biến $month
        foreach($dataMonth as $key=>$value1) {
            //1. cột tăng lên 10 ( khi hết 1 vòng for )
            //2. init lại hàng ( khi hết 1 vòng for )
            $this->startColumnMergeFirstRow = $this->startColumnMergeFirstRow + $step;
            //Merge cell
            $this->sheet->mergeCells($this->cellsToMergeByColsRow($this->colEx + 1, $this->colEx + $step, $rowMerge));
            $this->sheet->setCellValueByColumnAndRow($this->colEx + 1, $rowMerge, $key); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Số ngày tính lãi tháng T'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Lãi vay phải trả NĐT'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Thuế TNCN phải nộp thay cho NĐT'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Phí tư vấn quản lý'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Phí thẩm định và lưu trữ tài sản đảm bảo'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Phí trả chậm'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Phí trả trước'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Phí gia hạn khoản vay'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Tổng phải thu lãi + phí tháng T'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Tổng phải thu khách hàng cuối tháng T (bao gồm gôc+ lãi)'); $this->colEx++;
            //Foreach các kỳ trong 1 tháng : cột giữ nguyên, hàng tăng lên 1 ( khi hết 1 vòng for)
            foreach($value1 as $value) {
                $rowValue_ = $rowValue;
                foreach($contracts as $contract) {
                    $type_interest = !empty($contract->loan_infor->type_interest) ? $contract->loan_infor->type_interest: "";
                    $amountCalculate = !empty($contract->amount_extend) ? $contract->amount_extend : $contract->receiver_infor->amount;
                    //$feeInvestor = !empty($contract->fee) && !empty($contract->fee->percent_interest_investor) ? $contract->fee->percent_interest_investor : 0;
                    $feeInvestor = !empty($contract->fee) && !empty($contract->fee->percent_interest_customer) ? $contract->fee->percent_interest_customer : 0;
                    $feeAdvisory = !empty($contract->fee) && !empty($contract->fee->percent_advisory) ? $contract->fee->percent_advisory : 0;
                    $feeExpertise = !empty($contract->fee) && !empty($contract->fee->percent_expertise) ? $contract->fee->percent_expertise : 0;
                    if($value->code_contract == $contract->code_contract) {
                        $calLaivayphaitraNDT = $value->tien_goc_1thang + $value->tien_goc_con_thang;
                        //$feeInvestor = !empty($contract->fee) ? $contract->fee->percent_interest_investor : 0;
                        $amountFeeInvestor = getLaiVayPhaiTraNDT($type_interest, $amountCalculate, $feeInvestor, $calLaivayphaitraNDT, $value->count_date_interest);
                        //$sumAmountFeeInvestor = $sumAmountFeeInvestor + $amountFeeInvestor;
                        
                        $tax = $amountFeeInvestor * 0.05;
                        
                        //$feeAdvisory = !empty($contract->fee->percent_advisory) ? $contract->fee->percent_advisory: 0;
                        $amountFeeAdvisory = $amountCalculate * $feeAdvisory / 100;
                        $amountFeeAdvisory = $amountFeeAdvisory / 30 * $value->count_date_interest;
                        //$total35 = $total35 + $amountFeeAdvisory;
                        
                        //$feeExpertise = !empty($contract->fee->percent_expertise) ? $contract->fee->percent_expertise : 0;
                        $amountFeeExpertise = $amountCalculate * $feeExpertise / 100;
                        $amountFeeExpertise = $amountFeeExpertise / 30 * $value->count_date_interest;
                        //$total36 = $total36 + $amountFeeExpertise;
                        
                        $amountFeeDelayPay = !empty($value->fee_delay_pay) ? $value->fee_delay_pay : 0;
                        //$total37 = $total37 + $amountFeeDelayPay;
                        
                        $amountFeePrePay = !empty($value->fee_prepay) ? $value->fee_prepay : 0;
                        //$total38 = $total38 + $amountFeePrePay;
                        
                        $amountFeeExtend = !empty($value->fee_extend) ? $value->fee_extend : 0;
                        //$total39 = $total39 + $amountFeeExtend;
                        
                        $total = $amountFeeInvestor + $amountFeeAdvisory + $amountFeeExpertise + $amountFeeDelayPay + $amountFeePrePay + $amountFeeExtend;
                        $total_1 = $total;
                        $total_2 = $total + $contract->receiver_infor->amount;
                        
                        //Start fill value
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 1, $rowValue_, $value->count_date_interest); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 2, $rowValue_, $amountFeeInvestor); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 3, $rowValue_, $tax);
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 4, $rowValue_, $amountFeeAdvisory); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 5, $rowValue_, $amountFeeExpertise); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 6, $rowValue_, $amountFeeDelayPay); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 7, $rowValue_, $amountFeePrePay); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 8, $rowValue_, $amountFeeExtend); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 9, $rowValue_, $total_1);
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 10, $rowValue_, $total_2);
                    } else {
                        $rowValue_++;
                    }
                }
                //$rowValue++;
            }
            $this->colExValue = $this->colExValue + 10 + 1;
            //$rowValue = 4;
        }
        
        //Lãi dự thu đến thời điểm đáo hạn
        //Title
        $this->sheet->mergeCells($this->cellsToMergeByColsRow($this->colEx + 1, $this->colEx + 2, $rowMerge));
        $this->sheet->setCellValueByColumnAndRow($this->colEx + 1, $rowMerge, "Lãi dự thu đến thời điểm đáo hạn	"); $this->colEx++;
        $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, "Lãi NDT dự thu đến thời điểm đáo hạn"); $this->colEx++;
        $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, "Phí dự thu đến thời điểm đáo hạn"); $this->colEx++;
        
        $total414243 = $this->getTotal414243($contracts);
        
//        echo"<pre>";
//        var_dump($total414243);
//        die; 
        
        //hàng tăng 1
        foreach($total414243 as $key=>$value) {
            //Tổng phải thu lãi NĐT từ khi  giải ngân đến thời điểm đáo hạn
            $this->sheet->setCellValueByColumnAndRow($this->colExValue + 1, $rowValue, $value['total41'] - $value['total45']); 
            //Tổng phải thu phí TCV từ khi  giải ngân đến thời điểm đáo hạn
            $this->sheet->setCellValueByColumnAndRow($this->colExValue + 2, $rowValue, $value['total42'] - $value['total52'] + $value['total45']);
            //Tổng phải thu (gốc và lãi, phí) từ khi  giải ngân đến thời điểm đáo hạn
            $rowValue++;
        }
        $this->colExValue = $this->colExValue + 2;
        $this->startColumnMergeFirstRow = $this->startColumnMergeFirstRow + 7;
        
        //Merge cell
        $this->sheet->mergeCells($this->cellsToMergeByColsRow($startMegeFirstColumn, $this->startColumnMergeFirstRow, 1));
        $this->sheet->setCellValueByColumnAndRow($startMegeFirstColumn, 1, "Lãi + phí tính đến thời điểm cuối mỗi tháng T");
       
        $this->sheet->getCellByColumnAndRow($startMegeFirstColumn,1)->getStyle()->applyFromArray($this->getStyle)->getAlignment()->setHorizontal('center');
    }
    
    private function getExcelRevokeLoan($contracts) {
        $rowValue = 4;
        $rowMerge = 2;
        $rowTitle = 3;
        $step = 7;
        $this->colExValue = $this->colExValue + 1;
        $startMegeFirstColumn = $this->colEx + 1;
        $total414243 = $this->getTotal414243($contracts);
        //Step 1: Tổng hợp các kỳ vào biến $month
        $dataMonth = $this->getDataMonth($contracts);
        //Step 2: For biến $month
        foreach($dataMonth as $key=>$value1) {
            //1. cột tăng lên 10 ( khi hết 1 vòng for )
            //2. init lại hàng ( khi hết 1 vòng for )
            $this->startColumnMergeFirstRow = $this->startColumnMergeFirstRow + $step;
            //Merge cell
            $this->sheet->mergeCells($this->cellsToMergeByColsRow($this->colEx + 1, $this->colEx + $step, $rowMerge));
            $this->sheet->setCellValueByColumnAndRow($this->colEx + 1, $rowMerge, $key); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Ngày thu hồi'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Hình thức thu hồi'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Mã GD NH/Phiếu thu'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Số tiền lãi đã thu hồi'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Số tiền gốc đã thu hồi'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Gốc còn lại cuối tháng'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Gốc còn lại tính từ tháng T+1 đến thời điểm đáo hạn '); $this->colEx++;
            //Foreach các kỳ trong 1 tháng : cột giữ nguyên, hàng tăng lên 1 ( khi hết 1 vòng for)
            foreach($value1 as $value) {
                $rowValue_ = $rowValue;
                foreach($contracts as $contract) {
                    if($value->code_contract == $contract->code_contract) {
                        $amountCalculate = !empty($contract->amount_extend) ? $contract->amount_extend : $contract->receiver_infor->amount;
                        //$feeInvestor = !empty($contract->fee) && !empty($contract->fee->percent_interest_investor) ? $contract->fee->percent_interest_investor : 0;
                        $feeInvestor = !empty($contract->fee) && !empty($contract->fee->percent_interest_customer) ? $contract->fee->percent_interest_customer : 0;
                        $amountFeeInvestor = $feeInvestor > 0 ? $amountCalculate * $feeInvestor / 100 : 0;
                        
                        $feeAdvisory = !empty($contract->fee->percent_advisory) ? $contract->fee->percent_advisory: 0;
                        $amountFeeAdvisory = $amountCalculate * $feeAdvisory / 100;
                        
                        $feeExpertise = !empty($contract->fee->percent_expertise) ? $contract->fee->percent_expertise : 0;
                        $amountFeeExpertise = $amountCalculate * $feeExpertise / 100;
                        
                        $amountFeeDelayPay = !empty($value->fee_delay_pay) ? $value->fee_delay_pay : 0;
                        $amountFeePrePay = !empty($value->fee_prepay) ? $value->fee_prepay : 0;
                        $amountFeeExtend = !empty($value->fee_extend) ? $value->fee_extend : 0;
                        
                        $total40 = $value->tien_goc_1thang + $amountFeeInvestor + $amountFeeAdvisory + $amountFeeExpertise + $amountFeeDelayPay + $amountFeePrePay + $amountFeeExtend;
                        
                        $amountInterest = !empty($value->revoke->amount_interest) ?  $value->revoke->amount_interest : 0;
                        $amountRoot = !empty($value->revoke->amount_root) ? $value->revoke->amount_root : 0;
                        
                        //Start fill value
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 1, $rowValue_, !empty($value->revoke) ? $this->time_model->convertTimestampToDatetime($value->revoke->date) : ""); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 2, $rowValue_, !empty($value->revoke) && $value->revoke->type == 1 ? "Tiên mặt" : "Bank"); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 3, $rowValue_, !empty($value->revoke) ? $value->revoke->code : "");
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 4, $rowValue_, $amountInterest); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 5, $rowValue_, $amountRoot); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 6, $rowValue_, $total40 - $amountInterest - $amountRoot); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 7, $rowValue_, $total414243[$contract->code_contract]['total43'] - $amountInterest - $amountRoot); 
                    } else {
                        $rowValue_++;
                    }
                }
                //$rowValue++;
            }
            $this->colExValue = $this->colExValue + 7 + 1;
            //$rowValue = 4;
        }
        
        //Trạng thái - Số gốc phải trả đến thời điểm đáo hạn - Số lãi phải trả đến thời điểm đáo hạn
        //Title
        $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, "Trạng thái"); $this->colEx++;
        $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, "Số gốc phải trả đến thời điểm đáo hạn"); $this->colEx++;
        $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, "Số lãi phải trả đến thời điểm đáo hạn"); $this->colEx++;
        
        foreach($contracts as $contract) {
            $amountCalculate = !empty($contract->amount_extend) ? $contract->amount_extend : $contract->receiver_infor->amount;
            $this->sheet->setCellValueByColumnAndRow($this->colExValue + 0, $rowValue, "Tất toán hoặc gia hạn"); 
            $this->sheet->setCellValueByColumnAndRow($this->colExValue + 1, $rowValue, $amountCalculate); 
            $this->sheet->setCellValueByColumnAndRow($this->colExValue + 2, $rowValue, $total414243[$contract->code_contract]['total41']); 
            $rowValue++;
        }
        
        $this->colExValue = $this->colExValue + 2;
        $this->startColumnMergeFirstRow = $this->startColumnMergeFirstRow + 7;
        
        //Merge cell
        $this->sheet->mergeCells($this->cellsToMergeByColsRow($startMegeFirstColumn, $this->startColumnMergeFirstRow, 1));
        $this->sheet->setCellValueByColumnAndRow($startMegeFirstColumn, 1, "Thu hồi khoản vay");
        
        $this->sheet->getCellByColumnAndRow($startMegeFirstColumn,1)->getStyle()->applyFromArray($this->getStyle)->getAlignment()->setHorizontal('center');
    }
    
    private function getExcelPayInvestor($contracts, $step=0) {
        $rowValue = 4;
        $rowMerge = 2;
        $rowTitle = 3;
        //$step = 8;
        $this->colExValue = $this->colExValue + 1;
        $startMegeFirstColumn = $this->colEx + 1;
        $total414243 = $this->getTotal414243($contracts);
        //Step 1: Tổng hợp các kỳ vào biến $month
        $dataMonth = $this->getDataMonth($contracts);
        //Step 2: For biến $month
        foreach($dataMonth as $key=>$value1) {
            //1. cột tăng lên step ( khi hết 1 vòng for )
            //2. init lại hàng ( khi hết 1 vòng for )
            $this->startColumnMergeFirstRow = $this->startColumnMergeFirstRow + $step;
            //Merge cell
            $this->sheet->mergeCells($this->cellsToMergeByColsRow($this->colEx + 1, $this->colEx + $step, $rowMerge));
            $this->sheet->setCellValueByColumnAndRow($this->colEx + 1, $rowMerge, $key); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Nguồn tiền trả gốc vay'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Ngày trả'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Số tiền gôc phải trả mỗi tháng'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Số tiền lãi phải trả NĐT mỗi tháng'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Số tiền lãi đã trả'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Số tiền gốc đã trả'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Số còn lại phải trả NĐT tháng T'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Số còn lại phải trả NĐt đến thời điểm đáo hạn'); $this->colEx++;
            //Foreach các kỳ trong 1 tháng : cột giữ nguyên, hàng tăng lên 1 ( khi hết 1 vòng for)
            foreach($value1 as $value) {
                $rowValue_ = $rowValue;
                foreach($contracts as $contract) {
                    if($value->code_contract == $contract->code_contract) {
                        $amountCalculate = !empty($contract->amount_extend) ? $contract->amount_extend : $contract->receiver_infor->amount;
                        $amount_interest_paid = !empty($value->pay_investor) ? $value->pay_investor->amount_interest_paid : 0;
                        $amount_root_paid = !empty($value->pay_investor) ? $value->pay_investor->amount_root_paid : 0;
                        $totalPaid = !empty($totalPaid) && $totalPaid > 0 ? $totalPaid : 0;
                        $totalPaid = $totalPaid + $amount_interest_paid + $amount_root_paid;
                        
                        //$feeInvestor = !empty($contract->fee) && !empty($contract->fee->percent_interest_investor) ? $contract->fee->percent_interest_investor : 0;
                        $feeInvestor = !empty($contract->fee) && !empty($contract->fee->percent_interest_customer) ? $contract->fee->percent_interest_customer : 0;
                        $amountFeeInvestor = $feeInvestor > 0 ? $amountCalculate * $feeInvestor / 100 : 0;
                        
                        //Start fill value
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 1, $rowValue_, !empty($value->pay_investor) ? $value->pay_investor->resource_pay : ""); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 2, $rowValue_, !empty($value->pay_investor) ? $value->pay_investor->date_pay : ""); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 3, $rowValue_, $value->tien_goc_1thang);
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 4, $rowValue_, $amountFeeInvestor); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 5, $rowValue_, $amount_interest_paid); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 6, $rowValue_, $amount_root_paid); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 7, $rowValue_, $value->tien_goc_1thang + $amountFeeInvestor - $amount_interest_paid - $amount_root_paid); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 8, $rowValue_, $amountCalculate + $total414243[$contract->code_contract]['total41'] - $totalPaid); 
                    } else {
                        $rowValue_++;
                    }
                }
                //$rowValue++;
            }
            $this->colExValue = $this->colExValue + 8 + 1;
            //$rowValue = 4;
        }
        //$this->colExValue = $this->colExValue + 2;
        $this->startColumnMergeFirstRow = $this->startColumnMergeFirstRow + 8;
        
        //Merge cell
        $this->sheet->mergeCells($this->cellsToMergeByColsRow($startMegeFirstColumn, $this->startColumnMergeFirstRow, 1));
        $this->sheet->setCellValueByColumnAndRow($startMegeFirstColumn, 1, "Thanh toán lãi và gốc cho NĐT");
        
        $this->sheet->getCellByColumnAndRow($startMegeFirstColumn,1)->getStyle()->applyFromArray($this->getStyle)->getAlignment()->setHorizontal('center');
    }
    
    private function getExcelCustomerInfor($contracts) {
        $rowValue = 4;
        $rowMerge = 2;
        $rowTitle = 3;
        $step = 8;
        //$this->colExValue = $this->colExValue + 1;
        $startMegeFirstColumn = $this->colEx;
        
        //Merge cell
        $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Địa chỉ'); $this->colEx++;
        $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Email'); $this->colEx++;
        $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'SĐT'); $this->colEx++;
        $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Ngân hàng'); $this->colEx++;
        $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Số thẻ ATM'); $this->colEx++;
        $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Tên chủ thẻ ATM'); $this->colEx++;
        $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Số TK'); $this->colEx++;
        $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Tên chủ TK'); $this->colEx++;
        
        foreach($contracts as $contract){
            $provinceName = !empty($contract->current_address->province_name) ? $contract->current_address->province_name : "";
            $districtName = !empty($contract->current_address->district_name) ? $contract->current_address->district_name : "";
            $wardName = !empty($contract->current_address->ward_name) ? $contract->current_address->ward_name : "";
            
            //Start fill value
            $this->sheet->setCellValueByColumnAndRow($this->colExValue + 0, $rowValue, $provinceName.'-'.$districtName.'-'.$wardName); 
            $this->sheet->setCellValueByColumnAndRow($this->colExValue + 1, $rowValue, !empty($contract->customer_infor->customer_email) ? $contract->customer_infor->customer_email : ""); 
            $this->sheet->setCellValueByColumnAndRow($this->colExValue + 2, $rowValue, !empty($contract->customer_infor->customer_phone_number) ? $contract->customer_infor->customer_phone_number : "");
            $this->sheet->setCellValueByColumnAndRow($this->colExValue + 3, $rowValue, !empty($contract->receiver_infor->bank_name) ? $contract->receiver_infor->bank_name : ""); 
            $this->sheet->setCellValueByColumnAndRow($this->colExValue + 4, $rowValue, !empty($contract->receiver_infor->atm_card_number) ? $contract->receiver_infor->atm_card_number : ""); 
            $this->sheet->setCellValueByColumnAndRow($this->colExValue + 5, $rowValue, !empty($contract->receiver_infor->atm_card_holder) ? $contract->receiver_infor->atm_card_holder : ""); 
            $this->sheet->setCellValueByColumnAndRow($this->colExValue + 6, $rowValue, !empty($contract->receiver_infor->bank_account) ? $contract->receiver_infor->bank_account : ""); 
            $this->sheet->setCellValueByColumnAndRow($this->colExValue + 7, $rowValue, !empty($contract->receiver_infor->bank_account_holder) ? $contract->receiver_infor->bank_account_holder : ""); 
            
            $rowValue++;
        }
        $this->colExValue = $this->colExValue + 2;
        $this->startColumnMergeFirstRow = $this->startColumnMergeFirstRow + 4;
        
        //Merge cell
        //$this->sheet->mergeCells($this->cellsToMergeByColsRow($startMegeFirstColumn, $this->startColumnMergeFirstRow, 2));
        $this->sheet->setCellValueByColumnAndRow($startMegeFirstColumn, 2, "Thông tin khách hàng vay");
        
        $this->sheet->getCellByColumnAndRow($startMegeFirstColumn, 2)->getStyle()->applyFromArray($this->getStyle)->getAlignment()->setHorizontal('center');
    }
    
    private function getExcelInvestorInfor($contracts) {
        $rowValue = 4;
        $rowMerge = 2;
        $rowTitle = 3;
        $step = 8;
        //$this->colExValue = $this->colExValue + 1;
        $startMegeFirstColumn = $this->colEx;
        
        //Merge cell
        $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Mã nhà đầu tư'); $this->colEx++;
        $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Địa chỉ'); $this->colEx++;
        $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Email'); $this->colEx++;
        $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'SĐT'); $this->colEx++;
        $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Thông tin TK trả NĐT'); $this->colEx++;
        
        foreach($contracts as $contract){
            //Start fill value
            $this->sheet->setCellValueByColumnAndRow($this->colExValue + 0, $rowValue, !empty($contract->investor_infor->code) ? $contract->investor_infor->code : ""); 
            $this->sheet->setCellValueByColumnAndRow($this->colExValue + 1, $rowValue, !empty($contract->investor_infor->address) ? $contract->investor_infor->address : ""); 
            $this->sheet->setCellValueByColumnAndRow($this->colExValue + 2, $rowValue, !empty($contract->investor_infor->email) ? $contract->investor_infor->email : "");
            $this->sheet->setCellValueByColumnAndRow($this->colExValue + 2, $rowValue, !empty($contract->investor_infor->phone) ? $contract->investor_infor->email : "");
            $this->sheet->setCellValueByColumnAndRow($this->colExValue + 3, $rowValue, !empty($contract->investor_infor->bank_ìnor) ? $contract->investor_infor->bank_ìnor : ""); 
            
            $rowValue++;
        }
        $this->colExValue = $this->colExValue + 2;
        $this->startColumnMergeFirstRow = $this->startColumnMergeFirstRow + 4 + 1;
        
        //Merge cell
        //$this->sheet->mergeCells($this->cellsToMergeByColsRow($startMegeFirstColumn, $this->startColumnMergeFirstRow, 2));
        $this->sheet->setCellValueByColumnAndRow($startMegeFirstColumn, 2, "Thông tin NĐT");
        
        $this->sheet->getCellByColumnAndRow($startMegeFirstColumn, 2)->getStyle()->applyFromArray($this->getStyle)->getAlignment()->setHorizontal('center');
    }
    
    private function getStyle() {
        
    }
    
    private function setStyle($range) {
        $styles = [ 
            'font' => 
                [ 
                    'name' => 'Arial', 
                    'bold' => false, 
                    'italic' => false, 
                    'strikethrough' => false, 
                    //'color' => [ 'rgb' => '808080' ] 
                ], 
//            'borders' => 
//                [ 
//                    'left' => 
//                        [ 
//                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM, 
//                            'color' => [ 'rgb' => '808080' ] 
//                        ], 
//                    'right' => 
//                        [ 
//                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM, 
//                            'color' => [ 'rgb' => '808080' ] 
//                        ], 
//                    'bottom' => 
//                        [ 
//                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM, 
//                            'color' => [ 'rgb' => '808080' ] 
//                        ], 
//                    'top' => 
//                        [ 
//                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM, 
//                            'color' => [ 'rgb' => '808080' ] 
//                        ] 
//                ], 
            'quotePrefix' => true 
        ] ;
        $this->getStyle = $styles;
        $this->sheet->getStyle($range)->applyFromArray($styles)->getAlignment()->setHorizontal('center');
    }
    
    public function reportContractVolume() {
        $this->data["pageName"] = "Báo cáo tổng hợp số HĐ, volume";
        $this->data['template'] = 'web/accounting_system/report_contract_volume/index';
        $this->load->view('template', isset($this->data) ? $this->data:NULL);
    }
    
    public function exportContractVolume() {
        $start = !empty($_GET['fdate_export']) ? $_GET['fdate_export'] : "";
        $end = !empty($_GET['tdate_export']) ? $_GET['tdate_export'] : "";
        if(empty($start) || empty($end)){
            $this->session->set_flashdata('error_excel_contract_volume', "Chọn ngày bắt đầu, ngày kết thúc");
            redirect(base_url('accountingSystem/reportContractVolume'));
        }
        
        if(strtotime($start) > strtotime($end)){
            $this->session->set_flashdata('error_excel_contract_volume', "Ngày bắt đầu phải nhỏ hơn ngày kết thúc");
            redirect(base_url('accountingSystem/reportContractVolume'));
        }
        $data = array();
        if(!empty($start)) $data['start'] = $start;
        if(!empty($end)) $data['end'] = $end;
        $months = $this->api->apiPost($this->userInfo['token'], "accountingSystem/export_contract_volume", $data);
        //Calculate to export excel
        if(!empty($months->data)) {
            $this->doExportContractVolume($months->data);
        } else {
            $this->session->set_flashdata('error_excel_contract_volume', "Không có dữ liệu để xuất excel");
            redirect(base_url('accountingSystem/reportContractVolume'));
        }
    }
    
    public function doExportContractVolume($data) {
        $this->sheet->setCellValue('A1', 'STT');
        $this->sheet->setCellValue('B1', 'Tháng');
        $this->sheet->setCellValue('C1', 'Phòng giao dịch');
        $this->sheet->setCellValue('D1', 'Số hợp đồng giải ngân');
        $this->sheet->setCellValue('E1', 'Tổng giải ngân');
        $this->sheet->setCellValue('F1', 'Tổng giải ngân lũy kế');
        $this->sheet->setCellValue('G1', 'Tổng thu hồi');
        $this->sheet->setCellValue('H1', 'HĐ quá hạn');
        
        $i = 2;
        $index = 1;
        foreach($data as $month=>$stores) {
            foreach($stores as $nameStore=>$infor) {
                $this->sheet->setCellValue('A'.$i, $index);
                $this->sheet->setCellValue('B'.$i, $month);
                $this->sheet->setCellValue('C'.$i, $nameStore);
                $this->sheet->setCellValue('D'.$i, $infor->count_contract_disburse);
                $this->sheet->setCellValue('E'.$i, $infor->total_disburse);
                $this->sheet->setCellValue('F'.$i, $infor->total_disburse_accumulated);
                $this->sheet->setCellValue('G'.$i, $infor->total_debt_pay);
                $this->sheet->setCellValue('H'.$i, "");
                $i++;
                $index++;
            }
        }
        
        //---------------------------------------------------------------------
        $this->callLibExcel('data-contract-volume-'.time().'.xlsx');
        
    }
    
    public function reportInterestMonth() {
        $this->data["pageName"] = "Báo cáo lãi tháng";
        $this->data['template'] = 'web/accounting_system/report_interest_month/index';
        $this->load->view('template', isset($this->data) ? $this->data:NULL);
    }
    
    public function exportInterestMonth() {
        $start = !empty($_GET['fdate_export']) ? $_GET['fdate_export'] : "";
        $end = !empty($_GET['tdate_export']) ? $_GET['tdate_export'] : "";
        if(strtotime($start) > strtotime($end)){
            $this->session->set_flashdata('error_excel', "Ngày bắt đầu phải nhỏ hơn ngày kết thúc");
            redirect(base_url('accountingSystem/reportInterestMonth'));
        }
        $data = array();
        if(!empty($start)) $data['start'] = $start;
        if(!empty($end)) $data['end'] = $end;
        $contractData = $this->api->apiPost($this->userInfo['token'], "accountingSystem/search_summary_total", $data);
        //Calculate to export excel
        if(!empty($contractData->data)) {
            $this->doExportInterestMonth($contractData->data);
        } else {
            $this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
            redirect(base_url('accountingSystem/reportInterestMonth'));
        }
    }
    
    private function doExportInterestMonth($contracts) {
        //Thông tin khoản vay
        $this->getExcelLoanInfor($contracts);
        //Bảng phí
        $this->getExcelFee($contracts);
        //Lãi+ phí phải thu khách hàng từ thời điểm vay đến thời điểm đáo hạn
        $this->getExcelFeeInterestToExpire($contracts);
        //Lãi + phí tính đến thời điểm cuối mỗi tháng T
        $this->getExcelEndMonthT($contracts);
        //---------------------------------------------------------------------
        $this->callLibExcel('data-interest-month-'.time().'.xlsx');
        
    }
    
    public function reportPublicDebtCustomer() {
        $this->data["pageName"] = "Báo cáo khách hàng";
        $this->data['template'] = 'web/accounting_system/report_public_debt_customer/index';
        $this->load->view('template', isset($this->data) ? $this->data:NULL);
    }
    
    public function exportPublicDebtCustomer() {
        $start = !empty($_GET['fdate_export']) ? $_GET['fdate_export'] : "";
        $end = !empty($_GET['tdate_export']) ? $_GET['tdate_export'] : "";
        if(strtotime($start) > strtotime($end)){
            $this->session->set_flashdata('error_excel', "Ngày bắt đầu phải nhỏ hơn ngày kết thúc");
            redirect(base_url('accountingSystem/reportPublicDebtCustomer'));
        }
        $data = array();
        if(!empty($start)) $data['start'] = $start;
        if(!empty($end)) $data['end'] = $end;
        $contractData = $this->api->apiPost($this->userInfo['token'], "accountingSystem/search_summary_total", $data);
        //Calculate to export excel
        if(!empty($contractData->data)) {
            $this->doExportPublicDebtCustomer($contractData->data);
        } else {
            $this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
            redirect(base_url('accountingSystem/reportPublicDebtCustomer'));
        }
    }
    
    private function doExportPublicDebtCustomer($contracts) {
        //Thông tin khoản vay
        $this->getExcelLoanInfor($contracts);
        //Bảng phí
        $this->getExcelFee($contracts);
        //Lãi+ phí phải thu khách hàng từ thời điểm vay đến thời điểm đáo hạn
        $this->getExcelFeeInterestToExpire($contracts);
        //Lãi + phí tính đến thời điểm cuối mỗi tháng T
        $this->getExcelEndMonthT($contracts);
        //Thu hồi khoản vay
        $this->getExcelRevokeLoan($contracts);
        //---------------------------------------------------------------------
        $this->callLibExcel('data-summary-'.time().'.xlsx');
    }
    
    private function callLibExcel($filename) {
        // Redirect output to a client's web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.
        ob_end_clean();
        $writer = IOFactory::createWriter($this->spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
    
    public function reportInvestor() {
        $this->data["pageName"] = "Báo cáo Nhà đầu tư";
        $this->data['template'] = 'web/accounting_system/report_investor/index';
        $this->load->view('template', isset($this->data) ? $this->data:NULL);
    }
    
    public function exportInvestor() {
        $start = !empty($_GET['fdate_export']) ? $_GET['fdate_export'] : "";
        $end = !empty($_GET['tdate_export']) ? $_GET['tdate_export'] : "";
        if(strtotime($start) > strtotime($end)){
            $this->session->set_flashdata('error_excel', "Ngày bắt đầu phải nhỏ hơn ngày kết thúc");
            redirect(base_url('accountingSystem/reportInvestor'));
        }
        $data = array();
        if(!empty($start)) $data['start'] = $start;
        if(!empty($end)) $data['end'] = $end;
        $contractData = $this->api->apiPost($this->userInfo['token'], "accountingSystem/search_summary_total", $data);
        //Calculate to export excel
        if(!empty($contractData->data)) {
            $this->doExportInvestor($contractData->data);
        } else {
            $this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
            redirect(base_url('accountingSystem/reportInvestor'));
        }
    }
    
    private function doExportInvestor($contracts) {
        //Thông tin khoản vay
        $this->getExcelLoanInforPayInvestor($contracts);
        //Bảng phí
        //$this->getExcelFee($contracts);
        //Lãi+ phí phải thu khách hàng từ thời điểm vay đến thời điểm đáo hạn
        //$this->getExcelFeeInterestToExpire($contracts);
        //Lãi + phí tính đến thời điểm cuối mỗi tháng T
        //$this->getExcelEndMonthT($contracts);
        
        //Thu hồi khoản vay
        //$this->getExcelRevokeLoan($contracts);
        //Thanh toán lãi và gốc cho NĐT
        $this->getExcelPayInvestor_($contracts);
        
        //Thông tin khách hàng
        //$this->getExcelCustomerInfor($contracts);
        
        //Thông tin NĐT
        //$this->getExcelInvestorInfor($contracts);
        
        //---------------------------------------------------------------------
        $this->callLibExcel('data-pay-investor-'.time().'.xlsx');
    }
    
    private function getExcelLoanInforPayInvestor($contracts) {
        $this->sheet->mergeCells("A1:L1");
        $this->sheet->setCellValue('A1', 'Thông tin hợp đồng vay');
        $this->sheet->setCellValue('A2', 'STT');
        $this->sheet->setCellValue('B2', 'Nhà đầu tư');
        $this->sheet->setCellValue('C2', 'Tên người vay');
        $this->sheet->setCellValue('D2', 'Thời hạn vay (ngày)');
        $this->sheet->setCellValue('E2', 'Ngày giải ngân');
        $this->sheet->setCellValue('F2', 'Ngày đáo hạn');
        $this->sheet->setCellValue('G2', 'Hình thức trả cho NĐT');
        $this->sheet->setCellValue('H2', 'Ngày phải trả');
        $this->sheet->setCellValue('I2', 'Số tiền cho vay');
        $this->sheet->setCellValue('J2', '% lãi vay');
        $this->sheet->setCellValue('K2', 'Số gốc phải trả đến thời điểm đáo hạn');
        $this->sheet->setCellValue('L2', 'Số lãi phải trả đến thời điểm đáo hạn');
        
        $this->startColumnMergeFirstRow = $this->startColumnMergeFirstRow + 12;
        $this->colEx = 12;
        $this->colExValue = 11;
        //Set style
        $this->setStyle("A1:L1");
        $total414243 = $this->getTotal414243($contracts);
        $i = 4;
        $index = 1;
        foreach($contracts as $item){
            $amountCalculate = !empty($item->amount_extend) ? $item->amount_extend : $item->receiver_infor->amount;
            //Số tiền giải ngân
            $amount = 0;
            if(empty($item->count_extend)) {
                $amount = !empty($item->receiver_infor->amount) ? $item->receiver_infor->amount : 0;
            }
            $this->sheet->setCellValue('A'.$i, $index);
            $index++;
            $codeTransaction = "";
            if(!empty($item->investor_code) && $item->investor_code == 'vimo' && $item->status_create_withdrawal == 'success') {
                $codeTransaction = $item->response_get_transaction_withdrawal_status->withdrawal_transaction_id;
            }
            $this->sheet->setCellValue('B'.$i, !empty($item->investor_infor->name) ? $item->investor_infor->name : ""); 
            $this->sheet->setCellValue('C'.$i, $item->customer_infor->customer_name); 
            $this->sheet->setCellValue('D'.$i, $item->loan_infor->number_day_loan); 
            $this->sheet->setCellValue('E'.$i, !empty($item->disbursement_date) ? $this->time_model->convertTimestampToDatetime($item->disbursement_date) : ""); 
            $this->sheet->setCellValue('F'.$i, !empty($item->expire_date) ? $this->time_model->convertTimestampToDatetime($item->expire_date) : "");
            //Hình thức trả
            $typePay = "";
            $type_interest = !empty($item->loan_infor->type_interest) ? $item->loan_infor->type_interest: "";
            if($type_interest == 1){
                $typePay = "Lãi hàng tháng, gốc hàng tháng";
            }else{
                $typePay = "Lãi hàng tháng, gốc cuối kỳ";
            }
            $this->sheet->setCellValue('G'.$i, $typePay);
            $this->sheet->setCellValue('H'.$i, "");
            $this->sheet->setCellValue('I'.$i, $amount);
            $this->sheet->setCellValue('J'.$i, !empty($item->fee->percent_interest_investor) ? $item->fee->percent_interest_investor : 0);
            
            $this->sheet->setCellValue('K'.$i, $amountCalculate);
            $this->sheet->setCellValue('L'.$i, $total414243[$item->code_contract]['total41']);
            
            $i++;
        }
    }
    
    private function getExcelPayInvestor_($contracts, $step=0) {
        $rowValue = 4;
        $rowMerge = 2;
        $rowTitle = 3;
        $step = 8;
        $this->colExValue = $this->colExValue + 1;
        $total414243 = $this->getTotal414243($contracts);
        //Step 1: Tổng hợp các kỳ vào biến $month
        $dataMonth = $this->getDataMonth($contracts);
        //Step 2: For biến $month
        foreach($dataMonth as $key=>$value1) {
            //1. cột tăng lên step ( khi hết 1 vòng for )
            //2. init lại hàng ( khi hết 1 vòng for )
            $this->startColumnMergeFirstRow = $this->startColumnMergeFirstRow + $step;
            //Merge cell
            $this->sheet->mergeCells($this->cellsToMergeByColsRow($this->colEx + 1, $this->colEx + $step, $rowMerge));
            $this->sheet->setCellValueByColumnAndRow($this->colEx + 1, $rowMerge, $key); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Nguồn tiền trả gốc vay'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Ngày trả'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Số tiền gôc phải trả mỗi tháng'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Số tiền lãi phải trả NĐT mỗi tháng'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Số tiền lãi đã trả'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Số tiền gốc đã trả'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Số còn lại phải trả NĐT tháng T'); $this->colEx++;
            $this->sheet->setCellValueByColumnAndRow($this->colEx, $rowTitle, 'Số còn lại phải trả NĐt đến thời điểm đáo hạn'); $this->colEx++;
            //Foreach các kỳ trong 1 tháng : cột giữ nguyên, hàng tăng lên 1 ( khi hết 1 vòng for)
            foreach($value1 as $value) {
                foreach($contracts as $contract) {
                    if($value->code_contract == $contract->code_contract) {
                        $amountCalculate = !empty($contract->amount_extend) ? $contract->amount_extend : $contract->receiver_infor->amount;
                        $amount_interest_paid = !empty($value->pay_investor) ? $value->pay_investor->amount_interest_paid : 0;
                        $amount_root_paid = !empty($value->pay_investor) ? $value->pay_investor->amount_root_paid : 0;
                        $totalPaid = !empty($totalPaid) && $totalPaid > 0 ? $totalPaid : 0;
                        $totalPaid = $totalPaid + $amount_interest_paid + $amount_root_paid;
                        
                        $feeInvestor = !empty($contract->fee) && !empty($contract->fee->percent_interest_investor) ? $contract->fee->percent_interest_investor : 0;
                        $amountFeeInvestor = $feeInvestor > 0 ? $amountCalculate * $feeInvestor / 100 : 0;
                        
                        //Start fill value
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 1, $rowValue, !empty($value->pay_investor) ? $value->pay_investor->resource_pay : ""); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 2, $rowValue, !empty($value->pay_investor) ? $value->pay_investor->date_pay : ""); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 3, $rowValue, $value->tien_goc_1thang);
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 4, $rowValue, $amountFeeInvestor); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 5, $rowValue, $amount_interest_paid); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 6, $rowValue, $amount_root_paid); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 7, $rowValue, $value->tien_goc_1thang + $amountFeeInvestor - $amount_interest_paid - $amount_root_paid); 
                        $this->sheet->setCellValueByColumnAndRow($this->colExValue + 8, $rowValue, $amountCalculate + $total414243[$contract->code_contract]['total41'] - $totalPaid); 
                    }
                }
                $rowValue++;
            }
            $this->colExValue = $this->colExValue + 8 + 1;
            $rowValue = 4;
        }
        //$this->colExValue = $this->colExValue + 2;
        $this->startColumnMergeFirstRow = $this->startColumnMergeFirstRow + 8;
        
        //Merge cell
        $this->sheet->mergeCells($this->cellsToMergeByColsRow(13, $this->startColumnMergeFirstRow, 1));
        $this->sheet->setCellValueByColumnAndRow(13, 1, "Thanh toán lãi và gốc cho NĐT");
        
        $this->sheet->getCellByColumnAndRow(13,1)->getStyle()->applyFromArray($this->getStyle)->getAlignment()->setHorizontal('center');
    }
    
}
?>

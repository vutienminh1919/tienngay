
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AccountingSystemUpdate extends MY_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        $this->load->model("store_model");
        $this->load->model("time_model");
        $this->load->model("contract_model");
        $this->load->helper('lead_helper');
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
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $this->tong_BangLaiThuc = array(
            "so_tien_vay" => 0, //N4
            "du_no_goc_thang_truoc" => 0, //P4
            "du_no_lai_thang_truoc" => 0, //Q4
            "du_no_phi_thang_truoc" => 0, //R4
            "so_ngay_tinh_lai_thang" => 0, //S4
            "lai_vay_tra_NDT" => 0, //T4
            "thue_TTCN_tra_thay_NDT" => 0, //U4
            "phi_tu_van" => 0, //V4
            "phi_tham_dinh" => 0, //W4
            "phi_gia_han_khoan_vay" => 0, //Z4
            "tong_phi" => 0, //AA4
            "so_tien_goc_da_thu_hoi" => 0, //AB4
            "so_tien_lai_NDT_da_thu_hoi" => 0, //AC4
            "so_tien_phi_da_thu_hoi" => 0, //AD4
            "so_tien_goc_con_lai" => 0, //AE4
            "so_tien_lai_NDT_con_lai" => 0, //AF4
            "so_tien_phi_con_lai" => 0, //AG4
        );
        $this->numberRowLastColumn = 0;
    }
    
    private $tong_BangLaiThuc, $numberRowLastColumn;
    
    private $startMonth, $endMonth, $getStyle, $startColumnMergeFirstRow, $spreadsheet, $sheet, $colEx, $colExLoanInfor, $colExFeeTable, $colExValue;
    
    //Giải ngân
    public function disburse() {
        $this->data["pageName"] = "Giải ngân";
        $this->data['template'] = 'web/accounting_system_update/disburse';
        $this->load->view('template', isset($this->data) ? $this->data:NULL);
    }
    
    public function doDisburse() {
        $start = !empty($_GET['fdate_export']) ? $_GET['fdate_export'] : "";
        $end = !empty($_GET['tdate_export']) ? $_GET['tdate_export'] : "";
        $data = array();
        if(!empty($start)) $data['start'] = $start;
        if(!empty($end)) $data['end'] = $end;
        
        $contractData = $this->api->apiPost($this->userInfo['token'], "accountingSystemUpdate/disburse", $data);
        
        //Calculate to export excel
        if(!empty($contractData->data)) {
            $this->exportDisburse($contractData->data,$start,$end);
        } else {
            $this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
            redirect(base_url('accountingSystemUpdate/disburse'));
        }
    }
    
    public function exportDisburse($contracts,$start,$end) {
        $this->sheet->setCellValue('A1', 'Mã phiếu ghi');
        $this->sheet->setCellValue('B1', 'Mã giao dịch');
        $this->sheet->setCellValue('C1', 'Mã Hợp đồng vay');
        $this->sheet->setCellValue('D1', 'Thời hạn vay (ngày)');
        $this->sheet->setCellValue('E1', 'Ngày giải ngân');
        $this->sheet->setCellValue('F1', 'Ngày đáo hạn');
        $this->sheet->setCellValue('G1', 'Tên người vay');
        $this->sheet->setCellValue('H1', 'Mã người vay ( trùng CMT)');
        $this->sheet->setCellValue('I1', 'Tên nhà đầu tư');
        $this->sheet->setCellValue('J1', 'Mã NĐT');
        $this->sheet->setCellValue('K1', 'Phòng giao dịch giải ngân');
        $this->sheet->setCellValue('L1', 'Hình thức cầm cố');
        $this->sheet->setCellValue('M1', 'Tiền vay');
        $this->sheet->setCellValue('N1', 'Tiền bảo hiểm');
        $this->sheet->setCellValue('O1', 'Tiền thực nhận');
        $this->sheet->setCellValue('P1', 'Hình thức lãi');
        $this->sheet->setCellValue('Q1', 'Số TK giải ngân');
        $this->sheet->setCellValue('R1', 'Tên chủ TK');
        $this->sheet->setCellValue('S1', 'Ngân hàng');
        $this->sheet->setCellValue('T1', 'Chi nhánh');
        $this->sheet->setCellValue('U1', 'Trạng thái');
        $this->sheet->setCellValue('V1', 'Nội dung giải ngân');
        $this->sheet->setCellValue('W1', 'Mã GD ngân hàng');
        
        $i = 2;
        foreach($contracts as $item) {
            //Hình thức lãi
            $typePay = "";
            $type_interest = !empty($item->loan_infor->type_interest) ? $item->loan_infor->type_interest: "";
            if($type_interest == 1){
                $typePay = "Lãi hàng tháng, gốc hàng tháng";
            }else{
                $typePay = "Lãi hàng tháng, gốc cuối kỳ";
            }
            //Số tiền giải ngân
            $amount = 0;
            if(empty($item->count_extend)) {
                $amount = !empty($item->loan_infor->amount_money) ? $item->loan_infor->amount_money : 0;

            }
            $amount_thucnhan = !empty($item->loan_infor->amount_loan) ? $item->loan_infor->amount_loan : 0;
            $amount_bh = $amount-$amount_thucnhan;
            
            $this->sheet->setCellValue('A'.$i,$item->code_contract); 
            $this->sheet->setCellValue('B'.$i, $this->getCodeTransaction($item)); 
            $this->sheet->setCellValue('C'.$i, $this->contract_model->getMaHopDongVay($item)); 
            $this->sheet->setCellValue('D'.$i, $item->debt->thoi_han_vay); 
            $this->sheet->setCellValue('E'.$i, !empty($item->disbursement_date) ? $this->time_model->convertTimestampToDatetime_($item->disbursement_date) : ""); 
            $this->sheet->setCellValue('F'.$i, !empty($item->expire_date) ? $this->time_model->convertTimestampToDatetime_($item->expire_date) : "");
            $this->sheet->setCellValue('G'.$i, $item->customer_infor->customer_name);
            $this->sheet->setCellValue('H'.$i, $item->customer_infor->customer_identify);
            $this->sheet->setCellValue('I'.$i, !empty($item->investor_infor->name) ? $item->investor_infor->name : "");
            $this->sheet->setCellValue('J'.$i, !empty($item->investor_infor->code) ? $item->investor_infor->code : "");
            $this->sheet->setCellValue('K'.$i, !empty($item->store->name) ? $item->store->name : "");
            $this->sheet->setCellValue('L'.$i, !empty($item->loan_infor) && !empty($item->loan_infor->type_loan->code) && !empty($item->loan_infor->type_property->code) ? $item->loan_infor->type_loan->code.'-'.$item->loan_infor->type_property->code : "");
            $this->sheet->setCellValue('M'.$i, $amount);
            $this->sheet->setCellValue('N'.$i, $amount_bh);
            $this->sheet->setCellValue('O'.$i, $amount_thucnhan);
            $this->sheet->setCellValue('P'.$i, $typePay);
            //Thông tin giải ngân
            $this->sheet->setCellValue('Q'.$i, !empty($item->receiver_infor->atm_card_number) ? $item->receiver_infor->atm_card_number : $item->receiver_infor->bank_account);
            $this->sheet->setCellValue('R'.$i, !empty($item->receiver_infor->atm_card_holder) ? $item->receiver_infor->atm_card_holder : $item->receiver_infor->bank_account_holder);
            $this->sheet->setCellValue('S'.$i, !empty($item->receiver_infor->bank_name) ? $item->receiver_infor->bank_name : "");
            $this->sheet->setCellValue('T'.$i, !empty($item->receiver_infor->bank_branch) ? $item->receiver_infor->bank_branch : "");
            $endMonth = strtotime(date('Y-m-t', strtotime($start)).' 23:59:59'); 
            $condition=[
                'code_contract'=>$item->code_contract,
                'status'=>1,
                'type'=>3,
                'date_pay'=> array(
                '$lte' => $endMonth
            )
            ];
            $this->sheet->setCellValue('U'.$i, $this->contract_model->getStatusContract($condition));
            $this->sheet->setCellValue('V'.$i, !empty($item->content_transfer_disbursement) ? $item->content_transfer_disbursement : ""); 
            $this->sheet->setCellValue('W'.$i, !empty($item->code_transaction_bank_disbursement) ? $item->code_transaction_bank_disbursement : ""); 
            $i++;
        }
        //---------------------------------------------------------------------
        $this->callLibExcel('bao-cao-giai-ngan-'.date('d-m-Y-H:i:s-').$start.'_'.$end.'.xlsx');
    }
    
    //Bảng lãi thực
    public function interestReal() {
        $this->data["pageName"] = "Bảng lãi thực";
        $this->data['template'] = 'web/accounting_system_update/interest_real';
        $this->load->view('template', isset($this->data) ? $this->data:NULL);
    }
    
    public function doInterestReal() {
        $start = !empty($_GET['fdate_export']) ? $_GET['fdate_export'] : "";
        if(empty($start)){
            $this->session->set_flashdata('error', "Hãy chọn tháng");
            redirect(base_url('accountingSystemUpdate/interestReal'));
        }
        
        $data = array();
        if(!empty($start)) $data['start'] = $start;
        
        $infor = $this->api->apiPost($this->userInfo['token'], "accountingSystemUpdate/interest_real", $data);
        //Calculate to export excel
        if(!empty($infor->data)) {
            $this->exportInterestReal_part1($infor->data,$start);
            $this->exportInterestReal_part2($infor->data,$start);
            $this->exportInterestReal_part3($infor->data,$start);
            $this->exportInterestReal_part4($infor->data,$start);
            
            $this->lastRow_Tong_BangLaiThuc();
            
            //-------------------------------
            $this->callLibExcel('bao-cao-bang-lai-thuc-'.date('d-m-Y-H:i:s-').$start.'.xlsx');
            
        } else {
            $this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
            redirect(base_url('accountingSystemUpdate/interestReal'));
        }
    }
    
    private function exportInterestReal_part1($contracts,$start) {
        $this->startColumnMergeFirstRow = $this->startColumnMergeFirstRow + 15;
        $this->sheet->mergeCells("A1:O1");
        $this->sheet->setCellValue('A1', 'Thông tin hợp đồng vay');
        $this->sheet->setCellValue('A2', 'Mã phiếu ghi');
        $this->sheet->setCellValue('B2', 'Mã giao dịch');
        $this->sheet->setCellValue('C2', 'Mã Hợp đồng vay');
        $this->sheet->setCellValue('D2', 'Mã phụ lục hợp đồng vay');
        $this->sheet->setCellValue('E2', 'Thời hạn vay (ngày)');
        $this->sheet->setCellValue('F2', 'Ngày giải ngân');
        $this->sheet->setCellValue('G2', 'Ngày đáo hạn');
        $this->sheet->setCellValue('H2', 'Tên người vay');
        $this->sheet->setCellValue('I2', 'Mã người vay ( trùng CMT)');
        $this->sheet->setCellValue('J2', 'Tên nhà đầu tư');
        $this->sheet->setCellValue('K2', 'Mã NĐT');
        $this->sheet->setCellValue('L2', 'Phòng giao dịch giải ngân');
        $this->sheet->setCellValue('M2', 'Hình thức cầm cố');
        $this->sheet->setCellValue('N2', 'Số tiền vay');
        $this->sheet->setCellValue('O2', 'Hình thức tính lãi');
        
        //Set style
        $this->setStyle("A1:O1");
        
        $i = 3;
        $this->numberRowLastColumn = 3;
        $index = 1;
        
        foreach($contracts as $item){
          
            //Hình thức trả
            $typePay = "";
            $type_interest = !empty($item->loan_infor->type_interest) ? $item->loan_infor->type_interest: "";
            if($type_interest == 1){
                $typePay = "Lãi hàng tháng, gốc hàng tháng";
            }else{
                $typePay = "Lãi hàng tháng, gốc cuối kỳ";
            }
            //Số tiền giải ngân
             $amount = 0;
            if(empty($item->count_extend) || empty($item->count_structure)) {
                $amount = !empty($item->loan_infor->amount_money) ? $item->loan_infor->amount_money : 0;
            }

            $this->sheet->setCellValue('A'.$i,$item->code_contract);
            $index++;
             
            $this->sheet->setCellValue('B'.$i, $this->getCodeTransaction($item)); 
            $this->sheet->setCellValue('C'.$i, $this->contract_model->getMaHopDongVay($item)); 
            //$this->sheet->setCellValue('D'.$i, !empty($item->code_contract_child) ? $item->code_contract_child : ""); 
            $this->sheet->setCellValue('D'.$i, $this->contract_model->getMaPhuLuc($item)); 
            $this->sheet->setCellValue('E'.$i, $item->debt->thoi_han_vay); 
            $this->sheet->setCellValue('F'.$i, !empty($item->disbursement_date) ? $this->time_model->convertTimestampToDatetime_($item->disbursement_date) : ""); 
            $this->sheet->setCellValue('G'.$i, !empty($item->expire_date) ? $this->time_model->convertTimestampToDatetime_($item->expire_date) : "");
            $this->sheet->setCellValue('H'.$i, $item->customer_infor->customer_name);
            $this->sheet->setCellValue('I'.$i, $item->customer_infor->customer_identify);
            $this->sheet->setCellValue('J'.$i, !empty($item->investor_infor->name) ? $item->investor_infor->name : "");
            $this->sheet->setCellValue('K'.$i, !empty($item->investor_infor->code) ? $item->investor_infor->code : "");
            $this->sheet->setCellValue('L'.$i, !empty($item->store->name) ? $item->store->name : "");
            $this->sheet->setCellValue('M'.$i, !empty($item->loan_infor) && !empty($item->loan_infor->type_loan->code) && !empty($item->loan_infor->type_property->code) ? $item->loan_infor->type_loan->code.'-'.$item->loan_infor->type_property->code : "");
            
            $this->sheet->setCellValue('N'.$i, round($amount))
            ->getStyle('N'.$i)
            ->getNumberFormat()
            ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
            $this->sheet->setCellValue('O'.$i, $typePay);
           
            $this->tong_BangLaiThuc['so_tien_vay'] = $this->tong_BangLaiThuc['so_tien_vay'] + $amount;
            
            $i++;
            $this->numberRowLastColumn++;
        }
    }
    
    private function exportInterestReal_part2($contracts,$start) {
        $this->startColumnMergeFirstRow = $this->startColumnMergeFirstRow + 3;
        $this->sheet->mergeCells("P1:P2");
        $this->sheet->mergeCells("Q1:Q2");
        $this->sheet->mergeCells("R1:R2");
        $this->sheet->setCellValue('P1', 'Gốc tháng trước');
        $this->sheet->setCellValue('Q1', 'Lãi tháng trước');
        $this->sheet->setCellValue('R1', 'Phí tháng trước');
        
        //Set style
        $this->setStyle("P1:P2");
        $this->setStyle("Q1:Q2");
        $this->setStyle("R1:R2");
        
        $i = 3;
        foreach($contracts as $item){
           
           $du_no_goc_thang_truoc= $this->getDuno($item,$start)['du_no_goc_thang_truoc'];
           $du_no_lai_thang_truoc= $this->getDuno($item,$start)['du_no_lai_thang_truoc'];
           $du_no_phi_thang_truoc= $this->getDuno($item,$start)['du_no_phi_thang_truoc'];
           
         
            $this->sheet->setCellValue('P'.$i, round($du_no_goc_thang_truoc))
            ->getStyle('P'.$i)
            ->getNumberFormat()
            ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND); 
            $this->sheet->setCellValue('Q'.$i, round($du_no_lai_thang_truoc))
            ->getStyle('Q'.$i)
            ->getNumberFormat()
            ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND); 
            $this->sheet->setCellValue('R'.$i, round($du_no_phi_thang_truoc))
            ->getStyle('R'.$i)
            ->getNumberFormat()
            ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND); 
            
            $this->tong_BangLaiThuc['du_no_goc_thang_truoc'] = $this->tong_BangLaiThuc['du_no_goc_thang_truoc'] + $du_no_goc_thang_truoc;
            $this->tong_BangLaiThuc['du_no_lai_thang_truoc'] = $this->tong_BangLaiThuc['du_no_lai_thang_truoc'] + $du_no_lai_thang_truoc;
            $this->tong_BangLaiThuc['du_no_phi_thang_truoc'] = $this->tong_BangLaiThuc['du_no_phi_thang_truoc'] + $du_no_phi_thang_truoc;
           
            $i++;
        }
    }
    
    private function exportInterestReal_part3($contracts,$start) {
        $this->startColumnMergeFirstRow = $this->startColumnMergeFirstRow + 9;
        $this->sheet->mergeCells("S1:AB1");
        $this->sheet->setCellValue('S1', 'Lãi + phí tính đến thời điểm cuối tháng');
        $this->sheet->setCellValue('S2', 'Số ngày tính lãi tháng');
        $this->sheet->setCellValue('T2', 'Lãi vay (trả nhà ĐT)');
        $this->sheet->setCellValue('U2', 'Thuế TNCN trả thay NĐT');
        $this->sheet->setCellValue('V2', 'Phí tư vấn');
        $this->sheet->setCellValue('W2', 'Phí thẩm định');
        $this->sheet->setCellValue('X2', 'Phí gia hạn');
        $this->sheet->setCellValue('Y2', 'Phí trả chậm');
        $this->sheet->setCellValue('Z2', 'Phí trả trước');
        $this->sheet->setCellValue('AA2', 'Phí quá hạn');
        $this->sheet->setCellValue('AB2', 'Tổng phí');
        //Set style
        $this->setStyle("S1:AB1");
        
        $i = 3;
        
        foreach($contracts as $item){

            $count_date_interest = !empty($item->plan_contract[0]->count_date_interest) ? $item->plan_contract[0]->count_date_interest : 0;

            //Lãi vay (trả nhà ĐT)
            $interestPayInvestor = $this->getLaiVayPhaiTraNDT_T4($item); 
            //Thuế TNCN trả thay NDT
            $thue_TNCN_tra_thay_NDT = $interestPayInvestor * 5 / 100;
            $so_ngay_trong_thang=!empty($item->plan_contract[0]->so_ngay_trong_thang_dau) ? $item->plan_contract[0]->so_ngay_trong_thang_dau : $item->plan_contract[0]->so_ngay_trong_thang;
            if($so_ngay_trong_thang>0)
            {
            //Phí tư vấn
            $feeAdvisory = ($item->loan_infor->amount_money * $item->fee->percent_advisory / 100) * $item->plan_contract[0]->count_date_interest / $so_ngay_trong_thang;
            //Phí thẩm định
            $feeExpertise = ($item->loan_infor->amount_money * $item->fee->percent_expertise / 100) * $item->plan_contract[0]->count_date_interest / $so_ngay_trong_thang;
            }else{
                $feeAdvisory =0;
                $feeExpertise =0;
            }
          
            if(empty($so_ngay_trong_thang))
            {
                $interestPayInvestor=0;
                $thue_TNCN_tra_thay_NDT=0;
                $feeAdvisory=0;
                $feeExpertise=0;
            }
             
            $so_tien_phi_da_thu_hoi = $this->getTongPhi_AA4_BangLaiThuc($item);
            $so_tien_phi_gia_han_da_thu_hoi = !empty($item->so_tien_phi_gia_han_1thang_da_tra) ? $item->so_tien_phi_gia_han_1thang_da_tra : 0;
            $so_tien_phi_cham_tra_da_thu_hoi = !empty($item->so_tien_phi_cham_tra_1thang_da_tra) ? $item->so_tien_phi_cham_tra_1thang_da_tra : 0;
            $so_tien_phi_tat_toan_da_thu_hoi = !empty($item->so_tien_phi_tat_toan_1thang_da_tra) ? $item->so_tien_phi_tat_toan_1thang_da_tra : 0;
            $so_tien_phi_phat_sinh_da_thu_hoi = !empty($item->so_tien_phi_phat_sinh_1thang_da_tra) ? $item->so_tien_phi_phat_sinh_1thang_da_tra : 0;
          
            //Tổng phí
            $totalFee =$so_tien_phi_da_thu_hoi +$so_tien_phi_gia_han_da_thu_hoi+$so_tien_phi_cham_tra_da_thu_hoi+$so_tien_phi_tat_toan_da_thu_hoi+$so_tien_phi_phat_sinh_da_thu_hoi;
            $startMonth = strtotime(date('Y-m-01', strtotime($start)).' 00:00:00');
              $endMonth = strtotime(date('Y-m-t', strtotime($start)).' 23:59:59'); 
             $condition_last=[
                'code_contract'=>$item->code_contract,
                'status'=>1,
                'type'=>3,
                'ky_tt_xa_nhat' => $item->debt->ky_tt_xa_nhat,
                'endMonth' => $endMonth,
            ];
            $du_no_lai_thang_truoc = !empty($item->tien_lai_thang_truoc) ? $item->tien_lai_thang_truoc-$so_tien_lai_da_thu_hoi_thang_truoc : 0;
            
             $disbursement_date=!empty($item->disbursement_date) ? $item->disbursement_date : 0;
              if(date('Y-m',$disbursement_date)==date('Y-m',$item->plan_contract[0]->time_timestamp))
            {
             
              $du_no_lai_thang_truoc=0;
            
            }
            $tranDB = $this->contract_model->get_tran_one_tt($condition_last);
            if(!empty($tranDB) && $count_date_interest>0)
            {
                if($tranDB['date_pay']<$item->debt->ky_tt_xa_nhat)
                {
                 //Lãi vay (trả nhà ĐT)
                if($item->disbursement_date>=$startMonth)
              {
                $datediff = $tranDB['date_pay'] -$item->disbursement_date;
                $count = intval($datediff / (60 * 60 * 24))+1;
               }else{
                 $datediff = $tranDB['date_pay'] -$startMonth;
                 $count = intval($datediff / (60 * 60 * 24))+1;
               }
                if($count>0)
                {
                if($item->loan_infor->type_interest==2)
                {
            $interestPayInvestor =  ($interestPayInvestor/$count_date_interest)*$count ;
            //Thuế TNCN trả thay NDT
            $thue_TNCN_tra_thay_NDT = $interestPayInvestor * 5 / 100;

            $so_tien_phi_da_thu_hoi =($so_tien_phi_da_thu_hoi/$count_date_interest)*$count ;
              }else{
            $feeAdvisory_ = $item->loan_infor->amount_money * $item->fee->percent_advisory / 100;
            //Phí thẩm định
            $feeExpertise_ = $item->loan_infor->amount_money * $item->fee->percent_expertise / 100;
             $interestPayInvestor =  ($interestPayInvestor/$count_date_interest)*$count ;
            //Thuế TNCN trả thay NDT
            $thue_TNCN_tra_thay_NDT = $interestPayInvestor * 5 / 100;

            $so_tien_phi_da_thu_hoi =(($feeAdvisory_+$feeExpertise_)/30)*$count ;

              }
             
             //Phí tư vấn
            $feeAdvisory = $so_tien_phi_da_thu_hoi *($item->fee->percent_advisory / ($item->fee->percent_advisory +$item->fee->percent_expertise));
            //Phí thẩm định
            $feeExpertise = $so_tien_phi_da_thu_hoi *($item->fee->percent_expertise / ($item->fee->percent_advisory +$item->fee->percent_expertise));
            $count_date_interest=$count;
            //Tổng phí
           
            }else{
                $interestPayInvestor=0;
                $thue_TNCN_tra_thay_NDT=0;
                $feeAdvisory=0;
                $feeExpertise=0;
             }
            }
            }else{
                $startMonth = strtotime(date('Y-m-01', strtotime($start)).' 00:00:00');
              $endMonth = strtotime(date('Y-m-t', strtotime($start)).' 23:59:59');  
                  $du_no_lai_thang_truoc= $this->getDuno($item,$start)['du_no_lai_thang_truoc'];
                  $du_no_phi_thang_truoc= $this->getDuno($item,$start)['du_no_phi_thang_truoc'];
            $condition=[
                'code_contract'=>$item->code_contract,
                'status'=>1,
                'type'=>3,
                'ky_tt_xa_nhat' => $item->debt->ky_tt_xa_nhat,
                'endMonth' => $endMonth,
            ];
             
            $tranDB = $this->contract_model->get_tran_one_tt($condition);
            if(empty($tranDB) && $item->debt->ky_tt_xa_nhat< $endMonth)
            {
              $so_ngay_trong_thang=days_in_month(date('m', $startMonth),date('Y', $startMonth));
              $count_date_interest=30;
              //Phí tư vấn
            $feeAdvisory = $du_no_phi_thang_truoc *($item->fee->percent_advisory / ($item->fee->percent_advisory +$item->fee->percent_expertise))*$count_date_interest/$so_ngay_trong_thang;
            //Phí thẩm định
            $feeExpertise = $du_no_phi_thang_truoc *($item->fee->percent_expertise / ($item->fee->percent_advisory +$item->fee->percent_expertise))*$count_date_interest/$so_ngay_trong_thang;
           
            $interestPayInvestor = $du_no_lai_thang_truoc *$item->fee->percent_interest_customer*$count_date_interest/$so_ngay_trong_thang;
            //Thuế TNCN trả thay NDT
            $thue_TNCN_tra_thay_NDT = $interestPayInvestor * 5 / 100;
            }
            if(empty($tranDB) && $item->debt->ky_tt_xa_nhat< $endMonth && $item->debt->ky_tt_xa_nhat>= $startMonth)
            {
              $so_ngay_trong_thang=days_in_month(date('m', $startMonth),date('Y', $startMonth));
              
            $datediff = $endMonth - $item->debt->ky_tt_xa_nhat;
            $count_date_interest = intval($datediff / (60 * 60 * 24));
              //Phí tư vấn
            $feeAdvisory = $du_no_phi_thang_truoc *($item->fee->percent_advisory / ($item->fee->percent_advisory +$item->fee->percent_expertise))*$count_date_interest/$so_ngay_trong_thang;
            //Phí thẩm định
            $feeExpertise = $du_no_phi_thang_truoc *($item->fee->percent_expertise / ($item->fee->percent_advisory +$item->fee->percent_expertise))*$count_date_interest/$so_ngay_trong_thang;
           
            $interestPayInvestor = $du_no_lai_thang_truoc *$item->fee->percent_interest_customer*$count_date_interest/$so_ngay_trong_thang;
            //Thuế TNCN trả thay NDT
            $thue_TNCN_tra_thay_NDT = $interestPayInvestor * 5 / 100;
            }
            if(!empty($tranDB) && $item->debt->ky_tt_xa_nhat< $endMonth && $tranDB['date_pay']>=$startMonth)
            {
             $so_ngay_trong_thang=days_in_month(date('m', $startMonth),date('Y', $startMonth));
           
               $datediff = $tranDB['date_pay'] - $startMonth;
            $count_date_interest = intval($datediff / (60 * 60 * 24));
                //Phí tư vấn
            $feeAdvisory = $du_no_phi_thang_truoc *($item->fee->percent_advisory / ($item->fee->percent_advisory +$item->fee->percent_expertise))*$count_date_interest/$so_ngay_trong_thang;
            //Phí thẩm định
            $feeExpertise = $du_no_phi_thang_truoc *($item->fee->percent_expertise / ($item->fee->percent_advisory +$item->fee->percent_expertise))*$count_date_interest/$so_ngay_trong_thang;
           
            $interestPayInvestor = $du_no_lai_thang_truoc *$item->fee->percent_interest_customer*$count_date_interest/$so_ngay_trong_thang;
            //Thuế TNCN trả thay NDT
            $thue_TNCN_tra_thay_NDT = $interestPayInvestor * 5 / 100;

            }

            }
            if($feeAdvisory<0)
            {
                $feeAdvisory=0;
            }
             if($feeExpertise<0)
            {
                $feeExpertise=0;
            }
             if($interestPayInvestor<0)
            {
                $interestPayInvestor=0;
            }
             if($thue_TNCN_tra_thay_NDT<0)
            {
                $thue_TNCN_tra_thay_NDT=0;
            }
             $totalFee =$feeAdvisory+$feeExpertise+$so_tien_phi_gia_han_da_thu_hoi+$so_tien_phi_cham_tra_da_thu_hoi+$so_tien_phi_tat_toan_da_thu_hoi+$so_tien_phi_phat_sinh_da_thu_hoi;
            
            $this->sheet->setCellValue('S'.$i, $count_date_interest); 
            $this->sheet->setCellValue('T'.$i, round($interestPayInvestor))
            ->getStyle('T'.$i)
            ->getNumberFormat()
            ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND); 
            $this->sheet->setCellValue('U'.$i, round($thue_TNCN_tra_thay_NDT))
            ->getStyle('U'.$i)
            ->getNumberFormat()
            ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND); 
            $this->sheet->setCellValue('V'.$i, round($feeAdvisory))
            ->getStyle('V'.$i)
            ->getNumberFormat()
            ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND); 
            $this->sheet->setCellValue('W'.$i, round($feeExpertise))
            ->getStyle('W'.$i)
            ->getNumberFormat()
            ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND); 
            $this->sheet->setCellValue('X'.$i, round($so_tien_phi_gia_han_da_thu_hoi))
            ->getStyle('X'.$i)
            ->getNumberFormat()
            ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND); 
            $this->sheet->setCellValue('Y'.$i, round($so_tien_phi_cham_tra_da_thu_hoi))
            ->getStyle('Y'.$i)
            ->getNumberFormat()
            ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND); 
            $this->sheet->setCellValue('Z'.$i, round($so_tien_phi_tat_toan_da_thu_hoi))
            ->getStyle('Z'.$i)
            ->getNumberFormat()
            ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND); 
            $this->sheet->setCellValue('AA'.$i, round($so_tien_phi_phat_sinh_da_thu_hoi))
            ->getStyle('AA'.$i)
            ->getNumberFormat()
            ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND); 
            $this->sheet->setCellValue('AB'.$i, round($totalFee))
            ->getStyle('AB'.$i)
            ->getNumberFormat()
            ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND); 
            
            $this->tong_BangLaiThuc['so_ngay_tinh_lai_thang'] = $this->tong_BangLaiThuc['so_ngay_tinh_lai_thang'] + $count_date_interest;
            $this->tong_BangLaiThuc['lai_vay_tra_NDT'] = $this->tong_BangLaiThuc['lai_vay_tra_NDT'] + $interestPayInvestor;
            $this->tong_BangLaiThuc['thue_TTCN_tra_thay_NDT'] = $this->tong_BangLaiThuc['thue_TTCN_tra_thay_NDT'] + $thue_TNCN_tra_thay_NDT;
            $this->tong_BangLaiThuc['phi_tu_van'] = $this->tong_BangLaiThuc['phi_tu_van'] + $feeAdvisory;
            $this->tong_BangLaiThuc['phi_tham_dinh'] = $this->tong_BangLaiThuc['phi_tham_dinh'] + $feeExpertise;
            $this->tong_BangLaiThuc['phi_gia_han_khoan_vay'] = $this->tong_BangLaiThuc['phi_gia_han_khoan_vay'] + $so_tien_phi_gia_han_da_thu_hoi;
            $this->tong_BangLaiThuc['phi_cham_tra_khoan_vay'] = $this->tong_BangLaiThuc['phi_cham_tra_khoan_vay'] + $so_tien_phi_cham_tra_da_thu_hoi;
            $this->tong_BangLaiThuc['phi_tat_toan_khoan_vay'] = $this->tong_BangLaiThuc['phi_tat_toan_khoan_vay'] + $so_tien_phi_tat_toan_da_thu_hoi;
            $this->tong_BangLaiThuc['phi_phat_sinh_khoan_vay'] = $this->tong_BangLaiThuc['phi_phat_sinh_khoan_vay'] + $so_tien_phi_phat_sinh_da_thu_hoi;

            $this->tong_BangLaiThuc['tong_phi'] = $this->tong_BangLaiThuc['tong_phi'] + $totalFee;
            
            $i++;
        }
    }
    
    private function exportInterestReal_part4($contracts,$start) {
        $this->startColumnMergeFirstRow = $this->startColumnMergeFirstRow + 9;
        $this->sheet->mergeCells("AC1:AH1");
        $this->sheet->setCellValue('AC1', '');
        $this->sheet->setCellValue('AD2', 'Số tiền gốc đã thu hồi');
        $this->sheet->setCellValue('AE2', 'Số tiền lãi NĐT đã thu hồi');
        $this->sheet->setCellValue('AF2', 'Số tiền phí đã thu hồi');
        $this->sheet->setCellValue('AG2', 'Số tiền gốc còn lại');
        $this->sheet->setCellValue('AH2', 'Số tiền lãi NĐT còn lại ');
        $this->sheet->setCellValue('AI2', 'Số tiền phí còn lại');
        $this->sheet->setCellValue('AJ2', 'Trạng thái');
        
        $i = 3;
        
        foreach($contracts as $item){
          
            //Số tiền giải ngân
            $amount = 0;
            $startMonth = strtotime(date('Y-m-01', strtotime($start)).' 00:00:00');
              $endMonth = strtotime(date('Y-m-t', strtotime($start)).' 23:59:59');  
            $amount = !empty($item->loan_infor->amount_money) ? $item->loan_infor->amount_money : 0;
            
            $tien_lai_1thang_da_tra_tien_thua = !empty($item->tien_lai_1thang_da_tra_tien_thua) ? $item->tien_lai_1thang_da_tra_tien_thua : 0;
            //var_dump($tien_lai_1thang_da_tra_tien_thua); die;
            $tien_phi_1thang_da_tra_tien_thua = !empty($item->tien_phi_1thang_da_tra_tien_thua) ? $item->tien_phi_1thang_da_tra_tien_thua : 0;
            $tien_phi_1thang_da_tra_tien_thua = !empty($item->tien_phi_1thang_da_tra_tien_thua) ? $item->tien_phi_1thang_da_tra_tien_thua : 0;

            $so_tien_goc_da_thu_hoi = !empty($item->tien_goc_1thang_da_tra) ? $item->tien_goc_1thang_da_tra : 0;
            $so_tien_lai_NDT_da_thu_hoi = !empty($item->tien_lai_1thang_da_tra) ? $item->tien_lai_1thang_da_tra : 0;
            $so_tien_phi_da_thu_hoi = !empty($item->tien_phi_1thang_da_tra) ? $item->tien_phi_1thang_da_tra : 0;
            $so_tien_thua_thanh_toan_1thang_da_tra = !empty($item->so_tien_thua_thanh_toan_1thang_da_tra) ? $item->so_tien_thua_thanh_toan_1thang_da_tra : 0;
            $so_tien_thua_tat_toan_1thang_da_tra = !empty($item->so_tien_thua_tat_toan_1thang_da_tra) ? $item->so_tien_thua_tat_toan_1thang_da_tra : 0;
            $so_tien_lai_NDT_da_thu_hoi =$so_tien_lai_NDT_da_thu_hoi + $tien_lai_1thang_da_tra_tien_thua; 
             $so_tien_phi_da_thu_hoi =$so_tien_phi_da_thu_hoi + $tien_phi_1thang_da_tra_tien_thua+$so_tien_thua_thanh_toan_1thang_da_tra+$so_tien_thua_tat_toan_1thang_da_tra;
            $so_tien_lai_NDT_con_lai = 0;
            $so_tien_phi_con_lai = 0;
             $type_interest = !empty($item->loan_infor->type_interest) ? $item->loan_infor->type_interest : "";
            $condition_stt=[
                'code_contract'=>$item->code_contract,
                'status'=>1,
                'type'=>3,
                'ky_tt_xa_nhat' => $item->debt->ky_tt_xa_nhat,
                'endMonth' => $endMonth,
                'status_contract_origin' => $item->status,
                'date_pay'=> array(
                '$lte' => $endMonth)
            ];
            $status = $this->contract_model->getStatusContract($condition_stt);
            if($status=="Đang vay" && $type_interest==2)
           {
             $so_tien_phi_da_thu_hoi=$so_tien_phi_da_thu_hoi+ $so_tien_goc_da_thu_hoi;
             $so_tien_goc_da_thu_hoi=0;
           }
  
           
            //$so_tien_lai_NDT_con_lai = Q4 + T4 - AC4;
            
            
            //$so_tien_phi_con_lai = R4 + AA4 - AD4
            $R4 = !empty($item->du_no_phi_thang_truoc) ? $item->du_no_phi_thang_truoc : 0;
            $AA4 = $this->getTongPhi_AA4_BangLaiThuc($item);
            $so_tien_phi_con_lai = $R4 + $AA4 - $so_tien_phi_da_thu_hoi;
            
            $du_no_goc_thang_truoc= $this->getDuno($item,$start)['du_no_goc_thang_truoc'];
           $du_no_lai_thang_truoc= $this->getDuno($item,$start)['du_no_lai_thang_truoc'];
           $du_no_phi_thang_truoc= $this->getDuno($item,$start)['du_no_phi_thang_truoc'];

            
         
          $disbursement_date=!empty($item->disbursement_date) ? $item->disbursement_date : 0;
            if($du_no_goc_thang_truoc == 0 && date('Y-m',$disbursement_date)==date('Y-m',$item->plan_contract[0]->time_timestamp)) {
                $AG = $amount - $so_tien_goc_da_thu_hoi;
            } else {
                $AG = $du_no_goc_thang_truoc - $so_tien_goc_da_thu_hoi;
            }
            
            $AH = $du_no_lai_thang_truoc + $this->getLaiVayPhaiTraNDT_T4($item) - $so_tien_lai_NDT_da_thu_hoi;
            $AI = $du_no_phi_thang_truoc + $this->getTongPhi_AA4_BangLaiThuc($item) - $so_tien_phi_da_thu_hoi;
              $condition=[
                'code_contract'=>$item->code_contract,
                'status'=>1,
                'type'=>3,
                'ky_tt_xa_nhat' => $item->debt->ky_tt_xa_nhat,
                'endMonth' => $endMonth,
            ];
             $condition_last=[
                'code_contract'=>$item->code_contract,
                'status'=>1,
                'type'=>3,
                'ky_tt_xa_nhat' => $item->debt->ky_tt_xa_nhat,
                'endMonth' => $startMonth,
                'status_contract_origin' => $item->status,
                'date_pay'=> array(
                '$lte' => $startMonth)
            ];
            $tranDB = $this->contract_model->get_tran_one_tt($condition);
          
             
            $status_last = $this->contract_model->getStatusContract($condition_last);

            if(!empty($tranDB))
            {
                $du_no_goc_con = $tranDB['so_tien_goc_phai_tra_tat_toan']-$tranDB['so_tien_goc_da_tra'];
                $du_no_lai_con = $tranDB['so_tien_lai_phai_tra_tat_toan']-$tranDB['so_tien_lai_da_tra'];
                $du_no_phi_con = $tranDB['so_tien_phi_phai_tra_tat_toan']-$tranDB['so_tien_phi_da_tra']+$tranDB['tien_thua_thanh_toan'];

                    $AG = $du_no_goc_con;
                    $AH = $du_no_lai_con; 
                    $AI = $du_no_phi_con;
            }
           
          if($status=="Gia hạn" && $status_last!="Gia hạn")
          {
            $so_tien_goc_da_thu_hoi=$amount;
            $AG=0;
            $so_tien_phi_da_thu_hoi=$so_tien_phi_da_thu_hoi- $tien_phi_1thang_da_tra_tien_thua-$so_tien_thua_thanh_toan_1thang_da_tra-$so_tien_thua_tat_toan_1thang_da_tra;
         
           $AI = $du_no_phi_thang_truoc + $this->getTongPhi_AA4_BangLaiThuc($item) - $so_tien_phi_da_thu_hoi;

          }
           if($status=="Gia hạn" && $status_last=="Gia hạn")
          {
            $so_tien_goc_da_thu_hoi=0;
            $AG=0;
            $so_tien_phi_da_thu_hoi=0;
            $so_tien_lai_da_thu_hoi=0;
            
            $AI = $AI+$so_tien_thua_thanh_toan_da_thu_hoi;
            $so_tien_lai_NDT_tt =$so_tien_lai_NDT_da_thu_hoi - $tien_lai_1thang_da_tra_tien_thua;
            $AH = $du_no_lai_thang_truoc + $this->getLaiVayPhaiTraNDT_T4($item) - $so_tien_lai_NDT_tt;
            $status="Gia hạn+";
          }

            $this->sheet->setCellValue('AD'.$i, round($so_tien_goc_da_thu_hoi))
            ->getStyle('AD'.$i)
            ->getNumberFormat()
            ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND); 
            $this->sheet->setCellValue('AE'.$i, round($so_tien_lai_NDT_da_thu_hoi))
            ->getStyle('AE'.$i)
            ->getNumberFormat()
            ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND); 
            $this->sheet->setCellValue('AF'.$i, round($so_tien_phi_da_thu_hoi))
            ->getStyle('AF'.$i)
            ->getNumberFormat()
            ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND); 
            $this->sheet->setCellValue('AG'.$i, round($AG))
            ->getStyle('AG'.$i)
            ->getNumberFormat()
            ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
            $this->sheet->setCellValue('AH'.$i, round($AH))
            ->getStyle('AH'.$i)
            ->getNumberFormat()
            ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
            $this->sheet->setCellValue('AI'.$i, round($AI))
            ->getStyle('AI'.$i)
            ->getNumberFormat()
            ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
            $this->sheet->setCellValue('AJ'.$i, $status); 
            
            $this->tong_BangLaiThuc['so_tien_goc_da_thu_hoi'] = $this->tong_BangLaiThuc['so_tien_goc_da_thu_hoi'] + $so_tien_goc_da_thu_hoi;
            $this->tong_BangLaiThuc['so_tien_lai_NDT_da_thu_hoi'] = $this->tong_BangLaiThuc['so_tien_lai_NDT_da_thu_hoi'] + $so_tien_lai_NDT_da_thu_hoi;
            $this->tong_BangLaiThuc['so_tien_phi_da_thu_hoi'] = $this->tong_BangLaiThuc['so_tien_phi_da_thu_hoi'] + $so_tien_phi_da_thu_hoi;
            $this->tong_BangLaiThuc['so_tien_goc_con_lai'] = $this->tong_BangLaiThuc['so_tien_goc_con_lai'] + $AG;
            $this->tong_BangLaiThuc['so_tien_lai_NDT_con_lai'] = $this->tong_BangLaiThuc['so_tien_lai_NDT_con_lai'] + $AH;
            $this->tong_BangLaiThuc['so_tien_phi_con_lai'] = $this->tong_BangLaiThuc['so_tien_phi_con_lai'] + $AI;
            
            $i++;
        }
    }
    
    //Theo dõi khoản vay T hiện tại
    public function followCurrentMonth() {
        $this->data["pageName"] = "Theo dõi khoản vay T hiện tại";
        $this->data['template'] = 'web/accounting_system_update/follow_current_month';
        $this->load->view('template', isset($this->data) ? $this->data:NULL);
    }
    
    //Thu hồi khoản vay
    public function revokeLoan() {
        $this->data["pageName"] = "Thu hồi khoản vay";
        $this->data['template'] = 'web/accounting_system_update/revoke_loan';
        $this->load->view('template', isset($this->data) ? $this->data:NULL);
    }
    
    //Theo dõi NĐT
    public function followInvestor() {
        $this->data["pageName"] = "Theo dõi NĐT";
        $this->data['template'] = 'web/accounting_system_update/follow_investor';
        $this->load->view('template', isset($this->data) ? $this->data:NULL);
    }
    
    //Bảng lãi thực NĐT
    public function interestRealInvestor() {
        $this->data["pageName"] = "Bảng lãi thực NĐT";
        $this->data['template'] = 'web/accounting_system_update/interest_real_investor';
        $this->load->view('template', isset($this->data) ? $this->data:NULL);
    }
    
    //Thanh toán NĐT
    public function payInvestor() {
        $this->data["pageName"] = "Bảng lãi thực NĐT";
        $this->data['template'] = 'web/accounting_system_update/pay_investor';
        $this->load->view('template', isset($this->data) ? $this->data:NULL);
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
            'borders' => 
                [ 
                    'left' => 
                        [ 
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM, 
                            'color' => [ 'rgb' => '808080' ] 
                        ], 
                    'right' => 
                        [ 
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM, 
                            'color' => [ 'rgb' => '808080' ] 
                        ], 
                    'bottom' => 
                        [ 
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM, 
                            'color' => [ 'rgb' => '808080' ] 
                        ], 
                    'top' => 
                        [ 
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM, 
                            'color' => [ 'rgb' => '808080' ] 
                        ] 
                ], 
            'quotePrefix' => true 
        ] ;
        $this->getStyle = $styles;
        $this->sheet->getStyle($range)->applyFromArray($styles)->getAlignment()->setHorizontal('center');
    }
    
    private function getTongPhi_AA4_BangLaiThuc($item) {
        $so_ngay_trong_thang=!empty($item->plan_contract[0]->so_ngay_trong_thang_dau) ? $item->plan_contract[0]->so_ngay_trong_thang_dau : $item->plan_contract[0]->so_ngay_trong_thang;
        if($so_ngay_trong_thang>0)
        {
         //Phí tư vấn
            $feeAdvisory = ($item->loan_infor->amount_money * $item->fee->percent_advisory / 100) * $item->plan_contract[0]->count_date_interest / $so_ngay_trong_thang;
            //Phí thẩm định
            $feeExpertise = ($item->loan_infor->amount_money * $item->fee->percent_expertise / 100) * $item->plan_contract[0]->count_date_interest / $so_ngay_trong_thang;
        }
        if($feeAdvisory<0)
            {
                $feeAdvisory=0;
            }
             if($feeExpertise<0)
            {
                $feeExpertise=0;
            }
        $totalFee = $feeAdvisory + $feeExpertise ;
      if(empty($so_ngay_trong_thang))
      {
        $totalFee=0;
      }
        return $totalFee;
    }
    
     private function lastRow_Tong_BangLaiThuc() {
        $this->sheet->setCellValue('B'.$this->numberRowLastColumn, "Tổng")
                    ->getStyle('B'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        //N4
        $this->sheet->setCellValue('N'.$this->numberRowLastColumn,round($this->tong_BangLaiThuc['so_tien_vay']))
                    ->getStyle('N'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)))
                    ->getNumberFormat()
                    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                   
        //P4
        $this->sheet->setCellValue('P'.$this->numberRowLastColumn, round($this->tong_BangLaiThuc['du_no_goc_thang_truoc']))
                    ->getStyle('P'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)))
                    ->getNumberFormat()
                    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
        
        //Q4
        $this->sheet->setCellValue('Q'.$this->numberRowLastColumn, round($this->tong_BangLaiThuc['du_no_lai_thang_truoc']))
                    ->getStyle('Q'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)))
                    ->getNumberFormat()
                    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
        
        //R4
        $this->sheet->setCellValue('R'.$this->numberRowLastColumn, round($this->tong_BangLaiThuc['du_no_phi_thang_truoc']))
                    ->getStyle('R'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)))
                    ->getNumberFormat()
                    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
        //S4
        $this->sheet->setCellValue('S'.$this->numberRowLastColumn, $this->tong_BangLaiThuc['so_ngay_tinh_lai_thang'])
                    ->getStyle('S'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        //T4
        $this->sheet->setCellValue('T'.$this->numberRowLastColumn, round($this->tong_BangLaiThuc['lai_vay_tra_NDT']))
                    ->getStyle('T'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)))
                    ->getNumberFormat()
                    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
        //R4
        $this->sheet->setCellValue('R'.$this->numberRowLastColumn, round($this->tong_BangLaiThuc['du_no_phi_thang_truoc']))
                    ->getStyle('R'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)))
                    ->getNumberFormat()
                    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
        //U4
        $this->sheet->setCellValue('U'.$this->numberRowLastColumn, round($this->tong_BangLaiThuc['thue_TTCN_tra_thay_NDT']))
                    ->getStyle('U'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)))
                    ->getNumberFormat()
                    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
        //V4
        $this->sheet->setCellValue('V'.$this->numberRowLastColumn, round($this->tong_BangLaiThuc['phi_tu_van']))
                    ->getStyle('V'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)))
                    ->getNumberFormat()
                    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
        //W4
        $this->sheet->setCellValue('W'.$this->numberRowLastColumn, round($this->tong_BangLaiThuc['phi_tham_dinh']))
                    ->getStyle('W'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)))
                    ->getNumberFormat()
                    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
        //X4
        $this->sheet->setCellValue('X'.$this->numberRowLastColumn, round($this->tong_BangLaiThuc['phi_gia_han_khoan_vay']))
                    ->getStyle('X'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)))
                    ->getNumberFormat()
                    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
        //Y4
        $this->sheet->setCellValue('Y'.$this->numberRowLastColumn, round($this->tong_BangLaiThuc['phi_cham_tra_khoan_vay']))
                    ->getStyle('Y'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)))
                    ->getNumberFormat()
                    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
        //Z4
        $this->sheet->setCellValue('Z'.$this->numberRowLastColumn, round($this->tong_BangLaiThuc['phi_gia_han_khoan_vay']))
                    ->getStyle('Z'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)))
                    ->getNumberFormat()
                    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
        //AA4
        $this->sheet->setCellValue('AA'.$this->numberRowLastColumn, round($this->tong_BangLaiThuc['phi_phat_sinh_khoan_vay']))
                    ->getStyle('AA'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)))
                    ->getNumberFormat()
                    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
        //AB4
        $this->sheet->setCellValue('AB'.$this->numberRowLastColumn, round($this->tong_BangLaiThuc['tong_phi']))
                    ->getStyle('AB'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)))
                    ->getNumberFormat()
                    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
        //AD4
        $this->sheet->setCellValue('AD'.$this->numberRowLastColumn, round($this->tong_BangLaiThuc['so_tien_goc_da_thu_hoi']))
                    ->getStyle('AD'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)))
                    ->getNumberFormat()
                    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
        
        //AE4
        $this->sheet->setCellValue('AE'.$this->numberRowLastColumn, round($this->tong_BangLaiThuc['so_tien_lai_NDT_da_thu_hoi']))
                    ->getStyle('AE'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)))
                    ->getNumberFormat()
                    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
        //AF4
        $this->sheet->setCellValue('AF'.$this->numberRowLastColumn, round($this->tong_BangLaiThuc['so_tien_phi_da_thu_hoi']))
                    ->getStyle('AF'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)))
                    ->getNumberFormat()
                    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
        //AG4
        $this->sheet->setCellValue('AG'.$this->numberRowLastColumn, round($this->tong_BangLaiThuc['so_tien_goc_con_lai']))
                    ->getStyle('AG'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)))
                    ->getNumberFormat()
                    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
         //AH4
        $this->sheet->setCellValue('AH'.$this->numberRowLastColumn, round($this->tong_BangLaiThuc['so_tien_lai_NDT_con_lai']))
                    ->getStyle('AH'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)))
                    ->getNumberFormat()
                    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
         //AI4
        $this->sheet->setCellValue('AI'.$this->numberRowLastColumn, round($this->tong_BangLaiThuc['so_tien_phi_con_lai']))
                    ->getStyle('AI'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)))
                    ->getNumberFormat()
                    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
        
    }
    
    private function getLaiVayPhaiTraNDT_T4($item) {
        $laiVayPhaiTraNDT = 0;
       
       
            $laiVayPhaiTraNDT = $item->plan_contract[0]->tien_lai_1thang ;

        
        return $laiVayPhaiTraNDT;
    }
    
    private function getCodeTransaction($item) {
        $codeTransaction = "";
        if(!empty($item->investor_code) && $item->investor_code == 'vimo' && $item->status_create_withdrawal == 'success') {
            $codeTransaction = "'".$item->response_get_transaction_withdrawal_status->withdrawal_transaction_id;
        } else if(!empty($item->investor_code) && $item->status_create_withdrawal_nl == '00') {
            $codeTransaction = $item->response_get_transaction_withdrawal_status_nl->transaction_id;
        } else if(!empty($item->investor_code) && !empty($item->code_auto_disbursement)) {
            $codeTransaction = $item->code_auto_disbursement;
        } else if(!empty($item->response_get_transaction_withdrawal_status_nl) && $item->response_get_transaction_withdrawal_status_nl->error_code == '00') {
			$codeTransaction = $item->response_get_transaction_withdrawal_status_nl->transaction_id;
		}
        return $codeTransaction;
    }
    
    private function getAD2($item) {
        $a = !empty($item->so_tien_phi_da_thu_hoi_AD) ? $item->so_tien_phi_da_thu_hoi_AD : 0;
        $b = !empty($item->so_tien_phi_tra_cham_da_thu_hoi) ? $item->so_tien_phi_tra_cham_da_thu_hoi : 0;
        $c = !empty($item->so_tien_phi_tat_toan_da_thu_hoi) ? $item->so_tien_phi_tat_toan_da_thu_hoi : 0;
        $d = !empty($item->so_tien_phi_gia_han_da_thu_hoi) ? $item->so_tien_phi_gia_han_da_thu_hoi : 0;
        $e = !empty($item->so_tien_phi_phat_sinh_da_thu_hoi) ? $item->so_tien_phi_phat_sinh_da_thu_hoi : 0;
        
        return $a+$b+$c+$d+$e;
    }
     private function getDuno($item,$start) {
         $disbursement_date=!empty($item->disbursement_date) ? $item->disbursement_date : 0;
            $startMonth = strtotime(date('Y-m-01', strtotime($start)).' 00:00:00');

            $so_tien_goc_da_thu_hoi_thang_truoc = !empty($item->so_tien_goc_da_thu_hoi) ? $item->so_tien_goc_da_thu_hoi : 0;
            $so_tien_lai_da_thu_hoi_thang_truoc = !empty($item->so_tien_lai_da_thu_hoi) ? $item->so_tien_lai_da_thu_hoi : 0;
            $so_tien_thua_tat_toan_da_thu_hoi = !empty($item->so_tien_thua_tat_toan_da_thu_hoi) ? $item->so_tien_thua_tat_toan_da_thu_hoi : 0;
            $so_tien_thua_thanh_toan_da_thu_hoi = !empty($item->so_tien_thua_thanh_toan_da_thu_hoi) ? $item->so_tien_thua_thanh_toan_da_thu_hoi : 0;
            $so_tien_phi_da_thu_hoi_tien_thua = !empty($item->so_tien_phi_da_thu_hoi_tien_thua) ? $item->so_tien_phi_da_thu_hoi_tien_thua : 0;
            $so_tien_phi_da_thu_hoi_thang_truoc = !empty($item->so_tien_phi_da_thu_hoi) ? $item->so_tien_phi_da_thu_hoi : 0;
            $so_tien_phi_da_thu_hoi_thang_truoc=$so_tien_phi_da_thu_hoi_thang_truoc+ $so_tien_thua_tat_toan_da_thu_hoi+$so_tien_thua_thanh_toan_da_thu_hoi+$so_tien_phi_da_thu_hoi_tien_thua;
            $so_tien_lai_da_thu_hoi_tien_thua = !empty($item->so_tien_lai_da_thu_hoi_tien_thua) ? $item->so_tien_lai_da_thu_hoi_tien_thua : 0;
            $condition_last=[
                'code_contract'=>$item->code_contract,
                'status'=>1,
                'type'=>3,
                'ky_tt_xa_nhat' => $item->debt->ky_tt_xa_nhat,
                'status_contract_origin' => $item->status,
                'endMonth' => $startMonth,
            ];
            $status = $this->contract_model->getStatusContract($condition_last);
         $type_interest = !empty($item->loan_infor->type_interest) ? $item->loan_infor->type_interest: "";
         if($status=="Đang vay" && $type_interest==2)
           {
             $so_tien_phi_da_thu_hoi_thang_truoc=$so_tien_phi_da_thu_hoi_thang_truoc+ $so_tien_goc_da_thu_hoi_thang_truoc;
             $so_tien_goc_da_thu_hoi_thang_truoc=0;
           }

            $du_no_goc_thang_truoc = !empty($item->loan_infor->amount_money) ? $item->loan_infor->amount_money-$so_tien_goc_da_thu_hoi_thang_truoc : 0;
            $du_no_lai_thang_truoc = !empty($item->tien_lai_thang_truoc) ? $item->tien_lai_thang_truoc-$so_tien_lai_da_thu_hoi_thang_truoc- $so_tien_lai_da_thu_hoi_tien_thua : 0;
            $du_no_phi_thang_truoc = !empty($item->tien_phi_thang_truoc) ? $item->tien_phi_thang_truoc-$so_tien_phi_da_thu_hoi_thang_truoc  : 0;

           
            
         
            $tranDB = $this->contract_model->get_tran_one_tt($condition_last);
            if(!empty($tranDB) )
            {
              
                 $du_no_goc_thang_truoc = $tranDB['so_tien_goc_phai_tra_tat_toan']-$tranDB['so_tien_goc_da_tra'];
                 $du_no_lai_thang_truoc = $tranDB['so_tien_lai_phai_tra_tat_toan']-$tranDB['so_tien_lai_da_tra'];
                 $du_no_phi_thang_truoc = $tranDB['so_tien_phi_phai_tra_tat_toan']-$tranDB['so_tien_phi_da_tra']+$tranDB['tien_thua_thanh_toan'];
                
            }
            if(date('Y-m',$disbursement_date)==date('Y-m',$item->plan_contract[0]->time_timestamp))
            {
              $du_no_goc_thang_truoc=0;
              $du_no_lai_thang_truoc=0;
              $du_no_phi_thang_truoc=0;
            }

          if($status=="Gia hạn")
          {
            $du_no_goc_thang_truoc =0;
           
            $so_tien_phi_da_thu_hoi_thang_truoc=$so_tien_phi_da_thu_hoi_thang_truoc- $so_tien_thua_tat_toan_da_thu_hoi-$so_tien_thua_thanh_toan_da_thu_hoi;
           
            $du_no_lai_thang_truoc = !empty($item->tien_lai_thang_truoc) ? $item->tien_lai_thang_truoc-$so_tien_lai_da_thu_hoi_thang_truoc- $so_tien_lai_da_thu_hoi_tien_thua : 0;
            $du_no_phi_thang_truoc = !empty($item->tien_phi_thang_truoc) ? $item->tien_phi_thang_truoc-$so_tien_phi_da_thu_hoi_thang_truoc  : 0;

          }
          return ['du_no_goc_thang_truoc'=>$du_no_goc_thang_truoc,'du_no_lai_thang_truoc'=>$du_no_lai_thang_truoc,'du_no_phi_thang_truoc'=>$du_no_phi_thang_truoc];
    }
    private function getP($item) {
        $so_tien_goc_da_thu_hoi_cac_thang_truoc = !empty($item->so_tien_goc_da_thu_hoi) ? $item->so_tien_goc_da_thu_hoi : 0;
        $N = $this->getN($item);
        return $N - $so_tien_goc_da_thu_hoi;
    }
    
  private function getN($item) {
        //Số tiền giải ngân
        $amount = 0;
        if(empty($item->count_extend)) {
            $amount = !empty($item->loan_infor->amount_money) ? $item->loan_infor->amount_money : 0;
        }
        return $amount;
    }
}
?>

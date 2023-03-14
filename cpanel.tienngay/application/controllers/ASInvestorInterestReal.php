
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ASInvestorInterestReal extends MY_Controller{
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
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $this->spreadsheet = new Spreadsheet();
        $this->sheet = $this->spreadsheet->getActiveSheet();
        
        $this->tong_BangLaiThuc = array(
            "so_tien_vay" => 0, //L4
            "du_no_goc_thang_truoc" => 0, //N4
            "du_no_lai_thang_truoc" => 0, //O4
            "so_ngay_tinh_lai_thang" => 0, //P4
            "lai_vay_tra_NDT" => 0, //Q4
            "thue_TTCN_tra_thay_NDT" => 0, //R4
            
            "so_tien_goc_NDT_da_tra" => 0,
            "so_tien_lai_NDT_da_tra" => 0,
            "so_tien_goc_con_lai" => 0,
            "so_tien_lai_con_lai" => 0,
          
        );
        $this->numberRowLastColumn = 0;
    }
    
    private $tong_BangLaiThuc, $numberRowLastColumn;
    
    private $startMonth, $endMonth, $getStyle, $startColumnMergeFirstRow, $spreadsheet, $sheet, $colEx, $colExLoanInfor, $colExFeeTable, $colExValue;
    
    //Bảng lãi thực NĐT
    public function index() {
        $this->data["pageName"] = "Bảng lãi thực NĐT";
        $this->data['template'] = 'web/accounting_system_update/interest_real_investor';
        $this->load->view('template', isset($this->data) ? $this->data:NULL);
    }
    
    public function doInterestRealInvestor() {
        $start = !empty($_GET['fdate_export']) ? $_GET['fdate_export'] : "";
        if(empty($start)){
            $this->session->set_flashdata('error', "Hãy chọn tháng");
            redirect(base_url('accountingSystemUpdate/interestRealInvestor'));
        }
        
        $data = array();
        if(!empty($start)) $data['start'] = $start;
        
        $infor = $this->api->apiPost($this->userInfo['token'], "accountingSystemUpdate/interest_real_investor", $data);
        //Calculate to export excel
        if(!empty($infor->data)) {
            $this->exportInterestReal_part1($infor->data);
            $this->exportInterestReal_part2($infor->data);
            $this->exportInterestReal_part3($infor->data);
            $this->exportInterestReal_part4($infor->data);
            
            $this->lastRow_Tong_BangLaiThuc();
            
            //-------------------------------
            $this->callLibExcel('data-interest-real-investor-'.date('d-m-Y-H:i:s-').$start.'.xlsx');
            
        } else {
            $this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
            redirect(base_url('aSInvestorInterestReal'));
        }
    }
    
    private function exportInterestReal_part1($contracts) {
        $this->startColumnMergeFirstRow = $this->startColumnMergeFirstRow + 13;
        $this->sheet->mergeCells("A1:M1");
        $this->sheet->setCellValue('A1', 'Thông tin hợp đồng vay');
        $this->sheet->setCellValue('A2', 'STT');
        $this->sheet->setCellValue('B2', 'Mã Hợp đồng vay');
        $this->sheet->setCellValue('C2', 'Thời hạn vay (ngày)');
        $this->sheet->setCellValue('D2', 'Ngày giải ngân');
        $this->sheet->setCellValue('E2', 'Ngày đáo hạn');
        $this->sheet->setCellValue('F2', 'Tên người vay');
        $this->sheet->setCellValue('G2', 'Mã người vay ( trùng CMT)');
        $this->sheet->setCellValue('H2', 'Tên nhà đầu tư');
        $this->sheet->setCellValue('I2', 'Mã NĐT');
        $this->sheet->setCellValue('J2', 'Phòng giao dịch giải ngân');
        $this->sheet->setCellValue('K2', 'Hình thức cầm cố');
        $this->sheet->setCellValue('L2', 'Số tiền vay');
        $this->sheet->setCellValue('M2', 'Hình thức tính lãi');
        
        //Set style
        $this->setStyle("A1:M1");
        
        $i = 4;
        $this->numberRowLastColumn = 4;
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
            $amount = $this->get_L4($item);
            //$amountExtend = !empty($item->amount_extend) ? $item->amount_extend : 0;
            $this->sheet->setCellValue('A'.$i, $index);
            $index++;

            $this->sheet->setCellValue('B'.$i, !empty($item->code_contract_disbursement) ? $item->code_contract_disbursement : $item->code_contract); 
            $this->sheet->setCellValue('C'.$i, $item->loan_infor->number_day_loan); 
            $this->sheet->setCellValue('D'.$i, !empty($item->disbursement_date) ? $this->time_model->convertTimestampToDatetime($item->disbursement_date) : ""); 
            $this->sheet->setCellValue('E'.$i, !empty($item->expire_date) ? $this->time_model->convertTimestampToDatetime($item->expire_date) : "");
            $this->sheet->setCellValue('F'.$i, $item->customer_infor->customer_name);
            $this->sheet->setCellValue('G'.$i, $item->customer_infor->customer_identify);
            $this->sheet->setCellValue('H'.$i, !empty($item->investor_infor->name) ? $item->investor_infor->name : "");
            $this->sheet->setCellValue('I'.$i, !empty($item->investor_infor->code) ? $item->investor_infor->code : "");
            $this->sheet->setCellValue('J'.$i, !empty($item->store->name) ? $item->store->name : "");
            $this->sheet->setCellValue('K'.$i, !empty($item->loan_infor) && !empty($item->loan_infor->type_loan->code) && !empty($item->loan_infor->type_property->code) ? $item->loan_infor->type_loan->code.'-'.$item->loan_infor->type_property->code : "");
            
            $this->sheet->setCellValue('L'.$i, $amount);
            $this->sheet->setCellValue('M'.$i, $typePay);
           
            $this->tong_BangLaiThuc['so_tien_vay'] = $this->tong_BangLaiThuc['so_tien_vay'] + $amount;
            
            $i++;
            $this->numberRowLastColumn++;
        }
    }
    
    private function get_L4($item) {
        $amount = 0;
        if(empty($item->count_extend)) {
            $amount = !empty($item->receiver_infor->amount) ? $item->receiver_infor->amount : 0;
        }
        return $amount;
    }
    
    private function exportInterestReal_part2($contracts) {
        $this->startColumnMergeFirstRow = $this->startColumnMergeFirstRow + 2;
        $this->sheet->mergeCells("N1:N2");
        $this->sheet->mergeCells("O1:O2");
        $this->sheet->setCellValue('N1', 'Gốc tháng trước');
        $this->sheet->setCellValue('O1', 'Lãi tháng trước');
        
        //Set style
        $this->setStyle("N1:N2");
        $this->setStyle("O1:O2");
        
        $i = 4;
        foreach($contracts as $item){
            $du_no_goc_thang_truoc = $this->get_N4($item);
            $du_no_lai_thang_truoc = $this->get_O4($item);
            
            $this->sheet->setCellValue('N'.$i, $du_no_goc_thang_truoc); 
            $this->sheet->setCellValue('O'.$i, $du_no_lai_thang_truoc); 
            
            $this->tong_BangLaiThuc['du_no_goc_thang_truoc'] = $this->tong_BangLaiThuc['du_no_goc_thang_truoc'] + $du_no_goc_thang_truoc;
            $this->tong_BangLaiThuc['du_no_lai_thang_truoc'] = $this->tong_BangLaiThuc['du_no_lai_thang_truoc'] + $du_no_lai_thang_truoc;
           
            $i++;
        }
    }
    
    private function get_N4($item) {
        return !empty($item->plan_contract[0]->goc_con_lai_chua_thu_thang_truoc) ? $item->plan_contract[0]->goc_con_lai_chua_thu_thang_truoc : 0;
    }
    
    private function get_O4($item) {
        return !empty($item->plan_contract[0]->du_no_lai_thang_truoc) ? $item->plan_contract[0]->du_no_lai_thang_truoc : 0;
    }
    
    private function exportInterestReal_part3($contracts) {
        $this->startColumnMergeFirstRow = $this->startColumnMergeFirstRow + 3;
        $this->sheet->mergeCells("P1:R1");
        $this->sheet->setCellValue('P1', 'Lãi + phí tính đến thời điểm cuối tháng');
        $this->sheet->setCellValue('P2', 'Số ngày tính lãi tháng');
        $this->sheet->setCellValue('Q2', 'Lãi vay (trả nhà ĐT)');
        $this->sheet->setCellValue('R2', 'Thuế TNCN trả thay NĐT');
        //Set style
        $this->setStyle("P1:R1");
        
        $i = 4;
        
        foreach($contracts as $item){
            $count_date_interest = !empty($item->plan_contract[0]->count_date_interest) ? $item->plan_contract[0]->count_date_interest : 0;
            //Lãi vay (trả nhà ĐT)
            $interestPayInvestor = $this->get_Q4($item); 
            //Thuế TNCN trả thay NDT
            $thue_TNCN_tra_thay_NDT = $interestPayInvestor * 5 / 100;
        
            $this->sheet->setCellValue('P'.$i, $count_date_interest); 
            $this->sheet->setCellValue('Q'.$i, $interestPayInvestor); 
            $this->sheet->setCellValue('R'.$i, $thue_TNCN_tra_thay_NDT); 
            
            $this->tong_BangLaiThuc['so_ngay_tinh_lai_thang'] = $this->tong_BangLaiThuc['so_ngay_tinh_lai_thang'] + $count_date_interest;
            $this->tong_BangLaiThuc['lai_vay_tra_NDT'] = $this->tong_BangLaiThuc['lai_vay_tra_NDT'] + $interestPayInvestor;
            $this->tong_BangLaiThuc['thue_TTCN_tra_thay_NDT'] = $this->tong_BangLaiThuc['thue_TTCN_tra_thay_NDT'] + $thue_TNCN_tra_thay_NDT;
            
            $i++;
        }
    }
    
    private function exportInterestReal_part4($contracts) {
        $this->startColumnMergeFirstRow = $this->startColumnMergeFirstRow + 13;
        $this->sheet->setCellValue('S2', 'Số tiền gốc NĐT đã trả');
        $this->sheet->setCellValue('T2', 'Số tiền lãi NĐT đã trả');
        $this->sheet->setCellValue('U2', 'Số tiền gốc còn lại');
        $this->sheet->setCellValue('V2', 'Số tiền lãi NĐT còn lại');
        $this->sheet->setCellValue('W2', 'Trạng thái');
        
        $i = 4;
        $this->numberRowLastColumn = 4;
        
        foreach($contracts as $item){
            $so_tien_goc_NDT_da_tra = $this->get_S4($item);
            $so_tien_lai_NDT_da_tra = $this->get_T4($item);
            $so_tien_goc_con_lai = $this->get_U4($item);
            $so_tien_lai_NDT_con_lai = $this->get_V4($item);

            $this->sheet->setCellValue('S'.$i, $so_tien_goc_NDT_da_tra); 
            $this->sheet->setCellValue('T'.$i, $so_tien_lai_NDT_da_tra); 
            $this->sheet->setCellValue('U'.$i, $so_tien_goc_con_lai); 
            $this->sheet->setCellValue('V'.$i, $so_tien_lai_NDT_con_lai);
            $this->sheet->setCellValue('W'.$i, $this->getStatusContract($item));
            
            $this->tong_BangLaiThuc['so_tien_goc_NDT_da_tra'] = $this->tong_BangLaiThuc['so_tien_goc_NDT_da_tra'] + $so_tien_goc_NDT_da_tra;
            $this->tong_BangLaiThuc['so_tien_lai_NDT_da_tra'] = $this->tong_BangLaiThuc['so_tien_lai_NDT_da_tra'] + $so_tien_lai_NDT_da_tra;
            $this->tong_BangLaiThuc['so_tien_goc_con_lai'] = $this->tong_BangLaiThuc['so_tien_goc_con_lai'] + $so_tien_goc_con_lai;
            $this->tong_BangLaiThuc['so_tien_lai_con_lai'] = $this->tong_BangLaiThuc['so_tien_lai_con_lai'] + $so_tien_lai_NDT_con_lai;
            
            $i++;
            $this->numberRowLastColumn++;
        }
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
    
    private function lastRow_Tong_BangLaiThuc() {
        $this->sheet->setCellValue('B'.$this->numberRowLastColumn, "Tổng")
                    ->getStyle('B'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        //L4
        $this->sheet->setCellValue('L'.$this->numberRowLastColumn, $this->tong_BangLaiThuc['so_tien_vay'])
                    ->getStyle('L'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        //N4
        $this->sheet->setCellValue('N'.$this->numberRowLastColumn, $this->tong_BangLaiThuc['du_no_goc_thang_truoc'])
                    ->getStyle('N'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        //O4
        $this->sheet->setCellValue('O'.$this->numberRowLastColumn, $this->tong_BangLaiThuc['du_no_lai_thang_truoc'])
                    ->getStyle('O'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        //P4
        $this->sheet->setCellValue('P'.$this->numberRowLastColumn, $this->tong_BangLaiThuc['so_ngay_tinh_lai_thang'])
                    ->getStyle('P'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        //Q4
        $this->sheet->setCellValue('Q'.$this->numberRowLastColumn, $this->tong_BangLaiThuc['lai_vay_tra_NDT'])
                    ->getStyle('Q'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        //R4
        $this->sheet->setCellValue('R'.$this->numberRowLastColumn, $this->tong_BangLaiThuc['thue_TTCN_tra_thay_NDT'])
                    ->getStyle('R'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        //S4
        $this->sheet->setCellValue('S'.$this->numberRowLastColumn, $this->tong_BangLaiThuc['so_tien_goc_NDT_da_tra'])
                    ->getStyle('S'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        //T4
        $this->sheet->setCellValue('T'.$this->numberRowLastColumn, $this->tong_BangLaiThuc['so_tien_lai_NDT_da_tra'])
                    ->getStyle('T'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        
        //U4
        $this->sheet->setCellValue('U'.$this->numberRowLastColumn, $this->tong_BangLaiThuc['so_tien_goc_con_lai'])
                    ->getStyle('U'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        
        //V4
        $this->sheet->setCellValue('V'.$this->numberRowLastColumn, $this->tong_BangLaiThuc['so_tien_lai_con_lai'])
                    ->getStyle('V'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        
    }
    
    private function getStatusContract($item) {
        //Trạng thái HĐ
        $status = "";
        //Đang vay
        if($item->status == 17) {
            $status = "Đang vay";
        } 
        //Tất toán
        else if($item->status == 19) {
            $status = "Tất toán";
        } 
        //Đã gia hạn
        else if($item->status == 23) {
            $status = "Đã gia hạn";
        } 
        //Quá hạn
        else if($item->status == 20) {
            $status = "Quá hạn";
        }
        return $status;
    }
    
    private function get_Q4($item) {
        $laiVayPhaiTraNDT = 0;
        $goc_con_lai_chua_thu_cuoi_thang_hien_tai = !empty($item->plan_contract[0]->goc_con_lai_chua_thu_cuoi_thang_hien_tai) ? $item->plan_contract[0]->goc_con_lai_chua_thu_cuoi_thang_hien_tai : 0;
        //Dư  giảm dần
        if($item->loan_infor->type_interest == 1) {
            $laiVayPhaiTraNDT = ($goc_con_lai_chua_thu_cuoi_thang_hien_tai * $item->fee->percent_interest_customer / 100) * $item->plan_contract[0]->count_date_interest / 30;
        } 
        //Lãi hàng tháng, gốc cuối kì
        else if($item->loan_infor->type_interest == 2) {
            $laiVayPhaiTraNDT = ($item->loan_infor->amount_money * $item->fee->percent_interest_customer / 100) * $item->plan_contract[0]->count_date_interest / 30;
        }
        return $laiVayPhaiTraNDT;
    }
    
    
    private function get_S4($item) {
        return !empty($item->so_tien_goc_da_thu_hoi_thang_hien_tai) ? $item->so_tien_goc_da_thu_hoi_thang_hien_tai : 0;
    }
    
    private function get_T4($item) {
        return !empty($item->so_tien_lai_da_thu_hoi_thang_hien_tai) ? $item->so_tien_lai_da_thu_hoi_thang_hien_tai : 0;
    }
    
    private function get_U4($item) {
        // IF(N4=0,L4-S4,N4-S4)
        if($this->get_N4($item) == 0) {
            return $this->get_L4($item) - $this->get_S4($item);
        } else {
            return $this->get_N4($item) - $this->get_S4($item);
        }
    }
    
    private function get_V4($item) {
        // =O4+Q4-T4
        return $this->get_O4($item) + $this->get_Q4($item) - $this->get_T4($item);
    }
}
?>

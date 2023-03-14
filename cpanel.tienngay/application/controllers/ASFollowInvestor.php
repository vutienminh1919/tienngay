<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ASFollowInvestor extends MY_Controller{
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
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $this->tong = array(
           'so_tien_cho_vay' => 0,
            'du_no_phai_tra_goc_thang_truoc' => 0,
            'du_no_phai_tra_lai_thang_truoc' => 0,
            'so_tien_goc_phai_tra' => 0,
            'so_tien_lai_phai_tra' => 0,
            'so_tien_goc_phai_tra_den_thoi_den_dao_han' => 0,
            'so_tien_lai_phai_tra_den_thoi_den_dao_han' => 0,
            
            'so_tien_goc_da_tra_NDT_luy_ke_thang_truoc' => 0,
            'so_tien_lai_da_tra_NDT_luy_ke_thang_truoc' => 0,
            'so_tien_goc_da_tra_NDT_thang_hien_tai' => 0,
            'so_tien_lai_da_tra_NDT_thang_hien_tai' => 0,
            'so_tien_goc_da_tra_NDT_luy_ke' => 0,
            'so_tien_lai_da_tra_NDT_luy_ke' => 0,
            'so_lai_con_lai_phai_tra_NDT' => 0,
            'so_lai_con_goc_phai_tra_NDT' => 0
            
        );
        
        $this->numberRowLastColumn = 0;
    }
    
    private $tong, $numberRowLastColumn;
    
    private $getStyle, $spreadsheet, $sheet;
    
    public function index() {
        $this->data["pageName"] = "Theo dõi NĐT";
        $this->data['template'] = 'web/accounting_system_update/follow_investor';
        $this->load->view('template', isset($this->data) ? $this->data:NULL);
    }
    
    public function process() {
        $start = !empty($_GET['fdate_export']) ? $_GET['fdate_export'] : "";
        if(empty($start)){
            $this->session->set_flashdata('error', "Hãy chọn tháng");
            redirect(base_url('aSFollowInvestor'));
        }
        $data = array();
        if(!empty($start)) $data['start'] = $start;
        $infor = $this->api->apiPost($this->userInfo['token'], "accountingSystemUpdate/follow_investor", $data);
        //Calculate to export excel
        if(!empty($infor->data)) {
            $this->export_part1($infor->data);
            $this->export_part2($infor->data);
            $this->export_part3($infor->data);
            $this->export_part4($infor->data);
            $this->export_part5($infor->data);
            $this->lastRow_Tong();
            //-------------------------------
            $this->callLibExcel('data-follow-investor-'.time().'.xlsx');
            
        } else {
            $this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
            redirect(base_url('aSFollowInvestor'));
        }
        
        
//        $infor = $this->getData($start);
////        echo"<pre>";
////        var_dump($infor);
////        die;
//        
//        if(!empty($infor)) {
//            $this->export_part1($infor);
//            $this->export_part2($infor);
//            $this->export_part3($infor);
//            $this->export_part4($infor);
//            $this->export_part5($infor);
//            $this->lastRow_Tong();
//            //-------------------------------
//            $this->callLibExcel('data-follow-investor-'.time().'.xlsx');
//        } else {
//            $this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
//            redirect(base_url('aSFollowInvestor'));
//        }
    }
    
    private function export_part1($contracts) {
        $this->sheet->setCellValue('A2', 'STT');
        $this->sheet->setCellValue('B2', 'Mã HĐ vay');
        $this->sheet->setCellValue('C2', 'Nhà đầu tư');
        $this->sheet->setCellValue('D2', 'Mã nhà đầu tư');
        $this->sheet->setCellValue('E2', 'Thời hạn vay (ngày)');
        $this->sheet->setCellValue('F2', 'Ngày giải ngân');
        $this->sheet->setCellValue('G2', 'Ngày đáo hạn');
        $this->sheet->setCellValue('H2', 'Tên người vay');
        $this->sheet->setCellValue('I2', 'Phòng giao dịch giải ngân');
        $this->sheet->setCellValue('J2', 'Số tiền cho vay');
        $this->sheet->setCellValue('K2', '%Lãi vay');
        $this->sheet->setCellValue('L2', 'Hình thức tính lãi');
        
        //Set style
        $this->setStyle("A2");
        $this->setStyle("B2");
        $this->setStyle("C2");
        $this->setStyle("D2");
        $this->setStyle("E2");
        $this->setStyle("F2");
        $this->setStyle("G2");
        $this->setStyle("H2");
        $this->setStyle("I2");
        $this->setStyle("J2");
        $this->setStyle("K2");
        $this->setStyle("L2");
        
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
            $amount = $this->get_J4($item);
            $this->sheet->setCellValue('A'.$i, $index);
            $this->sheet->setCellValue('B'.$i, !empty($item->code_contract_disbursement) ? $item->code_contract_disbursement : $item->code_contract); 
            $this->sheet->setCellValue('C'.$i, !empty($item->investor_infor->name) ? $item->investor_infor->name : "");
            $this->sheet->setCellValue('D'.$i, !empty($item->investor_infor->code) ? $item->investor_infor->code : "");
            $this->sheet->setCellValue('E'.$i, $item->loan_infor->number_day_loan); 
            $this->sheet->setCellValue('F'.$i, !empty($item->disbursement_date) ? $this->time_model->convertTimestampToDatetime($item->disbursement_date) : ""); 
            $this->sheet->setCellValue('G'.$i, !empty($item->expire_date) ? $this->time_model->convertTimestampToDatetime($item->expire_date) : "");
            $this->sheet->setCellValue('H'.$i, $item->customer_infor->customer_name);
            $this->sheet->setCellValue('I'.$i, !empty($item->store->name) ? $item->store->name : "");
            $this->sheet->setCellValue('J'.$i, $amount);
            $this->sheet->setCellValue('K'.$i, !empty($item->fee) ? $item->fee->percent_interest_customer : "");
            $this->sheet->setCellValue('L'.$i, $typePay);
                    
            $this->tong['so_tien_cho_vay'] = $this->tong['so_tien_cho_vay'] + $amount;
            
            $index++;
            $i++;
            $this->numberRowLastColumn++;
        }
    }
    
    private function get_J4($item) {
        $amount = 0;
        if(empty($item->count_extend)) {
            $amount = !empty($item->receiver_infor->amount) ? $item->receiver_infor->amount : 0;
        }
        return $amount;
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
    
    private function lastRow_Tong() {
        $this->sheet->setCellValue('B'.$this->numberRowLastColumn, "Tổng")
                    ->getStyle('B'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        //J4
        $this->sheet->setCellValue('J'.$this->numberRowLastColumn, $this->tong['so_tien_cho_vay'])
                    ->getStyle('J'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        //M4
        $this->sheet->setCellValue('M'.$this->numberRowLastColumn, $this->tong['du_no_phai_tra_goc_thang_truoc'])
                    ->getStyle('M'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        //N4
        $this->sheet->setCellValue('N'.$this->numberRowLastColumn, $this->tong['du_no_phai_tra_lai_thang_truoc'])
                    ->getStyle('N'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        //O4
        $this->sheet->setCellValue('O'.$this->numberRowLastColumn, $this->tong['so_tien_goc_phai_tra'])
                    ->getStyle('O'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        //P4
        $this->sheet->setCellValue('P'.$this->numberRowLastColumn, $this->tong['so_tien_lai_phai_tra'])
                    ->getStyle('P'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        //Q4
        $this->sheet->setCellValue('Q'.$this->numberRowLastColumn, $this->tong['so_tien_goc_phai_tra_den_thoi_den_dao_han'])
                    ->getStyle('Q'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        //R4
        $this->sheet->setCellValue('R'.$this->numberRowLastColumn, $this->tong['so_tien_lai_phai_tra_den_thoi_den_dao_han'])
                    ->getStyle('R'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        //S4
        $this->sheet->setCellValue('S'.$this->numberRowLastColumn, $this->tong['so_tien_lai_da_tra_NDT_luy_ke_thang_truoc'])
                    ->getStyle('S'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        //T4
        $this->sheet->setCellValue('T'.$this->numberRowLastColumn, $this->tong['so_tien_goc_da_tra_NDT_luy_ke_thang_truoc'])
                    ->getStyle('T'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        //U4
        $this->sheet->setCellValue('U'.$this->numberRowLastColumn, $this->tong['so_tien_lai_da_tra_NDT_thang_hien_tai'])
                    ->getStyle('U'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        //V4
        $this->sheet->setCellValue('V'.$this->numberRowLastColumn, $this->tong['so_tien_goc_da_tra_NDT_thang_hien_tai'])
                    ->getStyle('V'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        //W4
        $this->sheet->setCellValue('W'.$this->numberRowLastColumn, $this->tong['so_tien_lai_da_tra_NDT_luy_ke'])
                    ->getStyle('W'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        //X4
        $this->sheet->setCellValue('X'.$this->numberRowLastColumn, $this->tong['so_tien_goc_da_tra_NDT_luy_ke'])
                    ->getStyle('X'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        //Y4
        $this->sheet->setCellValue('Y'.$this->numberRowLastColumn, $this->tong['so_lai_con_lai_phai_tra_NDT'])
                    ->getStyle('Y'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        //Z4
        $this->sheet->setCellValue('Z'.$this->numberRowLastColumn, $this->tong['so_goc_con_lai_phai_tra_NDT'])
                    ->getStyle('Z'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
      
    }
    
    private function export_part2($contracts) {
        $this->sheet->setCellValue('M2', 'Gốc phải trả gốc tháng trước');
        $this->sheet->setCellValue('N2', 'Lãi phải trả lãi tháng trước');
        //Set style
        $this->setStyle("M2");
        $this->setStyle("N2");
        $i = 3;
        foreach($contracts as $item){
            $du_no_phai_tra_goc_thang_truoc = $this->get_M4($item);
            $du_no_phai_tra_lai_thang_truoc = $this->get_N4($item);
            
            $this->sheet->setCellValue('M'.$i, $du_no_phai_tra_goc_thang_truoc); 
            $this->sheet->setCellValue('N'.$i, $du_no_phai_tra_lai_thang_truoc); 
           
            $this->tong['du_no_phai_tra_goc_thang_truoc'] = $this->tong['du_no_phai_tra_goc_thang_truoc'] + $du_no_phai_tra_goc_thang_truoc;
            $this->tong['du_no_phai_tra_lai_thang_truoc'] = $this->tong['du_no_phai_tra_lai_thang_truoc'] + $du_no_phai_tra_lai_thang_truoc;
            
            $i++;
        }
    }
    
    private function export_part3($contracts) {
        $this->sheet->mergeCells("O1:P1");
        $this->sheet->setCellValue('O1', 'Tháng Tn');
        $this->sheet->setCellValue('O2', 'Số tiền gốc phải trả');
        $this->sheet->setCellValue('P2', 'Số tiền lãi phải trả');
        
        //Set style
        $this->setStyle("O1:P1");
        $this->setStyle("O2");
        $this->setStyle("P2");
        
        $i = 3;
        foreach($contracts as $item){

            $so_tien_goc_phai_tra = !empty($item->bang_lai_ky[0]->tien_goc_1ky_phai_tra) ? $item->bang_lai_ky[0]->tien_goc_1ky_phai_tra : 0;
            $so_tien_lai_phai_tra = $this->get_P4($item);
            
            $this->sheet->setCellValue('O'.$i, $so_tien_goc_phai_tra); 
            $this->sheet->setCellValue('P'.$i, $so_tien_lai_phai_tra); 
           
            $this->tong['so_tien_goc_phai_tra'] = $this->tong['so_tien_goc_phai_tra'] + $so_tien_goc_phai_tra;
            $this->tong['so_tien_lai_phai_tra'] = $this->tong['so_tien_lai_phai_tra'] + $so_tien_lai_phai_tra;
            
            $i++;
        }
    }
    
    private function get_P4($item) {
        return !empty($item->bang_lai_ky[0]->tien_lai_1ky_phai_tra) ? $item->bang_lai_ky[0]->tien_lai_1ky_phai_tra : 0;
    }
    
    private function export_part4($contracts) {
        $this->sheet->mergeCells("Q1:R1");
        $this->sheet->setCellValue('Q1', 'Đến cuối kỳ');
        $this->sheet->setCellValue('Q2', 'Số tiền gốc phải trả');
        $this->sheet->setCellValue('R2', 'Số tiền lãi phải trả');
        
        //Set style
        $this->setStyle("Q1:R1");
        $this->setStyle("Q2");
        $this->setStyle("R2");
        
        $i = 3;
        foreach($contracts as $item){

            $so_tien_goc_phai_tra_den_thoi_diem_dao_han = !empty($item->goc_vay_phai_thu_den_thoi_diem_dao_han) ? $item->goc_vay_phai_thu_den_thoi_diem_dao_han : 0;
            $so_tien_lai_phai_tra_den_thoi_diem_dao_han = !empty($item->lai_vay_phai_tra_NDT_den_thoi_diem_dao_han) ? $item->lai_vay_phai_tra_NDT_den_thoi_diem_dao_han : 0;
            
            $this->sheet->setCellValue('Q'.$i, $so_tien_goc_phai_tra_den_thoi_diem_dao_han); 
            $this->sheet->setCellValue('R'.$i, $so_tien_lai_phai_tra_den_thoi_diem_dao_han); 
           
            $this->tong['so_tien_goc_phai_tra_den_thoi_den_dao_han'] = $this->tong['so_tien_goc_phai_tra_den_thoi_den_dao_han'] + $so_tien_goc_phai_tra_den_thoi_diem_dao_han;
            $this->tong['so_tien_lai_phai_tra_den_thoi_den_dao_han'] = $this->tong['so_tien_lai_phai_tra_den_thoi_den_dao_han'] + $so_tien_lai_phai_tra_den_thoi_diem_dao_han;
            
            $i++;
        }
    }
    
    private function export_part5($contracts) {
        $this->sheet->setCellValue('S2', 'Số tiền lãi đã trả lũy kế tháng trước');
        $this->sheet->setCellValue('T2', 'Số tiền gốc đã trả lũy kế tháng trươc');
        $this->sheet->setCellValue('U2', 'Số tiền lãi đã trả');
        $this->sheet->setCellValue('V2', 'Số tiền gốc đã trả');
        $this->sheet->setCellValue('W2', 'Số tiền lãi lũy kế đã trả');
        $this->sheet->setCellValue('X2', 'Số tiền gốc lũy kế đã trả');
        $this->sheet->setCellValue('Y2', 'Số lãi còn lại phải trả NĐT');
        $this->sheet->setCellValue('Z2', 'Số gốc còn lại phải trả NĐT');
        $this->sheet->setCellValue('AA2', 'Trạng thái');
        
        //Set style
        $this->setStyle("S2");
        $this->setStyle("T2");
        $this->setStyle("U2");
        $this->setStyle("V2");
        $this->setStyle("W2");
        $this->setStyle("X2");
        $this->setStyle("Y2");
        $this->setStyle("Z2");
        $this->setStyle("AA2");
        
        $i = 3;
        $this->numberRowLastColumn = 3;
        $index = 1;
        foreach($contracts as $item){
            
            $so_tien_lai_da_tra_NDT_luy_ke_thang_truoc = !empty($item->so_tien_lai_da_tra_NDT_luy_ke_thang_truoc) ? $item->so_tien_lai_da_tra_NDT_luy_ke_thang_truoc : 0;
            $so_tien_goc_da_tra_NDT_luy_ke_thang_truoc = !empty($item->so_tien_goc_da_tra_NDT_luy_ke_thang_truoc) ? $item->so_tien_goc_da_tra_NDT_luy_ke_thang_truoc : 0;
            $so_tien_lai_da_tra_thang_hien_tai = $this->get_U4($item);
            $so_tien_goc_da_tra_thang_hien_tai = $this->get_V4($item);
            $so_tien_lai_da_tra_NDT_luy_ke = !empty($item->so_tien_lai_da_tra_NDT_luy_ke) ? $item->so_tien_lai_da_tra_NDT_luy_ke : 0;
            $so_tien_goc_da_tra_NDT_luy_ke = !empty($item->so_tien_goc_da_tra_NDT_luy_ke) ? $item->so_tien_goc_da_tra_NDT_luy_ke : 0;
            
            $Y = $this->getColumnY($item);
            $Z = $this->getColumnZ($item);
            
            $this->sheet->setCellValue('S'.$i, $so_tien_lai_da_tra_NDT_luy_ke_thang_truoc);
            $this->sheet->setCellValue('T'.$i, $so_tien_goc_da_tra_NDT_luy_ke_thang_truoc); 
            $this->sheet->setCellValue('U'.$i, $so_tien_lai_da_tra_thang_hien_tai);
            $this->sheet->setCellValue('V'.$i, $so_tien_goc_da_tra_thang_hien_tai);
            $this->sheet->setCellValue('W'.$i, $so_tien_lai_da_tra_NDT_luy_ke); 
            $this->sheet->setCellValue('X'.$i, $so_tien_goc_da_tra_NDT_luy_ke); 
            $this->sheet->setCellValue('Y'.$i, $Y);
            $this->sheet->setCellValue('Z'.$i, $Z);
            $this->sheet->setCellValue('AA'.$i, $this->getStatusContract($item));
                    
            $this->tong['so_tien_goc_da_tra_NDT_luy_ke_thang_truoc'] = $this->tong['so_tien_goc_da_tra_NDT_luy_ke_thang_truoc'] + $so_tien_goc_da_tra_NDT_luy_ke_thang_truoc;
            $this->tong['so_tien_lai_da_tra_NDT_luy_ke_thang_truoc'] = $this->tong['so_tien_lai_da_tra_NDT_luy_ke_thang_truoc'] + $so_tien_lai_da_tra_NDT_luy_ke_thang_truoc;
            $this->tong['so_tien_goc_da_tra_NDT_thang_hien_tai'] = $this->tong['so_tien_goc_da_tra_NDT_thang_hien_tai'] + $so_tien_goc_da_tra_thang_hien_tai;
            $this->tong['so_tien_lai_da_tra_NDT_thang_hien_tai'] = $this->tong['so_tien_lai_da_tra_NDT_thang_hien_tai'] + $so_tien_lai_da_tra_thang_hien_tai;
            $this->tong['so_tien_goc_da_tra_NDT_luy_ke'] = $this->tong['so_tien_goc_da_tra_NDT_luy_ke'] + $so_tien_goc_da_tra_NDT_luy_ke;
            $this->tong['so_tien_lai_da_tra_NDT_luy_ke'] = $this->tong['so_tien_lai_da_tra_NDT_luy_ke'] + $so_tien_lai_da_tra_NDT_luy_ke;
            $this->tong['so_lai_con_lai_phai_tra_NDT'] = $this->tong['so_lai_con_lai_phai_tra_NDT'] + $Y;
            $this->tong['so_goc_con_lai_phai_tra_NDT'] = $this->tong['so_goc_con_lai_phai_tra_NDT'] + $Z;
            
            $index++;
            $i++;
            $this->numberRowLastColumn++;
        }
    }
    
    private function get_U4($item) {
        return !empty($item->so_tien_lai_da_tra_NDT_thang_hien_tai) ? $item->so_tien_lai_da_tra_NDT_thang_hien_tai : 0;
    }
    
    private function get_V4($item) {
        return !empty($item->so_tien_goc_da_tra_NDT_thang_hien_tai) ? $item->so_tien_goc_da_tra_NDT_thang_hien_tai : 0;
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
    
    private function getColumnY($item) {
        //N4 + P4 -U4
        return $this->get_N4($item) + $this->get_P4($item) - $this->get_U4($item);
    }
    
    private function getColumnZ($item) {
        $colZ = 0;
        //IF(M4=0,J4-V4,M4-V4)
        if($this->get_M4($item) == 0) {
            $colZ = $this->get_J4($item) - $this->get_V4($item);
        } else {
            $colZ = $this->get_M4($item) - $this->get_V4($item);
        }
        return $colZ;
    }
    
    private function get_M4($item) {
        //Tổng gốc phải trả tháng trước - bảng lãi kỳ = A
        $a = !empty($item->tong_goc_phai_tra_thang_truoc) ? $item->tong_goc_phai_tra_thang_truoc : 0;
        
        //Tổng gốc đã trả tháng trước - bang transaction = B
        $b = !empty($item->so_tien_goc_da_tra_NDT_luy_ke_thang_truoc) ? $item->so_tien_goc_da_tra_NDT_luy_ke_thang_truoc : 0;
        
        //Trả về = A - B
        return $a - $b;
        
//        $goc_da_vay_chua_tra_thang_truoc = 0;
//        foreach($item->bang_lai_ky_den_thang_Tn as $a) {
//            $tien_goc_1ky_con_lai = !empty($a->tien_goc_1ky_con_lai) ? $a->tien_goc_1ky_con_lai : 0;
//            $goc_da_vay_chua_tra_thang_truoc = $goc_da_vay_chua_tra_thang_truoc + $tien_goc_1ky_con_lai;
//        }
//        return $goc_da_vay_chua_tra_thang_truoc;
    }
    
    private function get_N4($item) {
        //Tổng lãi phải trả tháng trước - bảng lãi kỳ = A
        $a = !empty($item->tong_lai_phai_tra_thang_truoc) ? $item->tong_lai_phai_tra_thang_truoc : 0;
        
        //Tổng lãi đã trả tháng trước - bang transaction = B
        $b = !empty($item->so_tien_lai_da_tra_NDT_luy_ke_thang_truoc) ? $item->so_tien_lai_da_tra_NDT_luy_ke_thang_truoc : 0;
        
        //Trả về = A - B
        return $a - $b;
        
        
//        $lai_da_vay_chua_tra_thang_truoc = 0;
//        foreach($item->bang_lai_ky_den_thang_Tn as $a) {
//            $tien_lai_1ky_con_lai = !empty($a->tien_lai_1ky_con_lai) ? $a->tien_lai_1ky_con_lai : 0;
//            $lai_da_vay_chua_tra_thang_truoc = $lai_da_vay_chua_tra_thang_truoc + $tien_lai_1ky_con_lai;
//        }
//        return $lai_da_vay_chua_tra_thang_truoc;
        
        return !empty($item->du_no_phai_tra_lai_thang_truoc) ? $item->du_no_phai_tra_lai_thang_truoc : 0;
        
    }
    
    public function getData($start) {
        $startMonth = date('Y-m-01', strtotime($start)); // 2020-01-01
        $endMonth = date('Y-m-t', strtotime($start)); // 2020-01-31
        
        $condition = array();
        if(!empty($start)) {
            $condition['start'] = strtotime(trim($startMonth).' 00:00:00');
            $condition['end'] = strtotime(trim($endMonth).' 23:59:59');
        } 
        $contract = $this->contract_model->getFollowInvestor($condition);
        return $contract;
    }
}
?>

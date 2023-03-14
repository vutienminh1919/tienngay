
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ASPayInvestor extends MY_Controller{
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
        
        $this->tong = array(
            "so_tien_goc_da_tra" => 0,
            "so_tien_lai_da_tra" => 0,
        );
        
        $this->numberRowLastColumn = 0;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }
    
    private $tong, $numberRowLastColumn;
    
    private $getStyle, $spreadsheet, $sheet;
    
    //Thu hồi khoản vay
    public function index() {
        $this->data["pageName"] = "Thanh toán NĐT";
        $this->data['template'] = 'web/accounting_system_update/pay_investor';
        $this->load->view('template', isset($this->data) ? $this->data:NULL);
    }
    
    public function process() {
        $start = !empty($_GET['fdate_export']) ? $_GET['fdate_export'] : "";
        if(empty($start)){
            $this->session->set_flashdata('error', "Hãy chọn tháng");
            redirect(base_url('aSPayInvestor'));
        }
        
        $data = array();
        if(!empty($start)) $data['start'] = $start;
        $infor = $this->api->apiPost($this->userInfo['token'], "accountingSystemUpdate/get_pay_investor", $data);
        
        //Calculate to export excel
        if(!empty($infor->data)) {
            $this->export_part1($infor->data);
            $this->lastRow_Tong();
            
            //-------------------------------
            $this->callLibExcel('data-pay-investor-'.time().'.xlsx');
            
        } else {
            $this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
            redirect(base_url('aSRevokeLoan'));
        }
    }
    
    private function export_part1($trans) {
        $this->sheet->setCellValue('A1', 'STT');
        $this->sheet->setCellValue('B1', 'Ngày');
        $this->sheet->setCellValue('C1', 'Mã GD ngân hàng');
        $this->sheet->setCellValue('D1', 'Mã Hợp đồng');
        $this->sheet->setCellValue('E1', 'Tên NĐT');
        $this->sheet->setCellValue('F1', 'Số tiền gốc đã trả');
        $this->sheet->setCellValue('G1', 'Số tiền lãi đã trả');
        
        //Set style
        $this->setStyle("A1");
        $this->setStyle("B1");
        $this->setStyle("C1");
        $this->setStyle("D1");
        $this->setStyle("E1");
        $this->setStyle("F1");
        $this->setStyle("G1");
        
        $i = 2;
        $this->numberRowLastColumn = 2;
        $index = 1;
        foreach($trans as $item){
            
            $so_tien_goc_da_tra = !empty($item->so_tien_goc_da_tra) ? $item->so_tien_goc_da_tra : 0;
            $so_tien_lai_da_tra = !empty($item->so_tien_lai_da_tra) ? $item->so_tien_lai_da_tra : 0;
            
            $this->sheet->setCellValue('A'.$i, $index);
            $this->sheet->setCellValue('B'.$i, $this->time_model->convertTimestampToDatetime($item->created_at)); 
            $this->sheet->setCellValue('C'.$i, !empty($item->ma_giao_dich_ngan_hang) ? $item->ma_giao_dich_ngan_hang : $item->code_transaction_bank); 
            $this->sheet->setCellValue('D'.$i, !empty($item->code_contract_disbursement) ? $item->code_contract_disbursement : $item->code_contract); 
            $this->sheet->setCellValue('E'.$i, !empty($item->contract_infor) ? $item->contract_infor[0]->investor_infor->name : ""); 
            $this->sheet->setCellValue('F'.$i, $so_tien_goc_da_tra); 
            $this->sheet->setCellValue('G'.$i, $so_tien_lai_da_tra); 
            
            $this->tong['so_tien_goc_da_tra'] = $this->tong['so_tien_goc_da_tra'] + $so_tien_goc_da_tra;
            $this->tong['so_tien_lai_da_tra'] = $this->tong['so_tien_lai_da_tra'] + $so_tien_lai_da_tra;
           
            $index++;
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
    
    private function lastRow_Tong() {
        $this->sheet->setCellValue('B'.$this->numberRowLastColumn, "Tổng")
                    ->getStyle('B'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        //F4
        $this->sheet->setCellValue('F'.$this->numberRowLastColumn, $this->tong['so_tien_goc_da_tra'])
                    ->getStyle('F'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
        //G4
        $this->sheet->setCellValue('G'.$this->numberRowLastColumn, $this->tong['so_tien_lai_da_tra'])
                    ->getStyle('G'.$this->numberRowLastColumn)
                    ->applyFromArray(array("font" => array( "bold" => true)));
       
    }
}
?>

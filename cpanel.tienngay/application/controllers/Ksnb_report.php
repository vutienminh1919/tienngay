
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Ksnb_report extends MY_Controller{
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
        
    }

	public function getDataInterestFee()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$this->data["pageName"] = 'Danh sách lãi phí';
		$data = array();
		if (!empty($fdate) && !empty($tdate)) {
			if (strtotime($fdate) > strtotime($tdate)) {
				$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
				redirect(base_url('Ksnb_report/getDataInterestFee'));
			}
			if (empty($_GET['fdate']) || empty($_GET['tdate'])) {
				$this->session->set_flashdata('error', $this->lang->line('Please_select_input_date'));
				redirect(base_url('Ksnb_report/getDataInterestFee'));
			}
			$data = array(
				"fdate" => $fdate,
				"tdate" => $tdate,
			);
		}
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		$dataInterestFee = $this->api->apiPost($this->userInfo['token'], 'log/get_interest_fee', $data);
		
		if (!empty($dataInterestFee->status) && $dataInterestFee->status == 200) {
			$this->data['dataInterestFee'] = $dataInterestFee->data;
		} else {
			$this->data['dataInterestFee'] = array();
		}
		$this->data['template'] = 'page/interest_fee/list_interest_fee';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
    }
    
     public function lich_su_hop_dong() {
        $this->data["pageName"] = "Lịch sử hợp đồng";
        $this->data['template'] = 'page/ksnb_report/lich_su_hop_dong';
        $this->load->view('template', isset($this->data) ? $this->data:NULL);
    }
    public function doLich_su_hop_dong() {
        $start = !empty($_GET['fdate_export']) ? $_GET['fdate_export'] : "";
        if(empty($start)){
            $this->session->set_flashdata('error', "Hãy chọn tháng");
            redirect(base_url('ksnb_report/lich_su_hop_dong'));
        }
        
        $data = array();
        if(!empty($start)) $data['start'] = $start;
        
        $infor = $this->api->apiPost($this->userInfo['token'], "ksnb_report/lich_su_hop_dong", $data);
        //Calculate to export excel
        if(!empty($infor->data)) {
            $this->exportLich_su_hop_dong($infor->data,$start);
            
            
            //-------------------------------
            $this->callLibExcel('lich_su_hop_dong-'.date('d-m-Y-H:i:s-').$start.'.xlsx');
            
        } else {
            $this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
            redirect(base_url('ksnb_report/lich_su_hop_dong'));
        }
    }
    public function exportLich_su_hop_dong($dataPawn,$start)
    {
        $this->sheet->setCellValue('A1', 'STT');
        $this->sheet->setCellValue('B1', 'Mã giao dịch giải ngân');
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
        $this->sheet->setCellValue('M1', 'Tên TS đảm bảo');
        $this->sheet->setCellValue('N1', 'Giá trị TSĐB');
        $this->sheet->setCellValue('O1', 'Số tiền được vay');
        $this->sheet->setCellValue('P1', 'Loại bảo hiểm khoản vay');
        $this->sheet->setCellValue('Q1', 'Tiền vay');
        $this->sheet->setCellValue('R1', 'Tiền bảo hiểm');
        $this->sheet->setCellValue('S1', 'Tiền thực nhận');
        $this->sheet->setCellValue('T1', 'Hình thức lãi');
        $this->sheet->setCellValue('U1', 'Tỷ lệ lãi thu ng vay');
        $this->sheet->setCellValue('V1', 'Tỷ lệ phí thẩm định');
        $this->sheet->setCellValue('W1', 'Tỷ lệ phí tư vấn');
        $this->sheet->setCellValue('X1', 'Ngày gia hạn');
        $this->sheet->setCellValue('Y1', 'Tỷ lệ phí gia hạn');
        $this->sheet->setCellValue('Z1', 'Tỷ lệ phí TT trước hạn');
        $this->sheet->setCellValue('AA1', 'Tổng số tiền gốc đã thanh toán');
        $this->sheet->setCellValue('AB1', 'Tổng số tiền lãi đã thanh toán');
        $this->sheet->setCellValue('AC1', 'Tổng phí thẩm định/tư vấn đã thanh toán');
        $this->sheet->setCellValue('AD1', 'Tổng phí gia hạn đã thanh toán');
        $this->sheet->setCellValue('AE1', 'Tổng phí TT trước hạn đã thanh toán');
        $this->sheet->setCellValue('AF1', 'Gốc còn lại');
        $this->sheet->setCellValue('AG1', 'Lãi còn lại');
        $this->sheet->setCellValue('AH1', 'Phí còn lại');
        $this->sheet->setCellValue('AI1', 'Phí gia hạn');
        $this->sheet->setCellValue('AJ1', 'TT trước hạn');
        $this->sheet->setCellValue('AK1', 'Ngày thu hồi lần cuối');
        $this->sheet->setCellValue('AL1', 'Ngày tất toán');
        $this->sheet->setCellValue('AM1', 'Trạng thái');
        


        $i = 2;
        $startMonth = strtotime(date('Y-m-01', strtotime($start)).' 00:00:00');
        $endMonth = strtotime(date('Y-m-t', strtotime($start)).' 23:59:59');  
        foreach ($dataPawn as $data) {
           
            $insurance="";
            if (!empty($data->loan_infor->type_interest)) {
                if ($data->loan_infor->type_interest == 1) {
                    $type_interest = "Lãi hàng tháng, gốc hàng tháng";
                } else {
                    $type_interest = "Lãi hàng tháng, gốc cuối kỳ";
                }
            }
           
            if (!empty($data->loan_infor->loan_insurance)) {
                if ($data->loan_infor->loan_insurance == 1) {
                    $insurance = "GIC";
                } else {
                    $insurance = "MIC";
                }
            }
            $condition_stt=[
                'code_contract'=>$data->code_contract,
                'status'=>1,
                'type'=>3,
                'ky_tt_xa_nhat' => $data->debt->ky_tt_xa_nhat,
                'endMonth' => $endMonth,
                'status_contract_origin' => $data->status,
                'date_pay'=> array(
                '$lte' => $endMonth)
            ];
            $status = $this->contract_model->getStatusContract($condition_stt);

       
            $san_pham=(!empty($data->loan_infor->loan_product->text)) ? $data->loan_infor->loan_product->text : '';
           $du_no_gia_han=($data->so_tien_phi_gia_han_da_tra>0 || $status=="Gia hạn") ? 200000-$data->so_tien_phi_gia_han_da_tra : 0;
           $thu_hoi_cuoi=!empty($data->transaction_last[0]->date_pay) ? date("d/m/Y",$data->transaction_last[0]->date_pay) : '';
            $tat_toan_cuoi=!empty($data->transaction_tt[0]->date_pay) ? date("d/m/Y",$data->transaction_tt[0]->date_pay) : '';
            
            $this->sheet->setCellValue('A' . $i, $i - 1);
            $this->sheet->setCellValue('B' . $i, !empty($data->response_get_transaction_withdrawal_status_nl->transaction_id) ? $data->response_get_transaction_withdrawal_status_nl->transaction_id : '');
            $this->sheet->setCellValue('C' . $i, !empty($data->code_contract_disbursement) ? $data->code_contract_disbursement : $data->code_contract);
            $this->sheet->setCellValue('D' . $i, !empty($data->loan_infor->number_day_loan) ? $data->loan_infor->number_day_loan : "");
            $this->sheet->setCellValue('E' . $i, !empty($data->disbursement_date) ? date("d/m/Y", $data->disbursement_date) : "");
            $this->sheet->setCellValue('F' . $i, !empty($data->expire_date) ? date("d/m/Y", $data->expire_date) : "");
           
            $this->sheet->setCellValue('G' . $i, !empty($data->customer_infor->customer_name) ? $data->customer_infor->customer_name : "");
            $this->sheet->setCellValue('H' . $i, !empty($data->customer_infor->customer_identify) ? hide_phone($data->customer_infor->customer_identify) : "");
            $this->sheet->setCellValue('I'.$i, !empty($data->investor_infor->name) ? $data->investor_infor->name : "");
            $this->sheet->setCellValue('J'.$i, !empty($data->investor_infor->code) ? $data->investor_infor->code : "");

             $this->sheet->setCellValue('K'.$i, !empty($data->store->name) ? $data->store->name : "");
             $this->sheet->setCellValue('L'.$i, !empty($data->loan_infor) && !empty($data->loan_infor->type_loan->code) && !empty($data->loan_infor->type_property->code) ? $data->loan_infor->type_loan->code.'-'.$data->loan_infor->type_property->code : "");
            $this->sheet->setCellValue('M' . $i, !empty($data->loan_infor->name_property->text) ? $data->loan_infor->name_property->text : "");
            $this->sheet->setCellValue('N' . $i, !empty($data->loan_infor->price_property) ? $data->loan_infor->price_property : "");
            $this->sheet->setCellValue('O' . $i, !empty($data->loan_infor->amount_money_max) ? $data->loan_infor->amount_money_max : "");
            $this->sheet->setCellValue('P' . $i, !empty($insurance) ? $insurance : "");
            $this->sheet->setCellValue('Q' . $i, !empty($data->loan_infor->amount_money) ? $data->loan_infor->amount_money : "");
             $this->sheet->setCellValue('R' . $i, !empty($data->loan_infor->amount_money) ? $data->loan_infor->amount_GIC + $data->loan_infor->amount_GIC_easy + $data->loan_infor->amount_GIC_plt + $data->loan_infor->amount_VBI  : "");
            $this->sheet->setCellValue('S' . $i, !empty($data->loan_infor->amount_loan) ? $data->loan_infor->amount_loan : "");
            $this->sheet->setCellValue('T' . $i, !empty($type_interest) ? $type_interest : "");

            $this->sheet->setCellValue('U' . $i, !empty($data->fee->percent_interest_customer) ? $data->fee->percent_interest_customer : "");
            $this->sheet->setCellValue('V' . $i, !empty($data->fee->percent_expertise) ? $data->fee->percent_expertise : "");
            $this->sheet->setCellValue('W' . $i, !empty($data->fee->percent_advisory) ? $data->fee->percent_advisory : "");

            $this->sheet->setCellValue('X' . $i, !empty($data->extend_date) ? date("d/m/Y",$data->extend_date) : "");
            $this->sheet->setCellValue('Y' . $i, !empty($data->fee->fee_extend) ? $data->fee->fee_extend : "");

            $this->sheet->setCellValue('Z' . $i, !empty($data->fee->percent_prepay_phase_1) ? $data->fee->percent_prepay_phase_1 .' - '.$data->fee->percent_prepay_phase_2 .' - '.$data->fee->percent_prepay_phase_3 : "");
            $this->sheet->setCellValue('AA' . $i, !empty($data->tien_goc_da_tra) ? $data->tien_goc_da_tra : "");
            $this->sheet->setCellValue('AB' . $i, !empty($data->tien_lai_da_tra) ? $data->tien_lai_da_tra : "");
            $this->sheet->setCellValue('AC' . $i, !empty($data->tien_phi_da_tra) ? $data->tien_phi_da_tra : "");
            $this->sheet->setCellValue('AD' . $i, !empty($data->so_tien_phi_gia_han_da_tra) ? $data->so_tien_phi_gia_han_da_tra : "");
             $this->sheet->setCellValue('AE' . $i, !empty($data->so_tien_phi_tat_toan_da_tra) ? $data->so_tien_phi_tat_toan_da_tra : "");
           
            $this->sheet->setCellValue('AF' . $i,  $data->tien_goc_phai_tra-$data->tien_goc_da_tra );
            $this->sheet->setCellValue('AG' . $i, $data->tien_lai_phai_tra-$data->tien_lai_da_tra);
            $this->sheet->setCellValue('AH' . $i, $data->tien_phi_phai_tra-$data->tien_phi_da_tra);
            $this->sheet->setCellValue('AI' . $i, $du_no_gia_han);
            $this->sheet->setCellValue('AJ' . $i, $data->so_tien_phi_tat_toan_phai_tra_tat_toan-$data->so_tien_phi_tat_toan_da_tra);
            $this->sheet->setCellValue('AK' . $i,  $thu_hoi_cuoi);
            $this->sheet->setCellValue('AL' . $i, $tat_toan_cuoi);
            $this->sheet->setCellValue('AM' . $i, $status);             
            

            $i++;
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




}

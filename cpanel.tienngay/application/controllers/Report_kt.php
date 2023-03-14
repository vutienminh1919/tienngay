<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
include APPPATH.'/libraries/CpanelV2.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Report_kt extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model("time_model");
		$this->load->library('pagination');
		$this->load->model("store_model");
		$this->load->helper('lead_helper');
		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
		if (!$this->is_superadmin) {
			$paramController = $this->uri->segment(1);
			$param = strtolower($paramController);
			if (!in_array($param, $this->paramMenus)) {
				$this->session->set_flashdata('error', $this->lang->line('not_have_permission') . ' ' . $paramController . '!');
				redirect(base_url('app'));
				return;
			}
		}
		date_default_timezone_set('Asia/Ho_Chi_Minh');

		$this->spreadsheet = new Spreadsheet();
		$this->sheet = $this->spreadsheet->getActiveSheet();
	}

	public function report_tldp()
	{
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$dept = !empty($_GET['dept']) ? $_GET['dept'] : [];
		$reset = !empty($_GET['reset']) ? $_GET['reset'] : "";

		$condition = [];
		if ($store != "") {
			$condition['store'] = $store;
		}
		if ($dept != "") {
			$condition['dept'] = $dept;
		}
		if ($reset != "") {
			$condition['reset'] = 1;
		}

		$reportData = $this->api->apiPost($this->userInfo['token'], "report_kt/report_tldp", $condition);

		if (!empty($reportData->status) && $reportData->status == 200) {
			$report = $reportData->data;
		} else {
			$report = array();
		}

		$this->data['store_list'] = $this->store_model->find();
		$this->data['store'] = $store;
		$this->data['dept'] = $dept;
		// var_dump($this->data['dept']);die;

		$this->data['report'] = $report;
			$this->data['template'] = 'page/report/report_cldp.php';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function report_tldp_pgd()
	{
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$dept = !empty($_GET['dept']) ? $_GET['dept'] : [];
		$reset = !empty($_GET['reset']) ? $_GET['reset'] : "";

		$condition = [];
		if ($store != "") {
			$condition['store'] = $store;
		}
		if ($dept != "") {
			$condition['dept'] = $dept;
		}
		if ($reset != "") {
			$condition['reset'] = 1;
		}

		$reportData = $this->api->apiPost($this->userInfo['token'], "report_kt/report_tldp_pgd", $condition);

		if (!empty($reportData->status) && $reportData->status == 200) {
			$report = $reportData->data;
		} else {
			$report = array();
		}

		$this->data['store_list'] = $this->store_model->find();
		$this->data['store'] = $store;
		$this->data['dept'] = $dept;

		$this->data['report'] = $report;
		$this->data['template'] = 'page/report/report_cldp_pgd.php';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function report_detail_dept() {
		// Param
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$dept = !empty($_GET['dept']) ? $_GET['dept'] : "";
		$reset = !empty($_GET['reset']) ? $_GET['reset'] : "";

		$condition = [];
		if ($store != "") {
			$condition['store'] = $store;
		}
		if ($dept != "") {
			$dept_send = implode($dept, ",");
			$condition['dept'] = $dept_send;
		}
		if ($reset != "") {
			$condition['reset'] = 1;
		}

		// Count
		$reportData = $this->api->apiPost($this->userInfo['token'], "report_kt/report_detail_dept_count_all", $condition);
		if (!empty($reportData->status) && $reportData->status == 200) {
			$count = $reportData->data;
		} else {
			$count = 0;
		}

		// Paginate
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		// $config['base_url'] = base_url('borrowed/search_borrowed?fdate=' . $fdate . '&tdate=' . $tdate . '&code_contract_disbursement_text=' . $code_contract_disbursement_text . '&status_borrowed=' . $status_borrowed);
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;

		$condition['per_page'] = $config['per_page'];
		$condition['uriSegment'] = $config['uri_segment'];
		$this->data['store_list'] = $this->store_model->find();
		$this->data['store'] = $store;
		$this->data['dept'] = $dept;

		// Get Data
		$reportData = $this->api->apiPost($this->userInfo['token'], "report_kt/report_detail_dept", $condition);
		if (!empty($reportData->status) && $reportData->status == 200) {
			$report = $reportData->data;
		} else {
			$report = array();
		}
		$this->data['report'] = $report;
		$this->data['template'] = 'page/report/report_detail_dept.php';

		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
    public function report_log_phieu_thu() {
    	$reportData = $this->api->apiPost($this->userInfo['token'], "report_kt/report_log_phieu_thu", $condition);
		if (!empty($reportData->status) && $reportData->status == 200) {
			$report = $reportData->data;
		} else {
			$report = array();
		}
		$this->data['report'] = $report;
		$this->data['template'] = 'page/report/report_log_phieu_thu.php';
    	$this->load->view('template', isset($this->data) ? $this->data : NULL);
    }
	public function report_gach_no_tu_dong() {
		// Param
		$bank = !empty($_GET['bank']) ? $_GET['bank'] : "";
		$code = !empty($_GET['code']) ? $_GET['code'] : "";
		$contract_code = !empty($_GET['contract_code']) ? $_GET['contract_code'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$fromdate = !empty($_GET['fromdate']) ? $_GET['fromdate'] : "";
		$todate = !empty($_GET['todate']) ? $_GET['todate'] : "";

		$condition = [];
		if ($bank != "") {
			$condition['bank'] = $bank;
		}
		if ($code != "") {
			$condition['code'] = $code;
		}
		if ($contract_code != "") {
			$condition['contract_code'] = $contract_code;
		}
		if ($status != "") {
			$condition['status'] = $status;
		}
		if ($fromdate != "") {
			$condition['fromdate'] = $fromdate;
		}
		if ($todate != "") {
			$condition['todate'] = $todate;
		}
//		var_dump($condition);die;
		// Query
		$reportData = $this->api->apiPost($this->userInfo['token'], "report_kt/report_gach_no_tu_dong_count_all", $condition);
		if (!empty($reportData->status) && $reportData->status == 200) {
			$count = $reportData->data;
		} else {
			$count = 0;
		}

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		 $config['base_url'] = base_url('report_kt/report_gach_no_tu_dong');
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;

		$condition['per_page'] = $config['per_page'];
		$condition['uriSegment'] = $config['uri_segment'];
		// Get Data
		$reportData = $this->api->apiPost($this->userInfo['token'], "report_kt/report_gach_no_tu_dong", $condition);
		if (!empty($reportData->status) && $reportData->status == 200) {
			$report = $reportData->data;
		} else {
			$report = array();
		}
		$this->data['report'] = $report;
		$this->data['template'] = 'page/report/report_gach_no_tu_dong.php';
		$this->data['bank'] = $bank;
		$this->data['code'] = $code;
		$this->data['contract_code'] = $contract_code;
		$this->data['status'] = $status;
		$this->data['fromdate'] = $fromdate;
		$this->data['todate'] = $todate;

		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}


	public function action_transaction_change() {
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		$ma_phieu_ghi = !empty($_POST['ma_phieu_ghi']) ? $_POST['ma_phieu_ghi'] : "";
		$ma_hop_dong = !empty($_POST['ma_hop_dong']) ? $_POST['ma_hop_dong'] : "";
		$ten_khach_hang = !empty($_POST['ten_khach_hang']) ? $_POST['ten_khach_hang'] : "";
		$ghi_chu = !empty($_POST['ghi_chu']) ? $_POST['ghi_chu'] : "";
		$result = $this->api->apiPost($this->userInfo['token'], "report_kt/action_transaction_change", [
			'id' => $id,
			'ma_phieu_ghi' => $ma_phieu_ghi,
			'ma_hop_dong' => $ma_hop_dong,
			'ten_khach_hang' => $ten_khach_hang,
			'ghi_chu' => $ghi_chu,
		]);
		if(!empty($result->status) && $result->status == 200){
			$response = [
				'status' => "200",
				'data' => $result->data,
			];
			echo json_encode($response);
			return;
		}else{
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $result->message
			];
			echo json_encode($response);
			return;
		}
	}

	public function report_gach_no_tu_dong_excel() {
		// Param
		$bank = !empty($_GET['bank']) ? $_GET['bank'] : "";
		$code = !empty($_GET['code']) ? $_GET['code'] : "";
		$contract_code = !empty($_GET['contract_code']) ? $_GET['contract_code'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$fromdate = !empty($_GET['fromdate']) ? $_GET['fromdate'] : "";
		$todate = !empty($_GET['todate']) ? $_GET['todate'] : "";

		$condition = [];
		if ($bank != "") {
			$condition['bank'] = $bank;
		}
		if ($code != "") {
			$condition['code'] = $code;
		}
		if ($contract_code != "") {
			$condition['contract_code'] = $contract_code;
		}
		if ($status != "") {
			$condition['status'] = $status;
		}
		if ($fromdate != "") {
			$condition['fromdate'] = $fromdate;
		}
		if ($todate != "") {
			$condition['todate'] = $todate;
		}

		$reportData = $this->api->apiPost($this->userInfo['token'], "report_kt/export_gach_no_tu_dong", $condition);
		if (!empty($reportData->status) && $reportData->status == 200) {
			$report = $reportData->data;
			$this->exportGachNoTuDong($report);
			var_dump("Done");
		} else {
			var_dump("Không có dữ liệu để xuất excel");
		}
	}

	public function exportGachNoTuDong($data) {
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Ngân hàng');
		$this->sheet->setCellValue('C1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('D1', 'Mã giao dịch');
		$this->sheet->setCellValue('E1', 'Số tiền thanh toán');
		$this->sheet->setCellValue('F1', 'Nội dung giao dịch');
		$this->sheet->setCellValue('G1', 'Ngày thanh toán');
		$this->sheet->setCellValue('H1', 'Trạng thái');

		$i = 2;
		foreach($data as $item) {
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, isset($item->bank) ? $item->bank : '');
			$this->sheet->setCellValue('C' . $i, isset($item->contract_code) ? $item->contract_code : '');
			$this->sheet->setCellValue('D' . $i, isset($item->code) ? $item->code : '');
			$this->sheet->setCellValue('E' . $i, isset($item->money) ? $item->money : '');
			$this->sheet->setCellValue('F' . $i, isset($item->content) ? $item->content : '');
			$this->sheet->setCellValue('G' . $i, isset($item->date) ? date("d/m/Y", $item->date) : '');
			$this->sheet->setCellValue('H' . $i, isset($item->status) && $item->status == 1 ? 'Gạch thành công' : 'Thất bại');
			$i++;
		}

		$this->callLibExcel('report-gach-no-tu-dong-' . time() . '.xlsx');
	}

	public function report_detail_dept_excel() {
		// Param
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$dept = !empty($_GET['dept']) ? $_GET['dept'] : "";

		$condition = [];
		if ($store != "") {
			$condition['store'] = $store;
		}
		if ($dept != "") {
			$dept_send = implode($dept, ",");
			$condition['dept'] = $dept_send;
		}

		$reportData = $this->api->apiPost($this->userInfo['token'], "report_kt/report_detail_dept_all", $condition);
		if (!empty($reportData->status) && $reportData->status == 200) {
			$report = $reportData->data;
			$this->exportDetailDept($report);
			var_dump("Done");
		} else {
			var_dump("Không có dữ liệu để xuất excel");
		}
	}

	public function exportDetailDept($data) {
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã hợp đồng vay');
		$this->sheet->setCellValue('C1', 'Mã phụ lục hợp đồng vay');
		$this->sheet->setCellValue('D1', 'Thời hạn vay');
		$this->sheet->setCellValue('E1', 'Ngày giải ngân');
		$this->sheet->setCellValue('F1', 'Ngày đáo hạn');
		$this->sheet->setCellValue('G1', 'Tên người vay');
		$this->sheet->setCellValue('H1', 'Phòng giao dịch');
		$this->sheet->setCellValue('I1', 'Hình thức vay');
		$this->sheet->setCellValue('J1', 'Số tiền vay');
		$this->sheet->setCellValue('K1', 'Hình thức tính lãi');
		$this->sheet->setCellValue('L1', 'Giá trị tài sản đảm bảo');
		$this->sheet->setCellValue('M1', 'Gốc còn lại');
		$this->sheet->setCellValue('N1', 'Lãi còn lại');
		$this->sheet->setCellValue('O1', 'Phí còn lại');
		$this->sheet->setCellValue('P1', 'Tổng còn lại phải trả');
		$this->sheet->setCellValue('Q1', 'Nhóm');

		$i = 2;
		foreach($data as $item) {
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, isset($item->ma_hop_dong) ? $item->ma_hop_dong : '');
			$this->sheet->setCellValue('C' . $i, isset($item->ma_phu_luc) ? $item->ma_phu_luc : '');
			$this->sheet->setCellValue('D' . $i, isset($item->thoi_han_vay) ? $item->thoi_han_vay : '');
			$this->sheet->setCellValue('E' . $i, isset($item->ngay_giai_ngan) ? date("d/m/Y", $item->ngay_giai_ngan) : '');
			$this->sheet->setCellValue('F' . $i, isset($item->ngay_dao_han) ? date("d/m/Y", $item->ngay_dao_han) : '');
			$this->sheet->setCellValue('G' . $i, isset($item->ten_nguoi_vay) ? $item->ten_nguoi_vay : '');
			$this->sheet->setCellValue('H' . $i, isset($item->store) ? $item->store->name : '');
			$this->sheet->setCellValue('I' . $i, isset($item->hinh_thuc_vay) ? $item->hinh_thuc_vay : '');
			$this->sheet->setCellValue('J' . $i, isset($item->so_tien_vay) ? $item->so_tien_vay : '');
			$this->sheet->setCellValue('K' . $i, $item->hinh_thuc_lai == 1 ? "Lãi hàng tháng, gốc hàng tháng" : 'Lãi hàng tháng, gốc cuối kỳ');
			$this->sheet->setCellValue('L' . $i, isset($item->tai_san_dam_bao) ? $item->tai_san_dam_bao : '');
			$this->sheet->setCellValue('M' . $i, isset($item->du_no_goc_con_lai) ? $item->du_no_goc_con_lai : '');
			$this->sheet->setCellValue('N' . $i, isset($item->du_no_lai_con_lai) ? $item->du_no_lai_con_lai : '');
			$this->sheet->setCellValue('O' . $i, isset($item->du_no_phi_con_lai) ? $item->du_no_phi_con_lai : '');
			$this->sheet->setCellValue('P' . $i, isset($item->tong_du_no) ? $item->tong_du_no : '');
			$this->sheet->setCellValue('Q' . $i, isset($item->nhom_no) ? "B".$item->nhom_no : '');
			$i++;
		}

		$this->callLibExcel('report-chi-tiet-no-xau-' . time() . '.xlsx');
	}

	private function callLibExcel($filename)
	{
		// Redirect output to a client's web browser (Xlsx)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
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

	public function index_report_kt()
	{

		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$customer_form_hs = !empty($_GET['customer_form_hs']) ? $_GET['customer_form_hs'] : "";

		$data = array();
		if (!empty($start)) $data['start'] = $start;
		if (!empty($end)) $data['end'] = $end;
		if (!empty($customer_form_hs)) $data['customer_form_hs'] = $customer_form_hs;


		$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all_store");

		if (!empty($storeData->status) && $storeData->status == 200) {
			$this->data['stores'] = $storeData->data;
		} else {
			$this->data['stores'] = array();
		}

		$list_kt = $this->api->apiPost($this->userInfo['token'], "exportExcel/get_user_kt");
		if (!empty($list_kt->status) && $list_kt->status == 200) {
			$this->data['list_kt'] = $list_kt->data;
		} else {
			$this->data['list_kt'] = array();
		}

		$report = $this->api->apiPost($this->userInfo['token'], "exportExcel/export_kt",$data);
		$view_report = [];
		$i=0;

		foreach ($report->data as $key => $value) {

			if (in_array($value->email, $list_kt->data)) {
				$email_hs = $value->email;
			}

			unset($created_at_gdv);
			unset($created_at_return);
			unset($created_at_cancel);
			unset($created_at_approval);
			unset($created_at_xl);

			if ($value->status_new == "15") {
				$created_at_gdv = $value->created_at;
			}
			if ($value->status_new == "7") {
				$created_at_return = $value->created_at;
			}
			if ($value->status_new == "3") {
				$created_at_cancel = $value->created_at;
			}
			if ($value->status_new == "17") {
				$created_at_approval = $value->created_at;
			}

			if (!empty($created_at_gdv)) {
				if (empty($created_at_approval) || empty($created_at_cancel)) {
					$arr = $created_at_gdv;
					continue;
				}
			}
			if (!empty($created_at_return)) {
				$created_at_gdv = $arr;
				$created_at_xl = abs($created_at_return - $created_at_gdv);
				unset($arr);
			}

			if (!empty($arr) && !empty($created_at_approval)) {
				$created_at_gdv = $arr;
				$created_at_xl = abs($created_at_approval - $created_at_gdv);
				unset($arr);
			}

			if (!empty($arr) && !empty($created_at_cancel)) {
				$created_at_gdv = $arr;
				$created_at_xl = abs($created_at_cancel - $created_at_gdv);
				unset($arr);
			}

			if (!empty($created_at_xl)){
				$years = floor($created_at_xl / (365*60*60*24));
				$months = floor(($created_at_xl - $years * 365*60*60*24) / (30*60*60*24));
				$days = floor(($created_at_xl - $years * 365*60*60*24 - $months*30*60*60*24) / (60*60*24));
				$hours = floor(($created_at_xl - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));
				$minutes = floor(($created_at_xl - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60) / 60);
				$seconds = floor(($created_at_xl - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));
			}

			if (!empty($value->customer_form_hs) || $value->customer_form_hs != "") {
				if ($email_hs != $value->customer_form_hs) {
					continue;
				}
			}

			if (!empty($start) && !empty($end)){
				$start1 = strtotime(trim($start) . ' 00:00:00');
				if (!empty($created_at_approval) && $created_at_approval < $start1){
					continue;
				}
				if (!empty($created_at_cancel) && $created_at_cancel < $start1){
					continue;
				}
			}



			$view_report[$i]['email_hs'] = !empty($email_hs) ? $email_hs : '';
			$view_report[$i]['pgd'] = !empty($value->pgd) ? $value->pgd : '';
			$view_report[$i]['customer_name'] = !empty($value->customer_name) ? $value->customer_name : '';
			$view_report[$i]['code_contract'] = (!empty($value->code_contract) ? $value->code_contract : '');
			$view_report[$i]['loan_product'] = (!empty($value->loan_product) ? ($value->loan_product) : '');
			$view_report[$i]['new_amount_loan'] = (!empty($value->amount_loan) ? number_format($value->amount_loan) : '');
			if (!empty($value->new_amount_loan) && $value->new_amount_loan != 0){
				$view_report[$i]['new_amount_loan'] = (!empty($value->new_amount_loan) ? number_format($value->new_amount_loan) : '');
			}

			$view_report[$i]['created_at_gdv'] = (!empty($created_at_gdv) ? date("d/m/Y H:i:s ", $created_at_gdv) : '');
			$view_report[$i]['created_at_return'] = (!empty($created_at_return) ? date("d/m/Y H:i:s ", $created_at_return) : '');
			$view_report[$i]['created_at_approval'] = (!empty($created_at_approval) ? date("d/m/Y H:i:s ", $created_at_approval) : '');
			$view_report[$i]['created_at_cancel'] = (!empty($created_at_cancel) ? date("d/m/Y H:i:s ", $created_at_cancel) : '');

			$view_report[$i]['created_at_xl'] = (!empty($created_at_xl)) ? date("$hours:$minutes:$seconds", $created_at_xl) : '';

			$view_report[$i]['note'] = (!empty($value->note) ? ($value->note) : '');
			$view_report[$i]['count_return'] = (!empty($value->count_return) ? ($value->count_return) : '');
			$i++;
		}


		$this->data['view_report'] = $view_report;

		$this->data['template'] = 'page/approval_report/report_kt';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function report_thn_tlpb_tht()
	{
		$area = !empty($_GET['area']) ? $_GET['area'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$fromdate = !empty($_GET['fromdate']) ? $_GET['fromdate'] : "";
		$todate = !empty($_GET['todate']) ? $_GET['todate'] : "";

		$condition = [];
		if ($store != "") {
			$condition['store'] = $store;
		}
		if ($area != "") {
			$condition['area'] = $area;
		}
		if ($fromdate != "") {
			$condition['fromdate'] = $fromdate;
		}
		if ($todate != "") {
			$condition['todate'] = $todate;
		}

		// Report toàn hệ thống
		$store_report = [];
		if ($area == "" && $store == "") {
			$reportData = $this->api->apiPost($this->userInfo['token'], "report_kt/report_thu_hoi_no_area", $condition);
			if (!empty($reportData->status) && $reportData->status == 200) {
				$report = $reportData->data;
			} else {
				$report = array();
			}
			$type = 1;
		}

		// Report PGD
		if ($store != '') {
			$reportData = $this->api->apiPost($this->userInfo['token'], "report_kt/report_thu_hoi_no_store", $condition);
			if (!empty($reportData->status) && $reportData->status == 200) {
				$report = $reportData->data;
			} else {
				$report = array();
			}
			$store_report = $this->store_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($store)]);
			$type = 3;
		} else if ($area != '' && $store == '') {
			$reportData = $this->api->apiPost($this->userInfo['token'], "report_kt/report_thu_hoi_no_detail", $condition);
			if (!empty($reportData->status) && $reportData->status == 200) {
				$report = $reportData->data;
			} else {
				$report = array();
			}
			$storeData = $this->api->apiPost($this->userInfo['token'], "report_kt/report_thu_hoi_no_area_store", $condition);
			if (!empty($storeData->status) && $storeData->status == 200) {
				$store_report = $storeData->data;
			} else {
				$store_report = array();
			}
			$type = 2;
		}
		// $this->dd($store_report);

		$this->data['area'] = $area;
		$this->data['store'] = $store;
		$this->data['store_list'] = $this->store_model->find_where([
			'status' => 'active',
		]);
		$this->data['report'] = $report;
		$this->data['store_report'] = $store_report;
		$this->data['type'] = $type;
		$this->data['template'] = 'page/report/report_thn_tlpb_tht.php';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function ajax_change_area() {
		$area = !empty($_POST['area']) ? $_POST['area'] : "";
		$condition = [];
		if ($area != "") {
			$condition['area'] = $area;
		}
		$storeData = $this->api->apiPost($this->userInfo['token'], "report_kt/report_thu_hoi_no_area_store", $condition);
		if (!empty($storeData->status) && $storeData->status == 200) {
			$store_report = $storeData->data;
		} else {
			$store_report = array();
		}
		$data = [];
		foreach ($store_report as $item) {
			$data[] = [
				'value' => (string) $item->_id->{'$oid'},
				'text' => $item->name
			];
		}

		$response = [
			'res' => true,
			'status' => "200",
			'data' => $data
		];
		echo json_encode($response);
		return;
	}

	public function report_history_contract() {
		$fromdate = !empty($_GET['fromdate']) ? $_GET['fromdate'] : '';
		$todate = !empty($_GET['todate']) ? $_GET['todate'] : date("Y-m-d");
		$ma_phieu_ghi = !empty($_GET['ma_phieu_ghi']) ? $_GET['ma_phieu_ghi'] : "";
		$ma_hop_dong = !empty($_GET['ma_hop_dong']) ? $_GET['ma_hop_dong'] : "";
		$ten_khach_hang = !empty($_GET['ten_khach_hang']) ? $_GET['ten_khach_hang'] : "";
		$so_dien_thoai = !empty($_GET['so_dien_thoai']) ? $_GET['so_dien_thoai'] : "";
		$hinh_thuc_vay = !empty($_GET['hinh_thuc_vay']) ? $_GET['hinh_thuc_vay'] : "";
		$san_pham_vay = !empty($_GET['san_pham_vay']) ? $_GET['san_pham_vay'] : "";
		$phong_giao_dich = !empty($_GET['phong_giao_dich']) ? $_GET['phong_giao_dich'] : "";
		$trang_thai = !empty($_GET['trang_thai']) ? $_GET['trang_thai'] : "";

		$condition = [];
		if ($fromdate != '') {
			$condition['fromdate'] = strtotime($fromdate. ' 00:00:00');
		}
		if ($todate != '') {
			$condition['todate'] = strtotime($todate. ' 23:59:59');
		}
		if ($ma_phieu_ghi != '') {
			$condition['ma_phieu_ghi'] = $ma_phieu_ghi;
		}
		if ($ma_hop_dong != '') {
			$condition['ma_hop_dong'] = $ma_hop_dong;
		}
		if ($ten_khach_hang != '') {
			$condition['ten_khach_hang'] = $ten_khach_hang;
		}
		if ($so_dien_thoai != '') {
			$condition['so_dien_thoai'] = $so_dien_thoai;
		}
		if ($hinh_thuc_vay != '') {
			$condition['hinh_thuc_vay'] = $hinh_thuc_vay;
		}
		if ($san_pham_vay != '') {
			$condition['san_pham_vay'] = $san_pham_vay;
		}
		if ($phong_giao_dich != '') {
			$condition['phong_giao_dich'] = $phong_giao_dich;
		}
		if ($trang_thai != '') {
			$condition['trang_thai'] = $trang_thai;
		}
		// Count All
		$reportData = $this->api->apiPost($this->userInfo['token'], "report_kt/report_history_contract_count_all", $condition);
		if (!empty($reportData->status) && $reportData->status == 200) {
			$count = $reportData->data;
		} else {
			$count = 0;
		}

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('report_kt/report_history_contract?fromdate=' . $fromdate . '&todate=' . $todate. '&ma_phieu_ghi'. $ma_phieu_ghi .'=&ma_hop_dong='. $ma_hop_dong .'&ten_khach_hang'. $ten_khach_hang .'=&hinh_thuc_vay='. $hinh_thuc_vay .'&phong_giao_dich='. $phong_giao_dich);
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;

		$condition['per_page'] = $config['per_page'];
		$condition['uriSegment'] = $config['uri_segment'];
		// Get Data
		$reportData = $this->api->apiPost($this->userInfo['token'], "report_kt/report_history_contract", $condition);
		if (!empty($reportData->status) && $reportData->status == 200) {
			$report = $reportData->data;
		} else {
			$report = array();
		}
		$this->data['report'] = $report;
		$this->data['template'] = 'page/report/report_history_contract.php';
		$this->data['fromdate'] = $fromdate;
		$this->data['todate'] = $todate;
		$this->data['ma_phieu_ghi'] = $ma_phieu_ghi;
		$this->data['ma_hop_dong'] = $ma_hop_dong;
		$this->data['ten_khach_hang'] = $ten_khach_hang;
		$this->data['so_dien_thoai'] = $so_dien_thoai;
		$this->data['hinh_thuc_vay'] = $hinh_thuc_vay;
		$this->data['san_pham_vay'] = $san_pham_vay;
		$this->data['phong_giao_dich'] = $phong_giao_dich;
		$this->data['count'] = $count;
		$this->data['api'] = $this->api;
//		$this->data['store_list'] = $this->store_model->find(['status' => 'active']);
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function report_history_contract_excel() {
		$fromdate = !empty($_GET['fromdate']) ? $_GET['fromdate'] : '';
		$todate = !empty($_GET['todate']) ? $_GET['todate'] : date("Y-m-d");
		$ma_phieu_ghi = !empty($_GET['ma_phieu_ghi']) ? $_GET['ma_phieu_ghi'] : "";
		$ma_hop_dong = !empty($_GET['ma_hop_dong']) ? $_GET['ma_hop_dong'] : "";
		$ten_khach_hang = !empty($_GET['ten_khach_hang']) ? $_GET['ten_khach_hang'] : "";
		$so_dien_thoai = !empty($_GET['so_dien_thoai']) ? $_GET['so_dien_thoai'] : "";
		$hinh_thuc_vay = !empty($_GET['hinh_thuc_vay']) ? $_GET['hinh_thuc_vay'] : "";
		$san_pham_vay = !empty($_GET['san_pham_vay']) ? $_GET['san_pham_vay'] : "";
		$phong_giao_dich = !empty($_GET['phong_giao_dich']) ? $_GET['phong_giao_dich'] : "";
		$trang_thai = !empty($_GET['trang_thai']) ? $_GET['trang_thai'] : "";

		$condition = [];
		if ($fromdate != '') {
			$condition['fromdate'] = strtotime($fromdate. ' 00:00:00');
		}
		if ($todate != '') {
			$condition['todate'] = strtotime($todate. ' 23:59:59');
		}
		if ($ma_phieu_ghi != '') {
			$condition['ma_phieu_ghi'] = $ma_phieu_ghi;
		}
		if ($ma_hop_dong != '') {
			$condition['ma_hop_dong'] = $ma_hop_dong;
		}
		if ($ten_khach_hang != '') {
			$condition['ten_khach_hang'] = $ten_khach_hang;
		}
		if ($so_dien_thoai != '') {
			$condition['so_dien_thoai'] = $so_dien_thoai;
		}
		if ($hinh_thuc_vay != '') {
			$condition['hinh_thuc_vay'] = $hinh_thuc_vay;
		}
		if ($san_pham_vay != '') {
			$condition['san_pham_vay'] = $san_pham_vay;
		}
		if ($phong_giao_dich != '') {
			$condition['phong_giao_dich'] = $phong_giao_dich;
		}
		if ($trang_thai != '') {
			$condition['trang_thai'] = $trang_thai;
		}
		// Get Data
		$reportData = $this->api->apiPost($this->userInfo['token'], "report_kt/report_history_contract_all", $condition);
		if (!empty($reportData->status) && $reportData->status == 200) {
			$report = $reportData->data;
			$this->exportHistoryContract($report);
			var_dump("Done");
		} else {
			var_dump("Không có dữ liệu để xuất excel");
		}


	}

	public function exportHistoryContract($data) {
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã giao dịch giải ngân');
		$this->sheet->setCellValue('C1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('D1', 'Mã hợp đồng vay');
		$this->sheet->setCellValue('E1', 'Mã hợp đồng gốc');
		$this->sheet->setCellValue('F1', 'Kỳ hạn cho vay (Kỳ hạn)');
		$this->sheet->setCellValue('G1', 'Thời hạn cho vay (Ngày)');
		$this->sheet->setCellValue('H1', 'Ngày giải ngân');
		$this->sheet->setCellValue('I1', 'Ngày gia hạn');
		$this->sheet->setCellValue('J1', 'Ngày cơ cấu');
		$this->sheet->setCellValue('K1', 'Ngày đáo hạn');
		$this->sheet->setCellValue('L1', 'Ngày tất toán');
		$this->sheet->setCellValue('M1', 'Tên người cho vay');
		$this->sheet->setCellValue('N1', 'Mã người cho vay');
		$this->sheet->setCellValue('O1', 'CMT/CCCD người cho vay');
		$this->sheet->setCellValue('P1', 'Tên nhà đầu tư');
		$this->sheet->setCellValue('Q1', 'Mã nhà đầu tư');
		$this->sheet->setCellValue('R1', 'Phòng giao dịch giải ngân');
		$this->sheet->setCellValue('S1', 'Phân khu vực');
		$this->sheet->setCellValue('T1', 'Phân vùng');
		$this->sheet->setCellValue('U1', 'Phân miền');
		$this->sheet->setCellValue('V1', 'Hình thức cầm cố');
		$this->sheet->setCellValue('W1', 'Mã tài sản thế chấp');
		$this->sheet->setCellValue('X1', 'Tên tài sản thế chấp');
		$this->sheet->setCellValue('Y1', 'Định vị');
		$this->sheet->setCellValue('Z1', 'Vị trí');
		$this->sheet->setCellValue('AA1', 'Giá trị tài sản thế chấp');
		$this->sheet->setCellValue('AB1', 'Giá trị thị trường khi thẩm định');
		$this->sheet->setCellValue('AC1', 'Giá trị tài sản khi chuẩn bị thanh lý');
		$this->sheet->setCellValue('AD1', 'Giá trị thực khi thanh lý');
		$this->sheet->setCellValue('AE1', 'Tiền cho vay');
		$this->sheet->setCellValue('AF1', 'Tiền bảo hiểm');
		$this->sheet->setCellValue('AG1', 'Tiền khách hàng thực nhận');
		$this->sheet->setCellValue('AH1', 'Số tài khoản giải ngân');
		$this->sheet->setCellValue('AI1', 'Tên chủ tài khoản');
		$this->sheet->setCellValue('AJ1', 'Ngân hàng');
		$this->sheet->setCellValue('AK1', 'Chi nhánh');
		$this->sheet->setCellValue('AL1', 'Số thẻ ATM');
		$this->sheet->setCellValue('AM1', 'Tên chủ thẻ ATM');
		$this->sheet->setCellValue('AN1', 'Trạng thái hợp đồng');
		$this->sheet->setCellValue('AO1', 'Trạng thái hiện tại');
		$this->sheet->setCellValue('AP1', 'Hình thức trả lãi');

		$i = 2;
		foreach($data as $item) {
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, isset($item->ma_giao_dich_giai_ngan) ? $item->ma_giao_dich_giai_ngan : '');
			$this->sheet->setCellValue('C' . $i, isset($item->ma_phieu_ghi) ? $item->ma_phieu_ghi : '');
			$this->sheet->setCellValue('D' . $i, isset($item->ma_hop_dong) ? $item->ma_hop_dong : '');
			$this->sheet->setCellValue('E' . $i, isset($item->ma_hop_dong_goc) ? $item->ma_hop_dong_goc : '');
			$this->sheet->setCellValue('F' . $i, isset($item->thoi_han_vay_thang) ? $item->thoi_han_vay_thang : '');
			$this->sheet->setCellValue('G' . $i, isset($item->thoi_han_vay_ngay) ? $item->thoi_han_vay_ngay : '');
			$this->sheet->setCellValue('H' . $i, isset($item->ngay_giai_ngan) ? date('d/m/Y', $item->ngay_giai_ngan) : '');
			$this->sheet->setCellValue('I' . $i, isset($item->ngay_gia_han) ? date('d/m/Y', $item->ngay_gia_han) : '');
			$this->sheet->setCellValue('J' . $i, isset($item->ngay_co_cau) ? date('d/m/Y', $item->ngay_co_cau) : '');
			$this->sheet->setCellValue('K' . $i, isset($item->ngay_dao_han) ? date('d/m/Y', $item->ngay_dao_han) : '');
			$this->sheet->setCellValue('L' . $i, isset($item->ngay_tat_toan) ? date('d/m/Y', $item->ngay_tat_toan) : '');
			$this->sheet->setCellValue('M' . $i, isset($item->ten_nguoi_vay) ? $item->ten_nguoi_vay : '');
			$this->sheet->setCellValue('N' . $i, isset($item->ma_nguoi_vay) ? $item->ma_nguoi_vay : '');
			$this->sheet->setCellValue('O' . $i, isset($item->cmt_nguoi_vay) ? $item->cmt_nguoi_vay : '');
			$this->sheet->setCellValue('P' . $i, isset($item->ten_ndt) ? $item->ten_ndt : '');
			$this->sheet->setCellValue('Q' . $i, isset($item->ma_ndt) ? $item->ma_ndt : '');
			$this->sheet->setCellValue('R' . $i, isset($item->store->name) ? $item->store->name : '');
			$this->sheet->setCellValue('S' . $i, isset($item->store->khu_vuc) ? $item->store->khu_vuc : '');
			$this->sheet->setCellValue('T' . $i, isset($item->store->vung) ? $item->store->vung : '');
			$this->sheet->setCellValue('U' . $i, isset($item->store->mien) ? $item->store->mien : '');
			$this->sheet->setCellValue('V' . $i, isset($item->hinh_thuc_cam_co) ? $item->hinh_thuc_cam_co : '');
			$this->sheet->setCellValue('W' . $i, isset($item->ma_tai_san_the_chap) ? $item->ma_tai_san_the_chap : '');
			$this->sheet->setCellValue('X' . $i, isset($item->ten_tai_san_the_chap) ? $item->ten_tai_san_the_chap : '');
			$this->sheet->setCellValue('Y' . $i, isset($item->dinh_vi_tai_san_the_chap) ? $item->dinh_vi_tai_san_the_chap : '');
			$this->sheet->setCellValue('Z' . $i, isset($item->vi_tri_tai_san_the_chap) ? $item->vi_tri_tai_san_the_chap : 'Người vay giữ');
			$this->sheet->setCellValue('AA' . $i, isset($item->gia_tri_tai_san_the_chap) ? number_format($item->gia_tri_tai_san_the_chap) : '');
			$this->sheet->setCellValue('AB' . $i, isset($item->gia_tri_tai_san_khi_tham_dinh) ? number_format($item->gia_tri_tai_san_khi_tham_dinh) : '');
			$this->sheet->setCellValue('AC' . $i, isset($item->gia_tri_tai_san_truoc_thanh_ly) ? number_format($item->gia_tri_tai_san_truoc_thanh_ly) : '');
			$this->sheet->setCellValue('AD' . $i, isset($item->gia_tri_tai_san_khi_thanh_ly) ? number_format($item->gia_tri_tai_san_khi_thanh_ly) : '');
			$this->sheet->setCellValue('AE' . $i, isset($item->so_tien_vay) ? number_format($item->so_tien_vay) : '');
			$this->sheet->setCellValue('AF' . $i, isset($item->so_tien_bao_hiem) ? number_format($item->so_tien_bao_hiem) : '');
			$this->sheet->setCellValue('AG' . $i, isset($item->so_tien_thuc_nhan) ? number_format($item->so_tien_thuc_nhan) : '');
			$this->sheet->setCellValue('AH' . $i, isset($item->bank_info->so_tai_khoan) ? $item->bank_info->so_tai_khoan : '');
			$this->sheet->setCellValue('AI' . $i, isset($item->bank_info->ten_chu_tk) ? $item->bank_info->ten_chu_tk : '');
			$this->sheet->setCellValue('AJ' . $i, isset($item->bank_info->bank_name) ? $item->bank_info->bank_name : '');
			$this->sheet->setCellValue('AK' . $i, isset($item->bank_info->ten_chi_nhanh) ? $item->bank_info->ten_chi_nhanh : '');
			$this->sheet->setCellValue('AL' . $i, isset($item->bank_info->so_the_atm) ? $item->bank_info->so_the_atm : '');
			$this->sheet->setCellValue('AM' . $i, isset($item->bank_info->ten_chu_atm) ? $item->bank_info->ten_chu_atm : '');

			$reportDataGoc = $this->api->apiPost($this->userInfo['token'], "report_kt/report_history_contract", [
				'ma_hop_dong' => $item->ma_hop_dong_goc
			]);
			if (!empty($reportDataGoc->status) && $reportDataGoc->status == 200) {
				$reportGoc = $reportDataGoc->data[0];
				if( (int) $reportGoc->ngay_tat_toan <= strtotime(date('Y-m-d 00:00:00')) && (int) $reportGoc->ngay_tat_toan != 0) {
					$trang_thai = "Đã tất toán";
				} else {
					if ( (int) $reportGoc->ngay_hop_dong_goc_co_cau > 0 && $reportGoc->ngay_hop_dong_goc_co_cau <= strtotime(date('Y-m-d 00:00:00')) ) {
						$trang_thai = "Đã cơ cấu";
					} elseif ( (int) $reportGoc->ngay_hop_dong_goc_gia_han > 0 && $reportGoc->ngay_hop_dong_goc_gia_han <= strtotime(date('Y-m-d 00:00:00')) ) {
						$trang_thai = "Đã gia hạn";
					} else {
						// Hợp đồng con đang gia hạn
						if ($reportGoc->danh_sach_hop_dong_gia_han != null) {
							if (end($reportGoc->danh_sach_hop_dong_gia_han) == $reportGoc->ma_hop_dong) {
								$trang_thai = "Đang vay";
							} else {
								$trang_thai = "Đã gia hạn";
							}
						} elseif ($reportGoc->danh_sach_hop_dong_co_cau != null) {
							if (end($reportGoc->danh_sach_hop_dong_co_cau) == $reportGoc->ma_hop_dong) {
								$trang_thai = "Đang vay";
							} else {
								$trang_thai = "Đã cơ cấu";
							}
						} else {
							$trang_thai = "Đang vay";
						}
					}
				}
			} else {
				$trang_thai = "";
			}
			$this->sheet->setCellValue('AN' . $i, $trang_thai);

			if( (int) $item->ngay_tat_toan <= strtotime(date('Y-m-d 00:00:00')) && (int) $item->ngay_tat_toan != 0) {
				$trang_thai_hien_tai = "Đã tất toán";
			} else {
				if ( (int) $item->ngay_hop_dong_goc_co_cau > 0 && $item->ngay_hop_dong_goc_co_cau <= strtotime(date('Y-m-d 00:00:00')) ) {
					$trang_thai_hien_tai = "Đã cơ cấu";
				} elseif ( (int) $item->ngay_hop_dong_goc_gia_han > 0 && $item->ngay_hop_dong_goc_gia_han <= strtotime(date('Y-m-d 00:00:00')) ) {
					$trang_thai_hien_tai = "Đã gia hạn";
				} else {
					// Hợp đồng con đang gia hạn
					if ($item->danh_sach_hop_dong_gia_han != null) {
						if (end($item->danh_sach_hop_dong_gia_han) == $item->ma_hop_dong) {
							$trang_thai_hien_tai = "Đang vay";
						} else {
							$trang_thai_hien_tai = "Đã gia hạn";
						}
					} elseif ($item->danh_sach_hop_dong_co_cau != null) {
						if (end($item->danh_sach_hop_dong_co_cau) == $item->ma_hop_dong) {
							$trang_thai_hien_tai = "Đang vay";
						} else {
							$trang_thai_hien_tai = "Đã cơ cấu";
						}
					} else {
						$trang_thai_hien_tai = "Đang vay";
					}
				}
			}
			$this->sheet->setCellValue('AO' . $i, $trang_thai_hien_tai);
			$this->sheet->setCellValue('AP' . $i, isset($item->hinh_thuc_tra_lai) ? $item->hinh_thuc_tra_lai : '');
			$i++;
		}

		$this->callLibExcel('report-lich-su-hop-dong-' . time() . '.xlsx');
	}

	public function report_history_transaction() {
		$cpanelV2 = CpanelV2::getDomain();
		$token = $this->userInfo['token'];
	    $this->data['template'] = 'page/report/report_history_transaction.php';
	    $this->data['url'] = $cpanelV2 . "cpanel/report/form2?access_token=$token";
		$this->load->view('template', $this->data);
		return;
	}

	public function report_history_transaction_excel() {
		$fromdate = !empty($_GET['fromdate']) ? $_GET['fromdate'] : '';
		$todate = !empty($_GET['todate']) ? $_GET['todate'] : date("Y-m-d");
		$ma_phieu_ghi = !empty($_GET['ma_phieu_ghi']) ? $_GET['ma_phieu_ghi'] : "";
		$ma_hop_dong = !empty($_GET['ma_hop_dong']) ? $_GET['ma_hop_dong'] : "";

		$condition = [];
		if ($fromdate != '') {
			$condition['fromdate'] = strtotime($fromdate. ' 00:00:00');
		}
		if ($todate != '') {
			$condition['todate'] = strtotime($todate. ' 23:59:59');
		}
		if ($ma_phieu_ghi != '') {
			$condition['ma_phieu_ghi'] = $ma_phieu_ghi;
		}
		if ($ma_hop_dong != '') {
			$condition['ma_hop_dong'] = $ma_hop_dong;
		}

		// Get Data
		$reportData = $this->api->apiPost($this->userInfo['token'], "report_kt/report_history_transaction_excel", $condition);
		if (!empty($reportData->status) && $reportData->status == 200) {
			$report = $reportData->data;
			$this->exportHistoryTransaction($report);
			var_dump("Done");
		} else {
			var_dump("Không có dữ liệu để xuất excel");
		}
	}

	public function exportHistoryTransaction($data) {
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Ngày thanh toán');
		$this->sheet->setCellValue('C1', 'Mã giao dịch ngân hàng');
		$this->sheet->setCellValue('D1', 'Ngân hàng');
		$this->sheet->setCellValue('E1', 'Phòng giao dịch thu tiền');
		$this->sheet->setCellValue('F1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('G1', 'Mã hợp đồng');
		$this->sheet->setCellValue('H1', 'Mã hợp đồng gốc');
		$this->sheet->setCellValue('I1', 'Mã người vay');
		$this->sheet->setCellValue('J1', 'Tên người vay');
		$this->sheet->setCellValue('K1', 'Số tiền gốc đã thu hồi (GH/CC)');
		$this->sheet->setCellValue('L1', 'Số tiền lãi đã thu hồi (GH/CC)');
		$this->sheet->setCellValue('M1', 'Số tiền phí đã thu hồi (GH/CC)');
		$this->sheet->setCellValue('N1', 'Số tiền còn phải thu (GH/CC)');
		$this->sheet->setCellValue('O1', 'Số tiền thừa khi (GH/CC)');
		$this->sheet->setCellValue('P1', 'Số tiền gốc đã thu hồi thực tế');
		$this->sheet->setCellValue('Q1', 'Số tiền lãi đã thu hồi thực tế');
		$this->sheet->setCellValue('R1', 'Số tiền phí đã thu hồi thực tế');
		$this->sheet->setCellValue('S1', 'Số tiền phí gia hạn đã thu hồi thực tế');
		$this->sheet->setCellValue('T1', 'Số tiền phí chậm trả đã thu hồi thực tế');
		$this->sheet->setCellValue('U1', 'Số tiền phí trước hạn đã thu hồi thực tế');
		$this->sheet->setCellValue('V1', 'Số tiền phí quá hạn đã thu hồi thực tế');
		$this->sheet->setCellValue('W1', 'Tổng phí đã thu hồi');
		$this->sheet->setCellValue('X1', 'Tiền thừa');
		$this->sheet->setCellValue('Y1', 'Tổng tiền thu hồi');
		$this->sheet->setCellValue('Z1', 'Số tiền gốc đã miễn giảm');
		$this->sheet->setCellValue('AA1', 'Số tiền lãi đã miễn giảm');
		$this->sheet->setCellValue('AB1', 'Số tiền phí đã miễn giảm');
		$this->sheet->setCellValue('AC1', 'Số tiền phí gia hạn đã miễn giảm');
		$this->sheet->setCellValue('AD1', 'Số tiền phí chậm trả đã miễn giảm');
		$this->sheet->setCellValue('AE1', 'Số tiền phí trước hạn đã miễn giảm');
		$this->sheet->setCellValue('AF1', 'Số tiền phí quá hạn đã miễn giảm');
		$this->sheet->setCellValue('AG1', 'Tổng tiền được miễn giảm');
		$this->sheet->setCellValue('AH1', 'Tổng gốc phải trả khi tất toán hợp đồng');
		$this->sheet->setCellValue('AI1', 'Tổng lãi phải trả khi tất toán hợp đồng');
		$this->sheet->setCellValue('AJ1', 'Tổng phí phải trả khi tất toán hợp đồng');
		$this->sheet->setCellValue('AK1', 'Tổng phí chậm trả phải trả khi tất toán hợp đồng');
		$this->sheet->setCellValue('AL1', 'Tổng phí phát sinh phải trả khi tất toán hợp đồng');
		$this->sheet->setCellValue('AM1', 'Phương thức thanh toán');
		$this->sheet->setCellValue('AN1', 'Loại thanh toán');
		$this->sheet->setCellValue('AO1', 'Hình thức trả lãi');
		$this->sheet->setCellValue('AP1', 'Tổng thu hồi lũy kế');
		$this->sheet->setCellValue('AQ1', 'Tình trạng thanh lý');

		$i = 2;
		foreach($data as $item) {
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, isset($item->ngay_thanh_toan) ? date('d/m/Y', $item->ngay_thanh_toan) : '');
			$this->sheet->setCellValue('C' . $i, isset($item->ma_giao_dich_ngan_hang) ? $item->ma_giao_dich_ngan_hang : '');
			$this->sheet->setCellValue('D' . $i, isset($item->ngan_hang) ? $item->ngan_hang : '');
			$this->sheet->setCellValue('E' . $i, isset($item->phong_giao_dich->name) ? $item->phong_giao_dich->name : '');
			$this->sheet->setCellValue('F' . $i, isset($item->ma_phieu_ghi) ? $item->ma_phieu_ghi : '');
			$this->sheet->setCellValue('G' . $i, isset($item->ma_hop_dong) ? $item->ma_hop_dong : '');
			$this->sheet->setCellValue('H' . $i, isset($item->ma_hop_dong_goc) ? $item->ma_hop_dong_goc : '');
			$this->sheet->setCellValue('I' . $i, isset($item->cmt_nguoi_vay) ? $item->cmt_nguoi_vay : '');
			$this->sheet->setCellValue('J' . $i, isset($item->ten_nguoi_vay) ? $item->ten_nguoi_vay : '');
			$this->sheet->setCellValue('K' . $i, isset($item->tien_goc_ghcc_da_thu_hoi) ? $item->tien_goc_ghcc_da_thu_hoi : '')
				->getStyle('K' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('L' . $i, isset($item->tien_lai_ghcc_da_thu_hoi) ? $item->tien_lai_ghcc_da_thu_hoi : '')
				->getStyle('L' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('M' . $i, isset($item->tien_phi_ghcc_da_thu_hoi) ? $item->tien_phi_ghcc_da_thu_hoi : '')
				->getStyle('M' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('N' . $i, isset($item->tien_ghcc_con_phai_thu) ? $item->tien_ghcc_con_phai_thu : '')
				->getStyle('N' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('O' . $i, isset($item->tien_thua_khi_ghcc) ? $item->tien_thua_khi_ghcc : '')
				->getStyle('O' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('P' . $i, isset($item->tien_goc_da_thu_hoi) ? $item->tien_goc_da_thu_hoi : '')
				->getStyle('P' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('Q' . $i, isset($item->tien_lai_da_thu_hoi) ? $item->tien_lai_da_thu_hoi : '')
				->getStyle('Q' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('R' . $i, isset($item->tien_phi_da_thu_hoi) ? $item->tien_phi_da_thu_hoi : '')
				->getStyle('R' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('S' . $i, isset($item->tien_phi_gia_han_da_thu_hoi) ? $item->tien_phi_gia_han_da_thu_hoi : '')
				->getStyle('S' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('T' . $i, isset($item->tien_phi_cham_tra_da_thu_hoi) ? $item->tien_phi_cham_tra_da_thu_hoi : '')
				->getStyle('T' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('U' . $i, isset($item->tien_phi_truoc_han_da_thu_hoi) ? $item->tien_phi_truoc_han_da_thu_hoi : '')
				->getStyle('U' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('V' . $i, isset($item->tien_phi_qua_han_da_thu_hoi) ? $item->tien_phi_qua_han_da_thu_hoi : '')
				->getStyle('V' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('W' . $i, isset($item->tong_phi_da_thu_hoi) ? $item->tong_phi_da_thu_hoi : '')
				->getStyle('W' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('X' . $i, isset($item->tien_thua) ? $item->tien_thua : '')
				->getStyle('X' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('Y' . $i, isset($item->tong_thu_hoi_thuc_te) ? $item->tong_thu_hoi_thuc_te : '')
				->getStyle('Y' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('Z' . $i, isset($item->tien_goc_duoc_mien_giam) ? $item->tien_goc_duoc_mien_giam : '')
				->getStyle('Z' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AA' . $i, isset($item->tien_lai_duoc_mien_giam) ? $item->tien_lai_duoc_mien_giam : '')
				->getStyle('AA' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AB' . $i, isset($item->tien_phi_duoc_mien_giam) ? $item->tien_phi_duoc_mien_giam : '')
				->getStyle('AB' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AC' . $i, isset($item->tien_phi_gia_han_duoc_mien_giam) ? $item->tien_phi_gia_han_duoc_mien_giam : '')
				->getStyle('AC' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AD' . $i, isset($item->tien_phi_chan_tra_duoc_mien_giam) ? $item->tien_phi_chan_tra_duoc_mien_giam : '')
				->getStyle('AD' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AE' . $i, isset($item->tien_phi_truoc_han_duoc_mien_giam) ? $item->tien_phi_truoc_han_duoc_mien_giam : '')
				->getStyle('AE' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AF' . $i, isset($item->tien_phi_qua_han_duoc_mien_giam) ? $item->tien_phi_qua_han_duoc_mien_giam : '')
				->getStyle('AF' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AG' . $i, isset($item->tien_mien_giam) ? $item->tien_mien_giam : '')
				->getStyle('AG' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AH' . $i, isset($item->tong_goc_phai_tra_khi_tat_toan_hop_dong) ? $item->tong_goc_phai_tra_khi_tat_toan_hop_dong : '')
				->getStyle('AH' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AI' . $i, isset($item->tong_lai_phai_tra_khi_tat_toan_hop_dong) ? $item->tong_lai_phai_tra_khi_tat_toan_hop_dong : '')
				->getStyle('AI' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AJ' . $i, isset($item->tong_phi_phai_tra_khi_tat_toan_hop_dong) ? $item->tong_phi_phai_tra_khi_tat_toan_hop_dong : '')
				->getStyle('AJ' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AK' . $i, isset($item->tong_phi_cham_tra_phai_tra_khi_tat_toan_hop_dong) ? $item->tong_phi_cham_tra_phai_tra_khi_tat_toan_hop_dong : '')
				->getStyle('AK' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AL' . $i, isset($item->tong_phi_phat_sinh_phai_tra_khi_tat_toan_hop_dong) ? $item->tong_phi_phat_sinh_phai_tra_khi_tat_toan_hop_dong : '')
				->getStyle('AL' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AM' . $i, isset($item->phuong_thuc_thanh_toan) ? $item->phuong_thuc_thanh_toan : '');
			$this->sheet->setCellValue('AN' . $i, isset($item->loai_thanh_toan) ? $item->loai_thanh_toan : '');
			$this->sheet->setCellValue('AO' . $i, isset($item->hinh_thuc_tra_lai) ? $item->hinh_thuc_tra_lai : '');
			$this->sheet->setCellValue('AP' . $i, isset($item->tong_thu_hoi_luy_ke) ? $item->tong_thu_hoi_luy_ke : '')
				->getStyle('AP' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AQ' . $i, isset($item->tinh_trang_thanh_ly) ? $item->tinh_trang_thanh_ly : '');
			$i++;
		}
		$this->callLibExcel('report-lich-su-thu-hoi-' . time() . '.xlsx');
	}

	/**
	* Báo cáo bảng lãi thực Form 3
	*/
	public function report_real_revenue() {
		$cpanelV2 = CpanelV2::getDomain();
		$token = $this->userInfo['token'];
	    $this->data['template'] = 'page/report/report_real_revenue.php';
	    $this->data['url'] = $cpanelV2 . "cpanel/report/form3?access_token=$token";
		$this->load->view('template', $this->data);
		return;
	}


}

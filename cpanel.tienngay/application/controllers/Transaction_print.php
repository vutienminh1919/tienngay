<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// include APPPATH.'/libraries/Api.php';

include('application/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Transaction_print extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		// $this->api = new Api();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model("time_model");
		$this->load->model("store_model");
		$this->load->library('pagination');
		$this->load->helper('lead_helper');
		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
		if (!$this->is_superadmin) {
			$resGroupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
			if (!empty($resGroupRoles->status) && $resGroupRoles->status == 200) {
				$groupRoles = $resGroupRoles->data;
				if(!in_array('kiem-soat-noi-bo', $groupRoles)) {
					redirect(base_url('app'));
					return;
				}
			}
		}
		date_default_timezone_set('Asia/Ho_Chi_Minh');

		$this->spreadsheet = new Spreadsheet();
		$this->sheet = $this->spreadsheet->getActiveSheet();
	}

	public function reportPrintView() {
		$store_value = !empty($_GET['store']) ? $_GET['store'] : "";
		$fromdate = !empty($_GET['fromdate']) ? $_GET['fromdate'] : date('Y-m-01');
		$todate = !empty($_GET['todate']) ? $_GET['todate'] : date('Y-m-t');
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$code_transaction = !empty($_GET['code_transaction']) ? $_GET['code_transaction'] : "";

		$condition = [];
		if(is_array($store_value))
		$store_send = implode($store_value, ",");
		if ($store_value != "") {
			$condition['store'] = $store_send;
		}
		if ($code_contract_disbursement != "") {
			$condition['code_contract_disbursement'] = $code_contract_disbursement;
		}
		if ($code_contract != "") {
			$condition['code_contract'] = $code_contract;
		}
		if ($code_transaction != "") {
			$condition['code_transaction'] = $code_transaction;
		}
		if ($fromdate != "") {
			$condition['fromdate'] = $fromdate;
		}
		if ($todate != "") {
			$condition['todate'] = $todate;
		}

		$resStore = $this->api->apiPost($this->userInfo['token'], "transaction_print/count_print_store", $condition);
		if ($resStore->status == 200) {
			$store = $resStore->data;
		} else {
			$store = [];
		}

		$resContract = $this->api->apiPost($this->userInfo['token'], "transaction_print/count_print_contract", $condition);
		if ($resContract->status == 200) {
			$contract = $resContract->data;
		} else {
			$contract = [];
		}

		$resAll = $this->api->apiPost($this->userInfo['token'], "transaction_print/count_all", $condition);
		if ($resAll->status == 200) {
			$all = $resAll->data;
		} else {
			$all = 0;
		}

		$store_filter_list = $this->store_model->find();
		$store_help = new stdClass;
		$store_help->_id = "00000";
		$store_help->name = "Thu hộ phòng";
		array_push($store_filter_list, $store_help);

		$this->data['store_list'] = $store_filter_list;
		$this->data['store'] = $store;
		$this->data['store_value'] = $store_value;
		$this->data['code_contract_disbursement'] = $code_contract_disbursement;
		$this->data['code_contract'] = $code_contract;
		$this->data['code_transaction'] = $code_transaction;
		$this->data['fromdate'] = $fromdate;
		$this->data['todate'] = $todate;
		$this->data['contract'] = $contract;
		$this->data['all'] = $all;
		$this->data['template'] = 'page/transaction_print/list';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function getDatePrint() 
	{
		$store_value = !empty($_POST['store']) ? $_POST['store'] : "";
		$code_contract_disbursement = !empty($_POST['code_contract_disbursement']) ? $_POST['code_contract_disbursement'] : "";
		$user_print = !empty($_POST['user_print']) ? $_POST['user_print'] : "";
		if ($store_value != "") {
			$condition['store'] = $store_value;
		}
		if ($code_contract_disbursement != "") {
			$condition['code_contract_disbursement'] = $code_contract_disbursement;
		}
		if ($user_print != "") {
			$condition['user_print'] = $user_print;
		}
		$res_print = $this->api->apiPost($this->userInfo['token'], "transaction_print/get_date_print", $condition);
		if ($res_print->status == 200) {
			$data = $res_print->data;
		} else {
			$data = [];
		}

		$response = [
			'res' => true,
			'status' => "200",
			'data' => $data
		];
		echo json_encode($response);
		return;
	}

	public function exportExcelPrint()
	{
		$store_value = !empty($_GET['store']) ? $_GET['store'] : "";
		$fromdate = !empty($_GET['fromdate']) ? $_GET['fromdate'] : "";
		$todate = !empty($_GET['todate']) ? $_GET['todate'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$code_transaction = !empty($_GET['code_transaction']) ? $_GET['code_transaction'] : "";

		$condition = [];
		$store_send = implode($store_value, ",");
		if ($store_value != "") {
			$condition['store'] = $store_send;
		}
		if ($code_contract_disbursement != "") {
			$condition['code_contract_disbursement'] = $code_contract_disbursement;
		}
		if ($code_contract != "") {
			$condition['code_contract'] = $code_contract;
		}
		if ($code_transaction != "") {
			$condition['code_transaction'] = $code_transaction;
		}
		if ($fromdate != "") {
			$condition['fromdate'] = $fromdate;
		}
		if ($todate != "") {
			$condition['todate'] = $todate;
		}

		$resStore = $this->api->apiPost($this->userInfo['token'], "transaction_print/count_print_store", $condition);
		if ($resStore->status == 200) {
			$store = $resStore->data;
		} else {
			$store = [];
		}

		$resContract = $this->api->apiPost($this->userInfo['token'], "transaction_print/count_print_contract", $condition);
		if ($resContract->status == 200) {
			$contract = $resContract->data;
		} else {
			$contract = [];
		}

		$resAll = $this->api->apiPost($this->userInfo['token'], "transaction_print/count_all", $condition);
		if ($resAll->status == 200) {
			$all = $resAll->data;
		} else {
			$all = 0;
		}

		$this->exportDetailPrint($all, $store, $contract);
	}

	public function exportDetailPrint($all, $store, $contract) {
		$this->sheet->setCellValue('A1', 'Tổng phiếu thu đã in:');
		$this->sheet->setCellValue('B1', $all);

		$i = 2;
		foreach ($store as $key => $item) {
			$this->sheet->setCellValue('A' . $i, "Phòng giao dịch:");
			$this->sheet->setCellValue('B' . $i, $item->_id->name);
			$this->sheet->setCellValue('C' . $i, "Tổng PT PGD đã in:");
			$this->sheet->setCellValue('D' . $i, $item->count);
			$i++;
			$i = $this->renderExcelContract($item, $contract, $i);
		}

		$this->callLibExcel('thong-ke-luot-in-phieu-thu-' . date('d-m-Y-H-i') . '.xlsx');
	}

	public function renderExcelContract($store, $contract, $i) {
		$this->sheet->setCellValue('A'. $i, 'STT');
		$this->sheet->setCellValue('B'. $i, 'Tên phòng giao dịch');
		$this->sheet->setCellValue('C'. $i, 'Mã hợp đồng');
		$this->sheet->setCellValue('D'. $i, 'Mã phiếu ghi');
		$this->sheet->setCellValue('E'. $i, 'Mã phiếu thu');
		$this->sheet->setCellValue('F'. $i, 'Tên khách hàng');
		$this->sheet->setCellValue('G'. $i, 'Người thực hiện');
		$this->sheet->setCellValue('H'. $i, 'Phòng thu hộ');
		$this->sheet->setCellValue('I'. $i, 'Số phiếu thu đã in');

		$i++;
		$count = 1;
		foreach($contract as $item_contract) {
			if ( $item_contract->_id->store->id == $store->_id->id) {
				$this->sheet->setCellValue('A' . $i, $count);
				$this->sheet->setCellValue('B' . $i, isset($item_contract->_id->store->name) ? $item_contract->_id->store->name : '');
				$this->sheet->setCellValue('C' . $i, isset($item_contract->code_contract_disbursement) ? $item_contract->code_contract_disbursement : '');
				$this->sheet->setCellValue('D' . $i, isset($item_contract->code_contract) ? $item_contract->code_contract : '');
				$this->sheet->setCellValue('E' . $i, isset($item_contract->code_transaction) ? $item_contract->code_transaction : '');
				$this->sheet->setCellValue('F' . $i, isset($item_contract->customer_name) ? $item_contract->customer_name : '');
				$this->sheet->setCellValue('G' . $i, isset($item_contract->user_print) ? $item_contract->user_print : '');
				if($item_contract->help_pgd_name) {
					$this->sheet->setCellValue('H' . $i, isset($item_contract->help_pgd_name->name) ? $item_contract->help_pgd_name->name : '');
				} else {
					$this->sheet->setCellValue('H' . $i, 'Không');
				}
				$this->sheet->setCellValue('I' . $i, isset($item_contract->count) ? $item_contract->count : '');
				$i++;
				$count++;
			}
		}

		return $i;
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

}
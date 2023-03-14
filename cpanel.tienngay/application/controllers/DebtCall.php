<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DebtCall extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("time_model");
		$this->load->model("province_model");
		$this->load->model("reason_model");
		$this->load->model("main_property_model");
		$this->load->helper('lead_helper');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->config->load('config');
		$this->load->library('pagination');
		$this->load->helper('location_helper');
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
		$this->spreadsheet = new Spreadsheet();
		$this->sheet = $this->spreadsheet->getActiveSheet();
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	private function pushJson($code, $data)
	{
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}

	public function index()
	{
		$this->data['pageName'] = 'Import hợp đồng cho call';
		$roles = $this->api->apiPost($this->user['token'], "DebtCall/getRole", array("user_id" => $this->user['id']));
		if (!empty($roles->status) && $roles->status == 200) {
			$this->data['Roles'] = $roles->data;
		}
		$this->data['template'] = 'page/debt/contract_call/import_contract_assign_to_call.php';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function list_contract_call()
	{
		$this->data['pageName'] = 'Danh sách hợp đồng vay';
		$this->data['stores'] = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active")->data;
		$this->data['contractData'] = array();
		$this->data['groupRole'] = array();
		$this->data['storeData'] = array();

		//Params
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$phone_number = !empty($_GET['phone_number']) ? $_GET['phone_number'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$status_contract = !empty($_GET['status_contract']) ? $_GET['status_contract'] : "";
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$email = !empty($_GET['email_call']) ? $_GET['email_call'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "active";
		// điều kiện để lấy bản ghi
		$condition = array();
		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('DebtCall/list_contract_call'));
		}
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$condition['start'] = $start;
			$condition['end'] = $end;
		}
		if (!empty($store)) {
			$condition['store_id'] = trim($store);
		}

		if (!empty($customer_name)) {
			$condition['customer_name'] = trim($customer_name);
		}
		if (!empty($email)) {
			$condition['email'] = trim($email);
		}

		if (!empty($code_contract_disbursement)) {
			$condition['code_contract_disbursement'] = trim($code_contract_disbursement);
		}
		if (!empty($code_contract)) {
			$condition['code_contract'] = trim($code_contract);
		}
		if (!empty($status)) {
			$condition['status'] = $status;
		}
		if (!empty($status_contract)) {
			$condition['status_contract'] = $status_contract;
		}
		if (!empty($tab)) {
			$condition['tab'] = $tab;
		}
		//Paginate
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('DebtCall/list_contract_call?code_contract_disbursement=' . $code_contract_disbursement . '&fdate=' . $start . '&tdate=' . $end . '&customer_name=' . $customer_name . '&phone_number=' . $phone_number . '&store=' . $store . '&code_contract=' . $code_contract . '&status=' . $status . '&status_contract=' . $status_contract . '&email=' . $email . '&tab=' .$tab);
		$config['per_page'] = 30;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$condition['per_page'] = $config['per_page'];
		$condition['uriSegment'] = $config['uriSegment'];
		// call api get contract data
		$contractData = $this->api->apiPost($this->userInfo['token'], "DebtCall/get_all_contract_call", $condition);

		if (!empty($contractData->status) && $contractData->status == 200) {
			$config['total_rows'] = $contractData->total;
			$this->data['contractData'] = $contractData->data;
			$this->data['data_review'] = $contractData->data_review;
		} else {
			$this->data['contractData'] = array();
			$this->data['data_review'] = array();
		}
		$total_count_b0 = 0;
		$total_sum_b0 = 0;
		$total_count_b1 = 0;
		$total_sum_b1 = 0;
		$total_count_b2 = 0;
		$total_sum_b2 = 0;
		$total_count_b3 = 0;
		$total_sum_b3 = 0;
		$total_count_b4 = 0;
		$total_sum_b4 = 0;
		$total_count_b5 = 0;
		$total_sum_b5 = 0;
		$total_count_b6 = 0;
		$total_sum_b6 = 0;
		$total_count_b7 = 0;
		$total_sum_b7 = 0;
		$total_count_b8 = 0;
		$total_sum_b8 = 0;
		$total_count_all = 0;
		$total_sum_all = 0;
		if (!empty($contractData->data_review)) {
			foreach ($contractData->data_review as $key => $review) {
				$total_count_b0 += (int)$review->count_b0;
				$total_sum_b0 += (int)$review->sum_b0;
				$total_count_b1 += (int)$review->count_b1;
				$total_sum_b1 += (int)$review->sum_b1;
				$total_count_b2 += (int)$review->count_b2;
				$total_sum_b2 += (int)$review->sum_b2;
				$total_count_b3 += (int)$review->count_b3;
				$total_sum_b3 += (int)$review->sum_b3;
				$total_count_b4 += (int)$review->count_b4;
				$total_sum_b4 += (int)$review->sum_b4;
				$total_count_b5 += (int)$review->count_b5;
				$total_sum_b5 += (int)$review->sum_b5;
				$total_count_b6 += (int)$review->count_b6;
				$total_sum_b6 += (int)$review->sum_b6;
				$total_count_b7 += (int)$review->count_b7;
				$total_sum_b7 += (int)$review->sum_b7;
				$total_count_b8 += (int)$review->count_b8;
				$total_sum_b8 += (int)$review->sum_b8;
				$total_count_all += (int)$review->count_all_by_email;
				$total_sum_all += (int)$review->sum_all_by_email;
			}
		}

		//Role
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		}

		$roles = $this->api->apiPost($this->user['token'], "DebtCall/getRole", array("user_id" => $this->user['id']));
		if (!empty($roles->status) && $roles->status == 200) {
			$this->data['Roles'] = $roles->data;
		}
		// Get DS NV Call
		if (in_array('tbp-thn-mien-bac', $roles->data) || in_array('lead-thn-mien-bac', $roles->data)) {
			$data_debt_email_caller = $this->api->apiPost($this->userInfo['token'], "DebtCall/get_email_user_call_thn_mb", []);
			if (!empty($data_debt_email_caller->status) && $data_debt_email_caller->status == 200) {
				$this->data['debt_caller_emails'] = $data_debt_email_caller->data;
			} else {
				$this->data['debt_caller_emails'] = [];
			}

		} else if (in_array('tbp-thn-mien-nam', $roles->data) || in_array('lead-thn-mien-nam', $roles->data)) {
			$data_debt_email_caller = $this->api->apiPost($this->userInfo['token'], "DebtCall/get_email_user_call_thn_mn", []);
			if (!empty($data_debt_email_caller->status) && $data_debt_email_caller->status == 200) {
				$this->data['debt_caller_emails'] = $data_debt_email_caller->data;
			} else {
				$this->data['debt_caller_emails'] = [];
			}
		}
		// Get DS NV Field
		if (in_array('tbp-thn-mien-bac', $roles->data) || in_array('lead-thn-mien-bac', $roles->data)) {
			$data_debt_email_caller = $this->api->apiPost($this->userInfo['token'], "DebtCall/get_email_user_field_thn_mb", []);
			if (!empty($data_debt_email_caller->status) && $data_debt_email_caller->status == 200) {
				$this->data['debt_field_emails'] = $data_debt_email_caller->data;
			} else {
				$this->data['debt_field_emails'] = [];
			}

		} else if (in_array('tbp-thn-mien-nam', $roles->data) || in_array('lead-thn-mien-nam', $roles->data)) {
			$data_debt_email_caller = $this->api->apiPost($this->userInfo['token'], "DebtCall/get_email_user_field_thn_mn", []);
			if (!empty($data_debt_email_caller->status) && $data_debt_email_caller->status == 200) {
				$this->data['debt_field_emails'] = $data_debt_email_caller->data;
			} else {
				$this->data['debt_field_emails'] = [];
			}
		}

		//get store
		$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all");
		if (!empty($storeData->status) && $storeData->status == 200) {
			$this->data['storeData'] = $storeData->data;
		}
		$this->data['result_count'] = $config['total_rows'];
//		$this->pagination->initialize($config);
//		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['email_user'] = $this->userInfo['email'];
		$this->data['full_name'] = $this->userInfo['full_name'];
		$this->data['total_count_b0'] = $total_count_b0;
		$this->data['total_sum_b0'] = $total_sum_b0;
		$this->data['total_count_b1'] = $total_count_b1;
		$this->data['total_sum_b1'] = $total_sum_b1;
		$this->data['total_count_b2'] = $total_count_b2;
		$this->data['total_sum_b2'] = $total_sum_b2;
		$this->data['total_count_b3'] = $total_count_b3;
		$this->data['total_sum_b3'] = $total_sum_b3;
		$this->data['total_count_b4'] = $total_count_b4;
		$this->data['total_sum_b4'] = $total_sum_b4;
		$this->data['total_count_b5'] = $total_count_b5;
		$this->data['total_sum_b5'] = $total_sum_b5;
		$this->data['total_count_b6'] = $total_count_b6;
		$this->data['total_sum_b6'] = $total_sum_b6;
		$this->data['total_count_b7'] = $total_count_b7;
		$this->data['total_sum_b7'] = $total_sum_b7;
		$this->data['total_count_b8'] = $total_count_b8;
		$this->data['total_sum_b8'] = $total_sum_b8;
		$this->data['total_count_all'] = $total_count_all;
		$this->data['total_sum_all'] = $total_sum_all;
		$this->data['template'] = 'page/debt/contract_call/list_contract_assign_to_call.php';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function list_contract_debt_to_field()
	{
		$this->data['pageName'] = 'Danh sách hợp đồng yêu cầu chuyển Field';
		$this->data['stores'] = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active")->data;
		$this->data['contractData'] = array();
		$this->data['groupRole'] = array();
		$this->data['storeData'] = array();

		//Params
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$phone_number = !empty($_GET['phone_number']) ? $_GET['phone_number'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$status_contract = !empty($_GET['status_contract']) ? $_GET['status_contract'] : "";
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		// điều kiện để lấy bản ghi
		$condition = array();
		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('DebtCall/list_contract_debt_to_field'));
		}
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$condition['start'] = $start;
			$condition['end'] = $end;
		}
		if (!empty($store)) {
			$condition['store_id'] = trim($store);
		}

		if (!empty($customer_name)) {
			$condition['customer_name'] = trim($customer_name);
		}

		if (!empty($code_contract_disbursement)) {
			$condition['code_contract_disbursement'] = trim($code_contract_disbursement);
		}
		if (!empty($code_contract)) {
			$condition['code_contract'] = trim($code_contract);
		}
		if (!empty($status)) {
			$condition['status'] = $status;
		}
		if (!empty($status_contract)) {
			$condition['status_contract'] = $status_contract;
		}

		//Paginate
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('DebtCall/list_contract_debt_to_field?code_contract_disbursement=' . $code_contract_disbursement . '&fdate=' . $start . '&tdate=' . $end . '&customer_name=' . $customer_name . '&phone_number=' . $phone_number . '&store=' . $store . '&code_contract=' . $code_contract . '&status=' . $status . '$status_contract=' . $status_contract);
		$config['per_page'] = 30;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$condition['per_page'] = $config['per_page'];
		$condition['uriSegment'] = $config['uriSegment'];
		// call api get contract data
		$contractData = $this->api->apiPost($this->userInfo['token'], "DebtCall/get_all_contract_to_field", $condition);

		if (!empty($contractData->status) && $contractData->status == 200) {
			$config['total_rows'] = $contractData->total;
			$this->data['contractData'] = $contractData->data;
			$config['total_rows'] = $contractData->total;
		}

		//Role
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		}

		//get store
		$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all");
		if (!empty($storeData->status) && $storeData->status == 200) {
			$this->data['storeData'] = $storeData->data;
		}
		$this->data['result_count'] = $config['total_rows'];
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['email_user'] = $this->userInfo['email'];
		$this->data['full_name'] = $this->userInfo['full_name'];
		$this->data['template'] = 'page/debt/contract_call/list_contract_debt_to_field.php';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function mission_caller()
	{
		$this->data['pageName'] = 'Quản lý nhiệm vụ Call';
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('DebtCall/mission_caller'));
		}

		if (isset($_GET['fdate']) && isset($_GET['tdate'])) {
			$data['start'] = $start;
			$data['end'] = $end;
		}

		$result = $this->api->apiPost($this->userInfo['token'], 'DebtCall/report_mission_debt_caller', $data);
		if (!empty($result->status) && $result->status == 200) {
			$this->data['dataMissionCaller'] = $result->data;
			$this->data['tong_hop_dong_giao'] = $result->tong_hop_dong_giao;
			$this->data['tong_du_no_goc_con_lai'] = $result->tong_du_no_goc_con_lai;
			$this->data['tong_hop_dong_da_tac_dong'] = $result->tong_hop_dong_da_tac_dong;
			$this->data['tong_so_cuoc_goi'] = $result->tong_so_cuoc_goi;
			$this->data['start_time'] = $result->start_time;
			$this->data['end_time'] = $result->end_time;
			$this->data['log_time_to_field'] = $result->log_time_to_field;

		} else {
			$this->data['dataMissionCaller'] = array();
		}
		$this->data['template'] = 'page/debt/contract_call/mission_call_manager.php';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function importContractDebtBzBo()
	{
		//redirect('ImportDatabase');
		if (empty($_FILES['upload_file']['name'])) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('not_selected_file_import')
			];
			echo json_encode($response);
			return;
		} else {
			$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
				$arr_file = explode('.', $_FILES['upload_file']['name']);
				$extension = end($arr_file);
				if ('csv' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}
				$spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
				$sheetData = $spreadsheet->getActiveSheet()->toArray();
				if (count($sheetData[0]) < 4) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "File không đúng định dạng!"
					];
					echo json_encode($response);
					return;
				}
				$sheetDataFilter = array_filter($sheetData, "array_filter");
				$listFail1 = [];
				$listFail2 = [];
				foreach ($sheetDataFilter as $key => $value) {
					if ($key >= 1 && !empty($value["0"])) {
						$data = array(
							"code_contract" => !empty($value["0"]) ? (trim($value["0"])) : "",
							"code_contract_disbursement" => !empty($value["1"]) ? (trim($value["1"])) : "",
							"customer_name" => !empty($value["2"]) ? (trim($value["2"])) : "",
							"email_call" => !empty(trim($value["3"])) ? (trim($value["3"])) : "",
						);

						$return = $this->api->apiPost($this->userInfo['token'], "DebtCall/assign_contract_to_debt_caller", $data);
						if (!empty($return->data1)) {
							array_push($listFail1, $return->data1);
						}
						if (!empty($return->data2)) {
							array_push($listFail2, $return->data2);
						}
					}
				}
				if ($return->status == 200) {
					$response = [
						'res' => true,
						'status' => "200",
						'message' => $this->lang->line('import_success'),
					];
				} else {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => $return->message,
						'data1' => $listFail1,
						'data2' => $listFail2
					];
				}
			} else {
				$response = [
					'res' => false,
					'status' => "400",
					'message' => $this->lang->line('type_invalid')
				];
			}
		}
		echo json_encode($response);
		return;
	}

	public function checkImportContractDebt()
	{
		//redirect('ImportDatabase');
		if (empty($_FILES['upload_file']['name'])) {
			$response = [
				'res' => false,
				'status' => "401",
				'message' => $this->lang->line('not_selected_file_import')
			];
			echo json_encode($response);
			return;
		} else {
			$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
				$arr_file = explode('.', $_FILES['upload_file']['name']);
				$extension = end($arr_file);
				if ('csv' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}
				$spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
				$sheetData = $spreadsheet->getActiveSheet()->toArray();
				if (count($sheetData[0]) < 5) {
					$response = [
						'res' => false,
						'status' => "401",
						'message' => "File không đúng định dạng!"
					];
					echo json_encode($response);
					return;
				}
				$sheetDataFilter = array_filter($sheetData, "array_filter");
				$listFail1 = [];
				$listFail2 = [];
				foreach ($sheetDataFilter as $key => $value) {
					if ($key >= 1 && !empty($value["0"])) {
						$data = array(
							"code_contract" => !empty($value["0"]) ? (trim($value["0"])) : "",
							"code_contract_disbursement" => !empty($value["1"]) ? (trim($value["1"])) : "",
							"customer_name" => !empty($value["2"]) ? (trim($value["2"])) : "",
							"email_call" => !empty(trim($value["3"])) ? (trim($value["3"])) : "",
						);
						$return = $this->api->apiPost($this->user['token'], "DebtCall/check_import_contract", $data);
						if (!empty($return->data1)) {
							array_push($listFail1, $return->data1);
						}
						if (!empty($return->data2)) {
							array_push($listFail2, $return->data2);
						}
					}
				}
				if ($return->status == 200) {
					$response = [
						'res' => true,
						'status' => "200",
						'message' => 'Đã check xong!',
					];
				} else {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => $return->message,
						'data1' => $listFail1,
						'data2' => $listFail2
					];
				}
			} else {
				$response = [
					'res' => false,
					'status' => "400",
					'message' => $this->lang->line('type_invalid')
				];
			}
		}
		echo json_encode($response);
		return;
	}

	public function update_debt_caller()
	{
		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['email_debt_caller'] = $this->security->xss_clean($data['email_debt_caller']);

		$data_send_api = [
			'id' => $data['id'],
			'email_debt_caller' => $data['email_debt_caller']
		];
		$result = $this->api->apiPost($this->userInfo['token'], 'DebtCall/update_email_caller', $data_send_api);
		if (!empty($result->status) && $result->status == 200) {
			$response = [
				'res' => true,
				'status' => '200',
				'msg' => 'Cập nhập thành công!'
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => 'Cập nhật không thành công',
			];
			echo json_encode($response);
			return;
		}
	}

	public function setup_time_to_field()
	{
		$data = $this->input->post();
		$data['contract_caller_id'] = $this->security->xss_clean($data['contract_caller_id']);
		$data['date_range_to_field'] = $this->security->xss_clean($data['date_range_to_field']);

		if (empty($data['contract_caller_id'])) {
			$this->pushJson('200', json_encode(array("status" => 400, "msg" => 'id hợp đồng đang trống!')));
			return;
		}
		if (empty($data['date_range_to_field'])) {
			$this->pushJson('200', json_encode(array("status" => 400, "msg" => 'Ngày setup Field cho hợp đồng đang trống!')));
			return;
		}
		$date_range_convert = strtotime($data['date_range_to_field']);
		$day_of_convert = date('d', $date_range_convert);
//		if ($day_of_convert > 10) {
//			$this->pushJson('200', json_encode(array("status" => '400', "msg" => 'Ngày setup không được lớn hơn ngày 10!')));
//			return;
//		}
		$data_send = [
			'contract_caller_id' => $data['contract_caller_id'],
			'date_range_to_field' => $data['date_range_to_field']
		];

		$result = $this->api->apiPost($this->userInfo['token'], 'DebtCall/setup_time_to_field', $data_send);
		if (!empty($result->status) && $result->status == 200) {
			$this->pushJson('200', json_encode(array('status' => "200", 'msg' => "Thành công!")));
			return;
		} else {
			$this->pushJson('200', json_encode(array("status" => '400', "msg" => $result->message)));
			return;
		}
	}

	public function approve_to_field()
	{
		$data = $this->input->post();
		$data['contract_id'] = $this->security->xss_clean($data['contract_id']);
		$data['status'] = $this->security->xss_clean($data['status']);
		$data['note'] = $this->security->xss_clean($data['note']);

		if (empty($data['contract_id'])) {
			$this->pushJson('200', json_encode(array('status' => "400", 'msg' => "id hợp đồng đang trống!")));
			return;
		}

		$data_send_api = [
			'contract_id' => $data['contract_id'],
			'status' => $data['status'],
			'note' => $data['note']
		];

		$result = $this->api->apiPost($this->userInfo['token'], 'DebtCall/approve_contract_to_field', $data_send_api);
		if (!empty($result->status) && $result->status == 200) {
			$this->pushJson('200', json_encode(array('status' => "200", 'msg' => "Thành công!")));
			return;
		} else {
			$this->pushJson('200', json_encode(array("status" => '400', "msg" => 'Cập nhập thất bại!')));
			return;
		}

	}

	public function showContractDebtLog($contract_id)
	{
		try {
			$contract_id = $this->security->xss_clean($contract_id);
			$condition = ['contract_id' => $contract_id];
			$contractDebt = $this->api->apiPost($this->userInfo['token'], 'DebtCall/get_contract_debt_log', $condition);
			$this->pushJson('200', json_encode(array('code' => '200', 'html' => $contractDebt->html, 'data' => $contractDebt->data)));
		} catch (Exception $exception) {
			show_404();
		}
	}

	public function update_time_field()
	{
		$data = $this->input->post();
		$data['contract_call_id'] = $this->security->xss_clean($data['contract_call_id']);
		$data['time_field'] = $this->security->xss_clean($data['time_field']);
		$data_send_api = [
			'contract_id' => $data['contract_call_id'],
			'time_field' => $data['time_field'],
		];

		$result = $this->api->apiPost($this->userInfo['token'], 'DebtCall/update_time_to_field', $data_send_api);
		if (!empty($result->status) && $result->status == 200) {
			$this->pushJson('200', json_encode(['status' => '200', 'msg' => 'Cập nhập thành công!']));
			return;
		} else {
			$this->pushJson('200', json_encode(['status' => '400', 'msg' => $result->message]));
			return;
		}
	}

	public function setup_time_to_field_all()
	{
		$data = $this->input->post();
		$data['start_time'] = $this->security->xss_clean($data['start_time']);
		$data['end_time'] = $this->security->xss_clean($data['end_time']);

		$data_send_api = [
			"start_time" => $data['start_time'],
			"end_time" => $data['end_time']
		];

		$result = $this->api->apiPost($this->userInfo['token'], "DebtCall/setup_time_to_field_all", $data_send_api);
		if (!empty($result->status) && $result->status == 200) {
			$this->pushJson("200", json_encode(['status' => '200', 'msg' => 'Cài đặt thành công!']));
			return;
		} else {
			$this->pushJson('200', json_encode(['status' => '400', 'msg' => $result->message]));
			return;
		}
	}

	public function getTimeToField()
	{
		try {
			$result = $this->api->apiPost($this->userInfo['token'], 'DebtCall/get_time_to_field',[]);
			$this->pushJson('200', json_encode(array('status' => '200', 'data' => $result->data)));
		} catch (Exception $exception) {
			show_404();
		}

	}

	public function approve_contract_to_call()
	{
		$data = $this->input->post();
		$data['contract_caller_id'] = $this->security->xss_clean($data['contract_caller_id']);
		$data['status'] = $this->security->xss_clean($data['status']);
		$data['note'] = $this->security->xss_clean($data['note']);
		if (empty($data['contract_caller_id'])) {
			$this->pushJson('200', json_encode(array("status" => 400, "msg" => 'id hợp đồng đang trống!')));
			return;
		}
		if (empty($data['status'])) {
			$this->pushJson('200', json_encode(array("status" => 400, "msg" => 'Bạn chưa chọn lý do duyệt!')));
			return;
		}

		$data_send = [
			'contract_caller_id' => $data['contract_caller_id'],
			'status' => $data['status'],
			'note' => $data['note'],
		];

		$result = $this->api->apiPost($this->userInfo['token'], 'DebtCall/approve_all_contract', $data_send);
		 $this->api->apiPost($this->userInfo['token'], 'dashboard_thn/call_update_pos_dau_ky', array('contract_id' => $data['contract_caller_id']));



		if (!empty($result->status) && $result->status == 200) {
			$this->pushJson('200', json_encode(array('status' => "200", 'msg' => "Thành công!")));
			return;
		} else {
			$this->pushJson('200', json_encode(array("status" => '400', "msg" => $result->message)));
			return;
		}
	}

	public function assigned_contract_to_field()
	{
		$data = $this->input->post();
		$data['code_contract'] = $this->security->xss_clean($data['code_contract']);
		$data['status'] = $this->security->xss_clean($data['status']);
		$data['note'] = $this->security->xss_clean($data['note']);
		$data['email_field'] = $this->security->xss_clean($data['email_field']);

		if (empty($data['code_contract'])) {
			$this->pushJson('200', json_encode(array("status" => 400, "msg" => 'Mã phiếu ghi hợp đồng đang trống!')));
			return;
		}
		if (empty($data['email_field'])) {
			$this->pushJson('200', json_encode(array("status" => 400, "msg" => 'Email của nhân viên Field đang trống!!')));
			return;
		}
		if (empty($data['status'])) {
			$this->pushJson('200', json_encode(array("status" => 400, "msg" => 'Bạn chưa chọn lý do duyệt!')));
			return;
		}

		$data_send = [
			'code_contract' => $data['code_contract'],
			'status' => $data['status'],
			'note' => $data['note'],
			'email_field' => $data['email_field']
		];
		$result = $this->api->apiPost($this->userInfo['token'], 'DebtCall/assign_contract_to_debt_field', $data_send);
		if (!empty($result->status) && $result->status == 200) {
			$this->pushJson('200', json_encode(array('status' => "200", 'msg' => "Thành công!")));
			return;
		} else {
			$this->pushJson('200', json_encode(array("status" => '400', "msg" => $result->message)));
			return;
		}
	}

}

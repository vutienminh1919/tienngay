<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Debt_manager_app extends MY_Controller
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

	public function area_manager()
	{
		$debtEmploy = $this->api->apiPost($this->user['token'], "debt_manager_app/get_user_debt");
		if (!empty($debtEmploy->status) && $debtEmploy->status == 200) {
			$this->data['debtEmploy'] = $debtEmploy->data;
		} else {
			$this->data['debtEmploy'] = array();
		}
		$provinces = $this->api->apiPost($this->user['token'], "province/get_province");
		if (!empty($provinces->status) && $provinces->status == 200) {
			$this->data['provinces'] = $provinces->data;
		} else {
			$this->data['provinces'] = array();
		}
		$this->data['template'] = 'page/debt/manager_area';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function get_area_user()
	{
		$id = !empty($_GET['employ']) ? $_GET['employ'] : "";
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('debt_manager_app/get_area_user?employ=' . $id);
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 20;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		if (!empty($id)) {
			$data['id'] = $id;
		}
		$debtEmploy = $this->api->apiPost($this->user['token'], "debt_manager_app/get_user_debt");
		if (!empty($debtEmploy->status) && $debtEmploy->status == 200) {
			$this->data['debtEmploy'] = $debtEmploy->data;
		} else {
			$this->data['debtEmploy'] = array();
		}
		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];
		$area = $this->api->apiPost($this->user['token'], "debt_manager_app/area_user_manager", $data);
		if (!empty($area) && $area->status == 200) {
			$config['total_rows'] = $area->total;
			$this->data['area'] = $area->data;
		} else {
			$this->data['area'] = [];
		}
		$provinces = $this->api->apiPost($this->user['token'], "province/get_province");
		if (!empty($provinces->status) && $provinces->status == 200) {
			$this->data['provinces'] = $provinces->data;
		} else {
			$this->data['provinces'] = array();
		}
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/debt/manager_area';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function block_area_employ()
	{
		try {
			$id = !empty($_GET['id']) ? $_GET['id'] : "";
			if (!empty($id)) {
				$data['id'] = $id;
			}
			$res = $this->api->apiPost($this->user['token'], "debt_manager_app/block_area_field", $data);
			if (!empty($res->status) && $res->status == 200) {
				$this->pushJson('200', json_encode(array("code" => "200", "msg" => $res->message)));
				return;
			}
		} catch (Exception $exception) {
			show_404();
		}

	}

	private function pushJson($code, $data)
	{
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}

	public function get_district_from_province()
	{
		try {
			$id = !empty($_GET['id']) ? $_GET['id'] : "";
			if (!empty($id)) {
				$data['id'] = $id;
			}
			$res = $this->api->apiPost($this->user['token'], "debt_manager_app/get_district_from_province", $data);
			if (!empty($res->status) && $res->status == 200) {
				$this->pushJson('200', json_encode(array("code" => "200", "data" => $res->data, "msg" => $res->message)));
				return;
			}
		} catch (\Exception $exception) {
			show_404();
		}
	}

	public function add_area_for_user()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		$province_debt = !empty($_POST['province']) ? $_POST['province'] : "";
		$district_debt = !empty($_POST['district']) ? $_POST['district'] : "";
		if (!empty($id)) {
			$data['user_id'] = $id;
		}
		if (!empty($province_debt)) {
			$data['province'] = $province_debt;
		}
		if (!empty($district_debt)) {
			$data['district'] = $district_debt;
		}
		$res = $this->api->apiPost($this->user['token'], "debt_manager_app/assignForEmployee", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $res->data, "msg" => $res->message)));
			return;
		} elseif (!empty($res->status) && $res->status == 401) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $res->message)));
			return;
		}
	}

	public function get_list_radio()
	{
		$radio = $this->api->apiPost($this->user['token'], "debt_manager_app/get_list_radio");
		if (!empty($radio->status) && $radio->status == 200) {
			$this->data['radio'] = $radio->data;
		} else {
			$this->data['radio'] = [];
		}
		$this->data['template'] = 'page/debt/manager_radio';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function create_radio_field()
	{
		$B1 = !empty($_POST['b1']) ? $this->security->xss_clean($_POST['b1']) : '';
		$B2 = !empty($_POST['b2']) ? $this->security->xss_clean($_POST['b2']) : '';
		$B3 = !empty($_POST['b3']) ? $this->security->xss_clean($_POST['b3']) : '';
		$B4 = !empty($_POST['b4']) ? $this->security->xss_clean($_POST['b4']) : '';
		$B5 = !empty($_POST['b5']) ? $this->security->xss_clean($_POST['b5']) : '';
		$B6 = !empty($_POST['b6']) ? $this->security->xss_clean($_POST['b6']) : '';
		$B7 = !empty($_POST['b7']) ? $this->security->xss_clean($_POST['b7']) : '';
		$B8 = !empty($_POST['b8']) ? $this->security->xss_clean($_POST['b8']) : '';
		$month = !empty($_POST['month']) ? $this->security->xss_clean($_POST['month']) : '';
		$year = !empty($_POST['year']) ? $this->security->xss_clean($_POST['year']) : '';
		if (!empty($B1)) {
			$data['b1'] = $B1;
		}
		if (!empty($B2)) {
			$data['b2'] = $B2;
		}
		if (!empty($B3)) {
			$data['b3'] = $B3;
		}
		if (!empty($B4)) {
			$data['b4'] = $B4;
		}
		if (!empty($B5)) {
			$data['b5'] = $B5;
		}
		if (!empty($B6)) {
			$data['b6'] = $B6;
		}
		if (!empty($B7)) {
			$data['b7'] = $B7;
		}
		if (!empty($B8)) {
			$data['b8'] = $B8;
		}
		if (!empty($month)) {
			$data['month'] = $month;
		}
		if (!empty($year)) {
			$data['year'] = $year;
		}
		$res = $this->api->apiPost($this->user['token'], "debt_manager_app/create_radio_field", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $res->message)));
			return;
		} elseif (!empty($res->status) && $res->status == 401) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $res->message)));
			return;
		}
	}

	public function block_radio_field()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		if (!empty($id)) {
			$data['id'] = $id;
		}
		$res = $this->api->apiPost($this->user['token'], "debt_manager_app/block_radio_field", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $res->message)));
			return;
		}
	}

	public function showRadio()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		if (!empty($id)) {
			$data['id'] = $id;
		}
		$res = $this->api->apiPost($this->user['token'], "debt_manager_app/showRadio", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", 'data' => $res->data, "msg" => $res->message)));
			return;
		}
	}

	public function updateRadio()
	{
		$id = !empty($_POST['id']) ? $this->security->xss_clean($_POST['id']) : '';
		$B1 = !empty($_POST['b1']) ? $this->security->xss_clean($_POST['b1']) : '';
		$B2 = !empty($_POST['b2']) ? $this->security->xss_clean($_POST['b2']) : '';
		$B3 = !empty($_POST['b3']) ? $this->security->xss_clean($_POST['b3']) : '';
		$B4 = !empty($_POST['b4']) ? $this->security->xss_clean($_POST['b4']) : '';
		$B5 = !empty($_POST['b5']) ? $this->security->xss_clean($_POST['b5']) : '';
		$B6 = !empty($_POST['b6']) ? $this->security->xss_clean($_POST['b6']) : '';
		$B7 = !empty($_POST['b7']) ? $this->security->xss_clean($_POST['b7']) : '';
		$B8 = !empty($_POST['b8']) ? $this->security->xss_clean($_POST['b8']) : '';
		if (!empty($B1)) {
			$data['b1'] = $B1;
		}
		if (!empty($B2)) {
			$data['b2'] = $B2;
		}
		if (!empty($B3)) {
			$data['b3'] = $B3;
		}
		if (!empty($B4)) {
			$data['b4'] = $B4;
		}
		if (!empty($B5)) {
			$data['b5'] = $B5;
		}
		if (!empty($B6)) {
			$data['b6'] = $B6;
		}
		if (!empty($B7)) {
			$data['b7'] = $B7;
		}
		if (!empty($B8)) {
			$data['b8'] = $B8;
		}
		if (!empty($id)) {
			$data['id'] = $id;
		}
		$res = $this->api->apiPost($this->user['token'], "debt_manager_app/updateRadio", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $res->message)));
			return;
		} elseif (!empty($res->status) && $res->status == 401) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $res->message)));
			return;
		}
	}

	public function get_location_user()
	{
		$id = !empty($_GET['location']) ? $_GET['location'] : '';
		if (!empty($id)) {
			$data['user_id'] = $id;
		}
		$debtEmploy = $this->api->apiPost($this->user['token'], "debt_manager_app/get_user_debt");
		if (!empty($debtEmploy->status) && $debtEmploy->status == 200) {
			$this->data['debtEmploy'] = $debtEmploy->data;
		} else {
			$this->data['debtEmploy'] = array();
		}
		$location = $this->api->apiPost($this->user['token'], "debt_manager_app/get_location_user", $data);
		if (!empty($location->status) && $location->status == 200) {
			$this->data['location'] = $location->data;
		} else {
			$this->data['location'] = [];
		}
		$this->data['template'] = 'page/debt/manager_location';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function view_manager_location()
	{
		$debtEmploy = $this->api->apiPost($this->user['token'], "debt_manager_app/get_user_debt");
		if (!empty($debtEmploy->status) && $debtEmploy->status == 200) {
			$this->data['debtEmploy'] = $debtEmploy->data;
		} else {
			$this->data['debtEmploy'] = array();
		}
		$this->data['template'] = 'page/debt/manager_location';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function get_contract_user_debt()
	{
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$phone_number = !empty($_GET['phone_number']) ? $_GET['phone_number'] : "";
		$id_card = !empty($_GET['id_card']) ? $_GET['id_card'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$id = !empty($_GET['userId']) ? $_GET['userId'] : '';
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('debt_manager_app/get_contract_user_debt?userId=' . $id . '&code_contract_disbursement=' . $code_contract_disbursement . '&customer_name=' . $customer_name . '&phone_number=' . $phone_number . '&id_card=' . $id_card);
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 20;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		if (!empty($id)) {
			$data['user_id'] = $id;
		} else {
			$this->session->set_flashdata('error', "Hãy chọn nhân viên trước!");
			redirect(base_url('debt_manager_app/view_manager_contract'));
		}
		if (!empty($id_card)) {
			$data['id_card'] = trim($id_card);
		}
		if (!empty($customer_name)) {
			$data['customer_name'] = trim($customer_name);
		}
		if (!empty($phone_number)) {
			$data['customer_phone_number'] = trim($phone_number);
		}
		if (!empty($code_contract_disbursement)) {
			$data['code_contract_disbursement'] = trim($code_contract_disbursement);
		}
		$debtEmploy = $this->api->apiPost($this->user['token'], "debt_manager_app/get_user_debt");
		if (!empty($debtEmploy->status) && $debtEmploy->status == 200) {
			$this->data['debtEmploy'] = $debtEmploy->data;
		} else {
			$this->data['debtEmploy'] = array();
		}
		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];
		$contract = $this->api->apiPost($this->user['token'], "debt_manager_app/get_contract_user_debt", $data);
		if (!empty($contract->status) && $contract->status == 200) {
			$config['total_rows'] = $contract->total;
			$this->data['contract'] = $contract->data;
			$this->data['total_rows'] = $contract->total;
		} else {
			$this->data['contract'] = array();
		}
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/debt/manager_contract';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function view_manager_contract()
	{
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$phone_number = !empty($_GET['phone_number']) ? $_GET['phone_number'] : "";
		$id_card = !empty($_GET['id_card']) ? $_GET['id_card'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$id = !empty($_GET['userId']) ? $_GET['userId'] : '';
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('debt_manager_app/view_manager_contract?userId=' . $id . '&code_contract_disbursement=' . $code_contract_disbursement . '&customer_name=' . $customer_name . '&phone_number=' . $phone_number . '&id_card=' . $id_card);
//		$config['base_url'] = base_url('debt_manager_app/view_manager_contract');
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 20;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		if (!empty($id)) {
			$data['user_id'] = $id;
		}
		if (!empty($id_card)) {
			$data['id_card'] = trim($id_card);
		}
		if (!empty($customer_name)) {
			$data['customer_name'] = trim($customer_name);
		}
		if (!empty($phone_number)) {
			$data['customer_phone_number'] = trim($phone_number);
		}
		if (!empty($code_contract_disbursement)) {
			$data['code_contract_disbursement'] = trim($code_contract_disbursement);
		}
		$debtEmploy = $this->api->apiPost($this->user['token'], "debt_manager_app/get_user_debt");
		if (!empty($debtEmploy->status) && $debtEmploy->status == 200) {
			$this->data['debtEmploy'] = $debtEmploy->data;
		} else {
			$this->data['debtEmploy'] = array();
		}
		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];
		$contracts = $this->api->apiPost($this->user['token'], "debt_manager_app/get_all_contract_debt", $data);
		if (!empty($contracts->status) && $contracts->status == 200) {
			$this->data['contract'] = $contracts->data;
			$config['total_rows'] = $contracts->total;
			$this->data['total_rows'] = $contracts->total;
		} else {
			$this->data['contract'] = array();
		}
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/debt/manager_contract';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function list_contract_field()
	{
		$this->data['stores'] = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active")->data;
		$this->data['contractData'] = array();
		$this->data['groupRole'] = array();
		$this->data['storeData'] = array();

		//Params
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$customer_phone = !empty($_GET['customer_phone']) ? $_GET['customer_phone'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$status_contract = !empty($_GET['status_contract']) ? $_GET['status_contract'] : "";
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$email = !empty($_GET['email']) ? $_GET['email'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "active";
		$id = !empty($_GET['userId']) ? $_GET['userId'] : '';
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
		if (!empty($customer_phone)) {
			$condition['customer_phone'] = trim($customer_phone);
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
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('Debt_manager_app/list_contract_field?code_contract_disbursement=' . $code_contract_disbursement . '&fdate=' . $start . '&tdate=' . $end . '&customer_name=' . $customer_name . '&customer_phone=' . $customer_phone . '&store=' . $store . '&code_contract=' . $code_contract . '&status=' . $status . '&status_contract=' . $status_contract . '&email=' . $email . '&tab=' . $tab);
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 60;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$condition['per_page'] = $config['per_page'];
		$condition['uriSegment'] = $config['uri_segment'];

		// Role
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
			$data_debt_email_field_mb = $this->api->apiPost($this->userInfo['token'], "DebtCall/get_email_user_field_thn_mb", []);
			$data_email_field_b4_mb = $this->api->apiPost($this->userInfo['token'], "DebtCall/get_email_field_mb_b4", []);
			if (!empty($data_debt_email_field_mb->status) && !empty($data_email_field_b4_mb->status)) {
				$email_field_b4_mb = array_merge($data_debt_email_field_mb->data, $data_email_field_b4_mb->data);
				$unique_email_field_mb = array_unique($email_field_b4_mb);
				$this->data['debt_field_emails'] = $unique_email_field_mb;
			}
		} else if (in_array('tbp-thn-mien-nam', $roles->data) || in_array('lead-thn-mien-nam', $roles->data)) {
			$data_debt_email_field_mn = $this->api->apiPost($this->userInfo['token'], "DebtCall/get_email_user_field_thn_mn", []);
			$data_email_field_b4_mn = $this->api->apiPost($this->userInfo['token'], "DebtCall/get_email_field_mn_b4", []);
			if (!empty($data_debt_email_field_mn->status) && !empty($data_email_field_b4_mn->status)) {
				$email_field_b4_mn = array_merge($data_debt_email_field_mn->data, $data_email_field_b4_mn->data);
				$unique_email_field_mn = array_unique($email_field_b4_mn);
				$this->data['debt_field_emails'] = $unique_email_field_mn;
			}

			if (!empty($data_debt_email_caller->status) && $data_debt_email_caller->status == 200) {
				$this->data['debt_field_emails'] = $data_debt_email_caller->data;
			} else {
				$this->data['debt_field_emails'] = [];
			}
		}
		$contracts = $this->api->apiPost($this->user['token'], "DebtCall/get_all_contract_field", $condition);
		if (!empty($contracts->status) && $contracts->status == 200) {
			$this->data['contractData'] = $contracts->data;
			$this->data['data_review'] = $contracts->data_review;
			$config['total_rows'] = $contracts->total;
		} else {
			$this->data['contract'] = array();
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
		if (!empty($contracts->data_review)) {
			foreach ($contracts->data_review as $key => $review) {
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
		$this->data['result_count'] = $config['total_rows'];
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
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/debt/contract_field/manager_contract.php';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function add_user_debt_contract()
	{
		$user_id = !empty($_POST['user_id']) ? $this->security->xss_clean($_POST['user_id']) : '';
		$id_contract = !empty($_POST['id_contract']) ? $this->security->xss_clean($_POST['id_contract']) : '';
		if (!empty($user_id)) {
			$data['user_id'] = $user_id;
		}
		if (!empty($id_contract)) {
			$data['id_contract'] = $id_contract;
		}
		$res = $this->api->apiPost($this->user['token'], "debt_manager_app/add_user_debt_contract", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $res->message)));
			return;
		} elseif (!empty($res->status) && $res->status == 401) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $res->message)));
			return;
		}
	}

	public function showContractDebt()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		if (!empty($id)) {
			$data['id'] = $id;
		}
		$res = $this->api->apiPost($this->user['token'], "debt_manager_app/showContractDebt", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", 'data' => $res->data, "msg" => $res->message)));
			return;
		}
	}

	public function addAssignUserDebt()
	{
		$id = !empty($_POST['userId']) ? $_POST['userId'] : "";
		$code_contract = !empty($_POST['code_contract']) ? $_POST['code_contract'] : "";
		$note = !empty($_POST['note']) ? $_POST['note'] : "";
		if (!empty($code_contract)) {
			$request['code_contract_disbursement'] = $code_contract;
		}
		$contract = $this->api->apiPost($this->user['token'], "debt_manager_app/getContractDebt", $request);
		if (!empty($contract->status) && $contract->status == 200) {
			$id_contract = $contract->data->_id->{'$oid'};
		} else {
			$id_contract = '';
		}

		if (!empty($id)) {
			$data['user_id'] = $id;
		}

		if (!empty($id_contract)) {
			$data['id_contract'] = $id_contract;
		}

		if (!empty($note)) {
			$data['note'] = $note;
		}
		$res = $this->api->apiPost($this->user['token'], "debt_manager_app/manager_add_user_debt_contract", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $res->message)));
			return;
		} elseif (!empty($res->status) && $res->status == 401) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $res->message)));
			return;
		}
	}

	public function index_import_contract()
	{
		$this->data['template'] = 'page/debt/contract_field/import_contract_to_field.php';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function importContractDebt()
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
						'message' => "Bạn nhập sai định dạng file"
					];
					echo json_encode($response);
					return;
				}
				$listFail1 = [];
				$listFail2 = [];
				foreach ($sheetData as $key => $value) {
					if ($key >= 1) {
						$data = array(
							"code_contract" => !empty($value["0"]) ? (trim($value["0"])) : "",
							"code_contract_disbursement" => !empty($value["1"]) ? (trim($value["1"])) : "",
							"customer_name" => !empty($value["2"]) ? (trim($value["2"])) : "",
							"email_field" => !empty(trim($value["3"])) ? (trim($value["3"])) : "",
						);

//						$return = $this->api->apiPost($this->user['token'], "debt_manager_app/manager_add_user_debt_all_contract", $data);
						$return = $this->api->apiPost($this->user['token'], "DebtCall/assign_contract_to_debt_field", $data);
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
					$roles = $this->api->apiPost($this->user['token'], "DebtCall/getRole", array("user_id" => $this->user['id']));
					if (!empty($roles->status) && $roles->status == 200) {
						$this->data['Roles'] = $roles->data;
					}
					if (in_array('tbp-thn-mien-bac', $roles->data) || in_array('lead-thn-mien-bac', $roles->data)) {
						$user_id_tpthn = $this->api->apiPost($this->userInfo['token'], "DebtCall/get_id_tp_thn_mb_for_cpanel", []);
						if (!empty($user_id_tpthn->status) && $user_id_tpthn->status == 200) {
							$user_id_tpthn_r = $user_id_tpthn->data;
						} else {
							$user_id_tpthn_r = [];
						}
					} else if (in_array('tbp-thn-mien-nam', $roles->data) || in_array('lead-thn-mien-nam', $roles->data)) {
						$user_id_tpthn = $this->api->apiPost($this->userInfo['token'], "DebtCall/get_id_tp_thn_mn_for_cpanel", []);
						if (!empty($user_id_tpthn->status) && $user_id_tpthn->status == 200) {
							$user_id_tpthn_r = $user_id_tpthn->data;
						} else {
							$user_id_tpthn_r = [];
						}
					}

					if (!empty($user_id_tpthn_r)) {
						foreach ($user_id_tpthn_r as $user_id) {
							$data_noti['id_user'] = $user_id;
							$this->api->apiPost($this->userInfo['token'], "DebtCall/push_notification_to_tpthn", $data_noti);
						}
					}
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

	public function checkImportContract()
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
				if (count($sheetData[0]) < 5) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Bạn nhập sai định dạng file"
					];
					echo json_encode($response);
					return;
				}
				$listFail1 = [];
				$listFail2 = [];
				foreach ($sheetData as $key => $value) {
					if ($key >= 1) {
						$data = array(
							"code_contract" => !empty($value["0"]) ? (trim($value["0"])) : "",
							"customer_name" => !empty($value["1"]) ? (trim($value["1"])) : "",
							"customer_phone" => !empty(trim($value["2"])) ? (trim($value["2"])) : "",
							"email" => !empty(trim($value["3"])) ? (trim($value["3"])) : "",
						);
						$return = $this->api->apiPost($this->user['token'], "debt_manager_app/check_import_contract", $data);
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
						'message' => 'success',
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

	public function log_debt()
	{
		$contract_id = !empty($_GET['contract_id']) ? $_GET['contract_id'] : '';
		if (!empty($contract_id)) {
			$data['contract_id'] = $contract_id;
		}
		$res = $this->api->apiPost($this->user['token'], "debt_manager_app/log_debt_user", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", 'data' => $res->data, 'html' => $res->html, "msg" => $res->message)));
			return;
		}
	}

	public function kpi_overView()
	{
		$user_id = !empty($_GET['user_id']) ? $_GET['user_id'] : '';
		if (!empty($user_id)) {
			$data['user_id'] = $user_id;
		}
		$res = $this->api->apiPost($this->user['token'], "debt_manager_app/kpi_overview", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", 'data' => $res->data, "msg" => $res->message)));
			return;
		}
	}

	public function push_noti_user_debt()
	{
		$contract_id = !empty($_GET['contract_id']) ? $_GET['contract_id'] : '';
		$date = !empty($_GET['date']) ? $_GET['date'] : '';
		if (!empty($contract_id)) {
			$data['contract_id'] = $contract_id;
		}
		if (!empty($date)) {
			$data['date'] = $date;
		}
		$res = $this->api->apiPost($this->user['token'], "debt_manager_app/push_noti_user_debt", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $res->message)));
			return;
		}
	}

	public function get_log_call_debt()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$email = !empty($_GET['email']) ? $_GET['email'] : '';
		if (strtotime($fdate) > strtotime($tdate)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('mic_tnds/list_mic_tnds'));
		}
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$data['start'] = $fdate;
			$data['end'] = $tdate;
		}
		if (!empty($email)) {
			$data['email'] = $email;
		}
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('debt_manager_app/get_log_call_debt?fdate=' . $fdate . '&tdate=' . $tdate . '&email=' . $email);
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 20;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];
		$debtEmploy = $this->api->apiPost($this->user['token'], "debt_manager_app/get_all_user_debt");
		if (!empty($debtEmploy->status) && $debtEmploy->status == 200) {
			$this->data['debtEmploy'] = $debtEmploy->data;
		} else {
			$this->data['debtEmploy'] = array();
		}
		$log_call = $this->api->apiPost($this->user['token'], "debt_manager_app/get_log_call_debt", $data);
		if (!empty($log_call->status) && $log_call->status == 200) {
			$this->data['log_call'] = $log_call->data;
			$config['total_rows'] = $log_call->total;
			$this->data['total_rows'] = $log_call->total;
		} else {
			$this->data['log_call'] = array();
		}
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/debt/log_call_debt';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function excelLogCallDebt()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$email = !empty($_GET['email']) ? $_GET['email'] : '';
		if (strtotime($fdate) > strtotime($tdate)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('mic_tnds/list_mic_tnds'));
		}
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$data['start'] = $fdate;
			$data['end'] = $tdate;
		}
		if (!empty($email)) {
			$data['email'] = $email;
		}
		$data['per_page'] = 1000;
		$log_call = $this->api->apiPost($this->user['token'], "debt_manager_app/get_log_call_debt", $data);

		if (!empty($log_call->status) && $log_call->status == 200) {
			$this->exportLogCallDebt($log_call->data);
			$this->callLibExcel('data-log-call-debt' . time() . '.xlsx');

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
			redirect(base_url('debt_manager_app/view_manager_contract'));
		}
	}

	public function exportLogCallDebt($data)
	{
		$this->sheet->setCellValue('A1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('B1', 'Mã hợp đồng');
		$this->sheet->setCellValue('C1', 'Khách hàng');
		$this->sheet->setCellValue('D1', 'Người thực hiện');
		$this->sheet->setCellValue('E1', 'Kết quả nhắc HĐ vay');
		$this->sheet->setCellValue('F1', 'Ghi chú');
		$this->sheet->setCellValue('G1', 'Thời gian thực hiện');
		$i = 2;
		foreach ($data as $value) {
			$this->sheet->setCellValue('A' . $i, $value->code_contract ?? '');
			$this->sheet->setCellValue('B' . $i, $value->code_contract_disbursement ?? '');
			$this->sheet->setCellValue('C' . $i, $value->customer_name ?? '');
			$this->sheet->setCellValue('D' . $i, $value->created_by ?? '');
			$this->sheet->setCellValue('E' . $i, !empty($value->new->note_reminder) ? note_renewal($value->new->note_reminder->reminder) : note_renewal($value->new->result_reminder));
			$this->sheet->setCellValue('F' . $i, !empty($value->new->note_reminder) ? $value->new->note_reminder->note : $value->new->note);
			$this->sheet->setCellValue('G' . $i, !empty($value->created_at) ? date('d/m/Y H:m:s', $value->created_at) : '');
			$i++;
		}
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

	public function contract_is_due()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$id_store = !empty($_GET['store']) ? $_GET['store'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		if (strtotime($fdate) > strtotime($tdate)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('debt_manager_app/contract_is_due'));
		}
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$data['start'] = $fdate;
			$data['end'] = $tdate;
		}
		if (!empty($id_store)) {
			$data['store'] = $id_store;
		}
		if (!empty($customer_name)) {
			$data['customer_name'] = $customer_name;
		}
		if (!empty($code_contract_disbursement)) {
			$data['code_contract_disbursement'] = $code_contract_disbursement;
		}
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('debt_manager_app/contract_is_due?fdate=' . $fdate . '&tdate=' . $tdate . '&store=' . $id_store . '&customer_name=' . $customer_name . '&code_contract_disbursement=' . $code_contract_disbursement);
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 30;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];
		$contract = $this->api->apiPost($this->user['token'], "debt_manager_app/get_contract_is_due", $data);
		if (!empty($contract->status) && $contract->status == 200) {
			$this->data['contracts'] = $contract->data;
			$config['total_rows'] = $contract->total;
			$this->data['total_rows'] = $contract->total;
		} else {
			$this->data['contracts'] = array();
		}
		$stores = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active", $data);
		$this->data['stores'] = $stores->data;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/debt/contract_due';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function approve_contract_assigned_field()
	{
		$data = $this->input->post();
		$data['contract_field_id'] = !empty($this->security->xss_clean($data['contract_field_id'])) ? $this->security->xss_clean($data['contract_field_id']) : '';
		$data['status'] = !empty($this->security->xss_clean($data['status'])) ? $this->security->xss_clean($data['status']) : '';
		$data['note'] = !empty($this->security->xss_clean($data['note'])) ? $this->security->xss_clean($data['note']) : '';
		if (empty($data['contract_field_id'])) {
			$this->pushJson('200', json_encode(array("status" => 400, "msg" => 'Id hợp đồng đang trống!')));
			return;
		}
		if (empty($data['status'])) {
			$this->pushJson('200', json_encode(array("status" => 400, "msg" => 'Bạn chưa chọn lý do duyệt!')));
			return;
		}
		$data_send = [
			'contract_field_id' => $data['contract_field_id'],
			'status' => $data['status'],
			'note' => $data['note'],
		];
		$result = $this->api->apiPost($this->userInfo['token'], 'DebtCall/approve_all_contract_field', $data_send);
		$this->api->apiPost($this->userInfo['token'], 'dashboard_thn/field_update_pos_dau_ky', array('contract_id' => $data['contract_field_id']));
		if (!empty($result->status) && $result->status == 200) {
			$this->pushJson('200', json_encode(array('status' => "200", 'msg' => "Thành công!")));
			return;
		} else {
			$this->pushJson('200', json_encode(array("status" => '400', "msg" => $result->message)));
			return;
		}
	}

	public function showContractFieldLog($contract_id)
	{
		try {
			$contract_id = $this->security->xss_clean($contract_id);
			$condition = ['contract_id' => $contract_id];
			$contractDebt = $this->api->apiPost($this->userInfo['token'], 'DebtCall/get_contract_field_log', $condition);
			$this->pushJson('200', json_encode(array('code' => '200', 'html' => $contractDebt->html, 'data' => $contractDebt->data)));
		} catch (Exception $exception) {
			show_404();
		}
	}

	public function update_debt_field()
	{
		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['email_debt_field'] = $this->security->xss_clean($data['email_debt_field']);

		$data_send_api = [
			'id' => $data['id'],
			'email_debt_field' => $data['email_debt_field']
		];
		$result = $this->api->apiPost($this->userInfo['token'], 'DebtCall/update_email_field', $data_send_api);
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

	public function exportContractAssignField()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$getStore = !empty($_GET['store']) ? $_GET['store'] : "";
		$phone_number = !empty($_GET['phone_number']) ? $_GET['phone_number'] : "";
		$status_contract = !empty($_GET['status_contract']) ? $_GET['status_contract'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$bucket = !empty($_GET['bucket']) ? $_GET['bucket'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$email = !empty($_GET['email']) ? $_GET['email'] : "";
		//	$customer_phone_number= !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "assigned";

		$data = array();
		$data['start'] = !empty($fdate) ? $fdate : "";
		$data['end'] = !empty($tdate) ? $tdate : "";
		$data['store'] = !empty($getStore) ? $getStore : '';
		$data['status_contract'] = !empty($status_contract) ? $status_contract : '';
		$data['status'] = !empty($status) ? $status : '';
		$data['bucket'] = !empty($bucket) ? $bucket : '';
		$data['customer_name'] = !empty($customer_name) ? $customer_name : '';
		$data['phone_number'] = !empty($phone_number) ? $phone_number : '';
		$data['email'] = !empty($email) ? $email : '';
		$data['code_contract_disbursement'] = !empty($code_contract_disbursement) ? $code_contract_disbursement : '';
		$data['code_contract'] = !empty($code_contract) ? $code_contract : '';
		$data['tab'] = !empty($tab) ? $tab : '';

		$data['per_page'] = 10000;
		$contract_debt_field = $this->api->apiPost($this->userInfo['token'], 'DebtCall/get_all_contract_field', $data);
		if (!empty($contract_debt_field->data)) {
			$this->exportContractDebtField($contract_debt_field->data);

			var_dump($fdate . ' -- ' . $tdate);
		} else {
			var_dump("Không có dữ liệu để xuất excel");
		}
	}

	public function exportContractDebtField($contractDebtCall)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('C1', 'Mã hợp đồng');
		$this->sheet->setCellValue('D1', 'Tên khách hàng');
		$this->sheet->setCellValue('E1', 'SDT KH');
		$this->sheet->setCellValue('F1', 'Trạng thái hợp đồng');
		$this->sheet->setCellValue('G1', 'Trạng thái gán Field');
		$this->sheet->setCellValue('H1', 'Nhóm');
		$this->sheet->setCellValue('I1', 'Số ngày chậm trả');
		$this->sheet->setCellValue('J1', 'Gốc còn lại');
		$this->sheet->setCellValue('K1', 'Nhân viên Field');
		$this->sheet->setCellValue('L1', 'Email field');
		$this->sheet->setCellValue('M1', 'Phòng giao dịch');
		$this->sheet->setCellValue('N1', 'Trạng thái xử lý của Field');

		$i = 2;
		foreach ($contractDebtCall as $contract_field) {
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($contract_field->code_contract) ? $contract_field->code_contract : "");
			$this->sheet->setCellValue('C' . $i, !empty($contract_field->code_contract_disbursement) ? $contract_field->code_contract_disbursement : "");
			$this->sheet->setCellValue('D' . $i, !empty($contract_field->customer_name) ? $contract_field->customer_name : "");
			$this->sheet->setCellValue('E' . $i, !empty($contract_field->customer_phone_number) ? $contract_field->customer_phone_number : "");
			$this->sheet->setCellValue('F' . $i, !empty($contract_field->status_contract) ? contract_status($contract_field->status_contract) : "");
			$this->sheet->setCellValue('G' . $i, !empty($contract_field->status) ? status_contract_field($contract_field->status) : "");
			$this->sheet->setCellValue('H' . $i, !empty($contract_field->bucket) ? ($contract_field->bucket) : "");
			$this->sheet->setCellValue('I' . $i, !empty($contract_field->time_due) ? $contract_field->time_due : 0);
			$this->sheet->setCellValue('J' . $i, !empty($contract_field->pos) ? $contract_field->pos : "");
			$this->sheet->setCellValue('K' . $i, !empty($contract_field->debt_field_name) ? $contract_field->debt_field_name : "");
			$this->sheet->setCellValue('L' . $i, !empty($contract_field->debt_field_email) ? $contract_field->debt_field_email : "");
			$this->sheet->setCellValue('M' . $i, !empty($contract_field->store_name) ? $contract_field->store_name : "");
			$this->sheet->setCellValue('N' . $i, !empty($contract_field->evaluate) ? status_debt_recovery($contract_field->evaluate) : "");
			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('ExportContractAssignField' . time() . '.xlsx');
	}

	public function assigned_contract_back_to_caller()
	{
		$data = $this->input->post();
		$data['code_contract'] = $this->security->xss_clean($data['code_contract']);
		$data['status'] = $this->security->xss_clean($data['status']);
		$data['note'] = $this->security->xss_clean($data['note']);
		$data['email_call'] = $this->security->xss_clean($data['email_call']);

		if (empty($data['code_contract'])) {
			$this->pushJson('200', json_encode(array("status" => 400, "msg" => 'Mã phiếu ghi hợp đồng đang trống!')));
			return;
		}
		if (empty($data['email_call'])) {
			$this->pushJson('200', json_encode(array("status" => 400, "msg" => 'Email của nhân viên Call đang trống!!')));
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
			'email_call' => $data['email_call']
		];
		$result = $this->api->apiPost($this->userInfo['token'], 'DebtCall/assign_contract_to_debt_caller', $data_send);
		if (!empty($result->status) && $result->status == 200) {
			$this->pushJson('200', json_encode(array('status' => "200", 'msg' => "Thành công!")));
			return;
		} else {
			$this->pushJson('200', json_encode(array("status" => '400', "msg" => $result->message)));
			return;
		}
	}

	public function view_contract()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$id_card = !empty($_GET['id_card']) ? $_GET['id_card'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : 17;
		$loan_product = !empty($_GET['loan_product']) ? $_GET['loan_product'] : "";
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('debt_manager_app/view_contract?code_contract_disbursement=' . $code_contract_disbursement . '&customer_name=' . $customer_name . '&id_card=' . $id_card . '&fdate=' . $start . '&tdate=' . $end . '&code_contract=' . $code_contract . '&loan_product=' . $loan_product);
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 20;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;

		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('debt_manager_app/view_contract'));
		}
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$data['start'] = $start;
			$data['end'] = $end;
		}

		if (!empty($id_card)) {
			$data['id_card'] = trim($id_card);
		}
		if (!empty($customer_name)) {
			$data['customer_name'] = trim($customer_name);
		}
		if (!empty($code_contract_disbursement)) {
			$data['code_contract_disbursement'] = trim($code_contract_disbursement);
		}
		if (!empty($code_contract)) {
			$data['code_contract'] = trim($code_contract);
		}
		if (!empty($store)) {
			$data['store'] = trim($store);
		}
		if (!empty($status)) {
			$data['status'] = trim($status);
		}
		if (!empty($loan_product)) {
			$data['loan_product'] = trim($loan_product);
		}
		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];

		$contracts = $this->api->apiPost($this->user['token'], "debt_manager_app/contract_tempo_debt_ho", $data);
		if (!empty($contracts->status) && $contracts->status == 200) {
			$this->data['contract'] = $contracts->data;
			$config['total_rows'] = $contracts->total;
			$this->data['total_rows'] = $contracts->total;
		} else {
			$this->data['contract'] = array();
		}

		$stores = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active", $data);
		$store = $this->api->apiPost($this->userInfo['token'], "mic_tnds/get_store_by_user", $data);
		//lấy id_store của user theo session hiện tại
		$arr_store = [];
		foreach ($this->userInfo['stores'] as $st) {
			$arr_store += [$st->store_id => $st->store_name];
		}
		$this->data['stores'] = $arr_store;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/accountant/contract_ho';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
}

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Dashboard_thn extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		// $this->api = new Api();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url', 'file'));
		$this->load->helper('lead_helper');
		$this->load->model("main_property_model");
		$this->load->model('config_gic_model');
		$this->load->model("time_model");
		$this->load->library('pagination');
		$this->config->load('config');

		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";

		$this->spreadsheet = new Spreadsheet();
		$this->spreadsheet->setActiveSheetIndex(0);

		$this->sheet = $this->spreadsheet->getActiveSheet();

	}

	public function index_groupRole_thn(){


		$groupRoles = $this->api->apiPost($this->user['token'], "dashboard_thn/groupRoles_get_all");

		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles;
		} else {
			$this->data['groupRoles'] = array();
		}

		$this->data['template'] = 'page/dashboard_thn/groupRole_thn';
		$this->load->view('template', isset($this->data)?$this->data:NULL);
	}

	public function displayCreate() {
		$this->data["pageName"] = $this->lang->line('group_role_management');

		$this->data['template'] = 'page/dashboard_thn/groupRole_create';
		$this->load->view('template', isset($this->data)?$this->data:NULL);
	}

	public function create() {
		$data = $this->input->post();
		$this->data['role_name'] = $this->security->xss_clean($data['role_name']);
		$this->data['role_code'] = $this->security->xss_clean($data['role_code']);
		$this->data['role_area'] = $this->security->xss_clean($data['role_area']);
		$this->data['role_function'] = $this->security->xss_clean($data['role_function']);
		$this->data['users'] = $this->security->xss_clean($data['users']);
		$this->data['users'] = json_decode($data['users']);

		$insert = array();
		$insert['status'] = "active";
		$insert['name'] = $this->data['role_name'];
		$insert['slug'] = slugify($this->data['role_name']);

		$insert['role_code'] = $this->data['role_code'];
		$insert['role_area'] = $this->data['role_area'];
		$insert['role_function'] = $this->data['role_function'];

		$insert['created_at'] = $this->createdAt;
		$insert['created_by'] = $this->data['userSession']['id'];
		if(count($this->data['users']) > 0) {
			$insert['users'] = $this->data['users'];
		}

		$this->api->apiPost($this->user['token'], "dashboard_thn/create", $insert);
		$this->pushJson('200', json_encode(array("code" => "200", "data" => $this->data)));
	}

	public function displayUpdate() {

		$dataGet = $this->input->get();
		$this->data['id'] = $this->security->xss_clean($dataGet['id']);
		$dataPost = array(
			"id" => $this->data['id']
		);
		$role = $this->api->apiPost($this->user['token'], "dashboard_thn/get_one", $dataPost);
		$this->data['template'] = 'page/dashboard_thn/groupRole_update';
		$this->data['role'] = $role->data;
		$this->load->view('template', isset($this->data)?$this->data:NULL);
	}

	public function delete() {
		$dataPost = $this->input->post();
		$this->data['id'] = $this->security->xss_clean($dataPost['id']);
		$post = array(
			"id" => $this->data['id']
		);
		$this->api->apiPost($this->user['token'], "dashboard_thn/delete", $post);
		$this->pushJson('200', json_encode(array("code" => "200", "data" => $this->lang->line('Delete_success'))));
	}

	private function pushJson($code, $data)
	{
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}

	public function update() {
		$data = $this->input->post();
		$this->data['role_name'] = $this->security->xss_clean($data['role_name']);
		$this->data['role_code'] = $this->security->xss_clean($data['role_code']);
		$this->data['role_area'] = $this->security->xss_clean($data['role_area']);
		$this->data['role_function'] = $this->security->xss_clean($data['role_function']);
		$this->data['users'] = $this->security->xss_clean($data['users']);
		$this->data['role_id'] = $this->security->xss_clean($data['role_id']);
		$this->data['users'] = json_decode($data['users']);

		if(empty($this->data['role_id']) || empty($this->data['role_name'])) {
			$this->pushJson('200', json_encode(array("code" => "201", "message" => $this->lang->line('Rights_group_name_empty'))));
			return;
		}

		$update = array();
		$update['users'] = "";
		$update['role_id'] = $this->data['role_id'];
		$update['name'] = $this->data['role_name'];
		$update['role_code'] = $this->data['role_code'];
		$update['role_area'] = $this->data['role_area'];
		$update['role_function'] = $this->data['role_function'];
		if(count($this->data['users']) > 0) {
			$update['users'] = $this->data['users'];
		}
		$res = $this->api->apiPost($this->user['token'], "dashboard_thn/update", $update);
		$this->pushJson('200', json_encode(array("code" => "200", "message" => $res)));
	}

	public function index_report_recording(){

		$data = [];
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$get_call = !empty($_GET['get_call']) ? $_GET['get_call'] : "";
		$hangupCause = !empty($_GET['hangupCause']) ? $_GET['hangupCause'] : "";
		$email_thn = !empty($_GET['email_thn']) ? $_GET['email_thn'] : "";

		if (!empty($fdate)) {
			$data['fdate'] = $fdate;
		}
		if (!empty($tdate)) {
			$data['tdate'] = $tdate;
		}
		if (!empty($get_call)) {
			$data['get_call'] = $get_call;
		}
		if (!empty($hangupCause)) {
			$data['hangupCause'] = $hangupCause;
		}
		if (!empty($email_thn)) {
			$data['email_thn'] = $email_thn;
		}

		$count = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/count_user_report_recording",$data);
		$count = (int)$count->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('dashboard_thn/index_report_recording?fdate=' . $fdate . '&tdate=' . $tdate . '&get_call=' . $get_call . '&email_thn=' . $email_thn . '&hangupCause=' . $hangupCause);
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;

		$data["per_page"] = $config['per_page'];
		$data["uriSegment"] = $config['uri_segment'];

		$data_report_thn = $this->api->apiPost($this->user['token'], "dashboard_thn/report_recording", $data);

		if (!empty($data_report_thn->status) && $data_report_thn->status == 200) {
			$this->data['data_report_thn'] = $data_report_thn->data;
			$this->data['NO_USER_RESPONSE'] = $data_report_thn->NO_USER_RESPONSE;
			$this->data['USER_BUSY'] = $data_report_thn->USER_BUSY;
			$this->data['NORMAL_CLEARING'] = $data_report_thn->NORMAL_CLEARING;
			$this->data['ORIGINATOR_CANCEL'] = $data_report_thn->ORIGINATOR_CANCEL;
		} else {
			$this->data['data_report_thn'] = array();
		}

		$this->data['template'] = 'page/dashboard_thn/report_recording';
		$this->load->view('template', isset($this->data)?$this->data:NULL);

	}

	public function setup_kpi_thn(){

		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";

		$data = array();
		$data['start'] = $start;

		$data_call_thn = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/get_all_list_thn", $data);

		if (!empty($data_call_thn->status) && $data_call_thn->status == 200) {
			$this->data['data_call_thn'] = $data_call_thn->call_thn;
			$this->data['data_field_thn'] = $data_call_thn->field;
			$this->data['data_field_b4'] = $data_call_thn->field_b4;
			$this->data['tbp_thn'] = $data_call_thn->tbp_thn;
			$this->data['leader_call'] = $data_call_thn->leader_call;
			$this->data['leader_field'] = $data_call_thn->leader_field;

		} else {
			$this->data['data_call_thn'] = array();
			$this->data['data_field_thn'] = array();
			$this->data['data_field_b4'] = array();
			$this->data['tbp_thn'] = array();
			$this->data['leader_call'] = array();
			$this->data['leader_field'] = array();
		}

		$this->data['template'] = 'page/dashboard_thn/setup_kpi_thn';
		$this->load->view('template', isset($this->data)?$this->data:NULL);
	}

	public function doAddKpi_thn(){

		$start = !empty($_POST['fdate_export']) ? $_POST['fdate_export'] : "";

		if (empty($start)) {

			$response = [
				'res' => false,
				'status' => "400",
				'message' =>'Bạn cần chọn tháng KPI'
			];
			echo json_encode($response);
			return;
		}

		$data = array(
			"start" => $start,
		);

		$return = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/create_kpi_thn", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('create_kpi_success')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('create_kpi_failed')
			];
			echo json_encode($response);
			return;
		}


	}

	public function update_thn(){

		$data = $this->input->post();
		$data['field'] = $this->security->xss_clean($data['field']);
		$data['value'] = $this->security->xss_clean($data['value']);
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['bucket'] = $this->security->xss_clean($data['bucket']);

		$condition = array(
			'id' => $data['id'],
			"field" => $data['field'],
			"value" => $data['value'],
			"bucket" => $data['bucket'],
			"updated_by" => $this->user['email']


		);

		$this->api->apiPost($this->user['token'], "dashboard_thn/update_kpi_thn", $condition);

	}

	public function update_thn_hoahong(){

		$data = $this->input->post();
		$data['field'] = $this->security->xss_clean($data['field']);
		$data['value'] = $this->security->xss_clean($data['value']);
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['item'] = $this->security->xss_clean($data['bucket']);

		$condition = array(
			'id' => $data['id'],
			"field" => $data['field'],
			"value" => $data['value'],
			"item" => $data['item'],
			"updated_by" => $this->user['email'],
			'updated_at' => $this->createdAt
		);

		$this->api->apiPost($this->user['token'], "dashboard_thn/update_thn_hoahong", $condition);

	}

	public function view_dashboard_thn(){

		$search_thn = !empty($_GET['search_thn']) ? $_GET['search_thn'] : '';

		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$data = array();
		$data['start'] = $start;

		$groupRoles = $this->api->apiPost($this->session->userdata('user')['token'], "groupRole/getGroupRole", array("user_id" => $this->session->userdata('user')['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}


		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			if ((in_array('tp-thn-mien-bac',$groupRoles->data) || in_array('tp-thn-mien-nam',$groupRoles->data)) && !in_array('quan-ly-cap-cao',$groupRoles->data)){

				$report = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/view_dashboard_thn_manager", $data);

				if (!empty($report->status) && $report->status == 200) {

					$this->data['tong_du_no_duoc_giao'] = $report->tong_du_no_duoc_giao;
					$this->data['tong_du_no_duoc_giao_b1b3'] = $report->tong_du_no_duoc_giao_b1b3;
					$this->data['tong_du_no_duoc_giao_field_b4'] = $report->tong_du_no_duoc_giao_field_b4;
					$this->data['tong_du_no_thu_duoc'] = $report->tong_du_no_thu_duoc;
					$this->data['tong_tien_thu_duoc'] = $report->tong_tien_thu_duoc;


					$this->data['tong_du_no_duoc_giao_b0b3'] = $report->tong_du_no_duoc_giao_b0b3;
					$this->data['tong_du_no_thu_duoc_b0b3'] = $report->tong_du_no_thu_duoc_b0b3;
					$this->data['tong_du_no_duoc_giao_field_b1b3'] = $report->tong_du_no_duoc_giao_field_b1b3;
					$this->data['tong_du_no_thu_duoc_field_b1b3'] = $report->tong_du_no_thu_duoc_field_b1b3;

					$this->data['tong_du_no_thu_duoc_field_b4'] = $report->tong_du_no_thu_duoc_field_b4;

					$this->data['total_thuc_thu'] = $report->total_thuc_thu;

					$this->data['kpi_call'] = $report->kpi_call;
					$this->data['kpi_call_top'] = $report->kpi_call_top;
					$this->data['kpi_field'] = $report->kpi_field;
					$this->data['kpi_field_top'] = $report->kpi_field_top;
					$this->data['kpi_field_b4'] = $report->kpi_field_b4;
					$this->data['kpi_field_top_b4'] = $report->kpi_field_top_b4;
					$this->data['kpi_tp_thn'] = $report->kpi_tp_thn;
					$this->data['all_arr'] = $report->all_arr;
					$this->data['tong_tien_hoa_hong'] = $report->tong_tien_hoa_hong;

					$this->data['arr_call_price'] = $report->arr_call_price;
					$this->data['arr_call_price_top'] = $report->arr_call_price_top;
					$this->data['arr_field_price'] = $report->arr_field_price;
					$this->data['arr_field_price_top'] = $report->arr_field_price_top;


				}

				$kpi_month = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/get_all_month_kpi",["search_thn" => $search_thn]);
				if (!empty($kpi_month->status) && $kpi_month->status == 200) {
					$arr_month = [0,0,0,0,0,0,0,0,0,0,0,0];
					for ($i=1;$i<13;$i++){
						$number = $i;
						if ($i<10){
							$number = "0$i";
						}

						foreach ($kpi_month->data as $value){
							if ($number == $value->month){
								$arr_month[$i-1] = $value->kpi;
							}
						}
					}
					$this->data['kpi_month'] = $arr_month;
				}
				$this->data['template'] = 'page/dashboard_thn/manager.php';
			}
		}
		$this->load->view('template', isset($this->data)?$this->data:NULL);

	}

	public function view_dashboard_nhanvien_thn(){

		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$data = array();
		$data['start'] = $start;

		$array_user = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/check_user_call_field");

		if (!empty($array_user->status) && $array_user->status == 200) {

			$user_email = $this->userInfo['email'];

			if (in_array($user_email, $array_user->data)){

				$report = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/view_dashboard_thn_nhanvien_call",$data);

				if (!empty($report->status) && $report->status == 200) {
					$this->data['tong_du_no_duoc_giao_call'] = $report->tong_du_no_duoc_giao_call;
					$this->data['tong_du_no_thu_duoc_call'] = $report->tong_du_no_thu_duoc_call;
					$this->data['total_thuc_thu'] = $report->total_thuc_thu;
					$this->data['kpi_user'] = $report->kpi_user;
					$this->data['tong_tien_hoa_hong'] = $report->tong_tien_hoa_hong;

				}
				$this->data['template'] = 'page/dashboard_thn/nhanvien.php';
			} else {

				$report = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/view_dashboard_thn_nhanvien_field",$data);

				if (!empty($report->status) && $report->status == 200) {

					$this->data['tong_du_no_duoc_giao_field'] = $report->tong_du_no_duoc_giao_field;
					$this->data['tong_du_no_duoc_giao_field_b1b3'] = $report->tong_du_no_duoc_giao_field_b1b3;
					$this->data['tong_du_no_duoc_giao_field_b4'] = $report->tong_du_no_duoc_giao_field_b4;
					$this->data['tong_du_no_thu_duoc'] = $report->tong_du_no_thu_duoc;
					$this->data['tong_du_no_thu_duoc_field_b1b3'] = $report->tong_du_no_thu_duoc_field_b1b3;
					$this->data['tong_du_no_thu_duoc_field_b4'] = $report->tong_du_no_thu_duoc_field_b4;
					$this->data['total_thuc_thu'] = $report->total_thuc_thu;
					$this->data['kpi'] = $report->kpi;
					$this->data['tong_tien_hoa_hong'] = $report->tong_tien_hoa_hong;


				}

				$this->data['template'] = 'page/dashboard_thn/nhanvien_field.php';

			}
			$kpi_month = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/get_all_month_kpi",["search_thn" => $search_thn]);
			if (!empty($kpi_month->status) && $kpi_month->status == 200) {
				$arr_month = [0,0,0,0,0,0,0,0,0,0,0,0];
				for ($i=1;$i<13;$i++){
					$number = $i;
					if ($i<10){
						$number = "0$i";
					}

					foreach ($kpi_month->data as $value){
						if ($number == $value->month){
							$arr_month[$i-1] = $value->kpi;
						}
					}
				}

				$this->data['kpi_month'] = $arr_month;
			}

		}

		$this->load->view('template', isset($this->data)?$this->data:NULL);
	}

	public function view_dashboard_lead_thn(){

		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$data = array();
		$data['start'] = $start;

		$array_user = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/check_user_call_field_lead");

		if (!empty($array_user->status) && $array_user->status == 200) {

			$user_email = $this->userInfo['email'];

			if (in_array($user_email, $array_user->data)){

				$report = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/view_dashboard_lead_call",$data);

				if (!empty($report->status) && $report->status == 200) {

					$this->data['tong_du_no_duoc_giao_call'] = $report->tong_du_no_duoc_giao_call;
					$this->data['tong_du_no_thu_duoc_call'] = $report->tong_du_no_thu_duoc_call;
					$this->data['arr_du_no_giao'] = $report->arr_du_no_giao;
					$this->data['kpi_call'] = $report->kpi_call;
					$this->data['kpi_call_top'] = $report->kpi_call_top;
					$this->data['total_thuc_thu'] = $report->total_thuc_thu;
					$this->data['kpi_lead_call'] = $report->kpi_lead_call;

					$this->data['tong_tien_hoa_hong'] = $report->tong_tien_hoa_hong;
					$this->data['arr_call_price'] = $report->arr_call_price;
					$this->data['arr_call_price_top'] = $report->arr_call_price_top;



				}
				$this->data['template'] = 'page/dashboard_thn/lead.php';
			} else {

				$report = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/view_dashboard_lead_field", $data);

				if (!empty($report->status) && $report->status == 200) {

					$this->data['tong_du_no_duoc_giao_field'] = $report->tong_du_no_duoc_giao_field;
					$this->data['tong_du_no_duoc_giao_field_b1b3'] = $report->tong_du_no_duoc_giao_field_b1b3;
					$this->data['tong_du_no_duoc_giao_field_b4'] = $report->tong_du_no_duoc_giao_field_b4;
					$this->data['tong_du_no_thu_duoc'] = $report->tong_du_no_thu_duoc;
					$this->data['arr_du_no_giao_b1b3'] = $report->arr_du_no_giao_b1b3;
					$this->data['arr_du_no_giao_b4'] = $report->arr_du_no_giao_b4;

					$this->data['kpi_field'] = $report->kpi_field;
					$this->data['kpi_field_top'] = $report->kpi_field_top;
					$this->data['kpi_field_b4'] = $report->kpi_field_b4;
					$this->data['kpi_field_top_b4'] = $report->kpi_field_top_b4;
					$this->data['total_thuc_thu'] = $report->total_thuc_thu;
					$this->data['kpi_lead_field'] = $report->kpi_lead_field;

					$this->data['tong_tien_hoa_hong'] = $report->tong_tien_hoa_hong;
					$this->data['arr_field_price'] = $report->arr_field_price;
					$this->data['arr_field_price_top'] = $report->arr_field_price_top;




				}

				$this->data['template'] = 'page/dashboard_thn/lead_field.php';

			}
			$kpi_month = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/get_all_month_kpi",["search_thn" => $search_thn,'kpi_lead' => '1']);
			if (!empty($kpi_month->status) && $kpi_month->status == 200) {
				$arr_month = [0,0,0,0,0,0,0,0,0,0,0,0];
				for ($i=1;$i<13;$i++){
					$number = $i;
					if ($i<10){
						$number = "0$i";
					}
					foreach ($kpi_month->data as $value){
						if ($number == $value->month){
							$arr_month[$i-1] = $value->kpi;
						}
					}
				}
				$this->data['kpi_month'] = $arr_month;
			}

		}

		$this->load->view('template', isset($this->data)?$this->data:NULL);
	}


	public function setup_hh_thn(){

		$data_setup_hh_thn = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/setup_hh_thn");

		if (!empty($data_setup_hh_thn->status) && $data_setup_hh_thn->status == 200) {
			$this->data['data'] = $data_setup_hh_thn->data;

		} else {
			$this->data['data'] = [];
		}


		$this->data['template'] = 'page/dashboard_thn/setup_hoahong.php';
		$this->load->view('template', isset($this->data)?$this->data:NULL);

	}

	public function index_report_debt(){

		$this->data['template'] = 'page/dashboard_thn/report_debt.php';
		$this->load->view('template', isset($this->data)?$this->data:NULL);

	}

	public function index_export_excel_debt(){



		$this->data['template'] = 'page/dashboard_thn/indexExportDebt.php';
		$this->load->view('template', isset($this->data)?$this->data:NULL);

	}

	public function exportExcelDebt(){

		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : date('Y-m-d');
		$area = !empty($_GET['area']) ? $_GET['area'] : "";
		$data = [];
		if (!empty($tdate)) {
			$data['tdate'] = $tdate;
		}
		if (!empty($area)) {
			$data['area'] = $area;
		}

		$contractData = $this->api->apiPost($this->userInfo['token'], "report_kpi/get_all_data_contract", $data);

		if (!empty($contractData->data)) {
			$this->exportExcelDebt_data($contractData->data);

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}


	}

	public function exportExcelDebt_data($data)
	{

		$this->sheet->setCellValue('A1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('B1', 'Mã hợp đồng');
		$this->sheet->setCellValue('C1', 'Tên khách hàng');
		$this->sheet->setCellValue('D1', 'Số tiền giải ngân');
		$this->sheet->setCellValue('E1', 'Hình thức vay');
		$this->sheet->setCellValue('F1', 'Sản phẩm vay');
		$this->sheet->setCellValue('G1', 'Tiền kỳ');
		$this->sheet->setCellValue('H1', 'Ngày trễ');
		$this->sheet->setCellValue('I1', 'Bucket');
		$this->sheet->setCellValue('J1', 'Ngày thanh toán gần nhất');
		$this->sheet->setCellValue('K1', 'Số kỳ đã thanh toán');
		$this->sheet->setCellValue('L1', 'Gốc còn lại');
		$this->sheet->setCellValue('M1', 'PGD');
		$this->sheet->setCellValue('N1', 'CMT/CCCD/Hộ chiếu');
		$this->sheet->setCellValue('O1', 'Số điện thoại');
		$this->sheet->setCellValue('P1', 'Tỉnh hộ khẩu');
		$this->sheet->setCellValue('Q1', 'Quận/Huyện hộ khẩu');
		$this->sheet->setCellValue('R1', 'Xã/Phường hộ khẩu');
		$this->sheet->setCellValue('S1', 'Địa chỉ hộ khẩu');
		$this->sheet->setCellValue('T1', 'Quận/Huyện theo HĐ đang vay (PGD KH ĐANG VAY)');
		$this->sheet->setCellValue('U1', 'Tỉnh/ theo HĐ đang vay (PGD KH ĐANG VAY)');
		$this->sheet->setCellValue('V1', 'Khu vực/ theo HĐ đang vay (PGD KH ĐANG VAY)');
		$this->sheet->setCellValue('W1', 'Code trạng thái');
		$this->sheet->setCellValue('X1', 'Địa chỉ tạm trú');
		$this->sheet->setCellValue('Y1', 'Địa chỉ nơi làm việc');
		$this->sheet->setCellValue('Z1', 'Hình thức cư trú');
		$this->sheet->setCellValue('AA1', 'Ngày giải ngân');
		$this->sheet->setCellValue('AB1', 'Gán định vị');
		$this->sheet->setCellValue('AC1', 'IMEI Device VSET');
		$this->sheet->setCellValue('AD1', 'CVKD tạo hợp đồng');
		$this->sheet->setCellValue('AE1', 'Người theo dõi hợp đồng');
		$this->sheet->setCellValue('AF1', 'Ngày kỳ trả');



		$i = 2;
		foreach ($data as $key => $value) {

			$typePay = "";
			$type_interest = !empty($value->loan_infor->type_interest) ? $value->loan_infor->type_interest : "";
			if ($type_interest == 1) {
				$typePay = "Lãi hàng tháng, gốc hàng tháng";
			} else {
				$typePay = "Lãi hàng tháng, gốc cuối kỳ";
			}

			$is_device_vset = 'Không có';
			if (!empty($value->loan_infor->device_asset_location)) {
				$is_device_vset = 'Có';
			} else {
				$is_device_vset = 'Không có';
			}

			$this->sheet->setCellValue('A' . $i, !empty($value->code_contract) ? $value->code_contract : '');
			$this->sheet->setCellValue('B' . $i, !empty($value->code_contract_disbursement) ? $value->code_contract_disbursement : '');
			$this->sheet->setCellValue('C' . $i, !empty($value->customer_infor->customer_name) ? $value->customer_infor->customer_name : '');
			$this->sheet->setCellValue('D' . $i, !empty($value->loan_infor->amount_money) ? $value->loan_infor->amount_money : 0)
				->getStyle('D' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('E' . $i, $typePay . ' - ' . $value->loan_infor->number_day_loan / 30 . ' tháng');
			$this->sheet->setCellValue('F' . $i, !empty($value->loan_infor->type_property->text) ? $value->loan_infor->type_property->text : "");
			$this->sheet->setCellValue('G' . $i, !empty($value->tien_ky) ? $value->tien_ky : 0)
				->getStyle('G' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('H' . $i, !empty($value->debt->so_ngay_cham_tra) ? $value->debt->so_ngay_cham_tra : 0);
			$this->sheet->setCellValue('I' . $i, !empty($value->debt->so_ngay_cham_tra) && $value->debt->so_ngay_cham_tra != 0 ? get_bucket($value->debt->so_ngay_cham_tra) : "B0");
			$this->sheet->setCellValue('J' . $i, !empty($value->ky_thanh_toan_gan_nhat) ? date('d/m/Y', $value->ky_thanh_toan_gan_nhat) : "");
			$this->sheet->setCellValue('K' . $i, !empty($value->so_ki_thanh_toan) ? $value->so_ki_thanh_toan : 0);
			$this->sheet->setCellValue('L' . $i, !empty($value->original_debt->du_no_goc_con_lai) ? $value->original_debt->du_no_goc_con_lai : 0)
				->getStyle('L' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('M' . $i, !empty($value->store->name) ? $value->store->name . ', ' . $value->province : "");
			$this->sheet->setCellValue('N' . $i, !empty($value->customer_infor->customer_identify) ? $value->customer_infor->customer_identify ?: $value->customer_infor->passport_number : "");
			$this->sheet->setCellValue('O' . $i, !empty($value->customer_infor->customer_phone_number) ? $value->customer_infor->customer_phone_number : "");
			$this->sheet->setCellValue('P' . $i, !empty($value->houseHold_address->province_name) ? $value->houseHold_address->province_name : "");
			$this->sheet->setCellValue('Q' . $i, !empty($value->houseHold_address->district_name) ? $value->houseHold_address->district_name : "");
			$this->sheet->setCellValue('R' . $i, !empty($value->houseHold_address->ward_name) ? $value->houseHold_address->ward_name : "");
			$this->sheet->setCellValue('S' . $i, !empty($value->houseHold_address->address_household) ? $value->houseHold_address->address_household : "");
			$this->sheet->setCellValue('T' . $i, !empty($value->district) ? $value->district : "");
			$this->sheet->setCellValue('U' . $i, !empty($value->province) ? $value->province : "");
			$this->sheet->setCellValue('V' . $i, !empty($value->code_area) ? name_area($value->code_area) : "");
			$this->sheet->setCellValue('W' . $i, !empty($value->reminder_now) ? note_renewal($value->reminder_now) : "");
			$this->sheet->setCellValue('X' . $i, !empty($value->current_address->current_stay) ? $value->current_address->current_stay : "");
			$this->sheet->setCellValue('Y' . $i, !empty($value->job_infor->address_company) ? $value->job_infor->address_company : "");
			$this->sheet->setCellValue('Z' . $i, !empty($value->current_address->form_residence) ? $value->current_address->form_residence : "");
			$this->sheet->setCellValue('AA' . $i, !empty($value->disbursement_date) ? date('d/m/Y', $value->disbursement_date) : "");
			$this->sheet->setCellValue('AB' . $i, $is_device_vset);
			$this->sheet->setCellValue('AC' . $i, !empty($value->loan_infor->device_asset_location->code) ? $value->loan_infor->device_asset_location->code . " " : '');
			$this->sheet->setCellValue('AD' . $i, !empty($value->created_by) ? $value->created_by : '');
			$this->sheet->setCellValue('AE' . $i, !empty($value->follow_contract) ? $value->follow_contract : '');
			$this->sheet->setCellValue('AF' . $i, !empty($value->debt->ngay_ky_tra) ? date('d/m/Y', $value->debt->ngay_ky_tra) : '');

			$i++;
		}

		$this->callLibExcel('Export report debt ' . date('d-m-Y') . '.xlsx');
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


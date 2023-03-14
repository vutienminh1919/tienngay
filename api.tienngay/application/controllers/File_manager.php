<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
require_once APPPATH . 'libraries/NL_Withdraw.php';
require_once APPPATH . 'libraries/REST_Controller.php';
require_once APPPATH . 'libraries/CVS.php';

//require_once APPPATH . 'libraries/Fcm.php';

use Restserver\Libraries\REST_Controller;
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

class File_manager extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('menu_model');
		$this->load->model("transaction_model");
		$this->load->model('fee_loan_model');
		$this->load->model('contract_model');
		$this->load->model('gic_model');
		$this->load->model('mic_model');
		$this->load->model('gic_easy_model');
		$this->load->model('gic_plt_model');
		$this->load->model('log_contract_model');
		$this->load->model('log_model');
		$this->load->model('log_gic_model');
		$this->load->model('log_mic_model');
		$this->load->model('user_model');
		$this->load->model('role_model');
		$this->load->model('config_gic_model');
		$this->load->model('city_gic_model');
		$this->load->model('contract_tempo_model');
		$this->load->model('investor_model');
		$this->load->model("group_role_model");
		$this->load->model("notification_model");
		$this->load->model("notification_app_model");
		$this->load->model("store_model");
		$this->load->model("lead_model");
		$this->load->model("sms_model");
		$this->load->model("temporary_plan_contract_model");
		$this->load->model('log_contract_tempo_model');
		$this->load->model('tempo_contract_accounting_model');
		$this->load->model('dashboard_model');
		$this->load->model('coupon_model');
		$this->load->model('verify_identify_contract_model');
		$this->load->model('device_model');
		$this->load->helper('lead_helper');
		$this->load->model('vbi_model');
		$this->load->model('log_hs_model');
		$this->load->model('log_call_debt_model');
		$this->load->model('asset_management_model');
		$this->load->model('thongbao_model');
		$this->load->model('borrowed_model');
		$this->load->model('log_borrowed_model');
		$this->load->model('borrowed_noti_model');
		$this->load->model('file_return_model');
		$this->load->model('log_file_return_model');
		$this->load->model('log_sendfile_model');
		$this->load->model('log_fileManager_model');
		$this->load->model('file_manager_model');
		$this->load->model('email_template_model');
		$this->load->model('email_history_model');
		$this->load->model('borrow_paper_model');
		$this->load->model('extend_borrowed_model');
		$this->load->library('image_lib');

		$this->createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		$headers = $this->input->request_headers();
		$this->flag_login = 1;
		$this->superadmin = false;
		$this->dataPost = $this->input->post();
		$this->cvs = new CVS();
		if (!empty($headers['Authorization']) || !empty($headers['authorization'])) {
			$headers_item = !empty($headers['Authorization']) ? $headers['Authorization'] : $headers['authorization'];
			$token = Authorization::validateToken($headers_item);
			if ($token != false) {
				// Kiểm tra tài khoản và token có khớp nhau và có trong db hay không
				$this->app_login = array(
					'_id' => new \MongoDB\BSON\ObjectId($token->id),
					'email' => $token->email,
					"status" => "active",
					// "is_superadmin" => 1
				);
				//Web
				if ($this->dataPost['type'] == 1) $this->app_login['token_web'] = $headers_item;
				if ($this->dataPost['type'] == 2) $this->app_login['token_app'] = $headers_item;
				$count_account = $this->user_model->count($this->app_login);
				$this->flag_login = 'success';
				if ($count_account != 1) $this->flag_login = 2;
				if ($count_account == 1) {
					$this->info = $this->user_model->findOne($this->app_login);
					$this->id = $this->info['_id'];
					$this->ulang = !empty($this->info['lang']) ? $this->info['lang'] : "english";
					$this->uemail = $this->info['email'];

					// Get access right
					$roles = $this->role_model->getRoleByUserId((string)$this->id);
					$this->roleAccessRights = $roles['role_access_rights'];
					$this->superadmin = isset($this->info['is_superadmin']) && (int)$this->info['is_superadmin'] === 1;
				}
			}
		}
		unset($this->dataPost['type']);


	}

	private $createdAt, $flag_login, $id, $uemail, $ulang, $app_login, $dataPost, $roleAccessRights, $info;


	public function process_create_fileReturn_post()
	{
		$this->dataPost['code_contract_disbursement_value'] = $this->security->xss_clean($this->dataPost['code_contract_disbursement_value']);
		$this->dataPost['code_contract_disbursement_text'] = trim(implode("", $this->security->xss_clean($this->dataPost['code_contract_disbursement_text'])));
		$this->dataPost['file'] = $this->security->xss_clean($this->dataPost['file']);
		$this->dataPost['giay_to_khac'] = $this->security->xss_clean($this->dataPost['giay_to_khac']);

		$this->dataPost['taisandikem'] = $this->security->xss_clean($this->dataPost['taisandikem']);
		$this->dataPost['ghichu'] = $this->security->xss_clean($this->dataPost['ghichu']);
		$this->dataPost['fileReturn_img'] = $this->security->xss_clean($this->dataPost['fileReturn_img']);

		$check_area = $this->store_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['stores'])));

		if ($check_area['code_area'] == "Priority" || $check_area['code_area'] == "KV_HN1" || $check_area['code_area'] == "KV_HN2" || $check_area['code_area'] == "KV_QN" || $check_area['code_area'] == "KV_MT1" || $check_area['code_area'] == "KV_BTB") {
			$this->dataPost["area"] = "MB";
			$user = $this->quan_ly_ho_so_mb();
		} else if ($check_area['code_area'] == "KV_MK") {
			$this->dataPost["area"] = "MK";
			$user = $this->quan_ly_ho_so_mekong();
		} else {
			$this->dataPost["area"] = "MN";
			$user = $this->quan_ly_ho_so_mn();
		}


		//Validate
		if (empty($this->dataPost['code_contract_disbursement_value'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Mã hợp đồng không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

		if (empty($this->dataPost['giay_to_khac'])) {
			if (empty($this->dataPost['file'])) {
				$response = array(
					'status' => REST_Controller::HTTP_UNAUTHORIZED,
					'message' => "Danh sách hồ sơ không được để trống"
				);
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			}
		}

		if (empty($this->dataPost['fileReturn_img'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Ảnh không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

		$check_fileReturn = $this->file_manager_model->find_where(array("code_contract_disbursement_text" => $this->dataPost['code_contract_disbursement_text']));
		foreach ($check_fileReturn as $key => $value) {
			if ($value['status'] != "2") {
				$response = array(
					'status' => REST_Controller::HTTP_UNAUTHORIZED,
					'message' => "Hợp đồng đã tạo yêu cầu gửi"
				);
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			}
		}

		$this->dataPost['created_at'] = $this->createdAt;

		$contractId = $this->file_manager_model->insertReturnId($this->dataPost);

		$log = array(
			"type" => "fileReturn",
			"action" => "CVKD tạo mới YC",
			"fileReturn_id" => (string)$contractId,
			"fileReturn" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_fileManager_model->insert($log);

		$fileReturn = $this->file_manager_model->findOne(array("_id" => new MongoDB\BSON\ObjectId((string)$contractId)));
		$this->sendEmailApprove_qlhs($fileReturn, $user);

		if (!empty($user)) {
			foreach (array_unique($user) as $qlhs) {
				$data_approve = [
					'action_id' => (string)$contractId,
					'action' => 'FileReturn_create',
					'note' => 'Mới',
					'user_id' => (string)$qlhs,
					'status' => 1, //1: new, 2 : read, 3: block,
					'fileReturn_status' => 1,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Create new borrowed success"

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	/**
	 * Get all DS hồ sơ gửi về HO
	 */
	public function get_all_sendFile_post()
	{
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;
		$this->dataPost = $this->input->post();
		$condition = [];

		$fdate = !empty($this->dataPost['fdate']) ? $this->dataPost['fdate'] : "";
		$tdate = !empty($this->dataPost['tdate']) ? $this->dataPost['tdate'] : "";

		$status = !empty($this->dataPost['status']) ? $this->dataPost['status'] : "";
		$store = !empty($this->dataPost['store']) ? $this->dataPost['store'] : "";
		$code_contract_disbursement_search = !empty($this->dataPost['code_contract_disbursement_search']) ? $this->dataPost['code_contract_disbursement_search'] : "";

		if (!empty($fdate)) {
			$condition['fdate'] = strtotime(trim($fdate) . ' 00:00:00');
		}
		if (!empty($tdate)) {
			$condition['tdate'] = strtotime(trim($tdate) . ' 23:59:59');
		}
		if (!empty($status)) {
			$condition['status'] = $status;
		}
		if (!empty($store)) {
			$condition['store'] = $store;
		}
		if (!empty($code_contract_disbursement_search)) {
			$condition['code_contract_disbursement_search'] = $code_contract_disbursement_search;
		}

		$groupRoles = $this->getGroupRole($this->id);
		$all = false;
		if (in_array('giao-dich-vien', $groupRoles) || in_array('cua-hang-truong', $groupRoles)) {
			$all = true;
		}
		if ($all) {
			$stores = $this->getStores($this->id);
			if (empty($stores)) {
				$response = array(
					'status' => REST_Controller::HTTP_OK,
					'data' => array()
				);
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			}
			$condition['stores'] = $stores;
		}
		if (in_array('quan-ly-ho-so', $groupRoles)){

			$stores_list = $this->getStores_list($this->id);
			$condition['stores_list'] = $stores_list;

		}
		$per_page = !empty($this->dataPost['per_page']) ? $this->dataPost['per_page'] : 30;
		$uriSegment = !empty($this->dataPost['uriSegment']) ? $this->dataPost['uriSegment'] : 0;
		$fileReturn = $this->file_manager_model->getDataByRole($condition, $per_page, $uriSegment);
		if (empty($fileReturn)) {
			return;
		}
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $fileReturn
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function get_all_sendFile_tattoan_post()
	{
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;
		$this->dataPost = $this->input->post();
		$condition = [];

		$fdate = !empty($this->dataPost['fdate']) ? $this->dataPost['fdate'] : "";
		$tdate = !empty($this->dataPost['tdate']) ? $this->dataPost['tdate'] : "";

		$status = !empty($this->dataPost['status']) ? $this->dataPost['status'] : "";
		$store = !empty($this->dataPost['store']) ? $this->dataPost['store'] : "";
		$code_contract_disbursement_search = !empty($this->dataPost['code_contract_disbursement_search']) ? $this->dataPost['code_contract_disbursement_search'] : "";

		if (!empty($fdate)) {
			$condition['fdate'] = strtotime(trim($fdate) . ' 00:00:00');
		}
		if (!empty($tdate)) {
			$condition['tdate'] = strtotime(trim($tdate) . ' 23:59:59');
		}
		if (!empty($status)) {
			$condition['status'] = $status;
		}
		if (!empty($store)) {
			$condition['store'] = $store;
		}
		if (!empty($code_contract_disbursement_search)) {
			$condition['code_contract_disbursement_search'] = $code_contract_disbursement_search;
		}

		$groupRoles = $this->getGroupRole($this->id);
		$all = false;
		if (in_array('giao-dich-vien', $groupRoles) || in_array('cua-hang-truong', $groupRoles)) {
			$all = true;
		}
		if ($all) {
			$stores = $this->getStores($this->id);
			if (empty($stores)) {
				$response = array(
					'status' => REST_Controller::HTTP_OK,
					'data' => array()
				);
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			}
			$condition['stores'] = $stores;
		}

		if (in_array('quan-ly-ho-so', $groupRoles)){

			$stores_list = $this->getStores_list($this->id);
			$condition['stores_list'] = $stores_list;

		}


		$per_page = !empty($this->dataPost['per_page']) ? $this->dataPost['per_page'] : 30;
		$uriSegment = !empty($this->dataPost['uriSegment']) ? $this->dataPost['uriSegment'] : 0;

		$fileReturn = $this->file_manager_model->getDataByRole_tattoan($condition, $per_page, $uriSegment);
		if (empty($fileReturn)) {
			return;
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $fileReturn
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}


	public function get_count_all_sendfile_post()
	{

		$this->dataPost = $this->input->post();
		$condition = [];

		$fdate = !empty($this->dataPost['fdate']) ? $this->dataPost['fdate'] : "";
		$tdate = !empty($this->dataPost['tdate']) ? $this->dataPost['tdate'] : "";

		$status = !empty($this->dataPost['status']) ? $this->dataPost['status'] : "";
		$store = !empty($this->dataPost['store']) ? $this->dataPost['store'] : "";
		$code_contract_disbursement_search = !empty($this->dataPost['code_contract_disbursement_search']) ? $this->dataPost['code_contract_disbursement_search'] : "";

		if (!empty($fdate)) {
			$condition['fdate'] = strtotime(trim($fdate) . ' 00:00:00');
		}
		if (!empty($tdate)) {
			$condition['tdate'] = strtotime(trim($tdate) . ' 23:59:59');
		}
		if (!empty($status)) {
			$condition['status'] = $status;
		}
		if (!empty($store)) {
			$condition['store'] = $store;
		}
		if (!empty($code_contract_disbursement_search)) {
			$condition['code_contract_disbursement_search'] = $code_contract_disbursement_search;
		}

		$groupRoles = $this->getGroupRole($this->id);
		$all = false;
		if (in_array('giao-dich-vien', $groupRoles) || in_array('cua-hang-truong', $groupRoles)) {
			$all = true;
		}
		if ($all) {
			$stores = $this->getStores($this->id);
			if (empty($stores)) {
				$response = array(
					'status' => REST_Controller::HTTP_OK,
					'data' => array()
				);
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			}
			$condition['stores'] = $stores;
		}

		if (in_array('quan-ly-ho-so', $groupRoles)) {

			$stores_list = $this->getStores_list($this->id);
			$condition['stores_list'] = $stores_list;

		}

		$sendFile_count = $this->file_manager_model->getCountByRole($condition);

		if (empty($sendFile_count)) {
			return;
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $sendFile_count
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function get_count_all_tattoan_post()
	{
		$this->dataPost = $this->input->post();
		$condition = [];

		$fdate = !empty($this->dataPost['fdate']) ? $this->dataPost['fdate'] : "";
		$tdate = !empty($this->dataPost['tdate']) ? $this->dataPost['tdate'] : "";

		$status = !empty($this->dataPost['status']) ? $this->dataPost['status'] : "";
		$store = !empty($this->dataPost['store']) ? $this->dataPost['store'] : "";
		$code_contract_disbursement_search = !empty($this->dataPost['code_contract_disbursement_search']) ? $this->dataPost['code_contract_disbursement_search'] : "";

		if (!empty($fdate)) {
			$condition['fdate'] = strtotime(trim($fdate) . ' 00:00:00');
		}
		if (!empty($tdate)) {
			$condition['tdate'] = strtotime(trim($tdate) . ' 23:59:59');
		}
		if (!empty($status)) {
			$condition['status'] = $status;
		}
		if (!empty($store)) {
			$condition['store'] = $store;
		}
		if (!empty($code_contract_disbursement_search)) {
			$condition['code_contract_disbursement_search'] = $code_contract_disbursement_search;
		}

		$groupRoles = $this->getGroupRole($this->id);
		$all = false;
		if (in_array('giao-dich-vien', $groupRoles) || in_array('cua-hang-truong', $groupRoles)) {
			$all = true;
		}
		if ($all) {
			$stores = $this->getStores($this->id);
			if (empty($stores)) {
				$response = array(
					'status' => REST_Controller::HTTP_OK,
					'data' => array()
				);
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			}
			$condition['stores'] = $stores;
		}

		if (in_array($this->id, $this->quan_ly_ho_so_mb())) {
			$condition['area'][] = "MB";
		}
		if (in_array($this->id, $this->quan_ly_ho_so_mn())) {
			$condition['area'][] = "MN";
		}
		if (in_array($this->id, $this->quan_ly_ho_so_mekong())){
			$condition['area'][] = "MK";
		}

		$sendFile_count = $this->file_manager_model->getCountByRole_tat_toan($condition);

		if (empty($sendFile_count)) {
			return;
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $sendFile_count
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}


	public function get_one_post()
	{

		$flag = notify_token($this->flag_login);
		if ($flag == false) return;
		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);

		$file_manager = $this->file_manager_model->findOne(array("_id" => new \MongoDB\BSON\ObjectId($this->dataPost['id'])));

		if (!empty($file_manager)){
			$file_pdf = $this->contract_model->findOne(['code_contract_disbursement' => $file_manager['code_contract_disbursement_text']]);
			if (!empty($file_pdf)){
				$file_manager['file_pdf'] = $file_pdf['image_accurecy']['digital'];
			}
		}

		if (empty($file_manager)) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Hợp đồng không tồn tại"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $file_manager,
		);

		$this->set_response($response, REST_Controller::HTTP_OK);

	}

	public function cancel_fileReturn_post()
	{

		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);

		$fileReturn = $this->file_manager_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])));
		$this->dataPost['status'] = "2";
		$log = array(
			"type" => "fileReturn",
			"action" => "Hủy",
			"fileReturn_id" => $this->dataPost['id'],
			"old" => $fileReturn,
			"new" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_fileManager_model->insert($log);

		$check_area = $this->store_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($fileReturn['stores'])));
		if ($check_area['code_area'] == "Priority" || $check_area['code_area'] == "KV_HN1" || $check_area['code_area'] == "KV_HN2" || $check_area['code_area'] == "KV_QN" || $check_area['code_area'] == "KV_MT1" || $check_area['code_area'] == "KV_BTB") {
			$user = $this->quan_ly_ho_so_mb();
		} else if ($check_area['code_area'] == "KV_MK") {
			$user = $this->quan_ly_ho_so_mekong();
		} else {
			$user = $this->quan_ly_ho_so_mn();
		}
		$fileReturn['status'] = "2";

		$this->sendEmailApprove_qlhs($fileReturn, $user);

		if (!empty($user)) {
			foreach (array_unique($user) as $re) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id'],
					'action' => 'FileReturn_cancel',
					'note' => 'Hủy yêu cầu',
					'user_id' => $re,
					'status' => 1, //1: new, 2 : read, 3: block,
					'fileReturn_status' => 2,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}

		unset($this->dataPost['id']);

		$this->file_manager_model->update(array("_id" => $fileReturn['_id']), ["status" => "2"]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Cancel borrowed success"

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;


	}

	public function get_one_fileReturn_post()
	{

		$data = $this->input->post();
		$fileReturn = $this->file_manager_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($data["id"])));
		if (empty($fileReturn)) return;

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $fileReturn
		);
		$this->set_response($response, REST_Controller::HTTP_OK);

	}

	public function process_update_fileReturn_post()
	{

		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);
		$this->dataPost['code_contract_disbursement_value'] = $this->security->xss_clean($this->dataPost['code_contract_disbursement_value']);
		$this->dataPost['code_contract_disbursement_text'] = trim(implode("", $this->security->xss_clean($this->dataPost['code_contract_disbursement_text'])));
		$this->dataPost['file'] = $this->security->xss_clean($this->dataPost['file']);
		$this->dataPost['giay_to_khac'] = $this->security->xss_clean($this->dataPost['giay_to_khac']);

		$this->dataPost['taisandikem'] = $this->security->xss_clean($this->dataPost['taisandikem']);
		$this->dataPost['ghichu'] = $this->security->xss_clean($this->dataPost['ghichu']);
		$this->dataPost['fileReturn_img'] = $this->security->xss_clean($this->dataPost['fileReturn_img']);


		//Validate
		if (empty($this->dataPost['code_contract_disbursement_value'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Mã hợp đồng không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

		if (empty($this->dataPost['giay_to_khac'])) {
			if (empty($this->dataPost['file'])) {
				$response = array(
					'status' => REST_Controller::HTTP_UNAUTHORIZED,
					'message' => "Danh sách hồ sơ không được để trống"
				);
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			}
		}
		if (empty($this->dataPost['fileReturn_img'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Ảnh không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

		$check_fileReturn = $this->file_manager_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])));

		$this->dataPost['updated_at'] = $this->createdAt;

		$log = array(
			"type" => "fileReturn",
			"action" => "Sửa",
			"fileReturn_id" => $this->dataPost['id'],
			"fileReturn" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_fileManager_model->insert($log);

		unset($this->dataPost['id']);

		$this->file_manager_model->update(array("_id" => $check_fileReturn['_id']), ["file" => $this->dataPost['file'], "giay_to_khac" => $this->dataPost['giay_to_khac'], "taisandikem" => $this->dataPost['taisandikem'], "ghichu" => $this->dataPost['ghichu'], "fileReturn_img" => $this->dataPost['fileReturn_img']]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Update borrowed success"

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function send_file_fileReturn_post()
	{

		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);

		$fileReturn = $this->file_manager_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])));
		$this->dataPost['status'] = "3";
		$log = array(
			"type" => "fileReturn",
			"action" => "Xác nhận",
			"fileReturn_id" => $this->dataPost['id'],
			"old" => $fileReturn,
			"new" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_fileManager_model->insert($log);

		$check_area = $this->store_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($fileReturn['stores'])));
		if ($check_area['code_area'] == "Priority" ||$check_area['code_area'] == "KV_HN1" || $check_area['code_area'] == "KV_HN2" || $check_area['code_area'] == "KV_QN" || $check_area['code_area'] == "KV_MT1" || $check_area['code_area'] == "KV_BTB") {
			$user = $this->quan_ly_ho_so_mb();
		} else if ($check_area['code_area'] == "KV_MK") {
			$user = $this->quan_ly_ho_so_mekong();
		} else {
			$user = $this->quan_ly_ho_so_mn();
		}
		$fileReturn['status'] = "3";
		$this->sendEmailApprove_qlhs($fileReturn, $user);

		if (!empty($user)) {
			foreach (array_unique($user) as $re) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id'],
					'action' => 'FileReturn_cancel',
					'note' => 'YC gửi HS giải ngân',
					'user_id' => $re,
					'status' => 1, //1: new, 2 : read, 3: block,
					'fileReturn_status' => 3,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}

		unset($this->dataPost['id']);

		$this->file_manager_model->update(array("_id" => $fileReturn['_id']), ["status" => "3"]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Approve borrowed success"

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	private function sendEmailApprove_borrowed($fileReturn, $user_qlhs)
	{
		$status_text = "";
		$id = $fileReturn['_id'];

		if ($fileReturn['status'] == "1") {
			$status_text = "Mới";
		} elseif ($fileReturn['status'] == "2") {
			$status_text = "Hủy yêu cầu";
		} elseif ($fileReturn['status'] == "3") {
			$status_text = "PGD YC mượn HS giải ngân";
		} elseif ($fileReturn['status'] == "4") {
			$status_text = "Yêu cầu mượn HS";
		} elseif ($fileReturn['status'] == "5") {
			$status_text = "QLHS trả về yêu cầu mượn";
		} elseif ($fileReturn['status'] == "6") {
			$status_text = "Chờ nhận hồ sơ";
		} elseif ($fileReturn['status'] == "7") {
			$status_text = "Đang mượn hồ sơ";
		} elseif ($fileReturn['status'] == "8") {
			$status_text = "Chưa nhận đủ HS mượn";
		} elseif ($fileReturn['status'] == "9") {
			$status_text = "Trả HS mượn về HO";
		} elseif ($fileReturn['status'] == "10") {
			$status_text = "Lưu kho";
		} elseif ($fileReturn['status'] == "11") {
			$status_text = "Chưa trả đủ HS đã mượn";
		} elseif ($fileReturn['status'] == "12") {
			$status_text = "Quá hạn mượn HS";
		} elseif ($fileReturn['status'] == "13") {
			$status_text = "Trả hồ sơ cho KH tất toán";
		} elseif ($fileReturn['status'] == "14") {
			$status_text = "QLHS xác nhận KH đã tất toán";
		} elseif ($fileReturn['status'] == "15") {
			$status_text = "Yêu cầu gia hạn mượn hồ sơ";
		} elseif ($fileReturn['status'] == Borrowed_model::WAIT_DEBT_MANAGER_APPROVE) {
			$status_text = "Chờ TP QLKV duyệt yêu cầu mượn hồ sơ";
		} elseif ($fileReturn['status'] == Borrowed_model::WAIT_DEBT_MANAGER_APPROVE_EXTEND_BORROWED) {
			$status_text = "Chờ TP QLKV duyệt yêu cầu gia hạn mượn hồ sơ";
		}

		$data = array(
			'code' => "vfc_send_email_qlhs",
			'code_contract_disbursement' => $fileReturn['code_contract_disbursement_text'],
			'status' => $status_text,
			'url' => $this->config->item('cpanel_url') . "file_manager/detail_borrowed?id=$id"
		);

		foreach ($user_qlhs as $item) {
			$email_user = $this->getGroupRole_email($item);
			foreach ($email_user as $value) {
				$data['email'] = "$value";
				$data['API_KEY'] = $this->config->item('API_KEY');
				$this->user_model->send_Email($data);
//				$this->sendEmail($data);
			}
		}
		return;
	}


	private function sendEmailApprove_qlhs($fileReturn, $user_qlhs)
	{
		$status_text = "";
		$id = $fileReturn['_id'];

		if ($fileReturn['status'] == "1") {
			$status_text = "Mới";
		} elseif ($fileReturn['status'] == "2") {
			$status_text = "Hủy yêu cầu";
		} elseif ($fileReturn['status'] == "3") {
			$status_text = "YC gửi HS giải ngân";
		} elseif ($fileReturn['status'] == "4") {
			$status_text = "QLHS YC bổ sung";
		} elseif ($fileReturn['status'] == "5") {
			$status_text = "Đã XN YC gửi HS";
		} elseif ($fileReturn['status'] == "6") {
			$status_text = "Hoàn tất lưu kho";
		} elseif ($fileReturn['status'] == "7") {
			$status_text = "QLHS chưa nhận HS";
		} elseif ($fileReturn['status'] == "8") {
			$status_text = "YC trả HS sau tất toán";
		} elseif ($fileReturn['status'] == "9") {
			$status_text = "QLHS đã xác nhận YC trả HS";
		} elseif ($fileReturn['status'] == "10") {
			$status_text = "YC bổ sung HS";
		} elseif ($fileReturn['status'] == "11") {
			$status_text = "Đã trả HS sau tất toán";
		} elseif ($fileReturn['status'] == "13") {
			$status_text = "Trả về yêu cầu";
		}
		$data = array(
			'code' => "vfc_send_email_qlhs",
			'code_contract_disbursement' => $fileReturn['code_contract_disbursement_text'],
			'status' => $status_text,
			'url' => "https://lms.tienngay.vn/file_manager/detail?id=$id"
		);

		foreach ($user_qlhs as $item) {
			$email_user = $this->getGroupRole_email($item);
			foreach ($email_user as $value) {
				$data['email'] = "$value";
				$data['API_KEY'] = $this->config->item('API_KEY');
				$this->user_model->send_Email($data);
//				$this->sendEmail($data);
			}

		}
		return;
	}

	private function sendEmailBorrow_qlhs($fileReturn, $user_qlhs)
	{
		$status_text = "";
		$id = $fileReturn['_id'];

		if ($fileReturn['status'] == "1") {
			$status_text = "Mới";
		} elseif ($fileReturn['status'] == "2") {
			$status_text = "Xác nhận yêu cầu mượn giấy đi đường";
		} elseif ($fileReturn['status'] == "3") {
			$status_text = "Hủy";
		}
		$data = array(
			'code' => "vfc_email_borrow_paper",
			'code_contract_disbursement' => $fileReturn['code_contract_disbursement_value'],
			'status' => $status_text,
			'url' => "https://lms.tienngay.vn/file_manager/borrow_travel_paper",

		);

		foreach ($user_qlhs as $item) {
			$email_user = $this->getGroupRole_email($item);
			foreach ($email_user as $value) {
				$data['email'] = "$value";
				$data['email_show'] = "$value";
				$data['API_KEY'] = $this->config->item('API_KEY');
//				$this->user_model->send_Email($data);
				$this->sendEmail($data);
			}

		}
		return;
	}



	public function bosunghoso_fileReturn_post()
	{

		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);
		$this->dataPost['ghichu_qlhs'] = $this->security->xss_clean($this->dataPost['ghichu_qlhs']);

		$fileReturn = $this->file_manager_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])));
		$this->dataPost['status'] = "4";
		$log = array(
			"type" => "fileReturn",
			"action" => "Trả về",
			"fileReturn_id" => $this->dataPost['id'],
			"old" => $fileReturn,
			"new" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_fileManager_model->insert($log);

		$user_gdv = array($fileReturn['created_by']['id']);
		$fileReturn['status'] = "4";
		$this->sendEmailApprove_qlhs($fileReturn, $user_gdv);

		if (!empty($user_gdv)) {
			foreach (array_unique($user_gdv) as $re) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id'],
					'action' => 'FileReturn_cancel',
					'note' => 'QLHS YC bổ sung',
					'user_id' => $re,
					'status' => 1, //1: new, 2 : read, 3: block,
					'fileReturn_status' => 4,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}

		unset($this->dataPost['id']);

		$this->file_manager_model->update(array("_id" => $fileReturn['_id']), ["status" => "4", "ghichu_qlhs" => $this->dataPost['ghichu_qlhs']]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Return borrowed success"

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;


	}

	public function guibosunghoso_fileReturn_post()
	{

		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);

		$this->dataPost['file'] = $this->security->xss_clean($this->dataPost['file']);
		$this->dataPost['giay_to_khac'] = $this->security->xss_clean($this->dataPost['giay_to_khac']);

		$this->dataPost['taisandikem'] = $this->security->xss_clean($this->dataPost['taisandikem']);
		$this->dataPost['ghichu'] = $this->security->xss_clean($this->dataPost['ghichu']);
		$this->dataPost['fileReturn_img'] = $this->security->xss_clean($this->dataPost['fileReturn_img']);

		//Validate
		if (empty($this->dataPost['giay_to_khac'])) {
			if (empty($this->dataPost['file'])) {
				$response = array(
					'status' => REST_Controller::HTTP_UNAUTHORIZED,
					'message' => "File trả không được để trống"
				);
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			}
		}
		if (empty($this->dataPost['fileReturn_img'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Ảnh không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

		$check_fileReturn = $this->file_manager_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])));

		$this->dataPost['updated_at'] = $this->createdAt;
		$this->dataPost['status'] = "3";
		$log = array(
			"type" => "fileReturn",
			"action" => "Xác nhận",
			"fileReturn_id" => $this->dataPost['id'],
			"old" => $check_fileReturn,
			"new" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_fileManager_model->insert($log);

		$check_area = $this->store_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($check_fileReturn['stores'])));
		if ($check_area['code_area'] == "Priority" ||$check_area['code_area'] == "KV_HN1" || $check_area['code_area'] == "KV_HN2" || $check_area['code_area'] == "KV_QN" || $check_area['code_area'] == "KV_MT1" || $check_area['code_area'] == "KV_BTB") {
			$user = $this->quan_ly_ho_so_mb();
		} else if ($check_area['code_area'] == "KV_MK") {
			$user = $this->quan_ly_ho_so_mekong();
		} else {
			$user = $this->quan_ly_ho_so_mn();
		}
		$check_fileReturn['status'] = "3";
		$this->sendEmailApprove_qlhs($check_fileReturn, $user);

		if (!empty($user)) {
			foreach (array_unique($user) as $re) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id'],
					'action' => 'FileReturn_cancel',
					'note' => 'CVKD gửi HS bổ sung',
					'user_id' => $re,
					'status' => 1, //1: new, 2 : read, 3: block,
					'fileReturn_status' => 3,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}

		unset($this->dataPost['id']);

		$this->file_manager_model->update(array("_id" => $check_fileReturn['_id']), array("status" => "3", "file" => $this->dataPost['file'], "giay_to_khac" => $this->dataPost['giay_to_khac'], "taisandikem" => $this->dataPost['taisandikem'], "ghichu" => $this->dataPost['ghichu'], "fileReturn_img" => $this->dataPost['fileReturn_img']));

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Update success"

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;


	}

	public function approve_fileReturn_post()
	{

		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);
		$this->dataPost['ghichu'] = $this->security->xss_clean($this->dataPost['ghichu']);
		$this->dataPost['file_img_approve'] = $this->security->xss_clean($this->dataPost['file_img_approve']);

		$fileReturn = $this->file_manager_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])));
		$this->dataPost['status'] = "5";
		$log = array(
			"type" => "fileReturn",
			"action" => "Xác nhận",
			"fileReturn_id" => $this->dataPost['id'],
			"old" => $fileReturn,
			"new" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_fileManager_model->insert($log);

		$fileReturn['status'] = "5";
		$user = array($fileReturn['created_by']['id']);
		$this->sendEmailApprove_qlhs($fileReturn, $user);
		if (!empty($user)) {
			foreach (array_unique($user) as $re) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id'],
					'action' => 'FileReturn_cancel',
					'note' => 'Đã XN YC gửi HS',
					'user_id' => $re,
					'status' => 1, //1: new, 2 : read, 3: block,
					'fileReturn_status' => 5,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}

		unset($this->dataPost['id']);

		$this->file_manager_model->update(array("_id" => $fileReturn['_id']), ["status" => "5", "ghichu" => $this->dataPost['ghichu'], "file_img_approve" => $this->dataPost['file_img_approve']]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Approve borrowed success"

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function save_fileReturn_post()
	{

		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);
		$this->dataPost['ghichu'] = $this->security->xss_clean($this->dataPost['ghichu']);
		$this->dataPost['file_img_approve'] = $this->security->xss_clean($this->dataPost['file_img_approve']);
		//V2
		$this->dataPost['thoa_thuan_ba_ben'] = $this->security->xss_clean($this->dataPost['thoa_thuan_ba_ben']);
		$this->dataPost['bbbg_tai_san'] = $this->security->xss_clean($this->dataPost['bbbg_tai_san']);
		$this->dataPost['dang_ky_xe'] = $this->security->xss_clean($this->dataPost['dang_ky_xe']);
		$this->dataPost['thong_bao'] = $this->security->xss_clean($this->dataPost['thong_bao']);
		$this->dataPost['hd_mua_ban_xe'] = $this->security->xss_clean($this->dataPost['hd_mua_ban_xe']);
		$this->dataPost['cam_ket'] = $this->security->xss_clean($this->dataPost['cam_ket']);
		$this->dataPost['bbbg_thiet_bi_dinh_vi'] = $this->security->xss_clean($this->dataPost['bbbg_thiet_bi_dinh_vi']);
		$this->dataPost['bbh_hoi_dong_co_dong'] = $this->security->xss_clean($this->dataPost['bbh_hoi_dong_co_dong']);
		$this->dataPost['hop_dong_mua_ban'] = $this->security->xss_clean($this->dataPost['hop_dong_mua_ban']);
		$this->dataPost['hd_uy_quyen'] = $this->security->xss_clean($this->dataPost['hd_uy_quyen']);
		$this->dataPost['hd_chuyen_nhuong'] = $this->security->xss_clean($this->dataPost['hd_chuyen_nhuong']);
		$this->dataPost['so_do'] = $this->security->xss_clean($this->dataPost['so_do']);
		$this->dataPost['hd_dat_coc'] = $this->security->xss_clean($this->dataPost['hd_dat_coc']);
		$this->dataPost['phu_luc_gia_han'] = $this->security->xss_clean($this->dataPost['phu_luc_gia_han']);
		$this->dataPost['code_store_rc'] = $this->security->xss_clean($this->dataPost['code_store_rc']);
		$fileReturn = $this->file_manager_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])));
		$ma_luu_kho = '';
		$is_dkx_origin = false;
		$status_dkx = '';
		if (!empty($fileReturn['code_contract_disbursement_text'])) {
			$ma_luu_kho = explode('/',$fileReturn['code_contract_disbursement_text'],3);
			$ma_luu_kho = $ma_luu_kho[2] ?? '';
		}
		if ($this->dataPost['dang_ky_xe'] > 0) {
			$is_dkx_origin = true;
			$status_dkx = 1; // 1: Lưu kho, 2: Đã trả, 3: Lưu ở hợp đồng khác, 4: Không có ĐKX
		}
		if ($this->dataPost['so_do'] > 0) {
			$is_dkx_origin = true;
		}
		$this->dataPost['status'] = "6";
		$log = array(
			"type" => "fileReturn",
			"action" => "Xác nhận",
			"fileReturn_id" => $this->dataPost['id'],
			"old" => $fileReturn,
			"new" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_fileManager_model->insert($log);
		$fileReturn['status'] = "6";
		$user = array($fileReturn['created_by']['id']);
		$this->sendEmailApprove_qlhs($fileReturn, $user);
		if (!empty($user)) {
			foreach (array_unique($user) as $re) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id'],
					'action' => 'FileReturn_cancel',
					'note' => 'Hoàn tất lưu kho',
					'user_id' => $re,
					'status' => 1, //1: new, 2 : read, 3: block,
					'fileReturn_status' => 6,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}
		unset($this->dataPost['id']);
		$array_update = [
			"status" => "6",
			"ghichu" => $this->dataPost['ghichu'],
			"file_img_approve" => $this->dataPost['file_img_approve'],
			"records_receive.thoa_thuan_ba_ben.text" => 'Thỏa thuận 3 bên',
			"records_receive.thoa_thuan_ba_ben.quantity" => (int)$this->dataPost['thoa_thuan_ba_ben'],
			"records_receive.thoa_thuan_ba_ben.slug" => 'thoa-thuan-3-ben',
			"records_receive.bbbg_tai_san.text" => 'Biên bản bàn giao Tài sản',
			"records_receive.bbbg_tai_san.quantity" => (int)$this->dataPost['bbbg_tai_san'],
			"records_receive.bbbg_tai_san.slug" => 'bien-ban-ban-giao-tai-san',
			"records_receive.dang_ky_xe.text" => 'Đăng ký / Cà vẹt xe',
			"records_receive.dang_ky_xe.quantity" => (int)$this->dataPost['dang_ky_xe'],
			"records_receive.dang_ky_xe.slug" => 'dang-ky-xe',
			"records_receive.thong_bao.text" => 'Thông báo',
			"records_receive.thong_bao.quantity" => (int)$this->dataPost['thong_bao'],
			"records_receive.thong_bao.slug" => 'thong-bao',
			"records_receive.hd_mua_ban_xe.text" => 'Hợp đồng mua bán xe',
			"records_receive.hd_mua_ban_xe.quantity" => (int)$this->dataPost['hd_mua_ban_xe'],
			"records_receive.hd_mua_ban_xe.slug" => 'hop-dong-mua-ban-xe',
			"records_receive.cam_ket.text" => 'Cam kết',
			"records_receive.cam_ket.quantity" => (int)$this->dataPost['cam_ket'],
			"records_receive.cam_ket.slug" => 'cam-ket',
			"records_receive.bbbg_thiet_bi_dinh_vi.text" => 'BBBG thiết bị định vị',
			"records_receive.bbbg_thiet_bi_dinh_vi.quantity" => (int)$this->dataPost['bbbg_thiet_bi_dinh_vi'],
			"records_receive.bbbg_thiet_bi_dinh_vi.slug" => 'bbbg-thiet-bi-dinh-vi',
			"records_receive.bbh_hoi_dong_co_dong.text" => 'BB họp hội đồng cổ đông',
			"records_receive.bbh_hoi_dong_co_dong.quantity" => (int)$this->dataPost['bbh_hoi_dong_co_dong'],
			"records_receive.bbh_hoi_dong_co_dong.slug" => 'bb-hop-hoi-dong-co-dong',
			"records_receive.hop_dong_mua_ban.text" => 'Hợp đồng mua bán',
			"records_receive.hop_dong_mua_ban.quantity" => (int)$this->dataPost['hop_dong_mua_ban'],
			"records_receive.hop_dong_mua_ban.slug" => 'hop-dong-mua-ban',
			"records_receive.hd_uy_quyen.text" => 'Hợp đồng ủy quyền',
			"records_receive.hd_uy_quyen.quantity" => (int)$this->dataPost['hd_uy_quyen'],
			"records_receive.hd_uy_quyen.slug" => 'hop-dong-uy-quyen',
			"records_receive.hd_chuyen_nhuong.text" => 'Hợp đồng chuyển nhượng',
			"records_receive.hd_chuyen_nhuong.quantity" => (int)$this->dataPost['hd_chuyen_nhuong'],
			"records_receive.hd_chuyen_nhuong.slug" => 'hop-dong-chuyen-nhuong',
			"records_receive.so_do.text" => 'Sổ đỏ / Giấy CNQSDĐ',
			"records_receive.so_do.quantity" => (int)$this->dataPost['so_do'],
			"records_receive.so_do.slug" => 'so-do',
			"records_receive.hd_dat_coc.text" => 'Hợp đồng đặt cọc',
			"records_receive.hd_dat_coc.quantity" => (int)$this->dataPost['hd_dat_coc'],
			"records_receive.hd_dat_coc.slug" => 'hop-dong-dat-coc',
			"records_receive.phu_luc_gia_han.text" => 'Phụ lục gia hạn',
			"records_receive.phu_luc_gia_han.quantity" => (int)$this->dataPost['phu_luc_gia_han'],
			"records_receive.phu_luc_gia_han.slug" => 'phu-luc-gia-han',
			"ma_luu_kho" => $ma_luu_kho,
			"is_dkx_origin" => $is_dkx_origin,
			"status_dkx" => $status_dkx,
			"code_store_rc" => $this->dataPost['code_store_rc'],
			"updated_rcr_at" => $this->createdAt,
			"updated_rcr_by" => $this->uemail,
		];
		$this->file_manager_model->update(array("_id" => $fileReturn['_id']), $array_update);
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Lưu kho thành công!"
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function not_received_fileReturn_post()
	{

		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);
		$this->dataPost['ghichu'] = $this->security->xss_clean($this->dataPost['ghichu']);
		$this->dataPost['file_img_approve'] = $this->security->xss_clean($this->dataPost['file_img_approve']);

		$fileReturn = $this->file_manager_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])));
		$this->dataPost['status'] = "7";
		$log = array(
			"type" => "fileReturn",
			"action" => "Xác nhận",
			"fileReturn_id" => $this->dataPost['id'],
			"old" => $fileReturn,
			"new" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_fileManager_model->insert($log);
		$fileReturn['status'] = "7";
		$user = array($fileReturn['created_by']['id']);
		$this->sendEmailApprove_qlhs($fileReturn, $user);
		if (!empty($user)) {
			foreach (array_unique($user) as $re) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id'],
					'action' => 'FileReturn_cancel',
					'note' => 'QLHS chưa nhận HS',
					'user_id' => $re,
					'status' => 1, //1: new, 2 : read, 3: block,
					'fileReturn_status' => 7,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}

		unset($this->dataPost['id']);

		$this->file_manager_model->update(array("_id" => $fileReturn['_id']), ["status" => "7", "ghichu" => $this->dataPost['ghichu'], "file_img_approve" => $this->dataPost['file_img_approve']]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Success"

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function return_file_v2_fileReturn_post()
	{

		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);
		$this->dataPost['ghichu'] = $this->security->xss_clean($this->dataPost['ghichu']);
		$this->dataPost['file_img_approve'] = $this->security->xss_clean($this->dataPost['file_img_approve']);

		$fileReturn = $this->file_manager_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])));

		$check_tt = $this->contract_model->findOne(array("code_contract_disbursement" => $fileReturn['code_contract_disbursement_text']));

//		if ($check_tt['status'] != 19) {
//			$response = array(
//				'status' => REST_Controller::HTTP_UNAUTHORIZED,
//				'message' => "Hợp đồng chưa được tất toán"
//
//			);
//			$this->set_response($response, REST_Controller::HTTP_OK);
//			return;
//		}

		$this->dataPost['status'] = "8";
		$log = array(
			"type" => "fileReturn",
			"action" => "Xác nhận",
			"fileReturn_id" => $this->dataPost['id'],
			"old" => $fileReturn,
			"new" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_fileManager_model->insert($log);

		$check_area = $this->store_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($fileReturn['stores'])));
		if ($check_area['code_area'] == "Priority" ||$check_area['code_area'] == "KV_HN1" || $check_area['code_area'] == "KV_HN2" || $check_area['code_area'] == "KV_QN" || $check_area['code_area'] == "KV_MT1" || $check_area['code_area'] == "KV_BTB") {
			$user = $this->quan_ly_ho_so_mb();
		} else if ($check_area['code_area'] == "KV_MK") {
			$user = $this->quan_ly_ho_so_mekong();
		} else {
			$user = $this->quan_ly_ho_so_mn();
		}
		$fileReturn['status'] = "8";
		$this->sendEmailApprove_qlhs($fileReturn, $user);
		if (!empty($user)) {
			foreach (array_unique($user) as $re) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id'],
					'action' => 'FileReturn_cancel',
					'note' => 'YC trả HS sau tất toán',
					'user_id' => $re,
					'status' => 1, //1: new, 2 : read, 3: block,
					'fileReturn_status' => 8,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}

		unset($this->dataPost['id']);

		$this->file_manager_model->update(array("_id" => $fileReturn['_id']), ["status" => "8", "ghichu" => $this->dataPost['ghichu'], "file_img_approve" => $this->dataPost['file_img_approve']]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Success"

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;


	}


	public function quan_ly_ho_so_mb()
	{
		$roles = $this->role_model->find_where(['status' => 'active']);
		$data = [];
		foreach ($roles as $key => $role) {
			if (!empty($role['users']) && ($role['slug'] == "qlhs-mien-bac")) {
				foreach ($role['users'] as $key1 => $user) {
					foreach ($user as $key2 => $item) {
						array_push($data, $key2);

					}
				}
			}
		}
		return $data;
	}

	public function asm_hn1()
	{
		$roles = $this->role_model->find_where(['status' => 'active']);
		$data = [];
		foreach ($roles as $key => $role) {
			if (!empty($role['users']) && ($role['slug'] == "asm-hn1")) {
				foreach ($role['users'] as $key1 => $user) {
					foreach ($user as $key2 => $item) {
						array_push($data, $key2);

					}
				}
			}
		}
		return $data;
	}

	public function asm_hn2()
	{
		$roles = $this->role_model->find_where(['status' => 'active']);
		$data = [];

		foreach ($roles as $key => $role) {
			if (!empty($role['users']) && ($role['slug'] == "asm-hn2")) {
				foreach ($role['users'] as $key1 => $user) {

					foreach ($user as $key2 => $item) {

						array_push($data, $key2);

					}
				}
			}
		}
		return $data;
	}

	public function asm_hcm1()
	{
		$roles = $this->role_model->find_where(['status' => 'active']);
		$data = [];

		foreach ($roles as $key => $role) {
			if (!empty($role['users']) && ($role['slug'] == "asm-hcm1")) {
				foreach ($role['users'] as $key1 => $user) {
					foreach ($user as $key2 => $item) {
						array_push($data, $key2);

					}
				}
			}
		}
		return $data;
	}

	public function asm_hcm2()
	{
		$roles = $this->role_model->find_where(['status' => 'active']);
		$data = [];

		foreach ($roles as $key => $role) {
			if (!empty($role['users']) && ($role['slug'] == "asm-hcm2")) {
				foreach ($role['users'] as $key1 => $user) {

					foreach ($user as $key2 => $item) {
						array_push($data, $key2);

					}
				}
			}
		}
		return $data;
	}

	public function asm_mekong()
	{
		$roles = $this->role_model->find_where(['status' => 'active']);
		$data = [];

		foreach ($roles as $key => $role) {
			if (!empty($role['users']) && ($role['slug'] == "asm-mekong")) {
				foreach ($role['users'] as $key1 => $user) {

					foreach ($user as $key2 => $item) {

						array_push($data, $key2);

					}
				}
			}
		}
		return $data;
	}


	public function quan_ly_ho_so_mn()
	{
		$roles = $this->role_model->find_where(['status' => 'active']);
		$data = [];

		foreach ($roles as $key => $role) {
			if (!empty($role['users']) && ($role['slug'] == "qlhs-mien-nam")) {
				foreach ($role['users'] as $key1 => $user) {

					foreach ($user as $key2 => $item) {

						array_push($data, $key2);

					}
				}
			}
		}
		return $data;
	}

	public function quan_ly_ho_so_mekong()
	{
		$roles = $this->role_model->find_where(['status' => 'active']);
		$data = [];

		foreach ($roles as $key => $role) {
			if (!empty($role['users']) && ($role['slug'] == "qlhs-mekong")) {
				foreach ($role['users'] as $key1 => $user) {

					foreach ($user as $key2 => $item) {

						array_push($data, $key2);

					}
				}
			}
		}
		return $data;
	}

	private function getGroupRole_asm()
	{
		$groupRoles = $this->group_role_model->find_where(array("status" => "active", 'slug' => 'quan-ly-khu-vuc'));

		$arr = array();
		foreach ($groupRoles as $groupRole) {
			if (!empty($groupRole['users'])) {

				foreach ($groupRole['users'] as $value) {
					foreach ($value as $key => $item) {
						array_push($arr, $key);
					}

				}
			}
		}
		return $arr;
	}

	private function getGroupRole_gdv()
	{
		$groupRoles = $this->group_role_model->find_where(array("status" => "active", 'slug' => 'giao-dich-vien'));

		$arr = array();
		foreach ($groupRoles as $groupRole) {
			if (!empty($groupRole['users'])) {

				foreach ($groupRole['users'] as $value) {
					foreach ($value as $key => $item) {
						array_push($arr, $key);
					}

				}
			}
		}
		return $arr;
	}

	public function return_v2_fileReturn_post()
	{
		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);
		$this->dataPost['ghichu'] = $this->security->xss_clean($this->dataPost['ghichu']);
		$this->dataPost['fileReturn_img_v2'] = $this->security->xss_clean($this->dataPost['fileReturn_img_v2']);
		//V2
		$this->dataPost['thoa_thuan_ba_ben'] = $this->security->xss_clean($this->dataPost['thoa_thuan_ba_ben']);
		$this->dataPost['bbbg_tai_san'] = $this->security->xss_clean($this->dataPost['bbbg_tai_san']);
		$this->dataPost['dang_ky_xe'] = $this->security->xss_clean($this->dataPost['dang_ky_xe']);
		$this->dataPost['thong_bao'] = $this->security->xss_clean($this->dataPost['thong_bao']);
		$this->dataPost['hd_mua_ban_xe'] = $this->security->xss_clean($this->dataPost['hd_mua_ban_xe']);
		$this->dataPost['cam_ket'] = $this->security->xss_clean($this->dataPost['cam_ket']);
		$this->dataPost['bbbg_thiet_bi_dinh_vi'] = $this->security->xss_clean($this->dataPost['bbbg_thiet_bi_dinh_vi']);
		$this->dataPost['bbh_hoi_dong_co_dong'] = $this->security->xss_clean($this->dataPost['bbh_hoi_dong_co_dong']);
		$this->dataPost['hop_dong_mua_ban'] = $this->security->xss_clean($this->dataPost['hop_dong_mua_ban']);
		$this->dataPost['hd_uy_quyen'] = $this->security->xss_clean($this->dataPost['hd_uy_quyen']);
		$this->dataPost['hd_chuyen_nhuong'] = $this->security->xss_clean($this->dataPost['hd_chuyen_nhuong']);
		$this->dataPost['so_do'] = $this->security->xss_clean($this->dataPost['so_do']);
		$this->dataPost['hd_dat_coc'] = $this->security->xss_clean($this->dataPost['hd_dat_coc']);
		$this->dataPost['phu_luc_gia_han'] = $this->security->xss_clean($this->dataPost['phu_luc_gia_han']);
		//Validate
		if (empty($this->dataPost['fileReturn_img_v2'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Ảnh không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

		$check_fileReturn = $this->file_manager_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])));
		$this->dataPost['updated_at'] = $this->createdAt;
		$this->dataPost['status'] = "9";
		$log = array(
			"type" => "fileReturn",
			"action" => "Xác nhận",
			"fileReturn_id" => $this->dataPost['id'],
			"old" => $check_fileReturn,
			"new" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_fileManager_model->insert($log);
		$check_fileReturn['status'] = "9";
		$user = array($check_fileReturn['created_by']['id']);
		$this->sendEmailApprove_qlhs($check_fileReturn, $user);
		if (!empty($user)) {
			foreach (array_unique($user) as $re) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id'],
					'action' => 'FileReturn_cancel',
					'note' => 'QLHS đã xác nhận YC trả HS',
					'user_id' => $re,
					'status' => 1, //1: new, 2 : read, 3: block,
					'fileReturn_status' => 9,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}
		unset($this->dataPost['id']);
		$array_update = [
			"status" => "9",
			"ghichu" => $this->dataPost['ghichu'],
			"fileReturn_img_v2" => $this->dataPost['fileReturn_img_v2'],
			"records_return.thoa_thuan_ba_ben.text" => 'Thỏa thuận 3 bên',
			"records_return.thoa_thuan_ba_ben.quantity" => (int)$this->dataPost['thoa_thuan_ba_ben'],
			"records_return.thoa_thuan_ba_ben.slug" => 'thoa-thuan-3-ben',
			"records_return.bbbg_tai_san.text" => 'Biên bản bàn giao Tài sản',
			"records_return.bbbg_tai_san.quantity" => (int)$this->dataPost['bbbg_tai_san'],
			"records_return.bbbg_tai_san.slug" => 'bien-ban-ban-giao-tai-san',
			"records_return.dang_ky_xe.text" => 'Đăng ký / Cà vẹt xe',
			"records_return.dang_ky_xe.quantity" => (int)$this->dataPost['dang_ky_xe'],
			"records_return.dang_ky_xe.slug" => 'dang-ky-xe',
			"records_return.thong_bao.text" => 'Thông báo',
			"records_return.thong_bao.quantity" => (int)$this->dataPost['thong_bao'],
			"records_return.thong_bao.slug" => 'thong-bao',
			"records_return.hd_mua_ban_xe.text" => 'Hợp đồng mua bán xe',
			"records_return.hd_mua_ban_xe.quantity" => (int)$this->dataPost['hd_mua_ban_xe'],
			"records_return.hd_mua_ban_xe.slug" => 'hop-dong-mua-ban-xe',
			"records_return.cam_ket.text" => 'Cam kết',
			"records_return.cam_ket.quantity" => (int)$this->dataPost['cam_ket'],
			"records_return.cam_ket.slug" => 'cam-ket',
			"records_return.bbbg_thiet_bi_dinh_vi.text" => 'BBBG thiết bị định vị',
			"records_return.bbbg_thiet_bi_dinh_vi.quantity" => (int)$this->dataPost['bbbg_thiet_bi_dinh_vi'],
			"records_return.bbbg_thiet_bi_dinh_vi.slug" => 'bbbg-thiet-bi-dinh-vi',
			"records_return.bbh_hoi_dong_co_dong.text" => 'BB họp hội đồng cổ đông',
			"records_return.bbh_hoi_dong_co_dong.quantity" => (int)$this->dataPost['bbh_hoi_dong_co_dong'],
			"records_return.bbh_hoi_dong_co_dong.slug" => 'bb-hop-hoi-dong-co-dong',
			"records_return.hop_dong_mua_ban.text" => 'Hợp đồng mua bán',
			"records_return.hop_dong_mua_ban.quantity" => (int)$this->dataPost['hop_dong_mua_ban'],
			"records_return.hop_dong_mua_ban.slug" => 'hop-dong-mua-ban',
			"records_return.hd_uy_quyen.text" => 'Hợp đồng ủy quyền',
			"records_return.hd_uy_quyen.quantity" => (int)$this->dataPost['hd_uy_quyen'],
			"records_return.hd_uy_quyen.slug" => 'hop-dong-uy-quyen',
			"records_return.hd_chuyen_nhuong.text" => 'Hợp đồng chuyển nhượng',
			"records_return.hd_chuyen_nhuong.quantity" => (int)$this->dataPost['hd_chuyen_nhuong'],
			"records_return.hd_chuyen_nhuong.slug" => 'hop-dong-chuyen-nhuong',
			"records_return.so_do.text" => 'Sổ đỏ / Giấy CNQSDĐ',
			"records_return.so_do.quantity" => (int)$this->dataPost['so_do'],
			"records_return.so_do.slug" => 'so-do',
			"records_return.hd_dat_coc.text" => 'Hợp đồng đặt cọc',
			"records_return.hd_dat_coc.quantity" => (int)$this->dataPost['hd_dat_coc'],
			"records_return.hd_dat_coc.slug" => 'hop-dong-dat-coc',
			"records_return.phu_luc_gia_han.text" => 'Phụ lục gia hạn',
			"records_return.phu_luc_gia_han.quantity" => (int)$this->dataPost['phu_luc_gia_han'],
			"records_return.phu_luc_gia_han.slug" => 'phu-luc-gia-han',
			"updated_rcrt_at" => $this->createdAt,
			"updated_rcrt_by" => $this->uemail,
		];
		$this->file_manager_model->update(array("_id" => $check_fileReturn['_id']), $array_update);
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Trả hồ sơ thành công!"

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function cvkd_ycbs_fileReturn_post()
	{

		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);

		$this->dataPost['file'] = $this->security->xss_clean($this->dataPost['file']);
		$this->dataPost['giay_to_khac'] = $this->security->xss_clean($this->dataPost['giay_to_khac']);

		$this->dataPost['taisandikem'] = $this->security->xss_clean($this->dataPost['taisandikem']);
		$this->dataPost['ghichu'] = $this->security->xss_clean($this->dataPost['ghichu']);

		$this->dataPost['fileReturn_img'] = $this->security->xss_clean($this->dataPost['fileReturn_img']);

		//Validate
		if (empty($this->dataPost['giay_to_khac'])) {
			if (empty($this->dataPost['file'])) {
				$response = array(
					'status' => REST_Controller::HTTP_UNAUTHORIZED,
					'message' => "File trả không được để trống"
				);
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			}
		}
		if (empty($this->dataPost['fileReturn_img'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Ảnh không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

		$check_fileReturn = $this->file_manager_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])));

		$this->dataPost['updated_at'] = $this->createdAt;
		$this->dataPost['status'] = "10";
		$log = array(
			"type" => "fileReturn",
			"action" => "Xác nhận",
			"fileReturn_id" => $this->dataPost['id'],
			"old" => $check_fileReturn,
			"new" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_fileManager_model->insert($log);

		$check_area = $this->store_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($check_fileReturn['stores'])));
		if ($check_area['code_area'] == "Priority" ||$check_area['code_area'] == "KV_HN1" || $check_area['code_area'] == "KV_HN2" || $check_area['code_area'] == "KV_QN" || $check_area['code_area'] == "KV_MT1" || $check_area['code_area'] == "KV_BTB") {
			$user = $this->quan_ly_ho_so_mb();
		} else if ($check_area['code_area'] == "KV_MK") {
			$user = $this->quan_ly_ho_so_mekong();
		} else {
			$user = $this->quan_ly_ho_so_mn();
		}
		$check_fileReturn['status'] = "10";
		$this->sendEmailApprove_qlhs($check_fileReturn, $user);
		if (!empty($user)) {
			foreach (array_unique($user) as $re) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id'],
					'action' => 'FileReturn_cancel',
					'note' => 'YC bổ sung HS',
					'user_id' => $re,
					'status' => 1, //1: new, 2 : read, 3: block,
					'fileReturn_status' => 10,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}

		unset($this->dataPost['id']);

		$this->file_manager_model->update(array("_id" => $check_fileReturn['_id']), array("status" => "10", "file_v2" => $this->dataPost['file'], "giay_to_khac_v2" => $this->dataPost['giay_to_khac'], "taisandikem_v2" => $this->dataPost['taisandikem'], "ghichu" => $this->dataPost['ghichu'], "fileReturn_img_v2" => $this->dataPost['fileReturn_img']));

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Update success"

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;


	}

	public function trahososautattoan_fileReturn_post()
	{

		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);
		$this->dataPost['ghichu'] = $this->security->xss_clean($this->dataPost['ghichu']);
		$this->dataPost['file_img_approve'] = $this->security->xss_clean($this->dataPost['file_img_approve']);

		$fileReturn = $this->file_manager_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])));
		if (!empty($fileReturn['is_dkx_origin']) && $fileReturn['is_dkx_origin'] == true) {
			$status_dkx = 2;
		} else {
			$status_dkx = $fileReturn['status_dkx'] ?? 4;
		}

		$this->dataPost['status'] = "11";
		$log = array(
			"type" => "fileReturn",
			"action" => "Xác nhận",
			"fileReturn_id" => $this->dataPost['id'],
			"old" => $fileReturn,
			"new" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_fileManager_model->insert($log);

		$check_area = $this->store_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($fileReturn['stores'])));
		if ($check_area['code_area'] == "Priority" ||$check_area['code_area'] == "KV_HN1" || $check_area['code_area'] == "KV_HN2" || $check_area['code_area'] == "KV_QN" || $check_area['code_area'] == "KV_MT1" || $check_area['code_area'] == "KV_BTB") {
			$user = $this->quan_ly_ho_so_mb();
		} else if ($check_area['code_area'] == "KV_MK") {
			$user = $this->quan_ly_ho_so_mekong();
		} else {
			$user = $this->quan_ly_ho_so_mn();
		}
		$fileReturn['status'] = "11";
		$this->sendEmailApprove_qlhs($fileReturn, $user);
		if (!empty($user)) {
			foreach (array_unique($user) as $re) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id'],
					'action' => 'FileReturn_cancel',
					'note' => 'Đã trả HS sau tất toán',
					'user_id' => $re,
					'status' => 1, //1: new, 2 : read, 3: block,
					'fileReturn_status' => 11,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}

		unset($this->dataPost['id']);
		$array_update = [
			"status" => "11",
			"ghichu" => $this->dataPost['ghichu'],
			"file_img_approve" => $this->dataPost['file_img_approve'],
			"status_dkx" => $status_dkx
		];
		$this->file_manager_model->update(array("_id" => $fileReturn['_id']), $array_update);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Approve borrowed success"

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function traveyeucautattoan_fileReturn_post()
	{

		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);
		$this->dataPost['ghichu'] = $this->security->xss_clean($this->dataPost['ghichu']);
		$this->dataPost['file_img_approve'] = $this->security->xss_clean($this->dataPost['file_img_approve']);

		$fileReturn = $this->file_manager_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])));
		$this->dataPost['status'] = "13";
		$log = array(
			"type" => "fileReturn",
			"action" => "Xác nhận",
			"fileReturn_id" => $this->dataPost['id'],
			"old" => $fileReturn,
			"new" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_fileManager_model->insert($log);


		$user = array($fileReturn['created_by']['id']);
		$fileReturn['status'] = "13";
		$this->sendEmailApprove_qlhs($fileReturn, $user);
		if (!empty($user)) {
			foreach (array_unique($user) as $re) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id'],
					'action' => 'FileReturn_cancel',
					'note' => 'Trả về yêu cầu',
					'user_id' => $re,
					'status' => 1, //1: new, 2 : read, 3: block,
					'fileReturn_status' => 13,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}

		unset($this->dataPost['id']);

		$this->file_manager_model->update(array("_id" => $fileReturn['_id']), ["status" => "13", "ghichu" => $this->dataPost['ghichu'], "file_img_approve" => $this->dataPost['file_img_approve']]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Approve borrowed success"

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}


	public function get_log_one_post()
	{

		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);

		$fileManager = $this->log_fileManager_model->find_where(array("fileReturn_id" => $this->dataPost['id']));

		if (empty($fileManager)) return;

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $fileManager
		);
		$this->set_response($response, REST_Controller::HTTP_OK);

	}


	private function getGroupRole($userId)
	{
		$groupRoles = $this->group_role_model->find_where(array("status" => "active"));
		$arr = array();
		foreach ($groupRoles as $groupRole) {
			if (empty($groupRole['users'])) continue;
			foreach ($groupRole['users'] as $item) {
				if (key($item) == $userId) {
					array_push($arr, $groupRole['slug']);
					continue;
				}
			}
		}
		return $arr;
	}


	private function getGroupRole_email($userId)
	{
		$groupRoles = $this->group_role_model->find_where(array("status" => "active"));
		$arr = array();
		foreach ($groupRoles as $groupRole) {
			if (empty($groupRole['users'])) continue;
			foreach ($groupRole['users'] as $item) {
				if (key($item) == $userId) {
					array_push($arr, $item[key($item)]['email']);
					continue;
				}
			}
		}
		return array_unique($arr);
	}

	private function getStores($userId)
	{
		$roles = $this->role_model->find_where(array("status" => "active"));
		$roleStores = array();
		if (count($roles) > 0) {
			foreach ($roles as $role) {
				if (!empty($role['users']) && count($role['users']) > 0) {
					$arrUsers = array();
					foreach ($role['users'] as $item) {
						array_push($arrUsers, key($item));
					}
					//Check userId in list key of $users
					if (in_array($userId, $arrUsers) == TRUE) {
						if (!empty($role['stores'])) {
							//Push store
							foreach ($role['stores'] as $key => $item) {
								array_push($roleStores, key($item));
							}
						}
					}
				}
			}
		}
		return $roleStores;
	}


	private function getUserbyStores_email($storeId)
	{
		$roles = $this->role_model->find_where(array("status" => "active"));
		$roleAllUsers = array();
		if (count($roles) > 0) {
			foreach ($roles as $role) {
				if (!empty($role['stores']) && count($role['stores']) == 1) {
					$arrStores = array();
					foreach ($role['stores'] as $item) {
						array_push($arrStores, key($item));
					}
					//Check userId in list key of $users
					if (in_array($storeId, $arrStores) == TRUE) {
						if (!empty($role['stores'])) {
							//Push store
							foreach ($role['users'] as $key => $item) {
								array_push($roleAllUsers, $item[key($item)]['email']);
							}
						}
					}
				}
			}
		}
		$roleUsers = array_unique($roleAllUsers);
		return $roleUsers;
	}


	public function check_file_manager_post()
	{
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;
		$data = $this->input->post();
		$groupRoles = $this->getGroupRole($this->id);
		$all = false;
		$condition = [];
		if (in_array('giao-dich-vien', $groupRoles) || in_array('cua-hang-truong', $groupRoles)) {
			$all = true;
		}
		if ($all) {
			$stores = $this->getStores($this->id);
			if (empty($stores)) {
				$response = array(
					'status' => REST_Controller::HTTP_OK,
					'data' => array()
				);
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			}
			$condition['stores'] = $stores;
		}

		$borrowed = $this->file_manager_model->where_in_status($condition);
		if (empty($borrowed)) {
			return;
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $borrowed
		);
		$this->set_response($response, REST_Controller::HTTP_OK);


	}

	public function process_create_borrowed_post()
	{

		$this->dataPost['code_contract_disbursement_value'] = $this->security->xss_clean($this->dataPost['code_contract_disbursement_value']);
		$this->dataPost['code_contract_disbursement_text'] = trim(implode("", $this->security->xss_clean($this->dataPost['code_contract_disbursement_text'])));
		$this->dataPost['file'] = $this->security->xss_clean($this->dataPost['file']);
		$this->dataPost['giay_to_khac'] = $this->security->xss_clean($this->dataPost['giay_to_khac']);
		$this->dataPost['borrowed_start'] = strtotime($this->security->xss_clean($this->dataPost['borrowed_start']));
		$this->dataPost['borrowed_end'] = strtotime($this->security->xss_clean($this->dataPost['borrowed_end']));
		$this->dataPost['ghichu'] = $this->security->xss_clean($this->dataPost['ghichu']);
		$this->dataPost['groupRoles_store'] = $this->security->xss_clean($this->dataPost['groupRoles_store']);
		$this->dataPost['lydomuon'] = $this->security->xss_clean($this->dataPost['lydomuon']);

		$check_area = $this->store_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['stores'])));
		$this->dataPost['area'] = $check_area['code_area'];

		if ($check_area['code_area'] == "Priority" ||$check_area['code_area'] == "KV_HN1" || $check_area['code_area'] == "KV_HN2" || $check_area['code_area'] == "KV_QN" || $check_area['code_area'] == "KV_MT1" || $check_area['code_area'] == "KV_BTB") {
			$user = $this->quan_ly_ho_so_mb();
		} else if ($check_area['code_area'] == "KV_MK") {
			$user = $this->quan_ly_ho_so_mekong();
		} else {
			$user = $this->quan_ly_ho_so_mn();
		}


		//Validate
		if (empty($this->dataPost['code_contract_disbursement_value'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Mã hợp đồng không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

//		$check_borrowed = $this->borrowed_model->find_where(array("code_contract_disbursement_text" => $this->dataPost['code_contract_disbursement_text']));
//
//		if (!empty($check_borrowed)) {
//			if ($check_borrowed[0]->status != "10" && ($check_borrowed[0]->status != "2")) {
//				$response = array(
//					'status' => REST_Controller::HTTP_UNAUTHORIZED,
//					'message' => "Hồ sơ của hợp đồng đang được mượn"
//				);
//				$this->set_response($response, REST_Controller::HTTP_OK);
//				return;
//			}
//		}

		if (empty($this->dataPost['lydomuon'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Lý do mượn không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

		if (empty($this->dataPost['giay_to_khac'])) {
			if (empty($this->dataPost['file'])) {
				$response = array(
					'status' => REST_Controller::HTTP_UNAUTHORIZED,
					'message' => "Danh sách hồ sơ không được để trống"
				);
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			}
		}

		if (empty($this->dataPost['borrowed_start'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Thời gian bắt đầu mượn không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		if (empty($this->dataPost['borrowed_end'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Thời gian trả không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		if ($this->dataPost['borrowed_start'] > $this->dataPost['borrowed_end']) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Thời gian trả phải lớn hơn thời gian mượn"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		if ($this->dataPost['borrowed_start'] == $this->dataPost['borrowed_end']) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Thời gian mượn và thời gian trả không trùng nhau"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

		$check_borrowed = $this->dataPost['borrowed_end'] - $this->dataPost['borrowed_start'];
		$years = floor($check_borrowed / (365 * 60 * 60 * 24));
		$months = floor(($check_borrowed - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
		$days = floor(($check_borrowed - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
		$is_user = (string)$this->id;
		$list_id_nv_qlkv_mb = $this->role_model->get_id_nv_qlkv_mb();
		$list_id_nv_qlkv_mn = $this->role_model->get_id_nv_qlkv_mn();
		$list_id_lead_qlkv_mb = $this->role_model->get_id_lead_qlkv_mb();
		$list_id_lead_qlkv_mn = $this->role_model->get_id_lead_qlkv_mn();
		$list_nv_qlkv = array_merge($list_id_nv_qlkv_mb, $list_id_lead_qlkv_mb, $list_id_nv_qlkv_mn, $list_id_lead_qlkv_mn);
		if (in_array($is_user, $list_nv_qlkv)) {
			if ($days > 10 || $months >= 1) {
				$response = array(
					'status' => REST_Controller::HTTP_UNAUTHORIZED,
					'message' => "Thời gian mượn không được quá 10 ngày"
				);
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			}
		} else {
			if ($days > 15 || $months >= 1) {
				$response = array(
					'status' => REST_Controller::HTTP_UNAUTHORIZED,
					'message' => "Thời gian mượn không được quá 15 ngày"
				);
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			}
		}


		$this->dataPost['created_at'] = $this->createdAt;

		$contractId = $this->borrowed_model->insertReturnId($this->dataPost);

		$log = array(
			"type" => "borrowed",
			"action" => "Tạo YC mượn HS",
			"borrowed_id" => (string)$contractId,
			"borrowed" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_borrowed_model->insert($log);

		$fileReturn = $this->borrowed_model->findOne(array("_id" => new MongoDB\BSON\ObjectId((string)$contractId)));
		$this->sendEmailApprove_borrowed($fileReturn, $user);

		if (!empty($user)) {
			foreach (array_unique($user) as $qlhs) {
				$data_approve = [
					'action_id' => (string)$contractId,
					'action' => 'Borrowed_create',
					'note' => 'Mới',
					'user_id' => (string)$qlhs,
					'status' => 1, //1: new, 2 : read, 3: block,
					'borrowed_status' => 1,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Tạo yêu cầu mượn hồ sơ thành công!"

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function get_count_all_post()
	{

		$this->dataPost = $this->input->post();
		$condition = [];

		$fdate = !empty($this->dataPost['fdate']) ? $this->dataPost['fdate'] : "";
		$tdate = !empty($this->dataPost['tdate']) ? $this->dataPost['tdate'] : "";
		$code_contract_disbursement_text = !empty($this->dataPost['code_contract_disbursement_search']) ? $this->dataPost['code_contract_disbursement_search'] : "";
		$status = !empty($this->dataPost['status']) ? $this->dataPost['status'] : "";
		$store = !empty($this->dataPost['store']) ? $this->dataPost['store'] : "";
		$groupRoles_store_search = !empty($this->dataPost['groupRoles_store_search']) ? $this->dataPost['groupRoles_store_search'] : "";

		if (!empty($store)) {
			$condition['store'] = $store;
		}
		if (!empty($code_contract_disbursement_text)) {
			$condition['code_contract_disbursement_text'] = $code_contract_disbursement_text;
		}
		if (!empty($groupRoles_store_search)) {
			$condition['groupRoles_store_search'] = $groupRoles_store_search;
		}
		if (!empty($status)) {
			$condition['status'] = $status;
		}
		if (!empty($fdate)) {
			$condition['fdate'] = strtotime(trim($fdate) . ' 00:00:00');
		}
		if (!empty($tdate)) {
			$condition['tdate'] = strtotime(trim($tdate) . ' 23:59:59');
		}

		$groupRoles = $this->getGroupRole($this->id);
		$id_user = (string)$this->id;
		$all = true;
		if (in_array('quan-ly-ho-so', $groupRoles)) {
			$all = false;
		}

		if (in_array('cua-hang-truong', $groupRoles) || in_array('quan-ly-khu-vuc', $groupRoles)) {

			$stores_list = $this->getStores_list($this->id);
			$condition['stores_list'] = $stores_list;
			$condition['groupRoles_store'] = "Cửa hàng trưởng";

		} elseif (in_array('quan-ly-ho-so', $groupRoles)){

			$stores_list = $this->getStores_list($this->id);
			$condition['stores_list'] = $stores_list;

		} elseif (in_array('thu-hoi-no', $groupRoles)) {
			$list_qlkv_mb = $this->role_model->get_list_all_id_nv_qlkv_mb();
			$list_qlkv_mn = $this->role_model->get_list_all_id_nv_qlkv_mn();
			$condition['created_by'] = $this->uemail;
			if (in_array($id_user, $list_qlkv_mb)) {
				$condition['domain_borrow'] = "MB";
			} elseif (in_array($id_user, $list_qlkv_mn)) {
				$condition['domain_borrow'] = "MN";
			}
		} else {
			$condition['created_by'] = $this->uemail;
		}
		$borrowed_count = $this->borrowed_model->getCountByRole($condition);
		if (empty($borrowed_count)) {
			return;
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $borrowed_count
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function get_all_post()
	{
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;
		$this->dataPost = $this->input->post();
		$condition = [];

		$fdate = !empty($this->dataPost['fdate']) ? $this->dataPost['fdate'] : "";
		$tdate = !empty($this->dataPost['tdate']) ? $this->dataPost['tdate'] : "";
		$code_contract_disbursement_text = !empty($this->dataPost['code_contract_disbursement_search']) ? $this->dataPost['code_contract_disbursement_search'] : "";
		$status = !empty($this->dataPost['status']) ? $this->dataPost['status'] : "";
		$store = !empty($this->dataPost['store']) ? $this->dataPost['store'] : "";
		$groupRoles_store_search = !empty($this->dataPost['groupRoles_store_search']) ? $this->dataPost['groupRoles_store_search'] : "";

		if (!empty($code_contract_disbursement_text)) {
			$condition['code_contract_disbursement_text'] = $code_contract_disbursement_text;
		}
		if (!empty($status)) {
			$condition['status'] = (string)$status;
		}
		if (!empty($store)) {
			$condition['store'] = $store;
		}
		if (!empty($fdate)) {
			$condition['fdate'] = strtotime(trim($fdate) . ' 00:00:00');
		}
		if (!empty($tdate)) {
			$condition['tdate'] = strtotime(trim($tdate) . ' 23:59:59');
		}
		if (!empty($groupRoles_store_search)) {
			$condition['groupRoles_store_search'] = $groupRoles_store_search;
		}

		$groupRoles = $this->getGroupRole($this->id);
		$id_user = (string)$this->id;
		$all = true;
		if (in_array('quan-ly-ho-so', $groupRoles) || in_array('quan-ly-cap-cao', $groupRoles)) {
			$all = false;
		}

		if (in_array('cua-hang-truong', $groupRoles) || in_array('quan-ly-khu-vuc', $groupRoles)) {

			$stores_list = $this->getStores_list($this->id);
			$condition['stores_list'] = $stores_list;
			$condition['groupRoles_store'] = "Cửa hàng trưởng";
		} elseif (in_array('quan-ly-ho-so', $groupRoles)){
			$stores_list = $this->getStores_list($this->id);
			$condition['stores_list'] = $stores_list;
		} elseif (in_array('thu-hoi-no', $groupRoles)) {
			$list_qlkv_mb = $this->role_model->get_list_all_id_nv_qlkv_mb();
			$list_qlkv_mn = $this->role_model->get_list_all_id_nv_qlkv_mn();
			$condition['created_by'] = $this->uemail;
			if (in_array($id_user, $list_qlkv_mb)) {
				$condition['domain_borrow'] = "MB";
			} elseif (in_array($id_user, $list_qlkv_mn)) {
				$condition['domain_borrow'] = "MN";
			}
		} else {
			$condition['created_by'] = $this->uemail;
		}
		$per_page = !empty($this->dataPost['per_page']) ? $this->dataPost['per_page'] : 30;
		$uriSegment = !empty($this->dataPost['uriSegment']) ? $this->dataPost['uriSegment'] : 0;
		$borrowed = $this->borrowed_model->getDataByRole($condition, $per_page, $uriSegment);
		if (empty($borrowed)) {
			return;
		}
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $borrowed
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function get_all_checkquahan_post()
	{
//		$flag = notify_token($this->flag_login);
//		if ($flag == false) return;
		$this->dataPost = $this->input->post();
		$condition = [];

		$fdate = !empty($this->dataPost['fdate']) ? $this->dataPost['fdate'] : "";
		$tdate = !empty($this->dataPost['tdate']) ? $this->dataPost['tdate'] : "";
		$code_contract_disbursement_text = !empty($this->dataPost['code_contract_disbursement_search']) ? $this->dataPost['code_contract_disbursement_search'] : "";

		if (!empty($code_contract_disbursement_text)) {
			$condition['code_contract_disbursement_text'] = $code_contract_disbursement_text;
		}

		if (!empty($fdate)) {
			$condition['fdate'] = strtotime(trim($fdate) . ' 00:00:00');
		}
		if (!empty($tdate)) {
			$condition['tdate'] = strtotime(trim($tdate) . ' 23:59:59');
		}


		$per_page = !empty($this->dataPost['per_page']) ? $this->dataPost['per_page'] : 30;
		$uriSegment = !empty($this->dataPost['uriSegment']) ? $this->dataPost['uriSegment'] : 0;

		$borrowed = $this->borrowed_model->getDataByRole_quahan($condition, $per_page, $uriSegment);

		if (empty($borrowed)) {
			return;
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $borrowed
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function get_count_all_quahan_post()
	{
		$this->dataPost = $this->input->post();
		$condition = [];

		$fdate = !empty($this->dataPost['fdate']) ? $this->dataPost['fdate'] : "";
		$tdate = !empty($this->dataPost['tdate']) ? $this->dataPost['tdate'] : "";
		$code_contract_disbursement_text = !empty($this->dataPost['code_contract_disbursement_search']) ? $this->dataPost['code_contract_disbursement_search'] : "";

		if (!empty($code_contract_disbursement_text)) {
			$condition['code_contract_disbursement_text'] = $code_contract_disbursement_text;
		}
		if (!empty($fdate)) {
			$condition['fdate'] = strtotime(trim($fdate) . ' 00:00:00');
		}
		if (!empty($tdate)) {
			$condition['tdate'] = strtotime(trim($tdate) . ' 23:59:59');
		}

		$borrowed_count = $this->borrowed_model->getCountByRole_quahan($condition);

		if (empty($borrowed_count)) {
			return;
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $borrowed_count
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}


	public function get_log_one_borrowed_post()
	{
		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);

		$fileManager = $this->log_borrowed_model->find_where(array("borrowed_id" => $this->dataPost['id']));

		if (empty($fileManager)) return;

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $fileManager
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
	}

	public function get_one_borrowed_post()
	{

		$data = $this->input->post();

		$borrowed = $this->borrowed_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($data["id"])));

		if (empty($borrowed)) return;

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $borrowed
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
	}

	public function cancel_borrowed_post()
	{

		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);

		$fileReturn = $this->borrowed_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])));
		$this->dataPost['status'] = "2";
		$log = array(
			"type" => "fileReturn",
			"action" => "Hủy",
			"borrowed_id" => $this->dataPost['id'],
			"old" => $fileReturn,
			"new" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_borrowed_model->insert($log);

		$check_area = $this->store_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($fileReturn['stores'])));
		if ($check_area['code_area'] == "KV_HN1" || $check_area['code_area'] == "KV_HN2" || $check_area['code_area'] == "KV_QN" || $check_area['code_area'] == "KV_MT1" || $check_area['code_area'] == "KV_BTB") {
			$user_qlhs = $this->quan_ly_ho_so_mb();
		} else if ($check_area['code_area'] == "KV_MK") {
			$user_qlhs = $this->quan_ly_ho_so_mekong();
		} else {
			$user_qlhs = $this->quan_ly_ho_so_mn();
		}
		$user_send = array($fileReturn['created_by']['id']);

		$user = array_merge($user_send, $user_qlhs);
		$fileReturn['status'] = "2";
		$this->sendEmailApprove_borrowed($fileReturn, $user);

		if (!empty($user)) {
			foreach (array_unique($user) as $re) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id'],
					'action' => 'FileReturn_cancel',
					'note' => 'Hủy yêu cầu',
					'user_id' => $re,
					'status' => 1, //1: new, 2 : read, 3: block,
					'borrowed_status' => 2,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}

		unset($this->dataPost['id']);

		$this->borrowed_model->update(array("_id" => $fileReturn['_id']), ["status" => "2"]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Cancel borrowed success"

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function process_update_borrowed_post()
	{

		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);
		$this->dataPost['code_contract_disbursement_value'] = $this->security->xss_clean($this->dataPost['code_contract_disbursement_value']);
		$this->dataPost['code_contract_disbursement_text'] = trim(implode("", $this->security->xss_clean($this->dataPost['code_contract_disbursement_text'])));
		$this->dataPost['file'] = $this->security->xss_clean($this->dataPost['file']);
		$this->dataPost['giay_to_khac'] = $this->security->xss_clean($this->dataPost['giay_to_khac']);
		$this->dataPost['ghichu'] = $this->security->xss_clean($this->dataPost['ghichu']);
		$this->dataPost['borrowed_start'] = strtotime($this->security->xss_clean($this->dataPost['borrowed_start']));
		$this->dataPost['borrowed_end'] = strtotime($this->security->xss_clean($this->dataPost['borrowed_end']));
		$this->dataPost['groupRoles_store'] = $this->security->xss_clean($this->dataPost['groupRoles_store']);
		$this->dataPost['lydomuon'] = $this->security->xss_clean($this->dataPost['lydomuon']);

		//Validate
		if (empty($this->dataPost['code_contract_disbursement_value'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Mã hợp đồng không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

//		$check_borrowed = $this->borrowed_model->find_where(array("code_contract_disbursement_text" => $this->dataPost['code_contract_disbursement_text']));
//
//		if (!empty($check_borrowed)) {
//			if ($check_borrowed[0]->status != "10" && ($check_borrowed[0]->status != "2")) {
//				$response = array(
//					'status' => REST_Controller::HTTP_UNAUTHORIZED,
//					'message' => "Hồ sơ của hợp đồng đang được mượn"
//				);
//				$this->set_response($response, REST_Controller::HTTP_OK);
//				return;
//			}
//		}

		if (empty($this->dataPost['lydomuon'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Lý do mượn không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

		if (empty($this->dataPost['giay_to_khac'])) {
			if (empty($this->dataPost['file'])) {
				$response = array(
					'status' => REST_Controller::HTTP_UNAUTHORIZED,
					'message' => "Danh sách hồ sơ không được để trống"
				);
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			}
		}

		if (empty($this->dataPost['borrowed_start'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Thời gian bắt đầu mượn không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		if (empty($this->dataPost['borrowed_end'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Thời gian trả không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		if ($this->dataPost['borrowed_start'] > $this->dataPost['borrowed_end']) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Thời gian trả phải lớn hơn thời gian mượn"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		if ($this->dataPost['borrowed_start'] == $this->dataPost['borrowed_end']) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Thời gian mượn và thời gian trả không trùng nhau"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

		$check_borrowed = $this->dataPost['borrowed_end'] - $this->dataPost['borrowed_start'];
		$years = floor($check_borrowed / (365 * 60 * 60 * 24));
		$months = floor(($check_borrowed - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
		$days = floor(($check_borrowed - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

		if ($days > 15 || $months >= 1) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Thời gian mượn không được quá 15 ngày"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

		$check_fileReturn = $this->borrowed_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])));

		$this->dataPost['updated_at'] = $this->createdAt;

		$log = array(
			"type" => "borrowed",
			"action" => "Sửa",
			"borrowed_id" => $this->dataPost['id'],
			"borrowed" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_borrowed_model->insert($log);

		unset($this->dataPost['id']);

		$this->borrowed_model->update(array("_id" => $check_fileReturn['_id']), ["file" => $this->dataPost['file'], "giay_to_khac" => $this->dataPost['giay_to_khac'], "ghichu" => $this->dataPost['ghichu'], "borrowed_start" => $this->dataPost['borrowed_start'], "borrowed_end" => $this->dataPost['borrowed_end'], "groupRoles_store" => $this->dataPost['groupRoles_store'], "lydomuon" => $this->dataPost['lydomuon']]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Update borrowed success"

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function asm_borrowed_post()
	{

		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);

		$fileReturn = $this->borrowed_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])));
		$this->dataPost['status'] = "3";
		$log = array(
			"type" => "borrowed",
			"action" => "Hủy",
			"borrowed_id" => $this->dataPost['id'],
			"old" => $fileReturn,
			"new" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_borrowed_model->insert($log);

		if ($fileReturn['area'] == "KV_HN1" || $fileReturn['area'] == "KV_MT1") {
			$user = $this->asm_hn1();
		} elseif ($fileReturn['area'] == "KV_HN2" || $fileReturn['area'] == "KV_QN") {
			$user = $this->asm_hn2();
		} elseif ($fileReturn['area'] == "KV_HCM1") {
			$user = $this->asm_hcm1();
		} elseif ($fileReturn['area'] == "KV_HCM2") {
			$user = $this->asm_hcm2();
		} elseif ($fileReturn['area'] == "KV_MK") {
			$user = $this->asm_mekong();
		}
		$fileReturn['status'] = "3";
		$this->sendEmailApprove_borrowed($fileReturn, $user);

		if (!empty($user)) {
			foreach (array_unique($user) as $re) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id'],
					'action' => 'FileReturn_cancel',
					'note' => 'PGD YC mượn HS giải ngân',
					'user_id' => $re,
					'status' => 1, //1: new, 2 : read, 3: block,
					'borrowed_status' => 3,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}

		unset($this->dataPost['id']);

		$this->borrowed_model->update(array("_id" => $fileReturn['_id']), ["status" => "3"]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Cancel borrowed success"

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function qlhs_borrowed_post()
	{

		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);
		$this->dataPost['ghichu'] = $this->security->xss_clean($this->dataPost['ghichu']);
		$this->dataPost['file_img_approve'] = $this->security->xss_clean($this->dataPost['file_img_approve']);

		$fileReturn = $this->borrowed_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])));
		$this->dataPost['status'] = "4";
		$log = array(
			"type" => "borrowed",
			"action" => "Xác nhận",
			"borrowed_id" => $this->dataPost['id'],
			"old" => $fileReturn,
			"new" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_borrowed_model->insert($log);

		$check_area = $this->store_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($fileReturn['stores'])));
		if ($check_area['code_area'] == "Priority" ||$check_area['code_area'] == "KV_HN1" || $check_area['code_area'] == "KV_HN2" || $check_area['code_area'] == "KV_QN" || $check_area['code_area'] == "KV_MT1" || $check_area['code_area'] == "KV_BTB") {
			$user = $this->quan_ly_ho_so_mb();
		} else if ($check_area['code_area'] == "KV_MK") {
			$user = $this->quan_ly_ho_so_mekong();
		} else {
			$user = $this->quan_ly_ho_so_mn();
		}
		$fileReturn['status'] = "4";
		$this->sendEmailApprove_borrowed($fileReturn, $user);

		if (!empty($user)) {
			foreach (array_unique($user) as $re) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id'],
					'action' => 'FileReturn_cancel',
					'note' => 'Yêu cầu mượn HS',
					'user_id' => $re,
					'status' => 1, //1: new, 2 : read, 3: block,
					'borrowed_status' => 4,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}

		unset($this->dataPost['id']);

		$this->borrowed_model->update(array("_id" => $fileReturn['_id']), ["status" => "4", "ghichu" => $this->dataPost['ghichu'], "file_img_approve" => $this->dataPost['file_img_approve']]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "success"

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function qlhs_trahoso_borrowed_post()
	{

		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);

		$this->dataPost['ghichu'] = $this->security->xss_clean($this->dataPost['ghichu']);


		//Validate
		if (empty($this->dataPost['ghichu'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Ghi chú không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

		$check_fileReturn = $this->borrowed_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])));

		$this->dataPost['updated_at'] = $this->createdAt;
		$this->dataPost['status'] = "5";
		$log = array(
			"type" => "borrowed",
			"action" => "Xác nhận",
			"borrowed_id" => $this->dataPost['id'],
			"old" => $check_fileReturn,
			"new" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);

		$this->log_borrowed_model->insert($log);


		$user = array($check_fileReturn['created_by']['id']);
		$check_fileReturn['status'] = "5";
		$this->sendEmailApprove_borrowed($check_fileReturn, $user);

		if (!empty($user)) {
			foreach (array_unique($user) as $re) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id'],
					'action' => 'FileReturn_cancel',
					'note' => 'QLHS trả về yêu cầu mượn',
					'user_id' => $re,
					'status' => 1, //1: new, 2 : read, 3: block,
					'borrowed_status' => 5,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}

		unset($this->dataPost['id']);

		$this->borrowed_model->update(array("_id" => $check_fileReturn['_id']), ["status" => "5", "ghichu" => $this->dataPost['ghichu']]);


		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Update borrowed success"
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function approve_borrowed_post()
	{

		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);

		$this->dataPost['ghichu'] = $this->security->xss_clean($this->dataPost['ghichu']);
		$this->dataPost['fileApprove_img'] = $this->security->xss_clean($this->dataPost['fileApprove_img']);

		//Validate
		if (empty($this->dataPost['fileApprove_img'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Ảnh hồ sơ không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

		$check_fileReturn = $this->borrowed_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])));

		$this->dataPost['updated_at'] = $this->createdAt;
		$this->dataPost['status'] = "6";
		$log = array(
			"type" => "borrowed",
			"action" => "Xác nhận",
			"borrowed_id" => $this->dataPost['id'],
			"old" => $check_fileReturn,
			"new" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);

		$this->log_borrowed_model->insert($log);

		$user = array($check_fileReturn['created_by']['id']);
		$check_fileReturn['status'] = "6";
		$this->sendEmailApprove_borrowed($check_fileReturn, $user);

		if (!empty($user)) {
			foreach (array_unique($user) as $re) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id'],
					'action' => 'FileReturn_cancel',
					'note' => 'Chờ nhận hồ sơ',
					'user_id' => $re,
					'status' => 1, //1: new, 2 : read, 3: block,
					'borrowed_status' => 6,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}

		unset($this->dataPost['id']);

		$this->borrowed_model->update(array("_id" => $check_fileReturn['_id']), ["status" => "6", "ghichu" => $this->dataPost['ghichu'], "fileApprove_img" => $this->dataPost['fileApprove_img']]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Success"
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function borrowed_danhanhoso_post()
	{
		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);
		$this->dataPost['ghichu'] = $this->security->xss_clean($this->dataPost['ghichu']);
		$this->dataPost['file_img_approve'] = $this->security->xss_clean($this->dataPost['file_img_approve']);

		$fileReturn = $this->borrowed_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])));
		$this->dataPost['status'] = "7";
		$log = array(
			"type" => "borrowed",
			"action" => "Xác nhận",
			"borrowed_id" => $this->dataPost['id'],
			"old" => $fileReturn,
			"new" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_borrowed_model->insert($log);

		$check_area = $this->store_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($fileReturn['stores'])));
		if ($check_area['code_area'] == "Priority" ||$check_area['code_area'] == "KV_HN1" || $check_area['code_area'] == "KV_HN2" || $check_area['code_area'] == "KV_QN" || $check_area['code_area'] == "KV_MT1" || $check_area['code_area'] == "KV_BTB") {
			$user = $this->quan_ly_ho_so_mb();
		} else if ($check_area['code_area'] == "KV_MK") {
			$user = $this->quan_ly_ho_so_mekong();
		} else {
			$user = $this->quan_ly_ho_so_mn();
		}
		$fileReturn['status'] = "7";
		$this->sendEmailApprove_borrowed($fileReturn, $user);

		if (!empty($user)) {
			foreach (array_unique($user) as $re) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id'],
					'action' => 'FileReturn_cancel',
					'note' => 'Đang mượn hồ sơ',
					'user_id' => $re,
					'status' => 1, //1: new, 2 : read, 3: block,
					'borrowed_status' => 7,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}

		unset($this->dataPost['id']);

		$this->borrowed_model->update(array("_id" => $fileReturn['_id']), ["status" => "7", "ghichu" => $this->dataPost['ghichu'], "file_img_approve" => $this->dataPost['file_img_approve']]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "success"

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function borrowed_trahskhachhangtattoan_post(){

		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);
		$this->dataPost['ghichu'] = $this->security->xss_clean($this->dataPost['ghichu']);
		$this->dataPost['file_img_approve'] = $this->security->xss_clean($this->dataPost['file_img_approve']);

		//Validate
		if (empty($this->dataPost['ghichu'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Ghi chú không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		if (empty($this->dataPost['file_img_approve'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Ảnh hồ sơ không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

		$fileReturn = $this->borrowed_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])));
		$this->dataPost['status'] = "13";
		$log = array(
			"type" => "borrowed",
			"action" => "Xác nhận",
			"borrowed_id" => $this->dataPost['id'],
			"old" => $fileReturn,
			"new" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_borrowed_model->insert($log);

		$check_area = $this->store_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($fileReturn['stores'])));
		if ($check_area['code_area'] == "Priority" ||$check_area['code_area'] == "KV_HN1" || $check_area['code_area'] == "KV_HN2" || $check_area['code_area'] == "KV_QN" || $check_area['code_area'] == "KV_MT1" || $check_area['code_area'] == "KV_BTB") {
			$user = $this->quan_ly_ho_so_mb();
		} else if ($check_area['code_area'] == "KV_MK") {
			$user = $this->quan_ly_ho_so_mekong();
		} else {
			$user = $this->quan_ly_ho_so_mn();
		}
		$fileReturn['status'] = "13";
		$this->sendEmailApprove_borrowed($fileReturn, $user);

		if (!empty($user)) {
			foreach (array_unique($user) as $re) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id'],
					'action' => 'FileReturn_cancel',
					'note' => 'Trả HS khách hàng tất toán',
					'user_id' => $re,
					'status' => 1, //1: new, 2 : read, 3: block,
					'borrowed_status' => 13,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}

		unset($this->dataPost['id']);

		$this->borrowed_model->update(array("_id" => $fileReturn['_id']), ["status" => "13", "ghichu" => $this->dataPost['ghichu'], "file_img_approve" => $this->dataPost['file_img_approve']]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "success"

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function borrowed_giahanthoigianmuon_post(){

		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);
		$this->dataPost['ghichu'] = $this->security->xss_clean($this->dataPost['ghichu']);
		$this->dataPost['file_img_approve'] = $this->security->xss_clean($this->dataPost['file_img_approve']);
		$this->dataPost['update_time_borrowed'] = $this->security->xss_clean($this->dataPost['update_time_borrowed']);
		$this->dataPost['created_at'] = $this->createdAt;

		//Validate
		if (empty($this->dataPost['update_time_borrowed'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Thời gian gia hạn không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

		$time_borrowed_end = $this->borrowed_model->find_one_select(["_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])],[]);

		$days = $this->check_day_extend_borrowed($this->dataPost['update_time_borrowed'], $time_borrowed_end['borrowed_end']);

		if ($days >= 15){
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Thời gian gia hạn mượn không quá 15 ngày"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

		if (empty($this->dataPost['ghichu'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Lý do mượn không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		if (empty($this->dataPost['file_img_approve'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Ảnh hồ sơ không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

		$log = array(
			"type" => "borrowed",
			"action" => "Xác nhận",
			"borrowed_id" => $this->dataPost['id'],
			"old" => ['status' => "12"],
			"new" => ['status' => "15",'ghichu' => $this->dataPost['ghichu'],'fileApprove_img' => $this->dataPost['file_img_approve']],
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_borrowed_model->insert($log);

		$check_area = $this->store_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($time_borrowed_end['stores'])));
		if ($check_area['code_area'] == "Priority" ||$check_area['code_area'] == "KV_HN1" || $check_area['code_area'] == "KV_HN2" || $check_area['code_area'] == "KV_QN" || $check_area['code_area'] == "KV_MT1" || $check_area['code_area'] == "KV_BTB") {
			$user = $this->quan_ly_ho_so_mb();
		} else if ($check_area['code_area'] == "KV_MK") {
			$user = $this->quan_ly_ho_so_mekong();
		} else {
			$user = $this->quan_ly_ho_so_mn();
		}
		$time_borrowed_end['status'] = "15";
		$this->sendEmailApprove_borrowed($time_borrowed_end, $user);

		if (!empty($user)) {
			foreach (array_unique($user) as $re) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id'],
					'action' => 'Gia hạn mượn hồ sơ',
					'note' => 'Yêu cầu gia hạn mượn hồ sơ',
					'user_id' => $re,
					'status' => 1, //1: new, 2 : read, 3: block,
					'borrowed_status' => 15,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}

		$this->dataPost['borrowed_id'] = $this->dataPost['id'];
		$this->extend_borrowed_model->insert($this->dataPost);
		$this->borrowed_model->update(array("_id" => $time_borrowed_end['_id']), ["status" => "15"]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "success"

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}



	public function borrowed_xacnhankhdatattoan_post(){

		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);
		$this->dataPost['ghichu'] = $this->security->xss_clean($this->dataPost['ghichu']);
		$this->dataPost['file_img_approve'] = $this->security->xss_clean($this->dataPost['file_img_approve']);
		//V2
		$this->dataPost['thoa_thuan_ba_ben'] = $this->security->xss_clean($this->dataPost['thoa_thuan_ba_ben']);
		$this->dataPost['bbbg_tai_san'] = $this->security->xss_clean($this->dataPost['bbbg_tai_san']);
		$this->dataPost['dang_ky_xe'] = $this->security->xss_clean($this->dataPost['dang_ky_xe']);
		$this->dataPost['thong_bao'] = $this->security->xss_clean($this->dataPost['thong_bao']);
		$this->dataPost['hd_mua_ban_xe'] = $this->security->xss_clean($this->dataPost['hd_mua_ban_xe']);
		$this->dataPost['cam_ket'] = $this->security->xss_clean($this->dataPost['cam_ket']);
		$this->dataPost['bbbg_thiet_bi_dinh_vi'] = $this->security->xss_clean($this->dataPost['bbbg_thiet_bi_dinh_vi']);
		$this->dataPost['bbh_hoi_dong_co_dong'] = $this->security->xss_clean($this->dataPost['bbh_hoi_dong_co_dong']);
		$this->dataPost['hop_dong_mua_ban'] = $this->security->xss_clean($this->dataPost['hop_dong_mua_ban']);
		$this->dataPost['hd_uy_quyen'] = $this->security->xss_clean($this->dataPost['hd_uy_quyen']);
		$this->dataPost['hd_chuyen_nhuong'] = $this->security->xss_clean($this->dataPost['hd_chuyen_nhuong']);
		$this->dataPost['so_do'] = $this->security->xss_clean($this->dataPost['so_do']);
		$this->dataPost['hd_dat_coc'] = $this->security->xss_clean($this->dataPost['hd_dat_coc']);
		$this->dataPost['phu_luc_gia_han'] = $this->security->xss_clean($this->dataPost['phu_luc_gia_han']);
		$fileReturn = $this->borrowed_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])));
		$this->dataPost['status'] = "14";

		$fileReturn_log = $this->file_manager_model->find_where(array("code_contract_disbursement_text" => $fileReturn['code_contract_disbursement_text']));

		//KH đã tất toán
		if (!empty($fileReturn_log)){
			$array_update = [
				"status" => "11",
				"records_return.thoa_thuan_ba_ben.text" => 'Thỏa thuận 3 bên',
				"records_return.thoa_thuan_ba_ben.quantity" => (int)$this->dataPost['thoa_thuan_ba_ben'],
				"records_return.thoa_thuan_ba_ben.slug" => 'thoa-thuan-3-ben',
				"records_return.bbbg_tai_san.text" => 'Biên bản bàn giao Tài sản',
				"records_return.bbbg_tai_san.quantity" => (int)$this->dataPost['bbbg_tai_san'],
				"records_return.bbbg_tai_san.slug" => 'bien-ban-ban-giao-tai-san',
				"records_return.dang_ky_xe.text" => 'Đăng ký / Cà vẹt xe',
				"records_return.dang_ky_xe.quantity" => (int)$this->dataPost['dang_ky_xe'],
				"records_return.dang_ky_xe.slug" => 'dang-ky-xe',
				"records_return.thong_bao.text" => 'Thông báo',
				"records_return.thong_bao.quantity" => (int)$this->dataPost['thong_bao'],
				"records_return.thong_bao.slug" => 'thong-bao',
				"records_return.hd_mua_ban_xe.text" => 'Hợp đồng mua bán xe',
				"records_return.hd_mua_ban_xe.quantity" => (int)$this->dataPost['hd_mua_ban_xe'],
				"records_return.hd_mua_ban_xe.slug" => 'hop-dong-mua-ban-xe',
				"records_return.cam_ket.text" => 'Cam kết',
				"records_return.cam_ket.quantity" => (int)$this->dataPost['cam_ket'],
				"records_return.cam_ket.slug" => 'cam-ket',
				"records_return.bbbg_thiet_bi_dinh_vi.text" => 'BBBG thiết bị định vị',
				"records_return.bbbg_thiet_bi_dinh_vi.quantity" => (int)$this->dataPost['bbbg_thiet_bi_dinh_vi'],
				"records_return.bbbg_thiet_bi_dinh_vi.slug" => 'bbbg-thiet-bi-dinh-vi',
				"records_return.bbh_hoi_dong_co_dong.text" => 'BB họp hội đồng cổ đông',
				"records_return.bbh_hoi_dong_co_dong.quantity" => (int)$this->dataPost['bbh_hoi_dong_co_dong'],
				"records_return.bbh_hoi_dong_co_dong.slug" => 'bb-hop-hoi-dong-co-dong',
				"records_return.hop_dong_mua_ban.text" => 'Hợp đồng mua bán',
				"records_return.hop_dong_mua_ban.quantity" => (int)$this->dataPost['hop_dong_mua_ban'],
				"records_return.hop_dong_mua_ban.slug" => 'hop-dong-mua-ban',
				"records_return.hd_uy_quyen.text" => 'Hợp đồng ủy quyền',
				"records_return.hd_uy_quyen.quantity" => (int)$this->dataPost['hd_uy_quyen'],
				"records_return.hd_uy_quyen.slug" => 'hop-dong-uy-quyen',
				"records_return.hd_chuyen_nhuong.text" => 'Hợp đồng chuyển nhượng',
				"records_return.hd_chuyen_nhuong.quantity" => (int)$this->dataPost['hd_chuyen_nhuong'],
				"records_return.hd_chuyen_nhuong.slug" => 'hop-dong-chuyen-nhuong',
				"records_return.so_do.text" => 'Sổ đỏ / Giấy CNQSDĐ',
				"records_return.so_do.quantity" => (int)$this->dataPost['so_do'],
				"records_return.so_do.slug" => 'so-do',
				"records_return.hd_dat_coc.text" => 'Hợp đồng đặt cọc',
				"records_return.hd_dat_coc.quantity" => (int)$this->dataPost['hd_dat_coc'],
				"records_return.hd_dat_coc.slug" => 'hop-dong-dat-coc',
				"records_return.phu_luc_gia_han.text" => 'Phụ lục gia hạn',
				"records_return.phu_luc_gia_han.quantity" => (int)$this->dataPost['phu_luc_gia_han'],
				"records_return.phu_luc_gia_han.slug" => 'phu-luc-gia-han',
				"ghichu" => "(QLHS xác nhận KH đã tất toán)",
				"updated_rcrt_at" => $this->createdAt,
				"updated_rcrt_by" => $this->uemail
			];
			if (isset($fileReturn_log[0]['is_dkx_origin']) && $fileReturn_log[0]['is_dkx_origin'] == true && $this->dataPost['dang_ky_xe'] > 0) {
				$array_update['status_dkx'] = 2;//1: Lưu kho, 2: Đã trả, 3: Lưu ở hợp đồng khác, 4: Không có ĐKX
				$this->dataPost['status_dkx'] = 2;
			} else {
				$array_update['status_dkx'] = 4;
				$this->dataPost['status_dkx'] = 4;
			}

			$this->file_manager_model->update(array("_id" => new MongoDB\BSON\ObjectId((string)$fileReturn_log[0]['_id'])), $array_update);
			$log_tt = array(
				"type" => "fileReturn",
				"action" => "Xác nhận",
				"fileReturn_id" => (string)$fileReturn_log[0]['_id'],
				"old" => $fileReturn_log[0],
				"new" => $this->dataPost,
				"created_at" => $this->createdAt,
				"created_by" => $this->uemail
			);
			$this->log_fileManager_model->insert($log_tt);
		}


		$log = array(
			"type" => "borrowed",
			"action" => "Xác nhận",
			"borrowed_id" => $this->dataPost['id'],
			"old" => $fileReturn,
			"new" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_borrowed_model->insert($log);

		$user = array($fileReturn['created_by']['id']);
		$fileReturn['status'] = "14";
		$this->sendEmailApprove_borrowed($fileReturn, $user);

		if (!empty($user)) {
			foreach (array_unique($user) as $re) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id'],
					'action' => 'FileReturn_cancel',
					'note' => 'Xác nhận khách hàng đã tất toán',
					'user_id' => $re,
					'status' => 1, //1: new, 2 : read, 3: block,
					'borrowed_status' => 14,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}

		unset($this->dataPost['id']);

		$this->borrowed_model->update(array("_id" => $fileReturn['_id']), ["status" => "14", "ghichu" => $this->dataPost['ghichu'], "file_img_approve" => $this->dataPost['file_img_approve']]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "success"

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;


	}


	public function return_borrowed_post()
	{
		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);

		$this->dataPost['ghichu'] = $this->security->xss_clean($this->dataPost['ghichu']);
		$this->dataPost['fileReturn_img'] = $this->security->xss_clean($this->dataPost['fileReturn_img']);

		//Validate
		if (empty($this->dataPost['ghichu'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Ghi chú không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		if (empty($this->dataPost['fileReturn_img'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Ảnh hồ sơ không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

		$check_fileReturn = $this->borrowed_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])));

		$this->dataPost['updated_at'] = $this->createdAt;
		$this->dataPost['status'] = "8";
		$log = array(
			"type" => "borrowed",
			"action" => "Chưa nhận đủ hồ sơ",
			"borrowed_id" => $this->dataPost['id'],
			"old" => $check_fileReturn,
			"new" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);

		$this->log_borrowed_model->insert($log);

		$check_area = $this->store_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($check_fileReturn['stores'])));
		if ($check_area['code_area'] == "Priority" ||$check_area['code_area'] == "KV_HN1" || $check_area['code_area'] == "KV_HN2" || $check_area['code_area'] == "KV_QN" || $check_area['code_area'] == "KV_MT1" || $check_area['code_area'] == "KV_BTB") {
			$user = $this->quan_ly_ho_so_mb();
		} else if ($check_area['code_area'] == "KV_MK") {
			$user = $this->quan_ly_ho_so_mekong();
		} else {
			$user = $this->quan_ly_ho_so_mn();
		}
		$check_fileReturn['status'] = "8";
		$this->sendEmailApprove_borrowed($check_fileReturn, $user);

		if (!empty($user)) {
			foreach (array_unique($user) as $re) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id'],
					'action' => 'FileReturn_cancel',
					'note' => 'Chưa nhận đủ HS mượn',
					'user_id' => $re,
					'status' => 1, //1: new, 2 : read, 3: block,
					'borrowed_status' => 8,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}

		unset($this->dataPost['id']);

		$this->borrowed_model->update(array("_id" => $check_fileReturn['_id']), ["status" => "8", "ghichu" => $this->dataPost['ghichu'], "fileReturn_img" => $this->dataPost['fileReturn_img']]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Success"
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function borrowed_trahsdamuon_post()
	{

		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);
		$this->dataPost['ghichu'] = $this->security->xss_clean($this->dataPost['ghichu']);
		$this->dataPost['file_img_approve'] = $this->security->xss_clean($this->dataPost['file_img_approve']);

		$fileReturn = $this->borrowed_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])));
		$this->dataPost['status'] = "9";
		$log = array(
			"type" => "borrowed",
			"action" => "Xác nhận",
			"borrowed_id" => $this->dataPost['id'],
			"old" => $fileReturn,
			"new" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_borrowed_model->insert($log);

		$check_area = $this->store_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($fileReturn['stores'])));
		if ($check_area['code_area'] == "Priority" ||$check_area['code_area'] == "KV_HN1" || $check_area['code_area'] == "KV_HN2" || $check_area['code_area'] == "KV_QN" || $check_area['code_area'] == "KV_MT1" || $check_area['code_area'] == "KV_BTB") {
			$user = $this->quan_ly_ho_so_mb();
		} else if ($check_area['code_area'] == "KV_MK") {
			$user = $this->quan_ly_ho_so_mekong();
		} else {
			$user = $this->quan_ly_ho_so_mn();
		}
		$fileReturn['status'] = "9";
		$this->sendEmailApprove_borrowed($fileReturn, $user);

		if (!empty($user)) {
			foreach (array_unique($user) as $re) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id'],
					'action' => 'FileReturn_cancel',
					'note' => 'Trả HS mượn về HO',
					'user_id' => $re,
					'status' => 1, //1: new, 2 : read, 3: block,
					'borrowed_status' => 9,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}

		unset($this->dataPost['id']);

		$this->borrowed_model->update(array("_id" => $fileReturn['_id']), ["status" => "9", "ghichu" => $this->dataPost['ghichu'], "file_img_approve" => $this->dataPost['file_img_approve']]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "success"

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function borrowed_luukho_post()
	{

		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);
		$this->dataPost['ghichu'] = $this->security->xss_clean($this->dataPost['ghichu']);
		$this->dataPost['file_img_approve'] = $this->security->xss_clean($this->dataPost['file_img_approve']);

		$fileReturn = $this->borrowed_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])));
		$this->dataPost['status'] = "10";
		$log = array(
			"type" => "borrowed",
			"action" => "Xác nhận",
			"borrowed_id" => $this->dataPost['id'],
			"old" => $fileReturn,
			"new" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_borrowed_model->insert($log);

		$user = array($fileReturn['created_by']['id']);
		$fileReturn['status'] = "10";
		$this->sendEmailApprove_borrowed($fileReturn, $user);

		if (!empty($user)) {
			foreach (array_unique($user) as $re) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id'],
					'action' => 'FileReturn_cancel',
					'note' => 'Lưu kho',
					'user_id' => $re,
					'status' => 1, //1: new, 2 : read, 3: block,
					'borrowed_status' => 10,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}

		unset($this->dataPost['id']);

		$this->borrowed_model->update(array("_id" => $fileReturn['_id']), ["status" => "10", "ghichu" => $this->dataPost['ghichu'], "file_img_approve" => $this->dataPost['file_img_approve']]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "success"

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function chua_tra_hs_da_muon_post()
	{

		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);

		$this->dataPost['ghichu'] = $this->security->xss_clean($this->dataPost['ghichu']);
		$this->dataPost['fileReturn_qlhs_img'] = $this->security->xss_clean($this->dataPost['fileReturn_qlhs_img']);

		//Validate
		if (empty($this->dataPost['ghichu'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Ghi chú không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		if (empty($this->dataPost['fileReturn_qlhs_img'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Ảnh hồ sơ không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

		$check_fileReturn = $this->borrowed_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])));

		$this->dataPost['updated_at'] = $this->createdAt;
		$this->dataPost['status'] = "11";
		$log = array(
			"type" => "borrowed",
			"action" => "Chưa nhận đủ hồ sơ trả",
			"borrowed_id" => $this->dataPost['id'],
			"old" => $check_fileReturn,
			"new" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);

		$this->log_borrowed_model->insert($log);

		$user = array($check_fileReturn['created_by']['id']);
		$check_fileReturn['status'] = "11";
		$this->sendEmailApprove_borrowed($check_fileReturn, $user);

		if (!empty($user)) {
			foreach (array_unique($user) as $re) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id'],
					'action' => 'FileReturn_cancel',
					'note' => 'Chưa trả đủ HS đã mượn',
					'user_id' => $re,
					'status' => 1, //1: new, 2 : read, 3: block,
					'borrowed_status' => 11,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}

		unset($this->dataPost['id']);

		$this->borrowed_model->update(array("_id" => $check_fileReturn['_id']), ["status" => "11", "ghichu" => $this->dataPost['ghichu'], "fileReturn_qlhs_img" => $this->dataPost['fileReturn_qlhs_img']]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Success"
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;


	}

	public function sendEmail($dataPost)
	{
		$email_template = $this->email_template_model->findOne(array('code' => $dataPost['code'], 'status' => 'active'));

		$domain = $this->config->item('sendgrid_domain');
		// var_dump($email_template); die;

		$from = 'support@tienngay.vn';
		$from_name = $email_template['from_name'];
		$subject = $email_template['subject'];
		$message = $this->getEmailStr($email_template['message'], $dataPost);
		$status = 'active';
		$data = array(
			"code" => $dataPost['code'],
			"from" => $from,
			"from_name" => $from_name,
			"to" => $dataPost['email'],
			"subject" => $subject,
			"email_domain" => $domain,
			"status" => $status,
			"message" => $message,
//			"device" => $this->agent->browser() . ';' . $this->agent->platform(),
//			"ipaddress" => getIpAddress(),
			"created_at" => (int)$this->createdAt
		);

		//var_dump('expression');

		$this->email_history_model->insert($data);
		return;


	}

	public function send($from, $to, $subject, $message, $from_name)
	{

		$email = new \SendGrid\Mail\Mail();
		$email->setFrom($from, $from_name);
		$email->setSubject($subject);
		$email->addTo($to, "");
		$email->addContent(
			"text/html", $message
		);
		$sendgrid = new \SendGrid($this->config->item('sendgrid_api_key'));
		try {
			$response = $sendgrid->send($email);
			// print $response->statusCode() . "\n";
			//    print_r($response->headers());
			//    print $response->body() . "\n";
			if ($response->statusCode() == '202') {
				return true;
			} else {
				return false;
			}
		} catch (Exception $e) {
			return false;
		}


	}

	public function getGroupRole_hcns()
	{
		$groupRoles = $this->group_role_model->find_where(array("status" => "active", 'slug' => 'quan-ly-ho-so'));

		$arr = array();
		foreach ($groupRoles as $groupRole) {
			if (!empty($groupRole['users'])) {

				foreach ($groupRole['users'] as $value) {
					foreach ($value as $key => $item) {
						array_push($arr, $key);
					}

				}
			}
		}
		return $arr;
	}

	public function getEmailStr($emailTemplate, $filter)
	{
		foreach ($filter as $key => $value) {
			$emailTemplate = str_replace("{" . $key . "}", $value, $emailTemplate);
		}
		return $emailTemplate;
	}

	public function check_file_post()
	{
		$this->dataPost['code_contract_disbursement'] = $this->security->xss_clean($this->dataPost['code_contract_disbursement']);
		$records_borrowed = $this->borrowed_model->find_where(array("code_contract_disbursement_text" => $this->dataPost['code_contract_disbursement'], 'status' => ['$in' => ['6','7','8','9','11','12','13','15','17']]));
		$file_borrowing = [];
		$data = [];
		if (!empty($records_borrowed)){
			foreach ($records_borrowed as $value){
				foreach ($value['file'] as $item){
					array_push($file_borrowing, $item);
				}
			}
			$records_borrowed[0]['file'] = $file_borrowing;
			$records_borrowed = $records_borrowed[0];
		}
		if (empty($records_borrowed)) {
			return;
		}
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Success",
			"data" => $records_borrowed
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}


	public function cron_update_hopdongtra_qlhs_post()
	{
		$condition = [];

		$start = strtotime('-15 day', strtotime(date('Y-m-d', (int)$this->createdAt)));

		$start1 = date('Y-m-d', $start);

		if (!empty($start1)) {
			$condition = array(
				'start' => strtotime(trim($start1)),

			);
		}

//		$contractData = $this->contract_model->find_where_mhd_cron($condition,$limit=10,$offset = 0);
		$contractData = $this->contract_model->find_where_mhd_cron($condition);

		if (!empty($contractData)) {
			foreach ($contractData as $value) {
				$data = [];
				$check_contract = $this->file_manager_model->findOne(["code_contract_disbursement_text" => $value['code_contract_disbursement']]);
				if (empty($check_contract)) {

					$check_area = $this->store_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($value['store']->id)));


					if ($check_area['code_area'] == "KV_HN1" || $check_area['code_area'] == "KV_HN2" || $check_area['code_area'] == "KV_QN" || $check_area['code_area'] == "KV_MT1") {
						$area = "MB";
					} else if ($check_area['code_area'] == "KV_MK") {
						$area = "MK";
					} else {
						$area = "MN";
					}

					$data = [
						"code_contract_disbursement_text" => $value['code_contract_disbursement'],
						"file" => [
							"Thỏa thuận 3 bên",
							"Văn bản bàn giao tài sản",
							"Thông báo",
							"Đăng ký xe/Cà vẹt",
							"Hợp đồng mua bán",
							"Đăng kiểm",
							"Giấy cam kết",
							"Ủy quyền",
							"Chìa khóa",
							"Sổ đỏ"
						],
						"giay_to_khac" => "",
						"taisandikem" => "",
						"ghichu" => "",
						"fileReturn_img" => "",
						"stores" => $value['store']->id,
						"area" => $area,
						"file_img_approve" => "",
						"fileReturn_img_v2" => "",
						"created_at" => $this->createdAt,
						"status" => "6",
						"created_by" => "cron_admin"
					];
					$this->file_manager_model->insert($data);
				}

			}
		}
		echo "okei";

	}

	public function cron_store_file_manager_post(){
		//Cập nhật store hồ sơ
		$list_file = $this->file_manager_model->find();

		if (!empty($list_file)) {

			foreach ($list_file as $value) {

				if (!empty($value['code_contract_disbursement_text'])){

					$check_store_new = $this->contract_model->findOne_storeId(['code_contract_disbursement'=> $value['code_contract_disbursement_text']]);

					if (!empty($check_store_new['store']['id'])){

						$this->file_manager_model->update(["_id" => new MongoDB\BSON\ObjectId((string)$value['_id'])], ['stores' => $check_store_new['store']['id']]);

						//Mekong -- 5f87c5acd6612bd45a08fc62(308 Đường 30/4) -- 5f6ac65cd6612b2e6c4a7db3(1797 Trần Hưng Đạo) -- 5f6ac5acd6612b295d77fd54(63 Đường 26 tháng 3)
//						if ($check_store_new['store']['id'] == "5f87c5acd6612bd45a08fc62" || $check_store_new['store']['id'] == "5f6ac65cd6612b2e6c4a7db3" || $check_store_new['store']['id'] == "5f6ac5acd6612b295d77fd54"){
//							$this->file_manager_model->update(["_id" => new MongoDB\BSON\ObjectId((string)$value['_id'])], ['area' => "MK"]);
//						}
						//Direct Sale BD -- 6176264c9bf0aa68cd55c404
						if ($check_store_new['store']['id'] == "61945bd9b5987f1710347a65"){
							$this->file_manager_model->update(["_id" => new MongoDB\BSON\ObjectId((string)$value['_id'])], ['area' => "MB"]);
						}
					}
				}

			}
		}
		echo "cron_ok";
	}

	public function cron_store_borrowed_post(){
		//Cập nhật store mượn/trả hồ sơ
		$list_borrowed = $this->borrowed_model->find();

		if (!empty($list_borrowed)){

			foreach ($list_borrowed as $value){

				$check_store_new = $this->contract_model->findOne_storeId(['code_contract_disbursement'=> $value['code_contract_disbursement_text']]);

				if (!empty($check_store_new['store']['id'])){

					$this->borrowed_model->update(["_id" => new MongoDB\BSON\ObjectId((string)$value['_id'])], ['stores' => $check_store_new['store']['id']]);

				}
			}
		}
		echo "cron_ok";
	}

	public function get_store_status_active_new_post(){
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;

		$i = 0;
		if (in_array($this->id, $this->quan_ly_ho_so_mb())) {
			$condition['area'] = "MB";
			++$i;
			$condition['increase'] = $i;
		}
		if (in_array($this->id, $this->quan_ly_ho_so_mn())) {
			$condition['area'] = "MN";
			++$i;
			$condition['increase'] = $i;
		}
		if (in_array($this->id, $this->quan_ly_ho_so_mekong())) {
			$condition['area'] = "MK";
			++$i;
			$condition['increase'] = $i;
		}

		$store = $this->store_model->find_where_in_new($condition);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $store
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
	}

	private function getStores_list($userId)
	{
		$roles = $this->role_model->find_where(array("status" => "active"));
		$roleStores = array();
		if (count($roles) > 0) {
			foreach ($roles as $role) {
				if (!empty($role['users']) && count($role['users']) > 0) {
					$arrUsers = array();
					foreach ($role['users'] as $item) {
						array_push($arrUsers, key($item));
					}
					//Check userId in list key of $users
					if (in_array($userId, $arrUsers) == TRUE) {
						if (!empty($role['stores'])) {
							//Push store
							foreach ($role['stores'] as $key => $item) {
								array_push($roleStores,key($item));
							}
						}
					}
				}
			}
		}
		return $roleStores;
	}

	public function muontrahoso_excel_post(){
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;

		$this->dataPost = $this->input->post();
		$condition = [];

		$fdate = !empty($this->dataPost['fdate']) ? $this->dataPost['fdate'] : "";
		$tdate = !empty($this->dataPost['tdate']) ? $this->dataPost['tdate'] : "";
		$code_contract_disbursement_text = !empty($this->dataPost['code_contract_disbursement_search']) ? $this->dataPost['code_contract_disbursement_search'] : "";
		$status = !empty($this->dataPost['status']) ? $this->dataPost['status'] : "";
		$store = !empty($this->dataPost['store']) ? $this->dataPost['store'] : "";

		if (!empty($code_contract_disbursement_text)) {
			$condition['code_contract_disbursement_text'] = $code_contract_disbursement_text;
		}
		if (!empty($status)) {
			$condition['status'] = (string)$status;
		}
		if (!empty($store)) {
			$condition['store'] = $store;
		}
		if (!empty($fdate)) {
			$condition['fdate'] = strtotime(trim($fdate) . ' 00:00:00');
		}
		if (!empty($tdate)) {
			$condition['tdate'] = strtotime(trim($tdate) . ' 23:59:59');
		}

		$groupRoles = $this->getGroupRole($this->id);
		$id_user = (string)$this->id;

		$all = true;
		if (in_array('quan-ly-ho-so', $groupRoles) || in_array('quan-ly-cap-cao', $groupRoles)) {
			$all = false;
		}


		if (in_array('cua-hang-truong', $groupRoles) || in_array('quan-ly-khu-vuc', $groupRoles)) {

			$stores_list = $this->getStores_list($this->id);
			$condition['stores_list'] = $stores_list;
			$condition['groupRoles_store'] = "Cửa hàng trưởng";

		} elseif (in_array('quan-ly-ho-so', $groupRoles)){

			$stores_list = $this->getStores_list($this->id);
			$condition['stores_list'] = $stores_list;

		} elseif (in_array('thu-hoi-no', $groupRoles)) {
			$list_qlkv_mb = $this->role_model->get_list_all_id_nv_qlkv_mb();
			$list_qlkv_mn = $this->role_model->get_list_all_id_nv_qlkv_mn();
			$condition['created_by'] = $this->uemail;
			if (in_array($id_user, $list_qlkv_mb)) {
				$condition['domain_borrow'] = "MB";
			} elseif (in_array($id_user, $list_qlkv_mn)) {
				$condition['domain_borrow'] = "MN";
			}
		} else {
			$condition['created_by'] = $this->uemail;
		}

		$borrowed = $this->borrowed_model->getDataByRole_excel($condition);

		if (empty($borrowed)) {
			return;
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $borrowed
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;



	}


	public function get_all_contract_luukho_post(){

		$stores = $this->getStores_list($this->id);

		$contractData = $this->file_manager_model->find_where_select(['status' => '6', 'stores' => ['$in' => $stores]], ['code_contract_disbursement_text']);

		if (empty($contractData)){
			return;
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $contractData
		);
		$this->set_response($response, REST_Controller::HTTP_OK);


	}

	public function process_create_borrow_travel_paper_post(){

		$this->dataPost['code_contract_disbursement_value'] = $this->security->xss_clean($this->dataPost['code_contract_disbursement_value']);
		$this->dataPost['fileReturn'] = $this->security->xss_clean($this->dataPost['fileReturn']);

		//Validate
		if (empty($this->dataPost['code_contract_disbursement_value'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Mã hợp đồng không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}


		$storeData = $this->contract_model->find_one_select(['code_contract_disbursement' => $this->dataPost['code_contract_disbursement_value']],['store','customer_infor.customer_name']);

		if (!empty($storeData)){
			$this->dataPost['store'] = $storeData;
			$this->dataPost['customer_name'] = $storeData['customer_infor']['customer_name'];

		}

		$user = $this->quan_ly_ho_so_mb();

		$this->dataPost['created_at'] = $this->createdAt;
		$this->dataPost['created_by'] = $this->uemail;
		$this->dataPost['user_id'] = $this->id;
		//1 - Yêu cầu mượn giấy đi đường, 2 - Xác nhận gửi giấy đi đường, 3 - Hủy
		$this->dataPost['status'] = 1;

		$check_borrow_paper = $this->borrow_paper_model->findOne(['code_contract_disbursement_value' => $this->dataPost['code_contract_disbursement_value'],'status' => ['$in' => [1,2]]]);
		// Lấy link file giay_di_duong.docx
		$link_file_docx = $this->create_travel_paper($this->dataPost['code_contract_disbursement_value']);
		if (empty($link_file_docx)) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Khởi tạo giấy đi đường thất bại!"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		} else {
			$this->dataPost['link_docx_file'] = $link_file_docx;
		}
		if (!empty($check_borrow_paper)) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Đã mượn giấy đi đường"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		} else {
			$id_borrow_paper = $this->borrow_paper_model->insertReturnId($this->dataPost);
		}

		$fileReturn = $this->borrow_paper_model->findOne(array("_id" => new MongoDB\BSON\ObjectId((string)$id_borrow_paper)));
		$this->sendEmailBorrow_qlhs($fileReturn, $user);

		if (!empty($user)) {
			foreach (array_unique($user) as $qlhs) {
				$data_approve = [
					'action_id' => (string)$id_borrow_paper,
					'action' => 'borrow_travel_paper',
					'note' => 'Gửi YC cấp giấy đi đường',
					'user_id' => (string)$qlhs,
					'status' => 1, //1: new, 2 : read, 3: block,
					'fileReturn_status' => 1,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Create new borrowed success"

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function get_all_borrow_paper_post(){

		$this->dataPost = $this->input->post();
		$condition = [];

		$fdate = !empty($this->dataPost['fdate']) ? $this->dataPost['fdate'] : "";
		$tdate = !empty($this->dataPost['tdate']) ? $this->dataPost['tdate'] : "";
		$code_contract_disbursement_text = !empty($this->dataPost['code_contract_disbursement_search']) ? $this->dataPost['code_contract_disbursement_search'] : "";
		$status = !empty($this->dataPost['status']) ? $this->dataPost['status'] : "";
		$store = !empty($this->dataPost['store']) ? $this->dataPost['store'] : "";

		if (!empty($code_contract_disbursement_text)) {
			$condition['code_contract_disbursement_text'] = $code_contract_disbursement_text;
		}
		if (!empty($status)) {
			$condition['status'] = (string)$status;
		}
		if (!empty($store)) {
			$condition['store'] = $store;
		}
		if (!empty($fdate)) {
			$condition['fdate'] = strtotime(trim($fdate) . ' 00:00:00');
		}
		if (!empty($tdate)) {
			$condition['tdate'] = strtotime(trim($tdate) . ' 23:59:59');
		}

		$groupRoles = $this->getGroupRole($this->id);
		$stores_list = $this->getStores_list($this->id);

		if (in_array('giao-dich-vien', $groupRoles)) {
			$condition['stores_list'] = $stores_list;
		}

		if (in_array('cua-hang-truong', $groupRoles)) {
			$condition['stores_list'] = $stores_list;
		}

		$per_page = !empty($this->dataPost['per_page']) ? $this->dataPost['per_page'] : 30;
		$uriSegment = !empty($this->dataPost['uriSegment']) ? $this->dataPost['uriSegment'] : 0;

		$borrowed = $this->borrow_paper_model->getDataByRole($condition, $per_page, $uriSegment);

		if (empty($borrowed)) {
			return;
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $borrowed
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;



	}

	public function get_count_borrow_paper_post(){
		$this->dataPost = $this->input->post();
		$condition = [];

		$fdate = !empty($this->dataPost['fdate']) ? $this->dataPost['fdate'] : "";
		$tdate = !empty($this->dataPost['tdate']) ? $this->dataPost['tdate'] : "";
		$code_contract_disbursement_text = !empty($this->dataPost['code_contract_disbursement_search']) ? $this->dataPost['code_contract_disbursement_search'] : "";
		$status = !empty($this->dataPost['status']) ? $this->dataPost['status'] : "";
		$store = !empty($this->dataPost['store']) ? $this->dataPost['store'] : "";

		if (!empty($code_contract_disbursement_text)) {
			$condition['code_contract_disbursement_text'] = $code_contract_disbursement_text;
		}
		if (!empty($status)) {
			$condition['status'] = (string)$status;
		}
		if (!empty($store)) {
			$condition['store'] = $store;
		}
		if (!empty($fdate)) {
			$condition['fdate'] = strtotime(trim($fdate) . ' 00:00:00');
		}
		if (!empty($tdate)) {
			$condition['tdate'] = strtotime(trim($tdate) . ' 23:59:59');
		}

		$groupRoles = $this->getGroupRole($this->id);
		$stores_list = $this->getStores_list($this->id);

		if (in_array('giao-dich-vien', $groupRoles)) {
			$condition['stores_list'] = $stores_list;
		}

		if (in_array('cua-hang-truong', $groupRoles)) {
			$condition['stores_list'] = $stores_list;
		}

		$borrowed = $this->borrow_paper_model->getDataByRole_count($condition);

		if (empty($borrowed)) {
			return;
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $borrowed
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function approve_borrow_travel_paper_post(){

		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);

		$fileReturn = $this->borrow_paper_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])));

		$fileReturn['status'] = 2;
		$user = array((string)$fileReturn['user_id']);

		$this->sendEmailBorrow_qlhs($fileReturn, $user);


		if (!empty($user)) {
			foreach (array_unique($user) as $re) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id'],
					'action' => 'borrow_paper',
					'note' => 'Đã XN YC Mượn Giấy Đi Đường',
					'user_id' => $re,
					'status' => 1, //1: new, 2 : read, 3: block,
					'fileReturn_status' => 1,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}

		unset($this->dataPost['id']);

		$this->borrow_paper_model->update(array("_id" => $fileReturn['_id']), ["status" => 2]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Approve borrowed success"

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;


	}

	public function cancel_borrow_travel_paper_post(){

		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);
		$this->dataPost['note_return_paper'] = $this->security->xss_clean($this->dataPost['note_return_paper']);

		$fileReturn = $this->borrow_paper_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])));

		$fileReturn['status'] = 3;
		$user = array((string)$fileReturn['user_id']);

		$this->sendEmailBorrow_qlhs($fileReturn, $user);

		if (!empty($user)) {
			foreach (array_unique($user) as $re) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id'],
					'action' => 'borrow_paper',
					'note' => 'Hủy YC Mượn Giấy Đi Đường',
					'user_id' => $re,
					'status' => 1, //1: new, 2 : read, 3: block,
					'fileReturn_status' => 1,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}

		unset($this->dataPost['id']);

		$this->borrow_paper_model->update(array("_id" => $fileReturn['_id']), ["status" => 3, 'note' => $this->dataPost['note_return_paper']]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Approve borrowed success"

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function check_day_extend_borrowed($update_time_borrowed, $time_borrowed_end){
		$check_time = (strtotime($update_time_borrowed) - $time_borrowed_end);
		$years = floor($check_time / (365 * 60 * 60 * 24));
		$months = floor(($check_time - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
		$days = floor(($check_time - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

		return $days;
	}

	public function get_one_extend_borrowed_post(){

		$data = $this->input->post();

		$borrowed = $this->extend_borrowed_model->find_where_limit((string)$data["id"]);

		if (empty($borrowed)) return;

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $borrowed[0]
		);
		$this->set_response($response, REST_Controller::HTTP_OK);

	}

	public function approveExtendBorrowed_post(){

		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);
		$this->dataPost['update_time_borrowed_approve'] = $this->security->xss_clean($this->dataPost['update_time_borrowed_approve']);

		$borrowed = $this->borrowed_model->findOne(["_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])]);

		$log = array(
			"type" => "borrowed",
			"action" => "Xác nhận",
			"borrowed_id" => $this->dataPost['id'],
			"old" => $borrowed,
			"new" => ['status' => "7",'updated_at' => $this->createdAt,'borrowed_end' => strtotime($this->dataPost['update_time_borrowed_approve'])],
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);

		$this->log_borrowed_model->insert($log);

		$user = array($borrowed['created_by']['id']);
		$borrowed['status'] = "7";
		$this->sendEmailApprove_borrowed($borrowed, $user);

		if (!empty($user)) {
			foreach (array_unique($user) as $re) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id'],
					'action' => 'approveExtendBorrowed',
					'note' => 'Đang mượn hồ sơ',
					'user_id' => $re,
					'status' => 1, //1: new, 2 : read, 3: block,
					'borrowed_status' => 7,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}

		$this->borrowed_model->update(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])), ["status" => "7", 'borrowed_end' => strtotime($this->dataPost['update_time_borrowed_approve'])]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Success"
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;



	}


	/** Lấy 01 bản ghi hồ sơ GN trả về
	 * @param $id_records(string)
	 */
	public function get_one_records_return_post()
	{
		$dataPost = $this->input->post();
		$id_records = $this->security->xss_clean($dataPost['id_records']) ?? '';
		$records_return_db = $this->file_manager_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($id_records)]);
		if (empty($records_return_db)) {
			$response = [
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => 'Không tìm thấy hồ sơ || Hồ sơ không tồn tại!'
			];
			return $this->set_response($response, REST_Controller::HTTP_OK);
		}
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'data' => $records_return_db
		];
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}

	/** Lấy 01 bản ghi hồ sơ GN trả về
	 * @param $id_records(string)
	 */
	public function get_one_records_return_borrow_post()
	{
		$dataPost = $this->input->post();
		$code_contract_disbursement = $this->security->xss_clean($dataPost['code_contract_disbursement']) ?? '';
		$records_return_db = $this->file_manager_model->findOne(['code_contract_disbursement_text' => $code_contract_disbursement]);
		if (empty($records_return_db)) {
			$response = [
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => 'Không tìm thấy hồ sơ || Hồ sơ không tồn tại!'
			];
			return $this->set_response($response, REST_Controller::HTTP_OK);
		}
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'data' => $records_return_db
		];
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}


	/** Function update số lượng hồ sơ trong database
	 *
	 */
	public function update_quantity_records_post()
	{
		$this->dataPost['id_records'] = $this->security->xss_clean($this->dataPost['id_records']) ?? '';
		$this->dataPost['ghichu_qlhs'] = $this->security->xss_clean($this->dataPost['note_update']) ?? '';
		$this->dataPost['code_storage'] = $this->security->xss_clean($this->dataPost['code_storage']) ?? '';
		$this->dataPost['thoa_thuan_ba_ben'] = $this->security->xss_clean($this->dataPost['thoa_thuan_ba_ben']);
		$this->dataPost['bbbg_tai_san'] = $this->security->xss_clean($this->dataPost['bbbg_tai_san']);
		$this->dataPost['dang_ky_xe'] = $this->security->xss_clean($this->dataPost['dang_ky_xe']);
		$this->dataPost['thong_bao'] = $this->security->xss_clean($this->dataPost['thong_bao']);
		$this->dataPost['hd_mua_ban_xe'] = $this->security->xss_clean($this->dataPost['hd_mua_ban_xe']);
		$this->dataPost['cam_ket'] = $this->security->xss_clean($this->dataPost['cam_ket']);
		$this->dataPost['bbbg_thiet_bi_dinh_vi'] = $this->security->xss_clean($this->dataPost['bbbg_thiet_bi_dinh_vi']);
		$this->dataPost['bbh_hoi_dong_co_dong'] = $this->security->xss_clean($this->dataPost['bbh_hoi_dong_co_dong']);
		$this->dataPost['hop_dong_mua_ban'] = $this->security->xss_clean($this->dataPost['hop_dong_mua_ban']);
		$this->dataPost['hd_uy_quyen'] = $this->security->xss_clean($this->dataPost['hd_uy_quyen']);
		$this->dataPost['hd_chuyen_nhuong'] = $this->security->xss_clean($this->dataPost['hd_chuyen_nhuong']);
		$this->dataPost['so_do'] = $this->security->xss_clean($this->dataPost['so_do']);
		$this->dataPost['hd_dat_coc'] = $this->security->xss_clean($this->dataPost['hd_dat_coc']);
		$this->dataPost['phu_luc_gia_han'] = $this->security->xss_clean($this->dataPost['phu_luc_gia_han']);
		$records_db = $this->file_manager_model->find_one_select(['_id' => new \MongoDB\BSON\ObjectId($this->dataPost['id_records'])], ['_id']);
		if ($this->dataPost['dang_ky_xe'] > 0) {
			$is_dkx_origin = true;
			$status_dkx = 1; //1: Lưu kho, 2: Đã trả, 3: Lưu ở hợp đồng khác, 4: Không có ĐKX
		} elseif ($this->dataPost['dang_ky_xe'] == 0) {
			$is_dkx_origin = false;
			$status_dkx = 4;
		}
		if ($this->dataPost['so_do'] > 0) {
			$is_dkx_origin = true;
		}
		$array_update = [
			"ghichu_qlhs" => $this->dataPost['ghichu_qlhs'],
			"code_store_rc" => $this->dataPost['code_storage'],
			"records_receive.thoa_thuan_ba_ben.text" => 'Thỏa thuận 3 bên',
			"records_receive.thoa_thuan_ba_ben.quantity" => (int)$this->dataPost['thoa_thuan_ba_ben'],
			"records_receive.thoa_thuan_ba_ben.slug" => 'thoa-thuan-3-ben',
			"records_receive.bbbg_tai_san.text" => 'Biên bản bàn giao Tài sản',
			"records_receive.bbbg_tai_san.quantity" => (int)$this->dataPost['bbbg_tai_san'],
			"records_receive.bbbg_tai_san.slug" => 'bien-ban-ban-giao-tai-san',
			"records_receive.dang_ky_xe.text" => 'Đăng ký / Cà vẹt xe',
			"records_receive.dang_ky_xe.quantity" => (int)$this->dataPost['dang_ky_xe'],
			"records_receive.dang_ky_xe.slug" => 'dang-ky-xe',
			"records_receive.thong_bao.text" => 'Thông báo',
			"records_receive.thong_bao.quantity" => (int)$this->dataPost['thong_bao'],
			"records_receive.thong_bao.slug" => 'thong-bao',
			"records_receive.hd_mua_ban_xe.text" => 'Hợp đồng mua bán xe',
			"records_receive.hd_mua_ban_xe.quantity" => (int)$this->dataPost['hd_mua_ban_xe'],
			"records_receive.hd_mua_ban_xe.slug" => 'hop-dong-mua-ban-xe',
			"records_receive.cam_ket.text" => 'Cam kết',
			"records_receive.cam_ket.quantity" => (int)$this->dataPost['cam_ket'],
			"records_receive.cam_ket.slug" => 'cam-ket',
			"records_receive.bbbg_thiet_bi_dinh_vi.text" => 'BBBG thiết bị định vị',
			"records_receive.bbbg_thiet_bi_dinh_vi.quantity" => (int)$this->dataPost['bbbg_thiet_bi_dinh_vi'],
			"records_receive.bbbg_thiet_bi_dinh_vi.slug" => 'bbbg-thiet-bi-dinh-vi',
			"records_receive.bbh_hoi_dong_co_dong.text" => 'BB họp hội đồng cổ đông',
			"records_receive.bbh_hoi_dong_co_dong.quantity" => (int)$this->dataPost['bbh_hoi_dong_co_dong'],
			"records_receive.bbh_hoi_dong_co_dong.slug" => 'bb-hop-hoi-dong-co-dong',
			"records_receive.hop_dong_mua_ban.text" => 'Hợp đồng mua bán',
			"records_receive.hop_dong_mua_ban.quantity" => (int)$this->dataPost['hop_dong_mua_ban'],
			"records_receive.hop_dong_mua_ban.slug" => 'hop-dong-mua-ban',
			"records_receive.hd_uy_quyen.text" => 'Hợp đồng ủy quyền',
			"records_receive.hd_uy_quyen.quantity" => (int)$this->dataPost['hd_uy_quyen'],
			"records_receive.hd_uy_quyen.slug" => 'hop-dong-uy-quyen',
			"records_receive.hd_chuyen_nhuong.text" => 'Hợp đồng chuyển nhượng',
			"records_receive.hd_chuyen_nhuong.quantity" => (int)$this->dataPost['hd_chuyen_nhuong'],
			"records_receive.hd_chuyen_nhuong.slug" => 'hop-dong-chuyen-nhuong',
			"records_receive.so_do.text" => 'Sổ đỏ / Giấy CNQSDĐ',
			"records_receive.so_do.quantity" => (int)$this->dataPost['so_do'],
			"records_receive.so_do.slug" => 'so-do',
			"records_receive.hd_dat_coc.text" => 'Hợp đồng đặt cọc',
			"records_receive.hd_dat_coc.quantity" => (int)$this->dataPost['hd_dat_coc'],
			"records_receive.hd_dat_coc.slug" => 'hop-dong-dat-coc',
			"records_receive.phu_luc_gia_han.text" => 'Phụ lục gia hạn',
			"records_receive.phu_luc_gia_han.quantity" => (int)$this->dataPost['phu_luc_gia_han'],
			"records_receive.phu_luc_gia_han.slug" => 'phu-luc-gia-han',
			"is_dkx_origin" => $is_dkx_origin,
			"status_dkx" => $status_dkx,
			"updated_rcr_after_store_at" => $this->createdAt,
			"updated_rcr_after_store_by" => $this->uemail
		];
		//Insert log
		$log = array(
			"type" => "fileReturn",
			"action" => "update_quantity_records",
			"fileReturn_id" => $this->dataPost['id_records'],
			"old" => $records_db,
			"new" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_fileManager_model->insert($log);
		//Update DB
		$this->file_manager_model->update(['_id' => $records_db['_id']], $array_update);
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'Cập nhật hoàn thành!'
		];
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}

	public function get_all_contract_data_post()
	{
		// $flag = notify_token($this->flag_login);
		// if ($flag == false) return;
		$this->dataPost = $this->input->post();
		$condition = !empty($this->dataPost['condition']) ? $this->dataPost['condition'] : array();
		$start = !empty($this->dataPost['start']) ? $this->dataPost['start'] : "";
		$end = !empty($this->dataPost['end']) ? $this->dataPost['end'] : "";
		$property = !empty($this->dataPost['property']) ? $this->dataPost['property'] : "";
		$status = !empty($this->dataPost['status']) ? $this->dataPost['status'] : "";
		$customer_identify = !empty($this->dataPost['customer_identify']) ? $this->dataPost['customer_identify'] : "";
		$code_contract = !empty($this->dataPost['code_contract']) ? $this->dataPost['code_contract'] : "";
		$code_contract_disbursement = !empty($this->dataPost['code_contract_disbursement']) ? $this->dataPost['code_contract_disbursement'] : "";
		$ngaygiaingan = !empty($this->dataPost['ngaygiaingan']) ? $this->dataPost['ngaygiaingan'] : 1;
		$customer_name = !empty($this->dataPost['customer_name']) ? $this->dataPost['customer_name'] : "";
		$type_contract = !empty($this->dataPost['type_contract']) ? $this->dataPost['type_contract'] : "";
		$customer_phone_number = !empty($this->dataPost['customer_phone_number']) ? $this->dataPost['customer_phone_number'] : "";
		$type = !empty($this->dataPost['type_ct']) ? $this->dataPost['type_ct'] : "";
		$asset_name = !empty($this->dataPost['asset_name']) ? $this->dataPost['asset_name'] : "";
		$search_htv = !empty($this->dataPost['search_htv']) ? $this->dataPost['search_htv'] : "";
		$is_export = !empty($this->dataPost['is_export']) ? $this->dataPost['is_export'] : "";
		$search_status = !empty($this->dataPost['search_status']) ? $this->dataPost['search_status'] : "";
		$phone_number_relative = !empty($this->dataPost['phone_number_relative']) ? $this->dataPost['phone_number_relative'] : "";
		$fullname_relative = !empty($this->dataPost['fullname_relative']) ? $this->dataPost['fullname_relative'] : "";
		$type_contract_digital = !empty($this->dataPost['type_contract_digital']) ? $this->dataPost['type_contract_digital'] : "";
		$code_store = !empty($this->dataPost['code_store']) ? $this->dataPost['code_store'] : "";
		$region = !empty($this->dataPost['region']) ? $this->dataPost['region'] : "";
		if (!empty($region) && (count($code_store) < 1 || empty($code_store)) ) {
			$stores_id = $this->get_list_id_stores_by_region($region);
		}
		if (!empty($start) && !empty($end)) {
			$condition = array(
				'start' => strtotime(trim($start) . ' 00:00:00'),
				'end' => strtotime(trim($end) . ' 23:59:59')
			);
		}
		$groupRoles = $this->getGroupRole($this->id);
		$all = false;
		if (in_array('quan-ly-ho-so', $groupRoles)) {
			$all = true;
		} else if (in_array('giao-dich-vien', $groupRoles)) {
			$condition['created_by'] = $this->uemail;
		}
		if ($all) {
			$stores = $this->getStores($this->id);
			if (empty($stores)) {
				$response = array(
					'status' => REST_Controller::HTTP_OK,
					'data' => array()
				);
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			}
			$condition['stores'] = $stores;
		}
		if (!empty($code_store)) {
			$condition['stores'] = (is_array($code_store)) ? $code_store : [$code_store];
		}
		if (!empty($stores_id) && count($stores_id) > 1) {
			$condition['stores'] = (is_array($stores_id)) ? $stores_id : [$code_store];
		}
		if (!empty($search_status)) {
			$condition['search_status'] = $search_status;
		}

		if (!empty($asset_name)) {
			$condition['asset_name'] = $asset_name;
		}
		if (!empty($property)) {
			$condition['property'] = $property;
		}
		if (!empty($type)) {
			$condition['type'] = $type;
		}
		if (!empty($status)) {
			$condition['status'] = (int)$status;
		}
		if (!empty($customer_identify)) {
			$customer_identify = explode(",", (string)$customer_identify);
			$condition['customer_identify'] = $customer_identify;
		}
		if (!empty($code_contract)) {
			$condition['code_contract'] = $code_contract;
		}
		if (!empty($code_contract_disbursement)) {
			$condition['code_contract_disbursement'] = $code_contract_disbursement;
		}
		if (!empty($phone_number_relative)) {
			$condition['phone_number_relative'] = $phone_number_relative;
		}
		if (!empty($fullname_relative)) {
			$condition['fullname_relative'] = $fullname_relative;
		}
		if (!empty($customer_name)) {
			$condition['customer_name'] = $customer_name;
		}
		if (!empty($customer_phone_number)) {
			$customer_phone_numbers = explode(",", (string)$customer_phone_number);
			$condition['customer_phone_number'] = $customer_phone_numbers;
		}
		if (!empty($ngaygiaingan)) {
			$condition['ngaygiaingan'] = $ngaygiaingan;
		}
		if (!empty($search_htv)) {
			$condition['search_htv'] = $search_htv;
		}
		if (!empty($is_export)) {
			$condition['is_export'] = $is_export;
		}
		if (!empty($type_contract)) {
			$condition['type_contract'] = $type_contract;
		}
		if (!empty($type_contract_digital)) {
			$condition['type_contract_digital'] = $type_contract_digital;
		}
		$per_page = !empty($this->dataPost['per_page']) ? $this->dataPost['per_page'] : 30;
		$uriSegment = !empty($this->dataPost['uriSegment']) ? $this->dataPost['uriSegment'] : 0;
		if (!empty($condition)) {
			if (!empty($this->dataPost['is_export'])) {
				$contract = $this->contract_model->getContractPaginationByRecordsManager($condition, $per_page, $uriSegment);
			} else {
				$contract = $this->contract_model->getContractPaginationByRecordsManager($condition, $per_page, $uriSegment);
			}
		} else {
			$contract = $this->contract_model->findContractPagination($per_page, $uriSegment);
		}
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $contract,
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}


	public function get_count_contract_all_post()
	{
		// $flag = notify_token($this->flag_login);
		// if ($flag == false) return;
		$this->dataPost = $this->input->post();
		$condition = !empty($this->dataPost['condition']) ? $this->dataPost['condition'] : array();
		$code_contract = !empty($this->dataPost['code_contract']) ? $this->dataPost['code_contract'] : "";
		$code_contract_disbursement = !empty($this->dataPost['code_contract_disbursement']) ? $this->dataPost['code_contract_disbursement'] : "";
		$customer_name = !empty($this->dataPost['customer_name']) ? $this->dataPost['customer_name'] : "";
		$customer_phone_number = !empty($this->dataPost['customer_phone_number']) ? $this->dataPost['customer_phone_number'] : "";
		$start = !empty($this->dataPost['start']) ? $this->dataPost['start'] : "";
		$end = !empty($this->dataPost['end']) ? $this->dataPost['end'] : "";
		$ngaygiaingan = !empty($this->dataPost['ngaygiaingan']) ? $this->dataPost['ngaygiaingan'] : 1;
		$property = !empty($this->dataPost['property']) ? $this->dataPost['property'] : "";
		$status = !empty($this->dataPost['status']) ? $this->dataPost['status'] : "";
		$type = !empty($this->dataPost['type_ct']) ? $this->dataPost['type_ct'] : "";
		$asset_name = !empty($this->dataPost['asset_name']) ? $this->dataPost['asset_name'] : "";
		$customer_identify = !empty($this->dataPost['customer_identify']) ? $this->dataPost['customer_identify'] : "";
		$search_htv = !empty($this->dataPost['search_htv']) ? $this->dataPost['search_htv'] : "";
		$phone_number_relative = !empty($this->dataPost['phone_number_relative']) ? $this->dataPost['phone_number_relative'] : "";
		$fullname_relative = !empty($this->dataPost['fullname_relative']) ? $this->dataPost['fullname_relative'] : "";
		$type_contract_digital = !empty($this->dataPost['type_contract_digital']) ? $this->dataPost['type_contract_digital'] : "";
		$code_store = !empty($this->dataPost['code_store']) ? $this->dataPost['code_store'] : "";
		$region = !empty($this->dataPost['region']) ? $this->dataPost['region'] : "";
		if (!empty($region) && (count($code_store) < 1 || empty($code_store)) ) {
			$stores_id = $this->get_list_id_stores_by_region($region);
		}
		if (!empty($start) && !empty($end)) {
			$condition = array(
				'start' => strtotime(trim($start) . ' 00:00:00'),
				'end' => strtotime(trim($end) . ' 23:59:59')
			);
		}
		$groupRoles = $this->getGroupRole($this->id);
		$all = false;
		if (in_array('quan-ly-ho-so', $groupRoles)) {
			$all = true;
		}
		if ($all) {
			$stores = $this->getStores($this->id);
			if (empty($stores)) {
				$response = array(
					'status' => REST_Controller::HTTP_UNAUTHORIZED,
					'data' => array()
				);
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			}
			$condition['stores'] = $stores;
		}
		if (!empty($code_store)) {
			$condition['stores'] = (is_array($code_store)) ? $code_store : [$code_store];
		}
		if (!empty($stores_id) && count($stores_id) > 1) {
			$condition['stores'] = (is_array($stores_id)) ? $stores_id : [$code_store];
		}
		if (!empty($asset_name)) {
			$condition['asset_name'] = $asset_name;
		}
		if (!empty($ngaygiaingan)) {
			$condition['ngaygiaingan'] = $ngaygiaingan;
		}
		if (!empty($property)) {
			$condition['property'] = $property;
		}
		if (!empty($type)) {
			$condition['type'] = $type;
		}

		if (!empty($status)) {
			$condition['status'] = (int)$status;
		}
		if (!empty($code_contract)) {
			$condition['code_contract'] = $code_contract;
		}
		if (!empty($search_htv)) {
			$condition['search_htv'] = $search_htv;
		}
		if (!empty($code_contract_disbursement)) {

			$condition['code_contract_disbursement'] = $code_contract_disbursement;
		}
		if (!empty($phone_number_relative)) {
			$condition['phone_number_relative'] = $phone_number_relative;
		}
		if (!empty($fullname_relative)) {
			$condition['fullname_relative'] = $fullname_relative;
		}
		if (!empty($customer_name)) {
			$condition['customer_name'] = $customer_name;
		}
		if (!empty($customer_phone_number)) {
			$customer_phone_number = explode(",", (string)$customer_phone_number);
			$condition['customer_phone_number'] = $customer_phone_number;
		}
		if (!empty($type_contract_digital)) {
			$condition['type_contract_digital'] = $type_contract_digital;
		}
		if (!empty($customer_identify)) {
			$customer_identify = explode(",", (string)$customer_identify);
			$condition['customer_identify'] = $customer_identify;
		}
		if (!empty($condition)) {
			$contract = $this->contract_model->getCountContractByRecordsManager($condition);
		} else {
			$contract = $this->contract_model->countContract();
		}
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $contract
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}


	/** Get array store infor
	 *
	 */
	public function get_stores_by_code_region_post()
	{
		$code_region = $this->security->xss_clean($this->dataPost['code_region']) ?? '';
		$stores_data = $this->get_list_stores_by_region($code_region);
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'data' => $stores_data
		];
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}

	/** Get array store infor theo mã vùng miền
	 * @param $code_region
	 * @return array|array[]
	 */
	private function get_list_stores_by_region($code_region)
	{
		$array_store = [];
		$i = 0;
		if ($code_region == 'north_region') {
			$roles_qlhs_all = $this->role_model->findOne(['status' => 'active', 'slug' => 'qlhs-mien-bac']);
		} elseif ($code_region == 'sounth_region') {
			$roles_qlhs_all = $this->role_model->findOne(['status' => 'active', 'slug' => 'qlhs-mien-nam']);
		} elseif ($code_region == 'mekong_region') {
			$roles_qlhs_all = $this->role_model->findOne(['status' => 'active', 'slug' => 'qlhs-mekong']);
		}
		//Lặp mảng store trong role QLHS để lấy store infor
		if (!empty($roles_qlhs_all)) {
			foreach ($roles_qlhs_all['stores'] as $stores) {
				foreach ($stores as $id_store => $store) {
					$array_store += [$i => array('store_id' => $id_store, 'store_name' => $store['name'])];
					$i++;
				}
			}
		}
		return $array_store;
	}

	/** Check trạng thái đăng ký xe hoặc sổ đỏ của hồ sơ
	 *
	 */
	public function check_dkx_origin_post()
	{
		$code_contract_disbursement = !empty($this->security->xss_clean($this->dataPost['code_contract_disbursement']))? $this->dataPost['code_contract_disbursement'] : '';
		$contract_records_db = $this->file_manager_model->find_one_select(['code_contract_disbursement_text' => $code_contract_disbursement, 'is_dkx_origin' => true], ['is_dkx_origin']);
		if (empty($contract_records_db)) {
			$response = [
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => 'noData',
				'isDkx' => false
			];
			return $this->set_response($response,REST_Controller::HTTP_OK);
		} else {
			$response = [
				'status' => REST_Controller::HTTP_OK,
				'isDkx' => true
			];
			return $this->set_response($response,REST_Controller::HTTP_OK);
		}
	}

	/** Lấy một hồ sơ của HĐ liên quan
	 *
	 */
	public function get_one_records_by_contract_post()
	{
		$code_contract_disbursement = !empty($this->security->xss_clean($this->dataPost['code_contract_disbursement']))? $this->dataPost['code_contract_disbursement'] : '';
		$contract_records = $this->file_manager_model->findOne(['code_contract_disbursement_text' => $code_contract_disbursement, 'is_dkx_origin' => array('$exists' => true)]);
		if (empty($contract_records)) {
			$response = [
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => 'noData'
			];
			return $this->set_response($response,REST_Controller::HTTP_OK);
		}
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'data' => $contract_records
		];
		return $this->set_response($response,REST_Controller::HTTP_OK);
	}

	/** Lấy một Hợp đồng của hồ sơ
	 *
	 */
	public function get_one_contract_by_records_post()
	{
		$code_contract_disbursement = !empty($this->security->xss_clean($this->dataPost['code_contract_disbursement']))? $this->dataPost['code_contract_disbursement'] : '';
		$contract_records_db = $this->contract_model->find_one_select(['code_contract_disbursement' => $code_contract_disbursement],
			['customer_infor','property_infor','loan_infor','store','code_contract_disbursement','code_contract','disbursement_date','status','type_property','date_payment_finish']
		);
		if (empty($contract_records_db)) {
			$response = [
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => 'noData',
				'data' => new stdClass()
			];
			return $this->set_response($response,REST_Controller::HTTP_OK);
		}
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'data' => $contract_records_db
		];
		return $this->set_response($response,REST_Controller::HTTP_OK);
	}

	/**
	 * Đồng bộ dữ liệu hồ sơ giải ngân cũ
	 */
	public function importOldRecords_post()
	{
		$records_old_db = $this->file_manager_model->findOne(['code_contract_disbursement_text' => $this->dataPost['code_contract_disbursement'], 'status' => array('$nin' => array('2'))]);
		if (empty($records_old_db)) {
			$response = [
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => 'Không tìm thấy hoặc không tồn tại hồ sơ!',
				'data' => $this->dataPost['code_contract_disbursement']
			];
			return $this->set_response($response, REST_Controller::HTTP_OK);
		} else {
			$is_dkx_origin = false;
			if ($this->dataPost['dang_ky_xe'] > 0) {
				$is_dkx_origin = true;
				$status_dkx = 1; //1: Lưu kho, 2: Đã trả, 3: Lưu ở hợp đồng khác, 4: Không có ĐKX
			}
			if ($this->dataPost['so_do'] > 0) {
				$is_dkx_origin = true;
			}
			$array_update = [
				"records_receive.thoa_thuan_ba_ben.text" => 'Thỏa thuận 3 bên',
				"records_receive.thoa_thuan_ba_ben.quantity" => (int)$this->dataPost['thoa_thuan_ba_ben'],
				"records_receive.thoa_thuan_ba_ben.slug" => 'thoa-thuan-3-ben',
				"records_receive.bbbg_tai_san.text" => 'Biên bản bàn giao Tài sản',
				"records_receive.bbbg_tai_san.quantity" => (int)$this->dataPost['bbbg_tai_san'],
				"records_receive.bbbg_tai_san.slug" => 'bien-ban-ban-giao-tai-san',
				"records_receive.dang_ky_xe.text" => 'Đăng ký / Cà vẹt xe',
				"records_receive.dang_ky_xe.quantity" => (int)$this->dataPost['dang_ky_xe'],
				"records_receive.dang_ky_xe.slug" => 'dang-ky-xe',
				"records_receive.thong_bao.text" => 'Thông báo',
				"records_receive.thong_bao.quantity" => (int)$this->dataPost['thong_bao'],
				"records_receive.thong_bao.slug" => 'thong-bao',
				"records_receive.hd_mua_ban_xe.text" => 'Hợp đồng mua bán xe',
				"records_receive.hd_mua_ban_xe.quantity" => (int)$this->dataPost['hd_mua_ban_xe'],
				"records_receive.hd_mua_ban_xe.slug" => 'hop-dong-mua-ban-xe',
				"records_receive.cam_ket.text" => 'Cam kết',
				"records_receive.cam_ket.quantity" => (int)$this->dataPost['cam_ket'],
				"records_receive.cam_ket.slug" => 'cam-ket',
				"records_receive.bbbg_thiet_bi_dinh_vi.text" => 'BBBG thiết bị định vị',
				"records_receive.bbbg_thiet_bi_dinh_vi.quantity" => (int)$this->dataPost['bbbg_thiet_bi_dinh_vi'],
				"records_receive.bbbg_thiet_bi_dinh_vi.slug" => 'bbbg-thiet-bi-dinh-vi',
				"records_receive.bbh_hoi_dong_co_dong.text" => 'BB họp hội đồng cổ đông',
				"records_receive.bbh_hoi_dong_co_dong.quantity" => (int)$this->dataPost['bbh_hoi_dong_co_dong'],
				"records_receive.bbh_hoi_dong_co_dong.slug" => 'bb-hop-hoi-dong-co-dong',
				"records_receive.hop_dong_mua_ban.text" => 'Hợp đồng mua bán',
				"records_receive.hop_dong_mua_ban.quantity" => (int)$this->dataPost['hop_dong_mua_ban'],
				"records_receive.hop_dong_mua_ban.slug" => 'hop-dong-mua-ban',
				"records_receive.hd_uy_quyen.text" => 'Hợp đồng ủy quyền',
				"records_receive.hd_uy_quyen.quantity" => (int)$this->dataPost['hd_uy_quyen'],
				"records_receive.hd_uy_quyen.slug" => 'hop-dong-uy-quyen',
				"records_receive.hd_chuyen_nhuong.text" => 'Hợp đồng chuyển nhượng',
				"records_receive.hd_chuyen_nhuong.quantity" => (int)$this->dataPost['hd_chuyen_nhuong'],
				"records_receive.hd_chuyen_nhuong.slug" => 'hop-dong-chuyen-nhuong',
				"records_receive.so_do.text" => 'Sổ đỏ / Giấy CNQSDĐ',
				"records_receive.so_do.quantity" => (int)$this->dataPost['so_do'],
				"records_receive.so_do.slug" => 'so-do',
				"records_receive.hd_dat_coc.text" => 'Hợp đồng đặt cọc',
				"records_receive.hd_dat_coc.quantity" => (int)$this->dataPost['hd_dat_coc'],
				"records_receive.hd_dat_coc.slug" => 'hop-dong-dat-coc',
				"records_receive.phu_luc_gia_han.text" => 'Phụ lục gia hạn',
				"records_receive.phu_luc_gia_han.quantity" => (int)$this->dataPost['phu_luc_gia_han'],
				"records_receive.phu_luc_gia_han.slug" => 'phu-luc-gia-han',
				"is_dkx_origin" => $is_dkx_origin,
				"status_dkx" => $status_dkx,
				"code_store_rc" => $this->dataPost['code_store_rc'],
				"updated_rcr_at" => $this->createdAt,
				"updated_rcr_by" => $this->uemail
			];
			//Insert log
			$log = array(
				"type" => "records_send",
				"action" => "import",
				"fileReturn_id" => $records_old_db['_id'],
				"old" => $records_old_db,
				"new" => $this->dataPost,
				"created_at" => $this->createdAt,
				"created_by" => $this->uemail
			);
			$this->log_fileManager_model->insert($log);
			//Update DB
			$this->file_manager_model->update(['_id' => $records_old_db['_id']], $array_update);
			$response = [
				'status' => REST_Controller::HTTP_OK,
				'message' => 'Import thành công!'
			];
			return $this->set_response($response, REST_Controller::HTTP_OK);
		}
	}


	private function create_travel_paper($code_contract_disbursement)
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
//		$code_contract_disbursement = $this->dataPost['code_contract_disbursement'];
		// Get one contract db
		$contract_db = $this->contract_model->find_one_select(['code_contract_disbursement' => $code_contract_disbursement],
			['customer_infor','loan_infor','property_infor','store','code_contract_disbursement','disbursement_date','expire_date','code_contract']
		);
		$store_db = $this->store_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($contract_db['store']['id'])]);
		$province_store_name = $store_db['province']['name'] ?? '';
		$province_store_name = str_replace('Tỉnh', '', $province_store_name);
		$province_store_name = str_replace('Thành phố', '', $province_store_name);
		$province_store_name = trim($province_store_name);
		$mydate = getdate(date("U"));
		$day = '';
		$mon = '';
		$year = $mydate['year'];
		$ten_cong_ty = '';
		$ten_cong_ty_viet_hoa = '';
		$code_contract = $contract_db['code_contract'] ?? '';
		$width_img_doc = 520;
		$height_img_doc = 250;
		$link_docx_file = '';
		$company_code = $this->check_store_tcv_dong_bac($contract_db['store']['id']);
		if ($company_code == 'TCV') {
			$ten_cong_ty = 'Tiện Ngay';
			$ten_cong_ty_viet_hoa = 'TIỆN NGAY';
		} elseif ($company_code == 'TCVĐB') {
			$ten_cong_ty = 'Tiện Ngay Đông Bắc';
			$ten_cong_ty_viet_hoa = 'TIỆN NGAY ĐÔNG BẮC';
		}
		$place_document = '';
		if ($mydate['mday'] < 10) {
			$day = "0" . $mydate['mday'];
		} else {
			$day = $mydate['mday'];
		}
		if ($mydate['mon'] < 3) {
			$mon = "0" . $mydate['mon'];
		} else {
			$mon = $mydate['mon'];
		}
		$ma_hop_dong = $contract_db['code_contract_disbursement'] ?? '';
		$bien_kiem_soat = $contract_db['property_infor'][2]['value'] ?? '';
		$ten_chu_xe = $contract_db['property_infor'][5]['value'] ?? '';
		$ten_khach_hang = $contract_db['customer_infor']['customer_name'] ?? '';
		$ngay_hieu_luc = date('d/m/Y', $contract_db['disbursement_date']) ?? '';
		$ngay_ket_thuc = date('d/m/Y', $contract_db['expire_date']) ?? '';
		$vehicle_img_arr = [
			'front_img' => $contract_db['loan_infor']['image_property']['image_front'],
			'back_img' => $contract_db['loan_infor']['image_property']['image_back'],
			'get_thumb' => 'true',
			'type_url' => 'vehicle_registrations'
		];

		// Call API CVS để lấy ảnh đăng ký xe đã được cắt gọn dạng img base64_string
		$response_cvs = $this->cvs->callApi($vehicle_img_arr);
		if (isset($response_cvs->errorCode) && $response_cvs->errorCode == 0) {
			if ($response_cvs->data[1]->type == 'vehicle_registration_front') {
				$base64_front_string = $response_cvs->data[1]->info->image;
			}
			if ($response_cvs->data[0]->type == 'vehicle_registration_back') {
				$base64_back_string = $response_cvs->data[0]->info->image;
			}
			$output_front_img = APPPATH . 'file/front_' . $code_contract . '.png';
			$output_back_img = APPPATH . 'file/back_' . $code_contract . '.png';
			// Convert base64_string img to file image
			$this->base64_to_jpeg($base64_front_string, $output_front_img);
			$this->base64_to_jpeg($base64_back_string, $output_back_img);
		}
		// Create file giay_di_duong.docx
		if (file_exists('assets/file/giay_di_duong/giay_di_duong_template.docx')) {
			$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('assets/file/giay_di_duong/giay_di_duong_template.docx');
			$templateProcessor->setValue('ten_cong_ty_up', $ten_cong_ty_viet_hoa ?? '');
			$templateProcessor->setValue('place', $province_store_name ?? '');
			$templateProcessor->setValue('day', $day ?? '');
			$templateProcessor->setValue('month', $mon ?? '');
			$templateProcessor->setValue('year', $year ?? '');
			$templateProcessor->setValue('ma_hop_dong', $ma_hop_dong ?? '');
			$templateProcessor->setValue('ten_cong_ty', $ten_cong_ty ?? '');
			$templateProcessor->setValue('bien_kiem_soat', $bien_kiem_soat ?? '');
			$templateProcessor->setValue('ten_chu_xe', $ten_chu_xe ?? '');
			$templateProcessor->setValue('ten_khach_hang', $ten_khach_hang ?? '');
			$templateProcessor->setValue('ngay_hieu_luc', $ngay_hieu_luc ?? '');
			$templateProcessor->setValue('ngay_ket_thuc', $ngay_ket_thuc ?? '');
			$templateProcessor->setImageValue('dkx_front_img', array(
				'path' => $output_front_img,
				'width' => $width_img_doc,
				'height' => $height_img_doc
			));
			$templateProcessor->setImageValue('dkx_back_img', array(
				'path' => $output_back_img,
				'width' => $width_img_doc,
				'height' => $height_img_doc
			));
			$docx_file_path = APPPATH . 'file_created/giay_di_duong_' . $code_contract . '.docx';
			$templateProcessor->saveAs($docx_file_path);
			unlink($output_front_img);
			unlink($output_back_img);
		}
		// Upload file docx vừa tạo lên services upload
		$cfile = new CURLFile($docx_file_path);
		$push_upload = $this->pushUpload($cfile);
		$link_docx_file = '';
		if (is_object($push_upload)) {
			if ($push_upload->code == 200) {
				$link_docx_file = $push_upload->path;
			}
		}
		return $link_docx_file;
	}

	/** Lấy mã công ty Tài chính Việt hoặc TCV Đông Bắc
	 * @param $id_pgd
	 * @return string
	 */
	public function check_store_tcv_dong_bac($id_pgd)
	{
		$role = $this->role_model->findOne(['slug' => 'cong-ty-cpcn-tcv-dong-bac']);
		$id_store = [];
		if (count($role['stores']) > 0) {
			foreach ($role['stores'] as $store) {
				foreach ($store as $key => $value) {
					$id_store[] = $key;
				}
			}
		}
		if (in_array($id_pgd, $id_store)) {
			return 'TCVĐB';
		}
		return 'TCV';
	}


	/** Convert chuỗi base64 ảnh sang file ảnh
	 * @param $base64_string
	 * @param $output_file
	 * @return mixed
	 */
	private function base64_to_jpeg($base64_string, $output_file) {
		// open the output file for writing
		$ifp = fopen( $output_file, 'wb' );
		// split the string on commas
		// $data[ 0 ] == "data:image/png;base64"
		// $data[ 1 ] == <actual base64 string>
		$data = explode( ',', $base64_string );
		// we could add validation here with ensuring count( $data ) > 1
		fwrite( $ifp, base64_decode($data[0]));
		// clean up the file resource
		fclose( $ifp );
		return $output_file;
	}

	/** Upload file lên services upload
	 * @param $cfile
	 * @return mixed
	 */
	private function pushUpload($cfile){
		$serviceUpload = $this->config->item("url_service_upload");
		$post = array('avatar' => $cfile );
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $serviceUpload);
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec ($ch);
		curl_close ($ch);
		$result1 = json_decode($result);
		return $result1;
	}


	/** Get array region theo mã nhân viên
	 *
	 * @return array|array[]
	 */
	public function get_region_by_user_post()
	{
		$array_region = [];
		$i = 0;
		$id_user_login = $this->id ?? $this->dataPost['user_id'];
		$roles_qlhs_mb = $this->role_model->findOne(['status' => 'active', 'slug' => 'qlhs-mien-bac']);
		$roles_qlhs_mn = $this->role_model->findOne(['status' => 'active', 'slug' => 'qlhs-mien-nam']);
		$roles_qlhs_mekong = $this->role_model->findOne(['status' => 'active', 'slug' => 'qlhs-mekong']);
		//Lặp mảng users trong role QLHS để lấy users infor
		if (!empty($roles_qlhs_mb)) {
			foreach ($roles_qlhs_mb['users'] as $users) {
				foreach ($users as $id_user => $user) {
					if ($id_user_login == $id_user) {
						$array_region += [$i => array('value_region' => 'north_region', 'name_region' => 'Miền Bắc')];
						++$i;
					}
					break;
				}
			}
		}
		//Lặp mảng users trong role QLHS để lấy users infor
		if (!empty($roles_qlhs_mb)) {
			foreach ($roles_qlhs_mn['users'] as $users) {
				foreach ($users as $id_user => $user) {
					if ($id_user_login == $id_user) {
						$array_region += [$i => array('value_region' => 'sounth_region', 'name_region' => 'Miền Nam')];
						++$i;
					}
					break;
				}
			}
		}
		//Lặp mảng users trong role QLHS để lấy users infor
		if (!empty($roles_qlhs_mb)) {
			foreach ($roles_qlhs_mekong['users'] as $users) {
				foreach ($users as $id_user => $user) {
					if ($id_user_login == $id_user) {
						$array_region += [$i => array('value_region' => 'mekong_region', 'name_region' => 'MeKong')];
					}
					break;
				}
			}
		}
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'data' => $array_region
		];
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}

	/** Get array idstore infor theo mã vùng miền
	 * @param $code_region
	 * @return array|array[]
	 */
	private function get_list_id_stores_by_region($code_region)
	{
		$array_id_store = array();
		$i = 0;
		if ($code_region == 'north_region') {
			$roles_qlhs_all = $this->role_model->findOne(['status' => 'active', 'slug' => 'qlhs-mien-bac']);
		} elseif ($code_region == 'sounth_region') {
			$roles_qlhs_all = $this->role_model->findOne(['status' => 'active', 'slug' => 'qlhs-mien-nam']);
		} elseif ($code_region == 'mekong_region') {
			$roles_qlhs_all = $this->role_model->findOne(['status' => 'active', 'slug' => 'qlhs-mekong']);
		}
		//Lặp mảng store trong role QLHS để lấy store infor
		if (!empty($roles_qlhs_all)) {
			foreach ($roles_qlhs_all['stores'] as $stores) {
				foreach ($stores as $id_store => $store) {
					array_push($array_id_store, $id_store);
				}
			}
		}
		return $array_id_store;
	}

	/**
	 * Get log for is_superadmin
	 */
	public function get_log_record_by_id_post()
	{
		$id_record = $this->security->xss_clean($this->dataPost['id_record']) ?? '';
		$logs_db = $this->log_fileManager_model->find_where(['fileReturn_id' => $id_record]);
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'data' => $logs_db
		];
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}

	/** Gửi TP QLKV duyệt yêu cầu mượn hồ sơ
	 * @return null
	 */
	public function send_borrowed_to_tp_qlkv_post()
	{
		$id_borrowed = $this->dataPost['id_borrowed'];
		$img_file_borrow = $this->dataPost['file_img_approve'];
		$note_qlkv = $this->dataPost['note_qlkv'];
		$borrowed_record = $this->borrowed_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($id_borrowed)]);
		$log = array(
			"type" => "borrowed",
			"action" => "approve",
			"borrowed_id" => $this->dataPost['id_borrowed'],
			"old" => $borrowed_record,
			"new" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_borrowed_model->insert($log);
		$area_infor = $this->store_model->get_area_by_store_id($borrowed_record['stores']);
		if ($area_infor == 'MB') {
			$list_id_tp_qlkv = $this->role_model->get_id_tp_qlkv_mb();
		} elseif ($area_infor == 'MN') {
			$list_id_tp_qlkv = $this->role_model->get_id_tp_qlkv_mn();
		}
		/*Gửi email tới tp QLKV*/
		$borrowed_record['status'] = Borrowed_model::WAIT_DEBT_MANAGER_APPROVE;
		$this->sendEmailApprove_borrowed($borrowed_record, $list_id_tp_qlkv);
		if (!empty($list_id_tp_qlkv)) {
			foreach (array_unique($list_id_tp_qlkv) as $user_id) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id_borrowed'],
					'action' => 'borrowed_approve',
					'note' => 'Duyệt yêu cầu mượn HS',
					'user_id' => $user_id,
					'status' => 1, //1: new, 2 : read, 3: block,
					'borrowed_status' => Borrowed_model::WAIT_DEBT_MANAGER_APPROVE,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}
		unset($this->dataPost['id_borrowed']);
		$array_update = [
			'status' => Borrowed_model::WAIT_DEBT_MANAGER_APPROVE,
			'ghichu' => $note_qlkv,
			'file_img_approve' => $img_file_borrow,
			'domain_borrow' => $area_infor
		];
		/*update borrowed record*/
		$this->borrowed_model->update(['_id' => $borrowed_record['_id']], $array_update);
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Success"
		);
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}

	/** TP QLKV Gửi yêu cầu mượn lên quản lý hồ sơ
	 * @return null
	 */
	public function send_borrowed_to_qlhs_post()
	{
		$id_borrowed = $this->dataPost['id_borrowed'];
		$img_file_borrow = $this->dataPost['file_img_approve'];
		$note_qlkv = $this->dataPost['note_qlkv'];
		$borrowed_record = $this->borrowed_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($id_borrowed)]);
		$log = array(
			"type" => "borrowed",
			"action" => "send_borrow_qlhs",
			"borrowed_id" => $this->dataPost['id_borrowed'],
			"old" => $borrowed_record,
			"new" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_borrowed_model->insert($log);
		$check_area = $this->store_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($borrowed_record['stores'])));
		if ($check_area['code_area'] == "Priority" ||$check_area['code_area'] == "KV_HN1" || $check_area['code_area'] == "KV_HN2" || $check_area['code_area'] == "KV_QN" || $check_area['code_area'] == "KV_MT1" || $check_area['code_area'] == "KV_BTB") {
			$user = $this->quan_ly_ho_so_mb();
		} else if ($check_area['code_area'] == "KV_MK") {
			$user = $this->quan_ly_ho_so_mekong();
		} else {
			$user = $this->quan_ly_ho_so_mn();
		}
		/*Gửi email tới tp QLKV*/
		$borrowed_record['status'] = Borrowed_model::REQUEST_TO_BORROW;
		$this->sendEmailApprove_borrowed($borrowed_record, $user);
		if (!empty($user)) {
			foreach (array_unique($user) as $user_id) {
				$data_approve = [
					'action_id' => (string)$this->dataPost['id_borrowed'],
					'action' => 'request_borrow',
					'note' => 'Yêu cầu mượn HS.',
					'user_id' => $user_id,
					'status' => 1, //1: new, 2 : read, 3: block,
					'borrowed_status' => Borrowed_model::REQUEST_TO_BORROW,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}
		unset($this->dataPost['id_borrowed']);
		$array_update = [
			'status' => Borrowed_model::REQUEST_TO_BORROW,
			'ghichu' => $note_qlkv,
			'file_img_approve' => $img_file_borrow,
			'req_borrow' => 'forward',
			'created_req_borrow_at' => $this->createdAt,
			'created_req_borrow_by' => $this->uemail
		];
		/*update borrowed record*/
		$this->borrowed_model->update(['_id' => $borrowed_record['_id']], $array_update);
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Success"
		);
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}

	/** Gửi YC duyệt gia hạn thời gian mượn hồ sơ tới TP QLKV
	 * @return void|null
	 */
	public function send_request_extend_borrow_post()
	{
		$id_borrow = $this->dataPost['id_borrow'];
		$file_img_approve = $this->dataPost['file_img_approve'];
		$note_approve_extend = $this->dataPost['note_approve_extend'];
		$time_extend = $this->dataPost['time_extend'];
		//Validate
		if (empty($this->dataPost['time_extend'])) {
			$response = array(
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => "Thời gian gia hạn không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		$borrowed_record = $this->borrowed_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($id_borrow)]);
		$borrowed_days = $this->check_day_extend_borrowed($this->dataPost['time_extend'], $borrowed_record['borrowed_end']);

		if ($borrowed_days > Borrowed_model::DUE_TIME_EXTEND_BORROW_QLKV){
			$response = array(
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => "Thời gian gia hạn mong muốn mượn (" . $borrowed_days . " ngày) không quá 10 ngày"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		if (empty($this->dataPost['note_approve_extend'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Lý do mượn không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		if (empty($this->dataPost['file_img_approve'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Ảnh hồ sơ không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		$log = array(
			"type" => "borrowed",
			"action" => "send_request",
			"borrowed_id" => $id_borrow,
			"old" => ['status' => $borrowed_record['status']],
			"new" => ['status' => Borrowed_model::WAIT_DEBT_MANAGER_APPROVE_EXTEND_BORROWED,'ghichu' => $this->dataPost['note_approve_extend'],'fileApprove_img' => $this->dataPost['file_img_approve']],
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_borrowed_model->insert($log);
		$area_infor = $borrowed_record['domain_borrow'];
		if ($area_infor == 'MB') {
			$list_id_tp_qlkv = $this->role_model->get_id_tp_qlkv_mb();
		} elseif ($area_infor == 'MN') {
			$list_id_tp_qlkv = $this->role_model->get_id_tp_qlkv_mn();
		}
		/*Gửi email tới tp QLKV*/
		$borrowed_record['status'] = Borrowed_model::WAIT_DEBT_MANAGER_APPROVE_EXTEND_BORROWED;
		$this->sendEmailApprove_borrowed($borrowed_record, $list_id_tp_qlkv);
		if (!empty($list_id_tp_qlkv)) {
			foreach (array_unique($list_id_tp_qlkv) as $user_id) {
				$data_approve = [
					'action_id' => (string)$id_borrow,
					'action' => 'borrowed_approve_extend',
					'note' => 'Duyệt yêu cầu gia hạn thời gian mượn HS',
					'user_id' => $user_id,
					'status' => 1, //1: new, 2 : read, 3: block,
					'borrowed_status' => Borrowed_model::WAIT_DEBT_MANAGER_APPROVE_EXTEND_BORROWED,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}
		unset($this->dataPost['id_borrow']);
		$array_update = [
			'status' => Borrowed_model::WAIT_DEBT_MANAGER_APPROVE_EXTEND_BORROWED,
			'ghichu' => $note_approve_extend,
			'file_img_approve' => $file_img_approve,
			'time_extend_suggest' => strtotime($time_extend)
		];
		/*update borrowed record*/
		$this->borrowed_model->update(['_id' => $borrowed_record['_id']], $array_update);
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Success"
		);
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}

	/** Gửi YC duyệt gia hạn thời gian mượn hồ sơ tới QLHS
	 * @return void|null
	 */
	public function send_request_extend_borrow_to_qlhs_post()
	{
		$id_borrow = $this->dataPost['id'];
		$borrowed_record = $this->borrowed_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($id_borrow)]);
		$this->dataPost['file_img_approve'] = !empty($this->dataPost['file_img_approve']) ? $this->security->xss_clean($this->dataPost['file_img_approve']) : $borrowed_record['file_img_approve'];
		$this->dataPost['ghichu'] = !empty($this->dataPost['ghichu']) ? $this->security->xss_clean($this->dataPost['ghichu']) : $borrowed_record['ghichu'];
		$this->dataPost['update_time_borrowed'] = !empty($this->dataPost['update_time_borrowed']) ? $this->security->xss_clean($this->dataPost['update_time_borrowed']) : date('d-m-Y', $borrowed_record['time_extend_suggest']);
		$file_img_approve = $this->dataPost['file_img_approve'];
		$note_extend = $this->dataPost['ghichu'];
		$time_extend = $this->dataPost['update_time_borrowed'];
		$this->dataPost['created_at'] = $this->createdAt;
		//Validate

		$borrowed_days = $this->check_day_extend_borrowed($time_extend, $borrowed_record['borrowed_end']);
		if ($borrowed_days > 15) {
			$response = array(
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => "Thời gian gia hạn mượn mong muốn (" . $borrowed_days . " ngày) không quá 15 ngày"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		$log = array(
			"type" => "borrowed",
			"action" => "send_request",
			"borrowed_id" => $id_borrow,
			"old" => ['status' => $borrowed_record['status']],
			"new" => ['status' => Borrowed_model::REQUEST_EXTEND_BORROWED,'ghichu' => $note_extend,'fileApprove_img' => $file_img_approve],
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_borrowed_model->insert($log);
		$check_area = $this->store_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($borrowed_record['stores'])));
		if ($check_area['code_area'] == "Priority" ||$check_area['code_area'] == "KV_HN1" || $check_area['code_area'] == "KV_HN2" || $check_area['code_area'] == "KV_QN" || $check_area['code_area'] == "KV_MT1" || $check_area['code_area'] == "KV_BTB") {
			$user = $this->quan_ly_ho_so_mb();
		} else if ($check_area['code_area'] == "KV_MK") {
			$user = $this->quan_ly_ho_so_mekong();
		} else {
			$user = $this->quan_ly_ho_so_mn();
		}
		/*Gửi email tới tp QLKV*/
		$borrowed_record['status'] = Borrowed_model::REQUEST_EXTEND_BORROWED;
		$this->sendEmailApprove_borrowed($borrowed_record, $user);
		if (!empty($user)) {
			foreach (array_unique($user) as $user_id) {
				$data_approve = [
					'action_id' => (string)$id_borrow,
					'action' => 'request_extend',
					'note' => 'Yêu cầu gia hạn thời gian mượn HS',
					'user_id' => $user_id,
					'status' => 1, //1: new, 2 : read, 3: block,
					'borrowed_status' => Borrowed_model::REQUEST_EXTEND_BORROWED,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->borrowed_noti_model->insert($data_approve);
			}
		}
		unset($this->dataPost['id_borrow']);
		$array_update = [
			'status' => Borrowed_model::REQUEST_EXTEND_BORROWED,
			'ghichu' => $note_extend,
			'file_img_approve' => $file_img_approve,
			'time_extend' => strtotime($time_extend),
			'req_extend' => 'forward',
			'created_req_extend_at' => $this->createdAt,
			'created_req_extend_by' => $this->uemail
		];
		if (empty($array_update['file_img_approve'])) {
			$array_update['file_img_approve'] = $borrowed_record['file_img_approve'];
		}
		/*update borrowed record*/
		$this->dataPost['borrowed_id'] = $this->dataPost['id'];
		$this->extend_borrowed_model->insert($this->dataPost);
		$this->borrowed_model->update(['_id' => $borrowed_record['_id']], $array_update);
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Success"
		);
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}

	/** Cron update domain for borrowed of quan ly khoan vay department (run only one)
	 * @return void
	 */
	public function sync_domain_for_borrowed_qlkv_post()
	{
		/*không cần chạy hàm này nữa*/
		$borrowed_dbs = $this->borrowed_model->find_where_select(['groupRoles_store' => 'Thu hồi nợ', 'domain_borrow' => array('$exists' => false)], ['stores']);
		if (empty($borrowed_dbs)) {
			echo "No Data!";
			return;
		} else {
			foreach ($borrowed_dbs as $borrowed) {
				$id_borrowed = $borrowed['_id'];
				$id_store = !empty($borrowed['stores']) ? $borrowed['stores'] : '';
				$code_domain = $this->store_model->get_area_by_store_id($id_store);
				try {
					$this->borrowed_model->update(['_id' => $id_borrowed], [
						'domain_borrow' => $code_domain,
						'log_cron' => 'update domain for borrowed of qlkv department',
						'type_cron' => true,
						'cron_at' => time(),
					]);
				} catch (Exception $exception) {
					echo $exception;
				}
			}
		}
		echo "Update domain of borrowed for qlkv completed!";
	}

	/** Cập nhật hồ sơ về hợp đồng gốc.
	 * @return null
	 */
	public function update_records_origin_post()
	{
		$id = $this->security->xss_clean($this->dataPost['id']);
		$record_db = $this->file_manager_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);
		$record_have_dkx = $this->file_manager_model->find_where_select([
			'code_contract_disbursement_text' => $record_db['code_contract_disbursement_text'],
			'is_dkx_origin' => true
		], ['code_contract_disbursement_text', 'is_dkx_origin', 'records_receive', 'status_dkx', 'code_store_rc']);
		if (empty($record_have_dkx)) {
			$response = [
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => 'Không tìm thấy hoặc không tồn tại hồ sơ lưu trữ'
			];
			return $this->response($response, REST_Controller::HTTP_OK);
		}
		foreach ($record_have_dkx as $index => $record) {
			if ($record->is_dkx_origin == true) {
				$array_update_new = [
					'is_dkx_origin' => $record['is_dkx_origin'],
					'records_receive' => $record['records_receive'],
					'status_dkx' => $record['status_dkx'],
					'code_store_rc' => $record['code_store_rc'],
					'status' => File_manager_model::STORAGE_COMPLETED
				];
				$array_update_old = [
					'is_dkx_origin' => false,
					'records_receive' => '',
					'status_dkx' => File_manager_model::IS_DKX_AT_RECORD_ANOTHER,
					'code_store_rc' => '',
				];
				$this->file_manager_model->update([
					'_id' => $record_db['_id']
				], $array_update_new);
				$this->file_manager_model->update([
					'_id' => $record['_id']
				], $array_update_old);
				//Insert log
				$array_update_new['ghichu_qlhs'] = 'QLHS cập nhật hồ sơ gốc';
				$log = array(
					"type" => "file_manager",
					"action" => "update_origin",
					"fileReturn_id" => $id,
					"old" => $record_db,
					"new" => $array_update_new,
					"created_at" => $this->createdAt,
					"created_by" => $this->uemail
				);
				$this->log_fileManager_model->insert($log);
				break;
			}
		}
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'Cập nhật thành công'
		];
		return $this->response($response, REST_Controller::HTTP_OK);
	}










}

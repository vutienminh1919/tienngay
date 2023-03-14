<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class File_manager extends MY_Controller
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
		$this->spreadsheet = new Spreadsheet();
		$this->sheet = $this->spreadsheet->getActiveSheet();
		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
		$this->dataPost = $this->input->post();


	}
	const UPDATE_NOTE_YET = 4;

	/**
	 * Get all danh sách hồ sơ gửi về HO
	 */
	public function index_file_manager()
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$this->data["pageName"] = "Danh sách hồ sơ gửi về QLHS";
		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		$code_contract_disbursement = $this->api->apiPost($this->userInfo['token'], "contract/contract_borrowing");
		if (!empty($code_contract_disbursement->status) && $code_contract_disbursement->status == 200) {
			$arr_code_contract_disbursement = [];
			foreach ($code_contract_disbursement->data as $value) {
				if (!empty($value->code_contract_disbursement)) {
					array_push($arr_code_contract_disbursement, $value->code_contract_disbursement);
				}
			}
			$this->data['code_contract_disbursement'] = $arr_code_contract_disbursement;
		} else {
			$this->data['code_contract_disbursement'] = array();
		}
		$countFileReturn = $this->api->apiPost($this->userInfo['token'], "file_manager/get_count_all_sendfile");
		$count = (int)$countFileReturn->data;
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('file_manager/index_file_manager');
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;
		$data["per_page"] = $config['per_page'];
		$data["uriSegment"] = $config['uri_segment'];
		$sendFile = $this->api->apiPost($this->userInfo['token'], "file_manager/get_all_sendFile", $data);
		if (!empty($sendFile->status) && $sendFile->status == 200) {
			foreach ($sendFile->data as $item){
				$data_id = [
					"code_contract_disbursement_text" => $item->code_contract_disbursement_text
				];
				$check_id = $this->api->apiPost($this->userInfo['token'], "contract/store",$data_id);
				$item->store = $check_id->data->store;
				$item->status_hd = $check_id->data->status;
				$item->id_contract = $check_id->data->_id;
				$item->customer_name = $check_id->data->customer_infor->customer_name;
				$item->type_contract = $check_id->data->customer_infor->type_contract_sign ?? '2';
			}
			$this->data['sendFile'] = $sendFile->data;

		} else {
			$this->data['sendFile'] = array();
		}
		$stores = $this->api->apiPost($this->userInfo['token'], "file_manager/get_store_status_active_new");
		$this->data['stores'] = $stores->data;
		$this->data['template'] = 'page/file_manager/file_manager_1';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function index_file_manager_trahstattoan()
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$this->data["pageName"] = "Danh sách hồ sơ trả PGD";
		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}


		$code_contract_disbursement = $this->api->apiPost($this->userInfo['token'], "contract/contract_borrowing");
		if (!empty($code_contract_disbursement->status) && $code_contract_disbursement->status == 200) {
			$arr_code_contract_disbursement = [];
			foreach ($code_contract_disbursement->data as $value) {
				if (!empty($value->code_contract_disbursement)) {
					array_push($arr_code_contract_disbursement, $value->code_contract_disbursement);
				}
			}
			$this->data['code_contract_disbursement'] = $arr_code_contract_disbursement;
		} else {
			$this->data['code_contract_disbursement'] = array();
		}

		$countFileReturn = $this->api->apiPost($this->userInfo['token'], "file_manager/get_count_all_tattoan");

		$count = (int)$countFileReturn->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('file_manager/index_file_manager_trahstattoan');
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;

		$data["per_page"] = $config['per_page'];
		$data["uriSegment"] = $config['uri_segment'];

		$sendFile = $this->api->apiPost($this->userInfo['token'], "file_manager/get_all_sendFile_tattoan", $data);

		if (!empty($sendFile->status) && $sendFile->status == 200) {

			foreach ($sendFile->data as $item){
				$data_id = [
					"code_contract_disbursement_text" => $item->code_contract_disbursement_text
				];
				$check_id = $this->api->apiPost($this->userInfo['token'], "contract/store",$data_id);
				$item->store = $check_id->data->store;
				$item->id_contract = $check_id->data->_id;

				$item->customer_name = $check_id->data->customer_infor->customer_name;

				$item->status_hd = $check_id->data->status;


			}

			$this->data['sendFile'] = $sendFile->data;

		} else {
			$this->data['sendFile'] = array();
		}

		$stores = $this->api->apiPost($this->userInfo['token'], "file_manager/get_store_status_active_new");
		$this->data['stores'] = $stores->data;


		$this->data['template'] = 'page/file_manager/trahstattoan';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}



	public function create_file_manager(){

		$data = $this->input->post();
		$data['code_contract_disbursement_value'] = $this->security->xss_clean($data['code_contract_disbursement_value']);
		$data['code_contract_disbursement_text'] = $this->security->xss_clean($data['code_contract_disbursement_text']);
		$data['file'] = $this->security->xss_clean($data['file']);

		$data['giay_to_khac'] = $this->security->xss_clean($data['giay_to_khac']);

		$data['taisandikem'] = $this->security->xss_clean($data['taisandikem']);
		$data['ghichu'] = $this->security->xss_clean($data['ghichu']);
		$data['fileReturn_img'] = $this->security->xss_clean($data['fileReturn_img']);

		$data_id = [
			"code_contract_disbursement_text" => $data['code_contract_disbursement_text']
		];

		$check_id = $this->api->apiPost($this->userInfo['token'], "contract/store_file_manager",$data_id);

		$sendApi = array(
			'code_contract_disbursement_value' => $data['code_contract_disbursement_value'],
			'code_contract_disbursement_text' => $data['code_contract_disbursement_text'],
			'file' => $data['file'],
			'giay_to_khac' => $data['giay_to_khac'],

			'taisandikem' => $data['taisandikem'],
			'ghichu' => $data['ghichu'],
			'fileReturn_img' => $data['fileReturn_img'],
//			"stores" => $this->userInfo['stores'][count($this->userInfo['stores'])-1]->store_id,
			"stores" => $check_id->data->store->id,
			"status" => "1",

			"created_at" => $this->createdAt,
			"created_by" => $this->userInfo,
		);



		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/process_create_fileReturn", $sendApi);

		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		} else {
			$msg = !empty($return->data->message) ? $return->data->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));

		}

	}

	public function detail(){

		$data = $this->input->get();
		$data['id'] = $this->security->xss_clean($data['id']);
		$condition = array("id" => $data['id']);
			$file_manager_log = $this->api->apiPost($this->userInfo['token'], "file_manager/get_log_one", $condition);
		if (!empty($file_manager_log->status) && $file_manager_log->status == 200) {
			$this->data['file_manager_log'] = $file_manager_log->data;
		} else {
			$this->data['file_manager_log'] = array();
		}
		$code_contract_disbursement = $this->api->apiPost($this->userInfo['token'], "contract/contract_borrowing");
		if (!empty($code_contract_disbursement->status) && $code_contract_disbursement->status == 200) {
			$arr_code_contract_disbursement = [];
			foreach ($code_contract_disbursement->data as $value) {
				if (!empty($value->code_contract_disbursement)) {
					array_push($arr_code_contract_disbursement, $value->code_contract_disbursement);
				}
			}
			$this->data['code_contract_disbursement'] = $arr_code_contract_disbursement;
		} else {
			$this->data['code_contract_disbursement'] = array();
		}
		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$file_manager = $this->api->apiPost($this->userInfo['token'], "file_manager/get_one", array("id" => $data['id']));
		$data_send = [
			"code_contract_disbursement_text" => $file_manager->data->code_contract_disbursement_text
		];
		$contract_db = $this->api->apiPost($this->userInfo['token'], "contract/store", $data_send);
		$file_manager->data->status_hd = $contract_db->data->status;
		if (!empty($file_manager->status) && $file_manager->status == 200) {

			$this->data['file_manager'] = $file_manager->data;
		} else {
			$this->data['file_manager'] = array();
		}
		$log_records = $this->api->apiPost($this->userInfo['token'], 'File_manager/get_log_record_by_id', ['id_record' => $data['id']]);
		if (!empty($log_records->status) && $log_records->status == 200) {

			$this->data['log_records'] = $log_records->data;
		} else {
			$this->data['log_records'] = array();
		}
		$code_contract_text = $this->data['file_manager']->code_contract_disbursement_text ?? '';
		$this->data["pageName"] = "Chi tiết hồ sơ: " . $code_contract_text;
		$this->data['template'] = 'page/file_manager/detail_file_manager';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function cancel_fileReturn(){

		$data = $this->input->post();
		$data['fileReturn_id'] = $this->security->xss_clean($data['fileReturn_id']);

		$data = array(
			"id" => !empty($data['fileReturn_id']) ? $data['fileReturn_id'] : '',
			"created_by" => $this->userInfo,
			"status" => "2"
		);

		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/cancel_fileReturn", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}

	}

	public function showUpdate_fileReturn($id){

		try {
			$id = $this->security->xss_clean($id);
			$condition = array("id" => $id);
			$content = $this->api->apiPost($this->userInfo['token'], "file_manager/get_one_fileReturn", $condition);

			if (!empty($content->data->fileReturn_img)){
				$content->data->image = (array)$content->data->fileReturn_img;
			}
			if (!empty($content->data)){
				$arr = [];
				foreach ((array)$content->data->fileReturn_img as $value) {
					array_push($arr, $value);
				}
			}
			$content->data->image = $arr;

			$this->pushJson('200', json_encode(array("code" => "200", "data" => $content->data)));
		} catch (\Exception $exception) {
			show_404();
		}


	}

	public function update_fileReturn(){

		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['code_contract_disbursement_value'] = $this->security->xss_clean($data['code_contract_disbursement_value']);
		$data['code_contract_disbursement_text'] = $this->security->xss_clean($data['code_contract_disbursement_text']);
		$data['file'] = $this->security->xss_clean($data['file']);
		$data['giay_to_khac'] = $this->security->xss_clean($data['giay_to_khac']);

		$data['taisandikem'] = $this->security->xss_clean($data['taisandikem']);
		$data['ghichu'] = $this->security->xss_clean($data['ghichu']);
		$data['fileReturn_img'] = $this->security->xss_clean($data['fileReturn_img']);

		$sendApi = array(
			"id" => $data['id'],
			'code_contract_disbursement_value' => $data['code_contract_disbursement_value'],
			'code_contract_disbursement_text' => $data['code_contract_disbursement_text'],
			'file' => $data['file'],
			'giay_to_khac' => $data['giay_to_khac'],

			'taisandikem' => $data['taisandikem'],
			'ghichu' => $data['ghichu'],
			'fileReturn_img' => $data['fileReturn_img'],

			"status" => "1",
			"created_by" => $this->userInfo,
		);


		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/process_update_fileReturn", $sendApi);


		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		} else {

			$msg = !empty($return->data->message) ? $return->data->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));

		}

	}

	public function send_file_fileReturn(){

		$data = $this->input->post();
		$data['fileReturn_id'] = $this->security->xss_clean($data['fileReturn_id']);

		$data = array(
			"id" => !empty($data['fileReturn_id']) ? $data['fileReturn_id'] : '',
			"created_by" => $this->userInfo,
			"status" => "3"
		);

		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/send_file_fileReturn", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}

	}

	public function bosunghoso_fileReturn(){


		$data = $this->input->post();
		$data['fileReturn_id'] = $this->security->xss_clean($data['fileReturn_id']);
		$data['ghichu_qlhs'] = $this->security->xss_clean($data['ghichu_qlhs']);

		$data = array(
			"id" => !empty($data['fileReturn_id']) ? $data['fileReturn_id'] : '',
			"ghichu_qlhs" => !empty($data['ghichu_qlhs']) ? $data['ghichu_qlhs'] : '',
			"created_by" => $this->userInfo,
			"status" => "4"
		);

		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/bosunghoso_fileReturn", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}

	}

	public function guibosunghoso_fileReturn(){

		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);

		$data['file'] = $this->security->xss_clean($data['file']);
		$data['giay_to_khac'] = $this->security->xss_clean($data['giay_to_khac']);

		$data['taisandikem'] = $this->security->xss_clean($data['taisandikem']);
		$data['ghichu'] = $this->security->xss_clean($data['ghichu']);
		$data['fileReturn_img'] = $this->security->xss_clean($data['fileReturn_img']);

		$sendApi = array(
			"id" => $data['id'],

			'file' => $data['file'],

			'giay_to_khac' => $data['giay_to_khac'],

			'taisandikem' => $data['taisandikem'],

			'ghichu' => $data['ghichu'],

			'fileReturn_img' => $data['fileReturn_img'],

			"status" => "3",

			"created_by" => $this->userInfo,
		);

		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/guibosunghoso_fileReturn", $sendApi);

		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		} else {
			$msg = !empty($return->data->message) ? $return->data->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));
		}


	}

	public function approve_fileReturn(){

		$data = $this->input->post();
		$data['fileReturn_id'] = $this->security->xss_clean($data['fileReturn_id']);
		$data['ghichu'] = $this->security->xss_clean($data['ghichu']);
		$data['file_img_approve'] = $this->security->xss_clean($data['file_img_approve']);


		$data = array(
			"id" => !empty($data['fileReturn_id']) ? $data['fileReturn_id'] : '',
			"ghichu" => !empty($data['ghichu']) ? $data['ghichu'] : '',
			"file_img_approve" => !empty($data['file_img_approve']) ? $data['file_img_approve'] : '',
			"created_by" => $this->userInfo,
			"status" => "5"
		);

		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/approve_fileReturn", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}

	}

	public function save_fileReturn() {
		$data = $this->input->post();
		$data['fileReturn_id'] = $this->security->xss_clean($data['fileReturn_id']);
		$data['ghichu'] = $this->security->xss_clean($data['ghichu']);
		$data['file_img_approve'] = $this->security->xss_clean($data['file_img_approve']);
		//V2
		$thoa_thuan_ba_ben = !empty($this->security->xss_clean($data['thoa_thuan_ba_ben'])) ? $this->security->xss_clean($data['thoa_thuan_ba_ben']) : 0;
		$bbbg_tai_san = !empty($this->security->xss_clean($data['bbbg_tai_san'])) ? $this->security->xss_clean($data['bbbg_tai_san']) : 0;
		$dang_ky_xe = !empty($this->security->xss_clean($data['dang_ky_xe'])) ? $this->security->xss_clean($data['dang_ky_xe']) : 0;
		$thong_bao = !empty($this->security->xss_clean($data['thong_bao'])) ? $this->security->xss_clean($data['thong_bao']) : 0;
		$hd_mua_ban_xe = !empty($this->security->xss_clean($data['hd_mua_ban_xe'])) ? $this->security->xss_clean($data['hd_mua_ban_xe']) : 0;
		$cam_ket = !empty($this->security->xss_clean($data['cam_ket'])) ? $this->security->xss_clean($data['cam_ket']) : 0;
		$bbbg_thiet_bi_dinh_vi = !empty($this->security->xss_clean($data['bbbg_thiet_bi_dinh_vi'])) ? $this->security->xss_clean($data['bbbg_thiet_bi_dinh_vi']) : 0;
		$bbh_hoi_dong_co_dong = !empty($this->security->xss_clean($data['bbh_hoi_dong_co_dong'])) ? $this->security->xss_clean($data['bbh_hoi_dong_co_dong']) : 0;
		$hop_dong_mua_ban = !empty($this->security->xss_clean($data['hop_dong_mua_ban'])) ? $this->security->xss_clean($data['hop_dong_mua_ban']) : 0;
		$hd_uy_quyen = !empty($this->security->xss_clean($data['hd_uy_quyen'])) ? $this->security->xss_clean($data['hd_uy_quyen']) : 0;
		$hd_chuyen_nhuong = !empty($this->security->xss_clean($data['hd_chuyen_nhuong'])) ? $this->security->xss_clean($data['hd_chuyen_nhuong']) : 0;
		$so_do = !empty($this->security->xss_clean($data['so_do'])) ? $this->security->xss_clean($data['so_do']) : 0;
		$hd_dat_coc = !empty($this->security->xss_clean($data['hd_dat_coc'])) ? $this->security->xss_clean($data['hd_dat_coc']) : 0;
		$phu_luc_gia_han = !empty($this->security->xss_clean($data['phu_luc_gia_han'])) ? $this->security->xss_clean($data['phu_luc_gia_han']) : 0;
		$code_store_rc = !empty($this->security->xss_clean($data['code_store_rc'])) ? $this->security->xss_clean($data['code_store_rc']) : '';
		//Validate khi chưa nhập số lượng HS
		if ($thoa_thuan_ba_ben == 0
			&& $bbbg_tai_san == 0
			&&  $dang_ky_xe == 0
			&& $thong_bao == 0
			&& $hd_mua_ban_xe == 0
			&& $bbbg_thiet_bi_dinh_vi == 0
			&& $bbh_hoi_dong_co_dong == 0
			&& $hop_dong_mua_ban == 0
			&& $hd_uy_quyen == 0
			&& $hd_chuyen_nhuong == 0
			&& $so_do == 0
			&& $hd_dat_coc == 0
			&& $phu_luc_gia_han == 0
		) {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => 'Chưa nhập số lượng hồ sơ để lưu kho!'
			];
			return $this->pushJson('200', json_encode($response));
		}
		$dataSend = array(
			"id" => !empty($data['fileReturn_id']) ? $data['fileReturn_id'] : '',
			"ghichu" => !empty($data['ghichu']) ? $data['ghichu'] : '',
			"file_img_approve" => !empty($data['file_img_approve']) ? $data['file_img_approve'] : '',
			"created_by" => $this->userInfo,
			"status" => "6",
			"thoa_thuan_ba_ben" => $thoa_thuan_ba_ben,
			"bbbg_tai_san" => $bbbg_tai_san,
			"dang_ky_xe" => $dang_ky_xe,
			"thong_bao" => $thong_bao,
			"hd_mua_ban_xe" => $hd_mua_ban_xe,
			"cam_ket" => $cam_ket,
			"bbbg_thiet_bi_dinh_vi" => $bbbg_thiet_bi_dinh_vi,
			"bbh_hoi_dong_co_dong" => $bbh_hoi_dong_co_dong,
			"hop_dong_mua_ban" => $hop_dong_mua_ban,
			"hd_uy_quyen" => $hd_uy_quyen,
			"hd_chuyen_nhuong" => $hd_chuyen_nhuong,
			"so_do" => $so_do,
			"hd_dat_coc" => $hd_dat_coc,
			"phu_luc_gia_han" => $phu_luc_gia_han,
			"code_store_rc" => $code_store_rc
		);

		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/save_fileReturn", $dataSend);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'msg' => $return->message
			];
			return $this->pushJson('200', json_encode($response));
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => 'Lưu kho thất bại!'
			];
			return $this->pushJson('200', json_encode($response));
		}
	}

	public function not_received_fileReturn(){

		$data = $this->input->post();
		$data['fileReturn_id'] = $this->security->xss_clean($data['fileReturn_id']);
		$data['ghichu'] = $this->security->xss_clean($data['ghichu']);
		$data['file_img_approve'] = $this->security->xss_clean($data['file_img_approve']);


		$data = array(
			"id" => !empty($data['fileReturn_id']) ? $data['fileReturn_id'] : '',
			"ghichu" => !empty($data['ghichu']) ? $data['ghichu'] : '',
			"file_img_approve" => !empty($data['file_img_approve']) ? $data['file_img_approve'] : '',
			"created_by" => $this->userInfo,
			"status" => "7"
		);

		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/not_received_fileReturn", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}

	}

	public function return_file_v2_fileReturn(){

		$data = $this->input->post();
		$data['fileReturn_id'] = $this->security->xss_clean($data['fileReturn_id']);
		$data['ghichu'] = $this->security->xss_clean($data['ghichu']);
		$data['file_img_approve'] = $this->security->xss_clean($data['file_img_approve']);


		$data = array(
			"id" => !empty($data['fileReturn_id']) ? $data['fileReturn_id'] : '',
			"ghichu" => !empty($data['ghichu']) ? $data['ghichu'] : '',
			"file_img_approve" => !empty($data['file_img_approve']) ? $data['file_img_approve'] : '',
			"created_by" => $this->userInfo,
			"status" => "8"
		);

		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/return_file_v2_fileReturn", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}

	}

	public function return_v2_fileReturn(){

		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['ghichu'] = $this->security->xss_clean($data['ghichu']);
		$data['fileReturn_img_v2'] = $this->security->xss_clean($data['fileReturn_img_v2']);
		//V2
		$thoa_thuan_ba_ben = !empty($this->security->xss_clean($data['thoa_thuan_ba_ben'])) ? $this->security->xss_clean($data['thoa_thuan_ba_ben']) : 0;
		$bbbg_tai_san = !empty($this->security->xss_clean($data['bbbg_tai_san'])) ? $this->security->xss_clean($data['bbbg_tai_san']) : 0;
		$dang_ky_xe = !empty($this->security->xss_clean($data['dang_ky_xe'])) ? $this->security->xss_clean($data['dang_ky_xe']) : 0;
		$thong_bao = !empty($this->security->xss_clean($data['thong_bao'])) ? $this->security->xss_clean($data['thong_bao']) : 0;
		$hd_mua_ban_xe = !empty($this->security->xss_clean($data['hd_mua_ban_xe'])) ? $this->security->xss_clean($data['hd_mua_ban_xe']) : 0;
		$cam_ket = !empty($this->security->xss_clean($data['cam_ket'])) ? $this->security->xss_clean($data['cam_ket']) : 0;
		$bbbg_thiet_bi_dinh_vi = !empty($this->security->xss_clean($data['bbbg_thiet_bi_dinh_vi'])) ? $this->security->xss_clean($data['bbbg_thiet_bi_dinh_vi']) : 0;
		$bbh_hoi_dong_co_dong = !empty($this->security->xss_clean($data['bbh_hoi_dong_co_dong'])) ? $this->security->xss_clean($data['bbh_hoi_dong_co_dong']) : 0;
		$hop_dong_mua_ban = !empty($this->security->xss_clean($data['hop_dong_mua_ban'])) ? $this->security->xss_clean($data['hop_dong_mua_ban']) : 0;
		$hd_uy_quyen = !empty($this->security->xss_clean($data['hd_uy_quyen'])) ? $this->security->xss_clean($data['hd_uy_quyen']) : 0;
		$hd_chuyen_nhuong = !empty($this->security->xss_clean($data['hd_chuyen_nhuong'])) ? $this->security->xss_clean($data['hd_chuyen_nhuong']) : 0;
		$so_do = !empty($this->security->xss_clean($data['so_do'])) ? $this->security->xss_clean($data['so_do']) : 0;
		$hd_dat_coc = !empty($this->security->xss_clean($data['hd_dat_coc'])) ? $this->security->xss_clean($data['hd_dat_coc']) : 0;
		$phu_luc_gia_han = !empty($this->security->xss_clean($data['phu_luc_gia_han'])) ? $this->security->xss_clean($data['phu_luc_gia_han']) : 0;
		//Validate khi chưa nhập số lượng HS
		if ($thoa_thuan_ba_ben == 0
			&& $bbbg_tai_san == 0
			&&  $dang_ky_xe == 0
			&& $thong_bao == 0
			&& $hd_mua_ban_xe == 0
			&& $bbbg_thiet_bi_dinh_vi == 0
			&& $bbh_hoi_dong_co_dong == 0
			&& $hop_dong_mua_ban == 0
			&& $hd_uy_quyen == 0
			&& $hd_chuyen_nhuong == 0
			&& $so_do == 0
			&& $hd_dat_coc == 0
			&& $phu_luc_gia_han == 0
		) {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => 'Chưa nhập số lượng hồ sơ để trả PGD!'
			];
			return $this->pushJson('200', json_encode($response));
		}
		$sendApi = array(
			"id" => $data['id'],
			'ghichu' => $data['ghichu'],
			'fileReturn_img_v2' => $data['fileReturn_img_v2'],
			"status" => "9",
			"created_by" => $this->userInfo,
			"thoa_thuan_ba_ben" => $thoa_thuan_ba_ben,
			"bbbg_tai_san" => $bbbg_tai_san,
			"dang_ky_xe" => $dang_ky_xe,
			"thong_bao" => $thong_bao,
			"hd_mua_ban_xe" => $hd_mua_ban_xe,
			"cam_ket" => $cam_ket,
			"bbbg_thiet_bi_dinh_vi" => $bbbg_thiet_bi_dinh_vi,
			"bbh_hoi_dong_co_dong" => $bbh_hoi_dong_co_dong,
			"hop_dong_mua_ban" => $hop_dong_mua_ban,
			"hd_uy_quyen" => $hd_uy_quyen,
			"hd_chuyen_nhuong" => $hd_chuyen_nhuong,
			"so_do" => $so_do,
			"hd_dat_coc" => $hd_dat_coc,
			"phu_luc_gia_han" => $phu_luc_gia_han
		);
		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/return_v2_fileReturn", $sendApi);
		if (!empty($return->status) && $return->status == 200) {
			$response_js = [
				'res' => true,
				'status' => "200",
				'msg' => $return->message
			];
			return $this->pushJson('200', json_encode($response_js));
		} else {
			$response_js = [
				'res' => false,
				'status' => "400",
				'msg' => $return->message ?? 'Trả hồ sơ thất bại!'
			];
			return $this->pushJson('200', json_encode($response_js));
		}
	}

	public function cvkd_ycbs_fileReturn(){

		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);

		$data['file'] = $this->security->xss_clean($data['file']);

		$data['giay_to_khac'] = $this->security->xss_clean($data['giay_to_khac']);

		$data['taisandikem'] = $this->security->xss_clean($data['taisandikem']);
		$data['ghichu'] = $this->security->xss_clean($data['ghichu']);
		$data['fileReturn_img'] = $this->security->xss_clean($data['fileReturn_img_cvkd']);

		$sendApi = array(
			"id" => $data['id'],

			'file' => $data['file'],
			'giay_to_khac' => $data['giay_to_khac'],

			'taisandikem' => $data['taisandikem'],
			'ghichu' => $data['ghichu'],
			'fileReturn_img' => $data['fileReturn_img'],

			"status" => "10",

			"created_by" => $this->userInfo,
		);


		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/cvkd_ycbs_fileReturn", $sendApi);

		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		} else {

			$msg = !empty($return->data->message) ? $return->data->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));

		}

	}

	private function pushJson($code, $data)
	{
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}

	public function trahososautattoan_fileReturn(){

		$data = $this->input->post();
		$data['fileReturn_id'] = $this->security->xss_clean($data['fileReturn_id']);
		$data['ghichu'] = $this->security->xss_clean($data['ghichu']);
		$data['file_img_approve'] = $this->security->xss_clean($data['file_img_approve']);


		$data = array(
			"id" => !empty($data['fileReturn_id']) ? $data['fileReturn_id'] : '',
			"ghichu" => !empty($data['ghichu']) ? $data['ghichu'] : '',
			"file_img_approve" => !empty($data['file_img_approve']) ? $data['file_img_approve'] : '',
			"created_by" => $this->userInfo,
			"status" => "11"
		);

		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/trahososautattoan_fileReturn", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}

	}

	public function search(){

		$data = [];
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$code_contract_disbursement_search = !empty($_GET['code_contract_disbursement_search']) ? $_GET['code_contract_disbursement_search'] : "";
		$this->data['pageName'] = 'Tìm kiếm hồ sơ ' . $code_contract_disbursement_search;
		if (!empty($store)) {
			$data['store'] = $store;
		}
		if (!empty($fdate)) {
			$data['fdate'] = $fdate;
		}
		if (!empty($tdate)) {
			$data['tdate'] = $tdate;
		}
		if (!empty($status)) {
			$data['status'] = $status;
		}
		if (!empty($code_contract_disbursement_search)) {
			$data['code_contract_disbursement_search'] = $code_contract_disbursement_search;
		}

		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$stores = $this->api->apiPost($this->userInfo['token'], "file_manager/get_store_status_active_new");
		$this->data['stores'] = $stores->data;

		$code_contract_disbursement = $this->api->apiPost($this->userInfo['token'], "contract/contract_borrowing");
		if (!empty($code_contract_disbursement->status) && $code_contract_disbursement->status == 200) {
			$arr_code_contract_disbursement = [];
			foreach ($code_contract_disbursement->data as $value) {
				if (!empty($value->code_contract_disbursement)) {
					array_push($arr_code_contract_disbursement, $value->code_contract_disbursement);
				}
			}
			$this->data['code_contract_disbursement'] = $arr_code_contract_disbursement;
		} else {
			$this->data['code_contract_disbursement'] = array();
		}


		$countFileReturn = $this->api->apiPost($this->userInfo['token'], "file_manager/get_count_all_sendfile",$data);

		$count = (int)$countFileReturn->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('file_manager/search?fdate=' . $fdate . '&tdate=' . $tdate .'&status=' . $status .'&store=' . $store .'&code_contract_disbursement_search=' . $code_contract_disbursement_search );
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;

		$data["per_page"] = $config['per_page'];
		$data["uriSegment"] = $config['uri_segment'];


		$sendFile = $this->api->apiPost($this->userInfo['token'], "file_manager/get_all_sendFile", $data);

		if (!empty($sendFile->status) && $sendFile->status == 200) {

			foreach ($sendFile->data as $item){
				$data_id = [
					"code_contract_disbursement_text" => $item->code_contract_disbursement_text
				];
				$check_id = $this->api->apiPost($this->userInfo['token'], "contract/store",$data_id);
				$item->store = $check_id->data->store;
				$item->id_contract = $check_id->data->_id;
				$item->status_hd = $check_id->data->status;
				$item->customer_name = $check_id->data->customer_infor->customer_name;

			}

			$this->data['sendFile'] = $sendFile->data;

		} else {
			$this->data['sendFile'] = array();
		}

		$this->data['template'] = 'page/file_manager/file_manager_1';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);


	}

	public function search_tattoan(){
		$data = [];
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$code_contract_disbursement_search = !empty($_GET['code_contract_disbursement_search']) ? $_GET['code_contract_disbursement_search'] : "";

		if (!empty($store)) {
			$data['store'] = $store;
		}
		if (!empty($fdate)) {
			$data['fdate'] = $fdate;
		}
		if (!empty($tdate)) {
			$data['tdate'] = $tdate;
		}
		if (!empty($status)) {
			$data['status'] = $status;
		}
		if (!empty($code_contract_disbursement_search)) {
			$data['code_contract_disbursement_search'] = $code_contract_disbursement_search;
		}

		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$stores = $this->api->apiPost($this->userInfo['token'], "file_manager/get_store_status_active_new");
		$this->data['stores'] = $stores->data;

		$code_contract_disbursement = $this->api->apiPost($this->userInfo['token'], "contract/contract_borrowing");
		if (!empty($code_contract_disbursement->status) && $code_contract_disbursement->status == 200) {
			$arr_code_contract_disbursement = [];
			foreach ($code_contract_disbursement->data as $value) {
				if (!empty($value->code_contract_disbursement)) {
					array_push($arr_code_contract_disbursement, $value->code_contract_disbursement);
				}
			}
			$this->data['code_contract_disbursement'] = $arr_code_contract_disbursement;
		} else {
			$this->data['code_contract_disbursement'] = array();
		}


		$countFileReturn = $this->api->apiPost($this->userInfo['token'], "file_manager/get_count_all_tattoan",$data);

		$count = (int)$countFileReturn->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('file_manager/search_tattoan?fdate=' . $fdate . '&tdate=' . $tdate .'&status=' . $status .'&store=' . $store .'&code_contract_disbursement_search=' . $code_contract_disbursement_search);
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;

		$data["per_page"] = $config['per_page'];
		$data["uriSegment"] = $config['uri_segment'];

		$sendFile = $this->api->apiPost($this->userInfo['token'], "file_manager/get_all_sendFile_tattoan", $data);

		if (!empty($sendFile->status) && $sendFile->status == 200) {

			foreach ($sendFile->data as $item){
				$data_id = [
					"code_contract_disbursement_text" => $item->code_contract_disbursement_text
				];
				$check_id = $this->api->apiPost($this->userInfo['token'], "contract/store",$data_id);
				$item->store = $check_id->data->store;
				$item->id_contract = $check_id->data->_id;
				$item->customer_name = $check_id->data->customer_infor->customer_name;
				$item->status_hd = $check_id->data->status;
			}

			$this->data['sendFile'] = $sendFile->data;

		} else {
			$this->data['sendFile'] = array();
		}

		$this->data['template'] = 'page/file_manager/trahstattoan';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function all(){

		date_default_timezone_set('UTC');

		if (empty( $this->userInfo)) {
			redirect(base_url());
			return;
		}

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');

		$config['base_url'] = base_url('file_manager/all');

		$config['per_page'] = 25;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;

		$data = array(
			"per_page" => $config['per_page'],
			"uriSegment" => $config['uri_segment']
		);

		$return = $this->api->apiPost( $this->userInfo['token'], "user/getNotificationBorrow",$data);

		if (!empty($return->status) && $return->status == 200) {
			$config['total_rows'] = $return->total;
			$this->data['total_rows'] = $return->total;

			$this->data['notifications'] = $return->data;
			foreach ($this->data['notifications'] as $n) {
				$n->date = $this->time_model->convertTimestampToDatetime((int)$n->created_at);
			}
		} else {
			$this->data['notifications'] = [];
		}

		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/file_manager/all';
		$this->load->view('template', isset($this->data)?$this->data:NULL);
		return;


	}

	public function index_borrowed()
	{
		$this->data['pageName'] = 'Quản lý danh sách mượn/trả hồ sơ';
		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$groupRoles_store = $this->api->apiPost($this->user['token'], "groupRole/get_all");
		if (!empty($groupRoles_store->status) && $groupRoles_store->status == 200) {
			$this->data['groupRoles_store'] = $groupRoles_store->data;
		} else {
			$this->data['groupRoles_store'] = array();
		}
		$role_nv_qlkv = $this->api->apiPost($this->userInfo['token'], "Role/get_id_nv_qlkv_all");
		if (!empty($role_nv_qlkv->status) && $role_nv_qlkv->status == 200) {
			$this->data['role_nv_qlkv'] = $role_nv_qlkv->data;
		} else {
			$this->data['role_nv_qlkv'] = $role_nv_qlkv->data;
		}
		$code_contract_disbursement = $this->api->apiPost($this->userInfo['token'], "contract/contract_borrowing");

		if (!empty($code_contract_disbursement->status) && $code_contract_disbursement->status == 200) {
			$arr_code_contract_disbursement = [];
			foreach ($code_contract_disbursement->data as $value) {
				if (!empty($value->code_contract_disbursement)) {
					array_push($arr_code_contract_disbursement, $value->code_contract_disbursement);
				}
			}
			$this->data['code_contract_disbursement'] = $arr_code_contract_disbursement;
		} else {
			$this->data['code_contract_disbursement'] = array();
		}


		$countBorrowed = $this->api->apiPost($this->userInfo['token'], "file_manager/get_count_all");

		$count = (int)$countBorrowed->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('file_manager/index_borrowed');
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;
		$data = array(
			"per_page" => $config['per_page'],
			"uriSegment" => $config['uri_segment']
		);

		$borrowed = $this->api->apiPost($this->userInfo['token'], "file_manager/get_all", $data);

		if (!empty($borrowed->status) && $borrowed->status == 200) {

			foreach ($borrowed->data as $item){
				$data_id = [
					"code_contract_disbursement_text" => $item->code_contract_disbursement_text
				];
				$dataSend = ['code_contract_disbursement' => $item->code_contract_disbursement_text];
				$check_id = $this->api->apiPost($this->userInfo['token'], "contract/store",$data_id);
				$records = $this->api->apiPost($this->userInfo['token'],'File_manager/get_one_records_by_contract', $dataSend);
				$item->store = $check_id->data->store;
				$item->id_contract = $check_id->data->_id;
				$item->customer_name = $check_id->data->customer_infor->customer_name;
				$item->status_hd = $check_id->data->status;
				$item->status_dkx = !empty($records->data->status_dkx) ? $records->data->status_dkx : self::UPDATE_NOTE_YET;
			}

			$this->data['borrowed'] = $borrowed->data;

		} else {
			$this->data['borrowed'] = array();
		}
		$stores = $this->api->apiPost($this->userInfo['token'], "file_manager/get_store_status_active_new");
		$this->data['stores'] = $stores->data;
		$this->data['template'] = 'page/file_manager/borrowed';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function index_quahan()
	{

		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$countBorrowed = $this->api->apiPost($this->userInfo['token'], "file_manager/get_count_all_quahan");

		$count = (int)$countBorrowed->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('file_manager/index_quahan');
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;
		$data = array(
			"per_page" => $config['per_page'],
			"uriSegment" => $config['uri_segment']
		);

		$borrowed = $this->api->apiPost($this->userInfo['token'], "file_manager/get_all_checkquahan", $data);

		if (!empty($borrowed->status) && $borrowed->status == 200) {

			foreach ($borrowed->data as $item){
				$data_id = [
					"code_contract_disbursement_text" => $item->code_contract_disbursement_text
				];
				$check_id = $this->api->apiPost($this->userInfo['token'], "contract/store",$data_id);

				$item->store = $check_id->data->store;
				$item->id_contract = $check_id->data->_id;


				if ($this->createdAt > $item->borrowed_end){
					$check_date = abs($this->createdAt - $item->borrowed_end);
					$years = floor($check_date / (365 * 60 * 60 * 24));
					$months = floor(($check_date - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
					$days = floor(($check_date - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

					$item->days_am = $days;
				}

				if ($this->createdAt < $item->borrowed_end){
					$check_date = abs($item->borrowed_end - $this->createdAt);
					$years = floor($check_date / (365 * 60 * 60 * 24));
					$months = floor(($check_date - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
					$days = floor(($check_date - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

					$item->days_duong = $days;
				}
			}

			$this->data['borrowed'] = $borrowed->data;

		} else {
			$this->data['borrowed'] = array();
		}


		$this->data['template'] = 'page/file_manager/list_hanmuonhs';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}


	public function create_borrowed(){

		$data = $this->input->post();
		$data['code_contract_disbursement_value'] = $this->security->xss_clean($data['code_contract_disbursement_value']);
		$data['code_contract_disbursement_text'] = $this->security->xss_clean($data['code_contract_disbursement_text']);
		$data['file'] = $this->security->xss_clean($data['file']);
		$data['groupRoles_store'] = $this->security->xss_clean($data['groupRoles_store']);

		$data['giay_to_khac'] = $this->security->xss_clean($data['giay_to_khac']);
		$data['borrowed_start'] = $this->security->xss_clean($data['borrowed_start']);
		$data['borrowed_end'] = $this->security->xss_clean($data['borrowed_end']);
		$data['ghichu'] = $this->security->xss_clean($data['ghichu']);
		$data['lydomuon'] = $this->security->xss_clean($data['lydomuon']);
		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$group_role = $groupRoles->data;
		} else {
			$group_role = array();
		}

		$check_group_role = true;
		if ($data['groupRoles_store'] == "Thu hồi nợ") {
			if (!in_array('thu-hoi-no', $group_role)) {
				$check_group_role = false;
			}
		} elseif ($data['groupRoles_store'] == "Cửa hàng trưởng") {
			if (!in_array('cua-hang-truong', $group_role)) {
				$check_group_role = false;
			}
		} elseif ($data['groupRoles_store'] == "An ninh điều tra") {
			if (!in_array('an-ninh-dieu-tra', $group_role)) {
				$check_group_role = false;
			}
		} elseif ($data['groupRoles_store'] == "Kiểm soát nội bộ") {
			if (!in_array('kiem-soat-noi-bo', $group_role)) {
				$check_group_role = false;
			}
		}
		if ($check_group_role == false) {
			$response_js = [
				'status' => '400',
				'msg' => 'Phòng ban không chính xác!'
			];
			return $this->pushJson('200', json_encode($response_js));
		}
		$data_id = [
			"code_contract_disbursement_text" => $data['code_contract_disbursement_text']
		];
		$check_id = $this->api->apiPost($this->userInfo['token'], "contract/store_file_manager",$data_id);
		$records_db = $this->api->apiPost($this->userInfo['token'], 'File_manager/check_dkx_origin', ['code_contract_disbursement' => $data['code_contract_disbursement_text'][0]]);
		$contract_db = $this->api->apiPost($this->userInfo['token'], "File_manager/get_one_contract_by_records",['code_contract_disbursement' => $data['code_contract_disbursement_text'][0]]);
		$asset_text = '';
		$code_property = $contract_db->data->loan_infor->type_property->code;
		if ($code_property == 'NĐ') {
			$asset_text = 'sổ đỏ/GCNQSDĐ';
		} else {
			$asset_text = 'đăng ký xe';
		}
		//Check nếu không có ĐKX bản gốc/Sổ đỏ sẽ không mượn được hồ sơ
		if (isset($records_db->status) && $records_db->status == 400) {
			if ($records_db->isDkx == false) {
				$response_js = [
					'status' => '400',
					'msg' => 'Hồ sơ đang không lưu ' . $asset_text . ' bản gốc!'
				];
				return $this->pushJson('200', json_encode($response_js));
			}
		}
		$sendApi = array(
			'code_contract_disbursement_value' => $data['code_contract_disbursement_value'],
			'code_contract_disbursement_text' => $data['code_contract_disbursement_text'],
			'file' => $data['file'],
			'giay_to_khac' => $data['giay_to_khac'],
			'borrowed_start' => $data['borrowed_start'],
			'borrowed_end' => $data['borrowed_end'],
			'groupRoles_store' => $data['groupRoles_store'],
			'lydomuon' => $data['lydomuon'],

			'ghichu' => $data['ghichu'],

//			"stores" => $this->userInfo['stores'][0]->store_id,
			"stores" => $check_id->data->store->id,
			"status" => "1",

			"created_at" => $this->createdAt,
			"created_by" => $this->userInfo,
		);

		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/process_create_borrowed", $sendApi);

		if (!empty($return) && $return->status == 200) {
			$response_js = [
				'status' => '200',
				'msg' => $return->message
			];
		} else {
			$msg = !empty($return->data->message) ? $return->data->message : $return->message;
			$response_js = [
				'status' => '400',
				'msg' => $msg
			];
		}
		return $this->pushJson('200', json_encode($response_js));
	}

	public function detail_borrowed(){

		$data = $this->input->get();
		$data['id'] = $this->security->xss_clean($data['id']);
		$condition = array("id" => $data['id']);
		$borrowed_log = $this->api->apiPost($this->userInfo['token'], "file_manager/get_log_one_borrowed", $condition);
		if (!empty($borrowed_log->status) && $borrowed_log->status == 200) {
			$this->data['borrowed_log'] = $borrowed_log->data;
		} else {
			$this->data['borrowed_log'] = array();
		}

		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$groupRoles_store = $this->api->apiPost($this->user['token'], "groupRole/get_all");
		if (!empty($groupRoles_store->status) && $groupRoles_store->status == 200) {
			$this->data['groupRoles_store'] = $groupRoles_store->data;
		} else {
			$this->data['groupRoles_store'] = array();
		}
		$role_nv_qlkv = $this->api->apiPost($this->userInfo['token'], "Role/get_id_nv_qlkv_all");
		if (!empty($role_nv_qlkv->status) && $role_nv_qlkv->status == 200) {
			$this->data['role_nv_qlkv'] = $role_nv_qlkv->data;
		} else {
			$this->data['role_nv_qlkv'] = $role_nv_qlkv->data;
		}

		$code_contract_disbursement = $this->api->apiPost($this->userInfo['token'], "file_manager/check_file_manager");
		if (!empty($code_contract_disbursement->status) && $code_contract_disbursement->status == 200) {
			$arr = [];
			foreach ($code_contract_disbursement->data as $value){
				array_push($arr, $value->code_contract_disbursement_text);
			}
			$this->data['code_contract_disbursement'] = $arr;
		} else {
			$this->data['code_contract_disbursement'] = array();
		}

		$borrowed = $this->api->apiPost($this->userInfo['token'], "file_manager/get_one_borrowed", array("id" => $data['id']));
		$dataSendApi = ['code_contract_disbursement' => $borrowed->data->code_contract_disbursement_text];
		$contract_record = $this->api->apiPost($this->userInfo['token'],'File_manager/get_one_contract_by_records', $dataSendApi);
		$borrowed->data->status_hd = !empty($contract_record->data->status) ? $contract_record->data->status : '';
		if (!empty($borrowed->status) && $borrowed->status == 200) {

			$this->data['borrowed'] = $borrowed->data;
		} else {
			$this->data['borrowed'] = array();
		}
		$code_contract_text = $this->data['borrowed']->code_contract_disbursement_text ?? '';
		$this->data['pageName'] = 'Chi tiết hồ sơ mượn/trả: ' . $code_contract_text;
		$this->data['template'] = 'page/file_manager/detail_file_manager_borrowed';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function cancel_borrowed(){

		$data = $this->input->post();
		$data['borrowed_id'] = $this->security->xss_clean($data['fileReturn_id']);

		$data = array(
			"id" => !empty($data['borrowed_id']) ? $data['borrowed_id'] : '',
			"created_by" => $this->userInfo,
			"status" => "2"
		);

		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/cancel_borrowed", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}

	}

	public function showUpdate_borrowed($id){
		try {
			$id = $this->security->xss_clean($id);
			$condition = array("id" => $id);

			$content = $this->api->apiPost($this->userInfo['token'], "file_manager/get_one_borrowed", $condition);

			if (!empty($content)){
				$content->data->borrowed_start = date("d-m-Y", $content->data->borrowed_start);
				$content->data->borrowed_end = date("d-m-Y", $content->data->borrowed_end);
			}

			$this->pushJson('200', json_encode(array("code" => "200", "data" => $content->data)));
		} catch (\Exception $exception) {
			show_404();
		}
	}

	public function showExtendBorrowed($id)
	{
		try {


			$id = $this->security->xss_clean($id);
			$condition = array("id" => $id);

			$content = $this->api->apiPost($this->userInfo['token'], "file_manager/get_one_extend_borrowed", $condition);
			$arr = [];
			if (!empty($content)) {
				if (!empty($content->data->file_img_approve)) {
					foreach ($content->data->file_img_approve as $value) {
						array_push($arr, $value);
					}
				}
				$content->data->file_img_approve = $arr;
			}

			$this->pushJson('200', json_encode(array("code" => "200", "data" => $content->data)));
		} catch (\Exception $exception) {
			show_404();
		}
	}

	public function approveExtendBorrowed(){

		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['fileReturn_id']);
		$data['update_time_borrowed_approve'] = $this->security->xss_clean($data['update_time_borrowed_approve']);

		$data = array(
			"id" => !empty($data['id']) ? $data['id'] : '',
			"update_time_borrowed_approve" => !empty($data['update_time_borrowed_approve']) ? $data['update_time_borrowed_approve'] : '',
			"status" => "12"
		);

		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/approveExtendBorrowed", $data);

		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		} else {

			$msg = !empty($return->message) ? $return->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));

		}


	}

	public function update_borrowed(){

		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['code_contract_disbursement_value'] = $this->security->xss_clean($data['code_contract_disbursement_value']);
		$data['code_contract_disbursement_text'] = $this->security->xss_clean($data['code_contract_disbursement_text']);
		$data['file'] = $this->security->xss_clean($data['file']);
		$data['giay_to_khac'] = $this->security->xss_clean($data['giay_to_khac']);


		$data['ghichu'] = $this->security->xss_clean($data['ghichu']);
		$data['borrowed_start'] = $this->security->xss_clean($data['borrowed_start']);
		$data['borrowed_end'] = $this->security->xss_clean($data['borrowed_end']);
		$data['groupRoles_store'] = $this->security->xss_clean($data['groupRoles_store']);
		$data['lydomuon'] = $this->security->xss_clean($data['lydomuon']);


		$sendApi = array(
			"id" => $data['id'],
			'code_contract_disbursement_value' => $data['code_contract_disbursement_value'],
			'code_contract_disbursement_text' => $data['code_contract_disbursement_text'],
			'file' => $data['file'],
			'giay_to_khac' => $data['giay_to_khac'],

			'ghichu' => $data['ghichu'],
			'borrowed_start' => $data['borrowed_start'],
			'borrowed_end' => $data['borrowed_end'],
			'groupRoles_store' => $data['groupRoles_store'],
			'lydomuon' => $data['lydomuon'],

			"created_by" => $this->userInfo,
		);


		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/process_update_borrowed", $sendApi);


		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		} else {

			$msg = !empty($return->data->message) ? $return->data->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));

		}

	}

	public function asm_borrowed(){

		$data = $this->input->post();
		$data['borrowed_id'] = $this->security->xss_clean($data['fileReturn_id']);

		$data = array(
			"id" => !empty($data['borrowed_id']) ? $data['borrowed_id'] : '',
			"created_by" => $this->userInfo,
			"status" => "3"
		);

		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/asm_borrowed", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}

	}

	public function qlhs_borrowed(){
		$data = $this->input->post();
		$data['borrowed_id'] = $this->security->xss_clean($data['fileReturn_id']);
		$data['ghichu'] = $this->security->xss_clean($data['ghichu']);
		$data['file_img_approve'] = $this->security->xss_clean($data['file_img_approve']);

		$data = array(
			"id" => !empty($data['borrowed_id']) ? $data['borrowed_id'] : '',
			"ghichu" => !empty($data['ghichu']) ? $data['ghichu'] : '',
			"file_img_approve" => !empty($data['file_img_approve']) ? $data['file_img_approve'] : '',
			"created_by" => $this->userInfo,
			"status" => "4"
		);

		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/qlhs_borrowed", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}
	}

	public function qlhs_trahoso_borrowed(){

		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);

		$data['ghichu'] = $this->security->xss_clean($data['ghichu']);



		$sendApi = array(
			"id" => $data['id'],

			'ghichu' => $data['ghichu'],

			"created_by" => $this->userInfo,
		);


		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/qlhs_trahoso_borrowed", $sendApi);


		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		} else {

			$msg = !empty($return->data->message) ? $return->data->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));

		}

	}

	public function approve_borrowed(){

		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);

		$data['ghichu'] = $this->security->xss_clean($data['ghichu']);
		$data['fileApprove_img'] = $this->security->xss_clean($data['fileApprove_img']);



		$sendApi = array(
			"id" => $data['id'],
			'ghichu' => $data['ghichu'],
			'fileApprove_img' => $data['fileApprove_img'],
			"created_by" => $this->userInfo,
		);


		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/approve_borrowed", $sendApi);


		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		} else {

			$msg = !empty($return->data->message) ? $return->data->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));

		}

	}

	public function borrowed_danhanhoso(){

		$data = $this->input->post();
		$data['borrowed_id'] = $this->security->xss_clean($data['fileReturn_id']);
		$data['ghichu'] = $this->security->xss_clean($data['ghichu']);
		$data['file_img_approve'] = $this->security->xss_clean($data['file_img_approve']);

		$data = array(
			"id" => !empty($data['borrowed_id']) ? $data['borrowed_id'] : '',
			"ghichu" => !empty($data['ghichu']) ? $data['ghichu'] : '',
			"file_img_approve" => !empty($data['file_img_approve']) ? $data['file_img_approve'] : '',
			"created_by" => $this->userInfo,
			"status" => "7"
		);

		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/borrowed_danhanhoso", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}

	}

	public function borrowed_trahskhachhangtattoan(){

		$data = $this->input->post();
		$data['borrowed_id'] = $this->security->xss_clean($data['fileReturn_id']);
		$data['ghichu'] = $this->security->xss_clean($data['ghichu']);
		$data['file_img_approve'] = $this->security->xss_clean($data['file_img_approve']);

		$data = array(
			"id" => !empty($data['borrowed_id']) ? $data['borrowed_id'] : '',
			"ghichu" => !empty($data['ghichu']) ? $data['ghichu'] : '',
			"file_img_approve" => !empty($data['file_img_approve']) ? $data['file_img_approve'] : '',
			"created_by" => $this->userInfo,
			"status" => "13"
		);

		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/borrowed_trahskhachhangtattoan", $data);

		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		} else {

			$msg = !empty($return->message) ? $return->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));

		}


	}

	public function borrowed_giahanthoigianmuon(){

		$data = $this->input->post();
		$data['borrowed_id'] = $this->security->xss_clean($data['fileReturn_id']);
		$data['ghichu'] = $this->security->xss_clean($data['ghichu']);
		$data['file_img_approve'] = $this->security->xss_clean($data['file_img_approve']);
		$data['update_time_borrowed'] = $this->security->xss_clean($data['update_time_borrowed']);

		$data = array(
			"id" => !empty($data['borrowed_id']) ? $data['borrowed_id'] : '',
			"ghichu" => !empty($data['ghichu']) ? $data['ghichu'] : '',
			"file_img_approve" => !empty($data['file_img_approve']) ? $data['file_img_approve'] : '',
			"update_time_borrowed" => !empty($data['update_time_borrowed']) ? $data['update_time_borrowed'] : '',
			"created_by" => $this->userInfo['email'],
			"status" => "15"
		);

		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/borrowed_giahanthoigianmuon", $data);

		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		} else {

			$msg = !empty($return->message) ? $return->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));

		}
	}

	public function borrowed_xacnhankhdatattoan(){

		$data = $this->input->post();
		$data['borrowed_id'] = $this->security->xss_clean($data['fileReturn_id']);
		$data['ghichu'] = $this->security->xss_clean($data['ghichu']);
		$data['file_img_approve'] = $this->security->xss_clean($data['file_img_approve']);
		//V2
		$thoa_thuan_ba_ben = !empty($this->security->xss_clean($data['thoa_thuan_ba_ben'])) ? $this->security->xss_clean($data['thoa_thuan_ba_ben']) : 0;
		$bbbg_tai_san = !empty($this->security->xss_clean($data['bbbg_tai_san'])) ? $this->security->xss_clean($data['bbbg_tai_san']) : 0;
		$dang_ky_xe = !empty($this->security->xss_clean($data['dang_ky_xe'])) ? $this->security->xss_clean($data['dang_ky_xe']) : 0;
		$thong_bao = !empty($this->security->xss_clean($data['thong_bao'])) ? $this->security->xss_clean($data['thong_bao']) : 0;
		$hd_mua_ban_xe = !empty($this->security->xss_clean($data['hd_mua_ban_xe'])) ? $this->security->xss_clean($data['hd_mua_ban_xe']) : 0;
		$cam_ket = !empty($this->security->xss_clean($data['cam_ket'])) ? $this->security->xss_clean($data['cam_ket']) : 0;
		$bbbg_thiet_bi_dinh_vi = !empty($this->security->xss_clean($data['bbbg_thiet_bi_dinh_vi'])) ? $this->security->xss_clean($data['bbbg_thiet_bi_dinh_vi']) : 0;
		$bbh_hoi_dong_co_dong = !empty($this->security->xss_clean($data['bbh_hoi_dong_co_dong'])) ? $this->security->xss_clean($data['bbh_hoi_dong_co_dong']) : 0;
		$hop_dong_mua_ban = !empty($this->security->xss_clean($data['hop_dong_mua_ban'])) ? $this->security->xss_clean($data['hop_dong_mua_ban']) : 0;
		$hd_uy_quyen = !empty($this->security->xss_clean($data['hd_uy_quyen'])) ? $this->security->xss_clean($data['hd_uy_quyen']) : 0;
		$hd_chuyen_nhuong = !empty($this->security->xss_clean($data['hd_chuyen_nhuong'])) ? $this->security->xss_clean($data['hd_chuyen_nhuong']) : 0;
		$so_do = !empty($this->security->xss_clean($data['so_do'])) ? $this->security->xss_clean($data['so_do']) : 0;
		$hd_dat_coc = !empty($this->security->xss_clean($data['hd_dat_coc'])) ? $this->security->xss_clean($data['hd_dat_coc']) : 0;
		$phu_luc_gia_han = !empty($this->security->xss_clean($data['phu_luc_gia_han'])) ? $this->security->xss_clean($data['phu_luc_gia_han']) : 0;
		//Validate khi chưa nhập số lượng HS
		if ($thoa_thuan_ba_ben == 0
			&& $bbbg_tai_san == 0
			&&  $dang_ky_xe == 0
			&& $thong_bao == 0
			&& $hd_mua_ban_xe == 0
			&& $bbbg_thiet_bi_dinh_vi == 0
			&& $bbh_hoi_dong_co_dong == 0
			&& $hop_dong_mua_ban == 0
			&& $hd_uy_quyen == 0
			&& $hd_chuyen_nhuong == 0
			&& $so_do == 0
			&& $hd_dat_coc == 0
			&& $phu_luc_gia_han == 0
		) {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => 'Chưa nhập số lượng hồ sơ để trả PGD!'
			];
			return $this->pushJson('200', json_encode($response));
		}
		$data = array(
			"id" => !empty($data['borrowed_id']) ? $data['borrowed_id'] : '',
			"ghichu" => !empty($data['ghichu']) ? $data['ghichu'] : '',
			"file_img_approve" => !empty($data['file_img_approve']) ? $data['file_img_approve'] : '',
			"created_by" => $this->userInfo,
			"status" => "14",
			"thoa_thuan_ba_ben" => $thoa_thuan_ba_ben,
			"bbbg_tai_san" => $bbbg_tai_san,
			"dang_ky_xe" => $dang_ky_xe,
			"thong_bao" => $thong_bao,
			"hd_mua_ban_xe" => $hd_mua_ban_xe,
			"cam_ket" => $cam_ket,
			"bbbg_thiet_bi_dinh_vi" => $bbbg_thiet_bi_dinh_vi,
			"bbh_hoi_dong_co_dong" => $bbh_hoi_dong_co_dong,
			"hop_dong_mua_ban" => $hop_dong_mua_ban,
			"hd_uy_quyen" => $hd_uy_quyen,
			"hd_chuyen_nhuong" => $hd_chuyen_nhuong,
			"so_do" => $so_do,
			"hd_dat_coc" => $hd_dat_coc,
			"phu_luc_gia_han" => $phu_luc_gia_han
		);
		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/borrowed_xacnhankhdatattoan", $data);

		if (!empty($return) && $return->status == 200) {
			$response = [
				'status' => "200",
				'msg' => 'Xác nhận thành công!'
			];
		} else {
			$msg = !empty($return->message) ? $return->message : $return->message;
			$response = [
				'status' => "400",
				'msg' => $msg
			];
		}
		return $this->pushJson('200', json_encode($response));

	}

	public function return_borrowed(){


		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);

		$data['ghichu'] = $this->security->xss_clean($data['ghichu']);
		$data['fileReturn_img'] = $this->security->xss_clean($data['fileReturn_img']);


		$sendApi = array(
			"id" => $data['id'],
			'ghichu' => $data['ghichu'],
			'fileReturn_img' => $data['fileReturn_img'],
			"created_by" => $this->userInfo,
		);


		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/return_borrowed", $sendApi);


		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		} else {

			$msg = !empty($return->data->message) ? $return->data->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));

		}

	}

	public function borrowed_trahsdamuon(){

		$data = $this->input->post();
		$data['borrowed_id'] = $this->security->xss_clean($data['fileReturn_id']);
		$data['ghichu'] = $this->security->xss_clean($data['ghichu']);
		$data['file_img_approve'] = $this->security->xss_clean($data['file_img_approve']);

		$data = array(
			"id" => !empty($data['borrowed_id']) ? $data['borrowed_id'] : '',
			"ghichu" => !empty($data['ghichu']) ? $data['ghichu'] : '',
			"file_img_approve" => !empty($data['file_img_approve']) ? $data['file_img_approve'] : '',
			"created_by" => $this->userInfo,
			"status" => "9"
		);

		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/borrowed_trahsdamuon", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}


	}

	public function borrowed_luukho(){

		$data = $this->input->post();
		$data['borrowed_id'] = $this->security->xss_clean($data['fileReturn_id']);
		$data['ghichu'] = $this->security->xss_clean($data['ghichu']);
		$data['file_img_approve'] = $this->security->xss_clean($data['file_img_approve']);

		$data = array(
			"id" => !empty($data['borrowed_id']) ? $data['borrowed_id'] : '',
			"ghichu" => !empty($data['ghichu']) ? $data['ghichu'] : '',
			"file_img_approve" => !empty($data['file_img_approve']) ? $data['file_img_approve'] : '',
			"created_by" => $this->userInfo,
			"status" => "10"
		);

		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/borrowed_luukho", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}


	}

	public function chua_tra_hs_da_muon(){
		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);

		$data['ghichu'] = $this->security->xss_clean($data['ghichu']);
		$data['fileReturn_qlhs_img'] = $this->security->xss_clean($data['fileReturn_qlhs_img']);


		$sendApi = array(
			"id" => $data['id'],
			'ghichu' => $data['ghichu'],
			'fileReturn_qlhs_img' => $data['fileReturn_qlhs_img'],
			"created_by" => $this->userInfo,
		);


		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/chua_tra_hs_da_muon", $sendApi);


		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		} else {

			$msg = !empty($return->data->message) ? $return->data->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));

		}

	}

	public function search_borrowed(){

		$data = [];
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$code_contract_disbursement_search = !empty($_GET['code_contract_disbursement_search']) ? $_GET['code_contract_disbursement_search'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$groupRoles_store_search = !empty($_GET['groupRoles_store_search']) ? $_GET['groupRoles_store_search'] : "";
		if (!empty($fdate)) {
			$data['fdate'] = $fdate;
		}
		if (!empty($tdate)) {
			$data['tdate'] = $tdate;
		}
		if (!empty($status)) {
			$data['status'] = $status;
		}
		if (!empty($code_contract_disbursement_search)) {
			$data['code_contract_disbursement_search'] = $code_contract_disbursement_search;
		}
		if (!empty($store)) {
			$data['store'] = $store;
		}
		if (!empty($groupRoles_store_search)) {
			$data['groupRoles_store_search'] = $groupRoles_store_search;
		}

		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$groupRoles_store = $this->api->apiPost($this->user['token'], "groupRole/get_all");
		if (!empty($groupRoles_store->status) && $groupRoles_store->status == 200) {
			$this->data['groupRoles_store'] = $groupRoles_store->data;
		} else {
			$this->data['groupRoles_store'] = array();
		}
		$role_nv_qlkv = $this->api->apiPost($this->userInfo['token'], "Role/get_id_nv_qlkv_all");
		if (!empty($role_nv_qlkv->status) && $role_nv_qlkv->status == 200) {
			$this->data['role_nv_qlkv'] = $role_nv_qlkv->data;
		} else {
			$this->data['role_nv_qlkv'] = $role_nv_qlkv->data;
		}
		$code_contract_disbursement = $this->api->apiPost($this->userInfo['token'], "file_manager/check_file_manager");
		if (!empty($code_contract_disbursement->status) && $code_contract_disbursement->status == 200) {
			$arr = [];
			foreach ($code_contract_disbursement->data as $value){
				array_push($arr, $value->code_contract_disbursement_text);
			}
			$this->data['code_contract_disbursement'] = $arr;
		} else {
			$this->data['code_contract_disbursement'] = array();
		}


		$countBorrowed = $this->api->apiPost($this->userInfo['token'], "file_manager/get_count_all",$data);

		$count = (int)$countBorrowed->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('file_manager/search_borrowed?fdate=' . $fdate . '&tdate=' . $tdate .'&status=' . $status .'&code_contract_disbursement_search=' . $code_contract_disbursement_search .'&groupRoles_store_search=' . $groupRoles_store_search);
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;

			$data['per_page'] = $config['per_page'];
			$data['uriSegment'] = $config['uri_segment'];


		$borrowed = $this->api->apiPost($this->userInfo['token'], "file_manager/get_all", $data);

		if (!empty($borrowed->status) && $borrowed->status == 200) {

			foreach ($borrowed->data as $item){
				$data_id = [
					"code_contract_disbursement_text" => $item->code_contract_disbursement_text
				];
				$dataSend = ['code_contract_disbursement' => $item->code_contract_disbursement_text];
				$check_id = $this->api->apiPost($this->userInfo['token'], "contract/store",$data_id);
				$records = $this->api->apiPost($this->userInfo['token'],'File_manager/get_one_records_by_contract', $dataSend);
				$item->store = $check_id->data->store;
				$item->id_contract = $check_id->data->_id;
				$item->customer_name = $check_id->data->customer_infor->customer_name;
				$item->status_hd = $check_id->data->status;
				$item->status_dkx = !empty($records->data->status_dkx) ? $records->data->status_dkx : self::UPDATE_NOTE_YET;
			}

			$this->data['borrowed'] = $borrowed->data;

		} else {
			$this->data['borrowed'] = array();
		}
		$stores = $this->api->apiPost($this->userInfo['token'], "file_manager/get_store_status_active_new");
		$this->data['stores'] = $stores->data;
		$this->data['template'] = 'page/file_manager/borrowed';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function search_quahan(){

		$data = [];
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$code_contract_disbursement_search = !empty($_GET['code_contract_disbursement_search']) ? $_GET['code_contract_disbursement_search'] : "";

		if (!empty($fdate)) {
			$data['fdate'] = $fdate;
		}
		if (!empty($tdate)) {
			$data['tdate'] = $tdate;
		}
		if (!empty($status)) {
			$data['status'] = $status;
		}
		if (!empty($code_contract_disbursement_search)) {
			$data['code_contract_disbursement_search'] = $code_contract_disbursement_search;
		}
		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$countBorrowed = $this->api->apiPost($this->userInfo['token'], "file_manager/get_count_all_quahan",$data);

		$count = (int)$countBorrowed->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('file_manager/search_quahan?fdate=' . $fdate . '&tdate=' . $tdate .'&status=' . $status .'&code_contract_disbursement_search=' . $code_contract_disbursement_search);
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;

			$data["per_page"] = $config['per_page'];
			$data["uriSegment"] = $config['uri_segment'];


		$borrowed = $this->api->apiPost($this->userInfo['token'], "file_manager/get_all_checkquahan", $data);

		if (!empty($borrowed->status) && $borrowed->status == 200) {

			foreach ($borrowed->data as $item){
				$data_id = [
					"code_contract_disbursement_text" => $item->code_contract_disbursement_text
				];
				$check_id = $this->api->apiPost($this->userInfo['token'], "contract/store",$data_id);
				$item->store = $check_id->data->store;
				$item->id_contract = $check_id->data->_id;


				if ($this->createdAt > $item->borrowed_end){
					$check_date = abs($this->createdAt - $item->borrowed_end);
					$years = floor($check_date / (365 * 60 * 60 * 24));
					$months = floor(($check_date - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
					$days = floor(($check_date - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

					$item->days_am = $days;
				}

				if ($this->createdAt < $item->borrowed_end){
					$check_date = abs($item->borrowed_end - $this->createdAt);
					$years = floor($check_date / (365 * 60 * 60 * 24));
					$months = floor(($check_date - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
					$days = floor(($check_date - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

					$item->days_duong = $days;
				}
			}

			$this->data['borrowed'] = $borrowed->data;

		} else {
			$this->data['borrowed'] = array();
		}


		$this->data['template'] = 'page/file_manager/list_hanmuonhs';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}


	public function getNotification()
	{
		$dataPost = array(
			'token' => $this->user['token'],
			'user_id' => $this->user['id'],
		);

		$nofityBorrowed = $this->api->apiPost($this->user['token'], "user/get_init_dataBorrowed_note", $dataPost);

		if (!empty($this->user)) {
			$this->data['user_borrowed'] = $nofityBorrowed->notifications;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $this->data['user_borrowed'])));
			return;
		}
	}

	public function check_file(){
		$data = [];
		$code_contract_disbursement = !empty($_POST['code_contract_disbursement']) ? $_POST['code_contract_disbursement'] : "";
		$data['code_contract_disbursement'] = $code_contract_disbursement;
		$check_file = $this->api->apiPost($this->userInfo['token'], "file_manager/check_file", $data);

		if (!empty($check_file) && $check_file->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $check_file->data)));
		} else {

			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));

		}
	}

	public function traveyeucautattoan_fileReturn(){

		$data = $this->input->post();
		$data['fileReturn_id'] = $this->security->xss_clean($data['fileReturn_id']);
		$data['ghichu'] = $this->security->xss_clean($data['ghichu']);
		$data['file_img_approve'] = $this->security->xss_clean($data['file_img_approve']);

		$data = array(
			"id" => !empty($data['fileReturn_id']) ? $data['fileReturn_id'] : '',
			"ghichu" => !empty($data['ghichu']) ? $data['ghichu'] : '',
			"file_img_approve" => !empty($data['file_img_approve']) ? $data['file_img_approve'] : '',
			"created_by" => $this->userInfo,
			"status" => "13"
		);

		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/traveyeucautattoan_fileReturn", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}

	}

	public function borrow_travel_paper() {
		$this->data['pageName'] = 'Danh sách cấp giấy đi đường';
		//Nhóm quyền
		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		//Lấy tất cả hợp đồng lưu kho
		$contractData = $this->api->apiPost($this->userInfo['token'], "file_manager/get_all_contract_luukho");
		if (!empty($contractData) && $contractData->status == 200) {
			$this->data['code_contract_disbursement'] = $contractData->data;
		} else {
			$this->data['code_contract_disbursement'] = [];
		}

		//Lấy yêu cầu mượn giấy đi đường
		$countBorrowed = $this->api->apiPost($this->userInfo['token'], "file_manager/get_count_borrow_paper");

		$count = (int)$countBorrowed->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('file_manager/borrow_travel_paper');
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;
		$data = array(
			"per_page" => $config['per_page'],
			"uriSegment" => $config['uri_segment']
		);
		$dataBorrowPaper = $this->api->apiPost($this->userInfo['token'], "file_manager/get_all_borrow_paper",$data);
		if (!empty($dataBorrowPaper) && $dataBorrowPaper->status == 200) {
			$this->data['dataBorrowPaper'] = $dataBorrowPaper->data;

			foreach ($dataBorrowPaper->data as $item){
				$data_id = [
					"code_contract_disbursement_text" => $item->code_contract_disbursement_value
				];
				$check_id = $this->api->apiPost($this->userInfo['token'], "contract/store",$data_id);

				$item->status_hd = $check_id->data->status;


			}


		} else {
			$this->data['dataBorrowPaper'] = [];
		}

		$stores = $this->api->apiPost($this->userInfo['token'], "file_manager/get_store_status_active_new");
		$this->data['stores'] = $stores->data;


		$this->data['template'] = 'page/file_manager/borrow_travel_paper';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function create_borrow_travel_paper(){

		$data = $this->input->post();
		$data['code_contract_disbursement_value'] = $this->security->xss_clean($data['code_contract_disbursement_value']);
		$sendApi = array(
			'code_contract_disbursement_value' => $data['code_contract_disbursement_value']
		);
		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/process_create_borrow_travel_paper", $sendApi);
		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		} else {
			$msg = !empty($return->data->message) ? $return->data->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));
		}
	}

	public function approve_borrow_travel_paper(){

		$data = $this->input->post();
		$data['fileReturn_id'] = $this->security->xss_clean($data['fileReturn_id']);

		$data = array(
			"id" => !empty($data['fileReturn_id']) ? $data['fileReturn_id'] : '',
			"created_by" => $this->userInfo,
		);

		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/approve_borrow_travel_paper", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}
	}

	public function cancel_borrow_travel_paper(){

		$data = $this->input->post();
		$data['fileReturn_id'] = $this->security->xss_clean($data['fileReturn_id']);
		$data['note_return_paper'] = $this->security->xss_clean($data['note_return_paper']) ?? '';

		$data = array(
			"id" => !empty($data['fileReturn_id']) ? $data['fileReturn_id'] : '',
			"note_return_paper" => !empty($data['note_return_paper']) ? $data['note_return_paper'] : '',
			"created_by" => $this->userInfo,
		);

		$return = $this->api->apiPost($this->userInfo['token'], "file_manager/cancel_borrow_travel_paper", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}

	}

	public function search_borrow_travel_paper(){

		$data = [];
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$code_contract_disbursement_search = !empty($_GET['code_contract_disbursement_search']) ? $_GET['code_contract_disbursement_search'] : "";

		if (!empty($store)) {
			$data['store'] = $store;
		}
		if (!empty($fdate)) {
			$data['fdate'] = $fdate;
		}
		if (!empty($tdate)) {
			$data['tdate'] = $tdate;
		}
		if (!empty($status)) {
			$data['status'] = $status;
		}
		if (!empty($code_contract_disbursement_search)) {
			$data['code_contract_disbursement_search'] = $code_contract_disbursement_search;
		}

		//Nhóm quyền
		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		//Lấy tất cả hợp đồng lưu kho
		$contractData = $this->api->apiPost($this->userInfo['token'], "file_manager/get_all_contract_luukho");
		if (!empty($contractData) && $contractData->status == 200) {
			$this->data['code_contract_disbursement'] = $contractData->data;
		} else {
			$this->data['code_contract_disbursement'] = [];
		}

		//Lấy yêu cầu mượn giấy đi đường
		$countBorrowed = $this->api->apiPost($this->userInfo['token'], "file_manager/get_count_borrow_paper",$data);

		$count = (int)$countBorrowed->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('file_manager/borrow_travel_paper');
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;

		$data["per_page"] = $config['per_page'];
		$data["uriSegment"] = $config['uri_segment'];

		$dataBorrowPaper = $this->api->apiPost($this->userInfo['token'], "file_manager/get_all_borrow_paper",$data);
		if (!empty($dataBorrowPaper) && $dataBorrowPaper->status == 200) {
			$this->data['dataBorrowPaper'] = $dataBorrowPaper->data;

			foreach ($dataBorrowPaper->data as $item){
				$data_id = [
					"code_contract_disbursement_text" => $item->code_contract_disbursement_value
				];
				$check_id = $this->api->apiPost($this->userInfo['token'], "contract/store",$data_id);

				$item->status_hd = $check_id->data->status;


			}
		} else {
			$this->data['dataBorrowPaper'] = [];
		}

		$stores = $this->api->apiPost($this->userInfo['token'], "file_manager/get_store_status_active_new");
		$this->data['stores'] = $stores->data;


		$this->data['template'] = 'page/file_manager/borrow_travel_paper';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);


	}


	/** Lấy một bản ghi hồ sơ
	 * @param $id_records
	 */
	public function get_one_records_return($id_records)
	{
		try {
			$records_db = $this->api->apiPost($this->userInfo['token'], 'file_manager/get_one_records_return', ['id_records' => $id_records]);
			if (!empty($records_db->status) && $records_db->status == 200) {
				$response_js = [
					'status' => '200',
					'data' => $records_db->data
				];
				return $this->pushJson('200', json_encode($response_js));
			} else {
				$response_js = [
					'status' => '400',
					'msg' => $records_db->message,
				];
				return $this->pushJson('200', json_encode($response_js));
			}
		} catch (Exception $exception) {
			show_404();
		}
	}

	/** Lấy một bản ghi hồ sơ
	 * @param $code_contract_disbursement
	 */
	public function get_one_records_return_borrow($id_records_br)
	{
		try {

			$dataSend = ['id' => $id_records_br];
			$borrow_db = $this->api->apiPost($this->userInfo['token'], 'File_manager/get_one_borrowed', $dataSend);
			if (!empty($borrow_db->data)) {
				$data_send_rc = ['code_contract_disbursement' => $borrow_db->data->code_contract_disbursement_text];
			}
			$records_db = $this->api->apiPost($this->userInfo['token'], 'file_manager/get_one_records_return_borrow', $data_send_rc);
			if (!empty($records_db->status) && $records_db->status == 200) {
				$response_js = [
					'status' => '200',
					'data' => $records_db->data
				];
				return $this->pushJson('200', json_encode($response_js));
			} else {
				$response_js = [
					'status' => '400',
					'msg' => $records_db->message,
				];
				return $this->pushJson('200', json_encode($response_js));
			}
		} catch (Exception $exception) {
			show_404();
		}
	}

	
	/** Func call api để cập nhật số lượng văn bản trong hồ sơ
	 *
	 */
	public function update_quantity_records()
	{
		$dataPost = $this->input->post();
		//V2
		$id_records = !empty($this->security->xss_clean($dataPost['id_records'])) ? $this->security->xss_clean($dataPost['id_records']) : 0;
		$note_update = !empty($this->security->xss_clean($dataPost['note_update'])) ? $this->security->xss_clean($dataPost['note_update']) : 0;
		$code_storage = !empty($this->security->xss_clean($dataPost['code_storage'])) ? $this->security->xss_clean($dataPost['code_storage']) : 0;
		$thoa_thuan_ba_ben = !empty($this->security->xss_clean($dataPost['thoa_thuan_ba_ben'])) ? $this->security->xss_clean($dataPost['thoa_thuan_ba_ben']) : 0;
		$bbbg_tai_san = !empty($this->security->xss_clean($dataPost['bbbg_tai_san'])) ? $this->security->xss_clean($dataPost['bbbg_tai_san']) : 0;
		$dang_ky_xe = !empty($this->security->xss_clean($dataPost['dang_ky_xe'])) ? $this->security->xss_clean($dataPost['dang_ky_xe']) : 0;
		$thong_bao = !empty($this->security->xss_clean($dataPost['thong_bao'])) ? $this->security->xss_clean($dataPost['thong_bao']) : 0;
		$hd_mua_ban_xe = !empty($this->security->xss_clean($dataPost['hd_mua_ban_xe'])) ? $this->security->xss_clean($dataPost['hd_mua_ban_xe']) : 0;
		$cam_ket = !empty($this->security->xss_clean($dataPost['cam_ket'])) ? $this->security->xss_clean($dataPost['cam_ket']) : 0;
		$bbbg_thiet_bi_dinh_vi = !empty($this->security->xss_clean($dataPost['bbbg_thiet_bi_dinh_vi'])) ? $this->security->xss_clean($dataPost['bbbg_thiet_bi_dinh_vi']) : 0;
		$bbh_hoi_dong_co_dong = !empty($this->security->xss_clean($dataPost['bbh_hoi_dong_co_dong'])) ? $this->security->xss_clean($dataPost['bbh_hoi_dong_co_dong']) : 0;
		$hop_dong_mua_ban = !empty($this->security->xss_clean($dataPost['hop_dong_mua_ban'])) ? $this->security->xss_clean($dataPost['hop_dong_mua_ban']) : 0;
		$hd_uy_quyen = !empty($this->security->xss_clean($dataPost['hd_uy_quyen'])) ? $this->security->xss_clean($dataPost['hd_uy_quyen']) : 0;
		$hd_chuyen_nhuong = !empty($this->security->xss_clean($dataPost['hd_chuyen_nhuong'])) ? $this->security->xss_clean($dataPost['hd_chuyen_nhuong']) : 0;
		$so_do = !empty($this->security->xss_clean($dataPost['so_do'])) ? $this->security->xss_clean($dataPost['so_do']) : 0;
		$hd_dat_coc = !empty($this->security->xss_clean($dataPost['hd_dat_coc'])) ? $this->security->xss_clean($dataPost['hd_dat_coc']) : 0;
		$phu_luc_gia_han = !empty($this->security->xss_clean($dataPost['phu_luc_gia_han'])) ? $this->security->xss_clean($dataPost['phu_luc_gia_han']) : 0;
		$dataSend = [
			"id_records" => $id_records,
			"note_update" => $note_update,
			"code_storage" => $code_storage,
			"thoa_thuan_ba_ben" => $thoa_thuan_ba_ben,
			"thoa_thuan_ba_ben" => $thoa_thuan_ba_ben,
			"bbbg_tai_san" => $bbbg_tai_san,
			"dang_ky_xe" => $dang_ky_xe,
			"thong_bao" => $thong_bao,
			"hd_mua_ban_xe" => $hd_mua_ban_xe,
			"cam_ket" => $cam_ket,
			"bbbg_thiet_bi_dinh_vi" => $bbbg_thiet_bi_dinh_vi,
			"bbh_hoi_dong_co_dong" => $bbh_hoi_dong_co_dong,
			"hop_dong_mua_ban" => $hop_dong_mua_ban,
			"hd_uy_quyen" => $hd_uy_quyen,
			"hd_chuyen_nhuong" => $hd_chuyen_nhuong,
			"so_do" => $so_do,
			"hd_dat_coc" => $hd_dat_coc,
			"phu_luc_gia_han" => $phu_luc_gia_han,
		];
		$response_api = $this->api->apiPost($this->userInfo['token'], "file_manager/update_quantity_records", $dataSend);
		if (!empty($response_api->status) && $response_api->status == 200) {
			$response_js = [
				'res' => true,
				'status' => "200",
				'msg' => $response_api->message
			];
			return $this->pushJson('200', json_encode($response_js));
		} else {
			$response_js = [
				'res' => false,
				'status' => "400",
				'msg' => 'Cập nhật thất bại!'
			];
			return $this->pushJson('200', json_encode($response_js));
		}
	}

	public function contract_all()
	{
		$this->data["pageName"] = 'Quản lý hợp đồng vay - Chỉ định bộ phận QLHS';
		// call api get count contract
		$data = array();
		$userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
		$stores = !empty($userInfo['stores']) ? $userInfo['stores'] : array();
		//get store
		$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all", array());
		$arr_store = array();
		$this->data['code_domain'] = '';
		if (!empty($storeData->status) && $storeData->status == 200 && !empty($stores)) {
			foreach ($stores as $key => $store) {
				$arr_store += [$key => $store->store_id];
			}
			foreach ($storeData->data as $key => $value) {
				if ($value->status != 'active' || !in_array($value->_id->{'$oid'}, $arr_store)) {
					unset($storeData->data[$key]);
				} else {
					$area = $this->api->apiPost($this->userInfo['token'], "area/get_area_by_code", array('code' => $value->code_area));
					if (!empty($area->status) && $area->status == 200) {
						$this->data['code_domain'] = $area->data->domain->code;
					}
				}
			}
			$this->data['stores'] = $storeData->data;
		} else {
			$this->data['stores'] = array();
		}
		// Get region qlhs
		$region_records = $this->api->apiPost($this->userInfo['token'], 'File_manager/get_region_by_user', ['user_id' => $this->userInfo['id']]);
		if (isset($region_records->status) && $region_records->status == 200) {
			$this->data['region_records'] = $region_records->data;
		} else {
			$this->data['region_records'] = array();
		}
		$countContractData = $this->api->apiPost($this->userInfo['token'], "File_manager/get_count_contract_all", $data);
		if (!empty($countContractData->status) && $countContractData->status == 200 && $countContractData->data != 0) {
			$count = (int)$countContractData->data;
			$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
			$config = $this->config->item('pagination');
			$config['base_url'] = base_url('File_manager/contract_all');
			$config['total_rows'] = $count;
			$config['per_page'] = 30;
			$config['page_query_string'] = true;
			$config['uri_segment'] = $uriSegment;
			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();
			$this->data['countContract'] = $count;
			$data = array(
				"per_page" => $config['per_page'],
				"uriSegment" => $config['uri_segment']
			);

			$contractData = $this->api->apiPost($this->userInfo['token'], "File_manager/get_all_contract_data", $data);
			if (!empty($contractData->status) && $contractData->status == 200) {
				$this->data['contractData'] = $contractData->data;
				$this->data['count'] = $contractData->count;
			} else {
				$this->data['contractData'] = array();
				$this->data['count'] = [];
			}
			for ($i = 0; $i < count($contractData->data); $i++) {
				$check = [
					"contract_id" => $contractData->data[$i]->_id->{'$oid'}
				];
				$data_hs = $this->api->apiPost($this->userInfo['token'], "hoiso_create/get_create_at_hs_all", $check);
				if (!empty($data_hs->status) && $data_hs->status == 200) {
					$contractData->data[$i]->data_hs = $data_hs->data;
				} else {
					$contractData->data[$i]->data_hs = array();
				}
				unset($check);
				unset($data_hs);
			}
		} else {
			$this->data['contractData'] = array();
		}
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		//get coupon
		$couponData = $this->api->apiPost($this->userInfo['token'], "coupon/get_all_home");
		if (!empty($couponData->status) && $couponData->status == 200) {
			$this->data['couponData'] = $couponData->data;
		} else {
			$this->data['couponData'] = array();
		}
		//get property main ( tài sản cấp cao nhất parenid == null)
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main");
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$this->data['mainPropertyData'] = $mainPropertyData->data;
		} else {
			$this->data['mainPropertyData'] = array();
		}
		//get list nhà đầu tư
		$listInvestor = $this->api->apiPost($this->userInfo['token'], "investor/get_all");
		if ($listInvestor->status == 200) {
			$this->data['listInvestor'] = $listInvestor->data;
		}

		$this->data['tilekhoanvay'] = 0;
		$config = $this->api->apiPost($this->userInfo['token'], "config_gic/get_config", array('code' => "TN_TNNNV"));
		if (!empty($config->status) && $config->status == 200) {
			$this->data['tilekhoanvay'] = (!empty($config->data->TyLePhi)) ? $config->data->TyLePhi : 0;
		}
		$this->data['template'] = 'page/file_manager/contract_all';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function search_contract()
	{
		$this->data["pageName"] = $this->lang->line('manage_contract');
		$this->data['tilekhoanvay'] = 0;


		// Get region qlhs
		$region_records = $this->api->apiPost($this->userInfo['token'], 'File_manager/get_region_by_user', ['user_id' => $this->userInfo['id']]);
		if (isset($region_records->status) && $region_records->status == 200) {
			$this->data['region_records'] = $region_records->data;
		} else {
			$this->data['region_records'] = array();
		}
		$config = $this->api->apiPost($this->userInfo['token'], "config_gic/get_config", array('code' => "TN_TNNNV"));
		if (!empty($config->status) && $config->status == 200) {
			$this->data['tilekhoanvay'] = (!empty($config->data->TyLePhi)) ? $config->data->TyLePhi : 0;
		}
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$customer_phone_number = !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$property = !empty($_GET['property']) ? $_GET['property'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$customer_identify = !empty($_GET['customer_identify']) ? $_GET['customer_identify'] : "";
//		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$asset_name = !empty($_GET['asset_name']) ? $_GET['asset_name'] : "";
		$search_htv = !empty($_GET['search_htv']) ? $_GET['search_htv'] : "";
		$ngay_giai_ngan = !empty($_GET['ngay_giai_ngan']) ? $_GET['ngay_giai_ngan'] : 1;
		$phone_number_relative = !empty($_GET['phone_number_relative']) ? $_GET['phone_number_relative'] : "";
		$fullname_relative = !empty($_GET['fullname_relative']) ? $_GET['fullname_relative'] : "";
		$type_contract_digital = !empty($_GET['type_contract_digital']) ? $_GET['type_contract_digital'] : "";
		$region = !empty($_GET['region']) ? $_GET['region'] : "";
		$code_store = array();
		$url_code_store = "";
		if (is_array($_GET['code_store'])) {
			foreach ($_GET['code_store'] as $code) {
				array_push($code_store, $code);
				$url_code_store .= '&code_store[]=' . $code;
			}
		} else {
			$code_store = !empty($_GET['code_store']) ? $_GET['code_store'] : "";
			$url_code_store = '&code_store=' . $code_store;
		}
		if ($status == 17) {
			$ngay_giai_ngan = 2;
		} elseif ($status == 19) {
			$ngay_giai_ngan = 3;
		}
		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('File_manager/contract_all'));
		}
		$data = array();
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$data = array(
				"start" => $start,
				"end" => $end,
			);
		}
		if (!empty($code_store)) {
			$data['code_store'] = $code_store;
		}
		if (!empty($asset_name)) {
			$data['asset_name'] = $asset_name;
		}
		if (!empty($search_htv)) {
			$data['search_htv'] = $search_htv;
		}
		if (!empty($ngay_giai_ngan)) {
			$data['ngaygiaingan'] = $ngay_giai_ngan;
		}
		if (!empty($property)) {
			$data['property'] = $property;
		}
		if (!empty($status)) {
			$data['status'] = $status;
		}
		if (!empty($customer_identify)) {
			$data['customer_identify'] = $customer_identify;
		}
		if (!empty($code_contract)) {
			$data['code_contract'] = $code_contract;
		}
		if (!empty($code_contract_disbursement)) {
			$data['code_contract_disbursement'] = $code_contract_disbursement;
		}
		if (!empty($customer_name)) {
			$data['customer_name'] = $customer_name;
		}
		if (!empty($customer_phone_number)) {
			$data['customer_phone_number'] = $customer_phone_number;
		}
		if (!empty($store)) {
			$data['store'] = $store;
		}
		if (!empty($phone_number_relative)) {
			$data['phone_number_relative'] = $phone_number_relative;
		}
		if (!empty($fullname_relative)) {
			$data['fullname_relative'] = $fullname_relative;
		}
		if (!empty($type_contract_digital)) {
			$data['type_contract_digital'] = $type_contract_digital;
		}
		if (!empty($region)) {
			$data['region'] = $region;
			$stores_list = $this->api->apiPost($this->userInfo['token'],'File_manager/get_stores_by_code_region', array('code_region' => $region));
			if (isset($stores_list->status) && $stores_list->status == 200) {
				$this->data['stores_list'] = $stores_list->data;
			} else {
				$this->data['stores_list'] = array();
			}
		} else {
			$userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
			$stores = !empty($userInfo['stores']) ? $userInfo['stores'] : array();
			//get store
			$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all", array());
			$arr_store = array();
			$this->data['code_domain'] = '';
			if (!empty($storeData->status) && $storeData->status == 200 && !empty($stores)) {
				foreach ($stores as $key => $store) {
					$arr_store += [$key => $store->store_id];
				}
				foreach ($storeData->data as $key => $value) {
					if ($value->status != 'active' || !in_array($value->_id->{'$oid'}, $arr_store)) {
						unset($storeData->data[$key]);
					} else {
						$area = $this->api->apiPost($this->userInfo['token'], "area/get_area_by_code", array('code' => $value->code_area));
						if (!empty($area->status) && $area->status == 200) {
							$this->data['code_domain'] = $area->data->domain->code;
						}
					}
				}
				$this->data['stores'] = $storeData->data;
			} else {
				$this->data['stores'] = array();
			}
		}

		// call api get count contract
		$countContractData = $this->api->apiPost($this->userInfo['token'], "File_manager/get_count_contract_all", $data);
		if (!empty($countContractData->status) && $countContractData->status == 200 && $countContractData->data != 0) {
			$count = $countContractData->data;
			$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
			$config = $this->config->item('pagination');
			$config['base_url'] = base_url('File_manager/search_contract?
				code_contract=' . $code_contract .
				'&code_contract_disbursement=' . $code_contract_disbursement .
				'&fdate=' . $start .
				'&tdate=' . $end .
				'&property=' . $property .
				'&status=' . $status .
				'&customer_name=' . $customer_name .
				'&customer_phone_number=' . $customer_phone_number .
				 $url_code_store .
				'&asset_name=' . $asset_name .
				'&search_htv=' . $search_htv .
				'&ngay_giai_ngan=' . $ngay_giai_ngan .
				'&fullname_relative=' . $fullname_relative .
				'&phone_number_relative=' . $phone_number_relative .
				'&type_contract_digital=' . $type_contract_digital .
				'&region=' . $region
				              );
			$config['total_rows'] = $count;
			$config['per_page'] = 30;
			$config['page_query_string'] = true;
			$config['uri_segment'] = $uriSegment;
			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();
			$data['per_page'] = $config['per_page'];
			$data['uriSegment'] = $config['uri_segment'];
			$this->data['countContract'] = $count;
			//Call api get all data contract
			$contractData = $this->api->apiPost($this->userInfo['token'], "File_manager/get_all_contract_data", $data);
			if (!empty($contractData->status) && $contractData->status == 200) {
				$this->data['contractData'] = $contractData->data;
				$this->data['count'] = $contractData->count;
			} else {
				$this->data['contractData'] = array();
				$this->data['count'] = [];
			}
		} else {
			$this->data['contractData'] = array();
		}
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		$listInvestor = $this->api->apiPost($this->userInfo['token'], "investor/get_all");
		if ($listInvestor->status == 200) {
			$this->data['listInvestor'] = $listInvestor->data;
		}

		//get property main ( tài sản cấp cao nhất parenid == null)
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main");
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$this->data['mainPropertyData'] = $mainPropertyData->data;
		} else {
			$this->data['mainPropertyData'] = array();
		}
		$this->data['template'] = 'page/file_manager/contract_all';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}


	public function get_stores_by_code_region()
	{
		$dataPost = $this->input->post();
		$code_region = !empty($this->security->xss_clean($dataPost['code_region'])) ? $this->security->xss_clean($dataPost['code_region']) : '';
		if (!empty($code_region)) {
			$result = $this->api->apiPost($this->userInfo['token'], 'File_manager/get_stores_by_code_region', array('code_region' => $code_region));
			if (!empty($result->status) && $result->status == 200) {
				$response_js = [
					'status' => 200,
					'msg' => 'success',
					'data' => $result->data
				];
				return $this->pushJson(200, json_encode($response_js));
			} else {
				$response_js = [
					'status' => 400,
					'msg' => 'fail',
					'data' => array()
				];
				return $this->pushJson(200, json_encode($response_js));
			}
		} else {
			$stores_ss = $this->userInfo['stores'];
			$response_js = [
				'status' => 200,
				'msg' => 'success',
				'data' => $stores_ss
			];
			return $this->pushJson(200, json_encode($response_js));
		}
	}

	public function exportAllContract()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$ngaygiaingan = !empty($_GET['ngaygiaingan']) ? $_GET['ngaygiaingan'] : "1";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$customer_phone_number = !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
		$property = !empty($_GET['property']) ? $_GET['property'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$customer_identify = !empty($_GET['customer_identify']) ? $_GET['customer_identify'] : "";
		$createBy = !empty($_GET['createBy']) ? $_GET['createBy'] : "";
		$search_htv = !empty($_GET['search_htv']) ? $_GET['search_htv'] : "";
		$code_store = !empty($_GET['code_store']) ? $_GET['code_store'] : array();
		$region = !empty($_GET['region']) ? $_GET['region'] : "";
		if (empty($start) || empty($end)) {
			echo "Vui lòng chọn thời gian để xuất dữ liệu!";
			return;
		}
		if (strtotime($start) > strtotime($end)) {
			echo "Thời gian tìm kiếm không hợp lệ!";
			return;
		}
		$data = array();
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$data = array(
				"start" => $start,
				"end" => $end,
			);
		}

		if (!empty($code_store)) {
			$data['code_store'] = $code_store;
		}
		if ($status == 17) {
			$ngaygiaingan = 2;
		} elseif ($status == 19) {
			$ngaygiaingan = 3;
		}
		$data['ngaygiaingan'] = $ngaygiaingan;

		if (!empty($property)) {
			$data['property'] = $property;
		}
		if (!empty($status)) {
			$data['status'] = $status;
		}
		if (!empty($search_htv)) {
			$data['search_htv'] = $search_htv;
		}
		if (!empty($customer_identify)) {
			$data['customer_identify'] = $customer_identify;
		}
		if (!empty($code_contract)) {
			$data['code_contract'] = $code_contract;
		}
		if (!empty($code_contract_disbursement)) {
			$data['code_contract_disbursement'] = $code_contract_disbursement;
		}
		if (!empty($customer_name)) {
			$data['customer_name'] = $customer_name;
		}
		if (!empty($customer_phone_number)) {
			$data['customer_phone_number'] = $customer_phone_number;
		}
		if (!empty($createBy)) {
			$data['created_by'] = $createBy;
		}
		if (!empty($region)) {
			$data['region'] = $region;
		}
		$data['is_export'] = 1;
		$data["per_page"] = 10000;
		// call api get count contract
		$infoContractData = $this->api->apiPost($this->userInfo['token'], "File_manager/get_all_contract_data", $data);
		if (empty($infoContractData->data)) {
			echo "Không có dữ liệu!";
			return;
		} else {
			$this->fcExportAllContract($infoContractData->data);
			$this->callLibExcel('ReportContractDisbursement-' . $createBy . time() . '.xlsx');
		}
	}

	public function fcExportAllContract($dataPawn)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã HĐ gốc');
		$this->sheet->setCellValue('C1', 'Tên khách hàng');
		$this->sheet->setCellValue('D1', 'PGD');
		$this->sheet->setCellValue('E1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('F1', 'Ngày giải ngân');
		$this->sheet->setCellValue('G1', 'Ngày gia hạn/cơ cấu');
		$this->sheet->setCellValue('H1', 'Trạng thái');
		$this->sheet->setCellValue('I1', 'Hình thức');
		$this->sheet->setCellValue('J1', 'Sản phẩm');
		$this->sheet->setCellValue('K1', 'IMEI Device VSET');
		$this->sheet->setCellValue('L1', 'Loại tài sản');
		$this->sheet->setCellValue('M1', 'Biển số xe');
		$this->sheet->setCellValue('N1', 'Họ tên chủ xe');
		$this->sheet->setCellValue('O1', 'Địa chỉ đăng ký');
		$this->sheet->setCellValue('P1', 'Số đăng ký');
		$this->sheet->setCellValue('Q1', 'Khu vực');
		$this->sheet->setCellValue('R1', 'Vùng');
		$this->sheet->setCellValue('S1', 'Miền');
		$this->sheet->setCellValue('T1', 'Thỏa thuận 3 bên');
		$this->sheet->setCellValue('U1', 'BBBG Tài sản');
		$this->sheet->setCellValue('V1', '"ĐKX/CVX"');
		$this->sheet->setCellValue('W1', 'Thông báo');
		$this->sheet->setCellValue('X1', 'Hợp đồng mua bán xe');
		$this->sheet->setCellValue('Y1', 'Cam kết (nếu xe ko chính chủ)');
		$this->sheet->setCellValue('Z1', 'BBBG thiết bị định vị');
		$this->sheet->setCellValue('AA1', 'BB họp hội đồng cổ đông');
		$this->sheet->setCellValue('AB1', 'HĐ mua bán');
		$this->sheet->setCellValue('AC1', 'HĐ uỷ quyền');
		$this->sheet->setCellValue('AD1', 'HĐ chuyển nhượng');
		$this->sheet->setCellValue('AE1', 'Giấy CNQSDĐ');
		$this->sheet->setCellValue('AF1', 'HĐ đặt cọc');
		$this->sheet->setCellValue('AG1', 'Phụ lục gia hạn/cơ cấu');
		$this->sheet->setCellValue('AH1', 'ID quản lý (ID xác nhận lưu kho)');
		$this->sheet->setCellValue('AI1', 'Thời gian xác nhận lưu kho');
		$this->sheet->setCellValue('AJ1', 'Mã lưu trữ hồ sơ');

		$i = 2;
		foreach ($dataPawn as $data) {
			$bien_so_xe = "";
			$ho_ten_chu_xe = "";
			$dia_chi_dang_ky = "";
			$so_dang_ky = "";
			$status_customer = "";
			$marital_status = "";
			if (!empty($data->property_infor)) {
				$vehicle_infor = $data->property_infor ?? array();
				$bien_so_xe = $vehicle_infor[2]->value ?? '';
				$ho_ten_chu_xe = $vehicle_infor[5]->value ?? '';
				$dia_chi_dang_ky = $vehicle_infor[6]->value ?? '';
				$so_dang_ky = $vehicle_infor[7]->value ?? '';
			}
			$bucket = "";
			$du_no_goc_con = (!empty($data->debt->tong_tien_goc_con)) ? $data->debt->tong_tien_goc_con : 0;
			$so_ngay_cham_tra = (!empty($data->debt->so_ngay_cham_tra)) ? $data->debt->so_ngay_cham_tra : 0;

			$bucket = get_bucket($so_ngay_cham_tra);
			$san_pham = (!empty($data->loan_infor->loan_product->text)) ? $data->loan_infor->loan_product->text : '';
			$store_id = (!empty($data->store->id)) ? $data->store->id : '';
			$store = $this->api->apiPost($this->userInfo['token'], "store/get_store", array('id' => $store_id));
			$code_area = (!empty($store->data->code_area)) ? $store->data->code_area : '';
			$area = $this->api->apiPost($this->userInfo['token'], "area/get_area_by_code", array('code' => $code_area));
			$vung = (!empty($area->data->region->name)) ? $area->data->region->name : '';
			$mien = (!empty($area->data->domain->name)) ? $area->data->domain->name : '';
			$khu_vuc = (!empty($area->data->title)) ? $area->data->title : '';
			$records_contract = $this->api->apiPost($this->userInfo['token'], 'File_manager/get_one_records_by_contract', array('code_contract_disbursement' => $data->code_contract_disbursement));
			if (!empty($records_contract->data)) {
				$records = $records_contract->data;
				$bbbg_tai_san = $records->records_receive->bbbg_tai_san->quantity ?? 0;
				$bbbg_thiet_bi_dinh_vi = $records->records_receive->bbbg_thiet_bi_dinh_vi->quantity ?? 0;
				$bbh_hoi_dong_co_dong = $records->records_receive->bbh_hoi_dong_co_dong->quantity ?? 0;
				$cam_ket = $records->records_receive->cam_ket->quantity ?? 0;
				$dang_ky_xe = $records->records_receive->dang_ky_xe->quantity ?? 0;
				$hd_chuyen_nhuong = $records->records_receive->hd_chuyen_nhuong->quantity ?? 0;
				$hd_dat_coc = $records->records_receive->hd_dat_coc->quantity ?? 0;
				$hd_mua_ban_xe = $records->records_receive->hd_mua_ban_xe->quantity ?? 0;
				$hd_uy_quyen = $records->records_receive->hd_uy_quyen->quantity ?? 0;
				$hop_dong_mua_ban = $records->records_receive->hop_dong_mua_ban->quantity ?? 0;
				$phu_luc_gia_han = $records->records_receive->phu_luc_gia_han->quantity ?? 0;
				$so_do = $records->records_receive->so_do->quantity ?? 0;
				$thoa_thuan_ba_ben = $records->records_receive->thoa_thuan_ba_ben->quantity ?? 0;
				$thong_bao = $records->records_receive->thong_bao->quantity ?? 0;
				$id_manager_received = $records_contract->data->updated_rcr_by ?? '';
				$time_confirm_received = !empty($records_contract->data->updated_rcr_at) ? date('d/m/Y H:i:s', $records_contract->data->updated_rcr_at) : '';
				$ma_luu_tru_hs = $records_contract->data->code_store_rc ?? '';
			}

			$this->sheet->setCellValue('A' . $i, $i - 1);
			$this->sheet->setCellValue('B' . $i, !empty($data->code_contract_disbursement) ? $data->code_contract_disbursement : $data->code_contract);
			$this->sheet->setCellValue('C' . $i, !empty($data->customer_infor->customer_name) ? $data->customer_infor->customer_name : "");
			$this->sheet->setCellValue('D' . $i, !empty($data->store->name) ? $data->store->name : "");
			$this->sheet->setCellValue('E' . $i, !empty($data->code_contract) ? $data->code_contract : '');
			$this->sheet->setCellValue('F' . $i, (!empty($data->disbursement_date) && empty($data->type_gh) && empty($data->type_cc)) ? date("d/m/Y", $data->disbursement_date) : "");
			$this->sheet->setCellValue('G' . $i, (!empty($data->disbursement_date) && (!empty($data->type_gh) || !empty($data->type_cc))) ? date("d/m/Y", $data->disbursement_date) : "");
			$this->sheet->setCellValue('H' . $i, !empty($data->status) ? contract_status($data->status) : "");
			$this->sheet->setCellValue('I' . $i, !empty($data->loan_infor->type_loan->code) ? $data->loan_infor->type_loan->code : "");
			$this->sheet->setCellValue('J' . $i, !empty($san_pham) ? $san_pham : "");
			$this->sheet->setCellValue('K' . $i, !empty($data->loan_infor->device_asset_location->code) ? $data->loan_infor->device_asset_location->code . " " : '');
			$this->sheet->setCellValue('L' . $i, !empty($data->loan_infor->type_property->text) ? $data->loan_infor->type_property->text : "");
			$this->sheet->setCellValue('M' . $i, $bien_so_xe);
			$this->sheet->setCellValue('N' . $i, !empty($ho_ten_chu_xe) ? $ho_ten_chu_xe : "");
			$this->sheet->setCellValue('O' . $i, !empty($dia_chi_dang_ky) ? $dia_chi_dang_ky : "");
			$this->sheet->setCellValue('P' . $i, !empty($so_dang_ky) ? $so_dang_ky : "");
			$this->sheet->setCellValue('Q' . $i, !empty($khu_vuc) ? $khu_vuc : "");
			$this->sheet->setCellValue('R' . $i, !empty($vung) ? $vung : "");
			$this->sheet->setCellValue('S' . $i, !empty($mien) ? $mien : "");
			$this->sheet->setCellValue('T' . $i, $thoa_thuan_ba_ben);
			$this->sheet->setCellValue('U' . $i, $bbbg_tai_san);
			$this->sheet->setCellValue('V' . $i, $dang_ky_xe);
			$this->sheet->setCellValue('W' . $i, $thong_bao);
			$this->sheet->setCellValue('X' . $i, $hd_mua_ban_xe);
			$this->sheet->setCellValue('Y' . $i, $cam_ket);
			$this->sheet->setCellValue('Z' . $i, $bbbg_thiet_bi_dinh_vi);
			$this->sheet->setCellValue('AA' . $i, $bbh_hoi_dong_co_dong);
			$this->sheet->setCellValue('AB' . $i, $hop_dong_mua_ban);
			$this->sheet->setCellValue('AC' . $i, $hd_uy_quyen);
			$this->sheet->setCellValue('AD' . $i, $hd_chuyen_nhuong);
			$this->sheet->setCellValue('AE' . $i, $so_do);
			$this->sheet->setCellValue('AF' . $i, $hd_dat_coc);
			$this->sheet->setCellValue('AG' . $i, $phu_luc_gia_han);
			$this->sheet->setCellValue('AH' . $i, $id_manager_received);
			$this->sheet->setCellValue('AI' . $i, $time_confirm_received);
			$this->sheet->setCellValue('AJ' . $i, $ma_luu_tru_hs);

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


	public function ExportRecordsDisbursement()
	{
		$dataGet = $this->input->get();
		$from_date = !empty($this->security->xss_clean($dataGet['fdate'])) ? $this->security->xss_clean($dataGet['fdate']) : '';
		$to_date = !empty($this->security->xss_clean($dataGet['tdate'])) ? $this->security->xss_clean($dataGet['tdate']) : '';
		$store = !empty($this->security->xss_clean($dataGet['store'])) ? $this->security->xss_clean($dataGet['store']) : '';
		$status = !empty($this->security->xss_clean($dataGet['status'])) ? $this->security->xss_clean($dataGet['status']) : '';
		$code_contract_disbursement_search = !empty($this->security->xss_clean($dataGet['code_contract_disbursement_search'])) ? $this->security->xss_clean($dataGet['code_contract_disbursement_search']) : '';
		if (empty($from_date) || empty($to_date)) {
			echo "Vui lòng chọn thời gian để xuất dữ liệu!";
			return;
		}
		if (strtotime($from_date) > strtotime($to_date)) {
			echo "Thời gian tìm kiếm không hợp lệ!";
			return;
		}
		$dataSend = array();
		if (!empty($from_date) && !empty($to_date)) {
			$dataSend = array(
				'fdate' => $from_date,
				'tdate' => $to_date
			);
		}
		if (!empty($store)) {
			$dataSend['store'] = $store;
		}
		if (!empty($status)) {
			$dataSend['status'] = $status;
		}
		if (!empty($code_contract_disbursement_search)) {
			$dataSend['code_contract_disbursement_search'] = $code_contract_disbursement_search;
		}
		$dataSend['per_page'] = 10000;
		$recordsData = $this->api->apiPost($this->userInfo['token'], 'File_manager/get_all_sendFile', $dataSend);
		if (empty($recordsData->data)) {
			$this->session->set_flashdata('error', "Không có dữ liệu ");
			redirect(base_url('File_manager/index_file_manager'));
		} else {
			$this->fcExportRecordsDisbursement($recordsData->data);
			$this->callLibExcel('ReportContractSendHO-' . $createBy . time() . '.xlsx');
		}

	}


	public function fcExportRecordsDisbursement($recordsData)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã HĐ gốc');
		$this->sheet->setCellValue('C1', 'Tên khách hàng');
		$this->sheet->setCellValue('D1', 'PGD');
		$this->sheet->setCellValue('E1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('F1', 'Ngày giải ngân');
		$this->sheet->setCellValue('G1', 'Ngày gia hạn/cơ cấu');
		$this->sheet->setCellValue('H1', 'Ngày tất toán');
		$this->sheet->setCellValue('I1', 'Trạng thái');
		$this->sheet->setCellValue('J1', 'Hình thức');
		$this->sheet->setCellValue('K1', 'Sản phẩm');
		$this->sheet->setCellValue('L1', 'IMEI Device VSET');
		$this->sheet->setCellValue('M1', 'Loại tài sản');
		$this->sheet->setCellValue('N1', 'Biển số xe');
		$this->sheet->setCellValue('O1', 'Họ tên chủ xe');
		$this->sheet->setCellValue('P1', 'Địa chỉ đăng ký');
		$this->sheet->setCellValue('Q1', 'Số đăng ký');
		$this->sheet->setCellValue('R1', 'Khu vực');
		$this->sheet->setCellValue('S1', 'Vùng');
		$this->sheet->setCellValue('T1', 'Miền');
		$this->sheet->setCellValue('U1', 'Thỏa thuận 3 bên');
		$this->sheet->setCellValue('V1', 'BBBG Tài sản');
		$this->sheet->setCellValue('W1', '"ĐKX/CVX"');
		$this->sheet->setCellValue('X1', 'Thông báo');
		$this->sheet->setCellValue('Y1', 'Hợp đồng mua bán xe');
		$this->sheet->setCellValue('Z1', 'Cam kết (nếu xe ko chính chủ)');
		$this->sheet->setCellValue('AA1', 'BBBG thiết bị định vị');
		$this->sheet->setCellValue('AB1', 'BB họp hội đồng cổ đông');
		$this->sheet->setCellValue('AC1', 'HĐ mua bán');
		$this->sheet->setCellValue('AD1', 'HĐ uỷ quyền');
		$this->sheet->setCellValue('AE1', 'HĐ chuyển nhượng');
		$this->sheet->setCellValue('AF1', 'Giấy CNQSDĐ');
		$this->sheet->setCellValue('AG1', 'HĐ đặt cọc');
		$this->sheet->setCellValue('AH1', 'Phụ lục gia hạn/cơ cấu');
		$this->sheet->setCellValue('AI1', 'ID quản lý (ID xác nhận lưu kho)');
		$this->sheet->setCellValue('AJ1', 'Thời gian xác nhận lưu kho');
		$this->sheet->setCellValue('AK1', 'Mã lưu kho');
		$this->sheet->setCellValue('AL1', 'Mã lưu trữ hồ sơ');

		$i = 2;
		foreach ($recordsData as $records) {
			$contractInfor = $this->api->apiPost($this->userInfo['token'],'File_manager/get_one_contract_by_records', ['code_contract_disbursement' => $records->code_contract_disbursement_text]);
			$records->contract_infor = $contractInfor->data ?? new stdClass();
			$so_khung = "";
			$so_may = "";
			$bien_so_xe = "";
			$model = "";
			$nhan_hieu = "";
			$ho_ten_chu_xe = "";
			$dia_chi_dang_ky = "";
			$so_dang_ky = "";
			$ngay_cap = "";
			$status_customer = "";
			$marital_status = "";
			$ma_luu_kho = "";
			$ma_luu_kho = explode('/',$records->code_contract_disbursement_text,3);
			$ma_luu_kho = $ma_luu_kho[2] ?? '';
			$data = $records->contract_infor;
			if (!empty($data->property_infor)) {
				$nhan_hieu = $data->property_infor[0]->value ?? '';
				$model = $data->property_infor[1]->value ?? '';
				$bien_so_xe = $data->property_infor[2]->value ?? '';
				$so_khung = $data->property_infor[3]->value ?? '';
				$so_may = $data->property_infor[4]->value ?? '';
				$ho_ten_chu_xe = $data->property_infor[5]->value ?? '';
				$dia_chi_dang_ky = $data->property_infor[6]->value ?? '';
				$so_dang_ky = $data->property_infor[7]->value ?? '';
				$ngay_cap = $data->property_infor[8]->value ?? '';
			}
			$san_pham = (!empty($data->loan_infor->loan_product->text)) ? $data->loan_infor->loan_product->text : '';
			$store_id = (!empty($data->store->id)) ? $data->store->id : '';
			$store = $this->api->apiPost($this->userInfo['token'], "store/get_store", array('id' => $store_id));
			$code_area = (!empty($store->data->code_area)) ? $store->data->code_area : '';
			$area = $this->api->apiPost($this->userInfo['token'], "area/get_area_by_code", array('code' => $code_area));
			$vung = (!empty($area->data->region->name)) ? $area->data->region->name : '';
			$mien = (!empty($area->data->domain->name)) ? $area->data->domain->name : '';
			$khu_vuc = (!empty($area->data->title)) ? $area->data->title : '';
			$bbbg_tai_san = $records->records_receive->bbbg_tai_san->quantity ?? 0;
			$bbbg_thiet_bi_dinh_vi = $records->records_receive->bbbg_thiet_bi_dinh_vi->quantity ?? 0;
			$bbh_hoi_dong_co_dong = $records->records_receive->bbh_hoi_dong_co_dong->quantity ?? 0;
			$cam_ket = $records->records_receive->cam_ket->quantity ?? 0;
			$dang_ky_xe = $records->records_receive->dang_ky_xe->quantity ?? 0;
			$hd_chuyen_nhuong = $records->records_receive->hd_chuyen_nhuong->quantity ?? 0;
			$hd_dat_coc = $records->records_receive->hd_dat_coc->quantity ?? 0;
			$hd_mua_ban_xe = $records->records_receive->hd_mua_ban_xe->quantity ?? 0;
			$hd_uy_quyen = $records->records_receive->hd_uy_quyen->quantity ?? 0;
			$hop_dong_mua_ban = $records->records_receive->hop_dong_mua_ban->quantity ?? 0;
			$phu_luc_gia_han = $records->records_receive->phu_luc_gia_han->quantity ?? 0;
			$so_do = $records->records_receive->so_do->quantity ?? 0;
			$thoa_thuan_ba_ben = $records->records_receive->thoa_thuan_ba_ben->quantity ?? 0;
			$thong_bao = $records->records_receive->thong_bao->quantity ?? 0;
			$id_manager_received = $records->updated_rcr_by ?? '';
			$time_confirm_received = !empty($records->updated_rcr_at) ? date('d/m/Y H:i:s', $records->updated_rcr_at) : '';
			$ma_luu_tru_hs = $records->code_store_rc ?? '';

			$this->sheet->setCellValue('A' . $i, $i - 1);
			$this->sheet->setCellValue('B' . $i, !empty($data->code_contract_disbursement) ? $data->code_contract_disbursement : $data->code_contract);
			$this->sheet->setCellValue('C' . $i, !empty($data->customer_infor->customer_name) ? $data->customer_infor->customer_name : "");
			$this->sheet->setCellValue('D' . $i, !empty($data->store->name) ? $data->store->name : "");
			$this->sheet->setCellValue('E' . $i, !empty($data->code_contract) ? $data->code_contract : '');
			$this->sheet->setCellValue('F' . $i, (!empty($data->disbursement_date) && empty($data->type_gh) && empty($data->type_cc)) ? date("d/m/Y", $data->disbursement_date) : "");
			$this->sheet->setCellValue('G' . $i, (!empty($data->disbursement_date) && (!empty($data->type_gh) || !empty($data->type_cc))) ? date("d/m/Y", $data->disbursement_date) : "");
			$this->sheet->setCellValue('H' . $i, (!empty($data->date_payment_finish)) ? date("d/m/Y", $data->date_payment_finish) : "");
			$this->sheet->setCellValue('I' . $i, !empty($records->status) ? file_manager_status($records->status) : "");
			$this->sheet->setCellValue('J' . $i, !empty($data->loan_infor->type_loan->code) ? $data->loan_infor->type_loan->code : "");
			$this->sheet->setCellValue('K' . $i, !empty($san_pham) ? $san_pham : "");
			$this->sheet->setCellValue('L' . $i, !empty($data->loan_infor->device_asset_location->code) ? $data->loan_infor->device_asset_location->code . " " : '');
			$this->sheet->setCellValue('M' . $i, !empty($data->loan_infor->type_property->text) ? $data->loan_infor->type_property->text : "");
			$this->sheet->setCellValue('N' . $i, $bien_so_xe);
			$this->sheet->setCellValue('O' . $i, !empty($ho_ten_chu_xe) ? $ho_ten_chu_xe : "");
			$this->sheet->setCellValue('P' . $i, !empty($dia_chi_dang_ky) ? $dia_chi_dang_ky : "");
			$this->sheet->setCellValue('Q' . $i, !empty($so_dang_ky) ? $so_dang_ky : "");
			$this->sheet->setCellValue('R' . $i, !empty($khu_vuc) ? $khu_vuc : "");
			$this->sheet->setCellValue('S' . $i, !empty($vung) ? $vung : "");
			$this->sheet->setCellValue('T' . $i, !empty($mien) ? $mien : "");
			$this->sheet->setCellValue('U' . $i, $thoa_thuan_ba_ben);
			$this->sheet->setCellValue('V' . $i, $bbbg_tai_san);
			$this->sheet->setCellValue('W' . $i, $dang_ky_xe);
			$this->sheet->setCellValue('X' . $i, $thong_bao);
			$this->sheet->setCellValue('Y' . $i, $hd_mua_ban_xe);
			$this->sheet->setCellValue('Z' . $i, $cam_ket);
			$this->sheet->setCellValue('AA' . $i, $bbbg_thiet_bi_dinh_vi);
			$this->sheet->setCellValue('AB' . $i, $bbh_hoi_dong_co_dong);
			$this->sheet->setCellValue('AC' . $i, $hop_dong_mua_ban);
			$this->sheet->setCellValue('AD' . $i, $hd_uy_quyen);
			$this->sheet->setCellValue('AE' . $i, $hd_chuyen_nhuong);
			$this->sheet->setCellValue('AF' . $i, $so_do);
			$this->sheet->setCellValue('AG' . $i, $hd_dat_coc);
			$this->sheet->setCellValue('AH' . $i, $phu_luc_gia_han);
			$this->sheet->setCellValue('AI' . $i, $id_manager_received);
			$this->sheet->setCellValue('AJ' . $i, $time_confirm_received);
			$this->sheet->setCellValue('AK' . $i, $ma_luu_kho);
			$this->sheet->setCellValue('AL' . $i, $ma_luu_tru_hs);

			$i++;
		}
	}


	public function ExportRecordsReturn()
	{
		$dataGet = $this->input->get();
		$from_date = !empty($this->security->xss_clean($dataGet['fdate'])) ? $this->security->xss_clean($dataGet['fdate']) : '';
		$to_date = !empty($this->security->xss_clean($dataGet['tdate'])) ? $this->security->xss_clean($dataGet['tdate']) : '';
		$store = !empty($this->security->xss_clean($dataGet['store'])) ? $this->security->xss_clean($dataGet['store']) : '';
		$status = !empty($this->security->xss_clean($dataGet['status'])) ? $this->security->xss_clean($dataGet['status']) : '';
		$code_contract_disbursement_search = !empty($this->security->xss_clean($dataGet['code_contract_disbursement_search'])) ? $this->security->xss_clean($dataGet['code_contract_disbursement_search']) : '';
		if (empty($from_date) || empty($to_date)) {
			echo "Vui lòng chọn thời gian để xuất dữ liệu!";
			return;
		}
		if (strtotime($from_date) > strtotime($to_date)) {
			echo "Thời gian tìm kiếm không hợp lệ!";
			return;
		}
		$dataSend = array();
		if (!empty($from_date) && !empty($to_date)) {
			$dataSend = array(
				'fdate' => $from_date,
				'tdate' => $to_date
			);
		}
		if (!empty($store)) {
			$dataSend['store'] = $store;
		}
		if (!empty($status)) {
			$dataSend['status'] = $status;
		}
		if (!empty($code_contract_disbursement_search)) {
			$dataSend['code_contract_disbursement_search'] = $code_contract_disbursement_search;
		}
		$dataSend['per_page'] = 10000;
		$recordsData = $this->api->apiPost($this->userInfo['token'], 'File_manager/get_all_sendFile_tattoan', $dataSend);
		if (empty($recordsData->data)) {
			$this->session->set_flashdata('error', "Không có dữ liệu ");
			redirect(base_url('File_manager/index_file_manager_trahstattoan'));
		} else {
			$this->fcExportRecordsReturn($recordsData->data);
			$this->callLibExcel('ReportContractFinish-' . $createBy . time() . '.xlsx');
		}
	}


	public function fcExportRecordsReturn($recordsData)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã HĐ gốc');
		$this->sheet->setCellValue('C1', 'Tên khách hàng');
		$this->sheet->setCellValue('D1', 'PGD');
		$this->sheet->setCellValue('E1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('F1', 'Ngày giải ngân');
		$this->sheet->setCellValue('G1', 'Ngày gia hạn/cơ cấu');
		$this->sheet->setCellValue('H1', 'Ngày tất toán');
		$this->sheet->setCellValue('I1', 'Trạng thái');
		$this->sheet->setCellValue('J1', 'Hình thức');
		$this->sheet->setCellValue('K1', 'Sản phẩm');
		$this->sheet->setCellValue('L1', 'IMEI Device VSET');
		$this->sheet->setCellValue('M1', 'Loại tài sản');
		$this->sheet->setCellValue('N1', 'Biển số xe');
		$this->sheet->setCellValue('O1', 'Họ tên chủ xe');
		$this->sheet->setCellValue('P1', 'Địa chỉ đăng ký');
		$this->sheet->setCellValue('Q1', 'Số đăng ký');
		$this->sheet->setCellValue('R1', 'Khu vực');
		$this->sheet->setCellValue('S1', 'Vùng');
		$this->sheet->setCellValue('T1', 'Miền');
		$this->sheet->setCellValue('U1', 'Thỏa thuận 3 bên');
		$this->sheet->setCellValue('V1', 'BBBG Tài sản');
		$this->sheet->setCellValue('W1', '"ĐKX/CVX"');
		$this->sheet->setCellValue('X1', 'Thông báo');
		$this->sheet->setCellValue('Y1', 'Hợp đồng mua bán xe');
		$this->sheet->setCellValue('Z1', 'Cam kết (nếu xe ko chính chủ)');
		$this->sheet->setCellValue('AA1', 'BBBG thiết bị định vị');
		$this->sheet->setCellValue('AB1', 'BB họp hội đồng cổ đông');
		$this->sheet->setCellValue('AC1', 'HĐ mua bán');
		$this->sheet->setCellValue('AD1', 'HĐ uỷ quyền');
		$this->sheet->setCellValue('AE1', 'HĐ chuyển nhượng');
		$this->sheet->setCellValue('AF1', 'Giấy CNQSDĐ');
		$this->sheet->setCellValue('AG1', 'HĐ đặt cọc');
		$this->sheet->setCellValue('AH1', 'Phụ lục gia hạn/cơ cấu');
		$this->sheet->setCellValue('AI1', 'ID quản lý (ID xác nhận lưu kho)');
		$this->sheet->setCellValue('AJ1', 'Thời gian xác nhận lưu kho');
		$this->sheet->setCellValue('AK1', 'Mã lưu kho');
		$this->sheet->setCellValue('AL1', 'Mã lưu trữ hồ sơ');

		$i = 2;
		foreach ($recordsData as $records) {
			$contractInfor = $this->api->apiPost($this->userInfo['token'],'File_manager/get_one_contract_by_records', ['code_contract_disbursement' => $records->code_contract_disbursement_text]);
			$records->contract_infor = $contractInfor->data ?? new stdClass();
			$so_khung = "";
			$so_may = "";
			$bien_so_xe = "";
			$model = "";
			$nhan_hieu = "";
			$ho_ten_chu_xe = "";
			$dia_chi_dang_ky = "";
			$so_dang_ky = "";
			$ngay_cap = "";
			$status_customer = "";
			$marital_status = "";
			$ma_luu_kho = "";
			$ma_luu_kho = explode('/', $records->code_contract_disbursement_text,3);
			$ma_luu_kho = end($ma_luu_kho) ?? '';
			$data = $records->contract_infor;
			if (!empty($data->property_infor)) {
				$nhan_hieu = $data->property_infor[0]->value ?? '';
				$model = $data->property_infor[1]->value ?? '';
				$bien_so_xe = $data->property_infor[2]->value ?? '';
				$so_khung = $data->property_infor[3]->value ?? '';
				$so_may = $data->property_infor[4]->value ?? '';
				$ho_ten_chu_xe = $data->property_infor[5]->value ?? '';
				$dia_chi_dang_ky = $data->property_infor[6]->value ?? '';
				$so_dang_ky = $data->property_infor[7]->value ?? '';
				$ngay_cap = $data->property_infor[8]->value ?? '';
			}
			$san_pham = (!empty($data->loan_infor->loan_product->text)) ? $data->loan_infor->loan_product->text : '';
			$store_id = (!empty($data->store->id)) ? $data->store->id : '';
			$store = $this->api->apiPost($this->userInfo['token'], "store/get_store", array('id' => $store_id));
			$code_area = (!empty($store->data->code_area)) ? $store->data->code_area : '';
			$area = $this->api->apiPost($this->userInfo['token'], "area/get_area_by_code", array('code' => $code_area));
			$vung = (!empty($area->data->region->name)) ? $area->data->region->name : '';
			$mien = (!empty($area->data->domain->name)) ? $area->data->domain->name : '';
			$khu_vuc = (!empty($area->data->title)) ? $area->data->title : '';
			$bbbg_tai_san = $records->records_receive->bbbg_tai_san->quantity ?? 0;
			$bbbg_thiet_bi_dinh_vi = $records->records_receive->bbbg_thiet_bi_dinh_vi->quantity ?? 0;
			$bbh_hoi_dong_co_dong = $records->records_receive->bbh_hoi_dong_co_dong->quantity ?? 0;
			$cam_ket = $records->records_receive->cam_ket->quantity ?? 0;
			$dang_ky_xe = $records->records_receive->dang_ky_xe->quantity ?? 0;
			$hd_chuyen_nhuong = $records->records_receive->hd_chuyen_nhuong->quantity ?? 0;
			$hd_dat_coc = $records->records_receive->hd_dat_coc->quantity ?? 0;
			$hd_mua_ban_xe = $records->records_receive->hd_mua_ban_xe->quantity ?? 0;
			$hd_uy_quyen = $records->records_receive->hd_uy_quyen->quantity ?? 0;
			$hop_dong_mua_ban = $records->records_receive->hop_dong_mua_ban->quantity ?? 0;
			$phu_luc_gia_han = $records->records_receive->phu_luc_gia_han->quantity ?? 0;
			$so_do = $records->records_receive->so_do->quantity ?? 0;
			$thoa_thuan_ba_ben = $records->records_receive->thoa_thuan_ba_ben->quantity ?? 0;
			$thong_bao = $records->records_receive->thong_bao->quantity ?? 0;
			$id_manager_received = $records->updated_rcr_by ?? '';
			$time_confirm_received = !empty($records->updated_rcr_at) ? date('d/m/Y H:i:s', $records->updated_rcr_at) : '';
			$ma_luu_tru_hs = $records->code_store_rc ?? '';
			$this->sheet->setCellValue('A' . $i, $i - 1);
			$this->sheet->setCellValue('B' . $i, !empty($data->code_contract_disbursement) ? $data->code_contract_disbursement : $data->code_contract);
			$this->sheet->setCellValue('C' . $i, !empty($data->customer_infor->customer_name) ? $data->customer_infor->customer_name : "");
			$this->sheet->setCellValue('D' . $i, !empty($data->store->name) ? $data->store->name : "");
			$this->sheet->setCellValue('E' . $i, !empty($data->code_contract) ? $data->code_contract : '');
			$this->sheet->setCellValue('F' . $i, (!empty($data->disbursement_date) && empty($data->type_gh) && empty($data->type_cc)) ? date("d/m/Y", $data->disbursement_date) : "");
			$this->sheet->setCellValue('G' . $i, (!empty($data->disbursement_date) && (!empty($data->type_gh) || !empty($data->type_cc))) ? date("d/m/Y", $data->disbursement_date) : "");
			$this->sheet->setCellValue('H' . $i, (!empty($data->date_payment_finish)) ? date("d/m/Y", $data->date_payment_finish) : "");
			$this->sheet->setCellValue('I' . $i, !empty($records->status) ? file_manager_status($records->status) : "");
			$this->sheet->setCellValue('J' . $i, !empty($data->loan_infor->type_loan->code) ? $data->loan_infor->type_loan->code : "");
			$this->sheet->setCellValue('K' . $i, !empty($san_pham) ? $san_pham : "");
			$this->sheet->setCellValue('L' . $i, !empty($data->loan_infor->device_asset_location->code) ? $data->loan_infor->device_asset_location->code . " " : '');
			$this->sheet->setCellValue('M' . $i, !empty($data->loan_infor->type_property->text) ? $data->loan_infor->type_property->text : "");
			$this->sheet->setCellValue('N' . $i, $bien_so_xe);
			$this->sheet->setCellValue('O' . $i, !empty($ho_ten_chu_xe) ? $ho_ten_chu_xe : "");
			$this->sheet->setCellValue('P' . $i, !empty($dia_chi_dang_ky) ? $dia_chi_dang_ky : "");
			$this->sheet->setCellValue('Q' . $i, !empty($so_dang_ky) ? $so_dang_ky : "");
			$this->sheet->setCellValue('R' . $i, !empty($khu_vuc) ? $khu_vuc : "");
			$this->sheet->setCellValue('S' . $i, !empty($vung) ? $vung : "");
			$this->sheet->setCellValue('T' . $i, !empty($mien) ? $mien : "");
			$this->sheet->setCellValue('U' . $i, $thoa_thuan_ba_ben);
			$this->sheet->setCellValue('V' . $i, $bbbg_tai_san);
			$this->sheet->setCellValue('W' . $i, $dang_ky_xe);
			$this->sheet->setCellValue('X' . $i, $thong_bao);
			$this->sheet->setCellValue('Y' . $i, $hd_mua_ban_xe);
			$this->sheet->setCellValue('Z' . $i, $cam_ket);
			$this->sheet->setCellValue('AA' . $i, $bbbg_thiet_bi_dinh_vi);
			$this->sheet->setCellValue('AB' . $i, $bbh_hoi_dong_co_dong);
			$this->sheet->setCellValue('AC' . $i, $hop_dong_mua_ban);
			$this->sheet->setCellValue('AD' . $i, $hd_uy_quyen);
			$this->sheet->setCellValue('AE' . $i, $hd_chuyen_nhuong);
			$this->sheet->setCellValue('AF' . $i, $so_do);
			$this->sheet->setCellValue('AG' . $i, $hd_dat_coc);
			$this->sheet->setCellValue('AH' . $i, $phu_luc_gia_han);
			$this->sheet->setCellValue('AI' . $i, $id_manager_received);
			$this->sheet->setCellValue('AJ' . $i, $time_confirm_received);
			$this->sheet->setCellValue('AK' . $i, $ma_luu_kho);
			$this->sheet->setCellValue('AL' . $i, $ma_luu_tru_hs);

			$i++;
		}
	}


	public function import_old_records()
	{
		$this->data['pageName'] = 'Import số lượng hồ sơ cho hợp đồng cũ';
		$this->data['template'] = 'page/file_manager/import_old_records.php';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}


	public function importOldRecords()
	{
		$file_name = $_FILES['upload_file']['name'] ?? '';
		$file_type = $_FILES['upload_file']['type'] ?? '';
		$file_tmp_name = $_FILES['upload_file']['tmp_name'] ?? '';
		if (empty($file_name)) {
			$response = [
				'res' => false,
				'status' => '400',
				'message' => $this->lang->line('not_selected_file_import')
			];
			return $this->pushJson('200', json_encode($response));
		} else {
			$mimes_type = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			if (isset($file_name) && in_array($file_type, $mimes_type)) {
				$arr_file = explode('.', $file_name);
				$extension = end($arr_file);
				if ($extension == 'csv') {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}

				$spreadsheet = $reader->load($file_tmp_name);
				//convert spreadsheet to array column excel
				$sheetData = $spreadsheet->getActiveSheet()->toArray();
				$quantity_column_excel = count($sheetData[0]);
				if ( $quantity_column_excel < 18 || $quantity_column_excel > 18 ) {
					$response = [
						'res' => false,
						'status' => '400',
						'message' => 'File excel không đúng mẫu import!'
					];
					return $this->pushJson('200', json_encode($response));
				}
				// Loại bỏ các ô value blank trong mảng sheetData
				$sheetDataFilter  = array_filter($sheetData, 'array_filter');
				$listFail1 = [];
				$listFail2 = [];
				foreach ($sheetDataFilter as $key => $column_excel) {
					if ($key >= 1 && !empty($column_excel['0'])) {
						$dataSend = [
							'code_contract_disbursement' => !empty($column_excel['1']) ? trim($column_excel['1']) : '',
							'thoa_thuan_ba_ben' => !empty($column_excel['2']) ? trim($column_excel['2']) : 0,
							'bbbg_tai_san' => !empty($column_excel['3']) ? trim($column_excel['3']) : 0,
							'dang_ky_xe' => !empty($column_excel['4']) ? trim($column_excel['4']) : 0,
							'thong_bao' => !empty($column_excel['5']) ? trim($column_excel['5']) : 0,
							'hd_mua_ban_xe' => !empty($column_excel['6']) ? trim($column_excel['6']) : 0,
							'cam_ket' => !empty($column_excel['7']) ? trim($column_excel['7']) : 0,
							'bbbg_thiet_bi_dinh_vi' => !empty($column_excel['8']) ? trim($column_excel['8']) : 0,
							'bbh_hoi_dong_co_dong' => !empty($column_excel['9']) ? trim($column_excel['9']) : 0,
							'hop_dong_mua_ban' => !empty($column_excel['10']) ? trim($column_excel['10']) : 0,
							'hd_uy_quyen' => !empty($column_excel['11']) ? trim($column_excel['11']) : 0,
							'hd_chuyen_nhuong' => !empty($column_excel['12']) ? trim($column_excel['12']) : 0,
							'so_do' => !empty($column_excel['13']) ? trim($column_excel['13']) : 0,
							'hd_dat_coc' => !empty($column_excel['14']) ? trim($column_excel['14']) : 0,
							'phu_luc_gia_han' => !empty($column_excel['15']) ? trim($column_excel['15']) : 0,
							'code_store_rc' => !empty($column_excel['16']) ? trim($column_excel['16']) : '',
						];
						$result = $this->api->apiPost($this->userInfo['token'],'File_manager/importOldRecords', $dataSend);


					}
				}
				if (isset($result->status) && $result->status == 200) {
					$response = [
						'res' => true,
						'status' => '200',
						'message' => $result->message
					];
					return $this->pushJson('200', json_encode($response));
				} else {
					$response = [
						'res' => true,
						'status' => '400',
						'data' => $result->data,
						'message' => $result->message ?? 'Import thất bại!'
					];
					return $this->pushJson('200', json_encode($response));
				}
			} else {
				$response = [
					'res' => false,
					'status' => "400",
					'message' => $this->lang->line('type_invalid')
				];
				return $this->pushJson('200', json_encode($response));
			}
		}
		return $this->pushJson('200', json_encode($response));
	}

	/** NV QLKV gửi YC mượn hồ sơ lên TP Quản lý khoản vay
	 * @return void
	 */
	public function send_borrowed_to_tp_qlkv()
	{
		$id_borrowed = !empty($this->dataPost['id_borrowed']) ? $this->security->xss_clean($this->dataPost['id_borrowed']) : '';
		$img_file_borrow = !empty($this->dataPost['img_file_borrow']) ? $this->security->xss_clean($this->dataPost['img_file_borrow']) : '';
		$note_qlkv = !empty($this->dataPost['note_qlkv']) ? $this->security->xss_clean($this->dataPost['note_qlkv']) : '';
		$dataSendApi = [
			'id_borrowed' => $id_borrowed,
			'file_img_approve' => $img_file_borrow,
			'note_qlkv' => $note_qlkv,
			'status' => '16',
		];

		$result = $this->api->apiPost($this->userInfo['token'], 'File_manager/send_borrowed_to_tp_qlkv', $dataSendApi);
		if (!empty($result->status) && $result->status == 200) {
			$response_js = [
				'status' => 200,
				'msg' => 'Gửi yêu cầu thành công!'
			];
		} else {
			$response_js = [
				'status' => 400,
				'msg' => 'Gửi yêu cầu thất bại!'
			];
		}
		return $this->pushJson(200, json_encode($response_js));
	}

	public function send_borrowed_to_qlhs()
	{
		$id_borrowed = !empty($this->dataPost['id_borrowed']) ? $this->security->xss_clean($this->dataPost['id_borrowed']) : '';
		$img_file_borrow = !empty($this->dataPost['img_file_borrow']) ? $this->security->xss_clean($this->dataPost['img_file_borrow']) : '';
		$note_qlkv = !empty($this->dataPost['note_qlkv']) ? $this->security->xss_clean($this->dataPost['note_qlkv']) : '';
		$dataSendApi = [
			'id_borrowed' => $id_borrowed,
			'file_img_approve' => $img_file_borrow,
			'note_qlkv' => $note_qlkv,
			'status' => '4',
		];
		$result = $this->api->apiPost($this->userInfo['token'], 'File_manager/send_borrowed_to_qlhs', $dataSendApi);
		if (!empty($result->status) && $result->status == 200) {
			$response_js = [
				'status' => 200,
				'msg' => 'Gửi duyệt thành công!'
			];
		} else {
			$response_js = [
				'status' => 400,
				'msg' => 'Gửi duyệt thất bại!'
			];
		}
		return $this->pushJson(200, json_encode($response_js));
	}

	/** Gửi YC duyệt gia hạn thời gian mượn tới TP QLKV
	 * @return null
	 */
	public function send_request_extend_borrow()
	{
		$id_borrow = !empty($this->dataPost['id_borrow']) ? $this->security->xss_clean($this->dataPost['id_borrow']) : '';
		$img_file_borrow = !empty($this->dataPost['img_file_borrow']) ? $this->security->xss_clean($this->dataPost['img_file_borrow']) : '';
		$note_approve_extend = !empty($this->dataPost['note_approve_extend']) ? $this->security->xss_clean($this->dataPost['note_approve_extend']) : '';
		$time_extend = !empty($this->dataPost['time_extend']) ? $this->security->xss_clean($this->dataPost['time_extend']) : '';
		$dataSendApi = [
			'id_borrow' => $id_borrow,
			'file_img_approve' => $img_file_borrow,
			'note_approve_extend' => $note_approve_extend,
			'time_extend' => $time_extend,
			'status' => '17',
		];
		$result = $this->api->apiPost($this->userInfo['token'], 'File_manager/send_request_extend_borrow', $dataSendApi);
		if (!empty($result->status) && $result->status == 200) {
			$response_js = [
				'status' => 200,
				'msg' => 'Gửi duyệt thành công!'
			];
		} else {
			$response_js = [
				'status' => 400,
				'msg' => $result->message
			];
		}
		return $this->pushJson(200, json_encode($response_js));
	}

	/** Gửi YC duyệt gia hạn thời gian mượn tới QLHS
	 * @return null
	 */
	public function send_request_extend_borrow_to_qlhs()
	{
		$id_borrow = !empty($this->dataPost['id_borrow']) ? $this->security->xss_clean($this->dataPost['id_borrow']) : '';
		$img_file_borrow = !empty($this->dataPost['img_file_borrow']) ? $this->security->xss_clean($this->dataPost['img_file_borrow']) : '';
		$note_extend = !empty($this->dataPost['note_extend']) ? $this->security->xss_clean($this->dataPost['note_extend']) : '';
		$time_extend = !empty($this->dataPost['time_extend']) ? $this->security->xss_clean($this->dataPost['time_extend']) : '';
		$dataSendApi = [
			'id' => $id_borrow,
			'file_img_approve' => $img_file_borrow,
			'ghichu' => $note_extend,
			'update_time_borrowed' => $time_extend,
			"created_by" => $this->userInfo['email'],
			'status' => '15',
		];
		$result = $this->api->apiPost($this->userInfo['token'], 'File_manager/send_request_extend_borrow_to_qlhs', $dataSendApi);
		if (!empty($result->status) && $result->status == 200) {
			$response_js = [
				'status' => 200,
				'msg' => 'Gửi yêu cầu thành công!'
			];
		} else {
			$response_js = [
				'status' => 400,
				'msg' => $result->message
			];
		}
		return $this->pushJson(200, json_encode($response_js));
	}

	public function update_records_origin()
	{
		$id = $this->security->xss_clean($this->dataPost['id']);
		$dataSendApi = array('id' => $id);
		$response = $this->api->apiPost($this->userInfo['token'], 'File_manager/update_records_origin', $dataSendApi);
		if (isset($response->status) && $response->status == 200) {
			$response_js = [
				'status' => 200,
				'msg' => 'Cập nhật thành công!'
			];
		} else {
			$response_js = [
				'status' => 400,
				'msg' => $response->message
			];
		}
		return $this->pushJson(200, json_encode($response_js));
	}

	public function approveHandOver(){

		$code_contract = $this->security->xss_clean($this->dataPost['code_contract']) ?? '';

		$res = $this->api->api_core_Post($this->user['token'], "assetLocation/contract/recall_device_hand_over", ['code_contract' => $code_contract]);

		if (!empty($res->status) && $res->status == 200) {
			$response = [
				'status' => 200,
				'message' => 'success',
			];
			return $this->pushJson(200, json_encode($response));
		} else {
			$response = [
				'status' => 400,
				'message' => !empty($res->message) ? $res->message : 'Thất bại',
			];
			return $this->pushJson(200, json_encode($response));
		}


	}


	public function updateAllStatusNoti(){

		$return = $this->api->apiPost( $this->userInfo['token'], "user/update_read_all_notification_filemanager");
		if (!empty($return->status && $return->status == 200)) {
			$data['status'] = 200;
			$data['message'] = 'Thành công';

			echo json_encode($data);
			return;
		} else {
			$data['status'] = 401;
			$data['message'] = 'Có lỗi xảy ra!';
			echo json_encode($data);
			return;
		}


	}

}


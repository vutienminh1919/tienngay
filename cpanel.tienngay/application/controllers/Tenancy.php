<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;


class Tenancy extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("time_model");
		$this->load->helper('lead_helper');
		$this->load->library('pagination');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->config->load('config');
		$this->load->library('pagination');
		$this->createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
		$this->spreadsheet = new Spreadsheet();
		$this->sheet = $this->spreadsheet->getActiveSheet();
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	public function createTenancy()
	{

		$result = $this->api->apiPost($this->user['token'],"tenancy/getAll");
		$this->data['result_bank_name'] = $result->data;

		$result = $this->api->apiPost($this->user['token'],"tenancy/get_all_district");
		$this->data['result_district'] = $result->data;

		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$this->data['template'] = 'page/hdnd/thuematbang';
		$this->load->view('template', $this->data);
	}

	public function tenancyInsert()
	{
		$data = $this->input->post();
		$cpanelV2 = $this->config->item("cpanel_v2_url");
		$token = $this->userInfo['token'];
		$id = !empty($data['id']) ? $data['id'] : "";
		$code_contract = !empty($data['code_contract']) ? $data['code_contract'] : "";
		$date_contract = !empty($data['date_contract']) ?$data['date_contract'] : "";
		$contract_expiry_date = !empty($data['contract_expiry_date']) ? $data['contract_expiry_date'] : "";
		$start_date_contract = !empty($data['start_date_contract']) ? ($data['start_date_contract']) : "";
		$end_date_contract = !empty($data['end_date_contract']) ? ($data['end_date_contract']) : "";
		$store = !empty($data['store']) ? $data['store'] : "";
		$name_cty = !empty($data['name_cty']) ? $data['name_cty'] : "";
		$address = !empty($data['address']) ? $data['address'] : "";
		$staff_ptmb = !empty($data['staff_ptmb']) ? $data['staff_ptmb'] : "";
		$one_month_rent = !empty($data['one_month_rent']) ? (trim(str_replace(array(',', '.',), '', $data['one_month_rent']))) : "";
		$ky_tra = !empty($data['ky_tra']) ? $data['ky_tra'] : "";
		$customer_infor = !empty($data['customer_infor']) ? $data['customer_infor'] : "";
		$ten_chu_nha = !empty($data['ten_chu_nha']) ? $data['ten_chu_nha'] : "";
		$sdt_chu_nha = !empty($data['sdt_chu_nha']) ? $data['sdt_chu_nha'] : "";
		$ten_tk_chu_nha = !empty($data['ten_tk_chu_nha']) ? $data['ten_tk_chu_nha'] : "";
		$so_tk_chu_nha = !empty($data['so_tk_chu_nha']) ? $data['so_tk_chu_nha'] : "";
		$bank_name = !empty($data['bank_name']) ? $data['bank_name'] : "";
		$ngay_dat_coc = !empty($data['ngay_dat_coc']) ?$data['ngay_dat_coc'] : "";
		$tien_coc = !empty($data['tien_coc']) ? (trim(str_replace(array(',', '.',), '', $data['tien_coc']))) : "";
		$ma_so_thue = !empty($data['ma_so_thue']) ? $data['ma_so_thue'] : "";
		$nguoi_nop_thue = !empty($data['nguoi_nop_thue']) ? $data['nguoi_nop_thue'] : "";
		$created_by = $this->userInfo['email'];
		$status = !empty($data['status']) ? $data['status'] : "";
		$hop_dong_so = !empty($data['hop_dong_so']) ? $data['hop_dong_so'] : "";
		$tien_thue = !empty($data['tien_thue']) ? $data['tien_thue'] : "";
		$created_at = !empty($data['created_at']) ? $data['created_at'] : "";
		$store_name = !empty($data['store_name']) ? $data['store_name'] : "";
		$dien_tich = !empty($data['dien_tich']) ? $data['dien_tich'] : "";


		$data1 = [
			"id" => $id,
			"code_contract" => $code_contract,
			"date_contract" => $date_contract,
			"contract_expiry_date" => $contract_expiry_date,
			"start_date_contract" => $start_date_contract,
			"end_date_contract" => $end_date_contract,
			"store" => $store,
			"address" => $address,
			"staff_ptmb" => $staff_ptmb,
			"one_month_rent" => $one_month_rent,
			"ky_tra" => $ky_tra,
			"customer_infor" => $customer_infor,
			"ten_chu_nha" => $ten_chu_nha,
			"sdt_chu_nha" => $sdt_chu_nha,
			"ten_tk_chu_nha" => $ten_tk_chu_nha,
			"so_tk_chu_nha" => $so_tk_chu_nha,
			"bank_name" => $bank_name,
			"tien_coc" => $tien_coc,
			"ngay_dat_coc" => $ngay_dat_coc,
			"tien_coc" => $tien_coc,
			"ma_so_thue" => $ma_so_thue,
			"nguoi_nop_thue" => $nguoi_nop_thue,
			"status" => $status,
			"hop_dong_so" => $hop_dong_so,
			"tien_thue" => $tien_thue,
			"created_at" => $created_at,
			"name_cty" => $name_cty,
			"created_by" => $created_by,
			"store_name" => $store_name,
			"dien_tich" => $dien_tich,
			'typeMsg' => 'all'
		];

		$resultTenancy = $this->api->api_core_Post($this->userInfo['token'], 'tenancy/create_tenancy', $data1);
		if ($resultTenancy && $resultTenancy->status == 200) {
			$response = [
				'status' => "200",
				'msg' => $resultTenancy->message,
				'data' => $resultTenancy
			];
		} else {
			$response = [
				'status' => "400",
				'msg' => $resultTenancy->message,
				'data' => $resultTenancy
			];
		}
		echo json_encode($response);
		return;

	}

	public function curlTenancy($service, $data = [])
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $service,
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CUSTOMREQUEST => "POST",
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$data = json_decode($response, true);
		return $data;
	}

	public function update_status()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : "";
		$result = $this->api->api_core_Post($this->userInfo['token'],"tenancy/update_status/" . $id);

		if ($result && $result->status == 200) {
			$response = [
				'status' => "200",
				'msg' => 'Cập nhật thành công',
				'data' => $result
			];
		} else {
			$response = [
				'status' => "400",
				'msg' => "cập nhật thất bại",
				'data' => $result
			];
		}
		echo json_encode($response);
		return;
	}

	public function listTenancy()
	{
		$start_date = !empty($_GET['start_date_contract_uni']) ? $_GET['start_date_contract_uni'] : "";
		$end_date = !empty($_GET['end_date_contract_uni']) ? $_GET['end_date_contract_uni'] : "";
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
				$config1['base_url'] = base_url('tenancy/listTenancy?tab=tat-ca' . '&start_date_contract_uni=' . $start_date . '&end_date_contract_uni=' . $end_date);
		$config1['per_page'] = 15;
		$config1['uri_segment'] = $uriSegment;
		$config1['enable_query_strings'] = true;
		$config1['page_query_string'] = true;
		$data1 = [
			'start_date_contract_uni' => $start_date,
			'end_date_contract_uni' => $end_date,
			'code_contract' => $_GET['code_contract_tat_ca'] ?? "" ,
			'status' => $_GET['status'] ?? "",
			'limit' =>$config1['per_page'],
			'offset' => $config1['uri_segment'],
			'typeQuery' => 'get'
		];
		$data2 = [
			'code_contract' =>$_GET['code_contract_toi_han'] ?? "",
			'status' => $_GET['status_toi_han'] ?? "",
			'status_thue' => $_GET['status_thue_toi_han'] ?? ""
		];

		$data3 = [
			'code_contract' => $_GET['code_contract_qua_han'] ?? "",
			'status' => $_GET['status_qua_han'] ?? "",
			'status_thue' => $_GET['status_thue_qua_han'] ?? ""
		];

		$result = $this->api->api_core_Post($this->userInfo['token'], 'tenancy/list',$data1);
		if ($result && $result->status == 200) {
			$this->data['contract'] = $result->data->data;
			$config1['total_rows'] = $result->data->total;
			$this->data['total'] = $result->data->total;
		}else{
			$this->session->set_flashdata('error', $result->message ?? 'that bai');
			$this->data['contract'] = [];
		}
		$toi_han = $this->api->api_core_Post($this->userInfo['token'],'tenancy/toi_han',$data2);
		if ($toi_han && $toi_han->status == 200){
			$this->data['toi_han'] = $toi_han->data;
		}else{
			$this->data['toi_han'] = [];
		}
		$qua_han = $this->api->api_core_Post($this->userInfo['token'],'tenancy/qua_han',$data3);
		if ($qua_han && $qua_han->status == 200) {
			$this->data['qua_han'] = $qua_han->data;
		} else {
			$this->data['qua_han'] = [];
		}

		$result = $this->api->apiPost($this->user['token'],"tenancy/get_all_district");
		$this->data['result_district'] = $result->data;

		$result = $this->api->apiPost($this->user['token'],"tenancy/getAll");
		$this->data['result_bank_name'] = $result->data;

		$notification = $this->api->api_core_Post($this->userInfo['token'],'tenancy/getDataAll');
		if ($notification && $notification->status == 200) {
			$this->data['notification'] = $notification->data;
		} else {
			$this->data['notification'] = [];
		}

		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$notificationTenancy = $this->api->api_core_Post($this->userInfo['token'],'tenancy/get_all_tenancy');
		if (!empty($notificationTenancy->status) && $notificationTenancy->status == 200) {
			$this->data['notification_tenancy'] = $notificationTenancy->data;
		} else {
			$this->data['notification_tenancy'] = array();
		}

		$this->data['userInfo'] = $this->userInfo['is_superadmin'];
		$this->pagination->initialize($config1);
		$this->data['pagination1'] = $this->pagination->create_links();
		$this->data['template'] = 'page/hdnd/ds_hopdong';
		$this->load->view('template', $this->data,$this->session);
	}

	public function detail_tenancy()
	{
		$result = $this->api->api_core_Post($this->userInfo['token'], 'tenancy/detail_tenancy/' . $_GET['id']);
		if ($result && $result->status == 200) {
			$this->data['resutl'] = $result->data->detail;
			$this->data['code'] = $result->data->code;
		} else {
			$this->session->set_flashdata('error', $result->message ?? 'that bai');
			$this->data['resutl'] = [];
			$this->data['code'] = [];
		}
		if (!empty($result->data->detail->image_tenancy)) {
			$arr_img_tenancy = [];
			foreach ($result->data->detail->image_tenancy as $value) {
				array_push($arr_img_tenancy, $value);
			}
		}
		$this->data['img_tenancy'] = $arr_img_tenancy;
		$logs = $this->api->api_core_Post($this->userInfo['token'],'tenancy/findLogs/'. $_GET['id']);
		if ($logs) {
			$this->data['logs'] = $logs;
		} else {
			$this->data['logs'] = [];
		}

		$result_appendix = $this->api->api_core_Post($this->userInfo['token'],'tenancy/findOneAppendix/'. $_GET['id']);
		$this->data['result_appendix'] = $result_appendix->data;

		$result_ptmb = $this->api->api_core_Post($this->userInfo['token'], "tenancy/findUserPtmb");
		$this->data['result_ptmb'] = $result_ptmb->data;

		$moneySum = $result->data->detail->code_contract;
		$data1 = [
			'code_contract' => $moneySum,
		];
		$resultMoney = $this->api->api_core_Post($this->userInfo['token'], "tenancy/updateMoney",$data1);
		if ($resultMoney && $resultMoney->status == 200){
			$this->data['tong_tien_phai_tra'] = $resultMoney->data->data;
			$this->data['tien_tra_thuc_te'] = $resultMoney->data->data1;
		}else{
			$this->data['tong_tien_phai_tra'] = 0;
			$this->data['tien_tra_thuc_te'] = 0;
		}

		$resultmoneyPax = $this->api->api_core_Post($this->userInfo['token'], "tenancy/updateMoneyPax",$data1);
		if ($resultMoney && $resultMoney->status == 200){
			$this->data['tong_tien_thue_phai_tra'] = $resultmoneyPax->data->data;
			$this->data['tien_thue_tra_thuc_te'] = $resultmoneyPax->data->data1;
		}else{
			$this->data['tong_tien_thue_phai_tra'] = 0;
			$this->data['tien_thue_tra_thuc_te'] = 0;
		}

		$resultDeposit = $this->api->api_core_Post($this->userInfo['token'],"tenancy/history_payment_deposit/" . $_GET['id']);
		if ($resultDeposit && $resultDeposit->status == 200){
			$this->data['deposit'] = $resultDeposit->data;
		}else{
			$this->data['deposit'] = [];
		}

		$resultDepositHome = $this->api->api_core_Post($this->userInfo['token'],"tenancy/history_payment_deposit_home/" . $_GET['id']);
		if ($resultDepositHome && $resultDepositHome->status == 200){
			$this->data['depositHome'] = $resultDepositHome->data;
		}else{
			$this->data['depositHome'] = [];
		}

		$result = $this->api->apiPost($this->user['token'], "tenancy/getAll");
		$this->data['result_bank_name'] = $result->data;

		$result = $this->api->apiPost($this->user['token'], "tenancy/get_all_district");
		$this->data['result_district'] = $result->data;

		$this->data['template'] = 'page/hdnd/ct_hd';
		$this->load->view('template', $this->data);
	}

	public function note_tenancy()
	{
		$data = $this->input->post();
		$note = !empty($data['note']) ? $data['note'] : "";
		$id = !empty($data['id']) ? $data['id'] : "";
		$note_description = !empty($data['note_description']) ? $data['note_description'] : "";
		$created_by = $this->userInfo['email'];
		$data1 = [
			'_id' => $id,
			'note' => $note,
			'note_description' => $note_description,
			"created_by" => $created_by
		];
		$result = $this->api->api_core_Post($this->userInfo['token'],'tenancy/note_tenancy',$data1);
		if ($result && $result->status == 200) {
			$response = [
				'status' => "200",
				'msg' => $result->message,
				'data' =>$result
			];
		} else {
			$response = [
				'status' => "400",
				'msg' => $result->message,
				'data' =>$result
			];
		}
		echo json_encode($response);
		return;
	}

	public function findOnePaymentPeriod()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : "";
		$result  = $this->api->api_core_Post($this->userInfo['token'],'tenancy/find_one_payment_priod/'.$id);
		$this->data['resutl_note'] = $result->data->noteOneTenancy;
		$response = [
			'status' => "200",
			'msg' => 'Cập nhật thành công',
			'data' => $result->data
		];
		echo json_encode($response);
		return;
	}

	public function payment_Tenancy()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : "";
		$code_contract = !empty($data['code_contract']) ? $data['code_contract'] : "";
		$one_month_rent = !empty($data['one_month_rent']) ? (trim(str_replace(array(',', '.',), '', $data['one_month_rent']))) : "";
		$tien_coc = !empty($data['tien_coc']) ? (trim(str_replace(array(',', '.',), '', $data['tien_coc']))) : 0;
		$id_tong_tenancy = !empty($data['id_tong_tenancy']) ? $data['id_tong_tenancy'] : "";
		$ngay_thanh_toan_tt = !empty($data['ngay_thanh_toan_tt']) ? $data['ngay_thanh_toan_tt'] : "";
		$data1 = [
			'_id' => $id,
			'code_contract' => $code_contract,
			'one_month_rent' => $one_month_rent,
			'tien_coc' => $tien_coc,
			'ngay_thanh_toan_tt' => $ngay_thanh_toan_tt,
		];
		$result = $this->api->api_core_Post($this->userInfo['token'],'tenancy/payment_tenancy/'.$id_tong_tenancy,$data1);
		if ($result && $result->status == 400){
			$response = [
			'status' => "400",
			'msg' => $result->message,
			'msg_text' => $result->message
		];
		}else{
			$response = [
				'status' => "200",
				'msg' => 'Thanh toán thành công',
				'data' => $result->data
			];
		}
		echo json_encode($response);
		return;
	}

	public function thanh_toan_thue()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : "";
		$code_contract = !empty($data['code_contract']) ? $data['code_contract'] : "";
		$tien_thue = !empty($data['tien_thue']) ? (trim(str_replace(array(',', '.',), '', $data['tien_thue']))) : "";
		$ngay_thanh_toan_thue = !empty($data['ngay_thanh_toan_thue']) ? ($data['ngay_thanh_toan_thue']) : "";
		$id_tong = !empty($data['id_tong']) ? $data['id_tong'] : "";
		$image_thue = !empty($data['image_thue']) ? json_decode($data['image_thue']) : "";
		$data1 = [
			'_id' => $id,
			'code_contract' => $code_contract,
			'tien_thue' => $tien_thue,
			'ngay_thanh_toan_thue' => $ngay_thanh_toan_thue,
			'created_by' => $this->userInfo['email'],
			'image_thue' => $image_thue,
		];
		$result = $this->api->api_core_Post($this->userInfo['token'],'tenancy/thanh_toan_thue/'.$id_tong,$data1);
		if ($result && $result->status == 200) {
			$response = [
				'status' => "200",
				'msg' => 'Thanh toán thành công',
				'data' => $result->data
			];
		} else {
			$response = [
				'status' => "400",
				'msg' => 'Thanh toán thuế không thành công',
				'msg_text' => $result->message
			];
		}
		echo json_encode($response);
		return;
	}

	public function Thanh_ly_hop_dong()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : "";
		$data1 = [
			'ngay_tlhd' => $ngay_tlhd
		];
		$result = $this->api->api_core_Post($this->userInfo['token'],'tenancy/Thanh_ly_hop_dong/'. $id);
		if ($result && $result->status == 200){
			$response = [
				'status' => "200",
				'msg' => 'Thanh lý hợp đồng thành công',
			];
			echo json_encode($response);
		}else{
			$response = [
				'status' => "400",
				'msg' => 'Thanh lý hợp đồng không thành công',
			];
			echo json_encode($response);
		}
		return;
	}

	public function updateTenancy()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : "";
		$nguoi_nop_thue = !empty($data['nguoi_nop_thue']) ? $data['nguoi_nop_thue'] : "";
		$ma_so_thue = !empty($data['ma_so_thue']) ? $data['ma_so_thue'] : "";
		$staff_ptmb = !empty($data['staff_ptmb']) ? $data['staff_ptmb'] : "";
		$data1 = [
			'nguoi_nop_thue' => $nguoi_nop_thue,
			'ma_so_thue' => $ma_so_thue,
			'staff_ptmb' => $staff_ptmb,
		];
		$result = $this->api->api_core_Post($this->userInfo['token'],'tenancy/update_tenancy/'. $id,$data1);
		if ($result && $result->status == 200) {
			$response = [
				'status' => "200",
				'msg' => 'Cập nhật thành công',
			];
		} else {
			$response = [
				'status' => "400",
				'msg' => 'Cập nhật không thành công',
			];
		}

		echo json_encode($response);
		return;
	}

	public function pushJson($code, $data)
	{
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}

	public function uploadImage()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : "";
		$image_tenancy = !empty($data['image_tenancy']) ? json_decode($data['image_tenancy']) : "";
		$data1 = [
			'image_tenancy' => $image_tenancy,
			'id' => $id
		];
		$result = $this->api->api_core_Post($this->userInfo['token'],'tenancy/uploadScanHd',$data1);

		if ( $result && $result->status == 200 ) {
			$response = [
				'status' => "200",
				'msg' => 'Cập nhật thành công',
			];
			echo json_encode($response);
		} else {
			$response = [
				'status' => "400",
				'msg' => 'Cập nhật không thành công',
			];
			echo json_encode($response);
		}
		return;

	}
	
	public function upload_img()
	{
		// $data = $this->input->post();
		if ($_FILES['file']['size'] > 20000000) {
			return $this->pushJson('200', json_encode(array(
				'code' => '201',
				'msg' => 'Kích cỡ max là 10MB'
			)));
		}
		$acceptFormat = array("jpeg", "png", "jpg", "mp3", "mp4","pdf");
		if (in_array($_FILES['file']['type'], $acceptFormat)) {
			return $this->pushJson('200', json_encode(array(
				'code' => '201',
				'msg' => 'Định dạng không cho phép',
				'type' => $_FILES['file']['type']
			)));
		}
		$serviceUpload = $this->config->item("url_service_upload");
		// $curlFile  = new CURLFile($_FILES["avatar"]["tmp_name"],$_FILES["avatar"]["type"],$_FILES["avatar"]["name"]);
		$cfile = new CURLFile($_FILES['file']["tmp_name"], $_FILES['file']["type"], $_FILES['file']["name"]);
		$post = array('avatar' => $cfile);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $serviceUpload);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		$result1 = json_decode($result);

		$random = sha1(substr(md5(rand()), 0, 8));

		if (empty($result1->path)) {
			return $this->pushJson('200', json_encode(array(
				'code' => '201',
				'msg' => 'File lỗi! Hệ thống không đọc được file (file ảnh bạn mở màn hình chụp lại rồi tạo ảnh mới upload lại)'
			)));
		} else {
			$response = array(
				'code' => 200,
				"msg" => "success",
				'path' => $result1->path,
				'key' => $random,
				'raw_name' => $_FILES['file']['name']
			);
			$push = json_encode($response);
			return $this->pushJson(200, $push);
		}
	}

	public function newInsertKyHan()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : "";
		$start_date_contract = !empty($data['start_date_contract']) ? ($data['start_date_contract']) : "";
		$end_date_contract = !empty($data['end_date_contract']) ? 	($data['end_date_contract']) : "";
		$ky_tra = !empty($data['ky_tra']) ? $data['ky_tra'] : "";
		$contract_expiry_date = !empty($data['contract_expiry_date']) ? $data['contract_expiry_date'] : "";
		$hop_dong_so = !empty($data['hop_dong_so']) ? $data['hop_dong_so'] : "";
		$one_month_rent = !empty($data['one_month_rent']) ? (trim(str_replace(array(',', '.',), '', $data['one_month_rent']))) : "";
		$created_at = !empty($data['created_at']) ? $data['created_at'] : "";
		$data1 = [
			'start_date_contract' => $start_date_contract,
			'end_date_contract' => $end_date_contract,
			'ky_tra' => $ky_tra,
			'contract_expiry_date' => $contract_expiry_date,
			'one_month_rent' => $one_month_rent,
		];
		$result = $this->api->api_core_Post($this->userInfo['token'],'tenancy/insert_new_tenancy/'.$id,$data1);
		if ($result && $result->status == 200) {
			$response = [
				'status' => "200",
				'msg' => $result->message,
				'data' => $result->data
			];
		} else {
			$response = [
				'status' => "400",
				'msg' => $result->message,
				'msg_text' => $result->message
			];
		}
		echo json_encode($response);
		return;
	}

	public function findImageThue()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : "";

		$result = $this->api->api_core_Post($this->userInfo['token'], 'tenancy/findImageKyHan',['id'=>$id]);
		if ($result && $result->status == 400){
			$response = [
			'status' => "400",
			'msg' => 'Thanh toán không thành công',
			'msg_text' => $result->message
		];
		}else{
			$response = [
				'status' => "200",
				'msg' => 'Thanh toán thành công',
				'data' => $result->data
			];
		}
		echo json_encode($response);
		return;
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

	public function excel_tmb()
	{
		$start_date = !empty($_GET['start_date_contract_uni']) ? $_GET['start_date_contract_uni'] : "";
		$end_date = !empty($_GET['end_date_contract_uni']) ? $_GET['end_date_contract_uni'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$data1 = [
			'start_date_contract_uni' => $start_date,
			'end_date_contract_uni' => $end_date,
			'code_contract' => $code_contract,
			'typeQuery' => 'excel'
		];
		$resultExcelAll = $this->api->api_core_Post($this->userInfo['token'], "tenancy/list", $data1);
		if ($resultExcelAll && $resultExcelAll->status == 200) {
			$this->export_list_ke_toan($resultExcelAll->data->data);
			$this->callLibExcel('danh-sach-hop-dong-thue-nha' . date('Y-m-d') . '.xlsx');
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	public function export_list_ke_toan($data)
	{
			$this->sheet->setCellValue('A1', 'Số Hợp Đồng')->getColumnDimension('A')->setAutoSize(true);
			$this->sheet->setCellValue('B1', 'Ngày kí')->getColumnDimension('B')->setAutoSize(true);
			$this->sheet->setCellValue('C1', 'Ngày bắt đầu')->getColumnDimension('C')->setAutoSize(true);
			$this->sheet->setCellValue('D1', 'Ngày hết hạn')->getColumnDimension('D')->setAutoSize(true);
			$this->sheet->setCellValue('E1', 'Khu vực')->getColumnDimension('E')->setAutoSize(true);
			$this->sheet->setCellValue('F1', 'Tên phòng giao dịch')->getColumnDimension('F')->setAutoSize(true);
			$this->sheet->setCellValue('G1', 'Tên công ty')->getColumnDimension('G')->setAutoSize(true);
			$this->sheet->setCellValue('H1', 'Giá thuê/tháng')->getColumnDimension('H')->setAutoSize(true);
			$this->sheet->setCellValue('I1', 'Tiền đặt cọc')->getColumnDimension('I')->setAutoSize(true);
			$this->sheet->setCellValue('J1', 'Diện tích thuê')->getColumnDimension('J')->setAutoSize(true);
			$this->sheet->setCellValue('K1', 'Nhân viên phụ trách')->getColumnDimension('K')->setAutoSize(true);
			$i = 2;
			foreach ($data as $item) {
				$this->sheet->setCellValue('A' . $i, !empty($item->code_contract) ? $item->code_contract : '');
				$this->sheet->setCellValue('B' . $i, !empty($item->date_contract) ? ($item->date_contract) : '');
				$this->sheet->setCellValue('C' . $i, !empty($item->start_date_contract) ? $item->start_date_contract : '');
				$this->sheet->setCellValue('D' . $i, !empty($item->end_date_contract) ? $item->end_date_contract : '');
				$this->sheet->setCellValue('E' . $i, !empty($item->store->address) ? $item->store->address : '');
				$this->sheet->setCellValue('F' . $i, !empty($item->store->store_name) ? ($item->store->store_name) : '');
				$this->sheet->setCellValue('G' . $i, !empty($item->name_cty) ?	($item->name_cty) : '');
				$this->sheet->setCellValue('H' . $i, !empty($item->one_month_rent) ? ($item->one_month_rent) : '');
				$this->sheet->setCellValue('I' . $i, !empty($item->tien_coc) ? $item->tien_coc : "");
				$this->sheet->setCellValue('J' . $i, !empty($item->dien_tich) ? $item->dien_tich : '');
				$this->sheet->setCellValue('K' . $i, !empty($item->staff_ptmb) ? ($item->staff_ptmb) : '');
				$i++;
			}
	}

	public function importTenancy()
	{
		if (empty($_FILES['upload_file']['name'])) {
			$this->session->set_flashdata('error', $this->lang->line('not_selected_file_import'));
			redirect('Tenancy/createTenancy');
		} else {
			$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
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

				$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
				$sheetData[0] = array_filter($sheetData[0]);
				if (count($sheetData[0]) != 22) {
					$this->session->set_flashdata('error', "Bạn nhập sai mẫu file");
					redirect('Tenancy/createTenancy');
				}

				foreach ($sheetData as $key => $value) {
					if ($key >= 1) {
						if (strtotime($value[0]) > $createdAt) {
							$this->session->set_flashdata('error', "Thời gian khởi tạo không được lớn hơn thời gian hiện tại!");
							redirect('Tenancy/createTenancy');
						}
					}
				}
				$arr_error = [];
				foreach ($sheetData as $key => $value) {
					if ($key >= 1) {
						if ($value["0"] == '') continue;
						$data = [
							'code_contract' => $value[1],
							'date_contract' => $value[2],
							'contract_expiry_date' => $value[3],
							'start_date_contract' => $value[4],
							'end_date_contract' => $value[5],
							'store_name' => $value[6],
							'address' => $value[7],
							'name_cty' => $value[8],
							'staff_ptmb' => $value[9],
							'ten_chu_nha' => $value[10],
							'sdt_chu_nha' => $value[11],
							'ten_tk_chu_nha' => $value[12],
							'so_tk_chu_nha' => $value[13],
							'bank_name' => $value[14],
							'tien_coc' => (trim(str_replace(array(',', '.',), '', $value[15]))),
							'ngay_dat_coc' => $value[16],
							'one_month_rent' => (trim(str_replace(array(',', '.',), '', $value[17]))),
							'ky_tra' => $value[18],
							'ma_so_thue' => $value[19],
							'nguoi_nop_thue' => $value[20],
							'dien_tich' => $value[21]
						];
						$result = $this->api->api_core_Post($this->userInfo['token'], 'tenancy/create_tenancy', $data);

						if ($result->status == 400) {
							$arr_error[] = 'dòng ' . ++$key . ': ' . $result->message;
						}
					}
				}
				if (count($arr_error) > 0) {
					$message = '';
					foreach ($arr_error as $va) {
						$message .= $va . "<br>\n";
					}
					$this->session->set_flashdata('error', $message);
					redirect('Tenancy/createTenancy');
				} else {
					$this->session->set_flashdata('success', $this->lang->line('import_success'));
					redirect('Tenancy/listTenancy');
				}
			}else{
				$this->session->set_flashdata('error', 'Sai định dạng file');
				redirect('Tenancy/createTenancy');
			}
		}
	}

	public function notificationTenancy()
	{
		$data = $this->input->post();
		$code_contract = !empty($data['code_contract']) ? $data['code_contract'] : "";
		$ngay_thanh_toan = !empty($data['ngay_thanh_toan']) ? ($data['ngay_thanh_toan']) : "";
		$ngay_thanh_toan_tt = !empty($data['ngay_thanh_toan_tt']) ?(($data['ngay_thanh_toan_tt'])) : "";
		$hop_dong_so = !empty($data['hop_dong_so']) ? $data['hop_dong_so'] : "";
		$one_month_rent = !empty($data['one_month_rent']) ? $data['one_month_rent'] : "";
		$status_notification = !empty($data['status_notification']) ? $data['status_notification'] : "";
		$dataNotification = [
			'code_contract' => $code_contract,
			'ngay_thanh_toan' => $ngay_thanh_toan,
			'ngay_thanh_toan_tt' => $ngay_thanh_toan_tt,
			'one_month_rent' => $one_month_rent,
			'hop_dong_so' => $hop_dong_so,
			'status' => $status_notification,
		];

		$notification = $this->api->api_core_Post($this->userInfo['token'], 'tenancy/createData', $dataNotification);
		if ($notification && $notification->status == 200) {
			$response = [
				'status' => "200",
				'msg' => 'Thêm mới thành công',
				'data' => $notification
			];
		} else {
			$response = [
				'status' => "400",
				'msg' => 'Thêm mới thất bại',
				'data' => $notification
			];
		}
		echo json_encode($response);
		return;
	}

	public function quaHanExcel()
	{
		$resultExcelAll = $this->api->api_core_Post($this->userInfo['token'], "tenancy/qua_han");
		if ($resultExcelAll && $resultExcelAll->status == 200) {
			$this->export_list_ke_toan_qua_han($resultExcelAll->data);
			$this->callLibExcel('danh-sach-hop-dong-thue-nha-qua-han' . date('Y-m-d') . '.xlsx');
		}else{
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	public function export_list_ke_toan_qua_han($data)
	{
		$this->sheet->setCellValue('A1', 'Số Hợp Đồng')->getColumnDimension('A')->setAutoSize(true);
		$this->sheet->setCellValue('B1', 'Giá thuê/tháng')->getColumnDimension('B')->setAutoSize(true);
		$this->sheet->setCellValue('C1', 'Kì hạn thanh toán')->getColumnDimension('C')->setAutoSize(true);
		$this->sheet->setCellValue('D1', 'Tổng tiền trả')->getColumnDimension('D')->setAutoSize(true);
		$this->sheet->setCellValue('E1', 'Trạng thái thanh toán')->getColumnDimension('E')->setAutoSize(true);
		$this->sheet->setCellValue('F1', 'Ngày đến hạn thanh toán')->getColumnDimension('F')->setAutoSize(true);
		$this->sheet->setCellValue('G1', 'Thuế GTGT +thuế TNCN')->getColumnDimension('G')->setAutoSize(true);
		$this->sheet->setCellValue('H1', 'Trạng thái nộp thuế')->getColumnDimension('H')->setAutoSize(true);
		$i = 2;
		foreach ($data as $item){
			$this->sheet->setCellValue('A' . $i, !empty($item->code_contract) ? $item->code_contract : '');
			$this->sheet->setCellValue('B' . $i, $item->one_month_rent / $item->ky_tra );
			$this->sheet->setCellValue('C' . $i, !empty($item->ky_tra) ? $item->ky_tra : '');
			$this->sheet->setCellValue('D' . $i, !empty($item->one_month_rent) ? $item->one_month_rent : '');
			$this->sheet->setCellValue('E' . $i, !empty($item->status) ? $item->status : '');
			$this->sheet->setCellValue('F' . $i, !empty($item->ngay_thanh_toan) ? ($item->ngay_thanh_toan) : '');
			$this->sheet->setCellValue('G' . $i, !empty($item->tien_thue) ? ($item->tien_thue) : '');
			$this->sheet->setCellValue('H' . $i, !empty($item->status_thue) ? ($item->status_thue) : '');
			$i++;
		}
	}

	public function update_notification()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : '';
		$result = $this->api->api_core_Post($this->userInfo['token'],"tenancy/statusNotification/" . $id);

		if ($result && $result->status == 200) {
			$response = [
				'status' => "200",
				'msg' => 'Cập nhật thành công',
				'data' => $result
			];
		} else {
			$response = [
				'status' => "400",
				'msg' => "cập nhật thất bại",
				'data' => $result
			];
		}
		echo json_encode($response);
		return;
	}

	public function updatePaymentKyHan()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : "";
		$one_month_rent = !empty($data['one_month_rent']) ? (trim(str_replace(array(',', '.',), '', $data['one_month_rent']))) : "";
		$ky_tra = !empty($data['ky_tra']) ? $data['ky_tra'] : "";
		$ngay_thanh_toan = !empty($data['ngay_thanh_toan']) ? $data['ngay_thanh_toan'] : "";
		$id_tong_tenancy = !empty($data['id_tong_tenancy']) ? $data['id_tong_tenancy'] : "";
		$data1 = [
			'_id' => $id,
			'ngay_thanh_toan' => $ngay_thanh_toan,
			'one_month_rent' => $one_month_rent,
			'ky_tra' => $ky_tra,
		];
		$result = $this->api->api_core_Post($this->userInfo['token'],'tenancy/update_payment_ky_han/'.$id_tong_tenancy,$data1);
		if ($result && $result->status == 200){
			$response = [
			'status' => "200",
			'msg' => 'Thành công',
			'data' => $result->data
		];
		}else{
			$response = [
				'status' => "400",
				'msg' => 'Không thành công',
				'msg' => $result->message,
			];
		}
		echo json_encode($response);
		return;
	}

	public function findOnePayment()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		$data = [
			'_id' => $id
		];
		$result = $this->api->api_core_Post($this->userInfo['token'],'tenancy/find_one_payment_priod_ky_han',$data);
		if ($result && $result->status == 200) {
				$result->data->ngay_thanh_toan = date('Y-m-d', $result->data->ngay_thanh_toan_unix);
			$response = [
			'status' => "200",
			'data' => $result->data,
			'msg'=> 'succes'
		];
		}else{
			$response = [
				'status' => "400",
				'msg' => 'Không thành công',
				'msg' => $result->message,
			];
		}
		echo json_encode($response);
		return;
	}

	public function thanh_toan_coc_chu_nha()
	{
		$data = $this->input->post();
		$coc_bctt = !empty($data['coc_bctt']) ? (trim(str_replace(array(',', '.',), '', $data['coc_bctt']))) : "";
		$ngay_thanh_toan_coc = !empty($data['ngay_thanh_toan_coc']) ? $data['ngay_thanh_toan_coc'] : "";
		$id = !empty($data['id']) ? $data['id'] : "";
		$data1 = [
			'coc_bctt' => $coc_bctt,
			'ngay_thanh_toan_coc' => $ngay_thanh_toan_coc,
		];
		$result = $this->api->api_core_Post($this->userInfo['token'],'tenancy/updateTienCocChuNha/'.$id,$data1);
		if ($result && $result->status == 200) {
			$response = [
				'status' => "200",
				'msg' => 'Cập nhật thành công',
			];
		} else {
			$response = [
				'status' => "400",
				'msg' => 'Cập nhật không thành công(kiểm tra lại số tiền,...)',
			];
		}
		echo json_encode($response);
		return;
	}

	public function update_tenancy_status_block()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : "";
		$code_contract = !empty($data['code_contract']) ? $data['code_contract'] : "";
		$date_contract = !empty($data['date_contract']) ?$data['date_contract'] : "";
		$contract_expiry_date = !empty($data['contract_expiry_date']) ? $data['contract_expiry_date'] : "";
		$start_date_contract = !empty($data['start_date_contract']) ? ($data['start_date_contract']) : "";
		$end_date_contract = !empty($data['end_date_contract']) ? ($data['end_date_contract']) : "";
		$store = !empty($data['store']) ? $data['store'] : "";
		$name_cty = !empty($data['name_cty']) ? $data['name_cty'] : "";
		$address = !empty($data['address']) ? $data['address'] : "";
		$staff_ptmb = !empty($data['staff_ptmb']) ? $data['staff_ptmb'] : "";
		$one_month_rent = !empty($data['one_month_rent']) ? (trim(str_replace(array(',', '.',), '', $data['one_month_rent']))) : "";
		$ky_tra = !empty($data['ky_tra']) ? $data['ky_tra'] : "";
		$customer_infor = !empty($data['customer_infor']) ? $data['customer_infor'] : "";
		$ten_chu_nha = !empty($data['ten_chu_nha']) ? $data['ten_chu_nha'] : "";
		$sdt_chu_nha = !empty($data['sdt_chu_nha']) ? $data['sdt_chu_nha'] : "";
		$ten_tk_chu_nha = !empty($data['ten_tk_chu_nha']) ? $data['ten_tk_chu_nha'] : "";
		$so_tk_chu_nha = !empty($data['so_tk_chu_nha']) ? $data['so_tk_chu_nha'] : "";
		$bank_name = !empty($data['bank_name']) ? $data['bank_name'] : "";
		$tien_coc = !empty($data['tien_coc']) ? $data['tien_coc'] : "";
		$ngay_dat_coc = !empty($data['ngay_dat_coc']) ?$data['ngay_dat_coc'] : "";
		$tien_coc = !empty($data['tien_coc']) ? (trim(str_replace(array(',', '.',), '', $data['tien_coc']))) : "";
		$ma_so_thue = !empty($data['ma_so_thue']) ? $data['ma_so_thue'] : "";
		$nguoi_nop_thue = !empty($data['nguoi_nop_thue']) ? $data['nguoi_nop_thue'] : "";
		$created_by = $this->userInfo['email'];
		$status = !empty($data['status']) ? $data['status'] : "";
		$hop_dong_so = !empty($data['hop_dong_so']) ? $data['hop_dong_so'] : "";
		$tien_thue = !empty($data['tien_thue']) ? $data['tien_thue'] : "";
		$created_at = !empty($data['created_at']) ? $data['created_at'] : "";
		$store_name = !empty($data['store_name']) ? $data['store_name'] : "";
		$dien_tich = !empty($data['dien_tich']) ? $data['dien_tich'] : "";
		$start_date_contract_uni = !empty($data['start_date_contract_uni']) ? $data['start_date_contract_uni'] : "";
		$end_date_contract_uni = !empty($data['end_date_contract_uni']) ? $data['end_date_contract_uni'] : "";

		$data1 = [
			"id" => $id,
			"code_contract" => $code_contract,
			"date_contract" => $date_contract,
			"contract_expiry_date" => $contract_expiry_date,
			"start_date_contract" => $start_date_contract,
			"end_date_contract" => $end_date_contract,
			"store" => $store,
			"address" => $address,
			"staff_ptmb" => $staff_ptmb,
			"one_month_rent" => $one_month_rent,
			"ky_tra" => $ky_tra,
			"customer_infor" => $customer_infor,
			"ten_chu_nha" => $ten_chu_nha,
			"sdt_chu_nha" => $sdt_chu_nha,
			"ten_tk_chu_nha" => $ten_tk_chu_nha,
			"so_tk_chu_nha" => $so_tk_chu_nha,
			"bank_name" => $bank_name,
			"tien_coc" => $tien_coc,
			"ngay_dat_coc" => $ngay_dat_coc,
			"tien_coc" => $tien_coc,
			"ma_so_thue" => $ma_so_thue,
			"nguoi_nop_thue" => $nguoi_nop_thue,
			"status" => $status,
			"hop_dong_so" => $hop_dong_so,
			"tien_thue" => $tien_thue,
			"created_at" => $created_at,
			"name_cty" => $name_cty,
			"created_by" => $created_by,
			"store_name" => $store_name,
			"dien_tich" => $dien_tich,
			"start_date_contract_uni" => $start_date_contract_uni,
			"end_date_contract_uni" => $end_date_contract_uni,
		];


		$result = $this->api->api_core_Post($this->userInfo['token'],'tenancy/update_tenancy_status_block/'.$id,$data1);
		if ($result && $result->status == 200) {
			$response = [
				'status' => "200",
				'msg' => 'Cập nhật thành công',
			];
		} else {
			$response = [
				'status' => "400",
				'msg' => $result->message,
			];
		}

		echo json_encode($response);
		return;
	}

	public function findOneByIdTenancy()
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : "";
		$result  = $this->api->api_core_Post($this->userInfo['token'],'tenancy/find_one_id_Tenancy/'.$id);
		$result->data->date_contract = date("Y-m-d", $result->data->date_contract);
		$result->data->ngay_dat_coc = date("Y-m-d", $result->data->ngay_dat_coc);
		$result->data->start_date_contract_uni = date("Y-m-d", $result->data->start_date_contract_uni);
		$result->data->end_date_contract_uni = date("Y-m-d", $result->data->end_date_contract_uni);
		$response = [
			'status' => "200",
			'msg' => 'Cập nhật thành công',
			'data' => $result->data
		];
		echo json_encode($response);
		return;
	}

	public function forbidden()
	{
		$this->data['template'] = 'errors/html/403';
		$this->load->view('template', $this->data,$this->session);
	}

	public function exampleExcel()
	{
		$this->sheet->setCellValue('A1', 'STT')->getColumnDimension('A')->setAutoSize(true);
		$this->sheet->setCellValue('B1', 'Số Hợp Đồng')->getColumnDimension('B')->setAutoSize(true);
		$this->sheet->setCellValue('C1', 'Ngày ký hợp đồng')->getColumnDimension('C')->setAutoSize(true);
		$this->sheet->setCellValue('D1', 'Thời hạn thuê')->getColumnDimension('D')->setAutoSize(true);
		$this->sheet->setCellValue('E1', 'Ngày bắt đâu tính tiến')->getColumnDimension('E')->setAutoSize(true);
		$this->sheet->setCellValue('F1', 'Ngày kết thúc hợp đồng')->getColumnDimension('F')->setAutoSize(true);
		$this->sheet->setCellValue('G1', 'Tên phòng giao dịch')->getColumnDimension('G')->setAutoSize(true);
		$this->sheet->setCellValue('H1', 'Khu vực')->getColumnDimension('H')->setAutoSize(true);
		$this->sheet->setCellValue('I1', 'Tên công ty')->getColumnDimension('I')->setAutoSize(true);
		$this->sheet->setCellValue('J1', 'Người phụ trách')->getColumnDimension('J')->setAutoSize(true);
		$this->sheet->setCellValue('K1', 'Tên chủ nhà')->getColumnDimension('K')->setAutoSize(true);
		$this->sheet->setCellValue('L1', 'Số điện thoại chủ nhà')->getColumnDimension('L')->setAutoSize(true);
		$this->sheet->setCellValue('M1', 'Tên tài khoản chủ nhà')->getColumnDimension('M')->setAutoSize(true);
		$this->sheet->setCellValue('N1', 'Số tài khoản chủ nhà')->getColumnDimension('N')->setAutoSize(true);
		$this->sheet->setCellValue('O1', 'Tên ngân hàng')->getColumnDimension('O')->setAutoSize(true);
		$this->sheet->setCellValue('P1', 'Tiền cọc')->getColumnDimension('P')->setAutoSize(true);
		$this->sheet->setCellValue('Q1', 'Ngày đặt cọc')->getColumnDimension('Q')->setAutoSize(true);
		$this->sheet->setCellValue('R1', 'Tiền thuê/tháng')->getColumnDimension('R')->setAutoSize(true);
		$this->sheet->setCellValue('S1', 'Kỳ trả')->getColumnDimension('S')->setAutoSize(true);
		$this->sheet->setCellValue('T1', 'Mã số thuế')->getColumnDimension('T')->setAutoSize(true);
		$this->sheet->setCellValue('U1', 'Người nộp thuế')->getColumnDimension('U')->setAutoSize(true);
		$this->sheet->setCellValue('V1', 'Diện tích')->getColumnDimension('V')->setAutoSize(true);

		$this->sheet->setCellValue('A2','1');
		$this->sheet->setCellValue('B2','HDTN023941947');
		$this->sheet->setCellValue('C2','2022-11-03');
		$this->sheet->setCellValue('D2','12');
		$this->sheet->setCellValue('E2','2022-11-03');
		$this->sheet->setCellValue('F2','2023-11-03');
		$this->sheet->setCellValue('G2','Long biên');
		$this->sheet->setCellValue('H2','Hà Nội');
		$this->sheet->setCellValue('I2','Tài chính việt');
		$this->sheet->setCellValue('J2','Trương Huy Hải');
		$this->sheet->setCellValue('K2','Trần Thị Kim Mai');
		$this->sheet->setCellValue('L2','097921893');
		$this->sheet->setCellValue('M2','Trần Thị Kim Mai');
		$this->sheet->setCellValue('N2','500104161350031');
		$this->sheet->setCellValue('O2','SCB CN Hà Nội');
		$this->sheet->setCellValue('P2','25000000');
		$this->sheet->setCellValue('Q2','2019-10-21');
		$this->sheet->setCellValue('R2','25000000');
		$this->sheet->setCellValue('S2','6');
		$this->sheet->setCellValue('T2','8176873771');
		$this->sheet->setCellValue('U2','1');
		$this->sheet->setCellValue('V2','23');


		$this->callLibExcel('danh-sach-import-mau' . date('Y-m-d') . '.xlsx');

	}

	public function get_all_contract_payment()
	{
		$data = $this->input->post();
		$code_contract = !empty($data['code_contract']) ? $data['code_contract'] : "";
		$data1 = [
			'code_contract' => $code_contract
		];
		$result = $this->api->api_core_Post($this->userInfo['token'], 'tenancy/contract_active', $data1);
		if ($result && $result->status == 200) {
			$response = [
				'status' => "200",
				'msg' => $result->message,
				'data' => $result->data
			];
		}else{
			$response = [
				'status' => "400",
				'msg' => $result->message,
				'msg_text' => $result->message
			];
		}
		echo json_encode($response);
		return;

	}

	public function thanh_ly_hop_dong_tenancy()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : "";
		$ngay_thanh_ly = !empty($data['ngay_thanh_ly']) ? $data['ngay_thanh_ly'] : "";

		$data1 = [
			'ngay_thanh_ly' => $ngay_thanh_ly
		];
		$result = $this->api->api_core_Post($this->userInfo['token'],'tenancy/thanh_ly_hop_dong_tenancy/'. $id,$data1);
		if ($result && $result->status == 200) {
			$response = [
				'status' => "200",
				'msg' => 'Cập nhật thành công ngày thanh lý',
			];
		} else {
			$response = [
				'status' => "400",
				'msg' => 'Cập nhật thất bại ngày thanh lý',
			];
		}
		echo json_encode($response);
		return;

	}


}

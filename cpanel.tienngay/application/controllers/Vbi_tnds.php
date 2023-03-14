<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');

class Vbi_tnds extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->api = new Api();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model("time_model");
		$this->load->library('pagination');
		$this->load->helper('lead_helper');
		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
		// if (!$this->is_superadmin) {
		// 	$paramController = $this->uri->segment(1);
		// 	$param = strtolower($paramController);
		// 	if (!in_array($param, $this->paramMenus)) {
		// 		$this->session->set_flashdata('error', $this->lang->line('not_have_permission') . ' ' . $paramController . '!');
		// 		redirect(base_url('app'));
		// 		return;
		// 	}
		// }
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

	public function form_vbi_tnds()
	{
		$stores = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active");
		$store = $this->api->apiPost($this->userInfo['token'], "mic_tnds/get_store_by_user");
		if (!empty($store->status) && $store->status == 200) {
			$this->data['stores'] = $store->data;
		} else {
			$this->data['stores'] = $stores->data;
		}
		$storeDataCentral = $this->api->apiPost($this->userInfo['token'], "Store/getAllStoreCentral", array());
		if (!empty($storeDataCentral->status) && $storeDataCentral->status == 200) {
			$this->data['storeDataCentral'] = $storeDataCentral->data;
		} else {
			$this->data['storeDataCentral'] = array();
		}
		$years = $this->api->apiPost($this->userInfo['token'], "vbi_tnds/get_year");
		$this->data['years'] = $years->data;
		$nhom_xe = $this->api->apiPost($this->userInfo['token'], "vbi_tnds/get_danh_muc_xe", ['option' => "NHOM_XE"]);
		$hieu_xe = $this->api->apiPost($this->userInfo['token'], "vbi_tnds/get_danh_muc_xe", ['option' => "HIEU_XE"]);
		$hang_xe = $this->api->apiPost($this->userInfo['token'], "vbi_tnds/get_danh_muc_xe", ['option' => "HANG_XE"]);
		$this->data['nhom_xe'] = $nhom_xe->data;
		$this->data['hieu_xe'] = $hieu_xe->data;
		$this->data['hang_xe'] = $hang_xe->data;
		$this->data['template'] = 'page/vbi_tnds/add_vbi_tnds';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function index()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$customer_phone = !empty($_GET['customer_phone']) ? $_GET['customer_phone'] : "";
		$code = !empty($_GET['code']) ? $_GET['code'] : "";
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : 'vbi_tnds';
		if (!empty($fdate) && !empty($tdate) && strtotime($fdate) > strtotime($tdate)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('vbi_tnds'));
		}
		if (!empty($fdate)) {
			$data['start'] = $fdate;
		}
		if (!empty($tdate)) {
			$data['end'] = $tdate;
		}
		if (!empty($customer_phone)) {
			$data['customer_phone'] = $customer_phone;
		}
		if (!empty($code)) {
			$data['code'] = $code;
		}
		$data['tab'] = $tab;
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		if ($tab == 'vbi_tnds') {
			$config['base_url'] = base_url('vbi_tnds?fdate=' . $fdate . '&tdate=' . $tdate . '&tab=' . $tab . '&customer_phone=' . $customer_phone . '&code=' . $code);
		} else {
			$config['base_url'] = base_url('vbi_tnds?fdate=' . $fdate . '&tdate=' . $tdate . '&tab=' . $tab . '&code=' . $code);
		}
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 30;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];
		$vbi = $this->api->apiPost($this->userInfo['token'], "vbi_tnds/get_list_vbi_tnds", $data);
		if (!empty($vbi->status) && $vbi->status == 200) {
			$this->data['transaction'] = $vbi->data;
			$config['total_rows'] = $vbi->total;
		} else {
			$this->data['transaction'] = array();
		}
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['pageName'] = 'Vbi TNDS Ôtô';
		$this->data['template'] = 'page/vbi_tnds/list_vbi_tnds';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function add_transaction_pay_money()
	{
		$data = [];
		$stores = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active");
		$store = $this->api->apiPost($this->userInfo['token'], "mic_tnds/get_store_by_user");
		if (!empty($store->status) && $store->status == 200) {
			$this->data['stores'] = $store->data;
		} else {
			$this->data['stores'] = $stores->data;
		}
		$vbi = $this->api->apiPost($this->userInfo['token'], "vbi_tnds/get_vbi_tnds_accounting_transfe", $data);
		if ($vbi->status == 200) {
			$this->data['vbi_tnds'] = $vbi->data;
			$this->data['total_money'] = $vbi->total_money;
		} else {
			$this->data['vbi_tnds'] = array();
		}
		$storeDataCentral = $this->api->apiPost($this->userInfo['token'], "Store/getAllStoreCentral", array());
		if (!empty($storeDataCentral->status) && $storeDataCentral->status == 200) {
			$this->data['storeDataCentral'] = $storeDataCentral->data;
		} else {
			$this->data['storeDataCentral'] = array();
		}
		$this->data['template'] = 'page/vbi_tnds/giao_dich_dong_tien_them_moi';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function get_total_pay()
	{
		$code = !empty($_POST['code']) ? $_POST['code'] : '';
		if (!empty($code)) {
			$data['code'] = $code;
		}
		$res = $this->api->apiPost($this->userInfo['token'], "vbi_tnds/get_total_pay", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", 'total' => $res->total, "msg" => $res->message)));
			return;
		}
	}

	public function create_transaction()
	{
		$code = !empty($_POST['vbi']) ? $_POST['vbi'] : '';
		$store = !empty($_POST['store']) ? $_POST['store'] : '';
		$loai_khach = !empty($_POST['loai_khach']) ? $_POST['loai_khach'] : '';
		if (!empty($code)) {
			$data['code'] = explode(',', $code);
		}
		if (!empty($store)) {
			$data['store'] = $store;
		}
		$data['bh_product'] =7;
		$data['store_id'] = $store;
		$data['loai_khach'] = $loai_khach;
		$code_coupon="";
		$rescp = $this->api->apiPost($this->userInfo['token'], "coupon_cash/get_all_home", $data);
		if (!empty($rescp->status) && $rescp->status == 200) {
			$code_coupon=$rescp->code;
		}
		$data['code_coupon'] =$code_coupon;
		$res = $this->api->apiPost($this->userInfo['token'], "vbi_tnds/create_transaction", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $res->message)));
			return;
		} elseif (!empty($res->status) && $res->status == 401) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $res->message)));
			return;
		}
	}

	public function detail_transaction()
	{
		$code = !empty($_GET['code']) ? $_GET['code'] : '';
		if (!empty($code)) {
			$data['code'] = $code;
		}
		$res = $this->api->apiPost($this->userInfo['token'], "vbi_tnds/detail_transaction", $data);
		if ($res->status == 200) {
			$this->data['vbis'] = $res->data;
		} else {
			$this->data['vbis'] = array();
		}
		$this->data['template'] = 'page/vbi_tnds/giao_dich_dong_tien';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function tinh_phi_vbi_tnds()
	{
		$ten = !empty($_POST['ten']) ? $_POST['ten'] : '';
		$email = !empty($_POST['email']) ? $_POST['email'] : '';
		$cmt = !empty($_POST['cmt']) ? (string)$_POST['cmt'] : '';
		$sdt = !empty($_POST['sdt']) ? (string)$_POST['sdt'] : '';
		$ngaysinh = !empty($_POST['ngaysinh']) ? $_POST['ngaysinh'] : '';
		$gioi_tinh = !empty($_POST['gioi_tinh']) ? $_POST['gioi_tinh'] : '';
		$nam_sx = !empty($_POST['nam_sx']) ? $_POST['nam_sx'] : '';
		$hang_xe = !empty($_POST['hang_xe']) ? $_POST['hang_xe'] : '';
		$hieu_xe = !empty($_POST['hieu_xe']) ? $_POST['hieu_xe'] : '';
		$nhom_xe = !empty($_POST['nhom_xe']) ? $_POST['nhom_xe'] : '';
		$store = !empty($_POST['store']) ? $_POST['store'] : '';
		$diachi = !empty($_POST['diachi']) ? $_POST['diachi'] : '';
		$bien_xe = !empty($_POST['bien_xe']) ? $_POST['bien_xe'] : '';
		$so_cho = !empty($_POST['so_cho']) ? (string)$_POST['so_cho'] : '';
		$trong_tai = !empty($_POST['trong_tai']) ? (string)$_POST['trong_tai'] : '';
		$gia_tri_xe = !empty($_POST['gia_tri_xe']) ? (string)$_POST['gia_tri_xe'] : '';
		$start_date_effect = !empty($_POST['start_date_effect']) ? $_POST['start_date_effect'] : '';
		if (!empty($ten)) {
			$data['ten'] = $ten;
		}
		if (!empty($email)) {
			$data['email'] = $email;
		}
		if (!empty($cmt)) {
			$data['cmt'] = (string)$cmt;
		}
		if (!empty($sdt)) {
			$data['sdt'] = (string)$sdt;
		}
		if (!empty($ngaysinh)) {
			$data['ngaysinh'] = date('d/m/Y', strtotime($ngaysinh));
		}
		if (!empty($gioi_tinh)) {
			$data['gioi_tinh'] = $gioi_tinh;
		}
		if (!empty($nam_sx)) {
			$data['nam_sx'] = (string)$nam_sx;
		}
		if (!empty($hang_xe)) {
			$data['hang_xe'] = $hang_xe;
		}
		if (!empty($hieu_xe)) {
			$data['hieu_xe'] = $hieu_xe;
		}
		if (!empty($nhom_xe)) {
			$data['nhom_xe'] = $nhom_xe;
		}
		if (!empty($store)) {
			$data['id_pgd'] = $store;
		}
		if (!empty($diachi)) {
			$data['diachi'] = $diachi;
		}
		if (!empty($bien_xe)) {
			$data['bien_xe'] = $bien_xe;
		}
		if (!empty($so_cho)) {
			$data['so_cho'] = (string)$so_cho;
		}
		if (!empty($trong_tai)) {
			$data['trong_tai'] = (string)$trong_tai;
		}
		if (!empty($gia_tri_xe)) {
			$data['gia_tri_xe'] = (string)$gia_tri_xe;
		}
		if (!empty($start_date_effect)) {
			$data['start_date_effect'] = $start_date_effect;
		}
		$res = $this->api->apiPost($this->user['token'], "vbi_tnds/create_bill_vbi_tnds", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "phi" => $res->tong_phi, "msg" => $res->message)));
			return;
		} elseif (!empty($res->status) && $res->status == 401) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $res->message)));
			return;
		}
	}

	public function fees_apply()
	{
		$ten = !empty($_POST['ten']) ? $_POST['ten'] : '';
		$email = !empty($_POST['email']) ? $_POST['email'] : '';
		$cmt = !empty($_POST['cmt']) ? $_POST['cmt'] : '';
		$sdt = !empty($_POST['sdt']) ? $_POST['sdt'] : '';
		$ngaysinh = !empty($_POST['ngaysinh']) ? $_POST['ngaysinh'] : '';
		$gioi_tinh = !empty($_POST['gioi_tinh']) ? $_POST['gioi_tinh'] : '';
		$nam_sx = !empty($_POST['nam_sx']) ? $_POST['nam_sx'] : '';
		$hang_xe = !empty($_POST['hang_xe']) ? $_POST['hang_xe'] : '';
		$hieu_xe = !empty($_POST['hieu_xe']) ? $_POST['hieu_xe'] : '';
		$nhom_xe = !empty($_POST['nhom_xe']) ? $_POST['nhom_xe'] : '';
		$store = !empty($_POST['store']) ? $_POST['store'] : '';
		$diachi = !empty($_POST['diachi']) ? $_POST['diachi'] : '';
		$bien_xe = !empty($_POST['bien_xe']) ? $_POST['bien_xe'] : '';
		$so_cho = !empty($_POST['so_cho']) ? $_POST['so_cho'] : '';
		$trong_tai = !empty($_POST['trong_tai']) ? $_POST['trong_tai'] : '';
		$gia_tri_xe = !empty($_POST['gia_tri_xe']) ? $_POST['gia_tri_xe'] : '';
		$price = !empty($_POST['price_vbi']) ? $_POST['price_vbi'] : '';
		$start_date_effect = !empty($_POST['start_date_effect']) ? $_POST['start_date_effect'] : '';

		if (!empty($ten)) {
			$data['ten'] = $ten;
		}
		if (!empty($email)) {
			$data['email'] = $email;
		}
		if (!empty($cmt)) {
			$data['cmt'] = (string)$cmt;
		}
		if (!empty($sdt)) {
			$data['sdt'] = (string)$sdt;
		}
		if (!empty($ngaysinh)) {
			$data['ngaysinh'] = date('d/m/Y', strtotime($ngaysinh));
		}
		if (!empty($gioi_tinh)) {
			$data['gioi_tinh'] = $gioi_tinh;
		}
		if (!empty($nam_sx)) {
			$data['nam_sx'] = $nam_sx;
		}
		if (!empty($hang_xe)) {
			$data['hang_xe'] = $hang_xe;
		}
		if (!empty($hieu_xe)) {
			$data['hieu_xe'] = $hieu_xe;
		}
		if (!empty($nhom_xe)) {
			$data['nhom_xe'] = $nhom_xe;
		}
		if (!empty($store)) {
			$data['id_pgd'] = $store;
		}
		if (!empty($diachi)) {
			$data['diachi'] = $diachi;
		}
		if (!empty($bien_xe)) {
			$data['bien_xe'] = $bien_xe;
		}
		if (!empty($so_cho)) {
			$data['so_cho'] = (string)$so_cho;
		}
		if (!empty($trong_tai)) {
			$data['trong_tai'] = (string)$trong_tai;
		}
		if (!empty($gia_tri_xe)) {
			$data['gia_tri_xe'] = $gia_tri_xe;
		}
		if (!empty($price)) {
			$data['price'] = $price;
		}
		if (!empty($start_date_effect)) {
			$data['start_date_effect'] = $start_date_effect;
		}
		$res = $this->api->apiPost($this->user['token'], "vbi_tnds/fees_apply", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $res->message)));
			return;
		} elseif (!empty($res->status) && $res->status == 401) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $res->message)));
			return;
		}

	}
	public function get_phi_vbi_tnds()
	{
		$ten = 'nguyen van a';
		$email = 'a@gmail.com';
		$cmt = '0356236263';
		$sdt = '0236523653';
		$ngaysinh = '1992-12-24';
		$gioi_tinh = 'nam';
		$nam_sx = '2019';
		$hang_xe = !empty($_GET['hang_xe']) ? $_GET['hang_xe'] : '';
		$hieu_xe = !empty($_GET['hieu_xe']) ? $_GET['hieu_xe'] : '';
		$nhom_xe = !empty($_GET['nhom_xe']) ? $_GET['nhom_xe'] : '';
		
		$diachi = '1132 TRAN HUNG ĐAO , TO 5 , BINH LONG 4 , MY BINH , LONG XUYEN , AN GIANG';
		$bien_xe = '67C13520';
		$so_cho = '2';
		$trong_tai = '1.5';
		$gia_tri_xe = '120,000,000';
		if (!empty($ten)) {
			$data['ten'] = $ten;
		}
		if (!empty($email)) {
			$data['email'] = $email;
		}
		if (!empty($cmt)) {
			$data['cmt'] = (string)$cmt;
		}
		if (!empty($sdt)) {
			$data['sdt'] = (string)$sdt;
		}
		if (!empty($ngaysinh)) {
			$data['ngaysinh'] = date('d/m/Y', strtotime($ngaysinh));
		}
		if (!empty($gioi_tinh)) {
			$data['gioi_tinh'] = $gioi_tinh;
		}
		if (!empty($nam_sx)) {
			$data['nam_sx'] = (string)$nam_sx;
		}
		if (!empty($hang_xe)) {
			$data['hang_xe'] = $hang_xe;
		}
		if (!empty($hieu_xe)) {
			$data['hieu_xe'] = $hieu_xe;
		}
		if (!empty($nhom_xe)) {
			$data['nhom_xe'] = $nhom_xe;
		}
		if (!empty($store)) {
			$data['id_pgd'] = $store;
		}
		if (!empty($diachi)) {
			$data['diachi'] = $diachi;
		}
		if (!empty($bien_xe)) {
			$data['bien_xe'] = $bien_xe;
		}
		if (!empty($so_cho)) {
			$data['so_cho'] = (string)$so_cho;
		}
		if (!empty($trong_tai)) {
			$data['trong_tai'] = (string)$trong_tai;
		}
		if (!empty($gia_tri_xe)) {
			$data['gia_tri_xe'] = (string)$gia_tri_xe;
		}
		$res = $this->api->apiPost($this->user['token'], "vbi_tnds/create_bill_vbi_tnds", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "phi" => $res->tong_phi, "msg" => $res->message)));
			return;
		} elseif (!empty($res->status) && $res->status == 401) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $res->message)));
			return;
		}
	}

}

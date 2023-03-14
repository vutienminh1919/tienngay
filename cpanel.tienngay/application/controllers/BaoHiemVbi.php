<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');

class BaoHiemVbi extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->api = new Api();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model("time_model");
		$this->load->library('pagination');
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

	public function form_vbi_utv()
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
		$this->data['pageName'] = 'Bán mới bảo hiểm VBI-UTV';
		$this->data['template'] = 'page/bao_hiem_vbi/utv/add_vbi_utv';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function fees_apply()
	{
		$ten_chu_hd = !empty($_POST['ten_chu_hd']) ? $_POST['ten_chu_hd'] : '';
		$email_chu_hd = !empty($_POST['email_chu_hd']) ? $_POST['email_chu_hd'] : '';
		$sdt_chu_hd = !empty($_POST['sdt_chu_hd']) ? $_POST['sdt_chu_hd'] : '';
		$cmt_chu_hd = !empty($_POST['cmt_chu_hd']) ? $_POST['cmt_chu_hd'] : '';
		$diachi_chu_hd = !empty($_POST['diachi_chu_hd']) ? $_POST['diachi_chu_hd'] : '';
		$ngaysinh_chu_hd = !empty($_POST['ngaysinh_chu_hd']) ? $_POST['ngaysinh_chu_hd'] : '';
		$gioi_tinh_chu_hd = !empty($_POST['gioi_tinh_chu_hd']) ? $_POST['gioi_tinh_chu_hd'] : '';
		$ten_nguoi_bh = !empty($_POST['ten_nguoi_bh']) ? $_POST['ten_nguoi_bh'] : '';
		$email_nguoi_bh = !empty($_POST['email_nguoi_bh']) ? $_POST['email_nguoi_bh'] : '';
		$sdt_nguoi_bh = !empty($_POST['sdt_nguoi_bh']) ? $_POST['sdt_nguoi_bh'] : '';
		$cmt_nguoi_bh = !empty($_POST['cmt_nguoi_bh']) ? $_POST['cmt_nguoi_bh'] : '';
		$cmt_ngay_cap_nguoi_bh = !empty($_POST['cmt_ngay_cap_nguoi_bh']) ? $_POST['cmt_ngay_cap_nguoi_bh'] : '';
		$cmt_noi_cap_nguoi_bh = !empty($_POST['cmt_noi_cap_nguoi_bh']) ? $_POST['cmt_noi_cap_nguoi_bh'] : '';
		$diachi_nguoi_bh = !empty($_POST['diachi_nguoi_bh']) ? $_POST['diachi_nguoi_bh'] : '';
		$ngaysinh_nguoi_bh = !empty($_POST['ngaysinh_nguoi_bh']) ? $_POST['ngaysinh_nguoi_bh'] : '';
		$gioi_tinh_nguoi_bh = !empty($_POST['gioi_tinh_nguoi_bh']) ? $_POST['gioi_tinh_nguoi_bh'] : '';
		$moi_quan_he = !empty($_POST['moi_quan_he']) ? $_POST['moi_quan_he'] : '';
		$goi_bao_hiem = !empty($_POST['goi_bao_hiem']) ? $_POST['goi_bao_hiem'] : '';
		$store = !empty($_POST['store']) ? $_POST['store'] : '';
		$price = !empty($_POST['price']) ? $_POST['price'] : '';
		if (!empty($ten_chu_hd)) {
			$data['ten_chu_hd'] = $ten_chu_hd;
		}
		if (!empty($email_chu_hd)) {
			$data['email_chu_hd'] = $email_chu_hd;
		}
		if (!empty($sdt_chu_hd)) {
			$data['sdt_chu_hd'] = $sdt_chu_hd;
		}
		if (!empty($cmt_chu_hd)) {
			$data['cmt_chu_hd'] = $cmt_chu_hd;
		}
		if (!empty($diachi_chu_hd)) {
			$data['diachi_chu_hd'] = $diachi_chu_hd;
		}
		if (!empty($ngaysinh_chu_hd)) {
			$data['ngaysinh_chu_hd'] = $ngaysinh_chu_hd;
		}
		if (!empty($gioi_tinh_chu_hd)) {
			$data['gioi_tinh_chu_hd'] = $gioi_tinh_chu_hd;
		}
		if (!empty($ten_nguoi_bh)) {
			$data['ten_nguoi_bh'] = $ten_nguoi_bh;
		}
		if (!empty($email_nguoi_bh)) {
			$data['email_nguoi_bh'] = $email_nguoi_bh;
		}
		if (!empty($sdt_nguoi_bh)) {
			$data['sdt_nguoi_bh'] = $sdt_nguoi_bh;
		}
		if (!empty($cmt_nguoi_bh)) {
			$data['cmt_nguoi_bh'] = $cmt_nguoi_bh;
		}
		if (!empty($cmt_ngay_cap_nguoi_bh)) {
			$data['cmt_ngay_cap_nguoi_bh'] = $cmt_ngay_cap_nguoi_bh;
		}
		if (!empty($cmt_noi_cap_nguoi_bh)) {
			$data['cmt_noi_cap_nguoi_bh'] = $cmt_noi_cap_nguoi_bh;
		}
		if (!empty($diachi_nguoi_bh)) {
			$data['diachi_nguoi_bh'] = $diachi_nguoi_bh;
		}
		if (!empty($ngaysinh_nguoi_bh)) {
			$data['ngaysinh_nguoi_bh'] = $ngaysinh_nguoi_bh;
		}
		if (!empty($gioi_tinh_nguoi_bh)) {
			$data['gioi_tinh_nguoi_bh'] = $gioi_tinh_nguoi_bh;
		}
		if (!empty($moi_quan_he)) {
			$data['moi_quan_he'] = $moi_quan_he;
		}
		if (!empty($goi_bao_hiem)) {
			$data['goi_bao_hiem'] = $goi_bao_hiem;
		}
		if (!empty($store)) {
			$data['id_pgd'] = $store;
		}
		if (!empty($price)) {
			$data['price'] = $price;
		}
		$res = $this->api->apiPost($this->user['token'], "vbi_utv/fees_apply", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $res->message)));
			return;
		} elseif (!empty($res->status) && $res->status == 401) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $res->message)));
			return;
		}
	}

	public function check_birthday()
	{
		$ngaysinh_nguoi_bh = !empty($_GET['ngaysinh_nguoi_bh']) ? $_GET['ngaysinh_nguoi_bh'] : '';
		if (!empty($ngaysinh_nguoi_bh)) {
			$data['ngaysinh_nguoi_bh'] = $ngaysinh_nguoi_bh;
		}
		$res = $this->api->apiPost($this->user['token'], "vbi_utv/check_birthday", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", 'data' => $res->data, 'age' => $res->age, "msg" => $res->message)));
			return;
		} elseif (!empty($res->status) && $res->status == 401) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $res->message)));
			return;
		}
	}

	public function get_price_goi_bh()
	{
		$goi_bao_hiem = !empty($_POST['goi_bao_hiem']) ? $_POST['goi_bao_hiem'] : '';
		$ngaysinh_nguoi_bh = !empty($_POST['ngaysinh_nguoi_bh']) ? $_POST['ngaysinh_nguoi_bh'] : '';
		if (!empty($ngaysinh_nguoi_bh)) {
			$data['ngaysinh_nguoi_bh'] = $ngaysinh_nguoi_bh;
		}
		if (!empty($goi_bao_hiem)) {
			$data['goi_bao_hiem'] = $goi_bao_hiem;
		}
		$res = $this->api->apiPost($this->user['token'], "vbi_utv/get_price_goi_bh", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", 'data' => $res->price, "msg" => $res->message)));
			return;
		} elseif (!empty($res->status) && $res->status == 401) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $res->message)));
			return;
		}
	}

	public function utv()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$customer_phone = !empty($_GET['customer_phone']) ? $_GET['customer_phone'] : "";
		$code = !empty($_GET['code']) ? $_GET['code'] : "";
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : 'vbi_utv';
		$filter_by_store = !empty($_GET['filter_by_store']) ? $_GET['filter_by_store'] : '';
		if (!empty($fdate) && !empty($tdate) && strtotime($fdate) > strtotime($tdate)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('baoHiemVbi/utv'));
		}
		if ($tdate) {
			$data['end'] = $tdate;
		}
		if ($fdate) {
			$data['start'] = $fdate;
		}
		if (!empty($customer_phone)) {
			$data['customer_phone'] = $customer_phone;
		}
		if (!empty($code)) {
			$data['code'] = $code;
		}
		if (!empty($filter_by_store)) {
			$data['filter_by_store'] = $filter_by_store;
		}
		$data['tab'] = $tab;
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		if ($tab == 'vbi_utv') {
			$config['base_url'] = base_url('baoHiemVbi/utv?fdate=' . $fdate . '&tdate=' . $tdate . '&tab=' . $tab . '&customer_phone=' . $customer_phone . '&code=' . $code . '&filter_by_store=' . $filter_by_store);
		} else {
			$config['base_url'] = base_url('baoHiemVbi/utv?fdate=' . $fdate . '&tdate=' . $tdate . '&tab=' . $tab . '&code=' . $code . '&filter_by_store=' . $filter_by_store);
		}
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 30;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		$storeData = $this->userInfo['stores'];
		if (!empty($storeData)) {
			$this->data['storeData'] = $storeData;
		} else {
			$this->data['storeData'] = array();
		}
		$vbi = $this->api->apiPost($this->userInfo['token'], "vbi_utv/get_list_vbi_utv", $data);
		if (!empty($vbi->status) && $vbi->status == 200) {
			$this->data['transaction'] = $vbi->data;
			$config['total_rows'] = $vbi->total;
		} else {
			$this->data['transaction'] = array();
		}
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['pageName'] = 'Bảo hiểm Vbi Ung thư vú';
		$this->data['template'] = 'page/bao_hiem_vbi/utv/list_vbi_utv';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function add_utv_transaction_pay_money()
	{
		$data = [];
		$stores = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active");
		$store = $this->api->apiPost($this->userInfo['token'], "mic_tnds/get_store_by_user");
		if (!empty($store->status) && $store->status == 200) {
			$this->data['stores'] = $store->data;
		} else {
			$this->data['stores'] = $stores->data;
		}
		$vbi = $this->api->apiPost($this->userInfo['token'], "vbi_utv/get_vbi_utv_accounting_transfe", $data);
		if ($vbi->status == 200) {
			$this->data['vbi_utv'] = $vbi->data;
			$this->data['total_money'] = $vbi->total_money;
		} else {
			$this->data['vbi_utv'] = array();
		}
		$storeDataCentral = $this->api->apiPost($this->userInfo['token'], "Store/getAllStoreCentral", array());
		if (!empty($storeDataCentral->status) && $storeDataCentral->status == 200) {
			$this->data['storeDataCentral'] = $storeDataCentral->data;
		} else {
			$this->data['storeDataCentral'] = array();
		}
		$this->data['pageName'] = 'Chuyển tiền VBI-UTV sang kế toán';
		$this->data['template'] = 'page/bao_hiem_vbi/utv/giao_dich_dong_tien_them_moi';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function get_utv_total_pay()
	{
		$code = !empty($_POST['code']) ? $_POST['code'] : '';
		if (!empty($code)) {
			$data['code'] = $code;
		}
		$res = $this->api->apiPost($this->userInfo['token'], "vbi_utv/get_total_pay", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", 'total' => $res->total, "msg" => $res->message)));
			return;
		}
	}

	public function create_utv_transaction()
	{
		$code = !empty($_POST['vbi']) ? $_POST['vbi'] : '';
		$store = !empty($_POST['store']) ? $_POST['store'] : '';
		if (!empty($code)) {
			$data['code'] = explode(',', $code);
		}
		if (!empty($store)) {
			$data['store'] = $store;
		}
		$res = $this->api->apiPost($this->userInfo['token'], "vbi_utv/create_transaction", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $res->message)));
			return;
		} elseif (!empty($res->status) && $res->status == 401) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $res->message)));
			return;
		}
	}

	public function detail_utv_transaction()
	{
		$code = !empty($_GET['code']) ? $_GET['code'] : '';
		if (!empty($code)) {
			$data['code'] = $code;
		}
		$res = $this->api->apiPost($this->userInfo['token'], "vbi_utv/detail_transaction", $data);
		if ($res->status == 200) {
			$this->data['vbis'] = $res->data;
		} else {
			$this->data['vbis'] = array();
		}
		$this->data['template'] = 'page/bao_hiem_vbi/utv/giao_dich_dong_tien';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function form_vbi_sxh()
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
		$this->data['pageName'] = 'Bán mới bảo hiểm VBI-SXH';
		$this->data['template'] = 'page/bao_hiem_vbi/sxh/add_vbi_sxh';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function fees_apply_sxh()
	{
		$ten_chu_hd = !empty($_POST['ten_chu_hd']) ? $_POST['ten_chu_hd'] : '';
		$email_chu_hd = !empty($_POST['email_chu_hd']) ? $_POST['email_chu_hd'] : '';
		$sdt_chu_hd = !empty($_POST['sdt_chu_hd']) ? $_POST['sdt_chu_hd'] : '';
		$cmt_chu_hd = !empty($_POST['cmt_chu_hd']) ? $_POST['cmt_chu_hd'] : '';
		$diachi_chu_hd = !empty($_POST['diachi_chu_hd']) ? $_POST['diachi_chu_hd'] : '';
		$ngaysinh_chu_hd = !empty($_POST['ngaysinh_chu_hd']) ? $_POST['ngaysinh_chu_hd'] : '';
		$gioi_tinh_chu_hd = !empty($_POST['gioi_tinh_chu_hd']) ? $_POST['gioi_tinh_chu_hd'] : '';
		$ten_nguoi_bh = !empty($_POST['ten_nguoi_bh']) ? $_POST['ten_nguoi_bh'] : '';
		$email_nguoi_bh = !empty($_POST['email_nguoi_bh']) ? $_POST['email_nguoi_bh'] : '';
		$sdt_nguoi_bh = !empty($_POST['sdt_nguoi_bh']) ? $_POST['sdt_nguoi_bh'] : '';
		$cmt_nguoi_bh = !empty($_POST['cmt_nguoi_bh']) ? $_POST['cmt_nguoi_bh'] : '';
		$cmt_ngay_cap_nguoi_bh = !empty($_POST['cmt_ngay_cap_nguoi_bh']) ? $_POST['cmt_ngay_cap_nguoi_bh'] : '';
		$cmt_noi_cap_nguoi_bh = !empty($_POST['cmt_noi_cap_nguoi_bh']) ? $_POST['cmt_noi_cap_nguoi_bh'] : '';
		$diachi_nguoi_bh = !empty($_POST['diachi_nguoi_bh']) ? $_POST['diachi_nguoi_bh'] : '';
		$ngaysinh_nguoi_bh = !empty($_POST['ngaysinh_nguoi_bh']) ? $_POST['ngaysinh_nguoi_bh'] : '';
		$gioi_tinh_nguoi_bh = !empty($_POST['gioi_tinh_nguoi_bh']) ? $_POST['gioi_tinh_nguoi_bh'] : '';
		$moi_quan_he = !empty($_POST['moi_quan_he']) ? $_POST['moi_quan_he'] : '';
		$goi_bao_hiem = !empty($_POST['goi_bao_hiem']) ? $_POST['goi_bao_hiem'] : '';
		$store = !empty($_POST['store']) ? $_POST['store'] : '';
		$price = !empty($_POST['price']) ? $_POST['price'] : '';
		if (!empty($ten_chu_hd)) {
			$data['ten_chu_hd'] = $ten_chu_hd;
		}
		if (!empty($email_chu_hd)) {
			$data['email_chu_hd'] = $email_chu_hd;
		}
		if (!empty($sdt_chu_hd)) {
			$data['sdt_chu_hd'] = $sdt_chu_hd;
		}
		if (!empty($cmt_chu_hd)) {
			$data['cmt_chu_hd'] = $cmt_chu_hd;
		}
		if (!empty($diachi_chu_hd)) {
			$data['diachi_chu_hd'] = $diachi_chu_hd;
		}
		if (!empty($ngaysinh_chu_hd)) {
			$data['ngaysinh_chu_hd'] = $ngaysinh_chu_hd;
		}
		if (!empty($gioi_tinh_chu_hd)) {
			$data['gioi_tinh_chu_hd'] = $gioi_tinh_chu_hd;
		}
		if (!empty($ten_nguoi_bh)) {
			$data['ten_nguoi_bh'] = $ten_nguoi_bh;
		}
		if (!empty($email_nguoi_bh)) {
			$data['email_nguoi_bh'] = $email_nguoi_bh;
		}
		if (!empty($sdt_nguoi_bh)) {
			$data['sdt_nguoi_bh'] = $sdt_nguoi_bh;
		}
		if (!empty($cmt_nguoi_bh)) {
			$data['cmt_nguoi_bh'] = $cmt_nguoi_bh;
		}
		if (!empty($cmt_ngay_cap_nguoi_bh)) {
			$data['cmt_ngay_cap_nguoi_bh'] = $cmt_ngay_cap_nguoi_bh;
		}
		if (!empty($cmt_noi_cap_nguoi_bh)) {
			$data['cmt_noi_cap_nguoi_bh'] = $cmt_noi_cap_nguoi_bh;
		}
		if (!empty($diachi_nguoi_bh)) {
			$data['diachi_nguoi_bh'] = $diachi_nguoi_bh;
		}
		if (!empty($ngaysinh_nguoi_bh)) {
			$data['ngaysinh_nguoi_bh'] = $ngaysinh_nguoi_bh;
		}
		if (!empty($gioi_tinh_nguoi_bh)) {
			$data['gioi_tinh_nguoi_bh'] = $gioi_tinh_nguoi_bh;
		}
		if (!empty($moi_quan_he)) {
			$data['moi_quan_he'] = $moi_quan_he;
		}
		if (!empty($goi_bao_hiem)) {
			$data['goi_bao_hiem'] = $goi_bao_hiem;
		}
		if (!empty($store)) {
			$data['id_pgd'] = $store;
		}
		if (!empty($price)) {
			$data['price'] = $price;
		}
		$res = $this->api->apiPost($this->user['token'], "vbi_sxh/fees_apply", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $res->message)));
			return;
		} elseif (!empty($res->status) && $res->status == 401) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $res->message)));
			return;
		}
	}

	public function check_gioi_tinh()
	{
		$ngaysinh_nguoi_bh = !empty($_GET['ngaysinh_nguoi_bh']) ? $_GET['ngaysinh_nguoi_bh'] : '';
		$gioi_tinh_nguoi_bh = !empty($_GET['gioi_tinh_nguoi_bh']) ? $_GET['gioi_tinh_nguoi_bh'] : '';
		if (!empty($ngaysinh_nguoi_bh)) {
			$data['ngaysinh_nguoi_bh'] = $ngaysinh_nguoi_bh;
		}
		if (!empty($gioi_tinh_nguoi_bh)) {
			$data['gioi_tinh_nguoi_bh'] = $gioi_tinh_nguoi_bh;
		}
		$res = $this->api->apiPost($this->user['token'], "vbi_sxh/check_gioi_tinh", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", 'data' => $res->data, 'age' => $res->age, "msg" => $res->message)));
			return;
		} elseif (!empty($res->status) && $res->status == 401) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $res->message)));
			return;
		}
	}

	public function get_price_goi_bh_sxh()
	{
		$goi_bao_hiem = !empty($_POST['goi_bao_hiem']) ? $_POST['goi_bao_hiem'] : '';
		$ngaysinh_nguoi_bh = !empty($_POST['ngaysinh_nguoi_bh']) ? $_POST['ngaysinh_nguoi_bh'] : '';
		$gioi_tinh_nguoi_bh = !empty($_POST['gioi_tinh_nguoi_bh']) ? $_POST['gioi_tinh_nguoi_bh'] : '';
		if (!empty($ngaysinh_nguoi_bh)) {
			$data['ngaysinh_nguoi_bh'] = $ngaysinh_nguoi_bh;
		}
		if (!empty($goi_bao_hiem)) {
			$data['goi_bao_hiem'] = $goi_bao_hiem;
		}
		if (!empty($gioi_tinh_nguoi_bh)) {
			$data['gioi_tinh_nguoi_bh'] = $gioi_tinh_nguoi_bh;
		}
		$res = $this->api->apiPost($this->user['token'], "vbi_sxh/get_price_goi_bh", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", 'data' => $res->price, "msg" => $res->message)));
			return;
		} elseif (!empty($res->status) && $res->status == 401) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $res->message)));
			return;
		}
	}

	public function sxh()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$customer_phone = !empty($_GET['customer_phone']) ? $_GET['customer_phone'] : "";
		$code = !empty($_GET['code']) ? $_GET['code'] : "";
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : 'vbi_sxh';
		$filter_by_store = !empty($_GET['filter_by_store']) ? $_GET['filter_by_store'] : '';
		if (strtotime($fdate) > strtotime($tdate)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('baoHiemVbi/sxh'));
		}
		if ($tdate) {
			$data['end'] = $tdate;
		}
		if ($fdate) {
			$data['start'] = $fdate;
		}
		if (!empty($customer_phone)) {
			$data['customer_phone'] = $customer_phone;
		}
		if (!empty($code)) {
			$data['code'] = $code;
		}
		if (!empty($filter_by_store)) {
			$data['filter_by_store'] = $filter_by_store;
		}
		$data['tab'] = $tab;
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		if ($tab == 'vbi_sxh') {
			$config['base_url'] = base_url('baoHiemVbi/sxh?fdate=' . $fdate . '&tdate=' . $tdate . '&tab=' . $tab . '&customer_phone=' . $customer_phone . '&code=' . $code . '&filter_by_store=' . $filter_by_store);
		} else {
			$config['base_url'] = base_url('baoHiemVbi/sxh?fdate=' . $fdate . '&tdate=' . $tdate . '&tab=' . $tab . '&code=' . $code . '&filter_by_store=' . $filter_by_store);
		}
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 30;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		$storeData = $this->userInfo['stores'];
		if (!empty($storeData)) {
			$this->data['storeData'] = $storeData;
		} else {
			$this->data['storeData'] = array();
		}
		$vbi = $this->api->apiPost($this->userInfo['token'], "vbi_sxh/get_list_vbi_sxh", $data);
		if (!empty($vbi->status) && $vbi->status == 200) {
			$this->data['transaction'] = $vbi->data;
			$config['total_rows'] = $vbi->total;
		} else {
			$this->data['transaction'] = array();
		}
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['pageName'] = 'Bảo hiểm Vbi sốt xuất huyết';
		$this->data['template'] = 'page/bao_hiem_vbi/sxh/list_vbi_sxh';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function add_transaction_pay_money_sxh()
	{
		$data = [];
		$stores = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active");
		$store = $this->api->apiPost($this->userInfo['token'], "mic_tnds/get_store_by_user");
		if (!empty($store->status) && $store->status == 200) {
			$this->data['stores'] = $store->data;
		} else {
			$this->data['stores'] = $stores->data;
		}
		$vbi = $this->api->apiPost($this->userInfo['token'], "vbi_sxh/get_vbi_sxh_accounting_transfe", $data);
		if ($vbi->status == 200) {
			$this->data['vbi_sxh'] = $vbi->data;
			$this->data['total_money'] = $vbi->total_money;
		} else {
			$this->data['vbi_sxh'] = array();
		}
		$storeDataCentral = $this->api->apiPost($this->userInfo['token'], "Store/getAllStoreCentral", array());
		if (!empty($storeDataCentral->status) && $storeDataCentral->status == 200) {
			$this->data['storeDataCentral'] = $storeDataCentral->data;
		} else {
			$this->data['storeDataCentral'] = array();
		}
		$this->data['pageName'] = 'Chuyển tiền VBI-SXH sang kế toán';
		$this->data['template'] = 'page/bao_hiem_vbi/sxh/giao_dich_dong_tien_them_moi';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function get_sxh_total_pay()
	{
		$code = !empty($_POST['code']) ? $_POST['code'] : '';
		if (!empty($code)) {
			$data['code'] = $code;
		}
		$res = $this->api->apiPost($this->userInfo['token'], "vbi_sxh/get_total_pay", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", 'total' => $res->total, "msg" => $res->message)));
			return;
		}
	}

	public function create_sxh_transaction()
	{
		$code = !empty($_POST['vbi']) ? $_POST['vbi'] : '';
		$store = !empty($_POST['store']) ? $_POST['store'] : '';
		if (!empty($code)) {
			$data['code'] = explode(',', $code);
		}
		if (!empty($store)) {
			$data['store'] = $store;
		}
		$res = $this->api->apiPost($this->userInfo['token'], "vbi_sxh/create_transaction", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $res->message)));
			return;
		} elseif (!empty($res->status) && $res->status == 401) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $res->message)));
			return;
		}
	}

	public function detail_sxh_transaction()
	{
		$code = !empty($_GET['code']) ? $_GET['code'] : '';
		if (!empty($code)) {
			$data['code'] = $code;
		}
		$res = $this->api->apiPost($this->userInfo['token'], "vbi_sxh/detail_transaction", $data);
		if ($res->status == 200) {
			$this->data['vbis'] = $res->data;
		} else {
			$this->data['vbis'] = array();
		}
		$this->data['template'] = 'page/bao_hiem_vbi/sxh/giao_dich_dong_tien';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
}

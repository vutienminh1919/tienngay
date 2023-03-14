<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Gic_easy extends MY_Controller
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
		 $this->load->helper('lead_helper');
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

	public function add_gic_easy()
	{
		$province_name = !empty($_POST['province_name']) ? $_POST['province_name'] : '';
		$district_name = !empty($_POST['district_name']) ? $_POST['district_name'] : '';
		$nhan_hieu = !empty($_POST['nhan_hieu']) ? $_POST['nhan_hieu'] : '';
		$model = !empty($_POST['model']) ? $_POST['model'] : '';
		$bien_so_xe = !empty($_POST['bien_so_xe']) ? $_POST['bien_so_xe'] : '';
		$so_khung = !empty($_POST['so_khung']) ? $_POST['so_khung'] : '';
		$so_may = !empty($_POST['so_may']) ? $_POST['so_may'] : '';
		$ho_ten_chu_xe = !empty($_POST['ho_ten_chu_xe']) ? $_POST['ho_ten_chu_xe'] : '';
		$dia_chi_dang_ky = !empty($_POST['dia_chi_dang_ky']) ? $_POST['dia_chi_dang_ky'] : '';
		$code_gic_easy = !empty($_POST['code_gic_easy']) ? $_POST['code_gic_easy'] : "";
		$ten_kh = !empty($_POST['ten_kh']) ? $_POST['ten_kh'] : '';
		$cmt = !empty($_POST['cmt']) ? $_POST['cmt'] : '';
		$ngay_sinh = !empty($_POST['ngay_sinh']) ? $_POST['ngay_sinh'] : '';
		$phone = !empty($_POST['phone']) ? $_POST['phone'] : '';
		$mail = !empty($_POST['mail']) ? $_POST['mail'] : '';
		$address = !empty($_POST['address']) ? $_POST['address'] : '';
		
		$price = !empty($_POST['price']) ? $_POST['price'] : "";
		$gender = !empty($_POST['gender']) ? $_POST['gender'] : '';
		$id_pgd = !empty($_POST['id_pgd']) ? $_POST['id_pgd'] : '';
		$thoi_han_hieu_luc = !empty($_POST['thoi_han_hieu_luc']) ? $_POST['thoi_han_hieu_luc'] : '';
		$data = [];
		if (!empty($province_name)) {
			$data['province_name'] = $province_name;
		}
		if (!empty($district_name)) {
			$data['district_name'] = $district_name;
		}
		if (!empty($nhan_hieu)) {
			$data['nhan_hieu'] = $nhan_hieu;
		}
		if (!empty($model)) {
			$data['model'] = $model;
		}
		if (!empty($bien_so_xe)) {
			$data['bien_so_xe'] = $bien_so_xe;
		}
		if (!empty($so_khung)) {
			$data['so_khung'] = $so_khung;
		}
		if (!empty($so_may)) {
			$data['so_may'] = $so_may;
		}
		if (!empty($ho_ten_chu_xe)) {
			$data['ho_ten_chu_xe'] = $ho_ten_chu_xe;
		}
		if (!empty($dia_chi_dang_ky)) {
			$data['dia_chi_dang_ky'] = $dia_chi_dang_ky;
		}
		if (!empty($code_gic_easy)) {
			$data['code_gic_easy'] = $code_gic_easy;
		}
		if (!empty($ten_kh)) {
			$data['ten_kh'] = $ten_kh;
		}
		if (!empty($cmt)) {
			$data['cmt'] = $cmt;
		}
		if (!empty($ngay_sinh)) {
			$data['ngay_sinh'] = strtotime($ngay_sinh);
		}
		if (!empty($phone)) {
			$data['phone'] = $phone;
		}
		if (!empty($mail)) {
			$data['mail'] = $mail;
		}
		if (!empty($thoi_han_hieu_luc)) {
			$data['effective_time'] = $thoi_han_hieu_luc;
		}
		
		if (!empty($price)) {
			$data['price'] = $price;
		}
		if (!empty($address)) {
			$data['address'] = $address;
		}
	
		if (!empty($id_pgd)) {
			$data['id_pgd'] = $id_pgd;
		}

		$res = $this->api->apiPost($this->user['token'], "gic_easy_bn/insert_gic_easy", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "file" => $res->file, "msg" => $res->message)));
			return;
		} elseif (!empty($res->status) && $res->status == 401) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $res->message)));
			return;

		}
	}

	private function pushJson($code, $data)
	{
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}

	public function form_add_gic_easy()
	{
		$stores = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active");
		$store = $this->api->apiPost($this->userInfo['token'], "gic_easy_bn/get_store_by_user");
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
	   $provinceData = $this->api->apiPost($this->userInfo['token'], "province/get_province");
			if (!empty($provinceData->status) && $provinceData->status == 200) {
				$this->data['provinceData'] = $provinceData->data;
			} else {
				$this->data['provinceData'] = array();
			}
			$districtData = $this->api->apiPost($this->userInfo['token'], "province/get_district_by_province", array("id" => $provinceSelected));
			if (!empty($districtData->status) && $districtData->status == 200) {
				$this->data['districtData'] = $districtData->data;
			} else {
				$this->data['districtData'] = array();
			}

	
		$this->data['template'] = 'page/gic_easy/add_gic_easy';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function index()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$customer_phone = !empty($_GET['customer_phone']) ? $_GET['customer_phone'] : "";
		$code = !empty($_GET['code']) ? $_GET['code'] : "";
		$code_gic_easy = !empty($_GET['code_gic_easy']) ? $_GET['code_gic_easy'] : "";
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : 'gic_easy';
		$filter_by_store = !empty($_GET['filter_by_store']) ? $_GET['filter_by_store'] : '';
		if (strtotime($fdate) > strtotime($tdate)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('gic_easy'));
		}
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$data['start'] = $fdate;
			$data['end'] = $tdate;
		}
		if (!empty($customer_name)) {
			$data['customer_name'] = $customer_name;
		}
		if (!empty($customer_phone)) {
			$data['customer_phone'] = $customer_phone;
		}
		if (!empty($code)) {
			$data['code'] = $code;
		}
		if (!empty($code_gic_easy)) {
			$data['code_gic_easy'] = $code_gic_easy;
		}
		if (!empty($filter_by_store)) {
			$data['filter_by_store'] = $filter_by_store;
		}
		$data['tab'] = $tab;
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('gic_easy?fdate=' . $fdate . '&tdate=' . $tdate . '&tab=' . $tab . '&customer_name=' . $customer_name . '&customer_phone=' . $customer_phone . '&code=' . $code . '&code_gic_easy=' . $code_gic_easy . '&filter_by_store=' . $filter_by_store);
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 20;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];
		$mic = $this->api->apiPost($this->userInfo['token'], "gic_easy_bn/get_list_gic_easy", $data);
		if (!empty($mic->status) && $mic->status == 200) {
			$this->data['transaction'] = $mic->data;
			$config['total_rows'] = $mic->total;
		} else {
			$this->data['transaction'] = array();
		}
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
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/gic_easy/list_gic_easy';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function excelGic_easy()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$id_store = !empty($_GET['store']) ? $_GET['store'] : "";
		if (strtotime($fdate) > strtotime($tdate)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('gic_easy/list_gic_easy'));
		}
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$data['start'] = $fdate;
			$data['end'] = $tdate;
		}
		if (!empty($id_store)) {
			$data['store'] = $id_store;
		}
		$config['per_page'] = 10000;
		$data['per_page'] = $config['per_page'];
		$mic = $this->api->apiPost($this->userInfo['token'], "gic_easy_bn/get_list_gic_easy", $data);
		if (!empty($mic->status) && $mic->status == 200) {
			$this->exportGic_easy($mic->data);
			$this->callLibExcel('data-gic-easy' . time() . '.xlsx');

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
			redirect(base_url('gic_easy/list_gic_easy'));
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

	public function exportGic_easy($data)
	{
		$this->sheet->setCellValue('A1', 'Mã giao dịch');
		$this->sheet->setCellValue('B1', 'Người được BH');
		$this->sheet->setCellValue('C1', 'Ngày sinh KH');
		$this->sheet->setCellValue('D1', 'Emai KH');
		$this->sheet->setCellValue('E1', 'Số điện thoại KH');
		$this->sheet->setCellValue('F1', 'Biển số xe');
		$this->sheet->setCellValue('G1', 'Phí BH');
		$this->sheet->setCellValue('H1', 'Ngày hiệu lực');
		$this->sheet->setCellValue('I1', 'Ngày kết thúc');
		$this->sheet->setCellValue('J1', 'Người tạo');
		$this->sheet->setCellValue('K1', 'Phòng giao dịch');
		$i = 2;
		foreach ($data as $item) {
			$this->sheet->setCellValue('A' . $i, !empty($item->id_transaction) ? $item->id_transaction : '');
			$this->sheet->setCellValue('B' . $i, !empty($item->customer_info->customer_name) ? $item->customer_info->customer_name : '');
			$this->sheet->setCellValue('C' . $i, !empty($item->customer_info->birthday) ? date('d/m/Y', $item->customer_info->birthday) : '');
			$this->sheet->setCellValue('D' . $i, !empty($item->customer_info->email) ? $item->customer_info->email : "");
			$this->sheet->setCellValue('E' . $i, !empty($item->customer_info->customer_phone) ? $item->customer_info->customer_phone : '');
			$this->sheet->setCellValue('F' . $i, !empty($item->license_plates) ? $item->license_plates : '');
			$this->sheet->setCellValue('G' . $i, !empty($item->mic_fee) ? number_format($item->mic_fee) . ' VND' : '');
			$this->sheet->setCellValue('H' . $i, !empty($item->NGAY_HL) ? $item->NGAY_HL : '');
			$this->sheet->setCellValue('I' . $i, !empty($item->NGAY_KT) ? $item->NGAY_KT : '');
			$this->sheet->setCellValue('J' . $i, !empty($item->created_by) ? $item->created_by : '');
			$this->sheet->setCellValue('K' . $i, !empty($item->store->name) ? $item->store->name : '');
			$i++;
		}
	}

	public function statistical_gic_easy()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$id_store = !empty($_GET['store']) ? $_GET['store'] : "";
		if (strtotime($fdate) > strtotime($tdate)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('gic_easy/statistical_gic_easy'));
		}
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$data['start'] = $fdate;
			$data['end'] = $tdate;
		}
		if (!empty($id_store)) {
			$data['store'] = $id_store;
		}
		$stores = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active", $data);
		$this->data['stores'] = $stores->data;
//		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
//		$this->load->library('pagination');
//		$config = $this->config->item('pagination');
//		$config['base_url'] = base_url('gic_easy/statistical_gic_easy?fdate=' . $start . '&tdate=' . $end . '&store=' . $id_store);
//		$config['uri_segment'] = $uriSegment;
//		$config['per_page'] = 30;
//		$config['enable_query_strings'] = true;
//		$config['page_query_string'] = true;
//		$data['per_page'] = $config['per_page'];
//		$data['uriSegment'] = $config['uri_segment'];
		$mic = $this->api->apiPost($this->userInfo['token'], "gic_easy_bn/statistical_gic_easy", $data);
		if (!empty($mic->status) && $mic->status == 200) {
			$this->data['mics'] = $mic->data;
//			$config['total_rows'] = $mic->total;
//			$this->data['total_rows'] = $mic->total;
		} else {
			$this->data['mics'] = array();
		}
//		$this->pagination->initialize($config);
//		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/gic_easy/statistical_gic_easy';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function get_price_gic_easy()
	{
		$loai_xe = !empty($_GET['loai_xe']) ? $_GET['loai_xe'] : "";
		$muc_trach_nhiem = !empty($_GET['muc_trach_nhiem']) ? $_GET['muc_trach_nhiem'] : "";
		$thoi_han_hieu_luc = !empty($_GET['thoi_han_hieu_luc']) ? $_GET['thoi_han_hieu_luc'] : "";
		if (!empty($loai_xe)) {
			$data['loai_xe'] = $loai_xe;
		}
		if (!empty($muc_trach_nhiem)) {
			$data['muc_trach_nhiem'] = $muc_trach_nhiem;
		}
		if (!empty($thoi_han_hieu_luc)) {
			$data['effective_time'] = $thoi_han_hieu_luc;
		}
		$price = $this->api->apiPost($this->userInfo['token'], "gic_easy_bn/get_phi_gic_easy", $data);
		if (!empty($price->status) && $price->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $price->message, 'data' => $price->phi)));
			return;
		}
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
		$acceptFormat = array("jpeg", "png", "jpg");
		if (in_array($_FILES['file']['type'], $acceptFormat)) {
			return $this->pushJson('200', json_encode(array(
				'code' => '201',
				'msg' => 'Định dạng không cho phép',
				'type' => $_FILES['file']['type']
			)));
		}
		$serviceUpload = $this->config->item("url_service_upload");
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

	public function detail_gic_easy()
	{
		$this->data['template'] = 'page/gic_easy/view_img';
		$dataGet = $this->input->get();
		$dataGet['id'] = $this->security->xss_clean($dataGet['id']);
		$dataPost = array(
			"id" => $dataGet['id']
		);
		$result = $this->api->apiPost($this->userInfo['token'], "gic_easy_bn/detail_gic_easy", $dataPost);
		$this->data['images'] = $result->data;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

   	public function add_transaction_pay_money()
	{
		$data = [];
		$stores = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active");
		$store = $this->api->apiPost($this->userInfo['token'], "gic_easy_bn/get_store_by_user");
		if (!empty($store->status) && $store->status == 200) {
			$this->data['stores'] = $store->data;
		} else {
			$this->data['stores'] = $stores->data;
		}
		$mic = $this->api->apiPost($this->userInfo['token'], "gic_easy_bn/get_gic_easy_accounting_transfe", $data);
		if ($mic->status == 200) {
			$this->data['gic_easy'] = $mic->data;
			$this->data['total_money'] = $mic->total_money;
		} else {
			$this->data['gic_plt'] = array();
		}
		$storeDataCentral = $this->api->apiPost($this->userInfo['token'], "Store/getAllStoreCentral", array());
		if (!empty($storeDataCentral->status) && $storeDataCentral->status == 200) {
			$this->data['storeDataCentral'] = $storeDataCentral->data;
		} else {
			$this->data['storeDataCentral'] = array();
		}
		$this->data['template'] = 'page/gic_easy/giao_dich_dong_tien_them_moi';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function create_transaction()
	{
		$code = !empty($_POST['mic']) ? $_POST['mic'] : '';
		$store = !empty($_POST['store']) ? $_POST['store'] : '';
		if (!empty($code)) {
			$data['code'] = explode(',', $code);
		}
		if (!empty($store)) {
			$data['store'] = $store;
		}
		
		$res = $this->api->apiPost($this->userInfo['token'], "gic_easy_bn/create_transaction", $data);
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
		$res = $this->api->apiPost($this->userInfo['token'], "gic_easy_bn/detail_transaction", $data);
		if ($res->status == 200) {
			$this->data['mics'] = $res->data;
		} else {
			$this->data['mics'] = array();
		}
		$this->data['template'] = 'page/gic_easy/giao_dich_dong_tien';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function get_total_pay()
	{
		$code = !empty($_POST['code']) ? $_POST['code'] : '';
		if (!empty($code)) {
			$data['code'] = $code;
		}
		$res = $this->api->apiPost($this->userInfo['token'], "gic_easy_bn/get_total_pay", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", 'total' => $res->total, "msg" => $res->message)));
			return;
		}
	}

	public function get_time()
	{
		$year = !empty($_GET['year']) ? $_GET['year'] : '';
		if (!empty($year)) {
			$data['year'] = $year;
		}
		$res = $this->api->apiPost($this->userInfo['token'], "gic_easy_bn/get_time", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", 'date' => $res->date, "msg" => $res->message)));
			return;
		}
	}
}

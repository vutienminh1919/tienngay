<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Pti_vta extends MY_Controller
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
		$this->spreadsheet = new Spreadsheet();
		$this->sheet = $this->spreadsheet->getActiveSheet();
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}
	 public function list_pti_vta_doi_soat()
	{
          $uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('pti_vta/list_pti_vta_doi_soat?fdate='.$start.'&tdate='.$end);
		$this->data["pageName"] = 'PTI VTA';
			$config['per_page'] = 30;
			$config['enable_query_strings'] = true;
			$config['page_query_string'] = true;
			$config['uri_segment'] = $uriSegment;
		$data = array(
				
				"per_page" => $config['per_page'],
				"uriSegment" => $config['uri_segment']
			);
		if(strtotime($start) > strtotime($end)){
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('pti_vta/list_pti_vta_doi_soat'));
		}

		if(!empty($_GET['fdate']) && !empty($_GET['tdate'])){

			$data['start'] = $start;
			$data['end'] = $end;

		}
		//var_dump($this->userInfo['token']); die;
		$ptiData = $this->api->apiPost($this->userInfo['token'], "pti_vta/get_list_pti_vta_doi_soat", $data);
		if (!empty($ptiData->status) && $ptiData->status == 200) {
			$this->data['ptiData'] = $ptiData->data;
			$config['total_rows'] = $ptiData->total;
		} else {
			$this->data['ptiData'] = array();
		}
          $this->pagination->initialize($config);
       $this->data['result_count']= "Hiển thị ".$config['total_rows']." Kết quả";
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/pti_vta/list_pti_vta_doi_soat';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
    public function list_pti_vta_hd()
	{
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$code_contract_disbursement = !empty($_GET["code_contract_disbursement"]) ? $_GET["code_contract_disbursement"] : "";
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('pti_vta/list_pti_vta_hd?fdate='.$start.'&tdate='.$end . '&code_contract_disbursement=' . $code_contract_disbursement);
		$this->data["pageName"] = 'PTI VTA';
			$config['per_page'] = 30;
			$config['enable_query_strings'] = true;
			$config['page_query_string'] = true;
			$config['uri_segment'] = $uriSegment;
		$data = array(
				
				"per_page" => $config['per_page'],
				"uriSegment" => $config['uri_segment']
			);
		if(strtotime($start) > strtotime($end)){
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('pti_vta/list_pti_vta_hd'));
		}

		if(!empty($_GET['fdate']) && !empty($_GET['tdate'])){

			$data['start'] = $start;
			$data['end'] = $end;

		}
		if (!empty($code_contract_disbursement)) {
			$data['code_contract_disbursement'] = trim($code_contract_disbursement);
		}
		//var_dump($this->userInfo['token']); die;
		$ptiData = $this->api->apiPost($this->userInfo['token'], "pti_vta/get_list_pti_vta_hd", $data);
		if (!empty($ptiData->status) && $ptiData->status == 200) {
			$this->data['ptiData'] = $ptiData->data;
			$config['total_rows'] = $ptiData->total;
		} else {
			$this->data['ptiData'] = array();
		}
          $this->pagination->initialize($config);
       $this->data['result_count']= "Hiển thị ".$config['total_rows']." Kết quả";
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/pti_vta/list_pti_vta_hd';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
	public function restore_pti_vta(){

        $data = $this->input->post();
        $data['id_contract'] = $this->security->xss_clean($data['id_contract']);
        $result = $this->api->apiPost($this->userInfo['token'], "contract/restore_pti_vta", $data);
	       if(!empty($result->status) && $result->status == 200) 
	        {
	            $response = [
	                'res' => true,
	                'code' => "200",
	                'msg' => $result->message
	               
	            ];
	            echo json_encode($response);
	            return;
	        }else{
	            $response = [
	                'res' => false,
	                'code' => "400",
	                'msg' => $result->message
	            ];
	            echo json_encode($response);
	            return;
	        }
	    }
	public function add_pti_vta()
	{
		$fullname = !empty($_POST['fullname']) ? $_POST['fullname'] : '';
		$gender = !empty($_POST['gender']) ? $_POST['gender'] : '';
		$cmt = !empty($_POST['cmt']) ? $_POST['cmt'] : '';
		$relationship = !empty($_POST['relationship']) ? $_POST['relationship'] : '';
		$address = !empty($_POST['address']) ? $_POST['address'] : '';
		$id_pgd = !empty($_POST['id_pgd']) ? $_POST['id_pgd'] : '';
		$obj = !empty($_POST['obj']) ? $_POST['obj'] : '';
		$phone = !empty($_POST['phone']) ? $_POST['phone'] : '';
		$email = !empty($_POST['email']) ? $_POST['email'] : '';
		$birthday = !empty($_POST['birthday']) ? $_POST['birthday'] : '';
		$fullname_another = !empty($_POST['fullname_another']) ? $_POST['fullname_another'] : '';
		$birthday_another = !empty($_POST['birthday_another']) ? $_POST['birthday_another'] : '';
		$email_another = !empty($_POST['email_another']) ? $_POST['email_another'] : '';
		$cmt_another = !empty($_POST['cmt_another']) ? $_POST['cmt_another'] : '';
		$phone_another = !empty($_POST['phone_another']) ? $_POST['phone_another'] : '';
		$address_another = !empty($_POST['address_another']) ? $_POST['address_another'] : '';
		$gender_another = !empty($_POST['gender_another']) ? $_POST['gender_another'] : '';
		$sel_ql = !empty($_POST['sel_ql']) ? $_POST['sel_ql'] : '';
		$sel_year = !empty($_POST['sel_year']) ? $_POST['sel_year'] : '';
	    $price = !empty($_POST['price']) ? $_POST['price'] : '';
	    $code_fee = !empty($_POST['code_fee']) ? $_POST['code_fee'] : '';
	    $ck1 = !empty($_POST['ck1']) ? $_POST['ck1'] : '';
	    $ck2 = !empty($_POST['ck2']) ? $_POST['ck2'] : '';
	    $ck3 = !empty($_POST['ck3']) ? $_POST['ck3'] : '';
	    $img_xac_minh = !empty($_POST['img_xac_minh']) ? $_POST['img_xac_minh'] : '';
	    $checked_img = !empty($_POST['checked_img']) ? $_POST['checked_img'] : '';
		$data = [];
		if($img_xac_minh=="https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png")
		{
			$this->pushJson('200', json_encode(array("code" => "401", "msg" =>'GIẤY TỜ XÁC MINH đang trống!')));
			return;
		}
		if (!empty($fullname)) {
			$data['fullname'] = $fullname;
		}
		if (!empty($gender)) {
			$data['gender'] = $gender;
		}
		if (!empty($cmt)) {
			$data['cmt'] = $cmt;
		}
		if (!empty($relationship)) {
			$data['relationship'] = $relationship;
		}
		if (!empty($address)) {
			$data['address'] = $address;
		}
		if (!empty($id_pgd)) {
			$data['id_pgd'] = $id_pgd;
		}
		if (!empty($obj)) {
			$data['obj'] = $obj;
		}
		if (!empty($phone)) {
			$data['phone'] = $phone;
		}
		if (!empty($email)) {
			$data['email'] = $email;
		}
		if (!empty($birthday)) {
			$data['birthday'] = $birthday;
		}
		if (!empty($fullname_another)) {
			$data['fullname_another'] = $fullname_another;
		}
		if (!empty($birthday_another)) {
			$data['birthday_another'] = $birthday_another;
		}
		if (!empty($email_another)) {
			$data['email_another'] = $email_another;
		}
		if (!empty($cmt_another)) {
			$data['cmt_another'] = $cmt_another;
		}
		if (!empty($phone_another)) {
			$data['phone_another'] = $phone_another;
		}
		if (!empty($address_another)) {
			$data['address_another'] = $address_another;
		}
		if (!empty($gender_another)) {
			$data['gender_another'] = $gender_another;
		}
		if (!empty($sel_ql)) {
			$data['sel_ql'] = $sel_ql;
		}
		if (!empty($sel_year)) {
			$data['sel_year'] = $sel_year;
		}
		if (!empty($price)) {
			$data['price'] = $price;
		}
		if (!empty($ck1)) {
			$data['ck1'] = $ck1;
		}
		if (!empty($ck2)) {
			$data['ck2'] = $ck2;
		}
		if (!empty($ck3)) {
			$data['ck3'] = $ck3;
		}
		if (!empty($img_xac_minh)) {
			$data['img_xac_minh'] = $img_xac_minh;
		}
		if (!empty($checked_img)) {
			$data['checked_img'] = $checked_img;
		}

		$res = $this->api->apiPost($this->user['token'], "pti_vta/insert_pti_vta", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $res->message)));
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
    private function validateAge($birthday, $from = 18, $to = 59)
	{
		$today = new DateTime(date("Y-m-d"));
		$bday = new DateTime($birthday);
		$interval = $today->diff($bday);
		if (intval($interval->y) >= $from && intval($interval->y) <= $to) {
			return 'TRUE';
		} else {
			return 'FALSE';
		}
	}
	public function form_add_pti_vta()
	{
		$stores = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active");
		$store = $this->api->apiPost($this->userInfo['token'], "pti_vta/get_store_by_user");
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
		$list_fee = $this->api->apiPost($this->userInfo['token'],"Pti_vta_fee/list_pti_fee",[]);
		if (!empty($list_fee->status) && $list_fee->status == 200) {
			$this->data['list_fee'] = $list_fee->data;
		} else {
			$this->data['list_fee'] = array();
		}
		$this->data['template'] = 'page/pti_vta/add_pti_vta';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function index()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$customer_phone = !empty($_GET['customer_phone']) ? $_GET['customer_phone'] : "";
		$code = !empty($_GET['code']) ? $_GET['code'] : "";
		$code_pti_vta = !empty($_GET['code_pti_vta']) ? $_GET['code_pti_vta'] : "";
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : 'pti_vta';
		$filter_by_store = !empty($_GET['filter_by_store']) ? $_GET['filter_by_store'] : '';
		$customer_cmt = !empty($_GET['customer_cmt']) ? $_GET['customer_cmt'] : "";
		$customer_name_another = !empty($_GET['customer_name_another']) ? $_GET['customer_name_another'] : "";
		$filter_by_status = !empty($_GET['filter_by_status']) ? $_GET['filter_by_status'] : "";
		$filter_by_sell_per = !empty($_GET['filter_by_sell_per']) ? $_GET['filter_by_sell_per'] : "";
		if (strtotime($fdate) > strtotime($tdate)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('pti_vta'));
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
		if (!empty($code_pti_vta)) {
			$data['code_pti_vta'] = $code_pti_vta;
		}
		if (!empty($filter_by_store)) {
			$data['filter_by_store'] = $filter_by_store;
		}
		if (!empty($customer_cmt)) {
			$data['customer_cmt'] = $customer_cmt;
		}
		if (!empty($customer_name_another)) {
			$data['customer_name_another'] = $customer_name_another;
		}
		if (!empty($filter_by_status)) {
			$data['filter_by_status'] = $filter_by_status;
		}
		if (!empty($filter_by_sell_per)) {
			$data['filter_by_sell_per'] = $filter_by_sell_per;
		}
		$data['tab'] = $tab;
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('pti_vta?fdate=' . $fdate . '&tdate=' . $tdate . '&tab=' . $tab . '&customer_name=' . $customer_name . '&customer_phone=' . $customer_phone . '&code=' . $code . '&code_pti_vta=' . $code_pti_vta . '&filter_by_store=' . $filter_by_store . '&customer_cmt=' . $customer_cmt . '&customer_name_another=' . $customer_name_another . '&filter_by_status=' . $filter_by_status . '&filter_by_sell_per=' . $filter_by_sell_per);
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 20;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];
		$pti = $this->api->apiPost($this->userInfo['token'], "pti_vta/get_list_pti_vta", $data);
		if (!empty($pti->status) && $pti->status == 200) {
			$this->data['transaction'] = $pti->data;
			$config['total_rows'] = $pti->total;
			$this->data['total'] = $pti->total;
			$this->data['total_not_send_yet'] = $pti->total_not_send_yet;
			$this->data['total_sended'] = $pti->total_sended;
			$this->data['total_money'] = number_format($pti->total_money);
			$this->data['total_not_send_yet_money'] = number_format($pti->total_not_send_yet_money);
			$this->data['total_sended_money'] = number_format($pti->total_sended_money);
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
		$this->data['template'] = 'page/pti_vta/list_pti_vta';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	

	public function statistical_pti_vta()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$id_store = !empty($_GET['store']) ? $_GET['store'] : "";
		if (strtotime($fdate) > strtotime($tdate)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('pti_vta/statistical_pti_vta'));
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
//		$config['base_url'] = base_url('pti_vta/statistical_pti_vta?fdate=' . $start . '&tdate=' . $end . '&store=' . $id_store);
//		$config['uri_segment'] = $uriSegment;
//		$config['per_page'] = 30;
//		$config['enable_query_strings'] = true;
//		$config['page_query_string'] = true;
//		$data['per_page'] = $config['per_page'];
//		$data['uriSegment'] = $config['uri_segment'];
		$pti = $this->api->apiPost($this->userInfo['token'], "pti_vta/statistical_pti_vta", $data);
		if (!empty($pti->status) && $pti->status == 200) {
			$this->data['ptis'] = $pti->data;
//			$config['total_rows'] = $pti->total;
//			$this->data['total_rows'] = $pti->total;
		} else {
			$this->data['ptis'] = array();
		}
//		$this->pagination->initialize($config);
//		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/pti_vta/statistical_pti_vta';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
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

	public function detail_pti_vta()
	{
		$this->data['template'] = 'page/pti_vta/view_img';
		$dataGet = $this->input->get();
		$dataGet['id'] = $this->security->xss_clean($dataGet['id']);
		$dataPost = array(
			"id" => $dataGet['id']
		);
		$result = $this->api->apiPost($this->userInfo['token'], "pti_vta/detail_pti_vta", $dataPost);
		$this->data['images'] = $result->data;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function add_transaction_pay_money()
	{
		$data = [];
		$stores = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active");
		$store = $this->api->apiPost($this->userInfo['token'], "pti_vta/get_store_by_user");
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
		$pti = $this->api->apiPost($this->userInfo['token'], "pti_vta/get_pti_vta_accounting_transfe", $data);
		if ($pti->status == 200) {
			$this->data['pti_vta'] = $pti->data;
			$this->data['total_money'] = $pti->total_money;
		} else {
			$this->data['pti_vta'] = array();
		}
		$this->data['template'] = 'page/pti_vta/giao_dich_dong_tien_them_moi';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function create_transaction()
	{
		$code = !empty($_POST['pti_vta']) ? $_POST['pti_vta'] : '';
		$store = !empty($_POST['store']) ? $_POST['store'] : '';
		if (!empty($code)) {
			$data['code'] = explode(',', $code);
		}
		if (!empty($store)) {
			$data['store'] = $store;
		}
		
		$res = $this->api->apiPost($this->userInfo['token'], "pti_vta/create_transaction", $data);
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
		$res = $this->api->apiPost($this->userInfo['token'], "pti_vta/detail_transaction", $data);
		if ($res->status == 200) {
			$this->data['ptis'] = $res->data;
		} else {
			$this->data['ptis'] = array();
		}
		$this->data['template'] = 'page/pti_vta/giao_dich_dong_tien';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function get_total_pay()
	{
		$code = !empty($_POST['code']) ? $_POST['code'] : '';
		if (!empty($code)) {
			$data['code'] = $code;
		}
		$res = $this->api->apiPost($this->userInfo['token'], "pti_vta/get_total_pay", $data);
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
		$res = $this->api->apiPost($this->userInfo['token'], "pti_vta/get_time", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", 'date' => $res->date, "msg" => $res->message)));
			return;
		}
	}
	public function exportListPti_vta_doi_soat()
	{
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "pti_vta";
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		

		$data = array();
		$data['start'] = !empty($fdate) ? $fdate : date('Y-m-d');
		$data['end'] = !empty($tdate) ? $tdate : date('Y-m-d');
		
		$data['per_page'] = 10000;
		$ptiVtaData = $this->api->apiPost($this->userInfo['token'], "pti_vta/get_list_pti_vta_doi_soat", $data);
		//Calculate to export excel
		if (!empty($ptiVtaData->data)) {
			$this->exportPti_vta_doi_soatDetail($ptiVtaData->data);

			var_dump($fdate . ' -- ' . $tdate);
		} else {
			// $this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
			var_dump("Không có dữ liệu để xuất excel");
		}
	}

	public function exportPti_vta_doi_soatDetail($ptiVtaData)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã bảo hiểm');
		$this->sheet->setCellValue('C1', 'Thời gian nộp tiền');
		$this->sheet->setCellValue('D1', 'Tên khách hàng');
		$this->sheet->setCellValue('E1', 'Số điện thoại khách hàng');
		$this->sheet->setCellValue('F1', 'Số tiền');
		$this->sheet->setCellValue('G1', 'Người giao dịch');
		$this->sheet->setCellValue('H1', 'Phòng giao dịch');
		$this->sheet->setCellValue('I1', 'Trạng thái');
		$this->sheet->setCellValue('J1', 'Người tạo');
		$this->sheet->setCellValue('K1', 'Ngày sinh');
		$this->sheet->setCellValue('L1', 'Giới tính');
		$this->sheet->setCellValue('M1', 'CMT');
		$this->sheet->setCellValue('N1', 'Địa chỉ');
		$this->sheet->setCellValue('O1', 'Ngày cấp');
		$this->sheet->setCellValue('P1', 'Loại');



		$i = 2;
		foreach ($ptiVtaData as $ptiVta) {
			$bdiachidn = !empty($ptiVta->request->bdiachidn) ? $ptiVta->request->bdiachidn : "";
                    
			$so_tc_gcn = !empty($ptiVta->pti_info->chung_thuc) ? $ptiVta->pti_info->chung_thuc : "";
			 $gioi_tinh = "Khác";
            if($ptiVta->type_pti=="HD")
            {
               $DCHI = $bdiachidn;
               if (!empty($ptiVta->contract_info->customer_infor->customer_gender)) {
				if ($ptiVta->contract_info->customer_infor->customer_gender == "1"){
					$gioi_tinh = "Nam";
				}
				if ($ptiVta->contract_info->customer_infor->customer_gender == "2"){
					$gioi_tinh = "Nữ";
				}
			   }
            }else {
            	
            	$DCHI = !empty($ptiVta->customer_another_info->address_another) ? $ptiVta->customer_another_info->address_another : "";
            	if (!empty($ptiVta->customer_another_info->gender_another)) {
				if ($ptiVta->customer_another_info->gender_another == "1"){
					$gioi_tinh = "Nam";
				}
				if ($ptiVta->customer_another_info->gender_another == "2"){
					$gioi_tinh = "Nữ";
				}
			   }
            }
           
			
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($ptiVta->pti_code) ?  $ptiVta->pti_code : "");
			$this->sheet->setCellValue('C' . $i, !empty($ptiVta->created_at) ? date('d/m/Y H:i:s', intval($ptiVta->created_at)) : '');
			$this->sheet->setCellValue('D' . $i, !empty($ptiVta->request->ten) ? $ptiVta->request->ten : "");
			$this->sheet->setCellValue('E' . $i, !empty($ptiVta->request->phone) ? hide_phone($ptiVta->request->phone) : "");
			$this->sheet->setCellValue('F' . $i, !empty($ptiVta->request->phi_bh) ? str_replace(',', '', $ptiVta->request->phi_bh)  : "");
			$this->sheet->setCellValue('G' . $i, !empty($ptiVta->created_by) ? $ptiVta->created_by : "");
			$this->sheet->setCellValue('H' . $i, !empty($ptiVta->store->name) ? $ptiVta->store->name : "");
			$this->sheet->setCellValue('I' . $i, !empty($ptiVta->status) ? status_transaction($ptiVta->status) : "");
			$this->sheet->setCellValue('J' . $i, !empty($ptiVta->contract_info->created_by) && $ptiVta->type_pti == "HD" ?  $ptiVta->contract_info->created_by : $ptiVta->created_by);
			$this->sheet->setCellValue('K' . $i, !empty($ptiVta->request->ngay_sinh) ? str_replace(',', '', $ptiVta->request->ngay_sinh)  : "");
			$this->sheet->setCellValue('L' . $i, $gioi_tinh);
			$this->sheet->setCellValue('M' . $i, !empty($ptiVta->request->so_cmt) ? str_replace(',', '', $ptiVta->request->so_cmt)  : "");
			$this->sheet->setCellValue('N' . $i, $DCHI);
			$this->sheet->setCellValue('O' . $i,!empty($ptiVta->request->ngay_hl) ? str_replace(',', '', $ptiVta->request->ngay_hl)  : "");
			$this->sheet->setCellValue('P' . $i,!empty($ptiVta->type_pti) ?  $ptiVta->type_pti  : "");



			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('exportPti_vta_doi_soat_' . time() . '.xlsx');
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

	public function customer_web() {
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$customer_phone = !empty($_GET['customer_phone']) ? $_GET['customer_phone'] : "";
		$code = !empty($_GET['code']) ? $_GET['code'] : "";
		$code_pti_vta = !empty($_GET['code_pti_vta']) ? $_GET['code_pti_vta'] : "";
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : 'pti_vta';
		$filter_by_store = !empty($_GET['filter_by_store']) ? $_GET['filter_by_store'] : '';
		$customer_cmt = !empty($_GET['customer_cmt']) ? $_GET['customer_cmt'] : "";
		$customer_name_another = !empty($_GET['customer_name_another']) ? $_GET['customer_name_another'] : "";
		$filter_by_status = !empty($_GET['filter_by_status']) ? $_GET['filter_by_status'] : "";
		$filter_by_sell_per = !empty($_GET['filter_by_sell_per']) ? $_GET['filter_by_sell_per'] : "";
		if (strtotime($fdate) > strtotime($tdate)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('pti_vta'));
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
		if (!empty($code_pti_vta)) {
			$data['code_pti_vta'] = $code_pti_vta;
		}
		if (!empty($filter_by_store)) {
			$data['filter_by_store'] = $filter_by_store;
		}
		if (!empty($customer_cmt)) {
			$data['customer_cmt'] = $customer_cmt;
		}
		if (!empty($customer_name_another)) {
			$data['customer_name_another'] = $customer_name_another;
		}
		if (!empty($filter_by_status)) {
			$data['filter_by_status'] = $filter_by_status;
		}
		if (!empty($filter_by_sell_per)) {
			$data['filter_by_sell_per'] = $filter_by_sell_per;
		}
		$data['tab'] = $tab;
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('pti_vta/customer_web?fdate=' . $fdate . '&tdate=' . $tdate . '&tab=' . $tab . '&customer_name=' . $customer_name . '&customer_phone=' . $customer_phone . '&code=' . $code . '&code_pti_vta=' . $code_pti_vta . '&filter_by_store=' . $filter_by_store . '&customer_cmt=' . $customer_cmt . '&customer_name_another=' . $customer_name_another . '&filter_by_status=' . $filter_by_status . '&filter_by_sell_per=' . $filter_by_sell_per);
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 20;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];
		$data['type_pti'] = "WEB";
		$pti = $this->api->apiPost($this->userInfo['token'], "pti_vta/get_list_pti_vta", $data);
		if (!empty($pti->status) && $pti->status == 200) {
			$this->data['transaction'] = $pti->data;
			$config['total_rows'] = $pti->total;
			$this->data['total'] = $pti->total;
			$this->data['total_not_send_yet'] = $pti->total_not_send_yet;
			$this->data['total_sended'] = $pti->total_sended;
			$this->data['total_money'] = number_format($pti->total_money);
			$this->data['total_not_send_yet_money'] = number_format($pti->total_not_send_yet_money);
			$this->data['total_sended_money'] = number_format($pti->total_sended_money);
			$this->data['total_web'] = number_format($pti->total_web);
			$this->data['total_web_success'] = number_format($pti->total_web_success);
			$this->data['total_web_wait'] = number_format($pti->total_web_wait);
			$this->data['total_web_kt'] = number_format($pti->total_web_kt);
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
		$this->data['template'] = 'page/pti_vta/list_customer_web';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function confirm_payment_customer() {
		$number_item = !empty($_POST['number_item']) ? $_POST['number_item'] : "";
		$data = $this->api->apiPost($this->user['token'], "pti_vta/confirm_payment_customer", ["number_item" => $number_item]);
		if ( !empty($data->status) && $data->status == 200 ) {
			$response = [
				'status' => "200",
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'status' => "400",
			];
			echo json_encode($response);
			return;
		}
	}

	public function cancel_payment_customer() {
		$number_item = !empty($_POST['number_item']) ? $_POST['number_item'] : "";
		$data = $this->api->apiPost($this->user['token'], "pti_vta/cancel_payment_customer", ["number_item" => $number_item]);
		if ($data) {
			$response = [
				'status' => "200",
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'status' => "400",
			];
			echo json_encode($response);
			return;
		}
	}

	public function refund_payment_customer() {
		$number_item = !empty($_POST['number_item']) ? $_POST['number_item'] : "";
		$data = $this->api->apiPost($this->user['token'], "pti_vta/refund_payment_customer", ["number_item" => $number_item]);
		if ($data) {
			$response = [
				'status' => "200",
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'status' => "400",
			];
			echo json_encode($response);
			return;
		}
	}

	/**
	*	Xem Giấy Chứng Nhận PTI VTA
	*/
	public function viewGCN() {
		$so_id = !empty($_GET['so_id']) ? $_GET['so_id'] : "";
		if (empty($so_id)) {
			return;
		}
		$res = $this->api->apiPost("", "pti_vta/getGCN", ["so_id" => $so_id]);
		$data = (array) $res;
		if ($data['status'] == 200 && isset($data['data'])) {
            header("Location: " . $data['data']); 
			exit();
        } else {
        	return;
        }
	}

}

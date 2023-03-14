<?php

class Report_telesale extends MY_Controller
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
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}


	public function nangsuatlaodong()
	{

		$result = $this->api->apiPost($this->user['token'], "Report_telesale/get_all_nangsuatlaodong", $data);

		$list_telesale = $this->api->apiPost($this->user['token'], "Report_telesale/getGroupRole_telesale");

		if (!empty($list_telesale->data) && $list_telesale->status == 200) {
			$this->data['list_telesale'] = $list_telesale->data;

		} else {
			$this->data['list_telesale'] = array();
		}

		if (!empty($result->status) && $result->status == 200) {
			$this->data['result'] = $result->data;

		} else {
			$this->data['result'] = array();
		}

		$this->data['template'] = 'page/lead/report_telesale/nangsuatlaodong';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function search_nangsuatlaodong()
	{

		$data = [];
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$telesale = !empty($_GET['telesale']) ? $_GET['telesale'] : "";

		if (!empty($fdate)) {
			$data['fdate'] = $fdate;
		}
		if (!empty($tdate)) {
			$data['tdate'] = $tdate;
		}
		if (!empty($telesale)) {
			$data['telesale'] = $telesale;
		}
		if (!empty($fdate) || !empty($tdate)){
		$data['error'] = "Trường không được để trống";
		}


		$result = $this->api->apiPost($this->user['token'], "Report_telesale/get_all_nangsuatlaodong", $data);

		if (!empty($result->status) && $result->status == 200) {
			$this->data['result'] = $result->data;

		} else {
			$this->data['result'] = array();
		}

		$list_telesale = $this->api->apiPost($this->user['token'], "Report_telesale/getGroupRole_telesale");

		if (!empty($list_telesale->data) && $list_telesale->status == 200) {
			$this->data['list_telesale'] = $list_telesale->data;

		} else {
			$this->data['list_telesale'] = array();
		}

		$this->data['template'] = 'page/lead/report_telesale/nangsuatlaodong';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}


	public function tilechuyendoi()
	{

		$stores = $this->api->apiPost($this->user['token'], "store/get_all_noheader");
		if (!empty($stores->status) && $stores->status == 200) {
			$this->data['stores'] = $stores->data;
		} else {
			$this->data['stores'] = array();
		}

		$areaData = $this->api->apiPost($this->userInfo['token'], "area/get_all", $data);
		if (!empty($areaData->status) && $areaData->status == 200) {
			$this->data['areaData'] = $areaData->data;
		} else {
			$this->data['areaData'] = array();
		}

		$result = $this->api->apiPost($this->user['token'], "Report_telesale/get_all_tilechuyendoi", $data);
		if (!empty($result->status) && $result->status == 200) {
			$this->data['result'] = $result->data;

		} else {
			$this->data['result'] = array();
		}


		$this->data['template'] = 'page/lead/report_telesale/tilechuyendoi_pgd';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function search_tilechuyendoi()
	{

		$data = [];
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$area = !empty($_GET['area']) ? $_GET['area'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";

		if (!empty($fdate)) {
			$data['fdate'] = $fdate;
		}
		if (!empty($tdate)) {
			$data['tdate'] = $tdate;
		}
		if (!empty($area)) {
			$data['area'] = $area;
		}
		if (!empty($store)) {
			$data['store'] = $store;
		}


		$stores = $this->api->apiPost($this->user['token'], "store/get_all_noheader");
		if (!empty($stores->status) && $stores->status == 200) {
			$this->data['stores'] = $stores->data;
		} else {
			$this->data['stores'] = array();
		}

		$areaData = $this->api->apiPost($this->userInfo['token'], "area/get_all");
		if (!empty($areaData->status) && $areaData->status == 200) {
			$this->data['areaData'] = $areaData->data;
		} else {
			$this->data['areaData'] = array();
		}

		$result = $this->api->apiPost($this->user['token'], "Report_telesale/get_all_tilechuyendoi", $data);
		if (!empty($result->status) && $result->status == 200) {
			$this->data['result'] = $result->data;

		} else {
			$this->data['result'] = array();
		}


		$this->data['template'] = 'page/lead/report_telesale/tilechuyendoi_pgd';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}


	public function baocaotonghop()
	{

		$result = $this->api->apiPost($this->user['token'], "Report_telesale/get_all_baocao_tonghop", $data);

		if (!empty($result->status) && $result->status == 200) {
			$this->data['result'] = $result->data;
			$this->data['lead_ve'] = $result->lead_ve;
			$this->data['tls_xl'] = $result->tls_xl;
			$this->data['data_gn'] = $result->data_gn;
			$this->data['title'] = $result->title;
			$this->data['data_amount'] = $result->data_amount;

		} else {
			$this->data['result'] = array();
		}

		$kpis = $this->api->apiPost($this->user['token'], "Report_telesale/get_all_monney");
		if (!empty($kpis->status) && $kpis->status == 200) {
			$this->data['kpis'] = $kpis->data->amount_money;
		} else {
			$this->data['kpis'] = array();
		}

		$this->data['template'] = 'page/lead/report_telesale/baocaotonghop';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function create_kpis()
	{

		$data = $this->input->post();
		$data['amount_money'] = $this->security->xss_clean($data['amount_money']);
		$arr = [];
		if (!empty($data['amount_money'])) {
			foreach ($data['amount_money'] as $value) {

				$check = explode(",", $value);
				for ($i = 0; $i < count($check); $i++) {
					if ($check[$i] == ",") {
						unset($check[$i]);
					}
				}
				array_push($arr, implode("", $check));
			}
		}

		for ($i = 0; $i < count($arr); $i++) {
			if ($arr[$i] == "") {
				$arr[$i] = 0;
			}
		}

		$sendApi = array(
			"amount_money" => $arr,
			"created_at" => $this->createdAt,
			"created_by" => $this->userInfo,
		);

		$return = $this->api->apiPost($this->userInfo['token'], "report_telesale/create_kpis", $sendApi);

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


	public function list_kpi()
	{

		try {
			$kpis = $this->api->apiPost($this->user['token'], "Report_telesale/get_all_monney");

			$this->pushJson('200', json_encode(array("code" => "200", "data" => $kpis->data->amount_money)));

		} catch (\Exception $exception) {
			show_404();
		}

	}

	public function search_baocaotonghop(){

		$data = [];
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";


		if (!empty($fdate)) {
			$data['fdate'] = $fdate;
		}
		if (!empty($tdate)) {
			$data['tdate'] = $tdate;
		}

		$result = $this->api->apiPost($this->user['token'], "Report_telesale/get_all_baocao_tonghop", $data);

		if (!empty($result->status) && $result->status == 200) {
			$this->data['result'] = $result->data;
			$this->data['lead_ve'] = $result->lead_ve;
			$this->data['tls_xl'] = $result->tls_xl;
			$this->data['data_gn'] = $result->data_gn;
			$this->data['title'] = $result->title;
			$this->data['data_amount'] = $result->data_amount;

		} else {
			$this->data['result'] = array();
		}

		$kpis = $this->api->apiPost($this->user['token'], "Report_telesale/get_all_monney");
		if (!empty($kpis->status) && $kpis->status == 200) {
			$this->data['kpis'] = $kpis->data->amount_money;
		} else {
			$this->data['kpis'] = array();
		}

		$this->data['template'] = 'page/lead/report_telesale/baocaotonghop';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);


	}

	public function index_reportMkt(){

		$result = $this->api->apiPost($this->user['token'], "Report_telesale/index_reportMkt");
		if (!empty($result->status) && $result->status == 200) {
			$this->data['result'] = $result->data;
		} else {
			$this->data['result'] = array();
		}

		$this->data['template'] = 'page/lead/BaocaoMkt/index';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function search_reportMkt(){

		$data = [];
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		if (!empty($fdate)) {
			$data['fdate'] = $fdate;
		}
		if (!empty($tdate)) {
			$data['tdate'] = $tdate;
		}

		$config['base_url'] = base_url('report_telesale/search_reportMkt?fdate=' . $fdate . '&tdate=' . $tdate);
		$this->pagination->initialize($config);

		$result = $this->api->apiPost($this->user['token'], "Report_telesale/index_reportMkt", $data);
		if (!empty($result->status) && $result->status == 200) {
			$this->data['result'] = $result->data;
		} else {
			$this->data['result'] = array();
		}

		$this->data['template'] = 'page/lead/BaocaoMkt/index';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function index_accesstrade(){


		$countFileReturn = $this->api->apiPost($this->userInfo['token'], "Report_telesale/index_accesstrade_count");

		$count = (int)$countFileReturn->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('report_telesale/index_accesstrade');
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;

		$data["per_page"] = $config['per_page'];
		$data["uriSegment"] = $config['uri_segment'];

		$result = $this->api->apiPost($this->user['token'], "Report_telesale/index_accesstrade", $data);
		if (!empty($result->status) && $result->status == 200) {
			$this->data['result'] = $result->data;
		} else {
			$this->data['result'] = array();
		}
		//Check user hiện tại có thuộc quyền Phan Nguyễn
		$is_user_phan_nguyen = $this->api->apiPost($this->userInfo['token'], 'Report_telesale/get_roles_phan_nguyen', ['user_id' => $this->userInfo['id']]);
		if (!empty($is_user_phan_nguyen->status) && $is_user_phan_nguyen->status == 200) {
			$this->data['is_user_phan_nguyen'] = $is_user_phan_nguyen->data;
		} else {
			$this->data['is_user_phan_nguyen'] = array();
		}

		$this->data['template'] = 'page/lead/BaocaoMkt/list_accesstrade';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function search_accesstrade(){

		$data = [];
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$status_sale = !empty($_GET['status_sale']) ? $_GET['status_sale'] : "";
		$utm_source = !empty($_GET['utm_source']) ? $_GET['utm_source'] : "";

		if (!empty($fdate)) {
			$data['fdate'] = $fdate;
		}
		if (!empty($tdate)) {
			$data['tdate'] = $tdate;
		}
		if (!empty($status_sale)) {
			$data['status_sale'] = $status_sale;
		}
		if (!empty($utm_source)) {
			$data['utm_source'] = $utm_source;
		}

		$countFileReturn = $this->api->apiPost($this->userInfo['token'], "Report_telesale/index_accesstrade_count",$data);

		$count = (int)$countFileReturn->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('report_telesale/search_accesstrade?fdate=' . $fdate . '&tdate=' . $tdate . '&status_sale=' . $status_sale . '&utm_source=' . $utm_source);
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;

		$data["per_page"] = $config['per_page'];
		$data["uriSegment"] = $config['uri_segment'];

		$result = $this->api->apiPost($this->user['token'], "Report_telesale/index_accesstrade", $data);

		if (!empty($result->status) && $result->status == 200) {
			$this->data['result'] = $result->data;
		} else {
			$this->data['result'] = array();
		}
		//Check user hiện tại có thuộc quyền Phan Nguyễn
		$is_user_phan_nguyen = $this->api->apiPost($this->userInfo['token'], 'Report_telesale/get_roles_phan_nguyen', ['user_id' => $this->userInfo['id']]);
		if (!empty($is_user_phan_nguyen->status) && $is_user_phan_nguyen->status == 200) {
			$this->data['is_user_phan_nguyen'] = $is_user_phan_nguyen->data;
		} else {
			$this->data['is_user_phan_nguyen'] = array();
		}


		$this->data['template'] = 'page/lead/BaocaoMkt/list_accesstrade';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);


	}

	public function index_report_inhouse(){

		$data = [];

		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$store_search = !empty($_GET['store_search']) ? $_GET['store_search'] : "";
		$status_pgd = !empty($_GET['status_pgd']) ? $_GET['status_pgd'] : "";

		if (!empty($fdate)) {
			$data['fdate'] = $fdate;
		}
		if (!empty($tdate)) {
			$data['tdate'] = $tdate;
		}
		if (!empty($store_search)) {
			$data['store_search'] = $store_search;
		}
		if (!empty($status_pgd)) {
			$data['status_pgd'] = $status_pgd;
		}


		$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all", array());
		if (!empty($storeData->status) && $storeData->status == 200) {
			$this->data['stores'] = $storeData->data;
		} else {
			$this->data['stores'] = array();
		}


		$countFileReturn = $this->api->apiPost($this->userInfo['token'], "Report_telesale/index_report_inhouse_count",$data);
		$count = (int)$countFileReturn->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('report_telesale/index_report_inhouse?fdate=' . $fdate . '&tdate=' . $tdate . '&store_search=' . $store_search . '&status_pgd=' . $status_pgd);
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;

		$data["per_page"] = $config['per_page'];
		$data["uriSegment"] = $config['uri_segment'];

		$result = $this->api->apiPost($this->user['token'], "Report_telesale/index_report_inhouse", $data);
		if (!empty($result->status) && $result->status == 200) {
			$this->data['result'] = $result->data;
		} else {
			$this->data['result'] = array();
		}

		$this->data['template'] = 'page/lead/report_telesale/report_lead_inhouse.php';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function showLeadLogInfo($id){
		try {
			$id = $this->security->xss_clean($id);
			$condition = array("id" => $id);
			$lead = $this->api->apiPost($this->user['token'], 'report_telesale/get_lead_log', $condition);
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $lead->data)));
		} catch (Exception $exception) {
			show_404();
		}

	}

	public function showTimeHandle($id){
		try {
			$id = $this->security->xss_clean($id);
			$condition = array("id" => $id);
			$lead = $this->api->apiPost($this->user['token'], 'report_telesale/get_lead_log_time_pgd', $condition);
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $lead->data)));
		} catch (Exception $exception) {
			show_404();
		}
	}

	public function showTimeHandleTotal($id){
		try {
			$id = $this->security->xss_clean($id);
			$condition = array("id" => $id);
			$lead = $this->api->apiPost($this->user['token'], 'report_telesale/get_lead_log_time_pgd_total', $condition);
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $lead->data)));
		} catch (Exception $exception) {
			show_404();
		}
	}





}

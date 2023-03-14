<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class HeyU extends MY_Controller
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

	public function index()
	{
		$stores = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active", $data);
		$store = $this->api->apiPost($this->userInfo['token'], "mic_tnds/get_store_by_user", $data);
		if (!empty($store->status) && $store->status == 200) {
			$this->data['stores'] = $store->data;
		} else {
			$this->data['stores'] = $stores->data;
		}
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "";
		$startDate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$endDate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$code_driver_filter = !empty($_GET['code_driver_filter']) ? $_GET['code_driver_filter'] : "";
		$name_driver_filter = !empty($_GET['name_driver_filter']) ? $_GET['name_driver_filter'] : "";
		$code_transaction = !empty($_GET['code_transaction']) ? $_GET['code_transaction'] : "";
		$filter_by_store = !empty($_GET['filter_by_store']) ? $_GET['filter_by_store'] : "";
		$code_heyu = !empty($_GET['code_heyu']) ? $_GET['code_heyu'] : "";
		$data = [];
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('heyU') . '?tab=' . $tab . '&fdate=' . $startDate . '&tdate=' . $endDate . '&code_driver_filter=' . $code_driver_filter . '&name_driver_filter=' . $name_driver_filter . '&code_transaction=' . $code_transaction . '&filter_by_store=' . $filter_by_store . '&code_heyu=' . $code_heyu;
		$config['per_page'] = 20;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;

		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];
		$data['tab'] = $tab;
		if (!empty($startDate) && !empty($endDate)) {
			$data['start'] = $startDate;
			$data['end'] = $endDate;
		}
		if (!empty($code_driver_filter)) {
			$data['code_driver_filter'] = $code_driver_filter;
		}
		if (!empty($name_driver_filter)) {
			$data['name_driver_filter'] = $name_driver_filter;
		}
		if (!empty($code_transaction)) {
			$data['code_transaction'] = $code_transaction;
		}
		if (!empty($filter_by_store)) {
			$data['filter_by_store'] = $filter_by_store;
		}
		if (!empty($code_heyu)) {
			$data['code_heyu'] = $code_heyu;
		}
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		$response = $this->api->apiPost($this->userInfo['token'], "hey_u/get_list_hey_u", $data);
		if ($response->status == 200) {
			$this->data['transaction'] = $response->data;
			$config['total_rows'] = $response->total;
		} else {
			$this->data['transaction'] = array();
		}
		$storeData = $this->userInfo['stores'];
		if (!empty($storeData)) {
			$this->data['storeData'] = $storeData;
		} else {
			$this->data['storeData'] = array();
		}
		$storeDataCentral = $this->api->apiPost($this->userInfo['token'], "Store/getAllStoreCentral", array());
		if (!empty($storeDataCentral->status) && $storeDataCentral->status == 200) {
			$this->data['storeDataCentral'] = $storeDataCentral->data;
		} else {
			$this->data['storeDataCentral'] = array();
		}
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['pageName'] = 'Nạp tiền tài xế HeyU';
		$this->data['template'] = 'page/heyU/index_heyU';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function recharge_the_driver()
	{
		$code_driver = !empty($_POST['code_driver']) ? $_POST['code_driver'] : '';
		$money = !empty($_POST['money']) ? $_POST['money'] : '';
		$store = !empty($_POST['store']) ? $_POST['store'] : '';
		if (!empty($code_driver)) {
			$data['code_driver'] = $code_driver;
		}
		if (!empty($money)) {
			$data['money'] = $money;
		}
		if (!empty($store)) {
			$data['store'] = $store;
		}
		$res = $this->api->apiPost($this->user['token'], "hey_u/recharge_the_driver", $data);
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

	public function add_transaction_pay_money()
	{
		$stores = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active");
		$store = $this->api->apiPost($this->userInfo['token'], "mic_tnds/get_store_by_user");
		if (!empty($store->status) && $store->status == 200) {
			$this->data['stores'] = $store->data;
		} else {
			$this->data['stores'] = $stores->data;
		}
		$data = [];
		$heyU = $this->api->apiPost($this->userInfo['token'], "hey_u/get_hey_u_accounting_transfe", $data);
		if ($heyU->status == 200) {
			$this->data['heyU'] = $heyU->data;
			$config['total_rows'] = $heyU->total;
			$this->data['total_rows'] = $heyU->total;
			$this->data['total_money'] = $heyU->total_money;
		} else {
			$this->data['heyU'] = array();
		}
		$storeDataCentral = $this->api->apiPost($this->userInfo['token'], "Store/getAllStoreCentral", array());
		if (!empty($storeDataCentral->status) && $storeDataCentral->status == 200) {
			$this->data['storeDataCentral'] = $storeDataCentral->data;
		} else {
			$this->data['storeDataCentral'] = array();
		}
		$this->data['template'] = 'page/heyU/giao_dich_dong_tien_them_moi';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function create_transaction()
	{
		$code = !empty($_POST['heyu']) ? $_POST['heyu'] : '';
		$store = !empty($_POST['store']) ? $_POST['store'] : '';
		if (!empty($code)) {
			$data['code'] = explode(',', $code);
		}
		if (!empty($store)) {
			$data['store'] = $store;
		}
		$res = $this->api->apiPost($this->userInfo['token'], "hey_u/create_transaction", $data);
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
		$res = $this->api->apiPost($this->userInfo['token'], "hey_u/detail_transaction", $data);
		if ($res->status == 200) {
			$this->data['heyU'] = $res->data;
		} else {
			$this->data['heyU'] = array();
		}
		$this->data['template'] = 'page/heyU/giao_dich_dong_tien';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function history()
	{
		$startDate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$endDate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$data = [];
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('heyU/history') . '?fdate=' . $startDate . '&tdate=' . $endDate;
		$config['per_page'] = 30;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;

		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];
		if (!empty($startDate) && !empty($endDate)) {
			$data['start'] = $startDate;
			$data['end'] = $endDate;
		}
		
		$response = $this->api->apiPost($this->userInfo['token'], "hey_u/get_history_heyU", $data);
		if ($response->status == 200) {
			$this->data['heyU'] = $response->data;
			$config['total_rows'] = $response->total;
		} else {
			$this->data['transaction'] = array();
		}
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/heyU/history';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function get_total_pay()
	{
		$code = !empty($_POST['code']) ? $_POST['code'] : '';
		if (!empty($code)) {
			$data['code'] = $code;
		}
		$res = $this->api->apiPost($this->userInfo['token'], "hey_u/get_total_pay", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", 'total' => $res->total, "msg" => $res->message)));
			return;
		}
	}

	public function get_name()
	{
		$code_driver = !empty($_GET['code_driver']) ? $_GET['code_driver'] : '';
		if (!empty($code_driver)) {
			$data['code_driver'] = $code_driver;
		}
		$res = $this->api->apiPost($this->userInfo['token'], "hey_u/get_name_driver", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", 'name' => $res->name, "msg" => $res->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $res->message)));
			return;
		}
	}

	public function storage()
	{
		$cpanelV2 = $this->config->item("cpanel_v2_url");
		$token = $this->userInfo['token'];

		$this->data['template'] = 'page/heyU/storage';
		if (!empty($_GET['target_url'])) {
			$this->data['url'] = $_GET['target_url'] . "?access_token=$token";
		} else {
			$this->data['url'] = $cpanelV2 . "cpanel/heyu?access_token=$token";
		}
	    $this->data['iframeDomain'] = $cpanelV2;
		$this->load->view('template', $this->data);
		return;
	}

		public function handover()
	{
		$cpanelV2 = $this->config->item("cpanel_v2_url");
		$token = $this->userInfo['token'];
	    $this->data['template'] = 'page/heyU/storage';
	    $this->data['url'] = $cpanelV2 . "cpanel/heyu/handover?access_token=$token";
		$this->data['iframeDomain'] = $cpanelV2;
		$this->load->view('template', $this->data);
		return;
	}

		public function handoverCreateBill()
	{
		$cpanelV2 = $this->config->item("cpanel_v2_url");
		$token = $this->userInfo['token'];
	    $this->data['template'] = 'page/heyU/storage';
	    $this->data['url'] = $cpanelV2 . "cpanel/heyu/handover/create-bill?access_token=$token";
		$this->data['iframeDomain'] = $cpanelV2;
		$this->load->view('template', $this->data);
		return;
	}

	public function handoverDetailBill($id = NULL)
	{
		$cpanelV2 = $this->config->item("cpanel_v2_url");
		$token = $this->userInfo['token'];
	    $this->data['template'] = 'page/heyU/storage';
	    $this->data['url'] = $cpanelV2 . "cpanel/heyu/handover/$id?access_token=$token";
	    $this->data['iframeDomain'] = $cpanelV2;
		$this->load->view('template', $this->data);
		return;
	}
}

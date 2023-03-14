<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

class View_payroll extends MY_Controller
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


	}

	public function index_payroll(){

		date_default_timezone_set('Asia/Ho_Chi_Minh');

		$data = [];

		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$fdate_month = !empty($_GET['fdate_month']) ? $_GET['fdate_month'] : "";
		$email_user = !empty($_GET['email_user']) ? $_GET['email_user'] : "";
		$data['fdate_month'] = $fdate_month;
		$data['email_user'] = $email_user;

		if (!empty($groupRoles->status) && $groupRoles->status == 200) {

			if (in_array('giao-dich-vien', $groupRoles->data) && !in_array('cua-hang-truong', $groupRoles->data)){

				$count = $this->api->apiPost($this->userInfo['token'], "view_payroll/get_count",$data);

				$count = (int)$count->data;

				$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
				$config = $this->config->item('pagination');
				$config['base_url'] = base_url('view_payroll/index_payroll');
				$config['total_rows'] = $count;
				$config['per_page'] = 30;
				$config['page_query_string'] = true;
				$config['uri_segment'] = $uriSegment;
				$this->pagination->initialize($config);
				$this->data['pagination'] = $this->pagination->create_links();
				$this->data['count'] = $count;

				$data['per_page'] = $config['per_page'];
				$data['uriSegment'] = $config['uri_segment'];

				$getData = $this->api->apiPost($this->userInfo['token'], "view_payroll/get_all", $data);

				if (!empty($getData->status) && $getData->status == 200) {

					$this->data['tong_tien_hoa_hong'] = $getData->tong_tien_hoa_hong;

					$this->data['getData'] = $getData->data;
				} else {
					$this->data['getData'] = array();
				}
			}

			if (in_array('cua-hang-truong', $groupRoles->data) || in_array('quan-ly-khu-vuc', $groupRoles->data)){
				$store = !empty($_GET['store']) ? $_GET['store'] : "";
				$data['store'] = $store;
				$count = $this->api->apiPost($this->userInfo['token'], "view_payroll/get_count",$data);

				$count = (int)$count->data;

				$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
				$config = $this->config->item('pagination');
				$config['base_url'] = base_url('view_payroll/index_payroll?fdate_month=' . $fdate_month . '&email_user=' . $email_user . '&store=' . $store );
				$config['total_rows'] = $count;
				$config['per_page'] = 30;
				$config['page_query_string'] = true;
				$config['uri_segment'] = $uriSegment;
				$this->pagination->initialize($config);
				$this->data['pagination'] = $this->pagination->create_links();
				$this->data['count'] = $count;

				$data['per_page'] = $config['per_page'];
				$data['uriSegment'] = $config['uri_segment'];


				$getData = $this->api->apiPost($this->userInfo['token'], "view_payroll/get_all", $data);

				if (!empty($getData->status) && $getData->status == 200) {

					$this->data['tong_tien_hoa_hong'] = $getData->tong_tien_hoa_hong;

					$this->data['getData'] = $getData->data;
				} else {
					$this->data['getData'] = array();
				}

				$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all", array());
				$stores = !empty($this->userInfo['stores']) ? $this->userInfo['stores'] : array();
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


		}

		$this->data['template'] = 'page/view_payroll/index_payroll.php';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);


	}







}


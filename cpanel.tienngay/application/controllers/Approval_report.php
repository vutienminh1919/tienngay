<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');

class Approval_report extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
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
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	public function index_approval()
	{

		$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all_store");

		if (!empty($storeData->status) && $storeData->status == 200) {
			$this->data['stores'] = $storeData->data;
		} else {
			$this->data['stores'] = array();
		}

		$list_hs = $this->api->apiPost($this->userInfo['token'], "exportExcel/get_user_hs");
		if (!empty($list_hs->status) && $list_hs->status == 200) {
			$this->data['list_hs'] = $list_hs->data;
		} else {
			$this->data['list_hs'] = array();
		}

		$list_asm = $this->api->apiPost($this->userInfo['token'], "exportExcel/getGroupRole_asm");

		if (!empty($list_asm->status) && $list_asm->status == 200) {
			$this->data['list_asm'] = $list_asm->data;
		} else {
			$this->data['list_asm'] = array();
		}

		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$change_time = !empty($_GET['change_time']) ? $_GET['change_time'] : "";
		$stores_ad = !empty($_GET['stores_ad']) ? $_GET['stores_ad'] : "";
		$area = !empty($_GET['area']) ? $_GET['area'] : "";
		$customer_form_hs = !empty($_GET['customer_form_hs']) ? $_GET['customer_form_hs'] : "";


		$data = array();
		if (!empty($start)) $data['start'] = $start;
		if (!empty($end)) $data['end'] = $end;
		if (!empty($change_time)) $data['change_time'] = $change_time;
		if (!empty($stores_ad)) $data['stores_ad'] = $stores_ad;
		if (!empty($area)) $data['area'] = $area;
		if (!empty($customer_form_hs)) $data['customer_form_hs'] = $customer_form_hs;


		$this->data['template'] = 'page/approval_report/export_approval_report';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}


}

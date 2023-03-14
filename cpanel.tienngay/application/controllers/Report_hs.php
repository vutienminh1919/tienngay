<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
class Report_hs extends MY_Controller
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
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}


	public function listReport_hs()
	{


			$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
			$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

			$cond = array(
				"start" => $start,
				"end" => $end,
			);
			$res = $this->api->apiPost($this->user['token'], "report_hs/report_hs",$cond);
			if (!empty($res->status) && $res->status == 200) {
			$this->data['data'] = $res->data;
           }else{
           	$this->data['data'] = array();
           }


		$this->data['template'] = 'page/approval_report/report_month';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}



}

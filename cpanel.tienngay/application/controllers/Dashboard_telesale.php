<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

class Dashboard_telesale extends MY_Controller
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

	public function index_dashboard_telesale(){

		$data = [];
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		if (!empty($fdate)) {
			$data['fdate'] = $fdate;
		}
		if (!empty($tdate)) {
			$data['tdate'] = $tdate;
		}

		$report = $this->api->apiPost($this->user['token'], "dashboard_telesale/index_dashboard_telesale", $data);

		if (!empty($report->status) && $report->status == 200) {
			$this->data['total_lead'] = $report->total_lead;
			$this->data['total_lead_update'] = $report->total_lead_update;
			$this->data['total_lead_qlf'] = $report->total_lead_qlf;
			$this->data['count_hd_giaingan'] = $report->count_hd_giaingan;
			$this->data['price_hd_giaingan'] = $report->price_hd_giaingan;
			$this->data['data'] = $report->data;
			$this->data['total_lead_status'] = $report->total_lead_status;

		} else {
			$this->data['total_lead'] = array();
		}

		$table_telesale = $this->api->apiPost($this->user['token'], "dashboard_telesale/table_telesale", $data);

		if (!empty($table_telesale->status) && $table_telesale->status == 200) {
			$this->data['table_telesale'] = $table_telesale->data;
			$this->data['sort'] = $table_telesale->sort;
			$this->data['sort_convert_tele'] = $table_telesale->sort_convert;

		} else {
			$this->data['table_telesale'] = array();
			$this->data['sort'] = array();
			$this->data['sort_convert_tele'] = array();
		}

		$table_store = $this->api->apiPost($this->user['token'], "dashboard_telesale/table_store", $data);

		if (!empty($table_store->status) && $table_store->status == 200) {
			$this->data['table_store'] = $table_store->data;
			$this->data['sort_convert'] = $table_store->sort_convert;
			$this->data['sort_price'] = $table_store->sort_price;
		} else {
			$this->data['table_store'] = [];
			$this->data['sort_convert'] = [];
			$this->data['sort_price'] = [];
		}


		$this->data['template'] = 'page/dashboard_telesale/tp_telesale.php';
		$this->load->view('template', isset($this->data)?$this->data:NULL);
	}

















}


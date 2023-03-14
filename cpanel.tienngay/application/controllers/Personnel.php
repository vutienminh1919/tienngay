<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
class Personnel extends MY_Controller
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

	public function listNhanSu()
	{

		$personnelData = $this->api->apiPost($this->userInfo['token'], "import/get_all_nhansu");

		if (!empty($personnelData->status) && $personnelData->status == 200) {
			$this->data['personnelData'] = $personnelData->data;
		} else {
			$this->data['personnelData'] = array();
		}

		$this->data['template'] = 'page/importns/list_nhansu';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}



}


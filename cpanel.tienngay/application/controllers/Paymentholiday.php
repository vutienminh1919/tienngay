<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');

class Paymentholiday extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	public function index()
	{
		$cpanelV2 = $this->config->item("cpanel_v2_url");
		$token = $this->userInfo['token'];
	    $this->data['template'] = 'page/payment_holiday/index';
	    $this->data['url'] = $cpanelV2 . "cpanel/payment-holiday/index?access_token=$token";
	    $this->data['iframeDomain'] = $cpanelV2;
		$this->load->view('template', $this->data);
		return;
	}
}

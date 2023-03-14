<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

class Ladipage_lead extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->api = new Api();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url', 'file'));
		$this->load->helper('lead_helper');
		$this->load->model("main_property_model");
		$this->load->model('config_gic_model');
		$this->load->model("time_model");
		$this->load->library('pagination');
		$this->config->load('config');

	


	}

	public function index_dangky_tienngay()
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');


		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('ladipage/dangky.tienngay.vn/index', isset($this->data) ? $this->data : NULL);

	}

	public function vaytien_tienngay_vnbatdongsan()
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');


		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('ladipage/vaytien.tienngay.vnbatdongsan/index', isset($this->data) ? $this->data : NULL);

	}

	public function ndt_tienngay_vn()
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');

		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('ladipage/ndt.tienngay.vn/index', isset($this->data) ? $this->data : NULL);

	}

	public function vaytien_taichinhsieutoc_vn()
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');

		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('ladipage/vaytien.taichinhsieutoc.vn/index', isset($this->data) ? $this->data : NULL);

	}

	public function vaytien_tienngay_vn()
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');

		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('ladipage/vaytien.tienngay.vn/index', isset($this->data) ? $this->data : NULL);

	}

	public function send_otp(){

		$data = $this->input->post();


		$data['name'] = $this->security->xss_clean($data['name']);
		$data['phone'] = $this->security->xss_clean($data['phone']);

		$sendApi = array(
			'name' => $data['name'],
			'phone' => $data['phone'],
		);

		$return = $this->api->apiPost('', "Ladipage_lead/register_lead", $sendApi);

		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "200","message" => $return))));
		} else {
			$msg = !empty($return->message) ? $return->message : "";
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));
		}

	}

	public function send_otp_ndt(){
		$data = $this->input->post();


		$data['name'] = $this->security->xss_clean($data['name']);
		$data['phone'] = $this->security->xss_clean($data['phone']);
		$data['sdt_ndt'] = $this->security->xss_clean($data['sdt_ndt']);

		$sendApi = array(
			'name' => $data['name'],
			'phone' => $data['phone'],
			'sdt_ndt' => $data['sdt_ndt'],
		);

		$return = $this->api->apiPost('', "Ladipage_lead/register_lead_ndt", $sendApi);

		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "200","message" => $return))));
		} else {
			$msg = !empty($return->message) ? $return->message : "";
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));
		}
	}


	public function check_otp(){
		$data = $this->input->post();
		$data['name'] = $this->security->xss_clean($data['name']);
		$data['phone'] = $this->security->xss_clean($data['phone']);
		$data['otp_phone'] = $this->security->xss_clean($data['otp_phone']);
		$data['lead_id'] = $this->security->xss_clean($data['lead_id']);

		$data['link'] = $this->security->xss_clean($data['link']);


		$data['utmSource'] = !empty($_POST['utmSource']) ? $_POST['utmSource'] : "direct";
		$data['utmCampaign'] = !empty($_POST['utmCampaign']) ? $_POST['utmCampaign'] : $data['link'];


		$sendApi = array(
			'name' => $data['name'],
			'phone' => $data['phone'],
			'otp_phone' => $data['otp_phone'],
			'lead_id' => $data['lead_id'],
			'utmSource' => $data['utmSource'],
			'utmCampaign' => $data['utmCampaign'],
			'link' => $data['link']
		);

		$return = $this->api->apiPost('', "Ladipage_lead/insert_lead", $sendApi);
		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "200","message" => $return))));
		} else {
			$msg = !empty($return->message) ? $return->message : "";
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));
		}
	}

	public function check_otp_ndt(){
		$data = $this->input->post();
		$data['name'] = $this->security->xss_clean($data['name']);
		$data['phone'] = $this->security->xss_clean($data['phone']);
		$data['otp_phone'] = $this->security->xss_clean($data['otp_phone']);
		$data['lead_id'] = $this->security->xss_clean($data['lead_id']);
		$data['sdt_ndt'] = $this->security->xss_clean($data['sdt_ndt']);

		$data['link'] = $this->security->xss_clean($data['link']);

		$data['utmSource'] = !empty($_POST['utmSource']) ? $_POST['utmSource'] : "direct";
		$data['utmCampaign'] = !empty($_POST['utmCampaign']) ? $_POST['utmCampaign'] : $data['link'];


		$sendApi = array(
			'name' => $data['name'],
			'phone' => $data['phone'],
			'sdt_ndt' => $data['sdt_ndt'],
			'otp_phone' => $data['otp_phone'],
			'lead_id' => $data['lead_id'],
			'utmSource' => $data['utmSource'],
			'utmCampaign' => $data['utmCampaign'],
			'link' => $data['link']
		);

		$return = $this->api->apiPost('', "Ladipage_lead/insert_lead_ndt", $sendApi);

		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "200","message" => $return))));
		} else {
			$msg = !empty($return->message) ? $return->message : "";
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

	public function camon(){
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('ladipage/dangky.tienngay.vn/camon', isset($this->data) ? $this->data : NULL);
	}

	public function camon_ndt(){
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('ladipage/ndt.tienngay.vn/thank', isset($this->data) ? $this->data : NULL);
	}

	public function camon_tcst(){
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('ladipage/vaytien.taichinhsieutoc.vn/thank_tcst', isset($this->data) ? $this->data : NULL);
	}

	public function vaytien_tienngay_oto()
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');


		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('ladipage/vaytien.tienngay.oto/index', isset($this->data) ? $this->data : NULL);

	}

}


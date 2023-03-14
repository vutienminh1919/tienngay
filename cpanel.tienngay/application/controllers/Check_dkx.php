<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Check_dkx extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
//		$this->api = new Api();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model("time_model");
		$this->load->library('pagination');
		$this->load->helper('lead_helper');
		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
//		if (!$this->userInfo) {
//			$this->session->set_flashdata('error', $this->lang->line('You_do_not_have_permission_access_this_item'));
//			redirect(base_url());
//			return;
//		}
//		if (!$this->is_superadmin) {
//			$paramController = $this->uri->segment(1);
//			$param = strtolower($paramController);
//			if (!in_array($param, $this->paramMenus)) {
//				$this->session->set_flashdata('error', $this->lang->line('not_have_permission') . ' ' . $paramController . '!');
//				redirect(base_url('app'));
//				return;
//			}
//		}
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	private function pushJson($code, $data)
	{
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}

	public function check_info_dkx()
	{
		$url1 = !empty($_GET['img1']) ? $_GET['img1'] : '';
		$url2 = !empty($_GET['img2']) ? $_GET['img2'] : '';

		$res = $this->api->apiPost($this->user['token'], "checkDkx/check_info_dkx", ['img1' => $url1, 'img2' => $url2]);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $res->data, "msg" => $res->message)));
			return;
		} elseif (!empty($res->status) && $res->status == 401) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $res->message)));
			return;
		}
	}

	public function upload_img()
	{
		$data = $this->input->post();
		if ($_FILES['file']['size'] > 20000000) {
			return $this->pushJson('200', json_encode(array(
				'code' => '201',
				'msg' => 'Size max is 10MB'
			)));
		}
		$acceptFormat = array("jpeg", "png", "jpg");
		if (in_array($_FILES['file']['type'], $acceptFormat)) {
			return $this->pushJson('200', json_encode(array(
				'code' => '201',
				'msg' => 'Không đúng định dạng',
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
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		$result1 = json_decode($result);

		$random = sha1(substr(md5(rand()), 0, 8));

		$data_con = array();
		$data_con['url'] = $result1->path;

		$response = array(
			'code' => 200,
			"msg" => "success",
			'path' => $result1->path,
			'key' => $random,
			'raw_name' => $_FILES['file']['name']
		);
		echo json_encode($response);
		return;
	}
}

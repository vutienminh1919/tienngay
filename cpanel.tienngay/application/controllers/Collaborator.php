<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
class Collaborator extends MY_Controller
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

	public function index_collaborator(){
		$data = [
			"user" => !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "",
		];
		$list_ctv = $this->api->apiPost($this->userInfo['token'], "collaborator/get_all_collaborator_model",$data);
		if (!empty($list_ctv->status) && $list_ctv->status == 200) {
			$this->data['list_ctv'] = $list_ctv->data;
		} else {
			$this->data['list_ctv'] = array();
		}

		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$this->data["template"] = "page/collaborator/list_collaborators";
		$this->load->view("template", isset($this->data) ? $this->data : '');
	}

	public function insert_collaborator()
	{

		$data = $this->input->post();

//		$data['ctv_code'] = $this->security->xss_clean($data['ctv_code']);
		$data['ctv_name'] = $this->security->xss_clean($data['ctv_name']);
		$data['ctv_phone'] = $this->security->xss_clean($data['ctv_phone']);
		$data['ctv_job'] = $this->security->xss_clean($data['ctv_job']);
		$data['ctv_bank_name'] = $this->security->xss_clean($data['ctv_bank_name']);
		$data['ctv_bank'] = $this->security->xss_clean($data['ctv_bank']);

		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());


		if (!preg_match("/^[A-z0-9]{0,15}$/", $data['ctv_code'])){
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Mã cộng tác viên không đúng định dạng"
			];
			echo json_encode($response);
			return;
		}

		if (empty($data['ctv_name'])) {

			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Bạn chưa nhập đầy đủ tên cộng tác viên"
			];
			echo json_encode($response);
			return;
		}
		if (empty($data['ctv_phone'])) {

			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Bạn chưa nhập số điện thoại"
			];
			echo json_encode($response);
			return;
		}

		if (!empty($data['ctv_phone']) && !preg_match("/^[0-9]{10}$/", $data['ctv_phone'])) {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Bạn chưa nhập đúng định dạng sđt"
			];
			echo json_encode($response);
			return;
		}

		if (empty($data['ctv_job'])) {

			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Bạn chưa nhập nghề nghiệp"
			];
			echo json_encode($response);
			return;
		}
		if (empty($data['ctv_bank_name'])) {

			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Bạn chưa nhập tên ngân hàng"
			];
			echo json_encode($response);
			return;
		}
		if (empty($data['ctv_bank'])) {

			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Bạn chưa nhập số tài khoản ngân hàng"
			];
			echo json_encode($response);
			return;
		}


		$data = array(
//			"ctv_code" => !empty($data['ctv_code']) ? $data['ctv_code'] : '',
			"ctv_name" => !empty($data['ctv_name']) ? $data['ctv_name'] : '',
			"ctv_phone" => !empty($data['ctv_phone']) ? $data['ctv_phone'] : '',
			"ctv_job" => !empty($data['ctv_job']) ? $data['ctv_job'] : '',
			"ctv_bank_name" => !empty($data['ctv_bank_name']) ? $data['ctv_bank_name'] : '',
			"ctv_bank" => !empty($data['ctv_bank']) ? $data['ctv_bank'] : '',
			"created_at" => $updateAt,
			"user" => !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "",
		);
		$return = $this->api->apiPost($this->user['token'], "collaborator/create_collaborator", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'msg' => 'Thêm mới danh sách thành công',
				'url' => $return->url
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => 'Cộng tác viên đã được tạo',
				'data' => $return
			];
			echo json_encode($response);
			return;
		}
	}

	public function showUpdate_collaborator($id){

		try {
			$id = $this->security->xss_clean($id);
			$condition = array("id" => $id);

			$content = $this->api->apiPost($this->userInfo['token'], "collaborator/get_one", $condition);

			if (!empty($content->data)){
				$content->data->id = $content->data->_id->{'$oid'};
			}


			$this->pushJson('200', json_encode(array("code" => "200", "data" => $content->data)));
		} catch (\Exception $exception) {
			show_404();
		}

	}

	private function pushJson($code, $data)
	{
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}

	public function update(){

		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['ctv_code_update'] = $this->security->xss_clean($data['ctv_code_update']);
		$data['ctv_name_update'] = $this->security->xss_clean($data['ctv_name_update']);
		$data['ctv_phone_update'] = $this->security->xss_clean($data['ctv_phone_update']);
		$data['ctv_job_update'] = $this->security->xss_clean($data['ctv_job_update']);
		$data['ctv_bank_name_update'] = $this->security->xss_clean($data['ctv_bank_name_update']);
		$data['ctv_bank_update'] = $this->security->xss_clean($data['ctv_bank_update']);

		$sendApi = array(
			'id' => $data['id'],
			"ctv_code" => !empty($data['ctv_code_update']) ? $data['ctv_code_update'] : '',
			"ctv_name" => !empty($data['ctv_name_update']) ? $data['ctv_name_update'] : '',
			"ctv_phone" => !empty($data['ctv_phone_update']) ? $data['ctv_phone_update'] : '',
			"ctv_job" => !empty($data['ctv_job_update']) ? $data['ctv_job_update'] : '',
			"ctv_bank_name" => !empty($data['ctv_bank_name_update']) ? $data['ctv_bank_name_update'] : '',
			"ctv_bank" => !empty($data['ctv_bank_update']) ? $data['ctv_bank_update'] : '',
			"user" => !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "",
		);


		$return = $this->api->apiPost($this->userInfo['token'], "collaborator/update", $sendApi);

		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		} else {

			$msg = !empty($return->data->message) ? $return->data->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));

		}


	}


}

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Pti_vta_fee extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->api = new Api();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model("time_model");
		$this->load->model("store_model");
		$this->load->library('pagination');
		$this->load->helper('lead_helper');
		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
		if (!$this->userInfo) {
			$this->session->set_flashdata('error', $this->lang->line('You_do_not_have_permission_access_this_item'));
			redirect(base_url());
			return;
		}
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	private function pushJson($code, $data)
	{
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}

	public function index()
	{
		$this->data["pageName"] = "Danh sách gói phí bảo hiểm PTI VTA";
		$result = $this->api->apiPost($this->userInfo['token'],"Pti_vta_fee/get_all", array());
		if (!empty($result->status) && $result->status == 200) {
			$this->data['pti_fee'] = $result->data;
		} else {
			$this->data['pti_fee'] = array();
		}
		$this->data['template'] = 'page/pti_vta_fee/list_pti_vta_fee.php';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function product_list()
	{
		$this->data["pageName"] = "Quản lý loại hình sản phẩm hoa hồng";
		$data = array(// "type_login" => 1
		);

		$this->data['template'] = 'page/commission_kpi/product_list';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function createPtiFee()
	{
		$this->data["pageName"] = "Cài đặt phí bảo hiểm PTI VTA";
		$this->data['template'] = 'page/pti_vta_fee/form_create_pti_fee.php';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function doCreatePtiFee()
	{
		$data = $this->input->post();
		if (empty($data['title_fee'])) {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Tiêu đề không được để trống!",
			];
			$this->pushJson('200', json_encode($response));
			return;
		}

		if (empty($data['start_date'])) {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Thời gian bắt đầu không được để trống!",
			];
			$this->pushJson('200', json_encode($response));
			return;
		}
		if (empty($data['end_date'])) {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Thời gian kết thúc không được để trống!",
			];
			$this->pushJson('200', json_encode($response));
			return;
		}
		if (!empty($data['start_date']) && !empty($data['end_date'])) {
			if (strtotime($data['start_date']) > strtotime($data['end_date'])) {
				$response = [
					'res' => false,
					'status' => "400",
					'msg' => "Thời gian bắt đầu không được lớn hơn thời gian kết thúc!!",
				];
				$this->pushJson('200', json_encode($response));
				return;
			}
		}

		if (empty($data['packet'])) {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Tên gói không được để trống!",
			];
			$this->pushJson('200', json_encode($response));
			return;
		}
		if (!empty($data['packet']) && !in_array($data['packet'], ['G1', 'G2', 'G3'])) {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Tên gói phải thuộc nhóm G1, G2, G3!",
			];
			$this->pushJson('200', json_encode($response));
			return;
		}
		if (empty($data['died_fee'])) {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Quyền lợi hưởng tử vong không được để trống!",
			];
			$this->pushJson('200', json_encode($response));
			return;
		}
		if (empty($data['therapy_fee'])) {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Quyền lợi hưởng điều trị không được để trống!",
			];
			$this->pushJson('200', json_encode($response));
			return;
		}
		if (empty($data['three_month'])) {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Phí 3 tháng không được để trống!",
			];
			$this->pushJson('200', json_encode($response));
			return;
		}
		if (empty($data['six_month'])) {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Phí 6 tháng không được để trống!",
			];
			$this->pushJson('200', json_encode($response));
			return;
		}
		if (empty($data['twelve_month'])) {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Phí 12 tháng không được để trống!",
			];
			$this->pushJson('200', json_encode($response));
			return;
		}
		if (empty($data['quy_one'])) {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Quỹ 1 không được để trống!",
			];
			$this->pushJson('200', json_encode($response));
			return;
		}
		if (empty($data['quy_two'])) {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Quỹ 2 không được để trống!",
			];
			$this->pushJson('200', json_encode($response));
			return;
		}
		if (empty($data['quy_three'])) {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Quỹ 3 không được để trống!",
			];
			$this->pushJson('200', json_encode($response));
			return;
		}
		if (empty($data['quy_four'])) {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Quỹ 4 kết thúc không được để trống!",
			];
			$this->pushJson('200', json_encode($response));
			return;
		}
		if (empty($data['quy_five'])) {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Quỹ 5 không được để trống!",
			];
			$this->pushJson('200', json_encode($response));
			return;
		}
		if (empty($data['quy_six'])) {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Quỹ 6 không được để trống!",
			];
			$this->pushJson('200', json_encode($response));
			return;
		}
		$result = $this->api->apiPost($this->userInfo['token'], "Pti_vta_fee/createPtiFee", $data);
		if (!empty($result->status) && $result->status == 200) {
			$this->pushJson("200", json_encode(array("status" => 200, "msg" => $result->message)));
			return;
		} else {
			$this->pushJson("200", json_encode(array("status" => 400, "msg" => $result->message)));
			return;
		}
	}

	public function listCommission()
	{
		$this->data["pageName"] = "Cài đặt hoa hồng Cộng tác viên";
		$result = $this->api->apiPost($this->userInfo['token'], "Commission_kpi/list_commission", array());
		if (!empty($result->status) && $result->status == 200) {
			$this->data['listCommission'] = $result->data;
		} else {
			$this->data['listCommission'] = array();
		}
		$this->data['template'] = 'page/commission_kpi/list_commission';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function getAllFee()
	{
		$data = $this->input->post();
		$list_fee = $this->api->apiPost($this->userInfo['token'], "Pti_vta_fee/get_pti_fee", $data);
		if (!empty($list_fee->status) && $list_fee->status == 200) {
			$this->pushJson('200', json_encode(array('status' => 200, 'data' => $list_fee->data)));
			return;
		} else {
			$this->pushJson('200', json_encode(array('status' => 400, 'data' => $list_fee->data)));
			return;
		}
	}
}

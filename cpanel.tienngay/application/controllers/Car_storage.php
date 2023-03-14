<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
class Car_storage extends MY_Controller
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

	public function index_car_storage(){

		$list_storage = $this->api->apiPost($this->userInfo['token'], "car_storage/get_all_car_storage");
		if (!empty($list_storage->status) && $list_storage->status == 200) {
			$this->data['list_storage'] = $list_storage->data;
		} else {
			$this->data['list_storage'] = array();
		}

		$this->data["template"] = "page/car_storage/list_carStorage";
		$this->load->view("template", isset($this->data) ? $this->data : '');
	}

	public function insert_car_storage()
	{

		$data = $this->input->post();

		$data['storage_name'] = $this->security->xss_clean($data['storage_name']);
		$data['storage_address'] = $this->security->xss_clean($data['storage_address']);
		$data['car_park'] = $this->security->xss_clean($data['car_park']);
		$data['storage_ticket'] = $this->security->xss_clean($data['storage_ticket']);
		$data['storage_price'] = $this->security->xss_clean($data['storage_price']);
		$data['storage_covered'] = $this->security->xss_clean($data['storage_covered']);

		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());


		if (empty($data['storage_address'])) {

			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Bạn chưa nhập đầy đủ địa chỉ"
			];
			echo json_encode($response);
			return;
		}
		if (empty($data['storage_name'])) {

			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Bạn chưa nhập đầy đủ tên"
			];
			echo json_encode($response);
			return;
		}
		if (empty($data['storage_price'])) {

			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Bạn chưa nhập đầy đủ tiền"
			];
			echo json_encode($response);
			return;
		}

		$data = array(
			"storage_name" => !empty($data['storage_name']) ? $data['storage_name'] : '',
			"storage_address" => !empty($data['storage_address']) ? $data['storage_address'] : '',
			"car_park" => !empty($data['car_park']) ? $data['car_park'] : '',
			"storage_ticket" => !empty($data['storage_ticket']) ? $data['storage_ticket'] : '',
			"storage_price" => !empty($data['storage_price']) ? $data['storage_price'] : '',
			"storage_covered" => !empty($data['storage_covered']) ? $data['storage_covered'] : '',
			"created_at" => $updateAt,
			"user" => !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "",
		);
		$return = $this->api->apiPost($this->user['token'], "car_storage/create_car_storage", $data);

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
				'msg' => 'Tên địa điểm đã được tạo',
				'data' => $return
			];
			echo json_encode($response);
			return;
		}
	}


}

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Commission_kpi extends MY_Controller
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

	
	public function product_list()
	{
		$this->data["pageName"] = "Quản lý loại hình sản phẩm hoa hồng";
		$data = array(// "type_login" => 1
		);
		
		$this->data['template'] = 'page/commission_kpi/product_list';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function createProductType()
	{
		$name_product_type = !empty($_POST['name_product_type']) ? $_POST['name_product_type'] : "";
		$code_product_type = !empty($_POST['code_product_type']) ? $_POST['code_product_type'] : "";
		$parent_property = !empty($_POST['parent_property']) ? $_POST['parent_property'] : "";
		$depreciation = !empty($_POST['depreciation']) ? $_POST['depreciation'] : array();
		$properties = !empty($_POST['properties']) ? $_POST['properties'] : array();
		$name_product_type = $this->security->xss_clean($name_product_type);
		$code_product_type = $this->security->xss_clean($code_product_type);
		$parent_property = $this->security->xss_clean($parent_property);
		$depreciation = $this->security->xss_clean($depreciation);
		$properties = $this->security->xss_clean($properties);

		if (empty($name_product_type)) {
			$this->session->set_flashdata('error', "Tên loại hình đang trống!");
			redirect('Commission_kpi/product_list');
		}
		$parent_id = "";
		if (!empty($parent_property)) {
			$parent_id = $parent_property;
		}

		$fields_depreciation = array();
		foreach ($depreciation as $key => $dep) {
			if (!empty($dep)) {
				$value_dep = array(
					"name" => $dep,
					"slug" => slugify($dep),
				);
				array_push($fields_depreciation, $value_dep);
			}

		}
		$fields_properties = array();
		foreach ($properties as $key => $propertie) {
			if (!empty($propertie)) {
				$value_propertie = array(
					"name" => $propertie,
					"slug" => slugify($propertie)
				);
				array_push($fields_properties, $value_propertie);
			}

		}
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		$data = array(
			"name" => $name_product_type,
			"code" => $code_product_type,
			"properties" => $fields_properties,
			"depreciations" => $fields_depreciation,
			"parent_id" => $parent_id,
			"status" => "active",
			"created_at" => $createdAt,
			"created_by" => $this->userInfo['email'],

		);
		$return = $this->api->apiPost($this->userInfo['token'], "Commission_kpi/create_product_type", $data);
		if (!empty($return->status) && $return->status == 200) {
			$this->session->set_flashdata('success', "Tạo loại hình sản phẩm thành công!");
			redirect('Commission_kpi/product_list');
		} else {
			$this->session->set_flashdata('error', $return->message);
			// $this->session->set_flashdata('error', $this->lang->line('create_valuation_failed'));
			redirect('Commission_kpi/product_list');
		}
	}

	public function update()
	{
		$this->data["pageName"] = "Cập nhập loại hình sản phẩm";
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		$id = $this->security->xss_clean($id);
		$data = array(
			"id" => $id,
			// "type_login" => 1
		);

		$main_property = $this->api->apiPost($this->userInfo['token'], "Commission_kpi/get_property", $data);
		if (!empty($main_property->status) && $main_property->status == 200) {
			$this->data['main_property'] = $main_property->data;
		} else {
			$this->data['main_property'] = array();
		}
		if (empty($main_property->data)) {
			echo "404";
			die;
			redirect('404');
		}
		$dataAll = array(// "type_login" => 1
		);
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "Commission_kpi/get_property_all", $dataAll);
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$this->data['mainPropertyData'] = $mainPropertyData->data;
		} else {
			$this->data['mainPropertyData'] = array();
		}
		$this->data['template'] = 'page/commission_kpi/update';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function doUpdate()
	{
		$id = !empty($_POST['id_property_main']) ? $_POST['id_property_main'] : "";
		$name_product_type = !empty($_POST['name_product_type']) ? $_POST['name_product_type'] : "";
		$code_product_type = !empty($_POST['code_product_type']) ? $_POST['code_product_type'] : "";
		$status = !empty($_POST['status']) ? $_POST['status'] : "";
		$depreciation = !empty($_POST['depreciation']) ? $_POST['depreciation'] : array();
		$price_depreciation = !empty($_POST['price_depreciation']) ? $_POST['price_depreciation'] : array();
		$price = !empty($_POST['price']) ? $_POST['price'] : "";
		$properties = !empty($_POST['properties']) ? $_POST['properties'] : array();
		$parent_property = !empty($_POST['parent_property']) ? $_POST['parent_property'] : "";

		$id = $this->security->xss_clean($id);
		$name_product_type = $this->security->xss_clean($name_product_type);
		$code_product_type = $this->security->xss_clean($code_product_type);
		$status = $this->security->xss_clean($status);
		$depreciation = $this->security->xss_clean($depreciation);
		$price_depreciation = $this->security->xss_clean($price_depreciation);
		$price = $this->security->xss_clean($price);
		$properties = $this->security->xss_clean($properties);
		$parent_property = $this->security->xss_clean($parent_property);

		if (empty($name_product_type)) {
			$this->session->set_flashdata('error', $this->lang->line('product_type_not_null'));
			redirect('Commission_kpi/update?id=' . $id);
		}
		if (empty($status)) {
			$this->session->set_flashdata('error', $this->lang->line('required_status'));
			redirect('Commission_kpi/update?id=' . $id);
		}
		$parent_id = "";
		if (!empty($parent_property)) {
			$parent_id = $parent_property;
		}
		$fields_depreciation = array();
		foreach ($depreciation as $key => $dep) {
			if (!empty($dep)) {
				$value_dep = array(
					"name" => $dep,
					"slug" => slugify($dep),
				);
				array_push($fields_depreciation, $value_dep);
			}
		}

		$fields_properties = array();
		foreach ($properties as $key => $propertie) {
			if (!empty($propertie)) {
				$value_propertie = array(
					"name" => $propertie,
					"slug" => slugify($propertie)
				);
				array_push($fields_properties, $value_propertie);
			}
		}
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		$data = array(
			"name" => $name_product_type,
			"code" => $code_product_type,
			"properties" => $fields_properties,
			"depreciations" => $fields_depreciation,
			"parent_id" => $parent_id,
			"status" => $status,
			"updated_at" => $createdAt,
			"updated_by" => $this->userInfo['email'],
			"id" => $id,
//			"price" => $price,
			// "type_login" => 1
		);

		$return = $this->api->apiPost($this->userInfo['token'], "Commission_kpi/update_property_main", $data);

		if (!empty($return->status) && $return->status == 200) {
			$this->session->set_flashdata('success', $this->lang->line('update_store_success'));
			redirect('Commission_kpi/product_list');
		} else {
			$this->session->set_flashdata('error', $this->lang->line('update_store_failed'));
			redirect('Commission_kpi/update?id=' . $id);
		}

	}

	public function getPopertyByMain()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		$id = $this->security->xss_clean($id);
		$data = array(
			// "type_login" => 1,
			"parent_id" => $id
		);
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "Commission_kpi/get_property_by_main", $data);
		$properties = !empty($mainPropertyData->properties) ? $mainPropertyData->properties : array();
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $mainPropertyData->data,
				'properties' => $properties
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
			];
			echo json_encode($response);
			return;
		}
	}

	public function createCommission()
	{
		$this->data["pageName"] = "Cài đặt hoa hồng Cộng tác viên";
		$this->data['template'] = 'page/commission_kpi/form_product_list';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function doCreateCommission()
	{
		$data = $this->input->post();

		if (empty($data['title_commission'])) {
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
		
		$result = $this->api->apiPost($this->userInfo['token'], "Commission_kpi/createCommission", $data);
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
		$result = $this->api->apiPost($this->userInfo['token'],"Commission_kpi/list_commission", array());
		if (!empty($result->status) && $result->status == 200) {
			$this->data['listCommission'] = $result->data;
		} else {
			$this->data['listCommission'] = array();
		}

		$this->data['template'] = 'page/commission_kpi/list_commission';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function doUpdateStatus()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$status = ($status=='true') ? 'active' : 'deactivate';
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_news_selected_deletion')
			];
			echo json_encode($response);
			return;
		}
		if (empty($status)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_news_selected_deletion')
			];
			echo json_encode($response);
			return;
		}
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		$data = array(
			"id" => $id,
			"status" => $status,
			"updated_at" => $createdAt,
			"updated_by" => $this->userInfo['email']
		);
		$return = $this->api->apiPost($this->user['token'], "Commission_kpi/update_status", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => 'Cập nhập thành công!'
			];
			$this->pushJson('200', json_encode($response));
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $return->message
			];
			$this->pushJson('200', json_encode($response));
			return;
		}
	}
}

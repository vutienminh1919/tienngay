<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class WebsiteCTVTienNgay extends MY_Controller
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

	public function get_list_ctv_intro()
	{
		$this->data['pageName'] = "Danh sách Cộng tác viên giới thiệu";
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : '';
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : '';
		$status = !empty($_GET['status']) ? $_GET['status'] : '';
		$ctv_name = !empty($_GET['ctv_name']) ? $_GET['ctv_name'] : '';
		$ctv_phone = !empty($_GET['ctv_phone']) ? $_GET['ctv_phone'] : '';
		$data = array();
		if (!empty($fdate) && !empty($tdate)) {
			if (strtotime($fdate) > strtotime($tdate)) {
				$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
				redirect(base_url('WebsiteCTVTienNgay/get_list_ctv_intro'));
			}
		}
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['base_url'] = base_url('WebsiteCTVTienNgay/get_list_ctv_intro') . '?fdate=' . $fdate . '&tdate=' . $tdate . '&status=' . $status . '&ctv_name=' . $ctv_name . '&ctv_phone=' . $ctv_phone;
		$data = array(
			'per_page' => $config['per_page'],
			'uriSegment' => $config['uri_segment'],
			'fdate' => $fdate,
			'tdate' => $tdate,
		);
		if (!empty($status)) {
			$data['status'] = $status;
		}
		if (!empty($ctv_name)) {
			$data['ctv_name'] = $ctv_name;
		}
		if (!empty($ctv_phone)) {
			$data['ctv_phone'] = $ctv_phone;
		}
		$result = $this->api->apiPost($this->userInfo['token'], "Ctv_Tienngay/get_all_ctv_intro", $data);
		if (isset($result->status) && $result->status == 200) {
			$this->data['ctv_intro_data'] = $result->data;
			$config['total_rows'] = $result->total;
		} else {
			$this->data['ctv_intro_data'] = array();
		}
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		$this->pagination->initialize($config);
		$this->data['result_count'] = $config['total_rows'];
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/website_ctv_tienngay/collaborator_intro_list';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;
	}

	public function get_list_order()
	{
		$this->data['pageName'] = "Danh sách Cộng tác viên giới thiệu";
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : '';
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : '';
		$status = !empty($_GET['status']) ? $_GET['status'] : '';
		$ctv_name = !empty($_GET['ctv_name']) ? $_GET['ctv_name'] : '';
		$ctv_phone = !empty($_GET['ctv_phone']) ? $_GET['ctv_phone'] : '';
		$lead_name = !empty($_GET['lead_name']) ? $_GET['lead_name'] : '';
		$lead_phone = !empty($_GET['lead_phone']) ? $_GET['lead_phone'] : '';
		$data = array();
		if (!empty($fdate) && !empty($tdate)) {
			if (strtotime($fdate) > strtotime($tdate)) {
				$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
				redirect(base_url('WebsiteCTVTienNgay/get_list_order'));
			}
		}
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 30;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$config['base_url'] = base_url('WebsiteCTVTienNgay/get_list_order') . '?fdate=' . $fdate . '&tdate=' . $tdate . '&status=' . $status . '&ctv_name=' . $ctv_name . '&ctv_phone=' . $ctv_phone . '&lead_name=' . $lead_name . '&lead_phone=' . $lead_phone;
		$data = array(
			'per_page' => $config['per_page'],
			'uriSegment' => $config['uri_segment'],
			'fdate' => $fdate,
			'tdate' => $tdate,
		);
		if (!empty($status)) {
			$data['status'] = $status;
		}
		if (!empty($ctv_name)) {
			$data['ctv_name'] = $ctv_name;
		}
		if (!empty($ctv_phone)) {
			$data['ctv_phone'] = $ctv_phone;
		}
		if (!empty($lead_name)) {
			$data['lead_name'] = $lead_name;
		}
		if (!empty($lead_phone)) {
			$data['lead_phone'] = $lead_phone;
		}
		$result = $this->api->apiPost($this->userInfo['token'], "Ctv_Tienngay/get_all_order", $data);
		if (isset($result->status) && $result->status == 200) {
			$this->data['order_list'] = $result->data;
			$config['total_rows'] = $result->total;
		} else {
			$this->data['order_list'] = array();
		}
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['result_count'] = $config['total_rows'];
		$this->data['template'] = 'page/website_ctv_tienngay/order_list';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;
	}

	public function product_list()
	{
		$this->data["pageName"] = "Quản lý loại hình sản phẩm hoa hồng";
		$data = array(// "type_login" => 1
		);
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "MainCommission/get_property_all", $data);
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$this->data['mainPropertyData'] = $mainPropertyData->data;
		} else {
			$this->data['mainPropertyData'] = array();
		}
		$this->data['template'] = 'page/website_ctv_tienngay/setup_commission/product_list';
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
			redirect('WebsiteCTVTienNgay/product_list');
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
		$return = $this->api->apiPost($this->userInfo['token'], "MainCommission/create_product_type", $data);
		if (!empty($return->status) && $return->status == 200) {
			$this->session->set_flashdata('success', "Tạo loại hình sản phẩm thành công!");
			redirect('WebsiteCTVTienNgay/product_list');
		} else {
			$this->session->set_flashdata('error', $return->message);
			// $this->session->set_flashdata('error', $this->lang->line('create_valuation_failed'));
			redirect('WebsiteCTVTienNgay/product_list');
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

		$main_property = $this->api->apiPost($this->userInfo['token'], "MainCommission/get_property", $data);
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
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "MainCommission/get_property_all", $dataAll);
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$this->data['mainPropertyData'] = $mainPropertyData->data;
		} else {
			$this->data['mainPropertyData'] = array();
		}
		$this->data['template'] = 'page/website_ctv_tienngay/setup_commission/update';
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
			redirect('WebsiteCTVTienNgay/update?id=' . $id);
		}
		if (empty($status)) {
			$this->session->set_flashdata('error', $this->lang->line('required_status'));
			redirect('WebsiteCTVTienNgay/update?id=' . $id);
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

		$return = $this->api->apiPost($this->userInfo['token'], "MainCommission/update_property_main", $data);

		if (!empty($return->status) && $return->status == 200) {
			$this->session->set_flashdata('success', 'Cập nhật thành công!');
			redirect('WebsiteCTVTienNgay/product_list');
		} else {
			$this->session->set_flashdata('error', $this->lang->line('Cập nhật thất bại!'));
			redirect('WebsiteCTVTienNgay/update?id=' . $id);
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
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "MainCommission/get_property_by_main", $data);
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
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "MainCommission/get_property_main");
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$this->data['mainPropertyData'] = $mainPropertyData->data;
		} else {
			$this->data['mainPropertyData'] = array();
		}

		$dataGet = $this->input->get();
		//Id = Loại tài sản
		if (!empty($dataGet['main'])) $dataGet['main'] = $this->security->xss_clean($dataGet['main']);
		$dataInit = array(
			"main" => !empty($dataGet['main']) ? $dataGet['main'] : "",
		);
		$this->data['dataInit'] = $dataInit;

		$groupCTV = $this->api->apiPost($this->userInfo['token'], "Ctv_Tienngay/get_all_ctv_by_group");
		if (!empty($groupCTV->status) && $groupCTV->status == 200) {
			$this->data["groupCTV"] = $groupCTV->data;
		} else {
			$this->data["groupCTV"] = array();
		}
		$this->data['template'] = 'page/website_ctv_tienngay/setup_commission/form_product_list';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function doCreateCommission()
	{
		$data = $this->input->post();
		$data['product_type'] = $this->security->xss_clean($data['product_type']);
		$data['title_commission'] = $this->security->xss_clean($data['title_commission']);
		$data['group_ctv'] = $this->security->xss_clean($data['group_ctv']);
		$data['application_ctv_individual'] = $this->security->xss_clean($data['application_ctv_individual']);
		$data['start_date'] = $this->security->xss_clean($data['start_date']);
		$data['end_date'] = $this->security->xss_clean($data['end_date']);
		$data['note_commission'] = $this->security->xss_clean($data['note_commission']);
		$data['product_list'] = $this->security->xss_clean($data['product_list']);
		$data['status'] = "active";
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		$data['created_at'] = $createdAt;
		$data['created_by'] = $this->userInfo['email'];
		if (empty($data['title_commission'])) {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Tiêu đề không được để trống!",
			];
			$this->pushJson('200', json_encode($response));
			return;
		}
		if (empty($data['group_ctv'])) {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Công ty áp dụng không được để trống!",
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
		if (!empty($data['product_list'])) {
			foreach ($data['product_list'] as $product) {
				if (empty($product['percent'])) {
					$response = [
						'res' => false,
						'status' => "400",
						'msg' => "Tỷ lệ phần trăm không được để trống!",
					];
					$this->pushJson('200', json_encode($response));
					return;
				}
			}
		}
		$result = $this->api->apiPost($this->userInfo['token'], "Commission_setup/createCommission", $data);
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
		$result = $this->api->apiPost($this->userInfo['token'],"Commission_setup/list_commission", array());
		if (!empty($result->status) && $result->status == 200) {
			$this->data['listCommission'] = $result->data;
		} else {
			$this->data['listCommission'] = array();
		}

		$this->data['template'] = 'page/website_ctv_tienngay/setup_commission/list_commission';
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
		$return = $this->api->apiPost($this->user['token'], "Commission_setup/update_status", $data);
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

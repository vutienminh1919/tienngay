<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Property_main extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->api = new Api();
		$this->load->model("main_property_model");
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model("time_model");
		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
//		if (!$this->is_superadmin) {
//			$paramController = $this->uri->segment(1);
//			$param = strtolower($paramController);
//			if (!in_array($param, $this->paramMenus)) {
//				$this->session->set_flashdata('error', $this->lang->line('not_have_permission') . ' ' . $paramController . '!');
//				redirect(base_url('app'));
//				return;
//			}
//		}

	}

	public function getPriceProperty()
	{
		$formality = !empty($_POST['formality']) ? $_POST['formality'] : "";
		$property_id = !empty($_POST['property_id']) ? $_POST['property_id'] : "";
		$depreciation_price = !empty($_POST['depreciation_price']) ? $_POST['depreciation_price'] : "";
		$property_id = $this->security->xss_clean($property_id);
		$data = array(
			"id" => $property_id,
			// "type_login" => 1
		);
		$propertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property", $data);
		if (!empty($propertyData->status) && $propertyData->status == 200 && !empty($propertyData->data->price)) {
//            if($depreciation_price >=1 &&  $depreciation_price <= 100)
//            {
//                 $price = (int)$propertyData->data->price - (int)$propertyData->data->price*(int)$depreciation_price/100;
//             }else{
//                 $price = (int)$propertyData->data->price - (int)$depreciation_price;
//             }
			$giam_tru_tieu_chuan = !empty($propertyData->data->giam_tru_tieu_chuan) ? (int)$propertyData->data->giam_tru_tieu_chuan : 0;
			$price_tieu_chuan = (int)$propertyData->data->price - (int)$propertyData->data->price * $giam_tru_tieu_chuan / 100;
			$price = $price_tieu_chuan - (int)$propertyData->data->price * (int)$depreciation_price / 100;
			$amount_money = (int)$price * (int)$formality / 100;
			$response = [
				'res' => true,
				'status' => "200",
				'price' => number_format($price),
				'amount_money' => number_format($amount_money),
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

	public function getDepreciationByProperty()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		$type_loan = !empty($_POST['type_loan']) ? $_POST['type_loan'] : "";
		$code_type_property = !empty($_POST['code_type_property']) ? $_POST['code_type_property'] : "";
		$id = $this->security->xss_clean($id);
		$data = array(
			// "type_login" => 1,
			"id" => $id
		);
		$depreciationData = $this->api->apiPost($this->userInfo['token'], "property/get_depreciation_by_property", $data);
		if (!empty($depreciationData->status) && $depreciationData->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $depreciationData->data,
				'price_property' => $depreciationData->price_property
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'price_property' => $depreciationData->price_property
			];
			echo json_encode($response);
			return;
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
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_by_main", $data);
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

	public function appraise()
	{
		//get property main ( tài sản cấp cao nhất parenid == null)
		$this->data["pageName"] = $this->lang->line('property_valuation');
		$data = array(// "type_login" => 1
		);
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main", $data);
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$this->data['mainPropertyData'] = $mainPropertyData->data;
		} else {
			$this->data['mainPropertyData'] = array();
		}
		//get hình thức vay
		$data = array(// "type_login" => 1
		);
		$configuration_formality = $this->api->apiPost($this->userInfo['token'], "configuration_formality/get_configuration_formality", $data);
		if (!empty($configuration_formality->status) && $configuration_formality->status == 200) {
			$this->data['configuration_formality'] = $configuration_formality->data;
		} else {
			$this->data['configuration_formality'] = array();
		}
		$this->data['template'] = 'page/property/main/appraise_new';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function deletePropertyMain()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		$id = $this->security->xss_clean($id);

		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('nothing_valuation_to_delete')
			];
			echo json_encode($response);
			return;
		}
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		$data = array(
			"status" => 'block',
			"updated_at" => $createdAt,
			"updated_by" => $this->userInfo['email'],
			"id" => $id,
			// "type_login" => 1
		);
		$return = $this->api->apiPost($this->userInfo['token'], "property/update_property_main", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('valuation_delete_success')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('valuation_delete_failed')
			];
			echo json_encode($response);
			return;
		}


	}

	public function doUpdate()
	{
		$id = !empty($_POST['id_property_main']) ? $_POST['id_property_main'] : "";
		$name_property_main = !empty($_POST['name_property_main']) ? $_POST['name_property_main'] : "";
		$code_property_main = !empty($_POST['name_property_main']) ? $_POST['code_property_main'] : "";
		$status = !empty($_POST['status']) ? $_POST['status'] : "";
		$depreciation = !empty($_POST['depreciation']) ? $_POST['depreciation'] : array();
		$price_depreciation = !empty($_POST['price_depreciation']) ? $_POST['price_depreciation'] : array();
		$price = !empty($_POST['price']) ? $_POST['price'] : "";
		$properties = !empty($_POST['properties']) ? $_POST['properties'] : array();
		$parent_property = !empty($_POST['parent_property']) ? $_POST['parent_property'] : "";

		$id = $this->security->xss_clean($id);
		$name_property_main = $this->security->xss_clean($name_property_main);
		$code_property_main = $this->security->xss_clean($code_property_main);
		$status = $this->security->xss_clean($status);
		$depreciation = $this->security->xss_clean($depreciation);
		$price_depreciation = $this->security->xss_clean($price_depreciation);
		$price = $this->security->xss_clean($price);
		$properties = $this->security->xss_clean($properties);
		$parent_property = $this->security->xss_clean($parent_property);

		if (empty($name_property_main)) {
			$this->session->set_flashdata('error', $this->lang->line('product_type_not_null'));
			redirect('property_main/update?id=' . $id);
		}
		if (empty($status)) {
			$this->session->set_flashdata('error', $this->lang->line('required_status'));
			redirect('property_main/update?id=' . $id);
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
					"price" => $price_depreciation[$key]
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
			"name" => $name_property_main,
			"code" => $code_property_main,
			"properties" => $fields_properties,
			"depreciations" => $fields_depreciation,
			"parent_id" => $parent_id,
			"status" => $status,
			"updated_at" => $createdAt,
			"updated_by" => $this->userInfo['email'],
			"id" => $id,
			"price" => $price,
			// "type_login" => 1
		);
		// var_dump($data);die;

		$return = $this->api->apiPost($this->userInfo['token'], "property/update_property_main", $data);

		if (!empty($return->status) && $return->status == 200) {
			$this->session->set_flashdata('success', $this->lang->line('update_store_success'));
			redirect('property_main/listMainProperty');
		} else {
			$this->session->set_flashdata('error', $this->lang->line('update_store_failed'));
			redirect('property_main/update?id=' . $id);
		}

	}

	public function update()
	{
		$this->data["pageName"] = $this->lang->line('update_valuation');
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		$id = $this->security->xss_clean($id);
		$data = array(
			"id" => $id,
			// "type_login" => 1
		);

		$main_property = $this->api->apiPost($this->userInfo['token'], "property/get_property", $data);
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
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_all", $dataAll);
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$this->data['mainPropertyData'] = $mainPropertyData->data;
		} else {
			$this->data['mainPropertyData'] = array();
		}
		$data_dep = array(
			"parent_property_id" => $main_property->data->parent_id
		);
		$depreciationData = $this->api->apiPost($this->userInfo['token'], "property/get_depreciation", $data_dep);
		if (!empty($depreciationData->status) && $depreciationData->status == 200) {
			$this->data['depreciationData'] = $depreciationData->data;
		} else {
			$this->data['depreciationData'] = array();
		}
		$this->data['template'] = 'page/property/main/update';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function listMainProperty()
	{
		$this->data["pageName"] = $this->lang->line('manage_valuation');
		$data = array(// "type_login" => 1
		);
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_all", $data);
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$this->data['mainPropertyData'] = $mainPropertyData->data;
		} else {
			$this->data['mainPropertyData'] = array();
		}
		$this->data['template'] = 'page/property/main/list';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function createMainProperty()
	{
		$name_property_main = !empty($_POST['name_property_main']) ? $_POST['name_property_main'] : "";
		$code_property_main = !empty($_POST['code_property_main']) ? $_POST['code_property_main'] : "";
		$parent_property = !empty($_POST['parent_property']) ? $_POST['parent_property'] : "";
		$depreciation = !empty($_POST['depreciation']) ? $_POST['depreciation'] : array();
		$price_depreciation = !empty($_POST['price_depreciation']) ? $_POST['price_depreciation'] : array();
		$price = !empty($_POST['price']) ? $_POST['price'] : "";
		$properties = !empty($_POST['properties']) ? $_POST['properties'] : array();

		$name_property_main = $this->security->xss_clean($name_property_main);
		$code_property_main = $this->security->xss_clean($code_property_main);
		$parent_property = $this->security->xss_clean($parent_property);
		$depreciation = $this->security->xss_clean($depreciation);
		$price_depreciation = $this->security->xss_clean($price_depreciation);
		$price = $this->security->xss_clean($price);
		$properties = $this->security->xss_clean($properties);

		if (empty($name_property_main)) {
			$this->session->set_flashdata('error', $this->lang->line('required_type_valuation'));
			redirect('property_main/main_property');
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
					"price" => $price_depreciation[$key]
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
			"name" => $name_property_main,
			"code" => $code_property_main,
			"properties" => $fields_properties,
			"depreciations" => $fields_depreciation,
			"parent_id" => $parent_id,
			"status" => "active",
			"created_at" => $createdAt,
			"updated_by" => $this->userInfo['email'],
			"price" => $price,
			// "type_login" => 1
		);
		$return = $this->api->apiPost($this->userInfo['token'], "property/create_property", $data);
		if (!empty($return->status) && $return->status == 200) {
			$this->session->set_flashdata('success', $this->lang->line('create_valuation_success'));
			redirect('property_main/listMainProperty');
		} else {
			$this->session->set_flashdata('error', $return->message);
			// $this->session->set_flashdata('error', $this->lang->line('create_valuation_failed'));
			redirect('property_main/listMainProperty');
		}
	}

	public function getDepreciation()
	{
		$parent_property_id = !empty($_POST['parent_property_id']) ? $this->security->xss_clean($_POST['parent_property_id']) : "";
		$data = array(
			"parent_property_id" => $parent_property_id
		);
		$depreciationData = $this->api->apiPost($this->userInfo['token'], "property/get_depreciation", $data);
		// var_dump($depreciationData);die;
		if (!empty($depreciationData->status) && $depreciationData->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $depreciationData->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('required_depreciation_type')
			];
			echo json_encode($response);
			return;
		}
	}

	public function get_main_property()
	{
		$code = !empty($_GET['code']) ? $_GET['code'] : "";
		$code = $this->security->xss_clean($code);
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property_v2/get_main_property", ['code' => $code]);
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $mainPropertyData->data,
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

	public function get_property_by_main()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		$id = $this->security->xss_clean($id);
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property_v2/get_property_by_main_v2", ['id' => $id]);
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $mainPropertyData->data,
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

	public function get_property_child()
	{
		$model = !empty($_GET['model']) ? $_GET['model'] : "";
		$model = $this->security->xss_clean($model);
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property_v2/get_property_child", ['model' => $model]);
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $mainPropertyData->data,
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

	public function get_data_property_child()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		$id = $this->security->xss_clean($id);
		$data = $this->api->apiPost($this->userInfo['token'], "property_v2/get_data_property_child", ['id' => $id]);
		if (!empty($data->status) && $data->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $data->data,
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

	public function getPriceProperty_new()
	{
		$data = [];
		$data['type_loan'] = !empty($_POST['type_loan']) ? $_POST['type_loan'] : "";
		$data['code_type_property'] = !empty($_POST['code_type_property']) ? $_POST['code_type_property'] : "";
		$data['loan_product'] = !empty($_POST['loan_product']) ? $_POST['loan_product'] : "";
		$data['property_id'] = !empty($_POST['property_id']) ? $_POST['property_id'] : "";
		$data['depreciation_price'] = !empty($_POST['depreciation_price']) ? $_POST['depreciation_price'] : "";
		$data = $this->api->apiPost($this->userInfo['token'], "property_v2/getPriceProperty", $data);
		if (!empty($data->status) && $data->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $data->data,
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
}

?>

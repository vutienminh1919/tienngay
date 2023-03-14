<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Store extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->api = new Api();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model("store_model");
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
	}

	public function deleteStore()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_stores_selected_deletion')
			];
			echo json_encode($response);
			return;
		}
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		$data = array(
			"status" => 'block',
			"updated_at" => $createdAt,
			"updated_by" => $this->userInfo['email'],
			"id" => $id
		);
		$return = $this->api->apiPost($this->userInfo['token'], "store/update_store", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_property')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Property_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}

	public function doUpdateStore()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		$name_shop = !empty($_POST['name_shop']) ? $_POST['name_shop'] : "";
		$phone_shop = !empty($_POST['phone_shop']) ? $_POST['phone_shop'] : "";
		$phone_hotline = !empty($_POST['phone_hotline']) ? $_POST['phone_hotline'] : "";
		$province_shop = !empty($_POST['province_shop']) ? $_POST['province_shop'] : "";
		$district_shop = !empty($_POST['district_shop']) ? $_POST['district_shop'] : "";
		$province_id = !empty($_POST['province_id']) ? $_POST['province_id'] : "";
		$district_id = !empty($_POST['district_id']) ? $_POST['district_id'] : "";
		$address_shop = !empty($_POST['address_shop']) ? $_POST['address_shop'] : "";
		$representative = !empty($_POST['representative']) ? $_POST['representative'] : "";
		$investment = !empty($_POST['investment']) ? $_POST['investment'] : "";
		$code_address_store = !empty($_POST['code_address_store']) ? $_POST['code_address_store'] : "";
		$lat = !empty($_POST['lat']) ? $_POST['lat'] : "";
		$lng = !empty($_POST['lng']) ? $_POST['lng'] : "";
		$code_province_store = !empty($_POST['code_province_store']) ? $_POST['code_province_store'] : "";
		$type_pgd = !empty($_POST['type_pgd']) ? $_POST['type_pgd'] : "";
		$status = !empty($_POST['status']) ? $_POST['status'] : "";
		if (empty($name_shop)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Store_name_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($phone_shop)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Phone_number_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($province_shop)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('province_city_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($district_shop)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('District_must_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($address_shop)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Address_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($representative)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('representative_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($code_address_store)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('code_address_store_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($code_province_store)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('code_province_store_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($status)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('status_empty')
			];
			echo json_encode($response);
			return;
		}
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		$province = array(
			'id' => $province_id,
			"name" => $province_shop
		);
		$district = array(
			'id' => $district_id,
			"name" => $district_shop
		);

		if (!empty($address_shop)) {
			$address = $this->get_infor_from_address($address_shop);
			if(empty($lat))
			{
			$lat = $address->results[0]->geometry->location->lat;
		    }
		    if(empty($lng))
			{
			$lng = $address->results[0]->geometry->location->lng;
		    }
		}
	

		$data = array(
			"name" => $name_shop,
			"phone" => $phone_shop,
			"phone_hotline" => $phone_hotline,
			"province" => $province,
			"province_id" => $province_id,
			"district" => $district,
			"district_id" => $district_id,
			"address" => $address_shop,
			"representative" => $representative,
			"investment" => (int)$investment,
			"code_area" => $code_province_store,
			"code_address_store" => $code_address_store,
			"status" => $status,
			"type_pgd" => $type_pgd,
			"updated_by" => $this->userInfo['email'],
			"id" => $id,
			'location' => [
				'lat' => $lat,
				'lng' => $lng
			]

		);
		$return = $this->api->apiPost($this->userInfo['token'], "store/update_store", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successful_store_update')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('failed_store_update')
			];
			echo json_encode($response);
			return;
		}
	}

	public function update()
	{
		$this->data["pageName"] = $this->lang->line('update_store');
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		// get store by id
		$data = array(
			"id" => $id,
			// "type_login" => 1
		);
		$store = $this->api->apiPost($this->userInfo['token'], "store/get_store", $data);
		if (!empty($store->status) && $store->status == 200) {
			$this->data['store'] = $store->data;
		} else {
			$this->data['store'] = array();
		}
		if (empty($store->data)) {
			echo "404";
			die;
			redirect('404');
		}
		//get province
		$data_pro = array(// "type_login" => 1
		);
		$provinceData = $this->api->apiPost($this->userInfo['token'], "province/get_province", $data_pro);
		if (!empty($provinceData->status) && $provinceData->status == 200) {
			$this->data['provinceData'] = $provinceData->data;
		} else {
			$this->data['provinceData'] = array();
		}
		$areaData = $this->api->apiPost($this->userInfo['token'], "area/get_all", $data);
		if (!empty($areaData->status) && $areaData->status == 200) {
			$this->data['areaData'] = $areaData->data;
		} else {
			$this->data['areaData'] = array();
		}
		// get district
		if (!empty($store->data->province)) {
			$data_dis = array(
				// "type_login" => 1,
				"id" => $store->data->province_id,
			);
			$districtData = $this->api->apiPost($this->userInfo['token'], "province/get_district_by_province", $data_dis);
			if (!empty($districtData->status) && $districtData->status == 200) {
				$this->data['districtData'] = $districtData->data;
			} else {
				$this->data['districtData'] = array();
			}
		} else {
			$this->data['districtData'] = array();
		}
		$this->data['template'] = 'page/store/update_store';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function listStore()
	{
		$this->data["pageName"] = $this->lang->line('Store_manager');
		$data = array(// "type_login" => 1
		);
		$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all", $data);
		if (!empty($storeData->status) && $storeData->status == 200) {
			$this->data['storeData'] = $storeData->data;
		} else {
			$this->data['storeData'] = array();
		}
		$this->data['template'] = 'page/store/list_store';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function doAddStore()
	{
		$name_shop = !empty($_POST['name_shop']) ? $_POST['name_shop'] : "";
		$phone_shop = !empty($_POST['phone_shop']) ? $_POST['phone_shop'] : "";
		$phone_hotline = !empty($_POST['phone_hotline']) ? $_POST['phone_hotline'] : "";
		$province_shop = !empty($_POST['province_shop']) ? $_POST['province_shop'] : "";
		$district_shop = !empty($_POST['district_shop']) ? $_POST['district_shop'] : "";
		$province_id = !empty($_POST['province_id']) ? $_POST['province_id'] : "";
		$district_id = !empty($_POST['district_id']) ? $_POST['district_id'] : "";
		$address_shop = !empty($_POST['address_shop']) ? $_POST['address_shop'] : "";
		$representative = !empty($_POST['representative']) ? $_POST['representative'] : "";
		$investment = !empty($_POST['investment']) ? $_POST['investment'] : "";
		$code_address_store = !empty($_POST['code_address_store']) ? $_POST['code_address_store'] : "";
		$company = !empty($_POST['company']) ? $_POST['company'] : "";
		$code_province_store = !empty($_POST['code_province_store']) ? $_POST['code_province_store'] : "";
		$status = !empty($_POST['status']) ? $_POST['status'] : "";
		$type_pgd = !empty($_POST['type_pgd']) ? $_POST['type_pgd'] : "";
		$lat = !empty($_POST['lat']) ? $_POST['lat'] : "";
		$lng = !empty($_POST['lng']) ? $_POST['lng'] : "";
		if (empty($name_shop)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Store_name_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($phone_shop)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Phone_number_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($province_shop)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('province_city_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($district_shop)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('District_must_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($address_shop)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Address_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($representative)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('representative_empty')
			];
			echo json_encode($response);
			return;
		}

		if (empty($status)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('status_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($code_address_store)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('code_address_store_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($code_province_store)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('code_province_store_empty')
			];
			echo json_encode($response);
			return;
		}
		if (!empty($address_shop)) {
			$address = $this->get_infor_from_address($address_shop);
			if(empty($lat))
			{
			$lat = $address->results[0]->geometry->location->lat;
		    }
		    if(empty($lng))
			{
			$lng = $address->results[0]->geometry->location->lng;
		    }
		}
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		$data = array(
			"name" => $name_shop,
			"phone" => $phone_shop,
			"phone_hotline" => $phone_hotline,
			"province" => $province_shop,
			"province_id" => $province_id,
			"district" => $district_shop,
			"district_id" => $district_id,
			"address" => $address_shop,
			"representative" => $representative,
			"code_area" => $code_province_store,
			"company" => $company,
			"code_address_store" => $code_address_store,
			"investment" => (int)$investment,
			"status" => $status,
			"created_at" => $createdAt,
			"type_pgd" => $type_pgd,
			"updated_by" => $this->userInfo['email'],
			'location' => [
				'lat' => $lat,
				'lng' => $lng
			],
		);
	
		$return = $this->api->apiPost($this->userInfo['token'], "store/create_store", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('create_store_success')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('create_store_failed')
			];
			echo json_encode($response);
			return;
		}
	}

	public function createStore()
	{
		$this->data["pageName"] = $this->lang->line('create_store');
		$this->data['template'] = 'page/store/addnew_store';
		//get province
		$data = array(// "type_login" => 1
		);
		$provinceData = $this->api->apiPost($this->userInfo['token'], "province/get_province", $data);
		if (!empty($provinceData->status) && $provinceData->status == 200) {
			$this->data['provinceData'] = $provinceData->data;
		} else {
			$this->data['provinceData'] = array();
		}
		$areaData = $this->api->apiPost($this->userInfo['token'], "area/get_all", $data);
		if (!empty($areaData->status) && $areaData->status == 200) {
			$this->data['areaData'] = $areaData->data;
		} else {
			$this->data['areaData'] = array();
		}
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function get_district_by_province()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";

		$data = array(
			// "type_login" => 1,
			"id" => $id
		);

		$districtData = $this->api->apiPost($this->userInfo['token'], "province/get_district_by_province", $data);
		if (!empty($districtData->status) && $districtData->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $districtData->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('no_depreciation_configured')
			];
			echo json_encode($response);
			return;
		}
	}

	public function get_ward_by_district()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		$data = array(
			// "type_login" => 1,
			"id" => $id
		);
		$wardData = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", $data);
		if (!empty($wardData->status) && $wardData->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $wardData->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('no_depreciation_configured')
			];
			echo json_encode($response);
			return;
		}
	}
	private function get_infor_from_address($address = null)
	{
		$apiKey = 'AIzaSyDU6vwuTA_eC2NKb0IuDJpa2XmrypkTSvA';
		$addressnew = str_replace(', ', ' ', $address);
		$prepAddr = str_replace(' ', '+', $this->stripUnicode($addressnew));
		$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false&key=' . $apiKey . '');
		$output = json_decode($geocode);
		return $output;
	}

	private function stripUnicode($str)
	{
		if (!$str) return false;
		$unicode = array(
			'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
			'd' => 'đ|Đ',
			'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
			'i' => 'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
			'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
			'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
			'y' => 'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ'
		);
		foreach ($unicode as $nonUnicode => $uni) $str = preg_replace("/($uni)/i", $nonUnicode, $str);
		return $str;
	}
		public function getStore_by_code_area()
	{

		$code_area = !empty($_POST['code_area']) ? $_POST['code_area'] : "";
		$data = array(
			"code_area" => $code_area,
			

		);
		$return = $this->api->apiPost($this->userInfo['token'], "store/get_store_by_code_area", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => "Thành công",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => (isset($return->message)) ? $return->message : 'Thất bại!'
			];
			echo json_encode($response);
			return;
		}
	}

	public function updateUserStore(){

		$data = $this->input->post();
		$data['field'] = $this->security->xss_clean($data['field']);
		$data['value'] = $this->security->xss_clean($data['value']);
		$data['id'] = $this->security->xss_clean($data['id']);

		$condition = array(
			'id' => $data['id'],
			$data['field'] => $data['value'],
		);

		$this->api->apiPost($this->user['token'], "store/updateUserStore", $condition);


	}
}

?>

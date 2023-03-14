<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');

class Coupon extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->api = new Api();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model("time_model");
		$this->load->library('pagination');
		$this->load->helper('lead_helper');
		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
		// if (!$this->is_superadmin) {
		// 	$paramController = $this->uri->segment(1);
		// 	$param = strtolower($paramController);
		// 	if (!in_array($param, $this->paramMenus)) {
		// 		$this->session->set_flashdata('error', $this->lang->line('not_have_permission') . ' ' . $paramController . '!');
		// 		redirect(base_url('app'));
		// 		return;
		// 	}
		// }
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	public function deleteCoupon()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_coupon_selected_deletion')
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
		$return = $this->api->apiPost($this->userInfo['token'], "coupon/update_coupon", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_coupon')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Coupon_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}

	public function doUpdateStatusCoupon()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$status = ($status == 'true') ? 'active' : 'deactive';
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_coupon_selected_deletion')
			];
			echo json_encode($response);
			return;
		}
		if (empty($status)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_coupon_selected_deletion')
			];
			echo json_encode($response);
			return;
		}
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		$data = array(
			"status" => $status,
			"updated_at" => $createdAt,
			"updated_by" => $this->userInfo['email'],
			"id" => $id
		);
		$return = $this->api->apiPost($this->userInfo['token'], "coupon/update_coupon", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_coupon')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Coupon_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}

	public function doUpdateCoupon()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		$title_vi = !empty($_POST['title_vi']) ? $_POST['title_vi'] : "";
		$content_vi = !empty($_POST['content_vi']) ? $_POST['content_vi'] : "";
		$title_en = !empty($_POST['title_en']) ? $_POST['title_en'] : "";
		$content_en = !empty($_POST['content_en']) ? $_POST['content_en'] : "";
		$type = !empty($_POST['type_coupon']) ? $_POST['type_coupon'] : "";
		$status = !empty($_POST['status']) ? $_POST['status'] : "";

		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		if (empty($title_vi)) {

			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Coupon_title_empty')
			];
			echo json_encode($response);
			return;
		}

		if (empty($content_vi)) {

			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Coupon_content_empty')
			];
			echo json_encode($response);
			return;
		}
		$data = array(
			"title_vi" => $title_vi,
			"link" => slugify($title_vi),
			"content_vi" => $content_vi,
			"title_en" => $title_en,
			"content_en" => $content_en,
			"type_coupon" => $type,
			"status" => $status,
			"updated_at" => $updateAt,
			"updated_by" => $this->userInfo['email'],
			"id" => $id

		);
		$return = $this->api->apiPost($this->userInfo['token'], "coupon/update_coupon", $data);
		// die;
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successful_coupon_update')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Failed_coupon_update'),
				'data' => $image
			];
			echo json_encode($response);
			return;
		}
	}

	public function update()
	{
		$this->data["pageName"] = $this->lang->line('update_coupon');
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		// get coupon by id
		$data = array(
			"id" => $id,
		);
		$coupon = $this->api->apiPost($this->userInfo['token'], "coupon/get_coupon", $data);
		if (!empty($coupon->status) && $coupon->status == 200) {
			$this->data['coupon'] = $coupon->data;
		} else {
			$this->data['coupon'] = array();
		}
		$provinceData = $this->api->apiPost($this->userInfo['token'], "province/get_province", $data);
		if (!empty($provinceData->status) && $provinceData->status == 200) {
			$this->data['provinceData'] = $provinceData->data;
		} else {
			$this->data['provinceData'] = array();
		}
		//get hình thức vay
		$configuration_formality = $this->api->apiPost($this->userInfo['token'], "configuration_formality/get_configuration_formality");
		if (!empty($configuration_formality->status) && $configuration_formality->status == 200) {
			$this->data['configuration_formality'] = $configuration_formality->data;
		} else {
			$this->data['configuration_formality'] = array();
		}
		//get property main ( tài sản cấp cao nhất parenid == null)
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main");
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$this->data['mainPropertyData'] = $mainPropertyData->data;
		} else {
			$this->data['mainPropertyData'] = array();
		}
		$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all", array());
		if (!empty($storeData->status) && $storeData->status == 200) {
			$this->data['storeData'] = $storeData->data;
		} else {
			$this->data['storeData'] = array();
		}
		if (empty($coupon->data)) {
			echo "404";
			die;
			redirect('404');
		}
		$areaData = $this->api->apiPost($this->userInfo['token'], "area/get_all", $data);
		if (!empty($areaData->status) && $areaData->status == 200) {
			$this->data['areaData'] = $areaData->data;
		} else {
			$this->data['areaData'] = array();
		}
		$this->data['template'] = 'page/coupon/form_coupon';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function listCoupon()
	{
		$this->data["pageName"] = $this->lang->line('Coupon_manager');
		$data = array(// "type_login" => 1
		);

		$couponData = $this->api->apiPost($this->userInfo['token'], "coupon/get_all", $data);
		if (!empty($couponData->status) && $couponData->status == 200) {
			$this->data['couponData'] = $couponData->data;
		} else {
			$this->data['couponData'] = array();
		}
		$this->data['template'] = 'page/coupon/list_coupon';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
//		echo "<pre>";
//		var_dump($this->data);
//		echo "</pre>";
	}

	public function getCoupon()
	{


		$type_property = !empty($_POST['type_property']) ? $_POST['type_property'] : "";
		$number_day_loan = !empty($_POST['number_day_loan']) ? $_POST['number_day_loan'] : "";
		$type_loan = !empty($_POST['type_loan']) ? $_POST['type_loan'] : "";
		$loan_product = !empty($_POST['loan_product']) ? $_POST['loan_product'] : "";
		$store_id = !empty($_POST['store_id']) ? $_POST['store_id'] : "";
		$created_at = !empty($_POST['created_at']) ? $_POST['created_at'] : "";

		$data = array(
			"loan_product" => $loan_product,
			"store_id" => $store_id,
			"type_loan" => $type_loan,
			"number_day_loan" => $number_day_loan,
			"type_property" => $type_property,
			"created_at" => $created_at

		);

		$return = $this->api->apiPost($this->userInfo['token'], "coupon/get_all_home", $data);

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

	public function doAddCoupon()
	{


		$code = !empty($_POST['code']) ? $_POST['code'] : "";
		$start_date = !empty($_POST['start_date']) ? $_POST['start_date'] : "";
		$end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : "";
		$event = !empty($_POST['event']) ? $_POST['event'] : "";
		$note = !empty($_POST['note']) ? $_POST['note'] : "";
		$percent_interest_customer = !empty($_POST['percent_interest_customer']) ? $_POST['percent_interest_customer'] : "";
		$percent_advisory = !empty($_POST['percent_advisory']) ? $_POST['percent_advisory'] : "";
		$percent_expertise = !empty($_POST['percent_expertise']) ? $_POST['percent_expertise'] : "";
		$penalty_percent = !empty($_POST['penalty_percent']) ? $_POST['penalty_percent'] : "";
		$penalty_amount = !empty($_POST['penalty_amount']) ? $_POST['penalty_amount'] : "";
		$extend = !empty($_POST['extend']) ? $_POST['extend'] : "";
		$loan_product = !empty($_POST['loan_product']) ? $_POST['loan_product'] : "";
		$status = !empty($_POST['status']) ? $_POST['status'] : "";
		$reduction_interest = !empty($_POST['reduction_interest']) ? $_POST['reduction_interest'] : "";
		$down_interest_on_month = !empty($_POST['down_interest_on_month']) ? $_POST['down_interest_on_month'] : "";
		$set_by_coupon = !empty($_POST['set_by_coupon']) ? $_POST['set_by_coupon'] : "";
		$chon_tu_dong = !empty($_POST['chon_tu_dong']) ? $_POST['chon_tu_dong'] : "";


		$percent_prepay_phase_1 = !empty($_POST['percent_prepay_phase_1']) ? $_POST['percent_prepay_phase_1'] : "";
		$percent_prepay_phase_2 = !empty($_POST['percent_prepay_phase_2']) ? $_POST['percent_prepay_phase_2'] : "";
		$percent_prepay_phase_3 = !empty($_POST['percent_prepay_phase_3']) ? $_POST['percent_prepay_phase_3'] : "";
		$id_coupon = !empty($_POST['id_coupon']) ? $_POST['id_coupon'] : "";
		$number_day_loan = !empty($_POST['number_day_loan']) ? $_POST['number_day_loan'] : "";
		$type_property = !empty($_POST['type_property']) ? $_POST['type_property'] : "";
		$selectize_province = !empty($_POST['selectize_province']) ? $_POST['selectize_province'] : "";
		$code_store = !empty($_POST['code_store']) ? $_POST['code_store'] : "";
		$type_loan = !empty($_POST['type_loan']) ? $_POST['type_loan'] : "";
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		$code_area = !empty($_POST['code_area']) ? $_POST['code_area'] : "";

		if (empty($code)) {

			$response = [
				'res' => false,
				'status' => "400",
				'message' => 'Bạn cần nhập mã Coupon'
			];
			echo json_encode($response);
			return;
		}

		if (empty($start_date) || empty($end_date)) {

			$response = [
				'res' => false,
				'status' => "400",
				'message' => 'Bạn cần nhập ngày bắt đầu và ngày kết thúc'
			];
			echo json_encode($response);
			return;
		}
		if (empty($event) || empty($note)) {

			$response = [
				'res' => false,
				'status' => "400",
				'message' => 'Bạn cần nhập sự kiện và ghi chú'
			];
			echo json_encode($response);
			return;
		}
		$data = array(
			"code" => slugify($code),
			"start_date" => $start_date,
			"end_date" => $end_date,
			"event" => $event,
			"note" => $note,
			"percent_interest_customer" => $percent_interest_customer,
			"percent_advisory" => $percent_advisory,
			"percent_expertise" => $percent_expertise,
			"penalty_percent" => $penalty_percent,
			"penalty_amount" => $penalty_amount,
			"extend" => $extend,
			"percent_prepay_phase_1" => $percent_prepay_phase_1,
			"percent_prepay_phase_2" => $percent_prepay_phase_2,
			"percent_prepay_phase_3" => $percent_prepay_phase_3,
			"id" => $id_coupon,
			"type_loan" => $type_loan,
			"loan_product" => explode(",", $loan_product),
			"number_day_loan" => explode(",", $number_day_loan),
			"type_property" => $type_property,
			"selectize_province" => $selectize_province,
			"code_store" => $code_store,
			"status" => $status,
			"is_reduction_interest" => $reduction_interest,
			"down_interest_on_month" => $down_interest_on_month,
			"set_by_coupon" => $set_by_coupon,
			"chon_tu_dong" => $chon_tu_dong,
			"code_area" => explode(",", $code_area)

		);

		$return = $this->api->apiPost($this->userInfo['token'], "coupon/create_coupon", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => "Thành công"
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

	public function createCoupon()
	{
		$this->data["pageName"] = $this->lang->line('create_coupon');
		$this->data['template'] = 'page/coupon/form_coupon';

		$provinceData = $this->api->apiPost($this->userInfo['token'], "province/get_province", $data);
		if (!empty($provinceData->status) && $provinceData->status == 200) {
			$this->data['provinceData'] = $provinceData->data;
		} else {
			$this->data['provinceData'] = array();
		}
		//get hình thức vay
		$configuration_formality = $this->api->apiPost($this->userInfo['token'], "configuration_formality/get_configuration_formality");
		if (!empty($configuration_formality->status) && $configuration_formality->status == 200) {
			$this->data['configuration_formality'] = $configuration_formality->data;
		} else {
			$this->data['configuration_formality'] = array();
		}
		//get property main ( tài sản cấp cao nhất parenid == null)
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main");
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$this->data['mainPropertyData'] = $mainPropertyData->data;
		} else {
			$this->data['mainPropertyData'] = array();
		}
		$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all", array());
		if (!empty($storeData->status) && $storeData->status == 200) {
			$this->data['storeData'] = $storeData->data;
		} else {
			$this->data['storeData'] = array();
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
}


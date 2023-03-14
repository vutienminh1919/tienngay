<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
class Coupon_cash extends MY_Controller
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
	
			date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	public function deleteCoupon_cash()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => 'Thông tin trống'
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
		$return = $this->api->apiPost($this->userInfo['token'], "coupon_cash/update_coupon_cash", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => 'Thành công'
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => 'Thất bại'
			];
			echo json_encode($response);
			return;
		}
	}
    public function doUpdateStatusCoupon_cash()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$status = ($status=='true') ? 'active' : 'deactive';
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => 'Thông tin id trống'
			];
			echo json_encode($response);
			return;
		}
			if (empty($status)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => 'Thông tin status trống'
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
		$return = $this->api->apiPost($this->userInfo['token'], "coupon_cash/update_coupon_cash", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => 'Thành công'
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => 'Thất bại'
			];
			echo json_encode($response);
			return;
		}
	}
	

	public function update()
	{
		$this->data["pageName"] = $this->lang->line('update_coupon_cash');
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		// get coupon_cash by id
		$data = array(
			"id" => $id,
		);
		$coupon_cash = $this->api->apiPost($this->userInfo['token'], "coupon_cash/get_coupon_cash_by_id", $data);
		if (!empty($coupon_cash->status) && $coupon_cash->status == 200) {
			$this->data['coupon_cash'] = $coupon_cash->data;
		} else {
			$this->data['coupon_cash'] = array();
		}
		
             $storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all", array());
            if(!empty($storeData->status) && $storeData->status == 200){
                $this->data['storeData'] = $storeData->data;
            }else{
                $this->data['storeData'] = array();
            }
		if (empty($coupon_cash->data)) {
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
		$this->data['template'] = 'page/coupon_cash/form_coupon_cash';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function listCoupon_cash()
	{
		$this->data["pageName"] = 'Quản lý coupon HĐ bán';
		$data = array(
		);

		$coupon_cashData = $this->api->apiPost($this->userInfo['token'], "coupon_cash/get_all", $data);
		if (!empty($coupon_cashData->status) && $coupon_cashData->status == 200) {
			$this->data['coupon_cashData'] = $coupon_cashData->data;
		} else {
			$this->data['coupon_cashData'] = array();
		}
		$this->data['template'] = 'page/coupon_cash/list_coupon_cash';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}
    	public function getCoupon_cash()
	{
		
      
		$bh_product = !empty($_POST['bh_product']) ? $_POST['bh_product'] : "";
		$store_id = !empty($_POST['store_id']) ? $_POST['store_id'] : "";
		$created_at = !empty($_POST['created_at']) ? $_POST['created_at'] : "";
		
		$data = array(
			"bh_product" => $bh_product,
			"store_id" => $store_id,
			"created_at"=>$created_at

		);
       
		$return = $this->api->apiPost($this->userInfo['token'], "coupon_cash/get_all_home", $data);
		
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
	public function doAddCoupon_cash()
	{
		
		
		$code = !empty($_POST['code']) ? $_POST['code'] : "";
		$start_date = !empty($_POST['start_date']) ? $_POST['start_date'] : "";
		$end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : "";
		$note = !empty($_POST['note']) ? $_POST['note'] : "";
		$bh_product = !empty($_POST['bh_product']) ? $_POST['bh_product'] : "";
		$status = !empty($_POST['status']) ? $_POST['status'] : "";
		$id_coupon_cash = !empty($_POST['id_coupon_cash']) ? $_POST['id_coupon_cash'] : "";
		$code_store = !empty($_POST['code_store']) ? $_POST['code_store'] : "";
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		$code_area = !empty($_POST['code_area']) ? $_POST['code_area'] : "";
		$percent_reduction = !empty($_POST['percent_reduction']) ? (int)$_POST['percent_reduction'] : "";
		$loai_khach = !empty($_POST['loai_khach']) ? $_POST['loai_khach'] : "";
			if (empty($start_date) || empty($start_date) ) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => 'Bạn cần nhập ngày bắt đầu và ngày kết thúc'
			];
			echo json_encode($response);
			return;
		}
		if (strtotime($start_date)>strtotime($end_date) ) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => ' Ngày bắt đầu < ngày kết thúc'
			];
			echo json_encode($response);
			return;
		}
		if (empty($code)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => 'Bạn cần nhập mã Coupon_cash'
			];
			echo json_encode($response);
			return;
		}
		if (empty($percent_reduction)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => 'Bạn cần nhập phí giảm'
			];
			echo json_encode($response);
			return;
		}
		if (!is_integer($percent_reduction)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => '% Phí giảm phải là số nguyên'
			];
			echo json_encode($response);
			return;
		}
		if ($percent_reduction>=100 || $percent_reduction<=0) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => '% Phí giảm trừ trong khoảng: 1<=% bảo hiểm khoản vay <100'
			];
			echo json_encode($response);
			return;
		}
		
	
		
		if( empty($note) ) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => 'Bạn cần nhập Mô tả chi tiết'
			];
			echo json_encode($response);
			return;
		}
		$data = array(
			"code" => slugify($code),
			"start_date" =>$start_date,
			"end_date" => $end_date,
			"note" => $note,
			"id" => $id_coupon_cash,
			"bh_product" => explode(",",$bh_product),
			"loai_khach" => explode(",",$loai_khach),
			"code_store" => $code_store,
			"status" => $status,
			"percent_reduction" => $percent_reduction,
			"code_area" => explode(",", $code_area)

		);
       
		$return = $this->api->apiPost($this->userInfo['token'], "coupon_cash/create_coupon_cash", $data);
		
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

	public function createCoupon_cash()
	{
		$this->data["pageName"] = $this->lang->line('create_coupon_cash');
		$this->data['template'] = 'page/coupon_cash/form_coupon_cash';
		
		
       $storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all", array());
            if(!empty($storeData->status) && $storeData->status == 200){
                $this->data['storeData'] = $storeData->data;
            }else{
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


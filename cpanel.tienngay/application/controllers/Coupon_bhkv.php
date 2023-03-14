<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
class Coupon_bhkv extends MY_Controller
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

	public function deleteCoupon_bhkv()
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
		$return = $this->api->apiPost($this->userInfo['token'], "coupon_bhkv/update_coupon_bhkv", $data);
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
    public function doUpdateStatusCoupon_bhkv()
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
		$return = $this->api->apiPost($this->userInfo['token'], "coupon_bhkv/update_coupon_bhkv", $data);
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
		$this->data["pageName"] = $this->lang->line('update_coupon_bhkv');
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		// get coupon_bhkv by id
		$data = array(
			"id" => $id,
		);
		$coupon_bhkv = $this->api->apiPost($this->userInfo['token'], "coupon_bhkv/get_coupon_bhkv", $data);
		if (!empty($coupon_bhkv->status) && $coupon_bhkv->status == 200) {
			$this->data['coupon_bhkv'] = $coupon_bhkv->data;
		} else {
			$this->data['coupon_bhkv'] = array();
		}
		$provinceData = $this->api->apiPost($this->userInfo['token'], "province/get_province", $data);
        if(!empty($provinceData->status) && $provinceData->status == 200){
            $this->data['provinceData'] = $provinceData->data;
        }else{
            $this->data['provinceData'] = array();
        }
          //get hình thức vay
            $configuration_formality = $this->api->apiPost($this->userInfo['token'], "configuration_formality/get_configuration_formality");
            if(!empty($configuration_formality->status) && $configuration_formality->status == 200){
                $this->data['configuration_formality'] = $configuration_formality->data;
            }else{
                $this->data['configuration_formality'] = array();
            }
            //get property main ( tài sản cấp cao nhất parenid == null)
            $mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main");
            if(!empty($mainPropertyData->status) && $mainPropertyData->status == 200){
                $this->data['mainPropertyData'] = $mainPropertyData->data;
            }else{
                $this->data['mainPropertyData'] = array();
            }
             $storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all", array());
            if(!empty($storeData->status) && $storeData->status == 200){
                $this->data['storeData'] = $storeData->data;
            }else{
                $this->data['storeData'] = array();
            }
		if (empty($coupon_bhkv->data)) {
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
		$this->data['template'] = 'page/coupon_bhkv/form_coupon_bhkv';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function listCoupon_bhkv()
	{
		$this->data["pageName"] = 'Quản lý coupon BHKV';
		$data = array(
		);

		$coupon_bhkvData = $this->api->apiPost($this->userInfo['token'], "coupon_bhkv/get_all", $data);
		if (!empty($coupon_bhkvData->status) && $coupon_bhkvData->status == 200) {
			$this->data['coupon_bhkvData'] = $coupon_bhkvData->data;
		} else {
			$this->data['coupon_bhkvData'] = array();
		}
		$this->data['template'] = 'page/coupon_bhkv/list_coupon_bhkv';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}
    	public function getCoupon_bhkv()
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
			"created_at"=>$created_at

		);
       
		$return = $this->api->apiPost($this->userInfo['token'], "coupon_bhkv/get_all_home", $data);
		
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
	public function doAddCoupon_bhkv()
	{
		
		
		$code = !empty($_POST['code']) ? $_POST['code'] : "";
		$start_date = !empty($_POST['start_date']) ? $_POST['start_date'] : "";
		$end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : "";
		$note = !empty($_POST['note']) ? $_POST['note'] : "";
		$loan_product = !empty($_POST['loan_product']) ? $_POST['loan_product'] : "";
		$status = !empty($_POST['status']) ? $_POST['status'] : "";
		$id_coupon_bhkv = !empty($_POST['id_coupon_bhkv']) ? $_POST['id_coupon_bhkv'] : "";
        $number_day_loan = !empty($_POST['number_day_loan']) ? $_POST['number_day_loan'] : "";
		$type_property = !empty($_POST['type_property']) ? $_POST['type_property'] : "";
		$code_store = !empty($_POST['code_store']) ? $_POST['code_store'] : "";
		$type_loan = !empty($_POST['type_loan']) ? $_POST['type_loan'] : "";
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		$code_area = !empty($_POST['code_area']) ? $_POST['code_area'] : "";
		$start_money = !empty($_POST['start_money']) ? (int)$_POST['start_money'] : 0;
		$end_money = !empty($_POST['end_money']) ? (int)$_POST['end_money'] : 0;
		$percent_reduction = !empty($_POST['percent_reduction']) ? (int)$_POST['percent_reduction'] : "";
		$type_coupon = !empty($_POST['type_coupon']) ? $_POST['type_coupon'] : 1;
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
				'message' => ' Ngày bắt đầu > ngày kết thúc'
			];
			echo json_encode($response);
			return;
		}
		if ($start_money>$end_money && $end_money>0) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => ' Khoản vay áp dụng từ > Khoản vay áp dụng đến'
			];
			echo json_encode($response);
			return;
		}



		if (empty($code)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => 'Bạn cần nhập mã Coupon_bhkv'
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
			"id" => $id_coupon_bhkv,
			"type_loan" =>explode(",",$type_loan),
			"loan_product" => explode(",",$loan_product),
			"number_day_loan" => explode(",", $number_day_loan),
			"type_property" => explode(",", $type_property),
			"selectize_province" => $selectize_province,
			"code_store" => $code_store,
			"status" => $status,
			"start_money" => $start_money,
			"end_money" => $end_money,
			"percent_reduction" => $percent_reduction,
			"type_coupon" => $type_coupon,
			"code_area" => explode(",", $code_area)

		);
       
		$return = $this->api->apiPost($this->userInfo['token'], "coupon_bhkv/create_coupon_bhkv", $data);
		
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

	public function createCoupon_bhkv()
	{
		$this->data["pageName"] = $this->lang->line('create_coupon_bhkv');
		$this->data['template'] = 'page/coupon_bhkv/form_coupon_bhkv';
		
		 $provinceData = $this->api->apiPost($this->userInfo['token'], "province/get_province", $data);
        if(!empty($provinceData->status) && $provinceData->status == 200){
            $this->data['provinceData'] = $provinceData->data;
        }else{
            $this->data['provinceData'] = array();
        }
          //get hình thức vay
            $configuration_formality = $this->api->apiPost($this->userInfo['token'], "configuration_formality/get_configuration_formality");
            if(!empty($configuration_formality->status) && $configuration_formality->status == 200){
                $this->data['configuration_formality'] = $configuration_formality->data;
            }else{
                $this->data['configuration_formality'] = array();
            }
            //get property main ( tài sản cấp cao nhất parenid == null)
            $mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main");
            if(!empty($mainPropertyData->status) && $mainPropertyData->status == 200){
                $this->data['mainPropertyData'] = $mainPropertyData->data;
            }else{
                $this->data['mainPropertyData'] = array();
            }
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


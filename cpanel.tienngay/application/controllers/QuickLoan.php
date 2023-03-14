<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// include APPPATH.'/libraries/Api.php';
class QuickLoan extends MY_Controller{
	public function __construct(){
		parent::__construct();
		// $this->api = new Api();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url','file'));
		$this->load->model("main_property_model");
		$this->load->model('config_gic_model');
		$this->load->model("time_model");
		$this->load->library('pagination');
		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
		if (!$this->is_superadmin) {
			$paramController = $this->uri->segment(1);
			$param = strtolower($paramController);
			if (!in_array($param, $this->paramMenus)) {
				$this->session->set_flashdata('error', $this->lang->line('not_have_permission').' '.$paramController .'!');
				redirect(base_url('app'));
				return;
			}
		}
	}

	public function imageResize($imageResourceId,$width,$height) {
		$targetWidth =200;
		$targetHeight =200;
		$targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);
		imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight, $width,$height);


		return $targetLayer;
	}

	public function upload_img_contract(){
		if($_FILES['file']['size'] > 20000000) {
			$response = array(
				'code' => 201,
				'msg' => 'Kích cỡ max là 10MB'
			);
			return $this->pushJson('200', json_encode($response));
		}
		$acceptFormat = array("jpeg", "png", "jpg", "mp3", "mp4", "image/jpeg", "image/png", "image/jpg");
		if(in_array($_FILES['file']['type'], $acceptFormat) == FALSE) {
			$response = array(
				'code' => 201,
				'msg' => 'Định dạng không cho phép',
				'type' => $_FILES['file']['type']
			);
			return $this->pushJson('200', json_encode($response));
		}

		$this->load->library('upload');
		$config['upload_path']  = './uploads/contract';
		$config['allowed_types']        = '*';
		//$config['allowed_types']        = 'gif|jpg|png|jpeg|mp3|mp4|';
		// $config['allowed_types']  = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
		$config['max_size']             = 10000;
		$config['overwrite']            = TRUE;
		$config['file_name'] = time().'-'.md5(time());
		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('file')){
			$error = array('error' => $this->upload->display_errors());
			$response = array(
				'code' => 201,
				'msg' => $error
			);
			return $this->pushJson('200', json_encode($response));
		}else{
			try {
				$data = array( 'timestamp' => $this->time_model->getTimeUTC(),'upload_data' => $this->upload->data());
				$file_name = str_replace(".","",$config['upload_path'])."/".$data['upload_data']['file_name'];
				$random = sha1(substr(md5(rand()), 0, 8));
				$response = array(
					'code' => 200,
					"msg"=>"success",
					'path' => $file_name,
					'key' => $random,
					'raw_name' => $_FILES['file']['name']
				);
				$push = json_encode($response);
				return $this->pushJson(200, $push);
			}
			catch (Exception $e) {
				$e->getMessage();
			}
		}
	}







	public function upload_img(){
		// $data = $this->input->post();
		if($_FILES['file']['size'] > 20000000) {
			return $this->pushJson('200', json_encode(array(
				'code' => '201',
				'msg' => 'Kích cỡ max là 10MB'
			)));
		}
		$acceptFormat = array("jpeg", "png", "jpg", "mp3", "mp4");
		if(in_array($_FILES['file']['type'], $acceptFormat)) {
			return $this->pushJson('200', json_encode(array(
				'code' => '201',
				'msg' => 'Định dạng không cho phép',
				'type' => $_FILES['file']['type']
			)));
		}
		$serviceUpload = $this->config->item("url_service_upload");
		// $curlFile  = new CURLFile($_FILES["avatar"]["tmp_name"],$_FILES["avatar"]["type"],$_FILES["avatar"]["name"]);
		$cfile = new CURLFile($_FILES['file']["tmp_name"],$_FILES['file']["type"],$_FILES['file']["name"]);
		$post = array('avatar'=> $cfile );
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$serviceUpload);
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec ($ch);
		curl_close ($ch);
		$result1 = json_decode($result);

		$random = sha1(substr(md5(rand()), 0, 8));

		$response = array(
			'code' => 200,
			"msg"=>"success",
			'path' => $result1->path,
			'key' => $random,
			'raw_name' => $_FILES['file']['name']
		);
		$push = json_encode($response);
		return $this->pushJson(200, $push);
	}

	public function doUploadContract(){
		$data = $this->input->post();
		$data['contractId'] = $this->security->xss_clean($data['contractId']);
		$data['identify'] = $this->security->xss_clean($data['identify']);
		$data['household'] = $this->security->xss_clean($data['household']);
		$data['driver_license'] = $this->security->xss_clean($data['driver_license']);
		$data['vehicle'] = $this->security->xss_clean($data['vehicle']);
		$data['agree'] = $this->security->xss_clean($data['agree']);
		$image_accurecy = array(
			"identify" =>  $data['identify'],
			"household" =>  $data['household'],
			"driver_license" =>  $data['driver_license'],
			"vehicle" =>  $data['vehicle'],
			"agree" =>  $data['agree'],
		);
		$dataPost = array(
			"id" => $data['contractId'],
			"image_accurecy" => $image_accurecy,
		);
		$result = $this->api->apiPost($this->userInfo['token'], "contract/upload_image_contract", $dataPost);
		$this->pushJson('200', json_encode(array("code" => "200", "data" => $result)));

	}

	// private $createdAt;
	public function approveContract(){
		$data = $this->input->post();
		$data['note'] = $this->security->xss_clean($data['note']);
		$data['status'] = $this->security->xss_clean($data['status']);
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['amount_money'] = $this->security->xss_clean($data['amount_money']);
		$data['amount_loan'] = $this->security->xss_clean($data['amount_loan']);
		$data['amount_GIC'] = $this->security->xss_clean($data['amount_GIC']);
		$dataPost = array(
			"note" => $data['note'],
			"status" => $data['status'],
			"contract_id" => $data['id'],
			"amount_money" => $data['amount_money'],
			"amount_loan" => $data['amount_loan'],
			"amount_GIC" => $data['amount_GIC'],
		);
		$result = $this->api->apiPost($this->userInfo['token'], "contract/approve", $dataPost);
		if(empty($result->status)){
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => "approve error" , "data"=>$result)));
			return;
		}
		if(!empty($result->status) && $result->status == 200){
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $result->message,  "data"=>$result)));
			return;
		}
		if(!empty($result->status) && $result->status == 401){
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $result->message, "data"=>$result)));
			return;
		}
	}

	public function approveContractForQuickLoan(){
		$data = $this->input->post();
		$data['note'] = $this->security->xss_clean($data['note']);
		$data['status'] = $this->security->xss_clean($data['status']);
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['amount_money'] = $this->security->xss_clean($data['amount_money']);
		$data['amount_loan'] = $this->security->xss_clean($data['amount_loan']);
		$data['amount_GIC'] = $this->security->xss_clean($data['amount_GIC']);
		$dataPost = array(
			"note" => $data['note'],
			"status" => $data['status'],
			"contract_id" => $data['id'],
			"amount_money" => $data['amount_money'],
			"amount_loan" => $data['amount_loan'],
			"amount_GIC" => $data['amount_GIC'],
		);
		$result = $this->api->apiPost($this->userInfo['token'], "contract/approve_for_quickloan", $dataPost);
		if(empty($result->status)){
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => "approve error" , "data"=>$result)));
			return;
		}
		if(!empty($result->status) && $result->status == 200){
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => "Approve success",  "data"=>$result)));
			return;
		}
		if(!empty($result->status) && $result->status == 401){
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $result->message, "data"=>$result)));
			return;
		}
	}

	public function doUploadImage(){
		$data = $this->input->post();
		$data['type_img'] = $this->security->xss_clean($data['type_img']);
		$data['contract_id'] = $this->security->xss_clean($data['contract_id']);
		$dataPost = array(
			"id" => $data['contract_id'],
			"type_img" => $data['type_img'],
			"file" => $_FILES['file']
		);
		$result = $this->api->apiPost($this->userInfo['token'], "contract/upload_image", $dataPost);
		// echo $result; return;
		$this->pushJson('200', json_encode(array("code" => "200", "data" => $result)));
	}

	public function deleteImage(){
		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['type_img'] = $this->security->xss_clean($data['type_img']);
		$data['key'] = $this->security->xss_clean($data['key']);
		$dataPost = array(
			"id" => $data['id'],
			"type_img" => $data['type_img'],
			"key" => $data['key']
		);
		$result = $this->api->apiPost($this->userInfo['token'], "contract/delete_image", $dataPost);
		$this->pushJson('200', json_encode(array("code" => "200", "data" => $result)));
	}

	public function uploadsImageAccuracy(){
		$this->data["pageName"] = $this->lang->line('update_img_authentication');
		$this->data['template'] = 'page/pawn/upload_img';
		$dataGet = $this->input->get();
		$dataGet['id'] = $this->security->xss_clean($dataGet['id']);
		$dataPost = array(
			"id" => $dataGet['id']
		);
		$result = $this->api->apiPost($this->userInfo['token'], "contract/get_image_accurecy", $dataPost);
		$this->data['result'] = $result->data;
		$this->data['contract_status'] = $result->contract_status;
		$this->load->view('template', isset($this->data)?$this->data:NULL);
	}

	public function viewImageAccuracy(){
		$this->data["pageName"] = $this->lang->line('view_img_authentication');
		$this->data['template'] = 'page/pawn/view_img';
		$dataGet = $this->input->get();
		$dataGet['id'] = $this->security->xss_clean($dataGet['id']);
		$dataPost = array(
			"id" => $dataGet['id']
		);
		$result = $this->api->apiPost($this->userInfo['token'], "contract/get_image_accurecy", $dataPost);
		$this->data['result'] = $result->data;
		$this->load->view('template', isset($this->data)?$this->data:NULL);
	}

	public function continueCreate(){
		//Get information
		$data = $this->input->get();
		$id = $this->security->xss_clean($data['id']);

		$config = $this->config_gic_model->findOne(array('code'=>'TN_TNNNV'));
		$this->data['tilekhoanvay'] =(!empty($config['TyLePhi'])) ? $config['TyLePhi'] : 0;

		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $id));
		if($contract->status == 200) {
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
			//Init loan infor
			$arrMinus = array();
			if(!empty($contract->data->loan_infor->decreaseProperty)) {
				$decreaseProperty = $contract->data->loan_infor->decreaseProperty;
				foreach($decreaseProperty as $item) {
					$a = array();
					$a['checked'] = !empty($item->checked) ? $item->checked : '';
					$a['name'] = !empty($item->name) ? $item->name : '';
					$a['slug'] = !empty($item->slug) ? $item->slug : '';
					$a['price'] = !empty($item->value) ? $item->value : '';
					array_push($arrMinus, $a);
				}
			}
			$dataLoanInfor = array(
				"type_finance" => !empty($contract->data->loan_infor->type_loan->id) ? $contract->data->loan_infor->type_loan->id : "",
				"main" => !empty($contract->data->loan_infor->type_property->id) ? $contract->data->loan_infor->type_property->id : "",
				"sub" => !empty($contract->data->loan_infor->name_property->id) ? $contract->data->loan_infor->name_property->id : "",
				"subName" => !empty($contract->data->loan_infor->name_property->text) ? $contract->data->loan_infor->name_property->text : "",
				"minus" => $arrMinus,
				"rootPrice" => !empty($contract->data->loan_infor->price_property) ? $contract->data->loan_infor->price_property : "",
				"editPrice" => !empty($contract->data->loan_infor->amount_money_max) ? $contract->data->loan_infor->amount_money_max : ""
			);
			//Start Địa chỉ đang ở
			$provinceSelected = $contract->data->current_address->province;
			$districtSelected = $contract->data->current_address->district;
			$provinceData = $this->api->apiPost($this->userInfo['token'], "province/get_province");
			if(!empty($provinceData->status) && $provinceData->status == 200){
				$this->data['provinceData'] = $provinceData->data;
			}else{
				$this->data['provinceData'] = array();
			}
			$districtData = $this->api->apiPost($this->userInfo['token'], "province/get_district_by_province", array("id" => $provinceSelected));
			if(!empty($districtData->status) && $districtData->status == 200){
				$this->data['districtData'] = $districtData->data;
			}else{
				$this->data['districtData'] = array();
			}
			$wardData = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtSelected));
			if(!empty($wardData->status) && $wardData->status == 200){
				$this->data['wardData'] = $wardData->data;
			}else{
				$this->data['wardData'] = array();
			}
			//End
			//Start Địa chỉ hộ khẩu
			$provinceSelected_ = $contract->data->houseHold_address->province;
			$districtSelected_ = $contract->data->houseHold_address->district;
			$provinceData_ = $this->api->apiPost($this->userInfo['token'], "province/get_province");
			if(!empty($provinceData_->status) && $provinceData_->status == 200){
				$this->data['provinceData_'] = $provinceData_->data;
			}else{
				$this->data['provinceData_'] = array();
			}
			//get district by province
			$districtData_ = $this->api->apiPost($this->userInfo['token'], "province/get_district_by_province", array("id" => $provinceSelected_));
			if(!empty($districtData_->status) && $districtData_->status == 200){
				$this->data['districtData_'] = $districtData_->data;
			}else{
				$this->data['districtData_'] = array();
			}
			//get ward by district
			$wardData_ = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtSelected_));
			if(!empty($wardData_->status) && $wardData_->status == 200){
				$this->data['wardData_'] = $wardData_->data;
			}else{
				$this->data['wardData_'] = array();
			}
			//End

		} else {
			$dataLoanInfor = array();
			$this->data['bankVimoData'] = array();
			$this->data['wardData'] = array();
			$this->data['provinceData_'] = array();
			$this->data['districtData'] = array();
			$this->data['configuration_formality'] = array();
			$this->data['mainPropertyData'] = array();
		}
		//get bank vimo
		$bankVimoData = $this->api->apiPost($this->userInfo['token'], "BankVimo/get_all");
		if(!empty($bankVimoData->status) && $bankVimoData->status == 200){
			$this->data['bankVimoData'] = $bankVimoData->data;
		}else{
			$this->data['bankVimoData'] = array();
		}
		$log = $this->api->apiPost($this->userInfo['token'], "log/get_log_contract", array("contract_id" => $id));
		if(!empty($log->status) && $log->status == 200){
			$this->data['logs'] = $log->data;
		}else{
			$this->data['logs'] = array();
		}
		//get store
		$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all", array());
		if(!empty($storeData->status) && $storeData->status == 200){
			$this->data['stores'] = $storeData->data;
		}else{
			$this->data['stores'] = array();
		}
		$this->data['dataInit'] = $dataLoanInfor;
		$this->data["pageName"] = $this->lang->line('add_new_contract');
		$this->data['template'] = 'page/pawn/continue_create_contract';
		$this->data['contractInfor'] = $contract->data;
		$this->load->view('template', isset($this->data)?$this->data:NULL);

	}

	public function createContract(){
		$this->data["pageName"] = $this->lang->line('add_new_contract');
		//get property main ( tài sản cấp cao nhất parenid == null)
		$config = $this->config_gic_model->findOne(array('code'=>'TN_TNNNV'));
		$this->data['tilekhoanvay'] =(!empty($config['TyLePhi'])) ? $config['TyLePhi'] : 0;
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main");
		//  var_dump( $this->data['tilekhoanvay']);die;
		if(!empty($mainPropertyData->status) && $mainPropertyData->status == 200){
			$this->data['mainPropertyData'] = $mainPropertyData->data;
		}else{
			$this->data['mainPropertyData'] = array();
		}
		//get province
		$provinceData = $this->api->apiPost($this->userInfo['token'], "province/get_province");
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

		//Start init data from màn hình định giá
		$dataGet = $this->input->get();
		//Hình thức vay
		if(!empty($dataGet['finance'])) $dataGet['finance'] = $this->security->xss_clean($dataGet['finance']);
		//Id = Loại tài sản
		if(!empty($dataGet['main'])) $dataGet['main'] = $this->security->xss_clean($dataGet['main']);
		//Id = Tên tài sản
		if(!empty($dataGet['sub'])) $dataGet['sub'] = $this->security->xss_clean($dataGet['sub']);
		if(!empty($dataGet['subName'])) $dataGet['subName'] = $this->security->xss_clean($dataGet['subName']);
		//Khấu hao
		if(!empty($dataGet['minus'])) {
			$data = array(
				"id" =>  $dataGet['sub']
			);
			$depreciationData = $this->api->apiPost($this->userInfo['token'], "property/get_depreciation_by_property", $data);
			$arrChecked = explode(",", $dataGet['minus']);
			$arrMinus = array();
			foreach($depreciationData->data as $item) {
				$a = array();
				in_array($item->slug, $arrChecked) == TRUE ? $a['checked'] = 1 : $a['checked'] = 0;
				$a['name'] = $item->name;
				$a['slug'] = $item->slug;
				$a['price'] = $item->price;
				array_push($arrMinus, $a);
			}
		}
		//giá gốc
		if(!empty($dataGet['rootPrice'])) $dataGet['rootPrice'] = $this->security->xss_clean($dataGet['rootPrice']);
		//giá sau sửa
		if(!empty($dataGet['editPrice'])) $dataGet['editPrice'] = $this->security->xss_clean($dataGet['editPrice']);

		$dataInit = array(
			"type_finance" => !empty($dataGet['finance']) ? $dataGet['finance'] : "",
			"main" => !empty($dataGet['main']) ? $dataGet['main'] : "",
			"sub" => !empty($dataGet['sub']) ? $dataGet['sub'] : "",
			"subName" => !empty($dataGet['subName']) ? $dataGet['subName'] : "",
			"minus" => !empty($arrMinus) ? $arrMinus : "",
			"rootPrice" => !empty($dataGet['rootPrice']) ? $dataGet['rootPrice'] : 0,
			"editPrice" => !empty($dataGet['editPrice']) ? $dataGet['editPrice'] : 0
		);
		$this->data['dataInit'] = $dataInit;
		//End init data from màn hình định giá

		//get bank vimo
		$bankVimoData = $this->api->apiPost($this->userInfo['token'], "BankVimo/get_all");
		if(!empty($bankVimoData->status) && $bankVimoData->status == 200){
			$this->data['bankVimoData'] = $bankVimoData->data;
		}else{
			$this->data['bankVimoData'] = array();
		}
		//get store
		$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all", array());
		if(!empty($storeData->status) && $storeData->status == 200){
			$this->data['stores'] = $storeData->data;
		}else{
			$this->data['stores'] = array();
		}
		$this->data['template'] = 'page/pawn/new_create_contract';
		// $this->data['template'] = 'page/pawn/create_contract';
		$this->load->view('template', isset($this->data)?$this->data:NULL);

	}

	private function isValidEmail($email) {
		$email = strtolower($email);
		return filter_var($email, FILTER_VALIDATE_EMAIL)
			&& preg_match('/@.+\./', $email);
	}

	public function validateCreateContract(){
		$data = $this->input->post();
		$data['customer_infor'] = $this->security->xss_clean($data['customer_infor']);
		$data['current_address'] = $this->security->xss_clean($data['current_address']);
		$data['houseHold_address'] = $this->security->xss_clean($data['houseHold_address']);
		$data['job_infor'] = $this->security->xss_clean($data['job_infor']);
		$data['relative_infor'] = $this->security->xss_clean($data['relative_infor']);
		$data['loan_infor'] = $this->security->xss_clean($data['loan_infor']);
		$data['receiver_infor'] = $this->security->xss_clean($data['receiver_infor']);
		$data['expertise_infor'] = $this->security->xss_clean($data['expertise_infor']);
		$data['store'] = $this->security->xss_clean($data['store']);
		$data['step'] = $this->security->xss_clean($data['step']);
		$propertyInfor = array();
		if(!empty($data['property_infor'])) $propertyInfor = $this->security->xss_clean($data['property_infor']);
		if($data['step'] == 1){
			//Check null mục thông tin khách hàng
			if(empty($data['customer_infor']) || empty($data['customer_infor']['customer_name'])
				|| empty($data['customer_infor']['customer_name'])
				|| empty($data['customer_infor']['customer_email'])
				|| empty($data['customer_infor']['customer_phone_number'])
				|| empty($data['customer_infor']['customer_identify'])
				|| empty($data['customer_infor']['customer_BOD'])
				|| empty($data['customer_infor']['marriage'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Điền đầy đủ mục thông tin khách hàng")));
				return;
			}
			//Check null mục địa chỉ đang ở
			if(empty($data['current_address']) || empty($data['current_address']['province'])
				|| empty($data['current_address']['district'])
				|| empty($data['current_address']['ward'])
				|| empty($data['current_address']['form_residence'])
				|| empty($data['current_address']['time_life'])
				|| empty($data['current_address']['current_stay'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Điền đầy đủ mục địa chỉ đang ở")));
				return;
			}
			//Check null mục địa chỉ hộ khẩu
			if(empty($data['houseHold_address']) || empty($data['houseHold_address']['province'])
				|| empty($data['houseHold_address']['district'])
				|| empty($data['houseHold_address']['ward'])
				|| empty($data['houseHold_address']['address_household'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Điền đầy đủ mục địa chỉ hộ khẩu")));
				return;
			}
			// validate
			if (!$this->isValidEmail($data['customer_infor']['customer_email'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => $this->lang->line('invalid_email'))));
				return;
			}
			if(!preg_match("/^[0-9]{9,12}$/", $data['customer_infor']['customer_identify'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "CMND không đúng định dạng")));
				return;
			}
			if(!preg_match("/^[0-9]{9,11}$/", $data['customer_infor']['customer_phone_number'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format'))));
				return;
			}
		}

		if($data['step'] == 2){
			//Check null mục Thông tin việc làm
			if(empty($data['job_infor']) || empty($data['job_infor']['phone_number_company'])
				|| empty($data['job_infor']['job_position'])
				|| empty($data['job_infor']['name_company'])
				|| empty($data['job_infor']['address_company'])
				|| empty($data['job_infor']['salary'])
				|| empty($data['job_infor']['receive_salary_via'])) {
				// var_dump($data['job_infor']['phone_number_company']);
				// var_dump($data['job_infor']['job_position']);
				// var_dump($data['job_infor']['name_company']);
				// var_dump($data['job_infor']['address_company']);
				// var_dump($data['job_infor']['salary']);
				// var_dump($data['job_infor']['receive_salary_via']);


				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Điền đầy đủ mục thông tin việc làm")));
				return;
			}
		}
		if($data['step'] == 3){
			//Check null mục Thông tin người thân
			if(empty($data['relative_infor']) || empty($data['relative_infor']['type_relative_1'])
				|| empty($data['relative_infor']['fullname_relative_1'])
				|| empty($data['relative_infor']['phone_number_relative_1'])
				|| empty($data['relative_infor']['hoursehold_relative_1'])
				|| empty($data['relative_infor']['confirm_relativeInfor_1'])
				|| empty($data['relative_infor']['type_relative_2'])
				|| empty($data['relative_infor']['fullname_relative_2'])
				|| empty($data['relative_infor']['phone_number_relative_2'])
				|| empty($data['relative_infor']['hoursehold_relative_2'])
				|| empty($data['relative_infor']['confirm_relativeInfor_2'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Điền đầy đủ mục thông tin người thân")));
				return;

			}
			if(!preg_match("/^[0-9]{9,11}$/", $data['relative_infor']['phone_number_relative_1'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format'))));
				return;
			}
			if(!preg_match("/^[0-9]{9,11}$/", $data['relative_infor']['phone_number_relative_2'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format'))));
				return;
			}
		}
		if($data['step'] == 4){

			//Check null mục Thông tin khoản vay
			if(empty($data['loan_infor']) || empty($data['loan_infor'])
				|| empty($data['loan_infor']['type_property'])
				|| empty($data['loan_infor']['name_property'])
				|| empty($data['loan_infor']['price_property'])
				|| empty($data['loan_infor']['amount_money'])
				|| empty($data['loan_infor']['type_interest'])
				|| empty($data['loan_infor']['number_day_loan'])
				|| empty($data['loan_infor']['insurrance_contract'])
				|| empty($data['loan_infor']['loan_purpose'])
				|| empty($data['loan_infor']['period_pay_interest'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Điền đầy đủ mục thông tin khoản vay")));
				return;
			}
			//   die($this->validateAge($data['customer_infor']['customer_BOD'],18) );
			if($this->validateAge($data['customer_infor']['customer_BOD'],18)=="FALSE" && $data['loan_infor']['insurrance_contract']==1) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Khách hàng đăng ký bảo hiểm phải lớn hơn 18 tuổi và < 75 tuổi")));
				return;
			}
			//Check null mục Thông tin tài sản
			$res = array(
				"code" =>  "200",
				"data" => ""
			);
			if(!empty($data['property_infor'])) {
				foreach($data['property_infor'] as $item) {
					if(empty($item['value'])) {
						$res = array(
							"code" =>  "400",
							"message" => "Điền đầy đủ mục thông tin tài sản"
						);

						break;
					}
					if ($item['slug'] == 'bien-so-xe') {
						$check = $this->checkProperty($item['value']);
						if (!empty($check)) {
							$res = array(
								"status" => 2,
								"message" => "Hợp đồng đang vay đã tồn tại biển số xe"
							);
							break;
						}
					}
				}
				$this->pushJson('200', json_encode($res));
				return;
			}else{
				$res = array(
					"code" =>  "400",
					"message" => "Điền đầy đủ mục thông tin tài sản"
				);
				$this->pushJson('200', json_encode($res));
				return;
			}
		}
		if($data['step'] == 5){

			//Check null mục thông tin chuyển khoản
			if(empty($data['receiver_infor']) || empty($data['receiver_infor']['type_payout'])
				|| empty($data['receiver_infor']['amount'])
				|| empty($data['receiver_infor']['bank_id'])) {
				$res = array(
					"status" => 2,
					"message" => "Điền đầy đủ mục thông tin khách hàng"
				);
				$this->pushJson('200', json_encode($res));
				return;
			}
			if(!empty($data['receiver_infor']['type_payout'])){
				if($data['receiver_infor']['type_payout'] == 2 && (empty($data['receiver_infor']['bank_account']) || empty($data['receiver_infor']['bank_account_holder']) || empty($data['receiver_infor']['bank_branch']))){
					$res = array(
						"status" => 2,
						"message" => "Điền đầy đủ mục thông tin khách hàng"
					);
					$this->pushJson('200', json_encode($res));
					return;
				}
				if($data['receiver_infor']['type_payout'] == 3 && (empty($data['receiver_infor']['atm_card_number']) || empty($data['receiver_infor']['atm_card_holder']))){
					$res = array(
						"status" => 2,
						"message" => "Điền đầy đủ mục thông tin khách hàng"
					);
					$this->pushJson('200', json_encode($res));
					return;
				}
			}

			//Check null mục thông tin phong giao dich
			if(empty($data['store']) || empty($data['store']['id'])
				|| empty($data['store']['name'])
				|| empty($data['store']['address'])) {
				$res = array(
					"status" => 2,
					"message" => "Điền đầy đủ mục thông tin phòng giao dịch"
				);
				$this->pushJson('200', json_encode($res));
				return;
			}

		}

		$this->pushJson('200', json_encode(array("code" => "200", "data" => '')));
		return;

	}

	private function checkProperty($infor) {
		$sendApi = array(
			"infor" => $infor,
		);
		$return = $this->api->apiPost($this->user['token'], "contract/check_property", $sendApi);
		if (!empty($return->status) && $return->status == 200) {
			return $return->data;
		} else{
			return array();
		}
	}

	public function saveContract(){
		$data = $this->input->post();
		$data['customer_infor'] = $this->security->xss_clean($data['customer_infor']);
		// var_dump($data['customer_infor']['customer_phone_number']);die;
		$data['current_address'] = $this->security->xss_clean($data['current_address']);
		$data['houseHold_address'] = $this->security->xss_clean($data['houseHold_address']);
		$data['job_infor'] = $this->security->xss_clean($data['job_infor']);
		$data['relative_infor'] = $this->security->xss_clean($data['relative_infor']);
		$data['loan_infor'] = $this->security->xss_clean($data['loan_infor']);
		$data['receiver_infor'] = $this->security->xss_clean($data['receiver_infor']);
		$data['expertise_infor'] = $this->security->xss_clean($data['expertise_infor']);
		$data['store'] = $this->security->xss_clean($data['store']);
		$data['step'] = $this->security->xss_clean($data['step']);
		$propertyInfor = array();
		if(!empty($data['property_infor'])) $propertyInfor = $this->security->xss_clean($data['property_infor']);
		// validate
		if($data['step'] == 1){
			//Check null mục thông tin khách hàng
			if(empty($data['customer_infor']) || empty($data['customer_infor']['customer_name'])
				|| empty($data['customer_infor']['customer_name'])
				|| empty($data['customer_infor']['customer_email'])
				|| empty($data['customer_infor']['customer_phone_number'])
				|| empty($data['customer_infor']['customer_identify'])
				|| empty($data['customer_infor']['customer_BOD'])
				|| empty($data['customer_infor']['marriage'])) {
				$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => 'Điền đầy đủ mục thông tin khách hàng'))));
				return;
			}

			if (!$this->isValidEmail($data['customer_infor']['customer_email'])) {
				$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $this->lang->line('invalid_email')))));
				return;
			}
			if(!preg_match("/^[0-9]{9,12}$/", $data['customer_infor']['customer_identify'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "CMND không đúng định dạng")));
				return;
			}
			if(!preg_match("/^[0-9]{9,11}$/", $data['customer_infor']['customer_phone_number'])) {
				$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format')))));
				return;
			}
		}
		if (!$this->isValidEmail($data['customer_infor']['customer_email'])) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $this->lang->line('invalid_email')))));
			return;
		}
		if(!preg_match("/^[0-9]{9,12}$/", $data['customer_infor']['customer_identify'])) {
			$this->pushJson('200', json_encode(array("code" => "400", "message" => "CMND không đúng định dạng")));
			return;
		}
		if(!preg_match("/^[0-9]{9,11}$/", $data['customer_infor']['customer_phone_number'])) {


			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format')))));
			return;
		}
		if(!empty($data['relative_infor']['phone_number_relative_1'])){
			if(!preg_match("/^[0-9]{9,11}$/", $data['relative_infor']['phone_number_relative_1'])) {
				$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format')))));
				return;
			}
		}
		if(!empty($data['relative_infor']['phone_number_relative_2'])){
			if(!preg_match("/^[0-9]{9,11}$/", $data['relative_infor']['phone_number_relative_2'])) {
				$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format')))));
				return;
			}
		}
		if(!empty($data['loan_infor']['amount_money']) && !empty($data['loan_infor']['amount_money_max'])){
			if((int)$data['loan_infor']['amount_money'] > (int)$data['loan_infor']['amount_money_max']){
				$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => "Số tiền vay lớn hơn mức quy định"))));
				return;
			}
		}
		// end
		$sendApi = array(
			'customer_infor' => $data['customer_infor'],
			'current_address' => $data['current_address'],
			'houseHold_address' => $data['houseHold_address'],
			'job_infor' => $data['job_infor'],
			'relative_infor' => $data['relative_infor'],
			'loan_infor' => $data['loan_infor'],
			'property_infor' => $propertyInfor,
			'receiver_infor' => $data['receiver_infor'],
			'expertise_infor' => $data['expertise_infor'],
			'store' => $data['store'],
			'step' => $data['step'],
			"created_at" => $this->createdAt,
			"created_by" => $this->user['email'],
		);
		$return = $this->api->apiPost($this->user['token'], "contract/process_save_contract", $sendApi);
		$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
	}

	public function processCreateContract() {
		$data = $this->input->post();
		$data['customer_infor'] = $this->security->xss_clean($data['customer_infor']);
		// var_dump($data['customer_infor']['customer_phone_number']);die;
		$data['current_address'] = $this->security->xss_clean($data['current_address']);
		$data['houseHold_address'] = $this->security->xss_clean($data['houseHold_address']);
		$data['job_infor'] = $this->security->xss_clean($data['job_infor']);
		$data['relative_infor'] = $this->security->xss_clean($data['relative_infor']);
		$data['loan_infor'] = $this->security->xss_clean($data['loan_infor']);
		$data['receiver_infor'] = $this->security->xss_clean($data['receiver_infor']);
		$data['expertise_infor'] = $this->security->xss_clean($data['expertise_infor']);
		$data['store'] = $this->security->xss_clean($data['store']);
		$propertyInfor = array();
		if(!empty($data['property_infor'])) $propertyInfor = $this->security->xss_clean($data['property_infor']);


		// validate
		if (!$this->isValidEmail($data['customer_infor']['customer_email'])) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $this->lang->line('invalid_email')))));
			return;
		}
		if(!preg_match("/^[0-9]{9,12}$/", $data['customer_infor']['customer_identify'])) {
			$this->pushJson('200', json_encode(array("code" => "400", "message" => "CMND không đúng định dạng")));
			return;
		}
		if(!preg_match("/^[0-9]{9,11}$/", $data['customer_infor']['customer_phone_number'])) {


			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format')))));
			return;
		}

		if(!preg_match("/^[0-9]{9,11}$/", $data['relative_infor']['phone_number_relative_1'])) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format')))));
			return;
		}
		if(!preg_match("/^[0-9]{9,11}$/", $data['relative_infor']['phone_number_relative_2'])) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format')))));
			return;
		}

		if((int)$data['loan_infor']['amount_money'] > (int)$data['loan_infor']['amount_money_max']){
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => "Số tiền vay lớn hơn mức quy định"))));
			return;
		}
		// end
		$sendApi = array(
			'customer_infor' => $data['customer_infor'],
			'current_address' => $data['current_address'],
			'houseHold_address' => $data['houseHold_address'],
			'job_infor' => $data['job_infor'],
			'relative_infor' => $data['relative_infor'],
			'loan_infor' => $data['loan_infor'],
			'property_infor' => $propertyInfor,
			'receiver_infor' => $data['receiver_infor'],
			'expertise_infor' => $data['expertise_infor'],
			'store' => $data['store'],
			"created_at" => $this->createdAt,
			"created_by" => $this->user['email'],
		);
		$return = $this->api->apiPost($this->user['token'], "contract/process_create_contract", $sendApi);
		if(!empty($return) && $return->status == 200){
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		}else{
			$msg = !empty($return->data->message) ? $return->data->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg))));
		}

	}

	public function continueCreateContract() {
		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['customer_infor'] = $this->security->xss_clean($data['customer_infor']);
		$data['current_address'] = $this->security->xss_clean($data['current_address']);
		$data['houseHold_address'] = $this->security->xss_clean($data['houseHold_address']);
		$data['job_infor'] = $this->security->xss_clean($data['job_infor']);
		$data['relative_infor'] = $this->security->xss_clean($data['relative_infor']);
		$data['loan_infor'] = $this->security->xss_clean($data['loan_infor']);
		$data['receiverInfor'] = $this->security->xss_clean($data['receiverInfor']);
		$data['expertise_infor'] = $this->security->xss_clean($data['expertise_infor']);
		$data['store'] = $this->security->xss_clean($data['store']);
		$config = $this->config_gic_model->findOne(array('code'=>'TN_TNNNV'));
		$this->data['tilekhoanvay'] =(!empty($config['TyLePhi'])) ? $config['TyLePhi'] : 0;
		$propertyInfor = array();
		if(!empty($data['property_infor'])) $propertyInfor = $this->security->xss_clean($data['property_infor']);

		// validate
		if (!$this->isValidEmail($data['customer_infor']['customer_email'])) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $this->lang->line('invalid_email')))));
			return;
		}
		if(!preg_match("/^[0-9]{9,12}$/", $data['customer_infor']['customer_identify'])) {
			$this->pushJson('200', json_encode(array("code" => "400", "message" => "CMND không đúng định dạng")));
			return;
		}
		if(!preg_match("/^[0-9]{9,11}$/", $data['customer_infor']['customer_phone_number'])) {


			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format')))));
			return;
		}
		if(!preg_match("/^[0-9]{9,11}$/", $data['relative_infor']['phone_number_relative_1'])) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format')))));
			return;
		}
		if(!preg_match("/^[0-9]{9,11}$/", $data['relative_infor']['phone_number_relative_2'])) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format')))));
			return;
		}
		if((int)$data['loan_infor']['amount_money'] > (int)$data['loan_infor']['amount_money_max']){
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => "Số tiền vay lớn hơn mức quy định"))));
			return;
		}

		$sendApi = array(
			"id" => $data['id'],
			'customer_infor' => $data['customer_infor'],
			'current_address' => $data['current_address'],
			'houseHold_address' => $data['houseHold_address'],
			'job_infor' => $data['job_infor'],
			'relative_infor' => $data['relative_infor'],
			'loan_infor' => $data['loan_infor'],
			'property_infor' => $propertyInfor,
			'receiver_infor' => $data['receiverInfor'],
			'expertise_infor' => $data['expertise_infor'],
			'store' => $data['store'],
			// "created_at" => $this->createdAt,
			"updated_by" => $this->user['email'],
		);
		//Insert log
		$return = $this->api->apiPost($this->user['token'], "contract/process_continue_create_contract", $sendApi);
		$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
	}

	public function continueSaveContract() {
		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['customer_infor'] = $this->security->xss_clean($data['customer_infor']);
		$data['current_address'] = $this->security->xss_clean($data['current_address']);
		$data['houseHold_address'] = $this->security->xss_clean($data['houseHold_address']);
		$data['job_infor'] = $this->security->xss_clean($data['job_infor']);
		$data['relative_infor'] = $this->security->xss_clean($data['relative_infor']);
		$data['loan_infor'] = $this->security->xss_clean($data['loan_infor']);
		$data['receiverInfor'] = $this->security->xss_clean($data['receiverInfor']);
		$data['expertise_infor'] = $this->security->xss_clean($data['expertise_infor']);
		$data['store'] = $this->security->xss_clean($data['store']);
		$data['step'] = $this->security->xss_clean($data['step']);
		$propertyInfor = array();
		if(!empty($data['property_infor'])) $propertyInfor = $this->security->xss_clean($data['property_infor']);
		if($data['step'] == 1){
			//Check null mục thông tin khách hàng
			if(empty($data['customer_infor']) || empty($data['customer_infor']['customer_name'])
				|| empty($data['customer_infor']['customer_name'])
				|| empty($data['customer_infor']['customer_email'])
				|| empty($data['customer_infor']['customer_phone_number'])
				|| empty($data['customer_infor']['customer_identify'])
				|| empty($data['customer_infor']['customer_BOD'])
				|| empty($data['customer_infor']['marriage'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Điền đầy đủ mục thông tin khách hàng")));
				return;
			}
			if (!$this->isValidEmail($data['customer_infor']['customer_email'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => $this->lang->line('invalid_email'))));
				return;
			}
			if(!preg_match("/^[0-9]{9,12}$/", $data['customer_infor']['customer_identify'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "CMND không đúng định dạng")));
				return;
			}
			if(!preg_match("/^[0-9]{9,11}$/", $data['customer_infor']['customer_phone_number'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format'))));
				return;
			}
		}
		if(!preg_match("/^[0-9]{9,12}$/", $data['customer_infor']['customer_identify'])) {
			$this->pushJson('200', json_encode(array("code" => "400", "message" => "CMND không đúng định dạng")));
			return;
		}
		if (!$this->isValidEmail($data['customer_infor']['customer_email'])) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $this->lang->line('invalid_email')))));
			return;
		}
		if(!preg_match("/^[0-9]{9,11}$/", $data['customer_infor']['customer_phone_number'])) {


			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format')))));
			return;
		}
		if(!empty($data['relative_infor']['phone_number_relative_1'])){
			if(!preg_match("/^[0-9]{9,11}$/", $data['relative_infor']['phone_number_relative_1'])) {
				$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format')))));
				return;
			}
		}
		if(!empty($data['relative_infor']['phone_number_relative_2'])){
			if(!preg_match("/^[0-9]{9,11}$/", $data['relative_infor']['phone_number_relative_2'])) {
				$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format')))));
				return;
			}
		}
		if(!empty($data['loan_infor']['amount_money']) && !empty($data['loan_infor']['amount_money_max'])){
			if((int)$data['loan_infor']['amount_money'] > (int)$data['loan_infor']['amount_money_max']){
				$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => "Số tiền vay lớn hơn mức quy định"))));
				return;
			}
		}
		$sendApi = array(
			"id" => $data['id'],
			'customer_infor' => $data['customer_infor'],
			'current_address' => $data['current_address'],
			'houseHold_address' => $data['houseHold_address'],
			'job_infor' => $data['job_infor'],
			'relative_infor' => $data['relative_infor'],
			'loan_infor' => $data['loan_infor'],
			'property_infor' => $propertyInfor,
			'receiver_infor' => $data['receiverInfor'],
			'expertise_infor' => $data['expertise_infor'],
			'store' => $data['store'],
			'step' => $data['step'],
			// "created_at" => $this->createdAt,
			"updated_by" => $this->user['email'],
		);
		//Insert log
		$return = $this->api->apiPost($this->user['token'], "contract/process_update_contract_continue", $sendApi);
		$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
	}

	public function processUpdateContract() {
		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['customer_infor'] = $this->security->xss_clean($data['customer_infor']);
		$data['current_address'] = $this->security->xss_clean($data['current_address']);
		$data['houseHold_address'] = $this->security->xss_clean($data['houseHold_address']);
		$data['job_infor'] = $this->security->xss_clean($data['job_infor']);
		$data['relative_infor'] = $this->security->xss_clean($data['relative_infor']);
		$data['loan_infor'] = $this->security->xss_clean($data['loan_infor']);
		$data['receiverInfor'] = $this->security->xss_clean($data['receiverInfor']);
		$data['expertise_infor'] = $this->security->xss_clean($data['expertise_infor']);
		$data['store'] = $this->security->xss_clean($data['store']);
		$propertyInfor = array();
		if(!empty($data['property_infor'])) $propertyInfor = $this->security->xss_clean($data['property_infor']);

		// validate
		if (!$this->isValidEmail($data['customer_infor']['customer_email'])) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $this->lang->line('invalid_email')))));
			return;
		}
		if(!preg_match("/^[0-9]{9,11}$/", $data['customer_infor']['customer_phone_number'])) {


			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format')))));
			return;
		}
		if(!preg_match("/^[0-9]{9,11}$/", $data['relative_infor']['phone_number_relative_1'])) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format')))));
			return;
		}
		if(!preg_match("/^[0-9]{9,11}$/", $data['relative_infor']['phone_number_relative_2'])) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format')))));
			return;
		}
		if((int)$data['loan_infor']['amount_money'] > (int)$data['loan_infor']['amount_money_max']){
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => "Số tiền vay lớn hơn mức quy định"))));
			return;
		}

		$sendApi = array(
			"id" => $data['id'],
			'customer_infor' => $data['customer_infor'],
			'current_address' => $data['current_address'],
			'houseHold_address' => $data['houseHold_address'],
			'job_infor' => $data['job_infor'],
			'relative_infor' => $data['relative_infor'],
			'loan_infor' => $data['loan_infor'],
			'property_infor' => $propertyInfor,
			'receiver_infor' => $data['receiverInfor'],
			'expertise_infor' => $data['expertise_infor'],
			'store' => $data['store'],
			// "created_at" => $this->createdAt,
			"updated_by" => $this->user['email'],
		);
		//Insert log
		$return = $this->api->apiPost($this->user['token'], "contract/process_update_contract", $sendApi);
		$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
	}

	private function pushJson($code, $data) {
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}

	public function contract(){

		$this->data["pageName"] = $this->lang->line('manage_contract');
		$data = array(
			// "type_login" => 1
		);
		$contractData = $this->api->apiPost($this->userInfo['token'], "contract/get_all_for_quickloan", $data);
		if(!empty($contractData->status) && $contractData->status == 200){
			$this->data['contractData'] = $contractData->data;
		}else{
			$this->data['contractData'] = array();
		}
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if(!empty($groupRoles->status) && $groupRoles->status == 200){
			$this->data['groupRoles'] = $groupRoles->data;
		}else{
			$this->data['groupRoles'] = array();
		}
		$config = $this->config_gic_model->findOne(array('code'=>'TN_TNNNV'));
		$this->data['tilekhoanvay'] =(!empty($config['TyLePhi'])) ? $config['TyLePhi'] : 0;
		$this->data['template'] = 'page/quickloan/contract';
		$this->load->view('template', isset($this->data)?$this->data:NULL);
	}
	public function search(){
		$this->data["pageName"] = $this->lang->line('manage_contract');
		$config = $this->config_gic_model->findOne(array('code'=>'TN_TNNNV'));
		$this->data['tilekhoanvay'] =(!empty($config['TyLePhi'])) ? $config['TyLePhi'] : 0;
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		if(strtotime($start) > strtotime($end)){
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('pawn/contract'));
		}
		$data = array(
		);
		if(!empty($_GET['fdate']) && !empty($_GET['tdate'])){
			$data = array(
				"start" => $start,
				"end" => $end,
			);
		}

		if (!empty($status)) {
			$data['status'] = $status;
		}
		$contractData = $this->api->apiPost($this->userInfo['token'], "contract/get_all_for_quickloan", $data);
		if(!empty($contractData->status) && $contractData->status == 200){
			$this->data['contractData'] = $contractData->data;
		}else{
			$this->data['contractData'] = array();
		}

		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if(!empty($groupRoles->status) && $groupRoles->status == 200){
			$this->data['groupRoles'] = $groupRoles->data;
		}else{
			$this->data['groupRoles'] = array();
		}
		$this->data['template'] = 'page/quickloan/contract';
		$this->load->view('template', isset($this->data)?$this->data:NULL);
	}

	public function spreadsheetFeeLoan(){
		$amount_money = !empty($_POST['amount_money']) ? $_POST['amount_money'] : 0;
		$type_loan = !empty($_POST) ? $_POST : "";
		$number_day_loan = !empty($_POST['number_day_loan']) ? $_POST['number_day_loan'] : 0;
		$period_pay_interest = !empty($_POST['period_pay_interest']) ? $_POST['period_pay_interest'] : 0;
		$type_interest = !empty($_POST['type_interest']) ? $_POST['type_interest'] : 0;
		$insurrance = !empty($_POST['insurrance']) ? $_POST['insurrance'] : "";
		$date_payment = !empty($_POST['date_payment']) ? strtotime($_POST['date_payment']) : 0;
		$number_date_payment = 0;

		$amount_money = $this->security->xss_clean($amount_money);
		$type_loan = $this->security->xss_clean($type_loan);
		$number_day_loan = $this->security->xss_clean($number_day_loan);
		$period_pay_interest = $this->security->xss_clean($period_pay_interest);
		$type_interest = $this->security->xss_clean($type_interest);
		$insurrance = $this->security->xss_clean($insurrance);
		$date_payment = $this->security->xss_clean($date_payment);


		//bang tính khoan vay
		$data_khoan_vay = array();


		// get thông tin phí vay
		$dataPhi = array();
		$phi_vay = $this->api->apiPost($this->userInfo['token'], "contract/bang_phi_vay", $dataPhi);
		$pham_tram_phi_tu_van = "";
		$pham_tram_phi_tham_dinh = "";
		if(!empty($phi_vay->status) && $phi_vay->status == 200){
			foreach($phi_vay->data as $key => $phi){
				if($phi->code == 'phi_tu_van'){
					$pham_tram_phi_tu_van = !empty($phi->percent) ? $phi->percent : 0;
				}
				if($phi->code == 'phi_tham_dinh'){
					$pham_tram_phi_tham_dinh = !empty($phi->percent) ? $phi->percent : 0;
				}
				if($phi->code == 'phi_bao_hiem'){
					$percent_insurrance = !empty($phi->percent) ? $phi->percent : 0;
				}
			}
		}
		//phí bảo hiểm
		if($insurrance == 'true'){
			$fee_insurrance = $amount_money*$percent_insurrance;
		}else{
			$fee_insurrance = 0;
		}
		$tien_goc = $amount_money + $fee_insurrance;

		$number_date_payment = $period_pay_interest;

		// số kỳ vay
		$so_ky_vay = (int)$number_day_loan/(int)$period_pay_interest;
		if($type_loan == 1){
			// trường hợp cầm cố chỉ có 1 hình thức lãi hàng tháng gốc cuối kỳ và chỉ cho vay ngắn hạn max 30 ngày
			if(!empty($date_payment)){
				// truong hop tất toán trước hạn
				//số ngày vay thực tế = $date_payment -  time now
				$date_payment = $date_payment - time();
				$number_date_payment = 0;
				if($date_payment > 0){
					$number_date_payment = (int)ceil($date_payment/(60*60*24));

				}

				//block số ngày vay thực tế trường hợp cầm đồ
				if($number_date_payment <= 10){
					$number_date_payment = 10;
				}elseif($number_date_payment > 10 && $number_date_payment <= 20){
					$number_date_payment = 20;
				}elseif($number_date_payment > 20 && $number_date_payment <= 30){
					$number_date_payment = 30;
				}

			}
			if($type_interest == 2){
				// hình thức lãi hàng tháng gốc cuối kỳ

				//lãi 1 kỳ
				//number_date_payment => số ngày vay thục thế
				$lai_ky = round(($number_date_payment*$tien_goc*0.18)/365);

				//phí tư vấn
				$phi_tu_van=0;
				if(!empty($pham_tram_phi_tham_dinh)){
					$phi_tu_van=$tien_goc*$pham_tram_phi_tham_dinh;
				}
				//phí dịch vu
				$phi_tham_dinh=0;
				if(!empty($pham_tram_phi_tham_dinh)){
					$phi_tham_dinh=$tien_goc*$pham_tram_phi_tham_dinh;
				}

				//tổng phí lãi 1 kỳ
				if(empty($date_payment)){
					$phi_lai = 0.081*$tien_goc;
				}else{
					$phi_lai =  $lai_ky +  $phi_tu_van + $phi_tham_dinh;
				}
				// var_dump($phi_lai);die;
				//tiền tất toán
				$tien_tat_toan = $phi_lai+$tien_goc;

				//khoan vay 1 ky
				for( $i = 1;$i<= $so_ky_vay;$i++){
					if($i == $so_ky_vay){
						$lai_ky = round(($number_date_payment*$tien_goc*0.18)/365);
					}
					$ky_tra = $i;
					$data_1ky = array(
						'ky_tra' => $ky_tra,
						'phi_lai' => $phi_lai,
						'phi_tu_van' => $phi_tu_van,
						'phi_tham_dinh' => $phi_tham_dinh,
						'lai_ky' => $lai_ky,
						'tien_tat_toan' => $tien_tat_toan
					);
					array_push($data_khoan_vay,$data_1ky);
				}


				//total phai tra
				//tổng tiền trả kỳ
				$tong_tien_tra_ky = $phi_lai * $so_ky_vay;
				//tổng tiền tất toán
				$tong_tien_tat_toan =  $tong_tien_tra_ky + $tien_goc;
				//tổng tiền phí tư vấn
				$tong_phi_tu_van =  $phi_tu_van * $so_ky_vay;
				//tổng tiền phí thẩm định
				$tong_phi_tham_dinh =  $phi_tham_dinh * $so_ky_vay;
				//tổng tiền lãi kỳ
				$tong_lai_ky = $lai_ky *  $so_ky_vay;

				$data_total = array(
					"tong_tien_tra_ky" =>  $tong_tien_tra_ky,
					"tong_tien_tat_toan" => $tong_tien_tat_toan,
					"tong_phi_tu_van" => $tong_phi_tu_van,
					"tong_phi_tham_dinh" => $tong_phi_tham_dinh,
					"tong_lai_ky" =>  $tong_lai_ky
				);

				$response = [
					'res' => true,
					'status' => "200",
					'message' => $this->lang->line('success'),
					'data' => $data_khoan_vay,
					'data_total' => $data_total
				];
				echo json_encode($response);
				return;

			}else{
				$response = [
					'res' => false,
					'status' => "400",
					'message' => $this->lang->line('can_not_pay_method'),
				];
				echo json_encode($response);
				return;
			}
		}else{
			// trường hợp giấy tờ xe
			if($type_interest == 1){
				//hinh thức dư  giảm dần
				//sô ngày vay thực tế kỳ cuối
				// $number_date_payment_ky_cuoi = (int)$number_day_loan%(int)$number_day_loan;
				$number_date_payment_ky_cuoi = 0;


				//tiền trả 1 kỳ pow(2, -3)
				$tien_tra_1_ky = round(($tien_goc*0.081)/(1-pow((1+0.081),-$so_ky_vay)));

				//tiền trả 1 kỳ làm tròn
				$round_tien_tra_1_ky = round($tien_tra_1_ky,-1);

				//gốc còn lại
				$tien_goc_con = $tien_goc;

				//tong cac loai phi
				$tong_phi_tu_van = 0;
				$tong_phi_tham_dinh  = 0;

				// truong hop tất toán trước hạn
				if(!empty($date_payment)){
					//số ngày vay thực tế = $date_payment -  time now

					$date_payment = $date_payment - time();
					$number_date_payment = 0;
					if($date_payment > 0){
						$number_date_payment = (int)ceil($date_payment/(60*60*24));
					}
					$kyvay = (int)$number_date_payment/(int)$period_pay_interest;

					$so_ky_vay = ceil((int)$number_date_payment/(int)$period_pay_interest);
					$number_date_payment_ky_cuoi = $number_date_payment - (int)$kyvay*(int)$period_pay_interest;

				}

				//khoan vay 1 ky
				for( $i = 1;$i<= $so_ky_vay;$i++){
					//kỳ trả
					$ky_tra = $i;
					//lãi
					$lai_ky = round(($period_pay_interest*$tien_goc_con*0.18)/365);
					//tổng phí lãi 1 kỳ
					$tong_phi_lai = 0.081*$tien_goc_con;
					//tiền gốc
					$tien_goc_1ky=$tien_tra_1_ky-$tong_phi_lai;
					//phí tư vấn
					$phi_tu_van="";
					if(!empty($pham_tram_phi_tu_van)){
						$phi_tu_van=$tien_goc_con*$pham_tram_phi_tu_van;
					}

					//phí dịch vu
					$phi_tham_dinh="";
					if(!empty($pham_tram_phi_tham_dinh)){
						$phi_tham_dinh=$tien_goc_con*$pham_tram_phi_tham_dinh;
					}
					//tiền gốc còn lại
					$tien_goc_con -= $tien_goc_1ky;

					//tiền tất toán
					$tien_tat_toan = $tien_tra_1_ky+$tien_goc_con;

					// tiền phạt tất toán;
					$tien_phat_tat_toan  = 0;

					if($i == $so_ky_vay){
						if($number_date_payment_ky_cuoi != 0 && !empty($date_payment)){
							$lai_ky = round(($number_date_payment_ky_cuoi*$tien_goc*0.18)/365);
							$tien_tra_1_ky = $tien_goc_con;
							$round_tien_tra_1_ky =  round($tien_tra_1_ky);
							$tien_goc_1ky = $tien_tra_1_ky - $tong_phi_lai;

							// tiền phạt tất toán;
							if($number_date_payment < $number_day_loan*0.3){
								// phat tất toán 8% tổng tiền gốc còn
								$tien_phat_tat_toan = $tien_goc_con * 0.8;
							}elseif($number_date_payment < $number_day_loan*0.6 && $number_date_payment > $number_day_loan*0.3 ){
								// phat tất toán 5% tổng tiền gốc còn
								$tien_phat_tat_toan = $tien_goc_con * 0.5;
							}elseif($number_date_payment < $number_day_loan*0.9 && $number_date_payment > $number_day_loan*0.6 ){
								// phat tất toán 5% tổng tiền gốc còn
								$tien_phat_tat_toan = $tien_goc_con * 0.3;
							}

							$tien_goc_con = 0;
						}
					}

					$data_1ky = array(
						'ky_tra' => $ky_tra,
						'tien_tra_1_ky' => $tien_tra_1_ky,
						'round_tien_tra_1_ky' => $round_tien_tra_1_ky,
						'tien_goc_1ky' => $tien_goc_1ky,
						'tong_phi_lai' => $tong_phi_lai,
						'phi_tu_van' => $phi_tu_van,
						'phi_tham_dinh' => $phi_tham_dinh,
						'lai_ky' => $lai_ky,
						'tien_goc_con' => $tien_goc_con,
						'tien_tat_toan' => $tien_tat_toan,


					);
					array_push($data_khoan_vay,$data_1ky);

					//tổng phí tư vấn
					$tong_phi_tu_van += $phi_tu_van;
					//tổng phí dịch vụ
					$tong_phi_tham_dinh += $phi_tham_dinh;
				}
				//total phai tra
				//tổng tiền trả kỳ
				$tong_tien_tra_ky = $tien_tra_1_ky * $so_ky_vay;
				//tổng tiền tra kỳ làm tròn
				$tong_round_tien_tra_ky = $round_tien_tra_1_ky * $so_ky_vay;
				$dataTotal = array(
					"tong_tien_tra_ky" =>  $tong_tien_tra_ky,
					"tong_round_tien_tra_ky" => $tong_round_tien_tra_ky,
					"tong_phi_tu_van" => $tong_phi_tu_van,
					"tong_phi_tham_dinh" => $tong_phi_tham_dinh,
					'tien_phat_tat_toan' => $tien_phat_tat_toan
				);

				$response = [
					'res' => true,
					'status' => "200",
					'message' => $this->lang->line('success'),
					'data' => $data_khoan_vay,
					'dataTotal' => $dataTotal,
				];
				echo json_encode($response);
				return;


			}else{
				// hình thức lãi hàng tháng gốc cuối kỳ
				//tổng phí lãi 1 kỳ
				$phi_lai = 0.081*$tien_goc;

				//lãi 1 kỳ
				//number_date_payment => số ngày vay thục thế

				$lai_ky = round(($period_pay_interest*$tien_goc*0.18)/365);

				//tiền tất toán
				$tien_tat_toan = $phi_lai+$tien_goc;

				//phí tư vấn
				$phi_tu_van=0;
				if(!empty($pham_tram_phi_tham_dinh)){
					$phi_tu_van=$tien_goc*$pham_tram_phi_tham_dinh;
				}
				//phí dịch vu
				$phi_tham_dinh=0;
				if(!empty($pham_tram_phi_tham_dinh)){
					$phi_tham_dinh=$tien_goc*$pham_tram_phi_tham_dinh;
				}

				//khoan vay 1 ky
				for( $i = 1;$i<= $so_ky_vay;$i++){
					if($i == $so_ky_vay){
						$lai_ky = round(($number_date_payment*$tien_goc*0.18)/365);
					}
					$ky_tra = $i;
					$data_1ky = array(
						'ky_tra' => $ky_tra,
						'phi_lai' => $phi_lai,
						'phi_tu_van' => $phi_tu_van,
						'phi_tham_dinh' => $phi_tham_dinh,
						'lai_ky' => $lai_ky,
						'tien_tat_toan' => $tien_tat_toan
					);
					array_push($data_khoan_vay,$data_1ky);
				}


				//total phai tra
				//tổng tiền trả kỳ
				$tong_tien_tra_ky = $phi_lai * $so_ky_vay;
				//tổng tiền tất toán
				$tong_tien_tat_toan =  $tong_tien_tra_ky + $tien_goc;
				//tổng tiền phí tư vấn
				$tong_phi_tu_van =  $phi_tu_van * $so_ky_vay;
				//tổng tiền phí thẩm định
				$tong_phi_tham_dinh =  $phi_tham_dinh * $so_ky_vay;
				//tổng tiền lãi kỳ
				$tong_lai_ky = $lai_ky *  $so_ky_vay;

				$data_total = array(
					"tong_tien_tra_ky" =>  $tong_tien_tra_ky,
					"tong_tien_tat_toan" => $tong_tien_tat_toan,
					"tong_phi_tu_van" => $tong_phi_tu_van,
					"tong_phi_tham_dinh" => $tong_phi_tham_dinh,
					"tong_lai_ky" =>  $tong_lai_ky
				);

				$response = [
					'res' => true,
					'status' => "200",
					'message' => $this->lang->line('success'),
					'data' => $data_khoan_vay,
					'data_total' => $data_total
				];
				echo json_encode($response);
				return;


			}

		}

	}

	public function feeTable(){
		$configuration_formality = $this->api->apiPost($this->userInfo['token'], "configuration_formality/get_configuration_formality");
		if(!empty($configuration_formality->status) && $configuration_formality->status == 200){
			$this->data['configuration_formality'] = $configuration_formality->data;
		}else{
			$this->data['configuration_formality'] = array();
		}
		$this->data["pageName"] = $this->lang->line('manage_contract');
		$this->data['template'] = 'page/pawn/fee_table';
		$this->load->view('template', isset($this->data)?$this->data:NULL);
	}

	public function updateDisbursement(){
		$data = $this->input->get();
		$data['id'] = $this->security->xss_clean($data['id']);
		//Get information
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		if($contract->status == 200) {
			//get bank vimo
			$bankVimoData = $this->api->apiPost($this->userInfo['token'], "BankVimo/get_all");
			if(!empty($bankVimoData->status) && $bankVimoData->status == 200){
				$this->data['bankVimoData'] = $bankVimoData->data;
			}else{
				$this->data['bankVimoData'] = array();
			}
			$this->data["pageName"] = $this->lang->line('update_contract');
			$this->data['template'] = 'page/pawn/update_disbursement_contract';
			$this->data['contractInfor'] = $contract->data;
			$this->load->view('template', isset($this->data)?$this->data:NULL);
		}
	}

	public function updateFee(){

		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['percent_advisory'] = $this->security->xss_clean($data['percent_advisory']);
		$data['percent_expertise'] = $this->security->xss_clean($data['percent_expertise']);
		// $data['note'] = $this->security->xss_clean($data['note']);
		if(empty($data['percent_advisory'])){
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => "Không được để trống phí tư vấn quản lý")));
		}
		if(empty($data['percent_expertise'])){
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => "Không được để trống phí thẩm định và lưu trữ tài sản đảm bảo")));
		}
		// end
		$sendApi = array(
			'id' => $data['id'],
			'percent_advisory' => $data['percent_advisory'],
			'percent_expertise' => $data['percent_expertise'],
		);
		$return = $this->api->apiPost($this->user['token'], "contract/process_update_fee", $sendApi);
		$this->pushJson('200', json_encode(array("code" => "200", "data" => $return, "msg" => "update fee success")));

	}

	public function updateDisbursementContract(){

		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['receiver_infor'] = $this->security->xss_clean($data['receiver_infor']);
		// end
		$sendApi = array(
			'id' => $data['id'],
			'receiver_infor' => $data['receiver_infor'],
		);
		$return = $this->api->apiPost($this->user['token'], "contract/process_update_disbursement_contract", $sendApi);
		$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));

	}

	public function update() {
		$data = $this->input->get();
		$data['id'] = $this->security->xss_clean($data['id']);
		$config = $this->config_gic_model->findOne(array('code'=>'TN_TNNNV'));
		$this->data['tilekhoanvay'] =(!empty($config['TyLePhi'])) ? $config['TyLePhi'] : 0;
		//Get information
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		if($contract->status == 200) {
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
			//Init loan infor
			$arrMinus = array();
			if(!empty($contract->data->loan_infor->decreaseProperty)) {
				$decreaseProperty = $contract->data->loan_infor->decreaseProperty;
				foreach($decreaseProperty as $item) {
					$a = array();
					$a['checked'] = $item->checked;
					$a['name'] = $item->name;
					$a['slug'] = $item->slug;
					$a['price'] = $item->value;
					array_push($arrMinus, $a);
				}
			}
			$dataLoanInfor = array(
				"type_finance" => !empty($contract->data->loan_infor->type_loan->id) ? $contract->data->loan_infor->type_loan->id : "",
				"main" => !empty($contract->data->loan_infor->type_property->id) ? $contract->data->loan_infor->type_property->id : "",
				"sub" => !empty($contract->data->loan_infor->name_property->id) ? $contract->data->loan_infor->name_property->id : "",
				"subName" => !empty($contract->data->loan_infor->name_property->text) ? $contract->data->loan_infor->name_property->text : "",
				"minus" => $arrMinus,
				"rootPrice" => !empty($contract->data->loan_infor->price_property) ? $contract->data->loan_infor->price_property : "",
				"editPrice" => !empty($contract->data->loan_infor->amount_money_max) ? $contract->data->loan_infor->amount_money_max : ""
			);
			//Start Địa chỉ đang ở
			$provinceSelected = $contract->data->current_address->province;
			$districtSelected = $contract->data->current_address->district;
			$provinceData = $this->api->apiPost($this->userInfo['token'], "province/get_province");
			if(!empty($provinceData->status) && $provinceData->status == 200){
				$this->data['provinceData'] = $provinceData->data;
			}else{
				$this->data['provinceData'] = array();
			}
			$districtData = $this->api->apiPost($this->userInfo['token'], "province/get_district_by_province", array("id" => $provinceSelected));
			if(!empty($districtData->status) && $districtData->status == 200){
				$this->data['districtData'] = $districtData->data;
			}else{
				$this->data['districtData'] = array();
			}
			$wardData = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtSelected));
			if(!empty($wardData->status) && $wardData->status == 200){
				$this->data['wardData'] = $wardData->data;
			}else{
				$this->data['wardData'] = array();
			}
			//End
			//Start Địa chỉ hộ khẩu
			$provinceSelected_ = $contract->data->houseHold_address->province;
			$districtSelected_ = $contract->data->houseHold_address->district;
			$provinceData_ = $this->api->apiPost($this->userInfo['token'], "province/get_province");
			if(!empty($provinceData_->status) && $provinceData_->status == 200){
				$this->data['provinceData_'] = $provinceData_->data;
			}else{
				$this->data['provinceData_'] = array();
			}
			//get district by province
			$districtData_ = $this->api->apiPost($this->userInfo['token'], "province/get_district_by_province", array("id" => $provinceSelected_));
			if(!empty($districtData_->status) && $districtData_->status == 200){
				$this->data['districtData_'] = $districtData_->data;
			}else{
				$this->data['districtData_'] = array();
			}
			//get ward by district
			$wardData_ = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtSelected_));
			if(!empty($wardData_->status) && $wardData_->status == 200){
				$this->data['wardData_'] = $wardData_->data;
			}else{
				$this->data['wardData_'] = array();
			}
			//End

			//get bank vimo
			$bankVimoData = $this->api->apiPost($this->userInfo['token'], "BankVimo/get_all");
			if(!empty($bankVimoData->status) && $bankVimoData->status == 200){
				$this->data['bankVimoData'] = $bankVimoData->data;
			}else{
				$this->data['bankVimoData'] = array();
			}

			// get history log
			$work_follow = $this->api->apiPost($this->userInfo['token'], "log/get_log_contract", array("contract_id" => $data['id']));
			if(!empty($work_follow->status) && $work_follow->status == 200){
				$this->data['work_follow'] = $work_follow->data;
			}else{
				$this->data['work_follow'] = array();
			}
			//get store
			$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all", array());
			if(!empty($storeData->status) && $storeData->status == 200){
				$this->data['stores'] = $storeData->data;
			}else{
				$this->data['stores'] = array();
			}
			$this->data['dataInit'] = $dataLoanInfor;
			$this->data["pageName"] = $this->lang->line('update_contract');
			$this->data['template'] = 'page/pawn/new_update_contract';
			// $this->data['template'] = 'page/pawn/update';
			$this->data['contractInfor'] = $contract->data;
			$this->load->view('template', isset($this->data)?$this->data:NULL);
		} else {

		}

	}

	public function detail() {
		$data = $this->input->get();
		$data['id'] = $this->security->xss_clean($data['id']);
		$config = $this->config_gic_model->findOne(array('code'=>'TN_TNNNV'));
		$this->data['tilekhoanvay'] =(!empty($config['TyLePhi'])) ? $config['TyLePhi'] : 0;
		//Get information
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		if($contract->status == 200) {
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
			//Init loan infor
			$arrMinus = array();
			if(!empty($contract->data->loan_infor->decreaseProperty)) {
				$decreaseProperty = $contract->data->loan_infor->decreaseProperty;
				foreach($decreaseProperty as $item) {
					$a = array();
					$a['checked'] = !empty($item->checked) ? $item->checked : '';
					$a['name'] = !empty($item->name) ? $item->name : '';
					$a['slug'] = !empty($item->slug) ? $item->slug : '';
					$a['price'] = !empty($item->value) ? $item->value : '';
					array_push($arrMinus, $a);
				}
			}
			$dataLoanInfor = array(
				"type_finance" => !empty($contract->data->loan_infor->type_loan->id) ? $contract->data->loan_infor->type_loan->id : "",
				"main" => !empty($contract->data->loan_infor->type_property->id) ? $contract->data->loan_infor->type_property->id : "",
				"sub" => !empty($contract->data->loan_infor->name_property->id) ? $contract->data->loan_infor->name_property->id : "",
				"subName" => !empty($contract->data->loan_infor->name_property->text) ? $contract->data->loan_infor->name_property->text : "",
				"minus" => $arrMinus,
				"rootPrice" => !empty($contract->data->loan_infor->price_property) ? $contract->data->loan_infor->price_property : "",
				"editPrice" => !empty($contract->data->loan_infor->amount_money_max) ? $contract->data->loan_infor->amount_money_max : ""
			);
			//Start Địa chỉ đang ở
			$provinceSelected = $contract->data->current_address->province;
			$districtSelected = $contract->data->current_address->district;
			$provinceData = $this->api->apiPost($this->userInfo['token'], "province/get_province");
			if(!empty($provinceData->status) && $provinceData->status == 200){
				$this->data['provinceData'] = $provinceData->data;
			}else{
				$this->data['provinceData'] = array();
			}
			$districtData = $this->api->apiPost($this->userInfo['token'], "province/get_district_by_province", array("id" => $provinceSelected));
			if(!empty($districtData->status) && $districtData->status == 200){
				$this->data['districtData'] = $districtData->data;
			}else{
				$this->data['districtData'] = array();
			}
			$wardData = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtSelected));
			if(!empty($wardData->status) && $wardData->status == 200){
				$this->data['wardData'] = $wardData->data;
			}else{
				$this->data['wardData'] = array();
			}
			//End
			//Start Địa chỉ hộ khẩu
			$provinceSelected_ = $contract->data->houseHold_address->province;
			$districtSelected_ = $contract->data->houseHold_address->district;
			$provinceData_ = $this->api->apiPost($this->userInfo['token'], "province/get_province");
			if(!empty($provinceData_->status) && $provinceData_->status == 200){
				$this->data['provinceData_'] = $provinceData_->data;
			}else{
				$this->data['provinceData_'] = array();
			}
			//get district by province
			$districtData_ = $this->api->apiPost($this->userInfo['token'], "province/get_district_by_province", array("id" => $provinceSelected_));
			if(!empty($districtData_->status) && $districtData_->status == 200){
				$this->data['districtData_'] = $districtData_->data;
			}else{
				$this->data['districtData_'] = array();
			}
			//get ward by district
			$wardData_ = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtSelected_));
			if(!empty($wardData_->status) && $wardData_->status == 200){
				$this->data['wardData_'] = $wardData_->data;
			}else{
				$this->data['wardData_'] = array();
			}
			//End

		} else {
			$dataLoanInfor = array();
			$this->data['bankVimoData'] = array();
			$this->data['wardData'] = array();
			$this->data['provinceData_'] = array();
			$this->data['districtData'] = array();
			$this->data['configuration_formality'] = array();
			$this->data['mainPropertyData'] = array();
		}

		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if(!empty($groupRoles->status) && $groupRoles->status == 200){
			$this->data['groupRoles'] = $groupRoles->data;
		}else{
			$this->data['groupRoles'] = array();
		}
		//get bank vimo
		$bankVimoData = $this->api->apiPost($this->userInfo['token'], "BankVimo/get_all");
		if(!empty($bankVimoData->status) && $bankVimoData->status == 200){
			$this->data['bankVimoData'] = $bankVimoData->data;
		}else{
			$this->data['bankVimoData'] = array();
		}
		// get history log
		$log = $this->api->apiPost($this->userInfo['token'], "log/get_log_contract", array("contract_id" => $data['id']));
		if(!empty($log->status) && $log->status == 200){
			$this->data['logs'] = $log->data;
		}else{
			$this->data['logs'] = array();
		}
		$this->data['dataInit'] = $dataLoanInfor;
		$this->data["pageName"] = $this->lang->line('detail_loan_contract');
		$this->data['template'] = 'page/quickloan/detail_contract';
		$this->data['detail'] = 1;
		$this->data['contractInfor'] = $contract->data;
		$this->load->view('template', isset($this->data)?$this->data:NULL);

	}

	public function printed() {
		$data = $this->input->get();
		$data['id'] = $this->security->xss_clean($data['id']);
		//Get information
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		$address = '';
		if($contract->status == 200) {
			//Start Địa chỉ đang ở
			$districtSelected = $contract->data->current_address->district;
			$wardSelected = $contract->data->current_address->ward;
			$current_address = $contract->data->current_address->current_stay;
			$wardData = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtSelected));
			if(!empty($wardData->status) && $wardData->status == 200){
				foreach ($wardData->data as $w) {
					if ($w->code == $wardSelected) {
						$address = $current_address. ', '.$w->path_with_type;
						break;
					}
				}
			}
			//End

		}
		//get bank vimo
		$bank_id = $contract->data->receiver_infor->bank_id;
		$bankVimoData = $this->api->apiPost($this->userInfo['token'], "BankVimo/get_bank_name", array('bank_id' => $bank_id));
		$bank_name = '';
		if(!empty($bankVimoData->status) && $bankVimoData->status == 200){
			$bank_name = $bankVimoData->data->name;
		}
		$condition = array(
			'insurrance' => isset($contract->data->loan_infor->insurrance_contract) ? $contract->data->loan_infor->insurrance_contract : '',
			'type_interest' => $contract->data->loan_infor->type_interest,
			'period_pay_interest' => $contract->data->loan_infor->period_pay_interest,
			'number_day_loan' => $contract->data->loan_infor->number_day_loan,
			'amount_money' => $contract->data->loan_infor->amount_money,
			'code_contract' => $contract->data->code_contract,
		);
		$money_per_month = $this->api->apiPost($this->userInfo['token'], "generateContract/getMoneyPerMonth", $condition);
		$money = '';
		if(!empty($money_per_month->status) && $money_per_month->status == 200){
			$money = $money_per_month->data;
		}
		$property = $contract->data->property_infor;
		$sokhung = '';
		$somay = '';
		$bienkiemsoat = '';
		$nhanhieu = '';
		$model = '';
		foreach ($property as $p) {
			if ($p->slug === 'bien-so-xe') {
				$bienkiemsoat = $p->value;
			} elseif ($p->slug === 'so-khung') {
				$sokhung = $p->value;
			} elseif ($p->slug === 'so-may') {
				$somay = $p->value;
			} elseif ($p->slug === 'nhan-hieu') {
				$nhanhieu = $p->value;
			} elseif ($p->slug === 'model') {
				$model = $p->value;
			}
		}
		$customerDOB = '';
		if (!empty($contract->data->customer_infor->customer_BOD)) {
			$dobArray = explode('-',$contract->data->customer_infor->customer_BOD);
			$customerDOB = $dobArray[2].'-'.$dobArray[1].'-'.$dobArray[0];
		}
		$this->data['contract'] = $contract->data;
		$this->data['money'] = $money;
		$this->data['bank_name'] = $bank_name;
		$this->data['address'] = $address;
		$this->data['sokhung'] = $sokhung;
		$this->data['somay'] = $somay;
		$this->data['nhanhieu'] = $nhanhieu;
		$this->data['model'] = $model;
		$this->data['bienkiemsoat'] = $bienkiemsoat;
		$this->data['customerDOB'] = $customerDOB;
		$this->load->view('contract_printed', isset($this->data)?$this->data:NULL);
		return;
	}

	public function disbursement($id) {
		$data['id'] = $id;
		$data['id'] = $this->security->xss_clean($data['id']);

		//get list nhà đầu tư
		$listInvestor = $this->api->apiPost($this->userInfo['token'], "investor/get_all");
		if($listInvestor->status == 200) {
			$this->data['listInvestor'] = $listInvestor->data;
		}
		//Get information
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		if($contract->status == 200) {
			$this->data['contractInfor'] = $contract->data;
		}
		$this->data['template'] = 'page/pawn/disbursement';
		$this->load->view('template', isset($this->data)?$this->data:NULL);

	}

	public function createWithdrawalVimo(){
		$data = $this->input->post();
		$data['type_payout'] = !empty($data['type_payout']) ? $this->security->xss_clean($data['type_payout']) : "";
		$data['order_code'] = !empty($data['order_code']) ? $this->security->xss_clean($data['order_code']) : "";
		$data['amount'] = !empty($data['amount']) ? $this->security->xss_clean($data['amount']) : "";
		$data['bank_id'] = !empty($data['bank_id']) ?$this->security->xss_clean($data['bank_id']) : "";
		$data['description'] = !empty($data['description']) ? $this->security->xss_clean($data['description']) : "";
		$data['code_contract'] = !empty($data['code_contract']) ? $this->security->xss_clean($data['code_contract']) : "";
		//Bank account = 2
		if($data['type_payout'] == 2 || $data['type_payout'] == 10) {
			$data['bank_account'] = !empty($data['bank_account']) ? $this->security->xss_clean($data['bank_account']) : "";
			$data['bank_account_holder'] = !empty($data['bank_account_holder']) ? $this->security->xss_clean($data['bank_account_holder']) : "";
			$data['bank_branch'] = !empty($data['bank_branch']) ? $this->security->xss_clean($data['bank_branch']) : "";
		}
		//ATM Card Number = 3
		if($data['type_payout'] == 3) {
			$data['atm_card_number'] = !empty($data['atm_card_number']) ? $this->security->xss_clean($data['atm_card_number']) : "";
			$data['atm_card_holder'] = !empty($data['atm_card_holder']) ? $this->security->xss_clean($data['atm_card_holder']) : "";
		}
		//Encrypt TripleDes
		$libTripleDes = new TripleDes();
		$secretKey = $libTripleDes->Encrypt(json_encode($data), $this->config->item("TRIPLEDES_KEY"));
		$dataPost = array(
			"type_payout" => $data['type_payout'],
			"order_code" => $data['order_code'],
			"amount" => $data['amount'],
			"bank_id" => $data['bank_id'],
			"description" => $data['description'],
			"bank_account" => !empty($data['bank_account']) ? $data['bank_account'] : "",
			"bank_account_holder" => !empty($data['bank_account_holder']) ? $data['bank_account_holder'] : "",
			"atm_card_number" => !empty($data['atm_card_number']) ? $data['atm_card_number'] : "",
			"atm_card_holder" => !empty($data['atm_card_holder']) ? $data['atm_card_holder'] : "",
			"updated_by" => $this->user['email'],
			"secret_key" => $secretKey,
			"code_contract" =>  !empty($data['code_contract']) ? $data['code_contract'] : "",
			"bank_branch" =>  !empty($data['bank_branch']) ? $data['bank_branch'] : "",
			"disbursement_by" =>  $this->user['email'],
			'percent_interest_investor' =>  !empty($data['percent_interest_investor']) ? $data['percent_interest_investor'] : "",
			'investor_code' => !empty($data['investor_code']) ? $data['investor_code'] : "",
		);
		// goi sang vimo tao giao dich
		$return = $this->api->apiPost($this->user['token'], "PayoutVimo/create_withdrawal", $dataPost);

		if(!empty($return->status) && $return->status == 200){
			//update code contract
			$dataPost = array(
				"code_contract" =>  !empty($data['code_contract']) ? $data['code_contract'] : ""
			);

			$update_code_contract = $this->api->apiPost($this->user['token'], "contract/update_code_contract", $dataPost);
			if(!empty($update_code_contract->status) && $update_code_contract->status == 200){
				$this->pushJson('200', json_encode(array("code" => "200", "data" => $return,"msg" => $this->lang->line('Successful_disbursement_order'))));
			}else {
				$this->pushJson('200', json_encode(array("code" => "401","data" => $return, "msg" => $update_code_contract->message)));
			}

		}else{
			$this->pushJson('200', json_encode(array("code" => "401","data" => $return, "msg" => $return->result->error_description)));
		}
	}

	public function getOne(){
		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		//Get information
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		if($contract->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $contract->data)));
			return;
		}
	}

	public function getInforHeader() {
		$countContracts = $this->api->apiGet($this->userInfo['token'], "contract/get_infor_header");

	}

	public function investorsDisbursement(){
		$data = $this->input->post();
		$data['code_contract'] = $this->security->xss_clean($data['code_contract']);
		$data['investor_code'] = $this->security->xss_clean($data['investor_code']);
		$data['contract_id'] = $this->security->xss_clean($data['contract_id']);

		$data['disbursement_date'] = $this->security->xss_clean($data['disbursement_date']);

		$data['code_transaction_bank_disbursement'] = $this->security->xss_clean($data['code_transaction_bank_disbursement']);
		$data['bank_name'] = $this->security->xss_clean($data['bank_name']);
		$data['content_transfer_disbursement'] = $this->security->xss_clean($data['content_transfer']);

		$percent_interest_investor = $this->security->xss_clean($data['percent_interest_investor']);
		if(empty($data['investor_code'])){
			$investor_id = $this->security->xss_clean($data['investor_id']);
			//case giai ngan qua nha dau tu ngoai khong phải vfc
			$investor = $this->api->apiPost($this->userInfo['token'], "investor/get_one", array('id'=> $investor_id));
			if($investor->status == 200) {
				$percent_interest_investor = $investor->data->percent_interest_investor;
				$data['investor_code'] = $investor->data->code;
			}

		}
		$disbursement_date = !empty($data['disbursement_date']) ? $data['disbursement_date'] : "";
		$dataPost = array(
			"code_contract" => $data['code_contract'],
			"investor_code" => $data['investor_code'],
			"disbursement_date" => !empty($disbursement_date) ? strtotime($disbursement_date) : $this->time_model->convertDatetimeToTimestamp(new DateTime()),
			"secret_key" => "",
		);
//        if(empty($data['code_transaction_bank_disbursement'])) {
//            $data['code_transaction_bank_disbursement'] = "MGD_".substr(md5((string)rand(1, 99999999)), 1,15);
//        }

		$dataUpdate = array(
			"contract_id" =>  $data['contract_id'],
			"percent_interest_investor" =>  $percent_interest_investor,
			"code_transaction_bank_disbursement" => $data['code_transaction_bank_disbursement'],
			"bank_name_disbursement" => $data['bank_name'],
			"content_transfer_disbursement" => $data['content_transfer_disbursement'],
		);

		$update = $this->api->apiPost($this->userInfo['token'], "contract/accountant_investors_disbursement", $dataUpdate);
		if(!empty($update->status)  && $update->status == 200){
			$result = $this->api->apiPost($this->userInfo['token'], "generateContract/processContract", $dataPost);
			if(!empty($result->status) && $result->status == 200){
				$this->pushJson('200', json_encode(array("code" => "200", "msg" => $result->message)));
				return;
			}else{
				$this->pushJson('200', json_encode(array("code" => "401", "msg" => $result->message)));
				return;
			}
		}else{
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $update->message, 'data' => $update )));
			return;
		}

	}
	public function accountantUpload(){
		$this->data["pageName"] = $this->lang->line('update_img_authentication');
		$dataGet = $this->input->get();
		$dataGet['id'] = $this->security->xss_clean($dataGet['id']);
		$dataPost = array(
			"id" => $dataGet['id']
		);
		$result = $this->api->apiPost($this->userInfo['token'], "contract/get_image_accurecy", $dataPost);
		$this->data['result'] = $result->data;
		$this->data['template'] = 'page/pawn/accountant_upload';
		$this->load->view('template', isset($this->data)?$this->data:NULL);
	}



// validate birthday
	function validateAge($birthday, $from = 18,$to=75)
	{
		$today = new DateTime(date("Y-m-d"));
		$bday = new DateTime($birthday);
		$interval = $today->diff($bday);
		if(intval($interval->y) > $from && intval($interval->y) < $to){
			return 'TRUE';
		}else{
			return 'FALSE';
		}
	}


	public function updateDescriptionImage(){
		$data = $this->input->post();
		$data['contractId'] = $this->security->xss_clean($data['contractId']);
		$expertise = array();
		if(!empty($data['expertise'])) $expertise = $this->security->xss_clean($data['expertise']);
		$sendApi = array(
			"id" => $data['contractId'],
			'expertise' => $expertise,
		);
		//Insert log
		$return = $this->api->apiPost($this->user['token'], "contract/process_update_description_img", $sendApi);
		$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
	}
}
?>

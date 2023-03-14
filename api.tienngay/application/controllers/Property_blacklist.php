<?php
include('application/vendor/autoload.php');
include_once APPPATH . '/libraries/LogCI.php';
require_once APPPATH . 'libraries/REST_Controller.php';
require_once APPPATH . 'libraries/CVS.php';

use Restserver\Libraries\REST_Controller;

class Property_blacklist extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('main_property_model');
		$this->load->model('main_approve_property_model');
		$this->load->model('property_log_model');
		$this->load->model('depreciation_property_model');
		$this->load->model('configuration_formality_model');
		$this->load->model('depreciation_model');
		$this->load->model('property_v2_model');
		$this->load->model('property_v3_model');
		$this->load->model('log_property_model');
		$this->load->helper('lead_helper');
		$this->load->model('depreciation_approve_model');
		$this->load->model('depreciation_model');
		$this->load->model('property_request_valuation_model');
		$this->load->model('group_role_model');
		$this->load->model('role_model');
		$this->load->model('log_valuation_property_model');
		$this->load->model('log_approve_property_model');
		$this->load->model('user_model');
		$this->load->model('property_blacklist_model');
		$this->load->model('log_property_blacklist_model');
		$this->load->model('contract_model');
		$this->load->library('LogCI');
		$this->createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		$headers = $this->input->request_headers();
		$this->dataPost = $this->input->post();
		$this->cvs = new CVS();
		$this->flag_login = 1;
		if (!empty($headers['Authorization']) || !empty($headers['authorization'])) {
			$headers_item = !empty($headers['Authorization']) ? $headers['Authorization'] : $headers['authorization'];
			$token = Authorization::validateToken($headers_item);
			if ($token != false) {
				// Kiểm tra tài khoản và token có khớp nhau và có trong db hay không
				$this->app_login = array(
					'_id' => new \MongoDB\BSON\ObjectId($token->id),
					'email' => $token->email,
					"status" => "active",
				);
				//Web
				if ($this->dataPost['type'] == 1) $this->app_login['token_web'] = $headers_item;
				if ($this->dataPost['type'] == 2) $this->app_login['token_app'] = $headers_item;
				$count_account = $this->user_model->count($this->app_login);
				$this->flag_login = 'success';
				if ($count_account != 1) $this->flag_login = 2;
				if ($count_account == 1) {
					$this->info = $this->user_model->findOne($this->app_login);
					$this->id = $this->info['_id'];
					$this->uemail = $this->info['email'];
				}
			}
		}
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	//danh sách yêu cầu blacklist
	public function propertyBlacklist_post()
	{
		$data = $this->input->post();
		$condition = [];
		$property = !empty($data['property']) ? $data['property'] : '';
		$hang_xe = !empty($data['hang_xe']) ? $data['hang_xe'] : '';
		$status = !empty($data['status_blacklist']) ? $data['status_blacklist'] : '';

		$per_page = !empty($data['per_page']) ? $data['per_page'] : 30;
		$uriSegment = !empty($data['uriSegment']) ? $data['uriSegment'] : 0;

		$condition['property'] = $property;
		$condition['hang_xe'] = !empty($hang_xe) ? slugify($hang_xe) : '';
		$condition['status_blacklist'] = $status;
		$userDG = $this->get_role_bo_phan_dinh_gia();
		if (!in_array($this->uemail, $userDG)) {
			$condition['user'] = $this->uemail;
		} else {
			$condition['user'] = "";
		}
		$list = $this->property_blacklist_model->getRequestBlacklistProperty($condition, $per_page, $uriSegment);
		$condition['total'] = true;
		$total = $this->property_blacklist_model->getRequestBlacklistProperty($condition, $per_page, $uriSegment);
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'ok',
			'data' => $list,
			'total' => $total
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

// danh sách blacklist tài sản
	public function blacklist_post()
	{
		$data = $this->input->post();
		$condition = [];
		$from_date = !empty($data['from_date']) ? $data['from_date'] : '';
		$to_date = !empty($data['to_date']) ? $data['to_date'] : '';
		$property = !empty($data['property']) ? $data['property'] : '';
		$hang_xe = !empty($data['hang_xe']) ? $data['hang_xe'] : '';
		$bien_so_xe = !empty($data['bien_so_xe']) ? $data['bien_so_xe'] : '';
		$so_khung = !empty($data['so_khung']) ? $data['so_khung'] : '';
		$so_may = !empty($data['so_may']) ? $data['so_may'] : '';
		$phone = !empty($data['phone']) ? $data['phone'] : '';
		$identify_passport = !empty($data['identify_passport']) ? $data['identify_passport'] : '';
		$per_page = !empty($data['per_page']) ? $data['per_page'] : 30;
		$uriSegment = !empty($data['uriSegment']) ? $data['uriSegment'] : 0;
		$condition = array();
		if (!empty($from_date) && !empty($to_date)) {
			$condition = [
				'from_date' => strtotime(trim($from_date) . ' 00:00:00'),
				'to_date' => strtotime(trim($to_date) . ' 23:59:59'),
			];
		}

		$condition['property'] = $property;
		$condition['hang_xe'] = !empty($hang_xe) ? slugify($hang_xe) : '';
		$condition['bien_so_xe'] = $bien_so_xe;
		$condition['so_khung'] = $so_khung;
		$condition['so_may'] = $so_may;
		$condition['phone'] = $phone;
		$condition['identify_passport'] = $identify_passport;
		$list = $this->property_blacklist_model->getBlacklistProperty($condition, $per_page, $uriSegment);
		$condition['total'] = true;
		$total = $this->property_blacklist_model->getBlacklistProperty($condition, $per_page, $uriSegment);
		$userDG = $this->get_role_bo_phan_dinh_gia();
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'ok',
			'data' => $list,
			'total' => $total,
			'userDG' => $userDG
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	//tạo yêu cầu
	public function requestProperty_post()
	{
		$data = $this->input->post();
		$property = !empty($data['property']) ? $data['property'] : '';
		$brand_property = !empty($data['brand_property']) ? $data['brand_property'] : '';
		$id_property = !empty($data['id_property']) ? $data['id_property'] : '';
		$front_registration_img = !empty($data['front_registration_img']) ? $data['front_registration_img'] : '';
		$back_registration_img = !empty($data['back_registration_img']) ? $data['back_registration_img'] : '';
		$front_regis_car_img = !empty($data['front_regis_car_img']) ? $data['front_regis_car_img'] : '';
		$back_regis_car_img = !empty($data['back_regis_car_img']) ? $data['back_regis_car_img'] : '';
		$image_tai_san = !empty($data['image_tai_san']) ? $data['image_tai_san'] : '';
		$url = !empty($data['url']) ? $data['url'] : '';
		$url_item = !empty($data['url_item']) ? $data['url_item'] : "";
		$message = $this->validateCreateRequestBlacklist($data);
		if (count($message) > 0) {
			$response = array(
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => $message[0],
				'key' => $data['key']
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		$customer = [
			'name' => '',
			'identify' => '',
			'phone' => '',
		];
		$dataInsertRegistration['front_img'] = $front_registration_img;
		$dataInsertRegistration['back_img'] = $back_registration_img;
		$dataInsertRegisCar['front_img'] = $front_regis_car_img;
		$dataInsertRegisCar['back_img'] = $back_regis_car_img;
		$dataPost = [
			'code' => $property,
			'brand_name' => $brand_property,
			'property_id' => $id_property,
			'slug_brand_name' => slugify($brand_property),
			'customer_infor' => $customer,
			'status' => 1, //chờ xem xét
			'image_registration' => $dataInsertRegistration,
			'image_certificate' => $dataInsertRegisCar,
			'image_property' => $image_tai_san,
			'created_at' => $this->createdAt,
			'created_by' => $this->uemail
		];
		$id = $this->property_blacklist_model->insertReturnId($dataPost);
		$dataEmail = [
			'code' => $property,
			'hang_xe' => $brand_property,
			'url' => $url,
			'url_item' => $url_item . '?id=' . $id,
			'created_by' => $this->uemail
		];
		$this->sendEmailRequestToBPDG($dataEmail);
		$dataLog = [
			'property_id' => (string)$id,
			'type' => 'create',
			'data' => $dataPost,
			'created_at' => $this->createdAt,
			'created_by' => $this->uemail
		];
		$this->log_property_blacklist_model->insert($dataLog);
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'ok',
			'data' => $dataPost
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	//hủy yêu cầu
	public function cancelRequesProperty_post()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : '';
		$property = $this->property_blacklist_model->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
		$url = !empty($data['url']) ? $data['url'] : '';
		$url_item = !empty($data['url_item']) ? $data['url_item'] : "";
		if (!empty($property)) {
			$this->property_blacklist_model->update(['_id' => new MongoDB\BSON\ObjectId($id)],
				[
					'status' => 200, //hủy
					'updated_at' => $this->createdAt,
					'updated_by' => $this->uemail
				]
			);
		}
		$dataEmail = [
			'code' => $property['code'],
			'hang_xe' => $property['brand_name'],
			'url' => $url,
			'url_item' => $url_item,
			'created_by' => $property['created_by']
		];
		$this->sendEmailCancelRequest($dataEmail);
		$dataLog = [
			'property_id' => (string)$id,
			'type' => 'cancel',
			'data' => $property,
			'created_at' => $this->createdAt,
			'created_by' => $this->uemail,
		];
		$this->log_property_blacklist_model->insert($dataLog);
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'ok',
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	//trả về yêu cầu
	public function feedbackRequestProperty_post()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : '';
		$note = !empty($data['note']) ? $data['note'] : '';
		$url = !empty($data['url']) ? $data['url'] : '';
		$url_item = !empty($data['url_item']) ? $data['url_item'] : "";
		if (empty($note)) {
			$response = array(
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => "Note đang để trống",
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		if (!empty($id)) {
			$this->property_blacklist_model->update(['_id' => new \MongoDB\BSON\ObjectId($id)],
				[
					'note' => $note,
					'status' => 3, //trả về
					'updated_at' => $this->createdAt,
					'updated_by' => $this->uemail
				]
			);
			$property = $this->property_blacklist_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);
		}
		$dataEmail = [
			'code' => $property['code'],
			'hang_xe' => $property['brand_name'],
			'note' => $note,
			'url' => $url,
			'url_item' => $url_item,
			'created_by' => $property['created_by']
		];
		$this->sendEmailNoteRequest($dataEmail);
		$dataLog = [
			'property_id' => (string)$id,
			'type' => 'note',
			'data' => $property,
			'created_at' => $this->createdAt,
			'created_by' => $this->uemail,
		];
		$this->log_property_blacklist_model->insert($dataLog);
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'ok',
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	//check tài sản giả
	public function checkFakeRequestProperty_post()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : '';
		$bien_so_xe = !empty($data['bien_so_xe']) ? $data['bien_so_xe'] : '';
		$so_khung = !empty($data['so_khung']) ? $data['so_khung'] : '';
		$so_may = !empty($data['so_may']) ? $data['so_may'] : '';
		$registration_number = !empty($data['so_dang_ky']) ? $data['so_dang_ky'] : '';
		$registration_date = !empty($data['ngay_cap_dang_ky']) ? $data['ngay_cap_dang_ky'] : '';
		$registration_place = !empty($data['noi_cap_dang_ky']) ? $data['noi_cap_dang_ky'] : '';
		$inspection_number = !empty($data['so_dang_kiem']) ? $data['so_dang_kiem'] : '';
		$inspection_date = !empty($data['ngay_cap_dang_kiem']) ? $data['ngay_cap_dang_kiem'] : '';
		$inspection_place = !empty($data['noi_cap_dang_kiem']) ? $data['noi_cap_dang_kiem'] : '';
		$name = !empty($data['name']) ? $data['name'] : '';
		$description = !empty($data['description']) ? $data['description'] : '';
		$url = !empty($data['url']) ? $data['url'] : '';
		$url_item = !empty($data['url_item']) ? $data['url_item'] : "";
		$loai_xe = !empty($data['loai_xe']) ? $data['loai_xe'] : "";
		$message = $this->validateCreateBlacklist($data);
		if (count($message) > 0) {
			$response = array(
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => $message[0],
				'key' => $data['key']
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		$customer_infor = [
			'name' => $name,
			'identify' => '',
			'phone' => ''
		];
		$registration = [
			'number' => $registration_number,
			'date_range' => $registration_date,
			'issued_by' => $registration_place
		];
		$inspection = [
			'number' => $inspection_number,
			'date_range' => $inspection_date,
			'issued_by' => $inspection_place
		];
		$this->property_blacklist_model->update(['_id' => new MongoDB\BSON\ObjectId($id)],
			[
				'customer_infor' => $customer_infor,
				'registration' => $registration,
				'inspection' => $inspection,
				'chassis_number' => $so_khung,
				'engine_number' => $so_may,
				'vehicle_number' => $bien_so_xe,
				'description' => $description,
				'status' => 'active', //tài sản giả vào blacklist
				'updated_at' => $this->createdAt,
				'updated_by' => $this->uemail,
				'scan' => 1, // chưa scan
			]);
		$property = $this->property_blacklist_model->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
		$dataEmail = [
			'code' => $property['code'],
			'hang_xe' => $property['brand_name'],
			'name' => $property['customer_infor']['name'],
			'so_may' => $property['engine_number'],
			'so_khung' => $property['chassis_number'],
			'bien_so_xe' => $property['vehicle_number'],
			'description' => $property['description'],
			'url' => $url,
			'url_item' => $url_item,
			'created_by' => $property['created_by']
		];
		$this->sendEmailCheckFakeProperty($dataEmail);
		$dataLog = [
			'property_id' => (string)$id,
			'type' => 'check_fake_property',
			'data' => $property,
			'created_at' => $this->createdAt,
			'created_by' => $this->uemail,
		];
		$this->log_property_blacklist_model->insert($dataLog);
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'ok',
			'data' => $property
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	//tài sản thật
	public function checkRealRequestProperty_post()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : '';
		$url = !empty($data['url']) ? $data['url'] : '';
		$url_item = !empty($data['url_item']) ? $data['url_item'] : "";
		$this->property_blacklist_model->update(['_id' => new MongoDB\BSON\ObjectId($id)],
			[
				'status' => 4,//thật
				'updated_at' => $this->createdAt,
				'updated_by' => $this->uemail
			]);
		$property = $this->property_blacklist_model->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
		$dataEmail = [
			'code' => $property['code'],
			'hang_xe' => $property['brand_name'],
			'url' => $url,
			'url_item' => $url_item,
			'created_by' => $property['created_by']
		];
		$this->sendEmailCheckRealProperty($dataEmail);
		$dataLog = [
			'property_id' => (string)$id,
			'type' => 'check_real_property',
			'data' => $property,
			'created_at' => $this->createdAt,
			'created_by' => $this->uemail,
		];
		$this->log_property_blacklist_model->insert($dataLog);
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'ok',
			'data' => $property
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	//update yêu cầu để vào blacklist
	public function updateRequestBlacklist_post()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : '';
		$identify = !empty($data['identify']) ? $data['identify'] : '';
		$passport = !empty($data['passport']) ? $data['passport'] : '';
		$date = !empty($data['ngay_cap']) ? $data['ngay_cap'] : '';
		$issued_by = !empty($data['noi_cap']) ? $data['noi_cap'] : '';
		$phone = !empty($data['phone']) ? $data['phone'] : '';
		$name = !empty($data['name']) ? $data['name'] : '';
		$loai_xe = !empty($data['loai_xe']) ? $data['loai_xe'] : '';
		$url = !empty($data['url']) ? $data['url'] : '';
		$url_item = !empty($data['url_item']) ? $data['url_item'] : '';
		$front_registration_img = !empty($data['front_registration_img']) ? $data['front_registration_img'] : '';
		$back_registration_img = !empty($data['back_registration_img']) ? $data['back_registration_img'] : '';
		$front_regis_car_img = !empty($data['front_regis_car_img']) ? $data['front_regis_car_img'] : '';
		$back_regis_car_img = !empty($data['back_regis_car_img']) ? $data['back_regis_car_img'] : '';
		$image_tai_san = !empty($data['image_tai_san']) ? $data['image_tai_san'] : '';

		$message = $this->validateAddDataToBlacklist($data);
		if (count($message) > 0) {
			$response = array(
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => $message[0],
				'key' => $data['key']
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		$property = $this->property_blacklist_model->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);

		$customer = [
			'name' => $property['customer_infor']['name'],
			'car_owner' => $name,
			'identify' => $identify,
			'passport' => $passport,
			'phone' => $phone,
			'date_range' => $date,
			'issued_by' => $issued_by
		];
		$dataInsertRegistration['front_img'] = $front_registration_img;
		$dataInsertRegistration['back_img'] = $back_registration_img;
		$dataInsertRegisCar['front_img'] = $front_regis_car_img;
		$dataInsertRegisCar['back_img'] = $back_regis_car_img;
		$array_update = [
			'customer_infor' => $customer,
			'status' => 'active',
			'image_property' => $image_tai_san,
			'image_registration' => $dataInsertRegistration,
			'image_certificate' => $dataInsertRegisCar,
			'scan' => 1,
			'updated_at' => $this->createdAt,
			'updated_by' => $this->uemail
		];
		if (empty($front_registration_img) || empty($back_registration_img)) {
			unset($array_update['image_registration']);
		}
		if (empty($front_regis_car_img) || empty($back_regis_car_img)) {
			unset($array_update['image_certificate']);
		}
		$this->property_blacklist_model->update(['_id' => new MongoDB\BSON\ObjectId($id)],$array_update);
		$property1 = $this->property_blacklist_model->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
		$dataEmail = [
			'code' => $property1['code'],
			'identify' => !empty($identify) ? $identify : $passport,
			'phone' => $phone,
			'hang_xe' => $property1['brand_name'],
			'so_may' => $property1['engine_number'],
			'so_khung' => $property1['chassis_number'],
			'bien_so_xe' => $property1['vehicle_number'],
			'created_by' => $property1['created_by'],
			'url' => $url,
			'url_item' => $url_item
		];
		$this->sendEmailToBPDGAfterUpdateBlacklist($dataEmail);
		$dataLog = [
			'property_id' => (string)$id,
			'type' => 'update_request_blacklist',
			'data' => $property1,
			'created_at' => $this->createdAt,
			'created_by' => $this->uemail,
		];
		$this->log_property_blacklist_model->insert($dataLog);
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'ok',
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	//update sau khi note
	public function updateAfterFeedbackBlacklist_post()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : '';
		$loai_xe = !empty($data['loai_xe']) ? $data['loai_xe'] : '';
		$brand_property = !empty($data['brand_property']) ? $data['brand_property'] : "";
		$id_property = !empty($data['id_property']) ? $data['id_property'] : "";
		$front_registration_img = !empty($data['front_registration_img']) ? $data['front_registration_img'] : '';
		$back_registration_img = !empty($data['back_registration_img']) ? $data['back_registration_img'] : '';
		$front_regis_car_img = !empty($data['front_regis_car_img']) ? $data['front_regis_car_img'] : '';
		$back_regis_car_img = !empty($data['back_regis_car_img']) ? $data['back_regis_car_img'] : '';
		$image_tai_san = !empty($data['image_tai_san']) ? $data['image_tai_san'] : '';
		$url = !empty($data['url']) ? $data['url'] : '';
		$url_item = !empty($data['url_item']) ? $data['url_item'] : '';
		$message = $this->validateUpdateAfterFeedbackBlacklist($data);
		if (count($message) > 0) {
			$response = array(
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => $message[0],
				'key' => $data['key']
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		$customer = [
			'name' => '',
			'identify' => "",
			'phone' => ""
		];
		$dataInsertRegistration['front_img'] = $front_registration_img;
		$dataInsertRegistration['back_img'] = $back_registration_img;
		$dataInsertRegisCar['front_img'] = $front_regis_car_img;
		$dataInsertRegisCar['back_img'] = $back_regis_car_img;
		$array_update = [
			'status' => 1,
			'brand_name' => $brand_property,
			'property_id' => $id_property,
			'slug_brand_name' => slugify($brand_property),
			'code' => $loai_xe,
			'image_property' => $image_tai_san,
			'image_registration' => $dataInsertRegistration,
			'image_certificate' => $dataInsertRegisCar,
			'customer_infor' => $customer,
			'updated_at' => $this->createdAt,
			'updated_by' => $this->uemail,
		];
		if (empty($front_registration_img) || empty($back_registration_img)) {
			unset($array_update['image_registration']);
		}
		if (empty($front_regis_car_img) || empty($back_regis_car_img)) {
			unset($array_update['image_certificate']);
		}
		if (empty($brand_property)) {
			unset($array_update['brand_name']);
		}
		if (empty($id_property)) {
			unset($array_update['property_id']);
		}
		$this->property_blacklist_model->update(['_id' => new MongoDB\BSON\ObjectId($id)], $array_update);

		$property = $this->property_blacklist_model->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
		$dataEmail = [
			'code' => $property['code'],
			'hang_xe' => $property['brand_name'],
			'url' => $url,
			'url_item' => $url_item,
			'created_by' => $property['created_by']
		];
		$this->sendEmailRequestToBPDG($dataEmail);
		$dataLog = [
			'property_id' => (string)$id,
			'type' => 'update_feedback',
			'data' => $property,
			'created_at' => $this->createdAt,
			'created_by' => $this->uemail,
		];
		$this->log_property_blacklist_model->insert($dataLog);

		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'ok',
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	//tạo yêu cầu update cho người yêu cầu
	public function createRequestUpdateBlacklist_post()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : '';
		$updateDescription = !empty($data['updateDescription']) ? $data['updateDescription'] : "";
		$url = !empty($data['url']) ? $data['url'] : '';
		$url_item = !empty($data['url_item']) ? $data['url_item'] : "";
		$this->property_blacklist_model->update(['_id' => new MongoDB\BSON\ObjectId($id)], [
			'status' => 2,
			'update_description' => $updateDescription,
			'updated_by' => $this->uemail,
			'updated_at' => $this->createdAt
		]);
		$property = $this->property_blacklist_model->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
		$dataEmail = [
			'code' => $property['code'],
			'hang_xe' => $property['brand_name'],
			'name' => $property['customer_infor']['name'],
			'url' => $url,
			'url_item' => $url_item,
			'update_description' => $property['update_description'],
			'chassis_number' => $property['chassis_number'],
			'engine_number' => $property['engine_number'],
			'vehicle_number' => $property['vehicle_number'],
			'created_by' => $property['created_by']
		];
		$this->sendEmailRequestUpdateBlacklist($dataEmail);
		$dataLog = [
			'property_id' => (string)$id,
			'type' => "request_update",
			'data' => $property,
			'created_at' => $this->createdAt,
			'created_by' => $this->uemail,
		];
		$this->log_property_blacklist_model->insert($dataLog);
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'ok',

		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function updateRequestProperty_post()
	{
		$data = $this->input->post();
		$dataLog = [];
		$id = !empty($data['id']) ? $data['id'] : '';
		$property = !empty($data['property']) ? $data['property'] : '';
		$hang_xe = !empty($data['hang_xe']) ? $data['hang_xe'] : '';
		$bien_so_xe = !empty($data['bien_so_xe']) ? $data['bien_so_xe'] : '';
		$so_khung = !empty($data['so_khung']) ? $data['so_khung'] : '';
		$so_may = !empty($data['so_may']) ? $data['so_may'] : '';
		$ten_chu_xe = !empty($data['ten_chu_xe']) ? $data['ten_chu_xe'] : '';
		$phone = !empty($data['phone']) ? $data['phone'] : '';
		$identify = !empty($data['identify']) ? $data['identify'] : '';
		$path = !empty($data['path']) ? $data['path'] : '';
		$message = $this->validateUpdateBlacklist($data);
		if (count($message) > 0) {
			$response = array(
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => $message[0],
				'key' => $data['key']
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		$property_log = $this->property_blacklist_model->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
		$dataLog['old_data'] = $property_log;
		$dataUpdate = [
			'code' => $property,
			'brand_name' => $hang_xe,
			'slug_brand_name' => slugify($hang_xe),
			'vehicle_number' => $bien_so_xe,
			'chassis_number' => $so_khung,
			'engine_number' => $so_may,
			'car_owner' => $ten_chu_xe,
			'phone' => $phone,
			'identify_card' => $identify,
			'path' => $path,
			'updated_at' => $this->createdAt,
			'updated_by' => $this->uemail
		];
		$this->property_blacklist_model->update(['_id' => new MongoDB\BSON\ObjectId($id)], [
			'code' => $property,
			'brand_name' => $hang_xe,
			'slug_brand_name' => slugify($hang_xe),
			'vehicle_number' => $bien_so_xe,
			'chassis_number' => $so_khung,
			'engine_number' => $so_may,
			'car_owner' => $ten_chu_xe,
			'phone' => $phone,
			'identify_card' => $identify,
			'path' => $path,
			'updated_at' => $this->createdAt,
			'updated_by' => $this->uemail
		]);
		$dataLog['data'] = $dataUpdate;
		$dataLog['type'] = 'update';
		$dataLog['created_at'] = $tis->createdAt;
		$dataLog['created_by'] = $this->uemail;
		$this->log_property_blacklist_model->insert($dataLog);
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'ok',
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function validateCreateRequestBlacklist($data)
	{
		$message = [];
		if (empty($data['property'])) {
			$message[] = 'Bạn chưa chọn loại tài sản!';
		}
		if (empty($data['brand_property'])) {
			$message[] = 'Bạn chưa chọn hãng xe!';
		}
		if (empty($data['front_registration_img'])) {
			$message[] = 'Bạn chưa upload ảnh đăng ký xe mặt trước!';
		}
		if (empty($data['back_registration_img'])) {
			$message[] = 'Bạn chưa upload ảnh đăng ký xe mặt sau!';
		}
		if (empty($data['front_regis_car_img']) && $data['property'] == 'OTO') {
			$message[] = 'Bạn chưa upload ảnh đăng kiểm xe mặt trước!';
		}
		if (empty($data['back_regis_car_img']) && $data['property'] == 'OTO') {
			$message[] = 'Bạn chưa upload ảnh đăng kiểm xe mặt sau!';
		}
		return $message;
	}

	//validate cập nhật dữ liệu vào blacklist
	public function validateCreateBlacklist($data)
	{

		$so_khung = $data['so_khung'];
		$so_may = $data['so_may'];
		$bien_so_xe = $data['bien_so_xe'];
		$so_dang_ky = $data['so_dang_ky'];
		$so_dang_kiem = $data['so_dang_kiem'];
		$loai_xe = $data['loai_xe'];
		$so_khung_duplicate = $this->property_blacklist_model->findOne(['chassis_number' => $so_khung]);
		$so_may_duplicate = $this->property_blacklist_model->findOne(['engine_number' => $so_may]);
		$bien_so_xe_duplicate = $this->property_blacklist_model->findOne(['vehicle_number' => $bien_so_xe]);
		$so_dang_ky_duplicate = $this->property_blacklist_model->findOne(['registration.number' => $so_dang_ky]);
		$so_dang_kiem_duplicate = $this->property_blacklist_model->findOne(['inspection.number' => $so_dang_kiem]);
		$message = [];


		if (empty($data['name'])) {
			$message[] = 'Tên chủ xe đang trống!';
		}
		if (empty($data['so_khung'])) {
			$message[] = 'Số khung xe đang trống!';
		}
		if (empty($data['so_may'])) {
			$message[] = 'Số máy đang trống!';
		}
		if (empty($data['bien_so_xe'])) {
			$message[] = 'Biển số xe đang trống!';
		}
		if (!empty($data['bien_so_xe'])) {
			if ($loai_xe == 'OTO') {
				if (!preg_match("/^([0-9A-Z]{3,4}-[0-9]{3}[\.][0-9]{1,2})$/", $data['bien_so_xe'])) {
					$message[] = 'Biển số xe không đúng định dạng xxxx-xxx.xx!';
				}
			} else {
				if (!preg_match("/^([0-9A-Z]{4}-[0-9]{3}[\.][0-9]{1,2})$/", $data['bien_so_xe'])) {
					$message[] = 'Biển số xe không đúng định dạng xxxx-xxx.xx!';
				}
			}
		}
		if (empty($data['so_dang_ky'])) {
			$message[] = 'Số đăng ký đang trống!';
		}
		if (empty($data['ngay_cap_dang_ky'])) {
			$message[] = 'Ngày cấp đăng ký đang trống!';
		}
		if (empty($data['noi_cap_dang_ky'])) {
			$message[] = 'Nơi cấp đăng ký đang trống!';
		}
		if (empty($data['so_dang_kiem']) && $loai_xe == "OTO") {
			$message[] = 'Số đăng kiểm đang trống!';
		}
		if (empty($data['ngay_cap_dang_kiem']) && $loai_xe == "OTO") {
			$message[] = 'Ngày cấp đăng kiểm đang trống!';
		}
		if (empty($data['noi_cap_dang_kiem']) && $loai_xe == "OTO") {
			$message[] = 'Nơi cấp đăng kiểm đang trống!';
		}
		if (!empty($so_khung_duplicate)) {
			$message[] = 'Số khung đã tồn tại!';
		}
		if (!empty($so_may_duplicate)) {
			$message[] = 'Số máy đã tồn tại!';
		}
		if (!empty($bien_so_xe_duplicate)) {
			$message[] = 'Biển số xe đã tồn tại!';
		}
		if (!empty($so_dang_ky_duplicate)) {
			$message[] = 'Số đăng ký đã tồn tại!';
		}
		if (!empty($so_dang_kiem_duplicate) && $loai_xe == "OTO") {
			$message[] = 'Số đăng kiểm đã tồn tại!';
		}

		return $message;

	}

	public function validateAddDataToBlacklist($data)
	{
		$message = [];
		$id = $data['id'];
		$identify = $data['identify'];
		$phone = $data['phone'];
		$passport = $data['passport'];
		$ngay_cap = $data['ngay_cap'];
		$noi_cap = $data['noi_cap'];
		$identify_validate = $this->checkExistIdentify($id, $identify);
		$passpost_validate = $this->checkExistPassport($id, $passport);

		if (empty($identify) && empty($passport)) {
			$message[] = 'CCCD/CMND/Hộ chiếu đang trống!';
		}
		if (empty($phone)) {
			$message[] = 'Số điện thoại đang trống!';
		}
		if (empty($ngay_cap)) {
			$message[] = 'Ngày cấp đang trống!';
		}
		if (empty($noi_cap)) {
			$message[] = 'Nơi cấp đang trống!';
		}
		if (!empty($identify_validate) && empty($passport)) {
			$message[] = 'CCCD/CMND đã tồn tại!';
		}
		if (!empty($passpost_validate) && empty($identify)) {
			$message[] = 'Hộ chiếu đã tồn tại!';
		}
		if (!preg_match('/^0[1-9][0-9]{8}$/', $phone)) {
			$message[] = "Số điện thoại phải bắt đầu bằng số 0 và đúng định dạng 10 số";
		}
		if (!preg_match('/^[A-Z][0-9]{7}$/', $passport) && empty($identify)) {
			$message[] = "Hộ chiếu phải bắt đầu bằng chữ in hoa và 7 số";
		}
		if (!preg_match("/^([0-9]{9}|[0-9]{12})$/", $identify) && empty($passport)) {
			$message[] = "CCCD/CMND phải đúng định dạng 9 hoặc 12 số";
		}
		if (!empty($data['front_registration_img'])) {
			if (empty($data['back_registration_img'])) {
				$message[] = "Bạn chưa tải lên ảnh đăng ký xe/cavet mặt sau";
			}
		}
		if (!empty($data['back_registration_img'])) {
			if (empty($data['front_registration_img'])) {
				$message[] = "Bạn chưa tải lên ảnh đăng ký xe/cavet mặt trước";
			}
		}
		if (!empty($data['front_regis_car_img'])) {
			if (empty($data['back_regis_car_img'])) {
				$message[] = "Bạn chưa tải lên ảnh đăng kiểm xe mặt sau";
			}
		}
		if (!empty($data['back_regis_car_img'])) {
			if (empty($data['front_regis_car_img'])) {
				$message[] = "Bạn chưa tải lên ảnh đăng kiểm xe mặt trước";
			}
		}
		return $message;
	}

	public function validateUpdateAfterFeedbackBlacklist($data)
	{
		$message = [];
		if (empty($data['brand_property'])) {
			$message[] = 'Bạn chưa chọn hãng xe!';
		}
		if (!empty($data['front_registration_img'])) {
			if (empty($data['back_registration_img'])) {
				$message[] = "Bạn chưa tải lên ảnh đăng ký xe/cavet mặt sau";
			}
		}
		if (!empty($data['back_registration_img'])) {
			if (empty($data['front_registration_img'])) {
				$message[] = "Bạn chưa tải lên ảnh đăng ký xe/cavet mặt trước";
			}
		}
		if (!empty($data['front_regis_car_img'])) {
			if (empty($data['back_regis_car_img'])) {
				$message[] = "Bạn chưa tải lên ảnh đăng kiểm xe mặt sau";
			}
		}
		if (!empty($data['back_regis_car_img'])) {
			if (empty($data['front_regis_car_img'])) {
				$message[] = "Bạn chưa tải lên ảnh đăng kiểm xe mặt trước";
			}
		}
		return $message;
	}

	public function validateUpdateBlacklist($data)
	{
		$message = [];
		$id = $data['id'];
		$identify = $data['identify'];
		$so_khung = $data['so_khung'];
		$so_may = $data['so_may'];
		$bien_so_xe = $data['bien_so_xe'];
//		$identify_validate = $this->checkExistIdentify($id, $identify);
//		$bien_so_xe_validate = $this->checkExistVehicleNumber($id, $bien_so_xe);
//		$so_khung_validate = $this->checkExistChassisNumber($id, $so_khung);
//		$so_may_validate = $this->checkExistEngineNumber($id, $so_may);

//		if ($identify_validate) {
//			$message[] = 'Căn cước đã tồn tại!';
//		}
//		if ($bien_so_xe_validate) {
//			$message[] = 'Biển số xe đã tồn tại!';
//		}
//		if ($so_khung_validate) {
//			$message[] = 'Số khung đã tồn tại!';
//		}
//		if ($so_may_validate) {
//			$message[] = 'Số máy đã tồn tại!';
//		}
		if (empty($data['property'])) {
			$message[] = 'Loại xe đang trống!';
		}
		if (empty($data['hang_xe'])) {
			$message[] = 'Hãng xe đang trống!';
		}
		if (empty($data['so_khung'])) {
			$message[] = 'Số khung xe đang trống!';
		}
		if (empty($data['so_may'])) {
			$message[] = 'Số máy đang trống!';
		}
		if (empty($data['bien_so_xe'])) {
			$message[] = 'Biển số xe đang trống!';
		}
		if (empty($data['ten_chu_xe'])) {
			$message[] = 'Tên chủ xe đang trống!';
		}
		if (empty($data['phone'])) {
			$message[] = 'Số điện thoại đang trống!';
		}
		if (empty($data['identify'])) {
			$message[] = 'CCCD/CMND đang trống!';
		}
		if (empty($data['path'])) {
			$message[] = 'Ảnh tài sản đang trống!';
		}

		return $message;

	}

	public function detailRequestProperty_post()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : '';
		$property = $this->property_blacklist_model->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
		$userDG = $this->get_role_bo_phan_dinh_gia();
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'ok',
			'data' => $property,
			'userDG' => $userDG,
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function deleteRequestProperty_post()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : '';
		$dataLog = [];
		$property = $this->property_blacklist_model->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
		$dataLog = [
			'property_id' => $id,
			'type' => 'delete',
			'data' => $property,
			'created_at' => $this->createdAt,
			'created_by' => $this->uemail
		];
		$this->log_property_blacklist_model->insert($dataLog);
		$this->property_blacklist_model->delete(['_id' => new MongoDB\BSON\ObjectId($id)]);
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'ok',
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;


	}

	public function checkExistIdentify($id, $identify)
	{
		$record = NULL;
		if ($id) {
			$record = $this->property_blacklist_model->find_where(['customer_infor.identify' => $identify, '_id' => ['$ne' => new MongoDB\BSON\ObjectId($id)]]);
		} else {
			$record = $this->property_blacklist_model->find_where(['customer_infor.identify' => $identify]);
		}
		if ($record) {
			return true;
		} else {
			return false;
		}
	}

	public function checkExistPassport($id, $passport)
	{
		$record = NULL;
		if ($id) {
			$record = $this->property_blacklist_model->find_where(['customer_infor.passport' => $passport, '_id' => ['$ne' => new MongoDB\BSON\ObjectId($id)]]);
		} else {
			$record = $this->property_blacklist_model->find_where(['customer_infor.passport' => $passport]);
		}
		if ($record) {
			return true;
		} else {
			return false;
		}
	}

	public function checkExistChassisNumber($id, $chassis_number)
	{
		$record = NULL;
		if ($id) {
			$record = $this->property_blacklist_model->find_where(['chassis_number' => $chassis_number, '_id' => ['$ne' => new MongoDB\BSON\ObjectId($id)]]);
		} else {
			$record = $this->property_blacklist_model->find_where(['chassis_number' => $chassis_number]);
		}
		if ($record) {
			return true;
		} else {
			return false;
		}
	}

	public function checkExistEngineNumber($id, $engine_number)
	{
		$record = NULL;
		if ($id) {
			$record = $this->property_blacklist_model->find_where(['engine_number' => $engine_number, '_id' => ['$ne' => new MongoDB\BSON\ObjectId($id)]]);
		} else {
			$record = $this->property_blacklist_model->find_where(['engine_number' => $engine_number]);
		}
		if ($record) {
			return true;
		} else {
			return false;
		}
	}

	public function checkExistVehicleNumber($id, $vehicle_number)
	{
		$record = NULL;
		if ($id) {
			$record = $this->property_blacklist_model->find_where(['vehicle_number' => $vehicle_number, '_id' => ['$ne' => new MongoDB\BSON\ObjectId($id)]]);
		} else {
			$record = $this->property_blacklist_model->find_where(['vehicle_number' => $vehicle_number]);
		}
		if ($record) {
			return true;
		} else {
			return false;
		}
	}

	public function get_role_bo_phan_dinh_gia()
	{
		$data = [];
		$user = $this->group_role_model->findOne(['slug' => 'bo-phan-dinh-gia']);
		foreach ($user['users'] as $item) {
			foreach ($item as $i) {
				array_push($data, $i['email']);
			}
		}
		return $data;
	}

	//gửi email yêu cầu đến bộ phận định giá
	public function sendEmailRequestToBPDG($data)
	{
		if ($data['code'] == 'XM') {
			$type_xm_oto = 'Xe máy';
		} elseif ($data['code'] == "OTO") {
			$type_xm_oto = 'Ô tô';
		}
		$hang_xe = $data['hang_xe'];
		$code = 'send_email_request_blacklist';
		$url = $data['url'];
		$url_item = $data['url_item'];
		$createdBy = $data['created_by'];
		$userBPDG = $this->get_role_bo_phan_dinh_gia();
		try {
			$dataEmail = [
				'code' => $code,
				'url' => $url,
				'url_item' => $url_item,
				'brand' => $hang_xe,
				'type_xm_oto' => $type_xm_oto,
				'user' => $createdBy
			];
			LogCI::message('blacklist_property', 'dataEmail: ' . print_r($dataEmail, true));
			$user_email = [
				'dinhgia@tienngay.vn'
			];

			// $dataEmail['user_email'] = $user_nv;
			foreach ($user_email as $key => $value) {
				if ($value == "ngochtm@tienngay.vn") {
					continue;
				}
				$dataEmail['email'] = $value;
				$result = $this->user_model->send_Email($dataEmail);
			}
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'message' => "Gửi email thành công"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		} catch (Exception $e) {
			$response = array(
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => "Gửi email thất bại"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

	}

	//gửi email hủy yêu cầu
	public function sendEmailCancelRequest($data)
	{
		if ($data['code'] == 'XM') {
			$type_xm_oto = 'Xe máy';
		} elseif ($data['code'] == "OTO") {
			$type_xm_oto = 'Ô tô';
		}
		$hang_xe = $data['hang_xe'];
		$loai_xe = $data['code'];
		$code = 'send_email_cancel_request_blacklist';
		$url = $data['url'];
		$url_item = $data['url_item'];
		$createdBy = $data['created_by'];
		$userBPDG = $this->get_role_bo_phan_dinh_gia();
		try {
			$dataEmail = [
				'code' => $code,
				'brand' => $hang_xe,
				'user' => $createdBy,
				'type_xm_oto' => $loai_xe,
				'url' => $url,
				'url_item' => $url_item,
			];
			$user_email = [
				$createdBy
			];

			// $dataEmail['user_email'] = $user_nv;
			foreach ($user_email as $key => $value) {
				if ($value == "ngochtm@tienngay.vn") {
					continue;
				}
				$dataEmail['email'] = $value;
				$result = $this->user_model->send_Email($dataEmail);
			}
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'message' => "Gửi email thành công"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		} catch (Exception $e) {
			$response = array(
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => "Gửi email thất bại"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
	}

	//gửi email trả về đến ng yêu cầu
	public function sendEmailNoteRequest($data)
	{
		if ($data['code'] == 'XM') {
			$type_xm_oto = 'Xe máy';
		} elseif ($data['code'] == "OTO") {
			$type_xm_oto = 'Ô tô';
		}
		$hang_xe = $data['hang_xe'];
		$note = $data['note'];
		$code = 'send_email_feedback_request_blacklist';
		$url = $data['url'];
		$url_item = $data['url_item'];
		$createdBy = $data['created_by'];
		$userBPDG = $this->get_role_bo_phan_dinh_gia();
		try {
			$dataEmail = [
				'url' => $url,
				'code' => $code,
				'type_xm_oto' => $type_xm_oto,
				'note' => $note,
				'brand' => $hang_xe,
				'url_item' => $url_item,
				'user' => $createdBy
			];
			$user_email = [
				$createdBy
			];

			// $dataEmail['user_email'] = $user_nv;
			foreach ($user_email as $key => $value) {
				if ($value == "ngochtm@tienngay.vn") {
					continue;
				}
				$dataEmail['email'] = $value;
				$result = $this->user_model->send_Email($dataEmail);
			}
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'message' => "Gửi email thành công"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		} catch (Exception $e) {
			$response = array(
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => "Gửi email thất bại"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

	}

	//gửi email cho người yêu cầu sau khi xác nhận tài sản giả
	public function sendEmailCheckFakeProperty($data)
	{

		if ($data['code'] == 'XM') {
			$type_xm_oto = 'Xe máy';
		} elseif ($data['code'] == "OTO") {
			$type_xm_oto = 'Ô tô';
		}
		$hang_xe = $data['hang_xe'];
		$description = $data['description'];
		$so_khung = $data['so_khung'];
		$so_may = $data['so_may'];
		$bien_so_xe = $data['bien_so_xe'];
		$code = 'send_email_fake_property_request';
		$name = $data['name'];
		$url = $data['url'];
		$url_item = $data['url_item'];
		$createdBy = $data['created_by'];
		$userBPDG = $this->get_role_bo_phan_dinh_gia();
		try {
			$dataEmail = [
				'url' => $url,
				'url_item' => $url_item,
				'code' => $code,
				'type_xm_oto' => $type_xm_oto,
				'car_owner' => $name,
				'brand' => $hang_xe,
				'user' => $createdBy,
				'chassis_number' => $so_khung,
				'engine_number' => $so_may,
				'vehicle_number' => $bien_so_xe,
				'description' => $description
			];
			$user_email = [
				$createdBy
			];

			// $dataEmail['user_email'] = $user_nv;
			foreach ($user_email as $key => $value) {
				if ($value == "ngochtm@tienngay.vn") {
					continue;
				}
				$dataEmail['email'] = $value;
				$result = $this->user_model->send_Email($dataEmail);
			}
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'message' => "Gửi email thành công"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		} catch (Exception $e) {
			$response = array(
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => "Gửi email thất bại"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

	}

	//gửi email đến ng yêu cầu sau khi xác nhận tài sản thật
	public function sendEmailCheckRealProperty($data)
	{
		if ($data['code'] == 'XM') {
			$type_xm_oto = 'Xe máy';
		} elseif ($data['code'] == "OTO") {
			$type_xm_oto = 'Ô tô';
		}
		$hang_xe = $data['hang_xe'];
		$code = 'send_email_real_property_request';
		$url = $data['url'];
		$url_item = $data['url_item'];
		$createdBy = $data['created_by'];
		$userBPDG = $this->get_role_bo_phan_dinh_gia();
		try {
			$dataEmail = [
				'url' => $url,
				'url_item' => $url_item,
				'code' => $code,
				'type_xm_oto' => $type_xm_oto,
				'brand' => $hang_xe,
				'user' => $createdBy,
			];
			$user_email = [
				$createdBy
			];

			// $dataEmail['user_email'] = $user_nv;
			foreach ($user_email as $key => $value) {
				if ($value == "ngochtm@tienngay.vn") {
					continue;
				}
				$dataEmail['email'] = $value;
				$result = $this->user_model->send_Email($dataEmail);
			}
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'message' => "Gửi email thành công"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		} catch (Exception $e) {
			$response = array(
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => "Gửi email thất bại"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

	}

	//gửi email yêu cầu người tạo updte thêm thông tin
	public function sendEmailRequestUpdateBlacklist($data)
	{
		if ($data['code'] == 'XM') {
			$type_xm_oto = 'Xe máy';
		} elseif ($data['code'] == "OTO") {
			$type_xm_oto = 'Ô tô';
		}
		$hang_xe = $data['hang_xe'];
		$note = $data['note'];
		$so_khung = $data['chassis_number'];
		$so_may = $data['engine_number'];
		$bien_so_xe = $data['vehicle_number'];
		$code = 'send_email_request_update_property_blacklist';
		$name = $data['name'];
		$url = $data['url'];
		$url_item = $data['url_item'];
		$createdBy = $data['created_by'];
		$updateDescription = $data['update_description'];

		$userBPDG = $this->get_role_bo_phan_dinh_gia();
		try {
			$dataEmail = [
				'updateDescription' => $updateDescription,
				'url' => $url,
				'code' => $code,
				'type_xm_oto' => $type_xm_oto,
				'car_owner' => $name,
				'brand' => $hang_xe,
				'user' => $createdBy,
				'chassis_number' => $so_khung,
				'engine_number' => $so_may,
				'vehicle_number' => $bien_so_xe,
				'url_item' => $url_item
			];
			$user_email = [
				$createdBy
			];

			// $dataEmail['user_email'] = $user_nv;
			foreach ($user_email as $key => $value) {
				if ($value == "ngochtm@tienngay.vn") {
					continue;
				}
				$dataEmail['email'] = $value;
				$result = $this->user_model->send_Email($dataEmail);
			}
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'message' => "Gửi email thành công"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		} catch (Exception $e) {
			$response = array(
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => "Gửi email thất bại"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

	}

	//gửi email cho BPDG sau khi update xong
	public function sendEmailToBPDGAfterUpdateBlacklist($data)
	{
		if ($data['code'] == 'XM') {
			$type_xm_oto = 'Xe máy';
		} elseif ($data['code'] == "OTO") {
			$type_xm_oto = 'Ô tô';
		}
		$identify = $data['identify'];
		$phone = $data['phone'];
		$hang_xe = $data['hang_xe'];
		$note = $data['note'];
		$so_khung = $data['so_khung'];
		$so_may = $data['so_may'];
		$bien_so_xe = $data['bien_so_xe'];
		$url = $data['url'];
		$url_item = $data['url_item'];
		$code = 'send_email_done_update_property_blacklist';
		$url = $data['url'];
		$url_item = $data['url_item'];
		$createdBy = $data['created_by'];
		$userBPDG = $this->get_role_bo_phan_dinh_gia();
		try {
			$dataEmail = [
				'code' => $code,
				'url' => $url,
				'url_item' => $url_item,
				'type_xm_oto' => $type_xm_oto,
				'brand' => $hang_xe,
				'phone' => $phone,
				'identify' => $identify,
				'chassis_number' => $so_khung,
				'engine_number' => $so_may,
				'vehicle_number' => $bien_so_xe,
				'user' => $createdBy
			];
			$user_email = [
				'dinhgia@tienngay.vn'
			];

			// $dataEmail['user_email'] = $user_nv;
			foreach ($user_email as $key => $value) {
				if ($value == "ngochtm@tienngay.vn") {
					continue;
				}
				$dataEmail['email'] = $value;
				$result = $this->user_model->send_Email($dataEmail);
			}
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'message' => "Gửi email thành công"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		} catch (Exception $e) {
			$response = array(
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => "Gửi email thất bại"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

	}

	public function getHistoryBlacklistProperty_post()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : '';
		$logs = $this->log_property_blacklist_model->get_history_blacklist(['property_id' => $id]);
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'ok',
			'data' => $logs
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function addCommentBlacklistPropertyIntoLog_post()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : '';
		$comment = !empty($data['comment']) ? $data['comment'] : "";
		$dataLog = [
			'type' => 'comment',
			'comment' => $comment,
			'property_id' => $id,
			'created_at' => $this->createdAt,
			'created_by' => $this->uemail,
		];
		$this->log_property_blacklist_model->insert($dataLog);
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'ok',

		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	//kiểm tra tài sản có trong blacklist hay không
	public function checkPropertyBlacklistInDetailContract_post()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : '';
		$arrIdentify = false;
		$contract = $this->contract_model->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
		$condition = [];
		$condition['identify'] = $contract['customer_infor']['customer_identify'];
		$condition['passport'] = $contract['customer_infor']['passport_number'];
		$condition['phone'] = $contract['customer_infor']['customer_phone_number'];
		foreach ($contract['property_infor'] as $item) {
			if ($item->slug == 'bien-so-xe') {
				$condition['vehicle_number'] = $item->value;
			}
			if ($item->slug == 'so-khung') {
				$condition['chassis_number'] = $item->value;
			}
			if ($item->slug == 'so-may') {
				$condition['engine_number'] = $item->value;
			}
			if ($item->slug == 'so-dang-ky') {
				$condition['registration_number'] = $item->value;
			}
		}
		if (!empty($contract)) {
			$property = $this->property_blacklist_model->get_check_fake_property($condition);
			if (!empty($property)) {
				$arrIdentify = true;
			}
		}
		foreach ($property as $a) {
			$id = (string)$a['_id'];
		}

		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'ok',
			'data' => $arrIdentify,
			'id' => $id
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function importExcelXM_post()
	{
		$data = $this->input->post();
		$code = !empty($data['code']) ? $data['code'] : '';
		$brand_name = !empty($data['brand']) ? $data['brand'] : '';
		$name = !empty($data['name']) ? $data['name'] : '';
		$so_khung = !empty($data['so_khung']) ? $data['so_khung'] : '';
		$so_may = !empty($data['so_may']) ? $data['so_may'] : '';
		$bien_so_xe = !empty($data['bien_so_xe']) ? $data['bien_so_xe'] : '';
		$so_dang_ky = !empty($data['so_dang_ky']) ? $data['so_dang_ky'] : '';
		$ngay_cap_dang_ky = !empty($data['ngay_cap_dang_ky']) ? $data['ngay_cap_dang_ky'] : '';
		$noi_cap_dang_ky = !empty($data['noi_cap_dang_ky']) ? $data['noi_cap_dang_ky'] : '';
		$description = !empty($data['description']) ? $data['description'] : '';
		$so_khung_duplicate = $this->property_blacklist_model->findOne(['chassis_number' => $so_khung]);
		$so_may_duplicate = $this->property_blacklist_model->findOne(['engine_number' => $so_may]);
		$bien_so_xe_duplicate = $this->property_blacklist_model->findOne(['vehicle_number' => $bien_so_xe]);
		$so_dang_ky_duplicate = $this->property_blacklist_model->findOne(['registration.number' => $so_dang_ky]);
		$message = $this->validateImport($data);
		if (count($message) > 0) {
			$response = array(
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => $message[0],
				'key' => $data['key']
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		$customer = [
			'name' => $name,
		];

		$registration = [
			'number' => $so_dang_ky,
			'date_range' => $ngay_cap_dang_ky,
			'issued_by' => $noi_cap_dang_ky,
		];

		$dataInsert = [
			'code' => $code,
			'brand_name' => $brand_name,
			'customer_infor' => $customer,
			'status' => 'active',
			'scan' => 1,
			'registration' => $registration,
			'chassis_number' => $so_khung,
			'engine_number' => $so_may,
			'vehicle_number' => $bien_so_xe,
			'description' => $description,
			'created_at' => $this->createdAt,
			'created_by' => $this->uemail,

		];
		if (!($so_khung_duplicate) && !($so_may_duplicate) && !($bien_so_xe_duplicate) && !($so_dang_ky_duplicate) && !($so_dang_kiem_duplicate)) {
			$id = $this->property_blacklist_model->insertReturnId($dataInsert);
			$dataLog = [
				'type' => 'create',
				'property_id' => (string)$id,
				'data' => $dataInsert,
				'created_at' => $this->createdAt,
				'created_by' => $this->uemail,
			];
			$this->log_property_blacklist_model->insert($dataLog);
			$response = [
				'status' => REST_Controller::HTTP_OK,
				'message' => 'ok',
			];
		}
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;


	}

	public function importExcelOTO_post()
	{
		$data = $this->input->post();
		$code = !empty($data['code']) ? $data['code'] : '';
		$brand_name = !empty($data['brand']) ? $data['brand'] : '';
		$name = !empty($data['name']) ? $data['name'] : '';
		$so_khung = !empty($data['so_khung']) ? $data['so_khung'] : '';
		$so_may = !empty($data['so_may']) ? $data['so_may'] : '';
		$bien_so_xe = !empty($data['bien_so_xe']) ? $data['bien_so_xe'] : '';
		$so_dang_ky = !empty($data['so_dang_ky']) ? $data['so_dang_ky'] : '';
		$ngay_cap_dang_ky = !empty($data['ngay_cap_dang_ky']) ? $data['ngay_cap_dang_ky'] : '';
		$noi_cap_dang_ky = !empty($data['noi_cap_dang_ky']) ? $data['noi_cap_dang_ky'] : '';
		$so_dang_kiem = !empty($data['so_dang_kiem']) ? $data['so_dang_kiem'] : '';
		$ngay_cap_dang_kiem = !empty($data['ngay_cap_dang_kiem']) ? $data['ngay_cap_dang_kiem'] : '';
		$noi_cap_dang_kiem = !empty($data['noi_cap_dang_kiem']) ? $data['noi_cap_dang_kiem'] : '';
		$description = !empty($data['description']) ? $data['description'] : '';
		$so_khung_duplicate = $this->property_blacklist_model->findOne(['chassis_number' => $so_khung]);
		$so_may_duplicate = $this->property_blacklist_model->findOne(['engine_number' => $so_may]);
		$bien_so_xe_duplicate = $this->property_blacklist_model->findOne(['vehicle_number' => $bien_so_xe]);
		$so_dang_ky_duplicate = $this->property_blacklist_model->findOne(['registration.number' => $so_dang_ky]);
//		$so_dang_kiem_duplicate = $this->property_blacklist_model->findOne(['inspection.number' => $so_dang_kiem]);
		$message = $this->validateImport($data);
		if (count($message) > 0) {
			$response = array(
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => $message[0],
				'key' => $data['key']
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		$customer = [
			'name' => $name,
		];

		$registration = [
			'number' => $so_dang_ky,
			'date_range' => $ngay_cap_dang_ky,
			'issued_by' => $noi_cap_dang_ky,
		];

		$inspection = [
			'number' => $so_dang_kiem,
			'date_range' => $ngay_cap_dang_kiem,
			'issued_by' => $noi_cap_dang_kiem
		];

		$dataInsert = [
			'code' => $code,
			'brand_name' => $brand_name,
			'customer_infor' => $customer,
			'status' => 'active',
			'scan' => 1,
			'registration' => $registration,
			'inspection' => $inspection,
			'chassis_number' => $so_khung,
			'engine_number' => $so_may,
			'vehicle_number' => $bien_so_xe,
			'description' => $description,
			'created_at' => $this->createdAt,
			'created_by' => $this->uemail,

		];
		if (!($so_khung_duplicate) && !($so_may_duplicate) && !($bien_so_xe_duplicate) && !($so_dang_ky_duplicate) && !($so_dang_kiem_duplicate)) {
			$id = $this->property_blacklist_model->insertReturnId($dataInsert);
			$dataLog = [
				'type' => 'create',
				'property_id' => (string)$id,
				'created_at' => $this->createdAt,
				'created_by' => $this->uemail,
			];
			$this->log_property_blacklist_model->insert($dataLog);
			$response = [
				'status' => REST_Controller::HTTP_OK,
				'message' => 'ok',
			];
		}

		$this->set_response($response, REST_Controller::HTTP_OK);
		return;


	}

	public function validateImport($data)
	{
		$code = !empty($data['code']) ? $data['code'] : '';
		$brand_name = !empty($data['brand']) ? $data['brand'] : '';
		$name = !empty($data['name']) ? $data['name'] : '';
		$so_khung = !empty($data['so_khung']) ? $data['so_khung'] : '';
		$so_may = !empty($data['so_may']) ? $data['so_may'] : '';
		$bien_so_xe = !empty($data['bien_so_xe']) ? $data['bien_so_xe'] : '';
		$so_dang_ky = !empty($data['so_dang_ky']) ? $data['so_dang_ky'] : '';
		$ngay_cap_dang_ky = !empty($data['ngay_cap_dang_ky']) ? $data['ngay_cap_dang_ky'] : '';
		$noi_cap_dang_ky = !empty($data['noi_cap_dang_ky']) ? $data['noi_cap_dang_ky'] : '';
		$so_dang_kiem = !empty($data['so_dang_kiem']) ? $data['so_dang_kiem'] : '';
		$ngay_cap_dang_kiem = !empty($data['ngay_cap_dang_kiem']) ? $data['ngay_cap_dang_kiem'] : '';
		$noi_cap_dang_kiem = !empty($data['noi_cap_dang_kiem']) ? $data['noi_cap_dang_kiem'] : '';
		$description = !empty($data['description']) ? $data['description'] : '';

		$message = [];

		if(empty($data['brand'])){
			$message[] = 'Hãng xe không được để trống';
		}
		if(empty($data['name'])){
			$message[] = 'Tên chủ xe không được để trống';
		}
		if(empty($data['so_khung'])){
			$message[] = 'Số khung xe không được để trống';
		}
		if(empty($data['so_may'])){
			$message[] = 'Số máy xe không được để trống';
		}
		if(empty($data['bien_so_xe'])){
			$message[] = 'Biển số xe không được để trống';
		}
		if(empty($data['so_dang_ky'])){
			$message[] = 'Đăng ký xe không được để trống';
		}
		if(empty($data['ngay_cap_dang_ky'])){
			$message[] = 'Ngày cấp đăng ký không được để trống';
		}
		if(empty($data['noi_cap_dang_ky'])){
			$message[] = 'Nơi cấp đăng ký không được để trống';
		}
//		if(empty($data['so_dang_kiem']) && $code == "OTO"){
//			$message[] = 'Đăng kiểm xe không được để trống';
//		}
//		if(empty($data['ngay_cap_dang_kiem']) && $code == "OTO"){
//			$message[] = 'Ngày cấp đăng kiểm không được để trống';
//		}
//		if(empty($data['noi_cap_dang_kiem']) && $code == "OTO"){
//			$message[] = 'Nơi câp đăng kiểm không được để trống';
//		}
		if($so_khung_duplicate){
			$message[] = 'Số khung đã tồn tại';
		}
		if($so_may_duplicate){
			$message[] = 'Số máy đã tồn tại';
		}
		if($bien_so_xe_duplicate){
			$message[] = 'Biển số xe đã tồn tại';
		}
		if($so_dang_ky_duplicate){
			$message[] = 'Số đăng ký xe đã tồn tại';
		}
//		if($so_dang_kiem_duplicate && $code == "OTO"){
//			$message[] = "Số đăng kiểm đã tồn tại";
//		}

		return $message;
	}

	public function addScanFlagInBlacklistProperty_post()
	{
		$property = $this->property_blacklist_model->find_where(['status' => ['$in' => ['active', 2]]]);
		foreach ($property as $item) {
			$this->property_blacklist_model->update(['_id' => new MongoDB\BSON\ObjectId($item['_id'])],
				[
					'scan' => 1 //chua quet
				]
			);
		}
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'ok',
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function getBlacklistProperty_post()
	{
		$property = $this->property_blacklist_model->get_property_blacklist_scan();
		if ($property) {
			$bool = $this->updateScanStatus($property);
			if ($bool) {
				$response = [
					'status' => REST_Controller::HTTP_OK,
					'message' => 'ok',
					'data' => $property
				];
			} else {
				$response = [
					'status' => REST_Controller::HTTP_BAD_REQUEST,
					'message' => 'ok',
				];
			}
		}

		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function updateScanStatus($data)
	{
		if ($data) {
			foreach ($data as $item) {
				$this->property_blacklist_model->update(['_id' => new MongoDB\BSON\ObjectId($item->_id)], [
					'scan' => 2
				]);
			}
			return true;
		} else {
			return false;
		}

	}

	public function detailBlacklistProperty_post()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : '';
		$property = $this->property_blacklist_model->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
		$userDG = $this->get_role_bo_phan_dinh_gia();
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'ok',
			'data' => $property,
			'userDG' => $userDG,
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	/**
	 * Nhận dạng ảnh giấy tờ và trả về thông tin text
	 */
	public function detect_registration_post()
	{
//		$flag = notify_token($this->flag_login);
//		if ($flag == false) return;
		$dataPost = $this->input->post();
		$property_id = $dataPost['property_id'];
		$property_db = $this->property_blacklist_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($property_id)]);
		$front_img = "";
		$back_img = "";
		if (!empty($property_db)) {
			$front_img = $property_db['image_registration']['front_img'] ?? '';
			$back_img = $property_db['image_registration']['back_img'] ?? '';
		}
		$vehicle_img_arr = [
			'front_img' => $front_img,
			'back_img' => $back_img,
			'get_thumb' => 'false',
			'type_url' => 'vehicle_registrations'
		];
		//Call Api CVS để lấy thông tin đăng ký/cavet xe dạng text
		$response_cvs = $this->cvs->callApi($vehicle_img_arr);
		$registration_info = [];
		if (isset($response_cvs->errorCode) && $response_cvs->errorCode == 0) {
			if ($response_cvs->data[1]->type == 'vehicle_registration_front') {
				$registration_info['registration_number'] = $response_cvs->data[1]->info->id;
			}
			if ($response_cvs->data[0]->type == 'vehicle_registration_back') {
				$registration_info['owner_car_name'] = $response_cvs->data[0]->info->name;
				$plate_number = $response_cvs->data[0]->info->plate;
				$plate_number_arr = explode(' ', $plate_number);
				$plate_number_convert = $plate_number_arr[0].'-'.$plate_number_arr[1].'.'.$plate_number_arr[2];
				$registration_info['plate_number'] = $plate_number_convert;
				$registration_info['chassis_number'] = $response_cvs->data[0]->info->chassis;
				$registration_info['engine_number'] = $response_cvs->data[0]->info->engine;
				$registration_info['license_date'] = $response_cvs->data[0]->info->last_issue_date;
				$registration_info['issued_at'] = $response_cvs->data[0]->info->issued_at;
			}
		} else {
			$response = [
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => 'Nhận dạng không thành công!'
			];
		}
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'data' => !empty($registration_info) ? $registration_info : ''
		];
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}
}

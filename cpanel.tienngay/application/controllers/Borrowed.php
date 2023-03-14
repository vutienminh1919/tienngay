<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

class Borrowed extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// $this->api = new Api();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url', 'file'));
		$this->load->helper('lead_helper');
		$this->load->model("main_property_model");
		$this->load->model('config_gic_model');
		$this->load->model("time_model");
		$this->load->library('pagination');
		$this->config->load('config');

		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";


	}

	public function index_borrowed()
	{

		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$code_contract_disbursement = $this->api->apiPost($this->userInfo['token'], "contract/contract_borrowing");
		if (!empty($code_contract_disbursement->status) && $code_contract_disbursement->status == 200) {
			$arr_code_contract_disbursement = [];
			foreach ($code_contract_disbursement->data as $value) {
				if (!empty($value->code_contract_disbursement)) {
					array_push($arr_code_contract_disbursement, $value->code_contract_disbursement);
				}
			}
			$this->data['code_contract_disbursement'] = $arr_code_contract_disbursement;
		} else {
			$this->data['code_contract_disbursement'] = array();
		}


		$countBorrowed = $this->api->apiPost($this->userInfo['token'], "borrowed/get_count_all");

		$count = (int)$countBorrowed->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('borrowed/index_borrowed');
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;
		$data = array(
			"per_page" => $config['per_page'],
			"uriSegment" => $config['uri_segment']
		);

		$borrowed = $this->api->apiPost($this->userInfo['token'], "borrowed/get_all", $data);
		if (!empty($borrowed->status) && $borrowed->status == 200) {

			foreach ($borrowed->data as $item){
				$data_id = [
					"id" => $item->code_contract_disbursement_text
				];
				$check_id = $this->api->apiPost($this->userInfo['token'], "contract/check_id",$data_id);
				$item->oid = $check_id->data;
			}

			$this->data['borrowed'] = $borrowed->data;
		} else {
			$this->data['borrowed'] = array();
		}


		$this->data['template'] = 'page/borrowed/borrowed';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function create_borrowed()
	{

		$data = $this->input->post();
		$data['code_contract_disbursement_value'] = $this->security->xss_clean($data['code_contract_disbursement_value']);
		$data['code_contract_disbursement_text'] = $this->security->xss_clean($data['code_contract_disbursement_text']);
		$data['file'] = $this->security->xss_clean($data['file']);
		$data['giay_to_khac'] = $this->security->xss_clean($data['giay_to_khac']);
		$data['borrowed_start'] = $this->security->xss_clean($data['borrowed_start']);
		$data['borrowed_end'] = $this->security->xss_clean($data['borrowed_end']);
		$data['note'] = $this->security->xss_clean($data['note']);


		$sendApi = array(
			'code_contract_disbursement_value' => $data['code_contract_disbursement_value'],
			'code_contract_disbursement_text' => $data['code_contract_disbursement_text'],
			'file' => $data['file'],
			'giay_to_khac' => $data['giay_to_khac'],
			'borrowed_start' => $data['borrowed_start'],
			'borrowed_end' => $data['borrowed_end'],
			'note' => $data['note'],

			"status" => "8",
			"created_at" => $this->createdAt,
			"created_by" => $this->userInfo,
		);

		$return = $this->api->apiPost($this->userInfo['token'], "borrowed/process_create_borrowed", $sendApi);

		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		} else {
			$msg = !empty($return->data->message) ? $return->data->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));

		}

	}

	private function pushJson($code, $data)
	{
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}

	public function update_borrowed()
	{
		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['code_contract_disbursement_value'] = $this->security->xss_clean($data['code_contract_disbursement_value']);
		$data['code_contract_disbursement_text'] = $this->security->xss_clean($data['code_contract_disbursement_text']);
		$data['file'] = $this->security->xss_clean($data['file']);
		$data['giay_to_khac'] = $this->security->xss_clean($data['giay_to_khac']);
		$data['borrowed_start'] = $this->security->xss_clean($data['borrowed_start']);
		$data['borrowed_end'] = $this->security->xss_clean($data['borrowed_end']);
		$data['note'] = $this->security->xss_clean($data['note']);


		$sendApi = array(
			"id" => $data['id'],
			'code_contract_disbursement_value' => $data['code_contract_disbursement_value'],
			'code_contract_disbursement_text' => $data['code_contract_disbursement_text'],
			'file' => $data['file'],
			'giay_to_khac' => $data['giay_to_khac'],
			'borrowed_start' => $data['borrowed_start'],
			'borrowed_end' => $data['borrowed_end'],
			'note' => $data['note'],

			"status" => "8",
			"created_by" => $this->userInfo,
		);

		$return = $this->api->apiPost($this->userInfo['token'], "borrowed/process_update_borrowed", $sendApi);


		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		} else {

			$msg = !empty($return->data->message) ? $return->data->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));

		}
	}

	public function showUpdate($id)
	{
		try {
			$id = $this->security->xss_clean($id);
			$condition = array("id" => $id);
			$content = $this->api->apiPost($this->userInfo['token'], "borrowed/get_one", $condition);

			if (!empty($content)){
				$content->data->borrowed_start = date("d-m-Y", $content->data->borrowed_start);
				$content->data->borrowed_end = date("d-m-Y", $content->data->borrowed_end);
			}

			$this->pushJson('200', json_encode(array("code" => "200", "data" => $content->data)));
		} catch (\Exception $exception) {
			show_404();
		}
	}

	public function cancel_borrowed()
	{

		$data = $this->input->post();
		$data['id_borrowed'] = $this->security->xss_clean($data['id_borrowed']);

		$data = array(
			"id" => !empty($data['id_borrowed']) ? $data['id_borrowed'] : '',
			"created_by" => $this->userInfo,
			"status" => "3"
		);

		$return = $this->api->apiPost($this->userInfo['token'], "borrowed/cancel_borrowed", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}
	}

	public function approve_borrowed_asm()
	{

		$data = $this->input->post();
		$data['id_borrowed'] = $this->security->xss_clean($data['id_borrowed']);

		$data = array(
			"id" => !empty($data['id_borrowed']) ? $data['id_borrowed'] : '',
			"created_by" => $this->userInfo,
			"status" => "1"
		);

		$return = $this->api->apiPost($this->userInfo['token'], "borrowed/approve_borrowed_asm", $data);

//		if (!empty($return->status) && $return->status == 200) {
//			$response = [
//				'res' => true,
//				'status' => "200",
//				'data' => $return->data
//			];
//			echo json_encode($response);
//			return;
//		} else {
//			$response = [
//				'res' => false,
//				'status' => "400",
//				'data' => $return->data
//			];
//			echo json_encode($response);
//			return;
//		}
		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		} else {
			$msg = !empty($return->data->message) ? $return->data->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));

		}
	}

	public function approve_borrowed()
	{
		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);

		$data['file'] = $this->security->xss_clean($data['file']);
		$data['giay_to_khac'] = $this->security->xss_clean($data['giay_to_khac']);
		$data['borrowed_start'] = $this->security->xss_clean($data['borrowed_start']);
		$data['borrowed_end'] = $this->security->xss_clean($data['borrowed_end']);
		$data['note'] = $this->security->xss_clean($data['note']);


		$sendApi = array(
			"id" => $data['id'],

			'file' => $data['file'],
			'giay_to_khac' => $data['giay_to_khac'],
			"borrowed_start" => $data['borrowed_start'],
			'borrowed_end' => $data['borrowed_end'],
			'note' => $data['note'],

			"status" => "2",
			"created_by" => $this->userInfo,
		);

		$return = $this->api->apiPost($this->userInfo['token'], "borrowed/approve_borrowed", $sendApi);
		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		} else {
			$msg = !empty($return->data->message) ? $return->data->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));

		}

	}

	public function confirm_borrowed()
	{

		$data = $this->input->post();
		$data['id_borrowed'] = $this->security->xss_clean($data['id_borrowed']);
		$data['borrowed_img'] = $this->security->xss_clean($data['borrowed_img']);

		$data = array(
			"id" => !empty($data['id_borrowed']) ? $data['id_borrowed'] : '',
			"borrowed_img" => !empty($data['borrowed_img']) ? $data['borrowed_img'] : '',
			"created_by" => $this->userInfo,
			"status" => "4"
		);

		$return = $this->api->apiPost($this->userInfo['token'], "borrowed/confirm_borrowed", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}

	}

	public function pay_borrowed()
	{

		$data = $this->input->post();
		$data['id_borrowed'] = $this->security->xss_clean($data['id_borrowed']);
		$data['note'] = $this->security->xss_clean($data['note']);

		$data = array(
			"id" => !empty($data['id_borrowed']) ? $data['id_borrowed'] : '',
			"created_by" => $this->userInfo,
			"note" => $data['note'],
			"status" => "5"
		);

		$return = $this->api->apiPost($this->userInfo['token'], "borrowed/pay_borrowed", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}

	}

	public function paid_borrowed()
	{

		$data = $this->input->post();
		$data['id_borrowed'] = $this->security->xss_clean($data['id_borrowed']);
		$data['borrowed_img'] = $this->security->xss_clean($data['borrowed_img']);


		$data = array(
			"id" => !empty($data['id_borrowed']) ? $data['id_borrowed'] : '',
			"borrowed_img" => !empty($data['borrowed_img']) ? $data['borrowed_img'] : '',
			"created_by" => $this->userInfo,
			"time_return" => $this->createdAt,
			"status" => "6"
		);

		$return = $this->api->apiPost($this->userInfo['token'], "borrowed/paid_borrowed", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}
	}

	public function showLog($id)
	{
		try {
			$id = $this->security->xss_clean($id);
			$condition = array("id" => $id);
			$content = $this->api->apiPost($this->userInfo['token'], "borrowed/get_log_one", $condition);

			foreach ($content->data as $value){
				$value->created_at = date('d/m/y H:i:s', $value->created_at);
				if (!empty($value->borrowed->status)){
					$value->note = $value->borrowed->note;

					$value->file = implode(", ", $value->borrowed->file);

					if (!empty($value->borrowed->giay_to_khac)){
						$result = array_merge($value->borrowed->file,(array)$value->borrowed->giay_to_khac);
						$value->file = implode(", ", $result);
					}

					$value->borrowed->status = $this->check_status($value->borrowed->status);
					$value->old = "";
					$value->new = "";

				}
				if (!empty($value->old->note)){
					$value->note = $value->old->note;
				}
				if (!empty($value->old->file)){
					$value->file = implode(", ", $value->old->file);

					if (!empty($value->old->giay_to_khac)){
						$result_1 = array_merge($value->old->file,(array)$value->old->giay_to_khac);
						$value->file = implode(", ", $result_1);
					}
					if (!empty($value->new->file)){
						$value->file = implode(", ", $value->new->file);
					}
					if (!empty($value->new->giay_to_khac)){

						$result_2 = array_merge($value->new->file,(array)$value->new->giay_to_khac);
						$value->file = implode(", ", $result_2);
					}

				}
				if (!empty($value->new->note)){
					$value->note = $value->new->note;
				}
				if (!empty($value->old->status)){
					$value->old->status = $this->check_status($value->old->status);
					$value->borrowed = "";
				}
				if (!empty($value->new->status)){
					$value->new->status = $this->check_status($value->new->status);
					$value->borrowed = "";
				}
//				if (!empty($value->new->borrowed_img)){
//					$value->new->borrowed_img = (array)$value->new->borrowed_img;
//				}

			}

			$this->pushJson('200', json_encode(array("code" => "200", "data" => $content->data)));
		} catch (\Exception $exception) {
			show_404();
		}
	}

	private function check_status($value){

		if ($value == 1){
			$status = "Chờ duyệt mượn HS";
		} elseif ($value == 2) {
			$status = "Chờ đến nhận HS";
		} elseif ($value == 3) {
			$status = "Hủy";
		} elseif ($value == 4) {
			$status = "Đang mượn";
		} elseif ($value == 5) {
			$status = "Chờ trả HS";
		}elseif ($value == 6) {
			$status = "Đã trả";
		} elseif ($value == 7) {
			$status = "Quá hạn";
		} elseif ($value == 8) {
			$status = "Chờ Asm duyệt mượn HS";
		}
		return $status;
	}

	public function search_borrowed()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$code_contract_disbursement_text = !empty($_GET['code_contract_disbursement_text']) ? $_GET['code_contract_disbursement_text'] : "";
		$status_borrowed = !empty($_GET['status_borrowed']) ? $_GET['status_borrowed'] : "";

		if (!empty($fdate)) {
			$data['fdate'] = $fdate;
		}
		if (!empty($tdate)) {
			$data['tdate'] = $tdate;
		}
		if (!empty($code_contract_disbursement_text)) {
			$data['code_contract_disbursement_text'] = $code_contract_disbursement_text;
		}
		if (!empty($status_borrowed)) {
			$data['status_borrowed'] = $status_borrowed;
		}


		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->userInfo['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}



		$code_contract_disbursement = $this->api->apiPost($this->userInfo['token'], "contract/contract_borrowing");
		if (!empty($code_contract_disbursement->status) && $code_contract_disbursement->status == 200) {
			$arr_code_contract_disbursement = [];
			foreach ($code_contract_disbursement->data as $value) {
				if (!empty($value->code_contract_disbursement)) {
					array_push($arr_code_contract_disbursement, $value->code_contract_disbursement);
				}
			}
			$this->data['code_contract_disbursement'] = $arr_code_contract_disbursement;
		} else {
			$this->data['code_contract_disbursement'] = array();
		}

		$countBorrowed = $this->api->apiPost($this->userInfo['token'], "borrowed/get_count_all", $data);
//		if (empty($countBorrowed)){
//			return;
//		}

		$count = (int)$countBorrowed->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;


		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('borrowed/search_borrowed?fdate=' . $fdate . '&tdate=' . $tdate . '&code_contract_disbursement_text=' . $code_contract_disbursement_text . '&status_borrowed=' . $status_borrowed);
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;
//		$data = array(
//			"per_page" => $config['per_page'],
//			"uriSegment" => $config['uri_segment']
//		);

		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];

		$borrowed = $this->api->apiPost($this->userInfo['token'], "borrowed/get_all", $data);

		if (!empty($borrowed->status) && $borrowed->status == 200) {

			foreach ($borrowed->data as $item){
				$data_id = [
					"id" => $item->code_contract_disbursement_text
				];
				$check_id = $this->api->apiPost($this->userInfo['token'], "contract/check_id",$data_id);
				$item->oid = $check_id->data;
			}


			$this->data['borrowed'] = $borrowed->data;
		} else {
			$this->data['borrowed'] = array();
		}

		$this->data['template'] = 'page/borrowed/borrowed';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function search_fileReturn(){

		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$code_contract_disbursement_text = !empty($_GET['code_contract_disbursement_text']) ? $_GET['code_contract_disbursement_text'] : "";
		$status_fileReturn = !empty($_GET['status_fileReturn']) ? $_GET['status_fileReturn'] : "";

		if (!empty($fdate)) {
			$data['fdate'] = $fdate;
		}
		if (!empty($tdate)) {
			$data['tdate'] = $tdate;
		}
		if (!empty($code_contract_disbursement_text)) {
			$data['code_contract_disbursement_text'] = $code_contract_disbursement_text;
		}
		if (!empty($status_fileReturn)) {
			$data['status_fileReturn'] = $status_fileReturn;
		}

		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$code_contract_disbursement = $this->api->apiPost($this->userInfo['token'], "contract/contract_borrowing");
		if (!empty($code_contract_disbursement->status) && $code_contract_disbursement->status == 200) {
			$arr_code_contract_disbursement = [];
			foreach ($code_contract_disbursement->data as $value) {
				if (!empty($value->code_contract_disbursement)) {
					array_push($arr_code_contract_disbursement, $value->code_contract_disbursement);
				}
			}
			$this->data['code_contract_disbursement'] = $arr_code_contract_disbursement;
		} else {
			$this->data['code_contract_disbursement'] = array();
		}

		$countFileReturn = $this->api->apiPost($this->userInfo['token'], "borrowed/get_count_all_fileReturn",$data);

		$count = (int)$countFileReturn->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('borrowed/index_fileReturn');
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;

		$data["per_page"] = $config['per_page'];
		$data["uriSegment"] = $config['uri_segment'];


		$fileReturn = $this->api->apiPost($this->userInfo['token'], "borrowed/get_all_fileReturn", $data);
		if (!empty($fileReturn->status) && $fileReturn->status == 200) {

			foreach ($fileReturn->data as $item){
				$data_id = [
					"id" => $item->code_contract_disbursement_text
				];
				$check_id = $this->api->apiPost($this->userInfo['token'], "contract/check_id",$data_id);
				$item->oid = $check_id->data;
			}

			$this->data['file_return'] = $fileReturn->data;
		} else {
			$this->data['file_return'] = array();
		}

		$this->data['template'] = 'page/borrowed/file_return';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);


	}

	public function updateStatusNoti() {
		if (empty( $this->userInfo)) {
			redirect(base_url());
			return;
		}
		$id = $this->input->post('noti_id');
		$data_post = array(
			'noti_id' => $id,
		);
		$return = $this->api->apiPost( $this->userInfo['token'], "user/updateNotification_borrowed", $data_post);
		if (!empty($return->status && $return->status == 200)) {
			$data['status'] = 200;
			$data['message'] = 'success';
			echo json_encode($data);
		} else {
			$data['status'] = 400;
			$data['message'] = 'error';
			echo json_encode($data);
		}
		return;
	}

	public function index_fileReturn()
	{

		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$code_contract_disbursement = $this->api->apiPost($this->userInfo['token'], "contract/contract_borrowing");
		if (!empty($code_contract_disbursement->status) && $code_contract_disbursement->status == 200) {
			$arr_code_contract_disbursement = [];
			foreach ($code_contract_disbursement->data as $value) {
				if (!empty($value->code_contract_disbursement)) {
					array_push($arr_code_contract_disbursement, $value->code_contract_disbursement);
				}
			}
			$this->data['code_contract_disbursement'] = $arr_code_contract_disbursement;
		} else {
			$this->data['code_contract_disbursement'] = array();
		}

		$countFileReturn = $this->api->apiPost($this->userInfo['token'], "borrowed/get_count_all_fileReturn");

		$count = (int)$countFileReturn->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('borrowed/index_fileReturn');
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;
		$data = array(
			"per_page" => $config['per_page'],
			"uriSegment" => $config['uri_segment']
		);

		$fileReturn = $this->api->apiPost($this->userInfo['token'], "borrowed/get_all_fileReturn", $data);
		if (!empty($fileReturn->status) && $fileReturn->status == 200) {

			foreach ($fileReturn->data as $item){
				$data_id = [
					"id" => $item->code_contract_disbursement_text
				];
				$check_id = $this->api->apiPost($this->userInfo['token'], "contract/check_id",$data_id);
				$item->oid = $check_id->data;
			}

			$this->data['file_return'] = $fileReturn->data;
		} else {
			$this->data['file_return'] = array();
		}



		$this->data['template'] = 'page/borrowed/file_return';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function create_fileReturn(){

		$data = $this->input->post();
		$data['code_contract_disbursement_value'] = $this->security->xss_clean($data['code_contract_disbursement_value']);
		$data['code_contract_disbursement_text'] = $this->security->xss_clean($data['code_contract_disbursement_text']);
		$data['file'] = $this->security->xss_clean($data['file']);

		$data['giay_to_khac'] = $this->security->xss_clean($data['giay_to_khac']);

		$data['fileReturn_start'] = $this->security->xss_clean($data['fileReturn_start']);

		$sendApi = array(
			'code_contract_disbursement_value' => $data['code_contract_disbursement_value'],
			'code_contract_disbursement_text' => $data['code_contract_disbursement_text'],
			'file' => $data['file'],
			'giay_to_khac' => $data['giay_to_khac'],

			'fileReturn_start' => $data['fileReturn_start'],

			"status" => "1",
			"created_at" => $this->createdAt,
			"created_by" => $this->userInfo,
		);

		$return = $this->api->apiPost($this->userInfo['token'], "borrowed/process_create_fileReturn", $sendApi);

		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		} else {
			$msg = !empty($return->data->message) ? $return->data->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));

		}


	}

	function showUpdate_fileReturn($id){

		try {
			$id = $this->security->xss_clean($id);
			$condition = array("id" => $id);
			$content = $this->api->apiPost($this->userInfo['token'], "borrowed/get_one_fileReturn", $condition);

			if (!empty($content->data)){
				$content->data->fileReturn_start =  date("d-m-Y", $content->data->fileReturn_start);
			}


			$this->pushJson('200', json_encode(array("code" => "200", "data" => $content->data)));
		} catch (\Exception $exception) {
			show_404();
		}

	}

	public function update_fileReturn(){

		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['code_contract_disbursement_value'] = $this->security->xss_clean($data['code_contract_disbursement_value']);
		$data['code_contract_disbursement_text'] = $this->security->xss_clean($data['code_contract_disbursement_text']);
		$data['file'] = $this->security->xss_clean($data['file']);
		$data['giay_to_khac'] = $this->security->xss_clean($data['giay_to_khac']);

		$data['fileReturn_start'] = $this->security->xss_clean($data['fileReturn_start']);

		$sendApi = array(
			"id" => $data['id'],
			'code_contract_disbursement_value' => $data['code_contract_disbursement_value'],
			'code_contract_disbursement_text' => $data['code_contract_disbursement_text'],
			'file' => $data['file'],
			'giay_to_khac' => $data['giay_to_khac'],

			'fileReturn_start' => $data['fileReturn_start'],

			"status" => "1",
			"created_by" => $this->userInfo,
		);

		$return = $this->api->apiPost($this->userInfo['token'], "borrowed/process_update_fileReturn", $sendApi);


		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		} else {

			$msg = !empty($return->data->message) ? $return->data->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));

		}


	}

	public function approve_fileReturn()
	{
		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);

		$data['fileReturn_start'] = $this->security->xss_clean($data['fileReturn_start']);

		$data['note'] = $this->security->xss_clean($data['note']);


		$sendApi = array(
			"id" => $data['id'],
			'fileReturn_start' => $data['fileReturn_start'],
			'note' => $data['note'],

			"status" => "2",
			"created_by" => $this->userInfo,
		);

		$return = $this->api->apiPost($this->userInfo['token'], "borrowed/approve_fileReturn", $sendApi);
		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		} else {
			$msg = !empty($return->data->message) ? $return->data->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));

		}

	}

	public function confirm_fileReturn(){

		$data = $this->input->post();
		$data['id_fileReturn'] = $this->security->xss_clean($data['id_fileReturn']);
		$data['fileReturn_img'] = $this->security->xss_clean($data['fileReturn_img']);

		$data = array(
			"id" => !empty($data['id_fileReturn']) ? $data['id_fileReturn'] : '',
			"fileReturn_img" => !empty($data['fileReturn_img']) ? $data['fileReturn_img'] : '',
			"created_by" => $this->userInfo,
			"status" => "3"
		);

		$return = $this->api->apiPost($this->userInfo['token'], "borrowed/confirm_fileReturn", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}


	}

	public function cancel_fileReturn(){

		$data = $this->input->post();
		$data['fileReturn_id'] = $this->security->xss_clean($data['fileReturn_id']);

		$data = array(
			"id" => !empty($data['fileReturn_id']) ? $data['fileReturn_id'] : '',
			"created_by" => $this->userInfo,
			"status" => "4"
		);

		$return = $this->api->apiPost($this->userInfo['token'], "borrowed/cancel_fileReturn", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}


	}

	public function showLog_fileReturn($id){

		try {
			$id = $this->security->xss_clean($id);
			$condition = array("id" => $id);
			$content = $this->api->apiPost($this->userInfo['token'], "borrowed/get_log_one_fileReturn", $condition);

			foreach ($content->data as $value){

				$value->created_at = date('d/m/y H:i:s', $value->created_at);

//				$value->status = $this->check_status_fileReturn($value->old->status);

				if (!empty($value->fileReturn->status)){
					$value->note = $value->fileReturn->note;

					$value->file = implode(", ", $value->fileReturn->file);

					if (!empty($value->fileReturn->giay_to_khac)){
						$result = array_merge($value->fileReturn->file,(array)$value->fileReturn->giay_to_khac);
						$value->file = implode(", ", $result);
					}

					$value->fileReturn->status = $this->check_status_fileReturn($value->fileReturn->status);

					$value->old = "";
					$value->new = "";


				}
				if (!empty($value->old->note)){
					$value->note = $value->old->note;
				}
				if (!empty($value->old->file)){
					$value->file = implode(", ", $value->old->file);

					if (!empty($value->old->giay_to_khac)){
						$result_1 = array_merge($value->old->file,(array)$value->old->giay_to_khac);
						$value->file = implode(", ", $result_1);
					}
					if (!empty($value->new->file)){
						$value->file = implode(", ", $value->new->file);
					}
					if (!empty($value->new->giay_to_khac)){

						$result_2 = array_merge($value->new->file,(array)$value->new->giay_to_khac);
						$value->file = implode(", ", $result_2);
					}

				}
				if (!empty($value->new->note)){
					$value->note = $value->new->note;
				}
				if (!empty($value->old->status)){
					$value->old->status = $this->check_status_fileReturn($value->old->status);

					$value->fileReturn = "";
				}
				if (!empty($value->new->status)){
					$value->new->status = $this->check_status_fileReturn($value->new->status);

					$value->fileReturn = "";
				}

			}


			$this->pushJson('200', json_encode(array("code" => "200", "data" => $content->data)));
		} catch (\Exception $exception) {
			show_404();
		}


	}

	public function check_status_fileReturn($value){

		if ($value == 1){
			$status = "Chờ hội sở xử lý";
		} elseif ($value == 2) {
			$status = "Chờ gửi hồ sơ";
		} elseif ($value == 3) {
			$status = "Đã nhận hồ sơ";
		} elseif ($value == 4) {
			$status = "Chưa nhận được hồ sơ";
		}

		return $status;

	}

	public function check_status_sendFile($value){

		if ($value == 1){
			$status = "Chờ xác nhận";
		} elseif ($value == 2) {
			$status = "Đã nhận";
		} elseif ($value == 3) {
			$status = "Hủy";
		} elseif ($value == 4) {
			$status = "Chưa nhận Vpp";
		}

		return $status;

	}

	public function index_sendFile()
	{

		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$stores = $this->api->apiPost($this->userInfo['token'], "role/get_all");
		$this->data['stores'] = $stores->data;

		$countFileReturn = $this->api->apiPost($this->userInfo['token'], "borrowed/get_count_all_sendfile");

		$count = (int)$countFileReturn->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('borrowed/index_sendFile');
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;

		$data["per_page"] = $config['per_page'];
		$data["uriSegment"] = $config['uri_segment'];

		$sendFile = $this->api->apiPost($this->userInfo['token'], "borrowed/get_all_sendFile", $data);

		if (!empty($sendFile->status) && $sendFile->status == 200) {

			foreach ($sendFile->data as $value){
				$arr = [];
				foreach ($value->store_take_value[0] as $item){
					$data1 = [
						"slug" => $item
					];
					$store_name = $this->api->apiPost($this->userInfo['token'], "borrowed/check_name", $data1);

					array_push($arr, $store_name->data);
				}
				$value->store_name = $arr;
			}
			$this->data['sendFile'] = $sendFile->data;
		} else {
			$this->data['sendFile'] = array();
		}


		$this->data['template'] = 'page/borrowed/send_file';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function create_sendFile(){

		$data = $this->input->post();
		$data['store_take_value'] = $this->security->xss_clean($data['store_take_value']);
		$data['van_phong_pham_value'] = $this->security->xss_clean($data['van_phong_pham_value']);
		$data['cong_cu_value'] = $this->security->xss_clean($data['cong_cu_value']);
		$data['send_start'] = $this->security->xss_clean($data['send_start']);
		$data['send_end'] = $this->security->xss_clean($data['send_end']);
		$data['note'] = $this->security->xss_clean($data['note']);
		$data['img_send_file'] = $this->security->xss_clean($data['img_send_file']);

		$sendApi = array(
			'store_take_value' => $data['store_take_value'],
			'van_phong_pham_value' => $data['van_phong_pham_value'],
			'cong_cu_value' => $data['cong_cu_value'],
			'send_start' => $data['send_start'],
			'send_end' => $data['send_end'],
			'note' => $data['note'],
			'img_send_file' => $data['img_send_file'],

			"status" => "1",
			"created_at" => $this->createdAt,
			"created_by" => $this->userInfo,
		);


		$return = $this->api->apiPost($this->userInfo['token'], "borrowed/process_create_sendFile", $sendApi);

		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		} else {
			$msg = !empty($return->data->message) ? $return->data->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));

		}


	}

	public function showUpdate_sendFile($id){

		try {
			$id = $this->security->xss_clean($id);
			$condition = array("id" => $id);
			$content = $this->api->apiPost($this->userInfo['token'], "borrowed/get_one_sendFile", $condition);

			$arr = [];
			if (!empty($content->data->img_send_file)){
				foreach ((array)$content->data->img_send_file as $value) {
					array_push($arr, $value);
				}
			}
			if (!empty($content)){
				$content->data->send_start = date("d-m-Y", $content->data->send_start);
				$content->data->send_end = date("d-m-Y", $content->data->send_end);

			}
			$content->data->image = $arr;

			$this->pushJson('200', json_encode(array("code" => "200", "data" => $content->data)));
		} catch (\Exception $exception) {
			show_404();
		}

	}

	public function update_sendFile(){

		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['store_take_value'] = $this->security->xss_clean($data['store_take_value']);
		$data['van_phong_pham_value'] = $this->security->xss_clean($data['van_phong_pham_value']);
		$data['cong_cu_value'] = $this->security->xss_clean($data['cong_cu_value']);
		$data['send_start'] = $this->security->xss_clean($data['send_start']);
		$data['send_end'] = $this->security->xss_clean($data['send_end']);
		$data['note'] = $this->security->xss_clean($data['note']);
		$data['img_send_file'] = $this->security->xss_clean($data['img_send_file']);

		$sendApi = array(
			'id' => $data['id'],
			'store_take_value' => $data['store_take_value'],
			'van_phong_pham_value' => $data['van_phong_pham_value'],
			'cong_cu_value' => $data['cong_cu_value'],
			'send_start' => $data['send_start'],
			'send_end' => $data['send_end'],
			'note' => $data['note'],
			'img_send_file' => $data['img_send_file'],

			"status" => "1",

			"created_by" => $this->userInfo,
		);

		$return = $this->api->apiPost($this->userInfo['token'], "borrowed/process_update_sendFile", $sendApi);

		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		} else {
			$msg = !empty($return->data->message) ? $return->data->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));

		}


	}

	public function confirm_sendFile(){

		$data = $this->input->post();
		$data['sendFile_id'] = $this->security->xss_clean($data['sendFile_id']);
		$data['img_send_file'] = $this->security->xss_clean($data['img_send_file']);

		$data = array(
			"id" => !empty($data['sendFile_id']) ? $data['sendFile_id'] : '',
			"img_send_file" => !empty($data['img_send_file']) ? $data['img_send_file'] : '',
			"created_by" => $this->userInfo,
			"status" => "2"
		);

		$return = $this->api->apiPost($this->userInfo['token'], "borrowed/confirm_sendFile", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}

	}

	public function showLog_sendFile($id){

		try {
			$id = $this->security->xss_clean($id);
			$condition = array("id" => $id);
			$content = $this->api->apiPost($this->userInfo['token'], "borrowed/get_log_one_sendFile", $condition);

			foreach ($content->data as $value){
				$value->created_at = date('d/m/y H:i:s', $value->created_at);

				if (!empty($value->sendFile->status)){
					$value->note = $value->sendFile->note;

					$value->van_phong_pham_value = implode(", ", $value->sendFile->van_phong_pham_value[0]);
					$value->cong_cu_value = implode(", ", $value->sendFile->cong_cu_value[0]);

					$value->sendFile->status = $this->check_status_sendFile($value->sendFile->status);
					$value->old = "";
					$value->new = "";

				}
				if (!empty($value->old->note)){
					$value->note = $value->old->note;
				}
				if (!empty($value->old->van_phong_pham_value[0])){
					$value->van_phong_pham_value = implode(", ", $value->old->van_phong_pham_value[0]);

					if (!empty($value->new->van_phong_pham_value[0])){
						$value->van_phong_pham_value = implode(", ", $value->new->van_phong_pham_value[0]);
					}
				}
				if (!empty($value->old->cong_cu_value[0])){
					$value->cong_cu_value = implode(", ", $value->old->cong_cu_value[0]);
					if (!empty($value->new->cong_cu_value[0])){
						$value->cong_cu_value = implode(", ", $value->new->cong_cu_value[0]);
					}
				}
				if (!empty($value->new->note)){
					$value->note = $value->new->note;
				}
				if (!empty($value->old->status)){
					$value->old->status = $this->check_status_sendFile($value->old->status);
					$value->sendFile = "";
				}
				if (!empty($value->new->status)){
					$value->new->status = $this->check_status_sendFile($value->new->status);
					$value->sendFile = "";
				}


			}


			$this->pushJson('200', json_encode(array("code" => "200", "data" => $content->data)));
		} catch (\Exception $exception) {
			show_404();
		}


	}

	public function cancel_sendFile(){

		$data = $this->input->post();
		$data['sendFile_id'] = $this->security->xss_clean($data['sendFile_id']);

		$data = array(
			"id" => !empty($data['sendFile_id']) ? $data['sendFile_id'] : '',
			"created_by" => $this->userInfo,
			"status" => "3"
		);

		$return = $this->api->apiPost($this->userInfo['token'], "borrowed/cancel_sendFile", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}

	}

	public function search_sendFile(){

		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$status_sendFile = !empty($_GET['status_sendFile']) ? $_GET['status_sendFile'] : "";

		if (!empty($fdate)) {
			$data['fdate'] = $fdate;
		}
		if (!empty($tdate)) {
			$data['tdate'] = $tdate;
		}
		if (!empty($status_sendFile)) {
			$data['status_sendFile'] = $status_sendFile;
		}

		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$stores = $this->api->apiPost($this->userInfo['token'], "role/get_all");
		$this->data['stores'] = $stores->data;

		$countFileReturn = $this->api->apiPost($this->userInfo['token'], "borrowed/get_count_all_sendfile",$data);

		$count = (int)$countFileReturn->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('borrowed/index_sendFile');
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;

		$data["per_page"] = $config['per_page'];
		$data["uriSegment"] = $config['uri_segment'];

		$sendFile = $this->api->apiPost($this->userInfo['token'], "borrowed/get_all_sendFile", $data);

		if (!empty($sendFile->status) && $sendFile->status == 200) {

			foreach ($sendFile->data as $value){
				$arr = [];
				foreach ($value->store_take_value[0] as $item){
					$data1 = [
						"slug" => $item
					];
					$store_name = $this->api->apiPost($this->userInfo['token'], "borrowed/check_name", $data1);

					array_push($arr, $store_name->data);
				}
				$value->store_name = $arr;
			}
			$this->data['sendFile'] = $sendFile->data;
		} else {
			$this->data['sendFile'] = array();
		}


		$this->data['template'] = 'page/borrowed/send_file';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}




}


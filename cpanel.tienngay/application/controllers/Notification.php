<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

class Notification extends MY_Controller
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

	public function index_notification()
	{

		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/get_all");
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$areaData = $this->api->apiPost($this->userInfo['token'], "area/get_all");
		if (!empty($areaData->status) && $areaData->status == 200) {
			$this->data['areaData'] = $areaData->data;
		} else {
			$this->data['areaData'] = array();
		}


		$countNotificationData = $this->api->apiPost($this->userInfo['token'], "notification/get_count_all");

		$count = (int)$countNotificationData->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('notification/index_notification');
		$config['total_rows'] = $count;
		$config['per_page'] = 50;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['countNotification'] = $count;
		$data = array(
			"per_page" => $config['per_page'],
			"uriSegment" => $config['uri_segment']
		);

		$header = $this->api->apiPost($this->userInfo['token'], "notification/get_all_header", $data);
		if (!empty($header->status) && $header->status == 200) {
			$this->data['header'] = $header->data;
		} else {
			$this->data['header'] = array();
		}

		$notifications = $this->api->apiPost($this->userInfo['token'], "notification/get_all", $data);
		if (!empty($notifications->status) && $notifications->status == 200) {
			$this->data['notifications'] = $notifications->data;
		} else {
			$this->data['notifications'] = array();
		}



		$return = $this->api->apiPost($this->userInfo['token'], "role/get_role_by_user", ["user_id" => $this->userInfo['id']]);
		$arrReturn = [];
		if (!empty($return->status) && $return->status == 200) {

			foreach ($return->data->role_stores as $value){
				if (!empty($value->code_area)){
					array_push($arrReturn,$value->code_area);
				}
			}
			$this->data['return'] = $arrReturn;

		} else {
			$this->data['return'] = array();
		}

		$this->data['template'] = 'page/thongbao/thongbao';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function create_notification()
	{

		$data = $this->input->post();
		$data['notification_type'] = $this->security->xss_clean($data['notification_type']);
		$data['priority_level'] = $this->security->xss_clean($data['priority_level']);
		$data['title'] = $this->security->xss_clean($data['title']);
		$data['content'] = !empty($_POST['content']) ?  $_POST['content'] : "" ;
		$data['start_date'] = $this->security->xss_clean($data['start_date']);
		$data['end_date'] = $this->security->xss_clean($data['end_date']);
		$data['selectize_role_value'] = $this->security->xss_clean($data['selectize_role_value']);
		$data['selectize_area_value'] = $this->security->xss_clean($data['selectize_area_value']);

		$data['contractId'] = $this->security->xss_clean($data['contractId']);

		$data['identify'] = $this->security->xss_clean($data['identify']);

		$image_accurecy = array(
			"identify" => $data['identify'],
		);

		$sendApi = array(
			'notification_type' => $data['notification_type'],
			'priority_level' => $data['priority_level'],
			'title' => $data['title'],
			'content' => $data['content'],
			'start_date' => $data['start_date'],
			'end_date' => $data['end_date'],
			'selectize_role_value' => $data['selectize_role_value'],
			'selectize_area_value' => $data['selectize_area_value'],

			"image_accurecy" => $image_accurecy,

			"created_at" => $this->createdAt,
			"created_by" => $this->user['email'],
		);
		$return = $this->api->apiPost($this->user['token'], "notification/process_create_notification", $sendApi);

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

	public function update()
	{
		$data = $this->input->get();
		$data['id'] = $this->security->xss_clean($data['id']);


		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		if ($contract->status == 200) {

			$data['contractInfor'] = $contract->data;


			$dataGet = $this->input->get();
			$dataGet['id'] = $this->security->xss_clean($dataGet['id']);
			$dataPost = array(
				"id" => $dataGet['id']
			);
			$result = $this->api->apiPost($this->userInfo['token'], "contract/get_image_accurecy", $dataPost);
			$data['result'] = $result->data;
			$data['contract_status'] = $result->contract_status;

			$data['template'] = 'page/pawn/new_contract/update/update_quanlyhopdong_addnew';
			$this->load->view('template', isset($data) ? $data : NULL);
		}
	}

	public function showUpdate($id)
	{

		$id = $this->security->xss_clean($id);
		$condition = array("id" => $id);
		$content = $this->api->apiPost($this->userInfo['token'], "notification/get_one", $condition);
		if (!empty($content->data)){
			$arr = [];
			foreach ((array)$content->data->image_accurecy->identify as $value) {
				array_push($arr, $value);
			}
			if (!empty($content->data->start_date)){
				$content->data->start_date = date("d-m-Y", $content->data->start_date);
			}
			if (!empty($content->data->end_date)){
				$content->data->end_date = date("d-m-Y", $content->data->end_date);
			}
		}

//		foreach ($content as $item) {
//			$item->start_date_new = date("d-m-Y", $item->start_date);
//			$item->end_date_new = date("d-m-Y", $item->end_date);
//		}

		$content->data->image = $arr;

		$this->pushJson('200', json_encode(array("code" => "200", "data" => $content->data)));

	}

	public function update_notification()
	{

		$data = $this->input->post();
		$data['notification_type'] = $this->security->xss_clean($data['notification_type']);
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['priority_level'] = $this->security->xss_clean($data['priority_level']);
		$data['title'] = $this->security->xss_clean($data['title']);
		$data['content'] = !empty($_POST['content']) ?  $_POST['content'] : "" ;
		$data['start_date'] = $this->security->xss_clean($data['start_date']);
		$data['end_date'] = $this->security->xss_clean($data['end_date']);
		$data['selectize_role_value'] = $this->security->xss_clean($data['selectize_role_value']);
		$data['selectize_area_value'] = $this->security->xss_clean($data['selectize_area_value']);

		$data['contractId'] = $this->security->xss_clean($data['contractId']);

		$data['identify'] = $this->security->xss_clean($data['identify']);

		$image_accurecy = array(
			"identify" => $data['identify'],
		);


		$sendApi = array(
			"id" => $data['id'],
			'notification_type' => $data['notification_type'],
			'priority_level' => $data['priority_level'],
			'title' => $data['title'],
			'content' => $data['content'],
			'start_date' => $data['start_date'],
			'end_date' => $data['end_date'],
			'selectize_role_value' => $data['selectize_role_value'],
			'selectize_area_value' => $data['selectize_area_value'],

			"image_accurecy" => $image_accurecy,

			"created_by" => $this->user['email'],
		);
		$return = $this->api->apiPost($this->user['token'], "notification/process_update_notification", $sendApi);

		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		} else {
			$msg = !empty($return->data->message) ? $return->data->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));

		}

	}

	public function search()
	{

		$notification_type = !empty($_GET['notification_type']) ? $_GET['notification_type'] : "";
		$title = !empty($_GET['title']) ? $_GET['title'] : "";
		$priority_level = !empty($_GET['priority_level']) ? $_GET['priority_level'] : "";

		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/get_all");
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$areaData = $this->api->apiPost($this->userInfo['token'], "area/get_all");
		if (!empty($areaData->status) && $areaData->status == 200) {
			$this->data['areaData'] = $areaData->data;
		} else {
			$this->data['areaData'] = array();
		}

		$data = array();
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$data = array(
				"start" => $start,
				"end" => $end,
			);
		}
		if (!empty($notification_type)) {
			$data['notification_type'] = $notification_type;
		}

		if (!empty($title)) {
			$data['title'] = $title;
		}

		if (!empty($priority_level)) {
			$data['priority_level'] = $priority_level;
		}

		$countNotificationData = $this->api->apiPost($this->userInfo['token'], "notification/get_count_all", $data);

		$count = (int)$countNotificationData->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('notification/search?fdate=' . $start . '&tdate=' . $end . '&notification_type=' . $notification_type . '&title=' . $title . '&priority_level=' . $priority_level);
		$config['total_rows'] = $count;
		$config['per_page'] = 50;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['countNotification'] = $count;

		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];

		$header = $this->api->apiPost($this->userInfo['token'], "notification/get_all_header", $data);
		if (!empty($header->status) && $header->status == 200) {
			$this->data['header'] = $header->data;
		} else {
			$this->data['header'] = array();
		}

		$notifications = $this->api->apiPost($this->userInfo['token'], "notification/get_all", $data);
		if (!empty($notifications->status) && $notifications->status == 200) {
			$this->data['notifications'] = $notifications->data;
		} else {
			$this->data['notifications'] = array();
		}

		$this->data['template'] = 'page/thongbao/thongbao';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);


	}


}

?>

<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . '/libraries/Api.php';

class MY_Controller extends CI_Controller
{
	protected $user, $userRoles, $data, $createdAt, $groupRoles, $paramMenus, $is_superadmin, $api, $fcm;

	public function __construct()
	{
		parent::__construct();

		date_default_timezone_set('UTC');
		$this->api = new Api();
		//Start check login or check delete - deactive
		if (!$this->session->has_userdata('user')) {
			redirect(base_url());
		}

		$this->user = $this->session->userdata('user') ? $this->session->userdata('user') : '';
		$this->avatar = $this->session->userdata('avatar') ? $this->session->userdata('avatar') : '';
		$this->data['avatar'] = $this->avatar;
		//Check user token
		$userInfor = $this->api->apiPost($this->user['token'], "user/find_where", array('token_web' => $this->user['token']));


		if (empty($userInfor)) {
			$this->session->sess_destroy();
			redirect(base_url());
		}
		$this->data['userSession'] = $this->user;
		// session language
		if (!$this->session->userdata('language')) {
			$lang_ = 'english';
			$this->session->set_userdata('language', $lang_);
		}
		$this->langu = !empty($this->session->userdata("language")) ? $this->session->userdata("language") : "english";
		$this->lang->load('infor_lang', $this->langu);
		//Get roles
		$this->load->model("role_model");
		$this->load->model("group_role_model");
		$this->load->model("menu_model");
		$this->load->model("time_model");

		$dataPost = array(
			'token' => $this->user['token'],
			'user_id' => $this->user['id'],
		);

		$initData = $this->api->apiPost($this->user['token'], "user/get_init_data", $dataPost);

		$initData_borrowed = $this->api->apiPost($this->user['token'], "user/get_init_dataBorrowed", $dataPost);

		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles_s'] = $groupRoles->data;
		} else {
			$this->data['groupRoles_s'] = array();
		}
		// echo "<pre>";
		// print_r($initData_borrowed);
		// echo "</pre>";
		//
		// $this->userRoles = $this->role_model->get_role_by_user($this->user['token'], $this->user['id']);
		// $this->userRoles = $initData->userRoles;
		// $this->groupRoles = $this->group_role_model->get_group_role_by_user($this->user['token'], $this->user['id']);
		// $this->userRoles = $initData->groupRoles;
		// var_dump($dataPost);
		$this->data['userRoles'] = $initData->userRoles;
		$this->data['groupRoles'] = $initData->groupRoles;
		//$menuRoleIds = $this->userRoles->role_menus;
		$this->is_superadmin = !empty($this->user['is_superadmin']) && $this->user['is_superadmin'] == 1;
		if (!$this->is_superadmin) {
			//$this->paramMenus = $this->menu_model->get_url_menu_by_user($this->user['token'], $menuRoleIds);
			$this->paramMenus = $initData->paramMenus;
		}
		$this->createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		if (!empty($this->user)) {
			$nofity = $this->getNotification($initData->notifications);
			$this->data['count_notify'] = $nofity['count_notify'];
			$this->data['user_notifications'] = $nofity['user_notifications'];
		}
		if (!empty($this->user)) {

			$nofity_borrowed = $this->getNotification_borrowed($initData_borrowed->notifications);

			$this->data['count_notify_borrowed'] = $nofity_borrowed['count_notify_borrowed'];
			$this->data['user_notifications_borrowed'] = $nofity_borrowed['user_notifications_borrowed'];
		}


		$header = $this->api->apiPost($this->user['token'], "notification/get_all_header");
		if (!empty($header->status) && $header->status == 200) {
			$this->data['header'] = $header->data;
		} else {
			$this->data['header'] = array();
		}
		$return = $this->api->apiPost($this->user['token'], "role/get_role_by_user", ["user_id" => $this->user['id']]);
		$arrReturn = [];
		if (!empty($return->status) && $return->status == 200) {

			foreach ($return->data->role_stores as $value){
				if (!empty($value->code_area)){
					array_push($arrReturn,$value->code_area);
				}
			}
			$this->data['return_header'] = $arrReturn;

		} else {
			$this->data['return_header'] = array();
		}
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/get_all");
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles_header'] = $groupRoles->data;
		} else {
			$this->data['groupRoles_header'] = array();
		}


		if (!empty($nofity['user_notifications'])) {
			for ($i = 0; $i < count($nofity['user_notifications']); $i++) {
				$check = [
					"contract_id" => $nofity['user_notifications'][$i]->action_id
				];
				$data_hs = $this->api->apiPost($this->user['token'], "hoiso_create/get_create_at_hs_all", $check);

				if (!empty($data_hs->status) && $data_hs->status == 200) {

					$nofity['user_notifications'][$i]->data_hs = $data_hs->data;
				} else {

					$nofity['user_notifications'][$i]->data_hs = array();
				}

				unset($check);
				unset($data_hs);
			}
		}

		//Get infor header
		$this->data['header_infor'] = $this->getInforHeader($this->data['userRoles']->role_stores, $this->data['groupRoles']);
	}

	private function getNotification($notifications)
	{
		//$return = $this->api->apiPost($this->user['token'], "user/getNotification", array('limit' => 6));


		$data = array();
		$data['user_notifications'] = $notifications->data;
		$data['count_notify'] = $notifications->count;
		if (!empty($data)) {
			foreach ($data['user_notifications'] as $n) {
				$n->date = $this->time_model->convertTimestampToDatetime((int)$n->created_at);
			}
		}
		return $data;
	}

	private function getNotification_borrowed($notifications)
	{
		//$return = $this->api->apiPost($this->user['token'], "user/getNotification", array('limit' => 6));
		date_default_timezone_set('Asia/Ho_Chi_Minh');

		$data = array();
		$data['user_notifications_borrowed'] = $notifications->data;
		$data['count_notify_borrowed'] = $notifications->count;
		if (!empty($data)) {
			foreach ($data['user_notifications_borrowed'] as $n) {
				$n->date = $this->time_model->convertTimestampToDatetime((int)$n->created_at);
			}
		}
		return $data;
	}

	private function getInforHeader()
	{
		$condition = array(
			"stores_id" => $this->data['userRoles']->role_stores,
			"group_roles" => $this->data['groupRoles']
		);
		// $data = $this->api->apiPost($this->user['token'], "dashboard/get_contract_header", $condition);
	}

	public function dd($arr)
	{
		echo "<pre>";
		var_dump($arr);
		echo "</pre>";
	}

	public function tt($arr)
	{
		echo "<pre>";
		var_dump($arr);
		echo "</pre>";
		die();
	}
}

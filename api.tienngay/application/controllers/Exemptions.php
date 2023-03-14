<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
require_once APPPATH . 'libraries/REST_Controller.php';
require_once APPPATH . 'libraries/Fcm.php';

use Restserver\Libraries\REST_Controller;
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

class exemptions extends REST_Controller
{

	public function __construct($config = 'rest')
	{
		parent::__construct($config);
		$this->load->model('menu_model');
		$this->load->helper('lead_helper');
		$this->load->model('user_model');
		$this->load->model('role_model');
		$this->load->model('group_role_model');
		$this->load->model('contract_model');
		$this->load->model("transaction_model");
		$this->load->model('contract_tempo_model');
		$this->load->model("temporary_plan_contract_model");
		$this->load->model('tempo_contract_accounting_model');
		$this->load->model('dashboard_model');
		$this->load->model('exemptions_model');
		$this->load->model('log_exemptions_model');
		$this->load->model("store_model");
		$this->load->model("notification_model");
		$this->load->model("device_model");
		$this->load->model("email_history_model");
		$this->load->model("email_template_model");
		$this->load->model("lead_model");
		$this->load->model("kpi_area_model");
		$this->load->model("kpi_gdv_model");
		$this->load->model("kpi_pgd_model");
		$this->load->model("area_model");
		$this->load->model("profile_exemption_model");


		$this->createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		$headers = $this->input->request_headers();
		$this->flag_login = 1;
		$this->superadmin = false;
		$this->dataPost = $this->input->post();
		if (!empty($headers['Authorization']) || !empty($headers['authorization'])) {
			$headers_item = !empty($headers['Authorization']) ? $headers['Authorization'] : $headers['authorization'];
			$token = Authorization::validateToken($headers_item);
			if ($token != false) {
				// Kiểm tra tài khoản và token có khớp nhau và có trong db hay không
				$this->app_login = array(
					'_id' => new \MongoDB\BSON\ObjectId($token->id),
					'email' => $token->email,
					"status" => "active",
					// "is_superadmin" => 1
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
					$this->ulang = !empty($this->info['lang']) ? $this->info['lang'] : "english";
					$this->uemail = $this->info['email'];

					// Get access right
					$roles = $this->role_model->getRoleByUserId((string)$this->id);
					$this->roleAccessRights = $roles['role_access_rights'];
					$this->superadmin = isset($this->info['is_superadmin']) && (int)$this->info['is_superadmin'] === 1;
				}
			}
		}
		unset($this->dataPost['type']);
	}

	private $createdAt, $flag_login, $id, $uemail, $ulang, $app_login, $dataPost, $roleAccessRights, $info;

	public function approve_exemptions_post()
	{
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;
		$this->dataPost['id_contract'] = $this->security->xss_clean($this->dataPost['id_contract']);
		$this->dataPost['id_exemption'] = $this->security->xss_clean($this->dataPost['id_exemption']);
		$this->dataPost['code_contract'] = $this->security->xss_clean($this->dataPost['code_contract']);
		$this->dataPost['code_contract_disbursement'] = $this->security->xss_clean($this->dataPost['code_contract_disbursement']);
		$this->dataPost['customer_phone_number'] = $this->security->xss_clean($this->dataPost['customer_phone_number']);
		$this->dataPost['store'] = $this->security->xss_clean($this->dataPost['store']);
		$this->dataPost['ky_tra'] = $this->security->xss_clean($this->dataPost['ky_tra']);
		$this->dataPost['ngay_ky_tra'] = $this->security->xss_clean($this->dataPost['ngay_ky_tra']);
		$this->dataPost['customer_name'] = $this->security->xss_clean($this->dataPost['customer_name']);
		$this->dataPost['status'] = $this->security->xss_clean($this->dataPost['status']);
		$this->dataPost['status_update'] = $this->security->xss_clean($this->dataPost['status_update']);
		$this->dataPost['amount_customer_suggest'] = $this->security->xss_clean($this->dataPost['amount_customer_suggest']);
		$this->dataPost['amount_tp_thn_suggest'] = $this->security->xss_clean($this->dataPost['amount_tp_thn_suggest']);
		$this->dataPost['user_receive_approve'] = $this->security->xss_clean($this->dataPost['user_receive_approve']);
		$this->dataPost['user_receive_cc'] = $this->security->xss_clean($this->dataPost['user_receive_cc']);
		$this->dataPost['date_suggest'] = $this->security->xss_clean($this->dataPost['date_suggest']);
		$this->dataPost['start_date_effect'] = $this->security->xss_clean($this->dataPost['start_date_effect']);
		$this->dataPost['end_date_effect'] = $this->security->xss_clean($this->dataPost['end_date_effect']);
		$this->dataPost['image_file'] = $this->security->xss_clean($this->dataPost['image_file']);
		$this->dataPost['note'] = $this->security->xss_clean($this->dataPost['note']);
		$this->dataPost['note_lead'] = $this->security->xss_clean($this->dataPost['note_lead']);
		$this->dataPost['note_tp_thn'] = $this->security->xss_clean($this->dataPost['note_tp_thn']);
		$this->dataPost['note_qlcc'] = $this->security->xss_clean($this->dataPost['note_qlcc']);
		$this->dataPost['position'] = $this->security->xss_clean($this->dataPost['position']);
		$this->dataPost['type_payment_exem'] = $this->security->xss_clean($this->dataPost['type_payment_exem']);
		$this->dataPost['customer_identify'] = $this->security->xss_clean($this->dataPost['customer_identify']);
		$this->dataPost['confirm_email'] = $this->security->xss_clean($this->dataPost['confirm_email']);
		$this->dataPost['is_exemption_paper'] = $this->security->xss_clean($this->dataPost['is_exemption_paper']);
		$this->dataPost['number_date_late'] = $this->security->xss_clean($this->dataPost['number_date_late']);
		if (!empty($this->dataPost['status'])) {
			$status = $this->dataPost['status'];
		}
		if (!empty($this->dataPost['status_update'])) {
			$status_update = (int)$this->dataPost['status_update'];
		}
		if (!empty($this->dataPost['code_contract'])) {
			$code_contract = $this->dataPost['code_contract'];
		}
		if (!empty($this->dataPost['id_exemption'])) {
			$id_exemption_post = $this->dataPost['id_exemption'];
		}
		$old_exemption_contract = $this->exemptions_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($id_exemption_post)]);

		// B1: Tạo đơn miễn giảm.
		$log = [];
		if ($this->dataPost['number_date_late']) {
			$bucket = get_bucket($this->dataPost['number_date_late']);
		}
		if ($status == 1) {
			$store_db = $this->store_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($this->dataPost['store']['id'])]);
			$area_exemption = $this->area_model->findOne(['code' => $store_db['code_area']]);
			$domain_exemption = !empty($area_exemption['domain']['code']) ? $area_exemption['domain']['code'] : '';
			$data_insert = [
				'id_contract' => $this->dataPost['id_contract'],
				'code_transaction' => '',
				'code_contract' => $code_contract,
				'code_contract_disbursement' => $this->dataPost['code_contract_disbursement'],
				'customer_name' => $this->dataPost['customer_name'],
				'customer_phone_number' => $this->dataPost['customer_phone_number'],
				'store' => $this->dataPost['store'],
				'status' => (int)$status,
				'amount_customer_suggest' => $this->dataPost['amount_customer_suggest'],
				'ky_tra' => (int)$this->dataPost['ky_tra'],
				'ngay_ky_tra' => (int)$this->dataPost['ngay_ky_tra'],
				'date_suggest' => (int)$this->dataPost['date_suggest'],
				'start_date_effect' => (int)$this->dataPost['start_date_effect'],
				'end_date_effect' => (int)$this->dataPost['end_date_effect'],
				'image_exemption_profile' => $this->dataPost['image_file'],
				'note' => $this->dataPost['note'],
				'created_profile_at' => $this->createdAt,
				'type_payment_exem' => $this->dataPost['type_payment_exem'],
				'created_profile_by' => $this->uemail,
				'customer_identify' => $this->dataPost['customer_identify'],
				'confirm_email' => (int)$this->dataPost['confirm_email'],
				'is_exemption_paper' => (int)$this->dataPost['is_exemption_paper'],
				'number_date_late' => (int)$this->dataPost['number_date_late'],
				'bucket' => $bucket,
				'domain_exemption' => $domain_exemption,
			];
			if ($this->dataPost['is_exemption_paper'] == 1) {
				$data_insert['type_exception'] = 3;
			} else if ($this->dataPost['is_exemption_paper'] == 2) {
				$data_insert['type_exception'] = 1;
			}

			$check_isset_record = $this->exemptions_model->find_where(['code_contract' => $code_contract]);
			if (!empty($check_isset_record)) {
				foreach ($check_isset_record as $key => $check) {
					if ((!empty($check['ky_tra']) && $check['ky_tra'] == $this->dataPost['ky_tra']) || $check['type_payment_exem'] == 2) {
						$response = [
							'status' => REST_Controller::HTTP_UNAUTHORIZED,
							'message' => "Đã tồn tại đơn miễn giảm của kỳ hiện tại!"
						];
						$this->set_response($response, REST_Controller::HTTP_OK);
						return;
					} else {
						$id_exemption_insert_return = $this->exemptions_model->insertReturnId($data_insert);
						$log = [
							'type' => 'application_exemptions',
							'action' => 'create_exemption_profile',
							'code_contract' => $this->dataPost['code_contract'],
							'ky_tra' => $this->dataPost['ky_tra'],
							'exemptions_id' => (string)$id_exemption_insert_return,
							'record_exemptions' => $data_insert,
							'created_at' => $this->createdAt,
							'created_by' => $this->uemail,
						];
						$this->log_exemptions_model->insert($log);
					}
				}
			} else {
				$id_exemption_insert_return = $this->exemptions_model->insertReturnId($data_insert);
				$log = [
					'type' => 'application_exemptions',
					'action' => 'create_exemption_profile',
					'code_contract' => $this->dataPost['code_contract'],
					'ky_tra' => $this->dataPost['ky_tra'],
					'exemptions_id' => (string)$id_exemption_insert_return,
					'record_exemptions' => $data_insert,
					'created_at' => $this->createdAt,
					'created_by' => $this->uemail,
				];
				$this->log_exemptions_model->insert($log);
			}
		}

		// B2: Lead QLHĐV xử lý đơn miễn giảm && TP, QLCC trả về
		if (in_array($status, [2, 3, 4, 7, 8, 9])) {
			$array_update = [
				'status' => (int)$status,
				'updated_at' => $this->createdAt,
				'updated_by' => $this->uemail,
			];
			if ($this->dataPost['position'] == "lead") {
				$array_update['note_lead'] = $this->dataPost['note_lead'];
			} elseif ($this->dataPost['position'] == "tp") {
				$array_update['note_tp_thn'] = $this->dataPost['note_tp_thn'];
			} elseif ($this->dataPost['position'] == "qlcc") {
				$array_update['note_qlcc'] = $this->dataPost['note_qlcc'];
			}
		}

		// Gửi lại đơn miễn giảm
		if (isset($status_update) && $status_update == 1) {
			$array_update = [
				'status' => 1,
				'type_payment_exem' => $this->dataPost['type_payment_exem'],
				'confirm_email' => (int)$this->dataPost['confirm_email'],
				'is_exemption_paper' => (int)$this->dataPost['is_exemption_paper'],
				'amount_customer_suggest' => $this->dataPost['amount_customer_suggest'],
				'date_suggest' => (int)$this->dataPost['date_suggest'],
				'start_date_effect' => (int)$this->dataPost['start_date_effect'],
				'end_date_effect' => (int)$this->dataPost['end_date_effect'],
				'image_exemption_profile' => $this->dataPost['image_file'],
				'number_date_late' => (int)$this->dataPost['number_date_late'],
				'note' => $this->dataPost['note'],
				'updated_at' => $this->createdAt,
				'updated_by' => $this->uemail,
			];
			if ($this->dataPost['is_exemption_paper'] == 1) {
				$array_update['type_exception'] = 3;
			} else if ($this->dataPost['is_exemption_paper'] == 2) {
				$array_update['type_exception'] = 1;
			}
		}

		// B3: TP QLHĐV xử lý đơn miễn giảm
		// TP QLHĐV Duyệt
		if ($status == 5) {
			$array_update = [
				'image_exemption_profile' => $this->dataPost['image_file'],
				'amount_tp_thn_suggest' => $this->dataPost['amount_tp_thn_suggest'],
				'note_tp_thn' => $this->dataPost['note_tp_thn'],
				'status' => (int)$status,
				'updated_at' => $this->createdAt,
				'updated_by' => $this->uemail,
			];
		}

		// TP QLHĐV Gửi lên cấp cao
		if ($status == 6) {
			$array_update = [
				'image_exemption_profile' => $this->dataPost['image_file'],
				'amount_tp_thn_suggest' => $this->dataPost['amount_tp_thn_suggest'],
				'note_tp_thn' => $this->dataPost['note_tp_thn'],
				'user_receive_approve' => $this->dataPost['user_receive_approve'],
				'user_receive_cc' => $this->dataPost['user_receive_cc'],
				'status' => (int)$status,
				'updated_at' => $this->createdAt,
				'updated_by' => $this->uemail,
			];
		}

		if (!empty($id_exemption_post)) {
			$this->exemptions_model->update(
				['_id' => new \MongoDB\BSON\ObjectId($id_exemption_post)],
				$array_update
			);
			$log = [
				'type' => 'application_exemptions',
				'code_contract' => $this->dataPost['code_contract'],
				'ky_tra' => $this->dataPost['ky_tra'],
				'exemptions_id' => $this->dataPost['id_exemption'],
				'old' => $old_exemption_contract,
				'new' => $array_update,
				'created_at' => $this->createdAt,
				'created_by' => $this->uemail,
			];
			if ($this->dataPost['position'] == "lead") {
				if ($status == 2) {
					$log['action'] = 'lead_qlhdv_cancel_exemption_application';
				} elseif ($status == 3) {
					$log['action'] = 'lead_qlhdv_return';
				} elseif ($status == 4) {
					$log['action'] = 'lead_qlhdv_confirm';
				}
			} elseif ($this->dataPost['position'] == "tp") {
				if ($status == 8) {
					$log['action'] = 'tp_qlhdv_return';
				} elseif ($status == 2) {
					$log['action'] = 'tp_qlhdv_cancel_exemption_application';
				}
			} elseif ($this->dataPost['position'] == "qlcc") {
				if ($status == 7) {
					$log['action'] = 'qlcc_confirm';
				} elseif ($status == 9) {
					$log['action'] = 'qlcc_return';
				}
			}
			if (isset($status_update) && $status_update == 1) {
				$log['action'] = 'update_exemption_application';
			}
			if ($status == 5) {
				$log['action'] = 'tp_qlhdv_confirm';
			}
			if ($status == 6) {
				$log['action'] = 'tp_qlhdv_send_up_qlcc';
			}

			$this->log_exemptions_model->insert($log);
		}

		if (!empty($id_exemption_post)) {
			$exemption_contract = $this->exemptions_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($id_exemption_post)]);
		} else {
			$exemption_contract = $this->exemptions_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($id_exemption_insert_return)]);
		}
		// Gửi thông báo tới user liên quan
		$note = '';
		$array_id_user_receive_message = [];
		$link_detail = 'accountant/view_v2?id=' . $exemption_contract['id_contract'] . '#tab_content_history_exemption_contract';
		$link_detail_update = 'accountant/view_v2?id=' . $exemption_contract['id_contract'] . '#tab_content_update_exemption_contract';

		if ($status == 1 || $status_update == 1) {
			$note = 'Chờ Lead QLHĐV xử lý đơn miễn giảm';
			$array_id_user_receive_message = $this->getGroupRole_lead_THN();
			$this->push_notification_exemption_to_thn($array_id_user_receive_message, $status, $note, $link_detail, $exemption_contract, $status_update);
		} elseif (in_array($status,[3,8,9])) {
			if ($this->dataPost['position'] == "lead") {
				$note = 'Lead QLHĐV trả về đơn miễn giảm';
			} elseif ($this->dataPost['position'] == "tp") {
				$note = 'TP QLHĐV không chấp nhận đơn miễn giảm';
			} elseif ($this->dataPost['position'] == "qlcc") {
				$note = 'QLCC không chấp nhận đơn miễn giảm';
			}
			$user_created = $this->user_model->findOne(array('email' => $exemption_contract['created_profile_by']));
			$array_id_user_receive_message[] = (string)$user_created['_id'];
			$this->push_notification_exemption_to_thn($array_id_user_receive_message, $status, $note, $link_detail_update, $exemption_contract);
		} elseif ($status == 4) {
			$note = 'Chờ TP QLHĐV xử lý đơn miễn giảm';
			$array_id_user_receive_message = $this->getGroupRole_TP_THN();
			$this->push_notification_exemption_to_thn($array_id_user_receive_message, $status, $note, $link_detail, $exemption_contract);
		} elseif ($status == 5) {
			$note = 'TP QLHĐV đã duyệt đơn miễn giảm';
			$user_created = $this->user_model->findOne(array('email' => $exemption_contract['created_profile_by']));
			$id_user_create[] = (string)$user_created['_id'];
			$id_leads_thn = $this->getGroupRole_lead_THN();
			$array_id_user_receive_message = array_merge($id_user_create,$id_leads_thn);
			$this->push_notification_exemption_to_thn($array_id_user_receive_message, $status, $note, $link_detail, $exemption_contract);
		} elseif ($status == 6) {
			$note = 'Chờ QLCC duyệt đơn miễn giảm';
			$array_id_user_receive_message = $this->dataPost['user_receive_approve'];
			$array_id_user_receive_cc_message = $this->dataPost['user_receive_cc'];
			$this->push_notification_exemption_to_thn($array_id_user_receive_message, $status, $note, $link_detail, $exemption_contract);

			$this->sendEmailApproveExemptionContract($exemption_contract, $status, $array_id_user_receive_message);
			$this->sendEmailCcExemptionContract($exemption_contract, $status, $array_id_user_receive_cc_message);
		} elseif ($status == 7) {
			$note = 'QLCC đã duyệt đơn miễn giảm';
			$user_created = $this->user_model->findOne(array('email' => $exemption_contract['created_profile_by']));
			$array_id_user_receive_message[] = (string)$user_created['_id'];
			$this->push_notification_exemption_to_thn($array_id_user_receive_message, $status, $note, $link_detail, $exemption_contract);
		} elseif ($status == 2) {
			$note = 'Lead QLHĐV Hủy đơn miễn giảm';
			$user_created = $this->user_model->findOne(array('email' => $exemption_contract['created_profile_by']));
			$array_id_user_receive_message[] = (string)$user_created['_id'];
			$this->push_notification_exemption_to_thn($array_id_user_receive_message, $status, $note, $link_detail, $exemption_contract);
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => 'Success!',
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	private function getGroupRole_lead_THN()
	{
		$groupRoles = $this->group_role_model->find_where(array("status" => "active", 'slug' => 'lead-thn'));
		$arr = array();
		foreach ($groupRoles as $groupRole) {
			if (!empty($groupRole['users'])) {

				foreach ($groupRole['users'] as $value) {
					foreach ($value as $key => $item) {
						array_push($arr, $key);
					}

				}
			}
		}
		return $arr;
	}

	public function get_group_role_high_manager_post()
	{
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;
		$groupRoles = $this->group_role_model->find_where(array("status" => "active", 'slug' => 'cap-cao-duyet-mien-giam'));
		$arr = array();
		foreach ($groupRoles as $groupRole) {
			if (!empty($groupRole['users'])) {

				foreach ($groupRole['users'] as $value) {
					foreach ($value as $key => $item) {
						$arr[$key] = $item;
					}
				}
			}
		}

		$response = [
			'status' => REST_Controller::HTTP_OK,
			'data' => $arr
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function get_group_role_cc_receive_email_post()
	{
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;
		$groupRoles = $this->group_role_model->find_where(array("status" => "active", 'slug' => 'cc-nhan-email-mien-giam'));
		$arr = array();
		foreach ($groupRoles as $groupRole) {
			if (!empty($groupRole['users'])) {
				foreach ($groupRole['users'] as $value) {
					foreach ($value as $key => $item) {
						$arr[$key] = $item;
					}
				}
			}
		}

		$response = [
			'status' => REST_Controller::HTTP_OK,
			'data' => $arr
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	private function getGroupRole_TP_THN()
	{
		$groupRoles = $this->group_role_model->find_where(array("status" => "active", 'slug' => 'tbp-thu-hoi-no'));
		$arr = array();
		foreach ($groupRoles as $groupRole) {
			if (!empty($groupRole['users'])) {

				foreach ($groupRole['users'] as $value) {
					foreach ($value as $key => $item) {
						array_push($arr, $key);
					}

				}
			}
		}
		return $arr;
	}

	public function get_all_application_exemptions_post()
	{
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;
		$this->dataPost = $this->input->post()['condition'];
		$condition = !empty($this->dataPost['condition']) ? $this->dataPost['condition'] : array();
		$store_id = !empty($this->dataPost['store_id']) ? $this->dataPost['store_id'] : "";
		$id_card = !empty($this->dataPost['id_card']) ? $this->dataPost['id_card'] : "";
		$status = !empty($this->dataPost['status']) ? $this->dataPost['status'] : "17";
		$status_disbursement = !empty($this->dataPost['status_disbursement']) ? $this->dataPost['status_disbursement'] : "";
		$start = !empty($this->dataPost['start']) ? $this->dataPost['start'] : "";
		$end = !empty($this->dataPost['end']) ? $this->dataPost['end'] : "";
		$customer_name = !empty($this->dataPost['customer_name']) ? $this->dataPost['customer_name'] : "";
		$customer_phone_number = !empty($this->dataPost['customer_phone_number']) ? $this->dataPost['customer_phone_number'] : "";
		$code_contract_disbursement = !empty($this->dataPost['code_contract_disbursement']) ? $this->dataPost['code_contract_disbursement'] : "";
		$code_contract = !empty($this->dataPost['code_contract']) ? $this->dataPost['code_contract'] : "";

		if (!empty($start) && !empty($end)) {
			$condition = array(
				'start' => strtotime(trim($start) . ' 00:00:00'),
				'end' => strtotime(trim($end) . ' 23:59:59')
			);
		}
		if (!empty($status)) {
			$condition['status'] = $status;
		}
		if (!empty($status_disbursement)) {
			$condition['status_disbursement'] = $status_disbursement;
		}

		if (!empty($investor_code)) {
			$condition['investor_code'] = $investor_code;
		}
		if (!empty($store_id)) {
			$condition['store'] = $store_id;
		}

		if (!empty($customer_name)) {
			$condition['customer_name'] = trim($customer_name);
		}
		if (!empty($customer_phone_number)) {
			$condition['customer_phone_number'] = trim($customer_phone_number);
		}
		if (!empty($code_contract_disbursement)) {
			$condition['code_contract_disbursement'] = trim($code_contract_disbursement);
		}
		if (!empty($code_contract)) {
			$condition['code_contract'] = trim($code_contract);
		}
		$groupRoles = $this->getGroupRole($this->id);

		$all = false;
		if (in_array('cua-hang-truong', $groupRoles) || in_array('quan-ly-khu-vuc', $groupRoles) || in_array('giao-dich-vien', $groupRoles)) {
			$all = true;
		}
		if (!empty($code_contract_disbursement) || !empty($customer_name) || !empty($customer_phone_number)) {
			$all = false;
		}
		if ($all) {
			$stores = $this->getStores($this->id);
			if (empty($stores)) {
				$response = array(
					'status' => REST_Controller::HTTP_OK,
					'data' => array()
				);
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			}
			$condition['stores'] = $stores;
		}
		$per_page = !empty($this->input->post()['per_page']) ? $this->input->post()['per_page'] : 30;
		$uriSegment = !empty($this->input->post()['uriSegment']) ? $this->input->post()['uriSegment'] : 0;
		$array_id_tp_thn_mb = $this->get_id_tp_thn_mb();
		$array_id_lead_thn_mb = $this->get_id_lead_thn_mb();
		$array_id_nv_qlkv_mb = $this->get_id_nv_qlkv_mb();
		if (in_array($this->id, $array_id_tp_thn_mb) || in_array($this->id, $array_id_lead_thn_mb) || in_array($this->id, $array_id_nv_qlkv_mb)) {
			$condition['domain_exemption'] = 'MB';
		} else {
			$condition['domain_exemption'] = 'MN';
		}
		$contract = array();
		$data_exemption = $this->exemptions_model->get_all(array(), $condition, $per_page, $uriSegment);
		$condition['total'] = true;
		$total = $this->exemptions_model->get_all(array(), $condition);

		$response = [
			'status' => REST_Controller::HTTP_OK,
			'data' => $data_exemption,
			'total' => $total
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function get_one_post()
	{
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;
		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);
		$contract_exemptions = $this->exemptions_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($this->dataPost['id'])]);
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'data' => $contract_exemptions
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function get_all_post()
	{
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;
		$this->dataPost['code_contract'] = $this->security->xss_clean($this->dataPost['code_contract']);
		$contract_exemptions = $this->exemptions_model->find_where(['code_contract' => $this->dataPost['code_contract']]);
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'contract' => $contract_exemptions
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function get_all_by_id_contract_post()
	{
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;
		$this->dataPost['id_contract'] = $this->security->xss_clean($this->dataPost['id_contract']);
		$contract_exemptions = $this->exemptions_model->find_where(['id_contract' => $this->dataPost['id_contract']]);
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'contract' => $contract_exemptions
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function get_transaction_discount_post()
	{
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;
		$this->dataPost['code_contract'] = $this->security->xss_clean($this->dataPost['code_contract']);
		$this->dataPost['ky_tra_hien_tai'] = $this->security->xss_clean($this->dataPost['ky_tra_hien_tai']);

		$code_contract = !empty($this->dataPost['code_contract']) ? $this->dataPost['code_contract'] : '';
		$ky_tra_hien_tai = !empty($this->dataPost['ky_tra_hien_tai']) ? (int)$this->dataPost['ky_tra_hien_tai'] : '';
		$transaction_discount = $this->transaction_model->find_where(['code_contract' => $code_contract,'ky_tra_hien_tai' => $ky_tra_hien_tai, "type" => array('$in' => array(4)), "status" => array('$ne' => 3)]);
		$transaction_discount_finish = $this->transaction_model->find_where(['code_contract' => $code_contract,'ky_tra_hien_tai' => $ky_tra_hien_tai, "type" => array('$in' => array(3)), "status" => array('$ne' => 3)]);
		if (!empty($transaction_discount)) {
			$check_discount = false;
			foreach ($transaction_discount as $key => $tran) {
				if ($tran->discounted_fee > 0) {
					$check_discount = true;
				}
			}
		}
		if (!empty($transaction_discount_finish)) {
			$check_discount_finish = false;
			foreach ($transaction_discount as $key1 => $tran_finish) {
				if ($tran_finish->discounted_fee > 0) {
					$check_discount_finish = true;
				}
			}
		}
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'data' => $transaction_discount,
			'check_discount' => $check_discount,
			'check_discount_finish' => $check_discount_finish,

		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function get_log_post()
	{
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;
		$this->dataPost['code_contract'] = $this->security->xss_clean($this->dataPost['code_contract']);
		$contract_exemptions = $this->log_exemptions_model->find_where(['code_contract' => $this->dataPost['code_contract']]);
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'contract' => $contract_exemptions
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function restore_exemption_post()
	{
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;
		$this->dataPost['id_exemption'] = $this->security->xss_clean($this->dataPost['id_exemption']);
		$this->dataPost['id_contract'] = $this->security->xss_clean($this->dataPost['id_contract']);
		$this->dataPost['code_contract'] = $this->security->xss_clean($this->dataPost['code_contract']);
		$this->dataPost['type_payment_exem'] = $this->security->xss_clean($this->dataPost['type_payment_exem']);

		$array_update = [
			'status' => 3,
			'type_payment_exem' => $this->dataPost['type_payment_exem'],
			'updated_at' => $this->createdAt,
			'updated_by' => $this->uemail,
		];

		$this->exemptions_model->update(
			['_id' => new \MongoDB\BSON\ObjectId($this->dataPost['id_exemption'])],
			$array_update
		);

		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'Success',
			'data' => ''
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function get_current_period_post()
	{
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;
		$ky_tra_hien_tai = 0;
		$ngay_den_han = 0;
		$this->dataPost['code_contract'] = $this->security->xss_clean($this->dataPost['code_contract']);
		$contract = $this->temporary_plan_contract_model->find_where(['code_contract' => $this->dataPost['code_contract']]);
		$contract_tempo = $this->contract_tempo_model->getContractTempobyTime(['code_contract' => $this->dataPost['code_contract'], 'status' => 1]);
		$contract_tempo_all = $this->temporary_plan_contract_model->getKiDaThanhToanGanNhat($this->dataPost['code_contract']);
		$ky_tra_hien_tai = !empty($contract_tempo[0]['ky_tra']) ? intval($contract_tempo[0]['ky_tra']) : intval($contract_tempo_all[0]['ky_tra']);
		$ngay_den_han = !empty($contract_tempo[0]['ngay_ky_tra']) ? intval($contract_tempo[0]['ngay_ky_tra']) : intval($contract_tempo_all[0]['ngay_ky_tra']);

		$response = [
			'status' => REST_Controller::HTTP_OK,
			'contract' => $contract,
			'ky_tra_hien_tai' => $ky_tra_hien_tai,
			'ngay_den_han' => $ngay_den_han,
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	private function getGroupRole($userId)
	{
		$groupRoles = $this->group_role_model->find_where(array("status" => "active"));
		$arr = array();
		foreach ($groupRoles as $groupRole) {
			if (empty($groupRole['users'])) continue;
			foreach ($groupRole['users'] as $item) {
				if (key($item) == $userId) {
					array_push($arr, $groupRole['slug']);
					continue;
				}
			}
		}
		return $arr;
	}

	private function getStores($userId)
	{
		$roles = $this->role_model->find_where(array("status" => "active"));
		$roleStores = array();
		if (count($roles) > 0) {
			foreach ($roles as $role) {
				if (!empty($role['users']) && count($role['users']) > 0) {
					$arrUsers = array();
					foreach ($role['users'] as $item) {
						array_push($arrUsers, key($item));
					}
					//Check userId in list key of $users
					if (in_array($userId, $arrUsers) == TRUE) {
						if (!empty($role['stores'])) {
							//Push store
							foreach ($role['stores'] as $key => $item) {
								array_push($roleStores, key($item));
							}
						}
					}
				}
			}
		}
		return $roleStores;
	}

	private function push_notification_exemption_to_thn($array_id_user_receive_message, $status, $note, $link_detail, $exemption_contract, $status_update = '')
	{
		foreach ($array_id_user_receive_message as $key => $id_user) {
			if (!empty($id_user)) {
				$data_notification = [
					'action_id' => (string)$exemption_contract['_id'],
					'action' => 'contract_exemptions',
					'detail' => $link_detail,
					'title' => $exemption_contract['customer_name'] . ' - ' . $exemption_contract['store']['name'],
					'note' => $note,
					'user_id' => $id_user,
					'status' => 1, //1: new, 2 : read, 3: block,
					'status_exemption_contract' => $status,
					'type_notification' => 1, //1: thông báo miễn giảm,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$code_contract = $exemption_contract['code_contract'];
				$code_contract_disbursement = $exemption_contract['code_contract_disbursement'];
				$customer_name = $exemption_contract['customer_name'];
				$this->notification_model->insertReturnId($data_notification);
				$device = $this->device_model->find_where(['user_id' => $id_user]);

				if (!empty($device) && $id_user == $device[0]['user_id']) {
					$badge = $this->get_count_notification_user($id_user);
					$fcm = new Fcm();
					$to = [];
					foreach ($device as $de) {
						$to[] = $de->device_token;
					}
					if ($status == 1) {
						$fcm->setTitle('Chờ Lead QLHĐV xử lý đơn miễn giảm! ');
					} elseif ($status_update == 1) {
						$fcm->setTitle('Chờ Lead QLHĐV duyệt lại đơn miễn giảm! ');
					} elseif ($status == 2) {
						$fcm->setTitle('Đơn miễn giảm đã bị hủy! ');
					} elseif ($status == 3) {
						$fcm->setTitle('Lead QLHĐV yêu cầu bổ sung hồ sơ! ');
					} elseif ($status == 4) {
						$fcm->setTitle('Chờ TP QLHĐV duyệt đơn miễn giảm! ');
					} elseif ($status == 5) {
						$fcm->setTitle('TP QLHĐV đã duyệt đơn miễn giảm! ');
					} elseif ($status == 6) {
						$fcm->setTitle('Chờ QLCC duyệt đơn miễn giảm! ');
					} elseif ($status == 7) {
						$fcm->setTitle('QLCC đã duyệt đơn miễn giảm! ');
					} elseif ($status == 8) {
						$fcm->setTitle('TP QLHĐV yêu cầu bổ sung hồ sơ! ');
					} elseif ($status == 9) {
						$fcm->setTitle('QLCC yêu cầu bổ sung hồ sơ! ');
					}

					$fcm->setMessage("HĐ: $code_contract_disbursement, KH: $customer_name");
					$lms_url = $this->config->item("cpanel_url");
					if (in_array($status,[3,8,9])) {
						$click_action = $lms_url . 'accountant/view_v2?id=' . $exemption_contract['id_contract'] . '#tab_content_update_exemption_contract';
					} else {
						$click_action = $lms_url . 'accountant/view_v2?id=' . $exemption_contract['id_contract'] . '#tab_content_history_exemption_contract';

					}

					$fcm->setClickAction($click_action);
					$fcm->setBadge($badge);
					$message = $fcm->getMessage();
					$result = $fcm->sendToTopicCpanel($to, $message, $message);

				}
			}
		}
	}

	private function get_count_notification_user($user_id)
	{
		$condition = [];
		$condition['user_id'] = (string)$user_id;
		$condition['type_notification'] = 1;
		$condition['status'] = 1;
		$unRead = $this->notification_model->get_count_notification_user($condition);
		return $unRead;
	}

	private function sendEmailApproveExemptionContract($exemption_contract, $status, $email_receive)
	{
		$status_text = "";
		$id = (string)$exemption_contract["_id"];

		if ($status == 6) {
			$status_text = "Chờ quản lý cấp cao xử lý đơn miễn giảm";
		}
		$lms_url = $this->config->item("cpanel_url");
		$data_send_email = array(
			'code' => "vfc_send_email_approve_exemption_contract",
			'customer_name' => $exemption_contract['customer_name'],
			'code_contract_disbursement' => $exemption_contract['code_contract_disbursement'],
			'amount_tp_thn_suggest' => number_format($exemption_contract['amount_tp_thn_suggest']),
			'status' => $status_text,
			'url' => $lms_url . "accountant/view_v2?id=" . $exemption_contract['id_contract'] . '#tab_content_history_exemption_contract',
		);

		foreach ($email_receive as $item) {
			$email_user = $this->getGroupRole_email($item);
			foreach ($email_user as $value) {
				$data_send_email['email'] = "$value";
				$data_send_email['API_KEY'] = $this->config->item('API_KEY');
				$this->user_model->send_Email($data_send_email);
//				$this->sendEmail($data_send_email);
			}
		}
		return;
	}

	private function sendEmailCcExemptionContract($exemption_contract, $status, $email_receive)
	{
		$status_text = "";
		$id = (string)$exemption_contract["_id"];

		if ($status == 6) {
			$status_text = "Chờ quản lý cấp cao xử lý đơn miễn giảm";
		}
		$lms_url = $this->config->item("cpanel_url");
		$data_send_email = array(
			'code' => "vfc_send_cc_exemption_contract",
			'customer_name' => $exemption_contract['customer_name'],
			'code_contract_disbursement' => $exemption_contract['code_contract_disbursement'],
			'amount_tp_thn_suggest' => number_format($exemption_contract['amount_tp_thn_suggest']),
			'status' => $status_text,
			'url' => $lms_url . "accountant/view_v2?id=" . $exemption_contract['id_contract'] . '#tab_content_history_exemption_contract',
		);

		foreach ($email_receive as $item) {
			$email_user = $this->getGroupRole_email($item);
			foreach ($email_user as $value) {
				$data_send_email['email'] = "$value";
				$data_send_email['API_KEY'] = $this->config->item('API_KEY');
				$this->user_model->send_Email($data_send_email);
//				$this->sendEmail($data_send_email);
			}
		}
		return;
	}

	public function sendEmail($dataPost)
	{
		$email_template = $this->email_template_model->findOne(array('code' => $dataPost['code'], 'status' => 'active'));

		$domain = $this->config->item('sendgrid_domain');
		// var_dump($email_template); die;

		$from = 'support@tienngay.vn';
		$from_name = $email_template['from_name'];
		$subject = $email_template['subject'];
		$message = $this->getEmailStr($email_template['message'], $dataPost);
		$status = 'active';
		$data = array(
			"code" => $dataPost['code'],
			"from" => $from,
			"from_name" => $from_name,
			"to" => $dataPost['email'],
			"subject" => $subject,
			"email_domain" => $domain,
			"status" => $status,
			"message" => $message,
			"created_at" => (int)$this->createdAt
		);

		//var_dump('expression');

		$this->email_history_model->insert($data);
		return;

	}

	public function getEmailStr($emailTemplate, $filter)
	{
		foreach ($filter as $key => $value) {
			$emailTemplate = str_replace("{" . $key . "}", $value, $emailTemplate);
		}
		return $emailTemplate;
	}

	private function getGroupRole_email($userId)
	{
		$groupRoles = $this->group_role_model->find_where(array("status" => "active"));
		$arr = array();
		foreach ($groupRoles as $groupRole) {
			if (empty($groupRole['users'])) continue;
			foreach ($groupRole['users'] as $item) {
				if (key($item) == $userId) {
					array_push($arr, $item[key($item)]['email']);
					continue;
				}
			}
		}
		return array_unique($arr);
	}

	public function noti_cskh_thoi_gian_khach_hen_post(){
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$condition = [];

		$create_at = date('Y-m-d H:i:s');

		$cenvertedTime = date('Y-m-d H:i:s',strtotime('+5 minutes',strtotime($create_at)));

		$condition['cenvertedTime'] = strtotime($cenvertedTime);

		$leadData = $this->lead_model->get_thoi_gian_khach_hen($condition);

		if (!empty($leadData)){
			foreach ($leadData as $value){

				if (!empty($value['cskh'])){
					$user_id = $this->user_model->findOne(['email' => $value['cskh']]);
					if (!empty($user_id)){
						$id_user = (string)$user_id['_id'];

						if (!empty($id_user)) {
							$device = $this->device_model->find_where(['user_id' => $id_user]);
							if (!empty($device) && $id_user == $device[0]['user_id']) {
								$badge = $this->get_count_notification_user($id_user);
								$fcm = new Fcm();
								$to = [];
								foreach ($device as $de) {
									$to[] = $de->device_token;
								}
								$fcm->setTitle('Khách hàng ' . $value['fullname'] .  " hẹn gọi lại! ");

//								$click_action = 'http://localhost/tienngay/cpanel.tienngay/lead_custom?tab=6';
								$click_action = 'https://lms.tienngay.vn/lead_custom?tab=6';
//								$click_action = 'https://sandboxcpanel.tienngay.vn/lead_custom?tab=6';

								$fcm->setClickAction($click_action);
								$fcm->setMessage("Thời gian: " . date('d/m/Y H:i:s', $value['thoi_gian_khach_hen'] ) . ", SĐT: " .  hide_phone($value['phone_number']));
								$fcm->setBadge($badge);
								$message = $fcm->getMessage();
								$result = $fcm->sendToTopicCpanel($to, $message, $message);

								$this->lead_model->update(array("_id" => new MongoDB\BSON\ObjectId((string)$value['_id'])), ['status_thoi_gian_khach_hen' => "2"]);


							}
						}
					}
				}

			}



		}
	}

	public function check_update_noti_kpi_post()
	{
//		$flag = notify_token($this->flag_login);
//		if ($flag == false) return;

		$groupRoles = $this->getGroupRole($this->id);

		if (!empty($groupRoles)){
			if (in_array("quan-ly-cap-cao", $groupRoles)){
				$check_kpi_area = $this->kpi_area_model->find_where(["year" => date('Y'), "month" => date('m')]);

				if (empty($check_kpi_area)){
					$click_action = "kpi/listKPI_area";
					$response = array(
						'status' => REST_Controller::HTTP_OK,
						'click_action' => $click_action
					);
					$this->set_response($response, REST_Controller::HTTP_OK);
				}
				return;
			}

			if (in_array("quan-ly-khu-vuc",$groupRoles)){
				$stores = $this->getStores_list($this->id);
				if (!empty($stores)){
					$check_kpi_pgd = $this->kpi_pgd_model->find_where(["year" => date('Y'), "month" => date('m'),'store.id' => $stores[0]]);
					if (empty($check_kpi_pgd)){
						$click_action = "kpi/listKPI_pgd";
						$response = array(
							'status' => REST_Controller::HTTP_OK,
							'click_action' => $click_action
						);
						$this->set_response($response, REST_Controller::HTTP_OK);
					}
				}
				return;
			}

			if (in_array("cua-hang-truong", $groupRoles)){
				$stores = $this->getStores_list($this->id);
				if (!empty($stores)){
					$check_kpi_gdv = $this->kpi_gdv_model->find_where(["year" => date('Y'), "month" => date('m'),'store.id' => $stores[0]]);
					if (empty($check_kpi_gdv)){
						$click_action = "kpi/listKPI_gdv";
						$response = array(
							'status' => REST_Controller::HTTP_OK,
							'click_action' => $click_action
						);
						$this->set_response($response, REST_Controller::HTTP_OK);
					}
				}
				return;
			}
		}
		$response = array(
			'status' => REST_Controller::HTTP_BAD_REQUEST,
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function push_noti_kpi($id_user, $setTitle, $click_action){

			$device = $this->device_model->find_where(['user_id' => $id_user]);
			if (!empty($device) && $id_user == $device[0]['user_id']) {
				$badge = $this->get_count_notification_user($id_user);
				$fcm = new Fcm();
				$to = [];
				foreach ($device as $de) {
					$to[] = $de->device_token;
				}
				$fcm->setTitle("Vui lòng cài đặt Kpi " . $setTitle);

				$fcm->setClickAction($click_action);
				$fcm->setMessage("Thời gian: Set Kpi tháng " . date('m'));
				$fcm->setBadge($badge);
				$message = $fcm->getMessage();
				$result = $fcm->sendToTopicCpanel($to, $message, $message);


		}

	}

	private function getGroupRole_check($slug)
	{
		$groupRoles = $this->group_role_model->find_where(array("status" => "active", 'slug' => $slug));

		$arr = array();
		foreach ($groupRoles as $groupRole) {
			if (!empty($groupRole['users'])) {

				foreach ($groupRole['users'] as $value) {
					foreach ($value as $key => $item) {
						array_push($arr, $key);
					}

				}
			}
		}
		return array_unique($arr);
	}

	private function getStores_list($userId)
	{
		$roles = $this->role_model->find_where(array("status" => "active"));
		$roleStores = array();
		if (count($roles) > 0) {
			foreach ($roles as $role) {
				if (!empty($role['users']) && count($role['users']) > 0) {
					$arrUsers = array();
					foreach ($role['users'] as $item) {
						array_push($arrUsers, key($item));
					}
					//Check userId in list key of $users
					if (in_array($userId, $arrUsers) == TRUE) {
						if (!empty($role['stores'])) {
							//Push store
							foreach ($role['stores'] as $key => $item) {
								array_push($roleStores,key($item));
							}
						}
					}
				}
			}
		}
		return $roleStores;
	}

	private function getUserbyStores($storeId)
	{
		$roles = $this->role_model->find_where(array("status" => "active"));
		$roleAllUsers = array();
		if (count($roles) > 0) {
			foreach ($roles as $role) {
				if (!empty($role['stores']) && count($role['stores']) == 1) {
					$arrStores = array();
					foreach ($role['stores'] as $item) {
						array_push($arrStores, key($item));
					}

					//Check userId in list key of $users
					foreach ($storeId as $s){

						if (in_array($s, $arrStores) == TRUE) {
							if (!empty($role['stores'])) {
								//Push store

								foreach ($role['users'] as $key => $item) {
									foreach ($item as $e){
										array_push($roleAllUsers, $e->email);
									}
								}

							}
						}
					}

				}
			}
		}
		$roleUsers = array_unique($roleAllUsers);
		return $roleUsers;
	}

	public function exportExcelExemption_post()
	{
		$start = !empty($this->dataPost['start']) ? $this->dataPost['start'] : "";
		$end = !empty($this->dataPost['end']) ? $this->dataPost['end'] : "";
		$code_contract = !empty($this->dataPost['code_contract']) ? $this->dataPost['code_contract'] : "";
		if (!empty($start) && !empty($end)) {
			$condition = array(
				'start' => strtotime(trim($start) . ' 00:00:00'),
				'end' => strtotime(trim($end) . ' 23:59:59')
			);
		}
		if (!empty($code_contract)) {
			$condition['code_contract'] = $code_contract;
		}
		$array_id_tp_thn_mb = $this->get_id_tp_thn_mb();
		$array_id_lead_thn_mb = $this->get_id_lead_thn_mb();
		if (in_array($this->id, $array_id_tp_thn_mb) || in_array($this->id, $array_id_lead_thn_mb)) {
			$condition['domain_exemption'] = 'MB';
		} else {
			$condition['domain_exemption'] = 'MN';
		}
		$data_exemption = $this->exemptions_model->exportExcelExemption($condition);

		if (!empty($data_exemption)) {
			foreach ($data_exemption as $value) {
				$dataContract = $this->contract_model->find_one_select(['code_contract' => $value['code_contract']], ['disbursement_date', 'loan_infor.type_interest', 'status', 'expire_date', 'loan_infor.amount_money','original_debt.du_no_goc_con_lai','debt.so_ngay_cham_tra','store', 'code_contract_parent_gh', 'number_day_loan', 'code_contract_parent_cc']);
				if (!empty($dataContract)) {
					$value['type_interest'] = $dataContract['loan_infor']['type_interest'];
					$value['disbursement_date'] = $dataContract['disbursement_date'];
					$value['statusContract'] = $dataContract['status'];
					$value['expire_date'] = $dataContract['expire_date'];
					$value['amount_money'] = $dataContract['loan_infor']['amount_money'];
					$value['tong_tien_goc_con'] = $dataContract['original_debt']['du_no_goc_con_lai'];
					$value['store'] = $dataContract['store']['name'];
					//report v2
					//Mã phiếu ghi gốc (vs HĐ gia hạn hoặc cơ cấu)
					$value['code_contract_origin'] = !empty($dataContract['code_contract_parent_gh']) ? $dataContract['code_contract_parent_gh'] : (!empty($dataContract['code_contract_parent_cc']) ? $dataContract['code_contract_parent_cc'] : '');
					$contract_origin_gh_db = $this->contract_model->find_one_select(['code_contract' => $dataContract['code_contract_parent_gh']], ['code_contract_disbursement']);
					$contract_origin_cc_db = $this->contract_model->find_one_select(['code_contract' => $dataContract['code_contract_parent_cc']], ['code_contract_disbursement']);
					//Mã hợp đồng gốc (vs HĐ gia hạn hoặc cơ cấu)
					$value['code_contract_disbursement_origin'] = !empty($contract_origin_gh_db['code_contract_disbursement']) ? $contract_origin_gh_db['code_contract_disbursement'] : (!empty($contract_origin_cc_db['code_contract_disbursement']) ? $contract_origin_cc_db['code_contract_disbursement'] : '');
					$log_exemption_db = $this->log_exemptions_model->find_where(['action' => 'tp_qlhdv_confirm', 'exemptions_id' => (string)$value['_id']]);
					//Ngày TP QLHĐV duyệt đơn miễn giảm
					$value['date_tpthn_approve'] = $log_exemption_db[0]['created_at'] ?? 0;
					//Update loại miễn giảm cho các HĐ cũ
					$trans_payment_finish_db = $this->transaction_model->findOne(['code_contract' => $value['code_contract'], 'type' => 3, 'status' => 1]);
					$text_date_pay_finish = !empty($trans_payment_finish_db['date_pay']) ? date('Y-m-d', $trans_payment_finish_db['date_pay']) : ''; // sample: 2022-09-16
					if (empty($value['type_payment_exem'])) {
						if (!empty($trans_payment_finish_db)) {
							if ( (int)$trans_payment_finish_db['total_deductible'] > 0) {
								$value['type_payment_exem'] = '2';
							}
						} else {
							$value['type_payment_exem'] = '1';
						}
					}
				}

				//Tổng tiền đã thu trước thời điểm tất toán
				$value['totalTran'] = 0;
				$total_where = $this->transaction_model->find_where_select(['code_contract' => $value['code_contract'], 'status' => 1, 'type' => array('$in' => [4, 5])], ['total']);
				if(!empty($total_where)){
					foreach ($total_where as $item){
						$value['totalTran'] += (int)$item['total'];
					}
				}

				//Tổng cần thu (gốc + lãi + phí)
				$value['total_tong_can_thu'] = $this->transaction_model->sum_where(['code_contract' => $value['code_contract'], 'status' => 1, 'type' => array('$in' => [3])], '$amount_total');

				//Khách hàng thanh toán tại ngày tất toán
				$value['total_thanh_toan_tat_toan'] = $this->transaction_model->sum_where(['code_contract' => $value['code_contract'], 'status' => 1, 'type' => array('$in' => [3])], '$total');

				//Tổng số tiền đã thu trước thời điểm miễn giảm
				 $total_trans_before_created_exemp_dbs = $this->transaction_model->find_where_select(
					[
						'code_contract' => $value['code_contract'],
						'status' => 1,
						'type' => 4,
						'date_pay' => array('$lt' => strtotime(date('Y-m-d', $value['updated_at']) . ' 23:59:59')),
					], ['total','ky_tra_hien_tai','total_deductible','date_pay','created_at']);

				$value['tong_tien_da_thu_truoc_mien_giam'] = 0;

				if (!empty($total_trans_before_created_exemp_dbs)) {
					foreach ($total_trans_before_created_exemp_dbs as $key => $trans) {
						$text_date_pay_normal = !empty($trans['date_pay']) ? date('Y-m-d', $trans['date_pay']) : '';
						$text_created_at_normal = !empty($trans['created_at']) ? date('Y-m-d', $trans['created_at']) : '';
						if ( ($value['type_payment_exem'] == '1') && $trans['total_deductible'] > 0 ) break;
						if ( ($value['type_payment_exem'] == '2') && ($text_date_pay_normal == $text_date_pay_finish) ) break;
						// MPG: 0000013848 - PT Tất toán miễn giảm bị tách ra 02 PT khác ngày
						if ( ($value['code_contract'] == '0000013848') && ($text_date_pay_normal == '2022-10-25') ) break;
						// MPG: 000006469 - PT tất toán miễn giảm bị tách ra 02 PT cùng ngày nhưng trùng vs PT thanh toán kỳ thông thường.
						if ( ($value['code_contract'] == '000006469') && ($text_date_pay_normal == '2022-10-25') ) break;
						$value['tong_tien_da_thu_truoc_mien_giam'] += (int)$trans['total'];
					}
					if ( ($value['code_contract'] == '000009228') ) {
						$value['tong_tien_da_thu_truoc_mien_giam'] = 16404000;
					}
				}
				// End Tổng số tiền đã thu trước thời điểm miễn giảm
				//Số tiền gốc còn lại trước khi làm đơn MG
				$trans_before_created_exemp_dbs = $this->transaction_model->find_where_select(
					[
						'code_contract' => $value['code_contract'],
						'status' => 1,
						'date_pay' => array('$lt' => strtotime(date('Y-m-d', $value['updated_at']) . ' 23:59:59')),
					], ['con_lai_sau_thanh_toan.goc_con_lai','date_pay','total_deductible']);

				if ( $dataContract['number_day_loan'] == 30 || (empty($trans_before_created_exemp_dbs)) ) {
					if (!empty($trans_before_created_exemp_dbs)) {
						$value['tien_goc_con_truoc_mien_giam'] = $trans_before_created_exemp_dbs[0]['con_lai_sau_thanh_toan']['goc_con_lai'] ?? $value['tong_tien_goc_con'];
					}

				} else {
					$value['tien_goc_con_truoc_mien_giam'] = $trans_before_created_exemp_dbs[count($trans_before_created_exemp_dbs) - 1]['con_lai_sau_thanh_toan']['goc_con_lai'] ?? '';
					// MPG: 0000013848 - PT Tất toán miễn giảm bị tách ra 02 PT khác ngày
					if ( ($value['code_contract'] == '0000013848')) {
						$value['tien_goc_con_truoc_mien_giam'] = $trans_before_created_exemp_dbs[count($trans_before_created_exemp_dbs) - 3]['con_lai_sau_thanh_toan']['goc_con_lai'] ?? '';
					}
					// MPG: 000006469 - PT tất toán miễn giảm bị tách ra 02 PT cùng ngày nhưng trùng vs PT thanh toán kỳ thông thường.
					if ( ($value['code_contract'] == '000006469')) {
						$value['tien_goc_con_truoc_mien_giam'] = $trans_before_created_exemp_dbs[count($trans_before_created_exemp_dbs) - 5]['con_lai_sau_thanh_toan']['goc_con_lai'] ?? '';
					}
					//Nếu PT đầu tiên có miễn giảm
					if ($trans_before_created_exemp_dbs[0]['total_deductible'] > 0) {
						$value['tien_goc_con_truoc_mien_giam'] = $value['amount_money'] ?? 0;
					}
				}

				//End Số tiền gốc còn lại trước khi làm đơn MG
				$trans_payment_db = $this->transaction_model->findOne(['code_contract' => $value['code_contract'], 'type' => 4, 'status' => 1, 'total_deductible' => array('$gt' => 0)]);
				$trans_payment_finish_db = $this->transaction_model->findOne(['code_contract' => $value['code_contract'], 'type' => 3, 'status' => 1]);
				//Case nếu date_pay > ngày update ĐMG => Lấy gốc còn lại trước miễn giảm dựa vào PT tất toán
				if (empty($trans_before_created_exemp_dbs)) {
					$value['tien_goc_con_truoc_mien_giam'] = $trans_payment_finish_db['con_lai_sau_thanh_toan']['goc_con_lai'] ?? 0;
				}
				if ( ($value['type_payment_exem'] == '2') && ($trans_payment_finish_db['total'] == 0) ) {
					$trans_quer_before_finish_db = $this->transaction_model->find_where_select(
						[
							'code_contract' => $value['code_contract'],
							'status' => 1,
							'date_pay' => array('$lt' => strtotime(date('Y-m-d', $trans_payment_finish_db['date_pay']) . ' 00:00:00')),
						], ['con_lai_sau_thanh_toan.goc_con_lai','date_pay']);
					$value['tien_goc_con_truoc_mien_giam'] = $trans_quer_before_finish_db[count($trans_quer_before_finish_db) - 1]['con_lai_sau_thanh_toan']['goc_con_lai'] ?? 0;
					// MPG: 000009228 - PT tất toán miễn giảm bị tách ra 02 PT cùng ngày nhưng trùng vs PT thanh toán kỳ thông thường.
					if ( ($value['code_contract'] == '000009228') ) {
						$value['tien_goc_con_truoc_mien_giam'] = 0;
					}
				}
				$value['tien_khach_dong_ngay_tao_phieu_thu_mien_giam'] = 0;
				$value['tien_tat_toan_can_thu_tu_khi_vay'] = 0;
				$value['tien_con_lai_can_thu_tai_ngay_tat_toan'] = 0;
				$value['tien_mien_giam_goc'] = 0;
				$value['tien_mien_giam_lai'] = 0;
				$value['tien_mien_giam_phi'] = 0;
				if (!empty($trans_payment_finish_db) && $value['type_payment_exem'] == 2) {
					$phai_tra_hop_dong = $trans_payment_finish_db['phai_tra_hop_dong'] ?? array();
					$tat_toan_phai_tra = $trans_payment_finish_db['tat_toan_phai_tra'] ?? array();
					$chia_mien_giam = $trans_payment_finish_db['chia_mien_giam'] ?? array();
					//Tiền khách đóng tại ngày tất toán
						$value['tien_khach_dong_ngay_tao_phieu_thu_mien_giam'] = (int)$trans_payment_finish_db['total'] ?? 0;
						//tien KH dong cung ngay tat toan
						$trans_same_day_finish = $this->transaction_model->find_where_select(
							[
								'code_contract' => $value['code_contract'],
								'status' => 1,
								'date_pay' => array('$lte' => strtotime(date('Y-m-d', $trans_payment_finish_db['date_pay']) . ' 23:59:59'),
													'$gte' => strtotime(date('Y-m-d', $trans_payment_finish_db['date_pay']) . ' 00:00:00')
													),
							], ['total','date_pay','created_at']);
						if (count($trans_same_day_finish) > 1) {
							$value['tien_khach_dong_ngay_tao_phieu_thu_mien_giam'] = 0;
							foreach ($trans_same_day_finish as $tran_same) {
								//Case đặc biệt: 000009228, có PT thanh toán kỳ thông thường trùng vs ngày tạo PT tất toán miễn giảm
								$text_created_at_same_normal = !empty($tran_same['created_at']) ? date('Y-m-d', $tran_same['created_at']) : '';
								if (($value['code_contract'] == '000009228') && $text_created_at_same_normal == '2022-05-23') continue;
								$value['tien_khach_dong_ngay_tao_phieu_thu_mien_giam'] += $tran_same['total'];
							}
						}
					//Tổng tiền tất toán cần thu từ khi vay
						$value['tien_tat_toan_can_thu_tu_khi_vay'] = $phai_tra_hop_dong['so_tien_goc_phai_tra_hop_dong']
																+ $phai_tra_hop_dong['so_tien_lai_phai_tra_hop_dong']
																+ $phai_tra_hop_dong['so_tien_phi_phai_tra_hop_dong']
																+ $phai_tra_hop_dong['phi_gia_han_phai_tra_hop_dong']
																+ $phai_tra_hop_dong['phi_cham_tra_phai_tra_hop_dong']
																+ $phai_tra_hop_dong['phi_tat_toan_phai_tra_hop_dong']
																+ $phai_tra_hop_dong['phi_phat_sinh_phai_tra_hop_dong'];
					//Tiền tất toán hợp lệ trên hệ thống, tại ngày tất toán
						$value['tien_con_lai_can_thu_tai_ngay_tat_toan'] = $tat_toan_phai_tra['so_tien_goc_phai_tra_tat_toan']
																+ $tat_toan_phai_tra['so_tien_lai_phai_tra_tat_toan']
																+ $tat_toan_phai_tra['so_tien_phi_phai_tra_tat_toan']
																+ $tat_toan_phai_tra['so_tien_phi_cham_tra_phai_tra_tat_toan']
																+ $tat_toan_phai_tra['so_tien_phi_gia_han_phai_tra_tat_toan']
																+ $tat_toan_phai_tra['so_tien_phi_phat_sinh_phai_tra_tat_toan']
																+ $phai_tra_hop_dong['phi_tat_toan_phai_tra_hop_dong'];
					// MPG: 0000013848 - PT Tất toán miễn giảm bị tách ra 02 PT khác ngày
					if ( ($value['code_contract'] == '0000013848') ) {
						$value['tien_con_lai_can_thu_tai_ngay_tat_toan'] = 5035259;
						$trans_nearest_finish = $this->transaction_model->find_where_select(
							[
								'code_contract' => $value['code_contract'],
								'status' => 1,
								'date_pay' => array('$lt' => strtotime(date('Y-m-d', $trans_payment_finish_db['date_pay']) . ' 00:00:00')),
							], ['date_pay','total']);
						$value['tien_khach_dong_ngay_tao_phieu_thu_mien_giam'] += $trans_nearest_finish[count($trans_nearest_finish)-1]['total'] ?? 0;
					}
					// MPG: 000009228 - PT tất toán miễn giảm bị tách ra 02 PT cùng ngày nhưng trùng vs PT thanh toán kỳ thông thường.
					if ( ($value['code_contract'] == '000009228') ) {
						$value['tien_con_lai_can_thu_tai_ngay_tat_toan'] = 1630402;
					}
					// MPG: 000006469 - PT tất toán miễn giảm bị tách ra 02 PT cùng ngày nhưng trùng vs PT thanh toán kỳ thông thường.
					if ( ($value['code_contract'] == '000006469')) {
						$value['tien_con_lai_can_thu_tai_ngay_tat_toan'] = 23564833;
					}
					$value['tien_mien_giam_goc'] = $chia_mien_giam['so_tien_goc_da_tra'] ?? 0;
					$value['tien_mien_giam_lai'] = $chia_mien_giam['so_tien_lai_da_tra'] ?? 0;
					$value['tien_mien_giam_phi'] = $chia_mien_giam['so_tien_phi_da_tra'] ?? 0;
					$value['amount_tp_thn_suggest'] = $trans_payment_finish_db['total_deductible'] ?? $value['amount_tp_thn_suggest'];
				} else {
					$chia_mien_giam = $trans_payment_db['chia_mien_giam'] ?? array();
					$value['tien_mien_giam_goc'] = $chia_mien_giam['so_tien_goc_da_tra'] ?? 0;
					$value['tien_mien_giam_lai'] = $chia_mien_giam['so_tien_lai_da_tra'] ?? 0;
					$value['tien_mien_giam_phi'] = $chia_mien_giam['so_tien_phi_da_tra'] ?? 0;
					//=== Case đã duyệt ĐMG nhưng chưa tạo PT Tat toan liên quan => Lấy tien_goc_con_truoc_mien_giam
					if ($value['type_payment_exem'] == '2') {
						$value['tien_goc_con_truoc_mien_giam'] = $value['tong_tien_goc_con'] ?? 0;
					}
				}
				if ($value['type_payment_exem'] == 1) {
					//Get các PT thanh toán kỳ thành công trước ngày duyệt ĐMG để lấy tiền KH đóng tại ngày tạo PTMG
					$trans_before_exemp_normal_db = $this->transaction_model->find_where_select(
						[
							'code_contract' => $value['code_contract'],
							'type' => 4,
							'status' => 1,
							'date_pay' => array('$lt' => strtotime(date('Y-m-d', $value['updated_at']) . ' 23:59:59')),
						], ['date_pay','total_deductible','total','ky_tra_hien_tai']);
					foreach ($trans_before_exemp_normal_db as $transa_normal) {
						if ((int)$transa_normal['total_deductible'] > 0) {
							$value['tien_khach_dong_ngay_tao_phieu_thu_mien_giam'] = (int)$transa_normal['total'] ?? 0;
						}
					}
					//Ngoại lệ: Ngày tạo PT miễn giảm không thuộc kỳ MG trong DMG của hệ thống
					if (($value['code_contract'] == '0000011751')) {
						$trans_exeption_0000011751 = $this->transaction_model->find_one_select(
							[
								'code_contract' => $value['code_contract'],
								'type' => 4,
								'status' => 1,
								'ky_tra_hien_tai' => $value['ky_tra']
							],['date_pay','total','total_deductible','ky_tra_hien_tai','code']);
						$value['tien_khach_dong_ngay_tao_phieu_thu_mien_giam'] = (int)$trans_exeption_0000011751['total'] ?? 0;
					}
				}
				// Xử lý các case ngoại lệ
				//=== Tìm PT gia hạn thành công
				$trans_gh_db = $this->transaction_model->findOne(['code_contract' => $value['code_contract'],'type_payment' => 2, 'status' => 1, 'total_deductible' => array('$gt' => 0)]);
				if (!empty($trans_gh_db)) {
					$value['tong_tien_da_thu_truoc_mien_giam'] = 0;
					// Tìm các PT thanh toán trước ngày gia hạn
					$trans_payment_before_gh_db = $this->transaction_model->find_where_select(
						[
							'code_contract' => $value['code_contract'],
							'status' => 1,
							'date_pay' => array('$lt' => strtotime(date('Y-m-d', $trans_gh_db['date_pay']) . ' 00:00:00')),
						], ['con_lai_sau_thanh_toan.goc_con_lai','date_pay','total']);
					if (!empty($trans_payment_before_gh_db)) {
						$value['tien_goc_con_truoc_mien_giam'] = $trans_payment_before_gh_db[count($trans_payment_before_gh_db) - 1]['con_lai_sau_thanh_toan']['goc_con_lai'] ?? 0;
						foreach ($trans_payment_before_gh_db as $trans_gh) {
							$value['tong_tien_da_thu_truoc_mien_giam'] += (int)$trans_gh['total'];
						}
					}
					// Tìm các PT thanh toán cùng ngày miễn giảm gia hạn
					$trans_payment_same_gh_db = $this->transaction_model->find_where_select(
						[
							'code_contract' => $value['code_contract'],
							'status' => 1,
							'date_pay' => array('$lte' => strtotime(date('Y-m-d', $trans_gh_db['date_pay']) . ' 23:59:59'),
												'$gte' => strtotime(date('Y-m-d', $trans_gh_db['date_pay']) . ' 00:00:00')),
						], ['date_pay','total']);
					if (count($trans_payment_same_gh_db) > 1) {
						$value['tien_khach_dong_ngay_tao_phieu_thu_mien_giam'] = 0;
						foreach ($trans_payment_same_gh_db as $trans_gh_same) {
							$value['tien_khach_dong_ngay_tao_phieu_thu_mien_giam'] += (int)$trans_gh_same['total'];
						}
					}
				}
				// Nếu hình thức vay là Gốc cuối kỳ thì gốc còn lại sẽ = tiền vay
				if ($value['type_interest'] == 2) {
					$value['tien_goc_con_truoc_mien_giam'] = $value['tong_tien_goc_con'] ?? 0;
				}
				// Case ngoại lệ, có nhiều ĐMG thanh toán kỳ, lấy tổng đã thu trước MG
				$exemption_dbs = $this->exemptions_model->find_where(['code_contract' => $value['code_contract'], 'type_payment_exem' => '1', 'status' => array('$in' => [5,7])]);
				if (count($exemption_dbs) > 1) {
					$trans_payment_period_db = $this->transaction_model->find_one_select(
						[
							'code_contract' => $value['code_contract'],
							'type' => 4,
							'status' => 1,
							'ky_tra_hien_tai' => $value['ky_tra'],
							'date_pay' => array('$lt' => strtotime(date('Y-m-d', $value['updated_at']) . ' 23:59:59')),
						],['date_pay','total','total_deductible','ky_tra_hien_tai','code']);
					$trans_payment_period_dbs = $this->transaction_model->find_where_select(
						[
							'code_contract' => $value['code_contract'],
							'type' => 4,
							'status' => 1,
							'date_pay' => array('$lt' => strtotime(date('Y-m-d', $trans_payment_period_db['date_pay']) . ' 00:00:00')),
						],['date_pay','total','total_deductible','ky_tra_hien_tai','code','code_contract']);
					$value['tong_tien_da_thu_truoc_mien_giam'] = $this->transaction_model->sum_where(
						[
							'code_contract' => $value['code_contract'],
							'status' => 1,
							'type' => 4,
							'date_pay' => array('$lt' => strtotime(date('Y-m-d', $trans_payment_period_db['date_pay']) . ' 00:00:00')),
						], array('$toDouble' => '$total'));

				}
			}
		}
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'data' => $data_exemption,
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	//lấy hết hợp đồng đã được duyệt giảm (blackList)
	public function getAllContractExempted_post()
	{
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;
		$this->dataPost = $this->input->post();
		// var_dump($this->dataPost); die;
		$condition = !empty($this->dataPost['condition']) ? $this->dataPost['condition'] : array();
		$store_id = !empty($this->dataPost['store_id']) ? $this->dataPost['store_id'] : "";
		$id_card = !empty($this->dataPost['id_card']) ? $this->dataPost['id_card'] : "";
		$status = !empty($this->dataPost['status']) ? $this->dataPost['status'] : "17";
		$status_disbursement = !empty($this->dataPost['status_disbursement']) ? $this->dataPost['status_disbursement'] : "";
		$start = !empty($this->dataPost['start']) ? $this->dataPost['start'] : "";
		$end = !empty($this->dataPost['end']) ? $this->dataPost['end'] : "";
		$customer_name = !empty($this->dataPost['customer_name']) ? $this->dataPost['customer_name'] : "";
		$customer_phone_number = !empty($this->dataPost['customer_phone_number']) ? $this->dataPost['customer_phone_number'] : "";
		$code_contract_disbursement = !empty($this->dataPost['code_contract_disbursement']) ? $this->dataPost['code_contract_disbursement'] : "";
		$code_contract = !empty($this->dataPost['code_contract']) ? $this->dataPost['code_contract'] : "";
		$customer_identify = !empty($this->dataPost['customer_identify']) ? $this->dataPost['customer_identify'] : "";
		if (!empty($start) && !empty($end)) {
			$condition = [
				'start' => $start,
				'end' => $end
			];
		} else if (!empty($start)) {
			$condition = [
				'start' => $start,
			];
		} else if (!empty($end)) {
			$condition = [
				'end' => $end,
			];
		}
		// var_dump($condition); die;
		if (!empty($status)) {
			$condition['status'] = $status;
		}
		if (!empty($status_disbursement)) {
			$condition['status_disbursement'] = $status_disbursement;
		}
		if (!empty($investor_code)) {
			$condition['investor_code'] = $investor_code;
		}
		if (!empty($store_id)) {
			$condition['store_id'] = $store_id;
		}
		if (!empty($customer_name)) {
			$condition['customer_name'] = trim($customer_name);
		}
		if (!empty($customer_phone_number)) {
			$condition['customer_phone_number'] = trim($customer_phone_number);
		}
		if (!empty($code_contract_disbursement)) {
			$condition['code_contract_disbursement'] = trim($code_contract_disbursement);
		}
		if (!empty($code_contract)) {
			$condition['code_contract'] = trim($code_contract);
		}
		if (!empty($customer_identify)) {
			$condition['customer_identify'] = trim($customer_identify);
		}
		$groupRoles = $this->getGroupRole($this->id);
		$all = false;
		if (in_array('cua-hang-truong', $groupRoles) || in_array('quan-ly-khu-vuc', $groupRoles) || in_array('giao-dich-vien', $groupRoles)) {
			$all = true;
		}
		if (!empty($code_contract_disbursement) || !empty($customer_name) || !empty($customer_phone_number)) {
			$all = false;
		}
		// if ($all) {
		// 	$stores = $this->getStores($this->id);
		// 	if (empty($stores)) {
		// 		$response = array(
		// 			'status' => REST_Controller::HTTP_OK,
		// 			'data' => array()
		// 		);
		// 		$this->set_response($response, REST_Controller::HTTP_OK);
		// 		return;
		// 	}
		// 	$condition['stores'] = $stores;
		// }
		$per_page = !empty($this->input->post()['per_page']) ? $this->input->post()['per_page'] : 30;
		$uriSegment = !empty($this->input->post()['uriSegment']) ? $this->input->post()['uriSegment'] : 0;
		$contract = array();
		$data_exemption = $this->exemptions_model->getAllContractExempted(array(), $condition, $per_page, $uriSegment);
		$condition['total'] = true;
		$total = $this->exemptions_model->getAllContractExempted(array(), $condition);


		$response = [
			'status' => REST_Controller::HTTP_OK,
			'data' => $data_exemption,
			'total' => $total
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}


	//insert thêm customer_identify (nếu bản ghi nào chưa có) 
	public function insertIdentify_post() {
		$data = $this->input->post();
		$getContractExemption = $this->exemptions_model->find_where(['status' => ['$in' => [1,2,3,4,5,6,7,8,9]]]);
		foreach($getContractExemption as $c) {
			if (!empty($c['code_contract'])) {
				$codeContract[] =  $c['code_contract'];
			}
		}
		//lấy trong table contract
		$contracts = $this->contract_model->find_where(['code_contract' => ['$in' => $codeContract]]);
		foreach ($contracts as $key => $contract) {
			if (empty($contract['customer_identify'])) {
				$this->exemptions_model->update(['code_contract' => $contract['code_contract']],
				[
					"customer_identify" => $contract['customer_infor']['customer_identify'],
				]);
			}
			if (empty($contract['scan'])) {
				$this->exemptions_model->update(['code_contract' => $contract['code_contract']],
				[
					"scan" => 1,
				]);
			}
		}
		$response = [
			'status' => REST_Controller::HTTP_OK,
			"messages" => "OK",
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	//xuất excel đơn miễn giảm
	public function exportExcelExempted_post()
	{
		$dataPost = $this->input->post();
		$start = !empty($this->dataPost['start']) ? $this->dataPost['start'] : "";
		$end = !empty($this->dataPost['end']) ? $this->dataPost['end'] : "";
		$customer_name = !empty($dataPost['customer_name']) ? $dataPost['customer_name'] : "";
		$customer_identify = !empty($dataPost['customer_identify']) ? $dataPost['customer_identify'] : "";
		$customer_phone_number = !empty($dataPost['customer_phone_number']) ? $dataPost['customer_phone_number'] : "";
		$code_contract = !empty($dataPost['code_contract']) ? $dataPost['code_contract'] : "";
		$code_contract_disbursement = !empty($dataPost['code_contract_disbursement']) ? $dataPost['code_contract_disbursement'] : "";
		$store = !empty($dataPost['store_id']) ? $dataPost['store_id'] : "";
		if (!empty($start) && !empty($end)) {
			$condition = [
				'start' => $start,
				'end' => $end
			];
		} else if (!empty($start)) {
			$condition = [
				'start' => $start
			];
		} else if (!empty($end)) {
			$condition = [
				'end' => $end
			];
		}
		if (!empty($customer_name)) {
			$condition['customer_name'] = trim($customer_name);
		}
		if (!empty($customer_phone_number)) {
			$condition['customer_phone_number'] = trim($customer_phone_number);
		}
		if (!empty($code_contract_disbursement)) {
			$condition['code_contract_disbursement'] = trim($code_contract_disbursement);
		}
		if (!empty($store)) {
			$condition['store_id'] = $store;
		}
		if (!empty($code_contract)) {
			$condition['code_contract'] = trim($code_contract);
		}
		if (!empty($customer_identify)) {
			$condition['customer_identify'] = trim($customer_identify);
		}

		$data_exempted = $this->exemptions_model->exportExcelExempted($condition);
		if (!empty($data_exempted)) {
			foreach ($data_exempted as $value) {
				$dataContract = $this->contract_model->find_one_select(['code_contract' => $value['code_contract']], ['disbursement_date', 'loan_infor.type_interest', 'status', 'expire_date', 'loan_infor.amount_money','original_debt.du_no_goc_con_lai','debt.so_ngay_cham_tra','store']);
				if (!empty($dataContract)) {
					$value['type_interest'] = $dataContract['loan_infor']['type_interest'];
					$value['disbursement_date'] = $dataContract['disbursement_date'];
					$value['statusContract'] = $dataContract['status'];
					$value['expire_date'] = $dataContract['expire_date'];
					$value['amount_money'] = $dataContract['loan_infor']['amount_money'];
					$value['tong_tien_goc_con'] = $dataContract['original_debt']['du_no_goc_con_lai'];
					$value['bucket'] = $dataContract['debt']['so_ngay_cham_tra'];
					$value['store'] = $dataContract['store']['name'];
				}
				//Tổng tiền đã thu trước thời điểm tất toán
				$value['totalTran'] = 0;
				$total_where = $this->transaction_model->find_where_select(['code_contract' => $value['code_contract'], 'status' => 1, 'type' => array('$in' => [4, 5])], ['total']);
				if(!empty($total_where)){
					foreach ($total_where as $item){
						$value['totalTran'] += (int)$item['total'];
					}
				}
				//Tổng cần thu (gốc + lãi + phí)
				$value['total_tong_can_thu'] = $this->transaction_model->sum_where(['code_contract' => $value['code_contract'], 'status' => 1, 'type' => array('$in' => [3])], '$amount_total');
				//Khách hàng thanh toán tại ngày tất toán
				$value['total_thanh_toan_tat_toan'] = $this->transaction_model->sum_where(['code_contract' => $value['code_contract'], 'status' => 1, 'type' => array('$in' => [3])], '$total');
			}
		}
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'data' => $data_exempted,
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function getContractExemption_post()
	{
		$data = $this->input->post();
		$id = $data['id_contract'];
		$contract = $this->exemptions_model->find_where(['id_contract' => $id, 'status' => ['$in' => [5,7]]]);
		$response = [
			'status' => REST_Controller::HTTP_OK,
			"messages" => "OK",
			"data" => $contract,
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function getIdentify_post()
	{
		$data = $this->input->post();
		$id = $data['id_contract'];
		$arrIdentify = false;
		$customer_identify = $data['customer_identify'];
		$contract = $this->contract_model->findOne(['_id' =>  new \MongoDB\BSON\ObjectId($id)]);
		if(!empty($contract)) {
			$contract_debt = $this->exemptions_model->findOne(['customer_identify' => $contract['customer_infor']['customer_identify']]);
			if (!empty($contract_debt)) {
				$arrIdentify = true;
			}
		}	
		$response = [
			'status' => REST_Controller::HTTP_OK,
			"messages" => "OK",
			"data" => $arrIdentify,
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function getContractExempted_post()
	{
		$exempteds = $this->exemptions_model->find_where(['scan' => 1, 'status' => ['$in' => [5, 7]], 'customer_identify' => ['$exists' => true]]);
		if ($exempteds) {
			$bool = $this->updateScanStatus($exempteds);
			if ($bool) {
				$response = [
					'status' => REST_Controller::HTTP_OK,
					"messages" => "Thành Công",
					"data" => $exempteds,
				];
			} else {
				$response = [
					'status' => REST_Controller::HTTP_BAD_REQUEST,
					'message' => 'ok',
				];
			}
		} else {
			$response = [
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => 'error',
			];
		}
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function getDetailExemption_post()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : '';
		$exemption = $this->exemptions_model->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'Thành Công',
			'data' => $exemption
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function updateScanStatus($data)
	{
		if ($data) {
			foreach ($data as $item) {
				$this->exemptions_model->update(['_id' => new MongoDB\BSON\ObjectId($item->_id)], [
					'scan' => 2
				]);
			}
			return true;
		} else {
			return false;
		}

	}

	//get all exemptions and hsmg
	public function get_exemptions_by_status_profile_post()
	{
		$tab = !empty($this->security->xss_clean($this->dataPost['tab'])) ? $this->security->xss_clean($this->dataPost['tab']) : '';
		$from_date = !empty($this->security->xss_clean($this->dataPost['from_date'])) ? $this->security->xss_clean($this->dataPost['from_date']) : '';
		$to_date = !empty($this->security->xss_clean($this->dataPost['to_date'])) ? $this->security->xss_clean($this->dataPost['to_date']) : '';
		$store = !empty($this->security->xss_clean($this->dataPost['store'])) ? $this->security->xss_clean($this->dataPost['store']) : '';
		$status = !empty($this->security->xss_clean($this->dataPost['status'])) ? $this->security->xss_clean($this->dataPost['status']) : '';
		$type_send = !empty($this->security->xss_clean($this->dataPost['type_send'])) ? $this->security->xss_clean($this->dataPost['type_send']) : '';
		$postal_code = !empty($this->security->xss_clean($this->dataPost['postal_code'])) ? $this->security->xss_clean($this->dataPost['postal_code']) : '';
		$bbbg_code = !empty($this->security->xss_clean($this->dataPost['bbbg_code'])) ? $this->security->xss_clean($this->dataPost['bbbg_code']) : '';
		$domain_exemption = !empty($this->security->xss_clean($this->dataPost['domain_exemption'])) ? $this->security->xss_clean($this->dataPost['domain_exemption']) : '';
		$customer_name = !empty($this->security->xss_clean($this->dataPost['customer_name'])) ? $this->security->xss_clean($this->dataPost['customer_name']) : '';
		$code_contract = !empty($this->security->xss_clean($this->dataPost['code_contract'])) ? $this->security->xss_clean($this->dataPost['code_contract']) : '';
		$code_contract_disbursement = !empty($this->security->xss_clean($this->dataPost['code_contract_disbursement'])) ? $this->security->xss_clean($this->dataPost['code_contract_disbursement']) : '';
		$per_page = !empty($this->security->xss_clean($this->dataPost['per_page'])) ? $this->security->xss_clean($this->dataPost['per_page']) : '';
		$uriSegment = !empty($this->security->xss_clean($this->dataPost['uriSegment'])) ? $this->security->xss_clean($this->dataPost['uriSegment']) : '';
		$id_profile_mb = $this->get_domain_profile_exemption_mb($this->id);
		$id_profile_mn = $this->get_domain_profile_exemption_mn($this->id);
		if ($id_profile_mb) {
			$condition['domain_area'] = 'MB';
		} elseif ($id_profile_mn) {
			$condition['domain_area'] = 'MN';
		}
		if ($tab == 'normal') {
			if (!empty($status)) {
				if (!$id_profile_mb && !$id_profile_mn) {
					if (!in_array($status, [5])) {
						$response = [
							'status' => REST_Controller::HTTP_BAD_REQUEST,
							'message' => 'Trạng thái không hợp lệ!'
						];
						return $this->set_response($response, REST_Controller::HTTP_OK);
					}
				} else {
					if (!in_array($status, [1, 8])) {
						$response = [
							'status' => REST_Controller::HTTP_BAD_REQUEST,
							'message' => 'Trạng thái không hợp lệ!'
						];
						return $this->set_response($response, REST_Controller::HTTP_OK);
					}
				}
			}
		}
		if (!empty($from_date) && !empty($to_date)) {
			$condition['from_date'] = strtotime(trim($from_date) . ' 00:00:00');
			$condition['to_date'] = strtotime(trim($to_date). ' 23:59:59');
		}
		if (!empty($store)) {
			$condition['store'] = $store;
		}
		if (!empty($tab)) {
			$condition['tab'] = $tab;
		}
		if (!empty($status)) {
			$condition['status'] = $status;
		}
		if (!empty($domain_exemption)) {
			$condition['domain_area'] = $domain_exemption;
		}
		if (!empty($type_send)) {
			$condition['type_send'] = $type_send;
		}
		if (!empty($postal_code)) {
			$condition['postal_code'] = $postal_code;
		}
		if (!empty($bbbg_code)) {
			$condition['bbbg_code'] = $bbbg_code;
		}
		if (!empty($customer_name)) {
			$condition['customer_name'] = trim($customer_name);
		}
		if (!empty($customer_phone_number)) {
			$condition['customer_phone_number'] = trim($customer_phone_number);
		}
		if (!empty($code_contract)) {
			$condition['code_contract'] = trim($code_contract);
		}
		if (!empty($code_contract_disbursement)) {
			$condition['code_contract_disbursement'] = trim($code_contract_disbursement);
		}
		if ($tab == 'all') {
			$exemptions = $this->exemptions_model->get_exems_by_status_profile($condition, $per_page, $uriSegment);
			$condition['total'] = true;
			$total = $this->exemptions_model->get_exems_by_status_profile($condition);
		} else if (in_array($tab, ['normal', 'exception', 'asset']) ) {
			$exemptions = $this->exemptions_model->get_exemptions_none_paginate($condition);
			$total = count($exemptions);
		} else if ( in_array($tab, ['profile_normal', 'profile_exception', 'profile_asset']) ) {
			$exemption_profiles = $this->profile_exemption_model->get_all_profile($condition, $per_page, $uriSegment);
			$condition['total'] = true;
			$total = $this->profile_exemption_model->get_all_profile($condition);
		}
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'data' => $exemptions,
			'profiles' => $exemption_profiles,
			'total' => $total ?? ''
		];
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}

	//update confirm email của CEO
	public function update_profile_exemption_post()
	{
		$data = $this->input->post();
		unset($data['type']);
		$id_exemption = !empty($this->security->xss_clean($data['id_exemption'])) ? $this->security->xss_clean($data['id_exemption']) : '';
		$option = !empty($this->security->xss_clean($data['option'])) ? $this->security->xss_clean($data['option']) : '';
		$exemption_db = $this->exemptions_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($id_exemption)]);

		if ($option == 1) {
			//update thông tin email ĐMG được CEO confirm
			$arrayUpdate = [
				'confirm_email' => (int)$option,
			];
			$log = [
				'type' => 'exemption_hs',
				'action' => 'update',
				'exemptions_id' => (string)$id_exemption['_id'],
				'old' => $id_exemption,
				'new' => $data,
				'created_at' => $this->createdAt,
				'created_by' => $this->uemail
			];
			//insert log
			$this->log_exemptions_model->insert($log);
		}
		$this->exemptions_model->update(
			['_id' => $exemption_db['_id']], $arrayUpdate
		);
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'Cập nhật thành công!'
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	//Tạo hồ sơ miễn giảm
	public function create_profile_exemption_post()
	{
		$profile_exemption = !empty($this->security->xss_clean($this->dataPost['profile'])) ? $this->security->xss_clean($this->dataPost['profile']) : array();
		$profile_old_id = !empty($this->security->xss_clean($this->dataPost['profile_old_id'])) ? $this->security->xss_clean($this->dataPost['profile_old_id']) : '';
		$profile_note = !empty($this->security->xss_clean($this->dataPost['profile_note'])) ? $this->security->xss_clean($this->dataPost['profile_note']) : '';
		$current_month = date('m');
		$current_year = date('y');
		$finance_department = $this->config->item("FINANCE_DEPARTMENT");
		$address_mb =$this->config->item("ADDRESS_HO_MB");
		$address_mn =$this->config->item("ADDRESS_HO_MN");
		$is_user_thn = $this->get_id_thn_departments($this->id);
		$is_user_kt = $this->get_id_finances($this->id);
		$is_thn_mb = $this->get_domain_profile_exemption_mb($this->id);
		$is_thn_mn = $this->get_domain_profile_exemption_mn($this->id);
		if (empty($profile_exemption)) {
			$response = [
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => 'Bạn chưa tích chọn đơn miễn giảm!'
			];
			return $this->set_response($response, REST_Controller::HTTP_OK);
		}
		$status_check = [];
		$domain_area_check = [];
		$type_exception = [];
		foreach ($profile_exemption as $exemption) {
			$exemption_db = $this->exemptions_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($exemption)]);
			array_push($status_check, $exemption_db['status_profile']);
			array_push($domain_area_check, $exemption_db['domain_exemption']);
			array_push($type_exception, $exemption_db['type_exception']);
		}
		//check nếu user role thuộc QLHĐV sẽ ko cho tạo HSMG với trạng thái mới tích Trả về
		if ($is_user_thn) {
			if ( in_array(5, $status_check) ) {
				$response = [
					'status' => REST_Controller::HTTP_BAD_REQUEST,
					'message' => 'Tạo hồ sơ thất bại, tồn tại đơn miễn giảm có trạng thái không hợp lệ!'
				];
				return $this->set_response($response, REST_Controller::HTTP_OK);
			}
		}
		if ($is_user_kt) {
			if ( in_array(1, $status_check) || in_array(8, $status_check) ) {
				$response = [
					'status' => REST_Controller::HTTP_BAD_REQUEST,
					'message' => 'Tạo hồ sơ thất bại, tồn tại đơn miễn giảm có trạng thái không hợp lệ!'
				];
				return $this->set_response($response, REST_Controller::HTTP_OK);
			}
		}
		if ($is_user_kt) {
			$domain_area_checks = array_unique($domain_area_check);
			if ( count($domain_area_checks) > 1 ) {
				$response = [
					'status' => REST_Controller::HTTP_BAD_REQUEST,
					'message' => 'Tạo hồ sơ thất bại, tồn tại đơn miễn giảm khác khu vực còn lại!'
				];
				return $this->set_response($response, REST_Controller::HTTP_OK);
			}
		}
		$domain_area_checks = array_unique($domain_area_check);
		$domain_exemp = $domain_area_checks[0];
		if ($domain_exemp == 'MB') {
			$province_doc = 'Hà Nội';
			$explain_address = 'Miền Bắc';
			$address_thn = $address_mb;
		} elseif ($domain_exemp == 'MN') {
			$province_doc = 'Thành phố Hồ Chí Minh';
			$explain_address = 'Miền Nam';
			$address_thn = $address_mn;
		}
		if ($is_user_thn) {
			$type_send = 1;
			$status = 2;
			$profile_note = 'Tạo mới hồ sơ miễn giảm';
		} elseif ($is_user_kt) {
			$type_send = 2;
			$status = 9;
			$profile_note = 'Trả về hồ sơ miền giảm';
			$province_doc = 'Hà Nội';
		}
		if (!empty($type_send)) {
			if ($type_send == 1) {
				$type_send_text = 'GUI';
			} elseif ($type_send == 2) {
				$type_send_text = 'TRA';
			} elseif ($type_send == 3) {
				$type_send_text = 'THIEU';
			}
		}
		$condition = [
			'current_month' => $current_month,
			'current_year' => $current_year,
			'type_send' => $type_send
		];
		$count = $this->profile_exemption_model->count_profile_by_month($condition);
		if (!empty($count) && $count < 10) {
			$count = '0' . ($count + 1);
		} elseif (!empty($count) && $count > 10) {
			$count = ($count + 1);
		} else {
			$count = '0' . ($count + 1);
		}
		if (in_array(1, $type_exception)) {
			$tail = ' - ' . 'NL';
			$redirect = 1;
		} elseif (in_array(2, $type_exception)) {
			$tail = ' - ' . 'TLTS';
			$redirect = 2;
		} else {
			$tail = '';
		}
		$profile_name = 'HSMG/' . $type_send_text . '/QLHĐV' . $domain_exemp. '/' . $current_year . $current_month . '/' . $count . $tail;
		$code_security = 'HSMG'. date('Ymd') . '_' . uniqid();
		if (!empty($profile_exemption)) {
			foreach ($profile_exemption as $exemp) {
				$exemption = $this->exemptions_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($exemp)]);
				$dataUpdate = [
					'status_profile' => $status,
					'code_parent' => $code_security,
					'profile_name' => $profile_name,
					'type_send' => $type_send, //GUI, TRA, THIEU HS
					'is_bbbg_profile' => 1,
					'profile_note' => $profile_note
				];
				$this->exemptions_model->update(
					['_id' => $exemption['_id']], $dataUpdate
				);
				$log = [
					'type' => 'exemptions',
					'action' => 'update',
					'exemptions_id' => (string)$exemption['_id'],
					'old' => $exemption,
					'new' => $dataUpdate,
					'created_at' => $this->createdAt,
					'created_by' => $this->uemail
				];
				//insert log
				$this->log_exemptions_model->insert($log);
			}
			$user_send = $this->user_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($this->id)]);
			$user_name_send = $user_send['full_name'] ? $user_send['full_name'] : '';
			$dataInsert = [
				'code_ref' => $code_security,
				'profile_name' => $profile_name,
				//infor SEND
				'user_send' => $user_name_send,
				'position_user_send' => ($is_user_thn) ? ('Phòng Quản lý hợp đồng vay ' . $explain_address) : $finance_department,
				'address_send' => ($is_user_thn) ? ($address_thn) : $address_mb,
				//infor RECEIVE
				'user_receive' => ($is_user_thn) ? ($finance_department) : ('Phòng Quản lý hợp đồng vay ' . $explain_address),
				'position_user_receive' => ($is_user_thn) ? ($finance_department) : ('Phòng Quản lý hợp đồng vay ' . $explain_address),
				'address_receive' => ($is_user_thn) ? ($address_mb) : ($address_thn),

				'month' => $current_month,
				'year' => $current_year,
				'status' => $status,
				'type_send' => $type_send, //GUI, TRA, THIEU HS
				'province_doc' => $province_doc,
				'domain_area' => $domain_exemp,
				'is_bbbg_profile' => 1,
				'created_at' => $this->createdAt,
				'created_by' => $this->uemail
			];
			if (in_array(1, $type_exception)) {
				$dataInsert['type_exception'] = 1; //HSMG ngoại lệ, không có ĐMG bản giấy
			} elseif (in_array(2, $type_exception)) {
				$dataInsert['type_exception'] = 2; //HSMG TLTS chỉ bao gồm BBBG xe, ko có ĐMG bản giấy
			} else {
				$dataInsert['type_exception'] = 3; //HSMG loại thường có ĐMG bản giấy
			}
			//Tạo mới hồ sơ miễn giảm (chưa nhiều đơn miễn giảm con)
			$profile_id = $this->profile_exemption_model->insertReturnId($dataInsert);
			$log = [
				'type' => 'hsmg',
				'action' => 'create',
				'profile_id' => (string)$profile_id,
				'old' => $profile_old_id,
				'new' => $dataInsert,
				'created_at' => $this->createdAt,
				'created_by' => $this->uemail
			];
			//insert log
			$this->log_exemptions_model->insert($log);
		}
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => ($type_send_text == 'GUI') ? 'Tạo thành công hồ sơ miễn giảm "Gửi" !' : 'Tạo thành công hồ sơ miễn giảm "Trả về" !',
			'data' => $redirect
		];
		return $this->set_response($response, REST_Controller::HTTP_OK);

	}

	// Lấy thông tin chi tiết hồ so miễn giảm
	public function get_detail_profile_post()
	{
		$code_ref = $this->dataPost['code_ref'] ? $this->dataPost['code_ref'] : '';
		$profile = $this->profile_exemption_model->findOne(['code_ref' => $code_ref]);
		$exemptions_list = $this->exemptions_model->find_where(['code_parent' => $code_ref]);
		if (!empty($exemptions_list)) {
			$response = [
				'status' => REST_Controller::HTTP_OK,
				'data' => $exemptions_list,
				'profile' => $profile
			];
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
	}

	//Upload ảnh hSMG và mã bưu phẩm
	public function send_profile_post()
	{
		$code_ref = $this->dataPost['code_ref'] ? $this->dataPost['code_ref'] : '';
		$img_profile = $this->dataPost['img_profile'] ? $this->dataPost['img_profile'] : '';
		$type_send = $this->dataPost['type_send'] ? $this->dataPost['type_send'] : '';
		$type_exception = $this->dataPost['type_exception'] ? $this->dataPost['type_exception'] : '';
		$postal_code = $this->dataPost['postal_code'] ? $this->dataPost['postal_code'] : '';
		if (empty($img_profile)) {
			$response = [
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => 'Bạn chưa chọn ảnh upload!'
			];
			return $this->set_response($response, REST_Controller::HTTP_OK);
		}
		if (empty($postal_code)) {
			$response = [
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => 'Bạn chưa nhập "Mã bưu phẩm"!'
			];
			return $this->set_response($response, REST_Controller::HTTP_OK);
		}
		$postal_code_db = $this->profile_exemption_model->find_where(['postal_code' => $postal_code]);
		if (!empty($postal_code_db)) {
			$response = [
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => '"Mã bưu phẩm" đã tồn tại!'
			];
			return $this->set_response($response, REST_Controller::HTTP_OK);
		}
		$profile_db = $this->profile_exemption_model->findOne(['code_ref' => $code_ref]);
		if (empty($profile_db)) {
			$response = [
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => 'Không tồn tại hồ sơ miễn giảm - mã: ' . $code_ref
			];
			return $this->set_response($response, REST_Controller::HTTP_OK);
		} else {
			if ($type_send == 1) {
				$status = 3; //Đang gửi
			} elseif ($type_send == 2) {
				$status = 6; //Đang trả
			}

			$arrayUpdate = [
				'img_profile' => $img_profile,
				'postal_code' => $postal_code,
				'status' => (int)$status,
				'start_at' => $this->createdAt ? $this->createdAt : time(),
				'start_by' => $this->uemail ? $this->uemail : 'system'
			];
			$log = [
				'type' => 'hsmg',
				'action' => 'update',
				'profile_id' => (string)$profile_db['_id'],
				'old' => $profile_db,
				'new' => $arrayUpdate,
				'created_at' => $this->createdAt ? $this->createdAt : time(),
				'created_by' => $this->uemail ? $this->uemail : 'system'
			];
			//insert log
			$this->log_exemptions_model->insert($log);
			//update img và trạng thái Đang gửi (3) hoặc Đang trả (6)
			$this->profile_exemption_model->update(
				['_id' => $profile_db['_id']], $arrayUpdate
			);
			$exemptions_db = $this->exemptions_model->find_where(['code_parent' => $code_ref]);
			if (!empty($exemptions_db)) {
				foreach ($exemptions_db as $exemption) {
					//update trạng thái Đang gửi cho các ĐMG con
					$this->exemptions_model->update(
						['_id' => $exemption['_id']],[
							'status_profile' => (int)$status
						]
					);
					//insert log
					$log = [
						'type' => 'exemptions',
						'action' => 'update',
						'exemptions_id' => (string)$exemption['_id'],
						'old' => $exemption,
						'new' => ['status_profile' => (int)$status],
						'created_at' => $this->createdAt ? $this->createdAt : time(),
						'created_by' => $this->uemail ? $this->uemail : 'system'
					];
					$this->log_exemptions_model->insert($log);

				}
			}
		}
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'Gửi hồ sơ thành công!',
			'data' => $type_exception
		];
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}

	private function get_domain_profile_exemption_mb($user_id) {
		$roles = $this->role_model->findOne(['slug' => 'ho-so-mien-giam-mien-bac']);
		$array_user_id = array();
		$is_user_mb = false;
		if (!empty($roles)) {
			foreach ($roles['users'] as $role) {
				foreach ($role as $key => $item) {
					array_push($array_user_id, $key);
				}
			}
		}
		if (in_array($user_id, $array_user_id)) {
			$is_user_mb = true;
		} else {
			$is_user_mb = false;
		}
		return $is_user_mb;
	}

	public function is_thn_mb_post() {
		$user_id = $this->id;
		$roles = $this->role_model->findOne(['slug' => 'ho-so-mien-giam-mien-bac']);
		$array_user_id = array();
		$is_user_mb = false;
		if (!empty($roles)) {
			foreach ($roles['users'] as $role) {
				foreach ($role as $key => $item) {
					array_push($array_user_id, $key);
				}
			}
		}
		if (in_array($user_id, $array_user_id)) {
			$is_user_mb = true;
		} else {
			$is_user_mb = false;
		}
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'data' => $is_user_mb
		];
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}

	private function get_domain_profile_exemption_mn($user_id) {
		$roles = $this->role_model->findOne(['slug' => 'ho-so-mien-giam-mien-nam']);
		$array_user_id = array();
		$is_user_mn = false;
		if (!empty($roles)) {
			foreach ($roles['users'] as $role) {
				foreach ($role as $key => $item) {
					array_push($array_user_id, $key);
				}
			}
		}
		if (in_array($user_id, $array_user_id)) {
			$is_user_mn = true;
		} else {
			$is_user_mn = false;
		}
		return $is_user_mn;
	}

	public function is_thn_mn_post() {
		$user_id = $this->id;
		$roles = $this->role_model->findOne(['slug' => 'ho-so-mien-giam-mien-nam']);
		$array_user_id = array();
		$is_user_mn = false;
		if (!empty($roles)) {
			foreach ($roles['users'] as $role) {
				foreach ($role as $key => $item) {
					array_push($array_user_id, $key);
				}
			}
		}
		if (in_array($user_id, $array_user_id)) {
			$is_user_mn = true;
		} else {
			$is_user_mn = false;
		}
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'data' => $is_user_mn
		];
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}

	public function complete_profile_post()
	{
		$profile_exemption = !empty($this->security->xss_clean($this->dataPost['profile'])) ? $this->security->xss_clean($this->dataPost['profile']) : array();
		$profile_note = !empty($this->security->xss_clean($this->dataPost['profile_note'])) ? $this->security->xss_clean($this->dataPost['profile_note']) : '';
		$status = !empty($this->security->xss_clean($this->dataPost['status'])) ? $this->security->xss_clean($this->dataPost['status']) : '';
		$type_status = !empty($this->security->xss_clean($this->dataPost['type_status'])) ? $this->security->xss_clean($this->dataPost['type_status']) : '';
		$profile_old_id = !empty($this->security->xss_clean($this->dataPost['profile_old_id'])) ? $this->security->xss_clean($this->dataPost['profile_old_id']) : '';
		$profile_db = $this->profile_exemption_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($profile_old_id)]);

		//update hsmg
		$array_update = [
			'status' => (int)$status,
			'note' => $profile_note,
			'updated_at' => $this->createdAt ? $this->createdAt : time(),
			'updated_by' => $this->uemail ? $this->uemail : 'system'
		];
		if (!empty($type_status) && $type_status == 'THIEU') {
			$array_update['lack_note'] = $profile_note;
		}
		$this->profile_exemption_model->update(
			['_id' => $profile_db['_id']], $array_update
		);
		$log = [
			'type' => 'hsmg',
			'action' => 'update',
			'profile_id' => (string)$profile_db['_id'],
			'old' => $profile_db,
			'new' => $this->dataPost,
			'created_at' => $this->createdAt ? $this->createdAt : time(),
			'created_by' => $this->uemail ? $this->uemail : 'system'
		];
		//insert log
		$this->log_exemptions_model->insert($log);
		//update các đơn miễn giảm con
		foreach ($profile_exemption as  $profile_id) {
			$exemption_db = $this->exemptions_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($profile_id)]);
			$this->exemptions_model->update(
				['_id' => $exemption_db['_id']],[
					'status_profile' => (int)$status,
					'profile_note' => $profile_note,
					'created_at' => $this->createdAt ? $this->createdAt : time(),
					'created_by' => $this->uemail ? $this->uemail : 'system'
				]
			);
		}
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => $type_status == 'THIEU' ? 'Cập nhật thành công!' : 'Hoàn tất hồ sơ miễn giảm thành công!'
		];
		return $this->set_response($response, REST_Controller::HTTP_OK);

	}

	public function get_id_finance_post()
	{
		$roles = $this->role_model->find_where(['slug' => 'ke-toan']);
		$array_id_kt = [];
		$is_id_kt = false;
		if (!empty($roles)) {
			foreach ($roles[0]['users'] as $role) {
				foreach ($role as $key => $item) {
					array_push($array_id_kt, $key);
				}
			}
		}
		if (in_array($this->id, $array_id_kt)) {
			$is_id_kt = true;
		} else {
			$is_id_kt = false;
		}
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'data' => $is_id_kt
		];
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}

	public function get_id_thn_department_post()
	{
		$roles = $this->role_model->find_where(['slug' => 'phong-thu-hoi-no']);
		$array_thn_id = [];
		$is_id_thn = false;
		if (!empty($roles)) {
			foreach ($roles[0]['users'] as $role) {
				foreach ($role as $key => $item) {
					array_push($array_thn_id, $key);
				}
			}
		}
		if (in_array($this->id, $array_thn_id)) {
			$is_id_thn = true;
		} else {
			$is_id_thn = false;
		}
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'data' => $is_id_thn
		];
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}

	public function get_id_thn_departments($is_user)
	{
		$roles = $this->role_model->find_where(['slug' => 'phong-thu-hoi-no']);
		$array_thn_id = [];
		$is_user_thn = false;
		if (!empty($roles)) {
			foreach ($roles[0]['users'] as $role) {
				foreach ($role as $key => $item) {
					array_push($array_thn_id, $key);
				}
			}
		}
		if (in_array($is_user, $array_thn_id)) {
			$is_user_thn = true;
		} else {
			$is_user_thn = false;
		}
		return $is_user_thn;
	}

	public function get_id_finances($id_user)
	{
		$roles = $this->role_model->find_where(['slug' => 'ke-toan']);
		$array_id_kt = [];
		$is_user_kt = false;
		if (!empty($roles)) {
			foreach ($roles[0]['users'] as $role) {
				foreach ($role as $key => $item) {
					array_push($array_id_kt, $key);
				}
			}
		}
		if (in_array($id_user, $array_id_kt)) {
			$is_user_kt = true;
		} else {
			$is_user_kt = false;
		}
		return $is_user_kt;

	}

	//update one record exemptions
	public function update_exemption_spa_post()
	{
		$profile_note = !empty($this->security->xss_clean($this->dataPost['profile_note'])) ? $this->security->xss_clean($this->dataPost['profile_note']) : '';
		$exemption_id = !empty($this->security->xss_clean($this->dataPost['exemption_id'])) ? $this->security->xss_clean($this->dataPost['exemption_id']) : '';
		$exemption_status = !empty($this->security->xss_clean($this->dataPost['exemption_status'])) ? $this->security->xss_clean($this->dataPost['exemption_status']) : '';
		$profile_status = !empty($this->security->xss_clean($this->dataPost['profile_status'])) ? $this->security->xss_clean($this->dataPost['profile_status']) : '';
		$profile_code_ref = !empty($this->security->xss_clean($this->dataPost['profile_code_ref'])) ? $this->security->xss_clean($this->dataPost['profile_code_ref']) : '';
		$exemption_db = $this->exemptions_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($exemption_id)]);

		if (!empty($exemption_db)) {
			if (empty($exemption_status) && !empty($profile_note)) {
				$arrayUpdate = [
					'profile_note' => $profile_note,
					'updated_at' => $this->createdAt ? $this->createdAt : time(),
					'updated_by' => $this->uemail ? $this->uemail : 'system'
				];
			} elseif (!empty($exemption_status) && empty($profile_note)) {
				$arrayUpdate = [
					'status_profile' => (int)$exemption_status,
					'updated_at' => $this->createdAt ? $this->createdAt : time(),
					'updated_by' => $this->uemail ? $this->uemail : 'system'
				];
				if ($exemption_status == 5) {
					$arrayUpdate['type_send'] = 2;
					$arrayUpdate['is_bbbg_profile'] = '';
				} else if ($exemption_status == 7) {
					$arrayUpdate['type_send'] = 3;
					$arrayUpdate['is_bbbg_profile'] = '';
				} else if ($exemption_status == 8) {
					$arrayUpdate['is_bbbg_profile'] = '';
				}
			}
			$this->exemptions_model->update(
				['_id' => $exemption_db['_id']], $arrayUpdate
			);
			$log = [
				'type' => 'exemptions',
				'action' => 'update',
				'exemptions_id' => (string)$exemption_db['_id'],
				'old' => $exemption_db,
				'new' => $arrayUpdate,
				'created_at' => $this->createdAt ? $this->createdAt : time(),
				'created_by' => $this->uemail ? $this->uemail : 'system'
			];
			//insert log
			$this->log_exemptions_model->insert($log);
		}
		//Tìm all ĐMG để đồng bộ trạng thái vs HSMG
		$exemptions_db = $this->exemptions_model->find_where(['code_parent' => $profile_code_ref]);
		if (!empty($exemptions_db)) {
			$status_check = [];
			foreach ($exemptions_db as $exemption) {
				array_push($status_check, $exemption['status_profile']);
			}
			//update trạng thái HSMG
			$profile_db = $this->profile_exemption_model->findOne(['code_ref' => $profile_code_ref]);
			if ( !in_array($profile_status, $status_check) && in_array(4, $status_check) ) {

				$arrProfileUpdate = [
					'status' => 4,
					'end_at' => $this->createdAt ? $this->createdAt : time(),
					'end_by' => $this->uemail ? $this->uemail : 'system'
				];
				$this->profile_exemption_model->update(
					['_id' => $profile_db['_id']], $arrProfileUpdate
				);
				$log = [
					'type' => 'hsmg',
					'action' => 'update',
					'profile_id' => (string)$profile_db['_id'],
					'old' => $profile_db,
					'new' => $arrProfileUpdate,
					'created_at' => $this->createdAt ? $this->createdAt : time(),
					'created_by' => $this->uemail ? $this->uemail : 'system'
				];
				//insert log
				$this->log_exemptions_model->insert($log);
			} elseif ( !in_array($profile_status, $status_check) && !in_array(4, $status_check) ) {
				$arrProfileUpdate = [
					'status' => 10,
					'end_at' => $this->createdAt ? $this->createdAt : time(),
					'end_by' => $this->uemail ? $this->uemail : 'system'
				];
				$this->profile_exemption_model->update(
					['_id' => $profile_db['_id']], $arrProfileUpdate
				);
				$log = [
					'type' => 'hsmg',
					'action' => 'update',
					'profile_id' => (string)$profile_db['_id'],
					'old' => $profile_db,
					'new' => $arrProfileUpdate,
					'created_at' => $this->createdAt ? $this->createdAt : time(),
					'created_by' => $this->uemail ? $this->uemail : 'system'
				];
				//insert log
				$this->log_exemptions_model->insert($log);
			}
		}
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'Cập nhật thành công!'
		];
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}

	//Lưu hồ sơ miễn giảm
	public function save_profile_post()
	{
		$status = !empty($this->security->xss_clean($this->dataPost['status'])) ? $this->security->xss_clean($this->dataPost['status']) : '';
		$exemption_id = !empty($this->security->xss_clean($this->dataPost['exemption_id'])) ? $this->security->xss_clean($this->dataPost['exemption_id']) : '';
		$profile_status = !empty($this->security->xss_clean($this->dataPost['profile_status'])) ? $this->security->xss_clean($this->dataPost['profile_status']) : '';
		$code_ref = !empty($this->security->xss_clean($this->dataPost['code_ref'])) ? $this->security->xss_clean($this->dataPost['code_ref']) : '';
		if (empty($exemption_id)) {
			$response = [
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => 'ID đơn miễn giảm đang trống!'
			];
			return $this->set_response($response, REST_Controller::HTTP_OK);
		} else {
			$exemption_db = $this->exemptions_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($exemption_id)]);
			//update status exemption
			if ($exemption_db['status_profile'] != $status) {
				$arrayUpdate =  [
					'status_profile' => (int)$status,
					'updated_at' => $this->createdAt ? $this->createdAt : time(),
					'updated_by' => $this->uemail ? $this->uemail : 'system'
				];
				if ($status == 5) {
					$arrayUpdate['type_send'] = 2;
				} elseif ($status == 7) {
					$arrayUpdate['type_send'] = 3;
				} elseif ($status == 8) {
					$arrayUpdate['is_bbbg_profile'] = '';
				}
				$this->exemptions_model->update(
					['_id' => $exemption_db['_id']], $arrayUpdate
				);
				//insert log
				$log = [
					'type' => 'exemptions',
					'action' => 'update',
					'exemptions_id' => (string)$exemption_db['_id'],
					'old' => $exemption_db,
					'new' => $arrayUpdate,
					'created_at' => $this->createdAt ? $this->createdAt : time(),
					'created_by' => $this->uemail ? $this->uemail : 'system'
				];
				$this->log_exemptions_model->insert($log);
				//check status all exemption
				$exemptions_db = $this->exemptions_model->find_where(['code_parent' => $code_ref]);
				if (!empty($exemptions_db)) {
					$status_check = [];
					foreach ($exemptions_db as $exemption) {
						array_push($status_check, $exemption['status_profile']);
					}
					//Nếu trạng thái HSMG được update hết thì đồng bộ trạng thái HSMG vs đơn miễn giảm
					if (!in_array($profile_status, $status_check)) {
						$profile_db = $this->profile_exemption_model->findOne(['code_ref' => $code_ref]);
						$arrProfileUpdate = [
							'status' => (int)$status,
							'end_at' => $this->createdAt ? $this->createdAt : time(),
							'end_by' => $this->uemail ? $this->uemail : 'system'
						];
						$this->profile_exemption_model->update(
							['_id' => $profile_db['_id']], $arrProfileUpdate
						);
						$log = [
							'type' => 'hsmg',
							'action' => 'update',
							'profile_id' => (string)$profile_db['_id'],
							'old' => $profile_db,
							'new' => $arrProfileUpdate,
							'created_at' => $this->createdAt ? $this->createdAt : time(),
							'created_by' => $this->uemail ? $this->uemail : 'system'
						];
						//insert log
						$this->log_exemptions_model->insert($log);
					}
				}
				$response = [
					'status' => REST_Controller::HTTP_OK,
					'message' => 'Lưu hồ sơ thành công!'
				];
				return $this->set_response($response, REST_Controller::HTTP_OK);
			} elseif ($exemption_db['status_profile'] == $status) {
				$response = [
					'status' => REST_Controller::HTTP_BAD_REQUEST,
					'message' => 'Không có dữ liệu mới cần cập nhật!'
				];
				return $this->set_response($response, REST_Controller::HTTP_OK);
			} else {
				$response = [
					'status' => REST_Controller::HTTP_BAD_REQUEST,
					'message' => 'Không có dữ liệu mới cần cập nhật!'
				];
				return $this->set_response($response, REST_Controller::HTTP_OK);
			}
		}

	}

	//Đồng bộ hồ sơ miễn giảm với all ĐMG con
	public function sync_profile_post()
	{
		$code_ref = !empty($this->security->xss_clean($this->dataPost['code_ref'])) ? $this->security->xss_clean($this->dataPost['code_ref']) : '';
		$exemptions_db = $this->exemptions_model->find_where(['code_parent' => $code_ref]);
		$check_status = [];
		if (empty($exemptions_db)) {
			$response = [
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => 'Hồ sơ miễn giảm không tồn tại'
			];
			return $this->set_response($response, REST_Controller::HTTP_OK);
		} else {
			foreach ($exemptions_db as $exemption) {
				array_push($check_status, $exemption['status_profile']);
			}
			if (count($check_status) >= 1 ) {
				$status_unique = array_unique($check_status);
				$status_sync = $status_unique[0];
				if (count($status_unique) == 1) {
					$profile_db = $this->profile_exemption_model->findOne(['code_ref' => $code_ref]);
					$arrayUpdate = [
						'status' => (int)$status_sync,
						'end_at' => $this->createdAt ? $this->createdAt : time(),
						'end_by' => $this->uemail ? $this->uemail : 'system'
					];
					$this->profile_exemption_model->update(
						['_id' => $profile_db['_id']], $arrayUpdate
					);
					//insert log
					$log = [
						'type' => 'hsmg',
						'action' => 'update',
						'profile_id' => (string)$profile_db['_id'],
						'old' => $profile_db,
						'new' => $arrayUpdate,
						'created_at' => $this->createdAt ? $this->createdAt : time(),
						'created_by' => $this->uemail ? $this->uemail : 'system'
					];
					$this->log_exemptions_model->insert($log);
					$response = [
						'status' => REST_Controller::HTTP_OK,
						'message' => 'Đồng bộ trạng thái thành công!'
					];
					return $this->set_response($response, REST_Controller::HTTP_OK);
				} else {
					$response = [
						'status' => REST_Controller::HTTP_BAD_REQUEST,
						'message' => 'Đồng bộ trạng thái không thành công!'
					];
					return $this->set_response($response, REST_Controller::HTTP_OK);
				}
			} else {
				$response = [
					'status' => REST_Controller::HTTP_BAD_REQUEST,
					'message' => 'Đồng bộ trạng thái không thành công!'
				];
				return $this->set_response($response, REST_Controller::HTTP_OK);
			}
		}
	}

	//Thay đổi thông tin ĐMG có xác nhận của CEO qua email hay ko?
	public function change_email_confirm_post()
	{
		$bbbgx = !empty($this->security->xss_clean($this->dataPost['bbbgx'])) ? $this->security->xss_clean($this->dataPost['bbbgx']) : '';
		$confirm_email = !empty($this->security->xss_clean($this->dataPost['confirm_email'])) ? $this->security->xss_clean($this->dataPost['confirm_email']) : '';
		$is_exemption_paper = !empty($this->security->xss_clean($this->dataPost['is_exemption_paper'])) ? $this->security->xss_clean($this->dataPost['is_exemption_paper']) : '';
		$type_change = !empty($this->security->xss_clean($this->dataPost['type_change'])) ? $this->security->xss_clean($this->dataPost['type_change']) : '';
		$exemption_id = !empty($this->security->xss_clean($this->dataPost['exemption_id'])) ? $this->security->xss_clean($this->dataPost['exemption_id']) : '';
		if (empty($exemption_id)) {
			$response = [
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => 'ID đơn miễn giảm đang trống!'
			];
			return $this->set_response($response, REST_Controller::HTTP_OK);
		}
		$exemption_db = $this->exemptions_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($exemption_id)]);
		if (!empty($exemption_db) && in_array($exemption_db['status_profile'], [1, 5, 8])) {
			if ($type_change == 1) {
				$arrayUpdate = [
					'confirm_email' => (int)$confirm_email,
					'updated_at' => $this->createdAt ? $this->createdAt : time(),
					'updated_by' => $this->uemail ? $this->uemail : 'system'
				];
			} elseif ($type_change == 2) {
				$arrayUpdate = [
					'is_exemption_paper' => (int)$is_exemption_paper,
					'updated_at' => $this->createdAt ? $this->createdAt : time(),
					'updated_by' => $this->uemail ? $this->uemail : 'system'
				];
				//Nếu không có ĐMG => ĐMG ngoại lệ
				if ($is_exemption_paper == 2) {
					$arrayUpdate['type_exception'] = 1;
				} elseif ($is_exemption_paper == 1) {
					$arrayUpdate['type_exception'] = 3;
				}
			} elseif ($type_change == 3) {
				$arrayUpdate = [
					'bbbgx' => (int)$bbbgx,
					'updated_at' => $this->createdAt ? $this->createdAt : time(),
					'updated_by' => $this->uemail ? $this->uemail : 'system'
				];
			}
			$this->exemptions_model->update(
				['_id' => $exemption_db['_id']], $arrayUpdate
			);
			$log = [
				'type' => 'exemptions',
				'action' => 'update',
				'exemptions_id' => (string)$exemption_db['_id'],
				'old' => $exemption_db,
				'new' => $this->dataPost,
				'created_at' => $this->createdAt ? $this->createdAt : time(),
				'created_by' => $this->uemail ? $this->uemail : 'system'
			];
			//insert log
			$this->log_exemptions_model->insert($log);
		} else {
			$response = [
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => 'Trạng thái không hợp lệ!'
			];
			return $this->set_response($response, REST_Controller::HTTP_OK);
		}
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'Cập nhật thành công!'
		];
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}

	//Hoàn tất HSMG
	public function complete_profile_exemptions_post()
	{
		$code_ref = !empty($this->security->xss_clean($this->dataPost['code_ref'])) ? $this->security->xss_clean($this->dataPost['code_ref']) : array();
		$note = !empty($this->security->xss_clean($this->dataPost['note'])) ? $this->security->xss_clean($this->dataPost['note']) : '';
		$status = !empty($this->security->xss_clean($this->dataPost['status'])) ? $this->security->xss_clean($this->dataPost['status']) : '';
		$profile_db = $this->profile_exemption_model->findOne(['code_ref' => $code_ref]);
		//update hsmg
		$array_update = [
			'status' => (int)$status,
			'note' => $note,
			'end_at' => $this->createdAt ? $this->createdAt : time(),
			'end_by' => $this->uemail ? $this->uemail : 'system'
		];
		$this->profile_exemption_model->update(
			['_id' => $profile_db['_id']], $array_update
		);
		$log = [
			'type' => 'hsmg',
			'action' => 'update',
			'profile_id' => (string)$profile_db['_id'],
			'old' => $profile_db,
			'new' => $array_update,
			'created_at' => $this->createdAt ? $this->createdAt : time(),
			'created_by' => $this->uemail ? $this->uemail : 'system'
		];
		//insert log
		$this->log_exemptions_model->insert($log);
		//update các đơn miễn giảm con
		$exemptions_db = $this->exemptions_model->find_where(['code_parent' => $code_ref]);
		if (!empty($exemptions_db)) {
			foreach ($exemptions_db as $exemption) {
				if ($exemption['status_profile'] != 3) continue;
				$arrayUpdate = [
					'status_profile' => (int)$status,
					'profile_note' => $note,
					'end_at' => $this->createdAt ? $this->createdAt : time(),
					'end_by' => $this->uemail ? $this->uemail : 'system'
				];
				$this->exemptions_model->update(
					['_id' => $exemption['_id']], $arrayUpdate
				);
				$log = [
					'type' => 'exemptions',
					'action' => 'update',
					'exemptions_id' => (string)$exemption['_id'],
					'old' => $exemption,
					'new' => $arrayUpdate,
					'created_at' => $this->createdAt ? $this->createdAt : time(),
					'created_by' => $this->uemail ? $this->uemail : 'system'
				];
				//insert log
				$this->log_exemptions_model->insert($log);
			}
			$response = [
				'status' => REST_Controller::HTTP_OK,
				'message' => 'Hoàn tất hồ sơ miễn giảm thành công!'
			];
			return $this->set_response($response, REST_Controller::HTTP_OK);
		}
	}

	// Lịch sử xử lý đơn miễn giảm con
	public function get_log_exemption_post()
	{
		$id_exemption = !empty($this->dataPost['id_exemption']) ? $this->dataPost['id_exemption'] : '';
		$exemption_log = $this->log_exemptions_model->get_log_exemption(['id_exemption' => $id_exemption]);
		$html = gen_html_exemption_log($exemption_log);
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'html' => $html
		];
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}

	// Lịch sử xử lý hồ sơ miễn giảm cha
	public function get_log_profile_post()
	{
		$id_profile = !empty($this->dataPost['id_profile']) ? $this->dataPost['id_profile'] : '';
		$profile_log = $this->log_exemptions_model->get_log_profile(['id_profile' => $id_profile]);
		$html = gen_html_profile_log($profile_log);
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'html' => $html
		];
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}

	public function close_profile_post()
	{
		$code_ref = !empty($this->security->xss_clean($this->dataPost['code_ref'])) ? $this->security->xss_clean($this->dataPost['code_ref']) : '';
		$profile_db = $this->profile_exemption_model->findOne(['code_ref' => $code_ref]);
		$exemptions_db = $this->exemptions_model->find_where(['code_parent' => $code_ref]);
		$status_parent = $profile_db['status'] ? $profile_db['status'] : 1;
		$check_status = [];

		$arrayUpdate = [
			'status' => 10, // Kết thúc
			'updated_at' => $this->createdAt ? $this->createdAt : time(),
			'updated_by' => $this->uemail ? $this->uemail : 'system'
		];
		//Không còn ĐMG nào trong HSMG => Đóng HSMG đó
		if (empty($exemptions_db)) {
			$this->profile_exemption_model->update(
				['_id' => $profile_db['_id']], $arrayUpdate
			);
			//insert log
			$log = [
				'type' => 'hsmg',
				'action' => 'update',
				'profile_id' => (string)$profile_db['_id'],
				'old' => $profile_db,
				'new' => $arrayUpdate,
				'created_at' => $this->createdAt ? $this->createdAt : time(),
				'created_by' => $this->uemail ? $this->uemail : 'system'
			];
			$this->log_exemptions_model->insert($log);
			$response = [
				'status' => REST_Controller::HTTP_OK,
				'message' => 'Kết thúc hồ sơ miễn giảm thành công!'
			];
			return $this->set_response($response, REST_Controller::HTTP_OK);
		} else {
			// Còn ĐMG nhưng khác trạng thái của HSMG => Đóng HSMG đó
			foreach ($exemptions_db as $exemption) {
				array_push($check_status, $exemption['status_profile']);
			}
			if (!in_array($status_parent, $check_status)) {
				$this->profile_exemption_model->update(
					['_id' => $profile_db['_id']], $arrayUpdate
				);
				//insert log
				$log = [
					'type' => 'hsmg',
					'action' => 'update',
					'profile_id' => (string)$profile_db['_id'],
					'old' => $profile_db,
					'new' => $arrayUpdate,
					'created_at' => $this->createdAt ? $this->createdAt : time(),
					'created_by' => $this->uemail ? $this->uemail : 'system'
				];
				$this->log_exemptions_model->insert($log);
				$response = [
					'status' => REST_Controller::HTTP_OK,
					'message' => 'Kết thúc hồ sơ miễn giảm thành công!'
				];
				return $this->set_response($response, REST_Controller::HTTP_OK);
			} else {
				$response = [
					'status' => REST_Controller::HTTP_BAD_REQUEST,
					'message' => 'HSMG còn ĐMG chưa chuyển trạng thái!'
				];
				return $this->set_response($response, REST_Controller::HTTP_OK);
			}
		}
	}

	//Đồng bộ các ĐMG old chưa có các trường thông tin của HSMG
	public function dong_bo_dmg_post()
	{
		$from_date = strtotime($_GET['from_date'] . ' 00:00:00');
		$to_date = strtotime($_GET['to_date'] . ' 23:59:59');
		$condition = [
			'from_date' => $from_date,
			'to_date' => $to_date
		];
		$exemptions_db = $this->exemptions_model->find_all_dmg($condition);
		if (!empty($exemptions_db)) {
			foreach ($exemptions_db as $exemption) {
				$store_db = $this->store_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($exemption['store']['id'])]);
				$area_exemption = $this->area_model->findOne(['code' => $store_db['code_area']]);
				$domain_exemption = !empty($area_exemption['domain']['code']) ? $area_exemption['domain']['code'] : '';
				$arrayUpdate = [
					'status_apply' => 1,
					'status_profile' => 1,
					'confirm_email' => 1,
					'is_exemption_paper' => 1,
					'type_send' => 1, //1 GUI, 2: TRA, 3: THIEU HS
					'domain_exemption' => $domain_exemption
				];
				$this->exemptions_model->update(
					['_id' => $exemption['_id']], $arrayUpdate
				);
			}
		}
		echo "DONE!";
	}


	public function remove_exemption_post()
	{
		$id_exemption = !empty($this->security->xss_clean($this->dataPost['id_exemption'])) ? $this->security->xss_clean($this->dataPost['id_exemption']) : '';
		$code_ref = !empty($this->security->xss_clean($this->dataPost['code_ref'])) ? $this->security->xss_clean($this->dataPost['code_ref']) : '';
		$exemption_db = $this->exemptions_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($id_exemption)]);
		if (!empty($exemption_db)) {
			unset($exemption_db['code_parent']);
			unset($exemption_db['profile_name']);
			if ($exemption_db['status_profile'] == 2) {
				$status_rollback = 1; //back về trạng thái Mới
			} elseif ($exemption_db['status_profile'] == 9) {
				$status_rollback = 5; //back về trạng thái Trả về
			}
			$arrayUpdate = [
				'status_profile' => (int)$status_rollback,
				'profile_note' => 'Gỡ ĐMG khỏi HSMG',
				'code_parent' => '',
				'profile_name' => '',
				'is_bbbg_profile' => '',
				'updated_at' => $this->createdAt,
				'updated_by' => $this->uemail,
			];
			$this->exemptions_model->update(
				['_id' => $exemption_db['_id']],$arrayUpdate
			);
			$log = [
				'type' => 'exemptions',
				'action' => 'update',
				'exemptions_id' => (string)$exemption_db['_id'],
				'old' => $exemption_db,
				'new' => $arrayUpdate,
				'created_at' => $this->createdAt ? $this->createdAt : time(),
				'created_by' => $this->uemail ? $this->uemail : 'system'
			];
			//insert log
			$this->log_exemptions_model->insert($log);
		}
		$exemptions_db = $this->exemptions_model->find_where(['code_parent' => $code_ref]);
		if (empty($exemptions_db)) {
			$profile_db = $this->profile_exemption_model->findOne(['code_ref' => $code_ref]);
			$this->profile_exemption_model->delete(['_id' => $profile_db['_id']]);
			$log = [
				'type' => 'hsmg',
				'action' => 'delete',
				'profile_id' => (string)$profile_db['_id'],
				'old' => $profile_db,
				'new' => array(),
				'created_at' => $this->createdAt ? $this->createdAt : time(),
				'created_by' => $this->uemail ? $this->uemail : 'system'
			];
			//insert log
			$this->log_exemptions_model->insert($log);
		}
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'Gỡ ĐMG thành công!'
		];
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}

	//Get ĐMG chưa có trong HSMG nào
	public function get_exemptions_post()
	{
		$exemption_ids = !empty($this->security->xss_clean($this->dataPost['exemption_ids'])) ? $this->security->xss_clean($this->dataPost['exemption_ids']) : '';
		$domain_profile = !empty($this->security->xss_clean($this->dataPost['domain_profile'])) ? $this->security->xss_clean($this->dataPost['domain_profile']) : '';
		$type_exception = !empty($this->security->xss_clean($this->dataPost['type_exception'])) ? $this->security->xss_clean($this->dataPost['type_exception']) : '';
		$type_send = !empty($this->security->xss_clean($this->dataPost['type_send'])) ? $this->security->xss_clean($this->dataPost['type_send']) : '';
		$is_user_thn = $this->get_id_thn_departments($this->id);
		$is_user_kt = $this->get_id_finances($this->id);
		$condition = [
			'not_in' => $exemption_ids,
			'domain_profile' => $domain_profile,
			'type_exception' => (int)$type_exception,
			'type_send' => (int)$type_send,
			'role_thn' => $is_user_thn,
			'role_kt' => $is_user_kt,
		];
		$exemptions_not_selected = $this->exemptions_model->find_where_not_in($condition);
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'data' => $exemptions_not_selected
		];
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}


	public function addmore_exemption_post()
	{
		$exemption_ids = !empty($this->security->xss_clean($this->dataPost['exemption_ids'])) ? $this->security->xss_clean($this->dataPost['exemption_ids']) : '';
		$code_ref = !empty($this->security->xss_clean($this->dataPost['code_ref'])) ? $this->security->xss_clean($this->dataPost['code_ref']) : '';
		$profile_db = $this->profile_exemption_model->findOne(['code_ref' => $code_ref]);
		foreach ($exemption_ids as $exemp_id) {
			$exemption_db = $this->exemptions_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($exemp_id)]);
			$arrayUpdate = [
				'status_profile' => (int)$profile_db['status'],
				'code_parent' => $profile_db['code_ref'],
				'profile_name' => $profile_db['profile_name'],
				'is_bbbg_profile' => 1,
				'profile_note' => 'thêm ĐMG vào HSMG',
				'updated_at' => $this->createdAt,
				'updated_by' => $this->uemail,
			];
			$this->exemptions_model->update(
				['_id' => $exemption_db['_id']], $arrayUpdate
			);
			$log = [
				'type' => 'exemptions',
				'action' => 'update',
				'exemptions_id' => (string)$exemption_db['_id'],
				'old' => $exemption_db,
				'new' => $arrayUpdate,
				'created_at' => $this->createdAt ? $this->createdAt : time(),
				'created_by' => $this->uemail ? $this->uemail : 'system'
			];
			//insert log
			$this->log_exemptions_model->insert($log);
		}
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'Thêm đơn miễn giảm thành công!'
		];
		return $this->set_response($response, REST_Controller::HTTP_OK);
	}


	public function cron_update_domain_exemption_post()
	{
		$exemptions_db = $this->exemptions_model->find_where(['store.id' => array('$exists' => true), 'domain_exemption' => array('$exists' => false)]);
		if (empty($exemptions_db)) {
			echo 'Không tìm thấy hoặc không tồn tại đơn miễn giảm cần đồng bộ!';
			return;
		} else {
			foreach ($exemptions_db as $exemption) {
				$store_db = $this->store_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($exemption['store']['id'])]);
				$area_exemption = $this->area_model->findOne(['code' => $store_db['code_area']]);
				$domain_exemption = !empty($area_exemption['domain']['code']) ? $area_exemption['domain']['code'] : '';
				$arrayUpdate = [
					'domain_exemption' => $domain_exemption
				];
				$this->exemptions_model->update(
					['_id' => $exemption['_id']], $arrayUpdate
				);
			}
			echo 'Success!';
		}
	}

	/** Get DS id TP quản lý khoản vay MB
	 * @return array
	 */
	private function get_id_tp_thn_mb()
	{
		$data_role = $this->role_model->findOne(['slug' => 'tbp-thn-mien-bac']);
		$array_user_id = [];
		if (!empty($data_role)) {
			foreach ($data_role['users'] as $key => $role) {
				foreach ($role as $key1 => $item) {
					array_push($array_user_id, $key1);
				}
			}
		}
		return $array_user_id;
	}

	/** Get danh sách nhân viên phòng quản lý khoản vay miền Bắc
	 * @return array
	 */
	private function get_id_nv_qlkv_mb()
	{
		$data_role = $this->role_model->findOne(['slug' => 'nhan-vien-qlkv-mien-bac']);
		$array_user_id = [];
		if (!empty($data_role)) {
			foreach ($data_role['users'] as $key => $role) {
				foreach ($role as $key1 => $item) {
					array_push($array_user_id, $key1);
				}
			}
		}
		return $array_user_id;
	}

	/** Get list ID TP QLKV miền Nam
	 * @return array
	 */
	private function get_id_tp_thn_mn()
	{
		$data_role = $this->role_model->findOne(['slug' => 'tbp-thn-mien-nam']);
		$array_user_id = [];
		if (!empty($data_role)) {
			foreach ($data_role['users'] as $key => $role) {
				foreach ($role as $key1 => $item) {
					array_push($array_user_id, $key1);
				}
			}
		}
		return $array_user_id;
	}

	/** Get list id Lead Phòng QLKV miền Bắc
	 * @return array
	 */
	private function get_id_lead_thn_mb()
	{
		$data_role = $this->role_model->findOne(['slug' => 'lead-thn-mien-bac']);
		$array_user_id = [];
		if (!empty($data_role)) {
			foreach ($data_role['users'] as $key => $role) {
				foreach ($role as $key1 => $item) {
					array_push($array_user_id, $key1);
				}
			}
		}
		return $array_user_id;
	}





}

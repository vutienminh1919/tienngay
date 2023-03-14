<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
require_once APPPATH . 'libraries/NL_Withdraw.php';
require_once APPPATH . 'libraries/REST_Controller.php';
require_once APPPATH . 'libraries/Fcm.php';
require_once APPPATH . 'libraries/Vbi_tnds_oto.php';

use Restserver\Libraries\REST_Controller;
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

class LiquidationAssetContract extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("transaction_model");
		$this->load->model('fee_loan_model');
		$this->load->model('contract_model');
		$this->load->model('gic_model');
		$this->load->model('mic_model');
		$this->load->model('gic_easy_model');
		$this->load->model('gic_plt_model');
		$this->load->model('log_contract_model');
		$this->load->model('log_model');
		$this->load->model('log_gic_model');
		$this->load->model('log_mic_model');
		$this->load->model('user_model');
		$this->load->model('role_model');
		$this->load->model('config_gic_model');
		$this->load->model('city_gic_model');
		$this->load->model('contract_tempo_model');
		$this->load->model('investor_model');
		$this->load->model("group_role_model");
		$this->load->model("notification_model");
		$this->load->model("notification_app_model");
		$this->load->model("store_model");
		$this->load->model("lead_model");
		$this->load->model("sms_model");
		$this->load->model("temporary_plan_contract_model");
		$this->load->model('log_contract_tempo_model');
		$this->load->model('tempo_contract_accounting_model');
		$this->load->model('dashboard_model');
		$this->load->model('coupon_model');
		$this->load->model('verify_identify_contract_model');
		$this->load->model('device_model');
		$this->load->helper('lead_helper');
		$this->load->model('vbi_model');
		$this->load->model('log_hs_model');
		$this->load->model('log_call_debt_model');
		$this->load->model('asset_management_model');
		$this->load->model("transaction_extend_model");
		$this->load->model("contract_tnds_model");
		$this->load->model("log_mic_tnds_model");
		$this->load->model("log_vbi_tnds_model");
		$this->load->model("main_property_model");
		$this->load->model("area_model");
		$this->load->model("email_template_model");
		$this->load->model("email_history_model");
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

	// Luồng duyệt hợp đồng thanh lý của thu hồi nợ
	public function approve_liquidations_post()
	{
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;
		if (empty($this->dataPost['id'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => 'Không tồn tại hợp đồng!'
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		$id_contract = $this->security->xss_clean($this->dataPost['id']) ? $this->security->xss_clean($this->dataPost['id']) : '';
		$date_seize = $this->security->xss_clean($this->dataPost['date_seize']) ? $this->security->xss_clean($this->dataPost['date_seize']) : '';
		$name_person_seize = $this->security->xss_clean($this->dataPost['name_person_seize']) ? $this->security->xss_clean($this->dataPost['name_person_seize']) : '';
		$license_plates = $this->security->xss_clean($this->dataPost['license_plates']) ? $this->security->xss_clean($this->dataPost['license_plates']) : '';
		$frame_number = $this->security->xss_clean($this->dataPost['frame_number']) ? $this->security->xss_clean($this->dataPost['frame_number']) : '';
		$engine_number = $this->security->xss_clean($this->dataPost['engine_number']) ? $this->security->xss_clean($this->dataPost['engine_number']) : '';
		$license_number = $this->security->xss_clean($this->dataPost['license_number']) ? $this->security->xss_clean($this->dataPost['license_number']) : '';
		$status = $this->security->xss_clean($this->dataPost['status']) ? $this->security->xss_clean($this->dataPost['status']) : '';
		$note = $this->security->xss_clean($this->dataPost['note']) ? $this->security->xss_clean($this->dataPost['note']) : '';
		$debt_remain_root = $this->security->xss_clean($this->dataPost['debt_remain_root']) ? $this->security->xss_clean($this->dataPost['debt_remain_root']) : '';
		$suggest_price = $this->security->xss_clean($this->dataPost['suggest_price']) ? $this->security->xss_clean($this->dataPost['suggest_price']) : '';
		$name_buyer = $this->security->xss_clean($this->dataPost['name_buyer']) ? $this->security->xss_clean($this->dataPost['name_buyer']) : '';
		$phone_number_buyer = $this->security->xss_clean($this->dataPost['phone_number_buyer']) ? $this->security->xss_clean($this->dataPost['phone_number_buyer']) : '';
		$image_file = $this->security->xss_clean($this->dataPost['image_file']) ? $this->security->xss_clean($this->dataPost['image_file']) : '';
		$data_send_approve = $this->security->xss_clean($this->dataPost['data_send_approve']) ? $this->security->xss_clean($this->dataPost['data_send_approve']) : '';
		$action = $this->security->xss_clean($this->dataPost['action']) ? $this->security->xss_clean($this->dataPost['action']) : '';
		$name_valuation = $this->security->xss_clean($this->dataPost['name_valuation']) ? $this->security->xss_clean($this->dataPost['name_valuation']) : '';
		$phone_valuation = $this->security->xss_clean($this->dataPost['phone_valuation']) ? $this->security->xss_clean($this->dataPost['phone_valuation']) : '';
		$price_suggest_bpdg = $this->security->xss_clean($this->dataPost['price_suggest_bpdg']) ? $this->security->xss_clean($this->dataPost['price_suggest_bpdg']) : '';
		$price_suggest_thn = $this->security->xss_clean($this->dataPost['price_suggest_thn']) ? $this->security->xss_clean($this->dataPost['price_suggest_thn']) : '';
		$price_suggest_thn_send_ceo = $this->security->xss_clean($this->dataPost['price_suggest_thn_send_ceo']) ? $this->security->xss_clean($this->dataPost['price_suggest_thn_send_ceo']) : '';
		$price_refer_ceo = $this->security->xss_clean($this->dataPost['price_refer_ceo']) ? $this->security->xss_clean($this->dataPost['price_refer_ceo']) : '';
		$price_real_sold = $this->security->xss_clean($this->dataPost['price_real_sold']) ? $this->security->xss_clean($this->dataPost['price_real_sold']) : '';
		$fee_sold = $this->security->xss_clean($this->dataPost['fee_sold']) ? $this->security->xss_clean($this->dataPost['fee_sold']) : '';
		$asset_name = $this->security->xss_clean($this->dataPost['asset_name']) ? $this->security->xss_clean($this->dataPost['asset_name']) : '';
		$asset_branch = $this->security->xss_clean($this->dataPost['asset_branch']) ? $this->security->xss_clean($this->dataPost['asset_branch']) : '';
		$asset_model = $this->security->xss_clean($this->dataPost['asset_model']) ? $this->security->xss_clean($this->dataPost['asset_model']) : '';
		$number_km = $this->security->xss_clean($this->dataPost['number_km']) ? $this->security->xss_clean($this->dataPost['number_km']) : '';
		$date_effect_bpdg = $this->security->xss_clean($this->dataPost['date_effect_bpdg']) ? $this->security->xss_clean($this->dataPost['date_effect_bpdg']) : '';
		$date_sold = $this->security->xss_clean($this->dataPost['date_sold']) ? strtotime($this->security->xss_clean($this->dataPost['date_sold'])) : '';
		$contract = $this->contract_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($id_contract)));
		$store = $this->store_model->findOne(array("_id" => new \MongoDB\BSON\ObjectId($contract['store']['id'])));
		$area_contract = $this->area_model->findOne(array("code" => $store['code_area']));
		$domain_contract = $area_contract['domain']->code;
		$array_tp_thn_mb_id = $this->get_id_tp_thn_mb();
		$array_tp_thn_mn_id = $this->get_id_tp_thn_mn();
		$array_lead_thn_mb_id = $this->get_id_lead_thn_mb();
		$array_lead_thn_mn_id = $this->get_id_lead_thn_mn();
		//Insert log
		$log = array(
			"type" => "liquidation",
			"action" => $action,
			"contract_id" => $id_contract,
			"old" => $contract,
			"new" => $this->dataPost,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		if (empty($status) && $data_send_approve == "cancel_approve") {
			$log['action'] = "tpthn_cancel_liquidation";
			$log['new']['status'] = (int)$contract["liquidation_info"]["old_status"];
		}
		//THN khởi tạo yêu cầu định giá tài sản thanh lý (TSTL)
		if ($contract['status'] == '17' && $status == '44') {
			$log['action'] = "thn_send_request_evaluation";
		}
		//BPĐG trả về THN tạo lại YC
		if ($contract['status'] == '44' && $status == '45') {
			$log['action'] = "bpdg_return_thn";
		}
		//THN gửi lại YC định giá TSTL
		if ($contract['status'] == '45' && $status == '44') {
			$log['action'] = "thn_resend_request_liquidation";
		}
		//BPGĐ gửi kết quả định giá cho THN
		if ($contract['status'] == '44' && $status == '46') {
			$log['action'] = "bpdg_send_evaluation";
		}
		//TP THN cập nhật giá tham khảo lên LMS
		if ($contract['status'] == '46' && $status == '47') {
			$log['action'] = "update_price_refer";
		}
		//TP THN duyệt thay CEO
		if ($contract['status'] == '47' && $status == '48') {
			$log['action'] = "thn_approve_instate_ceo";
		}
		//THN trả về BPĐG định giá lại
		if ($contract['status'] == '47' && $status == '49') {
			$log['action'] = "thn_return_bpdg";
		}
		//BPĐG định giá lại và gửi THN KQ định giá
		if ($contract['status'] == '49' && $status == '46') {
			$log['action'] = "bpdg_resend_evaluation";
		}
		//THN cập nhật thông tin TSTL đã bán
		if ($contract['status'] == '48' && $status == '40') {
			$log['action'] = "thn_sold_asset";
		}
		if ($status == 17) {
			$log['action'] = "thn_cancel_liquidation";
		}
		/**
		 * Save log to json file
		 */
		$insertLogNew = [
			"type" => "contract",
			"action" => !empty($log['action']) ? $log['action'] : '',
			"contract_id" => !empty($log['contract_id']) ? $log['contract_id'] : '',
			"created_at" => !empty($log['created_at']) ? $log['created_at'] : '',
			"created_by" => !empty($log['created_by']) ? $log['created_by'] : '',
		];
		$log_id =  $this->log_contract_model->insertReturnId($insertLogNew);
		$this->log_model->insert($log);
		$log['log_id'] = $log_id;
		$this->insert_log_file($log, $log['contract_id']);
		/**
		 * ----------------------
		 */
		$status = (int)$status;
		//Update status contract
		if ($status == 44) {
			if ($action == 'create') {
				$arrUpdate = array(
					"status" => $status,
					"liquidation_info.date_seize" => $date_seize,
					"liquidation_info.name_person_seize" => $name_person_seize,
					"liquidation_info.license_plates" => $license_plates,
					"liquidation_info.frame_number" => $frame_number,
					"liquidation_info.engine_number" => $engine_number,
					"liquidation_info.license_number" => $license_number,
					"liquidation_info.asset_name" => $asset_name,
					"liquidation_info.asset_branch" => $asset_branch,
					"liquidation_info.asset_model" => $asset_model,
					"liquidation_info.number_km" => $number_km,
					"liquidation_info.old_status" => $contract["status"],
					"liquidation_info.img_liquidation" => $image_file,
					"liquidation_info.note_create_liquidation" => $note,
					"liquidation_info.created_at_request" => $this->createdAt,
					"liquidation_info.created_by_request" => $this->uemail,
				);
			} elseif ($action == 'resend') {
				$arrUpdate = array(
					"status" => $status,
					"liquidation_info.date_seize" => $date_seize,
					"liquidation_info.name_person_seize" => $name_person_seize,
					"liquidation_info.license_plates" => $license_plates,
					"liquidation_info.frame_number" => $frame_number,
					"liquidation_info.engine_number" => $engine_number,
					"liquidation_info.license_number" => $license_number,
					"liquidation_info.asset_name" => $asset_name,
					"liquidation_info.asset_branch" => $asset_branch,
					"liquidation_info.asset_model" => $asset_model,
					"liquidation_info.number_km" => $number_km,
					"liquidation_info.old_status" => $contract["status"],
					"liquidation_info.img_liquidation" => $image_file,
					"liquidation_info.note_create_liquidation" => $note,
					"liquidation_info.updated_request_at" => $this->createdAt,
					"liquidation_info.updated_request_by" => $this->uemail,
				);
			}
		} elseif ($status == 45) {
			$arrUpdate = array(
				"status" => $status,
				"liquidation_info.note_bpdg" => $note,
				"liquidation_info.old_status" => $contract["status"],
				"liquidation_info.updated_at" => $this->createdAt,
				"liquidation_info.updated_by" => $this->uemail
			);
		} elseif (empty($status)) {
			$arrUpdate = array(
				"status" => (int)$contract["liquidation_info"]["old_status"],
				"note" => $this->dataPost['note'],
			);
		} elseif ($status == 46) {
			if ($action == "approve") {
				$arrUpdate = array(
					"status" => $status,
					"liquidation_info.bpdg.name_valuation" => $name_valuation,
					"liquidation_info.bpdg.phone_valuation" => $phone_valuation,
					"liquidation_info.bpdg.date_effect_bpdg" => $date_effect_bpdg,
					"liquidation_info.bpdg.price_suggest_bpdg" => (int)$price_suggest_bpdg,
					"liquidation_info.old_status" => $contract["status"],
					"liquidation_info.bpdg.img_liquidation" => $image_file,
					"liquidation_info.bpdg.note" => $note,
					"liquidation_info.bpdg.created_at" => $this->createdAt,
					"liquidation_info.bpdg.created_by" => $this->uemail
				);
			} elseif ($action == "resend") {
				$arrUpdate = array(
					"status" => $status,
					"liquidation_info.bpdg.name_valuation" => $name_valuation,
					"liquidation_info.bpdg.phone_valuation" => $phone_valuation,
					"liquidation_info.bpdg.date_effect_bpdg" => $date_effect_bpdg,
					"liquidation_info.bpdg.price_suggest_bpdg" => (int)$price_suggest_bpdg,
					"liquidation_info.old_status" => $contract["status"],
					"liquidation_info.bpdg.img_liquidation" => $image_file,
					"liquidation_info.bpdg.note" => $note,
					"liquidation_info.bpdg.updated_at" => $this->createdAt,
					"liquidation_info.bpdg.updated_by" => $this->uemail
				);
			}
		} elseif ($status == 47) {
			$arrUpdate = array(
				"status" => $status,
				"liquidation_info.thn.price_suggest_thn" => (int)$price_suggest_thn,
				"liquidation_info.old_status" => $contract["status"],
				"liquidation_info.thn.image_file_asset" => $image_file,
				"liquidation_info.thn.note" => $note,
				"liquidation_info.thn.created_at" => $this->createdAt,
				"liquidation_info.thn.created_by" => $this->uemail
			);
		} elseif ($status == 48) {
			$arrUpdate = array(
				"status" => $status,
				"liquidation_info.old_status" => $contract["status"],
				"liquidation_info.thn.price_suggest_thn_send_ceo" => (int)$price_suggest_thn_send_ceo,
				"liquidation_info.thn.price_refer_ceo" => (int)$price_refer_ceo,
				"liquidation_info.thn.image_from_email_ceo" => $image_file,
				"liquidation_info.thn.note" => $note,
				"liquidation_info.thn.updated_at" => $this->createdAt,
				"liquidation_info.thn.updated_by" => $this->uemail
			);
		} elseif ($status == 49) {
			$arrUpdate = array(
				"status" => $status,
				"liquidation_info.old_status" => $contract["status"],
				"liquidation_info.thn.price_refer_ceo" => (int)$price_refer_ceo,
				"liquidation_info.thn.image_from_email_ceo" => $image_file,
				"liquidation_info.thn.note" => $note,
				"liquidation_info.thn.updated_at" => $this->createdAt,
				"liquidation_info.thn.updated_by" => $this->uemail
			);
		} elseif ($status == 40) {
			$arrUpdate = array(
				"status" => $status,
				"liquidation_info.old_status" => $contract["status"],
				"liquidation_info.name_buyer" => $name_buyer,
				"liquidation_info.phone_number_buyer" => $phone_number_buyer,
				"liquidation_info.fee_sold" => (int)$fee_sold,
				"liquidation_info.price_real_sold" => (int)$price_real_sold,
				"liquidation_info.sold.image_sold_asset" => $image_file,
				"liquidation_info.note" => $note,
				"liquidation_info.created_at_liquidations" => (int)$date_sold,
				"liquidation_info.updated_at" => $this->createdAt,
				"liquidation_info.updated_by" => $this->uemail
			);
		} elseif ($status == 17) {
			$arrUpdate = array(
				"status" => $status,
				"liquidation_info.old_status" => $contract["status"],
				"liquidation_info.note" => $note,
				"liquidation_info.updated_at" => $this->createdAt,
				"liquidation_info.updated_by" => $this->uemail
			);
		}
		if (!empty($contract)) {
			$this->contract_model->update(array("_id" => $contract['_id']), $arrUpdate);
		}
		$note = '';
		$user_ids = array();
		$user_ids_approve = array();
		//60a5e0c05324a73f2e25d224 TP THNMB
		//60a5e0d45324a73eba244ca6 TP THNMN
		//6299d771c0e6ce081f2b0fa4 BPĐG
		//5ea803b0d6612b991c2cdc97 TBP THN chung 2 mien
		if (!empty($contract)) {
			$ten_tai_san = "";
			$nhan_hieu = "";
			$model = "";
			$so_khung = "";
			$so_may = "";
			$bien_kiem_soat = "";
			$so_dang_ky = "";
			$so_km_da_di = "";
			$ten_tai_san = $contract['loan_infor']['type_property']['text'];
			$properties = !empty($contract['property_infor']) ? $contract['property_infor'] : array();
			foreach ($properties as $item) {
				if ($item['slug'] === 'nhan-hieu') {
					$nhan_hieu = $item['value'];
				} elseif ($item['slug'] === 'model') {
					$model = $item['value'];
				} elseif ($item['slug'] === 'so-khung') {
					$so_khung = $item['value'];
				} elseif ($item['slug'] === 'so-may') {
					$so_may = $item['value'];
				} elseif ($item['slug'] === 'bien-so-xe') {
					$bien_kiem_soat = $item['value'];
				} elseif ($item['slug'] === 'so-dang-ky') {
					$so_dang_ky = $item['value'];
				} elseif ($item['slug'] === 'so-km-da-di') {
					$so_km_da_di = $item['value'];
				}
			}
		}
		if ($status == 44) {
			$note = "Chờ bộ phận định giá xử lý";
			$bpdg_id = array(
				"6299d771c0e6ce081f2b0fa4"
			);
			$user_ids_approve = $this->getUserGroupRole($bpdg_id);
			$data_send = array(
				"code" => "send_bpdg_valuation_asset",
				"customer_name" => $contract['customer_infor']['customer_name'],
				"code_contract" => $contract['code_contract'],
				"store_name" => $contract['store']['name'],
				"amount_money" => !empty($contract['loan_infor']['amount_money']) ? number_format($contract['loan_infor']['amount_money']) : "0",
				"product" => $contract['loan_infor']['type_loan']['text'],
				"product_detail" => $contract['loan_infor']['name_property']['text'],
				"number_day_loan" => (int)$contract['loan_infor']['number_day_loan'] / 30,
				"phone_store" => $store['phone'],
				"type_interest" => (int)$contract['loan_infor']['type_interest'] == 1 ? "Dư nợ giảm dần" : "Lãi hàng tháng, gốc cuối kì",
				"name_asset" => $ten_tai_san ?? '' ,
				"nhan_hieu" => $nhan_hieu ?? '' ,
				"model" => $model ?? '' ,
				"license_plates" => $bien_kiem_soat ?? '' ,
				"frame_number" => $so_khung ?? '',
				"engine_number" => $so_may ?? '',
				"license_number" => $so_dang_ky ?? '',
				"so_km_da_di" => $so_km_da_di ?? '',
				"sender" => $this->uemail ?? '',
				'url' => $this->config->item("url_detail_contract").(string)$contract['_id']
			);
			$this->sendEmailApproveLiquidation($user_ids_approve, $data_send, $status);
		} elseif ($status == 45) {
			//id CEO => 608137415324a7567e5ffe04
			$note = "BP Định giá trả về";
			$tp_thn_id = array(
				"5ea803b0d6612b991c2cdc97"
			);
			$user_ids_approve = $this->getUserGroupRole($tp_thn_id);
			$data_send = array(
				"code" => "bpdg_return_thn",
				"customer_name" => $contract['customer_infor']['customer_name'],
				"code_contract" => $contract['code_contract'],
				"store_name" => $contract['store']['name'],
				"amount_money" => !empty($contract['loan_infor']['amount_money']) ? number_format($contract['loan_infor']['amount_money']) : "0",
				"product" => $contract['loan_infor']['type_loan']['text'],
				"product_detail" => $contract['loan_infor']['name_property']['text'],
				"number_day_loan" => (int)$contract['loan_infor']['number_day_loan'] / 30,
				"phone_store" => $store['phone'],
				"type_interest" => (int)$contract['loan_infor']['type_interest'] == 1 ? "Dư nợ giảm dần" : "Lãi hàng tháng, gốc cuối kì",
				"name_asset" => $ten_tai_san ?? '' ,
				"nhan_hieu" => $nhan_hieu ?? '' ,
				"model" => $model ?? '' ,
				"license_plates" => $bien_kiem_soat ?? '' ,
				"frame_number" => $so_khung ?? '',
				"engine_number" => $so_may ?? '',
				"license_number" => $so_dang_ky ?? '',
				"so_km_da_di" => $so_km_da_di ?? '',
				"sender" => $this->uemail ?? '',
				'url' => $this->config->item("url_detail_contract").(string)$contract['_id']
			);
			$this->sendEmailApproveLiquidation($user_ids_approve, $data_send, $status);
		} elseif ($status == 46) {
			$tp_thn_id = "5ea803b0d6612b991c2cdc97";
			$note = "BPĐG gửi kết quả định giá tài sản";
			if ($domain_contract == 'MB') {
				$user_ids_approve = $array_tp_thn_mb_id;
			} elseif ($domain_contract == 'MN') {
				$user_ids_approve = $array_tp_thn_mn_id;
			} else {
				$user_ids_approve = $this->getUserGroupRole($tp_thn_id);
			}
			$data_send = array(
				"code" => "bpdg_valuation_asset",
				"customer_name" => $contract['customer_infor']['customer_name'],
				"code_contract" => $contract['code_contract'],
				"store_name" => $contract['store']['name'],
				"amount_money" => !empty($contract['loan_infor']['amount_money']) ? number_format($contract['loan_infor']['amount_money']) : "0",
				"product" => $contract['loan_infor']['type_loan']['text'],
				"product_detail" => $contract['loan_infor']['name_property']['text'],
				"number_day_loan" => (int)$contract['loan_infor']['number_day_loan'] / 30,
				"phone_store" => $store['phone'],
				"type_interest" => (int)$contract['loan_infor']['type_interest'] == 1 ? "Dư nợ giảm dần" : "Lãi hàng tháng, gốc cuối kì",
				"name_asset" => $ten_tai_san ?? '' ,
				"nhan_hieu" => $nhan_hieu ?? '' ,
				"model" => $model ?? '' ,
				"license_plates" => $bien_kiem_soat ?? '' ,
				"frame_number" => $so_khung ?? '',
				"engine_number" => $so_may ?? '',
				"license_number" => $so_dang_ky ?? '',
				"so_km_da_di" => $so_km_da_di ?? '',
				"name_valuation" => $name_valuation ?? '',
				"phone_valuation" => $phone_valuation ?? '',
				"date_effect_bpdg" => $date_effect_bpdg ? date('d/m/Y', strtotime($date_effect_bpdg)) : '',
				"price_suggest_bpdg" => $price_suggest_bpdg ? number_format($price_suggest_bpdg) : '',
				"sender" => $this->uemail ?? '',
				'url' => $this->config->item("url_detail_contract").(string)$contract['_id']
			);
			$this->sendEmailApproveLiquidation($user_ids_approve, $data_send, $status);
		} elseif ($status == 47) {
			$note = "Chờ TP THN duyệt thay CEO";
			$tp_thn_id = "5ea803b0d6612b991c2cdc97";
			if ($domain_contract == 'MB') {
				$user_ids_approve = $array_tp_thn_mb_id;
			} elseif ($domain_contract == 'MN') {
				$user_ids_approve = $array_tp_thn_mn_id;
			} else {
				$user_ids_approve = $this->getUserGroupRole($tp_thn_id);
			}
		} elseif ($status == 48) {
			$note = "Chờ TP THN bán tài sản thanh lý";
			$tp_thn_id = "5ea803b0d6612b991c2cdc97";
			$lead_thn_id = "612d86f55324a72a5c49efd8";
			if ($domain_contract == 'MB') {
				$user_ids_approve = $array_tp_thn_mb_id;
			} elseif ($domain_contract == 'MN') {
				$user_ids_approve = $array_tp_thn_mn_id;
			} else {
				$user_ids_approve = $this->getUserGroupRole($tp_thn_id);
			}
		} elseif ($status == 49) {
			$note = "Chờ BPĐG định giá lại";
			$bpdg_id = array(
				"6299d771c0e6ce081f2b0fa4"
			);
			$user_ids_approve = $this->getUserGroupRole($bpdg_id);
			$data_send = array(
				"code" => "thn_return_bpdg",
				"customer_name" => $contract['customer_infor']['customer_name'],
				"code_contract" => $contract['code_contract'],
				"store_name" => $contract['store']['name'],
				"amount_money" => !empty($contract['loan_infor']['amount_money']) ? number_format($contract['loan_infor']['amount_money']) : "0",
				"product" => $contract['loan_infor']['type_loan']['text'],
				"product_detail" => $contract['loan_infor']['name_property']['text'],
				"number_day_loan" => (int)$contract['loan_infor']['number_day_loan'] / 30,
				"phone_store" => $store['phone'],
				"type_interest" => (int)$contract['loan_infor']['type_interest'] == 1 ? "Dư nợ giảm dần" : "Lãi hàng tháng, gốc cuối kì",
				"name_asset" => $ten_tai_san ?? '' ,
				"nhan_hieu" => $nhan_hieu ?? '' ,
				"model" => $model ?? '' ,
				"license_plates" => $bien_kiem_soat ?? '',
				"frame_number" => $so_khung ?? '',
				"engine_number" => $so_may ?? '',
				"license_number" => $so_dang_ky ?? '',
				"so_km_da_di" => $so_km_da_di ?? '',
				"name_valuation" => $name_valuation ?? '',
				"phone_valuation" => $phone_valuation ?? '',
				"date_effect_bpdg" => $date_effect_bpdg ? date('d/m/Y', strtotime($date_effect_bpdg)) : '',
				"price_suggest_bpdg" => $price_suggest_bpdg ? number_format($price_suggest_bpdg) : '',
				"price_fefer_ceo" => $price_refer_ceo ? number_format($price_refer_ceo) : '',
				"sender" => $this->uemail ?? '',
				"note" => $note ?? '',
				'url' => $this->config->item("url_detail_contract").(string)$contract['_id']
			);
			$this->sendEmailApproveLiquidation($user_ids_approve, $data_send, $status);
		} elseif ($status == 40 || $status == 17) {
			if ($status == 40) {
				$note = "Chờ tạo phiếu thu Thanh lý tài sản!";
			} elseif ($status == 17) {
				$note = "Đã hủy yêu cầu thanh lý tài sản!";
			}
			$tp_thn_id = "5ea803b0d6612b991c2cdc97";
			if ($domain_contract == 'MB') {
				$user_ids_approve = $array_tp_thn_mb_id;
				$user_ids = $array_lead_thn_mb_id;
			} elseif ($domain_contract == 'MN') {
				$user_ids_approve = $array_tp_thn_mn_id;
				$user_ids = $array_lead_thn_mn_id;
			} else {
				$user_ids_approve = $this->getUserGroupRole($tp_thn_id);
				$user_ids = $this->getUserGroupRole($lead_thn_id);;
			}
		}
		$link_detail = 'pawn/detail?id=' . (string)$contract['_id'];
		$link_detail_view_v2 = 'accountant/view_v2?id=' . (string)$contract['_id'];
		// oke
		$dataSocket = array();
		if (!empty($user_ids)) {
			$user_ids = array_values($user_ids);
			foreach ($user_ids as $u_id) {
				if ($status == 40) {
					$link_detail = 'accountant/view_v2?id=' . (string)$contract['_id'];
				} else {
					$link_detail = 'pawn/detail?id=' . (string)$contract['_id'];
				}
				$data_notification = [
					'action_id' => (string)$contract['_id'],
					'action' => 'contract',
					'title' => $contract['customer_infor']['customer_name'] . ' - ' . $contract['store']['name'],
					'detail' => $link_detail,
					'note' => $note,
					'user_id' => $u_id,
					'status' => 1, //1: new, 2 : read, 3: block,
					'contract_status' => $status,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->notification_model->insertReturnId($data_notification);
			}
		}
		if (!empty($user_ids_approve)) {
			$user_ids_approve = array_values($user_ids_approve);
			if ($note == '') {
				$note = 'Chờ duyệt thanh lý tài sản';
			}
			foreach ($user_ids_approve as $us_id) {
				if ($status == 44) {
					$note = 'Chờ định giá tài sản thanh lý';
				} else if ($status == 45) {
					$note = 'Trả về yêu cầu định giá tài sản thanh lý';
				} else if ($status == 46) {
					$note = 'Chờ TP THN cập nhật giá bán tham khảo';
				} else if ($status == 47) {
					$note = 'Chờ TP THN duyệt thay CEO thanh lý tài sản';
				} else if ($status == 48) {
					$note = 'Chờ bán tài sản thanh lý';
				}  else if ($status == 49) {
					$note = 'Chờ BPĐG định giá lại tài sản';
				} else if ($status == 40) {
					$note = 'Chờ tạo phiếu thu thanh lý tài sản';
				}
				$data_approve = [
					'action_id' => (string)$contract['_id'],
					'action' => 'contract',
					'detail' => $link_detail,
					'title' => $contract['customer_infor']['customer_name'] . ' - ' . $contract['store']['name'],
					'note' => $note,
					'user_id' => $us_id,
					'status' => 1, //1: new, 2 : read, 3: block,
					'contract_status' => $status,
					'created_at' => $this->createdAt,
					"created_by" => $this->uemail
				];
				$this->notification_model->insertReturnId($data_approve);
			}
		}
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => 'Duyệt thành công!',
			'dataSocket' => $dataSocket
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	private function sendEmailApproveLiquidation($user_id, $data, $status='')
	{
		foreach ($user_id as $key => $value) {
			$dataUser = $this->user_model->findOne(array('_id' => new \MongoDB\BSON\ObjectId($value)));
			$email = !empty($dataUser['email']) ? $dataUser['email'] : "";
			$full_name = !empty($dataUser['full_name']) ? $dataUser['full_name'] : "";
			if (!empty($email)) {
				$data['email'] = $email;
				$data['full_name'] = $full_name;
				$data['API_KEY'] = $this->config->item('API_KEY');
//				$this->user_model->send_Email($data);
				$this->sendEmail($data);
			}
		}

		// status == 40 send email cho khach hang (thong bao tai san da duoc thanh ly)
//		if ($status == 40 && !empty($data['customer_email'])) {
//			if (!empty($data['customer_email'])) {
//				$data['code'] = 'vfc_liquidations_send_customer';
//				$data['email'] = $data['customer_email'];
//				$data['API_KEY'] = $this->config->item('API_KEY');
//				// return $data;
//				$this->user_model->send_Email($data);
//			}
//		}
	}

	private function checkApproveLiquidationsByAccessRight($roleAccessRights, $status)
	{
		$isAccess = false;
		//Status = 47 = TP THN duyệt thay CEO = 60a62bae5324a75dc12b8b75
		//Status = 40 = TP THN bán tài sản thanh lý = 60a62c305324a767e20de7c3

		if ($status == 47 && in_array('60a62bae5324a75dc12b8b75', $roleAccessRights)
			|| $status == 40 && in_array('60a62c305324a767e20de7c3', $roleAccessRights) )
			$isAccess = true;
		return $isAccess;
	}

	public function contract_tempo_liquidations_post()
	{
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;
		$start = !empty($this->dataPost['start']) ? $this->dataPost['start'] : "";
		$end = !empty($this->dataPost['end']) ? $this->dataPost['end'] : "";
		$store = !empty($this->dataPost['store']) ? $this->dataPost['store'] : "";
		$status = !empty($this->dataPost['status']) ? $this->dataPost['status'] : "";
		$customer_name = !empty($this->dataPost['customer_name']) ? $this->dataPost['customer_name'] : "";
		$customer_phone_number = !empty($this->dataPost['customer_phone_number']) ? $this->dataPost['customer_phone_number'] : "";
		$code_contract_disbursement = !empty($this->dataPost['code_contract_disbursement']) ? $this->dataPost['code_contract_disbursement'] : "";
		$code_contract = !empty($this->dataPost['code_contract']) ? $this->dataPost['code_contract'] : "";
		$condition = array();
		if (!empty($start) && !empty($end)) {
			$condition = array(
				'start' => strtotime(trim($start) . ' 00:00:00'),
				'end' => strtotime(trim($end) . ' 23:59:59')
			);
		}
		if (!empty($status)) {
			$condition['status'] = $status;
		}
		if (!empty($store)) {
			$condition['stores'] = is_array($store) ? $store : array($store);
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
		if (!$all) {
			$stores = $this->getStores($this->id);
			if (empty($stores)) {
				$response = array(
					'status' => REST_Controller::HTTP_BAD_REQUEST,
					'data' => array(),
					'groupRoles' => array(),
					'total' => 0,
				);
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			}
			$condition['stores'] = $stores;
		}
		if (empty($store)) {
			if (in_array('quan-ly-khu-vuc', $groupRoles) || $this->superadmin || in_array('van-hanh', $groupRoles) || in_array('ke-toan', $groupRoles) || in_array('cua-hang-truong', $groupRoles) || in_array('tbp-thu-hoi-no', $groupRoles) || in_array('lead-thn', $groupRoles)|| in_array('thu-hoi-no', $groupRoles)) {
				$stores = $this->getStores($this->id);
				$condition['stores'] = $stores;
			}
		} else {
			$condition['stores'] = (is_array($store)) ? $store : [$store];
		}
		$per_page = !empty($this->input->post()['per_page']) ? $this->input->post()['per_page'] : 0;
		$uriSegment = !empty($this->input->post()['uriSegment']) ? $this->input->post()['uriSegment'] : 0;
		$contract_liquidation = $this->contract_model->getContractLiquidations(array(), $condition, $per_page, $uriSegment);
		$condition['total'] = true;
		$total = $this->contract_model->getContractLiquidations(array(), $condition);
		//Gán thêm thông tin phiếu thu tất toán thanh lý tài sản
		if (!empty($contract_liquidation)) {
			foreach ($contract_liquidation as $key => $contract) {
				$transaction_liquidation = $this->get_infor_transaction_liquidation($contract['code_contract']);
				$contract['tien_tat_toan_pt'] = $transaction_liquidation['tien_tat_toan_pt'] ?? 0;
				$contract['total_deductible'] = $transaction_liquidation['total_deductible'] ?? 0;
				$contract['valid_amount'] = $transaction_liquidation['valid_amount'] ?? 0;
				$contract['tien_chenh_lech_tat_toan'] = $transaction_liquidation['tien_chenh_lech_tat_toan'] ?? 0;
			}
		}
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $contract_liquidation,
			'total' => $total
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function update_date_liquidations_post()
	{
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : "";
		$date_liquidations = !empty($data['date_liquidations']) ? $data['date_liquidations'] : "";

		$count = $this->contract_model->count(array("_id" => new \MongoDB\BSON\ObjectId($id)));
		$contract_old = $this->contract_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($id)));
		if ($count != 1) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Không tồn tại hợp đồng"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

		unset($data['id']);
		$log = array(
			"type" => "contract",
			"action" => "update",
			"contract_id" => $data['id'],
			"old" => $contract_old,
			"new" => $data,
			"created_at" => $this->createdAt,
			"created_by" => $this->uemail
		);
		$this->log_model->insert($log);

		$this->contract_model->update(
			array("_id" => new MongoDB\BSON\ObjectId($id)),
			["liquidation_info.created_at_liquidations" => (int)$date_liquidations]
		);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'contract' => $contract_old['liquidation_info']["created_at_liquidations"],
			'message' => "Cập nhập ngày thanh lý tài sản thành công!"
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	private function getUserGroupRole($GroupIds)
	{
		$arr = array();
		foreach ($GroupIds as $groupId) {
			$groups = $this->group_role_model->findOne(array('_id' => new MongoDB\BSON\ObjectId($groupId)));
			foreach ($groups['users'] as $item) {
				$arr[] = key($item);
			}
		}
		$arr = array_unique($arr);
		return $arr;
	}

	private function transferSocket($data)
	{
		$version = new Version2X($this->config->item('IP_SOCKET_SERVER'));
		$dataNotify['res'] = $data['status'];
		if (!empty($data['approve'])) {
			$dataApprove['res'] = $data['approve'];
		}
		try {
			$client = new Client($version);
			$client->initialize();
			$client->emit('notify_status', $dataNotify);
			if (!empty($dataApprove)) {
				$client->emit('notify_approve', $dataApprove);
			}
			$client->close();
		} catch (Exception $e) {

		}

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

	public function insert_log_file($value, $contract_id){

		$fp = fopen($this->config->item("URL_LOG_CONTRACT").$contract_id.'.json', "a");

		if(!empty($fp)){

			$arrayData = $this->readFileJson($contract_id);

			if(empty($arrayData)){
				$arrayData = [];
			}
			array_push($arrayData, $value);

			$this->saveFileJson($arrayData, $contract_id);

		}
	}

	public function saveFileJson($arrayData , $contract_id){
		$dataJson = json_encode($arrayData);
		file_put_contents($this->config->item("URL_LOG_CONTRACT").$contract_id.'.json',$dataJson);
	}
	public function readFileJson($contract_id){
		$data = file_get_contents($this->config->item("URL_LOG_CONTRACT").$contract_id.'.json');
		return json_decode($data,true);
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

	public function get_id_lead_thn_mn()
	{
		$data_role = $this->role_model->findOne(['slug' => 'lead-thn-mien-nam']);
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

	public function lay_du_no_goc_con_lai_one_post()
	{
		$code_contract = $this->dataPost['code_contract'];
		$contract = $this->contract_model->findOne(['code_contract' => $code_contract]);
		if(!empty($contract)){
			$du_no_goc_con_lai = 0;
			$tempo = $this->contract_tempo_model->find_where(['code_contract'=> $contract['code_contract'], 'status'=> 1]);
			if(count($tempo) > 0){
				foreach ($tempo as $t){
					$du_no_goc_con_lai += (float)$t['tien_goc_1ky'];
				}
			}
			$this->contract_model->update(['_id'=>$contract['_id']],['original_debt'=>['du_no_goc_con_lai'=>$du_no_goc_con_lai]]);
		} else {
			echo "Không tồn tại hợp đồng!";
		}
		return 'ok';
	}

	public function get_role_create_liquidation_post()
	{
		$role_liq = $this->role_model->findOne(['slug' => 'tao-thanh-ly-tai-san']);
		$array_emails = array();
		if (!empty($role_liq)) {
			foreach ($role_liq['users'] as $key => $user) {
				foreach ($user as $key1 => $item) {
					array_push($array_emails, $item['email']);
				}
			}
		}
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'data' => $array_emails
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function get_role_cancel_liquidation_post()
	{
		$role_liq = $this->role_model->findOne(['slug' => 'huy-thanh-ly-tai-san']);
		$array_emails = array();
		if (!empty($role_liq)) {
			foreach ($role_liq['users'] as $key => $user) {
				foreach ($user as $key1 => $item) {
					array_push($array_emails, $item['email']);
				}
			}
		}
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'data' => $array_emails
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function get_infor_transaction_liquidation($code_contract)
	{
		$transaction_liquidation = $this->transaction_model->findOne(['code_contract' => $code_contract, 'type_payment' => 4, 'type' => 3, 'status' => 1]);
		$liquidation_infor = array();
		if (!empty($transaction_liquidation)) {
			$liquidation_infor['tien_tat_toan_pt'] = $transaction_liquidation['amount_payment_finish_system'] ? $transaction_liquidation['amount_payment_finish_system'] : 0;
			$liquidation_infor['total_deductible'] = $transaction_liquidation['total_deductible'] ? $transaction_liquidation['total_deductible'] : 0;
			$liquidation_infor['valid_amount'] = $transaction_liquidation['valid_amount'] ? $transaction_liquidation['valid_amount'] : 0;
			$liquidation_infor['tien_chenh_lech_tat_toan'] = $transaction_liquidation['tien_chenh_lech_tat_toan'] ? $transaction_liquidation['tien_chenh_lech_tat_toan'] : 0;
		}

		return $liquidation_infor;

	}

	//@param store_id
	//outPut new name store remove comma
	public function cron_update_name_store_post()
	{
		$data = $this->input->post();
		$store_id = !empty($data['store_id']) ? $data['store_id'] : "";
		$contractDb = $this->contract_model->find_where(['store.id' => $store_id]);
		if (empty($contractDb)) {
			echo "Không tìm thấy phòng giao dịch trong hợp đồng!";
			return;
		} else {
			foreach ($contractDb as $contract) {
				$this->contract_model->update(
					[
						"_id" => $contract['_id']
					],[
						'store.name' => strtok($contract['store']['name'], ',')
					]
				);
			}
			echo 'Done';
		}
	}

}

?>

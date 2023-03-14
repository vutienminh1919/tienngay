<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
require_once APPPATH . 'libraries/REST_Controller.php';
require_once APPPATH . 'libraries/NL_Withdraw.php';
require_once APPPATH . 'libraries/Fcm.php';

use Restserver\Libraries\REST_Controller;

class Collaborator extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('vbi_model');
		$this->load->model('warehouse_model');
		$this->load->model('contract_model');
		$this->load->model("user_model");
		$this->load->model("role_model");
		$this->load->model("group_role_model");
		$this->load->model('temporary_plan_contract_model');
		$this->load->model('log_model');
		$this->load->model('car_storage_model');
		$this->load->model('collaborator_model');
		$this->load->model('store_model');
		$this->load->model("lead_model");
		$this->load->model('account_bank_model');
		$this->load->model('transaction_model');
		$this->load->model('log_payment_ctv_model');
		$url_gic = "http://bancasuat.gic.vn";
		$this->createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		$headers = $this->input->request_headers();
		$dataPost = $this->input->post();
		$this->flag_login = 1;
		$this->superadmin = false;
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
				if ($dataPost['type'] == 1) $this->app_login['token_web'] = $headers_item;
				if ($dataPost['type'] == 2) $this->app_login['token_app'] = $headers_item;
				$count_account = $this->user_model->count($this->app_login);
				$this->flag_login = 'success';
				if ($count_account != 1) $this->flag_login = 2;
				if ($count_account == 1) {
					$this->info = $this->user_model->findOne($this->app_login);
					$this->id = $this->info['_id'];
					// $this->ulang = $this->info['lang'];
					$this->uemail = $this->info['email'];
					$this->superadmin = isset($this->info['is_superadmin']) && (int)$this->info['is_superadmin'] === 1;
				}
			}
		}
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	private $createdAt, $flag_login, $id, $uemail, $ulang, $app_login;

	public function create_collaborator_post()
	{
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;

		$data = $this->input->post();
		$data['created_at'] = (int)$data['created_at'];

		$collaborator_p = $this->collaborator_model->findOne(['ctv_phone'=> $data['ctv_phone']]);

		if (!empty($data)){
			$resNumberCode = $this->initNumberContractCode();

//			$code_area = $data['user']['stores'][count($data['user']['stores'])-1]['code_area'];


				$find_code_area = $this->store_model->findOne(['_id' => new MongoDB\BSON\ObjectId($data['user']['stores'][count($data['user']['stores'])-1]['store_id'])]);

				if (!empty($find_code_area)) {
					$code_area = $find_code_area['code_area'];
				}


			$data['ctv_code'] = $code_area . ".00" . $resNumberCode['number_code_ctv'];
			$data['number_code_ctv'] = $resNumberCode['number_code_ctv'];
		}

		$data['stores'] = $data['user']['stores'][count($data['user']['stores'])-1]['store_id'];
		$data['created_by'] = $this->uemail;

		if (empty($collaborator_p) ) {

			$this->collaborator_model->insert($data);
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'message' => "Tạo mới thành công",
				'data' => $data
			);
		} else {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Tạo mới thất bại đã tồn tại CTV mã hoặc phone",
				'data' => $data
			);
		}
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function get_all_collaborator_model_post(){
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;
		$condition = [];
		$this->dataPost = $this->input->post();

		$store_id = $this->dataPost['user']['stores'][count($this->dataPost['user']['stores'])-1]['store_id'];

		$groupRoles = $this->getGroupRole($this->id);
		$all = false;
		if (in_array('giao-dich-vien', $groupRoles) || in_array('cua-hang-truong', $groupRoles)) {
			$all = true;
		}
		if ($all) {
			$condition['created_by'] = $this->uemail;

			$condition['phone_introduce'] = !empty($this->info['phone_number']) ? $this->info['phone_number'] : "";
		} else {
			$condition['check_flag'] = "1";
		}

		$data = $this->collaborator_model->getByRole($condition);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Thành công",
			'data' => $data
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
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

	public function get_one_post(){

		$data = $this->input->post();
		$collaborator = $this->collaborator_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($data["id"])));
		if (empty($collaborator)) return;

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $collaborator
		);
		$this->set_response($response, REST_Controller::HTTP_OK);


	}

	public function update_post(){

		$this->dataPost = $this->input->post();
		$this->dataPost['id'] = $this->security->xss_clean($this->dataPost['id']);
		$this->dataPost['ctv_code'] = $this->security->xss_clean($this->dataPost['ctv_code']);
		$this->dataPost['ctv_name'] = $this->security->xss_clean($this->dataPost['ctv_name']);
		$this->dataPost['ctv_phone'] = $this->security->xss_clean($this->dataPost['ctv_phone']);
		$this->dataPost['ctv_job'] = $this->security->xss_clean($this->dataPost['ctv_job']);
		$this->dataPost['ctv_bank_name'] = $this->security->xss_clean($this->dataPost['ctv_bank_name']);
		$this->dataPost['ctv_bank'] = $this->security->xss_clean($this->dataPost['ctv_bank']);
		$this->dataPost['user'] = $this->security->xss_clean($this->dataPost['user']);

		//Validate
		if (empty($this->dataPost['ctv_code'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Mã CTV không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		if (empty($this->dataPost['ctv_name'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Tên CTV không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		if (empty($this->dataPost['ctv_phone'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "SĐT CTV không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		if (empty($this->dataPost['ctv_bank_name'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Tên ngân hàng không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		if (empty($this->dataPost['ctv_bank'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Số tài khoản không được để trống"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}


		$this->collaborator_model->update(array("_id" => new MongoDB\BSON\ObjectId($this->dataPost['id'])), ["ctv_name" => $this->dataPost['ctv_name'], "ctv_phone" => $this->dataPost['ctv_phone'], "ctv_job" => $this->dataPost['ctv_job'], "ctv_bank_name" => $this->dataPost['ctv_bank_name'], "ctv_bank" => $this->dataPost['ctv_bank'], "updated_at" => $this->createdAt]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Update borrowed success"

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function cron_code_ctv_post(){

		$list_ctv = $this->collaborator_model->find_notNumberCode();

		if (!empty($list_ctv)){
			foreach ($list_ctv as $value){

					$resNumberCode = $value->number_code_ctv;

//					$code_area = $value->user->stores[count($value->user->stores)-1]->code_area;

					$find_code_area = $this->store_model->findOne(['_id' => new MongoDB\BSON\ObjectId($value->user->stores[count($value->user->stores)-1]->store_id)]);

					if (!empty($find_code_area)) {
						$code_area = $find_code_area['code_area'];
					}

					$data['ctv_code'] = $code_area . ".00" . $resNumberCode;

					$this->collaborator_model->update(array("_id" => $value['_id']), ['ctv_code' => $data['ctv_code']]);

			}
		}

		echo "ok";
	}

	private function initNumberContractCode()
	{
		$maxNumber = $this->collaborator_model->getMaxNumberCodeCTV();
		$maxNumberCodeCTV = !empty($maxNumber[0]['number_code_ctv']) ? (float)$maxNumber[0]['number_code_ctv'] + 1 : 1;
		$res = array(
			"number_code_ctv" => $maxNumberCodeCTV
		);
		return $res;
	}


	function WriteLog($fileName, $data, $breakLine = true, $addTime = true)
	{

		$fp = fopen("log/" . $fileName, 'a');
		if ($fp) {
			if ($breakLine) {
				if ($addTime)
					$line = date("H:i:s, d/m/Y:  ", time()) . $data . " \n";
				else
					$line = $data . " \n";
			} else {
				if ($addTime)
					$line = date("H:i:s, d/m/Y:  ", time()) . $data;
				else
					$line = $data;
			}
			fwrite($fp, $line);
			fclose($fp);
		}
	}


	private function check_lead_verified($lead_group)
	{
		//Check verify
		$collaborator_check = $this->collaborator_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($lead_group['_id']), 'status' => 'active']);
		$condition = [
			'ctv_code' => $lead_group['_id'],
			'status_web' => "Thành công",
			'tien_hoa_hong' => array('$gt' => 0),
			'payment_status' => array('$nin' => array(1, 2))
		];
		$leads_payment_db = $this->lead_model->find_where($condition);
		if (empty($collaborator_check)) {
			$message = "Không tồn tại CTV cần xác thực hoặc tài khoản đang tạm khóa; ";
			echo $message;
			//update status payment fail for lead and write log
			foreach ($leads_payment_db as $lead) {
				$dataUpdate = [
					'payment_status' => 3, //1: Da thanh toan, 2: NL đang xử lý, 3: Thanh toan thất bại, 4: GD hoàn trả
					'payment_error' => $message
				]; //thanh toán thất bại
				$this->lead_model->update(
					['_id' => $lead['_id']], $dataUpdate
				);
				$this->log_payment_ctv_model->insertLog('payment_fail', 'update', $lead, $dataUpdate, time(), 'system');
			}
			// push FCM
			return false;
		}
		if (!empty($collaborator_check)) {
			if ($collaborator_check['status_verified'] != 3) {
				$message ="Tài khoản CTV chưa được xác thực " . '- ' . $collaborator_check['ctv_phone'] . ' - ' . $collaborator_check['ctv_name'] . '; ';
				echo $message;
				//update status payment fail for lead and write log
				foreach ($leads_payment_db as $lead) {
					$dataUpdate = [
						'payment_status' => 3, //1: Da thanh toan, 2: NL đang xử lý, 3: Thanh toan thất bại, 4: GD hoàn trả
						'payment_error' => $message
					]; //thanh toán thất bại
					$this->lead_model->update(
						['_id' => $lead['_id']], $dataUpdate
					);
					$this->log_payment_ctv_model->insertLog('payment_fail', 'update', $lead, $dataUpdate, time(), 'system');
				}
				// push FCM
				if (!empty($collaborator_check['device_token'])) {
					$fcm = new Fcm();
					$to[] = $collaborator_check['device_token'];
					$fcm->setTitle('XÁC THỰC TÀI KHOẢN CỘNG TÁC VIÊN');
					$fcm->setMessage('Để nhận tiền thanh toán hoa hồng từ TienNgay.vn, Qúy khách vui lòng xác thực tài khoản tại website: https://ctv.tienngay.vn. Trân trọng!');
					$message = $fcm->getMessage();
					if (!empty($to)) {
						$result = $fcm->sendToTopicCTVTienNgay($to, $message, $message);
					}
				}
				return false;
			}
			if ($collaborator_check['status_verified'] == 3) {
				echo "Tài khoản CTV đã xác thực chờ thanh toán " . '- ' . $collaborator_check['ctv_phone'] . ' - ' . $collaborator_check['ctv_name'] . '; ';
				return true;
			}
		}
	}


	/** Call API Chi hộ sang Ngân Lượng
	 * @param $lead_group
	 * @return bool
	 */
	private function paymentByNganLuong($lead_group)
	{
		$merchant_id = $this->config->item("NL_MERCHANT_ID");
		$merchant_password = $this->config->item("NL_MERCHANT_PASSWORD");
		$receiver_email = $this->config->item("NL_RECEIVER_EMAIL");
		$ctv_code = $lead_group['_id'] ?? '';
		$ref_code = "macode_" . $ctv_code . "_" . time();
		$total_amount = $lead_group['total'] ?? 0; //MỞ COMMENT CODE KHI ĐẨY LIVE
		$account_type = 3;
		$account_infor_many = $this->account_bank_model->find_where(['user_id' => (string)$lead_group['_id']]);
		$account_infor = $account_infor_many[0];
		$condition = [
			'ctv_code' => $lead_group['_id'],
			'status_web' => "Thành công",
			'tien_hoa_hong' => array('$gt' => 0),
			'payment_status' => array('$nin' => array(1, 2))
		];
		$leads_payment_db = $this->lead_model->find_where($condition);
		$collaborator = $this->collaborator_model->findOne(['_id' => new \MongoDB\BSON\ObjectId($lead_group['_id']), 'status' => 'active']);
		if (empty($account_infor)) {
			//update status payment fail for lead and write log
			foreach ($leads_payment_db as $lead) {
				$message = 'Bank account infor not found';
				$dataUpdate = [
					'payment_status' => 3,
					'payment_error' => $message
				]; //thanh toán thất bại
				$this->lead_model->update(
					['_id' => $lead['_id']], $dataUpdate
				);
				$this->log_payment_ctv_model->insertLog('payment_fail', 'update', $lead, $dataUpdate, time(), 'system');
			}
			//Push FCM
			if (!empty($collaborator['device_token'])) {
				$fcm = new Fcm();
				$to[] = $collaborator['device_token'] ? $collaborator['device_token'] : '';
				$fcm->setTitle('CẬP NHẬT THÔNG TIN TÀI KHOẢN NGÂN HÀNG');
				$fcm->setMessage('Để nhận tiền thanh toán hoa hồng từ TienNgay.vn, Quý khách vui lòng cập nhật thông tin tài khoản ngân hàng tại website: https://ctv.tienngay.vn. Trân trọng!');
				$message = $fcm->getMessage();
				if (!empty($to)) {
					$result = $fcm->sendToTopicCTVTienNgay($to, $message, $message);
				}
			}
			return false;
		}
		$bank_code = $account_infor['bank']['code'] ?? '';
		$bank_name = $account_infor['bank']['name'] ?? ''; // Tên ngân hàng. VD: Ngân hàng TMCP Quân đội
		$card_fullname = $account_infor['name_user'] ?? '';
		$card_number = $account_infor['stk_user'] ?? ''; // Số tài khoản ngân hàng
		$card_month = '';
		$card_year = '';
		$branch_name = $account_infor['bank_branch']['name'] ?? '';
		$reason = 'TienNgay thanh toan hoa hong CTV';
		$nlcheckout = new NL_Withdraw($merchant_id, $merchant_password, $receiver_email);
		$nlcheckout->url_api = $this->config->item("NL_WITHDRAW_URL");
		//Call API to payment by Ngan Luong
		try {
			$nl_result = $nlcheckout->SetCashoutRequest(
				$ref_code,
				$total_amount,
				$account_type,
				$bank_code,
				$card_fullname,
				$card_number,
				$card_month,
				$card_year,
				$branch_name,
				$reason
			);
			//Insert log
			$this->WriteLog("commissionCTVNganLuong" . date("Ymd", time()) . ".txt", " ================= START ======================= ");
			$this->WriteLog("commissionCTVNganLuong" . date("Ymd", time()) . ".txt", "[INPUT_WD]: ref_code :" . $ref_code . ",total_amount :" . $total_amount . ", account_type:" . $account_type . ",bank_code: " . $bank_code . ",card_fullname:" . $card_fullname . ",card_number:" . $card_number . ",card_month:" . $card_month . ",card_year:" . $card_year . ",branch_name:" . $branch_name . ",reason:" . $reason);
			$this->WriteLog("commissionCTVNganLuong" . date("Ymd", time()) . ".txt", "[OUTPUT_WD]: nl_result :" . json_encode($nl_result));
			$this->WriteLog("commissionCTVNganLuong" . date("Ymd", time()) . ".txt", " ================= END ======================= ");
			$leads_pay = $leads_payment_db;
			if ($nl_result->error_code == '00') {
				if ($nl_result->transaction_status == '00') {
					if (!empty($leads_pay)) {
						//insert transaction
						$codeTrans = 'PTCTV_' . date('Ymd'). '_' . uniqid();
						$nl_result->error_description = "Thành công";
						$dataInsertTran = [
							'date_pay' => time(),
							'code' => $codeTrans,
							'status' => 1, //1: Thanh cong, 2: Cho xu ly, 3: That bai
							'type' => 17, //thanh toan hoa hong cong tac vien
							'total' => $total_amount,
							'payment_method' => 'NganLuong',
							'note' => $reason,
							'bank' => $bank_code,
							'bank_username' => $card_fullname,
							'bank_name' => $bank_name,
							'bank_account' => $card_number,
							'result_nl' => $nl_result,
							'code_transaction_bank' => $ref_code,
							'ctv_code' => (string)$collaborator['_id'],
							'customer_bill_name' => $collaborator['ctv_name'] ?? '',
							'customer_bill_phone' => $collaborator['ctv_phone'] ?? '',
							"created_at" => time(),
							"created_by" => 'system'
						];
						$transaction_id = $this->transaction_model->insertReturnId($dataInsertTran);
						$this->log_payment_ctv_model->insertLog('payment_success', 'insert', array(), $dataInsertTran, time(), 'system');
						foreach ($leads_pay as $lead) {
							$arrUpdateLead = [
								'date_pay' => time(),
								'transaction_code' => $codeTrans,
								'his_money' => $lead['tien_hoa_hong'],
								'his_key' => $ref_code,
								'bank_username' => $card_fullname,
								'bank_name' => $bank_name,
								'bank_account' => $card_number
							];
							$arrUpdateLead['payment_status'] = 1; //1: Da thanh toan, 2: NL đang xử lý, 3: Thanh toan thất bại, 4: GD hoàn trả
							$arrUpdateLead['code_transaction'] = $codeTrans;
							$this->lead_model->update(
								array("_id" => new MongoDB\BSON\ObjectId((string)$lead['_id'])), $arrUpdateLead
							);
							$this->log_payment_ctv_model->insertLog('payment_success', 'update', $lead, $arrUpdateLead, time(), 'system');
							//PUSH FCM
							if (!empty($collaborator['device_token'])) {
								$fcm = new Fcm();
								$to[] = $collaborator['device_token'] ? $collaborator['device_token'] : '';
								$fcm->setTitle('THANH TOÁN HOA HỒNG CTV TienNgay.vn');
								$fcm->setMessage('Quý khách được thanh toán hoa hồng: '. number_format($total_amount) . ' VNĐ, khi giới thiệu khách vay thành công tại TienNgay.vn. Cảm ơn quý khách đã đồng hành cùng TienNgay.vn!');
								$message = $fcm->getMessage();
								if (!empty($to)) {
									$result = $fcm->sendToTopicCTVTienNgay($to, $message, $message);
								}
							}
						}
					}
				} else {
					if ($nl_result->transaction_status == '01') {
						$codeTrans = 'PTCTV_' . date('Ymd'). '_' . uniqid();
						$nl_result->error_description = "Thành công";
						$transaction_id = $this->transaction_model->insertReturnId($dataInsertTran);
						$this->log_payment_ctv_model->insertLog('payment_wait', 'insert', array(), $dataInsertTran, time(), 'system');
						$nl_result->error_description = 'Chờ ngân lượng xử lý';
						$payment_status = 2;
						$payment_action = 'payment_wait';
					} elseif ($nl_result->transaction_status == '02') {
						$nl_result->error_description = 'Giao dịch thất bại';
						$payment_status = 3;
						$payment_action = 'payment_fail';
					} elseif ($nl_result->transaction_status == '03') {
						$nl_result->error_description = 'Giao dịch đã hoàn trả';
						$payment_status = 4;
						$payment_action = 'payment_fail';
					}
					if (!empty($leads_pay)) {
						foreach ($leads_pay as $lead) {
							$arrUpdateLead['payment_status'] = $payment_status; //1: Da thanh toan, 2: NL đang xử lý, 3: Thanh toan thất bại, 4: GD hoàn trả
							$arrUpdateLead['result_nl'] = $nl_result;
							$this->lead_model->update(
								array("_id" => new MongoDB\BSON\ObjectId((string)$lead['_id'])), $arrUpdateLead
							);
							$this->log_payment_ctv_model->insertLog($payment_action, 'update', $lead, $arrUpdateLead, time(), 'system');
						}
					}
				}
			} else {
				$nl_result->error_description = isset($nl_result->error_message) ? $nl_result->error_message : "Thanh toán ngân lượng không thành công";
				if (!empty($leads_pay)) {
					//Write log
					foreach ($leads_pay as $lead) {
						$arrUpdateLead['payment_status'] = 3; //1: Da thanh toan, 2: NL đang xử lý, 3: Thanh toan thất bại, 4: GD hoàn trả
						$arrUpdateLead['result_nl'] = $nl_result;
						$this->lead_model->update(
							array("_id" => new MongoDB\BSON\ObjectId((string)$lead['_id'])), $arrUpdateLead
						);
						$this->log_payment_ctv_model->insertLog('payment_fail', 'update', $lead, $arrUpdateLead, time(), 'system');
						//PUSH FCM
					}
				}
			}
		} catch (Exception $exception) {
			$nl_result = $exception->getMessage();
			foreach ($leads_pay as $lead) {
				$arrUpdateLead['payment_status'] = 3; //1: Da thanh toan, 2: NL đang xử lý, 3: Thanh toan thất bại, 4: GD hoàn trả
				$arrUpdateLead['result_nl'] = $nl_result;
				$this->lead_model->update(
					array("_id" => new MongoDB\BSON\ObjectId((string)$lead['_id'])), $arrUpdateLead
				);
				$this->log_payment_ctv_model->insertLog('payment_fail', 'update', $lead, $arrUpdateLead, time(), 'system');
			}
		}
	}


	/** cron function autopayment commission for collaborator
	 *
	 */
	public function cron_auto_payment_commission_collaborator_post()
	{
		$lead_ctv_success_db = $this->lead_model->get_all_lead_success();
		if (!empty($lead_ctv_success_db)) {
			$lead_success_uniq = array_values(array_column($lead_ctv_success_db, null, 'ctv_code'));
			foreach ($lead_success_uniq as $lead) {
				$lead_group = $this->lead_model->get_all_lead_group_by(['ctv_code' => $lead['ctv_code']]);
				if (!empty($lead_group) && $lead_group['total'] > 100000) {
					$verify_lead = $this->check_lead_verified($lead_group);
					if ($verify_lead) {
						$nl_request = $this->paymentByNganLuong($lead_group);
					}
				}
			}
		}
		echo ' DONE!';
	}



}

?>

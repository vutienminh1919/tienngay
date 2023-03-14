<?php
include('application/vendor/autoload.php');
require_once APPPATH . 'libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class ReportPtkt extends REST_Controller
{
	public function __construct()
	{

		parent::__construct();
		$this->load->model("file_bank_model");
		$this->load->model("transaction_model");
		$this->load->model("lead_model");
		$this->load->model("dashboard_model");
		$this->load->model('contract_model');
		$this->load->model('log_lead_model');
		$this->load->model('log_model');
		$this->load->model('user_model');
		$this->load->model('role_model');
		$this->load->model("store_model");
		$this->load->model("group_role_model");
		$this->load->model('district_model');
		$this->load->model('ward_model');
		$this->load->helper('lead_helper');
		$this->load->model('province_model');
		$this->load->model('recording_model');
		$this->load->model("landing_page_model");
		$this->load->model("lead_extra_model");
		$this->load->model('cskh_del_model');
		$this->load->model('cskh_insert_model');
		$this->load->model('log_hs_model');
		$this->load->model('log_accesstrade_model');
		$this->load->model("notification_model");
		$this->load->model("order_model");
		$this->load->model("area_model");
		$this->load->model("createkpi_telesale_model");
		$this->load->model("log_trans_model");
		$this->load->model("log_transaction_file_bank_import_model");

		$this->createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		$headers = $this->input->request_headers();
		$this->dataPost = $this->input->post();
		$this->flag_login = 1;
		date_default_timezone_set('Asia/Ho_Chi_Minh');
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
				unset($this->dataPost['type']);
				$count_account = $this->user_model->count($this->app_login);
				$this->flag_login = 'success';
				if ($count_account != 1) $this->flag_login = 2;
				if ($count_account == 1) {
					$this->info = $this->user_model->findOne($this->app_login);
					$this->id = $this->info['_id'];
					$this->ulang = $this->info['lang'];
					$this->uemail = $this->info['email'];
					$this->superadmin = isset($this->info['is_superadmin']) && (int)$this->info['is_superadmin'] === 1;
				}
			}
		}
	}

	public function importBank_post()
	{
		$data = $this->input->post();
		$date = !empty($data['date']) ? strtotime($data['date']) : "";
		$code_transaction_bank = !empty($data['code_transaction_bank']) ? $data['code_transaction_bank'] : "";
		$code_contract = !empty($data['code_contract']) ? $data['code_contract'] : "";
		$code_contract_disbursement = !empty($data['code_contract_disbursement']) ? $data['code_contract_disbursement'] : "";
		$customer_name = !empty($data['customer_name']) ? $data['customer_name'] : "";
		$money = !empty($data['money']) ? $data['money'] : "";
		$bank = !empty($data['bank']) ? $data['bank'] : "";
		$bank_code = !empty($data['bank_code']) ? $data['bank_code'] : "";

		$dataInsert = [
			'date' => $date,
			'code_transaction_bank' => $code_transaction_bank,
			'code_contract' => $code_contract,
			'code_contract_disbursement' => $code_contract_disbursement,
			'customer_name' => $customer_name,
			'money' => $money,
			'bank' => $bank,
			'bank_code' => $bank_code,
			'created_at' => $this->createdAt,
			'created_by' => $this->uemail,
		];
		$duplicate = $this->file_bank_model->findOne([
			'date' => $date,
			'code_transaction_bank' => $code_transaction_bank,
			'code_contract' => $code_contract,
			'code_contract_disbursement' => $code_contract_disbursement,
			'customer_name' => $customer_name,
			'money' => $money,
			'bank' => $bank,
			'bank_code' => $bank_code,
		]);
		if (!$duplicate) {
			$result = $this->file_bank_model->insert($dataInsert);
		}
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'ok',
			'data' => $result
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function getImported()
	{
		$result = $this->file_bank_model->getImported();
		return $result;
	}

	public function getImportedCancel()
	{
		$result = $this->file_bank_model->getImportedCancel();
		return $result;
	}

	public function findPT($condition)
	{

		$import = $this->getImported();
//		$importCancel = $this->getImportedCancel();
		$result = [];
		$arr = [];
		$count_no_code = 0;
		$code_error = [];
		$code_tran = $this->transaction_model->getAllCodeTransactionBank();
		$search = [];
		$area = $condition['place'];
		$search['status'] = $condition['status'];
		if ($area) {
			$code = $this->area_model->find_where(['domain.code' => $area]);
			$domain = [];
			foreach ($code as $item) {
				$domain[] = $item->code;
			}
			$pgd = $this->store_model->find_where_in_active('code_area', $domain);
			$id_pgd = [];
			foreach ($pgd as $item) {
				$id_pgd[] = (string)$item->_id;
			}
			$search['place'] = $id_pgd;
		} else {
			$search['place'] = "";
		}
		foreach ($code_tran as $item) {
			$arr_tran[] = $item->code_transaction_bank;
		}

		$error = [];
		$arrCkThanhToan = [];
		$arrTienMatThanhToan = [];
		$arrTatToan = [];
		$arrCkThanhToanAll = [];
		$arrTienMatThanhToanAll = [];
		$arrTatToanAll = [];
		$arrTatToanAll1 = [];
		$countCkThanhToan = 0;
		$countTienMatThanhToan = 0;
		$countTatToan = 0;
		foreach ($import as $item) {
			if (!empty($item->code_transaction_bank)) {
				$search["code_transaction_bank"] = $item->code_transaction_bank;
				$search["code_contract"] = $item->code_contract;
				$search["code_contract_disbursement"] = $item->code_contract_disbursement;
//				$search["money"] = $item->money;
			}
			$ckThanhToan = $this->log_trans_model->getAllCkThanhToan($search)[0];
			$vpbankAllThanhToan = true;
			$ckThanhToanAll = $this->log_trans_model->getAllCkThanhToan($search, $vpbankAllThanhToan)[0];
			$tienMatThanhToan = $this->log_trans_model->getAllTienMatThanhToan($search)[0];
			$vpbankAllTienMatThanhToan = true;
			$tienMatThanhToanAll = $this->log_trans_model->getAllTienMatThanhToan($search, $vpbankAllTienMatThanhToan)[0];
			$tatToan = $this->log_trans_model->getAlltatToan($search)[0];
			$vpbankAllTatToan = true;
			$tatToanAll = $this->log_trans_model->getAlltatToan($search, $vpbankAllTatToan)[0];

			$pt = $this->transaction_model->findPT($search);
			if ($pt) {
//				$result[] = $this->transaction_model->findPT($search);
				$result[] = $pt;
			} elseif (!in_array($search["code_transaction_bank"], $arr_tran)) {
				$error[] = $item['code_transaction_bank'];
				$count_no_code += 1;
			}
			if (!empty($ckThanhToan)) {
				$countCkThanhToan += 1;
				$arrCkThanhToan[] = $ckThanhToan['old']['code'];
			}
			if (!empty($tienMatThanhToan)) {
				$countTienMatThanhToan += 1;
				$arrTienMatThanhToan[] = $tienMatThanhToan['old']['code'];
			}
			if (!empty($tatToan)) {
				$countTatToan += 1;
				$arrTatToan[] = $tatToan['old']['code'];
			}
			if (!empty($ckThanhToanAll)) {
				$arrCkThanhToanAll[] = $ckThanhToanAll['old']['code'];
				$countCkThanhToanAll += 1;
			}
			if (!empty($tienMatThanhToanAll)) {
				$arrTienMatThanhToanAll[] = $tienMatThanhToanAll['old']['code'];
				$countTienMatThanhToanAll += 1;
			}
			if (!empty($tatToanAll)) {
				$arrTatToanAll[] = $tatToanAll['old']['code'];
				$arrTatToanAll1[] = $item['code_transaction_bank'];
				$countTatToanAll += 1;
			}
		}
		$data = [
			'data' => $result,
			'count_no_code' => $count_no_code,
			'data_no_code' => $error,
			'detail_banking_thanhtoan' => $arrCkThanhToanAll,
			'detail_cash_thanhtoan' => $arrTienMatThanhToanAll,
			'detail_tattoan' => $arrTatToanAll,
			'data_ck_thanhtoan' => $countCkThanhToanAll,
			'data_cash_thanhtoan' => $countTienMatThanhToanAll,
			'data_tattoan' => $countTatToanAll,
		];
		return $data;

	}

	public function checkPT_post()
	{
		$data = $this->input->post();
		$this->log_transaction_file_bank_import_model->delete_all();
//		$start_date = !empty($data['start_date']) ? strtotime($data['start_date']) : "";
//		$end_date = !empty($data['end_date']) ? strtotime($data['end_date'] . " 23:59:59") : "";
		$store = !empty($data['place']) ? $data['place'] : "";
		$condition_core = [];
		$condition = [];
//		$condition['start'] = $start_date;
//		$condition['end'] = $end_date;
		$condition['place'] = $store;
		$area = $condition['place'];
		if ($area) {
			$code = $this->area_model->find_where(['domain.code' => $area]);
			$domain = [];
			foreach ($code as $item) {
				$domain[] = $item->code;
			}
			$pgd = $this->store_model->find_where_in_active('code_area', $domain);
			$id_pgd = [];
			foreach ($pgd as $item) {
				$id_pgd[] = (string)$item->_id;
			}
			$search_place = $id_pgd;
		} else {
			$search_place = "";
		}
		$url_api_core = $this->config->item('URL_CORE');
//		$condition_core['start_date_pay'] = $start_date;
//		$condition_core['end_date_pay'] = $end_date;
		$condition_core['place'] = !empty($search_place) ? json_encode($search_place) : "";
		$url_core = $url_api_core . "vpbank/mistakentransaction/getAllTransactions";

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $url_core,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => $condition_core,
		));

		$response = curl_exec($curl);
		curl_close($curl);
		$data = json_decode($response, true);
		$dataError = $data['data']['data'];
		$arrPT_vpbank_error = [];
		foreach ($dataError as $item) {
			$arrPT_vpbank_error[] = $item['tn_trancode'];
		}
		$arrPT = $this->findPT($condition);
		$count_thanh_toan_success_cash = 0;
		$count_thanh_toan_success_banking = 0;
		$count_tat_toan = 0;
		$count_momo = 0;
		$count_vpbank = 0;
		$count_vpbank1 = 0;
		$count_vpbank_error = 0;
		$count_cancel = 0;
		$count_pending_cash = 0;
		$count_pending_banking = 0;
		$count_no_code = 0;
		$count_total = 0;
		$PT_thanh_toan_success_cash = [];
		$PT_thanh_toan_success_banking = [];
		$PT_tat_toan = [];
		$PT_momo = [];
		$PT_vpbank = [];
		$PT_cash = [];
		$PT_banking = [];
		$PT_cancel = [];
		$PT_nocode = [];
		$code = [];
		$code_cash = [];
		$code_banking = [];
		$code_banking = [];
		$code_tt = [];
		$count_bank_VP = 0;
		$arr_count_bank_VP = [];

		foreach ($arrPT['data'] as $item) {
//			if ($item['type'] == 4 && $item['payment_method'] == "1" && $item['status'] == 1) {
//				$count_thanh_toan_success_cash += 1;
//				$PT_thanh_toan_success_cash[] = $item['code'];
//				$code_cash[] = $item['code_transaction_bank'];
//			}
//			if ($item['type'] == 4 && $item['payment_method'] == "2" && $item['status'] == 1) {
//				$count_thanh_toan_success_banking += 1;
//				$PT_thanh_toan_success_banking[] = $item['code'];
//				$code_banking[] = $item['code_transaction_bank'];
//			}
//			if ($item['type'] == 3 && $item['status'] == 1) {
//				$count_tat_toan += 1;
//				$PT_tat_toan[] = $item['code'];
//				$code_tt[] = $item['code_transaction_bank'];
//			}


			if ($item['status'] == 1 && $item['payment_method'] == "momo_app") {
				$count_momo += 1;
				$PT_momo[] = $item['code'];
			}
			if ($item['status'] == 1 && $item['bank'] == "VPB" && (in_array($item['payment_method'], ['1','VPBank']))) {
				$count_vpbank += 1;
				$PT_vpbank[] = $item['code'];
			}
//			if ($item['status'] == 1 && $item['payment_method'] == "VPBank") {
//				$count_vpbank += 1;
//				$PT_vpbank[] = $item['code'];
//				$code[] = $item['code_transaction_bank'];
//			}
			if (in_array($item['code'], $arrPT_vpbank_error)) {
				$count_vpbank_error += 1;
				$PT_vpbank_error[] = $item['code'];
			}
			if ($item['status'] == 3) {
				$count_cancel += 1;
				$PT_cancel[] = $item['code'];
			}
			if ($item['payment_method'] == "1" && ($item['status'] == 11 || $item['status'] == 2)) {
				$count_pending_cash += 1;
				$PT_cash[] = $item['code'];
			}
			if ($item['payment_method'] == "2" && ($item['status'] == 11 || $item['status'] == 2)) {
				$count_pending_banking += 1;
				$PT_banking[] = $item['code'];
			}
		}
		$arr_tat_toan_duplicate = array_diff($arrPT['detail_tattoan'], $PT_vpbank_error);
		$count_tat_toan_duplicate = count($arr_tat_toan_duplicate);
//		$count_thanh_cong_duyet_tay = $count_thanh_toan_success_cash + $count_thanh_toan_success_banking + $count_tat_toan;
//		'data_ck_thanhtoan' => $countCkThanhToan,
//			'data_cash_thanhtoan' => $countTienMatThanhToan,
//			'data_tattoan' => $countTatToan,

//		$count_thanh_cong_duyet_tay = $arrPT['data_ck_thanhtoan'] + $arrPT['data_cash_thanhtoan'] + $arrPT['data_tattoan'];
		$count_thanh_cong_duyet_tay = $arrPT['data_ck_thanhtoan'] + $arrPT['data_cash_thanhtoan'] + $count_tat_toan_duplicate;

		$count_confirm_and_return = $count_pending_cash + $count_pending_banking;

		$count_no_code = $arrPT['count_no_code'];

		$count_vpbank_success = $count_vpbank - $count_vpbank_error;
		$count_total = $count_thanh_cong_duyet_tay + $count_confirm_and_return + $count_momo + $count_vpbank + $count_cancel + $count_no_code;
//		$count_total = count($arrPT['data']) + $count_no_code;
//		$count_vpbank = $count_total - ($count_thanh_cong_duyet_tay + $count_confirm_and_return + $count_momo + $count_cancel + $count_no_code);
		$count_vpbank_success = $count_vpbank - $count_vpbank_error;
		$rate_count_no_code = number_format($count_no_code / $count_total * 100, 2);
		if (!$store) {
			//
		} else {
			$rate_count_no_code = "0";
			$count_total = $count_thanh_cong_duyet_tay + $count_confirm_and_return + $count_momo + $count_vpbank + $count_cancel;
//			$count_total = count($arrPT['data']);
			$count_total = $count_total . " " . "(" . 'không bao gồm mã GD ngân hàng chưa tạo' . ")";
			$count_no_code = $count_no_code . " " . "(" . 'bao gồm cả hai vùng miền' . ")";
		}
//		$rate_thanh_cong_duyet_tay = number_format($count_thanh_cong_duyet_tay / $count_total * 100, 2);
//		$rate_thanh_toan_banking = number_format($count_thanh_toan_success_banking / $count_total * 100, 2);
//		$rate_thanh_toan_cash = number_format($count_thanh_toan_success_cash / $count_total * 100, 2);
//		$rate_count_tat_toan = number_format($count_tat_toan / $count_total * 100, 2);
		$rate_thanh_cong_duyet_tay = number_format($count_thanh_cong_duyet_tay / $count_total * 100, 2);
		$rate_thanh_toan_banking = number_format($arrPT['data_ck_thanhtoan'] / $count_total * 100, 2);
		$rate_thanh_toan_cash = number_format($arrPT['data_cash_thanhtoan'] / $count_total * 100, 2);
		$rate_count_tat_toan = number_format($count_tat_toan_duplicate / $count_total * 100, 2);
		$rate_count_momo = number_format($count_momo / $count_total * 100, 2);
		$rate_count_cancel = number_format($count_cancel / $count_total * 100, 2);
		$rate_count_confirm_and_return = number_format($count_confirm_and_return / $count_total * 100, 2);
		$rate_count_confirm_and_return_banking = number_format($count_pending_banking / $count_total * 100, 2);
		$rate_count_confirm_and_return_cash = number_format($count_pending_cash / $count_total * 100, 2);
		$rate_count_no_code = number_format($count_no_code / $count_total * 100, 2);
		$rate_count_vpbank = number_format($count_vpbank / $count_total * 100, 2);
		$rate_count_vpbank_success = number_format($count_vpbank_success / $count_total * 100, 2);
		$rate_count_vpbank_error = number_format($count_vpbank_error / $count_total * 100, 2);
		if ($PT_vpbank_error) {
			$PT_vpbank_success = array_diff($PT_vpbank, $PT_vpbank_error);
		} else {
			$PT_vpbank_success = $PT_vpbank;
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'mess' => "ok",
			'data' => [
				' - Lệnh thành công duyệt tay' => [
					'count' => $count_thanh_cong_duyet_tay,
					'rate' => $rate_thanh_cong_duyet_tay
				],
				' + Lệnh thành công duyệt tay( thanh toán kỳ Chuyển khoản )' => [
					'count' => $arrPT['data_ck_thanhtoan'],
					'rate' => $rate_thanh_toan_banking,
//					'detail' => implode(", ", $PT_thanh_toan_success_banking)
					'detail' => implode(", ", (array)$arrPT['detail_banking_thanhtoan'])
				],
				' + Lệnh thành công duyệt tay (thanh toán kỳ Tiền mặt)' => [
					'count' => $arrPT['data_cash_thanhtoan'],
					'rate' => $rate_thanh_toan_cash,
//					'detail' => implode(", ", $PT_thanh_toan_success_cash)
					'detail' => implode(", ", (array)$arrPT['detail_cash_thanhtoan'])
				],
				' + Lệnh thành công duyệt tay( tất toán )' => [
					'count' => $count_tat_toan_duplicate,
					'rate' => $rate_count_tat_toan,
//					'detail' => implode(", ", $PT_tat_toan)
					'detail' => implode(", ", (array)$arr_tat_toan_duplicate)
				],
				'- Lệnh thành công Momo' => [
					'count' => $count_momo,
					'rate' => $rate_count_momo,
					'detail' => implode(", ", (array)$PT_momo)
				],
				'- Lệnh thành công định danh quá VPB' => [
					'count' => $count_vpbank,
					'rate' => $rate_count_vpbank,
					'detail' => implode(", ", (array)$PT_vpbank)
				],
				'+ lệnh định danh thành công đúng' => [
					'count' => $count_vpbank_success,
					'rate' => $rate_count_vpbank_success,
					'detail' => implode(", ", (array)$PT_vpbank_success)
				],
				'+ lệnh định danh thành công lỗi đã sửa' => [
					'count' => $count_vpbank_error,
					'rate' => $rate_count_vpbank_error,
					'detail' => implode(", ", (array)$PT_vpbank_error)
				],
				'- Lệnh PT huỷ' => [
					'count' => $count_cancel,
					'rate' => $rate_count_cancel,
					'detail' => implode(", ", (array)$PT_cancel)
				],
				'- Mã GD Ngân hàng pending đã tạo chưa được duyệt' => [
					'count' => $count_confirm_and_return,
					'rate' => $rate_count_confirm_and_return,

				],
				'+ Mã GD Ngân hàng pending đã tạo chưa được duyệt ( Tiền Mặt)' => [
					'count' => $count_pending_cash,
					'rate' => $rate_count_confirm_and_return_cash,
					'detail' => implode(", ", (array)$PT_cash)
				],
				'+ Mã GD Ngân hàng pending đã tạo chưa được duyệt ( Chuyển khoản)' => [
					'count' => $count_pending_banking,
					'rate' => $rate_count_confirm_and_return_banking,
					'detail' => implode(", ", (array)$PT_banking)
				],
				'- Mã GD Ngân hàng chưa tạo' => [
					'count' => $count_no_code,
					'rate' => $rate_count_no_code,
					'detail' => !empty($arrPT['data_no_code']) ? implode(", ", (array)$arrPT['data_no_code']) : ""
				],
				'Tổng hợp các lệnh' => [
					'count' => $count_total,
					'rate' => '100'
				],
			]
		);
		$log = $this->log_transaction_file_bank_import_model->insert([
			'type' => 'all',
			'data' => $response,
		]);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function test_post()
	{

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://v2.tienvui.vn/vpbank/mistakentransaction/getAllTransactions',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
		));

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;
	}

	public function checkPTCancel_post()
	{
		$data = $this->input->post();
		$this->log_transaction_file_bank_import_model->delete_all();
//		$start_date = !empty($data['start_date']) ? strtotime($data['start_date'] . "0:00:00") : "";
//		$end_date = !empty($data['end_date']) ? strtotime($data['end_date'] . "23:59:59") : "";
		$store = !empty($data['place']) ? $data['place'] : "";
//		$condition['start'] = $start_date;
//		$condition['end'] = $end_date;
		$condition['place'] = $store;
		$condition['status'] = 3;

		$arrPT = $this->findPT($condition);
		$count_cancel = 0;
		$PT_cancel = [];
		$PT_reason = [];
		$PT = [];
		$str_item = [];
		$arr_code = [];
		$arr_note = [];
		foreach ($arrPT['data'] as $item) {
//			if ($item['status'] == 3) {
//				if (is_array($item['note'])) {
//					$str_item = implode(",", $item['note']);
//				} else {
//					$str_item = $item['note'];
//				}
//
//				if (is_iterable($item['note'])) {
//					foreach ($item['note'] as $n) {
//						if (!in_array($item['note'], $arr_note)) {
//							array_push($arr_note, $item['note']);
//						}
//					}
//				} else {
//					if (!in_array($item['note'], $arr_note)) {
//						array_push($arr_note, $item['note']);
//					}
//				}
//				$count_cancel += 1;
//			}
			if ($item['status'] == 3) {
				array_push($arr_note, $item['code_transaction_bank']);
				$count_cancel += 1;
			}

		}
		foreach ($arr_note as $value) {
			$arr_value = [];
			foreach ($arrPT['data'] as $item) {
				if ($item['status'] == 3) {
					if ($value == $item['code_transaction_bank']) {
						array_push($arr_value, $item['code']);
					}
				}
			}
//			if (is_iterable($value)) {
//				$arr_note_1 = $value;
//				$value = implode(",", (array)$value);
//			} else {
//				$arr_note_1 = $value;
//			}
			$arr_code += [$value => [
				'detail' => $arr_value,
//				'note' => $arr_note_1,
			]];
		}
		if ($count_cancel != 0) {
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'mess' => "ok",
				'count' => $count_cancel,
				'data' => $arr_code
			);
		} else {
			$response = array(
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'mess' => "ok",
			);
		}
		$log = $this->log_transaction_file_bank_import_model->insert([
			'type' => 'cancel',
			'data' => $response
		]);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function getSortPt_post()
	{
		$result = $this->log_transaction_file_bank_import_model->getAll();
		$response = array(
			'status' => REST_Controller::HTTP_BAD_REQUEST,
			'mess' => "ok",
			'data' => $result,
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function getSortPtCancel_post()
	{
		$result = $this->log_transaction_file_bank_import_model->getAllCancel();
		$response = array(
			'status' => REST_Controller::HTTP_BAD_REQUEST,
			'mess' => "ok",
			'data' => $result,
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function delete_all_file_bank_import_post()
	{
		$result = $this->file_bank_model->delete_all();
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'mess' => "ok",
			'data' => $result,
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}


}

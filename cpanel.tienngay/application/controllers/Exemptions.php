<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Exemptions extends MY_Controller
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
		$this->load->helper('location_helper');
		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
		$this->spreadsheet = new Spreadsheet();
		$this->sheet = $this->spreadsheet->getActiveSheet();
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	/** Get danh sách đơn miễn giảm theo miền nam, bắc
	 * @return void
	 */
	public function index()
	{
		$this->data["pageName"] = "Danh sách hợp đồng xin miễn giảm";
		$store_code = !empty($_GET['store']) ? $_GET['store'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "17";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$customer_phone_number = !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";

		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('exemptions'));
		}
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$condition['start'] = $start;
			$condition['end'] = $end;
		}
		if (!empty($store_code)) {
			$condition['store_id'] = trim($store_code);
		}
		if (!empty($code_contract)) {
			$condition['code_contract'] = trim($code_contract);
		}

		if (!empty($customer_name)) {
			$condition['customer_name'] = $customer_name;
		}
		if (!empty($customer_phone_number)) {
			$condition['customer_phone_number'] = $customer_phone_number;
		}
		if (!empty($code_contract_disbursement)) {
			$condition['code_contract_disbursement'] = $code_contract_disbursement;
		}

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('exemptions/index?code_contract_disbursement=' . $code_contract_disbursement . '&fdate=' . $start . '&tdate=' . $end . '&customer_name=' . $customer_name . '&customer_phone_number' . $customer_phone_number . '&store=' . $store_code . '&code_contract=' . $code_contract . '&status=' . $status);
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 30;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		// call api get contract data
		$data = array(
			"condition" => $condition,
			"per_page" => $config['per_page'],
			"uriSegment" => $config['uri_segment']
		);
		$result = $this->api->apiPost($this->userInfo['token'], "exemptions/get_all_application_exemptions", $data);
		if (isset($result->status) && $result->status == 200) {
			$this->data['dataExemptions'] = $result->data;
			foreach ($result->data as $key => $exemption_contract) {
				$data_find_contract = [
					"id" => $exemption_contract->id_contract
				];
				$data_find_tempo_contract = [
					"code_contract" => $exemption_contract->code_contract
				];


				$contract_one = $this->api->apiPost($this->userInfo['token'], "contract/get_one", $data_find_contract);
				$exemption_contract->status_contract = $contract_one->data->status;
				$tempo_contract = $this->api->apiPost($this->userInfo['token'],'exemptions/get_current_period', $data_find_tempo_contract);
				if (!empty($tempo_contract->status) && $tempo_contract->status == 200) {
					$transaction_discount = $this->api->apiPost($this->userInfo['token'], 'exemptions/get_transaction_discount',['code_contract' => $exemption_contract->code_contract,'ky_tra_hien_tai' => $tempo_contract->ky_tra_hien_tai]);
					if (!empty($transaction_discount->status) && $transaction_discount->status == 200) {
						$exemption_contract->is_discount_transaction = $transaction_discount->check_discount;
					}
					$ky_tra_hien_tai = $tempo_contract->ky_tra_hien_tai;
					$exemption_contract->ky_tra_hien_tai = $ky_tra_hien_tai;
				}
			}
			$config['total_rows'] = $result->total;

		} else {
			$this->data['dataExemptions'] = [];
		}
		$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all");
		if (!empty($storeData->status) && $storeData->status == 200) {
			$this->data['storeData'] = $storeData->data;
		} else {
			$this->data['storeData'] = array();
		}

		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		$this->data['user_id_login'] = $this->userInfo['id'];
		$data_send_api = [];
			$groupRolesHighManager = $this->api->apiPost($this->userInfo['token'], "exemptions/get_group_role_high_manager", $data_send_api);
		if (!empty($groupRolesHighManager->status) && $groupRolesHighManager->status == 200) {
			$this->data['groupRolesHighManager'] = $groupRolesHighManager->data;
		} else {
			$this->data['groupRolesHighManager'] = array();
		}

		$groupRolesReceiveEmail = $this->api->apiPost($this->userInfo['token'], "exemptions/get_group_role_cc_receive_email", $data_send_api);
		if (!empty($groupRolesReceiveEmail->status) && $groupRolesReceiveEmail->status == 200) {
			$this->data['groupRolesReceiveEmail'] = $groupRolesReceiveEmail->data;
		} else {
			$this->data['groupRolesReceiveEmail'] = array();
		}

		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['result_count'] = $config['total_rows'];
		$this->data['template'] = 'page/accountant/thn/list_contract_exemptions';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	private function pushJson($code, $data)
	{
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}

	public function approve_exemptions()
	{
		$data = $this->input->post();
		$data['id_contract'] = $this->security->xss_clean($data['id_contract']);
		$data['id_exemption'] = $this->security->xss_clean($data['id_exemption']);
		$data['code_contract'] = $this->security->xss_clean($data['code_contract']);
		$data['store'] = $this->security->xss_clean($data['store']);
		$data['status'] = $this->security->xss_clean($data['status']);
		$data['status_update'] = $this->security->xss_clean($data['status_update']);
		$data['amount_customer_suggest'] = $this->security->xss_clean($data['amount_customer_suggest']);
		$data['amount_tp_thn_suggest'] = $this->security->xss_clean($data['amount_tp_thn_suggest']);
		$data['date_suggest'] = $this->security->xss_clean($data['date_suggest']);
		$data['date_customer_sign'] = $this->security->xss_clean($data['date_customer_sign']);
		$data['image_file'] = $this->security->xss_clean($data['image_file']);
		$data['note'] = $this->security->xss_clean($data['note']);
		$data['note_lead'] = $this->security->xss_clean($data['note_lead']);
		$data['note_tp_thn'] = $this->security->xss_clean($data['note_tp_thn']);
		$data['note_qlcc'] = $this->security->xss_clean($data['note_qlcc']);
		$data['user_receive_approve'] = $this->security->xss_clean($data['user_receive_approve']);
		$data['user_receive_cc'] = $this->security->xss_clean($data['user_receive_cc']);
		$data['position'] = $this->security->xss_clean($data['position']);
		$data['amount_customer_suggest'] = str_replace( array( '.', ','), '', $data['amount_customer_suggest']);
		$data['amount_tp_thn_suggest'] = str_replace( array( '.', ','), '', $data['amount_tp_thn_suggest']);
        $data['type_payment_exem'] = isset($data['type_payment_exem']) ? $data['type_payment_exem'] : 1;
        $data['confirm_email'] = isset($data['confirm_email']) ? $data['confirm_email'] : 1;
        $data['is_exemption_paper'] = isset($data['is_exemption_paper']) ? $data['is_exemption_paper'] : 1;
        $type_payment_exem = isset($data['type_payment_exem']) ? $data['type_payment_exem'] : 1;
		$data['customer_identify'] = $this->security->xss_clean($data['customer_identify']);
		$data['number_date_late'] = $this->security->xss_clean($data['number_date_late']);

        // ngày hiệu lực để áp dụng số tiền thanh toán/tất toán có ngày thanh toán (date_pay) là ngày KH ký đơn miễn giảm + 10 day
		$date_effect_config = '+10 day';
        $start_date_effect = (int)strtotime($data['date_customer_sign']);
        $end_date_effect = (int)strtotime($date_effect_config, strtotime($data['date_customer_sign']. ' 23:59:59'));

		// Lấy thông tin hợp đồng full
		$data_send_tempo = [
			"id" => $data['id_contract']
		];
		$contractData = $this->api->apiPost($this->userInfo['token'], "view_payment/tempo_detail", $data_send_tempo);
		if (!empty($contractData->status) && $contractData->status == 200) {
			$contract_full = $contractData->contract;
		}

		// Lấy kỳ thanh toán hiện tại làm miễn giảm
		$data_send_period = [
			'code_contract' => $contract_full->code_contract,
		];
		$period_contract = $this->api->apiPost($this->userInfo['token'], 'exemptions/get_current_period',$data_send_period);
		if (!empty($period_contract->status) && $period_contract->status == 200) {
			$current_period = $period_contract->ky_tra_hien_tai;
			$ngay_den_han = $period_contract->ngay_den_han;
			$next_period = $current_period + 1;
			$data_tempo_plan_contract = $period_contract->contract;

			$next_period_time = 0;
			foreach ($data_tempo_plan_contract as $key => $tempo_contract) {
				if ($next_period == $tempo_contract->ky_tra) {
					$next_period_time = $tempo_contract->ngay_ky_tra;
					break;
				} else {
					$next_period_time = $ngay_den_han;
				}
			}
		}

		// B1: Tạo đơn miễn giảm
		if (!empty($data['status']) && $data['status'] == 1) {

			if (empty($data['amount_customer_suggest'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Số tiền đề nghị miễn giảm không được để trống!")));
				return;
			}

			if (!empty($data['amount_customer_suggest']) && ($data['amount_customer_suggest'] < 1000)) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Số tiền đề nghị miễn giảm không hợp lệ!")));
				return;
			}
			if (empty($data['date_suggest'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Ngày đề nghị miễn giảm không được để trống!")));
				return;
			}
			if (empty($data['number_date_late'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa nhập số ngày quá hạn!")));
				return;
			}
			if ( !empty($data['date_suggest']) && strtotime($data['date_suggest']) < strtotime(date('Y-m-d', $contract_full->disbursement_date))   && $type_payment_exem==1) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Ngày đề nghị miễn giảm không được nhỏ hơn ngày giải ngân!")));
				return;
			}
			if ($current_period == 1 && $type_payment_exem==1) {
				if (!empty($data['date_suggest']) && strtotime($data['date_suggest']) < strtotime(date('Y-m-d', $ngay_den_han))   && $type_payment_exem==1) {
					$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Ngày đề nghị miễn giảm không được nhỏ hơn ngày đến hạn gần nhất!")));
					return;
				}
			}
			if (!empty($data['date_suggest']) && strtotime($data['date_suggest']) < strtotime(date('Y-m-d', $ngay_den_han)) && $contract_full->debt->is_qua_han == 0  && $type_payment_exem==1) {
					$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Ngày đề nghị miễn giảm không được nhỏ hơn ngày đến hạn gần nhất!")));
					return;
			}

			if (!empty($data['date_suggest']) && strtotime($data['date_suggest']) >= strtotime(date('Y-m-d', $next_period_time)) && $contract_full->debt->is_qua_han == 0  && $type_payment_exem==1) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Ngày đề nghị miễn giảm không được lớn hơn ngày đến hạn gần nhất!")));
				return;
			}

			if (empty($data['image_file'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Ảnh hồ sơ miễn giảm không được để trống!")));
				return;
			}

			$sendApi = [
				'id_contract' => $data['id_contract'],
				'code_contract' => $data['code_contract'],
				'code_contract_disbursement' => $contract_full->code_contract_disbursement,
				'customer_name' => $contract_full->customer_infor->customer_name,
				'customer_phone_number' => $contract_full->customer_infor->customer_phone_number,
				'store' => $data['store'],
				'ky_tra' => $current_period,
				'ngay_ky_tra' => (int)$ngay_den_han,
				'status' => $data['status'],
				'amount_customer_suggest' => $data['amount_customer_suggest'],
				'date_suggest' => (int)strtotime($data['date_suggest']),
				'start_date_effect' => $start_date_effect,
				'end_date_effect' => $end_date_effect,
				'image_file' => $data['image_file'],
				'note' => $data['note'],
				'number_date_late' => $data['number_date_late'],
				'customer_identify' => $data['customer_identify']
			];
			$sendApi['type_payment_exem'] = $data['type_payment_exem'];
			$sendApi['confirm_email'] = $data['confirm_email'];
			$sendApi['is_exemption_paper'] = $data['is_exemption_paper'];
		}

		//	Cập nhập đơn miễn giảm
		if (!empty($data['status_update']) && $data['status_update'] == 1) {
			if (empty($data['amount_customer_suggest'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Số tiền đề nghị miễn giảm không được để trống!")));
				return;
			}
			if (!empty($data['amount_customer_suggest']) &&  ($data['amount_customer_suggest'] < 1000) ) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Số tiền đề nghị miễn giảm không hợp lệ!")));
				return;
			}
			if (empty($data['date_suggest'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Ngày đề nghị miễn giảm không được để trống!")));
				return;
			}
			if (empty($data['number_date_late'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa nhập số ngày quá hạn!")));
				return;
			}
			if ( !empty($data['date_suggest']) && strtotime($data['date_suggest']) < strtotime(date('Y-m-d', $contract_full->disbursement_date))   && $type_payment_exem==1) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Ngày đề nghị miễn giảm không được nhỏ hơn ngày giải ngân!")));
				return;
			}
			if ($current_period == 1) {
				if (!empty($data['date_suggest']) && strtotime($data['date_suggest']) < strtotime(date('Y-m-d', $ngay_den_han))  && $type_payment_exem==1) {
					$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Ngày đề nghị miễn giảm không được nhỏ hơn ngày đến hạn gần nhất!")));
					return;
				}
			}
			if (!empty($data['date_suggest']) && strtotime($data['date_suggest']) < strtotime(date('Y-m-d', $ngay_den_han)) && $contract_full->debt->is_qua_han == 0  && $type_payment_exem==1) {
					$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Ngày đề nghị miễn giảm không được nhỏ hơn ngày đến hạn gần nhất!")));
					return;
			}
			if (!empty($data['date_suggest']) && strtotime($data['date_suggest']) >= strtotime(date('Y-m-d', $next_period_time)) && $contract_full->debt->is_qua_han == 0  && $type_payment_exem==1) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Ngày đề nghị miễn giảm không được lớn hơn ngày đến hạn gần nhất!")));
				return;
			}
			if (empty($data['image_file'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Ảnh hồ sơ miễn giảm không được để trống!")));
				return;
			}

			$sendApi = [
				'id_exemption' => $data['id_exemption'],
				'id_contract' => $data['id_contract'],
				'code_contract' => $data['code_contract'],
				'ky_tra' => $current_period,
				'status_update' => $data['status_update'],
				'amount_customer_suggest' => $data['amount_customer_suggest'],
				'date_suggest' => (int)strtotime($data['date_suggest']),
				'start_date_effect' => $start_date_effect,
				'end_date_effect' => $end_date_effect,
				'image_file' => $data['image_file'],
				'note' => $data['note'],
				'customer_identify' => $data['customer_identify'],
				'number_date_late' => $data['number_date_late'],
			];
			$sendApi['type_payment_exem'] = $data['type_payment_exem'];
			$sendApi['confirm_email'] = $data['confirm_email'];
			$sendApi['is_exemption_paper'] = $data['is_exemption_paper'];
		}

		//	B2: Lead QLHĐV xử lý
		if (!empty($data['status']) && in_array($data['status'],[2,3,4,7,8,9])) {
			$sendApi = [
				'id_exemption' => $data['id_exemption'],
				'code_contract' => $data['code_contract'],
				'ky_tra' => $current_period,
				'position' => $data['position'],
				'status' => $data['status'],
				'customer_identify' => $data['customer_identify']
			];

			if ($data['position'] == "lead") {
				$sendApi['note_lead'] = $data['note_lead'];
			} elseif ($data['position'] == "tp") {
				$sendApi['note_tp_thn'] = $data['note_tp_thn'];
			} elseif ($data['position'] == "qlcc") {
				$sendApi['note_qlcc'] = $data['note_qlcc'];
			}
		}

		//	B3: TP QLHĐV xử lý.
		if (!empty($data['status']) && $data['status'] == 5) {
			if (empty($data['amount_tp_thn_suggest'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Số tiền đề xuất duyệt không được để trống!")));
				return;
			}
			if (!empty($data['amount_tp_thn_suggest']) && ($data['amount_tp_thn_suggest'] < 1000) ) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Số tiền đề xuất duyệt miễn giảm không hợp lệ!")));
				return;
			}
			$sendApi = [
				'id_exemption' => $data['id_exemption'],
				'code_contract' => $data['code_contract'],
				'ky_tra' => $current_period,
				'image_file' => $data['image_file'],
				'amount_tp_thn_suggest' => $data['amount_tp_thn_suggest'],
				'note_tp_thn' => $data['note_tp_thn'],
				'status' => $data['status'],
				'customer_identify' => $data['customer_identify']
			];
		} elseif (!empty($data['status']) && $data['status'] == 6) {
			if (empty($data['amount_tp_thn_suggest'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Số tiền đề nghị miễn giảm không được để trống!")));
				return;
			}
			if (!empty($data['amount_tp_thn_suggest']) && ($data['amount_tp_thn_suggest'] < 1000) ) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Số tiền đề nghị miễn giảm không hợp lệ!")));
				return;
			}
			$string_user_receive_cc = implode(',', $data['user_receive_cc']);
			$convert_user_receive_cc = explode(',', $string_user_receive_cc);
			$sendApi = [
				'id_exemption' => $data['id_exemption'],
				'code_contract' => $data['code_contract'],
				'ky_tra' => $current_period,
				'image_file' => $data['image_file'],
				'amount_tp_thn_suggest' => $data['amount_tp_thn_suggest'],
				'note_tp_thn' => $data['note_tp_thn'],
				'status' => $data['status'],
				'user_receive_approve' => explode(',', $data['user_receive_approve']),
				'user_receive_cc' => $convert_user_receive_cc,
				'customer_identify' => $data['customer_identify']
			];
		}
		$result = $this->api->apiPost($this->userInfo['token'], "exemptions/approve_exemptions", $sendApi);
		if (isset($result->status) && $result->status == 200) {
			
			$this->pushJson('200', json_encode(['status' => '200', 'msg' => 'Thành công!']));
			return;
		} else {
			$this->pushJson('200', json_encode(array('status' => "401", 'msg' => $result->message)));
			return;
		}
	}

	public function restore_exemption_contract()
	{
		$data = $this->input->post();
		$data['id_contract'] = $this->security->xss_clean($data['id_contract']);
		$data['id_exemption'] = $this->security->xss_clean($data['id_exemption']);
		$data['code_contract'] = $this->security->xss_clean($data['code_contract']);
		$data['type_payment_exem'] = isset($data['type_payment_exem']) ? $data['type_payment_exem'] : 1;

		$sendApi = array(
			'id_exemption' => $data['id_exemption'],
			'id_contract' => $data['id_contract'],
			'code_contract' => $data['code_contract'],
			'type_payment_exem' => $data['type_payment_exem'],
		);

		$return = $this->api->apiPost($this->userInfo['token'], "exemptions/restore_exemption", $sendApi);
		if (!empty($return->status) && $return->status == 200) {
			$this->data['contract'] = $return->contract;
			$this->pushJson('200', json_encode(array("status" => "200", "msg" => 'Khôi phục đơn miễn giảm thành công!', 'data' => $this->data)));
			return;

		} else {
			$this->pushJson('200', json_encode(array("status" => "401", "msg" => $return->message)));
			return;
		}
	}

	public function contractExemptionsInfo($id)
	{
		try {
			$id = $this->security->xss_clean($id);
			$data_send_api = [
				'id' => $id
			];
			$contract_exemptions = $this->api->apiPost($this->userInfo['token'], 'exemptions/get_one', $data_send_api);
			$this->pushJson('200', json_encode(['code' => "200", 'data' => $contract_exemptions->data]));
		} catch (\Exception $exception) {
			show_404();
		}
	}

	public function viewImageExemption()
	{
		$this->data["pageName"] = $this->lang->line('view_img_authentication');
		$dataGet = $this->input->get();
		$dataGet['id'] = $this->security->xss_clean($dataGet['id']);
		$dataPost = array(
			"id" => $dataGet['id']
		);
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		$result = $this->api->apiPost($this->userInfo['token'], "exemptions/get_one", $dataPost);
		$this->data['result'] = $result->data;
		$this->data['template'] = 'page/accountant/thn/viewImageExemption';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function exportContractExemption()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$customer_phone_number = !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$condition['start'] = $fdate;
			$condition['end'] = $tdate;
		}
		$data = array();
		$data['code_contract'] = !empty($code_contract) ? $code_contract : '';
		$data['code_contract_disbursement'] = !empty($code_contract_disbursement) ? $code_contract_disbursement : '';
		$data['customer_name'] = !empty($customer_name) ? $customer_name : '';
		$data['customer_phone_number'] = !empty($customer_phone_number) ? $customer_phone_number : '';
		$data['store'] = !empty($store) ? $store : '';
		$data['status_contract'] = !empty($status_contract) ? $status_contract : '';
		$data['status'] = !empty($status) ? $status : '';

		$data['per_page'] = 10000;
		$data['condition'] = $condition;
		$contract_exemption = $this->api->apiPost($this->userInfo['token'], 'exemptions/get_all_application_exemptions',$data);
		if (!empty($contract_exemption->data)) {
			$this->exportDetailContractExemption($contract_exemption->data);

			var_dump($fdate . ' -- ' . $tdate);
		} else {
			var_dump("Không có dữ liệu để xuất excel");
		}
	}

	public function exportDetailContractExemption($contractExemption)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('C1', 'Mã hợp đồng');
		$this->sheet->setCellValue('D1', 'Tên khách hàng');
		$this->sheet->setCellValue('E1', 'SDT KH');
		$this->sheet->setCellValue('F1', 'Số tiền KH đề nghị miễn giảm');
		$this->sheet->setCellValue('G1', 'Số tiền TP đề xuất');
		$this->sheet->setCellValue('H1', 'Loại miễn giảm');
		$this->sheet->setCellValue('I1', 'Kỳ miễn giảm');
		$this->sheet->setCellValue('J1', 'Ngày làm đơn miễn giảm');
		$this->sheet->setCellValue('K1', 'Ngày xử lý');
		$this->sheet->setCellValue('L1', 'Trạng thái');
		$this->sheet->setCellValue('M1', 'Phòng giao dịch');

		$i = 2;
		foreach ($contractExemption as $contract_exem) {
			$type_exemption = '';
			if (!empty($contract_exem->status)) {
				if ($contract_exem->status == 1) {
					$type_exemption = "Thanh toán";
				} else {
					$type_exemption = "Tất toán";
				}
			}
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($contract_exem->code_contract) ? $contract_exem->code_contract : "");
			$this->sheet->setCellValue('C' . $i, !empty($contract_exem->code_contract_disbursement) ? $contract_exem->code_contract_disbursement : "");
			$this->sheet->setCellValue('D' . $i, !empty($contract_exem->customer_name) ? $contract_exem->customer_name : "");
			$this->sheet->setCellValue('E' . $i, !empty($contract_exem->customer_phone_number) ? $contract_exem->customer_phone_number : "");
			$this->sheet->setCellValue('F' . $i, !empty($contract_exem->amount_customer_suggest) ? $contract_exem->amount_customer_suggest : "");
			$this->sheet->setCellValue('G' . $i, !empty($contract_exem->amount_tp_thn_suggest) ? $contract_exem->amount_tp_thn_suggest : null);
			$this->sheet->setCellValue('H' . $i, !empty($type_exemption) ? ($type_exemption) : 0);
			$this->sheet->setCellValue('I' . $i, !empty($contract_exem->ky_tra) ? $contract_exem->ky_tra : 0);
			$this->sheet->setCellValue('J' . $i, !empty($contract_exem->created_profile_at) ? date('d/m/Y', intval($contract_exem->created_profile_at)) : "");
			$this->sheet->setCellValue('K' . $i, !empty($contract_exem->date_suggest) ? date('d/m/Y', intval($contract_exem->date_suggest)) : "");
			$this->sheet->setCellValue('L' . $i, !empty($contract_exem->status) ? exemptions_status($contract_exem->status) : "");
			$this->sheet->setCellValue('M' . $i, !empty($contract_exem->store->name) ? $contract_exem->store->name : "");
			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('ExportContractExemption' . time() . '.xlsx');
	}

	private function callLibExcel($filename)
	{
		// Redirect output to a client's web browser (Xlsx)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.
		ob_end_clean();
		$writer = IOFactory::createWriter($this->spreadsheet, 'Xlsx');
		$writer->save('php://output');
	}

	public function push_noti_api(){

		$api = $this->api->apiPost($this->userInfo['token'], 'exemptions/check_update_noti_kpi');

		if (!empty($api) && $api->status == 200){
			$this->pushJson('200', json_encode(array("code" => "200", "click_action" => $api->click_action)));
			return;
		}

	}

	public function excelExemption(){
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$data = array();
		$data['start'] = !empty($fdate) ? $fdate : "";
		$data['end'] = !empty($tdate) ? $tdate : "";
		$data['code_contract'] = !empty($code_contract) ? $code_contract : "";
		$contract_exemption = $this->api->apiPost($this->userInfo['token'], 'exemptions/exportExcelExemption',$data);
		if (!empty($contract_exemption->data)) {
			$this->exportExcelExemption($contract_exemption->data);

			var_dump($fdate . ' -- ' . $tdate);
		} else {
			var_dump("Không có dữ liệu để xuất excel");
		}
	}

	public function exportExcelExemption($data){
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('C1', 'Mã hợp đồng');
		$this->sheet->setCellValue('D1', 'Mã phiếu ghi gốc');
		$this->sheet->setCellValue('E1', 'Mã hợp đồng gốc');
		$this->sheet->setCellValue('F1', 'Tên người vay');
		$this->sheet->setCellValue('G1', 'Phòng giao dịch');
		$this->sheet->setCellValue('H1', 'Phương thức tính lãi');
		$this->sheet->setCellValue('I1', 'Ngày giải ngân');
		$this->sheet->setCellValue('J1', 'Trạng thái duyệt đơn MG');
		$this->sheet->setCellValue('K1', 'Loại miễn giảm');
		$this->sheet->setCellValue('L1', 'Trạng thái hợp đồng');
		$this->sheet->setCellValue('M1', 'Ngày đề nghị MG');
		$this->sheet->setCellValue('N1', 'Ngày KH ký đơn MG');
		$this->sheet->setCellValue('O1', 'Ngày TP QLHĐV duyệt đơn MG');
		$this->sheet->setCellValue('P1', 'Ngày tất toán trên hệ thống');
		$this->sheet->setCellValue('Q1', 'Số tiền vay');
		$this->sheet->setCellValue('R1', 'Tổng số tiền đã thu trước thời điểm xin miễn giảm');
		$this->sheet->setCellValue('S1', 'Số tiền gốc còn lại trước khi làm đơn MG');
		$this->sheet->setCellValue('T1', 'Tổng số tiền còn lại cần thu tại ngày tất toán (gốc+lãi+phí)');
		$this->sheet->setCellValue('U1', 'Số tiền KH thanh toán tại ngày tạo phiếu thu miễn giảm');
		$this->sheet->setCellValue('V1', 'Tổng số tiền tất toán cần thu');
		$this->sheet->setCellValue('W1', 'Tổng số tiền khách hàng đã thanh toán');
		$this->sheet->setCellValue('X1', 'Tổng tiền Miễn Giảm');
		$this->sheet->setCellValue('Y1', 'Miễn giảm gốc');
		$this->sheet->setCellValue('Z1', 'Miễn giảm lãi');
		$this->sheet->setCellValue('AA1', 'Miễn giảm phí');
		$this->sheet->setCellValue('AB1', 'Nhóm');
		$this->sheet->setCellValue('AC1', 'Lý do xin miễn giảm');

		$this->setStyle_exemption('A1');
		$this->setStyle_exemption('B1');
		$this->setStyle_exemption('C1');
		$this->setStyle_exemption('D1');
		$this->setStyle_exemption('E1');
		$this->setStyle_exemption('F1');
		$this->setStyle_exemption('G1');
		$this->setStyle_exemption('H1');
		$this->setStyle_exemption('I1');
		$this->setStyle_exemption('J1');
		$this->setStyle_exemption('K1');
		$this->setStyle_exemption('L1');
		$this->setStyle_exemption('M1');
		$this->setStyle_exemption('N1');
		$this->setStyle_exemption('O1');
		$this->setStyle_exemption('P1');
		$this->setStyle_exemption('Q1');
		$this->setStyle_exemption('R1');
		$this->setStyle_exemption('S1');
		$this->setStyle_exemption('T1');
		$this->setStyle_exemption('U1');
		$this->setStyle_exemption('V1');
		$this->setStyle_exemption('W1');
		$this->setStyle_exemption('X1');
		$this->setStyle_exemption('Y1');
		$this->setStyle_exemption('Z1');
		$this->setStyle_exemption('AA1');
		$this->setStyle_exemption('AB1');
		$this->setStyle_exemption('AC1');

		$i = 2;
		foreach ($data as $value) {
			$type_interest = "";
			if(!empty($value->type_interest) && $value->type_interest == 1){
				$type_interest = "Lãi hàng tháng, gốc hàng tháng";
			} else {
				$type_interest = "Lãi hàng tháng, gốc cuối kỳ";
			}

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($value->code_contract) ? $value->code_contract : "");
			$this->sheet->setCellValue('C' . $i, !empty($value->code_contract_disbursement) ? $value->code_contract_disbursement : "");
			$this->sheet->setCellValue('D' . $i, !empty($value->code_contract_origin) ? $value->code_contract_origin : "");
			$this->sheet->setCellValue('E' . $i, !empty($value->code_contract_disbursement_origin) ? $value->code_contract_disbursement_origin : "");
			$this->sheet->setCellValue('F' . $i, !empty($value->customer_name) ? $value->customer_name : "");
			$this->sheet->setCellValue('G' . $i, !empty($value->store) ? $value->store : "");
			$this->sheet->setCellValue('H' . $i, $type_interest);
			$this->sheet->setCellValue('I' . $i, !empty($value->disbursement_date) ? date('d/m/Y', $value->disbursement_date) : "");
			$this->sheet->setCellValue('J' . $i, !empty($value->status) ? exemptions_status($value->status) : "");
			$this->sheet->setCellValue('K' . $i, !empty($value->type_payment_exem) ? type_payment_exem($value->type_payment_exem) : "");
			$this->sheet->setCellValue('L' . $i, !empty($value->statusContract) ? contract_status($value->statusContract) : "");
			$this->sheet->setCellValue('M' . $i, !empty($value->date_suggest) ? date('d/m/Y', $value->date_suggest) : "");
			$this->sheet->setCellValue('N' . $i, !empty($value->start_date_effect) ? date('d/m/Y', $value->start_date_effect) : "");
			$this->sheet->setCellValue('O' . $i, !empty($value->date_tpthn_approve) ? date('d/m/Y', $value->date_tpthn_approve) : "");
			$this->sheet->setCellValue('P' . $i, !empty($value->expire_date) ? date('d/m/Y', $value->expire_date) : "");
			$this->sheet->setCellValue('Q' . $i, !empty($value->amount_money) ? $value->amount_money : "")
				->getStyle('Q' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('R' . $i, !empty($value->tong_tien_da_thu_truoc_mien_giam) ? $value->tong_tien_da_thu_truoc_mien_giam : 0)
				->getStyle('R' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('S' . $i, !empty($value->tien_goc_con_truoc_mien_giam) ? $value->tien_goc_con_truoc_mien_giam : 0)
				->getStyle('S' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('T' . $i, !empty($value->tien_con_lai_can_thu_tai_ngay_tat_toan) ? $value->tien_con_lai_can_thu_tai_ngay_tat_toan : 0)
				->getStyle('T' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('U' . $i, !empty($value->tien_khach_dong_ngay_tao_phieu_thu_mien_giam) ? $value->tien_khach_dong_ngay_tao_phieu_thu_mien_giam : 0)
				->getStyle('U' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('V' . $i, !empty($value->tien_tat_toan_can_thu_tu_khi_vay) ? $value->tien_tat_toan_can_thu_tu_khi_vay : 0)
				->getStyle('V' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('W' . $i, !empty($value->totalTran) ? $value->totalTran : 0)
				->getStyle('W' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('X' . $i, !empty($value->amount_tp_thn_suggest) ? $value->amount_tp_thn_suggest : 0)
				->getStyle('X' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('Y' . $i, !empty($value->tien_mien_giam_goc) ? $value->tien_mien_giam_goc : 0)
				->getStyle('Y' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('Z' . $i, !empty($value->tien_mien_giam_lai) ? $value->tien_mien_giam_lai : 0)
				->getStyle('Z' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AA' . $i, !empty($value->tien_mien_giam_phi) ? $value->tien_mien_giam_phi : 0)
				->getStyle('AA' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AB' . $i, !empty($value->bucket) ? $value->bucket : "B0");
			$this->sheet->setCellValue('AC' . $i, !empty($value->note_tp_thn) ? $value->note_tp_thn : "");
			$i++;
		}
		//----------------------------------------------------------------------
		$this->callLibExcel('exportExcelExemption' . time() . '.xlsx');
	}

	private function setStyle_exemption($range)
	{
		$styles = [
			'font' =>
				[
					'name' => 'Arial',
					'bold' => true,
					'italic' => false,
					'strikethrough' => false,
					'color' => ['rgb' => 'FFFFFF'],
				],
			'borders' =>
				[
					'left' =>
						[
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
							'color' => ['rgb' => '000000']
						],
					'right' =>
						[
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
							'color' => ['rgb' => '000000']
						],
					'bottom' =>
						[
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
							'color' => ['rgb' => '000000']
						],
					'top' =>
						[
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
							'color' => ['rgb' => '000000']
						]
				],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'startColor' => array('rgb' => "008000")
			],
			'quotePrefix' => true
		];
		$this->getStyle = $styles;
		$this->sheet->getStyle($range)->applyFromArray($styles)->getAlignment()->setHorizontal('center');
	}

	//lấy hết hợp đồng đã được duyệt giảm(black list)
	public function getContractExempted() 
    {	
		$this->data["pageName"] = "Danh sách hợp đồng đã được duyệt miễn giảm";
		$store_code = !empty($_GET['store']) ? $_GET['store'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "17";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$customer_phone_number = !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$customer_identify = !empty($_GET['customer_identify']) ? $_GET['customer_identify'] : "";
		if (strtotime($start) > strtotime($end) && !empty(strtotime($end))) {
			$this->session->set_flashdata('error', $this->lang->line('Error_date'));
			redirect(base_url('exemptions/getContractExempted'));
		}
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$condition['start'] = strtotime($start);
			$condition['end'] = strtotime($end);
		} else if (!empty($_GET['fdate'])) {
			$condition['start'] = strtotime($start);
		} else if (!empty($_GET['tdate'])) {
			$condition['end'] = strtotime($end);
		}
		// var_dump($condition); die;
		if (!empty($store_code)) {
			$condition['store_id'] = trim($store_code);
		}
		if (!empty($code_contract)) {
			$condition['code_contract'] = trim($code_contract);
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
		if (!empty($customer_identify)) {
			$condition['customer_identify'] = trim($customer_identify);
		}
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('exemptions/getContractExempted?code_contract_disbursement=' . $code_contract_disbursement . '&fdate=' . $start . '&tdate=' . $end . '&customer_name=' . $customer_name . '&customer_phone_number' . $customer_phone_number . '&store=' . $store_code . '&code_contract=' . $code_contract . '&status=' . $status . '&$customer_identify=' . $customer_identify);
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 30;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		// call api get contract data
		$data = array(
			"condition" => $condition,
			"per_page" => $config['per_page'],
			"uriSegment" => $config['uri_segment']
		);

		$result = $this->api->apiPost($this->userInfo['token'], "exemptions/getAllContractExempted", $data);
		$config['total_rows'] = $result->total;
		$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all");
		if (!empty($storeData->status) && $storeData->status == 200) {
			$this->data['storeData'] = $storeData->data;
		} else {
			$this->data['storeData'] = array();
		}
		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		$this->data['user_id_login'] = $this->userInfo['id'];
		$this->pagination->initialize($config);
		$this->data['dataResult'] = $result->data;
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['result_count'] = $config['total_rows'];
		$this->data['template'] = 'page/blacklist/blacklist_thn.php';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	//view chi tiết ảnh miễn giảm
	public function viewImageExempted()
	{
		$this->data["pageName"] = $this->lang->line('view_img_authentication');
		$dataGet = $this->input->get();
		$dataGet['id'] = $this->security->xss_clean($dataGet['id']);
		$dataPost = array(
			"id" => $dataGet['id']
		);
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		$result = $this->api->apiPost($this->userInfo['token'], "exemptions/get_one", $dataPost);
		$this->data['result'] = $result->data;
		$this->data['template'] = 'page/blacklist/viewImageExempted';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	//xuất excel hợp đồng đã được duyệt giảm
	public function exportContractExempted()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$customer_phone_number = !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$customer_identify = !empty($_GET['customer_identify']) ? $_GET['customer_identify'] : "";

		$data = array();
		if (strtotime($start) > strtotime($end) && !empty(strtotime($end))) {
			$this->session->set_flashdata('error', $this->lang->line('Error_date'));
			redirect(base_url('exemptions/getContractExempted'));
		}
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$data['start'] = strtotime($start);
			$data['end'] = strtotime($end);
		} else if (!empty($_GET['fdate'])) {
			$data['start'] = strtotime($start);
		} else if (!empty($_GET['tdate'])) {
			$data['end'] = strtotime($end);
		}
		$data['code_contract'] = !empty($code_contract) ? $code_contract : '';
		$data['code_contract_disbursement'] = !empty($code_contract_disbursement) ? $code_contract_disbursement : '';
		$data['customer_name'] = !empty($customer_name) ? $customer_name : '';
		$data['customer_phone_number'] = !empty($customer_phone_number) ? $customer_phone_number : '';
		$data['store_id'] = !empty($store) ? $store : '';
		$data['status_contract'] = !empty($status_contract) ? $status_contract : '';
		$data['status'] = !empty($status) ? $status : '';
		$data['customer_identify'] = !empty($customer_identify) ? $customer_identify : '';

		$data['per_page'] = 10000;
		$contractExempted = $this->api->apiPost($this->userInfo['token'], 'exemptions/getAllContractExempted',$data);
		if (!empty($contractExempted->data)) {
			$this->exportDetailContractExempted($contractExempted->data);

			var_dump($fdate . ' -- ' . $tdate);
		} else {
			var_dump("Không có dữ liệu để xuất excel");
		}
	}
	// xuất hợp đồng đc duyệt miễn giảm
	public function exportDetailContractExempted($contractExempted)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('C1', 'Mã hợp đồng');
		$this->sheet->setCellValue('D1', 'Tên khách hàng');
		$this->sheet->setCellValue('E1', 'SĐT');
		$this->sheet->setCellValue('F1', 'CMND/CCCD');
		$this->sheet->setCellValue('G1', 'Loại miễn giảm');
		$this->sheet->setCellValue('H1', 'Ngày xử lý');
		$this->sheet->setCellValue('I1', 'Trạng thái');
		$this->sheet->setCellValue('J1', 'Phòng giao dịch');

		$this->setStyle_exemption('A1');
		$this->setStyle_exemption('B1');
		$this->setStyle_exemption('C1');
		$this->setStyle_exemption('D1');
		$this->setStyle_exemption('E1');
		$this->setStyle_exemption('F1');
		$this->setStyle_exemption('G1');
		$this->setStyle_exemption('H1');
		$this->setStyle_exemption('I1');
		$this->setStyle_exemption('J1');
		$i = 2;
		foreach ($contractExempted as $contract) {
			$type_exemption = '';
			if (!empty($contract->status)) {
				if ($contract->status == 1) {
					$type_exemption = "Thanh toán";
				} else {
					$type_exemption = "Tất toán";
				}
			}
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($contract->code_contract) ? $contract->code_contract : "");
			$this->sheet->setCellValue('C' . $i, !empty($contract->code_contract_disbursement) ? $contract->code_contract_disbursement : "");
			$this->sheet->setCellValue('D' . $i, !empty($contract->customer_name) ? $contract->customer_name : "");
			$this->sheet->setCellValue('E' . $i, !empty($contract->customer_phone_number) ? $contract->customer_phone_number : "");
			$this->sheet->setCellValue('F' . $i, !empty($contract->customer_identify) ? $contract->customer_identify : "");
			$this->sheet->setCellValue('G' . $i, !empty($type_exemption) ? ($type_exemption) : 0);
			$this->sheet->setCellValue('H' . $i, !empty($contract->date_suggest) ? date('d/m/Y', intval($contract->date_suggest)) : "");
			$this->sheet->setCellValue('I' . $i, !empty($contract->status) ? exemptions_status($contract->status) : "");
			$this->sheet->setCellValue('J' . $i, !empty($contract->store->name) ? $contract->store->name : "");
			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('ExportContractExemption' . time() . '.xlsx');
	}

	//xuất đơn miễn giảm của hđ đc duyệt miễn giảm
	public function excelExempted(){
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$customer_identify = !empty($_GET['customer_identify']) ? $_GET['customer_identify'] : "";
		$customer_phone_number = !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$data = array();
		if (strtotime($start) > strtotime($end) && !empty(strtotime($end))) {
			$this->session->set_flashdata('error', $this->lang->line('Error_date'));
			redirect(base_url('exemptions/getContractExempted'));
		}
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$data['start'] = strtotime($start);
			$data['end'] = strtotime($end);
		} else if (!empty($_GET['fdate'])) {
			$data['start'] = strtotime($start);
		} else if (!empty($_GET['tdate'])) {
			$data['end'] = strtotime($end);
		}
		$data['customer_name'] = !empty($customer_name) ? $customer_name : "";
		$data['customer_identify'] = !empty($customer_identify) ? $customer_identify : "";
		$data['customer_phone_number'] = !empty($customer_phone_number) ? $customer_phone_number : "";
		$data['code_contract'] = !empty($code_contract) ? $code_contract : "";
		$data['code_contract_disbursement'] = !empty($code_contract_disbursement) ? $code_contract_disbursement : "";
		$data['store_id'] = !empty($store) ? $store : "";

		$contract_exemption = $this->api->apiPost($this->userInfo['token'], 'exemptions/exportExcelExempted',$data);
		if (!empty($contract_exemption->data)) {
			$this->exportExcelExempted($contract_exemption->data);

			var_dump($fdate . ' -- ' . $tdate);
		} else {
			var_dump("Không có dữ liệu để xuất excel");
		}

	}

	//xuất đơn miễn giảm của hđ đc duyệt miễn giảm
	public function exportExcelExempted($data){

		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('C1', 'Mã hợp đồng');
		$this->sheet->setCellValue('D1', 'Tên người vay');
		$this->sheet->setCellValue('E1', 'Phương thức tính lãi');
		$this->sheet->setCellValue('F1', 'Ngày giải ngân');
		$this->sheet->setCellValue('G1', 'Trạng thái duyệt đơn MG');
		$this->sheet->setCellValue('H1', 'Trạng thái hợp đồng');
		$this->sheet->setCellValue('I1', 'Ngày tất toán trên hệ thống');
		$this->sheet->setCellValue('J1', 'Số tiền vay');
		$this->sheet->setCellValue('K1', 'Tổng số tiền đã thu trước thời điểm tất toán');
		$this->sheet->setCellValue('L1', 'Số tiền gốc còn');
		$this->sheet->setCellValue('M1', 'Tổng cần thu tại ngày tất toán (gốc+lãi+phí)');
		$this->sheet->setCellValue('N1', 'Số tiền KH thanh toán tại ngày tất toán');
		$this->sheet->setCellValue('O1', 'Tổng tiền Miễn Giảm');
		$this->sheet->setCellValue('P1', 'Nhóm');
		$this->sheet->setCellValue('Q1', 'Lý do xin miễn giảm');
		$this->sheet->setCellValue('R1', 'Phòng giao dịch');

		$this->setStyle_exemption('A1');
		$this->setStyle_exemption('B1');
		$this->setStyle_exemption('C1');
		$this->setStyle_exemption('D1');
		$this->setStyle_exemption('E1');
		$this->setStyle_exemption('F1');
		$this->setStyle_exemption('G1');
		$this->setStyle_exemption('H1');
		$this->setStyle_exemption('I1');
		$this->setStyle_exemption('J1');
		$this->setStyle_exemption('K1');
		$this->setStyle_exemption('L1');
		$this->setStyle_exemption('M1');
		$this->setStyle_exemption('N1');
		$this->setStyle_exemption('O1');
		$this->setStyle_exemption('P1');
		$this->setStyle_exemption('Q1');
		$this->setStyle_exemption('R1');

		$i = 2;
		foreach ($data as $value) {

			$type_interest = "";
			if(!empty($value->type_interest) && $value->type_interest == 1){
				$type_interest = "Lãi hàng tháng, gốc hàng tháng";
			} else {
				$type_interest = "Lãi hàng tháng, gốc cuối kỳ";
			}

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($value->code_contract) ? $value->code_contract : "");
			$this->sheet->setCellValue('C' . $i, !empty($value->code_contract_disbursement) ? $value->code_contract_disbursement : "");
			$this->sheet->setCellValue('D' . $i, !empty($value->customer_name) ? $value->customer_name : "");
			$this->sheet->setCellValue('E' . $i, $type_interest);
			$this->sheet->setCellValue('F' . $i, !empty($value->disbursement_date) ? date('d/m/Y', $value->disbursement_date) : "");
			$this->sheet->setCellValue('G' . $i, !empty($value->status) ? exemptions_status($value->status) : "");
			$this->sheet->setCellValue('H' . $i, !empty($value->statusContract) ? contract_status($value->statusContract) : "");
			$this->sheet->setCellValue('I' . $i, !empty($value->expire_date) ? date('d/m/Y', $value->expire_date) : "");
			$this->sheet->setCellValue('J' . $i, !empty($value->amount_money) ? $value->amount_money : "")
				->getStyle('J' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('K' . $i, !empty($value->totalTran) ? $value->totalTran : 0)
				->getStyle('K' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('L' . $i, !empty($value->tong_tien_goc_con) ? $value->tong_tien_goc_con : 0)
				->getStyle('L' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('O' . $i, !empty($value->amount_tp_thn_suggest) ? $value->amount_tp_thn_suggest : 0)
				->getStyle('O' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('M' . $i, !empty($value->total_tong_can_thu) ? $value->total_tong_can_thu : 0)
				->getStyle('M' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('N' . $i, !empty($value->total_thanh_toan_tat_toan) ? $value->total_thanh_toan_tat_toan : 0)
				->getStyle('N' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('P' . $i, (!empty($value->bucket) && $value->bucket != 0) ? get_bucket($value->bucket) : "B0");
			$this->sheet->setCellValue('Q' . $i, !empty($value->note_tp_thn) ? $value->note_tp_thn : "");
			$this->sheet->setCellValue('R' . $i, !empty($value->store) ? $value->store : "");
			$i++;
		}
		//---------------------------------------------------------------------

		$this->callLibExcel('exportExcelExemption' . time() . '.xlsx');

	}

	// In BBBG Hồ sơ miễn giảm
	public function printed_profile_exemption()
	{
		$code_ref = $this->uri->segment(3);
		if (empty($code_ref)) {
			$this->session->set_flashdata('error', $this->lang->line('Does_not_exist_transaction'));
			redirect(base_url('Exemptions/profile_exemption?tab=profile_origin'));
			return;
		}
		$code_ref = $this->security->xss_clean($code_ref);
		$dataSend['code_ref'] = $code_ref;
		$response = $this->api->apiPost($this->userInfo['token'], 'Exemptions/get_detail_profile', $dataSend);
		if (isset($response->status) && $response->status == 200) {
			$this->data['profiles'] = $response->data;
			$this->data['profile'] = $response->profile;
		} else {
			$this->data['profiles'] = array();
			$this->data['profile'] = array();
		}
		$this->load->view('contract_printed/BBBG_thechap/bbbg_exemption_profile', isset($this->data) ? $this->data : NULL);
		return;
	}

	//Danh sách đơn miễn giảm và hồ sơ miễn giảm
	public function profile_exemption()
	{
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "all";
		if (in_array($tab, ['all', 'normal', 'exception'])) {
			$this->data['pageName'] = 'Danh sách đơn miễn giảm';
		} elseif (in_array($tab, ['profile_normal', 'profile_exception', 'profile_asset'])) {
			$this->data['pageName'] = 'Danh sách hồ sơ miễn giảm';
		}
		$from_date = !empty($_GET['from_date']) ? $_GET['from_date'] : "";
		$to_date = !empty($_GET['to_date']) ? $_GET['to_date'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$type_send = !empty($_GET['type_send']) ? $_GET['type_send'] : "";
		$postal_code = !empty($_GET['postal_code']) ? $_GET['postal_code'] : "";
		$bbbg_code = !empty($_GET['bbbg_code']) ? $_GET['bbbg_code'] : "";
		$domain_exemption = !empty($_GET['domain_exemption']) ? $_GET['domain_exemption'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		if (strtotime($from_date) > strtotime($to_date)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('Exemptions/profile_exemption?tab=exemption'));
		}
		if (!empty($_GET['from_date']) && !empty($_GET['to_date'])) {
			$dataSend['from_date'] = $from_date;
			$dataSend['to_date'] = $to_date;
		}
		$dataSend['tab'] = $tab;
		$dataSend['store'] = $store;
		$dataSend['status'] = $status;
		$dataSend['type_send'] = $type_send;
		$dataSend['postal_code'] = $postal_code;
		$dataSend['bbbg_code'] = $bbbg_code;
		$dataSend['domain_exemption'] = $domain_exemption;
		$dataSend['customer_name'] = $customer_name;
		$dataSend['code_contract'] = $code_contract;
		$dataSend['code_contract_disbursement'] = $code_contract_disbursement;
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('Exemptions/profile_exemption?tab='
			. $tab
			. '&code_contract_disbursement=' . $code_contract_disbursement
			. '&from_date=' . $from_date
			. '&to_date=' . $to_date
			. '&customer_name=' . $customer_name
			. '&customer_phone_number' . $customer_phone_number
			. '&store=' . $store
			. '&code_contract=' . $code_contract
			. '&status=' . $status
			. '&type_send=' . $type_send
			. '&postal_code=' . $postal_code
			. '&bbbg_code=' . $bbbg_code
			. '&domain_exemption=' . $domain_exemption);
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 30;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$dataSend['per_page'] = $config['per_page'];
		$dataSend['uriSegment'] = $config['uri_segment'];
		//Call API get lish exemptions
		$response = $this->api->apiPost($this->userInfo['token'], 'Exemptions/get_exemptions_by_status_profile', $dataSend);
		if (isset($response->status) && $response->status == 200) {
			$this->data['exemptions'] = $response->data;
			$this->data['profiles'] = $response->profiles;
			$config['total_rows'] = $response->total;
		} else {
			$this->data['exemptions'] = array();
			$this->data['profiles'] = array();
		}
		//get is role Ke toan
		$kt_ids = $this->api->apiPost($this->userInfo['token'],'Exemptions/get_id_finance', []);
		if (isset($kt_ids->status) && $kt_ids->status == 200) {
			$this->data['kt_role'] = $kt_ids->data;
		} else {
			$this->data['kt_role'] = 0;
		}
		//get is role Thu hoi no
		$thn_ids = $this->api->apiPost($this->userInfo['token'],'Exemptions/get_id_thn_department', []);
		if (isset($thn_ids->status) && $thn_ids->status == 200) {
			$this->data['thn_role'] = $thn_ids->data;
		} else {
			$this->data['thn_role'] = 0;
		}
		//get is QLHĐV mb
		$is_thn_mb = $this->api->apiPost($this->userInfo['token'],'Exemptions/is_thn_mb', []);
		if (isset($is_thn_mb->status) && $is_thn_mb->status == 200) {
			$this->data['is_thn_mb'] = $is_thn_mb->data;
		} else {
			$this->data['is_thn_mb'] = 0;
		}
		//get is QLHĐV mn
		$is_thn_mn = $this->api->apiPost($this->userInfo['token'],'Exemptions/is_thn_mn', []);
		if (isset($is_thn_mn->status) && $is_thn_mn->status == 200) {
			$this->data['is_thn_mn'] = $is_thn_mn->data;
		} else {
			$this->data['is_thn_mn'] = 0;
		}
		//get all store
		$stores = $this->api->apiPost($this->userInfo['token'], 'Store/get_all_store', []);
		if (isset($stores->status) && $stores->status == 200) {
			$this->data['stores'] = $stores->data;
		} else {
			$this->data['stores'] = array();
		}
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['result_count'] = $config['total_rows'];
		$this->data['template'] = 'page/exemptions/exemption_list.php';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;
	}

	//Cập nhật tình trạng ĐMG có xác nhận qua email hay ko
	public function update_profile_exemption()
	{
		$data = $this->input->post();
		$id_exemption = !empty($this->security->xss_clean($data['exemption_id'])) ? $this->security->xss_clean($data['exemption_id']) : '';
		$option = !empty($this->security->xss_clean($data['option'])) ? $this->security->xss_clean($data['option']) : '';
		$dataSend = [
			'id_exemption' => $id_exemption,
			'option' => $option
		];
		$result = $this->api->apiPost($this->userInfo['token'], 'Exemptions/update_profile_exemption', $dataSend);
		if (isset($result->status) && $result->status == 200) {
			$response = [
				'status' => '200',
				'msg' => $result->message
			];
			$this->pushJson('200', json_encode($response));
			return;
		} else {
			$response = [
				'status' => '400',
				'msg' => 'Cật nhật thất bại!'
			];
			$this->pushJson('200', json_encode($response));
			return;
		}
	}

	//Tạo hồ sơ miễn giảm
	public function create_profile_exemption()
	{
		$data = $this->input->post();
		$profile = !empty($this->security->xss_clean($data['profile'])) ? $this->security->xss_clean($data['profile']) : array();
		$profile_old_id = !empty($this->security->xss_clean($data['profile_old_id'])) ? $this->security->xss_clean($data['profile_old_id']) : '';
		$dataSend = array();
		$dataSend = [
			'profile' => $profile,
			'profile_old_id' => $profile_old_id
		];
		$result = $this->api->apiPost($this->userInfo['token'], 'Exemptions/create_profile_exemption', $dataSend);
		if (isset($result->status) && $result->status == 200) {
			$response = [
				'status' => '200',
				'msg' => $result->message,
				'redirect' => $result->data
			];
			$this->pushJson('200', json_encode($response));
			return;
		} else {
			$response = [
				'status' => '400',
				'msg' => $result->message
			];
			$this->pushJson('200', json_encode($response));
			return;
		}
	}

	//Chi tiết hồ sơ miễn giảm
	public function detail_profile()
	{
		$data = $this->input->get();
		$code_ref = !empty($data['code']) ? $data['code'] : '';
		$this->data['pageName'] = 'Chi tiết HSMG - ' . $code_ref;

		$dataSend['code_ref'] = $code_ref;
		$response = $this->api->apiPost($this->userInfo['token'], 'Exemptions/get_detail_profile', $dataSend);
		if (isset($response->status) && $response->status == 200) {
			$this->data['profiles'] = $response->data;
			$this->data['profile'] = $response->profile;
		} else {
			$this->data['profiles'] = array();
			$this->data['profile'] = '';
		}
		$kt_ids = $this->api->apiPost($this->userInfo['token'],'Exemptions/get_id_finance', []);
		if (isset($kt_ids->status) && $kt_ids->status == 200) {
			$this->data['kt_ids'] = $kt_ids->data;
		} else {
			$this->data['kt_ids'] = 0;
		}
		$thn_ids = $this->api->apiPost($this->userInfo['token'],'Exemptions/get_id_thn_department', []);
		if (isset($thn_ids->status) && $thn_ids->status == 200) {
			$this->data['thn_ids'] = $thn_ids->data;
		} else {
			$this->data['thn_ids'] = 0;
		}
		$this->data['template'] = 'page/exemptions/list_detail_profile_exemption.php';
		return $this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	// View Upload ảnh cho hồ sơ miễn giảm
	public function upload_img()
	{
		$this->data['pageName'] = 'Upload ảnh HSMG và mã bưu phẩm';
		$dataGet = $this->input->get();
		$code_ref = !empty($dataGet['code']) ? $dataGet['code'] : '';
		$dataSend['code_ref'] = $code_ref;
		$response = $this->api->apiPost($this->userInfo['token'], 'Exemptions/get_detail_profile', $dataSend);
		if (isset($response->status) && $response->status == 200) {
			$this->data['profiles'] = $response->data;
			$this->data['profile'] = $response->profile;
		} else {
			$this->data['profiles'] = array();
			$this->data['profile'] = '';
		}
		$this->data['template'] = 'page/exemptions/upload_img.php';
		return $this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	// Gửi hồ sơ miễn giảm
	public function send_profile()
	{
		$dataPost = $this->input->post();
		$code_ref = !empty($this->security->xss_clean($dataPost['code_ref'])) ? $this->security->xss_clean($dataPost['code_ref']) : '';
		$postal_code = !empty($this->security->xss_clean($dataPost['postal_code'])) ? $this->security->xss_clean($dataPost['postal_code']) : '';
		$type_send = !empty($this->security->xss_clean($dataPost['type_send'])) ? $this->security->xss_clean($dataPost['type_send']) : '';
		$type_exception = !empty($this->security->xss_clean($dataPost['type_exception'])) ? $this->security->xss_clean($dataPost['type_exception']) : '';
		$img_profile = !empty($this->security->xss_clean($dataPost['img_profile'])) ? $this->security->xss_clean($dataPost['img_profile']) : '';
		$dataSend = [
			'code_ref' => $code_ref,
			'postal_code' => $postal_code,
			'type_send' => $type_send,
			'type_exception' => $type_exception,
			'img_profile' => $img_profile
		];
		$result = $this->api->apiPost($this->userInfo['token'], 'Exemptions/send_profile', $dataSend);
		if (isset($result->status) && $result->status == 200) {
			$response = [
				'status' => '200',
				'msg' => $result->message,
				'redirect' => $result->data
			];
			return $this->pushJson('200', json_encode($response));
		} else {
			$response = [
				'status' => '400',
				'msg' => $result->message
			];
			return $this->pushJson('200', json_encode($response));
		}
	}

	//Xem chi tiết ảnh HSMG
	public function view_img()
	{
		$dataGet = $this->input->get();
		$code_ref = !empty($dataGet['code']) ? $dataGet['code'] : '';
		$this->data['pageName'] = 'Ảnh hồ sơ miễn giảm - ' . $code_ref;
		$dataSend['code_ref'] = $code_ref;
		$response = $this->api->apiPost($this->userInfo['token'], 'Exemptions/get_detail_profile', $dataSend);
		if (isset($response->status) && $response->status == 200) {
			$this->data['profiles'] = $response->data;
			$this->data['profile'] = $response->profile;
		} else {
			$this->data['profiles'] = array();
			$this->data['profile'] = '';
		}
		$this->data['template'] = 'page/exemptions/view_img_profile.php';
		return $this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function complete_profile()
	{
		$dataPost = $this->input->post();
		$profile_note = !empty($this->security->xss_clean($dataPost['profile_note'])) ? $this->security->xss_clean($dataPost['profile_note']) : '';
		$status = !empty($this->security->xss_clean($dataPost['status'])) ? $this->security->xss_clean($dataPost['status']) : '';
		$type_status = !empty($this->security->xss_clean($dataPost['type_status'])) ? $this->security->xss_clean($dataPost['type_status']) : '';
		$profile = !empty($this->security->xss_clean($dataPost['profile'])) ? $this->security->xss_clean($dataPost['profile']) : array();
		$profile_old_id = !empty($this->security->xss_clean($dataPost['profile_old_id'])) ? $this->security->xss_clean($dataPost['profile_old_id']) : '';
		$dataSend = array();
		$dataSend = [
			'profile_note' => $profile_note,
			'status' => $status,
			'profile' => $profile,
			'profile_old_id' => $profile_old_id,
			'type_status' => $type_status
		];
		$result = $this->api->apiPost($this->userInfo['token'], 'Exemptions/complete_profile', $dataSend);
		if (isset($result->status) && $result->status == 200) {
			$response = [
				'status' => '200',
				'msg' => $result->message,
			];
			return $this->pushJson('200', json_encode($response));
		} else {
			$response = [
				'status' => '400',
				'msg' => $result->message
			];
			return $this->pushJson('200', json_encode($response));
		}
	}

	public function update_exemption_spa()
	{
		$dataPost = $this->input->post();
		$profile_note = !empty($this->security->xss_clean($dataPost['profile_note'])) ? $this->security->xss_clean($dataPost['profile_note']) : '';
		$exemption_id = !empty($this->security->xss_clean($dataPost['exemption_id'])) ? $this->security->xss_clean($dataPost['exemption_id']) : '';
		$exemption_status = !empty($this->security->xss_clean($dataPost['exemption_status'])) ? $this->security->xss_clean($dataPost['exemption_status']) : '';
		$profile_status = !empty($this->security->xss_clean($dataPost['profile_status'])) ? $this->security->xss_clean($dataPost['profile_status']) : '';
		$profile_code_ref = !empty($this->security->xss_clean($dataPost['profile_code_ref'])) ? $this->security->xss_clean($dataPost['profile_code_ref']) : '';
		$dataSend = [
			'profile_note' => $profile_note,
			'exemption_id' => $exemption_id,
			'exemption_status' => $exemption_status,
			'profile_status' => $profile_status,
			'profile_code_ref' => $profile_code_ref
		];
		$result = $this->api->apiPost($this->userInfo['token'], 'Exemptions/update_exemption_spa', $dataSend);
		if (isset($result->status) && $result->status == 200) {
			$response = [
				'status' => '200',
				'msg' => $result->message
			];
			return $this->pushJson('200', json_encode($response));
		} else {
			$response = [
				'status' => '400',
				'msg' => 'Cập nhật thất bại!'
			];
			return $this->pushJson('200', json_encode($response));
		}

	}

	public function save_profile()
	{
		$dataPost = $this->input->post();
		$status = !empty($this->security->xss_clean($dataPost['status'])) ? $this->security->xss_clean($dataPost['status']) : '';
		$exemption_id = !empty($this->security->xss_clean($dataPost['exemption_id'])) ? $this->security->xss_clean($dataPost['exemption_id']) : '';
		$profile_status = !empty($this->security->xss_clean($dataPost['profile_status'])) ? $this->security->xss_clean($dataPost['profile_status']) : '';
		$code_ref = !empty($this->security->xss_clean($dataPost['code_ref'])) ? $this->security->xss_clean($dataPost['code_ref']) : '';
		$dataSend = [
			'status' => $status,
			'exemption_id' => $exemption_id,
			'profile_status' => $profile_status,
			'code_ref' => $code_ref,
		];
		$response = $this->api->apiPost($this->userInfo['token'], 'Exemptions/save_profile', $dataSend);
		if (isset($response->status) && $response->status == 200) {
			$response_js = [
				'status' => '200',
				'msg' => $response->message,
			];
			return $this->pushJson('200', json_encode($response_js));
		} else {
			$response_js = [
				'status' => '400',
				'msg' => $response->message,
			];
			return $this->pushJson('200', json_encode($response_js));
		}
	}

	public function sync_profile()
	{
		$dataPost = $this->input->post();
		$code_ref = !empty($this->security->xss_clean($dataPost['code_ref'])) ? $this->security->xss_clean($dataPost['code_ref']) : '';
		$dataSend = [
			'code_ref' => $code_ref
		];
		$response = $this->api->apiPost($this->userInfo['token'], 'Exemptions/sync_profile', $dataSend);
		if (isset($response->status) && $response->status == 200) {
			$response_js = [
				'status' => '200',
				'msg' => $response->message
			];
			return $this->pushJson('200', json_encode($response_js));
		} else {
			$response_js = [
				'status' => '400',
				'msg' => $response->message
			];
			return $this->pushJson('200', json_encode($response_js));
		}
	}

	public function close_profile()
	{
		$dataPost = $this->input->post();
		$code_ref = !empty($this->security->xss_clean($dataPost['code_ref'])) ? $this->security->xss_clean($dataPost['code_ref']) : '';
		$dataSend = [
			'code_ref' => $code_ref
		];
		$response = $this->api->apiPost($this->userInfo['token'], 'Exemptions/close_profile', $dataSend);
		if (isset($response->status) && $response->status == 200) {
			$response_js = [
				'status' => '200',
				'msg' => $response->message
			];
			return $this->pushJson('200', json_encode($response_js));
		} else {
			$response_js = [
				'status' => '400',
				'msg' => $response->message
			];
			return $this->pushJson('200', json_encode($response_js));
		}
	}

	public function change_email_confirm()
	{
		$dataPost = $this->input->post();
		$bbbgx = !empty($this->security->xss_clean($dataPost['bbbgx'])) ? $this->security->xss_clean($dataPost['bbbgx']) : '';
		$confirm_email = !empty($this->security->xss_clean($dataPost['confirm_email'])) ? $this->security->xss_clean($dataPost['confirm_email']) : '';
		$is_exemption_paper = !empty($this->security->xss_clean($dataPost['is_exemption_paper'])) ? $this->security->xss_clean($dataPost['is_exemption_paper']) : '';
		$type_change = !empty($this->security->xss_clean($dataPost['type_change'])) ? $this->security->xss_clean($dataPost['type_change']) : '';
		$exemption_id = !empty($this->security->xss_clean($dataPost['exemption_id'])) ? $this->security->xss_clean($dataPost['exemption_id']) : '';
		$dataSend = [
			'bbbgx' => $bbbgx,
			'confirm_email' => $confirm_email,
			'exemption_id' => $exemption_id,
			'is_exemption_paper' => $is_exemption_paper,
			'type_change' => $type_change
		];
		$result = $this->api->apiPost($this->userInfo['token'], 'Exemptions/change_email_confirm', $dataSend);
		if (isset($result->status) && $result->status == 200) {
			$response = [
				'status' => '200',
				'msg' => $result->message
			];
			return $this->pushJson('200', json_encode($response));
		} else {
			$response = [
				'status' => '400',
				'msg' => $result->message
			];
			return $this->pushJson('200', json_encode($response));
		}
	}

	public function complete_profile_exemptions()
	{
		$dataPost = $this->input->post();
		$code_ref = !empty($this->security->xss_clean($dataPost['code_ref'])) ? $this->security->xss_clean($dataPost['code_ref']) : '';
		$status = !empty($this->security->xss_clean($dataPost['status'])) ? $this->security->xss_clean($dataPost['status']) : '';
		$note = !empty($this->security->xss_clean($dataPost['note'])) ? $this->security->xss_clean($dataPost['note']) : '';
		$dataSend = [
			'code_ref' => $code_ref,
			'status' => $status,
			'note' => $note
		];
		$result = $this->api->apiPost($this->userInfo['token'], 'Exemptions/complete_profile_exemptions', $dataSend);
		if (isset($result->status) && $result->status == 200) {
			$response = [
				'status' => '200',
				'msg' => $result->message
			];
			return $this->pushJson('200', json_encode($response));
		} else {
			$response = [
				'status' => '400',
				'msg' => 'Cập nhật thất bại!'
			];
			return $this->pushJson('200', json_encode($response));
		}
	}

	public function exportProfileExemptions()
	{
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "exemption";
		$from_date = !empty($_GET['from_date']) ? $_GET['from_date'] : "";
		$to_date = !empty($_GET['to_date']) ? $_GET['to_date'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$type_send = !empty($_GET['type_send']) ? $_GET['type_send'] : "";
		$domain_exemption = !empty($_GET['domain_exemption']) ? $_GET['domain_exemption'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$dataSend = array();
		if (strtotime($from_date) > strtotime($to_date) && !empty(strtotime($to_date))) {
			$this->session->set_flashdata('error', $this->lang->line('Error_date'));
			redirect(base_url('Exemptions/profile_exemption?tab=' . $tab));
		}
		if (!empty($_GET['from_date']) && !empty($_GET['to_date'])) {
			$dataSend['from_date'] = $from_date;
			$dataSend['to_date'] = $to_date;
		}
		$dataSend['tab'] = $tab;
		$dataSend['store'] = $store;
		$dataSend['status'] = $status;
		$dataSend['type_send'] = $type_send;
		$dataSend['domain_exemption'] = $domain_exemption;
		$dataSend['customer_name'] = $customer_name;
		$dataSend['code_contract'] = $code_contract;
		$dataSend['code_contract_disbursement'] = $code_contract_disbursement;
		$dataSend['per_page'] = 10000;
		$profileExemptions = $this->api->apiPost($this->userInfo['token'], 'Exemptions/get_exemptions_by_status_profile', $dataSend);
		if (!empty($profileExemptions->data)) {
			$this->exportListExemptions($profileExemptions->data);
			var_dump($from_date . ' -- ' . $to_date);
		} elseif (!empty($profileExemptions->profiles)) {
			$this->exportListProfileExemptions($profileExemptions->profiles);
			var_dump($from_date . ' -- ' . $to_date);
		} else {
			var_dump("Không có dữ liệu để xuất excel");
		}
	}

	public function exportListExemptions($profileExemptions)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('C1', 'Mã hợp đồng');
		$this->sheet->setCellValue('D1', 'Tên khách hàng');
		$this->sheet->setCellValue('E1', 'Loại miễn giảm');
		$this->sheet->setCellValue('F1', 'Kỳ trả');
		$this->sheet->setCellValue('G1', 'Số tiền miễn giảm');
		$this->sheet->setCellValue('H1', 'Loại đơn gửi');
		$this->sheet->setCellValue('I1', 'Miền');
		$this->sheet->setCellValue('J1', 'Phòng giao dịch');
		$this->sheet->setCellValue('K1', 'Ngày duyệt');
		$this->sheet->setCellValue('L1', 'Trạng thái');
		$this->sheet->setCellValue('M1', 'Người tạo đơn');
		$this->sheet->setCellValue('N1', 'Mã hồ sơ');
		$this->sheet->setCellValue('O1', 'Tên BBBG');
		$this->sheet->setCellValue('P1', 'Email CEO confirm');
		$this->sheet->setCellValue('Q1', 'Đơn miễn giảm (bản giấy)');
		$this->sheet->setCellValue('R1', 'BBBG HSMG');
		$this->sheet->setCellValue('S1', 'Đơn miễn giảm');

		$this->setStyle_exemption('A1');
		$this->setStyle_exemption('B1');
		$this->setStyle_exemption('C1');
		$this->setStyle_exemption('D1');
		$this->setStyle_exemption('E1');
		$this->setStyle_exemption('F1');
		$this->setStyle_exemption('G1');
		$this->setStyle_exemption('H1');
		$this->setStyle_exemption('I1');
		$this->setStyle_exemption('J1');
		$this->setStyle_exemption('K1');
		$this->setStyle_exemption('L1');
		$this->setStyle_exemption('M1');
		$this->setStyle_exemption('N1');
		$this->setStyle_exemption('O1');
		$this->setStyle_exemption('P1');
		$this->setStyle_exemption('Q1');
		$this->setStyle_exemption('R1');
		$this->setStyle_exemption('S1');
		$i = 2;
		foreach ($profileExemptions as $profile) {
			$type_exemption = '';
			if (!empty($profile->type_payment_exem)) {
				if ($profile->type_payment_exem == 1) {
					$type_exemption = "Thanh toán";
				} else if ($profile->type_payment_exem == 2) {
					$type_exemption = "Tất toán";
				} else {
					$type_exemption = "Tất toán";
				}
			}
			$amount_exemption = !empty($profile->amount_tp_thn_suggest) ? $profile->amount_tp_thn_suggest : (!empty($profile->amount_exemptions) ? $profile->amount_exemptions : 0);
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($profile->code_contract) ? $profile->code_contract : "");
			$this->sheet->setCellValue('C' . $i, !empty($profile->code_contract_disbursement) ? $profile->code_contract_disbursement : "");
			$this->sheet->setCellValue('D' . $i, !empty($profile->customer_name) ? $profile->customer_name : "");
			$this->sheet->setCellValue('E' . $i, !empty($type_exemption) ? ($type_exemption) : 'Tất toán');
			$this->sheet->setCellValue('F' . $i, !empty($profile->ky_tra) ? ($profile->ky_tra) : '-');
			$this->sheet->setCellValue('G' . $i, !empty($amount_exemption) ? number_format($amount_exemption) : "");
			$this->sheet->setCellValue('H' . $i, !empty($profile->type_send) ? type_send($profile->type_send) : "");
			$this->sheet->setCellValue('I' . $i, !empty($profile->domain_exemption) && $profile->domain_exemption == 'MB' ? ('Miền Bắc') : 'Miền Nam');
			$this->sheet->setCellValue('J' . $i, !empty($profile->store->name) ? $profile->store->name : "");
			$this->sheet->setCellValue('K' . $i, !empty($profile->created_at_profile) ? date('d/m/Y', intval($profile->created_at_profile)) : "");
			$this->sheet->setCellValue('L' . $i, !empty($profile->status_profile) ? status_exemption_profile($profile->status_profile) : "");
			$this->sheet->setCellValue('M' . $i, !empty($profile->created_profile_by) ? $profile->created_profile_by : (!empty($profile->created_by_profile) ? $profile->created_by_profile : ''));
			$this->sheet->setCellValue('N' . $i, !empty($profile->code_ref) ? $profile->code_ref : (!empty($profile->code_parent) ? $profile->code_parent : '-'));
			$this->sheet->setCellValue('O' . $i, !empty($profile->profile_name) ? $profile->profile_name : "-");
			$this->sheet->setCellValue('P' . $i, !empty($profile->confirm_email) ? is_yes_or_no($profile->confirm_email) : "-");
			$this->sheet->setCellValue('Q' . $i, !empty($profile->is_exemption_paper) ? is_yes_or_no($profile->is_exemption_paper) : "-");
			$this->sheet->setCellValue('R' . $i, !empty($profile->is_bbbg_profile) ? is_yes_or_no($profile->is_bbbg_profile) : "-");
			$this->sheet->setCellValue('S' . $i, !empty($profile->type_exception) ? type_exception($profile->type_exception) : "-");
			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('DSDonMienGiam' . time() . '.xlsx');
	}

	public function exportListProfileExemptions($profileExemptions)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Loại đơn gửi');
		$this->sheet->setCellValue('C1', 'Bên bàn giao');
		$this->sheet->setCellValue('D1', 'Địa chỉ bên bàn giao');
		$this->sheet->setCellValue('E1', 'Bên nhận bàn giao');
		$this->sheet->setCellValue('F1', 'Địa chỉ bên nhận bàn giao');
		$this->sheet->setCellValue('G1', 'Miền');
		$this->sheet->setCellValue('H1', 'Trạng thái');
		$this->sheet->setCellValue('I1', 'Mã bưu phẩm');
		$this->sheet->setCellValue('J1', 'Mã hồ sơ');
		$this->sheet->setCellValue('K1', 'Tên BBBG');
		$this->sheet->setCellValue('L1', 'Ngày tạo hồ sơ');
		$this->sheet->setCellValue('M1', 'Người tạo hồ sơ');
		$this->sheet->setCellValue('N1', 'Loại hồ sơ');

		$this->setStyle_exemption('A1');
		$this->setStyle_exemption('B1');
		$this->setStyle_exemption('C1');
		$this->setStyle_exemption('D1');
		$this->setStyle_exemption('E1');
		$this->setStyle_exemption('F1');
		$this->setStyle_exemption('G1');
		$this->setStyle_exemption('H1');
		$this->setStyle_exemption('I1');
		$this->setStyle_exemption('J1');
		$this->setStyle_exemption('K1');
		$this->setStyle_exemption('L1');
		$this->setStyle_exemption('M1');
		$this->setStyle_exemption('N1');
		$i = 2;
		foreach ($profileExemptions as $profile) {

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($profile->type_send) ? type_send($profile->type_send) : "");
			$this->sheet->setCellValue('C' . $i, !empty($profile->user_send) ? ($profile->user_send) : "");
			$this->sheet->setCellValue('D' . $i, !empty($profile->address_send) ? ($profile->address_send) : "");
			$this->sheet->setCellValue('E' . $i, !empty($profile->user_receive) ? ($profile->user_receive) : "");
			$this->sheet->setCellValue('F' . $i, !empty($profile->address_receive) ? ($profile->address_receive) : "");
			$this->sheet->setCellValue('G' . $i, !empty($profile->domain_area) && $profile->domain_area == 'MB' ? ('Miền Bắc') : 'Miền Nam');
			$this->sheet->setCellValue('H' . $i, !empty($profile->status) ? status_exemption_profile($profile->status) : "");
			$this->sheet->setCellValue('I' . $i, !empty($profile->postal_code) ? ($profile->postal_code) : "");
			$this->sheet->setCellValue('J' . $i, !empty($profile->code_ref) ? $profile->code_ref : "");
			$this->sheet->setCellValue('K' . $i, !empty($profile->profile_name) ? $profile->profile_name : "");
			$this->sheet->setCellValue('L' . $i, !empty($profile->created_at) ? date('d/m/Y', intval($profile->created_at)) : "");
			$this->sheet->setCellValue('M' . $i, !empty($profile->created_by) ? $profile->created_by : "");
			$this->sheet->setCellValue('N' . $i, !empty($profile->type_exception) ? type_exception($profile->type_exception) : "-");
			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('DSHoSoMienGiam' . time() . '.xlsx');
	}

	// Lịch sử xử lý đơn miễn giảm con
	public function get_log_exemption($id_exemption)
	{
		try {
			$id_exemption = $this->security->xss_clean($id_exemption);
			$response = $this->api->apiPost($this->userInfo['token'], 'Exemptions/get_log_exemption', ['id_exemption' => $id_exemption]);
			$this->pushJson('200', json_encode(array('status' => '200', 'html' => $response->html)));
		} catch (Exception $exception) {
			show_404();
		}

	}

	// Lịch sử xử lý hồ sơ miễn giảm cha
	public function get_log_profile($id_profile)
	{
		try {
			$id_profile = $this->security->xss_clean($id_profile);
			$response = $this->api->apiPost($this->userInfo['token'], 'Exemptions/get_log_profile', ['id_profile' => $id_profile]);
			$this->pushJson('200', json_encode(array('status' => '200', 'html' => $response->html)));
		} catch (Exception $exception) {
			show_404();
		}
	}

	//Remove ĐMG khỏi HSMG
	public function remove_exemption()
	{
		$dataPost = $this->input->post();
		$id_exemption = !empty($this->security->xss_clean($dataPost['id_exemption'])) ? $this->security->xss_clean($dataPost['id_exemption']) : '';
		$code_ref = !empty($this->security->xss_clean($dataPost['code_ref'])) ? $this->security->xss_clean($dataPost['code_ref']) : '';
		$dataSend = [
			'id_exemption' => $id_exemption,
			'code_ref' => $code_ref
		];
		$result = $this->api->apiPost($this->userInfo['token'], 'Exemptions/remove_exemption', $dataSend);
		if (isset($result->status) && $result->status == 200) {
			$response = [
				'status' => '200',
				'msg' => $result->message
			];
			return $this->pushJson('200', json_encode($response));
		} else {
			$response = [
				'status' => '400',
				'msg' => 'Xóa ĐMG thất bại!'
			];
			return $this->pushJson('200', json_encode($response));
		}
	}

	//Get DMG chưa có trong HSMG nào
	public function get_exemptions()
	{
		$dataPost = $this->input->post();
		$type_send = $this->security->xss_clean($dataPost['type_send']);
		$domain_profile = $this->security->xss_clean($dataPost['domain_profile']);
		$type_exception = $this->security->xss_clean($dataPost['type_exception']);
		$exemption_ids = $this->security->xss_clean($dataPost['exemption_ids']);
		$exemption_ids = json_decode($exemption_ids);
		if (!empty($exemption_ids)) {
			$exemptionIds = array();
			for ($i = 0; $i < count($exemption_ids); $i++) array_push($exemptionIds, $exemption_ids[$i]);
			$dataSend = [
				'type_send' => $type_send,
				'domain_profile' => $domain_profile,
				'type_exception' => $type_exception,
				'exemption_ids' => $exemptionIds
			];
			$exemptions = $this->api->apiPost($this->userInfo['token'], 'Exemptions/get_exemptions', $dataSend);
		}
		$response = array();
		foreach ($exemptions->data as $exemption) {
			$arr = array();
			$arr['id'] = getId($exemption->_id);
			$arr['code_contract'] = ($exemption->code_contract);
			$arr['code_contract_disbursement'] = ($exemption->code_contract_disbursement);
			$arr['customer_name'] = ($exemption->customer_name);
			$arr['customer_phone_number'] = ($exemption->customer_phone_number);
			$arr['profile_note'] = ($exemption->profile_note);
			$arr['status_profile'] = status_exemption_profile($exemption->status_profile);
			$arr['type_send'] = type_send($exemption->type_send);
			array_push($response, $arr);
		}
		return $this->pushJson('200', json_encode(array('status' => '200', 'data' => $response)));
	}

	public function addmore_exemption()
	{
		$dataPost = $this->input->post();
		$code_ref = $this->security->xss_clean($dataPost['code_ref']) ? $this->security->xss_clean($dataPost['code_ref']) : '';
		$exemption_ids = $this->security->xss_clean($dataPost['exemption_ids']) ? $this->security->xss_clean($dataPost['exemption_ids']) : '';
		$dataSend = [
			'code_ref' => $code_ref,
			'exemption_ids' => $exemption_ids,
		];
		$result = $this->api->apiPost($this->userInfo['token'],'Exemptions/addmore_exemption', $dataSend);
		if (isset($result->status) && $result->status == 200) {
			$response = [
				'status' => '200',
				'msg' => $result->message
			];
			return $this->pushJson('200', json_encode($response));
		} else {
			$response = [
				'status' => '400',
				'msg' => 'Thêm ĐMG thất bại!'
			];
			return $this->pushJson('200', json_encode($response));
		}
	}


}


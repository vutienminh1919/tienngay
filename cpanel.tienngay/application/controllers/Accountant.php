<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Accountant extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model("store_model");
		$this->load->model("time_model");
		$this->load->library('session');
		$this->load->helper('lead_helper');
		$this->config->load('config');
		$this->load->library('pagination');
		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
//		if (!$this->is_superadmin) {
//			$paramController = $this->uri->segment(1);
//			$param = strtolower($paramController);
//			if (!in_array($param, $this->paramMenus)) {
//				$this->session->set_flashdata('error', $this->lang->line('not_have_permission') . ' ' . $paramController . '!');
//				redirect(base_url('app'));
//				return;
//			}
//		}
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	public function remind_debt_first()
	{
		$this->data["pageName"] = "Danh sách nhắc HĐV";
		$condition = array();
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('accountant/remind_debt_first'));
		}
		

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('accountant/remind_debt_first?&fdate=' . $start . '&tdate=' . $end . '&code_contract_disbursement=' . $code_contract_disbursement . '&customer_name=' . $customer_name. '&code_contract=' . $code_contract);
		

		$config['per_page'] = 30;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;

		// call api get contract data
		$data = array(
		
			"per_page" => $config['per_page'],
			"uriSegment" => $config['uri_segment']
		);
       if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$data['start'] = $start;
			$data['end'] = $end;
		}
       $data['code_contract_disbursement'] = $code_contract_disbursement;
        $data['code_contract'] = $code_contract;
		$data['customer_name'] = $customer_name;
		$contractData = $this->api->apiPost($this->userInfo['token'], "contract/contract_tempo_all", $data);
		if (!empty($contractData->status) && $contractData->status == 200) {
			$this->data['contractData'] = $contractData->data;
			$config['total_rows'] = $contractData->total;
		} else {
			$this->data['contractData'] = array();
		}
		$this->pagination->initialize($config);
		$this->data['result_count'] = "Hiển thị " . $config['total_rows'] . " Kết quả";
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/accountant/thn/remind_debt_first';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;
	}

	public function contract_v2()
	{
		$this->data["pageName"] = "Hợp đồng vay";
		$this->data['stores'] = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active")->data;
		$this->data['contractData'] = array();
		$this->data['groupRole'] = array();
		$this->data['investorData'] = array();
		$this->data['storeData'] = array();

		//Params
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$phone_number = !empty($_GET['phone_number']) ? $_GET['phone_number'] : "";
		$id_card = !empty($_GET['id_card']) ? $_GET['id_card'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$bucket = !empty($_GET['bucket']) ? $_GET['bucket'] : "";
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$vung_mien = !empty($_GET['vung_mien']) ? $_GET['vung_mien'] : "";
		$van = !empty($_GET['van']) ? $_GET['van'] : "";
		// điều kiện để lấy bản ghi
		$condition = array(
			'status_disbursement' => 3, //1 moi tao, 2: tạo giải ngân thành công, 3// tiền đến với khách, 4 thất bại
			'status' => $status   // 17: giải ngân thành công, 18: giải ngân thất bại
		);
		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('accountant/contract_v2'));
		}
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$condition['start'] = $start;
			$condition['end'] = $end;
		}
		if (!empty($store)) {
			$condition['store_id'] = trim($store);
		}
		if (!empty($id_card)) {
			$condition['id_card'] = trim($id_card);
		}
		if (!empty($bucket)) {
			$condition['bucket'] = trim($bucket);
		}
		if (!empty($customer_name)) {
			$condition['customer_name'] = trim($customer_name);
		}
		if (!empty($phone_number)) {
			$condition['customer_phone_number'] = $phone_number;
		}
		if (!empty($code_contract_disbursement)) {
			$condition['code_contract_disbursement'] = trim($code_contract_disbursement);
		}
		if (!empty($code_contract)) {
			$condition['code_contract'] = trim($code_contract);
		}
		if (!empty($vung_mien)) {
			$condition['vung_mien'] = trim($vung_mien);
		}
		if (!empty($van)) {
			$condition['van'] = trim($van);
		}
		//Paginate
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('accountant/contract_v2?code_contract_disbursement=' . $code_contract_disbursement . '&fdate=' . $start . '&tdate=' . $end . '&bucket=' . $bucket . '&customer_name=' . $customer_name . '&phone_number=' . $phone_number . '&id_card=' . $id_card . '&store=' . $store . '&code_contract=' . $code_contract.'&vung_mien='.$vung_mien.'&status='.$status.'&van='.$van);
		$config['per_page'] = 30;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;

		// call api get contract data
		$contractData = $this->api->apiPost(
			$this->userInfo['token'],
			"contract/contract_tempo",
			[
				"condition" => $condition,
				"per_page" => $config['per_page'],
				"uriSegment" => $config['uri_segment']
			]
		);
		if (!empty($contractData->status) && $contractData->status == 200) {
			$config['total_rows'] = $contractData->total;
			$current_date = date('Y-m-d');
			foreach ($contractData->data as $key => $contract) {
				if ($contract->debt->so_ngay_cham_tra > 60 && $contract->status === 17) {
					$contractTemp = $this->api->apiPost(
						$this->userInfo['token'],
						"view_payment/tempo_detail",
						[
							"id" => $contract->_id->{'$oid'},
							"date_pay" => $current_date
						]
					);

					$tabTatToanPart1 = $this->api->apiPost(
						$this->userInfo['token'],
						"view_payment/get_infor_tat_toan_part_1",
						[
							"code_contract" => $contract->code_contract,
							"date_pay" => $current_date
						]
					);

					$debtData = $this->api->apiPost(
						$this->userInfo['token'],
						"view_payment/debt_detail",
						[
							"id" => $contract->_id->{'$oid'},
							"date_pay" => $current_date
						]
					);

					$cham_tra = 0;
					$lai = $tabTatToanPart1->data->lai_chua_tra_den_thoi_diem_hien_tai;
					foreach ($contractTemp->data as $temp) {
						$cham_tra += $temp->penalty_now;
					}

					$contract->tong_tt = $contract->debt->tong_tien_goc_con + $contract->debt->tong_tien_phi_con + $lai + $cham_tra + $debtData->data->phi_thanh_toan_truoc_han + $contractTemp->contract->phi_phat_sinh;
				}
				//	Lấy đơn miễn giảm của kỳ hiện tại
				$exemption_contract = $this->api->apiPost($this->userInfo['token'],'exemptions/get_all',["code_contract" => $contract->code_contract]);
				if (!empty($exemption_contract->status) && $exemption_contract->status == 200) {
					if (!empty($exemption_contract->contract)) {
						foreach ($exemption_contract->contract as $key => $contract_ex) {
							if ($contract_ex->ky_tra == $contract->lai_ki->ky_tra) {
								$contract->exemption = $contract_ex;
							}
						}
					}
				}
			}
			$this->data['contractData'] = $contractData->data;
			$config['total_rows'] = $contractData->total;
		}
		//Role
		$groupRoles = $this->api->apiPost(
			$this->user['token'],
			"groupRole/getGroupRole",
			array("user_id" => $this->user['id'])
		);
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		}
		// get investor
		$investor = $this->api->apiPost($this->userInfo['token'], "investor/get_all");
		if (!empty($investor->status) && $investor->status == 200) {
			$this->data['investorData'] = $investor->data;
		}
		//get store
		if(!empty($vung_mien)) {
			$storeData = $this->api->apiPost($this->userInfo['token'], "area/get_store_by_area", array("code_area" => $vung_mien));
			if (!empty($storeData->status) && $storeData->status == 200) {
				$this->data['storeData'] = json_decode(json_encode($storeData->data), true);
			}
		}
		//get role khởi tạo thanh lý
		$role_liq = $this->api->apiPost($this->userInfo['token'], 'LiquidationAssetContract/get_role_create_liquidation',[]);
		if (!empty($role_liq->data)) {
			$this->data["role_liq"] = $role_liq->data;
		} else {
			$this->data["role_liq"] = array();
		}
		//get role Hủy thanh lý
		$role_cancel_liq = $this->api->apiPost($this->userInfo['token'], 'LiquidationAssetContract/get_role_cancel_liquidation',[]);
		if (!empty($role_liq->data)) {
			$this->data["role_cancel_liq"] = $role_cancel_liq->data;
		} else {
			$this->data["role_cancel_liq"] = array();
		}
		$areaData = $this->api->apiPost($this->userInfo['token'], "area/get_all_home")->data;
		$this->data["selectedStore"] = $store;
		$this->data['areaData'] = $areaData;
		$this->data['result_count'] = $config['total_rows'];
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['email_user'] = $this->userInfo['email'];
		$this->data['full_name'] = $this->userInfo['full_name'];
		//var_dump($contractData); die;
		$this->data['template'] = 'page/accountant/contract_v2';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;
	}

	public function do_send_sms()
	{
		$data = $this->input->post();
		$content = $this->security->xss_clean($data['content']);
		$contract_id = $this->security->xss_clean($data['contract_id']);
		$template = $this->security->xss_clean($data['template']);


		$dataPost = array(
			"content" => $content,
			"contract_id" => $contract_id,
			"template" => $template

		);

		$result = $this->api->apiPost($this->userInfo['token'], "contract/do_send_sms", $dataPost);
		if (!empty($result->status) && $result->status == 200) {

			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $result->message, "data" => $result)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $result->message, "data" => $result)));
			return;
		}
	}

	public function doNoteReminder()
	{
		$data = $this->input->post();
		$data['note'] = $this->security->xss_clean($data['note']);
		$data['contractId'] = $this->security->xss_clean($data['contractId']);
		$data['result_reminder'] = $this->security->xss_clean($data['result_reminder']);
		$payment_date = !empty($data['payment_date']) ? $data['payment_date'] : "";
		$amount_payment_appointment = !empty($data['amount_payment_appointment']) ? $data['amount_payment_appointment'] : "";

		$dataPost = array(
			"note" => $data['note'],
			"result_reminder" => $data['result_reminder'],
			"payment_date" => $payment_date,
			"amount_payment_appointment" => $amount_payment_appointment,
			// "status" => 22,
			"contract_id" => $data['contractId'],
		);

		$result = $this->api->apiPost($this->userInfo['token'], "contract/do_note_reminder", $dataPost);
		if (!empty($result->status) && $result->status == 200) {

			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $result->message, "data" => $result)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $result->message, "data" => $result)));
			return;
		}
	}

	public function index()
	{
		$this->data["pageName"] = "Quản lý hợp đồng đang vay";
		$store_code = !empty($_GET['store']) ? $_GET['store'] : "";
		$type_loan = !empty($_GET['type_loan']) ? $_GET['type_loan'] : "";
		$type_property = !empty($_GET['type_property']) ? $_GET['type_property'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		// $investor_code = !empty($_GET['investor']) ? $_GET['investor'] : "";z
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$fdebt = isset($_GET['fdebt']) ? $_GET['fdebt'] : "";
		$tdebt = isset($_GET['tdebt']) ? $_GET['tdebt'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$customer_phone_number = !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('accountant'));
		}
		if ($fdebt > $tdebt) {
			$this->session->set_flashdata('error', 'Chọn lại ngày T');
			redirect(base_url('accountant'));
		}
		if (isset($_GET['fdate']) && isset($_GET['tdate'])) {
			$data['start'] = $start;
			$data['end'] = $end;
		}
		if (($_GET['fdebt'] != '') && ($_GET['tdebt'] != '')) {
			$data['fdebt'] = $fdebt;
			$data['tdebt'] = $tdebt;
		}
		if (!empty($store_code)) {
			$data['store_id'] = trim($store_code);
		}
		// if (!empty($bucket)) {
		// 	$condition['bucket'] = trim($bucket);
		// }
		if (!empty($customer_name)) {
			$data['customer_name'] = trim($customer_name);
		}
		if (!empty($customer_phone_number)) {
			$data['customer_phone_number'] = trim($customer_phone_number);
		}
		if (!empty($code_contract_disbursement)) {
			$data['code_contract_disbursement'] = trim($code_contract_disbursement);
		}
		if (!empty($status)) {
			$data['status'] = $status;
		}
		if (!empty($type_loan)) {
			$data['type_loan'] = $type_loan;
		}
		if (!empty($type_property)) {
			$data['type_property'] = $type_property;
		}
		if (!empty($code_contract)) {
			$data['code_contract'] = trim($code_contract);
		}
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('accountant?code_contract_disbursement=' . $code_contract_disbursement . '&fdate=' . $start . '&tdate=' . $end . '&customer_name=' . $customer_name . '&customer_phone_number'
			. $customer_phone_number . '&store=' . $store_code . '&status=' . $status . '&fdebt=' . $fdebt . '&tdebt=' . $tdebt . '&type_loan=' . $type_loan . '&type_property=' . $type_property . '&code_contract=' . $code_contract);
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 30;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;

		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];
		$contractData = $this->api->apiPost($this->userInfo['token'], "contract/contract_tempo_new", $data);
		if (!empty($contractData->status) && $contractData->status == 200) {
			$config['total_rows'] = $contractData->total;
			$this->data['contractData'] = $contractData->data;
			$this->data['tong_tien_cho_vay'] = $contractData->tong_tien_cho_vay_va_goc->tong_tien_vay;
			$this->data['tong_du_no_goc_con_lai'] = $contractData->tong_tien_cho_vay_va_goc->tong_tien_goc_con_lai;
			$this->data['tong_hd_qua_han'] = $contractData->tong_hd_qua_han;
			$this->data['tong_hd_can_nhac_no'] = $contractData->tong_hd_can_nhac_no;
		} else {
			$this->data['contractData'] = [];
		}

		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['result_count'] = $config['total_rows'];
		$stores = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active", $data);
		$store = $this->api->apiPost($this->userInfo['token'], "mic_tnds/get_store_by_user", $data);
		//lấy id_store của user theo session hiện tại
		$arr_store = [];
		foreach ($this->userInfo['stores'] as $st) {
			$arr_store += [$st->store_id => $st->store_name];
		}
		$this->data['stores'] = $arr_store;
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		$this->data['template'] = 'page/accountant/contract';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;
	}

	// Filter contract
	public function search()
	{
		$this->data["pageName"] = $this->lang->line('manage_approved_contracts');
		$dateRange = !empty($_GET['reservation']) ? $_GET['reservation'] : "";
		$store_code = !empty($_GET['store']) ? $_GET['store'] : "";
		$investor_code = !empty($_GET['investor']) ? $_GET['investor'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$bucket = !empty($_GET['bucket']) ? $_GET['bucket'] : "";
		// điều kiện để lấy bản ghi
		$condition = array(
			'status_disbursement' => 3, //1 moi tao, 2: tạo giải ngân thành công, 3// tiền đến với khách, 4 thất bại
			'status' => 17  // giải ngân thành công, 18: giải ngân thất bại
		);
		if (!empty($dateRange)) {
			$arrTime = explode('-', $dateRange);
			$condition['start'] = strtotime(trim($arrTime[0]) . ' 00:00:00');
			$condition['end'] = strtotime(trim($arrTime[1]) . ' 23:59:59');
		};
		if (!empty($store_code)) {
			$condition['store_id'] = trim($store_code);
		}
		if (!empty($investor_code)) {
			$condition['investor_code'] = trim($investor_code);
		}
		if (!empty($status)) {
			$condition['status'] = trim($status);
		}
		if (!empty($bucket)) {
			$condition['bucket'] = trim($bucket);
		}
		$data = array(
			"condition" => $condition
		);
		// Lấy hợp đồng theo điều kiện
		$contractData = $this->api->apiPost($this->userInfo['token'], "contract/contract_tempo", $data);
		// get investor
		$investor = $this->api->apiPost($this->userInfo['token'], "investor/get_all");
		//get store
		$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all");
		if (!empty($storeData->status) && $storeData->status == 200) {
			$this->data['storeData'] = $storeData->data;
		} else {
			$this->data['storeData'] = array();
		}
		if (!empty($investor->status) && $investor->status == 200) {
			$this->data['investorData'] = $investor->data;
		} else {
			$this->data['investorData'] = array();
		}
		if (!empty($contractData->status) && $contractData->status == 200) {
			$this->data['contractData'] = $contractData->data;
		} else {
			$this->data['contractData'] = array();
		}

		$this->data['store'] = $store_code;
		$this->data['investor'] = $investor_code;
		$this->data['reservation'] = $dateRange;

		$this->data['template'] = 'page/accountant/contract';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;
	}

	public function viewContract()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		if (empty($id)) {
			$this->session->set_flashdata('error', $this->lang->line('not_exist_contract'));
			redirect(base_url('accountant'));
			return;
		}
		$data = array(
			"id" => $id
		);
		$contractData = $this->api->apiPost($this->userInfo['token'], "view_payment/tempo_detail", $data);
		if (!empty($contractData->status) && $contractData->status == 200) {
			$this->data['contractData'] = $contractData->data;
			$this->data['contractDB'] = $contractData->contract;
		} else {
			$this->data['contractData'] = array();
			$this->data['contractDB'] = array();
		}
		$this->data['template'] = 'page/accountant/contract_detail';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;
	}

	public function reminder_ctd()
	{
		$this->data['pageName'] = 'Hợp đồng chuyển thực địa';
		$loan = !empty($_GET['loan']) ? $_GET['loan'] : "";
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$condition = array();
		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('accountant/reminder_ctd'));
		}
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$condition['start'] = $start;
			$condition['end'] = $end;
		}
		if (!empty($_GET['loan'])) {
			$condition['loan'] = $loan;
		}
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$condition['per_page'] = $config['per_page'];
		$condition['uriSegment'] = $config['uri_segment'];
		$contractData = $this->api->apiPost($this->userInfo['token'], "contract/get_contract_chuyentd", $condition);
		if (!empty($contractData->status) && $contractData->status == 200) {
			$this->data['contractData'] = $contractData->data;
			$config['total_rows'] = $contractData->total;
		} else {
			$this->data['contractData'] = array();
		}
		$cskhData = $this->api->apiPost($this->user['token'], "contract/get_cskh");
		if (!empty($cskhData->status) && $cskhData->status == 200) {
			$this->data['cskhData'] = $cskhData->data;
		} else {
			$this->data['cskhData'] = array();
		}
		$this->pagination->initialize($config);

		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['result_count'] = "Hiển thị " . $config['total_rows'] . " Kết quả";
		$this->data['template'] = 'page/accountant/contract_reminder_ctd';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;
	}

	public function view_v2()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		$date_pay = "";
		if (empty($id)) {
			$this->session->set_flashdata('error', $this->lang->line('not_exist_contract'));
			redirect(base_url('accountant'));
			return;
		}

		$data = array(
			"id" => $id
		);
		$contractData = $this->api->apiPost($this->userInfo['token'], "view_payment/tempo_detail", $data);
		//var_dump($contractData); die;
		$isDaTatToan = false;
		$address = '';
		$addressSHK = '';
		if (!empty($contractData->status) && $contractData->status == 200) {
			$this->data['contractData'] = $contractData->data;
			$this->data['contractDB'] = $contractData->contract;
			if ($contractData->contract->status == 19) $isDaTatToan = true;
			//Start Địa chỉ đang ở
			$districtSelected = $contractData->contract->current_address->district;
			$wardSelected = $contractData->contract->current_address->ward;
			$current_address = $contractData->contract->current_address->current_stay;
			$wardData = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtSelected));
			if (!empty($wardData->status) && $wardData->status == 200) {
				foreach ($wardData->data as $w) {
					if ($w->code == $wardSelected) {
						$address = $current_address . ', ' . $w->path_with_type;
						break;
					}
				}
			}
			//Start Địa chỉ shk
			$districtHousehold = $contractData->contract->houseHold_address->district;
			$wardHousehold = $contractData->contract->houseHold_address->ward;
			$household_address = $contractData->contract->houseHold_address->address_household;
			$wardDataHousehold = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtHousehold));
			if (!empty($wardDataHousehold->status) && $wardDataHousehold->status == 200) {
				foreach ($wardDataHousehold->data as $w) {
					if ($w->code == $wardHousehold) {
						$addressSHK = $household_address . ', ' . $w->path_with_type;
						break;
					}
				}
			}
			//End
		} else {
			$this->data['contractData'] = array();
			$this->data['contractDB'] = array();
		}

		$log_contract_thn = $this->api->apiPost($this->userInfo['token'], "log_contract_thn/get_one", $data);
		if (!empty($log_contract_thn->status) && $log_contract_thn->status == 200) {
			$this->data['log_contract_thn'] = $log_contract_thn->data->new;
			//$this->data['address_log'] =$log_contract_thn->data->new->address;

		} else {
			$this->data['log_contract_thn'] = array();

		}
		$check_isset_gh = 0;
		$check_isset_cc = 0;
		$check_dang_xl = 0;
		$historyData = $this->api->apiPost($this->userInfo['token'], "transaction/history_contract", $data);
		if (!empty($historyData->status) && $historyData->status == 200) {
			$this->data['historyData'] = $historyData->data;
			foreach ($historyData->data as $key => $value) {
				if (!empty($value->type_payment)) {
					if ($value->type_payment == 2 && $value->status != 3)
						$check_isset_gh = 1;
					if ($value->type_payment == 3 && $value->status != 3)
						$check_isset_cc = 1;

				}
				if (in_array($value->status, [2, 4]))
					$check_dang_xl = 1;

			}
		} else {
			$this->data['historyData'] = array();
		}


		$debtData = $this->api->apiPost($this->userInfo['token'], "view_payment/debt_detail", $data);


		if (!empty($debtData->status) && $debtData->status == 200) {
			$this->data['debtData'] = $debtData->data;
		} else {
			$this->data['debtData'] = array();
		}
		//list contract extension
		$sendApi = array(
			"id" => $id
		);
		$contractExtensionData = $this->api->apiPost($this->userInfo['token'], "contract/get_contract_extension_by_contractParent", $sendApi);
		$this->data['contractExtensionData'] = $contractExtensionData;
		$this->data['address'] = $address;
		$this->data['addressSHK'] = $addressSHK;
		$this->data['contract_id'] = $id;
		$this->data['template'] = 'page/accountant/debt_detail_v2';

		$result = $this->api->apiPost($this->userInfo['token'], "contract/get_image_accurecy", $data);
		$this->data['result'] = $result->data;
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", $data);
//		if ($contract->data->status == 40) {
//			$date_pay = date("Y-m-d", $contract->data->liquidation_info->created_at_liquidations);
//		}
		$this->data['contractInfor'] = $contract->data;
		$this->data['difference_amount'] = $contract->data->suggest_price_info->suggest_price - $contract->data->suggest_price_info->debt_remain_root;

		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$this->data['role'] = (in_array('tbp-thu-hoi-no', $this->data['groupRoles'])) ? "tbp-thu-hoi-no" : "";
		//get hình thức vay
		$configuration_formality = $this->api->apiPost($this->userInfo['token'], "configuration_formality/get_configuration_formality");
		if (!empty($configuration_formality->status) && $configuration_formality->status == 200) {
			$this->data['configuration_formality'] = $configuration_formality->data;
		} else {
			$this->data['configuration_formality'] = array();
		}
		//get property main ( tài sản cấp cao nhất parenid == null)
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main");
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$this->data['mainPropertyData'] = $mainPropertyData->data;
		} else {
			$this->data['mainPropertyData'] = array();
		}
		//Init loan infor
		$arrMinus = array();
		if (!empty($contract->data->loan_infor->decreaseProperty)) {
			$decreaseProperty = $contract->data->loan_infor->decreaseProperty;
			foreach ($decreaseProperty as $item) {
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
		if (!empty($provinceData->status) && $provinceData->status == 200) {
			$this->data['provinceData'] = $provinceData->data;
		} else {
			$this->data['provinceData'] = array();
		}
		$districtData = $this->api->apiPost($this->userInfo['token'], "province/get_district_by_province", array("id" => $provinceSelected));
		if (!empty($districtData->status) && $districtData->status == 200) {
			$this->data['districtData'] = $districtData->data;
		} else {
			$this->data['districtData'] = array();
		}
		$wardData = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtSelected));
		if (!empty($wardData->status) && $wardData->status == 200) {
			$this->data['wardData'] = $wardData->data;
		} else {
			$this->data['wardData'] = array();
		}
		//End
		//Start Địa chỉ hộ khẩu
		$provinceSelected_ = $contract->data->houseHold_address->province;
		$districtSelected_ = $contract->data->houseHold_address->district;
		$provinceData_ = $this->api->apiPost($this->userInfo['token'], "province/get_province");
		if (!empty($provinceData_->status) && $provinceData_->status == 200) {
			$this->data['provinceData_'] = $provinceData_->data;
		} else {
			$this->data['provinceData_'] = array();
		}
		//get district by province
		$districtData_ = $this->api->apiPost($this->userInfo['token'], "province/get_district_by_province", array("id" => $provinceSelected_));
		if (!empty($districtData_->status) && $districtData_->status == 200) {
			$this->data['districtData_'] = $districtData_->data;
		} else {
			$this->data['districtData_'] = array();
		}
		//get ward by district
		$wardData_ = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtSelected_));
		if (!empty($wardData_->status) && $wardData_->status == 200) {
			$this->data['wardData_'] = $wardData_->data;
		} else {
			$this->data['wardData_'] = array();
		}
		//End
		$log = $this->api->apiPost($this->userInfo['token'], "log/get_log_contract", array("contract_id" => $id));
		if (!empty($log->status) && $log->status == 200) {
			$this->data['logs'] = $log->data;
		} else {
			$this->data['logs'] = array();
		}

		$reminder_contract = $this->api->apiPost($this->userInfo['token'], "debt_manager_app/reminder_contract", array("contract_id" => $id));
		if (!empty($reminder_contract->status) && $reminder_contract->status == 200) {
			$this->data['reminder_contract'] = $reminder_contract->data;
		} else {
			$this->data['reminder_contract'] = array();
		}
		//Dữ liệu cho tab tất toán
		$tabTatToanPart1 = $this->api->apiPost($this->userInfo['token'], "view_payment/get_infor_tat_toan_part_1", array("code_contract" => $contract->data->code_contract, "date_pay" => $date_pay));
		$tabTatToanPart2 = $this->api->apiPost($this->userInfo['token'], "view_payment/get_infor_tat_toan_part_2", array("code_contract" => $contract->data->code_contract, "date_pay" => $date_pay));
		$countGiaoDichThanhToanChoDuyet = $this->api->apiPost($this->userInfo['token'], "view_payment/countGiaoDichThanhToanChoDuyet", array("code_contract" => $contract->data->code_contract));
		$countGiaoDichTatToanChoDuyet = $this->api->apiPost($this->userInfo['token'], "view_payment/countGiaoDichTatToanChoDuyet", array("code_contract" => $contract->data->code_contract));
		if ($isDaTatToan == true) {
			$contractDataTatToan = $this->api->apiPost($this->userInfo['token'], "view_payment/get_bang_lai_ky_tat_toan", array("code_contract" => $contract->data->code_contract));
			$this->data['contractDataTatToan'] = $contractDataTatToan->data;
			//Get transaction_thanh_toan_lai_ky_tai_ki_tat_toan
			$transaction_thanh_toan_lai_ky_tai_ki_tat_toan = $this->api->apiPost($this->userInfo['token'], "view_payment/get_transaction_thanh_toan_lai_ky_tai_ky_tat_toan", array("code_contract" => $contract->data->code_contract));
			$transaction_thanh_toan_lai_ky_tai_ki_tat_toan = (array)$transaction_thanh_toan_lai_ky_tai_ki_tat_toan->data;
			$total_transaction_tat_toan_goc_da_tra = 0;
			$total_transaction_tat_toan_lai_da_tra = 0;
			$total_transaction_tat_toan_phi_da_tra = 0;
			foreach ($transaction_thanh_toan_lai_ky_tai_ki_tat_toan as $item) {
				$total_transaction_tat_toan_goc_da_tra += !empty($item->so_tien_goc_da_tra) ? $item->so_tien_goc_da_tra : 0;
				$total_transaction_tat_toan_lai_da_tra += !empty($item->so_tien_lai_da_tra) ? $item->so_tien_lai_da_tra : 0;
				$total_transaction_tat_toan_phi_da_tra += !empty($item->so_tien_phi_da_tra) ? $item->so_tien_phi_da_tra : 0;
			}
			$this->data['total_transaction_tat_toan_goc_da_tra'] = $total_transaction_tat_toan_goc_da_tra;
			$this->data['total_transaction_tat_toan_lai_da_tra'] = $total_transaction_tat_toan_lai_da_tra;
			$this->data['total_transaction_tat_toan_phi_da_tra'] = $total_transaction_tat_toan_phi_da_tra;
		}
		$contract_view_payment = $this->data['contractDB'];
		$data_send_log = [
			'code_contract' => $contract->data->code_contract
		];

		//	Lấy ngày đến hạn và kỳ trả hiện tại chưa gạch nợ gần nhất (tính từ ngày giải ngân) từ bảng temporary_plan_contract
		$period_contract = $this->api->apiPost($this->userInfo['token'], 'exemptions/get_current_period',$data_send_log);
		$ky_tra_hien_tai = 0;
		$ngay_den_han = 0;
		if (!empty($period_contract->status) && $period_contract->status == 200) {
			$ky_tra_hien_tai = $period_contract->ky_tra_hien_tai;
			$ngay_den_han = $period_contract->ngay_den_han;
			$this->data['ky_tra_hien_tai'] = $ky_tra_hien_tai;
			$this->data['ngay_den_han'] = $ngay_den_han;
		}

		//	Lấy đơn miễn giảm của kỳ hiện tại
		$exemption_contract = $this->api->apiPost($this->userInfo['token'],'exemptions/get_all',$data_send_log);

		if (!empty($exemption_contract->status) && $exemption_contract->status == 200) {
			foreach ($exemption_contract->contract as $key => $contract_ex) {
                 $type_payment_exem= (!empty($contract_ex->type_payment_exem) && $contract_ex->type_payment_exem==2) ? 2 : 1;
				if ($contract_ex->ky_tra == $ky_tra_hien_tai && $type_payment_exem==1) {
					$this->data['exemption_contract'] = $contract_ex;
					
				}else if($type_payment_exem==2){
					$this->data['exemption_contract'] = $contract_ex;
			
				}
			}
			$this->data['exemption_contract_all'] = $exemption_contract->contract;
		}
		//	Lấy transaction đã áp dụng miễn giảm
		$data_api_discount = [
			'code_contract' => $contract->data->code_contract,
			'ky_tra_hien_tai' => $ky_tra_hien_tai,
		];
		$transaction_discount = $this->api->apiPost($this->userInfo['token'], 'exemptions/get_transaction_discount',$data_api_discount);
		if (!empty($transaction_discount->status) && $transaction_discount->status == 200) {
			$this->data['issetTransactionDiscount'] = $transaction_discount->check_discount;
		} else {
			$this->data['issetTransactionDiscount'] = array();
		}

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
		//	Lấy log của đơn miễn giảm
		$exemption_contract_log = $this->api->apiPost($this->userInfo['token'],'exemptions/get_log',$data_send_log);

		if (isset($exemption_contract_log->status) && $exemption_contract_log->status == 200) {
			$this->data['exemption_contract_log'] = $exemption_contract_log->contract;
		} else {
			$this->data['exemption_contract_log'] = [];
		}
		//	Lấy lãi trừ vào kỳ cuối (áp dụng coupon)
		$data_api_reduced_profit = [
			'code_contract' => $contract->data->code_contract,
			'code_coupon' => $contract->data->loan_infor->code_coupon,
			'date_pay' => $this->data['contractDB']->date_pay,
		];
		$date_pay = !empty($this->data['contractDB']->date_pay) ? date("Y-m-d", $this->data['contractDB']->date_pay) : date("Y-m-d");
		$expire_date = !empty($this->data['contractDB']->expire_date) ? date("Y-m-d", $this->data['contractDB']->expire_date) : '';
		$reduced_profit = $this->api->apiPost($this->userInfo['token'], "contract/get_interest_end_period_by_coupon", $data_api_reduced_profit);
		if (isset($reduced_profit->status) && $reduced_profit->status == 200) {
			if ($date_pay == $expire_date) {
				$this->data['reduced_profit'] = $reduced_profit->data;
			}
		} else {
			$this->data['reduced_profit'] = 0;
		}
		$transactionExemption = $this->api->apiPost($this->userInfo['token'], 'Transaction/getTransactionExemptionApproved', $data_send_log);
		if (isset($transactionExemption->data)) {
			$this->data['isTransactionExemptionsApproved'] = $transactionExemption->data;
		}

		$this->data['detail'] = 1;

		$this->data['user_id_login'] = $this->userInfo['id'];
		$this->data['countGiaoDichThanhToanChoDuyet'] = $countGiaoDichThanhToanChoDuyet->count;
		$this->data['countGiaoDichTatToanChoDuyet'] = $countGiaoDichTatToanChoDuyet->count;
		$this->data['dataTatToanPart1'] = $tabTatToanPart1->data;
		$this->data['dataTatToanPart2'] = $tabTatToanPart2;
		$this->data['dataInit'] = $dataLoanInfor;
		$this->data['check_isset_gh'] = $check_isset_gh;
		$this->data['check_isset_cc'] = $check_isset_cc;
		$this->data['check_dang_xl'] = $check_dang_xl;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;
	}

	public function check_date_pay()
	{
		$data = $this->input->post();
		$id_contract = !empty($data['id_contract']) ? $data['id_contract'] : "";
		$date_pay = !empty($data['date_pay']) ? $data['date_pay'] : "";

		$data = array(
			"id" => $id_contract,
			"date_pay" => $date_pay
		);
		$return = $this->api->apiPost($this->userInfo['token'], "view_payment/tempo_detail", $data);
		if (!empty($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("status" => "200", "msg" => 'Lấy dữ liệu thành công', 'data' => $return->contract)));
			return;

		} else {
			$this->pushJson('200', json_encode(array("status" => "401", "msg" => $return->message)));
			return;
		}
	}

	public function check_date_pay_finish()
	{
		$data = $this->input->post();
		$id_contract = !empty($data['id_contract']) ? $data['id_contract'] : "";
		//format date_pay: YYYY-mm-dd
		$date_pay = !empty($data['date_pay']) ? $data['date_pay'] : "";
		$type_payment = !empty($data['type_payment']) ? $data['type_payment'] : 1;

		$data = array(
			"id" => $id_contract,
			"date_pay" => $date_pay,
			"type_payment" => $type_payment
		);
		if ($type_payment == 2) {
			$log = $this->api->apiPost($this->userInfo['token'], "log/get_log_gh", array("contract_id" => $id_contract));
		}
		if ($type_payment == 3) {
			$log = $this->api->apiPost($this->userInfo['token'], "log/get_log_cc", array("contract_id" => $id_contract));
		}
		if (!empty($log->status) && $log->status == 200) {
			$this->data['logs'] = $log->data;
		} else {
			$this->data['logs'] = array();
		}
		$debtData = $this->api->apiPost($this->userInfo['token'], "view_payment/debt_detail", $data);
		if (!empty($debtData->status) && $debtData->status == 200) {
			$this->data['debtData'] = $debtData->data;
		} else {
			$this->data['debtData'] = array();
		}
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", $data);
		$return = $this->api->apiPost($this->userInfo['token'], "view_payment/tempo_detail", $data);
		//Dữ liệu cho tab tất toán
		$tabTatToanPart1 = $this->api->apiPost($this->userInfo['token'], "view_payment/get_infor_tat_toan_part_1", array("code_contract" => $contract->data->code_contract, "date_pay" => $date_pay));
		$tabTatToanPart2 = $this->api->apiPost($this->userInfo['token'], "view_payment/get_infor_tat_toan_part_2", array("code_contract" => $contract->data->code_contract, "date_pay" => $date_pay));

		$countGiaoDichTatToanChoDuyet = $this->api->apiPost($this->userInfo['token'], "view_payment/countGiaoDichTatToanChoDuyet", array("code_contract" => $contract->data->code_contract));
		if ($isDaTatToan == true) {
			$contractDataTatToan = $this->api->apiPost($this->userInfo['token'], "view_payment/get_bang_lai_ky_tat_toan", array("code_contract" => $contract->data->code_contract));
			$this->data['contractDataTatToan'] = $contractDataTatToan->data;
			//Get transaction_thanh_toan_lai_ky_tai_ki_tat_toan
			$transaction_thanh_toan_lai_ky_tai_ki_tat_toan = $this->api->apiPost($this->userInfo['token'], "view_payment/get_transaction_thanh_toan_lai_ky_tai_ky_tat_toan", array("code_contract" => $contract->data->code_contract));
			$transaction_thanh_toan_lai_ky_tai_ki_tat_toan = (array)$transaction_thanh_toan_lai_ky_tai_ki_tat_toan->data;
			$total_transaction_tat_toan_goc_da_tra = 0;
			$total_transaction_tat_toan_lai_da_tra = 0;
			$total_transaction_tat_toan_phi_da_tra = 0;
			foreach ($transaction_thanh_toan_lai_ky_tai_ki_tat_toan as $item) {
				$total_transaction_tat_toan_goc_da_tra += !empty($item->so_tien_goc_da_tra) ? $item->so_tien_goc_da_tra : 0;
				$total_transaction_tat_toan_lai_da_tra += !empty($item->so_tien_lai_da_tra) ? $item->so_tien_lai_da_tra : 0;
				$total_transaction_tat_toan_phi_da_tra += !empty($item->so_tien_phi_da_tra) ? $item->so_tien_phi_da_tra : 0;
			}
			$this->data['total_transaction_tat_toan_goc_da_tra'] = $total_transaction_tat_toan_goc_da_tra;
			$this->data['total_transaction_tat_toan_lai_da_tra'] = $total_transaction_tat_toan_lai_da_tra;
			$this->data['total_transaction_tat_toan_phi_da_tra'] = $total_transaction_tat_toan_phi_da_tra;
		}
		$this->data['countGiaoDichTatToanChoDuyet'] = $countGiaoDichTatToanChoDuyet->count;
		$this->data['dataTatToanPart1'] = $tabTatToanPart1->data;
		$this->data['dataTatToanPart2'] = $tabTatToanPart2;
		//	Lấy lãi trừ vào kỳ cuối (áp dụng coupon)
		$data_api_reduced_profit = [
			'code_contract' => $contract->data->code_contract,
			'code_coupon' => $contract->data->loan_infor->code_coupon,
			'date_pay' => strtotime(trim($date_pay) . ' 23:59:59')
		];
		$reduced_profit = $this->api->apiPost($this->userInfo['token'], "contract/get_interest_end_period_by_coupon", $data_api_reduced_profit);
		if (isset($reduced_profit->status) && $reduced_profit->status == 200) {
			$reduced_profit_cal = $reduced_profit->data;
		} else {
			$reduced_profit_cal = 0;
		}
		$expire_date = date("Y-m-d", $contract->data->expire_date);
		$this->data['reduced_profit_cal'] = 0;
		if ($date_pay == $expire_date) {
			if ($reduced_profit_cal > 0) {
				$this->data['reduced_profit_cal'] = $reduced_profit_cal;
			} else {
				$this->data['reduced_profit_cal'] = 0;
			}
		}

		if (!empty($return->status) && $return->status == 200) {
			$this->data['contract'] = $return->contract;
			$this->pushJson('200', json_encode(array("status" => "200", "msg" => 'Lấy dữ liệu thành công', 'data' => $this->data)));
			return;

		} else {
			$this->pushJson('200', json_encode(array("status" => "401", "msg" => $return->message)));
			return;
		}
	}

	public function view()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		if (empty($id)) {
			$this->session->set_flashdata('error', $this->lang->line('not_exist_contract'));
			redirect(base_url('accountant'));
			return;
		}
		$data = array(
			"id" => $id
		);
		$contractData = $this->api->apiPost($this->userInfo['token'], "view_payment/tempo_detail", $data);
		$isDaTatToan = false;
		$address = '';
		$addressSHK = '';
		if (!empty($contractData->status) && $contractData->status == 200) {
			$this->data['contractData'] = $contractData->data;
			$this->data['contractDB'] = $contractData->contract;
			if ($contractData->contract->status == 19) $isDaTatToan = true;
			//Start Địa chỉ đang ở
			$districtSelected = $contractData->contract->current_address->district;
			$wardSelected = $contractData->contract->current_address->ward;
			$current_address = $contractData->contract->current_address->current_stay;
			$wardData = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtSelected));
			if (!empty($wardData->status) && $wardData->status == 200) {
				foreach ($wardData->data as $w) {
					if ($w->code == $wardSelected) {
						$address = $current_address . ', ' . $w->path_with_type;
						break;
					}
				}
			}
			//Start Địa chỉ shk
			$districtHousehold = $contractData->contract->houseHold_address->district;
			$wardHousehold = $contractData->contract->houseHold_address->ward;
			$household_address = $contractData->contract->houseHold_address->address_household;
			$wardDataHousehold = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtHousehold));
			if (!empty($wardDataHousehold->status) && $wardDataHousehold->status == 200) {
				foreach ($wardDataHousehold->data as $w) {
					if ($w->code == $wardHousehold) {
						$addressSHK = $household_address . ', ' . $w->path_with_type;
						break;
					}
				}
			}
			//End
		} else {
			$this->data['contractData'] = array();
			$this->data['contractDB'] = array();
		}
		$check_isset_gh = 0;
		$check_isset_cc = 0;
		$historyData = $this->api->apiPost($this->userInfo['token'], "transaction/history_contract", $data);
		if (!empty($historyData->status) && $historyData->status == 200) {
			$this->data['historyData'] = $historyData->data;
			foreach ($historyData->data as $key => $value) {
				if (!empty($value->type_payment)) {
					if ($value->type_payment == 2 && $value->status != 3)
						$check_isset_gh = 1;
					if ($value->type_payment == 3 && $value->status != 3)
						$check_isset_cc = 1;

				}
				if (in_array($value->status, [2, 4]))
					$check_dang_xl = 1;

			}
		} else {
			$this->data['historyData'] = array();
		}
		$coupon_bhkv = $this->api->apiPost($this->userInfo['token'], "coupon_bhkv/get_all_ceo", $data);
		if (!empty($coupon_bhkv->status) && $coupon_bhkv->status == 200) {
			$this->data['coupon_bhkv'] = $coupon_bhkv->data;
		} else {
			$this->data['coupon_bhkv'] = array();
		}
		$debtData = $this->api->apiPost($this->userInfo['token'], "view_payment/debt_detail", $data);
		if (!empty($debtData->status) && $debtData->status == 200) {
			$this->data['debtData'] = $debtData->data;
		} else {
			$this->data['debtData'] = array();
		}
		//list contract extension
		$sendApi = array(
			"id" => $id
		);
		$contractExtensionData = $this->api->apiPost($this->userInfo['token'], "contract/get_contract_extension_by_contractParent", $sendApi);
		$this->data['contractExtensionData'] = $contractExtensionData;
		$this->data['address'] = $address;
		$this->data['addressSHK'] = $addressSHK;
		$this->data['contract_id'] = $id;
		$this->data['template'] = 'page/accountant/debt_detail';

		$result = $this->api->apiPost($this->userInfo['token'], "contract/get_image_accurecy", $data);
		$this->data['result'] = $result->data;

		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", $data);
		$this->data['contractInfor'] = $contract->data;
		$this->data['role'] = (in_array('tbp-thu-hoi-no', $contract->groupRoles)) ? "tbp-thu-hoi-no" : "";
		//get hình thức vay
		$configuration_formality = $this->api->apiPost($this->userInfo['token'], "configuration_formality/get_configuration_formality");
		if (!empty($configuration_formality->status) && $configuration_formality->status == 200) {
			$this->data['configuration_formality'] = $configuration_formality->data;
		} else {
			$this->data['configuration_formality'] = array();
		}
		//get property main ( tài sản cấp cao nhất parenid == null)
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main");
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$this->data['mainPropertyData'] = $mainPropertyData->data;
		} else {
			$this->data['mainPropertyData'] = array();
		}
		//Init loan infor
		$arrMinus = array();
		if (!empty($contract->data->loan_infor->decreaseProperty)) {
			$decreaseProperty = $contract->data->loan_infor->decreaseProperty;
			foreach ($decreaseProperty as $item) {
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
		if (!empty($provinceData->status) && $provinceData->status == 200) {
			$this->data['provinceData'] = $provinceData->data;
		} else {
			$this->data['provinceData'] = array();
		}
		$districtData = $this->api->apiPost($this->userInfo['token'], "province/get_district_by_province", array("id" => $provinceSelected));
		if (!empty($districtData->status) && $districtData->status == 200) {
			$this->data['districtData'] = $districtData->data;
		} else {
			$this->data['districtData'] = array();
		}
		$wardData = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtSelected));
		if (!empty($wardData->status) && $wardData->status == 200) {
			$this->data['wardData'] = $wardData->data;
		} else {
			$this->data['wardData'] = array();
		}
		//End
		//Start Địa chỉ hộ khẩu
		$provinceSelected_ = $contract->data->houseHold_address->province;
		$districtSelected_ = $contract->data->houseHold_address->district;
		$provinceData_ = $this->api->apiPost($this->userInfo['token'], "province/get_province");
		if (!empty($provinceData_->status) && $provinceData_->status == 200) {
			$this->data['provinceData_'] = $provinceData_->data;
		} else {
			$this->data['provinceData_'] = array();
		}
		//get district by province
		$districtData_ = $this->api->apiPost($this->userInfo['token'], "province/get_district_by_province", array("id" => $provinceSelected_));
		if (!empty($districtData_->status) && $districtData_->status == 200) {
			$this->data['districtData_'] = $districtData_->data;
		} else {
			$this->data['districtData_'] = array();
		}
		//get ward by district
		$wardData_ = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtSelected_));
		if (!empty($wardData_->status) && $wardData_->status == 200) {
			$this->data['wardData_'] = $wardData_->data;
		} else {
			$this->data['wardData_'] = array();
		}
		//End
		$log = $this->api->apiPost($this->userInfo['token'], "log/get_log_contract", array("contract_id" => $id));
		if (!empty($log->status) && $log->status == 200) {
			$this->data['logs'] = $log->data;
		} else {
			$this->data['logs'] = array();
		}

		$log_reminder = $this->api->apiPost($this->userInfo['token'], "contract/log_reminder_contract", array("id_contract" => $id));
		if (!empty($log_reminder->status) && $log_reminder->status == 200) {
			$this->data['reminders'] = $log_reminder->data;
		} else {
			$this->data['reminders'] = array();
		}

		//Dữ liệu cho tab tất toán
		$tabTatToanPart1 = $this->api->apiPost($this->userInfo['token'], "view_payment/get_infor_tat_toan_part_1", array("code_contract" => $contract->data->code_contract, "date_pay" => $date_pay));
		$tabTatToanPart2 = $this->api->apiPost($this->userInfo['token'], "view_payment/get_infor_tat_toan_part_2", array("code_contract" => $contract->data->code_contract, "date_pay" => $date_pay));

		$countGiaoDichThanhToanChoDuyet = $this->api->apiPost($this->userInfo['token'], "view_payment/countGiaoDichThanhToanChoDuyet", array("code_contract" => $contract->data->code_contract));
		$countGiaoDichTatToanChoDuyet = $this->api->apiPost($this->userInfo['token'], "view_payment/countGiaoDichTatToanChoDuyet", array("code_contract" => $contract->data->code_contract));
		if ($isDaTatToan == true) {
			$contractDataTatToan = $this->api->apiPost($this->userInfo['token'], "view_payment/get_bang_lai_ky_tat_toan", array("code_contract" => $contract->data->code_contract));
			$this->data['contractDataTatToan'] = $contractDataTatToan->data;
			//Get transaction_thanh_toan_lai_ky_tai_ki_tat_toan
			$transaction_thanh_toan_lai_ky_tai_ki_tat_toan = $this->api->apiPost($this->userInfo['token'], "view_payment/get_transaction_thanh_toan_lai_ky_tai_ky_tat_toan", array("code_contract" => $contract->data->code_contract));
			$transaction_thanh_toan_lai_ky_tai_ki_tat_toan = (array)$transaction_thanh_toan_lai_ky_tai_ki_tat_toan->data;
			$total_transaction_tat_toan_goc_da_tra = 0;
			$total_transaction_tat_toan_lai_da_tra = 0;
			$total_transaction_tat_toan_phi_da_tra = 0;
			foreach ($transaction_thanh_toan_lai_ky_tai_ki_tat_toan as $item) {
				$total_transaction_tat_toan_goc_da_tra += !empty($item->so_tien_goc_da_tra) ? $item->so_tien_goc_da_tra : 0;
				$total_transaction_tat_toan_lai_da_tra += !empty($item->so_tien_lai_da_tra) ? $item->so_tien_lai_da_tra : 0;
				$total_transaction_tat_toan_phi_da_tra += !empty($item->so_tien_phi_da_tra) ? $item->so_tien_phi_da_tra : 0;
			}
			$this->data['total_transaction_tat_toan_goc_da_tra'] = $total_transaction_tat_toan_goc_da_tra;
			$this->data['total_transaction_tat_toan_lai_da_tra'] = $total_transaction_tat_toan_lai_da_tra;
			$this->data['total_transaction_tat_toan_phi_da_tra'] = $total_transaction_tat_toan_phi_da_tra;
		}
		$data_send_log = [
			'code_contract' => $contract->data->code_contract
		];

		//	Lấy ngày đến hạn và kỳ trả hiện tại chưa gạch nợ gần nhất (tính từ ngày giải ngân) từ bảng temporary_plan_contract
		$period_contract = $this->api->apiPost($this->userInfo['token'], 'exemptions/get_current_period',$data_send_log);
		$ky_tra_hien_tai = 0;
		$ngay_den_han = 0;
		if (!empty($period_contract->status) && $period_contract->status == 200) {
			$ky_tra_hien_tai = $period_contract->ky_tra_hien_tai;
			$ngay_den_han = $period_contract->ngay_den_han;
			$this->data['ky_tra_hien_tai'] = $ky_tra_hien_tai;
			$this->data['ngay_den_han'] = $ngay_den_han;
		}

		//	Lấy đơn miễn giảm của kỳ hiện tại
		$exemption_contract = $this->api->apiPost($this->userInfo['token'],'exemptions/get_all',$data_send_log);

		if (!empty($exemption_contract->status) && $exemption_contract->status == 200) {
			foreach ($exemption_contract->contract as $key => $contract_ex) {
                 $type_payment_exem= (!empty($contract_ex->type_payment_exem) && $contract_ex->type_payment_exem==2) ? 2 : 1;
				if ($contract_ex->ky_tra == $ky_tra_hien_tai && $type_payment_exem==1) {
					$this->data['exemption_contract'] = $contract_ex;
					
				}else if($type_payment_exem==2){
					$this->data['exemption_contract'] = $contract_ex;
			
				}
			}
			$this->data['exemption_contract_all'] = $exemption_contract->contract;
		}
		//	Lấy transaction đã áp dụng miễn giảm
		$data_api_discount = [
			'code_contract' => $contract->data->code_contract,
			'ky_tra_hien_tai' => $ky_tra_hien_tai,
		];
		$transaction_discount = $this->api->apiPost($this->userInfo['token'], 'exemptions/get_transaction_discount',$data_api_discount);
		if (!empty($transaction_discount->status) && $transaction_discount->status == 200) {
			$this->data['issetTransactionDiscount'] = $transaction_discount->check_discount;
		} else {
			$this->data['issetTransactionDiscount'] = array();
		}

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
		//	Lấy log của đơn miễn giảm
		$exemption_contract_log = $this->api->apiPost($this->userInfo['token'],'exemptions/get_log',$data_send_log);

		if (isset($exemption_contract_log->status) && $exemption_contract_log->status == 200) {
			$this->data['exemption_contract_log'] = $exemption_contract_log->contract;
		} else {
			$this->data['exemption_contract_log'] = [];
		}
		//	Lấy lãi trừ vào kỳ cuối (áp dụng coupon)
		$data_api_reduced_profit = [
			'code_contract' => $contract->data->code_contract,
			'code_coupon' => $contract->data->loan_infor->code_coupon,
			'date_pay' => $this->data['contractDB']->date_pay,
		];
		$date_pay = !empty($this->data['contractDB']->date_pay) ? date("Y-m-d", $this->data['contractDB']->date_pay) : date("Y-m-d");
		$expire_date = !empty($this->data['contractDB']->expire_date) ? date("Y-m-d", $this->data['contractDB']->expire_date) : '';
		$reduced_profit = $this->api->apiPost($this->userInfo['token'], "contract/get_interest_end_period_by_coupon", $data_api_reduced_profit);
		if (isset($reduced_profit->status) && $reduced_profit->status == 200) {
			if ($date_pay == $expire_date) {
				$this->data['reduced_profit'] = $reduced_profit->data;
			}
		} else {
			$this->data['reduced_profit'] = 0;
		}
		$transactionExemption = $this->api->apiPost($this->userInfo['token'], 'Transaction/getTransactionExemptionApproved', $data_send_log);
		if (isset($transactionExemption->data)) {
			$this->data['isTransactionExemptionsApproved'] = $transactionExemption->data;
		}

		$this->data['detail'] = 1;

		$this->data['countGiaoDichThanhToanChoDuyet'] = $countGiaoDichThanhToanChoDuyet->count;
		$this->data['countGiaoDichTatToanChoDuyet'] = $countGiaoDichTatToanChoDuyet->count;
		$this->data['dataTatToanPart1'] = $tabTatToanPart1->data;
		$this->data['dataTatToanPart2'] = $tabTatToanPart2;
		$this->data['dataInit'] = $dataLoanInfor;
		$this->data['check_isset_gh'] = $check_isset_gh;
		$this->data['check_isset_cc'] = $check_isset_cc;
		$this->data['check_dang_xl'] = $check_dang_xl;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;
	}

	public function doPayment()
	{
		$data = $this->input->post();
		$data['code_contract'] = !empty($data['code_contract']) ? $this->security->xss_clean($data['code_contract']) : "";
		$data['phi_phat_sinh'] = !empty($data['phi_phat_sinh']) ? $this->security->xss_clean($data['phi_phat_sinh']) : "";
		$data['payment_name'] = !empty($data['payment_name']) ? $this->security->xss_clean($data['payment_name']) : "";
		$data['payment_note'] = !empty($data['payment_note']) ? $this->security->xss_clean($data['payment_note']) : "";
		$data['relative_with_contract_owner'] = !empty($data['relative_with_contract_owner']) ? $this->security->xss_clean($data['relative_with_contract_owner']) : "";
		$data['payment_phone'] = !empty($data['payment_phone']) ? $this->security->xss_clean($data['payment_phone']) : "";
		$data['payment_amount'] = !empty($data['payment_amount']) ? $this->security->xss_clean($data['payment_amount']) : 0;
		$data['payment_method'] = !empty($data['payment_method']) ? $this->security->xss_clean($data['payment_method']) : "";
		$data['reduced_fee'] = !empty($data['reduced_fee']) ? $this->security->xss_clean($data['reduced_fee']) : 0;
		$data['discounted_fee'] = !empty($data['discounted_fee']) ? $this->security->xss_clean($data['discounted_fee']) : 0;
		$data['other_fee'] = !empty($data['other_fee']) ? $this->security->xss_clean($data['other_fee']) : 0;
		$data['penalty_pay'] = !empty($data['penalty_pay']) ? $this->security->xss_clean($data['penalty_pay']) : 0;
		$data['valid_amount_payment'] = !empty($data['valid_amount_payment']) ? $this->security->xss_clean($data['valid_amount_payment']) : 0;
		$data['fee_reduction'] = !empty($data['fee_reduction']) ? $this->security->xss_clean($data['fee_reduction']) : 0;
		$data['date_pay'] = !empty($data['date_pay']) ? $this->security->xss_clean($data['date_pay']) : "";
		$data['fee_need_gh_cc'] = !empty($data['fee_need_gh_cc']) ? $this->security->xss_clean($data['fee_need_gh_cc']) : "";
		$store_id = !empty($data['store_id']) ? $this->security->xss_clean($data['store_id']) : "";
		$store_name = !empty($data['store_name']) ? $this->security->xss_clean($data['store_name']) : "";
		$type_payment = !empty($data['type_payment']) ? $this->security->xss_clean($data['type_payment']) : "";
		$amount_debt_cc = !empty($data['amount_debt_cc']) ? $this->security->xss_clean($data['amount_debt_cc']) : "";
		$amount_cc = !empty($data['amount_cc']) ? $this->security->xss_clean($data['amount_cc']) : "";
		$ky_tra_hien_tai = !empty($data['ky_tra_hien_tai']) ? $this->security->xss_clean($data['ky_tra_hien_tai']) : "";
		$ngay_den_han = !empty($data['ngay_den_han']) ? $this->security->xss_clean($data['ngay_den_han']) : "";
		$id_exemption = !empty($data['id_exemption']) ? $this->security->xss_clean($data['id_exemption']) : "";

		$contractDB = $this->api->apiPost($this->userInfo['token'], "contract/get_one_by_code_contract", array('code_contract' => $data['code_contract']));
		if (!empty($contractDB->status) && $contractDB->status == 200) {
			if ($contractDB->data->status == 29) {
				if ($type_payment == 1) {
					$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn phải chọn loại phiếu thu Gia hạn!")));
					return;
				}
			}
			if ($contractDB->data->status == 31) {
				if ($type_payment == 1) {
					$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn phải chọn loại phiếu thu Cơ cấu!")));
					return;
				}
			}
		}
		if (empty($data['code_contract'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Không được để trống mã phiếu ghi")));
			return;
		}
		if (empty($data['payment_name'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa nhập tên người thanh toán!")));
			return;
		}
		if (empty($data['payment_phone'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa nhập số điện thoại")));
			return;
		}
		if (!preg_match("/^[0-9]{10,12}$/", $data['payment_phone'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "msg" => $this->lang->line('phone_number_not_in_correct_format'))));
			return;
		}

		if (empty($data['relative_with_contract_owner'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa nhập tên mối quan hệ với chủ hợp đồng!")));
			return;
		}
		if (empty($data['payment_method'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "msg" => 'Phương thức thanh toán không được để trống')));
			return;
		}
		if (empty($data['payment_amount']) && $data['type_payment'] == 1) {
			$this->pushJson('200', json_encode(array("status" => "400", "msg" => 'Số tiền thanh toán không được để trống!')));
			return;
		}
		if ($data['type_payment'] == 3 && $data['amount_debt_cc'] > 0) {
			$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Tiền khách hàng thanh toán + tiền khách hàng cơ cấu phải lớn hơn hoặc bằng số tiền hợp lệ cơ cấu ")));
			return;
		}
		if ($data['type_payment'] == 2 && ($data['payment_amount'] < $data['fee_need_gh_cc'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "msg" => 'Số tiền thanh toán phải lớn hơn hơn hoặc bằng số tiền lãi phí cần để gia hạn/ cơ cấu')));
			return;
		}
		if (empty($data['payment_note'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "msg" => 'Bạn chưa chọn nội dung thu tiền!')));
			return;
		}

		//Encrypt TripleDes
		$libTripleDes = new TripleDes();
		// $secretKey = $libTripleDes->Encrypt(json_encode($data), $this->config->item("TRIPLEDES_KEY_TRANSACTION_CONTRACT"));
		$dataPost = array(
			"amount" => $data['payment_amount'],
			"valid_amount" => $data['valid_amount_payment'],
			"reduced_fee" => $data['reduced_fee'],
			"discounted_fee" => $data['discounted_fee'],
			"other_fee" => $data['other_fee'],
			"fee_reduction" => $data['fee_reduction'],
			"penalty_pay" => $data['penalty_pay'],
			"name" => $data['payment_name'],
			"type_payment" => $data['type_payment'],
			"name_relative" => $data['relative_with_contract_owner'],
			"phone" => $data['payment_phone'],
			"note" => !empty($data['payment_note']) ? $data['payment_note'] : '',
			"code_contract" => $data['code_contract'],
			"phi_phat_sinh" => $data['phi_phat_sinh'],
			"payment_method" => $data['payment_method'],// 1:tiền mặt, 2// ck
			"type_pt" => 4, // thanh toan ky lai
			"date_pay" => $data['date_pay'],
			"store" => array(
				'id' => $store_id,
				'name' => $store_name,
			),
			"amount_debt_cc" => $data['amount_debt_cc'],
			"amount_cc" => $data['amount_cc'],
			"ky_tra_hien_tai" => $data['ky_tra_hien_tai'],
			"ngay_den_han" => $data['ngay_den_han'],
			"id_exemption" => $data['id_exemption']

		);
		// if (!empty($data['code_contract'])) {
		// 		$dt_contract = $this->api->apiPost($this->user['token'], "caculator/get_one_contract", array('field' => 'code_contract', 'value' =>$data['code_contract']));
		// 	}

		// $id_contract = !empty($dt_contract->data->_id->{'$oid'}) ? $dt_contract->data->_id->{'$oid'} : "";
		//  $return_tattoan = $this->api->apiPost($this->user['token'], "payment/get_payment_all_contract", ['id'=>$id_contract,"date_pay"=>$data['date_pay']]);
		//  if (!empty($return_tattoan->status) && $return_tattoan->status == 200 && $data['type_payment']==1) {
		//  	if ( (int)$return_tattoan->tong_tien_tat_toan<=$data['payment_amount']) {
		//  		$dataPost['type_pt']=3;
		//  	}
		//  }
		$return = $this->api->apiPost($this->user['token'], "transaction/payment_contract", $dataPost);

		if (!empty($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("status" => "200", "msg" => "Đang khởi tạo biên nhận!", 'url' => $return->url, 'url_printed' => $return->url_printed, 'transaction_id' => $return->transaction_id)));
			return;

		} else {
			$this->pushJson('200', json_encode(array("status" => "401", "msg" => $this->lang->line('Create_failed_transaction'))));
			return;
		}

	}

	public function doFinishContract()
	{
		$data = $this->input->post();
		$data['code_contract'] = !empty($data['code_contract']) ? $this->security->xss_clean($data['code_contract']) : "";
		$data['phi_phat_sinh'] = !empty($data['phi_phat_sinh']) ? $this->security->xss_clean($data['phi_phat_sinh']) : "";
		$data['payment_name'] = !empty($data['payment_name']) ? $this->security->xss_clean($data['payment_name']) : "";
		$data['payment_note'] = !empty($data['payment_note']) ? $this->security->xss_clean($data['payment_note']) : "";
		$data['relative_with_contract_owner_finish'] = !empty($data['relative_with_contract_owner_finish']) ? $this->security->xss_clean($data['relative_with_contract_owner_finish']) : "";
		$data['payment_phone'] = !empty($data['payment_phone']) ? $this->security->xss_clean($data['payment_phone']) : "";
		$data['payment_amount'] = !empty($data['payment_amount']) ? $this->security->xss_clean($data['payment_amount']) : "";
		$data['fee_reduction'] = !empty($data['fee_reduction']) ? $this->security->xss_clean($data['fee_reduction']) : "";
		$data['payment_method'] = !empty($data['payment_method']) ? $this->security->xss_clean($data['payment_method']) : "";

		$data['reduced_fee'] = !empty($data['reduced_fee']) ? $this->security->xss_clean($data['reduced_fee']) : 0;
		$data['discounted_fee'] = !empty($data['discounted_fee']) ? $this->security->xss_clean($data['discounted_fee']) : 0;
		$data['other_fee'] = !empty($data['other_fee']) ? $this->security->xss_clean($data['other_fee']) : 0;
		$data['penalty_pay'] = !empty($data['penalty_pay']) ? $this->security->xss_clean($data['penalty_pay']) : 0;
		$data['valid_amount_payment'] = !empty($data['valid_amount_payment']) ? $this->security->xss_clean($data['valid_amount_payment']) : 0;
		$data['date_pay'] = !empty($data['date_pay']) ? $this->security->xss_clean($data['date_pay']) : "";
		$store_id = !empty($data['store_id']) ? $this->security->xss_clean($data['store_id']) : "";
		$store_name = !empty($data['store_name']) ? $this->security->xss_clean($data['store_name']) : "";
		$id_exemption = !empty($data['id_exemption']) ? $this->security->xss_clean($data['id_exemption']) : "";

		if (empty($data['payment_name'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa nhập tên người thanh toán!")));
			return;
		}
		if (empty($data['payment_phone'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "msg" => $this->lang->line('Phone_number_cannot_empty'))));
			return;
		}
		if (!preg_match("/^[0-9]{10,12}$/", $data['payment_phone'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "msg" => $this->lang->line('phone_number_not_in_correct_format'))));
			return;
		}
		if (empty($data['relative_with_contract_owner_finish'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa nhập tên mối quan hệ với chủ hợp đồng!")));
			return;
		}
		if (empty($data['payment_method'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "msg" => 'Phương thức thanh toán không được để trống')));
			return;
		}

		// if(empty($data['fee_reduction'])){
		// 	$this->pushJson('200', json_encode(array("status" => "400", "msg" => 'Phí giảm trừ không được để trống')));
		// 	return;
		// }
		
		if ((int)$data['payment_amount'] + 5 < (int)$data['valid_amount_payment']) {
			$this->pushJson('200', json_encode(array("status" => "400", "msg" => 'Số tiền tất toán không được nhỏ hơn số tiền hợp lệ ')));
			return;
		}
		if (empty($data['payment_note'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "msg" => 'Bạn chưa chọn nội dung thu tiền!')));
			return;
		}


		//Encrypt TripleDes
		$libTripleDes = new TripleDes();
		// $secretKey = $libTripleDes->Encrypt(json_encode($data), $this->config->item("TRIPLEDES_KEY_TRANSACTION_CONTRACT"));
		$dataPost = array(
			"amount" => $data['payment_amount'],
			"fee_reduction" => $data['fee_reduction'],
			"valid_amount" => $data['valid_amount_payment'],
			"reduced_fee" => $data['reduced_fee'],
			"discounted_fee" => $data['discounted_fee'],
			"id_exemption" => $data['id_exemption'],
			"other_fee" => $data['other_fee'],
			"penalty_pay" => $data['penalty_pay'],
			"name" => $data['payment_name'],
			"name_relative_finish" => $data['relative_with_contract_owner_finish'],
			"phone" => $data['payment_phone'],
			"note" => !empty($data['payment_note']) ? $data['payment_note'] : '',
			"code_contract" => $data['code_contract'],
			"payment_method" => $data['payment_method'],// 1:tiền mặt, 2// ck
			"type_pt" => 3, // tat toan
			"phi_phat_sinh" => $data['phi_phat_sinh'],
			"date_pay" => $data['date_pay'],
			"store" => array(
				'id' => $store_id,
				'name' => $store_name,
			),
			"type_payment" => 1, // 1: thanh toán, 2: gia hạn, 3: cơ cấu, 4: Thanh toán hợp đồng đã thanh lý tài sản

		);
		$return = $this->api->apiPost($this->user['token'], "transaction/payment_finish_contract", $dataPost);
		if (!empty($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("status" => "200", "msg" => "Đang khởi tạo biên nhận!", 'url' => $return->url, 'url_printed' => $return->url_printed, 'transaction_id' => $return->transaction_id)));
			return;

		} else {
			$this->pushJson('200', json_encode(array("status" => "401", "msg" => $return->message, "return" => $return)));
			return;
		}

	}

	public function renewalContinues()
	{
		$data = $this->input->post();
		$data['id'] = !empty($data['id']) ? $this->security->xss_clean($data['id']) : "";
		$data['code_contract'] = !empty($data['code_contract']) ? $this->security->xss_clean($data['code_contract']) : "";

		$data['payment_name'] = !empty($data['customer_name']) ? $this->security->xss_clean($data['customer_name']) : "";
		$data['payment_phone'] = !empty($data['customer_phone_number']) ? $this->security->xss_clean($data['customer_phone_number']) : "";
		$data['amount_money'] = !empty($data['amount_money']) ? $this->security->xss_clean($data['amount_money']) : 0;
		$data['fee_extend'] = !empty($data['fee_extend']) ? $this->security->xss_clean($data['fee_extend']) : 0;
		$data['tong_phi_no'] = !empty($data['tong_phi_no']) ? $this->security->xss_clean($data['tong_phi_no']) : 0;
		$data['payment_amount_total'] = !empty($data['tong_thanh_toan']) ? $this->security->xss_clean($data['tong_thanh_toan']) : 0;
		$data['payment_amount'] = !empty($data['so_tien_thanh_toan']) ? $this->security->xss_clean($data['so_tien_thanh_toan']) : 0;
		$data['store_id'] = !empty($data['store_id']) ? $this->security->xss_clean($data['store_id']) : "";
		$data['store_name'] = !empty($data['store_name']) ? $this->security->xss_clean($data['store_name']) : "";
		$data['payment_method'] = !empty($data['payment_method']) ? $this->security->xss_clean($data['payment_method']) : "";//type = 1 => thanh toán = tiền

		$data['renewal_number'] = !empty($data['renewal_number']) ? $this->security->xss_clean($data['renewal_number']) : "";
		$data['reason'] = !empty($data['reason']) ? $this->security->xss_clean($data['reason']) : "";

		if (empty($data['code_contract'])) {
			$this->pushJson('200', json_encode(array("status" => "401", "msg" => $this->lang->line('Phone_number_cannot_empty'))));
			return;
		}
		if (!preg_match("/^[0-9]{9,11}$/", $data['payment_phone'])) {
			$this->pushJson('200', json_encode(array("status" => "401", "msg" => $this->lang->line('phone_number_not_in_correct_format'))));
			return;
		}
		if (empty($data['payment_name'])) {
			$this->pushJson('200', json_encode(array("status" => "401", "msg" => $this->lang->line('Your_name_must_empty'))));
			return;
		}
		if (empty($data['payment_amount'])) {
			$this->pushJson('200', json_encode(array("status" => "401", "msg" => 'Số tiền thanh toán không được để trống')));
			return;
		}
		if (empty($data['payment_method'])) {
			$this->pushJson('200', json_encode(array("status" => "401", "msg" => 'Phương thức thanh toán không được để trống')));
			return;
		}
		//Encrypt TripleDes
		$libTripleDes = new TripleDes();
		// $secretKey = $libTripleDes->Encrypt(json_encode($data), $this->config->item("TRIPLEDES_KEY_TRANSACTION_CONTRACT"));
		$dataPost = array(
			"amount_total" => $data['payment_amount_total'],
			"amount" => $data['payment_amount'],
			'tong_phi_no' => $data['tong_phi_no'],
			"name" => $data['payment_name'],
			"phone" => $data['payment_phone'],
			"note" => $data['reason'],
			"type_pt" => 5,
			"code_contract" => $data['code_contract'],
			"payment_method" => $data['payment_method'],// 1:tiền mặt, 2// ck
			// "secret_key" => $secretKey,
			"store" => array(
				'id' => $data['store_id'],
				'name' => $data['store_name'],
			),
		);
		$return = $this->api->apiPost($this->user['token'], "transaction/payment_contract", $dataPost);
		if (!empty($return->status) && $return->status == 200) {
			//call api update trang thai hop đồng
			if ($data['payment_method'] == 1) {
				$status_contract = 21;
			} else {
				$status_contract = 24;
			}
			$sendApi = array(
				"id" => $data['id'],
				'description_infor' => "",
				'reason' => $data['reason'],
				'status_contract' => $status_contract
			);
			$returnApprove = $this->api->apiPost($this->user['token'], "contract/process_approve_extension", $sendApi);

			$this->pushJson('200', json_encode(array("status" => "200", "msg" => 'success', 'url' => $return->url, 'transaction_id' => $return->transaction_id)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("status" => "401", "msg" => "error")));
			return;
		}
	}

	public function renewalUpload()
	{
		$this->data["pageName"] = $this->lang->line('update_img_authentication');
		$dataGet = $this->input->get();
		// $dataGet['id'] = $this->security->xss_clean($dataGet['id']);
		// $dataPost = array(
		// 		"id" => $dataGet['id']
		// );
		// $result = $this->api->apiPost($this->userInfo['token'], "contract/get_image_accurecy", $dataPost);
		// $this->data['result'] = $result->data;
		$this->data['template'] = 'page/accountant/renewal_upload';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function caculator_monthly_fee()
	{
		$this->data["pageName"] = "Tính lãi tháng";
		$configuration_formality = $this->api->apiPost($this->userInfo['token'], "configuration_formality/get_configuration_formality");
		if (!empty($configuration_formality->status) && $configuration_formality->status == 200) {
			$this->data['configuration_formality'] = $configuration_formality->data;
		} else {
			$this->data['configuration_formality'] = array();
		}
		$stores = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active", []);
		
		if (!empty($stores->status) && $stores->status == 200) {
		
			$this->data['stores'] = $stores->data;
		}
		$areaData = $this->api->apiPost($this->userInfo['token'], "area/get_all", $data);
		if (!empty($areaData->status) && $areaData->status == 200) {
			$this->data['areaData'] = $areaData->data;
		} else {
			$this->data['areaData'] = array();
		}
		//get property main ( tài sản cấp cao nhất parenid == null)
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main");
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$this->data['mainPropertyData'] = $mainPropertyData->data;
		} else {
			$this->data['mainPropertyData'] = array();
		}
		$this->data['template'] = 'page/accountant/caculator/monthly_fee';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function process_caculator_monthly_fee()
	{
		$this->data["pageName"] = "Tính lãi tháng";
		$type_loan = !empty($_POST['type_loan']) ? $_POST['type_loan'] : "";
		$type_property = !empty($_POST['type_property']) ? $_POST['type_property'] : "";
		$amount_money = !empty($_POST['amount_money']) ? $_POST['amount_money'] : "";
		$ky_han = !empty($_POST['ky_han']) ? $_POST['ky_han'] : "";
		$hinh_thuc_tra_lai = !empty($_POST['hinh_thuc_tra_lai']) ? $_POST['hinh_thuc_tra_lai'] : "";
		$hinh_thuc_phi = !empty($_POST['hinh_thuc_phi']) ? $_POST['hinh_thuc_phi'] : "";
		$ngay_giai_ngan = !empty($_POST['ngay_giai_ngan']) ? $_POST['ngay_giai_ngan'] : "";
		$coupon = !empty($_POST['coupon']) ? $_POST['coupon'] : "";
		$ngay_tat_toan = !empty($_POST['ngay_tat_toan']) ? $_POST['ngay_tat_toan'] : "";
		$management_consulting_fee = !empty($_POST['management_consulting_fee']) ? $_POST['management_consulting_fee'] : "";
		$renewal_fee = !empty($_POST['renewal_fee']) ? $_POST['renewal_fee'] : "";
		$loan_interest_fee = !empty($_POST['loan_interest']) ? $_POST['loan_interest'] : "";
		$loan_product = !empty($_POST['loan_product']) ? $_POST['loan_product'] : "";


		$cond = array(
			"type_loan" => $type_loan,
			"type_property" => $type_property,
			"amount_money" => $amount_money,
			"ky_han" => $ky_han,
			"loan_interest" => $hinh_thuc_tra_lai,
			"hinh_thuc_phi" => $hinh_thuc_phi,
			"ngay_giai_ngan" => $ngay_giai_ngan,
			"coupon" => $coupon,
			"management_consulting_fee" => $management_consulting_fee,
			"renewal_fee" => $renewal_fee,
			"loan_interest_fee" => $loan_interest_fee,
			"ngay_tat_toan" => $ngay_tat_toan,
			"loan_product" => $loan_product


		);
		//var_dump($cond);die;
		$calucatorData = $this->api->apiPost($this->user['token'], "caculator/caculator_monthly_fee_w", $cond);
		if (!empty($calucatorData->status) && $calucatorData->status == 200) {
			$this->data['calucatorData'] = $calucatorData->data;
		} else {
			$this->data['calucatorData'] = array();
		}
		$response = [
			'res' => true,
			'code' => "200",
			'data' => $this->data['calucatorData']

		];
		echo json_encode($response);
		return;
	}

	public function caculator_charge_settlement()
	{
		$this->data["pageName"] = "Tính phí tất toán";
		$date = !empty($_GET['date']) ? $_GET['date'] : date('Y-m-d');
		$code_contract = !empty($_GET['code_contract']) ? trim($_GET['code_contract']) : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? trim($_GET['code_contract_disbursement']) : "";

		if (!empty($date) && (!empty($code_contract) || !empty($code_contract_disbursement))) {
			if (!empty($code_contract_disbursement)) {
				$dt_contract = $this->api->apiPost($this->user['token'], "caculator/get_one_contract", array('field' => 'code_contract_disbursement', 'value' => $code_contract_disbursement));
			}
			if (!empty($code_contract)) {
				$dt_contract = $this->api->apiPost($this->user['token'], "caculator/get_one_contract", array('field' => 'code_contract', 'value' => $code_contract));
			}

			$id_contract = !empty($dt_contract->data->_id->{'$oid'}) ? $dt_contract->data->_id->{'$oid'} : "";

			//var_dump($id_contract); die;
			if (!empty($id_contract)) {
				$data = array(
					"id" => $id_contract,
					"date_pay" => $date
				);
				$debtData = $this->api->apiPost($this->userInfo['token'], "view_payment/debt_detail", $data);
				if (!empty($debtData->status) && $debtData->status == 200) {
					$this->data['debtData'] = $debtData->data;
				} else {
					$this->data['debtData'] = array();
				}
				$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", $data);
				$contractData = $this->api->apiPost($this->userInfo['token'], "view_payment/tempo_detail", $data);
				if (!empty($contractData->status) && $contractData->status == 200) {
					$this->data['contractData'] = $contractData->data;
					$this->data['contractDB'] = $contractData->contract;
				}
				//Dữ liệu cho tab tất toán
				$tabTatToanPart1 = $this->api->apiPost($this->userInfo['token'], "view_payment/get_infor_tat_toan_part_1", array("code_contract" => $contract->data->code_contract, "date_pay" => $date));
				$tabTatToanPart2 = $this->api->apiPost($this->userInfo['token'], "view_payment/get_infor_tat_toan_part_2", array("code_contract" => $contract->data->code_contract, "date_pay" => $date));

				$countGiaoDichTatToanChoDuyet = $this->api->apiPost($this->userInfo['token'], "view_payment/countGiaoDichTatToanChoDuyet", array("code_contract" => $contract->data->code_contract));
				if ($isDaTatToan == true) {
					$contractDataTatToan = $this->api->apiPost($this->userInfo['token'], "view_payment/get_bang_lai_ky_tat_toan", array("code_contract" => $contract->data->code_contract));
					$this->data['contractDataTatToan'] = $contractDataTatToan->data;
					//Get transaction_thanh_toan_lai_ky_tai_ki_tat_toan
					$transaction_thanh_toan_lai_ky_tai_ki_tat_toan = $this->api->apiPost($this->userInfo['token'], "view_payment/get_transaction_thanh_toan_lai_ky_tai_ky_tat_toan", array("code_contract" => $contract->data->code_contract));
					$transaction_thanh_toan_lai_ky_tai_ki_tat_toan = (array)$transaction_thanh_toan_lai_ky_tai_ki_tat_toan->data;
					$total_transaction_tat_toan_goc_da_tra = 0;
					$total_transaction_tat_toan_lai_da_tra = 0;
					$total_transaction_tat_toan_phi_da_tra = 0;
					foreach ($transaction_thanh_toan_lai_ky_tai_ki_tat_toan as $item) {
						$total_transaction_tat_toan_goc_da_tra += !empty($item->so_tien_goc_da_tra) ? $item->so_tien_goc_da_tra : 0;
						$total_transaction_tat_toan_lai_da_tra += !empty($item->so_tien_lai_da_tra) ? $item->so_tien_lai_da_tra : 0;
						$total_transaction_tat_toan_phi_da_tra += !empty($item->so_tien_phi_da_tra) ? $item->so_tien_phi_da_tra : 0;
					}
					$this->data['total_transaction_tat_toan_goc_da_tra'] = $total_transaction_tat_toan_goc_da_tra;
					$this->data['total_transaction_tat_toan_lai_da_tra'] = $total_transaction_tat_toan_lai_da_tra;
					$this->data['total_transaction_tat_toan_phi_da_tra'] = $total_transaction_tat_toan_phi_da_tra;
				}
				$this->data['countGiaoDichTatToanChoDuyet'] = $countGiaoDichTatToanChoDuyet->count;
				$this->data['dataTatToanPart1'] = $tabTatToanPart1->data;
				$this->data['dataTatToanPart2'] = $tabTatToanPart2;
				$data_send_log = [
					'code_contract' => $contract->data->code_contract
				];
				//	Lấy ngày đến hạn và kỳ trả hiện tại chưa gạch nợ gần nhất (tính từ ngày giải ngân) từ bảng temporary_plan_contract
				$period_contract = $this->api->apiPost($this->userInfo['token'], 'exemptions/get_current_period',$data_send_log);
				$ky_tra_hien_tai = 0;
				$ngay_den_han = 0;
				if (!empty($period_contract->status) && $period_contract->status == 200) {
					$ky_tra_hien_tai = $period_contract->ky_tra_hien_tai;
					$ngay_den_han = $period_contract->ngay_den_han;
					$this->data['ky_tra_hien_tai'] = $ky_tra_hien_tai;
					$this->data['ngay_den_han'] = $ngay_den_han;
				}
				//	Lấy đơn miễn giảm của kỳ hiện tại
				$exemption_contract = $this->api->apiPost($this->userInfo['token'],'exemptions/get_all',$data_send_log);
				if (!empty($exemption_contract->status) && $exemption_contract->status == 200) {
					foreach ($exemption_contract->contract as $key => $contract_ex) {
						$type_payment_exem= (!empty($contract_ex->type_payment_exem) && $contract_ex->type_payment_exem==2) ? 2 : 1;
						if ($contract_ex->ky_tra == $ky_tra_hien_tai && $type_payment_exem==1) {
							$this->data['exemption_contract'] = $contract_ex;

						}else if($type_payment_exem==2){
							$this->data['exemption_contract'] = $contract_ex;

						}
					}
					$this->data['exemption_contract_all'] = $exemption_contract->contract;
				}
				//	Lấy transaction đã áp dụng miễn giảm
				$data_api_discount = [
					'code_contract' => $contract->data->code_contract,
					'ky_tra_hien_tai' => $ky_tra_hien_tai,
				];
				$transaction_discount = $this->api->apiPost($this->userInfo['token'], 'exemptions/get_transaction_discount',$data_api_discount);
				if (!empty($transaction_discount->status) && $transaction_discount->status == 200) {
					$this->data['issetTransactionDiscount'] = $transaction_discount->check_discount;
				} else {
					$this->data['issetTransactionDiscount'] = array();
				}
				//	Lấy lãi trừ vào kỳ cuối (áp dụng coupon)
				$data_api_reduced_profit = [
					'code_contract' => $contract->data->code_contract,
					'code_coupon' => $contract->data->loan_infor->code_coupon,
					'date_pay' => $date
				];
				$reduced_profit = $this->api->apiPost($this->userInfo['token'], "contract/get_interest_end_period_by_coupon_calculator", $data_api_reduced_profit);
				$date_pay = !empty($date) ? $date : date("Y-m-d");
				$expire_date = !empty($this->data['contractDB']->expire_date) ? date("Y-m-d", $this->data['contractDB']->expire_date) : '';
				if (isset($reduced_profit->status) && $reduced_profit->status == 200) {
					if ($date_pay == $expire_date) {
						$this->data['reduced_profit'] = $reduced_profit->data;
					}
				} else {
					$this->data['reduced_profit'] = 0;
				}
			} else {
				$this->session->set_flashdata('error', "Không tìm thấy thông tin hợp đồng, hoặc hợp đồng không ở trạng thái đang vay");
			}

		}
		$this->data['template'] = 'page/accountant/caculator/charge_settlement';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function report_debt_group_pgd()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$code_store = !empty($_GET['code_store']) ? $_GET['code_store'] : "";
		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('accountant/report_debt_group_pgd'));
		}
		$cond = array();
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$cond = array(
				"start" => $start,
				"end" => $end,
			);
		}

		if (!empty($code_store)) {
			$cond['code_store'] = $code_store;
		}

		$reportData = $this->api->apiPost($this->user['token'], "accountant/report_debt_group_pgd", $cond);
		if (!empty($reportData->status) && $reportData->status == 200) {
			$this->data['reportData'] = $reportData->data;
		} else {
			$this->data['reportData'] = array();
		}

		$storeData = $this->api->apiPost($this->user['token'], "store/get_all", []);
		if (!empty($storeData->status) && $storeData->status == 200) {
			$this->data['storeData'] = $storeData->data;
		} else {
			$this->data['storeData'] = array();
		}

		$this->data['store'] = (isset($_GET['code_store'])) ? $_GET['code_store'] : '';
		$this->data['storeData'] = $storeData->data;

		$this->data['template'] = 'page/accountant/report/debt_group_pgd';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function report_work_results()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$code_store = !empty($_GET['code_store']) ? $_GET['code_store'] : "";
		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('accountant/report_work_results'));
		}
		$cond = array();
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$cond = array(
				"start" => $start,
				"end" => $end,
			);
		}

		if (!empty($code_store)) {
			$cond['code_store'] = $code_store;
		}

		$reportData = $this->api->apiPost($this->user['token'], "accountant/report_work_results", $cond);
		if (!empty($cskhData->status) && $cskhData->status == 200) {
			$this->data['reportData'] = $reportData->data;
		} else {
			$this->data['reportData'] = array();
		}

		$storeData = $this->api->apiPost($this->user['token'], "store/get_all", []);
		if (!empty($storeData->status) && $storeData->status == 200) {
			$this->data['storeData'] = $storeData->data;
		} else {
			$this->data['storeData'] = array();
		}

		$this->data['store'] = (isset($_GET['code_store'])) ? $_GET['code_store'] : '';
		$this->data['storeData'] = $storeData->data;

		$this->data['template'] = 'page/accountant/report/work_results';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function report_general()
	{

		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$code_store = !empty($_GET['code_store']) ? $_GET['code_store'] : "";
		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('accountant/report_general'));
		}
		$cond = array();
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$cond = array(
				"start" => $start,
				"end" => $end,
			);
		}

		if (!empty($code_store)) {
			$cond['code_store'] = $code_store;
		}

		$reportData = $this->api->apiPost($this->user['token'], "accountant/report_general", $cond);
		if (!empty($cskhData->status) && $cskhData->status == 200) {
			$this->data['reportData'] = $reportData->data;
		} else {
			$this->data['reportData'] = array();
		}

		$storeData = $this->api->apiPost($this->user['token'], "store/get_all", []);
		if (!empty($storeData->status) && $storeData->status == 200) {
			$this->data['storeData'] = $storeData->data;
		} else {
			$this->data['storeData'] = array();
		}

		$this->data['store'] = (isset($_GET['code_store'])) ? $_GET['code_store'] : '';
		$this->data['storeData'] = $storeData->data;

		$this->data['template'] = 'page/accountant/report/general';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function doRenewalContract()
	{
		$data = $this->input->post();
		$data['contractId'] = $this->security->xss_clean($data['contractId']);
		$descriptionrInfo = array();
		if (!empty($data['arrDescription'])) $descriptionrInfo = $this->security->xss_clean($data['arrDescription']);
		$renewal_continues = !empty($this->session->userdata('renewal_continues' . $data['contractId'])) ? $this->session->userdata('renewal_continues' . $data['contractId']) : "";
		$reason = !empty($renewal_continues['reason']) ? $renewal_continues['reason'] : "";

		//tao phiếu thu
		$libTripleDes = new TripleDes();
		//		$secretKey = $libTripleDes->Encrypt(json_encode($data), $this->config->item("TRIPLEDES_KEY_TRANSACTION_CONTRACT"));
		$dataPost = array(
			"amount" => $renewal_continues['payment_amount'],
			'tong_phi_no' => $renewal_continues['tong_phi_no'],
			"name" => $renewal_continues['payment_name'],
			"phone" => $renewal_continues['payment_phone'],
			"note" => $renewal_continues['reason'],
			"type_pt" => 5,
			"code_contract" => $renewal_continues['code_contract'],
			"payment_method" => $renewal_continues['payment_method'],// 1:tiền mặt, 2// ck
			//			"secret_key" => $secretKey,
			"store" => array(
				'id' => $renewal_continues['store_id'],
				'name' => $renewal_continues['store_name'],
			),

		);
		$return = $this->api->apiPost($this->user['token'], "transaction/payment_contract", $dataPost);

		if (!empty($return->status) && $return->status == 200) {
			$sendApi = array(
				"id" => $data['contractId'],
				'description_infor' => $descriptionrInfo,
				'reason' => $reason,
				'status_contract' => 24,
				'transaction_id' => $return->transaction_id
			);
			// unset($_SESSION['renewal_continues'.$data['contractId']]);
			$return = $this->api->apiPost($this->user['token'], "contract/process_approve_extension", $sendApi);
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));

		}

	}

	public function approve_gia_han()
	{
		$data = $this->input->post();

		$data['contractId'] = $this->security->xss_clean($data['contractId']);
		$data['status'] = $this->security->xss_clean($data['status']);
		$data['exception_gh'] = $this->security->xss_clean($data['exception_gh']);
		$data['image_file'] = $this->security->xss_clean($data['image_file']);
		$data['note'] = $this->security->xss_clean($data['note']);
		$data['number_day_loan'] = $this->security->xss_clean($data['number_day_loan']);
		$data['amount_money'] = $this->security->xss_clean($data['amount_money']);
		$data['type_loan'] = $this->security->xss_clean($data['type_loan']);

		$dataPost = array(
			"note" => $data['note'],
			"number_day_loan" => $data['number_day_loan'] * 30,
			"contract_id" => $data['contractId'],
			"status" => $data['status'],
			"exception" => $data['exception'],
			"image_file" => $data['image_file'],
			"amount_money" => $data['amount_money'],
			"type_loan" => $data['type_loan'],
		);
		$result = $this->api->apiPost($this->userInfo['token'], "contract/approve", $dataPost);
		if (!empty($result->status) && $result->status == 200) {
			//call api sinh hop đồng gia hạn
			$arrPost = array(
				"contract_id" => $data['contractId'],
				"number_day_loan" => $data['number_day_loan'] * 30,
			);
			$resultExtension = $this->api->apiPost($this->userInfo['token'], "contract_cc_gh/approve_gia_han", $arrPost);
			// var_dump($resultExtension);die;
			if (!empty($resultExtension->status) && $resultExtension->status == 200) {
				// call api tao bang sinh lai

				$disbursement_date = (int)$resultExtension->disbursement_date;
				$dataPost = array(
					"code_contract" => $resultExtension->data->code_contract,
					"investor_code" => $resultExtension->data->investor_code,
					"disbursement_date" => $disbursement_date,
					"secret_key" => "",
					"code_contract_disbursement_origin" => $resultExtension->data->code_contract_parent_gh,
				);
				$result = $this->api->apiPost($this->userInfo['token'], "generateContract/processContract", $dataPost);
				$this->api->apiPost($this->userInfo['token'], "transaction/generate_money_extend", $dataPost_dele);
				$this->api->apiPost($this->userInfo['token'], "transaction/payment_tien_thua_gh_cc", $dataPost_dele);


				if (!empty($result->status) && $result->status == 200) {
					$this->pushJson('200', json_encode(array("code" => "200", "msg" => $result->message, "data" => $result)));
					return;
				} else {
					$this->pushJson('200', json_encode(array("code" => "401", "msg" => $result->message, "data" => $result)));
					return;
				}

			} else {
				$this->pushJson('200', json_encode(array("code" => "401", "msg" => $resultExtension->message, "data" => $result)));
				return;
			}

		}

	}

	public function approve_co_cau()
	{
		$data = $this->input->post();

		$data['contractId'] = $this->security->xss_clean($data['contractId']);
		$data['status'] = $this->security->xss_clean($data['status']);
		$data['exception_gh'] = $this->security->xss_clean($data['exception_gh']);
		$data['image_file'] = $this->security->xss_clean($data['image_file']);
		$data['note'] = $this->security->xss_clean($data['note']);
		$data['number_day_loan'] = $this->security->xss_clean($data['number_day_loan']);
		$data['amount_money'] = $this->security->xss_clean($data['amount_money']);
		$data['type_loan'] = $this->security->xss_clean($data['type_loan']);
		$data['type_interest'] = $this->security->xss_clean($data['type_interest']);
		//$data['amount_debt_cc'] = $this->security->xss_clean($data['amount_debt_cc']);

		$dataPost = array(
			"note" => $data['note'],
			"number_day_loan" => $data['number_day_loan'] * 30,
			"contract_id" => $data['contractId'],
			"status" => $data['status'],
			"exception" => $data['exception'],
			"image_file" => $data['image_file'],
			"amount_money" => $data['amount_money'],
			"type_loan" => $data['type_loan'],

		);
		// var_dump($dataPost);die;
		$result = $this->api->apiPost($this->userInfo['token'], "contract/approve", $dataPost);
		if (!empty($result->status) && $result->status == 200) {
			//call api sinh hop đồng gia hạn
			$arrPost = array(
				"number_day_loan" => $data['number_day_loan'] * 30,
				"contract_id" => $data['contractId'],
				"status" => $data['status'],
				"amount_money" => $data['amount_money'],
				"type_loan" => $data['type_loan'],
				"type_interest" => $data['type_interest'],
			);
			$resultExtension = $this->api->apiPost($this->userInfo['token'], "contract_cc_gh/approve_co_cau", $arrPost);

			if (!empty($resultExtension->status) && $resultExtension->status == 200) {
				// call api tao bang sinh lai

				$disbursement_date = (int)$resultExtension->disbursement_date;
				$dataPost = array(
					"code_contract" => $resultExtension->data->code_contract,
					"investor_code" => $resultExtension->data->investor_code,
					"disbursement_date" => $disbursement_date,
					"secret_key" => "",
				);
				$result = $this->api->apiPost($this->userInfo['token'], "generateContract/processContract", $dataPost);
				if (!empty($result->status) && $result->status == 200) {
					$this->pushJson('200', json_encode(array("code" => "200", "msg" => $result->message, "data" => $result)));
					return;
				} else {
					$this->pushJson('200', json_encode(array("code" => "401", "msg" => $result->message, "data" => $result)));
					return;
				}

			} else {
				$this->pushJson('200', json_encode(array("code" => "401", "msg" => $resultExtension->message, "data" => $result)));
				return;
			}

		}

	}

	public function doUploadImage()
	{
		$data = $this->input->post();
		// $data['type_img'] = $this->security->xss_clean($data['type_img']);
		// $data['transaction_id'] = $this->security->xss_clean($data['transaction_id']);
		// $dataPost = array(
		// 	"id" => $data['transaction_id'],
		// 	"type_img" => $data['type_img'],
		// 	"file" => $_FILES['file']
		// );

		$extension = array();
		if (!empty($data['extension'])) $extension = $this->security->xss_clean($data['extension']);
		$sendApi = array(
			"id" => $data['transaction_id'],
			'image_extension' => $extension,
		);
		// var_dump($dataPost);die;
		$result = $this->api->apiPost($this->userInfo['token'], "transaction/upload_image_extension", $sendApi);
		$this->pushJson('200', json_encode(array("code" => "200", "data" => $result)));
	}

	public function updatePhone()
	{
		$contract_id = !empty($_POST['contract_id']) ? $_POST['contract_id'] : '';
		$customer_phone = !empty($_POST['customer_phone']) ? $_POST['customer_phone'] : '';
		$phone_1 = !empty($_POST['phone_1']) ? $_POST['phone_1'] : '';
		$phone_2 = !empty($_POST['phone_2']) ? $_POST['phone_2'] : '';
		$address_1 = !empty($_POST['address_1']) ? $_POST['address_1'] : '';
		$address_2 = !empty($_POST['address_2']) ? $_POST['address_2'] : '';
		$address = !empty($_POST['address']) ? $_POST['address'] : '';
		$contract_id = trim($contract_id);
		$phone_1 = trim($phone_1);
		$phone_2 = trim($phone_2);
		if (empty($contract_id)) {
			$this->pushJson('200', json_encode(array("status" => 400, "msg" => 'Mã hợp đồng không được trống')));
			return;
		}
		if (!empty($customer_phone) && strlen($customer_phone) < 10) {
			$this->pushJson('200', json_encode(array("status" => 400, "msg" => 'Số điện thoại khách hàng không đúng định dạng!')));
			return;
		}
		if (!empty($phone_1) && strlen($phone_1) < 10) {
			$this->pushJson('200', json_encode(array("status" => 400, "msg" => 'Số điện thoại người thân 1 không đúng định dạng!')));
			return;
		}
		if (!empty($phone_2) && strlen($phone_2) < 10) {
			$this->pushJson('200', json_encode(array("status" => 400, "msg" => 'Số điện thoại người thân 2 không đúng định dạng!')));
			return;
		}
		$sendApi = array(
			'contract_id' => $contract_id,
			'customer_phone' => $customer_phone,
			'phone_1' => $phone_1,
			'phone_2' => $phone_2,
			'address_1' => $address_1,
			'address_2' => $address_2,
			'address' => $address
		);

		$return = $this->api->apiPost($this->user['token'], "accountant/update_relative_infor", $sendApi);
		if (!empty($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("status" => 200, "msg" => 'Cập nhật thông tin hợp đồng thành công!')));
			return;
		} else {
			$this->pushJson('200', json_encode(array("status" => 400, "msg" => 'Cập nhật thông tin hợp đồng lỗi!')));
			return;
		}
	}

	private function pushJson($code, $data)
	{
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}

	public function contractInfo($id)
	{
		try {
			$id = $this->security->xss_clean($id);
			$condition = array("id" => $id);
			$contract = $this->api->apiPost($this->user['token'], "contract/get_one", $condition);
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $contract->data)));
		} catch (\Exception $exception) {
			show_404();
		}
	}

	public function approve_liquidations()
	{
		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['_id']) ? $this->security->xss_clean($data['_id']) : '';
		$data['code_contract'] = $this->security->xss_clean($data['code_contract']) ? $this->security->xss_clean($data['code_contract']) : '';
		$data['debt_remain_root'] = $this->security->xss_clean($data['debt_remain_root']) ? $this->security->xss_clean($data['debt_remain_root']) : '';
		$data['suggest_price'] = $this->security->xss_clean($data['suggest_price']) ? $this->security->xss_clean($data['suggest_price']) : '';
		$data['name_buyer'] = $this->security->xss_clean($data['name_buyer']) ? $this->security->xss_clean($data['name_buyer']) : '';
		$data['phone_number_buyer'] = $this->security->xss_clean($data['phone_number_buyer']) ? $this->security->xss_clean($data['phone_number_buyer']) : '';
		$data['image_file'] = $this->security->xss_clean($data['image_file']) ? $this->security->xss_clean($data['image_file']) : '';
		$data['note'] = $this->security->xss_clean($data['note']) ? $this->security->xss_clean($data['note']) : '';
		$data['status'] = $this->security->xss_clean($data['status']) ? $this->security->xss_clean($data['status']) : '';
		$data['action'] = $this->security->xss_clean($data['action']) ? $this->security->xss_clean($data['action']) : '';
		$data['data_send_approve'] = $this->security->xss_clean($data['data_send_approve']) ? $this->security->xss_clean($data['data_send_approve']) : '';
		$data['data_note_approve'] = $this->security->xss_clean($data['data_note_approve']) ? $this->security->xss_clean($data['data_note_approve']) : '';
		$data['date_seize'] = $this->security->xss_clean($data['date_seize']) ? $this->security->xss_clean($data['date_seize']) : '';
		$data['date_effect_bpdg'] = $this->security->xss_clean($data['date_effect_bpdg']) ? $this->security->xss_clean($data['date_effect_bpdg']) : '';
		$data['name_person_seize'] = $this->security->xss_clean($data['name_person_seize']) ? $this->security->xss_clean($data['name_person_seize']) : '';
		$data['license_plates'] = $this->security->xss_clean($data['license_plates']) ? $this->security->xss_clean($data['license_plates']) : '';
		$data['frame_number'] = $this->security->xss_clean($data['frame_number']) ? $this->security->xss_clean($data['frame_number']) : '';
		$data['engine_number'] = $this->security->xss_clean($data['engine_number']) ? $this->security->xss_clean($data['engine_number']) : '';
		$data['license_number'] = $this->security->xss_clean($data['license_number']) ? $this->security->xss_clean($data['license_number']) : '';
		$data['asset_name'] = $this->security->xss_clean($data['asset_name']) ? $this->security->xss_clean($data['asset_name']) : '';
		$data['asset_branch'] = $this->security->xss_clean($data['asset_branch']) ? $this->security->xss_clean($data['asset_branch']) : '';
		$data['number_km'] = $this->security->xss_clean($data['number_km']) ? $this->security->xss_clean($data['number_km']) : '';
		$data['asset_model'] = $this->security->xss_clean($data['asset_model']) ? $this->security->xss_clean($data['asset_model']) : '';
		$data['name_valuation'] = $this->security->xss_clean($data['name_valuation']) ? $this->security->xss_clean($data['name_valuation']) : '';
		$data['phone_valuation'] = $this->security->xss_clean($data['phone_valuation']) ? $this->security->xss_clean($data['phone_valuation']) : '';
		$data['price_suggest_bpdg'] = $this->security->xss_clean($data['price_suggest_bpdg']) ? $this->security->xss_clean($data['price_suggest_bpdg']) : '';
		$data['price_suggest_thn'] = $this->security->xss_clean($data['price_suggest_thn']) ? $this->security->xss_clean($data['price_suggest_thn']) : '';
		$data['price_suggest_thn_send_ceo'] = $this->security->xss_clean($data['price_suggest_thn_send_ceo']) ? $this->security->xss_clean($data['price_suggest_thn_send_ceo']) : '';
		$data['price_refer_ceo'] = $this->security->xss_clean($data['price_refer_ceo']) ? $this->security->xss_clean($data['price_refer_ceo']) : '';
		$data['price_real_sold'] = $this->security->xss_clean($data['price_real_sold']) ? $this->security->xss_clean($data['price_real_sold']) : '';
		$data['fee_sold'] = $this->security->xss_clean($data['fee_sold']) ? $this->security->xss_clean($data['fee_sold']) : '';
		$data['date_sold'] = $this->security->xss_clean($data['date_sold']) ? $this->security->xss_clean($data['date_sold']) : '';
		$condition = array("id" => $data['id']);
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", $condition);
		$data['debt_remain_root'] = str_replace( array( '.', ','), '', $data['debt_remain_root']);
		$data['suggest_price'] = str_replace( array( '.', ','), '', $data['suggest_price']);
		$data['price_suggest_bpdg'] = str_replace( array( '.', ','), '', $data['price_suggest_bpdg']);
		$data['price_suggest_thn'] = str_replace( array( '.', ','), '', $data['price_suggest_thn']);
		$data['price_suggest_thn_send_ceo'] = str_replace( array( '.', ','), '', $data['price_suggest_thn_send_ceo']);
		$data['price_refer_ceo'] = str_replace( array( '.', ','), '', $data['price_refer_ceo']);
		$data['price_real_sold'] = str_replace( array( '.', ','), '', $data['price_real_sold']);
		$data['fee_sold'] = str_replace( array( '.', ','), '', $data['fee_sold']);
		if ($data['status'] == 44) {
			if (!empty($data['date_seize']) && (strtotime($data['date_seize']) < strtotime(date('Y-m-d',$contract->data->disbursement_date))) && $data['status'] == 37) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Ngày thu xe không được nhỏ hơn ngày giải ngân!")));
				return;
			}
			if (empty($data['date_seize'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa chọn ngày thu giữ xe!")));
				return;
			}
			if (empty($data['name_person_seize'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa nhập tên nhân viên thu giữ xe!")));
				return;
			}
			if (empty($data['license_plates'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa nhập biển số xe!")));
				return;
			}
			if (empty($data['frame_number'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa nhập số khung!")));
				return;
			}
			if (empty($data['engine_number'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa nhập số máy!")));
				return;
			}
			if (empty($data['license_number'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa nhập số đăng ký xe!")));
				return;
			}
			if (empty($data['asset_name'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa nhập tên tài sản!")));
				return;
			}
			if (empty($data['asset_branch'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa nhập thương hiệu tài sản!")));
				return;
			}
			if (empty($data['number_km'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa nhập số km đã đi!")));
				return;
			}
			if (empty($data['asset_model'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa nhập model tài sản!")));
				return;
			}
			if (empty($data['image_file'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Hình ảnh tài sản đảm bảo đang trống!")));
				return;
			}
		}
		//validate BPĐG nhập liệu
		if ($data['status'] == 46) {
			if (empty($data['name_valuation'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa nhập tên cá nhân/đơn vị trả giá!")));
				return;
			}
			if (empty($data['phone_valuation'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa nhập số điện thoại cá nhân/đơn vị trả giá!")));
				return;
			}
			if (!empty($data['phone_valuation'])) {
				if (!preg_match("/^[0-9]{10,12}$/", $data['phone_valuation'])) {
					$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Số điện thoại không đúng định dạng!")));
					return;
				}
			}
			if (empty($data['price_suggest_bpdg'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa nhập giá đề xuất tham khảo!")));
				return;
			}
			if (empty($data['date_effect_bpdg'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa chọn ngày hiệu lực của giá bán!")));
				return;
			}
			if (!empty($data['date_effect_bpdg'])) {
				if (strtotime($data["date_effect_bpdg"]) < strtotime(date('m/d/Y'))) {
					$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Ngày hiệu lực không được nhỏ hơn ngày hiện tại!")));
					return;
				}
			}
			if (empty($data['image_file'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Hình ảnh định giá tài sản đảm bảo đang trống!")));
				return;
			}
		}
		if ($data['status'] == 47) {
			if (empty($data['price_suggest_thn'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa nhập giá thanh lý tham khảo!")));
				return;
			}
			if (!empty($data['price_suggest_thn'])) {
				if ((int)$data['price_suggest_thn'] < $contract->data->liquidation_info->bpdg->price_suggest_bpdg) {
					$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Số tiền tham khảo phải lớn hơn hoặc bằng giá bán đã định giá!")));
					return;
				}
			}
		}
		if ($data['status'] == 48) {
			if (empty($data['price_suggest_thn_send_ceo'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa nhập giá TPTHN gửi CEO duyệt!")));
				return;
			}
			if (!empty($data['price_suggest_thn_send_ceo'])) {
				if ((int)$data['price_suggest_thn_send_ceo'] < $contract->data->liquidation_info->bpdg->price_suggest_bpdg) {
					$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Số tiền gửi duyệt phải lớn hơn hoặc bằng giá bán đã định giá!")));
					return;
				}
			}
			if (empty($data['price_refer_ceo'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa nhập giá CEO duyệt!")));
				return;
			}
			if (empty($data['image_file'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa upload hình ảnh CEO duyệt qua email!")));
				return;
			}
		}
		if ($data['status'] == 40) {
			if (empty($data['name_buyer'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa nhập họ tên người mua!")));
				return;
			}
			if (empty($data['phone_number_buyer'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa nhập số điện thoại người mua!")));
				return;
			}
			if (!empty($data['phone_number_buyer'])) {
				if (!preg_match("/^[0-9]{10,12}$/", $data['phone_number_buyer'])) {
					$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Số điện thoại không đúng định dạng!")));
					return;
				}
			}
			if (empty($data['price_real_sold'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa nhập giá thực bán tài sản thanh lý!")));
				return;
			}
			if (empty($data['date_sold'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa nhập ngày bán tài sản thanh lý!")));
				return;
			}
			if (empty($data['image_file'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa upload hình ảnh bán tài sản thanh lý!")));
				return;
			}
		}
		if ($data['status'] == 44) {
			$dataPost = array(
				"id" => $data["id"],
				"status" => $data["status"],
				"date_seize" => $data["date_seize"],
				"name_person_seize" => $data["name_person_seize"],
				"license_plates" => $data["license_plates"],
				"frame_number" => $data["frame_number"],
				"engine_number" => $data["engine_number"],
				"license_number" => $data["license_number"],
				"asset_name" => $data["asset_name"],
				"asset_branch" => $data["asset_branch"],
				"asset_model" => $data["asset_model"],
				"number_km" => $data["number_km"],
				"image_file" => $data["image_file"],
				"note" => $data["note"],
				"action" => $data["action"]
			);
		} elseif ($data['status'] == 45) {
			$dataPost = array(
				"id" => $data["id"],
				"status" => $data["status"],
				"action" => $data["action"],
				"note" => $data["note"]
			);
		} elseif ($data["status"] == 46) {
			$dataPost = array(
				"id" => $data["id"],
				"action" => $data['action'],
				"status" => $data["status"],
				"name_valuation" => $data["name_valuation"],
				"phone_valuation" => $data["phone_valuation"],
				"price_suggest_bpdg" => $data["price_suggest_bpdg"],
				"date_effect_bpdg" => $data["date_effect_bpdg"],
				"image_file" => $data["image_file"],
				"note" => $data["note"],
			);
		} elseif ($data['status'] == 47) {
			$dataPost = array(
				"id" => $data["id"],
				"action" => $data["action"],
				"status" => $data["status"],
				"price_suggest_thn" => $data["price_suggest_thn"],
				"image_file" => $data["image_file"],
				"note" => $data["note"]
			);
		} elseif ($data['status'] == 48) {
			$dataPost = array(
				"id" => $data["id"],
				"action" => $data["action"],
				"status" => $data["status"],
				"price_suggest_thn_send_ceo" => $data['price_suggest_thn_send_ceo'],
				"price_refer_ceo" => $data['price_refer_ceo'],
				"image_file" => $data["image_file"],
				"note" => $data["note"]
			);
		} elseif ($data['status'] == 49) {
			$dataPost = array(
				"id" => $data["id"],
				"action" => $data["action"],
				"status" => $data["status"],
				"price_refer_ceo" => $data['price_refer_ceo'],
				"image_file" => $data["image_file"],
				"note" => $data["note"]
			);
		} elseif ($data['status'] == 40) {
			$dataPost = array(
				"id" => $data["id"],
				"action" => $data["action"],
				"status" => $data["status"],
				"name_buyer" => $data['name_buyer'],
				"phone_number_buyer" => $data["phone_number_buyer"],
				"price_real_sold" => $data["price_real_sold"],
				"fee_sold" => $data["fee_sold"],
				"date_sold" => $data["date_sold"],
				"image_file" => $data["image_file"],
				"note" => $data["note"]
			);
		} elseif ($data['status'] == 17) {
			$dataPost = array(
				"id" => $data['id'],
				"action" => $data['action'],
				"status" => $data['status'],
				"note" => $data['note']
			);
		}
		$return = $this->api->apiPost($this->user['token'], "LiquidationAssetContract/approve_liquidations", $dataPost);
		if (!empty($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array('status' => "200", 'msg' => "Thành công!")));
			return;
		} else {
			$this->pushJson('200', json_encode(array('status' => "401", 'msg' => $return->message)));
			return;
		}
	}

	public function contractPaymentInfo($id)
	{
		try {
			$id = $this->security->xss_clean($id);
			$date_pay = "";
			$condition = array("id" => $id);
			$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", $condition);
			$tabTatToanPart1 = $this->api->apiPost($this->userInfo['token'], "view_payment/get_infor_tat_toan_part_1", array("code_contract" => $contract->data->code_contract, "date_pay" => $date_pay));
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $tabTatToanPart1->data, "data1" => $contract->data)));
		} catch (\Exception $exception) {
			show_404();
		}
	}

	public function contract_liquidations()
	{
		$this->data["pageName"] = "Quản lý hợp đồng có tài sản thanh lý";
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$store_code = !empty($_GET['store']) ? $_GET['store'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$customer_phone_number = !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		// điều kiện để lấy bản ghi
		$data = array();
		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('accountant/contract_liquidations'));
		}
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$data['start'] = $start;
			$data['end'] = $end;
		}
		if (!empty($status)) {
			$data['status'] = ($status);
		}
		if (!empty($store_code)) {
			$data['store'] = trim($store_code);
		}
		if (!empty($code_contract)) {
			$data['code_contract'] = trim($code_contract);
		}
		if (!empty($customer_name)) {
			$data['customer_name'] = $customer_name;
		}
		if (!empty($customer_phone_number)) {
			$data['customer_phone_number'] = $customer_phone_number;
		}
		if (!empty($code_contract_disbursement)) {
			$data['code_contract_disbursement'] = $code_contract_disbursement;
		}
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('accountant/contract_liquidations?code_contract_disbursement=' . $code_contract_disbursement . '&fdate=' . $start . '&tdate=' . $end . '&customer_name=' . $customer_name . '&customer_phone_number' . $customer_phone_number . '&store=' . $store_code . '&code_contract=' . $code_contract . '&status=' . $status);
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 30;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		// call api get contract data
		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];
		$contractLiquidations = $this->api->apiPost($this->userInfo['token'], "LiquidationAssetContract/contract_tempo_liquidations", $data);
		if (!empty($contractLiquidations->status) && $contractLiquidations->status == 200) {
			$config['total_rows'] = $contractLiquidations->total;
			$this->data['contractLiquidations'] = $contractLiquidations->data;
		} else {
			$this->data['contractLiquidations'] = array();
		}
		//get store
		$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all");
		if (!empty($storeData->status) && $storeData->status == 200) {
			$this->data['storeData'] = $storeData->data;
		} else {
			$this->data['storeData'] = array();
		}
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		//get role khởi tạo thanh lý
		$role_liq = $this->api->apiPost($this->userInfo['token'], 'LiquidationAssetContract/get_role_create_liquidation',[]);
		if (!empty($role_liq->data)) {
			$this->data["role_liq"] = $role_liq->data;
		} else {
			$this->data["role_liq"] = array();
		}
		//get role Hủy thanh lý
		$role_cancel_liq = $this->api->apiPost($this->userInfo['token'], 'LiquidationAssetContract/get_role_cancel_liquidation',[]);
		if (!empty($role_liq->data)) {
			$this->data["role_cancel_liq"] = $role_cancel_liq->data;
		} else {
			$this->data["role_cancel_liq"] = array();
		}
		$this->pagination->initialize($config);
		$this->data['result_count'] = $config['total_rows'];
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/accountant/thn/contract_liquidations';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;
	}

	public function doFinishContractLiquidations()
	{
		$data = $this->input->post();
		$data['code_contract'] = !empty($data['code_contract']) ? $this->security->xss_clean($data['code_contract']) : "";
		$data['phi_phat_sinh'] = !empty($data['phi_phat_sinh']) ? $this->security->xss_clean($data['phi_phat_sinh']) : "";
		$data['payment_name'] = !empty($data['payment_name']) ? $this->security->xss_clean($data['payment_name']) : "";
		$data['payment_note'] = !empty($data['payment_note']) ? $this->security->xss_clean($data['payment_note']) : "";
		$data['payment_amount'] = !empty($data['payment_amount']) ? $this->security->xss_clean($data['payment_amount']) : "";
		$data['fee_reduction'] = !empty($data['fee_reduction']) ? $this->security->xss_clean($data['fee_reduction']) : "";
		$data['payment_method'] = !empty($data['payment_method']) ? $this->security->xss_clean($data['payment_method']) : "";
		$data['reduced_fee'] = !empty($data['reduced_fee']) ? $this->security->xss_clean($data['reduced_fee']) : 0;
		$data['discounted_fee'] = !empty($data['discounted_fee']) ? $this->security->xss_clean($data['discounted_fee']) : 0;
		$data['other_fee'] = !empty($data['other_fee']) ? $this->security->xss_clean($data['other_fee']) : 0;
		$data['penalty_pay'] = !empty($data['penalty_pay']) ? $this->security->xss_clean($data['penalty_pay']) : 0;
		$data['valid_amount_payment'] = !empty($data['valid_amount_payment']) ? $this->security->xss_clean($data['valid_amount_payment']) : 0;
		$data['fee_sold_liquidation'] = !empty($data['fee_sold_liquidation']) ? $this->security->xss_clean($data['fee_sold_liquidation']) : 0;
		$data['amount_payment_finish_system'] = !empty($data['amount_payment_finish_system']) ? $this->security->xss_clean($data['amount_payment_finish_system']) : 0;
		$data['date_pay'] = !empty($data['date_pay']) ? $this->security->xss_clean($data['date_pay']) : "";
		$store_id = !empty($data['store_id']) ? $this->security->xss_clean($data['store_id']) : "";
		$store_name = !empty($data['store_name']) ? $this->security->xss_clean($data['store_name']) : "";

		if (empty($data['payment_name'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Bạn chưa nhập tên người thanh toán!")));
			return;
		}

		if (empty($data['payment_method'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "msg" => 'Phương thức thanh toán không được để trống')));
			return;
		}
		if (empty($data['payment_note'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "msg" => 'Bạn chưa chọn nội dung thu tiền!')));
			return;
		}
		//Encrypt TripleDes
		$libTripleDes = new TripleDes();
		// $secretKey = $libTripleDes->Encrypt(json_encode($data), $this->config->item("TRIPLEDES_KEY_TRANSACTION_CONTRACT"));
		$dataPost = array(
			"amount" => $data['payment_amount'],
			"fee_reduction" => $data['fee_reduction'],
			"valid_amount" => $data['valid_amount_payment'],
			"reduced_fee" => $data['reduced_fee'],
			"discounted_fee" => $data['discounted_fee'],
			"other_fee" => $data['other_fee'],
			"penalty_pay" => $data['penalty_pay'],
			"name" => $data['payment_name'],
			"note" => !empty($data['payment_note']) ? $data['payment_note'] : '',
			"code_contract" => $data['code_contract'],
			"payment_method" => $data['payment_method'],// 1:tiền mặt, 2// ck
			"type_pt" => 3, // tat toan
			"phi_phat_sinh" => $data['phi_phat_sinh'],
			"fee_sold_liquidation" => $data['fee_sold_liquidation'],
			"amount_payment_finish_system" => $data['amount_payment_finish_system'],
			"date_pay" => $data['date_pay'],
			"store" => array(
				'id' => $store_id,
				'name' => $store_name,
			),
			"type_payment" => 4, // 1: thanh toán, 2: gia hạn, 3: cơ cấu, 4: Tất toán hợp đồng đã thanh lý tài sản
		);
		$return = $this->api->apiPost($this->user['token'], "transaction/payment_finish_contract", $dataPost);
		if (!empty($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("status" => "200", "msg" => "Đang khởi tạo biên nhận!", 'url' => $return->url, 'url_printed' => $return->url_printed, 'transaction_id' => $return->transaction_id)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("status" => "401", "msg" => $return->message, "return" => $return)));
			return;
		}
	}

	public function update_date_liquidations()
	{
		$data = $this->input->post();
		$id_contract = !empty($data["id_contract"]) ? $this->security->xss_clean($data["id_contract"]) : "";
		$date_liquidations = !empty($data["date_liquidations"]) ? $data["date_liquidations"] : "";

		$data_update = array(
			"id" => $id_contract,
			"date_liquidations" => strtotime(trim($date_liquidations)),
		);

		$result_update = $this->api->apiPost($this->userInfo["token"], "LiquidationAssetContract/update_date_liquidations", $data_update);
		if (!empty($result_update->status) && $result_update->status == 200) {
			$this->pushJson("200", json_encode(array("status" => "200", "msg" => "Sửa ngày thanh lý tài sản thành công!", "data" => date("d/m/Y", $result_update->contract))));
			return;
		} else {
			$this->pushJson('200', json_encode(array("status" => "401", "msg" => $result_update->message)));
			return;
		}

	}

	public function index_list_contractMkt()
	{

		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$count = $this->api->apiPost($this->userInfo['token'], "lead_custom/get_count_all_200");

		$count = (int)$count->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('accountant/index_list_contractMkt');
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;

		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];

		$contract = $this->api->apiPost($this->userInfo['token'], "lead_custom/get_all_200", $data);

		if (!empty($contract->status) && $contract->status == 200) {

			foreach ($contract->data as $key => $item) {
				if (!empty($item->customer_infor->customer_phone_introduce)) {
					$check = [];
					$check['phone_number'] = $item->customer_infor->customer_phone_introduce;
					$status_check = $this->api->apiPost($this->userInfo['token'], "lead_custom/get_check_phone_ngt", $check);
					if (!empty($status_check)) {
						$item->status_check = $status_check->data;
					}
				}

			}

			$this->data['contract'] = $contract->data;

		} else {
			$this->data['contract'] = array();
		}

		$this->data['template'] = 'page/pawn/list_contract_200k';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;

	}

	public function update_presenter()
	{

		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['presenter_date'] = $this->security->xss_clean($data['presenter_date']);
		$data['presenter_money'] = $this->security->xss_clean($data['presenter_money']);
		$data['presenter_buttoan'] = $this->security->xss_clean($data['presenter_buttoan']);
		$data['img_approve'] = $this->security->xss_clean($data['img_approve']);

		$sendApi = array(
			"id" => $data['id'],
			"presenter_date" => $data['presenter_date'],
			"presenter_money" => $data['presenter_money'],
			"presenter_buttoan" => $data['presenter_buttoan'],
			"img_approve" => $data['img_approve'],

			"created_by" => $this->userInfo,
		);

		$return = $this->api->apiPost($this->userInfo['token'], "lead_custom/update_presenter", $sendApi);


		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		} else {

			$msg = !empty($return->data->message) ? $return->data->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));

		}


	}

	public function viewImageAccuracy()
	{
		$this->data["pageName"] = $this->lang->line('view_img_authentication');
		$this->data['template'] = 'page/pawn/img_cmt';
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
		$result = $this->api->apiPost($this->userInfo['token'], "contract/get_image", $dataPost);
		$this->data['result'] = $result->data;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function search_list_200()
	{

		$data = [];
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement_search']) ? $_GET['code_contract_disbursement_search'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$customer_phone_number = !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
		$customer_identify = !empty($_GET['customer_identify']) ? $_GET['customer_identify'] : "";

		if (!empty($code_contract)) {
			$data['code_contract'] = trim($code_contract);
		}
		if (!empty($code_contract_disbursement)) {
			$data['code_contract_disbursement'] = trim($code_contract_disbursement);
		}
		if (!empty($customer_name)) {
			$data['customer_name'] = trim($customer_name);
		}
		if (!empty($customer_phone_number)) {
			$data['customer_phone_number'] = trim($customer_phone_number);
		}
		if (!empty($customer_identify)) {
			$data['customer_identify'] = trim($customer_identify);
		}

		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$count = $this->api->apiPost($this->userInfo['token'], "lead_custom/get_count_all_200", $data);

		$count = (int)$count->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('accountant/index_list_contractMkt');
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;

		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];

		$contract = $this->api->apiPost($this->userInfo['token'], "lead_custom/get_all_200", $data);
		if (!empty($contract->status) && $contract->status == 200) {

			foreach ($contract->data as $key => $item) {
				if (!empty($item->customer_infor->customer_phone_introduce)) {
					$check = [];
					$check['phone_number'] = $item->customer_infor->customer_phone_introduce;
					$status_check = $this->api->apiPost($this->userInfo['token'], "lead_custom/get_check_phone_ngt", $check);
					if (!empty($status_check)) {
						$item->status_check = $status_check->data;
					}
				}
			}
			$this->data['contract'] = $contract->data;
		} else {
			$this->data['contract'] = array();
		}

		$this->data['template'] = 'page/pawn/list_contract_200k';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;


	}
	public function not_reminder()
	{
		$id_contract = !empty($_POST['id_contract']) ? $_POST['id_contract'] : '';
		$date_pay = !empty($_POST['date_pay']) ? $_POST['date_pay'] : '';
		$money_pay = !empty($_POST['money_pay']) ? $_POST['money_pay'] : '';
		$note = !empty($_POST['note']) ? $_POST['note'] : '';
		$res = $this->api->apiPost($this->user['token'], "contract/not_reminder", ['id_contract' => $id_contract, 'date_pay' => $date_pay, 'money_pay' => $money_pay, 'note' => $note]);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $res->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => $res->message)));
			return;
		}
	}
	public function coppy_contract()
	{
		$code_contract = !empty($_POST['code_contract']) ? $_POST['code_contract'] : '';
		
		$res = $this->api->apiPost($this->user['token'], "contract/coppy_contract", ['code_contract' => $code_contract]);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200","code_contract_new" => $res->code_contract_new, "msg" => $res->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => $res->message)));
			return;
		}
	}

	public function index_price_ctv_web(){

		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$count = $this->api->apiPost($this->userInfo['token'], "lead_custom/get_count_price_ctv");

		$count = (int)$count->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('accountant/index_price_ctv_web');
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;

		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];

		$lead_ctv = $this->api->apiPost($this->userInfo['token'], "lead_custom/get_price_ctv", $data);

		if (!empty($lead_ctv->status) && $lead_ctv->status == 200) {

			foreach ($lead_ctv->data as $item){

				if (!empty($item->ctv_code)){
					$code_ctv = [
						'code_ctv' => $item->ctv_code
					];

					$collaborator = $this->api->apiPost($this->userInfo['token'], "lead_custom/get_collaborator", $code_ctv);

					if (!empty($collaborator)){
						$item->collaborator = $collaborator->data;
					}
					$account_bank = $this->api->apiPost($this->userInfo['token'], "lead_custom/account_bank", $code_ctv);
					if (!empty($account_bank)){
						$item->account_bank = $account_bank->data;
					}
				}

			}

			$this->data['lead_ctv'] = $lead_ctv->data;
		} else {
			$this->data['lead_ctv'] = array();
		}

		$this->data['template'] = 'page/pawn/list_price_ctv';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;
	}

	public function show_bankPrice_ctv($id){

		try {
			$id = $this->security->xss_clean($id);
			$condition = array("id" => $id);

			$content = $this->api->apiPost($this->userInfo['token'], "lead_custom/get_one_bankPrice", $condition);

			if (!empty($content) && !empty($content->data->date_pay)){

				$content->data->date_pay = date("m-d-Y", $content->data->date_pay);
			}

			$this->pushJson('200', json_encode(array("code" => "200", "data" => $content->data)));
		} catch (\Exception $exception) {
			show_404();
		}
	}

	public function lead_update_bank(){

		$data = $this->input->post();

		$sendApi = array(
			"id" => $data['id'],
			'his_money' => $data['his_money'],
			'date_pay' => $data['date_pay'],
			'his_key' => $data['his_key'],
			'img_approve' => $data['img_approve'],
		);

		$return = $this->api->apiPost($this->userInfo['token'], "lead_custom/process_update_bankCTV", $sendApi);

		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		} else {
			$msg = !empty($return->data->message) ? $return->data->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "400", "data" => array("status" => "400", "message" => $msg, "return" => $return))));

		}


	}

	public function search_list_price_ctv(){

		$data = [];
		$key = !empty($_GET['key']) ? $_GET['key'] : "";
		$phone = !empty($_GET['phone']) ? $_GET['phone'] : "";
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";


		if (!empty($key)) {
			$data['key'] = $key;
		}
		if (!empty($phone)) {
			$data['phone'] = $phone;
		}
		if (!empty($tdate)) {
			$data['tdate'] = $tdate;
		}
		if (!empty($fdate)) {
			$data['fdate'] = $fdate;
		}

		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$count = $this->api->apiPost($this->userInfo['token'], "lead_custom/get_count_price_ctv", $data);

		$count = (int)$count->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('accountant/index_price_ctv_web?fdate='. $fdate . "&tdate=" . $tdate . "&phone=" . $phone . "&key=" . $key);
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;

		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];

		$lead_ctv = $this->api->apiPost($this->userInfo['token'], "lead_custom/get_price_ctv", $data);

		if (!empty($lead_ctv->status) && $lead_ctv->status == 200) {

			foreach ($lead_ctv->data as $item){

				if (!empty($item->ctv_code)){
					$code_ctv = [
						'code_ctv' => $item->ctv_code
					];

					$collaborator = $this->api->apiPost($this->userInfo['token'], "lead_custom/get_collaborator", $code_ctv);

					if (!empty($collaborator)){
						$item->collaborator = $collaborator->data;
					}

					$account_bank = $this->api->apiPost($this->userInfo['token'], "lead_custom/account_bank", $code_ctv);

					if (!empty($account_bank)){
						$item->account_bank = $account_bank->data;
					}

				}
			}

			$this->data['lead_ctv'] = $lead_ctv->data;
		} else {
			$this->data['lead_ctv'] = array();
		}

		$this->data['template'] = 'page/pawn/list_price_ctv';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;
	}
	public function getStoreByArea() {
		$id = !empty($_POST['code_area']) ? $_POST['code_area'] : "";
		$data = ['code_area' => $id];
		$storeData = $this->api->apiPost($this->userInfo['token'], "area/get_store_by_area",$data);
		if (!empty($storeData->status) && $storeData->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $storeData->data
			];
			//$this->pushJson('200', json_encode($response));
			// echo json_encode($response);
			// return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'data' => []
			];
			// echo json_encode($response);
			// return;
		}
		$this->pushJson('200', json_encode($response));
	}

	private function apiListSeriPositioningDevices(){

		$result = $this->api->apiPost($this->userInfo['token'], "contract/get_device_asset_location");
		$listSeriPositioningDevices = [];
		if (!empty($result)){
			foreach ($result->data as $value){
				$listSeriPositioningDevices += [$value->_id->{'$oid'} => "$value->code"];
			}
		}
		return $listSeriPositioningDevices;
	}
}

?>

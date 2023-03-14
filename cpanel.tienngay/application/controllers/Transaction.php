<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// include APPPATH.'/libraries/Api.php';
include APPPATH.'/libraries/CpanelV2.php';
class Transaction extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->api = new Api();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model("time_model");
		$this->load->model("store_model");
		$this->load->library('pagination');
		$this->load->helper('lead_helper');
		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
		if (!$this->userInfo) {
			$this->session->set_flashdata('error', $this->lang->line('You_do_not_have_permission_access_this_item'));
			redirect(base_url());
			return;
		}
		// if (!$this->is_superadmin) {
		// 	$paramController = $this->uri->segment(1);
		// 	$param = strtolower($paramController);
		// 	if (!in_array($param, $this->paramMenus)) {
		// 		$this->session->set_flashdata('error', $this->lang->line('not_have_permission') . ' ' . $paramController . '!');
		// 		redirect(base_url('app'));
		// 		return;
		// 	}
		// }
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	private function pushJson($code, $data)
	{
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}


	public function list_investors()
	{
		$this->data["pageName"] = $this->lang->line('Managing_receipts');
		$data = array();
		$transactionData = $this->api->apiPost($this->userInfo['token'], "transaction/get_tran_investors_all", $data);
		if (!empty($transactionData->status) && $transactionData->status == 200) {
			$this->data['transactionData'] = $transactionData->data;
		} else {
			$this->data['transactionData'] = array();
		}

		$this->data['template'] = 'page/transaction/list_tran_investors';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function transaction_v2()
	{
		$this->data["pageName"] = $this->lang->line('Managing_receipts');
		$data = array();
		$transactionData = $this->api->apiPost($this->userInfo['token'], "transaction/get_all_v2", $data);
		if (!empty($transactionData->status) && $transactionData->status == 200) {
			$this->data['transactionData'] = $transactionData->data;
			$this->data['groupRoles'] = $transactionData->groupRoles;
		} else {
			$this->data['transactionData'] = array();
			$this->data['groupRoles'] = array();
		}
		$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all");
		if (!empty($storeData->status) && $storeData->status == 200) {
			$this->data['storeData'] = $storeData->data;
		} else {
			$this->data['storeData'] = array();
		}
		$this->data['template'] = 'page/transaction/list_v2';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}


	public function index()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$payment_method = !empty($_GET['payment_method']) ? $_GET['payment_method'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$code = !empty($_GET['code']) ? $_GET['code'] : "";
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "";
		$sdt = !empty($_GET['sdt']) ? $_GET['sdt'] : "";
		$type_transaction = !empty($_GET['type_transaction']) ? $_GET['type_transaction'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$this->data["pageName"] = $this->lang->line('Managing_receipts');
		$data = array();
		if (!empty($fdate) && !empty($tdate)) {
			if (strtotime($fdate) > strtotime($tdate)) {
				$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
				redirect(base_url('transaction'));
			}
			if (empty($_GET['fdate']) || empty($_GET['tdate'])) {
				$this->session->set_flashdata('error', $this->lang->line('Please_select_input_date'));
				redirect(base_url('transaction'));
			}

		}
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['base_url'] = base_url('transaction') . '?fdate=' . $fdate . '&tdate=' . $tdate . '&sdt=' . $sdt . '&status=' . $status . '&store=' . $store . '&tab=' . $tab . '&type_transaction=' . $type_transaction . '&code=' . $code . '&code_contract_disbursement=' . $code_contract_disbursement . '&payment_method=' . $payment_method;
		$data = array(
			"per_page" => $config['per_page'],
			"uriSegment" => $config['uri_segment'],
			"fdate" => $fdate,
			"tdate" => $tdate,
			"sdt" => $sdt,
			"tab" => $tab,
		);
		if (!empty($status)) {
			$data['status'] = $status;
		}
		if (!empty($payment_method)) {
			$data['payment_method'] = $payment_method;
		}
		if (!empty($store)) {
			$data['store'] = $store;
		}
		if (!empty($code)) {
			$data['code'] = $code;
		}
		if (!empty($sdt)) {
			$data['sdt'] = $sdt;
		}
		if (!empty($type_transaction)) {
			$data['type_transaction'] = $type_transaction;
		}
		if (!empty($code_contract_disbursement)) {
			$data['code_contract_disbursement'] = $code_contract_disbursement;
		}
		$transactionData = $this->api->apiPost($this->userInfo['token'], "transaction/get_all", $data);
		if (!empty($transactionData->status) && $transactionData->status == 200) {
			$this->data['transactionData'] = $transactionData->data;
			$this->data['groupRoles'] = $transactionData->groupRoles;
			$config['total_rows'] = $transactionData->total;
		} else {
			$this->data['transactionData'] = array();
			$this->data['groupRoles'] = array();
		}
		//get store
		$storeData = $this->userInfo['stores'];
		$this->api->apiPost($this->userInfo['token'], "store/get_all");
		if (!empty($storeData)) {
			$this->data['storeData'] = $storeData;
		} else {
			$this->data['storeData'] = array();
		}
		$listInvestor = $this->api->apiPost($this->userInfo['token'], "investor/get_all");
		if ($listInvestor->status == 200) {
			$this->data['listInvestor'] = $listInvestor->data;
		}
		$this->data['fdate'] = $fdate;
		$this->data['tdate'] = $tdate;
		$this->data['status'] = $status;
		$this->pagination->initialize($config);
		$this->data['result_count'] = "Hiển thị " . $config['total_rows'] . " Kết quả";
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/transaction/list';
		$this->data['reasons_cancel'] = reasons_cancel_transaction();
		$this->data['reasons_return'] = reasons_return_transaction();
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;
	}

	public function list_kt()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$code = !empty($_GET['code']) ? $_GET['code'] : "";
		$type_transaction = !empty($_GET['type_transaction']) ? $_GET['type_transaction'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$allocation = !empty($_GET['allocation']) ? $_GET['allocation'] : "";

		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$code_transaction_bank = !empty($_GET['code_transaction_bank']) ? $_GET['code_transaction_bank'] : "";
		$full_name = !empty($_GET['full_name']) ? $_GET['full_name'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "all";
		$this->data["pageName"] = $this->lang->line('Managing_receipts');
		$data = array();
		if (!empty($fdate) && !empty($tdate)) {
			if (strtotime($fdate) > strtotime($tdate)) {
				$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
				redirect(base_url('transaction/list_kt'));
			}
			if (empty($_GET['fdate']) || empty($_GET['tdate'])) {
				$this->session->set_flashdata('error', $this->lang->line('Please_select_input_date'));
				redirect(base_url('transaction/list_kt'));
			}
			$data = array(
				"fdate" => $fdate,
				"tdate" => $tdate,
			);
		}
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');

		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;

		$config['base_url'] = base_url('transaction/list_kt') . '?fdate=' . $fdate . '&tdate=' . $tdate . '&full_name=' . $full_name . '&code_contract_disbursement=' . $code_contract_disbursement . '&store=' . $store . '&tab=' . $tab . '&code_transaction_bank=' . $code_transaction_bank . '&code_contract=' . $code_contract . '&status=' . $status . '&type_transaction=' . $type_transaction . '&allocation=' . $allocation . '&code=' . $code;
		$data = array(
			"per_page" => $config['per_page'],
			"uriSegment" => $config['uri_segment'],
			//"email" => $email,
			"fdate" => $fdate,
			"tdate" => $tdate,
			"tab" => $tab,

		);
		if (!empty($status)) {
			$data['status'] = $status;
		}
		if (!empty($type_transaction)) {
			$data['type_transaction'] = $type_transaction;
		}
		if (!empty($allocation)) {
			$data['allocation'] = $allocation;
		}
		if (!empty($store)) {
			$data['store'] = $store;
		}
		if (!empty($full_name)) {
			$data['full_name'] = $full_name;
		}
		if (!empty($code_contract)) {
			$data['code_contract'] = $code_contract;
		}
		if (!empty($code_contract_disbursement)) {
			$data['code_contract_disbursement'] = $code_contract_disbursement;
		}
		if (!empty($code_transaction_bank)) {
			$data['code_transaction_bank'] = $code_transaction_bank;
		}
		if (!empty($code)) {
			$data['code'] = $code;
		}

		$transactionData = $this->api->apiPost($this->userInfo['token'], "transaction/get_all_kt", $data);
		if (!empty($transactionData->status) && $transactionData->status == 200) {
			$this->data['transactionData'] = $transactionData->data;
			$this->data['groupRoles'] = $transactionData->groupRoles;
			$config['total_rows'] = $transactionData->total;
		} else {
			$this->data['transactionData'] = array();
			$this->data['groupRoles'] = array();
		}
		//get store
		$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all");
		if (!empty($storeData->status) && $storeData->status == 200) {
			$this->data['storeData'] = $storeData->data;
		} else {
			$this->data['storeData'] = array();
		}
		$this->data['fdate'] = $fdate;
		$this->data['tdate'] = $tdate;
		$this->data['status'] = $status;
		$this->pagination->initialize($config);
		$this->data['result_count'] = "Hiển thị " . $config['total_rows'] . " Kết quả";
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/transaction_kt/list';
		$this->data['reasons_cancel'] = reasons_cancel_transaction();
		$this->data['reasons_return'] = reasons_return_transaction();
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
//		return;
	}


	public function view()
	{
		$id = $this->uri->segment(3);
		if (empty($id)) {
			$this->session->set_flashdata('error', $this->lang->line('Does_not_exist_order'));
			redirect(base_url('transaction'));
			return;
		}
		$id = $this->security->xss_clean($id);
		//Get information
		$orders = $this->api->apiPost($this->userInfo['token'], "transaction/get_order", array("id" => $id));
		if (!empty($orders->status) && $orders->status == 200) {
			$this->data['orderData'] = $orders->orderData;
			$this->data['transaction'] = $orders->transaction;
		} else {
			$this->data['orderData'] = array();
			$this->data['transaction'] = array();
		}
		$this->data['template'] = 'page/transaction/order_list';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function viewContract()
	{
		$id = $this->uri->segment(3);
		if (empty($id)) {
			$this->session->set_flashdata('error', $this->lang->line('Does_not_exist_order'));
			redirect(base_url('transaction'));
			return;
		}
		$id = $this->security->xss_clean($id);
		//Get information
		$orders = $this->api->apiPost($this->userInfo['token'], "transaction/get_detail", array("id" => $id));
		if (!empty($orders->status) && $orders->status == 200) {
			$this->data['transaction'] = $orders->transaction;
		} else {
			$this->data['transaction'] = array();
		}
		$this->data['template'] = 'page/transaction/contract_list';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function detail()
	{
		$id = $this->uri->segment(3);
		if (empty($id)) {
			$this->session->set_flashdata('error', $this->lang->line('Does_not_exist_transaction'));
			redirect(base_url('transaction'));
			return;
		}
		$id = $this->security->xss_clean($id);
		//Get information
		$orders = $this->api->apiPost($this->userInfo['token'], "transaction/get_detail", array("id" => $id));
		if (!empty($orders->status) && $orders->status == 200) {
			$this->data['orderData'] = $orders->orderData;
			$this->data['transaction'] = $orders->transaction;
			$this->data['code_billing'] = $orders->code_billing;
			$this->data['hotline'] = $orders->hotline;
		} else {
			$this->data['orderData'] = array();
			$this->data['transaction'] = array();
			$this->data['code_billing'] = array();
			$this->data['hotline'] = '';
		}
		$this->load->view('billing_printed', isset($this->data) ? $this->data : NULL);
	}

	public function detail_contract()
	{
		$id = $this->uri->segment(3);
		if (empty($id)) {
			$this->session->set_flashdata('error', $this->lang->line('Does_not_exist_transaction'));
			redirect(base_url('transaction'));
			return;
		}
		$id = $this->security->xss_clean($id);
		//Get information
		$orders = $this->api->apiPost($this->userInfo['token'], "transaction/get_detail", array("id" => $id));
		if (!empty($orders->status) && $orders->status == 200) {
			$this->data['transaction'] = $orders->transaction;
			$this->data['hotline'] = $orders->hotline;
		} else {
			$this->data['transaction'] = array();
			$this->data['hotline'] = '';
		}
		$this->load->view('billing_printed_contract', isset($this->data) ? $this->data : NULL);
	}

	public function upload()
	{
		$this->data["pageName"] = $this->lang->line('update_img_authentication');
		$dataGet = $this->input->get();
		$dataGet['id'] = $this->security->xss_clean($dataGet['id']);
		$dataPost = array(
			"id" => $dataGet['id']
		);
		$result = $this->api->apiPost($this->userInfo['token'], "transaction/get_image_banking", $dataPost);
		$this->data['result'] = $result->data;
		$this->data['template'] = 'page/transaction/upload';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function viewImg()
	{
		$this->data["pageName"] = $this->lang->line('view_img_authentication');
		$dataGet = $this->input->get();
		$dataGet['id'] = $this->security->xss_clean($dataGet['id']);
		$dataPost = array(
			"id" => $dataGet['id']
		);
		$result = $this->api->apiPost($this->userInfo['token'], "transaction/get_image_banking", $dataPost);
		$this->data['result'] = $result->data;
		$this->data['template'] = 'page/transaction/view_img';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function viewImg_kt()
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
		$result = $this->api->apiPost($this->userInfo['token'], "transaction/get_image_banking", $dataPost);
		$this->data['result'] = $result->data;
		$this->data['template'] = 'page/transaction_kt/view_img';
		$this->data['reasons_cancel'] = reasons_cancel_transaction();
		$this->data['reasons_return'] = reasons_return_transaction();
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function uploadImage()
	{
		// $data = $this->input->post();
		if ($_FILES['file']['size'] > 10000000) {
			return $this->pushJson('200', json_encode(array(
				'code' => '201',
				'msg' => 'Kích cỡ max là 10MB'
			)));
		}
		$acceptFormat = array("jpeg", "png", "jpg", "mp3", "mp4");
		if (in_array($_FILES['file']['type'], $acceptFormat)) {
			return $this->pushJson('200', json_encode(array(
				'code' => '201',
				'msg' => 'Định dạng không cho phép',
				'type' => $_FILES['file']['type']
			)));
		}

		$serviceUpload = $this->config->item("url_service_upload");
		// $curlFile  = new CURLFile($_FILES["avatar"]["tmp_name"],$_FILES["avatar"]["type"],$_FILES["avatar"]["name"]);
		$cfile = new CURLFile($_FILES['file']["tmp_name"], $_FILES['file']["type"], $_FILES['file']["name"]);
		$post = array('avatar' => $cfile);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $serviceUpload);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		$result1 = json_decode($result);

		$random = sha1(substr(md5(rand()), 0, 8));

		$response = array(
			'code' => 200,
			"msg" => "success",
			'path' => $result1->path,
			'key' => $random,
			'raw_name' => $_FILES['file']['name']
		);
		$push = json_encode($response);
		return $this->pushJson(200, $push);
	}

	public function doUpload()
	{
		$data = $this->input->post();
		$data['transactionId'] = $this->security->xss_clean($data['transactionId']);
		$data['expertise'] = $this->security->xss_clean($data['expertise']);
		$image_expertise = array(
			"expertise" => $data['expertise'],
		);
		$dataPost = array(
			"id" => $data['transactionId'],
			"image_expertise" => $image_expertise,
		);
		// var_dump($dataPost);die;
		$result = $this->api->apiPost($this->userInfo['token'], "transaction/upload_image", $dataPost);

		$this->pushJson('200', json_encode(array("code" => "200", "data" => $result)));

	}

	public function deleteImage()
	{
		// delete image on service upload
	}

	public function update()
	{
		$data = $this->input->post();
		$data['field'] = $this->security->xss_clean($data['field']);
		$data['value'] = $this->security->xss_clean($data['value']);
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['gach_no'] = $this->security->xss_clean($data['gach_no']);

		// check nếu tồn tại gạch  tự động
		if ($data['field'] == 'code_transaction_bank') {
			if ($data['gach_no'] == 1) {
				$this->api->apiPost($this->userInfo['token'], "transaction/cancle_gach_no_tu_dong", [
					'code_transaction_bank' => $data['value']
				]);
			} else {
				$check_gach_no = $this->api->apiPost($this->userInfo['token'], "transaction/check_gach_no_tu_dong", [
					'code_transaction_bank' => $data['value']
				]);
				if ($check_gach_no->status != 200) {
					$this->pushJson('200', json_encode(array("status" => "401", "msg" => 'bank_transaction', "type" => "bank_transaction")));
					return;
				}
			}
		}

		$condition = array(
			'id' => $data['id'],
			$data['field'] => $data['value'],
			"updated_by" => $this->user['email']


		);
		// var_dump($this->user['token']); die;
		$return = $this->api->apiPost($this->user['token'], "transaction/update_transaction", $condition);
		$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
	}

	public function updateDescriptionImage()
	{
		$data = $this->input->post();
		$data['transactionId'] = $this->security->xss_clean($data['transactionId']);
		$expertise = array();
		if (!empty($data['expertise'])) $expertise = $this->security->xss_clean($data['expertise']);
		$sendApi = array(
			"id" => $data['transactionId'],
			'expertise' => $expertise,
		);
		//Insert log
		$return = $this->api->apiPost($this->user['token'], "transaction/process_update_description_img", $sendApi);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'msg' => "Upload ảnh thành công!",
				'type' => $return->type,
				'data' => $return->data
			];
			$this->pushJson('200', json_encode($response));
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Upload ảnh thất bại!",
				'type' => $return->type
			];
			$this->pushJson('200', json_encode($response));
			return;
		}

	}

	public function approve()
	{
		$data = $this->input->post();
		$data['transaction_id'] = $this->security->xss_clean($data['transaction_id']);
		$data['approve_note'] = $this->security->xss_clean($data['approve_note']);
		$data['status'] = $this->security->xss_clean($data['status']);
		$data['code_transaction_bank'] = trim($this->security->xss_clean($data['code_transaction_bank']));
		$data['bank'] = $this->security->xss_clean($data['bank']);
		$data['gach_no'] = $this->security->xss_clean($data['gach_no']);
		$dataPost = array(
			"transaction_id" => $data['transaction_id'],
			"code_transaction_bank" => $data['code_transaction_bank'],
			"bank" => $data['bank'],
			"approve_note" => $data['approve_note'],
			"status" => $data['status']
		);
		// check nếu tồn tại gạch tự động
		if ($data['gach_no'] == 1) {
			$this->api->apiPost($this->userInfo['token'], "transaction/cancle_gach_no_tu_dong", [
				'code_transaction_bank' => $data['code_transaction_bank']
			]);
		} else {
			$check_gach_no = $this->api->apiPost($this->userInfo['token'], "transaction/check_gach_no_tu_dong", [
				'code_transaction_bank' => $data['code_transaction_bank']
			]);
			if ($check_gach_no->status != 200) {
				$this->pushJson('200', json_encode(array("status" => "401", "msg" => 'bank_transaction', "type" => "bank_transaction")));
				return;
			}
		}

		$result = $this->api->apiPost($this->userInfo['token'], "transaction/approve_contract", $dataPost);

		if (!empty($result->status) && $result->status == 200) {

			if ($result->data->type_payment == 1 || $result->data->type_payment == 4) {

				$contract = $result->data_contract;
				$transaction = $result->data;



				if ((isset($contract->investor_id) || isset($contract->investor_code) && isset($contract->disbursement_date))) {
					$investor_code = "";
					if (isset($contract->investor_id)) {
						$data_in = array("id" => $contract->investor_id);
						$investors = $this->api->apiPost($this->userInfo['token'], "investor/get_one", $data_in);
						if ($investors->status == 200) {
							$investor_code = $investors->data->code;
						} else {
							$investor_code = $contract->investor_code;
						}
					} else {
						$investor_code = $contract->investor_code;
					}
					// Update chậm trả và lãi đã trừ kỳ cuối vào table contract
					$dataSendApiInterest = array(
						'code_contract' => $contract->code_contract,
						'code_coupon' => $contract->loan_infor->code_coupon,
						'date_pay' => $transaction->date_pay
					);
					$this->api->apiPost($this->userInfo['token'],'transaction/update_date_late_and_interest_reduction', $dataSendApiInterest);

					$data_delete = array(
						"code_contract" => $contract->code_contract,
						"status_contract" => $contract->status
					);
					$result_delete_and_update = $this->api->apiPost($this->userInfo['token'], "contract/delete_lai_ky_lai_thang", $data_delete);
					if (!empty($result_delete_and_update->status) && $result_delete_and_update->status == 200) {


						$dataPost_dele = array(
							"code_contract" => $contract->code_contract,
							"investor_code" => $investor_code,
							"disbursement_date" => $contract->disbursement_date,
							"date_pay" => $transaction->date_pay
						);

						$processContract = $this->api->apiPost($this->userInfo['token'], "generateContract/processContract", $dataPost_dele);

						if (!empty($processContract->status) && $processContract->status == 200) {
							$dataPost = array(
								"code_contract" => $contract->code_contract,
								"investor_code" => $investor_code,
								"disbursement_date" => $contract->disbursement_date
							);
							$payment_all_contract = $this->api->apiPost($this->userInfo['token'], "transaction/payment_all_contract", $dataPost);
							if (!empty($payment_all_contract->status) && $payment_all_contract->status == 200) {

								$id_store = $contract->store->id;
								$store_digital = $this->api->apiPost($this->userInfo['token'], "nextpay/check_store_create_contract_digital", ['store_id'=> $id_store]);
								if (!empty($store_digital->status) && $store_digital->status == 200) {
									$isStoreDigital = $store_digital->data;
								} else {
									$isStoreDigital = 0;
								}
								// Nếu PGD có áp dụng HĐ điện tử thì gửi BB
								if ($isStoreDigital == 1) {
									if (!empty($transaction->type) && $transaction->type == 3) {
										$exists_bbbgs = false;
										if (!empty($contract->megadoc->bbbg_after_sign->status && in_array($contract->megadoc->bbbg_after_sign->status, [0,1,2,3,7,99]))) {
											$exists_bbbgs = true;
										}
										// Gửi BBBG điện tử sau khi tất toán hợp đồng sang Megadoc
										if (!$exists_bbbgs) {
											$dataSend = array();
											$dataSend['contract_id'] = $contract->_id->{'$oid'};
											$dataSend['status_approve'] = 19;
											$dataSend['create_type'] = 'one';
											$result_resend = $this->api->apiPost($this->userInfo['token'], "contract/resend_file_to_megadoc", $dataSend);
											$this->pushJson('200', json_encode(array("status" => "200", "msg" => 'Thành công')));
										}
									}
								}
							} else {
								$this->pushJson('200', json_encode(array("status" => "401", "msg" => 'Hợp đồng không có mã nhà đầu tư và ngày giải ngân. 1')));
							}
						}
						//update du no goc va ngay_ky_tra vao bang contract da gan cho Call THN
						$sync_contract_caller = $this->api->apiPost($this->userInfo['token'], 'DebtCall/sync_contract_to_caller', ['code_contract' => $contract->code_contract]);
					}

				} else {

					$this->pushJson('200', json_encode(array("status" => "401", "msg" => 'Hợp đồng không có mã nhà đầu tư và ngày giải ngân. 2')));
					return;

				}
			}
			if ($result->data->type_payment == 2) {

				$logData = $this->api->apiPost($this->userInfo['token'], "log/get_log_gh", array("contract_id" => $result->data_contract->_id->{'$oid'}));
				if (!empty($logData->status) && $logData->status == 200) {
					$log = $logData->data;
				} else {
					$log = array();
				}
				$dataPost_app_ct = array(
					"number_day_loan" => $log->new->number_day_loan * 30,
					"contract_id" => $result->data_contract->_id->{'$oid'},
					"status" => 33,
					"amount_money" => $log->new->amount_money,
					"type_loan" => $log->new->type_loan,
				);
				$result_ct = $this->api->apiPost($this->userInfo['token'], "contract/approve", $dataPost_app_ct);
//				if (!empty($result_ct->status) && $result_ct->status == 200) {
					//call api sinh hop đồng gia hạn
					$arrPost = array(
						"contract_id" => $result->data_contract->_id->{'$oid'},
						"number_day_loan" => $log->new->number_day_loan * 30,
					);
					$resultExtension = $this->api->apiPost($this->userInfo['token'], "contract_cc_gh/approve_gia_han", $arrPost);
					// var_dump($resultExtension);die;
					if (!empty($resultExtension->status) && $resultExtension->status == 200) {
						// call api tao bang sinh lai

						$disbursement_date = (int)$resultExtension->disbursement_date;
						$dataPost_ge = array(
							"code_contract" => $resultExtension->data->code_contract,
							"investor_code" => $resultExtension->data->investor_code,
							"disbursement_date" => $disbursement_date,
							"secret_key" => "",
							"code_contract_disbursement_origin" => $resultExtension->data->code_contract_parent_gh,
						);
						$result_ct = $this->api->apiPost($this->userInfo['token'], "generateContract/processContract", $dataPost_ge);
						$this->api->apiPost($this->userInfo['token'], "transaction/generate_money_gh", $dataPost_ge);
						$this->api->apiPost($this->userInfo['token'], "transaction/generate_money_thieu_gh", $dataPost_ge);
						$this->api->apiPost($this->userInfo['token'], "transaction/payment_tien_thua_gh_cc", $dataPost_ge);


						if (!empty($result_ct->status) && $result_ct->status == 200) {
							$this->pushJson('200', json_encode(array("status" => "200", "msg" => $result_ct->message, "data" => $result_ct)));
							return;
						} else {
							$this->pushJson('200', json_encode(array("status" => "401", "msg" => $result_ct->message, "data" => $result_ct)));
							return;
						}

					} else {
						$this->pushJson('200', json_encode(array("status" => "401", "msg" => $resultExtension->message, "data" => $result_ct)));
						return;
					}

//				}
			}
			if ($result->data->type_payment == 3) {
				$logData = $this->api->apiPost($this->userInfo['token'], "log/get_log_cc", array("contract_id" => $result->data_contract->_id->{'$oid'}));
				if (!empty($logData->status) && $logData->status == 200) {
					$log = $logData->data;
				} else {
					$log = array();
				}
				$dataPost_app_ct = array(
					"number_day_loan" => $log->new->number_day_loan * 30,
					"contract_id" => $result->data_contract->_id->{'$oid'},
					"status" => 34,
					"amount_money" => $log->new->amount_money,
					"type_loan" => $log->new->type_loan,
					"type_interest" => $log->new->type_interest,
				);
				$result_ct_app = $this->api->apiPost($this->userInfo['token'], "contract/approve", $dataPost_app_ct);
				if (!empty($result_ct_app->status) && $result_ct_app->status == 200) {

					$resultExtension = $this->api->apiPost($this->userInfo['token'], "contract_cc_gh/approve_co_cau", $dataPost_app_ct);

					if (!empty($resultExtension->status) && $resultExtension->status == 200) {
						// call api tao bang sinh lai

						$disbursement_date = (int)$resultExtension->disbursement_date;
						$dataPost_ct = array(
							"code_contract" => $resultExtension->data->code_contract,
							"investor_code" => $resultExtension->data->investor_code,
							"disbursement_date" => $disbursement_date,
							"secret_key" => "",
						);
						$result_ct = $this->api->apiPost($this->userInfo['token'], "generateContract/processContract", $dataPost_ct);
						if (!empty($result_ct->status) && $result_ct->status == 200) {
							$this->pushJson('200', json_encode(array("status" => "200", "msg" => $result_ct->message, "data" => $result_ct)));
							return;
						} else {
							$this->pushJson('200', json_encode(array("status" => "401", "msg" => $result_ct->message, "data" => $result_ct)));
							return;
						}

					} else {
						$this->pushJson('200', json_encode(array("status" => "401", "msg" => $resultExtension->message, "data" => $result_ct)));
						return;
					}

				}
			}
			$response = [
				'res' => true,
				'status' => "200",
				'msg' => $result->msg,
				'url' => $result->url
			];
			//echo json_encode($response);
			$this->pushJson('200', json_encode($response));
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => 'Có lỗi trong quá trình duyệt',
				'data' => $result
			];
			$this->pushJson('200', json_encode($response));
		}

	}


	public function approveExtension()
	{
		$data = $this->input->post();
		$data['transaction_id'] = $this->security->xss_clean($data['transaction_id']);
		$data['note'] = $this->security->xss_clean($data['note']);
		$data['status'] = $this->security->xss_clean($data['status']);
		$data['investor'] = $this->security->xss_clean($data['investor']);
		$dataPost = array(
			"transaction_id" => $data['transaction_id'],
			"note" => $data['note'],
			"status" => $data['status']
		);
		$result = $this->api->apiPost($this->userInfo['token'], "transaction/approve_contract_extension", $dataPost);
		if (!empty($result->status) && $result->status == 200) {

			//call api sinh hop đồng gia hạn
			$arrPost = array(
				"contract_id" => $result->contract_id,
				"investor" => $data['investor']
			);
			$resultExtension = $this->api->apiPost($this->userInfo['token'], "contract/accountant_extension", $arrPost);
			if (!empty($resultExtension->status) && $resultExtension->status == 200) {
				// call api tao bang sinh lai
				$disbursement_date = (int)$resultExtension->disbursement_date;
				$dataPost = array(
					"code_contract" => $resultExtension->data->code_contract,
					"investor_code" => $resultExtension->data->investor_code,
					"disbursement_date" => $disbursement_date,
					"secret_key" => "",
				);
				$resultContract = $this->api->apiPost($this->userInfo['token'], "generateContract/processContract", $dataPost);
				if (!empty($resultContract->status) && $resultContract->status == 200) {
					$this->pushJson('200', json_encode(array("code" => "200", "msg" => $result->message, "data" => $result)));
					return;
				} else {
					$this->pushJson('200', json_encode(array("code" => "401", "msg" => $resultContract->message, "data" => $resultContract)));
					return;
				}
			} else {
				$this->pushJson('200', json_encode(array("code" => "401", "msg" => $resultExtension->message, "data" => $result)));
				return;
			}
		} else {
			$this->pushJson('200', json_encode(array("code" => "401", "data" => $result)));
			return;
		}

		// $this->pushJson('200', json_encode(array("code" => "200", "data" => $result)));
	}

	public function printed_billing_contract()
	{
		$id = $this->uri->segment(3);
		if (empty($id)) {
			$this->session->set_flashdata('error', $this->lang->line('Does_not_exist_transaction'));
			redirect(base_url('transaction'));
			return;
		}
		$id = $this->security->xss_clean($id);
		//Get information
		$orders = $this->api->apiPost($this->userInfo['token'], "transaction/get_detail", array("id" => $id));
		if (!empty($orders->status) && $orders->status == 200) {
			$this->data['transaction'] = $orders->transaction;
			$this->data['code_billing'] = $orders->code_billing;
			$this->data['hotline'] = $orders->hotline;
		} else {
			$this->data['transaction'] = array();
			$this->data['code_billing'] = array();
			$this->data['hotline'] = '';
		}
		$this->load->view('billing_print/billing_contract', isset($this->data) ? $this->data : NULL);
		return;
	}

	public function sendApprove()
	{
		$this->data["pageName"] = "Cập nhập ảnh chứng thực và gửi duyệt";
		$dataGet = $this->input->get();
		$dataGet['id'] = $this->security->xss_clean($dataGet['id']);
		$dataPost = array(
			"id" => $dataGet['id']
		);
		$result = $this->api->apiPost($this->userInfo['token'], "transaction/get_image_banking", $dataPost);
		$this->data['result'] = $result->data;
		$this->data['template'] = 'page/transaction/send_approve';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function updateApproveImage()
	{
		$data = $this->input->post();
		$data['transactionId'] = $this->security->xss_clean($data['transactionId']);
		$expertise = array();
		if (empty($data['expertise'])) {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => "Bạn chưa chọn ảnh chứng từ!")));
			return;
		}
		if (!empty($data['expertise'])) $expertise = $this->security->xss_clean($data['expertise']);
		$sendApi = array(
			"id" => $data['transactionId'],
			'expertise' => $expertise,
		);
		//Insert log
		$return = $this->api->apiPost($this->user['token'], "transaction/process_update_approve_img", $sendApi);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'msg' => 'Chờ kế toán xử lý!',
				'type' => $return->type,
				'data' => $return->data
			];
			$this->pushJson('200', json_encode($response));
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Có lỗi trong quá trình gửi duyệt!",
				'type' => $return->type
			];
			$this->pushJson('200', json_encode($response));
			return;
		}
	}

	public function approveTransactionHeyU()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$code = !empty($_GET['code']) ? $_GET['code'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$code_transaction_bank = !empty($_GET['code_transaction_bank']) ? $_GET['code_transaction_bank'] : "";
		$email = !empty($_GET['email']) ? $_GET['email'] : "";
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "all";
		$this->data["pageName"] = 'Quản lý phiếu thu HeyU + MIC-TNDS';
		$data = array();
		if (!empty($fdate) && !empty($tdate)) {
			if (strtotime($fdate) > strtotime($tdate)) {
				$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
				redirect(base_url('transaction/approveTransactionHeyU'));
			}
			if (empty($_GET['fdate']) || empty($_GET['tdate'])) {
				$this->session->set_flashdata('error', $this->lang->line('Please_select_input_date'));
				redirect(base_url('transaction/approveTransactionHeyU'));
			}
			$data = array(
				"fdate" => $fdate,
				"tdate" => $tdate,
			);
		}
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');

		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;

		$config['base_url'] = base_url('transaction/approveTransactionHeyU') . '?fdate=' . $fdate . '&tdate=' . $tdate . '&store=' . $store . '&tab=' . $tab . '&code_transaction_bank=' . $code_transaction_bank . '&status=' . $status . '&code=' . $code . '&email=' . $email;
		$data = array(
			"per_page" => $config['per_page'],
			"uriSegment" => $config['uri_segment'],
			"fdate" => $fdate,
			"tdate" => $tdate,
			"tab" => $tab,
		);
		if (!empty($status)) {
			$data['status'] = $status;
		}

		if (!empty($allocation)) {
			$data['allocation'] = $allocation;
		}
		if (!empty($store)) {
			$data['store'] = $store;
		}
		if (!empty($email)) {
			$data['email'] = $email;
		}

		if (!empty($code_transaction_bank)) {
			$data['code_transaction_bank'] = $code_transaction_bank;
		}
		if (!empty($code)) {
			$data['code'] = $code;
		}

		$transactionData = $this->api->apiPost($this->userInfo['token'], "transaction/get_all_kt_hey_u", $data);
		if (!empty($transactionData->status) && $transactionData->status == 200) {
			$this->data['transactionData'] = $transactionData->data;
			$this->data['groupRoles'] = $transactionData->groupRoles;
			$config['total_rows'] = $transactionData->total;
		} else {
			$this->data['transactionData'] = array();
			$this->data['groupRoles'] = array();
		}
		//get store
		$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all");
		if (!empty($storeData->status) && $storeData->status == 200) {
			$this->data['storeData'] = $storeData->data;
		} else {
			$this->data['storeData'] = array();
		}
		$this->data['fdate'] = $fdate;
		$this->data['tdate'] = $tdate;
		$this->data['status'] = $status;
		$this->pagination->initialize($config);
		$this->data['result_count'] = "Hiển thị " . $config['total_rows'] . " Kết quả";
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/heyU/approve_transaction_heyU';
		$this->data['reasons_cancel'] = reasons_cancel_transaction();
		$this->data['reasons_return'] = reasons_return_transaction();
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;
	}

	public function viewDetailHeyU()
	{
		$id = $this->uri->segment(3);
		if (empty($id)) {
			$this->session->set_flashdata('error', $this->lang->line('Does_not_exist_order'));
			redirect(base_url('transaction'));
			return;
		}
		$id = $this->security->xss_clean($id);
		//Get information
		$heyus = $this->api->apiPost($this->userInfo['token'], "transaction/get_detail_heyU", array("id" => $id));
		if (!empty($heyus->status) && $heyus->status == 200) {
			$this->data['heyUData'] = $heyus->heyUData;
			$this->data['transaction'] = $heyus->transaction;
		} else {
			$this->data['orderData'] = array();
			$this->data['transaction'] = array();
		}
		$this->data['template'] = 'page/heyU/list_detail_per_heyU';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function approveHeyU()
	{
		$data = $this->input->post();
		$data['transaction_id'] = $this->security->xss_clean($data['transaction_id']);
		$data['approve_note'] = $this->security->xss_clean($data['approve_note']);
		$data['status'] = $this->security->xss_clean($data['status']);

		$data['code_transaction_bank'] = $this->security->xss_clean($data['code_transaction_bank']);
		$data['bank'] = $this->security->xss_clean($data['bank']);
		$data['reasons'] = !empty($data['reasons']) ? $data['reasons'] : [];
		$reasons = [];
		foreach($data['reasons'] as $value) {
			if ($data['status'] == 11) { // Kế Toán Trả Về 
				$reasons[] = [
					"type" => "return",
					"id" => $value,
					"value" => reasons_return_transaction($value)
				];
			} else if ($data['status'] == 3) { // Kế Toán Hủy
				$reasons[] = [
					"type" => "cancel",
					"id" => $value,
					"value" => reasons_cancel_transaction($value)
				];
			}
		}

		$dataPost = array(
			"transaction_id" => $data['transaction_id'],
			"code_transaction_bank" => $data['code_transaction_bank'],
			"bank" => $data['bank'],
			"approve_note" => $data['approve_note'],
			"status" => $data['status'],
			"reasons" => $reasons
		);

		$result = $this->api->apiPost($this->userInfo['token'], "transaction/approve_heyu", $dataPost);
		if (!empty($result->status) && $result->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'msg' => $result->msg,
				'url' => $result->url,
			];
			//echo json_encode($response);
			$this->pushJson('200', json_encode($response));
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => $result->msg,
				'data' => $result
			];
			$this->pushJson('200', json_encode($response));
		}
	}

	public function returnTransactionStore()
	{
		$data = $this->input->post();
		$data['transaction_id'] = $this->security->xss_clean($data['transaction_id']);
		$data['approve_note'] = $this->security->xss_clean($data['approve_note']);
		$data['status'] = $this->security->xss_clean($data['status']);
		$data['reasons'] = $this->security->xss_clean($data['reasons']);
		$reasons = [];
		foreach($data['reasons'] as $value) {
			$reasons[] = [
				"type" => "return",
				"id" => $value,
				"value" => reasons_return_transaction($value)
			];
		}
		$dataPost = array(
			"transaction_id" => $data['transaction_id'],
			"approve_note" => $data['approve_note'],
			"status" => $data['status'],
			"reasons" => $reasons
		);
		$result = $this->api->apiPost($this->userInfo['token'], "transaction/return_transaction_store", $dataPost);
		if (!empty($result->status) && $result->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'msg' => $result->msg,
				'url' => $result->url
			];
			//echo json_encode($response);
			$this->pushJson('200', json_encode($response));
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => $result->msg,
				'data' => $result
			];
			$this->pushJson('200', json_encode($response));
			return;
		}
	}

	public function viewDetailMicTnds()
	{
		$id = $this->uri->segment(3);
		if (empty($id)) {
			$this->session->set_flashdata('error', $this->lang->line('Does_not_exist_order'));
			redirect(base_url('transaction'));
			return;
		}
		$id = $this->security->xss_clean($id);
		//Get information
		$mic_tnds = $this->api->apiPost($this->userInfo['token'], "transaction/get_detail_mic_tnds", array("id" => $id));
		if (!empty($mic_tnds->status) && $mic_tnds->status == 200) {
			$this->data['mic_tnds'] = $mic_tnds->mic_tnds;
			$this->data['transaction'] = $mic_tnds->transaction;
			if(!empty($this->data['transaction']->code_coupon_cash))
			{
				$res_cp = $this->api->apiPost($this->userInfo['token'], "coupon_cash/get_coupon_cash_by_code", array("code" => $this->data['transaction']->code_coupon_cash));
				if (!empty($res_cp->status) && $res_cp->status == 200) {
                   $this->data['coupon_cash'] = $res_cp->data;
				}else{
                   $this->data['coupon_cash'] = array();
				}
			}
		} else {
			$this->data['mic_tnds'] = array();
			$this->data['transaction'] = array();
		}
		$this->data['template'] = 'page/mic_tnds/list_detail_mic_tnds';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function viewDetailVbiTnds()
	{
		$id = $this->uri->segment(3);
		if (empty($id)) {
			$this->session->set_flashdata('error', $this->lang->line('Does_not_exist_order'));
			redirect(base_url('transaction'));
			return;
		}
		$id = $this->security->xss_clean($id);
		//Get information
		$vbi_tnds = $this->api->apiPost($this->userInfo['token'], "transaction/get_detail_vbi_tnds", array("id" => $id));

		if (!empty($vbi_tnds->status) && $vbi_tnds->status == 200) {
			$this->data['vbi_tnds'] = $vbi_tnds->vbi_tnds;
			$this->data['transaction'] = $vbi_tnds->transaction;
			if(!empty($this->data['transaction']->code_coupon_cash))
			{
				$res_cp = $this->api->apiPost($this->userInfo['token'], "coupon_cash/get_coupon_cash_by_code", array("code" => $this->data['transaction']->code_coupon_cash));
				if (!empty($res_cp->status) && $res_cp->status == 200) {
                   $this->data['coupon_cash'] = $res_cp->data;
				}else{
                   $this->data['coupon_cash'] = array();
				}
			}
		} else {
			$this->data['vbi_tnds'] = array();
			$this->data['transaction'] = array();
		}
		$this->data['template'] = 'page/vbi_tnds/list_detail_vbi_tnds';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function getBillingUtilities()
	{
		$stores = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active", []);
		$store = $this->api->apiPost($this->userInfo['token'], "mic_tnds/get_store_by_user", []);
		if (!empty($store->status) && $store->status == 200) {
			$this->data['stores'] = $store->data;
		} else {
			$this->data['stores'] = $stores->data;
		}
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "";
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$trading_code = !empty($_GET['trading_code']) ? $_GET['trading_code'] : "";
		$service_name = !empty($_GET['service_name']) ? $_GET['service_name'] : "";
		$publisher_name = !empty($_GET['publisher_name']) ? $_GET['publisher_name'] : "";
		$service_code = !empty($_GET['service_code']) ? $_GET['service_code'] : "";
		$code_transaction = !empty($_GET['code_transaction']) ? $_GET['code_transaction'] : "";
		$filter_by_store = !empty($_GET['filter_by_store']) ? $_GET['filter_by_store'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$data = [];
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('transaction/getBillingUtilities') . '?tab=' . $tab . '&fdate=' . $fdate . '&tdate=' . $tdate . '&trading_code=' . $trading_code . '&service_name=' . $service_name . '&publisher_name=' . $publisher_name . '&service_code=' . $service_code . '&code_transaction=' . $code_transaction . '&filter_by_store=' . $filter_by_store . '&status=' . $status;
		$config['per_page'] = 20;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;

		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];
		$data['tab'] = $tab;
		if (!empty($fdate) && !empty($tdate)) {
			$data['fdate'] = $fdate;
			$data['tdate'] = $tdate;
		}
		if (!empty($trading_code)) {
			$data['trading_code'] = $trading_code;
		}
		if (!empty($service_name)) {
			$data['service_name'] = $service_name;
		}
		if (!empty($publisher_name)) {
			$data['publisher_name'] = $publisher_name;
		}
		if (!empty($service_code)) {
			$data['service_code'] = $service_code;
		}
		if (!empty($code_transaction)) {
			$data['code_transaction'] = $code_transaction;
		}
		if (!empty($filter_by_store)) {
			$data['filter_by_store'] = $filter_by_store;
		}
		if (!empty($status)) {
			$data['status'] = $status;
		}
		$service = $this->api->apiPost($this->userInfo['token'], 'service/get_all_service', []);
		if (!empty($service->status) && $service->status == 200) {
			$this->data['services'] = $service->data;
		} else {
			$this->data['services'] = array();
		}
		$response = $this->api->apiPost($this->userInfo['token'], "transaction/get_list_billing_utilities", $data);
		if ($response->status == 200) {
			$this->data['transaction'] = $response->data;
			
			foreach ($response->data as $key => $datum) {
				$data_send_order = array(
					"id" => $datum->_id->{'$oid'}
				);
				if (isset($datum->type) && $datum->type == 1) {
					$order = $this->api->apiPost($this->userInfo["token"], "transaction/get_order", $data_send_order);
					if (!empty($order->status) && $order->status == 200) {
						$datum->status_order = $order->orderData[0]->status;
					}
				}
			}
			$config['total_rows'] = $response->total;
		} else {
			$this->data['transaction'] = array();
		}
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		$storeData = $this->userInfo['stores'];
		if (!empty($storeData)) {
			$this->data['storeData'] = $storeData;
		} else {
			$this->data['storeData'] = array();
		}
		
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/transaction/list_billing';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function get_service_name_by_service_code()
	{
		$data = $this->input->post();
		$data['service_code'] = $this->security->xss_clean($data['service_code']);
		$data_send = array(
			//"type_login" => 1,
			"service_code" => $data['service_code']
		);

		$services = $this->api->apiPost("", "service/get_service_name_by_service_code", $data_send);
		if (!empty($services->status) && $services->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $services->data
			];
			$this->pushJson('200', json_encode($response));
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'data' => $this->lang->line('no_depreciation_configured')
			];
			$this->pushJson('200', json_encode($response));
			return;
		}
	}

	public function viewDetailVbiUtv()
	{
		$id = $this->uri->segment(3);
		if (empty($id)) {
			$this->session->set_flashdata('error', $this->lang->line('Does_not_exist_order'));
			redirect(base_url('transaction'));
			return;
		}
		$id = $this->security->xss_clean($id);
		//Get information
		$vbi_utv = $this->api->apiPost($this->userInfo['token'], "transaction/get_detail_vbi_utv", array("id" => $id));

		if (!empty($vbi_utv->status) && $vbi_utv->status == 200) {
			$this->data['vbi_utv'] = $vbi_utv->vbi_utv;
			$this->data['transaction'] = $vbi_utv->transaction;
		} else {
			$this->data['vbi_utv'] = array();
			$this->data['transaction'] = array();
		}
		$this->data['template'] = 'page/bao_hiem_vbi/utv/list_detail_vbi_utv';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function viewDetailVbiSxh()
	{
		$id = $this->uri->segment(3);
		if (empty($id)) {
			$this->session->set_flashdata('error', $this->lang->line('Does_not_exist_order'));
			redirect(base_url('transaction'));
			return;
		}
		$id = $this->security->xss_clean($id);
		//Get information
		$vbi_sxh = $this->api->apiPost($this->userInfo['token'], "transaction/get_detail_vbi_sxh", array("id" => $id));

		if (!empty($vbi_sxh->status) && $vbi_sxh->status == 200) {
			$this->data['vbi_sxh'] = $vbi_sxh->vbi_sxh;
			$this->data['transaction'] = $vbi_sxh->transaction;
		} else {
			$this->data['vbi_sxh'] = array();
			$this->data['transaction'] = array();
		}
		$this->data['template'] = 'page/bao_hiem_vbi/sxh/list_detail_vbi_sxh';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
	public function viewDetailPtiVta()
	{
		$id = $this->uri->segment(3);
		if (empty($id)) {
			$this->session->set_flashdata('error', $this->lang->line('Does_not_exist_order'));
			redirect(base_url('transaction'));
			return;
		}
		$id = $this->security->xss_clean($id);
		//Get information
		$pti_vta = $this->api->apiPost($this->userInfo['token'], "transaction/get_detail_pti_vta", array("id" => $id));

		if (!empty($pti_vta->status) && $pti_vta->status == 200) {
			$this->data['pti_vta'] = $pti_vta->pti_vta;
			$this->data['transaction'] = $pti_vta->transaction;
		} else {
			$this->data['pti_vta'] = array();
			$this->data['transaction'] = array();
		}
		$this->data['template'] = 'page/pti_vta/list_detail_pti_vta';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
		public function revert_order()
	{
		$id_order = !empty($_POST['id_order']) ? $_POST['id_order'] : '';
		
		$res = $this->api->apiPost($this->user['token'], "BillingVimo/revert_bill", ['id_order' => $id_order]);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $res->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => $res->message)));
			return;
		}
	}

	public function momo()
	{
		$cpanelV2 = CpanelV2::getDomain();
		$token = $this->userInfo['token'];
	    $this->data['template'] = 'page/transaction/momo';
	    $this->data['url'] = $cpanelV2 . "cpanel/momo/transactions?access_token=$token";
		$this->load->view('template', $this->data);
		return;
	}


	public function vpbank()
	{
		//$cpanelV2 = CpanelV2::getDomain();
		$cpanelV2 = $this->config->item("cpanel_v2_url");
		$token = $this->userInfo['token'];
	    $this->data['template'] = 'page/transaction/vpbank';
	    $this->data['url'] = $cpanelV2 . "cpanel/vpbank/transactions?access_token=$token";
		$this->load->view('template', $this->data);
		return;
	}

	public function cancel_transaction()
	{
		$data = $this->input->post();
		$data['transaction_id'] = $this->security->xss_clean($data['transaction_id']);
		$data['approve_note'] = $this->security->xss_clean($data['approve_note']);
		$data['status'] = $this->security->xss_clean($data['status']);
		$data['code_transaction_bank'] = trim($this->security->xss_clean($data['code_transaction_bank']));
		$data['bank'] = $this->security->xss_clean($data['bank']);
		$data['reasons'] = $this->security->xss_clean($data['reasons']);
		$reasons = [];
		foreach($data['reasons'] as $value) {
			$reasons[] = [
				"type" => "cancel",
				"id" => $value,
				"value" => reasons_cancel_transaction($value)
			];
		}
		$dataPost = array(
			"transaction_id" => $data['transaction_id'],
			"code_transaction_bank" => $data['code_transaction_bank'],
			"bank" => $data['bank'],
			"approve_note" => $data['approve_note'],
			"status" => $data['status'],
			"reasons" => $reasons
		);
		$result = $this->api->apiPost($this->userInfo['token'], "transaction/cancel_contract", $dataPost);
		if (!empty($result->status) && $result->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'msg' => $result->msg,
				'url' => $result->url
			];
			//echo json_encode($response);
			$this->pushJson('200', json_encode($response));
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => 'Có lỗi trong quá trình duyệt',
				'data' => $result
			];
			$this->pushJson('200', json_encode($response));
		}
	}

	/**
	* Show internet banking detail for cash payment flows
	*/
	public function bankPayment() {
		$this->data["pageName"] = "Thông Tin Chuyển Khoản";
		$dataGet = $this->input->get();
		$id = $this->security->xss_clean($dataGet['id']);
		$dataPost = array(
			"id" => $id
		);
		$result = $this->api->apiPost($this->userInfo['token'], "transaction/bankPaymentDetail", $dataPost);
		$this->data['result'] = $result->data;
		$this->data['qrCode'] = $result->qrCode;
		$this->data['template'] = 'page/transaction/bankPayment';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function mistakenVPBTran()
	{
		//$cpanelV2 = CpanelV2::getDomain();
		$cpanelV2 = $this->config->item("cpanel_v2_url");
		$token = $this->userInfo['token'];
	    $this->data['template'] = 'page/transaction/mistakenvpbtransaction';
	    $this->data['url'] = $cpanelV2 . "cpanel/vpbank/mistakentransaction/index?access_token=$token";
		$this->load->view('template', $this->data);
		return;
	}

	/**
	 *  Báo cáo thời gian xử lý phiếu thu BP Kế Toán
	 * 
	 * */
	public function logTranReport()
	{
		$cpanelV2 = $this->config->item("cpanel_v2_url");
		$token = $this->userInfo['token'];
	    $this->data['template'] = 'page/transaction/transProcessingTime';
	    $this->data['url'] = $cpanelV2 . "cpanel/report/logTran?access_token=$token";
		$this->load->view('template', $this->data);
		return;
	}

	public function check_transaction() {
		$data = $this->input->post();
		$tranId = !empty($data['tranId']) ? $data['tranId'] : "";
		$url = !empty($data['url']) ? $data['url'] : "";
		$baseURL = !empty($data['baseUrl']) ? $data['baseUrl'] : "";
		if (!$tranId && !$url && !$baseURL) {
			$this->pushJson('400', json_encode([
				"message" => "data is empty!"
			]));
		}
		$result = $this->api->apiPost($this->userInfo['token'], "transaction/checkInProcessTime", [
			'tranId' => $tranId,
			'url' => $url,
			'baseURL' => $baseURL
		]);
		$this->pushJson('200', json_encode($result));
	}

	/**
	 *  Danh sách phiếu thu thanh toán hoa hồng cộng tác viên TienNgay
	 *
	 * */
	public function list_trans_ctv()
	{
		$this->data["pageName"] = "Danh sách phiếu thu thanh toán hoa hồng CTV";
		$dataGet = $this->input->get();
		$from_date = $dataGet['from_date'] ? $dataGet['from_date'] : '';
		$to_date = $dataGet['to_date'] ? $dataGet['to_date'] : '';
		$name_ctv = $dataGet['name_ctv'] ? $dataGet['name_ctv'] : '';
		$sdt_ctv = $dataGet['sdt_ctv'] ? $dataGet['sdt_ctv'] : '';
		$code = $dataGet['code'] ? $dataGet['code'] : '';
		$code_transaction_bank = $dataGet['code_transaction_bank'] ? $dataGet['code_transaction_bank'] : '';
		$status = $dataGet['status'] ? $dataGet['status'] : '';
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['per_page'] = 30;
		$config['uri_segment'] = $uriSegment;
		$config['page_query_string'] = true;
		$config['base_url'] = base_url('transaction/list_trans_ctv') .
			'?from_date=' . $from_date .
			'&to_date=' . $to_date .
			'&name_ctv=' . $name_ctv .
			'&sdt_ctv=' . $sdt_ctv .
			'&status=' . $status .
			'&code=' . $code .
			'&code_transaction_bank=' . $code_transaction_bank;
		if (!empty($from_date) && !empty($to_date)) {
			if (strtotime($from_date) > strtotime($to_date)) {
				$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
				redirect(base_url('transaction/list_trans_ctv'));
			}
			if (empty($from_date) || empty($to_date)) {
				$this->session->set_flashdata('error', $this->lang->line('Please_select_input_date'));
				redirect(base_url('transaction/list_trans_ctv'));
			}
		}
		$dataSend = [
			'from_date' => $from_date,
			'to_date' => $to_date,
			'name_ctv' => $name_ctv,
			'sdt_ctv' => $sdt_ctv,
			'code' => $code,
			'code_transaction_bank' => $code_transaction_bank,
			'status' => $status,
			'per_page' => $config['per_page'],
			'uriSegment' => $uriSegment,
		];
		$response = $this->api->apiPost($this->userInfo['token'], 'transaction/get_transactions_ctv', $dataSend);
		if (!empty($response->status) && $response->status == 200) {
			$this->data['transactionData'] = $response->data;
			$config['total_rows'] = $response->total;
		} else {
			$this->data['transactionData'] = array();
		}
		$this->pagination->initialize($config);
		$this->data['result_count'] = "Hiển thị " . $config['total_rows'] . " Kết quả";
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/transaction/trans_commission_ctv';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}


}

?>

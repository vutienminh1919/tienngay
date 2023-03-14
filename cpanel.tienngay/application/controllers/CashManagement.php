<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class CashManagement extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
//		$this->api = new Api();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model("time_model");
		$this->load->library('pagination');
		$this->load->helper('lead_helper');
		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
		if (!$this->userInfo)
		{			$this->session->set_flashdata('error', $this->lang->line('You_do_not_have_permission_access_this_item'));
			redirect(base_url());
			return;
		}
		if (!$this->is_superadmin) {
			$paramController = $this->uri->segment(1);
			$param = strtolower($paramController);
			if (!in_array($param, $this->paramMenus)) {
				$this->session->set_flashdata('error', $this->lang->line('not_have_permission') . ' ' . $paramController . '!');
				redirect(base_url('app'));
				return;
			}
		}
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	private function pushJson($code, $data)
	{
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}

	public function index()
	{
		$this->data["pageName"] = "Báo cáo tiền thu theo chi nhánh";
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$type_transaction = !empty($_GET['type_transaction']) ? $_GET['type_transaction'] : "";
		$total = !empty($_GET['total']) ? $_GET['total'] : "";
		$code = !empty($_GET['code']) ? $_GET['code'] : "";
		$data = array();
		$code_store = array();
		$url_code_store = "";

		if (is_array($_GET['code_store'])) {
			foreach ($_GET['code_store'] as $code_st) {
				array_push($code_store, $code_st);
				$url_code_store .= '&code_store[]=' . $code_st;
			}
		} else {
			$code_store = !empty($_GET['code_store']) ? $_GET['code_store'] : "";
			$url_code_store = '&code_store=' . $code_store;
		}
		if (!empty($fdate) && !empty($tdate)) {
			if (strtotime($fdate) > strtotime($tdate)) {
				$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
				redirect(base_url('CashManagement'));
			}
			if (empty($_GET['fdate']) || empty($_GET['tdate'])) {
				$this->session->set_flashdata('error', $this->lang->line('Please_select_input_date'));
				redirect(base_url('CashManagement'));
			}
		}
		$config = $this->config->item('pagination');
		$config['page_query_string'] = true;
		$config['base_url'] = base_url('CashManagement') . '?fdate=' . $fdate . '&tdate=' . $tdate . $url_code_store . '&type_transaction=' . $type_transaction . '&store=' . $store . '&status=' . $status;
		$data = array(
			"fdate" => $fdate,
			"tdate" => $tdate
		);
		
		if (!empty($code)) {
			$data['code'] = $code;
		}
		if (!empty($total)) {
			$data['total'] = $total;
		}
		
		if (!empty($type_transaction)) {
			$data['type_transaction'] = $type_transaction;
		}
		if (!empty($status)) {
			$data['status'] = $status;
		}
		if (!empty($code_store)) {
			$data['code_store'] = $code_store;
		}
	
		$transactionData = $this->api->apiPost($this->userInfo['token'], "transaction/get_report_invoice_store_by_day", $data);
		if (!empty($transactionData->status) && $transactionData->status == 200) {
			foreach ($transactionData->data as $key => $transaction) {
				foreach ($transaction as $key1 => $trans) {
					$total_not_yet_send = 0;
					$total_in = 0;
					$total_out = 0;
					foreach ($trans as $key2 => $tr) {
						if (in_array($tr->status, [4, 11])) {
							$total_not_yet_send += (int)$tr->total;
						}
						if (in_array($tr->status, [10])) {
							$total_not_yet_send += (int)$tr->money;
							$total_not_yet_send += (int)$tr->mic_fee;
							$total_not_yet_send += (int)$tr->fee;
							$total_not_yet_send += (int)$tr->price;
						}
						if (in_array($tr->status, [2])) {
							$total_in += (int)$tr->total;
						}
						if ($tr->status == 1 || $tr->status == "new") {
							$total_out += (int)$tr->total;
						}
					}
					$tran = (array)$trans;
					$tran[0]->total_amount_not_yet_send_user = $total_not_yet_send;
					$tran[0]->total_amount_in_user = $total_in;
					$tran[0]->total_amount_out_user = $total_out;
					$tran[0]->total_amount_transaction = $total_not_yet_send + $total_in + $total_out;
				}
			}
			$sum_cod_not_yet_send_day = 0;
			$sum_cod_in_day = 0;
			$sum_cod_out_day = 0;
			$sum_of_day = 0;
			foreach ($transactionData->total_parent as $value_parent) {
				$sum_cod_not_yet_send_day += $value_parent->store_child->total_cod_not_yet_send_day;
				$sum_cod_in_day += $value_parent->store_child->total_cod_in_day;
				$sum_cod_out_day += $value_parent->store_child->total_cod_out_day;
				$sum_of_day += $value_parent->store_child->total_cod_day;
			}
		}

		if (!empty($transactionData->status) && $transactionData->status == 200) {
			$config['total_rows'] = $transactionData->total_result;
			$this->data['transactionData'] = $transactionData->data;
			$this->data['groupRoles'] = $transactionData->groupRoles;
			$this->data['total_parent'] = $transactionData->total_parent;
			$this->data['sum_cod_not_yet_send_day'] = $sum_cod_not_yet_send_day;
			$this->data['sum_cod_in_day'] = $sum_cod_in_day;
			$this->data['sum_cod_out_day'] = $sum_cod_out_day;
			$this->data['sum_of_day'] = $sum_of_day;
		} else {
			$this->data['transactionData'] = array();
			$this->data['groupRoles'] = array();
		}
		//get store
		$storeData = $this->userInfo['stores'];
		if (!empty($storeData)) {
			$this->data['storeData'] = $storeData;
		} else {
			$this->data['storeData'] = array();
		}
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		$this->data['fdate'] = $fdate;
		$this->data['tdate'] = $tdate;
		$this->pagination->initialize($config);
		$this->data['result_count'] = $config['total_rows'];
		$this->data['template'] = 'page/reports-invoice/reports-invoice';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;
	}

	public function list_return()
	{
		$this->data["pageName"] = "Danh sách phiếu thu trả về!";
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$type_transaction = !empty($_GET['type_transaction']) ? $_GET['type_transaction'] : "";
		$total = !empty($_GET['total']) ? $_GET['total'] : "";
		$code = !empty($_GET['code']) ? $_GET['code'] : "";
		$data = array();
		$code_store = array();
		$url_code_store = "";

		if (is_array($_GET['code_store'])) {
			foreach ($_GET['code_store'] as $code_st) {
				array_push($code_store, $code_st);
				$url_code_store .= '&code_store[]=' . $code_st;
			}
		} else {
			$code_store = !empty($_GET['code_store']) ? $_GET['code_store'] : "";
			$url_code_store = '&code_store=' . $code_store;
		}
		if (!empty($fdate) && !empty($tdate)) {
			if (strtotime($fdate) > strtotime($tdate)) {
				$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
				redirect(base_url('CashManagement/list_return'));
			}
			if (empty($_GET['fdate']) || empty($_GET['tdate'])) {
				$this->session->set_flashdata('error', $this->lang->line('Please_select_input_date'));
				redirect(base_url('CashManagement/list_return'));
			}
		}
		$config = $this->config->item('pagination');
		$config['page_query_string'] = true;
		$config['base_url'] = base_url('CashManagement/list_return') . '?fdate=' . $fdate . '&tdate=' . $tdate . $url_code_store . '&type_transaction=' . $type_transaction . '&store=' . $store . '&status=' . $status;
		$data = array(
			"fdate" => $fdate,
			"tdate" => $tdate
		);

		if (!empty($code)) {
			$data['code'] = $code;
		}
		if (!empty($total)) {
			$data['total'] = $total;
		}

		if (!empty($type_transaction)) {
			$data['type_transaction'] = $type_transaction;
		}
		if (!empty($status)) {
			$data['status'] = $status;
		}
		if (!empty($code_store)) {
			$data['code_store'] = $code_store;
		}

		$transactionData = $this->api->apiPost($this->userInfo['token'], "transaction/report_transaction_pending", $data);
		if (!empty($transactionData->status) && $transactionData->status == 200) {
			foreach ($transactionData->data as $key => $transaction) {
				foreach ($transaction as $key1 => $trans) {
					$total_not_yet_send = 0;
					foreach ($trans as $key2 => $tr) {
						if (in_array($tr->status, [11])) {
							$total_not_yet_send += (int)$tr->total;
						}
					}
					$tran = (array)$trans;

					$tran[0]->total_amount_not_yet_send_user = $total_not_yet_send;
				}
			}
			$sum_cod_not_yet_send_day = 0;
			$sum_cod_in_day = 0;
			$sum_of_day = 0;
			$sum_cod_not_yet_send_all = 0;
			$sum_cod_in_all = 0;
			$sum_of_all = 0;

			foreach ($transactionData->total_parent as $value_parent) {
				$sum_cod_not_yet_send_day += $value_parent->store_child->total_cod_not_yet_send_day;
			}
		}

		if (!empty($transactionData->status) && $transactionData->status == 200) {
			$config['total_rows'] = $transactionData->total_result;
			$this->data['transactionData'] = $transactionData->data;
			$this->data['total_parent'] = $transactionData->total_parent;
			$this->data['sum_cod_not_yet_send_day'] = $sum_cod_not_yet_send_day;
		} else {
			$this->data['transactionData'] = array();
			$this->data['groupRoles'] = array();
		}
		//get store

		$storeData = $this->userInfo['stores'];
		if (!empty($storeData)) {
			$this->data['storeData'] = $storeData;
		} else {
			$this->data['storeData'] = array();
		}
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		$this->data['fdate'] = $fdate;
		$this->data['tdate'] = $tdate;
		$this->pagination->initialize($config);
		$this->data['result_count'] = $config['total_rows'];
		$this->data['template'] = 'page/transaction/list_return.php';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;
	}



}


<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class SmsMegadoc extends MY_Controller
{
	public function __construct()
	{

		parent::__construct();
		// $this->api = new Api();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url', 'file'));
		$this->load->helper('lead_helper');
		$this->load->helper('download_helper');
		$this->load->model("time_model");
		$this->load->library('pagination');
		$this->config->load('config');

		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
		if (!$this->is_superadmin) {
			$paramController = $this->uri->segment(1);
			$param = strtolower($paramController);
			if (!in_array($param, $this->paramMenus)) {
				$this->session->set_flashdata('error', $this->lang->line('not_have_permission') . ' ' . $paramController . '!');
				redirect(base_url('app'));
				return;
			}
		}


	}

	/**
	 * Danh sách tin nhắn SMS hợp đồng điện tử
	 */
	public function index()
	{
		$this->data["pageName"] = "Danh sách tin nhắn SMS Megadoc";
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : '';
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : '';
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : '';
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : '';
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : '';
		$customer_phone = !empty($_GET['customer_phone']) ? $_GET['customer_phone'] : '';
		$type_sms = !empty($_GET['type_sms']) ? $_GET['type_sms'] : '';
		$type_document = !empty($_GET['type_document']) ? $_GET['type_document'] : '';
		$status_sms = !empty($_GET['status_sms']) ? $_GET['status_sms'] : '';
		$store = !empty($_GET['store']) ? $_GET['store'] : '';
		if (!empty($fdate) && !empty($tdate)) {
			if (strtotime($fdate) > strtotime($tdate)) {
				$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
				redirect(base_url('SmsMegadoc'));
			}
			if (empty($_GET['fdate']) || empty($_GET['tdate'])) {
				$this->session->set_flashdata('error', $this->lang->line('Please_select_input_date'));
				redirect(base_url('transaction'));
			}
		}
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 15;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$config['base_url'] = base_url('SmsMegadoc') . '?fdate=' . $fdate . '&tdate=' . $tdate . '&code_contract_disbursement=' . $code_contract_disbursement . '&code_contract=' . $code_contract. '&customer_name=' . $customer_name . '&customer_phone=' . $customer_phone . '&store=' . $store . '&type_sms=' . $type_sms . '&type_document=' . $type_document . '&status_sms=' . $status_sms;
		$data_send = array(
			'per_page' => $config['per_page'],
			'uriSegment' => $config['uri_segment'],
			'fdate' => $fdate,
			'tdate' => $tdate,
		);
		if (!empty($code_contract_disbursement)) {
			$data_send['code_contract_disbursement'] = $code_contract_disbursement;
		}
		if (!empty($code_contract)) {
			$data_send['code_contract'] = $code_contract;
		}
		if (!empty($customer_name)) {
			$data_send['customer_name'] = $customer_name;
		}
		if (!empty($customer_phone)) {
			$data_send['customer_phone'] = $customer_phone;
		}
		if (!empty($type_sms)) {
			$data_send['type_sms'] = $type_sms;
		}
		if (!empty($type_document)) {
			$data_send['type_document'] = $type_document;
		}
		if (!empty($status_sms)) {
			$data_send['status_sms'] = $status_sms;
		}
		if (!empty($store)) {
			$data_send['store'] = $store;
		}
		$sms_megadoc_data = $this->api->apiPost($this->userInfo['token'], 'SmsMegadoc/get_all_sms', $data_send);
		if (!empty($sms_megadoc_data->status) && $sms_megadoc_data->status == 200) {
			$this->data['sms_megadoc'] = $sms_megadoc_data->data;
			$config['total_rows'] = $sms_megadoc_data->total;
		} else {
			$this->data['sms_megadoc'] = array();
		}
		//lấy id_store của user theo session hiện tại
		$arr_store = [];
		foreach ($this->userInfo['stores'] as $st) {
			$arr_store += [$st->store_id => $st->store_name];
		}
		$store_megadoc = $this->api->apiPost($this->userInfo['token'], 'Contract/get_store_megadoc',[]);
		if (!empty($store_megadoc->status) && $store_megadoc->status == 200) {
			$this->data['store_megadoc'] = $store_megadoc->data;
		} else {
			$this->data['store_megadoc'] = array();
		}
		$this->data['stores'] = $arr_store;
		$this->pagination->initialize($config);
		$this->data['result_count'] = $config['total_rows'];
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/sms_megadoc/list_sms_megadoc';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;
	}
}

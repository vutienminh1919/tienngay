<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

class Customer_manager extends MY_Controller
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

		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";


	}

	public function index_customer_manager()
	{
		$countFileReturn = $this->api->apiPost($this->userInfo['token'], "customer_manager/get_count_all");

		$count = (int)$countFileReturn->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('customer_manager/index_customer_manager');
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;

		$data["per_page"] = $config['per_page'];
		$data["uriSegment"] = $config['uri_segment'];


		$result = $this->api->apiPost($this->user['token'], "Customer_manager/get_all", $data);

		if (!empty($result->status) && $result->status == 200) {
			$this->data['result'] = $result->data;

		} else {
			$this->data['result'] = array();
		}


		$this->data['template'] = 'page/customer_manager/list_customer.php';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function search()
	{

		$data = [];

		$customer_code = !empty($_GET['customer_code']) ? $_GET['customer_code'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$customer_identify = !empty($_GET['customer_identify']) ? $_GET['customer_identify'] : "";

		if (!empty($customer_code)) {
			$data['customer_code'] = $customer_code;
		}
		if (!empty($customer_name)) {
			$data['customer_name'] = $customer_name;
		}
		if (!empty($customer_identify)) {
			$data['customer_identify'] = $customer_identify;
		}

		$countFileReturn = $this->api->apiPost($this->userInfo['token'], "customer_manager/get_count_all", $data);

		$count = (int)$countFileReturn->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('customer_manager/index_customer_manager');
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;

		$data["per_page"] = $config['per_page'];
		$data["uriSegment"] = $config['uri_segment'];


		$result = $this->api->apiPost($this->user['token'], "Customer_manager/get_all", $data);

		if (!empty($result->status) && $result->status == 200) {
			$this->data['result'] = $result->data;

		} else {
			$this->data['result'] = array();
		}


		$this->data['template'] = 'page/customer_manager/list_customer.php';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);


	}

	private function pushJson($code, $data)
	{
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}

	public function detail()
	{

		$data = $this->input->get();
		$data['id'] = $this->security->xss_clean($data['id']);

		$data['customer_code'] = $this->security->xss_clean($data['customer_code']);
		$data['customer_identify_name'] = $this->security->xss_clean($data['customer_identify_name']);

		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));

		if (!empty($contract->status) && $contract->status == 200) {
			$this->data['contract'] = $contract->data;
			$this->data['customer_code'] = $data['customer_code'];
			$this->data['customer_identify_name'] = $data['customer_identify_name'];

		} else {
			$this->data['contract'] = array();
		}


		$this->data['template'] = 'page/customer_manager/customer_manager.php';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function detail_edit()
	{

		$data = $this->input->get();
		$data['id'] = $this->security->xss_clean($data['id']);

		$data['customer_code'] = $this->security->xss_clean($data['customer_code']);
		$data['customer_identify_name'] = $this->security->xss_clean($data['customer_identify_name']);

		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));

		if (!empty($contract->status) && $contract->status == 200) {
			$this->data['contract'] = $contract->data;
			$this->data['customer_code'] = $data['customer_code'];
			$this->data['customer_identify_name'] = $data['customer_identify_name'];

		} else {
			$this->data['contract'] = array();
		}


		$this->data['template'] = 'page/customer_manager/edit_customer_manager.php';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function detail_tthd()
	{

		$data = $this->input->get();
		$data['id'] = $this->security->xss_clean($data['id']);

		$data['customer_code'] = $this->security->xss_clean($data['customer_code']);
		$data['customer_identify_name'] = $this->security->xss_clean($data['customer_identify_name']);

		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));

		if (!empty($contract->status) && $contract->status == 200) {
			$this->data['contract'] = $contract->data;
			$this->data['customer_code'] = $data['customer_code'];
			$this->data['customer_identify_name'] = $data['customer_identify_name'];

		} else {
			$this->data['contract'] = array();
		}


		$dataPost = array(
			"phone" => $contract->data->customer_infor->customer_phone_number,
			"customer_identify" => $contract->data->customer_infor->customer_identify,
			"customer_identify_old" => $contract->data->customer_infor->customer_identify_old,
			"phone_number_relative_1" => $contract->data->relative_infor->phone_number_relative_1,
			"phone_number_relative_2" => $contract->data->relative_infor->phone_number_relative_2
		);
		$contract_involve = $this->api->apiPost($this->userInfo['token'], "contract/get_contract_check_involve", $dataPost);
		if (!empty($contract_involve->status) && $contract_involve->status == 200) {
			$this->data['contract_involve_phone'] = $contract_involve->data_phone;
			$this->data['contract_involve_identify'] = $contract_involve->data_identify;

			$arr_bh = [];
			$arr_check_hd = [];
			if (!empty($contract_involve->data_phone)) {
				foreach ($contract_involve->data_phone as $value) {
					if (!in_array($value->code_contract, $arr_check_hd)) {
						array_push($arr_check_hd, $value->code_contract);
						array_push($arr_bh, $value);
					}
				}
			}
			if (!empty($contract_involve->data_identify)) {
				foreach ($contract_involve->data_identify as $value) {
					if (!in_array($value->code_contract, $arr_check_hd)) {
						array_push($arr_check_hd, $value->code_contract);
						array_push($arr_bh, $value);
					}
				}

			}

			foreach ($arr_bh as $item){
				$check_tnds = ["phone" => $item->customer_infor->customer_phone_number ];
				$bh_mic_tnds = $this->api->apiPost($this->userInfo['token'], "customer_manager/get_mic_tnds", $check_tnds);
				$contract_tnds = $this->api->apiPost($this->userInfo['token'], "customer_manager/get_contract_tnds", $check_tnds);
				$vbi_sxh = $this->api->apiPost($this->userInfo['token'], "customer_manager/get_vbi_sxh", $check_tnds);
				$vbi_tnds = $this->api->apiPost($this->userInfo['token'], "customer_manager/get_vbi_tnds", $check_tnds);
				$vbi_utv = $this->api->apiPost($this->userInfo['token'], "customer_manager/get_vbi_utv", $check_tnds);


				if (!empty($bh_mic_tnds) && $bh_mic_tnds->status == 200){
					$this->data['arr_mic_tnds'] = $bh_mic_tnds->data;
				} else {
					$this->data['arr_mic_tnds'] = [];
				}
				if (!empty($contract_tnds) && $contract_tnds->status == 200){
					$this->data['contract_tnds'] = $contract_tnds->data;
				} else {
					$this->data['contract_tnds'] = [];
				}
				if (!empty($vbi_sxh) && $vbi_sxh->status == 200){
					$this->data['vbi_sxh'] = $vbi_sxh->data;
				} else {
					$this->data['vbi_sxh'] = [];
				}
				if (!empty($vbi_tnds) && $vbi_tnds->status == 200){
					$this->data['vbi_tnds'] = $vbi_tnds->data;
				} else {
					$this->data['vbi_tnds'] = [];
				}
				if (!empty($vbi_utv) && $vbi_utv->status == 200){
					$this->data['vbi_utv'] = $vbi_utv->data;
				} else {
					$this->data['vbi_utv'] = [];
				}

			}


			$this->data['contract_involve_identify_old'] = $contract_involve->data_identify_old;
			$this->data['contract_involve_relative_1'] = $contract_involve->data_identify_relative_1;
			$this->data['contract_involve_relative_2'] = $contract_involve->data_identify_relative_2;
		} else {
			$this->data['contract_involve'] = array();
		}


		$data_ttdv = [
			"phone" => $contract->data->customer_infor->customer_phone_number
		];
		$transaction = $this->api->apiPost($this->userInfo['token'], "customer_manager/get_transaction", $data_ttdv);
		if (!empty($transaction->status) && $transaction->status == 200) {
			$arr_order = [];
			foreach ($transaction->data as $item) {
				$check_order = [
					"transaction_code" => $item->code
				];
				$order = $this->api->apiPost($this->userInfo['token'], "customer_manager/get_order", $check_order);
				if (!empty($order->status) && $order->status == 200) {
					foreach ($order->data as $order1) {
						array_push($arr_order, $order1);
					}
				}

			}
		}
		$this->data['arr_order'] = $arr_order;

		$this->data['template'] = 'page/customer_manager/customer_manager_tthd.php';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public
	function update()
	{

		$data = $this->input->post();
		$data['customer_code'] = $this->security->xss_clean($data['customer_code']);
		$data['img_id_front'] = $this->security->xss_clean($data['img_id_front']);
		$data['img_id_back'] = $this->security->xss_clean($data['img_id_back']);


		$sendApi = array(
			"customer_code" => $data['customer_code'],
			"img_id_front" => $data['img_id_front'],
			"img_id_back" => $data['img_id_back'],
			"created_by" => $this->userInfo

		);


		$return = $this->api->apiPost($this->userInfo['token'], "customer_manager/process_update", $sendApi);


		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		} else {

			$msg = !empty($return->data->message) ? $return->data->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));

		}

	}

	public
	function detail_giaytotuythan()
	{
		$data = [];
		$data = $this->input->get();
		$data['id'] = $this->security->xss_clean($data['id']);

		$data['customer_code'] = $this->security->xss_clean($data['customer_code']);
		$data['customer_identify_name'] = $this->security->xss_clean($data['customer_identify_name']);

		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));

		if (!empty($contract->status) && $contract->status == 200) {
			$this->data['contract'] = $contract->data;
			$this->data['customer_code'] = $data['customer_code'];
			$this->data['customer_identify_name'] = $data['customer_identify_name'];

		} else {
			$this->data['contract'] = array();
		}


		$img_new = $this->api->apiPost($this->userInfo['token'], "customer_manager/log_get_one", $data);

		if (!empty($img_new->status) && $img_new->status == 200) {
			$this->data['image'] = $img_new->data;

		} else {
			$this->data['image'] = array();
		}


		$this->data['template'] = 'page/customer_manager/giaytotuythan.php';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

}


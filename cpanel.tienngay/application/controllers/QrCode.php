<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class QrCode extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url', 'file'));
		$this->load->model("main_property_model");
		$this->load->model('config_gic_model');
		$this->load->model("time_model");
		$this->load->library('pagination');
		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
	}

	public function sim()
	{
		$stores = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active");
		$store = $this->api->apiPost($this->userInfo['token'], "mic_tnds/get_store_by_user");
		if (!empty($store->status) && $store->status == 200) {
			$this->data['stores'] = $store->data;
		} else {
			$this->data['stores'] = $stores->data;
		}
		$storeDataCentral = $this->api->apiPost($this->userInfo['token'], "Store/getAllStoreCentral", array());
		if (!empty($storeDataCentral->status) && $storeDataCentral->status == 200) {
			$this->data['storeDataCentral'] = $storeDataCentral->data;
		} else {
			$this->data['storeDataCentral'] = array();
		}
		$this->data['pageName'] = 'Tạo Qr chuyển khoản bán Sim';
		$this->data['template'] = 'page/qr/sim';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function gen_qr_code()
	{
		$amount = !empty($_POST['amount']) ? trim(str_replace([',', '.'], '', $_POST['amount'])) : 0;
		$store = $_POST['store'] ?? '';
		$type_transaction = $_POST['type_transaction'] ?? '';
		if (!$amount) {
			return $this->pushJson('200', json_encode(array("status" => "401", "msg" => 'Số tiền đang trống')));
		}

		if (!$store) {
			return $this->pushJson('200', json_encode(array("status" => "401", "msg" => 'PGD không để trống')));
		}

		$description = $type_transaction . ' - ' . $store;
		$url = 'https://img.vietqr.io/image/';
		$bank_code = 'TCB';
		$account = '19134928058023';
		$account_name = 'CTY CP CONG NGHE TAI CHINH VIET';
		$link = $url . $bank_code . "-" . $account . '-' . 'compact2.jpg'
			. '?amount=' . $amount
			. '&accountName=' . $account_name
			. '&addInfo=' . $description;
		return $this->pushJson('200', json_encode(array("status" => "200", "msg" => 'success', 'data' => $link)));

	}

	private function pushJson($code, $data)
	{
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}
}

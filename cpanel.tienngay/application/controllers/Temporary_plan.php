<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// include APPPATH.'/libraries/Api.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
class Temporary_plan extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->api = new Api();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model("time_model");
		$this->load->library('pagination');
		$this->load->helper('lead_helper');
		$this->config->load('config');
		$this->spreadsheet = new Spreadsheet();
		$this->sheet = $this->spreadsheet->getActiveSheet();
		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
		if (!$this->userInfo) {
			$this->session->set_flashdata('error', $this->lang->line('You_do_not_have_permission_access_this_item'));
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

	public function list()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$full_name = !empty($_GET['full_name']) ? $_GET['full_name'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "import_payment";
		$this->data["pageName"] = 'Quản lý lãi phí';
		$data = array();
		if (!empty($fdate) && !empty($tdate)) {
			if (strtotime($fdate) > strtotime($tdate)) {
				$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
				redirect(base_url('temporary_plan/list'));
			}
			if (empty($_GET['fdate']) || empty($_GET['tdate'])) {
				$this->session->set_flashdata('error', $this->lang->line('Please_select_input_date'));
				redirect(base_url('temporary_plan/list'));
			}
			$data = array(
				"fdate" => $fdate,
				"tdate" => $tdate,
			);
		}
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');

		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 300;
		$config['page_query_string'] = true;

		$config['base_url'] = base_url('temporary_plan/list') . '?fdate=' . $fdate . '&tdate=' . $tdate . '&full_name=' . $full_name . '&code_contract_disbursement=' . $code_contract_disbursement . '&store=' . $store . '&tab=' . $tab . '&code_contract=' . $code_contract;
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
		if (!empty($store)) {
			$data['store'] = $store;
		}
		if (!empty($full_name)) {
			$data['full_name'] = $full_name;
		}
		if (!empty($code_contract_disbursement)) {
			$data['code_contract_disbursement'] = $code_contract_disbursement;
		}
		if (!empty($code_contract)) {
			$data['code_contract'] = $code_contract;
		}
		$temporary_planData = $this->api->apiPost($this->userInfo['token'], "temporary_plan_contract/get_all", $data);
		if (!empty($temporary_planData->status) && $temporary_planData->status == 200) {
			$this->data['temporary_planData'] = $temporary_planData->data;
			$config['total_rows'] = $temporary_planData->total;
		} else {
			$this->data['temporary_planData'] = array();
			$config['total_rows'] = 0;

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

		$this->pagination->initialize($config);
		$this->data['result_count'] = "Hiển thị " . $config['total_rows'] . " Kết quả";
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/temporary_plan/list';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;
	}

	public function list_cc_gh()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$full_name = !empty($_GET['full_name']) ? $_GET['full_name'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "all";
		$this->data["pageName"] = 'Danh sách hợp đồng cơ cấu gia hạn';
		$data = array();
		if (!empty($fdate) && !empty($tdate)) {
			if (strtotime($fdate) > strtotime($tdate)) {
				$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
				redirect(base_url('temporary_plan/list_cc_gh'));
			}
			if (empty($_GET['fdate']) || empty($_GET['tdate'])) {
				$this->session->set_flashdata('error', $this->lang->line('Please_select_input_date'));
				redirect(base_url('temporary_plan/list_cc_gh'));
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

		$config['base_url'] = base_url('temporary_plan/list_cc_gh') . '?fdate=' . $fdate . '&tdate=' . $tdate . '&full_name=' . $full_name . '&code_contract_disbursement=' . $code_contract_disbursement . '&store=' . $store . '&tab=' . $tab . '&code_contract=' . $code_contract;
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
		if (!empty($store)) {
			$data['store'] = $store;
		}
		if (!empty($full_name)) {
			$data['full_name'] = $full_name;
		}
		if (!empty($code_contract_disbursement)) {
			$data['code_contract_disbursement'] = $code_contract_disbursement;
		}
		if (!empty($code_contract)) {
			$data['code_contract'] = $code_contract;
		}
		$temporary_planData = $this->api->apiPost($this->userInfo['token'], "temporary_plan_contract/get_all_cc_gh", $data);
		if (!empty($temporary_planData->status) && $temporary_planData->status == 200) {
			$this->data['temporary_planData'] = $temporary_planData->data;
			$config['total_rows'] = $temporary_planData->total;
		} else {
			$this->data['temporary_planData'] = array();
			$config['total_rows'] = 0;

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

		$this->pagination->initialize($config);
		$this->data['result_count'] = "Hiển thị " . $config['total_rows'] . " Kết quả";
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/temporary_plan/list_gh_cc';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;
	}

	public function list_thn()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$full_name = !empty($_GET['full_name']) ? $_GET['full_name'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "all";
		$this->data["pageName"] = $this->lang->line('Managing_receipts');
		$data = array();
		if (!empty($fdate) && !empty($tdate)) {
			if (strtotime($fdate) > strtotime($tdate)) {
				$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
				redirect(base_url('temporary_plan/list_thn'));
			}
			if (empty($_GET['fdate']) || empty($_GET['tdate'])) {
				$this->session->set_flashdata('error', $this->lang->line('Please_select_input_date'));
				redirect(base_url('temporary_plan/list_thn'));
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

		$config['base_url'] = base_url('temporary_plan/list_thn') . '?fdate=' . $fdate . '&tdate=' . $tdate . '&full_name=' . $full_name . '&code_contract_disbursement=' . $code_contract_disbursement . '&store=' . $store . '&tab=' . $tab . '&code_contract=' . $code_contract;
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
		if (!empty($store)) {
			$data['store'] = $store;
		}
		if (!empty($full_name)) {
			$data['full_name'] = $full_name;
		}
		if (!empty($code_contract_disbursement)) {
			$data['code_contract_disbursement'] = $code_contract_disbursement;
		}
		if (!empty($code_contract)) {
			$data['code_contract'] = $code_contract;
		}
		$temporary_planData = $this->api->apiPost($this->userInfo['token'], "temporary_plan_contract/get_all", $data);
		if (!empty($temporary_planData->status) && $temporary_planData->status == 200) {
			$this->data['temporary_planData'] = $temporary_planData->data;
			$config['total_rows'] = $temporary_planData->total;
		} else {
			$this->data['temporary_planData'] = array();
			$config['total_rows'] = 0;

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

		$this->pagination->initialize($config);
		$this->data['result_count'] = "Hiển thị " . $config['total_rows'] . " Kết quả";
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/temporary_plan/list_thn';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;
	}

	public function update()
	{
		$data = $this->input->post();
		$data['field'] = $this->security->xss_clean($data['field']);
		$data['value'] = $this->security->xss_clean($data['value']);
		$data['id'] = $this->security->xss_clean($data['id']);

		$condition = array(
			'id' => $data['id'],
			$data['field'] => $data['value'],
			"updated_by" => $this->user['email'],
			"updated_at" => $this->time_model->convertDatetimeToTimestamp(new DateTime())

		);
		// var_dump($condition); die;
		$return = $this->api->apiPost($this->user['token'], "temporary_plan_contract/update_contract", $condition);
		$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
	}

	public function view()
	{
		$id = $this->uri->segment(3);
		if (empty($id)) {
			$this->session->set_flashdata('error', $this->lang->line('Does_not_exist_order'));
			redirect(base_url('temporary_plan'));
			return;
		}
		$id = $this->security->xss_clean($id);
		//Get information
		$orders = $this->api->apiPost($this->userInfo['token'], "temporary_plan/get_order", array("id" => $id));
		if (!empty($orders->status) && $orders->status == 200) {
			$this->data['orderData'] = $orders->orderData;
			$this->data['temporary_plan'] = $orders->temporary_plan;
		} else {
			$this->data['orderData'] = array();
			$this->data['temporary_plan'] = array();
		}
		$this->data['template'] = 'page/temporary_plan/order_list';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function viewContract()
	{
		$id = $this->uri->segment(3);
		if (empty($id)) {
			$this->session->set_flashdata('error', $this->lang->line('Does_not_exist_order'));
			redirect(base_url('temporary_plan'));
			return;
		}
		$id = $this->security->xss_clean($id);
		//Get information
		$orders = $this->api->apiPost($this->userInfo['token'], "temporary_plan/get_detail", array("id" => $id));
		if (!empty($orders->status) && $orders->status == 200) {
			$this->data['temporary_plan'] = $orders->temporary_plan;
		} else {
			$this->data['temporary_plan'] = array();
		}
		$this->data['template'] = 'page/temporary_plan/contract_list';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function detail()
	{
		$id = $this->uri->segment(3);
		if (empty($id)) {
			$this->session->set_flashdata('error', $this->lang->line('Does_not_exist_temporary_plan'));
			redirect(base_url('temporary_plan'));
			return;
		}
		$id = $this->security->xss_clean($id);
		//Get information
		$orders = $this->api->apiPost($this->userInfo['token'], "temporary_plan_contract/get_detail", array("id" => $id));
		if (!empty($orders->status) && $orders->status == 200) {
			$this->data['orderData'] = $orders->orderData;
			$this->data['temporary_plan'] = $orders->temporary_plan;
			$this->data['hotline'] = $orders->hotline;
		} else {
			$this->data['orderData'] = array();
			$this->data['temporary_plan'] = array();
			$this->data['hotline'] = '';
		}
		$this->load->view('billing_printed', isset($this->data) ? $this->data : NULL);
	}

	public function detail_contract()
	{
		$id = $this->uri->segment(3);
		if (empty($id)) {
			$this->session->set_flashdata('error', $this->lang->line('Does_not_exist_temporary_plan'));
			redirect(base_url('temporary_plan'));
			return;
		}
		$id = $this->security->xss_clean($id);
		//Get information
		$orders = $this->api->apiPost($this->userInfo['token'], "temporary_plan/get_detail", array("id" => $id));
		if (!empty($orders->status) && $orders->status == 200) {
			$this->data['temporary_plan'] = $orders->temporary_plan;
			$this->data['hotline'] = $orders->hotline;
		} else {
			$this->data['temporary_plan'] = array();
			$this->data['hotline'] = '';
		}
		$this->load->view('billing_printed_contract', isset($this->data) ? $this->data : NULL);
	}


	public function run_fee()
	{
		$data = $this->input->post();
		$data['contract_id'] = $this->security->xss_clean($data['contract_id']);
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['contract_id']));
		if ($contract->status == 200) {
			if ((isset($contract->data->investor_id) || isset($contract->data->investor_code) && isset($contract->data->disbursement_date))) {
				if (isset($contract->data->investor_id)) {
					$data_in = array("id" => $contract->data->investor_id);
					$investors = $this->api->apiPost($this->userInfo['token'], "investor/get_one", $data_in);
					if ($investors->status == 200) {
						$investor_code = $investors->data->code;
					} else {
						$response = [
							'res' => false,
							'status' => "400",
							'msg' => 'Không tìm thấy nhà đầu tư' . ' : mã phiếu ghi:' . $contract->data->code_contract,
							'data' => $result
						];
						$this->pushJson('200', json_encode($response));
						return;
					}
				} else {
					$investor_code = $contract->data->investor_code;
				}
				$dataPost = array(
					"code_contract" => $contract->data->code_contract,
					"investor_code" => $investor_code,
					"disbursement_date" => $contract->data->disbursement_date
				);
				$result = $this->api->apiPost($this->userInfo['token'], "generateContract/processContract", $dataPost);
				if (!empty($result->status) && $result->status == 200) {
					$response = [
						'res' => true,
						'status' => "200",
						'msg' => 'Chạy phí thành công mã phiếu ghi : ' . $contract->data->code_contract,
						'url' => $result->url
					];
					//echo json_encode($response);
					$this->pushJson('200', json_encode($response));
					return;
				} else {
					$response = [
						'res' => false,
						'status' => "400",
						'msg' => $result->message . ' : mã phiếu ghi:' . $contract->data->code_contract,
						'data' => $result
					];
					$this->pushJson('200', json_encode($response));
					return;
				}

			} else {
				$response = [
					'res' => false,
					'status' => "400",
					'msg' => 'Hợp đồng không có mã nhà đầu tư và ngày giải ngân.' . ' : mã phiếu ghi:' . $contract->data->code_contract,
					'data' => $result
				];
				$this->pushJson('200', json_encode($response));
				return;
			}
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => 'Không tìm thấy hợp đồng',
				'data' => $result
			];
			$this->pushJson('200', json_encode($response));
			return;
		}

	}

	public function run_fee_again()
	{
		$data = $this->input->post();
		$data['contract_id'] = $this->security->xss_clean($data['contract_id']);
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['contract_id']));
		if ($contract->status == 200) {
			if ((isset($contract->data->investor_id) || isset($contract->data->investor_code) && isset($contract->data->disbursement_date))) {
				if (isset($contract->data->investor_id)) {
					$data_in = array("id" => $contract->data->investor_id);
					$investors = $this->api->apiPost($this->userInfo['token'], "investor/get_one", $data_in);
					if ($investors->status == 200) {
						$investor_code = $investors->data->code;
					} else {
						$response = [
							'res' => false,
							'status' => "400",
							'msg' => 'Không tìm thấy nhà đầu tư' . ' : mã phiếu ghi:' . $contract->data->code_contract,
							'data' => $result
						];
						$this->pushJson('200', json_encode($response));
						return;
					}
				} else {
					$investor_code = $contract->data->investor_code;
				}
				$data_delete = array(
					"code_contract" => $contract->data->code_contract,
				);
				$result_delete_and_update = $this->api->apiPost($this->userInfo['token'], "contract/delete_lai_ky_lai_thang", $data_delete);
				if (!empty($result_delete_and_update->status) && $result_delete_and_update->status == 200) {


					$dataPost = array(
						"code_contract" => $contract->data->code_contract,
						"investor_code" => $investor_code,
						"disbursement_date" => $contract->data->disbursement_date
					);
					$result = $this->api->apiPost($this->userInfo['token'], "generateContract/processContract", $dataPost);
					if (!empty($result->status) && $result->status == 200) {
						$response = [
							'res' => true,
							'status' => "200",
							'msg' => 'Chạy phí thành công mã phiếu ghi : ' . $contract->data->code_contract,
							'url' => $result->url
						];
						//echo json_encode($response);
						$this->pushJson('200', json_encode($response));
						return;
					} else {
						$response = [
							'res' => false,
							'status' => "400",
							'msg' => $result->message . ' : mã phiếu ghi:' . $contract->data->code_contract,
							'data' => $result
						];
						$this->pushJson('200', json_encode($response));
						return;
					}
				}

			} else {
				$response = [
					'res' => false,
					'status' => "400",
					'msg' => 'Hợp đồng không có mã nhà đầu tư và ngày giải ngân.' . ' : mã phiếu ghi:' . $contract->data->code_contract,
					'data' => $result
				];
				$this->pushJson('200', json_encode($response));
				return;
			}
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => 'Không tìm thấy hợp đồng',
				'data' => $result
			];
			$this->pushJson('200', json_encode($response));
			return;
		}

	}

	public function payment_all()
	{
		$data = $this->input->post();
		$data['contract_id'] = $this->security->xss_clean($data['contract_id']);
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['contract_id']));
		if ($contract->status == 200) {
			if ((isset($contract->data->investor_id) || isset($contract->data->investor_code) && isset($contract->data->disbursement_date))) {
				if (isset($contract->data->investor_id)) {
					$data_in = array("id" => $contract->data->investor_id);
					$investors = $this->api->apiPost($this->userInfo['token'], "investor/get_one", $data_in);
					if ($investors->status == 200) {
						$investor_code = $investors->data->code;
					} else {
						$response = [
							'res' => false,
							'status' => "400",
							'msg' => 'Không tìm thấy nhà đầu tư' . ' : mã phiếu ghi:' . $contract->data->code_contract,
							'data' => $result
						];
						$this->pushJson('200', json_encode($response));
						return;
					}
				} else {
					$investor_code = $contract->data->investor_code;
				}
				$data_delete = array(
					"code_contract" => $contract->data->code_contract,
				);
				$transaction_wait = $this->api->apiPost($this->userInfo['token'],'transaction/get_one_wait', $data_delete);
				if (!empty($transaction_wait->status) && $transaction_wait->status == 200) {
					if (!empty($transaction_wait)) {
						$data_delete['date_pay'] = $transaction_wait->date_pay;
					}
				}
				// Update thông tin chậm trả khi HĐ phát sinh ngày chậm trả
				$this->api->apiPost($this->userInfo['token'], 'transaction/update_date_late_into_contract', $data_delete);
				//xóa gen lãi kỳ và reset lại transaction =0 
				$result_delete_and_update = $this->api->apiPost($this->userInfo['token'], "contract/delete_lai_ky_lai_thang", $data_delete);
				if (!empty($result_delete_and_update->status) && $result_delete_and_update->status == 200) {


					$dataPost_dele = array(
						"code_contract" => $contract->data->code_contract,
						"investor_code" => $investor_code,
						"disbursement_date" => $contract->data->disbursement_date,
						"date_pay" => $transaction_wait->date_pay

					);
					//gen bảng lãi kỳ
					$result = $this->api->apiPost($this->userInfo['token'], "generateContract/processContract", $dataPost_dele);
					if (!empty($result->status) && $result->status == 200) {
						$dataPost = array(
							"code_contract" => $contract->data->code_contract,
							"investor_code" => $investor_code,
							"disbursement_date" => $contract->data->disbursement_date
						);
						// chia thanh toán tất toán
						$result = $this->api->apiPost($this->userInfo['token'], "transaction/payment_all_contract", $dataPost);
						if (!empty($result->status) && $result->status == 200) {

							$response = [
								'res' => true,
								'status' => "200",
								'msg' => 'Chạy phí thành công mã phiếu ghi : ' . $contract->data->code_contract,
								'url' => $result->url
							];
							//echo json_encode($response);
							$this->pushJson('200', json_encode($response));
							return;
						} else {
							$response = [
								'res' => false,
								'status' => "400",
								'msg' => $result->message . ' : mã phiếu ghi:' . $contract->data->code_contract,
								'data' => $result
							];
							$this->pushJson('200', json_encode($response));
							return;
						}
					}
				}

			} else {
				$response = [
					'res' => false,
					'status' => "400",
					'msg' => 'Hợp đồng không có mã nhà đầu tư và ngày giải ngân.' . ' : mã phiếu ghi:' . $contract->data->code_contract,
					'data' => $result
				];
				$this->pushJson('200', json_encode($response));
				return;
			}
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => 'Không tìm thấy hợp đồng',
				'data' => $result
			];
			$this->pushJson('200', json_encode($response));
			return;
		}

	}
	public function khoa_hop_dong()
	{
		$data = $this->input->post();
		$data['contract_id'] = $this->security->xss_clean($data['contract_id']);
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['contract_id']));
		if ($contract->status == 200) {
		    $result_up =$this->api->apiPost($this->userInfo['token'], "contract/update", array("id" => $data['contract_id'],"contract_lock" => 'lock'));
		    if (!empty($result_up->status) && $result_up->status == 200) {

							$response = [
								'res' => true,
								'status' => "200",
								'msg' => 'Khóa hợp đồng thành công',
								
							];
							
							$this->pushJson('200', json_encode($response));
							return;
						} else {
							$response = [
								'res' => false,
								'status' => "400",
								'msg' =>'Khóa hợp đồng không thành công',
							
							];
							$this->pushJson('200', json_encode($response));
							return;
						}
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => 'Không tìm thấy hợp đồng',
				'data' => $result
			];
			$this->pushJson('200', json_encode($response));
			return;
		}

	}
	public function mo_khoa_hop_dong()
	{
		$data = $this->input->post();
		$data['contract_id'] = $this->security->xss_clean($data['contract_id']);
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['contract_id']));
		if ($contract->status == 200) {
		    $result_up =$this->api->apiPost($this->userInfo['token'], "contract/update", array("id" => $data['contract_id'],"contract_lock" => 'unlock'));
		    if (!empty($result_up->status) && $result_up->status == 200) {

							$response = [
								'res' => true,
								'status' => "200",
								'msg' => 'Mở Khóa hợp đồng thành công',
								
							];
							
							$this->pushJson('200', json_encode($response));
							return;
						} else {
							$response = [
								'res' => false,
								'status' => "400",
								'msg' =>'Mở Khóa hợp đồng không thành công',
							
							];
							$this->pushJson('200', json_encode($response));
							return;
						}
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => 'Không tìm thấy hợp đồng',
				'data' => $result
			];
			$this->pushJson('200', json_encode($response));
			return;
		}

	}
	public function arrSortObjsByKey($key, $order = 'DESC')
	{
		return function ($a, $b) use ($key, $order) {

			// Swap order if necessary
			if ($order == 'DESC') {
				list($a, $b) = array($b, $a);
			}

			// Check data type
			if (is_numeric($a->$key)) {
				return $a->$key - $b->$key; // compare numeric
			} else {
				return strnatcasecmp($a->$key, $b->$key); // compare string
			}
		};
	}

	public function re_run_giahan()
	{
		$data = $this->input->post();
		$data['contract_id'] = $this->security->xss_clean($data['contract_id']);
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['contract_id']));

		if( isset($contract->data->contract_lock) && $contract->data->contract_lock=='lock') {
			$response = array(
				'res' => false,
				'status' => "400",
				'msg' => 'Hợp đồng đã khóa'
			);
			$this->pushJson('200', json_encode($response));
			return;
		}
		if ($contract->status == 200) {
			if (!empty($contract->data->extend_all)) {
				$arrPost = array(
					"code_contract" => $contract->data->code_contract
				);

				$array_gh = json_decode(json_encode($contract->data->extend_all, true), true);

				$array_gh_sort = array_sort($array_gh, 'so_lan', SORT_ASC);

				foreach ($array_gh_sort as $key => $value) {

					$so_lan = $value['so_lan'];
					if ($so_lan == 1) {
						$this->re_payment($contract->data->code_contract, $contract->data->code_contract_disbursement, 0, "GH");
					}

					$arrPost["number_day_loan"] = $value['number_day_loan'];
					$arrPost["so_lan"] = $so_lan;
					$arrPost["extend_date"] = $value['extend_date'];

					$resultExtension = $this->api->apiPost($this->userInfo['token'], "contract_cc_gh/check_approve_gia_han", $arrPost);

					if ($resultExtension->status == 200) {
						$arrPost['code_contract'] = $resultExtension->data->code_contract;

						$dt_contract = $this->api->apiPost($this->user['token'], "caculator/get_one_contract_cc_gh", array('field' => 'code_contract', 'value' => $arrPost['code_contract']));

						$dataPost_dele = array(
							"code_contract" => $dt_contract->data->code_contract,
							"code_contract_origin" => $contract->data->code_contract,
							"code_contract_disbursement_origin" => $contract->data->code_contract_disbursement,
							"investor_code" => $dt_contract->data->investor_code,
							"disbursement_date" => $dt_contract->data->disbursement_date,
							"type_gh_cc" => 'GH'
						);

						$result_delete_and_update = $this->api->apiPost($this->userInfo['token'], "contract/delete_lai_ky_lai_thang", $dataPost_dele);

						if (!empty($result_delete_and_update->status) && $result_delete_and_update->status == 200) {


							$result_delete = $this->api->apiPost($this->userInfo['token'], "generateContract/processContract", $dataPost_dele);
							if (!empty($result_delete->status) && $result_delete->status == 200) {


								$update_stt = array('status' => 33);
								if ($so_lan == 1) {
									$update_stt['code_contract'] = $contract->data->code_contract;
									$this->api->apiPost($this->userInfo['token'], "contract/update_status", $update_stt);
								} else if ($so_lan != 1 && $so_lan < count($array_gh)) {
									$update_stt['code_contract'] = $arrPost['code_contract'];
									$this->api->apiPost($this->userInfo['token'], "contract/update_status", $update_stt);

								}

								if ($so_lan == count($array_gh)) {
									$dataPost_dele['last'] = 1;
								}
								$this->api->apiPost($this->userInfo['token'], "transaction/payment_tien_thua_gh_cc", $dataPost_dele);
								$this->api->apiPost($this->userInfo['token'], "transaction/payment_all_contract_gh_cc", $dataPost_dele);
								if ($dataPost_dele['last'] != 1) {
									$this->api->apiPost($this->userInfo['token'], "transaction/generate_money_gh", $dataPost_dele);
								}
								$this->api->apiPost($this->userInfo['token'], "transaction/generate_money_thieu_gh", $dataPost_dele);
							}

						}

					} else {
						
						$response = [
							'res' => false,
							'status' => "400",
							'msg' => 'Có lỗi xảy ra',
							'data' => $result
						];
						$this->pushJson('200', json_encode($response));
						return;
					}

				}
				$response = [
					'res' => true,
					'status' => "200",
					'msg' => 'Chạy gia hạn thành công mã phiếu ghi : ' . $contract->data->code_contract,
				];
				$this->pushJson('200', json_encode($response));
				return;
			} else {
				$response = [
					'res' => false,
					'status' => "400",
					'msg' => 'Hợp đồng chưa gia hạn',
					'data' => $result
				];
				$this->pushJson('200', json_encode($response));
				return;
			}
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => 'Không tìm thấy hợp đồng',
				'data' => $result
			];
			$this->pushJson('200', json_encode($response));
			return;
		}
	}

	private function re_payment($code_contract, $code_contract_origin, $last = 0, $type_gh_cc = "")
	{
		$dt_contract = $this->api->apiPost($this->user['token'], "caculator/get_one_contract_cc_gh", array('field' => 'code_contract', 'value' => $code_contract));
		$data_delete = array(
			"code_contract" => $code_contract,
			"code_contract_disbursement_origin" => $code_contract_origin,
			"type_gh" => "origin"
		);
		$result_delete_and_update = $this->api->apiPost($this->userInfo['token'], "contract/delete_lai_ky_lai_thang", $data_delete);
		if (!empty($result_delete_and_update->status) && $result_delete_and_update->status == 200) {
			$dataPost_dele = array(
				"code_contract" => $dt_contract->data->code_contract,
				"code_contract_origin" => $dt_contract->data->code_contract,
				"code_contract_disbursement_origin" => $code_contract_origin,
				"investor_code" => $dt_contract->data->investor_code,
				"disbursement_date" => $dt_contract->data->disbursement_date,
				"last" => $last,
				"type_gh_cc" => $type_gh_cc
			);

			$result_delete = $this->api->apiPost($this->userInfo['token'], "generateContract/processContract", $dataPost_dele);
			if (!empty($result_delete->status) && $result_delete->status == 200) {

				$result = $this->api->apiPost($this->userInfo['token'], "transaction/payment_all_contract_gh_cc", $dataPost_dele);
			}
			if($type_gh_cc=="GH") {
				$this->api->apiPost($this->userInfo['token'], "transaction/generate_money_gh", $dataPost_dele);
				$this->api->apiPost($this->userInfo['token'], "transaction/generate_money_thieu_gh", $dataPost_dele);
			}
		}
	}
    
	public function re_run_cocau()
	{
		$data = $this->input->post();
		$data['contract_id'] = $this->security->xss_clean($data['contract_id']);
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['contract_id']));
		if( isset($contract->data->contract_lock) && $contract->data->contract_lock=='lock') {
			$response = array(
				'res' => false,
				'status' => "400",
				'msg' => 'Hợp đồng đã khóa'
			);
			$this->pushJson('200', json_encode($response));
			return;
		}
		if ($contract->status == 200) {
			if (!empty($contract->data->structure_all)) {
				$arrPost = array(
					"code_contract" => $contract->data->code_contract
				);


				$array_cc = json_decode(json_encode($contract->data->structure_all, true), true);

				$array_cc_sort = array_sort($array_cc, 'so_lan', SORT_ASC);

				foreach ($array_cc_sort as $key => $value) {

					$so_lan = $value['so_lan'];
					if ($so_lan == 1) {
						$this->re_payment($contract->data->code_contract, $contract->data->code_contract_disbursement, 0, "CC");
					}

					$arrPost["number_day_loan"] = $value['number_day_loan'];
					$arrPost["so_lan"] = $so_lan;
					$arrPost["amount_money"] = $value['amount_money'];
					$arrPost["type_loan"] = $value['type_loan']['code'];
					$arrPost["type_interest"] = $value['type_interest'];
					$arrPost["structure_date"] = $value['structure_date'];
                    // var_dump($arrPost); die;
					$resultExtension = $this->api->apiPost($this->userInfo['token'], "contract_cc_gh/check_approve_co_cau", $arrPost);

					if ($resultExtension->status == 200) {
						$arrPost['code_contract'] = $resultExtension->data->code_contract;

						$dt_contract = $this->api->apiPost($this->user['token'], "caculator/get_one_contract_cc_gh", array('field' => 'code_contract', 'value' => $arrPost['code_contract']));

						$dataPost_dele = array(
							"code_contract" => $dt_contract->data->code_contract,
							"code_contract_origin" => $contract->data->code_contract,
							"code_contract_disbursement_origin" => $contract->data->code_contract_disbursement,
							"investor_code" => $dt_contract->data->investor_code,
							"disbursement_date" => $dt_contract->data->disbursement_date,
							"type_gh_cc" => 'CC'
						);

						$result_delete_and_update = $this->api->apiPost($this->userInfo['token'], "contract/delete_lai_ky_lai_thang", $dataPost_dele);

						if (!empty($result_delete_and_update->status) && $result_delete_and_update->status == 200) {


							$result_delete = $this->api->apiPost($this->userInfo['token'], "generateContract/processContract", $dataPost_dele);
							if (!empty($result_delete->status) && $result_delete->status == 200) {


								$update_stt = array('status' => 34);
								if ($so_lan == 1) {
									$update_stt['code_contract'] = $contract->data->code_contract;
									$this->api->apiPost($this->userInfo['token'], "contract/update_status", $update_stt);
								} else if ($so_lan != 1 && $so_lan < count($array_cc)) {
									$update_stt['code_contract'] = $arrPost['code_contract'];
									$this->api->apiPost($this->userInfo['token'], "contract/update_status", $update_stt);

								}

								if ($so_lan == count($array_cc)) {
									$dataPost_dele['last'] = 1;
								}

								$this->api->apiPost($this->userInfo['token'], "transaction/payment_all_contract_gh_cc", $dataPost_dele);

							}

						}

					} else {

						$response = [
							'res' => false,
							'status' => "400",
							'msg' => 'Có lỗi xảy ra',
							'data' => $result
						];
						$this->pushJson('200', json_encode($response));
						return;
					}

				}
				$response = [
					'res' => true,
					'status' => "200",
					'msg' => 'Chạy gia hạn thành công mã phiếu ghi : ' . $contract->data->code_contract,
				];
				$this->pushJson('200', json_encode($response));
				return;
			} else {
				$response = [
					'res' => false,
					'status' => "400",
					'msg' => 'Hợp đồng chưa gia hạn',
					'data' => $result
				];
				$this->pushJson('200', json_encode($response));
				return;
			}
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => 'Không tìm thấy hợp đồng',
				'data' => $result
			];
			$this->pushJson('200', json_encode($response));
			return;
		}
	}


	public function duyet_hd_nganluong()
	{
		$data = $this->input->post();
		$data['contract_id'] = $this->security->xss_clean($data['contract_id']);
		$data['code_nganluong'] = $this->security->xss_clean($data['code_nganluong']);
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['contract_id']));
		if ($contract->status == 200) {
			if (isset($contract->data->status_create_withdrawal_nl) && $contract->data->status_create_withdrawal_nl == "03" && isset(explode('_', $data['code_nganluong'])[2])) {

				$dataPost = array(
					"id" => $data['contract_id'],
					"bank_name_disbursement" => "NGÂN LƯỢNG",
					"code_auto_disbursement" => "",
					"code_transaction_bank_disbursement" => "",
					"content_transfer" => "",
					"content_transfer_disbursement" => "",
					"disbursement_date" => explode('_', $data['code_nganluong'])[2],
					"disbursement_date_new" => explode('_', $data['code_nganluong'])[2],
					"investor_id" => "5eb57e17d6612b5384658686",
					"max_code_auto_disbursement" => 8,
					"response_get_transaction_withdrawal_status_nl" => array(
						"error_code" => "00",
						"ref_code" => $data['code_nganluong'],
						"total_amount" => $contract->data->loan_infor->amount_loan,
						"transaction_status" => "00",
						"error_message" => "Đã có lỗi xảy ra nhưng vẫn thành công"
					),
					"investor_code" => "vfc1_nl",
					"status_create_withdrawal_nl" => "00",
					"status_disbursement" => 2,
					"status" => 17
				);
				$result = $this->api->apiPost($this->userInfo['token'], "contract/update", $dataPost);
				if (!empty($result->status) && $result->status == 200) {
					$response = [
						'res' => true,
						'status' => "200",
						'msg' => 'Duyệt thành công mã : ' . $contract->data->code_contract,
						'url' => $result->url
					];
					//echo json_encode($response);
					$this->pushJson('200', json_encode($response));
					return;
				} else {
					$response = [
						'res' => false,
						'status' => "400",
						'msg' => $result->message . ' : mã phiếu ghi:' . $contract->data->code_contract,
						'data' => $result
					];
					$this->pushJson('200', json_encode($response));
					return;
				}
			} else {
				$response = [
					'res' => false,
					'status' => "400",
					'msg' => 'Không tìm thấy trạng thái lỗi ngân lượng 03: ' . $contract->data->code_contract,
					'data' => $result
				];
				$this->pushJson('200', json_encode($response));
				return;
			}

		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => 'Không tìm thấy hợp đồng',
				'data' => $result
			];
			$this->pushJson('200', json_encode($response));
			return;
		}

	}

	public function do_transaction_created()
	{
		if (!empty($_POST)) {

			$transaction = $this->api->apiPost($this->userInfo['token'], "transaction/create_tran_test", array("code_contract" => trim($_POST['code_contract']), "date_pay" => $_POST['date'], "amount" => $_POST['amount']));
			//var_dump($transaction); die;
			if ($transaction->status == 200) {

				$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $transaction->contract_id));
				if ($contract->status == 200) {
					if ((isset($contract->data->investor_id) || isset($contract->data->investor_code) && isset($contract->data->disbursement_date))) {
						if (isset($contract->data->investor_id)) {
							$data_in = array("id" => $contract->data->investor_id);
							$investors = $this->api->apiPost($this->userInfo['token'], "investor/get_one", $data_in);
							if ($investors->status == 200) {
								$investor_code = $investors->data->code;
							} else {

								$this->session->set_flashdata('error', 'Không tìm thấy nhà đầu tư' . ' : mã phiếu ghi:' . $contract->data->code_contract);
							}
						} else {
							$investor_code = $contract->data->investor_code;
						}
						$data_delete = array(
							"code_contract" => $contract->data->code_contract,
						);
						$result_delete_and_update = $this->api->apiPost($this->userInfo['token'], "contract/delete_lai_ky_lai_thang", $data_delete);
						if (!empty($result_delete_and_update->status) && $result_delete_and_update->status == 200) {


							$dataPost_dele = array(
								"code_contract" => $contract->data->code_contract,
								"investor_code" => $investor_code,
								"disbursement_date" => $contract->data->disbursement_date
							);
							$result = $this->api->apiPost($this->userInfo['token'], "generateContract/processContract", $dataPost_dele);
							if (!empty($result->status) && $result->status == 200) {
								$dataPost = array(
									"code_contract" => $contract->data->code_contract,
									"investor_code" => $investor_code,
									"disbursement_date" => $contract->data->disbursement_date
								);
								$result = $this->api->apiPost($this->userInfo['token'], "transaction/payment_all_contract", $dataPost);
								if (!empty($result->status) && $result->status == 200) {

									$this->session->set_flashdata('success', 'Chạy phí thành công mã phiếu ghi : ' . $contract->data->code_contract);
								} else {

									$this->session->set_flashdata('error', $result->message . ' : mã phiếu ghi:' . $contract->data->code_contract);
								}
							}
						}

					} else {
						$this->session->set_flashdata('error', 'Hợp đồng không có mã nhà đầu tư và ngày giải ngân.' . ' : mã phiếu ghi:' . $contract->data->code_contract);

					}
				} else {
					$this->session->set_flashdata('error', "Không tìm thấy hợp đồng");
				}

			} else {
				$this->session->set_flashdata('error', $transaction->message);
			}
		} else {
			$this->session->set_flashdata('error', "Bạn cần nhập đủ thông tin");
		}
		$this->data['template'] = 'page/accountant/caculator/create_transaction';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function transaction_created()
	{
		$this->data['template'] = 'page/accountant/caculator/create_transaction';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function get_vbee_thn()
	{
		$data['tab'] = !empty($_GET['tab']) ? $_GET['tab'] : 'toi_han';
		$call_thn_toi_han = !empty($_GET['call_thn_toi_han']) ? $_GET['call_thn_toi_han'] : '';
		$calledAtVbee = !empty($_GET['calledAtVbee']) ? $_GET['calledAtVbee'] : '';
		$duration = !empty($_GET['duration']) ? $_GET['duration'] : '';
		$status_end_code = !empty($_GET['status_end_code']) ? $_GET['status_end_code'] : '';
		$status_vbee = !empty($_GET['status_vbee']) ? $_GET['status_vbee'] : '';
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : '';
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : '';
		$start_date = !empty($_GET['calledAtVbee_start']) ? $_GET['calledAtVbee_start'] : '';
		$end_date = !empty($_GET['calledAtVbee_end']) ? $_GET['calledAtVbee_end'] : '';
		$customer_phone_number = !empty($_GET['sdt']) ? $_GET['sdt'] : '';
		$customer_identify = !empty($_GET['customer_identify']) ? $_GET['customer_identify'] : '';
		$priority_truoc_han = !empty($_GET['priority_truoc_han']) ? $_GET['priority_truoc_han'] : '';
		$priority_qh = !empty($_GET['priority_qh']) ? $_GET['priority_qh'] : '';
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['per_page'] = 20;
		$config['uri_segment'] = $uriSegment;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];
		$config['base_url'] = base_url('temporary_plan/get_vbee_thn?tab='.$data['tab'].'&calledAtVbee_start='.$start_date.'&calledAtVbee_end='.$end_date.'&sdt='.$customer_phone_number.
		'&customer_name='.$customer_name.'&code_contract_disbursement='.$code_contract_disbursement.'&customer_identify='.$customer_identify.'&priority_truoc_han='.$priority_truoc_han);
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
		$data['sdt'] = $customer_phone_number;
		$data['name'] = $customer_name;
		$data['code_contract_disbursement'] = $code_contract_disbursement;
		$data['customer_identify'] = $customer_identify;
		$data['priority_qh'] = $priority_qh;
		$data['priority_truoc_han'] = $priority_truoc_han;
		if ($data['tab'] == 'toi_han' ) {
			$leadsData = $this->api->apiPost($this->user['token'], "/lead/get_toi_han", $data);
			if (isset($leadsData->status) && $leadsData->status == 200) {
				$config['total_rows'] = $leadsData->total;
				$this->data['leadsData'] = $leadsData->data;
				$this->data['total_rows'] = $leadsData->total;
			} else {
				$this->data['leadsData'] = array();
			}
		} elseif ($data['tab'] == 'truoc_han') {
			$leadsDataTruocHan = $this->api->apiPost($this->user['token'], "/lead/get_truoc_han",$data);
			if (isset($leadsDataTruocHan->status) && $leadsDataTruocHan->status == 200) {
				$config['total_rows'] = $leadsDataTruocHan->total;
				$this->data['leadsDataTruocHan'] = $leadsDataTruocHan->data;
				$this->data['total_rows'] = $leadsDataTruocHan->total;
			} else {
				$this->data['leadsDataTruocHan'] = array();
			}
		} elseif ($data['tab'] == 'qua_han') {
			$leadsDataQuaHan = $this->api->apiPost($this->user['token'], "/lead/get_qua_han",$data);
			if (isset($leadsDataQuaHan->status) && $leadsDataQuaHan->status == 200) {
				$config['total_rows'] = $leadsDataQuaHan->total;
				$this->data['leadsDataQuaHan'] = $leadsDataQuaHan->data;
				$this->data['total_rows'] = $leadsDataQuaHan->total;
			} else {
				$this->data['leadsDataQuaHan'] = array();
			}
		}
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/accountant/list_call_vbee_thn';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function excel_thn()
	{
		$data['tab'] = !empty($_GET['tab']) ? $_GET['tab'] : 'toi_han';
		$start_date = !empty($_GET['start_date']) ? $_GET['start_date'] : '';
		$end_date = !empty($_GET['end_date']) ? $_GET['end_date'] : '';
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : '';
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
		$data['code_contract_disbursement'] = $code_contract_disbursement;
		if ($data['tab'] == 'toi_han'){
			$result_toi_han = $this->api->apiPost($this->user['token'],"lead/excel_thn_call_vbee_toi_han", $data);
			if (!empty($result_toi_han->status) && $result_toi_han->status == 200) {
				$this->export_list_thn($result_toi_han->data);
				$this->callLibExcel('chien-dich-toi-han' . time() . '.xlsx');
			}else {
				$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
				redirect(base_url('temporary_plan/get_vbee_thn?tab='.$data['tab']));
			}
		}elseif ($data['tab'] == 'truoc_han'){
			$result_truoc_han = $this->api->apiPost($this->user['token'],"lead/excel_thn_call_vbee_truoc_han", $data);
			if (!empty($result_truoc_han->status) && $result_truoc_han->status == 200) {
				$this->export_list_thn($result_truoc_han->data);
				$this->callLibExcel('chien-dich-truoc-han' . date('Y-m-d') . '.xlsx');
			}else {
				$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
				redirect(base_url('temporary_plan/get_vbee_thn?tab='.$data['tab']));
			}
		}elseif ($data['tab'] == 'qua_han'){
			$result_qua_han = $this->api->apiPost($this->user['token'],"lead/excel_thn_call_vbee_qua_han", $data);
			if (!empty($result_qua_han->status) && $result_qua_han->status == 200) {
				$this->export_list_thn($result_qua_han->data);
				$this->callLibExcel('chien-dich-qua-han' . date('Y-m-d') . '.xlsx');
			}else {
				$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
				redirect(base_url('temporary_plan/get_vbee_thn?tab='.$data['tab']));
			}
		}

	}

	public function export_list_thn($data)
	{
		$data['tab'] = !empty($_GET['tab']) ? $_GET['tab'] : 'toi_han';
		if ($data['tab'] == 'truoc_han') {
			$this->sheet->setCellValue('A1', 'Mã Hợp Đồng')->getColumnDimension('A')->setAutoSize(true);
			$this->sheet->setCellValue('B1', 'Bucket')->getColumnDimension('B')->setAutoSize(true);
			$this->sheet->setCellValue('C1', 'Ngày quá hạn')->getColumnDimension('C')->setAutoSize(true);
			$this->sheet->setCellValue('D1', 'PGD/DRS')->getColumnDimension('D')->setAutoSize(true);
			$this->sheet->setCellValue('E1', 'Nhân viên THN phụ trách')->getColumnDimension('E')->setAutoSize(true);
			$this->sheet->setCellValue('F1', 'Tên khách hàng')->getColumnDimension('F')->setAutoSize(true);
			$this->sheet->setCellValue('G1', 'Tiền kỳ')->getColumnDimension('G')->setAutoSize(true);
			$this->sheet->setCellValue('H1', 'Ngày Thanh Toán')->getColumnDimension('H')->setAutoSize(true);
			$this->sheet->setCellValue('I1', 'Số điện thoại')->getColumnDimension('I')->setAutoSize(true);
			$this->sheet->setCellValue('J1', 'CMT/CCCD/Hộ chiếu')->getColumnDimension('J')->setAutoSize(true);
			$this->sheet->setCellValue('K1', 'Thời điểm gọi')->getColumnDimension('K')->setAutoSize(true);
			$this->sheet->setCellValue('L1', 'Thời lượng kết nối TĐV(s)')->getColumnDimension('L')->setAutoSize(true);
			$this->sheet->setCellValue('M1', 'Phím Bấm')->getColumnDimension('M')->setAutoSize(true);
			$this->sheet->setCellValue('N1', 'Độ ưu tiên')->getColumnDimension('N')->setAutoSize(true);
			$i = 2;
			foreach ($data as $item) {
				$priority = '';
				if (!empty($item->priority_truoc_han == "3")){
					$priority = 'Thấp';
				}elseif (!empty($item->priority_truoc_han == "2")){
					$priority = 'Trung Bình';
				}elseif (!empty($item->priority_truoc_han == "1")){
					$priority = 'Cao';
				}
				$this->sheet->setCellValue('A' . $i, !empty($item->code_contract_disbursement) ? $item->code_contract_disbursement : '');
				$this->sheet->setCellValue('B' . $i, !empty($item->so_ngay_cham_tra) ? get_bucket($item->so_ngay_cham_tra) : '');
				$this->sheet->setCellValue('C' . $i, !empty($item->so_ngay_cham_tra) ? $item->so_ngay_cham_tra : '');
				$this->sheet->setCellValue('D' . $i, !empty($item->store_name) ? $item->store_name : '');
				$this->sheet->setCellValue('E' . $i, !empty($item->caller) ? $item->caller : '');
				$this->sheet->setCellValue('F' . $i, !empty($item->name) ? ($item->name) : '');
				$this->sheet->setCellValue('G' . $i, !empty($item->amount_truoc_han) ?	($item->amount_truoc_han) : '');
				$this->sheet->setCellValue('H' . $i, !empty($item->ngay_ky_tra) ? date('Y-m-d',$item->ngay_ky_tra) : '');
				$this->sheet->setCellValue('I' . $i, !empty($item->phone) ? $item->phone : "");
				$this->sheet->setCellValue('J' . $i, !empty($item->cmt) ? $item->cmt : '');
				$this->sheet->setCellValue('K' . $i, !empty($item->calledAtVbee) ? date('Y-m-d',$item->calledAtVbee) : '');
				$this->sheet->setCellValue('L' . $i, !empty($item->duration) ? ($item->duration) : '');
				$this->sheet->setCellValue('M' . $i, $item->key_press === 0 ? "'" . $item->key_press : $item->key_press);
				$this->sheet->setCellValue('N' . $i, !empty($item->priority_truoc_han) ? $priority : '');
				$i++;
			}
		} elseif ($data['tab'] == 'toi_han') {
			$this->sheet->setCellValue('A1', 'Mã Hợp Đồng')->getColumnDimension('A')->setAutoSize(true);
			$this->sheet->setCellValue('B1', 'Bucket')->getColumnDimension('B')->setAutoSize(true);
			$this->sheet->setCellValue('C1', 'Ngày quá hạn')->getColumnDimension('C')->setAutoSize(true);
			$this->sheet->setCellValue('D1', 'PGD/DRS')->getColumnDimension('D')->setAutoSize(true);
			$this->sheet->setCellValue('E1', 'Nhân viên THN phụ trách')->getColumnDimension('E')->setAutoSize(true);
			$this->sheet->setCellValue('F1', 'Tên khách hàng')->getColumnDimension('F')->setAutoSize(true);
			$this->sheet->setCellValue('G1', 'Tiền kỳ')->getColumnDimension('G')->setAutoSize(true);
			$this->sheet->setCellValue('H1', 'Ngày Thanh Toán')->getColumnDimension('H')->setAutoSize(true);
			$this->sheet->setCellValue('I1', 'Số điện thoại')->getColumnDimension('I')->setAutoSize(true);
			$this->sheet->setCellValue('J1', 'CMT/CCCD/Hộ chiếu')->getColumnDimension('J')->setAutoSize(true);
			$this->sheet->setCellValue('K1', 'Thời điểm gọi')->getColumnDimension('K')->setAutoSize(true);
			$this->sheet->setCellValue('L1', 'Thời lượng kết nối TĐV(s)')->getColumnDimension('L')->setAutoSize(true);
			$this->sheet->setCellValue('M1', 'Trạng thái')->getColumnDimension('M')->setAutoSize(true);
			$i = 2;
			foreach ($data as $item) {
				$this->sheet->setCellValue('A' . $i, !empty($item->code_contract_disbursement) ? $item->code_contract_disbursement : '');
				$this->sheet->setCellValue('B' . $i, !empty($item->so_ngay_cham_tra) ? get_bucket($item->so_ngay_cham_tra) : '');
				$this->sheet->setCellValue('C' . $i, !empty($item->so_ngay_cham_tra) ? $item->so_ngay_cham_tra : '');
				$this->sheet->setCellValue('D' . $i, !empty($item->store_name) ? $item->store_name : '');
				$this->sheet->setCellValue('E' . $i, !empty($item->caller) ? $item->caller : '');
				$this->sheet->setCellValue('F' . $i, !empty($item->name) ? ($item->name) : '');
				$this->sheet->setCellValue('G' . $i, !empty($item->amount_th) ? ($item->amount_th) : '');
				$this->sheet->setCellValue('H' . $i, !empty($item->ngay_ky_tra) ? date('Y-m-d',$item->ngay_ky_tra) : '');
				$this->sheet->setCellValue('I' . $i, !empty($item->phone) ? $item->phone : "");
				$this->sheet->setCellValue('J' . $i, !empty($item->cmt) ? $item->cmt : '');
				$this->sheet->setCellValue('K' . $i, !empty($item->calledAtVbee) ? date('Y-m-d',$item->calledAtVbee) : '');
				$this->sheet->setCellValue('L' . $i, !empty($item->duration) ? ($item->duration) : '');
				$this->sheet->setCellValue('M' . $i, !empty($item->status_end_code) ? ($item->status_end_code) : '');
				$i++;
			}
		} elseif ($data['tab'] == 'qua_han') {
			$this->sheet->setCellValue('A1', 'Mã Hợp Đồng')->getColumnDimension('A')->setAutoSize(true);
			$this->sheet->setCellValue('B1', 'Bucket')->getColumnDimension('B')->setAutoSize(true);
			$this->sheet->setCellValue('C1', 'Ngày quá hạn')->getColumnDimension('C')->setAutoSize(true);
			$this->sheet->setCellValue('D1', 'PGD/DRS')->getColumnDimension('D')->setAutoSize(true);
			$this->sheet->setCellValue('E1', 'Nhân viên THN phụ trách')->getColumnDimension('E')->setAutoSize(true);
			$this->sheet->setCellValue('F1', 'Tên khách hàng')->getColumnDimension('F')->setAutoSize(true);
			$this->sheet->setCellValue('G1', 'Tiền kỳ')->getColumnDimension('G')->setAutoSize(true);
			$this->sheet->setCellValue('H1', 'Ngày Thanh Toán')->getColumnDimension('H')->setAutoSize(true);
			$this->sheet->setCellValue('I1', 'Số điện thoại')->getColumnDimension('I')->setAutoSize(true);
			$this->sheet->setCellValue('J1', 'CMT/CCCD/Hộ chiếu')->getColumnDimension('J')->setAutoSize(true);
			$this->sheet->setCellValue('K1', 'Thời điểm gọi')->getColumnDimension('K')->setAutoSize(true);
			$this->sheet->setCellValue('L1', 'Thời lượng kết nối TĐV(s)')->getColumnDimension('L')->setAutoSize(true);
			$this->sheet->setCellValue('M1', 'Phím Bấm')->getColumnDimension('M')->setAutoSize(true);
			$this->sheet->setCellValue('N1', 'Độ ưu tiên')->getColumnDimension('N')->setAutoSize(true);
			$i = 2;
			foreach ($data as $item) {
				$priority = '';
				if (!empty($item->priority_qh == "3")) {
					$priority = 'Thấp';
				} elseif (!empty($item->priority_qh == "2")) {
					$priority = 'Trung Bình';
				} elseif (!empty($item->priority_qh == "1")) {
					$priority = 'Cao';
				}
				$this->sheet->setCellValue('A' . $i, !empty($item->code_contract_disbursement) ? $item->code_contract_disbursement : '');
				$this->sheet->setCellValue('B' . $i, !empty($item->so_ngay_cham_tra) ? get_bucket($item->so_ngay_cham_tra) : '');
				$this->sheet->setCellValue('C' . $i, !empty($item->so_ngay_cham_tra) ? ($item->so_ngay_cham_tra) : '');
				$this->sheet->setCellValue('D' . $i, !empty($item->store_name) ? $item->store_name : '');
				$this->sheet->setCellValue('E' . $i, !empty($item->caller) ? $item->caller : '');
				$this->sheet->setCellValue('F' . $i, !empty($item->name) ? ($item->name) : '');
				$this->sheet->setCellValue('G' . $i, !empty($item->amount_qua_han) ? ($item->amount_qua_han) : '');
				$this->sheet->setCellValue('H' . $i, !empty($item->ngay_thanh_toan) ? date('Y-m-d',$item->ngay_thanh_toan) : '');
				$this->sheet->setCellValue('I' . $i, !empty($item->phone) ? $item->phone : "");
				$this->sheet->setCellValue('J' . $i, !empty($item->cmt) ? $item->cmt : '');
				$this->sheet->setCellValue('K' . $i, !empty($item->calledAtVbee_qh) ? date('Y-m-d',$item->calledAtVbee_qh) : '');
				$this->sheet->setCellValue('L' . $i, !empty($item->duration_qh) ? ($item->duration_qh) : '');
				$this->sheet->setCellValue('M' . $i,
				$item->key_press === 0 ? "'" . $item->key_press : $item->key_press
				);
				$this->sheet->setCellValue('N' . $i, !empty($item->priority_qh) ? $priority : '');
				$i++;
			}

		}
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

}

?>

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

class Contract_ksnb extends MY_Controller
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
		$this->load->model("store_model");
		$this->load->library('session');

		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";


	}

	public function index_list_contract_ksnb()
	{

		$stores = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active");
		$this->data['stores'] = $stores->data;

		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$code_contract_disbursement = $this->api->apiPost($this->userInfo['token'], "contract/contract_ksnb");

		if (!empty($code_contract_disbursement->status) && $code_contract_disbursement->status == 200) {
			$arr_code_contract_disbursement = [];
			foreach ($code_contract_disbursement->data as $value) {
				if (!empty($value->code_contract_disbursement)) {
					array_push($arr_code_contract_disbursement, $value->code_contract_disbursement);
				}
			}
			$this->data['code_contract_disbursement'] = $arr_code_contract_disbursement;
		} else {
			$this->data['code_contract_disbursement'] = array();
		}

		$countKsnb = $this->api->apiPost($this->userInfo['token'], "contract_ksnb/get_count_all");

		$count = (int)$countKsnb->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('contract_ksnb/index_list_contract_ksnb');
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;

		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];

		$contract_ksnb = $this->api->apiPost($this->userInfo['token'], "contract_ksnb/get_all", $data);
		if (!empty($contract_ksnb->status) && $contract_ksnb->status == 200) {
			$this->data['contract_ksnb'] = $contract_ksnb->data;
		} else {
			$this->data['contract_ksnb'] = array();
		}


		$this->data['template'] = 'page/contract_ksnb/list_contract_ksnb';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function create_contract_ksnb()
	{
		$data = $this->input->post();
		$data['code_contract_disbursement_value'] = $this->security->xss_clean($data['code_contract_disbursement_value']);
		if (!empty($data['code_contract_disbursement_value'])) {
			foreach ($data['code_contract_disbursement_value'][0] as $value) {

				$contract = $this->api->apiPost($this->userInfo['token'], "contract_ksnb/add_contract_ksnb", ['code_contract_disbursement_value' => $value]);

				$sendApi = array(
					'code_contract_disbursement_value' => $value,

					'contract' => $contract->data,

					"status_ksnb" => "1",
					"created_at" => $this->createdAt,
					"created_by" => $this->userInfo,
				);
				$return = $this->api->apiPost($this->userInfo['token'], "contract_ksnb/process_create_contract_ksnb", $sendApi);

				if (!empty($return) && $return->status == 200) {
					$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
				} else {
					$msg = !empty($return->data->message) ? $return->data->message : $return->message;
					$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));

				}
			}
		} else {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => "Mã hợp đồng không được để trống"))));
		}

	}


	private function pushJson($code, $data)
	{
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}

	public function uploadsImageContractKsnb()
	{

		$dataGet = $this->input->get();
		$dataGet['id'] = $this->security->xss_clean($dataGet['id']);
		$dataPost = array(
			"id" => $dataGet['id']
		);
		$result = $this->api->apiPost($this->userInfo['token'], "contract_ksnb/get_image_accurecy", $dataPost);
		$this->data['result'] = $result->data;

		$this->data['template'] = 'page/contract_ksnb/accountantUpload';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);


	}

	public function updateDescriptionImage()
	{
		$data = $this->input->post();
		$data['contractId'] = $this->security->xss_clean($data['contractId']);
		$expertise = array();
		if (!empty($data['expertise'])) $expertise = $this->security->xss_clean($data['expertise']);
		$sendApi = array(
			"id" => $data['contractId'],
			'contract_ksnb' => $expertise,
		);

		//Insert log
		$return = $this->api->apiPost($this->userInfo['token'], "contract_ksnb/process_update_description_img", $sendApi);
		$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
	}

	public function view_image_ksnb()
	{

		$dataGet = $this->input->get();
		$dataGet['id'] = $this->security->xss_clean($dataGet['id']);
		$dataPost = array(
			"id" => $dataGet['id']
		);
		$result = $this->api->apiPost($this->userInfo['token'], "contract_ksnb/get_image_accurecy", $dataPost);
		$this->data['result'] = $result->data;

		$this->data['template'] = 'page/contract_ksnb/view_image';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function approve_note()
	{

		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);

		$data['note'] = $this->security->xss_clean($data['note']);


		$sendApi = array(
			"id" => $data['id'],

			'note' => $data['note'],

			"created_by" => $this->userInfo,
		);

		$return = $this->api->apiPost($this->userInfo['token'], "contract_ksnb/approve_note", $sendApi);

		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		} else {
			$msg = !empty($return->data->message) ? $return->data->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));

		}
	}

	public function search()
	{

		$data = [];
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$customer_phone_number = !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
		$customer_identify = !empty($_GET['customer_identify']) ? $_GET['customer_identify'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$code_contract_disbursement_search = !empty($_GET['code_contract_disbursement_search']) ? $_GET['code_contract_disbursement_search'] : "";

		if (!empty($store)) {
			$data['store'] = $store;
		}
		if (!empty($customer_name)) {
			$data['customer_name'] = $customer_name;
		}
		if (!empty($customer_phone_number)) {
			$data['customer_phone_number'] = $customer_phone_number;
		}
		if (!empty($customer_identify)) {
			$data['customer_identify'] = $customer_identify;
		}
		if (!empty($code_contract)) {
			$data['code_contract'] = $code_contract;
		}
		if (!empty($code_contract_disbursement_search)) {
			$data['code_contract_disbursement'] = $code_contract_disbursement_search;
		}

		$stores = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active");
		$this->data['stores'] = $stores->data;

		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$code_contract_disbursement = $this->api->apiPost($this->userInfo['token'], "contract/contract_ksnb");

		if (!empty($code_contract_disbursement->status) && $code_contract_disbursement->status == 200) {
			$arr_code_contract_disbursement = [];
			foreach ($code_contract_disbursement->data as $value) {
				if (!empty($value->code_contract_disbursement)) {
					array_push($arr_code_contract_disbursement, $value->code_contract_disbursement);
				}
			}
			$this->data['code_contract_disbursement'] = $arr_code_contract_disbursement;
		} else {
			$this->data['code_contract_disbursement'] = array();
		}


		$countKsnb = $this->api->apiPost($this->userInfo['token'], "contract_ksnb/get_count_all", $data);

		$count = (int)$countKsnb->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('contract_ksnb/index_list_contract_ksnb');
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;

		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];

		$contract_ksnb = $this->api->apiPost($this->userInfo['token'], "contract_ksnb/get_all", $data);
		if (!empty($contract_ksnb->status) && $contract_ksnb->status == 200) {
			$this->data['contract_ksnb'] = $contract_ksnb->data;
		} else {
			$this->data['contract_ksnb'] = array();
		}


		$this->data['template'] = 'page/contract_ksnb/list_contract_ksnb';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
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
		$this->data['template'] = 'page/contract_ksnb/detail/accountant.php';

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
		if (empty($data['payment_note'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "msg" => 'Bạn chưa chọn nội dung thu tiền!')));
			return;
		}

		if ($data['type_payment'] == 2 && $data['payment_amount'] < $data['fee_need_gh_cc']) {
			$this->pushJson('200', json_encode(array("status" => "400", "msg" => 'Số tiền thanh toán phải lớn hơn hơn hoặc bằng số tiền lãi phí cần để gia hạn/ cơ cấu')));
			return;
		}
		if ($data['type_payment'] == 3 && $data['amount_debt_cc'] > 0) {
			$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Tiền khách hàng thanh toán + tiền khách hàng cơ cấu phải bằng số tiền hợp lệ cơ cấu ")));
			return;
		}

		//Encrypt TripleDes
		$libTripleDes = new TripleDes();
//		$secretKey = $libTripleDes->Encrypt(json_encode($data), $this->config->item("TRIPLEDES_KEY_TRANSACTION_CONTRACT"));
		$dataPost = array(
			"amount" => $data['payment_amount'],
			"valid_amount" => $data['valid_amount_payment'],
			"reduced_fee" => $data['reduced_fee'],
			"discounted_fee" => $data['discounted_fee'],
			"other_fee" => $data['other_fee'],
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

		);
		$return = $this->api->apiPost($this->user['token'], "contract_ksnb/payment_contract", $dataPost);

		if (!empty($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("status" => "200", "msg" => "Đang khởi tạo biên nhận!", 'url' => $return->url, 'url_printed' => $return->url_printed, 'transaction_id' => $return->transaction_id)));
			return;

		} else {
			$this->pushJson('200', json_encode(array("status" => "401", "msg" => $this->lang->line('Create_failed_transaction'))));
			return;
		}

	}

	public function list_transaction()
	{

		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
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

		$stores = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active");
		$this->data['stores'] = $stores->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['base_url'] = base_url('transaction') . '?fdate=' . $fdate . '&tdate=' . $tdate . '&sdt=' . $sdt . '&status=' . $status . '&store=' . $store . '&tab=' . $tab . '&type_transaction=' . $type_transaction . '&code=' . $code . '&code_contract_disbursement=' . $code_contract_disbursement;
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
		$transactionData = $this->api->apiPost($this->userInfo['token'], "transaction/get_all_ksnb", $data);
		if (!empty($transactionData->status) && $transactionData->status == 200) {
			$this->data['transactionData'] = $transactionData->data;
			$this->data['groupRoles'] = $transactionData->groupRoles;
			$config['total_rows'] = $transactionData->total;
			$this->data['total_rows'] = $transactionData->total;
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
		$this->data['template'] = 'page/contract_ksnb/list_transaction';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;


	}

	public function history(){

		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		$condition = array("id" => $id);

		$content = $this->api->apiPost($this->userInfo['token'], "contract_ksnb/get_log_one", $condition);
		if (!empty($content->status) && $content->status == 200) {
			$this->data['content'] = $content->data;

		} else {
			$this->data['content'] = array();

		}
		$this->data['template'] = 'page/contract_ksnb/history';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;

	}

	public function search_list_transaction(){


		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$code_contract_disbursement_search = !empty($_GET['code_contract_disbursement_search']) ? $_GET['code_contract_disbursement_search'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";

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

		$stores = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active");
		$this->data['stores'] = $stores->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['base_url'] = base_url('contract_ksnb/search_list_transaction') . '?fdate=' . $fdate . '&tdate=' . $tdate . '&store=' . $store . '&status=' . $status . '&customer_name=' . $customer_name . '&code_contract=' . $code_contract . '&code_contract_disbursement_search=' . $code_contract_disbursement_search;
//		$data = array(
//			"per_page" => $config['per_page'],
//			"uriSegment" => $config['uri_segment'],
//			"fdate" => $fdate,
//			"tdate" => $tdate,
//
//		);
		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];

		if (!empty($fdate)) {
			$data['fdate'] = $fdate;
		}
		if (!empty($tdate)) {
			$data['tdate'] = $tdate;
		}
		if (!empty($status)) {
			$data['status'] = $status;
		}
		if (!empty($store)) {
			$data['store'] = $store;
		}
		if (!empty($customer_name)) {
			$data['customer_name'] = $customer_name;
		}
		if (!empty($code_contract)) {
			$data['code_contract'] = $code_contract;
		}
		if (!empty($code_contract_disbursement_search)) {
			$data['code_contract_disbursement_search'] = $code_contract_disbursement_search;
		}

		$transactionData = $this->api->apiPost($this->userInfo['token'], "transaction/get_all_ksnb", $data);
		if (!empty($transactionData->status) && $transactionData->status == 200) {
			$this->data['transactionData'] = $transactionData->data;
			$this->data['groupRoles'] = $transactionData->groupRoles;
			$config['total_rows'] = $transactionData->total;
			$this->data['total_rows'] = $transactionData->total;
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
		$this->data['template'] = 'page/contract_ksnb/list_transaction';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;

	}


}


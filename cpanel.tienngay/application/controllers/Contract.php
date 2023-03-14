<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Contract extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->api = new Api();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model("store_model");
		$this->load->model("time_model");
		$this->load->library('session');
		$this->load->helper('lead_helper');
		$this->config->load('config');
		$this->load->library('pagination');
		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
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
	public function list_money_300()
	{
		$this->data["pageName"] = "DANH SÁCH HỢP ĐỒNG CHƯA THANH TOÁN BẢO HIỂM";
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
		
		$data['chan_bao_hiem'] = 1;
		
		if (!empty($code_contract)) {
			$data['code_contract'] = trim($code_contract);
		}
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('contract?code_contract_disbursement=' . $code_contract_disbursement . '&fdate=' . $start . '&tdate=' . $end . '&customer_name=' . $customer_name . '&customer_phone_number'
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
			$this->data['tien_vay'] = $contractData->tien_vay;
			$this->data['tien_bao_hiem'] = $contractData->tien_bao_hiem;
		
		} else {
			$this->data['contractData'] = [];
		}

		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['result_count'] = $config['total_rows'];
		$stores = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active", $data);
		$store = $this->api->apiPost($this->userInfo['token'], "mic_tnds/get_store_by_user", $data);
		if (!empty($store->status) && $store->status == 200) {
			$this->data['stores'] = $store->data;
		} else {
			$this->data['stores'] = $stores->data;
		}
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		$this->data['template'] = 'page/pawn/list_hd_300/contract';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;
	}
		public function list_processes_bao_hiem()
	{

		$id = !empty($_GET['id']) ? $_GET['id'] : "";
        $data['id']=$id;
		$bhData = $this->api->apiPost($this->userInfo['token'], "contract/get_all_list_bh",$data);

		$count = (int)$bhData->count;
        $this->data['count'] = $count;
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('contract/list_processes_bao_hiem');
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;

		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];

		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_all_list_bh", $data);

		if (!empty($contract->status) && $contract->status == 200) {
			$this->data['contract'] = $contract->data;
			$this->data['contractInfor'] = $contract->contractInfor;

		}

		$this->data['template'] = 'page/pawn/list_hd_300/list_processes_bao_hiem';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;

	}
	public function do_restore_bao_hiem()
	{
		$data = $this->input->post();

		$data['contractId'] = $this->security->xss_clean($data['id_contract']);
	
		$dataPost = array(
	
			"id_contract" => $data['contractId'],
			"is_call_bao_hiem"=>1
		);
                      $this->api->apiPost($this->userInfo['token'], "contract/update_by_id", $dataPost);
		$result_gic_kv = $this->api->apiPost($this->userInfo['token'], "contract/restore_gic_kv", $dataPost);
		$result_mic_kv = $this->api->apiPost($this->userInfo['token'], "contract/restore_mic_kv", $dataPost);
		
        
		if ($result_gic_kv->status == 200 || $result_mic_kv->status == 200 ) {

			$this->pushJson('200', json_encode(array("code" => "200", "msg" =>'Thành công', "data" => '')));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => 'Có lỗi xảy ra, bạn vào xem chi tiết', "data" =>'')));
			return;
		}
	}
	public function do_edit_coupon_bao_hiem()
	{
		$data = $this->input->post();

		$data['id'] = $this->security->xss_clean($data['id']);
	   $data['code_coupon_bhkv'] = $this->security->xss_clean($data['code_coupon_bhkv']);
	   $data['image_file'] = $this->security->xss_clean($data['image_file']);
	   $data['approve_note'] = $this->security->xss_clean($data['approve_note']);
		$dataPost = array(
	
			"id_contract" => $data['id'],
			"code_coupon_bhkv"=> $data['code_coupon_bhkv'],
			"image_file"=> $data['image_file'],
			"approve_note"=> $data['approve_note'],
		);
           $result= $this->api->apiPost($this->userInfo['token'], "contract/update_coupon_bhkv", $dataPost);
		if ($result->status == 200 || $result->status == 200 ) {
              $this->api->apiPost($this->userInfo['token'], "payment/payment_all_contract", $dataPost);
			$this->pushJson('200', json_encode(array("code" => "200", "msg" =>'Thành công')));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $result->message)));
			return;
		}
	}
	public function printed_thong_bao()
	{
		$data = $this->input->get();
		$data['id'] = $this->security->xss_clean($data['id']);
		//Get information
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		$address = '';
		if ($contract->status == 200) {
			//Start Địa chỉ đang ở
			$districtSelected = $contract->data->current_address->district;
			$wardSelected = $contract->data->current_address->ward;
			$current_address = $contract->data->current_address->current_stay;
			$wardData = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtSelected));
			if (!empty($wardData->status) && $wardData->status == 200) {
				foreach ($wardData->data as $w) {
					if ($w->code == $wardSelected) {
						$address = $current_address . ', ' . $w->path_with_type;
						break;
					}
				}
			}
			//End
		}

		if ($contract->status == 200) {
			//Start Địa chỉ hổ khẩu
			$districtSelected = $contract->data->houseHold_address->district;
			$wardSelected = $contract->data->houseHold_address->ward;
			$house_hold_address = $contract->data->houseHold_address->address_household;
			$wardData = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtSelected));
			if (!empty($wardData->status) && $wardData->status == 200) {
				foreach ($wardData->data as $w) {
					if ($w->code == $wardSelected) {
						$address_house = $house_hold_address . ', ' . $w->path_with_type;
						break;
					}
				}
			}
			//End
		}
		//get bank vimo
		$bank_id = $contract->data->receiver_infor->bank_id;
		$bankVimoData = $this->api->apiPost($this->userInfo['token'], "BankVimo/get_bank_name", array('bank_id' => $bank_id));
		$bank_name = '';
		if (!empty($bankVimoData->status) && $bankVimoData->status == 200) {
			$bank_name = $bankVimoData->data->name;
		}
		$bank_id = $contract->data->receiver_infor->bank_id;
		$bankNganLuongData = $this->api->apiPost($this->userInfo['token'], "bankNganLuong/get_bank_name", array('bank_id' => $bank_id));
		$bank_name_nganluong = '';
		if (!empty($bankNganLuongData->status) && $bankNganLuongData->status == 200) {
			$bank_name_nganluong = $bankNganLuongData->data->name;
		}

		$condition = array(
			'insurrance' => isset($contract->data->loan_infor->insurrance_contract) ? $contract->data->loan_infor->insurrance_contract : '',
			'type_interest' => $contract->data->loan_infor->type_interest,
			'period_pay_interest' => $contract->data->loan_infor->period_pay_interest,
			'number_day_loan' => $contract->data->loan_infor->number_day_loan,
			'amount_money' => $contract->data->loan_infor->amount_money,
			'code_contract' => $contract->data->code_contract,
		);
		$money_per_month = $this->api->apiPost($this->userInfo['token'], "generateContract/getMoneyPerMonth", $condition);
		$money = '';
		if (!empty($money_per_month->status) && $money_per_month->status == 200) {
			$money = $money_per_month->data;
		}
		$property = !empty($contract->data->property_infor) ? $contract->data->property_infor : array();
		$sokhung = '';
		$somay = '';
		$bienkiemsoat = '';
		$nhanhieu = '';
		$model = '';
		$chuxe = '';
		$diachidangky = '';
		$sodangky = '';
		$ngaycapdangky = '';
		foreach ($property as $p) {
			if ($p->slug === 'bien-so-xe') {
				$bienkiemsoat = $p->value;
			} elseif ($p->slug === 'so-khung') {
				$sokhung = $p->value;
			} elseif ($p->slug === 'so-may') {
				$somay = $p->value;
			} elseif ($p->slug === 'nhan-hieu') {
				$nhanhieu = $p->value;
			} elseif ($p->slug === 'model') {
				$model = $p->value;
			} elseif ($p->slug === 'ho-ten-chu-xe') {
				$chuxe = $p->value;
			} elseif ($p->slug === 'dia-chi-dang-ky') {
				$diachidangky = $p->value;
			} elseif ($p->slug === 'so-dang-ky') {
				$sodangky = $p->value;
			} elseif ($p->slug === 'ngay-cap') {
				$ngaycapdangky = $p->value;
			}
		}

		$company_name = '';
		$company_address = '';
		$role = '';
		$work_year = '';
		if (!empty($contract->data->job_infor->name_company)) {
			$company_name = $contract->data->job_infor->name_company;
		}
		if (!empty($contract->data->job_infor->address_company)) {
			$company_address = $contract->data->job_infor->address_company;
		}
		if (!empty($contract->data->job_infor->job_position)) {
			$role = $contract->data->job_infor->job_position;
		}
		if (!empty($contract->data->job_infor->work_year)) {
			$work_year = $contract->data->job_infor->work_year;
		}

		$customerDOB = '';
		if (!empty($contract->data->customer_infor->customer_BOD)) {
			$dobArray = explode('-', $contract->data->customer_infor->customer_BOD);
			$customerDOB = $dobArray[2] . '/' . $dobArray[1] . '/' . $dobArray[0];
		}
		$customerPhone = '';
		if (!empty($contract->data->customer_infor->customer_phone_number)) {
			$customerPhone = $contract->data->customer_infor->customer_phone_number;
		}
		// var_dump($contract->data->store->id); die;
		$store = $this->api->apiPost($this->userInfo['token'], "store/get_store", array('id' => $contract->data->store->id));
		if (!empty($store->status) && $store->status == 200) {
			$this->data['store'] = $store->data;
		} else {
			$this->data['store'] = array();
		}
		$storeAddress = '';
		if (!empty($contract->data->store->address)) {
			$storeAddress = $contract->data->store->address;
		}
		$codeContract = '';
		if (!empty($contract->data->code_contract_disbursement)) {
			$codeContract = $contract->data->code_contract_disbursement;
		}
		
		$pgd_dong_bac = $this->api->apiPost($this->userInfo['token'], "tcv_dong_bac/get_store_tcv_dong_bac");
		$id_pgd_dong_bac = explode(' ', $pgd_dong_bac->id_store);
		$this->data['contract'] = $contract->data;
		$this->data['money'] = $money;
		$this->data['bank_name'] = $bank_name;
		$this->data['address'] = $address;
		$this->data['address_house'] = $address_house;
		$this->data['sokhung'] = $sokhung;
		$this->data['somay'] = $somay;
		$this->data['nhanhieu'] = $nhanhieu;
		$this->data['model'] = $model;
		$this->data['chuxe'] = $chuxe;
		$this->data['diachidangky'] = $diachidangky;
		$this->data['sodangky'] = $sodangky;
		$this->data['ngaycapdangky'] = $ngaycapdangky;
		$this->data['bienkiemsoat'] = $bienkiemsoat;
		$this->data['customerDOB'] = $customerDOB;
		$this->data['customerPhone'] = $customerPhone;
		$this->data['storeAddress'] = $storeAddress;
		$this->data['code_contract'] = $codeContract;
		$this->data['company_name'] = $company_name;
		$this->data['company_address'] = $company_address;
		$this->data['logs'] = $logs;
		$this->data['role'] = $role;
		$this->data['bank_name_nganluong'] = $bank_name_nganluong;

		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		if (in_array($contract->data->store->id, $id_pgd_dong_bac)) {
			$this->load->view('thn_printed/printed_thong_bao', isset($this->data) ? $this->data : NULL);
		} else {
			$this->load->view('thn_printed/printed_thong_bao', isset($this->data) ? $this->data : NULL);
		}
		return;
	}
	public function printed_thu_xac_nhan()
	{
		$data = $this->input->get();
		$data['id'] = $this->security->xss_clean($data['id']);
		//Get information
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		$address = '';
		if ($contract->status == 200) {
			//Start Địa chỉ đang ở
			$districtSelected = $contract->data->current_address->district;
			$wardSelected = $contract->data->current_address->ward;
			$current_address = $contract->data->current_address->current_stay;
			$wardData = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtSelected));
			if (!empty($wardData->status) && $wardData->status == 200) {
				foreach ($wardData->data as $w) {
					if ($w->code == $wardSelected) {
						$address = $current_address . ', ' . $w->path_with_type;
						break;
					}
				}
			}
			//End
		}

		if ($contract->status == 200) {
			//Start Địa chỉ hổ khẩu
			$districtSelected = $contract->data->houseHold_address->district;
			$wardSelected = $contract->data->houseHold_address->ward;
			$house_hold_address = $contract->data->houseHold_address->address_household;
			$wardData = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtSelected));
			if (!empty($wardData->status) && $wardData->status == 200) {
				foreach ($wardData->data as $w) {
					if ($w->code == $wardSelected) {
						$address_house = $house_hold_address . ', ' . $w->path_with_type;
						break;
					}
				}
			}
			//End
		}

		
		//get bank vimo
		$bank_id = $contract->data->receiver_infor->bank_id;
		$bankVimoData = $this->api->apiPost($this->userInfo['token'], "BankVimo/get_bank_name", array('bank_id' => $bank_id));
		$bank_name = '';
		if (!empty($bankVimoData->status) && $bankVimoData->status == 200) {
			$bank_name = $bankVimoData->data->name;
		}
		$bank_id = $contract->data->receiver_infor->bank_id;
		$bankNganLuongData = $this->api->apiPost($this->userInfo['token'], "bankNganLuong/get_bank_name", array('bank_id' => $bank_id));
		$bank_name_nganluong = '';
		if (!empty($bankNganLuongData->status) && $bankNganLuongData->status == 200) {
			$bank_name_nganluong = $bankNganLuongData->data->name;
		}

		$condition = array(
			'insurrance' => isset($contract->data->loan_infor->insurrance_contract) ? $contract->data->loan_infor->insurrance_contract : '',
			'type_interest' => $contract->data->loan_infor->type_interest,
			'period_pay_interest' => $contract->data->loan_infor->period_pay_interest,
			'number_day_loan' => $contract->data->loan_infor->number_day_loan,
			'amount_money' => $contract->data->loan_infor->amount_money,
			'code_contract' => $contract->data->code_contract,
		);
		$money_per_month = $this->api->apiPost($this->userInfo['token'], "generateContract/getMoneyPerMonth", $condition);
		$money = '';
		if (!empty($money_per_month->status) && $money_per_month->status == 200) {
			$money = $money_per_month->data;
		}
		$property = !empty($contract->data->property_infor) ? $contract->data->property_infor : array();
		$sokhung = '';
		$somay = '';
		$bienkiemsoat = '';
		$nhanhieu = '';
		$model = '';
		$chuxe = '';
		$diachidangky = '';
		$sodangky = '';
		$ngaycapdangky = '';
		foreach ($property as $p) {
			if ($p->slug === 'bien-so-xe') {
				$bienkiemsoat = $p->value;
			} elseif ($p->slug === 'so-khung') {
				$sokhung = $p->value;
			} elseif ($p->slug === 'so-may') {
				$somay = $p->value;
			} elseif ($p->slug === 'nhan-hieu') {
				$nhanhieu = $p->value;
			} elseif ($p->slug === 'model') {
				$model = $p->value;
			} elseif ($p->slug === 'ho-ten-chu-xe') {
				$chuxe = $p->value;
			} elseif ($p->slug === 'dia-chi-dang-ky') {
				$diachidangky = $p->value;
			} elseif ($p->slug === 'so-dang-ky') {
				$sodangky = $p->value;
			} elseif ($p->slug === 'ngay-cap') {
				$ngaycapdangky = $p->value;
			}
		}

		$company_name = '';
		$company_address = '';
		$role = '';
		$work_year = '';
		if (!empty($contract->data->job_infor->name_company)) {
			$company_name = $contract->data->job_infor->name_company;
		}
		if (!empty($contract->data->job_infor->address_company)) {
			$company_address = $contract->data->job_infor->address_company;
		}
		if (!empty($contract->data->job_infor->job_position)) {
			$role = $contract->data->job_infor->job_position;
		}
		if (!empty($contract->data->job_infor->work_year)) {
			$work_year = $contract->data->job_infor->work_year;
		}

		$customerDOB = '';
		if (!empty($contract->data->customer_infor->customer_BOD)) {
			$dobArray = explode('-', $contract->data->customer_infor->customer_BOD);
			$customerDOB = $dobArray[2] . '/' . $dobArray[1] . '/' . $dobArray[0];
		}
		$customerPhone = '';
		if (!empty($contract->data->customer_infor->customer_phone_number)) {
			$customerPhone = $contract->data->customer_infor->customer_phone_number;
		}
		// var_dump($contract->data->store->id); die;
		$store = $this->api->apiPost($this->userInfo['token'], "store/get_store", array('id' => $contract->data->store->id));
		if (!empty($store->status) && $store->status == 200) {
			$this->data['store'] = $store->data;
		} else {
			$this->data['store'] = array();
		}
		$storeAddress = '';
		if (!empty($contract->data->store->address)) {
			$storeAddress = $contract->data->store->address;
		}
		$codeContract = '';
		if (!empty($contract->data->code_contract_disbursement)) {
			$codeContract = $contract->data->code_contract_disbursement;
		}

		$pgd_dong_bac = $this->api->apiPost($this->userInfo['token'], "tcv_dong_bac/get_store_tcv_dong_bac");

		$historyData = $this->api->apiPost($this->userInfo['token'], "transaction/history_contract", $data);
		$group_total=0;
		if (!empty($historyData->status) && $historyData->status == 200) {
			if(!empty($historyData->data))
			{
				foreach($historyData->data as $key => $history){
		            if($history->type==2) continue;
		            
		             if($history->status==1)
		            {
		            $group_total+=$history->total;
					}
				}
			}
		}
		
		$this->data['money_total_payment'] =$group_total;
		
		$id_pgd_dong_bac = explode(' ', $pgd_dong_bac->id_store);
		$this->data['contract'] = $contract->data;
		$this->data['money'] = $money;
		$this->data['bank_name'] = $bank_name;
		$this->data['address'] = $address;
		$this->data['address_house'] = $address_house;
		$this->data['sokhung'] = $sokhung;
		$this->data['somay'] = $somay;
		$this->data['nhanhieu'] = $nhanhieu;
		$this->data['model'] = $model;
		$this->data['chuxe'] = $chuxe;
		$this->data['diachidangky'] = $diachidangky;
		$this->data['sodangky'] = $sodangky;
		$this->data['ngaycapdangky'] = $ngaycapdangky;
		$this->data['bienkiemsoat'] = $bienkiemsoat;
		$this->data['customerDOB'] = $customerDOB;
		$this->data['customerPhone'] = $customerPhone;
		$this->data['storeAddress'] = $storeAddress;
		$this->data['code_contract'] = $codeContract;
		$this->data['company_name'] = $company_name;
		$this->data['company_address'] = $company_address;
		$this->data['role'] = $role;
		$this->data['bank_name_nganluong'] = $bank_name_nganluong;

		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		if (in_array($contract->data->store->id, $id_pgd_dong_bac)) {
			$this->load->view('thn_printed/printed_thu_xac_nhan', isset($this->data) ? $this->data : NULL);
		} else {
			$this->load->view('thn_printed/printed_thu_xac_nhan', isset($this->data) ? $this->data : NULL);
		}
		return;
	}
	public function printed_quyet_dinh()
	{
		$data = $this->input->get();
		$data['id'] = $this->security->xss_clean($data['id']);
		//Get information
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		$address = '';
		if ($contract->status == 200) {
			//Start Địa chỉ đang ở
			$districtSelected = $contract->data->current_address->district;
			$wardSelected = $contract->data->current_address->ward;
			$current_address = $contract->data->current_address->current_stay;
			$wardData = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtSelected));
			if (!empty($wardData->status) && $wardData->status == 200) {
				foreach ($wardData->data as $w) {
					if ($w->code == $wardSelected) {
						$address = $current_address . ', ' . $w->path_with_type;
						break;
					}
				}
			}
			//End
		}

		if ($contract->status == 200) {
			//Start Địa chỉ hổ khẩu
			$districtSelected = $contract->data->houseHold_address->district;
			$wardSelected = $contract->data->houseHold_address->ward;
			$house_hold_address = $contract->data->houseHold_address->address_household;
			$wardData = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtSelected));
			if (!empty($wardData->status) && $wardData->status == 200) {
				foreach ($wardData->data as $w) {
					if ($w->code == $wardSelected) {
						$address_house = $house_hold_address . ', ' . $w->path_with_type;
						break;
					}
				}
			}
			//End
		}
		//get bank vimo
		$bank_id = $contract->data->receiver_infor->bank_id;
		$bankVimoData = $this->api->apiPost($this->userInfo['token'], "BankVimo/get_bank_name", array('bank_id' => $bank_id));
		$bank_name = '';
		if (!empty($bankVimoData->status) && $bankVimoData->status == 200) {
			$bank_name = $bankVimoData->data->name;
		}
		$bank_id = $contract->data->receiver_infor->bank_id;
		$bankNganLuongData = $this->api->apiPost($this->userInfo['token'], "bankNganLuong/get_bank_name", array('bank_id' => $bank_id));
		$bank_name_nganluong = '';
		if (!empty($bankNganLuongData->status) && $bankNganLuongData->status == 200) {
			$bank_name_nganluong = $bankNganLuongData->data->name;
		}

		$condition = array(
			'insurrance' => isset($contract->data->loan_infor->insurrance_contract) ? $contract->data->loan_infor->insurrance_contract : '',
			'type_interest' => $contract->data->loan_infor->type_interest,
			'period_pay_interest' => $contract->data->loan_infor->period_pay_interest,
			'number_day_loan' => $contract->data->loan_infor->number_day_loan,
			'amount_money' => $contract->data->loan_infor->amount_money,
			'code_contract' => $contract->data->code_contract,
		);
		$money_per_month = $this->api->apiPost($this->userInfo['token'], "generateContract/getMoneyPerMonth", $condition);
		$money = '';
		if (!empty($money_per_month->status) && $money_per_month->status == 200) {
			$money = $money_per_month->data;
		}
		$property = !empty($contract->data->property_infor) ? $contract->data->property_infor : array();
		$sokhung = '';
		$somay = '';
		$bienkiemsoat = '';
		$nhanhieu = '';
		$model = '';
		$chuxe = '';
		$diachidangky = '';
		$sodangky = '';
		$ngaycapdangky = '';
		foreach ($property as $p) {
			if ($p->slug === 'bien-so-xe') {
				$bienkiemsoat = $p->value;
			} elseif ($p->slug === 'so-khung') {
				$sokhung = $p->value;
			} elseif ($p->slug === 'so-may') {
				$somay = $p->value;
			} elseif ($p->slug === 'nhan-hieu') {
				$nhanhieu = $p->value;
			} elseif ($p->slug === 'model') {
				$model = $p->value;
			} elseif ($p->slug === 'ho-ten-chu-xe') {
				$chuxe = $p->value;
			} elseif ($p->slug === 'dia-chi-dang-ky') {
				$diachidangky = $p->value;
			} elseif ($p->slug === 'so-dang-ky') {
				$sodangky = $p->value;
			} elseif ($p->slug === 'ngay-cap') {
				$ngaycapdangky = $p->value;
			}
		}

		$company_name = '';
		$company_address = '';
		$role = '';
		$work_year = '';
		if (!empty($contract->data->job_infor->name_company)) {
			$company_name = $contract->data->job_infor->name_company;
		}
		if (!empty($contract->data->job_infor->address_company)) {
			$company_address = $contract->data->job_infor->address_company;
		}
		if (!empty($contract->data->job_infor->job_position)) {
			$role = $contract->data->job_infor->job_position;
		}
		if (!empty($contract->data->job_infor->work_year)) {
			$work_year = $contract->data->job_infor->work_year;
		}

		$customerDOB = '';
		if (!empty($contract->data->customer_infor->customer_BOD)) {
			$dobArray = explode('-', $contract->data->customer_infor->customer_BOD);
			$customerDOB = $dobArray[2] . '/' . $dobArray[1] . '/' . $dobArray[0];
		}
		$customerPhone = '';
		if (!empty($contract->data->customer_infor->customer_phone_number)) {
			$customerPhone = $contract->data->customer_infor->customer_phone_number;
		}
		// var_dump($contract->data->store->id); die;
		$store = $this->api->apiPost($this->userInfo['token'], "store/get_store", array('id' => $contract->data->store->id));
		if (!empty($store->status) && $store->status == 200) {
			$this->data['store'] = $store->data;
		} else {
			$this->data['store'] = array();
		}
		$storeAddress = '';
		if (!empty($contract->data->store->address)) {
			$storeAddress = $contract->data->store->address;
		}
		$codeContract = '';
		if (!empty($contract->data->code_contract_disbursement)) {
			$codeContract = $contract->data->code_contract_disbursement;
		}
	
		$pgd_dong_bac = $this->api->apiPost($this->userInfo['token'], "tcv_dong_bac/get_store_tcv_dong_bac");
		$id_pgd_dong_bac = explode(' ', $pgd_dong_bac->id_store);
		$this->data['contract'] = $contract->data;
		$this->data['money'] = $money;
		$this->data['bank_name'] = $bank_name;
		$this->data['address'] = $address;
		$this->data['address_house'] = $address_house;
		$this->data['sokhung'] = $sokhung;
		$this->data['somay'] = $somay;
		$this->data['nhanhieu'] = $nhanhieu;
		$this->data['model'] = $model;
		$this->data['chuxe'] = $chuxe;
		$this->data['diachidangky'] = $diachidangky;
		$this->data['sodangky'] = $sodangky;
		$this->data['ngaycapdangky'] = $ngaycapdangky;
		$this->data['bienkiemsoat'] = $bienkiemsoat;
		$this->data['customerDOB'] = $customerDOB;
		$this->data['customerPhone'] = $customerPhone;
		$this->data['storeAddress'] = $storeAddress;
		$this->data['code_contract'] = $codeContract;
		$this->data['company_name'] = $company_name;
		$this->data['company_address'] = $company_address;
		$this->data['logs'] = $logs;
		$this->data['role'] = $role;
		$this->data['bank_name_nganluong'] = $bank_name_nganluong;

		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		if (in_array($contract->data->store->id, $id_pgd_dong_bac)) {
			$this->load->view('thn_printed/printed_quyet_dinh', isset($this->data) ? $this->data : NULL);
		} else {
			$this->load->view('thn_printed/printed_quyet_dinh', isset($this->data) ? $this->data : NULL);
		}
		return;
	}
	public function printed_thong_bao_no()
	{
		$data = $this->input->get();
		$data['id'] = $this->security->xss_clean($data['id']);
		//Get information
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		$address = '';
		if ($contract->status == 200) {
			//Start Địa chỉ đang ở
			$districtSelected = $contract->data->current_address->district;
			$wardSelected = $contract->data->current_address->ward;
			$current_address = $contract->data->current_address->current_stay;
			$wardData = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtSelected));
			if (!empty($wardData->status) && $wardData->status == 200) {
				foreach ($wardData->data as $w) {
					if ($w->code == $wardSelected) {
						$address = $current_address . ', ' . $w->path_with_type;
						break;
					}
				}
			}
			//End
		}

		if ($contract->status == 200) {
			//Start Địa chỉ hổ khẩu
			$districtSelected = $contract->data->houseHold_address->district;
			$wardSelected = $contract->data->houseHold_address->ward;
			$house_hold_address = $contract->data->houseHold_address->address_household;
			$wardData = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtSelected));
			if (!empty($wardData->status) && $wardData->status == 200) {
				foreach ($wardData->data as $w) {
					if ($w->code == $wardSelected) {
						$address_house = $house_hold_address . ', ' . $w->path_with_type;
						break;
					}
				}
			}
			//End
		}
		//get bank vimo
		$bank_id = $contract->data->receiver_infor->bank_id;
		$bankVimoData = $this->api->apiPost($this->userInfo['token'], "BankVimo/get_bank_name", array('bank_id' => $bank_id));
		$bank_name = '';
		if (!empty($bankVimoData->status) && $bankVimoData->status == 200) {
			$bank_name = $bankVimoData->data->name;
		}
		$bank_id = $contract->data->receiver_infor->bank_id;
		$bankNganLuongData = $this->api->apiPost($this->userInfo['token'], "bankNganLuong/get_bank_name", array('bank_id' => $bank_id));
		$bank_name_nganluong = '';
		if (!empty($bankNganLuongData->status) && $bankNganLuongData->status == 200) {
			$bank_name_nganluong = $bankNganLuongData->data->name;
		}

		$condition = array(
			'insurrance' => isset($contract->data->loan_infor->insurrance_contract) ? $contract->data->loan_infor->insurrance_contract : '',
			'type_interest' => $contract->data->loan_infor->type_interest,
			'period_pay_interest' => $contract->data->loan_infor->period_pay_interest,
			'number_day_loan' => $contract->data->loan_infor->number_day_loan,
			'amount_money' => $contract->data->loan_infor->amount_money,
			'code_contract' => $contract->data->code_contract,
		);
		$money_per_month = $this->api->apiPost($this->userInfo['token'], "generateContract/getMoneyPerMonth", $condition);
		$money = '';
		if (!empty($money_per_month->status) && $money_per_month->status == 200) {
			$money = $money_per_month->data;
		}
		$property = !empty($contract->data->property_infor) ? $contract->data->property_infor : array();
		$sokhung = '';
		$somay = '';
		$bienkiemsoat = '';
		$nhanhieu = '';
		$model = '';
		$chuxe = '';
		$diachidangky = '';
		$sodangky = '';
		$ngaycapdangky = '';
		foreach ($property as $p) {
			if ($p->slug === 'bien-so-xe') {
				$bienkiemsoat = $p->value;
			} elseif ($p->slug === 'so-khung') {
				$sokhung = $p->value;
			} elseif ($p->slug === 'so-may') {
				$somay = $p->value;
			} elseif ($p->slug === 'nhan-hieu') {
				$nhanhieu = $p->value;
			} elseif ($p->slug === 'model') {
				$model = $p->value;
			} elseif ($p->slug === 'ho-ten-chu-xe') {
				$chuxe = $p->value;
			} elseif ($p->slug === 'dia-chi-dang-ky') {
				$diachidangky = $p->value;
			} elseif ($p->slug === 'so-dang-ky') {
				$sodangky = $p->value;
			} elseif ($p->slug === 'ngay-cap') {
				$ngaycapdangky = $p->value;
			}
		}

		$company_name = '';
		$company_address = '';
		$role = '';
		$work_year = '';
		if (!empty($contract->data->job_infor->name_company)) {
			$company_name = $contract->data->job_infor->name_company;
		}
		if (!empty($contract->data->job_infor->address_company)) {
			$company_address = $contract->data->job_infor->address_company;
		}
		if (!empty($contract->data->job_infor->job_position)) {
			$role = $contract->data->job_infor->job_position;
		}
		if (!empty($contract->data->job_infor->work_year)) {
			$work_year = $contract->data->job_infor->work_year;
		}

		$customerDOB = '';
		if (!empty($contract->data->customer_infor->customer_BOD)) {
			$dobArray = explode('-', $contract->data->customer_infor->customer_BOD);
			$customerDOB = $dobArray[2] . '/' . $dobArray[1] . '/' . $dobArray[0];
		}
		$customerPhone = '';
		if (!empty($contract->data->customer_infor->customer_phone_number)) {
			$customerPhone = $contract->data->customer_infor->customer_phone_number;
		}
		// var_dump($contract->data->store->id); die;
		$store = $this->api->apiPost($this->userInfo['token'], "store/get_store", array('id' => $contract->data->store->id));
		if (!empty($store->status) && $store->status == 200) {
			$this->data['store'] = $store->data;
		} else {
			$this->data['store'] = array();
		}
		$storeAddress = '';
		if (!empty($contract->data->store->address)) {
			$storeAddress = $contract->data->store->address;
		}
		$codeContract = '';
		if (!empty($contract->data->code_contract_disbursement)) {
			$codeContract = $contract->data->code_contract_disbursement;
		}
        $amount_payment=0;
        $ngay_qua_han=0;
        $ky_thanh_toan=0;
		$paymentData = $this->api->apiPost($this->userInfo['token'], "payment/get_payment_all_contract", array('id' => $data['id'],'date_pay'=>date('Y-m-d')));
		if (!empty($paymentData->status) && $paymentData->status == 200) {
			 $amount_payment= (int)$paymentData->tong_tien_thanh_toan;
			 $ky_thanh_toan= (int)$paymentData->contractDB->ky_thanh_toan;
		} 
        if (!empty($contract->data->debt->so_ngay_cham_tra)) {
			$ngay_qua_han = $contract->data->debt->so_ngay_cham_tra;
		}
		$this->data['ky_thanh_toan']=$ky_thanh_toan;
		 $this->data['ngay_qua_han']=$ngay_qua_han;
	   $this->data['amount_payment']=$amount_payment;
		$pgd_dong_bac = $this->api->apiPost($this->userInfo['token'], "tcv_dong_bac/get_store_tcv_dong_bac");
		$id_pgd_dong_bac = explode(' ', $pgd_dong_bac->id_store);
		$this->data['contract'] = $contract->data;
		$this->data['money'] = $money;
		$this->data['bank_name'] = $bank_name;
		$this->data['address'] = $address;
		$this->data['address_house'] = $address_house;
		$this->data['sokhung'] = $sokhung;
		$this->data['somay'] = $somay;
		$this->data['nhanhieu'] = $nhanhieu;
		$this->data['model'] = $model;
		$this->data['chuxe'] = $chuxe;
		$this->data['diachidangky'] = $diachidangky;
		$this->data['sodangky'] = $sodangky;
		$this->data['ngaycapdangky'] = $ngaycapdangky;
		$this->data['bienkiemsoat'] = $bienkiemsoat;
		$this->data['customerDOB'] = $customerDOB;
		$this->data['customerPhone'] = $customerPhone;
		$this->data['storeAddress'] = $storeAddress;
		$this->data['code_contract'] = $codeContract;
		$this->data['company_name'] = $company_name;
		$this->data['company_address'] = $company_address;
		$this->data['logs'] = $logs;
		$this->data['role'] = $role;
		$this->data['bank_name_nganluong'] = $bank_name_nganluong;

		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		if (in_array($contract->data->store->id, $id_pgd_dong_bac)) {
			$this->load->view('thn_printed/printed_thong_bao_no', isset($this->data) ? $this->data : NULL);
		} else {
			$this->load->view('thn_printed/printed_thong_bao_no', isset($this->data) ? $this->data : NULL);
		}
		return;
	}
	private function pushJson($code, $data)
	{
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}

	public function index_cvkd(){

		$data = [];
		$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all", array());


		if (!empty($storeData->status) && $storeData->status == 200) {

			$this->data['stores'] = $storeData->data;
		} else {
			$this->data['stores'] = array();
		}


		$this->data['template'] = 'page/pawn/export_du_no';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function index_cvkd_search(){

		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";


		$data = array();
		if (!empty($store)) $data['store'] = $store;
		if (!empty($fdate)) $data['fdate'] = $fdate;
		if (!empty($tdate)) $data['tdate'] = $tdate;


		$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all", array());

		$countContractData = $this->api->apiPost($this->userInfo['token'], "contract/exportContract_bucket_count", $data);

		if (!empty($countContractData->status) && $countContractData->status == 200 && $countContractData->data != 0) {

			$count = (int)$countContractData->data;
			$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
			$config = $this->config->item('pagination');
			$config['base_url'] = base_url('contract/index_cvkd_search?store=' . $store . '&fdate=' . $fdate . '&tdate=' . $tdate);
			$config['total_rows'] = $count;
			$config['per_page'] = 30;
			$config['page_query_string'] = true;
			$config['uri_segment'] = $uriSegment;
			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();
			$this->data['countContract'] = $count;

			$data['per_page'] = $config['per_page'];
			$data['uriSegment'] = $config['uri_segment'];

			$contractData = $this->api->apiPost($this->userInfo['token'], "contract/exportContract_bucket", $data);

			if (!empty($contractData->status) && $contractData->status == 200) {

				$this->data['contractData'] = $contractData->data;
				$this->data['count'] = $contractData->count;
				$this->data['total_du_no_dang_cho_vay'] = $contractData->total_du_no_dang_cho_vay;
				$this->data['total_du_no_qua_han_t10'] = $contractData->total_du_no_qua_han_t10;
				$this->data['total_du_no_trong_t10'] = $contractData->total_du_no_trong_t10;
			} else {
				$this->data['contractData'] = array();
				$this->data['count'] = [];
			}


		} else {
			$this->data['contractData'] = array();
		}


		if (!empty($storeData->status) && $storeData->status == 200) {

			$this->data['stores'] = $storeData->data;
		} else {
			$this->data['stores'] = array();
		}


		$this->data['template'] = 'page/pawn/export_du_no';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);


	}

}

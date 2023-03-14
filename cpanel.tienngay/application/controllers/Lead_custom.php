<?php

class Lead_custom extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("time_model");
		$this->load->model("province_model");
		$this->load->model("reason_model");
		$this->load->model("main_property_model");
		$this->load->helper('lead_helper');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->config->load('config');
		$this->load->library('pagination');
		$this->load->helper('location_helper');
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
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	public function displayUpdate()
	{
		$id = $this->security->xss_clean($_GET['id']);
		$condition = array(
			"id" => $id
		);

		$cskhData = $this->api->apiPost($this->user['token'], "lead_custom/get_cskh");
		if (!empty($cskhData->status) && $cskhData->status == 200) {
			$this->data['cskhData'] = $cskhData->data;
		} else {
			$this->data['cskhData'] = array();
		}
		$recordingData = $this->api->apiPost($this->user['token'], "recording/get_all");
		if (!empty($recordingData->status) && $recordingData->status == 200) {
			$this->data['recordingData'] = $recordingData->data;
		} else {
			$this->data['recordingData'] = array();
		}
		$provinces = $this->api->apiPost($this->user['token'], "province/get_province");
		if (!empty($provinces->status) && $provinces->status == 200) {
			$this->data['provinces'] = $provinces->data;
		} else {
			$this->data['provinces'] = array();
		}
		$storeData = $this->api->apiPost($this->user['token'], "store/get_all", []);
		if (!empty($storeData->status) && $storeData->status == 200) {
			$this->data['storeData'] = $storeData->data;
		} else {
			$this->data['storeData'] = array();
		}
		$leads = $this->api->apiPost($this->user['token'], "lead_admin/get_one", $condition);
		$main_property = $this->main_property_model->find();

		$this->data['storeData'] = $storeData->data;

		$this->data['lead_type_finance'] = lead_type_finance();

		//var_dump($this->data['lead_type_finance']);die();
		$this->data['provinces'] = $provinces->data;
		$this->data['reason'] = reason();
		$this->data['mainPropertyData'] = $main_property;
		$this->data['lead'] = $leads->data;
		$this->data['template'] = 'page/lead/lead_detail';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function return_cskh()
	{
		$data = array();


		$id = !empty($_GET['id']) ? $_GET['id'] : '';

		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		if (empty($id)) {

			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Bạn chưa chọn lead"
			];
			echo json_encode($response);
			return;
		}
		$data = array(
			"id" => $id,
			"status_pgd" => '8',
			"updated_at" => $updateAt,
			"updated_by" => $this->userInfo['email']
		);
		$return = $this->api->apiPost($this->user['token'], "lead_custom/update_status_pgd", $data);
		if (!empty($return->status) && $return->status == '200') {
			$response = [
				'res' => true,
				'status' => "200",
				'msg' => 'Cập nhật  thành công',
				'url' => $return->url
			];
			$this->pushJson('200', json_encode($response));
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => 'Cập nhật không thành công',
				'data' => $return
			];
			$this->pushJson('200', json_encode($response));
			return;
		}


	}

	public function mkt_report_general()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$source = !empty($_GET['source']) ? $_GET['source'] : "";
		$utm_source = !empty($_GET['utm_source']) ? $_GET['utm_source'] : "";
		$utm_campaign = !empty($_GET['utm_campaign']) ? $_GET['utm_campaign'] : "";
		$code_store = array();
		$url_code_store = "";
		if (is_array($_GET['code_store'])) {
			foreach ($_GET['code_store'] as $code) {
				array_push($code_store, $code);
				$url_code_store .= '&code_store[]=' . $code;
			}
		}
		$area = !empty($_GET['area']) ? $_GET['area'] : "";
		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('lead_custom/mkt_report_general'));
		}
		$cond = array();
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$cond = array(
				"start" => $start,
				"end" => $end,
			);
		}
		if (!empty($source)) {
			$cond['source'] = $source;
		}
		if (!empty($utm_source)) {
			$cond['utm_source'] = $utm_source;
		}
		if (!empty($utm_campaign)) {
			$cond['utm_campaign'] = $utm_campaign;
		}
		if (!empty($code_store)) {
			$cond['code_store'] = $code_store;
		}
		if (!empty($area)) {
			$cond['area'] = $area;
		}
		//var_dump($this->user['token']); die;


		$cskhData = $this->api->apiPost($this->user['token'], "lead_custom/search_mkt_general", $cond);
		if (!empty($cskhData->status) && $cskhData->status == 200) {
			$this->data['mktData'] = $cskhData->data;
		} else {
			$this->data['mktData'] = array();
		}

		$storeData = $this->api->apiPost($this->user['token'], "store/get_all", []);
		if (!empty($storeData->status) && $storeData->status == 200) {
			$this->data['storeData'] = $storeData->data;
		} else {
			$this->data['storeData'] = array();
		}
		$provinces = $this->api->apiPost($this->user['token'], "province/get_province");
		if (!empty($provinces->status) && $provinces->status == 200) {
			$this->data['provinces'] = $provinces->data;
		} else {
			$this->data['provinces'] = array();
		}
		$this->data['store'] = (isset($_GET['code_store'])) ? $_GET['code_store'] : '';
		$this->data['storeData'] = $storeData->data;

		$this->data['lead_type_finance'] = lead_type_finance();

		//var_dump($this->data['lead_type_finance']);die();
		$this->data['provinces'] = $provinces->data;
		$this->data['reason'] = reason();
		$this->data['mainPropertyData'] = $main_property;

		$this->data['template'] = 'page/lead/mkt/report_general';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function mkt_lead_cancel_static()
	{

		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : date("Y-m-d");
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : date("Y-m-d");
		$source = !empty($_GET['source']) ? $_GET['source'] : "";
		$utm_source = !empty($_GET['utm_source']) ? $_GET['utm_source'] : "";
		$utm_campaign = !empty($_GET['utm_campaign']) ? $_GET['utm_campaign'] : "";
		$code_store = array();
		$url_code_store = "";
		if (is_array($_GET['code_store'])) {
			foreach ($_GET['code_store'] as $code) {
				array_push($code_store, $code);
				$url_code_store .= '&code_store[]=' . $code;
			}
		}
		$area = !empty($_GET['area']) ? $_GET['area'] : "";
		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('lead_custom/mkt_lead_cancel_static'));
		}
		$cond = array();
		if (!empty($start) && !empty($end)) {
			$cond = array(
				"start" => $start,
				"end" => $end,
			);
		}
		if (!empty($source)) {
			$cond['source'] = $source;
		}
		if (!empty($utm_source)) {
			$cond['utm_source'] = $utm_source;
		}
		if (!empty($utm_campaign)) {
			$cond['utm_campaign'] = $utm_campaign;
		}
		if (!empty($code_store)) {
			$cond['code_store'] = $code_store;
		}

		if (!empty($area)) {
			$cond['area'] = $area;
		}
		//var_dump($this->user['token']); die;
		$cskhData = $this->api->apiPost($this->user['token'], "lead_custom/mkt_lead_cancel_static", $cond);
		if (!empty($cskhData->status) && $cskhData->status == 200) {
			$this->data['mktData'] = $cskhData->data;
			$this->data['mktData_q'] = $cskhData->data_q;
		} else {
			$this->data['mktData'] = array();
			$this->data['mktData_q'] = array();
		}

		$storeData = $this->api->apiPost($this->user['token'], "store/get_all", []);
		if (!empty($storeData->status) && $storeData->status == 200) {
			$this->data['storeData'] = $storeData->data;
		} else {
			$this->data['storeData'] = array();
		}
		$provinces = $this->api->apiPost($this->user['token'], "province/get_province");
		if (!empty($provinces->status) && $provinces->status == 200) {
			$this->data['provinces'] = $provinces->data;
		} else {
			$this->data['provinces'] = array();
		}
		$this->data['store'] = (isset($_GET['code_store'])) ? $_GET['code_store'] : '';
		$this->data['storeData'] = $storeData->data;

		$this->data['lead_type_finance'] = lead_type_finance();

		//var_dump($this->data['lead_type_finance']);die();
		$this->data['provinces'] = $provinces->data;
		$this->data['reason'] = reason();
		$this->data['mainPropertyData'] = $main_property;

		$this->data['template'] = 'page/lead/mkt/lead_cancel_static';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function mkt_lead_cancel()
	{
		$code_store = array();
		$url_code_store = "";
		if (is_array($_GET['code_store'])) {
			foreach ($_GET['code_store'] as $code) {
				array_push($code_store, $code);
				$url_code_store .= '&code_store[]=' . $code;
			}
		}
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : date("Y-m-d");
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : date("Y-m-d");
		$source = !empty($_GET['source']) ? $_GET['source'] : "";
		$utm_source = !empty($_GET['utm_source']) ? $_GET['utm_source'] : "";
		$utm_campaign = !empty($_GET['utm_campaign']) ? $_GET['utm_campaign'] : "";

		$area = !empty($_GET['area']) ? $_GET['area'] : "";
		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('lead_custom/mkt_lead_cancel'));
		}
		$cond = array();
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$cond = array(
				"start" => $start,
				"end" => $end,
			);
		}
		if (!empty($source)) {
			$cond['source'] = $source;
		}
		if (!empty($utm_source)) {
			$cond['utm_source'] = $utm_source;
		}
		if (!empty($utm_campaign)) {
			$cond['utm_campaign'] = $utm_campaign;
		}
		if (!empty($code_store)) {
			$cond['code_store'] = $code_store;
		}
		if (!empty($area)) {
			$cond['area'] = $area;
		}

		$cskhData = $this->api->apiPost($this->user['token'], "lead_custom/mkt_lead_cancel", $cond);
		if (!empty($cskhData->status) && $cskhData->status == 200) {
			$this->data['mktData'] = $cskhData->data;
			$this->data['mktData_q'] = $cskhData->data_q;
		} else {
			$this->data['mktData'] = array();
			$this->data['mktData_q'] = array();
		}

		$storeData = $this->api->apiPost($this->user['token'], "store/get_all", []);
		if (!empty($storeData->status) && $storeData->status == 200) {
			$this->data['storeData'] = $storeData->data;
		} else {
			$this->data['storeData'] = array();
		}
		$provinces = $this->api->apiPost($this->user['token'], "province/get_province");
		if (!empty($provinces->status) && $provinces->status == 200) {
			$this->data['provinces'] = $provinces->data;
		} else {
			$this->data['provinces'] = array();
		}
		$this->data['store'] = (isset($_GET['code_store'])) ? $_GET['code_store'] : '';
		$this->data['storeData'] = $storeData->data;

		$this->data['lead_type_finance'] = lead_type_finance();

		//var_dump($this->data['lead_type_finance']);die();
		$this->data['provinces'] = $provinces->data;
		$this->data['reason'] = reason();
//		$this->data['mainPropertyData'] = $main_property;

		$this->data['template'] = 'page/lead/mkt/lead_cancel';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function mkt_lead_full_info_digital()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$source = !empty($_GET['source']) ? $_GET['source'] : "";
		$utm_source = !empty($_GET['utm_source']) ? $_GET['utm_source'] : "";
		$utm_campaign = !empty($_GET['utm_campaign']) ? $_GET['utm_campaign'] : "";
		$code_store = array();
		$url_code_store = "";
		if (is_array($_GET['code_store'])) {
			foreach ($_GET['code_store'] as $code) {
				array_push($code_store, $code);
				$url_code_store .= '&code_store[]=' . $code;
			}
		}
		$area = !empty($_GET['area']) ? $_GET['area'] : "";
		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('lead_custom/mkt_lead_full_info_digital'));
		}
		$cond = array();
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$cond = array(
				"start" => $start,
				"end" => $end,
			);
		}
		if (!empty($source)) {
			$cond['source'] = $source;
		}
		if (!empty($utm_source)) {
			$cond['utm_source'] = $utm_source;
		}
		if (!empty($utm_campaign)) {
			$cond['utm_campaign'] = $utm_campaign;
		}
		if (!empty($code_store)) {
			$cond['code_store'] = $code_store;
		}
		if (!empty($area)) {
			$cond['area'] = $area;
		}
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 30;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$cond['per_page'] = $config['per_page'];
		$cond['uriSegment'] = $config['uri_segment'];
		$config['base_url'] = base_url('lead_custom/mkt_lead_full_info_digital?fdate=' . $start . '&tdate=' . $end . $url_code_store . '&area=' . $area . '&utm_source=' . $utm_source . '&utm_campaign=' . $utm_campaign);
		$cskhData = $this->api->apiPost($this->user['token'], "lead_custom/mkt_lead_full_info_digital", $cond);
		if (!empty($cskhData->status) && $cskhData->status == 200) {
			$this->data['mktData'] = $cskhData->data;
			$config['total_rows'] = $cskhData->total;
		} else {
			$this->data['mktData'] = array();
		}

		$storeData = $this->api->apiPost($this->user['token'], "store/get_all", []);
		if (!empty($storeData->status) && $storeData->status == 200) {
			$this->data['storeData'] = $storeData->data;
		} else {
			$this->data['storeData'] = array();
		}

		$provinces = $this->api->apiPost($this->user['token'], "province/get_province");
		if (!empty($provinces->status) && $provinces->status == 200) {
			$this->data['provinces'] = $provinces->data;
		} else {
			$this->data['provinces'] = array();
		}

		$main_property = $this->main_property_model->find();
		$this->data['store'] = (isset($_GET['code_store'])) ? $_GET['code_store'] : '';
		$this->data['storeData'] = $storeData->data;

		$this->data['lead_type_finance'] = lead_type_finance();

		$this->pagination->initialize($config);

		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['result_count'] = "Hiển thị " . $config['total_rows'] . " Kết quả";
		$this->data['provinces'] = $provinces->data;
		$this->data['reason'] = reason();
		$this->data['mainPropertyData'] = $main_property;

		$this->data['template'] = 'page/lead/mkt/lead_full_info_digital';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function mkt_list_transfe_office()
	{
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$cond = array(
			"per_page" => $config['per_page'],
			"uriSegment" => $config['uri_segment'],
		);
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$utm_source = !empty($_GET['utm_source']) ? $_GET['utm_source'] : "";
		$utm_campaign = !empty($_GET['utm_campaign']) ? $_GET['utm_campaign'] : "";
		$phone_number = !empty($_GET['phone_number']) ? $_GET['phone_number'] : "";
		$area = !empty($_GET['area']) ? $_GET['area'] : "";
		$status_sale = !empty($_GET['status_sale']) ? $_GET['status_sale'] : "";
		$status_pgd = !empty($_GET['status_pgd']) ? $_GET['status_pgd'] : "";
		$area_search = !empty($_GET['area_search']) ? $_GET['area_search'] : "";
		$code_store = array();
		$url_code_store = "";
		if (is_array($_GET['code_store'])) {
			foreach ($_GET['code_store'] as $code) {
				array_push($code_store, $code);
				$url_code_store .= '&code_store[]=' . $code;
			}
		}
		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('lead_custom/mkt_list_transfe_office'));
		}

		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {

			$cond['start'] = $start;
			$cond['end'] = $end;

		}
		if (!empty($status_sale)) {
			$cond['status_sale'] = $status_sale;
		}
		if (!empty($status_pgd)) {
			$cond['status_pgd'] = $status_pgd;
		}
		if (!empty($area)) {
			$cond['area'] = $area;
		}
		if (!empty($code_store)) {
			$cond['code_store'] = $code_store;
		}
		if (!empty($utm_source)) {
			$cond['utm_source'] = $utm_source;
		}
		if (!empty($utm_campaign)) {
			$cond['utm_campaign'] = $utm_campaign;
		}
		if (!empty($phone_number)) {
			$cond['phone_number'] = $phone_number;
		}
		if (!empty($area_search)) {
			$cond['area_search'] = $area_search;
		}
		$provinces = $this->api->apiPost($this->user['token'], "province/get_province");
		if (!empty($provinces->status) && $provinces->status == 200) {
			$this->data['provinces'] = $provinces->data;
		} else {
			$this->data['provinces'] = array();
		}
		//var_dump($cond); die;

		$config['base_url'] = base_url('lead_custom/mkt_list_transfe_office?&fdate=' . $start . '&tdate=' . $end . $url_code_store . '&area=' . $area . '&utm_source=' . $utm_source . '&utm_campaign=' . $utm_campaign . '&phone_number=' . $phone_number . '&status_pgd=' . $status_pgd . '&area_search=' . $area_search);

		$leadsData = $this->api->apiPost($this->user['token'], "lead_custom/get_lead_mkt", $cond);

		foreach ($leadsData->data as $lead) {
			$data_1['phone'] = $lead->phone_number;
			unset($checkContract->data[0]->_id->{'$oid'});
			$checkContract = $this->api->apiPost($this->userInfo['token'], "contract/search_phone", $data_1);

			if (!empty($checkContract->data) && $checkContract->status == 200) {
				if (!empty($checkContract->data[0]->status)) {
					foreach (contract_status() as $key => $item) {
						if ($key == $checkContract->data[0]->status) {
							$lead->status_lead = $item;
							$lead->id_contract_1 = $checkContract->data[0]->_id->{'$oid'};
						}
					}
				}
			}
		}


		if (!empty($leadsData->status) && $leadsData->status == 200) {
			$this->data['leadsData'] = $leadsData->data;
			$this->data['groupRoles'] = $leadsData->groupRoles;
			$this->data['stores'] = $leadsData->stores;
			$this->data['leadTotalMkt'] = $leadsData->leadTotalMkt;
			$this->data['leadTotalMkt1'] = $leadsData->leadTotalMkt1;

			//var_dump($this->data['stores']); die;
			$config['total_rows'] = $leadsData->total;

		} else {
			$this->data['leadsData'] = array();
		}

		$reasonData = $this->api->apiPost($this->user['token'], "reason/get_all", []);
		if (!empty($reasonData->data) && $reasonData->status == 200) {
			$this->data['reasonData'] = $reasonData->data;
		} else {
			$this->data['reasonData'] = array();
		}
		$this->pagination->initialize($config);

		$getArea = $this->api->apiPost($this->user['token'], "area/get_all_area_active");
		if (!empty($getArea->data) && $getArea->status == 200) {
			$this->data['getArea'] = $getArea->data;
		} else {
			$this->data['getArea'] = array();
		}

		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['result_count'] = "Hiển thị " . $config['total_rows'] . " Kết quả";
		$cskhData = $this->api->apiPost($this->user['token'], "lead_custom/get_cskh");
		//var_dump($cskhData); die;
		if (!empty($cskhData->status) && $cskhData->status == 200) {
			$this->data['cskhData'] = $cskhData->data;
		} else {
			$this->data['cskhData'] = array();
		}

		$storeData = $this->api->apiPost($this->user['token'], "store/get_all", []);
		if (!empty($storeData->status) && $storeData->status == 200) {
			$this->data['storeData'] = $storeData->data;

		} else {
			$this->data['storeData'] = array();
		}
		$cond = array(
			"id" => '5df09734d6612be6b43ccda8'
		);
//          $cskh = $this->api->apiPost1($this->user['token'], "user/detail", $cond);
//          var_dump($cskh);die();

		$main_property = $this->main_property_model->find();
		$this->data['leads'] = $leadsData->data;
		$this->data['storeData'] = $storeData->data;

		$this->data['lead_type_finance'] = lead_type_finance();
		//var_dump($this->data['lead_type_finance']);die();
		$this->data['mainPropertyData'] = $main_property;
		$this->data['reason'] = reason();
		$this->data['template'] = 'page/lead/mkt/list_transfe_office';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}


	public function lead_daily()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";

		$cond = array();
		if (!empty($_GET['fdate'])) {
			$cond = array(
				"start" => $start,
				"end" => $start,
			);
		}

		$cskhData = $this->api->apiPost($this->user['token'], "lead_custom/lead_daily", $cond);
		if (!empty($cskhData->status) && $cskhData->status == 200) {
			$this->data['mktData'] = $cskhData->data;
		} else {
			$this->data['mktData'] = array();
		}

		$this->data['template'] = 'page/lead/report/daily';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function lead_cancel()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";

		$cond = array();
		if (!empty($_GET['fdate'])) {
			$cond = array(
				"start" => $start,
				"end" => $start,
			);
		}

		$cskhData = $this->api->apiPost($this->user['token'], "lead_custom/lead_cancel", $cond);
		if (!empty($cskhData->status) && $cskhData->status == 200) {
			$this->data['mktData'] = $cskhData->data;
		} else {
			$this->data['mktData'] = array();
		}

		$this->data['template'] = 'page/lead/report/lead_cancel';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function lead_tsl_daily()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";

		$cond = array();
		if (!empty($_GET['fdate'])) {
			$cond = array(
				"start" => $start,
				"end" => $start,
			);
		}

		$cskhData = $this->api->apiPost($this->user['token'], "lead_custom/lead_tsl_daily", $cond);
		if (!empty($cskhData->status) && $cskhData->status == 200) {
			$this->data['mktData'] = $cskhData->data;
		} else {
			$this->data['mktData'] = array();
		}

		$this->data['template'] = 'page/lead/report/tsl_daily';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function lead_call_statistics_daily()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('lead_custom/lead_call_statistics_daily'));
		}
		$cond = array();
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$cond = array(
				"start" => $start,
				"end" => $end,
			);
		}
		//  var_dump($cond); die;
		$cskhData = $this->api->apiPost($this->user['token'], "lead_custom/lead_call_statistics_daily", $cond);
		if (!empty($cskhData->status) && $cskhData->status == 200) {
			$this->data['mktData'] = $cskhData->data;
		} else {
			$this->data['mktData'] = array();
		}

		$this->data['template'] = 'page/lead/report/call_statistics_daily';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function mkt_lead_digital()
	{

		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$source = !empty($_GET['source']) ? $_GET['source'] : "";
		$utm_source = !empty($_GET['utm_source']) ? $_GET['utm_source'] : "";
		$utm_campaign = !empty($_GET['utm_campaign']) ? $_GET['utm_campaign'] : "";
		$url_code_store = "";
		$code_store = !empty($_GET['code_store']) ? $_GET['code_store'] : "";
		$area = !empty($_GET['area']) ? $_GET['area'] : "";
		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('lead_custom/mkt_lead_digital'));
		}
		$cond = array();
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$cond = array(
				"start" => $start,
				"end" => $end,
			);
		}
		if (!empty($source)) {
			$cond['source'] = $source;
		}
		if (!empty($utm_source)) {
			$cond['utm_source'] = $utm_source;
		}
		if (!empty($utm_campaign)) {
			$cond['utm_campaign'] = $utm_campaign;
		}
		if (!empty($code_store)) {
			$cond['code_store'] = $code_store;
		}
		if (!empty($area)) {
			$cond['area'] = $area;
		}
		$cskhData = $this->api->apiPost($this->user['token'], "lead_custom/mkt_lead_digital", $cond);
		if (!empty($cskhData->status) && $cskhData->status == 200) {
			$this->data['mktData'] = $cskhData->data;
		} else {
			$this->data['mktData'] = array();
		}

		$storeData = $this->api->apiPost($this->user['token'], "store/get_all", []);
		if (!empty($storeData->status) && $storeData->status == 200) {
			$this->data['storeData'] = $storeData->data;
		} else {
			$this->data['storeData'] = array();
		}
		$provinces = $this->api->apiPost($this->user['token'], "province/get_province");
		if (!empty($provinces->status) && $provinces->status == 200) {
			$this->data['provinces'] = $provinces->data;
		} else {
			$this->data['provinces'] = array();
		}
		$this->data['store'] = (isset($_GET['code_store'])) ? $_GET['code_store'] : '';
		$this->data['storeData'] = $storeData->data;

		$this->data['lead_type_finance'] = lead_type_finance();
		//var_dump($this->data['lead_type_finance']);die();
		$this->data['provinces'] = $provinces->data;
		$this->data['reason'] = reason();
		$this->data['mainPropertyData'] = $main_property;

		$this->data['template'] = 'page/lead/mkt/lead_digital';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function historyCall()
	{

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;

		$userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$sdt = !empty($_GET['sdt']) ? $_GET['sdt'] : "";
		$email_nv = !empty($_GET['email_nv']) ? trim($_GET['email_nv']) : "";
		$user_name = !empty($_GET['user_name']) ? trim($_GET['user_name']) : "";
		$phone_name = !empty($_GET['phone_name']) ? trim($_GET['phone_name']) : "";

		$stores = !empty($userInfo['stores']) ? $userInfo['stores'] : array();
		$email = !empty($userInfo['email']) ? $userInfo['email'] : "";
		$userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";

		//get store
		$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all", array());
		$arr_store = array();
		$arr_store_hotline = array();
		if (!empty($storeData->status) && $storeData->status == 200 && !empty($stores)) {
			foreach ($stores as $key => $store) {
				array_push($arr_store, $store->store_id);
			}
			foreach ($storeData->data as $key => $value) {
				if ($value->status != 'active' || !in_array($value->_id->{'$oid'}, $arr_store)) {
					unset($storeData->data[$key]);

				} else {
					if (!empty($value->phone_hotline))
						array_push($arr_store_hotline, $value->phone_hotline);
				}

			}

		}
		//if ((!empty($start) && !empty($end)) || !empty($cskh) || !empty($sdt))
		$config['base_url'] = base_url('lead_custom/historyCall') . '?fdate=' . $start . '&tdate=' . $end . '&sdt=' . $sdt . '&email_nv=' . $email_nv . '&user_name=' . $user_name . '&phone_name=' . $phone_name;
		$data = array(
			"per_page" => $config['per_page'],
			"uriSegment" => $config['uri_segment'],
			"email" => $email,
			"start" => $start,
			"end" => $end,
			"sdt" => $sdt,
			"email_nv" => $email_nv,
			"arr_store_hotline" => $arr_store_hotline,
			"phone_name" => $phone_name,
			"user_name" => $user_name,


		);
		//var_dump($data ); die;
		$recordingData = $this->api->apiPost($this->user['token'], "recording/get_all", $data);

		if (!empty($recordingData->status) && $recordingData->status == 200) {
			$this->data['recordingData'] = $recordingData->data;
			$config['total_rows'] = $recordingData->count;
		} else {
			$this->data['recordingData'] = array();
		}


//		$list_gdv = $this->api->apiPost($this->userInfo['token'], "exportExcel/get_user_cskh");
//
//		if (!empty($list_gdv->status) && $list_gdv->status == 200) {
//			$this->data['list_cskh'] = $list_gdv->data;
//		} else {
//			$this->data['list_cskh'] = array();
//		}


		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}


		$this->pagination->initialize($config);
		$this->data['result_count'] = "Hiển thị " . $config['total_rows'] . " Kết quả";
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/lead/lead_history';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function historyCall_all()
	{
		$cskhData = $this->api->apiPost($this->user['token'], "lead_custom/get_user");
		if (!empty($cskhData->status) && $cskhData->status == 200) {
			$this->data['cskhData'] = $cskhData->data;
		} else {
			$this->data['cskhData'] = array();
		}
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;

		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$cskh = !empty($_GET['cskh']) ? $_GET['cskh'] : "";
		$sdt = !empty($_GET['sdt']) ? $_GET['sdt'] : "";

		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('lead_custom/historyCall_all');
		if ((!empty($start) && !empty($end)) || !empty($cskh) || !empty($sdt))
			$config['base_url'] = base_url('lead_custom/historyCall_all') . '?fdate=' . $start . '&tdate=' . $end . '&cskh=' . $cskh . '&sdt=' . $sdt;

		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;

		$data = array(
			"per_page" => $config['per_page'],
			"uriSegment" => $config['uri_segment'],
			"start" => $start,
			"end" => $end,
			"cskh" => $cskh,
			"sdt" => $sdt,


		);
		//var_dump($data ); die;
		$recordingData = $this->api->apiPost($this->user['token'], "recording/get_all", $data);
		if (!empty($recordingData->status) && $recordingData->status == 200) {
			$this->data['recordingData'] = $recordingData->data;
			$config['total_rows'] = $recordingData->count;
			$config['groupRoles'] = $recordingData->groupRoles;
		} else {
			$this->data['recordingData'] = array();
		}
		$this->pagination->initialize($config);

		$this->data['pagination'] = $this->pagination->create_links();
		// call api get contract data


		$this->data['result_count'] = "Hiển thị " . $config['total_rows'] . " Kết quả";


		$this->data['template'] = 'page/lead/lead_history_all';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function historyCall_Missed()
	{
		$cskhData = $this->api->apiPost($this->user['token'], "lead_custom/get_user");
		if (!empty($cskhData->status) && $cskhData->status == 200) {
			$this->data['cskhData'] = $cskhData->data;
		} else {
			$this->data['cskhData'] = array();
		}
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;

		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$cskh = !empty($_GET['cskh']) ? $_GET['cskh'] : "";
		$sdt = !empty($_GET['sdt']) ? $_GET['sdt'] : "";

		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('lead_custom/historyCall_all');
		if ((!empty($start) && !empty($end)) || !empty($cskh) || !empty($sdt))
			$config['base_url'] = base_url('lead_custom/historyCall_all') . '?fdate=' . $start . '&tdate=' . $end . '&cskh=' . $cskh . '&sdt=' . $sdt;

		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
		$stores = !empty($userInfo['stores']) ? $userInfo['stores'] : array();
		$data = array(
			"per_page" => $config['per_page'],
			"uriSegment" => $config['uri_segment'],
			"start" => $start,
			"end" => $end,
			"cskh" => $cskh,
			"sdt" => $sdt,
			"missed" => 'ok',

		);
		//var_dump($data ); die;
		$recordingData = $this->api->apiPost($this->user['token'], "recording/get_all", $data);
		if (!empty($recordingData->status) && $recordingData->status == 200) {
			$this->data['recordingData'] = $recordingData->data;
			$config['total_rows'] = $recordingData->count;
		} else {
			$this->data['recordingData'] = array();
		}
		$this->pagination->initialize($config);

		$this->data['pagination'] = $this->pagination->create_links();
		// call api get contract data


		$this->data['result_count'] = "Hiển thị " . $config['total_rows'] . " Kết quả";


		$this->data['template'] = 'page/lead/lead_history_missed';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function index()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$sdt = !empty($_GET['sdt']) ? $_GET['sdt'] : "";
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "";
		$source = !empty($_GET['source_s']) ? $_GET['source_s'] : "";
		$fullname = !empty($_GET['fullname']) ? $_GET['fullname'] : "";
		$cskh = !empty($_GET['cskh']) ? $_GET['cskh'] : "";
		$status_sale = !empty($_GET['status_sale_1']) ? $_GET['status_sale_1'] : "";
		$priority = !empty($_GET['priority']) ? $_GET['priority'] : "";

		if ((strtotime($start) > strtotime($end)) && !empty($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_date'));
			// redirect(base_url('lead_custom?tab=' .$tab));
		}
		$cond = array();
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$cond = array(
				"start" => $start,
				"end" => $end,
			);
		} elseif (!empty($_GET['fdate'])) {
			$cond = [
				'start' => $start,
			];
		} elseif (!empty($_GET['tdate'])) {
			$cond = [
				'end' => $end
			];
		}
		if (!empty($_GET['sdt'])) {
			$cond['sdt'] = $sdt;
		}
		if (!empty($_GET['source_s'])) {
			$cond['source'] = $source;
		}
		if (!empty($_GET['fullname'])) {
			$cond['fullname'] = $fullname;
		}
		if (!empty($_GET['cskh'])) {
			$cond['cskh'] = $cskh;
		}
		if (!empty($_GET['status_sale_1'])) {
			$cond['status_sale'] = $status_sale;
		}
		if (!empty($_GET['priority'])) {
			$cond['priority'] = $priority ;
		}

		// $count = $total->data;
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination', '', 'pagination1');
		$this->load->library('pagination', '', 'pagination2');
		$this->load->library('pagination', '', 'pagination3');
		$this->load->library('pagination', '', 'pagination4');
		$this->load->library('pagination', '', 'pagination5');
		$this->load->library('pagination', '', 'pagination6');
		$this->load->library('pagination', '', 'pagination10');
		$this->load->library('pagination', '', 'pagination11');
		$this->load->library('pagination', '', 'pagination12');
		$this->load->library('pagination', '', 'pagination13');
		$this->load->library('pagination', '', 'pagination14');
		$this->load->library('pagination', '', 'pagination20');

		$config1 = $this->config->item('pagination1');
		$config2 = $this->config->item('pagination2');
		$config3 = $this->config->item('pagination3');
		$config4 = $this->config->item('pagination4');
		$config5 = $this->config->item('pagination5');
		$config6 = $this->config->item('pagination6');
		$config10 = $this->config->item('pagination10');
		$config11 = $this->config->item('pagination11');
		$config12 = $this->config->item('pagination12');
		$config13 = $this->config->item('pagination13');
		$config14 = $this->config->item('pagination14');
		$config16 = $this->config->item('pagination14');
		$config20 = $this->config->item('pagination20');


		$config1['base_url'] = base_url('lead_custom?tab=1&fdate=' . $start . '&tdate=' . $end . '&sdt=' . $sdt . '&fullname=' . $fullname . '&cskh=' . $cskh . '&source_s=' . $source . '&status_sale_1=' . $status_sale . '&priority=' . $priority);
		$config2['base_url'] = base_url('lead_custom?tab=2&fdate=' . $start . '&tdate=' . $end . '&sdt=' . $sdt . '&fullname=' . $fullname . '&cskh=' . $cskh . '&source_s=' . $source . '&status_sale_1=' . $status_sale . '&priority=' . $priority);
		$config3['base_url'] = base_url('lead_custom?tab=3&fdate=' . $start . '&tdate=' . $end . '&sdt=' . $sdt . '&fullname=' . $fullname . '&cskh=' . $cskh . '&source_s=' . $source . '&status_sale_1=' . $status_sale . '&priority=' . $priority);
		$config4['base_url'] = base_url('lead_custom?tab=4&fdate=' . $start . '&tdate=' . $end . '&sdt=' . $sdt . '&fullname=' . $fullname . '&cskh=' . $cskh . '&source_s=' . $source . '&status_sale_1=' . $status_sale . '&priority=' . $priority);
		$config5['base_url'] = base_url('lead_custom?tab=5&fdate=' . $start . '&tdate=' . $end . '&sdt=' . $sdt . '&fullname=' . $fullname . '&cskh=' . $cskh . '&source_s=' . $source . '&status_sale_1=' . $status_sale . '&priority=' . $priority);
		$config6['base_url'] = base_url('lead_custom?tab=6&fdate=' . $start . '&tdate=' . $end . '&sdt=' . $sdt . '&fullname=' . $fullname . '&cskh=' . $cskh . '&source_s=' . $source . '&status_sale_1=' . $status_sale . '&priority=' . $priority);
		$config10['base_url'] = base_url('lead_custom?tab=10&fdate=' . $start . '&tdate=' . $end . '&sdt=' . $sdt . '&fullname=' . $fullname . '&cskh=' . $cskh . '&source_s=' . $source . '&status_sale_1=' . $status_sale . '&priority=' . $priority);
		$config11['base_url'] = base_url('lead_custom?tab=11&fdate=' . $start . '&tdate=' . $end . '&sdt=' . $sdt . '&fullname=' . $fullname . '&cskh=' . $cskh . '&source_s=' . $source . '&status_sale_1=' . $status_sale . '&priority=' . $priority);
		$config12['base_url'] = base_url('lead_custom?tab=12&fdate=' . $start . '&tdate=' . $end . '&sdt=' . $sdt . '&fullname=' . $fullname . '&cskh=' . $cskh . '&source_s=' . $source . '&status_sale_1=' . $status_sale . '&priority=' . $priority);
		$config13['base_url'] = base_url('lead_custom?tab=13&fdate=' . $start . '&tdate=' . $end . '&sdt=' . $sdt . '&fullname=' . $fullname . '&cskh=' . $cskh . '&source_s=' . $source . '&status_sale_1=' . $status_sale . '&priority=' . $priority);
		$config14['base_url'] = base_url('lead_custom?tab=14&fdate=' . $start . '&tdate=' . $end . '&sdt=' . $sdt . '&fullname=' . $fullname . '&cskh=' . $cskh . '&source_s=' . $source . '&status_sale_1=' . $status_sale . '&priority=' . $priority);
		$config16['base_url'] = base_url('lead_custom?tab=14&fdate=' . $start . '&tdate=' . $end . '&sdt=' . $sdt . '&fullname=' . $fullname . '&cskh=' . $cskh . '&source_s=' . $source . '&status_sale_1=' . $status_sale . '&priority=' . $priority);
		$config20['base_url'] = base_url('lead_custom?tab=15&fdate=' . $start . '&tdate=' . $end . '&sdt=' . $sdt . '&fullname=' . $fullname . '&cskh=' . $cskh . '&source_s=' . $source . '&status_sale_1=' . $status_sale . '&priority=' . $priority);

		$config1['per_page'] = 20;
		$config2['per_page'] = 20;
		$config3['per_page'] = 20;
		$config4['per_page'] = 20;
		$config5['per_page'] = 20;
		$config6['per_page'] = 20;
		$config10['per_page'] = 20;
		$config11['per_page'] = 20;
		$config12['per_page'] = 20;
		$config13['per_page'] = 20;
		$config14['per_page'] = 20;
		$config16['per_page'] = 20;
		$config20['per_page'] = 20;

		$config1['enable_query_strings'] = true;
		$config2['enable_query_strings'] = true;
		$config3['enable_query_strings'] = true;
		$config4['enable_query_strings'] = true;
		$config5['enable_query_strings'] = true;
		$config6['enable_query_strings'] = true;
		$config10['enable_query_strings'] = true;
		$config11['enable_query_strings'] = true;
		$config12['enable_query_strings'] = true;
		$config13['enable_query_strings'] = true;
		$config16['enable_query_strings'] = true;
		$config20['enable_query_strings'] = true;

		$config1['page_query_string'] = true;
		$config2['page_query_string'] = true;
		$config3['page_query_string'] = true;
		$config4['page_query_string'] = true;
		$config5['page_query_string'] = true;
		$config6['page_query_string'] = true;
		$config10['page_query_string'] = true;
		$config11['page_query_string'] = true;
		$config12['page_query_string'] = true;
		$config13['page_query_string'] = true;
		$config16['page_query_string'] = true;
		$config20['page_query_string'] = true;

		$config1['uri_segment'] = $uriSegment;
		$config2['uri_segment'] = $uriSegment;
		$config3['uri_segment'] = $uriSegment;
		$config4['uri_segment'] = $uriSegment;
		$config5['uri_segment'] = $uriSegment;
		$config6['uri_segment'] = $uriSegment;
		$config10['uri_segment'] = $uriSegment;
		$config11['uri_segment'] = $uriSegment;
		$config12['uri_segment'] = $uriSegment;
		$config13['uri_segment'] = $uriSegment;
		$config16['uri_segment'] = $uriSegment;
		$config20['uri_segment'] = $uriSegment;

		// call api get contract data
		$data = array(
			"condition" => $cond,
			"per_page1" => $config1['per_page'],
			"uriSegment1" => $config1['uri_segment'],
			"per_page2" => $config1['per_page'],
			"uriSegment2" => $config1['uri_segment'],
			"per_page3" => $config1['per_page'],
			"uriSegment3" => $config1['uri_segment'],
			"per_page4" => $config1['per_page'],
			"uriSegment4" => $config1['uri_segment'],
			"per_page5" => $config1['per_page'],
			"uriSegment5" => $config1['uri_segment'],
			"per_page6" => $config1['per_page'],
			"uriSegment6" => $config1['uri_segment'],
			"per_page10" => $config1['per_page'],
			"uriSegment10" => $config1['uri_segment'],
			"per_page11" => $config1['per_page'],
			"uriSegment11" => $config1['uri_segment'],
			"per_page12" => $config1['per_page'],
			"uriSegment12" => $config1['uri_segment'],
			"uriSegment13" => $config13['uri_segment'],
			"per_page13" => $config1['per_page'],
			"uriSegment16" => $config16['uri_segment'],
			"per_page16" => $config16['per_page'],

		);

		$dataLeadVbee = [
			'condition' => $cond,
			"uriSegment20" => $config20['uri_segment'],
			"per_page20" => $config20['per_page'],
		];


		$leadsData = $this->api->apiPost($this->user['token'], "lead_custom/get_lead_pt", $data);

		$leadVbee = $this->api->apiPost($this->user['token'], "lead_custom/getLeadVbee", $dataLeadVbee);
		if (!empty($leadVbee->status) && $leadVbee->status == 200) {
			$this->data['leadVbee'] = $leadVbee->data;
			$config20['total_rows'] = $leadVbee->total;
		}
		foreach ($leadsData->data1 as $lead) {
			$data_1['phone'] = $lead->phone_number;
			unset($checkContract->data[0]->_id->{'$oid'});
			$checkContract = $this->api->apiPost($this->userInfo['token'], "contract/search_phone", $data_1);

			if (!empty($checkContract->data) && $checkContract->status == 200) {
				if (!empty($checkContract->data[0]->status)) {
					foreach (contract_status() as $key => $item) {
						if ($key == $checkContract->data[0]->status) {
							$lead->status_lead = $item;
							$lead->id_contract_1 = $checkContract->data[0]->_id->{'$oid'};
						}
					}
				}
			}
		}

		if (!empty($leadsData->status) && $leadsData->status == 200) {
			$this->data['leadsData1'] = $leadsData->data1;
			$this->data['leadsData2'] = $leadsData->data2;
			$this->data['leadsData3'] = $leadsData->data3;
			$this->data['leadsData4'] = $leadsData->data4;
			$this->data['leadsData5'] = $leadsData->data5;
			$this->data['leadsData6'] = $leadsData->data6;
			$this->data['leadsData10'] = $leadsData->data10;
			$this->data['leadsData11'] = $leadsData->data11;
			$this->data['leadsData12'] = $leadsData->data12;
			$this->data['leadsData13'] = $leadsData->data13;
			$this->data['leadsData14'] = $leadsData->data14;
			$this->data['leadsData16'] = $leadsData->data16;


			$config1['total_rows'] = $leadsData->total1;
			$config2['total_rows'] = $leadsData->total2;
			$config3['total_rows'] = $leadsData->total3;
			$config4['total_rows'] = $leadsData->total4;
			$config5['total_rows'] = $leadsData->total5;
			$config6['total_rows'] = $leadsData->total6;
			$config10['total_rows'] = $leadsData->total10;
			$config11['total_rows'] = $leadsData->total11;
			$config12['total_rows'] = $leadsData->total12;
			$config13['total_rows'] = $leadsData->total13;
			$config14['total_rows'] = $leadsData->total14;
			$config16['total_rows'] = $leadsData->total16;
			$this->data['groupRoles'] = $leadsData->groupRoles;
		} else {
			$this->data['leadsData1'] = array();
			$this->data['leadsData2'] = array();
			$this->data['leadsData3'] = array();
			$this->data['leadsData4'] = array();
			$this->data['leadsData5'] = array();
			$this->data['leadsData6'] = array();
			$this->data['leadsData10'] = array();
			$this->data['leadsData11'] = array();
			$this->data['leadsData12'] = array();
			$this->data['leadsData13'] = array();
			$this->data['leadsData14'] = array();
		}

		$this->pagination1->initialize($config1);
		$this->pagination2->initialize($config2);
		$this->pagination3->initialize($config3);
		$this->pagination4->initialize($config4);
		$this->pagination5->initialize($config5);
		$this->pagination6->initialize($config6);
		$this->pagination10->initialize($config10);
		$this->pagination11->initialize($config11);
		$this->pagination12->initialize($config12);
		$this->pagination13->initialize($config13);
		$this->pagination14->initialize($config14);
		$this->pagination14->initialize($config16);
		$this->pagination20->initialize($config20);

		$this->data['result_count1'] = "Hiển thị " . $config1['total_rows'] . " Kết quả";
		$this->data['result_count2'] = "Hiển thị " . $config2['total_rows'] . " Kết quả";
		$this->data['result_count3'] = "Hiển thị " . $config3['total_rows'] . " Kết quả";
		$this->data['result_count4'] = "Hiển thị " . $config4['total_rows'] . " Kết quả";
		$this->data['result_count5'] = "Hiển thị " . $config5['total_rows'] . " Kết quả";
		$this->data['result_count6'] = "Hiển thị " . $config6['total_rows'] . " Kết quả";
		$this->data['result_count10'] = "Hiển thị " . $config10['total_rows'] . " Kết quả";
		$this->data['result_count11'] = "Hiển thị " . $config11['total_rows'] . " Kết quả";
		$this->data['result_count12'] = "Hiển thị " . $config12['total_rows'] . " Kết quả";
		$this->data['result_count13'] = "Hiển thị " . $config13['total_rows'] . " Kết quả";
		$this->data['result_count14'] = "Hiển thị " . $config14['total_rows'] . " Kết quả";
		$this->data['result_count16'] = "Hiển thị " . $config16['total_rows'] . " Kết quả";
		$this->data['total'] = "Hiển thị " . $config20['total_rows'] . " Kết quả";

		$this->data['pagination1'] = $this->pagination1->create_links();
		$this->data['pagination2'] = $this->pagination2->create_links();
		$this->data['pagination3'] = $this->pagination3->create_links();
		$this->data['pagination4'] = $this->pagination4->create_links();
		$this->data['pagination5'] = $this->pagination5->create_links();
		$this->data['pagination6'] = $this->pagination6->create_links();
		$this->data['pagination10'] = $this->pagination10->create_links();
		$this->data['pagination11'] = $this->pagination11->create_links();
		$this->data['pagination12'] = $this->pagination12->create_links();
		$this->data['pagination13'] = $this->pagination13->create_links();
		$this->data['pagination14'] = $this->pagination14->create_links();
		$this->data['pagination20'] = $this->pagination20->create_links();

		$cskhData = $this->api->apiPost($this->user['token'], "lead_custom/get_cskh");


		if (!empty($cskhData->status) && $cskhData->status == 200) {
			$this->data['cskhData'] = $cskhData->data;
		} else {
			$this->data['cskhData'] = array();
		}
		$provinces = $this->api->apiPost($this->user['token'], "province/get_province");
		if (!empty($provinces->status) && $provinces->status == 200) {
			$this->data['provinces'] = $provinces->data;
		} else {
			$this->data['provinces'] = array();
		}
		$storeData = $this->api->apiPost($this->user['token'], "store/get_all", []);
		if (!empty($storeData->status) && $storeData->status == 200) {
			$this->data['storeData'] = $storeData->data;
		} else {
			$this->data['storeData'] = array();
		}

		$reasonData = $this->api->apiPost($this->user['token'], "reason/get_all", []);
		if (!empty($reasonData->data) && $reasonData->status == 200) {
			$this->data['reasonData'] = $reasonData->data;
		} else {
			$this->data['reasonData'] = array();
		}
		$cond = array(
			"id" => '5df09734d6612be6b43ccda8'
		);

		$list_view_cskh = $this->api->apiPost($this->user['token'], "lead_custom/get_cskh_lead");

		if (!empty($list_view_cskh->status) && $list_view_cskh->status == 200) {
			$this->data['list_view_cskh'] = $list_view_cskh->data;
		} else {
			$this->data['list_view_cskh'] = array();
		}


//		$this->data['return_total'] = $return_total->data;
		//tool dinh gia
		$configuration_formality = $this->api->apiPost($this->userInfo['token'], "configuration_formality/get_configuration_formality");
		if (!empty($configuration_formality->status) && $configuration_formality->status == 200) {
			$this->data['configuration_formality'] = $configuration_formality->data;
		} else {
			$this->data['configuration_formality'] = array();
		}
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main");
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$this->data['main_PropertyData'] = $mainPropertyData->data;
		} else {
			$this->data['main_PropertyData'] = array();
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

		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		$source_active = $this->api->apiPost($this->user['token'], "lead/getSource");
		if ($source_active) {
			$this->data['source_active'] = explode(",",$source_active->data->source);
		}
		$main_property = $this->main_property_model->find();
		// $this->data['leads'] = $leadsData->data;
		$this->data['storeData'] = $storeData->data;
		$this->data['userInfo'] = $this->userInfo;
		$this->data['lead_type_finance'] = lead_type_finance();
		$this->data['provinces'] = $provinces->data;
		$this->data['reason'] = reason();
		$this->data['mainPropertyData'] = $main_property;
		$this->data['template'] = 'page/lead/index';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}


	public function list_transfe_office()
	{
		$this->data["pageName"] = 'Danh sách Lead chuyển về PGD';
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$cond = array(
			"per_page" => $config['per_page'],
			"uriSegment" => $config['uri_segment'],
		);
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$utm_source = !empty($_GET['utm_source']) ? $_GET['utm_source'] : "";
		$utm_campaign = !empty($_GET['utm_campaign']) ? $_GET['utm_campaign'] : "";
		$phone_number = !empty($_GET['phone_number']) ? $_GET['phone_number'] : "";
		$area = !empty($_GET['area']) ? $_GET['area'] : "";
		$status_sale = !empty($_GET['status_sale']) ? $_GET['status_sale'] : "";
		$status_pgd = !empty($_GET['tt_pgd']) ? $_GET['tt_pgd'] : "";
		$cvkd = !empty($_GET['cvkd']) ? $_GET['cvkd'] : "";
		$source_pgd = !empty($_GET['source_pgd']) ? $_GET['source_pgd'] : "";
		$code_store = array();
		$url_code_store = "";

		if (is_array($_GET['code_store'])) {
			foreach ($_GET['code_store'] as $code) {
				array_push($code_store, $code);
				$url_code_store .= '&code_store[]=' . $code;
			}
		} else {
			$code_store = !empty($_GET['code_store']) ? $_GET['code_store'] : "";
			$url_code_store = '&code_store=' . $code_store;
		}


		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('lead_custom/mkt_list_transfe_office'));
		}

		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {

			$cond['start'] = $start;
			$cond['end'] = $end;

		}
		if (!empty($status_sale)) {
			$cond['status_sale'] = $status_sale;
		}
		if (!empty($cvkd)) {
			$cond['cvkd'] = $cvkd;
		}
		if (!empty($status_pgd)) {
			$cond['status_pgd'] = $status_pgd;
		}
		if (!empty($area)) {
			$cond['area'] = $area;
		}
		if (!empty($code_store)) {
			$cond['code_store'] = $code_store;
		}
		if (!empty($utm_source)) {
			$cond['utm_source'] = $utm_source;
		}
		if (!empty($utm_campaign)) {
			$cond['utm_campaign'] = $utm_campaign;
		}
		if (!empty($phone_number)) {
			$cond['phone_number'] = $phone_number;
		}
		if (!empty($source_pgd)) {
			$cond['source_pgd'] = $source_pgd;
		}

		// $checkPhone = $this->api->apiPost($this->user["token"], "lead_custom/get_all_pgd");
		// var_dump(count($checkPhone->data));

		$provinces = $this->api->apiPost($this->user['token'], "province/get_province");
		if (!empty($provinces->status) && $provinces->status == 200) {
			$this->data['provinces'] = $provinces->data;
		} else {
			$this->data['provinces'] = array();
		}
		//var_dump($cond); die;

		$config['base_url'] = base_url('lead_custom/list_transfe_office?&fdate=' . $start . '&tdate=' . $end . $url_code_store . '&area=' . $area . '&utm_source=' . $utm_source . '&utm_campaign=' . $utm_campaign . '&phone_number=' . $phone_number . '&tt_pgd=' . $status_pgd . '&cvkd=' . $cvkd . '&source_pgd=' . $source_pgd);

		// echo '<pre>';
		// var_dump($this->data['userRoles']);
		// var_dump($this->data['groupRoles_s']);
		// exit;
		$group = ['van-hanh', 'giao-dich-vien', 'cua-hang-truong', 'super-admin', 'quan-ly-khu-vuc', 'hoi-so'];
		if (count(array_intersect($this->data['groupRoles_s'], $group)) > 0 || $this->is_superadmin) {
			$storeData = $this->api->apiPost($this->user['token'], "store/get_all", []);
			if (!empty($storeData->status) && $storeData->status == 200) {
				$this->data['storeData'] = $storeData->data;

			} else {
				$this->data['storeData'] = array();
			}

		} else {
			if (!isset($cond['code_store'])) {
				$store_id = array_column($this->data['userRoles']->role_stores, 'store_id');
				if (count($store_id) > 0) {
					$cond['code_store'] = $store_id;
				}
			}

			$this->data['storeData'] = array();
			foreach ($this->data['userRoles']->role_stores as $store) {
				$storeData[] = array(
					'id' => $store->store_id,
					'name' => $store->store_name
				);
			}
			$this->data['storeData'] = json_decode(json_encode($storeData));
		}

		$leadsData = $this->api->apiPost($this->user['token'], "lead_custom/get_lead", $cond);
		// echo "<pre>";
		// var_dump($leadsData->data);
		// echo "<pre>";

		foreach ($leadsData->data as $lead) {
			$data['phone'] = $lead->phone_number;
			unset($checkContract->data[0]->_id->{'$oid'});
			$checkContract = $this->api->apiPost($this->userInfo['token'], "contract/search_phone", $data);

			if (!empty($checkContract->data) && $checkContract->status == 200) {
				if (!empty($checkContract->data[0]->status)) {
					foreach (contract_status() as $key => $item) {
						if ($key == $checkContract->data[0]->status) {
							$lead->status_lead = $item;
							$lead->id_contract_1 = $checkContract->data[0]->_id->{'$oid'};
						}
					}
				}
			}
		}

		if (!empty($leadsData->status) && $leadsData->status == 200) {
			$this->data['leadsData'] = $leadsData->data;
			$this->data['groupRoles'] = $leadsData->groupRoles;
			$this->data['stores'] = $leadsData->stores;

			//var_dump($this->data['stores']); die;
			$config['total_rows'] = $leadsData->total;
		} else {
			$this->data['leadsData'] = array();
		}


		$this->pagination->initialize($config);

		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['result_count'] = "Hiển thị " . $config['total_rows'] . " Kết quả";
		$cskhData = $this->api->apiPost($this->user['token'], "lead_custom/get_cskh");
		//var_dump($cskhData); die;
		if (!empty($cskhData->status) && $cskhData->status == 200) {
			$this->data['cskhData'] = $cskhData->data;
		} else {
			$this->data['cskhData'] = array();
		}


		// $storeData = $this->api->apiPost($this->user['token'], "store/get_all", []);
		// if (!empty($storeData->status) && $storeData->status == 200) {
		// 	$this->data['storeData'] = $storeData->data;
		//
		// } else {
		// 	$this->data['storeData'] = array();
		// }

		$reasonData = $this->api->apiPost($this->user['token'], "reason/get_all", []);
		if (!empty($reasonData->data) && $reasonData->status == 200) {
			$this->data['reasonData'] = $reasonData->data;
		} else {
			$this->data['reasonData'] = array();
		}

		// $cond = array(
		// 	"id" => '5df09734d6612be6b43ccda8'
		// );
		// $cskh = $this->api->apiPost1($this->user['token'], "user/detail", $cond);
		// var_dump($cskh);die();

		$main_property = $this->main_property_model->find();
		$this->data['leads'] = $leadsData->data;
		// $this->data['storeData'] = $storeData->data;
		$this->data['lead_type_finance'] = lead_type_finance();
		//var_dump($this->data['lead_type_finance']);die();
		$this->data['mainPropertyData'] = $main_property;
		$this->data['reason'] = reason();
		$this->data['status_pgd'] = status_pgd();
		$this->data['template'] = 'page/lead/list_transfe_office';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function list_log()
	{
		$cdate = !empty($_GET['cdate']) ? $_GET['cdate'] : "";
		$udate = !empty($_GET['udate']) ? $_GET['udate'] : date("Y-m-d");
		$status_sale_fist = !empty($_GET['status_sale_fist']) ? $_GET['status_sale_fist'] : "";
		$status_sale_last = !empty($_GET['status_sale_last']) ? $_GET['status_sale_last'] : "";
		$utm_source = !empty($_GET['utm_source']) ? $_GET['utm_source'] : "";
		$utm_campaign = !empty($_GET['utm_campaign']) ? $_GET['utm_campaign'] : "";
		$phone_number = !empty($_GET['phone_number']) ? $_GET['phone_number'] : "";
		if (!empty($_GET['cdate'])) {
			$cond = array(
				"cdate" => $cdate,

			);
		}
		if (!empty($status_sale_fist)) {
			$cond['status_sale_fist'] = $status_sale_fist;
		}
		if (!empty($udate)) {
			$cond['udate'] = $udate;
		}
		if (!empty($status_sale_last)) {
			$cond['status_sale_last'] = $status_sale_last;
		}
		if (!empty($utm_source)) {
			$cond['utm_source'] = $utm_source;
		}
		if (!empty($utm_campaign)) {
			$cond['utm_campaign'] = $utm_campaign;
		}
		if (!empty($phone_number)) {
			$cond['phone_number'] = $phone_number;
		}
		// var_dump($cond); die;
		$leadsData = $this->api->apiPost($this->user['token'], "lead_custom/get_lead_log", $cond);
		if (!empty($leadsData->status) && $leadsData->status == 200) {
			$this->data['leadsData'] = $leadsData->data;

		} else {
			$this->data['leadsData'] = array();
		}

		$this->data['template'] = 'page/lead/list_log';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function demo_lead()
	{
		$this->data['template'] = 'web/js_lead/index';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function showLeadInfo($id)
	{
		try {
			$id = $this->security->xss_clean($id);
			$condition = array("id" => $id);
			$lead = $this->api->apiPost($this->user['token'], "lead_custom/get_one", $condition);

			$lead_log = $this->api->apiPost($this->user['token'], 'lead_custom/get_lead_log_html', $condition);

			if (!empty($lead->data) && !empty($lead->data->thoi_gian_khach_hen)) {
				$lead->data->thoi_gian_khach_hen = date('Y-m-d\TH:i:s', $lead->data->thoi_gian_khach_hen);
			}

			$this->pushJson('200', json_encode(array("code" => "200", "data" => $lead->data, 'html' => $lead_log->html)));
		} catch (\Exception $exception) {
			show_404();
		}
	}

	public function showLeadInfo_taivay($id)
	{
		try {

			$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $id));
			if (!empty($contract->data))

				if (!empty($contract->data->customer_infor->customer_phone_number))
					$contract->data->customer_infor->customer_phone_number = encrypt(convert_zero_phone($contract->data->customer_infor->customer_phone_number));

			$this->pushJson('200', json_encode(array("code" => "200", "data" => $contract->data)));
		} catch (\Exception $exception) {
			show_404();
		}
	}

	public function showCvkdChage($id)
	{
		try {
			$id = $this->security->xss_clean($id);
			$condition = array("id" => $id);
			$lead = $this->api->apiPost($this->user['token'], "lead_custom/get_one", $condition);

			$lead->data->status_sale = lead_status($lead->data->status_sale);
			$lead->data->status_pgd = status_pgd($lead->data->status_pgd);
			$lead->data->reason_process = reason_process($lead->data->reason_process);


			$this->pushJson('200', json_encode(array("code" => "200", "data" => $lead->data)));
		} catch (\Exception $exception) {
			show_404();
		}
	}


	public function showRecordingInfo($id)
	{
		try {
			$id = $this->security->xss_clean($id);
			$condition = array("id" => $id);
			$lead = $this->api->apiPost($this->user['token'], "lead_custom/get_recording_html", $condition);
			$this->pushJson('200', json_encode(array("code" => "200", "html" => $lead->html, 'data' => $lead->data)));
		} catch (\Exception $exception) {
			show_404();
		}
	}

	public function get_district_by_province($id)
	{
		try {
			$id = $this->security->xss_clean($id);
			$condition = array("id" => $id);
			$district = $this->api->apiPost($this->user['token'], "province/get_district_by_province", $condition);
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $district->data)));
		} catch (\Exception $exception) {
			show_404();
		}
	}

	public function get_ward_by_district($id)
	{
		try {
			$id = $this->security->xss_clean($id);
			$condition = array("id" => $id);
			$ward = $this->api->apiPost($this->user['token'], "province/get_ward_by_district", $condition);
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $ward->data)));
		} catch (\Exception $exception) {
			show_404();
		}
	}

	public function save_lead()
	{


		$input = $this->input->post();

		// $data['fullname']//họ tên đầy đủ
		// $data['type_finance']// hình thức vay
		// $data['hk_province']// hộ khẩu - tỉnh
		// $data['hk_district'] // hộ khẩu - huyện
		// $data['hk_ward'] // hộ khẩu - xã phường
		// $data['ns_province']//nơi sống - tỉnh
		// $data['ns_district'] //nơi sống -huyện
		// $data['ns_ward'] //nơi sống - xã phường
		// $data['obj'] // đối tượng
		// $data['com'] // tên công ty
		// $data['com_address'] ;// địa chỉ công ty
		// $data['position']  // vị trí
		// $data['time_work'] // thời gian làm việc
		// $data['contract_work'] // hợp đồng lao động
		// $data['other_contract']// giấy tờ xác nhận công việc khác
		// $data['salary_pay']//hình thức trả lương
		// $data['income'] = /thu nhập
		// $data['other_income'] //thu nhập khác
		// $data['workplace_evaluation'] /thẩm định nơi làm việc
		// $data['vehicle_registration'] //đăng kí xe chính chủ
		// $data['property_id'] //id loại xe
		// $data['loan_amount']//nhu cầu vay
		// $data['loan_time'] //thời gian vay
		// $data['type_repay'] //hình thức trả
		// $data['amout_repay'] =//trả hàng tháng
		// $data['status_sale'] =//trạng thái TLS
		// $data['reason_cancel']//Lý do hủy
		// $data['id_PDG'] //id phòng giao dịch
		// $data['time_support'] //thời gian hỗ trợ
		// $data['address_support'] //địa điểm hỗ trợ
		// $data['tls_note'] //TLS ghi chú
		//          Tiêu chí Lead Qualified 1. Khách hàng có hộ khẩu hoặc sinh sống tại HN
		// 2. Khách hàng có xe chính chủ
		// Nếu xe k chính chủ thì nếu đáp ứng 1 trong số các tiêu chí sau sẽ đc vay
		// - Khách có HK và sinh sống tại cùng 1 địa điểm trong nội thành HN
		// - Khách có lương CK
		// - Khách là chủ doanh nghiệp hoặc hộ kdoanh
		// 3. Khách có chứng minh thu nhập (có HĐLĐ hoặc lương CK hoặc bất cứ giấy tờ gì chứng minh thu nhập, hoặc có thể đến xác minh nơi làm việc)
		$_id = !empty($_POST['_id']) ? $_POST['_id'] : '';
		$fullname = !empty($_POST['fullname']) ? $_POST['fullname'] : '';
		$email = !empty($_POST['email']) ? $_POST['email'] : '';
		$identify_lead = !empty($_POST['identify_lead']) ? $_POST['identify_lead'] : '';
		$dob_lead = !empty($_POST['dob_lead']) ? $_POST['dob_lead'] : '';
		$address = !empty($_POST['address']) ? $_POST['address'] : '';
		$type_finance = !empty($_POST['type_finance']) ? $_POST['type_finance'] : '';
		$hk_province = !empty($_POST['hk_province']) ? $_POST['hk_province'] : '';
		$hk_district = !empty($_POST['hk_district']) ? $_POST['hk_district'] : '';
		$hk_ward = !empty($_POST['hk_ward']) ? $_POST['hk_ward'] : '';
		$ns_province = !empty($_POST['ns_province']) ? $_POST['ns_province'] : '';
		$ns_district = !empty($_POST['ns_district']) ? $_POST['ns_district'] : '';
		$ns_ward = !empty($_POST['ns_ward']) ? $_POST['ns_ward'] : '';
		$obj = !empty($_POST['obj']) ? $_POST['obj'] : '';
		$com = !empty($_POST['com']) ? $_POST['com'] : '';
		$com_address = !empty($_POST['com_address']) ? $_POST['com_address'] : '';
		$position = !empty($_POST['position']) ? $_POST['position'] : '';
		$time_work = !empty($_POST['time_work']) ? $_POST['time_work'] : '';
		$contract_work = !empty($_POST['contract_work']) ? $_POST['contract_work'] : '';
		$other_contract = !empty($_POST['other_contract']) ? $_POST['other_contract'] : '';
		$salary_pay = !empty($_POST['salary_pay']) ? $_POST['salary_pay'] : '';
		$income = !empty($_POST['income']) ? $_POST['income'] : '';
		$other_income = !empty($_POST['other_income']) ? $_POST['other_income'] : '';
		$workplace_evaluation = !empty($_POST['workplace_evaluation']) ? $_POST['workplace_evaluation'] : '';
		$vehicle_registration = !empty($_POST['vehicle_registration']) ? $_POST['vehicle_registration'] : '';
		$property_id = !empty($_POST['property_id']) ? $_POST['property_id'] : '';
		$loan_amount = !empty($_POST['loan_amount']) ? $_POST['loan_amount'] : '';
		$loan_time = !empty($_POST['loan_time']) ? $_POST['loan_time'] : '';
		$type_repay = !empty($_POST['type_repay']) ? $_POST['type_repay'] : '';
		$amout_repay = !empty($_POST['amout_repay']) ? $_POST['amout_repay'] : '';
		$status_sale = !empty($_POST['status_sale']) ? $_POST['status_sale'] : '';
		$reason_cancel = !empty($_POST['reason_cancel']) ? $_POST['reason_cancel'] : '';
		$id_PDG = !empty($_POST['id_PDG']) ? $_POST['id_PDG'] : '';
		$time_support = !empty($_POST['time_support']) ? $_POST['time_support'] : '';
		$address_support = !empty($_POST['address_support']) ? $_POST['address_support'] : '';
		$utm_source = !empty($_POST['utm_source']) ? $_POST['utm_source'] : '';
		$utm_campaign = !empty($_POST['utm_campaign']) ? $_POST['utm_campaign'] : '';
		$qualified = !empty($_POST['qualified']) ? $_POST['qualified'] : '';
		$tls_note = !empty($_POST['tls_note']) ? $_POST['tls_note'] : '';
		$pgd_note = !empty($_POST['pgd_note']) ? $_POST['pgd_note'] : '';
		$source = !empty($_POST['source']) ? $_POST['source'] : '';
		$debt = !empty($_POST['debt']) ? $_POST['debt'] : '';
		$status_pgd = !empty($_POST['status_pgd']) ? $_POST['status_pgd'] : '';
		$reason_return = !empty($_POST['reason_return']) ? $_POST['reason_return'] : '';
		$reason_cancel_pgd = !empty($_POST['reason_cancel_pgd']) ? $_POST['reason_cancel_pgd'] : '';
		$sim_chinh_chu = !empty($_POST['sim_chinh_chu']) ? $_POST['sim_chinh_chu'] : '';
		$debt = !empty($_POST['debt']) ? $_POST['debt'] : '';
		$thoi_gian_khach_hen = !empty($_POST['thoi_gian_khach_hen']) ? $_POST['thoi_gian_khach_hen'] : '';
		$status = 1;
		if (!empty($reason_cancel)) {
			$status = 2;
		}
		if (!empty($identify_lead)) {
			if (!preg_match("/^[0-9]{9,12}$/", $identify_lead)) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "CMND/CCCD không đúng định dạng")));
				return;
			}
		}


		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());

		if (!empty($thoi_gian_khach_hen)) {
			if (strtotime($_POST['thoi_gian_khach_hen']) <= $updateAt) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "Thời gian hẹn khách phải ở tương lai")));
				return;
			}
		}

		if ($status_sale == "2" && $id_PDG == "") {

			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Bạn cần chọn phòng giao dịch"
			];
			echo json_encode($response);
			return;
		}
		if ($status_sale == "19" && $reason_cancel == "") {

			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Bạn cần chọn lý do hủy"
			];
			echo json_encode($response);
			return;
		}

		$data = array(
			"id" => $_id,
			"fullname" => $fullname,
			"address" => $address,
			"email" => $email,
			"identify_lead" => $identify_lead,
			"dob_lead" => $dob_lead,
			"type_finance" => $type_finance,
			"hk_province" => $hk_province,
			"hk_district" => $hk_district,
			"hk_ward" => $hk_ward,
			"ns_province" => $ns_province,
			"ns_district" => $ns_district,
			"ns_ward" => $ns_ward,
			"obj" => $obj,
			"com" => $com,
			"com_address" => $com_address,
			"position" => $position,
			"time_work" => $time_work,
			"contract_work" => $contract_work,
			"other_contract" => $other_contract,
			"salary_pay" => $salary_pay,
			"income" => $income,
			"other_income" => $other_income,
			"workplace_evaluation" => $workplace_evaluation,
			"vehicle_registration" => $vehicle_registration,
			"property_id" => $property_id,
			"loan_amount" => $loan_amount,
			"loan_time" => $loan_time,
			"type_repay" => $type_repay,

			"status_sale" => $status_sale,
			"reason_cancel" => $reason_cancel,
			"id_PDG" => $id_PDG,

			"address_support" => $address_support,

			"source" => $source,
			"qualified" => $qualified,
			"status_pgd" => $status_pgd,
			"reason_return" => $reason_return,
			"reason_cancel_pgd" => $reason_cancel_pgd,
			"reason_process" => $reason_process,
			"sim_chinh_chu" => $sim_chinh_chu,
			"thoi_gian_khach_hen" => $thoi_gian_khach_hen,

			"tls_note" => $tls_note,
			"pgd_note" => $pgd_note,
			"status" => $status,
			"updated_at" => $updateAt,
			"updated_by" => $this->userInfo['email']

		);

		$return = $this->api->apiPost($this->user['token'], "lead_custom/update", $data);


		if (!empty($return->status) && $return->status == 200) {

			$response = [
				'res' => true,
				'status' => "200",
				'msg' => 'Cập nhật thành công',
				'url' => $return->url
			];
			echo json_encode($response);

			$this->api->apiPost($this->user['token'], "lead_custom/update_getAllListAT", array("id" => $_id));


			return;
		} else {
			if (!isset($return->message)) {
				$response = [
					'res' => false,
					'status' => "400",
					'msg' => 'Cập nhật không thành công',
					'data' => $return
				];
			} else {
				$response = [
					'res' => false,
					'status' => "400",
					'msg' => $return->message,
					'data' => $return
				];
			}
			echo json_encode($response);
			return;
		}


	}

	public function save_lead_office()
	{


		$input = $this->input->post();

		// $data['fullname']//họ tên đầy đủ
		// $data['type_finance']// hình thức vay
		// $data['hk_province']// hộ khẩu - tỉnh
		// $data['hk_district'] // hộ khẩu - huyện
		// $data['hk_ward'] // hộ khẩu - xã phường
		// $data['ns_province']//nơi sống - tỉnh
		// $data['ns_district'] //nơi sống -huyện
		// $data['ns_ward'] //nơi sống - xã phường
		// $data['obj'] // đối tượng
		// $data['com'] // tên công ty
		// $data['com_address'] ;// địa chỉ công ty
		// $data['position']  // vị trí
		// $data['time_work'] // thời gian làm việc
		// $data['contract_work'] // hợp đồng lao động
		// $data['other_contract']// giấy tờ xác nhận công việc khác
		// $data['salary_pay']//hình thức trả lương
		// $data['income'] = /thu nhập
		// $data['other_income'] //thu nhập khác
		// $data['workplace_evaluation'] /thẩm định nơi làm việc
		// $data['vehicle_registration'] //đăng kí xe chính chủ
		// $data['property_id'] //id loại xe
		// $data['loan_amount']//nhu cầu vay
		// $data['loan_time'] //thời gian vay
		// $data['type_repay'] //hình thức trả
		// $data['amout_repay'] =//trả hàng tháng
		// $data['status_sale'] =//trạng thái TLS
		// $data['reason_cancel']//Lý do hủy
		// $data['id_PDG'] //id phòng giao dịch
		// $data['time_support'] //thời gian hỗ trợ
		// $data['address_support'] //địa điểm hỗ trợ
		// $data['tls_note'] //TLS ghi chú
		//          Tiêu chí Lead Qualified 1. Khách hàng có hộ khẩu hoặc sinh sống tại HN
		// 2. Khách hàng có xe chính chủ
		// Nếu xe k chính chủ thì nếu đáp ứng 1 trong số các tiêu chí sau sẽ đc vay
		// - Khách có HK và sinh sống tại cùng 1 địa điểm trong nội thành HN
		// - Khách có lương CK
		// - Khách là chủ doanh nghiệp hoặc hộ kdoanh
		// 3. Khách có chứng minh thu nhập (có HĐLĐ hoặc lương CK hoặc bất cứ giấy tờ gì chứng minh thu nhập, hoặc có thể đến xác minh nơi làm việc)
		$_id = !empty($_POST['_id']) ? $_POST['_id'] : '';
		$fullname = !empty($_POST['fullname']) ? $_POST['fullname'] : '';
		$email = !empty($_POST['email']) ? $_POST['email'] : '';
		$identify_lead = !empty($_POST['identify_lead']) ? $_POST['identify_lead'] : '';
		$address = !empty($_POST['address']) ? $_POST['address'] : '';
		$type_finance = !empty($_POST['type_finance']) ? $_POST['type_finance'] : '';
		$hk_province = !empty($_POST['hk_province']) ? $_POST['hk_province'] : '';
		$hk_district = !empty($_POST['hk_district']) ? $_POST['hk_district'] : '';
		$hk_ward = !empty($_POST['hk_ward']) ? $_POST['hk_ward'] : '';
		$ns_province = !empty($_POST['ns_province']) ? $_POST['ns_province'] : '';
		$ns_district = !empty($_POST['ns_district']) ? $_POST['ns_district'] : '';
		$ns_ward = !empty($_POST['ns_ward']) ? $_POST['ns_ward'] : '';
		$obj = !empty($_POST['obj']) ? $_POST['obj'] : '';
		$com = !empty($_POST['com']) ? $_POST['com'] : '';
		$com_address = !empty($_POST['com_address']) ? $_POST['com_address'] : '';
		$position = !empty($_POST['position']) ? $_POST['position'] : '';
		$time_work = !empty($_POST['time_work']) ? $_POST['time_work'] : '';
		$contract_work = !empty($_POST['contract_work']) ? $_POST['contract_work'] : '';
		$other_contract = !empty($_POST['other_contract']) ? $_POST['other_contract'] : '';
		$salary_pay = !empty($_POST['salary_pay']) ? $_POST['salary_pay'] : '';
		$income = !empty($_POST['income']) ? $_POST['income'] : '';
		$other_income = !empty($_POST['other_income']) ? $_POST['other_income'] : '';
		$workplace_evaluation = !empty($_POST['workplace_evaluation']) ? $_POST['workplace_evaluation'] : '';
		$vehicle_registration = !empty($_POST['vehicle_registration']) ? $_POST['vehicle_registration'] : '';
		$property_id = !empty($_POST['property_id']) ? $_POST['property_id'] : '';
		$loan_amount = !empty($_POST['loan_amount']) ? $_POST['loan_amount'] : '';
		$loan_time = !empty($_POST['loan_time']) ? $_POST['loan_time'] : '';
		$type_repay = !empty($_POST['type_repay']) ? $_POST['type_repay'] : '';
		$amout_repay = !empty($_POST['amout_repay']) ? $_POST['amout_repay'] : '';
		$status_sale = !empty($_POST['status_sale']) ? $_POST['status_sale'] : '';
		$reason_cancel = !empty($_POST['reason_cancel']) ? $_POST['reason_cancel'] : '';
		$id_PDG = !empty($_POST['id_PDG']) ? $_POST['id_PDG'] : '';
		$time_support = !empty($_POST['time_support']) ? $_POST['time_support'] : '';
		$address_support = !empty($_POST['address_support']) ? $_POST['address_support'] : '';
		$utm_source = !empty($_POST['utm_source']) ? $_POST['utm_source'] : '';
		$utm_campaign = !empty($_POST['utm_campaign']) ? $_POST['utm_campaign'] : '';
		$qualified = !empty($_POST['qualified']) ? $_POST['qualified'] : '';
		$tls_note = !empty($_POST['tls_note']) ? $_POST['tls_note'] : '';
		$pgd_note = !empty($_POST['pgd_note']) ? $_POST['pgd_note'] : '';
		$source = !empty($_POST['source']) ? $_POST['source'] : '';
		$debt = !empty($_POST['debt']) ? $_POST['debt'] : '';
		$status_pgd = !empty($_POST['status_pgd']) ? $_POST['status_pgd'] : '';
		$reason_return = !empty($_POST['reason_return']) ? $_POST['reason_return'] : '';
		$reason_cancel_pgd = !empty($_POST['reason_cancel_pgd']) ? $_POST['reason_cancel_pgd'] : '';
		$reason_process = !empty($_POST['reason_process']) ? $_POST['reason_process'] : '';
		$status = 1;
		if (!empty($reason_cancel)) {
			$status = 2;
		}
		if (!empty($identify_lead)) {
			if (!preg_match("/^[0-9]{9,12}$/", $identify_lead)) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "CMND/CCCD không đúng định dạng")));
				return;
			}
		}
		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		if ($status_sale == "2" && $id_PDG == "") {

			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Bạn cần chọn phòng giao dịch"
			];
			echo json_encode($response);
			return;
		}
		if ($status_sale == "19" && $reason_cancel == "") {

			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Bạn cần chọn lý do hủy"
			];
			echo json_encode($response);
			return;
		}
		if ($status_sale == 2 && $status_pgd == "") {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Bạn cần chọn trạng thái lead PGD!"
			];
			echo json_encode($response);
			return;
		}
		if ($status_pgd == 8 && $reason_return == "") {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Bạn cần chọn lý do trả về!"
			];
			echo json_encode($response);
			return;
		}
		if ($status_pgd == 16 && $reason_cancel_pgd == "") {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Bạn cần chọn lý do hủy!"
			];
			echo json_encode($response);
			return;
		}
		if ($status_pgd == 17 && $reason_process == "") {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Bạn cần chọn lý do đang xử lý!"
			];
			echo json_encode($response);
			return;
		}

		$data = array(
			"id" => $_id,
			"fullname" => $fullname,
			"address" => $address,
			"email" => $email,
			"identify_lead" => $identify_lead,
			"type_finance" => $type_finance,
			"hk_province" => $hk_province,
			"hk_district" => $hk_district,
			"hk_ward" => $hk_ward,
			"ns_province" => $ns_province,
			"ns_district" => $ns_district,
			"ns_ward" => $ns_ward,
			"obj" => $obj,
			"com" => $com,
			"com_address" => $com_address,
			"position" => $position,
			"time_work" => $time_work,
			"contract_work" => $contract_work,
			"other_contract" => $other_contract,
			"salary_pay" => $salary_pay,
			"income" => $income,
			"other_income" => $other_income,
			"workplace_evaluation" => $workplace_evaluation,
			"vehicle_registration" => $vehicle_registration,
			"property_id" => $property_id,
			"loan_amount" => $loan_amount,
			"loan_time" => $loan_time,
			"type_repay" => $type_repay,

			"status_sale" => $status_sale,
			"reason_cancel" => $reason_cancel,
			"id_PDG" => $id_PDG,

			"address_support" => $address_support,

			"source" => $source,
			"qualified" => $qualified,
			"status_pgd" => $status_pgd,
			"reason_return" => $reason_return,
			"reason_cancel_pgd" => $reason_cancel_pgd,
			"reason_process" => $reason_process,

			"tls_note" => $tls_note,
			"pgd_note" => $pgd_note,
			"status" => $status,
			"updated_at" => $updateAt,
			"updated_by" => $this->userInfo['email']

		);

		$return = $this->api->apiPost($this->user['token'], "lead_custom/update", $data);
		if (!empty($return->status) && $return->status == 200) {

			$response = [
				'res' => true,
				'status' => "200",
				'msg' => 'Cập nhật thành công',
				'url' => $return->url
			];
			echo json_encode($response);
			return;
		} else {
			if (!isset($return->message)) {
				$response = [
					'res' => false,
					'status' => "400",
					'msg' => 'Cập nhật không thành công',
					'data' => $return
				];
			} else {
				$response = [
					'res' => false,
					'status' => "400",
					'msg' => $return->message,
					'data' => $return
				];
			}
			echo json_encode($response);
			return;
		}


	}

	public function change_pgd()
	{

		$data = array();

		$input = $this->input->post();
		$_id = !empty($_POST['_id']) ? $_POST['_id'] : '';
		$id_PDG = !empty($_POST['id_PDG']) ? $_POST['id_PDG'] : '';
		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		if (empty($id_PDG)) {

			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Bạn chưa chọn phòng giao dịch chuyển đến"
			];
			echo json_encode($response);
			return;
		}
		$data = array(
			"id" => $_id,
			"status_sale" => 2,
			"updated_at" => $updateAt,
			"updated_by" => $this->userInfo['email']
		);
		$return = $this->api->apiPost($this->user['token'], "lead_custom/update", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'msg' => 'Yêu cầu chuyển thành công',
				'url' => $return->url
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => 'Yêu cầu chuyển không thành công',
				'data' => $return
			];
			echo json_encode($response);
			return;
		}

	}

	public function do_update_cskh_lead()
	{

		$data = array();

		$input = $this->input->post();
		$id = !empty($_POST['id']) ? $_POST['id'] : '';
		$cskh = !empty($_POST['cskh']) ? $_POST['cskh'] : '';
		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		//            if (empty($cskh)) {

		// $response = [
		//  'res' => false,
		//  'status' => "400",
		//  'msg' => "Bạn chưa chọn CSKH"
		// ];
		// echo json_encode($response);
		// return;
		//         }
		$data = array(
			"id" => $id,
			"cskh" => $cskh,
			"updated_at" => $updateAt,
			"updated_by" => $this->userInfo['email'],
			"assign_to_cskh" => 1
		);
		$return = $this->api->apiPost($this->user['token'], "lead_custom/update", $data);
		if (!empty($return->status) && $return->status == '200') {
			$response = [
				'res' => true,
				'status' => "200",
				'msg' => 'Cập nhật  thành công',
				'url' => $return->url
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => 'Cập nhật không thành công',
				'data' => $return
			];
			echo json_encode($response);
			return;
		}

	}

	public function do_update_cskh_lead_taivay()
	{

		$data = array();

		$input = $this->input->post();
		$id = !empty($_POST['id']) ? $_POST['id'] : '';
		$cskh = !empty($_POST['cskh']) ? $_POST['cskh'] : '';
		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());

		$data = array(
			"id" => $id,
			"cskh_taivay" => $cskh,
			"updated_at" => $updateAt,
			"updated_by" => $this->userInfo['email'],
			"assign_to_cskh_taivay" => 1
		);
		$return = $this->api->apiPost($this->user['token'], "lead_custom/update", $data);
		if (!empty($return->status) && $return->status == '200') {
			$response = [
				'res' => true,
				'status' => "200",
				'msg' => 'Cập nhật  thành công',
				'url' => $return->url
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => 'Cập nhật không thành công',
				'data' => $return
			];
			echo json_encode($response);
			return;
		}

	}

	public function do_insert_lead()
	{

		$data = array();

		$input = $this->input->post();
		$customer_fullname = !empty($_POST['customer_fullname']) ? $_POST['customer_fullname'] : '';
		$customer_phone = !empty($_POST['customer_phone']) ? $_POST['customer_phone'] : '';
		$customer_gender = !empty($_POST['customer_gender']) ? $_POST['customer_gender'] : '';
		$customer_source = !empty($_POST['customer_source']) ? $_POST['customer_source'] : '';
		$customer_phone_introduce = !empty($_POST['customer_phone_introduce']) ? $_POST['customer_phone_introduce'] : '';
		$cskh = !empty($_POST['cskh']) ? $_POST['cskh'] : '';
		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());

		$data_extra = array(
			"cskh" => $cskh,
			"source" => $customer_source,
			"gender" => $customer_gender,
			"phone_number" => $customer_phone,
			"fullname" => $customer_fullname,
			"customer_phone_introduce" => $customer_phone_introduce,
			"status" => 1,
			"status_sale" => 1,
			"type" => 3,
			"created_at" => $updateAt,
			"created_by" => $this->userInfo['email']
		);

		$this->api->apiPost($this->user['token'], "lead_custom/create_lead_extra", $data_extra);

		if (empty($customer_fullname)) {

			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Bạn chưa nhập đầy đủ họ và tên"
			];
			echo json_encode($response);
			return;
		}
		if (empty($customer_phone)) {

			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Bạn chưa nhập đầy đủ số điện thoại"
			];
			echo json_encode($response);
			return;
		}
		if (!preg_match("/^[0-9]{10}$/", $customer_phone)) {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Số điện thoại không đúng định dạng"
			];
			echo json_encode($response);
			return;
		}


		$data = array(
			"cskh" => $cskh,
			"source" => $customer_source,
			"gender" => $customer_gender,
			"phone_number" => $customer_phone,
			"fullname" => $customer_fullname,
			"customer_phone_introduce" => $customer_phone_introduce,
			"status" => 1,
			"status_sale" => 1,
			"type" => 3,
			"created_at" => $updateAt,
			"created_by" => $this->userInfo['email']
		);

		$return = $this->api->apiPost($this->user['token'], "lead_custom/create_lead", $data);
		if (isset($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => 200,
				'msg' => 'Thêm mới khách hàng thành công',
				'url' => $return->url
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => 400,
				'msg' => 'Thêm mới khách hàng không thành công,lead trong các trạng thái chưa xử lý dứt điểm',
				'data' => $return
			];
			echo json_encode($response);
			return;
		}

	}

	public function lead_delete()
	{
		try {
			$input = $this->input->get();
			if ($input['_id'] == null) {
				$array = array(
					'error' => true,
					'_id' => form_error('_id'),
				);
				$this->pushJson('200', json_encode(array("code" => "200", "data" => $array)));
			} else {
				$data['_id'] = $this->security->xss_clean($input['_id']);
				$response = $this->api->apiPost($this->user['token'], "lead_custom/lead_delete", $data);
				$this->pushJson('200', json_encode(array("code" => "200", "data" => $response)));
			}
		} catch (\Exception $exception) {
			show_404();
		}
	}


	public function _validate()
	{
		$this->form_validation->set_rules('_id', '_id', 'required');
		$this->form_validation->set_rules('fullname', 'Họ và tên', 'required');
		$this->form_validation->set_rules('com', 'Công ty', 'required');
		if ($this->form_validation->run()) {
			$array = array();
		} else {
			$array = array(
				'error' => true,
				'_id' => form_error('_id'),
				'fullname' => form_error('fullname'),
				'com' => form_error('com'),
			);
		}
		return $array;
	}

	private function pushJson($code, $data)
	{
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}

	public function showLeadLogInfo($id)
	{
		try {
			$id = $this->security->xss_clean($id);
			$condition = array("id" => $id);
			$lead = $this->api->apiPost($this->user['token'], 'lead_custom/get_lead_log_html', $condition);
			$this->pushJson('200', json_encode(array("code" => "200", "html" => $lead->html, "data" => $lead->data)));
		} catch (Exception $exception) {
			show_404();
		}
	}

	public function lead_cancel_daily()
	{
		$start = !empty($_GET["fdate"]) ? $_GET["fdate"] : '';
		$end = !empty($_GET["tdate"]) ? $_GET["tdate"] : '';
		if (strtotime($start) > strtotime($end)) {

			$this->session->setflash_data("error", $this->lang->line("Error_formatting_date"));
			redirect(base_url("lead_custom/lead_cancel_daily"));
		}
		$condition = array();
		if (!empty($_GET["fdate"]) && !empty($_GET["tdate"])) {
		}
		$condition = array(
			"start" => $start,
			"end" => $end
		);
		$cskhData = $this->api->apiPost($this->user["token"], "lead_custom/lead_cancel_daily", $condition);
		if (!empty($cskhData->status) && $cskhData->status == 200) {
			$this->data['mktData'] = $cskhData->data;
		} else {
			$this->data['mktData'] = array();
		}
		$this->data["template"] = "page/lead/report/lead_cancel";
		$this->load->view("template", isset($this->data) ? $this->data : '');

	}


	public function pgd_insert_lead()
	{
		$data = array();
		$input = $this->input->post();
		$customer_fullname = !empty($_POST['customer_fullname']) ? $_POST['customer_fullname'] : '';
		$customer_phone = !empty($_POST['customer_phone']) ? $_POST['customer_phone'] : '';
		$customer_identity_card = !empty($_POST['customer_identity_card']) ? $_POST['customer_identity_card'] : '';
		$customer_card = !empty($_POST['customer_card']) ? $_POST['customer_card'] : '';
		$customer_gender = !empty($_POST['customer_gender']) ? $_POST['customer_gender'] : '';
		$customer_source = !empty($_POST['customer_source']) ? $_POST['customer_source'] : '';
		$customer_phone_introduce = !empty($_POST['customer_phone_introduce']) ? $_POST['customer_phone_introduce'] : '';
		$address = !empty($_POST['address']) ? $_POST['address'] : '';
		$data_extra = array(
			"customer_phone_introduce" => $customer_phone_introduce,
			"customer_card" => $customer_card,
			"customer_identity_card" => $customer_identity_card,
			"source" => $customer_source,
			"gender" => $customer_gender,
			"address" => $address,
			"phone_number" => $customer_phone,
			"fullname" => $customer_fullname,
			"status_sale" => 30,
			"created_by" => $this->userInfo['email']
		);

		$this->api->apiPost($this->user['token'], "lead_custom/create_lead_extra", $data_extra);


		if (empty($customer_fullname)) {

			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Bạn chưa nhập đầy đủ họ và tên"
			];
			echo json_encode($response);
			return;
		}

		$dataCheck = array(
			"phone_number" => $customer_phone,
		);

		$checkData = $this->api->apiPost($this->user["token"], "lead_custom/get_all_pgd");
		$check = $this->api->apiPost($this->user["token"], "lead_custom/get_one_lead_pgd", $dataCheck);

		if (!empty($check->data->source)) {
			if ($check->data->source == 1 || $check->data->source == 4 || $check->data->source == 5 || $check->data->source == 6 || $check->data->source == 7 || $check->data->source == 12) {
				$source = "Maketing";
			}
			if ($check->data->source == 2 || $check->data->source == 3) {
				$source = "Telesale";
			}
			if ($check->data->source == 12) {
				$source = "Nguồn app";
			}
		}
		if (!empty($check->data->source_pgd)) {
			if ($check->data->source_pgd == 8 || $check->data->source_pgd == 9 || $check->data->source_pgd == 10 || $check->data->source_pgd == 11) {
				$source = "PGD";
			}
		}

		if (!preg_match("/^[0-9]{10}$/", $customer_phone)) {

			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Bạn chưa nhập đúng số điện thoại"
			];
			echo json_encode($response);
			return;
		}

		if (!empty($customer_card)) {
			if (!preg_match("/^[0-9]{12}$/", $customer_card)) {

				$response = [
					'res' => false,
					'status' => "400",
					'msg' => "Bạn chưa nhập đầy đủ số thẻ căn cước"
				];
				echo json_encode($response);
				return;
			}
		}

//		if (empty($customer_identity_card)) {
//
//			$response = [
//				'res' => false,
//				'status' => "400",
//				'msg' => "Bạn chưa nhập đầy đủ số chứng minh nhân dân"
//			];
//			echo json_encode($response);
//			return;
//		}
		if (!empty($customer_identity_card)) {
			if (!empty($checkData->data)) {
				for ($i = 0; $i < count($checkData->data); $i++) {
					if ($checkData->data[$i]->customer_identity_card == $customer_identity_card) {
						$response = [
							'res' => false,
							'status' => "400",
							'msg' => "Dữ liệu đã do bộ phận " . $source . " tạo. Người dùng không được tạo nữa"
						];
						echo json_encode($response);
						return;
					}
				}
			}
		}


		if (!empty($customer_card)) {
			if (!empty($checkData->data)) {
				for ($i = 0; $i < count($checkData->data); $i++) {
					if ($checkData->data[$i]->customer_card == $customer_card) {
						$response = [
							'res' => false,
							'status' => "400",
							'msg' => "Dữ liệu đã do bộ phận " . $source . " tạo. Người dùng không được tạo nữa"
						];
						echo json_encode($response);
						return;
					}
				}
			}
		}

		if (!empty($checkData->data)) {
			for ($i = 0; $i < count($checkData->data); $i++) {
				if ($checkData->data[$i]->phone_number == $customer_phone && $check->data->status != 19) {
					$response = [
						'res' => false,
						'status' => "400",
						'msg' => "Dữ liệu đã do bộ phận " . $source . " tạo. Người dùng không được tạo nữa"
					];
					echo json_encode($response);
					return;
				}

			}
		}

		$data = array(
			"customer_phone_introduce" => $customer_phone_introduce,
			"customer_card" => $customer_card,
			"customer_identity_card" => $customer_identity_card,
			"source" => $customer_source,
			"gender" => $customer_gender,
			"address" => $address,
			"phone_number" => $customer_phone,
			"fullname" => $customer_fullname,
			"status_sale" => 30,
			"created_by" => $this->userInfo['email']
		);

		$return = $this->api->apiPost($this->user['token'], "lead_custom/create_lead_pgd", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'msg' => 'Thêm mới khách hàng thành công',
				'url' => $return->url
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => 'Thêm mới khách hàng không thành công,lead trong các trạng thái chưa xử lý dứt điểm',
				'data' => $return
			];
			echo json_encode($response);
			return;
		}

	}

	public function check_phone_source()
	{
		$phone_number_source = !empty($_POST['phone_number_source']) ? $_POST['phone_number_source'] : '';

		$data = [
			'phone_number_source' => $phone_number_source,
		];

		$check_phone = $this->api->apiPost($this->user["token"], "lead_custom/get_check_phone_source", $data);

		if (!empty($check_phone->status) && $check_phone->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'check_phone' => $check_phone,
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'check_phone' => $check_phone,
			];
			echo json_encode($response);
			return;
		}

	}

	public function customer_identify_source()
	{
		$customer_identify = !empty($_POST['customer_identify']) ? $_POST['customer_identify'] : '';

		$data = [
			'customer_identify' => $customer_identify,
		];

		$check_identify = $this->api->apiPost($this->user["token"], "lead_custom/get_check_identify_source", $data);

		if (!empty($check_identify->status) && $check_identify->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'check_phone' => $check_identify,
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
			];
			echo json_encode($response);
			return;
		}

	}

	public function update_list_cskh()
	{

		$data = array();

		$list_cskh = !empty($_POST['list_cskh']) ? $_POST['list_cskh'] : '';

		if ($list_cskh == "undefined") {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => 'Không thành công',
				'data' => $return
			];
			echo json_encode($response);
			return;
		}

		$list_cskh = !empty($_POST['list_cskh']) ? $_POST['list_cskh'] : '';

		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());


		$data = array(
			"list_cskh" => $list_cskh,
			"updated_at" => $updateAt,
			"status" => 1,
			"updated_by" => $this->userInfo['email']
		);

		$return = $this->api->apiPost($this->user['token'], "lead_custom/update_cskh_lead", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'msg' => 'Thành công',
				'url' => $return->url
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => 'Không thành công',
				'data' => $return
			];
			echo json_encode($response);
			return;
		}
	}

	public function update_list_cskh_del()
	{

		$data = array();

		$list_cskh_del = !empty($_POST['list_cskh_del']) ? $_POST['list_cskh_del'] : '';

		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());

		$data = array(
			"list_cskh_del" => $list_cskh_del,
			"updated_at" => $updateAt,
			"updated_by" => $this->userInfo['email']
		);

		$return = $this->api->apiPost($this->user['token'], "lead_custom/insert_cskh_del", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'msg' => 'Xóa Thành công',
				'url' => $return->url
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => 'Không thành công',
				'data' => $return
			];
			echo json_encode($response);
			return;
		}
	}

	public function insert_customer_hs_create_at()
	{

		$data = $this->input->post();


		$data['id_oid'] = $this->security->xss_clean($data['id_oid']);

		$data = array(
			"id_oid" => !empty($data['id_oid']) ? $data['id_oid'] : '',
			"user" => !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "",
		);

		$return = $this->api->apiPost($this->user['token'], "hoiso_create/create_hs_storage", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'msg' => 'Thêm mới danh sách thành công',
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => 'Tên địa điểm đã được tạo',
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}
	}

	public function getNotificationLead()
	{
		$dataPost = array(
			'token' => $this->user['token'],
			'user_id' => $this->user['id'],
		);

		$nofityData = $this->api->apiPost($this->user['token'], "user/get_notification_for_lead", $dataPost);
		if (!empty($this->user)) {
			$this->data['user_notifications'] = $nofityData->notifications;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $this->data['user_notifications'])));
			return;
		}
	}

	public function search_investors()
	{

		$data = $this->input->post();

		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";


		if (!empty($fdate)) {
			$data['fdate'] = $fdate;
		}
		if (!empty($tdate)) {
			$data['tdate'] = $tdate;
		}

		$count_lead_investors = $this->api->apiPost($this->userInfo['token'], "lead/count_index_lading_investors", $data);

		$count = (int)$count_lead_investors->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('lead_custom/get_lead_investors');
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;

		$data["per_page"] = $config['per_page'];
		$data["uriSegment"] = $config['uri_segment'];

		$lead_investors = $this->api->apiPost($this->user['token'], "lead/index_lading_investors", $data);

		if (!empty($lead_investors->status) && $lead_investors->status == 200) {

			$this->data['lead_investors'] = $lead_investors->data;
		} else {
			$this->data['lead_investors'] = array();
		}


		$this->data['template'] = 'page/lead_investors/lead_investors';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);


	}

	public function get_lead_investors()
	{

		$data = $this->input->post();

		$count_lead_investors = $this->api->apiPost($this->userInfo['token'], "lead/count_index_lading_investors");

		$count = (int)$count_lead_investors->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('lead_custom/get_lead_investors');
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;

		$data["per_page"] = $config['per_page'];
		$data["uriSegment"] = $config['uri_segment'];

		$lead_investors = $this->api->apiPost($this->user['token'], "lead/index_lading_investors", $data);

		if (!empty($lead_investors->status) && $lead_investors->status == 200) {

			$this->data['lead_investors'] = $lead_investors->data;
		} else {
			$this->data['lead_investors'] = array();
		}


		$this->data['template'] = 'page/lead_investors/lead_investors';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);


	}

	public function save_chage_cvkd()
	{


		$input = $this->input->post();

		$id = !empty($_POST['id']) ? $_POST['id'] : '';
		$cvkd = !empty($_POST['cvkd']) ? $_POST['cvkd'] : '';
		$note = !empty($_POST['note']) ? $_POST['note'] : '';
		$data = [
			'id' => $id,
			'cvkd' => $cvkd,
			'note_tpgd_chage_cvkd' => $cvkd,
		];

		$return = $this->api->apiPost($this->user['token'], "lead_custom/update_chage_cvkd", $data);


		if (!empty($return->status) && $return->status == 200) {

			$response = [
				'res' => true,
				'status' => "200",
				'msg' => 'Cập nhật thành công',
				'url' => $return->url
			];
			echo json_encode($response);

			return;
		} else {
			if (!isset($return->message)) {
				$response = [
					'res' => false,
					'status' => "400",
					'msg' => 'Cập nhật không thành công',
					'data' => $return
				];
			} else {
				$response = [
					'res' => false,
					'status' => "400",
					'msg' => $return->message,
					'data' => $return
				];
			}
			echo json_encode($response);
			return;
		}


	}


	public function lead_qualified_TS()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$reason_cancel = !empty($_GET['reason_cancel']) ? $_GET['reason_cancel'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "not_qualified";
		$sdt = !empty($_GET['sdt']) ? $_GET['sdt'] : "";
		$source = !empty($_GET['source_s']) ? $_GET['source_s'] : "";
		$fullname = !empty($_GET['fullname']) ? $_GET['fullname'] : "";

		$cond = array();
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$cond = array(
				"start" => $fdate,
				"end" => $tdate,
			);
		}

		if (!empty($fdate) && !empty($tdate)) {
			if (strtotime($fdate) > strtotime($tdate)) {
				$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
				redirect(base_url('lead_custom/lead_qualified_TS'));
			}
			if (empty($_GET['fdate']) || empty($_GET['tdate'])) {
				$this->session->set_flashdata('error', $this->lang->line('Please_select_input_date'));
				redirect(base_url('lead_custom/lead_qualified_TS'));
			}
		}
		if (!empty($reason_cancel)) {
			$cond["reason_cancel"] = $reason_cancel;
		}
		if (!empty($status)) {
			$cond["status"] = $status;
		}
		if (!empty($tab)) {
			$cond["tab"] = $tab;
		}
		if (!empty($_GET['sdt'])) {
			$cond['sdt'] = $sdt;
		}
		if (!empty($_GET['source_s'])) {
			$cond['source'] = $source;
		}
		if (!empty($_GET['fullname'])) {
			$cond['fullname'] = $fullname;
		}

		if (!empty($tab) && in_array($tab, ['list_not_qualified', 'list_qualified'])) {
			$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
			$this->load->library('pagination', '', 'pagination');

			$config = $this->config->item('pagination');
			$config['base_url'] = base_url('lead_custom/lead_qualified_TS?tab=' . $tab . '&fdate=' . $fdate . '&tdate=' . $tdate . '&sdt=' . $sdt . '&fullname=' . $fullname . '&source_s=' . $source . '&status=' . $status . '&reason_cancel=' . $reason_cancel);
			$config['per_page'] = 20;
			$config['enable_query_strings'] = true;
			$config['page_query_string'] = true;
			$config['uri_segment'] = $uriSegment;
			$cond['per_page'] = $config['per_page'];
			$cond['uriSegment'] = $config['uri_segment'];
			$cskhData = $this->api->apiPost($this->user['token'], "lead_custom/get_cskh");

			if (!empty($cskhData->status) && $cskhData->status == 200) {
				$this->data['cskhData'] = $cskhData->data;
			} else {
				$this->data['cskhData'] = array();
			}
			$provinces = $this->api->apiPost($this->user['token'], "province/get_province");
			if (!empty($provinces->status) && $provinces->status == 200) {
				$this->data['provinces'] = $provinces->data;
			} else {
				$this->data['provinces'] = array();
			}
			$storeData = $this->api->apiPost($this->user['token'], "store/get_all", []);
			if (!empty($storeData->status) && $storeData->status == 200) {
				$this->data['storeData'] = $storeData->data;
			} else {
				$this->data['storeData'] = array();
			}

			$reasonData = $this->api->apiPost($this->user['token'], "reason/get_all", []);
			if (!empty($reasonData->data) && $reasonData->status == 200) {
				$this->data['reasonData'] = $reasonData->data;
			} else {
				$this->data['reasonData'] = array();
			}

		}

		$cskhData = $this->api->apiPost($this->user['token'], "lead_custom/lead_qualified_TS", $cond);
		if (!empty($cskhData->status) && $cskhData->status == 200) {
			$this->data['leadTSData'] = $cskhData->data;
			$this->data['qualified_cancel'] = $cskhData->qualified_cancel;
			$this->data['leadsData'] = $cskhData->leadsData;
			$config['total_rows'] = $cskhData->leads_total;
			$this->data['groupRoles'] = $cskhData->groupRoles;
		} else {
			$this->data['leadTSData'] = array();
			$this->data['qualified_cancel'] = array();
			$this->data['leadsData'] = array();
		}
		$this->pagination->initialize($config);
		$this->data['result_count'] = "Hiển thị " . $config['total_rows'] . " Kết quả";
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/lead/report/lead_qualified_TS';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function restoreLead()
	{
		$data = $this->input->post();
		$id_lead = $this->security->xss_clean($data['id_lead']);
		if (!empty($id_lead)) {
			$data_send_api = array(
				'id_lead' => $id_lead
			);
		}

		$data_return = $this->api->apiPost($this->user['token'], 'lead_custom/restore_lead', $data_send_api);
		if (!empty($data_return->status) && $data_return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'msg' => $data_return->msg,
			];
			$this->pushJson('200', json_encode($response));
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Có lỗi trong quá trình khôi phục Lead!",
			];
			$this->pushJson('200', json_encode($response));
			return;
		}

	}

	public function back_delete()
	{

		$data_return = $this->api->apiPost($this->user['token'], 'lead_custom/back_delete');


		if (!empty($data_return->status) && $data_return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'msg' => $data_return->message,
			];
			$this->pushJson('200', json_encode($response));
			return;
		} else {
			$response = [
				'res' => true,
				'status' => "400",
				'msg' => "Không có dữ liệu",
			];
			$this->pushJson('200', json_encode($response));
			return;
		}


	}

	public function pgd_insert_lead_v2()
	{
		$data = array();
		$input = $this->input->post();
		$customer_fullname = !empty($_POST['customer_fullname']) ? $_POST['customer_fullname'] : '';
		$customer_phone = !empty($_POST['customer_phone']) ? $_POST['customer_phone'] : '';
		$identify_lead = !empty($_POST['identify_lead']) ? $_POST['identify_lead'] : '';
		$address = !empty($_POST['address']) ? $_POST['address'] : '';
		$customer_source = !empty($_POST['customer_source']) ? $_POST['customer_source'] : '';

		if (empty($customer_fullname)) {

			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Bạn chưa nhập đầy đủ họ và tên"
			];
			$this->pushJson('200', json_encode($response));
			return;
		}

		$dataCheck = array(
			"phone_number" => $customer_phone,
		);

		$checkData = $this->api->apiPost($this->user["token"], "lead_custom/get_all_pgd");
		$check = $this->api->apiPost($this->user["token"], "lead_custom/get_one_lead_pgd", $dataCheck);

		if (!empty($check->data->source)) {
			if ($check->data->source == 1 || $check->data->source == 4 || $check->data->source == 5 || $check->data->source == 6 || $check->data->source == 7 || $check->data->source == 12) {
				$source = "Maketing";
			}
			if ($check->data->source == 2 || $check->data->source == 3) {
				$source = "Telesale";
			}
			if ($check->data->source == 12) {
				$source = "Nguồn app";
			}
		}
		if (!empty($check->data->source_pgd)) {
			if ($check->data->source_pgd == 8 || $check->data->source_pgd == 9 || $check->data->source_pgd == 10 || $check->data->source_pgd == 11) {
				$source = "PGD";
			}
		}

		if (!preg_match("/^[0-9]{10}$/", $customer_phone)) {

			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Bạn chưa nhập đúng số điện thoại"
			];
			$this->pushJson('200', json_encode($response));
			return;
		}


		if (!empty($identify_lead)) {
			if (!empty($checkData->data)) {
				for ($i = 0; $i < count($checkData->data); $i++) {
					if ($checkData->data[$i]->customer_identity_card == $identify_lead) {
						$response = [
							'res' => false,
							'status' => "400",
							'msg' => "Dữ liệu đã do bộ phận " . $source . " tạo. Người dùng không được tạo nữa"
						];
						$this->pushJson('200', json_encode($response));
						return;
					}
				}
			}
		}


		if (!empty($checkData->data)) {
			for ($i = 0; $i < count($checkData->data); $i++) {
				if ($checkData->data[$i]->phone_number == $customer_phone && $check->data->status != 19) {
					$response = [
						'res' => false,
						'status' => "400",
						'msg' => "Dữ liệu đã do bộ phận " . $source . " tạo. Người dùng không được tạo nữa"
					];
					$this->pushJson('200', json_encode($response));
					return;
				}

			}
		}

		$data = array(
			"identify_lead" => $identify_lead,
			"source" => $customer_source,
			"address" => $address,
			"phone_number" => $customer_phone,
			"fullname" => $customer_fullname,
			"status_sale" => 30,
			"created_by" => $this->userInfo['email']
		);

		$return = $this->api->apiPost($this->user['token'], "lead_custom/create_lead_pgd", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'msg' => 'Thêm mới khách hàng thành công',
				'url' => $return->url
			];
			$this->pushJson('200', json_encode($response));
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => 'Thêm mới khách hàng không thành công,lead trong các trạng thái chưa xử lý dứt điểm',
				'data' => $return
			];
			$this->pushJson('200', json_encode($response));
			return;
		}

	}

	public function showNote($id)
	{
		$id = $this->security->xss_clean($id);
		$condition = array("id" => $id);
		$note = $this->api->apiPost($this->user['token'],"recording/get_one_note",$condition);
		$response = [
			'status' => "200",
			'msg' => 'ok',
			'data' => $note
		];
		$this->pushJson('200', json_encode($response));
		return;

	}

	public function saveMissedCall()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : "";
		$name = !empty($data['name']) ? $data['name'] : "";
		$date = !empty($data['date']) ? $data['date'] : "";
		$address = !empty($data['address']) ? $data['address'] : "";
		$cmt = !empty($data['cmt']) ? $data['cmt'] : "";
		$noteMissedCall = !empty($data['noteMissedCall']) ? $data['noteMissedCall'] : "";
		if (!empty($cmt)) {
			if (!preg_match("/^[0-9]{9,12}$/", $cmt)) {
				$this->pushJson('200', json_encode(array("status" => "400", "msg" => "CMND/CCCD không đúng định dạng")));
				$response = [
				'status' => "200",
				'msg' => "CMND/CCCD không đúng định dạng" ,
			];
				//echo json_encode($response);
				return;
			}
		}
		$dataInsert = [
			"id" => $id,
			"name" => $name,
			"date" => $date,
			"address" => $address,
			'cmt' => $cmt,
			'noteMissedCall'=>$noteMissedCall
		];
		$result = $this->api->apiPost($this->user['token'], "recording/insert_note", $dataInsert);
		$response = [
			'status' => "200",
			'msg' => 'Cập nhật thành công',
		];
		echo json_encode($response);
		return ;

	}


}

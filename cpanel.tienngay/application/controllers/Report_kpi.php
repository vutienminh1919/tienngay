<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Report_kpi extends MY_Controller{
    public function __construct(){
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url', 'file'));
		$this->load->helper('lead_helper');
		$this->load->model("main_property_model");
		$this->load->model('config_gic_model');
		$this->load->model("time_model");
		$this->load->library('pagination');
		$this->config->load('config');
          $this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
//        if (!$this->is_superadmin) {
//            $paramController = $this->uri->segment(1);
//            $param = strtolower($paramController);
//            if (!in_array($param, $this->paramMenus)) {
//                $this->session->set_flashdata('error', $this->lang->line('not_have_permission').' '.$paramController .'!');
//                redirect(base_url('app'));
//                return;
//            }
//        }
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }
    public function kpi_domain(){
          try{
        $this->data["pageName"] = "Dashboard";
         $this->data['template'] = 'page/report_kpi/kpi';
        $start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
        $end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

            $cond = array(
                "start" => $start,
                "end" => $end,
            );
            $res = $this->api->apiPost($this->user['token'], "report_kpi/kpi_domain",$cond);
            if (!empty($res->status) && $res->status == 200) {
            $this->data['data'] = $res->data;
           }else{
            $this->data['data'] = array();
           }
        
        $this->load->view('template', isset($this->data)?$this->data:NULL);
        }catch (\Exception $exception){
            $this->data['data'] = '';
            $this->load->view('template', isset($this->data)?$this->data:NULL);
        }
    }

	public function kpi_domain_v2(){
		try{

			$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
			$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
			$search_status = !empty($_GET['search_status']) ? $_GET['search_status'] : "Đang xử lý";

			$cond = array(
				"start" => $start,
				"end" => $end,
			);

			if (!empty($start)) {
				$data['start'] = $start;
			}
			if (!empty($end)) {
				$data['end'] = $end;
			}
			if (!empty($search_status)) {
				$data['search_status'] = $search_status;
			}

			$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
			if (!empty($groupRoles->status) && $groupRoles->status == 200) {
				$this->data['groupRoles'] = $groupRoles->data;
			} else {
				$this->data['groupRoles'] = array();
			}


			if (!empty($groupRoles->status) && $groupRoles->status == 200) {
				if(in_array('giao-dich-vien', $groupRoles->data) && !in_array('van-hanh', $groupRoles->data) && !in_array('hoi-so', $groupRoles->data) && !in_array('cua-hang-truong', $groupRoles->data)){
					$res = $this->api->apiPost($this->user['token'], "report_kpi/kpi_domain",$cond);
					if (!empty($res->status) && $res->status == 200) {
						$this->data['data'] = $res->data;
					}else{
						$this->data['data'] = array();
					}

					$this->get_contract($data);

					$this->data["pageName"] = "Dashboard";
					$this->data['template'] = 'page/dashboard_v2/nhanvien.php';
				} elseif (in_array('cua-hang-truong', $groupRoles->data) && !in_array('van-hanh', $groupRoles->data) && !in_array('hoi-so', $groupRoles->data) && !in_array('quan-ly-khu-vuc', $groupRoles->data)){
					$res = $this->api->apiPost($this->user['token'], "report_kpi/kpi_domain",$cond);
					if (!empty($res->status) && $res->status == 200) {
						$this->data['data'] = $res->data;
					}else{
						$this->data['data'] = array();
					}

					$this->get_contract($data);

					$this->data["pageName"] = "Dashboard";
					$this->data['template'] = 'page/dashboard_v2/lead.php';
				} elseif(in_array('quan-ly-khu-vuc', $groupRoles->data) && !in_array('quan-ly-cap-cao', $groupRoles->data)){
					$res = $this->api->apiPost($this->user['token'], "report_kpi/kpi_domain",$cond);
					if (!empty($res->status) && $res->status == 200) {
						$this->data['data'] = $res->data;
					}else{
						$this->data['data'] = array();
					}

					$this->get_contract($data);

					$this->data["pageName"] = "Dashboard";
					$this->data['template'] = 'page/dashboard_v2/asm.php';
				} elseif(in_array('quan-ly-cap-cao', $groupRoles->data)){
					$res = $this->api->apiPost($this->user['token'], "report_kpi/kpi_domain",$cond);
					if (!empty($res->status) && $res->status == 200) {
						$this->data['data'] = $res->data;
					}else{
						$this->data['data'] = array();
					}
					$this->data["pageName"] = "Dashboard";
					$this->data['template'] = 'page/dashboard_v2/manager.php';
				} else {
					redirect(base_url('app'));
				}


			}
			$this->load->view('template', isset($this->data)?$this->data:NULL);

		}catch (\Exception $exception){
			$this->data['data'] = '';
			$this->load->view('template', isset($this->data)?$this->data:NULL);
		}
	}

	public function get_contract($data){
		$countContractData = $this->api->apiPost($this->userInfo['token'], "contract/get_count_all", $data);

		if (!empty($countContractData->status) && $countContractData->status == 200 && $countContractData->data != 0) {

			$count = (int)$countContractData->data;
			$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
			$config = $this->config->item('pagination');
			$config['base_url'] = base_url('report_kpi/kpi_domain_v2');
			$config['total_rows'] = $count;
			$config['per_page'] = 30;
			$config['page_query_string'] = true;
			$config['uri_segment'] = $uriSegment;
			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();
			$this->data['countContract'] = $count;

			$data["per_page"] = $config['per_page'];
			$data["uriSegment"] = $config['uri_segment'];

			$contractData = $this->api->apiPost($this->userInfo['token'], "contract/get_all_data", $data);

			if (!empty($contractData->status) && $contractData->status == 200) {
				$this->data['contractData'] = $contractData->data;
				$this->data['count'] = $countContractData->data;

			} else {
				$this->data['contractData'] = array();
				$this->data['count'] = [];
			}
		} else {
			$this->data['contractData'] = array();
		}
	}

	public function index_report_synthetic(){

		$data = [];
		$month = !empty($_GET['month']) ? $_GET['month'] : date('Y-m');
		if (!empty($month)) {
			$data['month'] = $month;
		}


		$resultData = $this->api->apiPost($this->userInfo['token'], "report_kpi/report_synthetic_data", $data);

		if (!empty($resultData->status) && $resultData->status == 200) {
			$this->data['data'] = $resultData->data;
		} else {
			$this->data['data'] = array();
		}


		$this->data['template'] = 'page/dashboard_v2/report_synthetic.php';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}


	public function index_report_debt(){

		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : date('Y-m-d');
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : date('Y-m-d');
		if (!empty($fdate)) {
			$data['fdate'] = $fdate;
		}
		if (!empty($tdate)) {
			$data['tdate'] = $tdate;
		}

    	$countContractData = $this->api->apiPost($this->userInfo['token'], "report_kpi/get_count_all_mongo_read", $data);

		if (!empty($countContractData->status) && $countContractData->status == 200 && $countContractData->data != 0) {

			$count = (int)$countContractData->data;
			$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
			$config = $this->config->item('pagination');
			$config['base_url'] = base_url('report_kpi/index_report_debt?fdate=' . $fdate . '&tdate=' . $tdate);
			$config['total_rows'] = $count;
			$config['per_page'] = 30;
			$config['page_query_string'] = true;
			$config['uri_segment'] = $uriSegment;
			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();
			$this->data['countContract'] = $count;

			$data["per_page"] = $config['per_page'];
			$data["uriSegment"] = $config['uri_segment'];

			$contractData = $this->api->apiPost($this->userInfo['token'], "report_kpi/get_all_data_mongo_read", $data);

			if (!empty($contractData->status) && $contractData->status == 200) {
				$this->data['contractData'] = $contractData->data;

			} else {
				$this->data['contractData'] = array();

			}
		} else {
			$this->data['contractData'] = array();
		}


		$this->data['template'] = 'page/pawn/report_debt/index_debt.php';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function index_report_debt_total()
	{

		$date = !empty($_GET['date']) ? $_GET['date'] : date('Y-m-d');
		$data = [];
		if (!empty($date)) {
			$data['date'] = $date;
		}

		$contractData = $this->api->apiPost($this->userInfo['token'], "report_kpi/get_all_data_total_mongo_read", $data);

		if (!empty($contractData->status) && $contractData->status == 200) {
			$this->data['contractData'] = $contractData->data;

		} else {
			$this->data['contractData'] = array();

		}


		$this->data['template'] = 'page/pawn/report_debt/index_debt_total.php';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function index_report_debt_total_bds(){
		$date = !empty($_GET['date']) ? $_GET['date'] : date('Y-m-d');
		$data = [];
		if (!empty($date)) {
			$data['date'] = $date;
		}

		$contractData = $this->api->apiPost($this->userInfo['token'], "report_kpi/get_all_data_total_bds_mongo_read", $data);

		if (!empty($contractData->status) && $contractData->status == 200) {
			$this->data['contractData'] = $contractData->data;

		} else {
			$this->data['contractData'] = array();

		}


		$this->data['template'] = 'page/pawn/report_debt/index_debt_total_bds.php';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

}

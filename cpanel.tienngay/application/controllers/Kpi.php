<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
class Kpi extends MY_Controller
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


    public function doUpdateStatusKPI()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$status = ($status=='true') ? 'active' : 'deactive';
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_kpi_selected_deletion')
			];
			echo json_encode($response);
			return;
		}
			if (empty($status)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_kpi_selected_deletion')
			];
			echo json_encode($response);
			return;
		}
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		$data = array(
			"status" => $status,
			"updated_at" => $createdAt,
			"updated_by" => $this->userInfo['email'],
			"id" => $id
		);
		$return = $this->api->apiPost($this->userInfo['token'], "kpi/update_kpi", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_kpi')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('KPI_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}
	public function doUpdateKPI()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		$title_vi = !empty($_POST['title_vi']) ? $_POST['title_vi'] : "";
		$content_vi = !empty($_POST['content_vi']) ? $_POST['content_vi'] : "";
		$title_en = !empty($_POST['title_en']) ? $_POST['title_en'] : "";
		$content_en = !empty($_POST['content_en']) ? $_POST['content_en'] : "";
		$type = !empty($_POST['type_kpi']) ? $_POST['type_kpi'] : "";
		$status = !empty($_POST['status']) ? $_POST['status'] : "";
	
		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		if (empty($title_vi)) {
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('KPI_title_empty')
			];
			echo json_encode($response);
			return;
		}
		
		if (empty($content_vi)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('KPI_content_empty')
			];
			echo json_encode($response);
			return;
		}
		$data = array(
			"title_vi" => $title_vi,
			"link" => slugify($title_vi),
			"content_vi" => $content_vi,
			"title_en" => $title_en,
			"content_en" => $content_en,
			"type_kpi" => $type,
			"status" => $status,
			"updated_at" => $updateAt,
			"updated_by" => $this->userInfo['email'],
			"id"=>$id

		);
		$return = $this->api->apiPost($this->userInfo['token'], "kpi/update_kpi", $data);
      // die;
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successful_kpi_update')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Failed_kpi_update'),
				'data'=>$image
			];
			echo json_encode($response);
			return;
		}
	}

	public function update_area()
	{
		$data = $this->input->post();
		$data['field'] = $this->security->xss_clean($data['field']);
		$data['value'] = $this->security->xss_clean($data['value']);
		$data['id'] = $this->security->xss_clean($data['id']);

		$condition = array(
			'id' => $data['id'],
			$data['field'] => $data['value'],
			"updated_by" => $this->user['email']
			

		);
		
		$return = $this->api->apiPost($this->user['token'], "kpi/update_kpi_area", $condition);
		//$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
	}
		public function update_pgd()
	{
		$data = $this->input->post();
		$data['field'] = $this->security->xss_clean($data['field']);
		$data['value'] = $this->security->xss_clean($data['value']);
		$data['id'] = $this->security->xss_clean($data['id']);

		$condition = array(
			'id' => $data['id'],
			$data['field'] => $data['value'],
			"updated_by" => $this->user['email']
			

		);
		
		$return = $this->api->apiPost($this->user['token'], "kpi/update_kpi_pgd", $condition);
		//$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
	}
		public function update_gdv()
	{
		$data = $this->input->post();
		$data['field'] = $this->security->xss_clean($data['field']);
		$data['value'] = $this->security->xss_clean($data['value']);
		$data['id'] = $this->security->xss_clean($data['id']);

		$condition = array(
			'id' => $data['id'],
			$data['field'] => $data['value'],
			"updated_by" => $this->user['email']
			

		);
		
		$return = $this->api->apiPost($this->user['token'], "kpi/update_kpi_gdv", $condition);
		//$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
	}
    public function listDetailKPI_pgd()
	{
		$this->data["pageName"] = "Chi tiết số liệu KPI phòng giao dịch";
		
		$investor_code = !empty($_GET['investor']) ? $_GET['investor'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "17";
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$code_store = !empty($_GET['code_store']) ? $_GET['code_store'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		
		$customer_email = !empty($_GET['customer_email']) ? $_GET['customer_email'] : "";
	$code_domain = !empty($_GET['code_domain']) ? $_GET['code_domain'] : "";
	$code_region = !empty($_GET['code_region']) ? $_GET['code_region'] : "";
	$code_area = !empty($_GET['code_area']) ? $_GET['code_area'] : "";
	$url_code_store='';
	$url_code_region='';
	$url_code_area='';
	$url_code_domain='';
	   if (is_array($code_store)) {
			foreach ($code_store as $code) {
				array_push($code_store, $code);
				$url_code_store .= '&code_store[]=' . $code;
			}
		}
		if (is_array($code_domain)) {
			foreach ($code_domain as $code) {
				array_push($code_domain, $code);
				$url_code_domain .= '&code_domain[]=' . $code;
			}
		}
		if (is_array($code_region)) {
			foreach ($code_region as $code) {
				array_push($code_region, $code);
				$url_code_region .= '&code_region[]=' . $code;
			}
		}
		if (is_array($code_area)) {
			foreach ($code_area as $code) {
				array_push($code_area, $code);
				$url_code_area .= '&code_area[]=' . $code;
			}
		}
		// điều kiện để lấy bản ghi
		$condition = array(
			'status_disbursement' => 3, //1 moi tao, 2: tạo giải ngân thành công, 3// tiền đến với khách, 4 thất bại
			'status' => $status   // 17: giải ngân thành công, 18: giải ngân thất bại
		);
	
		if (!empty($_GET['fdate']) ) {
			$condition['start'] = $start;
			
		}
		if (!empty($code_area)) {
			$condition['code_area'] = $code_area;
		}
		if (!empty($code_region)) {
			$condition['code_region'] = $code_region;
		}
		if (!empty($code_domain)) {
			$condition['code_domain'] = $code_domain;
		}
		if (!empty($code_store)) {
			$condition['code_store'] = $code_store;
		}
		
		
		if (!empty($customer_email)) {
			$condition['customer_email'] = $customer_email;
		}
		
		$data = array(
			"condition" => $condition
		);

		$count = 0;
		$total = $this->api->apiPost($this->userInfo['token'], "report_kpi/get_detail_kpi_pgd", $data);
        $config = $this->config->item('pagination');
		if (!empty($total->status) && $total->status == 200 && $total->total != 0) {
			$count = $total->total;
			$offset = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
			
			$config['base_url'] = base_url('kpi/listDetailKPI_pgd?fdate=' . $start . '&tdate=' . $end . '&customer_email=' . $customer_email .$url_code_domain.$url_code_area.$url_code_region . $url_code_store );
			$config['total_rows'] = $count;
			$config['per_page'] = 30;
			$config['enable_query_strings'] = true;
			$config['page_query_string'] = true;
			$config['uri_segment'] = $offset;
			$this->pagination->initialize($config);
            $this->data['result_count'] = "Hiển thị " . $config['total_rows'] . " Kết quả";
			$this->data['pagination'] = $this->pagination->create_links();
			// call api get contract data
			$data = array(
				"condition" => $condition,
				"per_page" => $config['per_page'],
				"uriSegment" => $config['uri_segment']
			);
			//var_dump( $data); die;
			$kpiData = $this->api->apiPost($this->userInfo['token'], "report_kpi/get_detail_kpi_pgd", $data);
			if (!empty($kpiData->status) && $kpiData->status == 200) {
				$this->data['kpiData'] = $kpiData->data;
				$this->data['sum_giai_ngan'] = $kpiData->sum->sum_giai_ngan;
				$this->data['sum_bao_hiem'] = $kpiData->sum->sum_bao_hiem;
				$this->data['count_khach_hang_moi'] = $kpiData->sum->count_khach_hang_moi;
			} else {
				$this->data['kpiData'] = array();
			}
		}
		
		//get store
		$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all");
		if (!empty($storeData->status) && $storeData->status == 200) {
			$this->data['storeData'] = $storeData->data;
		} else {
			$this->data['storeData'] = array();
		}
		//get store
		$areaData = $this->api->apiPost($this->userInfo['token'], "area/get_all");
		if (!empty($areaData->status) && $areaData->status == 200) {
			$this->data['areaData'] = $areaData->data;
		} else {
			$this->data['areaData'] = array();
		}

		$this->data['template'] = 'page/kpi/list_detail_report_kpi';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;

		
	}
	public function listDetailKPI_user()
	{
		$this->data["pageName"] = "Chi tiết số liệu KPI phòng giao dịch";
		
		$investor_code = !empty($_GET['investor']) ? $_GET['investor'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "17";
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$code_store = !empty($_GET['code_store']) ? $_GET['code_store'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";

		$customer_email = !empty($_GET['customer_email']) ? $_GET['customer_email'] : "";
	$code_domain = !empty($_GET['code_domain']) ? $_GET['code_domain'] : "";
	$code_region = !empty($_GET['code_region']) ? $_GET['code_region'] : "";
	$code_area = !empty($_GET['code_area']) ? $_GET['code_area'] : "";
	$url_code_store='';
	$url_code_region='';
	$url_code_area='';
	$url_code_domain='';
	   if (is_array($code_store)) {
			foreach ($code_store as $code) {
				array_push($code_store, $code);
				$url_code_store .= '&code_store[]=' . $code;
			}
		}
		if (is_array($code_domain)) {
			foreach ($code_domain as $code) {
				array_push($code_domain, $code);
				$url_code_domain .= '&code_domain[]=' . $code;
			}
		}
		if (is_array($code_region)) {
			foreach ($code_region as $code) {
				array_push($code_region, $code);
				$url_code_region .= '&code_region[]=' . $code;
			}
		}
		if (is_array($code_area)) {
			foreach ($code_area as $code) {
				array_push($code_area, $code);
				$url_code_area .= '&code_area[]=' . $code;
			}
		}
		// điều kiện để lấy bản ghi
		$condition = array(
			'status_disbursement' => 3, //1 moi tao, 2: tạo giải ngân thành công, 3// tiền đến với khách, 4 thất bại
			'status' => $status   // 17: giải ngân thành công, 18: giải ngân thất bại
		);
		if (!empty($_GET['fdate']) ) {
			$condition['start'] = $start;
			
		}
		if (!empty($code_area)) {
			$condition['code_area'] = $code_area;
		}
		if (!empty($code_region)) {
			$condition['code_region'] = $code_region;
		}
		if (!empty($code_domain)) {
			$condition['code_domain'] = $code_domain;
		}
		if (!empty($code_store)) {
			$condition['code_store'] = $code_store;
		}
		
		
		if (!empty($customer_email)) {
			$condition['customer_email'] = $customer_email;
		}
		
		$data = array(
			"condition" => $condition
		);

		$count = 0;
		$total = $this->api->apiPost($this->userInfo['token'], "report_kpi/get_detail_kpi_user", $data);
        $config = $this->config->item('pagination');
		if (!empty($total->status) && $total->status == 200 && $total->total != 0) {
			$count = $total->total;
			$offset = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
			
			$config['base_url'] = base_url('kpi/listDetailKPI_user?fdate=' . $start . '&tdate=' . $end . '&customer_email=' . $customer_email .$url_code_domain.$url_code_area.$url_code_region . $url_code_store );
			$config['total_rows'] = $count;
			$config['per_page'] = 30;
			$config['enable_query_strings'] = true;
			$config['page_query_string'] = true;
			$config['uri_segment'] = $offset;
			$this->pagination->initialize($config);
            $this->data['result_count'] = "Hiển thị " . $config['total_rows'] . " Kết quả";
			$this->data['pagination'] = $this->pagination->create_links();
			// call api get contract data
			$data = array(
				"condition" => $condition,
				"per_page" => $config['per_page'],
				"uriSegment" => $config['uri_segment']
			);
			//var_dump( $data); die;
			$kpiData = $this->api->apiPost($this->userInfo['token'], "report_kpi/get_detail_kpi_user", $data);
			if (!empty($kpiData->status) && $kpiData->status == 200) {
				$this->data['kpiData'] = $kpiData->data;
				$this->data['sum_giai_ngan'] = $kpiData->sum->sum_giai_ngan;
				$this->data['sum_bao_hiem'] = $kpiData->sum->sum_bao_hiem;
				$this->data['count_khach_hang_moi'] = $kpiData->sum->count_khach_hang_moi;
			} else {
				$this->data['kpiData'] = array();
			}
		}
		
		//get store
		$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all");
		if (!empty($storeData->status) && $storeData->status == 200) {
			$this->data['storeData'] = $storeData->data;
		} else {
			$this->data['storeData'] = array();
		}
		//get store
		$areaData = $this->api->apiPost($this->userInfo['token'], "area/get_all");
		if (!empty($areaData->status) && $areaData->status == 200) {
			$this->data['areaData'] = $areaData->data;
		} else {
			$this->data['areaData'] = array();
		}
		
		
		$this->data['template'] = 'page/kpi/list_detail_report_kpi_user';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
		return;

		
	}
	public function listKPI_pgd()
	{
		$this->data["pageName"] ='QL KPI phòng giao dịch';
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$data = array();
		$data['start'] = $start;
		$kpiData = $this->api->apiPost($this->userInfo['token'], "kpi/get_all_pgd", $data);
		if (!empty($kpiData->status) && $kpiData->status == 200) {
			$this->data['kpiData'] = $kpiData->data;
		} else {
			$this->data['kpiData'] = array();
		}
		

		$this->data['template'] = 'page/kpi/list_kpi_pgd';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
	public function listKPI_gdv()
	{
		$this->data["pageName"] = 'QL KPI giao dịch viên';
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		
		$data = array();
		$data['start'] = $start;
		$data['code_store'] = $code_store;
		$kpiData = $this->api->apiPost($this->userInfo['token'], "kpi/get_all_gdv", $data);

		if (!empty($kpiData->status) && $kpiData->status == 200) {

			$this->data['kpiData'] = $kpiData->data;
		} else {
			$this->data['kpiData'] = array();
		}
		$storeData = $this->api->apiPost($this->user['token'], "store/get_all", []);
		if (!empty($storeData->status) && $storeData->status == 200) {
			$this->data['storeData'] = $storeData->data;
			$this->data['stores'] = $storeData->stores;
		} else {
			$this->data['storeData'] = array();
		}
		$this->data['template'] = 'page/kpi/list_kpi_gdv';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
	public function listKPI_area()
	{
		$this->data["pageName"] = 'QL KPI vùng';
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$data = array();
		$data['start'] = $start;
		$kpiData = $this->api->apiPost($this->userInfo['token'], "kpi/get_all_area", $data);
		if (!empty($kpiData->status) && $kpiData->status == 200) {
			$this->data['kpiData'] = $kpiData->data;
		} else {
			$this->data['kpiData'] = array();
		}
		$this->data['template'] = 'page/kpi/list_kpi_area';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
   public function listBaohiem()
	{
		$this->data["pageName"] ='Quản lý bảo hiểm';
		$data = array(
		);
		$baohiemData = $this->api->apiPost($this->userInfo['token'], "bao_hiem_pgd/get_all", $data);
		if (!empty($baohiemData->status) && $baohiemData->status == 200) {
			$this->data['baohiemData'] = $baohiemData->data;
		} else {
			$this->data['baohiemData'] = array();
		}
		$this->data['template'] = 'page/kpi/list_baohiem';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
	public function doAddKpi_area()
	{
		 $start = !empty($_POST['fdate_export']) ? $_POST['fdate_export'] : "";

		
		
		if (empty($start)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' =>'Bạn cần chọn tháng KPI'
			];
			echo json_encode($response);
			return;
		}
		
		
		$data = array(
			"start" => $start
		

		);
       
		$return = $this->api->apiPost($this->userInfo['token'], "kpi/create_kpi_area", $data);
		
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('create_kpi_success')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('create_kpi_failed')
			];
			echo json_encode($response);
			return;
		}
	}
    public function doAddKpi_pgd()
	{
		 $start = !empty($_POST['fdate_export']) ? $_POST['fdate_export'] : "";
		if (empty($start)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' =>'Bạn cần chọn tháng KPI'
			];
			echo json_encode($response);
			return;
		}
		
		$data = array(
			"start" => $start
		
		);
       
		$return = $this->api->apiPost($this->userInfo['token'], "kpi/create_kpi_pgd", $data);
		
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('create_kpi_success')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('create_kpi_failed')
			];
			echo json_encode($response);
			return;
		}
	}
	public function doAddKpi_gdv()
	{
		 $start = !empty($_POST['fdate_export']) ? $_POST['fdate_export'] : "";
          $code_store = !empty($_POST['code_store']) ? $_POST['code_store'] : "";
		
		
		if (empty($start)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' =>'Bạn cần chọn tháng KPI'
			];
			echo json_encode($response);
			return;
		}
			if (empty($code_store)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' =>'Bạn cần chọn PGD'
			];
			echo json_encode($response);
			return;
		}
		$data = array(
			"start" => $start,
			"code_store" => $code_store
		);
       
		$return = $this->api->apiPost($this->userInfo['token'], "kpi/create_kpi_gdv", $data);
		
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('create_kpi_success')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('create_kpi_failed')
			];
			echo json_encode($response);
			return;
		}
	}
	public function createKPI()
	{
		$this->data["pageName"] = $this->lang->line('create_kpi');
		$this->data['template'] = 'page/kpi/add_kpi';
		//get province
		$data = array(// "type_login" => 1
		);
		
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function get_district_by_province()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";

		$data = array(
			// "type_login" => 1,
			"id" => $id
		);

		$districtData = $this->api->apiPost($this->userInfo['token'], "province/get_district_by_province", $data);
		if (!empty($districtData->status) && $districtData->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $districtData->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('no_depreciation_configured')
			];
			echo json_encode($response);
			return;
		}

	}

	public function get_ward_by_district()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		$data = array(
			// "type_login" => 1,
			"id" => $id
		);
		$wardData = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", $data);
		if (!empty($wardData->status) && $wardData->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $wardData->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('no_depreciation_configured')
			];
			echo json_encode($response);
			return;
		}

	}
	private function pushJson($code, $data)
	{
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}

	public function listDetailKPI_pgd_v2()
	{
		$this->data["pageName"] = "Chi tiết số liệu KPI phòng giao dịch";

		$status = "17";

		$start = !empty($_POST['fdate']) ? $_POST['fdate']  : "";

		$code_store = !empty($_GET['code_store']) ? $_GET['code_store'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";

		$customer_email = !empty($_GET['customer_email']) ? $_GET['customer_email'] : "";
		$code_domain = !empty($_GET['code_domain']) ? $_GET['code_domain'] : "";
		$code_region = !empty($_GET['code_region']) ? $_GET['code_region'] : "";
		$code_area = !empty($_GET['code_area']) ? $_GET['code_area'] : "";
		$url_code_store='';
		$url_code_region='';
		$url_code_area='';
		$url_code_domain='';
		if (is_array($code_store)) {
			foreach ($code_store as $code) {
				array_push($code_store, $code);
				$url_code_store .= '&code_store[]=' . $code;
			}
		}
		if (is_array($code_domain)) {
			foreach ($code_domain as $code) {
				array_push($code_domain, $code);
				$url_code_domain .= '&code_domain[]=' . $code;
			}
		}
		if (is_array($code_region)) {
			foreach ($code_region as $code) {
				array_push($code_region, $code);
				$url_code_region .= '&code_region[]=' . $code;
			}
		}
		if (is_array($code_area)) {
			foreach ($code_area as $code) {
				array_push($code_area, $code);
				$url_code_area .= '&code_area[]=' . $code;
			}
		}
		// điều kiện để lấy bản ghi
		$condition = array(
			'status_disbursement' => 3, //1 moi tao, 2: tạo giải ngân thành công, 3// tiền đến với khách, 4 thất bại
			'status' => $status   // 17: giải ngân thành công, 18: giải ngân thất bại
		);

		if (!empty($start) ) {
			$condition['start'] = $start;
		}

		if (!empty($code_area)) {
			$condition['code_area'] = $code_area;
		}
		if (!empty($code_region)) {
			$condition['code_region'] = $code_region;
		}
		if (!empty($code_domain)) {
			$condition['code_domain'] = $code_domain;
		}
		if (!empty($code_store)) {
			$condition['code_store'] = $code_store;
		}


		if (!empty($customer_email)) {
			$condition['customer_email'] = $customer_email;
		}

		$data = array(
			"condition" => $condition
		);

		$count = 0;
		$total = $this->api->apiPost($this->userInfo['token'], "report_kpi/get_detail_kpi_pgd", $data);
		$config = $this->config->item('pagination');
		if (!empty($total->status) && $total->status == 200 && $total->total != 0) {
			$count = $total->total;
			$offset = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;

			$config['base_url'] = base_url('kpi/listDetailKPI_pgd?fdate=' . $start . '&tdate=' . $end . '&customer_email=' . $customer_email .$url_code_domain.$url_code_area.$url_code_region . $url_code_store );
			$config['total_rows'] = $count;
			$config['per_page'] = 30;
			$config['enable_query_strings'] = true;
			$config['page_query_string'] = true;
			$config['uri_segment'] = $offset;
			$this->pagination->initialize($config);
			$this->data['result_count'] = "Hiển thị " . $config['total_rows'] . " Kết quả";
			$this->data['pagination'] = $this->pagination->create_links();
			// call api get contract data
			$data = array(
				"condition" => $condition,
				"per_page" => $config['per_page'],
				"uriSegment" => $config['uri_segment']
			);
			//var_dump( $data); die;
			$kpiData = $this->api->apiPost($this->userInfo['token'], "report_kpi/get_detail_kpi_pgd", $data);
			if (!empty($kpiData->status) && $kpiData->status == 200) {
				$this->data['kpiData'] = $kpiData->data;
				$this->data['sum_giai_ngan'] = $kpiData->sum->sum_giai_ngan;
				$this->data['sum_bao_hiem'] = $kpiData->sum->sum_bao_hiem;
				$this->data['count_khach_hang_moi'] = $kpiData->sum->count_khach_hang_moi;
			} else {
				$this->data['kpiData'] = array();
			}
		}

		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			if((!in_array('giao-dich-vien', $groupRoles->data) && !in_array('cua-hang-truong', $groupRoles->data)) || (in_array('phat-trien-san-pham', $groupRoles->data))){
				$this->data["pageName"] = "Dashboard";
				$this->data['template'] = 'page/dashboard_v2/manager.php';
			}
			if (in_array('quan-ly-khu-vuc', $groupRoles->data) && !in_array('quan-ly-cap-cao', $groupRoles->data) ){
				$this->data["pageName"] = "Dashboard";
				$this->data['template'] = 'page/dashboard_v2/asm.php';
			}
			if (in_array('cua-hang-truong', $groupRoles->data) && !in_array('giao-dich-vien', $groupRoles->data)){
				$this->data["pageName"] = "Dashboard";
				$this->data['template'] = 'page/dashboard_v2/lead.php';
			}
		}

		$response = [
			'res' => true,
			'status' => "200",
			'data' => $kpiData->data
		];
		echo json_encode($response);


	}

	public function listUserPgd(){

		$status = "17";

		$start = !empty($_POST['fdate']) ? $_POST['fdate']  : "";

		$code_store = !empty($_GET['code_store']) ? $_GET['code_store'] : "";

		$condition = array(
			'status_disbursement' => 3, //1 moi tao, 2: tạo giải ngân thành công, 3// tiền đến với khách, 4 thất bại
			'status' => $status   // 17: giải ngân thành công, 18: giải ngân thất bại
		);


	}

	public function listDetailKPI_user_v2()
	{
		$this->data["pageName"] = "Chi tiết số liệu KPI phòng giao dịch";

		$status = "17";

		$start = !empty($_POST['fdate']) ? $_POST['fdate']  : "";

		$code_store = !empty($_GET['store_id']) ? $_GET['store_id'] : "";

		$customer_email = !empty($_GET['customer_email']) ? $_GET['customer_email'] : "";
		$code_domain = !empty($_GET['code_domain']) ? $_GET['code_domain'] : "";
		$code_region = !empty($_GET['code_region']) ? $_GET['code_region'] : "";
		$code_area = !empty($_GET['code_area']) ? $_GET['code_area'] : "";
		$url_code_store='';
		$url_code_region='';
		$url_code_area='';
		$url_code_domain='';
		if (is_array($code_store)) {
			foreach ($code_store as $code) {
				array_push($code_store, $code);
				$url_code_store .= '&code_store[]=' . $code;
			}
		}
		if (is_array($code_domain)) {
			foreach ($code_domain as $code) {
				array_push($code_domain, $code);
				$url_code_domain .= '&code_domain[]=' . $code;
			}
		}
		if (is_array($code_region)) {
			foreach ($code_region as $code) {
				array_push($code_region, $code);
				$url_code_region .= '&code_region[]=' . $code;
			}
		}
		if (is_array($code_area)) {
			foreach ($code_area as $code) {
				array_push($code_area, $code);
				$url_code_area .= '&code_area[]=' . $code;
			}
		}
		// điều kiện để lấy bản ghi
		$condition = array(
			'status_disbursement' => 3, //1 moi tao, 2: tạo giải ngân thành công, 3// tiền đến với khách, 4 thất bại
			'status' => $status   // 17: giải ngân thành công, 18: giải ngân thất bại
		);

		if (!empty($start) ) {
			$condition['start'] = $start;
		}

		if (!empty($code_area)) {
			$condition['code_area'] = $code_area;
		}
		if (!empty($code_region)) {
			$condition['code_region'] = $code_region;
		}
		if (!empty($code_domain)) {
			$condition['code_domain'] = $code_domain;
		}
		if (!empty($code_store)) {
			$condition['code_store'] = $code_store;
		}


		if (!empty($customer_email)) {
			$condition['customer_email'] = $customer_email;
		}

		$data = array(
			"condition" => $condition
		);

		$count = 0;

		$config = $this->config->item('pagination');

		$count = $total->total;
		$offset = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;

		$config['base_url'] = base_url('kpi/listDetailKPI_user_v2?fdate=' . $start . '&tdate=' . $end . '&customer_email=' . $customer_email . '&store_id=' . $store_id);
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $offset;
		$this->pagination->initialize($config);
		$this->data['result_count'] = "Hiển thị " . $config['total_rows'] . " Kết quả";
		$this->data['pagination'] = $this->pagination->create_links();
			// call api get contract data
		$data = array(
			"condition" => $condition,
			"per_page" => $config['per_page'],
			"uriSegment" => $config['uri_segment']
		);

		//var_dump( $data); die;
		$kpiData = $this->api->apiPost($this->userInfo['token'], "report_kpi/get_detail_kpi_user_v2", $data);

			if (!empty($kpiData->status) && $kpiData->status == 200) {
				$this->data['kpiData'] = $kpiData->data;
				$this->data['sum_giai_ngan'] = $kpiData->sum->sum_giai_ngan;
				$this->data['sum_bao_hiem'] = $kpiData->sum->sum_bao_hiem;
				$this->data['count_khach_hang_moi'] = $kpiData->sum->count_khach_hang_moi;
			} else {
				$this->data['kpiData'] = array();
			}


		$response = [
			'res' => true,
			'status' => "200",
			'data' => $kpiData->data
		];
		echo json_encode($response);


	}

	public function detail_code_area_dashboard(){

		try{

			$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
			$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
			$search_status = !empty($_GET['search_status']) ? $_GET['search_status'] : "Đang xử lý";

			$code_area = !empty($_GET['code_area']) ? $_GET['code_area'] : "";

			$cond = array(
				"start" => $start,
				"end" => $end,
				"code_area" => $code_area
			);
			$res = $this->api->apiPost($this->user['token'], "report_kpi/kpi_domain_detail",$cond);

			if (!empty($res->status) && $res->status == 200) {
				$this->data['data'] = $res->data;
			}else{
				$this->data['data'] = array();
			}

			//
			if (!empty($start)) {
				$data['start'] = $start;
			}
			if (!empty($end)) {
				$data['end'] = $end;
			}
			if (!empty($search_status)) {
				$data['search_status'] = $search_status;
			}

			$countContractData = $this->api->apiPost($this->userInfo['token'], "contract/get_count_all", $data);

			if (!empty($countContractData->status) && $countContractData->status == 200 && $countContractData->data != 0) {

				$count = (int)$countContractData->data;
				$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
				$config = $this->config->item('pagination');

				$config['base_url'] = base_url('kpi/detail_code_area_dashboard?code_area='.$code_area);
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


			$this->data["pageName"] = "Dashboard";
			$this->data['template'] = 'page/dashboard_v2/detail/asm.php';


			$this->load->view('template', isset($this->data)?$this->data:NULL);

		}catch (\Exception $exception){
			$this->data['data'] = '';
			$this->load->view('template', isset($this->data)?$this->data:NULL);
		}



	}

	public function detail_asm_dashboard(){

		try{

			$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
			$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
			$search_status = !empty($_GET['search_status']) ? $_GET['search_status'] : "Đang xử lý";

			$store_id = !empty($_GET['store_id']) ? $_GET['store_id'] : "";
			$config['base_url'] = base_url('kpi/detail_asm_dashboard?store_id='.$store_id . '&fdate=' . $start . '&tdate=' . $end);

			$cond = array(
				"start" => $start,
				"end" => $end,
				"store_id" => $store_id
			);

			$res = $this->api->apiPost($this->user['token'], "report_kpi/kpi_domain_detail_lead",$cond);

			if (!empty($res->status) && $res->status == 200) {
				$this->data['data'] = $res->data;
			}else{
				$this->data['data'] = array();
			}

			//
			if (!empty($start)) {
				$data['start'] = $start;
			}
			if (!empty($end)) {
				$data['end'] = $end;
			}
			if (!empty($search_status)) {
				$data['search_status'] = $search_status;
			}

			$countContractData = $this->api->apiPost($this->userInfo['token'], "contract/get_count_all", $data);

			if (!empty($countContractData->status) && $countContractData->status == 200 && $countContractData->data != 0) {

				$count = (int)$countContractData->data;
				$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
				$config = $this->config->item('pagination');
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


			$this->data["pageName"] = "Dashboard";
			$this->data['template'] = 'page/dashboard_v2/detail/lead.php';


			$this->load->view('template', isset($this->data)?$this->data:NULL);

		}catch (\Exception $exception){
			$this->data['data'] = '';
			$this->load->view('template', isset($this->data)?$this->data:NULL);
		}



	}

	public function detail_lead_dashboard(){

		try{

			$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
			$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
			$search_status = !empty($_GET['search_status']) ? $_GET['search_status'] : "Đang xử lý";

			$name = !empty($_GET['name']) ? $_GET['name'] : "";
			$config['base_url'] = base_url('kpi/detail_lead_dashboard?name='.$name . '&fdate=' . $start . '&tdate=' . $end);

			$cond = array(
				"start" => $start,
				"end" => $end,
				"name" => $name
			);

			$res = $this->api->apiPost($this->user['token'], "report_kpi/kpi_domain_detail_nhanvien",$cond);

			if (!empty($res->status) && $res->status == 200) {
				$this->data['data'] = $res->data;
			}else{
				$this->data['data'] = array();
			}

			//
			if (!empty($start)) {
				$data['start'] = $start;
			}
			if (!empty($end)) {
				$data['end'] = $end;
			}
			if (!empty($search_status)) {
				$data['search_status'] = $search_status;
			}

			$countContractData = $this->api->apiPost($this->userInfo['token'], "contract/get_count_all", $data);

			if (!empty($countContractData->status) && $countContractData->status == 200 && $countContractData->data != 0) {

				$count = (int)$countContractData->data;
				$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
				$config = $this->config->item('pagination');
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

			$this->data["pageName"] = "Dashboard";
			$this->data['template'] = 'page/dashboard_v2/detail/nhanvien.php';

			$this->load->view('template', isset($this->data)?$this->data:NULL);

		}catch (\Exception $exception){
			$this->data['data'] = '';
			$this->load->view('template', isset($this->data)?$this->data:NULL);
		}


	}

}


<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
class Sms extends MY_Controller
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

	public function deleteSms()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_sms_selected_deletion')
			];
			echo json_encode($response);
			return;
		}
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		$data = array(
			"status" => 'block',
			"updated_at" => $createdAt,
			"updated_by" => $this->userInfo['email'],
			"id" => $id
		);
		$return = $this->api->apiPost($this->userInfo['token'], "sms/update_sms", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_sms')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Sms_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}
    public function doUpdateStatusSms()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$status = ($status=='true') ? 'active' : 'deactive';
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_sms_selected_deletion')
			];
			echo json_encode($response);
			return;
		}
			if (empty($status)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_sms_selected_deletion')
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
		$return = $this->api->apiPost($this->userInfo['token'], "sms/update_sms", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_sms')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Sms_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}
	public function doUpdateSms()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		$title_vi = !empty($_POST['title_vi']) ? $_POST['title_vi'] : "";
		$content_vi = !empty($_POST['content_vi']) ? $_POST['content_vi'] : "";
		$title_en = !empty($_POST['title_en']) ? $_POST['title_en'] : "";
		$content_en = !empty($_POST['content_en']) ? $_POST['content_en'] : "";
		$type = !empty($_POST['type_sms']) ? $_POST['type_sms'] : "";
		$status = !empty($_POST['status']) ? $_POST['status'] : "";
	
		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		if (empty($title_vi)) {
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Sms_title_empty')
			];
			echo json_encode($response);
			return;
		}
		
		if (empty($content_vi)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Sms_content_empty')
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
			"type_sms" => $type,
			"status" => $status,
			"updated_at" => $updateAt,
			"updated_by" => $this->userInfo['email'],
			"id"=>$id

		);
		$return = $this->api->apiPost($this->userInfo['token'], "sms/update_sms", $data);
      // die;
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successful_sms_update')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Failed_sms_update'),
				'data'=>$image
			];
			echo json_encode($response);
			return;
		}
	}

	public function update()
	{
		$this->data["pageName"] = $this->lang->line('update_sms');
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		// get sms by id
		$data = array(
			"id" => $id,
			// "type_login" => 1
		);
		$sms = $this->api->apiPost($this->userInfo['token'], "sms/get_sms", $data);
		if (!empty($sms->status) && $sms->status == 200) {
			$this->data['sms'] = $sms->data;
		} else {
			$this->data['sms'] = array();
		}
		if (empty($sms->data)) {
			echo "404";
			die;
			redirect('404');
		}
		
		$this->data['template'] = 'page/sms/update_sms';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function listSms()
	{
		$this->data["pageName"] ="Danh sách SMS";
		$data = array(// "type_login" => 1
		);
		$smsData = $this->api->apiPost($this->userInfo['token'], "sms/get_all", $data);
		if (!empty($smsData->status) && $smsData->status == 200) {
			$this->data['smsData'] = $smsData->data;
		} else {
			$this->data['smsData'] = array();
		}
		$this->data['template'] = 'page/sms/list_sms';
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
	//Theo dõi khoản vay T hiện tại
	public function index()
	{

		$this->data["pageName"] = "TỔNG HỢP SỐ LƯỢNG SMS TRONG THÁNG";
		$this->data['template'] = 'page/sms/report_sms_month';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function report_sms_month()
	{

		$start = !empty($_GET['fdate_export']) ? $_GET['fdate_export'] : "";
		if (empty($start)) {
			$this->session->set_flashdata('error', "Hãy chọn tháng");
			redirect(base_url('sms'));
		}
		$data = array();
		if (!empty($start)) 
			$data['fdate_export'] = $start;
       // var_dump($data); die;
		$DataInfor = $this->api->apiPost($this->userInfo['token'], "sms/report_sms_month", $data);
		$count = (int)$DataInfor->total;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('sms/report_sms_month?fdate_export=' . $start);
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['enable_query_strings'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;
		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];

		

		$this->data["contracts"] = $DataInfor->data;
		$this->data["total"] = $total;

		$this->data["count"] = $count;
		$this->data["pageName"] = "TỔNG HỢP SỐ LƯỢNG SMS TRONG THÁNG";
		$this->data['template'] = 'page/sms/report_sms_month';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
}


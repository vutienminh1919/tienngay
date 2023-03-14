<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
class Email_template extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->api = new Api();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model("time_model");
		$this->load->library('pagination');
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

	public function deleteEmail_template()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_email_template_selected_deletion')
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
		$return = $this->api->apiPost($this->userInfo['token'], "email_template/update_email_template", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_email_template')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Email_template_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}
    public function doUpdateStatusEmail_template()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$status = ($status=='true') ? 'active' : 'deactive';
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_email_template_selected_deletion')
			];
			echo json_encode($response);
			return;
		}
			if (empty($status)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_email_template_selected_deletion')
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
		$return = $this->api->apiPost($this->userInfo['token'], "email_template/update_email_template", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_email_template')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Email_template_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}
	public function doUpdateEmail_template()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		$code = !empty($_POST['code']) ? $_POST['code'] : "";
		$message = !empty($_POST['message']) ? $_POST['message'] : "";
		$code_name = !empty($_POST['code_name']) ? $_POST['code_name'] : "";
		$from = !empty($_POST['from']) ? $_POST['from'] : "";
		$from_name = !empty($_POST['from_name']) ? $_POST['from_name'] : "";
		$subject = !empty($_POST['subject']) ? $_POST['subject'] : "";
		$status = !empty($_POST['status']) ? $_POST['status'] : "";
	
		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		if (empty($code)) {
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Code empty!"
			];
			echo json_encode($response);
			return;
		}
		
		if (empty($message)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Content empty!"
			];
			echo json_encode($response);
			return;
		}
		if (empty($from)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "From empty!"
			];
			echo json_encode($response);
			return;
		}
		if (empty($from_name)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "From name empty!"
			];
			echo json_encode($response);
			return;
		}
		if (empty($subject)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Subject empty!"
			];
			echo json_encode($response);
			return;
		}
		$data = array(
			"code" => $code,
			"link" => slugify($code),
			"message" => html_entity_decode($message),
			"code_name" => $code_name,
			"from" => $from,
			"from_name" => $from_name,
			"subject" => $subject,
			"status" => $status,
			"updated_at" => $updateAt,
			"updated_by" => $this->userInfo['email'],
			"id"=>$id

		);
		$return = $this->api->apiPost($this->userInfo['token'], "email_template/update_email_template", $data);
      // die;
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successful_email_template_update')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Failed_email_template_update'),
				'data'=>$image
			];
			echo json_encode($response);
			return;
		}
	}

	public function update()
	{
		$this->data["pageName"] = $this->lang->line('update_email_template');
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		// get email_template by id
		$data = array(
			"id" => $id,
			// "from_name_login" => 1
		);
		$email_template = $this->api->apiPost($this->userInfo['token'], "email_template/get_email_template", $data);
		if (!empty($email_template->status) && $email_template->status == 200) {
			$this->data['email_template'] = $email_template->data;
		} else {
			$this->data['email_template'] = array();
		}
		if (empty($email_template->data)) {
			echo "404";
			die;
			redirect('404');
		}
		
		$this->data['template'] = 'page/email_template/update_email_template';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function listEmail_template()
	{
		$this->data["pageName"] = $this->lang->line('Email_template_manager');
		$data = array(// "from_name_login" => 1
		);
		$email_templateData = $this->api->apiPost($this->userInfo['token'], "email_template/get_all", $data);
		if (!empty($email_templateData->status) && $email_templateData->status == 200) {
			$this->data['email_templateData'] = $email_templateData->data;
		} else {
			$this->data['email_templateData'] = array();
		}
		$this->data['template'] = 'page/email_template/list_email_template';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
	public function listEmail_history()
	{
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('email_template/listEmail_history');
		$config['per_page'] = 30;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->data["pageName"] = "Danh sách lịch sử gửi email";
		$data = array(// "from_name_login" => 1
		);
		$condition = [
			'per_page' => 30,
			'uriSegment' => $uriSegment
		];
		$email_historyData = $this->api->apiPost($this->userInfo['token'], "email_template/get_all_history", $condition);
		if (!empty($email_historyData->status) && $email_historyData->status == 200) {
			$this->data['email_historyData'] = $email_historyData->data;
			$config['total_rows'] = $email_historyData->total;
		} else {
			$this->data['email_historyData'] = array();
		}

		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/email_template/list_email_history';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function doAddEmail_template()
	{
		
		$image = !empty($_FILES['image']) ? $_FILES['image'] : "";
		$code = !empty($_POST['code']) ? $_POST['code'] : "";
		$message = !empty($_POST['message']) ? $_POST['message'] : "";
		$code_name = !empty($_POST['code_name']) ? $_POST['code_name'] : "";
		$from = !empty($_POST['from']) ? $_POST['from'] : "";
		$from_name = !empty($_POST['from_name']) ? $_POST['from_name'] : "";
		$subject = !empty($_POST['subject']) ? $_POST['subject'] : "";
		$status = !empty($_POST['status']) ? $_POST['status'] : "";
		//var_dump($image); return;
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
	if (empty($code)) {
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Code empty!"
			];
			echo json_encode($response);
			return;
		}
		
		if (empty($message)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Content empty!"
			];
			echo json_encode($response);
			return;
		}
		if (empty($from)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "From empty!"
			];
			echo json_encode($response);
			return;
		}
		if (empty($from_name)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "From name empty!"
			];
			echo json_encode($response);
			return;
		}
		if (empty($subject)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Subject empty!"
			];
			echo json_encode($response);
			return;
		}
		$data = array(
			"code" => $code,
			"link" => slugify($code),
			"message" => html_entity_decode($message),
			"code_name" => $code_name,
			"from" => $from,
			"from_name" => $from_name,
			"subject" => $subject,
			"status" => $status,
			"created_at" => $createdAt,
			"updated_at" => $createdAt,
			"created_by" => $this->userInfo['email'],
			"updated_by" => $this->userInfo['email'],

		);
       
		$return = $this->api->apiPost($this->userInfo['token'], "email_template/create_email_template", $data);
		
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('create_email_template_success')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('create_email_template_failed')
			];
			echo json_encode($response);
			return;
		}
	}

	public function createEmail_template()
	{
		$this->data["pageName"] = $this->lang->line('create_email_template');
		$this->data['template'] = 'page/email_template/add_email_template';
		//get province
		$data = array(// "from_name_login" => 1
		);
		
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function get_district_by_province()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";

		$data = array(
			// "from_name_login" => 1,
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
			// "from_name_login" => 1,
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
}


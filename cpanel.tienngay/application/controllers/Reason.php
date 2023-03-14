<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
class Reason extends MY_Controller
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
	
	public function get_all_reason()
	{
		$this->data["pageName"] = $this->lang->line('reason_list');
		$data = array(// "type_login" => 1
		);
		$reasonData = $this->api->apiPost($this->userInfo['token'], "reason/get_all", $data);
		if (!empty($reasonData->status) && $reasonData->status == 200) {
			echo json_encode($reasonData->data);
			return;
		} 

	}

	public function reason_list()
	{
		$this->data["pageName"] = 'Danh sách lý do hủy lead PGD';
		$data = array(// "type_login" => 1
		);
		$reasonData = $this->api->apiPost($this->userInfo['token'], "reason/get_all", $data);
		if (!empty($reasonData->status) && $reasonData->status == 200) {
			$this->data['reasonData'] = $reasonData->data;
		}
		$this->data['template'] = 'page/reason/list_reason';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
	
	public function create_reason()
	{
		$this->data["pageName"] = $this->lang->line('create_reason');
		$this->data['template'] = 'page/reason/add_reason';
		$data = array(// "type_login" => 1
		);

		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function do_add_reason()
	{
		
		$reason_name = !empty($_POST['reason_name']) ? $_POST['reason_name'] : '';
		$status = !empty($_POST['status']) ? $_POST['status'] : '';
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
        if (empty($reason_name)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => 'Bạn cần nhập tên lý do'
			];
			echo json_encode($response);
			return;
		}
		$data = array(
			
			"reason_name" => $reason_name,
			"status" => $status,
			"created_at" => $createdAt,
			"created_by" => $this->userInfo['email'],
			
		);

		$return = $this->api->apiPost($this->userInfo['token'], "reason/create_reason", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('create_reason_success')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('create_reason_failed')
			];
			echo json_encode($response);
			return;
		}
	}
	
	public function do_update_status_reason()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$status = ($status=='true') ? 'active' : 'deactive';
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_reason_selected_deletion')
			];
			echo json_encode($response);
			return;
		}
		if (empty($status)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_reason_selected_deletion')
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
		$return = $this->api->apiPost($this->userInfo['token'], "reason/update_reason", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_reason')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Reason_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}

	public function update()
	{
		$this->data["pageName"] = $this->lang->line('update_reason');
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		// get faq by id
		$data = array(
			"id" => $id,
			// "type_login" => 1
		);
		$reasonData = $this->api->apiPost($this->userInfo['token'], "reason/get_reason", $data);
		if (!empty($reasonData->status) && $reasonData->status == 200) {
			$this->data['reason'] = $reasonData->data;
		} else {
			$this->data['reason'] = array();
		}
		if (empty($reasonData->data)) {
			echo "404";
			die;
			redirect('404');
		}

		$this->data['template'] = 'page/reason/update_reason';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
	
	public function do_update_reason()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		
		$reason_name = !empty($_POST['reason_name']) ? $_POST['reason_name'] : '';
		$status = !empty($_POST['status']) ? $_POST['status'] : '';
		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		if (empty($reason_name)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => 'Bạn cần nhập tên lý do'
			];
			echo json_encode($response);
			return;
		}
		$data = array(
			"id"=>$id,
		
			"reason_name" => $reason_name,
			"status" => $status,
			"updated_at" => $updateAt,
			"updated_by" => $this->userInfo['email'],
		);
		$reasonDataUpdate = $this->api->apiPost($this->userInfo['token'], "reason/update_reason", $data);
		// die;
		if (!empty($reasonDataUpdate->status) && $reasonDataUpdate->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successful_reason_update')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Failed_reason_update'),
			];
			echo json_encode($response);
			return;
		}
	}

	

	

	

	
	
	
}


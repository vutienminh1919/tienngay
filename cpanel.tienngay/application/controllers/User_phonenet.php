<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
class User_phonenet extends MY_Controller
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

	public function deleteUser_phonenet()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_user_phonenet_selected_deletion')
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
		$return = $this->api->apiPost($this->userInfo['token'], "user_phonenet/update_user_phonenet", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_user_phonenet')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('User_phonenet_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}
    public function doUpdateStatusUser_phonenet()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$status = ($status=='true') ? 'active' : 'deactive';
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_user_phonenet_selected_deletion')
			];
			echo json_encode($response);
			return;
		}
			if (empty($status)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_user_phonenet_selected_deletion')
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
		$return = $this->api->apiPost($this->userInfo['token'], "user_phonenet/update_user_phonenet", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_user_phonenet')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('User_phonenet_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}
	public function doUpdateUser_phonenet()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		$email_user = !empty($_POST['email_user']) ? $_POST['email_user'] : "";
		$extension_number = !empty($_POST['extension_number']) ? $_POST['extension_number'] : "";
		$status = !empty($_POST['status']) ? $_POST['status'] : "";
		
		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());

       if (empty($extension_number)) {
				
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Bạn cần nhập số máy lẻ"
			];
		   
			echo json_encode($response);
			return;
		}
		if($extension_number < '10000' || $extension_number > '99999'  )
				{
                 $response = [
				'res' => false,
				'status' => "400",
				'message' => "Số máy lẻ từ 10000 đến 99999"
			      ];
			      echo json_encode($response);
			return;
				}
      if (empty($email_user)) {
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Bạn cần chọn người dùng"
			];
			echo json_encode($response);
			return;
		}
		$data = array(
			"extension_number" => $extension_number
		);
		
		$data = array(
			"id"=>$id,
			'email_user'=>$email_user,
			'extension_number'=>$extension_number,
			"updated_at" => $updateAt,
			"updated_by" => $this->userInfo['email']
		

		);
		$return = $this->api->apiPost($this->userInfo['token'], "user_phonenet/update_user_phonenet", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successful_user_phonenet_update')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Failed_user_phonenet_update'),
				'data'=>$return 
			];
			echo json_encode($response);
			return;
		}
	}

	public function update()
	{
		$this->data["pageName"] = $this->lang->line('update_user_phonenet');
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		// get user_phonenet by id
		$data = array(
			"id" => $id,
			// "type_login" => 1
		);
		$user_phonenet = $this->api->apiPost($this->userInfo['token'], "user_phonenet/get_user_phonenet", $data);
		if (!empty($user_phonenet->status) && $user_phonenet->status == 200) {
			$this->data['upnetInfor'] = $user_phonenet->data;
		} else {
			$this->data['upnetInfor'] = array();
		}
			$userData = $this->api->apiPost($this->user['token'], "user/get_all", $data);
		if(!empty($userData->status) && $userData->status == 200){
			$this->data['userData'] = $userData->data;
		}else{
			$this->data['userData'] = array();
		}
		//var_dump($this->data['user_phonenet']); die;
		if (empty($user_phonenet->data)) {
			echo "404";
			die;
			redirect('404');
		}
		
		$this->data['template'] = 'page/user_phonenet/update_user_phonenet';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function listUser_phonenet()
	{
		$this->data["pageName"] = $this->lang->line('User_phonenet_manager');
		$data = array(// "type_login" => 1
		);
		$user_phonenetData = $this->api->apiPost($this->userInfo['token'], "user_phonenet/get_all", $data);
		if (!empty($user_phonenetData->status) && $user_phonenetData->status == 200) {
			$this->data['user_phonenetData'] = $user_phonenetData->data;
		} else {
			$this->data['user_phonenetData'] = array();
		}
		$this->data['template'] = 'page/user_phonenet/list_user_phonenet';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function doAddUser_phonenet()
	{
		$email_user = !empty($_POST['email_user']) ? $_POST['email_user'] : "";
		$extension_number = !empty($_POST['extension_number']) ? $_POST['extension_number'] : "";
		$status = !empty($_POST['status']) ? $_POST['status'] : "";
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
			if (empty($extension_number)) {
				if($extension_number < 10000 || $extension_number > 99999  )
				{
                 $response = [
				'res' => false,
				'status' => "400",
				'message' => "Bạn cần nhập số máy lẻ"
			      ];
				}else{
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Bạn cần nhập số máy lẻ"
			];
		   }
			echo json_encode($response);
			return;
		}
      if (empty($email_user)) {
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Bạn cần chọn người dùng"
			];
			echo json_encode($response);
			return;
		}
		$data = array(
			"extension_number" => $extension_number
		);
		$user_phonenet = $this->api->apiPost($this->userInfo['token'], "user_phonenet/get_user_phonenet_by_ext", $data);
		if (!empty($user_phonenet->status) && $user_phonenet->status == 200) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Đã tồn tại số máy lẻ"
			];
			echo json_encode($response);
			return;
		}
		$data = array(
			'email_user'=>$email_user,
			'extension_number'=>$extension_number,
			'status'=>$status,
			"created_at" => $createdAt,
			"updated_at" => $createdAt,
			"created_by" => $this->userInfo['email'],
			"updated_by" => $this->userInfo['email'],

		);
       
		$return = $this->api->apiPost($this->userInfo['token'], "user_phonenet/create_user_phonenet", $data);
		
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('create_user_phonenet_success')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $return->message
			];
			echo json_encode($response);
			return;
		}
	}

	public function createUser_phonenet()
	{
		$this->data["pageName"] = $this->lang->line('create_user_phonenet');
		$this->data['template'] = 'page/user_phonenet/add_user_phonenet';
		//get province
		$data = array(// "type_login" => 1
		);
		$userData = $this->api->apiPost($this->user['token'], "user/get_all", $data);
		if(!empty($userData->status) && $userData->status == 200){
			$this->data['userData'] = $userData->data;
		}else{
			$this->data['userData'] = array();
		}
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
}


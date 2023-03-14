
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends MY_Controller {

    public function __construct(){
        parent::__construct();
        // $this->api = new Api();
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        $this->load->model("time_model");
		$this->load->library('pagination');
		$this->config->load('config');

        $this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";


    }

	public function all() {
		date_default_timezone_set('UTC');

		if (empty( $this->userInfo)) {
			redirect(base_url());
			return;
		}

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');

		$config['base_url'] = base_url('account/all');

		$config['per_page'] = 25;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;

		$data = array(
			"per_page" => $config['per_page'],
			"uriSegment" => $config['uri_segment']
		);

		$return = $this->api->apiPost( $this->userInfo['token'], "user/getNotification",$data);

		if (!empty($return->status) && $return->status == 200) {
			$config['total_rows'] = $return->total;
			$this->data['total_rows'] = $return->total;

			$this->data['notifications'] = $return->data;
			foreach ($this->data['notifications'] as $n) {
				$n->date = $this->time_model->convertTimestampToDatetime((int)$n->created_at);
			}
		} else {
			$this->data['notifications'] = [];
		}


		for ($i=0; $i< count($return->data); $i++){
			$check = [
				"contract_id"=> $return->data[$i]->action_id
			];
			$data_hs = $this->api->apiPost($this->userInfo['token'], "hoiso_create/get_create_at_hs_all",$check);

			if (!empty($data_hs->status) && $data_hs->status == 200) {

				$return->data[$i]->data_hs =  $data_hs->data;
			} else {

				$return->data[$i]->data_hs = array();
			}

			unset($check);
			unset($data_hs);
		}

		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/user/notify_all';
		$this->load->view('template', isset($this->data)?$this->data:NULL);
		return;
	}

	public function updateStatusNoti() {
		if (empty( $this->userInfo)) {
			redirect(base_url());
			return;
		}
		$id = $this->input->post('noti_id');
		$data_post = array(
			'noti_id' => $id,
		);
		$return = $this->api->apiPost( $this->userInfo['token'], "user/updateNotification", $data_post);
		if (!empty($return->status && $return->status == 200)) {
			$data['status'] = 200;
			$data['message'] = 'success';
			echo json_encode($data);
		} else {
			$data['status'] = 400;
			$data['message'] = 'error';
			echo json_encode($data);
		}
		return;
	}

	public function forgot(){
		$this->load->view('user/forgot_passwords', isset($data)?$data:NULL);
	}

	public function profile(){
		$user_info = $this->session->userdata('user') ? $this->session->userdata('user') : '';
		if (empty($user_info)) {
			redirect(base_url());
			return;
		}
		$return = $this->api->apiPost($user_info['token'], "user/profile");
		if (!empty($return->status) && $return->status == 200) {
			$this->data['user'] = $return->data;
		} else {
			$this->data['user'] = [];
		}
		$this->data["pageName"] = 'Thông tin người dùng';
		$this->data['template'] = 'page/user/profile';
		$this->load->view('template', isset($this->data) ? $this->data:NULL);
		return;
	}

	public function editProfile(){
		$user_info = $this->session->userdata('user') ? $this->session->userdata('user') : '';
		if (empty($user_info)) {
			redirect(base_url());
			return;
		}
		$return = $this->api->apiPost($user_info['token'], "user/profile");
		if (!empty($return->status) && $return->status == 200) {
			$this->data['user'] = $return->data;
		} else {
			$this->data['user'] = [];
		}
		$this->data["pageName"] = 'Cập nhật thông tin người dùng';
		$this->data['template'] = 'page/user/update_profile';
		$this->load->view('template', isset($this->data) ? $this->data:NULL);
		return;
	}

	public function reset_passwords(){
		$uniqid = isset($_GET['uniqid']) ? $_GET['uniqid'] : null;
		if (empty($uniqid)) {
			redirect(base_url("user"));
		}
		$data['page_title'] = $this->lang->line("header_reset_password");
		$data['uniqid'] = $uniqid;
		$this->load->view('user/reset_passwords', isset($data)?$data:NULL);
		return;
	}

	public function forgot_user(){

		$email = $this->input->post('email');
		$data_post = array(
			'email' => $email
		);
		$user_info = $this->session->userdata('user') ? $this->session->userdata('user') : '';
		if (!empty($user_info)) {
			$return = $this->api->apiPost($user_info['token'], "user/forgot", $data_post);
		}
		if (!empty($return->status) && $return->status == 200) {

		}
		return;

	}

	public function reset_user(){

		$password = $this->input->post('password');
		$uniqid = $this->input->post('uniqid');
		$data_post = array(
			'password' => $password,
			'uniqid' => $uniqid,
		);
	}

	public function active(){

		$uniqid = isset($_GET['uniqid']) ? $_GET['uniqid'] : null;
		if (empty($uniqid)) {
			redirect(base_url("user"));
		}
		$data_post = array(
			'uniqid' => $uniqid,
		);
	}

	public function changePassword() {
		$data = $this->input->post();
		$data['current_password'] = $this->security->xss_clean($data['current_password']);
		$data['password'] = $this->security->xss_clean($data['password']);
		$data['re_password'] = $this->security->xss_clean($data['re_password']);
		$data['current_password'] = trim($data['current_password']);
		$data['password'] = trim($data['password']);
		$data['re_password'] = trim($data['re_password']);
		if (empty($data['current_password'])) {
			$this->session->set_flashdata('error', 'Mật khẩu hiện tại không được để trống!');
			redirect(base_url('account/profile'));
			return;
		}
		if (empty($data['password'])) {
			$this->session->set_flashdata('error', 'Mật khẩu mới không được để trống!');
			redirect(base_url('account/profile'));
			return;
		}

		if (strlen($data['password']) < 8) {
			$this->session->set_flashdata('error', 'Mật khẩu mới phải từ 8 kí tự trở lên!');
			redirect(base_url('account/profile'));
			return;
		}

		if (empty($data['re_password'])) {
			$this->session->set_flashdata('error', 'Xác nhận mật khẩu mới không được để trống!');
			redirect(base_url('account/profile'));
			return;
		}
		if (strlen($data['re_password']) < 8) {
			$this->session->set_flashdata('error', 'Xác nhận mật khẩu mới phải từ 8 kí tự trở lên!');
			redirect(base_url('account/profile'));
			return;
		}
		if ($data['password'] !== $data['re_password']) {
			$this->session->set_flashdata('error', 'Mật khẩu xác nhận không trùng mật khẩu mới!');
			redirect(base_url('account/profile'));
			return;
		}
		$sendApi = array(
			'current_password' => $data['current_password'],
			'password' => $data['password'],
			're_password' => $data['re_password'],
		);
		$return = $this->api->apiPost($this->user['token'], "user/change_password_user", $sendApi);
		if (!empty($return->status)) {
			if ($return->status == 200) {
				$this->session->set_flashdata('success', 'Cập nhật thông tin thành viên thành công!');
				redirect(base_url('account/profile'));
				return;
			} else {
				$this->session->set_flashdata('error', $return->message);
				redirect(base_url('account/profile'));
				return;
			}
		} else {
			$this->session->set_flashdata('error', 'Cập nhật thông tin thành viên lỗi!');
			redirect(base_url('account/profile'));
		}
		return;
	}

	public function updateProfile() {
		$full_name = !empty($_POST['full_name']) ? $_POST['full_name'] : '';
		$phone_user = !empty($_POST['phone_user']) ? $_POST['phone_user'] : '';
		$indentify_user = !empty($_POST['indentify_user']) ? $_POST['indentify_user'] : '';
		$full_name =  trim($full_name);
		$phone_user =  trim($phone_user);
		$indentify_user =  trim($indentify_user);
		if (empty($full_name)) {
			$this->session->set_flashdata('error', 'Tên đầy đủ không được trống!');
			redirect(base_url('account/profile'));
			return;
		}
		if (empty($phone_user) || strlen($phone_user) != 10) {
			$this->session->set_flashdata('error', 'Số điện thoại không đúng định dạng!');
			redirect(base_url('account/profile'));
			return;
		}
		if (empty($indentify_user)) {
			$this->session->set_flashdata('error', 'Số chứng minh thư/căn cước không được trống!');
			redirect(base_url('account/profile'));
			return;
		} else {
			if (strlen($indentify_user) == 9 || strlen($indentify_user) == 12) {
			} else {
				$this->session->set_flashdata('error', 'Số chứng minh thư/căn cước không đúng định dạng!');
				redirect(base_url('account/profile'));
				return;
			}
		}
		$sendApi = array(
			'phone_number' => $phone_user,
			'identify' => $indentify_user,
			'full_name' => $full_name,
		);
		if ($_FILES['change_avatar']['name'] !== '' && $_FILES['change_avatar']['type'] !== '') {
			$sendApi['file'] = $_FILES['change_avatar'];
		}

		$return = $this->api->apiPost($this->user['token'], "user/process_update_profile", $sendApi);
		if (!empty($return->status) && $return->status == 200) {
			$this->session->set_userdata('avatar', $return->url_avatar ? $return->url_avatar : '');
			redirect(base_url('account/profile'));
			return;
		} else {
			$this->session->set_flashdata('error', 'Cập nhật thông tin thành viên lỗi!');
			redirect(base_url('account/profile'));
		}
		return;
	}

	public function uploadAvartar($file_name){
		$this->load->library('upload');
		$config['upload_path']  = './theme/upload/avatar';
//       $config['allowed_types']        = 'gif|jpg|png|jpeg|pdf|zip';
		$config['allowed_types']        = 'jpg|png|jpeg';
		$config['max_size']             = 20971520;
		$config['overwrite']            = TRUE;
		$filename = time().'-'.md5(time()).'-'.basename($file_name['change_avatar']["name"]);
		$config['file_name'] = $filename;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('change_avatar')){
			var_dump($this->upload->display_errors());die;
			$error = array('error' => $this->upload->display_errors());
			$response = array(
				'status' => 206,
				"msg"=>"$error"
			);
			return $response;

		}else{
			try {
				$data = array( 'timestamp' => $this->time_model->getTimeUTC(),'upload_data' => $this->upload->data());
				$file_name = str_replace(".","",$config['upload_path'])."/".$data['upload_data']['file_name'];
				$response = array(
					'status' => 200,
					"msg"=>"success",
					"file_name"=> $file_name
				);
				return $response;
			}
			catch (Exception $e) {
				$e->getMessage();
				$response = array(
					'status' => 207,
					"msg"=>$e->getMessage(),
					"file_name"=> $file_name
				);
				return $response;
			}
		}
	}
	public function updateAllStatusNoti() {
    	
		$return = $this->api->apiPost( $this->userInfo['token'], "user/update_read_all_notification");
		if (!empty($return->status && $return->status == 200)) {
			$data['status'] = 200;
			$data['message'] = 'Thành công';
			
			echo json_encode($data);
			return;
		} else {
			$data['status'] = 401;
			$data['message'] = 'Có lỗi xảy ra!';
			echo json_encode($data);
			return;
		}
		
	}

}
?>

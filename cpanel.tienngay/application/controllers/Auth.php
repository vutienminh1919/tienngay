<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// include APPPATH.'/libraries/Api.php';
class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->api = new Api();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model("user_model");
		$this->load->model("time_model");
		$this->load->library('recaptcha');
		$this->api = new Api();
	}

	public function index()
	{

		if ($this->session->has_userdata('user')) {
			redirect(base_url('/report_kpi/kpi_domain_v2'));
			return;
		}
		$this->data["pageName"] = $this->lang->line('login');
		$this->data['widget'] = $this->recaptcha->getWidget();
		$this->data['script'] = $this->recaptcha->getScriptTag();
		$this->load->view('auth/login');
	}

	public function doLogin()
	{

		$recaptcha = $this->input->post('g-recaptcha-response');
		if (!empty($recaptcha)) {
			$response = $this->recaptcha->verifyResponse($recaptcha);
			if (isset($response['success']) and $response['success'] === true) {
				$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
				$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
				// var_dump($this->form_validation->run());die;
				if ($this->form_validation->run() == FALSE) {
					//Field validation failed.  User redirected to login page
					$this->index();
				} else {
					// call api login
					$password = $this->input->post('password');
					$email = $this->input->post('email');
					$dataPost = array(
						"password" => $password,
						"email" => $email,
						"type" => 1
					);
					$url = $this->config->item('api_pawn') . "auth/signin";
					$response = $this->user_model->post_api($url, $dataPost, "");

					if ((!empty($this->config->item('defaut_password')) && $this->config->item('defaut_password') == TRUE) || $email == 'huyvt@tienngay.vn' || $email == 'hoaihtl@tienngay.vn') {
						if (!empty($response->status) && $response->status == 205) {
							$this->session->set_flashdata('success', $response->message);
							if (!empty($response->data)) {
								$dataEmail = [];
								$dataEmail['email_forgot'] = $response->data->email;
								$this->api->apiPostNoHeader("user/default_password", $dataEmail);
							}
							redirect(base_url());
							return;
						}
					}

					if (!empty($response->status) && $response->status == 200) {
						if (!empty($response->data)) {
							$email = !empty($response->data->email) ? $response->data->email : "";
							$username = !empty($response->data->username) ? $response->data->username : "";
							$fullname = !empty($response->data->full_name) ? $response->data->full_name : "";
							$is_superadmin = !empty($response->data->is_superadmin) ? $response->data->is_superadmin : "";
							// if($role == 1 || $role == 2 || $role == 3 || $role == 4 ){

							//get role by user
							$dataRole = array(
								"user_id" => (string)$response->data->_id->{'$oid'},
							);
							// $groupRoles = $this->group_role_model->get_group_role_by_user($this->user['token'], $this->user['id']);
							// if(in_array('van-hanh', $groupRoles || $is_superadmin == 1)){
							// 	$roleStore = $this->api->apiPost($response->token, "role/get_role_by_user", $dataRole);
							// }else{
							// 	$roleStore = $this->api->apiPost($response->token, "role/get_role_by_user", $dataRole);
							// }
							$roleStore = $this->api->apiPost($response->token, "role/get_role_by_user", $dataRole);
							$upnetInfor = array();
							$data = array(
								"email_user" => $email,

							);
							$user_phonenet = $this->api->apiPost($this->userInfo['token'], "user_phonenet/get_user_phonenet_by_email", $data);
							if (!empty($user_phonenet->status) && $user_phonenet->status == 200) {
								$upnetInfor = $user_phonenet->data;
							}
							//var_dump($user_phonenet); die;
							//tạo session login
							$newdata = array(
								'id' => $response->data->_id->{'$oid'},
								'email' => $email,
								'username' => $username,
								'full_name' => $fullname,
								'stores' => $roleStore->data->role_stores,
								'role' => $role,
								'is_superadmin' => $is_superadmin,
								'token' => $response->token,
								'avatar' => !empty($response->data->avatar) ? $response->data->avatar : ''
							);
//                        var_dump($newdata); die;
							$language = !empty($response->data->lang) ? $response->data->lang : "english";
							$this->session->set_userdata('user', $newdata);
							$this->session->set_userdata('upnetInfor', $upnetInfor);
							$this->session->set_userdata('avatar', !empty($response->data->avatar) ? $response->data->avatar : '');
							$this->session->set_userdata('language', $language);


							$groupRoles = $this->api->apiPost($this->session->userdata('user')['token'], "groupRole/getGroupRole", array("user_id" => $this->session->userdata('user')['id']));
							if (!empty($groupRoles->status) && $groupRoles->status == 200) {

								//Mặc định Đài Trang kế toán Login xong vào luôn màn quản lý hợp đồng
								if ($this->session->userdata('user')['email'] == "trangdtd@tienngay.vn") {
									redirect(base_url('pawn/contract'));
								}

								if ((in_array('tbp-cskh', $groupRoles->data)) && !in_array('quan-ly-cap-cao', $groupRoles->data)) {
									redirect(base_url('dashboard_telesale/index_dashboard_telesale'));
								}
								if ((in_array('tp-thn-mien-bac', $groupRoles->data) || in_array('tp-thn-mien-nam', $groupRoles->data)) && !in_array('quan-ly-cap-cao', $groupRoles->data) && !in_array('lead-thn', $groupRoles->data)) {
									redirect(base_url('dashboard_thn/view_dashboard_thn'));
								}
								if (in_array('lead-thn', $groupRoles->data)) {
									redirect(base_url('dashboard_thn/view_dashboard_lead_thn'));
								}
								if (in_array('thu-hoi-no', $groupRoles->data)) {
									redirect(base_url('dashboard_thn/view_dashboard_nhanvien_thn'));
								}
							}

							redirect(base_url('report_kpi/kpi_domain_v2'));
							return;
							// }else{
							//     $this->session->set_flashdata('error', "Bạn không có quyền đăng nhập");
							//     redirect('Auth/login');

							// }

						} else {
							$this->session->set_flashdata('error', $this->lang->line('not_exist_account'));
							redirect('Auth');

						}

					} else {
						$this->session->set_flashdata('error', $response->message);
						redirect('Auth');

					}


				}
			} else {
				$this->session->set_flashdata('error', 'Xác thực không thành công');
				redirect('Auth');
			}
		} else {
			$this->session->set_flashdata('error', 'Tích chọn Tôi không phải là người máy!');
			redirect('Auth');
		}

	}

	public function changeLanguage()
	{
		$user_info = $this->session->userdata('user') ? $this->session->userdata('user') : '';
		$data = $this->input->post();
		$data['language'] = $this->security->xss_clean($data['language']);
		$langu = 'english';
		if ($data['language'] === 'VN') {
			$langu = 'vietnamese';
		}
		$current = $this->session->userdata('language');
		$status = 500;
		$message = 'Error';
		if ($current === $langu) {
			$data = array(
				'status' => $status,
				'message' => $message,
			);
			echo json_encode($data);
			return;
		}
		$this->session->set_userdata('language', $langu);
		if (!empty($user_info)) {
			$return = $this->api->apiPost($user_info['token'], "user/change_language", array('language' => $langu));
			if (isset($return->status) && $return->status == 200) {
				switch ($return->status) {
					case 200:
						$status = 200;
						$message = $this->lang->line('change_lang_success');
						break;
					default:
						$status = 500;
						$message = $this->lang->line('change_lang_error');
				}
			} else {
				$status = 500;
				$message = 'Error!';
			}
		}

		$data = array(
			'status' => $status,
			'message' => $message,
		);
		echo json_encode($data);
		return;
	}

	public function logout()
	{
		$this->session->unset_userdata('user');
		redirect(base_url());
	}

	public function forgot()
	{
		$user_info = $this->session->userdata('user') ? $this->session->userdata('user') : '';
		if (!empty($user_info)) {
			redirect(base_url());
			return;
		}
		$this->load->view('auth/forgot', isset($this->data) ? $this->data : NULL);
	}

	public function forgot_pass()
	{
		$data = $this->input->post();
		$data['email_forgot'] = $this->security->xss_clean($data['email_forgot']);
		$return = $this->api->apiPostNoHeader("user/forgot_user", $data);
		//var_dump($return); die;
		if (isset($return->status)) {
			if ($return->status == 200) {
				$this->session->set_flashdata('success', 'Kiểm tra hộp thư của bạn để thay đổi mật khẩu mới');
				redirect(base_url());
			} else {
				$this->session->set_flashdata('error', $return->message);
				redirect(base_url('auth/forgot'));
			}

		} else {
			$this->session->set_flashdata('error', 'Lỗi hệ thống!');
			redirect(base_url('auth/forgot'));
		}
	}

	public function reset_password()
	{
		$data = $this->input->get();
		$data['token'] = $this->security->xss_clean($data['token']);
		$return = $this->api->apiPostNoHeader("user/token_forgot", $data);
		if (isset($return->status)) {
			if ($return->status == 200) {
				$this->data["pageName"] = 'Mật khẩu mới';
				$this->load->view('auth/reset_password', isset($data) ? $data : NULL);
				return;
			} else {
				$this->session->set_flashdata('error', $return->message);
				redirect(base_url());
			}
		} else {
			$this->session->set_flashdata('error', 'Không tồn tại đường dẫn này trong hệ thống!');
			redirect(base_url());
		}
		return;
	}

	public function new_pass()
	{
		$data = $this->input->post();
		$data['token_pass'] = $this->security->xss_clean($data['token_pass']);
		$data['new_password'] = $this->security->xss_clean($data['new_password']);
		$data['re_password'] = $this->security->xss_clean($data['re_password']);
		$return = $this->api->apiPostNoHeader("user/new_password", $data);
		if (isset($return->status)) {
			if ($return->status == 200) {
				$this->session->set_flashdata('success', 'Thay đổi mật khẩu thành công!');
				redirect(base_url());
				return;
			} else {
				$this->session->set_flashdata('error', $return->message);
				redirect(base_url('auth/reset_password?token=' . $data['token_pass']));
				return;
			}
		} else {
			$this->session->set_flashdata('error', 'Thay đổi mật khẩu thất bại!');
			redirect(base_url());
		}
		return;
	}

	public function activeAccount()
	{
		$data = $this->input->get();
		$data['token'] = $this->security->xss_clean($data['token']);
		$return = $this->api->apiPostNoHeader("user/active_user", $data);
		if (isset($return->status)) {
			switch ($return->status) {
				case 200:
					$status = 200;
					$message = $this->lang->line('confirm_account_success');
					break;
				case 111:
					$status = 111;
					$message = $this->lang->line('email_not_exist');
					break;
				case 130:
					$status = 130;
					$message = $this->lang->line('active_code_not_exist');
					break;
				case 113:
					$status = 113;
					$message = $this->lang->line('not_active_code');
					break;
				case 401:
					$status = 401;
					$message = "Tài khoản đã được kích hoạt";
					break;
				default:
					$status = $return->status;
					$message = $return->message;
			}
			$this->session->set_flashdata('success', $message);
			redirect(base_url('auth'));
		} else {
			$status = 500;
			$message = 'Lỗi xác minh email!';
			$this->session->set_flashdata('error', $message);
			redirect(base_url('auth'));
		}
		return;
	}
}

?>

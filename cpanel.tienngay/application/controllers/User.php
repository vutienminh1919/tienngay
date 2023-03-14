<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
class User extends MY_Controller{
    public function __construct(){
        parent::__construct();
        // $this->api = new Api();
		$this->load->library('pagination');
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model('time_model');
		if (!$this->is_superadmin) {
			$paramController = $this->uri->segment(1);
			$param = strtolower($paramController);
			if (!in_array($param, $this->paramMenus)) {
				$this->session->set_flashdata('error', $this->lang->line('not_have_permission').' '.$paramController .'!');
				redirect(base_url('app'));
				return;
			}
		}
    }
    
    // private $api;
    
    public function index(){
		$this->data["pageName"] =  $this->lang->line('List_of_system_members');
		$name = !empty($_GET['name'])?$_GET['name']:'';
		$email = !empty($_GET['email'])?$_GET['email']:'';
		$number_phone = !empty($_GET['number_phone'])?$_GET['number_phone']:'';
		$type = !empty($_GET['type_user']) ? $_GET['type_user'] : '' ;
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('user?name='.$name.'&email='.$email.'&number_phone='.$number_phone.'&type_user='.$type);
		$config['uri_segment']=$uriSegment;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$data = array(
			'name'=> $name,
			'email' => $email,
			'number_phone' => $number_phone,
			'type_user' => $type,
			"per_page" => $config['per_page'],
			"uriSegment" => $config['uri_segment']
		);		
		$userData = $this->api->apiPost($this->user['token'], "user/list", $data);
		if(!empty($userData->status) && $userData->status == 200){
			$this->data['userData'] = $userData->data;
			$config['total_rows'] = $userData->count;
		}else{
			$this->data['userData'] = array();
		}
	
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();

		$this->data['template'] = 'page/user/list';
		$this->load->view('template', isset($this->data)?$this->data:NULL);
		return;
    }

		public function view() {
		$this->data["pageName"] = $this->lang->line('System_member_details');
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		if (empty($id)) {
			$this->session->set_flashdata('error', $this->lang->line('This_member_does_not_exist'));
			redirect(base_url('user'));
			return;
		}
		$data = array(
			"id" => $id
		);
		$userData = $this->api->apiPost($this->user['token'], "user/detail", $data);
		if(!empty($userData->status) && $userData->status == 200){
			$this->data['userData'] = $userData->data;
		}else{
			$this->data['userData'] = array();
		}
		$roleUser = $this->api->apiPost($this->user['token'], "groupRole/get_all");
		if (isset($roleUser->status) && $roleUser->status == 200) {
			$groupRoles = $roleUser->data;
		} else {
			$groupRoles = array();
		}
		$roleOfUserdt =  $this->api->apiPost($this->user['token'], "role/get_role_by_user", array('user_id'=>$id));
		if (isset($roleOfUserdt->status) && $roleOfUserdt->status == 200) {
			$roleOfUser = $roleOfUserdt->data->role_name;
			$storeOfUser = $roleOfUserdt->data->role_stores;
		} else {
			$roleOfUser = array();
			$storeOfUser = array();
		}
		
		$groupRoleOfUser =  $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array('user_id'=>$id));
		if (isset($groupRoleOfUser->status) && $groupRoleOfUser->status == 200) {
			$groupRoleOfUser = $groupRoleOfUser->data;
		} else {
			$groupRoleOfUser = array();
		}
		$this->data['groupRoles'] = $groupRoles;
		$this->data['roleOfUser'] = $roleOfUser;
		$this->data['groupRoleOfUser'] = $groupRoleOfUser;
	    $this->data['storeOfUser'] = $storeOfUser;
		$this->data['id'] = $id;
		$this->data['template'] = 'page/user/detail';
		$this->load->view('template', isset($this->data)?$this->data:NULL);
		return;
	}

	public function create() {
		$this->data["pageName"] = $this->lang->line('Registration_members');
		$roleUser = $this->api->apiPost($this->user['token'], "groupRole/get_all");
		if (isset($roleUser->status) && $roleUser->status == 200) {
			$groupRoles = $roleUser->data;
		} else {
			$groupRoles = array();
		}
		$this->data['template'] = 'page/user/addnew';
		$this->data['groupRoles'] = $groupRoles;
		$this->load->view('template', isset($this->data)?$this->data:NULL);
		return;
	}

	public function processCreateUser() {
		$data = $this->input->post();
		$data['email'] = $this->security->xss_clean($data['email']);
		$data['username'] = $this->security->xss_clean($data['username']);
		$data['full_name'] = $this->security->xss_clean($data['full_name']);
		$data['phone_number'] = $this->security->xss_clean($data['phone']);
		$data['identify'] = $this->security->xss_clean($data['identify']);
		$data['password'] = $this->security->xss_clean($data['password']);
		$data['group_role'] = $this->security->xss_clean($data['group_role']);
		$data['email'] = trim($data['email']);
		$data['username'] = trim($data['username']);
		$data['full_name'] = trim($data['full_name']);
		$data['phone_number'] = trim($data['phone_number']);
		$data['identify'] = trim($data['identify']);
		$data['password'] = trim($data['password']);
		if (empty($data['email'])) {
			$res = array(
				'status' => 500,
				'message' => $this->lang->line('required_email'),
			);
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $res)));
			return;
		}
		if (!$this->isValidEmail($data['email'])) {
			$res = array(
				'status' => 500,
				'message' => $this->lang->line('invalid_email'),
			);
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $res)));
			return;
		}
		if (empty($data['username'])) {
			$res = array(
				'status' => 500,
				'message' => $this->lang->line('required_username'),
			);
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $res)));
			return;
		}
		if (empty($data['full_name'])) {
			$res = array(
				'status' => 500,
				'message' => $this->lang->line('required_full_name'),
			);
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $res)));
			return;
		}
		if (empty($data['phone_number'])) {
			$res = array(
				'status' => 500,
				'message' => $this->lang->line('required_phone_number'),
			);
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $res)));
			return;
		}
		if (strlen($data['phone_number']) !== 10) {
			$res = array(
				'status' => 500,
				'message' => $this->lang->line('invalid_phone'),
			);
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $res)));
			return;
		}
		if (empty($data['password'])) {
			$res = array(
				'status' => 500,
				'message' => $this->lang->line('required_password'),
			);
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $res)));
			return;
		}
		if (strlen($data['username']) < 6 or strlen($data['username']) > 32) {
			$res = array(
				'status' => 500,
				'message' => "User name tối thiểu 6 kí tự tối đa 32 kí tự",
			);
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $res)));
			return;
		}
		if (strlen($data['password']) < 8) {
			$res = array(
				'status' => 500,
				'message' => $this->lang->line('required_length_password'),
			);
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $res)));
			return;
		}
		if (empty($data['identify'])) {
			$res = array(
				'status' => 500,
				'message' => $this->lang->line('required_indentify'),
			);
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $res)));
			return;
		}
		$language = !empty($this->session->userdata("language")) ? $this->session->userdata("language") : "vietnamese";
		$sendApi = array(
			'email' => $data['email'],
			'username' => $data['username'],
			'full_name' => $data['full_name'],
			'phone_number' => $data['phone_number'],
			'identify' => $data['identify'],
			'password' => $data['password'],
			'group_role' => $data['group_role'],
			'lang' => $language,
			"created_at" => $this->createdAt,
			"created_by" => $this->user['email'],
		);
		$return = $this->api->apiPost($this->user['token'], "user/process_create_user", $sendApi);
		$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		return;
	}

	private function isValidEmail($email) {
		$email = strtolower($email);
		return filter_var($email, FILTER_VALIDATE_EMAIL)
			&& preg_match('/@.+\./', $email);
	}

	public function processUpdateUser() {
		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['email'] = $this->security->xss_clean($data['email']);
		$data['username'] = $this->security->xss_clean($data['username']);
		$data['phone'] = $this->security->xss_clean($data['phone']);
		$data['identify'] = $this->security->xss_clean($data['identify']);
		$data['full_name'] = $this->security->xss_clean($data['full_name']);
		
		$status = isset($data['status']) ? $data['status'] : '';
		if (empty($data['id'])) {
			$res = array(
				'status' => 500,
				'message' => $this->lang->line('id user not null'),
			);
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $res)));
			return;
		}
		if (empty($data['full_name'])) {
			$res = array(
				'status' => 500,
				'message' => $this->lang->line('required_full_name'),
			);
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $res)));
			return;
		}
		if (empty($data['phone'])) {
			$res = array(
				'status' => 500,
				'message' => $this->lang->line('required_phone_number'),
			);
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $res)));
			return;
		}
		if (empty($data['identify'])) {
			$res = array(
				'status' => 500,
				'message' => $this->lang->line('required_indentify'),
			);
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $res)));
			return;
		}
		$sendApi = array(
			"id" => $data['id'],
			"email" => $data['email'],
			"username" => $data['username'],
			'phone_number' => $data['phone'],
			'identify' => $data['identify'],
			'full_name' => $data['full_name'],
			"updated_at" => $this->createdAt,
			"updated_by" => $this->user['email'],
		);
		if (!empty($status)) {
			$sendApi['status'] = $status;
		}
		$return = $this->api->apiPost($this->user['token'], "user/process_update_user", $sendApi);
		$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		return;
	}

    public function searchAutocomplete() {
        $data = $this->input->post();
        $data['name'] = $this->security->xss_clean($data['name']);
        $data['value'] = $this->security->xss_clean($data['value']);
        if(!empty($data['name'])) {
            $search = array(
                "name" => $data['name'],
                "value" => $data['value']
            );
            $res = $this->api->apiPost($this->user['token'], "user/search_autocomplete", $search);
            $arrRes = array();
            foreach($res->data as $item) {
                $data = array();
                $data['email'] = !empty($item->email) ? $item->email : "";
                $data['phone_number'] = !empty($item->phone_number) ? $item->phone_number : "" ;
                $data['identify'] = !empty($item->identify) ? $item->identify : "";
                $data['id'] = $item->_id->{'$oid'};
                array_push($arrRes, $data);
            }
            $this->pushJson('200', json_encode(array("code" => "200", "data" => $arrRes)));
        }
    }

	public function getMsg() {
    	$data = array(
    		'U1' => $this->lang->line('required_email'),
    		'U2' => $this->lang->line('invalid_email'),
    		'U3' => $this->lang->line('required_full_name'),
    		'U4' => $this->lang->line('required_phone_number'),
    		'U5' => $this->lang->line('invalid_phone'),
    		'U6' => $this->lang->line('required_password'),
    		'U7' => $this->lang->line('required_length_password'),
    		'U8' => $this->lang->line('required_indentify'),
    		'U9' => $this->lang->line('required_username'),
		);
    	echo json_encode($data);
    	return;
	}
    
    private function pushJson($code, $data) {
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($code)
            ->set_output($data);
    }

    function test(){

	}

}
?>

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
class BlackList extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		// $this->api = new Api();
		$this->load->model("time_model");
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

	private function pushJson($code, $data)
	{
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}

	public function index()
	{
		$data = array();
		$blacklist = $this->api->apiPost($this->userInfo['token'], "blacklist/get_blacklist", $data);
		$this->data['blacklist'] = $blacklist->data;
		$this->data['template'] = 'page/blacklist/blacklist';
        $groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
        if(!empty($groupRoles->status) && $groupRoles->status == 200){
            $this->data['groupRoles'] = $groupRoles->data;
        }else{
            $this->data['groupRoles'] = array();
        }
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

    public function getBlacklistById()
    {
        $data = $this->input->post();
        $result = $this->api->apiPost($this->userInfo['token'], "blacklist/getBlacklistById", $data);
        $response = [
            'res' => true,
            'status' => "200",
            'data' => $result->data
        ];
        echo json_encode($response);
//        return json_encode($response);
    }

	public function upload_blacklist() {
		$this->data['template'] = 'page/blacklist/upload_info_blacklist';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function upload($data = null, $isUpdate = false) {
        if(empty($data)) $data = $this->input->post();
		$url_image = !empty($data['url_image']) ? $data['url_image'] : '';
		$name = !empty($data['name']) ? $data['name'] : '';
		$phone = !empty($data['phone']) ? $data['phone'] : '';
		$identify = !empty($data['identify']) ? $data['identify'] : '';
		$note = !empty($data['note']) ? $data['note'] : '';
		if(!empty($url_image) && !empty($name) && !empty($phone) && !empty($identify) && !empty($note)) {
			$data_arr = array('image' =>  array('url' => $url_image, 'metadata' => array('name'=>$name,'phone'=>$phone,'identify'=>$identify,'note'=>$note,'status'=>'active') ) );
			$url = $this->config->item("API_CVS").'face_search/add';
			$result1 = $this->push_api_cvs($url,json_encode($data_arr));
			if($result1->status_code == 0) {
				$data = [
					'image' => $url_image,
					'name' => $name,
					'phone' => $phone,
					'identify' => $identify,
					'note' => $note,
					'id_img_cvs' => $result1->result->id,
				];
				$return = $this->api->apiPost($this->userInfo['token'], "blacklist/add_blacklist", $data);
				if(!empty($return) && $return->status == 200) {
				    if($isUpdate){
				        return true;
                    }
					$this->session->set_flashdata('success', $this->lang->line('upload_success'));
					redirect('BlackList');
				} else {
					$this->session->set_flashdata('error', $this->lang->line('upload_failed'));
					redirect('BlackList/upload_blacklist');
				}
			} else {
				$this->session->set_flashdata('error', $this->lang->line('upload_failed'));
				redirect('BlackList/upload_blacklist');
			}
		} else {
			$this->session->set_flashdata('error', 'Bạn cần nhập đầy đủ thông tin');
			redirect('BlackList/upload_blacklist');
		}
	}

    public function deleteBlacklist($data = null, $isUpdate = false) {
	    if(empty($data)) $data = $this->input->post();
        $data_arr = array("ids" => array((int)$data['id_img_cvs']));
        $url = $this->config->item("API_CVS").'face_search/delete';
        $result1 = $this->push_api_cvs($url,json_encode($data_arr));
//        if($result1->status_code == 0 || $result1->status_code == 6) {
        if($result1->status_code == 0) {
            $return = $this->api->apiPost($this->userInfo['token'], "blacklist/deleteBlacklist", $data);
            if(!empty($return) && $return->status == 200) {
                if($isUpdate) return;
                $this->session->set_flashdata('success', "Xóa thành công!");
                $response = [
                    'status' => "200",
                    'message' => "Xóa thành công!"
                ];
                echo json_encode($response);
//                redirect('BlackList');
                return;
            } else {
                $this->session->set_flashdata('error', "Xóa thất bại!");
                $response = [
                    'status' => "400",
                    'message' => "Xóa thất bại!"
                ];
                echo json_encode($response);
                return;
            }
        } else {
            $this->session->set_flashdata('error', "Xóa thất bại!");
            $response = [
                'status' => "400",
                'message' => "Xóa thất bại!"
            ];
            echo json_encode($response);
            return;
        }
    }

    public function updateBlacklist() {
        $data = $this->input->post();
        $res = $this->upload($data, true);
        if(!empty($res) && $res == true ) $this->deleteBlacklist($data, true);
        redirect('BlackList');
    }

	public function doUpdateStatusBlacklist() {
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$status = ($status=='true') ? 'active' : 'deactive';
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_image_selected_deletion')
			];
			echo json_encode($response);
			return;
		}
		if (empty($status)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_image_selected_deletion')
			];
			echo json_encode($response);
			return;
		}
		$data = array(
			"status" => $status,
			"id" => $id
		);
		$result = $this->api->apiPost($this->userInfo['token'], "blacklist/update_blacklist", $data);
		$response = [
			'res' => true,
			'status' => "200",
			'message' => $result->message
		];
		echo json_encode($response);
		return;
	}

	private function push_api_cvs($url='',$data_post=[]){
		$username =$this->config->item("CVS_API_KEY");
		$password = $this->config->item("CVS_API_SECRET");
		$service = $url;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$service);
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close ($ch);
		$result1 = json_decode($result);
		return $result1;
	}
}

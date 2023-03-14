<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class App extends MY_Controller{
    public function __construct(){
        parent::__construct();
    }
    public function index(){
        $this->data["pageName"] = "Dashboard";
        $this->data['template'] = 'page/dashboard/index';
		$token = !empty($_POST['token']) ? $_POST['token'] : '';
		$data = array(
			"token" => $token,
		);

		$result = $this->api->apiPost($this->user['token'], "service/save_token", $data);

        try{
			$res = $this->api->apiPost($this->user['token'], "dashboard/getData");

			$this->data['data'] = $res->data;
			$this->load->view('template', isset($this->data)?$this->data:NULL);
		}catch (\Exception $exception){
			$this->data['data'] = '';
			$this->load->view('template', isset($this->data)?$this->data:NULL);
		}
//        $res = $this->api->apiPost($this->user['token'], "dashboard/index");
    }

    public function synchronized(){

		$res = $this->api->apiPost($this->user['token'], "dashboard/synchronized");
		if($res->status == 200){
			$this->session->set_flashdata('success', "Cập nhật thành công");
			redirect('app');
		}else{
			$this->session->set_flashdata('error', "Cập nhật thất bại");
			redirect('app');
		}
	}

	public function update_total(){

		$res = $this->api->apiPost($this->user['token'], "dashboard/update_total");
		if($res->status == 200){
			$this->session->set_flashdata('success', "Cập nhật thành công");
			redirect('app');
		}else{
			$this->session->set_flashdata('error', "Cập nhật thất bại");
			redirect('app');
		}
	}

	public function search(){
		$this->data["pageName"] = "Dashboard";
		$this->data['template'] = 'page/dashboard/index';
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		if(!empty($_GET['fdate']) && !empty($_GET['tdate'])){
			$cond = array(
				"start" => $start,
				"end" => $end,
			);
			$res = $this->api->apiPost($this->user['token'], "dashboard/search",$cond);
			$this->data['data'] = $res->data;
		}else{
			$this->session->set_flashdata('error', "Phải nhập khoảng ngày cần xem");
			redirect(base_url('app'));
		}
		$this->load->view('template', isset($this->data)?$this->data:NULL);
	}

	public function saveToken() {

		if (isset($result->status) && $result->status == 200) {
			$response = [
				'status' => 200,
				'msg' => 'Lưu thành công!'
			];
			$this->pushJson('200', json_encode($response));
			return;
		} else {
			$response = [
				'status' => 400,
				'msg' => 'Có lỗi trong quá trình lưu token!'
			];
			$this->pushJson('200', json_encode($response));
			return;
		}
	}

	private function pushJson($code, $data) {
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}


}
?>

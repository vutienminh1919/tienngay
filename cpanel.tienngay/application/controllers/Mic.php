<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
class Mic extends MY_Controller
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


	public function doResend()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		
		if (empty($id)) {
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => 'Mã MIC trống'
			];
			echo json_encode($response);
			return;
		}
		
		$data = array(
			
			"id"=>$id

		);

		$return = $this->api->apiPost($this->userInfo['token'], "mic/resend_mic", $data);
      // die;
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => 'Gửi lại thành công'
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => 'Gửi lại thất bại'
			];
			echo json_encode($response);
			return;
		}
	}

	public function listMic()
	{
        $uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$config = $this->config->item('pagination');
        $config['per_page'] = 30;
		$config['uri_segment'] = $uriSegment;
		$data = array(
				'type_mic'=>'MIC_TDCN',
				"per_page" => $config['per_page'],
				"uriSegment" => $config['uri_segment']
			);
		if(!empty($start) && !empty($end) && strtotime($start) > strtotime($end)){
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('mic/listMic'));
		}

		if(!empty($_GET['fdate']) && !empty($_GET['tdate'])){

			$data['start'] = $start;
			$data['end'] = $end;

		}
         $config['enable_query_strings'] = true;

		$config['page_query_string'] = true;
		$config['base_url'] = base_url('mic/listMic');
		$this->data["pageName"] = $this->lang->line('Mic_manager');
		$micData = $this->api->apiPost($this->userInfo['token'], "mic/get_all", $data);

		if (!empty($micData->status) && $micData->status == 200) {
			$this->data['micData'] = $micData->data;
			$this->data['groupRoles'] = $micData->groupRoles;
			$config['total_rows'] = $micData->total;
		} else {
			$this->data['micData'] = array();
		}
          $this->pagination->initialize($config);
       $this->data['result_count']= "Hiển thị ".$config['total_rows']." Kết quả";
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/mic/list_mic';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
	public function listMic_investor()
	{
          $uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('mic/listMic_investor');
		$this->data["pageName"] = 'MIC INVESTOR';
			$config['per_page'] = 30;
			$config['enable_query_strings'] = true;
			$config['page_query_string'] = true;
			$config['uri_segment'] = $uriSegment;
		$data = array(
				'type_mic'=>'MIC_TDT',
				"per_page" => $config['per_page'],
				"uriSegment" => $config['uri_segment']
			);
		if(strtotime($start) > strtotime($end)){
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('mic/listMic_investor'));
		}

		if(!empty($_GET['fdate']) && !empty($_GET['tdate'])){

			$data['start'] = $start;
			$data['end'] = $end;

		}
		$micData = $this->api->apiPost($this->userInfo['token'], "mic/get_all", $data);
		if (!empty($micData->status) && $micData->status == 200) {
			$this->data['micData'] = $micData->data;
			$config['total_rows'] = $micData->total;
		} else {
			$this->data['micData'] = array();
		}
          $this->pagination->initialize($config);
       $this->data['result_count']= "Hiển thị ".$config['total_rows']." Kết quả";
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/mic/list_mic_investor';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
	public function listMic_log()
	{
         $uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->data["pageName"] = 'LOG MIC';
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('mic/listMic_log');
		$this->data["pageName"] = 'MIC LOG';
			$config['per_page'] = 30;
			$config['enable_query_strings'] = true;
			$config['page_query_string'] = true;
			$config['uri_segment'] = $uriSegment;
		$data = array(
			
				"per_page" => $config['per_page'],
				"uriSegment" => $config['uri_segment']
			);

		$micData = $this->api->apiPost($this->userInfo['token'], "mic/get_all_log", $data);
		if (!empty($micData->status) && $micData->status == 200) {
			$this->data['micData'] = $micData->data;
			$config['total_rows'] = $micData->total;
		} else {
			$this->data['micData'] = array();
		}
          $this->pagination->initialize($config);
       $this->data['result_count']= "Hiển thị ".$config['total_rows']." Kết quả";
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/mic/list_mic_log';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
	    public function restore_mic_kv(){

        $data = $this->input->post();
        $data['id_contract'] = $this->security->xss_clean($data['id_contract']);
        //var_dump('expression'); die;
        $result = $this->api->apiPost($this->userInfo['token'], "contract/restore_mic_kv", $data);
	       if(!empty($result->status) && $result->status == 200) 
	        {
	            $response = [
	                'res' => true,
	                'code' => "200",
	                 'msg' => $result->message
	            ];
	            echo json_encode($response);
	            return;
	        }else{
	            $response = [
	                'res' => false,
	                'code' => "400",
	                'msg' => $result->message
	            ];
	            echo json_encode($response);
	            return;
	        }
	    }
	
	

	
}


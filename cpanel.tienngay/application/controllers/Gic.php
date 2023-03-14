<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
class Gic extends MY_Controller
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



	public function listGic()
	{
      $uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$config = $this->config->item('pagination');
      $config['per_page'] = 30;
		$config['uri_segment'] = $uriSegment;
		
		$data = array(
			"per_page" => $config['per_page'],
			"uriSegment" => $config['uri_segment']
		);

		if(!empty($start) && !empty($end) && strtotime($start) > strtotime($end)){
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('gic/listGic'));
		}

		if(!empty($_GET['fdate']) && !empty($_GET['tdate'])){
			$data['start'] = $start;
			$data['end'] = $end;
		}
      $config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$config['base_url'] = base_url('gic/listGic?fdate='.$start.'&tdate='.$end);
		$this->data["pageName"] = $this->lang->line('Gic_manager');
		$gicData = $this->api->apiPost($this->userInfo['token'], "gic/get_all", $data);
		if (!empty($gicData->status) && $gicData->status == 200) {
			$this->data['gicData'] = $gicData->data;
			$config['total_rows'] = $gicData->total;
		} else {
			$this->data['gicData'] = array();
		}
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
      $this->pagination->initialize($config);
      $this->data['result_count']= "Hiển thị ".$config['total_rows']." Kết quả";
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/gic/list_gic';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function listGic_easy()
	{
      $uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('gic/listGic_easy?fdate='.$start.'&tdate='.$end);
		$this->data["pageName"] = 'GIC EASY';
		$config['per_page'] = 30;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$data = array(
			"per_page" => $config['per_page'],
			"uriSegment" => $config['uri_segment']
		);
		if(!empty($start) && !empty($end) && strtotime($start) > strtotime($end)){
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('gic/listGic_easy'));
		}

		if(!empty($_GET['fdate']) && !empty($_GET['tdate'])){
			$data['start'] = $start;
			$data['end'] = $end;

		}
		$gicData = $this->api->apiPost($this->userInfo['token'], "gic_easy/get_all", $data);
		if (!empty($gicData->status) && $gicData->status == 200) {
			$this->data['gicData'] = $gicData->data;
			$config['total_rows'] = $gicData->total;
		} else {
			$this->data['gicData'] = array();
		}
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
      $this->pagination->initialize($config);
      $this->data['result_count']= "Hiển thị ".$config['total_rows']." Kết quả";
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/gic/list_gic_easy';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
	public function listGic_plt()
	{
          $uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('gic/listGic_plt?fdate='.$start.'&tdate='.$end);
		$this->data["pageName"] = 'GIC PLT';
			$config['per_page'] = 30;
			$config['enable_query_strings'] = true;
			$config['page_query_string'] = true;
			$config['uri_segment'] = $uriSegment;
		$data = array(
				
				"per_page" => $config['per_page'],
				"uriSegment" => $config['uri_segment']
			);
		if(!empty($start) && !empty($end) && strtotime($start) > strtotime($end)){
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('gic/listGic_plt'));
		}

		if(!empty($_GET['fdate']) && !empty($_GET['tdate'])){

			$data['start'] = $start;
			$data['end'] = $end;

		}
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		//var_dump($this->userInfo['token']); die;
		$gicData = $this->api->apiPost($this->userInfo['token'], "gic_plt/get_all", $data);
		if (!empty($gicData->status) && $gicData->status == 200) {
			$this->data['gicData'] = $gicData->data;
			$config['total_rows'] = $gicData->total;
		} else {
			$this->data['gicData'] = array();
		}
          $this->pagination->initialize($config);
       $this->data['result_count']= "Hiển thị ".$config['total_rows']." Kết quả";
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/gic/list_gic_plt';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
	public function listGic_log()
	{
        
		 $uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('gic/listGic_log');
		$this->data["pageName"] = 'GIC LOG';
			$config['per_page'] = 30;
			$config['enable_query_strings'] = true;
			$config['page_query_string'] = true;
			$config['uri_segment'] = $uriSegment;
		$data = array(
				
				"per_page" => $config['per_page'],
				"uriSegment" => $config['uri_segment']
			);
		$gicData = $this->api->apiPost($this->userInfo['token'], "gic_easy/get_all_log", $data);
		if (!empty($gicData->status) && $gicData->status == 200) {
			$this->data['gicData'] = $gicData->data;
				$config['total_rows'] = $gicData->total;
		} else {
			$this->data['gicData'] = array();
		}
          $this->pagination->initialize($config);

       $this->data['result_count']= "Hiển thị ".$config['total_rows']." Kết quả";
		$this->data['pagination'] = $this->pagination->create_links();

        
		$this->data['template'] = 'page/gic/list_gic_log';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
	
     public function restore_gic_plt(){

        $data = $this->input->post();
        $data['id_contract'] = $this->security->xss_clean($data['id_contract']);
        $result = $this->api->apiPost($this->userInfo['token'], "contract/restore_gic_plt", $data);
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
	
	    public function restore_gic_easy(){

        $data = $this->input->post();
        $data['id_contract'] = $this->security->xss_clean($data['id_contract']);
        $result = $this->api->apiPost($this->userInfo['token'], "contract/restore_gic_easy", $data);
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

		    public function restore_gic_kv(){

        $data = $this->input->post();
        $data['id_contract'] = $this->security->xss_clean($data['id_contract']);
        $result = $this->api->apiPost($this->userInfo['token'], "contract/restore_gic_kv", $data);
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

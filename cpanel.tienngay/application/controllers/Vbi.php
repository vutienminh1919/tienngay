<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
class Vbi extends MY_Controller
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



	public function listVbi()
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
			redirect(base_url('vbi/listVbi'));
		}
		if (!empty($start)) {
			$data['start'] = $start;
		}
		if (!empty($end)) {
			$data['end'] = $end;
		}
		$config['enable_query_strings'] = true;

		$config['page_query_string'] = true;
		$config['base_url'] = base_url('vbi/listVbi?fdate='.$start.'&tdate='.$end);
		$this->data["pageName"] = $this->lang->line('Gic_manager');


		$vbiData = $this->api->apiPost($this->userInfo['token'], "vbi/get_all", $data);
		if (!empty($vbiData->status) && $vbiData->status == 200) {
			$this->data['vbiData'] = $vbiData->data;
			$config['total_rows'] = $vbiData->total;
		} else {
			$this->data['gicData'] = array();
		}
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
//		echo "<pre>";
//		var_dump($gicData->data[0]->contract_info);
//		echo "</pre>";
		$this->pagination->initialize($config);
		$this->data['result_count']= "Hiển thị ".$config['total_rows']." Kết quả";
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/vbi/list_vbi';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

     public function restore_vbi(){

        $data = $this->input->post();
        $data['id_contract'] = $this->security->xss_clean($data['id_contract']);
        //var_dump('expression'); die;
        $result = $this->api->apiPost($this->userInfo['token'], "contract/restore_vbi", $data);
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

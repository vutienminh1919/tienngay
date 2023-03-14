<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DepreciationProperty extends MY_Controller {
    public function __construct() {
        parent::__construct();
        // $this->api = new Api();
        $this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
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
    
    public function index() {
        $this->data["pageName"] = $this->lang->line('asset_depreciation_manage');
        $datas = $this->api->apiPost($this->user['token'], "depreciationProperty/get_data");
        // get tài sản cha cấp cao nhất 
        $mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main");
        if(!empty($mainPropertyData->status) && $mainPropertyData->status == 200){
            $this->data['mainPropertyData'] = $mainPropertyData->data;
        }else{
            $this->data['mainPropertyData'] = array();
        }

        $this->data['datas'] = $datas->data;
        $this->data['template'] = 'web/depreciation_property';
        $this->load->view('template', isset($this->data) ? $this->data:NULL);
    }
        
    public function create() {
        $data = $this->input->post();
        $data['name'] = $this->security->xss_clean($data['name']);
        $data['property_id'] = $this->security->xss_clean($data['property_id']);
        $insert = array(
            "name" => $data['name'],
            "property_id" => $data['property_id'],
            "slug" => slugify($data['name']),
            "status" => "active"
        );
        $return = $this->api->apiPost($this->user['token'], "depreciationProperty/create", $insert);
        $this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
    }
    
    public function update() {
        //Update như bình thường
        $data = $this->input->post();
        $data['id'] = $this->security->xss_clean($data['id']);
        $data['name'] = $this->security->xss_clean($data['name']);
        $data['property_id'] = $this->security->xss_clean($data['property_id']);
        $update = array(
            "id" => $data['id'],
            "name" => $data['name'],
            "property_id" => $data['property_id'],
            "slug" => slugify($data['name'])
        );
        $response = $this->api->apiPost($this->user['token'], "depreciationProperty/update", $update);
        $this->pushJson('200', json_encode(array("code" => "200", "data" => $response)));
    }
    
    public function delete() {
        $data = $this->input->post();
        $data['id'] = $this->security->xss_clean($data['id']);
        $update = array(
            "id" => $data['id'],
            "status" => "deactive"
        );
        $this->api->apiPost($this->user['token'], "depreciationProperty/delete", $update);
        $this->pushJson('200', json_encode(array("code" => "200", "messsage" => "Delete success!")));
    }
    
    private function pushJson($code, $data) {
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($code)
            ->set_output($data);
    }
    
}

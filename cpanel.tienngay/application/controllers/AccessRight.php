<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AccessRight extends MY_Controller {
    public function __construct() {
        parent::__construct();
        // $this->api = new Api();
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
        $accessRights = $this->api->apiPost($this->user['token'], "accessRight/get_all");
        $this->data['access_right'] = $accessRights->data;
        $this->data['template'] = 'web/access_right/index';
        $this->load->view('template', isset($this->data)?$this->data:NULL);
    }
    
    public function create() {
        $data = $this->input->post();
        $insert = array();
        $insert['status'] = "active";
        $insert['name'] = $this->security->xss_clean($data['name']);
        $insert['description'] = $this->security->xss_clean($data['description']);
        $insert['slug'] = slugify($insert['name']);
        $res = $this->api->apiPost($this->user['token'], "accessRight/create", $insert);
        $this->pushJson('200', json_encode(array("code" => "200", "data" => $res)));
    }
    
    public function update() {
        $data = $this->input->post();
        $this->data['id'] = $this->security->xss_clean($data['id']);
        $this->data['name'] = $this->security->xss_clean($data['name']);
        $this->data['description'] = $this->security->xss_clean($data['description']);
        if(empty($this->data['id']) || empty($this->data['name'])) {
            $this->pushJson('200', json_encode(array("code" => "201", "message" => "Data post can not empty")));
            return;
        }
        $update = array(
            "id" => $this->data['id'],
            "name" => $this->data['name'],
            "slug" => slugify($this->data['name']),
            "description" => $this->data['description'],
        );
        
        $res = $this->api->apiPost($this->user['token'], "accessRight/update", $update);
        $this->pushJson('200', json_encode(array("code" => "200", "message" => $res)));
    }
   
    
    private function pushJson($code, $data) {
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($code)
            ->set_output($data);
    }
    
    public function delete() {
        $dataPost = $this->input->post();
        $this->data['id'] = $this->security->xss_clean($dataPost['id']);
        $post = array(
            "id" => $this->data['id']
        );
        $this->api->apiPost($this->user['token'], "accessRight/delete", $post);
        $this->pushJson('200', json_encode(array("code" => "200", "data" => "Delete success")));
    }
}

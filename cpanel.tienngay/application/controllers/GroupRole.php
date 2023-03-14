<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GroupRole extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("user_model");
        $this->load->model("store_model");
        $this->load->model("menu_model");
        $this->load->model("role_model");

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
    
    public function search() {
        $this->data["pageName"] = $this->lang->line('group_role_management');
        $groupRoles = $this->api->apiPost($this->user['token'], "groupRole/get_all");
        $this->data['groupRoles'] = $groupRoles;
        $this->data['template'] = 'web/group_role/search';
        $this->load->view('template', isset($this->data)?$this->data:NULL);
    }
    
    public function displayCreate() {
        $this->data["pageName"] = $this->lang->line('group_role_management');
        $this->data['template'] = 'web/group_role/create';
        $this->load->view('template', isset($this->data)?$this->data:NULL);
    }
    
    public function create() {
        $data = $this->input->post();
        $this->data['role_name'] = $this->security->xss_clean($data['role_name']);
        $this->data['users'] = $this->security->xss_clean($data['users']);
        $this->data['users'] = json_decode($data['users']);
        
        $insert = array();
        $insert['status'] = "active";
        $insert['name'] = $this->data['role_name'];
        $insert['slug'] = slugify($this->data['role_name']);
        $insert['created_at'] = $this->createdAt;
        $insert['created_by'] = $this->data['userSession']['id'];
        if(count($this->data['users']) > 0) {
            $insert['users'] = $this->data['users'];
        }
        $this->api->apiPost($this->user['token'], "groupRole/create", $insert);
        $this->pushJson('200', json_encode(array("code" => "200", "data" => $this->data)));
    }
    
    public function update() {
        $data = $this->input->post();
        $this->data['role_name'] = $this->security->xss_clean($data['role_name']);
        $this->data['users'] = $this->security->xss_clean($data['users']);
        $this->data['role_id'] = $this->security->xss_clean($data['role_id']);
        $this->data['users'] = json_decode($data['users']);
        
        if(empty($this->data['role_id']) || empty($this->data['role_name'])) {
            $this->pushJson('200', json_encode(array("code" => "201", "message" => $this->lang->line('Rights_group_name_empty'))));
            return;
        }
        
        $update = array();
        $update['users'] = "";
        $update['role_id'] = $this->data['role_id'];
        $update['name'] = $this->data['role_name'];
        if(count($this->data['users']) > 0) {
            $update['users'] = $this->data['users'];
        }
        $res = $this->api->apiPost($this->user['token'], "groupRole/update", $update);
        $this->pushJson('200', json_encode(array("code" => "200", "message" => $res)));
    }
    
    public function getUser() {
        $data = $this->input->post();
        $this->data['user_ids'] = $this->security->xss_clean($data['user_ids']);
        $this->data['user_ids'] = json_decode($data['user_ids']);
        $users = array();
        if(!empty($this->data['user_ids'])) {
            $userids = array();
            for($i=0; $i < count($this->data['user_ids']); $i++) array_push($userids, $this->data['user_ids'][$i]);
            $dataPost = array(
                "where" => array("status" => "active"),
                "fields" => "_id",
                "not_in" => $userids
            );
            $users = $this->api->apiPost($this->user['token'], "user/find_where_not_in", $dataPost);
        } else {
            $dataPost = array("status" => "active");
            $users = $this->api->apiPost($this->user['token'], "user/find_where", $dataPost);
        }
        $res = array();
        foreach($users->data as $item) {
            $arr = array();
            $arr['id'] = getId($item->_id);
            $arr['email'] = $item->email;
            array_push($res, $arr);
        }
        $this->pushJson('200', json_encode(array("code" => "200", "data" => $res)));
    }
    
    private function pushJson($code, $data) {
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($code)
            ->set_output($data);
    }
    
    public function displayUpdate() {
        $this->data["pageName"] = $this->lang->line('Update_group_permissions');
        $dataGet = $this->input->get();
        $this->data['id'] = $this->security->xss_clean($dataGet['id']);
        $dataPost = array(
            "id" => $this->data['id']
        );
        $role = $this->api->apiPost($this->user['token'], "groupRole/get_one", $dataPost);
        $this->data['template'] = 'web/group_role/update';
        $this->data['role'] = $role->data;
        $this->load->view('template', isset($this->data)?$this->data:NULL);
    }
    
    public function delete() {
        $dataPost = $this->input->post();
        $this->data['id'] = $this->security->xss_clean($dataPost['id']);
        $post = array(
            "id" => $this->data['id']
        );
        $this->api->apiPost($this->user['token'], "groupRole/delete", $post);
        $this->pushJson('200', json_encode(array("code" => "200", "data" => $this->lang->line('Delete_success'))));
    }
    
}

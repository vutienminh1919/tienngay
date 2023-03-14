<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Menu extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("menu_model");
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
    
    
    public function index() {
        $this->data["pageName"] = $this->lang->line('category_manage');
        $menus = $this->api->apiPost($this->user['token'], "menu/get_menu_all");
        $this->data['menu'] = $menus->data;
        $this->data['template'] = 'web/menu/index';
        $this->load->view('template', isset($this->data) ? $this->data:NULL);
    }
        
    public function create() {
        $data = $this->input->post();
        $data['name'] = $this->security->xss_clean($data['name']);
        $data['icon_menu'] = $this->security->xss_clean($data['icon_menu']);
        $data['url'] = $this->security->xss_clean($data['url']);
        $data['parent_id'] = $this->security->xss_clean($data['parent_id']);
        $data['language'] = $this->security->xss_clean($data['language']);
        $data['description'] = $this->security->xss_clean($data['description']);
        $data['parent_id'] = strtolower($data['parent_id']) == "none" ? "" : $data['parent_id'];
        $parentName = "";
        if(!empty($data['parent_id'])) {
            $parentInfor = $this->api->apiPost(
                    $this->user['token'], 
                    "menu/get_one", 
                    array("id" => $data['parent_id'], "type" => 1)
            );
            $parentName = $parentInfor->data->name;
        }
        if(empty($data['name'])) {
            $this->pushJson('200', json_encode(array(
                "code" => "201", 
                "message" => $this->lang->line('required_name')
            )));
            return;
        }
        $insert = array(
            "name" => $data['name'],
            "icon" => $data['icon_menu'],
            "url" => $data['url'],
            "slug" => slugify($data['name']),
            "parent_id" => $data['parent_id'],
            "parent_name" => $parentName,
            "language" => $data['language'],
            "description" => $data['description'],
            "status" => "active"
        );
        
    
        
        $return = $this->api->apiPost($this->user['token'], "menu/create", $insert);
        $this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
    }
    
    public function update() {
        //Update như bình thường
        $data = $this->input->post();
        $data['id'] = $this->security->xss_clean($data['id']);
        $data['name'] = $this->security->xss_clean($data['name']);
        $data['icon'] = $this->security->xss_clean($data['icon']);
        $data['url'] = $this->security->xss_clean($data['url']);
        $data['parent_id'] = $this->security->xss_clean($data['parent_id']);
        $data['language'] = $this->security->xss_clean($data['language']);
        $data['description'] = $this->security->xss_clean($data['description']);
        $data['parent_id'] = $data['parent_id'] == "none" ? "" : $data['parent_id'];
        $parentName = "";
        if(!empty($data['parent_id'])) {
            $parentInfor = $this->api->apiPost(
                    $this->user['token'], 
                    "menu/get_one", 
                    array("id" => $data['parent_id'])
            );
            $parentName = $parentInfor->data->name;
        }
        if(empty($data['name'])) {
            $this->pushJson('200', json_encode(array(
                "code" => "201", 
                "message" => $this->lang->line('required_name')
            )));
            return;
        }
        $update = array(
            "id" => $data['id'],
            "name" => $data['name'],
            "icon" => $data['icon'],
            "url" => $data['url'],
            "slug" => slugify($data['name']),
            "parent_id" => $data['parent_id'],
            "language" => $data['language'],
            "parent_name" => $parentName,
            "description" => $data['description']
        );
        
//        var_dump($update);
//        die;
        
        $response = $this->api->apiPost($this->user['token'], "menu/update", $update);
        $this->pushJson('200', json_encode(array("code" => "200", "data" => $response)));
    }
    
    public function delete() {
        $data = $this->input->post();
        $data['id'] = $this->security->xss_clean($data['id']);
        $count = $this->api->apiPost($this->user['token'], "menu/count", array("parent_id" => $data['id'],"status" => "active"));
        //Nếu có con thì tìm parent của nó và update parent cho toàn bộ các thằng con
        if($count->count > 0) {
            $menu = $this->api->apiPost($this->user['token'], "menu/get_one", array("id" => $data['id'], "status" => "active"));
            $newParent = $menu->data->parent_id;
            $childs = $this->api->apiPost($this->user['token'], "menu/get_where", array("parent_id" => $data['id']));
            foreach($childs->data as $child) {
                $this->api->apiPost($this->user['token'], "menu/update", array("id" => getId($child->_id), "parent_id" => $newParent));
            }
        }
        $this->api->apiPost($this->user['token'], "menu/update", array("parent_id" => $data['id']));
        $update = array(
            "id" => $data['id'],
            "status" => "deactive"
        );
        $this->api->apiPost($this->user['token'], "menu/update", $update);
        $this->pushJson('200', json_encode(array("code" => "200", "messsage" => "Delete success!")));
    }
    
    private function pushJson($code, $data) {
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($code)
            ->set_output($data);
    }
    
}

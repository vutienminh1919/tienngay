<?php

class Role extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("user_model");
        $this->load->model("store_model");
        $this->load->model("menu_model");
        $this->load->model("role_model");
        // $this->api = new Api();

		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";

	}
    
    // private $api;
    
    public function search() {
        $this->data["pageName"] = $this->lang->line('Rights_group_management');
        $roles = $this->api->apiPost($this->user['token'], "role/get_all");
        $this->data['roles'] = $roles;
        $this->data['template'] = 'web/role/search';
        $this->load->view('template', isset($this->data)?$this->data:NULL);
    }
    
    public function displayCreate() {
        $this->data["pageName"] = $this->lang->line('Decentralized_group');
        $this->data['template'] = 'web/role/create';
        $this->load->view('template', isset($this->data)?$this->data:NULL);
    }
    
    public function create() {
        $data = $this->input->post();
        $this->data['role_name'] = $this->security->xss_clean($data['role_name']);
        $this->data['users'] = $this->security->xss_clean($data['users']);
        $this->data['stores'] = $this->security->xss_clean($data['stores']);
        $this->data['menus'] = $this->security->xss_clean($data['menus']);
        $this->data['accessRights'] = $this->security->xss_clean($data['accessRights']);
        $this->data['users'] = json_decode($data['users']);
        $this->data['stores'] = json_decode($data['stores']);
        $this->data['menus'] = json_decode($data['menus']);
        $this->data['accessRights'] = json_decode($data['accessRights']);
        
        $insert = array();
        $insert['status'] = "active";
        $insert['name'] = $this->data['role_name'];
        $insert['slug'] = slugify($this->data['role_name']);
        $insert['created_at'] = $this->createdAt;
        $insert['created_by'] = $this->data['userSession']['id'];
        if(count($this->data['users']) > 0) {
            $insert['users'] = $this->data['users'];
        }
        if(count($this->data['stores']) > 0) {
            $insert['stores'] = $this->data['stores'];
        }
        if(count($this->data['menus']) > 0) {
            $insert['menus'] = $this->data['menus'];
        }
        if(count($this->data['accessRights']) > 0) {
            $insert['access_rights'] = $this->data['accessRights'];
        }
        $this->api->apiPost($this->user['token'], "role/create", $insert);
        $this->pushJson('200', json_encode(array("code" => "200", "data" => $this->data)));
    }
    
    public function update() {
        $data = $this->input->post();
        $this->data['role_name'] = $this->security->xss_clean($data['role_name']);
        $this->data['users'] = $this->security->xss_clean($data['users']);
        $this->data['stores'] = $this->security->xss_clean($data['stores']);
        $this->data['menus'] = $this->security->xss_clean($data['menus']);
        $this->data['accessRights'] = $this->security->xss_clean($data['accessRights']);
        $this->data['role_id'] = $this->security->xss_clean($data['role_id']);
        $this->data['users'] = json_decode($data['users']);
        $this->data['stores'] = json_decode($data['stores']);
        $this->data['menus'] = json_decode($data['menus']);
        $this->data['accessRights'] = json_decode($data['accessRights']);
        
        if(empty($this->data['role_id']) || empty($this->data['role_name'])) {
            $this->pushJson('200', json_encode(array("code" => "201", "message" => $this->lang->line('Rights_group_name_empty'))));
            return;
        }
        
        $update = array();
        $update['users'] = "";
        $update['stores'] = "";
        $update['menus'] = "";
        $update['access_rights'] = "";
        $update['role_id'] = $this->data['role_id'];
        $update['name'] = $this->data['role_name'];
        if(count($this->data['users']) > 0) {
            $update['users'] = $this->data['users'];
        }
        if(count($this->data['stores']) > 0) {
            $update['stores'] = $this->data['stores'];
        }
        if(count($this->data['menus']) > 0) {
            $update['menus'] = $this->data['menus'];
        }
        if(count($this->data['accessRights']) > 0) {
            $update['access_rights'] = $this->data['accessRights'];
        }
        $res = $this->api->apiPost($this->user['token'], "role/update", $update);
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
    
    public function getStore() {
        $data = $this->input->post();
        $this->data['store_ids'] = $this->security->xss_clean($data['store_ids']);
        $this->data['store_ids'] = json_decode($data['store_ids']);
        $stores = array();
        if(!empty($this->data['store_ids'])) {
            $storeids = array();
            for($i=0; $i < count($this->data['store_ids']); $i++) array_push($storeids, $this->data['store_ids'][$i]);
            $dataPost = array(
                "where" => array("status" => "active"),
                "fields" => "_id",
                "not_in" => $storeids
            );
            $stores = $this->api->apiPost($this->user['token'], "store/find_where_not_in", $dataPost);
        } else {
            $dataPost = array("status" => "active");
            $stores = $this->api->apiPost($this->user['token'], "store/find_where", $dataPost);
        }
        $res = array();
        foreach($stores->data as $item) {
            $arr = array();
            $arr['id'] = getId($item->_id);
            $arr['name'] = $item->name;
            $arr['province'] = $item->province;
            $arr['district'] = $item->district;
            $arr['address'] = $item->address;
            $arr['code_area'] = $item->code_area;
            array_push($res, $arr);
        }

        $this->pushJson('200', json_encode(array("code" => "200", "data" => $res)));
    }
    public function getMenu() {
        $data = $this->input->post();
        $this->data['menu_ids'] = $this->security->xss_clean($data['menu_ids']);
        $this->data['menu_ids'] = json_decode($data['menu_ids']);
        $menus = array();
        if(!empty($this->data['menu_ids'])) {
            $menuids = array();
            for($i=0; $i < count($this->data['menu_ids']); $i++) array_push($menuids, $this->data['menu_ids'][$i]);
            $dataPost = array(
                "where" => array("status" => "active"),
                "fields" => "_id",
                "not_in" => $menuids
            );
            $menus = $this->api->apiPost($this->user['token'], "menu/find_where_not_in", $dataPost);
        } else {
            $dataPost = array(
                "status" => "active",
            );
            $menus = $this->api->apiPost($this->user['token'], "menu/find_where", $dataPost);
        }
        $res = array();
        foreach($menus->data as $item) {
            $arr = array();
            $arr['need_superadmin'] = !empty($item->need_superadmin) ? $item->need_superadmin : "";
            $arr['id'] = getId($item->_id);
            //Get menu name
            $arr['menu'] = $item->name;
            if(!empty($item->parent_id)) {
                foreach($menus->data as $parent) {
                    if(getId($parent->_id) == $item->parent_id) {
                        $arr['menu'] = $parent->name.' / '.$item->name;
                        continue;
                    }
                }
            }
            //Not superadmin
            if(!empty($arr['need_superadmin']) && empty($this->data['userSession']['is_superadmin'])) {
                continue;
            }
            else {
                array_push($res, $arr);
            }
        }
        $this->pushJson('200', json_encode(array("code" => "200", "data" => (array)$res)));
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
        $role = $this->api->apiPost($this->user['token'], "role/get_one", $dataPost);
        $this->data['template'] = 'web/role/update';
        $this->data['role'] = $role->data;
        $this->load->view('template', isset($this->data)?$this->data:NULL);
    }
    
    public function delete() {
        $dataPost = $this->input->post();
        $this->data['id'] = $this->security->xss_clean($dataPost['id']);
        $post = array(
            "id" => $this->data['id']
        );
        $this->api->apiPost($this->user['token'], "role/delete", $post);
        $this->pushJson('200', json_encode(array("code" => "200", "data" => $this->lang->line('Delete_success'))));
    }
    
    public function getAccessRight() {
        $data = $this->input->post();
        $this->data['access_rights'] = $this->security->xss_clean($data['access_rights']);
        $this->data['access_rights'] = json_decode($data['access_rights']);
        $accessRights = array();
        if(!empty($this->data['access_rights'])) {
            $accessRightIds = array();
            for($i=0; $i < count($this->data['access_rights']); $i++) array_push($accessRightIds, $this->data['access_rights'][$i]);
            $dataPost = array(
                "where" => array("status" => "active"),
                "fields" => "_id",
                "not_in" => $accessRightIds
            );
            
            
            
            
            $accessRights = $this->api->apiPost($this->user['token'], "accessRight/find_where_not_in", $dataPost);
        } else {
            $dataPost = array("status" => "active");
            $accessRights = $this->api->apiPost($this->user['token'], "accessRight/find_where", $dataPost);
        }
        
        
        
        $res = array();
        foreach($accessRights->data as $item) {
            $arr = array();
            $arr['id'] = getId($item->_id);
            $arr['name'] = $item->name;
            $arr['slug'] = $item->slug;
            array_push($res, $arr);
        }
        $this->pushJson('200', json_encode(array("code" => "200", "data" => $res)));
    }
}

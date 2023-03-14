<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class FeeLoanNew extends MY_Controller {
    public function __construct() {
        parent::__construct();
          $this->load->helper('lead_helper');
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
    
    public function index() {
        $dataColumnFee  = $this->api->apiPost($this->user['token'], "FeeLoanNew/get_column");
        $this->data['columnFeeLoans'] = $dataColumnFee->data;
        $this->data["pageName"] = 'Quản lý phí mới';
        $dataFee  = $this->api->apiPost($this->user['token'], "FeeLoanNew/get_all");
        $groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
        if (!empty($groupRoles->status) && $groupRoles->status == 200) {
            $this->data['groupRoles'] = $groupRoles->data;
        } else {
            $this->data['groupRoles'] = array();
        }
        $this->data['dataFee'] = $dataFee->data;
        $this->data['template'] = 'web/feeloan_new/index';
        $this->load->view('template', isset($this->data) ? $this->data:NULL);
    }
    public function doUpdateStatus()
    {
        $id = !empty($_GET['id']) ? $_GET['id'] : "";
        $status = !empty($_GET['status']) ? $_GET['status'] : "";
         $main = !empty($_GET['main']) ? $_GET['main'] : "";
        $status = ($status=='true') ? 'active' : 'deactive';
        if (empty($id)) {
            $response = [
                'res' => false,
                'status' => "400",
                'message' => $this->lang->line('No_news_selected_deletion')
            ];
            echo json_encode($response);
            return;
        }
            if (empty($status)) {
            $response = [
                'res' => false,
                'status' => "400",
                'message' => $this->lang->line('No_news_selected_deletion')
            ];
            echo json_encode($response);
            return;
        }
        if( $status=='active')
        {
           if( $main=='1')
        {
        $res_check  = $this->api->apiPost($this->user['token'], "FeeLoanNew/get_fee_main", array());
          if(!empty($res_check->status) && $res_check->status == 200){
            if(!empty($res_check->data))
            {
             $res = array(
               'res' => false,
                'status' => "400",
                'message' => "Đã có biểu phí chuẩn, cần disable để được thêm mới !",
            );
            $this->pushJson('200', json_encode($res));
            return;
             }
        }else{
            if(!empty($res_check->status) && $res_check->status == 200){
             $res = array(
                'res' => false,
                'status' => "400",
                'message' => "Đã có biểu phí chuẩn, cần disable để được thêm mới !",
            );
            $this->pushJson('200', json_encode($res));
            return;
        }
       }
       }
   }
        $createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
        $data = array(
            "status" => $status,
            "updated_at" => $createdAt,
            "updated_by" => $this->userInfo['email'],
            "id" => $id
        );
        $return = $this->api->apiPost($this->user['token'], "FeeLoanNew/update", $data);
        if (!empty($return->status) && $return->status == 200) {
            $response = [
                'res' => true,
                'status' => "200",
                'message' => $this->lang->line('Successfully_deleted_news')
            ];
             $this->pushJson('200', json_encode($response));
            return;
        } else {
            $response = [
                'res' => false,
                'status' => "400",
                'message' => $this->lang->line('News_deletion_failed')
            ];
           $this->pushJson('200', json_encode($response));
            return;
        }
    }
    public function create() {
        $data = $this->input->post();
        if(empty($data['title'])  || empty($data['infor'])) {
            $res = array(
                'code' => 201,
                'message' => "Dữ liệu không thể để trống",
            );
            $this->pushJson('200', json_encode($res));
            return;
        }
        $data['title'] = $this->security->xss_clean($data['title']);
        $data['main'] = $this->security->xss_clean($data['main']);
        $data['infor'] = $this->security->xss_clean($data['infor']);
        $data['infor'] = json_decode($data['infor']);
        if( $data['main']=='1')
        {
        $res_check  = $this->api->apiPost($this->user['token'], "FeeLoanNew/get_fee_main", array());
          if(!empty($res_check->status) && $res_check->status == 200){
            if(!empty($res_check->data))
            {
             $res = array(
                'code' => 201,
                'message' => "Đã có biểu phí chuẩn, cần disable để được thêm mới !",
            );
            $this->pushJson('200', json_encode($res));
            return;
             }
        }else{
            if(!empty($res_check->status) && $res_check->status == 200){
             $res = array(
                'code' => 201,
                'message' => "Đã có biểu phí chuẩn, cần disable để được thêm mới !",
            );
            $this->pushJson('200', json_encode($res));
            return;
        }
       }
       }else{
        $data['main']="2";
       }

        //Call API
        $post = array(
            'title' => $data['title'],
            'main' => $data['main'],
            'infor' => $data['infor'],
        );
        $res  = $this->api->apiPost($this->user['token'], "FeeLoanNew/create", $post);
        if($res->code = '200') {
            $res = array(
                'code' => 200,
                'message' => "Tạo thành công",
            );
            $this->pushJson('200', json_encode($res));
            return;
        } else {
            $res = array(
                'code' => 201,
                'message' => "Dữ liệu không thể để trống"
            );
            $this->pushJson('200', json_encode(array("code" => "200", "data" => $res)));
            return;
        }
    }
    
    public function update() {
        $data = $this->input->post();
        if(empty($data['title']) ||  empty($data['infor']) ||  empty($data['from'])  ||  empty($data['to']) ||  empty($data['id'])) {
            $res = array(
                'code' => 201,
                'message' => "Dữ liệu không thể để trống",
            );
            $this->pushJson('200', json_encode($res));
            return;
        }
        
        $data['id'] = $this->security->xss_clean($data['id']);
        $data['title'] = $this->security->xss_clean($data['title']);
        $data['from'] = $this->security->xss_clean($data['from']);
        $data['to'] = $this->security->xss_clean($data['to']);
        $data['infor'] = $this->security->xss_clean($data['infor']);
        $data['infor'] = json_decode($data['infor']);

        //Call API
        $post = array(
            'id' => $data['id'],
            'title' => $data['title'],
            'from' => $data['from'],
            'to' => $data['to'],
            'infor' => $data['infor'],
        );
        $res  = $this->api->apiPost($this->user['token'], "FeeLoanNew/update", $post);
        if($res->code = '200') {
            $res = array(
                'code' => 200,
                'message' => "Cập nhật thành công",
            );
            $this->pushJson('200', json_encode($res));
            return;
        } else {
            $res = array(
                'code' => 201,
                'message' => "Dữ liệu không thể để trống"
            );
            $this->pushJson('200', json_encode(array("code" => "200", "data" => $res)));
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

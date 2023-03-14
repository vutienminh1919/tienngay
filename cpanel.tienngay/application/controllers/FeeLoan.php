<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class FeeLoan extends MY_Controller {
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
        $this->data["pageName"] = 'Quản lý phí';
        $dataFee  = $this->api->apiPost($this->user['token'], "FeeLoan/get_fee_all");
        $this->data['dataFee'] = $dataFee->data;
        $this->data['template'] = 'page/feeloan/index';
        $this->load->view('template', isset($this->data) ? $this->data:NULL);
    }
        
    public function update(){
        $data = $this->input->post();
		$data['fee_id'] = $this->security->xss_clean($data['fee_id']);
		$data['type_fee'] = $this->security->xss_clean($data['type_fee']);
		$data['percent_fee'] = $this->security->xss_clean($data['percent_fee']);
		$data['amount_fee'] = $this->security->xss_clean($data['amount_fee']);
		if (empty($data['fee_id'])) {
			$res = array(
				'status' => 400,
				'message' => "Không tồn tại phí",
			);
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $res)));
			return;
        }
        if($data['type_fee'] == 1){
            if (empty($data['percent_fee'])) {
                $res = array(
                    'status' => 400,
                    'message' => "Không được để trống phần trăm",
                );
                $this->pushJson('200', json_encode(array("code" => "200", "data" => $res)));
                return;
            }
        }
        if($data['type_fee'] == 2){
            if (empty($data['amount_fee'])) {
                $res = array(
                    'status' => 400,
                    'message' => "Không được để trống tiền phạt",
                );
                $this->pushJson('200', json_encode(array("code" => "200", "data" => $res)));
                return;
            }
        }
		
		$sendApi = array(
			"id" => $data['fee_id'],
			'type_fee' => $data['type_fee'],
			'percent_fee' => $data['percent_fee'],
			'amount_fee' => $data['amount_fee'],
		);
        $return = $this->api->apiPost($this->user['token'], "FeeLoan/update", $sendApi);
		$this->pushJson('200', json_encode(array("code" => "200", "data" => $return,  'message' => "Cập nhật thành công")));
		return;
    }

    private function pushJson($code, $data) {
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($code)
            ->set_output($data);
    }
    
}

<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Lead extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("time_model");
        $this->load->helper('lead_helper');
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
        $leads = $this->api->apiPost($this->user['token'], "lead_admin/get_lead");
        $this->data['leads'] = $leads->data;
        $this->data['template'] = 'web/lead/index';
        $this->load->view('template', isset($this->data) ? $this->data:NULL);
    }
    
    public function displayUpdate($id) {
        $id = $this->security->xss_clean($id);
        $condition = array(
            "id" => $id
        );
        $leads = $this->api->apiPost($this->user['token'], "lead_admin/get_one", $condition);
        $this->data['lead'] = $leads->data;
        $this->data['template'] = 'web/lead/update';
        $this->load->view('template', isset($this->data) ? $this->data:NULL);
    }
    
    
    public function update() {
        //Update như bình thường
        $data = $this->input->post();
        $data['id'] = $this->security->xss_clean($data['id']);
        $data['phone_number'] = $this->security->xss_clean($data['phone_number']);
        $data['type_finance'] = $this->security->xss_clean($data['type_finance']);
        $data['call'] = $this->security->xss_clean($data['call']);
        $data['status'] = $this->security->xss_clean($data['status']);
        $data['reason_1'] = $this->security->xss_clean($data['reason_1']);
        $data['reason_2'] = $this->security->xss_clean($data['reason_2']);
        $data['reason_3'] = $this->security->xss_clean($data['reason_3']);
        
        if(empty($data['phone_number'])) {
            $this->pushJson('200', json_encode(array(
                "code" => "201", 
                "message" =>  $this->lang->line('required_phone')
            )));
            return;
        }
        $update = array(
            "id" => $data['id'],
            "phone_number" => $data['phone_number'],
            "type_finance" => (int)$data['type_finance'],
            "call" => (int)$data['call'],
            "status" => (int)$data['status'],
            "reason_1" => !empty($data['reason_1']) ? (int)$data['reason_1'] : "",
            "reason_2" => !empty($data['reason_2']) ? (int)$data['reason_2'] : "",
            "reason_3" => !empty($data['reason_3']) ? (int)$data['reason_3'] : "",
            "updated_by" => $this->user['id'],
            "updated_at" => $this->time_model->convertDatetimeToTimestamp(new DateTime())
        );
        
//        var_dump($update);
//        die;
        
        $response = $this->api->apiPost($this->user['token'], "lead_admin/update", $update);
        $this->pushJson('200', json_encode(array("code" => "200", "data" => $response)));
    }
    
    private function pushJson($code, $data) {
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($code)
            ->set_output($data);
    }
    
    public function setupVbeeLead() {
		$this->data['pageName'] = 'Cài đặt lọc nguồn Thô - Lead Vbee';
        $source = $this->api->apiPost($this->user['token'], "lead/getSource");
        if (!empty($source->status) && $source->status == 200) {
            $this->data['source'] = explode("," ,$source->data->source);
        }
        $this->data['template'] = 'page/lead/setupLeadVbee';
        $this->load->view('template', isset($this->data) ? $this->data:NULL);
    }

    public function saveVbeeSetting() {
        $data = $this->input->post();
        $condition = [];
        $source = !empty($data['source']) ? $data['source'] : "";
        if (!empty($source)) {
            $condition['source'] = implode("," ,$source);
        } else {
            $this->session->set_flashdata('error', 'Nguồn Lead không để trống');
			redirect(base_url('lead/setupVbeeLead'));
            return;
        }
        $save = $this->api->apiPost($this->user['token'], "lead/setupVbeeLead", $condition);
        if (!empty($save->status) && $save->status == 200) {
            $this->session->set_flashdata('success', 'Update thành công');
			redirect(base_url('lead/setupVbeeLead'));
        } else {
			$source_exists = implode(', ', $save->data) ?? '';
			$this->session->set_flashdata('error', $save->message . ': ' . $source_exists);
			redirect(base_url('lead/setupVbeeLead'));
			return;
		}
		return ;
    }

	/**
	 * Show view cài đặt các nguồn lead cần đẩy qua chiến dịch lọc Lead Vbee all nguồn
	 */
	public function setupSourceVbeeLead() {
		$this->data['pageName'] = 'Cài đặt lọc nguồn Lead Vbee (All)';
		$source = $this->api->apiPost($this->user['token'], "lead/getSourcePushVbee");
		if (!empty($source->status) && $source->status == 200) {
			$this->data['source'] = explode("," ,$source->data->source);
		}
		$this->data['template'] = 'page/lead/setupAllSourcePushVbee.php';
		$this->load->view('template', isset($this->data) ? $this->data:NULL);
	}

	/**
	 *  Lưu cài đặt các nguồn lead cần đẩy qua chiến dịch lọc Lead Vbee all nguồn
	 */
	public function saveSourceLeadAll() {
		$data = $this->input->post();
		$condition = [];
		$source = !empty($data['source']) ? $data['source'] : "";
		if (!empty($source)) {
			$condition['source'] = implode("," ,$source);
		} else {
			$this->session->set_flashdata('error', 'Nguồn Lead không để trống');
			redirect(base_url('lead/setupSourceVbeeLead'));
			return;
		}
		$response = $this->api->apiPost($this->user['token'], "lead/saveSourceLeadAll", $condition);
		if (!empty($response->status) && $response->status == 200) {
			$this->session->set_flashdata('success', 'Update thành công');
			redirect(base_url('lead/setupSourceVbeeLead'));
		} else {
			$source_exists = implode(', ', $response->data) ?? '';
			$this->session->set_flashdata('error', $response->message . ': ' . $source_exists);
			redirect(base_url('lead/setupSourceVbeeLead'));
			return;
		}
		return ;
	}
}

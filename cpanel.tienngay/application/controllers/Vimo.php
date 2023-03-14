<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Vimo extends MY_Controller {
    public function __construct() {
        parent::__construct();
        // $this->api = new Api();
    }
    
    // private $api;
    
    public function createWithdrawal() {
        $data = $this->input->post();
        $data['type_payout'] = !empty($data['type_payout']) ? $this->security->xss_clean($data['type_payout']) : "";
        $data['order_code'] = !empty($data['order_code']) ? $this->security->xss_clean($data['order_code']) : "";
        $data['amount'] = !empty($data['amount']) ? $this->security->xss_clean($data['amount']) : "";
        $data['bank_id'] = !empty($data['bank_id']) ?$this->security->xss_clean($data['bank_id']) : "";
        $data['description'] = !empty($data['description']) ? $this->security->xss_clean($data['description']) : "";
        $data['code_contract'] = !empty($data['code_contract']) ? $this->security->xss_clean($data['code_contract']) : "";
        //Bank account = 2
        if($data['type_payout'] == 2 || $data['type_payout'] == 10) {
            $data['bank_account'] = !empty($data['bank_account']) ? $this->security->xss_clean($data['bank_account']) : "";
            $data['bank_account_holder'] = !empty($data['bank_account_holder']) ? $this->security->xss_clean($data['bank_account_holder']) : "";
            $data['bank_branch'] = !empty($data['bank_branch']) ? $this->security->xss_clean($data['bank_branch']) : "";
        }
        //ATM Card Number = 3
        if($data['type_payout'] == 3) {
            $data['atm_card_number'] = !empty($data['atm_card_number']) ? $this->security->xss_clean($data['atm_card_number']) : "";
            $data['atm_card_holder'] = !empty($data['atm_card_holder']) ? $this->security->xss_clean($data['atm_card_holder']) : "";
        }
        //Encrypt TripleDes
        $libTripleDes = new TripleDes();
        $secretKey = $libTripleDes->Encrypt(json_encode($data), $this->config->item("TRIPLEDES_KEY"));
        $dataPost = array(
            "type_payout" => $data['type_payout'],
            "order_code" => $data['order_code'],
            "amount" => $data['amount'],
            "bank_id" => $data['bank_id'],
            "description" => $data['description'],
            "bank_account" => !empty($data['bank_account']) ? $data['bank_account'] : "",
            "bank_account_holder" => !empty($data['bank_account_holder']) ? $data['bank_account_holder'] : "",
            "atm_card_number" => !empty($data['atm_card_number']) ? $data['atm_card_number'] : "",
            "atm_card_holder" => !empty($data['atm_card_holder']) ? $data['atm_card_holder'] : "",
            "created_by" => $this->user['email'],
            "secret_key" => $secretKey,
            "code_contract" =>  !empty($data['code_contract']) ? $data['code_contract'] : "",
            "bank_branch" =>  !empty($data['bank_branch']) ? $data['bank_branch'] : "",
            "disbursement_by" =>  $this->user['email'],
        );

        $return = $this->api->apiPost($this->user['token'], "vimo/create_withdrawal", $dataPost);
        if(!empty($return->status) && $return->status == 200){
            $this->pushJson('200', json_encode(array("code" => "200", "data" => $return,"msg" => $this->lang->line('Successful_disbursement_order'))));

        }else{
            $this->pushJson('200', json_encode(array("code" => "401","data" => $return, "msg" => $return->result->error_description)));
        }
    }
    
    private function pushJson($code, $data) {
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($code)
            ->set_output($data);
    }
}
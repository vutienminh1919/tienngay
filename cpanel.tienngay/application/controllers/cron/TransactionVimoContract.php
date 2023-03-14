<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TransactionVimoContract extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("time_model");
        $this->load->model("log_model");
        $this->load->model("contract_model");
        $this->load->model("user_model");
        $this->createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
        $this->api = new Api();
    }
    
    private $api, $createdAt;
    
    public function getTransaction() {
        $libTripleDes = new TripleDes();
        //Find contract
        $contracts = $this->contract_model->find_where(array(
            "status_create_withdrawal" => "create_withdrawal_success",
            "status" => 16
        ));
        if(empty($contracts)) return;
        foreach($contracts as $contract) {
            $amount = (int)$contract['loan_infor']['amount_money'];
            $param = array(
                "order_code" => $contract['code_contract'],
                "amount" => $amount,
            );
            $secretKey2 = $libTripleDes->Encrypt(json_encode($param), $this->config->item("TRIPLEDES_KEY"));
            $dataPost1 = array(
                "order_code" => $contract['code_contract'],
                "amount" => $amount,
                "type_payout" => $contract['receiver_infor']['type_payout'],
                "secret_key" => $secretKey2
            );
            //2. Call API get_withdrawal_transaction_status
            $statusVimo = $this->api->apiPostNoHeader("/vimo/get_withdrawal_transaction_status", $dataPost1);
            if($statusVimo->data->error_code == '00') { 
                //1. Update contract
                // response_get_transaction_withdrawal_status
                // status_create_withdrawal = 'success'
                // status = 17
                $this->contract_model->update(
                    array("_id" => $contract['_id']),
                    array("response_get_transaction_withdrawal_status" => $statusVimo->data,
                          "status_create_withdrawal" => "success",
                          "disbursement_date" => $this->createdAt,
                          "status" => 17,
                          "status_disbursement" => 2)
                );
                //2. Call API Tạo bảng tính lãi cho khách
                $data4 = array(
                    "code_contract" => $contract['code_contract'],
                    "disbursement_date" => $this->createdAt,
                    "investor_code" => "vimo"
                );
                $secretKey4 = $libTripleDes->Encrypt(json_encode($data4), $this->config->item("TRIPLEDES_KEY_CONTRACT_TEMPORARY"));
                $dataPost4 = array(
                    "code_contract" => $contract['code_contract'],
                    "disbursement_date" => $this->createdAt,
                    "investor_code" => "vimo",
                    "secret_key" => $secretKey4
                );
                $this->api->apiPostNoHeader("generateContract/processContract", $dataPost4);
                //3. Insert log
                $dataLog = array(
                    "type" => "contract",
                    "action" => "create_withdrawal_success",
                    "contract_id" => (string)$contract['_id'],
                    "created_at" => $this->createdAt
                );
                $this->log_model->insert($dataLog);
                //4. Update số  vào user
                $userDB = $this->user_model->findOne(array("email" => $contract['customer_infor']['customer_email']));
                if(empty($userDB)) continue;
                $currentDebt = !empty($userDB['debt']) ? $userDB['debt'] : 0;
                $this->user_model->update(
                    array("_id" => $userDB['_id']),
                    array("debt" => $currentDebt + $amount)
                );
            } else if($statusVimo->data->error_code == '00|13') {
                //1. Update contract
                // response_get_transaction_withdrawal_status
                // status_create_withdrawal = 'success'
                // status = 17
                $this->contract_model->update(
                    array("_id" => $contract['_id']),
                    array("response_get_transaction_withdrawal_status" => $statusVimo->data,
                          "status_create_withdrawal" => "failed",
                          "status" => 18)
                );
                //2. Insert log
                $dataLog = array(
                    "type" => "contract",
                    "action" => "create_withdrawal_failed",
                    "contract_id" => (string)$contract['_id'],
                    "created_at" => $this->createdAt
                );
                $this->log_model->insert($dataLog);
            }
        }
    }
}

<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TransactionVimo extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("time_model");
        $this->createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
        $this->api = new Api();
    }
    
    private $api, $createdAt;
    
    public function getTransaction() {
        
        var_dump(1);
        
        $libTripleDes = new TripleDes();
        //1. Call API disbursement_accounting  có status = 'create_withdrawal_success'
        $data1 = array("status" => "create_withdrawal_success");
        $secretKey1 = $libTripleDes->Encrypt(json_encode($data1), $this->config->item("TRIPLEDES_KEY_DISBURSEMENT_ACCOUNTING"));
        $dataPost1 = array(
            "status" => "create_withdrawal_success",
            "secret_key" => $secretKey1
        );
        $disbursementAccountings = $this->api->apiPostNoHeader("/disbursementAccounting/get_where", $dataPost1);
        foreach($disbursementAccountings->data as $disbursementAccounting) {
            $param = array(
                "order_code" => $disbursementAccounting->order_code,
                "amount" => $disbursementAccounting->amount,
            );
            $secretKey2 = $libTripleDes->Encrypt(json_encode($param), $this->config->item("TRIPLEDES_KEY"));
            $dataPost1 = array(
                "order_code" => $disbursementAccounting->order_code,
                "amount" => $disbursementAccounting->amount,
                "type_payout" => $disbursementAccounting->type_payout,
                "secret_key" => $secretKey2
            );
            //2. Call API get_withdrawal_transaction_status
            $statusVimo = $this->api->apiPostNoHeader("/vimo/get_withdrawal_transaction_status", $dataPost1);
            if($statusVimo->data->error_code == '00') {
                //Update status disbursement_accounting status = 'success'
                $data3 = array(
                    "condition" => array("order_code" => $disbursementAccounting->order_code),
                    "update" => array("status" => "success",
                                      "response_get_withdrawal_transaction_status" => $statusVimo->data)
                );
                $secretKey3 = $libTripleDes->Encrypt(json_encode($data3), $this->config->item("TRIPLEDES_KEY_DISBURSEMENT_ACCOUNTING"));
                $dataPost3 = array(
                    "condition" => array("order_code" => $disbursementAccounting->order_code),
                    "update" => array("status" => "success",
                                      "response_get_withdrawal_transaction_status" => $statusVimo->data),
                    "secret_key" => $secretKey3
                );
                $this->api->apiPostNoHeader("/disbursementAccounting/update", $dataPost3);
                //Call API Tạo bảng tính lãi cho khách
//                $data4 = array(
//                    "code_contract" => $disbursementAccounting->code_contract,
//                    "disbursement_date" => $this->createdAt,
//                    "investor_code" => "vimo"
//                );
//                $secretKey4 = $libTripleDes->Encrypt(json_encode($data4), $this->config->item("TRIPLEDES_KEY_CONTRACT_TEMPORARY"));
//                $dataPost4 = array(
//                    "code_contract" => $disbursementAccounting->code_contract,
//                    "disbursement_date" => $this->createdAt,
//                    "investor_code" => "vimo",
//                    "secret_key" => $secretKey4
//                );
//                $this->api->apiPostNoHeader("generateContract/processContract", $dataPost4);
            }
            //Transaction is failed and refunded
            else if($statusVimo->data->error_code == '00|13') {
                //Update status disbursement_accounting status = 'failed'
                $data3 = array(
                    "condition" => array("order_code" => $disbursementAccounting->order_code),
                    "update" => array("status" => "failed",
                                      "response_get_withdrawal_transaction_status" => $statusVimo->data)
                );
                $secretKey3 = $libTripleDes->Encrypt(json_encode($data3), $this->config->item("TRIPLEDES_KEY_DISBURSEMENT_ACCOUNTING"));
                $dataPost3 = array(
                    "condition" => array("order_code" => $disbursementAccounting->order_code),
                    "update" => array("status" => "failed",
                                      "response_get_withdrawal_transaction_status" => $statusVimo->data),
                    "secret_key" => $secretKey3
                );
                $this->api->apiPostNoHeader("/disbursementAccounting/update", $dataPost3);
            }
        }
    }
}
<?php
require_once __DIR__.'/../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DisbursementAccounting extends MY_Controller {
    public function __construct() {
        parent::__construct();
        // $this->api = new Api();
        $this->load->model("time_model");
        $this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
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
        $this->data["pageName"] = $this->lang->line('disbursement_management');
         //Encrypt TripleDes
         $libTripleDes = new TripleDes();
         $dataSecretKey = array("msg"=>"data secretkey success");
         $secretKey = $libTripleDes->Encrypt(json_encode($dataSecretKey), $this->config->item("TRIPLEDES_KEY_DISBURSEMENT_ACCOUNTING"));
         $arr = array(
            "secret_key" => $secretKey
        );
        // var_dump($secretKey);die;
        $datas = $this->api->apiPost($this->user['token'], "disbursementAccounting/get_all",$arr);
        if(!empty($datas->status) && $datas->status == 200){
            $this->data['disbursement'] = $datas->data;
        }
        $this->data['template'] = 'page/disbursement/list';
        $this->load->view('template', isset($this->data) ? $this->data:NULL);
    }

    public function view(){
        $id =  $this->input->get('id');
        //Encrypt TripleDes
        $libTripleDes = new TripleDes();
        $dataSecretKey = array("msg"=>"data secretkey success");
        $secretKey = $libTripleDes->Encrypt(json_encode($dataSecretKey), $this->config->item("TRIPLEDES_KEY_DISBURSEMENT_ACCOUNTING"));
        $arr = array(
            "id" => $id,
            "secret_key" => $secretKey
        );
        $datas = $this->api->apiPost($this->user['token'], "disbursementAccounting/get_one",$arr);
        if(!empty($datas->status) && $datas->status == 200){
            $this->data['disbursement'] = $datas->data;
        }
        $this->data['template'] = 'page/disbursement/view';
        $this->load->view('template', isset($this->data) ? $this->data:NULL);
    }

    public function search(){
        $fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
        $tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
        if(strtotime($fdate) > strtotime($tdate)){
             $this->session->set_flashdata('error', 'Error from date less to date.');
        redirect(base_url('DisbursementAccounting'));
        }
        if(empty($_GET['fdate']) || empty($_GET['tdate'])){
            $this->session->set_flashdata('error', 'Please select input date.');
            redirect(base_url('DisbursementAccounting'));
        }

        $this->data["pageName"] = $this->lang->line('disbursement_management');
         //Encrypt TripleDes
         $libTripleDes = new TripleDes();
         $dataSecretKey = array("msg"=>"data secretkey success");
         $secretKey = $libTripleDes->Encrypt(json_encode($dataSecretKey), $this->config->item("TRIPLEDES_KEY_DISBURSEMENT_ACCOUNTING"));
         $arr = array(
            "secret_key" => $secretKey,
            "fdate" => $fdate,
            "tdate" => $tdate,
        );
        $datas = $this->api->apiPost($this->user['token'], "disbursementAccounting/search",$arr);
        if(!empty($datas->status) && $datas->status == 200){
            $this->data['disbursement'] = $datas->data;
        }
        $this->data['template'] = 'page/disbursement/list';
        $this->load->view('template', isset($this->data) ? $this->data:NULL);
    }


    public function importDisbursement(){
        if(empty($_FILES['upload_file']['name'])){
            $this->session->set_flashdata('error', $this->lang->line('not_selected_file_import'));
            redirect('disbursementAccounting');
        }else{
            $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            if(isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
                $arr_file = explode('.', $_FILES['upload_file']['name']);
                $extension = end($arr_file);
                if('csv' == $extension){
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
                $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                var_dump($sheetData);die();
                $createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
                //Encrypt TripleDes
                $libTripleDes = new TripleDes();
                $dataSecretKey = array("msg"=>"data secretkey success");
                $secretKey = $libTripleDes->Encrypt(json_encode($dataSecretKey), $this->config->item("TRIPLEDES_KEY_DISBURSEMENT_ACCOUNTING"));
                foreach($sheetData as $key => $value){
                    if($key != 0 && !empty($value["1"])){
                        $data = array(
                            "code_contract" => $value["1"],
                            "customer_name" => $value["2"],
                            "customer_id" => $value["3"],
                            // "data_disbursement" => $value["3"],
                            "data_expire" => strtotime($value["5"]),
                            "story_name" => $value["6"],
                            "type_payout" => $value["7"],
                            "atm_card_holder" => $value["8"],
                            "atm_card_number" => $value["9"],
                            "bank_account_holder" => $value["10"],
                            "bank_account" =>  $value["11"],
                            "bank" =>$value["12"],
                            "bank_id" =>$value["13"],
                            "bank_branch" => $value["14"],
                            "amount" => $value["15"],
                            "description" =>$value["16"],
                            // "import_at" => $createdAt,
                            "import_by" =>  $this->userInfo['email'],
                            "status" => "new",
                            "order_code" => $value["1"],
                            "secret_key" => $secretKey
                        );
                        // call api insert db 
                        $return = $this->api->apiPost($this->user['token'], "disbursementAccounting/create", $data);
                    }
                }
                try {
                    $this->session->set_flashdata('success', $this->lang->line('import_success'));
                    redirect('disbursementAccounting');
                } catch (Exception $ex) {
                    $this->session->set_flashdata('error', $this->lang->line('import_failed'));
                    redirect('disbursementAccounting');
                }
            }else{
                $this->session->set_flashdata('error', $this->lang->line('type_invalid'));
                redirect('disbursementAccounting');
            }
        }
    }

    public function hideDisbursement(){
        $data = $this->input->post();
        $code_contract = !empty($data['code_contract']) ? $this->security->xss_clean($data['code_contract']) : "";
        $id =  !empty($data['id']) ? $this->security->xss_clean($data['id']) : "";
        if(empty($code_contract)){
            $response = [
                'res' => false, 
                'status' => "400",
                'message' => $this->lang->line('empty_code_contract')
            ];
            echo json_encode($response);
            return;
        }
        //Encrypt TripleDes
        $libTripleDes = new TripleDes();
        $dataSecretKey = array("msg"=>"data secretkey success");
        $secretKey = $libTripleDes->Encrypt(json_encode($dataSecretKey), $this->config->item("TRIPLEDES_KEY_DISBURSEMENT_ACCOUNTING"));
        $data = array(
            "status" => "hidden",
            "code_contract" =>  $code_contract,
            "secret_key" => $secretKey,
            "updated_by" =>  $this->userInfo['email'],
            "id" => $id
        );
        $return = $this->api->apiPost($this->userInfo['token'], "disbursementAccounting/hide_disbursement", $data);
     
        if(!empty($return->status) && $return->status == 200){
            $response = [
                'res' => true, 
                'status' => "200",
                'message' => $this->lang->line('hidden_transaction_success')
            ];
            echo json_encode($response);
            return;
        }else{
            $response = [
                'res' => false, 
                'status' => "400",
                'message' => $this->lang->line('hidden_transaction_failed')
            ];
            echo json_encode($response);
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

<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ImportDatabase extends MY_Controller
{
    private $property;

    public function __construct()
    {
        parent::__construct();
        // $this->api = new Api();
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        $this->load->model("time_model");
        $this->load->model("main_property_model");
        $this->load->helper('lead_helper');
        $this->load->library('pagination');
        $this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
        if (!$this->is_superadmin) {
            $paramController = $this->uri->segment(1);
            $param = strtolower($paramController);
            if (!in_array($param, $this->paramMenus)) {
                $this->session->set_flashdata('error', $this->lang->line('not_have_permission') . ' ' . $paramController . '!');
                redirect(base_url('app'));
                return;
            }
        }
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }

    private function pushJson($code, $data)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($code)
            ->set_output($data);
    }

    public function import_change_status()
    {
        $this->data["pageName"] = "Danh sách hợp đồng import chuyển TT";
        $condition = array();
        $start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
        $end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
        $type = !empty($_GET['type']) ? $_GET['type'] : "";
        $code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
        $customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
        if (strtotime($start) > strtotime($end)) {
            $this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
            redirect(base_url('importDatabase/import_change_status'));
        }
        if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
            $condition['start'] = $start;
            $condition['end'] = $end;
        }

        $uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = base_url('importDatabase/import_change_status?&fdate=' . $start . '&tdate=' . $end . '&code_contract_disbursement=' . $code_contract_disbursement . '&customer_name=' . $customer_name . '&type=' . $type);
        $condition['code_contract_disbursement'] = $code_contract_disbursement;
        $condition['customer_name'] = $customer_name;

        $config['per_page'] = 30;
        $config['enable_query_strings'] = true;
        $config['page_query_string'] = true;
        $config['uri_segment'] = $uriSegment;

        // call api get contract data
        $data = array(
            "condition" => $condition,
            "per_page" => $config['per_page'],
            "uriSegment" => $config['uri_segment']
        );
        if ($type == 'dangvay') {
            $data['is_change_dang_vay'] = 1;
        }
        if ($type == 'tattoan') {
            $data['is_change_tat_toan'] = 1;
        }

        $contractData = $this->api->apiPost($this->userInfo['token'], "import/contract_update_status_all", $data);

        if (!empty($contractData->status) && $contractData->status == 200) {
            $this->data['contractData'] = $contractData->data;
            $config['total_rows'] = $contractData->total;
        } else {
            $this->data['contractData'] = array();
        }
        $this->pagination->initialize($config);
        $this->data['result_count'] = "Hiển thị " . $config['total_rows'] . " Kết quả";
        $this->data['pagination'] = $this->pagination->create_links();
        $this->data['template'] = 'page/importdb/update_status';
        $this->load->view('template', isset($this->data) ? $this->data : NULL);
        return;
    }
    public function list_import_gh()
    {
        $this->data["pageName"] = "Danh sách hợp đồng import GH";
        $condition = array();
        $start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
        $end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
        
        $code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
        $customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
        if (strtotime($start) > strtotime($end)) {
            $this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
            redirect(base_url('importDatabase/list_import_gh'));
        }
        if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
            $condition['start'] = $start;
            $condition['end'] = $end;
        }

        $uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = base_url('importDatabase/list_import_gh?&fdate=' . $start . '&tdate=' . $end . '&code_contract_disbursement=' . $code_contract_disbursement . '&customer_name=' . $customer_name);
        $condition['code_contract_disbursement'] = $code_contract_disbursement;
        $condition['customer_name'] = $customer_name;

        $config['per_page'] = 30;
        $config['enable_query_strings'] = true;
        $config['page_query_string'] = true;
        $config['uri_segment'] = $uriSegment;

        // call api get contract data
        $data = array(
            "condition" => $condition,
            "per_page" => $config['per_page'],
            "uriSegment" => $config['uri_segment']
        );
        
        $contractData = $this->api->apiPost($this->userInfo['token'], "import/contract_import_gh", $data);

        if (!empty($contractData->status) && $contractData->status == 200) {
            $this->data['contractData'] = $contractData->data;
            $config['total_rows'] = $contractData->total;
        } else {
            $this->data['contractData'] = array();
        }
        $this->pagination->initialize($config);
        $this->data['result_count'] = "Hiển thị " . $config['total_rows'] . " Kết quả";
        $this->data['pagination'] = $this->pagination->create_links();
        $this->data['template'] = 'page/importdb/view_import_gh';
        $this->load->view('template', isset($this->data) ? $this->data : NULL);
        return;
    }
    public function list_import_cc()
    {
        $this->data["pageName"] = "Danh sách hợp đồng import GH";
        $condition = array();
        $start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
        $end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
        
        $code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
        $customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
        if (strtotime($start) > strtotime($end)) {
            $this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
            redirect(base_url('importDatabase/list_import_cc'));
        }
        if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
            $condition['start'] = $start;
            $condition['end'] = $end;
        }

        $uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = base_url('importDatabase/list_import_cc?&fdate=' . $start . '&tdate=' . $end . '&code_contract_disbursement=' . $code_contract_disbursement . '&customer_name=' . $customer_name);
        $condition['code_contract_disbursement'] = $code_contract_disbursement;
        $condition['customer_name'] = $customer_name;

        $config['per_page'] = 30;
        $config['enable_query_strings'] = true;
        $config['page_query_string'] = true;
        $config['uri_segment'] = $uriSegment;

        // call api get contract data
        $data = array(
            "condition" => $condition,
            "per_page" => $config['per_page'],
            "uriSegment" => $config['uri_segment']
        );
        
        $contractData = $this->api->apiPost($this->userInfo['token'], "import/contract_import_cc", $data);

        if (!empty($contractData->status) && $contractData->status == 200) {
            $this->data['contractData'] = $contractData->data;
            $config['total_rows'] = $contractData->total;
        } else {
            $this->data['contractData'] = array();
        }
        $this->pagination->initialize($config);
        $this->data['result_count'] = "Hiển thị " . $config['total_rows'] . " Kết quả";
        $this->data['pagination'] = $this->pagination->create_links();
        $this->data['template'] = 'page/importdb/view_import_cc';
        $this->load->view('template', isset($this->data) ? $this->data : NULL);
        return;
    }
    public function list_update_contract_phieu_thu()
    {
        $this->data["pageName"] = "Danh sách hợp đồng import update phiếu thu";
        $condition = array();
        $start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
        $end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
        
        $code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
        
        if (strtotime($start) > strtotime($end)) {
            $this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
            redirect(base_url('importDatabase/list_update_contract_phieu_thu'));
        }
        if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
            $condition['start'] = $start;
            $condition['end'] = $end;
        }

        $uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = base_url('importDatabase/list_update_contract_phieu_thu?&fdate=' . $start . '&tdate=' . $end . '&code_contract_disbursement=' . $code_contract_disbursement );
        $condition['code_contract_disbursement'] = $code_contract_disbursement;
    

        $config['per_page'] = 30;
        $config['enable_query_strings'] = true;
        $config['page_query_string'] = true;
        $config['uri_segment'] = $uriSegment;

        // call api get contract data
        $data = array(
            "condition" => $condition,
            "per_page" => $config['per_page'],
            "uriSegment" => $config['uri_segment']
        );
        
        $contractData = $this->api->apiPost($this->userInfo['token'], "import/contract_import_update_contract_phieu_thu", $data);

        if (!empty($contractData->status) && $contractData->status == 200) {
            $this->data['contractData'] = $contractData->data;
            $config['total_rows'] = $contractData->total;
        } else {
            $this->data['contractData'] = array();
        }
        $this->pagination->initialize($config);
        $this->data['result_count'] = "Hiển thị " . $config['total_rows'] . " Kết quả";
        $this->data['pagination'] = $this->pagination->create_links();
        $this->data['template'] = 'page/importdb/view_import_update_contract_phieu_thu';
        $this->load->view('template', isset($this->data) ? $this->data : NULL);
        return;
    }
    public function index()
    {
        $this->data['template'] = 'page/importdb/index';
        $this->load->view('template', isset($this->data) ? $this->data : NULL);
    }
    public function index_cc_gh()
    {
        $this->data['template'] = 'page/importdb/index_cc_gh';
        $this->load->view('template', isset($this->data) ? $this->data : NULL);
    }
    public function update_contract_phieu_thu()
    {
        $this->data['template'] = 'page/importdb/update_contract_phieu_thu';
        $this->load->view('template', isset($this->data) ? $this->data : NULL);
    }
    public function update_contract_status()
    {
        $this->data['template'] = 'page/importdb/update_contract_status';
        $this->load->view('template', isset($this->data) ? $this->data : NULL);
    }
     public function import_update_contract_phieu_thu()
    {
        if (empty($_FILES['upload_file']['name'])) {

            $response = [
                'res' => false,
                'status' => "400",
                'message' => $this->lang->line('not_selected_file_import')
            ];
            echo json_encode($response);
            return;
        } else {
            $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
                $arr_file = explode('.', $_FILES['upload_file']['name']);
                $extension = end($arr_file);
                if ('csv' == $extension) {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
                $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                $createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
                $notify = [];
                foreach ($sheetData as $key => $value) {
                    if ($key >= 1 && !empty($value['1'])) {
                
                        $dataPost = array(
                            "code_contract_disbursement" => trim($value['3']),
                            "code_contract" => trim($value['2']),
                            "code" => trim($value['1']),
                            
                            
                        );
                      
                        if(!empty($dataPost['code_contract']) && !empty($dataPost['code_contract_disbursement']) && !empty($dataPost['code']))
                        {
                           
                            $ket_qua=   $this->api->apiPost($this->user['token'], "import/process_contract_phieu_thu_import", $dataPost);
                            
                            if($ket_qua->status==200) {
                                    
                                    
                                } else {

                                    $response = [
                                        'res' => false,
                                        'status' => "400",
                                        'message' =>$ket_qua->message.' Mã phiếu thu:'.$dataPost['code']
                                    ];
                                    echo json_encode($response);
                                    return;
                                    
                                }
                         
                       }

                    

                    }


                }
            }
            

        }
        $response = [
            'res' => true,
            'status' => "200",
            'message' =>'Thành công'
        ];
        echo json_encode($response);
        return;
    }
    public function import_update_contract_status()
    {
        if (empty($_FILES['upload_file']['name'])) {

            $response = [
                'res' => false,
                'status' => "400",
                'message' => $this->lang->line('not_selected_file_import')
            ];
            echo json_encode($response);
            return;
        } else {
            $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
                $arr_file = explode('.', $_FILES['upload_file']['name']);
                $extension = end($arr_file);
                if ('csv' == $extension) {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
                $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                $createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
                $notify = [];
                foreach ($sheetData as $key => $value) {
                    if ($key >= 1 && !empty($value['1'])) {
                
                        $dataPost = array(
                            
                            "code_contract" => trim($value['2']),
                            "status" => trim($value['1']),
                            
                            
                        );
                      
                        if(!empty($dataPost['code_contract'])  && !empty($dataPost['status']))
                        {
                           
                            $ket_qua=   $this->api->apiPost($this->user['token'], "import/process_contract_status", $dataPost);
                            
                            if($ket_qua->status==200) {
                                    
                                    
                                } else {

                                    $response = [
                                        'res' => false,
                                        'status' => "400",
                                        'message' =>$ket_qua->message.' Mã phiếu ghi:'.$dataPost['code_contract']
                                    ];
                                    echo json_encode($response);
                                    return;
                                    
                                }
                         
                       }

                    

                    }


                }
            }
            

        }
        $response = [
            'res' => true,
            'status' => "200",
            'message' =>'Thành công'
        ];
        echo json_encode($response);
        return;
    }
    public function fakeData()
    {
        $this->data['template'] = 'page/importdb/view';
        $this->load->view('template', isset($this->data) ? $this->data : NULL);
    }
    public function import_giahan()
    {
        if (empty($_FILES['upload_file']['name'])) {

            $response = [
                'res' => false,
                'status' => "400",
                'message' => $this->lang->line('not_selected_file_import')
            ];
            echo json_encode($response);
            return;
        } else {
            $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
                $arr_file = explode('.', $_FILES['upload_file']['name']);
                $extension = end($arr_file);
                if ('csv' == $extension) {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
                $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                $createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
                $notify = [];
                foreach ($sheetData as $key => $value) {
                    if ($key >= 1 && !empty($value['1'])) {
                $date_ns_ip = !empty($value["5"]) ? trim($value["5"]) : '';
                $date_ns = explode("/", $date_ns_ip);
                $ngay_gh = "";
                // if (is_array($date_ns) && count($date_ns) > 2) {
                //  $ngay_gh = strtotime($date_ns[2] . '-' . $date_ns[0] . '-' . $date_ns[1]);
                // }
                        $dataPost = array(
                            "code_contract_disbursement" => trim($value['1']),
                            "code_contract" => trim($value['2']),
                            "number_day_loan" => trim($value['4']),
                            "lan_gia_han" => trim($value['6']),
                            "date_gia_han" => trim($ngay_gh),
                            
                        );

                        if((int)$dataPost['lan_gia_han']>0)
                        {
                             $lan_gia_han=(int)$dataPost['lan_gia_han'];
                            for($i=1; $i <=  $lan_gia_han; $i++) { 
                                $dataPost['lan_gia_han']=$i;
                                $this->api->apiPost($this->user['token'], "import/process_gia_han_import", $dataPost);
                            
                            }
                         
                       }

                    

                    }


                }
            }
            try {
                $response = [
                    'res' => true,
                    'status' => "200",
                    'message' => $this->lang->line('import_success')
                ];
                echo json_encode($response);
                return;
            } catch (Exception $ex) {

                $response = [
                    'res' => false,
                    'status' => "400",
                    'message' => $this->lang->line('import_failed')
                ];
                echo json_encode($response);
                return;
            }

        }
    }
      public function import_cocau()
    {
        if (empty($_FILES['upload_file']['name'])) {

            $response = [
                'res' => false,
                'status' => "400",
                'message' => $this->lang->line('not_selected_file_import')
            ];
            echo json_encode($response);
            return;
        } else {
            $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
                $arr_file = explode('.', $_FILES['upload_file']['name']);
                $extension = end($arr_file);
                if ('csv' == $extension) {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
                $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                $createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
                // if (count($sheetData[0]) != 14) {

                //  $response = [
                //      'res' => false,
                //      'status' => "400",
                //      'message' => "Bạn nhập sai định dạng file"
                //  ];
                //  echo json_encode($response);
                //  return;
                // }
                
                $notify = [];
                foreach ($sheetData as $key => $value) {
                    if ($key >= 1 && !empty($value['1'])) {
                        $date_ns_ip = !empty($value["5"]) ? trim($value["5"]) : '';
                $date_ns = explode("/", $date_ns_ip);
                $ngay_cc = "";
                if (is_array($date_ns) && count($date_ns) > 2) {
                    $ngay_cc = strtotime($date_ns[2] . '-' . $date_ns[0] . '-' . $date_ns[1]);
                }

                        $dataPost = array(
                            "code_contract_disbursement" => trim($value['1']),
                            "code_contract" => trim($value['2']),
                            "number_day_loan" => trim($value['4']),
                            "date_co_cau" => trim($ngay_cc),
                            "lan_co_cau" => trim($value['8']),
                            "amount_money_cc" => trim($value['6']),
                            "type_loan" => trim($value['7']),
                            "type_interest" => trim($value['9']),
                            
                        );

                        $return = $this->api->apiPost($this->user['token'], "import/process_co_cau_import", $dataPost);
                        if ((int)$return->status == 401) {
                            $response = [
                                'res' => false,
                                'status' => "400",
                                'message' => $return->message . ' Mã hợp đồng:' . $value['1']
                            ];
                            echo json_encode($response);
                            return;
                        }

                    }


                }
            }
            try {
                $response = [
                    'res' => true,
                    'status' => "200",
                    'message' => $this->lang->line('import_success')
                ];
                echo json_encode($response);
                return;
            } catch (Exception $ex) {

                $response = [
                    'res' => false,
                    'status' => "400",
                    'message' => $this->lang->line('import_failed')
                ];
                echo json_encode($response);
                return;
            }

        }
    }
    public function importOldContract_v2()
    {
//      $data = $this->input->post();
//      if (empty($_FILES['upload_file']['name'])) {
//          $this->session->set_flashdata('error', $this->lang->line('not_selected_file_import'));
//          redirect('ImportDatabase');
//      } else {
        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
            $arr_file = explode('.', $_FILES['upload_file']['name']);
            $extension = end($arr_file);
            if ('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
            $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            $limit = 30;
            $total = count($sheetData);
            //$current page là số page đang chay hiện tại ban đầu là 0 + limit = 30 trả về cho client
            $current = $this->security->xss_clean($data['current']);
            if ($current < $total) {
                foreach ($sheetData as $key => $value) {
                    if ($key != 0 && $key > $current && $key < (int)$current + $limit && !empty($value["1"])) {
                        $data = array(
                            "id" => $value["1"],
                            "code_contract" => $value["2"],
                            "code_contract_disbursement" => $value["2"],
                            "code_customer" => $value["3"],
                            "name" => $value["4"],
                            "DOB" => $value["5"],
                            "sex" => $value["6"],
                            "number_phone" => $value["7"],
                            "identify" => $value["8"],
                            "current_address" => $value["9"],
                            "household_address" => $value["10"],
                            "relative_phone_1" => $value["11"],
                            "relative_phone_2" => $value["12"],
                            "date_sign_contract" => $value["13"],
                            "date_maturity" => strtotime($value["14"]),
                            "amount" => $value["15"],
                            "amount_interest" => $value["16"],
                            "loan_fee" => $value["17"],
                            "closing_amount" => $value["18"],
                            "amount_customer_paid" => $value["19"],
                            "closing_balance" => $value["20"],
                            "period" => $value["21"],
                            "loan_purpose" => $value["22"],
                            "pay_history" => $value["23"],
                            "number_of_loan" => $value["24"],
                            "loan_info_package" => $value["25"],
                            "data_of_delivery" => $value["26"],
                            "DPD" => $value["27"],
                            "createdAt" => $createdAt
                        );
                        // call api insert db
//                          $return = $this->api->apiPost($this->user['token'], "badDebt/create", $data);
                    }
                }
                $current = $current + 30;
                $continude = 1;
            } else {
                $current = $total;
                $continude = 0;
            }
            var_dump($current);
            die();
            $this->pushJson('200', json_encode(array("code" => "200", "current" => $current, "continude" => $continude)));
            return;
        }
//      }
    }

    public function importTransaction()
    {
        $this->WriteLog("Import-PT-" . date("Ymd", time()) . ".txt", " ================= START ======================= ");
        if (empty($_FILES['upload_file']['name'])) {

            $response = [
                'res' => false,
                'status' => "400",
                'message' => $this->lang->line('not_selected_file_import')
            ];
            echo json_encode($response);
            return;
        } else {
            $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
                $arr_file = explode('.', $_FILES['upload_file']['name']);
                $extension = end($arr_file);
                if ('csv' == $extension) {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
                $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                $createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
                // var_dump($sheetData[0]); die;
                // if (count($sheetData[0]) != 15) {

                //  $response = [
                //      'res' => false,
                //      'status' => "400",
                //      'message' => "Bạn nhập sai định dạng file"
                //  ];
                //  echo json_encode($response);
                //  return;
                // }

                $notify = [];
                $this->WriteLog("Import-PT-" . date("Ymd", time()) . ".txt", "sheetData: " . json_encode($sheetData));
                $data = [];
                foreach ($sheetData as $key => $value) {
                    if ($key >= 1) {
                        //if ( empty($value['2']) ) continue;
                        $dataPost = array(
                            "amount" => trim(str_replace(',', '', $value['5'])),
                            "customer_name" => trim($value['3']),
                            "phone" => trim($value['4']),
                            "note" => 'import old transaction',
                            "code_contract" => trim($value['1']),
                            "code_contract_disbursement" => trim($value['2']),
                            "payment_method" => trim($value['6']),// 1:tiền mặt, 2// ck
                            "store" => array(
                                'id' => trim($value['7']),
                                'name' => trim($value['8']),
                            ),
                            'created_by' => trim($value['9']),
                            'created_at' => strtotime($value['12']),
                            'code_transaction_bank' => trim($value['13']),
                            'bank' => trim($value['14']),
                            'url_img' => trim($value['15']),
                            'discounted_fee' => trim($value['16']),
                            'note' => trim($value['17']),
                            'allow_duplicate' => $_GET['allow_duplicate'] ?? 0
                        );

                        if (!in_array((int)$value['10'], [1, 2, 3])) {
                            continue;
                            // var_dump($key); die;
                            // $response = [
                            //     'res' => false,
                            //     'status' => "400",
                            //     'message' => 'Loại phiếu thu không phù hợp Mã phiếu ghi:' . $dataPost['code_contract'] . ' Mã ngân hàng:' . $dataPost['code_transaction_bank']
                            // ];
                            // echo json_encode($response);
                            // return;
                        }
                       
                        if ((int)$value['10'] == 1) {
                            $dataPost["type_pt"] = 4;// thanh toan ky lai
                            // $this->WriteLog("Import-PT-" . date("Ymd", time()) . ".txt", "data post import/payment_contract_import: " . json_encode($dataPost));
                            // $return = $this->api->apiPost($this->user['token'], "import/payment_contract_import", $dataPost);
                            // $this->WriteLog("Import-PT-" . date("Ymd", time()) . ".txt", "data response import/payment_contract_import: " . json_encode($return));
                            // if ((int)$return->status == 401) {
                            //  $response = [
                            //      'res' => false,
                            //      'status' => "400",
                            //      'message' => $return->message . ' Mã phiếu ghi:' . $dataPost['code_contract'] . ' Mã ngân hàng:' . $dataPost['code_transaction_bank']
                            //  ];
                            //  echo json_encode($response);
                            //  return;
                            // }
                        }
                        if ((int)$value['10'] == 2) {
                            $dataPost["type_pt"] = 3; //tất toán
                            // $this->WriteLog("Import-PT-" . date("Ymd", time()) . ".txt", "data post import/payment_finish_contract_import: " . json_encode($dataPost));
                            // $return = $this->api->apiPost1($this->user['token'], "import/payment_finish_contract_import", $dataPost);
                            // $this->WriteLog("Import-PT-" . date("Ymd", time()) . ".txt", "data response import/payment_finish_contract_import: " . json_encode($return));
                            // if ((int)$return->status == 401) {
                            //  $response = [
                            //      'res' => false,
                            //      'status' => "400",
                            //      'message' => $return->message . ' Mã phiếu ghi:' . $dataPost['code_contract'] . ' Mã ngân hàng:' . $dataPost['code_transaction_bank']
                            //  ];
                            //  echo json_encode($response);
                            //  return;
                            // }
                        }
                        if ((int)$value['10'] == 3) {
                            $dataPost["tong_phi_no"] = !empty($value['11']) ? $value['11'] : 0;
                            $dataPost["type_pt"] = 5;
                            // $this->WriteLog("Import-PT-" . date("Ymd", time()) . ".txt", "data post import/payment_contract_import: " . json_encode($dataPost));
                            // $return = $this->api->apiPost($this->user['token'], "import/payment_contract_import", $dataPost);
                            // $this->WriteLog("Import-PT-" . date("Ymd", time()) . ".txt", "data response import/payment_contract_import: " . json_encode($return));
                            // if ((int)$return->status == 401) {
                            //  $response = [
                            //      'res' => false,
                            //      'status' => "400",
                            //      'message' => $return->message . ' Mã phiếu ghi:' . $dataPost['code_contract'] . ' Mã ngân hàng :' . $dataPost['code_transaction_bank']
                            //  ];
                            //  echo json_encode($response);
                            //  return;
                            // }
                        }
                        $data[] = $dataPost;

                    }
                }
                try {
                    $this->WriteLog("Import-PT-" . date("Ymd", time()) . ".txt", "importTransaction request" . json_encode($data));
                    $return = $this->api->apiPost($this->user['token'], "import/createPhieuThu", $data);
                    $this->WriteLog("Import-PT-" . date("Ymd", time()) . ".txt", "importTransaction response" . json_encode($return));
                    $response = [
                        'res' => true,
                        'status' => "200",
                        'message' => $this->lang->line('import_success')
                    ];
                    echo json_encode($response);
                    return;
                } catch (Exception $ex) {

                    $response = [
                        'res' => false,
                        'status' => "400",
                        'message' => $this->lang->line('import_failed')
                    ];
                    echo json_encode($response);
                    return;
                }

            }
        }
    }

    public function importContractNhadautu()
    {
        if (empty($_FILES['upload_file']['name'])) {

            $response = [
                'res' => false,
                'status' => "400",
                'message' => $this->lang->line('not_selected_file_import')
            ];
            echo json_encode($response);
            return;
        } else {
            $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
                $arr_file = explode('.', $_FILES['upload_file']['name']);
                $extension = end($arr_file);
                if ('csv' == $extension) {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
                $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                $createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
                if (count($sheetData[0]) != 14) {

                    $response = [
                        'res' => false,
                        'status' => "400",
                        'message' => "Bạn nhập sai định dạng file"
                    ];
                    echo json_encode($response);
                    return;
                }
                $date_ns_ip = !empty($value["4"]) ? trim($value["4"]) : '';
                $date_ns = explode("/", $date_ns_ip);
                $ngay_sn = "";
                if (is_array($date_ns) && count($date_ns) > 2) {
                    $ngay_sn = strtotime($date_ns[2] . '-' . $date_ns[0] . '-' . $date_ns[1] . ' ' . $date[3]);
                }

                $notify = [];
                foreach ($sheetData as $key => $value) {
                    if ($key >= 1) {
                        $dataPost = array(
                            "code" => trim($value['1']),
                            "name" => trim($value['2']),
                            "dentity_card" => trim($value['3']),
                            "note" => 'import',
                            "date_of_birth" => $ngay_sn,
                            "phone" => trim($value['5']),
                            "email" => trim($value['6']),// 1:tiền mặt, 2// ck
                            'address' => trim($value['7']),
                            'tax_code' => trim($value['8']),
                            'balance' => trim($value['9']),
                            'percent_interest_investor' => trim($value['10']),

//                          'period' => trim($value['11']),
//                          'form_of_receipt' => trim($value['12']),
                            'status' => "active"
                        );

                        $return = $this->api->apiPost($this->user['token'], "import/investor_import", $dataPost);
                        if ((int)$return->status == 401) {
                            $response = [
                                'res' => false,
                                'status' => "400",
                                'message' => $return->message . ' Mã nhà đầu tư:' . $value['1']
                            ];
                            echo json_encode($response);
                            return;
                        }

                    }


                }
            }
            try {
                $response = [
                    'res' => true,
                    'status' => "200",
                    'message' => $this->lang->line('import_success')
                ];
                echo json_encode($response);
                return;
            } catch (Exception $ex) {

                $response = [
                    'res' => false,
                    'status' => "400",
                    'message' => $this->lang->line('import_failed')
                ];
                echo json_encode($response);
                return;
            }

        }
    }

    public function importOldContract()
    {
        //redirect('ImportDatabase');
        if (empty($_FILES['upload_file']['name'])) {
            $response = [
                'res' => false,
                'status' => "400",
                'message' => $this->lang->line('not_selected_file_import')
            ];
            echo json_encode($response);
            return;
        } else {
            $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
                $arr_file = explode('.', $_FILES['upload_file']['name']);
                $extension = end($arr_file);
                if ('csv' == $extension) {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
                $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                // var_dump($sheetData); die;

                if (count($sheetData[0]) < 73) {

                    $response = [
                        'res' => false,
                        'status' => "400",
                        'message' => "Bạn nhập sai định dạng file"
                    ];
                    echo json_encode($response);
                    return;
                }
                foreach ($sheetData as $key => $value) {
                    $date_gn_ip = !empty($value["4"]) ? $value["4"] . '/07:00:00' : '';

                    $date = explode("/", $date_gn_ip);
                    $date_ns_ip = !empty($value["21"]) ? $value["21"] : '';
                    $date_ns = explode("/", $date_ns_ip);

                    if (is_array($date) && count($date) > 3 && is_array($date_ns) && count($date_ns) > 2) {

                        $ngay_gn = strtotime($date[2] . '-' . $date[0] . '-' . $date[1] . ' ' . $date[3]);
                        $ngay_sn = strtotime($date_ns[2] . '-' . $date_ns[0] . '-' . $date_ns[1] . ' ' . $date[3]);
                        if ($key >= 2 && !empty($value["1"])) {
                            $province_code_cr = $this->searchCodeprovince(trim($value["23"]));
                            $province_code_hh = $this->searchCodeprovince(trim($value["29"]));
                            $district_code_cr = $this->searchCodeDistrict(trim($province_code_cr), trim($value["24"]));
                            $district_code_hh = $this->searchCodeDistrict(trim($province_code_hh), trim($value["30"]));
                            $ward_code_cr = $this->searchCodeWard(trim($district_code_cr), trim($value["25"]));
                            $ward_code_hh = $this->searchCodeWard(trim($district_code_hh), trim($value["31"]));
                            $data = array(
                                "customer_infor" => array(
                                    "customer_name" => trim($value["16"]),
                                    "customer_email" => empty(trim($value["18"])) ? 'support@tienngay.vn' : trim($value["18"]),
                                    "customer_phone_number" => trim('0' . $value["17"]),
                                    "customer_identify" => trim($value["19"]),
                                    "customer_gender" => $this->checkGender(trim($value["20"])),
                                    "customer_BOD" => date("Y-m-d", $ngay_sn),
                                    "marriage" => trim($value["22"]),
                                ),
                                "current_address" => array(
                                    "province" => $province_code_cr,
                                    "province_name" => trim($value["23"]),
                                    "district" => $district_code_cr,
                                    "district_name" => trim($value["24"]),
                                    "ward" => $ward_code_cr,
                                    "ward_name" => trim($value["25"]),
                                    "form_residence" => trim($value["27"]),
                                    "time_life" => trim($value["28"]),
                                    "current_stay" => trim($value["26"]),
                                ),
                                "houseHold_address" => array(
                                    "province" => $province_code_hh,
                                    "province_name" => trim($value["29"]),
                                    "district" => $district_code_hh,
                                    "district_name" => trim($value["30"]),
                                    "ward" => $ward_code_hh,
                                    "ward_name" => trim($value["31"]),
                                    "address_household" => trim($value["32"])
                                ),
                                "job_infor" => array(
                                    "name_company" => trim($value["33"]),
                                    "phone_number_company" => '0' . (int)trim($value["35"]),
                                    "address_company" => trim($value["34"]),
                                    "job_position" => trim($value["36"]),
                                    "salary" => trim($value["37"]),
                                    "receive_salary_via" => $this->receive_salary_via(trim($value["38"]))
                                ),
                                "relative_infor" => array(
                                    "type_relative_1" => trim($value["40"]),
                                    "fullname_relative_1" => trim($value["39"]),
                                    "phone_number_relative_1" => '0' . trim($value["41"]),
                                    "hoursehold_relative_1" => trim($value["42"]),
                                    "confirm_relativeInfor_1" => trim($value["43"]),

                                    "type_relative_2" => trim($value["45"]),
                                    "fullname_relative_2" => trim($value["44"]),
                                    "phone_number_relative_2" => '0' . trim($value["46"]),
                                    "hoursehold_relative_2" => trim($value["47"]),
                                    "confirm_relativeInfor_2" => trim($value["48"]),
                                ),
                                "loan_infor" => array(
                                    "type_loan" => $this->type_loan(trim($value["49"])),
                                    "type_property" => $this->type_property(trim($value["50"])),
                                    "name_property" => array("text" => trim($value["51"])),
                                    "price_property" => intval(preg_replace('/[^0-9]/', '', trim($value["52"]))),
                                    "amount_money_max" => intval(preg_replace('/[^0-9]/', '', trim($value["52"]))),
                                    "amount_loan" => intval(preg_replace('/[^0-9]/', '', trim($value["57"]))),
                                    "amount_money" => intval(preg_replace('/[^0-9]/', '', trim($value["52"]))),
                                    "type_interest" => trim($value["53"]),
                                    "number_day_loan" => (int)trim($value["54"]) * 30,
                                    "period_pay_interest" => 30,
                                    "insurrance_contract" => 2,
                                    "loan_purpose" => trim($value["55"]),
                                    "note" => "hợp đồng cũ",
                                ),
                                "receiver_infor" => array(
                                    "type_payout" => 2,
                                    "amount" => trim($value["52"]),
//                              "bank_id"=>$this->findbankid($value["7"]),
                                    "bank_name" => trim($value["7"]),
                                    "atm_card_number" => "",
                                    "bank_account" => trim($value["9"]),
                                    "bank_account_holder" => trim($value["10"]),
                                    "bank_branch" => trim($value["8"])
                                ),
                                "store" => array(
                                    "id" => $this->findstoreid(trim($value["3"])),
                                    "name" => trim($value["3"]),
                                    "address" => trim($value["3"])
                                ),
                                "created_at" => $ngay_gn,
//                          "created_by"=>$this->findCreatBy($value["3"]),
                                "property_infor" => array(
                                    "0" => array(
                                        "name" => "Nhãn hiệu",
                                        "slug" => "nhan-hieu",
                                        "value" => trim($value["56"]),
                                    ),
                                    "1" => array(
                                        "name" => "Model",
                                        "slug" => "model",
                                        "value" => trim($value["57"]),
                                    ),
                                    "2" => array(
                                        "name" => "Biển số xe",
                                        "slug" => "bien-so-xe",
                                        "value" => trim($value["58"]),
                                    ),
                                    "3" => array(
                                        "name" => "Số khung",
                                        "slug" => "so-khung",
                                        "value" => trim($value["59"]),
                                    ),
                                    "4" => array(
                                        "name" => "Số máy",
                                        "slug" => "so-may",
                                        "value" => trim($value["60"]),
                                    ),
                                ),
                                "fee" => array(
                                    "percent_interest_customer" => trim($value["63"]),
                                    "percent_advisory" => trim($value["64"]),
                                    "percent_expertise" => trim($value["65"]),
                                    "penalty_percent" => trim($value["66"]),
                                    "penalty_amount" => trim($value["67"]),
                                    "percent_prepay_phase_1" => trim($value["68"]),
                                    "percent_prepay_phase_2" => trim($value["69"]),
                                    "percent_prepay_phase_3" => trim($value["70"]),
                                    "fee_extend" => trim($value["71"]),
                                    "percent_interest_investor" => trim($value["63"]),
                                ),
                                "status" => 16,
                                "code_contract_disbursement" => !empty($value["2"]) ? trim($value["2"]) : trim($value["1"]),
                                "code_contract_parent" => !empty(trim($value["2"])) ? trim($value["1"]) : "",
                                "disbursement_date" => $ngay_gn,
                                "number_contract" => "",
                                "investor_code" => trim($value["14"]),
                                "updated_at" => trim($ngay_gn),
                                "note" => "",
                                "expertise_infor" => array(
                                    "expertise_file" => trim($value["61"]),
                                    "expertise_field" => trim($value["62"]),
                                ),
                                "created_by" => trim($value["72"]),
                                "expire_date" => $this->expire_date(trim($value["4"]), trim($value["54"]))
                            );
                            if (!empty(trim($value["2"]))) {
                                $data['fee']['extend'] = trim($value["71"]);
                            }
                            // call api insert db
                            $return = $this->api->apiPost($this->user['token'], "import/process_create_contract_import", $data);
                        }
                    }

                    $response = [
                        'res' => true,
                        'status' => "200",
                        'message' => $this->lang->line('import_success')
                    ];
                }

            } else {

                $response = [
                    'res' => false,
                    'status' => "400",
                    'message' => $this->lang->line('type_invalid')
                ];
            }
        }
        echo json_encode($response);
        return;
    }

    public function importContractUpdate()
    {
        //redirect('ImportDatabase');
        if (empty($_FILES['upload_file']['name'])) {
            $response = [
                'res' => false,
                'status' => "400",
                'message' => $this->lang->line('not_selected_file_import')
            ];
            echo json_encode($response);
            return;
        } else {
            $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {

                $arr_file = explode('.', $_FILES['upload_file']['name']);
                $extension = end($arr_file);
                if ('csv' == $extension) {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
                $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                // var_dump($sheetData); die;

                if (count($sheetData[0]) < 74) {

                    $response = [
                        'res' => false,
                        'status' => "400",
                        'message' => "Bạn nhập sai định dạng file"
                    ];
                    echo json_encode($response);
                    return;
                }


                foreach ($sheetData as $key => $value) {

                    $date_gn_ip = !empty($value["4"]) ? $value["4"] . '/07:00:00' : '';
                    $date = explode("/", $date_gn_ip);
                    $date_ns_ip = !empty($value["21"]) ? $value["21"] : '';
                    $date_ns = explode("/", $date_ns_ip);

                    if (is_array($date) && count($date) > 3 ) {

                        $ngay_gn = strtotime($date[2] . '-' . $date[0] . '-' . $date[1] . ' ' . $date[3]);
                        $ngay_sn = strtotime($date_ns[2] . '-' . $date_ns[0] . '-' . $date_ns[1] . ' ' . $date[3]);

                        if ($key >= 2 ) {
                            $province_code_cr = $this->searchCodeprovince(trim($value["23"]));
                            $province_code_hh = $this->searchCodeprovince(trim($value["29"]));
                            $district_code_cr = $this->searchCodeDistrict(trim($province_code_cr), trim($value["24"]));
                            $district_code_hh = $this->searchCodeDistrict(trim($province_code_hh), trim($value["30"]));
                            $ward_code_cr = $this->searchCodeWard(trim($district_code_cr), trim($value["25"]));
                            $ward_code_hh = $this->searchCodeWard(trim($district_code_hh), trim($value["31"]));

                            $data = array(
                                "customer_infor" => array(
                                    "customer_name" => trim($value["16"]),
                                    "customer_email" => empty(trim($value["18"])) ? '' : trim($value["18"]),
                                    "customer_phone_number" => trim($value["17"]),
                                    "customer_identify" => trim($value["19"]),
                                    "customer_gender" => $this->checkGender(trim($value["20"])),
                                    "customer_BOD" => date("Y-m-d", $ngay_sn),
                                    "marriage" => trim($value["22"]),
                                ),
                                "current_address" => array(
                                    "province" => $province_code_cr,
                                    "province_name" => trim($value["23"]),
                                    "district" => $district_code_cr,
                                    "district_name" => trim($value["24"]),
                                    "ward" => $ward_code_cr,
                                    "ward_name" => trim($value["25"]),
                                    "form_residence" => trim($value["27"]),
                                    "time_life" => trim($value["28"]),
                                    "current_stay" => trim($value["26"]),
                                ),
                                "houseHold_address" => array(
                                    "province" => $province_code_hh,
                                    "province_name" => trim($value["29"]),
                                    "district" => $district_code_hh,
                                    "district_name" => trim($value["30"]),
                                    "ward" => $ward_code_hh,
                                    "ward_name" => trim($value["31"]),
                                    "address_household" => trim($value["32"])
                                ),
                                "job_infor" => array(
                                    "name_company" => trim($value["33"]),
                                    "phone_number_company" => '0' . (int)trim($value["35"]),
                                    "address_company" => trim($value["34"]),
                                    "job_position" => trim($value["36"]),
                                    "salary" => trim($value["37"]),
                                    "receive_salary_via" => $this->receive_salary_via(trim($value["38"]))
                                ),
                                "relative_infor" => array(
                                    "type_relative_1" => trim($value["40"]),
                                    "fullname_relative_1" => trim($value["39"]),
                                    "phone_number_relative_1" => '0' . trim($value["41"]),
                                    "hoursehold_relative_1" => trim($value["42"]),
                                    "confirm_relativeInfor_1" => trim($value["43"]),

                                    "type_relative_2" => trim($value["45"]),
                                    "fullname_relative_2" => trim($value["44"]),
                                    "phone_number_relative_2" => '0' . trim($value["46"]),
                                    "hoursehold_relative_2" => trim($value["47"]),
                                    "confirm_relativeInfor_2" => trim($value["48"]),
                                ),
                                "loan_infor" => array(
                                    "type_loan" => $this->type_loan(trim($value["49"])),
                                    "type_property" => $this->type_property(trim($value["50"])),
//                                  "name_property" => array("text" => trim($value["51"])),
                                    "price_property" => intval(preg_replace('/[^0-9]/', '', trim($value["52"]))),
                                    "amount_money_max" => intval(preg_replace('/[^0-9]/', '', trim($value["52"]))),
                                    "amount_loan" => intval(preg_replace('/[^0-9]/', '', trim($value["73"]))),
                                    "amount_money" => intval(preg_replace('/[^0-9]/', '', trim($value["52"]))),
                                    "type_interest" => trim($value["53"]),
                                    "number_day_loan" => (int)trim($value["54"]) * 30,
                                    "loan_purpose" => trim($value["55"])
                                ),
                                "receiver_infor" => array(
                                    "type_payout" => 2,
                                    "amount" => trim($value["52"]),
                                    "bank_name" => trim($value["7"]),
                                    "atm_card_number" => "",
                                    "bank_account" => trim($value["9"]),
                                    "bank_account_holder" => trim($value["10"]),
                                    "bank_branch" => trim($value["8"])
                                ),
//                              "property_infor" => array(
//                                  "0" => array(
//                                      "name" => "Nhãn hiệu",
//                                      "slug" => "nhan-hieu",
//                                      "value" => !empty(trim($value["56"])) ? trim($value["56"]) : "",
//                                  ),
//                                  "1" => array(
//                                      "name" => "Model",
//                                      "slug" => "model",
//                                      "value" => !empty(trim($value["57"])) ? trim($value["57"]) : "",
//                                  ),
//                                  "2" => array(
//                                      "name" => "Biển số xe",
//                                      "slug" => "bien-so-xe",
//                                      "value" => !empty(trim($value["58"])) ? trim($value["58"]) : "",
//                                  ),
//                                  "3" => array(
//                                      "name" => "Số khung",
//                                      "slug" => "so-khung",
//                                      "value" => !empty(trim($value["59"])) ? trim($value["59"]) : "",
//                                  ),
//                                  "4" => array(
//                                      "name" => "Số máy",
//                                      "slug" => "so-may",
//                                      "value" => !empty(trim($value["60"])) ? trim($value["60"]) : "",
//                                  ),
//                              ),
                                "created_by" => $value["72"],
                                "fee" => array(
                                    "percent_interest_customer" => trim($value["63"]),
                                    "percent_advisory" => trim($value["64"]),
                                    "percent_expertise" => trim($value["65"]),
                                    "penalty_percent" => trim($value["66"]),
                                    "penalty_amount" => trim($value["67"]),
                                    "percent_prepay_phase_1" => trim($value["68"]),
                                    "percent_prepay_phase_2" => trim($value["69"]),
                                    "percent_prepay_phase_3" => trim($value["70"]),
                                    "fee_extend" => trim($value["71"]),
//                                  "percent_interest_investor" => trim($value["63"]),
                                ),
                                "code_contract_disbursement" => !empty($value["1"]) ? trim($value["1"]) : trim($value["1"]),
                                "code_contract" => !empty($value["2"]) ? trim($value["2"]) : '',
                                "disbursement_date" => $ngay_gn,
                                "status" => trim($value["5"]),
                                "investor_code" => !empty($value["14"]) ? trim($value["14"]) : '',
                                "investor_name" => !empty($value["13"]) ? ($value["13"]) : '',
                                "expertise_infor" => array(
                                    "expertise_file" => trim($value["61"]),
                                    "expertise_field" => trim($value["62"]),
                                ),
                                "store" => array(
                                    "id" => $this->findstoreid($value["3"]),
                                    "name" => $value["3"],
                                    "address" => $value["3"]
                                ),
                            );


                            if (!empty(trim($value["2"]))) {
                                $data['fee']['extend'] = trim($value["71"]);
                            }

                            // call api insert db
                            $return = $this->api->apiPost($this->user['token'], "import/process_update_contract_import", $data);

                            if ($return->status != 200) {
                                $response = [
                                    'res' => false,
                                    'status' => "401",
                                    'message' => (string)($return->message . "  |  Số thứ tự: " . ($key + 1))
                                ];
                                echo json_encode($response);
                                return;
                            }

                        }
                    }

                    $response = [
                        'res' => true,
                        'status' => "200",
                        'message' => $this->lang->line('import_success')
                    ];

                }

            } else {

                $response = [
                    'res' => false,
                    'status' => "400",
                    'message' => 'Không đúng định dạng file'
                ];
            }
        }
        echo json_encode($response);
        return;
    }

    public function importContractDangVay()
    {
        //redirect('ImportDatabase');
        if (empty($_FILES['upload_file']['name'])) {
            $response = [
                'res' => false,
                'status' => "400",
                'message' => $this->lang->line('not_selected_file_import')
            ];
            echo json_encode($response);
            return;
        } else {
            $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
                $arr_file = explode('.', $_FILES['upload_file']['name']);
                $extension = end($arr_file);
                if ('csv' == $extension) {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
                $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                // var_dump($sheetData); die;

                if (count($sheetData[0]) < 6) {

                    $response = [
                        'res' => false,
                        'status' => "400",
                        'message' => "Bạn nhập sai định dạng file"
                    ];
                    echo json_encode($response);
                    return;
                }
                foreach ($sheetData as $key => $value) {
                    $date_gn_ip = !empty($value["5"]) ? $value["5"] . '/07:00:00' : '';
                    $date = explode("/", $date_gn_ip);


                    if (is_array($date) && count($date) > 3) {

                        $ngay_gn = strtotime($date[2] . '-' . $date[0] . '-' . $date[1] . ' ' . $date[3]);

                        if ($key >= 1) {

                            $data = array(
                                "investor_code" => trim($value["4"]),
                                "customer_name" => trim($value["1"]),
                                "code_contract_disbursement" => !empty($value["2"]) ? trim($value["2"]) : "",
                                "code_contract" => !empty(trim($value["3"])) ? trim($value["3"]) : "",
                                "disbursement_date" => $ngay_gn
                            );
                            // call api insert db
                            $return = $this->api->apiPost($this->user['token'], "import/process_update_dang_vay_import", $data);
                            if ((int)$return->status == 401) {
                                $response = [
                                    'res' => false,
                                    'status' => "400",
                                    'message' => $return->message . ' Mã phiếu ghi:' . $data['code_contract'] . ' Mã hợp đồng:' . $data['code_contract_disbursement']
                                ];
                                echo json_encode($response);
                                return;
                            }
                        }
                    }


                }
                $response = [
                    'res' => true,
                    'status' => "200",
                    'message' => $this->lang->line('import_success')
                ];
                echo json_encode($response);
                return;

            } else {

                $response = [
                    'res' => false,
                    'status' => "400",
                    'message' => $this->lang->line('type_invalid')
                ];
            }
        }
        echo json_encode($response);
        return;
    }

    public function importContractTatToan()
    {
        //redirect('ImportDatabase');
        if (empty($_FILES['upload_file']['name'])) {
            $response = [
                'res' => false,
                'status' => "400",
                'message' => $this->lang->line('not_selected_file_import')
            ];
            echo json_encode($response);
            return;
        } else {
            $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
                $arr_file = explode('.', $_FILES['upload_file']['name']);
                $extension = end($arr_file);
                if ('csv' == $extension) {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
                $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                // var_dump($sheetData); die;

                if (count($sheetData[0]) < 4) {

                    $response = [
                        'res' => false,
                        'status' => "400",
                        'message' => "Bạn nhập sai định dạng file"
                    ];
                    echo json_encode($response);
                    return;
                }
                foreach ($sheetData as $key => $value) {

                    //  var_dump($value);     die;
                    if ($key >= 1) {
//                       var_dump($value);     die;
                        $data = array(
                            "customer_name" => trim($value["1"]),
                            "code_contract_disbursement" => !empty($value["2"]) ? (trim($value["2"])) : "",
                            "code_contract" => !empty(trim($value["3"])) ? (trim($value["3"])) : "",

                        );
                        // call api insert db

                        if (!empty($data['code_contract'])) {

                            $return = $this->api->apiPost($this->user['token'], "import/process_update_tat_toan_import", $data);

                            if ($return->status != 200) {
                                $response = [
                                    'res' => false,
                                    'status' => "400",
                                    'message' => $return->message . ' Mã phiếu ghi:' . $data['code_contract'] . ' Mã hợp đồng:' . $data['code_contract_disbursement']
                                ];
                                echo json_encode($response);
                                return;
                            }

                        } else {
                            $return = $this->api->apiPost($this->user['token'], "import/process_update_tat_toan_import", $data);
                            $response = [
                                'res' => false,
                                'status' => "400",
                                'message' => $return->message . ' Mã phiếu ghi:' . $data['code_contract'] . ' Mã hợp đồng:' . $data['code_contract_disbursement']
                            ];
                            echo json_encode($response);
                            return;
                        }

                    }

                }
                $response = [
                    'res' => true,
                    'status' => "200",
                    'message' => $this->lang->line('import_success')
                ];


            } else {

                $response = [
                    'res' => false,
                    'status' => "400",
                    'message' => $this->lang->line('type_invalid')
                ];
            }
        }
        echo json_encode($response);
        return;
    }

    public function importFakeContract()
    {
        if (empty($_FILES['upload_file']['name'])) {
            $this->session->set_flashdata('error', $this->lang->line('not_selected_file_import'));
            redirect('ImportDatabase');
        } else {
            $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
                $arr_file = explode('.', $_FILES['upload_file']['name']);
                $extension = end($arr_file);
                if ('csv' == $extension) {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
                $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                // var_dump($sheetData);
                // die();
                $createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
                if (count($sheetData[0]) != 73) {
                    $this->session->set_flashdata('error', "Bạn nhập sai định dạng file");
                    redirect('ImportDatabase');
                }
                foreach ($sheetData as $key => $value) {
                    if ($key >= 2) {
                        $province_code_cr = $this->searchCodeprovince($value["23"]);
                        $province_code_hh = $this->searchCodeprovince($value["29"]);
                        $district_code_cr = $this->searchCodeDistrict($province_code_cr, $value["24"]);
                        $district_code_hh = $this->searchCodeDistrict($province_code_hh, $value["30"]);
                        $ward_code_cr = $this->searchCodeWard($district_code_cr, $value["25"]);
                        $ward_code_hh = $this->searchCodeWard($district_code_hh, $value["31"]);
                        $data = array(
                            "customer_infor" => array(
                                "customer_name" => $value["16"],
                                "customer_email" => $value["18"],
                                "customer_phone_number" => '0' . $value["17"],
                                "customer_identify" => $value["19"],
                                "customer_gender" => $this->checkGender($value["20"]),
                                "customer_BOD" => date("Y-m-d", strtotime($value["21"])),
                                "marriage" => $value["22"],
                            ),
                            "current_address" => array(
                                "province" => $province_code_cr,
                                "province_name" => $value["23"],
                                "district" => $district_code_cr,
                                "district_name" => $value["24"],
                                "ward" => $ward_code_cr,
                                "ward_name" => $value["25"],
                                "form_residence" => $value["27"],
                                "time_life" => $value["28"],
                                "current_stay" => $value["26"],
                            ),
                            "houseHold_address" => array(
                                "province" => $province_code_hh,
                                "province_name" => $value["29"],
                                "district" => $district_code_hh,
                                "district_name" => $value["30"],
                                "ward" => $ward_code_hh,
                                "ward_name" => $value["31"],
                                "address_household" => $value["32"]
                            ),
                            "job_infor" => array(
                                "name_company" => $value["33"],
                                "phone_number_company" => '0' . (int)$value["35"],
                                "address_company" => $value["34"],
                                "job_position" => $value["36"],
                                "salary" => $value["37"],
                                "receive_salary_via" => $this->receive_salary_via($value["38"])
                            ),
                            "relative_infor" => array(
                                "type_relative_1" => $value["40"],
                                "fullname_relative_1" => $value["39"],
                                "phone_number_relative_1" => '0' . $value["41"],
                                "hoursehold_relative_1" => $value["42"],
                                "confirm_relativeInfor_1" => $value["43"],

                                "type_relative_2" => $value["45"],
                                "fullname_relative_2" => $value["44"],
                                "phone_number_relative_2" => '0' . $value["46"],
                                "hoursehold_relative_2" => $value["47"],
                                "confirm_relativeInfor_2" => $value["48"],
                            ),
                            "loan_infor" => array(
                                "type_loan" => $this->type_loan($value["49"]),
                                "type_property" => $this->type_property($value["50"]),
                                "name_property" => array("text" => $value["51"]),
                                "price_property" => intval(preg_replace('/[^0-9]/', '', $value["52"])),
                                "amount_money_max" => intval(preg_replace('/[^0-9]/', '', $value["52"])),
                                "amount_loan" => intval(preg_replace('/[^0-9]/', '', $value["52"])),
                                "amount_money" => intval(preg_replace('/[^0-9]/', '', $value["52"])),
                                "type_interest" => $value["53"],
                                "number_day_loan" => (int)$value["54"] * 30,
                                "period_pay_interest" => 30,
                                "insurrance_contract" => 2,
                                "loan_purpose" => $value["55"],
                                "note" => "hợp đồng cũ",
                            ),
                            "receiver_infor" => array(
                                "type_payout" => 2,
                                "amount" => $value["52"],
//                              "bank_id"=>$this->findbankid($value["7"]),
                                "bank_name" => $value["7"],
                                "atm_card_number" => "",
                                "bank_account" => $value["9"],
                                "bank_account_holder" => $value["10"],
                                "bank_branch" => $value["8"]
                            ),
                            "store" => array(
                                "id" => $this->findstoreid($value["3"]),
                                "name" => $value["3"],
                                "address" => $value["3"]
                            ),
                            "created_at" => $createdAt,
//                          "created_by"=>$this->findCreatBy($value["3"]),
                            "property_infor" => array(
                                "0" => array(
                                    "name" => "Nhãn hiệu",
                                    "slug" => "nhan-hieu",
                                    "value" => $value["56"],
                                ),
                                "1" => array(
                                    "name" => "Model",
                                    "slug" => "model",
                                    "value" => $value["57"],
                                ),
                                "2" => array(
                                    "name" => "Biển số xe",
                                    "slug" => "bien-so-xe",
                                    "value" => $value["58"],
                                ),
                                "3" => array(
                                    "name" => "Số khung",
                                    "slug" => "so-khung",
                                    "value" => $value["59"],
                                ),
                                "4" => array(
                                    "name" => "Số máy",
                                    "slug" => "so-may",
                                    "value" => $value["60"],
                                ),
                            ),
                            "fee" => array(
                                "percent_interest_customer" => $value["63"],
                                "percent_advisory" => $value["64"],
                                "percent_expertise" => $value["65"],
                                "penalty_percent" => $value["66"],
                                "penalty_amount" => $value["67"],
                                "percent_prepay_phase_1" => $value["68"],
                                "percent_prepay_phase_2" => $value["69"],
                                "percent_prepay_phase_3" => $value["70"],
                                "fee_extend" => $value["71"],
                                "percent_interest_investor" => $value["63"],
                            ),
                            "status" => 16,
                            "code_contract_disbursement" => !empty($value["2"]) ? $value["2"] : $value["1"],
                            "code_contract_parent" => !empty($value["2"]) ? $value["1"] : "",
                            "disbursement_date" => !empty($value["4"]) ? strtotime(str_replace('/', '-', $value["4"])) + 7 * 60 * 60 : '',
                            "number_contract" => "",
                            "investor_code" => $value["14"],
                            "updated_at" => $createdAt,
                            "note" => "",
                            "expertise_infor" => array(
                                "expertise_file" => $value["61"],
                                "expertise_field" => $value["62"],
                            ),
                            "created_by" => $value["72"],
                            "expire_date" => $this->expire_date($value["4"], $value["54"])
                        );
                        if (!empty($value["2"])) {
                            $data['fee']['extend'] = $value["71"];
                        };
                        // call api insert db
                        $return = $this->api->apiPost($this->user['token'], "contract/process_create_contract_import", $data);
//                      if($return->check == 0){
//                          $trace = ["row_excel"=>$key,"status"=>"false"];
//                          array_push($log,$trace);
//                      }
                    }
                }
                try {
                    $this->session->set_flashdata('success', $this->lang->line('import_success'));
                    redirect('importDatabase/fakeData');
                } catch (Exception $ex) {
                    $this->session->set_flashdata('error', $this->lang->line('import_failed'));
                    redirect('importDatabase/fakeData');
                }
            } else {
                $this->session->set_flashdata('error', $this->lang->line('type_invalid'));
                redirect('importDatabase/fakeData');
            }
        }
    }

    public static function slugify($str)
    {
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd' => 'đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D' => 'Đ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );

        foreach ($unicode as $nonUnicode => $uni) {
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }
        $str = str_replace(' ', '-', $str);
        return strtolower($str);
    }

    public function searchCodeprovince($province)
    {
        $name = $this->slugify($province);
        $data = array(
            "name" => $name
        );
        $result = $this->api->apiPost($this->user['token'], "province/searchCodeprovince", $data);
//      var_dump($result->data[0]->code);die();
        return $result->data[0]->code;
    }

    public function searchCodeDistrict($province, $district)
    {
        $district = $this->slugify($district);
        $data = array(
            "name" => $district,
            "parent_code" => $province,
        );
        $result = $this->api->apiPost($this->user['token'], "province/searchCodedistrict", $data);
//      var_dump($parent_code->data[0]->code);die();
        return $result->data[0]->code;
    }

    public function searchCodeWard($district, $ward)
    {
        $name = $this->slugify($ward);
        $data = array(
            "name" => $name,
            "parent_code" => $district,
        );
        $result = $this->api->apiPost($this->user['token'], "province/searchCodeward", $data);
        return $result->data[0]->code;
    }

    public function receive_salary_via($text)
    {
        if ($text == "Tiền mặt") {
            $method = 1;
        } else {
            $method = 2;
        }
        return $method;
    }

    public function type_loan($cond)
    {
        if ($cond == 1) {
            $result = array(
                "id" => "5da82ed2a104d435e3b8ae65",
                "text" => "Cầm cố",
                "code" => "CC"
            );
        }
        if ($cond == 2) {
            $result = array(
                "id" => "5da82ee7a104d435e3b8ae66",
                "text" => "Cho vay",
                "code" => "DKX"
            );
        }
        if ($cond == 3) {
            $result = array(
                "id" => "5fdf75fa6653056471f0b7fe",
                "text" => "Tín chấp",
                "code" => "TC"
            );
        }
        return $result;
    }

    public function type_property($cond)
    {
        if ($this->slugify($cond) == "o-to") {
            $result = array(
                "id" => "5db7e6bfd6612bceec515b76",
                "text" => "Ô tô",
                "code" => "OTO"
            );
        } else {
            $result = array(
                "id" => "5db7e6b4d6612b173e0728a4",
                "text" => "Xe máy",
                "code" => "XM"
            );
        }
        return $result;
    }

//  public function findbankid($name){
//
//  }
//  public function marriage($text){
//      $status = $this->slugify($text);
//      if($status == 'da-ly-hon' or $status == 'ly-hon'){
//          return 3;
//      }
//      if($status == 'da-ket-hon'){
//          return 1;
//      }
//      if($status == 'doc-than'){
//          return 2;
//      }
//  }

    public function findstoreid($name)
    {
        if (isset($name)) {
            $data = array(
                "name" => $name
            );
            $result = $this->api->apiPost($this->user['token'], "store/getStoreIdByName", $data);
        }
        return $result->data[0]->_id->{'$oid'};
    }

    public function checkGender($gender)
    {
        $gender = $this->slugify($gender);
        if ($gender == 'nam') {
            return 1;
        } else {
            return 2;
        }
    }

    public function expire_date($disbursement_date, $number_day_loan)
    {
        if (!empty($disbursement_date) && !empty($number_day_loan)) {
            $expire_date = strtotime(str_replace('/', '-', $disbursement_date)) + ((((int)$number_day_loan * 30) - 1) * 24 * 60 * 60);
            return $expire_date;
        }
    }
//  public function type_interest($text){
//      if($text == "Trả góp"){
//          $result = 1;
//      }else{
//          $result = 2;
//      }
//      return $result;
//  }

    // hàm xóa hết danh sách hợp đồng cũ được import
    public function delete_old_contract()
    {
        $data = $this->input->post();
        $data['created_at'] = $this->security->xss_clean($data['created_at']);
        $data['code_contract'] = $this->security->xss_clean($data['code_contract']);
        $res = $this->api->apiPost($this->user['token'], "contract/delete_old_contract", $data);
        if ($res->status == 200) {
            $this->session->set_flashdata('success', "Xóa thành công hợp đồng cũ");
            redirect('importDatabase');
        } else {
            $this->session->set_flashdata('error', "Xóa thất bại hợp đồng cũ");
            redirect('importDatabase');
        }
    }

    public function delete_old_transaction()
    {
        $res = $this->api->apiPost($this->user['token'], "contract/delete_old_transaction");
        if ($res->status == 200) {
            $this->session->set_flashdata('success', "Xóa thành công hợp transaction");
            redirect('importDatabase');
        } else {
            $this->session->set_flashdata('error', "Xóa thất bại hợp transaction");
            redirect('importDatabase');
        }
    }

    public function buttonImport()
    {
        $this->data['template'] = 'page/importns/import';
        $this->load->view('template', isset($this->data) ? $this->data : NULL);
    }

    public function importNhanSu()
    {
        //redirect('ImportDatabase');
        if (empty($_FILES['upload_file']['name'])) {
            $response = [
                'res' => false,
                'status' => "400",
                'message' => $this->lang->line('not_selected_file_import')
            ];
            echo json_encode($response);
            return;
        } else {
            $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
                $arr_file = explode('.', $_FILES['upload_file']['name']);
                $extension = end($arr_file);
                if ('csv' == $extension) {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
                $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                $createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
                if (count($sheetData[0]) < 6) {

                    $response = [
                        'res' => false,
                        'status' => "400",
                        'message' => "Bạn nhập sai định dạng file"
                    ];
                    echo json_encode($response);
                    return;
                }

                foreach ($sheetData as $key => $value) {

                    if ($key >= 1) {
                        $data = array(
                            "customer_code" => !empty($value["0"]) ? (trim($value["0"])) : "",
                            "customer_name" => !empty($value["1"]) ? (trim($value["1"])) : "",
                            "customer_phone" => !empty($value["2"]) ? (trim($value["2"])) : "",
                            "title" => !empty(trim($value["3"])) ? (trim($value["3"])) : "",
                            "position" => !empty(trim($value["4"])) ? (trim($value["4"])) : "",
                            "part" => !empty(trim($value["5"])) ? (trim($value["5"])) : "",
                            'created_at' => $createdAt
                        );

                        if (empty($data["customer_code"])){
                            $response = [
                                'res' => false,
                                'status' => "400",
                                'message' => "Mã nhân viên không được để trống"
                            ];
                            echo json_encode($response);
                            return;
                        }
                        if (!preg_match("/^[A-z0-9]{0,15}$/", $data['customer_code'])){
                            $response = [
                                'res' => false,
                                'status' => "400",
                                'message' => "Mã nhân viên không đúng định dạng"
                            ];
                            echo json_encode($response);
                            return;
                        }

                        if (empty($data["customer_name"])){
                            $response = [
                                'res' => false,
                                'status' => "400",
                                'message' => "Tên không được để trống"
                            ];
                            echo json_encode($response);
                            return;
                        }

                        if (!empty($data["customer_phone"])){
                            if (!preg_match("/^[0-9]{10}$/", $data['customer_phone'])){
                                $response = [
                                    'res' => false,
                                    'status' => "400",
                                    'message' => "Số điện thoại không đúng định dạng"
                                ];
                                echo json_encode($response);
                                return;
                            }
                        }

                        if (empty($data["title"])){
                            $response = [
                                'res' => false,
                                'status' => "400",
                                'message' => "Chức danh không được để trống"
                            ];
                            echo json_encode($response);
                            return;
                        }
                        if (empty($data["position"])){
                            $response = [
                                'res' => false,
                                'status' => "400",
                                'message' => "Chức vụ không được để trống"
                            ];
                            echo json_encode($response);
                            return;
                        }
                        if (empty($data["part"])){
                            $response = [
                                'res' => false,
                                'status' => "400",
                                'message' => "Bộ phận không được để trống"
                            ];
                            echo json_encode($response);
                            return;
                        }
                        $return = $this->api->apiPost($this->user['token'], "import/nhansu_import", $data);

                    }
                }
                if ($return->status == 200) {
                    $response = [
                        'res' => true,
                        'status' => "200",
                        'message' => $this->lang->line('import_success')
                    ];
                }

            } else {

                $response = [
                    'res' => false,
                    'status' => "400",
                    'message' => $this->lang->line('type_invalid')
                ];


            }
        }
        echo json_encode($response);
        return;
    }

    /**
    * Update phiếu thu miễn giảm
    */
    public function updatePhieuThuMienGiam()
    {
        $this->WriteLog("Import-PT-" . date("Ymd", time()) . ".txt", " ================= START ======================= ");
        if (empty($_FILES['upload_file']['name'])) {

            $response = [
                'res' => false,
                'status' => "400",
                'message' => $this->lang->line('not_selected_file_import')
            ];
            echo json_encode($response);
            return;
        } else {
            $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
                $arr_file = explode('.', $_FILES['upload_file']['name']);
                $extension = end($arr_file);
                if ('csv' == $extension) {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
                $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);

                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                $createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
                $data = [];
                foreach ($sheetData as $key => $value) {
                    if ($key >= 1) {
                        if ( empty($value[1]) ) continue;
                        $dataPost = [
                            'code'                          => $value[1],
                            'code_contract'                 => $value[2],
                            'code_contract_disbursement'    => $value[3],
                            'customer_bill_name'            => $value[4],
                            'total_deductible'              => (int)$value[5],
                            'discounted_fee'                => (int)$value[5],
                            'date_pay'                      => $value[6],
                            'type_pt'                       => (int)$value[7],
                            'note'                          => $value[8],
                            'updated_at'                    => $createdAt,
                            'updated_by'                    => "system",
                            'type_import'                   => "edit_mg"
                        ];
                        $data[] = $dataPost;
                    }
                }
                $this->WriteLog("Import-PT-" . date("Ymd", time()) . ".txt", " ================= Input Data ======================= ");
                $this->WriteLog("Import-PT-" . date("Ymd", time()) . ".txt", json_encode($data));
                $return = $this->api->apiPost($this->user['token'], "import/updatePhieuThuMienGiam", $data);
                $this->WriteLog("Import-PT-" . date("Ymd", time()) . ".txt", "response: " . json_encode($return));
                if (isset($return->status) && $return->status == 200) {
                    $response = [
                        'res' => true,
                        'status' => "200",
                        'message' => $this->lang->line('import_success'),
                    ];
                    echo json_encode($response);
                    $this->WriteLog("Import-PT-" . date("Ymd", time()) . ".txt", " ================= End Success ======================= ");
                    return;
                }
                
            }

        }
        $response = [
            'res' => false,
            'status' => "400",
            'message' => $this->lang->line('not_selected_file_import')
        ];
        $this->WriteLog("Import-PT-" . date("Ymd", time()) . ".txt", " ================= End Failed ======================= ");
        echo json_encode($response);
        return;
        
    }

    /**
    * Chạy lại hợp đồng
    */
    public function rerunContract()
    {
        $this->WriteLog("Rerun-Contract-" . date("Ymd", time()) . ".txt", " ================= START ======================= ");
        if (empty($_FILES['upload_file']['name'])) {

            $response = [
                'res' => false,
                'status' => "400",
                'message' => $this->lang->line('not_selected_file_import')
            ];
            $this->WriteLog("Rerun-Contract-" . date("Ymd", time()) . ".txt", " ================= End Failed ======================= ");
            echo json_encode($response);
            return;
        } else {
            $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
                $arr_file = explode('.', $_FILES['upload_file']['name']);
                $extension = end($arr_file);
                if ('csv' == $extension) {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
                $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);

                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                $createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
                $data = [];
                foreach ($sheetData as $key => $value) {
                    if ($key >= 1) {
                        if ( empty($value[1]) ) continue;
                        $dataPost = [
                            'code_contract' => $value[1],
                        ];
                        $this->WriteLog("Rerun-Contract-" . date("Ymd", time()) . ".txt", "request: " . json_encode($dataPost));
                        $return = $this->api->apiPost($this->user['token'], "Payment/payment_all_contract", $dataPost);
                        $this->WriteLog("Rerun-Contract-" . date("Ymd", time()) . ".txt", "response: " . json_encode($return));
                    }
                }
                
            }

        }
        $response = [
            'res' => true,
            'status' => "200",
            'message' => $this->lang->line('import_success')
        ];
        $this->WriteLog("Rerun-Contract-" . date("Ymd", time()) . ".txt", " ================= End Success ======================= ");
        echo json_encode($response);
        return;
        
    }

    public function WriteLog($fileName,$data,$breakLine=true,$addTime=true) {
        $fp = fopen("log/".$fileName,'a');
        if ($fp)
        {
            if ($breakLine)
            {
                if ($addTime)
                    $line = date("H:i:s, d/m/Y:  ",time()).$data. " \n";
                else
                    $line = $data. " \n";
            }
            else
            {
                if ($addTime)
                    $line = date("H:i:s, d/m/Y:  ",time()).$data;
                else
                    $line = $data;
            }
            fwrite($fp,$line);
            fclose($fp);
        }
    }

}

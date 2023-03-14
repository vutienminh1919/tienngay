<?php
/**
 * Created by PhpStorm.
 * User: phanc
 * Date: 5/5/2020
 * Time: 5:09 PM
 */

require_once __DIR__.'/../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BadDebt extends MY_Controller
{
	public function __construct() {
		parent::__construct();
		// $this->api = new Api();
		$this->load->library('pagination');
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model("time_model");
		$this->load->helper('lead_helper');
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
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	private function pushJson($code, $data) {
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}

	public function index(){
		$this->data["pageName"] = "Quản lý HĐ quá hạn";
		$name = !empty($_GET['name'])?$_GET['name']:'';
		$identify = !empty($_GET['identify'])?$_GET['identify']:'';
		$number_phone = !empty($_GET['number_phone'])?$_GET['number_phone']:'';
		$code_contract = !empty($_GET['code_contract'])?$_GET['code_contract']:'';
		$start = !empty($_GET['fdate']) ?$_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('badDebt?name='.$name.'&indentify='.$identify.'&number_phone='.$number_phone.'&code_contract='.$code_contract.'&fdate='.$start.'&tdate='.$end);
		$config['uri_segment']=$uriSegment;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$data = array(
			'name'=> $name,
			'number_phone' => $number_phone,
			'identify' => $identify,
			'code_contract' =>$code_contract,
			'start' => $start,
			'end' => $end,
			"per_page" => $config['per_page'],
			"uriSegment" => $config['uri_segment']
		);
//		var_dump($data);die();
		$datas = $this->api->apiPost($this->user['token'], "badDebt/get_all",$data);
		if(!empty($datas->status) && $datas->status == 200){
			$this->data['baddebt'] = $datas->data;
			$config['total_rows'] = $datas->count;
		}

		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();

		$this->data['template'] = 'page/baddebt/list';
		$this->load->view('template', isset($this->data) ? $this->data:NULL);
	}

	public function callCustomer(){
		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['note'] = $this->security->xss_clean($data['note']);
		if (empty($data['id'])) {
			$res = array(
				'status' => 500,
				'message' => "Thiếu ID",
			);
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $res)));
			return;
		}
		$sendApi = array(
			"id" => $data['id'],
			"note" => $data['note'],
		);
		$return = $this->api->apiPost($this->user['token'], "badDebt/call_customer", $sendApi);
		$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		return;
	}

	public function importBadDebt(){
		if(empty($_FILES['upload_file']['name'])){
			$this->session->set_flashdata('error', $this->lang->line('not_selected_file_import'));
			redirect('badDebt');
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
				$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
				//Encrypt TripleDes
//				$log = array();
//				$count = 0;
				foreach($sheetData as $key => $value){
					if($key != 0 && !empty($value["1"])){
						$data = array(
							"id" => $value["1"],
							"code_contract" => $value["2"],
							"code_customer" => $value["3"],
							"name" => $value["4"],
							"DOB" => $value["5"],
							"sex" => $value["6"],
							"number_phone" => $value["7"],
							"relative_phone_1" =>  $value["8"],
							"relative_phone_2" =>$value["9"],
							"identify" => $value["10"],
							"current_address" => $value["11"],
							"current_district" => $value["12"],
							"current_province" => $value["13"],
							"household_address" => $value["14"],
							"household_district" => $value["15"],
							"household_province" => $value["16"],
							"date_sign_contract" =>$value["17"],
							"date_maturity" => strtotime($value["18"]),
							"amount" => $value["19"],
							"amount_interest" =>$value["20"],
							"loan_fee" =>  $value["21"],
							"closing_amount" =>  $value["22"],
							"amount_customer_paid" =>  $value["23"],
							"closing_balance" =>  $value["24"],
							"period" =>  $value["25"],
							"loan_purpose" =>  $value["26"],
							"pay_history" =>  $value["27"],
							"number_of_loan" =>  $value["28"],
							"loan_info_package" =>  $value["29"],
							"data_of_delivery" =>  $value["30"],
							"DPD" =>  $value["31"],
							"result_remind_baddebt" =>  $value["32"],
							"payment_date" =>  $value["33"],
							"amount_payment_appointment" =>  $value["34"],
							"note" =>  $value["35"],
							"createdAt" => $createdAt
						);
						// call api insert db
						$return = $this->api->apiPost($this->user['token'], "badDebt/create", $data);
//						if($return->check == 0){
//							$trace = ["row_excel"=>$key,"status"=>"false"];
//							array_push($log,$trace);
//						}
					}
				}
//				$file_name = "import".date("d-m-Y").time().".txt";
//				$myfile = fopen(__DIR__ . '/../logs/import/'.$file_name, "w") or die("Unable to open file!");
//				fwrite($myfile, json_encode($log));
//				fclose($myfile);
				try {
					$this->session->set_flashdata('success', $this->lang->line('import_success'));
					redirect('badDebt');
				} catch (Exception $ex) {
					$this->session->set_flashdata('error', $this->lang->line('import_failed'));
					redirect('badDebt');
				}
			}else{
				$this->session->set_flashdata('error', $this->lang->line('type_invalid'));
				redirect('badDebt');
			}
		}
	}

	public function doNoteReminder(){
		$data = $this->input->post();
		$data['note'] = $this->security->xss_clean($data['note']);
		$data['contractId'] = $this->security->xss_clean($data['contractId']);
		$data['payment_date'] = $this->security->xss_clean($data['payment_date']);
		$data['amount_payment_appointment'] = $this->security->xss_clean($data['amount_payment_appointment']);
		$data['result_reminder'] = $this->security->xss_clean($data['result_reminder']);
		$dataPost = array(
			"note" => $data['note'],
			"payment_date" => $data['payment_date'],
			"amount_payment_appointment" => $data['amount_payment_appointment'],
			"result_reminder" => $data['result_reminder'],
			"contract_id" => $data['contractId'],
		);
//		var_dump($dataPost);die();
		$result = $this->api->apiPost($this->userInfo['token'], "badDebt/do_note_reminder", $dataPost);
		if(!empty($result->status) && $result->status == 200){
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $result->message, "data"=>$result)));
			return;
		}else{
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $result->message, "data"=>$result)));
			return;
		}
	}

	public function viewNote(){
		$id = $_GET['id'];
		if(!empty($id)){
			$dataPost = array(
				"id" => $id,
			);
			$result =  $this->api->apiPost($this->userInfo['token'], "badDebt/getDetail", $dataPost);
			if(!empty($result->status) && $result->status == 200){
				$this->data['template'] = 'page/baddebt/shownote';
				$this->data['contractDB'] = $result->data;
				$this->load->view('template', isset($this->data) ? $this->data:NULL);
			}
		}
	}

}

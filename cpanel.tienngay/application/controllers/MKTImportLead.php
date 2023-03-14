<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MKTImportLead extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		// $this->api = new Api();
		$this->load->model("time_model");
		$this->load->helper('lead_helper');
		$this->createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		if (!in_array('5ea1b6d2d6612b65473f2b68', $this->data['groupRoles']) && !$this->is_superadmin) {
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

	public function index()
	{
		$this->data['template'] = 'page/importdb/view_import_lead';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
	public function trandata()
	{
		$this->data['template'] = 'page/importdb/view_import_trandata';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
	public function importLead() {
		if(empty($_FILES['upload_file']['name'])){
			$this->session->set_flashdata('error', $this->lang->line('not_selected_file_import'));
			redirect('MKTImportLead');
		} else {
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
				if(count($sheetData[0]) != 16){
					$this->session->set_flashdata('error', "Bạn nhập sai định dạng file");
					redirect('MKTImportLead');
				}
				
				foreach ($sheetData as $key => $value) {
					if ($key >=1) {
						if (strtotime($value[0]) > $createdAt) {
							$this->session->set_flashdata('error', "Thời gian khởi tạo không được lớn hơn thời gian hiện tại!" );
							redirect('MKTImportLead');
						}
					}
				}
				
				foreach($sheetData as $key => $value){
					if($key >= 1 ){
						$status_sale = 1;
						if(trim($value[12]) == 'Không đủ điều kiện vay') {
							$status_sale = 4;
						}
						if(trim($value[12]) == 'Hẹn đến PGD') {
							$status_sale = 9;
						}
						$area="";
						if(strlen(strstr(strtoupper($value[4]), "HN")) > 0) {
								$area='01';
							} elseif(strlen(strstr(strtoupper($value[4]), "HCM")) > 0) {
								$area='79';
							} else {
								$area='00';
							}
						if (empty($value[2])){
							continue;
						}

						if ($value[15] == 16) {
							$data = [
								'fullname' => empty($value[1]) ? "" : $value[1],
								'phone_number' => str_pad($value[2], 10, '0', STR_PAD_LEFT),
								'area' => $area,
								'link' => $value[5],
								'source' => $value[15],
								'status' => $value[6] ? '1' : '0',
								'status_sale' => $status_sale,
								"status_vbee" => 20,
								"call_vbee" => 0,
								"day_call" => 1,
								'utm_source' => $value[7],
								'utm_campaign' => $value[8],
								'created_at' => (empty($value[0])) ? time() : strtotime($value[0]),
								'priority' => 0,
								"status_call" => "0",
							];
						} else {
							$data = [
								'fullname' => empty($value[1]) ? "" : $value[1],
								'phone_number' => str_pad($value[2], 10, '0', STR_PAD_LEFT),
								'area' => $area,
								'link' => $value[5],
								'source' => $value[15],
								'status' => $value[6] ? '1' : '0',
								'status_sale' => $status_sale,
								"status_vbee" => 20,
								"call_vbee" => 0,
								"day_call" => 1,
								'utm_source' => $value[7],
								'utm_campaign' => $value[8],
								'created_at' => (empty($value[0])) ? time() : strtotime($value[0]),
								'priority' => 0,
								"status_call" => "0",
							];
						}

						//var_dump($data); die;
						// call api insert db
						$return = $this->api->apiPost($this->user['token'], "lead_custom/import_lead", $data);
					}
				}
				try {
					$this->session->set_flashdata('success', $this->lang->line('import_success'));
					redirect('MKTImportLead');
				} catch (Exception $ex) {
					$this->session->set_flashdata('error', $this->lang->line('import_failed'));
					redirect('MKTImportLead');
				}
			}else{
				$this->session->set_flashdata('error', $this->lang->line('type_invalid'));
				redirect('MKTImportLead');
			}
		}
	}
		public function importTrandata() {
		if(empty($_FILES['upload_file']['name'])){
			$this->session->set_flashdata('error', $this->lang->line('not_selected_file_import'));
			redirect('MKTImportLead/trandata');
		} else {
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
			//var_dump(count($sheetData[0])); die;
				if(count($sheetData[0]) != 9){
					$this->session->set_flashdata('error', "Bạn nhập sai định dạng file");
					redirect('MKTImportLead/trandata');
				}
				
				
				
				foreach($sheetData as $key => $value){
					 $get="";
						if($key >= 1 && !empty($value[0]) ){
						if($value[0]=="K03")
						{
							$get="aggregator/api/v1/kyc/k03_locationDiscovery";
						$data = [
							'phoneNumber' =>  (string)$value[1],
						];
					   }
					   if($value[0]=="V03")
						{
						$get="aggregator/api/v1/verification/v03_phone";
						$data = [
							'phoneNumber' =>  (string)$value[1],
							'id' =>  (string)$value[2],
							'provider' =>  (string)$value[3],
						];
					   }
					   		if($value[0]=="K06")
						{
							$get="aggregator/api/v1/kyc/k06_topRefPhone";
						$data = [
							'phoneNumber' =>  (string)$value[1],
						];
					   }
					   		if($value[0]=="K07")
						{
							$get="aggregator/api/v1/kyc/k07_simActiveDate";
						$data = [
							'phoneNumber' =>  (string)$value[1],
						];
					   }
					   	if($value[0]=="K08")
						{
							$get="aggregator/api/v1/kyc/k08_typeOfPhone";
						$data = [
							'phoneNumber' =>  (string)$value[1],
							'provider' =>  (string)$value[3],
						];
					   }
					   if($value[0]=="K11")
						{
							$get="aggregator/api/v1/kyc/k11_simType";
						$data = [
							'phoneNumber' =>  (string)$value[1],
							'provider' => (string)$value[3],
						];
					   }
					    if($value[0]=="K13")
						{
							$get="aggregator/api/v1/kyc/k11_simType";
						$data = [
							'phoneNumber' =>  (string)$value[1],
							'provider' => (string)$value[3],
						];
					   }
					   if($value[0]=="K04")
						{
							$get="aggregator/api/v1/kyc/k04_disbursementRate";
						$data = [
							'accountNo' =>  (string)$value[4],
							'timeline' =>  (string)$value[5],
						];
					   }
                       $data['full_name'] =  (string)$value[6];
					   $data['code_contract_disbursement'] =  (string)$value[7];
					   if(!empty($get))
					   {
					   $data['type_trandata']=$value[0];
					 $data['response']=  $this->get_info_trandata($data,$get);
					// var_dump( $data['response']); die;
						// call api insert db
						$return = $this->api->apiPost($this->user['token'], "trandata/create_trandata", $data);
					  }
					}
				}
				redirect('MKTImportLead/trandata');
			}
		}
	}
		public function get_info_trandata($data_post=[],$get=''){
		$url=	$this->config->item("TRANDATA_URL");
		$user=   $this->config->item("TRANDATA_USER");
		//$data_post
		$data_post['requestId']=$user.'_'.$this->random_unique_string();
	
		$data=json_encode($data_post);
		$token=	$this->get_token();
		$service =$url.$get;
		$headr = array();
		
		$headr[] = 'Content-type: application/json';
		$headr[] = 'Authorization: Bearer '.$token;
      $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $service);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headr);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		$result1 = json_decode($result);
		//$result1=(!empty($result1->Data->sessionToken)) ? $result1->Data->sessionToken : ''
		//echo $result1;
		return $result1;
		}
	 public   function random_unique_string($length=18) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ12345689';
    $my_string = '';
    for ($i = 0; $i < $length; $i++) {
      $pos = mt_rand(0, strlen($chars) -1);
      $my_string .= substr($chars, $pos, 1);
    }
    return $my_string;
  }
    public function get_token()
	{
		$user=   $this->config->item("TRANDATA_USER");
		$pass=	$this->config->item("TRANDATA_PAS");
		$url=	$this->config->item("TRANDATA_URL");
		$data_post=['username'=>$user,'password'=>$pass];
		$data_post=json_encode($data_post);
		$service =$url.'account/unauth/v1/login';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $service);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		$result1 = json_decode($result);
		$result1=(!empty($result1->Data->sessionToken)) ? $result1->Data->sessionToken : '';
		//echo $result1;
		return $result1;
	}

	public function importLead_trandata() {
		if(empty($_FILES['upload_file']['name'])){
			$this->session->set_flashdata('error', $this->lang->line('not_selected_file_import'));
			redirect('MKTImportLead');
		} else {
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
				if(count($sheetData[0]) != 5){
					$this->session->set_flashdata('error', "Bạn nhập sai định dạng file");
					redirect('MKTImportLead');
				}

//				foreach ($sheetData as $key => $value) {
//					if ($key >=1) {
//						if (strtotime($value[0]) > $createdAt) {
//							$this->session->set_flashdata('error', "Thời gian khởi tạo không được lớn hơn thời gian hiện tại!" );
//							redirect('MKTImportLead');
//						}
//					}
//				}

				foreach($sheetData as $key => $value){
					if($key >= 1 ){

						$area = !empty(($value[3])) ? trim($value[3]) : "";

						if ($area != "Hà Nội" && $area != "Hồ Chí Minh" && $area != "Bình Dương" && $area != "Cần Thơ" && $area != "An Giang"){
							continue;
						}

						$data = [
							'fullname' =>  !empty($value[1]) ? trim($value[1]) : "",
							'phone_number' => str_pad($value[2], 10, '0', STR_PAD_LEFT),
							'area' => $area,
							'source' => !empty($value[5]) ? trim($value[5]) : "trandata",
							'status' => '1',
							'status_sale' => "1",
							'created_at' => $this->createdAt,
						];

						// call api insert db
						$return = $this->api->apiPost($this->user['token'], "lead_custom/import_lead", $data);
					}
				}
				try {
					$this->session->set_flashdata('success', $this->lang->line('import_success'));
					redirect('MKTImportLead');
				} catch (Exception $ex) {
					$this->session->set_flashdata('error', $this->lang->line('import_failed'));
					redirect('MKTImportLead');
				}
			}else{
				$this->session->set_flashdata('error', $this->lang->line('type_invalid'));
				redirect('MKTImportLead');
			}
		}
	}

	public function index_tool_fb(){

		$countBorrowed = $this->api->apiPost($this->userInfo['token'], "lead_custom/get_file_group_name_count");

		$count = (int)$countBorrowed->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('MKTImportLead/index_tool_fb');
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;

		$data["per_page"] = $config['per_page'];
		$data["uriSegment"] = $config['uri_segment'];

		$export_uid = $this->api->apiPost($this->userInfo['token'], "lead_custom/get_file_group_name",$data);

		if (!empty($export_uid) && $export_uid->status == 200) {
			$this->data['export_uid'] = $export_uid->data;
		} else {
			$this->data['export_uid'] = [];
		}

		$this->data['template'] = 'page/lead/tool_fb/tool_fb.php';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function importUidFacebook()
	{

		if (empty($_FILES['upload_file']['name'])) {
			$this->session->set_flashdata('error', $this->lang->line('not_selected_file_import'));
			redirect('MKTImportLead/index_tool_fb');
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

				if (count($sheetData) > 2500){
					$this->session->set_flashdata('error', 'Dung lượng file không quá 2500 uid');
					redirect('MKTImportLead/index_tool_fb');
				}

				$check = $this->api->apiPost($this->user['token'], "lead_custom/check_name_file_group", ['file_name' => $_FILES['upload_file']['name']]);

				if (!empty($check) && $check->status != 200){
					$this->session->set_flashdata('error', 'Tên file import không được trùng nhau');
					redirect('MKTImportLead/index_tool_fb');
				}

				foreach ($sheetData as $key => $value) {
					if ($key >= 1) {

						$data = [
							'fullname' => !empty($value[1]) ? trim($value[1]) : "",
							'uid_facebook' => !empty($value[2]) ? trim($value[2]) : "",
							'gender' => !empty($value[3]) ? trim($value[3]) : "",
							'birthday' => !empty($value[4]) ? trim($value[4]) : "",
							'location' => !empty($value[7]) ? trim($value[7]) : "",
							'file_name' => $_FILES['upload_file']['name'],
							'created_at' => $this->createdAt,
						];

						$return = $this->api->apiPost($this->user['token'], "lead_custom/import_lead_uid", $data);
					}
				}
				try {
					$this->session->set_flashdata('success', $this->lang->line('import_success'));
					redirect('MKTImportLead/index_tool_fb');
				} catch (Exception $ex) {
					$this->session->set_flashdata('error', $this->lang->line('import_failed'));
					redirect('MKTImportLead/index_tool_fb');
				}
			} else {
				$this->session->set_flashdata('error', $this->lang->line('type_invalid'));
				redirect('MKTImportLead/index_tool_fb');
			}
		}

	}

	
}

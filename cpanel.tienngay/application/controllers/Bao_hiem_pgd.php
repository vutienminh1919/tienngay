<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
class Bao_hiem_pgd extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->api = new Api();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model("time_model");
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


    public function doUpdateStatusbao_hiem()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$status = ($status=='true') ? 'active' : 'deactive';
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_bao_hiem_selected_deletion')
			];
			echo json_encode($response);
			return;
		}
			if (empty($status)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_bao_hiem_selected_deletion')
			];
			echo json_encode($response);
			return;
		}
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		$data = array(
			"status" => $status,
			"updated_at" => $createdAt,
			"updated_by" => $this->userInfo['email'],
			"id" => $id
		);
		$return = $this->api->apiPost($this->userInfo['token'], "bao_hiem/update_bao_hiem", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_bao_hiem')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('bao_hiem_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}
	public function importBaohiem() {
		if(empty($_FILES['upload_file']['name'])){
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('not_selected_file_import')
			];
			echo json_encode($response);
			return;
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
			// 	//var_dump($sheetData[0]); die;
			// 	if(count($sheetData[0]) != 7){
			// 		$this->session->set_flashdata('error', "Bạn nhập sai định dạng file");
			// 		$response = [
			// 	'res' => false,
			// 	'status' => "400",
			// 	'message' => 'Bạn nhập sai định dạng file'
			// ];
			// echo json_encode($response);
			// return;
			// 	}
				
				
				foreach($sheetData as $key => $value){
					if($key >= 1 ){
						if(!empty($value[1]) && !empty($value[5]) && !empty($value[3]) && !empty($value[4])  && !empty($value[2]))
						{
						$data = [
							'email_nv' =>  $value[1],
							'ngay_ban' => strtotime($value[2]),
							'loai_bao_hiem' =>$value[3],
							'ten_khach_hang' => $value[4],
							'so_tien' => $value[5] ,
							'ghi_chu' => $value[6] 
							

						];
						// call api insert db
						$return = $this->api->apiPost($this->user['token'], "bao_hiem_pgd/import_bao_hiem", $data);
					}else{

					$response = [
						'res' => false,
						'status' => "400",
						'message' => 'CỘT '.$key.' thiếu thông tin.'
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
					echo json_encode($response);
					return;
		  }
		} 
	}
	public function doUpdatebao_hiem()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		$title_vi = !empty($_POST['title_vi']) ? $_POST['title_vi'] : "";
		$content_vi = !empty($_POST['content_vi']) ? $_POST['content_vi'] : "";
		$title_en = !empty($_POST['title_en']) ? $_POST['title_en'] : "";
		$content_en = !empty($_POST['content_en']) ? $_POST['content_en'] : "";
		$type = !empty($_POST['type_bao_hiem']) ? $_POST['type_bao_hiem'] : "";
		$status = !empty($_POST['status']) ? $_POST['status'] : "";
	
		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		if (empty($title_vi)) {
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('bao_hiem_title_empty')
			];
			echo json_encode($response);
			return;
		}
		
		if (empty($content_vi)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('bao_hiem_content_empty')
			];
			echo json_encode($response);
			return;
		}
		$data = array(
			"title_vi" => $title_vi,
			"link" => slugify($title_vi),
			"content_vi" => $content_vi,
			"title_en" => $title_en,
			"content_en" => $content_en,
			"type_bao_hiem" => $type,
			"status" => $status,
			"updated_at" => $updateAt,
			"updated_by" => $this->userInfo['email'],
			"id"=>$id

		);
		$return = $this->api->apiPost($this->userInfo['token'], "bao_hiem/update_bao_hiem", $data);
      // die;
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successful_bao_hiem_update')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Failed_bao_hiem_update'),
				'data'=>$image
			];
			echo json_encode($response);
			return;
		}
	}

	public function update()
	{
		$data = $this->input->post();
		$data['field'] = $this->security->xss_clean($data['field']);
		$data['value'] = $this->security->xss_clean($data['value']);
		$data['id'] = $this->security->xss_clean($data['id']);

		$condition = array(
			'id' => $data['id'],
			$data['field'] => $data['value'],
			"updated_by" => $this->user['email']
			

		);
		
		$return = $this->api->apiPost($this->user['token'], "bao_hiem/update_bao_hiem", $condition);
		$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
	}

	// public function listbao_hiem()
	// {
	// 	$this->data["pageName"] = $this->lang->line('bao_hiem_manager');
	// 	$data = array(// "type_login" => 1
	// 	);
	// 	$bao_hiemData = $this->api->apiPost($this->userInfo['token'], "bao_hiem/get_all", $data);
	// 	if (!empty($bao_hiemData->status) && $bao_hiemData->status == 200) {
	// 		$this->data['bao_hiemData'] = $bao_hiemData->data;
	// 	} else {
	// 		$this->data['bao_hiemData'] = array();
	// 	}
	// 	$this->data['template'] = 'page/bao_hiem/list_bao_hiem';
	// 	$this->load->view('template', isset($this->data) ? $this->data : NULL);
	// }
   public function listBaohiem()
	{
		

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$config = $this->config->item('pagination');
        $config['per_page'] = 30;
		$config['uri_segment'] = $uriSegment;
		$data = array(
				
				"per_page" => $config['per_page'],
				"uriSegment" => $config['uri_segment']
			);
		if(strtotime($start) > strtotime($end)){
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('bao_hiem_pgd/listBaohiem'));
		}

		if(!empty($_GET['fdate']) && !empty($_GET['tdate'])){

			$data['start'] = $start;
			$data['end'] = $end;

		}
         $config['enable_query_strings'] = true;

		$config['page_query_string'] = true;
		$config['base_url'] = base_url('bao_hiem_pgd/listBaohiem');
		$this->data["pageName"] = 'Quản lý bảo hiểm';
		$baohiemData = $this->api->apiPost($this->userInfo['token'], "bao_hiem_pgd/get_all", $data);
		if (!empty($baohiemData->status) && $baohiemData->status == 200) {
			$this->data['baohiemData'] = $baohiemData->data;
			$config['total_rows'] = $baohiemData->total;
		} else {
			$this->data['baohiemData'] = array();
			$config['total_rows'] = 0;
		}
          $this->pagination->initialize($config);
       $this->data['result_count']= "Hiển thị ".$config['total_rows']." Kết quả";
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/bao_hiem_pgd/list_baohiem';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
	public function doAddKpi()
	{
		 $start = !empty($_POST['fdate_export']) ? $_POST['fdate_export'] : "";

		
		
		if (empty($start)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' =>'Bạn cần chọn tháng bao_hiem'
			];
			echo json_encode($response);
			return;
		}
		
		
		$data = array(
			"start" => $start
		

		);
       
		$return = $this->api->apiPost($this->userInfo['token'], "bao_hiem/create_bao_hiem", $data);
		
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('create_bao_hiem_success')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('create_bao_hiem_failed')
			];
			echo json_encode($response);
			return;
		}
	}

	public function createbao_hiem()
	{
		$this->data["pageName"] = $this->lang->line('create_bao_hiem');
		$this->data['template'] = 'page/bao_hiem/add_bao_hiem';
		//get province
		$data = array(// "type_login" => 1
		);
		
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function get_district_by_province()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";

		$data = array(
			// "type_login" => 1,
			"id" => $id
		);

		$districtData = $this->api->apiPost($this->userInfo['token'], "province/get_district_by_province", $data);
		if (!empty($districtData->status) && $districtData->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $districtData->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('no_depreciation_configured')
			];
			echo json_encode($response);
			return;
		}

	}

	public function get_ward_by_district()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		$data = array(
			// "type_login" => 1,
			"id" => $id
		);
		$wardData = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", $data);
		if (!empty($wardData->status) && $wardData->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $wardData->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('no_depreciation_configured')
			];
			echo json_encode($response);
			return;
		}

	}
}


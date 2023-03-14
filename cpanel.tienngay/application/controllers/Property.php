<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Property extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("main_property_model");
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model("time_model");
		$this->config->load('config');
		$this->load->library('pagination');
		$this->load->helper('location_helper');
		$this->load->helper('lead_helper');
		$this->load->library('session');
		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
		$this->spreadsheet = new Spreadsheet();
		$this->sheet = $this->spreadsheet->getActiveSheet();
	}

	public function index()
	{
		$data['tab'] = !empty($_GET['tab']) ? $_GET['tab'] : 'tai-san';
		$data['property'] = !empty($_GET['property']) ? $_GET['property'] : 'XM';
		$hang_xe_khau_hao = !empty($_GET['hang_xe_khau_hao']) ? $_GET['hang_xe_khau_hao'] : '';
		$phan_khuc_khau_hao = !empty($_GET['phan_khuc_khau_hao']) ? $_GET['phan_khuc_khau_hao'] : '';
		$phan_khuc_tai_san = !empty($_GET['phan_khuc_tai_san']) ? $_GET['phan_khuc_tai_san'] : '';
		$loai_xe_tai_san = !empty($_GET['loai_xe_tai_san']) ? $_GET['loai_xe_tai_san'] : '';
		$nam_san_xuat_tai_san = !empty($_GET['nam_san_xuat_tai_san']) ? $_GET['nam_san_xuat_tai_san'] : '';
		$hang_xe_tai_san = !empty($_GET['hang_xe_tai_san']) ? $_GET['hang_xe_tai_san'] : '';
		$model_tai_san = !empty($_GET['model_tai_san']) ? $_GET['model_tai_san'] : '';
		if (!empty($hang_xe_khau_hao)) {
			$data['hang_xe_khau_hao'] = $hang_xe_khau_hao;
		}
		if (!empty($phan_khuc_khau_hao)) {
			$data['phan_khuc_khau_hao'] = $phan_khuc_khau_hao;
		}
		if (!empty($phan_khuc_tai_san)) {
			$data['phan_khuc_tai_san'] = $phan_khuc_tai_san;
		}
		if (!empty($loai_xe_tai_san)) {
			$data['loai_xe_tai_san'] = $loai_xe_tai_san;
		}
		if (!empty($nam_san_xuat_tai_san)) {
			$data['nam_san_xuat_tai_san'] = $nam_san_xuat_tai_san;
		}
		if (!empty($hang_xe_tai_san)) {
			$data['hang_xe_tai_san'] = $hang_xe_tai_san;
		}
		if (!empty($model_tai_san)) {
			$data['model_tai_san'] = $model_tai_san;
		}

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');

		if ($data['tab'] == 'khau-hao') {
			$main_depreciation = $this->api->apiPost($this->user['token'], "property_v2/get_main_depreciation", ['code' => $data['property']]);
			$this->data['main_depreciation'] = $main_depreciation->data;
			$config['base_url'] = base_url('property?tab=' . $data['tab'] . '&property=' . $data['property'] . '&hang_xe_khau_hao=' . $hang_xe_khau_hao . '&phan_khuc_khau_hao=' . $phan_khuc_khau_hao);
		} elseif ($data['tab'] == 'tai-san') {
			$main_property = $this->api->apiPost($this->user['token'], "property_v2/get_main_property", ['code' => $data['property']]);
			$this->data['main_property'] = $main_property->data;
			$config['base_url'] = base_url('property?tab=' . $data['tab'] . '&property=' . $data['property']
				. '&phan_khuc_tai_san=' . $phan_khuc_tai_san . '&loai_xe_tai_san=' . $loai_xe_tai_san . '&nam_san_xuat_tai_san=' . $nam_san_xuat_tai_san
				. '&hang_xe_tai_san=' . $hang_xe_tai_san . '&model_tai_san=' . $model_tai_san);
		} elseif ($data['tab'] == 'phe-duyet-tai-san') {
			$main_property = $this->api->apiPost($this->user['token'], "property_v3/get_main_property", ['code' => $data['property']]);
			$this->data['main_property'] = $main_property->data;
			$config['base_url'] = base_url('property?tab=' . $data['tab'] . '&property=' . $data['property']
				. '&phan_khuc_tai_san=' . $phan_khuc_tai_san . '&loai_xe_tai_san=' . $loai_xe_tai_san . '&nam_san_xuat_tai_san=' . $nam_san_xuat_tai_san
				. '&hang_xe_tai_san=' . $hang_xe_tai_san . '&model_tai_san=' . $model_tai_san);
		} else if ($data['tab'] == 'phe-duyet-khau-hao') {
			$main_depreciation = $this->api->apiPost($this->user['token'], "property_v3/get_main_depreciation", ['code' => $data['property']]);
			$this->data['main_depreciation'] = $main_depreciation->data;
			$config['base_url'] = base_url('property?tab=' . $data['tab'] . '&property=' . $data['property'] . '&hang_xe_khau_hao=' . $hang_xe_khau_hao . '&phan_khuc_khau_hao=' . $phan_khuc_khau_hao);
		} elseif($data['tab'] == 'lich-su'){
			$config['base_url'] = base_url('property?tab=' . $data['tab'] . '&property=' . $data['property']
				. '&phan_khuc_tai_san=' . $phan_khuc_tai_san . '&loai_xe_tai_san=' . $loai_xe_tai_san . '&nam_san_xuat_tai_san=' . $nam_san_xuat_tai_san
				. '&hang_xe_tai_san=' . $hang_xe_tai_san . '&model_tai_san=' . $model_tai_san);
		}

		else {
			$config['base_url'] = base_url('property?tab=' . $data['tab'] . '&property=' . $data['property']);
		}
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 20;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];
		if ($data['tab'] == 'khau-hao' || $data['tab'] == 'tai-san') {
			$result = $this->api->apiPost($this->user['token'], "property_v2/overview", $data);
			if (isset($result->status) && $result->status == 200) {
				$config['total_rows'] = $result->total;
				$this->data['propertys'] = $result->data;
				$this->data['total_rows'] = $result->total;
				$this->data['total_pending_approve'] = $result->total_pending;
			} else {
				$this->data['propertys'] = array();
			}
		} elseif ($data['tab'] == 'phe-duyet-tai-san' || $data['tab'] == 'phe-duyet-khau-hao') {
			$result = $this->api->apiPost($this->user['token'], "property_v3/overview", $data);
			if (isset($result->status) && $result->status == 200) {
				$config['total_rows'] = $result->total;
				$this->data['propertys_approve'] = $result->data;
				$this->data['total_rows_approve'] = $result->total;
				$this->data['total_pending_approve'] = $result->total_pending;
				$this->data['total_pending_approve_khau_hao'] = $result->total_pending_khau_hao;
			} else {
				$this->data['propertys_approve'] = array();
			}
		} elseif ($data['tab'] == 'lich-su') {
			$result = $this->api->apiPost($this->user['token'], "property_v3/show_history_property", $data);
			if (isset($result->status) && $result->status == 200) {
				$config['total_rows'] = $result->total;
				$this->data['log'] = $result->data;
				$this->data['total_rows_history'] = $result->total;
			} else {
				$this->data['log'] = array();
			}
		}

		$count_property = $this->api->apiPost($this->user['token'], "property_v3/get_count_total_pending_property", $data);
		if (!empty($count_property->status) && $count_property->status == 200) {
			$this->data['total_pending_property'] = $count_property->data;
		} else {
			$this->data['total_pending_property'] = 0;
		}

		$count_khau_hao = $this->api->apiPost($this->user['token'], "property_v3/get_count_total_pending_khau_hao", $data);
		if (!empty($count_khau_hao->status) && $count_khau_hao->status == 200) {
			$this->data['total_pending_khau_hao'] = $count_khau_hao->data;
		} else {
			$this->data['total_pending_khau_hao'] = 0;
		}

		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}


		$this->data['user'] = $this->userInfo['email'];
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/property/new/view';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function detail_property()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : '';
		$type = !empty($_GET['type']) ? $_GET['type'] : 'XM';
		$result = $this->api->apiPost($this->user['token'], "property_v2/detail_property", ['id' => $id, 'type_property' => $type]);
		if (isset($result->status) && $result->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", 'data' => $result->data, "msg" => $result->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => 'faild')));
			return;

		}
	}

	public function detail_property_approve()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : '';
		$type = !empty($_GET['type']) ? $_GET['type'] : 'XM';
		$result = $this->api->apiPost($this->user['token'], "property_v3/detail_property", ['id' => $id, 'type_property' => $type]);
		if (isset($result->status) && $result->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", 'data' => $result->data, "msg" => $result->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => 'faild')));
			return;

		}
	}

	private function pushJson($code, $data)
	{
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}

	public function get_property_by_main()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : '';
		$result = $this->api->apiPost($this->user['token'], "property_v2/get_property_by_main", ['id' => $id]);
		if (isset($result->status) && $result->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", 'data' => $result->data, "msg" => $result->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400")));
			return;
		}
	}

	public function get_approve_property_by_main()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : '';
		$result = $this->api->apiPost($this->user['token'], "property_v3/get_approve_property_by_main", ['id' => $id]);
		if (isset($result->status) && $result->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", 'data' => $result->data, "msg" => $result->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400")));
			return;
		}
	}

	public function import_khau_hao_xm()
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
				if (stripos("Loại xe", trim($sheetData[0][0])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô A định dạng bắt buộc là Loại xe"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Hãng xe", trim($sheetData[0][1])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô B định dạng bắt buộc là Hãng xe"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Số năm sử dụng", trim($sheetData[0][2])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô C định dạng bắt buộc là Số năm sử dụng"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Phân khúc", trim($sheetData[0][3])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô D định dạng bắt buộc là Phân khúc"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Giảm trừ tiêu chuẩn", trim($sheetData[0][4])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô E định dạng bắt buộc là Giảm trừ tiêu chuẩn"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Giảm trừ biển tỉnh", trim($sheetData[0][5])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô F định dạng bắt buộc là Giảm trừ biển tỉnh"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Giảm trừ xe dịch vụ", trim($sheetData[0][6])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô G định dạng bắt buộc là Giảm trừ xe dịch vụ"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Giảm trừ xe công ty", trim($sheetData[0][7])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô H định dạng bắt buộc là Giảm trừ xe công ty"
					];
					echo json_encode($response);
					return;
				}
				$count = 0;
				foreach ($sheetData as $key => $value) {
					if ($key >= 1) {
						if ($value["0"] == '') continue;
						$data = array(
							"loai_xe" => !empty($value["0"]) ? (trim($value["0"])) : "",
							"hang_xe" => !empty($value["1"]) ? (trim($value["1"])) : "",
							"year" => !empty(trim($value["2"])) ? (trim($value["2"])) : "",
							"phan_khuc" => !empty(trim($value["3"])) ? (trim($value["3"])) : "",
							"giam_tru_tieu_chuan" => !empty(trim($value["4"])) ? (trim($value["4"])) : "",
							"giam_tru_bien_tinh" => !empty(trim($value["5"])) ? (trim($value["5"])) : "",
							"giam_tru_dich_vu" => !empty(trim($value["6"])) ? (trim($value["6"])) : "",
							"giam_tru_cong_ty" => !empty(trim($value["7"])) ? (trim($value["7"])) : "",
							'url' => base_url('property?tab=phe-duyet-khau-hao&property=XM')
						);
						$return = $this->api->apiPost($this->user['token'], "property_v3/import_khau_hao_xe_may", $data);
						if(!empty($return->status) && $return->status == 200){
							$count++;
						}
					}
				}

				$dataEmail = [
					'url' => base_url('property?tab=phe-duyet-tai-san&property=OTO'),
					'tab' => 'khấu hao',
					'property' => 'xe máy',
					'count' => $count
				];
				$return = $this->api->apiPost($this->user['token'], "property_v3/send_email_import_property", $dataEmail);
				$response = [
					'res' => true,
					'status' => "200",
					'message' => $this->lang->line('import_success'),
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

	public function import_khau_hao_oto()
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

				if (stripos("Hãng xe", trim($sheetData[0][0])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô A định dạng bắt buộc là Hãng xe"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Số năm sử dụng", trim($sheetData[0][1])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô B định dạng bắt buộc là Số năm sử dụng"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Phân khúc", trim($sheetData[0][2])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô C định dạng bắt buộc là Phân khúc"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Giảm trừ tiêu chuẩn", trim($sheetData[0][3])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô D định dạng bắt buộc là Giảm trừ tiêu chuẩn"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Giảm trừ biển tỉnh", trim($sheetData[0][4])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô E định dạng bắt buộc là Giảm trừ biển tỉnh"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Giảm trừ xe vận tải", trim($sheetData[0][5])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô F định dạng bắt buộc là Giảm trừ xe vận tải"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Giảm trừ xe công ty", trim($sheetData[0][6])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô G định dạng bắt buộc là Giảm trừ xe công ty"
					];
					echo json_encode($response);
					return;
				}
				$count = 0;
				foreach ($sheetData as $key => $value) {
					if ($key >= 1) {
						if ($value["0"] == '') continue;
						$data = array(
							"hang_xe" => !empty($value["0"]) ? (trim($value["0"])) : "",
							"year" => !empty($value["1"]) ? (trim($value["1"])) : "",
							"phan_khuc" => !empty(trim($value["2"])) ? (trim($value["2"])) : "",
							"giam_tru_tieu_chuan" => !empty(trim($value["3"])) ? (trim($value["3"])) : "",
							"giam_tru_bien_tinh" => !empty(trim($value["4"])) ? (trim($value["4"])) : "",
							"giam_tru_xe_van_tai" => !empty(trim($value["5"])) ? (trim($value["5"])) : "",
							"giam_tru_xe_cong_ty" => !empty(trim($value["6"])) ? (trim($value["6"])) : "",
							'url' => base_url('property?tab=phe-duyet-khau-hao&property=OTO')
						);
						$return = $this->api->apiPost($this->user['token'], "property_v3/import_khau_hao_oto", $data);
						if(!empty($return->status) && $return->status == 200){
							$count++;
						}
					}
				}
				$dataEmail = [
					'url' => base_url('property?tab=phe-duyet-tai-san&property=OTO'),
					'tab' => 'khấu hao',
					'property' => 'ô tô',
					'count' => $count
				];
				$return = $this->api->apiPost($this->user['token'], "property_v3/send_email_import_property", $dataEmail);
				$response = [
					'res' => true,
					'status' => "200",
					'message' => $this->lang->line('import_success'),
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

	public function import_tai_san_xe_may()
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
				if (stripos("Năm sản xuất", trim($sheetData[0][0])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô A định dạng bắt buộc là Năm sản xuất"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Loại xe", trim($sheetData[0][1])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô B định dạng bắt buộc là Loại xe"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Phân khúc", trim($sheetData[0][2])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô C định dạng bắt buộc là Phân khúc"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Hãng xe", trim($sheetData[0][3])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô D định dạng bắt buộc là Hãng xe"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Model", trim($sheetData[0][4])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô E định dạng bắt buộc là Model"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Giá đề xuất", trim($sheetData[0][5])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô F định dạng bắt buộc là Giá đề xuất"
					];
					echo json_encode($response);
					return;
				}
				$count = 0;
				foreach ($sheetData as $key => $value) {
					if ($key >= 1) {
						if ($value["0"] == '') continue;
						$data = array(
							"year" => !empty($value["0"]) ? (trim($value["0"])) : "",
							"loai_xe" => !empty($value["1"]) ? (trim($value["1"])) : "",
							"phan_khuc" => !empty(trim($value["2"])) ? (trim($value["2"])) : "",
							"hang_xe" => !empty(trim($value["3"])) ? (trim($value["3"])) : "",
							"model" => !empty(trim($value["4"])) ? (trim($value["4"])) : "",
							"price" => !empty(trim($value["5"])) ? (trim($value["5"])) : "",

						);
						$return = $this->api->apiPost($this->user['token'], "property_v3/import_tai_san_xe_may", $data);
						if(!empty($return->status) && $return->status == 200){
							$count++;
						}
					}
				}
				$dataEmail = [
					'url' => base_url('property?tab=phe-duyet-tai-san&property=XM'),
					'tab' => 'tài sản',
					'property' => 'xe máy',
					'count' => $count
				];
				$return = $this->api->apiPost($this->user['token'], "property_v3/send_email_import_property", $dataEmail);
				$response = [
					'res' => true,
					'status' => "200",
					'message' => $this->lang->line('import_success'),
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

	public function import_tai_san_oto()
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
				if (stripos("Năm sản xuất", trim($sheetData[0][0])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô A định dạng bắt buộc là Năm sản xuất"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Loại xe", trim($sheetData[0][1])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô B định dạng bắt buộc là Loại xe"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Hãng xe", trim($sheetData[0][2])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô C định dạng bắt buộc là Hãng xe"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Xuất xứ", trim($sheetData[0][3])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô D định dạng bắt buộc là Xuất xứ"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Bản Xăng/Dầu", trim($sheetData[0][4])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô E định dạng bắt buộc là Bản Xăng/Dầu"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Phân khúc", trim($sheetData[0][5])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô F định dạng bắt buộc là Phân khúc"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Model", trim($sheetData[0][6])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô G định dạng bắt buộc là Model"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Giá đề xuất", trim($sheetData[0][7])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô H định dạng bắt buộc là Giá đề xuất"
					];
					echo json_encode($response);
					return;
				}
				$count = 0;
				foreach ($sheetData as $key => $value) {
					if ($key >= 1) {
						if ($value["0"] == '') continue;
						$data = array(
							"year" => !empty($value["0"]) ? (trim($value["0"])) : "",
							"loai_xe" => !empty($value["1"]) ? (trim($value["1"])) : "",
							"hang_xe" => !empty(trim($value["2"])) ? (trim($value["2"])) : "",
							"xuat_xu" => !empty(trim($value["3"])) ? (trim($value["3"])) : "",
							"ban_xang_dau" => !empty(trim($value["4"])) ? (trim($value["4"])) : "",
							"phan_khuc" => !empty(trim($value["5"])) ? (trim($value["5"])) : "",
							"model" => !empty(trim($value["6"])) ? (trim($value["6"])) : "",
							"price" => !empty(trim($value["7"])) ? (trim($value["7"])) : "",

						);
						$return = $this->api->apiPost($this->user['token'], "property_v3/import_tai_san_oto", $data);
						if(!empty($return->status) && $return->status == 200) {
							$count++;
						}
					}
				}
				$dataEmail = [
					'url' => base_url('property?tab=phe-duyet-tai-san&property=OTO'),
					'tab' => 'tài sản',
					'property' => 'ô tô',
					'count' => $count
				];
				$return = $this->api->apiPost($this->user['token'], "property_v3/send_email_import_property", $dataEmail);
				$response = [
					'res' => true,
					'status' => "200",
					'message' => $this->lang->line('import_success'),
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

	public function delete_property()
	{
		$tai_san = !empty($_POST['tai_san']) ? $_POST['tai_san'] : '';
		$property = !empty($_POST['property']) ? $_POST['property'] : '';
		if (!empty($tai_san)) {
			$data['id'] = $tai_san;
		}
		if (!empty($property)) {
			$data['property'] = $property;
		}
		$return = $this->api->apiPost($this->user['token'], "property_v2/delete_property", $data);
		if (isset($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $return->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => $return->message)));
			return;
		}
	}

	public function cancel_approve_property()
	{
		$tai_san = !empty($_POST['tai_san']) ? $_POST['tai_san'] : '';
		$property = !empty($_POST['property']) ? $_POST['property'] : '';
		if (!empty($tai_san)) {
			$data['id'] = $tai_san;
		}
		if (!empty($property)) {
			$data['property'] = $property;
		}
		$return = $this->api->apiPost($this->user['token'], "property_v3/cancel_approve_property", $data);
		if (isset($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $return->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => $return->message)));
			return;
		}
	}

	public function delete_khau_hao()
	{
		$khau_hao = !empty($_POST['khau_hao']) ? $_POST['khau_hao'] : '';
		$property = !empty($_POST['property']) ? $_POST['property'] : '';
		if (!empty($khau_hao)) {
			$data['id'] = $khau_hao;
		}
		if (!empty($property)) {
			$data['property'] = $property;
		}
		$return = $this->api->apiPost($this->user['token'], "property_v2/delete_khau_hao", $data);
		if (isset($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $return->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => $return->message)));
			return;
		}
	}

	public function cancel_phe_duyet_khau_hao()
	{
		$khau_hao = !empty($_POST['khau_hao']) ? $_POST['khau_hao'] : '';
		$property = !empty($_POST['property']) ? $_POST['property'] : '';

		if (!empty($khau_hao)) {
			$data['id'] = $khau_hao;
		}
		if (!empty($property)) {
			$data['property'] = $property;
		}
		$return = $this->api->apiPost($this->user['token'], "property_v3/cancel_approve_khau_hao", $data);
		if (isset($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $return->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => $return->message)));
			return;
		}
	}


	public function change_status_phe_duyet_tai_san()
	{
		$tai_san_str = !empty($_POST['tai_san']) ? $_POST['tai_san'] : '';
		$tai_san = explode(",", $tai_san_str);
		$property = !empty($_POST['property']) ? $_POST['property'] : '';
		//		var_dump($tai_san);
		//		die();
		if (!empty($tai_san)) {
			$data['id'] = $tai_san;
		}
		if (!empty($property)) {
			$data['property'] = $property;
		}
		$data['url'] = base_url('property/valuation_property');
		$return = $this->api->apiPost($this->user['token'], "property_v3/approve_property", $data);
		if (isset($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $return->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => $return->message)));
			return;
		}
	}

	public function change_status_phe_duyet_khau_hao()
	{
		$khau_hao_str = !empty($_POST['khau_hao']) ? $_POST['khau_hao'] : '';
		$khau_hao = explode(",", $khau_hao_str);
		$property = !empty($_POST['property']) ? $_POST['property'] : '';
		if (!empty($khau_hao)) {
			$data['id'] = $khau_hao;
		}
		if (!empty($property)) {
			$data['property'] = $property;
		}
		$return = $this->api->apiPost($this->user['token'], "property_v3/approve_depreciation", $data);
//		var_dump($return);
//		die();
		if (isset($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $return->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => $return->message)));
			return;
		}
	}

	public function update_price_property()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : '';
		$price = !empty($data['price']) ? $data['price'] : '';


		if (!empty($id)) {
			$data['id'] = $id;
		}
		if (!empty($price)) {
			$data['price'] = $price;
		}
		$return = $this->api->apiPost($this->user['token'], "property_v2/update_price_property", $data);
		if (isset($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $return->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => $return->message)));
			return;
		}

	}

	public function request_valuation_property()
	{
		$this->data['template'] = 'page/property/new/request';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function create_request_valuation_property()
	{
		$data = $this->input->post();
		$loai_xe_may = !empty($data['type_property_xm']) ? $data['type_property_xm'] : '';
		$loai_xe_oto = !empty($data['type_property_oto']) ? $data['type_property_oto'] : '';
		$hang_xe = !empty($data['brand_property']) ? $data['brand_property'] : '';
		$year = !empty($data['year_property']) ? $data['year_property'] : '';
		$phan_khuc_oto = !empty($data['phan_khuc_oto']) ? $data['phan_khuc_oto'] : '';
		$model = !empty($data['model_property']) ? $data['model_property'] : '';
		$xuat_xu = !empty($data['made_in']) ? $data['made_in'] : '';
		$ban_xang_dau = !empty($data['gas_or_oil']) ? $data['gas_or_oil'] : '';
		$type_xm_oto = !empty($data['type_xm_oto']) ? $data['type_xm_oto'] : '';
		$description = !empty($data['description']) ? $data['description'] : '';
		$price_suggest = !empty($data['price_suggest']) ? $data['price_suggest'] : '';
		$path_tai_san = !empty($data['img_tai_san']) ? json_decode($data['img_tai_san']) : '';
		$path_giay_to = !empty($data['img_giay_to']) ? json_decode($data['img_giay_to']) : '';
		$path_dang_kiem = !empty($data['img_dang_kiem']) ? json_decode($data['img_dang_kiem']) : '';
		$url = base_url('property/valuation_property');
		$price_suggest_str = $price_str = str_replace( ',', '', $price_suggest );
		$datainsert = [
			'type_xm_oto' => $type_xm_oto,
			'loai_xe_may' => $loai_xe_may,
			'loai_xe_oto' => $loai_xe_oto,
			'hang_xe' => $hang_xe,
			'year_property' => $year,
			'phan_khuc_oto' => $phan_khuc_oto,
			'name' => $model,
			'xuat_xu' => $xuat_xu,
			'ban_xang_dau' => $ban_xang_dau,
			'image_tai_san' => $path_tai_san,
			'image_dang_ky' => $path_giay_to,
			'image_dang_kiem' => $path_dang_kiem,
			'description' => $description,
			'price_suggest' => $price_suggest_str,
			'url' => $url
		];
		$return = $this->api->apiPost($this->user['token'], "property_v3/yeu_cau_dinh_gia_tai_san", $datainsert);
		if (isset($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $return->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => $return->message)));
			return;
		}

	}

	public function valuation_property()
	{
		$data = [];
		$type = !empty($_GET['type']) ? $_GET['type'] : '';
		$year = !empty($_GET['nam_san_xuat']) ? $_GET['nam_san_xuat'] : '';
		$hang_xe = !empty($_GET['hang_xe']) ? $_GET['hang_xe'] : '';
		$ten_tai_san = !empty($_GET['ten_tai_san']) ? $_GET['ten_tai_san'] : '';
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$user = $this->userInfo['email'];
		$data['user'] = $user;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 30;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$data['type_xm_oto'] = $type;
		$data['year'] = $year;
		$data['hang_xe'] = $hang_xe;
		$data['ten_tai_san'] = $ten_tai_san;
		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];
		$config['base_url'] = base_url('property/valuation_property?type=' . $type . '&nam_san_xuat=' . $year . '&hang_xe=' . $hang_xe . '&ten_tai_san=' . $hang_xe);
		$result = $this->api->apiPost($this->userInfo['token'], "property_v3/show_pending_valuation_property", $data);
		if (isset($result->status) && $result->status == 200) {
			$config['total_rows'] = $result->total;
			$this->data['total_rows'] = $result->total;
			$this->data['property_valuation'] = $result->data;
		}
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/property/new/valuation';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function detail_valuation_property()
	{
		$user = $this->userInfo['email'];
		$id = !empty($_GET['id']) ? $_GET['id'] : '';
		$result = $this->api->apiPost($this->userInfo['token'], "property_v3/detail_valuation_property", ["id" => $id]);
		if (isset($result->status) && $result->status == 200) {
			$this->data['user_lead_tham_dinh'] = $result->data->user_lead_tham_dinh;
			$this->data['user'] = $user;
			$this->data['total_rows'] = $result->total;
			$this->data['detail_property_valuation'] = $result->data;
			if ($result->data->price) {
				$this->data['price'] = number_format($result->data->price);
			}
			$img_tai_san = $result->data->image_property;
			$img_dang_ky = $result->data->image_registration;
			$img_dang_kiem = $result->data->image_certificate;
			if (!empty($result->data->image_property)) {
				$arr_img_tai_san = [];
				foreach ($result->data->image_property as $value) {
					array_push($arr_img_tai_san, $value);
				}
			}
			if (!empty($result->data->image_registration)) {
				$arr_img_dang_ky = [];
				foreach ($result->data->image_registration as $value) {
					array_push($arr_img_dang_ky, $value);
				}
			}
			if (!empty($result->data->image_certificate)) {
				$arr_img_dang_kiem = [];
				foreach ($result->data->image_certificate as $value) {
					array_push($arr_img_dang_kiem, $value);
				}
			}
			$this->data['img_tai_san'] = $arr_img_tai_san;
			$this->data['img_dang_ky'] = $arr_img_dang_ky;
			$this->data['img_dang_kiem'] = $arr_img_dang_kiem;
		}
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		$history =  $this->api->apiPost($this->user['token'], "property_v3/log_action", ['id' => $id]);
		if (!empty($history->status) && $history->status == 200) {
			$this->data['history'] = $history->data;
		} else {
			$this->data['history'] = [];
		}
		$this->data['template'] = 'page/property/new/detail_valuation';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function update_price_valuation_property()
	{
		$data = [];
//		$data['type_xm_oto'] = !empty($_POST['type_xm_oto']) ? $_POST['type_xm_oto'] : '';
		$data['id'] = !empty($_POST['id']) ? $_POST['id'] : '';
		$price = !empty($_POST['price']) ? $_POST['price'] : '';
		$data['phan_khuc_xm'] = !empty($_POST['phan_khuc_xm']) ? $_POST['phan_khuc_xm'] : '';
		$price_str = str_replace( ',', '', $price );
		$data['price'] = $price_str;
		$data['url'] = base_url('property?tab=phe-duyet-tai-san');
		$return = $this->api->apiPost($this->user['token'], "property_v3/valuation_property", $data);
		if (isset($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $return->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => $return->message)));
			return;
		}

	}

	public function upload_img_taisan()
	{
		// $data = $this->input->post();
		if ($_FILES['file']['size'] > 20000000) {
			return $this->pushJson('200', json_encode(array(
				'code' => '201',
				'msg' => 'Kích cỡ max là 10MB'
			)));
		}
		$acceptFormat = array("jpeg", "png", "jpg", "mp3", "mp4", "pdf", 'docx', 'doc');
		if (in_array($_FILES['file']['type'], $acceptFormat)) {
			return $this->pushJson('200', json_encode(array(
				'code' => '201',
				'msg' => 'Định dạng không cho phép',
				'type' => $_FILES['file']['type']
			)));
		}

		$serviceUpload = $this->config->item("url_service_upload");
		// $curlFile  = new CURLFile($_FILES["avatar"]["tmp_name"],$_FILES["avatar"]["type"],$_FILES["avatar"]["name"]);
		$cfile = new CURLFile($_FILES['file']["tmp_name"], $_FILES['file']["type"], $_FILES['file']["name"]);
		$post = array('avatar' => $cfile);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $serviceUpload);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		$result1 = json_decode($result);

		$random = sha1(substr(md5(rand()), 0, 8));

		if (empty($result1->path)) {
			return $this->pushJson('200', json_encode(array(
				'code' => '201',
				'msg' => 'File lỗi! Hệ thống không đọc được file (file ảnh bạn mở màn hình chụp lại rồi tạo ảnh mới upload lại)'
			)));
		} else {
			$response = array(
				'code' => 200,
				"msg" => "success",
				'path' => $result1->path,
				'key' => $random,
				'raw_name' => $_FILES['file']['name']
			);
			$push = json_encode($response);
			return $this->pushJson(200, $push);
		}
	}

	public function note_valuation_property()
	{
		$data = [];
		$data['id'] = !empty($_POST['id']) ? $_POST['id'] : '';
		$id = $data['id'];
		$data['note'] = !empty($_POST['note']) ? $_POST['note'] : '';
		$data['url_item'] = base_url('property/detail_valuation_property?id=' . $id);
		$data['url'] = base_url('property/valuation_property');
		$return = $this->api->apiPost($this->user['token'], "property_v3/feedback_note_dinh_gia_tai_san", $data);
		if (isset($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $return->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => $return->message)));
			return;
		}

	}

	public function excel_property()
	{
		$data['tab'] = !empty($_GET['tab']) ? $_GET['tab'] : 'tai-san';
		$data['property'] = !empty($_GET['property']) ? $_GET['property'] : 'XM';
		$hang_xe_khau_hao = !empty($_GET['hang_xe_khau_hao']) ? $_GET['hang_xe_khau_hao'] : '';
		$phan_khuc_khau_hao = !empty($_GET['phan_khuc_khau_hao']) ? $_GET['phan_khuc_khau_hao'] : '';
		$phan_khuc_tai_san = !empty($_GET['phan_khuc_tai_san']) ? $_GET['phan_khuc_tai_san'] : '';
		$loai_xe_tai_san = !empty($_GET['loai_xe_tai_san']) ? $_GET['loai_xe_tai_san'] : '';
		$nam_san_xuat_tai_san = !empty($_GET['nam_san_xuat_tai_san']) ? $_GET['nam_san_xuat_tai_san'] : '';
		$hang_xe_tai_san = !empty($_GET['hang_xe_tai_san']) ? $_GET['hang_xe_tai_san'] : '';
		$model_tai_san = !empty($_GET['model_tai_san']) ? $_GET['model_tai_san'] : '';

		if (!empty($hang_xe_khau_hao)) {
			$data['hang_xe_khau_hao'] = $hang_xe_khau_hao;
		}
		if (!empty($phan_khuc_khau_hao)) {
			$data['phan_khuc_khau_hao'] = $phan_khuc_khau_hao;
		}
		if (!empty($phan_khuc_tai_san)) {
			$data['phan_khuc_tai_san'] = $phan_khuc_tai_san;
		}
		if (!empty($loai_xe_tai_san)) {
			$data['loai_xe_tai_san'] = $loai_xe_tai_san;
		}
		if (!empty($nam_san_xuat_tai_san)) {
			$data['nam_san_xuat_tai_san'] = $nam_san_xuat_tai_san;
		}
		if (!empty($hang_xe_tai_san)) {
			$data['hang_xe_tai_san'] = $hang_xe_tai_san;
		}
		if (!empty($model_tai_san)) {
			$data['model_tai_san'] = $model_tai_san;
		}
		$result = $this->api->apiPost($this->user['token'], "property_v2/excel_property", $data);

		if ($data['property'] == 'XM') {
			if (!empty($result->status) && $result->status == 200) {
				$this->export_list_xm($result->data);
				$this->callLibExcel('data-property-xemay' . time() . '.xlsx');

			} else {
				$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
				redirect(base_url('property'));
			}
		} elseif ($data['property'] == 'OTO') {
			if (!empty($result->status) && $result->status == 200) {
				$this->export_list_oto($result->data);
				$this->callLibExcel('data-property-oto' . time() . '.xlsx');
			} else {
				$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
				redirect(base_url('property'));
			}
		}

	}

	public function export_list_xm($data)
	{
		$this->sheet->setCellValue('A1', 'Năm sản xuất');
		$this->sheet->setCellValue('B1', 'Loại xe');
		$this->sheet->setCellValue('C1', 'Phân khúc');
		$this->sheet->setCellValue('D1', 'Hãng xe');
		$this->sheet->setCellValue('E1', 'Model');
		$this->sheet->setCellValue('F1', 'Tên đầy đủ');
		$this->sheet->setCellValue('G1', 'Giá xe');
		$i = 2;
		foreach ($data as $item) {
			$this->sheet->setCellValue('A' . $i, !empty($item->year_property) ? $item->year_property : '');
			$this->sheet->setCellValue('B' . $i, !empty($item->type_property) ? type_property($item->type_property) : '');
			$this->sheet->setCellValue('C' . $i, !empty($item->phan_khuc) ? $item->phan_khuc : '');
			$this->sheet->setCellValue('D' . $i, !empty($item->main_data) ? $item->main_data : '');
			$this->sheet->setCellValue('E' . $i, !empty($item->name) ? $item->name : "");
			$this->sheet->setCellValue('F' . $i, !empty($item->str_name) ? $item->str_name : '');
			$this->sheet->setCellValue('G' . $i, !empty($item->price) ? number_format($item->price) . ' VND' : '');
			$i++;
		}
	}

	public function export_list_oto($data)
	{
		$this->sheet->setCellValue('A1', 'Tài sản');
		$this->sheet->setCellValue('B1', 'Năm sản xuất');
		$this->sheet->setCellValue('C1', 'Dòng xe');
		$this->sheet->setCellValue('D1', 'Phân khúc');
		$this->sheet->setCellValue('E1', 'Hãng xe');
		$this->sheet->setCellValue('F1', 'Model');
		$this->sheet->setCellValue('G1', 'Xuất xứ');
		$this->sheet->setCellValue('H1', 'Bản xăng/dầu');
		$this->sheet->setCellValue('I1', 'Tên đầy đủ');
		$this->sheet->setCellValue('J1', 'Giá xe');
		$i = 2;
		foreach ($data as $item) {

			$this->sheet->setCellValue('A' . $i, "Ôtô");
			$this->sheet->setCellValue('B' . $i, !empty($item->year_property) ? $item->year_property : '');
			$this->sheet->setCellValue('C' . $i, !empty($item->dong_xe) ? $item->dong_xe : '');
			$this->sheet->setCellValue('D' . $i, !empty($item->phan_khuc) ? $item->phan_khuc : "");
			$this->sheet->setCellValue('E' . $i, !empty($item->main_data) ? $item->main_data : '');
			$this->sheet->setCellValue('F' . $i, !empty($item->name) ? $item->name : '');
			$this->sheet->setCellValue('G' . $i, !empty($item->xuat_xu) ? $item->xuat_xu  : '');
			$this->sheet->setCellValue('H' . $i, !empty($item->ban_xang_dau) ? $item->ban_xang_dau : '');
			$this->sheet->setCellValue('I' . $i, !empty($item->str_name) ? $item->str_name : '');
			$this->sheet->setCellValue('J' . $i, !empty($item->price) ? number_format($item->price) . ' VND' : '');
			$i++;
		}
	}

	/**
	 * Xuất excel dữ liệu blacklist giấy tờ giả
	 */
	public function exportBlacklistCavet()
	{
		$dataGet = $this->input->get();
		$from_date = !empty($dataGet['from_date']) ? $dataGet['from_date'] : '';
		$to_date = !empty($dataGet['to_date']) ? $dataGet['to_date'] : '';
		$hang_xe = !empty($dataGet['hang_xe']) ? $dataGet['hang_xe'] : '';
		$bien_so_xe_blacklist = !empty($dataGet['bien_so_xe_blacklist']) ? $dataGet['bien_so_xe_blacklist'] : '';
		$so_khung_blacklist = !empty($dataGet['so_khung_blacklist']) ? $dataGet['so_khung_blacklist'] : '';
		$so_may_blacklist = !empty($dataGet['so_may_blacklist']) ? $dataGet['so_may_blacklist'] : '';
		$phone_blacklist = !empty($dataGet['phone_blacklist']) ? $dataGet['phone_blacklist'] : '';
		$identify_passport_blacklist = !empty($dataGet['identify_passport_blacklist']) ? $dataGet['identify_passport_blacklist'] : '';
		$condition = array();
		if (!empty($from_date) && !empty($to_date)) {
			if (strtotime($from_date) > strtotime($to_date)) {
				echo "Thời gian bắt đầu lọc không được lớn hơn thời gian kết thúc";
			}
			$condition = [
				'from_date' => $from_date,
				'to_date' => $to_date
			];
		}
		if (!empty($hang_xe)) {
			$dataSendApiPropertyInfo = [
				'property_id' => $hang_xe
			];
			$property_infor = $this->api->apiPost($this->userInfo['token'], 'Property/get_property_info_by_id', $dataSendApiPropertyInfo);
			if (!empty($property_infor->name)) {
				$hang_xe_filter = $property_infor->name;
			} else {
				$hang_xe_filter = '';
			}
			$condition['hang_xe'] = $hang_xe_filter;
		}
		if (!empty($bien_so_xe_blacklist)) {
			$condition['bien_so_xe_blacklist'] = $bien_so_xe_blacklist;
		}
		if (!empty($so_khung_blacklist)) {
			$condition['so_khung_blacklist'] = $so_khung_blacklist;
		}
		if (!empty($so_may_blacklist)) {
			$condition['so_may_blacklist'] = $so_may_blacklist;
		}
		if (!empty($phone_blacklist)) {
			$condition['phone_blacklist'] = $phone_blacklist;
		}
		if (!empty($identify_passport_blacklist)) {
			$condition['identify_passport_blacklist'] = $identify_passport_blacklist;
		}
		$condition['per_page'] = 10000;
		$response = $this->api->apiPost($this->userInfo['token'], 'property_blacklist/blacklist', $condition);
		if (isset($response->status) && $response->status == 200) {
			$this->exportDetailBlacklist($response->data);
			$this->callLibExcel('BlackListCavet_' . time() . '.xlsx');
		} else {
			echo "Không có dữ liệu!";
		}
	}

	public function exportDetailBlacklist($blacklistData)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Loại xe');
		$this->sheet->setCellValue('C1', 'Hãng xe');
		$this->sheet->setCellValue('D1', 'Model');
		$this->sheet->setCellValue('E1', 'Tên chủ xe');
		$this->sheet->setCellValue('F1', 'Số điện thoại');
		$this->sheet->setCellValue('G1', 'CMT/CCCD');
		$this->sheet->setCellValue('H1', 'Biển số xe');
		$this->sheet->setCellValue('I1', 'Số khung');
		$this->sheet->setCellValue('J1', 'Số máy');
		$this->sheet->setCellValue('K1', 'Số đăng ký');
		$this->sheet->setCellValue('L1', 'Ngày cấp');
		$this->sheet->setCellValue('M1', 'Nơi cấp');
		$this->sheet->setCellValue('N1', 'Trạng thái');
		$this->sheet->setCellValue('O1', 'Ngày tạo');
		$this->sheet->setCellValue('P1', 'Người tạo');
		$this->sheet->setCellValue('Q1', 'Số đăng kiểm');
		$this->sheet->setCellValue('R1', 'Ngày cấp đăng kiểm');
		$this->sheet->setCellValue('S1', 'Nơi cấp đăng kiểm');
		$i = 2;
		foreach ($blacklistData as $key => $data) {
			$this->sheet->setCellValue('A' . $i, $key + 1);
			$this->sheet->setCellValue('B' . $i, !empty($data->code) ? $data->code : '');
			$this->sheet->setCellValue('C' . $i, !empty($data->brand_name) ? $data->brand_name : '');
			$this->sheet->setCellValue('D' . $i, !empty($data->model) ? $data->model : '');
			$this->sheet->setCellValue('E' . $i, !empty($data->customer_infor->name) ? $data->customer_infor->name : '');
			$this->sheet->setCellValue('F' . $i, !empty($data->customer_infor->phone) ? $data->customer_infor->phone : '');
			$this->sheet->setCellValue('G' . $i, !empty($data->customer_infor->identify) ? $data->customer_infor->identify : '');
			$this->sheet->setCellValue('H' . $i, !empty($data->vehicle_number) ? $data->vehicle_number : '');
			$this->sheet->setCellValue('I' . $i, !empty($data->chassis_number) ? $data->chassis_number : '');
			$this->sheet->setCellValue('J' . $i, !empty($data->engine_number) ? $data->engine_number : '');
			$this->sheet->setCellValue('K' . $i, !empty($data->registration->number) ? $data->registration->number : '');
			$this->sheet->setCellValue('L' . $i, !empty($data->registration->date_range) ? $data->registration->date_range : '');
			$this->sheet->setCellValue('M' . $i, !empty($data->registration->issued_by) ? $data->registration->issued_by : '');
			$this->sheet->setCellValue('N' . $i, !empty($data->status) ? status_blacklist_property($data->status) : '');
			$this->sheet->setCellValue('O' . $i, !empty($data->created_at) ? date('d/m/Y H:i:s', $data->created_at) : '');
			$this->sheet->setCellValue('P' . $i, !empty($data->created_by) ? $data->created_by : '');
			$this->sheet->setCellValue('Q' . $i, !empty($data->inspection->number) ? $data->inspection->number : '');
			$this->sheet->setCellValue('R' . $i, !empty($data->inspection->date_range) ? $data->inspection->date_range : '');
			$this->sheet->setCellValue('S' . $i, !empty($data->inspection->issued_by) ? $data->inspection->issued_by : '');
			$i++;
		}
	}

	private function callLibExcel($filename)
	{
		// Redirect output to a client's web browser (Xlsx)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.
		ob_end_clean();
		$writer = IOFactory::createWriter($this->spreadsheet, 'Xlsx');
		$writer->save('php://output');
	}

	public function update_valuation_property()
	{
		$data = $this->input->post();

		$loai_xe_may = !empty($data['type_property_xm']) ? $data['type_property_xm'] : '';
		$loai_xe_oto = !empty($data['type_property_oto']) ? $data['type_property_oto'] : '';
		$hang_xe = !empty($data['brand']) ? $data['brand'] : '';
		$year = !empty($data['year']) ? $data['year'] : '';
		$phan_khuc = !empty($data['phan_khuc']) ? $data['phan_khuc'] : '';
		$model = !empty($data['model']) ? $data['model'] : '';
		$xuat_xu = !empty($data['xuat_xu']) ? $data['xuat_xu'] : '';
		$ban_xang_dau = !empty($data['gas_or_oil']) ? $data['gas_or_oil'] : '';
		$id = !empty($data['id']) ? $data['id'] : '';
		$type = !empty($data['type']) ? $data['type'] : '';
		$price_suggest = !empty($data['price_suggest']) ? $data['price_suggest'] : '';
		$price_suggest_str = $price_str = str_replace( ',', '', $price_suggest );
		$description = !empty($data['description']) ? $data['description'] : '';
		$path_tai_san = !empty($data['img_tai_san']) ? json_decode($data['img_tai_san']) : '';
		$path_giay_to = !empty($data['img_giay_to']) ? json_decode($data['img_giay_to']) : '';
		$path_dang_kiem = !empty($data['img_dang_kiem']) ? json_decode($data['img_dang_kiem']) : '';
		$url = base_url('property/property_valuation');

		$datainsert = [
			'type_xm_oto' => $type,
			'loai_xe_may' => $loai_xe_may,
			'loai_xe_oto' => $loai_xe_oto,
			'hang_xe' => $hang_xe,
			'year_property' => $year,
			'phan_khuc' => $phan_khuc,
			'name' => $model,
			'xuat_xu' => $xuat_xu,
			'ban_xang_dau' => $ban_xang_dau,
			'id' => $id,
			'price_suggest' => $price_suggest_str,
			'description' => $description,
			'img_tai_san' => $path_tai_san,
			'img_dang_ky' => $path_giay_to,
			'img_dang_kiem' => $path_dang_kiem,
			'url' => $url
		];
		$return = $this->api->apiPost($this->user['token'], "property_v3/update_property_valuation", $datainsert);
		if (isset($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $return->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => $return->message)));
			return;
		}

	}

	public function update_property()
	{
		$data = $this->input->post();
		$name = !empty($data['name']) ? $data['name'] : '';
		$loai_xe_may = !empty($data['type_property_xm']) ? $data['type_property_xm'] : '';
		$loai_xe_oto = !empty($data['type_property_oto']) ? $data['type_property_oto'] : '';
		$hang_xe = !empty($data['brand']) ? $data['brand'] : '';
		$year = !empty($data['year']) ? $data['year'] : '';
		$phan_khuc_oto = !empty($data['phan_khuc_oto']) ? $data['phan_khuc_oto'] : '';
		$phan_khuc_xm = !empty($data['phan_khuc_xm']) ? $data['phan_khuc_xm'] : '';
		$model = !empty($data['model']) ? $data['model'] : '';
		$xuat_xu = !empty($data['xuat_xu']) ? $data['xuat_xu'] : '';
		$ban_xang_dau = !empty($data['gas_or_oil']) ? $data['gas_or_oil'] : '';
		$id = !empty($data['id']) ? $data['id'] : '';
		$type = !empty($data['type']) ? $data['type'] : '';

		$datainsert = [
			'ten_tai_san' => $name,
			'type_xm_oto' => $type,
			'loai_xe_may' => $loai_xe_may,
			'loai_xe_oto' => $loai_xe_oto,
			'hang_xe' => $hang_xe,
			'year_property' => $year,
			'phan_khuc_oto' => $phan_khuc_oto,
			'phan_khuc_xm' => $phan_khuc_xm,
			'name' => $model,
			'xuat_xu' => $xuat_xu,
			'ban_xang_dau' => $ban_xang_dau,
			'id' => $id,
		];

		$return = $this->api->apiPost($this->user['token'], "property_v3/update_property", $datainsert);
		if (isset($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $return->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => $return->message)));
			return;
		}

	}

	public function cancel_valuation_property()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : '';
		$data['id'] = $id;
		$data['url_item'] = base_url('property/detail_valuation_property?id=' . $id);
		$data['url'] = base_url('property/valuation_property');
		$return = $this->api->apiPost($this->user['token'], "property_v3/cancel_property_valuation", $data);
		if (isset($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $return->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => $return->message)));
			return;
		}

	}

	public function dashboard_test()
	{
		$this->data['template'] = 'page/property/new/test';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
		//danh sách blacklist
	public function blackList()
	{
		$data = [];
		$from_date = !empty($_GET['from_date']) ? $_GET['from_date'] : '';
		$to_date = !empty($_GET['to_date']) ? $_GET['to_date'] : '';
		$property = !empty($_GET['type']) ? $_GET['type'] : 'XM';
		$bien_so_xe = !empty($_GET['bien_so_xe']) ? $_GET['bien_so_xe'] : '';
		$hang_xe = !empty($_GET['hang_xe']) ? $_GET['hang_xe'] : '';
		$so_khung = !empty($_GET['so_khung']) ? $_GET['so_khung'] : '';
		$so_may = !empty($_GET['so_may']) ? $_GET['so_may'] : '';
		$phone = !empty($_GET['phone']) ? $_GET['phone'] : '';
		$identify_passport = !empty($_GET['identify_passport']) ? $_GET['identify_passport'] : '';
		if (strtotime($from_date) > strtotime($to_date)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('Property/blackList'));
		}
		if (!empty($from_date) && !empty($to_date)) {
			$data = array();
			$data = [
				'from_date' => $from_date,
				'to_date' => $to_date,
			];
		}
		if (!empty($property)) {
			$dataSendApi = [
				'code' => $property
			];
			$response = $this->api->apiPost($this->userInfo['token'], "Property_v2/get_main_property", $dataSendApi);
			if (isset($response->status) && $response->status == 200) {
				$this->data['branch_property'] = $response->data;
			} else {
				$this->data['branch_property'] = array();
			}
			$data['property'] = $property;
		}
		if (!empty($bien_so_xe)) {
			$data['bien_so_xe'] = $bien_so_xe;
		}
		if (!empty($hang_xe)) {
			$dataSendApiPropertyInfo = [
				'property_id' => $hang_xe
			];
			$property_infor = $this->api->apiPost($this->userInfo['token'], 'Property/get_property_info_by_id', $dataSendApiPropertyInfo);
			if (!empty($property_infor->name)) {
				$data['hang_xe'] = $property_infor->name;
			} else {
				$data['hang_xe'] = '';
			}
		}
		if (!empty($so_khung)) {
			$data['so_khung'] = $so_khung;
		}
		if (!empty($so_may)) {
			$data['so_may'] = $so_may;
		}
		if (!empty($phone)) {
			$data['phone'] = $phone;
		}
		if (!empty($identify_passport)) {
			$data['identify_passport'] = $identify_passport;
		}
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 20;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];
		$config['base_url'] = base_url('property/blackList?type=' . $data['property'] . '&bien_so_xe=' . $data['bien_so_xe']
				. '&hang_xe=' . $data['hang_xe']  . '&so_khung=' . $data['so_khung'] . '&so_may=' . $data['so_may']
				. '&phone=' . $data['phone'] . '&identify_passport=' . $data['identify_passport']. '&from_date=' .
			$data['from_date']. '&to_date=' . $data['to_date']);
		$result = $this->api->apiPost($this->user['token'], "property_blacklist/blacklist", $data);
		if (isset($result->status) && $result->status == 200) {
			$config['total_rows'] = $result->total;
			$this->data['property'] = $result->data;
			$this->data['total_rows'] = $result->total;
			$this->data['userDG'] = $result->userDG;
		} else {
			$this->data['propertys'] = array();
		}
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/property/blacklist/list';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}
		//danh sách yêu cầu check
	public function requestBlacklist()
	{
		$property = !empty($_GET['type']) ? $_GET['type'] : '';
		$hang_xe = !empty($_GET['hang_xe']) ? $_GET['hang_xe'] : '';
		$status = !empty($_GET['status']) ? $_GET['status'] : '';
		if (!empty($property)) {
			$dataSendApi = [
				'code' => $property
			];
			$response = $this->api->apiPost($this->userInfo['token'], "Property_v2/get_main_property", $dataSendApi);
			if (isset($response->status) && $response->status == 200) {
				$this->data['branch_property'] = $response->data;
			} else {
				$this->data['branch_property'] = array();
			}
			$data['property'] = $property;
		}
		if (!empty($hang_xe)) {
			$dataSendApiPropertyInfo = [
				'property_id' => $hang_xe
			];
			$property_infor = $this->api->apiPost($this->userInfo['token'], 'Property/get_property_info_by_id', $dataSendApiPropertyInfo);
			if (!empty($property_infor->name)) {
				$hang_xe_filter = $property_infor->name;
			} else {
				$hang_xe_filter = '';
			}
			$data['hang_xe'] = $hang_xe_filter;
		}
		if (!empty($status)) {
			$data['status_blacklist'] = $status;
		}
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 20;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];
		$config['base_url'] = base_url('property/requestBlacklist?type=' . $data['property'] . '&hang_xe=' . $data['hang_xe']);
		$result = $this->api->apiPost($this->user['token'], "property_blacklist/propertyBlacklist", $data);
		if (isset($result->status) && $result->status == 200) {
			$config['total_rows'] = $result->total;
			$this->data['property'] = $result->data;
			$this->data['total_rows'] = $result->total;
		} else {
			$this->data['propertys'] = array();
		}
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
			if (!empty($groupRoles->status) && $groupRoles->status == 200) {
				$this->data['groupRoles'] = $groupRoles->data;
			} else {
				$this->data['groupRoles'] = array();
			}
		//get property main ( tài sản cấp cao nhất parenid == null)
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main");
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$this->data['mainPropertyData'] = $mainPropertyData->data;
		} else {
			$this->data['mainPropertyData'] = array();
		}
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/property/requestBlacklist/list';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function requestBlacklistCreate()
	{
		$this->data['template'] = 'page/property/requestBlacklist/request';
		//get property main ( tài sản cấp cao nhất parenid == null)
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main");
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$this->data['mainPropertyData'] = $mainPropertyData->data;
		} else {
			$this->data['mainPropertyData'] = array();
		}
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function requestBlacklistSave()
	{
		$data = $this->input->post();
		$property = !empty($data['type_xm_oto']) ? $this->security->xss_clean($data['type_xm_oto']) : '';
		$property_id = !empty($data['property_id']) ? $this->security->xss_clean($data['property_id']) : '';
		$front_registration_img = !empty($data['front_registration_img']) ? $this->security->xss_clean($data['front_registration_img']) : '';
		$back_registration_img = !empty($data['back_registration_img']) ? $this->security->xss_clean($data['back_registration_img']) : '';
		$front_regis_car_img = !empty($data['front_regis_car_img']) ? $this->security->xss_clean($data['front_regis_car_img']) : '';
		$back_regis_car_img = !empty($data['back_regis_car_img']) ? $this->security->xss_clean($data['back_regis_car_img']) : '';
		$img_tai_san = !empty($data['another_img_file']) ? json_decode($this->security->xss_clean($data['another_img_file'])) : '';
		$dataSendApi = [
			'property_id' => $property_id
		];
		$property_infor = $this->api->apiPost($this->userInfo['token'], 'Property/get_property_info_by_id', $dataSendApi);
		if (!empty($property_infor->name)) {
			$brand_property = $property_infor->name;
		} else {
			$brand_property = $property_id;
		}
		$datainsert = [
			'property' => $property,
			'brand_property' => $brand_property,
			'id_property' => $property_id,
			'front_registration_img' => $front_registration_img,
			'back_registration_img' => $back_registration_img,
			'front_regis_car_img' => $front_regis_car_img,
			'back_regis_car_img' => $back_regis_car_img,
			'image_tai_san' => $img_tai_san,
			'url' => base_url('property/requestBlacklist'),
			'url_item' => base_url('property/requestBlacklistDetail')
		];
		$return = $this->api->apiPost($this->user['token'], "property_blacklist/requestProperty", $datainsert);
		if (isset($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $return->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => $return->message)));
			return;
		}

	}

	public function requestBlacklistDetail()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : '';
		$result = $this->api->apiPost($this->user['token'], "property_blacklist/detailRequestProperty", ['id' => $id]);
		if (isset($result->status) && $result->status == 200) {
			$this->data['total_rows'] = $result->total;
			$this->data['detail_property_blacklist'] = $result->data;
			$this->data['userDG'] = $result->userDG;
			$img_tai_san = $result->data->image_property;
			$img_dang_ky = $result->data->image_registration;
			$img_dang_kiem = $result->data->image_certificate;
			if (!empty($result->data->image_property)) {
				$arr_img_tai_san = [];
				foreach ($result->data->image_property as $value) {
					array_push($arr_img_tai_san, $value);
				}
			}
			if (!empty($result->data->image_registration)) {
				$arr_img_dang_ky = [];
				foreach ($result->data->image_registration as $value) {
					array_push($arr_img_dang_ky, $value);
				}
			}
			if (!empty($result->data->image_certificate)) {
				$arr_img_dang_kiem = [];
				foreach ($result->data->image_certificate as $value) {
					array_push($arr_img_dang_kiem, $value);
				}
			}
			$this->data['img_tai_san'] = $arr_img_tai_san;
			$this->data['img_dang_ky'] = $arr_img_dang_ky;
			$this->data['img_dang_kiem'] = $arr_img_dang_kiem;
			$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
			if (!empty($groupRoles->status) && $groupRoles->status == 200) {
				$this->data['groupRoles'] = $groupRoles->data;
			} else {
				$this->data['groupRoles'] = array();
			}
		}
		$log = $this->api->apiPost($this->user['token'], "property_blacklist/getHistoryBlacklistProperty", ['id' => $id]);
		if (!empty($log->status) && $log->status == 200) {
			$this->data['logs'] = $log->data;
		} else {
			$this->data['logs'] = array();
		}

		$this->data['template'] = 'page/property/requestBlacklist/detail';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function blacklistDetail()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : '';
		$result = $this->api->apiPost($this->user['token'], "property_blacklist/detailRequestProperty", ['id' => $id]);
		if (isset($result->status) && $result->status == 200) {
			$this->data['total_rows'] = $result->total;
			$this->data['detail_property_blacklist'] = $result->data;
			$this->data['userDG'] = $result->userDG;
			$img_tai_san = $result->data->image_property;
			$img_dang_ky = $result->data->image_registration;
			$img_dang_kiem = $result->data->image_certificate;
			if (!empty($result->data->image_property)) {
				$arr_img_tai_san = [];
				foreach ($result->data->image_property as $value) {
					array_push($arr_img_tai_san, $value);
				}
			}
			if (!empty($result->data->image_registration)) {
				$arr_img_dang_ky = [];
				foreach ($result->data->image_registration as $value) {
					array_push($arr_img_dang_ky, $value);
				}
			}
			if (!empty($result->data->image_certificate)) {
				$arr_img_dang_kiem = [];
				foreach ($result->data->image_certificate as $value) {
					array_push($arr_img_dang_kiem, $value);
				}
			}

			$this->data['img_tai_san'] = $arr_img_tai_san;
			$this->data['img_dang_ky'] = $arr_img_dang_ky;
			$this->data['img_dang_kiem'] = $arr_img_dang_kiem;
			$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
			if (!empty($groupRoles->status) && $groupRoles->status == 200) {
				$this->data['groupRoles'] = $groupRoles->data;
			} else {
				$this->data['groupRoles'] = array();
			}
		}
		$log = $this->api->apiPost($this->user['token'], "property_blacklist/getHistoryBlacklistProperty", ['id' => $id]);
		if (!empty($log->status) && $log->status == 200) {
			$this->data['logs'] = $log->data;
		} else {
			$this->data['logs'] = array();
		}
		$this->data['template'] = 'page/property/blacklist/detail';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function requestBlacklistEdit()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : '';
		$result = $this->api->apiPost($this->user['token'], "property_blacklist/detailRequestProperty", ['id' => $id]);
		if (isset($result->status) && $result->status == 200) {
			$this->data['total_rows'] = $result->total;
			$this->data['detail_property_blacklist'] = $result->data;
			$img_tai_san = $result->data->image_property;
			$img_dang_ky = $result->data->image_registration;
			$img_dang_kiem = $result->data->image_certificate;
			if (!empty($result->data->image_property)) {
				$arr_img_tai_san = [];
				foreach ($result->data->image_property as $value) {
					array_push($arr_img_tai_san, $value);
				}
			}
			if (!empty($result->data->image_registration)) {
				$arr_img_dang_ky = [];
				foreach ($result->data->image_registration as $value) {
					array_push($arr_img_dang_ky, $value);
				}
			}
			if (!empty($result->data->image_certificate)) {
				$arr_img_dang_kiem = [];
				foreach ($result->data->image_certificate as $value) {
					array_push($arr_img_dang_kiem, $value);
				}
			}

			$this->data['img_tai_san'] = $arr_img_tai_san;
			$this->data['img_dang_ky'] = $arr_img_dang_ky;
			$this->data['img_dang_kiem'] = $arr_img_dang_kiem;
			$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
			if (!empty($groupRoles->status) && $groupRoles->status == 200) {
				$this->data['groupRoles'] = $groupRoles->data;
			} else {
				$this->data['groupRoles'] = array();
			}
			$dataSendApi = [
				'code' => $result->data->code
			];
			$main_property = $this->api->apiPost($this->userInfo['token'], "Property_v2/get_main_property", $dataSendApi);
			if (!empty($main_property->data)) {
				$this->data['property_branch'] = $main_property->data;
			} else {
				$this->data['property_branch'] = array();
			}
		}
		//get property main ( tài sản cấp cao nhất parenid == null)
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main");
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$this->data['mainPropertyData'] = $mainPropertyData->data;
		} else {
			$this->data['mainPropertyData'] = array();
		}
		$log = $this->api->apiPost($this->user['token'], "property_blacklist/getHistoryBlacklistProperty", ['id' => $id]);
		if (!empty($log->status) && $log->status == 200) {
			$this->data['logs'] = $log->data;
		} else {
			$this->data['logs'] = array();
		}
		if (!empty($this->data['logs'])) {
			$is_black_list = false;
			foreach ($this->data['logs'] as $log) {
				if ($log->data->status == 'active') {
					$is_black_list = true;
					break;
				}
			}
			$this->data['is_black_list'] = $is_black_list;
		}
		$this->data['template'] = 'page/property/requestBlacklist/update';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function requestBlacklistUpdate()
	{
		$data = $this->input->post();
		$dataPost = [];
		$id = !empty($data['id']) ? $data['id'] : '';
		$property = !empty($data['loai_xe']) ? $data['loai_xe'] : '';
		$hang_xe = !empty($data['hang_xe']) ? $data['hang_xe'] : '';
		$so_khung = !empty($data['so_khung']) ? $data['so_khung'] : '';
		$so_may = !empty($data['so_may']) ? $data['so_may'] : '';
		$bien_so_xe = !empty($data['bien_so_xe']) ? $data['bien_so_xe'] : '';
		$owner = !empty($data['name']) ? $data['name'] : '';
		$phone = !empty($data['phone']) ? $data['phone'] : '';
		$identify = !empty($data['identify']) ? $data['identify'] : '';
		$path = !empty($data['img_tai_san']) ? json_decode($data['img_tai_san']) : '';

		$dataPost = [
			'id' => $id,
			'property' => $property,
			'hang_xe' => $hang_xe,
			'so_khung' => $so_khung,
			'so_may' => $so_may,
			'bien_so_xe' => $bien_so_xe,
			'ten_chu_xe' => $owner,
			'phone' => $phone,
			'identify' => $identify,
			'path' => $path
		];

		$return = $this->api->apiPost($this->user['token'], "property_blacklist/updateRequestProperty", $dataPost);
		if (isset($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $return->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => $return->message)));
			return;
		}
	}

	public function requestBlacklistDelete()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : '';
		$return = $this->api->apiPost($this->user['token'], "property_blacklist/deleteProperty", ['id' => $id]);
		if (isset($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $return->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => $return->message)));
			return;
		}
	}
		//hủy check
	public function cancelRequest()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : '';
		$url = base_url('property/requestBlacklist');
		$url_item = base_url('property/requestBlacklistDetail?id=' . $id);
		$return = $this->api->apiPost($this->user['token'], "property_blacklist/cancelRequesProperty", ['id' => $id, 'url' => $url, 'url_item' => $url_item]);

		if (isset($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $return->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => $return->message)));
			return;
		}

	}
		//trả về
	public function feedbackRequest()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : '';
		$note = !empty($data['note']) ? $data['note'] : '';
		$dataPost = [
			'id' => $id,
			'note' => $note,
			'url' => base_url('property/requestBlacklist'),
			'url_item' => base_url('property/requestBlacklistEdit?id=' . $id)
		];
		$return = $this->api->apiPost($this->user['token'], "property_blacklist/feedbackRequestProperty",$dataPost);
		if (isset($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $return->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => $return->message)));
			return;
		}
	}
			//thêm tài sản vào blacklist
	public function addPropertyBlacklist()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : '';
		$name = !empty($data['ten_chu_xe']) ? $data['ten_chu_xe'] : '';
		$so_khung = !empty($data['so_khung']) ? $data['so_khung'] : '';
		$so_may = !empty($data['so_may']) ? $data['so_may'] : '';
		$bien_so_xe = !empty($data['bien_so_xe']) ? $data['bien_so_xe'] : '';
		$so_dang_ky = !empty($data['so_dang_ky']) ? $data['so_dang_ky'] : '';
		$noi_cap_dang_ky = !empty($data['noi_cap_dang_ky']) ? $data['noi_cap_dang_ky'] : '';
		$ngay_cap_dang_ky = !empty($data['ngay_cap_dang_ky']) ? $data['ngay_cap_dang_ky'] : '';
		$so_dang_kiem = !empty($data['so_dang_kiem']) ? $data['so_dang_kiem'] : '';
		$ngay_cap_dang_kiem = !empty($data['ngay_cap_dang_kiem']) ? $data['ngay_cap_dang_kiem'] : '';
		$noi_cap_dang_kiem = !empty($data['noi_cap_dang_kiem']) ? $data['noi_cap_dang_kiem'] : '';
		$description = !empty($data['description']) ? $data['description'] : '';
		$loai_xe = !empty($data['loai_xe']) ? $data['loai_xe'] : '';
		$dataPost = [
			'id' => $id,
			'name' => $name,
			'bien_so_xe' => $bien_so_xe,
			'so_may' => $so_may,
			'so_khung' => $so_khung,
			'so_dang_ky' => $so_dang_ky,
			'noi_cap_dang_ky' => $noi_cap_dang_ky,
			'ngay_cap_dang_ky' => $ngay_cap_dang_ky,
			'so_dang_kiem' => $so_dang_kiem,
			'ngay_cap_dang_kiem' => $ngay_cap_dang_kiem,
			'noi_cap_dang_kiem' => $noi_cap_dang_kiem,
			'description' => $description,
			'loai_xe' => $loai_xe,
			'url' => base_url('property/blacklist'),
			'url_item' => base_url('property/blacklistDetail?id=' . $id),
		];
		$return = $this->api->apiPost($this->user['token'], "property_blacklist/checkFakeRequestProperty", $dataPost);
		if (isset($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $return->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => $return->message)));
			return;
		}
	}
		//xác nhận tài sản thật
	public function realProperty()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : '';
		$dataPost = [
			'id' => $id,
			'url' => base_url('property/requestBlacklist'),
			'url_item' => base_url('property/requestBlacklistDetail?id=' . $id),
		];
		$return = $this->api->apiPost($this->user['token'], "property_blacklist/checkRealRequestProperty", $dataPost);
		if (isset($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $return->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => $return->message)));
			return;
		}

	}
		//update yêu cầu sau feedback
	public function updateFeedback()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : '';
		$loai_xe = !empty($data['loai_xe']) ? $data['loai_xe'] : '';
		$ten_chu_xe = !empty($data['name']) ? $data['name'] : '';
		$property_id = !empty($data['property_id']) ? $this->security->xss_clean($data['property_id']) : '';
		$front_registration_img = !empty($data['front_registration_img']) ? $this->security->xss_clean($data['front_registration_img']) : '';
		$back_registration_img = !empty($data['back_registration_img']) ? $this->security->xss_clean($data['back_registration_img']) : '';
		$front_regis_car_img = !empty($data['front_regis_car_img']) ? $this->security->xss_clean($data['front_regis_car_img']) : '';
		$back_regis_car_img = !empty($data['back_regis_car_img']) ? $this->security->xss_clean($data['back_regis_car_img']) : '';
		$img_tai_san = !empty($data['another_img_file']) ? json_decode($this->security->xss_clean($data['another_img_file'])) : '';
		$dataSendApi = [
			'property_id' => $property_id
		];
		$property_infor = $this->api->apiPost($this->userInfo['token'], 'Property/get_property_info_by_id', $dataSendApi);
		if (!empty($property_infor->name)) {
			$brand_property = $property_infor->name;
		} else {
			$brand_property = $property_id;
		}
		$dataPost = [
			'id' => $id,
			'loai_xe' => $loai_xe,
			'brand_property' => $brand_property,
			'id_property' => $property_id,
			'name' => $ten_chu_xe,
			'front_registration_img' => $front_registration_img,
			'back_registration_img' => $back_registration_img,
			'front_regis_car_img' => $front_regis_car_img,
			'back_regis_car_img' => $back_regis_car_img,
			'image_tai_san' => $img_tai_san,
			'url' => base_url('property/requestBlacklist'),
			'url_item' => base_url('property/requestBlacklistDetail?id=' . $id),
		];
		$return = $this->api->apiPost($this->user['token'], "property_blacklist/updateAfterFeedbackBlacklist", $dataPost);
		if (isset($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $return->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => $return->message)));
			return;
		}
	}
		//tạo yêu cầu cập nhật sau khi vào blacklist
	public function createRequestUpdateBlacklist()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : '';
		$updateDescription = !empty($data['updateDescription']) ? $data['updateDescription'] : '';
		$dataPost = [
			'id' => $id,
			'updateDescription' => $updateDescription,
			'url' => base_url('property/requestBlacklist'),
			'url_item' => base_url('property/requestBlacklistEdit?id=' . $id)
		];
		$return = $this->api->apiPost($this->user['token'], "property_blacklist/createRequestUpdateBlacklist",$dataPost);
		if (isset($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $return->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => $return->message)));
			return;
		}

	}
			//update yêu cầu sau khi vào blacklist
	public function updateRequestBlacklist()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : '';
		$identify = !empty($data['identify']) ? $data['identify'] : '';
		$passport = !empty($data['passport']) ? $data['passport'] : '';
		$noi_cap = !empty($data['noi_cap']) ? $data['noi_cap'] : '';
		$ngay_cap = !empty($data['ngay_cap']) ? $data['ngay_cap'] : '';
		$phone = !empty($data['phone']) ? $data['phone'] : '';
		$name = !empty($data['name']) ? $data['name'] : '';
		$loai_xe = !empty($data['loai_xe']) ? $data['loai_xe'] : '';
		$front_registration_img = !empty($data['front_registration_img']) ? $this->security->xss_clean($data['front_registration_img']) : '';
		$back_registration_img = !empty($data['back_registration_img']) ? $this->security->xss_clean($data['back_registration_img']) : '';
		$front_regis_car_img = !empty($data['front_regis_car_img']) ? $this->security->xss_clean($data['front_regis_car_img']) : '';
		$back_regis_car_img = !empty($data['back_regis_car_img']) ? $this->security->xss_clean($data['back_regis_car_img']) : '';
		$img_tai_san = !empty($data['another_img_file']) ? json_decode($this->security->xss_clean($data['another_img_file'])) : '';
		$dataPost = [
			'id' => $id,
			'identify' => $identify,
			'passport' => $passport,
			'noi_cap' => $noi_cap,
			'ngay_cap' => $ngay_cap,
			'phone' => $phone,
			'name' => $name,
			'loai_xe' => $loai_xe,
			'front_registration_img' => $front_registration_img,
			'back_registration_img' => $back_registration_img,
			'front_regis_car_img' => $front_regis_car_img,
			'back_regis_car_img' => $back_regis_car_img,
			'image_tai_san' => $img_tai_san,
			'url' => base_url('property/blacklist'),
			'url_item' => base_url('property/blacklistDetail?id=' . $id),
		];
		$return = $this->api->apiPost($this->user['token'], "property_blacklist/updateRequestBlacklist",$dataPost);
		if (isset($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $return->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => $return->message)));
			return;
		}

	}

	public function addCommentRequestBlacklist()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : '';
		$comment = !empty($data['comment']) ? $data['comment'] : '';
		$dataPost = [
			'id' => $id,
			'comment' => $comment,
		];
		$return = $this->api->apiPost($this->user['token'], "property_blacklist/addCommentBlacklistPropertyIntoLog",$dataPost);
		if (isset($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $return->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => $return->message)));
			return;
		}

	}

	public function comment_valuation()
	{
		$data = [];
		$data['id'] = !empty($_POST['id']) ? $_POST['id'] : '';
		$id = $data['id'];
		$data['comment'] = !empty($_POST['comment']) ? $_POST['comment'] : '';
		$return = $this->api->apiPost($this->user['token'], "property_v3/comment_valuation", $data);
		if (isset($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $return->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => $return->message)));
			return;
		}

	}

	public function importBlacklistXM()
	{
		$data = $this->input->post();
		$type = !empty($data['type']) ? $data['type'] : '';
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
				if (stripos("Hãng xe", trim($sheetData[0][0])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô A định dạng bắt buộc là Hãng xe"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Tên chủ xe(cá nhân/pháp nhân)", trim($sheetData[0][1])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô B định dạng bắt buộc là Tên chủ xe(cá nhân/pháp nhân)"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Số khung", trim($sheetData[0][2])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô C định dạng bắt buộc là Số khung"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Số máy", trim($sheetData[0][3])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô D định dạng bắt buộc là Số máy"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Biển số xe", trim($sheetData[0][4])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô E định dạng bắt buộc là Biển số xe"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Số đăng ký", trim($sheetData[0][5])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô F định dạng bắt buộc là Số đăng ký"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Ngày cấp đăng ký", trim($sheetData[0][6])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô G định dạng bắt buộc là Ngày cấp đăng ký"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Nơi cấp đăng ký", trim($sheetData[0][7])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô H định dạng bắt buộc là Nơi cấp đăng ký"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Mô tả", trim($sheetData[0][8])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô I định dạng bắt buộc là Mô tả"
					];
					echo json_encode($response);
					return;
				}
				foreach ($sheetData as $key => $value) {
					if ($this->isEmptyRow($value)) {
						continue;
					}
					if ($key >= 1) {
						if ($value["0"] == '') continue;
						$data = array(
							"code" => $type,
							"brand" => !empty($value["0"]) ? (trim($value["0"])) : "",
							"name" => !empty(trim($value["1"])) ? (trim($value["1"])) : "",
							"so_khung" => !empty(trim($value["2"])) ? (trim($value["2"])) : "",
							"so_may" => !empty(trim($value["3"])) ? (trim($value["3"])) : "",
							"bien_so_xe" => !empty(trim($value["4"])) ? (trim($value["4"])) : "",
							"so_dang_ky" => !empty(trim($value["5"])) ? (trim($value["5"])) : "",
							"ngay_cap_dang_ky" => !empty(trim($value["6"])) ? trim($value["6"]) : "",
							"noi_cap_dang_ky" => !empty(trim($value["7"])) ? (trim($value["7"])) : "",
							"description" => !empty(trim($value["8"])) ? (trim($value["8"])) : "",
						);
						$return = $this->api->apiPost($this->user['token'], "property_blacklist/importExcelXM", $data);
					}
				}
				$response = [
					'res' => true,
					'status' => "200",
					'message' => $this->lang->line('import_success'),
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

	public function importBlacklistOTO()
	{
		$data = $this->input->post();
		$type = !empty($data['type']) ? $data['type'] : '';
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
				if (stripos("Hãng xe", trim($sheetData[0][0])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô A định dạng bắt buộc là Hãng xe"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Tên chủ xe(cá nhân/pháp nhân)", trim($sheetData[0][1])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô B định dạng bắt buộc là Tên chủ xe(cá nhân/pháp nhân)"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Số khung", trim($sheetData[0][2])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô C định dạng bắt buộc là Số khung"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Số máy", trim($sheetData[0][3])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô D định dạng bắt buộc là Số máy"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Biển số xe", trim($sheetData[0][4])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô E định dạng bắt buộc là Biển số xe"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Số đăng ký", trim($sheetData[0][5])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô F định dạng bắt buộc là Số đăng ký"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Ngày cấp đăng ký", trim($sheetData[0][6])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô G định dạng bắt buộc là Ngày cấp đăng ký"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Nơi cấp đăng ký", trim($sheetData[0][7])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô H định dạng bắt buộc là Nơi cấp đăng ký"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Số đăng kiểm", trim($sheetData[0][8])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô I định dạng bắt buộc là Số đăng kiểm"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Ngày cấp đăng kiểm", trim($sheetData[0][9])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô J định dạng bắt buộc là Ngày cấp đăng kiểm"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Nơi cấp đăng kiểm", trim($sheetData[0][10])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô K định dạng bắt buộc là Nơi cấp đăng kiểm"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Mô tả", trim($sheetData[0][11])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô L định dạng bắt buộc là Mô tả"
					];
					echo json_encode($response);
					return;
				}
				foreach ($sheetData as $key => $value) {
					if ($this->isEmptyRow($value)) {
						continue;
					}
					if ($key >= 1) {
						if ($value["0"] == '') continue;
						$data = array(
							"code" => $type,
							"brand" => !empty($value["0"]) ? (trim($value["0"])) : "",
							"name" => !empty(trim($value["1"])) ? (trim($value["1"])) : "",
							"so_khung" => !empty(trim($value["2"])) ? (trim($value["2"])) : "",
							"so_may" => !empty(trim($value["3"])) ? (trim($value["3"])) : "",
							"bien_so_xe" => !empty(trim($value["4"])) ? (trim($value["4"])) : "",
							"so_dang_ky" => !empty(trim($value["5"])) ? (trim($value["5"])) : "",
							"ngay_cap_dang_ky" => !empty(trim($value["6"])) ? (trim($value["6"])) : "",
							"noi_cap_dang_ky" => !empty(trim($value["7"])) ? (trim($value["7"])) : "",
							"so_dang_kiem" => !empty(trim($value["8"])) ? (trim($value["8"])) : "",
							"ngay_cap_dang_kiem" => !empty(trim($value["9"])) ? (trim($value["9"])) : "",
							"noi_cap_dang_kiem" => !empty(trim($value["10"])) ? (trim($value["10"])) : "",
							"description" => !empty(trim($value["11"])) ? (trim($value["11"])) : "",
						);
						$return = $this->api->apiPost($this->user['token'], "property_blacklist/importExcelOTO", $data);
					}
				}
				$response = [
					'res' => true,
					'status' => "200",
					'message' => $this->lang->line('import_success'),
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

	public function isEmptyRow($row) {
        if (!array_filter($row)) {
            return true;
        }
        return false;
    }

}

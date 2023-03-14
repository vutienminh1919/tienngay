<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Property_valuation extends MY_Controller
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
		$this->spreadsheet = new Spreadsheet();
		$this->sheet = $this->spreadsheet->getActiveSheet();

	}

	public function view_list_moto()
	{
		$vehicles = !empty($_GET['vehicles']) ? $_GET['vehicles'] : "";
		$name_property = !empty($_GET['name_property']) ? $_GET['name_property'] : "";
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('property_valuation/view_list_moto?vehicles=' . $vehicles . '&name_property=' . $name_property);
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 50;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		if (!empty($vehicles)) {
			$data['vehicles'] = trim($vehicles);
		}
		if (!empty($name_property)) {
			$data['name_property'] = trim($name_property);
		}
		$main_property = $this->api->apiPost($this->user['token'], "property_valuation/get_list_main_motorcycle");
		if (!empty($main_property->status) && $main_property->status == 200) {
			$this->data['main_property'] = $main_property->data;
		} else {
			$this->data['main_property'] = array();
		}
		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];
		$property = $this->api->apiPost($this->user['token'], "property_valuation/get_list_motorcycle", $data);
		if (!empty($property->status) && $property->status == 200) {
			$config['total_rows'] = $property->total;
			$this->data['property'] = $property->data;
			$this->data['total_rows'] = $property->total;
		} else {
			$this->data['property'] = array();
		}
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/property/list/list_moto';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function view_list_oto()
	{
		$vehicles = !empty($_GET['vehicles']) ? $_GET['vehicles'] : "";
		$name_property = !empty($_GET['name_property']) ? $_GET['name_property'] : "";
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('property_valuation/view_list_oto?vehicles=' . $vehicles . '&name_property=' . $name_property);
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 50;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		if (!empty($vehicles)) {
			$data['vehicles'] = trim($vehicles);
		}
		if (!empty($name_property)) {
			$data['name_property'] = trim($name_property);
		}
		$main_property = $this->api->apiPost($this->user['token'], "property_valuation/get_list_main_oto");
		if (!empty($main_property->status) && $main_property->status == 200) {
			$this->data['main_property'] = $main_property->data;
		} else {
			$this->data['main_property'] = array();
		}
		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];
		$property = $this->api->apiPost($this->user['token'], "property_valuation/get_list_oto", $data);
		if (!empty($property->status) && $property->status == 200) {
			$config['total_rows'] = $property->total;
			$this->data['property'] = $property->data;
			$this->data['total_rows'] = $property->total;
		} else {
			$this->data['property'] = array();
		}
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/property/list/list_oto';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function excel_list_moto()
	{
		$vehicles = !empty($_GET['vehicles']) ? $_GET['vehicles'] : "";
		$name_property = !empty($_GET['name_property']) ? $_GET['name_property'] : "";
		if (!empty($vehicles)) {
			$data['vehicles'] = trim($vehicles);
		}
		if (!empty($name_property)) {
			$data['name_property'] = trim($name_property);
		}
		$data['per_page'] = 10000;
		$property = $this->api->apiPost($this->user['token'], "property_valuation/get_list_motorcycle", $data);
		if (!empty($property->status) && $property->status == 200) {
			$this->exportListMoto($property->data);
			$this->callLibExcel('data-property-xemay' . time() . '.xlsx');

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
			redirect(base_url('debt_manager_app/view_manager_contract'));
		}

	}

	public function excel_list_oto()
	{
		$vehicles = !empty($_GET['vehicles']) ? $_GET['vehicles'] : "";
		$name_property = !empty($_GET['name_property']) ? $_GET['name_property'] : "";
		if (!empty($vehicles)) {
			$data['vehicles'] = trim($vehicles);
		}
		if (!empty($name_property)) {
			$data['name_property'] = trim($name_property);
		}
		$data['per_page'] = 10000;
		$property = $this->api->apiPost($this->user['token'], "property_valuation/get_list_oto", $data);
		if (!empty($property->status) && $property->status == 200) {
			$this->exportListOto($property->data);
			$this->callLibExcel('data-property-oto' . time() . '.xlsx');

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
			redirect(base_url('debt_manager_app/view_manager_contract'));
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

	public function exportListMoto($data)
	{
		$this->sheet->setCellValue('A1', 'Tài sản');
		$this->sheet->setCellValue('B1', 'Hãng xe');
		$this->sheet->setCellValue('C1', 'Dòng xe');
		$this->sheet->setCellValue('D1', 'Tên xe');
		$this->sheet->setCellValue('E1', 'Tên đầy đủ');
		$this->sheet->setCellValue('F1', 'Năm sản xuất');
		$this->sheet->setCellValue('G1', 'Giá xe');
		$i = 2;
		foreach ($data as $item) {
			$this->sheet->setCellValue('A' . $i, "Xe Máy");
			$this->sheet->setCellValue('B' . $i, !empty($item->main_data) ? $item->main_data : '');
			$this->sheet->setCellValue('C' . $i, !empty($item->type_property) ? type_property($item->type_property) : '');
			$this->sheet->setCellValue('D' . $i, !empty($item->name) ? $item->name : "");
			$this->sheet->setCellValue('E' . $i, !empty($item->str_name) ? $item->str_name : '');
			$this->sheet->setCellValue('F' . $i, !empty($item->year_property) ? $item->year_property : '');
			$this->sheet->setCellValue('G' . $i, !empty($item->price) ? number_format($item->price) . ' VND' : '');
			$i++;
		}
	}

	public function exportListOto($data)
	{
		$this->sheet->setCellValue('A1', 'Tài sản');
		$this->sheet->setCellValue('B1', 'Hãng xe');
		$this->sheet->setCellValue('C1', 'Dòng xe');
		$this->sheet->setCellValue('D1', 'Tên xe');
		$this->sheet->setCellValue('E1', 'Tên đầy đủ');
		$this->sheet->setCellValue('F1', 'Năm sản xuất');
		$this->sheet->setCellValue('G1', 'Giá xe');
		$this->sheet->setCellValue('H1', 'Bổ máy');
		$this->sheet->setCellValue('I1', 'Tai nạn phần đầu, đuôi (bị nhẹ)');
		$this->sheet->setCellValue('J1', 'Tai nạn phần đầu, đuôi (bị nặng)');
		$this->sheet->setCellValue('K1', 'Tai nạn hai bên cửa');
		$this->sheet->setCellValue('L1', 'Xước sơn, sơn xấu quá nửa xe');
		$this->sheet->setCellValue('M1', 'Đèn Pha xước nhẹ, ố vàng');
		$this->sheet->setCellValue('N1', 'Đèn xước sâu, vỡ phải thay');
		$this->sheet->setCellValue('O1', 'Nội thất  xấu quá 50%');
		$i = 2;
		foreach ($data as $item) {
			if (!empty($item->depreciations)) {
				foreach ($item->depreciations as $v) {
					if ($v->slug == 'bo-may') {
						$H = $v->price;
					}
					if ($v->slug == 'tai-nan-phan-dau-duoi-bi-nhe') {
						$I = $v->price;
					}
					if ($v->slug == 'tai-nan-phan-dau-duoi-bi-nang') {
						$J = $v->price;
					}
					if ($v->slug == 'tai-nan-hai-ben-cua') {
						$K = $v->price;
					}
					if ($v->slug == 'xuoc-son-son-xau-qua-nua-xe') {
						$L = $v->price;
					}
					if ($v->slug == 'den-pha-xuoc-nhe-o-vang') {
						$M = $v->price;
					}
					if ($v->slug == 'den-xuoc-sau-vo-phai-thay') {
						$N = $v->price;
					}
					if ($v->slug == 'noi-that-xau-qua-50') {
						$O = $v->price;
					}
				}
			}
			$this->sheet->setCellValue('A' . $i, "Ôtô");
			$this->sheet->setCellValue('B' . $i, !empty($item->main_data) ? $item->main_data : '');
			$this->sheet->setCellValue('C' . $i, !empty($item->type_property) ? $item->type_property : '');
			$this->sheet->setCellValue('D' . $i, !empty($item->name) ? $item->name : "");
			$this->sheet->setCellValue('E' . $i, !empty($item->str_name) ? $item->str_name : '');
			$this->sheet->setCellValue('F' . $i, !empty($item->year_property) ? $item->year_property : '');
			$this->sheet->setCellValue('G' . $i, !empty($item->price) ? number_format($item->price) . ' VND' : '');
			$this->sheet->setCellValue('H' . $i, !empty($H) ? number_format($H) . ' VND' : 0);
			$this->sheet->setCellValue('I' . $i, !empty($I) ? number_format($I) . ' VND' : 0);
			$this->sheet->setCellValue('J' . $i, !empty($J) ? number_format($J) . ' VND' : 0);
			$this->sheet->setCellValue('K' . $i, !empty($K) ? number_format($K) . ' VND' : 0);
			$this->sheet->setCellValue('L' . $i, !empty($L) ? number_format($L) . ' VND' : 0);
			$this->sheet->setCellValue('M' . $i, !empty($M) ? number_format($M) . ' VND' : 0);
			$this->sheet->setCellValue('N' . $i, !empty($N) ? number_format($N) . ' VND' : 0);
			$this->sheet->setCellValue('O' . $i, !empty($O) ? number_format($O) . ' VND' : 0);
			$i++;
		}
	}

	public function import_depreciation_xm()
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
				if (stripos("Số Năm sử dụng", trim($sheetData[0][2])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô C định dạng bắt buộc là Số Năm sử dụng"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Phần trăm giảm trừ", trim($sheetData[0][3])) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô D định dạng bắt buộc là Phần trăm giảm trừ"
					];
					echo json_encode($response);
					return;
				}
				foreach ($sheetData as $key => $value) {
					if ($key >= 1) {
						$data = array(
							"type_property" => !empty($value["0"]) ? (trim($value["0"])) : "",
							"main_property" => !empty($value["1"]) ? (trim($value["1"])) : "",
							"year" => !empty(trim($value["2"])) ? (trim($value["2"])) : "",
							"depreciation" => !empty(trim($value["3"])) ? (trim($value["3"])) : "",
						);
						$return = $this->api->apiPost($this->user['token'], "property_valuation/import_depreciation", $data);
					}
				}
				if ($return->status == 200) {
					$response = [
						'res' => true,
						'status' => "200",
						'message' => $this->lang->line('import_success'),
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

	public function import_property_xm()
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
				if (stripos("Hãng xe", $sheetData[0][0]) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô A định dạng bắt buộc là Hãng xe"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Tên xe", $sheetData[0][1]) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô B định dạng bắt buộc là Tên xe"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Tên đầy đủ", $sheetData[0][2]) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô C định dạng bắt buộc là Tên đầy đủ"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Giá xe", $sheetData[0][3]) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô D định dạng bắt buộc là Giá xe"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Năm sản xuất", $sheetData[0][4]) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô E định dạng bắt buộc là Năm sản xuất"
					];
					echo json_encode($response);
					return;
				}

				if (stripos("Loại xe", $sheetData[0][5]) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô F định dạng bắt buộc là Loại xe"
					];
					echo json_encode($response);
					return;
				}
				foreach ($sheetData as $key => $value) {
					if ($key >= 1) {
						$data = array(
							"main_property" => !empty($value["0"]) ? (trim($value["0"])) : "",
							"name_property" => !empty($value["1"]) ? (trim($value["1"])) : "",
							"full_name" => !empty(trim($value["2"])) ? (trim($value["2"])) : "",
							"price" => !empty(trim($value["3"])) ? (trim($value["3"])) : "",
							"year" => !empty(trim($value["4"])) ? (trim($value["4"])) : "",
							"type_property" => !empty(trim($value["5"])) ? (trim($value["5"])) : "",
						);
						$return = $this->api->apiPost($this->user['token'], "property_valuation/import_list_property_moto", $data);
					}
				}
				if ($return->status == 200) {
					$response = [
						'res' => true,
						'status' => "200",
						'message' => $this->lang->line('import_success'),
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

	public function import_property_oto()
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

				if (stripos("Mã TS", $sheetData[0][0]) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô 1 định dạng bắt buộc là Mã TS"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Hãng SX", $sheetData[0][1]) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô 2 định dạng bắt buộc là Hãng SX"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Dòng Xe", $sheetData[0][2]) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô 3 định dạng bắt buộc là Dòng Xe"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Tên Xe", $sheetData[0][3]) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô 4 định dạng bắt buộc là Tên Xe"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Giá xe", $sheetData[0][4]) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô 5 định dạng bắt buộc là Giá xe"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Năm SX", $sheetData[0][5]) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô 6 định dạng bắt buộc là Năm SX"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Bổ máy", $sheetData[0][6]) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô 7 định dạng bắt buộc là Bổ máy"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Tai nạn phần đầu, đuôi (bị nhẹ)", $sheetData[0][7]) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô 8 định dạng bắt buộc là Tai nạn phần đầu, đuôi (bị nhẹ)"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Tai nạn phần đầu, đuôi (bị nặng)", $sheetData[0][8]) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô 9 định dạng bắt buộc là Tai nạn phần đầu, đuôi (bị nặng)"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Tai nạn hai bên cửa", $sheetData[0][9]) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô 10 định dạng bắt buộc là Tai nạn hai bên cửa"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Xước sơn, sơn xấu quá nửa xe", $sheetData[0][10]) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô 11 định dạng bắt buộc là Xước sơn, sơn xấu quá nửa xe"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Đèn Pha xước nhẹ, ố vàng", $sheetData[0][11]) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô 12 định dạng bắt buộc là Đèn Pha xước nhẹ, ố vàng"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Đèn xước sâu, vỡ phải thay", $sheetData[0][12]) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô 13 định dạng bắt buộc là Đèn xước sâu, vỡ phải thay"
					];
					echo json_encode($response);
					return;
				}
				if (stripos("Nội thất xấu quá 50%", $sheetData[0][13]) === false) {
					$response = [
						'res' => false,
						'status' => "400",
						'message' => "Tên ô 14 định dạng bắt buộc là Nội thất xấu quá 50%"
					];
					echo json_encode($response);
					return;
				}

				foreach ($sheetData as $key => $value) {
					if ($key >= 1) {
						$data = array(
							"code" => !empty($value["0"]) ? (trim($value["0"])) : "",
							"main_property" => !empty($value["1"]) ? (trim($value["1"])) : "",
							"type_property" => !empty(trim($value["2"])) ? (trim($value["2"])) : "",
							"full_name" => !empty(trim($value["3"])) ? (trim($value["3"])) : "",
							"price" => !empty(trim($value["4"])) ? (trim($value["4"])) : "",
							"year" => !empty(trim($value["5"])) ? (trim($value["5"])) : "",
							"bo_may" => !empty(trim($value["6"])) ? (trim($value["6"])) : "",
							"tai_nan_nhe" => !empty(trim($value["7"])) ? (trim($value["7"])) : "",
							"tai_nan_nang" => !empty(trim($value["8"])) ? (trim($value["8"])) : "",
							"tai_nan_cua" => !empty(trim($value["9"])) ? (trim($value["9"])) : "",
							"xuoc_son" => !empty(trim($value["10"])) ? (trim($value["10"])) : "",
							"den_xuoc_nhe" => !empty(trim($value["11"])) ? (trim($value["11"])) : "",
							"den_xuoc_sau" => !empty(trim($value["12"])) ? (trim($value["12"])) : "",
							"noi_that_xau" => !empty(trim($value["13"])) ? (trim($value["13"])) : "",
						);
						$return = $this->api->apiPost($this->user['token'], "property_valuation/import_list_property_oto", $data);
					}
				}
				if ($return->status == 200) {
					$response = [
						'res' => true,
						'status' => "200",
						'message' => $this->lang->line('import_success'),
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

	public function get_detai_property()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : '';
		if (!empty($id)) {
			$data['id'] = $id;
		}
		$res = $this->api->apiPost($this->user['token'], "property_valuation/get_detai_property", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", 'data' => $res->data, "msg" => $res->message)));
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

	public function block_property()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : '';
		if (!empty($id)) {
			$data['id'] = $id;
		}
		$res = $this->api->apiPost($this->user['token'], "property_valuation/block_property", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $res->message)));
			return;
		}
	}

	public function data_depreciations_moto()
	{
		$type_property = !empty($_GET['type_property']) ? $_GET['type_property'] : '';
		$vehicles = !empty($_GET['vehicles']) ? $_GET['vehicles'] : '';
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('property_valuation/data_depreciations_moto');
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 50;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];
		$main_property = $this->api->apiPost($this->user['token'], "property_valuation/get_list_main_depreciation_moto");
		if (!empty($main_property->status) && $main_property->status == 200) {
			$this->data['main_property'] = $main_property->data;
		} else {
			$this->data['main_property'] = array();
		}
		if (!empty($type_property)) {
			$data['type_property'] = $type_property;
		}
		if (!empty($vehicles)) {
			$data['vehicles'] = $vehicles;
		}
		$depreciations = $this->api->apiPost($this->user['token'], "property_valuation/data_depreciations_moto", $data);
		if (!empty($depreciations->status) && $depreciations->status == 200) {
			$config['total_rows'] = $depreciations->total;
			$this->data['depreciations'] = $depreciations->data;
			$this->data['total_rows'] = $depreciations->total;
		} else {
			$this->data['depreciations'] = array();
		}
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/property/list/list_khau_hao_xm';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function update_depreciations_moto()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : '';
		$depreciation = !empty($_POST['depreciation']) ? $_POST['depreciation'] : '';
		if (!empty($id)) {
			$data['id'] = $id;
		}
		if (!empty($depreciation)) {
			$data['depreciation'] = $depreciation;
		}
		$res = $this->api->apiPost($this->user['token'], "property_valuation/update_depreciations_moto", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $res->message)));
			return;
		} elseif (!empty($res->status) && $res->status == 401) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $res->message)));
			return;

		}
	}

	public function get_depreciation_moto()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : '';
		if (!empty($id)) {
			$data['id'] = $id;
		}
		$res = $this->api->apiPost($this->user['token'], "property_valuation/get_depreciation_moto", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $res->data, "msg" => $res->message)));
			return;
		}
	}

	public function get_configuration_formality()
	{
		$data = $this->api->apiPost($this->user['token'], "property_valuation/get_configuration_formality");
		if (!empty($data->status) && $data->status == 200) {
			$this->data['formality'] = $data->data;
		} else {
			$this->data['formality'] = array();
		}
		$this->data['template'] = 'page/property/list/list_khau_hao_hinh_thuc_vay';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function get_hinh_thuc_cc_or_dkx()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : '';
		if (!empty($id)) {
			$data['id'] = $id;
		}
		$res = $this->api->apiPost($this->user['token'], "property_valuation/get_hinh_thuc_cc_or_dkx", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $res->data, "msg" => $res->message)));
			return;
		}
	}

	public function get_hinh_thuc_tc()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : '';
		if (!empty($id)) {
			$data['id'] = $id;
		}
		$res = $this->api->apiPost($this->user['token'], "property_valuation/get_hinh_thuc_tc", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $res->data, "msg" => $res->message)));
			return;
		}
	}

	public function update_hinh_thuc_cc_or_dkx()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : '';
		$xm = !empty($_POST['xm']) ? $_POST['xm'] : '';
		$oto = !empty($_POST['oto']) ? $_POST['oto'] : '';
		if (!empty($id)) {
			$data['id'] = $id;
		}
		if (!empty($xm)) {
			$data['xm'] = $xm;
		}

		if (!empty($oto)) {
			$data['oto'] = $oto;
		}
		$res = $this->api->apiPost($this->user['token'], "property_valuation/update_hinh_thuc_cc_or_dkx", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $res->message)));
			return;
		} elseif (!empty($res->status) && $res->status == 401) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $res->message)));
			return;

		}
	}

	public function update_hinh_thuc_tc()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : '';
		$tc = !empty($_POST['tc']) ? $_POST['tc'] : '';
		if (!empty($id)) {
			$data['id'] = $id;
		}
		if (!empty($tc)) {
			$data['tc'] = $tc;
		}

		$res = $this->api->apiPost($this->user['token'], "property_valuation/update_hinh_thuc_tc", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $res->message)));
			return;
		} elseif (!empty($res->status) && $res->status == 401) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $res->message)));
			return;

		}
	}
}

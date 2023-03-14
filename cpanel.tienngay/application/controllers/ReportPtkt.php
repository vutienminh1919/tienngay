<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ReportPtkt extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("time_model");
		$this->load->model("province_model");
		$this->load->model("reason_model");
		$this->load->model("main_property_model");
		$this->load->helper('lead_helper');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->config->load('config');
		$this->load->library('pagination');
		$this->load->helper('location_helper');
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
		$this->spreadsheet = new Spreadsheet();
		$this->sheet = $this->spreadsheet->getActiveSheet();
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

	private function setStyleOrange($range)
	{
		$styles = [
			'font' =>
				[
					'name' => 'Arial',
					'bold' => false,
					'italic' => false,
					'strikethrough' => false,
					'color' => ['rgb' => '780000'],
				],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'startColor' => array('rgb' => "f4af85")
			],
			'quotePrefix' => true
		];
		$this->getStyle = $styles;
		$this->sheet->getStyle($range)->applyFromArray($styles)->getAlignment()->setHorizontal('left');
	}

	private function setStyleOrange1($range)
	{
		$styles = [
			'font' =>
				[
					'name' => 'Arial',
					'bold' => false,
					'italic' => false,
					'strikethrough' => false,
					'color' => ['rgb' => '780000'],
				],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'startColor' => array('rgb' => "f8cbac")
			],
			'quotePrefix' => true
		];
		$this->getStyle = $styles;
		$this->sheet->getStyle($range)->applyFromArray($styles)->getAlignment()->setHorizontal('left');
	}

	public function get_all_ptkt()
	{
		$resultPT = $this->api->apiPost($this->user['token'], "ReportPtkt/getSortPt");
		$this->data['pt'] = $resultPT->data[0]->data->data;
		$resultCancel = $this->api->apiPost($this->user['token'], "ReportPtkt/getSortPtCancel");
		$this->data['pt_cancel'] = $resultCancel->data[0]->data->data;
		$this->data['count_pt_cancel'] = $resultCancel->data[0]->data->count;
		$this->data['template'] = 'page/report_ptkt/report';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function sortPT()
	{
		$dataPost = $this->input->post();
		$dataPost['place'] = !empty($dataPost['store']) ? $dataPost['store'] : "";
		$resultPT = $this->api->apiPost($this->user['token'], "ReportPtkt/checkPT", $dataPost);
		$response = [
			'res' => 200,
			'message' => 'ok',
		];
		echo json_encode($response);
		return;
	}

	public function sortPTCancel()
	{
		$dataPost = $this->input->post();
		$dataPost['place'] = !empty($dataPost['store']) ? $dataPost['store'] : "";
		$resultPT = $this->api->apiPost($this->user['token'], "ReportPtkt/checkPTCancel", $dataPost);
		$response = [
			'res' => 200,
			'message' => 'ok',
		];
		echo json_encode($response);
		return;
	}

	public function excelPtkt()
	{
		$dataPost = [];
		$dataPost['start_date'] = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$dataPost['end_date'] = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$dataPost['place'] = !empty($_GET['store']) ? $_GET['store'] : "";

		$result = $this->api->apiPost($this->user['token'], "ReportPtkt/checkPT", $dataPost);
		$data = [];
		if (!empty($result->status) && $result->status == 200) {
			$data = (array)$result->data;
		} else {
			$data = [];
		}
		if (empty($data)) {
			var_dump("Không có dữ liệu để xuất excel");
		} else {
			if ($data["Tổng hợp các lệnh"]->count == 0) {
				var_dump("Không có dữ liệu để xuất excel");
			} else {
				$this->export_ptkt($data);
			}

		}

	}

	public function excelPtktCancel()
	{
		$dataPost = [];
		$dataPost['start_date'] = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$dataPost['end_date'] = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$dataPost['place'] = !empty($_GET['store']) ? $_GET['store'] : "";
		$result = $this->api->apiPost($this->user['token'], "ReportPtkt/checkPTCancel", $dataPost);
		$data = [];
		if (!empty($result->status) && $result->status == 200) {
			$data = (array)$result;
		} else {
			$data = [];
		}
		if (empty($data)) {
			var_dump("Không có dữ liệu để xuất excel");
		} else {
			if ($data["count"] == 0) {
				var_dump("Không có dữ liệu để xuất excel");
			} else {
				$this->export_ptkt_cancel($data);
			}
		}
	}

	public function export_ptkt($data)
	{

		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Loại Lệnh Phiếu thu');
		$this->sheet->setCellValue('C1', 'Số lệnh');
		$this->sheet->setCellValue('D1', 'Phần trăm trên tổng lệnh');
		$this->sheet->setCellValue('E1', 'Chi tiết các lệnh');

		$this->setStyleOrange("B2");
		$this->setStyleOrange("B6");
		$this->setStyleOrange("B7");
		$this->setStyleOrange("B10");
		$this->setStyleOrange("B11");
		$this->setStyleOrange("B14");

		$this->setStyleOrange("C2");
		$this->setStyleOrange("C6");
		$this->setStyleOrange("C7");
		$this->setStyleOrange("C10");
		$this->setStyleOrange("C11");
		$this->setStyleOrange("C14");

		$this->setStyleOrange("C2");
		$this->setStyleOrange("C6");
		$this->setStyleOrange("C7");
		$this->setStyleOrange("C10");
		$this->setStyleOrange("C11");
		$this->setStyleOrange("C14");

		$this->setStyleOrange("D2");
		$this->setStyleOrange("D6");
		$this->setStyleOrange("D7");
		$this->setStyleOrange("D10");
		$this->setStyleOrange("D11");
		$this->setStyleOrange("D14");

		$this->setStyleOrange1("B3");
		$this->setStyleOrange1("B4");
		$this->setStyleOrange1("B5");
		$this->setStyleOrange1("B8");
		$this->setStyleOrange1("B9");
		$this->setStyleOrange1("B13");
		$this->setStyleOrange1("B12");

		$this->setStyleOrange1("C3");
		$this->setStyleOrange1("C4");
		$this->setStyleOrange1("C5");
		$this->setStyleOrange1("C8");
		$this->setStyleOrange1("C9");
		$this->setStyleOrange1("C13");
		$this->setStyleOrange1("C12");

		$this->setStyleOrange1("D3");
		$this->setStyleOrange1("D4");
		$this->setStyleOrange1("D5");
		$this->setStyleOrange1("D8");
		$this->setStyleOrange1("D9");
		$this->setStyleOrange1("D13");
		$this->setStyleOrange1("D12");


		$i = 2;
		foreach ($data as $key => $tran) {
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($key) ? $key : "");
			$this->sheet->setCellValue('C' . $i, !empty($tran->count) ? $tran->count : 0);
			$this->sheet->setCellValue('D' . $i, !empty($tran->rate) ? $tran->rate . " " . '%' : 0);
			$this->sheet->setCellValue('E' . $i, !empty($tran->detail) ? $tran->detail : "");

			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('phan-loai-lenh-phieu-thu-' . time() . '.xlsx');

	}

	public function export_ptkt_cancel($data)
	{
		$count = !empty($data) ? $data['count'] : "";
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Lý do hủy PT');
		$this->sheet->setCellValue('C1', 'Tổng số lệnh');
		$this->sheet->setCellValue('D1', 'Phần trăm trên tổng lệnh');
		$this->sheet->setCellValue('E1', 'Chi tiết các lệnh');
		$i = 2;
		foreach ($data['data'] as $key => $tran) {
			$content_billing = '';
			$notes = !empty($tran->note) ? $tran->note : "";
			if (is_array($notes)) {
				foreach ($notes as $note) {
					if (count($notes) > 1) {
						$content_billing .= billing_content($note) . " | ";
					} else {
						$content_billing .= billing_content($note);
					}
				}
				$notes = $content_billing;
			} else {
				$notes = $key;
			}
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, $notes);
			$this->sheet->setCellValue('C' . $i, count($tran->detail));
			$this->sheet->setCellValue('D' . $i, !empty($tran) ? number_format(count($tran->detail) / $count * 100, 2) . " " . "%" : 0);
			$this->sheet->setCellValue('E' . $i, !empty($tran) && is_array($tran->detail) ? implode(", ", $tran->detail) : "");
			$i++;
		}
		$this->sheet->setCellValue('A' . $i, ($i - 1));
		$this->sheet->setCellValue('B' . $i, "Grand Total");
		$this->sheet->setCellValue('C' . $i, $count);
		$this->sheet->setCellValue('D' . $i, "100 %");
		//---------------------------------------------------------------------
		$this->callLibExcel('phan-loai-lenh-phieu-thu-huy' . time() . '.xlsx');

	}

	public function importFileBank()
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
					if ($key >= 1) {
						$dataPost = array(
							'date' => !empty($value['0']) ? trim($value['0']) : "",
							'code_transaction_bank' => !empty($value['1']) ? trim($value['1']) : "",
							'code_contract' => !empty($value['2']) ? trim($value['2']) : "",
							'code_contract_disbursement' => !empty($value['3']) ? trim($value['3']) : "",
							'customer_name' => !empty($value['4']) ? trim($value['4']) : "",
							'money' => !empty($value['5']) ? trim($value['5']) : "",
							'bank' => !empty($value['6']) ? trim($value['6']) : "",
							'bank_code' => !empty($value['7']) ? trim($value['7']) : "",
						);
						$ket_qua = $this->api->apiPost($this->user['token'], "reportPtkt/importBank", $dataPost);

						if ($ket_qua->status == 200) {
							$response = [
								'res' => true,
								'status' => "200",
								'message' => 'Thành công'
							];

						} else {
							$response = [
								'res' => false,
								'status' => "400",
								'msg' => "Thất bại"
							];
							echo json_encode($response);
							return;

						}
					}
				}
			} else {
				$response = [
					'res' => false,
					'status' => "400",
					'msg' => "Sai định dạng File"
				];
				echo json_encode($response);
				return;
			}

		}
		$response = [
			'res' => true,
			'status' => "200",
			'message' => 'Thành công'
		];
		echo json_encode($response);
		return;


	}



}

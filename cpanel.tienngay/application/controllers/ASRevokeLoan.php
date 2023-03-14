<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ASRevokeLoan extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model("store_model");
		$this->load->model("time_model");
		$this->load->model("contract_model");
		$this->load->library('pagination');
		$this->config->load('config');
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

		$this->tong = array(
			"valid_amount" => 0,
			"amount_actually_received" => 0,
			"total" => 0,
			"tong_chia" => 0
		);

		$this->numberRowLastColumn = 0;
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	private $tong, $numberRowLastColumn;

	private $getStyle, $spreadsheet, $sheet;

	//Thu hồi khoản vay
	public function index()
	{

		$this->data["pageName"] = "Thu hồi khoản vay";
		$this->data['template'] = 'web/accounting_system_update/revoke_loan';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function report_kt()
	{
		$start = !empty($_GET['fdate_export']) ? $_GET['fdate_export'] : "";
//		$end = !empty($_GET['fdate_export_end']) ? $_GET['fdate_export_end'] : "";

		if (empty($start)) {
			$this->session->set_flashdata('error', "Hãy chọn tháng");
			redirect(base_url('aSRevokeLoan'));
		}
		$data = array();
		if (!empty($start)) $data['start'] = $start;
		if (!empty($end)) $data['end'] = $end;

		$countBorrowed = $this->api->apiPost($this->userInfo['token'], "AccountingSystemUpdate/get_count_all", $data);
		$count = (int)$countBorrowed->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('aSRevokeLoan/report_kt?fdate_export='.$start);
		$config['total_rows'] = $count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['enable_query_strings'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;
		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];

		$infor = $this->api->apiPost($this->userInfo['token'], "AccountingSystemUpdate/revoke_loan_view", $data);


		$trans = [];
		$total = [];
		$i = 0;
		foreach ($infor->data as $item) {
			$tong_chia=round($item->so_tien_lai_da_tra + $item->so_tien_phi_da_tra + $item->so_tien_goc_da_tra +$item->so_tien_phi_cham_tra_da_tra + $item->tien_phi_phat_sinh_da_tra + $item->fee_finish_contract + $item->so_tien_phi_gia_han_da_tra+ $item->tien_thua_tat_toan +$item->tien_thua_thanh_toan_con_lai);
               
            $trans[$i]['tong_chia'] =$tong_chia;      

			$trans[$i]['date_bank'] =!empty($item->date_bank) ? date('d/m/Y', $item->date_bank) : '';
			$trans[$i]['date_pay'] = date('d/m/Y', $item->date_pay);
			$trans[$i]['created_at'] = date('d/m/Y H:i:s', $item->created_at);
			$trans[$i]['code_transaction_bank'] = !empty($item->code_transaction_bank) ? $item->code_transaction_bank : "";
			$trans[$i]['bank'] = !empty($item->bank) ? $item->bank : "";
			$trans[$i]['store'] = !empty($item->store) ? $item->store->name : "";
			$trans[$i]['code_contract_disbursement'] = $this->contract_model->getMaHopDongVay($item);
			
			$trans[$i]['customer_name'] = !empty($item->customer_name) ? $item->customer_name : $item->customer_bill_name;
			$trans[$i]['code_contract'] = !empty($item->code_contract) ? $item->code_contract : "";
			$trans[$i]['valid_amount'] = !empty($item->valid_amount) ? $item->valid_amount :0;
			$trans[$i]['payment_method'] = ($item->payment_method==1) ? "Tiền mặt" : "Chuyển khoản";
			$trans[$i]['amount_actually_received'] = !empty($item->amount_actually_received) ? $item->amount_actually_received : 0;
			$trans[$i]['type'] = ($item->type==4) ? "Thanh toán" : "Tất toán";
			$trans[$i]['total'] = !empty($item->total) ? $item->total :0;
			$content_billing = '';
			if (!empty($item->note)) {
				if (is_array($item->note)) {
					foreach ($item->note as $key => $note) {
						$content_billing .= billing_content($note).";";
					}
				} else {
					$content_billing = $transaction->note;
				}
			}
			$content_billing=is_array($item->note) ? $content_billing : $item->note;
			$trans[$i]['note'] = $content_billing;
			$trans[$i]['code'] = !empty($item->code) ? $item->code : "";
			
			
			$i++;

		}



		$this->data['trans'] = $trans;
		$this->data['total'] = $total;

		$this->data['template'] = 'web/accounting_system_update/revoke_loan';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function process()
	{
		$start = !empty($_GET['fdate_export']) ? $_GET['fdate_export'] : "";
		if (empty($start)) {
			$this->session->set_flashdata('error', "Hãy chọn tháng");
			redirect(base_url('aSRevokeLoan'));
		}
//
		$data = array();
		if (!empty($start)) $data['start'] = $start;


		if (empty($start)) {
			$this->session->set_flashdata('error', "Hãy chọn tháng");
			redirect(base_url('aSRevokeLoan'));
		}
		$data = array();
		if (!empty($start)) $data['start'] = $start;
		if (!empty($end)) $data['end'] = $end;

		$infor = $this->api->apiPost($this->userInfo['token'], "accountingSystemUpdate/revoke_loan", $data);

		//Calculate to export excel
		if (!empty($infor->data)) {
			$this->export_part1($infor->data, $start);
			$this->lastRow_Tong();

			//-------------------------------
			$this->callLibExcel('bao-cao-thu-hoi-khoan-vay-' . date('d-m-Y-H:i:s-') . $start . '.xlsx');

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
			redirect(base_url('aSRevokeLoan'));
		}
	}

	private function export_part1($infor, $start)
	{
		$this->sheet->setCellValue('A1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('B1', 'Mã hợp đồng');
		$this->sheet->setCellValue('C1', 'Mã phiếu thu');
		$this->sheet->setCellValue('D1', 'Tên khách hàng');
		$this->sheet->setCellValue('E1', 'Số tiền phải trả');
		$this->sheet->setCellValue('F1', 'Phòng giao dịch');
		$this->sheet->setCellValue('G1', 'Mã GD ngân hàng');

		$this->sheet->setCellValue('H1', 'Ngày tạo phiếu');
		$this->sheet->setCellValue('I1', 'Phương thức thanh toán');
		$this->sheet->setCellValue('J1', 'Ngân hàng');
		$this->sheet->setCellValue('K1', 'Trạng thái');

		$this->sheet->setCellValue('L1', 'Số tiền thực nhận');
		$this->sheet->setCellValue('M1', 'Loại thanh toán');
		$this->sheet->setCellValue('N1', 'Ngày khách thanh toán');
		$this->sheet->setCellValue('O1', 'Tổng tiền thanh toán');
		$this->sheet->setCellValue('P1', 'Tổng tiền đã trả');
		$this->sheet->setCellValue('Q1', 'Ngày bank nhận');
		$this->sheet->setCellValue('R1', 'Ghi chú');

		//Set style
		$this->setStyle("A1");
		$this->setStyle("B1");
		$this->setStyle("C1");
		$this->setStyle("D1");
		$this->setStyle("E1");
		$this->setStyle("F1");
		$this->setStyle("G1");
		$this->setStyle("H1");
		$this->setStyle("I1");
		$this->setStyle("J1");
		$this->setStyle("K1");
		$this->setStyle("L1");
		$this->setStyle("M1");
		$this->setStyle("N1");
		$this->setStyle("O1");
		$this->setStyle("P1");
		$this->setStyle("Q1");
		$this->setStyle("R1");
		$i = 2;
		$this->numberRowLastColumn = 2;
		$index = 1;
		$arr_so_tien_thua = [];
        	$trans = [];
		foreach ($infor as $item) {
			$content_billing = '';
			if (!empty($item->note)) {
				if (is_array($item->note)) {
					foreach ($item->note as $key => $note) {
						$content_billing .= billing_content($note).";";
					}
				} else {
					$content_billing = $transaction->note;
				}
			}
			$content_billing=is_array($item->note) ? $content_billing : $item->note;
			$tong_chia=$item->so_tien_lai_da_tra + $item->so_tien_phi_da_tra + $item->so_tien_goc_da_tra +$item->so_tien_phi_cham_tra_da_tra + $item->tien_phi_phat_sinh_da_tra + $item->fee_finish_contract + $item->so_tien_phi_gia_han_da_tra+ $item->tien_thua_tat_toan +$item->tien_thua_thanh_toan_con_lai;

			$date_bank =!empty($item->date_bank) ? date('d/m/Y', $item->date_bank) : '';
			$date_pay = date('d/m/Y', $item->date_pay);
			$created_at = date('d/m/Y H:i:s', $item->created_at);
			$code_transaction_bank= !empty($item->code_transaction_bank) ? $item->code_transaction_bank : "";
			$bank = !empty($item->bank) ? $item->bank : "";
			$store = !empty($item->store) ? $item->store->name : "";
			$code_contract_disbursement = $this->contract_model->getMaHopDongVay($item);
			
			$customer_name = !empty($item->customer_name) ? $item->customer_name : $item->customer_bill_name;
			$code_contract = !empty($item->code_contract) ? $item->code_contract : "";
			$valid_amount = !empty($item->valid_amount) ? $item->valid_amount :0;
			$payment_method = ($item->payment_method==1) ? "Tiền mặt" : "Chuyển khoản";
			$amount_actually_received = !empty($item->amount_actually_received) ? $item->amount_actually_received : 0;
			$type = ($item->type==4) ? "Thanh toán" : "Tất toán";
			$total = !empty($item->total) ? $item->total :0;

			$note = !empty($item->note) ? $item->note : "";
			$code = !empty($item->code) ? $item->code : "";

			$this->sheet->setCellValue('A' . $i, $code_contract);
			$this->sheet->setCellValue('B' . $i, $code_contract_disbursement);
			$this->sheet->setCellValue('C' . $i, $code);
			$this->sheet->setCellValue('D' . $i, $customer_name);
		
			  $this->sheet->setCellValue('E' . $i, round($valid_amount))
			 ->getStyle('E'.$i)
            ->getNumberFormat()
            ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('F' . $i, $store);
			$this->sheet->setCellValue('G' . $i, $code_transaction_bank);
			$this->sheet->setCellValue('H' . $i, $created_at);
			$this->sheet->setCellValue('I' . $i, $payment_method);
		    $this->sheet->setCellValue('J' . $i, $bank);
		     $this->sheet->setCellValue('K' . $i, "Thành công");
		  
		      $this->sheet->setCellValue('L' . $i, round($amount_actually_received))
			 ->getStyle('L'.$i)
            ->getNumberFormat()
            ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		     $this->sheet->setCellValue('M' . $i, $type);
		     $this->sheet->setCellValue('N' . $i, $date_pay);
		  
		   	  $this->sheet->setCellValue('O' . $i, round($total))
			 ->getStyle('O'.$i)
            ->getNumberFormat()
            ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
              $this->sheet->setCellValue('P' . $i, round($tong_chia))
			 ->getStyle('P'.$i)
            ->getNumberFormat()
            ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			
		
			$this->sheet->setCellValue('Q' . $i, $date_bank);
			 $this->sheet->setCellValue('R' . $i, (string)$content_billing);

            	$this->tong['valid_amount'] +=$valid_amount;
				$this->tong['amount_actually_received'] +=$amount_actually_received;
				$this->tong['total'] +=$total;
				$this->tong['tong_chia'] +=$tong_chia;
			$index++;
			$i++;
			$this->numberRowLastColumn++;
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

	private function setStyle($range)
	{
		$styles = [
			'font' =>
				[
					'name' => 'Arial',
					'bold' => false,
					'italic' => false,
					'strikethrough' => false,
					//'color' => [ 'rgb' => '808080' ]
				],
			'borders' =>
				[
					'left' =>
						[
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
							'color' => ['rgb' => '808080']
						],
					'right' =>
						[
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
							'color' => ['rgb' => '808080']
						],
					'bottom' =>
						[
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
							'color' => ['rgb' => '808080']
						],
					'top' =>
						[
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
							'color' => ['rgb' => '808080']
						]
				],
			'quotePrefix' => true
		];
		$this->getStyle = $styles;
		$this->sheet->getStyle($range)->applyFromArray($styles)->getAlignment()->setHorizontal('center');
	}

	private function lastRow_Tong()
	{
		$this->sheet->setCellValue('B' . $this->numberRowLastColumn, "Tổng")
			->getStyle('B' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)));
		//H4
		$this->sheet->setCellValue('E' . $this->numberRowLastColumn, round($this->tong['valid_amount']))
			->getStyle('E' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
            ->getNumberFormat()
            ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//I4
		$this->sheet->setCellValue('L' . $this->numberRowLastColumn, round($this->tong['amount_actually_received']))
			->getStyle('L' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
            ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//J4
		$this->sheet->setCellValue('O' . $this->numberRowLastColumn, round($this->tong['total']))
			->getStyle('O' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
            ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//K4
		$this->sheet->setCellValue('P' . $this->numberRowLastColumn, round($this->tong['tong_chia']))
			->getStyle('P' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
            ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		
	
	}

	private function getL1($item)
	{
		$method = "Tiền mặt";
		if (!empty($item->payment_method) && $item->payment_method == 1) {
			$method = "Tiền mặt";
		} elseif (!empty($item->payment_method) && $item->payment_method == 2) {
			$method = "Chuyển khoản";
		}
		return $method;
	}

	private function getM1($item)
	{
		$type = "";
		if ($item->type == 3) {
			$type = "Tất toán";
		} else if ($item->type == 4) {
			$type = "Thanh toán lãi kỳ";
		} else if ($item->type == 5) {
			$type = "Gia hạn";
		}
		if ($item->type_payment == 2) {
			$type = "Thanh toán gia hạn";
		}
		return $type;
	}

	private function getSoTienPhiDaTra($item)
	{
		$a = !empty($item->so_tien_phi_da_tra) ? $item->so_tien_phi_da_tra : 0;
		$b = !empty($item->tien_phi_phat_sinh_da_tra) ? $item->tien_phi_phat_sinh_da_tra : 0;
		$c = !empty($item->fee_finish_contract) ? $item->fee_finish_contract : 0;
		$d = !empty($item->so_tien_phi_cham_tra_da_tra) ? $item->so_tien_phi_cham_tra_da_tra : 0;
		$e = !empty($item->so_tien_phi_gia_han_da_tra) ? $item->so_tien_phi_gia_han_da_tra : 0;
		return $a + $b + $c + $d + $e;
	}
}

?>

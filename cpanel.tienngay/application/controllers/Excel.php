<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include APPPATH . '/libraries/CpanelV2.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Excel extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model("time_model");
		$this->load->model("contract_model");
		$this->load->helper('lead_helper');
		$this->load->helper('location_helper');
		$this->load->library('pagination');
		$this->load->model("reason_model");
		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
		// if (!$this->is_superadmin) {
		//     $paramController = $this->uri->segment(1);
		//     $param = strtolower($paramController);
		//     if (!in_array($param, $this->paramMenus)) {
		//         $this->session->set_flashdata('error', $this->lang->line('not_have_permission').' '.$paramController .'!');
		//         redirect(base_url('app'));
		//         return;
		//     }
		// }
		$this->spreadsheet = new Spreadsheet();
		$this->spreadsheet->setActiveSheetIndex(0);

		$this->sheet = $this->spreadsheet->getActiveSheet();
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$this->tong_Danhsachphieuthu = array();
		$this->numberRowLastColumn = 0;

	}

	private $tong_Danhsachphieuthu, $numberRowLastColumn;

	public function exportList_kt()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "";
		$type_transaction = !empty($_GET['type_transaction']) ? $_GET['type_transaction'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$allocation = !empty($_GET['allocation']) ? $_GET['allocation'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$data = array();
		$data['fdate'] = !empty($start) ? $start : '';
		$data['tdate'] = !empty($end) ? $end : '';
		$data['tab'] = $tab;
		$data['code_contract'] = $code_contract;
		$data['code_contract_disbursement'] = $code_contract_disbursement;
		$data['per_page'] = 10000;
		$data['status'] = $status;
		$data['type_transaction'] = $type_transaction;
		$data['allocation'] = $allocation;

		$contractData = $this->api->apiPost($this->userInfo['token'], "transaction/get_all_kt", $data);
		//Calculate to export excel
		if (!empty($contractData->data)) {
			$this->exportTransaction_kt($contractData->data);

			var_dump($start . ' -- ' . $end);
		} else {
			// $this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
			var_dump("Không có dữ liệu để xuất excel");


			//  redirect(base_url('transaction/list_kt?tab=all'));
		}
	}

	public function exportTransaction_kt($temporary_planData)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã HĐ');
		$this->sheet->setCellValue('C1', 'Mã Phiếu ghi');
		$this->sheet->setCellValue('D1', 'Tên khách hàng');
		$this->sheet->setCellValue('E1', 'Số tiền phải thanh toán');
		$this->sheet->setCellValue('F1', 'Hạn thanh toán');
		$this->sheet->setCellValue('G1', 'Phòng giao dịch');
		$this->sheet->setCellValue('H1', 'Ghi chú');
		$this->sheet->setCellValue('I1', 'Mã giao dịch ngân hàng');
		$this->sheet->setCellValue('J1', 'Ngày tạo phiếu');
		$this->sheet->setCellValue('K1', 'Phương thức thanh toán');
		$this->sheet->setCellValue('L1', 'Ngân hàng');
		$this->sheet->setCellValue('M1', 'Tiến trình xử lý');
		$this->sheet->setCellValue('N1', 'Số tiền thực nhận');
		$this->sheet->setCellValue('O1', 'Loại thanh toán');
		$this->sheet->setCellValue('P1', 'Ngày khách thanh toán');
		$this->sheet->setCellValue('Q1', 'Tổng tiền thanh toán');
		$this->sheet->setCellValue('R1', 'Gốc đã trả');
		$this->sheet->setCellValue('S1', 'Lãi đã trả');
		$this->sheet->setCellValue('T1', 'Phí đã trả');
		$this->sheet->setCellValue('U1', 'Phí chậm trả đã trả');
		$this->sheet->setCellValue('V1', 'Phí phát sinh đã trả');
		$this->sheet->setCellValue('W1', 'Phí trước hạn đã trả');
		$this->sheet->setCellValue('X1', 'Phí gia hạn đã trả');
		$this->sheet->setCellValue('Y1', 'Tiền thừa thanh toán');
		$this->sheet->setCellValue('Z1', 'Tiền thừa tất toán');
		$this->sheet->setCellValue('AA1', 'Gốc đã trả(MG)');
		$this->sheet->setCellValue('AB1', 'Lãi đã trả(MG)');
		$this->sheet->setCellValue('AC1', 'Phí đã trả(MG)');
		$this->sheet->setCellValue('AD1', 'Phí chậm trả đã trả(MG)');
		$this->sheet->setCellValue('AE1', 'Phí phát sinh đã trả(MG)');
		$this->sheet->setCellValue('AF1', 'Phí trước hạn đã trả(MG)');
		$this->sheet->setCellValue('AG1', 'Phí gia hạn đã trả(MG)');
		$this->sheet->setCellValue('AH1', 'Tiền thừa miễn giảm(MG)');
		$this->sheet->setCellValue('AI1', 'Tiền thiếu(GH)');
		$this->sheet->setCellValue('AJ1', 'Tổng đã trả');
		$this->sheet->setCellValue('AK1', 'Mã phiếu thu');
		$this->sheet->setCellValue('AL1', 'Ngày bank nhận');


		$i = 2;
		$this->numberRowLastColumn = 2;
		foreach ($temporary_planData as $tran) {
			$method = '';
			if (intval($tran->payment_method) == 0) {
				$method = $tran->payment_method;
			} else {
				if (intval($tran->payment_method) == 1) {
					$method = $this->lang->line('Cash');
				} else if (intval($tran->payment_method) == 2) {
					$method = 'Chuyển khoản';
				}
			}
			$content_billing = '';

			$notes = !empty($tran->note) ? $tran->note : "";
			if (is_array($notes)) {
				foreach ($notes as $note) {
					$content_billing .= billing_content($note);
				}
				$notes = $content_billing;
			} else {
				$notes = $tran->note;
			}
			$so_tien_goc_da_tra = !empty($tran->so_tien_goc_da_tra) ? $tran->so_tien_goc_da_tra : 0;
			$so_tien_lai_da_tra = !empty($tran->so_tien_lai_da_tra) ? $tran->so_tien_lai_da_tra : 0;
			$so_tien_phi_da_tra = !empty($tran->so_tien_phi_da_tra) ? $tran->so_tien_phi_da_tra : 0;
			$so_tien_phi_cham_tra_da_tra = !empty($tran->so_tien_phi_cham_tra_da_tra) ? $tran->so_tien_phi_cham_tra_da_tra : 0;
			$tien_phi_phat_sinh_da_tra = !empty($tran->tien_phi_phat_sinh_da_tra) ? $tran->tien_phi_phat_sinh_da_tra : 0;
			$fee_finish_contract = !empty($tran->fee_finish_contract) ? $tran->fee_finish_contract : 0;
			$so_tien_phi_gia_han_da_tra = !empty($tran->so_tien_phi_gia_han_da_tra) ? $tran->so_tien_phi_gia_han_da_tra : 0;
			$tien_thua_thanh_toan = !empty($tran->tien_thua_thanh_toan) ? $tran->tien_thua_thanh_toan : 0;
			$tien_thua_tat_toan = !empty($tran->tien_thua_tat_toan) ? $tran->tien_thua_tat_toan : 0;
			$total = !empty($tran->total) ? $tran->total : 0;

			$so_tien_goc_da_tra_mg = !empty($tran->chia_mien_giam->so_tien_goc_da_tra) ? $tran->chia_mien_giam->so_tien_goc_da_tra : 0;
			$so_tien_lai_da_tra_mg = !empty($tran->chia_mien_giam->so_tien_lai_da_tra) ? $tran->chia_mien_giam->so_tien_lai_da_tra : 0;
			$so_tien_phi_da_tra_mg = !empty($tran->chia_mien_giam->so_tien_phi_da_tra) ? $tran->chia_mien_giam->so_tien_phi_da_tra : 0;
			$so_tien_phi_cham_tra_da_tra_mg = !empty($tran->chia_mien_giam->so_tien_phi_cham_tra_da_tra) ? $tran->chia_mien_giam->so_tien_phi_cham_tra_da_tra : 0;
			$tien_phi_phat_sinh_da_tra_mg = !empty($tran->chia_mien_giam->so_tien_phi_phat_sinh_da_tra) ? $tran->chia_mien_giam->so_tien_phi_phat_sinh_da_tra : 0;
			$so_tien_phi_tat_toan_da_tra_mg = !empty($tran->chia_mien_giam->so_tien_phi_tat_toan_da_tra) ? $tran->chia_mien_giam->so_tien_phi_tat_toan_da_tra : 0;
			$so_tien_phi_gia_han_da_tra_mg = !empty($tran->chia_mien_giam->so_tien_phi_gia_han_da_tra) ? $tran->chia_mien_giam->so_tien_phi_gia_han_da_tra : 0;
			$tien_thua_mien_giam_mg = !empty($tran->chia_mien_giam->tien_thua_mien_giam) ? $tran->chia_mien_giam->tien_thua_mien_giam : 0;
			$so_tien_thieu = !empty($tran->so_tien_thieu) ? $tran->so_tien_thieu : 0;
			$tong_chi = $so_tien_goc_da_tra + $so_tien_lai_da_tra + $so_tien_phi_da_tra + $so_tien_phi_cham_tra_da_tra + $tien_phi_phat_sinh_da_tra + $fee_finish_contract + $so_tien_phi_gia_han_da_tra + $tien_thua_tat_toan + $tien_thua_thanh_toan + $so_tien_goc_da_tra_mg + $so_tien_lai_da_tra_mg + $so_tien_phi_da_tra_mg + $so_tien_phi_cham_tra_da_tra_mg + $tien_phi_phat_sinh_da_tra_mg + $so_tien_phi_tat_toan_da_tra_mg + $so_tien_phi_gia_han_da_tra_mg + $tien_thua_mien_giam_mg;

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($tran->code_contract_disbursement) ? $tran->code_contract_disbursement : "");
			$this->sheet->setCellValue('C' . $i, !empty($tran->code_contract) ? $tran->code_contract : "");
			$this->sheet->setCellValue('D' . $i, !empty($tran->full_name) ? $tran->full_name : $tran->customer_bill_name);
			$this->sheet->setCellValue('E' . $i, !empty($tran->detail->total_paid) ? $tran->detail->total_paid : 0);
			$this->sheet->setCellValue('F' . $i, !empty($tran->detail->ngay_ky_tra) ? date('d/m/Y', intval($tran->detail->ngay_ky_tra)) : "");
			$this->sheet->setCellValue('G' . $i, !empty($tran->store) ? $tran->store->name : "");
			$this->sheet->setCellValue('H' . $i, $notes);
			$this->sheet->setCellValue('I' . $i, !empty($tran->code_transaction_bank) ? $tran->code_transaction_bank : "");
			$this->sheet->setCellValue('J' . $i, !empty($tran->created_at) ? date('d/m/Y H:i:s', intval($tran->created_at)) : '');
			$this->sheet->setCellValue('K' . $i, $method);
			$this->sheet->setCellValue('L' . $i, !empty($tran->bank) ? $tran->bank : '');
			$this->sheet->setCellValue('M' . $i, !empty($tran->status) ? status_transaction($tran->status) : "");
			$this->sheet->setCellValue('N' . $i, !empty($tran->amount_actually_received) ? $tran->amount_actually_received : 0);
			$this->sheet->setCellValue('O' . $i, !empty($tran->type) ? type_transaction($tran->type) : "");
			$this->sheet->setCellValue('P' . $i, !empty($tran->date_pay) ? date('d/m/Y H:i:s', intval($tran->date_pay)) : '');
			$this->sheet->setCellValue('Q' . $i, (!empty($tran->total) && $tran->total > 0) ? $tran->total : 0);
			$this->sheet->setCellValue('R' . $i, !empty($tran->so_tien_goc_da_tra) ? round($tran->so_tien_goc_da_tra) : 0);
			$this->sheet->setCellValue('S' . $i, !empty($tran->so_tien_lai_da_tra) ? round($tran->so_tien_lai_da_tra) : 0);
			$this->sheet->setCellValue('T' . $i, !empty($tran->so_tien_phi_da_tra) ? round($tran->so_tien_phi_da_tra) : 0);
			$this->sheet->setCellValue('U' . $i, !empty($tran->so_tien_phi_cham_tra_da_tra) ? round($tran->so_tien_phi_cham_tra_da_tra) : 0);
			$this->sheet->setCellValue('V' . $i, !empty($tran->tien_phi_phat_sinh_da_tra) ? round($tran->tien_phi_phat_sinh_da_tra) : 0);
			$this->sheet->setCellValue('W' . $i, !empty($tran->fee_finish_contract) ? round($tran->fee_finish_contract) : 0);
			$this->sheet->setCellValue('X' . $i, !empty($tran->so_tien_phi_gia_han_da_tra) ? round($tran->so_tien_phi_gia_han_da_tra) : 0);
			$this->sheet->setCellValue('Y' . $i, !empty($tran->tien_thua_thanh_toan) ? round($tran->tien_thua_thanh_toan) : 0);
			$this->sheet->setCellValue('Z' . $i, !empty($tran->tien_thua_tat_toan) ? round($tran->tien_thua_tat_toan) : 0);
			$this->sheet->setCellValue('AA' . $i, round($so_tien_goc_da_tra_mg));
			$this->sheet->setCellValue('AB' . $i, round($so_tien_lai_da_tra_mg));
			$this->sheet->setCellValue('AC' . $i, round($so_tien_phi_da_tra_mg));
			$this->sheet->setCellValue('AD' . $i, round($so_tien_phi_cham_tra_da_tra_mg));
			$this->sheet->setCellValue('AE' . $i, round($tien_phi_phat_sinh_da_tra_mg));
			$this->sheet->setCellValue('AF' . $i, round($so_tien_phi_tat_toan_da_tra_mg));
			$this->sheet->setCellValue('AG' . $i, round($so_tien_phi_gia_han_da_tra_mg));
			$this->sheet->setCellValue('AH' . $i, round($tien_thua_mien_giam_mg));
			$this->sheet->setCellValue('AI' . $i, round($so_tien_thieu));
			$this->sheet->setCellValue('AJ' . $i, round($tong_chi));
			$this->sheet->setCellValue('AK' . $i, !empty($tran->code) ? $tran->code : 0);
			$this->sheet->setCellValue('AL' . $i, !empty($tran->date_bank) ? date('d/m/Y H:i:s', intval($tran->date_bank)) : '');
			$this->tong_Danhsachphieuthu['so_tien_goc_da_tra_mg'] = $this->tong_Danhsachphieuthu['so_tien_goc_da_tra_mg'] + $so_tien_goc_da_tra_mg;
			$this->tong_Danhsachphieuthu['so_tien_lai_da_tra_mg'] = $this->tong_Danhsachphieuthu['so_tien_lai_da_tra_mg'] + $so_tien_lai_da_tra_mg;
			$this->tong_Danhsachphieuthu['so_tien_phi_da_tra_mg'] = $this->tong_Danhsachphieuthu['so_tien_phi_da_tra_mg'] + $so_tien_phi_da_tra_mg;
			$this->tong_Danhsachphieuthu['so_tien_phi_cham_tra_da_tra_mg'] = $this->tong_Danhsachphieuthu['so_tien_phi_cham_tra_da_tra_mg'] + $so_tien_phi_cham_tra_da_tra_mg;
			$this->tong_Danhsachphieuthu['tien_phi_phat_sinh_da_tra_mg'] = $this->tong_Danhsachphieuthu['tien_phi_phat_sinh_da_tra_mg'] + $tien_phi_phat_sinh_da_tra_mg;
			$this->tong_Danhsachphieuthu['so_tien_phi_tat_toan_da_tra_mg'] = $this->tong_Danhsachphieuthu['so_tien_phi_tat_toan_da_tra_mg'] + $so_tien_phi_tat_toan_da_tra_mg;
			$this->tong_Danhsachphieuthu['so_tien_phi_gia_han_da_tra_mg'] = $this->tong_Danhsachphieuthu['so_tien_phi_gia_han_da_tra_mg'] + $so_tien_phi_gia_han_da_tra_mg;
			$this->tong_Danhsachphieuthu['tien_thua_mien_giam_mg'] = $this->tong_Danhsachphieuthu['tien_thua_mien_giam_mg'] + $tien_thua_mien_giam_mg;
			$this->tong_Danhsachphieuthu['so_tien_thieu'] = $this->tong_Danhsachphieuthu['so_tien_thieu'] + $so_tien_thieu;
			$this->tong_Danhsachphieuthu['so_tien_goc_da_tra'] = $this->tong_Danhsachphieuthu['so_tien_goc_da_tra'] + $so_tien_goc_da_tra;
			$this->tong_Danhsachphieuthu['so_tien_lai_da_tra'] = $this->tong_Danhsachphieuthu['so_tien_lai_da_tra'] + $so_tien_lai_da_tra;
			$this->tong_Danhsachphieuthu['so_tien_phi_da_tra'] = $this->tong_Danhsachphieuthu['so_tien_phi_da_tra'] + $so_tien_phi_da_tra;
			$this->tong_Danhsachphieuthu['so_tien_phi_cham_tra_da_tra'] = $this->tong_Danhsachphieuthu['so_tien_phi_cham_tra_da_tra'] + $so_tien_phi_cham_tra_da_tra;
			$this->tong_Danhsachphieuthu['tien_phi_phat_sinh_da_tra'] = $this->tong_Danhsachphieuthu['tien_phi_phat_sinh_da_tra'] + $tien_phi_phat_sinh_da_tra;
			$this->tong_Danhsachphieuthu['fee_finish_contract'] = $this->tong_Danhsachphieuthu['fee_finish_contract'] + $fee_finish_contract;
			$this->tong_Danhsachphieuthu['so_tien_phi_gia_han_da_tra'] = $this->tong_Danhsachphieuthu['so_tien_phi_gia_han_da_tra'] + $so_tien_phi_gia_han_da_tra;
			$this->tong_Danhsachphieuthu['tien_thua_thanh_toan'] = $this->tong_Danhsachphieuthu['tien_thua_thanh_toan'] + $tien_thua_thanh_toan;
			$this->tong_Danhsachphieuthu['tien_thua_tat_toan'] = $this->tong_Danhsachphieuthu['tien_thua_tat_toan'] + $tien_thua_tat_toan;
			$this->tong_Danhsachphieuthu['total'] = $this->tong_Danhsachphieuthu['total'] + $total;
			$this->tong_Danhsachphieuthu['tong_chi'] = $this->tong_Danhsachphieuthu['tong_chi'] + $tong_chi;
			$this->numberRowLastColumn++;
			$i++;
		}
		$this->sheet->setCellValue('B' . $this->numberRowLastColumn, "Tổng")
			->getStyle('B' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)));
		//N4
		$this->sheet->setCellValue('Q' . $this->numberRowLastColumn, round($this->tong_Danhsachphieuthu['total']))
			->getStyle('Q' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)));
		$this->sheet->setCellValue('R' . $this->numberRowLastColumn, round($this->tong_Danhsachphieuthu['so_tien_goc_da_tra']))
			->getStyle('R' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)));
		//P4
		$this->sheet->setCellValue('S' . $this->numberRowLastColumn, round($this->tong_Danhsachphieuthu['so_tien_lai_da_tra']))
			->getStyle('S' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)));

		//Q4
		$this->sheet->setCellValue('T' . $this->numberRowLastColumn, round($this->tong_Danhsachphieuthu['so_tien_phi_da_tra']))
			->getStyle('T' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)));
		//Q4
		$this->sheet->setCellValue('U' . $this->numberRowLastColumn, round($this->tong_Danhsachphieuthu['so_tien_phi_cham_tra_da_tra']))
			->getStyle('U' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)));
		//Q4
		$this->sheet->setCellValue('V' . $this->numberRowLastColumn, round($this->tong_Danhsachphieuthu['tien_phi_phat_sinh_da_tra']))
			->getStyle('V' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)));
		$this->sheet->setCellValue('W' . $this->numberRowLastColumn, round($this->tong_Danhsachphieuthu['fee_finish_contract']))
			->getStyle('W' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)));
		$this->sheet->setCellValue('W' . $this->numberRowLastColumn, round($this->tong_Danhsachphieuthu['fee_finish_contract']))
			->getStyle('W' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)));
		$this->sheet->setCellValue('X' . $this->numberRowLastColumn, round($this->tong_Danhsachphieuthu['so_tien_phi_gia_han_da_tra']))
			->getStyle('X' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)));
		$this->sheet->setCellValue('Y' . $this->numberRowLastColumn, round($this->tong_Danhsachphieuthu['tien_thua_thanh_toan']))
			->getStyle('Y' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)));
		$this->sheet->setCellValue('Z' . $this->numberRowLastColumn, round($this->tong_Danhsachphieuthu['tien_thua_tat_toan']))
			->getStyle('Z' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)));
		$this->sheet->setCellValue('AJ' . $this->numberRowLastColumn, round($this->tong_Danhsachphieuthu['tong_chi']))
			->getStyle('AJ' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)));

		$this->sheet->setCellValue('AA' . $this->numberRowLastColumn, round($this->tong_Danhsachphieuthu['so_tien_goc_da_tra_mg']))
			->getStyle('AA' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)));
		$this->sheet->setCellValue('AB' . $this->numberRowLastColumn, round($this->tong_Danhsachphieuthu['so_tien_lai_da_tra_mg']))
			->getStyle('AB' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)));
		$this->sheet->setCellValue('AC' . $this->numberRowLastColumn, round($this->tong_Danhsachphieuthu['so_tien_phi_da_tra_mg']))
			->getStyle('AC' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)));
		$this->sheet->setCellValue('AD' . $this->numberRowLastColumn, round($this->tong_Danhsachphieuthu['so_tien_phi_cham_tra_da_tra_mg']))
			->getStyle('AD' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)));
		$this->sheet->setCellValue('AE' . $this->numberRowLastColumn, round($this->tong_Danhsachphieuthu['tien_phi_phat_sinh_da_tra_mg']))
			->getStyle('AE' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)));
		$this->sheet->setCellValue('AF' . $this->numberRowLastColumn, round($this->tong_Danhsachphieuthu['so_tien_phi_tat_toan_da_tra_mg']))
			->getStyle('AF' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)));
		$this->sheet->setCellValue('AG' . $this->numberRowLastColumn, round($this->tong_Danhsachphieuthu['so_tien_phi_gia_han_da_tra_mg']))
			->getStyle('AG' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)));
		$this->sheet->setCellValue('AH' . $this->numberRowLastColumn, round($this->tong_Danhsachphieuthu['tien_thua_mien_giam_mg']))
			->getStyle('AH' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)));
		$this->sheet->setCellValue('AI' . $this->numberRowLastColumn, round($this->tong_Danhsachphieuthu['so_tien_thieu']))
			->getStyle('AI' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)));
		//---------------------------------------------------------------------
		$this->callLibExcel('danh-sach-phieu-thu-' . time() . '.xlsx');
	}

	public function exportListTemporary_plan()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$data = array();
		$data['fdate'] = !empty($start) ? $start : date('Y-m-d');
		$data['tdate'] = !empty($end) ? $end : date('Y-m-d');
		$data['tab'] = $tab;
		$data['per_page'] = 100000;
		$contractData = $this->api->apiPost($this->userInfo['token'], "temporary_plan_contract/get_all", $data);
		//Calculate to export excel
		if (!empty($contractData->data)) {
			$this->exportTemporary_plan($contractData->data);
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
			// redirect(base_url('lead_custom/list_transfe_office'));
		}
	}

	public function exportTemporary_plan($temporary_planData)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã HĐ');
		$this->sheet->setCellValue('C1', 'Mã Phiếu ghi');
		$this->sheet->setCellValue('D1', 'Tên khách hàng');
		$this->sheet->setCellValue('E1', 'Số tiền phải thanh toán');
		$this->sheet->setCellValue('F1', 'Mã ngân lượng');
		$this->sheet->setCellValue('G1', 'Hạn thanh toán');
		$this->sheet->setCellValue('H1', 'Phòng giao dịch');
		$this->sheet->setCellValue('I1', 'Trạng thái');
		$this->sheet->setCellValue('J1', 'Ghi chú');


		$i = 2;
		foreach ($temporary_planData as $tran) {

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($tran->code_contract_disbursement) ? $tran->code_contract_disbursement : "");
			$this->sheet->setCellValue('C' . $i, !empty($tran->code_contract) ? $tran->code_contract : "");
			$this->sheet->setCellValue('D' . $i, !empty($tran->customer_infor->customer_name) ? $tran->customer_infor->customer_name : "");
			$this->sheet->setCellValue('E' . $i, (!empty($tran->detail->total_paid) && $tran->detail->total_paid > 0) ? number_format($tran->detail->total_paid, 0, ',', ',') : "");
			$this->sheet->setCellValue('F' . $i, !empty($tran->response_get_transaction_withdrawal_status_nl->transaction_id) ? $tran->response_get_transaction_withdrawal_status_nl->transaction_id : '');
			$this->sheet->setCellValue('G' . $i, !empty($tran->detail->ngay_ky_tra) ? date('d/m/Y', intval($tran->detail->ngay_ky_tra)) : "");
			$this->sheet->setCellValue('H' . $i, !empty($tran->store) ? $tran->store->name : "");
			$this->sheet->setCellValue('I' . $i, !empty($tran->status) ? contract_status($tran->status) : "");
			$this->sheet->setCellValue('J' . $i, !empty($tran->note) ? $tran->note : "");

			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('danh-sach-quan-li-lai-phi-' . time() . '.xlsx');
	}

	public function doLead_hoiso()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$cvkd = !empty($_GET['cvkd']) ? $_GET['cvkd'] : "";
		$code_store = !empty($_GET['code_store']) ? $_GET['code_store'] : "";
		$source_pgd = !empty($_GET['source_pgd']) ? $_GET['source_pgd'] : "";
		$pgd_status = !empty($_GET['pgd_status']) ? $_GET['pgd_status'] : "";

		$data = array();
		$group = ['van-hanh', 'giao-dich-vien', 'super-admin', 'cua-hang-truong', "quan-ly-khu-vuc"];
		if (!empty($start)) $data['start'] = $start;
		if (!empty($end)) $data['end'] = $end;
		if (!empty($cvkd)) $data['cvkd'] = $cvkd;
		if (!empty($code_store)) {
			$data['code_store'] = $code_store;
		} else {
			$list_store = array();
			if (count(array_intersect($this->data['groupRoles_s'], $group)) > 0 || $this->is_superadmin) {
				$data['code_store'] = array_column($this->data['userRoles']->role_stores, 'store_id');
			}
		}
		if (!empty($source_pgd)) $data['source_pgd'] = $source_pgd;
		if (count(array_intersect($this->data['groupRoles_s'], $group)) > 0) {
			$storeData = $this->api->apiPost($this->user['token'], "store/get_all");
			if (!empty($storeData->status) && $storeData->status == 200) {
				$list_store = $storeData->data;
			} else {
				$list_store = array();
			}
		} else {
			$list_store = $this->data['userSession']['stores'];
		}
		if (!empty($pgd_status)) {
			$data['status_pgd'] = $pgd_status;
		}

		// $storeData = $this->api->apiPost($this->user['token'], "store/get_all");
		// var_dump($storeData); die;
		// if (!empty($storeData->status) && $storeData->status == 200) {
		// 	$list_store = $storeData->data;
		// } else {
		// 	$list_store = array();
		// }

		$contractData = $this->api->apiPost($this->userInfo['token'], "lead_custom/get_lead", $data);
		// $contractData = $this->api->apiPost($this->userInfo['token'], "lead_custom/get_all", $data);
		//Calculate to export excel
		if (!empty($contractData->data)) {
			$this->exportLead_hoiso($contractData->data, $list_store);
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
			// redirect(base_url('lead_custom/list_transfe_office'));
		}
	}

	public function exportLead_hoiso($leadsData, $list_store)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'NGÀY THÁNG');
		$this->sheet->setCellValue('C1', 'HỌ VÀ TÊN');
		$this->sheet->setCellValue('D1', 'SỐ ĐIỆN THOẠI');
		$this->sheet->setCellValue('E1', 'TRẠNG THÁI PGD');
		$this->sheet->setCellValue('F1', 'TÌNH TRẠNG LEAD');
		$this->sheet->setCellValue('G1', 'TRẠNG THÁI HĐ');
		$this->sheet->setCellValue('H1', 'NGUỒN');
		$this->sheet->setCellValue('I1', 'UTM SOURCE');
		$this->sheet->setCellValue('J1', 'UTM CAMPAIGN');
		$this->sheet->setCellValue('K1', 'CHUYỂN ĐẾN PGD');
		$this->sheet->setCellValue('L1', 'XÁC NHẬN');
		$this->sheet->setCellValue('M1', 'SẢN PHẨM VAY');
		$this->sheet->setCellValue('N1', 'VỊ TRÍ/CHỨC VỤ');
		$this->sheet->setCellValue('O1', 'CVKD');
		$reasonData = $this->api->apiPost($this->user['token'], "reason/get_all", []);
		$arr_reason = [];
		if (!empty($reasonData))
			foreach ($reasonData->data as $reason) {

				$arr_reason[$reason->code_reason] = $reason->reason_name;

			}
		// /var_dump($arr_reason); die;

		$i = 2;
		foreach ($leadsData as $lead) {

			$data['phone'] = $lead->phone_number;

			$checkContract = $this->api->apiPost($this->userInfo['token'], "contract/search_phone", $data);

			unset($status_hd);
			if (!empty($checkContract->data) && $checkContract->status == 200) {
				if (!empty($checkContract->data[0]->status)) {
					foreach (contract_status() as $key => $item) {
						if ($key == $checkContract->data[0]->status) {
							$status_hd = $item;
						}
					}
				}
			}

			if (!empty($lead->id_PDG)) {
				foreach ($list_store as $key => $value) {
					if ($value->_id->{'$oid'} == $lead->id_PDG) {
						$name_store = $value->name;
					}
				}
			} else {
				$name_store = "";
			}
			$tinh_trang_lead = '';
			if (!empty($lead->status_pgd)) {

				if ($lead->status_pgd == 16 && !empty($lead->reason_cancel_pgd)) {
					$tinh_trang_lead = $arr_reason[(int)$lead->reason_cancel_pgd];
				} else if ($lead->status_pgd == 17 && !empty($lead->reason_process)) {
					$tinh_trang_lead = reason_process((int)$lead->reason_process);
				} else if ($lead->status_pgd == 8 && !empty($lead->reason_return)) {
					$tinh_trang_lead = reason_return((int)$lead->reason_return);
				} else {
					$tinh_trang_lead = '';
				}
			} else {
				$tinh_trang_lead = '';
			}

			$nguon = "";
			$nguon = lead_nguon($lead->source);
			if ($nguon == "") {
				$nguon = lead_nguon_pgd($lead->source);
			}

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($lead->office_at) ? date('d/m/Y H:i:s', $lead->office_at) : date('d/m/Y H:i:s', $lead->updated_at));
			$this->sheet->setCellValue('C' . $i, ($lead->fullname) ? $lead->fullname : '');
			$this->sheet->setCellValue('D' . $i, !empty($lead->phone_number) ? hide_phone($lead->phone_number) : "");
			$this->sheet->setCellValue('E' . $i, ($lead->status_pgd) ? status_pgd((int)$lead->status_pgd, false) : status_pgd(0));
			$this->sheet->setCellValue('F' . $i, $tinh_trang_lead);
			// $this->sheet->setCellValue('G' . $i, !empty($lead->status_contract) ? contract_status((int)$lead->status_contract, false) : contract_status(0));
			$this->sheet->setCellValue('G' . $i, !empty($lead->status_contract) ? contract_status((int)$lead->status_contract, false) : (!empty($status_hd) ? $status_hd : ""));
			$this->sheet->setCellValue('H' . $i, !empty($nguon) ? $nguon : '');
			$this->sheet->setCellValue('I' . $i, ($lead->utm_source) ? $lead->utm_source : "");
			$this->sheet->setCellValue('I' . $i, ($lead->utm_campaign) ? $lead->utm_campaign : '');
			$this->sheet->setCellValue('K' . $i, $name_store);
			$this->sheet->setCellValue('L' . $i, !empty($lead->confirm) ? $lead->confirm : "");
			$this->sheet->setCellValue('M' . $i, !empty($lead->type_finance) ? lead_type_finance($lead->type_finance) : '');
			$this->sheet->setCellValue('N' . $i, !empty($lead->position) ? ($lead->position) : '');
			$this->sheet->setCellValue('O' . $i, !empty($lead->cvkd) ? ($lead->cvkd) : '');

			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('danh-sach-lead-hoi-so-' . time() . '.xlsx');
	}

	public function exportListGic()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$isEasy = !empty($_GET['isEasy']) ? $_GET['isEasy'] : "";
		$data = array();
		if (!empty($start)) $data['start'] = $start;
		if (!empty($end)) $data['end'] = $end;

		$data['access_token'] = $this->user['token'];
		$cpanelV2 = CpanelV2::getDomain();
		if ($isEasy) {
			$url = $cpanelV2 . "cpanel/exportExcel/exportGicEasy?";
		} else {
			$url = $cpanelV2 . "cpanel/exportExcel/exportGic?";
		}
		$first = true;
		foreach ($data as $key => $value) {
			if ($first) {
				$url .= $key . "=" . $value;
			} else {
				$url .= "&" . $key . "=" . $value;
			}
			$first = false;
		}
		redirect($url);

		// $data['isEasy'] = $isEasy;
		// if ($isEasy) {
		// 	$listGicData = $this->api->apiPost($this->userInfo['token'], "gic_easy/get_all", $data);
		// } else {
		// 	$listGicData = $this->api->apiPost($this->userInfo['token'], "gic/get_all", $data);
		// }
		// if (!empty($listGicData->data)) {
		// 	$this->fcExportListGic($listGicData->data, $isEasy);
		// } else {
		// 	$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		// 	// redirect(base_url('lead_custom/list_transfe_office'));
		// }
	}

	public function fcExportListGic($listGicData, $isEasy)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'MÃ HỢP ĐỒNG');
		$this->sheet->setCellValue('C1', 'MÃ HỢP ĐỒNG BẢO HIỂM');
		$this->sheet->setCellValue('D1', 'NGƯỜI ĐƯỢC BẢO HIỂM');
		if ($isEasy) {
			$this->sheet->setCellValue('E1', 'GÓI BẢO HIỂM');
		} else {
			$this->sheet->setCellValue('E1', 'SỐ TIỀN VAY');
		}
		$this->sheet->setCellValue('F1', 'PHÍ BẢO HIỂM');
		$this->sheet->setCellValue('G1', 'PGD');
		$this->sheet->setCellValue('H1', 'NGÀY HIỆU LỰC/NGÀY HẾT HẠN');
		$this->sheet->setCellValue('I1', 'TRẠNG THÁI GIC');
		$this->sheet->setCellValue('J1', 'NGÀY TẠO');
		$this->sheet->setCellValue('K1', 'NGƯỜI TẠO');


		$i = 2;
		foreach ($listGicData as $gic) {
			$store_name = "";
			$store = $gic->contract_info->store;
			foreach (array($store) as $key => $store_by_contract) {
				$store_name = $store_by_contract->name;
			}
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, $gic->code_contract_disbursement ? $gic->code_contract_disbursement : '');
			$this->sheet->setCellValue('C' . $i, $gic->gic_code ? $gic->gic_code : '');
			$this->sheet->setCellValue('D' . $i, ($gic->gic_info->thongTinNguoiDuocBaoHiem_CaNhan_Ten ? $gic->gic_info->thongTinNguoiDuocBaoHiem_CaNhan_Ten : '') . '/' . ($gic->contract_info->customer_infor->customer_BOD ? $gic->contract_info->customer_infor->customer_BOD : '') . '/' . ($gic->gic_info->thongTinNguoiDuocBaoHiem_CaNhan_Email ? $gic->gic_info->thongTinNguoiDuocBaoHiem_CaNhan_Email : '') . '/' . ($gic->gic_info->thongTinNguoiDuocBaoHiem_CaNhan_SoDienThoai ? $gic->gic_info->thongTinNguoiDuocBaoHiem_CaNhan_SoDienThoai : ''));
			if ($isEasy) {
				$this->sheet->setCellValue('E' . $i, $gic->contract_info->loan_infor->code_GIC_easy ? $gic->contract_info->loan_infor->code_GIC_easy : '');
			} else {
				$this->sheet->setCellValue('E' . $i, $gic->gic_info->noiDungBaoHiem_GiaTriKhoanVay ? $gic->gic_info->noiDungBaoHiem_GiaTriKhoanVay : '');
			}
			$this->sheet->setCellValue('F' . $i, $gic->gic_info->noiDungBaoHiem_PhiBaoHiem_VAT ? $gic->gic_info->noiDungBaoHiem_PhiBaoHiem_VAT : '');
			$this->sheet->setCellValue('G' . $i, $store_name ? $store_name : "");
			$this->sheet->setCellValue('H' . $i, ($gic->gic_info->noiDungBaoHiem_NgayHieuLucBaoHiem ? $gic->gic_info->noiDungBaoHiem_NgayHieuLucBaoHiem : '') . '/' . ($gic->gic_info->noiDungBaoHiem_NgayHieuLucBaoHiemDen ? $gic->gic_info->noiDungBaoHiem_NgayHieuLucBaoHiemDen : ''));
			$this->sheet->setCellValue('I' . $i, $gic->status != "3" ? $this->get_tt_gic($gic->gic_info->thongTinChung_TrangThaiHdId ? $gic->gic_info->thongTinChung_TrangThaiHdId : '') : "Đã hủy");
			$this->sheet->setCellValue('J' . $i, $gic->created_at ? date('m/d/Y H:i:s', $gic->created_at) : "");
			$this->sheet->setCellValue('K' . $i, $gic->contract_info->created_by ? $gic->contract_info->created_by : "");

			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('danh-sach-hop-dong-bao-hiem' . ($isEasy ? '-easy' : '') . '-' . time() . '.xlsx');
	}

	public function exportListGic_plt()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$isEasy = !empty($_GET['isEasy']) ? $_GET['isEasy'] : "";
		$data = array();
		if (!empty($start)) $data['start'] = $start;
		if (!empty($end)) $data['end'] = $end;

		$data['access_token'] = $this->user['token'];
		$cpanelV2 = CpanelV2::getDomain();
		$url = $cpanelV2 . "cpanel/exportExcel/exportGic_plt?";
		
		$first = true;
		foreach ($data as $key => $value) {
			if ($first) {
				$url .= $key . "=" . $value;
			} else {
				$url .= "&" . $key . "=" . $value;
			}
			$first = false;
		}
		redirect($url);
	}

	public function fcExportListGic_plt($listGicData, $isEasy)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'MÃ HỢP ĐỒNG');
		$this->sheet->setCellValue('C1', 'MÃ HỢP ĐỒNG BẢO HIỂM');
		$this->sheet->setCellValue('D1', 'NGƯỜI ĐƯỢC BẢO HIỂM');
		if ($isEasy) {
			$this->sheet->setCellValue('E1', 'GÓI BẢO HIỂM');
		} else {
			$this->sheet->setCellValue('E1', 'SỐ TIỀN VAY');
		}
		$this->sheet->setCellValue('F1', 'PHÍ BẢO HIỂM');
		$this->sheet->setCellValue('G1', 'NGÀY HIỆU LỰC/NGÀY HẾT HẠN');
		$this->sheet->setCellValue('H1', 'TRẠNG THÁI GIC');
		$this->sheet->setCellValue('I1', 'NGÀY TẠO');
		$this->sheet->setCellValue('J1', 'NGƯỜI TẠO');


		$i = 2;
		foreach ($listGicData as $gic) {
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, $gic->code_contract_disbursement ? $gic->code_contract_disbursement : '');
			$this->sheet->setCellValue('C' . $i, $gic->gic_code ? $gic->gic_code : '');
			$this->sheet->setCellValue('D' . $i, ($gic->gic_info->thongTinNguoiDuocBaoHiem_CaNhan_Ten ? $gic->gic_info->thongTinNguoiDuocBaoHiem_CaNhan_Ten : '') . '/' . ($gic->contract_info->customer_infor->customer_BOD ? $gic->contract_info->customer_infor->customer_BOD : '') . '/' . ($gic->gic_info->thongTinNguoiDuocBaoHiem_CaNhan_Email ? $gic->gic_info->thongTinNguoiDuocBaoHiem_CaNhan_Email : '') . '/' . ($gic->gic_info->thongTinNguoiDuocBaoHiem_CaNhan_SoDienThoai ? $gic->gic_info->thongTinNguoiDuocBaoHiem_CaNhan_SoDienThoai : ''));
			if ($isEasy) {
				$this->sheet->setCellValue('E' . $i, $gic->contract_info->loan_infor->code_GIC_easy ? $gic->contract_info->loan_infor->code_GIC_easy : '');
			} else {
				$this->sheet->setCellValue('E' . $i, $gic->gic_info->noiDungBaoHiem_GiaTriKhoanVay ? $gic->gic_info->noiDungBaoHiem_GiaTriKhoanVay : '');
			}
			$this->sheet->setCellValue('F' . $i, $gic->gic_info->noiDungBaoHiem_PhiBaoHiem_VAT ? $gic->gic_info->noiDungBaoHiem_PhiBaoHiem_VAT : '');
			$this->sheet->setCellValue('G' . $i, ($gic->gic_info->noiDungBaoHiem_NgayHieuLucBaoHiem ? $gic->gic_info->noiDungBaoHiem_NgayHieuLucBaoHiem : '') . '/' . ($gic->gic_info->noiDungBaoHiem_NgayHieuLucBaoHiemDen ? $gic->gic_info->noiDungBaoHiem_NgayHieuLucBaoHiemDen : ''));
			$this->sheet->setCellValue('H' . $i, $gic->status != "3" ? $this->get_tt_gic($gic->gic_info->thongTinChung_TrangThaiHdId ? $gic->gic_info->thongTinChung_TrangThaiHdId : '') : "Đã hủy");
			$this->sheet->setCellValue('I' . $i, $gic->created_at ? date('h/d/Y H:i:s', $gic->created_at) : '');
			$this->sheet->setCellValue('J' . $i, $gic->contract_info->created_by ? $gic->contract_info->created_by : '');

			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('danh-sach-hop-dong-bao-hiem-plt-' . time() . '.xlsx');
	}

	public function exportLeadFullInfo()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$source = !empty($_GET['source']) ? $_GET['source'] : "";
		$utm_source = !empty($_GET['utm_source']) ? $_GET['utm_source'] : "";
		$utm_campaign = !empty($_GET['utm_campaign']) ? $_GET['utm_campaign'] : "";
		$isExport = !empty($_GET['isExport']) ? $_GET['isExport'] : "";
		$code_store = array();
		$url_code_store = "";
		if (is_array($_GET['code_store'])) {
			foreach ($_GET['code_store'] as $code) {
				array_push($code_store, $code);
				$url_code_store .= '&code_store[]=' . $code;
			}
		}
		$area = !empty($_GET['area']) ? $_GET['area'] : "";
		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('lead_custom/mkt_lead_full_info_digital'));
		}
		$cond = array();
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$cond = array(
				"start" => $start,
				"end" => $end,
			);
		}
		if (!empty($source)) {
			$cond['source'] = $source;
		}
		if (!empty($utm_source)) {
			$cond['utm_source'] = $utm_source;
		}
		if (!empty($utm_campaign)) {
			$cond['utm_campaign'] = $utm_campaign;
		}
		if (!empty($code_store)) {
			$cond['code_store'] = $code_store;
		}
		if (!empty($area)) {
			$cond['area'] = $area;
		}
		if (!empty($isExport)) {
			$cond['isExport'] = $isExport;
		}
		$mktData = $this->api->apiPost($this->user['token'], "lead_custom/mkt_lead_full_info_digital", $cond);
		if (!empty($mktData->data)) {
			$this->fcExportLeadFullInfo($mktData->data);
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	public function fcExportLeadFullInfo($mktData)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'NGÀY GIỜ');
		$this->sheet->setCellValue('C1', 'UTM SOURCE');
		$this->sheet->setCellValue('D1', 'UTM CAMPAIGN');
		$this->sheet->setCellValue('E1', 'HỌ TÊN');
		$this->sheet->setCellValue('F1', 'EMAIL');
		$this->sheet->setCellValue('G1', 'SỐ ĐIỆN THOẠI');
		$this->sheet->setCellValue('H1', 'TRẠNG THÁI KH');
		$this->sheet->setCellValue('I1', 'LÝ DO HỦY');
		$this->sheet->setCellValue('J1', 'ĐỊA CHỈ HỘ KHẨU');
		$this->sheet->setCellValue('K1', 'NƠI Ở HIỆN TẠI');
		$this->sheet->setCellValue('L1', 'THÔNG TIN CÔNG VIỆC');
		$this->sheet->setCellValue('M1', 'HÌNH THỨC VAY');
		$this->sheet->setCellValue('N1', 'GỐC CÒN LẠI');
		$this->sheet->setCellValue('O1', 'HÌNH THỨC THANH TOÁN');
		$this->sheet->setCellValue('P1', 'KỲ HẠN');
		$this->sheet->setCellValue('Q1', 'SỐ LẦN ĐĂNG KÍ');

		$i = 2;
		foreach ($mktData as $mkt) {

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, ($mkt->created_at) ? date('d/m/Y H:i:s', $mkt->created_at) : "");
			$this->sheet->setCellValue('C' . $i, ($mkt->utm_source) ? $mkt->utm_source : '');
			$this->sheet->setCellValue('D' . $i, ($mkt->utm_campaign) ? $mkt->utm_campaign : '');
			$this->sheet->setCellValue('E' . $i, ($mkt->fullname) ? $mkt->fullname : '');
			$this->sheet->setCellValue('F' . $i, ($mkt->email) ? $mkt->email : '');
			$this->sheet->setCellValue('G' . $i, ($mkt->phone_number) ? $mkt->phone_number : '');
			$this->sheet->setCellValue('H' . $i, ($mkt->status_sale) ? lead_status($mkt->status_sale) : '');
			$this->sheet->setCellValue('I' . $i, ($mkt->reason_cancel) ? reason($mkt->reason_cancel) : '');
			$this->sheet->setCellValue('J' . $i, (($mkt->hk_ward) ? $mkt->hk_ward : '') . '/' . (($mkt->hk_district) ? $mkt->hk_district : '') . '/' . (($mkt->hk_province) ? $mkt->hk_province : ''));
			$this->sheet->setCellValue('K' . $i, (!empty($mkt->ns_ward) ? get_ward_name_by_code($mkt->ns_ward) : '') . '/' . (!empty($mkt->ns_district) ? get_district_name_by_code($mkt->ns_district) : '') . '/' . (!empty($mkt->ns_province) ? get_province_name_by_code($mkt->ns_province) : ''));
			$this->sheet->setCellValue('L' . $i, (($mkt->com) ? $mkt->com : '') . '/' . (($mkt->position) ? $mkt->position : ''));
			$this->sheet->setCellValue('M' . $i, ($mkt->type_finance) ? lead_type_finance($mkt->type_finance) : '');
			$this->sheet->setCellValue('N' . $i, ($mkt->debt) ? number_format($mkt->debt) : '0');
			$this->sheet->setCellValue('O' . $i, ($mkt->type_repay) ? type_repay($mkt->type_repay) : '');
			$this->sheet->setCellValue('P' . $i, ($mkt->loan_time) ? loan_time($mkt->loan_time) : '');
			$this->sheet->setCellValue('Q' . $i, ($mkt->sdt_trung) ? $mkt->sdt_trung : '0');

			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('danh-sach-lead-full-info-digital-' . time() . '.xlsx');
	}

	public function exportAllLead()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$sdt = !empty($_GET['sdt']) ? $_GET['sdt'] : "";
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "";
		$fullname = !empty($_GET['fullname']) ? $_GET['fullname'] : "";
		$cskh = !empty($_GET['cskh']) ? $_GET['cskh'] : "";
		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('lead_custom'));
		}
		if (empty($start) && empty($end)) {
			$this->session->set_flashdata('error', 'Ngày tháng không được để trống!');
			redirect(base_url('lead_custom'));
		}

		$cond = array();
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$cond["start"] = $start;
			$cond["end"] = $end;

		}
		if (!empty($_GET['sdt'])) {
			$cond['sdt'] = $sdt;
		}
		if (!empty($_GET['fullname'])) {
			$cond['fullname'] = $fullname;
		}
		if (!empty($_GET['cskh'])) {
			$cond['cskh'] = $cskh;
		}
		if (!empty($_GET['tab'])) {
			$cond['tab'] = $tab;
		}
		$cond['access_token'] = $this->user['token'];
		$cpanelV2 = CpanelV2::getDomain();
		$url = $cpanelV2 . "cpanel/exportExcel/exportAllLead?";
		$first = true;
		foreach ($cond as $key => $value) {
			if ($first) {
				$url .= $key . "=" . $value;
			} else {
				$url .= "&" . $key . "=" . $value;
			}
			$first = false;
		}
		$this->data['template'] = 'page/excel/exportAllLead.php';
		$this->data['url'] = $url;
		$this->load->view('template', $this->data);
		return;

	}

	public function exportAllRemindDebt()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('accountant/remind_debt_first'));
		}
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$condition['start'] = $start;
			$condition['end'] = $end;
		}
		$condition['code_contract_disbursement'] = $code_contract_disbursement;
		$condition['customer_name'] = $customer_name;
		$data = array(
			"condition" => $condition,
		);
		$contractData = $this->api->apiPost($this->userInfo['token'], "contract/contract_tempo_all", $data);
		if (!empty($contractData->data)) {
//			echo "<pre>";
//			print_r($contractData->data);
//			echo "</pre>";
//			die();
			$this->fcExportAllRemindDebt($contractData->data);
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	public function fcExportAllRemindDebt($contractData)
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$this->sheet->setCellValue('B1', 'Số hợp đồng');
		$this->sheet->setCellValue('C1', 'Họ và tên');
		$this->sheet->setCellValue('K1', 'Địa chỉ tạm trú');
		$this->sheet->setCellValue('L1', 'Địa chỉ hộ khẩu');
		$this->sheet->setCellValue('M1', 'Địa chỉ nơi làm việc');
		$this->sheet->setCellValue('N1', 'status');

		$i = 2;
		foreach ($contractData as $key => $data) {
			$this->sheet->setCellValue('B' . $i, !empty($data->code_contract_disbursement) ? $data->code_contract_disbursement : "");
			$this->sheet->setCellValue('C' . $i, !empty($data->customer_infor->customer_name) ? $data->customer_infor->customer_name : "");
			$this->sheet->setCellValue('K' . $i, $data->current_address->current_stay . ',' . $data->current_address->ward_name . ',' . $data->current_address->district_name . ',' . $data->current_address->province_name);
			$this->sheet->setCellValue('L' . $i, $data->houseHold_address->address_household . ',' . $data->houseHold_address->ward_name . ',' . $data->houseHold_address->district_name . ',' . $data->houseHold_address->province_name);
			$this->sheet->setCellValue('M' . $i, $data->job_infor->name_company . ',' . $data->job_infor->address_company);
			$this->sheet->setCellValue('N' . $i, $data->status);

			$i++;
		}
		$this->callLibExcel('danh-sach-all-lead-remind' . time() . '.xlsx');
	}

	public function fcExportAllLead1($leadsData)
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'CSKH');
		$this->sheet->setCellValue('C1', 'NGÀY THÁNG');
		$this->sheet->setCellValue('D1', 'NGUỒN');
		$this->sheet->setCellValue('E1', 'UTM_Source');
		$this->sheet->setCellValue('F1', 'UTM_Campaign');
		$this->sheet->setCellValue('G1', 'KHU VỰC');
		$this->sheet->setCellValue('H1', 'HỌ VÀ TÊN');
		$this->sheet->setCellValue('I1', 'SỐ ĐIỆN THOẠI');
		$this->sheet->setCellValue('J1', 'TRẠNG THÁI LEAD');
		$this->sheet->setCellValue('K1', 'LÝ DO HỦY');


		$i = 2;
		foreach ($leadsData as $lead) {
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($lead->cskh) ? $lead->cskh : "");
			$this->sheet->setCellValue('C' . $i, !empty($lead->created_at) ? date('d/m/Y H:i:s', $lead->created_at) : "");
			$this->sheet->setCellValue('D' . $i, !empty($lead->source) ? lead_nguon($lead->source) : '');
			$this->sheet->setCellValue('E' . $i, !empty($lead->utm_source) ? $lead->utm_source : '');
			$this->sheet->setCellValue('F' . $i, !empty($lead->utm_campaign) ? $lead->utm_campaign : '');
			$this->sheet->setCellValue('G' . $i, !empty($lead->area) ? get_province_name_by_code($lead->area) : '');
			$this->sheet->setCellValue('H' . $i, !empty($lead->fullname) ? $lead->fullname : '');
			$this->sheet->setCellValue('I' . $i, !empty($lead->phone_number) ? $lead->phone_number : "");
			$this->sheet->setCellValue('J' . $i, !empty($lead->status_sale) ? lead_status((int)$lead->status_sale) : lead_status(0));
			$this->sheet->setCellValue('K' . $i, !empty($lead->reason_cancel) ? reason($lead->reason_cancel) : '');
			$i++;
		}
		//---------------------------------------------------------------------

	}

	public function fcExportAllLead2($leadsData, $storeData)
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$this->sheet->setCellValue('L1', 'CHUYỂN ĐẾN PGD');
		$this->sheet->setCellValue('M1', 'TRẠNG THÁI HỢP ĐỒNG GN');
		$this->sheet->setCellValue('N1', 'SỐ TIỀN GN');
		$this->sheet->setCellValue('O1', 'HK_XÃ');
		$this->sheet->setCellValue('P1', 'HK_HUYỆN');
		$this->sheet->setCellValue('Q1', 'HK_TỈNH');
		$this->sheet->setCellValue('R1', 'NS_XÃ');
		$this->sheet->setCellValue('S1', 'NS_HUYỆN');
		$this->sheet->setCellValue('T1', 'NS_TỈNH');
		$this->sheet->setCellValue('U1', 'GHI CHÚ');
		$this->sheet->setCellValue('V1', 'SẢN PHẨM VAY');
		$this->sheet->setCellValue('W1', 'VỊ TRÍ/CHỨC VỤ');
		$this->sheet->setCellValue('X1', 'CMND/CCCD');
//		$this->sheet->setCellValue('Y1', 'CSKH TÁI VAY');
		$this->sheet->setCellValue('Z1', 'Transaction_Id');

		$i = 2;
//		echo "<pre>";
//		var_dump($leadsData);
//		echo "</pre>";
		foreach ($leadsData as $lead) {
			$store_name = '';
			$txt_status = '';
			if (!empty($lead->id_PDG)) {
				foreach ($storeData as $key => $value) {
					if ($value->_id->{'$oid'} == $lead->id_PDG) {
						$store_name = $value->name;
					}
				}
			}
			$status = (!empty($lead->contract_info[0]->status) && $lead->contract_info[0]->status > 16) ? $lead->contract_info[0]->status : "";
			if ($status == 17) {
				$txt_status = "Đang vay";
			} else if ($status == 18) {
				$txt_status = "Giải ngân thất bại";
			} else if ($status == 19) {
				$txt_status = "Đã tất toán";
			} else if ($status == 20) {
				$txt_status = "Đã quá hạn ";
			} else if ($status == 21) {
				$txt_status = "Chờ hội sở duyệt gia hạn";
			} else if ($status == 22) {
				$txt_status = "Chờ kế toán duyệt gia hạn ";
			} else if ($status == 23) {
				$txt_status = "Đã gia hạn ";
			} else if ($status == 24) {
				$txt_status = "chờ kế toán xác nhận phiếu thu gia hạn";
			} else if ($status == 25) {
				$txt_status = "đã duyệt gia hạn";
			}

			$this->sheet->setCellValue('L' . $i, $store_name);
			$this->sheet->setCellValue('M' . $i, $txt_status);
			$this->sheet->setCellValue('N' . $i, (!empty($lead->contract_info[0]->loan_infor->amount_loan) && (!empty($status) && $status > 16)) ? $lead->contract_info[0]->loan_infor->amount_loan : '');
			$this->sheet->setCellValue('O' . $i, !empty($lead->hk_ward) ? get_ward_name_by_code($lead->hk_ward) : '');
			$this->sheet->setCellValue('P' . $i, !empty($lead->hk_district) ? get_district_name_by_code($lead->hk_district) : '');
			$this->sheet->setCellValue('Q' . $i, !empty($lead->hk_province) ? get_province_name_by_code($lead->hk_province) : '');
			$this->sheet->setCellValue('R' . $i, !empty($lead->ns_ward) ? get_ward_name_by_code($lead->ns_ward) : '');
			$this->sheet->setCellValue('S' . $i, !empty($lead->ns_district) ? get_district_name_by_code($lead->ns_district) : '');
			$this->sheet->setCellValue('T' . $i, !empty($lead->ns_province) ? get_province_name_by_code($lead->ns_province) : '');
			$this->sheet->setCellValue('U' . $i, !empty($lead->tls_note) ? ($lead->tls_note) : '');
			$this->sheet->setCellValue('V' . $i, !empty($lead->type_finance) ? lead_type_finance($lead->type_finance) : '');
			$this->sheet->setCellValue('W' . $i, !empty($lead->position) ? ($lead->position) : '');
			$this->sheet->setCellValue('X' . $i, !empty($lead->identify_lead) ? ($lead->identify_lead) : '');
//			$this->sheet->setCellValue('Y' . $i, !empty($lead->cskh_taivay) ? ($lead->cskh_taivay) : '');
			$this->sheet->setCellValue('Z' . $i, !empty($lead->_id) ? (string)$lead->_id : '');

			$i++;
		}
		//---------------------------------------------------------------------
//		$this->callLibExcel('danh-sach-all-lead-' . time() . '.xlsx');
	}

	public function exportListLeadMKT()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$utm_source = !empty($_GET['utm_source']) ? $_GET['utm_source'] : "";
		$utm_campaign = !empty($_GET['utm_campaign']) ? $_GET['utm_campaign'] : "";
		$phone_number = !empty($_GET['phone_number']) ? $_GET['phone_number'] : "";
		$area = !empty($_GET['area']) ? $_GET['area'] : "";
		$status_sale = !empty($_GET['status_sale']) ? $_GET['status_sale'] : "";
		$area_search = !empty($_GET['area_search']) ? $_GET['area_search'] : "";
		$code_store = array();
		$url_code_store = "";
		if (is_array($_GET['code_store'])) {
			foreach ($_GET['code_store'] as $code) {
				array_push($code_store, $code);
				$url_code_store .= '&code_store[]=' . $code;
			}
		}
		$cond = array();
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$cond = array(
				"start" => $start,
				"end" => $end,
			);
		}
		if (!empty($status_sale)) {
			$cond['status_sale'] = $status_sale;
		}
		if (!empty($area)) {
			$cond['area'] = $area;
		}
		if (!empty($code_store)) {
			$cond['code_store'] = $code_store;
		}
		if (!empty($utm_source)) {
			$cond['utm_source'] = $utm_source;
		}
		if (!empty($utm_campaign)) {
			$cond['utm_campaign'] = $utm_campaign;
		}
		if (!empty($phone_number)) {
			$cond['phone_number'] = $phone_number;
		}
		if (!empty($area_search)) {
			$cond['area_search'] = $area_search;
		}

//		$leadsData = $this->api->apiPost($this->user['token'], "lead_custom/get_list_lead_mkt_export", $cond);
		$leadsData = $this->api->apiPost($this->user['token'], "lead_custom/get_lead_excel", $cond);
		$storeData = $this->api->apiPost($this->user['token'], "store/get_all", []);
		$reasonData = $this->api->apiPost($this->user['token'], "reason/get_all", []);
		if (!empty($leadsData->data)) {

			foreach ($leadsData->data as $lead) {
				$data['phone'] = $lead->phone_number;
				unset($checkContract->data[0]->_id->{'$oid'});
				$checkContract = $this->api->apiPost($this->userInfo['token'], "contract/search_phone", $data);

				if (!empty($checkContract->data) && $checkContract->status == 200) {
					if (!empty($checkContract->data[0]->status)) {
						foreach (contract_status() as $key => $item) {
							if ($key == $checkContract->data[0]->status) {
								$lead->status_lead = $item;
							}
						}
						$lead->amount_loan = $checkContract->data[0]->loan_infor->amount_loan;

					}
				}
			}

			$this->fcExportListLeadMKT($leadsData->data, $storeData->data, $reasonData->data);
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	public function fcExportListLeadMKT($leadsData, $storeData, $reasonData)
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'NGÀY THÁNG');
		$this->sheet->setCellValue('C1', 'CSKH');
		$this->sheet->setCellValue('D1', 'HỌ VÀ TÊN');
		$this->sheet->setCellValue('E1', 'SỐ ĐIỆN THOẠI');
		$this->sheet->setCellValue('F1', 'TRẠNG THÁI LEAD');
		$this->sheet->setCellValue('G1', 'NGUỒN');
		$this->sheet->setCellValue('H1', 'UTM SOURCE');
		$this->sheet->setCellValue('I1', 'UTM CAMPAIGN');
		$this->sheet->setCellValue('J1', 'CHUYỂN ĐẾN PGD');
		$this->sheet->setCellValue('K1', 'TRẠNG THÁI HỢP ĐỒNG GN');
		$this->sheet->setCellValue('L1', 'SỐ TIỀN GN');
		$this->sheet->setCellValue('M1', 'SẢN PHẨM VAY');
		$this->sheet->setCellValue('N1', 'VỊ TRÍ/CHỨC VỤ');
		$this->sheet->setCellValue('O1', 'CMND/CCCD');
		$this->sheet->setCellValue('P1', 'GHI CHÚ');
		$this->sheet->setCellValue('Q1', 'LÝ DO');
		$this->sheet->setCellValue('R1', 'TRẠNG THÁI SALE');
		$this->sheet->setCellValue('S1', 'Lý DO PGD');
		$this->sheet->setCellValue('T1', 'CVKD');


		$i = 2;
		foreach ($leadsData as $lead) {

			$store_name = '';
			$txt_status = '';
			if (!empty($lead->id_PDG)) {
				foreach ($storeData as $key => $value) {
					if ($value->_id->{'$oid'} == $lead->id_PDG) {
						$store_name = $value->name;
					}
				}
			}
			$status = (!empty($lead->contract_info[0]->status) && $lead->contract_info[0]->status > 16) ? $lead->contract_info[0]->status : "";
			if ($status == 17) {
				$txt_status = "Đang vay";
			} else if ($status == 18) {
				$txt_status = "Giải ngân thất bại";
			} else if ($status == 19) {
				$txt_status = "Đã tất toán";
			} else if ($status == 20) {
				$txt_status = "Đã quá hạn ";
			} else if ($status == 21) {
				$txt_status = "Chờ hội sở duyệt gia hạn";
			} else if ($status == 22) {
				$txt_status = "Chờ kế toán duyệt gia hạn ";
			} else if ($status == 23) {
				$txt_status = "Đã gia hạn ";
			} else if ($status == 24) {
				$txt_status = "chờ kế toán xác nhận phiếu thu gia hạn";
			} else if ($status == 25) {
				$txt_status = "đã duyệt gia hạn";
			}

			$reason_cancel_pgd = "";
			if (!empty($reasonData)) {
				foreach ($reasonData as $reason) {
					if ($lead->reason_cancel_pgd == $reason->code_reason) {
						$reason_cancel_pgd = $reason->reason_name;
					}
				}
			}
			if (!empty($lead->status_pgd)) {
				if ($lead->status_pgd == 16 && !empty($lead->reason_cancel_pgd)) {
					$reason_cancel_pgd = $reason_cancel_pgd;
				} else if ($lead->status_pgd == 17 && !empty($lead->reason_process)) {
					$reason_cancel_pgd = reason_process((int)$lead->reason_process);
				} else if ($lead->status_pgd == 8 && !empty($lead->reason_return)) {
					$reason_cancel_pgd = reason_return((int)$lead->reason_return);
				} else {
					$reason_cancel_pgd = '';
				}
			} else {
				$reason_cancel_pgd = '';
			}


			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($lead->office_at) ? date('d/m/Y H:i:s', $lead->office_at) : date('d/m/Y H:i:s', $lead->updated_at));
			$this->sheet->setCellValue('C' . $i, ($lead->cskh) ? $lead->cskh : '');
			$this->sheet->setCellValue('D' . $i, ($lead->fullname) ? $lead->fullname : '');
			$this->sheet->setCellValue('E' . $i, !empty($lead->phone_number) ? $lead->phone_number : "");
			$this->sheet->setCellValue('F' . $i, ($lead->status_pgd) ? status_pgd((int)$lead->status_pgd) : status_pgd(0));
			$this->sheet->setCellValue('G' . $i, ($lead->source) ? lead_nguon($lead->source) : '');
			$this->sheet->setCellValue('H' . $i, ($lead->utm_source) ? $lead->utm_source : "");
			$this->sheet->setCellValue('I' . $i, ($lead->utm_campaign) ? $lead->utm_campaign : '');
			$this->sheet->setCellValue('J' . $i, $store_name);
			$this->sheet->setCellValue('K' . $i, !empty($lead->status_contract) ? contract_status((int)$lead->status_contract, false) : (!empty($lead->status_lead) ? $lead->status_lead : ""));
			$this->sheet->setCellValue('L' . $i, (!empty($lead->contract_info[0]->loan_infor->amount_loan) && (!empty($status) && $status > 16)) ? $lead->contract_info[0]->loan_infor->amount_loan : (!empty($lead->amount_loan) ? $lead->amount_loan : ""));
			$this->sheet->setCellValue('M' . $i, !empty($lead->type_finance) ? lead_type_finance($lead->type_finance) : '');
			$this->sheet->setCellValue('N' . $i, !empty($lead->position) ? ($lead->position) : '');
			$this->sheet->setCellValue('O' . $i, !empty($lead->identify_lead) ? ($lead->identify_lead) : '');
			$this->sheet->setCellValue('P' . $i, !empty($lead->tls_note) ? ($lead->tls_note) : '');
			$this->sheet->setCellValue('Q' . $i, !empty($reason_cancel_pgd) ? $reason_cancel_pgd : '');
			$this->sheet->setCellValue('R' . $i, !empty($lead->status_sale) ? lead_status((int)$lead->status_sale, false) : "");
			$this->sheet->setCellValue('S' . $i, !empty($lead->pgd_note) ? $lead->pgd_note : "");
			$this->sheet->setCellValue('T' . $i, !empty($lead->cvkd) ? $lead->cvkd : "");

			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('danh-sach-lead-mkt-' . time() . '.xlsx');
	}

	public function exportListMic()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$type_mic = !empty($_GET['type_mic']) ? $_GET['type_mic'] : "";
		$isExport = !empty($_GET['isExport']) ? $_GET['isExport'] : "";
		$data = array();
		if (!empty($start)) $data['start'] = $start;
		if (!empty($end)) $data['end'] = $end;
		if (!empty($type_mic)) $data['type_mic'] = $type_mic;
		if (!empty($isExport)) $data['isExport'] = $isExport;

		$data['access_token'] = $this->user['token'];
		$cpanelV2 = CpanelV2::getDomain();
		$url = $cpanelV2 . "cpanel/exportExcel/exportMic?";
		
		$first = true;
		foreach ($data as $key => $value) {
			if ($first) {
				$url .= $key . "=" . $value;
			} else {
				$url .= "&" . $key . "=" . $value;
			}
			$first = false;
		}
		redirect($url);

		// $micData = $this->api->apiPost($this->userInfo['token'], "mic/get_all", $data);
		// //Calculate to export excel
		// if (!empty($micData->data)) {
		// 	$this->fcExportListMic($micData->data, $type_mic);
		// } else {
		// 	$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		// 	// redirect(base_url('lead_custom/list_transfe_office'));
		// }
	}

	public function fcExportListMic($micData, $type_mic)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'MÃ HỢP ĐỒNG');
		$this->sheet->setCellValue('C1', 'MÃ HỢP ĐỒNG BẢO HIỂM');
		$this->sheet->setCellValue('D1', 'NGƯỜI ĐƯỢC BẢO HÀNH');
		$this->sheet->setCellValue('E1', 'SỐ TIỀN VAY');
		$this->sheet->setCellValue('F1', 'PHÍ BẢO HIỂM');
		$this->sheet->setCellValue('G1', 'NGÀY HIỆU LỰC/NGÀY HẾT HẠN');
		$this->sheet->setCellValue('H1', 'TRẠNG THÁI MIC');
		$this->sheet->setCellValue('I1', 'NGÀY TẠO');
		$this->sheet->setCellValue('J1', 'NGƯỜI TẠO');

		$i = 2;
		foreach ($micData as $mic) {
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($mic->code_contract_disbursement) ? $mic->code_contract_disbursement : "");
			$this->sheet->setCellValue('C' . $i, !empty($mic->mic_gcn) ? $mic->mic_gcn : "");
			if ($type_mic == 'MIC_TDCN') {
				$this->sheet->setCellValue('D' . $i, !empty($mic->contract_info->customer_infor->customer_name) ? $mic->contract_info->customer_infor->customer_name : "");
				$this->sheet->setCellValue('E' . $i, !empty($mic->contract_info->loan_infor->amount_money) ? number_format($mic->contract_info->loan_infor->amount_money) : "");
				$this->sheet->setCellValue('F' . $i, !empty($mic->contract_info->loan_infor->amount_MIC) ? number_format($mic->contract_info->loan_infor->amount_MIC) : "");
			}
			if ($type_mic == 'MIC_TDT') {
				$this->sheet->setCellValue('D' . $i, !empty($mic->contract_info->investor_infor->name) ? $mic->contract_info->investor_infor->name : "");
				$this->sheet->setCellValue('E' . $i, !empty($mic->contract_info->loan_infor->amount_money) ? number_format($mic->contract_info->loan_infor->amount_money) : "");
				$this->sheet->setCellValue('F' . $i, !empty($mic->mic_fee) ? number_format($mic->mic_fee) : "");
			}
			$this->sheet->setCellValue('G' . $i, (!empty($mic->NGAY_HL) ? substr($mic->NGAY_HL, 0, 10) : "") . ' ' . (!empty($mic->NGAY_KT) ? substr($mic->NGAY_KT, 0, 10) : ""));
			$this->sheet->setCellValue('H' . $i, $mic->status == 'deactive' ? 'Thất bại' : 'Hoàn thành');
			$this->sheet->setCellValue('I' . $i, !empty($mic->created_at) ? date('m/d/Y H:i:s', $mic->created_at) : "");
			$this->sheet->setCellValue('J' . $i, !empty($mic->contract_info->created_by) ? $mic->contract_info->created_by : "");

			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('danh-sach-bao-hiem-mic-' . ($type_mic == 'MIC_TDT' ? 'nha-dau-tu-' : '') . time() . '.xlsx');
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
					'color' => ['rgb' => '780000'],
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

	private function get_tt_gic($id)
	{
		switch ($id) {
			case '4e9eb09f-2834-409f-a987-9928d4d8eac9':
				return "Đã đính kèm chứng từ";
				break;
			case '566e72ce-fb1a-456e-b337-b968ae47f0cc':
				return "Đã duyệt";
				break;
			case '30fe988b-0e95-4ae9-a5cb-2cf3214f97e0':
				return "Hoàn tất";
				break;
			case 'acc31454-af61-4896-b9a6-7d79ac8f9e37':
				return "Tạo mới";
				break;
			case '817eaae4-46e3-41f9-befb-ac52c3c01933':
				return "Chấm dứt hợp đồng";
				break;
			case 'c2105d39-f3bd-4932-98d8-7c5766a96bb9':
				return "Từ chối duyệt";
				break;
			case '7c666d28-765d-413a-ab8e-6c39e937ea72':
				return "Thanh toán đủ";
				break;
			case '93fbe0b2-1bab-4915-84bf-4abdca935952':
				return "Thanh toán 1 phần";
				break;
			case '2f77342d-ddc2-4194-8b2a-48068237a5c2':
				return "Hết hiệu lực";
				break;
		}
	}

	public function exportAllContract()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$ngaygiaingan = !empty($_GET['ngaygiaingan']) ? $_GET['ngaygiaingan'] : "1";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$customer_phone_number = !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
		$property = !empty($_GET['property']) ? $_GET['property'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$customer_identify = !empty($_GET['customer_identify']) ? $_GET['customer_identify'] : "";
		$getStore = !empty($_GET['store']) ? $_GET['store'] : "";
		$createBy = !empty($_GET['createBy']) ? $_GET['createBy'] : "";
		$search_htv = !empty($_GET['search_htv']) ? $_GET['search_htv'] : "";
		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('pawn/contract'));
		}
		$data = array();
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$data = array(
				"start" => $start,
				"end" => $end,
			);
		}
		$data['ngaygiaingan'] = $ngaygiaingan;
		if (!empty($getStore)) {
			$data['store'] = $getStore;
		}
		if (!empty($property)) {
			$data['property'] = $property;
		}
		if (!empty($status)) {
			$data['status'] = $status;
		}
		if (!empty($search_htv)) {
			$data['search_htv'] = $search_htv;
		}
		// if (!empty($status)) {
		// 	$data['status'] = $status;
		// } else {
		// 	$this->session->set_flashdata('error', "Bạn chưa chọn trạng thái!");
		// 	redirect(base_url('pawn/contract'));
		// }
		if (!empty($customer_identify)) {
			$data['customer_identify'] = $customer_identify;
		}
		if (!empty($code_contract)) {
			$data['code_contract'] = $code_contract;
		}
		if (!empty($code_contract_disbursement)) {
			$data['code_contract_disbursement'] = $code_contract_disbursement;
		}
		if (!empty($customer_name)) {
			$data['customer_name'] = $customer_name;
		}
		if (!empty($customer_phone_number)) {
			$data['customer_phone_number'] = $customer_phone_number;
		}
		if (!empty($createBy)) {
			$data['created_by'] = $createBy;
		}
		$data['is_export'] = 1;
		$data["per_page"] = 10000000;
		// call api get count contract
		$infoContractData = $this->api->apiPost($this->userInfo['token'], "contract/get_all_data", $data);
		if (empty($infoContractData->data)) {
			$this->session->set_flashdata('error', "Không có dữ liệu ");
			redirect(base_url('pawn/contract'));
		} else {
//			echo "<pre>";
//			print_r($infoContractData->data);
//			echo "</pre>";
//			die();
			$this->fcExportAllContract($infoContractData->data);
			$this->callLibExcel('data-contract-import-detail-' . $createBy . time() . '.xlsx');
		}
	}

	public function fcExportAllContract($dataPawn)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã HĐ gốc');
		$this->sheet->setCellValue('C1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('D1', 'PGD');
		$this->sheet->setCellValue('E1', 'Ngày giải ngân');
		$this->sheet->setCellValue('F1', 'Trạng thái');
		$this->sheet->setCellValue('G1', 'Hình thức');
		$this->sheet->setCellValue('H1', 'Ngân hàng');
		$this->sheet->setCellValue('I1', 'Chi nhánh');
		$this->sheet->setCellValue('J1', 'Số tài khoản');
		$this->sheet->setCellValue('K1', 'Tên chủ tài khoản');
		$this->sheet->setCellValue('L1', 'Số thẻ ATM');
		$this->sheet->setCellValue('M1', 'Tên chủ thẻ ATM');
		$this->sheet->setCellValue('N1', 'Tên NĐT');
		$this->sheet->setCellValue('O1', 'Mã NĐT');
		$this->sheet->setCellValue('P1', 'Phân loại KH');
		$this->sheet->setCellValue('Q1', 'Tên khách hàng');
		$this->sheet->setCellValue('R1', 'SĐT');
		$this->sheet->setCellValue('S1', 'Email');
		$this->sheet->setCellValue('T1', 'Số CMND');
		$this->sheet->setCellValue('U1', 'Giới tính');
		$this->sheet->setCellValue('V1', 'Ngày sinh');
		$this->sheet->setCellValue('W1', 'Tình trạng hôn nhân');
		$this->sheet->setCellValue('X1', 'Tỉnh/Thành phố');
		$this->sheet->setCellValue('Y1', 'Quận/Huyện');
		$this->sheet->setCellValue('Z1', 'Phường/Xã');
		$this->sheet->setCellValue('AA1', 'Thôn/Xóm/Tổ');
		$this->sheet->setCellValue('AB1', 'Hình thức cứ trú');
		$this->sheet->setCellValue('AC1', 'Thời gian sinh sống');
		$this->sheet->setCellValue('AD1', 'Tỉnh/Thành phố');
		$this->sheet->setCellValue('AE1', 'Quận/Huyện');
		$this->sheet->setCellValue('AF1', 'Phường/Xã');
		$this->sheet->setCellValue('AG1', 'Thôn/Xóm/Tổ');
		$this->sheet->setCellValue('AH1', 'Tên công ty');
		$this->sheet->setCellValue('AI1', 'Địa chỉ');
		$this->sheet->setCellValue('AJ1', 'SĐT');
		$this->sheet->setCellValue('AK1', 'Vị trí/Chức vụ');
		$this->sheet->setCellValue('AL1', 'Thu nhập');
		$this->sheet->setCellValue('AM1', 'Hình thức nhận lương');
		$this->sheet->setCellValue('AN1', 'Họ và tên');
		$this->sheet->setCellValue('AO1', 'Mối quan hệ');
		$this->sheet->setCellValue('AP1', 'SĐT');
		$this->sheet->setCellValue('AQ1', 'Địa chỉ');
		$this->sheet->setCellValue('AR1', 'Phản hồi');
		$this->sheet->setCellValue('AS1', 'Họ và tên');
		$this->sheet->setCellValue('AT1', 'Mối quan hệ');
		$this->sheet->setCellValue('AU1', 'SĐT');
		$this->sheet->setCellValue('AV1', 'Địa chỉ');
		$this->sheet->setCellValue('AW1', 'Phản hồi');
		$this->sheet->setCellValue('AX1', 'Hình thức');
		$this->sheet->setCellValue('AY1', 'Loại tài sản');
		$this->sheet->setCellValue('AZ1', 'Tên tài sản');
		$this->sheet->setCellValue('BA1', 'Số tiền vay');
		$this->sheet->setCellValue('BB1', 'Hình thức trả lãi');
		$this->sheet->setCellValue('BC1', 'Thời gian vay');
		$this->sheet->setCellValue('BD1', 'Mục đích vay');
		$this->sheet->setCellValue('BE1', 'Nhãn hiệu');
		$this->sheet->setCellValue('BF1', 'Model');
		$this->sheet->setCellValue('BG1', 'Biển số xe');
		$this->sheet->setCellValue('BH1', 'Số khung');
		$this->sheet->setCellValue('BI1', 'Số máy');
		$this->sheet->setCellValue('BJ1', 'Thẩm định hồ sơ');
		$this->sheet->setCellValue('BK1', 'Thẩm định thức địa');
		$this->sheet->setCellValue('BL1', 'Lãi suất NĐT');
		$this->sheet->setCellValue('BM1', 'Phí tư vấn');
		$this->sheet->setCellValue('BN1', 'Phí thẩm định và lưu trữ tài sản');
		$this->sheet->setCellValue('BO1', 'Phí quản lý số tiền vay chậm trả (%)');
		$this->sheet->setCellValue('BP1', 'Phí quản lý số tiền vay chậm trả (tối thiểu)');
		$this->sheet->setCellValue('BQ1', 'Phí tất toán trước hạn (trước 1/3)');
		$this->sheet->setCellValue('BR1', 'Phí tất toán trước hạn (trước 2/3)');
		$this->sheet->setCellValue('BS1', 'Phí tất toán trước hạn (còn lại)');
		$this->sheet->setCellValue('BT1', 'Phí tư vấn gia hạn');
		$this->sheet->setCellValue('BU1', 'Người tạo');
		$this->sheet->setCellValue('BV1', 'Nguồn khách hàng');
		$this->sheet->setCellValue('BW1', 'Trạng thái khách hàng');
		$this->sheet->setCellValue('BX1', 'Họ tên chủ xe');
		$this->sheet->setCellValue('BY1', 'Địa chỉ đăng ký');
		$this->sheet->setCellValue('BZ1', 'Số đăng ký');
		$this->sheet->setCellValue('CA1', 'Ngày cấp');
		$this->sheet->setCellValue('CB1', 'Khu vực');
		$this->sheet->setCellValue('CC1', 'Vùng');
		$this->sheet->setCellValue('CD1', 'Miền');
		$this->sheet->setCellValue('CE1', 'Gốc còn');
		$this->sheet->setCellValue('CF1', 'Bucket');
		$this->sheet->setCellValue('CG1', 'Sản phẩm');
		$this->sheet->setCellValue('CH1', '_id');
		$this->sheet->setCellValue('CI1', 'Ngày cấp CMT');
		$this->sheet->setCellValue('CJ1', 'Nơi cấp CMT');
		$this->sheet->setCellValue('CK1', 'Ngày gia hạn/cơ cấu');
		$this->sheet->setCellValue('CL1', 'Số ngày quá hạn');
		$this->sheet->setCellValue('CM1', 'Gắn định vị VSET');
		$this->sheet->setCellValue('CN1', 'IMEI Device VSET');
		$this->sheet->setCellValue('CO1', 'Bảo mật khoản vay tham chiếu 1');
		$this->sheet->setCellValue('CP1', 'Bảo mật khoản vay tham chiếu 2');
		$this->sheet->setCellValue('CQ1', 'Bảo mật khoản vay tham chiếu 3');


		$i = 2;
		foreach ($dataPawn as $data) {
			$customer_resources = !empty($data->customer_infor->customer_resources) ? $data->customer_infor->customer_resources : "";
			$resources = "";
			if ($customer_resources == '1') {
				$resources = "Digital";
			}
			if ($customer_resources == '2') {
				$resources = "TLS Tự kiếm";
			}
			if ($customer_resources == '3') {
				$resources = "Tổng đài";
			}
			if ($customer_resources == '4') {
				$resources = "Giới thiệu";
			}
			if ($customer_resources == '5') {
				$resources = "Đối tác";
			}
			if ($customer_resources == '6') {
				$resources = "Fanpage";
			}
			if ($customer_resources == '7') {
				$resources = "Nguồn khác";
			}
			if ($customer_resources == '8') {
				$resources = "KH vãng lai";
			}
			if ($customer_resources == '9') {
				$resources = "KH tự kiếm";
			}
			if ($customer_resources == '10') {
				$resources = "Cộng tác viên";
			}
			if ($customer_resources == '11') {
				$resources = "KH giới thiệu KH";
			}
			if ($customer_resources == '12') {
				$resources = "Nguồn App Mobile";
			}
			if ($customer_resources == 'VM') {
				$resources = "Nguồn vay mượn";
			}
			if ($customer_resources == 'hoiso') {
				$resources = "Nguồn hội sở";
			}
			if ($customer_resources == 'tukiem') {
				$resources = "Nguồn tự kiếm";
			}
			if ($customer_resources == 'vanglai') {
				$resources = "Nguồn vãng lai";
			}
			$so_khung = "";
			$so_may = "";
			$bien_so_xe = "";
			$model = "";
			$nhan_hieu = "";
			$ho_ten_chu_xe = "";
			$dia_chi_dang_ky = "";
			$so_dang_ky = "";
			$ngay_cap = "";
			$status_customer = "";
			$marital_status = "";
			$type_interest = "";
			$receive_salary_via = "";
			$customer_gender = "";
			if (!empty($data->customer_infor->status_customer)) {
				if ($data->customer_infor->status_customer == 1) {
					$status_customer = "Khách hàng mới";
				} else {
					$status_customer = "Khách hàng cũ";
				}
			}
			if (!empty($data->customer_infor->marriage)) {
				if ($data->customer_infor->marriage == 1) {
					$marital_status = "Đã kết hôn";
				} elseif ($data->customer_infor->marriage == 2) {
					$marital_status = "Chưa kết hôn";
				} else {
					$marital_status = "Ly hôn";
				}
			}
			if (!empty($data->loan_infor->type_interest)) {
				if ($data->loan_infor->type_interest == 1) {
					$type_interest = "Lãi hàng tháng, gốc hàng tháng";
				} else {
					$type_interest = "Lãi hàng tháng, gốc cuối kỳ";
				}
			}
			if (!empty($data->job_infor->receive_salary_via)) {
				if ($data->job_infor->receive_salary_via == 1) {
					$receive_salary_via = "Tiền mặt";
				} else {
					$receive_salary_via = "Chuyển khoản";
				}
			}
			if (!empty($data->customer_infor->customer_gender)) {
				if ($data->customer_infor->customer_gender == 1) {
					$customer_gender = "Nam";
				} else {
					$customer_gender = "Nữ";
				}
			}
			$is_device_vset = 'Không có';
			if (!empty($data->loan_infor->device_asset_location)) {
				$is_device_vset = 'Có';
			} else {
				$is_device_vset = 'Không có';
			}


			if (!empty($data->property_infor)) {
				foreach ($data->property_infor as $item) {
					if (empty($item->value)) {

					}
					if (!empty($item->value) && $item->slug == 'so-khung') {
						$so_khung = $item->value;
					}
					if (!empty($item->value) && $item->slug == 'so-may') {
						$so_may = $item->value;
					}
					if (!empty($item->value) && $item->slug == 'bien-so-xe') {
						$bien_so_xe = $item->value;
					}
					if (!empty($item->value) && $item->slug == 'model') {
						$model = $item->value;
					}
					if (!empty($item->value) && $item->slug == 'nhan-hieu') {
						$nhan_hieu = $item->value;
					}
					if (!empty($item->value) && $item->slug == 'ho-ten-chu-xe') {
						$ho_ten_chu_xe = $item->value;
					}
					if (!empty($item->value) && $item->slug == 'dia-chi-dang-ky') {
						$dia_chi_dang_ky = $item->value;
					}
					if (!empty($item->value) && $item->slug == 'so-dang-ky') {
						$so_dang_ky = $item->value;
					}
					if (!empty($item->value) && $item->slug == 'ngay-cap') {
						$ngay_cap = $item->value;
					}
				}

			}
			$bucket = "";
			$du_no_goc_con = (!empty($data->debt->tong_tien_goc_con)) ? $data->debt->tong_tien_goc_con : 0;
			$so_ngay_cham_tra = (!empty($data->debt->so_ngay_cham_tra)) ? $data->debt->so_ngay_cham_tra : 0;

			$bucket = get_bucket($so_ngay_cham_tra);
			$san_pham = (!empty($data->loan_infor->loan_product->text)) ? $data->loan_infor->loan_product->text : '';
			$store_id = (!empty($data->store->id)) ? $data->store->id : '';
			$store = $this->api->apiPost($this->userInfo['token'], "store/get_store", array('id' => $store_id));
			$code_area = (!empty($store->data->code_area)) ? $store->data->code_area : '';
			$area = $this->api->apiPost($this->userInfo['token'], "area/get_area_by_code", array('code' => $code_area));
			$vung = (!empty($area->data->region->name)) ? $area->data->region->name : '';
			$mien = (!empty($area->data->domain->name)) ? $area->data->domain->name : '';
			$khu_vuc = (!empty($area->data->title)) ? $area->data->title : '';
			$this->sheet->setCellValue('A' . $i, $i - 1);
			$this->sheet->setCellValue('B' . $i, !empty($data->code_contract_disbursement) ? $data->code_contract_disbursement : $data->code_contract);
			$this->sheet->setCellValue('C' . $i, !empty($data->code_contract) ? $data->code_contract : '');
			$this->sheet->setCellValue('D' . $i, !empty($data->store->name) ? $data->store->name : "");
			$this->sheet->setCellValue('E' . $i, (!empty($data->disbursement_date) && empty($data->type_gh) && empty($data->type_cc)) ? date("d/m/Y", $data->disbursement_date) : "");
			$this->sheet->setCellValue('F' . $i, !empty($data->status) ? contract_status($data->status) : "");
			$this->sheet->setCellValue('G' . $i, !empty($data->receiver_infor->type_payout) ? $data->receiver_infor->type_payout : "");
			$this->sheet->setCellValue('H' . $i, !empty($data->receiver_infor->bank_name) ? $data->receiver_infor->bank_name : "");
			$this->sheet->setCellValue('I' . $i, !empty($data->receiver_infor->bank_branch) ? $data->receiver_infor->bank_branch : "");
			$this->sheet->setCellValue('J' . $i, !empty($data->receiver_infor->bank_account) ? hide_phone($data->receiver_infor->bank_account) : "");
			$this->sheet->setCellValue('K' . $i, !empty($data->receiver_infor->bank_account_holder) ? $data->receiver_infor->bank_account_holder : "");
			$this->sheet->setCellValue('L' . $i, !empty($data->receiver_infor->atm_card_number) ? hide_phone($data->receiver_infor->atm_card_number) : "");
			$this->sheet->setCellValue('M' . $i, !empty($data->receiver_infor->atm_card_holder) ? ($data->receiver_infor->atm_card_holder) : "");
			$this->sheet->setCellValue('N' . $i, !empty($data->investor_infor->name) ? $data->investor_infor->name : "");
			$this->sheet->setCellValue('O' . $i, !empty($data->investor_infor->dentity_card) ? $data->investor_infor->dentity_card : "");
			$this->sheet->setCellValue('P' . $i, "");
			$this->sheet->setCellValue('Q' . $i, !empty($data->customer_infor->customer_name) ? $data->customer_infor->customer_name : "");
			$this->sheet->setCellValue('R' . $i, !empty($data->customer_infor->customer_phone_number) ? $data->customer_infor->customer_phone_number : "");
			$this->sheet->setCellValue('S' . $i, !empty($data->customer_infor->customer_email) ? $data->customer_infor->customer_email : "");
			$this->sheet->setCellValue('T' . $i, !empty($data->customer_infor->customer_identify) ? $data->customer_infor->customer_identify : "");
			$this->sheet->setCellValue('U' . $i, !empty($customer_gender) ? $customer_gender : "");
			$this->sheet->setCellValue('V' . $i, !empty($data->customer_infor->customer_BOD) ? $data->customer_infor->customer_BOD : "");
			$this->sheet->setCellValue('W' . $i, !empty($marital_status) ? $marital_status : "");
			$this->sheet->setCellValue('X' . $i, !empty($data->current_address->province_name) ? $data->current_address->province_name : "");
			$this->sheet->setCellValue('Y' . $i, !empty($data->current_address->district_name) ? $data->current_address->district_name : "");
			$this->sheet->setCellValue('Z' . $i, !empty($data->current_address->ward_name) ? $data->current_address->ward_name : "");
			$this->sheet->setCellValue('AA' . $i, !empty($data->current_address->current_stay) ? $data->current_address->current_stay : "");
			$this->sheet->setCellValue('AB' . $i, !empty($data->current_address->form_residence) ? $data->current_address->form_residence : "");
			$this->sheet->setCellValue('AC' . $i, !empty($data->current_address->time_life) ? $data->current_address->time_life : "");
			$this->sheet->setCellValue('AD' . $i, !empty($data->houseHold_address->province_name) ? $data->houseHold_address->province_name : "");
			$this->sheet->setCellValue('AE' . $i, !empty($data->houseHold_address->district_name) ? $data->houseHold_address->district_name : "");
			$this->sheet->setCellValue('AF' . $i, !empty($data->houseHold_address->ward_name) ? $data->houseHold_address->ward_name : "");
			$this->sheet->setCellValue('AG' . $i, !empty($data->houseHold_address->address_household) ? $data->houseHold_address->address_household : "");
			$this->sheet->setCellValue('AH' . $i, !empty($data->job_infor->name_company) ? $data->job_infor->name_company : "");
			$this->sheet->setCellValue('AI' . $i, !empty($data->job_infor->address_company) ? $data->job_infor->address_company : "");
			$this->sheet->setCellValue('AJ' . $i, !empty($data->job_infor->phone_number_company) ? hide_phone($data->job_infor->phone_number_company) : "");
			$this->sheet->setCellValue('AK' . $i, !empty($data->job_infor->job) ? $data->job_infor->job : "");
			$this->sheet->setCellValue('AL' . $i, !empty($data->job_infor->salary) ? $data->job_infor->salary : "");
			$this->sheet->setCellValue('AM' . $i, !empty($receive_salary_via) ? $receive_salary_via : "");
			$this->sheet->setCellValue('AN' . $i, !empty($data->relative_infor->fullname_relative_1) ? $data->relative_infor->fullname_relative_1 : "");
			$this->sheet->setCellValue('AO' . $i, !empty($data->relative_infor->type_relative_1) ? $data->relative_infor->type_relative_1 : "");
			$this->sheet->setCellValue('AP' . $i, !empty($data->relative_infor->phone_number_relative_1) ? hide_phone($data->relative_infor->phone_number_relative_1) : "");
			$this->sheet->setCellValue('AQ' . $i, !empty($data->relative_infor->hoursehold_relative_1) ? $data->relative_infor->hoursehold_relative_1 : "");
			$this->sheet->setCellValue('AR' . $i, !empty($data->relative_infor->confirm_relativeInfor_1) ? $data->relative_infor->confirm_relativeInfor_1 : "");
			$this->sheet->setCellValue('AS' . $i, !empty($data->relative_infor->fullname_relative_2) ? $data->relative_infor->fullname_relative_2 : "");
			$this->sheet->setCellValue('AT' . $i, !empty($data->relative_infor->type_relative_2) ? $data->relative_infor->type_relative_2 : "");
			$this->sheet->setCellValue('AU' . $i, !empty($data->relative_infor->phone_number_relative_2) ? hide_phone($data->relative_infor->phone_number_relative_2) : "");
			$this->sheet->setCellValue('AV' . $i, !empty($data->relative_infor->hoursehold_relative_2) ? $data->relative_infor->hoursehold_relative_2 : "");
			$this->sheet->setCellValue('AW' . $i, !empty($data->relative_infor->confirm_relativeInfor_2) ? $data->relative_infor->confirm_relativeInfor_2 : "");
			$this->sheet->setCellValue('AX' . $i, !empty($data->loan_infor->type_loan->code) ? $data->loan_infor->type_loan->code : "");
			$this->sheet->setCellValue('AY' . $i, !empty($data->loan_infor->type_property->text) ? $data->loan_infor->type_property->text : "");
			$this->sheet->setCellValue('AZ' . $i, !empty($data->loan_infor->name_property->text) ? $data->loan_infor->name_property->text : "");
			$this->sheet->setCellValue('BA' . $i, !empty($data->loan_infor->amount_money) ? $data->loan_infor->amount_money : "");
			$this->sheet->setCellValue('BB' . $i, !empty($type_interest) ? $type_interest : "");
			$this->sheet->setCellValue('BC' . $i, !empty($data->loan_infor->number_day_loan) ? $data->loan_infor->number_day_loan / 30 : "");
			$this->sheet->setCellValue('BD' . $i, !empty($data->loan_infor->loan_purpose) ? $data->loan_infor->loan_purpose : "");
			$this->sheet->setCellValue('BE' . $i, $nhan_hieu);
			$this->sheet->setCellValue('BF' . $i, $model);
			$this->sheet->setCellValue('BG' . $i, $bien_so_xe);
			$this->sheet->setCellValue('BH' . $i, $so_khung);
			$this->sheet->setCellValue('BI' . $i, $so_may);
			$this->sheet->setCellValue('BJ' . $i, "");
			$this->sheet->setCellValue('BK' . $i, "");
			$this->sheet->setCellValue('BL' . $i, !empty($data->fee->percent_interest_customer) ? $data->fee->percent_interest_customer : "");
			$this->sheet->setCellValue('BM' . $i, !empty($data->fee->percent_advisory) ? $data->fee->percent_advisory : "");
			$this->sheet->setCellValue('BN' . $i, !empty($data->fee->percent_expertise) ? $data->fee->percent_expertise : "");
			$this->sheet->setCellValue('BO' . $i, !empty($data->fee->penalty_percent) ? $data->fee->penalty_percent : "");
			$this->sheet->setCellValue('BP' . $i, !empty($data->fee->penalty_amount) ? $data->fee->penalty_amount : "");
			$this->sheet->setCellValue('BQ' . $i, !empty($data->fee->percent_prepay_phase_1) ? $data->fee->percent_prepay_phase_1 : "");
			$this->sheet->setCellValue('BR' . $i, !empty($data->fee->percent_prepay_phase_2) ? $data->fee->percent_prepay_phase_2 : "");
			$this->sheet->setCellValue('BS' . $i, !empty($data->fee->percent_prepay_phase_3) ? $data->fee->percent_prepay_phase_3 : "");
			$this->sheet->setCellValue('BT' . $i, !empty($data->fee->extend) ? $data->fee->extend : "");
			$this->sheet->setCellValue('BU' . $i, !empty($data->created_by) ? $data->created_by : "");
			$this->sheet->setCellValue('BV' . $i, !empty($resources) ? $resources : "");
			$this->sheet->setCellValue('BW' . $i, !empty($status_customer) ? $status_customer : "");
			$this->sheet->setCellValue('BX' . $i, !empty($ho_ten_chu_xe) ? $ho_ten_chu_xe : "");
			$this->sheet->setCellValue('BY' . $i, !empty($dia_chi_dang_ky) ? $dia_chi_dang_ky : "");
			$this->sheet->setCellValue('BZ' . $i, !empty($so_dang_ky) ? $so_dang_ky : "");
			$this->sheet->setCellValue('CA' . $i, !empty($ngay_cap) ? date("d/m/Y", $ngay_cap) : "");
			$this->sheet->setCellValue('CB' . $i, !empty($khu_vuc) ? $khu_vuc : "");
			$this->sheet->setCellValue('CC' . $i, !empty($vung) ? $vung : "");
			$this->sheet->setCellValue('CD' . $i, !empty($mien) ? $mien : "");
			$this->sheet->setCellValue('CE' . $i, !empty($du_no_goc_con) ? $du_no_goc_con : "");
			$this->sheet->setCellValue('CF' . $i, !empty($bucket) ? $bucket : "");
			$this->sheet->setCellValue('CG' . $i, !empty($san_pham) ? $san_pham : "");
			$this->sheet->setCellValue('CH' . $i, !empty($data->_id->{'$oid'}) ? $data->_id->{'$oid'} : "");
			$this->sheet->setCellValue('CI' . $i, !empty($data->customer_infor->date_range) ? $data->customer_infor->date_range : "");
			$this->sheet->setCellValue('CJ' . $i, !empty($data->customer_infor->issued_by) ? $data->customer_infor->issued_by : "");
			$this->sheet->setCellValue('CK' . $i, (!empty($data->disbursement_date) && (!empty($data->type_gh) || !empty($data->type_cc))) ? date("d/m/Y", $data->disbursement_date) : "");
			$this->sheet->setCellValue('CL' . $i, (!empty($data->debt->so_ngay_cham_tra) && $data->debt->so_ngay_cham_tra > 0) ? $data->debt->so_ngay_cham_tra : "");
			$this->sheet->setCellValue('CM' . $i, !empty($is_device_vset) ? $is_device_vset : "");
			$this->sheet->setCellValue('CN' . $i, !empty($data->loan_infor->device_asset_location->code) ? $data->loan_infor->device_asset_location->code . " " : '');
			$this->sheet->setCellValue('CO' . $i, !empty($data->relative_infor->loan_security_1) ? loan_security($data->relative_infor->loan_security_1) : "");
			$this->sheet->setCellValue('CP' . $i, !empty($data->relative_infor->loan_security_2) ? loan_security($data->relative_infor->loan_security_2) : "");
			$this->sheet->setCellValue('CQ' . $i, !empty($data->relative_infor->loan_security_3) ? loan_security($data->relative_infor->loan_security_3) : "");

			$i++;
		}

	}

	public function selectContractExportExcel()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$createBy = !empty($_GET['createBy']) ? $_GET['createBy'] : "";
		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('pawn/contract'));
		}

		$data = array();
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$data = array(
				"start" => $start,
				"end" => $end,
			);
		}
		$data["per_page"] = 2000;

		// call api get count contract
		$infoContractData = $this->api->apiPost($this->userInfo['token'], "exportExcel/selectExcelExport");

//		echo "<pre>";
//		print_r($infoContractData->data[8]);
//		echo "</pre>";
		if (empty($infoContractData->data)) {
			$this->session->set_flashdata('error', "Không có dữ liệu ");
			redirect(base_url('pawn/contract'));
		} else {

			$this->exportContract($infoContractData->data);
//			die();
			$this->callLibExcel('data-import-detail-' . $createBy . time() . '.xlsx');
		}
	}

	public function exportList_contract_money_300()
	{
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$data = array();
		if (!empty($_GET['code_contract_disbursement'])) {
			$data["code_contract_disbursement"] = $code_contract_disbursement;
		}
		if (!empty($_GET['code_contract'])) {
			$data["code_contract"] = $code_contract;
		}
		$data["chan_bao_hiem"] = 1;
		$data["per_page"] = 2000;
		$infoContractData = $this->api->apiPost($this->userInfo['token'], "contract/contract_tempo_new", $data);
		if (empty($infoContractData->data)) {
			$this->session->set_flashdata('error', "Không có dữ liệu ");
			redirect(base_url('contract/list_money_300'));
		} else {
			$this->exportContract($infoContractData->data);
			$this->callLibExcel('data-contract_money_300-' . $createBy . time() . '.xlsx');
		}
	}

	public function exportContract($dataPawn)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã HĐ gốc');
		$this->sheet->setCellValue('C1', 'PGD');
		$this->sheet->setCellValue('D1', 'Tên Khách Hàng');
		$this->sheet->setCellValue('E1', 'Giới tính');
		$this->sheet->setCellValue('F1', 'Ngày sinh');
		$this->sheet->setCellValue('G1', 'Địa chỉ hiện tại');
		$this->sheet->setCellValue('H1', 'Nghề nghiệp');
		$this->sheet->setCellValue('I1', 'Thu nhập');
		$this->sheet->setCellValue('J1', 'Chức vụ');
		$this->sheet->setCellValue('K1', 'Hình thức nhận lương');
		$this->sheet->setCellValue('L1', 'Sản phẩm');
		$this->sheet->setCellValue('M1', 'Số tiền vay');
		$this->sheet->setCellValue('N1', 'Hình thức trả');
		$this->sheet->setCellValue('O1', 'Thời gian vay');
		$this->sheet->setCellValue('P1', 'Mục đích cá nhân');
		$this->sheet->setCellValue('Q1', 'Gốc còn lại');
		$this->sheet->setCellValue('R1', 'Tổng số tiền phải trả');
		$this->sheet->setCellValue('S1', 'Tình trạng khoản vay');
		$this->sheet->setCellValue('T1', 'Tình trạng trả tiền');
		$this->sheet->setCellValue('U1', 'Số ngày trễ');

		$i = 2;
//		echo "<pre>";
//		print_r($dataPawn->data);
//		echo "</pre>";

		foreach ($dataPawn as $data) {
			if (!empty($data->customer_infor->customer_gender)) {
				if ($data->customer_infor->customer_gender == 1) {
					$customer_gender = "Nam";
				} else {
					$customer_gender = "Nữ";
				}
			}
			if (!empty($data->job_infor->receive_salary_via)) {
				if ($data->job_infor->receive_salary_via == 1) {
					$receive_salary_via = "Tiền mặt";
				} else {
					$receive_salary_via = "Chuyển khoản";
				}
			}
			if (!empty($data->loan_infor->type_interest)) {
				if ($data->loan_infor->type_interest == 1) {
					$type_interest = "Lãi hàng tháng, gốc hàng tháng";
				} else {
					$type_interest = "Lãi hàng tháng, gốc cuối kỳ";
				}
			}

//			$condition['code_contract'] = $data->code_contract;
//			$detailContractData = $this->api->apiPost($this->userInfo['token'], "tempoContract/get_tempoContract", $condition);
			$totalPrice = 0;
			$dayMax = 0;
			if (!empty($data->contract_info)) {
				foreach ($data->contract_info as $detail) {
					$totalPrice += (int)$detail->tien_tra_1_ky;
					if ($detail->ngay_ky_tra > $dayMax) {
						$dayMax = $detail->ngay_ky_tra;
					}
				}
			}

			$status = '';
			if ($data->status == 0) {
				$status = "Nháp";
			} else if ($data->status == 1) {
				$status = "Mới";
			} else if ($data->status == 2) {
				$status = "Chờ trưởng PGD duyệt";
			} else if ($data->status == 3) {
				$status = "Đã hủy";
			} else if ($data->status == 4) {
				$status = "Trưởng PGD không duyệt";
			} else if ($data->status == 5) {
				$status = "Chờ hội sở duyệt";
			} else if ($data->status == 6) {
				$status = "Đã duyệt";
			} else if ($data->status == 7) {
				$status = "Kế toán không duyệt";
			} else if ($data->status == 8) {
				$status = "Hội sở không duyệt";
			} else if ($data->status == 9) {
				$status = "Chờ ngân lượng xử lý";
			} else if ($data->status == 10) {
				$status = "Ngân lượng giải ngân thất bại";
			} else if ($data->status == 15) {
				$status = "Chờ giải ngân";
			} else if ($data->status == 16) {
				$status = "Tạo lệnh giải ngân thành công";
			} else if ($data->status == 17) {
				$status = "Đang vay";
			} else if ($data->status == 18) {
				$status = "Giải ngân thất bại";
			} else if ($data->status == 19) {
				$status = "Đã tất toán";
			} else if ($data->status == 20) {
				$status = "Đã quá hạn ";
			} else if ($data->status == 21) {
				$status = "Chờ hội sở duyệt gia hạn";
			} else if ($data->status == 22) {
				$status = "Chờ kế toán duyệt gia hạn ";
			} else if ($data->status == 23) {
				$status = "Đã gia hạn ";
			} else if ($data->status == 24) {
				$status = "chờ kế toán xác nhận phiếu thu gia hạn";
			} else if ($data->status == 25) {
				$status = "đã duyệt gia hạn";
			}
			$tinh_trang_tra_no = '';
			if (time() > $dayMax) {
				$tinh_trang_tra_no = "Quá hạn";
				$so_ngay_qua_han = (int)((time() - $dayMax) / 3600 / 24);
			} else {
				$tinh_trang_tra_no = "Còn hạn";
				$so_ngay_qua_han = "";
			}

			$this->sheet->setCellValue('A' . $i, $i - 1);
			$this->sheet->setCellValue('B' . $i, !empty($data->code_contract_disbursement) ? $data->code_contract_disbursement : "");
			$this->sheet->setCellValue('C' . $i, !empty($data->store->name) ? $data->store->name : '');
			$this->sheet->setCellValue('D' . $i, !empty($data->customer_infor->customer_name) ? $data->customer_infor->customer_name : "");
			$this->sheet->setCellValue('E' . $i, !empty($customer_gender) ? $customer_gender : "");
			$this->sheet->setCellValue('F' . $i, !empty($data->customer_infor->customer_BOD) ? $data->customer_infor->customer_BOD : "");
			$this->sheet->setCellValue('G' . $i, !empty($data->current_address) ? $data->current_address->ward_name . "," . $data->current_address->district_name . "," . $data->current_address->province_name : "");
			$this->sheet->setCellValue('H' . $i, !empty($data->job_infor->job) ? $data->job_infor->job : "");
			$this->sheet->setCellValue('I' . $i, !empty($data->job_infor->salary) ? $data->job_infor->salary : "");
			$this->sheet->setCellValue('J' . $i, !empty($data->job_infor->job_position) ? $data->job_infor->job_position : "");
			$this->sheet->setCellValue('K' . $i, !empty($receive_salary_via) ? $receive_salary_via : "");
			$this->sheet->setCellValue('L' . $i, !empty($data->loan_infor->name_property->text) ? ($data->loan_infor->name_property->text) : "");
			$this->sheet->setCellValue('M' . $i, !empty($data->loan_infor->amount_money) ? ($data->loan_infor->amount_money) : "");
			$this->sheet->setCellValue('N' . $i, !empty($type_interest) ? $type_interest : "");
			$this->sheet->setCellValue('O' . $i, !empty($data->loan_infor->number_day_loan) ? $data->loan_infor->number_day_loan . "ngày" : "");
			$this->sheet->setCellValue('P' . $i, !empty($data->loan_infor->loan_purpose) ? $data->loan_infor->loan_purpose : "");
			$this->sheet->setCellValue('Q' . $i, !empty($data->loan_infor->amount_loan) ? $data->loan_infor->amount_loan : "");
			$this->sheet->setCellValue('R' . $i, !empty($totalPrice) ? ($totalPrice) : "");
			$this->sheet->setCellValue('S' . $i, !empty($status) ? $status : "");
			$this->sheet->setCellValue('T' . $i, !empty($tinh_trang_tra_no) ? ($tinh_trang_tra_no) : "");
			$this->sheet->setCellValue('U' . $i, ($status == "Đang vay") ? ($so_ngay_qua_han) : "");

			$i++;
		}
	}

	public function excel_vbi_ungthuvu()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$data = array();
		if (!empty($start)) $data['start'] = $start;
		if (!empty($end)) $data['end'] = $end;

		$data['access_token'] = $this->user['token'];
		$cpanelV2 = CpanelV2::getDomain();
		$url = $cpanelV2 . "cpanel/exportExcel/exportVbiUtv?";
		$first = true;
		foreach ($data as $key => $value) {
			if ($first) {
				$url .= $key . "=" . $value;
			} else {
				$url .= "&" . $key . "=" . $value;
			}
			$first = false;
		}
		redirect($url);

		// $data['per_page'] = 10000;
		// $listVibData = $this->api->apiPost($this->userInfo['token'], "vbi/get_all_utv", $data);

		// if (!empty($listVibData->data)) {
		// 	$this->fcExportListVbiUtv($listVibData->data);
		// 	$this->callLibExcel('datavbi-import-detail-' . $createBy . time() . '.xlsx');
		// } else {
		// 	$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		// 	// redirect(base_url('lead_custom/list_transfe_office'));
		// }
	}

	public function fcExportListVbiUtv($listVibData)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'MÃ HỢP ĐỒNG');
		$this->sheet->setCellValue('C1', 'TÊN NGƯỜI ĐƯỢC BẢO HIỂM');
		$this->sheet->setCellValue('D1', 'TÊN GÓI BẢO HIỂM-VBI-1');
		$this->sheet->setCellValue('E1', 'PHÍ BẢO HIỂM-VBI-1');
		$this->sheet->setCellValue('F1', 'TÊN GÓI BẢO HIỂM-VBI-2');
		$this->sheet->setCellValue('G1', 'PHÍ BẢO HIỂM-VBI-2');
		$this->sheet->setCellValue('H1', 'TỔNG TIỀN');
		$this->sheet->setCellValue('I1', 'CHỨNG MINH NHÂN DÂN');
		$this->sheet->setCellValue('J1', 'NGÀY THÁNG NĂM SINH');
		$this->sheet->setCellValue('K1', 'SỐ ĐIỆN THOẠI');
		$this->sheet->setCellValue('L1', 'CỬA HÀNG');
		$this->sheet->setCellValue('M1', 'TRẠNG THÁI');
		$this->sheet->setCellValue('N1', 'NGÀY TẠO');
		$this->sheet->setCellValue('O1', 'NGƯỜI TẠO');


		$i = 2;
		foreach ($listVibData as $vbi) {
			if (!empty($vbi->status_vbi)) {
				if ($vbi->status_vbi == 1) {
					$status = "active";
				} else {
					$status = "deactive";
				}
			}

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($vbi->code_contract) ? $vbi->code_contract : '');
			$this->sheet->setCellValue('C' . $i, !empty($vbi->contract_info->customer_infor->customer_name) ? $vbi->contract_info->customer_infor->customer_name : '');
			$this->sheet->setCellValue('D' . $i, !empty($vbi->contract_info->loan_infor->code_VBI_1) ? $vbi->contract_info->loan_infor->code_VBI_1 : '');
			$this->sheet->setCellValue('E' . $i, !empty($vbi->contract_info->loan_infor->amount_code_VBI_1) ? $vbi->contract_info->loan_infor->amount_code_VBI_1 : '');
			$this->sheet->setCellValue('F' . $i, !empty($vbi->contract_info->loan_infor->code_VBI_2) ? $vbi->contract_info->loan_infor->code_VBI_2 : '');
			$this->sheet->setCellValue('G' . $i, !empty($vbi->contract_info->loan_infor->amount_code_VBI_2) ? $vbi->contract_info->loan_infor->amount_code_VBI_2 : '');
			$this->sheet->setCellValue('H' . $i, !empty($vbi->contract_info->loan_infor->amount_VBI) ? $vbi->contract_info->loan_infor->amount_VBI : '');
			$this->sheet->setCellValue('I' . $i, !empty($vbi->contract_info->customer_infor->customer_identify) ? $vbi->contract_info->customer_infor->customer_identify : "");
			$this->sheet->setCellValue('J' . $i, !empty($vbi->contract_info->customer_infor->customer_BOD) ? $vbi->contract_info->customer_infor->customer_BOD : "");
			$this->sheet->setCellValue('K' . $i, !empty($vbi->contract_info->customer_infor->customer_phone_number) ? $vbi->contract_info->customer_infor->customer_phone_number : "");
			$this->sheet->setCellValue('L' . $i, !empty($vbi->contract_info->store->name) ? ($vbi->contract_info->store->name) : "");
			$this->sheet->setCellValue('M' . $i, !empty($vbi->status_vbi) ? $status : "");
			$this->sheet->setCellValue('N' . $i, !empty($vbi->created_at) ? date('m/d/Y H:i:s', $vbi->created_at) : "");
			$this->sheet->setCellValue('O' . $i, !empty($vbi->contract_info->created_by) ? $vbi->contract_info->created_by : "");

			$i++;
		}
	}

	public function excel_vbi_sotxuathuyet()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$data = array();
		if (!empty($start)) $data['start'] = $start;
		if (!empty($end)) $data['end'] = $end;

		$data['access_token'] = $this->user['token'];
		$cpanelV2 = CpanelV2::getDomain();
		$url = $cpanelV2 . "cpanel/exportExcel/exportVbiSxh?";
		$first = true;
		foreach ($data as $key => $value) {
			if ($first) {
				$url .= $key . "=" . $value;
			} else {
				$url .= "&" . $key . "=" . $value;
			}
			$first = false;
		}
		redirect($url);


		// $data['per_page'] = 10000;
		// $listVibData = $this->api->apiPost($this->userInfo['token'], "vbi/get_all_sxh", $data);

		// if (!empty($listVibData->data)) {
		// 	$this->fcExportListVbiSxh($listVibData->data);
		// 	$this->callLibExcel('datavbi-import-detail-' . $createBy . time() . '.xlsx');
		// } else {
		// 	$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		// 	// redirect(base_url('lead_custom/list_transfe_office'));
		// }
	}

	public function fcExportListVbiSxh($listVibData)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'MÃ HỢP ĐỒNG');
		$this->sheet->setCellValue('C1', 'TÊN NGƯỜI ĐƯỢC BẢO HIỂM');
		$this->sheet->setCellValue('D1', 'TÊN GÓI BẢO HIỂM-VBI-1');
		$this->sheet->setCellValue('E1', 'PHÍ BẢO HIỂM-VBI-1');
		$this->sheet->setCellValue('F1', 'TÊN GÓI BẢO HIỂM-VBI-2');
		$this->sheet->setCellValue('G1', 'PHÍ BẢO HIỂM-VBI-2');
		$this->sheet->setCellValue('H1', 'TỔNG TIỀN');
		$this->sheet->setCellValue('I1', 'CHỨNG MINH NHÂN DÂN');
		$this->sheet->setCellValue('J1', 'NGÀY THÁNG NĂM SINH');
		$this->sheet->setCellValue('K1', 'SỐ ĐIỆN THOẠI');
		$this->sheet->setCellValue('L1', 'CỬA HÀNG');
		$this->sheet->setCellValue('M1', 'TRẠNG THÁI');
		$this->sheet->setCellValue('N1', 'NGÀY TẠO');
		$this->sheet->setCellValue('O1', 'NGƯỜI TẠO');


		$i = 2;
		foreach ($listVibData as $vbi) {
			if (!empty($vbi->status_vbi)) {
				if ($vbi->status_vbi == 1) {
					$status = "active";
				} else {
					$status = "deactive";
				}
			}

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($vbi->code_contract) ? $vbi->code_contract : '');
			$this->sheet->setCellValue('C' . $i, !empty($vbi->contract_info->customer_infor->customer_name) ? $vbi->contract_info->customer_infor->customer_name : '');
			$this->sheet->setCellValue('D' . $i, !empty($vbi->contract_info->loan_infor->code_VBI_1) ? $vbi->contract_info->loan_infor->code_VBI_1 : '');
			$this->sheet->setCellValue('E' . $i, !empty($vbi->contract_info->loan_infor->amount_code_VBI_1) ? $vbi->contract_info->loan_infor->amount_code_VBI_1 : '');
			$this->sheet->setCellValue('F' . $i, !empty($vbi->contract_info->loan_infor->code_VBI_2) ? $vbi->contract_info->loan_infor->code_VBI_2 : '');
			$this->sheet->setCellValue('G' . $i, !empty($vbi->contract_info->loan_infor->amount_code_VBI_2) ? $vbi->contract_info->loan_infor->amount_code_VBI_2 : '');
			$this->sheet->setCellValue('h' . $i, !empty($vbi->contract_info->loan_infor->amount_VBI) ? $vbi->contract_info->loan_infor->amount_VBI : '');
			$this->sheet->setCellValue('I' . $i, !empty($vbi->contract_info->customer_infor->customer_identify) ? $vbi->contract_info->customer_infor->customer_identify : "");
			$this->sheet->setCellValue('J' . $i, !empty($vbi->contract_info->customer_infor->customer_BOD) ? $vbi->contract_info->customer_infor->customer_BOD : "");
			$this->sheet->setCellValue('K' . $i, !empty($vbi->contract_info->customer_infor->customer_phone_number) ? $vbi->contract_info->customer_infor->customer_phone_number : "");
			$this->sheet->setCellValue('L' . $i, !empty($vbi->contract_info->store->name) ? ($vbi->contract_info->store->name) : "");
			$this->sheet->setCellValue('M' . $i, !empty($vbi->status_vbi) ? $status : "");
			$this->sheet->setCellValue('N' . $i, !empty($vbi->created_at) ? date('m/d/Y H:i:s', $vbi->created_at) : "");
			$this->sheet->setCellValue('O' . $i, !empty($vbi->contract_info->created_by) ? $vbi->contract_info->created_by : "");

			$i++;
		}
	}

	public function exportNoneDepreciationProperties()
	{
		$data = array();
		$data['status'] = "active";
		$propertiesData = $this->api->apiPost($this->userInfo['token'], "property/get_none_depreciations_properties", $data);
		if (!empty($propertiesData->data)) {
			$this->fcExportPropertiesNoneDepreciation($propertiesData->data);
			$this->callLibExcel('data-property-none-depreciation-import-detail-' . $createBy . time() . '.xlsx');
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	public function fcExportPropertiesNoneDepreciation($propertiesData)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Tên tài sản');
		$this->sheet->setCellValue('C1', 'Model');
		$this->sheet->setCellValue('D1', 'Giá');
		$this->sheet->setCellValue('E1', '_id tài sản hiện tại');
		$this->sheet->setCellValue('F1', 'ID Tài sản Cha');

		$i = 2;
		foreach ($propertiesData as $property) {

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($property->str_name) ? $property->str_name : '');
			$this->sheet->setCellValue('C' . $i, !empty($property->name) ? $property->name : '');
			$this->sheet->setCellValue('D' . $i, !empty($property->price) ? $property->price : '');
			$this->sheet->setCellValue('E' . $i, !empty($property->_id->{'$oid'}) ? $property->_id->{'$oid'} : '');
			$this->sheet->setCellValue('F' . $i, !empty($property->parent_id) ? $property->parent_id : '');

			$i++;
		}
	}


	public function excel_approval_report()
	{

		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$change_time = !empty($_GET['change_time']) ? $_GET['change_time'] : "";
		$stores_ad = !empty($_GET['stores_ad']) ? $_GET['stores_ad'] : "";
		$area = !empty($_GET['area']) ? $_GET['area'] : "";
		$customer_form_hs = !empty($_GET['customer_form_hs']) ? $_GET['customer_form_hs'] : "";


		$data = array();
		if (!empty($start)) $data['start'] = $start;
		if (!empty($end)) $data['end'] = $end;
		if (!empty($change_time)) $data['change_time'] = $change_time;
		if (!empty($stores_ad)) $data['stores_ad'] = $stores_ad;
		if (!empty($area)) $data['area'] = $area;
		if (!empty($customer_form_hs)) $data['customer_form_hs'] = $customer_form_hs;


		$list_report_pd = $this->api->apiPost($this->userInfo['token'], "exportExcel/export_report_hs_day", $data);

		if (!empty($list_report_pd->data)) {
			$this->fcExportList_report($list_report_pd->data, $start, $end);
			$this->callLibExcel("Report -" . date("d/m/Y") . '.xlsx');
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
			echo "Không có dữ liệu để xuất excel";
		}
	}


	public function fcExportList_report($report, $start, $end)
	{

		$this->sheet->mergeCells("L1:O1");
		$this->sheet->mergeCells("S1:V1");

		$this->sheet->mergeCells("A1:A2");
		$this->sheet->mergeCells("B1:B2");
		$this->sheet->mergeCells("C1:C2");
		$this->sheet->mergeCells("D1:D2");
		$this->sheet->mergeCells("E1:E2");
		$this->sheet->mergeCells("F1:F2");
		$this->sheet->mergeCells("G1:G2");
		$this->sheet->mergeCells("H1:H2");
		$this->sheet->mergeCells("I1:I2");
		$this->sheet->mergeCells("J1:J2");
		$this->sheet->mergeCells("K1:K2");

		$this->sheet->mergeCells("P1:P2");
		$this->sheet->mergeCells("Q1:Q2");
		$this->sheet->mergeCells("R1:R2");
		$this->sheet->mergeCells("V1:V2");


		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Người PD');
		$this->sheet->setCellValue('C1', 'Khu Vực');
		$this->sheet->setCellValue('D1', 'PGD');
		$this->sheet->setCellValue('E1', 'Tên KH');
		$this->sheet->setCellValue('F1', 'CMT');
		$this->sheet->setCellValue('G1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('H1', 'Sản phẩm vay');
		$this->sheet->setCellValue('I1', 'Số tiền YC');
		$this->sheet->setCellValue('J1', 'Thời gian YC');
		$this->sheet->setCellValue('K1', 'Thời gian thực hiện');

		$this->sheet->setCellValue('L2', 'Trả về');
		$this->sheet->setCellValue('M2', 'Hủy');
		$this->sheet->setCellValue('N2', 'Duyệt');
		$this->sheet->setCellValue('O2', 'Chưa xử lý');


		$this->sheet->setCellValue('P1', 'Lý do');
		$this->sheet->setCellValue('Q1', 'Tổng thời gian yêu cầu');
		$this->sheet->setCellValue('R1', 'Tổng thời gian xử lý');

		$this->sheet->setCellValue('S2', 'Trả về');
		$this->sheet->setCellValue('T2', 'Ghi chú - Trả về');
		$this->sheet->setCellValue('U2', 'Hủy');
		$this->sheet->setCellValue('V2', 'Duyệt');


		$this->sheet->setCellValue('W1', 'Ngoại lệ');


		$this->sheet->setCellValue('S1', 'Tổng số lần trả về');
		$this->sheet->setCellValue('L1', 'Trạng thái');


		$list_hs = $this->api->apiPost($this->userInfo['token'], "exportExcel/get_user_hs");
		$list_asm = $this->api->apiPost($this->userInfo['token'], "exportExcel/getGroupRole_asm");

		$i = 3;
		$check_code_contract = [];
		$arr_check_id = [];

		$total_resut = 0;
		$total = [];
		$tong_trave = 0;
		$tong_huy = 0;
		$tong_duyet = 0;
		$tong_chuaxuly = 0;

		foreach ($report as $key => $value) {

			if (in_array($value->email, $list_hs->data)) {
				$email_hs = $value->email;
			}

			if (in_array($value->email, $list_asm->data)) {
				$email_hs = $value->email;
			}

			if ($value->loan_product == "Cầm cố xe máy" || $value->loan_product == "Cầm cố ô tô") {
				continue;
			}


			unset($reason);
			if ($value->reason == 1) {
				$reason = "A1";

			} elseif ($value->reason == 2) {
				$reason = "A2";

			}

			if ($value->pgd == "398 Trần Phú" || $value->pgd == "51 Kim Hoàn" || $value->pgd == "246 La Thành" || $value->pgd == "79 Tây Đằng" || $value->pgd == "71 Lê Thanh Nghị" || $value->pgd == "494 Trần Cung" || $value->pgd == "26 Vạn Phúc" || $value->pgd == "264 Xã Đàn" || $value->pgd == "28 Phan Huy Ích" || $value->pgd == "44 Lĩnh Nam" || $value->pgd == "01 Mỹ Đình" || $value->pgd == "48 La Thành" || $value->pgd == "310 Phan Trọng Tuệ" || $value->pgd == "30 Nguyễn Thái Học" || $value->pgd == "81 Nguyễn Trãi" || $value->pgd == "518 Xã Đàn" || $value->pgd == "79 Hưng Đạo" || $value->pgd == "281 Ngô Gia Tự" || $value->pgd == "901 Giải Phóng") {
				$area = "Hà Nội";
			}
			if ($value->pgd == "316 Nguyễn Sơn" || $value->pgd == "550 Nguyễn Văn Khối" || $value->pgd == "138 Phan Đăng Lưu" || $value->pgd == "286 Bình Tiên" || $value->pgd == "267 Âu Cơ" || $value->pgd == "131 Hiệp Bình" || $value->pgd == "412 Cách Mạng Tháng 8" || $value->pgd == "81 Liêu Bình Hương" || $value->pgd == "28 Đỗ Xuân Hợp" || $value->pgd == "246 Nguyễn An Ninh" || $value->pgd == "133 Lê Văn Việt" || $value->pgd == "662 Lê Văn Khương" || $value->pgd == "PGD 2/1A Phan Văn Hớn" || $value->pgd == "63 Đường 26 tháng 3") {
				$area = "Tp Hồ Chí Minh";
			}
			if ($value->pgd == "63 Đường 26 tháng 3" || $value->pgd == "1797 Trần Hưng Đạo" || $value->pgd == "308 Đường 30/4") {
				$area = "Mekong";
			}

			if (!empty($value->exception1_value_detail[0])) {

				for ($j = 0; $j < count($value->exception1_value_detail[0]); $j++) {
					if ($value->exception1_value_detail[0][$j] == "1") {
						$value->exception1_value_detail[0][$j] = "E1.1";
					}
					if ($value->exception1_value_detail[0][$j] == "2") {
						$value->exception1_value_detail[0][$j] = "E1.2";
					}
				}
			}
			if (!empty($value->exception2_value_detail[0])) {
				for ($j = 0; $j < count($value->exception2_value_detail[0]); $j++) {
					if ($value->exception2_value_detail[0][$j] == "3") {
						$value->exception2_value_detail[0][$j] = "E2.1";
					}
					if ($value->exception2_value_detail[0][$j] == "4") {
						$value->exception2_value_detail[0][$j] = "E2.2";
					}
				}
			}
			if (!empty($value->exception3_value_detail[0])) {
				for ($j = 0; $j < count($value->exception3_value_detail[0]); $j++) {
					if ($value->exception3_value_detail[0][$j] == "5") {
						$value->exception3_value_detail[0][$j] = "E3.1";
					}
				}
			}
			if (!empty($value->exception4_value_detail[0])) {
				for ($j = 0; $j < count($value->exception4_value_detail[0]); $j++) {
					if ($value->exception4_value_detail[0][$j] == "6") {
						$value->exception4_value_detail[0][$j] = "E4.1";
					}
					if ($value->exception4_value_detail[0][$j] == "7") {
						$value->exception4_value_detail[0][$j] = "E4.2";
					}
				}
			}
			if (!empty($value->exception5_value_detail[0])) {
				for ($j = 0; $j < count($value->exception5_value_detail[0]); $j++) {
					if ($value->exception5_value_detail[0][$j] == "8") {
						$value->exception5_value_detail[0][$j] = "E5.1";
					}
					if ($value->exception5_value_detail[0][$j] == "9") {
						$value->exception5_value_detail[0][$j] = "E5.2";
					}
				}
			}
			if (!empty($value->exception6_value_detail[0])) {
				for ($j = 0; $j < count($value->exception6_value_detail[0]); $j++) {
					if ($value->exception6_value_detail[0][$j] == "10") {
						$value->exception6_value_detail[0][$j] = "E6.1";
					}
				}
			}
			if (!empty($value->exception7_value_detail[0])) {
				for ($j = 0; $j < count($value->exception7_value_detail[0]); $j++) {
					if ($value->exception7_value_detail[0][$j] == "11") {
						$value->exception7_value_detail[0][$j] = "E7.1";
					}
					if ($value->exception7_value_detail[0][$j] == "12") {
						$value->exception7_value_detail[0][$j] = "E7.2";
					}
					if ($value->exception7_value_detail[0][$j] == "13") {
						$value->exception7_value_detail[0][$j] = "E7.3";
					}
					if ($value->exception7_value_detail[0][$j] == "14") {
						$value->exception7_value_detail[0][$j] = "E7.4";
					}
				}
			}


			unset($created_at_cht);
			unset($created_at_return);
			unset($created_at_cancel);
			unset($created_at_approval);

			if ($value->status_new == "5") {
				$created_at_cht = $value->created_at;
			}
			if ($value->status_new == "8") {
				$created_at_return = $value->created_at;
			}
			if ($value->status_new == "3") {
				$created_at_cancel = $value->created_at;
			}
			if ($value->status_new == "6") {
				$created_at_approval = $value->created_at;
			}

			if (!empty($created_at_cht)) {

				if (!empty($value->contract_id)) {

					$data['contract_id'] = $value->contract_id;

					if (in_array(($data['contract_id']), $arr_check_id) != true) {
						array_push($arr_check_id, $data['contract_id']);
						$count = 0;
					}

					$arr_tgth = $this->api->apiPost($this->userInfo['token'], "hoiso_create/get_create_at_hs", $data);

					$count_tgth = count($arr_tgth->data);
					if ($count < $count_tgth) {
						unset($create_tgth);
						$create_tgth = $arr_tgth->data[$count]->created_at;
						$count++;

					} else {
						unset($create_tgth);
						$count = 0;
					}

					if ($count == $count_tgth) {
						$count = 0;
					}

				}

				if (empty($created_at_approval) || empty($created_at_cancel)) {
					if ($count_tgth != 0) {
						$arr = $created_at_cht;
						continue;
					}

				}
			}

			if (!empty($created_at_return)) {

				$created_at_cht = $arr;

				$create_total_yc = $create_tgth - $created_at_cht;
				$created_at_xl = $created_at_return - $create_tgth;

				unset($arr);
			}

			if (!empty($arr) && !empty($created_at_approval)) {
				$created_at_cht = $arr;
				$create_total_yc = $create_tgth - $created_at_cht;
				$created_at_xl = $created_at_approval - $create_tgth;
				unset($arr);
			}

			if (!empty($arr) && !empty($created_at_cancel)) {
				$created_at_cht = $arr;
				$create_total_yc = $create_tgth - $created_at_cht;
				$created_at_xl = $created_at_cancel - $create_tgth;
				unset($arr);
			}

			if (!empty($create_total_yc)) {
				$years = abs(floor($create_total_yc / 31536000));
				$days = abs(floor(($create_total_yc - ($years * 31536000)) / 86400));
				$hours = abs(floor(($create_total_yc - ($years * 31536000) - ($days * 86400)) / 3600));
			}

			if (!empty($created_at_xl)) {
				$years1 = abs(floor($created_at_xl / 31536000));
				$days1 = abs(floor(($created_at_xl - ($years1 * 31536000)) / 86400));
				$hours1 = abs(floor(($created_at_xl - ($years1 * 31536000) - ($days1 * 86400)) / 3600));
			}

			if (empty($create_tgth)) {
				$email_hs = "";
			}
			if (!empty($value->customer_form_hs) && $value->customer_form_hs != "") {
				if ($email_hs != $value->customer_form_hs) {
					continue;
				}
			}
			if (!empty($value->stores_ad) || $value->stores_ad != "") {
				if ($value->pgd != $value->stores_ad) {
					continue;
				}
			}

			if (!empty($start) && !empty($end)) {
				$start1 = strtotime(trim($start) . ' 00:00:00');
				$end1 = strtotime(trim($end) . ' 23:59:59');
				if ($create_tgth < $start1 || $create_tgth > $end1) {
					continue;
				}
			} else {
				$day_ss = strtotime(trim(date('Y-m-d')) . ' 00:00:00');
				if (!empty($create_tgth)) {
					if ($create_tgth < $day_ss) {
						continue;
					}
				}
			}


			$this->sheet->setCellValue('A' . $i, ($i - 2));
			$this->sheet->setCellValue('B' . $i, !empty($email_hs) ? $email_hs : '');
			$this->sheet->setCellValue('C' . $i, !empty($area) ? $area : '');
			$this->sheet->setCellValue('D' . $i, !empty($value->pgd) ? $value->pgd : '');
			$this->sheet->setCellValue('E' . $i, !empty($value->customer_name) ? $value->customer_name : '');
			$this->sheet->setCellValue('F' . $i, !empty($value->customer_identify) ? $value->customer_identify : '');
			$this->sheet->setCellValue('G' . $i, !empty($value->code_contract) ? $value->code_contract : '');
			$this->sheet->setCellValue('H' . $i, !empty($value->loan_product) ? $value->loan_product : '');
			$this->sheet->setCellValue('I' . $i, !empty($value->amount_money) ? number_format($value->amount_money) : '');
			$this->sheet->setCellValue('J' . $i, !empty($created_at_cht) ? date("d/m/Y H:i:s ", $created_at_cht) : '');
			$this->sheet->setCellValue('K' . $i, !empty($create_tgth) ? date("d/m/Y H:i:s ", $create_tgth) : '');
			$this->sheet->setCellValue('L' . $i, !empty($created_at_return) ? date("d/m/Y H:i:s ", $created_at_return) : '');
			$this->sheet->setCellValue('M' . $i, !empty($created_at_cancel) ? date("d/m/Y H:i:s ", $created_at_cancel) : '');
			$this->sheet->setCellValue('N' . $i, !empty($created_at_approval) ? date("d/m/Y H:i:s ", $created_at_approval) : '');
			$this->sheet->setCellValue('O' . $i, empty($create_tgth) ? "Chưa xử lý" : '');
			$this->sheet->setCellValue('P' . $i, !empty($value->count_return) ? $value->count_return : '');
			$this->sheet->setCellValue('Q' . $i, (!empty($create_total_yc) && !empty($create_tgth)) ? date("i:s ", $create_total_yc) : '');
			$this->sheet->setCellValue('R' . $i, (!empty($created_at_xl) && !empty($create_tgth)) ? date("i:s ", $created_at_xl) : '');
			$this->sheet->setCellValue('S' . $i, !empty($value->error_code[0]) ? implode(",", $value->error_code[0]) : '');
			$this->sheet->setCellValue('T' . $i, !empty($value->new_note) ? $value->new_note : '');
			$this->sheet->setCellValue('U' . $i, (!empty($value->lead_cancel1_C1[0]) ? implode(", ", $value->lead_cancel1_C1[0]) : '') . " " . (!empty($value->lead_cancel1_C2[0]) ? implode(", ", $value->lead_cancel1_C2[0]) : '') . " " . (!empty($value->lead_cancel1_C3[0]) ? implode(", ", $value->lead_cancel1_C3[0]) : '') . " " . (!empty($value->lead_cancel1_C4[0]) ? implode(", ", $value->lead_cancel1_C4[0]) : '') . " " . (!empty($value->lead_cancel1_C5[0]) ? implode(", ", $value->lead_cancel1_C5[0]) : '') . " " . (!empty($value->lead_cancel1_C6[0]) ? implode(", ", $value->lead_cancel1_C6[0]) : '') . " " . (!empty($value->lead_cancel1_C7[0]) ? implode(", ", $value->lead_cancel1_C7[0]) : ''));
			$this->sheet->setCellValue('V' . $i, !empty($reason) ? $reason : "");
			$this->sheet->setCellValue('W' . $i, (!empty($value->exception1_value_detail[0]) ? implode(", ", $value->exception1_value_detail[0]) : "") . " " . (!empty($value->exception2_value_detail[0]) ? implode(", ", $value->exception2_value_detail[0]) : "") . " " . (!empty($value->exception3_value_detail[0]) ? implode(", ", $value->exception3_value_detail[0]) : "") . " " . (!empty($value->exception4_value_detail[0]) ? implode(", ", $value->exception4_value_detail[0]) : "") . " " . (!empty($value->exception5_value_detail[0]) ? implode(", ", $value->exception5_value_detail[0]) : "") . " " . (!empty($value->exception6_value_detail[0]) ? implode(", ", $value->exception6_value_detail[0]) : "") . " " . (!empty($value->exception7_value_detail[0]) ? implode(", ", $value->exception7_value_detail[0]) : ""));

			$i++;
		}
	}

	public function exportCashManagement()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$code = !empty($_GET['code']) ? $_GET['code'] : "";
		$total = !empty($_GET['total']) ? $_GET['total'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$type_transaction = !empty($_GET['type_transaction']) ? $_GET['type_transaction'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";

		$data = array();
		$data['fdate'] = !empty($start) ? $start : date('Y-m-d');
		$data['tdate'] = !empty($end) ? $end : date('Y-m-d');
		$data['code'] = $code;
		$data['total'] = $total;
		$data['store'] = $store;
		$data['type_transaction'] = $type_transaction;
		$data['status'] = $status;
		$data['per_page'] = 10000;
		$transactionData = $this->api->apiPost($this->userInfo['token'], "transaction/get_report_invoice_store_by_day", $data);

		//Calculate to export excel
		if (!empty($transactionData->data_excel)) {
			$this->exportCashManagementDetail($transactionData->data_excel);

			var_dump($start . ' -- ' . $end);
		} else {
			// $this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
			var_dump("Không có dữ liệu để xuất excel");
		}
	}

	public function exportCashManagementDetail($transactionData)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã giao dịch');
		$this->sheet->setCellValue('C1', 'Loại phiếu thu');
		$this->sheet->setCellValue('D1', 'Ngày tạo phiếu thu');
		$this->sheet->setCellValue('E1', 'Người thu');
		$this->sheet->setCellValue('F1', 'Người nộp');
		$this->sheet->setCellValue('G1', 'Phòng giao dịch');
		$this->sheet->setCellValue('H1', 'Tiền thu');
		$this->sheet->setCellValue('I1', 'Trạng thái');
		$this->sheet->setCellValue('J1', 'Ngày duyệt phiếu thu');
		$this->sheet->setCellValue('K1', 'Người duyệt');
		$this->sheet->setCellValue('L1', 'Phương thức thanh toán');
		$this->sheet->setCellValue('M1', 'Ngân hàng');
		$this->sheet->setCellValue('N1', 'Mã giao dịch ngân hàng');
		$this->sheet->setCellValue('O1', 'Ghi chú Phòng giao dịch');
		$this->sheet->setCellValue('P1', 'Ghi chú Kế toán');
		$this->sheet->setCellValue('Q1', 'Mã HĐ');
		$this->sheet->setCellValue('R1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('S1', 'Số điện thoại KH');

		$i = 2;
		foreach ($transactionData as $tran) {
			$method = '';
			if (intval($tran->payment_method) == 0) {
				$method = $tran->payment_method;
			} else {
				if (intval($tran->payment_method) == 1) {
					$method = $this->lang->line('Cash');
				} else if (intval($tran->payment_method) == 2) {
					$method = 'Chuyển khoản';
				}
			}
			$content_billing = '';

			$notes = !empty($tran->note) ? $tran->note : "";
			if (is_array($notes)) {
				foreach ($notes as $note) {
					$content_billing .= billing_content($note);
				}
				$notes = $content_billing;
			} else {
				$notes = $tran->note;
			}
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($tran->code) ? $tran->code : (!empty($tran->transaction_code) ? $tran->transaction_code : (!empty($tran->mic_code) ? $tran->mic_code : "")));
			$this->sheet->setCellValue('C' . $i, !empty($tran->type) ? type_transaction($tran->type) : "");
			$this->sheet->setCellValue('D' . $i, !empty($tran->created_at) ? date('d/m/Y H:i:s', intval($tran->created_at)) : '');
			$this->sheet->setCellValue('E' . $i, !empty($tran->created_by) ? $tran->created_by : "");
			$this->sheet->setCellValue('F' . $i, !empty($tran->name_driver) ? $tran->name_driver : (!empty($tran->customer_name) ? $tran->customer_name : (!empty($tran->customer_bill_name) ? $tran->customer_bill_name : ((!empty($tran->customer_info) ? $tran->customer_info->customer_name : '')))));
			$this->sheet->setCellValue('G' . $i, !empty($tran->store) ? $tran->store->name : "");
			$this->sheet->setCellValue('H' . $i, !empty($tran->money) ? $tran->money : (!empty($tran->total) ? $tran->total : (!empty($tran->mic_fee) ? $tran->mic_fee : (!empty($tran->fee) ? $tran->fee : 0))));
			$this->sheet->setCellValue('I' . $i, !empty($tran->status) ? status_transaction($tran->status) : "");
			$this->sheet->setCellValue('J' . $i, !empty($tran->approved_at) ? date('d/m/Y H:i:s', intval($tran->approved_at)) : '');
			$this->sheet->setCellValue('K' . $i, !empty($tran->approved_by) ? $tran->approved_by : "");
			$this->sheet->setCellValue('L' . $i, !empty($method) ? $method : "Tiền mặt");
			$this->sheet->setCellValue('M' . $i, !empty($tran->bank) ? $tran->bank : "");
			$this->sheet->setCellValue('N' . $i, !empty($tran->code_transaction_bank) ? (string)$tran->code_transaction_bank : 0);
			$this->sheet->setCellValue('O' . $i, $notes);
			$this->sheet->setCellValue('P' . $i, !empty($tran->approve_note) ? $tran->approve_note : "");
			$this->sheet->setCellValue('Q' . $i, !empty($tran->code_contract_disbursement) ? $tran->code_contract_disbursement : "");
			$this->sheet->setCellValue('R' . $i, !empty($tran->code_contract) ? $tran->code_contract : "");
			$this->sheet->setCellValue('S' . $i, !empty($tran->customer_bill_phone) ? hide_phone($tran->customer_bill_phone) : (!empty($tran->customer_info) ? hide_phone($tran->customer_info->customer_phone) : ""));

			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('ReportReceiptByStore_' . time() . '.xlsx');
	}


	public function excel_kt_report()
	{

		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$customer_form_hs = !empty($_GET['customer_form_hs']) ? $_GET['customer_form_hs'] : "";


		$data = array();
		if (!empty($start)) $data['start'] = $start;
		if (!empty($end)) $data['end'] = $end;
		if (!empty($customer_form_hs)) $data['customer_form_hs'] = $customer_form_hs;

		$list_report_kt = $this->api->apiPost($this->userInfo['token'], "exportExcel/export_kt", $data);

		if (!empty($list_report_kt->data)) {
			$this->fcExportList_report_kt($list_report_kt->data, $start, $end);
			$this->callLibExcel("Report - " . date("d/m/Y") . '.xlsx');
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
			echo "Không có dữ liệu để xuất excel";
		}
	}

	public function fcExportList_report_kt($report, $start, $end)
	{
		$this->sheet->mergeCells("H1:J1");

		$this->sheet->mergeCells("A1:A2");
		$this->sheet->mergeCells("B1:B2");
		$this->sheet->mergeCells("C1:C2");
		$this->sheet->mergeCells("D1:D2");
		$this->sheet->mergeCells("E1:E2");
		$this->sheet->mergeCells("F1:F2");
		$this->sheet->mergeCells("G1:G2");
		$this->sheet->mergeCells("K1:K2");
		$this->sheet->mergeCells("L1:L2");
		$this->sheet->mergeCells("M1:M2");


		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Người thực hiện');
		$this->sheet->setCellValue('C1', 'PGD');
		$this->sheet->setCellValue('D1', 'Tên KH');
		$this->sheet->setCellValue('E1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('F1', 'Số tiền YC');
		$this->sheet->setCellValue('G1', 'Thời gian yêu cầu');
		$this->sheet->setCellValue('H1', 'Trạng thái');
		$this->sheet->setCellValue('K1', 'Ghi chú');
		$this->sheet->setCellValue('L1', 'Tổng số lần trả về');
		$this->sheet->setCellValue('M1', 'Tổng thời gian xử lý');

		$this->sheet->setCellValue('H2', 'Trả về');
		$this->sheet->setCellValue('I2', 'Hủy');
		$this->sheet->setCellValue('J2', 'Duyệt');

		$this->sheet->setCellValue('H1', 'Trạng thái');

		$this->setStyle("A1");
		$this->setStyle("A2");
		$this->setStyle("B1");
		$this->setStyle("B2");
		$this->setStyle("C1");
		$this->setStyle("C2");
		$this->setStyle("D1");
		$this->setStyle("D2");
		$this->setStyle("E1");
		$this->setStyle("E2");
		$this->setStyle("F1");
		$this->setStyle("F2");
		$this->setStyle("G1");
		$this->setStyle("G2");
		$this->setStyle("H1");
		$this->setStyle("H2");
		$this->setStyle("I2");
		$this->setStyle("J2");
		$this->setStyle("K1");
		$this->setStyle("K2");
		$this->setStyle("L1");
		$this->setStyle("L2");
		$this->setStyle("M1");
		$this->setStyle("M2");


		$list_kt = $this->api->apiPost($this->userInfo['token'], "exportExcel/get_user_kt");

		$i = 3;
		$check_code_contract = [];
		$arr_check_id = [];

		foreach ($report as $key => $value) {

			if (in_array($value->email, $list_kt->data)) {
				$email_hs = $value->email;
			}

			unset($created_at_gdv);
			unset($created_at_return);
			unset($created_at_cancel);
			unset($created_at_approval);
			unset($created_at_xl);

			if ($value->status_new == "15") {
				$created_at_gdv = $value->created_at;
			}
			if ($value->status_new == "7") {
				$created_at_return = $value->created_at;
			}
			if ($value->status_new == "3") {
				$created_at_cancel = $value->created_at;
			}
			if ($value->status_new == "17") {
				$created_at_approval = $value->created_at;
			}

			if (!empty($created_at_gdv)) {
				if (empty($created_at_approval) || empty($created_at_cancel)) {
					$arr = $created_at_gdv;
					continue;
				}
			}
			if (!empty($created_at_return)) {
				$created_at_gdv = $arr;
				$created_at_xl = abs($created_at_return - $created_at_gdv);
				unset($arr);
			}

			if (!empty($arr) && !empty($created_at_approval)) {
				$created_at_gdv = $arr;
				$created_at_xl = abs($created_at_approval - $created_at_gdv);
				unset($arr);
			}

			if (!empty($arr) && !empty($created_at_cancel)) {
				$created_at_gdv = $arr;
				$created_at_xl = abs($created_at_cancel - $created_at_gdv);
				unset($arr);
			}

			if (!empty($created_at_xl)) {
				$years = floor($created_at_xl / (365 * 60 * 60 * 24));
				$months = floor(($created_at_xl - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
				$days = floor(($created_at_xl - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
				$hours = floor(($created_at_xl - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
				$minutes = floor(($created_at_xl - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
				$seconds = floor(($created_at_xl - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minutes * 60));
			}

			if (!empty($value->customer_form_hs) || $value->customer_form_hs != "") {
				if ($email_hs != $value->customer_form_hs) {
					continue;
				}
			}

			if (!empty($start) && !empty($end)) {
				$start1 = strtotime(trim($start) . ' 00:00:00');
				if (!empty($created_at_approval) && $created_at_approval < $start1) {
					continue;
				}
				if (!empty($created_at_cancel) && $created_at_cancel < $start1) {
					continue;
				}
			}
			$date_time = "";
			if ($seconds != 0) {
				$date_time = "$seconds";
			}
			if ($minutes != 0) {
				$date_time = "$minutes:$seconds";
			}
			if ($hours != 0) {
				$date_time = "$hours:$minutes:$seconds";
			}

			$this->sheet->setCellValue('A' . $i, ($i - 2));
			$this->sheet->setCellValue('B' . $i, !empty($email_hs) ? $email_hs : '');
			$this->sheet->setCellValue('C' . $i, !empty($value->pgd) ? $value->pgd : '');
			$this->sheet->setCellValue('D' . $i, !empty($value->customer_name) ? $value->customer_name : '');
			$this->sheet->setCellValue('E' . $i, !empty($value->code_contract) ? $value->code_contract : '');
			$this->sheet->setCellValue('F' . $i, (!empty($value->new_amount_loan) && $value->new_amount_loan != 0) ? round($value->new_amount_loan) : round($value->amount_loan))
				->getStyle('F' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('G' . $i, !empty($created_at_gdv) ? date("d/m/y H:i:s", $created_at_gdv) : '')
				->getStyle('G' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_HIS);
			$this->sheet->setCellValue('H' . $i, !empty($created_at_return) ? date("d/m/y H:i:s", $created_at_return) : '')
				->getStyle('H' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_HIS);
			$this->sheet->setCellValue('I' . $i, !empty($created_at_cancel) ? date("d/m/y H:i:s", $created_at_cancel) : '')
				->getStyle('I' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_HIS);
			$this->sheet->setCellValue('J' . $i, !empty($created_at_approval) ? date("d/m/y H:i:s", $created_at_approval) : '')
				->getStyle('J' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_HIS);

			$this->sheet->setCellValue('K' . $i, !empty($value->note) ? $value->note : "");
			$this->sheet->setCellValue('L' . $i, !empty($value->count_return) ? $value->count_return : '');
			$this->sheet->setCellValue('M' . $i, !empty($created_at_xl) ? date("$date_time", $created_at_xl) : '');

			$i++;
		}

	}

	public function exportReceiptHeyU()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$code = !empty($_GET['code']) ? $_GET['code'] : "";
		$code_transaction_bank = !empty($_GET['code_transaction_bank']) ? $_GET['code_transaction_bank'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$tab = isset($_GET['tab']) ? $_GET['tab'] : 'all';

		$data = array();
		$data['fdate'] = !empty($start) ? $start : date('Y-m-d');
		$data['tdate'] = !empty($end) ? $end : date('Y-m-d');
		$data['code'] = $code;
		$data['code_transaction_bank'] = $code_transaction_bank;
		$data['store'] = $store;
		$data['tab'] = $tab;
		$data['status'] = $status;
		$data['per_page'] = 10000;
		$transactionData = $this->api->apiPost($this->userInfo['token'], "transaction/get_all_kt_hey_u", $data);
		//Calculate to export excel
		if (!empty($transactionData->data)) {
			$this->exportDataHeyU($transactionData->data);

			var_dump($start . ' -- ' . $end);
		} else {
			// $this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
			var_dump("Không có dữ liệu để xuất excel");
		}
	}

	public function exportDataHeyU($transactionData)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã HĐ');
		$this->sheet->setCellValue('C1', 'Mã Phiếu ghi');
		$this->sheet->setCellValue('D1', 'Tên khách hàng');
		$this->sheet->setCellValue('E1', 'Số tiền phải thanh toán');
		$this->sheet->setCellValue('F1', 'Hạn thanh toán');
		$this->sheet->setCellValue('G1', 'Phòng giao dịch');
		$this->sheet->setCellValue('H1', 'Tổng tiền thanh toán');
		$this->sheet->setCellValue('I1', 'Ngày khách thanh toán');
		$this->sheet->setCellValue('J1', 'Ngày tạo phiếu');
		$this->sheet->setCellValue('K1', 'Phương thức thanh toán');
		$this->sheet->setCellValue('L1', 'Ngân hàng');
		$this->sheet->setCellValue('M1', 'Mã giao dịch ngân hàng');
		$this->sheet->setCellValue('N1', 'Số tiền thực nhận');
		$this->sheet->setCellValue('O1', 'Loại thanh toán');
		$this->sheet->setCellValue('P1', 'Tiến trình xử lý');
		$this->sheet->setCellValue('Q1', 'Ghi chú');
		$this->sheet->setCellValue('R1', 'Mã Phiếu thu');

		$i = 2;
		foreach ($transactionData as $tran) {
			$method = '';
			if (intval($tran->payment_method) == 0) {
				$method = $tran->payment_method;
			} else {
				if (intval($tran->payment_method) == 1) {
					$method = $this->lang->line('Cash');
				} else if (intval($tran->payment_method) == 2) {
					$method = 'Chuyển khoản';
				}
			}

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($tran->code_contract_disbursement) ? $tran->code_contract_disbursement : "");
			$this->sheet->setCellValue('C' . $i, !empty($tran->code_contract) ? $tran->code_contract : "");
			$this->sheet->setCellValue('D' . $i, !empty($tran->full_name) ? $tran->full_name : $tran->customer_bill_name);
			$this->sheet->setCellValue('E' . $i, !empty($tran->detail->total_paid) ? $tran->detail->total_paid : 0);
			$this->sheet->setCellValue('F' . $i, !empty($tran->detail->ngay_ky_tra) ? date('d/m/Y', intval($tran->detail->ngay_ky_tra)) : "");
			$this->sheet->setCellValue('G' . $i, !empty($tran->store) ? $tran->store->name : "");
			$this->sheet->setCellValue('H' . $i, (!empty($tran->total) && $tran->total > 0) ? $tran->total : 0);
			$this->sheet->setCellValue('I' . $i, !empty($tran->date_pay) ? date('d/m/Y H:i:s', intval($tran->date_pay)) : '');
			$this->sheet->setCellValue('J' . $i, !empty($tran->created_at) ? date('d/m/Y H:i:s', intval($tran->created_at)) : '');
			$this->sheet->setCellValue('K' . $i, $method);
			$this->sheet->setCellValue('L' . $i, !empty($tran->bank) ? $tran->bank : '');
			$this->sheet->setCellValue('M' . $i, !empty($tran->code_transaction_bank) ? $tran->code_transaction_bank : "");
			$this->sheet->setCellValue('N' . $i, !empty($tran->amount_actually_received) ? $tran->amount_actually_received : 0);
			$this->sheet->setCellValue('O' . $i, !empty($tran->type) ? type_transaction($tran->type) : "");
			$this->sheet->setCellValue('P' . $i, !empty($tran->status) ? status_transaction($tran->status) : "");
			$this->sheet->setCellValue('Q' . $i, !empty($tran->approve_note) ? $tran->approve_note : "");
			$this->sheet->setCellValue('R' . $i, !empty($tran->code) ? $tran->code : "");

			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('danh-sach-giao-dich-heyu-' . time() . '.xlsx');
	}

	public function exportBillingUtilities()
	{
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "utilities";
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$trading_code = !empty($_GET['trading_code']) ? $_GET['trading_code'] : "";
		$service_name = !empty($_GET['service_name']) ? $_GET['service_name'] : "";
		$publisher_name = !empty($_GET['publisher_name']) ? $_GET['publisher_name'] : "";
		$service_code = !empty($_GET['service_code']) ? $_GET['service_code'] : "";
		$code_transaction = !empty($_GET['code_transaction']) ? $_GET['code_transaction'] : "";
		$filter_by_store = !empty($_GET['filter_by_store']) ? $_GET['filter_by_store'] : "";

		$data = array();
		$data['fdate'] = !empty($fdate) ? $fdate : date('Y-m-d');
		$data['tdate'] = !empty($tdate) ? $tdate : date('Y-m-d');
		$data['tab'] = $tab;
		$data['code'] = $code_transaction;
		$data['service_name'] = $service_name;
		$data['publisher_name'] = $publisher_name;
		$data['service_code'] = $service_code;
		$data['filter_by_store'] = $filter_by_store;
		$data['trading_code'] = $trading_code;
		$data['status'] = $status;
		$data['per_page'] = 10000;
		$transactionData = $this->api->apiPost($this->userInfo['token'], "transaction/get_list_billing_utilities", $data);

		//Calculate to export excel
		if (!empty($transactionData->data)) {
			$this->exportBillingUtilitiestDetail($transactionData->data);

			var_dump($fdate . ' -- ' . $tdate);
		} else {
			// $this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
			var_dump("Không có dữ liệu để xuất excel");
		}
	}

	public function exportBillingUtilitiestDetail($transactionData)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã giao dịch');
		$this->sheet->setCellValue('C1', 'Thời gian nộp tiền');
		$this->sheet->setCellValue('D1', 'Dịch vụ');
		$this->sheet->setCellValue('E1', 'Nhà phát hành');
		$this->sheet->setCellValue('F1', 'Tên khách hàng');
		$this->sheet->setCellValue('G1', 'Số điện thoại');
		$this->sheet->setCellValue('H1', 'Số tiền');
		$this->sheet->setCellValue('I1', 'Người giao dịch');
		$this->sheet->setCellValue('J1', 'Phòng giao dịch');
		$this->sheet->setCellValue('K1', 'Trạng thái');

		$i = 2;
		foreach ($transactionData as $tran) {

			$status = '';
			if ($tran->status == "new") {
				$status = "Chờ thanh toán";
			} else if ($tran->status == "failed") {
				$status = "Thanh toán thất bại";
			} else if ($tran->status == "success") {
				$status = "Thanh toán thành công";
			}

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($tran->mc_request_id) ? $tran->mc_request_id : "");
			$this->sheet->setCellValue('C' . $i, !empty($tran->created_at) ? date('d/m/Y H:i:s', intval($tran->created_at)) : '');
			$this->sheet->setCellValue('D' . $i, !empty($tran->service_name) ? $tran->service_name : "");
			$this->sheet->setCellValue('E' . $i, !empty($tran->publisher_name) ? $tran->publisher_name : "");
			$this->sheet->setCellValue('F' . $i, !empty($tran->customer_bill_name) ? $tran->customer_bill_name : "");
			$this->sheet->setCellValue('G' . $i, !empty($tran->customer_bill_phone) ? hide_phone($tran->customer_bill_phone) : "");
			$this->sheet->setCellValue('H' . $i, !empty($tran->money) ? $tran->money : 0);
			$this->sheet->setCellValue('I' . $i, !empty($tran->created_by) ? $tran->created_by : "");
			$this->sheet->setCellValue('J' . $i, !empty($tran->store->name) ? $tran->store->name : "");
			$this->sheet->setCellValue('K' . $i, !empty($status) ? $status : "");


			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('ReportBillingUtilities_' . time() . '.xlsx');
	}

	public function exportInterestFee()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$data = array();
		$data['fdate'] = !empty($fdate) ? $fdate : date('Y-m-d');
		$data['tdate'] = !empty($tdate) ? $tdate : date('Y-m-d');
		$dataInterestFee = $this->api->apiPost($this->userInfo['token'], "log/get_interest_fee", $data);
		//Calculate to export excel
		if (!empty($dataInterestFee->data)) {
			$this->exportInterestFeeDetail($dataInterestFee->data);
			var_dump($fdate . ' -- ' . $tdate);
		} else {
			// $this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
			var_dump("Không có dữ liệu để xuất excel");
		}
	}

	public function exportInterestFeeDetail($dataInterestFee)
	{
		$this->sheet->setCellValue('A1', 'Tạo từ ngày');
		$this->sheet->setCellValue('B1', 'Hình thức + Sản phẩm');
		$this->sheet->setCellValue('C1', 'Thời gian vay (Số ngày)');
		$this->sheet->setCellValue('D1', 'Lãi NĐT (%)');
		$this->sheet->setCellValue('E1', 'Phí tư vấn (%)');
		$this->sheet->setCellValue('F1', 'Phí thẩm định (%)');
		$this->sheet->setCellValue('G1', 'Phí chậm trả (%)');
		$this->sheet->setCellValue('H1', 'Phí phạt chậm trả (VNĐ)');
		$this->sheet->setCellValue('I1', 'Phí gia hạn (VNĐ)');
		$this->sheet->setCellValue('J1', 'Tất toán trước 01/3 (%)');
		$this->sheet->setCellValue('K1', 'Tất toán trước 01/3 - 02/3 (%)');
		$this->sheet->setCellValue('L1', 'Tất toán sau 02/3 (%)');

		$i = 2;
		$type_loan = "";
		foreach ($dataInterestFee as $key => $interestfee) {
			$this->sheet->setCellValue('A' . $i, !empty($interestfee[0]->created_at) ? date('d/m/Y', $interestfee[0]->created_at) : "");
			foreach ($interestfee[1] as $key1 => $item) {
				$this->sheet->setCellValue('B' . $i, !empty($key1) ? $key1 : "");
				foreach ($item as $key2 => $value) {
					$x = $i++;

					$this->sheet->setCellValue('C' . $x, !empty($key2) ? $key2 : "");
					$this->sheet->setCellValue('D' . $x, !empty($value->percent_interest_customer) ? $value->percent_interest_customer : 0);
					$this->sheet->setCellValue('E' . $x, !empty($value->percent_advisory) ? $value->percent_advisory : 0);
					$this->sheet->setCellValue('F' . $x, !empty($value->percent_expertise) ? $value->percent_expertise : 0);
					$this->sheet->setCellValue('G' . $x, !empty($value->penalty_percent) ? $value->penalty_percent : 0);
					$this->sheet->setCellValue('H' . $x, !empty($value->penalty_amount) ? $value->penalty_amount : 0);
					$this->sheet->setCellValue('I' . $x, !empty($value->extend) ? $value->extend : 0);
					$this->sheet->setCellValue('J' . $x, !empty($value->percent_prepay_phase_1) ? $value->percent_prepay_phase_1 : 0);
					$this->sheet->setCellValue('K' . $x, !empty($value->percent_prepay_phase_2) ? $value->percent_prepay_phase_2 : 0);
					$this->sheet->setCellValue('L' . $x, !empty($value->percent_prepay_phase_3) ? $value->percent_prepay_phase_3 : 0);
				}
				$i++;
			}
		}

		//---------------------------------------------------------------------
		$this->callLibExcel('ReportInterestFee' . time() . '.xlsx');
	}

	public function exportHeyU()
	{
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "";
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$code_driver_filter = !empty($_GET['code_driver_filter']) ? $_GET['code_driver_filter'] : "";
		$name_driver_filter = !empty($_GET['name_driver_filter']) ? $_GET['name_driver_filter'] : "";
		$filter_by_store = !empty($_GET['filter_by_store']) ? $_GET['filter_by_store'] : "";
		$code_heyu = !empty($_GET['code_heyu']) ? $_GET['code_heyu'] : "";
		$data = array();
		$data['start'] = !empty($fdate) ? $fdate : date('Y-m-d');
		$data['end'] = !empty($tdate) ? $tdate : date('Y-m-d');
		$data['tab'] = $tab;
		$data['code_driver_filter'] = $code_driver_filter;
		$data['name_driver_filter'] = $name_driver_filter;
		$data['filter_by_store'] = $filter_by_store;
		$data['code_heyu'] = $code_heyu;

		$data['per_page'] = 10000;
		$heyUData = $this->api->apiPost($this->userInfo['token'], "hey_u/get_list_hey_u", $data);
		//Calculate to export excel
		if (!empty($heyUData->data)) {
			$this->exportHeyUDetail($heyUData->data);

			var_dump($fdate . ' -- ' . $tdate);
		} else {
			// $this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
			var_dump("Không có dữ liệu để xuất excel");
		}
	}

	public function exportHeyUDetail($heyUData)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã giao dịch');
		$this->sheet->setCellValue('C1', 'Thời gian nộp tiền');
		$this->sheet->setCellValue('D1', 'Mã tài xế');
		$this->sheet->setCellValue('E1', 'Tên tài xế');
		$this->sheet->setCellValue('F1', 'Số tiền');
		$this->sheet->setCellValue('G1', 'Người giao dịch');
		$this->sheet->setCellValue('H1', 'Phòng giao dịch');
		$this->sheet->setCellValue('I1', 'Trạng thái');

		$i = 2;
		foreach ($heyUData as $heyu) {

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($heyu->transaction_code) ? $heyu->transaction_code : "");
			$this->sheet->setCellValue('C' . $i, !empty($heyu->created_at) ? date('d/m/Y H:i:s', intval($heyu->created_at)) : '');
			$this->sheet->setCellValue('D' . $i, !empty($heyu->code_driver) ? $heyu->code_driver : "");
			$this->sheet->setCellValue('E' . $i, !empty($heyu->name_driver) ? $heyu->name_driver : "");
			$this->sheet->setCellValue('F' . $i, !empty($heyu->money) ? $heyu->money : "");
			$this->sheet->setCellValue('G' . $i, !empty($heyu->created_by) ? $heyu->created_by : "");
			$this->sheet->setCellValue('H' . $i, !empty($heyu->store->name) ? $heyu->store->name : "");
			$this->sheet->setCellValue('I' . $i, !empty($heyu->status) ? status_transaction($heyu->status) : "");

			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('ExportHeyU' . time() . '.xlsx');
	}

	public function exportHistoryHeyU()
	{
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "";
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$data = array();
		$data['start'] = !empty($fdate) ? $fdate : date('Y-m-d');
		$data['end'] = !empty($tdate) ? $tdate : date('Y-m-d');


		$data['per_page'] = 10000;
		$heyUHistoryData = $this->api->apiPost($this->userInfo['token'], "hey_u/get_history_heyU", $data);
		//Calculate to export excel
		if (!empty($heyUHistoryData->data)) {
			$this->exportHistoryHeyUDetail($heyUHistoryData->data);

			var_dump($fdate . ' -- ' . $tdate);
		} else {
			// $this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
			var_dump("Không có dữ liệu để xuất excel");
		}
	}

	public function exportHistoryHeyUDetail($heyUHistoryData)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã giao dịch');
		$this->sheet->setCellValue('C1', 'Mã phiếu thu');
		$this->sheet->setCellValue('D1', 'Thời gian tạo');
		$this->sheet->setCellValue('E1', 'Mã tài xế');
		$this->sheet->setCellValue('F1', 'Tên tài xế');
		$this->sheet->setCellValue('G1', 'Số tiền');
		$this->sheet->setCellValue('H1', 'Người giao dịch');
		$this->sheet->setCellValue('I1', 'Phòng giao dịch');
		$this->sheet->setCellValue('J1', 'Trạng thái');
		$this->sheet->setCellValue('K1', 'Code đối tác HeyU');

		$i = 2;
		foreach ($heyUHistoryData as $history_heyu) {

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($history_heyu->orderId) ? $history_heyu->orderId : "");
			$this->sheet->setCellValue('C' . $i, !empty($history_heyu->transaction) ? $history_heyu->transaction : "");
			$this->sheet->setCellValue('D' . $i, !empty($history_heyu->created_at) ? date('d/m/Y H:i:s', intval($history_heyu->created_at / 1000)) : '');
			$this->sheet->setCellValue('E' . $i, !empty($history_heyu->name_code) ? $history_heyu->name_code : "");
			$this->sheet->setCellValue('F' . $i, !empty($history_heyu->name) ? $history_heyu->name : "");
			$this->sheet->setCellValue('G' . $i, !empty($history_heyu->amount) ? $history_heyu->amount : "");
			$this->sheet->setCellValue('H' . $i, !empty($history_heyu->created_by) ? $history_heyu->created_by : "");
			$this->sheet->setCellValue('I' . $i, !empty($history_heyu->store) ? $history_heyu->store : "");
			$this->sheet->setCellValue('J' . $i, !empty($history_heyu->status) ? status_transaction($history_heyu->status) : "");
			$this->sheet->setCellValue('K' . $i, !empty($history_heyu->transactionId) ? $history_heyu->transactionId : "");

			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('ExportHistoryHeyU' . time() . '.xlsx');
	}

	public function remind_debt_first()
	{

		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$data = array();
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$data = array(
				"start" => $start,
				"end" => $end,
			);
		}

		$infoContractData = $this->api->apiPost($this->userInfo['token'], "contract/contract_tempo_all_thn", $data);
		if (empty($infoContractData->data)) {
			$this->session->set_flashdata('error', "Không có dữ liệu ");
			redirect(base_url('accountant/remind_debt_first'));
		} else {
			$this->fcExportAllContract_thn($infoContractData->data);
			$this->callLibExcel('data-contract-thn-' . time() . '.xlsx');
		}
	}

	public function fcExportAllContract_thn($dataPawn)
	{

		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('C1', 'Mã hợp đồng');
		$this->sheet->setCellValue('D1', 'Tên khách hàng');
		$this->sheet->setCellValue('E1', 'Số điện thoại');
		$this->sheet->setCellValue('F1', 'Số tiền giải ngân');
		$this->sheet->setCellValue('G1', 'Ngày giải ngân');
		$this->sheet->setCellValue('H1', 'Ngày/tháng/năm sinh');
		$this->sheet->setCellValue('I1', 'Số CMND/CCCD');
		$this->sheet->setCellValue('J1', 'Ngày cấp');
		$this->sheet->setCellValue('K1', 'Địa chỉ hộ khẩu');
		$this->sheet->setCellValue('L1', 'Địa chỉ tạm trú');
		$this->sheet->setCellValue('M1', 'Loại tài sản');
		$this->sheet->setCellValue('N1', 'Biển kiểm soát');
		$this->sheet->setCellValue('O1', 'Số khung');
		$this->sheet->setCellValue('P1', 'Số máy');
		$this->sheet->setCellValue('Q1', 'Địa chỉ PGD');
		$this->sheet->setCellValue('R1', 'Số tiền tính tất toán');


		$i = 2;
		foreach ($dataPawn as $data) {

			$so_khung = "";
			$so_may = "";
			$bien_so_xe = "";

			if (!empty($data->property_infor)) {
				foreach ($data->property_infor as $item) {
					if (!empty($item->value) && $item->slug == 'so-khung') {
						$so_khung = $item->value;
					}
					if (!empty($item->value) && $item->slug == 'so-may') {
						$so_may = $item->value;
					}
					if (!empty($item->value) && $item->slug == 'bien-so-xe') {
						$bien_so_xe = $item->value;
					}
				}

			}

			$houseHold_address = "";
			if ($data->houseHold_address->address_household != "") {
				$houseHold_address = $data->houseHold_address->address_household;
			}
			if ($data->houseHold_address->ward_name != "") {
				$houseHold_address = $data->houseHold_address->address_household . ", " . $data->houseHold_address->ward_name;
			}
			if ($data->houseHold_address->district_name != "") {
				$houseHold_address = $data->houseHold_address->address_household . ", " . $data->houseHold_address->ward_name . ", " . $data->houseHold_address->district_name;
			}
			if ($data->houseHold_address->province_name != "") {
				$houseHold_address = $data->houseHold_address->address_household . ", " . $data->houseHold_address->ward_name . ", " . $data->houseHold_address->district_name . ", " . $data->houseHold_address->province_name;
			}
			$current_address = "";
			if ($data->current_address->current_stay != "") {
				$current_address = $data->current_address->current_stay;
			}
			if ($data->current_address->ward_name != "") {
				$current_address = $data->current_address->current_stay . ", " . $data->current_address->ward_name;
			}
			if ($data->current_address->district_name != "") {
				$current_address = $data->current_address->current_stay . ", " . $data->current_address->ward_name . ", " . $data->current_address->district_name;
			}
			if ($data->current_address->province_name != "") {
				$current_address = $data->current_address->current_stay . ", " . $data->current_address->ward_name . ", " . $data->current_address->district_name . ", " . $data->current_address->province_name;
			}
			// Số tiền tất toán đến ngày xuất
			$du_no_con_lai_tt = 0;
			$tien_lai_tt = 0;
			$tien_phi_tt =
			$tong_tien_thanh_toan_tt = 0;
			$phi_phat_cham_tra_tt = 0;
			$tong_penalty_con_lai = 0;
			$checktt = $this->check_date_pay_finish($data->_id->{'$oid'});

			$du_no_con_lai_tt = !empty($checktt['dataTatToanPart1']->du_no_con_lai) ? $checktt['dataTatToanPart1']->du_no_con_lai : 0;

			$phi_phat_sinh_tt = !empty($checktt['contract']->phi_phat_sinh) ? $checktt['contract']->phi_phat_sinh : 0;
			$phi_phat_tat_toan_truoc_han = !empty($checktt['debtData']->phi_thanh_toan_truoc_han) ? $checktt['debtData']->phi_thanh_toan_truoc_han : 0;

			$tien_du_ky_truoc = !empty($checktt['contract']->tien_du_ky_truoc) ? $checktt['contract']->tien_du_ky_truoc : 0;
			$phi_phat_cham_tra_tt = !empty($checktt['contract']->penalty_pay) ? $checktt['contract']->penalty_pay : 0;
			$tien_chua_tra_ky_thanh_toan = !empty($checktt['contract']->tien_chua_tra_ky_thanh_toan) ? $checktt['contract']->tien_chua_tra_ky_thanh_toan : 0;
			$tien_thua_thanh_toan = !empty($checktt['contract']->tien_thua_thanh_toan) ? $checktt['contract']->tien_thua_thanh_toan : 0;

			$tong_tien_thanh_toan_tt = $du_no_con_lai_tt + $phi_phat_cham_tra_tt + $phi_phat_tat_toan_truoc_han + $phi_phat_sinh_tt + $tien_chua_tra_ky_thanh_toan - $tien_du_ky_truoc - $tien_thua_thanh_toan;


			$this->sheet->setCellValue('A' . $i, $i - 1);
			$this->sheet->setCellValue('B' . $i, !empty($data->code_contract) ? $data->code_contract : "");
			$this->sheet->setCellValue('C' . $i, !empty($data->code_contract_disbursement) ? $data->code_contract_disbursement : '');
			$this->sheet->setCellValue('D' . $i, !empty($data->customer_infor->customer_name) ? $data->customer_infor->customer_name : "");
			$this->sheet->setCellValue('E' . $i, !empty($data->customer_infor->customer_phone_number) ? $data->customer_infor->customer_phone_number : "");
			$this->sheet->setCellValue('F' . $i, !empty($data->loan_infor->amount_loan) ? number_format($data->loan_infor->amount_loan) : 0);
			$this->sheet->setCellValue('G' . $i, !empty($data->disbursement_date) ? date("d/m/Y", $data->disbursement_date) : "");
			$this->sheet->setCellValue('H' . $i, !empty($data->customer_infor->customer_BOD) ? date("d/m/Y", strtotime($data->customer_infor->customer_BOD)) : "");
			$this->sheet->setCellValue('I' . $i, !empty($data->customer_infor->customer_identify) ? $data->customer_infor->customer_identify : "");
			$this->sheet->setCellValue('J' . $i, !empty($data->customer_infor->date_range) ? date("d/m/Y", strtotime($data->customer_infor->date_range)) : "");
			$this->sheet->setCellValue('K' . $i, !empty($houseHold_address) ? $houseHold_address : "");
			$this->sheet->setCellValue('L' . $i, !empty($current_address) ? $current_address : "");
			$this->sheet->setCellValue('M' . $i, !empty($data->loan_infor->type_property->text) ? $data->loan_infor->type_property->text : "");
			$this->sheet->setCellValue('N' . $i, !empty($bien_so_xe) ? ($bien_so_xe) : "");
			$this->sheet->setCellValue('O' . $i, !empty($so_khung) ? $so_khung : "");
			$this->sheet->setCellValue('P' . $i, !empty($so_may) ? $so_may : "");
			$this->sheet->setCellValue('Q' . $i, !empty($data->store->address) ? $data->store->address : "");
			$this->sheet->setCellValue('R' . $i, !empty($tong_tien_thanh_toan_tt) ? number_format($tong_tien_thanh_toan_tt) : 0);

			$i++;
		}

	}

	public function check_date_pay_finish($id_contract)
	{
		$check_tt = [];
		$id_contract = !empty($id_contract) ? $id_contract : "";
		$date_pay = date("y/m/d", $this->createdAt);
		$type_payment = !empty($data['type_payment']) ? $data['type_payment'] : 1;

		$data = array(
			"id" => $id_contract,
			"date_pay" => $date_pay,
			"type_payment" => $type_payment
		);

		$debtData = $this->api->apiPost($this->userInfo['token'], "view_payment/debt_detail", $data);
		if (!empty($debtData->status) && $debtData->status == 200) {
			$check_tt['debtData'] = $debtData->data;
		} else {
			$check_tt['debtData'] = array();
		}

		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", $data);
		$return = $this->api->apiPost($this->userInfo['token'], "view_payment/tempo_detail", $data);
		//Dữ liệu cho tab tất toán
		$tabTatToanPart1 = $this->api->apiPost($this->userInfo['token'], "view_payment/get_infor_tat_toan_part_1", array("code_contract" => $contract->data->code_contract, "date_pay" => $date_pay));
		$tabTatToanPart2 = $this->api->apiPost($this->userInfo['token'], "view_payment/get_infor_tat_toan_part_2", array("code_contract" => $contract->data->code_contract, "date_pay" => $date_pay));

		$countGiaoDichTatToanChoDuyet = $this->api->apiPost($this->userInfo['token'], "view_payment/countGiaoDichTatToanChoDuyet", array("code_contract" => $contract->data->code_contract));
		if ($isDaTatToan == true) {
			$contractDataTatToan = $this->api->apiPost($this->userInfo['token'], "view_payment/get_bang_lai_ky_tat_toan", array("code_contract" => $contract->data->code_contract));
			$check_tt['contractDataTatToan'] = $contractDataTatToan->data;
			//Get transaction_thanh_toan_lai_ky_tai_ki_tat_toan
			$transaction_thanh_toan_lai_ky_tai_ki_tat_toan = $this->api->apiPost($this->userInfo['token'], "view_payment/get_transaction_thanh_toan_lai_ky_tai_ky_tat_toan", array("code_contract" => $contract->data->code_contract));
			$transaction_thanh_toan_lai_ky_tai_ki_tat_toan = (array)$transaction_thanh_toan_lai_ky_tai_ki_tat_toan->data;
			$total_transaction_tat_toan_goc_da_tra = 0;
			$total_transaction_tat_toan_lai_da_tra = 0;
			$total_transaction_tat_toan_phi_da_tra = 0;
			foreach ($transaction_thanh_toan_lai_ky_tai_ki_tat_toan as $item) {
				$total_transaction_tat_toan_goc_da_tra += !empty($item->so_tien_goc_da_tra) ? $item->so_tien_goc_da_tra : 0;
				$total_transaction_tat_toan_lai_da_tra += !empty($item->so_tien_lai_da_tra) ? $item->so_tien_lai_da_tra : 0;
				$total_transaction_tat_toan_phi_da_tra += !empty($item->so_tien_phi_da_tra) ? $item->so_tien_phi_da_tra : 0;
			}
			$check_tt['total_transaction_tat_toan_goc_da_tra'] = $total_transaction_tat_toan_goc_da_tra;
			$check_tt['total_transaction_tat_toan_lai_da_tra'] = $total_transaction_tat_toan_lai_da_tra;
			$check_tt['total_transaction_tat_toan_phi_da_tra'] = $total_transaction_tat_toan_phi_da_tra;
		}
		$check_tt['countGiaoDichTatToanChoDuyet'] = $countGiaoDichTatToanChoDuyet->count;
		$check_tt['dataTatToanPart1'] = $tabTatToanPart1->data;
		$check_tt['dataTatToanPart2'] = $tabTatToanPart2;
		if (!empty($return->status) && $return->status == 200) {
			$check_tt['contract'] = $return->contract;
			return $check_tt;

		}
	}

	public function exportMicTnds()
	{
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "mic_tnds";
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$customer_phone = !empty($_GET['customer_phone']) ? $_GET['customer_phone'] : "";
		$code = !empty($_GET['code']) ? $_GET['code'] : "";
		$code_mic_tnds = !empty($_GET['code_mic_tnds']) ? $_GET['code_mic_tnds'] : "";
		$filter_by_store = !empty($_GET['filter_by_store']) ? $_GET['filter_by_store'] : "";

		$data = array();
		$data['tab'] = $tab;
		$data['customer_name'] = $customer_name;
		$data['customer_phone'] = $customer_phone;
		$data['filter_by_store'] = $filter_by_store;
		$data['code'] = $code;
		$data['code_mic_tnds'] = $code_mic_tnds;

		if (!empty($fdate)) $data['start'] = $fdate;
		if (!empty($tdate)) $data['end'] = $tdate;

		$data['access_token'] = $this->user['token'];
		$cpanelV2 = CpanelV2::getDomain();
		$url = $cpanelV2 . "cpanel/exportExcel/exportMicTnds?";
		$first = true;
		foreach ($data as $key => $value) {
			if ($first) {
				$url .= $key . "=" . $value;
			} else {
				$url .= "&" . $key . "=" . $value;
			}
			$first = false;
		}
		redirect($url);

		// $micTndsData = $this->api->apiPost($this->userInfo['token'], "mic_tnds/get_list_mic_tnds", $data);
		// // var_dump($micTndsData); die();
		// //Calculate to export excel
		// if (!empty($micTndsData->data)) {
		// 	$this->exportMicTNDSDetail($micTndsData->data);

		// 	var_dump($fdate . ' -- ' . $tdate);
		// } else {
		// 	// $this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		// 	var_dump("Không có dữ liệu để xuất excel");
		// }
	}

	public function exportMicTNDSDetail($micTndsData)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã giao dịch');
		$this->sheet->setCellValue('C1', 'Thời gian nộp tiền');
		$this->sheet->setCellValue('D1', 'Tên khách hàng');
		$this->sheet->setCellValue('E1', 'Số điện thoại khách hàng');
		$this->sheet->setCellValue('F1', 'Số tiền');
		$this->sheet->setCellValue('G1', 'Người giao dịch');
		$this->sheet->setCellValue('H1', 'Phòng giao dịch');
		$this->sheet->setCellValue('I1', 'Trạng thái');
		$this->sheet->setCellValue('J1', 'Mã đối soát');

		$i = 2;
		foreach ($micTndsData as $micTnds) {

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($micTnds->mic_code) ? $micTnds->mic_code : "");
			$this->sheet->setCellValue('C' . $i, !empty($micTnds->created_at) ? date('d/m/Y H:i:s', intval($micTnds->created_at)) : '');
			$this->sheet->setCellValue('D' . $i, !empty($micTnds->customer_info->customer_name) ? $micTnds->customer_info->customer_name : "");
			$this->sheet->setCellValue('E' . $i, !empty($micTnds->customer_info->customer_phone) ? hide_phone($micTnds->customer_info->customer_phone) : "");
			$this->sheet->setCellValue('F' . $i, !empty($micTnds->mic_fee) ? $micTnds->mic_fee : "");
			$this->sheet->setCellValue('G' . $i, !empty($micTnds->created_by) ? $micTnds->created_by : "");
			$this->sheet->setCellValue('H' . $i, !empty($micTnds->store->name) ? $micTnds->store->name : "");
			$this->sheet->setCellValue('I' . $i, !empty($micTnds->status) ? status_transaction($micTnds->status) : "");
			$this->sheet->setCellValue('J' . $i, !empty($micTnds->mic_gcn) ? $micTnds->mic_gcn : "");

			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('ExportMicTnds' . time() . '.xlsx');
	}

	public function excel_report_sms_month()
	{
		$fdate_export = !empty($_GET['fdate_export']) ? $_GET['fdate_export'] : "";

		$data = array();
		if (!empty($fdate_export)) $data['fdate_export'] = $fdate_export;


		$listData = $this->api->apiPost($this->userInfo['token'], "sms/report_sms_month", $data);

		if (!empty($listData->data)) {
			$this->fcExporReport_sms_month($listData->data);
			$this->callLibExcel('report-sms-month-' . $data['fdate_export'] . '-' . time() . '.xlsx');
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
			redirect(base_url('sms/report_sms_month'));
		}
	}

	public function fcExporReport_sms_month($listData)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'TÊN KHÁCH HÀNG');
		$this->sheet->setCellValue('C1', 'SỐ HỢP ĐỒNG');
		$this->sheet->setCellValue('D1', 'PHÒNG GIAO DỊCH');
		$this->sheet->setCellValue('E1', 'TỔNG SỐ SMS TRONG THÁNG');


		$i = 2;
		foreach ($listData as $vbi) {


			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($vbi->customer_name) ? $vbi->customer_name : '');
			$this->sheet->setCellValue('C' . $i, !empty($vbi->total_contract_month) ? $vbi->total_contract_month : 0);
			$this->sheet->setCellValue('D' . $i, !empty($vbi->store_name) ? $vbi->store_name : '');
			$this->sheet->setCellValue('E' . $i, !empty($vbi->total_sms_month) ? $vbi->total_sms_month : '');


			$i++;
		}
	}

	public function exportListTnds()
	{
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "mic_tnds";
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$full_name = !empty($_GET['full_name']) ? $_GET['full_name'] : "";
		$phone = !empty($_GET['phone']) ? $_GET['phone'] : "";
		// $code = !empty($_GET['code']) ? $_GET['code'] : "";
		// $code_mic_tnds = !empty($_GET['code_mic_tnds']) ? $_GET['code_mic_tnds'] : "";
		// $filter_by_store = !empty($_GET['filter_by_store']) ? $_GET['filter_by_store'] : "";

		$type_tnds = !empty($_GET['type_tnds']) ? $_GET['type_tnds'] : "";

		$data = array();
		$data['start'] = !empty($fdate) ? $fdate : "";
		$data['end'] = !empty($tdate) ? $tdate : "";
		// $data['tab'] = $tab;
		$data['full_name'] = $full_name;
		$data['phone'] = $phone;
		$data['code_contract_disbursement'] = $code_contract_disbursement;
		$data['type_tnds'] = $type_tnds;
		// $data['filter_by_store'] = $filter_by_store;
		// $data['code'] = $code;
		// $data['code_mic_tnds'] = $code_mic_tnds;


		$data['access_token'] = $this->user['token'];
		$cpanelV2 = CpanelV2::getDomain();
		$url = $cpanelV2 . "cpanel/exportExcel/exportContractTnds?";
		$first = true;
		foreach ($data as $key => $value) {
			if ($first) {
				$url .= $key . "=" . $value;
			} else {
				$url .= "&" . $key . "=" . $value;
			}
			$first = false;
		}
		redirect($url);

		// $data['per_page'] = 10000;
		// $micTndsData = $this->api->apiPost($this->userInfo['token'], "baoHiemTNDS/get_list_tnds", $data);
		// //Calculate to export excel
		// if (!empty($micTndsData->data)) {
		// 	$this->exportListTNDSDetail($micTndsData->data);

		// 	var_dump($fdate . ' -- ' . $tdate);
		// } else {
		// 	// $this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		// 	var_dump("Không có dữ liệu để xuất excel");
		// }
	}

	public function exportListTNDSDetail($micTndsData)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã giao dịch');
		$this->sheet->setCellValue('C1', 'Thời gian nộp tiền');
		$this->sheet->setCellValue('D1', 'Tên khách hàng');
		$this->sheet->setCellValue('E1', 'Số điện thoại khách hàng');
		$this->sheet->setCellValue('F1', 'Số tiền');
		$this->sheet->setCellValue('G1', 'Người giao dịch');
		$this->sheet->setCellValue('H1', 'Phòng giao dịch');
		$this->sheet->setCellValue('I1', 'Trạng thái');
		$this->sheet->setCellValue('J1', 'Người tạo');
		$this->sheet->setCellValue('K1', 'Mã hợp đồng');
		$this->sheet->setCellValue('L1', 'Mã phiếu ghi');

		$i = 2;
		foreach ($micTndsData as $micTnds) {
			// var_dump( $micTnds->contract_info->customer_infor->customer_phone_number); die;
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($micTnds->data->response->SO_ID) ? $micTnds->data->response->SO_ID : $micTnds->data->response->so_hd);
			$this->sheet->setCellValue('C' . $i, !empty($micTnds->created_at) ? date('d/m/Y H:i:s', intval($micTnds->created_at)) : '');
			$this->sheet->setCellValue('D' . $i, !empty($micTnds->contract_info->customer_infor->customer_name) ? $micTnds->contract_info->customer_infor->customer_name : "");
			$this->sheet->setCellValue('E' . $i, !empty($micTnds->contract_info->customer_infor->customer_phone_number) ? $micTnds->contract_info->customer_infor->customer_phone_number : "");
			$this->sheet->setCellValue('F' . $i, !empty($micTnds->data->response->PHI) ? $micTnds->data->response->PHI : $micTnds->data->response->tong_phi);
			$this->sheet->setCellValue('G' . $i, !empty($micTnds->created_by) ? $micTnds->created_by : "");
			$this->sheet->setCellValue('H' . $i, !empty($micTnds->store->name) ? $micTnds->store->name : "");
			$this->sheet->setCellValue('I' . $i, !empty($micTnds->data->response->STATUS) ? $micTnds->data->response->STATUS : $micTnds->data->response->response_message);
			$this->sheet->setCellValue('J' . $i, !empty($micTnds->contract_info->created_by) ? $micTnds->contract_info->created_by : "");
			$this->sheet->setCellValue('K' . $i, !empty($micTnds->contract_info->code_contract_disbursement) ? $micTnds->contract_info->code_contract_disbursement : "");
			$this->sheet->setCellValue('L' . $i, !empty($micTnds->contract_info->code_contract) ? $micTnds->contract_info->code_contract : "");

			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('ExportListTnds' . time() . '.xlsx');
	}

	public function exportLeadTS()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$sdt = !empty($_GET['sdt']) ? $_GET['sdt'] : "";
		$fullname = !empty($_GET['fullname']) ? $_GET['fullname'] : "";
		$reason_cancel = !empty($_GET['reason_cancel']) ? $_GET['reason_cancel'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "not_qualified";
		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('lead_custom/lead_qualified_TS'));
		}
		if (empty($start) && empty($end)) {
			$this->session->set_flashdata('error', 'Ngày tháng không được để trống!');
			redirect(base_url('lead_custom/lead_qualified_TS'));
		}

		$cond = array();
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$cond["start"] = $start;
			$cond["end"] = $end;

		}
		if (!empty($_GET['sdt'])) {
			$cond['sdt'] = $sdt;
		}
		if (!empty($_GET['fullname'])) {
			$cond['fullname'] = $fullname;
		}

		if (!empty($reason_cancel)) {
			$cond["reason_cancel"] = $reason_cancel;
		}
		if (!empty($status)) {
			$cond["status"] = $status;
		}
		if (!empty($tab)) {
			$cond["tab"] = $tab;
		}
		$data = array(
			"condition" => $cond,
		);
		$leadsData = $this->api->apiPost($this->user['token'], "lead_custom/lead_qualified_TS", $cond);

		if (!empty($leadsData->leadsData)) {
			$this->fcExportLeadTS($leadsData->leadsData);
			if ($tab == "list_not_qualified") {
				$this->callLibExcel('DS_Lead_TS_Not_Qualified_' . time() . '.xlsx');
			} else {
				$this->callLibExcel('DS_Lead_TS_Qualified_' . time() . '.xlsx');
			}
		} elseif (empty($start) && empty($end)) {
			$this->session->set_flashdata('error', 'Ngày tháng không được để trống!');
			redirect(base_url('lead_custom/lead_qualified_TS'));
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	public function fcExportLeadTS($leadsData)
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'CSKH');
		$this->sheet->setCellValue('C1', 'NGÀY THÁNG');
		$this->sheet->setCellValue('D1', 'NGUỒN');
		$this->sheet->setCellValue('E1', 'UTM_Source');
		$this->sheet->setCellValue('F1', 'UTM_Campaign');
		$this->sheet->setCellValue('G1', 'KHU VỰC');
		$this->sheet->setCellValue('H1', 'HỌ VÀ TÊN');
		$this->sheet->setCellValue('I1', 'SỐ ĐIỆN THOẠI');
		$this->sheet->setCellValue('J1', 'TRẠNG THÁI LEAD');
		$this->sheet->setCellValue('K1', 'LÝ DO HỦY');
		$this->sheet->setCellValue('L1', 'CHUYỂN ĐẾN PGD');
		$this->sheet->setCellValue('M1', 'TRẠNG THÁI HỢP ĐỒNG GN');
		$this->sheet->setCellValue('N1', 'SỐ TIỀN GN');
		$this->sheet->setCellValue('O1', 'HK_XÃ');
		$this->sheet->setCellValue('P1', 'HK_HUYỆN');
		$this->sheet->setCellValue('Q1', 'HK_TỈNH');
		$this->sheet->setCellValue('R1', 'NS_XÃ');
		$this->sheet->setCellValue('S1', 'NS_HUYỆN');
		$this->sheet->setCellValue('T1', 'NS_TỈNH');
		$this->sheet->setCellValue('U1', 'GHI CHÚ');
		$this->sheet->setCellValue('V1', 'SẢN PHẨM VAY');
		$this->sheet->setCellValue('W1', 'VỊ TRÍ/CHỨC VỤ');
		$this->sheet->setCellValue('X1', 'CMND/CCCD');

		$i = 2;
		foreach ($leadsData as $lead) {
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($lead->updated_by) ? $lead->updated_by : '');
			$this->sheet->setCellValue('C' . $i, !empty($lead->created_at) ? date('d/m/Y H:i:s', $lead->created_at) : "");
			$this->sheet->setCellValue('D' . $i, ($lead->source) ? lead_nguon($lead->source) : '');
			$this->sheet->setCellValue('E' . $i, !empty($lead->utm_source) ? $lead->utm_source : '');
			$this->sheet->setCellValue('F' . $i, !empty($lead->utm_campaign) ? $lead->utm_campaign : '');
			$this->sheet->setCellValue('G' . $i, !empty($lead->area) ? get_province_name_by_code($lead->area) : '');
			$this->sheet->setCellValue('H' . $i, ($lead->fullname) ? $lead->fullname : '');
			$this->sheet->setCellValue('I' . $i, !empty($lead->phone_number) ? $lead->phone_number : "");
			$this->sheet->setCellValue('J' . $i, ($lead->status_sale) ? lead_status((int)$lead->status_sale) : lead_status(0));
			$this->sheet->setCellValue('K' . $i, ($lead->reason_cancel) ? reason($lead->reason_cancel) : '');
			$this->sheet->setCellValue('L' . $i, "");
			$this->sheet->setCellValue('M' . $i, "");
			$this->sheet->setCellValue('N' . $i, (!empty($lead->contract_info[0]->loan_infor->amount_loan) && (!empty($status) && $status > 16)) ? $lead->contract_info[0]->loan_infor->amount_loan : '');
			$this->sheet->setCellValue('O' . $i, !empty($lead->hk_ward) ? get_ward_name_by_code($lead->hk_ward) : '');
			$this->sheet->setCellValue('P' . $i, !empty($lead->hk_district) ? get_district_name_by_code($lead->hk_district) : '');
			$this->sheet->setCellValue('Q' . $i, !empty($lead->hk_province) ? get_province_name_by_code($lead->hk_province) : '');
			$this->sheet->setCellValue('R' . $i, !empty($lead->ns_ward) ? get_ward_name_by_code($lead->ns_ward) : '');
			$this->sheet->setCellValue('S' . $i, !empty($lead->ns_district) ? get_district_name_by_code($lead->ns_district) : '');
			$this->sheet->setCellValue('T' . $i, !empty($lead->ns_province) ? get_province_name_by_code($lead->ns_province) : '');
			$this->sheet->setCellValue('U' . $i, !empty($lead->tls_note) ? ($lead->tls_note) : '');
			$this->sheet->setCellValue('V' . $i, !empty($lead->type_finance) ? lead_type_finance($lead->type_finance) : '');
			$this->sheet->setCellValue('W' . $i, !empty($lead->position) ? ($lead->position) : '');
			$this->sheet->setCellValue('X' . $i, !empty($lead->identify_lead) ? ($lead->identify_lead) : '');
			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('DS_Lead_TS_' . time() . '.xlsx');

	}

	public function exportAllContract_dng()
	{

		$end = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";


		$start = '2019-11-01';
		$endMonth = date('Y-m-t', strtotime($end));
		if (!empty($start) && !empty($endMonth)) {
			$data = array(
				"start" => $start,
				"end" => $endMonth,
			);
		}
		$data['is_export'] = 1;
		$data['ngaygiaingan'] = 2;
		$end = strtotime(trim($endMonth) . ' 23:59:59');
		$data["per_page"] = 10000000;
		// call api get count contract
		$infoContractData = $this->api->apiPost($this->userInfo['token'], "contract/get_all_data", $data);
		if (empty($infoContractData->data)) {
			$this->session->set_flashdata('error', "Không có dữ liệu ");
			redirect(base_url('accountant'));
		} else {

			$this->fcExportAllContract_dng($infoContractData->data, $end);
			$this->callLibExcel('data-contract-du-no-goc-' . $createBy . time() . '.xlsx');
		}
	}

	public function fcExportAllContract_dng($dataPawn, $end)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã HĐ gốc');
		$this->sheet->setCellValue('C1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('D1', 'PGD');
		$this->sheet->setCellValue('E1', 'Ngày giải ngân');
		$this->sheet->setCellValue('F1', 'Trạng thái');
		$this->sheet->setCellValue('G1', 'Hình thức');
		$this->sheet->setCellValue('H1', 'Ngân hàng');
		$this->sheet->setCellValue('I1', 'Chi nhánh');
		$this->sheet->setCellValue('J1', 'Số tài khoản');
		$this->sheet->setCellValue('K1', 'Tên chủ tài khoản');
		$this->sheet->setCellValue('L1', 'Số thẻ ATM');
		$this->sheet->setCellValue('M1', 'Tên chủ thẻ ATM');
		$this->sheet->setCellValue('N1', 'Tên NĐT');
		$this->sheet->setCellValue('O1', 'Mã NĐT');
		$this->sheet->setCellValue('P1', 'Phân loại KH');
		$this->sheet->setCellValue('Q1', 'Tên khách hàng');
		$this->sheet->setCellValue('R1', 'SĐT');
		$this->sheet->setCellValue('S1', 'Email');
		$this->sheet->setCellValue('T1', 'Số CMND');
		$this->sheet->setCellValue('U1', 'Giới tính');
		$this->sheet->setCellValue('V1', 'Ngày sinh');
		$this->sheet->setCellValue('W1', 'Tình trạng hôn nhân');
		$this->sheet->setCellValue('X1', 'Tỉnh/Thành phố');
		$this->sheet->setCellValue('Y1', 'Quận/Huyện');
		$this->sheet->setCellValue('Z1', 'Phường/Xã');
		$this->sheet->setCellValue('AA1', 'Thôn/Xóm/Tổ');
		$this->sheet->setCellValue('AB1', 'Hình thức cứ trú');
		$this->sheet->setCellValue('AC1', 'Thời gian sinh sống');
		$this->sheet->setCellValue('AD1', 'Tỉnh/Thành phố');
		$this->sheet->setCellValue('AE1', 'Quận/Huyện');
		$this->sheet->setCellValue('AF1', 'Phường/Xã');
		$this->sheet->setCellValue('AG1', 'Thôn/Xóm/Tổ');
		$this->sheet->setCellValue('AH1', 'Tên công ty');
		$this->sheet->setCellValue('AI1', 'Địa chỉ');
		$this->sheet->setCellValue('AJ1', 'SĐT');
		$this->sheet->setCellValue('AK1', 'Vị trí/Chức vụ');
		$this->sheet->setCellValue('AL1', 'Thu nhập');
		$this->sheet->setCellValue('AM1', 'Hình thức nhận lương');
		$this->sheet->setCellValue('AN1', 'Họ và tên');
		$this->sheet->setCellValue('AO1', 'Mối quan hệ');
		$this->sheet->setCellValue('AP1', 'SĐT');
		$this->sheet->setCellValue('AQ1', 'Địa chỉ');
		$this->sheet->setCellValue('AR1', 'Phản hồi');
		$this->sheet->setCellValue('AS1', 'Họ và tên');
		$this->sheet->setCellValue('AT1', 'Mối quan hệ');
		$this->sheet->setCellValue('AU1', 'SĐT');
		$this->sheet->setCellValue('AV1', 'Địa chỉ');
		$this->sheet->setCellValue('AW1', 'Phản hồi');
		$this->sheet->setCellValue('AX1', 'Hình thức');
		$this->sheet->setCellValue('AY1', 'Loại tài sản');
		$this->sheet->setCellValue('AZ1', 'Tên tài sản');
		$this->sheet->setCellValue('BA1', 'Số tiền vay');
		$this->sheet->setCellValue('BB1', 'Hình thức trả lãi');
		$this->sheet->setCellValue('BC1', 'Thời gian vay');
		$this->sheet->setCellValue('BD1', 'Mục đích vay');
		$this->sheet->setCellValue('BE1', 'Nhãn hiệu');
		$this->sheet->setCellValue('BF1', 'Model');
		$this->sheet->setCellValue('BG1', 'Biển số xe');
		$this->sheet->setCellValue('BH1', 'Số khung');
		$this->sheet->setCellValue('BI1', 'Số máy');
		$this->sheet->setCellValue('BJ1', 'Thẩm định hồ sơ');
		$this->sheet->setCellValue('BK1', 'Thẩm định thức địa');
		$this->sheet->setCellValue('BL1', 'Lãi suất NĐT');
		$this->sheet->setCellValue('BM1', 'Phí tư vấn');
		$this->sheet->setCellValue('BN1', 'Phí thẩm định và lưu trữ tài sản');
		$this->sheet->setCellValue('BO1', 'Phí quản lý số tiền vay chậm trả (%)');
		$this->sheet->setCellValue('BP1', 'Phí quản lý số tiền vay chậm trả (tối thiểu)');
		$this->sheet->setCellValue('BQ1', 'Phí tất toán trước hạn (trước 1/3)');
		$this->sheet->setCellValue('BR1', 'Phí tất toán trước hạn (trước 2/3)');
		$this->sheet->setCellValue('BS1', 'Phí tất toán trước hạn (còn lại)');
		$this->sheet->setCellValue('BT1', 'Phí tư vấn gia hạn');
		$this->sheet->setCellValue('BU1', 'Người tạo');
		$this->sheet->setCellValue('BV1', 'Nguồn khách hàng');
		$this->sheet->setCellValue('BW1', 'Trạng thái khách hàng');
		$this->sheet->setCellValue('BX1', 'Họ tên chủ xe');
		$this->sheet->setCellValue('BY1', 'Địa chỉ đăng ký');
		$this->sheet->setCellValue('BZ1', 'Số đăng ký');
		$this->sheet->setCellValue('CA1', 'Ngày cấp');
		$this->sheet->setCellValue('CB1', 'Khu vực');
		$this->sheet->setCellValue('CC1', 'Vùng');
		$this->sheet->setCellValue('CD1', 'Miền');
		$this->sheet->setCellValue('CE1', 'Gốc còn');
		$this->sheet->setCellValue('CF1', 'Bucket');
		$this->sheet->setCellValue('CG1', 'Số ngày trễ');
		$this->sheet->setCellValue('CH1', 'Sản phẩm');


		$i = 2;
		foreach ($dataPawn as $data) {
			if (!in_array((int)$data->status, [10, 11, 12, 13, 14, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 37, 38, 39, 40, 41, 42]))
				continue;

			$customer_resources = !empty($data->customer_infor->customer_resources) ? $data->customer_infor->customer_resources : "";
			$resources = "";
			if ($customer_resources == '1') {
				$resources = "Digital";
			}
			if ($customer_resources == '2') {
				$resources = "TLS Tự kiếm";
			}
			if ($customer_resources == '3') {
				$resources = "Tổng đài";
			}
			if ($customer_resources == '4') {
				$resources = "Giới thiệu";
			}
			if ($customer_resources == '5') {
				$resources = "Đối tác";
			}
			if ($customer_resources == '6') {
				$resources = "Fanpage";
			}
			if ($customer_resources == '7') {
				$resources = "Nguồn khác";
			}
			if ($customer_resources == '8') {
				$resources = "KH vãng lai";
			}
			if ($customer_resources == '9') {
				$resources = "KH tự kiếm";
			}
			if ($customer_resources == '10') {
				$resources = "Cộng tác viên";
			}
			if ($customer_resources == '11') {
				$resources = "KH giới thiệu KH";
			}
			if ($customer_resources == '12') {
				$resources = "Nguồn App Mobile";
			}
			if ($customer_resources == 'VM') {
				$resources = "Nguồn vay mượn";
			}
			if ($customer_resources == 'hoiso') {
				$resources = "Nguồn hội sở";
			}
			if ($customer_resources == 'tukiem') {
				$resources = "Nguồn tự kiếm";
			}
			if ($customer_resources == 'vanglai') {
				$resources = "Nguồn vãng lai";
			}
			$so_khung = "";
			$so_may = "";
			$bien_so_xe = "";
			$model = "";
			$nhan_hieu = "";
			$ho_ten_chu_xe = "";
			$dia_chi_dang_ky = "";
			$so_dang_ky = "";
			$ngay_cap = "";
			$status_customer = "";
			$marital_status = "";
			$type_interest = "";
			$receive_salary_via = "";
			$customer_gender = "";
			if (!empty($data->customer_infor->status_customer)) {
				if ($data->customer_infor->status_customer == 1) {
					$status_customer = "Khách hàng mới";
				} else {
					$status_customer = "Khách hàng cũ";
				}
			}
			if (!empty($data->customer_infor->marriage)) {
				if ($data->customer_infor->marriage == 1) {
					$marital_status = "Đã kết hôn";
				} elseif ($data->customer_infor->marriage == 2) {
					$marital_status = "Chưa kết hôn";
				} else {
					$marital_status = "Ly hôn";
				}
			}
			if (!empty($data->loan_infor->type_interest)) {
				if ($data->loan_infor->type_interest == 1) {
					$type_interest = "Lãi hàng tháng, gốc hàng tháng";
				} else {
					$type_interest = "Lãi hàng tháng, gốc cuối kỳ";
				}
			}
			if (!empty($data->job_infor->receive_salary_via)) {
				if ($data->job_infor->receive_salary_via == 1) {
					$receive_salary_via = "Tiền mặt";
				} else {
					$receive_salary_via = "Chuyển khoản";
				}
			}
			if (!empty($data->customer_infor->customer_gender)) {
				if ($data->customer_infor->customer_gender == 1) {
					$customer_gender = "Nam";
				} else {
					$customer_gender = "Nữ";
				}
			}


			if (!empty($data->property_infor)) {
				foreach ($data->property_infor as $item) {
					if (empty($item->value)) {

					}
					if (!empty($item->value) && $item->slug == 'so-khung') {
						$so_khung = $item->value;
					}
					if (!empty($item->value) && $item->slug == 'so-may') {
						$so_may = $item->value;
					}
					if (!empty($item->value) && $item->slug == 'bien-so-xe') {
						$bien_so_xe = $item->value;
					}
					if (!empty($item->value) && $item->slug == 'model') {
						$model = $item->value;
					}
					if (!empty($item->value) && $item->slug == 'nhan-hieu') {
						$nhan_hieu = $item->value;
					}
					if (!empty($item->value) && $item->slug == 'ho-ten-chu-xe') {
						$ho_ten_chu_xe = $item->value;
					}
					if (!empty($item->value) && $item->slug == 'dia-chi-dang-ky') {
						$dia_chi_dang_ky = $item->value;
					}
					if (!empty($item->value) && $item->slug == 'so-dang-ky') {
						$so_dang_ky = $item->value;
					}
					if (!empty($item->value) && $item->slug == 'ngay-cap') {
						$ngay_cap = $item->value;
					}
				}

			}
			$bucket = "";
			$du_no_goc_con = $this->contract_model->get_du_no_goc($data->code_contract, $end);
			$so_ngay_cham_tra = (!empty($data->debt->so_ngay_cham_tra)) ? $data->debt->so_ngay_cham_tra : 0;

			$bucket = get_bucket($so_ngay_cham_tra);

			$san_pham = (!empty($data->loan_infor->loan_product->text)) ? $data->loan_infor->loan_product->text : '';
			$store_id = (!empty($data->store->id)) ? $data->store->id : '';
			$store = $this->api->apiPost($this->userInfo['token'], "store/get_store", array('id' => $store_id));
			$code_area = (!empty($store->data->code_area)) ? $store->data->code_area : '';
			$area = $this->api->apiPost($this->userInfo['token'], "area/get_area_by_code", array('code' => $code_area));
			$vung = (!empty($area->data->region->name)) ? $area->data->region->name : '';
			$mien = (!empty($area->data->domain->name)) ? $area->data->domain->name : '';
			$khu_vuc = (!empty($area->data->title)) ? $area->data->title : '';
			$this->sheet->setCellValue('A' . $i, $i - 1);
			$this->sheet->setCellValue('B' . $i, !empty($data->code_contract_disbursement) ? $data->code_contract_disbursement : $data->code_contract);
			$this->sheet->setCellValue('C' . $i, !empty($data->code_contract) ? $data->code_contract : '');
			$this->sheet->setCellValue('D' . $i, !empty($data->store->name) ? $data->store->name : "");
			$this->sheet->setCellValue('E' . $i, !empty($data->disbursement_date) ? date("d/m/Y", $data->disbursement_date) : "");
			$this->sheet->setCellValue('F' . $i, !empty($data->status) ? $data->status : "");
			$this->sheet->setCellValue('G' . $i, !empty($data->receiver_infor->type_payout) ? $data->receiver_infor->type_payout : "");
			$this->sheet->setCellValue('H' . $i, !empty($data->receiver_infor->bank_name) ? $data->receiver_infor->bank_name : "");
			$this->sheet->setCellValue('I' . $i, !empty($data->receiver_infor->bank_branch) ? $data->receiver_infor->bank_branch : "");
			$this->sheet->setCellValue('J' . $i, !empty($data->receiver_infor->bank_account) ? hide_phone($data->receiver_infor->bank_account) : "");
			$this->sheet->setCellValue('K' . $i, !empty($data->receiver_infor->bank_account_holder) ? $data->receiver_infor->bank_account_holder : "");
			$this->sheet->setCellValue('L' . $i, !empty($data->receiver_infor->atm_card_number) ? hide_phone($data->receiver_infor->atm_card_number) : "");
			$this->sheet->setCellValue('M' . $i, !empty($data->receiver_infor->atm_card_holder) ? ($data->receiver_infor->atm_card_holder) : "");
			$this->sheet->setCellValue('N' . $i, !empty($data->investor_infor->name) ? $data->investor_infor->name : "");
			$this->sheet->setCellValue('O' . $i, !empty($data->investor_infor->dentity_card) ? $data->investor_infor->dentity_card : "");
			$this->sheet->setCellValue('P' . $i, "");
			$this->sheet->setCellValue('Q' . $i, !empty($data->customer_infor->customer_name) ? $data->customer_infor->customer_name : "");
			$this->sheet->setCellValue('R' . $i, !empty($data->customer_infor->customer_phone_number) ? $data->customer_infor->customer_phone_number : "");
			$this->sheet->setCellValue('S' . $i, !empty($data->customer_infor->customer_email) ? $data->customer_infor->customer_email : "");
			$this->sheet->setCellValue('T' . $i, !empty($data->customer_infor->customer_identify) ? $data->customer_infor->customer_identify : "");
			$this->sheet->setCellValue('U' . $i, !empty($customer_gender) ? $customer_gender : "");
			$this->sheet->setCellValue('V' . $i, !empty($data->customer_infor->customer_BOD) ? $data->customer_infor->customer_BOD : "");
			$this->sheet->setCellValue('W' . $i, !empty($marital_status) ? $marital_status : "");
			$this->sheet->setCellValue('X' . $i, !empty($data->current_address->province_name) ? $data->current_address->province_name : "");
			$this->sheet->setCellValue('Y' . $i, !empty($data->current_address->district_name) ? $data->current_address->district_name : "");
			$this->sheet->setCellValue('Z' . $i, !empty($data->current_address->ward_name) ? $data->current_address->ward_name : "");
			$this->sheet->setCellValue('AA' . $i, !empty($data->current_address->current_stay) ? $data->current_address->current_stay : "");
			$this->sheet->setCellValue('AB' . $i, !empty($data->current_address->form_residence) ? $data->current_address->form_residence : "");
			$this->sheet->setCellValue('AC' . $i, !empty($data->current_address->time_life) ? $data->current_address->time_life : "");
			$this->sheet->setCellValue('AD' . $i, !empty($data->houseHold_address->province_name) ? $data->houseHold_address->province_name : "");
			$this->sheet->setCellValue('AE' . $i, !empty($data->houseHold_address->district_name) ? $data->houseHold_address->district_name : "");
			$this->sheet->setCellValue('AF' . $i, !empty($data->houseHold_address->ward_name) ? $data->houseHold_address->ward_name : "");
			$this->sheet->setCellValue('AG' . $i, !empty($data->houseHold_address->address_household) ? $data->houseHold_address->address_household : "");
			$this->sheet->setCellValue('AH' . $i, !empty($data->job_infor->name_company) ? $data->job_infor->name_company : "");
			$this->sheet->setCellValue('AI' . $i, !empty($data->job_infor->address_company) ? $data->job_infor->address_company : "");
			$this->sheet->setCellValue('AJ' . $i, !empty($data->job_infor->phone_number_company) ? hide_phone($data->job_infor->phone_number_company) : "");
			$this->sheet->setCellValue('AK' . $i, !empty($data->job_infor->job) ? $data->job_infor->job : "");
			$this->sheet->setCellValue('AL' . $i, !empty($data->job_infor->salary) ? $data->job_infor->salary : "");
			$this->sheet->setCellValue('AM' . $i, !empty($receive_salary_via) ? $receive_salary_via : "");
			$this->sheet->setCellValue('AN' . $i, !empty($data->relative_infor->fullname_relative_1) ? $data->relative_infor->fullname_relative_1 : "");
			$this->sheet->setCellValue('AO' . $i, !empty($data->relative_infor->type_relative_1) ? $data->relative_infor->type_relative_1 : "");
			$this->sheet->setCellValue('AP' . $i, !empty($data->relative_infor->phone_number_relative_1) ? hide_phone($data->relative_infor->phone_number_relative_1) : "");
			$this->sheet->setCellValue('AQ' . $i, !empty($data->relative_infor->hoursehold_relative_1) ? $data->relative_infor->hoursehold_relative_1 : "");
			$this->sheet->setCellValue('AR' . $i, !empty($data->relative_infor->confirm_relativeInfor_1) ? $data->relative_infor->confirm_relativeInfor_1 : "");
			$this->sheet->setCellValue('AS' . $i, !empty($data->relative_infor->fullname_relative_2) ? $data->relative_infor->fullname_relative_2 : "");
			$this->sheet->setCellValue('AT' . $i, !empty($data->relative_infor->type_relative_2) ? $data->relative_infor->type_relative_2 : "");
			$this->sheet->setCellValue('AU' . $i, !empty($data->relative_infor->phone_number_relative_2) ? hide_phone($data->relative_infor->phone_number_relative_2) : "");
			$this->sheet->setCellValue('AV' . $i, !empty($data->relative_infor->hoursehold_relative_2) ? $data->relative_infor->hoursehold_relative_2 : "");
			$this->sheet->setCellValue('AW' . $i, !empty($data->relative_infor->confirm_relativeInfor_2) ? $data->relative_infor->confirm_relativeInfor_2 : "");
			$this->sheet->setCellValue('AX' . $i, !empty($data->loan_infor->type_loan->code) ? $data->loan_infor->type_loan->code : "");
			$this->sheet->setCellValue('AY' . $i, !empty($data->loan_infor->type_property->text) ? $data->loan_infor->type_property->text : "");
			$this->sheet->setCellValue('AZ' . $i, !empty($data->loan_infor->name_property->text) ? $data->loan_infor->name_property->text : "");
			$this->sheet->setCellValue('BA' . $i, !empty($data->loan_infor->amount_money) ? $data->loan_infor->amount_money : "");
			$this->sheet->setCellValue('BB' . $i, !empty($type_interest) ? $type_interest : "");
			$this->sheet->setCellValue('BC' . $i, !empty($data->loan_infor->number_day_loan) ? $data->loan_infor->number_day_loan / 30 : "");
			$this->sheet->setCellValue('BD' . $i, !empty($data->loan_infor->loan_purpose) ? $data->loan_infor->loan_purpose : "");
			$this->sheet->setCellValue('BE' . $i, $nhan_hieu);
			$this->sheet->setCellValue('BF' . $i, $model);
			$this->sheet->setCellValue('BG' . $i, $bien_so_xe);
			$this->sheet->setCellValue('BH' . $i, $so_khung);
			$this->sheet->setCellValue('BI' . $i, $so_may);
			$this->sheet->setCellValue('BJ' . $i, "");
			$this->sheet->setCellValue('BK' . $i, "");
			$this->sheet->setCellValue('BL' . $i, !empty($data->fee->percent_interest_customer) ? $data->fee->percent_interest_customer : "");
			$this->sheet->setCellValue('BM' . $i, !empty($data->fee->percent_advisory) ? $data->fee->percent_advisory : "");
			$this->sheet->setCellValue('BN' . $i, !empty($data->fee->percent_expertise) ? $data->fee->percent_expertise : "");
			$this->sheet->setCellValue('BO' . $i, !empty($data->fee->penalty_percent) ? $data->fee->penalty_percent : "");
			$this->sheet->setCellValue('BP' . $i, !empty($data->fee->penalty_amount) ? $data->fee->penalty_amount : "");
			$this->sheet->setCellValue('BQ' . $i, !empty($data->fee->percent_prepay_phase_1) ? $data->fee->percent_prepay_phase_1 : "");
			$this->sheet->setCellValue('BR' . $i, !empty($data->fee->percent_prepay_phase_2) ? $data->fee->percent_prepay_phase_2 : "");
			$this->sheet->setCellValue('BS' . $i, !empty($data->fee->percent_prepay_phase_3) ? $data->fee->percent_prepay_phase_3 : "");
			$this->sheet->setCellValue('BT' . $i, !empty($data->fee->extend) ? $data->fee->extend : "");
			$this->sheet->setCellValue('BU' . $i, !empty($data->created_by) ? $data->created_by : "");
			$this->sheet->setCellValue('BV' . $i, !empty($resources) ? $resources : "");
			$this->sheet->setCellValue('BW' . $i, !empty($status_customer) ? $status_customer : "");
			$this->sheet->setCellValue('BX' . $i, !empty($ho_ten_chu_xe) ? $ho_ten_chu_xe : "");
			$this->sheet->setCellValue('BY' . $i, !empty($dia_chi_dang_ky) ? $dia_chi_dang_ky : "");
			$this->sheet->setCellValue('BZ' . $i, !empty($so_dang_ky) ? $so_dang_ky : "");
			$this->sheet->setCellValue('CA' . $i, !empty($ngay_cap) ? date("d/m/Y", $ngay_cap) : "");
			$this->sheet->setCellValue('CB' . $i, !empty($khu_vuc) ? $khu_vuc : "");
			$this->sheet->setCellValue('CC' . $i, !empty($vung) ? $vung : "");
			$this->sheet->setCellValue('CD' . $i, !empty($mien) ? $mien : "");
			$this->sheet->setCellValue('CE' . $i, !empty($du_no_goc_con) ? $du_no_goc_con : "");
			$this->sheet->setCellValue('CF' . $i, !empty($bucket) ? $bucket : "");
			$this->sheet->setCellValue('CG' . $i, !empty($so_ngay_cham_tra) ? $so_ngay_cham_tra : "");
			$this->sheet->setCellValue('CH' . $i, !empty($san_pham) ? $san_pham : "");


			$i++;
		}

	}

	public function exportGic_plt()
	{
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "mic_tnds";
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$customer_phone = !empty($_GET['customer_phone']) ? $_GET['customer_phone'] : "";
		$code = !empty($_GET['code']) ? $_GET['code'] : "";
		$code_gic_plt = !empty($_GET['code_gic_plt']) ? $_GET['code_gic_plt'] : "";
		$filter_by_store = !empty($_GET['filter_by_store']) ? $_GET['filter_by_store'] : "";

		$data = array();
		$data['start'] = !empty($fdate) ? $fdate : '';
		$data['end'] = !empty($tdate) ? $tdate : '';
		$data['tab'] = $tab;
		$data['customer_name'] = $customer_name;
		$data['customer_phone'] = $customer_phone;
		$data['filter_by_store'] = $filter_by_store;
		$data['code'] = $code;
		$data['code_gic_plt'] = $code_gic_plt;

		$data['per_page'] = 10000;
		$micTndsData = $this->api->apiPost($this->userInfo['token'], "gic_plt_bn/get_list_gic_plt", $data);
		//Calculate to export excel
		if (!empty($micTndsData->data)) {
			$this->exportGic_pltDetail($micTndsData->data);

			var_dump($fdate . ' -- ' . $tdate);
		} else {
			// $this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
			var_dump("Không có dữ liệu để xuất excel");
		}
	}

	public function exportGic_pltDetail($micTndsData)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã giao dịch');
		$this->sheet->setCellValue('C1', 'Thời gian nộp tiền');
		$this->sheet->setCellValue('D1', 'Tên khách hàng');
		$this->sheet->setCellValue('E1', 'Số điện thoại khách hàng');
		$this->sheet->setCellValue('F1', 'Số tiền');
		$this->sheet->setCellValue('G1', 'Người giao dịch');
		$this->sheet->setCellValue('H1', 'Phòng giao dịch');
		$this->sheet->setCellValue('I1', 'Trạng thái');


		$i = 2;
		foreach ($micTndsData as $micTnds) {

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($micTnds->gic_code) ? $micTnds->gic_code : "");
			$this->sheet->setCellValue('C' . $i, !empty($micTnds->created_at) ? date('d/m/Y H:i:s', intval($micTnds->created_at)) : '');
			$this->sheet->setCellValue('D' . $i, !empty($micTnds->customer_info->customer_name) ? $micTnds->customer_info->customer_name : "");
			$this->sheet->setCellValue('E' . $i, !empty($micTnds->customer_info->customer_phone) ? hide_phone($micTnds->customer_info->customer_phone) : "");
			$this->sheet->setCellValue('F' . $i, !empty($micTnds->price) ? $micTnds->price : "");
			$this->sheet->setCellValue('G' . $i, !empty($micTnds->created_by) ? $micTnds->created_by : "");
			$this->sheet->setCellValue('H' . $i, !empty($micTnds->store->name) ? $micTnds->store->name : "");
			$this->sheet->setCellValue('I' . $i, !empty($micTnds->status) ? status_transaction($micTnds->status) : "");

			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('exportGic_plt_bn_' . time() . '.xlsx');
	}

	public function exportGic_easy()
	{
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "gic_easy";
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$customer_phone = !empty($_GET['customer_phone']) ? $_GET['customer_phone'] : "";
		$code = !empty($_GET['code']) ? $_GET['code'] : "";
		$code_gic_easy = !empty($_GET['code_gic_easy']) ? $_GET['code_gic_easy'] : "";
		$filter_by_store = !empty($_GET['filter_by_store']) ? $_GET['filter_by_store'] : "";

		$data = array();
		$data['start'] = !empty($fdate) ? $fdate : '';
		$data['end'] = !empty($tdate) ? $tdate : '';
		$data['tab'] = $tab;
		$data['customer_name'] = $customer_name;
		$data['customer_phone'] = $customer_phone;
		$data['filter_by_store'] = $filter_by_store;
		$data['code'] = $code;
		$data['code_gic_easy'] = $code_gic_easy;

		$data['per_page'] = 10000;
		$micTndsData = $this->api->apiPost($this->userInfo['token'], "gic_easy_bn/get_list_gic_easy", $data);
		//Calculate to export excel
		if (!empty($micTndsData->data)) {
			$this->exportGic_easyDetail($micTndsData->data);

			var_dump($fdate . ' -- ' . $tdate);
		} else {
			// $this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
			var_dump("Không có dữ liệu để xuất excel");
		}
	}

	public function exportGic_easyDetail($micTndsData)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã giao dịch');
		$this->sheet->setCellValue('C1', 'Thời gian nộp tiền');
		$this->sheet->setCellValue('D1', 'Tên khách hàng');
		$this->sheet->setCellValue('E1', 'Số điện thoại khách hàng');
		$this->sheet->setCellValue('F1', 'Số tiền');
		$this->sheet->setCellValue('G1', 'Người giao dịch');
		$this->sheet->setCellValue('H1', 'Phòng giao dịch');
		$this->sheet->setCellValue('I1', 'Trạng thái');


		$i = 2;
		foreach ($micTndsData as $micTnds) {

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($micTnds->gic_code) ? $micTnds->gic_code : "");
			$this->sheet->setCellValue('C' . $i, !empty($micTnds->created_at) ? date('d/m/Y H:i:s', intval($micTnds->created_at)) : '');
			$this->sheet->setCellValue('D' . $i, !empty($micTnds->customer_info->customer_name) ? $micTnds->customer_info->customer_name : "");
			$this->sheet->setCellValue('E' . $i, !empty($micTnds->customer_info->customer_phone) ? hide_phone($micTnds->customer_info->customer_phone) : "");
			$this->sheet->setCellValue('F' . $i, !empty($micTnds->price) ? $micTnds->price : "");
			$this->sheet->setCellValue('G' . $i, !empty($micTnds->created_by) ? $micTnds->created_by : "");
			$this->sheet->setCellValue('H' . $i, !empty($micTnds->store->name) ? $micTnds->store->name : "");
			$this->sheet->setCellValue('I' . $i, !empty($micTnds->status) ? status_transaction($micTnds->status) : "");

			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('exportGic_easy_bn_' . time() . '.xlsx');
	}

	public function exportPti_vta()
	{
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "pti_vta";
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$customer_phone = !empty($_GET['customer_phone']) ? $_GET['customer_phone'] : "";
		$code = !empty($_GET['code']) ? $_GET['code'] : "";
		$code_pti_vta = !empty($_GET['code_pti_vta']) ? $_GET['code_pti_vta'] : "";
		$filter_by_store = !empty($_GET['filter_by_store']) ? $_GET['filter_by_store'] : "";
		$customer_cmt = !empty($_GET['customer_cmt']) ? $_GET['customer_cmt'] : "";
		$customer_name_another = !empty($_GET['customer_name_another']) ? $_GET['customer_name_another'] : "";
		$filter_by_status = !empty($_GET['filter_by_status']) ? $_GET['filter_by_status'] : "";
		$filter_by_sell_per = !empty($_GET['filter_by_sell_per']) ? $_GET['filter_by_sell_per'] : "";
		$data = array();
		$data['start'] = !empty($fdate) ? $fdate : '';
		$data['end'] = !empty($tdate) ? $tdate : '';
		$data['tab'] = $tab;
		$data['customer_name'] = $customer_name;
		$data['customer_phone'] = $customer_phone;
		$data['filter_by_store'] = $filter_by_store;
		$data['code'] = $code;
		$data['code_pti_vta'] = $code_pti_vta;
		$data['customer_cmt'] = $customer_cmt;
		$data['customer_name_another'] = $customer_name_another;
		$data['filter_by_status'] = $filter_by_status;
		$data['filter_by_sell_per'] = $filter_by_sell_per;

		$data['per_page'] = 10000;
		$pti_vtaData = $this->api->apiPost($this->userInfo['token'], "pti_vta/get_list_pti_vta", $data);
		//Calculate to export excel
		if (!empty($pti_vtaData->data) && $tab == "pti_vta") {
			$this->exportPti_vtaDetail($pti_vtaData->data);

			var_dump($fdate . ' -- ' . $tdate);
		} else {
			// $this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
			var_dump("Không có dữ liệu để xuất excel");
		}
	}

	public function exportPti_vtaDetail($micTndsData)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã giao dịch');
		$this->sheet->setCellValue('C1', 'Thời gian nộp tiền');
		$this->sheet->setCellValue('D1', 'Tên khách hàng');
		$this->sheet->setCellValue('E1', 'Số điện thoại khách hàng');
		$this->sheet->setCellValue('F1', 'Số tiền');
		$this->sheet->setCellValue('G1', 'Người giao dịch');
		$this->sheet->setCellValue('H1', 'Phòng giao dịch');
		$this->sheet->setCellValue('I1', 'Trạng thái');
		$this->sheet->setCellValue('J1', 'Người tạo');


		$i = 2;
		foreach ($micTndsData as $micTnds) {

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($micTnds->pti_code) ? $micTnds->pti_code : "");
			$this->sheet->setCellValue('C' . $i, !empty($micTnds->created_at) ? date('d/m/Y H:i:s', intval($micTnds->created_at)) : '');
			$this->sheet->setCellValue('D' . $i, !empty($micTnds->customer_info->customer_name) ? $micTnds->customer_info->customer_name : "");
			$this->sheet->setCellValue('E' . $i, !empty($micTnds->customer_info->customer_phone) ? hide_phone($micTnds->customer_info->customer_phone) : "");
			$this->sheet->setCellValue('F' . $i, !empty($micTnds->price) ? $micTnds->price : "");
			$this->sheet->setCellValue('G' . $i, !empty($micTnds->created_by) ? $micTnds->created_by : "");
			$this->sheet->setCellValue('H' . $i, !empty($micTnds->store->name) ? $micTnds->store->name : "");
			$this->sheet->setCellValue('I' . $i, !empty($micTnds->status) ? status_transaction($micTnds->status) : "");
			$this->sheet->setCellValue('J' . $i, !empty($micTnds->type_pti == "HD") ? $micTnds->contract_info->created_by : $micTnds->created_by);

			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('exportPti_vta_bn_' . time() . '.xlsx');
	}

	public function exportListPti_vta_hd()
	{
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "pti_vta";
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$code_contract_disbursement = !empty($_GET["code_contract_disbursement"]) ? $_GET["code_contract_disbursement"] : "";

		$data = array();
		$data['start'] = !empty($fdate) ? $fdate : "";
		$data['end'] = !empty($tdate) ? $tdate : "";
		$data['code_contract_disbursement'] = !empty($code_contract_disbursement) ? $code_contract_disbursement : "";

		$data['per_page'] = 10000;
		$micTndsData = $this->api->apiPost($this->userInfo['token'], "pti_vta/get_list_pti_vta_hd", $data);
		//Calculate to export excel
		if (!empty($micTndsData->data)) {
			$this->exportPti_vta_hdDetail($micTndsData->data);

			var_dump($fdate . ' -- ' . $tdate);
		} else {
			// $this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
			var_dump("Không có dữ liệu để xuất excel");
		}
	}

	public function exportPti_vta_hdDetail($micTndsData)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã bảo hiểm');
		$this->sheet->setCellValue('C1', 'Thời gian nộp tiền');
		$this->sheet->setCellValue('D1', 'Tên khách hàng');
		$this->sheet->setCellValue('E1', 'Số điện thoại khách hàng');
		$this->sheet->setCellValue('F1', 'Số tiền');
		$this->sheet->setCellValue('G1', 'Gói phí');
		$this->sheet->setCellValue('H1', 'Thời hạn bảo hiểm');
		$this->sheet->setCellValue('I1', 'Ngày sinh');
		$this->sheet->setCellValue('J1', 'Giới tính');
		$this->sheet->setCellValue('K1', 'CMT/CCCD');
		$this->sheet->setCellValue('L1', 'Email');
		$this->sheet->setCellValue('M1', 'Trạng thái');
		$this->sheet->setCellValue('N1', 'Ngày hiệu lực');
		$this->sheet->setCellValue('O1', 'Ngày kết thúc');
		$this->sheet->setCellValue('P1', 'Ngày tạo');
		$this->sheet->setCellValue('Q1', 'Người tạo');
		$this->sheet->setCellValue('R1', 'Người giao dịch');
		$this->sheet->setCellValue('S1', 'Phòng giao dịch');
		$this->sheet->setCellValue('T1', 'Trạng thái hợp đồng vay');
		$this->sheet->setCellValue('U1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('V1', 'Mã hợp đồng');

		$i = 2;
		foreach ($micTndsData as $micTnds) {
			$gender = '';
			if (!empty($micTnds->contract_info->customer_infor->customer_gender) && $micTnds->contract_info->customer_infor->customer_gender == 1) {
				$gender = "Nam";
			} else {
				$gender = "Nữ";
			}
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($micTnds->pti_code) ? $micTnds->pti_code : "");
			$this->sheet->setCellValue('C' . $i, !empty($micTnds->created_at) ? date('d/m/Y H:i:s', intval($micTnds->created_at)) : '');
			$this->sheet->setCellValue('D' . $i, !empty($micTnds->contract_info->customer_infor->customer_name) ? $micTnds->contract_info->customer_infor->customer_name : "");
			$this->sheet->setCellValue('E' . $i, !empty($micTnds->contract_info->customer_infor->customer_phone_number) ? hide_phone($micTnds->contract_info->customer_infor->customer_phone_number) : "");
			$this->sheet->setCellValue('F' . $i, !empty($micTnds->contract_info->loan_infor->bao_hiem_pti_vta->price_pti_vta) ? $micTnds->contract_info->loan_infor->bao_hiem_pti_vta->price_pti_vta : "");
			$this->sheet->setCellValue('G' . $i, !empty($micTnds->contract_info->loan_infor->bao_hiem_pti_vta->code_pti_vta) ? $micTnds->contract_info->loan_infor->bao_hiem_pti_vta->code_pti_vta : "");
			$this->sheet->setCellValue('H' . $i, !empty($micTnds->contract_info->loan_infor->bao_hiem_pti_vta->year_pti_vta) ? $micTnds->contract_info->loan_infor->bao_hiem_pti_vta->year_pti_vta : "");
			$this->sheet->setCellValue('I' . $i, !empty($micTnds->contract_info->customer_infor->customer_BOD) ? $micTnds->contract_info->customer_infor->customer_BOD : "");
			$this->sheet->setCellValue('J' . $i, !empty($gender) ? $gender : "");
			$this->sheet->setCellValue('K' . $i, !empty($micTnds->contract_info->customer_infor->customer_identify) ? $micTnds->contract_info->customer_infor->customer_identify : "");
			$this->sheet->setCellValue('L' . $i, !empty($micTnds->contract_info->customer_infor->customer_email) ? $micTnds->contract_info->customer_infor->customer_email : "");
			$this->sheet->setCellValue('M' . $i, !empty($micTnds->status) ? status_transaction($micTnds->status) : "");
			$this->sheet->setCellValue('N' . $i, !empty($micTnds->NGAY_HL) ? $micTnds->NGAY_HL : "");
			$this->sheet->setCellValue('O' . $i, !empty($micTnds->NGAY_KT) ? $micTnds->NGAY_KT : "");
			$this->sheet->setCellValue('P' . $i, !empty($micTnds->created_at) ? date('m/d/Y H:i:s', $micTnds->created_at) : "");
			$this->sheet->setCellValue('Q' . $i, !empty($micTnds->created_by) ? $micTnds->created_by : "");
			$this->sheet->setCellValue('R' . $i, !empty($micTnds->contract_info->created_by) && $micTnds->type_pti == "HD" ? $micTnds->contract_info->created_by : $micTnds->created_by);
			$this->sheet->setCellValue('S' . $i, !empty($micTnds->store->name) ? $micTnds->store->name : "");
			$this->sheet->setCellValue('T' . $i, !empty($micTnds->contract_info->status) ? contract_status($micTnds->contract_info->status) : "");
			$this->sheet->setCellValue('U' . $i, !empty($micTnds->code_contract) ? $micTnds->code_contract : "");
			$this->sheet->setCellValue('V' . $i, !empty($micTnds->contract_info->code_contract_disbursement) ? $micTnds->contract_info->code_contract_disbursement : "");

			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('exportPti_vta_hd_' . time() . '.xlsx');
	}

	public function exportVbiUtvBn()
	{
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "vbi_utv";
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$customer_phone = !empty($_GET['customer_phone']) ? $_GET['customer_phone'] : "";
		$code = !empty($_GET['code']) ? $_GET['code'] : "";
		$filter_by_store = !empty($_GET['filter_by_store']) ? $_GET['filter_by_store'] : "";

		$data = array();
		$data['start'] = !empty($fdate) ? $fdate : '';
		$data['end'] = !empty($tdate) ? $tdate : '';
		$data['tab'] = $tab;
		$data['customer_name'] = $customer_name;
		$data['customer_phone'] = $customer_phone;
		$data['filter_by_store'] = $filter_by_store;
		$data['code'] = $code;

		$data['access_token'] = $this->user['token'];
		$cpanelV2 = CpanelV2::getDomain();
		$url = $cpanelV2 . "cpanel/exportExcel/exportVbiUtvBn?";
		$first = true;
		foreach ($data as $key => $value) {
			if ($first) {
				$url .= $key . "=" . $value;
			} else {
				$url .= "&" . $key . "=" . $value;
			}
			$first = false;
		}
		redirect($url);


		// $data['per_page'] = 10000;
		// $vbiUtvBnData = $this->api->apiPost($this->userInfo['token'], "vbi_utv/get_list_vbi_utv", $data);
		// //Calculate to export excel
		// if (!empty($vbiUtvBnData->data)) {
		// 	$this->exportVbiUtvBnDetail($vbiUtvBnData->data);

		// 	var_dump($fdate . ' -- ' . $tdate);
		// } else {
		// 	// $this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		// 	var_dump("Không có dữ liệu để xuất excel");
		// }
	}

	public function exportVbiUtvBnDetail($vbiUtvBnData)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã giao dịch');
		$this->sheet->setCellValue('C1', 'Số hợp đồng VBI');
		$this->sheet->setCellValue('D1', 'Số GCN');
		$this->sheet->setCellValue('E1', 'Ngày phát sinh');
		$this->sheet->setCellValue('F1', 'Ngày hiệu lực');
		$this->sheet->setCellValue('G1', 'Ngày kết thúc');
		$this->sheet->setCellValue('H1', 'Gói bảo hiểm');
		$this->sheet->setCellValue('I1', 'CMT/MST');
		$this->sheet->setCellValue('J1', 'Tên khách hàng');
		$this->sheet->setCellValue('K1', 'Ngày sinh');
		$this->sheet->setCellValue('L1', 'Địa chỉ');
		$this->sheet->setCellValue('M1', 'Điện thoại');
		$this->sheet->setCellValue('N1', 'EMAIL');
		$this->sheet->setCellValue('O1', 'Phí bảo hiểm');
		$this->sheet->setCellValue('P1', 'Tổng cộng');
		$this->sheet->setCellValue('Q1', 'Số hợp đồng đối tác');
		$this->sheet->setCellValue('R1', 'ID đối tác');
		$this->sheet->setCellValue('S1', 'ID giao dịch');
		$this->sheet->setCellValue('T1', 'Người giao dịch');
		$this->sheet->setCellValue('U1', 'Phòng giao dịch');
		$this->sheet->setCellValue('V1', 'Trạng thái');
		$this->sheet->setCellValue('W1', 'Trạng thái VBI');
		$this->sheet->setCellValue('X1', 'Người tạo');


		$i = 2;
		foreach ($vbiUtvBnData as $vbi_utv) {
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($vbi_utv->code) ? $vbi_utv->code : "");
			$this->sheet->setCellValue('C' . $i, !empty($vbi_utv->vbi_utv->so_hd) ? $vbi_utv->vbi_utv->so_hd : "");
			$this->sheet->setCellValue('D' . $i, !empty($vbi_utv->vbi_utv->GCNS[0]->so_gcn) ? $vbi_utv->vbi_utv->GCNS[0]->so_gcn : "");
			$this->sheet->setCellValue('E' . $i, !empty($vbi_utv->created_at) ? date('d/m/Y H:i:s', intval($vbi_utv->created_at)) : '');
			$this->sheet->setCellValue('F' . $i, !empty($vbi_utv->NGAY_HL) ? date('d/m/Y', strtotime($vbi_utv->NGAY_HL)) : "");
			$this->sheet->setCellValue('G' . $i, !empty($vbi_utv->NGAY_KT) ? date('d/m/Y', strtotime($vbi_utv->NGAY_KT)) : "");
			$this->sheet->setCellValue('H' . $i, !empty($vbi_utv->goi_bh) ? $vbi_utv->goi_bh : "");
			$this->sheet->setCellValue('I' . $i, !empty($vbi_utv->customer_info->cmt) ? $vbi_utv->customer_info->cmt : "");
			$this->sheet->setCellValue('J' . $i, !empty($vbi_utv->customer_info->customer_name) ? $vbi_utv->customer_info->customer_name : "");
			$this->sheet->setCellValue('K' . $i, !empty($vbi_utv->customer_info->ngay_sinh) ? date('d/m/Y', intval($vbi_utv->customer_info->ngay_sinh)) : "");
			$this->sheet->setCellValue('L' . $i, !empty($vbi_utv->customer_info->address) ? $vbi_utv->customer_info->address : "");
			$this->sheet->setCellValue('M' . $i, !empty($vbi_utv->gic_code) ? $vbi_utv->gic_code : "");
			$this->sheet->setCellValue('M' . $i, !empty($vbi_utv->customer_info->customer_phone) ? ($vbi_utv->customer_info->customer_phone) : "");
			$this->sheet->setCellValue('N' . $i, !empty($vbi_utv->customer_info->email) ? $vbi_utv->customer_info->email : "");
			$this->sheet->setCellValue('O' . $i, !empty($vbi_utv->fee) ? $vbi_utv->fee : "");
			$this->sheet->setCellValue('P' . $i, !empty($vbi_utv->vbi_utv->tong_phi) ? $vbi_utv->vbi_utv->tong_phi : "");
			$this->sheet->setCellValue('Q' . $i, !empty($vbi_utv->vbi_utv->GCNS[0]->so_id_dt_dtac) ? $vbi_utv->vbi_utv->GCNS[0]->so_id_dt_dtac : "");
			$this->sheet->setCellValue('R' . $i, !empty($vbi_utv->vbi_utv->GCNS[0]->so_id_dt_dtac) ? $vbi_utv->vbi_utv->GCNS[0]->so_id_dt_dtac : "");
			$this->sheet->setCellValue('S' . $i, !empty($vbi_utv->vbi_utv->GCNS[0]->so_id_dt_vbi) ? $vbi_utv->vbi_utv->GCNS[0]->so_id_dt_vbi : "");
			$this->sheet->setCellValue('T' . $i, !empty($vbi_utv->created_by) ? $vbi_utv->created_by : "");
			$this->sheet->setCellValue('U' . $i, !empty($vbi_utv->store->name) ? $vbi_utv->store->name : "");
			$this->sheet->setCellValue('V' . $i, !empty($vbi_utv->status) ? status_transaction($vbi_utv->status) : "");
			$this->sheet->setCellValue('W' . $i, !empty($vbi_utv->vbi_utv->response_message) ? ($vbi_utv->vbi_utv->response_message) : "");
			$this->sheet->setCellValue('X' . $i, !empty($vbi_utv->contract_info->created_by) ? ($vbi_utv->contract_info->created_by) : "");

			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('exportVbi_utv_bn_' . time() . '.xlsx');
	}

	public function exportVbiSxhBn()
	{
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "vbi_utv";
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$customer_phone = !empty($_GET['customer_phone']) ? $_GET['customer_phone'] : "";
		$code = !empty($_GET['code']) ? $_GET['code'] : "";
		$filter_by_store = !empty($_GET['filter_by_store']) ? $_GET['filter_by_store'] : "";

		$data = array();
		$data['tab'] = $tab;
		$data['customer_name'] = $customer_name;
		$data['customer_phone'] = $customer_phone;
		$data['filter_by_store'] = $filter_by_store;
		$data['code'] = $code;

		if (!empty($fdate)) $data['start'] = $fdate;
		if (!empty($tdate)) $data['end'] = $tdate;

		$data['access_token'] = $this->user['token'];
		$cpanelV2 = CpanelV2::getDomain();
		$url = $cpanelV2 . "cpanel/exportExcel/exportVbiSxhBn?";
		$first = true;
		foreach ($data as $key => $value) {
			if ($first) {
				$url .= $key . "=" . $value;
			} else {
				$url .= "&" . $key . "=" . $value;
			}
			$first = false;
		}
		redirect($url);


		// $data['per_page'] = 10000;
		// $vbiSxhBnData = $this->api->apiPost($this->userInfo['token'], "vbi_sxh/get_list_vbi_sxh", $data);
		// //Calculate to export excel
		// if (!empty($vbiSxhBnData->data)) {
		// 	$this->exportVbiSxhBnDetail($vbiSxhBnData->data);

		// 	var_dump($fdate . ' -- ' . $tdate);
		// } else {
		// 	// $this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		// 	var_dump("Không có dữ liệu để xuất excel");
		// }
	}

	public function exportVbiSxhBnDetail($vbiSxhBnData)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã giao dịch');
		$this->sheet->setCellValue('C1', 'Số hợp đồng VBI');
		$this->sheet->setCellValue('D1', 'Số GCN');
		$this->sheet->setCellValue('E1', 'Ngày phát sinh');
		$this->sheet->setCellValue('F1', 'Ngày hiệu lực');
		$this->sheet->setCellValue('G1', 'Ngày kết thúc');
		$this->sheet->setCellValue('H1', 'Gói bảo hiểm');
		$this->sheet->setCellValue('I1', 'CMT/MST');
		$this->sheet->setCellValue('J1', 'Tên khách hàng');
		$this->sheet->setCellValue('K1', 'Ngày sinh');
		$this->sheet->setCellValue('L1', 'Địa chỉ');
		$this->sheet->setCellValue('M1', 'Điện thoại');
		$this->sheet->setCellValue('N1', 'EMAIL');
		$this->sheet->setCellValue('O1', 'Phí bảo hiểm');
		$this->sheet->setCellValue('P1', 'Tổng cộng');
		$this->sheet->setCellValue('Q1', 'Số hợp đồng đối tác');
		$this->sheet->setCellValue('R1', 'ID đối tác');
		$this->sheet->setCellValue('S1', 'ID giao dịch');
		$this->sheet->setCellValue('T1', 'Người giao dịch');
		$this->sheet->setCellValue('U1', 'Phòng giao dịch');
		$this->sheet->setCellValue('V1', 'Trạng thái');
		$this->sheet->setCellValue('W1', 'Trạng thái VBI');
		$this->sheet->setCellValue('X1', 'Người tạo');


		$i = 2;
		foreach ($vbiSxhBnData as $vbi_sxh) {
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($vbi_sxh->code) ? $vbi_sxh->code : "");
			$this->sheet->setCellValue('C' . $i, !empty($vbi_sxh->vbi_sxh->so_hd) ? $vbi_sxh->vbi_sxh->so_hd : "");
			$this->sheet->setCellValue('D' . $i, !empty($vbi_sxh->vbi_sxh->GCNS[0]->so_gcn) ? $vbi_sxh->vbi_sxh->GCNS[0]->so_gcn : "");
			$this->sheet->setCellValue('E' . $i, !empty($vbi_sxh->created_at) ? date('d/m/Y H:i:s', intval($vbi_sxh->created_at)) : '');
			$this->sheet->setCellValue('F' . $i, !empty($vbi_sxh->NGAY_HL) ? date('d/m/Y', strtotime($vbi_sxh->NGAY_HL)) : "");
			$this->sheet->setCellValue('G' . $i, !empty($vbi_sxh->NGAY_KT) ? date('d/m/Y', strtotime($vbi_sxh->NGAY_KT)) : "");
			$this->sheet->setCellValue('H' . $i, !empty($vbi_sxh->goi_bh) ? $vbi_sxh->goi_bh : "");
			$this->sheet->setCellValue('I' . $i, !empty($vbi_sxh->customer_info->cmt) ? $vbi_sxh->customer_info->cmt : "");
			$this->sheet->setCellValue('J' . $i, !empty($vbi_sxh->customer_info->customer_name) ? $vbi_sxh->customer_info->customer_name : "");
			$this->sheet->setCellValue('K' . $i, !empty($vbi_sxh->customer_info->ngay_sinh) ? date('d/m/Y', intval($vbi_sxh->customer_info->ngay_sinh)) : "");
			$this->sheet->setCellValue('L' . $i, !empty($vbi_sxh->customer_info->address) ? $vbi_sxh->customer_info->address : "");
			$this->sheet->setCellValue('M' . $i, !empty($vbi_sxh->gic_code) ? $vbi_sxh->gic_code : "");
			$this->sheet->setCellValue('M' . $i, !empty($vbi_sxh->customer_info->customer_phone) ? ($vbi_sxh->customer_info->customer_phone) : "");
			$this->sheet->setCellValue('N' . $i, !empty($vbi_sxh->customer_info->email) ? $vbi_sxh->customer_info->email : "");
			$this->sheet->setCellValue('O' . $i, !empty($vbi_sxh->fee) ? $vbi_sxh->fee : "");
			$this->sheet->setCellValue('P' . $i, !empty($vbi_sxh->vbi_sxh->tong_phi) ? $vbi_sxh->vbi_sxh->tong_phi : "");
			$this->sheet->setCellValue('Q' . $i, !empty($vbi_sxh->vbi_sxh->GCNS[0]->so_id_dt_dtac) ? $vbi_sxh->vbi_sxh->GCNS[0]->so_id_dt_dtac : "");
			$this->sheet->setCellValue('R' . $i, !empty($vbi_sxh->vbi_sxh->GCNS[0]->so_id_dt_dtac) ? $vbi_sxh->vbi_sxh->GCNS[0]->so_id_dt_dtac : "");
			$this->sheet->setCellValue('S' . $i, !empty($vbi_sxh->vbi_sxh->GCNS[0]->so_id_dt_vbi) ? $vbi_sxh->vbi_sxh->GCNS[0]->so_id_dt_vbi : "");
			$this->sheet->setCellValue('T' . $i, !empty($vbi_sxh->created_by) ? $vbi_sxh->created_by : "");
			$this->sheet->setCellValue('U' . $i, !empty($vbi_sxh->store->name) ? $vbi_sxh->store->name : "");
			$this->sheet->setCellValue('V' . $i, !empty($vbi_sxh->status) ? status_transaction($vbi_sxh->status) : "");
			$this->sheet->setCellValue('W' . $i, !empty($vbi_sxh->vbi_sxh->response_message) ? ($vbi_sxh->vbi_sxh->response_message) : "");
			$this->sheet->setCellValue('X' . $i, !empty($vbi_sxh->contract_info->created_by) ? ($vbi_sxh->contract_info->created_by) : "");

			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('exportVbi_sxh_bn_' . time() . '.xlsx');
	}

	public function exportContractAssignCall()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$getStore = !empty($_GET['store']) ? $_GET['store'] : "";
		$phone_number = !empty($_GET['phone_number']) ? $_GET['phone_number'] : "";
		$status_contract = !empty($_GET['status_contract']) ? $_GET['status_contract'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$bucket = !empty($_GET['bucket']) ? $_GET['bucket'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		//	$customer_phone_number= !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "assigned";

		$data = array();
		$data['start'] = !empty($fdate) ? $fdate : "";
		$data['end'] = !empty($tdate) ? $tdate : "";
		$data['store'] = !empty($getStore) ? $getStore : '';
		$data['status_contract'] = !empty($status_contract) ? $status_contract : '';
		$data['status'] = !empty($status) ? $status : '';
		$data['bucket'] = !empty($bucket) ? $bucket : '';
		$data['customer_name'] = !empty($customer_name) ? $customer_name : '';
		$data['phone_number'] = !empty($phone_number) ? $phone_number : '';
		$data['code_contract_disbursement'] = !empty($code_contract_disbursement) ? $code_contract_disbursement : '';
		$data['code_contract'] = !empty($code_contract) ? $code_contract : '';
		$data['tab'] = !empty($tab) ? $tab : '';

		$data['per_page'] = 10000;
		$contract_debt_call = $this->api->apiPost($this->userInfo['token'], 'DebtCall/get_all_contract_call', $data);
		if (!empty($contract_debt_call->data)) {
			$this->exportContractDebtCall($contract_debt_call->data);

			var_dump($fdate . ' -- ' . $tdate);
		} else {
			var_dump("Không có dữ liệu để xuất excel");
		}
	}

	public function exportContractDebtCall($contractDebtCall)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('C1', 'Mã hợp đồng');
		$this->sheet->setCellValue('D1', 'Tên khách hàng');
		$this->sheet->setCellValue('E1', 'Trạng thái hợp đồng');
		$this->sheet->setCellValue('F1', 'Trạng thái duyệt');
		$this->sheet->setCellValue('G1', 'Nhân viên Call');
		$this->sheet->setCellValue('H1', 'Phòng giao dịch');
		$this->sheet->setCellValue('I1', 'Nhóm ');
		$this->sheet->setCellValue('J1', 'Số ngày chậm trả');
		$this->sheet->setCellValue('K1', 'Gốc còn lại');
		$this->sheet->setCellValue('L1', 'Email call');
		$this->sheet->setCellValue('M1', 'Trạng thái gọi');

		$i = 2;
		foreach ($contractDebtCall as $contract_call) {
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($contract_call->code_contract) ? $contract_call->code_contract : "");
			$this->sheet->setCellValue('C' . $i, !empty($contract_call->code_contract_disbursement) ? $contract_call->code_contract_disbursement : "");
			$this->sheet->setCellValue('D' . $i, !empty($contract_call->customer_name) ? $contract_call->customer_name : "");
			$this->sheet->setCellValue('E' . $i, !empty($contract_call->status_contract) ? contract_status($contract_call->status_contract) : "");
			$this->sheet->setCellValue('F' . $i, !empty($contract_call->status) ? status_contract_debt_to_field($contract_call->status) : "");
			$this->sheet->setCellValue('G' . $i, !empty($contract_call->debt_caller_name) ? $contract_call->debt_caller_name : "");
			$this->sheet->setCellValue('H' . $i, !empty($contract_call->store_name) ? $contract_call->store_name : "");
			$this->sheet->setCellValue('I' . $i, !empty($contract_call->bucket) ? ($contract_call->bucket) : "");
			$this->sheet->setCellValue('J' . $i, !empty($contract_call->so_ngay_cham_tra) ? $contract_call->so_ngay_cham_tra : "");
			$this->sheet->setCellValue('K' . $i, !empty($contract_call->root_debt) ? $contract_call->root_debt : "");
			$this->sheet->setCellValue('L' . $i, !empty($contract_call->debt_caller_email) ? $contract_call->debt_caller_email : "");
			$this->sheet->setCellValue('M' . $i, !empty($contract_call->evaluate) ? note_renewal($contract_call->evaluate) : "");
			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('ExportContractAssignCall' . time() . '.xlsx');
	}

	public function exportContractToField()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$getStore = !empty($_GET['store']) ? $_GET['store'] : "";
		$status_contract = !empty($_GET['status_contract']) ? $_GET['status_contract'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";

		$data = array();
		$data['start'] = !empty($fdate) ? $fdate : "";
		$data['end'] = !empty($tdate) ? $tdate : "";
		$data['store'] = !empty($getStore) ? $getStore : '';
		$data['status_contract'] = !empty($status_contract) ? $status_contract : '';
		$data['status'] = !empty($status) ? $status : '';
		$data['bucket'] = !empty($bucket) ? $bucket : '';
		$data['customer_name'] = !empty($customer_name) ? $customer_name : '';
		$data['code_contract_disbursement'] = !empty($code_contract_disbursement) ? $code_contract_disbursement : '';
		$data['code_contract'] = !empty($code_contract) ? $code_contract : '';

		$data['per_page'] = 10000;
		$contract_to_field = $this->api->apiPost($this->userInfo['token'], 'DebtCall/get_all_contract_to_field', $data);

		if (!empty($contract_to_field->data)) {
			$this->exportContractToFieldDetail($contract_to_field->data);

			var_dump($fdate . ' -- ' . $tdate);
		} else {
			var_dump("Không có dữ liệu để xuất excel");
		}
	}

	public function exportContractToFieldDetail($contractToField)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã hợp đồng');
		$this->sheet->setCellValue('C1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('D1', 'Tên khách hàng');
		$this->sheet->setCellValue('E1', 'Trạng thái hợp đồng');
		$this->sheet->setCellValue('F1', 'Trạng thái Call');
		$this->sheet->setCellValue('G1', 'Hạn chuyển Field');
		$this->sheet->setCellValue('H1', 'Nhân viên Call');
		$this->sheet->setCellValue('I1', 'Phòng giao dịch');
		$this->sheet->setCellValue('J1', 'Nhóm');
		$this->sheet->setCellValue('K1', 'Số ngày chậm trả');
		$this->sheet->setCellValue('L1', 'Gốc còn lại');
		$this->sheet->setCellValue('M1', 'Email call');

		$i = 2;
		foreach ($contractToField as $contract_to_field) {

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($contract_to_field->code_contract_disbursement) ? $contract_to_field->code_contract_disbursement : "");
			$this->sheet->setCellValue('C' . $i, !empty($contract_to_field->code_contract) ? $contract_to_field->code_contract : "");
			$this->sheet->setCellValue('D' . $i, !empty($contract_to_field->customer_name) ? $contract_to_field->customer_name : "");
			$this->sheet->setCellValue('E' . $i, !empty($contract_to_field->status_contract) ? contract_status($contract_to_field->status_contract) : "");
			$this->sheet->setCellValue('F' . $i, !empty($contract_to_field->status) ? status_contract_debt_to_field($contract_to_field->status) : "");
			$this->sheet->setCellValue('G' . $i, !empty($contract_to_field->end_time) ? date('d/m/Y H:i:s', $contract_to_field->end_time) : "");
			$this->sheet->setCellValue('H' . $i, !empty($contract_to_field->debt_caller_name) ? $contract_to_field->debt_caller_name : "");
			$this->sheet->setCellValue('I' . $i, !empty($contract_to_field->store_name) ? $contract_to_field->store_name : "");
			$this->sheet->setCellValue('J' . $i, !empty($contract_to_field->bucket) ? ($contract_to_field->bucket) : "");
			$this->sheet->setCellValue('K' . $i, !empty($contract_to_field->so_ngay_cham_tra) ? $contract_to_field->so_ngay_cham_tra : "");
			$this->sheet->setCellValue('L' . $i, !empty($contract_to_field->root_debt) ? $contract_to_field->root_debt : "");
			$this->sheet->setCellValue('M' . $i, !empty($contract_to_field->debt_caller_email) ? $contract_to_field->debt_caller_email : "");

			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('ExportContractToField' . time() . '.xlsx');
	}

	public function exportCtvIntro()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$ctv_name = !empty($_GET['ctv_name']) ? $_GET['ctv_name'] : "";
		$ctv_phone = !empty($_GET['ctv_phone']) ? $_GET['ctv_phone'] : "";
		$data = [];
		if (!empty($fdate)) {
			$data['fdate'] = $fdate;
		}
		if (!empty($tdate)) {
			$data['tdate'] = $tdate;
		}
		if (!empty($status)) {
			$data['status'] = $status;
		}
		if (!empty($ctv_name)) {
			$data['ctv_name'] = $ctv_name;
		}
		if (!empty($ctv_phone)) {
			$data['ctv_phone'] = $ctv_phone;
		}
		$data['per_page'] = 10000;
		$listCtv = $this->api->apiPost($this->userInfo['token'], "Ctv_Tienngay/get_all_ctv_intro", $data);
		if (!empty($listCtv->data)) {
			$this->ExportListCtvIntroDetail($listCtv->data);
			var_dump($fdate . ' -- ' . $tdate);
		} else {
			var_dump("Không có dữ liệu để xuất excel");
		}
	}

	public function ExportListCtvIntroDetail($listCtvData)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'SĐT người giới thiệu');
		$this->sheet->setCellValue('C1', 'SĐT người được giới thiệu');
		$this->sheet->setCellValue('D1', 'Thời gian giới thiệu');
		$this->sheet->setCellValue('E1', 'Loại Cộng tác viên');
		$this->sheet->setCellValue('F1', 'Tên Cộng tác viên');
		$this->sheet->setCellValue('G1', 'Trạng thái');
		$this->sheet->setCellValue('H1', 'Hoa hồng');
		$this->sheet->setCellValue('I1', 'Chức năng');
		$i = 2;
		foreach ($listCtvData as $ctv) {
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($ctv->phone_introduce) ? $ctv->phone_introduce : "");
			$this->sheet->setCellValue('C' . $i, !empty($ctv->ctv_phone) ? $ctv->ctv_phone : "");
			$this->sheet->setCellValue('D' . $i, !empty($ctv->created_at) ? date('d/m/Y H:i:s', intval($ctv->created_at)) : '');
			$this->sheet->setCellValue('E' . $i, "CTV được giới thiệu");
			$this->sheet->setCellValue('F' . $i, !empty($ctv->ctv_name) ? $ctv->ctv_name : "");
			$this->sheet->setCellValue('G' . $i, (!empty($ctv->status) && $ctv->status == 'active') ? "Đang hoạt động" : ((!empty($ctv->status) && $ctv->status == 'deactivate') ? "Ngừng hoạt động" : ""));
			$this->sheet->setCellValue('H' . $i, "");
			$this->sheet->setCellValue('I' . $i, "");

			$i++;
		}
		$this->callLibExcel('exportCtvIntro' . time() . '.xlsx');
	}

	public function exportCtvOrder()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$ctv_name = !empty($_GET['ctv_name']) ? $_GET['ctv_name'] : "";
		$ctv_phone = !empty($_GET['ctv_phone']) ? $_GET['ctv_phone'] : "";
		$lead_name = !empty($_GET['lead_name']) ? $_GET['lead_name'] : '';
		$lead_phone = !empty($_GET['lead_phone']) ? $_GET['lead_phone'] : '';
		$data = [];
		if (!empty($fdate)) {
			$data['fdate'] = $fdate;
		}
		if (!empty($tdate)) {
			$data['tdate'] = $tdate;
		}
		if (!empty($status)) {
			$data['status'] = $status;
		}
		if (!empty($ctv_name)) {
			$data['ctv_name'] = $ctv_name;
		}
		if (!empty($ctv_phone)) {
			$data['ctv_phone'] = $ctv_phone;
		}
		if (!empty($lead_name)) {
			$data['lead_name'] = $lead_name;
		}
		if (!empty($lead_phone)) {
			$data['lead_phone'] = $lead_phone;
		}
		$data['per_page'] = 10000;
		$listOrder = $this->api->apiPost($this->userInfo['token'], "Ctv_Tienngay/get_all_order", $data);
		if (!empty($listOrder->data)) {
			$this->ExportListCtvOrderDetail($listOrder->data);
			var_dump($fdate . ' -- ' . $tdate);
		} else {
			var_dump("Không có dữ liệu để xuất excel");
		}
	}

	public function ExportListCtvOrderDetail($listCtvOrderData)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Thời gian tạo');
		$this->sheet->setCellValue('C1', 'Tên CTV');
		$this->sheet->setCellValue('D1', 'SĐT CTV');
		$this->sheet->setCellValue('E1', 'Tên Lead');
		$this->sheet->setCellValue('F1', 'SĐT Lead');
		$this->sheet->setCellValue('G1', 'Số tiền giao dịch');
		$this->sheet->setCellValue('H1', 'Loại Cộng tác viên');
		$this->sheet->setCellValue('I1', 'Trạng thái sản phẩm');
		$this->sheet->setCellValue('J1', 'Hoa hồng');
		$i = 2;
		foreach ($listCtvOrderData as $order) {
			$ctv_type = '';
			if (!empty($order->ctv_type)) {
				if ($order->ctv_type == 1) {
					$ctv_type = "CTV cá nhân";
				} else {
					$ctv_type = "CTV đội nhóm";
				}
			}
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($order->created_at) ? date('d/m/Y H:i:s', intval($order->created_at)) : '');
			$this->sheet->setCellValue('C' . $i, !empty($order->ctv_name) ? $order->ctv_name : "");
			$this->sheet->setCellValue('D' . $i, !empty($order->ctv_phone) ? $order->ctv_phone : "");
			$this->sheet->setCellValue('E' . $i, !empty($order->fullname) ? $order->fullname : "");
			$this->sheet->setCellValue('F' . $i, !empty($order->phone_number) ? $order->phone_number : "");
			$this->sheet->setCellValue('G' . $i, !empty($order->price) ? $order->price : "");
			$this->sheet->setCellValue('H' . $i, !empty($ctv_type) ? $ctv_type : "");
			$this->sheet->setCellValue('I' . $i, !empty($order->status_web) ? $order->status_web : "");
			$this->sheet->setCellValue('J' . $i, !empty($order->tien_hoa_hong) ? $order->tien_hoa_hong : "");

			$i++;
		}
		$this->callLibExcel('exportCtvOrder' . time() . '.xlsx');
	}

	public function exportListMkt()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$status_sale = !empty($_GET['status_sale']) ? $_GET['status_sale'] : "";
		$utm_source = !empty($_GET['utm_source']) ? $_GET['utm_source'] : "";

		if ($fdate == "" || $tdate == "") {
			$this->session->set_flashdata("Vui lòng chọn ngày tháng để xuất Excel!");
			echo "Vui lòng chọn ngày tháng để xuất Excel!";
			return;
		}

		$data = array();
		if (!empty($fdate)) $data['fdate'] = $fdate;
		if (!empty($tdate)) $data['tdate'] = $tdate;
		if (!empty($status_sale)) $data['status_sale'] = $status_sale;
		if (!empty($utm_source)) $data['utm_source'] = $utm_source;

		$dataLead = $this->api->apiPost($this->userInfo['token'], "report_telesale/index_accesstrade_excel", $data);

		if (!empty($dataLead->data)) {
			$this->fcExportListMKT($dataLead->data);
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	public function fcExportListMKT($exportLeadMKT)
	{

		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Transaction_id');
		$this->sheet->setCellValue('C1', 'Ngày tạo');
		$this->sheet->setCellValue('D1', 'Nguồn lead');
		$this->sheet->setCellValue('E1', 'Tên khách hàng');
		$this->sheet->setCellValue('F1', 'Số điện thoại');
		$this->sheet->setCellValue('F1', 'PGD');
		$this->sheet->setCellValue('G1', 'Trạng thái lead');
		$this->sheet->setCellValue('H1', 'Lý do huỷ');
		$this->sheet->setCellValue('I1', 'Trạng thái hợp đồng');
		$this->sheet->setCellValue('J1', 'Số tiền vay');
		$i = 2;
		foreach ($exportLeadMKT as $value) {

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($value->_id) ? (string)$value->_id->{'$oid'} : '');
			$this->sheet->setCellValue('C' . $i, !empty($value->created_at) ? date("d/m/Y H:i:s", $value->created_at) : "");
			$this->sheet->setCellValue('D' . $i, !empty($value->utm_source) ? $value->utm_source : "");
			$this->sheet->setCellValue('E' . $i, !empty($value->fullname) ? $value->fullname : "");
			$this->sheet->setCellValue('F' . $i, !empty($value->phone_number) ? hide_phone($value->phone_number) : "");
			$this->sheet->setCellValue('F' . $i, !empty($value->store_name) ? ($value->store_name) : "");
			$this->sheet->setCellValue('G' . $i, !empty($value->status_sale) ? lead_status($value->status_sale) : "");
			$this->sheet->setCellValue('H' . $i, !empty($value->reason_cancel) ? reason($value->reason_cancel) : "");
			$this->sheet->setCellValue('I' . $i, !empty($value->status_hd) ? contract_status($value->status_hd) : "");
			$this->sheet->setCellValue('J' . $i, !empty($value->amount_money) ? number_format($value->amount_money) : "");

			$i++;
		}
		$this->callLibExcel('exportLeadMKT' . time() . '.xlsx');

	}


	public function exportContract_bucket()
	{
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$data = array();
		if (!empty($store)) $data['store'] = $store;
		if (!empty($fdate)) $data['fdate'] = $fdate;
		if (!empty($tdate)) $data['tdate'] = $tdate;

		$dataLead = $this->api->apiPost($this->userInfo['token'], "contract/exportContract_bucket_excel", $data);

		if (!empty($dataLead->data)) {
			$this->exportContractBucket($dataLead->data);
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	public function exportContractBucket($export)
	{

		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('C1', 'Mã hợp đồng');
		$this->sheet->setCellValue('D1', 'PGD');
		$this->sheet->setCellValue('E1', 'Ngày giải ngân');
		$this->sheet->setCellValue('F1', 'Gốc còn lại');
		$this->sheet->setCellValue('G1', 'Số ngày chậm trả');
		$this->sheet->setCellValue('H1', 'Bucket');
		$this->sheet->setCellValue('I1', 'Người tạo');
		$this->sheet->setCellValue('J1', 'Người tiếp quản hợp đồng');
		$this->sheet->setCellValue('K1', 'Ngày tạo');
		$i = 2;
		foreach ($export as $value) {

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($value->code_contract) ? $value->code_contract : '');
			$this->sheet->setCellValue('C' . $i, !empty($value->code_contract_disbursement) ? $value->code_contract_disbursement : "");
			$this->sheet->setCellValue('D' . $i, !empty($value->store->name) ? $value->store->name : "");
			$this->sheet->setCellValue('E' . $i, !empty($value->disbursement_date) ? date("d/m/Y H:i:s", $value->disbursement_date) : "");
			$this->sheet->setCellValue('F' . $i, !empty($value->debt->tong_tien_goc_con) ? $value->debt->tong_tien_goc_con : "");
			$this->sheet->setCellValue('G' . $i, !empty($value->debt->so_ngay_cham_tra) ? number_format($value->debt->so_ngay_cham_tra) : "");
			$this->sheet->setCellValue('H' . $i, !empty($value->debt->so_ngay_cham_tra) ? get_bucket($value->debt->so_ngay_cham_tra) : "");
			$this->sheet->setCellValue('I' . $i, !empty($value->created_by) ? $value->created_by : "");
			$this->sheet->setCellValue('J' . $i, !empty($value->follow_contract) ? $value->follow_contract : "");
			$this->sheet->setCellValue('K' . $i, !empty($value->created_at) ? date("d/m/Y H:i:s", $value->created_at) : "");

			$i++;
		}

		$this->callLibExcel('export' . time() . '.xlsx');

	}

	public function exportDashboard()
	{

		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$data = array();
		if (!empty($fdate)) $data['start'] = $fdate;
		if (!empty($tdate)) $data['end'] = $tdate;

		$dataLead = $this->api->apiPost($this->userInfo['token'], "report_kpi/exportDashboard", $data);

		if (!empty($dataLead->data)) {
			$this->exportDashboard_data($dataLead->data);
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	public function exportDashboard_data($export)
	{


		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Khu vực');
		$this->sheet->setCellValue('C1', 'Tiền giải ngân mới kỳ này');
		$this->sheet->setCellValue('D1', 'Gốc còn lại tăng net trong kỳ');
		$this->sheet->setCellValue('E1', 'Doanh số bảo hiểm kỳ này');
		$this->sheet->setCellValue('F1', 'Tổng tiền giải ngân');
		$this->sheet->setCellValue('G1', 'Gốc còn lại quản lý');
		$this->sheet->setCellValue('H1', 'Gốc còn lại trong hạn T+10 hiện tại');
		$this->sheet->setCellValue('I1', 'Gốc còn lại trong hạn T+10 kỳ trước');


		$i = 2;
		foreach ($export as $key => $value) {

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($key) ? $key : '');
			$this->sheet->setCellValue('C' . $i, !empty($value->total_so_tien_vay) ? $value->total_so_tien_vay : "")
				->getStyle('C' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('D' . $i, !empty($value->total_du_no_trong_han_t10) ? $value->total_du_no_trong_han_t10 : "")
				->getStyle('D' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('E' . $i, !empty($value->total_doanh_so_bao_hiem) ? $value->total_doanh_so_bao_hiem : "")
				->getStyle('E' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('F' . $i, !empty($value->total_so_tien_vay_old) ? $value->total_so_tien_vay_old : "")
				->getStyle('F' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('G' . $i, !empty($value->total_du_no_dang_cho_vay_old) ? $value->total_du_no_dang_cho_vay_old : "")
				->getStyle('G' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('H' . $i, !empty($value->total_du_no_trong_han_t10_old) ? $value->total_du_no_trong_han_t10_old : "")
				->getStyle('H' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('I' . $i, !empty($value->total_du_no_trong_han_t10_thang_truoc) ? $value->total_du_no_trong_han_t10_thang_truoc : "")
				->getStyle('I' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$i++;
		}

		$this->callLibExcel('export' . time() . '.xlsx');

	}

	public function exportAllBaohiem()
	{

		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$data = array();
		if (!empty($fdate)) $data['fdate'] = $fdate;
		if (!empty($tdate)) $data['tdate'] = $tdate;

		$dataLead = $this->api->apiPost($this->userInfo['token'], "report_kpi/exportAllBaohiem", $data);

		if (!empty($dataLead->data)) {
			$this->exportAllBaohiem_data($dataLead->data);
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}


	}

	public function exportAllBaohiem_data($export)
	{

		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã hợp đồng');
		$this->sheet->setCellValue('C1', 'Mã hợp đồng bảo hiểm');
		$this->sheet->setCellValue('D1', 'Tên người được bảo hiểm');
		$this->sheet->setCellValue('E1', 'Số điện thoại');
		$this->sheet->setCellValue('F1', 'Email');
		$this->sheet->setCellValue('G1', 'Ngày tháng năm sinh');
		$this->sheet->setCellValue('H1', 'Gói bảo hiểm');
		$this->sheet->setCellValue('I1', 'Phí bảo hiểm');
		$this->sheet->setCellValue('J1', 'Phòng giao dịch');
		$this->sheet->setCellValue('K1', 'Ngày hiệu lực');
		$this->sheet->setCellValue('L1', 'Ngày hết hạn');
		$this->sheet->setCellValue('M1', 'Ngày tạo');
		$this->sheet->setCellValue('N1', 'Người tạo');


		$i = 2;
		foreach ($export as $key => $value) {

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($value->ma_hop_dong) ? $value->ma_hop_dong : '');
			$this->sheet->setCellValue('C' . $i, !empty($value->ma_hop_dong_bao_hiem) ? $value->ma_hop_dong_bao_hiem : '');
			$this->sheet->setCellValue('D' . $i, !empty($value->ten_nguoi_duoc_bao_hiem) ? $value->ten_nguoi_duoc_bao_hiem : "");
			$this->sheet->setCellValue('E' . $i, !empty($value->so_dien_thoai) ? $value->so_dien_thoai : "");
			$this->sheet->setCellValue('F' . $i, !empty($value->email) ? $value->email : "");
			$this->sheet->setCellValue('G' . $i, !empty($value->ngay_thang_nam_sinh) ? $value->ngay_thang_nam_sinh : "");
			$this->sheet->setCellValue('H' . $i, !empty($value->goi_bao_hiem) ? $value->goi_bao_hiem : "");
			$this->sheet->setCellValue('I' . $i, !empty($value->phi_bao_hiem) ? $value->phi_bao_hiem : "");
			$this->sheet->setCellValue('J' . $i, !empty($value->phong_giao_dich) ? $value->phong_giao_dich : "");
			$this->sheet->setCellValue('K' . $i, !empty($value->ngay_hieu_luc) ? $value->ngay_hieu_luc : "");
			$this->sheet->setCellValue('L' . $i, !empty($value->ngay_ket_thuc) ? $value->ngay_ket_thuc : "");
			$this->sheet->setCellValue('M' . $i, !empty($value->ngay_tao) ? $value->ngay_tao : "");
			$this->sheet->setCellValue('N' . $i, !empty($value->nguoi_tao) ? $value->nguoi_tao : "");

			$i++;
		}

		$this->callLibExcel('export' . time() . '.xlsx');

	}

	public function exportDashboard_asm()
	{

		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$data = array();
		if (!empty($fdate)) $data['start'] = $fdate;
		if (!empty($tdate)) $data['end'] = $tdate;

		$dataLead = $this->api->apiPost($this->userInfo['token'], "report_kpi/exportDashboard_asm", $data);

		if (!empty($dataLead->data)) {
			$this->exportDashboard_asm_data($dataLead->data);
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	public function exportDashboard_asm_data($export)
	{


		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'PGD');
		$this->sheet->setCellValue('C1', 'Tiền giải ngân mới kỳ này');
		$this->sheet->setCellValue('D1', 'Gốc còn lại tăng net trong kỳ');
		$this->sheet->setCellValue('E1', 'Doanh số bảo hiểm kỳ này');
		$this->sheet->setCellValue('F1', 'Tổng tiền giải ngân');
		$this->sheet->setCellValue('G1', 'Gốc còn lại quản lý');
		$this->sheet->setCellValue('H1', 'Gốc còn lại trong hạn T+10 hiện tại');
		$this->sheet->setCellValue('I1', 'Gốc còn lại trong hạn T+10 kỳ trước');


		$i = 2;
		foreach ($export as $key => $value) {

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($key) ? $key : '');
			$this->sheet->setCellValue('C' . $i, !empty($value->total_so_tien_vay) ? $value->total_so_tien_vay : "")
				->getStyle('C' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('D' . $i, !empty($value->total_du_no_trong_han_t10) ? $value->total_du_no_trong_han_t10 : "")
				->getStyle('D' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('E' . $i, !empty($value->total_doanh_so_bao_hiem) ? $value->total_doanh_so_bao_hiem : "")
				->getStyle('E' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('F' . $i, !empty($value->total_so_tien_vay_old) ? $value->total_so_tien_vay_old : "")
				->getStyle('F' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('G' . $i, !empty($value->total_du_no_dang_cho_vay_old) ? $value->total_du_no_dang_cho_vay_old : "")
				->getStyle('G' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('H' . $i, !empty($value->total_du_no_trong_han_t10_old) ? $value->total_du_no_trong_han_t10_old : "")
				->getStyle('H' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('I' . $i, !empty($value->total_du_no_trong_han_t10_thang_truoc) ? $value->total_du_no_trong_han_t10_thang_truoc : "")
				->getStyle('I' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$i++;
		}

		$this->callLibExcel('export' . time() . '.xlsx');

	}

	public function exportDashboard_lead()
	{

		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$data = array();
		if (!empty($fdate)) $data['start'] = $fdate;
		if (!empty($tdate)) $data['end'] = $tdate;

		$dataLead = $this->api->apiPost($this->userInfo['token'], "report_kpi/exportDashboard_lead", $data);

		if (!empty($dataLead->data)) {
			$this->exportDashboard_lead_data($dataLead->data);
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	public function exportDashboard_lead_data($export)
	{


		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Tên');
		$this->sheet->setCellValue('C1', 'Tiền giải ngân mới kỳ này');
		$this->sheet->setCellValue('D1', 'Gốc còn lại tăng net trong kỳ');
		$this->sheet->setCellValue('E1', 'Doanh số bảo hiểm kỳ này');
		$this->sheet->setCellValue('F1', 'Tổng tiền giải ngân');
		$this->sheet->setCellValue('G1', 'Gốc còn lại quản lý');
		$this->sheet->setCellValue('H1', 'Gốc còn lại trong hạn T+10 hiện tại');
		$this->sheet->setCellValue('I1', 'Gốc còn lại trong hạn T+10 kỳ trước');


		$i = 2;
		foreach ($export as $key => $value) {

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($value->created_by) ? $value->created_by : '');
			$this->sheet->setCellValue('C' . $i, !empty($value->total_so_tien_vay) ? $value->total_so_tien_vay : "")
				->getStyle('C' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('D' . $i, !empty($value->total_du_no_trong_han_t10) ? $value->total_du_no_trong_han_t10 : "")
				->getStyle('D' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('E' . $i, !empty($value->total_doanh_so_bao_hiem) ? $value->total_doanh_so_bao_hiem : "")
				->getStyle('E' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('F' . $i, !empty($value->total_so_tien_vay_old) ? $value->total_so_tien_vay_old : "")
				->getStyle('F' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('G' . $i, !empty($value->total_du_no_dang_cho_vay_old) ? $value->total_du_no_dang_cho_vay_old : "")
				->getStyle('G' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('H' . $i, !empty($value->total_du_no_trong_han_t10_old) ? $value->total_du_no_trong_han_t10_old : "")
				->getStyle('H' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('I' . $i, !empty($value->total_du_no_trong_han_t10_thang_truoc) ? $value->total_du_no_trong_han_t10_thang_truoc : "")
				->getStyle('I' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$i++;
		}

		$this->callLibExcel('export' . time() . '.xlsx');

	}

	public function muontrahoso()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$code_contract_disbursement_search = !empty($_GET['code_contract_disbursement_search']) ? $_GET['code_contract_disbursement_search'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";


		$data = array();
		if (!empty($fdate)) $data['fdate'] = $fdate;
		if (!empty($tdate)) $data['tdate'] = $tdate;
		if (!empty($status)) $data['status'] = $status;
		if (!empty($code_contract_disbursement_search)) $data['code_contract_disbursement_search'] = $code_contract_disbursement_search;
		if (!empty($store)) $data['store'] = $store;

		$dataLead = $this->api->apiPost($this->userInfo['token'], "file_manager/muontrahoso_excel", $data);
		if (!empty($dataLead->data)) {
			$this->exportAllhoso_data($dataLead->data);

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	public function exportAllhoso_data($export)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Tên khách hàng');
		$this->sheet->setCellValue('C1', 'Mã hợp đồng');
		$this->sheet->setCellValue('D1', 'Phòng giao dịch');
		$this->sheet->setCellValue('E1', 'Thời gian mượn');
		$this->sheet->setCellValue('F1', 'Thời gian trả');
		$this->sheet->setCellValue('G1', 'Hồ sơ mượn');
		$this->sheet->setCellValue('H1', 'Trạng thái');
		$this->sheet->setCellValue('I1', 'Ngày tạo');
		$this->sheet->setCellValue('J1', 'Người tạo');

		$i = 2;
		foreach ($export as $key => $value) {
			$store_name = "";
			$customer_name = "";
			$data_id = [
				"code_contract_disbursement_text" => $value->code_contract_disbursement_text
			];
			$check_id = $this->api->apiPost($this->userInfo['token'], "contract/store", $data_id);
			$store_name = $check_id->data->store->name;
			$customer_name = $check_id->data->customer_infor->customer_name;
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($customer_name) ? $customer_name : '');
			$this->sheet->setCellValue('C' . $i, !empty($value->code_contract_disbursement_text) ? $value->code_contract_disbursement_text : "");
			$this->sheet->setCellValue('D' . $i, !empty($store_name) ? $store_name : '');
			$this->sheet->setCellValue('E' . $i, !empty($value->borrowed_start) ? date('d/m/Y', $value->borrowed_start) : "");
			$this->sheet->setCellValue('F' . $i, !empty($value->borrowed_end) ? date('d/m/Y', $value->borrowed_end) : "");
			$this->sheet->setCellValue('G' . $i, !empty($value->file) ? implode(", ", $value->file) : "");
			$this->sheet->setCellValue('H' . $i, !empty($value->status) ? file_manager_borrowed_status($value->status) : "");
			$this->sheet->setCellValue('I' . $i, !empty($value->created_at) ? date('d/m/Y', $value->created_at) : "");
			$this->sheet->setCellValue('J' . $i, !empty($value->created_by->email) ? $value->created_by->email : "");

			$i++;
		}

		$this->callLibExcel('export' . time() . '.xlsx');

	}

	public function exportTransactionStore()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "all";
		$type_transaction = !empty($_GET['type_transaction']) ? $_GET['type_transaction'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$payment_method = !empty($_GET['payment_method']) ? $_GET['payment_method'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$allocation = !empty($_GET['allocation']) ? $_GET['allocation'] : "";
		$sdt = !empty($_GET['sdt']) ? $_GET['sdt'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$data = array();
		$data['fdate'] = !empty($start) ? $start : '';
		$data['tdate'] = !empty($end) ? $end : '';
		$data['tab'] = $tab;
		$data['code_contract'] = $code_contract;
		$data['code_contract_disbursement'] = $code_contract_disbursement;
		$data['payment_method'] = $payment_method;
		$data['store'] = $store;
		$data['sdt'] = $sdt;
		$data['per_page'] = 10000;
		$data['status'] = $status;
		$data['type_transaction'] = $type_transaction;
		$data['allocation'] = $allocation;

		$contractData = $this->api->apiPost($this->userInfo['token'], "transaction/get_all", $data);
		//Calculate to export excel
		if (!empty($contractData->data)) {
			$this->exportTransactionStoreDetail($contractData->data);
			var_dump($start . ' -- ' . $end);
		} else {
			// $this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
			var_dump("Không có dữ liệu để xuất excel");
		}
	}

	public function exportTransactionStoreDetail($temporary_planData)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã HĐ');
		$this->sheet->setCellValue('C1', 'Mã Phiếu ghi');
		$this->sheet->setCellValue('D1', 'Mã phiếu thu');
		$this->sheet->setCellValue('E1', 'Tên khách hàng');
		$this->sheet->setCellValue('F1', 'Số điện thoại');
		$this->sheet->setCellValue('G1', 'Tổng tiền');
		$this->sheet->setCellValue('H1', 'Phương thức thanh toán');
		$this->sheet->setCellValue('I1', 'Loại thanh toán');
		$this->sheet->setCellValue('J1', 'Trạng thái');
		$this->sheet->setCellValue('K1', 'Phòng giao dịch');
		$this->sheet->setCellValue('L1', 'Ghi chú');
		$this->sheet->setCellValue('M1', 'Ngày tạo phiếu thu');
		$this->sheet->setCellValue('N1', 'Ngày khách thanh toán');
		$this->sheet->setCellValue('O1', 'Nhân viên tạo phiếu thu');
		$this->sheet->setCellValue('P1', 'Email Field');
		$this->sheet->setCellValue('Q1', 'Nhân viên Field');
		$this->sheet->setCellValue('R1', 'Email Call');
		$this->sheet->setCellValue('S1', 'Nhân viên Call');

		$i = 2;
		$this->numberRowLastColumn = 2;
		foreach ($temporary_planData as $tran) {
			$method = '';
			if (intval($tran->payment_method) == 0) {
				$method = $tran->payment_method;
			} else {
				if (intval($tran->payment_method) == 1) {
					$method = $this->lang->line('Cash');
				} else if (intval($tran->payment_method) == 2) {
					$method = 'Chuyển khoản';
				}
			}
			$content_billing = '';
			$type_transaction = '';
			if (!empty($tran->type) && $tran->type == 3) {
				$type_transaction = "Tất toán";
			} elseif (!empty($tran->type) && $tran->type == 4) {
				if ($tran->type_payment == 1) {
					$type_transaction = "Thanh toán kỳ";
				} elseif ($tran->type_payment == 2) {
					$type_transaction = "Thanh toán - gia hạn";
				} elseif ($tran->type_payment == 3) {
					$type_transaction = "Thanh toán - cơ cấu";
				} elseif ($tran->type_payment == 4) {
					$type_transaction = "Thanh toán - thanh lý tài sản";
				}
			}
			$notes = !empty($tran->note) ? $tran->note : "";
			if (is_array($notes)) {
				foreach ($notes as $note) {
					$content_billing .= billing_content($note);
				}
				$notes = $content_billing;
			} else {
				$notes = $tran->note;
			}
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($tran->code_contract_disbursement) ? $tran->code_contract_disbursement : "");
			$this->sheet->setCellValue('C' . $i, !empty($tran->code_contract) ? $tran->code_contract : "");
			$this->sheet->setCellValue('D' . $i, !empty($tran->code) ? $tran->code : '');
			$this->sheet->setCellValue('E' . $i, !empty($tran->full_name) ? $tran->full_name : $tran->customer_bill_name);
			$this->sheet->setCellValue('F' . $i, !empty($tran->customer_bill_phone) ? hide_phone($tran->customer_bill_phone) : '');
			$this->sheet->setCellValue('G' . $i, (!empty($tran->total) && $tran->total > 0) ? $tran->total : 0);
			$this->sheet->setCellValue('H' . $i, $method);
			$this->sheet->setCellValue('I' . $i, $type_transaction);
			$this->sheet->setCellValue('J' . $i, !empty($tran->status) ? status_transaction($tran->status) : "");
			$this->sheet->setCellValue('K' . $i, !empty($tran->store) ? $tran->store->name : "");
			$this->sheet->setCellValue('L' . $i, $notes);
			$this->sheet->setCellValue('M' . $i, !empty($tran->created_at) ? date('d/m/Y H:i:s', intval($tran->created_at)) : '');
			$this->sheet->setCellValue('N' . $i, !empty($tran->date_pay) ? date('d/m/Y H:i:s', intval($tran->date_pay)) : '');
			$this->sheet->setCellValue('O' . $i, !empty($tran->created_by) ? $tran->created_by : '');
			$this->sheet->setCellValue('P' . $i, !empty($tran->field_email) ? $tran->field_email : '');
			$this->sheet->setCellValue('Q' . $i, !empty($tran->field_fullname) ? $tran->field_fullname : '');
			$this->sheet->setCellValue('R' . $i, !empty($tran->call_email) ? $tran->call_email : '');
			$this->sheet->setCellValue('S' . $i, !empty($tran->call_fullname) ? $tran->call_fullname : '');
			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('PHIEU_THU_HD_PGD_' . time() . '.xlsx');
	}

	public function exportKpiCvkd()
	{

		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$data = array();
		if (!empty($fdate)) $data['start'] = $fdate;
		if (!empty($tdate)) $data['end'] = $tdate;

		$dataLead = $this->api->apiPost($this->userInfo['token'], "report_kpi/exportKpiCvkd", $data);
		if (!empty($dataLead->data)) {
			$this->exportKpiCvkd_data($dataLead->data);

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}

	}

	public function exportKpiCvkd_data($export)
	{

		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Tên chuyên viên kinh doanh');
		$this->sheet->setCellValue('C1', 'Gốc còn lại trong hạn T+10 kỳ trước');
		$this->sheet->setCellValue('D1', 'Gốc còn lại trong hạn T+10 hiện tại');
		$this->sheet->setCellValue('E1', 'Gốc còn lại tăng net trong tháng');
		$this->sheet->setCellValue('F1', 'Chỉ tiêu gốc còn lại tăng net trong tháng');
		$this->sheet->setCellValue('G1', 'Doanh số bảo hiểm trong tháng');
		$this->sheet->setCellValue('H1', 'Chỉ tiêu bảo hiểm trong tháng');
		$this->sheet->setCellValue('I1', 'Số tiền giải ngân trong tháng');
		$this->sheet->setCellValue('J1', 'Chỉ tiêu giải ngân trong tháng');
		$this->sheet->setCellValue('K1', 'Số tiền khách đầu tư trong tháng');
		$this->sheet->setCellValue('L1', 'Chỉ tiêu đầu tư trong tháng');
		$this->sheet->setCellValue('M1', 'Tỉ lệ Kpi (%)');
		$this->sheet->setCellValue('N1', 'Tổng tiền hoa hồng');


		$i = 2;
		foreach ($export as $key => $value) {

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($value->created_by) ? $value->created_by : '');
			$this->sheet->setCellValue('C' . $i, !empty($value->total_du_no_trong_han_t10_thang_truoc) ? $value->total_du_no_trong_han_t10_thang_truoc : '')
				->getStyle('C' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('D' . $i, !empty($value->total_du_no_trong_han_t10_old) ? $value->total_du_no_trong_han_t10_old : '')
				->getStyle('D' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('E' . $i, !empty($value->total_du_no_trong_han_t10) ? $value->total_du_no_trong_han_t10 : '')
				->getStyle('E' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('F' . $i, !empty($value->chi_tieu_du_no_tang_net) ? $value->chi_tieu_du_no_tang_net : '')
				->getStyle('F' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('G' . $i, !empty($value->total_doanh_so_bao_hiem) ? $value->total_doanh_so_bao_hiem : '')
				->getStyle('G' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('H' . $i, !empty($value->chi_tieu_bao_hiem) ? $value->chi_tieu_bao_hiem : '')
				->getStyle('H' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('I' . $i, !empty($value->total_so_tien_vay) ? $value->total_so_tien_vay : '')
				->getStyle('I' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('J' . $i, !empty($value->chi_tieu_giai_ngan) ? $value->chi_tieu_giai_ngan : '')
				->getStyle('J' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('K' . $i, !empty($value->tong_tien_dau_tu) ? $value->tong_tien_dau_tu : '')
				->getStyle('K' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('L' . $i, !empty($value->chi_tieu_nha_dau_tu) ? $value->chi_tieu_nha_dau_tu : '')
				->getStyle('L' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('M' . $i, !empty($value->kpi) ? $value->kpi : '')
				->getStyle('M' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('N' . $i, !empty($value->total_tien_hoa_hong) ? $value->total_tien_hoa_hong : '')
				->getStyle('N' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$i++;
		}

		$this->callLibExcel('Kpi_Cvkd' . time() . '.xlsx');


	}

	public function exportKpiPGD()
	{

		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$data = array();
		if (!empty($fdate)) $data['start'] = $fdate;
		if (!empty($tdate)) $data['end'] = $tdate;

		$dataLead = $this->api->apiPost($this->userInfo['token'], "report_kpi/exportKpiPGD", $data);
		if (!empty($dataLead->data)) {
			$this->exportKpiPGD_data($dataLead->data);

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}


	}

	public function exportKpiPGD_data($export)
	{

		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Trưởng PGD');
		$this->sheet->setCellValue('C1', 'Gốc còn lại trong hạn T+10 kỳ trước');
		$this->sheet->setCellValue('D1', 'Gốc còn lại trong hạn T+10 hiện tại');
		$this->sheet->setCellValue('E1', 'Gốc còn lại tăng net trong tháng');
		$this->sheet->setCellValue('F1', 'Chỉ tiêu gốc còn lại tăng net trong tháng');
		$this->sheet->setCellValue('G1', 'Doanh số bảo hiểm trong tháng');
		$this->sheet->setCellValue('H1', 'Chỉ tiêu bảo hiểm trong tháng');
		$this->sheet->setCellValue('I1', 'Số tiền giải ngân trong tháng');
		$this->sheet->setCellValue('J1', 'Chỉ tiêu giải ngân trong tháng');
		$this->sheet->setCellValue('K1', 'Số tiền đầu tư trong tháng');
		$this->sheet->setCellValue('L1', 'Chỉ tiêu đầu tư trong tháng');
		$this->sheet->setCellValue('M1', 'Tỉ lệ Kpi (%)');
		$this->sheet->setCellValue('N1', 'Tổng tiền hoa hồng');


		$i = 2;
		foreach ($export as $key => $value) {

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($value->store_name) ? $value->store_name : '');
			$this->sheet->setCellValue('C' . $i, !empty($value->total_du_no_trong_han_t10_thang_truoc) ? $value->total_du_no_trong_han_t10_thang_truoc : '')
				->getStyle('C' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('D' . $i, !empty($value->total_du_no_trong_han_t10_old) ? $value->total_du_no_trong_han_t10_old : '')
				->getStyle('D' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$this->sheet->setCellValue('E' . $i, !empty($value->total_du_no_trong_han_t10) ? $value->total_du_no_trong_han_t10 : '')
				->getStyle('E' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('F' . $i, !empty($value->chi_tieu_du_no_tang_net) ? $value->chi_tieu_du_no_tang_net : '')
				->getStyle('F' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('G' . $i, !empty($value->total_doanh_so_bao_hiem) ? $value->total_doanh_so_bao_hiem : '')
				->getStyle('G' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('H' . $i, !empty($value->chi_tieu_bao_hiem) ? $value->chi_tieu_bao_hiem : '')
				->getStyle('H' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('I' . $i, !empty($value->total_so_tien_vay) ? $value->total_so_tien_vay : '')
				->getStyle('I' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('J' . $i, !empty($value->chi_tieu_giai_ngan) ? $value->chi_tieu_giai_ngan : '')
				->getStyle('J' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('K' . $i, !empty($value->total_nha_dau_tu) ? $value->total_nha_dau_tu : '')
				->getStyle('K' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('L' . $i, !empty($value->chi_tieu_nha_dau_tu) ? $value->chi_tieu_nha_dau_tu : '')
				->getStyle('L' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('M' . $i, !empty($value->kpi) ? $value->kpi : '')
				->getStyle('M' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('N' . $i, !empty($value->total_tien_hoa_hong) ? $value->total_tien_hoa_hong : '')
				->getStyle('N' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$i++;
		}

		$this->callLibExcel('Kpi_Pgd' . time() . '.xlsx');

	}

	public function exportKpiASM()
	{

		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$data = array();
		if (!empty($fdate)) $data['start'] = $fdate;
		if (!empty($tdate)) $data['end'] = $tdate;

		$dataLead = $this->api->apiPost($this->userInfo['token'], "report_kpi/exportKpiASM", $data);
		if (!empty($dataLead->data)) {
			$this->exportKpiASM_data($dataLead->data);

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}


	}

	public function exportKpiASM_data($export)
	{

		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Khu vực');
		$this->sheet->setCellValue('C1', 'Gốc còn lại trong hạn T+10 kỳ trước');
		$this->sheet->setCellValue('D1', 'Gốc còn lại trong hạn T+10 hiện tại');
		$this->sheet->setCellValue('E1', 'Gốc còn lại tăng net trong tháng');
		$this->sheet->setCellValue('F1', 'Chỉ tiêu gốc còn lại tăng net trong tháng');
		$this->sheet->setCellValue('G1', 'Doanh số bảo hiểm trong tháng');
		$this->sheet->setCellValue('H1', 'Chỉ tiêu bảo hiểm trong tháng');
		$this->sheet->setCellValue('I1', 'Số tiền giải ngân trong tháng');
		$this->sheet->setCellValue('J1', 'Chỉ tiêu giải ngân trong tháng');
		$this->sheet->setCellValue('K1', 'Số tiền đầu tư trong tháng');
		$this->sheet->setCellValue('L1', 'Chỉ tiêu nhà đầu tư trong tháng');
		$this->sheet->setCellValue('M1', 'Tỉ lệ Kpi (%)');
		$this->sheet->setCellValue('N1', 'Tổng tiền hoa hồng');


		$i = 2;
		foreach ($export as $key => $value) {

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($value->store_name) ? $value->store_name : '');
			$this->sheet->setCellValue('C' . $i, !empty($value->total_du_no_trong_han_t10_thang_truoc) ? $value->total_du_no_trong_han_t10_thang_truoc : '')
				->getStyle('C' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('D' . $i, !empty($value->total_du_no_trong_han_t10_old) ? $value->total_du_no_trong_han_t10_old : '')
				->getStyle('D' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('E' . $i, !empty($value->total_du_no_trong_han_t10) ? $value->total_du_no_trong_han_t10 : '')
				->getStyle('E' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('F' . $i, !empty($value->chi_tieu_du_no_tang_net) ? $value->chi_tieu_du_no_tang_net : '')
				->getStyle('F' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('G' . $i, !empty($value->total_doanh_so_bao_hiem) ? $value->total_doanh_so_bao_hiem : '')
				->getStyle('G' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('H' . $i, !empty($value->chi_tieu_bao_hiem) ? $value->chi_tieu_bao_hiem : '')
				->getStyle('H' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('I' . $i, !empty($value->total_so_tien_vay) ? $value->total_so_tien_vay : '')
				->getStyle('I' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('J' . $i, !empty($value->chi_tieu_giai_ngan) ? $value->chi_tieu_giai_ngan : '')
				->getStyle('J' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('K' . $i, !empty($value->tong_tien_dau_tu) ? $value->tong_tien_dau_tu : '')
				->getStyle('K' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('L' . $i, !empty($value->chi_tieu_nha_dau_tu) ? $value->chi_tieu_nha_dau_tu : '')
				->getStyle('L' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('M' . $i, !empty($value->kpi) ? $value->kpi : '')
				->getStyle('M' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('N' . $i, !empty($value->total_tien_hoa_hong) ? $value->total_tien_hoa_hong : '')
				->getStyle('N' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$i++;
		}

		$this->callLibExcel('Kpi_Asm' . time() . '.xlsx');

	}

	public function exportAllDuNo()
	{

		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$data = array();
		if (!empty($fdate)) $data['start'] = $fdate;
		if (!empty($tdate)) $data['end'] = $tdate;

		$dataLead = $this->api->apiPost($this->userInfo['token'], "report_kpi/exportAllDuNo", $data);
		if (!empty($dataLead->data)) {
			$this->exportAllDuNo_data($dataLead->data);

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}

	}

	public function exportAllDuNo_data($export)
	{


		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('C1', 'Mã hợp đồng');
		$this->sheet->setCellValue('D1', 'Phòng giao dịch');
		$this->sheet->setCellValue('E1', 'Số ngày chậm trả');
		$this->sheet->setCellValue('F1', 'Gốc còn lại');
		$this->sheet->setCellValue('G1', 'Ngày giải ngân');
		$this->sheet->setCellValue('H1', 'Người tạo');

		$i = 2;
		foreach ($export as $key => $value) {

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($value->code_contract) ? $value->code_contract : '');
			$this->sheet->setCellValue('C' . $i, !empty($value->code_contract_disbursement) ? $value->code_contract_disbursement : '');
			$this->sheet->setCellValue('D' . $i, !empty($value->store->name) ? $value->store->name : '');

			$this->sheet->setCellValue('E' . $i, !empty($value->debt->so_ngay_cham_tra) ? $value->debt->so_ngay_cham_tra : '')
				->getStyle('E' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('F' . $i, !empty($value->debt->tong_tien_goc_con) ? $value->debt->tong_tien_goc_con : '')
				->getStyle('F' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('G' . $i, !empty($value->disbursement_date) ? date('d/m/Y', $value->disbursement_date) : '');
			$this->sheet->setCellValue('H' . $i, !empty($value->created_by) ? $value->created_by : '');


			$i++;
		}

		$this->callLibExcel('export' . time() . '.xlsx');


	}

	public function view_payroll_cvkd()
	{

		$fdate_month = !empty($_GET['fdate_month']) ? $_GET['fdate_month'] : "";

		$check_month = date('Y') . "-" . date('m');

		if (!empty($fdate_month) && $fdate_month != "" && $fdate_month != $check_month) {
			$this->session->set_flashdata('error', "Xuất Kpi ở tháng hiện tại");
			redirect("/view_payroll/index_payroll");
			return;
		}

		$data = array();
		if (!empty($fdate)) $data['start'] = $fdate;
		if (!empty($tdate)) $data['end'] = $tdate;

		$dataLead = $this->api->apiPost($this->userInfo['token'], "report_kpi/view_payroll_cvkd", $data);
		if (!empty($dataLead->data)) {
			$this->exportKpiCvkd_data($dataLead->data);

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}

	}

	public function view_payroll_store()
	{

		$fdate_month = !empty($_GET['fdate_month']) ? $_GET['fdate_month'] : "";

		$check_month = date('Y') . "-" . date('m');

		if (!empty($fdate_month) && $fdate_month != "" && $fdate_month != $check_month) {
			$this->session->set_flashdata('error', "Xuất Kpi ở tháng hiện tại");
			redirect("/view_payroll/index_payroll");
			return;
		}

		$data = array();
		if (!empty($fdate)) $data['start'] = $fdate;
		if (!empty($tdate)) $data['end'] = $tdate;

		$dataLead = $this->api->apiPost($this->userInfo['token'], "report_kpi/view_payroll_store", $data);
		if (!empty($dataLead->data)) {
			$this->exportKpiPGD_data($dataLead->data);

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}


	}

	public function view_payroll_cvkd_list()
	{

		$fdate_month = !empty($_GET['fdate_month']) ? $_GET['fdate_month'] : "";

		$check_month = date('Y') . "-" . date('m');

		if (!empty($fdate_month) && $fdate_month != "" && $fdate_month != $check_month) {
			$this->session->set_flashdata('error', "Xuất Kpi ở tháng hiện tại");
			redirect("/view_payroll/index_payroll");
			return;
		}

		$data = array();
		if (!empty($fdate)) $data['start'] = $fdate;
		if (!empty($tdate)) $data['end'] = $tdate;

		$dataLead = $this->api->apiPost($this->userInfo['token'], "report_kpi/view_payroll_cvkd_list", $data);
		if (!empty($dataLead->data)) {
			$this->exportKpiCvkd_data($dataLead->data);

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}

	}

	public function export_recording()
	{

		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$get_call = !empty($_GET['get_call']) ? $_GET['get_call'] : "";
		$hangupCause = !empty($_GET['hangupCause']) ? $_GET['hangupCause'] : "";
		$email_thn = !empty($_GET['email_thn']) ? $_GET['email_thn'] : "";

		$data = array();
		if (!empty($fdate)) $data['fdate'] = $fdate;
		if (!empty($tdate)) $data['tdate'] = $tdate;
		if (!empty($get_call)) $data['get_call'] = $get_call;
		if (!empty($hangupCause)) $data['hangupCause'] = $hangupCause;
		if (!empty($email_thn)) $data['email_thn'] = $email_thn;

		$dataRecord = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/export_recording", $data);

		$this->export_recording_data($dataRecord->data);


	}

	public function export_recording_data($export)
	{

		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Nhân viên');
		$this->sheet->setCellValue('C1', 'Số điện thoại');
		$this->sheet->setCellValue('D1', 'Thời gian bắt đầu');
		$this->sheet->setCellValue('E1', 'Thời gian kết thúc');
		$this->sheet->setCellValue('F1', 'Thời gian call');
		$this->sheet->setCellValue('G1', 'Trạng thái');

		$i = 2;
		foreach ($export as $key => $value) {

			$hangupCause = "";
			if ($value->hangupCause == 'NORMAL_CLEARING') {
				$hangupCause = 'Nghe máy';
			} elseif ($value->hangupCause == "NO_USER_RESPONSE") {
				$hangupCause = 'Không nghe máy';
			} elseif ($value->hangupCause == "CALL_REJECTED") {
				$hangupCause = 'Từ chối nghe';
			} elseif ($value->hangupCause == "ORIGINATOR_CANCEL") {
				$hangupCause = 'Người gọi dừng';
			} else {
				$hangupCause = 'Máy bận';
			}

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($value->fromUser->email) ? $value->fromUser->email : '');
			$this->sheet->setCellValue('C' . $i, !empty($value->toNumber) ? hide_phone($value->toNumber) : '');
			$this->sheet->setCellValue('D' . $i, !empty($value->startTime) ? date('d/m/Y H:i:s', $value->startTime / 1000) : '');
			$this->sheet->setCellValue('E' . $i, !empty($value->endTime) ? date('d/m/Y H:i:s', $value->endTime / 1000) : '');
			$this->sheet->setCellValue('F' . $i, !empty($value->billDuration) ? $value->billDuration . 's' : '');
			$this->sheet->setCellValue('G' . $i, !empty($hangupCause) ? $hangupCause : '');


			$i++;
		}

		$this->callLibExcel('Export_Call_ThuHoiNo_' . time() . '.xlsx');

	}


	public function export_kpi_call_b0b1()
	{

		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$data = array();
		$data['start'] = $start;

		$data_Call_Thn = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/export_data_call_thn", $data);

		$this->export_data_call_thn($data_Call_Thn->data);


	}

	public function export_data_call_thn($export)
	{

		$this->sheet->setCellValue('A1', 'TC');
		$this->sheet->setCellValue('B1', 'BUCKET');
		$this->sheet->setCellValue('C1', 'HD');
		$this->sheet->setCellValue('D1', 'BOM POS');
		$this->sheet->setCellValue('E1', 'TARGET KPI');
		$this->sheet->setCellValue('F1', 'RS POS');
		$this->sheet->setCellValue('G1', 'REAL AMOUNT');
		$this->sheet->setCellValue('H1', '% RESOLVED');
		$this->sheet->setCellValue('I1', '% UNRESOLVED');
		$this->sheet->setCellValue('J1', '% COMPLETION ACCORDING TO KPI');
		$this->sheet->setCellValue('K1', 'DISTRIBUTION WEIGHT');
		$this->sheet->setCellValue('L1', 'WEIGHT KPI COMPLETE RATE');
		$this->sheet->setCellValue('M1', 'SUMMARY OF PERFORMANCE KPI');
		$this->sheet->setCellValue('N1', 'BONUS');

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


		$i = 2;
		$row = 2;
		$number_end = 2;
		foreach ($export as $key => $value) {
			$start = $number_end;
			if ($number_end != 2) {
				$start++;
			}
			$number_end = $start + 3;

			$this->sheet->setCellValue('A' . $start, !empty($value->tc) ? $value->tc : '');
			$this->sheet->mergeCells("A$start:A$number_end");

			foreach ($value->bucket as $item) {
				$this->sheet->setCellValue('B' . $row, !empty($item->bucket) ? $item->bucket : "");

				$this->sheet->setCellValue('C' . $row, !empty($item->HĐ) ? $item->HĐ : 0)
					->getStyle('C' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('D' . $row, !empty($item->BOM_POS) ? $item->BOM_POS : 0)
					->getStyle('D' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('E' . $row, !empty($item->target_kpi) ? $item->target_kpi : 0)
					->getStyle('E' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('F' . $row, !empty($item->RS_POS) ? $item->RS_POS : 0)
					->getStyle('F' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('G' . $row, !empty($item->REAL_AMOUNT) ? $item->REAL_AMOUNT : 0)
					->getStyle('G' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('H' . $row, !empty($item->RESOLVED) ? $item->RESOLVED : 0)
					->getStyle('H' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('I' . $row, !empty($item->UNRESOLVED) ? $item->UNRESOLVED : 0)
					->getStyle('I' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('J' . $row, !empty($item->completion) ? $item->completion : 0)
					->getStyle('J' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('K' . $row, !empty($item->distribution_weight) ? $item->distribution_weight : 0)
					->getStyle('K' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('L' . $row, !empty($item->weight_kpi_complete_rate) ? $item->weight_kpi_complete_rate : 0)
					->getStyle('L' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$row++;

			}

			$this->sheet->setCellValue('M' . $start, !empty($value->SUMMARY_OF_PERFORMANCE_KPI) ? $value->SUMMARY_OF_PERFORMANCE_KPI : 0)
				->getStyle('M' . $start)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->mergeCells("M$start:M$number_end");


			$this->sheet->setCellValue('N' . $start, !empty($value->BONUS) ? $value->BONUS : 0)
				->getStyle('N' . $start)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->mergeCells("N$start:N$number_end");


		}

		$this->callLibExcel('Export_Call_ThuHoiNo_' . time() . '.xlsx');

	}

	public function export_kpi_leader_call_b0b3()
	{

		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$data = array();
		$data['start'] = $start;

		$data_Call_Thn = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/export_kpi_leader_call_b0b3", $data);

		$this->export_data_call_thn($data_Call_Thn->data);


	}

	public function export_kpi_field_b1b3()
	{

		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$data = array();
		$data['start'] = $start;

		$data_Call_Thn = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/export_kpi_field_b1b3", $data);

		$this->export_data_field_b1b3_thn($data_Call_Thn->data);

	}

	public function export_data_field_b1b3_thn($export)
	{

		$this->sheet->setCellValue('A1', 'TC');
		$this->sheet->setCellValue('B1', 'BUCKET');
		$this->sheet->setCellValue('C1', 'HD');
		$this->sheet->setCellValue('D1', 'BOM POS');
		$this->sheet->setCellValue('E1', 'TARGET KPI');
		$this->sheet->setCellValue('F1', 'RS POS');
		$this->sheet->setCellValue('G1', 'REAL AMOUNT');
		$this->sheet->setCellValue('H1', '% RESOLVED');
		$this->sheet->setCellValue('I1', '% UNRESOLVED');
		$this->sheet->setCellValue('J1', '% COMPLETION ACCORDING TO KPI');
		$this->sheet->setCellValue('K1', 'DISTRIBUTION WEIGHT');
		$this->sheet->setCellValue('L1', 'WEIGHT KPI COMPLETE RATE');
		$this->sheet->setCellValue('M1', 'SUMMARY OF PERFORMANCE KPI');
		$this->sheet->setCellValue('N1', 'BONUS');

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


		$i = 2;
		$row = 2;
		$number_end = 2;
		foreach ($export as $key => $value) {
			$start = $number_end;
			if ($number_end != 2) {
				$start++;
			}
			$number_end = $start + 2;

			$this->sheet->setCellValue('A' . $start, !empty($value->tc) ? $value->tc : '');
			$this->sheet->mergeCells("A$start:A$number_end");

			foreach ($value->bucket as $item) {
				$this->sheet->setCellValue('B' . $row, !empty($item->bucket) ? $item->bucket : "");

				$this->sheet->setCellValue('C' . $row, !empty($item->HĐ) ? $item->HĐ : 0)
					->getStyle('C' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('D' . $row, !empty($item->BOM_POS) ? $item->BOM_POS : 0)
					->getStyle('D' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('E' . $row, !empty($item->target_kpi) ? $item->target_kpi : 0)
					->getStyle('E' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('F' . $row, !empty($item->RS_POS) ? $item->RS_POS : 0)
					->getStyle('F' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('G' . $row, !empty($item->REAL_AMOUNT) ? $item->REAL_AMOUNT : 0)
					->getStyle('G' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('H' . $row, !empty($item->RESOLVED) ? $item->RESOLVED : 0)
					->getStyle('H' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('I' . $row, !empty($item->UNRESOLVED) ? $item->UNRESOLVED : 0)
					->getStyle('I' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('J' . $row, !empty($item->completion) ? $item->completion : 0)
					->getStyle('J' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('K' . $row, !empty($item->distribution_weight) ? $item->distribution_weight : 0)
					->getStyle('K' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('L' . $row, !empty($item->weight_kpi_complete_rate) ? $item->weight_kpi_complete_rate : 0)
					->getStyle('L' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$row++;

			}

			$this->sheet->setCellValue('M' . $start, !empty($value->SUMMARY_OF_PERFORMANCE_KPI) ? $value->SUMMARY_OF_PERFORMANCE_KPI : 0)
				->getStyle('M' . $start)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->mergeCells("M$start:M$number_end");


			$this->sheet->setCellValue('N' . $start, !empty($value->BONUS) ? $value->BONUS : 0)
				->getStyle('N' . $start)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->mergeCells("N$start:N$number_end");


		}

		$this->callLibExcel('Export_Field_ThuHoiNo_' . time() . '.xlsx');

	}

	public function export_kpi_field_b4()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$data = array();
		$data['start'] = $start;

		$data_Call_Thn = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/export_kpi_field_b4", $data);

		$this->export_data_kpi_field_b4($data_Call_Thn->data);
	}

	public function export_data_kpi_field_b4($export)
	{

		$this->sheet->setCellValue('A1', 'TC');
		$this->sheet->setCellValue('B1', 'BUCKET');
		$this->sheet->setCellValue('C1', 'HD');
		$this->sheet->setCellValue('D1', 'BOM POS');
		$this->sheet->setCellValue('E1', 'TARGET KPI');
		$this->sheet->setCellValue('F1', 'RS POS');
		$this->sheet->setCellValue('G1', 'REAL AMOUNT');
		$this->sheet->setCellValue('H1', '% RESOLVED');
		$this->sheet->setCellValue('I1', '% UNRESOLVED');
		$this->sheet->setCellValue('J1', '% COMPLETION ACCORDING TO KPI');
		$this->sheet->setCellValue('K1', 'DISTRIBUTION WEIGHT');
		$this->sheet->setCellValue('L1', 'WEIGHT KPI COMPLETE RATE');
		$this->sheet->setCellValue('M1', 'SUMMARY OF PERFORMANCE KPI');
		$this->sheet->setCellValue('N1', 'BONUS');

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


		$i = 2;

		foreach ($export as $key => $value) {

			$this->sheet->setCellValue('A' . $i, !empty($value->tc) ? $value->tc : '');
			$this->sheet->setCellValue('B' . $i, !empty($value->bucket->bucket) ? $value->bucket->bucket : '');
			$this->sheet->setCellValue('C' . $i, !empty($value->bucket->HĐ) ? $value->bucket->HĐ : 0);
			$this->sheet->setCellValue('D' . $i, !empty($value->bucket->BOM_POS) ? $value->bucket->BOM_POS : 0)
				->getStyle('D' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('E' . $i, !empty($value->bucket->target_kpi) ? $value->bucket->target_kpi : 0)
				->getStyle('E' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('F' . $i, !empty($value->bucket->RS_POS) ? $value->bucket->RS_POS : 0)
				->getStyle('F' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('G' . $i, !empty($value->bucket->REAL_AMOUNT) ? $value->bucket->REAL_AMOUNT : 0)
				->getStyle('G' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('H' . $i, !empty($value->bucket->RESOLVED) ? $value->bucket->RESOLVED : 0)
				->getStyle('H' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('I' . $i, !empty($value->bucket->UNRESOLVED) ? $value->bucket->UNRESOLVED : 0)
				->getStyle('I' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('J' . $i, !empty($value->bucket->completion) ? $value->bucket->completion : 0)
				->getStyle('J' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('K' . $i, !empty($value->bucket->distribution_weight) ? $value->bucket->distribution_weight : 0)
				->getStyle('K' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('L' . $i, !empty($value->bucket->weight_kpi_complete_rate) ? $value->bucket->weight_kpi_complete_rate : 0)
				->getStyle('L' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('M' . $i, !empty($value->SUMMARY_OF_PERFORMANCE_KPI) ? $value->SUMMARY_OF_PERFORMANCE_KPI : 0)
				->getStyle('M' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('N' . $i, !empty($value->BONUS) ? $value->BONUS : 0)
				->getStyle('N' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$i++;
		}

		$this->callLibExcel('Export_Field_ThuHoiNo_' . time() . '.xlsx');

	}

	public function export_kpi_leader_field()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$data = array();
		$data['start'] = $start;

		$data_Call_Thn = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/export_kpi_leader_field", $data);

		$this->export_data_lead_field($data_Call_Thn->data);
	}

	public function export_data_lead_field($export)
	{

		$this->sheet->setCellValue('A1', 'TC');
		$this->sheet->setCellValue('B1', 'BUCKET');
		$this->sheet->setCellValue('C1', 'HD');
		$this->sheet->setCellValue('D1', 'BOM POS');
		$this->sheet->setCellValue('E1', 'TARGET KPI');
		$this->sheet->setCellValue('F1', 'RS POS');
		$this->sheet->setCellValue('G1', 'REAL AMOUNT');
		$this->sheet->setCellValue('H1', '% RESOLVED');
		$this->sheet->setCellValue('I1', '% UNRESOLVED');
		$this->sheet->setCellValue('J1', '% COMPLETION ACCORDING TO KPI');
		$this->sheet->setCellValue('K1', 'DISTRIBUTION WEIGHT');
		$this->sheet->setCellValue('L1', 'WEIGHT KPI COMPLETE RATE');
		$this->sheet->setCellValue('M1', 'SUMMARY OF PERFORMANCE KPI');
		$this->sheet->setCellValue('N1', 'BONUS');

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


		$i = 2;
		$row = 2;
		$number_end = 2;
		foreach ($export as $key => $value) {
			$start = $number_end;
			if ($number_end != 2) {
				$start++;
			}
			$number_end = $start + 3;

			$this->sheet->setCellValue('A' . $start, !empty($value->tc) ? $value->tc : '');
			$this->sheet->mergeCells("A$start:A$number_end");

			foreach ($value->bucket as $item) {
				$this->sheet->setCellValue('B' . $row, !empty($item->bucket) ? $item->bucket : "");

				$this->sheet->setCellValue('C' . $row, !empty($item->HĐ) ? $item->HĐ : 0)
					->getStyle('C' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('D' . $row, !empty($item->BOM_POS) ? $item->BOM_POS : 0)
					->getStyle('D' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('E' . $row, !empty($item->target_kpi) ? $item->target_kpi : 0)
					->getStyle('E' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('F' . $row, !empty($item->RS_POS) ? $item->RS_POS : 0)
					->getStyle('F' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('G' . $row, !empty($item->REAL_AMOUNT) ? $item->REAL_AMOUNT : 0)
					->getStyle('G' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('H' . $row, !empty($item->RESOLVED) ? $item->RESOLVED : 0)
					->getStyle('H' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('I' . $row, !empty($item->UNRESOLVED) ? $item->UNRESOLVED : 0)
					->getStyle('I' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('J' . $row, !empty($item->completion) ? $item->completion : 0)
					->getStyle('J' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('K' . $row, !empty($item->distribution_weight) ? $item->distribution_weight : 0)
					->getStyle('K' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('L' . $row, !empty($item->weight_kpi_complete_rate) ? $item->weight_kpi_complete_rate : 0)
					->getStyle('L' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$row++;

			}

			$this->sheet->setCellValue('M' . $start, !empty($value->SUMMARY_OF_PERFORMANCE_KPI) ? $value->SUMMARY_OF_PERFORMANCE_KPI : 0)
				->getStyle('M' . $start)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->mergeCells("M$start:M$number_end");


			$this->sheet->setCellValue('N' . $start, !empty($value->BONUS) ? $value->BONUS : 0)
				->getStyle('N' . $start)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->mergeCells("N$start:N$number_end");


		}

		$this->callLibExcel('Export_Field_ThuHoiNo_' . time() . '.xlsx');


	}

	public function export_kpi_thn_all()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$data = array();
		$data['start'] = $start;

		$data_Call_Thn = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/export_kpi_thn_all", $data);

		$this->export_data_kpi_thn_all($data_Call_Thn->data);
	}

	public function export_data_kpi_thn_all($export)
	{
		$this->sheet->setCellValue('A1', 'TC');
		$this->sheet->setCellValue('B1', 'BUCKET');
		$this->sheet->setCellValue('C1', 'HD');
		$this->sheet->setCellValue('D1', 'BOM POS');
		$this->sheet->setCellValue('E1', 'TARGET KPI');
		$this->sheet->setCellValue('F1', 'RS POS');
		$this->sheet->setCellValue('G1', 'REAL AMOUNT');
		$this->sheet->setCellValue('H1', '% RESOLVED');
		$this->sheet->setCellValue('I1', '% UNRESOLVED');
		$this->sheet->setCellValue('J1', '% COMPLETION ACCORDING TO KPI');
		$this->sheet->setCellValue('K1', 'DISTRIBUTION WEIGHT');
		$this->sheet->setCellValue('L1', 'WEIGHT KPI COMPLETE RATE');
		$this->sheet->setCellValue('M1', 'SUMMARY OF PERFORMANCE KPI');
		$this->sheet->setCellValue('N1', 'BONUS');

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


		$i = 2;
		$row = 2;
		$number_end = 2;
		foreach ($export as $key => $value) {
			$start = $number_end;
			if ($number_end != 2) {
				$start++;
			}
			$number_end = $start + 4;

			$this->sheet->setCellValue('A' . $start, !empty($value->tc) ? $value->tc : '');
			$this->sheet->mergeCells("A$start:A$number_end");

			foreach ($value->bucket as $item) {
				$this->sheet->setCellValue('B' . $row, !empty($item->bucket) ? $item->bucket : "");

				$this->sheet->setCellValue('C' . $row, !empty($item->HĐ) ? $item->HĐ : 0)
					->getStyle('C' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('D' . $row, !empty($item->BOM_POS) ? $item->BOM_POS : 0)
					->getStyle('D' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('E' . $row, !empty($item->target_kpi) ? $item->target_kpi : 0)
					->getStyle('E' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('F' . $row, !empty($item->RS_POS) ? $item->RS_POS : 0)
					->getStyle('F' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('G' . $row, !empty($item->REAL_AMOUNT) ? $item->REAL_AMOUNT : 0)
					->getStyle('G' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('H' . $row, !empty($item->RESOLVED) ? $item->RESOLVED : 0)
					->getStyle('H' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('I' . $row, !empty($item->UNRESOLVED) ? $item->UNRESOLVED : 0)
					->getStyle('I' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('J' . $row, !empty($item->completion) ? $item->completion : 0)
					->getStyle('J' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('K' . $row, !empty($item->distribution_weight) ? $item->distribution_weight : 0)
					->getStyle('K' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$this->sheet->setCellValue('L' . $row, !empty($item->weight_kpi_complete_rate) ? $item->weight_kpi_complete_rate : 0)
					->getStyle('L' . $row)
					->getNumberFormat()
					->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
				$row++;
			}

			$this->sheet->setCellValue('M' . $start, !empty($value->SUMMARY_OF_PERFORMANCE_KPI) ? $value->SUMMARY_OF_PERFORMANCE_KPI : 0)
				->getStyle('M' . $start)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->mergeCells("M$start:M$number_end");


			$this->sheet->setCellValue('N' . $start, !empty($value->BONUS) ? $value->BONUS : 0)
				->getStyle('N' . $start)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->mergeCells("N$start:N$number_end");


		}

		$this->callLibExcel('Export_ToanPhong_' . time() . '.xlsx');
	}

	public function export_contest()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$data = array();
		$data['start'] = $start;

		$data_Call_Thn = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/export_contest", $data);

		$this->export_data_contest($data_Call_Thn->data);
	}

	public function export_data_contest($export)
	{

		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Họ tên nhân viên');
		$this->sheet->setCellValue('C1', 'Chức vụ');
		$this->sheet->setCellValue('D1', 'Bộ phận');
		$this->sheet->setCellValue('E1', 'Thu phí phạt (tổng tiền phạt)');
		$this->sheet->setCellValue('F1', 'Thưởng');
		$this->sheet->setCellValue('G1', 'Bucket Roll back (số kỳ phí thu)');
		$this->sheet->setCellValue('H1', 'Thưởng');
		$this->sheet->setCellValue('I1', 'Tất toán HĐ Xe Máy (số khách hàng)');
		$this->sheet->setCellValue('J1', 'Thưởng');
		$this->sheet->setCellValue('K1', 'Tất toán HĐ Xe Ô TÔ (số khách hàng)');
		$this->sheet->setCellValue('L1', 'Thưởng');
		$this->sheet->setCellValue('M1', 'Tổng thưởng Contest');

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


		$i = 2;

		foreach ($export as $key => $value) {

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($value->email) ? $value->email : '');
			$this->sheet->setCellValue('C' . $i, !empty($value->chuc_vu) ? $value->chuc_vu : '');
			$this->sheet->setCellValue('D' . $i, !empty($value->bo_phan) ? $value->bo_phan : '');
			$this->sheet->setCellValue('E' . $i, !empty($value->tong_thu_phi_phat) ? $value->tong_thu_phi_phat : 0)
				->getStyle('E' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('F' . $i, !empty($value->thuong_phi_phat) ? $value->thuong_phi_phat : 0)
				->getStyle('F' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('G' . $i, !empty($value->so_ky_phi_thu) ? $value->so_ky_phi_thu : 0)
				->getStyle('G' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('H' . $i, !empty($value->thuong_rollback) ? $value->thuong_rollback : 0)
				->getStyle('H' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('I' . $i, !empty($value->tat_toan_hd_xm) ? $value->tat_toan_hd_xm : 0)
				->getStyle('I' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('J' . $i, !empty($value->thuong_tt_xemay) ? $value->thuong_tt_xemay : 0)
				->getStyle('J' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('K' . $i, !empty($value->tat_toan_hd_oto) ? $value->tat_toan_hd_oto : 0)
				->getStyle('K' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('L' . $i, !empty($value->thuong_tt_oto) ? $value->thuong_tt_oto : 0)
				->getStyle('L' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('M' . $i, !empty($value->total_price) ? $value->total_price : 0)
				->getStyle('M' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);


			$i++;
		}

		$this->callLibExcel('Export_Thuong_Contest_' . time() . '.xlsx');

	}

	public function export_tong_thuong_thang()
	{

		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$data = array();
		$data['start'] = $start;

		$data_Call_Thn = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/export_tong_thuong_thang", $data);

		$this->export_data_tong_thuong_thang($data_Call_Thn->data, $data_Call_Thn->data_quanly);

	}

	public function export_data_tong_thuong_thang($export, $data_qly)
	{

		$this->sheet->setCellValue('A1', 'Team');
		$this->sheet->setCellValue('B1', 'Cấp chuyên viên');
		$this->sheet->setCellValue('C1', 'Chức vụ');
		$this->sheet->setCellValue('D1', 'Kết quả hoàn thành KPIs (%)');
		$this->sheet->setCellValue('E1', 'Thưởng Contest');
		$this->sheet->setCellValue('F1', 'Thưởng KPIs');
		$this->sheet->setCellValue('G1', 'Tổng thưởng thực nhận KPI + Contest');

		$this->setStyle("A1");
		$this->setStyle("B1");
		$this->setStyle("C1");
		$this->setStyle("D1");
		$this->setStyle("E1");
		$this->setStyle("F1");
		$this->setStyle("G1");


		$i = 2;

		foreach ($export as $key => $value) {

			$this->sheet->setCellValue('A' . $i, !empty($value->team) ? $value->team : '');
			$this->sheet->setCellValue('B' . $i, !empty($value->email) ? $value->email : '');
			$this->sheet->setCellValue('C' . $i, !empty($value->chuc_vu) ? $value->chuc_vu : '');
			$this->sheet->setCellValue('D' . $i, !empty($value->kpi) ? $value->kpi : 0)
				->getStyle('D' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('E' . $i, !empty($value->tong_thuong_contest) ? $value->tong_thuong_contest : 0)
				->getStyle('E' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('F' . $i, !empty($value->money_kpi) ? $value->money_kpi : 0)
				->getStyle('F' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('G' . $i, !empty($value->total_money) ? $value->total_money : 0)
				->getStyle('G' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$i++;
		}

		$this->sheet->setCellValue('A' . $i, 'Chức vụ');
		$this->sheet->setCellValue('B' . $i, 'Cấp quản lý');
		$this->sheet->setCellValue('C' . $i, 'Kết quả hoàn thành KPIs (%)');
		$this->sheet->setCellValue('F' . $i, 'Thưởng KPIs');
		$this->sheet->setCellValue('G' . $i, 'Tổng thưởng thực nhận KPI + Contest');
		$this->sheet->mergeCells("C$i:E$i");
		$this->setStyle("A" . $i);
		$this->setStyle("B" . $i);
		$this->setStyle("C" . $i);
		$this->setStyle("D" . $i);
		$this->setStyle("E" . $i);
		$this->setStyle("F" . $i);
		$this->setStyle("G" . $i);

		$j = $i + 1;
		foreach ($data_qly as $key => $value) {

			$this->sheet->setCellValue('A' . $j, !empty($value->team) ? $value->team : '');
			$this->sheet->setCellValue('B' . $j, !empty($value->email) ? $value->email : '');
			$this->sheet->setCellValue('C' . $j, !empty($value->kpi) ? $value->kpi : 0)
				->getStyle('C' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->mergeCells("C$j:E$j");

			$this->sheet->setCellValue('F' . $j, !empty($value->money_kpi) ? $value->money_kpi : 0)
				->getStyle('F' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('G' . $j, !empty($value->total_money) ? $value->total_money : 0)
				->getStyle('G' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$j++;
		}

		$this->callLibExcel('Export_Tong_Thuong_Thang_' . time() . '.xlsx');

	}

	public function excel_contract_ho()
	{
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$id_card = !empty($_GET['id_card']) ? $_GET['id_card'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : 17;
		$loan_product = !empty($_GET['loan_product']) ? $_GET['loan_product'] : "";
		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('debt_manager_app/view_contract'));
		}
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$data['start'] = $start;
			$data['end'] = $end;
		}

		if (!empty($id_card)) {
			$data['id_card'] = trim($id_card);
		}
		if (!empty($customer_name)) {
			$data['customer_name'] = trim($customer_name);
		}
		if (!empty($code_contract_disbursement)) {
			$data['code_contract_disbursement'] = trim($code_contract_disbursement);
		}
		if (!empty($code_contract)) {
			$data['code_contract'] = trim($code_contract);
		}
		if (!empty($store)) {
			$data['store'] = trim($store);
		}
		if (!empty($status)) {
			$data['status'] = trim($status);
		}
		if (!empty($loan_product)) {
			$data['loan_product'] = trim($loan_product);
		}
		$data['per_page'] = 2000;
		$contractData = $this->api->apiPost($this->user['token'], "debt_manager_app/contract_tempo_debt_ho", $data);
		if (!empty($contractData->status) && $contractData->status == 200) {
			$this->export_contract_ho($contractData->data);
			$this->callLibExcel('data-debt_contract-' . time() . '.xlsx');
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
			redirect(base_url('accountant/contract_v2'));
		}
	}

	private function export_contract_ho($contractData)
	{
		$this->sheet->setCellValue('A1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('B1', 'Mã hợp đồng');
		$this->sheet->setCellValue('C1', 'Tên khách hàng');
		$this->sheet->setCellValue('D1', 'Số tiền giải ngân');
		$this->sheet->setCellValue('E1', 'Hình thức vay');
		$this->sheet->setCellValue('F1', 'Sản phẩm vay');
		$this->sheet->setCellValue('G1', 'Kì hạn vay');
		$this->sheet->setCellValue('H1', 'Ngày trễ hạn');
		$this->sheet->setCellValue('I1', 'Bucket');
		$this->sheet->setCellValue('J1', 'Số kì thanh toán');
		$this->sheet->setCellValue('K1', 'Gốc còn lại');
		$this->sheet->setCellValue('L1', 'PGD');
		$this->sheet->setCellValue('M1', 'CMND/CCCD');
		$this->sheet->setCellValue('N1', 'Tỉnh hộ khẩu');
		$this->sheet->setCellValue('O1', 'Ngày giải ngân');
		$this->sheet->setCellValue('P1', 'Người phê duyệt');
		$this->sheet->setCellValue('Q1', 'Ngoại lệ');
		$this->sheet->setCellValue('R1', 'Trạng thái');

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
		foreach ($contractData as $item) {
			$ngoai_le = '';
			foreach ($item->ngoai_le as $value) {
				$ngoai_le .= lead_exception($value) . "\n";
			}
			$district = !empty($item->current_address->district) ? get_district_name_by_code($item->current_address->district) : '';
			$province = !empty($item->current_address->province) ? get_province_name_by_code($item->current_address->province) : '';
			$this->sheet->setCellValue('A' . $i, !empty($item->code_contract) ? $item->code_contract : '');
			$this->sheet->setCellValue('B' . $i, !empty($item->code_contract_disbursement) ? $item->code_contract_disbursement : '');
			$this->sheet->setCellValue('C' . $i, !empty($item->customer_infor->customer_name) ? $item->customer_infor->customer_name : "");
			$this->sheet->setCellValue('D' . $i, !empty($item->loan_infor->amount_money) ? number_format($item->loan_infor->amount_money) : "");
			$this->sheet->setCellValue('E' . $i, $item->loan_infor->type_interest == 1 ? "Lãi hàng tháng, gốc hàng tháng" : "Lãi hàng tháng, gốc cuối kỳ");
			$this->sheet->setCellValue('F' . $i, !empty($item->loan_infor->loan_product->text) ? ($item->loan_infor->loan_product->text) : '');
			$this->sheet->setCellValue('G' . $i, !empty($item->loan_infor->number_day_loan) ? $item->loan_infor->number_day_loan / 30 . ' tháng' : '');
			$this->sheet->setCellValue('H' . $i, !empty($item->debt->so_ngay_cham_tra) ? $item->debt->so_ngay_cham_tra : "");
			$this->sheet->setCellValue('I' . $i, !empty($item->debt->so_ngay_cham_tra) ? get_bucket($item->debt->so_ngay_cham_tra) : "");
			$this->sheet->setCellValue('J' . $i, !empty($item->so_ki_thanh_toan) ? ($item->so_ki_thanh_toan) : 0);
			$this->sheet->setCellValue('K' . $i, $item->status == 17 && !empty($item->original_debt) ? number_format($item->original_debt->du_no_goc_con_lai) : '');
			$this->sheet->setCellValue('L' . $i, !empty($item->store) ? ($item->store->name) : '');
			$this->sheet->setCellValue('M' . $i, !empty($item->customer_infor) ? ($item->customer_infor->customer_identify) : '');
			$this->sheet->setCellValue('N' . $i, $district . '/' . $province);
			$this->sheet->setCellValue('O' . $i, !empty($item->disbursement_date) ? date('d-m-Y', $item->disbursement_date) : '');
			$this->sheet->setCellValue('P' . $i, !empty($item->nguoi_duyet) ? $item->nguoi_duyet : '');
			$this->sheet->setCellValue('Q' . $i, $ngoai_le);
			$this->sheet->setCellValue('R' . $i, contract_status($item->status));
			$i++;
		}
	}

	public function indexExportExcelT10()
	{

		$this->data['template'] = 'page/accountant/report/report_thn.php';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function exportExcelT10()
	{

		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$data = array();
		$data['start'] = $start;

		$data = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/exportExcelT10", $data);

		$this->export_data_excel10($data->data);

	}

	public function export_data_excel10($data)
	{

		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã Phiếu Ghi');
		$this->sheet->setCellValue('C1', 'Số hợp đồng');
		$this->sheet->setCellValue('D1', 'Họ và tên');
		$this->sheet->setCellValue('E1', 'Ngày giải ngân');
		$this->sheet->setCellValue('F1', 'Khoản vay');
		$this->sheet->setCellValue('G1', 'Hình thức vay');
		$this->sheet->setCellValue('H1', 'Tiền kỳ');
		$this->sheet->setCellValue('I1', 'Số tiền gốc còn lại đến ngày xuất dữ liệu');
		$this->sheet->setCellValue('J1', 'Ngày quá hạn đến ngày xuất dữ liệu (DPD)');
		$this->sheet->setCellValue('K1', 'Nhóm đến ngày xuất dữ liệu (Bucket)');
		$this->sheet->setCellValue('L1', 'Số kỳ đã thanh toán tính đến ngày xuất dữ liệu');
		$this->sheet->setCellValue('M1', 'Số điện thoại khách hàng');
		$this->sheet->setCellValue('N1', 'Nghề nghiệp của khách hàng');
		$this->sheet->setCellValue('O1', 'PGD giải ngân');
		$this->sheet->setCellValue('P1', 'Quận/huyện theo hộ khẩu');
		$this->sheet->setCellValue('Q1', 'Tỉnh theo hộ khẩu');

		$this->setStyle_dataT10('A1');
		$this->setStyle_dataT10('B1');
		$this->setStyle_dataT10('C1');
		$this->setStyle_dataT10('D1');
		$this->setStyle_dataT10('E1');
		$this->setStyle_dataT10('F1');
		$this->setStyle_dataT10('G1');
		$this->setStyle_dataT10('H1');
		$this->setStyle_dataT10('I1');
		$this->setStyle_dataT10('J1');
		$this->setStyle_dataT10('K1');
		$this->setStyle_dataT10('L1');
		$this->setStyle_dataT10('M1');
		$this->setStyle_dataT10('N1');
		$this->setStyle_dataT10('O1');
		$this->setStyle_dataT10('P1');
		$this->setStyle_dataT10('Q1');

		$i = 2;

		foreach ($data as $value) {

			$type_interest = "";
			if (!empty($value->type_interest) && $value->type_interest == 1) {
				$type_interest = "Lãi hàng tháng, gốc hàng tháng";
			} else {
				$type_interest = "Lãi hàng tháng, gốc cuối kỳ";
			}

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($value->code_contract) ? $value->code_contract : "");
			$this->sheet->setCellValue('C' . $i, !empty($value->code_contract_disbursement) ? $value->code_contract_disbursement : "");
			$this->sheet->setCellValue('D' . $i, !empty($value->customer_name) ? $value->customer_name : "");
			$this->sheet->setCellValue('E' . $i, !empty($value->disbursement_date) ? date('d/m/Y', $value->disbursement_date) : "");
			$this->sheet->setCellValue('F' . $i, !empty($value->amount_money) ? $value->amount_money : 0)
				->getStyle('F' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('G' . $i, $type_interest);
			$this->sheet->setCellValue('H' . $i, !empty($value->tien_1_ky_phai_tra) ? $value->tien_1_ky_phai_tra : 0)
				->getStyle('H' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('I' . $i, !empty($value->du_no_goc_con_lai) ? $value->du_no_goc_con_lai : 0)
				->getStyle('I' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('J' . $i, !empty($value->ngay_qua_han) ? $value->ngay_qua_han : 0)
				->getStyle('J' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('K' . $i, !empty($value->ngay_qua_han) && $value->ngay_qua_han != 0 ? get_bucket($value->ngay_qua_han) : "B0");
			$this->sheet->setCellValue('L' . $i, !empty($value->so_ky_da_thanh_toan) ? $value->so_ky_da_thanh_toan : 0);
			$this->sheet->setCellValue('M' . $i, !empty($value->customer_phone_number) ? hide_phone($value->customer_phone_number) : "");
			$this->sheet->setCellValue('N' . $i, !empty($value->job_infor) ? $value->job_infor : "");
			$this->sheet->setCellValue('O' . $i, !empty($value->name) ? $value->name : "");
			$this->sheet->setCellValue('P' . $i, !empty($value->ward_name) ? $value->ward_name : "");
			$this->sheet->setCellValue('Q' . $i, !empty($value->province_name) ? $value->province_name : "");


			$i++;
		}


		$this->callLibExcel('Export_Data_T+10_' . date('d-m-Y') . '.xlsx');
	}

	private function setStyle_dataT10($range)
	{
		$styles = [
			'font' =>
				[
					'name' => 'Arial',
					'bold' => true,
					'italic' => false,
					'strikethrough' => false,
					'color' => ['rgb' => 'FFFFFF'],
				],
			'borders' =>
				[
					'left' =>
						[
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
							'color' => ['rgb' => '000000']
						],
					'right' =>
						[
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
							'color' => ['rgb' => '000000']
						],
					'bottom' =>
						[
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
							'color' => ['rgb' => '000000']
						],
					'top' =>
						[
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
							'color' => ['rgb' => '000000']
						]
				],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'startColor' => array('rgb' => "008000")
			],
			'quotePrefix' => true
		];
		$this->getStyle = $styles;
		$this->sheet->getStyle($range)->applyFromArray($styles)->getAlignment()->setHorizontal('center');
	}

	public function report_debt_ninety()
	{

		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$data = array();
		if (!empty($fdate)) $data['fdate'] = $fdate;
		if (!empty($tdate)) $data['tdate'] = $tdate;

		$dataReport = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/report_debt_ninety", $data);
		if (!empty($dataReport->data)) {
			$this->report_debt_ninety_data($dataReport->data);

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	public function report_debt_ninety_data($data)
	{

		$this->sheet->setCellValue('A1', 'Tiêu chí');
		$this->sheet->setCellValue('B1', 'Đang cho vay');
		$this->sheet->setCellValue('C1', 'Đã tất toán');
		$this->sheet->setCellValue('D1', 'HĐ quá hạn > 90 ngày');
		$this->sheet->setCellValue('E1', 'Tỉ lệ HĐ quá hạn > 90 ngày / Đang cho vay');
		$this->sheet->setCellValue('F1', 'Tỉ lệ HĐ quá hạn > 90 ngày / Đã tất toán');

		$this->sheet->setCellValue('A2', 'Số lượng hợp đồng');
		$this->sheet->setCellValue('A3', 'Tổng gốc còn');

		$this->setStyle_dataT10('A1');
		$this->setStyle_dataT10('B1');
		$this->setStyle_dataT10('C1');
		$this->setStyle_dataT10('D1');
		$this->setStyle_dataT10('E1');
		$this->setStyle_dataT10('F1');
		$this->setStyle_dataT10('A2');
		$this->setStyle_dataT10('A3');

		//
		$this->sheet->setCellValue('B2', !empty($data->lending_count) ? $data->lending_count : 0)
			->getStyle('B' . 2)
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		$this->sheet->setCellValue('C2', !empty($data->settlement_count) ? $data->settlement_count : 0)
			->getStyle('C' . 2)
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

		$this->sheet->setCellValue('D2', !empty($data->debt_count) ? $data->debt_count : 0)
			->getStyle('D' . 2)
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		$this->sheet->setCellValue('E2', (!empty($data->lending_count) && $data->lending_count != 0) ? number_format(($data->debt_count / $data->lending_count) * 100, 2) . '%' : 0);
		$this->sheet->setCellValue('F2', (!empty($data->settlement_count) && $data->settlement_count != 0) ? number_format(($data->debt_count / $data->settlement_count) * 100, 2) . '%' : 0);

		//
		$this->sheet->setCellValue('B3', !empty($data->lending_debt) ? $data->lending_debt : 0)
			->getStyle('B' . 3)
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		$this->sheet->setCellValue('C3', !empty($data->settlement_debt) ? $data->settlement_debt : 0)
			->getStyle('C' . 3)
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

		$this->sheet->setCellValue('D3', !empty($data->debt_debt) ? $data->debt_debt : 0)
			->getStyle('D' . 3)
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		$this->sheet->setCellValue('E3', (!empty($data->lending_debt) && $data->lending_debt != 0) ? number_format(($data->debt_debt / $data->lending_debt) * 100, 2) . '%' : 0);
		$this->sheet->setCellValue('F3', (!empty($data->settlement_count) && $data->settlement_count != 0) ? number_format(($data->debt_debt / $data->settlement_debt) * 100, 2) . '%' : 0);


		$this->callLibExcel('Bao_cao_no_xau_>90' . date('d-m-Y') . '.xlsx');
	}


	public function report_debt_product()
	{

		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$data = array();
		if (!empty($fdate)) $data['fdate'] = $fdate;
		if (!empty($tdate)) $data['tdate'] = $tdate;

		$dataReport = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/report_debt_product", $data);
		if (!empty($dataReport->data)) {
			$this->report_debt_product_data($dataReport->data);

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	public function report_debt_product_data($data)
	{

		$this->sheet->setCellValue('A1', 'Tiêu chí');
		$this->sheet->setCellValue('B1', 'Tổng HĐ quá hạn');
		$this->sheet->setCellValue('C1', 'Xe máy');

		$this->sheet->setCellValue('E1', 'Ô tô');
		$this->sheet->setCellValue('G1', 'Tín chấp');

		$this->sheet->setCellValue('A3', 'Số lượng hợp đồng');
		$this->sheet->setCellValue('A4', 'Tổng gốc còn lại');
		$this->sheet->setCellValue('C2', 'Thống kê');
		$this->sheet->setCellValue('D2', 'Tỉ lệ');
		$this->sheet->setCellValue('E2', 'Thống kê');
		$this->sheet->setCellValue('F2', 'Tỉ lệ');
		$this->sheet->setCellValue('G2', 'Thống kê');
		$this->sheet->setCellValue('H2', 'Tỉ lệ');

		$this->sheet->mergeCells("A1:A2");
		$this->sheet->mergeCells("B1:B2");
		$this->sheet->mergeCells("C1:D1");
		$this->sheet->mergeCells("E1:F1");
		$this->sheet->mergeCells("G1:H1");

		$this->setStyle_dataT10('A1');
		$this->setStyle_dataT10('B1');
		$this->setStyle_dataT10('C1');
		$this->setStyle_dataT10('E1');
		$this->setStyle_dataT10('G1');
		$this->setStyle_dataT10('F1');
		$this->setStyle_dataT10('A3');
		$this->setStyle_dataT10('A4');

		//
		$this->sheet->setCellValue('B3', !empty($data->bad_debt_count) ? $data->bad_debt_count : 0)
			->getStyle('B' . 3)
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		$this->sheet->setCellValue('C3', !empty($data->xm_count) ? $data->xm_count : 0)
			->getStyle('C' . 3)
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		$this->sheet->setCellValue('D3', !empty($data->xm_count_ratio) ? $data->xm_count_ratio . '%' : 0);

		$this->sheet->setCellValue('E3', !empty($data->oto_count) ? $data->oto_count : 0)
			->getStyle('E' . 3)
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		$this->sheet->setCellValue('F3', !empty($data->oto_count_ratio) ? $data->oto_count_ratio . '%' : 0);

		$this->sheet->setCellValue('G3', !empty($data->tc_count) ? $data->tc_count : 0)
			->getStyle('G' . 3)
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		$this->sheet->setCellValue('H3', !empty($data->tc_count_ratio) ? $data->tc_count_ratio . '%' : 0);

		//
		$this->sheet->setCellValue('B4', !empty($data->bad_debt) ? $data->bad_debt : 0)
			->getStyle('B' . 4)
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		$this->sheet->setCellValue('C4', !empty($data->xm_debt) ? $data->xm_debt : 0)
			->getStyle('C' . 4)
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		$this->sheet->setCellValue('D4', !empty($data->xm_debt_ratio) ? $data->xm_debt_ratio . '%' : 0);

		$this->sheet->setCellValue('E4', !empty($data->oto_debt) ? $data->oto_debt : 0)
			->getStyle('E' . 4)
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		$this->sheet->setCellValue('F4', !empty($data->oto_debt_ratio) ? $data->oto_debt_ratio . '%' : 0);

		$this->sheet->setCellValue('G4', !empty($data->tc_debt) ? $data->tc_debt : 0)
			->getStyle('G' . 4)
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		$this->sheet->setCellValue('H4', !empty($data->tc_debt_ratio) ? $data->tc_debt_ratio . '%' : 0);


		$this->callLibExcel('Bao_cao_no_xau_theo_san_pham' . date('d-m-Y') . '.xlsx');
	}


	public function report_debt_area()
	{

		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$data = array();
		if (!empty($fdate)) $data['fdate'] = $fdate;
		if (!empty($tdate)) $data['tdate'] = $tdate;

		$dataReport = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/report_debt_area", $data);
		if (!empty($dataReport->data)) {
			$this->report_debt_area_data($dataReport->data);

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	public function report_debt_area_data($data)
	{

		$this->sheet->setCellValue('A1', 'Tiêu chí');
		$this->sheet->setCellValue('B1', 'Tổng gốc còn lại');
		$this->sheet->setCellValue('C1', 'Khoản vay HĐ quá hạn 3 kỳ đầu');
		$this->sheet->setCellValue('D1', 'Tỉ lệ');
		$this->sheet->setCellValue('A2', 'Số lượng HĐ');
		$this->sheet->setCellValue('A3', 'Tổng số tiền');

		$this->setStyle_dataT10('A1');
		$this->setStyle_dataT10('B1');
		$this->setStyle_dataT10('C1');
		$this->setStyle_dataT10('D1');
		$this->setStyle_dataT10('A2');
		$this->setStyle_dataT10('A3');


		//
		$this->sheet->setCellValue('B2', !empty($data->bad_debt_count) ? $data->bad_debt_count : 0)
			->getStyle('B' . 2)
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		$this->sheet->setCellValue('C2', !empty($data->count) ? $data->count : 0)
			->getStyle('C' . 2)
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		$this->sheet->setCellValue('D2', !empty($data->ratio_count) ? $data->ratio_count . '%' : 0);

		$this->sheet->setCellValue('B3', !empty($data->bad_debt) ? $data->bad_debt : 0)
			->getStyle('B' . 3)
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		$this->sheet->setCellValue('C3', !empty($data->debt) ? $data->debt : 0)
			->getStyle('C' . 3)
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		$this->sheet->setCellValue('D3', !empty($data->ratio_debt) ? $data->ratio_debt . '%' : 0);

		$this->callLibExcel('KV_no_xau_qua_han_3_ky_dau_' . date('d-m-Y') . '.xlsx');
	}

	public function report_debt_month()
	{

		$dataReport = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/report_debt_month");
		if (!empty($dataReport->data)) {
			$this->report_debt_month_data($dataReport->data);

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	public function report_debt_month_data($data)
	{

		$this->sheet->setCellValue('A1', 'Tiêu chí');
		$this->sheet->setCellValue('B1', '2019');
		$this->sheet->setCellValue('B2', 'Đã giải ngân');
		$this->sheet->setCellValue('C2', 'Đang vay');
		$this->sheet->setCellValue('D2', 'HĐ quá hạn');
		$this->sheet->setCellValue('E2', 'Tỉ lệ HĐ quá hạn / đã giải ngân');
		$this->sheet->setCellValue('F2', 'Tỉ lệ HĐ quá hạn / đang vay');
		$this->sheet->setCellValue('G1', '2020');
		$this->sheet->setCellValue('G2', 'Đã giải ngân');
		$this->sheet->setCellValue('H2', 'Đang vay');
		$this->sheet->setCellValue('I2', 'HĐ quá hạn');
		$this->sheet->setCellValue('J2', 'Tỉ lệ HĐ quá hạn / đã giải ngân');
		$this->sheet->setCellValue('K2', 'Tỉ lệ HĐ quá hạn / đang vay');
		$this->sheet->setCellValue('L1', '2021');
		$this->sheet->setCellValue('L2', 'Đã giải ngân');
		$this->sheet->setCellValue('M2', 'Đang vay');
		$this->sheet->setCellValue('N2', 'HĐ quá hạn');
		$this->sheet->setCellValue('O2', 'Tỉ lệ HĐ quá hạn / đã giải ngân');
		$this->sheet->setCellValue('P2', 'Tỉ lệ HĐ quá hạn / đang vay');
		$this->sheet->setCellValue('Q1', '2022');
		$this->sheet->setCellValue('Q2', 'Đã giải ngân');
		$this->sheet->setCellValue('R2', 'Đang vay');
		$this->sheet->setCellValue('S2', 'HĐ quá hạn');
		$this->sheet->setCellValue('T2', 'Tỉ lệ HĐ quá hạn / đã giải ngân');
		$this->sheet->setCellValue('U2', 'Tỉ lệ HĐ quá hạn / đang vay');

		$this->setStyle_dataT10('A1');
		$this->setStyle_dataT10('B1');
		$this->setStyle_dataT10('G1');
		$this->setStyle_dataT10('L1');
		$this->setStyle_dataT10('Q1');
		$this->setStyle_dataT10('A3');
		$this->setStyle_dataT10('A4');

		$this->sheet->setCellValue('A3', 'Số lượng HĐ');
		$this->sheet->setCellValue('A4', 'Gốc còn lại');

		$this->sheet->mergeCells("A1:A2");
		$this->sheet->mergeCells("B1:F1");
		$this->sheet->mergeCells("G1:K1");
		$this->sheet->mergeCells("L1:P1");
		$this->sheet->mergeCells("Q1:U1");

		//
		$this->sheet->setCellValue('B3', !empty($data->count_dagiaingan_2019) ? number_format($data->count_dagiaingan_2019) : 0);
		$this->sheet->setCellValue('C3', !empty($data->count_dangvay_2019) ? number_format($data->count_dangvay_2019) : 0);
		$this->sheet->setCellValue('D3', !empty($data->count_noxau_2019) ? number_format($data->count_noxau_2019) : 0);
		$this->sheet->setCellValue('E3', !empty($data->count_tile_giaingan_2019) ? number_format($data->count_tile_giaingan_2019) . '%' : 0);
		$this->sheet->setCellValue('F3', !empty($data->count_tile_dangvay_2019) ? number_format($data->count_tile_dangvay_2019) . '%' : 0);
		$this->sheet->setCellValue('G3', !empty($data->count_dagiaingan_2020) ? number_format($data->count_dagiaingan_2020) : 0);
		$this->sheet->setCellValue('H3', !empty($data->count_dangvay_2020) ? number_format($data->count_dangvay_2020) : 0);
		$this->sheet->setCellValue('I3', !empty($data->count_noxau_2020) ? number_format($data->count_noxau_2020) : 0);
		$this->sheet->setCellValue('J3', !empty($data->count_tile_giaingan_2020) ? number_format($data->count_tile_giaingan_2020) . '%' : 0);
		$this->sheet->setCellValue('K3', !empty($data->count_tile_dangvay_2020) ? number_format($data->count_tile_dangvay_2020) . '%' : 0);
		$this->sheet->setCellValue('L3', !empty($data->count_dagiaingan_2021) ? number_format($data->count_dagiaingan_2021) : 0);
		$this->sheet->setCellValue('M3', !empty($data->count_dangvay_2021) ? number_format($data->count_dangvay_2021) : 0);
		$this->sheet->setCellValue('N3', !empty($data->count_noxau_2021) ? number_format($data->count_noxau_2021) : 0);
		$this->sheet->setCellValue('O3', !empty($data->count_tile_giaingan_2021) ? number_format($data->count_tile_giaingan_2021) . '%' : 0);
		$this->sheet->setCellValue('P3', !empty($data->count_tile_dangvay_2021) ? number_format($data->count_tile_dangvay_2021) . '%' : 0);
		$this->sheet->setCellValue('Q3', !empty($data->count_dagiaingan_2022) ? number_format($data->count_dagiaingan_2022) : 0);
		$this->sheet->setCellValue('R3', !empty($data->count_dangvay_2022) ? number_format($data->count_dangvay_2022) : 0);
		$this->sheet->setCellValue('S3', !empty($data->count_noxau_2022) ? number_format($data->count_noxau_2022) : 0);
		$this->sheet->setCellValue('T3', !empty($data->count_tile_giaingan_2022) ? number_format($data->count_tile_giaingan_2022) . '%' : 0);
		$this->sheet->setCellValue('U3', !empty($data->count_tile_dangvay_2022) ? number_format($data->count_tile_dangvay_2022) . '%' : 0);

		//
		$this->sheet->setCellValue('B4', !empty($data->debt_dagiaingan_2019) ? number_format($data->debt_dagiaingan_2019) : 0);
		$this->sheet->setCellValue('C4', !empty($data->debt_dangvay_2019) ? number_format($data->debt_dangvay_2019) : 0);
		$this->sheet->setCellValue('D4', !empty($data->debt_noxau_2019) ? number_format($data->debt_noxau_2019) : 0);
		$this->sheet->setCellValue('E4', !empty($data->debt_tile_giaingan_2019) ? number_format($data->debt_tile_giaingan_2019) . '%' : 0);
		$this->sheet->setCellValue('F4', !empty($data->debt_tile_dangvay_2019) ? number_format($data->debt_tile_dangvay_2019) . '%' : 0);
		$this->sheet->setCellValue('G4', !empty($data->debt_dagiaingan_2020) ? number_format($data->debt_dagiaingan_2020) : 0);
		$this->sheet->setCellValue('H4', !empty($data->debt_dangvay_2020) ? number_format($data->debt_dangvay_2020) : 0);
		$this->sheet->setCellValue('I4', !empty($data->debt_noxau_2020) ? number_format($data->debt_noxau_2020) : 0);
		$this->sheet->setCellValue('J4', !empty($data->debt_tile_giaingan_2020) ? number_format($data->debt_tile_giaingan_2020) . '%' : 0);
		$this->sheet->setCellValue('K4', !empty($data->debt_tile_dangvay_2020) ? number_format($data->debt_tile_dangvay_2020) . '%' : 0);
		$this->sheet->setCellValue('L4', !empty($data->debt_dagiaingan_2021) ? number_format($data->debt_dagiaingan_2021) : 0);
		$this->sheet->setCellValue('M4', !empty($data->debt_dangvay_2021) ? number_format($data->debt_dangvay_2021) : 0);
		$this->sheet->setCellValue('N4', !empty($data->debt_noxau_2021) ? number_format($data->debt_noxau_2021) : 0);
		$this->sheet->setCellValue('O4', !empty($data->debt_tile_giaingan_2021) ? number_format($data->debt_tile_giaingan_2021) . '%' : 0);
		$this->sheet->setCellValue('P4', !empty($data->debt_tile_dangvay_2021) ? number_format($data->debt_tile_dangvay_2021) . '%' : 0);
		$this->sheet->setCellValue('Q4', !empty($data->debt_dagiaingan_2022) ? number_format($data->debt_dagiaingan_2022) : 0);
		$this->sheet->setCellValue('R4', !empty($data->debt_dangvay_2022) ? number_format($data->debt_dangvay_2022) : 0);
		$this->sheet->setCellValue('S4', !empty($data->debt_noxau_2022) ? number_format($data->debt_noxau_2022) : 0);
		$this->sheet->setCellValue('T4', !empty($data->debt_tile_giaingan_2022) ? ($data->debt_tile_giaingan_2022) . '%' : 0);
		$this->sheet->setCellValue('U4', !empty($data->debt_tile_dangvay_2022) ? ($data->debt_tile_dangvay_2022) . '%' : 0);


		$this->callLibExcel('Thong_ke_no_xau_theo_nam' . date('d-m-Y') . '.xlsx');
	}

	public function report_debt_district()
	{

		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$data = array();
		if (!empty($fdate)) $data['fdate'] = $fdate;
		if (!empty($tdate)) $data['tdate'] = $tdate;

		$dataReport = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/report_debt_district", $data);
		if (!empty($dataReport->data)) {
			$this->report_debt_district_data($dataReport->data, $dataReport->count_hd_no_xau);

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}

	}

	public function report_debt_district_data($data, $count_hd_no_xau)
	{

		$this->sheet->setCellValue('A1', 'Khu vực');
		$this->sheet->setCellValue('B1', 'Số lượng HĐ quá hạn');
		$this->sheet->setCellValue('D1', 'Tổng gốc còn lại');
		$this->sheet->setCellValue('B2', 'Thống kê');
		$this->sheet->setCellValue('C2', 'Thống kê/ Tổng số lượng hợp đồng các tỉnh (%)');
		$this->sheet->setCellValue('D2', 'Tổng tiền tất toán');
		$this->sheet->setCellValue('E2', 'Tỉ lệ HĐ quá hạn/tất toán');
		$this->sheet->setCellValue('F2', 'Tiền gốc đang cho vay');
		$this->sheet->setCellValue('G2', 'Tổng gốc còn lại xấu');
		$this->sheet->setCellValue('H2', 'Nợ xấu / Đang cho vay (tỉnh)');

		$this->sheet->mergeCells("A1:A2");
		$this->sheet->mergeCells("B1:C1");
		$this->sheet->mergeCells("D1:H1");

		$this->setStyle_dataT10('A1');
		$this->setStyle_dataT10('B1');
		$this->setStyle_dataT10('D1');

		$i = 3;

		foreach ($data as $value) {

			$this->sheet->setCellValue('A' . $i, $value->name);
			$this->sheet->setCellValue('B' . $i, !empty($value->count_hd_no_xau) ? $value->count_hd_no_xau : 0);
			$this->sheet->setCellValue('C' . $i, !empty($count_hd_no_xau) && $count_hd_no_xau != 0 ? number_format(($value->count_hd_no_xau / $count_hd_no_xau) * 100, 2) . '%' : "0%");
			$this->sheet->setCellValue('D' . $i, !empty($value->total_tattoan) ? number_format($value->total_tattoan) : 0);
			$this->sheet->setCellValue('E' . $i, !empty($value->debt_hd_no_xau) && $value->debt_hd_no_xau != 0 ? number_format(($value->debt_hd_no_xau / $value->total_tattoan), 2) : '0');
			$this->sheet->setCellValue('F' . $i, !empty($value->debt_hd_dang_cho_vay) ? number_format($value->debt_hd_dang_cho_vay) : 0);
			$this->sheet->setCellValue('G' . $i, !empty($value->debt_hd_no_xau) ? number_format($value->debt_hd_no_xau) : 0);
			$this->sheet->setCellValue('H' . $i, !empty($value->debt_hd_dang_cho_vay) && $value->debt_hd_dang_cho_vay != 0 ? number_format((($value->debt_hd_no_xau / $value->debt_hd_dang_cho_vay) * 100), 2) . '%' : "0%");
			$i++;
		}

		$this->callLibExcel('No_xau_cac_tinh_' . date('d-m-Y') . '.xlsx');

	}

	public function report_debt_pgd()
	{

		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$data = array();
		if (!empty($fdate)) $data['fdate'] = $fdate;
		if (!empty($tdate)) $data['tdate'] = $tdate;

		$dataReport = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/report_debt_pgd", $data);
		if (!empty($dataReport->data)) {
			$this->report_debt_pgd_data($dataReport->data, $dataReport->count_hd_no_xau);

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}

	}

	public function report_debt_pgd_data($data, $count_hd_no_xau)
	{

		$this->sheet->setCellValue('A1', 'Kênh GN');
		$this->sheet->setCellValue('B1', 'Số lượng HĐ nợ xấu');
		$this->sheet->setCellValue('D1', 'Tổng dư nợ');
		$this->sheet->setCellValue('B2', 'Thống kê');
		$this->sheet->setCellValue('C2', 'Thống kê/ Tổng số lượng hợp đồng các PGD (%)');
		$this->sheet->setCellValue('D2', 'Tổng tiền tất toán');
		$this->sheet->setCellValue('E2', 'Tỉ lệ nợ xấu/tất toán');
		$this->sheet->setCellValue('F2', 'Dư nợ đang cho vay');
		$this->sheet->setCellValue('G2', 'Tổng dư nợ xấu');
		$this->sheet->setCellValue('H2', 'Nợ xấu / Đang cho vay (PGD)');

		$this->sheet->mergeCells("A1:A2");
		$this->sheet->mergeCells("B1:C1");
		$this->sheet->mergeCells("D1:H1");

		$this->setStyle_dataT10('A1');
		$this->setStyle_dataT10('B1');
		$this->setStyle_dataT10('D1');

		$i = 3;

		foreach ($data as $value) {

			$this->sheet->setCellValue('A' . $i, $value->name);
			$this->sheet->setCellValue('B' . $i, !empty($value->count_hd_no_xau) ? $value->count_hd_no_xau : 0);
			$this->sheet->setCellValue('C' . $i, !empty($count_hd_no_xau) && $count_hd_no_xau != 0 ? number_format(($value->count_hd_no_xau / $count_hd_no_xau) * 100, 2) . '%' : "0%");
			$this->sheet->setCellValue('D' . $i, !empty($value->total_tattoan) ? number_format($value->total_tattoan) : 0);
			$this->sheet->setCellValue('E' . $i, !empty($value->debt_hd_no_xau) && $value->debt_hd_no_xau != 0 ? number_format(($value->debt_hd_no_xau / $value->total_tattoan), 2) : '0');
			$this->sheet->setCellValue('F' . $i, !empty($value->debt_hd_dang_cho_vay) ? number_format($value->debt_hd_dang_cho_vay) : 0);
			$this->sheet->setCellValue('G' . $i, !empty($value->debt_hd_no_xau) ? number_format($value->debt_hd_no_xau) : 0);
			$this->sheet->setCellValue('H' . $i, !empty($value->debt_hd_dang_cho_vay) && $value->debt_hd_dang_cho_vay != 0 ? number_format((($value->debt_hd_no_xau / $value->debt_hd_dang_cho_vay) * 100), 2) . '%' : "0%");
			$i++;
		}

		$this->callLibExcel('No_xau_cac_pgd_' . date('d-m-Y') . '.xlsx');


	}

	public function report_debt_detail()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$data = array();
		if (!empty($fdate)) $data['fdate'] = $fdate;
		if (!empty($tdate)) $data['tdate'] = $tdate;

		$dataReport = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/report_debt_detail", $data);

		if (!empty($dataReport->data)) {
			$this->report_debt_detail_data($dataReport->data);

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	public function report_debt_detail_data($data)
	{

		$this->sheet->setCellValue('A1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('B1', 'Mã hợp đồng');
		$this->sheet->setCellValue('C1', 'Tên khách hàng');
		$this->sheet->setCellValue('D1', 'Số tiền giải ngân');
		$this->sheet->setCellValue('E1', 'Hình thức vay');
		$this->sheet->setCellValue('F1', 'Sản phẩm vay');
		$this->sheet->setCellValue('G1', 'Kỳ hạn vay');
		$this->sheet->setCellValue('H1', 'Tiền kỳ');
		$this->sheet->setCellValue('I1', 'Ngày trễ');
		$this->sheet->setCellValue('J1', 'Bucket');
		$this->sheet->setCellValue('K1', 'Số kỳ đã thanh toán');
		$this->sheet->setCellValue('L1', 'Dư nợ gốc còn lại');
		$this->sheet->setCellValue('M1', 'PGD');
		$this->sheet->setCellValue('N1', 'CMT/CCCD/Hộ chiếu');
		$this->sheet->setCellValue('O1', 'Số điện thoại');
		$this->sheet->setCellValue('P1', 'Tỉnh hộ khẩu');
		$this->sheet->setCellValue('Q1', 'Quận/Huyện Hộ Khẩu');
		$this->sheet->setCellValue('R1', 'Xã/Phường Hộ Khẩu');
		$this->sheet->setCellValue('S1', 'Địa chỉ hộ khẩu');
		$this->sheet->setCellValue('T1', 'Địa chỉ tạm trú');
		$this->sheet->setCellValue('U1', 'Địa chỉ nơi làm việc');
		$this->sheet->setCellValue('V1', 'KT1');
		$this->sheet->setCellValue('W1', 'Ngày giải ngân');

		$this->setStyle_dataT10('A1');
		$this->setStyle_dataT10('B1');
		$this->setStyle_dataT10('C1');
		$this->setStyle_dataT10('D1');
		$this->setStyle_dataT10('E1');
		$this->setStyle_dataT10('F1');
		$this->setStyle_dataT10('G1');
		$this->setStyle_dataT10('H1');
		$this->setStyle_dataT10('I1');
		$this->setStyle_dataT10('J1');
		$this->setStyle_dataT10('K1');
		$this->setStyle_dataT10('L1');
		$this->setStyle_dataT10('M1');
		$this->setStyle_dataT10('N1');
		$this->setStyle_dataT10('O1');
		$this->setStyle_dataT10('P1');
		$this->setStyle_dataT10('Q1');
		$this->setStyle_dataT10('R1');
		$this->setStyle_dataT10('S1');
		$this->setStyle_dataT10('T1');
		$this->setStyle_dataT10('U1');
		$this->setStyle_dataT10('V1');
		$this->setStyle_dataT10('W1');


		$i = 2;

		foreach ($data as $value) {

			$type_interest = "";
			if (!empty($value->loan_infor->type_interest)) {
				if ($value->loan_infor->type_interest == 1) {
					$type_interest = "Dư nợ giảm dần";
				} else {
					$type_interest = "Lãi hàng tháng, gốc cuối kỳ";
				}
			}

			$current_address = $value->current_address->current_stay . '/ ' . $value->current_address->ward_name . '/ ' . $value->current_address->district_name . '/ ' . $value->current_address->province_name;


			$this->sheet->setCellValue('A' . $i, !empty($value->code_contract) ? $value->code_contract : '');
			$this->sheet->setCellValue('B' . $i, !empty($value->code_contract_disbursement) ? $value->code_contract_disbursement : '');
			$this->sheet->setCellValue('C' . $i, !empty($value->customer_infor->customer_name) ? $value->customer_infor->customer_name : '');
			$this->sheet->setCellValue('D' . $i, !empty($value->loan_infor->amount_money) ? $value->loan_infor->amount_money : 0);
			$this->sheet->setCellValue('E' . $i, !empty($type_interest) ? $type_interest : "");
			$this->sheet->setCellValue('F' . $i, !empty($value->loan_infor->type_property->text) ? $value->loan_infor->type_property->text : "");
			$this->sheet->setCellValue('G' . $i, !empty($value->loan_infor->number_day_loan) ? $value->loan_infor->number_day_loan / 30 : 0);
			$this->sheet->setCellValue('H' . $i, !empty($value->tien_1_ky_phai_tra) ? $value->tien_1_ky_phai_tra : 0);
			$this->sheet->setCellValue('I' . $i, !empty($value->debt->so_ngay_cham_tra) ? $value->debt->so_ngay_cham_tra : 0);
			$this->sheet->setCellValue('J' . $i, !empty($value->debt->so_ngay_cham_tra) && $value->debt->so_ngay_cham_tra != 0 ? get_bucket($value->debt->so_ngay_cham_tra) : "B0");
			$this->sheet->setCellValue('K' . $i, !empty($value->so_ky_da_thanh_toan) ? $value->so_ky_da_thanh_toan : 0);
			$this->sheet->setCellValue('L' . $i, !empty($value->debt->tong_tien_goc_con) ? $value->debt->tong_tien_goc_con : 0);
			$this->sheet->setCellValue('M' . $i, !empty($value->store->name) ? $value->store->name : "");
			$this->sheet->setCellValue('N' . $i, !empty($value->customer_infor->customer_identify) ? $value->customer_infor->customer_identify : "");
			$this->sheet->setCellValue('O' . $i, !empty($value->customer_infor->customer_phone_number) ? $value->customer_infor->customer_phone_number : "");
			$this->sheet->setCellValue('P' . $i, !empty($value->houseHold_address->province_name) ? $value->houseHold_address->province_name : "");
			$this->sheet->setCellValue('Q' . $i, !empty($value->houseHold_address->district_name) ? $value->houseHold_address->district_name : "");
			$this->sheet->setCellValue('R' . $i, !empty($value->houseHold_address->ward_name) ? $value->houseHold_address->ward_name : "");
			$this->sheet->setCellValue('S' . $i, !empty($value->houseHold_address->address_household) ? $value->houseHold_address->address_household : "");
			$this->sheet->setCellValue('T' . $i, !empty($current_address) ? $current_address : "");
			$this->sheet->setCellValue('U' . $i, !empty($value->job_infor->address_company) ? $value->job_infor->address_company : "");
			$this->sheet->setCellValue('V' . $i, !empty($value->current_address->form_residence) ? $value->current_address->form_residence : "");
			$this->sheet->setCellValue('W' . $i, !empty($value->disbursement_date) ? date('d/m/Y', $value->disbursement_date) : "");


			$i++;
		}

		$this->callLibExcel('Export_chi_tiet_' . date('d-m-Y') . '.xlsx');

	}

	public function exportDetailCallAndFieldResultTHN()
	{

		$this->spreadsheet->createSheet();
		$this->sheet1 = $this->spreadsheet->setActiveSheetIndex(1);
		$month = !empty($_GET['month']) ? $_GET['month'] : '';
		$year = !empty($_GET['year']) ? $_GET['year'] : '';
		$dataPost['month'] = $month;
		$dataPost['year'] = $year;
		$border_style = [
			'borders' =>
				[
					'left' =>
						[
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
							'color' => ['rgb' => '000000']
						],
					'right' =>
						[
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
							'color' => ['rgb' => '000000']
						],
					'bottom' =>
						[
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
							'color' => ['rgb' => '000000']
						],
					'top' =>
						[
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
							'color' => ['rgb' => '000000']
						]
				],
		];
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Ngày giao thu hồi');
		$this->sheet->setCellValue('C1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('D1', 'Mã hợp đồng');
		$this->sheet->setCellValue('E1', 'Ngày giải ngân');
		$this->sheet->setCellValue('F1', 'Tên khách hàng');
		$this->sheet->setCellValue('G1', 'Số tiền giải ngân');
		$this->sheet->setCellValue('H1', 'Sản phẩm vay');
		$this->sheet->setCellValue('I1', 'Kì hạn vay');
		$this->sheet->setCellValue('J1', 'Tiền kỳ');
		$this->sheet->setCellValue('K1', 'Ngày trễ');
		$this->sheet->setCellValue('L1', 'Bucket');
		$this->sheet->setCellValue('M1', 'Ngày đến hạn thanh toán');
		$this->sheet->setCellValue('N1', 'Dư nợ gốc còn lại');
		$this->sheet->setCellValue('O1', 'PGD');
		$this->sheet->setCellValue('P1', 'Tỉnh hộ khẩu');
		$this->sheet->setCellValue('Q1', 'Quận/huyện theo hộ khẩu');
		$this->sheet->setCellValue('R1', 'Địa chỉ tạm trú');
		$this->sheet->setCellValue('S1', 'Địa chỉ nơi làm việc');
		$this->sheet->setCellValue('T1', 'ĐỐI TƯỢNG TÁC ĐỘNG')->getStyle('T' . 1)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffff00')->applyFromArray($border_style);
		$this->sheet->setCellValue('U1', 'NGÀY THỰC HIỆN TÁC ĐỘNG')->getStyle('U' . 1)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffff00')->applyFromArray($border_style);
		$this->sheet->setCellValue('V1', 'NỘI DUNG CHI TIẾT LÀM VIỆC')->getStyle('V' . 1)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('93d050')->applyFromArray($border_style);
		$this->sheet->setCellValue('W1', 'TỔNG SỐ KỲ ĐÃ THANH TOÁN ĐẾN HIỆN TẠI')->getStyle('W' . 1)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffff00')->applyFromArray($border_style);
		$this->sheet->setCellValue('X1', 'SỐ TIỀN THU ĐƯỢC TRONG THÁNG')->getStyle('X' . 1)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffff00')->applyFromArray($border_style);
		$this->sheet->setCellValue('Y1', 'KẾT QUẢ TÁC ĐỘNG')->getStyle('Y' . 1)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffff00')->applyFromArray($border_style);
		$this->sheet->setCellValue('Z1', 'SỐ LẦN ĐÃ TÁC ĐỘNG KHÁCH HÀNG NÀY/THÁNG')->getStyle('Z' . 1)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffff00')->applyFromArray($border_style);
		$this->sheet->setCellValue('AA1', 'NHÂN VIÊN THN PHỤ TRÁCH')->getStyle('AA' . 1)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('93d050')->applyFromArray($border_style);

		$i = 2;

		$data = $this->api->apiPost($this->userInfo['token'], "debtCall/getContractCallDetailTHN", $dataPost);
		foreach ($data->data as $key => $item) {

			$this->sheet->setCellValue('A' . $i, ++$key);
			$this->sheet->setCellValue('B' . $i, date('d/m/Y', $item->created_at));
			$this->sheet->setCellValue('C' . $i, !empty($item->code_contract) ? $item->code_contract : '');
			$this->sheet->setCellValue('D' . $i, !empty($item->code_contract_disbursement) ? $item->code_contract_disbursement : '');
			$this->sheet->setCellValue('E' . $i, date('d/m/Y', $item->contractDetail->disbursement_date));
			$this->sheet->setCellValue('F' . $i, !empty($item->customer_name) ? $item->customer_name : '');
			$this->sheet->setCellValue('G' . $i, !empty($item->contractDetail->loan_infor->amount_money) ? number_format($item->contractDetail->loan_infor->amount_money) : '');
			$this->sheet->setCellValue('H' . $i, !empty($item->contractDetail->loan_infor->type_property->text) ? $item->contractDetail->loan_infor->type_property->text : '');
			$this->sheet->setCellValue('I' . $i, ($item->number_day_loan / 30) . ' tháng');
			$this->sheet->setCellValue('J' . $i, !empty($item->tien_ky) ? number_format(round($item->tien_ky)) : '');
			$this->sheet->setCellValue('K' . $i, !empty($item->so_ngay_cham_tra) ? $item->so_ngay_cham_tra : '');
			$this->sheet->setCellValue('L' . $i, !empty($item->bucket) ? $item->bucket : '');
			$this->sheet->setCellValue('M' . $i, !empty($item->ngay_den_han_thanh_toan) ? date('d/m/Y', $item->ngay_den_han_thanh_toan) : '');
			$this->sheet->setCellValue('N' . $i, !empty($item->contractDetail->original_debt->du_no_goc_con_lai) ? number_format($item->contractDetail->original_debt->du_no_goc_con_lai) : '0');
			$this->sheet->setCellValue('O' . $i, !empty($item->store_name) ? $item->store_name : '');
			$this->sheet->setCellValue('P' . $i, !empty($item->contractDetail->houseHold_address->province_name) ? $item->contractDetail->houseHold_address->province_name : '');
			$this->sheet->setCellValue('Q' . $i, !empty($item->contractDetail->houseHold_address->district_name) ? $item->contractDetail->houseHold_address->district_name : '');
			$this->sheet->setCellValue('R' . $i, !empty($item->contractDetail->current_address->current_stay) ? $item->contractDetail->current_address->current_stay : '');
			$this->sheet->setCellValue('S' . $i, !empty($item->contractDetail->job_infor->address_company) ? $item->contractDetail->job_infor->address_company : '');
			$this->sheet->setCellValue('T' . $i, !empty($item->relativeDetail) ? $item->relativeDetail : '');
			$this->sheet->setCellValue('U' . $i, !empty($item->reminderDate) ? implode(', ', $item->reminderDate) : '');
			$this->sheet->setCellValue('V' . $i, !empty($item->reminderDetail) ? implode(', ', $item->reminderDetail) : '');  //nội dung
			$this->sheet->setCellValue('W' . $i, !empty($item->so_ky_da_thanh_toan) ? $item->so_ky_da_thanh_toan : '');
			$this->sheet->setCellValue('X' . $i, !empty($item->tien_thu_trong_thang) ? number_format($item->tien_thu_trong_thang) : '');
			$this->sheet->setCellValue('Y' . $i, !empty($item->reminderResult) ? $item->reminderResult : '');
			$this->sheet->setCellValue('Z' . $i, !empty($item->reminderDetail) ? count($item->reminderDetail) : 0);
			$this->sheet->setCellValue('AA' . $i, !empty($item->debt_caller_email) ? $item->debt_caller_email : '');

			$i++;
		}
		$this->sheet->setTitle('CALL' . ' ' . $month . '-' . $year);


		$this->sheet1->setCellValue('A1', 'STT');
		$this->sheet1->setCellValue('B1', 'Ngày giao thu hồi');
		$this->sheet1->setCellValue('C1', 'Mã phiếu ghi');
		$this->sheet1->setCellValue('D1', 'Mã hợp đồng');
		$this->sheet1->setCellValue('E1', 'Ngày giải ngân');
		$this->sheet1->setCellValue('F1', 'Tên khách hàng');
		$this->sheet1->setCellValue('G1', 'Số tiền giải ngân');
		$this->sheet1->setCellValue('H1', 'Sản phẩm vay');
		$this->sheet1->setCellValue('I1', 'Kì hạn vay');
		$this->sheet1->setCellValue('J1', 'Tiền kỳ');
		$this->sheet1->setCellValue('K1', 'Ngày trễ');
		$this->sheet1->setCellValue('L1', 'Bucket');
		$this->sheet1->setCellValue('M1', 'Ngày đến hạn thanh toán');
		$this->sheet1->setCellValue('N1', 'Dư nợ gốc còn lại');
		$this->sheet1->setCellValue('O1', 'PGD');
		$this->sheet1->setCellValue('P1', 'Tỉnh hộ khẩu');
		$this->sheet1->setCellValue('Q1', 'Quận/huyện theo hộ khẩu');
		$this->sheet1->setCellValue('R1', 'Địa chỉ tạm trú');
		$this->sheet1->setCellValue('S1', 'Địa chỉ nơi làm việc');
		$this->sheet1->setCellValue('T1', 'ĐỐI TƯỢNG TÁC ĐỘNG')->getStyle('T' . 1)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffff00')->applyFromArray($border_style);;
		$this->sheet1->setCellValue('U1', 'NGÀY THỰC HIỆN TÁC ĐỘNG')->getStyle('U' . 1)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffff00')->applyFromArray($border_style);;
		$this->sheet1->setCellValue('V1', 'NỘI DUNG CHI TIẾT LÀM VIỆC')->getStyle('V' . 1)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('93d050')->applyFromArray($border_style);;
		$this->sheet1->setCellValue('W1', 'TỔNG SỐ KỲ ĐÃ THANH TOÁN ĐẾN HIỆN TẠI')->getStyle('W' . 1)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffff00')->applyFromArray($border_style);;
		$this->sheet1->setCellValue('X1', 'SỐ TIỀN THU ĐƯỢC TRONG THÁNG')->getStyle('X' . 1)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffff00')->applyFromArray($border_style);;
		$this->sheet1->setCellValue('Y1', 'KẾT QUẢ TÁC ĐỘNG')->getStyle('Y' . 1)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffff00')->applyFromArray($border_style);;
		$this->sheet1->setCellValue('Z1', 'SỐ LẦN ĐÃ TÁC ĐỘNG KHÁCH HÀNG NÀY/THÁNG')->getStyle('Z' . 1)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffff00')->applyFromArray($border_style);;
		$this->sheet1->setCellValue('AA1', 'NHÂN VIÊN THN PHỤ TRÁCH')->getStyle('AA' . 1)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('93d050')->applyFromArray($border_style);;

		$k = 2;

		$data1 = $this->api->apiPost($this->userInfo['token'], "debtCall/getContractFieldDetailTHN", $dataPost);
		foreach ($data1->data as $key => $item1) {
			$this->sheet1->setCellValue('A' . $k, ++$key);
			$this->sheet1->setCellValue('B' . $k, date('d/m/Y', $item1->created_at));
			$this->sheet1->setCellValue('C' . $k, !empty($item1->code_contract) ? $item1->code_contract : '');
			$this->sheet1->setCellValue('D' . $k, !empty($item1->code_contract_disbursement) ? $item1->code_contract_disbursement : '');
			$this->sheet1->setCellValue('E' . $k, date('d/m/Y', $item1->contractDetail->disbursement_date));
			$this->sheet1->setCellValue('F' . $k, !empty($item1->customer_name) ? $item1->customer_name : '');
			$this->sheet1->setCellValue('G' . $k, !empty($item1->contractDetail->loan_infor->amount_money) ? number_format($item1->contractDetail->loan_infor->amount_money) : '');
			$this->sheet1->setCellValue('H' . $k, !empty($item1->contractDetail->loan_infor->type_property->text) ? $item1->contractDetail->loan_infor->type_property->text : '');
			$this->sheet1->setCellValue('I' . $k, ($item1->number_day_loan) / 30 . ' tháng');
			$this->sheet1->setCellValue('J' . $k, !empty($item1->tien_ky) ? number_format(round($item1->tien_ky)) : '');
			$this->sheet1->setCellValue('K' . $k, !empty($item1->time_due) ? $item1->time_due : '');
			$this->sheet1->setCellValue('L' . $k, !empty($item1->bucket) ? $item1->bucket : '');
			$this->sheet1->setCellValue('M' . $k, !empty($item1->ngay_den_han_thanh_toan) ? date('d/m/Y', $item1->ngay_den_han_thanh_toan) : '');
			$this->sheet1->setCellValue('N' . $k, !empty($item1->contractDetail->original_debt->du_no_goc_con_lai) ? number_format($item1->contractDetail->original_debt->du_no_goc_con_lai) : '0');
			$this->sheet1->setCellValue('O' . $k, !empty($item1->store_name) ? $item1->store_name : '');
			$this->sheet1->setCellValue('P' . $k, !empty($item1->contractDetail->houseHold_address->province_name) ? $item1->contractDetail->houseHold_address->province_name : '');
			$this->sheet1->setCellValue('Q' . $k, !empty($item1->contractDetail->houseHold_address->district_name) ? $item1->contractDetail->houseHold_address->district_name : '');
			$this->sheet1->setCellValue('R' . $k, !empty($item1->contractDetail->current_address->current_stay) ? $item1->contractDetail->current_address->current_stay : '');
			$this->sheet1->setCellValue('S' . $k, !empty($item1->contractDetail->job_infor->address_company) ? $item1->contractDetail->job_infor->address_company : '');
			$this->sheet1->setCellValue('T' . $k, !empty($item1->relativeDetail) ? $item1->relativeDetail : '');
			$this->sheet1->setCellValue('U' . $k, !empty($item1->fieldDate) ? implode(', ', $item1->fieldDate) : '');
			$this->sheet1->setCellValue('V' . $k, !empty($item1->fieldDetail) ? implode(', ', $item1->fieldDetail) : '');  //nội dung
			$this->sheet1->setCellValue('W' . $k, !empty($item1->so_ky_da_thanh_toan) ? $item1->so_ky_da_thanh_toan : '');
			$this->sheet1->setCellValue('X' . $k, !empty($item1->tien_thu_trong_thang) ? number_format($item1->tien_thu_trong_thang) : '');
			$this->sheet1->setCellValue('Y' . $k, !empty($item1->fieldResult) ? status_debt_recovery($item1->evaluate) : '');
			$this->sheet1->setCellValue('Z' . $k, !empty($item1->fieldDetail) ? count($item1->fieldDetail) : '0');
			$this->sheet1->setCellValue('AA' . $k, !empty($item1->debt_field_email) ? $item1->debt_field_email : '');
			$k++;
		}
		$this->sheet1->setTitle('FIELD' . ' ' . $month . '-' . $year);

		$this->callLibExcel('reportFieldAndCallDetailTHN' . date('d-m-Y') . '.xlsx');
	}

	public function exportReportGeneralTHN()
	{
		$dataPost = [];
		$month = !empty($_GET['month']) ? $_GET['month'] : '';
		$year = !empty($_GET['year']) ? $_GET['year'] : '';
		$dataPost['month'] = $month;
		$dataPost['year'] = $year;
		$this->sheet->mergeCells('A1:E1');

		$this->sheet->setCellValue('A1', 'BÁO CÁO KẾT QUẢ TÁC ĐỘNG THN - THÁNG ' . $month . '/' . $year);
		$this->sheet->setCellValue('A2', 'STT');
		$this->sheet->setCellValue('B2', 'NHÂN VIÊN PHỤ TRÁCH');
		$this->sheet->setCellValue('C2', 'TỔNG SỐ HỢP ĐỒNG ĐƯỢC GIAO TRONG THANG CHƯA TÁC ĐỘNG');
		$this->sheet->setCellValue('D2', 'TỔNG SỐ LẦN TÁC ĐỘNG KHÁCH HÀNG');
		$this->sheet->setCellValue('E2', 'TRƯỞNG NHÓM PHỤ TRÁCH');

		$this->setStyle('A1');
		$this->setStyle('A2');
		$this->setStyle('B2');
		$this->setStyle('C2');
		$this->setStyle('D2');
		$this->setStyle('E2');

		$i = 3;
		$data = $this->api->apiPost($this->userInfo['token'], "debtCall/getReportGeneralTHN", $dataPost);
		if (!empty($data->status) && $data->status == 200) {
			$result = (array)$data->data;
			$count = 1;
			foreach ($result as $key => $item) {
				foreach ($item as $l => $a) {
					if (empty($a->count) && empty($a->contact)) {
						continue;
					} else {
						$this->sheet->setCellValue('A' . $i, $count);
						$this->sheet->setCellValue('B' . $i, $l);
						$this->sheet->setCellValue('C' . $i, !empty($a->count) ? $a->count : '0');
						$this->sheet->setCellValue('D' . $i, !empty($a->contact) ? $a->contact : '0');
						$this->sheet->setCellValue('E' . $i, !empty($a->lead) ? $a->lead : '');
						$i++;
						$count++;
					}
				}
			}

			$this->sheet->setTitle('Báo cáo tổng hợp tháng ' . $month . '-' . $year);

			$this->callLibExcel('reportGeneralTHN' . date('d-m-Y') . '.xlsx');

		}

	}

	public function missed_call_excel()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$sdt = !empty($_GET['sdt']) ? $_GET['sdt'] : "";

		$data = array();
		if (!empty($fdate)) $data['start'] = strtotime($fdate);
		if (!empty($tdate)) $data['end'] = strtotime($tdate);
		if (!empty($sdt)) $data['sdt'] = $sdt;
		$dataReport = $this->api->apiPost($this->userInfo['token'], "recording/excel_missed_call", $data);
		if (!empty($dataReport->data)) {
			$this->missed_call_excel_data($dataReport->data);
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}

	}

	public function missed_call_excel_data($data)
	{
		$this->sheet->setCellValue('A1', 'NGÀY THÁNG')->getColumnDimension('A')->setAutoSize(true);
		$this->sheet->setCellValue('B1', 'Số điện thoại')->getColumnDimension('B')->setAutoSize(true);
		$this->sheet->setCellValue('C1', 'Họ Và Tên')->getColumnDimension('C')->setAutoSize(true);
		$this->sheet->setCellValue('D1', 'Địa Chỉ')->getColumnDimension('D')->setAutoSize(true);
		$this->sheet->setCellValue('E1', 'Ngày Tháng Năm Sinh')->getColumnDimension('E')->setAutoSize(true);
		$this->sheet->setCellValue('F1', 'Chứng Minh Thư')->getColumnDimension('F')->setAutoSize(true);
		$this->sheet->setCellValue('G1', 'Ý Kiến Phản Ánh')->getColumnDimension('G')->setAutoSize(true);

		$i = 2;

		foreach ($data as $value) {
			$this->sheet->setCellValue('A' . $i, date("d/m/Y H:i:s", $value->created_at));
			$this->sheet->setCellValue('B' . $i, !empty($value->fromNumber) ? $value->fromNumber : "");
			$this->sheet->setCellValue('C' . $i, !empty($value->name) ? $value->name : "");
			$this->sheet->setCellValue('D' . $i, !empty($value->address) ? $value->address : "");
			$this->sheet->setCellValue('E' . $i, !empty($value->date) ? $value->date : "");
			$this->sheet->setCellValue('F' . $i, !empty($value->cmt) ? $value->cmt : "");
			$this->sheet->setCellValue('G' . $i, !empty($value->noteMissedCall) ? $value->noteMissedCall : "");

			$i++;
		}

		$this->callLibExcel('Báo_cáo_cuộc_gọi_nhỡ_' . date('d-m-Y') . '.xlsx');


	}


	public function exportLeadVbee()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$fullname = !empty($_GET['fullname']) ? $_GET['fullname'] : "";
		$sdt = !empty($_GET['sdt']) ? $_GET['sdt'] : "";
		$cskh = !empty($_GET['cskh']) ? $_GET['cskh'] : "";
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "";
		$status_sale = !empty($_GET['status_sale_1']) ? $_GET['status_sale_1'] : "";
		$priority = !empty($_GET['priority']) ? $_GET['priority'] : "";
		$source = !empty($_GET['source_s']) ? $_GET['source_s'] : "";
		$data = [];

		if (strtotime($fdate) > strtotime($tdate) && !empty($tdate)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('lead_custom'));
		}
		if (!empty($fdate) && !empty($tdate)) {
			$data['start'] = strtotime($fdate);
			$data['end'] = strtotime($tdate);
		} elseif (!empty($fdate)) {
			$data['start'] = strtotime($fdate);
		} elseif (!empty($tdate)) {
			$data['end'] = strtotime($tdate);
		}

		if (!empty($fullname)) {
			$data['fullname'] = $fullname;
		}
		if (!empty($sdt)) {
			$data['sdt'] = $sdt;
		}
		if (!empty($cskh)) {
			$data['cskh'] = $cskh;
		}
		if (!empty($tab)) {
			$data['tab'] = $tab;
		}
		if (!empty($status_sale)) {
			$data['status_sale'] = $status_sale;
		}
		if (!empty($priority)) {
			$data['priority'] = $priority;
		}
		if (!empty($source)) {
			$data['source'] = $source;
		}
		$getLeadFbMkt = $this->api->apiPost($this->userInfo['token'], 'lead_custom/getExcelLeadVbee', $data);
		if (!empty($getLeadFbMkt->data)) {
			$this->exportExcelLeadVbee($getLeadFbMkt->data);

			var_dump($fdate . ' -- ' . $tdate);
		} else {
			var_dump("Không có dữ liệu để xuất excel");
		}
	}

	public function export_contract_liquidation()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$customer_phone_number = !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
		$data = array();
		if (!empty($fdate)) $data['start'] = ($fdate);
		if (!empty($tdate)) $data['end'] = ($tdate);
		if (!empty($status)) $data['status'] = $status;
		if (!empty($store)) $data['store'] = $store;
		if (!empty($code_contract)) $data['code_contract'] = $code_contract;
		if (!empty($code_contract_disbursement)) $data['code_contract_disbursement'] = $code_contract_disbursement;
		if (!empty($customer_name)) $data['customer_name'] = $customer_name;
		if (!empty($customer_phone_number)) $data['customer_phone_number'] = $customer_phone_number;
		$data['per_page'] = 10000;
		$contract_liquidation = $this->api->apiPost($this->userInfo['token'], "LiquidationAssetContract/contract_tempo_liquidations", $data);
		if (!empty($contract_liquidation->data)) {
			$this->contract_liquidation_data($contract_liquidation->data);
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	public function contract_liquidation_data($contract_liquidation)
	{
		$this->sheet->setCellValue('A1', 'Mã phiếu ghi')->getColumnDimension('A')->setAutoSize(true);
		$this->sheet->setCellValue('B1', 'Mã hợp đồng')->getColumnDimension('B')->setAutoSize(true);
		$this->sheet->setCellValue('C1', 'Họ Và Tên')->getColumnDimension('C')->setAutoSize(true);
		$this->sheet->setCellValue('D1', 'Số điện thoại')->getColumnDimension('D')->setAutoSize(true);
		$this->sheet->setCellValue('E1', 'Ngày tạo yêu cầu định giá')->getColumnDimension('E')->setAutoSize(true);
		$this->sheet->setCellValue('F1', 'Ngày bán tài sản thanh lý')->getColumnDimension('F')->setAutoSize(true);
		$this->sheet->setCellValue('G1', 'Số tiền định giá')->getColumnDimension('G')->setAutoSize(true);
		$this->sheet->setCellValue('H1', 'Số tiền TP.QLHDV gửi duyệt')->getColumnDimension('G')->setAutoSize(true);
		$this->sheet->setCellValue('I1', 'Số tiền CEO duyệt')->getColumnDimension('H')->setAutoSize(true);
		$this->sheet->setCellValue('J1', 'Số tiền thực bán')->getColumnDimension('I')->setAutoSize(true);
		$this->sheet->setCellValue('K1', 'Chi phí thanh lý')->getColumnDimension('I')->setAutoSize(true);
		$this->sheet->setCellValue('L1', 'Số tiền cần Tất toán (PT Tất toán)')->getColumnDimension('I')->setAutoSize(true);
		$this->sheet->setCellValue('M1', 'Số tiền miễn giảm')->getColumnDimension('I')->setAutoSize(true);
		$this->sheet->setCellValue('N1', 'Trạng thái')->getColumnDimension('J')->setAutoSize(true);
		$this->sheet->setCellValue('O1', 'Phòng giao dịch')->getColumnDimension('J')->setAutoSize(true);
		$i = 2;
		foreach ($contract_liquidation as $contract) {
			$this->sheet->setCellValue('A' . $i, !empty($contract->code_contract) ? $contract->code_contract : "");
			$this->sheet->setCellValue('B' . $i, !empty($contract->code_contract_disbursement) ? $contract->code_contract_disbursement : "");
			$this->sheet->setCellValue('C' . $i, !empty($contract->customer_infor->customer_name) ? $contract->customer_infor->customer_name : "");
			$this->sheet->setCellValue('D' . $i, !empty($contract->customer_infor->customer_phone_number) ? $contract->customer_infor->customer_phone_number : "");
			$this->sheet->setCellValue('E' . $i, !empty($contract->liquidation_info->created_at_request) ? date('d/m/Y', $contract->liquidation_info->created_at_request) : " - ");
			$this->sheet->setCellValue('F' . $i, !empty($contract->liquidation_info->created_at_liquidations) ? date('d/m/Y', $contract->liquidation_info->created_at_liquidations) : " - ");
			$this->sheet->setCellValue('G' . $i, !empty($contract->liquidation_info->bpdg->price_suggest_bpdg) ? $contract->liquidation_info->bpdg->price_suggest_bpdg : 0);
			$this->sheet->setCellValue('H' . $i, !empty($contract->liquidation_info->thn->price_suggest_thn_send_ceo) ? $contract->liquidation_info->thn->price_suggest_thn_send_ceo : 0);
			$this->sheet->setCellValue('I' . $i, !empty($contract->liquidation_info->thn->price_refer_ceo) ? $contract->liquidation_info->thn->price_refer_ceo : 0);
			$this->sheet->setCellValue('J' . $i, !empty($contract->liquidation_info->price_real_sold) ? $contract->liquidation_info->price_real_sold : 0);
			$this->sheet->setCellValue('K' . $i, !empty($contract->liquidation_info->fee_sold) ? $contract->liquidation_info->fee_sold : 0);
			$this->sheet->setCellValue('L' . $i, !empty($contract->tien_tat_toan_pt) ? round($contract->tien_tat_toan_pt) : 0);
			$this->sheet->setCellValue('M' . $i, !empty($contract->total_deductible) ? round($contract->total_deductible) : 0);
			$this->sheet->setCellValue('N' . $i, !empty($contract->status) ? contract_status($contract->status) : "");
			$this->sheet->setCellValue('O' . $i, !empty($contract->store->name) ? ($contract->store->name) : "");
			$i++;
		}
		$this->callLibExcel('ContractLiquidationData_' . date('d-m-Y') . '.xlsx');
	}

	public function export_excel_uid()
	{

		$id_file_name = !empty($_GET['id_file_name']) ? $_GET['id_file_name'] : "";

		$data = array();
		if (!empty($id_file_name)) $data['id_file_name'] = $id_file_name;

		$dataReport = $this->api->apiPost($this->userInfo['token'], "lead_custom/get_list_user_facebook", $data);
		if (!empty($dataReport->data)) {
			$this->export_excel_uid_data($dataReport->data);
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	public function export_excel_uid_data($data)
	{

		$this->sheet->setCellValue('A1', 'Họ và tên');
		$this->sheet->setCellValue('B1', 'UID Facebook');
		$this->sheet->setCellValue('C1', 'Số điện thoại');
		$this->sheet->setCellValue('D1', 'Thông tin trả về');
		$this->sheet->setCellValue('E1', 'Giới tính');
		$this->sheet->setCellValue('F1', 'Ngày sinh');
		$this->sheet->setCellValue('G1', 'Địa chỉ');
		$i = 2;

		foreach ($data as $value) {

			$this->sheet->setCellValue('A' . $i, !empty($value->fullname) ? $value->fullname : "");
			$this->sheet->setCellValue('B' . $i, !empty($value->uid_facebook) ? $value->uid_facebook : "");
			$this->sheet->setCellValue('C' . $i, !empty($value->phone) ? $value->phone : "");
			$this->sheet->setCellValue('D' . $i, !empty($value->code) ? $value->code : "");
			$this->sheet->setCellValue('E' . $i, !empty($value->gender) ? $value->gender : "");
			$this->sheet->setCellValue('F' . $i, !empty($value->birthday) ? $value->birthday : "");
			$this->sheet->setCellValue('G' . $i, !empty($value->location) ? $value->location : "");


			$i++;
		}


		$this->callLibExcel('Export_data_' . date('d-m-Y') . '.xlsx');
	}


	public function exportExcelLeadVbee($data)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'HỌ TÊN');
		$this->sheet->setCellValue('C1', 'SĐT');
		$this->sheet->setCellValue('D1', 'CSKH');
		$this->sheet->setCellValue('E1', 'NGUỒN');
		$this->sheet->setCellValue('F1', 'TRẠNG THÁI');
		$this->sheet->setCellValue('G1', 'ĐỘ ƯU TIÊN');


		$this->setStyle('A1');
		$this->setStyle('B1');
		$this->setStyle('C1');
		$this->setStyle('D1');
		$this->setStyle('E1');
		$this->setStyle('F1');
		$this->setStyle('G1');

		$i = 2;
		foreach ($data as $value) {
			# code...
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($value->fullname) ? $value->fullname : "");
			$this->sheet->setCellValue('C' . $i, !empty($value->phone_number) ? $value->phone_number : "");
			$this->sheet->setCellValue('D' . $i, !empty($value->cskh) ? $value->cskh : "");
			$this->sheet->setCellValue('E' . $i, !empty($value->source) ? lead_nguon($value->source) : "");
			$this->sheet->setCellValue('F' . $i, !empty($value->status_sale) ? lead_status($value->status_sale) : "");
			$this->sheet->setCellValue('G' . $i, !empty($value->priority) ? lead_priority($value->priority) : "");
			$i++;
		}
		$this->callLibExcel('Lead_nguồn_thô' . date('d-m-Y') . '.xlsx');

	}

	public function exportExcelReportTelesale()
	{

		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$store_search = !empty($_GET['store_search']) ? $_GET['store_search'] : "";
		$status_pgd = !empty($_GET['status_pgd']) ? $_GET['status_pgd'] : "";

		$data = array();
		if (!empty($fdate)) $data['start'] = $fdate;
		if (!empty($tdate)) $data['end'] = $tdate;
		if (!empty($store_search)) $data['store_search'] = $store_search;
		if (!empty($status_pgd)) $data['status_pgd'] = $status_pgd;

		$dataLead = $this->api->apiPost($this->userInfo['token'], "report_telesale/exportExcelReportTelesale", $data);

		if (!empty($dataLead->data)) {
			$this->exportExcelReportTelesale_data($dataLead->data);

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}

	}

	public function exportExcelReportTelesale_data($data)
	{

		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Thời gian lead về PGD');
		$this->sheet->setCellValue('C1', 'CVKD');
		$this->sheet->setCellValue('D1', 'Họ và tên KH');
		$this->sheet->setCellValue('E1', 'Số điện thoại');
		$this->sheet->setCellValue('F1', 'Chuyển đến PGD');
		$this->sheet->setCellValue('G1', 'Thời gian lần đầu PGD XL');
		$this->sheet->setCellValue('H1', 'Thời lượng PGD XL lần đầu');
		$this->sheet->setCellValue('I1', 'Tổng thời gian PGD XL');
		$this->sheet->setCellValue('J1', 'Trạng thái PGD');
		$this->sheet->setCellValue('K1', 'Tình trạng lead');
		$this->sheet->setCellValue('L1', 'Trạng thái HĐGN');
		$this->sheet->setCellValue('M1', 'Số tiền GN');

		$this->setStyle_dataT10('A1');
		$this->setStyle_dataT10('B1');
		$this->setStyle_dataT10('C1');
		$this->setStyle_dataT10('D1');
		$this->setStyle_dataT10('E1');
		$this->setStyle_dataT10('F1');
		$this->setStyle_dataT10('G1');
		$this->setStyle_dataT10('H1');
		$this->setStyle_dataT10('I1');
		$this->setStyle_dataT10('J1');
		$this->setStyle_dataT10('K1');
		$this->setStyle_dataT10('L1');
		$this->setStyle_dataT10('M1');

		$i = 2;
		foreach ($data as $value) {

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($value->office_at) ? date("d/m/y H:i:s", $value->office_at) : "")
				->getStyle('B' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_HIS);
			$this->sheet->setCellValue('C' . $i, !empty($value->cvkd) ? $value->cvkd : "");
			$this->sheet->setCellValue('D' . $i, !empty($value->fullname) ? $value->fullname : "");
			$this->sheet->setCellValue('E' . $i, !empty($value->phone_number) ? hide_phone($value->phone_number) : "");
			$this->sheet->setCellValue('F' . $i, !empty($value->id_PDG) ? $value->id_PDG : "");
			$this->sheet->setCellValue('G' . $i, !empty($value->time_xl_ld) ? $value->time_xl_ld : "")
				->getStyle('G' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_HIS);
			$this->sheet->setCellValue('H' . $i, !empty($value->at_xl_ld) ? $value->at_xl_ld : "")
				->getStyle('H' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_HIS);
			$this->sheet->setCellValue('I' . $i, !empty($value->time) ? $value->time : "")
				->getStyle('I' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_HIS);
			$this->sheet->setCellValue('J' . $i, !empty($value->status_pgd) ? status_pgd($value->status_pgd) : "");
			$this->sheet->setCellValue('K' . $i, !empty($value->reason_process) ? reason_process($value->reason_process) : "");
			$this->sheet->setCellValue('L' . $i, !empty($value->status_hd) ? contract_status($value->status_hd) : "");
			$this->sheet->setCellValue('M' . $i, !empty($value->amount_money) ? $value->amount_money : "")
				->getStyle('M' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);


			$i++;
		}
		$this->callLibExcel('Báo cáo xử lý lead PGD' . date('d-m-Y') . '.xlsx');


	}

	public function indexGroupDistribution()
	{

		$this->data['template'] = 'page/accountant/report/report_group_distribution.php';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function exportGroupDistribution()
	{

		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$data = array();
		if (!empty($fdate)) $data['fdate'] = $fdate;
		if (!empty($tdate)) $data['tdate'] = $tdate;

		$dataDebt = $this->api->apiPost($this->userInfo['token'], "dashboard_thn/exportGroupDistribution", $data);

		if (!empty($dataDebt->data)) {
			$this->exportGroupDistribution_data($dataDebt->data);
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	public function exportGroupDistribution_data($data)
	{

		$this->sheet->setCellValue('A1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('B1', 'Mã hợp đồng');
		$this->sheet->setCellValue('C1', 'Tên người vay');
		$this->sheet->setCellValue('D1', 'Phòng GD');
		$this->sheet->setCellValue('E1', 'Kỳ hạn vay');
		$this->sheet->setCellValue('F1', 'Số tiền vay ban đầu');
		$this->sheet->setCellValue('G1', 'Ngày giải ngân');
		$this->sheet->setCellValue('H1', 'Ngày đáo hạn');
		$this->sheet->setCellValue('I1', 'Nhóm nợ');
		$this->sheet->setCellValue('J1', 'Số tiền gốc còn lại');
		$this->sheet->setCellValue('K1', 'Số ngày chậm trả');
		$this->sheet->setCellValue('L1', 'Tổng số tiền đã thanh toán cho khoản vay');
		$this->sheet->setCellValue('M1', 'Tổng số tiền đã giảm cho khoản vay');

		$this->setStyle_dataT10('A1');
		$this->setStyle_dataT10('B1');
		$this->setStyle_dataT10('C1');
		$this->setStyle_dataT10('D1');
		$this->setStyle_dataT10('E1');
		$this->setStyle_dataT10('F1');
		$this->setStyle_dataT10('G1');
		$this->setStyle_dataT10('H1');
		$this->setStyle_dataT10('I1');
		$this->setStyle_dataT10('J1');
		$this->setStyle_dataT10('K1');
		$this->setStyle_dataT10('L1');
		$this->setStyle_dataT10('M1');

		$i = 2;
		foreach ($data as $value) {

			$this->sheet->setCellValue('A' . $i, !empty($value->code_contract) ? $value->code_contract : "");
			$this->sheet->setCellValue('B' . $i, !empty($value->code_contract_disbursement) ? $value->code_contract_disbursement : "");
			$this->sheet->setCellValue('C' . $i, !empty($value->customer_name) ? $value->customer_name : "");
			$this->sheet->setCellValue('D' . $i, !empty($value->store_name) ? $value->store_name : "");
			$this->sheet->setCellValue('E' . $i, !empty($value->number_day_loan) ? $value->number_day_loan : "");
			$this->sheet->setCellValue('F' . $i, !empty($value->amount_money) ? $value->amount_money : "")
				->getStyle('F' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('G' . $i, !empty($value->disbursement_date) ? date('d/m/Y', $value->disbursement_date) : "");
			$this->sheet->setCellValue('H' . $i, !empty($value->ngay_ky_tra) ? date('d/m/Y', $value->ngay_ky_tra) : "");
			$this->sheet->setCellValue('I' . $i, (!empty($value->so_ngay_cham_tra) && $value->so_ngay_cham_tra != 0) ? get_bucket($value->so_ngay_cham_tra) : "B0");
			$this->sheet->setCellValue('J' . $i, !empty($value->tong_tien_goc_con) ? $value->tong_tien_goc_con : "")
				->getStyle('J' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('K' . $i, (!empty($value->so_ngay_cham_tra) && $value->so_ngay_cham_tra != 0) ? $value->so_ngay_cham_tra : 0);
			$this->sheet->setCellValue('L' . $i, !empty($value->total_monney_contract) ? $value->total_monney_contract : 0)
				->getStyle('L' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('M' . $i, !empty($value->total_deductible) ? $value->total_deductible : 0)
				->getStyle('M' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);


			$i++;
		}


		$this->callLibExcel('Báo cáo phân bổ nhóm nợ THN' . date('d-m-Y') . '.xlsx');
	}

	public function excel_follow_debt()
	{

		$data = [];
		$month = !empty($_GET['month']) ? $_GET['month'] : date('Y-m');
		if (!empty($month)) {
			$data['month'] = $month;
		}

		$result = $this->api->apiPost($this->userInfo['token'], "plan_actual/indexFollowDebt", $data);

		if (!empty($result->data)) {
			$this->excel_follow_debt_data($result->data);
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	function excel_follow_debt_data($data)
	{
		$this->sheet->setCellValue('A1', 'Ngày');
		$this->sheet->setCellValue('B1', 'Lãi');
		$this->sheet->setCellValue('C1', 'Phí tư vấn');
		$this->sheet->setCellValue('D1', 'Phí thẩm định');
		$this->sheet->setCellValue('E1', 'Gốc');
		$this->sheet->setCellValue('F1', 'Total plan');
		$this->sheet->setCellValue('G1', 'Actual');
		$this->sheet->setCellValue('H1', 'Diff');

		$this->setStyle_dataT10('A1');
		$this->setStyle_dataT10('B1');
		$this->setStyle_dataT10('C1');
		$this->setStyle_dataT10('D1');
		$this->setStyle_dataT10('E1');
		$this->setStyle_dataT10('F1');
		$this->setStyle_dataT10('G1');
		$this->setStyle_dataT10('H1');


		$i = 2;
		foreach ($data as $value) {

			$this->sheet->setCellValue('A' . $i, !empty($value->ngay_thang) ? $value->ngay_thang : "");
			$this->sheet->setCellValue('B' . $i, !empty($value->lai) ? $value->lai : 0)
				->getStyle('B' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('C' . $i, !empty($value->phi_tu_van) ? $value->phi_tu_van : 0)
				->getStyle('C' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('D' . $i, !empty($value->phi_tham_dinh) ? $value->phi_tham_dinh : 0)
				->getStyle('D' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('E' . $i, !empty($value->goc) ? $value->goc : 0)
				->getStyle('E' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('F' . $i, !empty($value->total_plan) ? $value->total_plan : 0)
				->getStyle('F' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('G' . $i, !empty($value->actual) ? $value->actual : 0)
				->getStyle('G' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('H' . $i, !empty($value->diff) ? $value->diff : 0)
				->getStyle('H' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$i++;
		}
		$this->callLibExcel('Báo cáo thu hồi nợ - ' . date('d-m-Y') . '.xlsx');
	}

	function excel_disbursement()
	{
		$data = [];
		$month = !empty($_GET['month']) ? $_GET['month'] : date('Y-m');
		if (!empty($month)) {
			$data['month'] = $month;
		}

		$result = $this->api->apiPost($this->userInfo['token'], "plan_actual/indexDisbursement", $data);

		if (!empty($result->data)) {
			$this->excel_disbursement_data($result->data);
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	function excel_disbursement_data($data)
	{
		$this->sheet->setCellValue('A1', 'Ngày');
		$this->sheet->setCellValue('B1', 'KH PGD');
		$this->sheet->setCellValue('C1', 'KH (Priority + Nhà đất)');

		$this->setStyle_dataT10('A1');
		$this->setStyle_dataT10('B1');
		$this->setStyle_dataT10('C1');


		$i = 2;
		foreach ($data as $value) {

			$this->sheet->setCellValue('A' . $i, !empty($value->ngay_thang) ? $value->ngay_thang : "");
			$this->sheet->setCellValue('B' . $i, !empty($value->kh_pgd) ? $value->kh_pgd : 0)
				->getStyle('B' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('C' . $i, !empty($value->priority) ? $value->priority : 0)
				->getStyle('C' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$i++;
		}
		$this->callLibExcel('Báo cáo giải ngân - ' . date('d-m-Y') . '.xlsx');
	}

	function excel_investor()
	{
		$data = [];
		$month = !empty($_GET['month']) ? $_GET['month'] : date('Y-m');
		if (!empty($month)) {
			$data['month'] = $month;
		}

		$getData = $this->api->apiPost($this->userInfo['token'], "plan_actual/create_manually_investor", $data);

		$result = $this->callApiInvest($data);

		if (!empty($result->data)) {
			if (!empty($getData) && $getData->status == 200) {
				for ($i = 0; $i < count($result->data); $i++) {
					$result->data[$i]->phatSinhNdtHopTac = $getData->data[$i]->phatSinhNdtHopTac;
					$result->data[$i]->manually_investor_id = $getData->data[$i]->_id->{'$oid'};
				}
			}
			$this->excel_investor_data($result->data);
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	public function callApiInvest($data)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->config->item('URL_NDT') . '/plan/getDataInvestor',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => $data,
		));
		$response = curl_exec($curl);
		return json_decode($response);
	}

	function excel_investor_data($data)
	{

		$this->sheet->setCellValue('A1', 'Ngày');
		$this->sheet->setCellValue('B1', 'Lịch thanh toán lập cuối tháng T-1');
		$this->sheet->setCellValue('G1', 'Phát sinh lịch TT trong tháng T');
		$this->sheet->setCellValue('B2', 'NĐT hợp tác');
		$this->sheet->setCellValue('C2', 'Vay mượn');
		$this->sheet->setCellValue('D2', 'App NĐT NL');
		$this->sheet->setCellValue('E2', 'App NĐT Vimo');
		$this->sheet->setCellValue('F2', 'VNDT');
		$this->sheet->setCellValue('G2', 'NĐT hợp tác');
		$this->sheet->setCellValue('H2', 'VNDT');

		$this->sheet->mergeCells('A1:A2');
		$this->sheet->mergeCells('B1:F1');
		$this->sheet->mergeCells('G1:H1');

		$this->setStyle_dataT10('A1');
		$this->setStyle_dataT10('B1');
		$this->setStyle_dataT10('G1');
		$this->setStyle_dataT10('B2');
		$this->setStyle_dataT10('C2');
		$this->setStyle_dataT10('D2');
		$this->setStyle_dataT10('E2');
		$this->setStyle_dataT10('F2');
		$this->setStyle_dataT10('G2');
		$this->setStyle_dataT10('H2');

		$i = 3;
		foreach ($data as $value) {

			$this->sheet->setCellValue('A' . $i, !empty($value->ngay_thang) ? $value->ngay_thang : "");
			$this->sheet->setCellValue('B' . $i, !empty($value->ndt_hoptac) ? $value->ndt_hoptac : 0)
				->getStyle('B' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('C' . $i, 0)
				->getStyle('C' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('D' . $i, !empty($value->app_ndt_nl) ? $value->app_ndt_nl : 0)
				->getStyle('D' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('E' . $i, !empty($value->app_ndt_vimo) ? $value->app_ndt_vimo : 0)
				->getStyle('E' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('F' . $i, 0)
				->getStyle('F' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('G' . $i, !empty($value->phatSinhNdtHopTac) ? $value->phatSinhNdtHopTac : 0)
				->getStyle('G' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('H' . $i, 0)
				->getStyle('H' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$i++;
		}


		$this->callLibExcel('Báo cáo nhà đầu tư - ' . date('d-m-Y') . '.xlsx');
	}

	public function report_synthetic()
	{
		$data = [];
		$month = !empty($_GET['month']) ? $_GET['month'] : date('Y-m');
		if (!empty($month)) {
			$data['month'] = $month;
		}

		$result = $this->api->apiPost($this->userInfo['token'], "report_kpi/report_synthetic_data", $data);

		if (!empty($result->data) && $result->status == 200) {
			$this->report_synthetic_data($result->data);
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	public function report_synthetic_data($data)
	{

		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Tên PGD');
		$this->sheet->setCellValue('C1', 'Địa chỉ PGD');
		$this->sheet->setCellValue('D1', 'Thời gian hoạt động');
		$this->sheet->setCellValue('E1', 'Số lượng CVKD');
		$this->sheet->setCellValue('F1', 'Tỉnh');
		$this->sheet->setCellValue('G1', 'Khu vực');
		$this->sheet->setCellValue('H1', 'Miền');
		$this->sheet->setCellValue('I1', 'Số HĐ xe máy');
		$this->sheet->setCellValue('J1', 'Số HĐ ô tô');
		$this->sheet->setCellValue('K1', 'Số HĐ vay 1T');
		$this->sheet->setCellValue('L1', 'Số HĐ vay 3T');
		$this->sheet->setCellValue('M1', 'Số HĐ vay lớn hơn 6T');
		$this->sheet->setCellValue('N1', 'Tiền giải ngân mới kỳ này');
		$this->sheet->setCellValue('O1', 'Dư nợ tăng net T+10');
		$this->sheet->setCellValue('P1', 'Doanh số bảo hiểm kỳ này');
		$this->sheet->setCellValue('Q1', 'Tổng tiền giải ngân');
		$this->sheet->setCellValue('R1', 'Dư nợ quản lý');
		$this->sheet->setCellValue('S1', 'Dư nợ trong hạn T+10 hiện tại');
		$this->sheet->setCellValue('T1', 'Dư nợ trong hạn T+10 kỳ trước');
		$this->sheet->setCellValue('U1', 'Dư nợ (1 <= B1 <= 30)');
		$this->sheet->setCellValue('V1', 'Dư nợ (31 <= B2 <= 60)');
		$this->sheet->setCellValue('W1', 'Dư nợ (61 <= B2 <= 90)');
		$this->sheet->setCellValue('X1', 'Dư nợ (B4+ > 90)');
		$this->sheet->setCellValue('Y1', 'Dư nợ (B0 <= 0)');

		$this->setStyle_dataT10('A1');
		$this->setStyle_dataT10('B1');
		$this->setStyle_dataT10('C1');
		$this->setStyle_dataT10('D1');
		$this->setStyle_dataT10('E1');
		$this->setStyle_dataT10('F1');
		$this->setStyle_dataT10('G1');
		$this->setStyle_dataT10('H1');
		$this->setStyle_dataT10('I1');
		$this->setStyle_dataT10('J1');
		$this->setStyle_dataT10('K1');
		$this->setStyle_dataT10('L1');
		$this->setStyle_dataT10('M1');
		$this->setStyle_dataT10('N1');
		$this->setStyle_dataT10('O1');
		$this->setStyle_dataT10('P1');
		$this->setStyle_dataT10('Q1');
		$this->setStyle_dataT10('R1');
		$this->setStyle_dataT10('S1');
		$this->setStyle_dataT10('T1');
		$this->setStyle_dataT10('U1');
		$this->setStyle_dataT10('V1');
		$this->setStyle_dataT10('W1');
		$this->setStyle_dataT10('X1');
		$this->setStyle_dataT10('Y1');

		$i = 2;
		foreach ($data as $key => $value) {

			$this->sheet->setCellValue('A' . $i, ++$key);
			$this->sheet->setCellValue('B' . $i, !empty($value->name) ? $value->name : "");
			$this->sheet->setCellValue('C' . $i, !empty($value->address) ? $value->address : "");
			$this->sheet->setCellValue('D' . $i, !empty($value->created_at) ? date('d/m/Y', $value->created_at) : "");
			$this->sheet->setCellValue('E' . $i, !empty($value->nhanvien) ? $value->nhanvien : 0);
			$this->sheet->setCellValue('F' . $i, !empty($value->province) ? $value->province : "");
			$this->sheet->setCellValue('G' . $i, !empty($value->code_area) ? $value->code_area : "");
			$this->sheet->setCellValue('H' . $i, !empty($value->area) ? $value->area : "");
			$this->sheet->setCellValue('I' . $i, !empty($value->count_hd_xm) ? $value->count_hd_xm : 0)
				->getStyle('I' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('J' . $i, !empty($value->count_hd_oto) ? $value->count_hd_oto : 0)
				->getStyle('J' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('K' . $i, !empty($value->count_hd_1) ? $value->count_hd_1 : 0)
				->getStyle('K' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('L' . $i, !empty($value->count_hd_3) ? $value->count_hd_3 : 0)
				->getStyle('L' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('M' . $i, !empty($value->count_hd_6) ? $value->count_hd_6 : 0)
				->getStyle('M' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('N' . $i, !empty($value->amount_money) ? $value->amount_money : 0)
				->getStyle('N' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('O' . $i, !empty($value->du_no_tang_net) ? $value->du_no_tang_net : 0)
				->getStyle('O' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('P' . $i, !empty($value->insurance_sales) ? $value->insurance_sales : 0)
				->getStyle('P' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('Q' . $i, !empty($value->total_amount_money) ? $value->total_amount_money : 0)
				->getStyle('Q' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('R' . $i, !empty($value->total_du_no_dang_cho_vay_old) ? $value->total_du_no_dang_cho_vay_old : 0)
				->getStyle('R' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('S' . $i, !empty($value->du_no_trong_han_T10_hien_tai) ? $value->du_no_trong_han_T10_hien_tai : 0)
				->getStyle('S' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('T' . $i, !empty($value->du_no_trong_han_T10_ky_truoc) ? $value->du_no_trong_han_T10_ky_truoc : 0)
				->getStyle('T' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('U' . $i, !empty($value->total_du_no_b1) ? $value->total_du_no_b1 : 0)
				->getStyle('U' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('V' . $i, !empty($value->total_du_no_b2) ? $value->total_du_no_b2 : 0)
				->getStyle('V' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('W' . $i, !empty($value->total_du_no_b3) ? $value->total_du_no_b3 : 0)
				->getStyle('W' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('X' . $i, !empty($value->total_du_no_b4) ? $value->total_du_no_b4 : 0)
				->getStyle('X' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('Y' . $i, !empty($value->total_du_no_b0) ? $value->total_du_no_b0 : 0)
				->getStyle('Y' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$i++;
		}

		$this->callLibExcel('Báo cáo kinh doanh - ' . date('d-m-Y') . '.xlsx');
	}

	public function exportKpiRSM()
	{

		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$data = array();
		if (!empty($fdate)) $data['start'] = $fdate;
		if (!empty($tdate)) $data['end'] = $tdate;

		$dataLead = $this->api->apiPost($this->userInfo['token'], "report_kpi/exportKpiRSM", $data);
		if (!empty($dataLead->data)) {
			$this->exportKpiRSM_data($dataLead->data);

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}

	}

	public function exportKpiRSM_data($export)
	{

		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Khu vực');
		$this->sheet->setCellValue('C1', 'Dư nợ trong hạn T+10 kỳ trước');
		$this->sheet->setCellValue('D1', 'Dư nợ trong hạn T+10 hiện tại');
		$this->sheet->setCellValue('E1', 'Dư nợ tăng net trong tháng');
		$this->sheet->setCellValue('F1', 'Chỉ tiêu dư nợ tăng net trong tháng');
		$this->sheet->setCellValue('G1', 'Doanh số bảo hiểm trong tháng');
		$this->sheet->setCellValue('H1', 'Chỉ tiêu bảo hiểm trong tháng');
		$this->sheet->setCellValue('I1', 'Số tiền giải ngân trong tháng');
		$this->sheet->setCellValue('J1', 'Chỉ tiêu giải ngân trong tháng');
		$this->sheet->setCellValue('K1', 'Số tiền đầu tư trong tháng');
		$this->sheet->setCellValue('L1', 'Chỉ tiêu đầu tư trong tháng');
		$this->sheet->setCellValue('M1', 'Tỉ lệ Kpi (%)');
		$this->sheet->setCellValue('N1', 'Tổng tiền hoa hồng');


		$i = 2;
		foreach ($export as $key => $value) {

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($value->store_name) ? $value->store_name : '');
			$this->sheet->setCellValue('C' . $i, !empty($value->total_du_no_trong_han_t10_thang_truoc) ? $value->total_du_no_trong_han_t10_thang_truoc : '')
				->getStyle('C' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('D' . $i, !empty($value->total_du_no_trong_han_t10_old) ? $value->total_du_no_trong_han_t10_old : '')
				->getStyle('D' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('E' . $i, !empty($value->total_du_no_trong_han_t10) ? $value->total_du_no_trong_han_t10 : '')
				->getStyle('E' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('F' . $i, !empty($value->chi_tieu_du_no_tang_net) ? $value->chi_tieu_du_no_tang_net : '')
				->getStyle('F' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('G' . $i, !empty($value->total_doanh_so_bao_hiem) ? $value->total_doanh_so_bao_hiem : '')
				->getStyle('G' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('H' . $i, !empty($value->chi_tieu_bao_hiem) ? $value->chi_tieu_bao_hiem : '')
				->getStyle('H' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('I' . $i, !empty($value->total_so_tien_vay) ? $value->total_so_tien_vay : '')
				->getStyle('I' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('J' . $i, !empty($value->chi_tieu_giai_ngan) ? $value->chi_tieu_giai_ngan : '')
				->getStyle('J' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('K' . $i, !empty($value->tong_tien_dau_tu) ? $value->tong_tien_dau_tu : '')
				->getStyle('K' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('L' . $i, !empty($value->chi_tieu_nha_dau_tu) ? $value->chi_tieu_nha_dau_tu : '')
				->getStyle('L' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('M' . $i, !empty($value->kpi) ? $value->kpi : '')
				->getStyle('M' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('N' . $i, !empty($value->total_tien_hoa_hong) ? $value->total_tien_hoa_hong : '')
				->getStyle('N' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$i++;
		}

		$this->callLibExcel('Kpi_Rsm' . time() . '.xlsx');

	}

	public function excel_plan_actual()
	{

		$data = [];
		$month = !empty($_GET['month']) ? $_GET['month'] : date('Y-m');
		if (!empty($month)) {
			$data['month'] = $month;
		}

		$result = $this->api->apiPost($this->userInfo['token'], "plan_actual/getTongSoDuCacTaiKhoan", $data);

		if (!empty($result) && $result->status == 200) {

			$this->excel_plan_actual_data($result->getDayOfMonth, $result->totalBalance, $result->manually_enter);
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}


	}

	public function excel_plan_actual_data($getDayOfMonth, $totalBalance, $manually_enter)
	{

		$arr = ['C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG'];

		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Nội dung');

		foreach ($getDayOfMonth as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '1', $value);
		}
		$this->sheet->setCellValue('A2', 'Phần 1');
		$this->sheet->setCellValue('B2', 'BUDGET');
		$this->sheet->setCellValue('A3', 'A/');
		$this->sheet->setCellValue('B3', 'DÒNG TIỀN L1 - BUDGET:');

		$this->sheet->setCellValue('A4', '1/');
		$this->sheet->setCellValue('B4', 'Tổng tiền tại các TK NH');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '4', !empty($value->tong_tien_tai_khoan_ngan_hang) ? $value->tong_tien_tai_khoan_ngan_hang : 0)
				->getStyle($arr[$key] . '4')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}


		$this->sheet->setCellValue('A5', '2');
		$this->sheet->setCellValue('B5', 'Tổng tiền gốc VPS');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '5', !empty($value->tong_tien_goc_vps) ? $value->tong_tien_goc_vps : 0)
				->getStyle($arr[$key] . '5')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A6', '2.1');
		$this->sheet->setCellValue('B6', 'Tổng tiền gốc và lãi VPS đến hạn');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '6', !empty($value->goc_lai_vps_den_han) ? $value->goc_lai_vps_den_han : 0)
				->getStyle($arr[$key] . '6')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A7', '2.2');
		$this->sheet->setCellValue('B7', 'Tổng tiền gốc VPS chưa đến hạn');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '7', !empty($value->goc_lai_vps_chua_den_han) ? $value->goc_lai_vps_chua_den_han : 0)
				->getStyle($arr[$key] . '7')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A8', '2.3');
		$this->sheet->setCellValue('B8', 'Tổng tiền gốc VPS chưa đến hạn dự kiến đáo');
		foreach ($manually_enter as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '8', !empty($value->tong_tien_vps_chua_den_han_du_kien_dao) ? $value->tong_tien_vps_chua_den_han_du_kien_dao : 0)
				->getStyle($arr[$key] . '8')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A9', '2.4');
		$this->sheet->setCellValue('B9', 'Tổng tiền gốc VPS có thể sử dụng');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '9', !empty($value->tong_goc_VPS_co_the_su_dung) ? $value->tong_goc_VPS_co_the_su_dung : 0)
				->getStyle($arr[$key] . '9')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A10', '3');
		$this->sheet->setCellValue('B10', 'Tổng tiền có thể sử dụng L1');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '10', !empty($value->tong_tien_co_the_su_dung) ? $value->tong_tien_co_the_su_dung : 0)
				->getStyle($arr[$key] . '10')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A11', 'II/');
		$this->sheet->setCellValue('B11', 'Dòng tiền vào');

		$this->sheet->setCellValue('A12', '1');
		$this->sheet->setCellValue('B12', 'Thu nợ Nhóm nợ 1');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '12', !empty($value->total_plan) ? $value->total_plan : 0)
				->getStyle($arr[$key] . '12')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A13', '');
		$this->sheet->setCellValue('B13', 'Gốc');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '13', !empty($value->goc) ? $value->goc : 0)
				->getStyle($arr[$key] . '13')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A14', '');
		$this->sheet->setCellValue('B14', 'Lãi');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '14', !empty($value->lai) ? $value->lai : 0)
				->getStyle($arr[$key] . '14')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A15', '');
		$this->sheet->setCellValue('B15', 'Phí tư vấn');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '15', !empty($value->phi_tu_van) ? $value->phi_tu_van : 0)
				->getStyle($arr[$key] . '15')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A16', '');
		$this->sheet->setCellValue('B16', 'Phí thẩm định');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '16', !empty($value->phi_tham_dinh) ? $value->phi_tham_dinh : 0)
				->getStyle($arr[$key] . '16')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A17', '2');
		$this->sheet->setCellValue('B17', 'Thu L2');
		foreach ($manually_enter as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '17', !empty($value->thu_l2) ? $value->thu_l2 : 0)
				->getStyle($arr[$key] . '17')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A18', '3');
		$this->sheet->setCellValue('B18', 'Thu khác');
		foreach ($manually_enter as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '18', !empty($value->thu_khac) ? $value->thu_khac : 0)
				->getStyle($arr[$key] . '18')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A19', '');
		$this->sheet->setCellValue('B19', 'Tổng dòng tiền vào L1');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '19', !empty($value->total_dong_tien_l1) ? $value->total_dong_tien_l1 : 0)
				->getStyle($arr[$key] . '19')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A20', 'III/');
		$this->sheet->setCellValue('B20', 'Dòng tiền ra');

		$this->sheet->setCellValue('A21', '1');
		$this->sheet->setCellValue('B21', 'CP hoạt động');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '21', !empty($value->cp_hoat_dong) ? $value->cp_hoat_dong : 0)
				->getStyle($arr[$key] . '21')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A22', '');
		$this->sheet->setCellValue('B22', 'Thanh toán theo các đợt');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '22', !empty($value->thanh_toan_theo_cac_dot) ? $value->thanh_toan_theo_cac_dot : 0)
				->getStyle($arr[$key] . '22')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A23', '');
		$this->sheet->setCellValue('B23', 'Thanh toán ngoại lệ');
		foreach ($manually_enter as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '23', !empty($value->thanh_toan_ngoai_le) ? $value->thanh_toan_ngoai_le : 0)
				->getStyle($arr[$key] . '23')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A24', '2');
		$this->sheet->setCellValue('B24', 'Thanh toán về L2');
		foreach ($manually_enter as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '24', !empty($value->thanh_toan_ve_l2) ? $value->thanh_toan_ve_l2 : 0)
				->getStyle($arr[$key] . '24')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A25', '3');
		$this->sheet->setCellValue('B25', 'Các khoản chi khác');
		foreach ($manually_enter as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '25', !empty($value->cac_khoan_chi_khac) ? $value->cac_khoan_chi_khac : 0)
				->getStyle($arr[$key] . '25')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A26', '');
		$this->sheet->setCellValue('B26', 'Tổng dòng tiền ra');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '26', !empty($value->tong_dong_tien_ra) ? $value->tong_dong_tien_ra : 0)
				->getStyle($arr[$key] . '26')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A27', 'IV/');
		$this->sheet->setCellValue('B27', 'Net CF Budget - L1');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '27', !empty($value->net_cf_budget_l1) ? $value->net_cf_budget_l1 : 0)
				->getStyle($arr[$key] . '27')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A28', 'V/');
		$this->sheet->setCellValue('B28', 'DƯ TIỀN CẦN TẠI TK NH L1');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '28', !empty($value->du_tien_can_tai_tk_nh_l1) ? $value->du_tien_can_tai_tk_nh_l1 : 0)
				->getStyle($arr[$key] . '28')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A29', 'B/');
		$this->sheet->setCellValue('B29', 'DÒNG TIỀN L2:');

		$this->sheet->setCellValue('A30', 'I/');
		$this->sheet->setCellValue('B30', 'Số dư các TK L2:');

		$this->sheet->setCellValue('A31', '1');
		$this->sheet->setCellValue('B31', 'Ví NL TMQ');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '31', !empty($value->vi_nl_tmq) ? $value->vi_nl_tmq : 0)
				->getStyle($arr[$key] . '31')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A32', '2');
		$this->sheet->setCellValue('B32', 'Ví Vimo VFC');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '32', !empty($value->vi_vimo_vfc) ? $value->vi_vimo_vfc : 0)
				->getStyle($arr[$key] . '32')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A33', '3');
		$this->sheet->setCellValue('B33', 'Ví Vimo Vay Mượn');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '33', !empty($value->vi_vimo_vaymuon) ? $value->vi_vimo_vaymuon : 0)
				->getStyle($arr[$key] . '33')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A34', '4');
		$this->sheet->setCellValue('B34', 'Ví VNDT');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '34', !empty($value->vi_vndt) ? $value->vi_vndt : 0)
				->getStyle($arr[$key] . '34')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A35', '5');
		$this->sheet->setCellValue('B35', 'TK Tech TMQ');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '35', !empty($value->vi_tech_tmq) ? $value->vi_tech_tmq : 0)
				->getStyle($arr[$key] . '35')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A36', '6');
		$this->sheet->setCellValue('B36', 'TK VPS');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '36', !empty($value->tong_tien_goc_vps) ? $value->tong_tien_goc_vps : 0)
				->getStyle($arr[$key] . '36')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A37', '6.1');
		$this->sheet->setCellValue('B37', 'Tổng tiền VPS đến hạn');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '37', !empty($value->goc_lai_vps_den_han) ? $value->goc_lai_vps_den_han : 0)
				->getStyle($arr[$key] . '37')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A38', '6.2');
		$this->sheet->setCellValue('B38', 'Tổng tiền VPS chưa đến hạn');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '38', !empty($value->goc_lai_vps_chua_den_han) ? $value->goc_lai_vps_chua_den_han : 0)
				->getStyle($arr[$key] . '38')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A39', '6.3');
		$this->sheet->setCellValue('B39', 'Tổng tiền VPS chưa đến hạn dự kiến đáo');
		foreach ($manually_enter as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '39', !empty($value->tong_tien_vps_chua_den_han_du_kien_dao_1) ? $value->tong_tien_vps_chua_den_han_du_kien_dao_1 : 0)
				->getStyle($arr[$key] . '39')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A40', '6.4');
		$this->sheet->setCellValue('B40', 'Tổng tiền VPS có thể sử dụng');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '40', !empty($value->tong_tien_vps_co_the_su_dung) ? $value->tong_tien_vps_co_the_su_dung : 0)
				->getStyle($arr[$key] . '40')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A41', '');
		$this->sheet->setCellValue('B41', 'Tổng tiền có thể sử dụng L2:');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '41', !empty($value->tong_tien_co_the_su_dung_l2) ? $value->tong_tien_co_the_su_dung_l2 : 0)
				->getStyle($arr[$key] . '41')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A42', 'II/');
		$this->sheet->setCellValue('B42', 'DÒNG TIỀN VÀO:');


		$this->sheet->setCellValue('A43', '1');
		$this->sheet->setCellValue('B43', 'Nhà đầu tư nạp tiền:');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '43', !empty($value->nha_dau_tu_nap_tien) ? $value->nha_dau_tu_nap_tien : 0)
				->getStyle($arr[$key] . '43')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A44', '1.1');
		$this->sheet->setCellValue('B44', 'NĐT hợp tác');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '44', !empty($value->budget_nap_ndt_hop_tac) ? $value->budget_nap_ndt_hop_tac : 0)
				->getStyle($arr[$key] . '44')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A45', '1.2');
		$this->sheet->setCellValue('B45', 'NĐT App ví NL');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '45', !empty($value->budget_nap_app_vi_nl) ? $value->budget_nap_app_vi_nl : 0)
				->getStyle($arr[$key] . '45')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A46', '1.3');
		$this->sheet->setCellValue('B46', 'NĐT App ví Vimo');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '46', !empty($value->budget_nap_app_vi_vimo) ? $value->budget_nap_app_vi_vimo : 0)
				->getStyle($arr[$key] . '46')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A47', '1.4');
		$this->sheet->setCellValue('B47', 'NĐT App ví Vimo Vay Mượn');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '47', "-")
				->getStyle($arr[$key] . '47')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A48', '1.5');
		$this->sheet->setCellValue('B48', 'VNDT');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '48', "-")
				->getStyle($arr[$key] . '48')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A49', '2');
		$this->sheet->setCellValue('B49', 'Nhận tiền L1');
		foreach ($manually_enter as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '49', !empty($value->thanh_toan_ve_l2) ? $value->thanh_toan_ve_l2 : 0)
				->getStyle($arr[$key] . '49')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A50', '3');
		$this->sheet->setCellValue('B50', 'Nhận khác:');
		foreach ($manually_enter as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '50', !empty($value->nhan_khac) ? $value->nhan_khac : 0)
				->getStyle($arr[$key] . '50')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A51', '');
		$this->sheet->setCellValue('B51', 'Tổng dòng tiền vào L2:');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '51', !empty($value->tong_dong_tien_vao_l2) ? $value->tong_dong_tien_vao_l2 : 0)
				->getStyle($arr[$key] . '51')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A52', 'III/');
		$this->sheet->setCellValue('B52', 'Dòng tiền ra');

		$this->sheet->setCellValue('A53', '1');
		$this->sheet->setCellValue('B53', 'Giải ngân');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '53', !empty($value->giai_ngan) ? $value->giai_ngan : 0)
				->getStyle($arr[$key] . '53')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A54', '1.1');
		$this->sheet->setCellValue('B54', 'KH PGD');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '54', !empty($value->price_disbursement) ? $value->price_disbursement : 0)
				->getStyle($arr[$key] . '54')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A55', '1.2');
		$this->sheet->setCellValue('B55', 'KH (Priority + Nhà đất)');
		foreach ($manually_enter as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '55', !empty($value->priority_nd) ? $value->priority_nd : 0)
				->getStyle($arr[$key] . '55')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A56', '2');
		$this->sheet->setCellValue('B56', 'Thanh toán NĐT');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '56', !empty($value->thanh_toan_ndt) ? $value->thanh_toan_ndt : 0)
				->getStyle($arr[$key] . '56')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A57', '2.1');
		$this->sheet->setCellValue('B57', 'NĐT hợp tác');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '57', !empty($value->ndt_hop_tac) ? $value->ndt_hop_tac : 0)
				->getStyle($arr[$key] . '57')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A58', '2.2');
		$this->sheet->setCellValue('B58', 'App NĐT NL');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '58', !empty($value->app_vi_nl) ? $value->app_vi_nl : 0)
				->getStyle($arr[$key] . '58')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A59', '2.3');
		$this->sheet->setCellValue('B59', 'App NĐT Vimo');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '59', !empty($value->app_vi_vimo) ? $value->app_vi_vimo : 0)
				->getStyle($arr[$key] . '59')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A60', '2.4');
		$this->sheet->setCellValue('B60', 'Vay mượn');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '60', "-")
				->getStyle($arr[$key] . '60')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A61', '2.5');
		$this->sheet->setCellValue('B61', 'VNDT');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '61', "-")
				->getStyle($arr[$key] . '61')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A62', '');
		$this->sheet->setCellValue('B62', 'Tổng dòng tiền ra L2:');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '62', !empty($value->tong_dong_tien_ra_l2) ? $value->tong_dong_tien_ra_l2 : 0)
				->getStyle($arr[$key] . '62')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A63', 'IV/');
		$this->sheet->setCellValue('B63', 'Net CF Budget L2');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '63', !empty($value->net_cf_budget_l2) ? $value->net_cf_budget_l2 : 0)
				->getStyle($arr[$key] . '63')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A64', 'V/');
		$this->sheet->setCellValue('B64', 'Dự trữ thanh khoản');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '64', !empty($totalBalance[0]->du_tru_thanh_khoan) ? $totalBalance[0]->du_tru_thanh_khoan : 0)
				->getStyle($arr[$key] . '64')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A65', 'VI/');
		$this->sheet->setCellValue('B65', 'Tổng tiền cần để đảm bảo thanh khoản cao nhất');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '65', !empty($value->tong_tien_can_de_dam_bao_thanh_khoan_cao_nhat) ? $value->tong_tien_can_de_dam_bao_thanh_khoan_cao_nhat : 0)
				->getStyle($arr[$key] . '65')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A66', 'VII/');
		$this->sheet->setCellValue('B66', 'Số dư TK tối thiểu');

		$this->sheet->setCellValue('A67', '1');
		$this->sheet->setCellValue('B67', 'Ví NL');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '67', !empty($value->VI_vi_nl) ? $value->VI_vi_nl : 0)
				->getStyle($arr[$key] . '67')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A68', '2');
		$this->sheet->setCellValue('B68', 'Ví Vimo VFC');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '68', !empty($value->VI_vi_vimo_vfc) ? $value->VI_vi_vimo_vfc : 0)
				->getStyle($arr[$key] . '68')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A69', '3');
		$this->sheet->setCellValue('B69', 'Ví Vimo Vay Mượn');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '69', "-")
				->getStyle($arr[$key] . '69')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A70', '4');
		$this->sheet->setCellValue('B70', 'Ví VNDT');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '70', "-")
				->getStyle($arr[$key] . '70')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A71', 'Phần 2');
		$this->sheet->setCellValue('B71', 'ACTUAL');

		$this->sheet->setCellValue('A72', 'A/');
		$this->sheet->setCellValue('B72', 'DÒNG TIỀN L1:');

		$this->sheet->setCellValue('A73', 'I/');
		$this->sheet->setCellValue('B73', 'Tổng số dư các tài khoản');

		$this->sheet->setCellValue('A74', '1');
		$this->sheet->setCellValue('B74', 'Tổng tiền tại các TK NH:');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '74', !empty($value->actual_tong_tien_tai_khoan_ngan_hang) ? $value->actual_tong_tien_tai_khoan_ngan_hang : 0)
				->getStyle($arr[$key] . '74')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A75', '2');
		$this->sheet->setCellValue('B75', 'Tổng tiền VPS');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '75', !empty($value->tong_tien_goc_vps) ? $value->tong_tien_goc_vps : 0)
				->getStyle($arr[$key] . '75')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A76', '2.1');
		$this->sheet->setCellValue('B76', 'Tổng tiền VPS đến hạn');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '76', !empty($value->actual_goc_lai_vps_den_han) ? $value->actual_goc_lai_vps_den_han : 0)
				->getStyle($arr[$key] . '76')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A77', '2.2');
		$this->sheet->setCellValue('B77', 'Tổng tiền VPS chưa đến hạn');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '77', !empty($value->actual_tong_tien_vps_chua_den_han) ? $value->actual_tong_tien_vps_chua_den_han : 0)
				->getStyle($arr[$key] . '77')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A78', '2.3');
		$this->sheet->setCellValue('B78', 'Tổng tiền VPS chưa đến hạn dự kiến đáo');
		foreach ($manually_enter as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '78', !empty($value->actual_tong_tien_vps_chua_den_han_du_kien_dao) ? $value->actual_tong_tien_vps_chua_den_han_du_kien_dao : 0)
				->getStyle($arr[$key] . '78')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A79', '2.4');
		$this->sheet->setCellValue('B79', 'Tổng tiền VPS có thể sử dụng');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '79', !empty($value->actual_tong_tien_vps_co_the_su_dung_1) ? $value->actual_tong_tien_vps_co_the_su_dung_1 : 0)
				->getStyle($arr[$key] . '79')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A80', '3');
		$this->sheet->setCellValue('B80', 'Tổng tiền có thể sử dụng:');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '80', !empty($value->actual_tong_tien_co_the_su_dung) ? $value->actual_tong_tien_co_the_su_dung : 0)
				->getStyle($arr[$key] . '80')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A81', 'II/');
		$this->sheet->setCellValue('B81', 'Dòng tiền vào');

		$this->sheet->setCellValue('A82', '1');
		$this->sheet->setCellValue('B82', 'Thực thu KH');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '82', !empty($value->actual_thuc_thu_khach) ? $value->actual_thuc_thu_khach : 0)
				->getStyle($arr[$key] . '82')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A83', '2');
		$this->sheet->setCellValue('B83', 'Thu L2');
		foreach ($manually_enter as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '83', !empty($value->actual_thu_l2) ? $value->actual_thu_l2 : 0)
				->getStyle($arr[$key] . '83')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A84', '3');
		$this->sheet->setCellValue('B84', 'Thu khác');
		foreach ($manually_enter as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '84', !empty($value->actual_thu_khac) ? $value->actual_thu_khac : 0)
				->getStyle($arr[$key] . '84')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A85', '');
		$this->sheet->setCellValue('B85', 'Tổng dòng tiền thực vào L1');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '85', !empty($value->actual_tong_dong_tien_thuc_vao_l1) ? $value->actual_tong_dong_tien_thuc_vao_l1 : 0)
				->getStyle($arr[$key] . '85')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A86', 'III/');
		$this->sheet->setCellValue('B86', 'Dòng tiền ra');

		$this->sheet->setCellValue('A87', '1');
		$this->sheet->setCellValue('B87', 'CP hoạt động');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '87', !empty($value->actual_cp_hoat_dong) ? $value->actual_cp_hoat_dong : 0)
				->getStyle($arr[$key] . '87')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A88', '');
		$this->sheet->setCellValue('B88', 'Thanh toán theo các đợt');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '88', !empty($value->actual_thanh_toan_theo_cac_dot) ? $value->actual_thanh_toan_theo_cac_dot : 0)
				->getStyle($arr[$key] . '88')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A89', '');
		$this->sheet->setCellValue('B89', 'Thanh toán ngoại lệ');
		foreach ($manually_enter as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '89', !empty($value->actual_thanh_toan_ngoai_le) ? $value->actual_thanh_toan_ngoai_le : 0)
				->getStyle($arr[$key] . '89')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A90', '2');
		$this->sheet->setCellValue('B90', 'Thanh toán về L2');
		foreach ($manually_enter as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '90', !empty($value->actual_thanh_toan_ve_l2) ? $value->actual_thanh_toan_ve_l2 : 0)
				->getStyle($arr[$key] . '90')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A91', '3');
		$this->sheet->setCellValue('B91', 'Các khoản chi khác');
		foreach ($manually_enter as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '91', !empty($value->actual_cac_khoan_chi_khac) ? $value->actual_cac_khoan_chi_khac : 0)
				->getStyle($arr[$key] . '91')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A92', '');
		$this->sheet->setCellValue('B92', 'Tổng dòng tiền ra');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '92', !empty($value->actual_tong_dong_tien_ra) ? $value->actual_tong_dong_tien_ra : 0)
				->getStyle($arr[$key] . '92')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A93', 'IV/');
		$this->sheet->setCellValue('B93', 'DƯ TIỀN CẦN TẠI TK NH L1');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '93', !empty($value->actual_du_tien_can_tai_tk_nh_l1) ? $value->actual_du_tien_can_tai_tk_nh_l1 : 0)
				->getStyle($arr[$key] . '93')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A94', 'B/');
		$this->sheet->setCellValue('B94', 'DÒNG TIỀN L2:');

		$this->sheet->setCellValue('A95', 'I/');
		$this->sheet->setCellValue('B95', 'Số dư các TK L2');

		$this->sheet->setCellValue('A96', '1');
		$this->sheet->setCellValue('B96', 'Ví NL TMQ');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '96', !empty($value->vi_nl_tmq) ? $value->vi_nl_tmq : 0)
				->getStyle($arr[$key] . '96')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A97', '2');
		$this->sheet->setCellValue('B97', 'Ví Vimo VFC');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '97', !empty($value->vi_vimo_vfc) ? $value->vi_vimo_vfc : 0)
				->getStyle($arr[$key] . '97')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A98', '3');
		$this->sheet->setCellValue('B98', 'Ví Vimo Vay Mượn');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '98', !empty($value->vi_vimo_vaymuon) ? $value->vi_vimo_vaymuon : 0)
				->getStyle($arr[$key] . '98')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A99', '4');
		$this->sheet->setCellValue('B99', 'Ví VNDT');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '99', !empty($value->vi_vndt) ? $value->vi_vndt : 0)
				->getStyle($arr[$key] . '99')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A100', '5');
		$this->sheet->setCellValue('B100', 'TK Tech TMQ');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '100', !empty($value->vi_tech_tmq) ? $value->vi_tech_tmq : 0)
				->getStyle($arr[$key] . '100')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A101', '6');
		$this->sheet->setCellValue('B101', 'TK VPS');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '101', !empty($value->tong_tien_goc_vps) ? $value->tong_tien_goc_vps : 0)
				->getStyle($arr[$key] . '101')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A102', '6.1');
		$this->sheet->setCellValue('B102', 'Tổng tiền VPS đến hạn');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '102', !empty($value->actual_goc_lai_vps_den_han) ? $value->actual_goc_lai_vps_den_han : 0)
				->getStyle($arr[$key] . '102')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A103', '6.2');
		$this->sheet->setCellValue('B103', 'Tổng tiền VPS chưa đến hạn');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '103', !empty($value->goc_lai_vps_chua_den_han) ? $value->goc_lai_vps_chua_den_han : 0)
				->getStyle($arr[$key] . '103')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A104', '6.3');
		$this->sheet->setCellValue('B104', 'Tổng tiền VPS chưa đến hạn dự kiến đáo');
		foreach ($manually_enter as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '104', !empty($value->actual_tong_tien_vps_chua_den_han_du_kien_dao_1) ? $value->actual_tong_tien_vps_chua_den_han_du_kien_dao_1 : 0)
				->getStyle($arr[$key] . '104')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A105', '6.4');
		$this->sheet->setCellValue('B105', 'Tổng tiền VPS có thể sử dụng');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '105', !empty($value->actual_tong_tien_vps_co_the_su_dung) ? $value->actual_tong_tien_vps_co_the_su_dung : 0)
				->getStyle($arr[$key] . '105')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A106', '');
		$this->sheet->setCellValue('B106', 'Tổng tiền có thể sử dụng L2:');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '106', !empty($value->actual_tong_tien_co_the_su_dung_l2) ? $value->actual_tong_tien_co_the_su_dung_l2 : 0)
				->getStyle($arr[$key] . '106')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A107', 'II/');
		$this->sheet->setCellValue('B107', 'DÒNG TIỀN VÀO:');

		$this->sheet->setCellValue('A108', '1');
		$this->sheet->setCellValue('B108', 'Nhà đầu tư nạp tiền:');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '108', !empty($value->actual_nha_dau_tu_nap_tien) ? $value->actual_nha_dau_tu_nap_tien : 0)
				->getStyle($arr[$key] . '108')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A109', '');
		$this->sheet->setCellValue('B109', 'NĐT hợp tác');
		foreach ($manually_enter as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '109', !empty($value->actual_ndt_hop_tac) ? $value->actual_ndt_hop_tac : 0)
				->getStyle($arr[$key] . '109')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A110', '');
		$this->sheet->setCellValue('B110', 'NĐT App ví NL');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '110', !empty($value->nap_app_vi_nl) ? $value->nap_app_vi_nl : 0)
				->getStyle($arr[$key] . '110')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A111', '');
		$this->sheet->setCellValue('B111', 'NĐT App ví Vimo');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '111', !empty($value->nap_app_vi_vimo) ? $value->nap_app_vi_vimo : 0)
				->getStyle($arr[$key] . '111')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A112', '');
		$this->sheet->setCellValue('B112', 'NĐT App ví Vimo Vay Mượn');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '112', "-")
				->getStyle($arr[$key] . '112')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A113', '');
		$this->sheet->setCellValue('B113', 'VNDT');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '113', "-")
				->getStyle($arr[$key] . '113')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A114', '2');
		$this->sheet->setCellValue('B114', 'Nhận tiền L1');
		foreach ($manually_enter as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '114', !empty($value->actual_thanh_toan_ve_l2) ? $value->actual_thanh_toan_ve_l2 : 0)
				->getStyle($arr[$key] . '114')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A115', '3');
		$this->sheet->setCellValue('B115', 'Nhận khác:');
		foreach ($manually_enter as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '115', !empty($value->actual_nhan_khac) ? $value->actual_nhan_khac : 0)
				->getStyle($arr[$key] . '115')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A116', '');
		$this->sheet->setCellValue('B116', 'Tổng dòng tiền vào L2:');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '116', !empty($value->actual_tong_dong_tien_vao_l2) ? $value->actual_tong_dong_tien_vao_l2 : 0)
				->getStyle($arr[$key] . '116')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A117', 'III/');
		$this->sheet->setCellValue('B117', 'Dòng tiền ra');

		$this->sheet->setCellValue('A118', '1');
		$this->sheet->setCellValue('B118', 'Giải ngân');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '118', !empty($value->actual_giai_ngan) ? $value->actual_giai_ngan : 0)
				->getStyle($arr[$key] . '118')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A119', '');
		$this->sheet->setCellValue('B119', 'KH PGD');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '119', !empty($value->actual_kh_pgd) ? $value->actual_kh_pgd : 0)
				->getStyle($arr[$key] . '119')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A120', '');
		$this->sheet->setCellValue('B120', 'KH (Priority + nhà đất)');
		foreach ($manually_enter as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '120', !empty($value->actual_priority) ? $value->actual_priority : 0)
				->getStyle($arr[$key] . '120')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A121', '2');
		$this->sheet->setCellValue('B121', 'Thanh toán NĐT');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '121', !empty($value->actual_thanh_toan_ndt) ? $value->actual_thanh_toan_ndt : 0)
				->getStyle($arr[$key] . '121')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A122', '2.1');
		$this->sheet->setCellValue('B122', 'NĐT hợp tác');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '122', !empty($value->actual_ndt_hop_tac_1) ? $value->actual_ndt_hop_tac_1 : 0)
				->getStyle($arr[$key] . '122')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A123', '2.2');
		$this->sheet->setCellValue('B123', 'App NĐT NL');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '123', !empty($value->actual_app_vi_nl) ? $value->actual_app_vi_nl : 0)
				->getStyle($arr[$key] . '123')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A124', '2.3');
		$this->sheet->setCellValue('B124', 'App NĐT Vimo');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '124', !empty($value->actual_app_vi_vimo) ? $value->actual_app_vi_vimo : 0)
				->getStyle($arr[$key] . '124')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A125', '2.4');
		$this->sheet->setCellValue('B125', 'Vay mượn');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '125', "-")
				->getStyle($arr[$key] . '125')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A126', '2.5');
		$this->sheet->setCellValue('B126', 'VNDT');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '126', "-")
				->getStyle($arr[$key] . '126')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A127', '');
		$this->sheet->setCellValue('B127', 'Tổng dòng tiền ra L2');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '127', !empty($value->actual_tong_dong_tien_ra_l2) ? $value->actual_tong_dong_tien_ra_l2 : 0)
				->getStyle($arr[$key] . '127')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A128', 'IV/');
		$this->sheet->setCellValue('B128', 'Net CF adjust');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '128', !empty($value->actual_net_cf_budget_l2) ? $value->actual_net_cf_budget_l2 : 0)
				->getStyle($arr[$key] . '128')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A129', 'V/');
		$this->sheet->setCellValue('B129', 'Safety cash balance');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '129', !empty($totalBalance[0]->safety_cash_balance) ? $totalBalance[0]->safety_cash_balance : 0)
				->getStyle($arr[$key] . '129')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A130', 'VI/');
		$this->sheet->setCellValue('B130', 'Tổng tiền cần để đảm bảo thanh khoản cao nhất');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '130', !empty($value->actual_tong_tien_can_de_dam_bao_thanh_khoan_cao_nhat) ? $value->actual_tong_tien_can_de_dam_bao_thanh_khoan_cao_nhat : 0)
				->getStyle($arr[$key] . '130')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A131', 'VII/');
		$this->sheet->setCellValue('B131', 'Số dư TK tối thiếu');

		$this->sheet->setCellValue('A132', '1');
		$this->sheet->setCellValue('B132', 'Ví NL');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '132', !empty($value->actual_VI_vi_nl) ? $value->actual_VI_vi_nl : 0)
				->getStyle($arr[$key] . '132')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A133', '2');
		$this->sheet->setCellValue('B133', 'Ví Vimo VFC');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '133', !empty($value->actual_VI_vi_vimo_vfc) ? $value->actual_VI_vi_vimo_vfc : 0)
				->getStyle($arr[$key] . '133')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A134', '3');
		$this->sheet->setCellValue('B134', 'Ví Vimo Vay Mượn');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '134', "-")
				->getStyle($arr[$key] . '134')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}

		$this->sheet->setCellValue('A135', '3');
		$this->sheet->setCellValue('B135', 'Ví VNDT');
		foreach ($totalBalance as $key => $value) {
			$this->sheet->setCellValue($arr[$key] . '135', "-")
				->getStyle($arr[$key] . '135')
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		}


		$this->callLibExcel('CF - ' . date("m-Y") . '.xlsx');

	}

	public function exportLeadPGDCancel()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$fullname = !empty($_GET['fullname']) ? $_GET['fullname'] : "";
		$sdt = !empty($_GET['sdt']) ? $_GET['sdt'] : "";
		$cskh = !empty($_GET['cskh']) ? $_GET['cskh'] : "";
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "";
		$status_sale = !empty($_GET['status_sale_1']) ? $_GET['status_sale_1'] : "";
		$priority = !empty($_GET['priority']) ? $_GET['priority'] : "";
		$source = !empty($_GET['source_s']) ? $_GET['source_s'] : "";
		$data = [];
		if (strtotime($fdate) > strtotime($tdate) && !empty($tdate)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('lead_custom'));
		}
		if (!empty($fdate) && !empty($tdate)) {
			$data['start'] = strtotime($fdate);
			$data['end'] = strtotime($tdate);
		} elseif (!empty($fdate)) {
			$data['start'] = strtotime($fdate);
		} elseif (!empty($tdate)) {
			$data['end'] = strtotime($tdate);
		}

		if (!empty($fullname)) {
			$data['fullname'] = $fullname;
		}
		if (!empty($sdt)) {
			$data['sdt'] = $sdt;
		}
		if (!empty($cskh)) {
			$data['cskh'] = $cskh;
		}
		if (!empty($tab)) {
			$data['tab'] = $tab;
		}
		if (!empty($status_sale)) {
			$data['status_sale'] = $status_sale;
		}
		if (!empty($priority)) {
			$data['priority'] = $priority;
		}
		if (!empty($source)) {
			$data['source'] = $source;
		}
		$getLeadPGDCancel = $this->api->apiPost($this->userInfo['token'], 'lead_custom/getExcelLeadPGDCancel', $data);
		$reasonData = $this->api->apiPost($this->user['token'], "reason/get_all", []);
		if (!empty($reasonData->data) && $reasonData->status == 200) {
			$reason = $reasonData->data;
		} else {
			$reason = array();
		}
		if (!empty($getLeadPGDCancel->data)) {
			$this->exportExcelLeadPGDCancel($getLeadPGDCancel->data, $reason);

			var_dump($fdate . ' -- ' . $tdate);
		} else {
			var_dump("Không có dữ liệu để xuất excel");
		}
	}

	public function exportExcelLeadPGDCancel($data, $reason)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'HỌ TÊN');
		$this->sheet->setCellValue('C1', 'SĐT');
		$this->sheet->setCellValue('D1', 'CSKH');
		$this->sheet->setCellValue('E1', 'NGUỒN');
		$this->sheet->setCellValue('F1', 'TRẠNG THÁI');
		$this->sheet->setCellValue('G1', 'ĐỘ ƯU TIÊN');
		$this->sheet->setCellValue('H1', 'LÝ DO HỦY');
		$this->sheet->setCellValue('I1', 'PGD GHI CHÚ');
		$this->setStyle('A1');
		$this->setStyle('B1');
		$this->setStyle('C1');
		$this->setStyle('D1');
		$this->setStyle('E1');
		$this->setStyle('F1');
		$this->setStyle('G1');
		$this->setStyle('H1');
		$this->setStyle('I1');

		$i = 2;
		foreach ($data as $value) {
			foreach ($reason as $r) {
				if ($value->reason_cancel_pgd == $r->code_reason) {
					$reason_cancel_pgd = $r->reason_name;
				}
			}
			# code...
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($value->fullname) ? $value->fullname : "");
			$this->sheet->setCellValue('C' . $i, !empty($value->phone_number) ? $value->phone_number : "");
			$this->sheet->setCellValue('D' . $i, !empty($value->cskh) ? $value->cskh : "");
			$this->sheet->setCellValue('E' . $i, !empty($value->source) ? lead_nguon($value->source) : "");
			$this->sheet->setCellValue('F' . $i, !empty($value->status_sale) ? lead_status($value->status_sale) : "");
			$this->sheet->setCellValue('G' . $i, !empty($value->priority) ? lead_priority($value->priority) : "");
			$this->sheet->setCellValue('H' . $i, $reason_cancel_pgd);
			$this->sheet->setCellValue('I' . $i, !empty($value->pgd_note) ? $value->pgd_note : "");
			$i++;
		}
		$this->callLibExcel('Lead_PGD_Hủy' . date('d-m-Y') . '.xlsx');
	}

	/** Xuất dữ liệu phiếu thu thanh toán hoa hồng cho Cộng tác viên TienNgay
	 *
	 */
	public function exportTransactionCtv()
	{
		$dataGet = $this->input->get();
		$from_date = $dataGet['from_date'] ? $dataGet['from_date'] : '';
		$to_date = $dataGet['to_date'] ? $dataGet['to_date'] : '';
		$name_ctv = $dataGet['name_ctv'] ? $dataGet['name_ctv'] : '';
		$sdt_ctv = $dataGet['sdt_ctv'] ? $dataGet['sdt_ctv'] : '';
		$code = $dataGet['code'] ? $dataGet['code'] : '';
		$code_transaction_bank = $dataGet['code_transaction_bank'] ? $dataGet['code_transaction_bank'] : '';
		$status = $dataGet['status'] ? $dataGet['status'] : '';
		if (!empty($from_date) && !empty($to_date)) {
			if (strtotime($from_date) > strtotime($to_date)) {
				$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
				redirect(base_url('transaction/list_trans_ctv'));
			}
			if (empty($from_date) || $to_date) {
				$this->session->set_flashdata('error', $this->lang->line('Please_select_input_date'));
				redirect(base_url('transaction/list_trans_ctv'));
			}
		}
		$dataSend = array();
		$dataSend['per_page'] = 10000;
		$dataSend['from_date'] = $from_date;
		$dataSend['to_date'] = $to_date;
		$dataSend['name_ctv'] = $name_ctv;
		$dataSend['sdt_ctv'] = $sdt_ctv;
		$dataSend['code'] = $code;
		$dataSend['code_transaction_bank'] = $code_transaction_bank;
		$dataSend['status'] = $status;
		$response = $this->api->apiPost($this->userInfo['token'], 'transaction/get_transactions_ctv', $dataSend);
		if (!empty($response->data)) {
			$this->exportDetailTransCtv($response->data);
			var_dump($from_date . '--' . $to_date);
		} else {
			var_dump("Không có dữ liệu để xuất excel");
		}
	}

	public function exportDetailTransCtv($transactionCtvData)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Tên CTV');
		$this->sheet->setCellValue('C1', 'SĐT CTV');
		$this->sheet->setCellValue('D1', 'Mã PT');
		$this->sheet->setCellValue('E1', 'Loại PT');
		$this->sheet->setCellValue('F1', 'Số tiền');
		$this->sheet->setCellValue('G1', 'Trạng thái');
		$this->sheet->setCellValue('H1', 'Phương thức thanh toán');
		$this->sheet->setCellValue('I1', 'Ngân hàng');
		$this->sheet->setCellValue('J1', 'Mã giao dịch ngân hàng');
		$this->sheet->setCellValue('K1', 'Ghi chú');
		$this->sheet->setCellValue('L1', 'Ngày thanh toán');
		$this->sheet->setCellValue('M1', 'Thanh toán bởi');

		$this->setStyle('A1');
		$this->setStyle('B1');
		$this->setStyle('C1');
		$this->setStyle('D1');
		$this->setStyle('E1');
		$this->setStyle('F1');
		$this->setStyle('G1');
		$this->setStyle('H1');
		$this->setStyle('I1');
		$this->setStyle('J1');
		$this->setStyle('K1');
		$this->setStyle('L1');
		$this->setStyle('M1');
		$i = 2;
		foreach ($transactionCtvData as $transaction) {

			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($transaction->customer_bill_name) ? ($transaction->customer_bill_name) : "");
			$this->sheet->setCellValue('C' . $i, !empty($transaction->customer_bill_phone) ? ($transaction->customer_bill_phone) : "");
			$this->sheet->setCellValue('D' . $i, !empty($transaction->code) ? ($transaction->code) : "");
			$this->sheet->setCellValue('E' . $i, !empty($transaction->type) ? type_transaction($transaction->type) : "");
			$this->sheet->setCellValue('F' . $i, !empty($transaction->total) ? ($transaction->total) : "");
			$this->sheet->setCellValue('G' . $i, !empty($transaction->status) ? status_transaction($transaction->status) : "");
			$this->sheet->setCellValue('H' . $i, !empty($transaction->payment_method) ? ($transaction->payment_method) : "");
			$this->sheet->setCellValue('I' . $i, !empty($transaction->bank) ? $transaction->bank : "");
			$this->sheet->setCellValue('J' . $i, !empty($transaction->code_transaction_bank) ? $transaction->code_transaction_bank : "");
			$this->sheet->setCellValue('K' . $i, !empty($transaction->note) ? $transaction->note : "");
			$this->sheet->setCellValue('L' . $i, !empty($transaction->created_at) ? date('d/m/Y H:i:s', intval($transaction->created_at)) : "");
			$this->sheet->setCellValue('M' . $i, !empty($transaction->created_by) ? type_exception($transaction->created_by) : "-");
			$i++;
		}
		//---------------------------------------------------------------------
		$this->callLibExcel('PTThanhToanCTV' . time() . '.xlsx');
	}

	public function exportLeadPGDReturn()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$fullname = !empty($_GET['fullname']) ? $_GET['fullname'] : "";
		$sdt = !empty($_GET['sdt']) ? $_GET['sdt'] : "";
		$cskh = !empty($_GET['cskh']) ? $_GET['cskh'] : "";
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "";
		$status_sale = !empty($_GET['status_sale_1']) ? $_GET['status_sale_1'] : "";
		$priority = !empty($_GET['priority']) ? $_GET['priority'] : "";
		$source = !empty($_GET['source_s']) ? $_GET['source_s'] : "";
		$data = [];
		if (strtotime($fdate) > strtotime($tdate) && !empty($tdate)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('lead_custom'));
		}
		if (!empty($fdate) && !empty($tdate)) {
			$data['start'] = strtotime($fdate);
			$data['end'] = strtotime($tdate);
		} elseif (!empty($fdate)) {
			$data['start'] = strtotime($fdate);
		} elseif (!empty($tdate)) {
			$data['end'] = strtotime($tdate);
		}

		if (!empty($fullname)) {
			$data['fullname'] = $fullname;
		}
		if (!empty($sdt)) {
			$data['sdt'] = $sdt;
		}
		if (!empty($cskh)) {
			$data['cskh'] = $cskh;
		}
		if (!empty($tab)) {
			$data['tab'] = $tab;
		}
		if (!empty($status_sale)) {
			$data['status_sale'] = $status_sale;
		}
		if (!empty($priority)) {
			$data['priority'] = $priority;
		}
		if (!empty($source)) {
			$data['source'] = $source;
		}
		$getLeadPGDReturn = $this->api->apiPost($this->userInfo['token'], 'lead_custom/getExcelLeadPGDReturn', $data);
		if (!empty($getLeadPGDReturn->data)) {
			$this->exportExcelLeadPGDReturn($getLeadPGDReturn->data);
			var_dump($fdate . ' -- ' . $tdate);
		} else {
			var_dump("Không có dữ liệu để xuất excel");
		}
	}

	public function exportExcelLeadPGDReturn($data)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'HỌ TÊN');
		$this->sheet->setCellValue('C1', 'SĐT');
		$this->sheet->setCellValue('D1', 'CSKH');
		$this->sheet->setCellValue('E1', 'NGUỒN');
		$this->sheet->setCellValue('F1', 'TRẠNG THÁI');
		$this->sheet->setCellValue('G1', 'ĐỘ ƯU TIÊN');
		$this->sheet->setCellValue('H1', 'LÝ DO TRẢ VỀ');


		$this->setStyle('A1');
		$this->setStyle('B1');
		$this->setStyle('C1');
		$this->setStyle('D1');
		$this->setStyle('E1');
		$this->setStyle('F1');
		$this->setStyle('G1');
		$this->setStyle('H1');

		$i = 2;
		foreach ($data as $value) {
			# code...
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($value->fullname) ? $value->fullname : "");
			$this->sheet->setCellValue('C' . $i, !empty($value->phone_number) ? $value->phone_number : "");
			$this->sheet->setCellValue('D' . $i, !empty($value->cskh) ? $value->cskh : "");
			$this->sheet->setCellValue('E' . $i, !empty($value->source) ? lead_nguon($value->source) : "");
			$this->sheet->setCellValue('F' . $i, !empty($value->status_sale) ? lead_status($value->status_sale) : "");
			$this->sheet->setCellValue('G' . $i, !empty($value->priority) ? lead_priority($value->priority) : "");
			$this->sheet->setCellValue('H' . $i, !empty($value->pgd_note) ? $value->pgd_note : "");

			$i++;
		}
		$this->callLibExcel('Lead_PGD_Trả_Về' . date('d-m-Y') . '.xlsx');
	}

	function exportPGD_NIN_BDS()
	{

		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$data = array();
		if (!empty($fdate)) $data['start'] = $fdate;
		if (!empty($tdate)) $data['end'] = $tdate;

		$dataLead = $this->api->apiPost($this->userInfo['token'], "report_kpi/exportPGD_NIN_BDS", $data);
		if (!empty($dataLead->data)) {
			$this->exportPGD_NIN_BDS_data($dataLead->data);

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	function exportPGD_NIN_BDS_data($data)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'TÊN PGD');
		$this->sheet->setCellValue('C1', 'DƯ NỢ TRONG HẠN T+10');

		$this->setStyle_dataT10('A1');
		$this->setStyle_dataT10('B1');
		$this->setStyle_dataT10('C1');

		$i = 2;
		foreach ($data as $value) {
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($value->store_name) ? $value->store_name : "");
			$this->sheet->setCellValue('C' . $i, !empty($value->total_du_no_trong_han_t10_old) ? $value->total_du_no_trong_han_t10_old : "")
				->getStyle('C' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$i++;
		}
		$this->callLibExcel('Export Dư nợ T+10 PGD - ' . date('d-m-Y') . '.xlsx');
	}

	function exportUser_NIN_BDS()
	{
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		$data = array();
		if (!empty($fdate)) $data['start'] = $fdate;
		if (!empty($tdate)) $data['end'] = $tdate;

		$dataLead = $this->api->apiPost($this->userInfo['token'], "report_kpi/exportUser_NIN_BDS", $data);
		if (!empty($dataLead->data)) {
			$this->exportUser_NIN_BDS_data($dataLead->data);

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	function exportUser_NIN_BDS_data($data)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'EMAIL GDV');
		$this->sheet->setCellValue('C1', 'DƯ NỢ TRONG HẠN T+10');

		$this->setStyle_dataT10('A1');
		$this->setStyle_dataT10('B1');
		$this->setStyle_dataT10('C1');

		$i = 2;
		foreach ($data as $value) {
			$this->sheet->setCellValue('A' . $i, ($i - 1));
			$this->sheet->setCellValue('B' . $i, !empty($value->created_by) ? $value->created_by : "");
			$this->sheet->setCellValue('C' . $i, !empty($value->total_du_no_trong_han_t10_old) ? $value->total_du_no_trong_han_t10_old : "")
				->getStyle('C' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$i++;
		}
		$this->callLibExcel('Export Dư nợ T+10 GDV - ' . date('d-m-Y') . '.xlsx');
	}

	function export_digital_mkt()
	{

		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : date('Y-m-d');
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : date('Y-m-d');
		$area_search = !empty($_GET['area_search']) ? $_GET['area_search'] : "";

		$data = array();
		if (!empty($fdate)) $data['fdate'] = $fdate;
		if (!empty($tdate)) $data['tdate'] = $tdate;
		if (!empty($area_search)) $data['area_search'] = $area_search;

		$dataLead = $this->api->apiPost($this->userInfo['token'], "dashboard_telesale/report_digital_mkt", $data);

		if (!empty($dataLead->data)) {
			$this->export_digital_mkt_data($dataLead->data, $dataLead->table_top);

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	function export_digital_mkt_data($data, $table_top)
	{

		$this->sheet->setCellValue('A1', 'Phòng giao dịch');
		$this->sheet->setCellValue('B1', 'Facebook');
		$this->sheet->setCellValue('C1', 'Google');
		$this->sheet->setCellValue('D1', 'Tiktok');
		$this->sheet->setCellValue('E1', 'Khác');
		$this->sheet->setCellValue('F1', 'Tổng');


		$i = 2;
		foreach ($table_top as $value) {
			$this->sheet->setCellValue('A' . $i, !empty($value->name) ? ($value->name) : "");
			$this->sheet->setCellValue('B' . $i, !empty($value->facebook) ? ($value->facebook) : 0)
				->getStyle('B' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('C' . $i, !empty($value->google) ? ($value->google) : 0)
				->getStyle('C' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('D' . $i, !empty($value->tiktok) ? ($value->tiktok) : 0)
				->getStyle('D' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('E' . $i, !empty($value->khac) ? ($value->khac) : 0)
				->getStyle('E' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('F' . $i, !empty($value->total) ? ($value->total) : 0)
				->getStyle('F' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$i++;
		}

		$this->sheet->setCellValue('A10', 'Phòng giao dịch');
		$this->sheet->setCellValue('B10', 'Facebook');
		$this->sheet->setCellValue('E10', 'Google');
		$this->sheet->setCellValue('H10', 'Tiktok');
		$this->sheet->setCellValue('K10', 'Khác');
		$this->sheet->setCellValue('N10', 'Tổng');

		$this->sheet->setCellValue('B11', 'Lead qualified');
		$this->sheet->setCellValue('C11', 'Doanh số giải ngân');
		$this->sheet->setCellValue('D11', 'Chi phí MKT / Giải ngân');

		$this->sheet->setCellValue('E11', 'Lead qualified');
		$this->sheet->setCellValue('F11', 'Doanh số giải ngân');
		$this->sheet->setCellValue('G11', 'Chi phí MKT / Giải ngân');

		$this->sheet->setCellValue('H11', 'Lead qualified');
		$this->sheet->setCellValue('I11', 'Doanh số giải ngân');
		$this->sheet->setCellValue('J11', 'Chi phí MKT / Giải ngân');

		$this->sheet->setCellValue('K11', 'Lead qualified');
		$this->sheet->setCellValue('L11', 'Doanh số giải ngân');
		$this->sheet->setCellValue('M11', 'Chi phí MKT / Giải ngân');

		$this->sheet->setCellValue('N11', 'Lead qualified');
		$this->sheet->setCellValue('O11', 'Doanh số giải ngân');


		$this->sheet->mergeCells("A10:A11");
		$this->sheet->mergeCells("B10:D10");
		$this->sheet->mergeCells("E10:G10");
		$this->sheet->mergeCells("H10:J10");
		$this->sheet->mergeCells("K10:M10");
		$this->sheet->mergeCells("N10:O10");

		$i = 12;
		foreach ($data as $value) {
			$this->sheet->setCellValue('A' . $i, !empty($value->name_store) ? ($value->name_store) : "");
			$this->sheet->setCellValue('B' . $i, !empty($value->facebook_leadQLF) ? ($value->facebook_leadQLF) : 0)
				->getStyle('B' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('C' . $i, !empty($value->facebook_amountMoney) ? ($value->facebook_amountMoney) : 0)
				->getStyle('C' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('D' . $i, !empty($value->facebook_costAmountMoney) ? ($value->facebook_costAmountMoney) : 0)
				->getStyle('D' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('E' . $i, !empty($value->google_leadQLF) ? ($value->google_leadQLF) : 0)
				->getStyle('E' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('F' . $i, !empty($value->google_amountMoney) ? ($value->google_amountMoney) : 0)
				->getStyle('F' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('G' . $i, !empty($value->google_costAmountMoney) ? ($value->google_costAmountMoney) : 0)
				->getStyle('G' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('H' . $i, !empty($value->tiktok_leadQLF) ? ($value->tiktok_leadQLF) : 0)
				->getStyle('H' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('I' . $i, !empty($value->tiktok_amountMoney) ? ($value->tiktok_amountMoney) : 0)
				->getStyle('I' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('J' . $i, !empty($value->tiktok_costAmountMoney) ? ($value->tiktok_costAmountMoney) : 0)
				->getStyle('J' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('K' . $i, !empty($value->khac_leadQLF) ? ($value->khac_leadQLF) : 0)
				->getStyle('K' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('L' . $i, !empty($value->khac_amountMoney) ? ($value->khac_amountMoney) : 0)
				->getStyle('L' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('M' . $i, !empty($value->khac_costAmountMoney) ? ($value->khac_costAmountMoney) : 0)
				->getStyle('M' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('N' . $i, !empty($value->total_leadQLF) ? ($value->total_leadQLF) : 0)
				->getStyle('N' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('O' . $i, !empty($value->total_amountMoney) ? ($value->total_amountMoney) : 0)
				->getStyle('O' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$i++;
		}

		$this->callLibExcel('Export report digital marketing' . date('d-m-Y') . '.xlsx');
	}

	public function export_report_debt(){

		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : date('Y-m-d');

		$data = array();
		if (!empty($tdate)) $data['tdate'] = $tdate;

		$dataLead = $this->api->apiPost($this->userInfo['token'], "report_kpi/get_all_data_mongo_read_excel", $data);

		if (!empty($dataLead->data)) {
			$this->export_report_debt_data($dataLead->data);

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	function export_report_debt_data($data){
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('C1', 'Mã hợp đồng');
		$this->sheet->setCellValue('D1', 'Số tiền vay');
		$this->sheet->setCellValue('E1', 'Sản phẩm vay');
		$this->sheet->setCellValue('F1', 'Kỳ hạn vay');
		$this->sheet->setCellValue('G1', 'Ngày giải ngân');
		$this->sheet->setCellValue('H1', 'Ngày đáo hạn');
		$this->sheet->setCellValue('I1', 'Ngày chậm trả');
		$this->sheet->setCellValue('J1', 'Phòng giao dịch');
		$this->sheet->setCellValue('K1', 'Dư nợ');
		$this->sheet->setCellValue('L1', 'Dư nợ trong hạn T+10');
		$this->sheet->setCellValue('M1', 'Dư nợ B0 (B0 <= 0)');
		$this->sheet->setCellValue('N1', 'Dư nợ B1 (1 <= B1 <= 30)');
		$this->sheet->setCellValue('O1', 'Dư nợ B2 (31 <= B2 <= 60)');
		$this->sheet->setCellValue('P1', 'Dư nợ B3 (61 <= B3 <= 90)');
		$this->sheet->setCellValue('Q1', 'Dư nợ B4+ (90 < B4+)');
		$this->sheet->setCellValue('R1', 'Trạng thái');


		$i = 2;
		foreach ($data as $key => $value) {

			$du_no_trong_han = 0;
			$du_no_b0 = 0;
			$du_no_b1 = 0;
			$du_no_b2 = 0;
			$du_no_b3 = 0;
			$du_no_b4 = 0;

			if($value->data->status != 19){
				if($value->data->debt->so_ngay_cham_tra <= 10){
					$du_no_trong_han =  ($value->data->debt->tong_tien_goc_con);
				}
				if ($value->data->debt->so_ngay_cham_tra <= 0){
					$du_no_b0 = ($value->data->debt->tong_tien_goc_con);
				} elseif ($value->data->debt->so_ngay_cham_tra >= 1 && $value->data->debt->so_ngay_cham_tra <= 30){
					$du_no_b1 = ($value->data->debt->tong_tien_goc_con);
				} elseif ($value->data->debt->so_ngay_cham_tra >= 31 && $value->data->debt->so_ngay_cham_tra <= 60){
					$du_no_b2 = ($value->data->debt->tong_tien_goc_con);
				} elseif ($value->data->debt->so_ngay_cham_tra >= 61 && $value->data->debt->so_ngay_cham_tra <= 90){
					$du_no_b3 = ($value->data->debt->tong_tien_goc_con);
				} else {
					$du_no_b4 = ($value->data->debt->tong_tien_goc_con);
				}
			}



			$this->sheet->setCellValue('A' . $i, ++$key);
			$this->sheet->setCellValue('B' . $i, !empty($value->data->code_contract) ? $value->data->code_contract : "");
			$this->sheet->setCellValue('C' . $i, !empty($value->data->code_contract_disbursement) ? $value->data->code_contract_disbursement : "");
			$this->sheet->setCellValue('D' . $i, !empty($value->data->loan_infor->amount_money) ? $value->data->loan_infor->amount_money : "")
				->getStyle('D' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('E' . $i, !empty($value->data->loan_infor->type_property->text) ? $value->data->loan_infor->type_property->text : "");
			$this->sheet->setCellValue('F' . $i, !empty($value->data->loan_infor->number_day_loan) ? $value->data->loan_infor->number_day_loan / 30 : "");
			$this->sheet->setCellValue('G' . $i,  !empty($value->data->disbursement_date) ? date('d/m/Y', $value->data->disbursement_date) : 0);
			$this->sheet->setCellValue('H' . $i,  !empty($value->data->debt->ky_tt_xa_nhat) ? date('d/m/Y', $value->data->debt->ky_tt_xa_nhat) : 0);
			$this->sheet->setCellValue('I' . $i,  !empty($value->data->debt->so_ngay_cham_tra) ? $value->data->debt->so_ngay_cham_tra : 0);
			$this->sheet->setCellValue('J' . $i,  !empty($value->data->store->name) ? $value->data->store->name : "");
			$this->sheet->setCellValue('K' . $i,  ($value->data->status != 19)  ? ($value->data->debt->tong_tien_goc_con) : 0)
				->getStyle('K' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('L' . $i,  !empty($du_no_trong_han) ? $du_no_trong_han : 0)
				->getStyle('L' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('M' . $i,  !empty($du_no_b0) ? $du_no_b0 : 0)
				->getStyle('M' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('N' . $i,  !empty($du_no_b1) ? $du_no_b1 : 0)
				->getStyle('N' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('O' . $i,  !empty($du_no_b2) ? $du_no_b2 : 0)
				->getStyle('O' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('P' . $i,  !empty($du_no_b3) ? $du_no_b3 : 0)
				->getStyle('P' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('Q' . $i,  !empty($du_no_b4) ? $du_no_b4 : 0)
				->getStyle('Q' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('R' . $i, !empty($value->data->status) ? contract_status($value->data->status) : "");
			$i++;
		}

		$this->callLibExcel('Export report debt' . date('d-m-Y') . '.xlsx');
	}

	public function index_report_debt_total(){

		$month = !empty($_GET['date']) ? $_GET['date'] : date('Y-m-d');
		$data = [];
		if (!empty($month)) {
			$data['date'] = $month;
		}

		$contractData = $this->api->apiPost($this->userInfo['token'], "report_kpi/get_all_data_total_mongo_read", $data);

		if (!empty($contractData->data)) {
			$this->index_report_debt_total_data($contractData->data);

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}

	}

	public function index_report_debt_total_bds(){

		$month = !empty($_GET['date']) ? $_GET['date'] : date('Y-m-d');
		$data = [];
		if (!empty($month)) {
			$data['date'] = $month;
		}

		$contractData = $this->api->apiPost($this->userInfo['token'], "report_kpi/get_all_data_total_bds_mongo_read", $data);

		if (!empty($contractData->data)) {
			$this->index_report_debt_total_data($contractData->data);

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}

	}

	function index_report_debt_total_data($data){

		$this->sheet->setCellValue('A1', 'Tên PGD');
		$this->sheet->setCellValue('B1', 'Địa chỉ PGD');
		$this->sheet->setCellValue('C1', 'Tỉnh');
		$this->sheet->setCellValue('D1', 'Khu vực');
		$this->sheet->setCellValue('E1', 'Miền');
		$this->sheet->setCellValue('F1', 'Số HĐ xe máy');
		$this->sheet->setCellValue('G1', 'Số HĐ ô tô');
		$this->sheet->setCellValue('H1', 'Số HĐ vay 1T');
		$this->sheet->setCellValue('I1', 'Số HĐ vay 3T');
		$this->sheet->setCellValue('J1', 'Số HĐ vay lớn hơn 6T');
		$this->sheet->setCellValue('K1', 'Bảo hiểm');
		$this->sheet->setCellValue('L1', 'Tiền giải ngân mới trong kỳ');
		$this->sheet->setCellValue('M1', 'Dư nợ trong hạn T+10 kỳ trước');
		$this->sheet->setCellValue('N1', 'Dư nợ trong hạn T+10 hiện tại');
		$this->sheet->setCellValue('O1', 'Dư nợ tăng net T+10');
		$this->sheet->setCellValue('P1', 'Dư nợ quản lý');
		$this->sheet->setCellValue('Q1', 'Dư nợ tăng net');
		$this->sheet->setCellValue('R1', 'Dư nợ B0 (B0 <= 0)');
		$this->sheet->setCellValue('S1', 'Dư nợ B1 (1 <= B1 <= 30)');
		$this->sheet->setCellValue('T1', 'Dư nợ B2 (31 <= B2 <= 60)');
		$this->sheet->setCellValue('U1', 'Dư nợ B3 (61 <= B3 <= 90)');
		$this->sheet->setCellValue('V1', 'Dư nợ B4+ (90 < B4+)');

		$i = 2;
		foreach ($data as $key => $value) {

			$this->sheet->setCellValue('A' . $i, !empty($value->name) ? $value->name : '');
			$this->sheet->setCellValue('B' . $i, !empty($value->address) ? $value->address : '');
			$this->sheet->setCellValue('C' . $i, !empty($value->province) ? $value->province : '');
			$this->sheet->setCellValue('D' . $i, !empty($value->code_area) ? $value->code_area : '');
			$this->sheet->setCellValue('E' . $i, !empty($value->area) ? $value->area : '');
			$this->sheet->setCellValue('F' . $i, !empty($value->count_hd_xm) ? number_format($value->count_hd_xm) : 0);
			$this->sheet->setCellValue('G' . $i, !empty($value->count_hd_oto) ? number_format($value->count_hd_oto) : 0);
			$this->sheet->setCellValue('H' . $i, !empty($value->count_hd_1) ? number_format($value->count_hd_1) : 0);
			$this->sheet->setCellValue('I' . $i, !empty($value->count_hd_3) ? number_format($value->count_hd_3) : 0);
			$this->sheet->setCellValue('J' . $i, !empty($value->count_hd_6) ? number_format($value->count_hd_6) : 0);

			$this->sheet->setCellValue('K' . $i, !empty($value->bao_hiem) ? $value->bao_hiem : 0)
				->getStyle('K' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$this->sheet->setCellValue('L' . $i, !empty($value->amount_money) ? $value->amount_money : 0)
				->getStyle('L' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$this->sheet->setCellValue('M' . $i, !empty($value->du_no_trong_han_T10_ky_truoc) ? $value->du_no_trong_han_T10_ky_truoc : 0)
				->getStyle('M' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$this->sheet->setCellValue('N' . $i, !empty($value->du_no_trong_han_T10_hien_tai) ? $value->du_no_trong_han_T10_hien_tai : 0)
				->getStyle('N' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$this->sheet->setCellValue('O' . $i, !empty($value->du_no_tang_net_T10) ? $value->du_no_tang_net_T10 : 0)
				->getStyle('O' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$this->sheet->setCellValue('P' . $i, !empty($value->du_no_quan_ly) ? $value->du_no_quan_ly : 0)
				->getStyle('P' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$this->sheet->setCellValue('Q' . $i, !empty($value->du_no_tang_net) ? $value->du_no_tang_net : 0)
				->getStyle('Q' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$this->sheet->setCellValue('R' . $i, !empty($value->total_du_no_b0) ? $value->total_du_no_b0 : 0)
				->getStyle('R' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$this->sheet->setCellValue('S' . $i, !empty($value->total_du_no_b1) ? $value->total_du_no_b1 : 0)
				->getStyle('S' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$this->sheet->setCellValue('T' . $i, !empty($value->total_du_no_b2) ? $value->total_du_no_b2 : 0)
				->getStyle('T' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$this->sheet->setCellValue('U' . $i, !empty($value->total_du_no_b3) ? $value->total_du_no_b3 : 0)
				->getStyle('U' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$this->sheet->setCellValue('V' . $i, !empty($value->total_du_no_b4) ? $value->total_du_no_b4 : 0)
				->getStyle('V' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$i++;
		}

		$this->callLibExcel('Export report debt' . date('d-m-Y') . '.xlsx');

	}

	public function exportListVbiTnds()
	{
		$tab = !empty($_GET['tab']) ? $_GET['tab'] : "mic_tnds";
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$customer_phone = !empty($_GET['customer_phone']) ? $_GET['customer_phone'] : "";
		$code = !empty($_GET['code']) ? $_GET['code'] : "";

		$data = array();
		$data['start'] = !empty($fdate) ? $fdate : "";
		$data['end'] = !empty($tdate) ? $tdate : "";
		$data['customer_phone'] = $customer_phone;
		$data['code'] = $code;

		$data['access_token'] = $this->user['token'];
		$cpanelV2 = CpanelV2::getDomain();
		$url = $cpanelV2 . "cpanel/exportExcel/exportVbiTnds?";
		$first = true;
		foreach ($data as $key => $value) {
			if ($first) {
				$url .= $key . "=" . $value;
			} else {
				$url .= "&" . $key . "=" . $value;
			}
			$first = false;
		}
		redirect($url);
	}

}

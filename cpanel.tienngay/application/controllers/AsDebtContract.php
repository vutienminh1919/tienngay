<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

if (!defined('BASEPATH')) exit('No direct script access allowed');


class AsDebtContract extends MY_Controller
{
	private $spreadsheet;
	private $sheet;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model("store_model");
		$this->load->model("time_model");
		$this->load->model("contract_model");
		$this->load->library('pagination');
		$this->load->helper('location_helper');
		$this->load->helper('lead_helper');
		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
//		if (!$this->is_superadmin) {
//			$paramController = $this->uri->segment(1);
//			$param = strtolower($paramController);
//			if (!in_array($param, $this->paramMenus)) {
//				$this->session->set_flashdata('error', $this->lang->line('not_have_permission') . ' ' . $paramController . '!');
//				redirect(base_url('app'));
//				return;
//			}
//		}
		$this->spreadsheet = new Spreadsheet();
		$this->sheet = $this->spreadsheet->getActiveSheet();
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	public function process()
	{
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$phone_number = !empty($_GET['phone_number']) ? $_GET['phone_number'] : "";
		$id_card = !empty($_GET['id_card']) ? $_GET['id_card'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$bucket = !empty($_GET['bucket']) ? $_GET['bucket'] : "";
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$vung_mien = !empty($_GET['vung_mien']) ? $_GET['vung_mien'] : "";
		// $disbursement_date = !empty($_GET['disbursement_date']) ? $_GET['disbursement_date'] : "";
		// điều kiện để lấy bản ghi
		$condition = array(
			'status_disbursement' => 3, //1 moi tao, 2: tạo giải ngân thành công, 3// tiền đến với khách, 4 thất bại
			'status' => $status   // 17: giải ngân thành công, 18: giải ngân thất bại
		);
		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('accountant/contract_v2'));
		}
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$condition['start'] = $start;
			$condition['end'] = $end;
		}
		// if ((empty($start) && empty($end))) {
		// 	$this->session->set_flashdata('error', "Hãy chọn thời gian!");
		// 	redirect(base_url('accountant/contract_v2'));
		// }
		if (!empty($store)) {
			$condition['store_id'] = trim($store);
		}

		if (!empty($id_card)) {
			$condition['id_card'] = trim($id_card);
		}
		if (!empty($bucket)) {
			$condition['bucket'] = trim($bucket);
		}
		if (!empty($customer_name)) {
			$condition['customer_name'] = trim($customer_name);
		}
		if (!empty($phone_number)) {
			$condition['customer_phone_number'] = $phone_number;
		}
		if (!empty($status)) {
			$condition['status'] = $status;
		}
		if (!empty($code_contract_disbursement)) {
			$condition['code_contract_disbursement'] = trim($code_contract_disbursement);
		}
		if (!empty($code_contract)) {
			$condition['code_contract'] = trim($code_contract);
		}
		if (!empty($vung_mien)) {
			$condition['vung_mien'] = trim($vung_mien);
		}
		// if (!empty($disbursement_date)) {
		// 	$condition['disbursement_date'] = trim($disbursement_date);
		// }

		$total = $this->api->apiPost($this->userInfo['token'], "contract/count_contract_tempo", ['condition' => $condition]);
		if ($total->total > 3000) {
			$this->session->set_flashdata('error', "Số lượng cần xuất nhỏ hơn 3000, hãy chọn lại điều kiện xuất. ");
			redirect(base_url('accountant/contract_v2'));
		} else {

			$contractData = $this->api->apiPost($this->userInfo['token'], "contract/contract_tempo_excel", ['condition' => $condition, 'per_page' => 10000]);
			if (!empty($contractData->status) && $contractData->status == 200) {
				$this->export_part1($contractData->data);
				$this->export_part2($contractData->data);
				$this->callLibExcel('data-debt_contract-' . time() . '.xlsx');
			} else {
				$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
				redirect(base_url('accountant/contract_v2'));
			}
		}
	}

	private function export_part1($contractData)
	{
		$this->sheet->setCellValue('A1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('B1', 'Mã hợp đồng');
		$this->sheet->setCellValue('C1', 'Tên khách hàng');
		$this->sheet->setCellValue('D1', 'Số tiền giải ngân');
		$this->sheet->setCellValue('E1', 'Hình thức vay');
		$this->sheet->setCellValue('F1', 'Sản phẩm vay');
		$this->sheet->setCellValue('G1', 'Tiền kỳ');
		$this->sheet->setCellValue('H1', 'Ngày trễ');
		$this->sheet->setCellValue('I1', 'Bucket');

		$this->setStyle("A1");
		$this->setStyle("B1");
		$this->setStyle("C1");
		$this->setStyle("D1");
		$this->setStyle("E1");
		$this->setStyle("F1");
		$this->setStyle("G1");
		$this->setStyle("H1");
		$this->setStyle("I1");

		$i = 2;
		foreach ($contractData as $item) {
			$typePay = "";
			$type_interest = !empty($item->loan_infor->type_interest) ? $item->loan_infor->type_interest : "";
			if ($type_interest == 1) {
				$typePay = "Lãi hàng tháng, gốc hàng tháng";
			} else {
				$typePay = "Lãi hàng tháng, gốc cuối kỳ";
			}
			$this->sheet->setCellValue('A' . $i, !empty($item->code_contract) ? $item->code_contract : '');
			$this->sheet->setCellValue('B' . $i, !empty($item->code_contract_disbursement) ? $item->code_contract_disbursement : '');
			$this->sheet->setCellValue('C' . $i, !empty($item->customer_infor->customer_name) ? $item->customer_infor->customer_name : "");
			$this->sheet->setCellValue('D' . $i, !empty($item->loan_infor->amount_money) ? $item->loan_infor->amount_money : "");
			$this->sheet->setCellValue('E' . $i, $typePay . ' ' . $item->loan_infor->number_day_loan / 30 . ' tháng');
			$this->sheet->setCellValue('F' . $i, !empty($item->loan_infor->type_property->text) ? $item->loan_infor->type_property->text : 0);
			$this->sheet->setCellValue('G' . $i, !empty($item->lai_ki->tien_tra_1_ky) ? number_format(round($item->lai_ki->tien_tra_1_ky)) : '');
			$this->sheet->setCellValue('H' . $i, !empty($item->debt->so_ngay_cham_tra) ? $item->debt->so_ngay_cham_tra : "");
			$this->sheet->setCellValue('I' . $i, !empty($item->debt->so_ngay_cham_tra) ? get_bucket($item->debt->so_ngay_cham_tra) : "");
			$i++;
		}
	}

	private function export_part2($contractData)
	{


		$this->sheet->setCellValue('J1', 'Số kỳ đã thanh toán');
		$this->sheet->setCellValue('K1', 'Gốc còn lại');
		$this->sheet->setCellValue('L1', 'PGD');
		$this->sheet->setCellValue('M1', 'CMT/CCCD/Hộ chiếu');
		$this->sheet->setCellValue('N1', 'Số điện thoại');
		$this->sheet->setCellValue('O1', 'Tỉnh hộ khẩu');
		$this->sheet->setCellValue('P1', 'Quận/Huyện Hộ khẩu');
		$this->sheet->setCellValue('Q1', 'Xã/Phường Hộ khẩu');
		$this->sheet->setCellValue('R1', 'Địa chỉ hộ khẩu');
		$this->sheet->setCellValue('S1', 'Quận/Huyện theo HĐ đang vay (PGD KH ĐANG VAY)');
		$this->sheet->setCellValue('T1', 'Tỉnh/ Theo HĐ đang vay (PGD KH ĐANG VAY)');
		$this->sheet->setCellValue('U1', 'Khu vực/ Theo HĐ đang vay (PGD KH ĐANG VAY)');
		$this->sheet->setCellValue('V1', 'Code trạng thái');
		$this->sheet->setCellValue('W1', 'Địa chỉ tạm trú');
		$this->sheet->setCellValue('X1', 'Địa chỉ nơi làm việc');
		$this->sheet->setCellValue('Y1', 'KT1');
		$this->sheet->setCellValue('Z1', 'Ngày giải ngân');
		$this->sheet->setCellValue('AA1', 'Gắn định vị');
		$this->sheet->setCellValue('AB1', 'IMEI Device VSET');
		$this->sheet->setCellValue('AC1', 'CVKD tạo hợp đồng');
		$this->sheet->setCellValue('AD1', 'Người theo dõi hợp đồng');
		$this->sheet->setCellValue('AE1', 'Nội dung chi tiết việc làm Call');


		$this->setStyle("J1");
		$this->setStyle("K1");
		$this->setStyle("L1");
		$this->setStyle("M1");
		$this->setStyle("N1");
		$this->setStyle("O1");
		$this->setStyle("P1");
		$this->setStyle("Q1");
		$this->setStyle("R1");
		$this->setStyle("S1");

		$this->setStyle("T1");
		$this->setStyle("U1");
		$this->setStyle("V1");
		$this->setStyle("W1");
		$this->setStyle("X1");
		$this->setStyle("Y1");
		$this->setStyle("Z1");
		$this->setStyle("AA1");
		$this->setStyle("AB1");
		$this->setStyle("AC1");
		$this->setStyle("AD1");
		$this->setStyle("AE1");

		$i = 2;
		foreach ($contractData as $item) {
			$is_device_vset = 'Không có';
			if (!empty($item->loan_infor->device_asset_location)) {
				$is_device_vset = 'Có';
			} else {
				$is_device_vset = 'Không có';
			}

			$dataStore = $this->api->apiPost($this->userInfo['token'], "store/get_store", ['id' => $item->store->id]);

			$this->sheet->setCellValue('J' . $i, !empty($item->so_ki_thanh_toan) ? $item->so_ki_thanh_toan : 0);
			$this->sheet->setCellValue('K' . $i, !empty($item->original_debt->du_no_goc_con_lai) ? number_format(round($item->original_debt->du_no_goc_con_lai)) : 0);
			$this->sheet->setCellValue('L' . $i, !empty($item->store->name) ? $item->store->name . ', ' . $dataStore->data->province->name  : '');
			$this->sheet->setCellValue('M' . $i, !empty($item->customer_infor->customer_identify) ? $item->customer_infor->customer_identify ?: $item->customer_infor->passport_number : '');
			$this->sheet->setCellValue('N' . $i, !empty($item->customer_infor->customer_phone_number) ? ($item->customer_infor->customer_phone_number) : '');
			$this->sheet->setCellValue('O' . $i, !empty($item->houseHold_address->province_name) ? $item->houseHold_address->province_name : '');
			$this->sheet->setCellValue('P' . $i, !empty($item->houseHold_address->district_name) ? $item->houseHold_address->district_name : '');
			$this->sheet->setCellValue('Q' . $i, !empty($item->houseHold_address->ward_name) ? $item->houseHold_address->ward_name : '');
			$this->sheet->setCellValue('R' . $i, !empty($item->houseHold_address->address_household) ? $item->houseHold_address->address_household : '');

			$this->sheet->setCellValue('S' . $i, !empty($dataStore->data->district->name) ? $dataStore->data->district->name : '');
			$this->sheet->setCellValue('T' . $i, !empty($dataStore->data->province->name) ? $dataStore->data->province->name : '');
			$this->sheet->setCellValue('U' . $i, !empty($dataStore->data->code_area) ? name_area($dataStore->data->code_area) : '');
			$this->sheet->setCellValue('V' . $i, !empty($item->reminder_now) ? note_renewal($item->reminder_now) : '');

			$this->sheet->setCellValue('W' . $i, !empty($item->job_infor->address_company) ? $item->job_infor->address_company : '');
			$this->sheet->setCellValue('X' . $i, !empty($item->job_infor->address_company) ? $item->job_infor->address_company : '');
			$this->sheet->setCellValue('Y' . $i, !empty($item->current_address->form_residence) ? $item->current_address->form_residence : '');
			$this->sheet->setCellValue('Z' . $i, !empty($item->disbursement_date) ? date('d/m/Y', $item->disbursement_date) : "");
			$this->sheet->setCellValue('AA' . $i, $is_device_vset);
			$this->sheet->setCellValue('AB' . $i, !empty($item->loan_infor->device_asset_location->code) ? $item->loan_infor->device_asset_location->code . " " : '');
			$this->sheet->setCellValue('AC' . $i, !empty($item->created_by) ? $item->created_by : '');
			$this->sheet->setCellValue('AD' . $i, !empty($item->follow_contract) ? $item->follow_contract : '');
			$this->sheet->setCellValue('AE' . $i, !empty($item->ghi_cu_call_thn) ? $item->ghi_cu_call_thn : '');

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

	private function setStyle($range)
	{
		$styles = [
			'font' =>
				[
					'name' => 'Arial',
					'bold' => true,
					'italic' => false,
					'strikethrough' => false,
					'color' => ['rgb' => 'FFFFFF']
				],
			'borders' =>
				[
					'left' =>
						[
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							'color' => ['rgb' => '000000']
						],
					'right' =>
						[
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							'color' => ['rgb' => '000000']
						],
					'bottom' =>
						[
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							'color' => ['rgb' => '000000']
						],
					'top' =>
						[
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
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
		$this->sheet->getStyle($range)->applyFromArray($styles)->getAlignment()->setHorizontal('center')->setVertical('center');
	}

	public function excelContractDebt()
	{
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$phone_number = !empty($_GET['phone_number']) ? $_GET['phone_number'] : "";
		$id_card = !empty($_GET['id_card']) ? $_GET['id_card'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$id = !empty($_GET['userId']) ? $_GET['userId'] : '';
		if (!empty($id)) {
			$data['user_id'] = $id;
		}
		if (!empty($id_card)) {
			$data['id_card'] = trim($id_card);
		}
		if (!empty($customer_name)) {
			$data['customer_name'] = trim($customer_name);
		}
		if (!empty($phone_number)) {
			$data['customer_phone_number'] = trim($phone_number);
		}
		if (!empty($code_contract_disbursement)) {
			$data['code_contract_disbursement'] = trim($code_contract_disbursement);
		}
		$data['per_page'] = 10000;
		$contract = $this->api->apiPost($this->user['token'], "debt_manager_app/get_all_contract_debt", $data);
		if (!empty($contract->status) && $contract->status == 200) {
			$this->exportContractDebt($contract->data);
			$this->callLibExcel('data-debt_contract-' . time() . '.xlsx');
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
			redirect(base_url('debt_manager_app/view_manager_contract'));
		}
	}

	/** Xuất dữ liệu excel thông tin hợp đồng gán cho nhân viên Field
	 * @param $contracts
	 * @return void
	 */
	private function exportContractDebt($contracts)
	{
		$this->sheet->setCellValue('A1', 'Mã phiếu ghi');
		$this->sheet->setCellValue('B1', 'Mã hợp đồng');
		$this->sheet->setCellValue('C1', 'Họ và tên');
		$this->sheet->setCellValue('D1', 'Khoản vay');
		$this->sheet->setCellValue('E1', 'Hình thức vay');
		$this->sheet->setCellValue('F1', 'Khu vực');
		$this->sheet->setCellValue('G1', 'Tên Nhân Viên');
		$this->sheet->setCellValue('H1', 'Nhóm hợp đồng quá hạn');
		$this->sheet->setCellValue('I1', 'Ngày giải ngân');
		$this->sheet->setCellValue('J1', 'Điện thoại KH');
		$this->sheet->setCellValue('K1', 'Địa chỉ tạm trú');
		$this->sheet->setCellValue('L1', 'Địa chỉ hộ khẩu');
		$this->sheet->setCellValue('M1', 'Địa chỉ nơi làm việc');
		$this->sheet->setCellValue('N1', 'Đánh giá tình trạng lần cuối');
		$this->sheet->setCellValue('O1', 'Thời gian hẹn thanh toán');
		$this->sheet->setCellValue('P1', 'Số tiền');
		$this->sheet->setCellValue('Q1', 'Người gặp');
		$this->sheet->setCellValue('R1', 'Nơi đến');
		$this->sheet->setCellValue('S1', 'Ghi chú');
		$this->sheet->setCellValue('T1', 'Khu vực');
		$this->sheet->setCellValue('U1', 'PGD');
		$this->sheet->setCellValue('V1', 'POS');

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
		$this->setStyle("S1");
		$this->setStyle("T1");
		$this->setStyle("U1");
		$this->setStyle("V1");
		$i = 2;
		foreach ($contracts as $item) {
			$typePay = "";
			$type_interest = !empty($item->loan_infor->type_interest) ? $item->loan_infor->type_interest : "";
			if ($type_interest == 1) {
				$typePay = "Lãi hàng tháng, gốc hàng tháng";
			} else {
				$typePay = "Lãi hàng tháng, gốc cuối kỳ";
			}
			$evaluate = '';
			$time_promise_payment = '';
			$relative_meet = '';
			$arrived_place = '';
			$amount_received = '';
			$comment = '';
			if (!empty($item->debt_log)) {
				$debt_log_length = !empty($item->debt_log) ? count($item->debt_log) : 0;
				if ($debt_log_length > 0) {
					foreach ($item->debt_log as $key => $debt_log) {
						if (empty($debt_log)) continue;
						$the_number = $key + 1;
						if (!empty($debt_log->evaluate)) {
							$evaluate .= "(Lần " . $the_number . ") " . status_debt_recovery($debt_log->evaluate) . "\n";
						}
						if (!empty($debt_log->time_recovery)) {
							$time_promise_payment .= "(Lần " . $the_number . ") " . date('d/m/Y', $debt_log->time_recovery) . "\n";
						}
						if (!empty($debt_log->amount_received)) {
							$amount_received .= "(Lần " . $the_number . ") " . number_format($debt_log->amount_received) . "\n";
						}
						if (!empty($debt_log->people)) {
							$relative_meet .= "(Lần " . $the_number . ") " . meet_relatives($debt_log->people) . "\n";
						}
						if (!empty($debt_log->destination)) {
							$arrived_place .= "(Lần " . $the_number . ") " . $debt_log->destination . "\n";
						}
						if (!empty($debt_log->note)) {
							$comment .= "(Lần " . $the_number . ") " . $debt_log->note . "\n";
						}
					}
				}
			}

			$this->sheet->setCellValue('A' . $i, !empty($item->code_contract) ? $item->code_contract : '');
			$this->sheet->setCellValue('B' . $i, !empty($item->code_contract_disbursement) ? $item->code_contract_disbursement : '');
			$this->sheet->setCellValue('C' . $i, !empty($item->customer_infor->customer_name) ? $item->customer_infor->customer_name : "");
			$this->sheet->setCellValue('D' . $i, !empty($item->loan_infor->amount_money) ? $item->loan_infor->amount_money : "");
			$this->sheet->setCellValue('E' . $i, !empty($item->loan_infor->number_day_loan) ? $typePay . '/ ' . (($item->loan_infor->number_day_loan) / 30) . ' tháng' : '');
			$this->sheet->setCellValue('F' . $i, !empty($item->current_address->province_name) ? $item->current_address->province_name : '');
			$this->sheet->setCellValue('G' . $i, !empty($item->user_debt) ? ($item->user_debt) : '');
			$this->sheet->setCellValue('H' . $i, !empty($item->bucket) ? $item->bucket : "");
			$this->sheet->setCellValue('I' . $i, !empty($item->disbursement_date) ? date('d/m/Y', $item->disbursement_date) : "");
			$this->sheet->setCellValue('J' . $i, !empty($item->customer_infor->customer_phone_number) ? $item->customer_infor->customer_phone_number : "");
			$this->sheet->setCellValue('K' . $i, $item->current_address->current_stay . '/ ' . $item->current_address->ward_name . '/ ' . $item->current_address->district_name . '/ ' . $item->current_address->province_name);
			$this->sheet->setCellValue('L' . $i, $item->houseHold_address->address_household . '/ ' . $item->houseHold_address->ward_name . '/ ' . $item->houseHold_address->district_name . '/ ' . $item->current_address->province_name);
			$this->sheet->setCellValue('M' . $i, $item->job_infor->name_company . '/ ' . $item->job_infor->address_company);
			$this->sheet->setCellValue('N' . $i, rtrim($evaluate, "\ \t\n\r\0\x0B"));
			$this->sheet->setCellValue('O' . $i, rtrim($time_promise_payment, "\ \t\n\r\0\x0B"));
			$this->sheet->setCellValue('P' . $i, rtrim($amount_received, "\ \t\n\r\0\x0B"));
			$this->sheet->setCellValue('Q' . $i, rtrim($relative_meet, "\ \t\n\r\0\x0B"));
			$this->sheet->setCellValue('R' . $i, rtrim($arrived_place, "\ \t\n\r\0\x0B"));
			$this->sheet->setCellValue('S' . $i, rtrim($comment, "\ \t\n\r\0\x0B"));
			$this->sheet->setCellValue('T' . $i, !empty($item->current_address->district_name) ? ($item->current_address->district_name) : $item->houseHold_address->district_name);
			$this->sheet->setCellValue('U' . $i, !empty($item->store->name) ? ($item->store->name) : '');
			$this->sheet->setCellValue('V' . $i, !empty($item->debt->tong_tien_goc_con) ? ($item->debt->tong_tien_goc_con) : 0);

			$i++;
		}

	}
}

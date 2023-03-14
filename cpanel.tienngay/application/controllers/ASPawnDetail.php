<?php use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

if (!defined('BASEPATH')) exit('No direct script access allowed');


class ASPawnDetail extends MY_Controller
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
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	public function index()
	{
		$users = $this->api->apiPost($this->userInfo['token'], 'user/get_all');
		$this->data['users'] = $users->data;
		$this->data["pageName"] = "Thông tin hợp đồng";
		$this->data['template'] = 'page/pawn/excelPawn';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}


	public function process()
	{
		$createBy = !empty($_GET['createBy']) ? $_GET['createBy'] : "";
		if (empty($createBy)) {
			$this->session->set_flashdata('error', "Hãy nhập thông tin email ");
			redirect(base_url('aSPawnDetail'));
		}
		$data = [];
		if (!empty($createBy)) $data['created_by'] = $createBy;
		$info = $this->api->apiPost($this->userInfo['token'], "contract/get_all_by_status_active", $data);
		if (empty($info->data)) {
			$this->session->set_flashdata('error', "Không có dữ liệu ");
			redirect(base_url('aSPawnDetail'));
		} else {
//			echo "<pre>";
//			print_r($info->data);
//			echo "</pre>";
//			die();
			$this->export_part($info->data);
			$this->callLibExcel('data-pawn-detail-' . $createBy . time() . '.xlsx');
		}

	}
		public function do_export_contract_import()
	{
		 $start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
        $end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		
		$data = [];
		if (!empty($createBy)) $data['created_by'] = $createBy;
		$data['start']=$start;
		$data['end']=$end;
		$data["type_ct"] = "old_contract";
		$data["per_page"] = 30000;
		$info = $this->api->apiPost($this->userInfo['token'], "contract/get_all_data", $data);
		if (empty($info->data)) {
			$this->session->set_flashdata('error', "Không có dữ liệu ");
			redirect(base_url('pawn/contract_import'));
		} else {
//			echo "<pre>";
//			print_r($info->data);
//			echo "</pre>";
//			die();
			$this->export_contract_import($info->data);
			$this->callLibExcel('data-contract-import-detail-' . $createBy . time() . '.xlsx');
		}

	}
	public function export_contract_import($dataPawn)
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



		$i = 2;
		foreach ($dataPawn as $data) {
			$customer_resources = !empty($data->customer_infor->customer_resources) ? $data->customer_infor->customer_resources : "";
			$resources = "";
			if ($customer_resources == 'hoiso') {
				$resources = "KH từ hội sở";
			}
			if ($customer_resources == 'tukiem') {
				$resources = "KH tự kiếm";
			}
			if ($customer_resources == 'vanglai') {
				$resources = "KH vãng lai";
			}
			 $so_khung="";
			 $so_may="";
			 $bien_so_xe="";
			 $model="";
			 $nhan_hieu="";

			 if(!empty($data->property_infor)) {
                foreach($data->property_infor as $item) {
                    if(empty($item->value)) {
                       
                    }
                    if(!empty($item->value) && $item->slug=='so-khung' ) {
                        $so_khung=$item->value;
                    }
                    if(!empty($item->value) && $item->slug=='so-may') {
                       $so_may=$item->value;
                    }
                      if(!empty($item->value) && $item->slug=='bien-so-xe' ) {
                       $bien_so_xe=$item->value;
                    }
                     if (!empty($item->value) && $item->slug == 'model') {
                       $model=$item->value;
                    }
                    if (!empty($item->value) && $item->slug == 'nhan-hieu') {
                       $nhan_hieu=$item->value;
                    }
                }
              
            }
			$this->sheet->setCellValue('A' . $i, $i-1);
			$this->sheet->setCellValue('B' . $i, !empty($data->code_contract_disbursement) ? $data->code_contract_disbursement : $data->code_contract);
			$this->sheet->setCellValue('C' . $i, !empty($data->code_contract) ? $data->code_contract : '');
			$this->sheet->setCellValue('D' . $i, !empty($data->store->name) ? $data->store->name : "");
			$this->sheet->setCellValue('E' . $i,  !empty($data->disbursement_date) ? date("d/m/Y",$data->disbursement_date) : "");
			$this->sheet->setCellValue('F' . $i,  !empty($data->status) ? $data->status : "");
			$this->sheet->setCellValue('G' . $i, !empty($data->receiver_infor->type_payout) ? $data->receiver_infor->type_payout : "");
			$this->sheet->setCellValue('H' . $i, !empty($data->receiver_infor->bank_name) ? $data->receiver_infor->bank_name : "");
			$this->sheet->setCellValue('I' . $i, !empty($data->receiver_infor->bank_branch) ? $data->receiver_infor->bank_branch : "");
			$this->sheet->setCellValue('J' . $i, !empty($data->receiver_infor->bank_account) ? $data->receiver_infor->bank_account : "");
			$this->sheet->setCellValue('K' . $i, !empty($data->receiver_infor->bank_account_holder) ? $data->receiver_infor->bank_account_holder : "");
			$this->sheet->setCellValue('L' . $i, !empty($data->receiver_infor->atm_card_number) ? $data->receiver_infor->atm_card_number : "");
			$this->sheet->setCellValue('M' . $i,!empty($data->receiver_infor->atm_card_holder) ? $data->receiver_infor->atm_card_holder : "");
			$this->sheet->setCellValue('N' . $i, !empty($data->investor_infor->name) ? $data->investor_infor->name : "");
			$this->sheet->setCellValue('O' . $i,  !empty($data->investor_infor->dentity_card) ? $data->investor_infor->dentity_card : "");
			$this->sheet->setCellValue('P' . $i, "");
			$this->sheet->setCellValue('Q' . $i, !empty($data->customer_infor->customer_name) ? $data->customer_infor->customer_name : "");
			$this->sheet->setCellValue('R' . $i,  !empty($data->customer_infor->customer_phone_number) ? $data->customer_infor->customer_phone_number : "");
			$this->sheet->setCellValue('S' . $i, !empty($data->customer_infor->customer_email) ? $data->customer_infor->customer_email : "");
			$this->sheet->setCellValue('T' . $i, !empty($data->customer_infor->customer_identify) ? $data->customer_infor->customer_identify : "");
			$this->sheet->setCellValue('U' . $i, !empty($data->customer_infor->customer_gender) ? $data->customer_infor->customer_gender : "");
			$this->sheet->setCellValue('V' . $i, !empty($data->customer_infor->customer_BOD) ? $data->customer_infor->customer_BOD : "");
			$this->sheet->setCellValue('W' . $i, !empty($data->customer_infor->marriage) ? $data->customer_infor->marriage : "");
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
			$this->sheet->setCellValue('AJ' . $i,  !empty($data->job_infor->phone_number_company) ? $data->job_infor->phone_number_company : "");
			$this->sheet->setCellValue('AK' . $i,  !empty($data->job_infor->job) ? $data->job_infor->job : "");
			$this->sheet->setCellValue('AL' . $i, !empty($data->job_infor->salary) ? $data->job_infor->salary : "");
			$this->sheet->setCellValue('AM' . $i,!empty($data->job_infor->receive_salary_via) ? $data->job_infor->receive_salary_via : "");
			$this->sheet->setCellValue('AN' . $i, !empty($data->relative_infor->fullname_relative_1) ? $data->relative_infor->fullname_relative_1 : "");
			$this->sheet->setCellValue('AO' . $i, !empty($data->relative_infor->type_relative_1) ? $data->relative_infor->type_relative_1 : "");
			$this->sheet->setCellValue('AP' . $i, !empty($data->relative_infor->phone_number_relative_1) ? $data->relative_infor->phone_number_relative_1 : "");
			$this->sheet->setCellValue('AQ' . $i, !empty($data->relative_infor->hoursehold_relative_1) ? $data->relative_infor->hoursehold_relative_1 : "");
			$this->sheet->setCellValue('AR' . $i, !empty($data->relative_infor->confirm_relativeInfor_1) ? $data->relative_infor->confirm_relativeInfor_1 : "");
			$this->sheet->setCellValue('AS' . $i, !empty($data->relative_infor->fullname_relative_2) ? $data->relative_infor->fullname_relative_2 : "");
			$this->sheet->setCellValue('AT' . $i, !empty($data->relative_infor->type_relative_2) ? $data->relative_infor->type_relative_2 : "");
			$this->sheet->setCellValue('AU' . $i, !empty($data->relative_infor->phone_number_relative_2) ? $data->relative_infor->phone_number_relative_2 : "");
			$this->sheet->setCellValue('AV' . $i, !empty($data->relative_infor->hoursehold_relative_2) ? $data->relative_infor->hoursehold_relative_2 : "");
			$this->sheet->setCellValue('AW' . $i, !empty($data->relative_infor->confirm_relativeInfor_2) ? $data->relative_infor->confirm_relativeInfor_2 : "");
			$this->sheet->setCellValue('AX' . $i, !empty($data->loan_infor->type_loan->code) ? $data->loan_infor->type_loan->code : "");
			$this->sheet->setCellValue('AY' . $i, !empty($data->loan_infor->type_loan->type_property->text) ? $data->loan_infor->type_loan->type_property->text : "");
			$this->sheet->setCellValue('AZ' . $i, !empty($data->loan_infor->name_property->text) ? $data->loan_infor->name_property->text : "");
			$this->sheet->setCellValue('BA' . $i,!empty($data->loan_infor->amount_money) ? $data->loan_infor->amount_money : "" );
			$this->sheet->setCellValue('BB' . $i, !empty($data->loan_infor->type_interest) ? $data->loan_infor->type_interest : "");
			$this->sheet->setCellValue('BC' . $i, !empty($data->loan_infor->number_day_loan) ? $data->loan_infor->number_day_loan/30 : "");
			$this->sheet->setCellValue('BD' . $i, !empty($data->loan_infor->loan_purpose) ? $data->loan_infor->loan_purpose : "");
			$this->sheet->setCellValue('BE' . $i,  $nhan_hieu);
			$this->sheet->setCellValue('BF' . $i,  $model);
			$this->sheet->setCellValue('BG' . $i,  $bien_so_xe);
			$this->sheet->setCellValue('BH' . $i,  $so_khung);
			$this->sheet->setCellValue('BI' . $i,  $so_may);
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
		
			
			$i++;
		}

	}

	public function export_part($dataPawn)
	{
		$this->sheet->setCellValue('A1', 'Mã giao dịch');
		$this->sheet->setCellValue('B1', 'Họ và tên KH');
		$this->sheet->setCellValue('C1', 'CMND');
		$this->sheet->setCellValue('D1', 'Nguồn Kh');
		$this->sheet->setCellValue('E1', 'Hộ khẩu thường trú');
		$this->sheet->setCellValue('F1', 'Địa chỉ tạm trú');
		$this->sheet->setCellValue('G1', 'Nghề nghiệp');
		$this->sheet->setCellValue('H1', 'Thu nhập');
		$this->sheet->setCellValue('I1', 'Hình thức');
		$this->sheet->setCellValue('J1', 'Tài sản thế chấp');
		$this->sheet->setCellValue('K1', 'Số tiền vay');
		$this->sheet->setCellValue('L1', 'Số tiền giải ngân');
		$this->sheet->setCellValue('M1', 'Người tạo');
		$this->sheet->setCellValue('N1', 'Đánh giá tính tuân thủ quy định ');
		$this->sheet->setCellValue('O1', 'Kiến nghị của KSNB');
		$this->sheet->setCellValue('P1', 'Hình ảnh KSNB check');


		$i = 2;
		foreach ($dataPawn as $data) {
			$customer_resources = !empty($data->customer_infor->customer_resources) ? $data->customer_infor->customer_resources : "";
			$resources = "";
			if ($customer_resources == 'hoiso') {
				$resources = "KH từ hội sở";
			}
			if ($customer_resources == 'tukiem') {
				$resources = "KH tự kiếm";
			}
			if ($customer_resources == 'vanglai') {
				$resources = "KH vãng lai";
			}
			$this->sheet->setCellValue('A' . $i, !empty($data->code_contract) ? $data->code_contract : "");
			$this->sheet->setCellValue('B' . $i, !empty($data->customer_infor->customer_name) ? $data->customer_infor->customer_name : "");
			$this->sheet->setCellValue('C' . $i, !empty($data->customer_infor->customer_identify) ? $data->customer_infor->customer_identify : "");
			$this->sheet->setCellValue('D' . $i, $resources);
			$this->sheet->setCellValue('E' . $i, $data->houseHold_address->ward_name . ',' . $data->houseHold_address->district_name . ',' . $data->houseHold_address->province_name);
			$this->sheet->setCellValue('F' . $i, $data->current_address->ward_name . ',' . $data->current_address->district_name . ',' . $data->current_address->province_name);
			$this->sheet->setCellValue('G' . $i, !empty($data->job_infor->job) ? $data->job_infor->job : "");
			$this->sheet->setCellValue('H' . $i, !empty($data->job_infor->salary) ? number_format($data->job_infor->salary) : "");
			$this->sheet->setCellValue('I' . $i, !empty($data->loan_infor->type_loan->text) ? $data->loan_infor->type_loan->text : "");
			$this->sheet->setCellValue('J' . $i, !empty($data->loan_infor->name_property->text) ? $data->loan_infor->name_property->text : "");
			$this->sheet->setCellValue('K' . $i, !empty($data->loan_infor->amount_money) ? number_format($data->loan_infor->amount_money) : "");
			$this->sheet->setCellValue('L' . $i, !empty($data->loan_infor->amount_loan) ? number_format($data->loan_infor->amount_loan) : "");
			$this->sheet->setCellValue('M' . $i, !empty($data->created_by) ? $data->created_by : "");
			$this->sheet->setCellValue('N' . $i, "");
			$this->sheet->setCellValue('O' . $i, "");
			$this->sheet->setCellValue('P' . $i, "");
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
}

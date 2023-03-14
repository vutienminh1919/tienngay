<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ASCurrentMonth extends MY_Controller
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
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$this->tong = array(
			"so_tien_vay" => 0,
			"goc_vay_phai_thu" => 0, //P4
			"lai_vay_phai_tra_NDT" => 0, //Q4
			"phi_tu_van" => 0, //R4
			"phi_tham_dinh" => 0, //S4
			"phi_gia_han_khoan_vay" => 0, //V4
			"tong_phi" => 0,
			"lai_luy_ke_den_thang_Tn" => 0, //X4
			"phi_luy_ke_den_thang_Tn" => 0, //Y4,

			"goc_vay_phai_thu_den_thoi_diem_dao_han" => 0, //Z4
			"lai_vay_phai_tra_NDT_den_thoi_diem_dao_han" => 0, //AA4
			"phi_tu_van_den_thoi_diem_dao_han" => 0,//AB4
			"phi_tham_dinh_den_thoi_diem_dao_han" => 0,//AC4
			"phi_gia_han_den_thoi_diem_dao_han" => 0,//AF4
			"tong_phi_den_thoi_diem_dao_han" => 0,//AG4

			"lai_du_thu_thang_Tn" => 0, //AH
			"phi_du_thu_thang_Tn" => 0, //AI

			"du_no_goc_thang_truoc" => 0, //AJ
			"du_no_lai_thang_truoc" => 0, //AK
			"du_no_phi_thang_truoc" => 0, //AL

			"so_tien_goc_da_thu_hoi" => 0, //AM
			"so_tien_lai_da_thu_hoi" => 0, //AN
			"so_tien_phi_da_thu_hoi" => 0, //AO
			"tong_thu_hoi_luy_ke_thang_truoc" => 0, //AP
			"tong_thu_hoi_luy_ke_thang_Tn" => 0, //AQ
			"so_tien_goc_con_lai" => 0, //AR
			"so_tien_lai_con_lai" => 0, //AS
			"so_tien_phi_con_lai" => 0, //AT
		);

		$this->numberRowLastColumn = 0;
	}

	private $tong, $numberRowLastColumn;

	private $getStyle, $spreadsheet, $sheet;

	//Theo dõi khoản vay T hiện tại
	public function index()
	{

		$this->data["pageName"] = "Theo dõi khoản vay T hiện tại";
		$this->data['template'] = 'web/accounting_system_update/follow_current_month';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function report_month_kt()
	{

		$start = !empty($_GET['fdate_export']) ? $_GET['fdate_export'] : "";
		if (empty($start)) {
			$this->session->set_flashdata('error', "Hãy chọn tháng");
			redirect(base_url('aSCurrentMonth'));
		}
		$data = array();
		if (!empty($start)) $data['start'] = $start;

		$countInfor = $this->api->apiPost($this->userInfo['token'], "accountingSystemUpdate/follow_current_month_count", $data);
		$count = (int)$countInfor->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('ASCurrentMonth/report_month_kt?fdate_export=' . $start);
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

		$infor = $this->api->apiPost($this->userInfo['token'], "accountingSystemUpdate/follow_current_month_view", $data);

//		if (empty($infor->data)){
//			return;
//		}

		$contracts = [];
		$total = [];
		$i = 0;

		foreach ($infor->data as $key => $item) {

			$type_interest = !empty($item->loan_infor->type_interest) ? $item->loan_infor->type_interest : "";
			if ($type_interest == 1) {
				$typePay = "Lãi hàng tháng, gốc hàng tháng";
			} else {
				$typePay = "Lãi hàng tháng, gốc cuối kỳ";
			}

			$amount = 0;
			if (empty($item->count_extend)) {
				$amount = !empty($item->loan_infor->amount_money) ? $item->loan_infor->amount_money : 0;
			}

			$codeTransaction = "";
			if (!empty($item->investor_code) && $item->investor_code == 'vimo' && $item->status_create_withdrawal == 'success') {
				$codeTransaction = $item->response_get_transaction_withdrawal_status->withdrawal_transaction_id;
			} else if (!empty($item->investor_code) && !empty($item->code_transaction_bank_disbursement)) {
				$codeTransaction = $item->code_transaction_bank_disbursement;
			}

			////
			if ($item->status == 33 || $item->status == 34) {
				//Gốc vay phải thu
				$goc_vay_phai_thu = 0;
				//Lãi vay (trả nhà ĐT)
				$interestPayInvestor = 0;
				//Phí tư vấn
				$feeAdvisory = 0;
				//Phí thẩm định
				$feeExpertise = 0;
				//Tiền thừa tất toán
				$tien_thua_tat_toan = 0;
				//Phí trả chậm
				$feePayDelay = 0;
				//Phí trả trước = phí tất toán trước hạn
				$feeFinishContract = 0;
				//Phí gia hạn khoản vay
				$feeExtend = 0;
				//Tổng phí
				$totalFee = 0;
			} else {
				//Gốc vay phải thu
				$goc_vay_phai_thu = $this->gocVayPhaiThu_P4($item->bang_lai_ky[0]);
				//Lãi vay (trả nhà ĐT)
				$interestPayInvestor = $this->getQ($item->bang_lai_ky[0]);
				//Phí tư vấn
				$feeAdvisory = $this->getPhiTuVan($item->bang_lai_ky[0]);
				//Phí thẩm định
				$feeExpertise = $this->getPhiThamDinh($item->bang_lai_ky[0]);
				//Tiền thừa tất toán
				$tien_thua_tat_toan = $this->getTienThuaTatToan($item->bang_lai_ky[0]);
				//Phí trả chậm
				$feePayDelay = !empty($item->bang_lai_ky[0]->fee_delay_pay) ? $item->bang_lai_ky[0]->fee_delay_pay : 0;
				//Phí trả trước = phí tất toán trước hạn
				$feeFinishContract = !empty($item->bang_lai_ky[0]->fee_finish_contract) ? $item->bang_lai_ky[0]->fee_finish_contract : 0;
				//Phí gia hạn khoản vay
				$feeExtend = !empty($item->bang_lai_ky[0]->fee_extend) ? $item->bang_lai_ky[0]->fee_extend : 0;
				//Tổng phí
				$totalFee = $this->getW($item);
			}
			////
			$lai_luy_ke_den_thang_Tn_tru_1 = !empty($item->lai_luy_ke_den_thang_Tn) ? $item->lai_luy_ke_den_thang_Tn : 0;

			//$lai_luy_ke_den_thang_Tn = $lai_luy_ke_den_thang_Tn_tru_1 + $interestPayInvestor;
			$lai_luy_ke_den_thang_Tn = $lai_luy_ke_den_thang_Tn_tru_1;
			//Phí lũy kế đến tháng Tn
			//$phi_luy_ke_den_thang_Tn = $this->get_phi_luy_ke_den_thang_Tn($item);

			$phi_tu_van_luy_ke_den_thang_Tn = !empty($item->phi_tu_van_luy_ke_den_thang_Tn) ? $item->phi_tu_van_luy_ke_den_thang_Tn : 0;
			$phi_tham_dinh_luy_ke_den_thang_Tn = !empty($item->phi_tham_dinh_luy_ke_den_thang_Tn) ? $item->phi_tham_dinh_luy_ke_den_thang_Tn : 0;
			// $phi_tra_cham_luy_ke_den_thang_Tn = !empty($item->phi_tra_cham_luy_ke_den_thang_Tn) ? $item->phi_tra_cham_luy_ke_den_thang_Tn : 0;
			// $phi_tra_truoc_luy_ke_den_thang_Tn = !empty($item->phi_tra_truoc_luy_ke_den_thang_Tn) ? $item->phi_tra_truoc_luy_ke_den_thang_Tn : 0;
			// $phi_gia_han_luy_ke_den_thang_Tn = !empty($item->phi_gia_han_luy_ke_den_thang_Tn) ? $item->phi_gia_han_luy_ke_den_thang_Tn : 0;
			// $phi_phat_sinh_luy_ke_den_thang_Tn = !empty($item->phi_phat_sinh_luy_ke_den_thang_Tn) ? $item->phi_phat_sinh_luy_ke_den_thang_Tn : 0;

			$phi_luy_ke_den_thang_Tn = $phi_tu_van_luy_ke_den_thang_Tn +
				$phi_tham_dinh_luy_ke_den_thang_Tn;
			// $phi_tra_cham_luy_ke_den_thang_Tn +
			// $phi_tra_truoc_luy_ke_den_thang_Tn +
			// $phi_phat_sinh_luy_ke_den_thang_Tn +
			// $phi_gia_han_luy_ke_den_thang_Tn;


			if ($item->status == 33 || $item->status == 34) {
				$goc_vay_phai_thu_den_thoi_diem_dao_han = 0;

			} else {
				//Gốc vay phải thu ( bảng lãi KỲ)
				$goc_vay_phai_thu_den_thoi_diem_dao_han = !empty($item->goc_vay_phai_thu_den_thoi_diem_dao_han) ? $item->goc_vay_phai_thu_den_thoi_diem_dao_han : 0;
			}
			//Lãi vay phải trả NĐT( bảng lãi KỲ)
			$lai_vay_phai_tra_NDT_den_thoi_diem_dao_han = !empty($item->lai_vay_phai_tra_NDT_den_thoi_diem_dao_han) ? $item->lai_vay_phai_tra_NDT_den_thoi_diem_dao_han : 0;
			//Phí tư vấn( bảng lãi KỲ)
			$phi_tu_van_den_thoi_diem_dao_han = !empty($item->phi_tu_van_den_thoi_diem_dao_han) ? $item->phi_tu_van_den_thoi_diem_dao_han : 0;
			//Phí thẩm định( bảng lãi KỲ)
			$phi_tham_dinh_den_thoi_diem_dao_han = !empty($item->phi_tham_dinh_den_thoi_diem_dao_han) ? $item->phi_tham_dinh_den_thoi_diem_dao_han : 0;
			//Phí trả chậm( bảng lãi KỲ )
			$phi_tra_cham_den_thoi_diem_dao_han = !empty($item->phi_tra_cham_den_thoi_diem_dao_han) ? $item->phi_tra_cham_den_thoi_diem_dao_han : 0;
			//Phí trả trước( bảng lãi KỲ)
			$phi_tra_truoc_den_thoi_diem_dao_han = !empty($item->phi_tra_truoc_den_thoi_diem_dao_han) ? $item->phi_tra_truoc_den_thoi_diem_dao_han : 0;
			//Phí gia hạn khoản vay( bảng lãi KỲ)
			$phi_gia_han_den_thoi_diem_dao_han = !empty($item->phi_gia_han_den_thoi_diem_dao_han) ? $item->phi_gia_han_den_thoi_diem_dao_han : 0;
			//Phí phát sinh khoản vay( bảng lãi KỲ)
			$phi_phat_sinh_den_thoi_diem_dao_han = !empty($item->phi_phat_sinh_den_thoi_diem_dao_han) ? $item->phi_phat_sinh_den_thoi_diem_dao_han : 0;
			//Tổng phí
			$totalFee = $phi_tu_van_den_thoi_diem_dao_han +
				$phi_tham_dinh_den_thoi_diem_dao_han +
				$phi_tra_cham_den_thoi_diem_dao_han +
				$phi_tra_truoc_den_thoi_diem_dao_han +
				$phi_phat_sinh_den_thoi_diem_dao_han +
				$phi_gia_han_den_thoi_diem_dao_han;


			//Lãi vay phải trả NĐT( bảng lãi KỲ)
			$lai_vay_phai_tra_NDT_den_thoi_diem_dao_han = !empty($item->lai_vay_phai_tra_NDT_den_thoi_diem_dao_han) ? $item->lai_vay_phai_tra_NDT_den_thoi_diem_dao_han : 0;

			//$lai_luy_ke_den_thang_Tn = $lai_luy_ke_den_thang_Tn_tru_1 + $interestPayInvestor;
			$lai_luy_ke_den_thang_Tn = !empty($item->lai_luy_ke_den_thang_Tn) ? $item->lai_luy_ke_den_thang_Tn : 0;
			$tong_phi_cua_1_hang_den_thoi_diem_dao_han = $this->get_tong_phi_cua_1_hang_den_thoi_diem_dao_han($item);

			//Lãi dự thu tháng Tn
			$lai_du_thu_thang_Tn = $lai_vay_phai_tra_NDT_den_thoi_diem_dao_han -
				$lai_luy_ke_den_thang_Tn;

			//Phí dự thu tháng Tn
			$phi_luy_ke_den_thang_Tn = $this->get_phi_luy_ke_den_thang_Tn($item);
			$phi_du_thu_thang_Tn = $tong_phi_cua_1_hang_den_thoi_diem_dao_han - $phi_luy_ke_den_thang_Tn;


//			$du_no_goc_thang_truoc = $this->getAJ4($item);
//			$du_no_lai_thang_truoc = $this->getAK($item);
//			$du_no_phi_thang_truoc = $this->getAL($item);


			$endMonth_last = strtotime((date('Y-m-t', strtotime($start))) . ' 23:59:59');


			$condition_last = [
				'code_contract' => $item->code_contract,
				'status' => 1,
				'type' => 3,
				'date_pay' => array(
					'$lte' => $endMonth_last
				)
			];
			$status_last = "";
			$status_last = $this->contract_model->getStatusContract($condition_last);

			//Số tiền gốc đã thu hồi
			$so_tien_goc_da_thu_hoi = $this->getAM4($item);
			//Số tiền lãi đã thu hồi
			$so_tien_lai_da_thu_hoi = $this->getAN($item);
			//Số tiền phi đã thu hồi
			$so_tien_phi_da_thu_hoi = $this->getAO($item);
			if ($item->tien_goc_1thang_da_tra != 0) {
				$so_tien_goc_da_thu_hoi = $item->tien_goc_1thang_da_tra;
			}
			if ($item->tien_lai_1thang_da_tra_tien_thua != 0) {
				$so_tien_lai_da_thu_hoi = $item->tien_lai_1thang_da_tra_tien_thua;
			}
			if ($item->tien_phi_1thang_da_tra_tien_thua != 0) {
				$so_tien_phi_da_thu_hoi = $item->tien_phi_1thang_da_tra_tien_thua;
			}
			//Tổng thu hồi lũy kế tháng trước
//            $tong_thu_hoi_luy_ke_thang_truoc = $this->tongThuHoiLuyKeThangTruoc_AP($item);
			$tong_thu_hoi_luy_ke_thang_truoc = !empty($item->tong_thu_hoi_luy_ke_thang_truoc) ? $item->tong_thu_hoi_luy_ke_thang_truoc : 0;
			//Tổng thu hồi lũy kế tháng Tn
//            $tong_thu_hoi_luy_ke_thang_Tn = $this->tongThuHoiLuyKeThangTn_AQ($item);
			$tong_thu_hoi_luy_ke_thang_hien_tai = !empty($item->tong_thu_hoi_luy_ke_thang_hien_tai) ? $item->tong_thu_hoi_luy_ke_thang_hien_tai : 0;
			$tong_thu_hoi_luy_ke_thang_Tn = $tong_thu_hoi_luy_ke_thang_hien_tai + $tong_thu_hoi_luy_ke_thang_truoc;

			if ($item->status == 33 || $item->status == 34) {
				//Số tiền gốc còn lại
				$so_tien_goc_con_lai = 0;

				$tong_thu_hoi_luy_ke_thang_hien_tai = !empty($item->tong_thu_hoi_gia_han) ? $item->tong_thu_hoi_gia_han : 0;

			} else {
				//Số tiền gốc còn lại
				$so_tien_goc_con_lai = $this->getSoTienGocConLai($item);

			}

			//Số tiền lãi còn lại
			$so_tien_lai_con_lai = $this->getSoTienLaiConLai($item);
			//Số tiền phí còn lại


			$feePayDelay = !empty($item->bang_lai_ky[0]->fee_delay_pay) ? $item->bang_lai_ky[0]->fee_delay_pay : 0;
			//Phí trả trước = phí tất toán trước hạn
			$feeFinishContract = !empty($item->bang_lai_ky[0]->fee_finish_contract) ? $item->bang_lai_ky[0]->fee_finish_contract : 0;
			//Phí gia hạn khoản vay
			$feeExtend = !empty($item->bang_lai_ky[0]->fee_extend) ? $item->bang_lai_ky[0]->fee_extend : 0;
			//Tổng phí

			if ($item->type == 3) {
				$so_tien_phi_con_lai = $this->getSoTienPhiConLai($item) - $feePayDelay - $feeFinishContract - $feeExtend;
			} else {
				$so_tien_phi_con_lai = $this->getSoTienPhiConLai($item);
			}

			if ($item->status == 19) {
				$status_last = "Tất toán";
			} elseif ($item->status == 33) {
				$status_last = "Gia hạn";
			} elseif ($item->status == 17) {
				$status_last = "Đang vay";
			} elseif ($item->status == 34) {
				$status_last = "Cơ cấu";
			}


			//Tiền thừa tất toán
			$tien_thua_tat_toan = $this->getTienThuaTatToan($item->bang_lai_ky[0]);

			//Số tiền phí chậm trả
			$so_tien_phi_cham_tra_da_thu_hoi_thang_hien_tai = !empty($item->so_tien_phi_cham_tra_da_thu_hoi_thang_hien_tai) ? $item->so_tien_phi_cham_tra_da_thu_hoi_thang_hien_tai : 0;
			//Số tiền phí trước hạn
			$so_tien_phi_truoc_han_da_thu_hoi_thang_hien_tai = !empty($item->so_tien_phi_truoc_han_da_thu_hoi_thang_hien_tai) ? $item->so_tien_phi_truoc_han_da_thu_hoi_thang_hien_tai : 0;

//			$tong_thu_hoi_thang_T = $so_tien_goc_da_thu_hoi + $so_tien_lai_da_thu_hoi + $so_tien_phi_da_thu_hoi + $so_tien_phi_cham_tra_da_thu_hoi_thang_hien_tai + $so_tien_phi_truoc_han_da_thu_hoi_thang_hien_tai;


			//export_part1
			$contracts[$i]['codeTransaction'] = $codeTransaction;
			$contracts[$i]['getMaHopDongVay'] = $this->contract_model->getMaHopDongVay($item);
			$contracts[$i]['getMaPhuLuc'] = $this->contract_model->getMaPhuLuc($item);
			$contracts[$i]['thoi_han_vay'] = $item->debt->thoi_han_vay;
			$contracts[$i]['disbursement_date'] = !empty($item->disbursement_date) ? $this->time_model->convertTimestampToDatetime_($item->disbursement_date) : "";
			$contracts[$i]['expire_date'] = !empty($item->expire_date) ? $this->time_model->convertTimestampToDatetime_($item->expire_date) : "";
			$contracts[$i]['customer_name'] = $item->customer_infor->customer_name;
			$contracts[$i]['customer_identify'] = $item->customer_infor->customer_identify;
			$contracts[$i]['investor_infor_name'] = !empty($item->investor_infor->name) ? $item->investor_infor->name : "";
			$contracts[$i]['investor_infor_code'] = !empty($item->investor_infor->code) ? $item->investor_infor->code : "";
			$contracts[$i]['store_name'] = !empty($item->store->name) ? $item->store->name : "";
			$contracts[$i]['type_loan_code'] = !empty($item->loan_infor) && !empty($item->loan_infor->type_loan->code) && !empty($item->loan_infor->type_property->code) ? $item->loan_infor->type_loan->code . '-' . $item->loan_infor->type_property->code : "";
			$contracts[$i]['amount'] = number_format(round($amount));
			$contracts[$i]['typePay'] = $typePay;

			//export_part2
			$contracts[$i]['goc_vay_phai_thu'] = number_format(round($goc_vay_phai_thu));
			$contracts[$i]['interestPayInvestor'] = number_format(round($interestPayInvestor));
			$contracts[$i]['feeAdvisory'] = number_format(round($feeAdvisory));
			$contracts[$i]['feeExpertise'] = number_format(round($feeExpertise));
			$contracts[$i]['feePayDelay'] = number_format(round($feePayDelay));
			$contracts[$i]['feeFinishContract'] = number_format(round($feeFinishContract));
			$contracts[$i]['feeExtend'] = number_format(round($feeExtend));
			$contracts[$i]['totalFee'] = number_format(round($totalFee));

			//export_part3
			$contracts[$i]['lai_luy_ke_den_thang_Tn'] = number_format(round($lai_luy_ke_den_thang_Tn));
			$contracts[$i]['phi_luy_ke_den_thang_Tn'] = number_format(round($phi_luy_ke_den_thang_Tn));

			//export_part4
			$contracts[$i]['goc_vay_phai_thu_den_thoi_diem_dao_han'] = number_format(round($goc_vay_phai_thu_den_thoi_diem_dao_han));
			$contracts[$i]['lai_vay_phai_tra_NDT_den_thoi_diem_dao_han'] = number_format(round($lai_vay_phai_tra_NDT_den_thoi_diem_dao_han));
			$contracts[$i]['phi_tu_van_den_thoi_diem_dao_han'] = number_format(round($phi_tu_van_den_thoi_diem_dao_han));
			$contracts[$i]['phi_tham_dinh_den_thoi_diem_dao_han'] = number_format(round($phi_tham_dinh_den_thoi_diem_dao_han));
			$contracts[$i]['phi_gia_han_den_thoi_diem_dao_han'] = number_format(round($phi_gia_han_den_thoi_diem_dao_han));
			$contracts[$i]['phi_tra_cham_den_thoi_diem_dao_han'] = number_format(round($phi_tra_cham_den_thoi_diem_dao_han));
			$contracts[$i]['phi_tra_truoc_den_thoi_diem_dao_han'] = number_format(round($phi_tra_truoc_den_thoi_diem_dao_han));
			$contracts[$i]['phi_phat_sinh_den_thoi_diem_dao_han'] = number_format(round($phi_phat_sinh_den_thoi_diem_dao_han));
			$contracts[$i]['totalFee'] = number_format(round($totalFee));

			//export_part5
			$contracts[$i]['lai_du_thu_thang_Tn'] = number_format(round($lai_du_thu_thang_Tn));
			$contracts[$i]['phi_du_thu_thang_Tn'] = number_format(round($phi_du_thu_thang_Tn));

			//export_part6
			$contracts[$i]['du_no_goc_thang_truoc'] = number_format(round($du_no_goc_thang_truoc));
			$contracts[$i]['du_no_lai_thang_truoc'] = number_format(round($du_no_lai_thang_truoc));
			$contracts[$i]['du_no_phi_thang_truoc'] = number_format(round($du_no_phi_thang_truoc));

			//export_part7
			$contracts[$i]['so_tien_goc_da_thu_hoi'] = number_format(round($so_tien_goc_da_thu_hoi));
			$contracts[$i]['so_tien_lai_da_thu_hoi'] = number_format(round($so_tien_lai_da_thu_hoi));
			$contracts[$i]['so_tien_phi_da_thu_hoi'] = number_format(round($so_tien_phi_da_thu_hoi));
			$contracts[$i]['so_tien_phi_cham_tra_da_thu_hoi_thang_hien_tai'] = number_format(round($so_tien_phi_cham_tra_da_thu_hoi_thang_hien_tai));
			$contracts[$i]['so_tien_phi_truoc_han_da_thu_hoi_thang_hien_tai'] = number_format(round($so_tien_phi_truoc_han_da_thu_hoi_thang_hien_tai));
			$contracts[$i]['tong_thu_hoi_thang_T'] = number_format(round($tong_thu_hoi_luy_ke_thang_hien_tai));
			$contracts[$i]['tong_thu_hoi_luy_ke_thang_truoc'] = number_format(round($tong_thu_hoi_luy_ke_thang_truoc + $tien_thua_tat_toan));
			$contracts[$i]['tong_thu_hoi_luy_ke_thang_Tn'] = number_format(round($tong_thu_hoi_luy_ke_thang_Tn + $tien_thua_tat_toan));
			$contracts[$i]['so_tien_goc_con_lai'] = number_format(round($so_tien_goc_con_lai));
			$contracts[$i]['so_tien_lai_con_lai'] = number_format(round($so_tien_lai_con_lai));
			$contracts[$i]['so_tien_phi_con_lai'] = number_format(round($so_tien_phi_con_lai));
			$contracts[$i]['status_last'] = $status_last;

			$i++;

			$total['so_tien_vay'] = $total['so_tien_vay'] + $amount;

			$total['goc_vay_phai_thu'] = $total['goc_vay_phai_thu'] + $goc_vay_phai_thu;
			$total['lai_vay_phai_tra_NDT'] = $total['lai_vay_phai_tra_NDT'] + $interestPayInvestor;
			$total['phi_tu_van'] = $total['phi_tu_van'] + $feeAdvisory;
			$total['phi_tra_cham'] = $total['phi_tra_cham'] + $feePayDelay;
			$total['phi_tham_dinh'] = $total['phi_tham_dinh'] + $feeExpertise;
			$total['phi_gia_han_khoan_vay'] = $total['phi_gia_han_khoan_vay'] + $feeExtend;
			$total['phi_tra_truoc'] = $total['phi_tra_truoc'] + $feeFinishContract;
			$total['tong_phi'] = $total['tong_phi'] + $totalFee;

			$total['lai_luy_ke_den_thang_Tn'] = $total['lai_luy_ke_den_thang_Tn'] + $lai_luy_ke_den_thang_Tn;
			$total['phi_luy_ke_den_thang_Tn'] = $total['phi_luy_ke_den_thang_Tn'] + $phi_luy_ke_den_thang_Tn;

			$total['goc_vay_phai_thu_den_thoi_diem_dao_han'] = $total['goc_vay_phai_thu_den_thoi_diem_dao_han'] + $goc_vay_phai_thu_den_thoi_diem_dao_han;
			$total['lai_vay_phai_tra_NDT_den_thoi_diem_dao_han'] = $total['lai_vay_phai_tra_NDT_den_thoi_diem_dao_han'] + $lai_vay_phai_tra_NDT_den_thoi_diem_dao_han;
			$total['phi_tu_van_den_thoi_diem_dao_han'] = $total['phi_tu_van_den_thoi_diem_dao_han'] + $phi_tu_van_den_thoi_diem_dao_han;
			$total['phi_tham_dinh_den_thoi_diem_dao_han'] = $total['phi_tham_dinh_den_thoi_diem_dao_han'] + $phi_tham_dinh_den_thoi_diem_dao_han;
			$total['phi_gia_han_den_thoi_diem_dao_han'] = $total['phi_gia_han_den_thoi_diem_dao_han'] + $phi_gia_han_den_thoi_diem_dao_han;
			$total['phi_phat_sinh_den_thoi_diem_dao_han'] = $total['phi_phat_sinh_den_thoi_diem_dao_han'] + $phi_phat_sinh_den_thoi_diem_dao_han;
			$total['phi_tra_cham_den_thoi_diem_dao_han'] = $total['phi_tra_cham_den_thoi_diem_dao_han'] + $phi_tra_cham_den_thoi_diem_dao_han;
			$total['tong_phi_den_thoi_diem_dao_han'] = $total['tong_phi_den_thoi_diem_dao_han'] + $totalFee;

			$total['lai_du_thu_thang_Tn'] = $total['lai_du_thu_thang_Tn'] + $lai_du_thu_thang_Tn;
			$total['phi_du_thu_thang_Tn'] = $total['phi_du_thu_thang_Tn'] + $phi_du_thu_thang_Tn;

			$total['du_no_goc_thang_truoc'] = $total['du_no_goc_thang_truoc'] + $du_no_goc_thang_truoc;
			$total['du_no_lai_thang_truoc'] = $total['du_no_lai_thang_truoc'] + $du_no_lai_thang_truoc;
			$total['du_no_phi_thang_truoc'] = $total['du_no_phi_thang_truoc'] + $du_no_phi_thang_truoc;


			$total['so_tien_goc_da_thu_hoi'] = $total['so_tien_goc_da_thu_hoi'] + $so_tien_goc_da_thu_hoi;
			$total['so_tien_lai_da_thu_hoi'] = $total['so_tien_lai_da_thu_hoi'] + $so_tien_lai_da_thu_hoi;
			$total['so_tien_phi_da_thu_hoi'] = $total['so_tien_phi_da_thu_hoi'] + $so_tien_phi_da_thu_hoi;

			$total['so_tien_phi_cham_tra_da_thu_hoi_thang_hien_tai'] = $total['so_tien_phi_cham_tra_da_thu_hoi_thang_hien_tai'] + $so_tien_phi_cham_tra_da_thu_hoi_thang_hien_tai;
			$total['so_tien_phi_truoc_han_da_thu_hoi_thang_hien_tai'] = $this->tong['so_tien_phi_truoc_han_da_thu_hoi_thang_hien_tai'] + $so_tien_phi_truoc_han_da_thu_hoi_thang_hien_tai;
			$total['tong_thu_hoi_thang_T'] = $total['tong_thu_hoi_thang_T'] + $tong_thu_hoi_thang_T;


			$total['tong_thu_hoi_luy_ke_thang_truoc'] = $total['tong_thu_hoi_luy_ke_thang_truoc'] + $tong_thu_hoi_luy_ke_thang_truoc + $tien_thua_tat_toan;
			$total['tong_thu_hoi_luy_ke_thang_Tn'] = $total['tong_thu_hoi_luy_ke_thang_Tn'] + $tong_thu_hoi_luy_ke_thang_Tn + $tien_thua_tat_toan;
			$total['so_tien_goc_con_lai'] = $total['so_tien_goc_con_lai'] + $so_tien_goc_con_lai;
			$total['so_tien_lai_con_lai'] = $total['so_tien_lai_con_lai'] + $so_tien_lai_con_lai;
			$total['so_tien_phi_con_lai'] = $total['so_tien_phi_con_lai'] + $so_tien_phi_con_lai;
		}

		$this->data["contracts"] = $contracts;
		$this->data["total"] = $total;

		$this->data["count"] = $count;
		$this->data["pageName"] = "Theo dõi khoản vay T hiện tại";
		$this->data['template'] = 'web/accounting_system_update/follow_current_month';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function process()
	{
		$start = !empty($_GET['fdate_export']) ? $_GET['fdate_export'] : "";
		if (empty($start)) {
			$this->session->set_flashdata('error', "Hãy chọn tháng");
			redirect(base_url('aSCurrentMonth'));
		}

		$data = array();
		if (!empty($start)) $data['start'] = $start;
		$infor = $this->api->apiPost($this->userInfo['token'], "accountingSystemUpdate/follow_current_month", $data);
//		echo "<pre>";
//		var_dump($infor->data);
//		echo "</pre>";
//
//        die();
		//Calculate to export excel
		if (!empty($infor->data)) {
			$this->export_part1($infor->data);
			$this->export_part2($infor->data);
			$this->export_part3($infor->data);
			$this->export_part4($infor->data);

			$this->export_part5($infor->data);
			$this->export_part6($infor->data, $start);
			$this->export_part7($infor->data, $start);

			$this->lastRow_Tong();

			//-------------------------------
			$this->callLibExcel('bao_cao_theo_doi_khoan_vay_thang-' . date('d-m-Y-H:i:s-') . $start . '.xlsx');

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
			redirect(base_url('aSCurrentMonth'));
		}
	}

	private function export_part1($contracts)
	{
		$this->sheet->mergeCells("A1:O1");
		$this->sheet->setCellValue('A1', 'Thông tin hợp đồng vay');
		$this->sheet->setCellValue('A2', 'STT');
		$this->sheet->setCellValue('B2', 'Mã phiếu ghi');
		$this->sheet->setCellValue('C2', 'Mã Hợp đồng vay');
		$this->sheet->setCellValue('D2', 'Mã phụ lục hợp đồng vay');
		$this->sheet->setCellValue('E2', 'Thời hạn vay (ngày)');
		$this->sheet->setCellValue('F2', 'Ngày giải ngân');
		$this->sheet->setCellValue('G2', 'Ngày đáo hạn');
		$this->sheet->setCellValue('H2', 'Tên người vay');
		$this->sheet->setCellValue('I2', 'Mã người vay ( trùng CMT)');
		$this->sheet->setCellValue('J2', 'Tên nhà đầu tư');
		$this->sheet->setCellValue('K2', 'Mã NĐT');
		$this->sheet->setCellValue('L2', 'Phòng giao dịch giải ngân');
		$this->sheet->setCellValue('M2', 'Hình thức cầm cố');
		$this->sheet->setCellValue('N2', 'Số tiền vay');
		$this->sheet->setCellValue('O2', 'Hình thức tính lãi');

		//Set style
		$this->setStyle("A1:O1");
		$this->setStyle("A2");
		$this->setStyle("B2");
		$this->setStyle("C2");
		$this->setStyle("D2");
		$this->setStyle("E2");
		$this->setStyle("F2");
		$this->setStyle("G2");
		$this->setStyle("H2");
		$this->setStyle("I2");
		$this->setStyle("J2");
		$this->setStyle("K2");
		$this->setStyle("L2");
		$this->setStyle("M2");
		$this->setStyle("N2");
		$this->setStyle("O2");

		$i = 4;
		$this->numberRowLastColumn = 4;
		$index = 1;

		foreach ($contracts as $item) {
			//Hình thức trả
			$typePay = "";
			$type_interest = !empty($item->loan_infor->type_interest) ? $item->loan_infor->type_interest : "";
			if ($type_interest == 1) {
				$typePay = "Lãi hàng tháng, gốc hàng tháng";
			} else {
				$typePay = "Lãi hàng tháng, gốc cuối kỳ";
			}
			//Số tiền giải ngân
			$amount = 0;
			if (empty($item->count_extend)) {
				$amount = !empty($item->loan_infor->amount_money) ? $item->loan_infor->amount_money : 0;
			}
			//$amountExtend = !empty($item->amount_extend) ? $item->amount_extend : 0;
			$this->sheet->setCellValue('A' . $i, $index);
			$index++;
			$codeTransaction = "";
			if (!empty($item->investor_code) && $item->investor_code == 'vimo' && $item->status_create_withdrawal == 'success') {
				$codeTransaction = $item->response_get_transaction_withdrawal_status->withdrawal_transaction_id;
			} else if (!empty($item->investor_code) && !empty($item->code_transaction_bank_disbursement)) {
				$codeTransaction = $item->code_transaction_bank_disbursement;
			}
			$this->sheet->setCellValue('B' . $i,  $item->code_contract);
			$this->sheet->setCellValue('C' . $i, $this->contract_model->getMaHopDongVay($item));
			//$this->sheet->setCellValue('D'.$i, !empty($item->code_contract_child) ? $item->code_contract_child : "");
			$this->sheet->setCellValue('D' . $i, $this->contract_model->getMaPhuLuc($item));
			$this->sheet->setCellValue('E' . $i, $item->debt->thoi_han_vay);
			$this->sheet->setCellValue('F' . $i, !empty($item->disbursement_date) ? $this->time_model->convertTimestampToDatetime_($item->disbursement_date) : "");
			$this->sheet->setCellValue('G' . $i, !empty($item->expire_date) ? $this->time_model->convertTimestampToDatetime_($item->expire_date) : "");
			$this->sheet->setCellValue('H' . $i, $item->customer_infor->customer_name);
			$this->sheet->setCellValue('I' . $i, $item->customer_infor->customer_identify);
			$this->sheet->setCellValue('J' . $i, !empty($item->investor_infor->name) ? $item->investor_infor->name : "");
			$this->sheet->setCellValue('K' . $i, !empty($item->investor_infor->code) ? $item->investor_infor->code : "");
			$this->sheet->setCellValue('L' . $i, !empty($item->store->name) ? $item->store->name : "");
			$this->sheet->setCellValue('M' . $i, !empty($item->loan_infor) && !empty($item->loan_infor->type_loan->code) && !empty($item->loan_infor->type_property->code) ? $item->loan_infor->type_loan->code . '-' . $item->loan_infor->type_property->code : "");

			$this->sheet->setCellValue('N' . $i, round($amount))
				->getStyle('N' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$this->sheet->setCellValue('O' . $i, $typePay);

			$this->tong['so_tien_vay'] = $this->tong['so_tien_vay'] + $amount;

			$i++;
			$this->numberRowLastColumn++;
		}
	}

	private function export_part2($contracts)
	{
		$this->sheet->mergeCells("P1:W1");
		$this->sheet->setCellValue('P1', 'Tháng T');
		$this->sheet->setCellValue('P2', 'Gốc vay phải thu');
		$this->sheet->setCellValue('Q2', 'Lãi vay phải trả NĐT');
		$this->sheet->setCellValue('R2', 'Phí tư vấn');
		$this->sheet->setCellValue('S2', 'Phí thẩm định');
		$this->sheet->setCellValue('T2', 'Phí trả chậm');
		$this->sheet->setCellValue('U2', 'Phí trả trước');
		$this->sheet->setCellValue('V2', 'Phí gia hạn khoản vay');
		$this->sheet->setCellValue('W2', 'Tổng phí');
		//Set style
		$this->setStyle("P1:W1");
		$this->setStyle("P2");
		$this->setStyle("Q2");
		$this->setStyle("R2");
		$this->setStyle("S2");
		$this->setStyle("T2");
		$this->setStyle("U2");
		$this->setStyle("V2");
		$this->setStyle("W2");


		$i = 4;

		foreach ($contracts as $item) {
			if ($item->status == 33 || $item->status == 34) {
				//Gốc vay phải thu
				$goc_vay_phai_thu = 0;
				//Lãi vay (trả nhà ĐT)
				$interestPayInvestor = 0;
				//Phí tư vấn
				$feeAdvisory = 0;
				//Phí thẩm định
				$feeExpertise = 0;
				//Tiền thừa tất toán
				$tien_thua_tat_toan = 0;
				//Phí trả chậm
				$feePayDelay = 0;
				//Phí trả trước = phí tất toán trước hạn
				$feeFinishContract = 0;
				//Phí gia hạn khoản vay
				$feeExtend = 0;
				//Tổng phí
				$totalFee = 0;
			} else {
				//Gốc vay phải thu
				$goc_vay_phai_thu = $this->gocVayPhaiThu_P4($item->bang_lai_ky[0]);
				//Lãi vay (trả nhà ĐT)
				$interestPayInvestor = $this->getQ($item->bang_lai_ky[0]);
				//Phí tư vấn
				$feeAdvisory = $this->getPhiTuVan($item->bang_lai_ky[0]);
				//Phí thẩm định
				$feeExpertise = $this->getPhiThamDinh($item->bang_lai_ky[0]);
				//Tiền thừa tất toán
				$tien_thua_tat_toan = $this->getTienThuaTatToan($item->bang_lai_ky[0]);
				//Phí trả chậm
				$feePayDelay = !empty($item->bang_lai_ky[0]->fee_delay_pay) ? $item->bang_lai_ky[0]->fee_delay_pay : 0;
				//Phí trả trước = phí tất toán trước hạn
				$feeFinishContract = !empty($item->bang_lai_ky[0]->fee_finish_contract) ? $item->bang_lai_ky[0]->fee_finish_contract : 0;
				//Phí gia hạn khoản vay
				$feeExtend = !empty($item->bang_lai_ky[0]->fee_extend) ? $item->bang_lai_ky[0]->fee_extend : 0;
				//Tổng phí
				$totalFee = $this->getW($item);
			}
			$this->sheet->setCellValue('P' . $i, round($goc_vay_phai_thu))
				->getStyle('P' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('Q' . $i, round($interestPayInvestor))
				->getStyle('Q' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$this->sheet->setCellValue('R' . $i, round($feeAdvisory))
				->getStyle('R' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('S' . $i, round($feeExpertise))
				->getStyle('S' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('T' . $i, round($feePayDelay))
				->getStyle('T' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('U' . $i, round($feeFinishContract))
				->getStyle('U' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('V' . $i, round($feeExtend))
				->getStyle('V' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('W' . $i, round($totalFee))
				->getStyle('W' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$this->tong['goc_vay_phai_thu'] = $this->tong['goc_vay_phai_thu'] + $goc_vay_phai_thu;
			$this->tong['lai_vay_phai_tra_NDT'] = $this->tong['lai_vay_phai_tra_NDT'] + $interestPayInvestor;
			$this->tong['phi_tu_van'] = $this->tong['phi_tu_van'] + $feeAdvisory;
			$this->tong['phi_tra_cham'] = $this->tong['phi_tra_cham'] + $feePayDelay;
			$this->tong['phi_tham_dinh'] = $this->tong['phi_tham_dinh'] + $feeExpertise;
			$this->tong['phi_gia_han_khoan_vay'] = $this->tong['phi_gia_han_khoan_vay'] + $feeExtend;
			$this->tong['phi_tra_truoc'] = $this->tong['phi_tra_truoc'] + $feeFinishContract;
			$this->tong['tong_phi'] = $this->tong['tong_phi'] + $totalFee;

			$i++;
		}
	}

	private function export_part3($contracts)
	{
		$this->sheet->mergeCells("X1:X2");
		$this->sheet->mergeCells("Y1:Y2");
		$this->sheet->setCellValue('X1', 'Lãi lũy kế đến tháng Tn');
		$this->sheet->setCellValue('Y1', 'Phí lũy kế đến tháng Tn');

		//Set style
		$this->setStyle("X1:X2");
		$this->setStyle("Y1:Y2");

		$i = 4;

		foreach ($contracts as $item) {
			$lai_luy_ke_den_thang_Tn_tru_1 = !empty($item->lai_luy_ke_den_thang_Tn) ? $item->lai_luy_ke_den_thang_Tn : 0;

			//$lai_luy_ke_den_thang_Tn = $lai_luy_ke_den_thang_Tn_tru_1 + $interestPayInvestor;
			$lai_luy_ke_den_thang_Tn = $lai_luy_ke_den_thang_Tn_tru_1;
			//Phí lũy kế đến tháng Tn
			//$phi_luy_ke_den_thang_Tn = $this->get_phi_luy_ke_den_thang_Tn($item);

			$phi_tu_van_luy_ke_den_thang_Tn = !empty($item->phi_tu_van_luy_ke_den_thang_Tn) ? $item->phi_tu_van_luy_ke_den_thang_Tn : 0;
			$phi_tham_dinh_luy_ke_den_thang_Tn = !empty($item->phi_tham_dinh_luy_ke_den_thang_Tn) ? $item->phi_tham_dinh_luy_ke_den_thang_Tn : 0;
			// $phi_tra_cham_luy_ke_den_thang_Tn = !empty($item->phi_tra_cham_luy_ke_den_thang_Tn) ? $item->phi_tra_cham_luy_ke_den_thang_Tn : 0;
			// $phi_tra_truoc_luy_ke_den_thang_Tn = !empty($item->phi_tra_truoc_luy_ke_den_thang_Tn) ? $item->phi_tra_truoc_luy_ke_den_thang_Tn : 0;
			// $phi_gia_han_luy_ke_den_thang_Tn = !empty($item->phi_gia_han_luy_ke_den_thang_Tn) ? $item->phi_gia_han_luy_ke_den_thang_Tn : 0;
			// $phi_phat_sinh_luy_ke_den_thang_Tn = !empty($item->phi_phat_sinh_luy_ke_den_thang_Tn) ? $item->phi_phat_sinh_luy_ke_den_thang_Tn : 0;

			$phi_luy_ke_den_thang_Tn = $phi_tu_van_luy_ke_den_thang_Tn +
				$phi_tham_dinh_luy_ke_den_thang_Tn;
			// $phi_tra_cham_luy_ke_den_thang_Tn +
			// $phi_tra_truoc_luy_ke_den_thang_Tn +
			// $phi_phat_sinh_luy_ke_den_thang_Tn +
			// $phi_gia_han_luy_ke_den_thang_Tn;


			$this->sheet->setCellValue('X' . $i, round($lai_luy_ke_den_thang_Tn))
				->getStyle('X' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('Y' . $i, round($phi_luy_ke_den_thang_Tn))
				->getStyle('Y' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$this->tong['lai_luy_ke_den_thang_Tn'] = $this->tong['lai_luy_ke_den_thang_Tn'] + $lai_luy_ke_den_thang_Tn;
			$this->tong['phi_luy_ke_den_thang_Tn'] = $this->tong['phi_luy_ke_den_thang_Tn'] + $phi_luy_ke_den_thang_Tn;

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

	private function getW($item)
	{
		//Phí tư vấn
		//$feeAdvisory = !empty($item->bang_lai_ky[0]->phi_tu_van) ? $item->bang_lai_ky[0]->phi_tu_van : 0;
		$feeAdvisory = $this->getPhiTuVan($item->bang_lai_ky[0]);
		//Phí thẩm định
		//$feeExpertise = !empty($item->bang_lai_ky[0]->phi_tham_dinh) ? $item->bang_lai_ky[0]->phi_tham_dinh : 0;
		$feeExpertise = $this->getPhiThamDinh($item->bang_lai_ky[0]);
		//Phí trả chậm
		$feePayDelay = !empty($item->bang_lai_ky[0]->fee_delay_pay) ? $item->bang_lai_ky[0]->fee_delay_pay : 0;
		//Phí trả trước = phí tất toán trước hạn
		$feeFinishContract = !empty($item->bang_lai_ky[0]->fee_finish_contract) ? $item->bang_lai_ky[0]->fee_finish_contract : 0;
		//Phí gia hạn khoản vay
		$feeExtend = !empty($item->bang_lai_ky[0]->fee_extend) ? $item->bang_lai_ky[0]->fee_extend : 0;
		$totalFee = $feeAdvisory + $feeExpertise + $feePayDelay + $feeFinishContract + $feeExtend;
		return $totalFee;
	}

	private function lastRow_Tong()
	{
		$this->sheet->setCellValue('B' . $this->numberRowLastColumn, "Tổng")
			->getStyle('B' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//N4
		$this->sheet->setCellValue('N' . $this->numberRowLastColumn, round($this->tong['so_tien_vay']))
			->getStyle('N' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//P4
		$this->sheet->setCellValue('P' . $this->numberRowLastColumn, round($this->tong['goc_vay_phai_thu']))
			->getStyle('P' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//Q4
		$this->sheet->setCellValue('Q' . $this->numberRowLastColumn, round($this->tong['lai_vay_phai_tra_NDT']))
			->getStyle('Q' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//R4
		$this->sheet->setCellValue('R' . $this->numberRowLastColumn, round($this->tong['phi_tu_van']))
			->getStyle('R' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//S4
		$this->sheet->setCellValue('S' . $this->numberRowLastColumn, round($this->tong['phi_tham_dinh']))
			->getStyle('S' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//T4
		$this->sheet->setCellValue('T' . $this->numberRowLastColumn, round($this->tong['phi_tra_cham']))
			->getStyle('T' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//AD4
		$this->sheet->setCellValue('AE' . $this->numberRowLastColumn, round($this->tong['phi_tra_cham_den_thoi_diem_dao_han']))
			->getStyle('AE' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

		//AE4
		$this->sheet->setCellValue('AD' . $this->numberRowLastColumn, round($this->tong['phi_gia_han_den_thoi_diem_dao_han']))
			->getStyle('AD' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//U4
		$this->sheet->setCellValue('U' . $this->numberRowLastColumn, round($this->tong['phi_tra_truoc_luy_ke_den_thang_Tn']))
			->getStyle('U' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//V4
		$this->sheet->setCellValue('V' . $this->numberRowLastColumn, round($this->tong['phi_gia_han_luy_ke_den_thang_Tn']))
			->getStyle('V' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//Y4
		$this->sheet->setCellValue('Y' . $this->numberRowLastColumn, round($this->tong['phi_luy_ke_den_thang_Tn']))
			->getStyle('Y' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//W4
		$this->sheet->setCellValue('W' . $this->numberRowLastColumn, round($this->tong['tong_phi']))
			->getStyle('W' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//X4
		$this->sheet->setCellValue('X' . $this->numberRowLastColumn, round($this->tong['lai_luy_ke_den_thang_Tn']))
			->getStyle('X' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//Z4
		$this->sheet->setCellValue('Z' . $this->numberRowLastColumn, round($this->tong['goc_vay_phai_thu_den_thoi_diem_dao_han']))
			->getStyle('Z' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//AA4
		$this->sheet->setCellValue('AA' . $this->numberRowLastColumn, round($this->tong['lai_vay_phai_tra_NDT_den_thoi_diem_dao_han']))
			->getStyle('AA' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//AB4
		$this->sheet->setCellValue('AB' . $this->numberRowLastColumn, round($this->tong['phi_tu_van_den_thoi_diem_dao_han']))
			->getStyle('AB' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//AC4
		$this->sheet->setCellValue('AC' . $this->numberRowLastColumn, round($this->tong['phi_tham_dinh_den_thoi_diem_dao_han']))
			->getStyle('AC' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//AF4
		$this->sheet->setCellValue('AD' . $this->numberRowLastColumn, round($this->tong['phi_gia_han_den_thoi_diem_dao_han']))
			->getStyle('AD' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//AG4
		$this->sheet->setCellValue('AG' . $this->numberRowLastColumn, round($this->tong['phi_phat_sinh_den_thoi_diem_dao_han']))
			->getStyle('AG' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//AH4
		$this->sheet->setCellValue('AI' . $this->numberRowLastColumn, round($this->tong['lai_du_thu_thang_Tn']))
			->getStyle('AI' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//AI4
		$this->sheet->setCellValue('AJ' . $this->numberRowLastColumn, round($this->tong['phi_du_thu_thang_Tn']))
			->getStyle('AJ' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//AJ4
		$this->sheet->setCellValue('AK' . $this->numberRowLastColumn, round($this->tong['du_no_goc_thang_truoc']))
			->getStyle('AK' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//AK4
		$this->sheet->setCellValue('AL' . $this->numberRowLastColumn, round($this->tong['du_no_lai_thang_truoc']))
			->getStyle('AL' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//AL4
		$this->sheet->setCellValue('AM' . $this->numberRowLastColumn, round($this->tong['du_no_phi_thang_truoc']))
			->getStyle('AM' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//AM4
		$this->sheet->setCellValue('AN' . $this->numberRowLastColumn, round($this->tong['so_tien_goc_da_thu_hoi']))
			->getStyle('AN' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//AN4
		$this->sheet->setCellValue('AO' . $this->numberRowLastColumn, round($this->tong['so_tien_lai_da_thu_hoi']))
			->getStyle('AO' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//AO4
		$this->sheet->setCellValue('AP' . $this->numberRowLastColumn, round($this->tong['so_tien_phi_da_thu_hoi']))
			->getStyle('AP' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//AP4

		$this->sheet->setCellValue('AQ' . $this->numberRowLastColumn, round($this->tong['so_tien_phi_cham_tra_da_thu_hoi_thang_hien_tai']))
			->getStyle('AQ' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//AN4
		$this->sheet->setCellValue('AR' . $this->numberRowLastColumn, round($this->tong['so_tien_phi_truoc_han_da_thu_hoi_thang_hien_tai']))
			->getStyle('AR' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//AO4

		$this->sheet->setCellValue('AS' . $this->numberRowLastColumn, round($this->tong['so_tien_phi_gia_han_da_tra']))
			->getStyle('AS' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

		$this->sheet->setCellValue('AT' . $this->numberRowLastColumn, round($this->tong['so_tien_phi_phat_sinh']))
			->getStyle('AT' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);


		$this->sheet->setCellValue('AU' . $this->numberRowLastColumn, round($this->tong['tong_thu_hoi_thang_T']))
			->getStyle('AU' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);


		$this->sheet->setCellValue('AV' . $this->numberRowLastColumn, round($this->tong['tong_thu_hoi_luy_ke_thang_truoc']))
			->getStyle('AV' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//AQ4
		$this->sheet->setCellValue('AW' . $this->numberRowLastColumn, round($this->tong['tong_thu_hoi_luy_ke_thang_Tn']))
			->getStyle('AW' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//AR4
		$this->sheet->setCellValue('AX' . $this->numberRowLastColumn, round($this->tong['so_tien_goc_con_lai']))
			->getStyle('AX' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//AS4
		$this->sheet->setCellValue('AY' . $this->numberRowLastColumn, round($this->tong['so_tien_lai_con_lai']))
			->getStyle('AY' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
		//AT4
		$this->sheet->setCellValue('AZ' . $this->numberRowLastColumn, round($this->tong['so_tien_phi_con_lai']))
			->getStyle('AZ' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

		$this->sheet->setCellValue('AF' . $this->numberRowLastColumn, round($this->tong['phi_tra_truoc_den_thoi_diem_dao_han']))
			->getStyle('AF' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

		$this->sheet->setCellValue('AH' . $this->numberRowLastColumn, round($this->tong['tong_phi_den_thoi_diem_dao_han']))
			->getStyle('AH' . $this->numberRowLastColumn)
			->applyFromArray(array("font" => array("bold" => true)))
			->getNumberFormat()
			->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

	}

	private function export_part4($contracts)
	{
		$this->sheet->mergeCells("Z1:AH1");
		$this->sheet->setCellValue('Z1', 'Đến thời điểm đáo hạn');
		$this->sheet->setCellValue('Z2', 'Gốc vay phải thu');
		$this->sheet->setCellValue('AA2', 'Lãi vay phải trả NĐT');
		$this->sheet->setCellValue('AB2', 'Phí tư vấn');
		$this->sheet->setCellValue('AC2', 'Phí thẩm định');
		$this->sheet->setCellValue('AD2', 'Phí gia hạn');
		$this->sheet->setCellValue('AE2', 'Phí trả chậm');
		$this->sheet->setCellValue('AF2', 'Phí trả trước');
		$this->sheet->setCellValue('AG2', 'Phí quá hạn');

		$this->sheet->setCellValue('AH2', 'Tổng phí');
		//Set style
		$this->setStyle("Z1:AH1");
		$this->setStyle("Z2");
		$this->setStyle("AA2");
		$this->setStyle("AB2");
		$this->setStyle("AC2");
		$this->setStyle("AD2");
		$this->setStyle("AE2");
		$this->setStyle("AF2");
		$this->setStyle("AG2");
		$this->setStyle("AH2");


		$i = 4;

		foreach ($contracts as $item) {
			if ($item->status == 33 || $item->status == 34) {
				$goc_vay_phai_thu_den_thoi_diem_dao_han = 0;
			} else {
				//Gốc vay phải thu ( bảng lãi KỲ)
				$goc_vay_phai_thu_den_thoi_diem_dao_han = !empty($item->goc_vay_phai_thu_den_thoi_diem_dao_han) ? $item->goc_vay_phai_thu_den_thoi_diem_dao_han : 0;
			}
			//Lãi vay phải trả NĐT( bảng lãi KỲ)
			$lai_vay_phai_tra_NDT_den_thoi_diem_dao_han = !empty($item->lai_vay_phai_tra_NDT_den_thoi_diem_dao_han) ? $item->lai_vay_phai_tra_NDT_den_thoi_diem_dao_han : 0;
			//Phí tư vấn( bảng lãi KỲ)
			$phi_tu_van_den_thoi_diem_dao_han = !empty($item->phi_tu_van_den_thoi_diem_dao_han) ? $item->phi_tu_van_den_thoi_diem_dao_han : 0;
			//Phí thẩm định( bảng lãi KỲ)
			$phi_tham_dinh_den_thoi_diem_dao_han = !empty($item->phi_tham_dinh_den_thoi_diem_dao_han) ? $item->phi_tham_dinh_den_thoi_diem_dao_han : 0;
			//Phí trả chậm( bảng lãi KỲ )
			$phi_tra_cham_den_thoi_diem_dao_han = !empty($item->phi_tra_cham_den_thoi_diem_dao_han) ? $item->phi_tra_cham_den_thoi_diem_dao_han : 0;
			//Phí trả trước( bảng lãi KỲ)
			$phi_tra_truoc_den_thoi_diem_dao_han = !empty($item->phi_tra_truoc_den_thoi_diem_dao_han) ? $item->phi_tra_truoc_den_thoi_diem_dao_han : 0;
			//Phí gia hạn khoản vay( bảng lãi KỲ)
			$phi_gia_han_den_thoi_diem_dao_han = !empty($item->phi_gia_han_den_thoi_diem_dao_han) ? $item->phi_gia_han_den_thoi_diem_dao_han : 0;
			//Phí phát sinh khoản vay( bảng lãi KỲ)
			$phi_phat_sinh_den_thoi_diem_dao_han = !empty($item->phi_phat_sinh_den_thoi_diem_dao_han) ? $item->phi_phat_sinh_den_thoi_diem_dao_han : 0;
			//Tổng phí
			$totalFee = $phi_tu_van_den_thoi_diem_dao_han +
				$phi_tham_dinh_den_thoi_diem_dao_han +
				$phi_tra_cham_den_thoi_diem_dao_han +
				$phi_tra_truoc_den_thoi_diem_dao_han +
				$phi_phat_sinh_den_thoi_diem_dao_han +
				$phi_gia_han_den_thoi_diem_dao_han;

			$this->sheet->setCellValue('Z' . $i, round($goc_vay_phai_thu_den_thoi_diem_dao_han))
				->getStyle('Z' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AA' . $i, round($lai_vay_phai_tra_NDT_den_thoi_diem_dao_han))
				->getStyle('AA' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AB' . $i, round($phi_tu_van_den_thoi_diem_dao_han))
				->getStyle('AB' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AC' . $i, round($phi_tham_dinh_den_thoi_diem_dao_han))
				->getStyle('AC' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AD' . $i, round($phi_gia_han_den_thoi_diem_dao_han))
				->getStyle('AD' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AE' . $i, round($phi_tra_cham_den_thoi_diem_dao_han))
				->getStyle('AE' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AF' . $i, round($phi_tra_truoc_den_thoi_diem_dao_han))
				->getStyle('AF' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AG' . $i, round($phi_phat_sinh_den_thoi_diem_dao_han))
				->getStyle('AG' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$this->sheet->setCellValue('AH' . $i, round($totalFee))
				->getStyle('AH' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$this->tong['goc_vay_phai_thu_den_thoi_diem_dao_han'] = $this->tong['goc_vay_phai_thu_den_thoi_diem_dao_han'] + $goc_vay_phai_thu_den_thoi_diem_dao_han;
			$this->tong['lai_vay_phai_tra_NDT_den_thoi_diem_dao_han'] = $this->tong['lai_vay_phai_tra_NDT_den_thoi_diem_dao_han'] + $lai_vay_phai_tra_NDT_den_thoi_diem_dao_han;
			$this->tong['phi_tu_van_den_thoi_diem_dao_han'] = $this->tong['phi_tu_van_den_thoi_diem_dao_han'] + $phi_tu_van_den_thoi_diem_dao_han;
			$this->tong['phi_tham_dinh_den_thoi_diem_dao_han'] = $this->tong['phi_tham_dinh_den_thoi_diem_dao_han'] + $phi_tham_dinh_den_thoi_diem_dao_han;
			$this->tong['phi_gia_han_den_thoi_diem_dao_han'] = $this->tong['phi_gia_han_den_thoi_diem_dao_han'] + $phi_gia_han_den_thoi_diem_dao_han;
			$this->tong['phi_phat_sinh_den_thoi_diem_dao_han'] = $this->tong['phi_phat_sinh_den_thoi_diem_dao_han'] + $phi_phat_sinh_den_thoi_diem_dao_han;
			$this->tong['phi_tra_cham_den_thoi_diem_dao_han'] = $this->tong['phi_tra_cham_den_thoi_diem_dao_han'] + $phi_tra_cham_den_thoi_diem_dao_han;
			$this->tong['phi_tra_truoc_den_thoi_diem_dao_han'] = $this->tong['phi_tra_truoc_den_thoi_diem_dao_han'] + $phi_tra_truoc_den_thoi_diem_dao_han;
			$this->tong['tong_phi_den_thoi_diem_dao_han'] = $this->tong['tong_phi_den_thoi_diem_dao_han'] + $totalFee;

			$i++;
		}
	}

	private function export_part5($contracts)
	{
		$this->sheet->mergeCells("AI1:AI2");
		$this->sheet->mergeCells("AJ1:AJ2");
		$this->sheet->setCellValue('AI1', 'Lãi dự thu tháng Tn');
		$this->sheet->setCellValue('AJ1', 'Phí dự thu tháng Tn');

		//Set style
		$this->setStyle("AI1:AI2");
		$this->setStyle("AJ1:AJ2");

		$i = 4;

		foreach ($contracts as $item) {
			//Lãi vay phải trả NĐT( bảng lãi KỲ)
			$lai_vay_phai_tra_NDT_den_thoi_diem_dao_han = !empty($item->lai_vay_phai_tra_NDT_den_thoi_diem_dao_han) ? $item->lai_vay_phai_tra_NDT_den_thoi_diem_dao_han : 0;

			//$lai_luy_ke_den_thang_Tn = $lai_luy_ke_den_thang_Tn_tru_1 + $interestPayInvestor;
			$lai_luy_ke_den_thang_Tn = !empty($item->lai_luy_ke_den_thang_Tn) ? $item->lai_luy_ke_den_thang_Tn : 0;
			$tong_phi_cua_1_hang_den_thoi_diem_dao_han = $this->get_tong_phi_cua_1_hang_den_thoi_diem_dao_han($item);

			//Lãi dự thu tháng Tn
			$lai_du_thu_thang_Tn = $lai_vay_phai_tra_NDT_den_thoi_diem_dao_han -
				$lai_luy_ke_den_thang_Tn;

			//Phí dự thu tháng Tn
			$phi_luy_ke_den_thang_Tn = $this->get_phi_luy_ke_den_thang_Tn($item);
			$phi_du_thu_thang_Tn = $tong_phi_cua_1_hang_den_thoi_diem_dao_han - $phi_luy_ke_den_thang_Tn;

//            $this->sheet->setCellValue('AH'.$i, round($lai_du_thu_thang_Tn));
//            $this->sheet->setCellValue('AI'.$i, round($phi_du_thu_thang_Tn));

			$this->sheet->setCellValue('AI' . $i, round($lai_du_thu_thang_Tn))
				->getStyle('AI' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AJ' . $i, round($phi_du_thu_thang_Tn))
				->getStyle('AJ' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			//$this->sheet->setCellValue('AH'.$i, $lai_vay_phai_tra_NDT_den_thoi_diem_dao_han.'-'.$lai_luy_ke_den_thang_Tn);
			//$this->sheet->setCellValue('AI'.$i, $tong_phi_cua_1_hang_den_thoi_diem_dao_han.'-'.$phi_luy_ke_den_thang_Tn);

			$this->tong['lai_du_thu_thang_Tn'] = $this->tong['lai_du_thu_thang_Tn'] + $lai_du_thu_thang_Tn;
			$this->tong['phi_du_thu_thang_Tn'] = $this->tong['phi_du_thu_thang_Tn'] + $phi_du_thu_thang_Tn;

			$i++;
		}
	}

	private function get_tong_phi_cua_1_hang_den_thoi_diem_dao_han($item)
	{
		//Phí tư vấn( bảng lãi KỲ)
		$phi_tu_van_den_thoi_diem_dao_han = !empty($item->phi_tu_van_den_thoi_diem_dao_han) ? $item->phi_tu_van_den_thoi_diem_dao_han : 0;
		//Phí thẩm định( bảng lãi KỲ)
		$phi_tham_dinh_den_thoi_diem_dao_han = !empty($item->phi_tham_dinh_den_thoi_diem_dao_han) ? $item->phi_tham_dinh_den_thoi_diem_dao_han : 0;
		//Phí trả chậm( bảng lãi KỲ )
		$phi_tra_cham_den_thoi_diem_dao_han = !empty($item->phi_tra_cham_den_thoi_diem_dao_han) ? $item->phi_tra_cham_den_thoi_diem_dao_han : 0;
		//Phí trả trước( bảng lãi KỲ)
		$phi_tra_truoc_den_thoi_diem_dao_han = !empty($item->phi_tra_truoc_den_thoi_diem_dao_han) ? $item->phi_tra_truoc_den_thoi_diem_dao_han : 0;
		//Phí gia hạn khoản vay( bảng lãi KỲ)
		$phi_gia_han_den_thoi_diem_dao_han = !empty($item->phi_gia_han_den_thoi_diem_dao_han) ? $item->phi_gia_han_den_thoi_diem_dao_han : 0;
		$phi_phat_sinh_den_thoi_diem_dao_han = !empty($item->phi_phat_sinh_den_thoi_diem_dao_han) ? $item->phi_phat_sinh_den_thoi_diem_dao_han : 0;
		//Tổng phí
		$totalFee = $phi_tu_van_den_thoi_diem_dao_han +
			$phi_tham_dinh_den_thoi_diem_dao_han +
			$phi_tra_cham_den_thoi_diem_dao_han +
			$phi_tra_truoc_den_thoi_diem_dao_han +
			$phi_gia_han_den_thoi_diem_dao_han +
			$phi_phat_sinh_den_thoi_diem_dao_han;
		return $totalFee;
	}

	private function get_phi_luy_ke_den_thang_Tn($item)
	{
		$phi_tu_van_luy_ke_den_thang_Tn = !empty($item->phi_tu_van_luy_ke_den_thang_Tn) ? $item->phi_tu_van_luy_ke_den_thang_Tn : 0;
		$phi_tham_dinh_luy_ke_den_thang_Tn = !empty($item->phi_tham_dinh_luy_ke_den_thang_Tn) ? $item->phi_tham_dinh_luy_ke_den_thang_Tn : 0;
		$phi_tra_cham_luy_ke_den_thang_Tn = !empty($item->phi_tra_cham_luy_ke_den_thang_Tn) ? $item->phi_tra_cham_luy_ke_den_thang_Tn : 0;
		$phi_tra_truoc_luy_ke_den_thang_Tn = !empty($item->phi_tra_truoc_luy_ke_den_thang_Tn) ? $item->phi_tra_truoc_luy_ke_den_thang_Tn : 0;
		$phi_gia_han_luy_ke_den_thang_Tn = !empty($item->phi_gia_han_luy_ke_den_thang_Tn) ? $item->phi_gia_han_luy_ke_den_thang_Tn : 0;
		$phi_phat_sinh_luy_ke_den_thang_Tn = !empty($item->phi_phat_sinh_luy_ke_den_thang_Tn) ? $item->phi_phat_sinh_luy_ke_den_thang_Tn : 0;

		$phi_luy_ke_den_thang_Tn = $phi_tu_van_luy_ke_den_thang_Tn +
			$phi_tham_dinh_luy_ke_den_thang_Tn;
//                                   $phi_tra_cham_luy_ke_den_thang_Tn +
//                                   $phi_tra_truoc_luy_ke_den_thang_Tn +
//                                   $phi_phat_sinh_luy_ke_den_thang_Tn +
//                                   $phi_gia_han_luy_ke_den_thang_Tn;
		return $phi_luy_ke_den_thang_Tn;
	}


	private function export_part6($contracts, $start)
	{
		$this->sheet->mergeCells("AK1:AK2");
		$this->sheet->mergeCells("AL1:AL2");
		$this->sheet->mergeCells("AM1:AM2");
		$this->sheet->setCellValue('AK1', 'Gốc tháng trước');
		$this->sheet->setCellValue('AL1', 'Lãi tháng trước');
		$this->sheet->setCellValue('AM1', 'Phí tháng trước');

		//Set style
		$this->setStyle("AK1:AK2");
		$this->setStyle("AL1:AL2");
		$this->setStyle("AM1:AM2");

		$i = 4;

		foreach ($contracts as $item) {
			//Dư gốc tháng trước
//			$du_no_goc_thang_truoc = $this->getAJ4($item);
//			$du_no_lai_thang_truoc = $this->getAK($item);
//			$du_no_phi_thang_truoc = $this->getAL($item);

			$so_tien_goc_da_thu_hoi_thang_truoc = !empty($item->so_tien_goc_da_thu_hoi_luy_ke_thang_truoc) ? $item->so_tien_goc_da_thu_hoi_luy_ke_thang_truoc : 0;
			$so_tien_lai_da_thu_hoi_thang_truoc = !empty($item->so_tien_lai_da_thu_hoi_luy_ke_thang_truoc) ? $item->so_tien_lai_da_thu_hoi_luy_ke_thang_truoc : 0;
			$so_tien_thua_tat_toan_da_thu_hoi = !empty($item->so_tien_thua_tat_toan_da_thu_hoi) ? $item->so_tien_thua_tat_toan_da_thu_hoi : 0;
			$so_tien_thua_thanh_toan_da_thu_hoi = !empty($item->so_tien_thua_thanh_toan_da_thu_hoi) ? $item->so_tien_thua_thanh_toan_da_thu_hoi : 0;
			$so_tien_phi_da_thu_hoi_tien_thua = !empty($item->so_tien_phi_da_thu_hoi_tien_thua) ? $item->so_tien_phi_da_thu_hoi_tien_thua : 0;
			$so_tien_phi_da_thu_hoi_thang_truoc = !empty($item->so_tien_phi_da_thu_hoi_luy_ke_thang_truoc) ? $item->so_tien_phi_da_thu_hoi_luy_ke_thang_truoc : 0;
			$so_tien_phi_da_thu_hoi_thang_truoc = $so_tien_phi_da_thu_hoi_thang_truoc + $so_tien_thua_tat_toan_da_thu_hoi + $so_tien_thua_thanh_toan_da_thu_hoi + $so_tien_phi_da_thu_hoi_tien_thua;
			$so_tien_lai_da_thu_hoi_tien_thua = !empty($item->so_tien_lai_da_thu_hoi_tien_thua) ? $item->so_tien_lai_da_thu_hoi_tien_thua : 0;


			$du_no_goc_thang_truoc = !empty($item->loan_infor->amount_money) ? $item->loan_infor->amount_money - $so_tien_goc_da_thu_hoi_thang_truoc : 0;
			$du_no_lai_thang_truoc = !empty($item->tien_lai_thang_truoc) ? $item->tien_lai_thang_truoc - $so_tien_lai_da_thu_hoi_thang_truoc - $so_tien_lai_da_thu_hoi_tien_thua : 0;
			$du_no_phi_thang_truoc = !empty($item->tien_phi_thang_truoc) ? $item->tien_phi_thang_truoc - $so_tien_phi_da_thu_hoi_thang_truoc : 0;

			$disbursement_date = !empty($item->disbursement_date) ? $item->disbursement_date : 0;
			$startMonth = strtotime(date('Y-m-01', strtotime($start)) . ' 00:00:00');
			$condition_last = [
				'code_contract' => $item->code_contract,
				'status' => 1,
				'type' => 3,
				'ky_tt_xa_nhat' => $item->debt->ky_tt_xa_nhat,
				'status_contract_origin' => $item->status,
				'endMonth' => $startMonth,
			];

			$tranDB = $this->contract_model->get_tran_one_tt($condition_last);
			if (!empty($tranDB)) {

				$du_no_goc_thang_truoc = $tranDB['so_tien_goc_phai_tra_tat_toan'] - $tranDB['so_tien_goc_da_tra'];
				$du_no_lai_thang_truoc = $tranDB['so_tien_lai_phai_tra_tat_toan'] - $tranDB['so_tien_lai_da_tra'];
				$du_no_phi_thang_truoc = $tranDB['so_tien_phi_phai_tra_tat_toan'] - $tranDB['so_tien_phi_da_tra'] + $tranDB['tien_thua_thanh_toan'];

			}
			if (date('Y-m', $disbursement_date) == date('Y-m', $item->plan_contract[0]->time_timestamp)) {
				$du_no_goc_thang_truoc = 0;
				$du_no_lai_thang_truoc = 0;
				$du_no_phi_thang_truoc = 0;
			}
			$status = $this->contract_model->getStatusContract($condition_last);
			if ($status == "Gia hạn") {
				$du_no_goc_thang_truoc = 0;

				$so_tien_phi_da_thu_hoi_thang_truoc = $so_tien_phi_da_thu_hoi_thang_truoc - $so_tien_thua_tat_toan_da_thu_hoi - $so_tien_thua_thanh_toan_da_thu_hoi;

				$du_no_lai_thang_truoc = !empty($item->tien_lai_thang_truoc) ? $item->tien_lai_thang_truoc - $so_tien_lai_da_thu_hoi_thang_truoc - $so_tien_lai_da_thu_hoi_tien_thua : 0;
				$du_no_phi_thang_truoc = !empty($item->tien_phi_thang_truoc) ? $item->tien_phi_thang_truoc - $so_tien_phi_da_thu_hoi_thang_truoc : 0;

			}


			$this->sheet->setCellValue('AK' . $i, round($du_no_goc_thang_truoc))
				->getStyle('AK' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AL' . $i, round($du_no_lai_thang_truoc))
				->getStyle('AL' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AM' . $i, round($du_no_phi_thang_truoc))
				->getStyle('AM' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$this->tong['du_no_goc_thang_truoc'] = $this->tong['du_no_goc_thang_truoc'] + $du_no_goc_thang_truoc;
			$this->tong['du_no_lai_thang_truoc'] = $this->tong['du_no_lai_thang_truoc'] + $du_no_lai_thang_truoc;
			$this->tong['du_no_phi_thang_truoc'] = $this->tong['du_no_phi_thang_truoc'] + $du_no_phi_thang_truoc;

			$i++;
		}
	}

	private function export_part7($contracts, $start)
	{
		$this->sheet->mergeCells("AN1:BA1");
		$this->sheet->setCellValue('AN1', 'Thu hồi');
		$this->sheet->setCellValue('AN2', 'Số tiền gốc đã thu hồi');
		$this->sheet->setCellValue('AO2', 'Số tiền lãi đã thu hồi');
		$this->sheet->setCellValue('AP2', 'Số tiền phí đã thu hồi');

		$this->sheet->setCellValue('AQ2', 'Số tiền phí chậm trả đã thu hồi');
		$this->sheet->setCellValue('AR2', 'Số tiền phí trước hạn đã thu hồi');

		$this->sheet->setCellValue('AS2', 'Số tiền phí gia hạn đã thu hồi ');
		$this->sheet->setCellValue('AT2', 'Số tiền phí quá hạn');

		$this->sheet->setCellValue('AU2', 'Tổng thu hồi tháng T');

		$this->sheet->setCellValue('AV2', 'Tổng thu hồi lũy kế tháng trước');
		$this->sheet->setCellValue('AW2', 'Tổng thu hồi lũy kế tháng T');
		$this->sheet->setCellValue('AX2', 'Số tiền gốc còn lại');
		$this->sheet->setCellValue('AY2', 'Số tiền lãi còn lại');
		$this->sheet->setCellValue('AZ2', 'Số tiền phí còn lại');


		$this->sheet->setCellValue('BA2', 'Trạng thái');
		//Set style
		$this->setStyle("AN1:BA1");
		$this->setStyle("AN2");
		$this->setStyle("AO2");
		$this->setStyle("AP2");
		$this->setStyle("AQ2");
		$this->setStyle("AR2");
		$this->setStyle("AS2");
		$this->setStyle("AT2");
		$this->setStyle("AU2");
		$this->setStyle("AV2");
		$this->setStyle("AW2");
		$this->setStyle("AX2");
		$this->setStyle("AY2");
		$this->setStyle("AZ2");
		$this->setStyle("BA2");
		$i = 4;

		foreach ($contracts as $item) {
			$endMonth_last = strtotime((date('Y-m-t', strtotime($start))) . ' 23:59:59');

			$amount = 0;

			$amount = !empty($item->loan_infor->amount_money) ? $item->loan_infor->amount_money : 0;


			$condition_last = [
				'code_contract' => $item->code_contract,
				'status' => 1,
				'type' => 3,
				'date_pay' => array(
					'$lte' => $endMonth_last
				)

			];
			$status_last = "";
			$status_last = $this->contract_model->getStatusContract($condition_last);

			//Số tiền gốc đã thu hồi
//			$so_tien_goc_da_thu_hoi = $this->getAM4($item);
			//Số tiền lãi đã thu hồi
//			$so_tien_lai_da_thu_hoi = $this->getAN($item);
			//Số tiền phi đã thu hồi
//			$so_tien_phi_da_thu_hoi = $this->getAO($item);

			$tien_lai_1thang_da_tra_tien_thua = !empty($item->tien_lai_1thang_da_tra_tien_thua) ? $item->tien_lai_1thang_da_tra_tien_thua : 0;

			$tien_phi_1thang_da_tra_tien_thua = !empty($item->tien_phi_1thang_da_tra_tien_thua) ? $item->tien_phi_1thang_da_tra_tien_thua : 0;
			$so_tien_goc_da_thu_hoi = !empty($item->tien_goc_1thang_da_tra) ? $item->tien_goc_1thang_da_tra : 0;
			$so_tien_lai_da_thu_hoi = !empty($item->tien_lai_1thang_da_tra) ? $item->tien_lai_1thang_da_tra : 0;
			$so_tien_phi_da_thu_hoi = !empty($item->tien_phi_1thang_da_tra) ? $item->tien_phi_1thang_da_tra : 0;
			$so_tien_thua_thanh_toan_1thang_da_tra = !empty($item->so_tien_thua_thanh_toan_1thang_da_tra) ? $item->so_tien_thua_thanh_toan_1thang_da_tra : 0;
			$so_tien_thua_tat_toan_1thang_da_tra = !empty($item->so_tien_thua_tat_toan_1thang_da_tra) ? $item->so_tien_thua_tat_toan_1thang_da_tra : 0;
			$so_tien_lai_da_thu_hoi = $so_tien_lai_da_thu_hoi + $tien_lai_1thang_da_tra_tien_thua;
			$so_tien_phi_da_thu_hoi = $so_tien_phi_da_thu_hoi + $tien_phi_1thang_da_tra_tien_thua + $so_tien_thua_thanh_toan_1thang_da_tra + $so_tien_thua_tat_toan_1thang_da_tra;
			$so_tien_phi_phat_sinh = !empty($item->tien_phi_phat_sinh_da_tra) ? $item->tien_phi_phat_sinh_da_tra : 0;


			$so_tien_goc_da_thu_hoi_thang_truoc = !empty($item->so_tien_goc_da_thu_hoi_luy_ke_thang_truoc) ? $item->so_tien_goc_da_thu_hoi_luy_ke_thang_truoc : 0;
			$so_tien_lai_da_thu_hoi_thang_truoc = !empty($item->so_tien_lai_da_thu_hoi_luy_ke_thang_truoc) ? $item->so_tien_lai_da_thu_hoi_luy_ke_thang_truoc : 0;
			$so_tien_thua_tat_toan_da_thu_hoi = !empty($item->so_tien_thua_tat_toan_da_thu_hoi) ? $item->so_tien_thua_tat_toan_da_thu_hoi : 0;
			$so_tien_thua_thanh_toan_da_thu_hoi = !empty($item->so_tien_thua_thanh_toan_da_thu_hoi) ? $item->so_tien_thua_thanh_toan_da_thu_hoi : 0;
			$so_tien_phi_da_thu_hoi_tien_thua = !empty($item->so_tien_phi_da_thu_hoi_tien_thua) ? $item->so_tien_phi_da_thu_hoi_tien_thua : 0;
			$so_tien_phi_da_thu_hoi_thang_truoc = !empty($item->so_tien_phi_da_thu_hoi_luy_ke_thang_truoc) ? $item->so_tien_phi_da_thu_hoi_luy_ke_thang_truoc : 0;
			$so_tien_phi_da_thu_hoi_thang_truoc = $so_tien_phi_da_thu_hoi_thang_truoc + $so_tien_thua_tat_toan_da_thu_hoi + $so_tien_thua_thanh_toan_da_thu_hoi + $so_tien_phi_da_thu_hoi_tien_thua;
			$so_tien_lai_da_thu_hoi_tien_thua = !empty($item->so_tien_lai_da_thu_hoi_tien_thua) ? $item->so_tien_lai_da_thu_hoi_tien_thua : 0;

			$du_no_goc_thang_truoc = !empty($item->loan_infor->amount_money) ? $item->loan_infor->amount_money - $so_tien_goc_da_thu_hoi_thang_truoc : 0;
			$du_no_lai_thang_truoc = !empty($item->tien_lai_thang_truoc) ? $item->tien_lai_thang_truoc - $so_tien_lai_da_thu_hoi_thang_truoc - $so_tien_lai_da_thu_hoi_tien_thua : 0;
			$du_no_phi_thang_truoc = !empty($item->tien_phi_thang_truoc) ? $item->tien_phi_thang_truoc - $so_tien_phi_da_thu_hoi_thang_truoc : 0;


			$disbursement_date = !empty($item->disbursement_date) ? $item->disbursement_date : 0;
			if (date('Y-m', $disbursement_date) == date('Y-m', $item->plan_contract[0]->time_timestamp)) {
				$du_no_goc_thang_truoc = 0;
				$du_no_lai_thang_truoc = 0;
				$du_no_phi_thang_truoc = 0;
			}

			$endMonth = strtotime(date('Y-m-t', strtotime($start)) . ' 23:59:59');
			$startMonth = strtotime(date('Y-m-01', strtotime($start)) . ' 00:00:00');
			$condition_stt = [
				'code_contract' => $item->code_contract,
				'status' => 1,
				'type' => 3,
				'ky_tt_xa_nhat' => $item->debt->ky_tt_xa_nhat,
				'endMonth' => $endMonth,
				'status_contract_origin' => $item->status,
				'date_pay' => array(
					'$lte' => $endMonth)
			];
			$condition_last = [
				'code_contract' => $item->code_contract,
				'status' => 1,
				'type' => 3,
				'ky_tt_xa_nhat' => $item->debt->ky_tt_xa_nhat,
				'status_contract_origin' => $item->status,
				'endMonth' => $startMonth,
			];

			$tranDB = $this->contract_model->get_tran_one_tt($condition_last);
			if (!empty($tranDB)) {
				if ($tranDB['date_pay'] < $item->debt->ky_tt_xa_nhat) {
					$du_no_lai_thang_truoc = $tranDB['so_tien_lai_phai_tra_tat_toan'] - $tranDB['so_tien_lai_da_tra'];
					$du_no_phi_thang_truoc = $tranDB['so_tien_phi_phai_tra_tat_toan'] - $tranDB['so_tien_phi_da_tra'];
				}
			}
			$disbursement_date = !empty($item->disbursement_date) ? $item->disbursement_date : 0;

			if($du_no_goc_thang_truoc == 0 && date('Y-m',$disbursement_date)==date('Y-m',$item->plan_contract[0]->time_timestamp)) {
				$AG = $amount - $so_tien_goc_da_thu_hoi;
			} else {
				$AG = $du_no_goc_thang_truoc - $so_tien_goc_da_thu_hoi;
			}
			if ($du_no_goc_thang_truoc == 0 && date('Y-m', $disbursement_date) == date('Y-m', $item->plan_contract[0]->time_timestamp)) {
				$AG = $amount - $so_tien_goc_da_thu_hoi;
			} else {
				$AG = $du_no_goc_thang_truoc - $so_tien_goc_da_thu_hoi;
			}
			$AH = $du_no_lai_thang_truoc + $this->getLaiVayPhaiTraNDT_T4($item) - $so_tien_lai_da_thu_hoi;
			$AI = $du_no_phi_thang_truoc + $this->getTongPhi_AA4_BangLaiThuc($item) - $so_tien_phi_da_thu_hoi;
			$condition=[
				'code_contract'=>$item->code_contract,
				'status'=>1,
				'type'=>3,
				'ky_tt_xa_nhat' => $item->debt->ky_tt_xa_nhat,
				'endMonth' => $endMonth,
			];
			$tranDB = $this->contract_model->get_tran_one_tt($condition);

			$status = $this->contract_model->getStatusContract($condition_stt);
			$status_last = $this->contract_model->getStatusContract($condition_last);

			if(!empty($tranDB))
			{
				$du_no_goc_con = $tranDB['so_tien_goc_phai_tra_tat_toan']-$tranDB['so_tien_goc_da_tra'];
				$du_no_lai_con = $tranDB['so_tien_lai_phai_tra_tat_toan']-$tranDB['so_tien_lai_da_tra'];
				$du_no_phi_con = $tranDB['so_tien_phi_phai_tra_tat_toan']-$tranDB['so_tien_phi_da_tra']+$tranDB['tien_thua_thanh_toan'];

				$AG = $du_no_goc_con;
				$AH = $du_no_lai_con;
				$AI = $du_no_phi_con;

			}


			if ($status == "Gia hạn" && $status_last != "Gia hạn") {
				$so_tien_goc_da_thu_hoi = $amount;
				$AG=0;
				$so_tien_phi_da_thu_hoi = $so_tien_phi_da_thu_hoi - $so_tien_thua_thanh_toan_1thang_da_tra - $so_tien_thua_tat_toan_1thang_da_tra;
				$AI = $du_no_phi_thang_truoc + $this->getTongPhi_AA4_BangLaiThuc($item) - $so_tien_phi_da_thu_hoi;

			}
			if ($status == "Gia hạn" && $status_last == "Gia hạn") {
				$so_tien_goc_da_thu_hoi = 0;
				$AG=0;
				$so_tien_phi_da_thu_hoi = 0;
				$AI = $AI+$so_tien_thua_thanh_toan_da_thu_hoi;
				$so_tien_lai_NDT_tt = $so_tien_lai_da_thu_hoi - $tien_lai_1thang_da_tra_tien_thua;
				$AH = $du_no_lai_thang_truoc + $this->getLaiVayPhaiTraNDT_T4($item) - $so_tien_lai_NDT_tt;
				$status="Gia hạn";
			}

			//Tổng thu hồi lũy kế tháng trước
//            $tong_thu_hoi_luy_ke_thang_truoc = $this->tongThuHoiLuyKeThangTruoc_AP($item);
			$tong_thu_hoi_luy_ke_thang_truoc = !empty($item->tong_thu_hoi_luy_ke_thang_truoc) ? $item->tong_thu_hoi_luy_ke_thang_truoc : 0;
			//Tổng thu hồi lũy kế tháng Tn
//            $tong_thu_hoi_luy_ke_thang_Tn = $this->tongThuHoiLuyKeThangTn_AQ($item);
			$tong_thu_hoi_luy_ke_thang_hien_tai = !empty($item->tong_thu_hoi_luy_ke_thang_hien_tai) ? $item->tong_thu_hoi_luy_ke_thang_hien_tai : 0;
			$tong_thu_hoi_luy_ke_thang_Tn = $tong_thu_hoi_luy_ke_thang_hien_tai + $tong_thu_hoi_luy_ke_thang_truoc;

//			if ($item->status == 33 || $item->status == 34) {
//				//Số tiền gốc còn lại
//				$so_tien_goc_con_lai = 0;
//
//
//			} else {
//				//Số tiền gốc còn lại
//				$so_tien_goc_con_lai = $this->getSoTienGocConLai($item);
//			}

			//Số tiền lãi còn lại
			$so_tien_lai_con_lai = $this->getSoTienLaiConLai($item);
			//Số tiền phí còn lại


			$feePayDelay = !empty($item->bang_lai_ky[0]->fee_delay_pay) ? $item->bang_lai_ky[0]->fee_delay_pay : 0;
			//Phí trả trước = phí tất toán trước hạn
			$feeFinishContract = !empty($item->bang_lai_ky[0]->fee_finish_contract) ? $item->bang_lai_ky[0]->fee_finish_contract : 0;
			//Phí gia hạn khoản vay
			$feeExtend = !empty($item->bang_lai_ky[0]->fee_extend) ? $item->bang_lai_ky[0]->fee_extend : 0;
			//Tổng phí

			if ($item->type == 3) {
				$so_tien_phi_con_lai = $this->getSoTienPhiConLai($item) - $feePayDelay - $feeFinishContract - $feeExtend;
			} else {
				$so_tien_phi_con_lai = $this->getSoTienPhiConLai($item);
			}




			$so_tien_phi_gia_han_da_tra = !empty($item->so_tien_phi_gia_han_da_tra) ? $item->so_tien_phi_gia_han_da_tra : 0;

			//Tiền thừa tất toán
			$tien_thua_tat_toan = $this->getTienThuaTatToan($item->bang_lai_ky[0]);

			//Số tiền phí chậm trả
			$so_tien_phi_cham_tra_da_thu_hoi_thang_hien_tai = !empty($item->so_tien_phi_cham_tra_da_thu_hoi_thang_hien_tai) ? $item->so_tien_phi_cham_tra_da_thu_hoi_thang_hien_tai : 0;
			//Số tiền phí trước hạn
			$so_tien_phi_truoc_han_da_thu_hoi_thang_hien_tai = !empty($item->so_tien_phi_truoc_han_da_thu_hoi_thang_hien_tai) ? $item->so_tien_phi_truoc_han_da_thu_hoi_thang_hien_tai : 0;

//			$tong_thu_hoi_thang_T = $so_tien_phi_gia_han_da_tra + $so_tien_goc_da_thu_hoi + $so_tien_lai_da_thu_hoi + $so_tien_phi_da_thu_hoi + $so_tien_phi_cham_tra_da_thu_hoi_thang_hien_tai + $so_tien_phi_truoc_han_da_thu_hoi_thang_hien_tai;
//			$tong_thu_hoi_thang_T = !empty($item->tong_thu_hoi_thang_T) ? $item->tong_thu_hoi_thang_T : 0;

			if (!empty($item->code_contract_parent_gh)) {
				$tong_thu_hoi_luy_ke_thang_hien_tai = !empty($item->tong_thu_hoi_gia_han) ? $item->tong_thu_hoi_gia_han : 0;
			}

			$tong_thu_hoi_luy_ke_thang_hien_tai = $so_tien_phi_phat_sinh + $so_tien_phi_gia_han_da_tra + $so_tien_goc_da_thu_hoi + $so_tien_lai_da_thu_hoi + $so_tien_phi_da_thu_hoi + $so_tien_phi_cham_tra_da_thu_hoi_thang_hien_tai + $so_tien_phi_truoc_han_da_thu_hoi_thang_hien_tai;
			$this->sheet->setCellValue('AN' . $i, round($so_tien_goc_da_thu_hoi))
				->getStyle('AN' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AO' . $i, round($so_tien_lai_da_thu_hoi))
				->getStyle('AO' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AP' . $i, round($so_tien_phi_da_thu_hoi))
				->getStyle('AP' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$this->sheet->setCellValue('AQ' . $i, round($so_tien_phi_cham_tra_da_thu_hoi_thang_hien_tai))
				->getStyle('AQ' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AR' . $i, round($so_tien_phi_truoc_han_da_thu_hoi_thang_hien_tai))
				->getStyle('AR' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$this->sheet->setCellValue('AS' . $i, round($so_tien_phi_gia_han_da_tra))
				->getStyle('AS' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$this->sheet->setCellValue('AT' . $i, $so_tien_phi_phat_sinh)
				->getStyle('AT' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$this->sheet->setCellValue('AU' . $i, round($tong_thu_hoi_luy_ke_thang_hien_tai))
				->getStyle('AU' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);


			$this->sheet->setCellValue('AV' . $i, round($tong_thu_hoi_luy_ke_thang_truoc + $tien_thua_tat_toan))
				->getStyle('AV' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AW' . $i, round($tong_thu_hoi_luy_ke_thang_Tn + $tien_thua_tat_toan))
				->getStyle('AW' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);

			$this->sheet->setCellValue('AX' . $i, round($AG))
				->getStyle('AX' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AY' . $i, round($AH))
				->getStyle('AY' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);
			$this->sheet->setCellValue('AZ' . $i, round($AI))
				->getStyle('AZ' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);


			$this->sheet->setCellValue('BA' . $i, $status)
				->getStyle('BA' . $i)
				->getNumberFormat()
				->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_VND);


			$this->tong['so_tien_goc_da_thu_hoi'] = $this->tong['so_tien_goc_da_thu_hoi'] + $so_tien_goc_da_thu_hoi;
			$this->tong['so_tien_lai_da_thu_hoi'] = $this->tong['so_tien_lai_da_thu_hoi'] + $so_tien_lai_da_thu_hoi;
			$this->tong['so_tien_phi_da_thu_hoi'] = $this->tong['so_tien_phi_da_thu_hoi'] + $so_tien_phi_da_thu_hoi;

			$this->tong['so_tien_phi_cham_tra_da_thu_hoi_thang_hien_tai'] = $this->tong['so_tien_phi_cham_tra_da_thu_hoi_thang_hien_tai'] + $so_tien_phi_cham_tra_da_thu_hoi_thang_hien_tai;
			$this->tong['so_tien_phi_truoc_han_da_thu_hoi_thang_hien_tai'] = $this->tong['so_tien_phi_truoc_han_da_thu_hoi_thang_hien_tai'] + $so_tien_phi_truoc_han_da_thu_hoi_thang_hien_tai;
			$this->tong['tong_thu_hoi_thang_T'] = $this->tong['tong_thu_hoi_thang_T'] + $tong_thu_hoi_luy_ke_thang_hien_tai;

			$this->tong['tong_thu_hoi_luy_ke_thang_truoc'] = $this->tong['tong_thu_hoi_luy_ke_thang_truoc'] + $tong_thu_hoi_luy_ke_thang_truoc + $tien_thua_tat_toan;
			$this->tong['tong_thu_hoi_luy_ke_thang_Tn'] = $this->tong['tong_thu_hoi_luy_ke_thang_Tn'] + $tong_thu_hoi_luy_ke_thang_Tn + $tien_thua_tat_toan;
			$this->tong['so_tien_goc_con_lai'] = $this->tong['so_tien_goc_con_lai'] + $AG;
			$this->tong['so_tien_lai_con_lai'] = $this->tong['so_tien_lai_con_lai'] + $AH;
			$this->tong['so_tien_phi_con_lai'] = $this->tong['so_tien_phi_con_lai'] + $AI;

			$this->tong['so_tien_phi_gia_han_da_tra'] = $this->tong['so_tien_phi_gia_han_da_tra'] + $so_tien_phi_gia_han_da_tra;
			$this->tong['so_tien_phi_phat_sinh'] = $this->tong['so_tien_phi_phat_sinh'] + $so_tien_phi_phat_sinh;

			$i++;
		}
	}

	private function getSoTienGocConLai($item)
	{
		//=IF(AJ4>0,AJ4-AM4,N4-AM4)
		$AJ4 = $this->getAJ4($item);
		$AM4 = $this->getAM4($item);
		$N4 = $this->getN4($item);
		if ($AJ4 > 0) {
			$so_tien_goc_con_lai = $AJ4 - $AM4;
		} else {
			$so_tien_goc_con_lai = $N4 - $AM4;
		}
		return $so_tien_goc_con_lai;
	}


	private function getSoTienLaiConLai($item)
	{
		//=AK4+Q4-AN4
		$AK4 = $this->getAK($item);
		$Q4 = $this->getQ($item->bang_lai_ky[0]);
		$AN4 = $this->getAN($item);
		return $AK4 + $Q4 - $AN4;
	}

	private function getSoTienPhiConLai($item)
	{
		//=AL4+W4-AO4
		$AL4 = $this->getAL($item);
		$W4 = $this->getW($item);
		$AO4 = $this->getAO($item);
		return $AL4 + $W4 - $AO4;
	}

	private function gocVayPhaiThu_P4($i)
	{
		$gocVayPhaiThu = 0;
		// if(!empty($i->ki_khach_hang_tat_toan) && $i->ki_khach_hang_tat_toan == 1) {
		//     $gocVayPhaiThu = $i->so_tien_goc_da_tra_tat_toan;
		// } else {
		$gocVayPhaiThu = $i->tien_goc_1ky;
		// }
		return $gocVayPhaiThu;
	}

	private function getQ($i)
	{
		$laiVayPhaiTraNDT = 0;
		// if(!empty($i->ki_khach_hang_tat_toan) && $i->ki_khach_hang_tat_toan == 1) {
		//     $laiVayPhaiTraNDT = $i->so_tien_lai_da_tra_tat_toan;
		// } else {
		$laiVayPhaiTraNDT = $i->lai_ky;
		// }
		return $laiVayPhaiTraNDT;
	}

	private function tongThuHoiLuyKeThangTruoc_AP($item)
	{
		$so_tien_goc_da_thu_hoi_luy_ke_thang_truoc = !empty($item->so_tien_goc_da_thu_hoi_luy_ke_thang_truoc) ? $item->so_tien_goc_da_thu_hoi_luy_ke_thang_truoc : 0;
		$so_tien_lai_da_thu_hoi_luy_ke_thang_truoc = !empty($item->so_tien_lai_da_thu_hoi_luy_ke_thang_truoc) ? $item->so_tien_lai_da_thu_hoi_luy_ke_thang_truoc : 0;
		$so_tien_phi_da_thu_hoi_luy_ke_thang_truoc = !empty($item->so_tien_phi_da_thu_hoi_luy_ke_thang_truoc) ? $item->so_tien_phi_da_thu_hoi_luy_ke_thang_truoc : 0;

		$phi_phat_da_thu_hoi = $this->getPhiPhatDaThuHoi($item);

		return $so_tien_goc_da_thu_hoi_luy_ke_thang_truoc +
			$so_tien_lai_da_thu_hoi_luy_ke_thang_truoc +
			$so_tien_phi_da_thu_hoi_luy_ke_thang_truoc +
			$phi_phat_da_thu_hoi;
	}

	private function tongThuHoiLuyKeThangTn_AQ($item)
	{
		$so_tien_goc_da_thu_hoi_luy_ke_thang_truoc = !empty($item->so_tien_goc_da_thu_hoi_luy_ke_thang_truoc) ? $item->so_tien_goc_da_thu_hoi_luy_ke_thang_truoc : 0;
		$so_tien_lai_da_thu_hoi_luy_ke_thang_truoc = !empty($item->so_tien_lai_da_thu_hoi_luy_ke_thang_truoc) ? $item->so_tien_lai_da_thu_hoi_luy_ke_thang_truoc : 0;
		$so_tien_phi_da_thu_hoi_luy_ke_thang_truoc = !empty($item->so_tien_phi_da_thu_hoi_luy_ke_thang_truoc) ? $item->so_tien_phi_da_thu_hoi_luy_ke_thang_truoc : 0;

		$so_tien_goc_da_thu_hoi_thang_hien_tai = !empty($item->so_tien_goc_da_thu_hoi_thang_hien_tai) ? $item->so_tien_goc_da_thu_hoi_thang_hien_tai : 0;
		$so_tien_lai_da_thu_hoi_thang_hien_tai = !empty($item->so_tien_lai_da_thu_hoi_thang_hien_tai) ? $item->so_tien_lai_da_thu_hoi_thang_hien_tai : 0;
		$so_tien_phi_da_thu_hoi_thang_hien_tai = !empty($item->so_tien_phi_da_thu_hoi_thang_hien_tai) ? $item->so_tien_phi_da_thu_hoi_thang_hien_tai : 0;

		$b = !empty($item->so_tien_phi_tra_cham_da_thu_hoi_luy_ke) ? $item->so_tien_phi_tra_cham_da_thu_hoi_luy_ke : 0;
		$c = !empty($item->so_tien_phi_tat_toan_da_thu_hoi_luy_ke) ? $item->so_tien_phi_tat_toan_da_thu_hoi_luy_ke : 0;
		$d = !empty($item->so_tien_phi_gia_han_da_thu_hoi_luy_ke) ? $item->so_tien_phi_gia_han_da_thu_hoi_luy_ke : 0;


		return $so_tien_goc_da_thu_hoi_luy_ke_thang_truoc +
			$so_tien_lai_da_thu_hoi_luy_ke_thang_truoc +
			$so_tien_phi_da_thu_hoi_luy_ke_thang_truoc +
			$so_tien_goc_da_thu_hoi_thang_hien_tai +
			$so_tien_lai_da_thu_hoi_thang_hien_tai +
			$so_tien_phi_da_thu_hoi_thang_hien_tai +
			$b +
			$c +
			$d;
	}

	private function getPhiTuVan($item)
	{
		$phituvan = 0;
		// if(!empty($item->ki_khach_hang_tat_toan) && $item->ki_khach_hang_tat_toan == 1) {
		//     $phituvan = $item->so_tien_phi_da_tra_tat_toan / 2;
		// } else {
		$phituvan = $item->phi_tu_van;
		//}
		return $phituvan;
	}

	private function getPhiThamDinh($item)
	{
		$phithamdinh = 0;
		// if(!empty($item->ki_khach_hang_tat_toan) && $item->ki_khach_hang_tat_toan == 1) {
		//     $phithamdinh = $item->so_tien_phi_da_tra_tat_toan / 2;
		// } else {
		$phithamdinh = $item->phi_tham_dinh;
		//}
		return $phithamdinh;
	}

	private function getAO($item)
	{
		$a = !empty($item->so_tien_phi_da_thu_hoi_thang_hien_tai) ? $item->so_tien_phi_da_thu_hoi_thang_hien_tai : 0;


		return $a;

	}

	private function getAJ4($item)
	{
		$so_tien_goc_da_thu_hoi_thang_truoc = !empty($item->so_tien_goc_da_thu_hoi_luy_ke_thang_truoc) ? $item->so_tien_goc_da_thu_hoi_luy_ke_thang_truoc : 0;
		$du_no_goc_thang_truoc = !empty($item->loan_infor->amount_money) ? $item->loan_infor->amount_money - $so_tien_goc_da_thu_hoi_thang_truoc : 0;
		$disbursement_date = !empty($item->disbursement_date) ? $item->disbursement_date : 0;
		if ($item->so_tien_goc_luy_ke_thang_truoc == 0) {
			$du_no_goc_thang_truoc = 0;

		}
		return $du_no_goc_thang_truoc;
	}

	private function getAM4($item)
	{
		return !empty($item->so_tien_goc_da_thu_hoi_thang_hien_tai) ? $item->so_tien_goc_da_thu_hoi_thang_hien_tai : 0;
	}

	private function getN4($item)
	{
		//Số tiền giải ngân
		$amount = 0;
		if (empty($item->count_extend)) {
			$amount = !empty($item->loan_infor->amount_money) ? $item->loan_infor->amount_money : 0;
		}
		return $amount;
	}

	private function getAK($item)
	{

		$so_tien_lai_da_thu_hoi_thang_truoc = !empty($item->so_tien_lai_da_thu_hoi_luy_ke_thang_truoc) ? $item->so_tien_lai_da_thu_hoi_luy_ke_thang_truoc : 0;
		$du_no_lai_thang_truoc = !empty($item->so_tien_lai_luy_ke_thang_truoc) ? $item->so_tien_lai_luy_ke_thang_truoc - $so_tien_lai_da_thu_hoi_thang_truoc : 0;

		$disbursement_date = !empty($item->disbursement_date) ? $item->disbursement_date : 0;
		if ($disbursement_date == $item->time_timestamp) {

			$du_no_lai_thang_truoc = 0;

		}
		return $du_no_lai_thang_truoc;
	}

	private function getAN($item)
	{
		return !empty($item->so_tien_lai_da_thu_hoi_thang_hien_tai) ? $item->so_tien_lai_da_thu_hoi_thang_hien_tai : 0;
	}

	private function getAL($item)
	{

		$so_tien_phi_da_thu_hoi_thang_truoc = !empty($item->so_tien_phi_da_thu_hoi_luy_ke_thang_truoc) ? $item->so_tien_phi_da_thu_hoi_luy_ke_thang_truoc : 0;

		$du_no_phi_thang_truoc = !empty($item->so_tien_phi_luy_ke_thang_truoc) ? $item->so_tien_phi_luy_ke_thang_truoc - $so_tien_phi_da_thu_hoi_thang_truoc : 0;
		$disbursement_date = !empty($item->disbursement_date) ? $item->disbursement_date : 0;
		if ($disbursement_date == $item->time_timestamp) {

			$du_no_phi_thang_truoc = 0;
		}
		return $du_no_phi_thang_truoc;
	}

	private function getTienThuaTatToan($item)
	{
		return !empty($item->tien_thua_tat_toan) ? $item->tien_thua_tat_toan : 0;
	}

	private function getPhiPhatDaThuHoi($item)
	{
		$fee_delay = !empty($item->bang_lai_ky[0]->fee_delay_pay) ? $item->bang_lai_ky[0]->fee_delay_pay : 0;
		$fee_finish_contract = !empty($item->bang_lai_ky[0]->fee_finish_contract) ? $item->bang_lai_ky[0]->fee_finish_contract : 0;
		$fee_extend = !empty($item->bang_lai_ky[0]->fee_extend) ? $item->bang_lai_ky[0]->fee_extend : 0;
		return $fee_delay + $fee_finish_contract + $fee_extend;
	}
	private function getLaiVayPhaiTraNDT_T4($item) {
		$laiVayPhaiTraNDT = 0;


		$laiVayPhaiTraNDT = $item->plan_contract[0]->tien_lai_1thang ;


		return $laiVayPhaiTraNDT;
	}
	private function getTongPhi_AA4_BangLaiThuc($item) {
		$so_ngay_trong_thang=!empty($item->plan_contract[0]->so_ngay_trong_thang_dau) ? $item->plan_contract[0]->so_ngay_trong_thang_dau : $item->plan_contract[0]->so_ngay_trong_thang;
		if($so_ngay_trong_thang>0)
		{
		//Phí tư vấn
		$feeAdvisory = ($item->loan_infor->amount_money * $item->fee->percent_advisory / 100) * $item->plan_contract[0]->count_date_interest / $so_ngay_trong_thang;
		//Phí thẩm định
		$feeExpertise = ($item->loan_infor->amount_money * $item->fee->percent_expertise / 100) * $item->plan_contract[0]->count_date_interest / $so_ngay_trong_thang;

		$totalFee = $feeAdvisory + $feeExpertise ;
	    }else{
	    	$totalFee=0;
	    }
		
		return $totalFee;
	}
}

?>

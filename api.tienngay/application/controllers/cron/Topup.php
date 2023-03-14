<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Topup extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("transaction_model");
		$this->load->model('fee_loan_model');
		$this->load->model('contract_model');
		$this->load->model('gic_model');
		$this->load->model('mic_model');
		$this->load->model('gic_easy_model');
		$this->load->model('gic_plt_model');
		$this->load->model('log_contract_model');
		$this->load->model('log_model');
		$this->load->model('log_gic_model');
		$this->load->model('log_mic_model');
		$this->load->model('user_model');
		$this->load->model('role_model');
		$this->load->model('config_gic_model');
		$this->load->model('city_gic_model');
		$this->load->model('contract_tempo_model');
		$this->load->model('investor_model');
		$this->load->model("group_role_model");
		$this->load->model("notification_model");
		$this->load->model("notification_app_model");
		$this->load->model("store_model");
		$this->load->model("lead_model");
		$this->load->model("sms_model");
		$this->load->model("temporary_plan_contract_model");
		$this->load->model('log_contract_tempo_model');
		$this->load->model('tempo_contract_accounting_model');
		$this->load->model('device_model');
		$this->load->helper('lead_helper');
		$this->load->model('vbi_model');
		$this->load->model('log_hs_model');
		$this->load->model('log_call_debt_model');
		$this->load->model('asset_management_model');
		$this->load->model('contract_tempo_model');
		$this->load->model('contract_debt_model');
		$this->load->model('list_topup_model');
		$this->load->model('main_property_model');
	}

	public function update()
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$topups = $this->list_topup_model->find();
		foreach ($topups as $topup) {
			try {
				$contract = $this->contract_model->findOne(['code_contract' => $topup['code_contract']]);
				$contract_property = $this->contract_model->find_where(['loan_infor.name_property.id' => $contract['loan_infor']['name_property']['id'], 'status' => 17, 'customer_infor.customer_phone_number' => $contract['customer_infor']['customer_phone_number']]);
				$du_no_goc_con_lai = 0;
				$so_tien_vay = 0;
				foreach ($contract_property as $value) {
					$so_tien_vay += $value['loan_infor']['amount_money'];
					$tempo = $this->temporary_plan_contract_model->find_where(['code_contract' => $value['code_contract']]);
					foreach ($tempo as $t) {
						if ($t['status'] == 1) {
							$du_no_goc_con_lai += $t['tien_goc_1ky'];
						}
					}
				}

				$so_ky_thanh_toan = $this->temporary_plan_contract_model->count(['code_contract' => $topup['code_contract'], 'status' => 2]);
				$main_property = $this->main_property_model->findOne(['_id' => new MongoDB\BSON\ObjectId($contract['loan_infor']['name_property']['id'])]);
				if (!$main_property) {
					$main_property = $this->main_property_model->findOne(['str_name' => $contract['loan_infor']['name_property']['text']]);
				}
				if (!empty($main_property)) {
					$gia_tri_tai_san = (int)$main_property['price'] * (100 - (int)$main_property['giam_tru_tieu_chuan']) / 100;
				} else {
					$gia_tri_tai_san = (int)$contract['loan_infor']['price_property'];
				}
				$update = [];
				$update['so_tien_vay'] = $so_tien_vay;
				$update['hinh_thuc_vay'] = $contract['loan_infor']['type_interest'] == 1 ? "Dư nợ giảm dần" : 'Lãi hàng tháng, gốc cuối kỳ';
				$update['loai_san_pham_vay'] = $contract['loan_infor']['type_property']['text'] ?? '';
				$update['san_pham_vay'] = $contract['loan_infor']['loan_product']['text'] ?? "";
				$update['ky_han_vay'] = ($contract['loan_infor']['number_day_loan'] / 30) . ' Tháng';
				$update['tien_ky'] = round($tempo[0]['tien_tra_1_ky']);
				$update['ngay_tre'] = $contract['debt']['so_ngay_cham_tra'];
				$update['bucket'] = $this->get_bucket($contract['debt']['so_ngay_cham_tra']);
				$update['so_ky_thanh_toan'] = $so_ky_thanh_toan;
				$update['du_no_goc_con_lai'] = round($du_no_goc_con_lai);
				$update['pgd'] = $contract['store']['name'];
				$update['dia_chi_hien_tai'] = $contract['current_address']['current_stay'] . ' /' . $contract['current_address']['ward_name'] . ' /' . $contract['current_address']['district_name'] . ' /' . $contract['current_address']['province_name'];
				$update['kt1'] = $contract['current_address']['form_residence'];
				$update['ngay_giai_ngan'] = date('d-m-Y', $contract['disbursement_date']);
				$update['tai_san'] = $contract['loan_infor']['name_property']['text'];
				$update['gia_tri_tai_san'] = $gia_tri_tai_san;
				$update['chu_xe'] = $contract['property_infor'][5]['value'];
				$this->list_topup_model->update(['_id' => $topup['_id']], $update);
				echo 'success ' . $topup['code_contract'] . "\n";
			} catch (Exception $exception) {
				echo $exception->getMessage();
			}

		}
	}

	function get_bucket($time = 0)
	{
		if ($time < 0) {
			$bucket = 'B0';
		} else if ($time == 0) {
			$bucket = 'B0';
		} else if ($time >= 1 && $time <= 9) {
			$bucket = 'B1';
		} else if ($time >= 10 && $time <= 30) {
			$bucket = 'B1';
		} else if ($time >= 31 && $time <= 60) {
			$bucket = 'B2';
		} else if ($time >= 61 && $time <= 90) {
			$bucket = 'B3';
		} else if ($time >= 91 && $time <= 120) {
			$bucket = 'B4';
		} else if ($time >= 121 && $time <= 150) {
			$bucket = 'B5';
		} else if ($time >= 151 && $time <= 180) {
			$bucket = 'B6';
		} else if ($time >= 181 && $time <= 360) {
			$bucket = 'B7';
		} else {
			$bucket = 'B8';
		}
		return $bucket;
	}
}

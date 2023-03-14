<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

class Plan_actual extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url', 'file'));
		$this->load->helper('lead_helper');
		$this->load->model("main_property_model");
		$this->load->model('config_gic_model');
		$this->load->model("time_model");
		$this->load->library('pagination');
		$this->config->load('config');

		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
		date_default_timezone_set('Asia/Ho_Chi_Minh');

	}

	public function indexPlanActual()
	{
		$data = [];
		$month = !empty($_GET['month']) ? $_GET['month'] : date('Y-m');
		if (!empty($month)) {
			$data['month'] = $month;
		}

		$this->api->apiPost($this->userInfo['token'], "plan_actual/create_manually_enter", $data);

		$get_ratio = $this->api->apiPost($this->userInfo['token'], "plan_actual/get_ratio");
		if (!empty($get_ratio->status) && $get_ratio->status == 200) {
			$this->data['ratio'] = $get_ratio->data;
		} else {
			$this->data['ratio'] = array();
		}

		$tongSoDuCacTaiKhoan = $this->api->apiPost($this->userInfo['token'], "plan_actual/getTongSoDuCacTaiKhoan", $data);
		if (!empty($tongSoDuCacTaiKhoan->status) && $tongSoDuCacTaiKhoan->status == 200) {
			$this->data['getDayOfMonth'] = $tongSoDuCacTaiKhoan->getDayOfMonth;
			$this->data['totalBalance'] = $tongSoDuCacTaiKhoan->totalBalance;
			$this->data['manually_enter'] = $tongSoDuCacTaiKhoan->manually_enter;
		} else {
			$this->data['getDayOfMonth'] = array();
		}




		$this->data['template'] = 'page/plan_actual/indexPlanActual.php';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function update_ratio(){

		$data = [];
		$data['ndt_hop_tac'] = !empty($_POST['ndt_hop_tac']) ? $_POST['ndt_hop_tac'] : 0;
		$data['ndt_app_vi_nl'] = !empty($_POST['ndt_app_vi_nl']) ? $_POST['ndt_app_vi_nl'] : 0;
		$data['ndt_app_vi_vimo'] = !empty($_POST['ndt_app_vi_vimo']) ? $_POST['ndt_app_vi_vimo'] : 0;
		$data['ndt_app_vi_vay_muon'] = !empty($_POST['ndt_app_vi_vay_muon']) ? $_POST['ndt_app_vi_vay_muon'] : 0;
		$data['vndt'] = !empty($_POST['vndt']) ? $_POST['vndt'] : 0;
		$data['id'] = !empty($_POST['id']) ? $_POST['id'] : 0;
		$return = $this->api->apiPost($this->userInfo['token'], "plan_actual/update_ratio", $data);

		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		}

	}

	private function pushJson($code, $data)
	{
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}

	public function indexBankBalance()
	{

		$data = [];
		$day = !empty($_GET['day']) ? $_GET['day'] : date('Y-m-d');
		if (!empty($day)) {
			$data['day'] = $day;
		}

		$listBankBalance = $this->api->apiPost($this->userInfo['token'], "plan_actual/getBankBalance", $data);
		if (!empty($listBankBalance->status) && $listBankBalance->status == 200) {
			$this->data['data_tcv'] = $listBankBalance->data_tcv;
			$this->data['data_tcv_db'] = $listBankBalance->data_tcv_db;
			$this->data['data_tk_l2'] = $listBankBalance->data_tk_l2;
			$this->data['total_lk_tcv'] = $listBankBalance->total_lk_tcv;
			$this->data['total_lk_tcv_db'] = $listBankBalance->total_lk_tcv_db;
			$this->data['total_lk_l2'] = $listBankBalance->total_lk_l2;
			$this->data['total_lk_khac'] = $listBankBalance->total_lk_khac;
			$this->data['dataBankBalance_tk_khac'] = $listBankBalance->dataBankBalance_tk_khac;
			$this->data['total_lk_l1'] = $listBankBalance->total_lk_l1;
			$this->data['ducuoingay_tk_khac'] = $listBankBalance->ducuoingay_tk_khac;
			$this->data['ducuoingay_tcv'] = $listBankBalance->ducuoingay_tcv;
			$this->data['ducuoingay_tcv_db'] = $listBankBalance->ducuoingay_tcv_db;
			$this->data['ducuoingay_tk_l1'] = $listBankBalance->ducuoingay_tk_l1;
			$this->data['ducuoingay_tk_l2'] = $listBankBalance->ducuoingay_tk_l2;
			$this->data['dukinhdoanh_tcv'] = $listBankBalance->dukinhdoanh_tcv;
			$this->data['dukinhdoanh_tcv_db'] = $listBankBalance->dukinhdoanh_tcv_db;
			$this->data['dukinhdoanh_l1'] = $listBankBalance->dukinhdoanh_l1;
			$this->data['dukinhdoanh_khac'] = $listBankBalance->dukinhdoanh_khac;
			$this->data['dukinhdoanh_l2'] = $listBankBalance->dukinhdoanh_l2;
		} else {
			$this->data['listBankBalance'] = array();
		}

		$this->data['template'] = 'page/plan_actual/indexBankBalance.php';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function doAddBankBalance()
	{
		$day = !empty($_POST['day_export']) ? $_POST['day_export'] : "";
		if (empty($day)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => 'Bạn cần chọn ngày thêm số dư tài khoản ngân hàng'
			];
			echo json_encode($response);
			return;
		}
		$data = array(
			"day" => $day
		);

		$return = $this->api->apiPost($this->userInfo['token'], "plan_actual/create_bank_balance", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => "Tạo mới thành công"
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Bạn cần set dữ liệu ngày hôm trước"
			];
			echo json_encode($response);
			return;
		}

	}

	public function update_bank_balance()
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

		$this->api->apiPost($this->user['token'], "plan_actual/update_bank_balance", $condition);

	}

	public function indexFollowVPS(){

		$countResult = $this->api->apiPost($this->userInfo['token'], "plan_actual/getCountFollowVPS");
		if(!empty($countResult)){
			$count = (int)$countResult->data;
			$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
			$config = $this->config->item('pagination');
			$config['base_url'] = base_url('plan_actual/indexFollowVPS');
			$config['total_rows'] = $count;
			$config['per_page'] = 30;
			$config['page_query_string'] = true;
			$config['uri_segment'] = $uriSegment;
			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();
			$this->data['count'] = $count;

			$data["per_page"] = $config['per_page'];
			$data["uriSegment"] = $config['uri_segment'];

			$getFollowVps = $this->api->apiPost($this->user['token'], "plan_actual/getFollowVPS",$data);

			if (!empty($getFollowVps->status) && $getFollowVps->status == 200) {
				$this->data['getFollowVps'] = $getFollowVps->data;
			} else {
				$this->data['getFollowVps'] = array();
			}

			$getTotal = $this->api->apiPost($this->user['token'], "plan_actual/total_price_vps");

			if (!empty($getTotal->status) && $getTotal->status == 200) {
				$this->data['total_tien_gui_goc'] = $getTotal->total_tien_gui_goc;
				$this->data['total_lai_dao_han_du_kien'] = $getTotal->total_lai_dao_han_du_kien;
				$this->data['total_lai_thuc_te'] = $getTotal->total_lai_thuc_te;
				$this->data['total_tong_tien_dao_han'] = $getTotal->total_tong_tien_dao_han;
			} else {
				$this->data['getFollowVps'] = array();
			}
		}

		$this->data['template'] = 'page/plan_actual/indexFollowVps.php';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function importFollowVPS(){

		if (empty($_FILES['upload_file']['name'])) {
			$this->session->set_flashdata('error', $this->lang->line('not_selected_file_import'));
			redirect('plan_actual/indexFollowVPS');
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

				$this->api->apiPost($this->user['token'], "plan_actual/clearImportFollowVPS");

				foreach ($sheetData as $key => $value) {
					if ($key >= 1) {
						$data = [
							'doi_tuong_gui' => !empty($value[0]) ? trim($value[0]) : "",
							'so_hd' => !empty($value[1]) ? trim($value[1]) : "",
							'so_tien_gui_goc' => !empty($value[2]) ? trim($value[2]) : "",
							'lai_suat' => !empty($value[3]) ? trim($value[3]) : "",
							'ky_han_ban_dau' => !empty($value[4]) ? trim($value[4]) : "",
							'ky_han_gia_han' => !empty($value[5]) ? trim($value[5]) : "",
							'ngay_gui' => !empty($value[6]) ? trim($value[6]) : "",
							'ngay_dao_han_du_kien' => !empty($value[7]) ? trim($value[7]) : "",
							'lai_dao_han_du_kien' => !empty($value[8]) ? trim($value[8]) : "",
							'ngay_dao_han_thuc_te' => !empty($value[9]) ? trim($value[9]) : "",
							'trang_thai' => !empty($value[10]) ? trim($value[10]) : "",
							'lai_thuc_te' => !empty($value[11]) ? trim($value[11]) : "",
							'tong_tien_dao_han' => !empty($value[12]) ? trim($value[12]) : "",
							'ghichu' => !empty($value[13]) ? trim($value[13]) : "",
							'created_at' => $this->createdAt,
						];

						 $this->api->apiPost($this->user['token'], "plan_actual/importFollowVPS", $data);
					}
				}
				try {
					$this->session->set_flashdata('success', $this->lang->line('import_success'));
					redirect('plan_actual/indexFollowVPS');
				} catch (Exception $ex) {
					$this->session->set_flashdata('error', $this->lang->line('import_failed'));
					redirect('plan_actual/indexFollowVPS');
				}
			} else {
				$this->session->set_flashdata('error', $this->lang->line('type_invalid'));
				redirect('plan_actual/indexFollowVPS');
			}
		}
	}

	public function update_manually_enter(){

		$data = $this->input->post();
		$data['field'] = $this->security->xss_clean($data['field']);
		$data['value'] = $this->security->xss_clean($data['value']);
		$data['id'] = $this->security->xss_clean($data['id']);

		$condition = array(
			'id' => $data['id'],
			$data['field'] => $data['value'],
			"updated_by" => $this->user['email']
		);

		$this->api->apiPost($this->user['token'], "plan_actual/update_manually_enter", $condition);

	}

	public function update_investor(){
		$data = $this->input->post();
		$data['field'] = $this->security->xss_clean($data['field']);
		$data['value'] = $this->security->xss_clean($data['value']);
		$data['id'] = $this->security->xss_clean($data['id']);

		$condition = array(
			'id' => $data['id'],
			$data['field'] => $data['value'],
			"updated_by" => $this->user['email']
		);

		$this->api->apiPost($this->user['token'], "plan_actual/update_investor", $condition);
	}

	public function indexFollowDebt(){

		$data = [];
		$month = !empty($_GET['month']) ? $_GET['month'] : date('Y-m');
		if (!empty($month)) {
			$data['month'] = $month;
		}

		$result = $this->api->apiPost($this->userInfo['token'], "plan_actual/indexFollowDebt", $data);
		if (!empty($result->status) && $result->status == 200) {
			$this->data['data'] = $result->data;
			$this->data['total_lai'] = $result->total_lai;
			$this->data['total_phi_tu_van'] = $result->total_phi_tu_van;
			$this->data['total_phi_tham_dinh'] = $result->total_phi_tham_dinh;
			$this->data['total_goc'] = $result->total_goc;
			$this->data['sum_total_plan'] = $result->sum_total_plan;
			$this->data['sum_actual'] = $result->sum_actual;
			$this->data['sum_diff'] = $result->sum_diff;


		} else {
			$this->data['data'] = array();
		}

		$this->data['template'] = 'page/plan_actual/indexFollowDebt.php';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function indexHistorical(){

		$data = [];
		$month = !empty($_GET['month']) ? $_GET['month'] : date('Y-m');
		if (!empty($month)) {
			$data['month'] = $month;
		}

		$result = $this->api->apiPost($this->userInfo['token'], "plan_actual/getHistorical", $data);
		if (!empty($result->status) && $result->status == 200) {
			$this->data['data'] = $result->data;
		} else {
			$this->data['data'] = array();
		}

		$this->data['template'] = 'page/plan_actual/indexHistorical.php';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function indexDisbursement(){

		$data = [];
		$month = !empty($_GET['month']) ? $_GET['month'] : date('Y-m');
		if (!empty($month)) {
			$data['month'] = $month;
		}

		$result = $this->api->apiPost($this->userInfo['token'], "plan_actual/indexDisbursement", $data);
		if (!empty($result->status) && $result->status == 200) {
			$this->data['data'] = $result->data;
			$this->data['total_kh_pgd'] = $result->total_kh_pgd;
			$this->data['total_priority'] = $result->total_priority;

		} else {
			$this->data['data'] = array();
		}


		$this->data['template'] = 'page/plan_actual/indexDisbursement.php';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function importHistorical(){

		if (empty($_FILES['upload_file']['name'])) {
			$this->session->set_flashdata('error', $this->lang->line('not_selected_file_import'));
			redirect('plan_actual/indexHistorical');
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

				$data = [];
				$data['year'] = date('Y', strtotime($sheetData[1][4]));
				$data['month'] = date('m', strtotime($sheetData[1][4]));

				$this->api->apiPost($this->user['token'], "plan_actual/clearImportHistorical", $data);

				for ($i = 0; $i< count($sheetData); $i++){
					if ($i >= 1) {
						$data = [
							'code' => !empty($sheetData[$i][0]) ? trim($sheetData[$i][0]) : "",
							'gia_dinh_thanh_toan' => !empty($sheetData[$i][1]) ? trim($sheetData[$i][1]) : "",
							'actual' => !empty($sheetData[$i][2]) ? trim($sheetData[$i][2]) : "",
							'dot' => !empty($sheetData[$i][3]) ? trim($sheetData[$i][3]) : "",
							'year' => date('Y', strtotime($sheetData[1][4])),
							'month' => date('m', strtotime($sheetData[1][4])),
							'created_at' => $this->createdAt,
						];

						$this->api->apiPost($this->user['token'], "plan_actual/importHistorical", $data);
					}

				}

				try {
					$this->session->set_flashdata('success', $this->lang->line('import_success'));
					redirect('plan_actual/indexHistorical');
				} catch (Exception $ex) {
					$this->session->set_flashdata('error', $this->lang->line('import_failed'));
					redirect('plan_actual/indexHistorical');
				}
			} else {
				$this->session->set_flashdata('error', $this->lang->line('type_invalid'));
				redirect('plan_actual/indexHistorical');
			}
		}
	}

	public function indexCpWork(){

		$data = [];
		$month = !empty($_GET['month']) ? $_GET['month'] : date('Y-m');
		if (!empty($month)) {
			$data['month'] = $month;
		}

		$result = $this->api->apiPost($this->userInfo['token'], "plan_actual/indexCpWork", $data);
		if (!empty($result->status) && $result->status == 200) {
			$this->data['data_1'] = $result->data_1;
			$this->data['data_2'] = $result->data_2;
			$this->data['data_3'] = $result->data_3;
			$this->data['data_4'] = $result->data_4;
			$this->data['data_5'] = $result->data_5;

		} else {
			$this->data['data_1'] = array();
			$this->data['data_2'] = array();
			$this->data['data_3'] = array();
			$this->data['data_4'] = array();
			$this->data['data_5'] = array();
		}

		$this->data['template'] = 'page/plan_actual/indexCpWork.php';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function indexInvestor(){

		$data = [];
		$month = !empty($_GET['month']) ? $_GET['month'] : date('Y-m');
		if (!empty($month)) {
			$data['month'] = $month;
		}

		$getData = $this->api->apiPost($this->userInfo['token'], "plan_actual/create_manually_investor", $data);

		$result = $this->callApiInvest($data);
		if (!empty($result->status) && $result->status == 200) {
			$total_ndt_hoptac_phatsinh = 0;
			if (!empty($getData) && $getData->status == 200){
				for ($i =0; $i< count($result->data); $i++){
					$result->data[$i]->phatSinhNdtHopTac = $getData->data[$i]->phatSinhNdtHopTac;
					$result->data[$i]->manually_investor_id = $getData->data[$i]->_id->{'$oid'};
					$total_ndt_hoptac_phatsinh += $getData->data[$i]->phatSinhNdtHopTac;
				}
			}
			$this->data['data'] = $result->data;
			$this->data['total_ndt_hoptac'] = $result->total_ndt_hoptac;
			$this->data['total_app_ndt_vimo'] = $result->total_app_ndt_vimo;
			$this->data['total_vndt'] = $result->total_vndt;
			$this->data['total_app_ndt_nl'] = $result->total_app_ndt_nl;
			$this->data['total_ndt_hoptac_phatsinh'] = $total_ndt_hoptac_phatsinh;

		} else {
			$this->data['data'] = array();
		}

		$this->data['template'] = 'page/plan_actual/indexInvestor.php';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function callApiInvest($data){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->config->item('URL_NDT').'/plan/getDataInvestor',
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

	public function update_plan_actual(){

		$return = $this->api->apiPost($this->userInfo['token'], "plan_actual/cron_plan_actual_view");

		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "200"))));
		} else {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400"))));
		}
	}


}


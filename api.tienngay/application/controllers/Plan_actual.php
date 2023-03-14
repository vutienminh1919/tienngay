<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
require_once APPPATH . 'libraries/NL_Withdraw.php';
require_once APPPATH . 'libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

class Plan_actual extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('menu_model');
		$this->load->model("transaction_model");
		$this->load->model('user_model');
		$this->load->model('role_model');
		$this->load->model('bank_balance_model');
		$this->load->model('import_vps_model');
		$this->load->model('manually_enter_model');
		$this->load->model("temporary_plan_contract_model");
		$this->load->model("transaction_model");
		$this->load->model("contract_model");
		$this->load->model("import_historical_model");
		$this->load->model("manually_investor_model");
		$this->load->model("investor_deposit_rate_model");
		$this->load->model("plan_actual_model");
		$this->load->helper('lead_helper');

		date_default_timezone_set('Asia/Ho_Chi_Minh');

		$this->createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		$headers = $this->input->request_headers();
		$this->flag_login = 1;
		$this->superadmin = false;
		$this->dataPost = $this->input->post();
		if (!empty($headers['Authorization']) || !empty($headers['authorization'])) {
			$headers_item = !empty($headers['Authorization']) ? $headers['Authorization'] : $headers['authorization'];
			$token = Authorization::validateToken($headers_item);
			if ($token != false) {
				// Kiểm tra tài khoản và token có khớp nhau và có trong db hay không
				$this->app_login = array(
					'_id' => new \MongoDB\BSON\ObjectId($token->id),
					'email' => $token->email,
					"status" => "active",
					// "is_superadmin" => 1
				);
				//Web
				if ($this->dataPost['type'] == 1) $this->app_login['token_web'] = $headers_item;
				if ($this->dataPost['type'] == 2) $this->app_login['token_app'] = $headers_item;
				$count_account = $this->user_model->count($this->app_login);
				$this->flag_login = 'success';
				if ($count_account != 1) $this->flag_login = 2;
				if ($count_account == 1) {
					$this->info = $this->user_model->findOne($this->app_login);
					$this->id = $this->info['_id'];
					$this->ulang = !empty($this->info['lang']) ? $this->info['lang'] : "english";
					$this->uemail = $this->info['email'];

					// Get access right
					$roles = $this->role_model->getRoleByUserId((string)$this->id);
					$this->roleAccessRights = $roles['role_access_rights'];
					$this->superadmin = isset($this->info['is_superadmin']) && (int)$this->info['is_superadmin'] === 1;
				}
			}
		}
		unset($this->dataPost['type']);

	}

	private $createdAt, $flag_login, $id, $uemail, $ulang, $app_login, $dataPost, $roleAccessRights, $info;


	public function create_bank_balance_post()
	{
		$day = !empty($this->dataPost['day']) ? $this->dataPost['day'] : "";

		$newdate = strtotime('-1 day', strtotime($day));
		$check_update = $this->bank_balance_model->findOne(array("year" => date('Y', $newdate), "month" => date('m', $newdate), "day" => date('d', $newdate)));

		if (empty($check_update)){
			$response = array(
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => "Success",
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

		$list_noidung = array_merge(tk_tcv(), tk_tcv_db(), tong_tk_l2(), tong_tk_khac());
		if (!empty($list_noidung)) {
			$bank_balance_day = $this->bank_balance_model->findOne(array("year" => date('Y', strtotime($day)), "month" => date('m', strtotime($day)), "day" => date('d', strtotime($day))));
			if (empty($bank_balance_day)) {
				foreach ($list_noidung as $key => $value) {
					$data_arr = array();
					$data_arr['day'] = date('d', strtotime($day));
					$data_arr['month'] = date('m', strtotime($day));
					$data_arr['year'] = date('Y', strtotime($day));
					$data_arr['noidung'] = $value;
					$data_arr['sodudaungay'] = $this->check_sodudaungay($day, $value);
					$data_arr['pstang'] = 0;
					$data_arr['psgiam'] = 0;
					$data_arr['sodukd'] = 0;
					$data_arr['created_at'] = $this->createdAt;
					$data_arr['time_day'] = strtotime($day);
					$this->bank_balance_model->insert($data_arr);
				}
			}
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Success",

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function check_sodudaungay($day, $noidung)
	{

		$newdate = strtotime('-1 day', strtotime($day));

		$check_update = $this->bank_balance_model->findOne(array("year" => date('Y', $newdate), "month" => date('m', $newdate), "day" => date('d', $newdate), 'noidung' => $noidung));

		$so_du_cuoi_ngay = $check_update['sodudaungay'] + $check_update['pstang'] - $check_update['psgiam'];

		if (!empty($check_update)) {
			return $so_du_cuoi_ngay;
		} else {
			return 0;
		}
	}

	public function getBankBalance_post()
	{

		$condition = [];
		$day = !empty($this->dataPost['day']) ? $this->dataPost['day'] : "";
		$dataBankBalance_tcv = [];
		$dataBankBalance_tcv_db = [];
		$dataBankBalance_tk_l2 = [];
		$dataBankBalance_tk_khac = [];
		//
		$getBankBalance = $this->bank_balance_model->find_where(['year' => date('Y', strtotime($day)), 'month' => date('m', strtotime($day)), 'day' => date('d', strtotime($day))]);

		//Tổng
		$total_lk_l1 = 0;
		$total_lk_l2 = 0;
		$total_lk_tcv = 0;
		$total_lk_tcv_db = 0;
		$total_lk_khac = 0;
		$count_tcv = 0;
		$count_tcv_db = 0;
		$count_tk_l2 = 0;
		$count_tk_khac = 0;

		//Total số dư cuối ngày
		$ducuoingay_tcv = 0;
		$ducuoingay_tcv_db = 0;
		$ducuoingay_tk_l2 = 0;
		$ducuoingay_tk_khac = 0;
		$ducuoingay_tk_l1 = 0;

		//Số dư kd
		$dukinhdoanh_l1 = 0;
		$dukinhdoanh_l2 = 0;
		$dukinhdoanh_khac = 0;
		$dukinhdoanh_tcv_db = 0;
		$dukinhdoanh_tcv = 0;

		if (!empty($getBankBalance)) {
			foreach ($getBankBalance as $key => $value) {
				$value['sodudaungay'] = $this->total_sodudaungay($day, $value['noidung'], $value['sodudaungay']);
				if (in_array($value['noidung'], tk_tcv())) {
					$dataBankBalance_tcv[$count_tcv] = $value;
					$total_lk_tcv += $value['sodudaungay'];
					$dataBankBalance_tcv[$count_tcv]['soducuoingay'] = $value['sodudaungay'] + $value['pstang'] - $value['psgiam'];
					$ducuoingay_tcv += $dataBankBalance_tcv[$count_tcv]['soducuoingay'];
					$dukinhdoanh_tcv += $value['sodukd'];
					$count_tcv++;
				} elseif (in_array($value['noidung'], tk_tcv_db())) {
					$dataBankBalance_tcv_db[$count_tcv_db] = $value;
					$total_lk_tcv_db += $value['sodudaungay'];
					$dataBankBalance_tcv_db[$count_tcv_db]['soducuoingay'] = $value['sodudaungay'] + $value['pstang'] - $value['psgiam'];
					$ducuoingay_tcv_db += $dataBankBalance_tcv_db[$count_tcv_db]['soducuoingay'];
					$dukinhdoanh_tcv_db += $value['sodukd'];
					$count_tcv_db++;
				} elseif (in_array($value['noidung'], tong_tk_l2())) {
					$dataBankBalance_tk_l2[$count_tk_l2] = $value;
					$dataBankBalance_tk_l2[$count_tk_l2]['soducuoingay'] = $value['sodudaungay'] + $value['pstang'] - $value['psgiam'];
					$total_lk_l2 += $value['sodudaungay'];
					$ducuoingay_tk_l2 += $dataBankBalance_tk_l2[$count_tk_l2]['soducuoingay'];
					$dukinhdoanh_l2 += $value['sodukd'];
					$count_tk_l2++;
				} elseif (in_array($value['noidung'], tong_tk_khac())) {
					$dataBankBalance_tk_khac[$count_tk_khac] = $value;
					$dataBankBalance_tk_khac[$count_tk_khac]['soducuoingay'] = $value['sodudaungay'] + $value['pstang'] - $value['psgiam'];
					$total_lk_khac += $value['sodudaungay'];
					$ducuoingay_tk_khac += $dataBankBalance_tk_khac[$count_tk_khac]['soducuoingay'];
					$dukinhdoanh_khac += $value['sodukd'];
					$count_tk_khac++;
				}
			}
		}
		$total_lk_l1 = $total_lk_tcv + $total_lk_tcv_db;
		$ducuoingay_tk_l1 = $ducuoingay_tcv + $ducuoingay_tcv_db;
		$dukinhdoanh_l1 = $dukinhdoanh_tcv + $dukinhdoanh_tcv_db;

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Success",
			'data_tcv' => $dataBankBalance_tcv,
			'data_tcv_db' => $dataBankBalance_tcv_db,
			'data_tk_l2' => $dataBankBalance_tk_l2,
			'total_lk_tcv' => $total_lk_tcv,
			'total_lk_tcv_db' => $total_lk_tcv_db,
			'total_lk_l2' => $total_lk_l2,
			'total_lk_khac' => $total_lk_khac,
			'dataBankBalance_tk_khac' => $dataBankBalance_tk_khac,
			'total_lk_l1' => $total_lk_l1,
			'ducuoingay_tk_khac' => $ducuoingay_tk_khac,
			'ducuoingay_tcv' => $ducuoingay_tcv,
			'ducuoingay_tcv_db' => $ducuoingay_tcv_db,
			'ducuoingay_tk_l2' => $ducuoingay_tk_l2,
			'ducuoingay_tk_l1' => $ducuoingay_tk_l1,
			'dukinhdoanh_tcv' => $dukinhdoanh_tcv,
			'dukinhdoanh_tcv_db' => $dukinhdoanh_tcv_db,
			'dukinhdoanh_l1' => $dukinhdoanh_l1,
			'dukinhdoanh_l2' => $dukinhdoanh_l2,
			'dukinhdoanh_khac' => $dukinhdoanh_khac,

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;


	}

	function total_sodudaungay($day, $noidung, $value_sodudaungay){
		//Lấy số dư cuối ngày hôm trước
		$newdate = strtotime ( '-1 day' , strtotime ( $day ) ) ;
		$getSoDuCuoiNgay = $this->bank_balance_model->findOne(['year' => date('Y', $newdate), 'month' => date('m', $newdate), 'day' => date('d', $newdate), 'noidung' => $noidung]);
		if (!empty($getSoDuCuoiNgay)){
			$soDuDauNgay = $getSoDuCuoiNgay['sodudaungay'] + $getSoDuCuoiNgay['pstang'] - $getSoDuCuoiNgay['psgiam'];
		} else {
			$soDuDauNgay = $value_sodudaungay;
		}
		return $soDuDauNgay;
	}

	public function update_bank_balance_post()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : "";

		$updateBankBlance = $this->bank_balance_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($id)));

		if (isset($data['updated_at'])) {
			$data['updated_at'] = (int)$data['updated_at'];
		}
		if (empty($updateBankBlance)) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Không tồn tại dữ liệu cần cập nhật"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

		unset($data['id']);

		if (isset($data["sodudaungay"])) {
			$data["sodudaungay"] = (float)$data["sodudaungay"];
		}
		if (isset($data["pstang"])) {
			$data["pstang"] = (float)$data["pstang"];
		}
		if (isset($data["psgiam"])) {
			$data["psgiam"] = (float)$data["psgiam"];
		}
		if (isset($data["sodukd"])) {
			$data["sodukd"] = (float)$data["sodukd"];
		}

		$this->bank_balance_model->update(
			array("_id" => new MongoDB\BSON\ObjectId($id)),
			$data
		);

		//Update số dư đầu ngày ngày hôm trước
		$day = $updateBankBlance['day'];
		$month = $updateBankBlance['month'];
		$year = $updateBankBlance['year'];
		$newdate = strtotime('+1 day', strtotime("$year-$month-$day"));
		$new_balance =  $this->bank_balance_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($id)));
		$check_update = $this->bank_balance_model->find_where(array("time_day" => ['$gte' => $newdate], 'noidung' => $updateBankBlance['noidung']));

		if (!empty($check_update)){
				for ($i = 0;  $i < count($check_update); $i++){
					if($i == 0){
						$so_du_cuoi_ngay = $new_balance['sodudaungay'] + $new_balance['pstang'] - $new_balance['psgiam'];
						$this->bank_balance_model->update(
							array("_id" => new MongoDB\BSON\ObjectId($check_update[$i]['_id'])),
							['sodudaungay' => $so_du_cuoi_ngay ]
						);
					} else {
						$newupdate = $this->bank_balance_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($check_update[$i-1]['_id'])));
						if(!empty($newupdate)){
							$so_du_cuoi_ngay = $newupdate['sodudaungay'] +  $newupdate['pstang'] - $newupdate['psgiam'];
							$this->bank_balance_model->update(
								array("_id" => new MongoDB\BSON\ObjectId((string)$check_update[$i]['_id'])),
								['sodudaungay' => $so_du_cuoi_ngay ]
							);
						}
					}

				}
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Update success",
			'data' => $data
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function update_investor_post(){

		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : "";

		$updateInvestor = $this->manually_investor_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($id)));

		if (isset($data['updated_at'])) {
			$data['updated_at'] = (int)$data['updated_at'];
		}
		if (empty($updateInvestor)) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Không tồn tại dữ liệu cần cập nhật"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

		unset($data['id']);

		if (isset($data["phatSinhNdtHopTac"])) {
			$data["phatSinhNdtHopTac"] = (float)$data["phatSinhNdtHopTac"];
		}

		$this->manually_investor_model->update(
			array("_id" => new MongoDB\BSON\ObjectId($id)),
			$data
		);
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Update success",
			'data' => $data
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function importFollowVPS_post()
	{

		$data = $this->input->post();
		$data['created_at'] = $this->createdAt;
		$data['created_by'] = $this->uemail;

		if (!empty($data['ngay_gui'])) {
			$data['ngay_gui'] = strtotime($data['ngay_gui']);
		}
		if (!empty($data['ngay_dao_han_du_kien'])) {
			$data['ngay_dao_han_du_kien'] = strtotime($data['ngay_dao_han_du_kien']);
		}
		if (!empty($data['ngay_dao_han_thuc_te'])) {
			$data['ngay_dao_han_thuc_te'] = strtotime($data['ngay_dao_han_thuc_te']);
		}

		$this->import_vps_model->insert($data);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Success",
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function clearImportFollowVPS_post()
	{
		$count = $this->import_vps_model->count();

		for ($i = 0; $i <= $count; $i++) {
			$this->import_vps_model->delete();
		}
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Success",
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function clearImportHistorical_post(){

		$data = $this->input->post();
		$year = !empty($data['year']) ? $data['year'] : "";
		$month = !empty($data['month']) ? $data['month'] : "";

		$data = $this->import_historical_model->find_where(['year' => $year, 'month' => $month, 'status' => 1]);

		if(!empty($data)){
			foreach ($data as $value){
				$this->import_historical_model->update(
					array("_id" => new MongoDB\BSON\ObjectId((string)$value['_id'])),
					['status' => 2]
				);
			}
		}


		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Success",
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function getFollowVPS_post()
	{

		$per_page = !empty($this->dataPost['per_page']) ? $this->dataPost['per_page'] : 30;
		$uriSegment = !empty($this->dataPost['uriSegment']) ? $this->dataPost['uriSegment'] : 0;

		$getVPS = $this->import_vps_model->find_pagination($per_page, $uriSegment);

		if (empty($getVPS)) {
			return;
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Success",
			'data' => $getVPS,
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function getCountFollowVPS_post()
	{
		$count = $this->import_vps_model->count();

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Success",
			'data' => !empty($count) ? $count : 0
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function total_price_vps_post()
	{

		$getVps = $this->import_vps_model->find();
		$total_tien_gui_goc = 0;
		$total_lai_dao_han_du_kien = 0;
		$total_lai_thuc_te = 0;
		$total_tong_tien_dao_han = 0;

		if (!empty($getVps)) {
			foreach ($getVps as $value) {
				$total_tien_gui_goc += (int)$value['so_tien_gui_goc'];
				$total_lai_dao_han_du_kien += (int)$value['lai_dao_han_du_kien'];
				$total_lai_thuc_te += (int)$value['lai_thuc_te'];
				$total_tong_tien_dao_han += (int)$value['tong_tien_dao_han'];
			}
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Success",
			'total_tien_gui_goc' => $total_tien_gui_goc,
			'total_lai_dao_han_du_kien' => $total_lai_dao_han_du_kien,
			'total_lai_thuc_te' => $total_lai_thuc_te,
			'total_tong_tien_dao_han' => $total_tong_tien_dao_han,
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function getTongSoDuCacTaiKhoan_post()
	{

		$data = $this->input->post();
		$dataMonth = !empty($data['month']) ? $data['month'] : "";

		$getDayOfMonth = $this->getDayMonth($dataMonth);

//		$totalBalance = $this->totalBalance($dataMonth);
		$totalBalance = $this->plan_actual_model->findOne(['year' => date('Y', strtotime($this->dataPost['month'])), 'month' => date('m', strtotime($this->dataPost['month']))]);
		$manually_enter = $this->manually_enter_model->find_where(['year' => date('Y', strtotime($this->dataPost['month'])), 'month' => date('m', strtotime($this->dataPost['month']))]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Success",
			'getDayOfMonth' => !empty($getDayOfMonth) ? $getDayOfMonth : [],
			'totalBalance' => !empty($totalBalance) ? $totalBalance['totalBalance'] : [],
			'manually_enter' => !empty($manually_enter) ? $manually_enter : [],

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function cron_plan_actual_post(){

		$data = $this->input->post();
		$dataMonth = !empty($data['month']) ? $data['month'] : date("Y-m");
		$totalBalance = $this->totalBalance($dataMonth);
		$year = date('Y', strtotime($dataMonth));
		$month = date('m', strtotime($dataMonth));


		$data = [
			"year" => $year,
			"month" => $month,
			"totalBalance" => $totalBalance,
			"created_at" => $this->createdAt
		];

		$plan_actual = $this->plan_actual_model->findOne(['year' => $year, 'month' => $month]);
		if (empty($plan_actual)){
			$this->plan_actual_model->insert($data);
		} else {
			$this->plan_actual_model->update(['_id' => new MongoDB\BSON\ObjectId((string)$plan_actual['_id'])],$data);
		}
		echo "cron_ok";
	}

	public function cron_plan_actual_view_post(){

		$data = $this->input->post();
		$dataMonth = !empty($data['month']) ? $data['month'] : date("Y-m");
		$totalBalance = $this->totalBalance($dataMonth);
		$year = date('Y', strtotime($dataMonth));
		$month = date('m', strtotime($dataMonth));

		$data = [
			"year" => $year,
			"month" => $month,
			"totalBalance" => $totalBalance,
			"created_at" => $this->createdAt
		];

		$plan_actual = $this->plan_actual_model->findOne(['year' => $year, 'month' => $month]);
		if (empty($plan_actual)){
			$this->plan_actual_model->insert($data);
		} else {
			$this->plan_actual_model->update(['_id' => new MongoDB\BSON\ObjectId((string)$plan_actual['_id'])],$data);
		}
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Success",
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function getDayMonth($dataMonth)
	{

		$month = !empty($dataMonth) ? date('m', strtotime($dataMonth)) : date('m');
		$year = !empty($dataMonth) ? date('Y', strtotime($dataMonth)) : date('Y');

		$endDayMonth = $this->lastday($month, $year);
		$arrMonth = [];

		for ($i = 1; $i <= $endDayMonth; $i++) {
			$day = strtotime("$year-$month-$i");
			$day_current = $this->sw_get_current_weekday($day);
			array_push($arrMonth, $day_current);
		}
		return $arrMonth;
	}

	function lastday($month = '', $year = '')
	{
		if (empty($month)) {
			$month = date('m');
		}
		if (empty($year)) {
			$year = date('Y');
		}
		$result = strtotime("{$year}-{$month}-01");
		$result = strtotime('-1 second', strtotime('+1 month', $result));
		return date('d', $result);
	}

	function sw_get_current_weekday($day)
	{
		$weekday = date("l", $day);
		$weekday = strtolower($weekday);
		switch ($weekday) {
			case 'monday':
				$weekday = 'T2';
				break;
			case 'tuesday':
				$weekday = 'T3';
				break;
			case 'wednesday':
				$weekday = 'T4';
				break;
			case 'thursday':
				$weekday = 'T5';
				break;
			case 'friday':
				$weekday = 'T6';
				break;
			case 'saturday':
				$weekday = 'T7';
				break;
			default:
				$weekday = 'CN';
				break;
		}
		return $weekday . ', ' . date('d/m/Y', $day);
	}

	public function totalBalance($dataMonth)
	{
		$month = !empty($dataMonth) ? date('m', strtotime($dataMonth)) : date('m');
		$year = !empty($dataMonth) ? date('Y', strtotime($dataMonth)) : date('Y');

		$noidung = array_merge(tk_tcv(), tk_tcv_db());

		$endDayMonth = $this->lastday($month, $year);
		$dataBankBalance = [];
		$net_cf_budget_l2 = [];
		$actual_net_cf_budget_l2 = [];
		//Những hd có số ngày chậm trả <10
		$arr_code_contract = [];
		$code_contract = $this->contract_model->findWhereSelect(['status' => ['$in' => list_array_trang_thai_dang_vay()],'debt.so_ngay_cham_tra' => ['$lt' => 10]], ['code_contract']);
		$ratio = $this->investor_deposit_rate_model->find();
		if (!empty($code_contract)){
			foreach ($code_contract as $value){
				array_push($arr_code_contract, $value['code_contract']);
			}
		}
		$net_cf_budget_l1 = 0;
		for ($i = 0; $i < $endDayMonth; $i++) {
			$day = $i + 1;
			$day = date('d', strtotime("$year-$month-$day"));

			$dataBankBalance[$i]['tong_tien_tai_khoan_ngan_hang'] = $net_cf_budget_l1 + $this->bank_balance_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day, 'noidung' => ['$in' => $noidung]], '$sodudaungay');

			//Tổng tiền gốc VPS (2)
			$dataBankBalance[$i]['tong_tien_goc_vps'] = $this->import_vps_model->sum_where(['type' => "1"], '$so_tien_gui_goc');

			//Tổng gốc + lãi VPS có ngày đến hạn (2.1)
			$strDay = strtotime("$year-$month-$day");
			$dataBankBalance[$i]['goc_lai_vps_den_han'] = $this->total_goc_lai_vps($strDay);

			//Tổng gốc + lãi VPS có ngày chưa đến hạn (2.2)
			$dataBankBalance[$i]['goc_lai_vps_chua_den_han'] = $this->total_goc_lai_vps_chua_den_han($strDay);

			//Tổng tiền gốc VPS có thể sử dụng (2.4)
			$dataBankBalance[$i]['tong_goc_VPS_co_the_su_dung'] = $this->total_goc_lai_vps($strDay) + $this->manually_enter_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day], '$tong_tien_vps_chua_den_han_du_kien_dao');

			//Tổng tiền có thể sử dụng L1 (3)
			$dataBankBalance[$i]['tong_tien_co_the_su_dung'] = $dataBankBalance[$i]['tong_goc_VPS_co_the_su_dung'] + $dataBankBalance[$i]['tong_tien_tai_khoan_ngan_hang'];

			//Dòng tiền vào - thu nợ nhóm nợ 1
			//Gốc
			$dataBankBalance[$i]['goc'] = $this->temporary_plan_contract_model->sum_where_total(['ngay_ky_tra' => strtotime("$year-$month-$day"), 'code_contract' => ['$in' => $arr_code_contract]], '$tien_goc_1ky');

			//Lãi
			$dataBankBalance[$i]['lai'] = $this->temporary_plan_contract_model->sum_where_total(['ngay_ky_tra' => strtotime("$year-$month-$day"), 'code_contract' => ['$in' => $arr_code_contract]], '$lai_ky');

			//Phí tư vấn
			$dataBankBalance[$i]['phi_tu_van'] = $this->temporary_plan_contract_model->sum_where_total(['ngay_ky_tra' => strtotime("$year-$month-$day"), 'code_contract' => ['$in' => $arr_code_contract]], '$phi_tu_van');

			//Phí thẩm định
			$dataBankBalance[$i]['phi_tham_dinh'] = $this->temporary_plan_contract_model->sum_where_total(['ngay_ky_tra' => strtotime("$year-$month-$day"), 'code_contract' => ['$in' => $arr_code_contract]], '$phi_tham_dinh');

			//Total plan
			$dataBankBalance[$i]['total_plan'] = ($dataBankBalance[$i]['lai'] + $dataBankBalance[$i]['phi_tu_van'] + $dataBankBalance[$i]['phi_tham_dinh'] + $dataBankBalance[$i]['goc']) * 0.95;

			//Tổng dòng tiền vào L1
			$total_thu_l2 = $this->manually_enter_model->sum_where_total(['year' => $year, 'month' => $month , 'day' => $day],'$thu_l2');
			$total_khac = $this->manually_enter_model->sum_where_total(['year' => $year, 'month' => $month , 'day' => $day],'$thu_khac');
			$dataBankBalance[$i]['total_dong_tien_l1'] = $dataBankBalance[$i]['total_plan'] + $total_thu_l2 + $total_khac;

			//III- Dòng tiền ra
			$dataBankBalance[$i]['thanh_toan_theo_cac_dot'] = $this->import_historical_model->sum_where_total(['year' => $year, 'month' => $month , 'day' => $day, 'status' => 1],'$gia_dinh_thanh_toan');

			//CP hoat động
			$dataBankBalance[$i]['cp_hoat_dong'] = $dataBankBalance[$i]['thanh_toan_theo_cac_dot'] + $this->manually_enter_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day], '$thanh_toan_ngoai_le');

			//Tổng dòng tiền ra
			$dataBankBalance[$i]['tong_dong_tien_ra'] = $dataBankBalance[$i]['cp_hoat_dong'] + $this->manually_enter_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day], '$thanh_toan_ve_l2') + $this->manually_enter_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day], '$cac_khoan_chi_khac');

			//Net CF Budget-L1
			$dataBankBalance[$i]['net_cf_budget_l1'] = $dataBankBalance[$i]['total_dong_tien_l1'] - $dataBankBalance[$i]['tong_dong_tien_ra'];
			$net_cf_budget_l1 = $dataBankBalance[$i]['net_cf_budget_l1'];

			//Dư tiền cần tại tk nh L1
			$dataBankBalance[$i]['du_tien_can_tai_tk_nh_l1'] = $dataBankBalance[$i]['net_cf_budget_l1'] + $dataBankBalance[$i]['tong_tien_co_the_su_dung'];

			//Ví NL TMQ
			$dataBankBalance[$i]['vi_nl_tmq'] = $this->bank_balance_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day, 'noidung' => "Ví NL TMQ"], '$sodudaungay');
			//Ví Vimo VFC
			$dataBankBalance[$i]['vi_vimo_vfc'] = $this->bank_balance_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day, 'noidung' => "Ví Vimo VFC"], '$sodudaungay');
			//Ví Vimo Vay Mượn
			$dataBankBalance[$i]['vi_vimo_vaymuon'] = $this->bank_balance_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day, 'noidung' => "Ví Vimo Vay Mượn"], '$sodudaungay');
			//Ví VNDT
			$dataBankBalance[$i]['vi_vndt'] = $this->bank_balance_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day, 'noidung' => "Ví VNDT"], '$sodudaungay');
			//TK Tech TMQ
			$dataBankBalance[$i]['vi_tech_tmq'] = $this->bank_balance_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day, 'noidung' => "TK Tech TMQ"], '$sodudaungay');

			//Tổng tiền VPS có thể sử dụng
			$dataBankBalance[$i]['tong_tien_vps_co_the_su_dung'] = $dataBankBalance[$i]['goc_lai_vps_den_han'] + $this->manually_enter_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day], '$tong_tien_vps_chua_den_han_du_kien_dao_1');

			//Tổng tiền có thể sử dụng L2
			$dataBankBalance[$i]['tong_tien_co_the_su_dung_l2'] = $dataBankBalance[$i]['vi_nl_tmq'] + $dataBankBalance[$i]['vi_vimo_vfc'] + $dataBankBalance[$i]['vi_vimo_vaymuon'] + $dataBankBalance[$i]['vi_vndt'] + $dataBankBalance[$i]['tong_tien_vps_co_the_su_dung'] ;

			//Budget NĐT Hợp tác
			$budget_nap_ndt_hop_tac = $this->callApiInvest(['year' => $year, 'month' => $month, 'status' => 'UQ'], '/plan/sumTransactionWalletLastMonth')->data;
			$dataBankBalance[$i]['budget_nap_ndt_hop_tac'] = ($budget_nap_ndt_hop_tac * ($ratio[0]['ndt_hop_tac']/100))/30;

			//Budget NĐT vi NL
			$budget_nap_app_vi_nl = $this->callApiInvest(['year' => $year, 'month' => $month, 'status' => 'nganluong'], '/plan/sumTransactionWalletLastMonth')->data;
			$dataBankBalance[$i]['budget_nap_app_vi_nl'] = ($budget_nap_app_vi_nl * ($ratio[0]['ndt_app_vi_nl']/100))/30;

			//Budget NĐT vi NL
			$budget_nap_app_vi_vimo = $this->callApiInvest(['year' => $year, 'month' => $month, 'status' => 'vimo'], '/plan/sumTransactionWalletLastMonth')->data;
			$dataBankBalance[$i]['budget_nap_app_vi_vimo'] = ($budget_nap_app_vi_vimo * ($ratio[0]['ndt_app_vi_vimo']/100))/30;

			//Nhà đầu tư nạp tiền:
			$dataBankBalance[$i]['nha_dau_tu_nap_tien'] = $dataBankBalance[$i]['budget_nap_app_vi_nl'] + $dataBankBalance[$i]['budget_nap_app_vi_vimo'] + $dataBankBalance[$i]['budget_nap_ndt_hop_tac'];

			//Tổng dòng tiền vào L2:
			$dataBankBalance[$i]['tong_dong_tien_vao_l2'] = $dataBankBalance[$i]['nha_dau_tu_nap_tien'] + $this->manually_enter_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day], '$nhan_khac') + $this->manually_enter_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day], '$thanh_toan_ve_l2');

			//Khách hàng PGD
			$dataBankBalance[$i]['price_disbursement'] = $this->price_disbursement($year, $month, $day);

			//Giải ngân
			$dataBankBalance[$i]['giai_ngan'] = $dataBankBalance[$i]['price_disbursement'] + $this->manually_enter_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day], '$priority_nd');

			//Thanh toán NĐT App ví NL
			$dataBankBalance[$i]['app_vi_nl'] = $this->callApiInvest(['year' => $year, 'month' => $month, 'day' => $day, 'status' => 'bank', 'check_ndt' => 1], '/plan/sumPayNdt')->data;

			//Thanh toán NĐT App ví Vimo
			$dataBankBalance[$i]['app_vi_vimo'] = $this->callApiInvest(['year' => $year, 'month' => $month, 'day' => $day, 'status' => 'vimo', 'check_ndt' => 1], '/plan/sumPayNdt')->data;

			//Thanh toán NĐT Hợp tác
			$dataBankBalance[$i]['ndt_hop_tac'] = $this->callApiInvest(['year' => $year, 'month' => $month, 'day' => $day, 'status' => 'UQ', 'check_ndt' => 2], '/plan/sumPayNdt')->data;

			//Thanh toán NĐT VNDT
			$dataBankBalance[$i]['vndt'] = $this->callApiInvest(['year' => $year, 'month' => $month, 'day' => $day, 'status' => 'vndt', 'check_ndt' => 2], '/plan/sumPayNdt')->data;

			//Thanh toán NĐT
			$dataBankBalance[$i]['thanh_toan_ndt'] = $dataBankBalance[$i]['app_vi_nl'] + $dataBankBalance[$i]['app_vi_vimo'] + $dataBankBalance[$i]['ndt_hop_tac'] + $dataBankBalance[$i]['vndt'];

			//Tổng dòng tiền ra L2
			$dataBankBalance[$i]['tong_dong_tien_ra_l2'] = $dataBankBalance[$i]['giai_ngan'] + $dataBankBalance[$i]['thanh_toan_ndt'];

			//Net CF Budget L2
			$dataBankBalance[$i]['net_cf_budget_l2'] = abs($dataBankBalance[$i]['tong_dong_tien_vao_l2'] - $dataBankBalance[$i]['tong_dong_tien_ra_l2']);
			array_push($net_cf_budget_l2, $dataBankBalance[$i]['tong_dong_tien_ra_l2']);

			//Ví NL
			$dataBankBalance[$i]['VI_vi_nl'] =  $dataBankBalance[$i]['vi_nl_tmq'] + $dataBankBalance[$i]['budget_nap_ndt_hop_tac'] + $dataBankBalance[$i]['budget_nap_app_vi_nl'] + $this->manually_enter_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day], '$thanh_toan_ve_l2') + $this->manually_enter_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day], '$nhan_khac') - $dataBankBalance[$i]['giai_ngan'] - $dataBankBalance[$i]['ndt_hop_tac'] - $dataBankBalance[$i]['app_vi_nl'];

			//Ví Vimo VFC
			$dataBankBalance[$i]['VI_vi_vimo_vfc'] = $dataBankBalance[$i]['vi_vimo_vfc'] + $dataBankBalance[$i]['budget_nap_app_vi_vimo'] - $dataBankBalance[$i]['app_vi_vimo'];

			//Ví vndt
			$dataBankBalance[$i]['VI_vi_vndt'] = $dataBankBalance[$i]['vi_vndt'] - $dataBankBalance[$i]['vndt'];

			//Tổng tiền cần để đảm bảo thanh khoản cao nhất
			$dataBankBalance[$i]['tong_tien_can_de_dam_bao_thanh_khoan_cao_nhat'] = $dataBankBalance[$i]['tong_tien_tai_khoan_ngan_hang'] + $dataBankBalance[$i]['tong_tien_goc_vps'] + $dataBankBalance[$i]['total_dong_tien_l1'] - $dataBankBalance[$i]['tong_dong_tien_ra'] + $dataBankBalance[$i]['vi_nl_tmq'] + $dataBankBalance[$i]['vi_vimo_vfc'] + $dataBankBalance[$i]['vi_vimo_vaymuon'] + $dataBankBalance[$i]['vi_vndt'] + $dataBankBalance[$i]['vi_tech_tmq'] + $dataBankBalance[$i]['tong_tien_goc_vps'] + $dataBankBalance[$i]['tong_dong_tien_vao_l2'] - $dataBankBalance[$i]['tong_dong_tien_ra_l2'];

			/**
			 * Actual
			 */
			//Trả ví ngân lượng
			$dataBankBalance[$i]['actual_app_vi_nl'] = $this->callApiInvest(['year' => $year, 'month' => $month, 'day' => $day, 'status' => 'nganluong', 'check_ndt' => 1], '/plan/sumPayNdtActual')->data;

			//Trả ví vimo
			$dataBankBalance[$i]['actual_app_vi_vimo'] = $this->callApiInvest(['year' => $year, 'month' => $month, 'day' => $day, 'status' => 'vimo', 'check_ndt' => 1], '/plan/sumPayNdtActual')->data;

			//Thanh toán NĐT Hợp tác
			$dataBankBalance[$i]['actual_ndt_hop_tac_1'] = $this->callApiInvest(['year' => $year, 'month' => $month, 'day' => $day, 'status' => 'UQ', 'check_ndt' => 2], '/plan/sumPayNdtActual')->data;


			//Nạp tiền NĐT App Ví NL
			$dataBankBalance[$i]['nap_app_vi_nl'] = $this->callApiInvest(['year' => $year, 'month' => $month, 'day' => $day, 'status' => 'nganluong'], '/plan/sumTransactionWallet')->data;

			//Nạp tiền NĐT App Ví Vimo
			$dataBankBalance[$i]['nap_app_vi_vimo'] = $this->callApiInvest(['year' => $year, 'month' => $month, 'day' => $day, 'status' => 'vimo'], '/plan/sumTransactionWallet')->data;

			//Tổng tiền gốc lãi đến hạn
			$dataBankBalance[$i]['actual_goc_lai_vps_den_han'] = $this->total_goc_lai_vps_actual($strDay);

			//Tổng tiền VPS chưa đến hạn
			$dataBankBalance[$i]['actual_tong_tien_vps_chua_den_han'] = $this->actual_total_goc_lai_vps_chua_den_han($strDay);

			//Tổng tiền tại các TK NH:
			$dataBankBalance[$i]['actual_tong_tien_tai_khoan_ngan_hang'] = $this->bank_balance_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day, 'noidung' => ['$in' => $noidung]], '$sodudaungay');

			//Tổng tiền VPS có thể sử dụng
			$dataBankBalance[$i]['actual_tong_tien_vps_co_the_su_dung'] = $this->manually_enter_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day], '$actual_tong_tien_vps_chua_den_han_du_kien_dao_1') + $dataBankBalance[$i]['actual_goc_lai_vps_den_han'];
			$dataBankBalance[$i]['actual_tong_tien_vps_co_the_su_dung_1'] = $this->manually_enter_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day], '$actual_tong_tien_vps_chua_den_han_du_kien_dao') + $dataBankBalance[$i]['actual_goc_lai_vps_den_han'];


			//Tổng tiền có thể sử dụng
			$dataBankBalance[$i]['actual_tong_tien_co_the_su_dung'] = $dataBankBalance[$i]['actual_tong_tien_tai_khoan_ngan_hang'] + $dataBankBalance[$i]['actual_tong_tien_vps_co_the_su_dung_1'];

			//Thực thu khách hàng
			$condition = array(
				'$gte' => strtotime(("$year-$month-$day") . ' 00:00:00'),
				'$lte' => strtotime(("$year-$month-$day") . ' 23:59:59')
			);
			$dataBankBalance[$i]['actual_thuc_thu_khach'] = $this->total_transaction_actual($condition);

			//Tổng dòng tiền thực vào L1
			$dataBankBalance[$i]['actual_tong_dong_tien_thuc_vao_l1'] = $dataBankBalance[$i]['actual_thuc_thu_khach'] + $this->manually_enter_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day], '$actual_thu_l2') + $this->manually_enter_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day], '$actual_thu_khac');

			//Thanh toán theo các đợt
			$dataBankBalance[$i]['actual_thanh_toan_theo_cac_dot'] = $this->import_historical_model->sum_where_total(['year' => $year, 'month' => $month , 'day' => $day, 'status' => 1],'$actual');

			//CP hoạt đông
			$dataBankBalance[$i]['actual_cp_hoat_dong'] = $dataBankBalance[$i]['actual_thanh_toan_theo_cac_dot'] + $this->manually_enter_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day], '$actual_thanh_toan_ngoai_le');

			//Tổng dòng tiền ra
			$dataBankBalance[$i]['actual_tong_dong_tien_ra'] = $dataBankBalance[$i]['actual_cp_hoat_dong'] + $this->manually_enter_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day], '$actual_thanh_toan_ve_l2') + $this->manually_enter_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day], '$actual_cac_khoan_chi_khac');

			//Nhà đầu tư nạp tiền:
			$dataBankBalance[$i]['actual_nha_dau_tu_nap_tien'] = $dataBankBalance[$i]['nap_app_vi_nl'] + $dataBankBalance[$i]['nap_app_vi_vimo'] + $this->manually_enter_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day], '$actual_ndt_hop_tac');

			//Tổng dòng tiền vào L2:
			$dataBankBalance[$i]['actual_tong_dong_tien_vao_l2'] = $dataBankBalance[$i]['actual_nha_dau_tu_nap_tien'] +  $this->manually_enter_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day], '$actual_thanh_toan_ve_l2') + $this->manually_enter_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day], '$actual_nhan_khac');

			//KH PGD
			$dataBankBalance[$i]['actual_kh_pgd'] = $price = $this->contract_model->sum_where_total(['store.id'=> ['$nin'=> ['6059d6a25324a742991fd6f3','61945bd9b5987f1710347a65']], 'disbursement_date'=> $condition, 'loan_infor.type_property.code' => ['$in' => ['OTO','XM']] ,'code_contract_parent_cc' => array('$exists' => false),'code_contract_parent_gh' => array('$exists' => false),'status' => array('$in' => list_array_trang_thai_dang_vay_tat_toan())],array('$toLong' => '$loan_infor.amount_money'));

			//Giải ngân
			$dataBankBalance[$i]['actual_giai_ngan'] = $dataBankBalance[$i]['actual_kh_pgd'] + $this->manually_enter_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day], '$actual_priority');

			//Thanh toán nhà đầu tư
			$dataBankBalance[$i]['actual_thanh_toan_ndt'] = $dataBankBalance[$i]['actual_ndt_hop_tac_1'] + $dataBankBalance[$i]['actual_app_vi_nl'] + $dataBankBalance[$i]['actual_app_vi_vimo'];

			//Tổng dòng tiền ra L2
			$dataBankBalance[$i]['actual_tong_dong_tien_ra_l2'] = $dataBankBalance[$i]['actual_giai_ngan'] + $dataBankBalance[$i]['actual_thanh_toan_ndt'] + $dataBankBalance[$i]['actual_cp_hoat_dong'];

			//Net CF Budget L2
			$dataBankBalance[$i]['actual_net_cf_budget_l2'] = abs($dataBankBalance[$i]['actual_tong_dong_tien_vao_l2'] - $dataBankBalance[$i]['actual_tong_dong_tien_ra_l2']);
			array_push($actual_net_cf_budget_l2, $dataBankBalance[$i]['actual_tong_dong_tien_ra_l2']);

			//Ví NL
			$dataBankBalance[$i]['actual_VI_vi_nl'] = $dataBankBalance[$i]['vi_nl_tmq'] + $this->manually_enter_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day], '$actual_ndt_hop_tac') + $dataBankBalance[$i]['nap_app_vi_nl'] + $this->manually_enter_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day], '$actual_thanh_toan_ve_l2') + $this->manually_enter_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day], '$actual_nhan_khac') - $dataBankBalance[$i]['actual_giai_ngan'] - $dataBankBalance[$i]['actual_ndt_hop_tac_1'] - $dataBankBalance[$i]['actual_app_vi_nl'];

			//Ví Vimo VFC
			$dataBankBalance[$i]['actual_VI_vi_vimo_vfc'] = $dataBankBalance[$i]['vi_vimo_vfc'] + $dataBankBalance[$i]['nap_app_vi_vimo'] - $dataBankBalance[$i]['actual_app_vi_vimo'];

			//Tổng tiền cần để đảm bảo thanh khoản cao nhất
			$dataBankBalance[$i]['actual_tong_tien_can_de_dam_bao_thanh_khoan_cao_nhat'] = $dataBankBalance[$i]['actual_tong_tien_tai_khoan_ngan_hang'] + $dataBankBalance[$i]['tong_tien_goc_vps'] + $dataBankBalance[$i]['actual_tong_dong_tien_thuc_vao_l1'] - $dataBankBalance[$i]['actual_tong_dong_tien_ra'] + $dataBankBalance[$i]['vi_nl_tmq'] + $dataBankBalance[$i]['vi_vimo_vfc'] + $dataBankBalance[$i]['vi_vimo_vaymuon'] + $dataBankBalance[$i]['vi_vndt'] + $dataBankBalance[$i]['vi_tech_tmq'] + $dataBankBalance[$i]['tong_tien_goc_vps'] + $dataBankBalance[$i]['actual_tong_dong_tien_vao_l2'] - $dataBankBalance[$i]['actual_tong_dong_tien_ra_l2'];

			//Dư tiền cần tại TK NH L1
			$dataBankBalance[$i]['actual_du_tien_can_tai_tk_nh_l1'] = $dataBankBalance[$i]['actual_tong_tien_co_the_su_dung'] + $dataBankBalance[$i]['actual_tong_dong_tien_thuc_vao_l1'] - $dataBankBalance[$i]['actual_tong_dong_tien_ra'];

			$dataBankBalance[$i]['actual_tong_tien_co_the_su_dung_l2'] = $dataBankBalance[$i]['vi_nl_tmq'] + $dataBankBalance[$i]['vi_vimo_vfc'] + $dataBankBalance[$i]['vi_vimo_vaymuon'] + $dataBankBalance[$i]['vi_vndt'] + $dataBankBalance[$i]['actual_tong_tien_vps_co_the_su_dung'];


			/**
			 * ----------------------
			 */
		}

		//Dự trữ thanh khoản
		$dataBankBalance[0]['du_tru_thanh_khoan'] = abs(max($net_cf_budget_l2) - ((array_sum($net_cf_budget_l2)/count($net_cf_budget_l2)) * 0.5));

		//Safety cash balance
		$dataBankBalance[0]['safety_cash_balance'] = abs(max($actual_net_cf_budget_l2) - ((array_sum($actual_net_cf_budget_l2)/count($actual_net_cf_budget_l2)) * 0.5));


		return $dataBankBalance;
	}

	function total_goc_lai_vps($strDay)
	{
		$get = $this->import_vps_model->find_where(['ngay_dao_han_du_kien' => $strDay]);
		$total = 0;
		if (!empty($get)) {
			foreach ($get as $item) {
				$total += (int)$item['lai_dao_han_du_kien'] + (int)$item['so_tien_gui_goc'];
			}
		}
		return $total;
	}

	function total_goc_lai_vps_actual($strDay)
	{
		$get = $this->import_vps_model->find_where(['ngay_dao_han_thuc_te' => $strDay]);
		$total = 0;
		if (!empty($get)) {
			foreach ($get as $item) {
				$total += (int)$item['lai_thuc_te'] + (int)$item['so_tien_gui_goc'];
			}
		}
		return $total;
	}


	function total_goc_lai_vps_chua_den_han($strDay)
	{
		$get = $this->import_vps_model->find_where(['ngay_dao_han_du_kien' => ['$gt' => $strDay], "trang_thai" => "Chưa đáo hạn"]);
		$total = 0;
		if (!empty($get)) {
			foreach ($get as $item) {
				$total += (int)$item['so_tien_gui_goc'];
			}
		}
		return $total;
	}

	function actual_total_goc_lai_vps_chua_den_han($strDay)
	{
		$get = $this->import_vps_model->find_where(['ngay_dao_han_du_kien' => ['$gt' => $strDay], "trang_thai" => "Chưa đáo hạn"]);
		$total = 0;
		if (!empty($get)) {
			foreach ($get as $item) {
				$total += (int)$item['so_tien_gui_goc'];
			}
		}
		return $total;
	}

	public function create_manually_enter_post()
	{
		$month = !empty($this->dataPost['month']) ? date('m', strtotime($this->dataPost['month'])) : date('m');
		$year = !empty($this->dataPost['month']) ? date('Y', strtotime($this->dataPost['month'])) : date('Y');
		$endDayMonth = $this->lastday($month, $year);

		for ($i = 0; $i < $endDayMonth; $i++) {
			$day = $i + 1;
			$day = date('d', strtotime("$year-$month-$day"));
			$check_manually_enter = $this->manually_enter_model->findOne(["year" => $year, "month" => $month, "day" => $day]);
			if (empty($check_manually_enter)) {
				$data_arr = array();
				$data_arr['day'] = $day;
				$data_arr['month'] = $month;
				$data_arr['year'] = $year;
				$data_arr['tong_tien_vps_chua_den_han_du_kien_dao'] = 0;
				$data_arr['thu_l2'] = 0;
				$data_arr['thu_khac'] = 0;
				$data_arr['thanh_toan_ngoai_le'] = 0;
				$data_arr['thanh_toan_ve_l2'] = 0;
				$data_arr['cac_khoan_chi_khac'] = 0;
				$data_arr['tong_tien_vps_chua_den_han_du_kien_dao_1'] = 0;
				$data_arr['ndt_hop_tac'] = 0;
				$data_arr['nhan_khac'] = 0;
				$data_arr['priority_nd'] = 0;
				$data_arr['actual_tong_tien_vps_chua_den_han_du_kien_dao'] = 0;
				$data_arr['actual_thu_l2'] = 0;
				$data_arr['actual_thu_khac'] = 0;
				$data_arr['actual_thanh_toan_ngoai_le'] = 0;
				$data_arr['actual_thanh_toan_ve_l2'] = 0;
				$data_arr['actual_cac_khoan_chi_khac'] = 0;
				$data_arr['actual_tong_tien_vps_chua_den_han_du_kien_dao_1'] = 0;
				$data_arr['actual_ndt_hop_tac'] = 0;
				$data_arr['actual_nhan_khac'] = 0;
				$data_arr['actual_priority'] = 0;
				$data_arr['created_at'] = $this->createdAt;
				$data_arr['created_by'] = $this->uemail;
				$this->manually_enter_model->insert($data_arr);
			}
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Success",

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function create_manually_investor_post(){
		$month = !empty($this->dataPost['month']) ? date('m', strtotime($this->dataPost['month'])) : date('m');
		$year = !empty($this->dataPost['month']) ? date('Y', strtotime($this->dataPost['month'])) : date('Y');
		$endDayMonth = $this->lastday($month, $year);

		for ($i = 0; $i < $endDayMonth; $i++) {
			$day = $i + 1;
			$day = date('d', strtotime("$year-$month-$day"));
			$check_manually_investor = $this->manually_investor_model->findOne(["year" => $year, "month" => $month, "day" => $day]);
			if (empty($check_manually_investor)) {
				$data_arr = array();
				$data_arr['day'] = $day;
				$data_arr['month'] = $month;
				$data_arr['year'] = $year;
				$data_arr['phatSinhNdtHopTac'] = 0;
				$data_arr['created_at'] = $this->createdAt;
				$data_arr['created_by'] = $this->uemail;
				$this->manually_investor_model->insert($data_arr);
			}
		}

		$data = $this->manually_investor_model->find_where(["year" => $year, "month" => $month]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Success",
			'data' => !empty($data) ? $data : []

		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function update_manually_enter_post()
	{
		$data = $this->input->post();
		$id = !empty($data['id']) ? $data['id'] : "";

		$updateManuallyEnter = $this->manually_enter_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($id)));

		if (isset($data['updated_at'])) {
			$data['updated_at'] = (int)$data['updated_at'];
		}
		if (empty($updateManuallyEnter)) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => "Không tồn tại dữ liệu cần cập nhật"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

		unset($data['id']);

		if (isset($data["tong_tien_vps_chua_den_han_du_kien_dao"])) {
			$data["tong_tien_vps_chua_den_han_du_kien_dao"] = (float)$data["tong_tien_vps_chua_den_han_du_kien_dao"];
		}
		if (isset($data["tong_tien_vps_chua_den_han_du_kien_dao_1"])) {
			$data["tong_tien_vps_chua_den_han_du_kien_dao_1"] = (float)$data["tong_tien_vps_chua_den_han_du_kien_dao_1"];
		}
		if (isset($data["thu_l2"])) {
			$data["thu_l2"] = (float)$data["thu_l2"];
		}
		if (isset($data["thu_khac"])) {
			$data["thu_khac"] = (float)$data["thu_khac"];
		}
		if (isset($data["thanh_toan_ngoai_le"])) {
			$data["thanh_toan_ngoai_le"] = (float)$data["thanh_toan_ngoai_le"];
		}
		if (isset($data["thanh_toan_ve_l2"])) {
			$data["thanh_toan_ve_l2"] = (float)$data["thanh_toan_ve_l2"];
		}
		if (isset($data["cac_khoan_chi_khac"])) {
			$data["cac_khoan_chi_khac"] = (float)$data["cac_khoan_chi_khac"];
		}
		if (isset($data["ndt_hop_tac"])) {
			$data["ndt_hop_tac"] = (float)$data["ndt_hop_tac"];
		}
		if (isset($data["nhan_khac"])) {
			$data["nhan_khac"] = (float)$data["nhan_khac"];
		}
		if (isset($data["priority_nd"])) {
			$data["priority_nd"] = (float)$data["priority_nd"];
		}
		if (isset($data["actual_tong_tien_vps_chua_den_han_du_kien_dao"])) {
			$data["actual_tong_tien_vps_chua_den_han_du_kien_dao"] = (float)$data["actual_tong_tien_vps_chua_den_han_du_kien_dao"];
		}
		if (isset($data["actual_thu_l2"])) {
			$data["actual_thu_l2"] = (float)$data["actual_thu_l2"];
		}
		if (isset($data["actual_thu_khac"])) {
			$data["actual_thu_khac"] = (float)$data["actual_thu_khac"];
		}
		if (isset($data["actual_thanh_toan_ngoai_le"])) {
			$data["actual_thanh_toan_ngoai_le"] = (float)$data["actual_thanh_toan_ngoai_le"];
		}
		if (isset($data["actual_thanh_toan_ve_l2"])) {
			$data["actual_thanh_toan_ve_l2"] = (float)$data["actual_thanh_toan_ve_l2"];
		}
		if (isset($data["actual_cac_khoan_chi_khac"])) {
			$data["actual_cac_khoan_chi_khac"] = (float)$data["actual_cac_khoan_chi_khac"];
		}
		if (isset($data["actual_tong_tien_vps_chua_den_han_du_kien_dao_1"])) {
			$data["actual_tong_tien_vps_chua_den_han_du_kien_dao_1"] = (float)$data["actual_tong_tien_vps_chua_den_han_du_kien_dao_1"];
		}
		if (isset($data["actual_ndt_hop_tac"])) {
			$data["actual_ndt_hop_tac"] = (float)$data["actual_ndt_hop_tac"];
		}
		if (isset($data["actual_nhan_khac"])) {
			$data["actual_nhan_khac"] = (float)$data["actual_nhan_khac"];
		}
		if (isset($data["actual_priority"])) {
			$data["actual_priority"] = (float)$data["actual_priority"];
		}

		$this->manually_enter_model->update(
			array("_id" => new MongoDB\BSON\ObjectId($id)),
			$data
		);
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Update success",
			'data' => $data
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function indexFollowDebt_post()
	{

		$month = !empty($this->dataPost['month']) ? date('m', strtotime($this->dataPost['month'])) : date('m');
		$year = !empty($this->dataPost['month']) ? date('Y', strtotime($this->dataPost['month'])) : date('Y');
		$endDayMonth = $this->lastday($month, $year);

		$data = [];
		$total_lai = 0;
		$total_phi_tu_van = 0;
		$total_phi_tham_dinh = 0;
		$total_goc = 0;
		$sum_total_plan = 0;
		$sum_actual = 0;
		$sum_diff = 0;

		//Những hd có số ngày chậm trả <10
		$arr_code_contract = [];
		$code_contract = $this->contract_model->findWhereSelect(['status' => ['$in' => list_array_trang_thai_dang_vay()],'debt.so_ngay_cham_tra' => ['$lt' => 10]], ['code_contract']);
		if (!empty($code_contract)){
			foreach ($code_contract as $value){
				array_push($arr_code_contract, $value['code_contract']);
			}
		}

		for ($i = 0; $i < $endDayMonth; $i++) {
			$day = $i + 1;
			$day = date('d', strtotime("$year-$month-$day"));

			$data[$i]['ngay_thang'] = "$day/$month/$year";

			//Lãi
			$data[$i]['lai'] = $this->temporary_plan_contract_model->sum_where_total(['ngay_ky_tra' => strtotime("$year-$month-$day"), 'code_contract' => ['$in' => $arr_code_contract]], '$lai_ky');

			//Phí tư vấn
			$data[$i]['phi_tu_van'] = $this->temporary_plan_contract_model->sum_where_total(['ngay_ky_tra' => strtotime("$year-$month-$day"), 'code_contract' => ['$in' => $arr_code_contract]], '$phi_tu_van');

			//Phí thẩm định
			$data[$i]['phi_tham_dinh'] = $this->temporary_plan_contract_model->sum_where_total(['ngay_ky_tra' => strtotime("$year-$month-$day"), 'code_contract' => ['$in' => $arr_code_contract]], '$phi_tham_dinh');

			//Gốc
			$data[$i]['goc'] = $this->temporary_plan_contract_model->sum_where_total(['ngay_ky_tra' => strtotime("$year-$month-$day"), 'code_contract' => ['$in' => $arr_code_contract]], '$tien_goc_1ky');

			//Total plan
			$data[$i]['total_plan'] = ($data[$i]['lai'] + $data[$i]['phi_tu_van'] + $data[$i]['phi_tham_dinh'] + $data[$i]['goc']) * 0.95;

			//Actual
			$condition = array(
				'$gte' => strtotime(("$year-$month-$day") . ' 00:00:00'),
				'$lte' => strtotime(("$year-$month-$day") . ' 23:59:59')
			);
			$data[$i]['actual'] = $this->total_transaction_actual($condition);

			//Diff
			$data[$i]['diff'] = $data[$i]['actual'] - $data[$i]['total_plan'];


			$total_lai += $data[$i]['lai'];
			$total_phi_tu_van += $data[$i]['phi_tu_van'];
			$total_phi_tham_dinh += $data[$i]['phi_tham_dinh'];
			$total_goc += $data[$i]['goc'];
			$sum_total_plan += $data[$i]['total_plan'];
			$sum_actual += $data[$i]['actual'];
			$sum_diff += $data[$i]['diff'];
		}


		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Update success",
			'data' => $data,
			'total_lai' => $total_lai,
			'total_phi_tu_van' => $total_phi_tu_van,
			'total_phi_tham_dinh' => $total_phi_tham_dinh,
			'total_goc' => $total_goc,
			'sum_total_plan' => $sum_total_plan,
			'sum_actual' => $sum_actual,
			'sum_diff' => $sum_diff,


		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	function total_transaction_actual($condition)
	{
		$tong_tien_thu = 0;
		$total_where = $this->transaction_model->find_where_select(['date_pay' => $condition, 'status' => 1], ['total']);
		if (!empty($total_where)) {
			foreach ($total_where as $item) {
				$tong_tien_thu += (int)$item['total'];
			}
		}
		return $tong_tien_thu;
	}

	public function indexDisbursement_post(){

		$month = !empty($this->dataPost['month']) ? date('m', strtotime($this->dataPost['month'])) : date('m');
		$year = !empty($this->dataPost['month']) ? date('Y', strtotime($this->dataPost['month'])) : date('Y');
		$endDayMonth = $this->lastday($month, $year);

		$data = [];

		$total_kh_pgd = 0;
		$total_priority = 0;

		for ($i = 0; $i < $endDayMonth; $i++) {
			$day = $i + 1;
			$day = date('d', strtotime("$year-$month-$day"));

			$data[$i]['ngay_thang'] = "$day/$month/$year";

			//Khách hàng PGD
			$condition = array(
				'$gte' => strtotime(("$year-$month-$day") . ' 00:00:00'),
				'$lte' => strtotime(("$year-$month-$day") . ' 23:59:59')
			);

			//61945bd9b5987f1710347a65 - Id Phòng của ban phê duyệt
			//6059d6a25324a742991fd6f3 - Id Phòng priority

			$data[$i]['kh_pgd'] = $this->contract_model->sum_where_total(['store.id'=> ['$nin'=> ['6059d6a25324a742991fd6f3','61945bd9b5987f1710347a65']], 'disbursement_date'=> $condition, 'loan_infor.type_property.code' => ['$in' => ['OTO','XM']] ,'code_contract_parent_cc' => array('$exists' => false),'code_contract_parent_gh' => array('$exists' => false),'status' => array('$in' => list_array_trang_thai_dang_vay_tat_toan())],array('$toLong' => '$loan_infor.amount_money'));

			//Priority + nhà đất
			$priority = $this->contract_model->sum_where_total(['store.id'=> ['$in'=> ['6059d6a25324a742991fd6f3','61945bd9b5987f1710347a65']], 'disbursement_date'=> $condition ,'code_contract_parent_cc' => array('$exists' => false),'code_contract_parent_gh' => array('$exists' => false),'status' => array('$in' => list_array_trang_thai_dang_vay_tat_toan())],array('$toLong' => '$loan_infor.amount_money'));
			$pgd_nd = $this->contract_model->sum_where_total(['store.id'=> ['$nin'=> ['6059d6a25324a742991fd6f3','61945bd9b5987f1710347a65']], 'disbursement_date'=> $condition , 'loan_infor.type_property.code' => "NĐ" ,'code_contract_parent_cc' => array('$exists' => false),'code_contract_parent_gh' => array('$exists' => false),'status' => array('$in' => list_array_trang_thai_dang_vay_tat_toan())],array('$toLong' => '$loan_infor.amount_money'));
			$data[$i]['priority'] = $priority + $pgd_nd;

			$total_kh_pgd += $data[$i]['kh_pgd'];
			$total_priority += $data[$i]['priority'];
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Update success",
			'data' => $data,
			'total_kh_pgd' => $total_kh_pgd,
			'total_priority' => $total_priority,
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function price_disbursement($year,$month,$day){
		$startDay = strtotime ('-3 day' , strtotime ("$year-$month-$day")) ;
		$startDay = date ( 'Y-m-d' , $startDay );
		$endDay = strtotime ('-1 day' , strtotime ("$year-$month-$day")) ;
		$endDay = date ( 'Y-m-d' , $endDay );
		$condition = array(
			'$gte' => strtotime(($startDay) . ' 00:00:00'),
			'$lte' => strtotime(($endDay) . ' 23:59:59')
		);
		$price = $this->contract_model->sum_where_total(['store.id'=> ['$nin'=> ['6059d6a25324a742991fd6f3','61945bd9b5987f1710347a65']], 'disbursement_date'=> $condition, 'loan_infor.type_property.code' => ['$in' => ['OTO','XM']] ,'code_contract_parent_cc' => array('$exists' => false),'code_contract_parent_gh' => array('$exists' => false),'status' => array('$in' => list_array_trang_thai_dang_vay_tat_toan())],array('$toLong' => '$loan_infor.amount_money'));
		return $price/3;
	}

	public function importHistorical_post(){

		$data = $this->input->post();
		$data['created_at'] = $this->createdAt;
		$data['created_by'] = $this->uemail;
		$data['status'] = 1;
		if (!empty($data['gia_dinh_thanh_toan'])) {
			$data['gia_dinh_thanh_toan'] = (int)$data['gia_dinh_thanh_toan'];
		}
		if (!empty($data['actual'])) {
			$data['actual'] = (int)$data['actual'];
		}


		$year = $data['year'];
		$month = $data['month'];

		if (!empty($data['dot'])){
			if ($data['dot'] == 1){
				$day = '05';
				$check_weekday = date('l', strtotime("$year-$month-$day"));
				if ($check_weekday != "Sunday"){
					$data['day'] = "05";
				} else {
					$data['day'] = "06";
				}
			} elseif ($data['dot'] == 2){
				$day = '15';
				$check_weekday = date('l', strtotime("$year-$month-$day"));
				if ($check_weekday != "Sunday"){
					$data['day'] = "15";
				} else {
					$data['day'] = "16";
				}
			} elseif ($data['dot'] == 3){
				$day = '20';
				$check_weekday = date('l', strtotime("$year-$month-$day"));
				if ($check_weekday != "Sunday"){
					$data['day'] = "20";
				} else {
					$data['day'] = "21";
				}
			} elseif ($data['dot'] == 4){
				$day = '25';
				$check_weekday = date('l', strtotime("$year-$month-$day"));
				if ($check_weekday != "Sunday"){
					$data['day'] = "25";
				} else {
					$data['day'] = "26";
				}
			} elseif ($data['dot'] == 5){
				$data['day'] = $this->lastday($data['month'], $data['year']);
			}
		}

		$this->import_historical_model->insert($data);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Success",
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function getHistorical_post(){

		$month = !empty($this->dataPost['month']) ? date('m', strtotime($this->dataPost['month'])) : date('m');
		$year = !empty($this->dataPost['month']) ? date('Y', strtotime($this->dataPost['month'])) : date('Y');

		$data = $this->import_historical_model->find_where(['year' => $year, 'month' => $month, 'status' => 1]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Success",
			'data' => $data
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function indexCpWork_post(){

		$month = !empty($this->dataPost['month']) ? date('m', strtotime($this->dataPost['month'])) : date('m');
		$year = !empty($this->dataPost['month']) ? date('Y', strtotime($this->dataPost['month'])) : date('Y');

		//Đợt 1
		$data_1 = $this->import_historical_model->find_where(['year' => $year, 'month' => $month, 'dot' => "1", 'status' => 1]);

		//Đợt 2
		$data_2 = $this->import_historical_model->find_where(['year' => $year, 'month' => $month, 'dot' => "2", 'status' => 1]);

		//Đợt 3
		$data_3 = $this->import_historical_model->find_where(['year' => $year, 'month' => $month, 'dot' => "3", 'status' => 1]);

		//Đợt 4
		$data_4 = $this->import_historical_model->find_where(['year' => $year, 'month' => $month, 'dot' => "4", 'status' => 1]);

		//Đợt 5
		$data_5 = $this->import_historical_model->find_where(['year' => $year, 'month' => $month, 'dot' => "5", 'status' => 1]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Success",
			'data_1' => $data_1,
			'data_2' => $data_2,
			'data_3' => $data_3,
			'data_4' => $data_4,
			'data_5' => $data_5,
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;


	}

	public function callApiInvest($data, $url){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->config->item('URL_NDT').$url,
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

	public function get_ratio_post(){

		$data = $this->investor_deposit_rate_model->find();

		if(empty($data)){
			return;
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Success",
			'data' => $data,
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function update_ratio_post(){

		$data = $this->input->post();
		$data['updated_at'] = $this->createdAt;

		$this->investor_deposit_rate_model->update(['_id' => new \MongoDB\BSON\ObjectId($data['id'])],$data);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Success",
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}




}

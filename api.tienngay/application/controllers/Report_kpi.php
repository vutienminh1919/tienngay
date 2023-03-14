<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
require_once APPPATH . 'libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Report_kpi extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('report_kpi_model');
		$this->load->model('kpi_area_model');
		$this->load->model('report_kpi_user_model');
		$this->load->model('report_kpi_user_model');
		$this->load->model('report_kpi_top_user_model');
		$this->load->model('report_kpi_top_pgd_model');
		$this->load->model('store_model');
		$this->load->model('log_model');
		$this->load->model('role_model');
		$this->load->helper('lead_helper');
		$this->load->model('group_role_model');
		$this->load->model("contract_model");
		$this->load->model("lead_model");
		$this->load->model("area_model");
		$this->load->model("report_kpi_commission_pgd_model");
		$this->load->model("report_kpi_commission_user_model");
		$this->load->model("vbi_sxh_model");
		$this->load->model("vbi_tnds_model");
		$this->load->model("vbi_utv_model");
		$this->load->model("pti_vta_bn_model");
		$this->load->model("mic_tnds_model");
		$this->load->model("gic_plt_bn_model");
		$this->load->model("contract_tnds_model");
		$this->load->model("vbi_model");
		$this->load->model("gic_easy_model");
		$this->load->model("user_model");
		$this->load->model("kpi_gdv_model");
		$this->load->model("kpi_pgd_model");
		$this->load->model("kpi_area_model");
		$this->load->model("debt_user_model");
		$this->load->model("debt_store_model");
		$this->load->model("gic_easy_bn_model");
		$this->load->model("gic_plt_model");
		$this->load->model("debt_du_no_model");
		$this->load->model("insurance_model");
		$this->load->model("view_report_debt_model");
		$this->load->model("view_report_debt_bds_model");
		$this->load->model("transaction_model");
		$this->load->model("warehouse_asset_location_model");

		$this->createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		$headers = $this->input->request_headers();
		$dataPost = $this->input->post();
		$this->flag_login = 1;
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
				if ($dataPost['type'] == 1) $this->app_login['token_web'] = $headers_item;
				if ($dataPost['type'] == 2) $this->app_login['token_app'] = $headers_item;
				$count_account = $this->user_model->count($this->app_login);
				$this->flag_login = 'success';
				if ($count_account != 1) $this->flag_login = 2;
				if ($count_account == 1) {
					$this->info = $this->user_model->findOne($this->app_login);
					$this->id = $this->info['_id'];
					// $this->ulang = $this->info['lang'];
					$this->uemail = $this->info['email'];
					$this->user_phone = $this->info['phone_number'];
				}
			}
		}
		unset($this->dataPost['type']);

	}

	private $createdAt, $flag_login, $id, $uemail, $ulang, $app_login, $dataPost, $roleAccessRights, $info;

	public function get_detail_kpi_pgd_post()
	{
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;
		$this->dataPost = $this->input->post()['condition'];
		$condition = !empty($this->dataPost['condition']) ? $this->dataPost['condition'] : array();
		$customer_email = !empty($this->dataPost['customer_email']) ? $this->dataPost['customer_email'] : "";
		$code_store = !empty($this->dataPost['code_store']) ? $this->dataPost['code_store'] : "";

		$start = !empty($this->dataPost['start']) ? $this->dataPost['start'] : "";
		$end = !empty($this->dataPost['end']) ? $this->dataPost['end'] : "";
		$code_area = !empty($this->dataPost['code_area']) ? $this->dataPost['code_area'] : "";
		$code_region = !empty($this->dataPost['code_region']) ? $this->dataPost['code_region'] : "";
		$code_domain = !empty($this->dataPost['code_domain']) ? $this->dataPost['code_domain'] : "";
		$condition_sum = array();

		$month = date('m', strtotime($start));
		$year = date('Y', strtotime($start));
		if (!empty($start)) {
			$condition = array(
				'month' => $month,
				'year' => $year
			);
			$condition_sum['month'] = $month;
			$condition_sum['year'] = $year;
		}


		$stores = array();

		$stores = $this->getStores($this->id);
		if (empty($stores)) {

		} else {
			$condition['code_store'] = $stores;
			$condition_sum['store.id'] = array('$in' => $stores);
		}

		if (!empty($code_store)) {
			$condition['code_store'] = (is_array($code_store)) ? $code_store : [$code_store];
			$condition_sum['store.id'] = array('$in' => $code_store);
		}
		if (!empty($code_area)) {
			$condition['code_area'] = (is_array($code_area)) ? $code_area : [$code_area];
			$condition_sum['code_area'] = array('$in' => $code_area);
		}
		if (!empty($code_region)) {
			$condition['code_region'] = (is_array($code_region)) ? $code_region : [$code_region];
			$condition_sum['code_region'] = array('$in' => $code_region);
		}
		if (!empty($code_domain)) {
			$condition['code_domain'] = (is_array($code_domain)) ? $code_domain : [$code_domain];
			$condition_sum['code_domain'] = array('$in' => $code_domain);
		}


		if (!empty($customer_email)) {
			$condition['customer_email'] = $customer_email;
			$condition_sum['customer_email'] = $customer_email;
		}

		$per_page = !empty($this->input->post()['per_page']) ? $this->input->post()['per_page'] : 30;
		$uriSegment = !empty($this->input->post()['uriSegment']) ? $this->input->post()['uriSegment'] : 0;

		$contract = array();

		$contract = $this->report_kpi_model->getKpiByTime(array(), $condition, $per_page, $uriSegment);
		$condition['total'] = 1;
		$total = $this->report_kpi_model->getKpiByTime(array(), $condition);
		$arr_sum = array(
			'sum_giai_ngan' => $this->report_kpi_model->sum_where($condition_sum, '$sum_giai_ngan'),
			'sum_bao_hiem' => $this->report_kpi_model->sum_where($condition_sum, '$sum_bao_hiem'),
			'count_khach_hang_moi' => $this->report_kpi_model->sum_where($condition_sum, '$count_khach_hang_moi'),
		);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $contract,
			'total' => $total,
			'sum' => $arr_sum
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function get_detail_kpi_user_post()
	{
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;
		$this->dataPost = $this->input->post()['condition'];
		$condition = !empty($this->dataPost['condition']) ? $this->dataPost['condition'] : array();
		$customer_email = !empty($this->dataPost['customer_email']) ? $this->dataPost['customer_email'] : "";
		$code_store = !empty($this->dataPost['code_store']) ? $this->dataPost['code_store'] : "";

		$start = !empty($this->dataPost['start']) ? $this->dataPost['start'] : "";
		$end = !empty($this->dataPost['end']) ? $this->dataPost['end'] : "";
		$code_area = !empty($this->dataPost['code_area']) ? $this->dataPost['code_area'] : "";
		$code_region = !empty($this->dataPost['code_region']) ? $this->dataPost['code_region'] : "";
		$code_domain = !empty($this->dataPost['code_domain']) ? $this->dataPost['code_domain'] : "";
		$condition_sum = array();
		$month = date('m', strtotime($start));
		$year = date('Y', strtotime($start));
		if (!empty($start)) {
			$condition = array(
				'month' => $month,
				'year' => $year
			);
			$condition_sum['month'] = $month;
			$condition_sum['year'] = $year;
		}


		$stores = array();

		$stores = $this->getStores($this->id);
		if (empty($stores)) {

		} else {
			$condition['code_store'] = $stores;
			$condition_sum['store.id'] = array('$in' => $stores);
		}

		if (!empty($code_store)) {
			$condition['code_store'] = (is_array($code_store)) ? $code_store : [$code_store];
			$condition_sum['store.id'] = array('$in' => $code_store);
		}
		if (!empty($code_area)) {
			$condition['code_area'] = (is_array($code_area)) ? $code_area : [$code_area];
			$condition_sum['code_area'] = array('$in' => $code_area);
		}
		if (!empty($code_region)) {
			$condition['code_region'] = (is_array($code_region)) ? $code_region : [$code_region];
			$condition_sum['code_region'] = array('$in' => $code_region);
		}
		if (!empty($code_domain)) {
			$condition['code_domain'] = (is_array($code_domain)) ? $code_domain : [$code_domain];
			$condition_sum['code_domain'] = array('$in' => $code_domain);
		}


		if (!empty($customer_email)) {
			$condition['customer_email'] = $customer_email;
			$condition_sum['customer_email'] = $customer_email;
		}

		$per_page = !empty($this->input->post()['per_page']) ? $this->input->post()['per_page'] : 30;
		$uriSegment = !empty($this->input->post()['uriSegment']) ? $this->input->post()['uriSegment'] : 0;

		$contract = array();

		$contract = $this->report_kpi_user_model->getKpiByTime(array(), $condition, $per_page, $uriSegment);
		$condition['total'] = 1;
		$total = $this->report_kpi_user_model->getKpiByTime(array(), $condition);
		$arr_sum = array(
			'sum_giai_ngan' => $this->report_kpi_user_model->sum_where($condition_sum, '$sum_giai_ngan'),
			'sum_bao_hiem' => $this->report_kpi_user_model->sum_where($condition_sum, '$sum_bao_hiem'),
			'count_khach_hang_moi' => $this->report_kpi_user_model->sum_where($condition_sum, '$count_khach_hang_moi'),
		);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $contract,
			'total' => $total,
			'sum' => $arr_sum
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function get_detail_kpi_user_v2_post()
	{
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;
		$this->dataPost = $this->input->post()['condition'];
		$condition = !empty($this->dataPost['condition']) ? $this->dataPost['condition'] : array();
		$customer_email = !empty($this->dataPost['customer_email']) ? $this->dataPost['customer_email'] : "";
		$code_store = !empty($this->dataPost['code_store']) ? $this->dataPost['code_store'] : "";

		$start = !empty($this->dataPost['start']) ? $this->dataPost['start'] : "";
		$end = !empty($this->dataPost['end']) ? $this->dataPost['end'] : "";
		$code_area = !empty($this->dataPost['code_area']) ? $this->dataPost['code_area'] : "";
		$code_region = !empty($this->dataPost['code_region']) ? $this->dataPost['code_region'] : "";
		$code_domain = !empty($this->dataPost['code_domain']) ? $this->dataPost['code_domain'] : "";
		$condition_sum = array();
		$month = date('m', strtotime($start));
		$year = date('Y', strtotime($start));
		if (!empty($start)) {
			$condition = array(
				'month' => $month,
				'year' => $year
			);
			$condition_sum['month'] = $month;
			$condition_sum['year'] = $year;
		}


		$stores = array();

		$stores = $this->getStores($this->id);
		if (empty($stores)) {

		} else {
			$condition['code_store'] = $stores;
			$condition_sum['store.id'] = array('$in' => $stores);
		}

		if (!empty($code_store)) {
			$condition['code_store'] = (is_array($code_store)) ? $code_store : [$code_store];
			$condition_sum['store.id'] = array('$in' => [$code_store]);
		}
		if (!empty($code_area)) {
			$condition['code_area'] = (is_array($code_area)) ? $code_area : [$code_area];
			$condition_sum['code_area'] = array('$in' => $code_area);
		}
		if (!empty($code_region)) {
			$condition['code_region'] = (is_array($code_region)) ? $code_region : [$code_region];
			$condition_sum['code_region'] = array('$in' => $code_region);
		}
		if (!empty($code_domain)) {
			$condition['code_domain'] = (is_array($code_domain)) ? $code_domain : [$code_domain];
			$condition_sum['code_domain'] = array('$in' => $code_domain);
		}


		if (!empty($customer_email)) {
			$condition['customer_email'] = $customer_email;
			$condition_sum['customer_email'] = $customer_email;
		}

		$per_page = !empty($this->input->post()['per_page']) ? $this->input->post()['per_page'] : 30;
		$uriSegment = !empty($this->input->post()['uriSegment']) ? $this->input->post()['uriSegment'] : 0;

		$contract = array();

		$contract = $this->report_kpi_user_model->getKpiByTime(array(), $condition, $per_page, $uriSegment);

		$condition['total'] = 1;
		$total = $this->report_kpi_user_model->getKpiByTime(array(), $condition);

		$arr_sum = array(
			'sum_giai_ngan' => $this->report_kpi_user_model->sum_where($condition_sum, '$sum_giai_ngan'),
			'sum_bao_hiem' => $this->report_kpi_user_model->sum_where($condition_sum, '$sum_bao_hiem'),
			'count_khach_hang_moi' => $this->report_kpi_user_model->sum_where($condition_sum, '$count_khach_hang_moi'),
		);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $contract,
			'total' => $total,
			'sum' => $arr_sum
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function get_detail_daily_pgd_post()
	{
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;
		$this->dataPost = $this->input->post()['condition'];
		$condition = !empty($this->dataPost['condition']) ? $this->dataPost['condition'] : array();
		$customer_email = !empty($this->dataPost['customer_email']) ? $this->dataPost['customer_email'] : "";
		$code_store = !empty($this->dataPost['code_store']) ? $this->dataPost['code_store'] : "";

		$start = !empty($this->dataPost['start']) ? $this->dataPost['start'] : "";
		$end = !empty($this->dataPost['end']) ? $this->dataPost['end'] : "";
		$code_area = !empty($this->dataPost['code_area']) ? $this->dataPost['code_area'] : "";
		$code_region = !empty($this->dataPost['code_region']) ? $this->dataPost['code_region'] : "";
		$code_domain = !empty($this->dataPost['code_domain']) ? $this->dataPost['code_domain'] : "";
		$condition_sum = array();

		if (!empty($start) && !empty($end)) {
			$condition = array(
				'start' => strtotime(trim($start) . ' 00:00:00'),
				'end' => strtotime(trim($end) . ' 23:59:59')
			);
			$condition_sum['date'] = array(
				'$gte' => $condition['start'],
				'$lte' => $condition['end']
			);
		}


		$stores = array();

		$stores = $this->getStores($this->id);
		if (empty($stores)) {

		} else {
			$condition['code_store'] = $stores;
			$condition_sum['store.id'] = array('$in' => $stores);
		}

		if (!empty($code_store)) {
			$condition['code_store'] = (is_array($code_store)) ? $code_store : [$code_store];
			$condition_sum['store.id'] = array('$in' => $code_store);
		}
		if (!empty($code_area)) {
			$condition['code_area'] = (is_array($code_area)) ? $code_area : [$code_area];
			$condition_sum['code_area'] = array('$in' => $code_area);
		}
		if (!empty($code_region)) {
			$condition['code_region'] = (is_array($code_region)) ? $code_region : [$code_region];
			$condition_sum['code_region'] = array('$in' => $code_region);
		}
		if (!empty($code_domain)) {
			$condition['code_domain'] = (is_array($code_domain)) ? $code_domain : [$code_domain];
			$condition_sum['code_domain'] = array('$in' => $code_domain);
		}


		if (!empty($customer_email)) {
			$condition['customer_email'] = $customer_email;
			$condition_sum['customer_email'] = $customer_email;
		}

		$per_page = !empty($this->input->post()['per_page']) ? $this->input->post()['per_page'] : 30;
		$uriSegment = !empty($this->input->post()['uriSegment']) ? $this->input->post()['uriSegment'] : 0;

		$contract = array();

		$contract = $this->report_kpi_top_pgd_model->getKpiByTime(array(), $condition, $per_page, $uriSegment);
		$condition['total'] = 1;
		$total = $this->report_kpi_top_pgd_model->getKpiByTime(array(), $condition);
		$arr_sum = array(
			'sum_giai_ngan' => $this->report_kpi_top_pgd_model->sum_where($condition_sum, '$sum_giai_ngan'),
			'sum_bao_hiem' => $this->report_kpi_top_pgd_model->sum_where($condition_sum, '$sum_bao_hiem'),
			'count_khach_hang_moi' => $this->report_kpi_top_pgd_model->sum_where($condition_sum, '$count_khach_hang_moi'),
		);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $contract,
			'total' => $total,
			'sum' => $arr_sum
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function get_detail_daily_user_post()
	{
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;
		$this->dataPost = $this->input->post()['condition'];
		$condition = !empty($this->dataPost['condition']) ? $this->dataPost['condition'] : array();
		$customer_email = !empty($this->dataPost['customer_email']) ? $this->dataPost['customer_email'] : "";
		$code_store = !empty($this->dataPost['code_store']) ? $this->dataPost['code_store'] : "";

		$start = !empty($this->dataPost['start']) ? $this->dataPost['start'] : "";
		$end = !empty($this->dataPost['end']) ? $this->dataPost['end'] : "";
		$code_area = !empty($this->dataPost['code_area']) ? $this->dataPost['code_area'] : "";
		$code_region = !empty($this->dataPost['code_region']) ? $this->dataPost['code_region'] : "";
		$code_domain = !empty($this->dataPost['code_domain']) ? $this->dataPost['code_domain'] : "";
		$condition_sum = array();

		if (!empty($start) && !empty($end)) {
			$condition = array(
				'start' => strtotime(trim($start) . ' 00:00:00'),
				'end' => strtotime(trim($end) . ' 23:59:59')
			);
			$condition_sum['date'] = array(
				'$gte' => $condition['start'],
				'$lte' => $condition['end']
			);
		}


		$stores = array();

		$stores = $this->getStores($this->id);
		if (empty($stores)) {

		} else {
			$condition['code_store'] = $stores;
			$condition_sum['store.id'] = array('$in' => $stores);
		}

		if (!empty($code_store)) {
			$condition['code_store'] = (is_array($code_store)) ? $code_store : [$code_store];
			$condition_sum['store.id'] = array('$in' => $code_store);
		}
		if (!empty($code_area)) {
			$condition['code_area'] = (is_array($code_area)) ? $code_area : [$code_area];
			$condition_sum['code_area'] = array('$in' => $code_area);
		}
		if (!empty($code_region)) {
			$condition['code_region'] = (is_array($code_region)) ? $code_region : [$code_region];
			$condition_sum['code_region'] = array('$in' => $code_region);
		}
		if (!empty($code_domain)) {
			$condition['code_domain'] = (is_array($code_domain)) ? $code_domain : [$code_domain];
			$condition_sum['code_domain'] = array('$in' => $code_domain);
		}


		if (!empty($customer_email)) {
			$condition['customer_email'] = $customer_email;
			$condition_sum['customer_email'] = $customer_email;
		}

		$per_page = !empty($this->input->post()['per_page']) ? $this->input->post()['per_page'] : 30;
		$uriSegment = !empty($this->input->post()['uriSegment']) ? $this->input->post()['uriSegment'] : 0;

		$contract = array();

		$contract = $this->report_kpi_user_model->getKpiByTime(array(), $condition, $per_page, $uriSegment);
		$condition['total'] = 1;
		$total = $this->report_kpi_user_model->getKpiByTime(array(), $condition);
		$arr_sum = array(
			'sum_giai_ngan' => $this->report_kpi_user_model->sum_where($condition_sum, '$sum_giai_ngan'),
			'sum_bao_hiem' => $this->report_kpi_user_model->sum_where($condition_sum, '$sum_bao_hiem'),
			'count_khach_hang_moi' => $this->report_kpi_user_model->sum_where($condition_sum, '$count_khach_hang_moi'),
		);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $contract,
			'total' => $total,
			'sum' => $arr_sum
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function kpi_domain_post()
	{
		$flag = notify_token($this->flag_login);
		if ($flag == false) return;
		$data = $this->input->post();
		$start_old = '2019-11-01';
		$start = !empty($data['start']) ? $data['start'] : date('Y-m-01');
		$end = !empty($data['end']) ? $data['end'] : date('2030-m-d');
		$condition = array();
		$condition_lead = array();

		if (!empty($start) && !empty($end)) {
			$condition_old = array(
				'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);
			$condition_lead = array(
				'$gte' => strtotime(trim($start) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);
			$condition_search_old = array(
				'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
				'$lte' => strtotime(trim(date('Y-m-d')) . ' 23:59:59')
			);

			//Dư nợ quá hạn T+10 tháng trước
			$date = getdate();

			$month_thang_nay = $date['mon'] - 1;
			$month_thang_truoc = $date['mon'] - 1;
			$year = $date['year'];
			if ($date['mon'] == 1) {
				$month_thang_nay = 12;
				$month_thang_truoc = 12;
				$year = $date['year'] - 1;
			}

			$start_thang_truoc = !empty($month_thang_truoc) ? date("$year-$month_thang_truoc-01") : date('Y-m-01');
			$end_thang_truoc = !empty($month_thang_truoc) ? date("$year-$month_thang_truoc-t") : date('Y-m-d');


			$condition_thang_truoc = array(
				'$gte' => strtotime(trim($start_thang_truoc) . ' 00:00:00'),
				'$lte' => strtotime(trim($end_thang_truoc) . ' 23:59:59')
			);

		}
		$year = date('Y');
		$groupRoles = $this->getGroupRole($this->id);
		$stores = $this->getStores_list($this->id);

		//   $stores =array();
		if (in_array('giao-dich-vien', $groupRoles) && !in_array('cua-hang-truong', $groupRoles)) {

			$created_by = $this->uemail;
			$condition['created_by'] = $created_by;

			$phone_user = $this->getPhoneUser($this->id);

		} else {
			if (empty($stores)) {
				$storeData = $this->store_model->find_where_in('status', ['active']);

				if (!empty($storeData)) {

					foreach ($storeData as $key => $item) {
						array_push($stores, (string)$item['_id']);
					}
				}
				$condition['store.id'] = array('$in' => $stores);
			} else {
				$condition['store.id'] = array('$in' => $stores);
			}

			$phone_user = $this->getPhoneStore($stores);


		}

		$rk = new Report_kpi_model();
		$rku = new Report_kpi_user_model();
		$rktu = new Report_kpi_top_user_model();
		$rktp = new Report_kpi_top_pgd_model();
		$kpi_area = new Kpi_area_model();
		$area = new Area_model();
		$contract = new Contract_model();
		$rkcpm = new Report_kpi_commission_pgd_model();
		$rkcum = new Report_kpi_commission_user_model();
		$debt_user = new Debt_user_model();
		$debt_store = new Debt_store_model();
		$debt_du_no = new Debt_du_no_model();

		$arr_area = array();
		$data_report = array();
		$data_report['total_so_tien_vay'] = 0;
		$data_report['total_du_no_qua_han'] = 0;
		$data_report['total_du_no_dang_cho_vay'] = 0;


		//v2
		$data_report['total_du_no_trong_han_t10_old'] = $contract->sum_where_total(['loan_infor.type_property.code' => ['$nin' => ['NĐ']], 'status' => array('$in' => list_array_trang_thai_dang_vay()), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false), 'created_by' => $created_by], '$debt.tong_tien_goc_con');
		$data_report['total_du_no_trong_han_t10_thang_truoc'] = $debt_user->sum_where_total(['user' => $created_by, 'created_at' => $condition_thang_truoc], '$total_du_no_trong_han_t10_old');

		$data_report['total_doanh_so_bao_hiem'] = $rkcum->sum_where_total(['san_pham' => 'BH', 'created_at' => $condition_lead, 'user' => $created_by], '$commision.doanh_so');
		$data_report['total_tien_hoa_hong_bao_hiem'] = $rkcum->sum_where_total(['created_at' => $condition_lead, 'san_pham' => 'BH' ,'user' => $created_by], '$commision.tien_hoa_hong');

		$data_report['total_du_no_trong_han_t10'] = $data_report['total_du_no_trong_han_t10_old'] - $data_report['total_du_no_trong_han_t10_thang_truoc'];


		if (in_array('giao-dich-vien', $groupRoles) && !in_array('cua-hang-truong', $groupRoles)) {

			//Hoa hồng nhà đầu tư
			$total_nha_dau_tu = $this->callApiInvest(['year' => date('Y'), 'month' => date('m'), 'phone' => $phone_user], '/commission_cvkd');
			if($total_nha_dau_tu->status == 200 && !empty($total_nha_dau_tu)){
				$data_report['tien_hoa_hong_nha_dau_tu']  = $total_nha_dau_tu->data->total->money_commission_number;
				$data_report['total_nha_dau_tu'] = $total_nha_dau_tu->data->total->total_money_number;
			}

			$data_report['total_tien_hoa_hong'] = $rkcum->sum_where_total(['created_at' => $condition_lead, 'san_pham' => 'HDV' ,'user' => $created_by], '$commision.tien_hoa_hong');


			$data_report['total_so_tien_vay'] = $contract->sum_where_total(['created_by' => $created_by, 'disbursement_date' => $condition_lead, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 37, 38, 39, 41, 42, 19, 33, 34])], array('$toLong' => '$loan_infor.amount_money'));
			$data_report['total_so_tien_vay_old'] = $contract->sum_where_total(['status' => array('$in' => [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 37, 38, 39, 41, 42, 19]), 'disbursement_date' => $condition_search_old, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'created_by' => $created_by], array('$toLong' => '$loan_infor.amount_money'));
			$data_report['total_du_no_dang_cho_vay_old'] = $contract->sum_where_total(['disbursement_date' => $condition_old, 'status' => array('$in' => list_array_trang_thai_dang_vay()), 'tat_toan_gh' => array('$exists' => false), 'created_by' => $created_by], '$debt.tong_tien_goc_con');

			$data_report['total_du_no_dang_cho_vay'] = $contract->sum_where_total(['created_by' => $created_by, 'disbursement_date' => $condition_lead, 'status' => array('$in' => list_array_trang_thai_dang_vay()), 'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');

			$data_report['contract_moi'] = $rktu->sum_where(['store.id' => array('$in' => $stores), 'date' => $condition_lead, 'user' => $created_by], '$contract_moi');
			$data_report['contract_dang_xl'] = $rktu->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores), 'user' => $created_by], '$contract_dang_xl');
			$data_report['contract_cho_cd'] = $rktu->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores), 'user' => $created_by], '$contract_cho_cd');
			$data_report['contract_da_duyet'] = $rktu->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores), 'user' => $created_by], '$contract_da_duyet');
			$data_report['contract_cho_gn'] = $rktu->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores), 'user' => $created_by], '$contract_cho_gn');
			$data_report['contract_da_gn'] = $rktu->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores), 'user' => $created_by], '$contract_da_gn');
			$data_report['contract_khac'] = $rktu->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores), 'user' => $created_by], '$contract_khac');
			$data_report['contract_total'] = $rktu->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores), 'user' => $created_by], '$contract_total');

			$data_report['total_giai_ngan_chi_tieu_ti_trong'] = $this->price_disbursement_gdv($created_by, $start, $condition_lead);

		} else {
			$data_report['total_so_tien_vay_old'] = $contract->sum_where_total(['store.id' => array('$in' => $stores), 'disbursement_date' => $condition_search_old, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 37, 38, 39, 41, 42, 19])], array('$toLong' => '$loan_infor.amount_money'));

			//V2

			$data_report['total_du_no_trong_han_t10_old'] = $contract->sum_where_total(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'store.id' => array('$in' => $stores), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');
			$data_report['total_du_no_trong_han_t10_thang_truoc'] = $debt_store->sum_where_total(['store.id' => array('$in' => $stores), 'created_at' => $condition_thang_truoc], '$total_du_no_trong_han_t10_old');


			$data_report['total_doanh_so_bao_hiem'] = $rkcpm->sum_where_total(['store.id' => array('$in' => $stores), 'san_pham' => 'BH', 'created_at' => $condition_lead], '$commision.doanh_so');

			//Hoa hồng nhà đầu tư
			$total_nha_dau_tu = $this->callApiInvest(['year' => date('Y'), 'month' => date('m'), 'phone' => $phone_user], '/commission_group_cvkd');
			if($total_nha_dau_tu->status == 200 && !empty($total_nha_dau_tu)){
				$data_report['total_nha_dau_tu'] = $total_nha_dau_tu->data->total;

			}
			$total_nha_dau_tu = $this->callApiInvest(['year' => date('Y'), 'month' => date('m'), 'phone' => $this->user_phone], '/commission_cvkd');
			if($total_nha_dau_tu->status == 200 && !empty($total_nha_dau_tu)){
				$data_report['tien_hoa_hong_nha_dau_tu'] = $total_nha_dau_tu->data->total->money_commission_number;
			}

			//Tiền hoa hồng PGD
			$tong_tien_hoa_hong_ca_nhan = $rkcum->sum_where_total(['created_at' => $condition_lead ,'user' => $this->uemail], '$commision.tien_hoa_hong');
			$tong_tien_hoa_hong_huong_nv = $rkcpm->sum_where_total(['created_at' => $condition_lead, 'san_pham' => 'HDV','store.id' => array('$in' => $stores)], '$commision.tien_hoa_hong');
			$data_report['total_tien_hoa_hong'] = $tong_tien_hoa_hong_ca_nhan + $tong_tien_hoa_hong_huong_nv;

			$data_report['total_du_no_trong_han_t10'] = $data_report['total_du_no_trong_han_t10_old'] - $data_report['total_du_no_trong_han_t10_thang_truoc'];

			//
			$data_report['total_du_no_dang_cho_vay_old'] = $contract->sum_where_total(['store.id' => array('$in' => $stores), 'disbursement_date' => $condition_old, 'status' => array('$in' => list_array_trang_thai_dang_vay()), 'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');

			$data_report['total_so_tien_vay'] = $contract->sum_where_total(['store.id' => array('$in' => $stores), 'disbursement_date' => $condition_lead, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 37, 38, 39, 41, 42, 19, 33, 34])], array('$toLong' => '$loan_infor.amount_money'));

			$data_report['total_du_no_dang_cho_vay_thang_truoc'] = $debt_du_no->sum_where_total(['created_at' => $condition_thang_truoc], '$total_du_no_trong_han_t10_old');
			$data_report['du_no_tang_net'] = $data_report['total_du_no_dang_cho_vay_old'] - $data_report['total_du_no_dang_cho_vay_thang_truoc'];
			// var_dump($stores); die;

			$data_report['total_du_no_dang_cho_vay'] = $contract->sum_where_total(['store.id' => array('$in' => $stores), 'disbursement_date' => $condition_lead, 'status' => array('$in' => list_array_trang_thai_dang_vay()), 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');


			$data_report['contract_moi'] = $rktp->sum_where(['store.id' => array('$in' => $stores), 'date' => $condition_lead], '$contract_moi');

			$data_report['contract_dang_xl'] = $rktp->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores)], '$contract_dang_xl');
			$data_report['contract_cho_cd'] = $rktp->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores)], '$contract_cho_cd');
			$data_report['contract_da_duyet'] = $rktp->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores)], '$contract_da_duyet');
			$data_report['contract_cho_gn'] = $rktp->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores)], '$contract_cho_gn');
			$data_report['contract_da_gn'] = $rktp->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores)], '$contract_da_gn');
			$data_report['contract_khac'] = $rktp->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores)], '$contract_khac');
			$data_report['contract_total'] = $rktp->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores)], '$contract_total');

			$data_report['total_giai_ngan_chi_tieu_ti_trong'] = $this->price_disbursement_pgd($stores, $start, $condition_lead);
		}
		if (in_array('giao-dich-vien', $groupRoles) && !in_array('cua-hang-truong', $groupRoles)) {

			$arr_month = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
			foreach ($arr_month as $key => $month) {
				$report_kpiData = $rku->find_where(['month' => $month, 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'user_email' => $created_by]);
				if (!empty($report_kpiData)) {
					foreach ($report_kpiData as $report_kpi) {
						$data_report['kpi_bao_hiem'] += $report_kpi['sum_bao_hiem'];
						$data_report['kpi_kh_moi'] += $report_kpi['count_khach_hang_moi'];
						$data_report['kpi_giai_ngan'] += $report_kpi['sum_giai_ngan'];
						$data_report['tong_chi_tieu'] += $report_kpi['sum_giai_ngan'] + $report_kpi['count_khach_hang_moi'] + $report_kpi['sum_bao_hiem'];
						if (!empty($report_kpi['kpi'])) {
							$giai_ngan_CT = (isset($report_kpi['kpi']['giai_ngan_CT'])) ? $report_kpi['kpi']['giai_ngan_CT'] : 0;
							$bao_hiem_CT = (isset($report_kpi['kpi']['bao_hiem_CT'])) ? $report_kpi['kpi']['bao_hiem_CT'] : 0;
							$du_no_CT = (isset($report_kpi['kpi']['du_no_CT'])) ? $report_kpi['kpi']['du_no_CT'] : 0;
							$giai_ngan_TT = (isset($report_kpi['kpi']['giai_ngan_TT'])) ? $report_kpi['kpi']['giai_ngan_TT'] : 0;
							$bao_hiem_TT = (isset($report_kpi['kpi']['bao_hiem_TT'])) ? $report_kpi['kpi']['bao_hiem_TT'] : 0;
							$du_no_TT = (isset($report_kpi['kpi']['du_no_TT'])) ? $report_kpi['kpi']['du_no_TT'] : 0;

							$nha_dau_tu_CT = (isset($report_kpi['kpi']['nha_dau_tu'])) ? $report_kpi['kpi']['nha_dau_tu'] : 0;
							$nha_dau_tu_TT = (isset($report_kpi['kpi']['nha_dau_tu_TT'])) ? $report_kpi['kpi']['nha_dau_tu_TT'] : 0;
						}
						$sum_bao_hiem += (isset($report_kpi['sum_bao_hiem'])) ? $report_kpi['sum_bao_hiem'] : 0;
						$count_khach_hang_moi = (isset($report_kpi['count_khach_hang_moi'])) ? $report_kpi['count_khach_hang_moi'] : 0;
						$sum_giai_ngan += (isset($report_kpi['sum_giai_ngan'])) ? $report_kpi['sum_giai_ngan'] : 0;

						if (in_array('giao-dich-vien', $groupRoles) && !in_array('cua-hang-truong', $groupRoles)) {
							$data_report['data_labels'] = '"' . $report_kpi['user_email'] . '",';
						}
					}

					$data_report['data_kpichitieu_dsGiaiNgan'] .= $giai_ngan_CT . ',';
					$data_report['data_kpichitieu_dsBaoHiem'] .= $bao_hiem_CT . ',';
					$data_report['data_kpichitieu_slKhachHangMoi'] .= $khach_hang_moi_CT . ',';
					$data_report['data_kpidatduoc_dsBaoHiem'] .= $sum_bao_hiem . ',';
					$data_report['data_kpidatduoc_slKhachHangMoi'] .= $count_khach_hang_moi . ',';
					$data_report['data_kpidatduoc_dsGiaiNgan'] .= $sum_giai_ngan . ',';
					$data_report['datakpi_titrong_dsGiaiNgan'] .= $giai_ngan_TT . ',';
					$data_report['datakpi_titrong_dsBaoHiem'] .= $bao_hiem_TT . ',';
					$data_report['datakpi_titrong_slKhachHangMoi'] .= $khach_hang_moi_TT . ',';

					$data_report['data_kpichitieu_duno'] .= $du_no_CT . ',';
					$data_report['data_kpititrong_duno'] .= $du_no_TT . ',';

					$data_report['data_kpichitieu_nhadautu'] .= $nha_dau_tu_CT . ',';
					$data_report['data_kpititrong_nhadautu'] .= $nha_dau_tu_TT . ',';
				} else {
					$data_report['data_kpichitieu_dsGiaiNgan'] .= '0,';
					$data_report['data_kpichitieu_dsBaoHiem'] .= '0,';
					$data_report['data_kpichitieu_slKhachHangMoi'] .= '0,';
					$data_report['data_kpidatduoc_dsBaoHiem'] .= '0,';
					$data_report['data_kpidatduoc_slKhachHangMoi'] .= '0,';
					$data_report['data_kpidatduoc_dsGiaiNgan'] .= '0,';
					$data_report['datakpi_titrong_dsGiaiNgan'] .= '0,';
					$data_report['datakpi_titrong_dsBaoHiem'] .= '0,';
					$data_report['datakpi_titrong_slKhachHangMoi'] .= '0,';

					$data_report['data_kpichitieu_duno'] .= '0,';
					$data_report['data_kpititrong_duno'] .= '0,';

					$data_report['data_kpichitieu_nhadautu'] .= '0,';
					$data_report['data_kpititrong_nhadautu'] .= '0,';

				}
			}
			$data_report['data_kpichitieu_dsGiaiNgan'] = rtrim($data_report['data_kpichitieu_dsGiaiNgan'], ',');
			$data_report['data_kpichitieu_dsBaoHiem'] = rtrim($data_report['data_kpichitieu_dsBaoHiem'], ',');
			$data_report['data_kpichitieu_slKhachHangMoi'] = rtrim($data_report['data_kpichitieu_slKhachHangMoi'], ',');

			$data_report['data_kpidatduoc_dsBaoHiem'] = rtrim($data_report['data_kpidatduoc_dsBaoHiem'], ',');
			$data_report['data_kpidatduoc_slKhachHangMoi'] = rtrim($data_report['data_kpidatduoc_slKhachHangMoi'], ',');
			$data_report['data_kpidatduoc_dsGiaiNgan'] = rtrim($data_report['data_kpidatduoc_dsGiaiNgan'], ',');

			$data_report['datakpi_titrong_dsGiaiNgan'] = rtrim($data_report['datakpi_titrong_dsGiaiNgan'], ',');
			$data_report['datakpi_titrong_dsBaoHiem'] = rtrim($data_report['datakpi_titrong_dsBaoHiem'], ',');
			$data_report['datakpi_titrong_slKhachHangMoi'] = rtrim($data_report['datakpi_titrong_slKhachHangMoi'], ',');
		} else {
			if (in_array('cua-hang-truong', $groupRoles) && !in_array('phat-trien-san-pham', $groupRoles) && !in_array('quan-ly-khu-vuc', $groupRoles)) {
				$data_report['report_kpi'] = $rku->get_where(['month' => date("m", strtotime(trim($start) . ' 00:00:00')), 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)]);
				$data_report['data_kpi'] = $rk->get_where(['month' => date("m", strtotime(trim($start) . ' 00:00:00')), 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)]);
			} else {
				$data_report['report_kpi'] = $rk->get_where(['month' => date("m", strtotime(trim($start) . ' 00:00:00')), 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)]);

				if (in_array('quan-ly-khu-vuc', $groupRoles) && !in_array('quan-ly-cap-cao', $groupRoles)) {
					$check_area = [];
					foreach ($stores as $item) {
						$check = $this->store_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($item)));
						if (!in_array($check['code_area'], $check_area)) {
							array_push($check_area, $check['code_area']);
						}

					}
					if (!empty($check_area)) {
						$data_report['data_kpi'] = $kpi_area->get_where(['month' => date("m", strtotime(trim($start) . ' 00:00:00')), 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'area.code' => array('$in' => $check_area)]);

					}
				}
			}

			if ((!in_array('cua-hang-truong', $groupRoles) && !in_array('giao-dich-vien', $groupRoles)) || (in_array('phat-trien-san-pham', $groupRoles) || in_array('quan-ly-khu-vuc', $groupRoles))) {
				$area_data = $area->find_where(['status' => 'active']);
				$n = 0;
				foreach ($area_data as $key => $value) {
					$n++;
					$kpi_a = $kpi_area->findOne(['month' => date("m", strtotime(trim($start) . ' 00:00:00')), 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'area.code' => $value['code']]);
					$bao_hiem = $rk->sum_where(['month' => date("m", strtotime(trim($start) . ' 00:00:00')), 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'code_area' => $value['code']], '$sum_bao_hiem');
					$giai_ngan = $rk->sum_where(['month' => date("m", strtotime(trim($start) . ' 00:00:00')), 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'code_area' => $value['code']], '$sum_giai_ngan');
					$du_no_tang_net = $rk->sum_where(['month' => date("m", strtotime(trim($start) . ' 00:00:00')), 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'code_area' => $value['code']], '$du_no_tang_net');
					$khach_hang_moi = $rk->sum_where(['month' => date("m", strtotime(trim($start) . ' 00:00:00')), 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'code_area' => $value['code']], '$count_khach_hang_moi');
					$nha_dau_tu = $rk->sum_where(['month' => date("m", strtotime(trim($start) . ' 00:00:00')), 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'code_area' => $value['code']], '$sum_nha_dau_tu');
					if (!empty($kpi_a))
						$arr_area += [$n => ['bao_hiem' => $bao_hiem, 'giai_ngan' => $giai_ngan, 'khach_hang_moi' => $khach_hang_moi, 'name' => $value['title'], 'kpi' => $kpi_a, 'du_no_tang_net' => $du_no_tang_net, 'nha_dau_tu' => $nha_dau_tu]];
				}
			}
			foreach ($data_report['report_kpi'] as $key => $value) {

				$data_report['kpi_bao_hiem'] += $value['sum_bao_hiem'];
				$data_report['kpi_kh_moi'] += $value['count_khach_hang_moi'];
				$data_report['kpi_giai_ngan'] += $value['sum_giai_ngan'];
				$data_report['tong_chi_tieu'] += $value['sum_giai_ngan'] + $value['count_khach_hang_moi'] + $value['sum_bao_hiem'];

			}
		}
		$data_report['data_area'] = $arr_area;
		$data_report['groupRoles'] = $groupRoles;


		if ($data_report) {
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'data' => $data_report


			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

	}

	public function kpi_domain_detail_post()
	{
//		$flag = notify_token($this->flag_login);
//		if ($flag == false) return;
		$data = $this->input->post();
		$start_old = '2019-11-01';
		$start = !empty($data['start']) ? $data['start'] : date('Y-m-01');
		$end = !empty($data['end']) ? $data['end'] : date('2030-m-d');
		$condition = array();
		$condition_lead = array();

		$start_search = !empty($data['start']) ? $data['start'] : '2019-11-01';

		if (!empty($start) && !empty($end)) {
			$condition_old = array(
				'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);
			$condition_lead = array(
				'$gte' => strtotime(trim($start) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);
			$condition_search_old = array(
				'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
				'$lte' => strtotime(trim(date('Y-m-d')) . ' 23:59:59')
			);

			//Dư nợ quá hạn T+10 tháng trước
			$date = getdate();

			$month_thang_nay = $date['mon'] - 1;
			$month_thang_truoc = $date['mon'] - 1;
			$year = $date['year'];
			if ($date['mon'] == 1) {
				$month_thang_nay = 12;
				$month_thang_truoc = 12;
				$year = $date['year'] - 1;
			}

			$start_thang_truoc = !empty($month_thang_truoc) ? date("$year-$month_thang_truoc-01") : date('Y-m-01');
			$end_thang_truoc = !empty($month_thang_truoc) ? date("$year-$month_thang_truoc-t") : date('Y-m-d');

			$start_thang_nay = !empty($date['mon']) ? date("Y-$month_thang_nay-01") : date('Y-m-01');
			$end_thang_nay = !empty($date['mon']) ? date("Y-$month_thang_nay-d") : date('Y-m-d');

			$condition_thang_truoc = array(
				'$gte' => strtotime(trim($start_thang_truoc) . ' 00:00:00'),
				'$lte' => strtotime(trim($end_thang_truoc) . ' 23:59:59')
			);
			$condition_thang_nay = array(
				'$gte' => strtotime(trim($start_thang_nay) . ' 00:00:00'),
				'$lte' => strtotime(trim($end_thang_nay) . ' 23:59:59')
			);
		}
		$year = date('Y');
		$code_area = !empty($data['code_area']) ? $data['code_area'] : "";

		$stores = $this->getStores_list_detail($code_area);


		if (empty($stores)) {
			$storeData = $this->store_model->find_where_in('status', ['active']);

			if (!empty($storeData)) {

				foreach ($storeData as $key => $item) {
					array_push($stores, (string)$item['_id']);
				}
			}
			$condition['store.id'] = array('$in' => $stores);
		} else {
			$condition['store.id'] = array('$in' => $stores);
		}


		$user_phone = $this->getPhoneArea($code_area);


		$rk = new Report_kpi_model();
		$rku = new Report_kpi_user_model();
		$rktu = new Report_kpi_top_user_model();
		$rktp = new Report_kpi_top_pgd_model();
		$lead = new Lead_model();
		$kpi_area = new Kpi_area_model();
		$area = new Area_model();
		$contract = new Contract_model();
		$rkcpm = new Report_kpi_commission_pgd_model();
		$rkcum = new Report_kpi_commission_user_model();

		$debt_store = new Debt_store_model();

		$arr_area = array();
		$data_report = array();
		$data_report['total_so_tien_vay'] = 0;
		$data_report['total_du_no_qua_han'] = 0;
		$data_report['total_du_no_dang_cho_vay'] = 0;


		//v2
		$phone_user = $this->getPhoneStore($stores);
		$total_nha_dau_tu = $this->callApiInvest(['year' => date('Y'), 'month' => date('m'), 'phone' => $phone_user], '/commission_group_cvkd');
		if($total_nha_dau_tu->status == 200 && !empty($total_nha_dau_tu)){
			$data_report['total_nha_dau_tu'] = $total_nha_dau_tu->data->total;
		}
		$total_nha_dau_tu = $this->callApiInvest(['year' => date('Y'), 'month' => date('m'), 'phone' => $user_phone], '/commission_cvkd');
		if($total_nha_dau_tu->status == 200 && !empty($total_nha_dau_tu)){
			$data_report['tien_hoa_hong_nha_dau_tu'] = $total_nha_dau_tu->data->total->money_commission_number;
		}

		$data_report['total_so_tien_vay_old'] = $contract->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'disbursement_date' => $condition_search_old, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 37, 38, 39, 41, 42, 19])], array('$toLong' => '$loan_infor.amount_money'));

		$data_report['total_du_no_qua_han_t10_old'] = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'store.id' => array('$in' => $stores), 'debt.so_ngay_cham_tra' => ['$gte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');

		//V2
		$data_report['total_du_no_trong_han_t10_old'] = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'store.id' => array('$in' => $stores), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');
		$data_report['total_du_no_trong_han_t10_thang_truoc'] = $debt_store->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'created_at' => $condition_thang_truoc], '$total_du_no_trong_han_t10_old');


		$data_report['total_doanh_so_bao_hiem'] = $rkcpm->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'san_pham' => 'BH', 'created_at' => $condition_lead], '$commision.doanh_so');

		$data_report['total_tien_hoa_hong'] = $rkcpm->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'created_at' => $condition_lead], '$commision.tien_hoa_hong');


		$data_report['total_du_no_trong_han_t10'] = $data_report['total_du_no_trong_han_t10_old'] - $data_report['total_du_no_trong_han_t10_thang_truoc'];

		//
		$data_report['total_du_no_dang_cho_vay_old'] = $contract->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'disbursement_date' => $condition_old, 'status' => array('$in' => list_array_trang_thai_dang_vay()), 'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');

		$data_report['total_so_tien_vay'] = $contract->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'disbursement_date' => $condition_lead, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 37, 38, 39, 41, 42, 19, 33, 34])], array('$toLong' => '$loan_infor.amount_money'));

		// var_dump($stores); die;
		$data_report['total_du_no_qua_han_t10'] = $rktp->sum_where(['store.id' => array('$in' => $stores), 'date' => $condition_lead], '$total_du_no_qua_han_t10');

		$data_report['total_du_no_dang_cho_vay'] = $contract->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'disbursement_date' => $condition_lead, 'status' => array('$in' => list_array_trang_thai_dang_vay()), 'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');


		$data_report['contract_moi'] = $rktp->sum_where(['store.id' => array('$in' => $stores), 'date' => $condition_lead], '$contract_moi');

		$data_report['contract_dang_xl'] = $rktp->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores)], '$contract_dang_xl');
		$data_report['contract_cho_cd'] = $rktp->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores)], '$contract_cho_cd');
		$data_report['contract_da_duyet'] = $rktp->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores)], '$contract_da_duyet');
		$data_report['contract_cho_gn'] = $rktp->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores)], '$contract_cho_gn');
		$data_report['contract_da_gn'] = $rktp->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores)], '$contract_da_gn');
		$data_report['contract_khac'] = $rktp->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores)], '$contract_khac');
		$data_report['contract_total'] = $rktp->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores)], '$contract_total');


		//Update không hiển thị các PGD đã cơ cấu
		$data_report['report_kpi'] = $rk->get_where(['month' => date("m", strtotime(trim($start) . ' 00:00:00')), 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)]);
		$arr_store_new = [];
		foreach ($data_report['report_kpi'] as $value) {
			$check = $this->check_store_cocau($value['store']['id']);

			if ($check == true) {
				array_push($arr_store_new, $value);
			}
		}
		$data_report['report_kpi'] = $arr_store_new;

		$check_area = [];
		foreach ($stores as $item) {
			$check = $this->store_model->findOne(array("_id" => new MongoDB\BSON\ObjectId($item)));
			if (!in_array($check['code_area'], $check_area)) {
				array_push($check_area, $check['code_area']);
			}

		}
		if (!empty($check_area)) {
			$data_report['data_kpi'] = $kpi_area->get_where(['month' => date("m", strtotime(trim($start) . ' 00:00:00')), 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'area.code' => array('$in' => $check_area)]);

		}


		$area_data = $area->find_where(['status' => 'active']);
		$n = 0;
		foreach ($area_data as $key => $value) {
			$n++;
			$kpi_a = $kpi_area->findOne(['month' => date("m", strtotime(trim($start) . ' 00:00:00')), 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'area.code' => $value['code']]);
			$bao_hiem = $rk->sum_where(['month' => date("m", strtotime(trim($start) . ' 00:00:00')), 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'code_area' => $value['code']], '$sum_bao_hiem');
			$giai_ngan = $rk->sum_where(['month' => date("m", strtotime(trim($start) . ' 00:00:00')), 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'code_area' => $value['code']], '$sum_giai_ngan');
			$du_no_tang_net = $rk->sum_where(['month' => date("m", strtotime(trim($start) . ' 00:00:00')), 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'code_area' => $value['code']], '$du_no_tang_net');
			$khach_hang_moi = $rk->sum_where(['month' => date("m", strtotime(trim($start) . ' 00:00:00')), 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'code_area' => $value['code']], '$count_khach_hang_moi');
			if (!empty($kpi_a))
				$arr_area += [$n => ['bao_hiem' => $bao_hiem, 'giai_ngan' => $giai_ngan, 'khach_hang_moi' => $khach_hang_moi, 'name' => $value['title'], 'kpi' => $kpi_a, 'du_no_tang_net' => $du_no_tang_net]];
		}

		foreach ($data_report['report_kpi'] as $key => $value) {

			$data_report['kpi_bao_hiem'] += $value['sum_bao_hiem'];
			$data_report['kpi_kh_moi'] += $value['count_khach_hang_moi'];
			$data_report['kpi_giai_ngan'] += $value['sum_giai_ngan'];
			$data_report['tong_chi_tieu'] += $value['sum_giai_ngan'] + $value['count_khach_hang_moi'] + $value['sum_bao_hiem'];

		}


		$data_report['data_area'] = $arr_area;


		if ($data_report) {
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'data' => $data_report


			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

	}

	private function check_store_cocau($idStore)
	{

		$check = $this->store_model->findOne(['_id' => new MongoDB\BSON\ObjectId($idStore), 'type_pgd' => '3']);

		if (!empty($check)) {
			return false;
		} else {
			return true;
		}

	}

	private function getStores_list($userId)
	{
		$roles = $this->role_model->find_where(array("status" => "active"));
		$roleStores = array();
		if (count($roles) > 0) {
			foreach ($roles as $role) {
				if (!empty($role['users']) && count($role['users']) > 0) {
					$arrUsers = array();
					foreach ($role['users'] as $item) {
						array_push($arrUsers, key($item));
					}
					//Check userId in list key of $users
					if (in_array($userId, $arrUsers) == TRUE) {
						if (!empty($role['stores'])) {
							//Push store
							foreach ($role['stores'] as $key => $item) {
								array_push($roleStores, key($item));
							}
						}
					}
				}
			}
		}
		return $roleStores;
	}

	private function getUserbyStores($storeId)
	{
		$roles = $this->role_model->find_where(array("status" => "active"));
		$roleAllUsers = array();
		if (count($roles) > 0) {
			foreach ($roles as $role) {
				if (!empty($role['stores']) && count($role['stores']) == 1) {
					$arrStores = array();
					foreach ($role['stores'] as $item) {
						array_push($arrStores, key($item));
					}

					//Check userId in list key of $users
					foreach ($storeId as $s) {

						if (in_array($s, $arrStores) == TRUE) {
							if (!empty($role['stores'])) {
								//Push store

								foreach ($role['users'] as $key => $item) {
									foreach ($item as $e) {
										array_push($roleAllUsers, $e->email);
									}
								}

							}
						}
					}

				}
			}
		}
		$roleUsers = array_unique($roleAllUsers);
		return $roleUsers;
	}


	private function getStores_list_detail($code_area)
	{
		$roles = $this->store_model->find_where(array("status" => "active", "code_area" => $code_area));
		$roleStores = array();
		if (count($roles) > 0) {
			foreach ($roles as $role) {
				array_push($roleStores, (string)$role['_id']);
			}
		}

		return $roleStores;
	}

	private function getStores_pgd_detail($store_id)
	{
		$roles = $this->store_model->find_where(array("_id" => new MongoDB\BSON\ObjectId($store_id)));
		$roleStores = array();
		if (count($roles) > 0) {
			foreach ($roles as $role) {
				array_push($roleStores, (string)$role['_id']);
			}
		}

		return $roleStores;
	}


	private function getStores($userId)
	{
		$roles = $this->role_model->find_where(array("status" => "active"));
		$roleStores = array();
		if (count($roles) > 0) {
			foreach ($roles as $role) {
				if (!empty($role['users']) && count($role['users']) > 0) {
					$arrUsers = array();
					foreach ($role['users'] as $item) {
						array_push($arrUsers, key($item));
					}
					//Check userId in list key of $users
					if (in_array($userId, $arrUsers) == TRUE) {
						if (!empty($role['stores'])) {
							//Push store
							foreach ($role['stores'] as $key => $item) {
								array_push($roleStores, key($item));
							}
						}
					}
				}
			}
		}
		return $roleStores;
	}

	private function getGroupRole($userId)
	{
		$groupRoles = $this->group_role_model->find_where(array("status" => "active"));
		$arr = array();
		foreach ($groupRoles as $groupRole) {
			if (empty($groupRole['users'])) continue;
			foreach ($groupRole['users'] as $item) {
				if (key($item) == $userId) {
					array_push($arr, $groupRole['slug']);
					continue;
				}
			}
		}
		return $arr;
	}

	public function kpi_domain_detail_lead_post()
	{

//		$flag = notify_token($this->flag_login);
//		if ($flag == false) return;
		$data = $this->input->post();
		$start_old = '2019-11-01';
		$start = !empty($data['start']) ? $data['start'] : date('Y-m-01');
		$end = !empty($data['end']) ? $data['end'] : date('2030-m-d');
		$condition = array();
		$condition_lead = array();

		$start_search = !empty($data['start']) ? $data['start'] : '2019-11-01';

		if (!empty($start) && !empty($end)) {
			$condition_old = array(
				'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);
			$condition_lead = array(
				'$gte' => strtotime(trim($start) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);
			$condition_search_old = array(
				'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
				'$lte' => strtotime(trim(date('Y-m-d')) . ' 23:59:59')
			);

			//Dư nợ quá hạn T+10 tháng trước
			$date = getdate();

			$month_thang_nay = $date['mon'] - 1;
			$month_thang_truoc = $date['mon'] - 1;
			$year = $date['year'];
			if ($date['mon'] == 1) {
				$month_thang_nay = 12;
				$month_thang_truoc = 12;
				$year = $date['year'] - 1;
			}

			$start_thang_truoc = !empty($month_thang_truoc) ? date("$year-$month_thang_truoc-01") : date('Y-m-01');
			$end_thang_truoc = !empty($month_thang_truoc) ? date("$year-$month_thang_truoc-t") : date('Y-m-d');

			$start_thang_nay = !empty($date['mon']) ? date("Y-$month_thang_nay-01") : date('Y-m-01');
			$end_thang_nay = !empty($date['mon']) ? date("Y-$month_thang_nay-d") : date('Y-m-d');

			$condition_thang_truoc = array(
				'$gte' => strtotime(trim($start_thang_truoc) . ' 00:00:00'),
				'$lte' => strtotime(trim($end_thang_truoc) . ' 23:59:59')
			);
			$condition_thang_nay = array(
				'$gte' => strtotime(trim($start_thang_nay) . ' 00:00:00'),
				'$lte' => strtotime(trim($end_thang_nay) . ' 23:59:59')
			);
		}

//		$groupRoles = $this->getGroupRole($this->id);
		$year = date('Y');
		$store_id = !empty($data['store_id']) ? $data['store_id'] : "";

		$stores = $this->getStores_pgd_detail($store_id);

		$user_cht = $this->getGroupRole_cht();

		$store_name = $this->store_model->findOne(['_id' => new MongoDB\BSON\ObjectId($store_id)]);

		$getPhoneUserChtByStore = $this->getPhoneByCht($store_name, $user_cht);

		//   $stores =array();

		if (empty($stores)) {
			$storeData = $this->store_model->find_where_in('status', ['active']);

			if (!empty($storeData)) {

				foreach ($storeData as $key => $item) {
					array_push($stores, (string)$item['_id']);
				}
			}
			$condition['store.id'] = array('$in' => $stores);
		} else {
			$condition['store.id'] = array('$in' => $stores);
		}


		// $data_dashboard['contract']['contract_total']  = $contract->count(array("date"=>$condition,));
		$rk = new Report_kpi_model();
		$rku = new Report_kpi_user_model();
		$rktu = new Report_kpi_top_user_model();
		$rktp = new Report_kpi_top_pgd_model();
		$lead = new Lead_model();
		$kpi_area = new Kpi_area_model();
		$area = new Area_model();
		$contract = new Contract_model();
		$rkcpm = new Report_kpi_commission_pgd_model();
		$rkcum = new Report_kpi_commission_user_model();

		$debt_store = new Debt_store_model();

		$arr_area = array();
		$data_report = array();
		$data_report['total_so_tien_vay'] = 0;
		$data_report['total_du_no_qua_han'] = 0;
		$data_report['total_du_no_dang_cho_vay'] = 0;


		$phone_user = $this->getPhoneStore($stores);
		$total_nha_dau_tu = $this->callApiInvest(['year' => date('Y'), 'month' => date('m'), 'phone' => $phone_user], '/commission_group_cvkd');
		if($total_nha_dau_tu->status == 200 && !empty($total_nha_dau_tu)){
			$data_report['total_nha_dau_tu'] = $total_nha_dau_tu->data->total;
		}
		$total_nha_dau_tu = $this->callApiInvest(['year' => date('Y'), 'month' => date('m'), 'phone' => $getPhoneUserChtByStore], '/commission_cvkd');
		if($total_nha_dau_tu->status == 200 && !empty($total_nha_dau_tu)){
			$data_report['tien_hoa_hong_nha_dau_tu'] = $total_nha_dau_tu->data->total->money_commission_number;
		}

		//v2
		$data_report['total_so_tien_vay_old'] = $contract->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'disbursement_date' => $condition_search_old, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 37, 38, 39, 41, 42, 19])], array('$toLong' => '$loan_infor.amount_money'));

		$data_report['total_du_no_qua_han_t10_old'] = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'store.id' => array('$in' => $stores), 'debt.so_ngay_cham_tra' => ['$gte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');

		//V2

		$data_report['total_du_no_trong_han_t10_old'] = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'store.id' => array('$in' => $stores), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');
		$data_report['total_du_no_trong_han_t10_thang_truoc'] = $debt_store->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'created_at' => $condition_thang_truoc], '$total_du_no_trong_han_t10_old');

		$data_report['total_doanh_so_bao_hiem'] = $rkcpm->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'san_pham' => 'BH', 'created_at' => $condition_lead], '$commision.doanh_so');
//		$data_report['total_tien_hoa_hong'] = $rkcpm->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'created_at' => $condition_lead], '$commision.tien_hoa_hong');
		$tien_hoa_hong_PGD_ca_nhan = $rkcum->sum_where_total_mongo_read(['created_at' => $condition_lead ,'store.id' => array('$in' => $stores), 'user' => ['$in' => $user_cht]], '$commision.tien_hoa_hong');
		$tien_hoa_hong_PGD = $rkcpm->sum_where_total_mongo_read(['created_at' => $condition_lead ,'san_pham' => 'HDV','store.id' => array('$in' => $stores)], '$commision.tien_hoa_hong');
		$data_report['total_tien_hoa_hong'] = $tien_hoa_hong_PGD_ca_nhan + $tien_hoa_hong_PGD;

		$data_report['total_du_no_trong_han_t10'] = $data_report['total_du_no_trong_han_t10_old'] - $data_report['total_du_no_trong_han_t10_thang_truoc'];

		//
		$data_report['total_du_no_dang_cho_vay_old'] = $contract->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'disbursement_date' => $condition_old, 'status' => array('$in' => list_array_trang_thai_dang_vay()),'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');

		$data_report['total_so_tien_vay'] = $contract->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'disbursement_date' => $condition_lead, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 37, 38, 39, 41, 42, 19, 33, 34])], array('$toLong' => '$loan_infor.amount_money'));

		// var_dump($stores); die;
		$data_report['total_du_no_qua_han_t4'] = $rktp->sum_where(['store.id' => array('$in' => $stores), 'date' => $condition_lead], '$total_du_no_qua_han_t4');
		$data_report['total_du_no_qua_han_t10'] = $rktp->sum_where(['store.id' => array('$in' => $stores), 'date' => $condition_lead], '$total_du_no_qua_han_t10');

		$data_report['total_du_no_dang_cho_vay'] = $contract->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'disbursement_date' => $condition_lead, 'status' => array('$in' => list_array_trang_thai_dang_vay()), 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');


		$data_report['contract_moi'] = $rktp->sum_where(['store.id' => array('$in' => $stores), 'date' => $condition_lead], '$contract_moi');

		$data_report['contract_dang_xl'] = $rktp->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores)], '$contract_dang_xl');
		$data_report['contract_cho_cd'] = $rktp->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores)], '$contract_cho_cd');
		$data_report['contract_da_duyet'] = $rktp->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores)], '$contract_da_duyet');
		$data_report['contract_cho_gn'] = $rktp->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores)], '$contract_cho_gn');
		$data_report['contract_da_gn'] = $rktp->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores)], '$contract_da_gn');
		$data_report['contract_khac'] = $rktp->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores)], '$contract_khac');
		$data_report['contract_total'] = $rktp->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores)], '$contract_total');


		$data_report['report_kpi'] = $rku->get_where(['month' => date("m", strtotime(trim($start) . ' 00:00:00')), 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)]);
		$data_report['data_kpi'] = $rk->get_where(['month' => date("m", strtotime(trim($start) . ' 00:00:00')), 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)]);

		foreach ($data_report['report_kpi'] as $key => $value) {

			$data_report['kpi_bao_hiem'] += $value['sum_bao_hiem'];
			$data_report['kpi_kh_moi'] += $value['count_khach_hang_moi'];
			$data_report['kpi_giai_ngan'] += $value['sum_giai_ngan'];
			$data_report['tong_chi_tieu'] += $value['sum_giai_ngan'] + $value['count_khach_hang_moi'] + $value['sum_bao_hiem'];

		}

		$data_report['data_area'] = $arr_area;
		$data_report['store_name'] = $store_name['name'];


		if ($data_report) {
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'data' => $data_report


			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}


	}

	public function kpi_domain_detail_nhanvien_post()
	{

		$data = $this->input->post();
		$start_old = '2019-11-01';
		$start = !empty($data['start']) ? $data['start'] : date('Y-m-01');
		$end = !empty($data['end']) ? $data['end'] : date('2030-m-d');
		$condition = array();
		$condition_lead = array();

		$start_search = !empty($data['start']) ? $data['start'] : '2019-11-01';

		if (!empty($start) && !empty($end)) {
			$condition_old = array(
				'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);
			$condition_lead = array(
				'$gte' => strtotime(trim($start) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);
			$condition_search_old = array(
				'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
				'$lte' => strtotime(trim(date('Y-m-d')) . ' 23:59:59')
			);

			//Dư nợ quá hạn T+10 tháng trước
			$date = getdate();

			$month_thang_nay = $date['mon'] - 1;
			$month_thang_truoc = $date['mon'] - 1;
			$year = $date['year'];
			if ($date['mon'] == 1) {
				$month_thang_nay = 12;
				$month_thang_truoc = 12;
				$year = $date['year'] - 1;
			}

			$start_thang_truoc = !empty($month_thang_truoc) ? date("$year-$month_thang_truoc-01") : date('Y-m-01');
			$end_thang_truoc = !empty($month_thang_truoc) ? date("$year-$month_thang_truoc-t") : date('Y-m-d');

			$start_thang_nay = !empty($date['mon']) ? date("Y-$month_thang_nay-01") : date('Y-m-01');
			$end_thang_nay = !empty($date['mon']) ? date("Y-$month_thang_nay-d") : date('Y-m-d');

			$condition_thang_truoc = array(
				'$gte' => strtotime(trim($start_thang_truoc) . ' 00:00:00'),
				'$lte' => strtotime(trim($end_thang_truoc) . ' 23:59:59')
			);
			$condition_thang_nay = array(
				'$gte' => strtotime(trim($start_thang_nay) . ' 00:00:00'),
				'$lte' => strtotime(trim($end_thang_nay) . ' 23:59:59')
			);
		}
		$year = date('Y');
		$name = !empty($data['name']) ? $data['name'] : "";

		$id_user = $this->user_model->findOne(["email" => $name]);

		$stores = $this->getStores_list((string)$id_user['_id']);

		//   $stores =array();

		$created_by = $name;
		$condition['created_by'] = $created_by;

		// $data_dashboard['contract']['contract_total']  = $contract->count(array("date"=>$condition,));
		$rk = new Report_kpi_model();
		$rku = new Report_kpi_user_model();
		$rktu = new Report_kpi_top_user_model();
		$rktp = new Report_kpi_top_pgd_model();
		$lead = new Lead_model();
		$kpi_area = new Kpi_area_model();
		$area = new Area_model();
		$contract = new Contract_model();
		$rkcpm = new Report_kpi_commission_pgd_model();
		$rkcum = new Report_kpi_commission_user_model();
		$debt_user = new Debt_user_model();

		$arr_area = array();
		$data_report = array();
		$data_report['total_so_tien_vay'] = 0;
		$data_report['total_du_no_qua_han'] = 0;
		$data_report['total_du_no_dang_cho_vay'] = 0;



		//Hoa hồng nhà đầu tư
		$total_nha_dau_tu = $this->callApiInvest(['year' => date('Y'), 'month' => date('m'), 'phone' => $id_user['phone_number']], '/commission_cvkd');
		if($total_nha_dau_tu->status == 200 && !empty($total_nha_dau_tu)){
			$data_report['tien_hoa_hong_nha_dau_tu']  = $total_nha_dau_tu->data->total->money_commission_number;
			$data_report['total_nha_dau_tu'] = $total_nha_dau_tu->data->total->total_money_number;
		}

		//v2
		$data_report['total_giai_ngan_chi_tieu_ti_trong'] = $this->price_disbursement_gdv($created_by, $start, $condition_lead);

		$data_report['total_du_no_trong_han_t10_old'] = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false), 'created_by' => $created_by], '$debt.tong_tien_goc_con');
		$data_report['total_du_no_trong_han_t10_thang_truoc'] = $debt_user->sum_where_total_mongo_read(['user' => $created_by, 'created_at' => $condition_thang_truoc], '$total_du_no_trong_han_t10_old');

		$data_report['total_doanh_so_bao_hiem'] = $rkcum->sum_where_total_mongo_read(['san_pham' => 'BH', 'created_at' => $condition_lead, 'user' => $created_by], '$commision.doanh_so');
		$data_report['total_tien_hoa_hong'] = $rkcum->sum_where_total_mongo_read(['created_at' => $condition_lead, 'san_pham' => 'HDV' ,'user' => $created_by], '$commision.tien_hoa_hong');
		$data_report['total_tien_hoa_hong_bao_hiem'] = $rkcum->sum_where_total(['created_at' => $condition_lead, 'san_pham' => 'BH' ,'user' => $created_by], '$commision.tien_hoa_hong');


		$data_report['total_du_no_trong_han_t10'] = $data_report['total_du_no_trong_han_t10_old'] - $data_report['total_du_no_trong_han_t10_thang_truoc'];


		$data_report['total_so_tien_vay'] = $contract->sum_where_total_mongo_read(['created_by' => $created_by, 'disbursement_date' => $condition_lead, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 37, 38, 39, 41, 42, 19, 33, 34,19])], array('$toLong' => '$loan_infor.amount_money'));
		$data_report['total_so_tien_vay_old'] = $contract->sum_where_total_mongo_read(['status' => array('$in' => [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 37, 38, 39, 41, 42, 19]), 'disbursement_date' => $condition_search_old, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'created_by' => $created_by], array('$toLong' => '$loan_infor.amount_money'));
		$data_report['total_du_no_dang_cho_vay_old'] = $contract->sum_where_total_mongo_read(['disbursement_date' => $condition_old, 'status' => array('$in' => list_array_trang_thai_dang_vay()), 'tat_toan_gh' => array('$exists' => false), 'created_by' => $created_by], '$debt.tong_tien_goc_con');
		$data_report['total_du_no_qua_han_t10_old'] = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'created_by' => $created_by, 'debt.so_ngay_cham_tra' => ['$gte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');
		$data_report['total_du_no_dang_cho_vay'] = $contract->sum_where_total_mongo_read(['created_by' => $created_by, 'disbursement_date' => $condition_lead, 'status' => array('$in' => list_array_trang_thai_dang_vay()), 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');


		$data_report['contract_moi'] = $rktu->sum_where(['store.id' => array('$in' => $stores), 'date' => $condition_lead, 'user' => $created_by], '$contract_moi');
		$data_report['contract_dang_xl'] = $rktu->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores), 'user' => $created_by], '$contract_dang_xl');
		$data_report['contract_cho_cd'] = $rktu->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores), 'user' => $created_by], '$contract_cho_cd');
		$data_report['contract_da_duyet'] = $rktu->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores), 'user' => $created_by], '$contract_da_duyet');
		$data_report['contract_cho_gn'] = $rktu->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores), 'user' => $created_by], '$contract_cho_gn');
		$data_report['contract_da_gn'] = $rktu->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores), 'user' => $created_by], '$contract_da_gn');
		$data_report['contract_khac'] = $rktu->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores), 'user' => $created_by], '$contract_khac');
		$data_report['contract_total'] = $rktu->sum_where(['date' => $condition_lead, 'store.id' => array('$in' => $stores), 'user' => $created_by], '$contract_total');


		$arr_month = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
		foreach ($arr_month as $key => $month) {
			$report_kpiData = $rku->find_where(['month' => $month, 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'user_email' => $created_by]);
			if (!empty($report_kpiData)) {
				foreach ($report_kpiData as $report_kpi) {
					$data_report['kpi_bao_hiem'] += $report_kpi['sum_bao_hiem'];
					$data_report['kpi_kh_moi'] += $report_kpi['count_khach_hang_moi'];
					$data_report['kpi_giai_ngan'] += $report_kpi['sum_giai_ngan'];
					$data_report['tong_chi_tieu'] += $report_kpi['sum_giai_ngan'] + $report_kpi['count_khach_hang_moi'] + $report_kpi['sum_bao_hiem'];
					if (!empty($report_kpi['kpi'])) {
						$giai_ngan_CT = (isset($report_kpi['kpi']['giai_ngan_CT'])) ? $report_kpi['kpi']['giai_ngan_CT'] : 0;
						$bao_hiem_CT = (isset($report_kpi['kpi']['bao_hiem_CT'])) ? $report_kpi['kpi']['bao_hiem_CT'] : 0;
						$du_no_CT = (isset($report_kpi['kpi']['du_no_CT'])) ? $report_kpi['kpi']['du_no_CT'] : 0;
						$giai_ngan_TT = (isset($report_kpi['kpi']['giai_ngan_TT'])) ? $report_kpi['kpi']['giai_ngan_TT'] : 0;
						$bao_hiem_TT = (isset($report_kpi['kpi']['bao_hiem_TT'])) ? $report_kpi['kpi']['bao_hiem_TT'] : 0;
						$du_no_TT = (isset($report_kpi['kpi']['du_no_TT'])) ? $report_kpi['kpi']['du_no_TT'] : 0;

						$nha_dau_tu_CT = (isset($report_kpi['kpi']['nha_dau_tu'])) ? $report_kpi['kpi']['nha_dau_tu'] : 0;
						$nha_dau_tu_TT = (isset($report_kpi['kpi']['nha_dau_tu_TT'])) ? $report_kpi['kpi']['nha_dau_tu_TT'] : 0;
					}
					$sum_bao_hiem += (isset($report_kpi['sum_bao_hiem'])) ? $report_kpi['sum_bao_hiem'] : 0;
					$count_khach_hang_moi = (isset($report_kpi['count_khach_hang_moi'])) ? $report_kpi['count_khach_hang_moi'] : 0;
					$sum_giai_ngan += (isset($report_kpi['sum_giai_ngan'])) ? $report_kpi['sum_giai_ngan'] : 0;

					if (in_array('giao-dich-vien', $groupRoles) && !in_array('cua-hang-truong', $groupRoles)) {
						$data_report['data_labels'] = '"' . $report_kpi['user_email'] . '",';
					}
				}

				$data_report['data_kpichitieu_dsGiaiNgan'] .= $giai_ngan_CT . ',';
				$data_report['data_kpichitieu_dsBaoHiem'] .= $bao_hiem_CT . ',';

				$data_report['data_kpidatduoc_dsBaoHiem'] .= $sum_bao_hiem . ',';
				$data_report['data_kpidatduoc_slKhachHangMoi'] .= $count_khach_hang_moi . ',';
				$data_report['data_kpidatduoc_dsGiaiNgan'] .= $sum_giai_ngan . ',';
				$data_report['datakpi_titrong_dsGiaiNgan'] .= $giai_ngan_TT . ',';
				$data_report['datakpi_titrong_dsBaoHiem'] .= $bao_hiem_TT . ',';

				$data_report['data_kpichitieu_duno'] .= $du_no_CT . ',';
				$data_report['data_kpititrong_duno'] .= $du_no_TT . ',';

				$data_report['data_kpichitieu_nhadautu'] .= $nha_dau_tu_CT . ',';
				$data_report['data_kpititrong_nhadautu'] .= $nha_dau_tu_TT . ',';

			} else {
				$data_report['data_kpichitieu_dsGiaiNgan'] .= '0,';
				$data_report['data_kpichitieu_dsBaoHiem'] .= '0,';
				$data_report['data_kpichitieu_slKhachHangMoi'] .= '0,';
				$data_report['data_kpidatduoc_dsBaoHiem'] .= '0,';
				$data_report['data_kpidatduoc_slKhachHangMoi'] .= '0,';
				$data_report['data_kpidatduoc_dsGiaiNgan'] .= '0,';
				$data_report['datakpi_titrong_dsGiaiNgan'] .= '0,';
				$data_report['datakpi_titrong_dsBaoHiem'] .= '0,';
				$data_report['data_kpichitieu_duno'] .= '0,';
				$data_report['data_kpititrong_duno'] .= '0,';

				$data_report['data_kpichitieu_nhadautu'] .= '0,';
				$data_report['data_kpititrong_nhadautu'] .= '0,';
			}
		}
		$data_report['data_kpichitieu_dsGiaiNgan'] = rtrim($data_report['data_kpichitieu_dsGiaiNgan'], ',');
		$data_report['data_kpichitieu_dsBaoHiem'] = rtrim($data_report['data_kpichitieu_dsBaoHiem'], ',');
		$data_report['data_kpichitieu_slKhachHangMoi'] = rtrim($data_report['data_kpichitieu_slKhachHangMoi'], ',');

		$data_report['data_kpidatduoc_dsBaoHiem'] = rtrim($data_report['data_kpidatduoc_dsBaoHiem'], ',');
		$data_report['data_kpidatduoc_slKhachHangMoi'] = rtrim($data_report['data_kpidatduoc_slKhachHangMoi'], ',');
		$data_report['data_kpidatduoc_dsGiaiNgan'] = rtrim($data_report['data_kpidatduoc_dsGiaiNgan'], ',');

		$data_report['datakpi_titrong_dsGiaiNgan'] = rtrim($data_report['datakpi_titrong_dsGiaiNgan'], ',');
		$data_report['datakpi_titrong_dsBaoHiem'] = rtrim($data_report['datakpi_titrong_dsBaoHiem'], ',');
		$data_report['datakpi_titrong_slKhachHangMoi'] = rtrim($data_report['datakpi_titrong_slKhachHangMoi'], ',');


		$data_report['data_area'] = $arr_area;


		if ($data_report) {
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'data' => $data_report


			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
	}

	public function exportDashboard_post()
	{

		$data = $this->input->post();
		$start_old = '2019-11-01';
		$start = !empty($data['start']) ? $data['start'] : date('Y-m-01');
		$end = !empty($data['end']) ? $data['end'] : date('2030-m-d');
		$condition = array();
		$condition_lead = array();

		$start_search = !empty($data['start']) ? $data['start'] : '2019-11-01';

		if (!empty($start) && !empty($end)) {
			$condition_old = array(
				'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);
			$condition_lead = array(
				'$gte' => strtotime(trim($start) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);
			$condition_search_old = array(
				'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
				'$lte' => strtotime(trim(date('Y-m-d')) . ' 23:59:59')
			);

			//Dư nợ quá hạn T+10 tháng trước
			$date = getdate();

			$month_thang_nay = $date['mon'] - 1;
			$month_thang_truoc = $date['mon'] - 1;
			$year = $date['year'];
			if ($date['mon'] == 1) {
				$month_thang_nay = 12;
				$month_thang_truoc = 12;
				$year = $date['year'] - 1;
			}

			$start_thang_truoc = !empty($month_thang_truoc) ? date("$year-$month_thang_truoc-01") : date('Y-m-01');
			$end_thang_truoc = !empty($month_thang_truoc) ? date("$year-$month_thang_truoc-t") : date('Y-m-d');

			$start_thang_nay = !empty($date['mon']) ? date("Y-$month_thang_nay-01") : date('Y-m-01');
			$end_thang_nay = !empty($date['mon']) ? date("Y-$month_thang_nay-d") : date('Y-m-d');

			$condition_thang_truoc = array(
				'$gte' => strtotime(trim($start_thang_truoc) . ' 00:00:00'),
				'$lte' => strtotime(trim($end_thang_truoc) . ' 23:59:59')
			);
			$condition_thang_nay = array(
				'$gte' => strtotime(trim($start_thang_nay) . ' 00:00:00'),
				'$lte' => strtotime(trim($end_thang_nay) . ' 23:59:59')
			);
		}
		$year = date('Y');
		$area = $this->area_model->find_where(["status" => "active"]);
		$code_area = [];
		if (!empty($area)) {
			foreach ($area as $value) {
				if ($value['code'] == "Priority") {
					continue;
				}

				$code_area += [$value['title'] => $value['code']];
			}
		}


		$rk = new Report_kpi_model();
		$rku = new Report_kpi_user_model();
		$rktp = new Report_kpi_top_pgd_model();
		$contract = new Contract_model();
		$rkcpm = new Report_kpi_commission_pgd_model();
		$rkcum = new Report_kpi_commission_user_model();

		$debt_store = new Debt_store_model();

		$data = [];

		foreach ($code_area as $key => $item) {

			$stores = $this->getStores_list_detail($item);

			$condition['store.id'] = array('$in' => $stores);

			$data[$key]['total_so_tien_vay'] = $contract->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'disbursement_date' => $condition_lead, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 37, 38, 39, 41, 42, 19, 33, 34])], array('$toLong' => '$loan_infor.amount_money'));

			//du_no_tang_net

			$total_du_no_trong_han_t10_1 = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'store.id' => array('$in' => $stores), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');

			$total_du_no_trong_han_t10_2 = $debt_store->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'created_at' => $condition_thang_truoc], '$total_du_no_trong_han_t10_old');


			$data[$key]['total_du_no_trong_han_t10'] = $total_du_no_trong_han_t10_1 - $total_du_no_trong_han_t10_2;

			//doanh_so_bao_hiem
			$data[$key]['total_doanh_so_bao_hiem'] = $rkcpm->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'san_pham' => 'BH', 'created_at' => $condition_lead], '$commision.doanh_so');

			//Tổng tiền giải ngân
			$data[$key]['total_so_tien_vay_old'] = $contract->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'disbursement_date' => $condition_old, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 37, 38, 39, 41, 42, 19])], array('$toLong' => '$loan_infor.amount_money'));

			//Dư nợ quản lý
			$data[$key]['total_du_no_dang_cho_vay_old'] = $contract->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'disbursement_date' => $condition_old, 'status' => array('$in' => list_array_trang_thai_dang_vay()), 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');

			//Dư nợ trong hạn T+10 hiện tại
			$data[$key]['total_du_no_trong_han_t10_old'] = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'store.id' => array('$in' => $stores), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => true)], '$debt.tong_tien_goc_con');

			//Dư nợ trong hạn T+10 kỳ trước
			$data[$key]['total_du_no_trong_han_t10_thang_truoc'] = $debt_store->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'created_at' => $condition_thang_truoc], '$total_du_no_trong_han_t10_old');

		}

		if ($data) {
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'data' => $data
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

	}

	public function exportAllBaohiem_post()
	{

		$data = $this->input->post();

//		$start = !empty( $data['start']) ? $data['start'] : date('Y-m-01');
//		$end = !empty( $data['end']) ?  $data['end'] : date('Y-m-d');

		$start = !empty($data['fdate']) ? $data['fdate'] : date('Y-m-01');
		$end = !empty($data['tdate']) ? $data['tdate'] : date('Y-m-d');

		$condition = [];

		if (!empty($start)) {
			$condition['start'] = strtotime(trim($start) . ' 00:00:00');
		}
		if (!empty($end)) {
			$condition['end'] = strtotime(trim($end) . ' 23:59:59');
		}

		$groupRoles = $this->getGroupRole($this->id);
		$stores = $this->getStores_list($this->id);

		if (in_array('giao-dich-vien', $groupRoles) && !in_array('cua-hang-truong', $groupRoles)) {
			$created_by = $this->uemail;
			$condition['created_by'] = $created_by;
		} else {
			if (empty($stores)) {
				$storeData = $this->store_model->find_where_in('status', ['active']);

				if (!empty($storeData)) {

					foreach ($storeData as $key => $item) {
						array_push($stores, (string)$item['_id']);
					}
				}
				$condition['store.id'] = array('$in' => $stores);
			} else {
				$condition['store.id'] = array('$in' => $stores);
			}
		}

		$condition['status'] = 1;

		$data_vbi_sxh = [];
		$data_vbi_tnds = [];
		$data_vbi_utv = [];
		$data_pti_vta_bn = [];
		$data_mic_tnds = [];
		$data_gic_plt_bn = [];
		$data_contract_tnds = [];
		$data_vbi = [];
		$data_gic_easy = [];
		$data_gic_plt_easy = [];

		//vbi_sxh
		$list_vbi_sxh = $this->vbi_sxh_model->getAll_excel($condition);
		if (!empty($list_vbi_sxh)) {
			foreach ($list_vbi_sxh as $value) {
				$data_1['ma_hop_dong'] = "";
				$data_1['ma_hop_dong_bao_hiem'] = !empty($value['vbi_sxh']['so_hd']) ? $value['vbi_sxh']['so_hd'] : "";
				$data_1['ten_nguoi_duoc_bao_hiem'] = !empty($value['customer_info']['customer_name']) ? $value['customer_info']['customer_name'] : "";
				$data_1['so_dien_thoai'] = !empty($value['customer_info']['customer_phone']) ? $value['customer_info']['customer_phone'] : "";
				$data_1['email'] = !empty($value['customer_info']['email']) ? $value['customer_info']['email'] : "";
				$data_1['ngay_thang_nam_sinh'] = !empty($value['customer_info']['ngay_sinh']) ? date('d/m/Y', $value['customer_info']['ngay_sinh']) : "";
				$data_1['goi_bao_hiem'] = !empty($value['goi_bh']) ? $value['goi_bh'] : "";
				$data_1['phi_bao_hiem'] = !empty($value['fee']) ? $value['fee'] : "";
				$data_1['phong_giao_dich'] = !empty($value['store']['name']) ? $value['store']['name'] : "";
				$data_1['ngay_hieu_luc'] = !empty($value['NGAY_HL']) ? date('d/m/Y', strtotime((int)$value['NGAY_HL'])) : "";
				$data_1['ngay_ket_thuc'] = !empty($value['NGAY_KT']) ? date('d/m/Y', strtotime((int)$value['NGAY_KT'])) : "";
				$data_1['ngay_tao'] = !empty($value['created_at']) ? date('d/m/Y H:i:s', $value['created_at']) : "";
				$data_1['nguoi_tao'] = !empty($value['created_by']) ? $value['created_by'] : "";
				array_push($data_vbi_sxh, $data_1);
			}
		}


		//vbi_tnds
		$list_vbi_tnds = $this->vbi_tnds_model->getAll_excel($condition);
		if (!empty($list_vbi_tnds)) {
			foreach ($list_vbi_tnds as $value) {
				$data_1['ma_hop_dong'] = "";
				$data_1['ma_hop_dong_bao_hiem'] = !empty($value['vbi_tnds']['so_hd']) ? $value['vbi_tnds']['so_hd'] : "";
				$data_1['ten_nguoi_duoc_bao_hiem'] = !empty($value['customer_info']['customer_name']) ? $value['customer_info']['customer_name'] : "";
				$data_1['so_dien_thoai'] = !empty($value['customer_info']['customer_phone']) ? $value['customer_info']['customer_phone'] : "";
				$data_1['email'] = !empty($value['customer_info']['email']) ? $value['customer_info']['email'] : "";
				$data_1['ngay_thang_nam_sinh'] = "";
				$data_1['goi_bao_hiem'] = !empty($value['code']) ? $value['code'] : "";
				$data_1['phi_bao_hiem'] = !empty($value['fee']) ? $value['fee'] : "";
				$data_1['phong_giao_dich'] = !empty($value['store']['name']) ? $value['store']['name'] : "";
				$data_1['ngay_hieu_luc'] = !empty($value['NGAY_HL']) ? $value['NGAY_HL'] : "";
				$data_1['ngay_ket_thuc'] = !empty($value['NGAY_KT']) ? $value['NGAY_KT'] : "";
				$data_1['ngay_tao'] = !empty($value['created_at']) ? date('d/m/Y H:i:s', $value['created_at']) : "";
				$data_1['nguoi_tao'] = !empty($value['created_by']) ? $value['created_by'] : "";
				array_push($data_vbi_tnds, $data_1);
			}
		}

		//vbi_utv
		$list_vbi_utv = $this->vbi_utv_model->getAll_excel($condition);
		if (!empty($list_vbi_utv)) {
			foreach ($list_vbi_utv as $value) {
				$data_1['ma_hop_dong'] = "";
				$data_1['ma_hop_dong_bao_hiem'] = !empty($value['vbi_utv']['so_hd']) ? $value['vbi_utv']['so_hd'] : "";
				$data_1['ten_nguoi_duoc_bao_hiem'] = !empty($value['customer_info']['customer_name']) ? $value['customer_info']['customer_name'] : "";
				$data_1['so_dien_thoai'] = !empty($value['customer_info']['customer_phone']) ? $value['customer_info']['customer_phone'] : "";
				$data_1['email'] = !empty($value['customer_info']['email']) ? $value['customer_info']['email'] : "";
				$data_1['ngay_thang_nam_sinh'] = !empty($value['customer_info']['ngay_sinh']) ? date('d/m/Y', $value['customer_info']['ngay_sinh']) : "";
				$data_1['goi_bao_hiem'] = !empty($value['goi_bh']) ? $value['goi_bh'] : "";
				$data_1['phi_bao_hiem'] = !empty($value['fee']) ? $value['fee'] : "";
				$data_1['phong_giao_dich'] = !empty($value['store']['name']) ? $value['store']['name'] : "";
				$data_1['ngay_hieu_luc'] = !empty($value['NGAY_HL']) ? date('d/m/Y', strtotime((int)$value['NGAY_HL'])) : "";
				$data_1['ngay_ket_thuc'] = !empty($value['NGAY_KT']) ? date('d/m/Y', strtotime((int)$value['NGAY_KT'])) : "";
				$data_1['ngay_tao'] = !empty($value['created_at']) ? date('d/m/Y H:i:s', $value['created_at']) : "";
				$data_1['nguoi_tao'] = !empty($value['created_by']) ? $value['created_by'] : "";
				array_push($data_vbi_utv, $data_1);
			}
		}

		//pti_vta_bn
		$list_pti_vta_bn = $this->pti_vta_bn_model->getAll_excel($condition);
		if (!empty($list_pti_vta_bn)) {
			foreach ($list_pti_vta_bn as $value) {

				if ($value->type_pti == "HD") {
					$data_1['ma_hop_dong'] = !empty($value['code_contract_disbursement']) ? $value['code_contract_disbursement'] : "";
					$data_1['ma_hop_dong_bao_hiem'] = !empty($value['pti_code']) ? $value['pti_code'] : "";
					$data_1['ten_nguoi_duoc_bao_hiem'] = !empty($value['contract_info']['customer_infor']['customer_name']) ? $value['contract_info']['customer_infor']['customer_name'] : "";
					$data_1['so_dien_thoai'] = !empty($value['contract_info']['customer_infor']['customer_phone_number']) ? $value['contract_info']['customer_infor']['customer_phone_number'] : "";
					$data_1['email'] = !empty($value['contract_info']['customer_infor']['customer_email']) ? $value['contract_info']['customer_infor']['customer_email'] : "";
					$data_1['ngay_thang_nam_sinh'] = !empty($value['contract_info']['customer_infor']['customer_BOD']) ? $value['contract_info']['customer_infor']['customer_BOD'] : "";
					$data_1['goi_bao_hiem'] = !empty($value['code_pti_vta']) ? $value['code_pti_vta'] : "";
					$data_1['phi_bao_hiem'] = !empty($value['contract_info']['loan_infor']['bao_hiem_pti_vta']['price_pti_vta']) ? $value['contract_info']['loan_infor']['bao_hiem_pti_vta']['price_pti_vta'] : "";
					$data_1['phong_giao_dich'] = !empty($value['store']['name']) ? $value['store']['name'] : "";
					$data_1['ngay_hieu_luc'] = !empty($value['NGAY_HL']) ? date('d/m/Y', strtotime($value['NGAY_HL'])) : "";
					$data_1['ngay_ket_thuc'] = !empty($value['NGAY_KT']) ? date('d/m/Y', strtotime($value['NGAY_KT'])) : "";
					$data_1['ngay_tao'] = !empty($value['created_at']) ? date('d/m/Y H:i:s', $value['created_at']) : "";
					$data_1['nguoi_tao'] = !empty($value['contract_info']['created_by']) ? $value['contract_info']['created_by'] : "";
					array_push($data_pti_vta_bn, $data_1);
				} else {
					$data_1['ma_hop_dong'] = !empty($value['code_contract_disbursement']) ? $value['code_contract_disbursement'] : "";
					$data_1['ma_hop_dong_bao_hiem'] = !empty($value['request']['so_hd']) ? $value['request']['so_hd'] : "";
					$data_1['ten_nguoi_duoc_bao_hiem'] = !empty($value['request']['btendn']) ? $value['request']['btendn'] : "";
					$data_1['so_dien_thoai'] = !empty($value['request']['bphonedn']) ? $value['request']['bphonedn'] : "";
					$data_1['email'] = !empty($value['request']['bemaildn']) ? $value['request']['bemaildn'] : "";
					$data_1['ngay_thang_nam_sinh'] = !empty($value['request']['ngay_sinh']) ? date('d/m/Y', strtotime($value['request']['ngay_sinh'])) : "";
					$data_1['goi_bao_hiem'] = !empty($value['code_pti_vta']) ? $value['code_pti_vta'] : "";
					$data_1['phi_bao_hiem'] = !empty($value['request']['phi_bh']) ? $value['request']['phi_bh'] : "";
					$data_1['phong_giao_dich'] = !empty($value['store']['name']) ? $value['store']['name'] : "";
					$data_1['ngay_hieu_luc'] = !empty($value['NGAY_HL']) ? date('d/m/Y', strtotime($value['NGAY_HL'])) : "";
					$data_1['ngay_ket_thuc'] = !empty($value['NGAY_KT']) ? date('d/m/Y', strtotime($value['NGAY_KT'])) : "";
					$data_1['ngay_tao'] = !empty($value['created_at']) ? date('d/m/Y H:i:s', $value['created_at']) : "";
					$data_1['nguoi_tao'] = !empty($value['created_by']) ? $value['created_by'] : "";
					array_push($data_pti_vta_bn, $data_1);
				}


			}
		}

		//mic_tnds
		$list_mic_tnds = $this->mic_tnds_model->getAll_excel($condition);
		if (!empty($list_mic_tnds)) {
			foreach ($list_mic_tnds as $value) {
				$data_1['ma_hop_dong'] = !empty($value['code_contract_disbursement']) ? $value['code_contract_disbursement'] : "";
				$data_1['ma_hop_dong_bao_hiem'] = !empty($value['mic_code']) ? $value['mic_code'] : "";
				$data_1['ten_nguoi_duoc_bao_hiem'] = !empty($value['customer_info']['customer_name']) ? $value['customer_info']['customer_name'] : "";
				$data_1['so_dien_thoai'] = !empty($value['customer_info']['customer_phone']) ? $value['customer_info']['customer_phone'] : "";
				$data_1['email'] = !empty($value['customer_info']['email']) ? $value['customer_info']['email'] : "";
				$data_1['ngay_thang_nam_sinh'] = !empty($value['customer_info']['birthday']) ? date('d/m/Y', ((int)$value['customer_info']['birthday'])) : "";
				$data_1['goi_bao_hiem'] = !empty($value['type_mic']) ? $value['type_mic'] : "";
				$data_1['phi_bao_hiem'] = !empty($value['mic_fee']) ? $value['mic_fee'] : "";
				$data_1['phong_giao_dich'] = !empty($value['store']['name']) ? $value['store']['name'] : "";
				$data_1['ngay_hieu_luc'] = !empty($value['NGAY_HL']) ? $value['NGAY_HL'] : "";
				$data_1['ngay_ket_thuc'] = !empty($value['NGAY_KT']) ? $value['NGAY_KT'] : "";
				$data_1['ngay_tao'] = !empty($value['created_at']) ? date('d/m/Y H:i:s', $value['created_at']) : "";
				$data_1['nguoi_tao'] = !empty($value['created_by']) ? $value['created_by'] : "";
				array_push($data_mic_tnds, $data_1);
			}
		}

		//gic_plt_bn
		$list_gic_plt_bn = $this->gic_plt_bn_model->getAll_excel($condition);
		if (!empty($list_gic_plt_bn)) {
			foreach ($list_gic_plt_bn as $value) {
				$data_1['ma_hop_dong'] = !empty($value['code_contract_disbursement']) ? $value['code_contract_disbursement'] : "";
				$data_1['ma_hop_dong_bao_hiem'] = !empty($value['mic_code']) ? $value['mic_code'] : "";
				$data_1['ten_nguoi_duoc_bao_hiem'] = !empty($value['customer_info']['customer_name']) ? $value['customer_info']['customer_name'] : "";
				$data_1['so_dien_thoai'] = !empty($value['customer_info']['customer_phone']) ? $value['customer_info']['customer_phone'] : "";
				$data_1['email'] = !empty($value['customer_info']['email']) ? $value['customer_info']['email'] : "";
				$data_1['ngay_thang_nam_sinh'] = !empty($value['customer_info']['birthday']) ? date('d/m/Y', ((int)$value['customer_info']['birthday'])) : "";
				$data_1['goi_bao_hiem'] = !empty($value['type_mic']) ? $value['type_mic'] : "";
				$data_1['phi_bao_hiem'] = !empty($value['mic_fee']) ? $value['mic_fee'] : "";
				$data_1['phong_giao_dich'] = !empty($value['store']['name']) ? $value['store']['name'] : "";
				$data_1['ngay_hieu_luc'] = !empty($value['NGAY_HL']) ? $value['NGAY_HL'] : "";
				$data_1['ngay_ket_thuc'] = !empty($value['NGAY_KT']) ? $value['NGAY_KT'] : "";
				$data_1['ngay_tao'] = !empty($value['created_at']) ? date('d/m/Y H:i:s', $value['created_at']) : "";
				$data_1['nguoi_tao'] = !empty($value['created_by']) ? $value['created_by'] : "";
				array_push($data_gic_plt_bn, $data_1);
			}
		}

		//contract_tnds_model
		$list_contract_tnds = $this->contract_tnds_model->getAll_excel($condition);
		if (!empty($list_contract_tnds)) {
			foreach ($list_contract_tnds as $value) {

				$data_1['ma_hop_dong'] = !empty($value['contract_info']['code_contract_disbursement']) ? $value['contract_info']['code_contract_disbursement'] : "";
				$data_1['ma_hop_dong_bao_hiem'] = !empty($value['data']['response']['SO_ID']) ? $value['data']['response']['SO_ID'] : "";
				$data_1['ten_nguoi_duoc_bao_hiem'] = !empty($value['contract_info']['customer_infor']['customer_name']) ? $value['contract_info']['customer_infor']['customer_name'] : "";
				$data_1['so_dien_thoai'] = !empty($value['contract_info']['customer_infor']['customer_phone_number']) ? $value['contract_info']['customer_infor']['customer_phone_number'] : "";
				$data_1['email'] = !empty($value['contract_info']['customer_infor']['customer_email']) ? $value['contract_info']['customer_infor']['customer_email'] : "";
				$data_1['ngay_thang_nam_sinh'] = !empty($value['contract_info']['customer_infor']['customer_BOD']) ? date('d/m/Y', strtotime($value['contract_info']['customer_infor']['customer_BOD'])) : "";
				$data_1['goi_bao_hiem'] = "Bảo hiểm TNDS";
				$data_1['phi_bao_hiem'] = !empty($value['data']['response']['PHI']) ? $value['data']['response']['PHI'] : "";
				$data_1['phong_giao_dich'] = !empty($value['store']['name']) ? $value['store']['name'] : "";
				$data_1['ngay_hieu_luc'] = !empty($value['data']['NGAY_HL']) ? $value['data']['NGAY_HL'] : "";
				$data_1['ngay_ket_thuc'] = !empty($value['data']['NGAY_KT']) ? $value['data']['NGAY_KT'] : "";
				$data_1['ngay_tao'] = !empty($value['created_at']) ? date('d/m/Y H:i:s', $value['created_at']) : "";
				$data_1['nguoi_tao'] = !empty($value['created_by']) ? $value['created_by'] : "";
				array_push($data_contract_tnds, $data_1);
			}
		}

		//vbi
		$list_vbi = $this->vbi_model->getAll_excel($condition);

		if (!empty($list_vbi)) {
			foreach ($list_vbi as $value) {

				$data_1['ma_hop_dong'] = !empty($value['contract_info']['code_contract_disbursement']) ? $value['contract_info']['code_contract_disbursement'] : "";
				$data_1['ma_hop_dong_bao_hiem'] = !empty($value['vbi_sxh']['so_hd']) ? $value['vbi_sxh']['so_hd'] : $value['vbi_utv']['so_hd'];
				$data_1['ten_nguoi_duoc_bao_hiem'] = !empty($value['customer_info']['customer_name']) ? $value['customer_info']['customer_name'] : "";
				$data_1['so_dien_thoai'] = !empty($value['customer_info']['customer_phone']) ? $value['customer_info']['customer_phone'] : "";
				$data_1['email'] = !empty($value['customer_info']['email']) ? $value['customer_info']['email'] : "";
				$data_1['ngay_thang_nam_sinh'] = !empty($value['customer_info']['ngay_sinh']) ? date('d/m/Y', $value['customer_info']['ngay_sinh']) : "";
				$data_1['goi_bao_hiem'] = !empty($value['goi_bh']) ? $value['goi_bh'] : "";
				$data_1['phi_bao_hiem'] = !empty($value['fee']) ? $value['fee'] : "";
				$data_1['phong_giao_dich'] = !empty($value['contract_info']['store']['name']) ? $value['contract_info']['store']['name'] : "";
				$data_1['ngay_hieu_luc'] = !empty($value['NGAY_HL']) ? date('d/m/Y', strtotime($value['NGAY_HL'])) : "";
				$data_1['ngay_ket_thuc'] = !empty($value['NGAY_KT']) ? date('d/m/Y', strtotime($value['NGAY_KT'])) : "";
				$data_1['ngay_tao'] = !empty($value['created_at']) ? date('d/m/Y H:i:s', $value['created_at']) : "";
				$data_1['nguoi_tao'] = !empty($value['created_by']) ? $value['created_by'] : "";
				array_push($data_vbi, $data_1);
			}
		}

		//gic_easy
		$list_gic_easy = $this->gic_easy_model->getAll_excel($condition);
		if (!empty($list_gic_easy)) {
			foreach ($list_gic_easy as $value) {

				$data_1['ma_hop_dong'] = !empty($value['code_contract_disbursement']) ? $value['code_contract_disbursement'] : "";
				$data_1['ma_hop_dong_bao_hiem'] = !empty($value['gic_code']) ? $value['gic_code'] : "";
				$data_1['ten_nguoi_duoc_bao_hiem'] = !empty($value['contract_info']['customer_infor']['customer_name']) ? $value['contract_info']['customer_infor']['customer_name'] : "";
				$data_1['so_dien_thoai'] = !empty($value['contract_info']['customer_infor']['customer_phone_number']) ? $value['contract_info']['customer_infor']['customer_phone_number'] : "";
				$data_1['email'] = !empty($value['contract_info']['customer_infor']['customer_email']) ? $value['contract_info']['customer_infor']['customer_email'] : "";
				$data_1['ngay_thang_nam_sinh'] = !empty($value['contract_info']['customer_infor']['customer_BOD']) ? date('d/m/Y', strtotime($value['contract_info']['customer_infor']['customer_BOD'])) : "";
				$data_1['goi_bao_hiem'] = "Gic_easy";
				$data_1['phi_bao_hiem'] = !empty($value['contract_info']['loan_infor']['amount_GIC_easy']) ? $value['contract_info']['loan_infor']['amount_GIC_easy'] : "";
				$data_1['phong_giao_dich'] = !empty($value['contract_info']['store']['name']) ? $value['contract_info']['store']['name'] : "";
				$data_1['ngay_hieu_luc'] = !empty($value['gic_info']['noiDungBaoHiem_NgayHieuLucBaoHiem']) ? $value['gic_info']['noiDungBaoHiem_NgayHieuLucBaoHiem'] : "";
				$data_1['ngay_ket_thuc'] = !empty($value['gic_info']['noiDungBaoHiem_NgayHieuLucBaoHiemDen']) ? $value['gic_info']['noiDungBaoHiem_NgayHieuLucBaoHiemDen'] : "";
				$data_1['ngay_tao'] = !empty($value['created_at']) ? date('d/m/Y H:i:s', $value['created_at']) : "";
				$data_1['nguoi_tao'] = !empty($value['contract_info']['created_by']) ? $value['contract_info']['created_by'] : "";
				array_push($data_gic_easy, $data_1);
			}
		}

		//gic_plt
		$gic_plt_easy = $this->gic_plt_model->getAll_excel($condition);
		if (!empty($gic_plt_easy)) {
			foreach ($gic_plt_easy as $value) {

				$data_1['ma_hop_dong'] = !empty($value['code_contract_disbursement']) ? $value['code_contract_disbursement'] : "";
				$data_1['ma_hop_dong_bao_hiem'] = !empty($value['gic_code']) ? $value['gic_code'] : "";
				$data_1['ten_nguoi_duoc_bao_hiem'] = !empty($value['contract_info']['customer_infor']['customer_name']) ? $value['contract_info']['customer_infor']['customer_name'] : "";
				$data_1['so_dien_thoai'] = !empty($value['contract_info']['customer_infor']['customer_phone_number']) ? $value['contract_info']['customer_infor']['customer_phone_number'] : "";
				$data_1['email'] = !empty($value['contract_info']['customer_infor']['customer_email']) ? $value['contract_info']['customer_infor']['customer_email'] : "";
				$data_1['ngay_thang_nam_sinh'] = !empty($value['contract_info']['customer_infor']['customer_BOD']) ? date('d/m/Y', strtotime($value['contract_info']['customer_infor']['customer_BOD'])) : "";
				$data_1['goi_bao_hiem'] = "Gic_plt";
				$data_1['phi_bao_hiem'] = !empty($value['contract_info']['loan_infor']['amount_GIC_easy']) ? $value['contract_info']['loan_infor']['amount_GIC_easy'] : "";
				$data_1['phong_giao_dich'] = !empty($value['contract_info']['store']['name']) ? $value['contract_info']['store']['name'] : "";
				$data_1['ngay_hieu_luc'] = !empty($value['gic_info']['noiDungBaoHiem_NgayHieuLucBaoHiem']) ? $value['gic_info']['noiDungBaoHiem_NgayHieuLucBaoHiem'] : "";
				$data_1['ngay_ket_thuc'] = !empty($value['gic_info']['noiDungBaoHiem_NgayHieuLucBaoHiemDen']) ? $value['gic_info']['noiDungBaoHiem_NgayHieuLucBaoHiemDen'] : "";
				$data_1['ngay_tao'] = !empty($value['created_at']) ? date('d/m/Y H:i:s', $value['created_at']) : "";
				$data_1['nguoi_tao'] = !empty($value['created_by']) ? $value['created_by'] : "";
				array_push($data_gic_plt_easy, $data_1);
			}
		}


		$data_baohiem = array_merge($data_vbi_sxh, $data_vbi_tnds, $data_vbi_utv, $data_pti_vta_bn, $data_mic_tnds, $data_gic_plt_bn, $data_contract_tnds, $data_vbi, $data_gic_easy, $data_gic_plt_easy);

		if ($data_baohiem) {
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'data' => $data_baohiem
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

	}

	public function exportDashboard_asm_post()
	{

		$data = $this->input->post();
		$start_old = '2019-11-01';
		$start = !empty($data['start']) ? $data['start'] : date('Y-m-01');
		$end = !empty($data['end']) ? $data['end'] : date('2030-m-d');
		$condition = array();
		$condition_lead = array();

		$start_search = !empty($data['start']) ? $data['start'] : '2019-11-01';

		if (!empty($start) && !empty($end)) {
			$condition_old = array(
				'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);
			$condition_lead = array(
				'$gte' => strtotime(trim($start) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);
			$condition_search_old = array(
				'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
				'$lte' => strtotime(trim(date('Y-m-d')) . ' 23:59:59')
			);

			//Dư nợ quá hạn T+10 tháng trước
			$date = getdate();

			$month_thang_nay = $date['mon'] - 1;
			$month_thang_truoc = $date['mon'] - 1;
			$year = $date['year'];
			if ($date['mon'] == 1) {
				$month_thang_nay = 12;
				$month_thang_truoc = 12;
				$year = $date['year'] - 1;
			}

			$start_thang_truoc = !empty($month_thang_truoc) ? date("$year-$month_thang_truoc-01") : date('Y-m-01');
			$end_thang_truoc = !empty($month_thang_truoc) ? date("$year-$month_thang_truoc-t") : date('Y-m-d');

			$start_thang_nay = !empty($date['mon']) ? date("Y-$month_thang_nay-01") : date('Y-m-01');
			$end_thang_nay = !empty($date['mon']) ? date("Y-$month_thang_nay-d") : date('Y-m-d');

			$condition_thang_truoc = array(
				'$gte' => strtotime(trim($start_thang_truoc) . ' 00:00:00'),
				'$lte' => strtotime(trim($end_thang_truoc) . ' 23:59:59')
			);
			$condition_thang_nay = array(
				'$gte' => strtotime(trim($start_thang_nay) . ' 00:00:00'),
				'$lte' => strtotime(trim($end_thang_nay) . ' 23:59:59')
			);
		}
		$year = date('Y');
		$stores = $this->getStores_list($this->id);
		$stores_for = [];
		$code_area = [];
		if (!empty($stores)) {
			foreach ($stores as $value) {
				$store_name = $this->store_model->findOne(array('_id' => new MongoDB\BSON\ObjectId((string)$value)));
				if (!empty($store_name)) {
					$stores_for += [$store_name['name'] => $value];
				}
			}
		}

		$rk = new Report_kpi_model();
		$rku = new Report_kpi_user_model();
		$rktp = new Report_kpi_top_pgd_model();
		$contract = new Contract_model();
		$rkcpm = new Report_kpi_commission_pgd_model();
		$rkcum = new Report_kpi_commission_user_model();
		$debt_store = new Debt_store_model();
		$data = [];

		foreach ($stores_for as $key => $item) {

//			$stores = $this->getStores_list_detail($item);
			$stores = [$item];
			$condition['store.id'] = array('$in' => $stores);

			$data[$key]['total_so_tien_vay'] = $contract->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'disbursement_date' => $condition_lead, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 37, 38, 39, 41, 42, 19, 33, 34])], array('$toLong' => '$loan_infor.amount_money'));

			//du_no_tang_net
			$total_du_no_trong_han_t10_hien_tai = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'store.id' => array('$in' => $stores), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old,  'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');
			$total_du_no_oto_va_nha_dat_hien_tai = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'store.id' => array('$in' => $stores), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old,  'tat_toan_gh' => array('$exists' => false)], '$debt.kpi_tong_tien_goc_con');
			$total_du_no_trong_han_t10_1 = $total_du_no_trong_han_t10_hien_tai;

			$total_du_no_trong_han_t10_2 = $debt_store->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'created_at' => $condition_thang_truoc], '$total_du_no_trong_han_t10_old');

			$data[$key]['total_du_no_trong_han_t10'] = $total_du_no_trong_han_t10_1 - $total_du_no_trong_han_t10_2;

			//doanh_so_bao_hiem
			$data[$key]['total_doanh_so_bao_hiem'] = $rkcpm->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'san_pham' => 'BH', 'created_at' => $condition_lead], '$commision.doanh_so');

			//Tổng tiền giải ngân
			$data[$key]['total_so_tien_vay_old'] = $contract->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'disbursement_date' => $condition_old, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 37, 38, 39, 41, 42, 19])], array('$toLong' => '$loan_infor.amount_money'));

			//Dư nợ quản lý
			$data[$key]['total_du_no_dang_cho_vay_old'] = $contract->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'disbursement_date' => $condition_old, 'status' => array('$in' => list_array_trang_thai_dang_vay()), 'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');

			//Dư nợ trong hạn T+10 hiện tại
			$data[$key]['total_du_no_trong_han_t10_old'] = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'store.id' => array('$in' => $stores), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');

			//Dư nợ trong hạn T+10 kỳ trước
			$data[$key]['total_du_no_trong_han_t10_thang_truoc'] = $debt_store->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'created_at' => $condition_thang_truoc], '$total_du_no_trong_han_t10_old');
		}

		if ($data) {
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'data' => $data
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

	}

	public function exportDashboard_lead_post()
	{

		$data = $this->input->post();
		$start_old = '2019-11-01';
		$start = !empty($data['start']) ? $data['start'] : date('Y-m-01');
		$end = !empty($data['end']) ? $data['end'] : date('2030-m-d');
		$condition = array();
		$condition_lead = array();

		$start_search = !empty($data['start']) ? $data['start'] : '2019-11-01';

		if (!empty($start) && !empty($end)) {
			$condition_old = array(
				'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);
			$condition_lead = array(
				'$gte' => strtotime(trim($start) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);
			$condition_search_old = array(
				'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
				'$lte' => strtotime(trim(date('Y-m-d')) . ' 23:59:59')
			);

			//Dư nợ quá hạn T+10 tháng trước
			$date = getdate();

			$month_thang_nay = $date['mon'] - 1;
			$month_thang_truoc = $date['mon'] - 1;
			$year = $date['year'];
			if ($date['mon'] == 1) {
				$month_thang_nay = 12;
				$month_thang_truoc = 12;
				$year = $date['year'] - 1;
			}

			$start_thang_truoc = !empty($month_thang_truoc) ? date("$year-$month_thang_truoc-01") : date('Y-m-01');
			$end_thang_truoc = !empty($month_thang_truoc) ? date("$year-$month_thang_truoc-t") : date('Y-m-d');

			$start_thang_nay = !empty($date['mon']) ? date("Y-$month_thang_nay-01") : date('Y-m-01');
			$end_thang_nay = !empty($date['mon']) ? date("Y-$month_thang_nay-d") : date('Y-m-d');

			$condition_thang_truoc = array(
				'$gte' => strtotime(trim($start_thang_truoc) . ' 00:00:00'),
				'$lte' => strtotime(trim($end_thang_truoc) . ' 23:59:59')
			);
			$condition_thang_nay = array(
				'$gte' => strtotime(trim($start_thang_nay) . ' 00:00:00'),
				'$lte' => strtotime(trim($end_thang_nay) . ' 23:59:59')
			);
		}
		$year = date('Y');
		$stores = $this->getStores_list($this->id);

		$stores_for = [];
		$user = [];

		$list_user = $this->getUserbyStores($stores);

		$rk = new Report_kpi_model();
		$rku = new Report_kpi_user_model();
		$rktp = new Report_kpi_top_pgd_model();
		$contract = new Contract_model();
		$rkcpm = new Report_kpi_commission_pgd_model();
		$rkcum = new Report_kpi_commission_user_model();

		$debt_user = new Debt_user_model();

		$data = [];

		foreach ($list_user as $key => $item) {

			$created_by = $item;
			$data[$key]['created_by'] = $created_by;
			$data[$key]['total_so_tien_vay'] = $contract->sum_where_total_mongo_read(['created_by' => $created_by, 'disbursement_date' => $condition_lead, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 37, 38, 39, 41, 42, 19, 33, 34])], array('$toLong' => '$loan_infor.amount_money'));

			//du_no_tang_net
			$total_du_no_trong_han_t10_hien_tai = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'created_by' => $created_by, 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old,  'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');
			$total_du_no_oto_va_nha_dat_hien_tai = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'created_by' => $created_by, 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old,  'tat_toan_gh' => array('$exists' => false)], '$debt.kpi_tong_tien_goc_con');
			$total_du_no_trong_han_t10_1 = $total_du_no_trong_han_t10_hien_tai;


			$total_du_no_trong_han_t10_2 = $debt_user->sum_where_total_mongo_read(['user' => $created_by, 'created_at' => $condition_thang_truoc], '$total_du_no_trong_han_t10_old');

			$data[$key]['total_du_no_trong_han_t10'] = $total_du_no_trong_han_t10_1 - $total_du_no_trong_han_t10_2;

			//doanh_so_bao_hiem
			$data[$key]['total_doanh_so_bao_hiem'] = $rkcum->sum_where_total_mongo_read(['user' => $created_by, 'san_pham' => 'BH', 'created_at' => $condition_lead], '$commision.doanh_so');

			//Tổng tiền giải ngân
			$data[$key]['total_so_tien_vay_old'] = $contract->sum_where_total_mongo_read(['created_by' => $created_by, 'disbursement_date' => $condition_old, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 37, 38, 39, 41, 42, 19])], array('$toLong' => '$loan_infor.amount_money'));

			//Dư nợ quản lý
			$data[$key]['total_du_no_dang_cho_vay_old'] = $contract->sum_where_total_mongo_read(['created_by' => $created_by, 'disbursement_date' => $condition_old, 'status' => array('$in' => list_array_trang_thai_dang_vay()), 'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');

			//Dư nợ trong hạn T+10 hiện tại
			$data[$key]['total_du_no_trong_han_t10_old'] = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'created_by' => $created_by, 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');

			//Dư nợ trong hạn T+10 kỳ trước
			$data[$key]['total_du_no_trong_han_t10_thang_truoc'] = $debt_user->sum_where_total_mongo_read(['user' => $created_by, 'created_at' => $condition_thang_truoc], '$total_du_no_trong_han_t10_old');
		}

		if ($data) {
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'data' => $data
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

	}

	private function getGroupRole_gdv()
	{
		$groupRoles = $this->group_role_model->find_where(array("status" => "active", 'slug' => 'giao-dich-vien'));
		$arr = array();
		foreach ($groupRoles as $groupRole) {
			if (!empty($groupRole['users'])) {
				foreach ($groupRole['users'] as $value) {
					foreach ($value as $key => $item) {
						foreach ($item as $v) {
							$arr += ["$key" => $v];
						}
					}

				}
			}
		}
		return array_unique($arr);
	}

	private function getGroupRole_cht()
	{
		$groupRoles = $this->group_role_model->find_where(array("status" => "active", 'slug' => 'cua-hang-truong'));
		$arr = array();
		foreach ($groupRoles as $groupRole) {
			if (!empty($groupRole['users'])) {
				foreach ($groupRole['users'] as $value) {
					foreach ($value as $key => $item) {
						foreach ($item as $v) {
							array_push($arr, $v);
						}
					}

				}
			}
		}
		return array_unique($arr);
	}


	public function exportKpiCvkd_post()
	{

		$data = $this->input->post();
		$start_old = '2019-11-01';
		$start = !empty($data['start']) ? $data['start'] : date('Y-m-01');
		$end = !empty($data['end']) ? $data['end'] : date('2030-m-d');
		$condition = array();
		$condition_lead = array();

		$start_search = !empty($data['start']) ? $data['start'] : '2019-11-01';

		if (!empty($start) && !empty($end)) {
			$condition_old = array(
				'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);
			$condition_lead = array(
				'$gte' => strtotime(trim($start) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);
			$condition_search_old = array(
				'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
				'$lte' => strtotime(trim(date('Y-m-d')) . ' 23:59:59')
			);

			//Dư nợ quá hạn T+10 tháng trước
			$date = getdate();
			$month = $date['mon'];
			$month_thang_nay = $date['mon'] - 1;
			$month_thang_truoc = $date['mon'] - 1;
			$year = $date['year'];
			if ($date['mon'] == 1) {
				$month_thang_nay = 12;
				$month_thang_truoc = 12;
				$year = $date['year'] - 1;
			}
			if ($date['mon'] < 10) {
				$month = "0" . $month;
			}

			$start_thang_truoc = !empty($month_thang_truoc) ? date("$year-$month_thang_truoc-01") : date('Y-m-01');
			$end_thang_truoc = !empty($month_thang_truoc) ? date("$year-$month_thang_truoc-t") : date('Y-m-d');

			$start_thang_nay = !empty($date['mon']) ? date("Y-$month_thang_nay-01") : date('Y-m-01');
			$end_thang_nay = !empty($date['mon']) ? date("Y-$month_thang_nay-d") : date('Y-m-d');

			$condition_thang_truoc = array(
				'$gte' => strtotime(trim($start_thang_truoc) . ' 00:00:00'),
				'$lte' => strtotime(trim($end_thang_truoc) . ' 23:59:59')
			);
			$condition_thang_nay = array(
				'$gte' => strtotime(trim($start_thang_nay) . ' 00:00:00'),
				'$lte' => strtotime(trim($end_thang_nay) . ' 23:59:59')
			);
		}
		$year = date('Y');
		$rk = new Report_kpi_model();
		$rku = new Report_kpi_user_model();
		$rktp = new Report_kpi_top_pgd_model();
		$contract = new Contract_model();
		$rkcpm = new Report_kpi_commission_pgd_model();
		$rkcum = new Report_kpi_commission_user_model();
		$kpigdv = new Kpi_gdv_model();

		$debt_user = new Debt_user_model();

		$data = [];

		$list_user_pgd = $this->getGroupRole_gdv();
		$get_role = $this->getGroupRole_cht();

		$count = 0;
		$kpi_du_no = 0;
		$kpi_bao_hiem = 0;
		foreach ($list_user_pgd as $key => $item) {
			$kpi_du_no = 0;
			$kpi_bao_hiem = 0;
			$kpi_giai_ngan = 0;
			$kpi_nha_dau_tu = 0;

			$data[$count]['created_by'] = $item;
			if(in_array($item, $get_role)){
				continue;
			}

			//du_no_tang_net
			$total_du_no_trong_han_t10_hien_tai = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'created_by' => $item, 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');
			$total_du_no_oto_va_nha_dat_hien_tai = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'created_by' => $item, 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false)], '$debt.kpi_tong_tien_goc_con');
			$total_du_no_trong_han_t10_1 = $total_du_no_trong_han_t10_hien_tai;

			$total_du_no_trong_han_t10_2 = $debt_user->sum_where_total_mongo_read(['user' => $item, 'created_at' => $condition_thang_truoc], '$total_du_no_trong_han_t10_old');

			$data[$count]['total_du_no_trong_han_t10'] = $total_du_no_trong_han_t10_1 - $total_du_no_trong_han_t10_2;

			//Chỉ tiêu dư nợ tăng net
			$data[$count]['chi_tieu_du_no_tang_net'] = $kpigdv->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'email_gdv' => $item], '$du_no_CT');
			$du_no_tt = $kpigdv->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'email_gdv' => $item], '$du_no_TT');
			$tt_bao_hiem = $kpigdv->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'email_gdv' => $item], '$bao_hiem_TT');

			//doanh_so_bao_hiem
			$data[$count]['total_doanh_so_bao_hiem'] = $rkcum->sum_where_total_mongo_read(['user' => $item, 'san_pham' => 'BH', 'created_at' => $condition_lead], '$commision.doanh_so');

			//chỉ tiêu bảo hiểm
			$data[$count]['chi_tieu_bao_hiem'] = $kpigdv->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'email_gdv' => $item], '$bao_hiem_CT');

			//Chỉ tiêu giải ngân
			$data[$count]['chi_tieu_giai_ngan'] = $kpigdv->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'email_gdv' => $item], '$giai_ngan_CT');
			$tt_giai_ngan = $kpigdv->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'email_gdv' => $item], '$giai_ngan_TT');

			//Tiền giải ngân mới trong tháng
			$data[$count]['total_so_tien_vay'] = $contract->sum_where_total_mongo_read(['created_by' => $item, 'disbursement_date' => $condition_lead, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 37, 38, 39, 41, 42, 19, 33, 34])], array('$toLong' => '$loan_infor.amount_money'));

			//Chỉ tiêu giải ngân
			$chi_tieu_giai_ngan = $rku->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'kpi' => ['$nin' => [false]] ,'user_email' => $item],'$total_giai_ngan_chi_tieu_ti_trong');

			//Chỉ tiêu nhà đầu tư
			$data[$count]['chi_tieu_nha_dau_tu'] = $kpigdv->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'email_gdv' => $item], '$nha_dau_tu');
			$tt_nha_dau_tu = $kpigdv->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'email_gdv' => $item], '$nha_dau_tu_TT');

			//Doanh số khách đầu tư
			$phone_user = $this->getPhoneUserEmail($item);
			$total_nha_dau_tu = $this->callApiInvest(['year' => date('Y'), 'month' => date('m'), 'phone' => $phone_user], '/commission_cvkd');
			if($total_nha_dau_tu->status == 200 && !empty($total_nha_dau_tu)){
				$data[$count]['tong_tien_dau_tu'] = $total_nha_dau_tu->data->total->total_money_number;
				$tien_hoa_hong_dau_tu =  $total_nha_dau_tu->data->total->money_commission_number;
			}

			//Kpi
			if (!empty($data[$count]['chi_tieu_du_no_tang_net']) && $data[$count]['chi_tieu_du_no_tang_net'] != 0) {
				$kpi_du_no = round(($data[$count]['total_du_no_trong_han_t10'] / $data[$count]['chi_tieu_du_no_tang_net']) * $du_no_tt);
			}
			if (!empty($data[$count]['chi_tieu_bao_hiem']) && $data[$count]['chi_tieu_bao_hiem'] != 0) {
				$kpi_bao_hiem = round(($data[$count]['total_doanh_so_bao_hiem'] / $data[$count]['chi_tieu_bao_hiem']) * $tt_bao_hiem);
			}
			if (!empty($data[$count]['chi_tieu_giai_ngan']) && $data[$count]['chi_tieu_giai_ngan'] != 0) {
				$kpi_giai_ngan = round(($chi_tieu_giai_ngan / $data[$count]['chi_tieu_giai_ngan']) * $tt_giai_ngan);
			}
			if (!empty($data[$count]['chi_tieu_nha_dau_tu']) && $data[$count]['chi_tieu_nha_dau_tu'] != 0) {
				$kpi_nha_dau_tu = round(($data[$count]['tong_tien_dau_tu'] / $data[$count]['chi_tieu_nha_dau_tu']) * $tt_nha_dau_tu);
			}

			if ($kpi_du_no > 40) {
				$kpi_du_no = 40;
			} elseif ($kpi_du_no < 0){
				$kpi_du_no = 0;
			}
			if ($kpi_bao_hiem > 40) {
				$kpi_bao_hiem = 40;
			}
			if ($kpi_giai_ngan > 40) {
				$kpi_giai_ngan = 40;
			}
			if ($kpi_nha_dau_tu > 20) {
				$kpi_nha_dau_tu = 20;
			}

			$data[$count]['kpi'] = $kpi_du_no + $kpi_bao_hiem + $kpi_giai_ngan + $kpi_nha_dau_tu;

			//Tiền hoa hồng
			$total_tien_hoa_hong = $rkcum->sum_where_total_mongo_read(['user' => $item, 'san_pham' => 'HDV' ,'created_at' => $condition_lead], '$commision.tien_hoa_hong');
			$total_tien_hoa_hong_bao_hiem = $rkcum->sum_where_total_mongo_read(['user' => $item, 'san_pham' => 'BH' ,'created_at' => $condition_lead], '$commision.tien_hoa_hong');

			//dư nợ trong hạn T+10
			$data[$count]['total_du_no_trong_han_t10_old'] = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false), 'created_by' => $item], '$debt.tong_tien_goc_con');
			$data[$count]['total_du_no_trong_han_t10_thang_truoc'] = $debt_user->sum_where_total_mongo_read(['user' => $item, 'created_at' => $condition_thang_truoc], '$total_du_no_trong_han_t10_old');


			$tong_tien_hoa_hong = 0;
			if($data[$count]['kpi'] >= 60 && $data[$count]['kpi'] < 80){
				$tong_tien_hoa_hong = ($total_tien_hoa_hong + ($data[$count]['total_du_no_trong_han_t10'] * 0.3/100) + ($data[$count]['total_du_no_trong_han_t10_old'] * 0.1/100)) * 0.6 + $total_tien_hoa_hong_bao_hiem + $tien_hoa_hong_dau_tu;
			} elseif ($data[$count]['kpi'] >= 80 && $data[$count]['kpi'] < 100){
				$tong_tien_hoa_hong = ($total_tien_hoa_hong + ($data[$count]['total_du_no_trong_han_t10'] * 0.3/100) + ($data[$count]['total_du_no_trong_han_t10_old'] * 0.1/100)) * 0.8 + $total_tien_hoa_hong_bao_hiem + $tien_hoa_hong_dau_tu;
			} elseif ($data[$count]['kpi'] >= 100 && $data[$count]['kpi'] < 120){
				$tong_tien_hoa_hong = ($total_tien_hoa_hong + ($data[$count]['total_du_no_trong_han_t10'] * 0.3/100) + ($data[$count]['total_du_no_trong_han_t10_old'] * 0.1/100)) * 1 + $total_tien_hoa_hong_bao_hiem + $tien_hoa_hong_dau_tu;
			} elseif ($data[$count]['kpi'] >= 120){
				$tong_tien_hoa_hong = ($total_tien_hoa_hong + ($data[$count]['total_du_no_trong_han_t10'] * 0.3/100) + ($data[$count]['total_du_no_trong_han_t10_old'] * 0.1/100)) * 1.2 + $total_tien_hoa_hong_bao_hiem + $tien_hoa_hong_dau_tu;
			} else {
				$tong_tien_hoa_hong = $total_tien_hoa_hong_bao_hiem + $tien_hoa_hong_dau_tu;
			}

			$data[$count]['total_tien_hoa_hong'] = $tong_tien_hoa_hong;

			$count++;
		}

		if ($data) {
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'data' => $data
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
	}


	public function exportKpiPGD_post()
	{

		$data = $this->input->post();
		$start_old = '2019-11-01';
		$start = !empty($data['start']) ? $data['start'] : date('Y-m-01');
		$end = !empty($data['end']) ? $data['end'] : date('2030-m-d');
		$condition = array();
		$condition_lead = array();

		$start_search = !empty($data['start']) ? $data['start'] : '2019-11-01';

		if (!empty($start) && !empty($end)) {
			$condition_old = array(
				'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);
			$condition_lead = array(
				'$gte' => strtotime(trim($start) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);
			$condition_search_old = array(
				'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
				'$lte' => strtotime(trim(date('Y-m-d')) . ' 23:59:59')
			);

			//Dư nợ quá hạn T+10 tháng trước
			$date = getdate();
			$month = $date['mon'];
			$month_thang_nay = $date['mon'] - 1;
			$month_thang_truoc = $date['mon'] - 1;
			$year = $date['year'];
			if ($date['mon'] == 1) {
				$month_thang_nay = 12;
				$month_thang_truoc = 12;
				$year = $date['year'] - 1;
			}
			if ($date['mon'] < 10) {
				$month = "0" . $month;
			}


			$start_thang_truoc = !empty($month_thang_truoc) ? date("$year-$month_thang_truoc-01") : date('Y-m-01');
			$end_thang_truoc = !empty($month_thang_truoc) ? date("$year-$month_thang_truoc-t") : date('Y-m-d');

			$start_thang_nay = !empty($date['mon']) ? date("Y-$month_thang_nay-01") : date('Y-m-01');
			$end_thang_nay = !empty($date['mon']) ? date("Y-$month_thang_nay-d") : date('Y-m-d');

			$condition_thang_truoc = array(
				'$gte' => strtotime(trim($start_thang_truoc) . ' 00:00:00'),
				'$lte' => strtotime(trim($end_thang_truoc) . ' 23:59:59')
			);
			$condition_thang_nay = array(
				'$gte' => strtotime(trim($start_thang_nay) . ' 00:00:00'),
				'$lte' => strtotime(trim($end_thang_nay) . ' 23:59:59')
			);
		}
		$year = date('Y');
		$rk = new Report_kpi_model();
		$rku = new Report_kpi_user_model();
		$rktp = new Report_kpi_top_pgd_model();
		$contract = new Contract_model();
		$rkcpm = new Report_kpi_commission_pgd_model();
		$rkcum = new Report_kpi_commission_user_model();
		$kpigdv = new Kpi_gdv_model();
		$kpipgd = new Kpi_pgd_model();

		$debt_store = new Debt_store_model();

		$data = [];
		$user_cht = $this->getGroupRole_cht();
		$stores = $this->store_model->find_where(["status" => "active"]);
		$stores_for = [];

		if (!empty($stores)) {
			foreach ($stores as $value) {
				$store_name = $this->store_model->findOne(array('_id' => new MongoDB\BSON\ObjectId((string)$value['_id'])));
				if (!empty($store_name)) {
					$stores_for += [$store_name['name'] => $value];
				}
			}
		}

		$count = 0;
		$kpi_du_no = 0;
		$kpi_bao_hiem = 0;
		foreach ($stores_for as $key => $item) {
			$kpi_du_no = 0;
			$kpi_bao_hiem = 0;
			$kpi_giai_ngan = 0;
			$kpi_nha_dau_tu = 0;

			$stores = [(string)$item['_id']];

			$data[$count]['store_name'] = $item['name'];

			$getPhoneUserChtByStore = $this->getPhoneByCht($item, $user_cht);
			$phone_user = $this->getPhoneStore($stores);
			$total_nha_dau_tu = $this->callApiInvest(['year' => date('Y'), 'month' => date('m'), 'phone' => $phone_user], '/commission_group_cvkd');
			if($total_nha_dau_tu->status == 200 && !empty($total_nha_dau_tu)){
				$data[$count]['total_nha_dau_tu'] = $total_nha_dau_tu->data->total;
			}
			$total_nha_dau_tu = $this->callApiInvest(['year' => date('Y'), 'month' => date('m'), 'phone' => $getPhoneUserChtByStore], '/commission_cvkd');
			if($total_nha_dau_tu->status == 200 && !empty($total_nha_dau_tu)){
				$tien_hoa_hong_nha_dau_tu = $total_nha_dau_tu->data->total->money_commission_number;
			}
			$data[$count]['chi_tieu_nha_dau_tu'] = $rk->sum_where_total(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)],'$kpi.nha_dau_tu');


			//du_no_tang_net
			$total_du_no_trong_han_t10_hien_tai = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'store.id' => array('$in' => $stores), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old,  'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');
			$total_du_no_oto_va_nha_dat_hien_tai = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'store.id' => array('$in' => $stores), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old,  'tat_toan_gh' => array('$exists' => false)], '$debt.kpi_tong_tien_goc_con');
			$total_du_no_trong_han_t10_1 = $total_du_no_trong_han_t10_hien_tai;


			$total_du_no_trong_han_t10_2 = $debt_store->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'created_at' => $condition_thang_truoc], '$total_du_no_trong_han_t10_old');

			$data[$count]['total_du_no_trong_han_t10'] = $total_du_no_trong_han_t10_1 - $total_du_no_trong_han_t10_2;

			//Chỉ tiêu dư nợ tăng net
			$data[$count]['chi_tieu_du_no_tang_net'] = $kpipgd->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)], '$du_no_CT');
			$du_no_tt = $kpipgd->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)], '$du_no_TT');
			$tt_bao_hiem = $kpipgd->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)], '$bao_hiem_TT');

			//doanh_so_bao_hiem
			$data[$count]['total_doanh_so_bao_hiem'] = $rkcpm->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'san_pham' => 'BH', 'created_at' => $condition_lead], '$commision.doanh_so');

			//chỉ tiêu bảo hiểm
			$data[$count]['chi_tieu_bao_hiem'] = $kpipgd->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)], '$bao_hiem_CT');

			//Chỉ tiêu giải ngân
			$chi_tieu_giai_ngan = $rk->sum_where_total(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)],'$total_giai_ngan_chi_tieu_ti_trong');

			//Tiền giải ngân mới trong tháng
			$data[$count]['total_so_tien_vay'] = $contract->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'disbursement_date' => $condition_lead, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 37, 38, 39, 41, 42, 19, 33, 34])], array('$toLong' => '$loan_infor.amount_money'));
			$data[$count]['chi_tieu_giai_ngan'] = $kpipgd->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)], '$giai_ngan_CT');
			$giai_ngan_tt = $kpipgd->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)], '$giai_ngan_TT');
			//Kpi
			if (!empty($data[$count]['chi_tieu_du_no_tang_net']) && $data[$count]['chi_tieu_du_no_tang_net'] != 0) {
				$kpi_du_no = round(($data[$count]['total_du_no_trong_han_t10'] / $data[$count]['chi_tieu_du_no_tang_net']) * $du_no_tt);
			}
			if (!empty($data[$count]['chi_tieu_bao_hiem']) && $data[$count]['chi_tieu_bao_hiem'] != 0) {
				$kpi_bao_hiem = round(($data[$count]['total_doanh_so_bao_hiem'] / $data[$count]['chi_tieu_bao_hiem']) * $tt_bao_hiem);
			}
			if (!empty($data[$count]['chi_tieu_giai_ngan']) && $data[$count]['chi_tieu_giai_ngan'] != 0) {
				$kpi_giai_ngan = round(($chi_tieu_giai_ngan / $data[$count]['chi_tieu_giai_ngan']) * $giai_ngan_tt);
			}
			if (!empty($data[$count]['chi_tieu_nha_dau_tu']) && $data[$count]['chi_tieu_nha_dau_tu'] != 0) {
				$kpi_nha_dau_tu = round(($data[$count]['total_nha_dau_tu'] / $data[$count]['chi_tieu_nha_dau_tu']) * 10);
			}

			if ($kpi_du_no > 40) {
				$kpi_du_no = 40;
			} elseif ($kpi_du_no < 0){
				$kpi_du_no = 0;
			}
			if ($kpi_bao_hiem > 40) {
				$kpi_bao_hiem = 40;
			}
			if ($kpi_giai_ngan > 40) {
				$kpi_giai_ngan = 40;
			}
			if ($kpi_nha_dau_tu > 20) {
				$kpi_nha_dau_tu = 20;
			}

			$data[$count]['kpi'] = $kpi_du_no + $kpi_bao_hiem + $kpi_giai_ngan + $kpi_nha_dau_tu;

			//Tiền hoa hồng
			$hoa_hong_tu_kiem = $rkcum->sum_where_total_mongo_read(['store.id' => array('$in' => $stores) ,'created_at' => $condition_lead, 'user' => ['$in' => $user_cht]], '$commision.tien_hoa_hong');
			$hoa_hong_truong_phong = $rkcpm->sum_where_total(['created_at' => $condition_lead,'san_pham' => "HDV",'store.id' => array('$in' => $stores)], '$commision.tien_hoa_hong');
			$total_tien_hoa_hong_hdv = $hoa_hong_tu_kiem + $hoa_hong_truong_phong;


			if($data[$count]['kpi'] >= 60 && $data[$count]['kpi'] < 80){
				$tong_tien_hoa_hong = ($total_tien_hoa_hong_hdv + ($data[$count]['total_du_no_trong_han_t10'] * 0.2/100) + ($total_du_no_trong_han_t10_1 * 0.03/100)) * 0.6 ;
			} elseif ($data[$count]['kpi'] >= 80 && $data[$count]['kpi'] < 100){
				$tong_tien_hoa_hong = ($total_tien_hoa_hong_hdv + ($data[$count]['total_du_no_trong_han_t10'] * 0.2/100) + ($total_du_no_trong_han_t10_1 * 0.03/100)) * 0.8 ;
			} elseif ($data[$count]['kpi'] >= 100 && $data[$count]['kpi'] < 120){
				$tong_tien_hoa_hong = ($total_tien_hoa_hong_hdv + ($data[$count]['total_du_no_trong_han_t10'] * 0.2/100) + ($total_du_no_trong_han_t10_1 * 0.03/100)) * 1 ;
			} elseif ($data[$count]['kpi'] >= 120){
				$tong_tien_hoa_hong = ($total_tien_hoa_hong_hdv + ($data[$count]['total_du_no_trong_han_t10'] * 0.2/100) + ($total_du_no_trong_han_t10_1 * 0.03/100)) * 1.2 ;
			} else {
				$tong_tien_hoa_hong = 0;
			}

			$data[$count]['total_tien_hoa_hong'] = $tong_tien_hoa_hong + $tien_hoa_hong_nha_dau_tu;

			//dư nợ trong hạn T+10
			$data[$count]['total_du_no_trong_han_t10_old'] = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false), 'store.id' => array('$in' => $stores)], '$debt.tong_tien_goc_con');
			$data[$count]['total_du_no_trong_han_t10_thang_truoc'] = $debt_store->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'created_at' => $condition_thang_truoc], '$total_du_no_trong_han_t10_old');

			$count++;
		}

		if ($data) {
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'data' => $data
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
	}

	public function exportKpiASM_post()
	{

		$data = $this->input->post();
		$start_old = '2019-11-01';
		$start = !empty($data['start']) ? $data['start'] : date('Y-m-01');
		$end = !empty($data['end']) ? $data['end'] : date('2030-m-d');
		$condition = array();
		$condition_lead = array();
		$user_cht = $this->getGroupRole_cht();
		$start_search = !empty($data['start']) ? $data['start'] : '2019-11-01';

		if (!empty($start) && !empty($end)) {
			$condition_old = array(
				'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);
			$condition_lead = array(
				'$gte' => strtotime(trim($start) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);
			$condition_search_old = array(
				'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
				'$lte' => strtotime(trim(date('Y-m-d')) . ' 23:59:59')
			);

			//Dư nợ quá hạn T+10 tháng trước
			$date = getdate();
			$month = $date['mon'];
			$month_thang_nay = $date['mon'] - 1;
			$month_thang_truoc = $date['mon'] - 1;
			$year = $date['year'];
			if ($date['mon'] == 1) {
				$month_thang_nay = 12;
				$month_thang_truoc = 12;
				$year = $date['year'] - 1;
			}
			if ($date['mon'] < 10) {
				$month = "0" . $month;
			}

			$start_thang_truoc = !empty($month_thang_truoc) ? date("$year-$month_thang_truoc-01") : date('Y-m-01');
			$end_thang_truoc = !empty($month_thang_truoc) ? date("$year-$month_thang_truoc-t") : date('Y-m-d');

			$start_thang_nay = !empty($date['mon']) ? date("Y-$month_thang_nay-01") : date('Y-m-01');
			$end_thang_nay = !empty($date['mon']) ? date("Y-$month_thang_nay-d") : date('Y-m-d');

			$condition_thang_truoc = array(
				'$gte' => strtotime(trim($start_thang_truoc) . ' 00:00:00'),
				'$lte' => strtotime(trim($end_thang_truoc) . ' 23:59:59')
			);
			$condition_thang_nay = array(
				'$gte' => strtotime(trim($start_thang_nay) . ' 00:00:00'),
				'$lte' => strtotime(trim($end_thang_nay) . ' 23:59:59')
			);
		}
		$year = date('Y');
		$rk = new Report_kpi_model();
		$rku = new Report_kpi_user_model();
		$rktp = new Report_kpi_top_pgd_model();
		$contract = new Contract_model();
		$rkcpm = new Report_kpi_commission_pgd_model();
		$rkcum = new Report_kpi_commission_user_model();
		$kpigdv = new Kpi_gdv_model();
		$kpipgd = new Kpi_pgd_model();
		$kpi_asm = new Kpi_area_model();

		$debt_store = new Debt_store_model();

		$data = [];

		$area = $this->area_model->find_where(["status" => "active"]);
		$code_area = [];
		if (!empty($area)) {
			foreach ($area as $value) {
				if ($value['code'] == "Priority" || $value['code'] == "NextPay") {
					continue;
				}

				$code_area += [(string)$value['_id'] => $value['code']];
			}
		}


		$count = 0;
		$kpi_du_no = 0;
		$kpi_bao_hiem = 0;

		foreach ($code_area as $key => $item) {
			$kpi_du_no = 0;
			$kpi_bao_hiem = 0;
			$kpi_giai_ngan = 0;
			$kpi_nha_dau_tu = 0;

			$stores = $this->getStores_list_detail($item);

			$data[$count]['store_name'] = $item;

			//
			$user_phone = $this->getPhoneArea($item);
			$total_nha_dau_tu = $this->callApiInvest(['year' => date('Y'), 'month' => date('m'), 'phone' => $user_phone], '/commission_cvkd');
			if($total_nha_dau_tu->status == 200 && !empty($total_nha_dau_tu)){
				$tien_hoa_hong_nha_dau_tu = $total_nha_dau_tu->data->total->money_commission_number;
			}


			//du_no_tang_net
			$total_du_no_trong_han_t10_hien_tai = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'store.id' => array('$in' => $stores), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');
			$total_du_no_oto_va_nha_dat_hien_tai = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'store.id' => array('$in' => $stores), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false)], '$debt.kpi_tong_tien_goc_con');
			$total_du_no_trong_han_t10_1 = $total_du_no_trong_han_t10_hien_tai;


			$total_du_no_trong_han_t10_2 = $debt_store->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'created_at' => $condition_thang_truoc], '$total_du_no_trong_han_t10_old');

			$data[$count]['total_du_no_trong_han_t10'] = $total_du_no_trong_han_t10_1 - $total_du_no_trong_han_t10_2;

			//Chỉ tiêu dư nợ tăng net
			$data[$count]['chi_tieu_du_no_tang_net'] = $kpi_asm->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'area.id' => $key], '$du_no_CT');
			$du_no_tt = $kpi_asm->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'area.id' => $key], '$du_no_TT');
			$tt_bao_hiem = $kpi_asm->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'area.id' => $key], '$bao_hiem_TT');


			//doanh_so_bao_hiem
			$data[$count]['total_doanh_so_bao_hiem'] = $rkcpm->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'san_pham' => 'BH', 'created_at' => $condition_lead], '$commision.doanh_so');

			//chỉ tiêu bảo hiểm
			$data[$count]['chi_tieu_bao_hiem'] = $kpi_asm->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'area.id' => $key], '$bao_hiem_CT');

			//Tiền giải ngân mới trong tháng
			$data[$count]['total_so_tien_vay'] = $contract->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'disbursement_date' => $condition_lead, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 37, 38, 39, 41, 42, 19, 33, 34])], array('$toLong' => '$loan_infor.amount_money'));
			$data[$count]['chi_tieu_giai_ngan'] = $kpi_asm->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'area.id' => $key], '$giai_ngan_CT');
			$giai_ngan_tt = $kpi_asm->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'area.id' => $key], '$giai_ngan_TT');

			//Nhà đầu tư
			$data[$count]['chi_tieu_nha_dau_tu'] = $kpi_asm->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'area.id' => $key], '$nha_dau_tu');
			$TT_nha_dau_tu = $kpi_asm->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'area.id' => $key], '$nha_dau_tu_TT');
			$phone_user = $this->getPhoneStore($stores, $user_phone);

			$total_nha_dau_tu = $this->callApiInvest(['year' => date('Y'), 'month' => date('m'), 'phone' => $phone_user], '/commission_group_cvkd');
			if($total_nha_dau_tu->status == 200 && !empty($total_nha_dau_tu)){
				$data[$count]['tong_tien_dau_tu'] = $total_nha_dau_tu->data->total;
			}

			//Kpi
			if (!empty($data[$count]['chi_tieu_du_no_tang_net']) && $data[$count]['chi_tieu_du_no_tang_net'] != 0) {
				$kpi_du_no = round(($data[$count]['total_du_no_trong_han_t10'] / $data[$count]['chi_tieu_du_no_tang_net']) * $du_no_tt);
			}
			if (!empty($data[$count]['chi_tieu_bao_hiem']) && $data[$count]['chi_tieu_bao_hiem'] != 0) {
				$kpi_bao_hiem = round(($data[$count]['total_doanh_so_bao_hiem'] / $data[$count]['chi_tieu_bao_hiem']) * $tt_bao_hiem);
			}
			if (!empty($data[$count]['chi_tieu_giai_ngan']) && $data[$count]['chi_tieu_giai_ngan'] != 0) {
				$kpi_giai_ngan = round(($data[$count]['total_so_tien_vay'] / $data[$count]['chi_tieu_giai_ngan']) * $giai_ngan_tt);
			}
			if (!empty($data[$count]['chi_tieu_nha_dau_tu']) && $data[$count]['chi_tieu_nha_dau_tu'] != 0) {
				$kpi_nha_dau_tu = round(($data[$count]['tong_tien_dau_tu'] / $data[$count]['chi_tieu_nha_dau_tu']) * $TT_nha_dau_tu);
			}

			if ($kpi_du_no > 40) {
				$kpi_du_no = 40;
			} elseif ($kpi_du_no < 0){
				$kpi_du_no = 0;
			}
			if ($kpi_bao_hiem > 40) {
				$kpi_bao_hiem = 40;
			}
			if ($kpi_giai_ngan > 40) {
				$kpi_giai_ngan = 40;
			}
			if ($kpi_nha_dau_tu > 20) {
				$kpi_nha_dau_tu = 20;
			}

			$data[$count]['kpi'] = $kpi_du_no + $kpi_bao_hiem + $kpi_giai_ngan + $kpi_nha_dau_tu;
			$total_tien_hoa_hong = 0;
			//Tiền hoa hồng
			if (isset($data[$count]['kpi'])) {
				if ($data[$count]['kpi'] >= 80 && $data[$count]['kpi'] < 90) {
					$total_tien_hoa_hong = 5000000;
				} elseif ($data[$count]['kpi'] >= 90 && $data[$count]['kpi'] < 95) {
					$total_tien_hoa_hong = 7000000;
				} elseif ($data[$count]['kpi'] >= 95 && $data[$count]['kpi'] < 110) {
					$total_tien_hoa_hong = 10000000;
				} elseif ($data[$count]['kpi'] >= 110) {
					$total_tien_hoa_hong = 12000000;
				}
			}
			$data[$count]['total_tien_hoa_hong'] = $total_tien_hoa_hong + $tien_hoa_hong_nha_dau_tu;


			//dư nợ trong hạn T+10
			$data[$count]['total_du_no_trong_han_t10_old'] = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false), 'store.id' => array('$in' => $stores)], '$debt.tong_tien_goc_con');
			$data[$count]['total_du_no_trong_han_t10_thang_truoc'] = $debt_store->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'store.id' => array('$in' => $stores), 'created_at' => $condition_thang_truoc], '$total_du_no_trong_han_t10_old');

			$count++;
		}

		if ($data) {
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'data' => $data
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

	}

	public function exportKpiRSM_post()
	{

		$data = $this->input->post();
		$start_old = '2019-11-01';
		$start = !empty($data['start']) ? $data['start'] : date('Y-m-01');
		$end = !empty($data['end']) ? $data['end'] : date('2030-m-d');
		$condition = array();
		$condition_lead = array();

		$start_search = !empty($data['start']) ? $data['start'] : '2019-11-01';

		if (!empty($start) && !empty($end)) {
			$condition_old = array(
				'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);
			$condition_lead = array(
				'$gte' => strtotime(trim($start) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);
			$condition_search_old = array(
				'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
				'$lte' => strtotime(trim(date('Y-m-d')) . ' 23:59:59')
			);

			//Dư nợ quá hạn T+10 tháng trước
			$date = getdate();
			$month = $date['mon'];
			$month_thang_nay = $date['mon'] - 1;
			$month_thang_truoc = $date['mon'] - 1;
			$year = $date['year'];
			if ($date['mon'] == 1) {
				$month_thang_nay = 12;
				$month_thang_truoc = 12;
				$year = $date['year'] - 1;
			}
			if ($date['mon'] < 10) {
				$month = "0" . $month;
			}

			$start_thang_truoc = !empty($month_thang_truoc) ? date("$year-$month_thang_truoc-01") : date('Y-m-01');
			$end_thang_truoc = !empty($month_thang_truoc) ? date("$year-$month_thang_truoc-t") : date('Y-m-d');

			$start_thang_nay = !empty($date['mon']) ? date("Y-$month_thang_nay-01") : date('Y-m-01');
			$end_thang_nay = !empty($date['mon']) ? date("Y-$month_thang_nay-d") : date('Y-m-d');

			$condition_thang_truoc = array(
				'$gte' => strtotime(trim($start_thang_truoc) . ' 00:00:00'),
				'$lte' => strtotime(trim($end_thang_truoc) . ' 23:59:59')
			);
			$condition_thang_nay = array(
				'$gte' => strtotime(trim($start_thang_nay) . ' 00:00:00'),
				'$lte' => strtotime(trim($end_thang_nay) . ' 23:59:59')
			);
		}
		$year = date('Y');
		$rk = new Report_kpi_model();
		$rku = new Report_kpi_user_model();
		$rktp = new Report_kpi_top_pgd_model();
		$contract = new Contract_model();
		$rkcpm = new Report_kpi_commission_pgd_model();
		$rkcum = new Report_kpi_commission_user_model();
		$kpigdv = new Kpi_gdv_model();
		$kpipgd = new Kpi_pgd_model();
		$kpi_asm = new Kpi_area_model();

		$debt_store = new Debt_store_model();

		$data = [];

		$user_rsm = $this->getGroupRole_rsm();

		$count = 0;
		$kpi_du_no = 0;
		$kpi_bao_hiem = 0;

		foreach ($user_rsm as $key => $item) {
			$kpi_du_no = 0;
			$kpi_bao_hiem = 0;
			$kpi_giai_ngan = 0;
			$kpi_nha_dau_tu = 0;

			$stores = $this->getStores_list($key);
			$data[$count]['store_name'] = $item;

			$user_phone = $this->getPhoneUserEmail($item);
			$total_nha_dau_tu = $this->callApiInvest(['year' => date('Y'), 'month' => date('m'), 'phone' => $user_phone], '/commission_cvkd');
			if($total_nha_dau_tu->status == 200 && !empty($total_nha_dau_tu)){
				$tien_hoa_hong_nha_dau_tu = $total_nha_dau_tu->data->total->money_commission_number;
			}

			//du_no_tang_net
			$total_du_no_trong_han_t10_hien_tai = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'store.id' => array('$in' => $stores), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');
			$total_du_no_oto_va_nha_dat_hien_tai = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'store.id' => array('$in' => $stores), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false)], '$debt.kpi_tong_tien_goc_con');
			$total_du_no_trong_han_t10_1 = $total_du_no_trong_han_t10_hien_tai;

			$total_du_no_trong_han_t10_2 = $debt_store->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'created_at' => $condition_thang_truoc], '$total_du_no_trong_han_t10_old');

			$data[$count]['total_du_no_trong_han_t10'] = $total_du_no_trong_han_t10_1 - $total_du_no_trong_han_t10_2;

			//Chỉ tiêu dư nợ tăng net
			$data[$count]['chi_tieu_du_no_tang_net'] = $kpipgd->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)], '$du_no_CT');
//			$du_no_tt = $kpipgd->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)], '$du_no_TT');
//			$tt_bao_hiem = $kpipgd->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)], '$bao_hiem_TT');


			//doanh_so_bao_hiem
			$data[$count]['total_doanh_so_bao_hiem'] = $rkcpm->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'san_pham' => 'BH', 'created_at' => $condition_lead], '$commision.doanh_so');


			//chỉ tiêu bảo hiểm
			$data[$count]['chi_tieu_bao_hiem'] = $kpipgd->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)], '$bao_hiem_CT');

			//Tiền giải ngân mới trong tháng
			$data[$count]['total_so_tien_vay'] = $contract->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'disbursement_date' => $condition_lead, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 37, 38, 39, 41, 42, 19, 33, 34])], array('$toLong' => '$loan_infor.amount_money'));
			$data[$count]['chi_tieu_giai_ngan'] = $kpipgd->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)], '$giai_ngan_CT');
//			$giai_ngan_tt = $kpipgd->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)], '$giai_ngan_TT');

			//Hoa hồng nhà đầu tư
			$data[$count]['chi_tieu_nha_dau_tu'] = $kpipgd->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)], '$nha_dau_tu');
			$TT_nha_dau_tu = $kpipgd->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)], '$nha_dau_tu_TT');
			$phone_user = $this->getPhoneStore($stores, $user_phone);
			$total_nha_dau_tu = $this->callApiInvest(['year' => date('Y'), 'month' => date('m'), 'phone' => $phone_user], '/commission_group_cvkd');
			if($total_nha_dau_tu->status == 200 && !empty($total_nha_dau_tu)){
				$data[$count]['tong_tien_dau_tu'] = $total_nha_dau_tu->data->total;
			}


			//Kpi
			if (!empty($data[$count]['chi_tieu_du_no_tang_net']) && $data[$count]['chi_tieu_du_no_tang_net'] != 0) {
				$kpi_du_no = round(($data[$count]['total_du_no_trong_han_t10'] / $data[$count]['chi_tieu_du_no_tang_net']) * 30);
			}
			if (!empty($data[$count]['chi_tieu_bao_hiem']) && $data[$count]['chi_tieu_bao_hiem'] != 0) {
				$kpi_bao_hiem = round(($data[$count]['total_doanh_so_bao_hiem'] / $data[$count]['chi_tieu_bao_hiem']) * 30);
			}
			if (!empty($data[$count]['chi_tieu_giai_ngan']) && $data[$count]['chi_tieu_giai_ngan'] != 0) {
				$kpi_giai_ngan = round(($data[$count]['total_so_tien_vay'] / $data[$count]['chi_tieu_giai_ngan']) * 30);
			}
			if (!empty($data[$count]['chi_tieu_nha_dau_tu']) && $data[$count]['chi_tieu_nha_dau_tu'] != 0) {
				$kpi_nha_dau_tu = round(($data[$count]['tong_tien_dau_tu'] / $data[$count]['chi_tieu_nha_dau_tu']) * 10);
			}

			if ($kpi_du_no > 40) {
				$kpi_du_no = 40;
			} elseif ($kpi_du_no < 0){
				$kpi_du_no = 0;
			}
			if ($kpi_bao_hiem > 40) {
				$kpi_bao_hiem = 40;
			}
			if ($kpi_giai_ngan > 40) {
				$kpi_giai_ngan = 40;
			}
			if ($kpi_nha_dau_tu > 20) {
				$kpi_nha_dau_tu = 20;
			}

			$data[$count]['kpi'] = $kpi_du_no + $kpi_bao_hiem + $kpi_giai_ngan + $kpi_nha_dau_tu;

			//Tiền hoa hồng
			$total_tien_hoa_hong = 0;
			if (isset($data[$count]['kpi'])) {
				if ($data[$count]['kpi'] >= 80 && $data[$count]['kpi'] < 90) {
					$total_tien_hoa_hong = 8000000;
				} elseif ($data[$count]['kpi'] >= 90 && $data[$count]['kpi'] < 95) {
					$total_tien_hoa_hong = 10000000;
				} elseif ($data[$count]['kpi'] >= 95 && $data[$count]['kpi'] < 110) {
					$total_tien_hoa_hong = 13000000;
				} elseif ($data[$count]['kpi'] >= 110) {
					$total_tien_hoa_hong = 15000000;
				}

			}
			$data[$count]['total_tien_hoa_hong'] = $total_tien_hoa_hong + $tien_hoa_hong_nha_dau_tu;

			//dư nợ trong hạn T+10
			$data[$count]['total_du_no_trong_han_t10_old'] = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false), 'store.id' => array('$in' => $stores)], '$debt.tong_tien_goc_con');
			$data[$count]['total_du_no_trong_han_t10_thang_truoc'] = $debt_store->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'store.id' => array('$in' => $stores), 'created_at' => $condition_thang_truoc], '$total_du_no_trong_han_t10_old');

			$count++;
		}

		if ($data) {
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'data' => $data
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}


	}


	public function cron_du_no_tang_net_user_post()
	{

		$start_old = '2018-11-01';

		$end = !empty($data['end']) ? $data['end'] : date('2030-m-d');

		$condition_old = array(
			'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
			'$lte' => strtotime(trim($end) . ' 23:59:59')
		);

		$contract = new Contract_model();
		$debt_user = new Debt_user_model();

		$data_report = [];

		$list_user_pgd = $this->getGroupRole_gdv();


		if (!empty($list_user_pgd)) {
			foreach ($list_user_pgd as $value) {
				$data_report['month'] = date('m');
				$data_report['year'] = date('Y');
				$data_report['user'] = $value;

				$data_report['total_du_no_trong_han_t10_old'] = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']], 'status' => array('$in' => list_array_trang_thai_dang_vay()), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false), 'created_by' => $value], '$debt.tong_tien_goc_con');

				$data_report['created_at'] = strtotime(date('Y-m-20'));


				$debt_user->insert($data_report);
			}
		}
		echo "cron ok";
	}

	public function cron_du_no_store_post()
	{

		$start_old = '2018-11-01';

		$end = !empty($data['end']) ? $data['end'] : date('2030-m-d');

		$condition_old = array(
			'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
			'$lte' => strtotime(trim($end) . ' 23:59:59')
		);

		$contract = new Contract_model();
		$debt_du_no = new Debt_du_no_model();

		$data_report = [];

		$data_report['month'] = date('m');
		$data_report['year'] = date('Y');

		$data_report['total_du_no_trong_han_t10_old'] = $contract->sum_where_total(['status' => array('$in' => list_array_trang_thai_dang_vay()), 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');

		$data_report['created_at'] = strtotime(date('Y-m-20'));
//		$data_report['created_at'] = strtotime(date('2022-10-20'));

		$debt_du_no->insert($data_report);


		echo "cron ok";
	}

	public function cron_du_no_tang_net_store_post()
	{

		$start_old = '2018-11-01';

		$end = !empty($data['end']) ? $data['end'] : date('2030-m-d');

		$condition_old = array(
			'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
			'$lte' => strtotime(trim($end) . ' 23:59:59')
		);

		$contract = new Contract_model();
		$debt_store = new Debt_store_model();

		$stores = $this->store_model->find_where_in('status', ['active']);

		if (!empty($stores)) {
			foreach ($stores as $value) {
				$data_report['month'] = date('m');
				$data_report['year'] = date('Y');
				$data_report['store'] = array('id' => (string)$value['_id'], 'name' => $value['name']);

				$stores = [(string)$value['_id']];

				$data_report['total_du_no_trong_han_t10_old'] = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']], 'status' => array('$in' => list_array_trang_thai_dang_vay()), 'store.id' => array('$in' => $stores), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');

				$data_report['created_at'] = strtotime(date('Y-m-20'));

				$debt_store->insert($data_report);
			}
		}

		echo "cron ok";


	}


	public function exportAllDuNo_post()
	{

//		$start = '2019-11-01';
//		$end = '2021-9-30';
		$data = $this->input->post();
		$start = !empty($data['start']) ? $data['start'] : date('Y-m-01');
		$end = !empty($data['end']) ? $data['end'] : date('Y-m-d');

		if (!empty($start)) {
			$condition['start'] = strtotime(trim($start) . ' 00:00:00');
		}
		if (!empty($end)) {
			$condition['end'] = strtotime(trim($end) . ' 23:59:59');
		}

		$contract = $this->contract_model->exportAllContract($condition);

		if ($contract) {
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'data' => $contract
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
	}

	public function cron_duno_gh_cc_post()
	{

		$contractData = $this->contract_model->find_cron_du_no();

		if (!empty($contractData)) {
			foreach ($contractData as $value) {
				if (!empty($value['code_contract_child_gh'])) {
					$code_contract_disbursement = $value['code_contract_child_gh'][count($value['code_contract_child_gh'])];
					if (!empty($code_contract_disbursement)) {
						$contract = $this->contract_model->findOne_code(['code_contract_disbursement' => $code_contract_disbursement]);
						if (!empty($contract) && $contract['status'] == 19) {
							$this->contract_model->update(array("_id" => new \MongoDB\BSON\ObjectId((string)$value['_id'])), ["tat_toan_gh" => 1]);
						}
					}
				}
			}
		}

		echo "cron_oke";

	}

	public function view_payroll_cvkd_post()
	{

		$data = $this->input->post();
		$start_old = '2019-11-01';
		$start = !empty($data['start']) ? $data['start'] : date('Y-m-01');
		$end = !empty($data['end']) ? $data['end'] : date('2030-m-d');
		$condition = array();
		$condition_lead = array();

		if (!empty($start) && !empty($end)) {
			$condition_old = array(
				'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);
			$condition_lead = array(
				'$gte' => strtotime(trim($start) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);

			//Dư nợ quá hạn T+10 tháng trước
			$date = getdate();
			$month = $date['mon'];
			$month_thang_nay = $date['mon'] - 1;
			$month_thang_truoc = $date['mon'] - 1;
			$year = $date['year'];
			if ($date['mon'] == 1) {
				$month_thang_nay = 12;
				$month_thang_truoc = 12;
				$year = $date['year'] - 1;
			}
			if ($date['mon'] < 10) {
				$month = "0" . $month;
			}

			$start_thang_truoc = !empty($month_thang_truoc) ? date("$year-$month_thang_truoc-01") : date('Y-m-01');
			$end_thang_truoc = !empty($month_thang_truoc) ? date("$year-$month_thang_truoc-t") : date('Y-m-d');

			$condition_thang_truoc = array(
				'$gte' => strtotime(trim($start_thang_truoc) . ' 00:00:00'),
				'$lte' => strtotime(trim($end_thang_truoc) . ' 23:59:59')
			);

		}
		$year = date('Y');
		$contract = new Contract_model();

		$rkcum = new Report_kpi_commission_user_model();
		$kpigdv = new Kpi_gdv_model();

		$debt_user = new Debt_user_model();

		$data = [];

		$list_user_pgd = [$this->uemail];

		$count = 0;

		foreach ($list_user_pgd as $key => $item) {
			$kpi_du_no = 0;
			$kpi_bao_hiem = 0;
			$kpi_giai_ngan = 0;
			$kpi_nha_dau_tu = 0;
			$list_store_name = [];

			$data[$count]['created_by'] = $item;

			//Chỉ tiêu nhà đầu tư
			$data[$count]['chi_tieu_nha_dau_tu'] = $kpigdv->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'email_gdv' => $item], '$nha_dau_tu');
			$tt_nha_dau_tu = $kpigdv->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'email_gdv' => $item], '$nha_dau_tu_TT');

			//Hoa hồng nhà đầu tư
			$data_phone = $this->getPhoneUserEmail($item);
			$total_nha_dau_tu = $this->callApiInvest(['year' => date('Y'), 'month' => date('m'), 'phone' => $data_phone], '/commission_cvkd');
			if($total_nha_dau_tu->status == 200 && !empty($total_nha_dau_tu)){
				$tien_hoa_hong_nha_dau_tu  = $total_nha_dau_tu->data->total->money_commission_number;
				$data[$count]['total_nha_dau_tu'] = $total_nha_dau_tu->data->total->total_money_number;
			}


			//du_no_tang_net
			$total_du_no_trong_han_t10_hien_tai = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'created_by' => $item, 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old,  'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');
			$total_du_no_oto_va_nha_dat_hien_tai = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'created_by' => $item, 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old,  'tat_toan_gh' => array('$exists' => false)], '$debt.kpi_tong_tien_goc_con');
			$total_du_no_trong_han_t10_1 = $total_du_no_trong_han_t10_hien_tai;


			$total_du_no_trong_han_t10_2 = $debt_user->sum_where_total_mongo_read(['user' => $item, 'created_at' => $condition_thang_truoc], '$total_du_no_trong_han_t10_old');

			$data[$count]['total_du_no_trong_han_t10'] = $total_du_no_trong_han_t10_1 - $total_du_no_trong_han_t10_2;

			//Chỉ tiêu dư nợ tăng net
			$data[$count]['chi_tieu_du_no_tang_net'] = $kpigdv->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'email_gdv' => $item], '$du_no_CT');
			$du_no_tt = $kpigdv->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'email_gdv' => $item], '$du_no_TT');
			$tt_bao_hiem = $kpigdv->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'email_gdv' => $item], '$bao_hiem_TT');

			//doanh_so_bao_hiem
			$data[$count]['total_doanh_so_bao_hiem'] = $rkcum->sum_where_total_mongo_read(['user' => $item, 'san_pham' => 'BH', 'created_at' => $condition_lead], '$commision.doanh_so');


			//chỉ tiêu bảo hiểm
			$data[$count]['chi_tieu_bao_hiem'] = $kpigdv->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'email_gdv' => $item], '$bao_hiem_CT');

			//Tiền giải ngân mới trong tháng
			$data[$count]['total_so_tien_vay'] = $contract->sum_where_total_mongo_read(['created_by' => $item, 'disbursement_date' => $condition_lead, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 37, 38, 39, 41, 42, 19, 33, 34])], array('$toLong' => '$loan_infor.amount_money'));
			$data[$count]['chi_tieu_giai_ngan'] = $kpigdv->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'email_gdv' => $item], '$giai_ngan_CT');
			$giai_ngan_tt = $kpigdv->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'email_gdv' => $item], '$giai_ngan_TT');

			//Chỉ tiêu giải ngân
			$chi_tieu_giai_ngan = $this->report_kpi_user_model->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'kpi' => ['$nin' => [false]] ,'user_email' => $item],'$total_giai_ngan_chi_tieu_ti_trong');

			//Kpi
			if (!empty($data[$count]['chi_tieu_du_no_tang_net']) && $data[$count]['chi_tieu_du_no_tang_net'] != 0) {
				$kpi_du_no = round(($data[$count]['total_du_no_trong_han_t10'] / $data[$count]['chi_tieu_du_no_tang_net']) * $du_no_tt);
			}
			if (!empty($data[$count]['chi_tieu_bao_hiem']) && $data[$count]['chi_tieu_bao_hiem'] != 0) {
				$kpi_bao_hiem = round(($data[$count]['total_doanh_so_bao_hiem'] / $data[$count]['chi_tieu_bao_hiem']) * $tt_bao_hiem);
			}
			if (!empty($data[$count]['chi_tieu_giai_ngan']) && $data[$count]['chi_tieu_giai_ngan'] != 0) {
				$kpi_giai_ngan = round(($chi_tieu_giai_ngan / $data[$count]['chi_tieu_giai_ngan']) * $giai_ngan_tt);
			}
			if (!empty($data[$count]['chi_tieu_nha_dau_tu']) && $data[$count]['chi_tieu_nha_dau_tu'] != 0) {
				$kpi_nha_dau_tu = round(($data[$count]['total_nha_dau_tu'] / $data[$count]['chi_tieu_nha_dau_tu']) * $tt_nha_dau_tu);
			}

			if ($kpi_du_no > 40) {
				$kpi_du_no = 40;
			} elseif ($kpi_du_no < 0){
				$kpi_du_no = 0;
			}
			if ($kpi_bao_hiem > 40) {
				$kpi_bao_hiem = 40;
			}
			if ($kpi_giai_ngan > 40) {
				$kpi_giai_ngan = 40;
			}
			if ($kpi_nha_dau_tu > 20) {
				$kpi_nha_dau_tu = 20;
			}


			$data[$count]['kpi'] = $kpi_du_no + $kpi_bao_hiem + $kpi_giai_ngan + $kpi_nha_dau_tu;

			//Tiền hoa hồng
			$total_tien_hoa_hong = $rkcum->sum_where_total_mongo_read(['user' => $item, 'san_pham' => 'HDV' ,'created_at' => $condition_lead], '$commision.tien_hoa_hong');
			$total_tien_hoa_hong_bao_hiem = $rkcum->sum_where_total_mongo_read(['user' => $item, 'san_pham' => 'BH' ,'created_at' => $condition_lead], '$commision.tien_hoa_hong');

			//dư nợ trong hạn T+10
			$data[$count]['total_du_no_trong_han_t10_old'] = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false), 'created_by' => $item], '$debt.tong_tien_goc_con');
			$data[$count]['total_du_no_trong_han_t10_thang_truoc'] = $debt_user->sum_where_total_mongo_read(['user' => $item, 'created_at' => $condition_thang_truoc], '$total_du_no_trong_han_t10_old');

			$tong_tien_hoa_hong = 0;
			if($data[$count]['kpi'] >= 60 && $data[$count]['kpi'] < 80){
				$tong_tien_hoa_hong = ($total_tien_hoa_hong + ($data[$count]['total_du_no_trong_han_t10'] * 0.3/100) + ($data[$count]['total_du_no_trong_han_t10_old'] * 0.1/100)) * 0.6 + $total_tien_hoa_hong_bao_hiem;
			} elseif ($data[$count]['kpi'] >= 80 && $data[$count]['kpi'] < 100){
				$tong_tien_hoa_hong = ($total_tien_hoa_hong + ($data[$count]['total_du_no_trong_han_t10'] * 0.3/100) + ($data[$count]['total_du_no_trong_han_t10_old'] * 0.1/100)) * 0.8 + $total_tien_hoa_hong_bao_hiem;
			} elseif ($data[$count]['kpi'] >= 100 && $data[$count]['kpi'] < 120){
				$tong_tien_hoa_hong = ($total_tien_hoa_hong + ($data[$count]['total_du_no_trong_han_t10'] * 0.3/100) + ($data[$count]['total_du_no_trong_han_t10_old'] * 0.1/100)) * 1 + $total_tien_hoa_hong_bao_hiem;
			} elseif ($data[$count]['kpi'] >= 120){
				$tong_tien_hoa_hong = ($total_tien_hoa_hong + ($data[$count]['total_du_no_trong_han_t10'] * 0.3/100) + ($data[$count]['total_du_no_trong_han_t10_old'] * 0.1/100)) * 1.2 + $total_tien_hoa_hong_bao_hiem;
			} else {
				$tong_tien_hoa_hong = $total_tien_hoa_hong_bao_hiem;
			}

			$data[$count]['total_tien_hoa_hong'] = $tong_tien_hoa_hong + $tien_hoa_hong_nha_dau_tu;

			$count++;
		}

		if ($data) {
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'data' => $data
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

	}

	public function view_payroll_store_post()
	{
		$data = $this->input->post();
		$start_old = '2019-11-01';
		$start = !empty($data['start']) ? $data['start'] : date('Y-m-01');
		$end = !empty($data['end']) ? $data['end'] : date('2030-m-d');

		$condition_lead = array();

		if (!empty($start) && !empty($end)) {
			$condition_old = array(
				'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);
			$condition_lead = array(
				'$gte' => strtotime(trim($start) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);

			//Dư nợ quá hạn T+10 tháng trước
			$date = getdate();
			$month = $date['mon'];
			$month_thang_nay = $date['mon'] - 1;
			$month_thang_truoc = $date['mon'] - 1;
			$year = $date['year'];
			if ($date['mon'] == 1) {
				$month_thang_nay = 12;
				$month_thang_truoc = 12;
				$year = $date['year'] - 1;
			}
			if ($date['mon'] < 10) {
				$month = "0" . $month;
			}


			$start_thang_truoc = !empty($month_thang_truoc) ? date("$year-$month_thang_truoc-01") : date('Y-m-01');
			$end_thang_truoc = !empty($month_thang_truoc) ? date("$year-$month_thang_truoc-t") : date('Y-m-d');

			$start_thang_nay = !empty($date['mon']) ? date("Y-$month_thang_nay-01") : date('Y-m-01');
			$end_thang_nay = !empty($date['mon']) ? date("Y-$month_thang_nay-d") : date('Y-m-d');

			$condition_thang_truoc = array(
				'$gte' => strtotime(trim($start_thang_truoc) . ' 00:00:00'),
				'$lte' => strtotime(trim($end_thang_truoc) . ' 23:59:59')
			);

		}
		$year = date('Y');
		$contract = new Contract_model();
		$rkcpm = new Report_kpi_commission_pgd_model();

		$kpipgd = new Kpi_pgd_model();

		$debt_store = new Debt_store_model();
		$rkcum = new Report_kpi_commission_user_model();

		$data = [];

		$stores = $this->store_model->find_where(["status" => "active"]);
		$user_cht = $this->getGroupRole_cht();
		$stores_check = $this->getStores_list($this->id);

		$stores_for = [];

		if (!empty($stores)) {
			foreach ($stores as $value) {
				if (in_array((string)$value['_id'], $stores_check)) {
					$store_name = $this->store_model->findOne(array('_id' => new MongoDB\BSON\ObjectId((string)$value['_id'])));
					if (!empty($store_name)) {
						$stores_for += [$store_name['name'] => $value];
					}
				}
			}
		}

		$count = 0;

		foreach ($stores_for as $key => $item) {
			$kpi_du_no = 0;
			$kpi_bao_hiem = 0;
			$kpi_giai_ngan = 0;
			$kpi_nha_dau_tu = 0;

			$stores = [(string)$item['_id']];

			$data[$count]['store_name'] = $item['name'];

			$getPhoneUserChtByStore = $this->getPhoneByCht($item, $user_cht);
			$phone_user = $this->getPhoneStore($stores);
			$total_nha_dau_tu = $this->callApiInvest(['year' => date('Y'), 'month' => date('m'), 'phone' => $phone_user], '/commission_group_cvkd');
			if($total_nha_dau_tu->status == 200 && !empty($total_nha_dau_tu)){
				$data[$count]['total_nha_dau_tu'] = $total_nha_dau_tu->data->total;
			}
			$total_nha_dau_tu = $this->callApiInvest(['year' => date('Y'), 'month' => date('m'), 'phone' => $getPhoneUserChtByStore], '/commission_cvkd');
			if($total_nha_dau_tu->status == 200 && !empty($total_nha_dau_tu)){
				$tien_hoa_hong_nha_dau_tu = $total_nha_dau_tu->data->total->money_commission_number;
			}
			$data[$count]['chi_tieu_nha_dau_tu'] = $this->report_kpi_model->sum_where_total(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)],'$kpi.nha_dau_tu');

			//du_no_tang_net
			$total_du_no_trong_han_t10_hien_tai = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'store.id' => array('$in' => $stores), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');
			$total_du_no_trong_han_t10_1 = $total_du_no_trong_han_t10_hien_tai;

			$total_du_no_trong_han_t10_2 = $debt_store->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'created_at' => $condition_thang_truoc], '$total_du_no_trong_han_t10_old');

			$data[$count]['total_du_no_trong_han_t10'] = $total_du_no_trong_han_t10_1 - $total_du_no_trong_han_t10_2;

			//Chỉ tiêu dư nợ tăng net
			$data[$count]['chi_tieu_du_no_tang_net'] = $kpipgd->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)], '$du_no_CT');
			$du_no_tt = $kpipgd->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)], '$du_no_TT');
			$tt_bao_hiem = $kpipgd->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)], '$bao_hiem_TT');

			//doanh_so_bao_hiem
			$data[$count]['total_doanh_so_bao_hiem'] = $rkcpm->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'san_pham' => 'BH', 'created_at' => $condition_lead], '$commision.doanh_so');

			//chỉ tiêu bảo hiểm
			$data[$count]['chi_tieu_bao_hiem'] = $kpipgd->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)], '$bao_hiem_CT');

			//Chỉ tiêu giải ngân
			$chi_tieu_giai_ngan = $this->report_kpi_model->sum_where_total(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)],'$total_giai_ngan_chi_tieu_ti_trong');

			//Tiền giải ngân mới trong tháng
			$data[$count]['total_so_tien_vay'] = $contract->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'disbursement_date' => $condition_lead, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 37, 38, 39, 41, 42, 19, 33, 34])], array('$toLong' => '$loan_infor.amount_money'));
			$data[$count]['chi_tieu_giai_ngan'] = $kpipgd->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)], '$giai_ngan_CT');
			$giai_ngan_tt = $kpipgd->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'store.id' => array('$in' => $stores)], '$giai_ngan_TT');
			//Kpi
			if (!empty($data[$count]['chi_tieu_du_no_tang_net']) && $data[$count]['chi_tieu_du_no_tang_net'] != 0) {
				$kpi_du_no = round(($data[$count]['total_du_no_trong_han_t10'] / $data[$count]['chi_tieu_du_no_tang_net']) * $du_no_tt);
			}
			if (!empty($data[$count]['chi_tieu_bao_hiem']) && $data[$count]['chi_tieu_bao_hiem'] != 0) {
				$kpi_bao_hiem = round(($data[$count]['total_doanh_so_bao_hiem'] / $data[$count]['chi_tieu_bao_hiem']) * $tt_bao_hiem);
			}
			if (!empty($data[$count]['chi_tieu_giai_ngan']) && $data[$count]['chi_tieu_giai_ngan'] != 0) {
				$kpi_giai_ngan = round(($chi_tieu_giai_ngan / $data[$count]['chi_tieu_giai_ngan']) * $giai_ngan_tt);
			}
			if (!empty($data[$count]['chi_tieu_nha_dau_tu']) && $data[$count]['chi_tieu_nha_dau_tu'] != 0) {
				$kpi_nha_dau_tu = round(($data[$count]['total_nha_dau_tu'] / $data[$count]['chi_tieu_nha_dau_tu']) * 10);
			}

			if ($kpi_du_no > 40) {
				$kpi_du_no = 40;
			} elseif ($kpi_du_no < 0){
				$kpi_du_no = 0;
			}
			if ($kpi_bao_hiem > 40) {
				$kpi_bao_hiem = 40;
			}
			if ($kpi_giai_ngan > 40) {
				$kpi_giai_ngan = 40;
			}
			if ($kpi_nha_dau_tu > 20) {
				$kpi_nha_dau_tu = 20;
			}

			$data[$count]['kpi'] = $kpi_du_no + $kpi_bao_hiem + $kpi_giai_ngan + $kpi_nha_dau_tu;

			//Tiền hoa hồng
			$total_tien_hoa_hong_tukiem = $rkcum->sum_where_total_mongo_read(['store.id' => array('$in' => $stores) ,'created_at' => $condition_lead, 'user' => ['$in' => $user_cht]], '$commision.tien_hoa_hong');
			$tong_tien_hoa_hong_huong_nv = $rkcpm->sum_where_total(['created_at' => $condition_lead, 'san_pham' => 'HDV','store.id' => array('$in' => $stores)], '$commision.tien_hoa_hong');
			$total_tien_hoa_hong_hdv = $total_tien_hoa_hong_tukiem + $tong_tien_hoa_hong_huong_nv;

			if($data[$count]['kpi'] >= 60 && $data[$count]['kpi'] < 80){
				$tong_tien_hoa_hong = ($total_tien_hoa_hong_hdv + ($data[$count]['total_du_no_trong_han_t10'] * 0.2/100) + ($total_du_no_trong_han_t10_1 * 0.03/100)) * 0.6 ;
			} elseif ($data[$count]['kpi'] >= 80 && $data[$count]['kpi'] < 100){
				$tong_tien_hoa_hong = ($total_tien_hoa_hong_hdv + ($data[$count]['total_du_no_trong_han_t10'] * 0.2/100) + ($total_du_no_trong_han_t10_1 * 0.03/100)) * 0.8 ;
			} elseif ($data[$count]['kpi'] >= 100 && $data[$count]['kpi'] < 120){
				$tong_tien_hoa_hong = ($total_tien_hoa_hong_hdv + ($data[$count]['total_du_no_trong_han_t10'] * 0.2/100) + ($total_du_no_trong_han_t10_1 * 0.03/100)) * 1 ;
			} elseif ($data[$count]['kpi'] >= 120){
				$tong_tien_hoa_hong = ($total_tien_hoa_hong_hdv + ($data[$count]['total_du_no_trong_han_t10'] * 0.2/100) + ($total_du_no_trong_han_t10_1 * 0.03/100)) * 1.2 ;
			} else {
				$tong_tien_hoa_hong = 0;
			}

			$data[$count]['total_tien_hoa_hong'] = $tong_tien_hoa_hong + $tien_hoa_hong_nha_dau_tu;

			//dư nợ trong hạn T+10
			$data[$count]['total_du_no_trong_han_t10_old'] = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false), 'store.id' => array('$in' => $stores)], '$debt.tong_tien_goc_con');
			$data[$count]['total_du_no_trong_han_t10_thang_truoc'] = $debt_store->sum_where_total_mongo_read(['store.id' => array('$in' => $stores), 'created_at' => $condition_thang_truoc], '$total_du_no_trong_han_t10_old');

			$count++;
		}

		if ($data) {
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'data' => $data
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
	}

	public function view_payroll_cvkd_list_post()
	{

		$data = $this->input->post();
		$start_old = '2019-11-01';
		$start = !empty($data['start']) ? $data['start'] : date('Y-m-01');
		$end = !empty($data['end']) ? $data['end'] : date('2030-m-d');
		$condition = array();
		$condition_lead = array();

		if (!empty($start) && !empty($end)) {
			$condition_old = array(
				'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);
			$condition_lead = array(
				'$gte' => strtotime(trim($start) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);

			//Dư nợ quá hạn T+10 tháng trước
			$date = getdate();
			$month = $date['mon'];
			$month_thang_nay = $date['mon'] - 1;
			$month_thang_truoc = $date['mon'] - 1;
			$year = $date['year'];
			if ($date['mon'] == 1) {
				$month_thang_nay = 12;
				$month_thang_truoc = 12;
				$year = $date['year'] - 1;
			}
			if ($date['mon'] < 10) {
				$month = "0" . $month;
			}

			$start_thang_truoc = !empty($month_thang_truoc) ? date("$year-$month_thang_truoc-01") : date('Y-m-01');
			$end_thang_truoc = !empty($month_thang_truoc) ? date("$year-$month_thang_truoc-t") : date('Y-m-d');

			$condition_thang_truoc = array(
				'$gte' => strtotime(trim($start_thang_truoc) . ' 00:00:00'),
				'$lte' => strtotime(trim($end_thang_truoc) . ' 23:59:59')
			);

		}

		$contract = new Contract_model();

		$rkcum = new Report_kpi_commission_user_model();
		$kpigdv = new Kpi_gdv_model();

		$debt_user = new Debt_user_model();
		$year = date('Y');
		$data = [];
		$list_user_pgd = [];
		$stores_check = $this->getStores_list($this->id);
		$get_role = $this->getGroupRole_cht();
		foreach ($stores_check as $item) {
			$user = $this->get_user_store_post($item);

			foreach ($user as $value) {
				array_push($list_user_pgd, $value);
			}
		}

		$count = 0;

		foreach (array_unique($list_user_pgd) as $key => $item) {
			$kpi_du_no = 0;
			$kpi_bao_hiem = 0;
			$kpi_giai_ngan = 0;
			$kpi_nha_dau_tu = 0;
			$list_store_name = [];

			$data[$count]['created_by'] = $item;
			if(in_array($item, $get_role)){
				continue;
			}

			//Chỉ tiêu nhà đầu tư
			$data[$count]['chi_tieu_nha_dau_tu'] = $kpigdv->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'email_gdv' => $item], '$nha_dau_tu');
			$tt_nha_dau_tu = $kpigdv->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'email_gdv' => $item], '$nha_dau_tu_TT');

			//Hoa hồng nhà đầu tư
			$data_phone = $this->getPhoneUserEmail($item);
			$total_nha_dau_tu = $this->callApiInvest(['year' => date('Y'), 'month' => date('m'), 'phone' => $data_phone], '/commission_cvkd');
			if($total_nha_dau_tu->status == 200 && !empty($total_nha_dau_tu)){
				$tien_hoa_hong_nha_dau_tu  = $total_nha_dau_tu->data->total->money_commission_number;
				$data[$count]['total_nha_dau_tu'] = $total_nha_dau_tu->data->total->total_money_number;
			}

			//du_no_tang_net
			$total_du_no_trong_han_t10_hien_tai = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'created_by' => $item, 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');
			$total_du_no_oto_va_nha_dat_hien_tai = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'created_by' => $item, 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old,  'tat_toan_gh' => array('$exists' => false)], '$debt.kpi_tong_tien_goc_con');
			$total_du_no_trong_han_t10_1 = $total_du_no_trong_han_t10_hien_tai;


			$total_du_no_trong_han_t10_2 = $debt_user->sum_where_total_mongo_read(['user' => $item, 'created_at' => $condition_thang_truoc], '$total_du_no_trong_han_t10_old');

			$data[$count]['total_du_no_trong_han_t10'] = $total_du_no_trong_han_t10_1 - $total_du_no_trong_han_t10_2;

			//Chỉ tiêu dư nợ tăng net
			$data[$count]['chi_tieu_du_no_tang_net'] = $kpigdv->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'email_gdv' => $item], '$du_no_CT');
			$du_no_tt = $kpigdv->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'email_gdv' => $item], '$du_no_TT');
			$tt_bao_hiem = $kpigdv->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'email_gdv' => $item], '$bao_hiem_TT');

			//doanh_so_bao_hiem
			$data[$count]['total_doanh_so_bao_hiem'] = $rkcum->sum_where_total_mongo_read(['user' => $item, 'san_pham' => 'BH', 'created_at' => $condition_lead], '$commision.doanh_so');

			//Chỉ tiêu giải ngân
			$chi_tieu_giai_ngan = $this->report_kpi_user_model->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'kpi' => ['$nin' => [false]] ,'user_email' => $item],'$total_giai_ngan_chi_tieu_ti_trong');

			//chỉ tiêu bảo hiểm
			$data[$count]['chi_tieu_bao_hiem'] = $kpigdv->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'email_gdv' => $item], '$bao_hiem_CT');

			//Tiền giải ngân mới trong tháng
			$data[$count]['total_so_tien_vay'] = $contract->sum_where_total_mongo_read(['created_by' => $item, 'disbursement_date' => $condition_lead, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 37, 38, 39, 41, 42, 19, 33, 34])], array('$toLong' => '$loan_infor.amount_money'));
			$data[$count]['chi_tieu_giai_ngan'] = $kpigdv->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'email_gdv' => $item], '$giai_ngan_CT');
			$giai_ngan_tt = $kpigdv->sum_where_total_mongo_read(['month' => "$month", 'year' => date("Y", strtotime(trim($start) . ' 00:00:00')), 'email_gdv' => $item], '$giai_ngan_TT');
			//Kpi
			if (!empty($data[$count]['chi_tieu_du_no_tang_net']) && $data[$count]['chi_tieu_du_no_tang_net'] != 0) {
				$kpi_du_no = round(($data[$count]['total_du_no_trong_han_t10'] / $data[$count]['chi_tieu_du_no_tang_net']) * $du_no_tt);
			}
			if (!empty($data[$count]['chi_tieu_bao_hiem']) && $data[$count]['chi_tieu_bao_hiem'] != 0) {
				$kpi_bao_hiem = round(($data[$count]['total_doanh_so_bao_hiem'] / $data[$count]['chi_tieu_bao_hiem']) * $tt_bao_hiem);
			}
			if (!empty($data[$count]['chi_tieu_giai_ngan']) && $data[$count]['chi_tieu_giai_ngan'] != 0) {
				$kpi_giai_ngan = round(($chi_tieu_giai_ngan / $data[$count]['chi_tieu_giai_ngan']) * $giai_ngan_tt);
			}
			if (!empty($data[$count]['chi_tieu_nha_dau_tu']) && $data[$count]['chi_tieu_nha_dau_tu'] != 0) {
				$kpi_nha_dau_tu = round(($data[$count]['total_nha_dau_tu'] / $data[$count]['chi_tieu_nha_dau_tu']) * $tt_nha_dau_tu);
			}
			if ($kpi_du_no > 40) {
				$kpi_du_no = 40;
			} elseif ($kpi_du_no < 0){
				$kpi_du_no = 0;
			}
			if ($kpi_bao_hiem > 40) {
				$kpi_bao_hiem = 40;
			}
			if ($kpi_giai_ngan > 40) {
				$kpi_giai_ngan = 40;
			}
			if ($kpi_nha_dau_tu > 20) {
				$kpi_nha_dau_tu = 20;
			}

			$data[$count]['kpi'] = $kpi_du_no + $kpi_bao_hiem + $kpi_giai_ngan + $kpi_nha_dau_tu;

			//Tiền hoa hồng
			$total_tien_hoa_hong = $rkcum->sum_where_total_mongo_read(['user' => $item, 'san_pham' => 'HDV' ,'created_at' => $condition_lead], '$commision.tien_hoa_hong');
			$total_tien_hoa_hong_bao_hiem = $rkcum->sum_where_total_mongo_read(['user' => $item, 'san_pham' => 'BH' ,'created_at' => $condition_lead], '$commision.tien_hoa_hong');

			//dư nợ trong hạn T+10
			$data[$count]['total_du_no_trong_han_t10_old'] = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']],'status' => array('$in' => list_array_trang_thai_dang_vay()), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false),'created_by' => $item], '$debt.tong_tien_goc_con');
			$data[$count]['total_du_no_trong_han_t10_thang_truoc'] = $debt_user->sum_where_total_mongo_read(['user' => $item, 'created_at' => $condition_thang_truoc], '$total_du_no_trong_han_t10_old');

			$tong_tien_hoa_hong = 0;
			if($data[$count]['kpi'] >= 60 && $data[$count]['kpi'] < 80){
				$tong_tien_hoa_hong = ($total_tien_hoa_hong + ($data[$count]['total_du_no_trong_han_t10'] * 0.3/100) + ($data[$count]['total_du_no_trong_han_t10_old'] * 0.1/100)) * 0.6 + $total_tien_hoa_hong_bao_hiem;
			} elseif ($data[$count]['kpi'] >= 80 && $data[$count]['kpi'] < 100){
				$tong_tien_hoa_hong = ($total_tien_hoa_hong + ($data[$count]['total_du_no_trong_han_t10'] * 0.3/100) + ($data[$count]['total_du_no_trong_han_t10_old'] * 0.1/100)) * 0.8 + $total_tien_hoa_hong_bao_hiem;
			} elseif ($data[$count]['kpi'] >= 100 && $data[$count]['kpi'] < 120){
				$tong_tien_hoa_hong = ($total_tien_hoa_hong + ($data[$count]['total_du_no_trong_han_t10'] * 0.3/100) + ($data[$count]['total_du_no_trong_han_t10_old'] * 0.1/100)) * 1 + $total_tien_hoa_hong_bao_hiem;
			} elseif ($data[$count]['kpi'] >= 120){
				$tong_tien_hoa_hong = ($total_tien_hoa_hong + ($data[$count]['total_du_no_trong_han_t10'] * 0.3/100) + ($data[$count]['total_du_no_trong_han_t10_old'] * 0.1/100)) * 1.2 + $total_tien_hoa_hong_bao_hiem;
			} else {
				$tong_tien_hoa_hong = $total_tien_hoa_hong_bao_hiem;
			}

			$data[$count]['total_tien_hoa_hong'] = $tong_tien_hoa_hong + $tien_hoa_hong_nha_dau_tu;

			$count++;
		}

		if ($data) {
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'data' => $data
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

	}

	public function get_user_store_post($store_id)
	{
		$roles = $this->role_model->find_where(['status' => 'active']);
		$data = [];
		$i = 0;
		foreach ($roles as $key => $role) {
			if (!empty($role['users']) && !empty($role['stores'])) {
				$data[$i]['users'] = $role['users'];
				$data[$i]['stores'] = $role['stores'];
				$i++;
			}
		}
		foreach ($data as $da) {
			foreach ($da['stores'] as $d) {
				$storeId = [];
				foreach ($d as $k => $v) {
					array_push($storeId, $k);
				}
				if (in_array($store_id, $storeId) == true) {
					if (count($da['stores']) > 1) {
						continue;
					}
					$user_id = [];
					foreach ($da['users'] as $ds) {
						foreach ($ds as $k => $v) {
							foreach ($v as $e) {
								array_push($user_id, $e);

							}
						}
					}
				}
			}
		}
		return $user_id;
	}

	public function view_homepage_tienngay_post()
	{

		$data = [];
		$contract = new Contract_model();

		$data['total_giao_dich_thanh_cong'] = $contract->count(['code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 37, 38, 39, 41, 42, 19])]);
		$data['total_so_tien_vay_old'] = $contract->sum_where_total(['code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 37, 38, 39, 41, 42, 19])], array('$toLong' => '$loan_infor.amount_money'));

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $data


		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;


	}

	public function report_synthetic_data_post()
	{

		$this->dataPost = $this->input->post();

		$month = !empty($this->dataPost['month']) ? date('m', strtotime($this->dataPost['month'])) : date('m');
		$year = !empty($this->dataPost['month']) ? date('Y', strtotime($this->dataPost['month'])) : date('Y');
		$endDayMonth = $this->lastday($month, $year);

		//Tháng trước
		$newdate = strtotime('-1 month', strtotime("$year-$month-01"));
		$year_last_month = date('Y', $newdate);
		$last_month = date('m', $newdate);
		$endDayLastMonth = $this->lastday($last_month, $year_last_month);

		$data = [];
		$condition_month = array(
			'$gte' => strtotime(trim("$year-$month-01") . ' 00:00:00'),
			'$lte' => strtotime(trim("$year-$month-$endDayMonth") . ' 23:59:59')
		);
		$condition_old = array(
			'$gte' => strtotime(trim("2018-01-01") . ' 00:00:00'),
			'$lte' => strtotime(trim("$year-$month-$endDayMonth") . ' 23:59:59')
		);
		$condition_tong_tien = array(
			'$gte' => strtotime(trim("$year-01-01") . ' 00:00:00'),
			'$lte' => strtotime(trim("$year-$month-$endDayMonth") . ' 23:59:59')
		);
		$condition_last_month = array(
			'$gte' => strtotime(trim(date("$year_last_month-$last_month-01")) . ' 00:00:00'),
			'$lte' => strtotime(trim(date("$year_last_month-$last_month-$endDayLastMonth")) . ' 23:59:59')
		);

		$dataStore = $this->store_model->find_where(['status' => "active", 'name' => ['$nin' => ["BPD01", "Direct Sale AGN", "Direct Sale BD", "Direct Sale HCM 1", "Direct Sale HCM 2", "Direct Sale KGN", "Direct Sale QN", "Direct Sale TH", "IT test", "Priority"]]]);

		if (!empty($dataStore)) {
			for ($i = 0; $i < count($dataStore); $i++) {
				$data[$i]['name'] = $dataStore[$i]['name'];
				$data[$i]['address'] = $dataStore[$i]['address'];
				$data[$i]['code_area'] = name_area($dataStore[$i]['code_area']);
				$data[$i]['created_at'] = $dataStore[$i]['created_at'];
				$data[$i]['province'] = $dataStore[$i]['province']['name'];
				$data[$i]['_id'] = (string)$dataStore[$i]['_id'];

				//Miền
				$area = $this->area_model->findOne(['code' => $dataStore[$i]['code_area']]);
				$data[$i]['area'] = $area['domain']['name'];

				//Nhân viên trong phòng

				$data[$i]['nhanvien'] = $dataStore[$i]['nhanvien'];

				//Số lượng hđ xe máy
				$data[$i]['count_hd_xm'] = $this->contract_model->count(['loan_infor.type_property.code' => 'XM', 'store.id' => (string)$dataStore[$i]['_id'], 'disbursement_date' => $condition_month, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => list_array_trang_thai_dang_vay_tat_toan())]);

				//Số lượng hđ ô tô
				$data[$i]['count_hd_oto'] = $this->contract_model->count(['loan_infor.type_property.code' => 'OTO', 'store.id' => (string)$dataStore[$i]['_id'], 'disbursement_date' => $condition_month, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => list_array_trang_thai_dang_vay_tat_toan())]);

				//Số lượng hđ 1 tháng
				$data[$i]['count_hd_1'] = $this->contract_model->count(['loan_infor.number_day_loan' => "30", 'store.id' => (string)$dataStore[$i]['_id'], 'disbursement_date' => $condition_month, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => list_array_trang_thai_dang_vay_tat_toan())]);

				//Số lượng hđ 3 tháng
				$data[$i]['count_hd_3'] = $this->contract_model->count(['loan_infor.number_day_loan' => "90", 'store.id' => (string)$dataStore[$i]['_id'], 'disbursement_date' => $condition_month, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => list_array_trang_thai_dang_vay_tat_toan())]);

				//Số lượng hđ lớn hơn 6 tháng
				$data[$i]['count_hd_6'] = $this->contract_model->count(['loan_infor.number_day_loan' => ['$in' => ['180', '270', '360', '720', '540']], 'status' => array('$in' => list_array_trang_thai_dang_vay_tat_toan()), 'store.id' => (string)$dataStore[$i]['_id'], 'disbursement_date' => $condition_month, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false)]);

				//Tiền giải ngân mới trong kỳ
				$data[$i]['amount_money'] = $this->contract_model->sum_where_total(['store.id' => (string)$dataStore[$i]['_id'], 'disbursement_date' => $condition_month, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => list_array_trang_thai_dang_vay_tat_toan())], array('$toLong' => '$loan_infor.amount_money'));

				//Doanh số bảo hiểm trong kỳ
				$data[$i]['insurance_sales'] = $this->report_kpi_commission_pgd_model->sum_where_total(['store.id' => (string)$dataStore[$i]['_id'], 'san_pham' => 'BH', 'created_at' => $condition_month], '$commision.doanh_so');

				//Tổng tiền giải ngân
				$data[$i]['total_amount_money'] = $this->contract_model->sum_where_total(['store.id' => (string)$dataStore[$i]['_id'], 'disbursement_date' => $condition_tong_tien, 'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => list_array_trang_thai_dang_vay_tat_toan())], array('$toLong' => '$loan_infor.amount_money'));

				//Dư nợ quản lý
				$data[$i]['total_du_no_dang_cho_vay_old'] = $this->contract_model->sum_where_total(['store.id' => (string)$dataStore[$i]['_id'], 'disbursement_date' => $condition_old, 'status' => array('$in' => list_array_trang_thai_dang_vay()), 'tat_toan_gh' => array('$exists' => false)], '$original_debt.du_no_goc_con_lai');

				//Dư nợ trong hạn T+10 hiện tại
				$bds = $this->contract_model->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$in' => ['NĐ']], 'store.id' => (string)$dataStore[$i]['_id'], 'status' => array('$in' => list_array_trang_thai_dang_vay()), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');

				$data[$i]['du_no_trong_han_T10_hien_tai'] = $this->contract_model->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']], 'store.id' => (string)$dataStore[$i]['_id'], 'status' => array('$in' => list_array_trang_thai_dang_vay()), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false)], '$debt.tong_tien_goc_con');

				//Dư nợ trong hạn kỳ trước
				if ($year == date('Y') && $month == date('m')) {
					$data[$i]['du_no_trong_han_T10_ky_truoc'] = $this->debt_store_model->sum_where_total(['store.id' => (string)$dataStore[$i]['_id'], 'created_at' => $condition_last_month], '$total_du_no_trong_han_t10_old');
				} else {
					$newMonth = strtotime('-1 month', strtotime("$year_last_month-$last_month-01"));
					$year_last_month_two = date('Y', $newMonth);
					$last_month_two = date('m', $newMonth);
					$endDayLastMonth_two = $this->lastday($last_month_two, $year_last_month_two);
					$condition_two_last_month = array(
						'$gte' => strtotime(trim(date("$year_last_month_two-$last_month_two-01")) . ' 00:00:00'),
						'$lte' => strtotime(trim(date("$year_last_month_two-$last_month_two-$endDayLastMonth_two")) . ' 23:59:59')
					);
					$data[$i]['du_no_trong_han_T10_ky_truoc'] = $this->debt_store_model->sum_where_total(['store.id' => (string)$dataStore[$i]['_id'], 'created_at' => $condition_two_last_month], '$total_du_no_trong_han_t10_old');
				}

				//Dư nợ tăng net trong hạn T+10
				$data[$i]['du_no_tang_net'] = $data[$i]['du_no_trong_han_T10_hien_tai'] - $data[$i]['du_no_trong_han_T10_ky_truoc'];

				//Dư nợ B0
				$data[$i]['total_du_no_b0'] = $this->contract_model->sum_where_total(['loan_infor.type_property.code' => ['$nin' => ['NĐ']], 'debt.so_ngay_cham_tra' => ['$lte' => 0], 'store.id' => (string)$dataStore[$i]['_id'], 'disbursement_date' => $condition_old, 'status' => array('$in' => list_array_trang_thai_dang_vay()), 'tat_toan_gh' => array('$exists' => false)], '$original_debt.du_no_goc_con_lai');
				//Dư nợ B1
				$data[$i]['total_du_no_b1'] = $this->contract_model->sum_where_total(['loan_infor.type_property.code' => ['$nin' => ['NĐ']], 'debt.so_ngay_cham_tra' => ['$gte' => 1, '$lte' => 30], 'store.id' => (string)$dataStore[$i]['_id'], 'disbursement_date' => $condition_old, 'status' => array('$in' => list_array_trang_thai_dang_vay()), 'tat_toan_gh' => array('$exists' => false)], '$original_debt.du_no_goc_con_lai');
				//Dư nợ B2
				$data[$i]['total_du_no_b2'] = $this->contract_model->sum_where_total(['loan_infor.type_property.code' => ['$nin' => ['NĐ']], 'debt.so_ngay_cham_tra' => ['$gte' => 31, '$lte' => 60], 'store.id' => (string)$dataStore[$i]['_id'], 'disbursement_date' => $condition_old, 'status' => array('$in' => list_array_trang_thai_dang_vay()), 'tat_toan_gh' => array('$exists' => false)], '$original_debt.du_no_goc_con_lai');
				//Dư nợ B3
				$data[$i]['total_du_no_b3'] = $this->contract_model->sum_where_total(['loan_infor.type_property.code' => ['$nin' => ['NĐ']], 'debt.so_ngay_cham_tra' => ['$gte' => 61, '$lte' => 90], 'store.id' => (string)$dataStore[$i]['_id'], 'disbursement_date' => $condition_old, 'status' => array('$in' => list_array_trang_thai_dang_vay()), 'tat_toan_gh' => array('$exists' => false)], '$original_debt.du_no_goc_con_lai');
				//Dư nợ B4+
				$data[$i]['total_du_no_b4'] = $this->contract_model->sum_where_total(['loan_infor.type_property.code' => ['$nin' => ['NĐ']], 'debt.so_ngay_cham_tra' => ['$gte' => 91], 'store.id' => (string)$dataStore[$i]['_id'], 'disbursement_date' => $condition_old, 'status' => array('$in' => list_array_trang_thai_dang_vay()), 'tat_toan_gh' => array('$exists' => false)], '$original_debt.du_no_goc_con_lai');

			}
		}
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $data
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
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


	function getCountUserbyStores($storeId)
	{

		$roles = $this->role_model->find_where(array("status" => "active"));
		$key_gdv = $this->getGroupRole_gdv_key();
		$roleAllUsers = array();
		if (count($roles) > 0) {
			foreach ($roles as $role) {
				if (!empty($role['stores']) && count($role['stores']) == 1) {
					$arrStores = array();
					foreach ($role['stores'] as $item) {
						array_push($arrStores, key($item));
					}
					if (in_array($storeId, $arrStores) == TRUE) {
						foreach ($role['users'] as $key => $item) {
							if (!in_array(key($item), $key_gdv)) {
								continue;
							}
							$check_active_user = $this->user_model->findOne(['_id' => new \MongoDB\BSON\ObjectId(key($item)), 'status' => 'active']);
							if (!empty($check_active_user)) {
								array_push($roleAllUsers, key($item));
							}
						}
					}


				}
			}
		}
		$roleUsers = array_unique($roleAllUsers);
		return count($roleUsers);
	}

	public function getGroupRole_rsm()
	{
		$groupRoles = $this->group_role_model->find_where(array("status" => "active", 'slug' => 'quan-ly-vung'));

		$arr = array();
		foreach ($groupRoles as $groupRole) {
			if (!empty($groupRole['users'])) {

				foreach ($groupRole['users'] as $value) {
					foreach ($value as $key => $item) {
						foreach ($item as $e) {
							$arr += ["$key" => $e];

						}
					}

				}
			}
		}
		return $arr;
	}

	public function getGroupRole_gdv_key()
	{
		$groupRoles = $this->group_role_model->find_where(array("status" => "active", 'slug' => 'giao-dich-vien'));
		$arr = array();
		foreach ($groupRoles as $groupRole) {
			if (!empty($groupRole['users'])) {
				foreach ($groupRole['users'] as $value) {
					foreach ($value as $key => $item) {
						array_push($arr, $key);
					}

				}
			}
		}
		return $arr;
	}

	public function exportPGD_NIN_BDS_post()
	{

		$data = $this->input->post();
		$start_old = '2019-11-01';
		$start = !empty($data['start']) ? $data['start'] : date('Y-m-01');
		$end = !empty($data['end']) ? $data['end'] : date('2030-m-d');

		if (!empty($start) && !empty($end)) {
			$condition_old = array(
				'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);
		}

		$contract = new Contract_model();

		$data = [];

		$stores = $this->store_model->find_where(["status" => "active"]);
		$pgd_unset = ["BPD01", "Direct Sale AGN", "Direct Sale BD", "Direct Sale HCM 1", "Direct Sale HCM 2", "Direct Sale KGN", "Direct Sale QN", "Direct Sale TH", "IT test", "Priority"];
		$stores_for = [];

		if (!empty($stores)) {
			foreach ($stores as $value) {
				$store_name = $this->store_model->findOne(array('_id' => new MongoDB\BSON\ObjectId((string)$value['_id'])));
				if (!empty($store_name)) {
					$stores_for += [$store_name['name'] => $value];
				}
			}
		}

		$count = 0;

		foreach ($stores_for as $key => $item) {

			if (in_array($item['name'], $pgd_unset)) {
				continue;
			}

			$stores = [(string)$item['_id']];

			$data[$count]['store_name'] = $item['name'];

			$data[$count]['total_du_no_trong_han_t10_old'] = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']], 'status' => array('$in' => list_array_trang_thai_dang_vay()), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false), 'store.id' => array('$in' => $stores)], '$debt.tong_tien_goc_con');

			$count++;
		}

		if ($data) {
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'data' => $data
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}


	}

	public function exportUser_NIN_BDS_post()
	{

		$data = $this->input->post();
		$start_old = '2019-11-01';
		$start = !empty($data['start']) ? $data['start'] : date('Y-m-01');
		$end = !empty($data['end']) ? $data['end'] : date('2030-m-d');

		if (!empty($start) && !empty($end)) {
			$condition_old = array(
				'$gte' => strtotime(trim($start_old) . ' 00:00:00'),
				'$lte' => strtotime(trim($end) . ' 23:59:59')
			);

		}

		$contract = new Contract_model();

		$data = [];

		$list_user_pgd = $this->getGroupRole_gdv();

		$count = 0;

		foreach ($list_user_pgd as $key => $item) {

			$data[$count]['created_by'] = $item;

			//dư nợ trong hạn T+10
			$data[$count]['total_du_no_trong_han_t10_old'] = $contract->sum_where_total_mongo_read(['loan_infor.type_property.code' => ['$nin' => ['NĐ']], 'status' => array('$in' => list_array_trang_thai_dang_vay()), 'debt.so_ngay_cham_tra' => ['$lte' => 10], 'disbursement_date' => $condition_old, 'tat_toan_gh' => array('$exists' => false), 'created_by' => $item], '$debt.tong_tien_goc_con');

			$count++;
		}

		if ($data) {
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'data' => $data
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

	}

	public function price_disbursement_gdv($created_by, $start_date, $condition_lead){
		$total = 0;
		$month = date('m', strtotime($start_date));
		$year = date('Y', strtotime($start_date));

		$kpiDt = $this->kpi_gdv_model->findOne(array('month' => (string)$month, 'year' => (string)$year, 'email_gdv' => $created_by));

		if(!empty($kpiDt['oto_TT']) && !empty($kpiDt['xe_may_TT'])){

			$price_xm = $this->contract_model->sum_where_total(['created_by' => $created_by, 'loan_infor.type_property.code' => ['$nin' => ['NĐ', 'OTO']] ,'disbursement_date' => $condition_lead ,'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 37, 38, 39, 41, 42, 19, 33, 34])], array('$toLong' => '$loan_infor.amount_money'));
			$price_oto = $this->contract_model->sum_where_total(['created_by' => $created_by, 'loan_infor.type_property.code' => ['$nin' => ['NĐ', 'XM']] ,'disbursement_date' => $condition_lead ,'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 37, 38, 39, 41, 42, 19, 33, 34])], array('$toLong' => '$loan_infor.amount_money'));

			$tran_chi_tieu_xe_may = $kpiDt['giai_ngan_CT'] * $kpiDt['xe_may_TT']/100 * 1.5;
			$tran_chi_tieu_o_to = $kpiDt['giai_ngan_CT'] * $kpiDt['oto_TT']/100 * 2;

			if ($price_xm > $tran_chi_tieu_xe_may){
				$price_xm = $tran_chi_tieu_xe_may;
			}
			if ($price_oto > $tran_chi_tieu_o_to){
				$price_oto = $tran_chi_tieu_o_to;
			}

			$total = $price_xm + $price_oto;

		}
		return $total;
	}

	public function price_disbursement_pgd($stores ,$start_date, $condition_lead){

		$total = 0;
		$month = date('m', strtotime($start_date));
		$year = date('Y', strtotime($start_date));

		$kpiDt = $this->kpi_pgd_model->find_where(array('month' => $month, 'year' => $year, 'store.id' => ['$in' => $stores]));
		$giai_ngan_CT = 0;
		$xe_may_TT = 0;
		$oto_TT = 0;
		if	(!empty($kpiDt)){
			foreach ($kpiDt as $value){
				$giai_ngan_CT += $value['giai_ngan_CT'];
				$xe_may_TT += $value['xe_may_TT'];
				$oto_TT += $value['oto_TT'];
			}
		}

		if(!empty($kpiDt)){

			$price_xm = $this->contract_model->sum_where_total(['store.id' => ['$in' => $stores], 'loan_infor.type_property.code' => ['$nin' => ['NĐ', 'OTO']] ,'disbursement_date' => $condition_lead ,'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 37, 38, 39, 41, 42, 19, 33, 34])], array('$toLong' => '$loan_infor.amount_money'));
			$price_oto = $this->contract_model->sum_where_total(['store.id' => ['$in' => $stores], 'loan_infor.type_property.code' => ['$nin' => ['NĐ', 'XM']] ,'disbursement_date' => $condition_lead ,'code_contract_parent_cc' => array('$exists' => false), 'code_contract_parent_gh' => array('$exists' => false), 'tat_toan_gh' => array('$exists' => false), 'status' => array('$in' => [11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 37, 38, 39, 41, 42, 19, 33, 34])], array('$toLong' => '$loan_infor.amount_money'));

			$tran_chi_tieu_xe_may = $giai_ngan_CT * $xe_may_TT/100 * 1.5;
			$tran_chi_tieu_o_to = $giai_ngan_CT * $oto_TT/100 * 2;

			if ($price_xm > $tran_chi_tieu_xe_may){
				$price_xm = $tran_chi_tieu_xe_may;
			}
			if ($price_oto > $tran_chi_tieu_o_to){
				$price_oto = $tran_chi_tieu_o_to;
			}

			$total = $price_xm + $price_oto;

		}
		return $total;

	}

	public function get_count_all_mongo_read_post(){

		$data = $this->input->post();
		$end = !empty($data['tdate']) ? $data['tdate'] : "";
		$start = !empty($data['fdate']) ? $data['fdate'] : "";
		$condition = [];
		$condition['day'] = date('d', strtotime($end));
		$condition['month'] = date('m', strtotime($end));
		$condition['year'] = date('Y', strtotime($end));

		$condition['start'] = strtotime(trim($start) . ' 00:00:00');
		$condition['end'] = strtotime(trim($end) . ' 23:59:59');

		$count = $this->contract_model->count_mongo_read_live($condition);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $count
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function get_all_data_mongo_read_post(){

		$data = $this->input->post();
		$end = !empty($data['tdate']) ? $data['tdate'] : "";
		$start = !empty($data['fdate']) ? $data['fdate'] : "";
		$condition = [];
		$condition['day'] = date('d', strtotime($end));
		$condition['month'] = date('m', strtotime($end));
		$condition['year'] = date('Y', strtotime($end));


		$per_page = !empty($data['per_page']) ? $data['per_page'] : 30;
		$uriSegment = !empty($data['uriSegment']) ? $data['uriSegment'] : 0;

		$data = $this->contract_model->find_where_read_live($condition, $per_page, $uriSegment);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $data
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;


	}

	public function get_all_data_mongo_read_excel_post(){
		$data = $this->input->post();
		$end = !empty($data['tdate']) ? $data['tdate'] : "";
		$condition = [];
		$condition['day'] = date('d', strtotime($end));
		$condition['month'] = date('m', strtotime($end));
		$condition['year'] = date('Y', strtotime($end));

		$data = $this->contract_model->find_where_read_live_excel($condition);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $data
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function cron_get_all_data_total_mongo_read_post(){

		$this->dataPost = $this->input->post();

		$month = !empty($this->dataPost['month']) ? date('m', strtotime($this->dataPost['month'])) : date('m');
		$year = !empty($this->dataPost['month']) ? date('Y', strtotime($this->dataPost['month'])) : date('Y');

		$day = date("d",strtotime("yesterday"));

		if(date('d') == '01'){
			$last_month = date('m', strtotime('-1 month'));
			$month = $last_month;
		}

		$condition_month = array(
			'$gte' => strtotime(trim("$year-$month-01") . ' 00:00:00'),
			'$lte' => strtotime(trim("2030-$month-$day") . ' 23:59:59')
		);

		//Tháng trước
		$newdate = strtotime('-1 month', strtotime("$year-$month-01"));
		$year_last_month = date('Y', $newdate);
		$last_month = date('m', $newdate);
		$endDayLastMonth = $this->lastday($last_month, $year_last_month);

		$condition_lastMonth = array(
			'$gte' => strtotime(trim("$year_last_month-$last_month-01") . ' 00:00:00'),
			'$lte' => strtotime(trim("2030-$last_month-$endDayLastMonth") . ' 23:59:59')
		);

		$dataStore = $this->store_model->find_where(['status' => "active", 'name' => ['$nin' => ["Bảo hiểm PTI","Telesales HO","HO Hồ Chí Minh","IT test","Task Force Miền Nam","Task Force Miền Bắc","NextPay","Direct Sale KGN","Direct Sale HNI","Direct Sale HCM 2"]]]);

		$data = [];
		if (!empty($dataStore)) {
			for ($i = 0; $i < count($dataStore); $i++) {
				$data[$i]['name'] = $dataStore[$i]['name'];
				$data[$i]['address'] = $dataStore[$i]['address'];
				$data[$i]['code_area'] = name_area($dataStore[$i]['code_area']);
				$data[$i]['province'] = $dataStore[$i]['province']['name'];
//				$data[$i]['_id'] = (string)$dataStore[$i]['_id'];

				//Miền
				$area = $this->area_model->findOne(['code' => $dataStore[$i]['code_area']]);
				$data[$i]['area'] = $area['domain']['name'];

				//Số lượng hđ xe máy
				$data[$i]['count_hd_xm'] = $this->contract_model->count_live_excel(['year' => $year, 'month' => $month, 'day' => $day, 'data.loan_infor.type_property.code' => 'XM', 'data.store.id' => (string)$dataStore[$i]['_id'], 'data.disbursement_date' => $condition_month, 'data.code_contract_parent_cc' => array('$exists' => false), 'data.code_contract_parent_gh' => array('$exists' => false), 'data.tat_toan_gh' => array('$exists' => false), 'data.status' => array('$in' => list_array_trang_thai_dang_vay_tat_toan())]);
				//Số lượng hđ ô tô
				$data[$i]['count_hd_oto'] = $this->contract_model->count_live_excel(['year' => $year, 'month' => $month, 'day' => $day, 'data.loan_infor.type_property.code' => 'OTO', 'data.store.id' => (string)$dataStore[$i]['_id'], 'data.disbursement_date' => $condition_month, 'data.code_contract_parent_cc' => array('$exists' => false), 'data.code_contract_parent_gh' => array('$exists' => false), 'data.tat_toan_gh' => array('$exists' => false), 'data.status' => array('$in' => list_array_trang_thai_dang_vay_tat_toan())]);

				//Số lượng hđ 1 tháng
				$data[$i]['count_hd_1'] = $this->contract_model->count_live_excel(['year' => $year, 'month' => $month, 'day' => $day,'data.loan_infor.number_day_loan' => "30", 'data.store.id' => (string)$dataStore[$i]['_id'], 'data.disbursement_date' => $condition_month, 'data.code_contract_parent_cc' => array('$exists' => false), 'data.code_contract_parent_gh' => array('$exists' => false), 'data.tat_toan_gh' => array('$exists' => false), 'data.status' => array('$in' => list_array_trang_thai_dang_vay_tat_toan())]);

				//Số lượng hđ 3 tháng
				$data[$i]['count_hd_3'] = $this->contract_model->count_live_excel(['year' => $year, 'month' => $month, 'day' => $day,'data.loan_infor.number_day_loan' => "90", 'data.store.id' => (string)$dataStore[$i]['_id'], 'data.disbursement_date' => $condition_month, 'data.code_contract_parent_cc' => array('$exists' => false), 'data.code_contract_parent_gh' => array('$exists' => false), 'data.tat_toan_gh' => array('$exists' => false), 'data.status' => array('$in' => list_array_trang_thai_dang_vay_tat_toan())]);

				//Số lượng hđ lớn hơn 6 tháng
				$data[$i]['count_hd_6'] = $this->contract_model->count_live_excel(['year' => $year, 'month' => $month, 'day' => $day,'data.loan_infor.number_day_loan' => ['$in' => ['180', '270', '360', '720', '540']], 'data.status' => array('$in' => list_array_trang_thai_dang_vay_tat_toan()), 'data.store.id' => (string)$dataStore[$i]['_id'], 'data.disbursement_date' => $condition_month, 'data.code_contract_parent_cc' => array('$exists' => false), 'data.code_contract_parent_gh' => array('$exists' => false), 'data.tat_toan_gh' => array('$exists' => false)]);

				//Tiền giải ngân mới trong kỳ
				$data[$i]['amount_money'] = $this->contract_model->sum_where_total_read_live(['year' => $year, 'month' => $month, 'day' => $day,'data.store.id' => (string)$dataStore[$i]['_id'], 'data.disbursement_date' => $condition_month, 'data.code_contract_parent_cc' => array('$exists' => false), 'data.code_contract_parent_gh' => array('$exists' => false), 'data.tat_toan_gh' => array('$exists' => false), 'data.status' => array('$in' => list_array_trang_thai_dang_vay_tat_toan())], array('$toLong' => '$data.loan_infor.amount_money'));

				//Dư nợ trong hạn kỳ trước
				$data[$i]['du_no_trong_han_T10_ky_truoc'] = $this->contract_model->sum_where_total_read_live(['year' => $year_last_month, 'month' => $last_month, 'day' => $endDayLastMonth, 'data.store.id' => (string)$dataStore[$i]['_id'], 'data.status' => array('$in' => list_array_trang_thai_dang_vay()), 'data.debt.so_ngay_cham_tra' => ['$lte' => 10], 'data.tat_toan_gh' => array('$exists' => false)], '$data.debt.tong_tien_goc_con');

				//Dư nợ trong hạn kỳ hien tai
				$data[$i]['du_no_trong_han_T10_hien_tai'] = $this->contract_model->sum_where_total_read_live(['year' => $year, 'month' => $month, 'day' => $day, 'data.store.id' => (string)$dataStore[$i]['_id'], 'data.status' => array('$in' => list_array_trang_thai_dang_vay()), 'data.debt.so_ngay_cham_tra' => ['$lte' => 10], 'data.tat_toan_gh' => array('$exists' => false)], '$data.debt.tong_tien_goc_con');

				//Dư nợ tăng net T+10
				$data[$i]['du_no_tang_net_T10'] = $data[$i]['du_no_trong_han_T10_hien_tai'] - $data[$i]['du_no_trong_han_T10_ky_truoc'];

				//Dư nợ quản lý
				$data[$i]['du_no_quan_ly'] = $this->contract_model->sum_where_total_read_live(['year' => $year, 'month' => $month, 'day' => $day, 'data.store.id' => (string)$dataStore[$i]['_id'], 'data.status' => array('$in' => list_array_trang_thai_dang_vay()), 'data.tat_toan_gh' => array('$exists' => false)], '$data.debt.tong_tien_goc_con');

				//Dư nợ quản lý tháng trước
				$du_no_quan_ly_ky_truoc = $this->contract_model->sum_where_total_read_live(['year' => $year_last_month, 'month' => $last_month, 'day' => $endDayLastMonth, 'data.store.id' => (string)$dataStore[$i]['_id'], 'data.status' => array('$in' => list_array_trang_thai_dang_vay()), 'data.tat_toan_gh' => array('$exists' => false)], '$data.debt.tong_tien_goc_con');

				//Dư nợ tăng net
				$data[$i]['du_no_tang_net'] = $data[$i]['du_no_quan_ly'] - $du_no_quan_ly_ky_truoc;

				//Dư nợ B0
				$data[$i]['total_du_no_b0'] = $this->contract_model->sum_where_total_read_live(['year' => $year, 'month' => $month, 'day' => $day, 'data.debt.so_ngay_cham_tra' => ['$lte' => 0], 'data.store.id' => (string)$dataStore[$i]['_id'], 'data.status' => array('$in' => list_array_trang_thai_dang_vay()), 'data.tat_toan_gh' => array('$exists' => false)], '$data.debt.tong_tien_goc_con');
				//Dư nợ B1
				$data[$i]['total_du_no_b1'] = $this->contract_model->sum_where_total_read_live(['year' => $year, 'month' => $month, 'day' => $day, 'data.debt.so_ngay_cham_tra' => ['$gte' => 1, '$lte' => 30], 'data.store.id' => (string)$dataStore[$i]['_id'], 'data.status' => array('$in' => list_array_trang_thai_dang_vay()), 'data.tat_toan_gh' => array('$exists' => false)], '$data.debt.tong_tien_goc_con');
				//Dư nợ B2
				$data[$i]['total_du_no_b2'] = $this->contract_model->sum_where_total_read_live(['year' => $year, 'month' => $month, 'day' => $day, 'data.debt.so_ngay_cham_tra' => ['$gte' => 31, '$lte' => 60], 'data.store.id' => (string)$dataStore[$i]['_id'], 'data.status' => array('$in' => list_array_trang_thai_dang_vay()), 'data.tat_toan_gh' => array('$exists' => false)], '$data.debt.tong_tien_goc_con');
				//Dư nợ B3
				$data[$i]['total_du_no_b3'] = $this->contract_model->sum_where_total_read_live(['year' => $year, 'month' => $month, 'day' => $day, 'data.debt.so_ngay_cham_tra' => ['$gte' => 61, '$lte' => 90], 'data.store.id' => (string)$dataStore[$i]['_id'], 'data.status' => array('$in' => list_array_trang_thai_dang_vay()), 'data.tat_toan_gh' => array('$exists' => false)], '$data.debt.tong_tien_goc_con');
				//Dư nợ B4+
				$data[$i]['total_du_no_b4'] = $this->contract_model->sum_where_total_read_live(['year' => $year, 'month' => $month, 'day' => $day, 'data.debt.so_ngay_cham_tra' => ['$gte' => 91], 'data.store.id' => (string)$dataStore[$i]['_id'], 'data.status' => array('$in' => list_array_trang_thai_dang_vay()), 'data.tat_toan_gh' => array('$exists' => false)], '$data.debt.tong_tien_goc_con');

				//Bảo hiểm
				$data[$i]['bao_hiem'] = $this->insurance_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day, 'data.store.id' => (string)$dataStore[$i]['_id']], '$data.commision.doanh_so');

				$data[$i]['year'] = date('Y');
				$data[$i]['month'] = date('m');
				$data[$i]['day'] = date('d');
				$this->view_report_debt_model->insert($data[$i]);
			}
		}
		$response = array(
			'status' => REST_Controller::HTTP_OK,
		);
		$this->set_response($response, REST_Controller::HTTP_OK);

	}

	public function get_all_data_total_mongo_read_post(){

		$this->dataPost = $this->input->post();

		$month = !empty($this->dataPost['date']) ? date('m', strtotime($this->dataPost['date'])) : date('m');
		$year = !empty($this->dataPost['date']) ? date('Y', strtotime($this->dataPost['date'])) : date('Y');
		$day = !empty($this->dataPost['date']) ? date('d', strtotime($this->dataPost['date'])) : date('d');

		$data = $this->view_report_debt_model->find_where(['year' => $year, 'month' => $month, 'day' => $day]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $data
		);
		$this->set_response($response, REST_Controller::HTTP_OK);

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

	public function getPhoneUser($user_id){
		$user = $this->user_model->findOne(['_id' => new  MongoDB\BSON\ObjectId($user_id)]);
		if(!empty($user)){
			return $user['phone_number'];
		} else {
			return;
		}
	}

	public function getPhoneStore($stores, $user_phone = ""){

		$arr_user = $this->getUserbyStores_phone($stores);
		if(!empty($arr_user)){
			array_push($arr_user, $user_phone);

			$arr_user = implode(',', $arr_user);
		} else {
			$arr_user = '';
		}
		return $arr_user;
	}

	private function getUserbyStores_phone($storeId)
	{
		$roles = $this->role_model->find_where(array("status" => "active"));
		$roleAllUsers = array();
		if (count($roles) > 0) {
			foreach ($roles as $role) {
				if (!empty($role['stores']) && count($role['stores']) == 1) {
					$arrStores = array();
					foreach ($role['stores'] as $item) {
						array_push($arrStores, key($item));
					}
					//Check userId in list key of $users
					foreach ($storeId as $s) {
						if (in_array($s, $arrStores) == TRUE) {
							if (!empty($role['stores'])) {
								//Push store
								foreach ($role['users'] as $key => $item) {
									foreach ($item as $e) {
										array_push($roleAllUsers, $e->email);
									}
								}

							}
						}
					}

				}
			}
		}
		$roleUsers = array_unique($roleAllUsers);
		$roleUsers_phone = [];
		if(!empty($roleUsers)){
			foreach ($roleUsers as $item){
				$phone = $this->user_model->findOne(['email' => $item])["phone_number"];
				array_push($roleUsers_phone, $phone);
			}
		}
		return $roleUsers_phone;
	}

	public function getPhoneUserEmail($email){
		$user = $this->user_model->findOne(['email' => $email]);
		if(!empty($user)){
			return $user['phone_number'];
		} else {
			return;
		}
	}

	public function getPhoneByCht($store, $user_cht){

		$user = $this->getUserbyStores($store);

		if(!empty($user)){
			foreach ($user as $value){
				if(in_array($value, $user_cht)){
					$email_user = $value;
					break;
				}
			}
		}

		$data_phone = $this->getPhoneUserEmail($email_user);
		return $data_phone;
	}

	public function getPhoneArea($area){
		$user = [];
		if($area == "KV_HN1"){
			$user = $this->asm_hn();
		} elseif ($area == "KV_HCM1"){
			$user = $this->asm_hcm();
		} elseif ($area == "KV_BTB"){
			$user = $this->asm_bac_trung_bo();
		} elseif ($area == "KV_MK"){
			$user = $this->asm_mekong();
		} elseif ($area == "KV_BD"){
			$user = $this->asm_binh_duong();
		} elseif ($area == "KV_QN"){
			$user = $this->asm_qn();
		}

		$user_phone = [];


		foreach ($user as $value){

			if(in_array($value, $this->getGroupRole_asm()) && !in_array($value, $this->getGroupRole_rsm_check())){
				array_push($user_phone, $value);
			}


		}


		if(!empty($user_phone)){
			$data_phone = $this->getPhoneUserEmail($user_phone[0]);
			return $data_phone;
		}

		return ;
	}

	public function asm_hn()
	{
		$roles = $this->role_model->find_where(['status' => 'active']);
		$data = [];
		foreach ($roles as $key => $role) {
			if (!empty($role['users']) && ($role['slug'] == "asm-hn1")) {
				foreach ($role['users'] as $key1 => $user) {
					foreach ($user as $key2 => $item) {
						foreach ($item as $e) {
							array_push($data, $e);

						}

					}
				}
			}
		}
		return $data;
	}
	public function asm_hcm()
	{
		$roles = $this->role_model->find_where(['status' => 'active']);
		$data = [];
		foreach ($roles as $key => $role) {
			if (!empty($role['users']) && ($role['slug'] == "asm-hcm1")) {
				foreach ($role['users'] as $key1 => $user) {
					foreach ($user as $key2 => $item) {
						foreach ($item as $e) {
							array_push($data, $e);

						}

					}
				}
			}
		}
		return $data;
	}
	public function asm_mekong(){
		$roles = $this->role_model->find_where(['status' => 'active']);
		$data = [];
		foreach ($roles as $key => $role) {
			if (!empty($role['users']) && ($role['slug'] == "qlkv-mien-tay")) {
				foreach ($role['users'] as $key1 => $user) {
					foreach ($user as $key2 => $item) {
						foreach ($item as $e) {
							array_push($data, $e);

						}

					}
				}
			}
		}
		return $data;
	}
	public function asm_qn(){
		$roles = $this->role_model->find_where(['status' => 'active']);
		$data = [];
		foreach ($roles as $key => $role) {
			if (!empty($role['users']) && ($role['slug'] == "asm-qn")) {
				foreach ($role['users'] as $key1 => $user) {
					foreach ($user as $key2 => $item) {
						foreach ($item as $e) {
							array_push($data, $e);

						}

					}
				}
			}
		}
		return $data;
	}
	public function asm_binh_duong(){
		$roles = $this->role_model->find_where(['status' => 'active']);
		$data = [];
		foreach ($roles as $key => $role) {
			if (!empty($role['users']) && ($role['slug'] == "asm-binh-duong")) {
				foreach ($role['users'] as $key1 => $user) {
					foreach ($user as $key2 => $item) {
						foreach ($item as $e) {
							array_push($data, $e);

						}

					}
				}
			}
		}
		return $data;
	}
	public function asm_bac_trung_bo(){
		$roles = $this->role_model->find_where(['status' => 'active']);
		$data = [];
		foreach ($roles as $key => $role) {
			if (!empty($role['users']) && ($role['slug'] == "asm-bac-trung-bo")) {
				foreach ($role['users'] as $key1 => $user) {
					foreach ($user as $key2 => $item) {
						foreach ($item as $e) {
							array_push($data, $e);

						}

					}
				}
			}
		}
		return $data;
	}
	public function getGroupRole_asm()
	{
		$groupRoles = $this->group_role_model->find_where(array("status" => "active", 'slug' => 'quan-ly-khu-vuc'));

		$arr = array();
		foreach ($groupRoles as $groupRole) {
			if (!empty($groupRole['users'])) {

				foreach ($groupRole['users'] as $value) {
					foreach ($value as $key => $item) {
						foreach ($item as $e) {
							array_push($arr, $e);
						}

					}

				}
			}
		}
		return $arr;
	}
	public function getGroupRole_rsm_check()
	{
		$groupRoles = $this->group_role_model->find_where(array("status" => "active", 'slug' => 'quan-ly-vung'));

		$arr = array();
		foreach ($groupRoles as $groupRole) {
			if (!empty($groupRole['users'])) {

				foreach ($groupRole['users'] as $value) {
					foreach ($value as $key => $item) {
						foreach ($item as $e) {
							array_push($arr, $e);
						}

					}

				}
			}
		}
		return $arr;
	}

	public function cron_get_all_data_bds_total_mongo_read_post(){

		$this->dataPost = $this->input->post();

		$month = !empty($this->dataPost['month']) ? date('m', strtotime($this->dataPost['month'])) : date('m');
		$year = !empty($this->dataPost['month']) ? date('Y', strtotime($this->dataPost['month'])) : date('Y');
		$day = date("d",strtotime("yesterday"));

		if(date('d') == '01'){
			$last_month = date('m', strtotime('-1 month'));
			$month = $last_month;
		}

		$condition_month = array(
			'$gte' => strtotime(trim("$year-$month-01") . ' 00:00:00'),
			'$lte' => strtotime(trim("2030-$month-$day") . ' 23:59:59')
		);

		//Tháng trước
		$newdate = strtotime('-1 month', strtotime("$year-$month-01"));
		$year_last_month = date('Y', $newdate);
		$last_month = date('m', $newdate);
		$endDayLastMonth = $this->lastday($last_month, $year_last_month);

		$condition_lastMonth = array(
			'$gte' => strtotime(trim("$year_last_month-$last_month-01") . ' 00:00:00'),
			'$lte' => strtotime(trim("2030-$last_month-$endDayLastMonth") . ' 23:59:59')
		);

		$dataStore = $this->store_model->find_where(['status' => "active", 'name' => ['$nin' => ["Bảo hiểm PTI","Telesales HO","HO Hồ Chí Minh","IT test","Task Force Miền Nam","Task Force Miền Bắc","NextPay","Direct Sale KGN","Direct Sale HNI","Direct Sale HCM 2"]]]);

		$data = [];
		if (!empty($dataStore)) {
			for ($i = 0; $i < count($dataStore); $i++) {
				$data[$i]['name'] = $dataStore[$i]['name'];
				$data[$i]['address'] = $dataStore[$i]['address'];
				$data[$i]['code_area'] = name_area($dataStore[$i]['code_area']);
				$data[$i]['province'] = $dataStore[$i]['province']['name'];

				//Miền
				$area = $this->area_model->findOne(['code' => $dataStore[$i]['code_area']]);
				$data[$i]['area'] = $area['domain']['name'];

				//Số lượng hđ xe máy
				$data[$i]['count_hd_xm'] = $this->contract_model->count_live_excel(['year' => $year, 'month' => $month, 'day' => $day, 'data.loan_infor.type_property.code' => 'XM', 'data.store.id' => (string)$dataStore[$i]['_id'], 'data.disbursement_date' => $condition_month, 'data.code_contract_parent_cc' => array('$exists' => false), 'data.code_contract_parent_gh' => array('$exists' => false), 'data.tat_toan_gh' => array('$exists' => false), 'data.status' => array('$in' => list_array_trang_thai_dang_vay_tat_toan())]);
				//Số lượng hđ ô tô
				$data[$i]['count_hd_oto'] = $this->contract_model->count_live_excel(['year' => $year, 'month' => $month, 'day' => $day, 'data.loan_infor.type_property.code' => 'OTO', 'data.store.id' => (string)$dataStore[$i]['_id'], 'data.disbursement_date' => $condition_month, 'data.code_contract_parent_cc' => array('$exists' => false), 'data.code_contract_parent_gh' => array('$exists' => false), 'data.tat_toan_gh' => array('$exists' => false), 'data.status' => array('$in' => list_array_trang_thai_dang_vay_tat_toan())]);

				//Số lượng hđ 1 tháng
				$data[$i]['count_hd_1'] = $this->contract_model->count_live_excel(['year' => $year, 'month' => $month, 'day' => $day, 'data.loan_infor.type_property.code' => ['$nin' => ['NĐ']] , 'data.loan_infor.number_day_loan' => "30", 'data.store.id' => (string)$dataStore[$i]['_id'], 'data.disbursement_date' => $condition_month, 'data.code_contract_parent_cc' => array('$exists' => false), 'data.code_contract_parent_gh' => array('$exists' => false), 'data.tat_toan_gh' => array('$exists' => false), 'data.status' => array('$in' => list_array_trang_thai_dang_vay_tat_toan())]);

				//Số lượng hđ 3 tháng
				$data[$i]['count_hd_3'] = $this->contract_model->count_live_excel(['year' => $year, 'month' => $month, 'day' => $day, 'data.loan_infor.type_property.code' => ['$nin' => ['NĐ']] ,'data.loan_infor.number_day_loan' => "90", 'data.store.id' => (string)$dataStore[$i]['_id'], 'data.disbursement_date' => $condition_month, 'data.code_contract_parent_cc' => array('$exists' => false), 'data.code_contract_parent_gh' => array('$exists' => false), 'data.tat_toan_gh' => array('$exists' => false), 'data.status' => array('$in' => list_array_trang_thai_dang_vay_tat_toan())]);

				//Số lượng hđ lớn hơn 6 tháng
				$data[$i]['count_hd_6'] = $this->contract_model->count_live_excel(['year' => $year, 'month' => $month, 'day' => $day, 'data.loan_infor.type_property.code' => ['$nin' => ['NĐ']] ,'data.loan_infor.number_day_loan' => ['$in' => ['180', '270', '360', '720', '540']], 'data.status' => array('$in' => list_array_trang_thai_dang_vay_tat_toan()), 'data.store.id' => (string)$dataStore[$i]['_id'], 'data.disbursement_date' => $condition_month, 'data.code_contract_parent_cc' => array('$exists' => false), 'data.code_contract_parent_gh' => array('$exists' => false), 'data.tat_toan_gh' => array('$exists' => false)]);

				//Tiền giải ngân mới trong kỳ
				$data[$i]['amount_money'] = $this->contract_model->sum_where_total_read_live(['year' => $year, 'month' => $month, 'day' => $day, 'data.loan_infor.type_property.code' => ['$nin' => ['NĐ']] ,'data.store.id' => (string)$dataStore[$i]['_id'], 'data.disbursement_date' => $condition_month, 'data.code_contract_parent_cc' => array('$exists' => false), 'data.code_contract_parent_gh' => array('$exists' => false), 'data.tat_toan_gh' => array('$exists' => false), 'data.status' => array('$in' => list_array_trang_thai_dang_vay_tat_toan())], array('$toLong' => '$data.loan_infor.amount_money'));

				//Dư nợ trong hạn kỳ trước
				$data[$i]['du_no_trong_han_T10_ky_truoc'] = $this->contract_model->sum_where_total_read_live(['year' => $year_last_month, 'month' => $last_month, 'day' => $endDayLastMonth, 'data.loan_infor.type_property.code' => ['$nin' => ['NĐ']] , 'data.store.id' => (string)$dataStore[$i]['_id'], 'data.status' => array('$in' => list_array_trang_thai_dang_vay()), 'data.debt.so_ngay_cham_tra' => ['$lte' => 10], 'data.tat_toan_gh' => array('$exists' => false)], '$data.debt.tong_tien_goc_con');

				//Dư nợ trong hạn kỳ hien tai
				$data[$i]['du_no_trong_han_T10_hien_tai'] = $this->contract_model->sum_where_total_read_live(['year' => $year, 'month' => $month, 'day' => $day, 'data.store.id' => (string)$dataStore[$i]['_id'], 'data.loan_infor.type_property.code' => ['$nin' => ['NĐ']] , 'data.status' => array('$in' => list_array_trang_thai_dang_vay()), 'data.debt.so_ngay_cham_tra' => ['$lte' => 10], 'data.tat_toan_gh' => array('$exists' => false)], '$data.debt.tong_tien_goc_con');

				//Dư nợ tăng net T+10
				$data[$i]['du_no_tang_net_T10'] = $data[$i]['du_no_trong_han_T10_hien_tai'] - $data[$i]['du_no_trong_han_T10_ky_truoc'];

				//Dư nợ quản lý
				$data[$i]['du_no_quan_ly'] = $this->contract_model->sum_where_total_read_live(['year' => $year, 'month' => $month, 'day' => $day, 'data.store.id' => (string)$dataStore[$i]['_id'], 'data.loan_infor.type_property.code' => ['$nin' => ['NĐ']] , 'data.status' => array('$in' => list_array_trang_thai_dang_vay()), 'data.tat_toan_gh' => array('$exists' => false)], '$data.debt.tong_tien_goc_con');

				//Dư nợ quản lý tháng trước
				$du_no_quan_ly_ky_truoc = $this->contract_model->sum_where_total_read_live(['year' => $year_last_month, 'month' => $last_month, 'day' => $endDayLastMonth, 'data.store.id' => (string)$dataStore[$i]['_id'], 'data.loan_infor.type_property.code' => ['$nin' => ['NĐ']] , 'data.status' => array('$in' => list_array_trang_thai_dang_vay()), 'data.tat_toan_gh' => array('$exists' => false)], '$data.debt.tong_tien_goc_con');

				//Dư nợ tăng net
				$data[$i]['du_no_tang_net'] = $data[$i]['du_no_quan_ly'] - $du_no_quan_ly_ky_truoc;

				//Dư nợ B0
				$data[$i]['total_du_no_b0'] = $this->contract_model->sum_where_total_read_live(['year' => $year, 'month' => $month, 'day' => $day, 'data.loan_infor.type_property.code' => ['$nin' => ['NĐ']] , 'data.debt.so_ngay_cham_tra' => ['$lte' => 0], 'data.store.id' => (string)$dataStore[$i]['_id'], 'data.status' => array('$in' => list_array_trang_thai_dang_vay()), 'data.tat_toan_gh' => array('$exists' => false)], '$data.debt.tong_tien_goc_con');
				//Dư nợ B1
				$data[$i]['total_du_no_b1'] = $this->contract_model->sum_where_total_read_live(['year' => $year, 'month' => $month, 'day' => $day, 'data.loan_infor.type_property.code' => ['$nin' => ['NĐ']] , 'data.debt.so_ngay_cham_tra' => ['$gte' => 1, '$lte' => 30], 'data.store.id' => (string)$dataStore[$i]['_id'], 'data.status' => array('$in' => list_array_trang_thai_dang_vay()), 'data.tat_toan_gh' => array('$exists' => false)], '$data.debt.tong_tien_goc_con');
				//Dư nợ B2
				$data[$i]['total_du_no_b2'] = $this->contract_model->sum_where_total_read_live(['year' => $year, 'month' => $month, 'day' => $day, 'data.loan_infor.type_property.code' => ['$nin' => ['NĐ']] , 'data.debt.so_ngay_cham_tra' => ['$gte' => 31, '$lte' => 60], 'data.store.id' => (string)$dataStore[$i]['_id'], 'data.status' => array('$in' => list_array_trang_thai_dang_vay()), 'data.tat_toan_gh' => array('$exists' => false)], '$data.debt.tong_tien_goc_con');
				//Dư nợ B3
				$data[$i]['total_du_no_b3'] = $this->contract_model->sum_where_total_read_live(['year' => $year, 'month' => $month, 'day' => $day, 'data.loan_infor.type_property.code' => ['$nin' => ['NĐ']] , 'data.debt.so_ngay_cham_tra' => ['$gte' => 61, '$lte' => 90], 'data.store.id' => (string)$dataStore[$i]['_id'], 'data.status' => array('$in' => list_array_trang_thai_dang_vay()), 'data.tat_toan_gh' => array('$exists' => false)], '$data.debt.tong_tien_goc_con');
				//Dư nợ B4+
				$data[$i]['total_du_no_b4'] = $this->contract_model->sum_where_total_read_live(['year' => $year, 'month' => $month, 'day' => $day, 'data.loan_infor.type_property.code' => ['$nin' => ['NĐ']] , 'data.debt.so_ngay_cham_tra' => ['$gte' => 91], 'data.store.id' => (string)$dataStore[$i]['_id'], 'data.status' => array('$in' => list_array_trang_thai_dang_vay()), 'data.tat_toan_gh' => array('$exists' => false)], '$data.debt.tong_tien_goc_con');

				//Bảo hiểm
				$data[$i]['bao_hiem'] = $this->insurance_model->sum_where_total(['year' => $year, 'month' => $month, 'day' => $day, 'data.store.id' => (string)$dataStore[$i]['_id']], '$data.commision.doanh_so');

				$data[$i]['year'] = date('Y');
				$data[$i]['month'] = date('m');
				$data[$i]['day'] = date('d');
				$this->view_report_debt_bds_model->insert($data[$i]);
			}
		}
		$response = array(
			'status' => REST_Controller::HTTP_OK,
		);
		$this->set_response($response, REST_Controller::HTTP_OK);



	}

	public function get_all_data_total_bds_mongo_read_post(){

		$this->dataPost = $this->input->post();

		$month = !empty($this->dataPost['date']) ? date('m', strtotime($this->dataPost['date'])) : date('m');
		$year = !empty($this->dataPost['date']) ? date('Y', strtotime($this->dataPost['date'])) : date('Y');
		$day = !empty($this->dataPost['date']) ? date('d', strtotime($this->dataPost['date'])) : date('d');

		$data = $this->view_report_debt_bds_model->find_where(['year' => $year, 'month' => $month, 'day' => $day]);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $data
		);
		$this->set_response($response, REST_Controller::HTTP_OK);

	}

	public function get_all_data_contract_post()
	{

		$data = $this->input->post();
		$condition = [];

		$start_old = '2019-01-01';

		$end = !empty($data['tdate']) ? $data['tdate'] : date('Y-m-d');

		$area = !empty($data['area']) ? $data['area'] : "";

		if ($area == "MB") {
			$condition['store'] = $this->list_store(['KV_HN1', 'KV_QN', 'KV_BTB']);
		} elseif ($area == "MN") {
			$condition['store'] = $this->list_store(['KV_HCM1','KV_HCM2','KV_MK','KV_BD']);
		} elseif ($area == "Priority"){
			$condition['store'] = $this->list_store(['Priority']);
		}

		$condition['tdate'] = strtotime(trim($start_old) . ' 00:00:00');
		$condition['fdate'] = strtotime(trim($end) . ' 23:59:59');

		$data_contract = $this->contract_model->get_all_data_contract($condition);

		if(!empty($data_contract)){

			foreach ($data_contract as $value){
				//Tiền trả 1 kỳ
				$tempo = $this->contract_tempo_model->findOne_select(['code_contract' => $value['code_contract']]);
				$value['tien_ky'] = $tempo['tien_tra_1_ky'];

				//Số kỳ đã thanh toán
				$value['so_ki_thanh_toan'] = $this->contract_tempo_model->count(['code_contract' => $value['code_contract'], 'status' => 2]);

				//Thông tin PGD giải ngân hợp đồng
				$province = $this->store_model->find_one_select(['_id' =>  new MongoDB\BSON\ObjectId($value['store']['id'])],['province.name','district.name','code_area']);
				$value['province'] = $province['province']['name'];
				$value['district'] = $province['district']['name'];
				$value['code_area'] = $province['code_area'];

				//Kỳ quá hạn xa nhất
				$date_pay = $this->transaction_model->find_where_desc_select(['code_contract' => $value['code_contract'], 'status' => 1],['date_pay'])[0];
				$value['ky_thanh_toan_gan_nhat'] = $date_pay['date_pay'];

			}
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $data_contract
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
	}

	public function list_store($area){
		$store = $this->store_model->find_where(['code_area' => ['$in' => $area]]);
		$arr = [];
		foreach ($store as $value){
			array_push($arr, (string)$value['_id']);
		}
		return array_unique($arr);
	}

	public function updateStatusHandOver_post(){
		$data = [];
		$dataPost = $this->input->post();
		$code_contract = !empty($dataPost['code_contract']) ? $this->security->xss_clean($dataPost['code_contract']) : '';
		$data['handOverImg'] = !empty($dataPost['handOverImg']) ? $this->security->xss_clean($dataPost['handOverImg']) : '';
		$data['noteHandOver'] = !empty($dataPost['noteHandOver']) ? $this->security->xss_clean($dataPost['noteHandOver']) : '';
		$data['wareAssetLocation'] = !empty($dataPost['wareAssetLocation']) ? $this->security->xss_clean($dataPost['wareAssetLocation']) : '';
		$data['wareAssetLocationName'] = !empty($dataPost['wareAssetLocationName']) ? $this->security->xss_clean($dataPost['wareAssetLocationName']) : '';
		$data['created_at'] = $this->createdAt;
		$data['created_by'] = $this->uemail;

		//Status = 1 - Gửi yêu cầu bàn giao thiết bị, Status = 2 - Xác nhận lưu thiết bị về kho
		$data['statusHandOver'] = 1;

		$this->contract_model->update(
			array("code_contract" => $code_contract),
			array("loan_infor.device_asset_location.handOver" => $data)
		);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
	}

	public function getWareHouseAssetLocation_post(){

		$getData = $this->warehouse_asset_location_model->find_where(['level' => 1, 'status' => 'active']);

		if(empty($getData)){
			return;
		} else {
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'data' => $getData
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
		}


	}

	public function get_all_contract_post(){

		$condition = [];
		$this->dataPost = $this->input->post();
		$code_contract_disbursement = !empty($this->dataPost['code_contract_disbursement']) ? $this->dataPost['code_contract_disbursement'] : "";
		$statusHandOver = !empty($this->dataPost['statusHandOver']) ? $this->dataPost['statusHandOver'] : "";
		$code = !empty($this->dataPost['code']) ? $this->dataPost['code'] : "";

		if (!empty($code_contract_disbursement)) {
			$condition['code_contract_disbursement'] = $code_contract_disbursement;
		}
		if (!empty($statusHandOver)) {
			$condition['statusHandOver'] = $statusHandOver;
		}
		if (!empty($code)) {
			$condition['code'] = $code;
		}

		$per_page = !empty($this->dataPost['per_page']) ? $this->dataPost['per_page'] : 30;
		$uriSegment = !empty($this->dataPost['uriSegment']) ? $this->dataPost['uriSegment'] : 0;

		$getData = $this->contract_model->find_where_hand_over($condition, $per_page, $uriSegment);

		$condition['count'] = 1;

		$getCount = $this->contract_model->find_where_hand_over($condition);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $getData ?? [],
			'count' => $getCount ?? 0
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
	}

}

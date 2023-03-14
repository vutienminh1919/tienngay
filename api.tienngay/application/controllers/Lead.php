<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
require_once APPPATH . 'libraries/REST_Controller.php';
include_once APPPATH . '/libraries/LogCI.php';
include_once APPPATH . '/libraries/TelegramBotHandlerV1.php';
use Restserver\Libraries\REST_Controller;

class Lead extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("lead_model");
		$this->load->model("log_lead_model");
		$this->load->model("dashboard_model");
		$this->load->model("landing_page_model");
		$this->load->helper('lead_helper');
		$this->load->model('log_accesstrade_model');
		$this->load->model('lead_at_log_model');
		$this->load->model('lead_investors_model');
		$this->load->model('lead_dinos_log_model');
		$this->load->model('webhook_vbee_model');
		$this->load->model('log_vbee_model');
		$this->load->model('recording_model');
		$this->load->model('contract_model');
		$this->load->model('transaction_model');
		$this->load->model('contract_tempo_model');
		$this->load->model('payment_model');
		$this->load->model('exemptions_model');
		$this->load->model('temporary_plan_contract_model');
		$this->load->model('log_vbee_thn_model');
		$this->load->model('vbee_thn_model');
		$this->load->model('vbee_thn_qua_han_model');
		$this->load->model('vbee_thn_toi_han_model');
		$this->load->model('log_vbee_missed_call_model');
		$this->load->model('list_topup_model');
		$this->load->model('contract_debt_caller_model');
		$this->load->model('config_global_model');
		$this->load->model('log_config_global_model');
		$this->load->model('lead_phan_nguyen_log_model');
		$this->load->model('list_taivay_model');
		$this->ci =& get_instance();
		$this->ci->config->load('config');
		$this->baseURL = $this->ci->config->item("missed_call");
		$this->baseURL1 = $this->ci->config->item("vbee_call");
		$this->createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		$this->load->library('LogCI');
		$headers = $this->input->request_headers();
        $dataPost = $this->input->post();
        $this->flag_login = 1;
        if (!empty($headers['Authorization']) || !empty($headers['authorization'])) {
            $headers_item = !empty($headers['Authorization']) ? $headers['Authorization'] : $headers['authorization'];
            $token = Authorization::validateToken($headers_item);
            if ($token != false) {
                // Kiểm tra tài khoản và token có khớp nhau và có trong db hay không
                $this->app_login = array(
                    '_id'=>new \MongoDB\BSON\ObjectId($token->id),
                    'email'=>$token->email,
                    "status" => "active",
                    // "is_superadmin" => 1
                );
                //Web
                if($dataPost['type'] == 1) $this->app_login['token_web'] = $headers_item;
                if($dataPost['type'] == 2) $this->app_login['token_app'] = $headers_item;
                $count_account = $this->user_model->count($this->app_login);
                $this->flag_login = 'success';
                if ($count_account != 1) $this->flag_login = 2;
                if ($count_account == 1){
                    $this->info = $this->user_model->findOne($this->app_login);
                    $this->id = $this->info['_id'];
                    // $this->ulang = $this->info['lang'];
                    $this->uemail = $this->info['email'];
                }
            }
        }
	}

	private $createdAt;

	public function loannow_post()
	{
		$data = $this->input->post();
		if (empty($data['type_finance']) || empty($data['phone_number'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => 'Fields can not empty'
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

		$data['fullname'] = $this->security->xss_clean($data['fullname']);
		$data['phone_number'] = convert_zero_phone($this->security->xss_clean($data['phone_number']));
		$data['type_finance'] = $this->security->xss_clean($data['type_finance']);
		$data['type_finance'] = $data['type_finance'];
		$data['type'] = $data['type'];
		$data['status_sale'] = (!empty($data['status_sale'])) ? $data['status_sale'] : '1';
		$data['city'] = $this->security->xss_clean($data['city']);
		$data['call'] = $this->security->xss_clean($data['call']);
		$data['status'] = $this->security->xss_clean($data['status']);
		$data['created_at'] = $this->createdAt;
		$data['area'] = $this->security->xss_clean($data['city']);
//		$data['status_call']= '0';

//Count number
		$lead = $this->lead_model->findOne_langding(array("phone_number" => $data['phone_number']));
		if (!empty($lead)) {
			$current_day = strtotime(date('m/d/Y'));
			$datetime = !empty($lead[0]['created_at']) ? intval($lead[0]['created_at']) : $current_day;
			$time = intval(($current_day - $datetime) / (24 * 60 * 60));
			$last = 1 - $time;
			if ($time >= 1) {
				$this->lead_model->insert($data);

			} else {
				$response = array(
					'status' => REST_Controller::HTTP_UNAUTHORIZED,
					'message' => "Số điện thoại đã được đăng ký, vui lòng đăng ký sau " . $last . " ngày nữa"
				);
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			}
		} else {

			$this->lead_model->insert($data);

		}
//Summary for dashboard
		$dashboard = $this->dashboard_model->find();
		if (isset($dashboard[0]['lead_customer']['not_call'])) {
			$count = $dashboard[0]['lead_customer']['not_call'];
			$this->dashboard_model->update(
				array("_id" => $dashboard[0]['_id']),
				array("lead_customer.not_call" => $count + 1)
			);
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => 'Loan now successfully'
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
	}

	public function servicenow_post()
	{
		$data = $this->input->post();
		if (empty($data['type_finance']) || empty($data['phone_number'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => 'Fields can not empty'
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		$data['phone_number'] = convert_zero_phone($this->security->xss_clean($data['phone_number']));
		$data['type_finance'] = $this->security->xss_clean($data['type_finance']);
		$data['type_finance'] = $data['type_finance'];
		$data['status_sale'] = (!empty($data['status_sale'])) ? $data['status_sale'] : '1';
		$data['service'] = $this->security->xss_clean($data['service']);
		$data['call'] = $this->security->xss_clean($data['call']);
		$data['status'] = $this->security->xss_clean($data['status']);
		$data['created_at'] = $this->createdAt;
		$data['area'] = $this->security->xss_clean($data['city']);
//		$data['status_call'] = '0';
		//Count number
		$lead = $this->lead_model->findOne_langding(array("phone_number" => $data['phone_number']));
		if (!empty($lead)) {
			$current_day = strtotime(date('m/d/Y'));
			$datetime = !empty($lead[0]['created_at']) ? intval($lead[0]['created_at']) : $current_day;
			$time = intval(($current_day - $datetime) / (24 * 60 * 60));
			$last = 1 - $time;
			if ($time >= 1) {
				$this->lead_model->insert($data);

			} else {
				$response = array(
					'status' => REST_Controller::HTTP_UNAUTHORIZED,
					'message' => "Số điện thoại đã được đăng ký, vui lòng đăng ký sau " . $last . " ngày nữa"
				);
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			}
		} else {

			$this->lead_model->insert($data);

		}

		//Summary for dashboard
		$dashboard = $this->dashboard_model->find();
		if (isset($dashboard[0]['lead_customer']['not_call'])) {
			$count = $dashboard[0]['lead_customer']['not_call'];
			$this->dashboard_model->update(
				array("_id" => $dashboard[0]['_id']),
				array("lead_customer.not_call" => $count + 1)
			);
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => 'Loan now successfully'
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
	}

	public function register_lading_post()
	{

		$link = isset($_POST['link']) ? $_POST['link'] : "";
		$name = isset($_POST['name']) ? $_POST['name'] : "";
		$phoneNumber = isset($_POST['phone']) ? $_POST['phone'] : "";
		$utmSource = isset($_POST['utm_source']) ? $_POST['utm_source'] : "direct";
		$utmCampaign = isset($_POST['utm_campaign']) ? $_POST['utm_campaign'] : $link;
		$typeLoan = isset($_POST['type_loan']) ? $_POST['type_loan'] : "";
		$address = isset($_POST['address']) ? $_POST['address'] : "";
		$lead_uuid = isset($_POST['lead_uuid']) ? $_POST['lead_uuid'] : "";

//		$utmSource = "Dinos";
//		$utmCampaign = "https://dangky.tienngay.vn/dinos?utm_source=Dinos&utm_param_sub_id=b7f4e7ff28c3261d370b0b98748b4432";

		$click_id_masoffer = "";
		$click_id_dinos = "";
		if ($utmSource == "masoffer" && !empty($utmCampaign)) {

			$click_id = explode("=", $utmCampaign);

			$click_id = $click_id[2];
			$click_id_masoffer = !empty($click_id) ? $click_id : "";

		}
		if ($utmSource == "Dinos" && !empty($utmCampaign)) {

			$click_id = explode("=", $utmCampaign);
			$click_id = $click_id[2];
			$click_id_dinos = !empty($click_id) ? $click_id : "";

		}

		//Kh giới thiệu khách hàng - 200k
		$presenter_name = isset($_POST['presenter_name']) ? $_POST['presenter_name'] : "";
		$customer_phone_introduce = isset($_POST['presenter_phone']) ? $_POST['presenter_phone'] : "";
		$presenter_email = isset($_POST['presenter_email']) ? $_POST['presenter_email'] : "";
		$presenter_stk = isset($_POST['presenter_stk']) ? $_POST['presenter_stk'] : "";
		$presenter_bank = isset($_POST['presenter_bank']) ? $_POST['presenter_bank'] : "";


		$page = "";
		$area = '00';
		if (!empty($utmCampaign)) {
			if (strlen(strstr(strtoupper($utmCampaign), "HN")) > 0) {
				$area = '01';
			} elseif (strlen(strstr(strtoupper($utmCampaign), "HCM")) > 0) {
				$area = '79';
			} else {
				$area = '00';
			}
		}

		if (!empty($utmCampaign)) {
			$source = explode("/", $utmCampaign);
			if (count($source) > 2) {
				$toss = $source[3];
			}
		}
		if (!empty($toss) && $toss == "toss") {
			$utmSource = "Toss";
		}

		$source_new = "1";
		if ($utmSource == "KH") {
			$source_new = "11";
		}
		if ($utmSource == "phan_nguyen") {
			$source_new = "phan_nguyen";
		}

		$result = array();
		$data = array(
			"fullname" => $name,
			"phone_number" => convert_zero_phone($phoneNumber),
			"utm_source" => $utmSource,
			"utm_campaign" => $utmCampaign,
			"type_finance" => $this->get_finance($typeLoan),
			"address" => $address,
			"source" => $source_new,
			'link' => $link,
			"status" => '1',
			"area" => $area,
			"status_sale" => '1',
			"status_call" => '0',
			"ip" => $this->get_client_ip(),
			"created_at" => $this->createdAt,
			"click_id_masoffer" => $click_id_masoffer,
			"click_id_dinos" => $click_id_dinos,
			"click_id_phan_nguyen" => $lead_uuid,
			"presenter_name" => $presenter_name,
			"customer_phone_introduce" => $customer_phone_introduce,
			"presenter_email" => $presenter_email,
			"presenter_stk" => $presenter_stk,
			"presenter_bank" => $presenter_bank,
			"call_vbee" => "0",

		);
		$lead = $this->lead_model->findOne_langding(array("phone_number" => convert_zero_phone($phoneNumber)));


		if (!empty($lead)) {

			$current_day = strtotime(date('m/d/Y'));
			$datetime = !empty($lead[0]['created_at']) ? intval($lead[0]['created_at']) : $current_day;
			$time = intval(($current_day - $datetime) / (24 * 60 * 60));
			$last = 1 - $time;
			if ($time >= 1) {
				$this->lead_model->insert($data);

				$response = array(
					'status' => REST_Controller::HTTP_OK,
					'message' => "Create success"
				);
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			} else {

				date_default_timezone_set('Asia/Ho_Chi_Minh');

				$leadData = $this->lead_at_log_model->findOne(array("phone_number" => convert_zero_phone($phoneNumber)));

				if (!empty($leadData['utm_campaign'])) {
					$tracking_id = explode("=", $leadData['utm_campaign']);
					$result_tracking = $tracking_id[2];
					if (count($tracking_id) > 3) {
						$result_tracking_1 = explode("&", $tracking_id[2]);
						$result_tracking = $result_tracking_1[0];
					}
				}
				$data2 = array(

					"conversion_id" => !empty($leadData['_id']) ? (string)$leadData['_id'] : "",

					"conversion_result_id" => "30",

					"tracking_id" => !empty($result_tracking) ? $result_tracking : "",

					"transaction_id" => !empty($leadData['_id']) ? (string)$leadData['_id'] : "",

					"transaction_time" => !empty($leadData["created_at"]) ? date('Y-m-d\TH:i:s.Z\Z', $leadData["created_at"]) : "",

					"transaction_value" => 0,

					"status" => 2,

					"extra" => [
						"rejected_reason" => "Trùng số điện thoại",
						"phone_number" => $leadData['phone_number']
					],

					"is_cpql" => 1,

					"items" => []

				);

				$data_string = json_encode($data2);

				$ch = curl_init('https://api.accesstrade.vn/v1/postbacks/conversions');

				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

				curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				curl_setopt($ch, CURLOPT_HTTPHEADER, array(

					'Content-Type: application/json',

					'Authorization: Token fn1-vtdKGhR3afT1eJ3qw3XS9N3yv78K'

				));

				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);

				curl_setopt($ch, CURLOPT_TIMEOUT, 2); //timeout in seconds

				curl_exec($ch);

				//insert log
				$this->log_accesstrade_model->insert($data2);


				$response = array(
					'status' => REST_Controller::HTTP_UNAUTHORIZED,
					'message' => "Số điện thoại đã được đăng ký, vui lòng đăng ký sau " . $last . " ngày nữa"
				);
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			}


		} else {

			if ($utmSource == "accesstrade" || $utmSource == "google") {
				$this->lead_at_log_model->insert($data);
			}
			if ($utmSource == "Dinos") {
				$this->lead_dinos_log_model->insert($data);
			}
			if ($utmSource == "phan_nguyen") {
				$this->lead_phan_nguyen_log_model->insert($data);
				//Send message to bot Telegram
				$environment = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'production';
				$message = 'Thời gian: ' . date('d/m/Y H:i:s', time()) . "\n" .
							'Client: ' . $environment . "\n" .
							'Name: ' . $data['fullname'] . "\n" .
							'Phone: ' . $data['phone_number'] . "\n" .
							'utm_source: ' . $data['utm_source'] . "\n" .
							'utm_campaign: ' . $data['utm_campaign'] . "\n" .
							'IP: ' . $data['ip'];
				$token_bot = '5677407264:AAHoYlb2MHttJffSnpJINXDdBAMRacmMnLg';
				$channel = '-645505318';
				$telegram_bot = new TelegramBotHandlerV1($token_bot, $channel);
				$telegram_bot->sendMessage($message);
				//End send message
			}
			$this->lead_model->insert($data);

			//Masoffer
			//api_key = 9Tprs9wMJ4q2Q7lB -- Masoffer
			//
			if ($utmSource == "masoffer" && $click_id_masoffer != "") {
				$api_key = "9Tprs9wMJ4q2Q7lB";
				$lead_masoffer = $this->lead_model->findOne(array("phone_number" => convert_zero_phone($phoneNumber)));
				$transaction_id_masoffer = (string)$lead_masoffer['_id'];

				$url = "https://s2s.riofintech.net/v1/tienngay/postback.json?api_key=$api_key&postback_type=cpl_standard_postback&transaction_id=$transaction_id_masoffer&click_id=$click_id_masoffer&status_code=0";

				$ch = curl_init($url);

				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);

				curl_setopt($ch, CURLOPT_TIMEOUT, 2); //timeout in seconds

				$result = curl_exec($ch);

				curl_close($ch);

				echo $result;
			}

			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'message' => "Create success"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

	}

	private function api_dinos($click_id)
	{

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.dinos.vn/api/v1/post_back_campaign_redirect?click_id=$click_id&status=pending",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
		));

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;


	}

	public function run_area_post()
	{
		$lead = $this->lead_model->find();
		foreach ($lead as $key => $value) {
			$link = (isset($value['link'])) ? $value['link'] : '';
			if (!empty($link)) {
				$page_url = explode('?', $link, 2);
				$page = $page_url[0];
			}
			$area = '01';
			$lang_ding = $this->landing_page_model->findOne(array("url" => $page));
			if (!empty($lang_ding)) {
				$area = $lang_ding['province_id'];
			}
			//Update lead
			$this->lead_model->update(
				array("_id" => $value['_id']),
				array('area' => $area)
			);
		}
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "OK"
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function run_area_log_post()
	{
		$lead = $this->log_lead_model->find();

		foreach ($lead as $key => $value_t) {
			$value = $value_t['old_data'];
			$page = "";
			$link = (isset($value['link'])) ? $value['link'] : '';
			if (!empty($link)) {
				$page_url = explode('?', $link, 2);
				$page = $page_url[0];
			}
			$area = '01';
			$lang_ding = $this->landing_page_model->findOne(array("url" => $page));
			if (!empty($lang_ding)) {
				$area = $lang_ding['province_id'];
			}
			//Update lead
			$this->log_lead_model->update(
				array("_id" => $value_t['_id']),
				array('old_data.area' => $area)
			);
		}
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "OK"
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function get_finance($id)
	{
		switch ($id) {
			case 'Vay cầm cố xe máy':
				return "2";
				break;
			case 'Vay cầm cố ô tô':
				return "1";
				break;
			case 'Vay tiền bằng đăng ký xe máy':
				return "4";
				break;
			case 'Vay tiền bằng đăng ký xe ô tô':
				return "3";
				break;
				break;
			case 'Vay tiền bằng cà vẹt xe/ đăng ký xe máy':
				return "4";
				break;
			case 'Vay tiền bằng cà vẹt xe/ đăng ký xe ô tô':
				return "3";
				break;
		}
	}

	public function get_client_ip()
	{
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if (getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if (getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if (getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if (getenv('HTTP_FORWARDED'))
			$ipaddress = getenv('HTTP_FORWARDED');
		else if (getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'UNKNOWN';

		return $ipaddress;
	}

	public function create_landing_post()
	{

	}

	public function get_advisory()
	{

		$data = $this->input->post();
		if (empty($data['phone_number'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => 'Fields can not empty'
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}

		$data['fullname'] = $this->security->xss_clean($data['fullname']);
		$data['phone_number'] = convert_zero_phone($this->security->xss_clean($data['phone_number']));
		$data['type_finance'] = $this->security->xss_clean($data['type_finance']);
		$data['type_finance'] = $data['type_finance'];
		$data['type'] = $data['type'];
		$data['status_sale'] = (!empty($data['status_sale'])) ? $data['status_sale'] : '1';
		$data['city'] = $this->security->xss_clean($data['city']);
		$data['call'] = $this->security->xss_clean($data['call']);
		$data['status'] = $this->security->xss_clean($data['status']);
		$data['created_at'] = $this->createdAt;
		$data['area'] = '01';
//		$data['status_call'] = '0';
		//Count number
		$lead = $this->lead_model->findOne_langding(array("phone_number" => $data['phone_number']));
		if (!empty($lead)) {
			$current_day = strtotime(date('m/d/Y'));
			$datetime = !empty($lead[0]['created_at']) ? intval($lead[0]['created_at']) : $current_day;
			$time = intval(($current_day - $datetime) / (24 * 60 * 60));
			$last = 1 - $time;
			if ($time >= 1) {
				$this->lead_model->insert($data);

			} else {
				$response = array(
					'status' => REST_Controller::HTTP_UNAUTHORIZED,
					'message' => "Số điện thoại đã được đăng ký, vui lòng đăng ký sau " . $last . " ngày nữa"
				);
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			}
		} else {

			$this->lead_model->insert($data);

		}
//Summary for dashboard
		$dashboard = $this->dashboard_model->find();
		if (isset($dashboard[0]['lead_customer']['not_call'])) {
			$count = $dashboard[0]['lead_customer']['not_call'];
			$this->dashboard_model->update(
				array("_id" => $dashboard[0]['_id']),
				array("lead_customer.not_call" => $count + 1)
			);
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => 'Loan now successfully'
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
	}


	public function register_lading_investors_post()
	{

		$link = isset($_POST['link']) ? $_POST['link'] : "";
		$name = isset($_POST['name']) ? $_POST['name'] : "";
		$phoneNumber = isset($_POST['phone']) ? $_POST['phone'] : "";
		$utmSource = isset($_POST['utm_source']) ? $_POST['utm_source'] : "direct";
		$utmCampaign = isset($_POST['utm_campaign']) ? $_POST['utm_campaign'] : $link;

		$email = isset($_POST['email_ndt']) ? $_POST['email_ndt'] : "";
		$money = isset($_POST['sotien_ndt']) ? $_POST['sotien_ndt'] : "";
		$area = isset($_POST['khuvuc_ndt']) ? $_POST['khuvuc_ndt'] : "";
		$phone_ngt = isset($_POST['sdt_ndt']) ? $_POST['sdt_ndt'] : "";

		$check_lead_ndt = $this->lead_investors_model->findOne_langding(array("phone_number" => convert_zero_phone($phoneNumber)));


		if (empty($check_lead_ndt)) {
			$data = array(
				"fullname" => $name,
				"phone_number" => convert_zero_phone($phoneNumber),
				"utm_source" => $utmSource,
				"utm_campaign" => $utmCampaign,
				"email" => $email,
				"money" => $money,
				"area" => $area,
				"phone_ngt" => $phone_ngt,
				"source" => '1',
				'link' => $link,
				"status" => '1',
				"status_nđt" => '1',
				"ip" => $this->get_client_ip(),
				"created_at" => $this->createdAt,
			);
			$this->lead_investors_model->insert($data);

			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'message' => "Create success"
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
	}

	public function index_lading_investors_post()
	{


		$this->dataPost = $this->input->post();
		$condition = [];

		$fdate = !empty($this->dataPost['fdate']) ? $this->dataPost['fdate'] : "";
		$tdate = !empty($this->dataPost['tdate']) ? $this->dataPost['tdate'] : "";

		if (!empty($fdate)) {
			$condition['fdate'] = strtotime(trim($fdate) . ' 00:00:00');
		}
		if (!empty($tdate)) {
			$condition['tdate'] = strtotime(trim($tdate) . ' 23:59:59');
		}


		$per_page = !empty($this->dataPost['per_page']) ? $this->dataPost['per_page'] : 30;
		$uriSegment = !empty($this->dataPost['uriSegment']) ? $this->dataPost['uriSegment'] : 0;

		$lead_ndt = $this->lead_investors_model->getDataByRole($condition, $per_page, $uriSegment);
		if (empty($lead_ndt)) {
			echo "Không có dữ liệu";
			return;
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $lead_ndt
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function count_index_lading_investors_post()
	{


		$this->dataPost = $this->input->post();
		$condition = [];

		$fdate = !empty($this->dataPost['fdate']) ? $this->dataPost['fdate'] : "";
		$tdate = !empty($this->dataPost['tdate']) ? $this->dataPost['tdate'] : "";


		if (!empty($fdate)) {
			$condition['fdate'] = strtotime(trim($fdate) . ' 00:00:00');
		}
		if (!empty($tdate)) {
			$condition['tdate'] = strtotime(trim($tdate) . ' 23:59:59');
		}


		$lead_ndt = $this->lead_investors_model->getDataByRole_count($condition);
		if (empty($lead_ndt)) {
			echo "Không có dữ liệu";
			return;
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $lead_ndt
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function form_index_post()
	{

		$datapost = $this->input->post();
		if (empty($datapost['phone_number'])) {
			$response = array(
				'status' => REST_Controller::HTTP_UNAUTHORIZED,
				'message' => 'Số điện thoại không được để trống'
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		$datapost['fullname'] = $this->security->xss_clean($datapost['fullname']);
		$datapost['phone_number'] = convert_zero_phone($this->security->xss_clean($datapost['phone_number']));
		$datapost['type_finance'] = $this->security->xss_clean($datapost['type_finance']);
		$datapost['type'] = "1";
		$datapost['area'] = $this->security->xss_clean($datapost['city']);
		$datapost['created_at'] = $this->createdAt;
		$lead = $this->lead_model->findOne_langding(array("phone_number" => $datapost['phone_number']));
		if (!empty($lead)) {
			$current_day = strtotime(date('m/d/Y'));
			$datetime = !empty($lead[0]['created_at']) ? intval($lead[0]['created_at']) : $current_day;
			$time = intval(($current_day - $datetime) / (24 * 60 * 60));
			$last = 1 - $time;
			if ($time >= 1) {
				$this->lead_model->insert($datapost);

			} else {
				$response = array(
					'status' => REST_Controller::HTTP_UNAUTHORIZED,
					'message' => "Số điện thoại đã được đăng ký, vui lòng đăng ký sau " . $last . " ngày nữa"
				);
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			}
		} else {
			$this->lead_model->insert($datapost);
		}
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => 'Đăng ký vay thành công'
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
	}

	//vbee

//đẩy api


	public function import_vbee_post()
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		//20 - Đang gọi,40 - Đã nghe, 50 - Không thành công, 60 - Lỗi
		$secret_key = $this->config->item("vbee_sec_key");
		$access_token = $this->config->item("vbee_token");
		$campaign_id = 16511;
		$count = 0;
		$data = [];
		$start = strtotime(trim(date('Y-m-d')) . ' 8:30:00');
		$end = strtotime(trim(date('Y-m-d')) . ' 17:30:00');
		$current_time = $this->createdAt;
		$date = $this->createdAt;
		$currentTime = date('Y-m-d', (int)$date);
		//Lấy source từ table config_global để truy vấn Lead đẩy qua Vbee
		$source_config_all = $this->config_global_model->findOne(['flag' => 'filter_vbee_all']);
		$source_config_raw = $this->config_global_model->findOne(['flag' => 'vbee_lead']);
		$source_all_convert = explode(',', $source_config_all['source']);
		$source_raw_convert = explode(',', $source_config_raw['source']);
		if (!in_array('phan_nguyen', $source_raw_convert)) {
			array_push($source_all_convert, 'phan_nguyen');
		}
		if ($current_time > $start && $current_time < $end) {
			$leadData = $this->lead_model->find_where(
				array(
					"source" => ['$in' => $source_all_convert],
					"status_call" => "0",
					"status_sale" => ['$in' => ["1"]],
					"scan_date"=> ['$ne' => $currentTime])
			);
		} else {
			$leadData = [];
		}

		if (!empty($leadData)) {
			foreach ($leadData as $value) {
				if (($value['status_sale'] == "1") || ($value['call_vbee'] == 3 && $value['day_call'] == "1")) {
					$data[$count]["phone_number"] = $value['phone_number'];
					$data[$count]["ho_ten"] = !empty($value['fullname']) ? $value['fullname'] : "";
					$count++;
				}
				$this->lead_model->update(array("_id" => $value['_id']), array("status_call" => "1",'scan_date' => $currentTime));
			}
		}

		$data = json_encode($data);
		$response = $this->vbee_import($data, $campaign_id, $access_token);
		$response = json_decode($response);

		if (!empty($response->results) && $response->status == 1) {
			foreach ($response->results as $item) {
				if (!empty($item->phone_number)) {
					$lead = $this->lead_model->find_one_check_phone($item->phone_number);

					if (!empty($lead) && empty($lead[0]['call_id'])) {
						$this->lead_model->update(array("_id" => $lead[0]['_id']), array('call_id' => $item->call_id,'scan_date' => $currentTime,"status_call" => "1"));
					}
					if (!empty($lead[0]['call_id']) && !empty($lead[0]['call_id'])) {
						$this->lead_model->update(array("_id" => $lead[0]['_id']), array('call_id' => $item->call_id,'scan_date' => $currentTime,"status_call" => "1"));
					}
				}
			}
		}
	}

//đẩy api cho vbee

	private function vbee_import($data, $campaign_id, $access_token)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://aicallcenter.vn/api/campaigns/$campaign_id/import?access_token=$access_token",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{\n    \"contacts\":  $data  \n}\t",
			CURLOPT_HTTPHEADER => array(
				"Content-Type: application/json"
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}

//hứng api của vbeee
//vbee_aicc@tienngay.vn
	public function webhook_vbee_post()
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$current_time = $this->createdAt;
		$check_time = strtotime(trim(date('Y-m-d')) . ' 16:50:00');
		$dataDB['request'] = json_decode($this->input->raw_input_stream);
		$check_status_lead = $this->lead_model->findOne(["call_id" => (int)$dataDB['request']->data->call_id]);

		if (!empty($dataDB['request'])) {
			$check_phone = (substr($dataDB['request']->data->key_press, 0, 1));
			$vbeeState = (int)$dataDB['request']->data->state;

			if (!empty($check_status_lead)
				&& ($vbeeState == 20 || $vbeeState == 50 || $vbeeState == 60 || $vbeeState == 40)
			) {
				if ($vbeeState == 40) {
					if ($check_phone == 1 || $check_phone == 2) {
						if ($check_status_lead['status_sale'] == "1") {
							$this->lead_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array('status_sale' => "1", 'status_vbee' => $vbeeState, 'priority' => $check_phone, "status_call" => "1"));
						} else {
							$this->lead_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array('status_vbee' => $vbeeState, "status_call" => "1"));
						}
					} else {
						if ($check_status_lead['status_sale'] == "1") {
							$this->lead_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array('status_sale' => "1", 'status_vbee' => $vbeeState, 'priority' => "3", "status_call" => "1"));
						} else {
							$this->lead_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array('status_vbee' => $vbeeState, "status_call" => "1"));
						}
					}
				} elseif ($vbeeState == 50 || $vbeeState == 60) {
					if ($check_status_lead['status_sale'] == "1") {
						$this->lead_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array('status_sale' => "1", 'status_vbee' => $vbeeState, 'priority' => "3", "status_call" => "1", "call_vbee" => "1"));
					} elseif (($check_status_lead['status_sale'] != "1") && ($check_status_lead['call_vbee'] == "1")) {
						$this->lead_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array('status_vbee' => $vbeeState, "status_call" => "1", "call_vbee" => "2"));
					} elseif (($check_status_lead['status_sale'] != "1") && ($check_status_lead['call_vbee'] == "2")) {
						$this->lead_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array('status_vbee' => $vbeeState, "status_call" => "1", "call_vbee" => "3"));
					}
				}
			}
			$this->log_vbee_model->insert($dataDB);
			$this->webhook_vbee_model->insert($dataDB);

			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'data' => $dataDB,
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
		}
	}

	public function insert_status_call_post()
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$current_time = $this->createdAt;
		$targetTime = $current_time - 24 * 60 * 60;
		$leadData = $this->lead_model->find_where((array("source" => ['$in' => ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "15","17"]], "created_at" => ['$gte' => $targetTime]
		)));
		foreach ($leadData as $value) {
			if (!isset($value["status_call"])) {
				$this->lead_model->update(array("_id" => new \MongoDB\BSON\ObjectId($value['_id'])), array("status_call" => "0"));
			}
		}
	}

	public function vbee_missed_call_import_post()
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$secret_key = $this->config->item("vbee_sec_key");
		$access_token = $this->config->item("vbee_token");
		$campaign_id = 17978;
		$count = 0;
		$data = [];
		$current_time = $this->createdAt;
		$date = $this->createdAt;
		$currentTime = date('Y-m-d', (int)$date);
		$targetTime = time() - 24 * 60 * 60;
		$start = strtotime(trim(date('Y-m-d')) . ' 8:30:00');
		$end = strtotime(trim(date('Y-m-d')) . ' 17:30:00');
		if ($current_time > $start && $current_time < $end) {
			$missedCallData = $this->recording_model->find_where(array
			("status" => "active" ,
				'$and' => [
					array("toExt" => ['$regex' => '^([0-9][0-9][0-9])$']),
					array("toExt" => ['$ne'=> '299'])
				],
				"direction" => "inbound",
				"missed_call_vbee" => ['$exists' => false],
				"created_at" => ['$gte' => (string)$targetTime],
				'scan_date' =>['$ne' => $currentTime ]
			 ));
		}else{
			$missedCallData = [];
		}
		if (!empty($missedCallData)) {
			foreach ($missedCallData as $value) {
				if (($value['status'] == "active") && ($value['direction'] == "inbound")) {
					$data[$count]["phone_number"] = $value["fromNumber"];
					$count++;
				}
				$this->recording_model->update(array("_id" => $value['_id']), array("missed_call_vbee" => "1",'scan_date'=>$currentTime));
			}
		}
		$data = json_encode($data);
		$response = $this->vbee_missed_call_import_1($data, $campaign_id, $access_token);
		$response = json_decode($response);
		if (!empty($response->results) && $response->status == 1) {
			foreach ($response->results as $item) {
				if (!empty($item->phone_number)) {
					$lead = $this->recording_model->find_one_check_phone_vbee($item->phone_number);
					if (!empty($lead) && empty($lead[0]['call_id'])) {
						$this->recording_model->update(array("_id" => $lead[0]['_id']), array('call_id' => $item->call_id, "missed_call_vbee" => "1",'scan_date'=>$currentTime));
					}
				}
			}
		}
	}

	private function vbee_missed_call_import_1($data, $campaign_id, $access_token)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://aicallcenter.vn/api/campaigns/$campaign_id/import?access_token=$access_token",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{\n    \"contacts\":  $data  \n}\t",
			CURLOPT_HTTPHEADER => array(
				"Content-Type: application/json"
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}

	public function webhook_vbee_missed_call_post()
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$current_time = $this->createdAt;

		$dataDB['request'] = json_decode($this->input->raw_input_stream);
		$check_status_lead = $this->recording_model->findOne(["call_id" => (int)$dataDB['request']->data->call_id]);


		if (!empty($dataDB['request'])) {
			$check_phone_number = $dataDB['request']->data->callee_id;
			$check_phone = (substr($dataDB['request']->data->key_press, 0, 1));
			$vbeeState = (int)$dataDB['request']->data->state;

			if (!empty($check_status_lead)
				&& ($vbeeState == 20 || $vbeeState == 50 || $vbeeState == 60 || $vbeeState == 40)
			) {

				if (($vbeeState == 40) && ($check_phone == 3)) {
					$this->recording_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])),
						array("missed_call" => "1",
							'status_vbee' => $vbeeState,
							"missed_call_vbee" => "1"));
				} elseif (($vbeeState == 40) && ($check_phone == 2)) {
					if ($check_status_lead['status'] == "active") {
						$this->recording_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array('status_vbee' => $vbeeState, "missed_call_vbee" => "1"));
					}
					$result = $this->recording_model->findOne(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])));
					$data['phone'] = $result['fromNumber'];
					$response = $this->ndt_import($data);
					$response = json_decode($response);
				} elseif (($vbeeState == 40) && ($check_phone == 1)) {
					if ($missed_call_lead = $this->lead_model->find_where_1(
						array(
							"source" => ['$in' => ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17"]],
							"phone_number" => $check_phone_number
						))
					) {
						$this->lead_model->update(array("_id" => new \MongoDB\BSON\ObjectId($missed_call_lead[0]['_id'])), array
						('status_vbee' => $vbeeState,
							"priority" => "1",
							"missed_call_vbee" => "1",
							"call_id" => $check_status_lead['call_id']));

						$this->recording_model->update(["call_id" => (int)$check_status_lead['call_id']], array
						('status_vbee' => $vbeeState,
							"missed_call_vbee" => "1",
						));
					} else {
						$this->lead_model->insert(
							["phone_number" => $check_phone_number,
								"call_id" => $check_status_lead['call_id'],
								'priority' => "1", 'source' => "3",
								"status_sale" => "1", "status" => "1",
								"created_at" => $current_time,
								"updated_at" => $current_time,
								'status_vbee' => $vbeeState,
								"missed_call_vbee" => "1"]);
						$this->recording_model->update(["call_id" => (int)$check_status_lead['call_id']], array
						('status_vbee' => $vbeeState,
							"missed_call_vbee" => "1",
						));
					}
				} elseif ((($vbeeState == 40) && ($check_phone != 3 || $check_phone != 1 || $check_phone != 2))) {
					$this->recording_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array("missed_call" => "2", "missed_call_vbee" => "1"));
				}

				if (($vbeeState == 50) || ($vbeeState == 60)) {
					if ($check_status_lead['status'] == "active" && empty($check_status_lead['call_vbee'])) {
						$this->recording_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array('status_vbee' => $vbeeState, "call_vbee" => "1", "missed_call_vbee" => "1"));
					}
					if (($check_status_lead['call_vbee'] == "1") && ($check_status_lead['status'] == "active")) {
						$this->recording_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array("call_vbee" => "2"));
					}
					if (($check_status_lead['call_vbee'] == "2") && ($check_status_lead['status'] == "active")) {
						$this->recording_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array('status_vbee' => $vbeeState, "call_vbee" => "3", "missed_call" => "3"));
					}
				}

				$this->log_vbee_missed_call_model->insert($dataDB);
				$response = array(
					'status' => REST_Controller::HTTP_OK,
					'data' => $dataDB,
				);
				$this->set_response($response, REST_Controller::HTTP_OK);
			}
		}
	}

	public function get_missed_call_post()
	{
		$result = $this->recording_model->get_missed_call();
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $result,
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
	}

//đẩy sang  invetor
	private function ndt_import($data)
	{
		$service = $this->baseURL . '/missed_call';
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $service,
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CUSTOMREQUEST => "POST",
		));
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}


	public function vbee_fb_mkt_post()
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		//20 - Đang gọi,40 - Đã nghe, 50 - Không thành công, 60 - Lỗi
		$secret_key = $this->config->item("vbee_sec_key");
		$access_token = $this->config->item("vbee_token");
		$campaign_id = 19415;
		$count = 0;
		$data = [];


		$start = strtotime(trim(date('Y-m-d')) . ' 8:30:00');
		$end = strtotime(trim(date('Y-m-d')) . ' 17:30:00');
		$current_time = $this->createdAt;
		$current_date = date('Y-m-d', $current_time);


		if ($current_time > $start && $current_time < $end) {
			$sources = $this->config_global_model->findOne(['flag' => 'vbee_lead']);
			$arrSource = explode(",", $sources['source']);
			$leadData = $this->lead_model->find_where(
				['$or' => [
					['$and' => [	
						["source" => ['$in' => $arrSource]], 
						["status_call" => ['$in' => ["0", "7"]]], 
						["status_sale" => ['$in' => ["1", "20"]]], 
						["status_vbee" => ['$in' => ['20', 50, 60]]],
						["scan_date" => ['$ne' => $current_date]]
					]], 
					['$and' => 
					[
						["source" => ['$in' => $arrSource]], 
						["status_sale" => ['$in' => ["1", "20"]]], 
						["scan_date" => ['$ne' => $current_date]],
						["status_call" => ['$in' => ["0", "7"]]], 
					]]
				]]);
		} else {
			$leadData = [];
		}
		LogCI::message('dataImport', 'dataImport: '. print_r($leadData, true));
		if (!empty($leadData)) {
			foreach ($leadData as $value) {
				if (($value['status_sale'] == "1" || $value['status_sale'] == "20")) {
					$exists_number  = $this->lead_model->check_phone_exists($value['phone_number']);
					if (empty($exists_number)) {
						$data[$count]["phone_number"] = $value['phone_number'];
						$data[$count]["ho_ten"] = !empty($value['fullname']) ? $value['fullname'] : "";
						$count++;
					} else {
						continue;
					}
				}
				$this->lead_model->update(["_id" => $value['_id']], ["scan_date" => $current_date]);
			}
		}
		$data = json_encode($data);
		$response = $this->tls_fb_mkt($data, $campaign_id, $access_token);
		$response = json_decode($response);
		if (!empty($response->results) && $response->status == 1) {
			foreach ($response->results as $item) {
				if (!empty($item->phone_number)) {
					$lead = $this->lead_model->find_one_check_phone($item->phone_number);
					if (!empty($lead) && empty($lead[0]['call_id'])) {
						$this->lead_model->update(array("_id" => $lead[0]['_id']), array('call_id' => $item->call_id));
					}
					if (!empty($lead[0]['call_id'])){
						$this->lead_model->update(array("_id" => $lead[0]['_id']), array('call_id' => $item->call_id));
					}
				}
			}
			if (!empty($data)) {
				$response = array(
				  'status' => 'import success',
				  'data' => $response
				);
			  } else {
				$response = array(
				  'status' => 'import error',
				  'data' => []
				);
			  }
			  $this->set_response($response, REST_Controller::HTTP_OK);
		}
	}

	public function webhook_fb_mkt_post()
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$current_time = $this->createdAt;
		$check_time = strtotime(trim(date('Y-m-d')) . ' 16:50:00');
		$dataDB['request'] = json_decode($this->input->raw_input_stream);
		$check_status_lead = $this->lead_model->findOne(["call_id" => (int)$dataDB['request']->data->call_id]);

		if (!empty($check_status_lead)) {
			$check_phone = (substr($dataDB['request']->data->key_press, 0, 1)); //bấm phím
			$vbeeState = (int)$dataDB['request']->data->state; //state: 40 - Đã nghe, 50 - Không thành công, 60 - Lỗi
			$note = $dataDB['request']->data->note;
			if (!empty($check_status_lead) && ($vbeeState == 20 || $vbeeState == 50 || $vbeeState == 60 || $vbeeState == 40)) {
				if (($vbeeState == 40 && $note == 'VOICEMAIL_DETECTION') || $vbeeState == 50 || $vbeeState == 60){
					if (($check_status_lead['status_sale'] == "1" || $check_status_lead['status_sale'] == "20") && $check_status_lead['call_vbee'] == "0") {
						$this->lead_model->update(['_id' => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])], ['reason_cancel' => '15','status_sale' => '20', 'status_vbee' => $vbeeState, 'priority' => '3', 'status_call' => '7', "call_vbee" => '1', "day_call" => '1']);
					}
					elseif ($check_status_lead['call_vbee'] == "1" && $check_status_lead['status_call'] == "7") {
						$this->lead_model->update(['_id' => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])], ['reason_cancel' => '15', 'status_sale' => '20', 'status_vbee' => $vbeeState, 'priority' => '3', 'status_call' => '7', "call_vbee" => '2']);
					}
					elseif (!empty($check_status_lead['call_vbee']) && $check_status_lead['call_vbee'] == "2" && $check_status_lead['status_call'] == "7") {
						$this->lead_model->update(['_id' => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])], ['reason_cancel' => '15', 'status_sale' => '20', 'status_vbee' => $vbeeState, 'priority' => '3', 'status_call' => '7', "call_vbee" => '3', "day_call" => '2']);
					}
					elseif (!empty($check_status_lead['call_vbee']) && $check_status_lead['call_vbee'] == "3" && $check_status_lead['status_call'] == "7") {
						$this->lead_model->update(['_id' => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])], ['reason_cancel' => '15', 'status_sale' => '20', 'status_vbee' => $vbeeState, 'priority' => '3', 'status_call' => '7', 'call_vbee' => '4']);
					}
					elseif (!empty($check_status_lead['call_vbee']) && $check_status_lead['call_vbee'] == "4" && $check_status_lead['status_call'] == "7") {
						$this->lead_model->update(['_id' => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])], ['reason_cancel' => '15', 'status_sale' => '20', 'status_vbee' => $vbeeState, 'priority' => '3', 'status_call' => '7', "call_vbee" => '5', 'day_call' => '3']);
					}
					elseif (!empty($check_status_lead['call_vbee']) && $check_status_lead['call_vbee'] == "5" && $check_status_lead['status_call'] == "7") {
						$this->lead_model->update(['_id' => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])], ['reason_cancel' => '51', 'status_sale' => '19', 'status_vbee' => $vbeeState, 'priority' => '3', 'status_call' => '7', "call_vbee" => '6']);
					}
				}

				if ($vbeeState == 40 && ($note != 'VOICEMAIL_DETECTION' || empty($note))) {
					if ($check_phone == 1) {
						if ($check_status_lead['status_sale'] == "1") {
							$this->lead_model->update(['_id' => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])], ['status_sale' => '1', 'status_vbee' => $vbeeState, 'priority' => $check_phone, 'status_call' => '1']);
						} else {
							$this->lead_model->update(['_id' => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])], ['status_call' => '1', 'status_vbee' => $vbeeState, 'priority' => $check_phone]);
						}
					} elseif ($check_phone == 2) {
						if ($check_status_lead['status_sale'] == '1') {
							$this->lead_model->update(['_id' => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])], ['reason_cancel' => '9', 'status_sale' => '19', 'status_vbee' => $vbeeState, 'priority' => $check_phone, 'status_call' => '1']);
						} else {
							$this->lead_model->update(['_id' => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])], ['reason_cancel' => '9', 'status_sale' => '19', 'status_call' => '1', 'status_vbee' => $vbeeState, 'priority' => $check_phone]);
						}
					} else {
						if ($check_status_lead['status_sale'] == '1') {
							$this->lead_model->update(['_id' => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])], ['reason_cancel' => '9', 'status_sale' => '19', 'status_vbee' => $vbeeState, 'priority' => '2', 'status_call' => '1']);
						} else {
							$this->lead_model->update(['_id' => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])], ['reason_cancel' => '9', 'status_sale' => '19', 'status_call' => '1', 'status_vbee' => $vbeeState, 'priority' => '2',]);
						}
					}
				}
			}
			$this->log_vbee_model->insert($dataDB);
			$this->webhook_vbee_model->insert($dataDB);

			$response = [
				'status' => REST_Controller::HTTP_OK,
				'data' => $dataDB,
			];
			$this->set_response($response, REST_Controller::HTTP_OK);
		}
	}

	private function tls_fb_mkt($data, $campaign_id, $access_token)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://aicallcenter.vn/api/campaigns/$campaign_id/import?access_token=$access_token",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{\n    \"contacts\":  $data  \n}\t",
			CURLOPT_HTTPHEADER => array(
				"Content-Type: application/json"
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}

// tìm kiếm bản ghi trước hạn
	public function truoc_han_post()
	{
		$current_time = $this->createdAt;
		$curentime_day = date('Y-m-d', (int)$current_time);
		$start = strtotime(trim(date('Y-m-d')) . ' 8:00:00');
		$end = strtotime(trim(date('Y-m-d')) . ' 17:30:00');
		if ($current_time > $start && $current_time < $end) {
			$result1 = $this->contract_model->find_thn_truoc_han();
		} else {
			$result1 = [];
		}

		if (!empty($result1)) {
			foreach ($result1 as $v) {
				$this->contract_model->update(array("_id" => new \MongoDB\BSON\ObjectId($v['_id'])), array(
					"scan_date" => $curentime_day,
				));
				$code_contract = $v['code_contract'];
				$ky_tra_hien_tai = $v['debt']['ky_tra_hien_tai'];
				$phone = $v['customer_infor']['customer_phone_number'];
				$name = $v['customer_infor']['customer_name'];
				$customer_gender = $v['customer_infor']['customer_gender'];
				$cmt = $v['customer_infor']['customer_identify'];
				$result_temponary_contract = $this->temporary_plan_contract_model->findOne([
					'code_contract' => $code_contract,
					"ky_tra" => $ky_tra_hien_tai,
				]);
				$ky_tra = $result_temponary_contract['ky_tra'];
				$ngay_ky_tra = $result_temponary_contract['ngay_ky_tra'];
				$result_contract = $this->contract_model->find_where_1($code_contract);
				$code_contract_disbursement = $result_contract['code_contract_disbursement'];
				$id_contract = $result_contract['_id'];
				$ngay_cham_tra = $result_contract['debt']['so_ngay_cham_tra'];
				$result = $this->vbee_thn_model->find_where(array(
					"code_contract" => $code_contract,
					'ky_tra' => $ky_tra,
				));
				if (empty($result)) {
					$this->vbee_thn_model->insert([
						"code_contract" => $code_contract,
						"created_at" => $current_time,
						'ngay_ky_tra' => $ngay_ky_tra,
						"code_contract_disbursement" => $code_contract_disbursement,
						"phone" => $phone,
						'status' => 1,
						'cmt' => $cmt,
						'name' => $name,
						'customer_gender' => $customer_gender,
						'ky_tra' => $ky_tra,
						'so_ngay_cham_tra' => $ngay_cham_tra
					]);
				}
			}
		}
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $result1,
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
	}


// tìm kiếm bản ghi quá hạn
	public function qua_han_post()
	{
		$current_time = $this->createdAt;
		$curentime_day = date('Y-m-d', (int)$current_time);
		$start = strtotime(trim(date('Y-m-d')) . ' 8:00:00');
		$end = strtotime(trim(date('Y-m-d')) . ' 17:30:00');
		if ($current_time > $start && $current_time < $end) {
			$result1 = $this->contract_model->find_thn_qua_han();
		} else {
			$result1 = [];
		}
		if (!empty($result1)) {
			foreach ($result1 as $v) {
				$this->contract_model->update(array("_id" => new \MongoDB\BSON\ObjectId($v['_id'])), array(
					"scan_date" => $curentime_day,
				));
				$code_contract = $v['code_contract'];
				$ky_tra_hien_tai = $v['debt']['ky_tra_hien_tai'];
				$phone = $v['customer_infor']['customer_phone_number'];
				$name = $v['customer_infor']['customer_name'];
				$customer_gender = $v['customer_infor']['customer_gender'];
				$cmt = $v['customer_infor']['customer_identify'];
				$result_temponary_contract = $this->temporary_plan_contract_model->findOne([
					'code_contract' => $code_contract,
					"ky_tra" => $ky_tra_hien_tai,
				]);
				$ky_tra = $result_temponary_contract['ky_tra'];
				$ngay_ky_tra = $result_temponary_contract['ngay_ky_tra'];
				$result_contract = $this->contract_model->find_where_1($code_contract);
				$code_contract_disbursement = $result_contract['code_contract_disbursement'];
				$id_contract = $result_contract['_id'];
				$ngay_cham_tra = $result_contract['debt']['so_ngay_cham_tra'];
				$result = $this->vbee_thn_qua_han_model->find_where(array(
					"code_contract" => $code_contract,
					'ky_tra' => $ky_tra,
				));
				if (empty($result)) {
				$dataInsert = [
						"code_contract" => $code_contract,
						"created_at" => $current_time,
						'ngay_ky_tra' => $ngay_ky_tra,
						"code_contract_disbursement" => $code_contract_disbursement,
						"phone" => $phone,
						'status' => 1,
						'cmt' => $cmt,
						'name' => $name,
						'customer_gender' => $customer_gender,
						'ky_tra' => $ky_tra,
						'so_ngay_cham_tra' => $ngay_cham_tra
					];
				$dataQuaHan = $this->vbee_thn_qua_han_model->insert($dataInsert);
				LogCI::message('vbee_thn', 'data qua han reponse : ' . print_r($dataInsert, true));
				}
			}
		}

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $result1,
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
	}


// tìm kiếm bản ghi tới hạn
	public function toi_han_post()
	{
		$current_time = $this->createdAt;
		$curentime_day = date('Y-m-d', (int)$current_time);
		$start = strtotime(trim(date('Y-m-d')) . ' 8:00:00');
		$end = strtotime(trim(date('Y-m-d')) . ' 17:30:00');
		if ($current_time > $start && $current_time < $end) {
			$result1 = $this->contract_model->find_thn_toi_han();
		} else {
			$result1 = [];
		}
		if (!empty($result1)) {
			foreach ($result1 as $v) {
				$this->contract_model->update(array("_id" => new \MongoDB\BSON\ObjectId($v['_id'])), array(
					"scan_date" => $curentime_day
				));
				$code_contract = $v['code_contract'];
				$ky_tra_hien_tai = $v['debt']['ky_tra_hien_tai'];
				$phone = $v['customer_infor']['customer_phone_number'];
				$name = $v['customer_infor']['customer_name'];
				$customer_gender = $v['customer_infor']['customer_gender'];
				$cmt = $v['customer_infor']['customer_identify'];
				$result_temponary_contract = $this->temporary_plan_contract_model->findOne([
					'code_contract' => $code_contract,
					"ky_tra" => $ky_tra_hien_tai,
				]);
				$ky_tra = $result_temponary_contract['ky_tra'];
				$ngay_ky_tra = $result_temponary_contract['ngay_ky_tra'];
				$result_contract = $this->contract_model->find_where_1($code_contract);
				$code_contract_disbursement = $result_contract['code_contract_disbursement'];
				$id_contract = $result_contract['_id'];
				$ngay_cham_tra = $result_contract['debt']['so_ngay_cham_tra'];
				$result = $this->vbee_thn_toi_han_model->find_where(array(
					"code_contract" => $code_contract,
					'ky_tra' => $ky_tra,
				));
				if (empty($result)) {
					$this->vbee_thn_toi_han_model->insert([
						"code_contract" => $code_contract,
						"created_at" => $current_time,
						'ngay_ky_tra' => $ngay_ky_tra,
						"code_contract_disbursement" => $code_contract_disbursement,
						"phone" => $phone,
						'status' => 1,
						'cmt' => $cmt,
						'name' => $name,
						'customer_gender' => $customer_gender,
						'ky_tra' => (int)$ky_tra,
						'so_ngay_cham_tra' => $ngay_cham_tra
					]);
				}
			}
		}


		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'data' => $result1,
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
	}


//chiến dịch trước hạn
	public function vbee_thn_1_import_post()
	{
		LogCI::message('vbee_thn_truoc_han', '================ Run vbee_thn_1_import_post Start ==========================');
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$secret_key = $this->config->item("vbee_sec_key");
		$access_token = $this->config->item("vbee_token");
		$campaign_id = 16639;
		$count = 0;
		$data = [];
		$current_time = $this->createdAt;
		$curentime_day = date('Y-m-d', (int)$current_time);
		$start = strtotime(trim(date('Y-m-d')) . ' 8:30:00');
		$end = strtotime(trim(date('Y-m-d')) . ' 17:30:00');
		$thnCallData = [];
		if ($current_time > $start && $current_time < $end) {
			$thnCallData1 = $this->vbee_thn_model->find_thn_vbee_truoc_han();
			LogCI::message('vbee_thn_truoc_han', 'data $thnCallData1 : ' . print_r($thnCallData1, true));
		} else {
			$thnCallData1 = [];
		}
		foreach ($thnCallData1 as $k) {
		LogCI::message('vbee_thn_truoc_han', 'Run contract : ' . $k['code_contract']);
			$thnCallData_code_contract = $k['code_contract'];
			$thnCallData_ngay_ky_tra = $k['ngay_ky_tra'];
			$thnCallData_ky_tra = $k['ky_tra'];
			$result_temporary = $this->temporary_plan_contract_model->find_where_1(array(
				'code_contract' => $thnCallData_code_contract,
				'ky_tra' => $thnCallData_ky_tra
			));
			$id_temporary = $k['_id'];
			$result_contract_table = $this->contract_model->find_where_1($thnCallData_code_contract);
			$status_contract = $result_contract_table['status'];
			$status_temporary = $result_temporary[0]['status'];
			$result_transaction = $this->transaction_model->checkExistsWatingTrans($thnCallData_code_contract);
			if ($result_transaction) {
				// Nếu có phiếu thu đang chờ duyệt
				LogCI::message('vbee_thn_truoc_han', 'Có phiếu thu đang chờ duyệt: ' . $k['code_contract']);
				continue;
			}else{
				LogCI::message('vbee_thn_truoc_han', 'Không có phiếu thu đang chờ duyệt: ' . $k['code_contract']);
			}
			if ($status_temporary == 1 && $status_contract == 17) {
				// Nếu hợp đồng đang vay và trạng thái kỳ chưa thanh toán
				 $result = $this->vbee_thn_model->findOne(
					array(
						'code_contract' => $thnCallData_code_contract,
						'ngay_ky_tra' => $thnCallData_ngay_ky_tra
					)
				);
				if ($result) {
					$thnCallData[] = $result;
				}
			} else {
				$thnCallData_error = $this->vbee_thn_model->update(
					array("_id" => new \MongoDB\BSON\ObjectId($id_temporary)),
					[
						"thnCallData_error" => 1
					]
				);
				LogCI::message('vbee_thn_truoc_han', 'check  : ' . print_r($thnCallData_error,true));
			}
		}
		LogCI::message('vbee_thn_truoc_han', 'check $thnCallData: ' . print_r($thnCallData,true));
		if (!empty($thnCallData)) {
			$data = [];
			$data2 = [];
			foreach (($thnCallData) as $v) {
				if (isset($data2[$v['phone']])) {
					continue;
				}
				$id_code_contract = $v['code_contract'];
				$result_contract = $this->contract_model->find_where_1($id_code_contract);
				$trans = $this->transaction_model->find_where(array('type' => ['$in' => [3, 4]], 'code_contract' => $v['code_contract']));
				$conti = 0;
				if (!empty($trans)) {
					foreach ($trans as $key => $value_tran) {
						if (in_array($value_tran['status'], [2, 4, 11])) {
							$conti = 1;
							break;
						}
						$tong_thu = $value_tran['total'];
						$tong_chia = round($value_tran['so_tien_lai_da_tra'] + $value_tran['so_tien_phi_da_tra'] + $value_tran['so_tien_goc_da_tra'] + $value_tran['so_tien_phi_cham_tra_da_tra'] + $value_tran['tien_phi_phat_sinh_da_tra'] + $value_tran['fee_finish_contract'] + $value_tran['tien_thua_tat_toan'] + $value_tran['so_tien_phi_gia_han_da_tra']);

						if (strtotime(date('Y-m-d', $result_contract['disbursement_date']) . ' 00:00:00') > strtotime(date('Y-m-d', $value_tran['date_pay']) . ' 00:00:00')) {
							//ngày giải ngân > ngày thanh toán
							$conti = 1;
							break;
						}
						if ($value_tran['type'] == 4 && ($value_tran['type_payment'] == 1 || !isset($value_tran['type_payment'])) && $value_tran['tien_thua_thanh_toan'] > 0) {
							//nếu là phiêu thu thanh toán và  (nó là thanh toán lãi kỳ hoặc không tồn tại laoij thanh toán) và tiền thừa thanh toán lớn hơn 0
							$conti = 1;
							break;
						}
						if (strpos(strtolower($value_tran['note']), 'gia h') && is_string($value_tran['note']) && ($value_tran['type'] == 3 || $value_tran['type'] == 4) && $value_tran['status'] == 1 && !isset($result_contract['type_gh']) && $result_contract['status'] != 33) {
							// phiếu thu gia hạn
							$conti = 1;
							break;
						}
						if ($value_tran['type'] == 3 && $result_contract['status'] != 19) {
							// phiếu thu gia hạn, cơ cấu
							$conti = 1;
							break;
						}
						if ($tong_thu != $tong_chia) {
							// hợp đồng đang sai số liệu
							$conti = 1;
							break;
						}
						if ($value_tran['tien_thua_tat_toan'] > 0) {
							// hợp đồng có tiền thừa tất toán
							$conti = 1;
							break;
						}
						if ($conti == 1) {
							continue;
						}
					}
				}
				$dataCodeContract = $v['code_contract'];
				$danhXung = (!empty($v['customer_gender'] == "1")) ? 'Anh' : 'Chị';
				$resultKiPhaiThanhToanHienTai = strtotime(date('Y-m-d', trim($v['ngay_ky_tra'])) . ' 00:00:00');
				$resultKiPhaiThanhToanHienTaistr = ($v['ngay_ky_tra']);
				$resultKiPhaiThanhToanXaNhat = $this->temporary_plan_contract_model->getKiPhaiThanhToanXaNhat($dataCodeContract);
				$ngayQuaHan = $resultKiPhaiThanhToanXaNhat[0]['ngay_ky_tra'];
				$targetTimeToiHanXaNhat = date('d/m/Y', $resultKiPhaiThanhToanXaNhat[0]['ngay_ky_tra']);
				$targetTimeToiHanXaNhatstr = strtotime(date('Y-m-d', trim($resultKiPhaiThanhToanXaNhat[0]['ngay_ky_tra'])) . ' 00:00:00');
				$id = (string)$result_contract['_id'];
				$current_time = date('d/m/Y');
				$current_time_str = $this->createdAt;
				$response = $this->payment_import(['id' => $id]);
				$response = json_decode($response);
				$total_money_paid = (isset($response->tong_tien_thanh_toan)) ? $response->tong_tien_thanh_toan : 0;
				$total_amount = (isset($response->tong_tien_tat_toan)) ? $response->tong_tien_tat_toan : 0;
				if (($resultKiPhaiThanhToanHienTai == $targetTimeToiHanXaNhatstr) && $total_amount > 0) {
					LogCI::message('vbee_thn_truoc_han', 'check ngày thanh toán hiện tại bằng ngày thanh toán xa nhất: ' . ' code_contract' . $v['code_contract']);
					$phone = $v['phone'];
					$data[$count]["id"] = (string)$v["_id"];
					$data[$count]["phone_number"] = $v['phone'];
					$data[$count]["ten"] = $v['name'];
					$data[$count]["dueday"] = $targetTimeToiHanXaNhat;
					$data[$count]["danh_xung"] = $danhXung;
					$data[$count]["amount"] = formatNumber($total_amount);
					$data2[$phone] = (string)$v["_id"];
					$count++;
				} elseif (($current_time_str < $resultKiPhaiThanhToanHienTaistr) && $total_money_paid > 0) {
					LogCI::message('vbee_thn_truoc_han', 'check ngày  hiện tại nhỏ hơn ngày thanh toán hien tai: ' . ' code_contract' . $v['code_contract']);
					$phone = $v['phone'];
					$data[$count]["id"] = (string)$v["_id"];
					$data[$count]["phone_number"] = $v['phone'];
					$data[$count]["ten"] = $v['name'];
					$data[$count]["dueday"] = date('d/m/Y',$resultKiPhaiThanhToanHienTaistr);
					$data[$count]["danh_xung"] = $danhXung;
					$data[$count]["amount"] = formatNumber($total_money_paid);
					$data2[$phone] = (string)$v["_id"];
					$count++;
				}
			}
		}
		$data = json_encode(array_values($data));
		$response = $this->vbee_thn_import_thn($data, $campaign_id, $access_token);
		$response = json_decode($response);
		if (!empty($response->results) && $response->status == 1) {
			foreach ($response->results as $item) {
				if (!empty($item->phone_number)) {
					$data = [
						"id" => $data2[$item->phone_number],
						"phone" => $item->phone_number
					];
					$lead = $this->vbee_thn_model->find_one_check_phone_thn_vbee($data);
					$dayCallThn = !empty($lead['day_call_thn_truoc_han']) ? $lead['day_call_thn_truoc_han'] : 0;
					if ($dayCallThn < 4) {
						$this->vbee_thn_model->update(array("_id" => new \MongoDB\BSON\ObjectId($lead['_id'])), array(
							'day_call_thn_truoc_han' => ($dayCallThn + 1)
						));
					}
					if(!empty($lead)){
						if (empty($lead['call_id'])){
							$this->vbee_thn_model->update(array("_id" => $lead['_id']), array('call_id' => $item->call_id,'scan_date' => $curentime_day));
						}
						elseif (!empty($lead['call_id']) &&  ($dayCallThn < 4) ){
							$this->vbee_thn_model->update(array("_id" => $lead['_id']), array('call_id' => $item->call_id,'scan_date' => $curentime_day));
						}
					}
				}
			}
		}
		if (!empty($response->results) && $response->status == 1) {
			$response = array(
				'status' => 'import success',
				'dataImport' => $data,
				'dataResult' => $response->results
			);
		} else {
			$response = array(
				'status' => 'import error',
				'data' => []
			);
		}
		LogCI::message('vbee_thn_truoc_han', '================ Run vbee_thn_1_import_post End ==========================');
		$this->set_response($response, REST_Controller::HTTP_OK);
	}

	public function webhook_vbee_thn_call_truocHan_post()
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$current_time = $this->createdAt;
		$dataDB['request'] = json_decode($this->input->raw_input_stream);
		$check_status_lead = $this->vbee_thn_model->findOne(["call_id" => (int)$dataDB['request']->data->call_id]);
		$findDataCallId = $this->vbee_thn_model->findOne(["call_id" => (int)$dataDB['request']->data->call_id]);
		$dataContract = $findDataCallId['code_contract'];
		$dataCaller = $this->contract_debt_caller_model->findOneVbee([
			'code_contract' => $dataContract
		]);
		$dataContractTable = $this->contract_model->findOne([
			'code_contract' => $dataContract
		]);
		if (!empty($dataDB['request'])) {
			$amount_truoc_han = $dataDB['request']->import_data->amount;
			$check_phone = (substr($dataDB['request']->data->key_press, 0, 1));
			$vbeeState = (int)$dataDB['request']->data->state;
			$calledAtVbee = $dataDB['request']->data->called_at;
			$duration = $dataDB['request']->data->duration;
			$note = $dataDB['request']->data->note;
			$record = $dataDB['request']->data->record_audio;
			if (!empty($check_status_lead)
				&& ($vbeeState == 20 || $vbeeState == 50 || $vbeeState == 60 || $vbeeState == 40)) {
				if (($vbeeState == 40) && $note == 'VOICEMAIL_DETECTION'){
					if (!isset($check_status_lead['call_vbee_thn_truoc_han'])) {
						$this->vbee_thn_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array(
							'status_vbee' => $vbeeState,
							"call_vbee_thn_truoc_han" => 1,
							"priority_truoc_han" => "1",
							"amount_truoc_han" => $amount_truoc_han,
							"calledAtVbee" => strtotime($calledAtVbee) ,
							'call_thn_truoc_han' => 1
						));
						$this->vbee_thn_model->update_recording_vbee_thn_truoc_han($check_status_lead['_id'], $record);
					} else if ($check_status_lead['day_call_thn_truoc_han'] == 3 && $check_status_lead['call_vbee_thn_truoc_han'] == 3) {
						// Cuộc gọi lần thứ 3 của ngày thứ 3
						$callVbeeThn_truoc_han = $check_status_lead['call_vbee_thn_truoc_han'] + 1;
						$this->vbee_thn_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array(
							"call_vbee_thn_truoc_han" => $callVbeeThn_truoc_han,
							'status_vbee' => $vbeeState,
							"calledAtVbee" => strtotime($calledAtVbee),
							"call_thn_that_bai_truoc_han" => 1,
							"amount_truoc_han" => $amount_truoc_han,
							'call_thn_truoc_han' => 1,
							"call_thn_truoc_han_that_bai" => 1,
							'store_name' => $dataContractTable['store']['name'],
							'caller' => $dataCaller[0]['debt_caller_name'],
							'so_ngay_cham_tra' => $dataContractTable['debt']['so_ngay_cham_tra']
						));
						$this->vbee_thn_model->update_recording_vbee_thn_truoc_han($check_status_lead['_id'], $record);
					} else {
						// Các cuộc gọi của các ngày trong tháng 1 -> 3
						if ($check_status_lead['call_vbee_thn_truoc_han'] == 3) {
							// Nếu đã gọi đủ 3 cuộc trong 1 ngày. update dữ liệu sang ngày mới.
							$dayCall = $check_status_lead['day_call_thn_truoc_han'];
							$callVbeeThn_truoc_han = 0;
						} else {
							$dayCall = $check_status_lead['day_call_thn_truoc_han'];
							$callVbeeThn_truoc_han = $check_status_lead['call_vbee_thn_truoc_han'] + 1;
						}
						$this->vbee_thn_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array(
							'status_vbee' => $vbeeState,
							"call_vbee_thn_truoc_han" => $callVbeeThn_truoc_han,
							"day_call_thn_truoc_han" => $dayCall,
							"priority_truoc_han" => "1",
							"calledAtVbee" => strtotime($calledAtVbee) ,
							"amount_truoc_han" => $amount_truoc_han,
							'call_thn_truoc_han' => 1,
							'store_name' => $dataContractTable['store']['name'],
							'caller' => $dataCaller[0]['debt_caller_name'],
							'so_ngay_cham_tra' => $dataContractTable['debt']['so_ngay_cham_tra']
							));
						$this->vbee_thn_model->update_recording_vbee_thn_truoc_han($check_status_lead['_id'], $record);
					}
				}
				if ($vbeeState == 40 && empty($note == 'VOICEMAIL_DETECTION' )) {
					if (($check_phone == 1) || ($check_phone == 5) || ($check_phone === "0")) {
						$this->vbee_thn_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array(
							'status_vbee' => $vbeeState,
							'key_press' => $check_phone,
							"calledAtVbee" => strtotime($calledAtVbee),
							"duration" => $duration,
							"priority_truoc_han" => "3",
							"amount_truoc_han" => $amount_truoc_han,
							'call_thn_truoc_han' => 1,
							'call_thn_truoc_han_thanh_cong' => 1,
							'store_name' => $dataContractTable['store']['name'],
							'caller' => $dataCaller[0]['debt_caller_name'],
							'so_ngay_cham_tra' => $dataContractTable['debt']['so_ngay_cham_tra']
						));
						$this->vbee_thn_model->update_recording_vbee_thn_truoc_han($check_status_lead['_id'], $record);
					} else {
						$this->vbee_thn_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array(
							'status_vbee' => $vbeeState,
							"calledAtVbee" =>strtotime($calledAtVbee) ,
							"duration" => $duration,
							"priority_truoc_han" => "2",
							"amount_truoc_han" => $amount_truoc_han,
							'call_thn_truoc_han' => 1,
							'call_thn_truoc_han_thanh_cong' => 1,
							'store_name' => $dataContractTable['store']['name'],
							'caller' => $dataCaller[0]['debt_caller_name'],
							'so_ngay_cham_tra' => $dataContractTable['debt']['so_ngay_cham_tra']
						));
						$this->vbee_thn_model->update_recording_vbee_thn_truoc_han($check_status_lead['_id'], $record);
					}
				}
				if (($vbeeState == 50) || ($vbeeState == 60)) {
					if (!isset($check_status_lead['call_vbee_thn_truoc_han'])) {
						$this->vbee_thn_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array(
							'status_vbee' => $vbeeState,
							"call_vbee_thn_truoc_han" => 1,
							"priority_truoc_han" => "1",
							"amount_truoc_han" => $amount_truoc_han,
							"calledAtVbee" => strtotime($calledAtVbee),
							'call_thn_truoc_han' => 1
							));
					} else if ($check_status_lead['day_call_thn_truoc_han'] == 3 && $check_status_lead['call_vbee_thn_truoc_han'] == 3) {
						// Cuộc gọi lần thứ 2 của ngày thứ 3
						$callVbeeThn_truoc_han = $check_status_lead['call_vbee_thn_truoc_han'] + 1;
						$this->vbee_thn_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array(
							"call_vbee_thn_truoc_han" => $callVbeeThn_truoc_han,
							'status_vbee' => $vbeeState,
							"calledAtVbee" => strtotime($calledAtVbee),
							"call_thn_that_bai_truoc_han" => 1,
							"amount_truoc_han" => $amount_truoc_han,
							'call_thn_truoc_han' => 1,
							"call_thn_truoc_han_that_bai" => 1,
							'store_name' => $dataContractTable['store']['name'],
							'caller' => $dataCaller[0]['debt_caller_name'],
							'so_ngay_cham_tra' => $dataContractTable['debt']['so_ngay_cham_tra']

							));
					} else {
						// Các cuộc gọi của các ngày trong tháng 1 -> 3
						if ($check_status_lead['call_vbee_thn_truoc_han'] == 3) {
							// Nếu đã gọi đủ 2 cuộc trong 1 ngày. update dữ liệu sang ngày mới.
							$dayCall = $check_status_lead['day_call_thn_truoc_han'];
							$callVbeeThn_truoc_han = 0;
						} else {
							$dayCall = $check_status_lead['day_call_thn_truoc_han'];
							$callVbeeThn_truoc_han = $check_status_lead['call_vbee_thn_truoc_han'] + 1;
						}
						$this->vbee_thn_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array(
							'status_vbee' => $vbeeState,
							"call_vbee_thn_truoc_han" => $callVbeeThn_truoc_han,
							"day_call_thn_truoc_han" => $dayCall,
							"priority_truoc_han" => "1",
							"calledAtVbee" => strtotime($calledAtVbee),
							"amount_truoc_han" => $amount_truoc_han,
							'call_thn_truoc_han' => 1,
							'store_name' =>  $dataContractTable['store']['name'],
							'caller' => $dataCaller[0]['debt_caller_name'],
							'so_ngay_cham_tra' => $dataContractTable['debt']['so_ngay_cham_tra']
							));
					}
				}
			}
			$this->log_vbee_thn_model->insert($dataDB);
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'data' => $dataDB,
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
		}
	}
//chiến dịch tới hạn
	public function vbee_thn_2_import_post()
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$secret_key = $this->config->item("vbee_sec_key");
		$access_token = $this->config->item("vbee_token");
		$campaign_id = 19275;
		$count = 0;
		$data = [];
		$current_time = $this->createdAt;
		$start = strtotime(trim(date('Y-m-d')) . ' 8:30:00');
		$end = strtotime(trim(date('Y-m-d')) . ' 17:30:00');
		$thnCallData = [];
		if ($current_time > $start && $current_time < $end) {
			$thnCallData1 = $this->vbee_thn_toi_han_model->find_thn_vbee_toi_han();
		} else {
			$thnCallData1 = [];
		}
		foreach ($thnCallData1 as $k) {
			$thnCallData_code_contract = $k['code_contract'];
			$thnCallData_ngay_ky_tra = $k['ngay_ky_tra'];
			$thnCallData_ky_tra = $k['ky_tra'];
			$result_temporary = $this->temporary_plan_contract_model->find_where_1(array(
				'code_contract' => $thnCallData_code_contract,
				'ky_tra' => $thnCallData_ky_tra
			));
			$id_temporary = $k['_id'];
			$result_contract_table = $this->contract_model->find_where_1($thnCallData_code_contract);
			$status_contract = $result_contract_table['status'];
			$status_temporary = $result_temporary[0]['status'];
			$result_transaction = $this->transaction_model->checkExistsWatingTrans($thnCallData_code_contract);
			if ($result_transaction) {
				// Nếu có phiếu thu đang chờ duyệt
				continue;
			}
			if ($status_temporary == 1 && $status_contract == 17) {
				// Nếu hợp đồng đang vay và trạng thái kỳ chưa thanh toán
				$result = $this->vbee_thn_toi_han_model->findOne(
					array(
						'code_contract' => $thnCallData_code_contract,
						'ngay_ky_tra' => $thnCallData_ngay_ky_tra
					)
				);
				if ($result) {
					$thnCallData[] = $result;
				}
			} else {
				$thnCallData_error = $this->vbee_thn_toi_han_model->update(
					array("_id" => new \MongoDB\BSON\ObjectId($id_temporary)),
					[
						"thnCallData_error" => 1
					]
				);
			}
		}
		if (!empty($thnCallData)) {
			$data = [];
			$data2 = [];
			foreach ($thnCallData as $v) {
				if (isset($data2[$v['phone']])) {
					continue;
				}
				$id_code_contract = $v['code_contract'];
				$result_contract = $this->contract_model->find_where_1($id_code_contract);
					$trans = $this->transaction_model->find_where(array('type' => ['$in' => [3, 4]], 'code_contract' => $id_code_contract));
					$conti = 0;
					if (!empty($trans)) {
						foreach ($trans as $key => $value_tran) {
							if (in_array($value_tran['status'], [2, 4, 11])) {
								$conti = 1;
								break;
							}
							$tong_thu = $value_tran['total'];
							$tong_chia = round($value_tran['so_tien_lai_da_tra'] + $value_tran['so_tien_phi_da_tra'] + $value_tran['so_tien_goc_da_tra'] + $value_tran['so_tien_phi_cham_tra_da_tra'] + $value_tran['tien_phi_phat_sinh_da_tra'] + $value_tran['fee_finish_contract'] + $value_tran['tien_thua_tat_toan'] + $value_tran['so_tien_phi_gia_han_da_tra']);

							if (strtotime(date('Y-m-d', $c['disbursement_date']) . ' 00:00:00') > strtotime(date('Y-m-d', $value_tran['date_pay']) . ' 00:00:00')) {
								//ngày giải ngân > ngày thanh toán
								$conti = 1;
								break;
							}
							if ($value_tran['type'] == 4 && ($value_tran['type_payment'] == 1 || !isset($value_tran['type_payment'])) && $value_tran['tien_thua_thanh_toan'] > 0) {
								//nếu là phiêu thu thanh toán và  (nó là thanh toán lãi kỳ hoặc không tồn tại laoij thanh toán) và tiền thừa thanh toán lớn hơn 0
								$conti = 1;
								break;
							}
							if (strpos(strtolower($value_tran['note']), 'gia h') && is_string($value_tran['note']) && ($value_tran['type'] == 3 || $value_tran['type'] == 4) && $value_tran['status'] == 1 && !isset($c['type_gh']) && $c['status'] != 33) {
								// phiếu thu gia hạn
								$conti = 1;
								break;
							}
							if ($value_tran['type'] == 3 && $c['status'] != 19) {
								// phiếu thu gia hạn, cơ cấu
								$conti = 1;
								break;
							}
							if ($tong_thu != $tong_chia) {
								// hợp đồng đang sai số liệu
								$conti = 1;
								break;
							}
							if ($value_tran['tien_thua_tat_toan'] > 0) {
								// hợp đồng có tiền thừa tất toán
								$conti = 1;
								break;
							}
							if ($conti == 1) {
								continue;
							}
						}
					}
					$dataCodeContract = $v['code_contract'];
					$ngay_ky_tra_ht = date('d/m/Y', $v['ngay_ky_tra']);
					$danhXung = (!empty($v['customer_gender'] == "1")) ? 'Anh' : 'Chị';
					$resultKiPhaiThanhToanXaNhat = $this->temporary_plan_contract_model->getKiPhaiThanhToanXaNhat($dataCodeContract);
					$ngayToiHanXaNhat = date("d/m/Y" , $resultKiPhaiThanhToanXaNhat[0]['ngay_ky_tra']);
					$id = (string)$result_contract['_id'];
					$current_date = date('d/m/Y');
					$response = $this->payment_import(['id' => $id]);
					$response = json_decode($response);
					$total_money_paid = (isset($response->tong_tien_thanh_toan)) ? $response->tong_tien_thanh_toan : 0;
					$total_amount = (isset($response->tong_tien_tat_toan)) ? $response->tong_tien_tat_toan : 0;
					if (($current_date == $ngayToiHanXaNhat ) && $total_amount > 0) {
						$phone = $v['phone'];
						$data[$count]["id"] = (string)$v["_id"];
						$data[$count]["phone_number"] = $v['phone'];
						$data[$count]["ten"] = $v['name'];
						$data[$count]["danh_xung"] = $danhXung ;
						$data[$count]["amount"] = formatNumber($total_amount);
						$data2[$phone] = (string)$v["_id"];
						$count++;
					} elseif (($current_date == $ngay_ky_tra_ht ) && $total_money_paid > 0) {
						$phone = $v['phone'];
						$data[$count]["id"] = (string)$v["_id"];
						$data[$count]["phone_number"] = $v['phone'];
						$data[$count]["ten"] = $v['name'];
						$data[$count]["danh_xung"] = $danhXung ;
						$data[$count]["amount"] = formatNumber($total_money_paid);
						$data2[$phone] = (string)$v["_id"];
						$count++;
					}
			}
		}
		$data = json_encode(array_values($data));
		$response = $this->vbee_thn_import_thn($data, $campaign_id, $access_token);
		$response = json_decode($response);
		if (!empty($response->results) && $response->status == 1) {
			foreach ($response->results as $item) {
				if (!empty($item->phone_number)) {
					$data = [
						"id" => $data2[$item->phone_number],
						"phone" => $item->phone_number
					];
					$lead = $this->vbee_thn_toi_han_model->find_one_check_phone_thn_vbee($data);
					if (!empty($lead) && empty($lead['call_id'])) {
						$this->vbee_thn_toi_han_model->update(array("_id" => $lead['_id']), array('call_id' => $item->call_id,'scan_date' => date('Y-m-d',$current_time)));
					}
				}
			}
		}
		if (!empty($data)) {
			$response = array(
				'status' => 'import success',
				'data' => $response
			);
		} else {
			$response = array(
				'status' => 'import error',
				'data' => []
			);
		}
		$this->set_response($response, REST_Controller::HTTP_OK);
	}

	public function webhook_vbee_thn_call_toiHan_post()
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$current_time = $this->createdAt;
		$dataDB['request'] = json_decode($this->input->raw_input_stream);
		$check_status_lead = $this->vbee_thn_toi_han_model->findOne(["call_id" => (int)$dataDB['request']->data->call_id]);
		$findDataCallId = $this->vbee_thn_toi_han_model->findOne(["call_id" => (int)$dataDB['request']->data->call_id]);
		$dataContract = $findDataCallId['code_contract'];
		$dataCaller = $this->contract_debt_caller_model->findOneVbee([
			'code_contract' => $dataContract
		]);
		$dataContractTable = $this->contract_model->findOne([
			'code_contract' => $dataContract
		]);
		if (!empty($dataDB['request'])) {
			$amount_toi_han = $dataDB['request']->import_data->amount;
			$vbeeState = (int)$dataDB['request']->data->state;
			$calledAtVbeeToiHan = ($dataDB['request']->data->called_at);
			$durationToiHan = $dataDB['request']->data->duration;
			$check_phone = (substr($dataDB['request']->data->key_press, 0, 1));
			$end_code = (string)$dataDB['request']->data->end_code;
			$note = $dataDB['request']->data->note;
			$record = $dataDB['request']->data->record_audio;
			if (!empty($check_status_lead)
				&& ($vbeeState == 20 || $vbeeState == 50 || $vbeeState == 60 || $vbeeState == 40)) {
					if (($vbeeState == 40) && $note == 'VOICEMAIL_DETECTION'){
						if ($check_status_lead['status'] == 1 && empty($check_status_lead['call_vbee_toi_han'])) {
							$this->vbee_thn_toi_han_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])),
								array('status_vbee' => $vbeeState,
									"call_vbee_toi_han" => 1, "amount_th" => $amount_toi_han,
									"calledAtVbee" => strtotime($calledAtVbeeToiHan),
									"call_thn_toi_han" => 1,
									'store_name' => $dataContractTable['store']['name'],
									'caller' => $dataCaller[0]['debt_caller_name'],
									'so_ngay_cham_tra' => $dataContractTable['debt']['so_ngay_cham_tra']
								));
							$this->vbee_thn_toi_han_model->update_recording_vbee_thn_toi_han($check_status_lead['_id'], $record);
						} elseif (($check_status_lead['status'] == 1) && ($check_status_lead['call_vbee_toi_han'] == 1)) {
							$this->vbee_thn_toi_han_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])),
								array("call_vbee_toi_han" => 2, "calledAtVbee" =>strtotime($calledAtVbeeToiHan)));
							$this->vbee_thn_toi_han_model->update_recording_vbee_thn_toi_han($check_status_lead['_id'], $record);
						} elseif (($check_status_lead['status'] == 1) && ($check_status_lead['call_vbee_toi_han'] == 2)) {
							$this->vbee_thn_toi_han_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])),
								array('status_vbee' => $vbeeState,
									"call_vbee_toi_han" => 3,
									"call_thn_toi_han" => 1,
									"calledAtVbee" => strtotime($calledAtVbeeToiHan),
									"call_thn_toi_han_that_bai" => 1,
									 "status_end_code" => 'KHÁCH KHÔNG BẮT MÁY',
									'store_name' => $dataContractTable['store']['name'],
									'caller' => $dataCaller[0]['debt_caller_name'],
									'so_ngay_cham_tra' => $dataContractTable['debt']['so_ngay_cham_tra']
								));
							$this->vbee_thn_toi_han_model->update_recording_vbee_thn_toi_han($check_status_lead['_id'], $record);
						}
					}
					if ($vbeeState == 40 && empty($note == 'VOICEMAIL_DETECTION' )){
						if ($end_code == 'DONG_Y_THANH_TOAN'
							|| $end_code == "KHONG_DONG_Y_THANH_TOAN"
							|| $end_code == "SAI_THONG_TIN"
							|| $end_code == "BUSY"
							|| $end_code == "SAI_THONG_TIN_KH"
							|| $end_code == "VOICEMAIL"
							|| $end_code == "NGUOI_THAN"
							|| $end_code == "SILENT"
							|| $end_code == "DEFAULT_FALL"
						 ){
							$this->vbee_thn_toi_han_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array(
								'status_vbee' => $vbeeState,
								"status_end_code" => $end_code,
								"call_thn_toi_han" => 1,
								"calledAtVbee" => strtotime($calledAtVbeeToiHan),
								"duration" => $durationToiHan,
								"amount_th" => $amount_toi_han,
								"call_thn_toi_han_thanh_cong" => 1,
								'store_name' => $dataContractTable['store']['name'],
								'caller' => $dataCaller[0]['debt_caller_name'],
								'so_ngay_cham_tra' => $dataContractTable['debt']['so_ngay_cham_tra']
							 ));
							$this->vbee_thn_toi_han_model->update_recording_vbee_thn_toi_han($check_status_lead['_id'], $record);
						} else {
							$this->vbee_thn_toi_han_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array(
								'status_vbee' => $vbeeState,
								"status_end_code" => 'KHÁCH DẬP MÁY NGANG',
								"call_thn_toi_han" => 1,
								"calledAtVbee" =>strtotime($calledAtVbeeToiHan),
								"duration" => $durationToiHan,
								"amount_th" => $amount_toi_han,
								"call_thn_toi_han_thanh_cong" => 1,
								'store_name' => $dataContractTable['store']['name'],
								'caller' => $dataCaller[0]['debt_caller_name'],
								'so_ngay_cham_tra' => $dataContractTable['debt']['so_ngay_cham_tra']
							));
							$this->vbee_thn_toi_han_model->update_recording_vbee_thn_toi_han($check_status_lead['_id'], $record);
						}
					}
				if ($vbeeState == 50 || $vbeeState == 60) {
					if ($check_status_lead['status'] == 1 && empty($check_status_lead['call_vbee_toi_han'])) {
						$this->vbee_thn_toi_han_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array('status_vbee' => $vbeeState,
							"call_vbee_toi_han" => 1, "amount_th" => $amount_toi_han,
							"calledAtVbee" => strtotime($calledAtVbeeToiHan) ,
							"call_thn_toi_han" => 1,
							'store_name' => $dataContractTable['store']['name'],
							'caller' => $dataCaller[0]['debt_caller_name'],
							'so_ngay_cham_tra' => $dataContractTable['debt']['so_ngay_cham_tra'],
						 ));
					} elseif (($check_status_lead['status'] == 1) && ($check_status_lead['call_vbee_toi_han'] == 1)) {
						$this->vbee_thn_toi_han_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array("call_vbee_toi_han" => 2, "calledAtVbee" => strtotime($calledAtVbeeToiHan),));
					} elseif (($check_status_lead['status'] == 1) && ($check_status_lead['call_vbee_toi_han'] == 2)) {
						$this->vbee_thn_toi_han_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array('status_vbee' => $vbeeState,
							"call_vbee_toi_han" => 3,
							"call_thn_toi_han" => 1,
							"calledAtVbee" => strtotime($calledAtVbeeToiHan),
							"call_thn_toi_han_that_bai" => 1,
							"status_end_code" => 'KHÁCH KHÔNG BẮT MÁY',
							'store_name' => $dataContractTable['store']['name'],
							'caller' => $dataCaller[0]['debt_caller_name'],
							'so_ngay_cham_tra' => $dataContractTable['debt']['so_ngay_cham_tra'],
							));
					}
				}
			}
			$this->log_vbee_thn_model->insert($dataDB);
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'data' => $dataDB,
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
		}
	}
//chiến dịch quá hạn
	public function vbee_thn_3_import_post()
	{
		LogCI::message('vbee_thn', '================ Run vbee_thn_3_import_post Start ==========================');
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$secret_key = $this->config->item("vbee_sec_key");
		$access_token = $this->config->item("vbee_token");
		$campaign_id = 16638;
		$count = 0;
		$data = [];
		$current_time = $this->createdAt;
		$startTime = strtotime(date('Y-m-01',(int)$current_time));
		$curentime_day = date('Y-m-d', (int)$current_time);
		$start = strtotime(trim(date('Y-m-d')) . ' 8:30:00');
		$end = strtotime(trim(date('Y-m-d')) . ' 17:30:00');
		$thnCallData = [];
		if ($current_time > $start && $current_time < $end) {
			$thnCallData1 = $this->vbee_thn_qua_han_model->find_thn_vbee_qua_han();
			LogCI::message('vbee_thn', 'data $thnCallData1 : ' . print_r($thnCallData1, true));
		} else {
			$thnCallData1 = [];
		}
		foreach ($thnCallData1 as $k) {
		LogCI::message('vbee_thn', 'Run contract : ' . $k['code_contract']);
			$thnCallData_code_contract = $k['code_contract'];
			$thnCallData_ngay_ky_tra = $k['ngay_ky_tra'];
			$thnCallData_ky_tra = $k['ky_tra'];
			$idQuaHan = $k['_id'];
			$result_scan_date = $this->vbee_thn_qua_han_model->update(array("_id" => new \MongoDB\BSON\ObjectId($k['_id'])), array(
				'scan_date' => $curentime_day,
			));
			// Dưới đây là trường hợp phải gọi vebee
			$result_contract_table = $this->contract_model->find_where_1($thnCallData_code_contract);
			$ky_tra_hien_tai = $result_contract_table['debt']['ky_tra_hien_tai'];
			$status_contract = $result_contract_table['status'];
			$result_temporary = $this->temporary_plan_contract_model->find_where_1(array(
				'code_contract' => $thnCallData_code_contract,
				'ky_tra' => $ky_tra_hien_tai
			));
			$id_temporary = $k['_id'];
			$status_temporary = $result_temporary[0]['status'];
			$result_transaction = $this->transaction_model->checkExistsWatingTrans($thnCallData_code_contract);
			// 1. Lấy phiếu thu trong tháng hiện tại
			$transInMonth = $this->transaction_model->find_where_trans(array(
				'code_contract' => $thnCallData_code_contract,
				'date_pay' => ['$lte' => $current_time, '$gte' => $startTime],
				'ky_da_tt_gan_nhat' => ['$exists' => true],
				'status' => 1
			));
			LogCI::message('vbee_thn', 'check transInMonth : ' . count($transInMonth) . ' code_contract: ' . $k['code_contract']);
			if (!empty($transInMonth)) {
				$isCallVbee = false;
				$kyThanhToanGanNhat = $transInMonth[0]['ky_da_tt_gan_nhat'];
				foreach ($transInMonth as $tran) {
					LogCI::message('vbee_thn', 'data  phiếu thu trong tháng hiện tại : ' . $tran['code'] . " code_contract: " . $k['code_contract']);
					$kyThanhToanGanNhat1 = $tran['ky_da_tt_gan_nhat'];
					// Kiểm tra có 2 kỳ đã thanh toán gần nhất khác nhau
					if ($kyThanhToanGanNhat1 != $kyThanhToanGanNhat) {
						$isCallVbee = false;
						break;
					} else {
						$isCallVbee = true;
					}
				}
				LogCI::message('vbee_thn', 'check isCallVbee : ' . $isCallVbee);
				if (!$isCallVbee) {
					continue;
				}
				// kiểm tra kỳ thanh toán gần nhất có được thanh toán trong tháng này hay không.
				$kyThanhToanGanNhatTran = $this->transaction_model->find_where_trans(array(
					'code_contract' => $thnCallData_code_contract,
					'date_pay' => ['$lt' => $startTime],
					'ky_da_tt_gan_nhat' => $kyThanhToanGanNhat
				));
				LogCI::message('vbee_thn', 'data  kiểm tra kỳ thanh toán gần nhất có được thanh toán trong tháng này hay không : ' . print_r($kyThanhToanGanNhatTran, true));
				if (empty($kyThanhToanGanNhatTran)) {
					LogCI::message('vbee_thn', 'kyThanhToanGanNhatTran is empty');
					$isCallVbee = false;
					continue;
				}
			}
			if ($result_transaction) {
				// Nếu có phiếu thu đang chờ duyệt
				LogCI::message('vbee_thn', 'Có phiếu thu đang chờ duyệt: ' . $k['code_contract']);
				continue;
			} else {
				LogCI::message('vbee_thn', 'Không có phiếu thu đang chờ duyệt: ' . $k['code_contract']);
			}
			if ($status_temporary == 1 && $status_contract == 17) {
				// Nếu hợp đồng đang vay và trạng thái kỳ chưa thanh toán
				$result = $this->vbee_thn_qua_han_model->findOne(
					array(
						'code_contract' => $thnCallData_code_contract,
						'ngay_ky_tra' => $thnCallData_ngay_ky_tra
					)
				);
				//LogCI::message('vbee_thn', 'check Nếu hợp đồng đang vay và trạng thái kỳ chưa thanh toán : ' . print_r($result));
				if ($result) {
					$thnCallData[] = $result;
				}
			} else {
				$thnCallData_error = $this->vbee_thn_qua_han_model->update(
					array("_id" => new \MongoDB\BSON\ObjectId($id_temporary)),
					[
						"thnCallData_error" => 1
					]
				);
				LogCI::message('vbee_thn', 'check  : ' . print_r($thnCallData_error,true));
			}
		}
		LogCI::message('vbee_thn', 'check thnCallData: ' . print_r($thnCallData,true));
		if (!empty($thnCallData)) {
			$data = [];
			$data2 = [];
			foreach (($thnCallData) as $v) {
				if (isset($data2[$v['phone']])) {
					continue;
				}
				$id_code_contract = $v['code_contract'];
				$thoiGianThanhToanGanNhat = date('d/m/Y',$v['ngay_ky_tra']);
				$result_contract = $this->contract_model->find_where_1($id_code_contract);
					$trans = $this->transaction_model->find_where(array('type' => ['$in' => [3, 4]], 'code_contract' => $id_code_contract));
					$conti = 0;
					if (!empty($trans)) {
						foreach ($trans as $key => $value_tran) {
							if (in_array($value_tran['status'], [2, 4, 11])) {
								$conti = 1;
								break;
							}
							$tong_thu = $value_tran['total'];
							$tong_chia = round($value_tran['so_tien_lai_da_tra'] + $value_tran['so_tien_phi_da_tra'] + $value_tran['so_tien_goc_da_tra'] + $value_tran['so_tien_phi_cham_tra_da_tra'] + $value_tran['tien_phi_phat_sinh_da_tra'] + $value_tran['fee_finish_contract'] + $value_tran['tien_thua_tat_toan'] + $value_tran['so_tien_phi_gia_han_da_tra']);

							if (strtotime(date('Y-m-d', $c['disbursement_date']) . ' 00:00:00') > strtotime(date('Y-m-d', $value_tran['date_pay']) . ' 00:00:00')) {
								//ngày giải ngân > ngày thanh toán
								$conti = 1;
								break;
							}
							if ($value_tran['type'] == 4 && ($value_tran['type_payment'] == 1 || !isset($value_tran['type_payment'])) && $value_tran['tien_thua_thanh_toan'] > 0) {
								//nếu là phiêu thu thanh toán và  (nó là thanh toán lãi kỳ hoặc không tồn tại laoij thanh toán) và tiền thừa thanh toán lớn hơn 0
								$conti = 1;
								break;
							}
							if (strpos(strtolower($value_tran['note']), 'gia h') && is_string($value_tran['note']) && ($value_tran['type'] == 3 || $value_tran['type'] == 4) && $value_tran['status'] == 1 && !isset($c['type_gh']) && $c['status'] != 33) {
								// phiếu thu gia hạn
								$conti = 1;
								break;
							}
							if ($value_tran['type'] == 3 && $c['status'] != 19) {
								// phiếu thu gia hạn, cơ cấu
								$conti = 1;
								break;
							}
							if ($tong_thu != $tong_chia) {
								// hợp đồng đang sai số liệu
								$conti = 1;
								break;
							}
							if ($value_tran['tien_thua_tat_toan'] > 0) {
								// hợp đồng có tiền thừa tất toán
								$conti = 1;
								break;
							}
							if ($conti == 1) {
								continue;
							}
						}
					}
					$dataCodeContract = $v['code_contract'];
					$danhXung = (!empty($v['customer_gender'] == "1")) ? 'Anh' : 'Chị';
					$resultKiPhaiThanhToanXaNhat = $this->temporary_plan_contract_model->getKiPhaiThanhToanXaNhat($dataCodeContract);
					$resultKiChuaThanhToanGanNhat = $this->temporary_plan_contract_model->getKiChuaThanhToanGanNhat($dataCodeContract);
					$ngaytoihan = $resultKiChuaThanhToanGanNhat[0]['ngay_ky_tra'];
					$ngaytoihan_date = date("d/m/Y" , $ngaytoihan);
					$ngayQuaHan = $resultKiPhaiThanhToanXaNhat[0]['ngay_ky_tra'];
					$ngayQuaHan_date = date("d/m/Y" , $ngayQuaHan);
					$id = (string)$result_contract['_id'];
					//$current_date = date('d/m/Y');
					$current_date = $this->createdAt;
					$response = $this->payment_import(['id' => $id]);
					$response = json_decode($response);
					$total_money_paid = (isset($response->tong_tien_thanh_toan)) ? $response->tong_tien_thanh_toan : 0;
					$total_amount = (isset($response->tong_tien_tat_toan)) ? $response->tong_tien_tat_toan : 0;
					if (($current_date > $ngayQuaHan ) && $total_amount > 0) { // lấy dữ liệu  đẩy sang vbee ( ngày hiện tại lơn hơn ngày chưa thanh toán của kỳ cuối)
						$phone = $v['phone'];
						$data[$count]["id"] = (string)$v["_id"];
						$data[$count]["phone_number"] = $v['phone'];
						$data[$count]["ten"] = $v['name'];
						$data[$count]["ngay"] =  $ngayQuaHan_date;
						$data[$count]["danh_xung"] = $danhXung ;
						$data[$count]["amount"] = formatNumber($total_amount);
						$data2[$phone] = (string)$v["_id"];
						$count++;
					} elseif (($current_date > $ngaytoihan ) && $total_money_paid > 0) {// lấy dữ liệu  đẩy sang vbee ( ngày hiện tại lơn hơn ngày chưa thanh toán của kỳ thanh toán gần nhất)
						$phone = $v['phone'];
						$data[$count]["id"] = (string)$v["_id"];
						$data[$count]["phone_number"] = $v['phone'];
						$data[$count]["ten"] = $v['name'];
						$data[$count]["ngay"] =  $thoiGianThanhToanGanNhat;
						$data[$count]["danh_xung"] = $danhXung ;
						$data[$count]["amount"] = formatNumber($total_money_paid);
						$data2[$phone] = (string)$v["_id"];
						$count++;
					}
			}
		}
		$data = json_encode(array_values($data));
		$response = $this->vbee_thn_import_thn($data, $campaign_id, $access_token);
		$response = json_decode($response);
		if (!empty($response->results) && $response->status == 1) {
			foreach ($response->results as $item) {
				if (!empty($item->phone_number)) {
					$data = [
						"id" => $data2[$item->phone_number],
						"phone" => $item->phone_number
					];
					$lead = $this->vbee_thn_qua_han_model->find_one_check_phone_thn_vbee($data);
					$dayCallThn = !empty($lead['day_call_thn_qua_han']) ? $lead['day_call_thn_qua_han'] : 0;
					if ($lead['day_call_thn_qua_han'] == 0) {
						$this->vbee_thn_qua_han_model->update(array("_id" => new \MongoDB\BSON\ObjectId($lead['_id'])), array(
							'day_call_thn_qua_han' => ($dayCallThn + 2),
						));
					} elseif ($lead['day_call_thn_qh'] != 1 && $lead['day_call_thn_qua_han'] < 30) {
						$this->vbee_thn_qua_han_model->update(array("_id" => new \MongoDB\BSON\ObjectId($lead['_id'])), array(
							'day_call_thn_qua_han' => ($dayCallThn + 1),
						));
					}
					if (!empty($lead)) {
						if (empty($lead['call_id'])) {
							$this->vbee_thn_qua_han_model->update(array("_id" => $lead['_id']), array('call_id' => $item->call_id, 'scan_date' => $curentime_day));
						} elseif (!empty($lead['call_id']) && ($dayCallThn < 30)) {
							$this->vbee_thn_qua_han_model->update(array("_id" => $lead['_id']), array('call_id' => $item->call_id ,'scan_date' => $curentime_day));
						}
					}
				}
			}
		}
		if (!empty($data)) {
			$response = array(
				'status' => 'import success',
				'data' => $response
			);
		} else {
			$response = array(
				'status' => 'import error',
				'data' => []
			);
		}
		LogCI::message('vbee_thn', '================ Run vbee_thn_3_import_post End ==========================');
		$this->set_response($response, REST_Controller::HTTP_OK);
	}

	public function webhook_vbee_thn_call_quaHan_post()
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$current_time = $this->createdAt;
		$dataDB['request'] = json_decode($this->input->raw_input_stream);
		$check_status_lead = $this->vbee_thn_qua_han_model->findOne(["call_id" => (int)$dataDB['request']->data->call_id]);
		$findDataCallId = $this->vbee_thn_qua_han_model->findOne(["call_id" => (int)$dataDB['request']->data->call_id]);
		$dataContract = $findDataCallId['code_contract'];
		$dataCaller = $this->contract_debt_caller_model->findOneVbee([
			'code_contract' => $dataContract
		]);
		$dataContractTable = $this->contract_model->findOne([
			'code_contract' => $dataContract
		]);
		if (!empty($dataDB['request'])) {
			$amount_qua_han = $dataDB['request']->import_data->amount;
			$check_phone = (substr($dataDB['request']->data->key_press, 0, 1));
			$vbeeState = (int)$dataDB['request']->data->state;
			$calledAtVbee = ($dataDB['request']->data->called_at);
			$duration_qh = $dataDB['request']->data->duration;
			$note = $dataDB['request']->data->note;
			$record = $dataDB['request']->data->record_audio;
			if (!empty($check_status_lead)
				&& ($vbeeState == 20 || $vbeeState == 50 || $vbeeState == 60 || $vbeeState == 40)) {
				if (($vbeeState == 40) && $note == 'VOICEMAIL_DETECTION'){
					if ($check_status_lead['status'] == 1) {
						if (!isset($check_status_lead['call_vbee_thn_qh'])) {
							// Cuộc gọi đầu tiên của ngày đầu tiên
							$this->vbee_thn_qua_han_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array(
								'status_vbee' => $vbeeState, "call_vbee_thn_qh" => 1,
								"day_call_thn_qua_han" => 2, "priority_qh" => "1",
								"amount_qua_han" => $amount_qua_han, "calledAtVbee_qh" => strtotime($calledAtVbee), "call_thn_qua_han" => 1));
							$this->vbee_thn_qua_han_model->update_recording_vbee_thn_qua_han($check_status_lead['_id'], $record);
						} else if ($check_status_lead['day_call_thn_qua_han'] == 30 && $check_status_lead['call_vbee_thn_qh'] == 3) {
							// Cuộc gọi lần thứ 3 của ngày thứ 30
							$callVbeeThn_qh = $check_status_lead['call_vbee_thn_qh'] + 1;
							$this->vbee_thn_qua_han_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array(
								"call_vbee_thn_qh" => $callVbeeThn_qh,
								"call_thn_qua_han_that_bai" => 1,
								'status_vbee' => $vbeeState,
								"call_thn_qua_han" => 1,
								"calledAtVbee_qh" => strtotime($calledAtVbee),
								'store_name' => $dataContractTable['store']['name'],
								'caller' => $dataCaller[0]['debt_caller_name'],
								'so_ngay_cham_tra' => $dataContractTable['debt']['so_ngay_cham_tra'],
								"amount_qua_han" => $amount_qua_han,
								"ngay_thanh_toan" => $dataContractTable['debt']['ngay_ky_tra']
								));
							$this->vbee_thn_qua_han_model->update_recording_vbee_thn_qua_han($check_status_lead['_id'], $record);

						} else {
							// Các cuộc gọi của các ngày trong tháng 1-> 30
							if ($check_status_lead['call_vbee_thn_qh'] == 3) {
								// Nếu đã gọi đủ 4 cuộc trong 1 ngày. update dữ liệu sang ngày mới.
								$dayCall = $check_status_lead['day_call_thn_qua_han'];
								$callVbeeThn_qh = 0;
							} else {
								$dayCall = $check_status_lead['day_call_thn_qua_han'];
								$callVbeeThn_qh = $check_status_lead['call_vbee_thn_qh'] + 1;
							}
							$this->vbee_thn_qua_han_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array(
								'status_vbee' => $vbeeState,
								"call_vbee_thn_qh" => $callVbeeThn_qh,
								"day_call_thn_qua_han" => $dayCall,
								"priority_qh" => "1",
								"calledAtVbee_qh" => strtotime($calledAtVbee),
								"amount_qua_han" => $amount_qua_han,
								"call_thn_qua_han" => 1,
								'store_name' => $dataContractTable['store']['name'],
								'caller' => $dataCaller[0]['debt_caller_name'],
								'so_ngay_cham_tra' => $dataContractTable['debt']['so_ngay_cham_tra'],
								"ngay_thanh_toan" => $dataContractTable['debt']['ngay_ky_tra']
							));
							$this->vbee_thn_qua_han_model->update_recording_vbee_thn_qua_han($check_status_lead['_id'], $record);
						}
					}
				}
				if ($vbeeState == 40 && empty($note == 'VOICEMAIL_DETECTION' )) {
					if (($check_phone == 1) || ($check_phone === "0")) {
						$dayCall = $check_status_lead['day_call_thn_qua_han'];
						if ($dayCall < 30) {
							$this->vbee_thn_qua_han_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array(
								'status_vbee' => $vbeeState,
								'key_press_qh' => $check_phone,
								"calledAtVbee_qh" => strtotime($calledAtVbee),
								"duration_qh" => $duration_qh,
								"priority_qh" => "3",
								"amount_qua_han" => $amount_qua_han,
								"call_thn_qua_han" => 1,
								'day_call_thn_qua_han' => $dayCall,
								'store_name' => $dataContractTable['store']['name'],
								'caller' => $dataCaller[0]['debt_caller_name'],
								'so_ngay_cham_tra' => $dataContractTable['debt']['so_ngay_cham_tra'],
								"ngay_thanh_toan" => $dataContractTable['debt']['ngay_ky_tra']
							));
							$this->vbee_thn_qua_han_model->update_recording_vbee_thn_qua_han($check_status_lead['_id'], $record);
						}
					} else {
						if ($dayCall < 30) {
							$this->vbee_thn_qua_han_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array(
								'status_vbee' => $vbeeState,
								"calledAtVbee_qh" => strtotime($calledAtVbee),
								"duration_qh" => $duration_qh,
								"priority_qh" => "2",
								"amount_qua_han" => $amount_qua_han,
								"call_thn_qua_han" => 1,
								'store_name' => $dataContractTable['store']['name'],
								'caller' => $dataCaller[0]['debt_caller_name'],
								'so_ngay_cham_tra' => $dataContractTable['debt']['so_ngay_cham_tra'],
								"ngay_thanh_toan" => $dataContractTable['debt']['ngay_ky_tra']
							));
							$this->vbee_thn_qua_han_model->update_recording_vbee_thn_qua_han($check_status_lead['_id'], $record);
						}
					}
				}
				if (($vbeeState == 50) || ($vbeeState == 60)) {
					if ($check_status_lead['status'] == 1) {
						if (!isset($check_status_lead['call_vbee_thn_qh'])) {
							// Cuộc gọi đầu tiên của ngày đầu tiên
							$this->vbee_thn_qua_han_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array(
							'status_vbee' => $vbeeState, "call_vbee_thn_qh" => 1,
							 "day_call_thn_qua_han" => 2, "priority_qh" => "1",
							 "amount_qua_han" => $amount_qua_han,"calledAtVbee_qh" => strtotime($calledAtVbee),"call_thn_qua_han" => 1));
						} else if ($check_status_lead['day_call_thn_qua_han'] == 30 && $check_status_lead['call_vbee_thn_qh'] == 3) {
							// Cuộc gọi lần thứ 3 của ngày thứ 30
							$callVbeeThn_qh = $check_status_lead['call_vbee_thn_qh'] + 1;
							$this->vbee_thn_qua_han_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array(
								"call_vbee_thn_qh" => $callVbeeThn_qh,
								"call_thn_qua_han_that_bai" => 1,
								'status_vbee' => $vbeeState,
								"call_thn_qua_han" => 1,
								"calledAtVbee_qh" => strtotime($calledAtVbee),
								'store_name' => $dataContractTable['store']['name'],
								'caller' => $dataCaller[0]['debt_caller_name'],
								'so_ngay_cham_tra' => $dataContractTable['debt']['so_ngay_cham_tra'],
								"ngay_thanh_toan" => $dataContractTable['debt']['ngay_ky_tra'],
								"amount_qua_han" => $amount_qua_han));
						} else {
							// Các cuộc gọi của các ngày trong tháng 1-> 30
							if ($check_status_lead['call_vbee_thn_qh'] == 3) {
								// Nếu đã gọi đủ 4 cuộc trong 1 ngày. update dữ liệu sang ngày mới.
								$dayCall = $check_status_lead['day_call_thn_qua_han'];
								$callVbeeThn_qh = 0;
							} else {
								$dayCall = $check_status_lead['day_call_thn_qua_han'];
								$callVbeeThn_qh = $check_status_lead['call_vbee_thn_qh'] + 1;
							}
							$this->vbee_thn_qua_han_model->update(array("_id" => new \MongoDB\BSON\ObjectId($check_status_lead['_id'])), array(
								'status_vbee' => $vbeeState,
								"call_vbee_thn_qh" => $callVbeeThn_qh,
								"day_call_thn_qua_han" => $dayCall,
								"priority_qh" => "1",
								"calledAtVbee_qh" => strtotime($calledAtVbee),
								"amount_qua_han" => $amount_qua_han,
								"call_thn_qua_han" => 1,
								'store_name' => $dataContractTable['store']['name'],
								'caller' => $dataCaller[0]['debt_caller_name'],
								'so_ngay_cham_tra' => $dataContractTable['debt']['so_ngay_cham_tra'],
								"ngay_thanh_toan" => $dataContractTable['debt']['ngay_ky_tra'],
								));
						}
					}
				}
			}
			$this->log_vbee_thn_model->insert($dataDB);
			$response = array(
				'status' => REST_Controller::HTTP_OK,
				'data' => $dataDB,
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
		}
	}

	private function vbee_thn_import_thn($data, $campaign_id, $access_token)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://aicallcenter.vn/api/campaigns/$campaign_id/import?access_token=$access_token",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{\n    \"contacts\":  $data  \n}\t",
			CURLOPT_HTTPHEADER => array(
				"Content-Type: application/json"
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}

	public function get_truoc_han_post()
	{
		$data = $this->input->post();
		$condition = [];
		$per_page = !empty($data['per_page']) ? $data['per_page'] : 30;
		$uriSegment = !empty($data['uriSegment']) ? $data['uriSegment'] : 0;
		$start_date = !empty($data['start_date']) ? $data['start_date'] : "";
		$end_date = !empty($data['end_date']) ? $data['end_date'] : "";
		$phone = !empty($data['sdt']) ? $data['sdt'] : "";
		$name = !empty($data['name']) ? $data['name'] : "";
		$priority_truoc_han = !empty($data['priority_truoc_han']) ? $data['priority_truoc_han'] : "";
		$code_contract_disbursement = !empty($data['code_contract_disbursement']) ? $data['code_contract_disbursement'] : "";
		$customer_identify = !empty($data['customer_identify']) ? $data['customer_identify'] : "";
		if (!empty($start_date)) {
			$condition['start_date'] = strtotime($start_date);
		}
		if (!empty($end_date)) {
			$condition['end_date'] = strtotime($end_date);
		}
		$condition['sdt'] = $phone;
		$condition['name'] = $name;
		$condition['priority_truoc_han'] = $priority_truoc_han;
		$condition['code_contract_disbursement'] = $code_contract_disbursement;
		$condition['customer_identify'] = $customer_identify;
		$result = $this->vbee_thn_model->get_data_truoc_han($condition,$per_page,$uriSegment);
		$condition['total'] = true;
		$total = $this->vbee_thn_model->get_data_truoc_han($condition,$per_page,$uriSegment);
		$response = array(
			"status" => self::HTTP_OK,
			'data' => $result,
			'total' => $total
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function get_qua_han_post()
	{
		$data = $this->input->post();
		$condition = [];
		$per_page = !empty($data['per_page']) ? $data['per_page'] : 30;
		$uriSegment = !empty($data['uriSegment']) ? $data['uriSegment'] : 0;
		$start_date = !empty($data['start_date']) ? $data['start_date'] : "";
		$end_date = !empty($data['end_date']) ? $data['end_date'] : "";
		$phone = !empty($data['sdt']) ? $data['sdt'] : "";
		$name = !empty($data['name']) ? $data['name'] : "";
		$priority_qh = !empty($data['priority_qh']) ? $data['priority_qh'] : "";
		$code_contract_disbursement = !empty($data['code_contract_disbursement']) ? $data['code_contract_disbursement'] : "";
		$customer_identify = !empty($data['customer_identify']) ? $data['customer_identify'] : "";
		if (!empty($start_date)){
			$condition['start_date'] = strtotime($start_date);
		}
		if (!empty($end_date)){
			$condition['end_date'] = strtotime($end_date);
		}
		$condition['sdt'] = $phone;
		$condition['name'] = $name;
		$condition['priority_qh'] = $priority_qh;
		$condition['code_contract_disbursement'] = $code_contract_disbursement;
		$condition['customer_identify'] = $customer_identify;
		$result = $this->vbee_thn_qua_han_model->get_data_qua_han($condition,$per_page,$uriSegment);
		$condition['total'] = true;
		$total = $this->vbee_thn_qua_han_model->get_data_qua_han($condition,$per_page,$uriSegment);
		$response = array(
			"status" => self::HTTP_OK,
			'data' => $result,
			'total' => $total
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function get_toi_han_post()
	{
		$data = $this->input->post();
		$condition = [];
		$per_page = !empty($data['per_page']) ? $data['per_page'] : 30;
		$uriSegment = !empty($data['uriSegment']) ? $data['uriSegment'] : 0;
		$start_date = !empty($data['start_date']) ? $data['start_date'] : "";
		$end_date = !empty($data['end_date']) ? $data['end_date'] : "";
		$phone = !empty($data['sdt']) ? $data['sdt'] : "";
		$name = !empty($data['name']) ? $data['name'] : "";
		$code_contract_disbursement = !empty($data['code_contract_disbursement']) ? $data['code_contract_disbursement'] : "";
		$customer_identify = !empty($data['customer_identify']) ? $data['customer_identify'] : "";
		if (!empty($start_date)) {
			$condition['start_date'] = strtotime($start_date);
		}
		if (!empty($end_date)) {
			$condition['end_date'] = strtotime($end_date);
		}
		$condition['sdt'] = $phone;
		$condition['name'] = $name;
		$condition['code_contract_disbursement'] = $code_contract_disbursement;
		$condition['customer_identify'] = $customer_identify;
		$result = $this->vbee_thn_toi_han_model->get_data_toi_han($condition,$per_page,$uriSegment);
		$condition['total'] = true;
		$total = $this->vbee_thn_toi_han_model->get_data_toi_han($condition,$per_page,$uriSegment);
		 $response = array(
			"status" => self::HTTP_OK,
			'data' => $result,
			'total' => $total
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function excel_thn_call_vbee_toi_han_post()
	{
		$condition = [];
		$data = $this->input->post();
		$tab = !empty($data['tab']) ? $data['tab'] : 'toi_han';
		$start = !empty($data['start_date']) ? $data['start_date'] : "";
		$end = !empty($data['end_date']) ? $data['end_date'] : "";
		$maHopDong = !empty($data['code_contract_disbursement']) ? $data['code_contract_disbursement'] : "";

		if (empty($start) && empty($end)) {
			$condition = [
				"code_contract_disbursement" => $maHopDong,
			];
		} elseif (empty($start)) {
			$condition = [
				"end_date" => strtotime($end),
				"code_contract_disbursement" => $maHopDong,
			];
		} elseif (empty($end)) {
			$condition = [
				"start_date" => strtotime($start),
				"code_contract_disbursement" => $maHopDong,
			];
		}
		if (!empty($start) && !empty($end)) {
			$condition = [
				"start_date" => strtotime($start),
				"end_date" => strtotime($end),
				"code_contract_disbursement" => $maHopDong,
			];
		}
		$condition['tab'] = $tab;
		$result = $this->vbee_thn_toi_han_model->get_thn_vbee_excel($condition);
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => 'thành công!',
			'data' => ($result),
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function excel_thn_call_vbee_truoc_han_post()
	{
		$condition = [];
		$data = $this->input->post();
		$tab = !empty($data['tab']) ? $data['tab'] : 'toi_han';
		$start = !empty($data['start_date']) ? $data['start_date'] : "";
		$end = !empty($data['end_date']) ? $data['end_date'] : "";
		$maHopDong = !empty($data['code_contract_disbursement']) ? $data['code_contract_disbursement'] : "";

		if (empty($start) && empty($end)) {
			$condition = [
				"code_contract_disbursement" => $maHopDong,
			];
		} elseif (empty($start)) {
			$condition = [
				"end_date" => strtotime($end),
				"code_contract_disbursement" => $maHopDong,
			];
		} elseif (empty($end)) {
			$condition = [
				"start_date" => strtotime($start),
				"code_contract_disbursement" => $maHopDong,
			];
		}
		if (!empty($start) && !empty($end)) {
			$condition = [
				"start_date" => strtotime($start),
				"end_date" => strtotime($end),
				"code_contract_disbursement" => $maHopDong,
			];
		}
		$condition['tab'] = $tab;
		$result = $this->vbee_thn_model->get_thn_vbee_excel($condition);
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => 'thành công!',
			'data' => ($result),
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function excel_thn_call_vbee_qua_han_post()
	{
		$condition = [];
		$data = $this->input->post();
		$tab = !empty($data['tab']) ? $data['tab'] : 'toi_han';
		$start = !empty($data['start_date']) ? $data['start_date'] : "";
		$end = !empty($data['end_date']) ? $data['end_date'] : "";
		$maHopDong = !empty($data['code_contract_disbursement']) ? $data['code_contract_disbursement'] : "";

		if (empty($start) && empty($end)) {
			$condition = [
				"code_contract_disbursement" => $maHopDong,
			];
		} elseif (empty($start)) {
			$condition = [
				"end_date" => strtotime($end),
				"code_contract_disbursement" => $maHopDong,
			];
		} elseif (empty($end)) {
			$condition = [
				"start_date" => strtotime($start),
				"code_contract_disbursement" => $maHopDong,
			];
		}
		if (!empty($start) && !empty($end)) {
			$condition = [
				"start_date" => strtotime($start),
				"end_date" => strtotime($end),
				"code_contract_disbursement" => $maHopDong,
			];
		}
		$condition['tab'] = $tab;
		$result = $this->vbee_thn_qua_han_model->get_thn_vbee_excel($condition);
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => 'thành công!',
			'data' => ($result),
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;

	}

	public function payment_import($datathn)
	{
		$service = $this->baseURL1 . '/Payment/get_payment_all_contract';
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $service,
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => $datathn,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CUSTOMREQUEST => "POST",
		));
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}


	public function import_lead_topup_post(){

		$data = $this->input->post();

		$this->list_topup_model->insert($data);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Import topup success",
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;


	}

	public function getSource_post() {
		$getSource = $this->config_global_model->findOne(['flag' => 'vbee_lead']);
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Ok",
			'data'		=> $getSource,
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	//hàm thêm nguồn có sẵn của vbee (chạy 1 lần)
	public function InsertVbeeLead_post() {
		$data = $this->input->post();
		$source = !empty($data['source']) ? $data['source'] : "";
		$save = $this->config_global_model->insert(
			[   
				'source' 		=> $source,
				'created_at' 	=> $this->createdAt,
				'updated_at' 	=> $this->createdAt,
				'created_by'	=> $this->uemail,
				'flag' 			=> 'vbee_lead',
			]
		);
		$log_global = $this->log_config_global_model->insert(
			[
				'data' => [
					'source' 		=> $source,
					'created_at' 	=> $this->createdAt,
					'updated_at' 	=> $this->createdAt,
					'created_by'	=> $this->uemail,
					'flag' 			=> 'vbee_lead',
				],
				'created_at'	=> $this->createdAt,
				'created_by'	=> $this->uemail,
				'type'			=> 'insert',
			]
		);
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => "Thêm thành công",
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function setupVbeeLead_post() {
		$data = $this->input->post();
		$source = !empty($data['source']) ? $data['source'] : "";
		$source_all_db = $this->config_global_model->findOne(['flag' => 'filter_vbee_all']);
		$source_raw_input_convert = explode(',', $source);
		$source_all_convert = explode(',', $source_all_db['source']);
		$arr_source_exists = [];
		foreach ($source_raw_input_convert as $source_in) {
			if (in_array($source_in, $source_all_convert)) {
				array_push($arr_source_exists, $source_in);
			}
		}
		if (count($arr_source_exists) > 0) {
			$response = [
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => 'Trùng nguồn lọc Lead All',
				'data' => $arr_source_exists
			];
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		$update = $this->config_global_model->update(
		[
			'flag' => 'vbee_lead'
		],
		[   
			'source' 		=> $source,
			'created_at' 	=> $this->createdAt,
			'updated_at' 	=> $this->createdAt,
			'created_by'	=> $this->uemail,
			'flag' 			=> 'vbee_lead',
		]);
		$log_global = $this->log_config_global_model->insert(
			[
				'data' => [
					'source' 		=> $source,
					'created_at' 	=> $this->createdAt,
					'updated_at' 	=> $this->createdAt,
					'created_by'	=> $this->uemail,
					'flag' 			=> 'vbee_lead',
				],
				'created_at'	=> $this->createdAt,
				'created_by'	=> $this->uemail,
				'type'			=> 'update',
			]
		);
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => "Update lead thành công",
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function update_old_record_post()
	{
		$vbee_truoc_han = $this->vbee_thn_model->find();    //$campaign_id = 19275;
		$vbee_toi_han = $this->vbee_thn_toi_han_model->find();    //$campaign_id = 16639;
		$vbee_qua_han = $this->vbee_thn_qua_han_model->find();    //$campaign_id = 16638;

		foreach ($vbee_truoc_han as $item) {
			$record = $this->log_vbee_thn_model->find_record($item['phone'], 19275);
			if (count($record) > 0) {
				foreach ($record as $value) {
					$this->vbee_thn_model->update_recording_vbee_thn_truoc_han((string)$item['_id'], $value['request']->data->record_audio);
				}
			}

		}
		foreach ($vbee_toi_han as $item) {
			$record = $this->log_vbee_thn_model->find_record($item['phone'], 16639);
			if (count($record) > 0) {
				foreach ($record as $value) {
					$this->vbee_thn_toi_han_model->update_recording_vbee_thn_toi_han((string)$item['_id'], $value['request']->data->record_audio);
				}
			}
		}
		foreach ($vbee_qua_han as $item) {
			$record = $this->log_vbee_thn_model->find_record($item['phone'], 16638);
			if (count($record) > 0) {
				foreach ($record as $value) {
					$this->vbee_thn_qua_han_model->update_recording_vbee_thn_qua_han((string)$item['_id'], $value['request']->data->record_audio);
				}
			}
		}
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => 'ok'
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}


	public function import_lead_taivay_post(){

		$data = $this->input->post();

		$this->list_taivay_model->insert($data);

		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Import topup success",
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;


	}

	/**
	 *  Lưu cài đặt lọc nguồn Lead đẩy qua Vbee
	 */
	public function saveSourceLeadAll_post() {
		$data = $this->input->post();
		$source_input = !empty($data['source']) ? $data['source'] : "";
		$source_all_db = $this->config_global_model->findOne(['flag' => 'filter_vbee_all']);
		$source_raw_db = $this->config_global_model->findOne(['flag' => 'vbee_lead']);
		$source_all_input_convert = explode(',', $source_input);
		$source_raw_convert = explode(',', $source_raw_db['source']);
		$arr_source_exists = [];
		foreach ($source_all_input_convert as $source_in) {
			if (in_array($source_in, $source_raw_convert)) {
				array_push($arr_source_exists, $source_in);
			}
		}
		if (count($arr_source_exists) > 0) {
			$response = [
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => 'Trùng nguồn lọc Lead thô',
				'data' => $arr_source_exists
			];
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		$log_data = [
			'data' => [
				'source' 		=> $source_input,
				'created_at' 	=> $this->createdAt,
				'updated_at' 	=> $this->createdAt,
				'created_by'	=> $this->uemail,
				'flag' 			=> 'filter_vbee_all',
			],
			'created_at'	=> $this->createdAt,
			'created_by'	=> $this->uemail
		];
		if (empty($source_all_db)) {
			//Nếu chưa có dữ liệu thì thêm mới
			$this->config_global_model->insert(
				[
					'source' 		=> $source_input,
					'created_at' 	=> $this->createdAt,
					'updated_at' 	=> $this->createdAt,
					'created_by'	=> $this->uemail,
					'flag' 			=> 'filter_vbee_all',
				]
			);
			$log_data['type'] = 'insert';
		} else {
			$this->config_global_model->update(
				[
					'flag' => 'filter_vbee_all'
				],
				[
					'source' 		=> $source_input,
					'created_at' 	=> $this->createdAt,
					'updated_at' 	=> $this->createdAt,
					'created_by'	=> $this->uemail,
					'flag' 			=> 'filter_vbee_all',
				]);
			$log_data['type'] = 'update';
		}
		$this->log_config_global_model->insert($log_data);
		$response = [
			'status' => REST_Controller::HTTP_OK,
			'message' => "Cài đặt thành công",
		];
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

	public function getSourcePushVbee_post() {
		$getSource = $this->config_global_model->findOne(['flag' => 'filter_vbee_all']);
		$response = array(
			'status' => REST_Controller::HTTP_OK,
			'message' => "Ok",
			'data'		=> $getSource,
		);
		$this->set_response($response, REST_Controller::HTTP_OK);
		return;
	}

}

?>

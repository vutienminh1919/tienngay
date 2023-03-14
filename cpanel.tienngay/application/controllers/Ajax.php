<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->api = new Api();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->helper('lead_helper');
		$this->load->model("store_model");
		$this->load->model("time_model");
		$this->load->library('pagination');
		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
		date_default_timezone_set('Asia/Ho_Chi_Minh');

	}

	public function upload_img()
	{
		$data = $this->input->post();


		if ($_FILES['file']['size'] > 20000000) {
			return $this->pushJson('200', json_encode(array(
				'code' => '201',
				'msg' => 'Size max is 10MB'
			)));
		}
		$acceptFormat = array("jpeg", "png", "jpg");
		if (in_array($_FILES['file']['type'], $acceptFormat)) {
			return $this->pushJson('200', json_encode(array(
				'code' => '201',
				'msg' => 'Format not allowed',
				'type' => $_FILES['file']['type']
			)));
		}
		$serviceUpload = $this->config->item("url_service_upload");
		$cfile = new CURLFile($_FILES['file']["tmp_name"], $_FILES['file']["type"], $_FILES['file']["name"]);
		$post = array('avatar' => $cfile);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $serviceUpload);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		$result1 = json_decode($result);

		$random = sha1(substr(md5(rand()), 0, 8));

		$data_con = array();
		$data_con['url'] = $result1->path;

		$response = array(
			'code' => 200,
			"msg" => "success",
			'path' => $result1->path,
			'key' => $random,
			'raw_name' => $_FILES['file']['name']
		);


		echo json_encode($response);
		return;
	}

	public function get_info_cvs()
	{
		$mattruoc = !empty($_POST['mattruoc']) ? $_POST['mattruoc'] : '';
		$matsau = !empty($_POST['matsau']) ? $_POST['matsau'] : '';
		$img_person = !empty($_POST['img_person']) ? $_POST['img_person'] : '';
		$backside = !empty($_POST['backside']) ? $_POST['backside'] : '';
		$type = !empty($_POST['type']) ? $_POST['type'] : '';
		$image_url = !empty($_POST['image_url']) ? $_POST['image_url'] : '';
		$username = $this->config->item("CVS_API_KEY");
		$password = $this->config->item("CVS_API_SECRET");
		if ($type == "CMT") {
			$url = $this->config->item("API_CVS") . 'ocr/cmt/get_haimat?mattruoc=' . $mattruoc . '&matsau=' . $matsau;
		} else if ($type == "BLX") {
			$url = $this->config->item("API_CVS") . 'ocr/blx/get_blx?url=' . $image_url;
		} else if ($type == "FACE") {
			$url = $this->config->item("API_CVS") . 'face_matching/matching?img_cmt=' . $backside . '&img_person=' . $img_person;
		}
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		$respone_data = curl_exec($ch);
		curl_close($ch);
		//  var_dump($respone_data);
		$result1 = json_decode($respone_data);

		if ($result1->error_code == "0") {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $result1->data,
				'message' => $result1->error_message
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'data' => $result1->data,
				'message' => $result1->error_message
			];
			echo json_encode($response);
			return;
		}
	}

	// check existing in blacklist
	public function get_info_face_search()
	{

		// $img_person = !empty($_POST['img_person']) ? $_POST['img_person'] : '';

		// $username =$this->config->item("CVS_API_KEY");
		// $password = $this->config->item("CVS_API_SECRET");

		// $url = $this->config->item("API_CVS").'face_search/search';
		// $data_arr=array('image' =>  array('url' => $img_person ));
		// $result1 = $this->push_api_cvs($url,json_encode($data_arr));
		// // var_dump( json_encode($data_arr));
		// //   var_dump($url);
		// if($result1->status_code == 0)
		// {
		//     if(is_array($result1->result) && count($result1->result)){
		//         foreach ($result1->result as $key => $value) {
		//             if($value->metadata->status != 'active') {
		//                 unset($result1->result[$key]);
		//             }
		//         }
		//     }
		//     $response = [
		//         'res' => true,
		//         'status' => "200",
		//         'data' => $result1->result,
		//         'message' => $result1->message
		//     ];
		//     echo json_encode($response);
		//     return;
		// }else{
		$response = [
			'res' => false,
			'status' => "400",
			// 'data' => $result1->result,
			// 'message' => $result1->message
		];
		echo json_encode($response);
		return;
		//  }
	}

	// call cvs api
	private function push_api_cvs($url = '', $data_post = [])
	{
		$username = $this->config->item("CVS_API_KEY");
		$password = $this->config->item("CVS_API_SECRET");
		$service = $url;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $service);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		$result = curl_exec($ch);
		// var_dump($result);
		curl_close($ch);
		$result1 = json_decode($result);
		return $result1;
	}

	public function test_soap()
	{

		$originalXML = '<ns1:ws_GCN_TRA>
    <!--Optional:-->
    <ns1:xmlinput>
        <![CDATA[
                    <XMLINPUT>
                    <MA_DVI>VFC_TIENNGAY</MA_DVI>
                    <NSD>VFC_TIENNGAY</NSD>
                    <PAS>bhqd2019</PAS>
                    <NV>NG_TD</NV>
                    <ID_TRAS>MYTEST78754</ID_TRAS>
                    <TTOAN>132000</TTOAN>
                    <TEN>Nguyễn Chí Thành</TEN>
                    <KIEU_HD>G</KIEU_HD>
                    <LKH>C</LKH>
                    <NG_SINH>01/02/1992</NG_SINH>
                    <CMT>0326333333</CMT>
                    <MOBI>0356119318</MOBI>
                    <EMAIL>mydx@tienngay.vn</EMAIL>
                    <DCHI>bình tân, hcm - Bình Hưng Hòa</DCHI>
                    <NG_HUONG>Nguyễn Chí Thành</NG_HUONG>
                    <SO_HDL>E</SO_HDL>
                    <SO_HD_VAY>MYTEST78754</SO_HD_VAY>
                    <GUIHD>N</GUIHD>
                    <KIEUHD>E</KIEUHD>
                    <NGAY_HL>24/06/2020</NGAY_HL>
                    <NGAY_KT>24/06/2021</NGAY_KT>
                    <TIEN>2000000</TIEN>
                    </XMLINPUT>
                            ]]>
                    </ns1:xmlinput>
                </ns1:ws_GCN_TRA>
                ';

		$wsdl_url = 'http://test-dly.mic.vn/Service/dly/ws_dly.asmx?wsdl';
		try {
			$params = new \SoapVar($originalXML, XSD_ANYXML);
			//var_dump($params ); die;
			$this->soapClient = new \SoapClient($wsdl_url, array('soap_version' => SOAP_1_2, 'trace' => 1, 'exceptions' => false));
			$this->soapClient->__setLocation('http://test-dly.mic.vn/Service/dly/ws_dly.asmx');
			$result = $this->soapClient->ws_GCN_TRA($params);
			// var_dump($result); die;
			$xml = simplexml_load_string($result->ws_GCN_TRAResult);
			// var_dump($this->soapClient->__getLastRequest());
			var_dump($xml);
			die;

		} catch (Exception $e) {
			echo "<h2>Exception Error!</h2>";
			echo $e->getMessage();
			die;
			var_dump('xxx1');
			die;
		}
	}

	public function update_area_log()
	{
		$return = $this->api->apiPost1('', "lead/run_area_log");

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}

	}

	public function get_fee_mic()
	{

		$money = !empty($_POST['money']) ? $_POST['money'] : 0;
		$month = !empty($_POST['month']) ? $_POST['month'] : 0;
		$ngay_hl = date('d/m/Y');
		$ngay_kt = date('d/m/Y', strtotime('+' . $month . ' month'));
		$originalXML = '<ns1:ws_BPHI>
                     <!--Optional:-->
                     <ns1:xmlinput>
                     <![CDATA[
                     <XMLINPUT>
            <MA_DVI>' . $this->config->item("MIC_MA_DVI") . '</MA_DVI>
            <NSD>' . $this->config->item("MIC_NSD") . '</NSD>
            <PAS>' . $this->config->item("MIC_PAS") . '</PAS>
            <NV>NG_TD</NV>
            <KIEU_HD>G</KIEU_HD>
            <NGAY_HL>' . $ngay_hl . '</NGAY_HL>
            <NGAY_KT>' . $ngay_kt . '</NGAY_KT>
            <TIEN>' . (float)$money . '</TIEN>
            </XMLINPUT>
            ]]>  </ns1:xmlinput>
                  </ns1:ws_BPHI>
            ';

		$wsdl_url = $this->config->item("API_MIC") . '?wsdl';
		try {
			$params = new \SoapVar($originalXML, XSD_ANYXML);
			// var_dump($originalXML ); die;
			$this->soapClient = new \SoapClient($wsdl_url, array('soap_version' => SOAP_1_2, 'trace' => 1, 'exceptions' => false));
			$this->soapClient->__setLocation($this->config->item("API_MIC"));
			$result = $this->soapClient->ws_BPHI($params);
			// var_dump($result); die;
			$xml = simplexml_load_string($result->ws_BPHIResult);
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $xml
			];
			echo json_encode($response);
			return;

		} catch (Exception $e) {
			$response = [
				'res' => false,
				'status' => "401",
				'data' => $return->data,
				'massage' => $e->getMessage()
			];
			echo json_encode($response);
			return;


		}

	}

	public function update_area()
	{
		$return = $this->api->apiPost1('', "lead/run_area");

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}

	}

	public function update_loan_insurance()
	{
		$return = $this->api->apiPost1('', "contract/updateLoan_insurance");

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}

	}

	public function update_off_at()
	{
		$return = $this->api->apiPost1('', "lead_custom/update_off_at");

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}

	}

	public function get_base()
	{
		$base = !empty($_POST['base']) ? $_POST['base'] : "";
		$response = [
			'res' => true,
			'status' => "200",
			'data' => decrypt($base)
		];
		echo json_encode($response);
		return;

	}

	public function doAddRecording()
	{
		$headers = $this->input->request_headers();
		$dataPost = json_decode(file_get_contents("php://input"));
		$this->flag_login = 1;
		if (isset($headers['token']) || isset($headers['Token'])) {
			$headers_item = isset($headers['token']) ? $headers['token'] : $headers['Token'];
			if ($headers_item != "eeabcc6a8ed8d178bddd08b0e36635a56b9e36dbf0d424bba96ee6c7c653de8af26164980e0c91ddd65f2a3ca6696d2e9ea126c85e5779e01c402cb8d9dee74f") {
				$response = [
					'res' => false,
					'status' => "400",
					'message' => $this->lang->line('create_recording_failed')
				];
				echo json_encode($response);
				return;
			}

		}

		$_id = isset($dataPost->_id) ? $dataPost->_id : '';
		$host = isset($dataPost->host) ? $dataPost->host : '';
		$client = isset($dataPost->client) ? $dataPost->client : '';
		$gateway = isset($dataPost->gateway) ? $dataPost->gateway : '';
		$phoneNumber = isset($dataPost->phoneNumber) ? $dataPost->phoneNumber : '';
		$fromUser = isset($dataPost->fromUser) ? $dataPost->fromUser : '';
		$toUser = isset($dataPost->toUser) ? $dataPost->toUser : '';
		$fromGroup = isset($dataPost->fromGroup) ? $dataPost->fromGroup : '';
		$toGroup = isset($dataPost->toGroup) ? $dataPost->toGroup : '';
		$fromCallId = isset($dataPost->fromCallId) ? $dataPost->fromCallId : '';
		$toCallId = isset($dataPost->toCallId) ? $dataPost->toCallId : '';
		$direction = isset($dataPost->direction) ? $dataPost->direction : '';
		$fromExt = isset($dataPost->fromExt) ? $dataPost->fromExt : '';
		$fromNumber = isset($dataPost->fromNumber) ? $dataPost->fromNumber : '';
		$toNumber = isset($dataPost->toNumber) ? $dataPost->toNumber : '';
		$startTime = isset($dataPost->startTime) ? $dataPost->startTime : '';
		$answerTime = isset($dataPost->answerTime) ? $dataPost->answerTime : '';
		$endTime = isset($dataPost->endTime) ? $dataPost->endTime : '';
		$duration = isset($dataPost->duration) ? $dataPost->duration : '';
		$billDuration = isset($dataPost->billDuration) ? $dataPost->billDuration : '';
		$hangupCause = isset($dataPost->hangupCause) ? $dataPost->hangupCause : '';
		$createTime = isset($dataPost->createTime) ? $dataPost->createTime : '';
		$recording = isset($dataPost->recording) ? $dataPost->recording : '';
		$recordingDownloaded = isset($dataPost->recordingDownloaded) ? $dataPost->recordingDownloaded : '';
		$recordingSize = isset($dataPost->recordingSize) ? $dataPost->recordingSize : '';
		$recordingDeleted = isset($dataPost->recordingDeleted) ? $dataPost->recordingDeleted : '';
		$fromContact = isset($dataPost->fromContact) ? $dataPost->fromContact : '';
		$toContact = isset($dataPost->toContact) ? $dataPost->toContact : '';
		$ticketLog = isset($dataPost->ticketLog) ? $dataPost->ticketLog : '';

		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());

		$data = array(
			"code" => $_id,
			"host" => $host,
			"client" => $client,
			"gateway" => $gateway,
			"phoneNumber" => $phoneNumber,
			"fromUser" => $fromUser,
			"toUser" => $toUser,
			"fromGroup" => $fromGroup,
			"toGroup" => $toGroup,
			"fromCallId" => $fromCallId,
			"toCallId" => $toCallId,
			"direction" => $direction,
			"fromExt" => $fromExt,
			"fromNumber" => $fromNumber,
			"toNumber" => $toNumber,
			"startTime" => $startTime,
			"answerTime" => $answerTime,
			"endTime" => $endTime,
			"duration" => $duration,
			"billDuration" => $billDuration,
			"hangupCause" => $hangupCause,
			"createTime" => $createTime,
			"recording" => $recording,
			"recordingDownloaded" => $recordingDownloaded,
			"recordingSize" => $recordingSize,
			"recordingDeleted" => $recordingDeleted,
			"fromContact" => $fromContact,
			"toContact" => $toContact,
			"ticketLog" => $ticketLog,
			"created_at" => $createdAt,
			"updated_at" => $createdAt,
			"created_by" => 'phonenet',
			"updated_by" => '',
			'status' => 'active'

		);

		$return = $this->api->apiPost('', "recording/create_recording", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => "OK"
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('create_recording_failed')
			];
			echo json_encode($response);
			return;
		}
	}

	public function get_district_by_province()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";

		$data = array(
			// "type_login" => 1,
			"id" => $id
		);

		$districtData = $this->api->apiPost($this->userInfo['token'], "province/get_district_by_province", $data);
		if (!empty($districtData->status) && $districtData->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $districtData->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('no_depreciation_configured')
			];
			echo json_encode($response);
			return;
		}

	}

	public function get_ward_by_district()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		$data = array(
			// "type_login" => 1,
			"id" => $id
		);
		$wardData = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", $data);
		if (!empty($wardData->status) && $wardData->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $wardData->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('no_depreciation_configured')
			];
			echo json_encode($response);
			return;
		}

	}

	public function getPopertyByMain()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		$id = $this->security->xss_clean($id);
		$data = array(
			// "type_login" => 1,
			"parent_id" => $id
		);
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_by_main", $data);
		$properties = !empty($mainPropertyData->properties) ? $mainPropertyData->properties : array();
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $mainPropertyData->data,
				'properties' => $properties
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
			];
			echo json_encode($response);
			return;
		}

	}

	public function getDepreciationByProperty()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		$id = $this->security->xss_clean($id);
		$code_type_property = !empty($_POST['code_type_property']) ? $this->security->xss_clean($_POST['code_type_property']) : "";
		$type_loan = !empty($_POST['type_loan']) ? $this->security->xss_clean($_POST['type_loan']) : "";
		$data = array(
			"id" => $id,
			"code_type_property" => $code_type_property,
			"type_loan" => $type_loan
		);
		$depreciationData = $this->api->apiPost($this->userInfo['token'], "property/get_depreciation_by_property", $data);
		if (!empty($depreciationData->status) && $depreciationData->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $depreciationData->data,
				'price_property' => $depreciationData->price_property,
				"percent" => $depreciationData->percent,
				'price_goc' => $depreciationData->price_goc
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'price_property' => $depreciationData->price_property,
				"percent" => $depreciationData->percent,
				'price_goc' => $depreciationData->price_goc
			];
			echo json_encode($response);
			return;
		}
	}

	public function getPercentFormality()
	{
		$type_loan = !empty($_POST['type_loan']) ? $this->security->xss_clean($_POST['type_loan']) : "";
		$code_type_property = !empty($_POST['code_type_property']) ? $this->security->xss_clean($_POST['code_type_property']) : "";
		$data = array(
			"type_loan" => $type_loan,
			"code_type_property" => $code_type_property,
		);
		$percentFormality = $this->api->apiPost($this->userInfo['token'], "property/get_percent_formality", $data);
		if (!empty($percentFormality->status) && $percentFormality->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				"percent" => $percentFormality->percent
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
			];
			echo json_encode($response);
			return;
		}
	}


	public function get_bank_nganluong()
	{
		$account_type = !empty($_POST['account_type']) ? $_POST['account_type'] : "";

		$data = array(
			"account_type" => $account_type
		);
		$bankNganluongData = $this->api->apiPost($this->userInfo['token'], "bankNganLuong/get_all", $data);
		if (!empty($bankNganluongData->status) && $bankNganluongData->status == 200) {
			$respon = array();
			foreach ($bankNganluongData->data as $key => $value) {
				$value->name = $value->name . " ( " . $value->short_name . " )";
				array_push($respon, $value);
			}

			$response = [
				'res' => true,
				'status' => "200",
				'data' => $respon
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('no_depreciation_configured')
			];
			echo json_encode($response);
			return;
		}

	}

	public function get_list_gh()
	{
		$id_contract = !empty($_POST['id_contract']) ? $_POST['id_contract'] : "";

		$data = array(
			"id_contract" => $id_contract,
		);
		$contractData = $this->api->apiPost($this->userInfo['token'], "contract_cc_gh/get_list_gh", $data);
		// var_dump($contractData);die;
		if (!empty($contractData->status) && $contractData->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				"data" => $contractData->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
			];
			echo json_encode($response);
			return;
		}


	}

	public function get_list_cc()
	{
		$id_contract = !empty($_POST['id_contract']) ? $_POST['id_contract'] : "";

		$data = array(
			"id_contract" => $id_contract,
		);
		$contractData = $this->api->apiPost($this->userInfo['token'], "contract_cc_gh/get_list_cc", $data);
		// var_dump($contractData);die;
		if (!empty($contractData->status) && $contractData->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				"data" => $contractData->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
			];
			echo json_encode($response);
			return;
		}


	}

	public function checkContract()
	{
		$phone = !empty($_POST['phone']) ? $_POST['phone'] : "";
		$customer_identify = !empty($_POST['customer_identify']) ? $_POST['customer_identify'] : "";
		$customer_identify_old = !empty($_POST['customer_identify_old']) ? $_POST['customer_identify_old'] : "";
		$phone_number_relative_1 = !empty($_POST['phone_number_relative_1']) ? $_POST['phone_number_relative_1'] : "";
		$phone_number_relative_2 = !empty($_POST['phone_number_relative_2']) ? $_POST['phone_number_relative_2'] : "";
		$data = array(
			"phone" => $phone,
			"customer_identify" => $customer_identify,
			"customer_identify_old" => $customer_identify_old,
			"phone_number_relative_1" => $phone_number_relative_1,
			"phone_number_relative_2" => $phone_number_relative_2
		);
		$contractData = $this->api->apiPost($this->userInfo['token'], "contract/check_contract", $data);
		// var_dump($contractData);die;
		if (!empty($contractData->status) && $contractData->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				"data" => $contractData->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
			];
			echo json_encode($response);
			return;
		}


	}

	public function getAreaByDomain()
	{
		$code_domain = !empty($_POST['code_domain']) ? $_POST['code_domain'] : "";

		$data = array(

			"code_domain" => $code_domain
		);

		$areaData = $this->api->apiPost($this->userInfo['token'], "area/getAreaByDomain", $data);
		if (!empty($areaData->status) && $areaData->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $areaData->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('no_depreciation_configured')
			];
			echo json_encode($response);
			return;
		}

	}

	public function getStoreByArea()
	{
		$code_area = !empty($_POST['code_area']) ? $_POST['code_area'] : "";

		$data = array(

			"code_area" => $code_area
		);

		$areaData = $this->api->apiPost($this->userInfo['token'], "area/getStoreByArea", $data);
		if (!empty($areaData->status) && $areaData->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $areaData->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('no_depreciation_configured')
			];
			echo json_encode($response);
			return;
		}

	}

	public function getChar_kpi()
	{
		$start_date = !empty($_POST['start_date']) ? $_POST['start_date'] : "";
		$end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : "";
		$domain_vung = !empty($_POST['domain_vung']) ? $_POST['domain_vung'] : "";
		$area_vung = !empty($_POST['area_vung']) ? $_POST['area_vung'] : "";
		$store_vung = !empty($_POST['store_vung']) ? $_POST['store_vung'] : "";

		$data = array(
			"start_date" => $start_date,
			"end_date" => $end_date,
			"domain_vung" => $domain_vung,
			"area_vung" => $area_vung,
			"store_vung" => $store_vung
		);

		$areaData = $this->api->apiPost($this->userInfo['token'], "area/get_char_kpi", $data);
		if (!empty($areaData->status) && $areaData->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $areaData->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('no_depreciation_configured')
			];
			echo json_encode($response);
			return;
		}

	}

	public function checkTransaction()
	{
		$code_contract = !empty($_POST['code_contract']) ? $_POST['code_contract'] : "";
		$code_transaction = !empty($_POST['code_transaction']) ? $_POST['code_transaction'] : "";
		$data = array(
			"code_contract" => $code_contract,
			"code_transaction" => $code_transaction
		);
		$transactionData = $this->api->apiPost($this->userInfo['token'], "transaction/check_transaction", $data);
		// var_dump($contractData);die;
		if (!empty($transactionData->status) && $transactionData->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				"data" => $transactionData->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
			];
			echo json_encode($response);
			return;
		}


	}

	public function saveTransactionPrint()
	{
		$code_transaction = !empty($_POST['code_transaction']) ? $_POST['code_transaction'] : "";

		$data = array(
			"code_transaction" => $code_transaction,
			"user_print" => $this->userInfo['email']
		);
		$transactionPrint = $this->api->apiPost($this->userInfo['token'], "transaction_print/save_count_print", $data);
		if (!empty($transactionPrint->status) && $transactionPrint->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
			];
			echo json_encode($response);
			return;
		}
	}

	public function deepDetect()
	{
		$link = !empty($_GET['link']) ? $_GET['link'] : '';
		$result = $this->api->api_core_Post($this->userInfo['token'], "assetLocation/contract/deepDetect", ['link' => $link]);
		if ($result && $result->status == 200) {
			$response = [
				'status' => 200,
				'data' => $result->data,
				'message' => 'Thành công'
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'status' => 400,
				'message' => 'Thất bại'
			];
			echo json_encode($response);
			return;
		}

	}

	/**
	 * Gửi dữ liệu nhận dạng giấy tờ xe
	 */
	public function detect_registration()
	{
		$dataPost = $this->input->post();
		$property_id = !empty($dataPost['property_id']) ? $this->security->xss_clean($dataPost['property_id']) : '';
		$dataSendApi = [
			'property_id' => $property_id
		];
		$response = $this->api->apiPost($this->userInfo['token'], 'Property_blacklist/detect_registration', $dataSendApi);
		if (!empty($response->data)) {
			$response_js = [
				'status' => 200,
				'data' => $response->data
			];
			$this->pushJson(200, json_encode($response_js));
		} else {
			$response_js = [
				'status' => 400,
				'msg' => $response->message,
				'data' => array(),
			];
			$this->pushJson(200, json_encode($response_js));
		}

	}

	private function pushJson($code, $data)
	{
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}

	/**
	 * Check Hợp đồng liên quan từng thông tin
	 */
	public function check_contract_relative()
	{
		$dataPost = $this->input->post();
		$customer_name = !empty($this->security->xss_clean($dataPost['customer_name'])) ? $this->security->xss_clean($dataPost['customer_name']) : '';
		$customer_phone_number = !empty($this->security->xss_clean($dataPost['customer_phone_number'])) ? $this->security->xss_clean($dataPost['customer_phone_number']) : '';
		$customer_identify = !empty($this->security->xss_clean($dataPost['customer_identify'])) ? $this->security->xss_clean($dataPost['customer_identify']) : '';
		$passport_number = !empty($this->security->xss_clean($dataPost['passport_number'])) ? $this->security->xss_clean($dataPost['passport_number']) : '';
		$phone_number_relative = !empty($this->security->xss_clean($dataPost['phone_number_relative'])) ? $this->security->xss_clean($dataPost['phone_number_relative']) : '';
		//Thông tin khách hàng
		if (!empty($customer_name)) {
			$dataSend = array('customer_name' => $customer_name);
		}
		if (!empty($customer_phone_number)) {
			$dataSend = array('customer_phone_number' => $customer_phone_number);
		}
		if (!empty($customer_identify)) {
			$dataSend = array('customer_identify' => $customer_identify);
		}
		if (!empty($passport_number)) {
			$dataSend = array('passport_number' => $passport_number);
		}
		//Thông tin tham chiếu
		if (!empty($phone_number_relative)) {
			$dataSend = array('phone_number_relative' => $phone_number_relative);
		}
		$response = $this->api->apiPost($this->userInfo['token'], 'Contract/check_contract_relative', $dataSend);
		if (isset($response->status) && $response->status == 200) {
			$response_js = [
				'status' => 200,
				'data' => $response->data
			];
			$this->pushJson(200, json_encode($response_js));
		} else {
			$response_js = [
				'status' => 400,
				'data' => $response->data ? $response->data : ''
			];
			$this->pushJson(200, json_encode($response_js));
		}
		return;
	}

	/**
	 * Check SĐT nhân viên VFC
	 */
	public function check_staff_phone()
	{
		$dataPost = $this->input->post();
		$phone_number_relative = !empty($this->security->xss_clean($dataPost['phone_number_relative'])) ? $this->security->xss_clean($dataPost['phone_number_relative']) : '';
		if (!empty($phone_number_relative)) {
			$dataSendApi = [
				'phone_number_relative' => $phone_number_relative
			];
		}
		$check_staff_phone = $this->api->apiPost($this->userInfo['token'], 'User/check_staff_phone', $dataSendApi);
		if (isset($check_staff_phone->status) && $check_staff_phone->status == 200) {
			if ($check_staff_phone->data == true) {
				$response = [
					'status' => 400,
					'msg' => 'Không được dùng SĐT: '. $phone_number_relative .' của nhân viên VFC: ' . $check_staff_phone->email_user . ' làm tham chiếu!'
				];
				return $this->pushJson(200, json_encode($response));
			}
		}
	}

	/**
	 * Check Hợp đồng liên quan nhiều infor
	 */
	public function check_contract_relative_all()
	{
		$dataPost = $this->input->post();
		$customer_name = !empty($this->security->xss_clean($dataPost['customer_name'])) ? $this->security->xss_clean($dataPost['customer_name']) : '';
		$customer_phone_number = !empty($this->security->xss_clean($dataPost['customer_phone_number'])) ? $this->security->xss_clean($dataPost['customer_phone_number']) : '';
		$customer_identify = !empty($this->security->xss_clean($dataPost['customer_identify'])) ? $this->security->xss_clean($dataPost['customer_identify']) : '';
		$customer_identify_old = !empty($this->security->xss_clean($dataPost['customer_identify_old'])) ? $this->security->xss_clean($dataPost['customer_identify_old']) : '';
		$passport_number = !empty($this->security->xss_clean($dataPost['passport_number'])) ? $this->security->xss_clean($dataPost['passport_number']) : '';
		$phone_number_relative_1 = !empty($this->security->xss_clean($dataPost['phone_number_relative_1'])) ? $this->security->xss_clean($dataPost['phone_number_relative_1']) : '';
		$phone_number_relative_2 = !empty($this->security->xss_clean($dataPost['phone_number_relative_2'])) ? $this->security->xss_clean($dataPost['phone_number_relative_2']) : '';
		$phone_relative_3 = !empty($this->security->xss_clean($dataPost['phone_relative_3'])) ? $this->security->xss_clean($dataPost['phone_relative_3']) : '';
		$frame_number = !empty($this->security->xss_clean($dataPost['frame_number'])) ? $this->security->xss_clean($dataPost['frame_number']) : '';
		$dataSendApi = [
			'customer_name' => $customer_name,
			'customer_phone_number' => $customer_phone_number,
			'customer_identify' => $customer_identify,
			'customer_identify_old' => $customer_identify_old,
			'passport_number' => $passport_number,
			'phone_number_relative_1' => $phone_number_relative_1,
			'phone_number_relative_2' => $phone_number_relative_2,
			'phone_relative_3' => $phone_relative_3,
			'frame_number' => $frame_number,
		];
		$response = $this->api->apiPost($this->userInfo['token'], 'Contract/check_contract_relative_all', $dataSendApi);
		if (isset($response->status) && $response->status == 200) {
			$response_js = [
				'status' => 200,
				'contract_customer_name' => $response->contract_customer_name,
				'contract_phone_number' => $response->contract_phone_number,
				'contract_customer_identify' => $response->contract_customer_identify,
				'contract_customer_identify_old' => $response->contract_customer_identify_old,
				'contract_passport_number' => $response->contract_passport_number,
				'contract_phone_r1' => $response->contract_phone_r1,
				'contract_phone_r2' => $response->contract_phone_r2,
				'contract_phone_r3' => $response->contract_phone_r3,
				'contract_frame_number' => $response->contract_frame_number,
			];
			$this->pushJson(200, json_encode($response_js));
		} else {
			$response_js = [
				'status' => 400,
				'data' => null
			];
			$this->pushJson(200, json_encode($response_js));
		}
		return;
	}

	/**
	 * Lấy thông tin hãng xe theo mã tải sản property_code (xe máy/ô tô)
	 */
	public function get_brandname_property()
	{
		$dataPost = $this->input->post();
		$property_code = !empty($this->security->xss_clean($dataPost['property_code'])) ? $this->security->xss_clean($dataPost['property_code']) : '';
		if (!empty($property_code)) {
			$dataSendApi = [
				'code' => $property_code
			];
		}
		$response = $this->api->apiPost($this->userInfo['token'], "Property_v2/get_main_property", $dataSendApi);
		if (isset($response->status) && $response->status == 200) {
			$response_js = [
				'status' => 200,
				'data' => $response->data
			];
			$this->pushJson(200, json_encode($response_js));
		} else {
			$response_js = [
				'status' => 200,
				'data' => array()
			];
			$this->pushJson(200, json_encode($response_js));
		}
		return;
	}



}

?>

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// include APPPATH.'/libraries/Api.php';
class Pawn extends MY_Controller
{
	public function __construct()
	{

		parent::__construct();
		// $this->api = new Api();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url', 'file'));
		$this->load->helper('lead_helper');
		$this->load->helper('download_helper');
		$this->load->model("main_property_model");
		$this->load->model('config_gic_model');
		$this->load->model("time_model");
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


	}

	public function imageResize($imageResourceId, $width, $height)
	{
		$targetWidth = 200;
		$targetHeight = 200;
		$targetLayer = imagecreatetruecolor($targetWidth, $targetHeight);
		imagecopyresampled($targetLayer, $imageResourceId, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);


		return $targetLayer;
	}

	public function upload_img_contract()
	{
		if ($_FILES['file']['size'] > 20000000) {
			$response = array(
				'code' => 201,
				'msg' => 'Kích cỡ max là 10MB'
			);
			return $this->pushJson('200', json_encode($response));
		}
		$acceptFormat = array("jpeg", "png", "jpg", "mp3", "mp4", "image/jpeg", "image/png", "image/jpg");
		if (in_array($_FILES['file']['type'], $acceptFormat) == FALSE) {
			$response = array(
				'code' => 201,
				'msg' => 'Định dạng không cho phép',
				'type' => $_FILES['file']['type']
			);
			return $this->pushJson('200', json_encode($response));
		}

		$this->load->library('upload');
		$config['upload_path'] = './uploads/contract';
		$config['allowed_types'] = '*';
		//$config['allowed_types']        = 'gif|jpg|png|jpeg|mp3|mp4|';
		// $config['allowed_types']  = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
		$config['max_size'] = 10000;
		$config['overwrite'] = TRUE;
		$config['file_name'] = time() . '-' . md5(time());
		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('file')) {
			$error = array('error' => $this->upload->display_errors());
			$response = array(
				'code' => 201,
				'msg' => $error
			);
			return $this->pushJson('200', json_encode($response));
		} else {
			try {
				$data = array('timestamp' => $this->time_model->getTimeUTC(), 'upload_data' => $this->upload->data());
				$file_name = str_replace(".", "", $config['upload_path']) . "/" . $data['upload_data']['file_name'];
				$random = sha1(substr(md5(rand()), 0, 8));
				$response = array(
					'code' => 200,
					"msg" => "success",
					'path' => $file_name,
					'key' => $random,
					'raw_name' => $_FILES['file']['name']
				);
				$push = json_encode($response);
				return $this->pushJson(200, $push);
			} catch (Exception $e) {
				$e->getMessage();
			}
		}
	}


	public function upload_img()
	{
		// $data = $this->input->post();
		if ($_FILES['file']['size'] > 20000000) {
			return $this->pushJson('200', json_encode(array(
				'code' => '201',
				'msg' => 'Kích cỡ max là 10MB'
			)));
		}
		$acceptFormat = array("jpeg", "png", "jpg", "mp3", "mp4","pdf",'docx','doc','xlsx');
		if (in_array($_FILES['file']['type'], $acceptFormat)) {
			return $this->pushJson('200', json_encode(array(
				'code' => '201',
				'msg' => 'Định dạng không cho phép',
				'type' => $_FILES['file']['type']
			)));
		}

		$serviceUpload = $this->config->item("url_service_upload");
		// $curlFile  = new CURLFile($_FILES["avatar"]["tmp_name"],$_FILES["avatar"]["type"],$_FILES["avatar"]["name"]);
		$cfile = new CURLFile($_FILES['file']["tmp_name"], $_FILES['file']["type"], $_FILES['file']["name"]);
		$post = array('avatar' => $cfile);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $serviceUpload);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		$result1 = json_decode($result);

		$random = sha1(substr(md5(rand()), 0, 8));

		if (empty($result1->path)) {
			return $this->pushJson('200', json_encode(array(
				'code' => '201',
				'msg' => 'File lỗi! Hệ thống không đọc được file (file ảnh bạn mở màn hình chụp lại rồi tạo ảnh mới upload lại)'
			)));
		} else {
			$response = array(
				'code' => 200,
				"msg" => "success",
				'path' => $result1->path,
				'key' => $random,
				'raw_name' => $_FILES['file']['name']
			);
			$push = json_encode($response);
			return $this->pushJson(200, $push);
		}
	}

	public function doUploadContract()
	{
		$data = $this->input->post();
		$data['contractId'] = $this->security->xss_clean($data['contractId']);
		$data['identify'] = $this->security->xss_clean($data['identify']);
		$data['household'] = $this->security->xss_clean($data['household']);
		$data['driver_license'] = $this->security->xss_clean($data['driver_license']);
		$data['vehicle'] = $this->security->xss_clean($data['vehicle']);
		$data['agree'] = $this->security->xss_clean($data['agree']);
		$data['digital'] = $this->security->xss_clean($data['digital']);
		$data['locate'] = $this->security->xss_clean($data['locate']);
		$image_accurecy = array(
			"identify" => $data['identify'],
			"household" => $data['household'],
			"driver_license" => $data['driver_license'],
			"vehicle" => $data['vehicle'],
			"agree" => $data['agree'],
			"digital" => $data['digital'],
			"locate" => $data['locate'],
		);
		$dataPost = array(
			"id" => $data['contractId'],
			"image_accurecy" => $image_accurecy,
		);
		$result = $this->api->apiPost($this->userInfo['token'], "contract/upload_image_contract", $dataPost);
		$this->pushJson('200', json_encode(array("code" => "200", "data" => $result)));
	}

	// private $createdAt;
	public function approveContract()
	{
		$data = $this->input->post();
		$data['note'] = $this->security->xss_clean($data['note']);
		$data['reason'] = $this->security->xss_clean($data['approve_reason_hs']);
		$data['status'] = $this->security->xss_clean($data['status']);
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['id_oid'] = $this->security->xss_clean($data['id_oid']);
		$data['error_code'] = $this->security->xss_clean($data['error_code']);
		$data['amount_money'] = $this->security->xss_clean($data['amount_money']);
		$data['amount_loan'] = $this->security->xss_clean($data['amount_loan']);
		$data['amount_GIC'] = $this->security->xss_clean($data['amount_GIC']);
		$data['loan_insurance'] = $this->security->xss_clean($data['loan_insurance']);
		$data['code_contract_disbursement'] = $this->security->xss_clean($data['code_contract_disbursement']);
		$data['code_contract_disbursement_type'] = $this->security->xss_clean($data['codeContractDisbursementType']);
		$data['image_file'] = $this->security->xss_clean($data['image_file']);
		$data['lead_cancel1_C1'] = $this->security->xss_clean($data['lead_cancel1_C1']);
		$data['lead_cancel1_C2'] = $this->security->xss_clean($data['lead_cancel1_C2']);
		$data['lead_cancel1_C3'] = $this->security->xss_clean($data['lead_cancel1_C3']);
		$data['lead_cancel1_C4'] = $this->security->xss_clean($data['lead_cancel1_C4']);
		$data['lead_cancel1_C5'] = $this->security->xss_clean($data['lead_cancel1_C5']);
		$data['lead_cancel1_C6'] = $this->security->xss_clean($data['lead_cancel1_C6']);
		$data['lead_cancel1_C7'] = $this->security->xss_clean($data['lead_cancel1_C7']);
		$data['exception1_value_detail'] = $this->security->xss_clean($data['exception1_value_detail']);
		$data['exception2_value_detail'] = $this->security->xss_clean($data['exception2_value_detail']);
		$data['exception3_value_detail'] = $this->security->xss_clean($data['exception3_value_detail']);
		$data['exception4_value_detail'] = $this->security->xss_clean($data['exception4_value_detail']);
		$data['exception5_value_detail'] = $this->security->xss_clean($data['exception5_value_detail']);
		$data['exception6_value_detail'] = $this->security->xss_clean($data['exception6_value_detail']);
		$data['exception7_value_detail'] = $this->security->xss_clean($data['exception7_value_detail']);
		$data['exception7_value_detail'] = $this->security->xss_clean($data['exception7_value_detail']);
		$data['so_tien_vay_asm_de_xuat '] = $this->security->xss_clean($data['so_tien_vay_asm_de_xuat']);
		$data['ki_han_vay_asm_de_xuat '] = $this->security->xss_clean($data['ki_han_vay_asm_de_xuat']);
		if ($data['status'] == 15 && empty($data['code_contract_disbursement'])) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => "Mã hợp đồng là bắt buộc ",)));
			return;
		}
		$list_hs = $this->api->apiPost($this->userInfo['token'], "exportExcel/get_user_hs");
		if (!empty($list_hs->status) && $list_hs->status == 200) {
			$this->data['list_hs'] = $list_hs->data;
		} else {
			$this->data['list_hs'] = array();
		}
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));

		//Validate Seri Định Vị
		if($data['status'] == 2 || $data['status'] == 5 || $data['status'] == 15){
			if ($contract->data->loan_infor->loan_product->code == 19){
				$check_status_device = $this->api->apiPost($this->userInfo['token'], "contract/check_status_device", ['device_asset_location_id' => $contract->data->loan_infor->device_asset_location->device_asset_location_id]);
				if(!empty($check_status_device) && $check_status_device->status != 200){
					$this->pushJson('200', json_encode(array("code" => "401", "msg" => "Seri định vị đã được sử dụng, vui lòng vào thay mã seri khác")));
					return;
				}
			}
		}



		if ($data['status'] == 6) {
			// Begin Check require PTI BHTNCN
            if (empty($contract->data->loan_infor->pti_bhtn)) {
				$ptiBHTN = $this->api->apiPost($this->user['token'], "contract/validatePtiBHTNCN", [
					'amount_money' => $data['amount_money'],
					'customer_identify' => $contract->data->customer_infor->customer_identify
				]);
		        if (!empty($ptiBHTN->status) && $ptiBHTN->status == 200) {
		         	// do nothing
		        }else{
		        	$message = "Mục PTI - BHTN bắt buộc cho khoản vay trên 7tr";
		        	if (!empty($ptiBHTN->message)) {
		        		$message = $ptiBHTN->message;
		        	}
		        	$this->pushJson('200', json_encode([
		        		"status" => "400", 
		        		'msg' => $message, 
		        		'data' => $ptiBHTN
		        	]));
		        	return;
		        }
	            // End Check require PTI BHTNCN
			}
		}
		if ($contract->status == 200) {
			$contractInfo = $contract->data;
			$pti_insurance = ($contractInfo->loan_infor->bao_hiem_pti_vta->price_pti_vta) ? $contractInfo->loan_infor->bao_hiem_pti_vta->price_pti_vta : "";
			if ($data['status'] == 15 && !empty($pti_insurance)) {
				//  alert error, stop sell pti from 19/03/2022!!!
				if ($pti_insurance > 0) {
					$this->pushJson('200', json_encode(array("code" => "401", "msg" => "Sản phẩm bảo hiểm PTI VTA đã ngừng bán, liên hệ IT để được hỗ trợ!")));
					return;
				}
			}
			// check thỏa thuận ba bên megadoc trước khi tạo bbbg megadoc
			$store_digital = $this->api->apiPost($this->userInfo['token'], "nextpay/check_store_create_contract_digital", ['store_id'=> $contract->data->store->id]);
			if (!empty($store_digital->status) && $store_digital->status == 200) {
				if ($store_digital->data == 1) {
					if (!empty($contractInfo->customer_infor->type_contract_sign) && $contractInfo->customer_infor->type_contract_sign == 1) {
						if ($data['status'] == 15) {
							// Check hợp đồng điện tử đã đủ chữ ký số hay chưa
							$check_megadoc = $this->api->apiPost($this->userInfo['token'],'contract/check_ttbb_megadoc', array("code_contract" => $contract->data->code_contract));
							if (!empty($check_megadoc->status) && $check_megadoc->status == 200) {
								if (!$check_megadoc->is_ttbb_digital) {
									$this->pushJson('200', json_encode(array("code" => "401", "msg" => "Thỏa thuận ba bên điện tử chưa có đầy đủ chữ ký số!")));
									return;
								}
								if (!$check_megadoc->is_bbbg_digital) {
									$this->pushJson('200', json_encode(array("code" => "401", "msg" => "Biên bản bàn giao tài sản điện tử chưa có đầy đủ chữ ký số!")));
									return;
								}
								if (!empty($contractInfo->loan_infor->type_property->code) && $contractInfo->loan_infor->type_property->code != 'NĐ') {
									if (!$check_megadoc->is_tb_digital) {
										$this->pushJson('200', json_encode(array("code" => "401", "msg" => "Khách hàng chưa ký văn bản Thông báo!")));
										return;
									}
								}
							}
							// Check PGD đã upload video vào mục Chứng từ Thỏa thuận điện tử hay chưa
							if (empty($contractInfo->image_accurecy->digital)) {
								$this->pushJson('200', json_encode(array("code" => "401", "msg" => "PGD chưa upload chứng từ vào mục Thỏa thuận hợp đồng điện tử!")));
								return;
							}
							if (!empty($contractInfo->image_accurecy->digital)) {
								$array_type_file = array();
								$count_pdf = 0;
								foreach ($contractInfo->image_accurecy->digital as $digi) {
									array_push($array_type_file, $digi->file_type);
									if ($digi->file_type == 'application/pdf') {
										$count_pdf ++;
									}
								}
								$isset_video = false;
								$isset_pdf = false;
								if (!empty($array_type_file) && in_array('application/pdf', $array_type_file)) {
									$isset_pdf = true;
								}
								if (!$isset_pdf) {
									$this->pushJson('200', json_encode(array("code" => "401", "msg" => "PGD chưa upload File PDF hợp đồng điện tử vào mục Thỏa thuận hợp đồng điện tử!")));
									return;
								}
								if (!empty($contractInfo->loan_infor->type_property->code) && $contractInfo->loan_infor->type_property->code == 'NĐ') {
									if ($count_pdf < 2 ) {
										$this->pushJson('200', json_encode(array("code" => "401", "msg" => "PGD chưa upload đủ chứng từ PDF hợp đồng điện tử vào mục Thỏa thuận hợp đồng điện tử!")));
										return;
									}
								} elseif (!empty($contractInfo->loan_infor->type_loan->code) && ($contractInfo->loan_infor->type_loan->code == 'CC' || $contractInfo->loan_infor->type_loan->code == 'DKX') && $contractInfo->loan_infor->type_property->code != "TC") {
									if ($count_pdf < 3 ) {
										$this->pushJson('200', json_encode(array("code" => "401", "msg" => "PGD chưa upload đủ chứng từ PDF hợp đồng điện tử vào mục Thỏa thuận hợp đồng điện tử!")));
										return;
									}
								}

								if (!empty($array_type_file) && in_array('video/mp4', $array_type_file)) {
									$isset_video = true;
								}
								if (!$isset_video) {
									$this->pushJson('200', json_encode(array("code" => "401", "msg" => "PGD chưa upload video khách hàng ký hợp đồng điện tử vào mục Thỏa thuận hợp đồng điện tử!")));
									return;
								}
							}
						}
					}
				}
			}
		}
		$check_oid = [
			"id_oid" => $data['id_oid']
		];
		$this->api->apiPost($this->userInfo['token'], "hoiso_create/update_check_hs", $check_oid);

//		if (in_array($this->userInfo['email'], $list_hs->data)) {
//			if ($contract->data->status != 5 && $contract->data->status != 25 && $contract->data->status != 27) {
//				$this->pushJson('200', json_encode(array("code" => "401", "msg" => "Hợp đồng đã được xử lý",)));
//				return;
//			}
//		}


		if ($contract->status == 200) {
			$contract = $contract->data;
			$dataPost = array(
				"note" => $data['note'],
				"reason" => $data['reason'],
				"status" => $data['status'],
				"error_code" => $data['error_code'],
				"contract_id" => $data['id'],
				"amount_money" => $data['amount_money'],
				"amount_loan" => $data['amount_loan'],
				"code_contract_disbursement" => $data['code_contract_disbursement'],
				"code_contract_disbursement_type" => $data['code_contract_disbursement_type'],
				"image_file" => $data['image_file'],
				'lead_cancel1_C1' => $data['lead_cancel1_C1'],
				'lead_cancel1_C2' => $data['lead_cancel1_C2'],
				'lead_cancel1_C3' => $data['lead_cancel1_C3'],
				'lead_cancel1_C4' => $data['lead_cancel1_C4'],
				'lead_cancel1_C5' => $data['lead_cancel1_C5'],
				'lead_cancel1_C6' => $data['lead_cancel1_C6'],
				'lead_cancel1_C7' => $data['lead_cancel1_C7'],
				'exception1_value_detail' => $data['exception1_value_detail'],
				'exception2_value_detail' => $data['exception2_value_detail'],
				'exception3_value_detail' => $data['exception3_value_detail'],
				'exception4_value_detail' => $data['exception4_value_detail'],
				'exception5_value_detail' => $data['exception5_value_detail'],
				'exception6_value_detail' => $data['exception6_value_detail'],
				'exception7_value_detail' => $data['exception7_value_detail'],
				'so_tien_vay_asm_de_xuat' => $data['so_tien_vay_asm_de_xuat'],
				'ki_han_vay_asm_de_xuat' => $data['ki_han_vay_asm_de_xuat'],
			);
			if ($data['loan_insurance'] == "1") {
				$dataPost["amount_GIC"] = $data['amount_GIC'];
				$dataPost["amount_MIC"] = 0;
			}
			if ($data['loan_insurance'] == "2") {
				$dataPost["amount_MIC"] = $data['amount_GIC'];
				$dataPost["amount_GIC"] = 0;
			}
			$dataPost['code_GIC_plt'] = (!empty($contract->loan_infor->code_GIC_plt)) ? $contract->loan_infor->code_GIC_plt : '';
			$dataPost['is_free_gic_plt'] = (!empty($contract->loan_infor->is_free_gic_plt)) ? $contract->loan_infor->is_free_gic_plt : 2;
			$dataPost['amount_GIC_plt'] = (!empty($contract->loan_infor->amount_GIC_plt)) ? $contract->loan_infor->amount_GIC_plt : '';

			$result = $this->api->apiPost($this->userInfo['token'], "contract/approve", $dataPost);


			if (empty($result->status)) {
				$this->pushJson('200', json_encode(array("code" => "401", "msg" => "approve error", "data" => $result)));
				return;
			}
			if (!empty($result->status) && $result->status == 200) {
				$this->pushJson('200', json_encode(array("code" => "200", "msg" => $result->message, "data" => $result)));
				return;
			}
			if (!empty($result->status) && $result->status == 401) {
				$this->pushJson('200', json_encode(array("code" => "401", "msg" => $result->message, "data" => $result)));
				return;
			} else {
				$this->pushJson('200', json_encode(array("code" => "401", "msg" => $result->message,)));
				return;
			}
		}
	}

	public function request_exten()
	{
		$data = $this->input->post();

		$data['contractId'] = $this->security->xss_clean($data['contractId']);
		$data['status'] = $this->security->xss_clean($data['status']);
		$data['exception_gh'] = $this->security->xss_clean($data['exception_gh']);
		$data['image_file'] = $this->security->xss_clean($data['image_file']);
		$data['note'] = $this->security->xss_clean($data['note']);
		$data['number_day_loan'] = $this->security->xss_clean($data['number_day_loan']);
		$data['amount_money'] = $this->security->xss_clean($data['amount_money']);
		$data['type_loan'] = $this->security->xss_clean($data['type_loan']);
		$data['type_interest'] = $this->security->xss_clean($data['type_interest']);

		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['contractId']));
		if ($contract->status == 200) {
			if (empty($data['number_day_loan'])) {
				$this->pushJson('200', json_encode(array("code" => "401", "msg" => 'Bạn cần chọn thời gian vay', "data" => $result)));
				return;
			}
			if (empty($data['image_file'])) {
				$this->pushJson('200', json_encode(array("code" => "401", "msg" => 'Bạn cần up ảnh chứng thực', "data" => $result)));
				return;
			}
			if ($data['status'] == 23 || $data['status'] == 12 || $data['status'] == 27 || $data['status'] == 31 || $data['status'] == 32) {
				if (empty($data['type_interest'])) {
					$this->pushJson('200', json_encode(array("code" => "401", "msg" => 'Bạn cần chọn hình thức trả lãi', "data" => $result)));
					return;
				}

				$data_ct = array(
					"id" => $data['contractId'],
					"date_pay" => date("Y-m-d")
				);
				$contractData = $this->api->apiPost($this->userInfo['token'], "view_payment/tempo_detail", $data_ct);
				$data_part_1 = $this->api->apiPost($this->userInfo['token'], "view_payment/get_infor_tat_toan_part_1", ['code_contract' => $contract->data->code_contract, "date_pay" => date("Y-m-d")]);
				$debt_detail = $this->api->apiPost($this->userInfo['token'], "view_payment/debt_detail", ['id' => $data['contractId'], "date_pay" => date("Y-m-d")]);
				$tien_chua_tra_ky_thanh_toan = (!empty($contractData->contract->tien_chua_tra_ky_thanh_toan)) ? $contractData->contract->tien_chua_tra_ky_thanh_toan : 0;
				$tien_du_ky_truoc = (!empty($contractData->contract->tien_du_ky_truoc)) ? $contractData->contract->tien_du_ky_truoc : 0;
				$tien_thua_thanh_toan = (!empty($contractData->contract->tien_thua_thanh_toan)) ? $contractData->contract->tien_thua_thanh_toan : 0;
				$phi_thanh_toan_truoc_han = (!empty($debt_detail->data->phi_thanh_toan_truoc_han)) ? $debt_detail->data->phi_thanh_toan_truoc_han : 0;

				$max = $data_part_1->data->du_no_con_lai + $contractData->contract->phi_phat_sinh_ngay_thanh_toan + $contractData->contract->penalty_pay + $tien_chua_tra_ky_thanh_toan + $phi_thanh_toan_truoc_han - $tien_du_ky_truoc - $tien_thua_thanh_toan;
				$min = $data_part_1->data->goc_chua_tra;

				// if ((int)$data['amount_money'] <= 0 || (int)$data['amount_money'] < (int)$min || $min <= 0 || $max <= 0) {
				 if ((int)$data['amount_money'] <= 0) {
					// $this->pushJson('200', json_encode(array("code" => "401", "msg" => 'Số tiền cơ cấu phải nằm trong khoảng ' . number_format($min) . 'đ đến ' . number_format($max) . 'đ', "data" => $data['amount_money'])));
					$this->pushJson('200', json_encode(array("code" => "401", "msg" => 'Số tiền cơ cấu phải lớn hơn 0 ' )));
					return;
				}
			}
			$status_origin = (!empty($contract->data->status)) ? $contract->data->status : 0;
			$dataPost = array(
				"note" => $data['note'],
				"number_day_loan" => $data['number_day_loan'],
				"contract_id" => $data['contractId'],
				"status" => $data['status'],
				"exception" => $data['exception'],
				"image_file" => $data['image_file'],
				"amount_money" => $data['amount_money'],
				"type_loan" => $data['type_loan'],
				"type_interest" => $data['type_interest'],
			);
			$result = $this->api->apiPost($this->userInfo['token'], "contract/approve", $dataPost);
			if (empty($result->status)) {

				$this->pushJson('200', json_encode(array("code" => "401", "msg" => "approve error", "data" => $result)));
				return;
			}
			if (!empty($result->status) && $result->status == 200) {

				if ($data['status'] == 17) {
					$data_delete = array(
						"code_contract" => $contract->data->code_contract,
					);
					$this->api->apiPost($this->userInfo['token'], "contract_cc_gh/check_update_type_payment", $data_delete);
					$result_delete_and_update = $this->api->apiPost($this->userInfo['token'], "contract/delete_lai_ky_lai_thang", $data_delete);
					if (!empty($result_delete_and_update->status) && $result_delete_and_update->status == 200) {


						$dataPost_dele = array(
							"code_contract" => $contract->data->code_contract,
							"investor_code" => $contract->data->investor_code,
							"disbursement_date" => $contract->data->disbursement_date
						);
						$result = $this->api->apiPost($this->userInfo['token'], "generateContract/processContract", $dataPost_dele);
						if (!empty($result->status) && $result->status == 200) {

							$this->api->apiPost($this->userInfo['token'], "transaction/payment_all_contract", $dataPost_dele);
						}
					}
				}
				$this->pushJson('200', json_encode(array("code" => "200", "msg" => $result->message, "data" => $result)));
				return;
			}
			if (!empty($result->status) && $result->status == 401) {
				$this->pushJson('200', json_encode(array("code" => "401", "msg" => $result->message, "data" => $result)));
				return;
			} else {
				$this->pushJson('200', json_encode(array("code" => "401", "msg" => "Mã hợp đồng là bắt buộc ",)));
				return;
			}
		}

	}

	public function approveContractForQuickLoan()
	{
		$data = $this->input->post();
		$data['note'] = $this->security->xss_clean($data['note']);
		$data['status'] = $this->security->xss_clean($data['status']);
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['amount_money'] = $this->security->xss_clean($data['amount_money']);
		$data['amount_loan'] = $this->security->xss_clean($data['amount_loan']);
		$data['amount_GIC'] = $this->security->xss_clean($data['amount_GIC']);
		$dataPost = array(
			"note" => $data['note'],
			"status" => $data['status'],
			"contract_id" => $data['id'],
			"amount_money" => $data['amount_money'],
			"amount_loan" => $data['amount_loan'],
			"amount_GIC" => $data['amount_GIC'],
		);
		$result = $this->api->apiPost($this->userInfo['token'], "contract/approve_for_quickloan", $dataPost);
		if (empty($result->status)) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => "approve error", "data" => $result, "postval" => $dataPost)));
			return;
		}
		if (!empty($result->status) && $result->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $result->message, "data" => $result, "postval" => $dataPost)));
			return;
		}
		if (!empty($result->status) && $result->status == 401) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $result->message, "data" => $result, "postval" => $dataPost)));
			return;
		}
	}

	public function doUploadImage()
	{
		$data = $this->input->post();
		$data['type_img'] = $this->security->xss_clean($data['type_img']);
		$data['contract_id'] = $this->security->xss_clean($data['contract_id']);
		$dataPost = array(
			"id" => $data['contract_id'],
			"type_img" => $data['type_img'],
			"file" => $_FILES['file']
		);
		$result = $this->api->apiPost($this->userInfo['token'], "contract/upload_image", $dataPost);
		// echo $result; return;
		$this->pushJson('200', json_encode(array("code" => "200", "data" => $result)));
	}

	public function deleteImage()
	{
		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['type_img'] = $this->security->xss_clean($data['type_img']);
		$data['key'] = $this->security->xss_clean($data['key']);
		$dataPost = array(
			"id" => $data['id'],
			"type_img" => $data['type_img'],
			"key" => $data['key']
		);
		$result = $this->api->apiPost($this->userInfo['token'], "contract/delete_image", $dataPost);
		$this->pushJson('200', json_encode(array("code" => "200", "data" => $result)));
	}

	public function uploadsImageAccuracy()
	{
		$this->data["pageName"] = $this->lang->line('update_img_authentication');
		$this->data['template'] = 'page/pawn/upload_img';
		$dataGet = $this->input->get();
		$dataGet['id'] = $this->security->xss_clean($dataGet['id']);
		$dataPost = array(
			"id" => $dataGet['id']
		);
		$dataContract = $this->api->apiPost($this->user['token'], "contract/get_one", $dataPost);
		$result = $this->api->apiPost($this->userInfo['token'], "contract/get_image_accurecy", $dataPost);
		$this->data['type_contract'] = !empty($dataContract->data->customer_infor->type_contract_sign) ? $dataContract->data->customer_infor->type_contract_sign : '2';
		$this->data['result'] = $result->data;
		$this->data['contract_status'] = $result->contract_status;
		$this->data['type_property'] = !empty($dataContract->data->loan_infor->type_property->code) ? $dataContract->data->loan_infor->type_property->code : '';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function viewImageAccuracy()
	{
		$this->data["pageName"] = $this->lang->line('view_img_authentication');
		$this->data['template'] = 'page/pawn/view_img';
		$dataGet = $this->input->get();
		$dataGet['id'] = $this->security->xss_clean($dataGet['id']);
		$dataPost = array(
			"id" => $dataGet['id']
		);
		$dataContract = $this->api->apiPost($this->user['token'], "contract/get_one", $dataPost);
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		$result = $this->api->apiPost($this->userInfo['token'], "contract/get_image_accurecy", $dataPost);
		$this->data['type_contract'] = !empty($dataContract->data->customer_infor->type_contract_sign) ? $dataContract->data->customer_infor->type_contract_sign : '2';
		$this->data['result'] = $result->data;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function continueCreate()
	{
		//Get information
		$data = $this->input->get();
		$id = $this->security->xss_clean($data['id']);
		$this->data['tilekhoanvay'] = 0;
		$config = $this->api->apiPost($this->userInfo['token'], "config_gic/get_config", array('code' => "TN_TNNNV"));
		if (!empty($config->status) && $config->status == 200) {
			$this->data['tilekhoanvay'] = (!empty($config->data->TyLePhi)) ? $config->data->TyLePhi : 0;
		}

		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $id));
		if ($contract->status == 200) {
			$id_store = $contract->data->store->id;
			//get hình thức vay
			$configuration_formality = $this->api->apiPost($this->userInfo['token'], "configuration_formality/get_configuration_formality");
			if (!empty($configuration_formality->status) && $configuration_formality->status == 200) {
				$this->data['configuration_formality'] = $configuration_formality->data;
			} else {
				$this->data['configuration_formality'] = array();
			}
			//get property main ( tài sản cấp cao nhất parenid == null)
			$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main");
			if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
				$this->data['mainPropertyData'] = $mainPropertyData->data;
			} else {
				$this->data['mainPropertyData'] = array();
			}
			//Init loan infor
			$arrMinus = array();
			if (!empty($contract->data->loan_infor->decreaseProperty)) {
				$decreaseProperty = $contract->data->loan_infor->decreaseProperty;
				foreach ($decreaseProperty as $item) {
					$a = array();
					$a['checked'] = !empty($item->checked) ? $item->checked : '';
					$a['name'] = !empty($item->name) ? $item->name : '';
					$a['slug'] = !empty($item->slug) ? $item->slug : '';
					$a['price'] = !empty($item->value) ? $item->value : '';
					array_push($arrMinus, $a);
				}
			}
			$data = array(
				"id" => $contract->data->loan_infor->name_property->id,
				"code_type_property" => $contract->data->loan_infor->type_property->code,
				"type_loan" => $contract->data->loan_infor->type_loan->code
			);
			$price_property = "";
			$percent = "";
			$depreciationData = $this->api->apiPost($this->userInfo['token'], "property/get_depreciation_by_property", $data);
			if (!empty($depreciationData->status) && $depreciationData->status == 200) {

				$price_property = $depreciationData->price_property;
				$percent = $depreciationData->percent;
				$price_goc = $depreciationData->price_goc;


			}
			// var_dump($this->data['mainPropertyData'] ); die;
			$dataLoanInfor = array(
				"type_finance" => !empty($contract->data->loan_infor->type_loan->id) ? $contract->data->loan_infor->type_loan->id : "",
				"main" => !empty($contract->data->loan_infor->type_property->id) ? $contract->data->loan_infor->type_property->id : "",
				"sub" => !empty($contract->data->loan_infor->name_property->id) ? $contract->data->loan_infor->name_property->id : "",
				"subName" => !empty($contract->data->loan_infor->name_property->text) ? $contract->data->loan_infor->name_property->text : "",
				"minus" => $arrMinus,
				"price_property" => $price_property,
				"price_goc" => $price_goc,
				"percent" => $percent,
				"rootPrice" => !empty($contract->data->loan_infor->price_property) ? $contract->data->loan_infor->price_property : "",
				"loan_product" => !empty($contract->data->loan_infor->loan_product->code) ? $contract->data->loan_infor->loan_product->code : "",
				"editPrice" => !empty($contract->data->loan_infor->amount_money_max) ? $contract->data->loan_infor->amount_money_max : ""
			);
			//Start Địa chỉ đang ở
			$provinceSelected = $contract->data->current_address->province;
			$districtSelected = $contract->data->current_address->district;
			$provinceData = $this->api->apiPost($this->userInfo['token'], "province/get_province");
			if (!empty($provinceData->status) && $provinceData->status == 200) {
				$this->data['provinceData'] = $provinceData->data;
			} else {
				$this->data['provinceData'] = array();
			}
			$districtData = $this->api->apiPost($this->userInfo['token'], "province/get_district_by_province", array("id" => $provinceSelected));
			if (!empty($districtData->status) && $districtData->status == 200) {
				$this->data['districtData'] = $districtData->data;
			} else {
				$this->data['districtData'] = array();
			}
			$fee_data = $this->api->apiPost($this->userInfo['token'], "feeLoanNew/get_all", array());
			if (!empty($fee_data->status) && $fee_data->status == 200) {
				$this->data['fee_data'] = $fee_data->data;
			} else {
				$this->data['fee_data'] = array();
			}
			$wardData = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtSelected));
			if (!empty($wardData->status) && $wardData->status == 200) {
				$this->data['wardData'] = $wardData->data;
			} else {
				$this->data['wardData'] = array();
			}
			//End
			//Start Địa chỉ hộ khẩu
			$provinceSelected_ = $contract->data->houseHold_address->province;
			$districtSelected_ = $contract->data->houseHold_address->district;
			$provinceData_ = $this->api->apiPost($this->userInfo['token'], "province/get_province");
			if (!empty($provinceData_->status) && $provinceData_->status == 200) {
				$this->data['provinceData_'] = $provinceData_->data;
			} else {
				$this->data['provinceData_'] = array();
			}
			//get district by province
			$districtData_ = $this->api->apiPost($this->userInfo['token'], "province/get_district_by_province", array("id" => $provinceSelected_));
			if (!empty($districtData_->status) && $districtData_->status == 200) {
				$this->data['districtData_'] = $districtData_->data;
			} else {
				$this->data['districtData_'] = array();
			}

			//get ward by district
			$wardData_ = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtSelected_));
			if (!empty($wardData_->status) && $wardData_->status == 200) {
				$this->data['wardData_'] = $wardData_->data;
			} else {
				$this->data['wardData_'] = array();
			}
			//End
			$company_storage_phone = [
				'check_phone' => $contract->data->customer_infor->customer_phone_number
			];
			$company_storage = $this->api->apiPost($this->userInfo['token'], "company_storage/get_all_company_storage", $company_storage_phone);
			if (!empty($company_storage->status) && $company_storage->status == 200) {
				$this->data['company_storage'] = $company_storage->data;
			} else {
				$this->data['company_storage'] = array();
			}

		} else {
			$dataLoanInfor = array();
			$this->data['bankVimoData'] = array();
			$this->data['wardData'] = array();
			$this->data['provinceData_'] = array();
			$this->data['districtData'] = array();
			$this->data['configuration_formality'] = array();
			$this->data['mainPropertyData'] = array();
		}
		// //get bank vimo
		// $bankVimoData = $this->api->apiPost($this->userInfo['token'], "BankVimo/get_all");
		// if(!empty($bankVimoData->status) && $bankVimoData->status == 200){
		//     $this->data['bankVimoData'] = $bankVimoData->data;
		// }else{
		//     $this->data['bankVimoData'] = array();
		// }

		//get bank ngan luong
		$bankNganluongData = $this->api->apiPost($this->userInfo['token'], "bankNganLuong/get_all", array("account_type => 3"));
		if (!empty($bankNganluongData->status) && $bankNganluongData->status == 200) {
			$this->data['bankNganluongData'] = $bankNganluongData->data;
		} else {
			$this->data['bankNganluongData'] = array();
		}


		// $log = $this->api->apiPost($this->userInfo['token'], "log/get_log_contract", array("contract_id" => $id));
		// if(!empty($log->status) && $log->status == 200){
		//     $this->data['logs'] = $log->data;
		// }else{
		//     $this->data['logs'] = array();
		// }
		$userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
		$stores = !empty($userInfo['stores']) ? $userInfo['stores'] : array();
		$storeDataCentral = $this->api->apiPost($this->userInfo['token'], "Store/getAllStoreCentralNoneDirectSales", array());
		if (!empty($storeDataCentral->status) && $storeDataCentral->status == 200) {
			$this->data['storeDataCentral'] = $storeDataCentral->data;
		} else {
			$this->data['storeDataCentral'] = array();
		}
		//check PGD có áp dụng hợp đồng điện tử hay ko
		$store_megadoc = $this->api->apiPost($this->userInfo['token'], "nextpay/check_store_create_contract_digital", ["store_id" => $id_store]);
		if (!empty($store_megadoc->status) && $store_megadoc->status == 200) {
			$this->data['store_digital'] = $store_megadoc->data;
		} else {
			$this->data['store_digital'] = 0;
		}
		// get pti vta fee
		$pti_vta_fee = $this->api->apiPost($this->userInfo['token'],"Pti_vta_fee/list_pti_fee",[]);
		if (!empty($pti_vta_fee->status) && $pti_vta_fee->status == 200) {
			$this->data['pti_vta_fee'] = $pti_vta_fee->data;
		} else {
			$this->data['pti_vta_fee'] = array();
		}
		//get store
		$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all", array());
		$arr_store = array();
		$store_id ='';
		$this->data['code_domain'] = '';
		if (!empty($storeData->status) && $storeData->status == 200 && !empty($stores)) {
			foreach ($stores as $key => $store) {
				$arr_store += [$key => $store->store_id];
				$store_id=$store->store_id;
			}
			foreach ($storeData->data as $key => $value) {
				if ($value->status != 'active' || !in_array($value->_id->{'$oid'}, $arr_store)) {
					unset($storeData->data[$key]);

				} else {
					$area = $this->api->apiPost($this->userInfo['token'], "area/get_area_by_code", array('code' => $value->code_area));
					if (!empty($area->status) && $area->status == 200) {
						$this->data['code_domain'] = $area->data->domain->code;
					}

				}

			}
			$this->data['stores'] = $storeData->data;
		} else {
			$this->data['stores'] = array();
		}
		//get coupon
		$couponData = $this->api->apiPost($this->userInfo['token'], "coupon/get_all_home", array('created_at' => $contract->data->created_at, 'type_property' => $contract->data->loan_infor->type_property->id, 'type_loan' => $contract->data->loan_infor->type_loan->id, 'number_day_loan' => $contract->data->loan_infor->number_day_loan / 30, 'loan_product' => $contract->data->loan_infor->loan_product->code, 'store_id' => $store_id));
		if (!empty($couponData->status) && $couponData->status == 200) {
			$this->data['couponData'] = $couponData->data;
		} else {
			$this->data['couponData'] = array();
		}
		$list_storage = $this->api->apiPost($this->userInfo['token'], "car_storage/get_all_car_storage");
		if (!empty($list_storage->status) && $list_storage->status == 200) {
			$this->data['list_storage'] = $list_storage->data;
		} else {
			$this->data['list_storage'] = array();
		}

		$list_ctv = $this->api->apiPost($this->userInfo['token'], "collaborator/get_all_collaborator_model");
		if (!empty($list_ctv->status) && $list_ctv->status == 200) {
			$this->data['list_ctv'] = $list_ctv->data;
		} else {
			$this->data['list_ctv'] = array();
		}


		//  var_dump($this->data['stores']); die;
		$this->data['dataInit'] = $dataLoanInfor;
		$this->data["pageName"] = $this->lang->line('add_new_contract');
		$nhom_xe = $this->api->apiPost($this->userInfo['token'], "vbi_tnds/get_danh_muc_xe", ['option' => "NHOM_XE"]);
		$hieu_xe = $this->api->apiPost($this->userInfo['token'], "vbi_tnds/get_danh_muc_xe", ['option' => "HIEU_XE"]);
		$hang_xe = $this->api->apiPost($this->userInfo['token'], "vbi_tnds/get_danh_muc_xe", ['option' => "HANG_XE"]);
		$this->data['nhom_xe'] = $nhom_xe->data;
		$this->data['hieu_xe'] = $hieu_xe->data;
		$this->data['hang_xe'] = $hang_xe->data;
		$nextpay = $this->api->apiPost($this->userInfo['token'], "nextpay/check_group_next_pay", ['user_id'=>$this->userInfo['id']]);
		if (!empty($nextpay->status) && $nextpay->status == 200) {
			$this->data['user_nextpay'] = $nextpay->data;
		}else{
			$this->data['user_nextpay'] = 0;
		}

		//List seri mã định vị
		$listSeri = $this->apiListSeriPositioningDevices();
		$this->data['listSeri'] = $listSeri;

		$this->data['template'] = 'page/pawn/continue_create_contract';
		$this->data['contractInfor'] = $contract->data;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function verifyImageCVS()
	{
		$this->data['template'] = 'template/wizard_verifyimages';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function createContract()
	{

		$this->data["pageName"] = $this->lang->line('add_new_contract');
		//get property main ( tài sản cấp cao nhất parenid == null)
		$this->data['tilekhoanvay'] = 0;
		$config = $this->api->apiPost($this->userInfo['token'], "config_gic/get_config", array('code' => "TN_TNNNV"));
		if (!empty($config->status) && $config->status == 200) {
			$this->data['tilekhoanvay'] = (!empty($config->data->TyLePhi)) ? $config->data->TyLePhi : 0;
		}
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main");
		//  var_dump( $this->data['tilekhoanvay']);die;
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$this->data['mainPropertyData'] = $mainPropertyData->data;
		} else {
			$this->data['mainPropertyData'] = array();
		}
		//get province
		$provinceData = $this->api->apiPost($this->userInfo['token'], "province/get_province");
		if (!empty($provinceData->status) && $provinceData->status == 200) {
			$this->data['provinceData'] = $provinceData->data;
		} else {
			$this->data['provinceData'] = array();
		}

		//get hình thức vay
		$configuration_formality = $this->api->apiPost($this->userInfo['token'], "configuration_formality/get_configuration_formality");
		if (!empty($configuration_formality->status) && $configuration_formality->status == 200) {
			$this->data['configuration_formality'] = $configuration_formality->data;
		} else {
			$this->data['configuration_formality'] = array();
		}
		if (isset($_GET['id_lead'])) {
			$lead_info = $this->api->apiPost($this->user['token'], "lead_admin/get_one", array('id' => $_GET['id_lead']));
			if (!empty($lead_info->status) && $lead_info->status == 200) {
				$this->data['lead_info'] = $lead_info->data;
			} else {
				$this->data['lead_info'] = array();
			}
		}
		$provinceSelected_hk = !empty($this->data['lead_info']->hk_province) ? $this->data['lead_info']->hk_province : '';
		$districtSelected_hk = !empty($this->data['lead_info']->hk_district) ? $this->data['lead_info']->hk_district : '';
		$districtData_hk = $this->api->apiPost($this->userInfo['token'], "province/get_district_by_province", array("id" => $provinceSelected_hk));
		if (!empty($districtData_hk->status) && $districtData_hk->status == 200) {
			$this->data['districtData_hk'] = $districtData_hk->data;
		} else {
			$this->data['districtData_hk'] = array();
		}
		$wardData_hk = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtSelected_hk));
		if (!empty($wardData_hk->status) && $wardData_hk->status == 200) {
			$this->data['wardData_hk'] = $wardData_hk->data;
		} else {
			$this->data['wardData_hk'] = array();
		}
		$fee_id = $this->api->apiPost($this->userInfo['token'], "feeLoanNew/get_all", array());
		if (!empty($fee_id->status) && $fee_id->status == 200) {
			$this->data['fee_data'] = $fee_id->data;
		} else {
			$this->data['fee_data'] = array();
		}
		$provinceSelected_ns = ($this->data['lead_info']->ns_province) ? $this->data['lead_info']->ns_province : '';
		$districtSelected_ns = ($this->data['lead_info']->ns_district) ? $this->data['lead_info']->ns_district : '';
		$districtData_ns = $this->api->apiPost($this->userInfo['token'], "province/get_district_by_province", array("id" => $provinceSelected_ns));
		if (!empty($districtData_ns->status) && $districtData_ns->status == 200) {
			$this->data['districtData_ns'] = $districtData_ns->data;
		} else {
			$this->data['districtData_ns'] = array();
		}
		$wardData_ns = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtSelected_ns));
		if (!empty($wardData_ns->status) && $wardData_ns->status == 200) {
			$this->data['wardData_ns'] = $wardData_ns->data;
		} else {
			$this->data['wardData_ns'] = array();
		}
		//Start init data from màn hình định giá
		$dataGet = $this->input->get();
		//Hình thức vay
		if (!empty($dataGet['finance'])) $dataGet['finance'] = $this->security->xss_clean($dataGet['finance']);
		//Id = Loại tài sản
		if (!empty($dataGet['main'])) $dataGet['main'] = $this->security->xss_clean($dataGet['main']);
		//Id = Tên tài sản
		if (!empty($dataGet['sub'])) $dataGet['sub'] = $this->security->xss_clean($dataGet['sub']);
		if (!empty($dataGet['subName'])) $dataGet['subName'] = $this->security->xss_clean($dataGet['subName']);
		//Khấu hao
		if (!empty($dataGet['minus'])) {
			$data = array(
				"id" => $dataGet['sub']
			);
			$depreciationData = $this->api->apiPost($this->userInfo['token'], "property/get_depreciation_by_property", $data);
			$arrChecked = explode(",", $dataGet['minus']);
			$arrMinus = array();
			foreach ($depreciationData->data as $item) {
				$a = array();
				in_array($item->slug, $arrChecked) == TRUE ? $a['checked'] = 1 : $a['checked'] = 0;
				$a['name'] = $item->name;
				$a['slug'] = $item->slug;
				$a['price'] = $item->price;
				array_push($arrMinus, $a);
			}
		}
		//giá gốc
		if (!empty($dataGet['rootPrice'])) $dataGet['rootPrice'] = $this->security->xss_clean($dataGet['rootPrice']);
		//giá sau sửa
		if (!empty($dataGet['editPrice'])) $dataGet['editPrice'] = $this->security->xss_clean($dataGet['editPrice']);

		$dataInit = array(
			"type_finance" => !empty($dataGet['finance']) ? $dataGet['finance'] : "",
			"main" => !empty($dataGet['main']) ? $dataGet['main'] : "",
			"sub" => !empty($dataGet['sub']) ? $dataGet['sub'] : "",
			"subName" => !empty($dataGet['subName']) ? $dataGet['subName'] : "",
			"minus" => !empty($arrMinus) ? $arrMinus : "",
			"rootPrice" => !empty($dataGet['rootPrice']) ? $dataGet['rootPrice'] : 0,
			"editPrice" => !empty($dataGet['editPrice']) ? $dataGet['editPrice'] : 0
		);
		$this->data['dataInit'] = $dataInit;
		//End init data from màn hình định giá

		//get bank vimo
		// $bankVimoData = $this->api->apiPost($this->userInfo['token'], "BankVimo/get_all");
		// if(!empty($bankVimoData->status) && $bankVimoData->status == 200){
		//     $this->data['bankVimoData'] = $bankVimoData->data;
		// }else{
		//     $this->data['bankVimoData'] = array();
		// }

		//get bank ngan luong
		$bankNganluongData = $this->api->apiPost($this->userInfo['token'], "bankNganLuong/get_all", array("account_type => 3"));
		if (!empty($bankNganluongData->status) && $bankNganluongData->status == 200) {
			$this->data['bankNganluongData'] = $bankNganluongData->data;
		} else {
			$this->data['bankNganluongData'] = array();
		}


		$userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
		$stores = !empty($userInfo['stores']) ? $userInfo['stores'] : array();

		//get store
		$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all", array());

		$arr_store = array();
		$this->data['code_domain'] = '';
		if (!empty($storeData->status) && $storeData->status == 200 && !empty($stores)) {
			foreach ($stores as $key => $store) {
				$arr_store += [$key => $store->store_id];
			}

			foreach ($storeData->data as $key => $value) {
				if ($value->status != 'active' || !in_array($value->_id->{'$oid'}, $arr_store)) {
					unset($storeData->data[$key]);

				} else {
					$area = $this->api->apiPost($this->userInfo['token'], "area/get_area_by_code", array('code' => $value->code_area));
					if (!empty($area->status) && $area->status == 200) {
						$this->data['code_domain'] = $area->data->domain->code;
					}
				}

			}
			$this->data['stores'] = $storeData->data;
		} else {
			$this->data['stores'] = array();
		}

		$storeDataCentral = $this->api->apiPost($this->userInfo['token'], "Store/getAllStoreCentralNoneDirectSales", array());
		if (!empty($storeDataCentral->status) && $storeDataCentral->status == 200) {
			$this->data['storeDataCentral'] = $storeDataCentral->data;
		} else {
			$this->data['storeDataCentral'] = array();
		}
		$id_store_of_user = '';
		if (!empty($this->data['stores'])) {
			foreach ($this->data['stores'] as $key => $sto) {
				if (in_array($sto->_id->{'$oid'}, $this->data['storeDataCentral'])) {
					continue;
				}
				$id_store_of_user = $sto->_id->{'$oid'};
			}
		}
		$store_megadoc = $this->api->apiPost($this->userInfo['token'], "nextpay/check_store_create_contract_digital", ["store_id" => $id_store_of_user]);
		if (!empty($store_megadoc->status) && $store_megadoc->status == 200) {
			$this->data['store_digital'] = $store_megadoc->data;
		} else {
			$this->data['store_digital'] = 0;
		}

		// get pti vta fee
		$pti_vta_fee = $this->api->apiPost($this->userInfo['token'],"Pti_vta_fee/list_pti_fee",[]);
		if (!empty($pti_vta_fee->status) && $pti_vta_fee->status == 200) {
			$this->data['pti_vta_fee'] = $pti_vta_fee->data;
		} else {
			$this->data['pti_vta_fee'] = array();
		}
		//get coupon
		$couponData = $this->api->apiPost($this->userInfo['token'], "coupon/get_all_home");
		if (!empty($couponData->status) && $couponData->status == 200) {
			$this->data['couponData'] = $couponData->data;
		} else {
			$this->data['couponData'] = array();
		}
		$list_storage = $this->api->apiPost($this->userInfo['token'], "car_storage/get_all_car_storage");
		if (!empty($list_storage->status) && $list_storage->status == 200) {
			$this->data['list_storage'] = $list_storage->data;
		} else {
			$this->data['list_storage'] = array();
		}
		$list_ctv = $this->api->apiPost($this->userInfo['token'], "collaborator/get_all_collaborator_model");
		if (!empty($list_ctv->status) && $list_ctv->status == 200) {
			$this->data['list_ctv'] = $list_ctv->data;
		} else {
			$this->data['list_ctv'] = array();
		}
		$nhom_xe = $this->api->apiPost($this->userInfo['token'], "vbi_tnds/get_danh_muc_xe", ['option' => "NHOM_XE"]);
		$hieu_xe = $this->api->apiPost($this->userInfo['token'], "vbi_tnds/get_danh_muc_xe", ['option' => "HIEU_XE"]);
		$hang_xe = $this->api->apiPost($this->userInfo['token'], "vbi_tnds/get_danh_muc_xe", ['option' => "HANG_XE"]);
		$this->data['nhom_xe'] = $nhom_xe->data;
		$this->data['hieu_xe'] = $hieu_xe->data;
		$this->data['hang_xe'] = $hang_xe->data;
		// var_dump($this->data['stores']); die;
		$nextpay = $this->api->apiPost($this->userInfo['token'], "nextpay/check_group_next_pay", ['user_id'=>$this->userInfo['id']]);
		if (!empty($nextpay->status) && $nextpay->status == 200) {
			$this->data['user_nextpay'] = $nextpay->data;
		}else{
			$this->data['user_nextpay'] = 0;
		}

		//List seri mã định vị
		$listSeri = $this->apiListSeriPositioningDevices();
		$this->data['listSeri'] = $listSeri;

		$this->data['template'] = 'page/pawn/new_create_contract';
		// $this->data['template'] = 'page/pawn/create_contract';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	private function isValidEmail($email)
	{
		$email = strtolower($email);
		return filter_var($email, FILTER_VALIDATE_EMAIL)
			&& preg_match('/@.+\./', $email);
	}

	public function validateCreateContract()
	{
		$data = $this->input->post();
		$data['customer_infor'] = $this->security->xss_clean($data['customer_infor']);
		$data['current_address'] = $this->security->xss_clean($data['current_address']);
		$data['houseHold_address'] = $this->security->xss_clean($data['houseHold_address']);
		$data['job_infor'] = $this->security->xss_clean($data['job_infor']);
		$data['relative_infor'] = $this->security->xss_clean($data['relative_infor']);
		$data['loan_infor'] = $this->security->xss_clean($data['loan_infor']);
		$data['receiver_infor'] = $this->security->xss_clean($data['receiver_infor']);
		$data['expertise_infor'] = $this->security->xss_clean($data['expertise_infor']);
		$data['store'] = $this->security->xss_clean($data['store']);
		$data['step'] = $this->security->xss_clean($data['step']);
		$id_store = $data['store']['id'];
		$propertyInfor = array();
		$createAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		if (!empty($data['property_infor'])) $propertyInfor = $this->security->xss_clean($data['property_infor']);
//        var_dump($data);
		$store_digital = $this->api->apiPost($this->userInfo['token'], "nextpay/check_store_create_contract_digital", ['store_id'=> $id_store]);
		if (!empty($store_digital->status) && $store_digital->status == 200) {
			if ($store_digital->data == 1) {
				if (empty($data['customer_infor']['type_contract_sign'])) {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "(Mục Thông tin khách hàng) Loại hợp đồng khách hàng muốn ký không được để trống!")));
					return;
				}
				if (!empty($data['customer_infor']['type_contract_sign']) && $data['customer_infor']['type_contract_sign'] == 1) {
					if (empty($data['customer_infor']['status_email'])) {
						$this->pushJson('200', json_encode(array("code" => "400", "message" => "(Mục Thông tin khách hàng) Chưa chọn hình thức nhận thông báo ký số hợp đồng điện tử!")));
						return;
					}
				}
			}
		}
		if ($data['step'] == 1) {

			if (!empty($data['customer_infor']['passport_number'])) {
				if (empty($data['customer_infor']['passport_address'])) {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Nơi cấp hộ chiếu không được để trống")));
					return;
				}
				if (empty($data['customer_infor']['passport_date'])) {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Ngày cấp hộ chiếu không được để trống")));
					return;
				}

			}
			if (!empty($data['customer_infor']['customer_resources']) && $data['customer_infor']['customer_resources'] == 11) {
				if (empty($data['customer_infor']['presenter_name'])) {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Tên người giới thiệu không được để trống")));
					return;
				}
				if (empty($data['customer_infor']['customer_phone_introduce'])) {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Số điện thoại người giới thiệu không được để trống")));
					return;
				}
				if (!preg_match("/^[0-9]{10,12}$/", $data['customer_infor']['customer_phone_introduce'])) {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Số điện thoại người giới thiệu không đúng định dạng")));
					return;
				}
				if (empty($data['customer_infor']['presenter_bank'])) {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Tên ngân hàng người giới thiệu không được để trống")));
					return;
				}
				if (empty($data['customer_infor']['presenter_stk'])) {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Số tài khoản ngân hàng người giới thiệu không được để trống")));
					return;
				}
				if (empty($data['customer_infor']['presenter_cmt'])) {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Số chứng minh thư người giới thiệu không được để trống")));
					return;
				}
				if (!preg_match("/^[0-9]{9,12}$/", $data['customer_infor']['presenter_cmt'])) {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Số chứng minh thư người giới thiệu không đúng định dạng")));
					return;
				}
				if (empty($data['customer_infor']['img_file_presenter_cmt'])) {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Ảnh chứng minh thư người giới thiệu không được để trống")));
					return;
				}
			}

			//Check null mục thông tin khách hàng
			if (empty($data['customer_infor']) || empty($data['customer_infor']['customer_name'])
				|| empty($data['customer_infor']['customer_name'])
				|| empty($data['customer_infor']['customer_email'])
				|| empty($data['customer_infor']['customer_phone_number'])
				|| empty($data['customer_infor']['customer_identify'])
				|| empty($data['customer_infor']['date_range'])
				|| empty($data['customer_infor']['issued_by'])
				|| empty($data['customer_infor']['customer_BOD'])
				|| empty($data['customer_infor']['marriage'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Điền đầy đủ mục thông tin khách hàng")));
				return;
			}
			if (
				!empty($data['customer_infor']['customer_name']) 
				&& mb_strlen($data['customer_infor']['customer_name'], 'utf8') > 50
			) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Tên khách hàng không được vượt quá 50 ký tự!")));
				return;
			}
			$store_digital = $this->api->apiPost($this->userInfo['token'], "nextpay/check_store_create_contract_digital", ['store_id'=> $id_store]);
			if (!empty($store_digital->status) && $store_digital->status == 200) {
				if ($store_digital->data == 1) {
					if (empty($data['customer_infor']['type_contract_sign'])) {
						$this->pushJson('200', json_encode(array("code" => "400", "message" => "Loại hợp đồng KH muốn ký không được để trống!")));
						return;
					}
					if (!empty($data['customer_infor']['type_contract_sign']) && $data['customer_infor']['type_contract_sign'] == 1) {
						if (empty($data['customer_infor']['status_email'])) {
							$this->pushJson('200', json_encode(array("code" => "400", "message" => "Chưa chọn hình thức nhận thông báo ký số hợp đồng điện tử!")));
							return;
						}
					}
				}
			}
			if (!empty($data['customer_infor']['customer_name']) && strlen($data['customer_infor']['customer_name']) < 5) {

				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Tên khách hàng không được nhỏ hơn 5 ký tự")));
				return;
			}
			//Check null mục địa chỉ đang ở
			if (empty($data['current_address']) || empty($data['current_address']['province'])
				|| empty($data['current_address']['district'])
				|| empty($data['current_address']['ward'])
				|| empty($data['current_address']['form_residence'])
				|| empty($data['current_address']['time_life'])
				|| empty($data['current_address']['current_stay'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Điền đầy đủ mục địa chỉ đang ở")));
				return;
			}
			//Check null mục địa chỉ hộ khẩu
			if (empty($data['houseHold_address']) || empty($data['houseHold_address']['province'])
				|| empty($data['houseHold_address']['district'])
				|| empty($data['houseHold_address']['ward'])
				|| empty($data['houseHold_address']['address_household'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Điền đầy đủ mục địa chỉ hộ khẩu")));
				return;
			}
			// validate
			if (!$this->isValidEmail($data['customer_infor']['customer_email'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => $this->lang->line('invalid_email'))));
				return;
			}

			if (!preg_match("/^[0-9]{9,12}$/", $data['customer_infor']['customer_identify'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "CMND/CCCD hiện tại không đúng định dạng")));
				return;
			}

			if (!empty($data['customer_infor']['customer_identify_old']) && !preg_match("/^[0-9]{9,12}$/", $data['customer_infor']['customer_identify_old'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "CMND/CCCD cũ không đúng định dạng")));
				return;
			}

			if (!preg_match("/^[0-9]{10,12}$/", $data['customer_infor']['customer_phone_number'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format'))));
				return;
			}

			if (!empty($data['customer_infor']['date_range']) && strtotime($data['customer_infor']['date_range']) > $createAt) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Ngày cấp CMND/CCCD không hợp lệ!")));
				return;
			}

		}

		if ($data['step'] == 2) {
			//Check null mục Thông tin việc làm
			if (empty($data['job_infor']) || empty($data['job_infor']['phone_number_company'])
				|| empty($data['job_infor']['job_position'])
				|| empty($data['job_infor']['work_year'])
				|| empty($data['job_infor']['name_company'])
				|| empty($data['job_infor']['address_company'])
				|| empty($data['job_infor']['salary'])
				|| empty($data['job_infor']['receive_salary_via'])) {
				// var_dump($data['job_infor']['phone_number_company']);
				// var_dump($data['job_infor']['job_position']);
				// var_dump($data['job_infor']['name_company']);
				// var_dump($data['job_infor']['address_company']);
				// var_dump($data['job_infor']['salary']);
				// var_dump($data['job_infor']['receive_salary_via']);


				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Điền đầy đủ mục thông tin việc làm")));
				return;
			}
		}
		if ($data['step'] == 3) {
			//Check null mục Thông tin người thân
			if (empty($data['relative_infor']) || empty($data['relative_infor']['type_relative_1'])
				|| empty($data['relative_infor']['fullname_relative_1'])
				|| empty($data['relative_infor']['phone_number_relative_1'])
				|| empty($data['relative_infor']['loan_security_1'])
				|| empty($data['relative_infor']['hoursehold_relative_1'])
				|| empty($data['relative_infor']['confirm_relativeInfor_1'])
				|| empty($data['relative_infor']['type_relative_2'])
				|| empty($data['relative_infor']['fullname_relative_2'])
				|| empty($data['relative_infor']['phone_number_relative_2'])
				|| empty($data['relative_infor']['loan_security_2'])
				|| empty($data['relative_infor']['hoursehold_relative_2'])
				|| empty($data['relative_infor']['confirm_relativeInfor_2'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Điền đầy đủ mục thông tin người thân")));
				return;

			}
			if (!preg_match("/^[0-9]{10,12}$/", $data['relative_infor']['phone_number_relative_1'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format'))));
				return;
			}
			if (!preg_match("/^[0-9]{10,12}$/", $data['relative_infor']['phone_number_relative_2'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format'))));
				return;
			}
			if (!empty($data['relative_infor']['phone_relative_3'])) {
				if (!preg_match("/^[0-9]{10,12}$/", $data['relative_infor']['phone_relative_3'])) {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format'))));
					return;
				}
			}
			//Validate SĐT tham chiếu không hợp lệ nếu là SĐT của nhân viên VFC
			$response = $this->check_phone_relative($data['relative_infor']['phone_number_relative_1'], $data['relative_infor']['phone_number_relative_2'], $data['relative_infor']['phone_relative_3']);
			if (!empty($response['status']) && $response['status'] == 200) {
				return $this->pushJson(200, json_encode($response));
			}
			//Validate bảo mật khoản vay
			if (!empty($data['relative_infor']['fullname_relative_3']) || !empty($data['relative_infor']['address_relative_3']) || !empty($data['relative_infor']['phone_relative_3'])) {
				if (empty($data['relative_infor']['loan_security_3'])) {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Điền đầy đủ mục thông tin người thân - Bảo mật tham chiếu 3")));
					return;
				}
			}

		}


		if ($data['step'] == 4) {
			//Check null mục Thông tin khoản vay
			if (empty($data['loan_infor']) || empty($data['loan_infor'])
				|| empty($data['loan_infor']['type_property'])
				|| empty($data['loan_infor']['name_property'])
				|| empty($data['loan_infor']['price_property'])
				|| empty($data['loan_infor']['amount_money'])
				|| empty($data['loan_infor']['number_day_loan'])
				|| empty($data['loan_infor']['type_interest'])
				|| empty($data['loan_infor']['insurrance_contract'])
				|| empty($data['loan_infor']['loan_purpose'])
				|| empty($data['loan_infor']['loan_product'])
				|| empty($data['loan_infor']['period_pay_interest'])
				|| empty($data['loan_infor']['loan_product']['code'])
			) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Điền đầy đủ mục thông tin khoản vay")));
				return;
			}
			//Check hiệu lực BH GIC Easy
			if (!empty($data['loan_infor']['code_GIC_easy']) && $data['loan_infor']['amount_GIC_easy'] > 0) {
				if ($data['property_infor'][2]['slug'] == 'bien-so-xe' && $data['property_infor'][3]['slug'] == 'so-khung') {
					$dataSendApi = [
						'bien_so_xe' => $data['property_infor'][2]['value'] ?? '',
						'so_khung' => $data['property_infor'][3]['value'] ?? ''
					];
					$response = $this->api->apiPost($this->userInfo['token'],'Contract/checkExistGicEasy', $dataSendApi);
					if (!empty($response) && $response->status == 200) {
						if ($response->data->is_exists_insurance_remain_effect == true) {
							$this->pushJson('200', json_encode(array("code" => "200", "flag_gic" => 1, "data" => $response->data->code_contract_disbursement)));
							return;
						}
					}
				}
			}
			if (!empty($data['loan_infor']['maVBI_1']) && !empty($data['loan_infor']['maVBI_2']) && $data['loan_infor']['maVBI_1'] != "NaN" && $data['loan_infor']['maVBI_2'] != "NaN"){
				if ($data['loan_infor']['maVBI_1'] <= 6 && $data['loan_infor']['maVBI_2'] <= 6){
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Không chọn 2 gói bảo hiểm SXH")));
					return;
				}
				if ($data['customer_infor']['customer_gender'] == 2){
					if ($data['loan_infor']['maVBI_1'] > 6 && $data['loan_infor']['maVBI_2'] > 6){
						$this->pushJson('200', json_encode(array("code" => "400", "message" => "Không chọn 2 gói bảo hiểm UTV")));
						return;
					}
				} else {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Giới tính nữ mới mua được bảo hiểm UTV")));
					return;
				}
			}

			if ((!empty($data['loan_infor']['maVBI_1']) && $data['loan_infor']['maVBI_1'] > 6)){
				if ($data['customer_infor']['customer_gender'] == 1){
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Giới tính nữ mới mua được bảo hiểm UTV")));
					return;
				}
			}

			if ($data['receiver_infor']['amount'] > 5000000 && $data['loan_infor']['loan_product']['code'] == "18") {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Số tiền vay tối đa 5.000.000 vnđ")));
				return;
			}


			if ($data['loan_infor']['loan_product']['code'] == "14") {
				if (empty($data['loan_infor']['link_shop'])) {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Link shop online không được để trống")));
					return;
				}
			}
			if (!empty($data['loan_infor']['amount_money']) && !empty($data['loan_infor']['amount_money_max'])) {
				if ((int)$data['loan_infor']['amount_money'] > (int)$data['loan_infor']['amount_money_max']) {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Số tiền vay lớn hơn mức quy định")));
					return;
				}
			}

			if ($data['loan_infor']['insurrance_contract'] == 1 && empty($data['loan_infor']['loan_insurance'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Điền đầy đủ mục thông tin khoản vay")));
				return;
			}
			//validate PTI BHTN
			if (empty($data['loan_infor']['pti_bhtn'])) {
				$ptiBHTN = $this->api->apiPost($this->user['token'], "contract/validatePtiBHTNCN", [
					'amount_money' => $data['loan_infor']['amount_money'],
					'customer_identify' => $data['customer_infor']['customer_identify']
				]);
		        if (!empty($ptiBHTN->status) && $ptiBHTN->status == 200) {
		         	// do nothing
		        }else{
		        	$message = "Mục PTI - BHTN bắt buộc cho khoản vay trên 7tr";
		        	if (!empty($ptiBHTN->message)) {
		        		$message = $ptiBHTN->message;
		        	}
		        	$this->pushJson('200', json_encode([
		        		"status" => "400", 
		        		'message' => $message, 
		        		'data' => $ptiBHTN
		        	]));
		        	return;
		        }
		    }
			if ($data['loan_infor']['insurrance_contract'] == 1 && !empty($data['loan_infor']['loan_insurance'])) {
				if ($data['loan_infor']['loan_insurance'] == 1 && $data['loan_infor']['amount_GIC'] > 0) {
					if ($this->validateAge($data['customer_infor']['customer_BOD'], 18, 64) == "FALSE" && $data['loan_infor']['insurrance_contract'] == 1) {
						$this->pushJson('200', json_encode(array("code" => "400", "message" => "Khách hàng đăng ký bảo hiểm khoản vay GIC phải lớn hơn 18 tuổi và <= 65 tuổi")));
						return;
					}
				}
				if ($data['loan_infor']['loan_insurance'] == 2 && $data['loan_infor']['amount_MIC'] > 0) {
					if ($this->validateAge($data['customer_infor']['customer_BOD'], 18, 59) == "FALSE" && $data['loan_infor']['insurrance_contract'] == 1) {
						$this->pushJson('200', json_encode(array("code" => "400", "message" => "Khách hàng đăng ký bảo hiểm khoản vay MIC phải lớn hơn 18 tuổi và <= 60 tuổi")));
						return;
					}
				}
				if ($data['loan_infor']['amount_GIC_plt'] > 0) {
					if ($this->validateAge($data['customer_infor']['customer_BOD'], 18, 59) == "FALSE") {
						$this->pushJson('200', json_encode(array("code" => "400", "message" => "Độ tuổi áp dụng bảo hiểm phúc lộc thọ từ 18 đến 60 tuổi")));
						return;
					}

				}
				if ($data['loan_infor']['loan_insurance'] == 1 && $data['loan_infor']['amount_GIC'] <= 0) {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Điền đầy đủ mục thông tin khoản vay")));
					return;

				}
				if ($data['loan_infor']['loan_insurance'] == 2 && $data['loan_infor']['amount_MIC'] <= 0) {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Điền đầy đủ mục thông tin khoản vay")));
					return;
				}
				if ($data['loan_infor']['loan_insurance'] == 2 && $data['loan_infor']['amount_money'] < 3000000) {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Số tiền vay nhỏ hơn 03 triệu, không đủ điều kiện tạo BH MIC khoản vay!")));
					return;
				}


			}
			//validate BH GIC PLT theo do tuoi, khi khach ko dang ky bao hiem khoan vay
			if ($data['loan_infor']['amount_GIC_plt'] > 0) {
				if ($this->validateAge($data['customer_infor']['customer_BOD'], 18, 59) == "FALSE") {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Độ tuổi áp dụng bảo hiểm phúc lộc thọ từ 18 đến 60 tuổi")));
					return;
				}

			}
			if ($data['loan_infor']['type_property']['code'] == 'XM' || $data['loan_infor']['type_property']['code'] == 'OTO') {
				if ($data['loan_infor']['image_property']['image_front'] === 'https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png'
					|| $data['loan_infor']['image_property']['image_back'] === 'https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png') {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Ảnh đăng kí xe đang trống!")));
					return;
				}
			}
			if ($data['loan_infor']['type_property']['code'] == 'XM') {
				if (!empty($data['loan_infor']['bao_hiem_tnds'])) {
					if ($data['loan_infor']['bao_hiem_tnds']['type_tnds'] == 'VBI_TNDS') {
						$this->pushJson('200', json_encode(array("code" => "400", "message" => "Bảo hiểm trách nhiệm dân sự không đúng!")));
						return;
					}
				}
			}

			if ($data['loan_infor']['type_property']['code'] == 'OTO') {
				if (!empty($data['loan_infor']['bao_hiem_tnds'])) {
					if ($data['loan_infor']['bao_hiem_tnds']['type_tnds'] == 'MIC_TNDS') {
						$this->pushJson('200', json_encode(array("code" => "400", "message" => "Bảo hiểm trách nhiệm dân sự không đúng!")));
						return;
					}
				}
				if (empty($data['loan_infor']['gan_dinh_vi'])) {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Điền mục gắn định vị!")));
					return;
				}
				if ($data['loan_infor']['type_loan']['code'] == 'CC') {
					if (empty($data['loan_infor']['o_to_ngan_hang'])) {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Điền mục ô tô ngân hàng!")));
					return;
				   }
			    }
			}

			//Validate Seri Định Vị
			if ($data['loan_infor']['loan_product']['code'] == 19) {
				if (empty($data['loan_infor']['device_asset_location']['device_asset_location_id'])) {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Mã Seri Định Vị Không Được Để Trống")));
					return;
				}
				$check_status_device = $this->api->apiPost($this->userInfo['token'], "contract/check_status_device", ['device_asset_location_id' => $data['loan_infor']['device_asset_location']['device_asset_location_id']]);
				if(!empty($check_status_device) && $check_status_device->status != 200){
					$this->pushJson('200', json_encode(array("code" => "400", "message" => $check_status_device->message)));
					return;
				}

			} else {
				if(!empty($data['loan_infor']['device_asset_location']['device_asset_location_id'])){
					$check_status_device = $this->api->apiPost($this->userInfo['token'], "contract/check_status_device", ['device_asset_location_id' => $data['loan_infor']['device_asset_location']['device_asset_location_id']]);
					if(!empty($check_status_device) && $check_status_device->status != 200){
						$this->pushJson('200', json_encode(array("code" => "400", "message" => $check_status_device->message)));
						return;
					}
				}
			}


			//Check null mục Thông tin tài sản
			$res = array(
				"code" => "200",
				"data" => ""
			);
			if (!empty($data['property_infor'])) {
				foreach ($data['property_infor'] as $item) {
						if ($item['value']== "") {
								$res = array(
									"code" => "400",
									"message" => "Điền đầy đủ mục thông tin tài sản"
								);
							break;
						}

					if (!empty($item['value']) && $item['slug'] == 'so-khung' && strlen($item['value']) < 6) {
						$res = array(
							"code" => "400",
							"message" => "Số khung không được nhỏ hơn 7 ký tự"
						);

						break;
					}
					if (!empty($item['value']) && $item['slug'] == 'so-may' && strlen($item['value']) < 6) {
						$res = array(
							"code" => "400",
							"message" => "Số máy không được nhỏ hơn 7 ký tự"
						);

						break;
					}
					if (!empty($item['value']) && $item['slug'] == 'bien-so-xe' && strlen($item['value']) < 7) {
						$res = array(
							"code" => "400",
							"message" => "Biển số xe không được nhỏ hơn 7 ký tự"
						);

						break;
					}
					if ($item['slug'] == 'bien-so-xe') {
						$check = $this->checkProperty($item['value']);
						if (!empty($check)) {
							$res = array(
								"status" => 2,
								"message" => "Hợp đồng đang vay đã tồn tại biển số xe"
							);
							break;
						}
					}
					if ($item['slug'] == 'ngay-cap') {
						if (strtotime($item['value']) > $createAt) {
							$res = array(
								"code" => "400",
								"message" => "Ngày cấp đăng kí xe không hợp lệ!"
							);
							break;
						}
					}
					if ($item['slug'] == 'so-dang-ky') {
						if (!preg_match("/^[0-9]{6,7}$/", $item['value'])) {
							$res = array(
								"code" => "400",
								"message" => "Số đăng ký xe không hợp lệ!"
							);
							break;
						}
					}
					if ($item['slug'] == 'dien-tich-m2') {
						if (!preg_match("/^[0-9.,]*$/", $item['value'])) {
							$res = array(
								"code" => "400",
								"message" => "Diện tích phải là dạng số"
							);
							break;
						}
					}
					if ($item['slug'] == 'hinh-thuc-su-dung-rieng-m2') {
						if (!preg_match("/^[0-9.,]*$/", $item['value'])) {
							$res = array(
								"code" => "400",
								"message" => "Hình thức sử dụng riêng phải là dạng số"
							);
							break;
						}
					}
//					if ($item['slug'] == 'hinh-thuc-su-dung-chung-m2') {
//						if (!preg_match("/^[0-9.,]*$/", $item['value'])) {
//							$res = array(
//								"code" => "400",
//								"message" => "Hình thức sử dụng chung phải là dạng số"
//							);
//							break;
//						}
//					}
				}
				$this->pushJson('200', json_encode($res));
				return;
			}
//			else {
//				$res = array(
//					"code" => "400",
//					"message" => "Điền đầy đủ mục thông tin tài sản"
//				);
//				$this->pushJson('200', json_encode($res));
//				return;
//			}
		}


		if ($data['step'] == 5) {

			//Check null mục thông tin chuyển khoản
			if (empty($data['receiver_infor']) || empty($data['receiver_infor']['type_payout'])
				|| empty($data['receiver_infor']['amount'])
				|| empty($data['receiver_infor']['bank_id'])) {
				$res = array(
					"status" => 2,
					"message" => "Điền đầy đủ mục thông tin giải ngân"
				);
				$this->pushJson('200', json_encode($res));
				return;
			}
			if (!empty($data['receiver_infor']['type_payout'])) {
				if ($data['receiver_infor']['type_payout'] == 2 && (empty($data['receiver_infor']['bank_account']) || empty($data['receiver_infor']['bank_account_holder']) || empty($data['receiver_infor']['bank_branch']))) {
					$res = array(
						"status" => 2,
						"message" => "Điền đầy đủ mục thông tin giải ngân"
					);
					$this->pushJson('200', json_encode($res));
					return;
				}
				if ($data['receiver_infor']['type_payout'] == 3 && (empty($data['receiver_infor']['atm_card_number']) || empty($data['receiver_infor']['atm_card_holder']))) {
					$res = array(
						"status" => 2,
						"message" => "Điền đầy đủ mục thông tin giải ngân"
					);
					$this->pushJson('200', json_encode($res));
					return;
				}
			}

			//Check null mục thông tin phong giao dich
			if (empty($data['store']) || empty($data['store']['id'])
				|| empty($data['store']['name'])
				|| empty($data['store']['address'])) {
				$res = array(
					"status" => 2,
					"message" => "Điền đầy đủ mục thông tin phòng giao dịch"
				);
				$this->pushJson('200', json_encode($res));
				return;
			}
			if ($data['loan_infor']['loan_product']['code'] == 19) {
				if(!empty($check_status_device) && $check_status_device->status == 200){
					if ($check_status_device->data->warehouse_asset_location->store_id != $data['store']['id'])
						$this->pushJson('200', json_encode(array("code" => "400", "message" => "Thiết bị không nằm trong PGD")));
					return;
				}

			}

		}

		$this->pushJson('200', json_encode(array("code" => "200", "data" => '')));
		return;

	}

	private function checkProperty($infor)
	{
		$sendApi = array(
			"infor" => $infor,
		);
		$return = $this->api->apiPost($this->user['token'], "contract/check_property", $sendApi);
		if (!empty($return->status) && $return->status == 200) {
			return $return->data;
		} else {
			return array();
		}
	}

	public function saveContract()
	{
		$data = $this->input->post();
		$data['customer_infor'] = $this->security->xss_clean($data['customer_infor']);
		// var_dump($data['customer_infor']['customer_phone_number']);die;
		$data['current_address'] = $this->security->xss_clean($data['current_address']);
		$data['houseHold_address'] = $this->security->xss_clean($data['houseHold_address']);
		$data['job_infor'] = $this->security->xss_clean($data['job_infor']);
		$data['relative_infor'] = $this->security->xss_clean($data['relative_infor']);
		$data['loan_infor'] = $this->security->xss_clean($data['loan_infor']);
		$data['receiver_infor'] = $this->security->xss_clean($data['receiver_infor']);
		$data['expertise_infor'] = $this->security->xss_clean($data['expertise_infor']);
		$data['store'] = $this->security->xss_clean($data['store']);
		$data['step'] = $this->security->xss_clean($data['step']);
		$data['data_Face_search'] = $this->security->xss_clean($data['data_Face_search']);
		$data['data_Face_Identify'] = $this->security->xss_clean($data['data_Face_Identify']);
		$propertyInfor = array();
		if (!empty($data['property_infor'])) $propertyInfor = $this->security->xss_clean($data['property_infor']);
		// validate

//		if ($data['step'] == 1) {
			//Check null mục thông tin khách hàng
			if (empty($data['customer_infor']) || empty($data['customer_infor']['customer_name'])
				|| empty($data['customer_infor']['customer_name'])
				|| empty($data['customer_infor']['customer_email'])
				|| empty($data['customer_infor']['customer_phone_number'])
				|| empty($data['customer_infor']['customer_identify'])
				|| empty($data['customer_infor']['customer_BOD'])
				|| empty($data['customer_infor']['marriage'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => 'Điền đầy đủ mục thông tin khách hàng')));
				return;
			}

			if (!$this->isValidEmail($data['customer_infor']['customer_email'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => $this->lang->line('invalid_email'))));
				return;
			}
			if (!preg_match("/^[0-9]{9,12}$/", $data['customer_infor']['customer_identify'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "CMND/CCCD hiện tại không đúng định dạng")));
				return;
			}

			if (!preg_match("/^[0-9]{10,12}$/", $data['customer_infor']['customer_phone_number'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format'))));
				return;
			}
//		}
		if (!$this->isValidEmail($data['customer_infor']['customer_email'])) {
			$this->pushJson('200', json_encode(array("code" => "400", "message" => $this->lang->line('invalid_email'))));
			return;
		}

		if (!preg_match("/^[0-9]{10,12}$/", $data['customer_infor']['customer_phone_number'])) {


			$this->pushJson('200', json_encode(array("code" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format'))));
			return;
		}
		if (!empty($data['relative_infor']['phone_number_relative_1'])) {
			if (!preg_match("/^[0-9]{10,12}$/", $data['relative_infor']['phone_number_relative_1'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format'))));
				return;
			}
		}
		if (!empty($data['relative_infor']['phone_number_relative_2'])) {
			if (!preg_match("/^[0-9]{10,12}$/", $data['relative_infor']['phone_number_relative_2'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format'))));
				return;
			}
		}
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$groupRole = $groupRoles->data;
		} else {
			$groupRole = array();
		}
		if (!in_array('hoi-so', $groupRole))
			if (!empty($data['loan_infor']['amount_money']) && !empty($data['loan_infor']['amount_money_max'])) {
				if ((int)$data['loan_infor']['amount_money'] > (int)$data['loan_infor']['amount_money_max']) {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Số tiền vay lớn hơn mức quy định")));
					return;
				}
			}

		if ($data['loan_infor']['type_property']['code'] == 'XM') {
			if (!empty($data['loan_infor']['bao_hiem_tnds'])) {
				if ($data['loan_infor']['bao_hiem_tnds']['type_tnds'] == 'VBI_TNDS') {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Bảo hiểm trách nhiệm dân sự không đúng!")));
					return;
				}
			}
		}

		if ($data['loan_infor']['type_property']['code'] == 'OTO') {
			if (!empty($data['loan_infor']['bao_hiem_tnds'])) {
				if ($data['loan_infor']['bao_hiem_tnds']['type_tnds'] == 'MIC_TNDS') {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Bảo hiểm trách nhiệm dân sự không đúng!")));
					return;
				}
			}
			
		}
		if (isset($data['loan_infor']['amount_loan'])) {
			if ($data['loan_infor']['amount_loan'] > 300000000) {
				$data['info_disbursement_max'] = divide_amount_money($data['loan_infor']['amount_loan']);
				$data['status_disbursement_max'] = 1;
			}
		}

		if ($data['loan_infor']['type_property']['code'] == 'XM' || $data['loan_infor']['type_property']['code'] == 'OTO') {
			if ($data['loan_infor']['image_property']['image_front'] === 'https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png'
				|| $data['loan_infor']['image_property']['image_back'] === 'https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png') {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Ảnh đăng kí xe đang trống!")));
				return;
			}
		}
		if ($data['loan_infor']['type_loan']['code'] == 'CC') {
					$data['loan_infor']['number_day_loan']=30;
			    }
		if ($data['loan_infor']['number_day_loan']==30)
		{
			$data['loan_infor']['type_interest']=2;
		}
		//validate PTI BHTN
		if (empty($data['loan_infor']['pti_bhtn'])) {
			$ptiBHTN = $this->api->apiPost($this->user['token'], "contract/validatePtiBHTNCN", [
				'amount_money' => $data['loan_infor']['amount_money'],
				'customer_identify' => $data['customer_infor']['customer_identify']
			]);
	        if (!empty($ptiBHTN->status) && $ptiBHTN->status == 200) {
	         	// do nothing
	        }else{
	        	$message = "Mục PTI - BHTN bắt buộc cho khoản vay trên 7tr";
	        	if (!empty($ptiBHTN->message)) {
	        		$message = $ptiBHTN->message;
	        	}
	        	$this->pushJson('200', json_encode([
	        		"status" => "400", 
	        		'message' => $message, 
	        		'data' => $ptiBHTN
	        	]));
	        	return;
	        }
	    }
		if ($data['loan_infor']['loan_insurance'] == 2 && $data['loan_infor']['amount_money'] < 3000000) {
			$this->pushJson('200', json_encode(array("code" => "400", "message" => "Số tiền vay nhỏ hơn 03 triệu, không đủ điều kiện tạo BH MIC khoản vay!")));
			return;
		}


		// end
		$sendApi = array(
			'customer_infor' => $data['customer_infor'],
			'current_address' => $data['current_address'],
			'houseHold_address' => $data['houseHold_address'],
			'job_infor' => $data['job_infor'],
			'relative_infor' => $data['relative_infor'],
			'loan_infor' => $data['loan_infor'],
			'property_infor' => $propertyInfor,
			'receiver_infor' => $data['receiver_infor'],
			'expertise_infor' => $data['expertise_infor'],
			'info_disbursement_max' => $data['info_disbursement_max'],
			'status_disbursement_max' => $data['status_disbursement_max'],
			'store' => $data['store'],
			'step' => $data['step'],
			'data_Face_search' => $data['data_Face_search'],
			'data_Face_Identify' => $data['data_Face_Identify'],
			"created_at" => $this->createdAt,
			"created_by" => $this->user['email'],
		);

		$return = $this->api->apiPost($this->user['token'], "contract/process_save_contract", $sendApi);

		$this->api->apiPost($this->user['token'], "company_storage/create_company_storage", $sendApi);
         
         	$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
       
		
	}

	public function processCreateContract()
	{
		$data = $this->input->post();
		$data['customer_infor'] = $this->security->xss_clean($data['customer_infor']);
		// var_dump($data['customer_infor']['customer_phone_number']);die;
		$data['current_address'] = $this->security->xss_clean($data['current_address']);
		$data['houseHold_address'] = $this->security->xss_clean($data['houseHold_address']);
		$data['job_infor'] = $this->security->xss_clean($data['job_infor']);
		$data['relative_infor'] = $this->security->xss_clean($data['relative_infor']);
		$data['loan_infor'] = $this->security->xss_clean($data['loan_infor']);
		$data['receiver_infor'] = $this->security->xss_clean($data['receiver_infor']);
		$data['expertise_infor'] = $this->security->xss_clean($data['expertise_infor']);
		$data['store'] = $this->security->xss_clean($data['store']);
		$data['data_Face_search'] = $this->security->xss_clean($data['data_Face_search']);
		$data['data_Face_Identify'] = $this->security->xss_clean($data['data_Face_Identify']);
		$id_store = $data['store']['id'];
		$propertyInfor = array();
		if (!empty($data['property_infor'])) $propertyInfor = $this->security->xss_clean($data['property_infor']);

		if (empty($data['customer_infor']) || empty($data['customer_infor']['customer_name'])
			|| empty($data['customer_infor']['customer_name'])
			|| empty($data['customer_infor']['customer_email'])
			|| empty($data['customer_infor']['customer_phone_number'])
			|| empty($data['customer_infor']['customer_identify'])
			|| empty($data['customer_infor']['date_range'])
			|| empty($data['customer_infor']['issued_by'])
			|| empty($data['customer_infor']['customer_BOD'])
			|| empty($data['customer_infor']['marriage'])) {
			$this->pushJson('200', json_encode(array("code" => "400", "message" => "Điền đầy đủ mục thông tin khách hàng")));
			return;
		}
		if (
			!empty($data['customer_infor']['customer_name']) 
			&& mb_strlen($data['customer_infor']['customer_name'], 'utf8') > 50
		) {
			$this->pushJson('200', json_encode(array("code" => "400", "message" => "Tên khách hàng không được vượt quá 50 ký tự!")));
			return;
		}
		$store_digital = $this->api->apiPost($this->userInfo['token'], "nextpay/check_store_create_contract_digital", ['store_id'=> $id_store]);
		if (!empty($store_digital->status) && $store_digital->status == 200) {
			if ($store_digital->data == 1) {
				if (empty($data['customer_infor']['type_contract_sign'])) {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "(Mục Thông tin khách hàng) Loại hợp đồng KH muốn ký không được để trống!")));
					return;
				}
				if (!empty($data['customer_infor']['type_contract_sign']) && $data['customer_infor']['type_contract_sign'] == 1) {
					if (empty($data['customer_infor']['status_email'])) {
						$this->pushJson('200', json_encode(array("code" => "400", "message" => "(Mục Thông tin khách hàng) Chưa chọn hình thức nhận thông báo ký số hợp đồng điện tử!")));
						return;
					}
				}
			}
		}

		if ($data['receiver_infor']['amount'] > 5000000 && $data['loan_infor']['loan_product']['code'] == "18") {
			$this->pushJson('200', json_encode(array("code" => "400", "message" => "Số tiền vay tối đa 5.000.000 vnđ")));
			return;
		}

		// validate
		if (!$this->isValidEmail($data['customer_infor']['customer_email'])) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $this->lang->line('invalid_email')))));
			return;
		}

		if (!empty($data['loan_infor']['maVBI_1']) && !empty($data['loan_infor']['maVBI_2']) && $data['loan_infor']['maVBI_1'] != "NaN" && $data['loan_infor']['maVBI_2'] != "NaN"){
			if ($data['loan_infor']['maVBI_1'] <= 6 && $data['loan_infor']['maVBI_2'] <= 6){
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Không chọn 2 gói bảo hiểm SXH")));
				return;
			}
			if ($data['customer_infor']['customer_gender'] == 2){
				if ($data['loan_infor']['maVBI_1'] > 6 && $data['loan_infor']['maVBI_2'] > 6){
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Không chọn 2 gói bảo hiểm UTV")));
					return;
				}
			} else {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Giới tính nữ mới mua được bảo hiểm UTV")));
				return;
			}

		}
		if ((!empty($data['loan_infor']['maVBI_1']) && $data['loan_infor']['maVBI_1'] > 6)){
			if ($data['customer_infor']['customer_gender'] == 1){
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Giới tính nữ mới mua được bảo hiểm UTV")));
				return;
			}
		}

		if ($data['loan_infor']['loan_product']['code'] == "14") {
			if (empty($data['loan_infor']['link_shop'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Link shop online không được để trống")));
				return;
			}
		}


		if (!preg_match("/^[0-9]{9,12}$/", $data['customer_infor']['customer_identify'])) {
			$this->pushJson('200', json_encode(array("code" => "400", "message" => "CMND/CCCD hiện tại không đúng định dạng")));
			return;
		}

		if (!empty($data['customer_infor']['passport_number'])) {
			if (empty($data['customer_infor']['passport_address'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Nơi cấp hộ chiếu không được để trống")));
				return;
			}
			if (empty($data['customer_infor']['passport_date'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Ngày cấp hộ chiếu không được để trống")));
				return;
			}

		}

		if (!preg_match("/^[0-9]{10,12}$/", $data['customer_infor']['customer_phone_number'])) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format')))));
			return;
		}

		if (!preg_match("/^[0-9]{10,12}$/", $data['relative_infor']['phone_number_relative_1'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format'))));
			return;
		}
		if (!preg_match("/^[0-9]{10,12}$/", $data['relative_infor']['phone_number_relative_2'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format'))));
			return;
		}
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$groupRole = $groupRoles->data;
		} else {
			$groupRole = array();
		}
		if (!in_array('hoi-so', $groupRole))
			if ((int)$data['loan_infor']['amount_money'] > (int)$data['loan_infor']['amount_money_max']) {
				$this->pushJson('200', json_encode(array("status" => "400", "message" => "Số tiền vay lớn hơn mức quy định")));
				return;
			}


		if ($data['loan_infor']['insurrance_contract'] == 1 && empty($data['loan_infor']['loan_insurance'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "message" => "Điền đầy đủ mục thông tin khoản vay")));
			return;
		}
		if ($data['loan_infor']['type_property']['code'] == 'XM') {
			if (!empty($data['loan_infor']['bao_hiem_tnds'])) {
				if ($data['loan_infor']['bao_hiem_tnds']['type_tnds'] == 'VBI_TNDS') {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Bảo hiểm trách nhiệm dân sự không đúng!")));
					return;
				}
			}
		}

		if ($data['loan_infor']['type_property']['code'] == 'OTO') {
			if (!empty($data['loan_infor']['bao_hiem_tnds'])) {
				if ($data['loan_infor']['bao_hiem_tnds']['type_tnds'] == 'MIC_TNDS') {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Bảo hiểm trách nhiệm dân sự không đúng!")));
					return;
				}
			}
			if (empty($data['loan_infor']['gan_dinh_vi'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Điền mục gắn định vị!")));
				return;

			}
		}
		if (isset($data['loan_infor']['amount_loan'])) {
			if ($data['loan_infor']['amount_loan'] > 300000000) {
				$data['info_disbursement_max'] = divide_amount_money($data['loan_infor']['amount_loan']);
				$data['status_disbursement_max'] = 1;
			}
		}

		if ($data['loan_infor']['type_property']['code'] == 'XM' || $data['loan_infor']['type_property']['code'] == 'OTO') {
			if ($data['loan_infor']['image_property']['image_front'] === 'https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png'
				|| $data['loan_infor']['image_property']['image_back'] === 'https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png') {
				$this->pushJson('200', json_encode( ['status' => '400', "message" => "Ảnh đăng kí xe đang trống!"]));
				return;
			}
		}
		if ($data['loan_infor']['type_loan']['code'] == 'CC') {
					$data['loan_infor']['number_day_loan']=30;
			    }
		if ($data['loan_infor']['number_day_loan']==30)
		{
			$data['loan_infor']['type_interest']=2;
		}
		//validate PTI BHTN
		if (empty($data['loan_infor']['pti_bhtn'])) {
			$ptiBHTN = $this->api->apiPost($this->user['token'], "contract/validatePtiBHTNCN", [
				'amount_money' => $data['loan_infor']['amount_money'],
				'customer_identify' => $data['customer_infor']['customer_identify']
			]);
	        if (!empty($ptiBHTN->status) && $ptiBHTN->status == 200) {
	         	// do nothing
	        }else{
	        	$message = "Mục PTI - BHTN bắt buộc cho khoản vay trên 7tr";
	        	if (!empty($ptiBHTN->message)) {
	        		$message = $ptiBHTN->message;
	        	}
	        	$this->pushJson('200', json_encode([
	        		"status" => "400", 
	        		'message' => $message, 
	        		'data' => $ptiBHTN
	        	]));
	        	return;
	        }
	    }
		if ($data['loan_infor']['loan_insurance'] == 2 && $data['loan_infor']['amount_money'] < 3000000) {
			$this->pushJson('200', json_encode(array("code" => "400", "message" => "Số tiền vay nhỏ hơn 03 triệu, không đủ điều kiện tạo BH MIC khoản vay!")));
			return;
		}

		//Validate Seri Định Vị
		if ($data['loan_infor']['loan_product']['code'] == 19) {
			if (empty($data['loan_infor']['device_asset_location']['device_asset_location_id'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Mã Seri Định Vị Không Được Để Trống")));
				return;
			}
			$check_status_device = $this->api->apiPost($this->userInfo['token'], "contract/check_status_device", ['device_asset_location_id' => $data['loan_infor']['device_asset_location']['device_asset_location_id']]);
			if(!empty($check_status_device) && $check_status_device->status != 200){
				$this->pushJson('200', json_encode(array("code" => "400", "message" => $check_status_device->message)));
				return;
			}
			if(!empty($check_status_device) && $check_status_device->status == 200){
				if ($check_status_device->data->warehouse_asset_location->store_id != $data['store']['id']){
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Thiết bị không nằm trong PGD")));
					return;
				}

			}
		} else {
			if(!empty($data['loan_infor']['device_asset_location']['device_asset_location_id'])){
				$check_status_device = $this->api->apiPost($this->userInfo['token'], "contract/check_status_device", ['device_asset_location_id' => $data['loan_infor']['device_asset_location']['device_asset_location_id']]);
				if(!empty($check_status_device) && $check_status_device->status != 200){
					$this->pushJson('200', json_encode(array("code" => "400", "message" => $check_status_device->message)));
					return;
				}
				if(!empty($check_status_device) && $check_status_device->status == 200){
					if ($check_status_device->data->warehouse_asset_location->store_id != $data['store']['id']){
						$this->pushJson('200', json_encode(array("code" => "400", "message" => "Thiết bị không nằm trong PGD")));
						return;
					}
				}
			}
		}

		if(($data['loan_infor']['type_property']['code']) == 'XM' && $data['loan_infor']['number_day_loan'] < 180){
			$this->pushJson('200', json_encode(array("code" => "400", "message" => "Thời gian vay phải lớn hơn 3 tháng")));
			return;
		}


		// end
		$sendApi = array(
			'customer_infor' => $data['customer_infor'],
			'current_address' => $data['current_address'],
			'houseHold_address' => $data['houseHold_address'],
			'job_infor' => $data['job_infor'],
			'relative_infor' => $data['relative_infor'],
			'loan_infor' => $data['loan_infor'],
			'property_infor' => $propertyInfor,
			'receiver_infor' => $data['receiver_infor'],
			'expertise_infor' => $data['expertise_infor'],
			'info_disbursement_max' => $data['info_disbursement_max'],
			'status_disbursement_max' => $data['status_disbursement_max'],
			'store' => $data['store'],
			'data_Face_search' => $data['data_Face_search'],
			'data_Face_Identify' => $data['data_Face_Identify'],
			"created_at" => $this->createdAt,
			"created_by" => $this->user['email'],
		);
		$return = $this->api->apiPost($this->user['token'], "contract/process_create_contract", $sendApi);

		$this->api->apiPost($this->user['token'], "company_storage/create_company_storage", $sendApi);

		//$this->api->apiPost($this->user['token'], "lead_custom/getAllListAT");

		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("status" => "200", "data" => $return)));
		} else {
			$msg = !empty($return->data->message) ? $return->data->message : $return->message;
			$this->pushJson('200', json_encode(array("status" => "400", "message" => $msg, "return" => $return)));
		}

	}

	public function continueCreateContract()
	{
		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['customer_infor'] = $this->security->xss_clean($data['customer_infor']);
		$data['current_address'] = $this->security->xss_clean($data['current_address']);
		$data['houseHold_address'] = $this->security->xss_clean($data['houseHold_address']);
		$data['job_infor'] = $this->security->xss_clean($data['job_infor']);
		$data['relative_infor'] = $this->security->xss_clean($data['relative_infor']);
		$data['loan_infor'] = $this->security->xss_clean($data['loan_infor']);
		$data['receiverInfor'] = $this->security->xss_clean($data['receiverInfor']);
		$data['expertise_infor'] = $this->security->xss_clean($data['expertise_infor']);
		$data['store'] = $this->security->xss_clean($data['store']);
		$data['data_Face_search'] = $this->security->xss_clean($data['data_Face_search']);
		$data['data_Face_Identify'] = $this->security->xss_clean($data['data_Face_Identify']);
		$this->data['tilekhoanvay'] = 0;
		$config = $this->api->apiPost($this->userInfo['token'], "config_gic/get_config", array('code' => "TN_TNNNV"));
		if (!empty($config->status) && $config->status == 200) {
			$this->data['tilekhoanvay'] = (!empty($config->data->TyLePhi)) ? $config->data->TyLePhi : 0;
		}
		$propertyInfor = array();
		if (!empty($data['property_infor'])) $propertyInfor = $this->security->xss_clean($data['property_infor']);

		// validate
		if (!$this->isValidEmail($data['customer_infor']['customer_email'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "message" => $this->lang->line('invalid_email'))));
			return;
		}
		if (!preg_match("/^[0-9]{9,12}$/", $data['customer_infor']['customer_identify'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "message" => "CMND/CCCD hiện tại không đúng định dạng")));
			return;
		}

		if (!empty($data['customer_infor']['passport_number'])) {
			if (empty($data['customer_infor']['passport_address'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "message" => "Nơi cấp hộ chiếu không được để trống")));
				return;
			}
			if (empty($data['customer_infor']['passport_date'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "message" => "Ngày cấp hộ chiếu không được để trống")));
				return;
			}

		}
		if (empty($data['customer_infor']['customer_name'])) {
			$this->pushJson('200', json_encode(array("code" => "400", "message" => "Tên khách hàng không được để trống")));
			return;
		}
		if (
			!empty($data['customer_infor']['customer_name']) 
			&& mb_strlen($data['customer_infor']['customer_name'], 'utf8') > 50
		) {
			$this->pushJson('200', json_encode(array("code" => "400", "message" => "Tên khách hàng không được vượt quá 50 ký tự!")));
			return;
		}
		if (!empty($data['loan_infor']['maVBI_1']) && !empty($data['loan_infor']['maVBI_2']) && $data['loan_infor']['maVBI_1'] != "NaN" && $data['loan_infor']['maVBI_2'] != "NaN"){
			if ($data['loan_infor']['maVBI_1'] <= 6 && $data['loan_infor']['maVBI_2'] <= 6){
				$this->pushJson('200', json_encode(array("status" => "400", "message" => "Không chọn 2 gói bảo hiểm SXH")));
				return;
			}
			if ($data['customer_infor']['customer_gender'] == 2){
				if ($data['loan_infor']['maVBI_1'] > 6 && $data['loan_infor']['maVBI_2'] > 6){
					$this->pushJson('200', json_encode(array("status" => "400", "message" => "Không chọn 2 gói bảo hiểm UTV")));
					return;
				}
			} else {
				$this->pushJson('200', json_encode(array("status" => "400", "message" => "Giới tính nữ mới mua được bảo hiểm UTV")));
				return;
			}
		}
		if ((!empty($data['loan_infor']['maVBI_1']) && $data['loan_infor']['maVBI_1'] > 6)){
			if ($data['customer_infor']['customer_gender'] == 1){
				$this->pushJson('200', json_encode(array("status" => "400", "message" => "Giới tính nữ mới mua được bảo hiểm UTV")));
				return;
			}
		}


		if (!preg_match("/^[0-9]{10,12}$/", $data['customer_infor']['customer_phone_number'])) {


			$this->pushJson('200', json_encode(array("status" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format'))));
			return;
		}
		if (!preg_match("/^[0-9]{10,12}$/", $data['relative_infor']['phone_number_relative_1'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format'))));
			return;
		}
		if (!preg_match("/^[0-9]{10,12}$/", $data['relative_infor']['phone_number_relative_2'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format'))));
			return;
		}
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$groupRole = $groupRoles->data;
		} else {
			$groupRole = array();
		}
		if (!in_array('hoi-so', $groupRole))
			if ((int)$data['loan_infor']['amount_money'] > (int)$data['loan_infor']['amount_money_max']) {
				$this->pushJson('200', json_encode(array("status" => "400", "message" => "Số tiền vay lớn hơn mức quy định")));
				return;
			}

		//Validate bảo mật khoản vay (Thông tin người thân step 3)
		if (empty($data['relative_infor']) || empty($data['relative_infor']['loan_security_1'])
			|| empty($data['relative_infor']['loan_security_2'])
		) {
			$this->pushJson('200', json_encode(array("code" => "400", "message" => "Điền đầy đủ mục thông tin người thân")));
			return;
		}
		if (!empty($data['relative_infor']['fullname_relative_3']) || !empty($data['relative_infor']['address_relative_3']) || !empty($data['relative_infor']['phone_relative_3'])) {
			if (empty($data['relative_infor']['loan_security_3'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Điền đầy đủ mục thông tin người thân - Bảo mật tham chiếu 3")));
				return;
			}
		}
		//Validate SĐT tham chiếu không hợp lệ nếu là SĐT của nhân viên VFC
		$response = $this->check_phone_relative($data['relative_infor']['phone_number_relative_1'], $data['relative_infor']['phone_number_relative_2'], $data['relative_infor']['phone_relative_3']);
		if (!empty($response['status']) && $response['status'] == 200) {
			return $this->pushJson(200, json_encode($response));
		}
		if ($data['loan_infor']['insurrance_contract'] == 1 && empty($data['loan_infor']['loan_insurance'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "message" => "Điền đầy đủ mục thông tin khoản vay")));
			return;
		}

		if ($data['loan_infor']['type_property']['code'] == 'XM') {
			if (!empty($data['loan_infor']['bao_hiem_tnds'])) {
				if ($data['loan_infor']['bao_hiem_tnds']['type_tnds'] == 'VBI_TNDS') {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Bảo hiểm trách nhiệm dân sự không đúng!")));
					return;
				}
			}
		}

		if ($data['loan_infor']['type_property']['code'] == 'OTO') {
			if (!empty($data['loan_infor']['bao_hiem_tnds'])) {
				if ($data['loan_infor']['bao_hiem_tnds']['type_tnds'] == 'MIC_TNDS') {
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Bảo hiểm trách nhiệm dân sự không đúng!")));
					return;
				}
			}
			if (empty($data['loan_infor']['gan_dinh_vi'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Điền mục gắn định vị!")));
				return;

			}
		}
		if (isset($data['loan_infor']['amount_loan'])) {
			if ($data['loan_infor']['amount_loan'] > 300000000) {
				$data['info_disbursement_max'] = divide_amount_money($data['loan_infor']['amount_loan']);
				$data['status_disbursement_max'] = 1;
			}
		}

		if ($data['loan_infor']['type_property']['code'] == 'XM' || $data['loan_infor']['type_property']['code'] == 'OTO') {
			if ($data['loan_infor']['image_property']['image_front'] === 'https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png'
				|| $data['loan_infor']['image_property']['image_back'] === 'https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png') {
				$this->pushJson('200', json_encode( ['status' => '400', "message" => "Ảnh đăng kí xe đang trống!"]));
				return;
			}
		}
		if ($data['loan_infor']['type_loan']['code'] == 'CC') {
					$data['loan_infor']['number_day_loan']=30;
			    }
		if ($data['loan_infor']['number_day_loan']==30)
		{
			$data['loan_infor']['type_interest']=2;
		}
		//validate PTI BHTN
		if (empty($data['loan_infor']['pti_bhtn'])) {
			$ptiBHTN = $this->api->apiPost($this->user['token'], "contract/validatePtiBHTNCN", [
				'amount_money' => $data['loan_infor']['amount_money'],
				'customer_identify' => $data['customer_infor']['customer_identify']
			]);
	        if (!empty($ptiBHTN->status) && $ptiBHTN->status == 200) {
	         	// do nothing
	        }else{
	        	$message = "Mục PTI - BHTN bắt buộc cho khoản vay trên 7tr";
	        	if (!empty($ptiBHTN->message)) {
	        		$message = $ptiBHTN->message;
	        	}
	        	$this->pushJson('200', json_encode([
	        		"status" => "400", 
	        		'message' => $message, 
	        		'data' => $ptiBHTN
	        	]));
	        	return;
	        }
	    }
		if ($data['loan_infor']['loan_insurance'] == 2 && $data['loan_infor']['amount_money'] < 3000000) {
			$this->pushJson('200', json_encode(array("code" => "400", "message" => "Số tiền vay nhỏ hơn 03 triệu, không đủ điều kiện tạo BH MIC khoản vay!")));
			return;
		}

		//Validate Seri Định Vị
		if ($data['loan_infor']['loan_product']['code'] == 19) {
			if (empty($data['loan_infor']['device_asset_location']['device_asset_location_id'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Mã Seri Định Vị Không Được Để Trống")));
				return;
			}
			$check_status_device = $this->api->apiPost($this->userInfo['token'], "contract/check_status_device", ['device_asset_location_id' => $data['loan_infor']['device_asset_location']['device_asset_location_id']]);
			if(!empty($check_status_device) && $check_status_device->status != 200){
				$this->pushJson('200', json_encode(array("code" => "400", "message" => $check_status_device->message)));
				return;
			}
			if(!empty($check_status_device) && $check_status_device->status == 200){
				if ($check_status_device->data->warehouse_asset_location->store_id != $data['store']['id']){
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Thiết bị không nằm trong PGD")));
					return;
				}

			}
		} else {
			if(!empty($data['loan_infor']['device_asset_location']['device_asset_location_id'])){
				$check_status_device = $this->api->apiPost($this->userInfo['token'], "contract/check_status_device", ['device_asset_location_id' => $data['loan_infor']['device_asset_location']['device_asset_location_id']]);
				if(!empty($check_status_device) && $check_status_device->status != 200){
					$this->pushJson('200', json_encode(array("code" => "400", "message" => $check_status_device->message)));
					return;
				}
				if(!empty($check_status_device) && $check_status_device->status == 200){
					if ($check_status_device->data->warehouse_asset_location->store_id != $data['store']['id']){
						$this->pushJson('200', json_encode(array("code" => "400", "message" => "Thiết bị không nằm trong PGD")));
						return;
					}

				}
			}
		}

		if(($data['loan_infor']['type_property']['code']) == 'XM' && $data['loan_infor']['number_day_loan'] < 180){
			$this->pushJson('200', json_encode(array("code" => "400", "message" => "Thời gian vay phải lớn hơn 3 tháng")));
			return;
		}


		$sendApi = array(
			"id" => $data['id'],
			'customer_infor' => $data['customer_infor'],
			'current_address' => $data['current_address'],
			'houseHold_address' => $data['houseHold_address'],
			'job_infor' => $data['job_infor'],
			'relative_infor' => $data['relative_infor'],
			'loan_infor' => $data['loan_infor'],
			'property_infor' => $propertyInfor,
			'receiver_infor' => $data['receiverInfor'],
			'expertise_infor' => $data['expertise_infor'],
			'info_disbursement_max' => $data['info_disbursement_max'],
			'status_disbursement_max' => $data['status_disbursement_max'],
			'store' => $data['store'],
			'data_Face_search' => $data['data_Face_search'],
			'data_Face_Identify' => $data['data_Face_Identify'],
			// "created_at" => $this->createdAt,
			"updated_by" => $this->user['email'],
		);
		//Insert log
		$return = $this->api->apiPost($this->user['token'], "contract/process_continue_create_contract", $sendApi);
       
		$this->api->apiPost($this->user['token'], "company_storage/create_company_storage", $sendApi);


		  if (!empty($return->status) && $return->status == 200) {
         	$this->pushJson('200', json_encode(array("status" => "200", "data" => $return)));
        }else{
        		$this->pushJson('200', json_encode(array("status" => "400","message" =>$return->message, "data" => $return)));
        }
	}

	public function continueSaveContract()
	{
		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['customer_infor'] = $this->security->xss_clean($data['customer_infor']);
		$data['current_address'] = $this->security->xss_clean($data['current_address']);
		$data['houseHold_address'] = $this->security->xss_clean($data['houseHold_address']);
		$data['job_infor'] = $this->security->xss_clean($data['job_infor']);
		$data['relative_infor'] = $this->security->xss_clean($data['relative_infor']);
		$data['loan_infor'] = $this->security->xss_clean($data['loan_infor']);
		$data['receiverInfor'] = $this->security->xss_clean($data['receiverInfor']);
		$data['expertise_infor'] = $this->security->xss_clean($data['expertise_infor']);
		$data['store'] = $this->security->xss_clean($data['store']);
		$data['step'] = $this->security->xss_clean($data['step']);
		$id_store = $data['store']['id'];
		$propertyInfor = array();
		if (!empty($data['property_infor'])) $propertyInfor = $this->security->xss_clean($data['property_infor']);
		if ($data['step'] == 1) {
			//Check null mục thông tin khách hàng
			if (empty($data['customer_infor']) || empty($data['customer_infor']['customer_name'])
				|| empty($data['customer_infor']['customer_name'])
				|| empty($data['customer_infor']['customer_email'])
				|| empty($data['customer_infor']['customer_phone_number'])
				|| empty($data['customer_infor']['customer_identify'])
				|| empty($data['customer_infor']['customer_BOD'])
				|| empty($data['customer_infor']['marriage'])) {

				$this->pushJson('200', json_encode(array("status" => "400", "message" => "Điền đầy đủ mục thông tin khách hàng")));
				return;
			}
			$store_digital = $this->api->apiPost($this->userInfo['token'], "nextpay/check_store_create_contract_digital", ['store_id'=> $id_store]);
			if (!empty($store_digital->status) && $store_digital->status == 200) {
				if ($store_digital->data == 1) {
					if (empty($data['customer_infor']['type_contract_sign'])) {
						$this->pushJson('200', json_encode(array("code" => "400", "message" => "(Mục Thông tin khách hàng) Loại hợp đồng khách hàng muốn ký không được để trống!")));
						return;
					}
					if (!empty($data['customer_infor']['type_contract_sign']) && $data['customer_infor']['type_contract_sign'] == 1) {
						if (empty($data['customer_infor']['status_email'])) {
							$this->pushJson('200', json_encode(array("code" => "400", "message" => "(Mục Thông tin khách hàng) Chưa chọn hình thức nhận thông báo ký số hợp đồng điện tử!")));
							return;
						}
					}
				}
			}
			if (
				!empty($data['customer_infor']['customer_name']) 
				&& mb_strlen($data['customer_infor']['customer_name'], 'utf8') > 50
			) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Tên khách hàng không được vượt quá 50 ký tự!")));
				return;
			}
			if (!$this->isValidEmail($data['customer_infor']['customer_email'])) {

				$this->pushJson('200', json_encode(array("status" => "400", "message" => $this->lang->line('invalid_email'))));
				return;
			}
			if (!preg_match("/^[0-9]{9,12}$/", $data['customer_infor']['customer_identify'])) {

				$this->pushJson('200', json_encode(array("status" => "400", "message" => "CMND/CCCD hiện tại không đúng định dạng")));
				return;
			}

			if (!preg_match("/^[0-9]{10,12}$/", $data['customer_infor']['customer_phone_number'])) {

				$this->pushJson('200', json_encode(array("status" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format'))));
				return;
			}

			if (!empty($data['customer_infor']['passport_number'])) {
				if (empty($data['customer_infor']['passport_address'])) {
					$this->pushJson('200', json_encode(array("status" => "400", "message" => "Nơi cấp hộ chiếu không được để trống")));
					return;
				}
				if (empty($data['customer_infor']['passport_date'])) {
					$this->pushJson('200', json_encode(array("status" => "400", "message" => "Ngày cấp hộ chiếu không được để trống")));
					return;
				}

			}
		}

		if (!$this->isValidEmail($data['customer_infor']['customer_email'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "message" => $this->lang->line('invalid_email'))));
			return;
		}
		if (!preg_match("/^[0-9]{10,12}$/", $data['customer_infor']['customer_phone_number'])) {


			$this->pushJson('200', json_encode(array("status" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format'))));
			return;
		}

		if (!empty($data['relative_infor']['phone_number_relative_1'])) {
			if (!preg_match("/^[0-9]{10,12}$/", $data['relative_infor']['phone_number_relative_1'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format'))));
				return;
			}
		}
		if (!empty($data['relative_infor']['phone_number_relative_2'])) {
			if (!preg_match("/^[0-9]{10,12}$/", $data['relative_infor']['phone_number_relative_2'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format'))));
				return;
			}
		}
		//Validate bảo mật khoản vay (Thông tin người thân step 3)
		if (empty($data['relative_infor']) || empty($data['relative_infor']['loan_security_1'])
			|| empty($data['relative_infor']['loan_security_2'])
		) {
			$this->pushJson('200', json_encode(array("code" => "400", "message" => "Điền đầy đủ mục thông tin người thân")));
			return;
		}
		if (!empty($data['relative_infor']['fullname_relative_3']) || !empty($data['relative_infor']['address_relative_3']) || !empty($data['relative_infor']['phone_relative_3'])) {
			if (empty($data['relative_infor']['loan_security_3'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Điền đầy đủ mục thông tin người thân - Bảo mật tham chiếu 3")));
				return;
			}
		}
		//Validate SĐT tham chiếu không hợp lệ nếu là SĐT của nhân viên VFC
		$response = $this->check_phone_relative($data['relative_infor']['phone_number_relative_1'], $data['relative_infor']['phone_number_relative_2'], $data['relative_infor']['phone_relative_3']);
		if (!empty($response['status']) && $response['status'] == 200) {
			return $this->pushJson(200, json_encode($response));
		}

		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$groupRole = $groupRoles->data;
		} else {
			$groupRole = array();
		}
		if (!in_array('hoi-so', $groupRole))
			if (!empty($data['loan_infor']['amount_money']) && !empty($data['loan_infor']['amount_money_max'])) {
				if ((int)$data['loan_infor']['amount_money'] > (int)$data['loan_infor']['amount_money_max']) {
					$this->pushJson('200', json_encode(array("status" => "400", "message" => "Số tiền vay lớn hơn mức quy định")));
					return;
				}
			}

		if (isset($data['loan_infor']['amount_loan'])) {
			if ($data['loan_infor']['amount_loan'] > 300000000) {
				$data['info_disbursement_max'] = divide_amount_money($data['loan_infor']['amount_loan']);
				$data['status_disbursement_max'] = 1;
			}
		}
		if ($data['loan_infor']['type_property']['code'] == 'XM') {
			if (!empty($data['loan_infor']['bao_hiem_tnds'])) {
				if ($data['loan_infor']['bao_hiem_tnds']['type_tnds'] == 'VBI_TNDS') {
					$this->pushJson('200', json_encode(array("status" => "400", "message" => "Bảo hiểm trách nhiệm dân sự không đúng!")));
					return;
				}
			}
		}

		if ($data['loan_infor']['type_property']['code'] == 'OTO') {
			if (!empty($data['loan_infor']['bao_hiem_tnds'])) {
				if ($data['loan_infor']['bao_hiem_tnds']['type_tnds'] == 'MIC_TNDS') {
					$this->pushJson('200', json_encode(array("status" => "400", "message" => "Bảo hiểm trách nhiệm dân sự không đúng!")));
					return;
				}
			}
			if (empty($data['loan_infor']['gan_dinh_vi'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "message" => "Điền mục gắn định vị!")));
				return;

			}
		}

		if ($data['loan_infor']['type_property']['code'] == 'XM' || $data['loan_infor']['type_property']['code'] == 'OTO') {
			if ($data['loan_infor']['image_property']['image_front'] === 'https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png'
				|| $data['loan_infor']['image_property']['image_back'] === 'https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png') {
				$this->pushJson('200', json_encode(['status' => '400', "message" => "Ảnh đăng kí xe đang trống!"]));
				return;
			}
		}
		if ($data['loan_infor']['type_loan']['code'] == 'CC') {
					$data['loan_infor']['number_day_loan']=30;
			    }
		if ($data['loan_infor']['number_day_loan']==30)
		{
			$data['loan_infor']['type_interest']=2;
		}
		//validate PTI BHTN
		if (empty($data['loan_infor']['pti_bhtn'])) {
			$ptiBHTN = $this->api->apiPost($this->user['token'], "contract/validatePtiBHTNCN", [
				'amount_money' => $data['loan_infor']['amount_money'],
				'customer_identify' => $data['customer_infor']['customer_identify']
			]);
	        if (!empty($ptiBHTN->status) && $ptiBHTN->status == 200) {
	         	// do nothing
	        }else{
	        	$message = "Mục PTI - BHTN bắt buộc cho khoản vay trên 7tr";
	        	if (!empty($ptiBHTN->message)) {
	        		$message = $ptiBHTN->message;
	        	}
	        	$this->pushJson('200', json_encode([
	        		"status" => "400", 
	        		'message' => $message, 
	        		'data' => $ptiBHTN
	        	]));
	        	return;
	        }
	    }
		if ($data['loan_infor']['loan_insurance'] == 2 && $data['loan_infor']['amount_money'] < 3000000) {
			$this->pushJson('200', json_encode(array("code" => "400", "message" => "Số tiền vay nhỏ hơn 03 triệu, không đủ điều kiện tạo BH MIC khoản vay!")));
			return;
		}

		$sendApi = array(
			"id" => $data['id'],
			'customer_infor' => $data['customer_infor'],
			'current_address' => $data['current_address'],
			'houseHold_address' => $data['houseHold_address'],
			'job_infor' => $data['job_infor'],
			'relative_infor' => $data['relative_infor'],
			'loan_infor' => $data['loan_infor'],
			'property_infor' => $propertyInfor,
			'receiver_infor' => $data['receiverInfor'],
			'expertise_infor' => $data['expertise_infor'],
			'info_disbursement_max' => $data['info_disbursement_max'],
			'status_disbursement_max' => $data['status_disbursement_max'],
			'store' => $data['store'],
			'step' => $data['step'],
			// "created_at" => $this->createdAt,
			"updated_by" => $this->user['email'],
		);
		//Insert log
		$return = $this->api->apiPost($this->user['token'], "contract/process_update_contract_continue", $sendApi);

		  if (!empty($return->status) && $return->status == 200) {
         	$this->pushJson('200', json_encode(array("status" => "200", "data" => $return)));
        }else{
        		$this->pushJson('200', json_encode(array("status" => "400","message" =>$return->message, "data" => $return)));
        }
	}

	public function processUpdateContract()
	{
		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['customer_infor'] = $this->security->xss_clean($data['customer_infor']);
		$data['current_address'] = $this->security->xss_clean($data['current_address']);
		$data['houseHold_address'] = $this->security->xss_clean($data['houseHold_address']);
		$data['job_infor'] = $this->security->xss_clean($data['job_infor']);
		$data['relative_infor'] = $this->security->xss_clean($data['relative_infor']);
		$data['loan_infor'] = $this->security->xss_clean($data['loan_infor']);
		$data['receiverInfor'] = $this->security->xss_clean($data['receiverInfor']);
		$data['expertise_infor'] = $this->security->xss_clean($data['expertise_infor']);
		$data['store'] = $this->security->xss_clean($data['store']);
		$id_store = $data['store']['id'];

		$sendApiGetOneContract = array("id" => $data['id']);
		$dataContract = $this->api->apiPost($this->user['token'], "contract/get_one", $sendApiGetOneContract);
		if (!empty($dataContract->status) && $dataContract->status == 200) {
			$data['code_contract_disbursement'] = $dataContract->data->code_contract_disbursement;
			$status = $dataContract->data->status;
		} else {
			$data['code_contract_disbursement'] = "";
			$status = '';
		}

//		if(in_array($status, [15, 17, 19] )){
//			$this->pushJson('200', json_encode(array("code" => "400", "message" => "Trạng thái cập nhật không hợp lệ")));
//			return;
//		}
		$propertyInfor = array();
		if (!empty($data['property_infor'])) $propertyInfor = $this->security->xss_clean($data['property_infor']);


		if ($data['receiverInfor']['amount'] > 5000000 && $data['loan_infor']['loan_product']['code'] == "18") {
			$this->pushJson('200', json_encode(array("status" => "400", "message" => "Số tiền vay tối đa 5.000.000 vnđ")));
			return;

		}

		// validate
		if (!$this->isValidEmail($data['customer_infor']['customer_email'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "message" => $this->lang->line('invalid_email'))));
			return;
		}

		if (!empty($data['loan_infor']['maVBI_1']) && !empty($data['loan_infor']['maVBI_2']) && $data['loan_infor']['maVBI_1'] != "NaN" && $data['loan_infor']['maVBI_2'] != "NaN"){
			if ($data['loan_infor']['maVBI_1'] <= 6 && $data['loan_infor']['maVBI_2'] <= 6){
				$this->pushJson('200', json_encode(array("status" => "400", "message" => "Không chọn 2 gói bảo hiểm SXH")));
				return;
			}
			if ($data['customer_infor']['customer_gender'] == 2){
				if ($data['loan_infor']['maVBI_1'] > 6 && $data['loan_infor']['maVBI_2'] > 6){
					$this->pushJson('200', json_encode(array("status" => "400", "message" => "Không chọn 2 gói bảo hiểm UTV")));
					return;
				}
			} else {
				$this->pushJson('200', json_encode(array("status" => "400", "message" => "Giới tính nữ mới mua được bảo hiểm UTV")));
				return;
			}
		}

		if ((!empty($data['loan_infor']['maVBI_1']) && $data['loan_infor']['maVBI_1'] > 6)){
			if ($data['customer_infor']['customer_gender'] == 1){
				$this->pushJson('200', json_encode(array("status" => "400", "message" => "Giới tính nữ mới mua được bảo hiểm UTV")));
				return;
			}
		}

		if ($data['loan_infor']['loan_product']['code'] == "14") {
			if (empty($data['loan_infor']['link_shop'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "message" => "Link shop online không được để trống")));
				return;
			}
		}
		if (!empty($data['customer_infor']['passport_number'])) {
			if (empty($data['customer_infor']['passport_address'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "message" => "Nơi cấp hộ chiếu không được để trống")));
				return;
			}
			if (empty($data['customer_infor']['passport_date'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "message" => "Ngày cấp hộ chiếu không được để trống")));
				return;
			}

		}
		$store_digital = $this->api->apiPost($this->userInfo['token'], "nextpay/check_store_create_contract_digital", ['store_id'=> $id_store]);
			if (!empty($store_digital->status) && $store_digital->status == 200) {
				if ($store_digital->data == 1) {
					if (empty($data['customer_infor']['type_contract_sign'])) {
						$this->pushJson('200', json_encode(array("code" => "400", "message" => "(Mục Thông tin khách hàng) Loại hợp đồng khách hàng muốn ký không được để trống!")));
						return;
					}
					if (!empty($data['customer_infor']['type_contract_sign']) && $data['customer_infor']['type_contract_sign'] == 1) {
						if (empty($data['customer_infor']['status_email'])) {
							$this->pushJson('200', json_encode(array("code" => "400", "message" => "(Mục Thông tin khách hàng) Chưa chọn hình thức nhận thông báo ký số hợp đồng điện tử!")));
							return;
						}
					}
				}
			}
		if (
			!empty($data['customer_infor']['customer_name']) 
			&& mb_strlen($data['customer_infor']['customer_name'], 'utf8') > 50
		) {
			$this->pushJson('200', json_encode(array("code" => "400", "message" => "Tên khách hàng không được vượt quá 50 ký tự!")));
			return;
		}
		if (!empty($data['customer_infor']['customer_resources']) && $data['customer_infor']['customer_resources'] == 11) {
			if (empty($data['customer_infor']['presenter_name'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "message" => "Tên người giới thiệu không được để trống")));
				return;
			}
			if (empty($data['customer_infor']['customer_phone_introduce'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "message" => "Số điện thoại người giới thiệu không được để trống")));
				return;
			}
			if (!preg_match("/^[0-9]{10,12}$/", $data['customer_infor']['customer_phone_introduce'])) {

				$this->pushJson('200', json_encode(array("status" => "400", "message" => "Số điện thoại người giới thiệu không đúng định dạng")));
				return;
			}
			if (empty($data['customer_infor']['presenter_bank'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "message" => "Tên ngân hàng người giới thiệu không được để trống")));
				return;
			}
			if (empty($data['customer_infor']['presenter_stk'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "message" => "Số tài khoản ngân hàng người giới thiệu không được để trống")));
				return;
			}
			if (empty($data['customer_infor']['presenter_cmt'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "message" => "Số chứng minh thư người giới thiệu không được để trống")));
				return;
			}
			if (!preg_match("/^[0-9]{9,12}$/", $data['customer_infor']['presenter_cmt'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "message" => "Số chứng minh thư người giới thiệu không đúng định dạng")));
				return;
			}
			if (empty($data['customer_infor']['img_file_presenter_cmt'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "message" => "Ảnh chứng minh thư người giới thiệu không được để trống")));
				return;
			}
		}



		if (!preg_match("/^[0-9]{10,12}$/", $data['customer_infor']['customer_phone_number'])) {


			$this->pushJson('200', json_encode(array("status" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format'))));
			return;
		}
		if (!preg_match("/^[0-9]{10,12}$/", $data['relative_infor']['phone_number_relative_1'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format'))));
			return;
		}
		if (!preg_match("/^[0-9]{10,12}$/", $data['relative_infor']['phone_number_relative_2'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "message" => $this->lang->line('phone_number_not_in_correct_format'))));
			return;
		}
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$groupRole = $groupRoles->data;
		} else {
			$groupRole = array();
		}

		if (!in_array('hoi-so', $groupRole))
			if ((int)$data['loan_infor']['amount_money'] > (int)$data['loan_infor']['amount_money_max']) {
				$this->pushJson('200', json_encode(array("status" => "400", "message" => "Số tiền vay lớn hơn mức quy định")));
				return;
			}

		if ($data['loan_infor']['insurrance_contract'] == 1 && empty($data['loan_infor']['loan_insurance'])) {
			$this->pushJson('200', json_encode(array("status" => "400", "message" => "Điền đầy đủ mục thông tin khoản vay")));
			return;
		}

		if (!empty($data['customer_infor']['passport_number'])) {
			if (empty($data['customer_infor']['passport_address'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "message" => "Nơi cấp hộ chiếu không được để trống")));
				return;
			}
			if (empty($data['customer_infor']['passport_date'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "message" => "Ngày cấp hộ chiếu không được để trống")));
				return;
			}

		}
		//Validate bảo mật khoản vay (Thông tin người thân step 3)
		if (empty($data['relative_infor']) || empty($data['relative_infor']['loan_security_1'])
			|| empty($data['relative_infor']['loan_security_2'])
			) {
			$this->pushJson('200', json_encode(array("code" => "400", "message" => "Điền đầy đủ mục thông tin người thân")));
			return;
		}
		if (!empty($data['relative_infor']['fullname_relative_3']) || !empty($data['relative_infor']['address_relative_3']) || !empty($data['relative_infor']['phone_relative_3'])) {
			if (empty($data['relative_infor']['loan_security_3'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Điền đầy đủ mục thông tin người thân - Bảo mật tham chiếu 3")));
				return;
			}
		}
		//Validate SĐT tham chiếu không hợp lệ nếu là SĐT của nhân viên VFC
		$response = $this->check_phone_relative($data['relative_infor']['phone_number_relative_1'], $data['relative_infor']['phone_number_relative_2'], $data['relative_infor']['phone_relative_3']);
		if (!empty($response['status']) && $response['status'] == 200) {
			return $this->pushJson(200, json_encode($response));
		}

		if (isset($data['loan_infor']['amount_loan'])) {
			if ($data['loan_infor']['amount_loan'] > 300000000) {
				$data['info_disbursement_max'] = divide_amount_money($data['loan_infor']['amount_loan']);
				$data['status_disbursement_max'] = 1;
			}
		}

		if ($data['loan_infor']['type_property']['code'] == 'XM') {
			if (!empty($data['loan_infor']['bao_hiem_tnds'])) {
				if ($data['loan_infor']['bao_hiem_tnds']['type_tnds'] == 'VBI_TNDS') {
					$this->pushJson('200', json_encode(array("status" => "400", "message" => "Bảo hiểm trách nhiệm dân sự không đúng!")));
					return;
				}
			}
		}

		if ($data['loan_infor']['type_property']['code'] == 'OTO') {
			if (!empty($data['loan_infor']['bao_hiem_tnds'])) {
				if ($data['loan_infor']['bao_hiem_tnds']['type_tnds'] == 'MIC_TNDS') {
					$this->pushJson('200', json_encode(array("status" => "400", "message" => "Bảo hiểm trách nhiệm dân sự không đúng!")));
					return;
				}
			}
			if (empty($data['loan_infor']['gan_dinh_vi'])) {
				$this->pushJson('200', json_encode(array("status" => "400", "message" => "Điền mục gắn định vị!")));
				return;

			}
		}
		if ($data['loan_infor']['type_property']['code'] == 'XM' || $data['loan_infor']['type_property']['code'] == 'OTO') {
			if ($data['loan_infor']['image_property']['image_front'] === 'https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png'
				|| $data['loan_infor']['image_property']['image_back'] === 'https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png') {
				$this->pushJson('200', json_encode( ['status' => '400', "message" => "Ảnh đăng kí xe đang trống!"]));
				return;
			}
		}
		if ($data['loan_infor']['type_loan']['code'] == 'CC') {
					$data['loan_infor']['number_day_loan']=30;
			    }
		if ($data['loan_infor']['number_day_loan']==30)
		{
			$data['loan_infor']['type_interest']=2;
		}
		//validate PTI BHTN
		if (empty($data['loan_infor']['pti_bhtn'])) {
			$ptiBHTN = $this->api->apiPost($this->user['token'], "contract/validatePtiBHTNCN", [
				'amount_money' => $data['loan_infor']['amount_money'],
				'customer_identify' => $data['customer_infor']['customer_identify']
			]);
	        if (!empty($ptiBHTN->status) && $ptiBHTN->status == 200) {
	         	// do nothing
	        }else{
	        	$message = "Mục PTI - BHTN bắt buộc cho khoản vay trên 7tr";
	        	if (!empty($ptiBHTN->message)) {
	        		$message = $ptiBHTN->message;
	        	}
	        	$this->pushJson('200', json_encode([
	        		"status" => "400", 
	        		'message' => $message, 
	        		'data' => $ptiBHTN
	        	]));
	        	return;
	        }
	    }
		if ($data['loan_infor']['loan_insurance'] == 2 && $data['loan_infor']['amount_money'] < 3000000) {
			$this->pushJson('200', json_encode(array("code" => "400", "message" => "Số tiền vay nhỏ hơn 03 triệu, không đủ điều kiện tạo BH MIC khoản vay!")));
			return;
		}

		//Validate Seri Định Vị
		if ($data['loan_infor']['loan_product']['code'] == 19) {
			if (empty($data['loan_infor']['device_asset_location']['device_asset_location_id'])) {
				$this->pushJson('200', json_encode(array("code" => "400", "message" => "Mã Seri Định Vị Không Được Để Trống")));
				return;
			}
			$check_status_device = $this->api->apiPost($this->userInfo['token'], "contract/check_status_device", ['device_asset_location_id' => $data['loan_infor']['device_asset_location']['device_asset_location_id']]);
			if(!empty($check_status_device) && $check_status_device->status != 200){
				$this->pushJson('200', json_encode(array("code" => "400", "message" => $check_status_device->message)));
				return;
			}
			if(!empty($check_status_device) && $check_status_device->status == 200){
				if ($check_status_device->data->warehouse_asset_location->store_id != $data['store']['id']){
					$this->pushJson('200', json_encode(array("code" => "400", "message" => "Thiết bị không nằm trong PGD")));
					return;

				}
			}
		} else {
			if(!empty($data['loan_infor']['device_asset_location']['device_asset_location_id'])){
				$check_status_device = $this->api->apiPost($this->userInfo['token'], "contract/check_status_device", ['device_asset_location_id' => $data['loan_infor']['device_asset_location']['device_asset_location_id']]);
				if(!empty($check_status_device) && $check_status_device->status != 200){
					$this->pushJson('200', json_encode(array("code" => "400", "message" => $check_status_device->message)));
					return;
				}
				if(!empty($check_status_device) && $check_status_device->status == 200){
					if ($check_status_device->data->warehouse_asset_location->store_id != $data['store']['id']){
						$this->pushJson('200', json_encode(array("code" => "400", "message" => "Thiết bị không nằm trong PGD")));
						return;

					}
				}
			}
		}

		if(($data['loan_infor']['type_property']['code']) == 'XM' && $data['loan_infor']['number_day_loan'] < 180){
			$this->pushJson('200', json_encode(array("code" => "400", "message" => "Thời gian vay phải lớn hơn 3 tháng")));
			return;
		}

		$sendApi = array(
			"id" => $data['id'],
			'customer_infor' => $data['customer_infor'],
			'current_address' => $data['current_address'],
			'houseHold_address' => $data['houseHold_address'],
			'job_infor' => $data['job_infor'],
			'relative_infor' => $data['relative_infor'],
			'loan_infor' => $data['loan_infor'],
			'info_disbursement_max' => $data['info_disbursement_max'],
			'status_disbursement_max' => $data['status_disbursement_max'],
			'property_infor' => $propertyInfor,
			'receiver_infor' => $data['receiverInfor'],
			'expertise_infor' => $data['expertise_infor'],
			'store' => $data['store'],
			"code_contract_disbursement" => $data['code_contract_disbursement'],
			// "created_at" => $this->createdAt,
			"updated_by" => $this->user['email'],
		);
		//Insert log
		if(in_array($status, [6, 7] ) && !in_array('hoi-so', $groupRole)){
			$this->pushJson('200', json_encode(array("code" => "400", "message" => "Trạng thái cập nhật không hợp lệ")));
			return;
		}

		if(in_array($status, [15 , 17, 19] )){
			$this->pushJson('200', json_encode(array("code" => "400", "message" => "Trạng thái cập nhật không hợp lệ")));
			return;
		}
		$return = $this->api->apiPost($this->user['token'], "contract/process_update_contract", $sendApi);
        if (!empty($return->status) && $return->status == 200) {
         	$this->pushJson('200', json_encode(array("status" => "200", "data" => $return)));
        }else{
        		$this->pushJson('200', json_encode(array("status" => "400","message" =>$return->message, "data" => $return)));
        }
	
	}

	private function pushJson($code, $data)
	{
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}

	// public function display() {
	//     $condition['count'] = true;
	//     $condition['user_id'] = $this->userInfo['user_id'];
	//     $condition['type'] = 1;
	//     $count = $this->transaction_model->getTransactions($condition);
	//     $config = $this->config->item('pagination');
	//     $uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
	//     $config['base_url'] = base_url('referral/display');
	//     $config['total_rows'] = $count;
	//     $config['per_page'] = 30;
	//     $config['page_query_string'] = true;
	//     $config['uri_segment'] = $uriSegment;
	//     $this->pagination->initialize($config);
	//     $this->data['pagination'] = $this->pagination->create_links();
	//     unset($condition['count']);
	//     $data = $this->transaction_model->getTransactions($condition, $config['per_page'], $uriSegment);
	//     $this->data['transactions'] = $data;
	//     $this->data['pageName'] = 'Referral';
	//     $this->layout->view('referral/index', $this->data);
	// }


	public function contract()
	{
		$this->data["pageName"] = $this->lang->line('manage_contract');
		// call api get count contract
		$data = array();
		$userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
		$stores = !empty($userInfo['stores']) ? $userInfo['stores'] : array();

		//get store
		$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all", array());
		$arr_store = array();
		$this->data['code_domain'] = '';
		if (!empty($storeData->status) && $storeData->status == 200 && !empty($stores)) {
			foreach ($stores as $key => $store) {
				$arr_store += [$key => $store->store_id];
			}

			foreach ($storeData->data as $key => $value) {
				if ($value->status != 'active' || !in_array($value->_id->{'$oid'}, $arr_store)) {
					unset($storeData->data[$key]);

				} else {
					$area = $this->api->apiPost($this->userInfo['token'], "area/get_area_by_code", array('code' => $value->code_area));
					if (!empty($area->status) && $area->status == 200) {
						$this->data['code_domain'] = $area->data->domain->code;
					}
				}

			}
			$this->data['stores'] = $storeData->data;
		} else {
			$this->data['stores'] = array();
		}
		$countContractData = $this->api->apiPost($this->userInfo['token'], "contract/get_count_all", $data);

		if (!empty($countContractData->status) && $countContractData->status == 200 && $countContractData->data != 0) {

			$count = (int)$countContractData->data;
			$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
			$config = $this->config->item('pagination');
			$config['base_url'] = base_url('pawn/contract');
			$config['total_rows'] = $count;
			$config['per_page'] = 20;
			$config['page_query_string'] = true;
			$config['uri_segment'] = $uriSegment;
			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();
			$this->data['countContract'] = $count;
			$data = array(
				"per_page" => $config['per_page'],
				"uriSegment" => $config['uri_segment']
			);

			$contractData = $this->api->apiPost($this->userInfo['token'], "contract/get_all_data", $data);

			// var_dump($contractData->per_page);
			// var_dump($contractData->uriSegment);die;
			if (!empty($contractData->status) && $contractData->status == 200) {
				$this->data['contractData'] = $contractData->data;
				$this->data['count'] = $contractData->count;
			} else {
				$this->data['contractData'] = array();
				$this->data['count'] = [];
			}

			for ($i = 0; $i < count($contractData->data); $i++) {
				$check = [
					"contract_id" => $contractData->data[$i]->_id->{'$oid'}
				];
				$data_hs = $this->api->apiPost($this->userInfo['token'], "hoiso_create/get_create_at_hs_all", $check);

				if (!empty($data_hs->status) && $data_hs->status == 200) {

					$contractData->data[$i]->data_hs = $data_hs->data;
				} else {

					$contractData->data[$i]->data_hs = array();
				}

				unset($check);
				unset($data_hs);
			}


		} else {
			$this->data['contractData'] = array();
		}

		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		//get coupon
		$couponData = $this->api->apiPost($this->userInfo['token'], "coupon/get_all_home");
		if (!empty($couponData->status) && $couponData->status == 200) {
			$this->data['couponData'] = $couponData->data;
		} else {
			$this->data['couponData'] = array();
		}
		//get property main ( tài sản cấp cao nhất parenid == null)
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main");
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$this->data['mainPropertyData'] = $mainPropertyData->data;
		} else {
			$this->data['mainPropertyData'] = array();
		}
		//get list nhà đầu tư
		$listInvestor = $this->api->apiPost($this->userInfo['token'], "investor/get_all");
		if ($listInvestor->status == 200) {
			$this->data['listInvestor'] = $listInvestor->data;
		}

		$this->data['tilekhoanvay'] = 0;
		$config = $this->api->apiPost($this->userInfo['token'], "config_gic/get_config", array('code' => "TN_TNNNV"));
		if (!empty($config->status) && $config->status == 200) {
			$this->data['tilekhoanvay'] = (!empty($config->data->TyLePhi)) ? $config->data->TyLePhi : 0;
		}
		$this->data['template'] = 'page/pawn/contract';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function contract_giahan()
	{
		$this->data["pageName"] = $this->lang->line('manage_contract') . ' gia hạn';
		// call api get count contract
		$data = array();
		$stores = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active", $data);
		$this->data['stores'] = $stores->data;
		$data['type_contract'] = "GH";
		$countContractData = $this->api->apiPost($this->userInfo['token'], "contract/get_count_all", $data);

		if (!empty($countContractData->status) && $countContractData->status == 200 && $countContractData->data != 0) {

			$count = (int)$countContractData->data;
			$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
			$config = $this->config->item('pagination');
			$config['base_url'] = base_url('pawn/contract');
			$config['total_rows'] = $count;
			$config['per_page'] = 30;
			$config['page_query_string'] = true;
			$config['uri_segment'] = $uriSegment;
			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();
			$this->data['countContract'] = $count;
			$data = array(
				"per_page" => $config['per_page'],
				"uriSegment" => $config['uri_segment'],
				"type_contract" => "GH"
			);

			$contractData = $this->api->apiPost($this->userInfo['token'], "contract/get_all_data", $data);

			// var_dump($contractData->per_page);
			// var_dump($contractData->uriSegment);die;
			if (!empty($contractData->status) && $contractData->status == 200) {
				$this->data['contractData'] = $contractData->data;
			} else {
				$this->data['contractData'] = array();
			}

			for ($i = 0; $i < count($contractData->data); $i++) {
				$check = [
					"contract_id" => $contractData->data[$i]->_id->{'$oid'}
				];
				$data_hs = $this->api->apiPost($this->userInfo['token'], "hoiso_create/get_create_at_hs_all", $check);

				if (!empty($data_hs->status) && $data_hs->status == 200) {

					$contractData->data[$i]->data_hs = $data_hs->data;
				} else {

					$contractData->data[$i]->data_hs = array();
				}

				unset($check);
				unset($data_hs);
			}


		} else {
			$this->data['contractData'] = array();
		}

		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		//get coupon
		$couponData = $this->api->apiPost($this->userInfo['token'], "coupon/get_all_home");
		if (!empty($couponData->status) && $couponData->status == 200) {
			$this->data['couponData'] = $couponData->data;
		} else {
			$this->data['couponData'] = array();
		}
		//get property main ( tài sản cấp cao nhất parenid == null)
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main");
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$this->data['mainPropertyData'] = $mainPropertyData->data;
		} else {
			$this->data['mainPropertyData'] = array();
		}
		//get list nhà đầu tư
		$listInvestor = $this->api->apiPost($this->userInfo['token'], "investor/get_all");
		if ($listInvestor->status == 200) {
			$this->data['listInvestor'] = $listInvestor->data;
		}

		$this->data['tilekhoanvay'] = 0;
		$config = $this->api->apiPost($this->userInfo['token'], "config_gic/get_config", array('code' => "TN_TNNNV"));
		if (!empty($config->status) && $config->status == 200) {
			$this->data['tilekhoanvay'] = (!empty($config->data->TyLePhi)) ? $config->data->TyLePhi : 0;
		}
		$this->data['template'] = 'page/pawn/contract_giahan';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function contract_cocau()
	{
		$this->data["pageName"] = $this->lang->line('manage_contract') . ' cơ cấu';
		// call api get count contract
		$data = array();
		$stores = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active", $data);
		$this->data['stores'] = $stores->data;

		$data['type_contract'] = "CC";
		$countContractData = $this->api->apiPost($this->userInfo['token'], "contract/get_count_all", $data);

		if (!empty($countContractData->status) && $countContractData->status == 200 && $countContractData->data != 0) {

			$count = (int)$countContractData->data;
			$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
			$config = $this->config->item('pagination');
			$config['base_url'] = base_url('pawn/contract');
			$config['total_rows'] = $count;
			$config['per_page'] = 30;
			$config['page_query_string'] = true;
			$config['uri_segment'] = $uriSegment;
			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();
			$this->data['countContract'] = $count;
			$data = array(
				"per_page" => $config['per_page'],
				"uriSegment" => $config['uri_segment'],
				"type_contract" => "CC",
			);

			$contractData = $this->api->apiPost($this->userInfo['token'], "contract/get_all_data", $data);

			// var_dump($contractData->per_page);
			// var_dump($contractData->uriSegment);die;
			if (!empty($contractData->status) && $contractData->status == 200) {
				$this->data['contractData'] = $contractData->data;
			} else {
				$this->data['contractData'] = array();
			}

			for ($i = 0; $i < count($contractData->data); $i++) {
				$check = [
					"contract_id" => $contractData->data[$i]->_id->{'$oid'}
				];
				$data_hs = $this->api->apiPost($this->userInfo['token'], "hoiso_create/get_create_at_hs_all", $check);

				if (!empty($data_hs->status) && $data_hs->status == 200) {

					$contractData->data[$i]->data_hs = $data_hs->data;
				} else {

					$contractData->data[$i]->data_hs = array();
				}

				unset($check);
				unset($data_hs);
			}


		} else {
			$this->data['contractData'] = array();
		}

		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		//get coupon
		$couponData = $this->api->apiPost($this->userInfo['token'], "coupon/get_all_home");
		if (!empty($couponData->status) && $couponData->status == 200) {
			$this->data['couponData'] = $couponData->data;
		} else {
			$this->data['couponData'] = array();
		}
		//get property main ( tài sản cấp cao nhất parenid == null)
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main");
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$this->data['mainPropertyData'] = $mainPropertyData->data;
		} else {
			$this->data['mainPropertyData'] = array();
		}
		//get list nhà đầu tư
		$listInvestor = $this->api->apiPost($this->userInfo['token'], "investor/get_all");
		if ($listInvestor->status == 200) {
			$this->data['listInvestor'] = $listInvestor->data;
		}

		$this->data['tilekhoanvay'] = 0;
		$config = $this->api->apiPost($this->userInfo['token'], "config_gic/get_config", array('code' => "TN_TNNNV"));
		if (!empty($config->status) && $config->status == 200) {
			$this->data['tilekhoanvay'] = (!empty($config->data->TyLePhi)) ? $config->data->TyLePhi : 0;
		}
		$this->data['template'] = 'page/pawn/contract_cocau';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}


	public function contract_import()
	{
		$this->data["pageName"] = $this->lang->line('manage_contract');
		// call api get count contract
		$data = array("type_ct" => "old_contract");
		$countContractData = $this->api->apiPost($this->userInfo['token'], "contract/get_count_all", $data);
		if (!empty($countContractData->status) && $countContractData->status == 200 && $countContractData->data != 0) {

			$count = (int)$countContractData->data;
			$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
			$config = $this->config->item('pagination');
			$config['base_url'] = base_url('pawn/contract_import');
			$config['total_rows'] = $count;
			$config['per_page'] = 50;
			$config['page_query_string'] = true;
			$config['uri_segment'] = $uriSegment;
			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();
			$data = array(
				"type_ct" => "old_contract",
				"per_page" => $config['per_page'],
				"uriSegment" => $config['uri_segment']
			);
			$contractData = $this->api->apiPost($this->userInfo['token'], "contract/get_all_data", $data);
			// var_dump($contractData->per_page);
			// var_dump($contractData->uriSegment);die;
			if (!empty($contractData->status) && $contractData->status == 200) {
				$this->data['contractData'] = $contractData->data;
			} else {
				$this->data['contractData'] = array();
			}

		} else {
			$this->data['contractData'] = array();
		}

		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		//get coupon
		$couponData = $this->api->apiPost($this->userInfo['token'], "coupon/get_all_home");
		if (!empty($couponData->status) && $couponData->status == 200) {
			$this->data['couponData'] = $couponData->data;
		} else {
			$this->data['couponData'] = array();
		}
		//get property main ( tài sản cấp cao nhất parenid == null)
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main");
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$this->data['mainPropertyData'] = $mainPropertyData->data;
		} else {
			$this->data['mainPropertyData'] = array();
		}
		//get list nhà đầu tư
		$listInvestor = $this->api->apiPost($this->userInfo['token'], "investor/get_all");
		if ($listInvestor->status == 200) {
			$this->data['listInvestor'] = $listInvestor->data;
		}

		$this->data['tilekhoanvay'] = 0;
		$config = $this->api->apiPost($this->userInfo['token'], "config_gic/get_config", array('code' => "TN_TNNNV"));
		if (!empty($config->status) && $config->status == 200) {
			$this->data['tilekhoanvay'] = (!empty($config->data->TyLePhi)) ? $config->data->TyLePhi : 0;
		}
		$this->data['template'] = 'page/pawn/contract_import';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function contract_old()
	{
		$this->data["pageName"] = $this->lang->line('manage_contract');
		// call api get count contract
		$data = array("type_ct" => "old_contract");
		$countContractData = $this->api->apiPost($this->userInfo['token'], "contract/get_count_all", $data);
		if (!empty($countContractData->status) && $countContractData->status == 200 && $countContractData->data != 0) {
			$count = $countContractData->data;
			$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
			$config = $this->config->item('pagination');
			$config['base_url'] = base_url('pawn/contract');
			$config['total_rows'] = $count;
			$config['per_page'] = 50;
			$config['page_query_string'] = true;
			$config['uri_segment'] = $uriSegment;
			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();
			$data = array(
				"type" => "old_contract",
				"per_page" => $config['per_page'],
				"uriSegment" => $config['uri_segment']
			);

			$contractData = $this->api->apiPost($this->userInfo['token'], "contract/get_all_data", $data);
			// var_dump($contractData->per_page);
			// var_dump($contractData->uriSegment);die;
			if (!empty($contractData->status) && $contractData->status == 200) {
				$this->data['contractData'] = $contractData->data;
			} else {
				$this->data['contractData'] = array();
			}

		} else {
			$this->data['contractData'] = array();
		}

		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		//get property main ( tài sản cấp cao nhất parenid == null)
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main");
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$this->data['mainPropertyData'] = $mainPropertyData->data;
		} else {
			$this->data['mainPropertyData'] = array();
		}
		//get list nhà đầu tư
		$listInvestor = $this->api->apiPost($this->userInfo['token'], "investor/get_all");
		if ($listInvestor->status == 200) {
			$this->data['listInvestor'] = $listInvestor->data;
		}

		$this->data['tilekhoanvay'] = 0;
		$config = $this->api->apiPost($this->userInfo['token'], "config_gic/get_config", array('code' => "TN_TNNNV"));
		if (!empty($config->status) && $config->status == 200) {
			$this->data['tilekhoanvay'] = (!empty($config->data->TyLePhi)) ? $config->data->TyLePhi : 0;
		}
		$this->data['template'] = 'page/pawn/contract';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function search()
	{
		$this->data["pageName"] = $this->lang->line('manage_contract');
		$this->data['tilekhoanvay'] = 0;
		$userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
		$stores = !empty($userInfo['stores']) ? $userInfo['stores'] : array();

		//get store
		$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all", array());

		$arr_store = array();
		$this->data['code_domain'] = '';
		if (!empty($storeData->status) && $storeData->status == 200 && !empty($stores)) {
			foreach ($stores as $key => $store) {
				$arr_store += [$key => $store->store_id];
			}

			foreach ($storeData->data as $key => $value) {
				if ($value->status != 'active' || !in_array($value->_id->{'$oid'}, $arr_store)) {
					unset($storeData->data[$key]);

				} else {
					$area = $this->api->apiPost($this->userInfo['token'], "area/get_area_by_code", array('code' => $value->code_area));
					if (!empty($area->status) && $area->status == 200) {
						$this->data['code_domain'] = $area->data->domain->code;
					}
				}

			}
			$this->data['stores'] = $storeData->data;
		} else {
			$this->data['stores'] = array();
		}
		$config = $this->api->apiPost($this->userInfo['token'], "config_gic/get_config", array('code' => "TN_TNNNV"));
		if (!empty($config->status) && $config->status == 200) {
			$this->data['tilekhoanvay'] = (!empty($config->data->TyLePhi)) ? $config->data->TyLePhi : 0;
		}
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$customer_phone_number = !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$property = !empty($_GET['property']) ? $_GET['property'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$customer_identify = !empty($_GET['customer_identify']) ? $_GET['customer_identify'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$asset_name = !empty($_GET['asset_name']) ? $_GET['asset_name'] : "";
		$search_htv = !empty($_GET['search_htv']) ? $_GET['search_htv'] : "";
		$ngay_giai_ngan = !empty($_GET['ngay_giai_ngan']) ? $_GET['ngay_giai_ngan'] : 1;
		$phone_number_relative = !empty($_GET['phone_number_relative']) ? $_GET['phone_number_relative'] : "";
		$fullname_relative = !empty($_GET['fullname_relative']) ? $_GET['fullname_relative'] : "";
		$type_contract_digital = !empty($_GET['type_contract_digital']) ? $_GET['type_contract_digital'] : "";
		if ($status == 17) {
			$ngay_giai_ngan = 2;
		}
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
		if (!empty($asset_name)) {
			$data['asset_name'] = $asset_name;
		}
		if (!empty($search_htv)) {
			$data['search_htv'] = $search_htv;
		}
		if (!empty($ngay_giai_ngan)) {
			$data['ngaygiaingan'] = $ngay_giai_ngan;
		}
		if (!empty($property)) {
			$data['property'] = $property;
		}
		if (!empty($status)) {
			$data['status'] = $status;
		}
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
		if (!empty($store)) {
			$data['store'] = $store;
		}
		if (!empty($phone_number_relative)) {
			$data['phone_number_relative'] = $phone_number_relative;
		}
		if (!empty($fullname_relative)) {
			$data['fullname_relative'] = $fullname_relative;
		}
		if (!empty($type_contract_digital)) {
			$data['type_contract_digital'] = $type_contract_digital;
		}

		// call api get count contract
		$countContractData = $this->api->apiPost($this->userInfo['token'], "contract/get_count_all", $data);
		if (!empty($countContractData->status) && $countContractData->status == 200 && $countContractData->data != 0) {

			$count = $countContractData->data;
			$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
			$config = $this->config->item('pagination');
			$config['base_url'] = base_url('pawn/search?code_contract=' . $code_contract . '&code_contract_disbursement=' . $code_contract_disbursement . '&fdate=' . $start . '&tdate=' . $end . '&property=' . $property . '&status=' . $status . '&customer_name=' . $customer_name . '&customer_phone_number=' . $customer_phone_number . '&store=' . $store . '&asset_name=' . $asset_name . '&search_htv=' . $search_htv . '&ngay_giai_ngan=' . $ngay_giai_ngan . '&fullname_relative=' . $fullname_relative . '&phone_number_relative=' . $phone_number_relative . '&type_contract_digital=' . $type_contract_digital);
			$config['total_rows'] = $count;
			$config['per_page'] = 30;
			$config['page_query_string'] = true;
			$config['uri_segment'] = $uriSegment;
			$this->pagination->initialize($config);

			$this->data['pagination'] = $this->pagination->create_links();
			// call api get contract data

			$data['per_page'] = $config['per_page'];
			$data['uriSegment'] = $config['uri_segment'];
			$this->data['countContract'] = $count;
			$contractData = $this->api->apiPost($this->userInfo['token'], "contract/get_all_data", $data);
			if (!empty($contractData->status) && $contractData->status == 200) {
				$this->data['contractData'] = $contractData->data;
				$this->data['count'] = $contractData->count;
			} else {
				$this->data['contractData'] = array();
				$this->data['count'] = [];
			}

		} else {
			$this->data['contractData'] = array();
		}

		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		$listInvestor = $this->api->apiPost($this->userInfo['token'], "investor/get_all");
		if ($listInvestor->status == 200) {
			$this->data['listInvestor'] = $listInvestor->data;
		}

		//get property main ( tài sản cấp cao nhất parenid == null)
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main");
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$this->data['mainPropertyData'] = $mainPropertyData->data;
		} else {
			$this->data['mainPropertyData'] = array();
		}
		$this->data['template'] = 'page/pawn/contract';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function search_cc()
	{
		$this->data["pageName"] = $this->lang->line('manage_contract') . ' cơ cấu';
		$this->data['tilekhoanvay'] = 0;
		$stores = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active", $data);
		$this->data['stores'] = $stores->data;
		$config = $this->api->apiPost($this->userInfo['token'], "config_gic/get_config", array('code' => "TN_TNNNV"));
		if (!empty($config->status) && $config->status == 200) {
			$this->data['tilekhoanvay'] = (!empty($config->data->TyLePhi)) ? $config->data->TyLePhi : 0;
		}
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$customer_phone_number = !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$property = !empty($_GET['property']) ? $_GET['property'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$customer_identify = !empty($_GET['customer_identify']) ? $_GET['customer_identify'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$asset_name = !empty($_GET['asset_name']) ? $_GET['asset_name'] : "";
		$search_htv = !empty($_GET['search_htv']) ? $_GET['search_htv'] : "";

		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('pawn/contract_cocau'));
		}
		$data = array();
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$data = array(
				"start" => $start,
				"end" => $end,
			);
		}
		if (!empty($asset_name)) {
			$data['asset_name'] = $asset_name;
		}
		if (!empty($search_htv)) {
			$data['search_htv'] = $search_htv;
		}
		if (!empty($property)) {
			$data['property'] = $property;
		}
		if (!empty($status)) {
			$data['status'] = $status;
		}
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
		if (!empty($store)) {
			$data['store'] = $store;
		}
		$data['type_contract'] = "CC";
		// call api get count contract
		$countContractData = $this->api->apiPost($this->userInfo['token'], "contract/get_count_all", $data);
		if (!empty($countContractData->status) && $countContractData->status == 200 && $countContractData->data != 0) {

			$count = $countContractData->data;
			$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
			$config = $this->config->item('pagination');
			$config['base_url'] = base_url('pawn/search_cc?code_contract=' . $code_contract . '&code_contract_disbursement=' . $code_contract_disbursement . '&fdate=' . $start . '&tdate=' . $end . '&property=' . $property . '&status=' . $status . '&customer_name=' . $customer_name . '&customer_phone_number=' . $customer_phone_number . '&store=' . $store . '&asset_name=' . $asset_name . '&search_htv=' . $search_htv);
			$config['total_rows'] = $count;
			$config['per_page'] = 30;
			$config['page_query_string'] = true;
			$config['uri_segment'] = $uriSegment;
			$this->pagination->initialize($config);

			$this->data['pagination'] = $this->pagination->create_links();
			// call api get contract data

			$data['per_page'] = $config['per_page'];
			$data['uriSegment'] = $config['uri_segment'];

			$this->data['countContract'] = $count;

			$contractData = $this->api->apiPost($this->userInfo['token'], "contract/get_all_data", $data);
			if (!empty($contractData->status) && $contractData->status == 200) {
				$this->data['contractData'] = $contractData->data;
			} else {
				$this->data['contractData'] = array();
			}

		} else {
			$this->data['contractData'] = array();
		}

		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		$listInvestor = $this->api->apiPost($this->userInfo['token'], "investor/get_all");
		if ($listInvestor->status == 200) {
			$this->data['listInvestor'] = $listInvestor->data;
		}

		//get property main ( tài sản cấp cao nhất parenid == null)
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main");
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$this->data['mainPropertyData'] = $mainPropertyData->data;
		} else {
			$this->data['mainPropertyData'] = array();
		}
		$this->data['template'] = 'page/pawn/contract_cocau';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function search_gh()
	{
		$this->data["pageName"] = $this->lang->line('manage_contract') . ' gia hạn';
		$this->data['tilekhoanvay'] = 0;
		$stores = $this->api->apiPost($this->userInfo['token'], "store/get_store_status_active", $data);
		$this->data['stores'] = $stores->data;
		$config = $this->api->apiPost($this->userInfo['token'], "config_gic/get_config", array('code' => "TN_TNNNV"));
		if (!empty($config->status) && $config->status == 200) {
			$this->data['tilekhoanvay'] = (!empty($config->data->TyLePhi)) ? $config->data->TyLePhi : 0;
		}
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$customer_phone_number = !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$property = !empty($_GET['property']) ? $_GET['property'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$customer_identify = !empty($_GET['customer_identify']) ? $_GET['customer_identify'] : "";
		$store = !empty($_GET['store']) ? $_GET['store'] : "";
		$asset_name = !empty($_GET['asset_name']) ? $_GET['asset_name'] : "";
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
		if (!empty($asset_name)) {
			$data['asset_name'] = $asset_name;
		}
		if (!empty($search_htv)) {
			$data['search_htv'] = $search_htv;
		}
		if (!empty($property)) {
			$data['property'] = $property;
		}
		if (!empty($status)) {
			$data['status'] = $status;
		}
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
		if (!empty($store)) {
			$data['store'] = $store;
		}
		$data['type_contract'] = "GH";
		// call api get count contract
		$countContractData = $this->api->apiPost($this->userInfo['token'], "contract/get_count_all", $data);
		if (!empty($countContractData->status) && $countContractData->status == 200 && $countContractData->data != 0) {

			$count = $countContractData->data;
			$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
			$config = $this->config->item('pagination');
			$config['base_url'] = base_url('pawn/search_gh?code_contract=' . $code_contract . '&code_contract_disbursement=' . $code_contract_disbursement . '&fdate=' . $start . '&tdate=' . $end . '&property=' . $property . '&status=' . $status . '&customer_name=' . $customer_name . '&customer_phone_number=' . $customer_phone_number . '&store=' . $store . '&asset_name=' . $asset_name . '&search_htv=' . $search_htv);
			$config['total_rows'] = $count;
			$config['per_page'] = 30;
			$config['page_query_string'] = true;
			$config['uri_segment'] = $uriSegment;
			$this->pagination->initialize($config);

			$this->data['pagination'] = $this->pagination->create_links();
			// call api get contract data

			$data['per_page'] = $config['per_page'];
			$data['uriSegment'] = $config['uri_segment'];
			$this->data['countContract'] = $count;

			$contractData = $this->api->apiPost($this->userInfo['token'], "contract/get_all_data", $data);
			if (!empty($contractData->status) && $contractData->status == 200) {
				$this->data['contractData'] = $contractData->data;
			} else {
				$this->data['contractData'] = array();
			}

		} else {
			$this->data['contractData'] = array();
		}

		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		$listInvestor = $this->api->apiPost($this->userInfo['token'], "investor/get_all");
		if ($listInvestor->status == 200) {
			$this->data['listInvestor'] = $listInvestor->data;
		}

		//get property main ( tài sản cấp cao nhất parenid == null)
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main");
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$this->data['mainPropertyData'] = $mainPropertyData->data;
		} else {
			$this->data['mainPropertyData'] = array();
		}
		$this->data['template'] = 'page/pawn/contract_giahan';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function search_import()
	{
		$this->data["pageName"] = $this->lang->line('manage_contract');
		$this->data['tilekhoanvay'] = 0;
		$config = $this->api->apiPost($this->userInfo['token'], "config_gic/get_config", array('code' => "TN_TNNNV"));
		if (!empty($config->status) && $config->status == 200) {
			$this->data['tilekhoanvay'] = (!empty($config->data->TyLePhi)) ? $config->data->TyLePhi : 0;
		}
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$customer_phone_number = !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$property = !empty($_GET['property']) ? $_GET['property'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$customer_identify = !empty($_GET['customer_identify']) ? $_GET['customer_identify'] : "";
		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('pawn/contract_import'));
		}
		$data = array(
			"type_ct" => "old_contract"
		);
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$data = array(
				"start" => $start,
				"end" => $end,
			);
		}

		if (!empty($property)) {
			$data['property'] = $property;
		}
		if (!empty($status)) {
			$data['status'] = $status;
		}
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
		// call api get count contract
		$countContractData = $this->api->apiPost($this->userInfo['token'], "contract/get_count_all", $data);
		if (!empty($countContractData->status) && $countContractData->status == 200 && $countContractData->data != 0) {
			$count = $countContractData->data;
			$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
			$config = $this->config->item('pagination');
			$config['base_url'] = base_url('pawn/search_import?code_contract=' . $code_contract . '&code_contract_disbursement=' . $code_contract_disbursement . '&fdate=' . $start . '&tdate=' . $end . '&property=' . $property . '&status=' . $status . '&customer_name=' . $customer_name . '&customer_phone_number' . $customer_phone_number);
			$config['total_rows'] = $count;
			$config['per_page'] = 50;
			$config['page_query_string'] = true;
			$config['uri_segment'] = $uriSegment;
			$this->pagination->initialize($config);

			$this->data['pagination'] = $this->pagination->create_links();
			// call api get contract data
			$data['per_page'] = $config['per_page'];
			$data['uriSegment'] = $config['uri_segment'];
			$data['type_ct'] = 'old_contract';
			$contractData = $this->api->apiPost($this->userInfo['token'], "contract/get_all_data", $data);
			if (!empty($contractData->status) && $contractData->status == 200) {
				$this->data['contractData'] = $contractData->data;
			} else {
				$this->data['contractData'] = array();
			}

		} else {
			$this->data['contractData'] = array();
		}

		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		$listInvestor = $this->api->apiPost($this->userInfo['token'], "investor/get_all");
		if ($listInvestor->status == 200) {
			$this->data['listInvestor'] = $listInvestor->data;
		}

		//get property main ( tài sản cấp cao nhất parenid == null)
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main");
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$this->data['mainPropertyData'] = $mainPropertyData->data;
		} else {
			$this->data['mainPropertyData'] = array();
		}
		$this->data['template'] = 'page/pawn/contract_import';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function spreadsheetFeeLoan()
	{
		$amount_money = !empty($_POST['amount_money']) ? $_POST['amount_money'] : 0;
		$type_loan = !empty($_POST) ? $_POST : "";
		$number_day_loan = !empty($_POST['number_day_loan']) ? $_POST['number_day_loan'] : 0;
		$period_pay_interest = !empty($_POST['period_pay_interest']) ? $_POST['period_pay_interest'] : 0;
		$type_interest = !empty($_POST['type_interest']) ? $_POST['type_interest'] : 0;
		$insurrance = !empty($_POST['insurrance']) ? $_POST['insurrance'] : "";
		$date_payment = !empty($_POST['date_payment']) ? strtotime($_POST['date_payment']) : 0;
		$number_date_payment = 0;

		$amount_money = $this->security->xss_clean($amount_money);
		$type_loan = $this->security->xss_clean($type_loan);
		$number_day_loan = $this->security->xss_clean($number_day_loan);
		$period_pay_interest = $this->security->xss_clean($period_pay_interest);
		$type_interest = $this->security->xss_clean($type_interest);
		$insurrance = $this->security->xss_clean($insurrance);
		$date_payment = $this->security->xss_clean($date_payment);


		//bang tính khoan vay
		$data_khoan_vay = array();


		// get thông tin phí vay
		$dataPhi = array();
		$phi_vay = $this->api->apiPost($this->userInfo['token'], "contract/bang_phi_vay", $dataPhi);
		$pham_tram_phi_tu_van = "";
		$pham_tram_phi_tham_dinh = "";
		if (!empty($phi_vay->status) && $phi_vay->status == 200) {
			foreach ($phi_vay->data as $key => $phi) {
				if ($phi->code == 'phi_tu_van') {
					$pham_tram_phi_tu_van = !empty($phi->percent) ? $phi->percent : 0;
				}
				if ($phi->code == 'phi_tham_dinh') {
					$pham_tram_phi_tham_dinh = !empty($phi->percent) ? $phi->percent : 0;
				}
				if ($phi->code == 'phi_bao_hiem') {
					$percent_insurrance = !empty($phi->percent) ? $phi->percent : 0;
				}
			}
		}
		//phí bảo hiểm
		if ($insurrance == 'true') {
			$fee_insurrance = $amount_money * $percent_insurrance;
		} else {
			$fee_insurrance = 0;
		}
		$tien_goc = $amount_money + $fee_insurrance;

		$number_date_payment = $period_pay_interest;

		// số kỳ vay
		$so_ky_vay = (int)$number_day_loan / (int)$period_pay_interest;
		if ($type_loan == 1) {
			// trường hợp cầm cố chỉ có 1 hình thức lãi hàng tháng gốc cuối kỳ và chỉ cho vay ngắn hạn max 30 ngày
			if (!empty($date_payment)) {
				// truong hop tất toán trước hạn
				//số ngày vay thực tế = $date_payment -  time now
				$date_payment = $date_payment - time();
				$number_date_payment = 0;
				if ($date_payment > 0) {
					$number_date_payment = (int)ceil($date_payment / (60 * 60 * 24));

				}

				//block số ngày vay thực tế trường hợp cầm đồ
				if ($number_date_payment <= 10) {
					$number_date_payment = 10;
				} elseif ($number_date_payment > 10 && $number_date_payment <= 20) {
					$number_date_payment = 20;
				} elseif ($number_date_payment > 20 && $number_date_payment <= 30) {
					$number_date_payment = 30;
				}

			}
			if ($type_interest == 2) {
				// hình thức lãi hàng tháng gốc cuối kỳ

				//lãi 1 kỳ
				//number_date_payment => số ngày vay thục thế
				$lai_ky = round(($number_date_payment * $tien_goc * 0.18) / 365);

				//phí tư vấn
				$phi_tu_van = 0;
				if (!empty($pham_tram_phi_tham_dinh)) {
					$phi_tu_van = $tien_goc * $pham_tram_phi_tham_dinh;
				}
				//phí dịch vu
				$phi_tham_dinh = 0;
				if (!empty($pham_tram_phi_tham_dinh)) {
					$phi_tham_dinh = $tien_goc * $pham_tram_phi_tham_dinh;
				}

				//tổng phí lãi 1 kỳ
				if (empty($date_payment)) {
					$phi_lai = 0.081 * $tien_goc;
				} else {
					$phi_lai = $lai_ky + $phi_tu_van + $phi_tham_dinh;
				}
				// var_dump($phi_lai);die;
				//tiền tất toán
				$tien_tat_toan = $phi_lai + $tien_goc;

				//khoan vay 1 ky
				for ($i = 1; $i <= $so_ky_vay; $i++) {
					if ($i == $so_ky_vay) {
						$lai_ky = round(($number_date_payment * $tien_goc * 0.18) / 365);
					}
					$ky_tra = $i;
					$data_1ky = array(
						'ky_tra' => $ky_tra,
						'phi_lai' => $phi_lai,
						'phi_tu_van' => $phi_tu_van,
						'phi_tham_dinh' => $phi_tham_dinh,
						'lai_ky' => $lai_ky,
						'tien_tat_toan' => $tien_tat_toan
					);
					array_push($data_khoan_vay, $data_1ky);
				}


				//total phai tra
				//tổng tiền trả kỳ
				$tong_tien_tra_ky = $phi_lai * $so_ky_vay;
				//tổng tiền tất toán
				$tong_tien_tat_toan = $tong_tien_tra_ky + $tien_goc;
				//tổng tiền phí tư vấn
				$tong_phi_tu_van = $phi_tu_van * $so_ky_vay;
				//tổng tiền phí thẩm định
				$tong_phi_tham_dinh = $phi_tham_dinh * $so_ky_vay;
				//tổng tiền lãi kỳ
				$tong_lai_ky = $lai_ky * $so_ky_vay;

				$data_total = array(
					"tong_tien_tra_ky" => $tong_tien_tra_ky,
					"tong_tien_tat_toan" => $tong_tien_tat_toan,
					"tong_phi_tu_van" => $tong_phi_tu_van,
					"tong_phi_tham_dinh" => $tong_phi_tham_dinh,
					"tong_lai_ky" => $tong_lai_ky
				);

				$response = [
					'res' => true,
					'status' => "200",
					'message' => $this->lang->line('success'),
					'data' => $data_khoan_vay,
					'data_total' => $data_total
				];
				echo json_encode($response);
				return;

			} else {
				$response = [
					'res' => false,
					'status' => "400",
					'message' => $this->lang->line('can_not_pay_method'),
				];
				echo json_encode($response);
				return;
			}
		} else {
			// trường hợp giấy tờ xe
			if ($type_interest == 1) {
				//hinh thức dư giảm dần
				//sô ngày vay thực tế kỳ cuối
				// $number_date_payment_ky_cuoi = (int)$number_day_loan%(int)$number_day_loan;
				$number_date_payment_ky_cuoi = 0;


				//tiền trả 1 kỳ pow(2, -3)
				$tien_tra_1_ky = round(($tien_goc * 0.081) / (1 - pow((1 + 0.081), -$so_ky_vay)));

				//tiền trả 1 kỳ làm tròn
				$round_tien_tra_1_ky = round($tien_tra_1_ky, -1);

				//gốc còn lại
				$tien_goc_con = $tien_goc;

				//tong cac loai phi
				$tong_phi_tu_van = 0;
				$tong_phi_tham_dinh = 0;

				// truong hop tất toán trước hạn
				if (!empty($date_payment)) {
					//số ngày vay thực tế = $date_payment -  time now

					$date_payment = $date_payment - time();
					$number_date_payment = 0;
					if ($date_payment > 0) {
						$number_date_payment = (int)ceil($date_payment / (60 * 60 * 24));
					}
					$kyvay = (int)$number_date_payment / (int)$period_pay_interest;

					$so_ky_vay = ceil((int)$number_date_payment / (int)$period_pay_interest);
					$number_date_payment_ky_cuoi = $number_date_payment - (int)$kyvay * (int)$period_pay_interest;

				}

				//khoan vay 1 ky
				for ($i = 1; $i <= $so_ky_vay; $i++) {
					//kỳ trả
					$ky_tra = $i;
					//lãi
					$lai_ky = round(($period_pay_interest * $tien_goc_con * 0.18) / 365);
					//tổng phí lãi 1 kỳ
					$tong_phi_lai = 0.081 * $tien_goc_con;
					//tiền gốc
					$tien_goc_1ky = $tien_tra_1_ky - $tong_phi_lai;
					//phí tư vấn
					$phi_tu_van = "";
					if (!empty($pham_tram_phi_tu_van)) {
						$phi_tu_van = $tien_goc_con * $pham_tram_phi_tu_van;
					}

					//phí dịch vu
					$phi_tham_dinh = "";
					if (!empty($pham_tram_phi_tham_dinh)) {
						$phi_tham_dinh = $tien_goc_con * $pham_tram_phi_tham_dinh;
					}
					//tiền gốc còn lại
					$tien_goc_con -= $tien_goc_1ky;

					//tiền tất toán
					$tien_tat_toan = $tien_tra_1_ky + $tien_goc_con;

					// tiền phạt tất toán;
					$tien_phat_tat_toan = 0;

					if ($i == $so_ky_vay) {
						if ($number_date_payment_ky_cuoi != 0 && !empty($date_payment)) {
							$lai_ky = round(($number_date_payment_ky_cuoi * $tien_goc * 0.18) / 365);
							$tien_tra_1_ky = $tien_goc_con;
							$round_tien_tra_1_ky = round($tien_tra_1_ky);
							$tien_goc_1ky = $tien_tra_1_ky - $tong_phi_lai;

							// tiền phạt tất toán;
							if ($number_date_payment < $number_day_loan * 0.3) {
								// phat tất toán 8% tổng tiền gốc còn
								$tien_phat_tat_toan = $tien_goc_con * 0.8;
							} elseif ($number_date_payment < $number_day_loan * 0.6 && $number_date_payment > $number_day_loan * 0.3) {
								// phat tất toán 5% tổng tiền gốc còn
								$tien_phat_tat_toan = $tien_goc_con * 0.5;
							} elseif ($number_date_payment < $number_day_loan * 0.9 && $number_date_payment > $number_day_loan * 0.6) {
								// phat tất toán 5% tổng tiền gốc còn
								$tien_phat_tat_toan = $tien_goc_con * 0.3;
							}

							$tien_goc_con = 0;
						}
					}

					$data_1ky = array(
						'ky_tra' => $ky_tra,
						'tien_tra_1_ky' => $tien_tra_1_ky,
						'round_tien_tra_1_ky' => $round_tien_tra_1_ky,
						'tien_goc_1ky' => $tien_goc_1ky,
						'tong_phi_lai' => $tong_phi_lai,
						'phi_tu_van' => $phi_tu_van,
						'phi_tham_dinh' => $phi_tham_dinh,
						'lai_ky' => $lai_ky,
						'tien_goc_con' => $tien_goc_con,
						'tien_tat_toan' => $tien_tat_toan,


					);
					array_push($data_khoan_vay, $data_1ky);

					//tổng phí tư vấn
					$tong_phi_tu_van += $phi_tu_van;
					//tổng phí dịch vụ
					$tong_phi_tham_dinh += $phi_tham_dinh;
				}
				//total phai tra
				//tổng tiền trả kỳ
				$tong_tien_tra_ky = $tien_tra_1_ky * $so_ky_vay;
				//tổng tiền tra kỳ làm tròn
				$tong_round_tien_tra_ky = $round_tien_tra_1_ky * $so_ky_vay;
				$dataTotal = array(
					"tong_tien_tra_ky" => $tong_tien_tra_ky,
					"tong_round_tien_tra_ky" => $tong_round_tien_tra_ky,
					"tong_phi_tu_van" => $tong_phi_tu_van,
					"tong_phi_tham_dinh" => $tong_phi_tham_dinh,
					'tien_phat_tat_toan' => $tien_phat_tat_toan
				);

				$response = [
					'res' => true,
					'status' => "200",
					'message' => $this->lang->line('success'),
					'data' => $data_khoan_vay,
					'dataTotal' => $dataTotal,
				];
				echo json_encode($response);
				return;


			} else {
				// hình thức lãi hàng tháng gốc cuối kỳ
				//tổng phí lãi 1 kỳ
				$phi_lai = 0.081 * $tien_goc;

				//lãi 1 kỳ
				//number_date_payment => số ngày vay thục thế

				$lai_ky = round(($period_pay_interest * $tien_goc * 0.18) / 365);

				//tiền tất toán
				$tien_tat_toan = $phi_lai + $tien_goc;

				//phí tư vấn
				$phi_tu_van = 0;
				if (!empty($pham_tram_phi_tham_dinh)) {
					$phi_tu_van = $tien_goc * $pham_tram_phi_tham_dinh;
				}
				//phí dịch vu
				$phi_tham_dinh = 0;
				if (!empty($pham_tram_phi_tham_dinh)) {
					$phi_tham_dinh = $tien_goc * $pham_tram_phi_tham_dinh;
				}

				//khoan vay 1 ky
				for ($i = 1; $i <= $so_ky_vay; $i++) {
					if ($i == $so_ky_vay) {
						$lai_ky = round(($number_date_payment * $tien_goc * 0.18) / 365);
					}
					$ky_tra = $i;
					$data_1ky = array(
						'ky_tra' => $ky_tra,
						'phi_lai' => $phi_lai,
						'phi_tu_van' => $phi_tu_van,
						'phi_tham_dinh' => $phi_tham_dinh,
						'lai_ky' => $lai_ky,
						'tien_tat_toan' => $tien_tat_toan
					);
					array_push($data_khoan_vay, $data_1ky);
				}


				//total phai tra
				//tổng tiền trả kỳ
				$tong_tien_tra_ky = $phi_lai * $so_ky_vay;
				//tổng tiền tất toán
				$tong_tien_tat_toan = $tong_tien_tra_ky + $tien_goc;
				//tổng tiền phí tư vấn
				$tong_phi_tu_van = $phi_tu_van * $so_ky_vay;
				//tổng tiền phí thẩm định
				$tong_phi_tham_dinh = $phi_tham_dinh * $so_ky_vay;
				//tổng tiền lãi kỳ
				$tong_lai_ky = $lai_ky * $so_ky_vay;

				$data_total = array(
					"tong_tien_tra_ky" => $tong_tien_tra_ky,
					"tong_tien_tat_toan" => $tong_tien_tat_toan,
					"tong_phi_tu_van" => $tong_phi_tu_van,
					"tong_phi_tham_dinh" => $tong_phi_tham_dinh,
					"tong_lai_ky" => $tong_lai_ky
				);

				$response = [
					'res' => true,
					'status' => "200",
					'message' => $this->lang->line('success'),
					'data' => $data_khoan_vay,
					'data_total' => $data_total
				];
				echo json_encode($response);
				return;
			}

		}

	}

	public function feeTable()
	{
		$configuration_formality = $this->api->apiPost($this->userInfo['token'], "configuration_formality/get_configuration_formality");
		if (!empty($configuration_formality->status) && $configuration_formality->status == 200) {
			$this->data['configuration_formality'] = $configuration_formality->data;
		} else {
			$this->data['configuration_formality'] = array();
		}
		$this->data["pageName"] = $this->lang->line('manage_contract');
		$this->data['template'] = 'page/pawn/fee_table';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function updateDisbursement()
	{
		$data = $this->input->get();
		$data['id'] = $this->security->xss_clean($data['id']);
		//Get information
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		if ($contract->status == 200) {
			//  //get bank vimo
			//  $bankVimoData = $this->api->apiPost($this->userInfo['token'], "BankVimo/get_all");
			//  if(!empty($bankVimoData->status) && $bankVimoData->status == 200){
			//      $this->data['bankVimoData'] = $bankVimoData->data;
			//  }else{
			//      $this->data['bankVimoData'] = array();
			//  }
			//get bank ngan luong
			$bankNganluongData = $this->api->apiPost($this->userInfo['token'], "bankNganLuong/get_all", array("account_type => 3"));
			if (!empty($bankNganluongData->status) && $bankNganluongData->status == 200) {
				$this->data['bankNganluongData'] = $bankNganluongData->data;
			} else {
				$this->data['bankNganluongData'] = array();
			}

			$this->data["pageName"] = $this->lang->line('update_contract');
			$this->data['template'] = 'page/pawn/update_disbursement_contract';
			$this->data['contractInfor'] = $contract->data;
			$this->load->view('template', isset($this->data) ? $this->data : NULL);
		}
	}

	public function updateFee()
	{

		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		$percent_interest_customer = !empty($_POST['percent_interest_customer']) ? $_POST['percent_interest_customer'] : "";
		$percent_advisory = !empty($_POST['percent_advisory']) ? $_POST['percent_advisory'] : "";
		$percent_expertise = !empty($_POST['percent_expertise']) ? $_POST['percent_expertise'] : "";
		$percent_prepay_phase_1 = !empty($_POST['percent_prepay_phase_1']) ? $_POST['percent_prepay_phase_1'] : "";
		$percent_prepay_phase_2 = !empty($_POST['percent_prepay_phase_2']) ? $_POST['percent_prepay_phase_2'] : "";
		$percent_prepay_phase_3 = !empty($_POST['percent_prepay_phase_3']) ? $_POST['percent_prepay_phase_3'] : "";


		// end
		$sendApi = array(
			'id' => $data['id'],
			"percent_interest_customer" => $percent_interest_customer,
			"percent_advisory" => $percent_advisory,
			"percent_expertise" => $percent_expertise,
			"percent_prepay_phase_1" => $percent_prepay_phase_1,
			"percent_prepay_phase_2" => $percent_prepay_phase_2,
			"percent_prepay_phase_3" => $percent_prepay_phase_3,
		);
		$return = $this->api->apiPost($this->user['token'], "contract/process_update_fee", $sendApi);

		if (!empty($return->status) && $return->status == 200) {
			$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
			if ($contract->status == 200) {
				$data_delete = array(
					"code_contract" => $contract->data->code_contract,
				);
				$result_delete_and_update = $this->api->apiPost($this->userInfo['token'], "contract/delete_lai_ky_lai_thang", $data_delete);
				if (!empty($result_delete_and_update->status) && $result_delete_and_update->status == 200) {

					$investor_code = $contract->data->investor_code;
					$dataPost_dele = array(
						"code_contract" => $contract->data->code_contract,
						"investor_code" => $investor_code,
						"disbursement_date" => $contract->data->disbursement_date
					);
					$processContract = $this->api->apiPost($this->userInfo['token'], "generateContract/processContract", $dataPost_dele);
					if (!empty($processContract->status) && $processContract->status == 200) {
						$dataPost = array(
							"code_contract" => $contract->data->code_contract,
							"investor_code" => $investor_code,
							"disbursement_date" => $contract->data->disbursement_date
						);
						$payment_all_contract = $this->api->apiPost($this->userInfo['token'], "transaction/payment_all_contract", $dataPost);
						if (!empty($payment_all_contract->status) && $payment_all_contract->status == 200) {

							$response = [
								'res' => true,
								'code' => "200",
								'msg' => 'Chạy phí thành công mã phiếu ghi : ' . $contract->data->code_contract,
								'url' => $result->url
							];
							//echo json_encode($response);
							$this->pushJson('200', json_encode($response));
							return;
						} else {
							$response = [
								'res' => false,
								'code' => "200",
								'msg' => 'Thành công',
								'data' => $result
							];
							$this->pushJson('200', json_encode($response));
							return;
						}
					}
				} else {
					$this->pushJson('200', json_encode(array('res' => false, "code" => "400", "data" => $return, "msg" => 'Xóa lãi kỳ lỗi')));
					return;
				}
			} else {
				$this->pushJson('200', json_encode(array('res' => false, "code" => "400", "data" => $return, "msg" => 'Không tìm thấy hợp đồng')));
				return;
			}
		} else {
			$this->pushJson('200', json_encode(array('res' => false, "code" => "400", "data" => $return, "msg" => $return->data->message)));
			return;
		}


	}

	public function getFeeByCoupon()
	{

		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['code_coupon'] = $this->security->xss_clean($data['code_coupon']);

		if (empty($data['code_coupon'])) {
			$this->pushJson('200', json_encode(array("code" => "400", "msg" => "Bạn cần chọn coupon")));
		}

		// end
		$sendApi = array(
			'id' => $data['id'],
			'code_coupon' => $data['code_coupon']
		);
		$return = $this->api->apiPost($this->user['token'], "contract/process_get_fee", $sendApi);

		if (!empty($return->status) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return, "msg" => "update fee success")));
		} else {
			$this->pushJson('200', json_encode(array("code" => "400", "data" => $return, "msg" => $return->message)));
		}


	}

	public function updateDisbursementContract()
	{

		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['receiver_infor'] = $this->security->xss_clean($data['receiver_infor']);
		// end
		$sendApi = array(
			'id' => $data['id'],
			'receiver_infor' => $data['receiver_infor'],
		);
		$return = $this->api->apiPost($this->user['token'], "contract/process_update_disbursement_contract", $sendApi);
		$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));

	}

	public function update()
	{
		$data = $this->input->get();
		$data['id'] = $this->security->xss_clean($data['id']);
		$this->data['tilekhoanvay'] = 0;
		$config = $this->api->apiPost($this->userInfo['token'], "config_gic/get_config", array('code' => "TN_TNNNV"));
		if (!empty($config->status) && $config->status == 200) {
			$this->data['tilekhoanvay'] = (!empty($config->data->TyLePhi)) ? $config->data->TyLePhi : 0;
		}
		//Get information
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		if ($contract->status == 200) {
			$id_store = $contract->data->store->id;
			$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
			if (!empty($groupRoles->status) && $groupRoles->status == 200) {
				$this->data['groupRoles'] = $groupRoles->data;
			} else {
				$this->data['groupRoles'] = array();
			}
			//get hình thức vay
			$configuration_formality = $this->api->apiPost($this->userInfo['token'], "configuration_formality/get_configuration_formality");
			if (!empty($configuration_formality->status) && $configuration_formality->status == 200) {
				$this->data['configuration_formality'] = $configuration_formality->data;
			} else {
				$this->data['configuration_formality'] = array();
			}
			//get property main ( tài sản cấp cao nhất parenid == null)
			$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main");
			if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
				$this->data['mainPropertyData'] = $mainPropertyData->data;
			} else {
				$this->data['mainPropertyData'] = array();
			}
			//Init loan infor
			$arrMinus = array();
			if (!empty($contract->data->loan_infor->decreaseProperty)) {
				$decreaseProperty = $contract->data->loan_infor->decreaseProperty;
				foreach ($decreaseProperty as $item) {
					$a = array();
					$a['checked'] = $item->checked;
					$a['name'] = $item->name;
					$a['slug'] = $item->slug;
					$a['price'] = $item->value;
					array_push($arrMinus, $a);
				}
			}
			$data = array(
				"id" => $contract->data->loan_infor->name_property->id,
				"code_type_property" => $contract->data->loan_infor->type_property->code,
				"type_loan" => $contract->data->loan_infor->type_loan->code
			);
			$price_property = "";
			$percent = "";
			$depreciationData = $this->api->apiPost($this->userInfo['token'], "property/get_depreciation_by_property", $data);
			if (!empty($depreciationData->status) && $depreciationData->status == 200) {

				$price_property = $depreciationData->price_property;
				$percent = $depreciationData->percent;
				$price_goc = $depreciationData->price_goc;


			}
			// var_dump($this->data['mainPropertyData'] ); die;
			$dataLoanInfor = array(
				"type_finance" => !empty($contract->data->loan_infor->type_loan->id) ? $contract->data->loan_infor->type_loan->id : "",
				"main" => !empty($contract->data->loan_infor->type_property->id) ? $contract->data->loan_infor->type_property->id : "",
				"sub" => !empty($contract->data->loan_infor->name_property->id) ? $contract->data->loan_infor->name_property->id : "",
				"subName" => !empty($contract->data->loan_infor->name_property->text) ? $contract->data->loan_infor->name_property->text : "",
				"minus" => $arrMinus,
				"price_property" => $price_property,
				"price_goc" => $price_goc,
				"percent" => $percent,
				"rootPrice" => !empty($contract->data->loan_infor->price_property) ? $contract->data->loan_infor->price_property : "",
				"loan_product" => !empty($contract->data->loan_infor->loan_product->code) ? $contract->data->loan_infor->loan_product->code : "",
				"editPrice" => !empty($contract->data->loan_infor->amount_money_max) ? $contract->data->loan_infor->amount_money_max : ""
			);
			//Start Địa chỉ đang ở
			$provinceSelected = $contract->data->current_address->province;
			$districtSelected = $contract->data->current_address->district;
			$provinceData = $this->api->apiPost($this->userInfo['token'], "province/get_province");
			if (!empty($provinceData->status) && $provinceData->status == 200) {
				$this->data['provinceData'] = $provinceData->data;
			} else {
				$this->data['provinceData'] = array();
			}
			$districtData = $this->api->apiPost($this->userInfo['token'], "province/get_district_by_province", array("id" => $provinceSelected));
			if (!empty($districtData->status) && $districtData->status == 200) {
				$this->data['districtData'] = $districtData->data;
			} else {
				$this->data['districtData'] = array();
			}
			$wardData = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtSelected));
			if (!empty($wardData->status) && $wardData->status == 200) {
				$this->data['wardData'] = $wardData->data;
			} else {
				$this->data['wardData'] = array();
			}
			//End
			//Start Địa chỉ hộ khẩu
			$provinceSelected_ = $contract->data->houseHold_address->province;
			$districtSelected_ = $contract->data->houseHold_address->district;
			$provinceData_ = $this->api->apiPost($this->userInfo['token'], "province/get_province");
			if (!empty($provinceData_->status) && $provinceData_->status == 200) {
				$this->data['provinceData_'] = $provinceData_->data;
			} else {
				$this->data['provinceData_'] = array();
			}
			//get district by province
			$districtData_ = $this->api->apiPost($this->userInfo['token'], "province/get_district_by_province", array("id" => $provinceSelected_));
			if (!empty($districtData_->status) && $districtData_->status == 200) {
				$this->data['districtData_'] = $districtData_->data;
			} else {
				$this->data['districtData_'] = array();
			}
			//get ward by district
			$wardData_ = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtSelected_));
			if (!empty($wardData_->status) && $wardData_->status == 200) {
				$this->data['wardData_'] = $wardData_->data;
			} else {
				$this->data['wardData_'] = array();
			}
			//End

			//get bank vimo
			// $bankVimoData = $this->api->apiPost($this->userInfo['token'], "BankVimo/get_all");
			// if(!empty($bankVimoData->status) && $bankVimoData->status == 200){
			//     $this->data['bankVimoData'] = $bankVimoData->data;
			// }else{
			//     $this->data['bankVimoData'] = array();
			// }
			//get bank ngan luong
			$bankNganluongData = $this->api->apiPost($this->userInfo['token'], "bankNganLuong/get_all", array("account_type => 3"));
			if (!empty($bankNganluongData->status) && $bankNganluongData->status == 200) {
				$this->data['bankNganluongData'] = $bankNganluongData->data;
			} else {
				$this->data['bankNganluongData'] = array();
			}
			$fee = $this->api->apiPost($this->userInfo['token'], "feeLoanNew/get_all", array());
			if (!empty($fee->status) && $fee->status == 200) {
				$this->data['fee_data'] = $fee->data;
			} else {
				$this->data['fee_data'] = array();
			}
			// var_dump($this->data['fee_data']); die;
			// get history log
			// $work_follow = $this->api->apiPost($this->userInfo['token'], "log/get_log_contract", array("contract_id" => $data['id']));
			// if(!empty($work_follow->status) && $work_follow->status == 200){
			//     $this->data['work_follow'] = $work_follow->data;
			// }else{
			//     $this->data['work_follow'] = array();
			// }
			$userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
			$stores = !empty($userInfo['stores']) ? $userInfo['stores'] : array();

			//get store
			$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all", array());
			$arr_store = array();
            $store_id='';
			$this->data['code_domain'] = '';
			if (!empty($storeData->status) && $storeData->status == 200) {
				if (!in_array('hoi-so', $this->data['groupRoles'])) {
					if (!empty($stores)) {

						foreach ($stores as $key => $store) {
							$arr_store += [$key => $store->store_id];
							$store_id=$store->store_id;
						}

						foreach ($storeData->data as $key => $value) {
							if ($value->status != 'active' || !in_array($value->_id->{'$oid'}, $arr_store)) {
								unset($storeData->data[$key]);
							} else {
							
								$area = $this->api->apiPost($this->userInfo['token'], "area/get_area_by_code", array('code' => $value->code_area));
								if (!empty($area->status) && $area->status == 200) {
									$this->data['code_domain'] = $area->data->domain->code;
								}
							}

						}
					}
				}
				$this->data['stores'] = $storeData->data;
			} else {
				$this->data['stores'] = array();
			}
			$storeDataCentral = $this->api->apiPost($this->userInfo['token'], "Store/getAllStoreCentralNoneDirectSales", array());
			if (!empty($storeDataCentral->status) && $storeDataCentral->status == 200) {
				$this->data['storeDataCentral'] = $storeDataCentral->data;
			} else {
				$this->data['storeDataCentral'] = array();
			}
			// get pti vta fee
			$pti_vta_fee = $this->api->apiPost($this->userInfo['token'],"Pti_vta_fee/list_pti_fee",[]);
			if (!empty($pti_vta_fee->status) && $pti_vta_fee->status == 200) {
				$this->data['pti_vta_fee'] = $pti_vta_fee->data;
			} else {
				$this->data['pti_vta_fee'] = array();
			}
			//get coupon
			if (in_array('hoi-so', $this->data['groupRoles'])) {
				$couponData = $this->api->apiPost($this->userInfo['token'], "coupon/get_all");
				//var_dump($contract); die;
				if (!empty($couponData->status) && $couponData->status == 200) {
					$this->data['couponData'] = $couponData->data;
				} else {
					$this->data['couponData'] = array();
				}
			} else {
				$couponData = $this->api->apiPost($this->userInfo['token'], "coupon/get_all_home", array('created_at' => $contract->data->created_at, 'type_property' => $contract->data->loan_infor->type_property->id, 'type_loan' => $contract->data->loan_infor->type_loan->id, 'number_day_loan' => $contract->data->loan_infor->number_day_loan / 30, 'loan_product' => $contract->data->loan_infor->loan_product->code, 'store_id' =>$store_id));
				//var_dump($contract); die;
				if (!empty($couponData->status) && $couponData->status == 200) {
					$this->data['couponData'] = $couponData->data;
				} else {
					$this->data['couponData'] = array();
				}
			}
			$list_storage = $this->api->apiPost($this->userInfo['token'], "car_storage/get_all_car_storage");
			if (!empty($list_storage->status) && $list_storage->status == 200) {
				$this->data['list_storage'] = $list_storage->data;
			} else {
				$this->data['list_storage'] = array();
			}
			$list_ctv = $this->api->apiPost($this->userInfo['token'], "collaborator/get_all_collaborator_model");
			if (!empty($list_ctv->status) && $list_ctv->status == 200) {
				$this->data['list_ctv'] = $list_ctv->data;
			} else {
				$this->data['list_ctv'] = array();
			}

			$company_storage_phone = [
				'check_phone' => $contract->data->customer_infor->customer_phone_number
			];
			$company_storage = $this->api->apiPost($this->userInfo['token'], "company_storage/get_all_company_storage", $company_storage_phone);
			if (!empty($company_storage->status) && $company_storage->status == 200) {
				$this->data['company_storage'] = $company_storage->data;
			} else {
				$this->data['company_storage'] = array();
			}

			$this->data['dataInit'] = $dataLoanInfor;
			$this->data["pageName"] = $this->lang->line('update_contract');
			$nhom_xe = $this->api->apiPost($this->userInfo['token'], "vbi_tnds/get_danh_muc_xe", ['option' => "NHOM_XE"]);
			$hieu_xe = $this->api->apiPost($this->userInfo['token'], "vbi_tnds/get_danh_muc_xe", ['option' => "HIEU_XE"]);
			$hang_xe = $this->api->apiPost($this->userInfo['token'], "vbi_tnds/get_danh_muc_xe", ['option' => "HANG_XE"]);
			$this->data['nhom_xe'] = $nhom_xe->data;
			$this->data['hieu_xe'] = $hieu_xe->data;
			$this->data['hang_xe'] = $hang_xe->data;
			$nextpay = $this->api->apiPost($this->userInfo['token'], "nextpay/check_group_next_pay", ['user_id'=>$this->userInfo['id']]);
			if (!empty($nextpay->status) && $nextpay->status == 200) {
				$this->data['user_nextpay'] = $nextpay->data;
			}else{
				$this->data['user_nextpay'] = 0;
			}
			$store_digital = $this->api->apiPost($this->userInfo['token'], "nextpay/check_store_create_contract_digital", ['store_id'=> $id_store]);
			if (!empty($store_digital->status) && $store_digital->status == 200) {
				$this->data['store_digital'] = $store_digital->data;
			} else {
				$this->data['store_digital'] = 0;
			}

			//List seri mã định vị
			$listSeri = $this->apiListSeriPositioningDevices();
			$this->data['listSeri'] = $listSeri;

			$this->data['template'] = 'page/pawn/new_update_contract';
			// $this->data['template'] = 'page/pawn/update';
			$this->data['contractInfor'] = $contract->data;
			$this->load->view('template', isset($this->data) ? $this->data : NULL);
		} else {

		}

	}

	public function show_callhistory()
	{
		$data = $this->input->post();
		$data['phone_number'] = $this->security->xss_clean($data['phone_number']);
		// end
		$sendApi = array(
			'phone_number' => base64_decode($data['phone_number'])
		);
		$return = $this->api->apiPost($this->user['token'], "recording/get_reccord_by_phone_number", $sendApi);
		$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
	}

	public function detail()
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$data = $this->input->get();
		$data['id'] = $this->security->xss_clean($data['id']);
		$log_contract_thn = $this->api->apiPost($this->userInfo['token'], "log_contract_thn/get_one", array("id" => $data['id']));
		if (!empty($log_contract_thn->status) && $log_contract_thn->status == 200) {
			$this->data['log_contract_thn'] = isset($log_contract_thn->data->new) ? $log_contract_thn->data->new : '';
			$this->data['address_log'] = isset($log_contract_thn->data->new->address) ? $log_contract_thn->data->new->address : '';

		} else {
			$this->data['log_contract_thn'] = array();

		}
		$this->data['tilekhoanvay'] = 0;
		$config = $this->api->apiPost($this->userInfo['token'], "config_gic/get_config", array('code' => "TN_TNNNV"));
		if (!empty($config->status) && $config->status == 200) {
			$this->data['tilekhoanvay'] = (!empty($config->data->TyLePhi)) ? $config->data->TyLePhi : 0;
		}
		//Get information
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		if ($contract->status == 200) {
			//get hình thức vay
			$configuration_formality = $this->api->apiPost($this->userInfo['token'], "configuration_formality/get_configuration_formality");
			if (!empty($configuration_formality->status) && $configuration_formality->status == 200) {
				$this->data['configuration_formality'] = $configuration_formality->data;
			} else {
				$this->data['configuration_formality'] = array();
			}
			//get property main ( tài sản cấp cao nhất parenid == null)
			$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main");
			if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
				$this->data['mainPropertyData'] = $mainPropertyData->data;
			} else {
				$this->data['mainPropertyData'] = array();
			}
			//Init loan infor
			$arrMinus = array();
			if (!empty($contract->data->loan_infor->decreaseProperty)) {
				$decreaseProperty = $contract->data->loan_infor->decreaseProperty;
				foreach ($decreaseProperty as $item) {
					$a = array();
					$a['checked'] = !empty($item->checked) ? $item->checked : '';
					$a['name'] = !empty($item->name) ? $item->name : '';
					$a['slug'] = !empty($item->slug) ? $item->slug : '';
					$a['price'] = !empty($item->value) ? $item->value : '';
					array_push($arrMinus, $a);
				}
			}
			$dataLoanInfor = array(
				"type_finance" => !empty($contract->data->loan_infor->type_loan->id) ? $contract->data->loan_infor->type_loan->id : "",
				"main" => !empty($contract->data->loan_infor->type_property->id) ? $contract->data->loan_infor->type_property->id : "",
				"sub" => !empty($contract->data->loan_infor->name_property->id) ? $contract->data->loan_infor->name_property->id : "",
				"subName" => !empty($contract->data->loan_infor->name_property->text) ? $contract->data->loan_infor->name_property->text : "",
				"minus" => $arrMinus,
				"rootPrice" => !empty($contract->data->loan_infor->price_property) ? $contract->data->loan_infor->price_property : "",
				"loan_product" => !empty($contract->data->loan_infor->loan_product->code) ? $contract->data->loan_infor->loan_product->code : "",
				"editPrice" => !empty($contract->data->loan_infor->amount_money_max) ? $contract->data->loan_infor->amount_money_max : ""
			);
			//Start Địa chỉ đang ở
			$provinceSelected = $contract->data->current_address->province;
			$districtSelected = $contract->data->current_address->district;
			$provinceData = $this->api->apiPost($this->userInfo['token'], "province/get_province");
			if (!empty($provinceData->status) && $provinceData->status == 200) {
				$this->data['provinceData'] = $provinceData->data;
			} else {
				$this->data['provinceData'] = array();
			}
			$districtData = $this->api->apiPost($this->userInfo['token'], "province/get_district_by_province", array("id" => $provinceSelected));
			if (!empty($districtData->status) && $districtData->status == 200) {
				$this->data['districtData'] = $districtData->data;
			} else {
				$this->data['districtData'] = array();
			}
			$wardData = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtSelected));
			if (!empty($wardData->status) && $wardData->status == 200) {
				$this->data['wardData'] = $wardData->data;
			} else {
				$this->data['wardData'] = array();
			}
			//End
			//Start Địa chỉ hộ khẩu
			$provinceSelected_ = $contract->data->houseHold_address->province;
			$districtSelected_ = $contract->data->houseHold_address->district;
			$provinceData_ = $this->api->apiPost($this->userInfo['token'], "province/get_province");
			if (!empty($provinceData_->status) && $provinceData_->status == 200) {
				$this->data['provinceData_'] = $provinceData_->data;
			} else {
				$this->data['provinceData_'] = array();
			}
			//get district by province
			$districtData_ = $this->api->apiPost($this->userInfo['token'], "province/get_district_by_province", array("id" => $provinceSelected_));
			if (!empty($districtData_->status) && $districtData_->status == 200) {
				$this->data['districtData_'] = $districtData_->data;
			} else {
				$this->data['districtData_'] = array();
			}
			//get ward by district
			$wardData_ = $this->api->apiPost($this->userInfo['token'], "province/get_ward_by_district", array("id" => $districtSelected_));
			if (!empty($wardData_->status) && $wardData_->status == 200) {
				$this->data['wardData_'] = $wardData_->data;
			} else {
				$this->data['wardData_'] = array();
			}
			//End
			$company_storage_phone = [
				'check_phone' => $contract->data->customer_infor->customer_phone_number
			];
			$company_storage = $this->api->apiPost($this->userInfo['token'], "company_storage/get_all_company_storage", $company_storage_phone);
			if (!empty($company_storage->status) && $company_storage->status == 200) {
				$this->data['company_storage'] = $company_storage->data;
			} else {
				$this->data['company_storage'] = array();
			}

			$list_ctv = $this->api->apiPost($this->userInfo['token'], "collaborator/get_all_collaborator_model");
			if (!empty($list_ctv->status) && $list_ctv->status == 200) {
				$this->data['list_ctv'] = $list_ctv->data;
			} else {
				$this->data['list_ctv'] = array();
			}

			$check = [
				"contract_id" => $data['id'],
			];

			$data_hs = $this->api->apiPost($this->userInfo['token'], "hoiso_create/get_create_at_hs_all", $check);

			if (!empty($data_hs->status) && $data_hs->status == 200) {
				$this->data['data_hs'] = $data_hs->data;
			} else {
				$this->data['data_hs'] = array();
			}


		} else {
			$dataLoanInfor = array();
			$this->data['bankVimoData'] = array();
			$this->data['wardData'] = array();
			$this->data['provinceData_'] = array();
			$this->data['districtData'] = array();
			$this->data['configuration_formality'] = array();
			$this->data['mainPropertyData'] = array();
		}

		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));

		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		//get bank vimo
		$bankVimoData = $this->api->apiPost($this->userInfo['token'], "BankVimo/get_all");
		if (!empty($bankVimoData->status) && $bankVimoData->status == 200) {
			$this->data['bankVimoData'] = $bankVimoData->data;
		} else {
			$this->data['bankVimoData'] = array();
		}
		// get history log
		$log = $this->api->apiPost($this->userInfo['token'], "log/get_log_contract", array("contract_id" => $data['id']));
		if (!empty($log->status) && $log->status == 200) {
			$this->data['logs'] = $log->data;
		} else {
			$this->data['logs'] = array();
		}
		// get log change customer source
		$log_source = $this->api->apiPost($this->userInfo['token'], "contract/get_log_change_source", array("contract_id" => $data['id']));
		if (!empty($log_source->status) && $log_source->status == 200) {
			$this->data['logs_change_source'] = $log_source->data;
		} else {
			$this->data['logs_change_source'] = array();
		}

		$dataGet = array(
			"id" => $data['id']
		);
		$contractInfor = $contract->data;
		$money_lead = !empty($contractInfor->loan_infor->amount_money) ? $contractInfor->loan_infor->amount_money : "";
		if ($contractInfor->loan_infor->type_loan->code == 'DKX' && $contractInfor->loan_infor->type_property->code == 'XM') {
			$hinh_thuc_vay = '4';
		}

		if ($contractInfor->loan_infor->type_loan->code == 'DKX' && $contractInfor->loan_infor->type_property->code == 'OTO') {
			$hinh_thuc_vay = '3';
		}

		if ($contractInfor->loan_infor->type_loan->code == 'CC' && $contractInfor->loan_infor->type_property->code == 'XM') {
			$hinh_thuc_vay = '2';
		}

		if ($contractInfor->loan_infor->type_loan->code == 'CC' && $contractInfor->loan_infor->type_property->code == 'OTO') {
			$hinh_thuc_vay = '1';
		}
		$ky_han = !empty($contractInfor->loan_infor->number_day_loan) ? (int)$contractInfor->loan_infor->number_day_loan : 0;
		$hinh_thuc_tra_lai = !empty($contractInfor->loan_infor->type_interest) ? $contractInfor->loan_infor->type_interest : '';
		$typeProperty = !empty($contractInfor->loan_infor->type_property->code) ? $contractInfor->loan_infor->type_property->code : '';
		$management_consulting_fee = !empty($contractInfor->fee->percent_expertise) ? $contractInfor->fee->percent_expertise : 0;
		$renewal_fee = !empty($contractInfor->fee->percent_advisory) ? $contractInfor->fee->percent_advisory : 0;
		$loan_interest = !empty($contractInfor->fee->percent_interest_customer) ? $contractInfor->fee->percent_interest_customer : 0;
		$disbursement_date = !empty($contractInfor->disbursement_date) ? $contractInfor->disbursement_date : 0;
		$code_coupon = !empty($contractInfor->loan_infor->code_coupon) ? $contractInfor->loan_infor->code_coupon : '';
		$code_contract = !empty($contractInfor->code_contract) ? $contractInfor->code_contract : "";
		$tien_giam_tru_bhkv = !empty($contractInfor->tien_giam_tru_bhkv) ? $contractInfor->tien_giam_tru_bhkv : "";
		$cond = array(
			"money_lead" => $money_lead,
			"hinh_thuc_vay" => $hinh_thuc_vay,
			"typeProperty" => $typeProperty,
			"ky_han" => $ky_han,
			"fee" => isset($contractInfor->fee) ? (array)$contractInfor->fee : array(),
			"hinh_thuc_tra_lai" => $hinh_thuc_tra_lai,
			"management_consulting_fee" => $management_consulting_fee,
			"renewal_fee" => $renewal_fee,
			"loan_interest" => $loan_interest,
			"disbursement_date" => $disbursement_date,
			"code_coupon" => $code_coupon,
			"code_contract"=>$code_contract,
			"tien_giam_tru_bhkv"=>$tien_giam_tru_bhkv


		);

		$calucatorData = $this->api->apiPost($this->user['token'], "accountant/caculator_monthly_fee", $cond);
		if (!empty($calucatorData->status) && $calucatorData->status == 200) {
			$this->data['calucatorData'] = $calucatorData->data;
		} else {
			$this->data['calucatorData'] = array();
		}


		$dataPost = array(
			"phone" => $contract->data->customer_infor->customer_phone_number,
			"customer_identify" => $contract->data->customer_infor->customer_identify,
			"customer_identify_old" => $contract->data->customer_infor->customer_identify_old,
			"phone_number_relative_1" => $contract->data->relative_infor->phone_number_relative_1,
			"phone_number_relative_2" => $contract->data->relative_infor->phone_number_relative_2
		);
		$contract_involve = $this->api->apiPost($this->userInfo['token'], "contract/get_contract_check_involve", $dataPost);
		if (!empty($contract_involve->status) && $contract_involve->status == 200) {
			$this->data['contract_involve_phone'] = $contract_involve->data_phone;
			$this->data['contract_involve_identify'] = $contract_involve->data_identify;
			$this->data['contract_involve_identify_old'] = $contract_involve->data_identify_old;
			$this->data['contract_involve_relative_1'] = $contract_involve->data_identify_relative_1;
			$this->data['contract_involve_relative_2'] = $contract_involve->data_identify_relative_2;
		} else {
			$this->data['contract_involve'] = array();
		}
		$fee_id = $this->api->apiPost($this->userInfo['token'], "feeLoanNew/get_all", array());
		if (!empty($fee_id->status) && $fee_id->status == 200) {
			$this->data['fee_data'] = $fee_id->data;
		} else {
			$this->data['fee_data'] = array();
		}
		//        $dataVerifyIdentify = $this->api->apiPost($this->userInfo['token'], "contract/get_info_verify_identify", array('contract_id' => $data['id']));
		// $this->data['verify_identify'] = $dataVerifyIdentify->data;
		$tai_san = $contract->data->property_infor;
		if (!empty($tai_san)) {
			if ($contract->data->loan_infor->type_property->code == "NĐ") {
				foreach ($tai_san as $ts) {
					if ($ts->slug == 'thua-dat-so') {
						$thua_dat_so = $ts->value;
					}
				}
				$asset = $this->api->apiPost($this->userInfo['token'], "asset_manager/check_asset_estate", ['thua-dat-so' => $thua_dat_so]);
				if ($asset->status == 200) {
					$this->data['asset'] = $asset->data;
				}
			} else {
				foreach ($tai_san as $ts) {
					if ($ts->slug == 'so-khung') {
						$so_khung = $ts->value;
					}
					if ($ts->slug == 'so-may') {
						$so_may = $ts->value;
					}
				}
				$asset = $this->api->apiPost($this->userInfo['token'], "asset_manager/check_asset", ['so_khung' => $so_khung, 'so_may' => $so_may]);
				if ($asset->status == 200) {
					$this->data['asset'] = $asset->data;
				}
			}
		}
		$giahanData = $this->api->apiPost($this->userInfo['token'], "contract_cc_gh/get_list_gh", ['id_contract' => $data['id']]);
		if (!empty($giahanData->status) && $giahanData->status == 200) {
			$this->data['data_tab_gia_han'] = $giahanData->data;
		} else {
			$this->data['data_tab_gia_han'] = array();
		}
		$cocauData = $this->api->apiPost($this->userInfo['token'], "contract_cc_gh/get_list_cc", ['id_contract' => $data['id']]);
		if (!empty($cocauData->status) && $cocauData->status == 200) {
			$this->data['data_tab_co_cau'] = $cocauData->data;
		} else {
			$this->data['data_tab_co_cau'] = array();
		}

		//get_store
		$get_store = $this->api->apiPost($this->userInfo['token'], "store/get_all_follow_pgd");
		if (!empty($get_store->status) && $get_store->status == 200) {
			$this->data['get_store'] = $get_store->data;
		} else {
			$this->data['get_store'] = array();
		}
		//get_log_followContract

		$log_followContract = $this->api->apiPost($this->userInfo['token'], "store/get_log_followContract", ['id_contract' => $data['id']]);

		if (!empty($log_followContract->status) && $log_followContract->status == 200) {
			$this->data['log_followContract'] = $log_followContract->data;
		} else {
			$this->data['log_followContract'] = array();
		}
		$nextpay = $this->api->apiPost($this->userInfo['token'], "nextpay/check_store_next_pay", ['store_id'=>$contract->data->store->id]);
		if (!empty($nextpay->status) && $nextpay->status == 200) {
			$this->data['user_nextpay'] = $nextpay->data;
		}else{
			$this->data['user_nextpay'] = 0;
		}
		$store_digital = $this->api->apiPost($this->userInfo['token'], "nextpay/check_store_create_contract_digital", ['store_id'=> $contract->data->store->id]);
		if (!empty($store_digital->status) && $store_digital->status == 200) {
			$this->data['store_digital'] = $store_digital->data;
		}else{
			$this->data['store_digital'] = 0;
		}

		$contractExempted = $this->api->apiPost($this->userInfo['token'], "exemptions/getContractExemption", ['id_contract' => $data["id"]]);
		$this->data['contractExempted'] = $contractExempted->data;

		//getIdentify contractExemption
		$identify = $this->api->apiPost($this->userInfo['token'], "exemptions/getIdentify", ['id_contract' => $data["id"]]);
		if (!empty($identify->status) && $identify->status == 200) {
			$this->data['identify'] = $identify->data;
		} else {
			$this->data['identify'] = false;
		}
		$sms_megadoc_fail = $this->api->apiPost($this->userInfo['token'], "contract/get_sms_megadoc_fail", ['code_contract' => $code_contract]);
		if (!empty($sms_megadoc_fail->status) && $sms_megadoc_fail->status == 200) {
			$this->data['sms_megadoc'] = $sms_megadoc_fail->data;
		 } else {
			$this->data['sms_megadoc'] = array();
		}

		//Hiển thị ảnh
		$get_image = $this->api->apiPost($this->userInfo['token'], "contract/get_image_accurecy", $dataGet);
		$this->data['result'] = $get_image->data;


		$this->data['dataInit'] = $dataLoanInfor;
		$this->data["pageName"] = $this->lang->line('detail_loan_contract');
		//get role khởi tạo thanh lý
		$role_liq = $this->api->apiPost($this->userInfo['token'], 'LiquidationAssetContract/get_role_create_liquidation',[]);
		if (!empty($role_liq->data)) {
			$this->data["role_liq"] = $role_liq->data;
		} else {
			$this->data["role_liq"] = array();
		}
		//get role Hủy thanh lý
		$role_cancel_liq = $this->api->apiPost($this->userInfo['token'], 'LiquidationAssetContract/get_role_cancel_liquidation',[]);
		if (!empty($role_liq->data)) {
			$this->data["role_cancel_liq"] = $role_cancel_liq->data;
		} else {
			$this->data["role_cancel_liq"] = array();
		}

		//List seri mã định vị
		$listSeri = $this->apiListSeriPositioningDevices();
		$this->data['listSeri'] = $listSeri;

		//check property fake or not
		$property = $this->api->apiPost($this->userInfo['token'], "property_blacklist/checkPropertyBlacklistInDetailContract", ['id' => $data["id"]]);
		if (!empty($property->status) && $property->status == 200) {
			$this->data['property'] = $property->data;
			$this->data['property_id'] = $property->id;
		} else {
			$this->data['property'] = false;
		}


		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			if (in_array('ke-toan', $groupRoles->data)){

				$dataPost = array(
					"id" => $data['id']
				);
				$dataContract = $this->api->apiPost($this->user['token'], "contract/get_one", $dataPost);
				$this->data['type_contract'] = !empty($dataContract->data->customer_infor->type_contract_sign) ? $dataContract->data->customer_infor->type_contract_sign : '2';

				$this->data['template'] = 'page/pawn/view_ketoan_new/detail_contract_kt';
//				$this->data['template'] = 'page/pawn/detail_contract';
			} else {
				$this->data['template'] = 'page/pawn/detail_contract';
			}
		} else {
			$this->data['template'] = 'page/pawn/detail_contract';
		}

		$this->data['detail'] = 1;
		$this->data['contractInfor'] = $contract->data;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function printed()
	{
		$data = $this->input->get();
		$data['id'] = $this->security->xss_clean($data['id']);
		//Get information
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		$address = '';
		if ($contract->status == 200) {
			//Start Địa chỉ đang ở
			$contractInfo = $contract->data;
			$address = $contractInfo->current_address->current_stay . ', ' . $contractInfo->current_address->ward_name . ', ' . $contractInfo->current_address->district_name . ', ' . $contractInfo->current_address->province_name;
			//End
		}

		if ($contract->status == 200) {
			//Start Địa chỉ hổ khẩu
			$address_house = '';
			$address_house = $contractInfo->houseHold_address->address_household . ', ' . $contractInfo->houseHold_address->ward_name . ', ' . $contractInfo->houseHold_address->district_name . ', ' . $contractInfo->houseHold_address->province_name;
			//End
		}
		//get bank vimo
		$bank_id = $contract->data->receiver_infor->bank_id;
		$bankVimoData = $this->api->apiPost($this->userInfo['token'], "BankVimo/get_bank_name", array('bank_id' => $bank_id));
		$bank_name = '';
		if (!empty($bankVimoData->status) && $bankVimoData->status == 200) {
			$bank_name = $bankVimoData->data->name;
		}
		$bank_id = $contract->data->receiver_infor->bank_id;
		$bankNganLuongData = $this->api->apiPost($this->userInfo['token'], "bankNganLuong/get_bank_name", array('bank_id' => $bank_id));
		$bank_name_nganluong = '';
		if (!empty($bankNganLuongData->status) && $bankNganLuongData->status == 200) {
			$bank_name_nganluong = $bankNganLuongData->data->name;
		}

		$condition = array(
			'insurrance' => isset($contract->data->loan_infor->insurrance_contract) ? $contract->data->loan_infor->insurrance_contract : '',
			'type_interest' => $contract->data->loan_infor->type_interest,
			'period_pay_interest' => $contract->data->loan_infor->period_pay_interest,
			'number_day_loan' => $contract->data->loan_infor->number_day_loan,
			'amount_money' => $contract->data->loan_infor->amount_money,
			'code_contract' => $contract->data->code_contract,
		);
		$money_per_month = $this->api->apiPost($this->userInfo['token'], "generateContract/getMoneyPerMonth", $condition);
		$money = '';
		if (!empty($money_per_month->status) && $money_per_month->status == 200) {
			$money = $money_per_month->data;
		}
		$property = !empty($contract->data->property_infor) ? $contract->data->property_infor : array();
		$sokhung = '';
		$somay = '';
		$bienkiemsoat = '';
		$nhanhieu = '';
		$model = '';
		$chuxe = '';
		$diachidangky = '';
		$sodangky = '';
		$ngaycapdangky = '';
		foreach ($property as $p) {
			if ($p->slug === 'bien-so-xe') {
				$bienkiemsoat = $p->value;
			} elseif ($p->slug === 'so-khung') {
				$sokhung = $p->value;
			} elseif ($p->slug === 'so-may') {
				$somay = $p->value;
			} elseif ($p->slug === 'nhan-hieu') {
				$nhanhieu = $p->value;
			} elseif ($p->slug === 'model') {
				$model = $p->value;
			} elseif ($p->slug === 'ho-ten-chu-xe') {
				$chuxe = $p->value;
			} elseif ($p->slug === 'dia-chi-dang-ky') {
				$diachidangky = $p->value;
			} elseif ($p->slug === 'so-dang-ky') {
				$sodangky = $p->value;
			} elseif ($p->slug === 'ngay-cap') {
				$ngaycapdangky = $p->value;
			} elseif ($p->slug === 'ngay-cap-dang-ky') {
				$ngaycapdangkyoto = $p->value;
			}
		}

		$company_name = '';
		$company_address = '';
		$role = '';
		$work_year = '';
		$loan_purpose = $contract->data->loan_infor->loan_purpose;
		if (!empty($contract->data->job_infor->name_company)) {
			$company_name = $contract->data->job_infor->name_company;
		}
		if (!empty($contract->data->job_infor->address_company)) {
			$company_address = $contract->data->job_infor->address_company;
		}
		if (!empty($contract->data->job_infor->job_position)) {
			$role = $contract->data->job_infor->job_position;
		}
		if (!empty($contract->data->job_infor->work_year)) {
			$work_year = $contract->data->job_infor->work_year;
		}

		$customerDOB = '';
		if (!empty($contract->data->customer_infor->customer_BOD)) {
			$dobArray = explode('-', $contract->data->customer_infor->customer_BOD);
			$customerDOB = $dobArray[2] . '-' . $dobArray[1] . '-' . $dobArray[0];
		}
		$customerPhone = '';
		if (!empty($contract->data->customer_infor->customer_phone_number)) {
			$customerPhone = $contract->data->customer_infor->customer_phone_number;
		}
		// var_dump($contract->data->store->id); die;
		$store = $this->api->apiPost($this->userInfo['token'], "store/get_store", array('id' => $contract->data->store->id));
		if (!empty($store->status) && $store->status == 200) {
			$this->data['store'] = $store->data;
		} else {
			$this->data['store'] = array();
		}
		$storeAddress = '';
		if (!empty($contract->data->store->address)) {
			$storeAddress = $contract->data->store->address;
		}
		$codeContract = '';
		if (!empty($contract->data->code_contract_disbursement)) {
			$codeContract = $contract->data->code_contract_disbursement;
		}
		$identify_date_range = '';
		if (!empty($contract->data->customer_infor->date_range)) {
			$date_range_array = explode('-', $contract->data->customer_infor->date_range);
			$identify_date_range = $date_range_array[2] . '-' . $date_range_array[1] . '-' . $date_range_array[0];
		}
		$this->data['identify_date_range'] = $identify_date_range;
		$this->data['contract'] = $contract->data;
		$this->data['money'] = $money;
		$this->data['bank_name'] = $bank_name;
		$this->data['address'] = $address;
		$this->data['address_house'] = $address_house;
		$this->data['sokhung'] = $sokhung;
		$this->data['somay'] = $somay;
		$this->data['nhanhieu'] = $nhanhieu;
		$this->data['model'] = $model;
		$this->data['chuxe'] = $chuxe;
		$this->data['diachidangky'] = $diachidangky;
		$this->data['sodangky'] = $sodangky;
		$this->data['ngaycapdangky'] = $ngaycapdangky;
		$this->data['ngaycapdangkyoto'] = $ngaycapdangkyoto;
		$this->data['bienkiemsoat'] = $bienkiemsoat;
		$this->data['customerDOB'] = $customerDOB;
		$this->data['customerPhone'] = $customerPhone;
		$this->data['storeAddress'] = $storeAddress;
		$this->data['code_contract'] = $codeContract;
		$this->data['company_name'] = $company_name;
		$this->data['company_address'] = $company_address;
		$this->data['role'] = $role;
		$this->data['bank_name_nganluong'] = $bank_name_nganluong;
		$this->data['loan_purpose'] = $loan_purpose;
		$pgd_dong_bac = $this->api->apiPost($this->userInfo['token'], "tcv_dong_bac/get_store_tcv_dong_bac");
		$list_id_store_branch_hcm = $this->api->apiPost($this->userInfo['token'], 'Store/getStoreBranchHCM', []);
		$id_pgd_dong_bac = explode(' ', $pgd_dong_bac->id_store);
		if (in_array($contract->data->store->id, $id_pgd_dong_bac)) {
			$this->load->view('contract_printed/thoathuanbaben_chovay/chovay_tcvdb.php', isset($this->data) ? $this->data : NULL);
		} elseif (in_array($contract->data->store->id, $list_id_store_branch_hcm->data)) {
			$this->load->view('contract_printed/thoathuanbaben_chovay/chovay_tcvhcm.php', isset($this->data) ? $this->data : NULL);
		} else {
			$this->load->view('contract_printed/thoathuanbaben_chovay/chovay_tcv.php', isset($this->data) ? $this->data : NULL);
		}
		return;
	}

	public function printed_phuluc01()
	{
		$data = $this->input->get();
		$data['id'] = $this->security->xss_clean($data['id']);
		//Get information
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		$address = '';
		if ($contract->status == 200) {
			//Start Địa chỉ đang ở
			$contractInfo = $contract->data;
			$address = $contractInfo->current_address->current_stay . ', ' . $contractInfo->current_address->ward_name . ', ' . $contractInfo->current_address->district_name . ', ' . $contractInfo->current_address->province_name;
			//End
		}

		if ($contract->status == 200) {
			//Start Địa chỉ hổ khẩu
			$address_house = '';
			$address_house = $contractInfo->houseHold_address->address_household . ', ' . $contractInfo->houseHold_address->ward_name . ', ' . $contractInfo->houseHold_address->district_name . ', ' . $contractInfo->houseHold_address->province_name;
			//End
		}
		//get bank vimo
		$bank_id = $contract->data->receiver_infor->bank_id;
		$bankVimoData = $this->api->apiPost($this->userInfo['token'], "BankVimo/get_bank_name", array('bank_id' => $bank_id));
		$bank_name = '';
		if (!empty($bankVimoData->status) && $bankVimoData->status == 200) {
			$bank_name = $bankVimoData->data->name;
		}
		$bank_id = $contract->data->receiver_infor->bank_id;
		$bankNganLuongData = $this->api->apiPost($this->userInfo['token'], "bankNganLuong/get_bank_name", array('bank_id' => $bank_id));
		$bank_name_nganluong = '';
		if (!empty($bankNganLuongData->status) && $bankNganLuongData->status == 200) {
			$bank_name_nganluong = $bankNganLuongData->data->name;
		}

		$condition = array(
			'insurrance' => isset($contract->data->loan_infor->insurrance_contract) ? $contract->data->loan_infor->insurrance_contract : '',
			'type_interest' => $contract->data->loan_infor->type_interest,
			'period_pay_interest' => $contract->data->loan_infor->period_pay_interest,
			'number_day_loan' => $contract->data->loan_infor->number_day_loan,
			'amount_money' => $contract->data->loan_infor->amount_money,
			'code_contract' => $contract->data->code_contract,
		);
		$money_per_month = $this->api->apiPost($this->userInfo['token'], "generateContract/getMoneyPerMonth", $condition);
		$money = '';
		if (!empty($money_per_month->status) && $money_per_month->status == 200) {
			$money = $money_per_month->data;
		}
		$property = !empty($contract->data->property_infor) ? $contract->data->property_infor : array();
		$sokhung = '';
		$somay = '';
		$bienkiemsoat = '';
		$nhanhieu = '';
		$model = '';
		$chuxe = '';
		$diachidangky = '';
		$sodangky = '';
		$ngaycapdangky = '';
		foreach ($property as $p) {
			if ($p->slug === 'bien-so-xe') {
				$bienkiemsoat = $p->value;
			} elseif ($p->slug === 'so-khung') {
				$sokhung = $p->value;
			} elseif ($p->slug === 'so-may') {
				$somay = $p->value;
			} elseif ($p->slug === 'nhan-hieu') {
				$nhanhieu = $p->value;
			} elseif ($p->slug === 'model') {
				$model = $p->value;
			} elseif ($p->slug === 'ho-ten-chu-xe') {
				$chuxe = $p->value;
			} elseif ($p->slug === 'dia-chi-dang-ky') {
				$diachidangky = $p->value;
			} elseif ($p->slug === 'so-dang-ky') {
				$sodangky = $p->value;
			} elseif ($p->slug === 'ngay-cap') {
				$ngaycapdangky = $p->value;
			}
		}

		$company_name = '';
		$company_address = '';
		$role = '';
		$work_year = '';
		if (!empty($contract->data->job_infor->name_company)) {
			$company_name = $contract->data->job_infor->name_company;
		}
		if (!empty($contract->data->job_infor->address_company)) {
			$company_address = $contract->data->job_infor->address_company;
		}
		if (!empty($contract->data->job_infor->job_position)) {
			$role = $contract->data->job_infor->job_position;
		}
		if (!empty($contract->data->job_infor->work_year)) {
			$work_year = $contract->data->job_infor->work_year;
		}

		$customerDOB = '';
		if (!empty($contract->data->customer_infor->customer_BOD)) {
			$dobArray = explode('-', $contract->data->customer_infor->customer_BOD);
			$customerDOB = $dobArray[2] . '-' . $dobArray[1] . '-' . $dobArray[0];
		}
		$customerPhone = '';
		if (!empty($contract->data->customer_infor->customer_phone_number)) {
			$customerPhone = $contract->data->customer_infor->customer_phone_number;
		}
		$store = $this->api->apiPost($this->userInfo['token'], "store/get_store", array('id' => $contract->data->store->id));
		if (!empty($store->status) && $store->status == 200) {
			$this->data['store'] = $store->data;
		} else {
			$this->data['store'] = array();
		}
		$storeAddress = '';
		if (!empty($contract->data->store->address)) {
			$storeAddress = $contract->data->store->address;
		}
		$codeContract = '';
		if (!empty($contract->data->code_contract_disbursement)) {
			$codeContract = $contract->data->code_contract_disbursement;
		}
		if (in_array($contract->data->status, [11, 25, 29])) {
			$log = $this->api->apiPost($this->userInfo['token'], "log/get_log_gh", array("contract_id" => $data['id']));
			if (!empty($log->status) && $log->status == 200) {
				$logs = $log->data;
			} else {
				$logs = array();
			}
		}
		if (in_array($contract->data->status, [12, 27, 31])) {
			$log = $this->api->apiPost($this->userInfo['token'], "log/get_log_cc", array("contract_id" => $data['id']));
			if (!empty($log->status) && $log->status == 200) {
				$logs = $log->data;
			} else {
				$logs = array();
			}
		}
		$pgd_dong_bac = $this->api->apiPost($this->userInfo['token'], "tcv_dong_bac/get_store_tcv_dong_bac");
		$id_pgd_dong_bac = explode(' ', $pgd_dong_bac->id_store);
		$this->data['contract'] = $contract->data;
		$this->data['money'] = $money;
		$this->data['bank_name'] = $bank_name;
		$this->data['address'] = $address;
		$this->data['address_house'] = $address_house;
		$this->data['sokhung'] = $sokhung;
		$this->data['somay'] = $somay;
		$this->data['nhanhieu'] = $nhanhieu;
		$this->data['model'] = $model;
		$this->data['chuxe'] = $chuxe;
		$this->data['diachidangky'] = $diachidangky;
		$this->data['sodangky'] = $sodangky;
		$this->data['ngaycapdangky'] = $ngaycapdangky;
		$this->data['bienkiemsoat'] = $bienkiemsoat;
		$this->data['customerDOB'] = $customerDOB;
		$this->data['customerPhone'] = $customerPhone;
		$this->data['storeAddress'] = $storeAddress;
		$this->data['code_contract'] = $codeContract;
		$this->data['company_name'] = $company_name;
		$this->data['company_address'] = $company_address;
		$this->data['logs'] = $logs;
		$this->data['role'] = $role;
		$this->data['bank_name_nganluong'] = $bank_name_nganluong;
		if (in_array($contract->data->store->id, $id_pgd_dong_bac)) {
			$this->load->view('contract_printed/contract_printed_phu_luc01_tcvdb', isset($this->data) ? $this->data : NULL);
		} else {
			$this->load->view('contract_printed/contract_printed_phu_luc01', isset($this->data) ? $this->data : NULL);
		}
		return;
	}
    public function printed_bbbg_ky_thoa_thuan()
	{
		$data = $this->input->get();
		$data['id'] = $this->security->xss_clean($data['id']);
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		if ($contract->status == 200) {
			//Start Địa chỉ đang ở
			$contractInfo = $contract->data;
			$address = $contractInfo->current_address->current_stay . ', ' . $contractInfo->current_address->ward_name . ', ' . $contractInfo->current_address->district_name . ', ' . $contractInfo->current_address->province_name;
			//End
		}

		if ($contract->status == 200) {
			//Start Địa chỉ hổ khẩu
			$address_house = '';
			$address_house = $contractInfo->houseHold_address->address_household . ', ' . $contractInfo->houseHold_address->ward_name . ', ' . $contractInfo->houseHold_address->district_name . ', ' . $contractInfo->houseHold_address->province_name;
			//End
		}

		//get bank vimo
		$bank_id = $contract->data->receiver_infor->bank_id;
		$bankVimoData = $this->api->apiPost($this->userInfo['token'], "BankVimo/get_bank_name", array('bank_id' => $bank_id));
		$bank_name = '';
		if (!empty($bankVimoData->status) && $bankVimoData->status == 200) {
			$bank_name = $bankVimoData->data->name;
		}
		$bank_id = $contract->data->receiver_infor->bank_id;
		$bankNganLuongData = $this->api->apiPost($this->userInfo['token'], "bankNganLuong/get_bank_name", array('bank_id' => $bank_id));
		$bank_name_nganluong = '';
		if (!empty($bankNganLuongData->status) && $bankNganLuongData->status == 200) {
			$bank_name_nganluong = $bankNganLuongData->data->name;
		}
        	$identify_date_range = '';
		if (!empty($contract->data->customer_infor->date_range)) {
			$date_range_array = explode('-', $contract->data->customer_infor->date_range);
			$identify_date_range = $date_range_array[2] . '-' . $date_range_array[1] . '-' . $date_range_array[0];
		}
		$condition = array(
			'insurrance' => isset($contract->data->loan_infor->insurrance_contract) ? $contract->data->loan_infor->insurrance_contract : '',
			'type_interest' => $contract->data->loan_infor->type_interest,
			'period_pay_interest' => $contract->data->loan_infor->period_pay_interest,
			'number_day_loan' => $contract->data->loan_infor->number_day_loan,
			'amount_money' => $contract->data->loan_infor->amount_money,
			'code_contract' => $contract->data->code_contract,
		);
		$money_per_month = $this->api->apiPost($this->userInfo['token'], "generateContract/getMoneyPerMonth", $condition);
		$money = '';
		if (!empty($money_per_month->status) && $money_per_month->status == 200) {
			$money = $money_per_month->data;
		}
		$property = !empty($contract->data->property_infor) ? $contract->data->property_infor : array();

		$loai_tai_san = '';
		$thua_dat_so = '';
		$to_ban_do_so = '';
		$dia_chi_thua_dat = '';
		$dien_tich = '';
		$hinh_thuc_su_dung_rieng = '';
		$hinh_thuc_su_dung_chung = '';
		$muc_dich_su_dung = '';
		$thoi_han_su_dung = '';
		$nha_o = '';
		$giay_chung_nhan_so = '';
		$noi_cap = '';
		$ngay_cap = '';
		$so_vao_so = '';
		foreach ($property as $p) {
			if ($p->slug === 'loai-tai-san') {
				$loai_tai_san = $p->value;
			} elseif ($p->slug === 'thua-dat-so') {
				$thua_dat_so = $p->value;
			} elseif ($p->slug === 'to-ban-do-so') {
				$to_ban_do_so = $p->value;
			} elseif ($p->slug === 'dia-chi-thua-dat') {
				$dia_chi_thua_dat = $p->value;
			} elseif ($p->slug === 'dien-tich-m2') {
				$dien_tich = $p->value;
			} elseif ($p->slug === 'hinh-thuc-su-dung-rieng-m2') {
				$hinh_thuc_su_dung_rieng = $p->value;
			} elseif ($p->slug === 'hinh-thuc-su-dung-chung-m2') {
				$hinh_thuc_su_dung_chung = $p->value;
			} elseif ($p->slug === 'muc-dich-su-dung') {
				$muc_dich_su_dung = $p->value;
			} elseif ($p->slug === 'thoi-han-su-dung') {
				$thoi_han_su_dung = $p->value;
			} elseif ($p->slug === 'nha-o-neu-co') {
				$nha_o = $p->value;
			} elseif ($p->slug === 'giay-chung-nhan-so') {
				$giay_chung_nhan_so = $p->value;
			} elseif ($p->slug === 'noi-cap') {
				$noi_cap = $p->value;
			} elseif ($p->slug === 'ngay-cap') {
				$ngay_cap = $p->value;
			} elseif ($p->slug === 'so-vao-so') {
				$so_vao_so = $p->value;
			}
		}

		$company_name = '';
		$company_address = '';
		$role = '';
		if (!empty($contract->data->job_infor->name_company)) {
			$company_name = $contract->data->job_infor->name_company;
		}
		if (!empty($contract->data->job_infor->address_company)) {
			$company_address = $contract->data->job_infor->address_company;
		}
		if (!empty($contract->data->job_infor->job_position)) {
			$role = $contract->data->job_infor->job_position;
		}

		$customerDOB = '';
		if (!empty($contract->data->customer_infor->customer_BOD)) {
			$dobArray = explode('-', $contract->data->customer_infor->customer_BOD);
			$customerDOB = $dobArray[2] . '-' . $dobArray[1] . '-' . $dobArray[0];
		}
		$customerPhone = '';
		if (!empty($contract->data->customer_infor->customer_phone_number)) {
			$customerPhone = $contract->data->customer_infor->customer_phone_number;
		}
		// var_dump($contract->data->store->id); die;
		$store = $this->api->apiPost($this->userInfo['token'], "store/get_store", array('id' => $contract->data->store->id));
		if (!empty($store->status) && $store->status == 200) {
			$this->data['store'] = $store->data;
		} else {
			$this->data['store'] = array();
		}
		$storeAddress = '';
		if (!empty($contract->data->store->address)) {
			$storeAddress = $contract->data->store->address;
		}

		$storeRepresentative = '';
		if (!empty($store->data->representative)) {
			$storeRepresentative = $store->data->representative;
		}
		$codeContract = '';
		if (!empty($contract->data->code_contract_disbursement)) {
			$codeContract = $contract->data->code_contract_disbursement;
		}
		$ten_tai_san= !empty($contract->data->loan_infor->name_property->text) ? $contract->data->loan_infor->name_property->text : "";
		$gia_tai_san= !empty($contract->data->loan_infor->price_property) ? $contract->data->loan_infor->price_property : "";
		$pgd_dong_bac = $this->api->apiPost($this->userInfo['token'], "tcv_dong_bac/get_store_tcv_dong_bac");
		$id_pgd_dong_bac = explode(' ', $pgd_dong_bac->id_store);
		$name_delivery_records = 'BBBG';
		$short_name_province = '';
		$code_address_store = '';
		$current_year_code_contract = date("y");
		$current_month_code_contract = date("m");
		$current_day_code_contract = date("d");
		$current_day_month_year = $current_year_code_contract . $current_month_code_contract . $current_day_code_contract;
		$code_province_store = !empty($store->data->province->name) ? $store->data->province->name : "";
		$code_province_store = vn_to_str_space($code_province_store);
		$array_short_name_province = explode(" ", $code_province_store);
		foreach ($array_short_name_province as $short_name) {
			$short_name_province .= $short_name[0];
		}
		$short_name_province = strtoupper($short_name_province);
		$code_address_store = !empty($store->data->code_address_store) ? $store->data->code_address_store : "";
		$code_delivery_records = $name_delivery_records . "/" . $short_name_province . $code_address_store . "/" . $current_day_month_year . "/";
		$this->data['code_delivery_records'] = $code_delivery_records;
		$this->data['contract'] = $contract->data;
		$this->data['money'] = $money;
		$this->data['bank_name'] = $bank_name;
		$this->data['address'] = $address;
		$this->data['address_house'] = $address_house;
		$this->data['customerDOB'] = $customerDOB;
		$this->data['customerPhone'] = $customerPhone;
		$this->data['identify_date_range'] = $identify_date_range;
		$this->data['storeAddress'] = $storeAddress;
		$this->data['code_contract'] = $codeContract;
		$this->data['company_name'] = $company_name;
		$this->data['company_address'] = $company_address;
		$this->data['storeRepresentative'] = $storeRepresentative;
		$this->data['role'] = $role;
		$this->data['bank_name_nganluong'] = $bank_name_nganluong;
		$this->data['loai_tai_san'] = $loai_tai_san;
		$this->data['thua_dat_so'] = $thua_dat_so;
		$this->data['to_ban_do_so'] = $to_ban_do_so;
		$this->data['dia_chi_thua_dat'] = $dia_chi_thua_dat;
		$this->data['dien_tich'] = $dien_tich;
		$this->data['hinh_thuc_su_dung_rieng'] = $hinh_thuc_su_dung_rieng;
		$this->data['hinh_thuc_su_dung_chung'] = $hinh_thuc_su_dung_chung;
		$this->data['muc_dich_su_dung'] = $muc_dich_su_dung;
		$this->data['thoi_han_su_dung'] = $thoi_han_su_dung;
		$this->data['nha_o'] = $nha_o;
		$this->data['giay_chung_nhan_so'] = $giay_chung_nhan_so;
		$this->data['noi_cap'] = $noi_cap;
		$this->data['ngay_cap'] = $ngay_cap;
		$this->data['so_vao_so'] = $so_vao_so;
		$this->data['ten_tai_san'] = $ten_tai_san;
		$this->data['gia_tai_san'] = $gia_tai_san;
		$list_id_store_branch_hcm = $this->api->apiPost($this->userInfo['token'], 'Store/getStoreBranchHCM', []);
		if (in_array($contract->data->store->id, $id_pgd_dong_bac)) {
			$this->load->view('contract_printed/BBBG_thechap/BBBG_thechap_ban_giao_khi_ky_thoa_thuan_tcvdb', isset($this->data) ? $this->data : NULL);
		} elseif (in_array($contract->data->store->id, $list_id_store_branch_hcm->data)) {
			$this->load->view('contract_printed/BBBG_thechap/BBBG_thechap_ban_giao_khi_ky_thoa_thuan_tcvhcm', isset($this->data) ? $this->data : NULL);
		} else {
			$this->load->view('contract_printed/BBBG_thechap/BBBG_thechap_ban_giao_khi_ky_thoa_thuan', isset($this->data) ? $this->data : NULL);
		}
		return;

	}
	 public function printed_bbbg_the_chap_thanh_ly()
	{
		$data = $this->input->get();
		$data['id'] = $this->security->xss_clean($data['id']);
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		if ($contract->status == 200) {
			//Start Địa chỉ đang ở
			$contractInfo = $contract->data;
			$address = $contractInfo->current_address->current_stay . ', ' . $contractInfo->current_address->ward_name . ', ' . $contractInfo->current_address->district_name . ', ' . $contractInfo->current_address->province_name;
			//End
		}

		if ($contract->status == 200) {
			//Start Địa chỉ hổ khẩu
			$address_house = '';
			$address_house = $contractInfo->houseHold_address->address_household . ', ' . $contractInfo->houseHold_address->ward_name . ', ' . $contractInfo->houseHold_address->district_name . ', ' . $contractInfo->houseHold_address->province_name;
			//End
		}

		//get bank vimo
		$bank_id = $contract->data->receiver_infor->bank_id;
		$bankVimoData = $this->api->apiPost($this->userInfo['token'], "BankVimo/get_bank_name", array('bank_id' => $bank_id));
		$bank_name = '';
		if (!empty($bankVimoData->status) && $bankVimoData->status == 200) {
			$bank_name = $bankVimoData->data->name;
		}
		$bank_id = $contract->data->receiver_infor->bank_id;
		$bankNganLuongData = $this->api->apiPost($this->userInfo['token'], "bankNganLuong/get_bank_name", array('bank_id' => $bank_id));
		$bank_name_nganluong = '';
		if (!empty($bankNganLuongData->status) && $bankNganLuongData->status == 200) {
			$bank_name_nganluong = $bankNganLuongData->data->name;
		}

		$condition = array(
			'insurrance' => isset($contract->data->loan_infor->insurrance_contract) ? $contract->data->loan_infor->insurrance_contract : '',
			'type_interest' => $contract->data->loan_infor->type_interest,
			'period_pay_interest' => $contract->data->loan_infor->period_pay_interest,
			'number_day_loan' => $contract->data->loan_infor->number_day_loan,
			'amount_money' => $contract->data->loan_infor->amount_money,
			'code_contract' => $contract->data->code_contract,
		);
		$money_per_month = $this->api->apiPost($this->userInfo['token'], "generateContract/getMoneyPerMonth", $condition);
		$money = '';
		if (!empty($money_per_month->status) && $money_per_month->status == 200) {
			$money = $money_per_month->data;
		}
		$property = !empty($contract->data->property_infor) ? $contract->data->property_infor : array();

		$loai_tai_san = '';
		$thua_dat_so = '';
		$to_ban_do_so = '';
		$dia_chi_thua_dat = '';
		$dien_tich = '';
		$hinh_thuc_su_dung_rieng = '';
		$hinh_thuc_su_dung_chung = '';
		$muc_dich_su_dung = '';
		$thoi_han_su_dung = '';
		$nha_o = '';
		$giay_chung_nhan_so = '';
		$noi_cap = '';
		$ngay_cap = '';
		$so_vao_so = '';
		foreach ($property as $p) {
			if ($p->slug === 'loai-tai-san') {
				$loai_tai_san = $p->value;
			} elseif ($p->slug === 'thua-dat-so') {
				$thua_dat_so = $p->value;
			} elseif ($p->slug === 'to-ban-do-so') {
				$to_ban_do_so = $p->value;
			} elseif ($p->slug === 'dia-chi-thua-dat') {
				$dia_chi_thua_dat = $p->value;
			} elseif ($p->slug === 'dien-tich-m2') {
				$dien_tich = $p->value;
			} elseif ($p->slug === 'hinh-thuc-su-dung-rieng-m2') {
				$hinh_thuc_su_dung_rieng = $p->value;
			} elseif ($p->slug === 'hinh-thuc-su-dung-chung-m2') {
				$hinh_thuc_su_dung_chung = $p->value;
			} elseif ($p->slug === 'muc-dich-su-dung') {
				$muc_dich_su_dung = $p->value;
			} elseif ($p->slug === 'thoi-han-su-dung') {
				$thoi_han_su_dung = $p->value;
			} elseif ($p->slug === 'nha-o-neu-co') {
				$nha_o = $p->value;
			} elseif ($p->slug === 'giay-chung-nhan-so') {
				$giay_chung_nhan_so = $p->value;
			} elseif ($p->slug === 'noi-cap') {
				$noi_cap = $p->value;
			} elseif ($p->slug === 'ngay-cap') {
				$ngay_cap = $p->value;
			} elseif ($p->slug === 'so-vao-so') {
				$so_vao_so = $p->value;
			}
		}

		$company_name = '';
		$company_address = '';
		$role = '';
		if (!empty($contract->data->job_infor->name_company)) {
			$company_name = $contract->data->job_infor->name_company;
		}
		if (!empty($contract->data->job_infor->address_company)) {
			$company_address = $contract->data->job_infor->address_company;
		}
		if (!empty($contract->data->job_infor->job_position)) {
			$role = $contract->data->job_infor->job_position;
		}

		$customerDOB = '';
		if (!empty($contract->data->customer_infor->customer_BOD)) {
			$dobArray = explode('-', $contract->data->customer_infor->customer_BOD);
			$customerDOB = $dobArray[2] . '-' . $dobArray[1] . '-' . $dobArray[0];
		}
		$customerPhone = '';
		if (!empty($contract->data->customer_infor->customer_phone_number)) {
			$customerPhone = $contract->data->customer_infor->customer_phone_number;
		}
			$identify_date_range = '';
		if (!empty($contract->data->customer_infor->date_range)) {
			$date_range_array = explode('-', $contract->data->customer_infor->date_range);
			$identify_date_range = $date_range_array[2] . '-' . $date_range_array[1] . '-' . $date_range_array[0];
		}
		// var_dump($contract->data->store->id); die;
		$store = $this->api->apiPost($this->userInfo['token'], "store/get_store", array('id' => $contract->data->store->id));
		if (!empty($store->status) && $store->status == 200) {
			$this->data['store'] = $store->data;
		} else {
			$this->data['store'] = array();
		}
		$storeAddress = '';
		if (!empty($contract->data->store->address)) {
			$storeAddress = $contract->data->store->address;
		}
			$storeRepresentative = '';
		if (!empty($store->data->representative)) {
			$storeRepresentative = $store->data->representative;
		}
		$codeContract = '';
		if (!empty($contract->data->code_contract_disbursement)) {
			$codeContract = $contract->data->code_contract_disbursement;
		}
		$pgd_dong_bac = $this->api->apiPost($this->userInfo['token'], "tcv_dong_bac/get_store_tcv_dong_bac");
		$id_pgd_dong_bac = explode(' ', $pgd_dong_bac->id_store);
		$name_delivery_records = 'BBBG';
		$short_name_province = '';
		$code_address_store = '';
		$current_year_code_contract = date("y");
		$current_month_code_contract = date("m");
		$current_day_code_contract = date("d");
		$current_day_month_year = $current_year_code_contract . $current_month_code_contract . $current_day_code_contract;
		$code_province_store = !empty($store->data->province->name) ? $store->data->province->name : "";
		$code_province_store = vn_to_str_space($code_province_store);
		$array_short_name_province = explode(" ", $code_province_store);
		foreach ($array_short_name_province as $short_name) {
			$short_name_province .= $short_name[0];
		}
		$short_name_province = strtoupper($short_name_province);
		$code_address_store = !empty($store->data->code_address_store) ? $store->data->code_address_store : "";
		$code_delivery_records = $name_delivery_records . "/" . $short_name_province . $code_address_store . "/" . $current_day_month_year . "/";
		$this->data['code_delivery_records'] = $code_delivery_records;
		$this->data['contract'] = $contract->data;
		$this->data['money'] = $money;
		$this->data['bank_name'] = $bank_name;
		$this->data['address'] = $address;
		$this->data['identify_date_range'] = $identify_date_range;
		$this->data['address_house'] = $address_house;
		$this->data['customerDOB'] = $customerDOB;
		$this->data['customerPhone'] = $customerPhone;
		$this->data['storeAddress'] = $storeAddress;
		$this->data['code_contract'] = $codeContract;
		$this->data['company_name'] = $company_name;
		$this->data['company_address'] = $company_address;
		$this->data['storeRepresentative'] = $storeRepresentative;
		$this->data['role'] = $role;
		$this->data['bank_name_nganluong'] = $bank_name_nganluong;
		$this->data['loai_tai_san'] = $loai_tai_san;
		$this->data['thua_dat_so'] = $thua_dat_so;
		$this->data['to_ban_do_so'] = $to_ban_do_so;
		$this->data['dia_chi_thua_dat'] = $dia_chi_thua_dat;
		$this->data['dien_tich'] = $dien_tich;
		$this->data['hinh_thuc_su_dung_rieng'] = $hinh_thuc_su_dung_rieng;
		$this->data['hinh_thuc_su_dung_chung'] = $hinh_thuc_su_dung_chung;
		$this->data['muc_dich_su_dung'] = $muc_dich_su_dung;
		$this->data['thoi_han_su_dung'] = $thoi_han_su_dung;
		$this->data['nha_o'] = $nha_o;
		$this->data['giay_chung_nhan_so'] = $giay_chung_nhan_so;
		$this->data['noi_cap'] = $noi_cap;
		$this->data['ngay_cap'] = $ngay_cap;
		$this->data['so_vao_so'] = $so_vao_so;
		$list_id_store_branch_hcm = $this->api->apiPost($this->userInfo['token'], 'Store/getStoreBranchHCM', []);
		if (in_array($contract->data->store->id, $id_pgd_dong_bac)) {
			$this->load->view('contract_printed/BBBG_thechap/BBBG_thechap_sau_khi_thanh_ly_thoa_thuan_ba_ben_tcvdb', isset($this->data) ? $this->data : NULL);
		} elseif (in_array($contract->data->store->id, $list_id_store_branch_hcm->data)) {
			$this->load->view('contract_printed/BBBG_thechap/BBBG_thechap_sau_khi_thanh_ly_thoa_thuan_ba_ben_tcvhcm', isset($this->data) ? $this->data : NULL);
		} else {
			$this->load->view('contract_printed/BBBG_thechap/BBBG_thechap_sau_khi_thanh_ly_thoa_thuan_ba_ben', isset($this->data) ? $this->data : NULL);
		}
		return;

	}

	public function printedEstate()
	{
		$data = $this->input->get();
		$data['id'] = $this->security->xss_clean($data['id']);
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		if ($contract->status == 200) {
			//Start Địa chỉ đang ở
			$contractInfo = $contract->data;
			$address = $contractInfo->current_address->current_stay . ', ' . $contractInfo->current_address->ward_name . ', ' . $contractInfo->current_address->district_name . ', ' . $contractInfo->current_address->province_name;
			//End
		}

		if ($contract->status == 200) {
			//Start Địa chỉ hổ khẩu
			$address_house = '';
			$address_house = $contractInfo->houseHold_address->address_household . ', ' . $contractInfo->houseHold_address->ward_name . ', ' . $contractInfo->houseHold_address->district_name . ', ' . $contractInfo->houseHold_address->province_name;
			//End
		}

		//get bank vimo
		$bank_id = $contract->data->receiver_infor->bank_id;
		$bankVimoData = $this->api->apiPost($this->userInfo['token'], "BankVimo/get_bank_name", array('bank_id' => $bank_id));
		$bank_name = '';
		if (!empty($bankVimoData->status) && $bankVimoData->status == 200) {
			$bank_name = $bankVimoData->data->name;
		}
		$bank_id = $contract->data->receiver_infor->bank_id;
		$bankNganLuongData = $this->api->apiPost($this->userInfo['token'], "bankNganLuong/get_bank_name", array('bank_id' => $bank_id));
		$bank_name_nganluong = '';
		if (!empty($bankNganLuongData->status) && $bankNganLuongData->status == 200) {
			$bank_name_nganluong = $bankNganLuongData->data->name;
		}

		$condition = array(
			'insurrance' => isset($contract->data->loan_infor->insurrance_contract) ? $contract->data->loan_infor->insurrance_contract : '',
			'type_interest' => $contract->data->loan_infor->type_interest,
			'period_pay_interest' => $contract->data->loan_infor->period_pay_interest,
			'number_day_loan' => $contract->data->loan_infor->number_day_loan,
			'amount_money' => $contract->data->loan_infor->amount_money,
			'code_contract' => $contract->data->code_contract,
		);
		$money_per_month = $this->api->apiPost($this->userInfo['token'], "generateContract/getMoneyPerMonth", $condition);
		$money = '';
		if (!empty($money_per_month->status) && $money_per_month->status == 200) {
			$money = $money_per_month->data;
		}
		$property = !empty($contract->data->property_infor) ? $contract->data->property_infor : array();

		$loai_tai_san = '';
		$thua_dat_so = '';
		$to_ban_do_so = '';
		$dia_chi_thua_dat = '';
		$dien_tich = '';
		$hinh_thuc_su_dung_rieng = '';
		$hinh_thuc_su_dung_chung = '';
		$muc_dich_su_dung = '';
		$thoi_han_su_dung = '';
		$nha_o = '';
		$giay_chung_nhan_so = '';
		$noi_cap = '';
		$ngay_cap = '';
		$so_vao_so = '';
		foreach ($property as $p) {
			if ($p->slug === 'loai-tai-san') {
				$loai_tai_san = $p->value;
			} elseif ($p->slug === 'thua-dat-so') {
				$thua_dat_so = $p->value;
			} elseif ($p->slug === 'to-ban-do-so') {
				$to_ban_do_so = $p->value;
			} elseif ($p->slug === 'dia-chi-thua-dat') {
				$dia_chi_thua_dat = $p->value;
			} elseif ($p->slug === 'dien-tich-m2') {
				$dien_tich = $p->value;
			} elseif ($p->slug === 'hinh-thuc-su-dung-rieng-m2') {
				$hinh_thuc_su_dung_rieng = $p->value;
			} elseif ($p->slug === 'hinh-thuc-su-dung-chung-m2') {
				$hinh_thuc_su_dung_chung = $p->value;
			} elseif ($p->slug === 'muc-dich-su-dung') {
				$muc_dich_su_dung = $p->value;
			} elseif ($p->slug === 'thoi-han-su-dung') {
				$thoi_han_su_dung = $p->value;
			} elseif ($p->slug === 'nha-o-neu-co') {
				$nha_o = $p->value;
			} elseif ($p->slug === 'giay-chung-nhan-so') {
				$giay_chung_nhan_so = $p->value;
			} elseif ($p->slug === 'noi-cap') {
				$noi_cap = $p->value;
			} elseif ($p->slug === 'ngay-cap') {
				$ngay_cap = $p->value;
			} elseif ($p->slug === 'so-vao-so') {
				$so_vao_so = $p->value;
			}
		}

		$company_name = '';
		$company_address = '';
		$role = '';
		if (!empty($contract->data->job_infor->name_company)) {
			$company_name = $contract->data->job_infor->name_company;
		}
		if (!empty($contract->data->job_infor->address_company)) {
			$company_address = $contract->data->job_infor->address_company;
		}
		if (!empty($contract->data->job_infor->job_position)) {
			$role = $contract->data->job_infor->job_position;
		}

		$customerDOB = '';
		if (!empty($contract->data->customer_infor->customer_BOD)) {
			$dobArray = explode('-', $contract->data->customer_infor->customer_BOD);
			$customerDOB = $dobArray[2] . '-' . $dobArray[1] . '-' . $dobArray[0];
		}
		$customerPhone = '';
		if (!empty($contract->data->customer_infor->customer_phone_number)) {
			$customerPhone = $contract->data->customer_infor->customer_phone_number;
		}
		// var_dump($contract->data->store->id); die;
		$store = $this->api->apiPost($this->userInfo['token'], "store/get_store", array('id' => $contract->data->store->id));
		if (!empty($store->status) && $store->status == 200) {
			$this->data['store'] = $store->data;
		} else {
			$this->data['store'] = array();
		}
		$storeAddress = '';
		if (!empty($contract->data->store->address)) {
			$storeAddress = $contract->data->store->address;
		}
		$codeContract = '';
		if (!empty($contract->data->code_contract_disbursement)) {
			$codeContract = $contract->data->code_contract_disbursement;
		}
		$pgd_dong_bac = $this->api->apiPost($this->userInfo['token'], "tcv_dong_bac/get_store_tcv_dong_bac");
		$id_pgd_dong_bac = explode(' ', $pgd_dong_bac->id_store);
		$identify_date_range = '';
	    if (!empty($contract->data->customer_infor->date_range)) {
	      $date_range_array = explode('-', $contract->data->customer_infor->date_range);
	      $identify_date_range = $date_range_array[2] . '-' . $date_range_array[1] . '-' . $date_range_array[0];
	    }
	    $this->data['identify_date_range'] = $identify_date_range;
		$this->data['contract'] = $contract->data;
		$this->data['money'] = $money;
		$this->data['bank_name'] = $bank_name;
		$this->data['address'] = $address;
		$this->data['address_house'] = $address_house;
		$this->data['customerDOB'] = $customerDOB;
		$this->data['customerPhone'] = $customerPhone;
		$this->data['storeAddress'] = $storeAddress;
		$this->data['code_contract'] = $codeContract;
		$this->data['company_name'] = $company_name;
		$this->data['company_address'] = $company_address;
		$this->data['role'] = $role;
		$this->data['bank_name_nganluong'] = $bank_name_nganluong;
		$this->data['loai_tai_san'] = $loai_tai_san;
		$this->data['thua_dat_so'] = $thua_dat_so;
		$this->data['to_ban_do_so'] = $to_ban_do_so;
		$this->data['dia_chi_thua_dat'] = $dia_chi_thua_dat;
		$this->data['dien_tich'] = $dien_tich;
		$this->data['hinh_thuc_su_dung_rieng'] = $hinh_thuc_su_dung_rieng;
		$this->data['hinh_thuc_su_dung_chung'] = $hinh_thuc_su_dung_chung;
		$this->data['muc_dich_su_dung'] = $muc_dich_su_dung;
		$this->data['thoi_han_su_dung'] = $thoi_han_su_dung;
		$this->data['nha_o'] = $nha_o;
		$this->data['giay_chung_nhan_so'] = $giay_chung_nhan_so;
		$this->data['noi_cap'] = $noi_cap;
		$this->data['ngay_cap'] = $ngay_cap;
		$this->data['so_vao_so'] = $so_vao_so;
		$list_id_store_branch_hcm = $this->api->apiPost($this->userInfo['token'], 'Store/getStoreBranchHCM', []);
		if (in_array($contract->data->store->id, $id_pgd_dong_bac)) {
			$this->load->view('contract_printed/thoathuanbaben_thechap/thechap_tcvdb.php', isset($this->data) ? $this->data : NULL);
		} elseif (in_array($contract->data->store->id, $list_id_store_branch_hcm->data)) {
			$this->load->view('contract_printed/thoathuanbaben_thechap/thechap_tcvhcm.php', isset($this->data) ? $this->data : NULL);
		} else {
			$this->load->view('contract_printed/thoathuanbaben_thechap/thechap_tcv.php', isset($this->data) ? $this->data : NULL);
		}
		return;

	}

	public function printedReceiptAfterSignContract()
	{
		$data = $this->input->get();
		$data['id'] = $this->security->xss_clean($data['id']);
		//Get information
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		$address = '';
		if ($contract->status == 200) {
			//Start Địa chỉ đang ở
			$contractInfo = $contract->data;
			$address = $contractInfo->current_address->current_stay . ', ' . $contractInfo->current_address->ward_name . ', ' . $contractInfo->current_address->district_name . ', ' . $contractInfo->current_address->province_name;
			//End
		}
		//get bank vimo
		$bank_id = $contract->data->receiver_infor->bank_id;
		$bankVimoData = $this->api->apiPost($this->userInfo['token'], "BankVimo/get_bank_name", array('bank_id' => $bank_id));
		$bank_name = '';
		if (!empty($bankVimoData->status) && $bankVimoData->status == 200) {
			$bank_name = $bankVimoData->data->name;
		}

		$condition = array(
			'insurrance' => isset($contract->data->loan_infor->insurrance_contract) ? $contract->data->loan_infor->insurrance_contract : '',
			'type_interest' => $contract->data->loan_infor->type_interest,
			'period_pay_interest' => $contract->data->loan_infor->period_pay_interest,
			'number_day_loan' => $contract->data->loan_infor->number_day_loan,
			'amount_money' => $contract->data->loan_infor->amount_money,
			'code_contract' => $contract->data->code_contract,
		);
		$money_per_month = $this->api->apiPost($this->userInfo['token'], "generateContract/getMoneyPerMonth", $condition);
		$money = '';
		if (!empty($money_per_month->status) && $money_per_month->status == 200) {
			$money = $money_per_month->data;
		}
		$property = !empty($contract->data->property_infor) ? $contract->data->property_infor : array();
		$sokhung = '';
		$somay = '';
		$bienkiemsoat = '';
		$nhanhieu = '';
		$model = '';
		$diachidangky = '';
		$sodangky = '';
		$ngaycapdangky = '';
		foreach ($property as $p) {
			if ($p->slug === 'bien-so-xe') {
				$bienkiemsoat = $p->value;
			} elseif ($p->slug === 'so-khung') {
				$sokhung = $p->value;
			} elseif ($p->slug === 'so-may') {
				$somay = $p->value;
			} elseif ($p->slug === 'nhan-hieu') {
				$nhanhieu = $p->value;
			} elseif ($p->slug === 'model') {
				$model = $p->value;
			} elseif ($p->slug === 'ho-ten-chu-xe') {
				$chuxe = $p->value;
			} elseif ($p->slug === 'dia-chi-dang-ky') {
				$diachidangky = $p->value;
			} elseif ($p->slug === 'so-dang-ky') {
				$sodangky = $p->value;
			} elseif ($p->slug === 'ngay-cap') {
				$ngaycapdangky = $p->value;
			}
		}
		$customerDOB = '';
		if (!empty($contract->data->customer_infor->customer_BOD)) {
			$dobArray = explode('-', $contract->data->customer_infor->customer_BOD);
			$customerDOB = $dobArray[2] . '-' . $dobArray[1] . '-' . $dobArray[0];
		}
		$customerPhone = '';
		if (!empty($contract->data->customer_infor->customer_phone_number)) {
			$customerPhone = $contract->data->customer_infor->customer_phone_number;
		}
		$appraise = '';
		if (!empty($contract->data->loan_infor->price_property)) {
			$appraise = $contract->data->loan_infor->price_property;
		}

		$identify_date_range = '';
		if (!empty($contract->data->customer_infor->date_range)) {
			$date_range_array = explode('-', $contract->data->customer_infor->date_range);
			$identify_date_range = $date_range_array[2] . '-' . $date_range_array[1] . '-' . $date_range_array[0];
		}
		$codeContract = '';
		if (!empty($contract->data->code_contract_disbursement)) {
			$codeContract = $contract->data->code_contract_disbursement;
		}

		$store = $this->api->apiPost($this->userInfo['token'], "store/get_store", array('id' => $contract->data->store->id));

		if (!empty($store->status) && $store->status == 200) {
			$this->data['store'] = $store->data;
		} else {
			$this->data['store'] = array();
		}
		$storeAddress = '';
		if (!empty($contract->data->store->address)) {
			$storeAddress = $contract->data->store->address;
		}
		$storeRepresentative = '';
		if (!empty($store->data->representative)) {
			$storeRepresentative = $store->data->representative;
		}

		$name_delivery_records = 'BBBG';
		$short_name_province = '';
		$code_address_store = '';
		$current_year_code_contract = date("y");
		$current_month_code_contract = date("m");
		$current_day_code_contract = date("d");
		$current_day_month_year = $current_year_code_contract . $current_month_code_contract . $current_day_code_contract;
		$code_province_store = !empty($store->data->province->name) ? $store->data->province->name : "";
		$code_province_store = vn_to_str_space($code_province_store);
		$array_short_name_province = explode(" ", $code_province_store);
		foreach ($array_short_name_province as $short_name) {
			$short_name_province .= $short_name[0];
		}
		$short_name_province = strtoupper($short_name_province);
		$code_address_store = !empty($store->data->code_address_store) ? $store->data->code_address_store : "";
		$code_delivery_records = $name_delivery_records . "/" . $short_name_province . $code_address_store . "/" . $current_day_month_year . "/";
		$this->data['code_delivery_records'] = $code_delivery_records;
		$this->data['contract'] = $contract->data;
		$this->data['money'] = $money;
		$this->data['bank_name'] = $bank_name;
		$this->data['address'] = $address;
		$this->data['sokhung'] = $sokhung;
		$this->data['somay'] = $somay;
		$this->data['nhanhieu'] = $nhanhieu;
		$this->data['model'] = $model;
		$this->data['diachidangky'] = $diachidangky;
		$this->data['sodangky'] = $sodangky;
		$this->data['ngaycapdangky'] = $ngaycapdangky;
		$this->data['bienkiemsoat'] = $bienkiemsoat;
		$this->data['customerDOB'] = $customerDOB;
		$this->data['customerPhone'] = $customerPhone;
		$this->data['storeAddress'] = $storeAddress;
		$this->data['code_contract'] = $codeContract;
		$this->data['storeRepresentative'] = $storeRepresentative;
		$this->data['identify_date_range'] = $identify_date_range;
		$this->data['appraise'] = $appraise;
		$pgd_dong_bac = $this->api->apiPost($this->userInfo['token'], "tcv_dong_bac/get_store_tcv_dong_bac");
		$list_id_store_branch_hcm = $this->api->apiPost($this->userInfo['token'], 'Store/getStoreBranchHCM', []);
		$id_pgd_dong_bac = explode(' ', $pgd_dong_bac->id_store);
		if (in_array($contract->data->store->id, $id_pgd_dong_bac)) {
			$this->load->view('contract_printed/BBBG_chovay/delivery_records_property_after_sign_contract_tcvdb', isset($this->data) ? $this->data : NULL);
		} elseif (in_array($contract->data->store->id, $list_id_store_branch_hcm->data)) {
			$this->load->view('contract_printed/BBBG_chovay/delivery_records_property_after_sign_contract_tcvhcm', isset($this->data) ? $this->data : NULL);
		} else {
			$this->load->view('contract_printed/BBBG_chovay/delivery_records_property_after_sign_contract', isset($this->data) ? $this->data : NULL);
		}
		return;
	}

	public function printedReceiptFinalSettlement()
	{
		$data = $this->input->get();
		$data['id'] = $this->security->xss_clean($data['id']);
		//Get information
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		$address = '';
		if ($contract->status == 200) {
			//Start Địa chỉ đang ở
			$contractInfo = $contract->data;
			$address = $contractInfo->current_address->current_stay . ', ' . $contractInfo->current_address->ward_name . ', ' . $contractInfo->current_address->district_name . ', ' . $contractInfo->current_address->province_name;
			//End

		}
		//get bank vimo
		$bank_id = $contract->data->receiver_infor->bank_id;
		$bankVimoData = $this->api->apiPost($this->userInfo['token'], "BankVimo/get_bank_name", array('bank_id' => $bank_id));
		$bank_name = '';
		if (!empty($bankVimoData->status) && $bankVimoData->status == 200) {
			$bank_name = $bankVimoData->data->name;
		}

		$condition = array(
			'insurrance' => isset($contract->data->loan_infor->insurrance_contract) ? $contract->data->loan_infor->insurrance_contract : '',
			'type_interest' => $contract->data->loan_infor->type_interest,
			'period_pay_interest' => $contract->data->loan_infor->period_pay_interest,
			'number_day_loan' => $contract->data->loan_infor->number_day_loan,
			'amount_money' => $contract->data->loan_infor->amount_money,
			'code_contract' => $contract->data->code_contract,
		);
		$money_per_month = $this->api->apiPost($this->userInfo['token'], "generateContract/getMoneyPerMonth", $condition);
		$money = '';
		if (!empty($money_per_month->status) && $money_per_month->status == 200) {
			$money = $money_per_month->data;
		}
		$property = !empty($contract->data->property_infor) ? $contract->data->property_infor : array();
		$sokhung = '';
		$somay = '';
		$bienkiemsoat = '';
		$nhanhieu = '';
		$model = '';
		$diachidangky = '';
		$sodangky = '';
		$ngaycapdangky = '';
		foreach ($property as $p) {
			if ($p->slug === 'bien-so-xe') {
				$bienkiemsoat = $p->value;
			} elseif ($p->slug === 'so-khung') {
				$sokhung = $p->value;
			} elseif ($p->slug === 'so-may') {
				$somay = $p->value;
			} elseif ($p->slug === 'nhan-hieu') {
				$nhanhieu = $p->value;
			} elseif ($p->slug === 'model') {
				$model = $p->value;
			} elseif ($p->slug === 'ho-ten-chu-xe') {
				$chuxe = $p->value;
			} elseif ($p->slug === 'dia-chi-dang-ky') {
				$diachidangky = $p->value;
			} elseif ($p->slug === 'so-dang-ky') {
				$sodangky = $p->value;
			} elseif ($p->slug === 'ngay-cap') {
				$ngaycapdangky = $p->value;
			}
		}
		$customerDOB = '';
		if (!empty($contract->data->customer_infor->customer_BOD)) {
			$dobArray = explode('-', $contract->data->customer_infor->customer_BOD);
			$customerDOB = $dobArray[2] . '-' . $dobArray[1] . '-' . $dobArray[0];
		}
		$customerPhone = '';
		if (!empty($contract->data->customer_infor->customer_phone_number)) {
			$customerPhone = $contract->data->customer_infor->customer_phone_number;
		}
		$appraise = '';
		if (!empty($contract->data->loan_infor->price_property)) {
			$appraise = $contract->data->loan_infor->price_property;
		}

		$identify_date_range = '';
		if (!empty($contract->data->customer_infor->date_range)) {
			$date_range_array = explode('-', $contract->data->customer_infor->date_range);
			$identify_date_range = $date_range_array[2] . '-' . $date_range_array[1] . '-' . $date_range_array[0];
		}
		$codeContract = '';
		if (!empty($contract->data->code_contract_disbursement)) {
			$codeContract = $contract->data->code_contract_disbursement;
		}
		// var_dump($contract->data->store->id); die;
		$store = $this->api->apiPost($this->userInfo['token'], "store/get_store", array('id' => $contract->data->store->id));
		if (!empty($store->status) && $store->status == 200) {
			$this->data['store'] = $store->data;
		} else {
			$this->data['store'] = array();
		}
		$storeAddress = '';
		if (!empty($contract->data->store->address)) {
			$storeAddress = $contract->data->store->address;
		}
		$storeRepresentative = '';
		if (!empty($store->data->representative)) {
			$storeRepresentative = $store->data->representative;
		}
		$name_delivery_records = 'BBBG';
		$short_name_province = '';
		$code_address_store = '';
		$current_year_code_contract = date("y");
		$current_month_code_contract = date("m");
		$current_day_code_contract = date("d");
		$current_day_month_year = $current_year_code_contract . $current_month_code_contract . $current_day_code_contract;
		$code_province_store = !empty($store->data->province->name) ? $store->data->province->name : "";
		$code_province_store = vn_to_str_space($code_province_store);
		$array_short_name_province = explode(" ", $code_province_store);
		foreach ($array_short_name_province as $short_name) {
			$short_name_province .= $short_name[0];
		}
		$short_name_province = strtoupper($short_name_province);
		$code_address_store = !empty($store->data->code_address_store) ? $store->data->code_address_store : "";
		$code_delivery_records = $name_delivery_records . "/" . $short_name_province . $code_address_store . "/" . $current_day_month_year . "/";
		$this->data['code_delivery_records'] = $code_delivery_records;
		$this->data['contract'] = $contract->data;
		$this->data['money'] = $money;
		$this->data['bank_name'] = $bank_name;
		$this->data['address'] = $address;
		$this->data['sokhung'] = $sokhung;
		$this->data['somay'] = $somay;
		$this->data['nhanhieu'] = $nhanhieu;
		$this->data['model'] = $model;
		$this->data['diachidangky'] = $diachidangky;
		$this->data['sodangky'] = $sodangky;
		$this->data['ngaycapdangky'] = $ngaycapdangky;
		$this->data['bienkiemsoat'] = $bienkiemsoat;
		$this->data['customerDOB'] = $customerDOB;
		$this->data['customerPhone'] = $customerPhone;
		$this->data['storeAddress'] = $storeAddress;
		$this->data['code_contract'] = $codeContract;
		$this->data['storeRepresentative'] = $storeRepresentative;
		$this->data['identify_date_range'] = $identify_date_range;
		$this->data['appraise'] = $appraise;
		$pgd_dong_bac = $this->api->apiPost($this->userInfo['token'], "tcv_dong_bac/get_store_tcv_dong_bac");
		$id_pgd_dong_bac = explode(' ', $pgd_dong_bac->id_store);
		$list_id_store_branch_hcm = $this->api->apiPost($this->userInfo['token'], 'Store/getStoreBranchHCM', []);
		if (in_array($contract->data->store->id, $id_pgd_dong_bac)) {
			$this->load->view('contract_printed/BBBG_chovay/delivery_records_property_final_settlement_tcvdb', isset($this->data) ? $this->data : NULL);
		} elseif (in_array($contract->data->store->id, $list_id_store_branch_hcm->data)) {
			$this->load->view('contract_printed/BBBG_chovay/delivery_records_property_final_settlement_tcvhcm', isset($this->data) ? $this->data : NULL);
		} else {
			$this->load->view('contract_printed/BBBG_chovay/delivery_records_property_final_settlement', isset($this->data) ? $this->data : NULL);
		}
		return;
	}

	public function printedNotification()
	{
		$data = $this->input->get();
		$data['id'] = $this->security->xss_clean($data['id']);
		//Get information
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		$address = '';
		if ($contract->status == 200) {
			//Start Địa chỉ đang ở
			$contractInfo = $contract->data;
			$address = $contractInfo->current_address->current_stay . ', ' . $contractInfo->current_address->ward_name . ', ' . $contractInfo->current_address->district_name . ', ' . $contractInfo->current_address->province_name;
			//End

		}
		//get bank vimo
		$bank_id = $contract->data->receiver_infor->bank_id;
		$bankVimoData = $this->api->apiPost($this->userInfo['token'], "BankVimo/get_bank_name", array('bank_id' => $bank_id));
		$bank_name = '';
		if (!empty($bankVimoData->status) && $bankVimoData->status == 200) {
			$bank_name = $bankVimoData->data->name;
		}

		$condition = array(
			'insurrance' => isset($contract->data->loan_infor->insurrance_contract) ? $contract->data->loan_infor->insurrance_contract : '',
			'type_interest' => $contract->data->loan_infor->type_interest,
			'period_pay_interest' => $contract->data->loan_infor->period_pay_interest,
			'number_day_loan' => $contract->data->loan_infor->number_day_loan,
			'amount_money' => $contract->data->loan_infor->amount_money,
			'code_contract' => $contract->data->code_contract,
		);
		$money_per_month = $this->api->apiPost($this->userInfo['token'], "generateContract/getMoneyPerMonth", $condition);
		$money = '';
		if (!empty($money_per_month->status) && $money_per_month->status == 200) {
			$money = $money_per_month->data;
		}
		$property = !empty($contract->data->property_infor) ? $contract->data->property_infor : array();
		$sokhung = '';
		$somay = '';
		$bienkiemsoat = '';
		$nhanhieu = '';
		$model = '';
		$chuxe = '';
		$diachidangky = '';
		$sodangky = '';
		$ngaycapdangky = '';
		foreach ($property as $p) {
			if ($p->slug === 'bien-so-xe') {
				$bienkiemsoat = $p->value;
			} elseif ($p->slug === 'so-khung') {
				$sokhung = $p->value;
			} elseif ($p->slug === 'so-may') {
				$somay = $p->value;
			} elseif ($p->slug === 'nhan-hieu') {
				$nhanhieu = $p->value;
			} elseif ($p->slug === 'model') {
				$model = $p->value;
			} elseif ($p->slug === 'ho-ten-chu-xe') {
				$chuxe = $p->value;
			} elseif ($p->slug === 'dia-chi-dang-ky') {
				$diachidangky = $p->value;
			} elseif ($p->slug === 'so-dang-ky') {
				$sodangky = $p->value;
			} elseif ($p->slug === 'ngay-cap') {
				$ngaycapdangky = $p->value;
			}
		}
		$customerDOB = '';
		if (!empty($contract->data->customer_infor->customer_BOD)) {
			$dobArray = explode('-', $contract->data->customer_infor->customer_BOD);
			$customerDOB = $dobArray[2] . '-' . $dobArray[1] . '-' . $dobArray[0];
		}
		$customerPhone = '';
		if (!empty($contract->data->customer_infor->customer_phone_number)) {
			$customerPhone = $contract->data->customer_infor->customer_phone_number;
		}
		// var_dump($contract->data->store->id); die;
		$store = $this->api->apiPost($this->userInfo['token'], "store/get_store", array('id' => $contract->data->store->id));
		if (!empty($store->status) && $store->status == 200) {
			$this->data['store'] = $store->data;
		} else {
			$this->data['store'] = array();
		}
		$storeAddress = '';
		if (!empty($contract->data->store->address)) {
			$storeAddress = $contract->data->store->address;
		}
		$codeContract = '';
		if (!empty($contract->data->code_contract_disbursement)) {
			$codeContract = $contract->data->code_contract_disbursement;
		}
		$pgd_dong_bac = $this->api->apiPost($this->userInfo['token'], "tcv_dong_bac/get_store_tcv_dong_bac");
		$id_pgd_dong_bac = explode(' ', $pgd_dong_bac->id_store);
		$this->data['contract'] = $contract->data;
		$this->data['money'] = $money;
		$this->data['bank_name'] = $bank_name;
		$this->data['address'] = $address;
		$this->data['sokhung'] = $sokhung;
		$this->data['somay'] = $somay;
		$this->data['nhanhieu'] = $nhanhieu;
		$this->data['model'] = $model;
		$this->data['chuxe'] = $chuxe;
		$this->data['diachidangky'] = $diachidangky;
		$this->data['sodangky'] = $sodangky;
		$this->data['ngaycapdangky'] = $ngaycapdangky;
		$this->data['bienkiemsoat'] = $bienkiemsoat;
		$this->data['customerDOB'] = $customerDOB;
		$this->data['customerPhone'] = $customerPhone;
		$this->data['storeAddress'] = $storeAddress;
		$this->data['code_contract'] = $codeContract;
		$list_id_store_branch_hcm = $this->api->apiPost($this->userInfo['token'], 'Store/getStoreBranchHCM', []);
		if (in_array($contract->data->store->id, $id_pgd_dong_bac)) {
			$this->load->view('contract_printed/vanbanthongbao/contract_printed_notification_tcvdb', isset($this->data) ? $this->data : NULL);
		} elseif (in_array($contract->data->store->id, $list_id_store_branch_hcm->data)) {
			$this->load->view('contract_printed/vanbanthongbao/contract_printed_notification_tcvhcm', isset($this->data) ? $this->data : NULL);
		} else {
			$this->load->view('contract_printed/vanbanthongbao/contract_printed_notification', isset($this->data) ? $this->data : NULL);
		}
		return;
	}

	public function printedCommitmentCar()
	{
		$data = $this->input->get();
		$data['id'] = $this->security->xss_clean($data['id']);
		//Get information
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		$address = '';
		if ($contract->status == 200) {
			//Start Địa chỉ đang ở
			$contractInfo = $contract->data;
			$address = $contractInfo->current_address->current_stay . ', ' . $contractInfo->current_address->ward_name . ', ' . $contractInfo->current_address->district_name . ', ' . $contractInfo->current_address->province_name;
			//End

		}
		if ($contract->status == 200) {
			//Start Địa chỉ hổ khẩu
			$address_house = '';
			$address_house = $contractInfo->houseHold_address->address_household . ', ' . $contractInfo->houseHold_address->ward_name . ', ' . $contractInfo->houseHold_address->district_name . ', ' . $contractInfo->houseHold_address->province_name;
			//End
		}
		//get bank vimo
		$bank_id = $contract->data->receiver_infor->bank_id;
		$bankVimoData = $this->api->apiPost($this->userInfo['token'], "BankVimo/get_bank_name", array('bank_id' => $bank_id));
		$bank_name = '';
		if (!empty($bankVimoData->status) && $bankVimoData->status == 200) {
			$bank_name = $bankVimoData->data->name;
		}

		$condition = array(
			'insurrance' => isset($contract->data->loan_infor->insurrance_contract) ? $contract->data->loan_infor->insurrance_contract : '',
			'type_interest' => $contract->data->loan_infor->type_interest,
			'period_pay_interest' => $contract->data->loan_infor->period_pay_interest,
			'number_day_loan' => $contract->data->loan_infor->number_day_loan,
			'amount_money' => $contract->data->loan_infor->amount_money,
			'code_contract' => $contract->data->code_contract,
		);
		$money_per_month = $this->api->apiPost($this->userInfo['token'], "generateContract/getMoneyPerMonth", $condition);
		$money = '';
		if (!empty($money_per_month->status) && $money_per_month->status == 200) {
			$money = $money_per_month->data;
		}
		$property = !empty($contract->data->property_infor) ? $contract->data->property_infor : array();
		$sokhung = '';
		$somay = '';
		$bienkiemsoat = '';
		$nhanhieu = '';
		$model = '';
		$chuxe = '';
		$diachidangky = '';
		$sodangky = '';
		$ngaycapdangky = '';
		foreach ($property as $p) {
			if ($p->slug === 'bien-so-xe') {
				$bienkiemsoat = $p->value;
			} elseif ($p->slug === 'so-khung') {
				$sokhung = $p->value;
			} elseif ($p->slug === 'so-may') {
				$somay = $p->value;
			} elseif ($p->slug === 'nhan-hieu') {
				$nhanhieu = $p->value;
			} elseif ($p->slug === 'model') {
				$model = $p->value;
			} elseif ($p->slug === 'ho-ten-chu-xe') {
				$chuxe = $p->value;
			} elseif ($p->slug === 'dia-chi-dang-ky') {
				$diachidangky = $p->value;
			} elseif ($p->slug === 'so-dang-ky') {
				$sodangky = $p->value;
			} elseif ($p->slug === 'ngay-cap') {
				$ngaycapdangky = $p->value;
			}
		}
		$customerDOB = '';
		if (!empty($contract->data->customer_infor->customer_BOD)) {
			$dobArray = explode('-', $contract->data->customer_infor->customer_BOD);
			$customerDOB = $dobArray[2] . '-' . $dobArray[1] . '-' . $dobArray[0];
		}
		$customerPhone = '';
		if (!empty($contract->data->customer_infor->customer_phone_number)) {
			$customerPhone = $contract->data->customer_infor->customer_phone_number;
		}
		$identify_date_range = '';
		if (!empty($contract->data->customer_infor->date_range)) {
			$date_range_array = explode('-', $contract->data->customer_infor->date_range);
			$identify_date_range = $date_range_array[2] . '-' . $date_range_array[1] . '-' . $date_range_array[0];
		}
		$codeContract = '';
		if (!empty($contract->data->code_contract_disbursement)) {
			$codeContract = $contract->data->code_contract_disbursement;
		}
		// var_dump($contract->data->store->id); die;
		$store = $this->api->apiPost($this->userInfo['token'], "store/get_store", array('id' => $contract->data->store->id));
		if (!empty($store->status) && $store->status == 200) {
			$this->data['store'] = $store->data;
		} else {
			$this->data['store'] = array();
		}
		$storeAddress = '';
		if (!empty($contract->data->store->address)) {
			$storeAddress = $contract->data->store->address;
		}
		$storeRepresentative = '';
		if (!empty($store->data->representative)) {
			$storeRepresentative = $store->data->representative;
		}
		$pgd_dong_bac = $this->api->apiPost($this->userInfo['token'], "tcv_dong_bac/get_store_tcv_dong_bac");
		$id_pgd_dong_bac = explode(' ', $pgd_dong_bac->id_store);
		$this->data['contract'] = $contract->data;
		$this->data['money'] = $money;
		$this->data['bank_name'] = $bank_name;
		$this->data['address'] = $address;
		$this->data['address_house'] = $address_house;
		$this->data['sokhung'] = $sokhung;
		$this->data['somay'] = $somay;
		$this->data['nhanhieu'] = $nhanhieu;
		$this->data['model'] = $model;
		$this->data['chuxe'] = $chuxe;
		$this->data['diachidangky'] = $diachidangky;
		$this->data['sodangky'] = $sodangky;
		$this->data['ngaycapdangky'] = $ngaycapdangky;
		$this->data['bienkiemsoat'] = $bienkiemsoat;
		$this->data['customerDOB'] = $customerDOB;
		$this->data['customerPhone'] = $customerPhone;
		$this->data['storeAddress'] = $storeAddress;
		$this->data['code_contract'] = $codeContract;
		$this->data['storeRepresentative'] = $storeRepresentative;
		$this->data['identify_date_range'] = $identify_date_range;
		$list_id_store_branch_hcm = $this->api->apiPost($this->userInfo['token'], 'Store/getStoreBranchHCM', []);
		if (in_array($contract->data->store->id, $id_pgd_dong_bac)) {
			$this->load->view('contract_printed/camketxe/contract_printed_commitment_car_tcvdb', isset($this->data) ? $this->data : NULL);
		} elseif (in_array($contract->data->store->id, $list_id_store_branch_hcm->data)) {
			$this->load->view('contract_printed/camketxe/contract_printed_commitment_car_tcvhcm', isset($this->data) ? $this->data : NULL);
		} else {
			$this->load->view('contract_printed/camketxe/contract_printed_commitment_car', isset($this->data) ? $this->data : NULL);
		}
		return;
	}

	public function printedCommitmentPolicy()
	{
		$data = $this->input->get();
		$data['id'] = $this->security->xss_clean($data['id']);
		//Get information
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		$address = '';
		if ($contract->status == 200) {
			//Start Địa chỉ đang ở
			$contractInfo = $contract->data;
			$address = $contractInfo->current_address->current_stay . ', ' . $contractInfo->current_address->ward_name . ', ' . $contractInfo->current_address->district_name . ', ' . $contractInfo->current_address->province_name;
			//End

		}
		//get bank vimo
		$bank_id = $contract->data->receiver_infor->bank_id;
		$bankVimoData = $this->api->apiPost($this->userInfo['token'], "BankVimo/get_bank_name", array('bank_id' => $bank_id));
		$bank_name = '';
		if (!empty($bankVimoData->status) && $bankVimoData->status == 200) {
			$bank_name = $bankVimoData->data->name;
		}

		$condition = array(
			'insurrance' => isset($contract->data->loan_infor->insurrance_contract) ? $contract->data->loan_infor->insurrance_contract : '',
			'type_interest' => $contract->data->loan_infor->type_interest,
			'period_pay_interest' => $contract->data->loan_infor->period_pay_interest,
			'number_day_loan' => $contract->data->loan_infor->number_day_loan,
			'amount_money' => $contract->data->loan_infor->amount_money,
			'code_contract' => $contract->data->code_contract,
		);
		$money_per_month = $this->api->apiPost($this->userInfo['token'], "generateContract/getMoneyPerMonth", $condition);
		$money = '';
		if (!empty($money_per_month->status) && $money_per_month->status == 200) {
			$money = $money_per_month->data;
		}
		$property = !empty($contract->data->property_infor) ? $contract->data->property_infor : array();
		$sokhung = '';
		$somay = '';
		$bienkiemsoat = '';
		$nhanhieu = '';
		$model = '';
		foreach ($property as $p) {
			if ($p->slug === 'bien-so-xe') {
				$bienkiemsoat = $p->value;
			} elseif ($p->slug === 'so-khung') {
				$sokhung = $p->value;
			} elseif ($p->slug === 'so-may') {
				$somay = $p->value;
			} elseif ($p->slug === 'nhan-hieu') {
				$nhanhieu = $p->value;
			} elseif ($p->slug === 'model') {
				$model = $p->value;
			}
		}
		$customerDOB = '';
		if (!empty($contract->data->customer_infor->customer_BOD)) {
			$dobArray = explode('-', $contract->data->customer_infor->customer_BOD);
			$customerDOB = $dobArray[2] . '-' . $dobArray[1] . '-' . $dobArray[0];
		}
		$customerPhone = '';
		if (!empty($contract->data->customer_infor->customer_phone_number)) {
			$customerPhone = $contract->data->customer_infor->customer_phone_number;
		}
		$identify_date_range = '';
		if (!empty($contract->data->customer_infor->date_range)) {
			$date_range_array = explode('-', $contract->data->customer_infor->date_range);
			$identify_date_range = $date_range_array[2] . '-' . $date_range_array[1] . '-' . $date_range_array[0];
		}
		$codeContract = '';
		if (!empty($contract->data->code_contract_disbursement)) {
			$codeContract = $contract->data->code_contract_disbursement;
		}
		// var_dump($contract->data->store->id); die;
		$store = $this->api->apiPost($this->userInfo['token'], "store/get_store", array('id' => $contract->data->store->id));
		if (!empty($store->status) && $store->status == 200) {
			$this->data['store'] = $store->data;
		} else {
			$this->data['store'] = array();
		}
		$storeAddress = '';
		if (!empty($contract->data->store->address)) {
			$storeAddress = $contract->data->store->address;
		}
		$storeRepresentative = '';
		if (!empty($store->data->representative)) {
			$storeRepresentative = $store->data->representative;
		}
		$pgd_dong_bac = $this->api->apiPost($this->userInfo['token'], "tcv_dong_bac/get_store_tcv_dong_bac");
		$id_pgd_dong_bac = explode(' ', $pgd_dong_bac->id_store);
		$this->data['contract'] = $contract->data;
		$this->data['money'] = $money;
		$this->data['bank_name'] = $bank_name;
		$this->data['address'] = $address;
		$this->data['sokhung'] = $sokhung;
		$this->data['somay'] = $somay;
		$this->data['nhanhieu'] = $nhanhieu;
		$this->data['model'] = $model;
		$this->data['bienkiemsoat'] = $bienkiemsoat;
		$this->data['customerDOB'] = $customerDOB;
		$this->data['customerPhone'] = $customerPhone;
		$this->data['storeAddress'] = $storeAddress;
		$this->data['code_contract'] = $codeContract;
		$this->data['storeRepresentative'] = $storeRepresentative;
		$this->data['identify_date_range'] = $identify_date_range;
		$list_id_store_branch_hcm = $this->api->apiPost($this->userInfo['token'], 'Store/getStoreBranchHCM', []);
		if (in_array($contract->data->store->id, $id_pgd_dong_bac)) {
			$this->load->view('contract_printed/camketnhanvien/contract_printed_commitment_policy_tcvdb', isset($this->data) ? $this->data : NULL);
		} elseif (in_array($contract->data->store->id, $list_id_store_branch_hcm->data)) {
			$this->load->view('contract_printed/camketnhanvien/contract_printed_commitment_policy_tcvhcm', isset($this->data) ? $this->data : NULL);
		} else {
			$this->load->view('contract_printed/camketnhanvien/contract_printed_commitment_policy', isset($this->data) ? $this->data : NULL);
		}
		return;
	}

	public function printedMortgage()
	{
		$data = $this->input->get();
		$data['id'] = $this->security->xss_clean($data['id']);
		//Get information
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		$address = '';
		if ($contract->status == 200) {
			//Start Địa chỉ đang ở
			$contractInfo = $contract->data;
			$address = $contractInfo->current_address->current_stay . ', ' . $contractInfo->current_address->ward_name . ', ' . $contractInfo->current_address->district_name . ', ' . $contractInfo->current_address->province_name;
			//End
		}
		if ($contract->status == 200) {
			//Start Địa chỉ hổ khẩu
			$address_house = '';
			$address_house = $contractInfo->houseHold_address->address_household . ', ' . $contractInfo->houseHold_address->ward_name . ', ' . $contractInfo->houseHold_address->district_name . ', ' . $contractInfo->houseHold_address->province_name;
			//End
		}
		//get bank vimo
		$bank_id = $contract->data->receiver_infor->bank_id;
		$bankVimoData = $this->api->apiPost($this->userInfo['token'], "BankVimo/get_bank_name", array('bank_id' => $bank_id));
		$bank_name = '';
		if (!empty($bankVimoData->status) && $bankVimoData->status == 200) {
			$bank_name = $bankVimoData->data->name;
		}

		$bank_id = $contract->data->receiver_infor->bank_id;
		$bankNganLuongData = $this->api->apiPost($this->userInfo['token'], "bankNganLuong/get_bank_name", array('bank_id' => $bank_id));
		$bank_name_nganluong = '';
		if (!empty($bankNganLuongData->status) && $bankNganLuongData->status == 200) {
			$bank_name_nganluong = $bankNganLuongData->data->name;
		}

		$condition = array(
			'insurrance' => isset($contract->data->loan_infor->insurrance_contract) ? $contract->data->loan_infor->insurrance_contract : '',
			'type_interest' => $contract->data->loan_infor->type_interest,
			'period_pay_interest' => $contract->data->loan_infor->period_pay_interest,
			'number_day_loan' => $contract->data->loan_infor->number_day_loan,
			'amount_money' => $contract->data->loan_infor->amount_money,
			'code_contract' => $contract->data->code_contract,
		);
		$money_per_month = $this->api->apiPost($this->userInfo['token'], "generateContract/getMoneyPerMonth", $condition);
		$money = '';
		if (!empty($money_per_month->status) && $money_per_month->status == 200) {
			$money = $money_per_month->data;
		}
		$property = !empty($contract->data->property_infor) ? $contract->data->property_infor : array();
		$sokhung = '';
		$somay = '';
		$bienkiemsoat = '';
		$nhanhieu = '';
		$model = '';
		foreach ($property as $p) {
			if ($p->slug === 'bien-so-xe') {
				$bienkiemsoat = $p->value;
			} elseif ($p->slug === 'so-khung') {
				$sokhung = $p->value;
			} elseif ($p->slug === 'so-may') {
				$somay = $p->value;
			} elseif ($p->slug === 'nhan-hieu') {
				$nhanhieu = $p->value;
			} elseif ($p->slug === 'model') {
				$model = $p->value;
			}
		}
		$company_name = '';
		$company_address = '';
		$role = '';
		$work_year = '';
		$loan_purpose = $contract->data->loan_infor->loan_purpose;
		if (!empty($contract->data->job_infor->name_company)) {
			$company_name = $contract->data->job_infor->name_company;
		}
		if (!empty($contract->data->job_infor->address_company)) {
			$company_address = $contract->data->job_infor->address_company;
		}
		if (!empty($contract->data->job_infor->job_position)) {
			$role = $contract->data->job_infor->job_position;
		}
		if (!empty($contract->data->job_infor->work_year)) {
			$work_year = $contract->data->job_infor->work_year;
		}
		$customerDOB = '';
		if (!empty($contract->data->customer_infor->customer_BOD)) {
			$dobArray = explode('-', $contract->data->customer_infor->customer_BOD);
			$customerDOB = $dobArray[2] . '-' . $dobArray[1] . '-' . $dobArray[0];
		}
		$customerPhone = '';
		if (!empty($contract->data->customer_infor->customer_phone_number)) {
			$customerPhone = $contract->data->customer_infor->customer_phone_number;
		}
		$codeContract = '';
		if (!empty($contract->data->code_contract_disbursement)) {
			$codeContract = $contract->data->code_contract_disbursement;
		}
		// var_dump($contract->data->store->id); die;
		$store = $this->api->apiPost($this->userInfo['token'], "store/get_store", array('id' => $contract->data->store->id));
		if (!empty($store->status) && $store->status == 200) {
			$this->data['store'] = $store->data;
		} else {
			$this->data['store'] = array();
		}
		$storeAddress = '';
		if (!empty($contract->data->store->address)) {
			$storeAddress = $contract->data->store->address;
		}
		$storeRepresentative = '';
		if (!empty($store->data->representative)) {
			$storeRepresentative = $store->data->representative;
		}
		$pgd_dong_bac = $this->api->apiPost($this->userInfo['token'], "tcv_dong_bac/get_store_tcv_dong_bac");
		$id_pgd_dong_bac = explode(' ', $pgd_dong_bac->id_store);
		$this->data['address_house'] = $address_house;
		$this->data['contract'] = $contract->data;
		$this->data['money'] = $money;
		$this->data['bank_name'] = $bank_name;
		$this->data['address'] = $address;
		$this->data['sokhung'] = $sokhung;
		$this->data['somay'] = $somay;
		$this->data['nhanhieu'] = $nhanhieu;
		$this->data['model'] = $model;
		$this->data['bienkiemsoat'] = $bienkiemsoat;
		$this->data['customerDOB'] = $customerDOB;
		$this->data['customerPhone'] = $customerPhone;
		$this->data['storeAddress'] = $storeAddress;
		$this->data['code_contract'] = $codeContract;
		$this->data['storeRepresentative'] = $storeRepresentative;
		$this->data['company_name'] = $company_name;
		$this->data['company_address'] = $company_address;
		$this->data['role'] = $role;
		$this->data['work_year'] = $work_year;
		$this->data['bank_name_nganluong'] = $bank_name_nganluong;
		$this->data['loan_purpose'] = $loan_purpose;
		if (in_array($contract->data->store->id, $id_pgd_dong_bac)) {
			$this->load->view('contract_printed/contract_printed_mortgage_tcvdb', isset($this->data) ? $this->data : NULL);
		} else {
			$this->load->view('contract_printed/contract_printed_mortgage', isset($this->data) ? $this->data : NULL);
		}
		return;
	}


	public function disbursement($id)
	{
		$data['id'] = $id;
		$data['id'] = $this->security->xss_clean($data['id']);

		//get list nhà đầu tư
		$listInvestor = $this->api->apiPost($this->userInfo['token'], "investor/get_all");
		if ($listInvestor->status == 200) {
			$this->data['listInvestor'] = $listInvestor->data;
		}
		//Get information
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		if ($contract->status == 200) {

			$pgd_dong_bac = $this->api->apiPost($this->userInfo['token'], "tcv_dong_bac/get_store_tcv_dong_bac");
			$id_pgd_dong_bac = explode(' ', $pgd_dong_bac->id_store);
			if (in_array($contract->data->store->id, $id_pgd_dong_bac)) {
				$this->data['company_code'] = "1";
			} else {
				$this->data['company_code'] = "2";
			}

			$this->data['contractInfor'] = $contract->data;
		}
		$nextpay = $this->api->apiPost($this->userInfo['token'], "nextpay/check_store_next_pay", ['store_id'=>$contract->data->store->id]);
		if (!empty($nextpay->status) && $nextpay->status == 200) {
			$this->data['user_nextpay'] = $nextpay->data;
		}else{
			$this->data['user_nextpay'] = 0;
		}



		$this->data['template'] = 'page/pawn/view_ketoan_new/disbursement_new.php';
//		$this->data['template'] = 'page/pawn/disbursement';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function disbursement_nl($id)
	{
		$data['id'] = $id;
		$data['id'] = $this->security->xss_clean($data['id']);

		//get list nhà đầu tư
		$listInvestor = $this->api->apiPost($this->userInfo['token'], "investor/get_investor_nl");
		if ($listInvestor->status == 200) {
			$this->data['listInvestor'] = $listInvestor->data;
		}
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		//Get information
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		if ($contract->status == 200) {
			$pgd_dong_bac = $this->api->apiPost($this->userInfo['token'], "tcv_dong_bac/get_store_tcv_dong_bac");
			$id_pgd_dong_bac = explode(' ', $pgd_dong_bac->id_store);
			if (in_array($contract->data->store->id, $id_pgd_dong_bac)) {
				$this->data['company_code'] = "1";
			} else {
				$this->data['company_code'] = "2";
			}

			$this->data['contractInfor'] = $contract->data;
		}
		$nextpay = $this->api->apiPost($this->userInfo['token'], "nextpay/check_store_next_pay", ['store_id'=>$contract->data->store->id]);
		if (!empty($nextpay->status) && $nextpay->status == 200) {
			$this->data['user_nextpay'] = $nextpay->data;
		}else{
			$this->data['user_nextpay'] = 0;
		}

//		$this->data['template'] = 'page/pawn/disbursement_nl';
		$this->data['template'] = 'page/pawn/view_ketoan_new/disbursement_nl_new.php';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function createWithdrawalVimo()
	{
		$data = $this->input->post();
		$data['type_payout'] = !empty($data['type_payout']) ? $this->security->xss_clean($data['type_payout']) : "";
		$data['order_code'] = !empty($data['order_code']) ? $this->security->xss_clean($data['order_code']) : "";
		$data['amount'] = !empty($data['amount']) ? $this->security->xss_clean($data['amount']) : "";
		$data['bank_id'] = !empty($data['bank_id']) ? $this->security->xss_clean($data['bank_id']) : "";
		$data['description'] = !empty($data['description']) ? $this->security->xss_clean($data['description']) : "";
		$data['code_contract'] = !empty($data['code_contract']) ? $this->security->xss_clean($data['code_contract']) : "";
		//Bank account = 2
		if ($data['type_payout'] == 2 || $data['type_payout'] == 10) {
			$data['bank_account'] = !empty($data['bank_account']) ? $this->security->xss_clean($data['bank_account']) : "";
			$data['bank_account_holder'] = !empty($data['bank_account_holder']) ? $this->security->xss_clean($data['bank_account_holder']) : "";
			$data['bank_branch'] = !empty($data['bank_branch']) ? $this->security->xss_clean($data['bank_branch']) : "";
		}
		//ATM Card Number = 3
		if ($data['type_payout'] == 3) {
			$data['atm_card_number'] = !empty($data['atm_card_number']) ? $this->security->xss_clean($data['atm_card_number']) : "";
			$data['atm_card_holder'] = !empty($data['atm_card_holder']) ? $this->security->xss_clean($data['atm_card_holder']) : "";
		}
		//Encrypt TripleDes
		$libTripleDes = new TripleDes();
		$secretKey = $libTripleDes->Encrypt(json_encode($data), $this->config->item("TRIPLEDES_KEY"));
		$dataPost = array(
			"type_payout" => $data['type_payout'],
			"order_code" => $data['order_code'],
			"amount" => $data['amount'],
			"bank_id" => $data['bank_id'],
			"description" => $data['description'],
			"bank_account" => !empty($data['bank_account']) ? $data['bank_account'] : "",
			"bank_account_holder" => !empty($data['bank_account_holder']) ? $data['bank_account_holder'] : "",
			"atm_card_number" => !empty($data['atm_card_number']) ? $data['atm_card_number'] : "",
			"atm_card_holder" => !empty($data['atm_card_holder']) ? $data['atm_card_holder'] : "",
			"updated_by" => $this->user['email'],
			"secret_key" => $secretKey,
			"code_contract" => !empty($data['code_contract']) ? $data['code_contract'] : "",
			"bank_branch" => !empty($data['bank_branch']) ? $data['bank_branch'] : "",
			"disbursement_by" => $this->user['email'],
			'percent_interest_investor' => !empty($data['percent_interest_investor']) ? $data['percent_interest_investor'] : "",
			'investor_code' => !empty($data['investor_code']) ? $data['investor_code'] : "",
		);
		// goi sang vimo tao giao dich
		$return = $this->api->apiPost($this->user['token'], "PayoutVimo/create_withdrawal", $dataPost);

		if (!empty($return->status) && $return->status == 200) {
			//update code contract
			$dataPost = array(
				"code_contract" => !empty($data['code_contract']) ? $data['code_contract'] : ""
			);

			$update_code_contract = $this->api->apiPost($this->user['token'], "contract/update_code_contract", $dataPost);
			if (!empty($update_code_contract->status) && $update_code_contract->status == 200) {
				$this->pushJson('200', json_encode(array("code" => "200", "data" => $return, "msg" => $this->lang->line('Successful_disbursement_order'))));
			} else {
				$this->pushJson('200', json_encode(array("code" => "401", "data" => $return, "msg" => $update_code_contract->message)));
			}

		} else {
			$this->pushJson('200', json_encode(array("code" => "401", "data" => $return, "msg" => $return->result->error_description)));
		}
	}

	public function getOne()
	{
		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		//Get information
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));

		if ($contract->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $contract->data)));
			return;
		}
	}

	public function getOne_gh()
	{
		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		//Get information
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		$log = $this->api->apiPost($this->userInfo['token'], "log/get_log_gh", array("contract_id" => $data['id']));
		if (!empty($log->status) && $log->status == 200) {
			$logs = $log->data;
		} else {
			$logs = array();
		}
		if ($contract->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $contract->data, "logs" => $logs)));
			return;
		}
	}

	public function getOne_cc()
	{
		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		//Get information
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		$log = $this->api->apiPost($this->userInfo['token'], "log/get_log_cc", array("contract_id" => $data['id']));
		if (!empty($log->status) && $log->status == 200) {
			$logs = $log->data;
		} else {
			$logs = array();
		}
		$data_ct = array(
			"id" => $data['id']
		);
		$transaction = $this->api->apiPost($this->userInfo['token'], "transaction/get_transaction_cc", array("code_contract" => $contract->data->code_contract));
		$contractData = $this->api->apiPost($this->userInfo['token'], "view_payment/tempo_detail", $data_ct);

		$tien_phai_tra = $contract->data->debt->tong_tien_goc_con + $contract->data->debt->tong_tien_phi_con + $contract->data->debt->tong_tien_lai_con + $contractData->data->phi_phat_sinh + $contractData->data->penalty_now;

		if ($contract->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $contract->data, "logs" => $logs, "transactions" => $transaction, "tien_phai_tra" => $tien_phai_tra)));
			return;
		}
	}

	public function getInforHeader()
	{
		$countContracts = $this->api->apiGet($this->userInfo['token'], "contract/get_infor_header");

	}

	public function investorsDisbursement()
	{
		$data = $this->input->post();
		$data['code_contract'] = $this->security->xss_clean($data['code_contract']);
		$data['investor_code'] = $this->security->xss_clean($data['investor_code']);
		$data['contract_id'] = $this->security->xss_clean($data['contract_id']);

		$data['disbursement_date'] = $this->security->xss_clean($data['disbursement_date']);
		$data['chan_bao_hiem'] = $this->security->xss_clean($data['chan_bao_hiem']);
		$data['code_transaction_bank_disbursement'] = $this->security->xss_clean($data['code_transaction_bank_disbursement']);
		$data['bank_name'] = $this->security->xss_clean($data['bank_name']);
		$data['content_transfer_disbursement'] = $this->security->xss_clean($data['content_transfer']);

		$percent_interest_investor = $this->security->xss_clean($data['percent_interest_investor']);
		if (empty($data['investor_code'])) {
			$investor_id = $this->security->xss_clean($data['investor_id']);
			//case giai ngan qua nha dau tu ngoai khong phải vfc
			$investor = $this->api->apiPost($this->userInfo['token'], "investor/get_one", array('id' => $investor_id));
			if ($investor->status == 200) {
				$percent_interest_investor = $investor->data->percent_interest_investor;
				$data['investor_code'] = $investor->data->code;
			}

		}
		$disbursement_date = !empty($data['disbursement_date']) ? $data['disbursement_date'] : "";
		$dataPost = array(
			"code_contract" => $data['code_contract'],
			"investor_code" => $data['investor_code'],
			"disbursement_date" => !empty($disbursement_date) ? strtotime($disbursement_date) : $this->time_model->convertDatetimeToTimestamp(new DateTime()),
			"secret_key" => "",
		);
//        if(empty($data['code_transaction_bank_disbursement'])) {
//            $data['code_transaction_bank_disbursement'] = "MGD_".substr(md5((string)rand(1, 99999999)), 1,15);
//        }

		$dataUpdate = array(
			"investor_code" => $data['investor_code'],
			"contract_id" => $data['contract_id'],
			"percent_interest_investor" => $percent_interest_investor,
			"code_transaction_bank_disbursement" => $data['code_transaction_bank_disbursement'],
			"bank_name_disbursement" => $data['bank_name'],
			"chan_bao_hiem" => $data['chan_bao_hiem'],
			"content_transfer_disbursement" => $data['content_transfer_disbursement'],
			"disbursement_date_new" => !empty($disbursement_date) ? strtotime($disbursement_date) : $this->time_model->convertDatetimeToTimestamp(new DateTime())
		);

		$update = $this->api->apiPost($this->userInfo['token'], "contract/accountant_investors_disbursement", $dataUpdate);
		if (!empty($update->status) && $update->status == 200) {
			$result = $this->api->apiPost($this->userInfo['token'], "generateContract/processContract", $dataPost);
			if (!empty($result->status) && $result->status == 200) {
				$this->pushJson('200', json_encode(array("code" => "200", "msg" => $result->message)));
				return;
			} else {
				$this->pushJson('200', json_encode(array("code" => "401", "msg" => $result->message)));
				return;
			}
		} else {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $update->message, 'data' => $update, "type" => $update->type,)));
			return;
		}

	}

	public function investorsDisbursementNganluong()
	{
		$data = $this->input->post();
		$data['code_contract'] = $this->security->xss_clean($data['code_contract']);
		$data['investor_code'] = $this->security->xss_clean($data['investor_code']);
		$data['contract_id'] = $this->security->xss_clean($data['contract_id']);
		$data['content_transfer'] = $this->security->xss_clean($data['content_transfer']);
		$data['chan_bao_hiem'] = $this->security->xss_clean($data['chan_bao_hiem']);
		$data['code_transaction_bank_disbursement'] = $this->security->xss_clean($data['code_transaction_bank_disbursement']);
		$data['bank_name'] = $this->security->xss_clean($data['bank_name']);
		$data['content_transfer_disbursement'] = $this->security->xss_clean($data['content_transfer']);

		$investor_id = $this->security->xss_clean($data['investor_id']);
		$investor = $this->api->apiPost($this->userInfo['token'], "investor/get_one", array('id' => $investor_id));
		if ($investor->status == 200) {
			$percent_interest_investor = $investor->data->percent_interest_investor;
			$data['investor_code'] = $investor->data->code;
			if (empty($investor->data->merchant_id) || empty($investor->data->merchant_password) || empty($investor->data->receiver_email)) {
				$this->pushJson('200', json_encode(array("code" => "401", "msg" => "Thông tin nhà đầu tư không đầy đủ", 'data' => $investor)));
				return;
			}
			$merchant_id = $investor->data->merchant_id;
			$merchant_password = $investor->data->merchant_password;
			$receiver_email = $investor->data->receiver_email;

		} else {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => "Không tìm thấy nhà đầu tư", 'data' => $investor)));
			return;
		}
		$disbursement_date = !empty($data['disbursement_date']) ? $data['disbursement_date'] : "";
		$dataPost = array(
			"code_contract" => $data['code_contract'],
			"investor_code" => $data['investor_code'],
			"disbursement_date" => !empty($disbursement_date) ? strtotime($disbursement_date) : $this->time_model->convertDatetimeToTimestamp(new DateTime()),
			"secret_key" => "",
		);
		$dataUpdate = array(
			"contract_id" => $data['contract_id'],
			"percent_interest_investor" => $percent_interest_investor,
			"code_transaction_bank_disbursement" => $data['code_transaction_bank_disbursement'],
			"bank_name_disbursement" => $data['bank_name'],
			"content_transfer_disbursement" => $data['content_transfer_disbursement'],
			"merchant_id" => $merchant_id,
			"merchant_password" => $merchant_password,
			"receiver_email" => $receiver_email,
			"investor_id" => $investor_id,
			"content_transfer" => $data['content_transfer'],
			"chan_bao_hiem" => $data['chan_bao_hiem'],
			"disbursement_date_new" => !empty($disbursement_date) ? strtotime($disbursement_date) : $this->time_model->convertDatetimeToTimestamp(new DateTime())
		);
		// call api giải ngân qua ngân lượng
		$update = $this->api->apiPost($this->userInfo['token'], "contract/accountant_investors_disbursement_nl", $dataUpdate);
		if (!empty($update->status) && $update->status == 200) {
			// nếu giải ngân thành công thì call api sinh bảng tính lãi
			if (!empty($update->code) && $update->code == '00') {
				$result = $this->api->apiPost($this->userInfo['token'], "generateContract/processContract", $dataPost);
				if (!empty($result->status) && $result->status == 200) {
					$msg = (empty($result->msg)) ? "Giải ngân thành công" : $result->msg;
					$this->pushJson('200', json_encode(array("code" => "200", "msg" => $msg)));
					return;
				} else {
					$msg = (empty($result->msg)) ? "Giải ngân thất bại" : $result->msg;
					$this->pushJson('200', json_encode(array("code" => "401", "msg" => $msg)));
					return;
				}
			}
			if (!empty($update->code) && $update->code == '01') {
				$msg = (empty($update->msg)) ? "Giải ngân thành công" : $update->msg;
				$this->pushJson('200', json_encode(array("code" => "200", "msg" => $msg)));
				return;
			}

		} else {
			$msg = (empty($update->msg)) ? "Giải ngân thất bại" : $update->msg;
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $msg, 'data' => $update)));
			return;
		}

	}

	public function disbursement_nl_max($id)
	{
		$data['id'] = $id;
		$data['id'] = $this->security->xss_clean($data['id']);

		//get list nhà đầu tư
		$listInvestor = $this->api->apiPost($this->userInfo['token'], "investor/get_investor_nl");
		if ($listInvestor->status == 200) {
			$this->data['listInvestor'] = $listInvestor->data;
		}
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		//Get information
		$contract = $this->api->apiPost($this->userInfo['token'], "contract/get_one", array("id" => $data['id']));
		if ($contract->status == 200) {
			$this->data['contractInfor'] = $contract->data;
		}
		$nextpay = $this->api->apiPost($this->userInfo['token'], "nextpay/check_store_next_pay", ['store_id'=>$contract->data->store->id]);
		if (!empty($nextpay->status) && $nextpay->status == 200) {
			$this->data['user_nextpay'] = $nextpay->data;
		}else{
			$this->data['user_nextpay'] = 0;
		}
		$this->data['template'] = 'page/pawn/disbursement_nl_max';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function investorsDisbursementNganluong_max()
	{
		$data = $this->input->post();
		$data['code_contract'] = $this->security->xss_clean($data['code_contract']);
		$data['investor_code'] = $this->security->xss_clean($data['investor_code']);
		$data['contract_id'] = $this->security->xss_clean($data['contract_id']);
		$data['content_transfer'] = $this->security->xss_clean($data['content_transfer']);
		$data['part'] = $this->security->xss_clean($data['part']);
		$data['code_transaction_bank_disbursement'] = $this->security->xss_clean($data['code_transaction_bank_disbursement']);
		$data['bank_name'] = $this->security->xss_clean($data['bank_name']);
		$data['content_transfer_disbursement'] = $this->security->xss_clean($data['content_transfer']);
		$data['chan_bao_hiem'] = $this->security->xss_clean($data['chan_bao_hiem']);

		$investor_id = $this->security->xss_clean($data['investor_id']);
		$investor = $this->api->apiPost($this->userInfo['token'], "investor/get_one", array('id' => $investor_id));
		if ($investor->status == 200) {
			$percent_interest_investor = $investor->data->percent_interest_investor;
			$data['investor_code'] = $investor->data->code;
			if (empty($investor->data->merchant_id) || empty($investor->data->merchant_password) || empty($investor->data->receiver_email)) {
				$this->pushJson('200', json_encode(array("code" => "401", "msg" => "Thông tin nhà đầu tư không đầy đủ", 'data' => $investor)));
				return;
			}
			$merchant_id = $investor->data->merchant_id;
			$merchant_password = $investor->data->merchant_password;
			$receiver_email = $investor->data->receiver_email;

		} else {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => "Không tìm thấy nhà đầu tư", 'data' => $investor)));
			return;
		}
		$disbursement_date = !empty($data['disbursement_date']) ? $data['disbursement_date'] : "";
		$dataPost = array(
			"code_contract" => $data['code_contract'],
			"investor_code" => $data['investor_code'],
			"disbursement_date" => !empty($disbursement_date) ? strtotime($disbursement_date) : $this->time_model->convertDatetimeToTimestamp(new DateTime()),
			"secret_key" => "",
		);
		$dataUpdate = array(
			"contract_id" => $data['contract_id'],
			"percent_interest_investor" => $percent_interest_investor,
			"code_transaction_bank_disbursement" => $data['code_transaction_bank_disbursement'],
			"bank_name_disbursement" => $data['bank_name'],
			"content_transfer_disbursement" => $data['content_transfer_disbursement'],
			"merchant_id" => $merchant_id,
			"merchant_password" => $merchant_password,
			"receiver_email" => $receiver_email,
			"investor_id" => $investor_id,
			"content_transfer" => $data['content_transfer'],
			"part" => $data['part'],
			"chan_bao_hiem" => $data['chan_bao_hiem'],
			"disbursement_date_new" => !empty($disbursement_date) ? strtotime($disbursement_date) : $this->time_model->convertDatetimeToTimestamp(new DateTime())
		);
		// call api giải ngân qua ngân lượng
		$update = $this->api->apiPost($this->userInfo['token'], "contract/accountant_investors_disbursement_nl_max", $dataUpdate);
		if (!empty($update->status) && $update->status == 200) {
			// nếu giải ngân thành công thì call api sinh bảng tính lãi
			if (!empty($update->code) && $update->code == '00') {
				$this->pushJson('200', json_encode(array("code" => "200", "msg" => "Thành công")));
				return;

			}
			if (!empty($update->code) && $update->code == '01') {
				$this->pushJson('200', json_encode(array("code" => "200", "msg" => $update->message)));
				return;
			}

		} else {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $update->message, 'data' => $update)));

			return;
		}

	}

	public function approve_investorsDisbursementNganluong_max()
	{
		$data = $this->input->post();
		$data['code_contract'] = $this->security->xss_clean($data['code_contract']);
		$data['investor_code'] = $this->security->xss_clean($data['investor_code']);
		$data['contract_id'] = $this->security->xss_clean($data['contract_id']);
		$data['content_transfer'] = $this->security->xss_clean($data['content_transfer']);
		$data['chan_bao_hiem'] = $this->security->xss_clean($data['chan_bao_hiem']);

		$data['code_transaction_bank_disbursement'] = $this->security->xss_clean($data['code_transaction_bank_disbursement']);
		$data['bank_name'] = $this->security->xss_clean($data['bank_name']);
		$data['content_transfer_disbursement'] = $this->security->xss_clean($data['content_transfer']);

		$investor_id = $this->security->xss_clean($data['investor_id']);
		$investor = $this->api->apiPost($this->userInfo['token'], "investor/get_one", array('id' => $investor_id));
		if ($investor->status == 200) {
			$percent_interest_investor = $investor->data->percent_interest_investor;
			$data['investor_code'] = $investor->data->code;
			if (empty($investor->data->merchant_id) || empty($investor->data->merchant_password) || empty($investor->data->receiver_email)) {
				$this->pushJson('200', json_encode(array("code" => "401", "msg" => "Thông tin nhà đầu tư không đầy đủ", 'data' => $investor)));
				return;
			}
			$merchant_id = $investor->data->merchant_id;
			$merchant_password = $investor->data->merchant_password;
			$receiver_email = $investor->data->receiver_email;

		} else {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => "Không tìm thấy nhà đầu tư", 'data' => $investor)));
			return;
		}
		$disbursement_date = !empty($data['disbursement_date']) ? $data['disbursement_date'] : "";
		$dataPost = array(
			"code_contract" => $data['code_contract'],
			"investor_code" => $data['investor_code'],
			"disbursement_date" => !empty($disbursement_date) ? strtotime($disbursement_date) : $this->time_model->convertDatetimeToTimestamp(new DateTime()),
			"secret_key" => "",
		);
		$dataUpdate = array(
			"contract_id" => $data['contract_id'],
			"percent_interest_investor" => $percent_interest_investor,
			"code_transaction_bank_disbursement" => $data['code_transaction_bank_disbursement'],
			"bank_name_disbursement" => $data['bank_name'],
			"content_transfer_disbursement" => $data['content_transfer_disbursement'],
			"merchant_id" => $merchant_id,
			"merchant_password" => $merchant_password,
			"receiver_email" => $receiver_email,
			"investor_id" => $investor_id,
			"content_transfer" => $data['content_transfer'],
			"chan_bao_hiem" => $data['chan_bao_hiem'],
			"disbursement_date_new" => !empty($disbursement_date) ? strtotime($disbursement_date) : $this->time_model->convertDatetimeToTimestamp(new DateTime())
		);
		//var_dump($dataUpdate); die;
		// call api giải ngân qua ngân lượng
		$update = $this->api->apiPost($this->userInfo['token'], "contract/approve_accountant_investors_disbursement_nl_max", $dataUpdate);
		if (!empty($update->status) && $update->status == 200) {
			// nếu giải ngân thành công thì call api sinh bảng tính lãi

			$result = $this->api->apiPost($this->userInfo['token'], "generateContract/processContract", $dataPost);
			if (!empty($result->status) && $result->status == 200) {
				$this->pushJson('200', json_encode(array("code" => "200", "msg" => $result->message)));
				return;
			} else {
				$this->pushJson('200', json_encode(array("code" => "401", "msg" => $result->message)));
				return;
			}


		} else {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $update->message, 'data' => $update)));
			return;
		}

	}


	public function accountantUpload()
	{
		$this->data["pageName"] = $this->lang->line('update_img_authentication');
		$dataGet = $this->input->get();
		$dataGet['id'] = $this->security->xss_clean($dataGet['id']);
		$dataPost = array(
			"id" => $dataGet['id']
		);
		$result = $this->api->apiPost($this->userInfo['token'], "contract/get_image_accurecy", $dataPost);
		$this->data['result'] = $result->data;
		$this->data['template'] = 'page/pawn/accountant_upload';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

// validate birthday
	function validateAge($birthday, $from = 18, $to = 59)
	{
		$today = new DateTime(date("Y-m-d"));
		$bday = new DateTime($birthday);
		$interval = $today->diff($bday);
		if (intval($interval->y) >= $from && intval($interval->y) <= $to) {
			return 'TRUE';
		} else {
			return 'FALSE';
		}
	}


	public function updateDescriptionImage()
	{
		$data = $this->input->post();
		$data['contractId'] = $this->security->xss_clean($data['contractId']);
		$expertise = array();
		if (!empty($data['expertise'])) $expertise = $this->security->xss_clean($data['expertise']);
		$sendApi = array(
			"id" => $data['contractId'],
			'expertise' => $expertise,
		);
		//var_dump($sendApi); die;
		//Insert log
		$return = $this->api->apiPost($this->user['token'], "contract/process_update_description_img", $sendApi);
		$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
	}

	public function oldContract()
	{
		$this->data["pageName"] = $this->lang->line('manage_contract');
		$this->data['tilekhoanvay'] = 0;
		$config = $this->api->apiPost($this->userInfo['token'], "config_gic/get_config", array('code' => "TN_TNNNV"));
		if (!empty($config->status) && $config->status == 200) {
			$this->data['tilekhoanvay'] = (!empty($config->data->TyLePhi)) ? $config->data->TyLePhi : 0;
		}
		$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$customer_phone_number = !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$property = !empty($_GET['property']) ? $_GET['property'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('pawn/oldContract'));
		}
		$data = array();
		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$data = array(
				"start" => $start,
				"end" => $end,
			);
		}
		if (!empty($property)) {
			$data['property'] = $property;
		}
		if (!empty($status)) {
			$data['status'] = $status;
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
		// call api get count contract
		$countContractData = $this->api->apiPost($this->userInfo['token'], "contract/get_count_old_contract", $data);
		if (!empty($countContractData->status) && $countContractData->status == 200 && $countContractData->data != 0) {
			$count = $countContractData->data;
			$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
			$config = $this->config->item('pagination');
			$config['base_url'] = base_url('pawn/oldContract?code_contract=' . $code_contract . '&code_contract_disbursement=' . $code_contract_disbursement . '&fdate=' . $start . '&tdate=' . $end . '&property=' . $property . '&status=' . $status . '&customer_name=' . $customer_name . '&customer_phone_number' . $customer_phone_number);
			$config['total_rows'] = $count;
			$config['per_page'] = 50;
			$config['page_query_string'] = true;
			$config['uri_segment'] = $uriSegment;
			$this->pagination->initialize($config);

			$this->data['pagination'] = $this->pagination->create_links();
			// call api get contract data
			$data['per_page'] = $config['per_page'];
			$data['uriSegment'] = $config['uri_segment'];

			$contractData = $this->api->apiPost($this->userInfo['token'], "contract/get_all_old_data", $data);
			if (!empty($contractData->status) && $contractData->status == 200) {
				$this->data['contractData'] = $contractData->data;
			} else {
				$this->data['contractData'] = array();
			}

		} else {
			$this->data['contractData'] = array();
		}

		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		$listInvestor = $this->api->apiPost($this->userInfo['token'], "investor/get_all");
		if ($listInvestor->status == 200) {
			$this->data['listInvestor'] = $listInvestor->data;
		}

		//get property main ( tài sản cấp cao nhất parenid == null)
		$mainPropertyData = $this->api->apiPost($this->userInfo['token'], "property/get_property_main");
		if (!empty($mainPropertyData->status) && $mainPropertyData->status == 200) {
			$this->data['mainPropertyData'] = $mainPropertyData->data;
		} else {
			$this->data['mainPropertyData'] = array();
		}
		$this->data['template'] = 'page/pawn/old_contract';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function searchAutoCompleteContract()
	{
		$data = $this->input->post();
		$data['name'] = $this->security->xss_clean($data['name']);
		$data['value'] = $this->security->xss_clean($data['value']);
		if (!empty($data['name'])) {
			$search = array(
				"name" => $data['name'],
				"value" => $data['value']
			);
			$res = $this->api->apiPost($this->user['token'], "contract/search_auto_complete", $search);
			$arrRes = array();
			foreach ($res->data as $item) {
				$data = array();
				$data['customer_email'] = !empty($item->customer_infor->customer_email) ? $item->customer_infor->customer_email : "";
				$data['customer_phone_number'] = !empty($item->customer_infor->customer_phone_number) ? $item->customer_infor->customer_phone_number : "";
				$data['customer_identify'] = !empty($item->customer_infor->customer_identify) ? $item->customer_infor->customer_identify : "";
				$data['customer_identify_old'] = !empty($item->customer_infor->customer_identify_old) ? $item->customer_infor->customer_identify_old : "";
				$data['id'] = $item->_id->{'$oid'};
				array_push($arrRes, $data);
			}
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $arrRes)));
		}
	}

	public function update_code_contract_disbursement()
	{
		$data = $this->input->post();

		$data['id'] = $this->security->xss_clean($data['id']);

		$data['code_contract_disbursement'] = $this->security->xss_clean($data['code_contract_disbursement']);

		if (empty($data['code_contract_disbursement'])) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => "Mã hợp đồng là bắt buộc ",)));
			return;
		}


		$dataPost = array(

			"id" => $data['id'],
			"code_contract_disbursement" => $data['code_contract_disbursement']
		);


		$result = $this->api->apiPost($this->userInfo['token'], "contract/update_code_contract_disbursement", $dataPost);
		if (empty($result->status)) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => "Lỗi cập nhật", "data" => $result)));
			return;
		}
		if (!empty($result->status) && $result->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $result->message, "data" => $result)));
			return;
		}
		if (!empty($result->status) && $result->status == 401) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $result->message, "data" => $result)));
			return;
		}

	}

	public function insert_company_storage()
	{

		$data = $this->input->post();

		$data['company_name'] = !empty($this->security->xss_clean($data['company_name'])) ? $this->security->xss_clean($data['company_name']) : "";
		$data['company_name_other'] = !empty($this->security->xss_clean($data['company_name_other'])) ? $this->security->xss_clean($data['company_name_other']) : "";
		$data['company_debt'] = !empty($this->security->xss_clean($data['company_debt'])) ? $this->security->xss_clean($data['company_debt']) : "";
		$data['company_finalization'] = !empty($this->security->xss_clean($data['company_finalization'])) ? $this->security->xss_clean($data['company_finalization']) : "";
		$data['company_borrowing'] = !empty($this->security->xss_clean($data['company_borrowing'])) ? $this->security->xss_clean($data['company_borrowing']) : "";
		$data['company_out_of_date'] = !empty($this->security->xss_clean($data['company_out_of_date'])) ? $this->security->xss_clean($data['company_out_of_date']) : "";
		$data['check_phone'] = !empty($this->security->xss_clean($data['check_phone'])) ? $this->security->xss_clean($data['check_phone']) : "";

		$data1 = [
			'company_name' => $data['company_name'],
			'company_name_other' => $data['company_name_other'],
			'company_debt' => $data['company_debt'],
			'company_finalization' => $data['company_finalization'],
			'company_borrowing' => $data['company_borrowing'],
			'company_out_of_date' => $data['company_out_of_date'],
			'check_phone' => $data['check_phone'],
		];

		$return = $this->api->apiPost($this->user['token'], "company_storage/insert_company_storage", $data1);

		$response = [
			'res' => true,
			'status' => "200",
			'data' => $return
		];
		echo json_encode($response);
		return;
	}

	public function delete_company_storage()
	{
		$data = $this->input->post();

		$data['id'] = !empty($this->security->xss_clean($data['id'])) ? $this->security->xss_clean($data['id']) : "";
		$data1 = [
			'id' => $data['id'],
		];
		$return = $this->api->apiPost($this->user['token'], "company_storage/delete_company", $data1);

		$response = [
			'res' => true,
			'status' => "200",
			'data' => $return
		];
		echo json_encode($response);
		return;

	}

	public function downloadImage()
	{
		$this->load->library('zip');
		$this->load->helper('file');
		$this->data["pageName"] = $this->lang->line('view_img_authentication');
		$this->data['template'] = 'page/pawn/view_img';
		$dataGet = $this->input->get();
		$dataGet['id'] = $this->security->xss_clean($dataGet['id']);
		$dataPost = array(
			"id" => $dataGet['id']
		);
		$result = $this->api->apiPost($this->userInfo['token'], "contract/get_image_accurecy", $dataPost);
		$files_img = array();

		foreach ((array)$result->data->identify as $key => $value) {
			if (empty($value)) continue;
			if (!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) {
				array_push($files_img, $value->path);
			}
		}
		foreach ((array)$result->data->household as $key => $value) {
			if (empty($value)) continue;
			if (!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) {
				array_push($files_img, $value->path);
			}
		}

		foreach ((array)$result->data->driver_license as $key => $value) {
			if (empty($value)) continue;
			if (!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) {
				array_push($files_img, $value->path);
			}
		}

		foreach ((array)$result->data->vehicle as $key => $value) {
			if (empty($value)) continue;
			if (!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) {
				array_push($files_img, $value->path);
			}
		}

		foreach ((array)$result->data->agree as $key => $value) {
			if (empty($value)) continue;
			if (!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) {
				array_push($files_img, $value->path);
			}
		}
		foreach ((array)$result->data->expertise as $key => $value) {
			if (empty($value)) continue;
			if (!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) {
				array_push($files_img, $value->path);
			}
		}

		$zip = new ZipArchive();
		# create a temp file & open it
		$tmp_file = tempnam('assets/imgs/upload', '');
		$zip->open($tmp_file, ZipArchive::CREATE);
		# loop through each file
		foreach ($files_img as $file) {
			# download file

			$download_file = file_get_contents($file);
			#add it to the zip
			$zip->addFromString(basename($file), $download_file);
		}
		# close zip
		$zip->close();

		# send the file to the browser as a download
		header('Content-disposition: attachment; filename="Anh_chung_tu.zip"');
		header('Content-type: application/zip');
		readfile($tmp_file);
		unlink($tmp_file);
	}

	public function insert_log_comment()
	{

		$data = $this->input->post();

		$data['add_comment'] = $this->security->xss_clean($data['add_comment']);
		$data['comment_id'] = $this->security->xss_clean($data['comment_id']);

		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());

		if (empty($data['add_comment'])) {

			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Bạn chưa nhập đầy đủ ghi chú"
			];
			echo json_encode($response);
			return;
		}

		$data = array(
			"add_comment" => !empty($data['add_comment']) ? $data['add_comment'] : '',
			"comment_id" => !empty($data['comment_id']) ? $data['comment_id'] : '',
			"created_at" => $this->createdAt,
			"user" => !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "",
		);
		$return = $this->api->apiPost($this->user['token'], "log/create_log_comment", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'msg' => 'Thêm mới thành công',
				'url' => $return->url
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => 'Thất bại',
				'data' => $return
			];
			echo json_encode($response);
			return;
		}
	}

	public function list_tnds()
	{
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$full_name = !empty($_GET['full_name']) ? $_GET['full_name'] : "";
		$phone = !empty($_GET['phone']) ? $_GET['phone'] : "";
		$type_tnds = !empty($_GET['type_tnds']) ? $_GET['type_tnds'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$config = $this->config->item('pagination');
		$config['per_page'] = 30;
		$config['uri_segment'] = $uriSegment;

		$data = array(
			"per_page" => $config['per_page'],
			"uriSegment" => $config['uri_segment']
		);
		if (strtotime($start) > strtotime($end)) {
			$this->session->set_flashdata('error', $this->lang->line('Error_formatting_date'));
			redirect(base_url('pawn/list_tnds'));
		}

		if (!empty($_GET['fdate']) && !empty($_GET['tdate'])) {
			$data['start'] = $start;
			$data['end'] = $end;
		}
		if (!empty($_GET['full_name'])) {
			$data['full_name'] = trim($full_name);
		}
		if (!empty($_GET['type_tnds'])) {
			$data['type_tnds'] = trim($type_tnds);
		}
		if (!empty($_GET['phone'])) {
			$data['phone'] = trim($phone);
		}
		if (!empty($_GET['code_contract_disbursement'])) {
			$data['code_contract_disbursement'] = trim($code_contract_disbursement);
		}
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$config['base_url'] = base_url('pawn/list_tnds?fdate=' . $start . '&tdate=' . $end);
		$this->data["pageName"] = $this->lang->line('Gic_manager');
		$data = $this->api->apiPost($this->userInfo['token'], "baoHiemTNDS/get_list_tnds", $data);
		if (!empty($data->status) && $data->status == 200) {
			$this->data['bao_hiem'] = $data->data;
			$config['total_rows'] = $data->total;
		} else {
			$this->data['bao_hiem'] = array();
		}
		$groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}
		$this->pagination->initialize($config);
		$this->data['result_count'] = $config['total_rows'];
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/pawn/list_tnds';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}

	public function gui_lai_tnds()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : '';
		$res = $this->api->apiPost($this->userInfo['token'], "contract/restore_tnds", ['id_contract' => $id]);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $res->message)));
			return;
		} elseif (!empty($res->status) && $res->status == 401) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $res->message)));
			return;
		}
	}

	public function update_follow_contract(){

		$data = $this->input->post();
		$data['follow_email'] = $this->security->xss_clean($data['follow_email']);
		$data['follow_idStore'] = $this->security->xss_clean($data['follow_idStore']);
		$data['follow_idEmail'] = $this->security->xss_clean($data['follow_idEmail']);
		$id = $this->security->xss_clean($data['id']);

		$data = array(
			"follow_email" => !empty($data['follow_email']) ? $data['follow_email'] : '',
			"follow_idStore" => !empty($data['follow_idStore']) ? $data['follow_idStore'] : '',
			"follow_idEmail" => !empty($data['follow_idEmail']) ? $data['follow_idEmail'] : '',
			'id' => $id
		);

		$return = $this->api->apiPost($this->userInfo['token'], "store/update_follow_contract", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'data' => $return->data
			];
			echo json_encode($response);
			return;
		}


	}

	public function change_status_contract()
	{
		$data = $this->input->post();
		$contract_id = $this->security->xss_clean($data['id_contract']);
		$status_contract = $this->security->xss_clean($data['status_contract']);
		$dataSend = [
			'contract_id' => $contract_id,
			'status_contract' => $status_contract
		];
		$result = $this->api->apiPost($this->userInfo['token'], "Contract/update_status_contract_event", $dataSend);
		if (!empty($result->status) && $result->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'msg' => $result->msg,
				'url' => $result->url
			];
			//echo json_encode($response);
			$this->pushJson('200', json_encode($response));
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => 'Có lỗi trong quá trình cập nhật!',
				'data' => $result
			];
			$this->pushJson('200', json_encode($response));
			return;
		}
	}

	public function change_customer_resource()
	{
		$data = $this->input->post();
		$id_contract = $this->security->xss_clean($data['id_contract']);
		$customer_resource = $this->security->xss_clean($data['customer_resources']);
		$note_change_source = $this->security->xss_clean($data['note_change_source']);
		$dataSend = [
			'id_contract' => $id_contract,
			'customer_resources' => $customer_resource,
			'note_change_source' => $note_change_source,
		];
		$result = $this->api->apiPost($this->userInfo['token'], "contract/update_customer_resource", $dataSend);
		if (!empty($result->status) && $result->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'msg' => $result->message,
			];
			//echo json_encode($response);
			$this->pushJson('200', json_encode($response));
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => 'Có lỗi trong quá trình cập nhật!',
				'data' => $result
			];
			$this->pushJson('200', json_encode($response));
			return;
		}
	}

	public function status_contract_megadoc()
	{
		$data = $this->input->post();
		$searchkey = !empty($this->security->xss_clean($data['searchkey'])) ? $this->security->xss_clean($data['searchkey']) : '';
		$code_contract = !empty($this->security->xss_clean($data['code_contract'])) ? $this->security->xss_clean($data['code_contract']) : '';
		$dataSend = array();
		if (!empty($searchkey)) {
			$dataSend['searchkey'] = $searchkey;
		}
		if (!empty($code_contract)) {
			$dataSend['code_contract'] = $code_contract;
		}
		$response = $this->api->apiPost($this->userInfo['token'], "contract/get_status_megadoc", $dataSend);
		if (!empty($response->status) && $response->status == 200) {
			$this->pushJson('200', json_encode(array("status" => "200", "data" => $response->data)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("status" => "401", "msg" => 'Có lỗi trong quá trình lấy dữ liệu megadoc!')));
			return;
		}
	}

	public function cancel_contract_megadoc()
	{
		$data = $this->input->post();
		$fkey = $this->security->xss_clean($data['fkey_send']) ? $this->security->xss_clean($data['fkey_send']) : '';
		$contract_no = $this->security->xss_clean($data['contract_no_send']) ? $this->security->xss_clean($data['contract_no_send']) : '';
		$reason_cancel_megadoc = $this->security->xss_clean($data['reason_cancel_megadoc']) ? $this->security->xss_clean($data['reason_cancel_megadoc']) : '';
		$dataSend = array();
		if (!empty($fkey)) {
			$dataSend['fkey'] = $fkey;
		}
		if (!empty($contract_no)) {
			$dataSend['contract_no'] = $contract_no;
		}
		if (!empty($reason_cancel_megadoc)) {
			$dataSend['reason_cancel_megadoc'] = $reason_cancel_megadoc;
		} else {
			$this->pushJson('200', json_encode(array("status" => "401", "msg" => "Bạn chưa nhập lý do hủy hợp đồng Megadoc!")));
			return;
		}
		$result = $this->api->apiPost($this->userInfo['token'], "Contract/cancel_contract_megadoc", $dataSend);
		if (!empty($result->status) && $result->status == 200) {
			$this->pushJson('200', json_encode(array("status" => "200", "msg" => $result->message)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("status" => "401", "msg" => "Có lỗi trong quá trình hủy hợp đồng hoặc chưa tồn tại hợp đồng điện tử Megadoc!")));
			return;
		}
	}

	/**
	 * send param to api
	 * @param string | $id_contract
	 * @param string | $code_contract ma phieu ghi
	 * @param string | $new_code_contract_disbursement ma hop dong
	 * @param string | $note_edit_code_contract_disbursement ghi chu
	 * @return void
	 */
	public function edit_code_contract_d()
	{
		$data = $this->input->post();
		$id_contract = $this->security->xss_clean($data['id_contract']);
		$code_contract = $this->security->xss_clean($data['code_contract']);
		$new_code_contract_disbursement = $this->security->xss_clean($data['new_code_contract_disbursement']);
		$note_edit_code_contract_disbursement = $this->security->xss_clean($data['note_edit_code_contract_disbursement']);
		if (empty($new_code_contract_disbursement)) {
			$response_js = array(
				'res' => false,
				'status' => '401',
				'msg' => "Bạn chưa nhập mã hợp đồng mới!"
			);
			$this->pushJson('200', json_encode($response_js));
			return;
		}
		$dataSend = array();
		if (!empty($id_contract)) {
			$dataSend['id_contract'] = $id_contract;
		}
		if (!empty($code_contract)) {
			$dataSend['code_contract'] = $code_contract;
		}
		if (!empty($new_code_contract_disbursement)) {
			$dataSend['new_code_contract_disbursement'] = $new_code_contract_disbursement;
		}
		if (!empty($note_edit_code_contract_disbursement)) {
			$dataSend['note_edit_code_contract_disbursement'] = $note_edit_code_contract_disbursement;
		}
		$result = $this->api->apiPost($this->userInfo['token'], 'Contract/edit_code_contract_d', $dataSend);
		if (!empty($result->status) && $result->status == 200) {
			$response_js = array(
				'res' => true,
				'status' => '200',
				'msg' => $result->message
			);
			$this->pushJson('200', json_encode($response_js));
			return;
		} else {
			$response_js = array(
				'res' => false,
				'status' => '401',
				'msg' => $result->message
			);
			$this->pushJson('200', json_encode($response_js));
			return;
		}
	}

	public function resend_file_to_megadoc()
	{
		$data = $this->input->post();
		$contract_id = !empty($this->security->xss_clean($data['id_contract'])) ? $this->security->xss_clean($data['id_contract']) : '';
		$status_approve = !empty($this->security->xss_clean($data['status_approve'])) ? $this->security->xss_clean($data['status_approve']) : '';
		$create_type = !empty($this->security->xss_clean($data['create_type'])) ? $this->security->xss_clean($data['create_type']) : '';
		$dataSend = array();
		if (!empty($contract_id)) {
			$dataSend['contract_id'] = $contract_id;
		}
		if (!empty($status_approve)) {
			$dataSend['status_approve'] = $status_approve;
		}
		if (!empty($create_type)) {
			$dataSend['create_type'] = $create_type;
		}

		$result = $this->api->apiPost($this->userInfo['token'], "contract/resend_file_to_megadoc", $dataSend);
		if (!empty($result->status) && $result->status == 200) {
			$response_js = array(
				'res' => true,
				'status' => '200',
				'msg' => $result->message
			);
			$this->pushJson('200', json_encode($response_js));
			return;
		} else {
			$response_js = array(
				'res' => false,
				'status' => '401',
				'msg' => $result->message
			);
			$this->pushJson('200', json_encode($response_js));
			return;
		}
	}

	public function download_file_megadoc()
	{
		$data = $this->input->post();
		$searchkey = !empty($this->security->xss_clean($data['searchkey'])) ? $this->security->xss_clean($data['searchkey']) : "";
		$file_type = !empty($this->security->xss_clean($data['file_type'])) ? $this->security->xss_clean($data['file_type']) : "";
		$code_contract = !empty($this->security->xss_clean($data['code_contract'])) ? $this->security->xss_clean($data['code_contract']) : "";
		$dataSend = array();
		if (!empty($searchkey)) {
			$dataSend['searchkey'] = $searchkey;
		}
		if (!empty($file_type)) {
			$dataSend['file_type'] = $file_type;
		}
		if (!empty($code_contract)) {
			$dataSend['code_contract'] = $code_contract;
		}
		$result = $this->api->apiPost($this->userInfo['token'], "contract/download_file_megadoc", $dataSend);
		if (!empty($result->status) && $result->status == 200) {
			$response_js = array(
				'res' => true,
				'status' => '200',
				'msg' => $result->message,
				'url' => $result->data
			);
			$this->pushJson('200', json_encode($response_js));
			return;
		} else {
			$response_js = array(
				'res' => false,
				'status' => '401',
				'msg' => $result->message
			);
			$this->pushJson('200', json_encode($response_js));
			return;
		}

	}

	public function sync_status_megadoc()
	{
		$data = $this->input->post();
		$id_contract = !empty($this->security->xss_clean($data['id_contract'])) ? $this->security->xss_clean($data['id_contract']) : '';
		$data_send_api = array(
			'id_contract' => $id_contract
		);
		$response = $this->api->apiPost($this->userInfo['token'], "contract/sync_status_megadoc", $data_send_api);
		if (!empty($response->status) && $response->status == 200) {
			$this->pushJson('200', json_encode(array("status" => "200", "data" => $response->data)));
			return;
		} else {
			$this->pushJson('200', json_encode(array("status" => "401", "msg" => 'Có lỗi trong quá trình lấy dữ liệu megadoc!')));
			return;
		}
	}

	public function resend_sms_megadoc()
	{
		$data = $this->input->post();
		$code_contract = !empty($this->security->xss_clean($data['code_contract'])) ? $this->security->xss_clean($data['code_contract']) : '';
		$sms_id = !empty($this->security->xss_clean($data['sms_id'])) ? $this->security->xss_clean($data['sms_id']) : '';
		$data_send_api = [
			'code_contract' =>  $code_contract,
			'sms_id' =>  $sms_id
		];
		$response = $this->api->apiPost($this->userInfo['token'],"contract/resend_sms_megadoc", $data_send_api);
		if (!empty($response->status) && $response->status == 200) {
			$this->pushJson("200", json_encode(array("status" => "200", "res" => true, "msg" => $response->message)));
			return;
		} else {
			$this->pushJson("200", json_encode(array("status" => "401", "res" => false, "msg" => $response->message)));
			return;
		}
	}

	private function check_store_apply_contract_digital()
	{
		$userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
		$stores = !empty($userInfo['stores']) ? $userInfo['stores'] : array();
		//get store
		$storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all", array());
		$arr_store = array();
		$code_domain = '';
		if (!empty($storeData->status) && $storeData->status == 200 && !empty($stores)) {
			foreach ($stores as $key => $store) {
				$arr_store += [$key => $store->store_id];
			}
			foreach ($storeData->data as $key => $value) {
				if ($value->status != 'active' || !in_array($value->_id->{'$oid'}, $arr_store)) {
					unset($storeData->data[$key]);

				} else {
					$area = $this->api->apiPost($this->userInfo['token'], "area/get_area_by_code", array('code' => $value->code_area));
					if (!empty($area->status) && $area->status == 200) {
						$code_domain = $area->data->domain->code;
					}
				}
			}
			$all_store = $storeData->data;
		} else {
			$all_store = array();
		}

		$storeDataCentral = $this->api->apiPost($this->userInfo['token'], "Store/getAllStoreCentralNoneDirectSales", array());
		if (!empty($storeDataCentral->status) && $storeDataCentral->status == 200) {
			$arr_store_cc = $storeDataCentral->data;
		} else {
			$arr_store_cc = array();
		}
		$id_store_of_user = '';
		if (!empty($all_store)) {
			foreach ($all_store as $key => $sto) {
				if (in_array($sto->_id->{'$oid'}, $arr_store_cc)) {
					continue;
				}
				$id_store_of_user = $sto->_id->{'$oid'};
			}
		}
		$store_megadoc = $this->api->apiPost($this->userInfo['token'], "nextpay/check_store_create_contract_digital", ["store_id" => $id_store_of_user]);
		if (!empty($store_megadoc->status) && $store_megadoc->status == 200) {
			$is_store_contract_digital = $store_megadoc->data;
		} else {
			$is_store_contract_digital = 0;
		}
		if (!empty($is_store_contract_digital) && $is_store_contract_digital == 1) {
			return true;
		} else {
			return false;
		}

	}


	public function checkContract(){
		$data = $this->input->post();
		$customer_identify = !empty($this->security->xss_clean($data['customer_identify'])) ? $this->security->xss_clean($data['customer_identify']) : '';

		$result = $this->api->apiPost($this->userInfo['token'], "contract/checkContract", ['customer_identify' => $customer_identify]);

		if (!empty($result) && $result->status == 200) {

			$res = $this->api->apiPost($this->user['token'], "contract/coppy_contract", ['code_contract' => $result->code_contract, 'code' => 1]);


			if (!empty($res) && $res->status == 200){
				$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "200"))));

			} else {
				$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => "Tạo hợp đồng mới không thành công"))));
			}

		} else {

			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $result->message))));
		}

	}

	private function apiListSeriPositioningDevices(){

		$result = $this->api->apiPost($this->userInfo['token'], "contract/get_device_asset_location");
		$listSeriPositioningDevices = [];
		if (!empty($result)){
			foreach ($result->data as $value){
				$listSeriPositioningDevices += [$value->_id->{'$oid'} => "$value->code"];
			}
		}
		return $listSeriPositioningDevices;
	}

	/**
	 * Check SĐT nhân viên VFC
	 */
	public function check_staff_phone_validate($phone_number_relative)
	{
		$dataSendApi = [
			'phone_number_relative' => $phone_number_relative
		];
		$check_staff_phone = $this->api->apiPost($this->userInfo['token'], 'User/check_staff_phone', $dataSendApi);
		if (isset($check_staff_phone->status) && $check_staff_phone->status == 200) {
			if ($check_staff_phone->data == true) {
				$response = [
					'status' => 200,
					'message' => 'Không được dùng SĐT: '. $phone_number_relative .' của nhân viên VFC: ' . $check_staff_phone->email_user . ' làm tham chiếu!'
				];
				return $response;
			} else {
				$response = [
					'status' => 400,
					'message' => ''
				];
				return $response;
			}
		}
	}

	/**
	 * Check validate SĐT nhân viên VFC
	 */
	public function check_phone_relative($number_phone_relative_one, $number_phone_relative_two, $number_phone_relative_three)
	{
		if (!empty($number_phone_relative_one)) {
			$response = $this->check_staff_phone_validate($number_phone_relative_one);
			if (!empty($response['status']) && $response['status'] == 200) {
				return $response;
			}
		}
		if (!empty($number_phone_relative_two)) {
			$response = $this->check_staff_phone_validate($number_phone_relative_two);
			if (!empty($response['status']) && $response['status'] == 200) {
				return $response;
			}
		}
		if (!empty($number_phone_relative_three)) {
			$response = $this->check_staff_phone_validate($number_phone_relative_three);
			if (!empty($response['status']) && $response['status'] == 200) {
				return $response;
			}
		}
	}



}

?>

<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
class Investors extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->api = new Api();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model("time_model");
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
			date_default_timezone_set('Asia/Ho_Chi_Minh');
	}
	 public function doUpdateStatusInvestors()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$status = ($status=='true') ? 'active' : 'deactive';
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_investors_selected_deletion')
			];
			echo json_encode($response);
			return;
		}
			if (empty($status)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_investors_selected_deletion')
			];
			echo json_encode($response);
			return;
		}
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		$data = array(
			"status" => $status,
			"updated_at" => $createdAt,
			"updated_by" => $this->userInfo['email'],
			"id" => $id
		);
		$return = $this->api->apiPost($this->userInfo['token'], "investor/update_investors", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_investors')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Investors_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}

	public function deleteInvestors()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_investors_selected_deletion')
			];
			echo json_encode($response);
			return;
		}
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		$data = array(
			"status" => 'block',
			"updated_at" => $createdAt,
			"updated_by" => $this->userInfo['email'],
			"id" => $id
		);
		$return = $this->api->apiPost($this->userInfo['token'], "investor/update_investors", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_investors')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Investors_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}
    public function doGetTemporary_plan_contract()
	{
		$code_contract = !empty($_POST['code_contract']) ? $_POST['code_contract'] : "";
		if (empty($code_contract)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_investors_selected_deletion')
			];
			echo json_encode($response);
			return;
		}
		
		$data = array(
		
			"code_contract" => $code_contract
		);
		$return = $this->api->apiPost($this->userInfo['token'], "investor/get_temporary_plan_contract", $data);
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
				'message' => $this->lang->line('Investors_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}
	  
	public function doUpdateInvestors()
	{
		$type_investors = !empty($_POST['type_investors']) ? $_POST['type_investors'] : "";
		$merchant_id = !empty($_POST['merchant_id']) ? $_POST['merchant_id'] : "";
		$merchant_password = !empty($_POST['merchant_password']) ? $_POST['merchant_password'] : "";
		$receiver_email = !empty($_POST['receiver_email']) ? $_POST['receiver_email'] : "";
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		$code = !empty($_POST['code']) ? $_POST['code'] : "";
		$name = !empty($_POST['name']) ? $_POST['name'] : "";
		$dentity_card = !empty($_POST['dentity_card']) ? $_POST['dentity_card'] : "";
		$balance = !empty($_POST['balance']) ? $_POST['balance'] : "";
		$tax_code = !empty($_POST['tax_code']) ? $_POST['tax_code'] : "";
		$percent_interest_investor = !empty($_POST['percent_interest_investor']) ? $_POST['percent_interest_investor'] : "";
		$date_of_birth = !empty($_POST['date_of_birth']) ? $_POST['date_of_birth'] : "";
		$address = !empty($_POST['address']) ? $_POST['address'] : "";
		$email = !empty($_POST['email']) ? $_POST['email'] : "";
		$phone = !empty($_POST['phone']) ? $_POST['phone'] : "";
		$form_of_receipt = !empty($_POST['form_of_receipt']) ? $_POST['form_of_receipt'] : "";
		$account_number = !empty($_POST['account_number']) ? $_POST['account_number'] : "";
		$period = !empty($_POST['period']) ? $_POST['period'] : "";
		$bank = !empty($_POST['bank']) ? $_POST['bank'] : "";
		$bank_branch = !empty($_POST['bank_branch']) ? $_POST['bank_branch'] : "";
		$status = !empty($_POST['status']) ? $_POST['status'] : "";
	
		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		if (empty($merchant_id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Không được để trống merchant id ngân lượng"
			];
			echo json_encode($response);
			return;
		}
		if (empty($merchant_password)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Không được để trống merchant password ngân lượng"
			];
			echo json_encode($response);
			return;
		}
		if (empty($receiver_email)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Không được để trống receiver email ngân lượng"
			];
			echo json_encode($response);
			return;
		}

		if (empty($code)) {
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Investors_code_empty')
			];
			echo json_encode($response);
			return;
		}
		
		if (empty($name)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Investors_name_empty')
			];
			echo json_encode($response);
			return;
		}
		$data = array(
			"type_investors" => $type_investors,
			"merchant_id" => $merchant_id,
			"merchant_password" => $merchant_password,
			"receiver_email" => $receiver_email,
			"code" => $code,
			"name" => $name,
			"dentity_card" => $dentity_card,
			"balance" => $balance,
			"tax_code" => $tax_code,
			"percent_interest_investor" => $percent_interest_investor,
			"phone" => $phone,
			"date_of_birth"=>$date_of_birth,
			"address" => $address,
			"email" => $email,
			"period" => $period,
			"form_of_receipt" => $form_of_receipt,
			"account_number" => $account_number,
			"bank" => $bank,
			"bank_branch" => $bank_branch,
			"status" => $status,
			"updated_at" => $updateAt,
			"updated_by" => $this->userInfo['email'],
			"id"=>$id

		);
		$return = $this->api->apiPost($this->userInfo['token'], "investor/update_investors", $data);
      // die;
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successful_investors_update')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Failed_investors_update'),
				'data'=>$image
			];
			echo json_encode($response);
			return;
		}
	}
    public function doUpdateTemporary_plan_contract()
	{
		$id_contract = !empty($_POST['id_contract']) ? $_POST['id_contract'] : "";
        $ma_giao_dich_ngan_hang = !empty($_POST['ma_giao_dich_ngan_hang']) ? $_POST['ma_giao_dich_ngan_hang'] : "";
        $ghi_chu = !empty($_POST['ghi_chu']) ? $_POST['ghi_chu'] : "";
		$ngay_tra = !empty($_POST['ngay_tra']) ?$this->time_model->convertDatetimeToTimestamp(date_create($_POST['ngay_tra'].' 23:59:59') ) : "";
		$so_tien_lai_da_tra = !empty($_POST['so_tien_lai_da_tra']) ? $_POST['so_tien_lai_da_tra'] : 0;
		$so_tien_goc_da_tra = !empty($_POST['so_tien_goc_da_tra']) ? $_POST['so_tien_goc_da_tra'] : 0;
		$so_tien_lai_phai_tra = !empty($_POST['so_tien_lai_phai_tra']) ? $_POST['so_tien_lai_phai_tra'] : 0;
		$so_tien_goc_phai_tra = !empty($_POST['so_tien_goc_phai_tra']) ? $_POST['so_tien_goc_phai_tra'] : 0;
		$hinh_thuc_tra = !empty($_POST['hinh_thuc_tra']) ? $_POST['hinh_thuc_tra'] : "";
		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
        if (empty($ma_giao_dich_ngan_hang)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Mã giao dịch ngân hàng không được để trống"
			];
			echo json_encode($response);
			return;
		}
		if (empty($ghi_chu)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Ghi chú không được để trống"
			];
			echo json_encode($response);
			return;
		}
		
		if (empty($ngay_tra)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => "Ngày trả không được để trống"
			];
			echo json_encode($response);
			return;
		}
		// if (empty($so_tien_lai_da_tra)) {
		
		// 	$response = [
		// 		'res' => false,
		// 		'status' => "400",
		// 		'msg' =>  "Số tiền lãi đã trả không được để trống"
		// 	];
		// 	echo json_encode($response);
		// 	return;
		// }
		
		// if (empty($so_tien_goc_da_tra)) {
			
		// 	$response = [
		// 		'res' => false,
		// 		'status' => "400",
		// 		'msg' => "Số tiền gốc đã trả không được để trống"
		// 	];
		// 	echo json_encode($response);
		// 	return;
		// }
		
		$data = array(
		
			"lich_su_tra_ndt_thu"=>[
				'ngay_tra'=>$ngay_tra,
				'so_tien_lai_da_tra'=>(float)str_replace(',', '', $so_tien_lai_da_tra),
				'so_tien_goc_da_tra'=>(float)str_replace(',', '', $so_tien_goc_da_tra),
				'hinh_thuc_tra'=>$hinh_thuc_tra,
				'ma_giao_dich_ngan_hang'=>$ma_giao_dich_ngan_hang,
				'tien_goc_1ky_da_tra'=>0,
				'tien_lai_1ky_da_tra'=>0,
				'tien_goc_1ky_con_lai'=>0,
				'tien_lai_1ky_con_lai'=>0,
				'ghi_chu'=>$ghi_chu,
				'updated_at' => $updateAt,
			    'updated_by' => $this->userInfo['email']
			],
			"id_contract"=>$id_contract

		);
		$return = $this->api->apiPost($this->userInfo['token'], "investor/update_temporary_plan_contract", $data);
      // die;
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'msg' => $this->lang->line('Successful_investors_update'),
				'url' => $return->url
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'msg' => $this->lang->line('Failed_investors_update'),
				'data'=>$return
			];
			echo json_encode($response);
			return;
		}
	}
	public function update()
	{
		$this->data["pageName"] = $this->lang->line('update_investors');
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		// get investors by id
		$data = array(
			"id" => $id,
			// "type_login" => 1
		);
		$investors = $this->api->apiPost($this->userInfo['token'], "investor/get_one", $data);
		if (!empty($investors->status) && $investors->status == 200) {
			$this->data['investors'] = $investors->data;
		} else {
			$this->data['investors'] = array();
		}
		 $bankData = $this->api->apiPost($this->userInfo['token'], "bankVimo/get_all", $data);
        if(!empty($bankData->status) && $bankData->status == 200){
            $this->data['bankData'] = $bankData->data;
        }else{
            $this->data['bankData'] = array();
        }
		if (empty($investors->data)) {
			echo "404";
			die;
			redirect('404');
		}
		
		$this->data['template'] = 'page/investors/update_investors';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function listInvestors()
	{
		$this->data["pageName"] = $this->lang->line('Investors_manager');
		$data = array(// "type_login" => 1
		);
		$investorsData = $this->api->apiPost($this->userInfo['token'], "investor/get_all", $data);
			//var_dump($this->userInfo['token']); die;
		if (!empty($investorsData->status) && $investorsData->status == 200) {
			$this->data['investorsData'] = $investorsData->data;
		} else {
			$this->data['investorsData'] = array();
		}

		$this->data['template'] = 'page/investors/list_investors';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
     public function view_detail()
	{
       	$this->data["pageName"] = $this->lang->line('investors_view_detail');
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		// get investors by id
		$data = array(
			"id" => $id,
			// "type_login" => 1
		);
		
		$investors = $this->api->apiPost($this->userInfo['token'], "investor/get_one", $data);
		if (!empty($investors->status) && $investors->status == 200) {
			$this->data['investors'] = $investors->data;
		} else {
			$this->data['investors'] = array();
		}
		$contractData = $this->api->apiPost($this->userInfo['token'], "investor/get_investor_in_contract",$data);
		//var_dump($this->userInfo['token']); die;
		if (!empty($contractData->status) && $contractData->status == 200) {
			$this->data['contractData'] = $contractData->data;
		} else {
			$this->data['contractData'] = array();
		}
		$this->data['template'] = 'page/investors/view_detail_investors';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
	 public function view_payment()
	{
       	$this->data["pageName"] = $this->lang->line('investors_view_detail');
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
	
		$contractData = $this->api->apiPost($this->userInfo['token'], "investor/get_investor",array());
		//var_dump($this->userInfo['token']); die;
		if (!empty($contractData->status) && $contractData->status == 200) {
			$this->data['contractData'] = $contractData->data;
		} else {
			$this->data['contractData'] = array();
		}
		$this->data['template'] = 'page/investors/list_payment_investors';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
	public function view_detail_payment()
	{
       	$this->data["pageName"] = $this->lang->line('investors_view_detail');
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		// get investors by id
		$data = array(
			"id" => $id,
			// "type_login" => 1
		);
	
		$contractData = $this->api->apiPost($this->userInfo['token'], "investor/get_investor_payment",$data);
		//var_dump($this->userInfo['token']); die;
		if (!empty($contractData->status) && $contractData->status == 200) {
			$this->data['contract'] = $contractData->dataContract;
			$this->data['temData'] = $contractData->dataTem;
			$this->data['tranData'] = $contractData->dataTran;
			//var_dump($this->data['temData']); die;
		} else {
			$this->data['contract'] = array();
			$this->data['temData'] = array();
		}
		$this->data['template'] = 'page/investors/view_payment_detail';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
	public function doAddInvestors()
	{
		
		$type_investors = !empty($_POST['type_investors']) ? $_POST['type_investors'] : "";
		$merchant_id = !empty($_POST['merchant_id']) ? $_POST['merchant_id'] : "";
		$merchant_password = !empty($_POST['merchant_password']) ? $_POST['merchant_password'] : "";
		$receiver_email = !empty($_POST['receiver_email']) ? $_POST['receiver_email'] : "";
		$code = !empty($_POST['code']) ? $_POST['code'] : "";
		$name = !empty($_POST['name']) ? $_POST['name'] : "";
		$dentity_card = !empty($_POST['dentity_card']) ? $_POST['dentity_card'] : "";
		$balance = !empty($_POST['balance']) ? $_POST['balance'] : "";
		$tax_code = !empty($_POST['tax_code']) ? $_POST['tax_code'] : "";
		$percent_interest_investor = !empty($_POST['percent_interest_investor']) ? $_POST['percent_interest_investor'] : "";
		$date_of_birth = !empty($_POST['date_of_birth']) ? $_POST['date_of_birth'] : "";
		$address = !empty($_POST['address']) ? $_POST['address'] : "";
		$email = !empty($_POST['email']) ? $_POST['email'] : "";
		$phone = !empty($_POST['phone']) ? $_POST['phone'] : "";
		$form_of_receipt = !empty($_POST['form_of_receipt']) ? $_POST['form_of_receipt'] : "";
		$account_number = !empty($_POST['account_number']) ? $_POST['account_number'] : "";
		$bank = !empty($_POST['bank']) ? $_POST['bank'] : "";
		$bank_branch = !empty($_POST['bank_branch']) ? $_POST['bank_branch'] : "";
		$period = !empty($_POST['period']) ? $_POST['period'] : "";
		$status = !empty($_POST['status']) ? $_POST['status'] : "";
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		
		if (empty($merchant_id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Không được để trống merchant id ngân lượng"
			];
			echo json_encode($response);
			return;
		}
		if (empty($merchant_password)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Không được để trống merchant password ngân lượng"
			];
			echo json_encode($response);
			return;
		}
		if (empty($receiver_email)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Không được để trống receiver email ngân lượng"
			];
			echo json_encode($response);
			return;
		}

		if (empty($code)) {
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Investors_code_empty')
			];
			echo json_encode($response);
			return;
		}
		
		if (empty($name)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Investors_name_empty')
			];
			echo json_encode($response);
			return;
		}

		$data = array(
			"type_investors" => $type_investors,
			"merchant_id" => $merchant_id,
			"merchant_password" => $merchant_password,
			"receiver_email" => $receiver_email,
			"code" => $code,
			"name" => $name,
			"dentity_card" => $dentity_card,
			"balance" => $balance,
			"tax_code" => $tax_code,
			"percent_interest_investor" => $percent_interest_investor,
			"phone" => $phone,
			"address" => $address,
			"email" => $email,
			"date_of_birth"=>$date_of_birth,
			"form_of_receipt" => $form_of_receipt,
			"account_number" => $account_number,
			"bank" => $bank,
			"period" => $period,
			"bank_branch" => $bank_branch,
			"status" => $status,
			"created_at" => $createdAt,
			"updated_at" => $createdAt,
			"created_by" => $this->userInfo['email'],
			"updated_by" => $this->userInfo['email'],

		);
       
		$return = $this->api->apiPost($this->userInfo['token'], "investor/create_investors", $data);
		
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('create_investors_success')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $return->message
			];
			echo json_encode($response);
			return;
		}
	}

	public function createInvestors()
	{
		$this->data["pageName"] = $this->lang->line('create_investors');
		$this->data['template'] = 'page/investors/add_investors';
		//get province
		$data = array(// "type_login" => 1
		);
		 $bankData = $this->api->apiPost($this->userInfo['token'], "bankVimo/get_all", $data);
        if(!empty($bankData->status) && $bankData->status == 200){
            $this->data['bankData'] = $bankData->data;
        }else{
            $this->data['bankData'] = array();
        }
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	
}


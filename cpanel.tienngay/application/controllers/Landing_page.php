<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
class Landing_page extends MY_Controller
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

	public function deleteLanding_page()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_landing_page_selected_deletion')
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
		$return = $this->api->apiPost($this->userInfo['token'], "landing_page/update_landing_page", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_landing_page')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Landing_page_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}
    public function doUpdateStatusLanding_page()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$status = ($status=='true') ? 'active' : 'deactive';
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_landing_page_selected_deletion')
			];
			echo json_encode($response);
			return;
		}
			if (empty($status)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_landing_page_selected_deletion')
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
		$return = $this->api->apiPost($this->userInfo['token'], "landing_page/update_landing_page", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_landing_page')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Landing_page_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}
	public function doUpdateLanding_page()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		$url = !empty($_POST['url']) ? $_POST['url'] : "";
		$province_id = !empty($_POST['province_id']) ? $_POST['province_id'] : "";
		$province_name = !empty($_POST['province_name']) ?  $_POST['province_name'] : "";
		
		$status = !empty($_POST['status']) ? $_POST['status'] : "";
	
		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		
		
	
		$province = array(
            'id' => $province_id,
            "name" => $province_name
        );
		$data = array(
			
			"url" => $url,
			"province_id" => $province_id,
			"province" => $province,
			"status" => $status,
			"updated_at" => $updateAt,
			"updated_by" => $this->userInfo['email'],
			"id"=>$id

		);
		$return = $this->api->apiPost($this->userInfo['token'], "landing_page/update_landing_page", $data);
      // die;
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successful_landing_page_update')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Failed_landing_page_update'),
				'data'=>$image
			];
			echo json_encode($response);
			return;
		}
	}

	public function update()
	{
		$this->data["pageName"] = $this->lang->line('update_landing_page');
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		// get landing_page by id
		$data = array(
			"id" => $id,
			// "type_login" => 1
		);

		$landing_page = $this->api->apiPost($this->userInfo['token'], "landing_page/get_landing_page", $data);
		if (!empty($landing_page->status) && $landing_page->status == 200) {
			$this->data['landing_page'] = $landing_page->data;
		} else {
			$this->data['landing_page'] = array();
		}
		if (empty($landing_page->data)) {
			echo "404";
			die;
			redirect('404');
		}
		$provinceData = $this->api->apiPost($this->userInfo['token'], "province/get_province", $data_pro);
        if(!empty($provinceData->status) && $provinceData->status == 200){
            $this->data['provinceData'] = $provinceData->data;
        }else{
            $this->data['provinceData'] = array();
        }
		$this->data['template'] = 'page/landing_page/update_landing_page';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function listLanding_page()
	{
		$this->data["pageName"] = $this->lang->line('Landing_page_manager');
		$data = array(// "type_login" => 1
		);
		$landing_pageData = $this->api->apiPost($this->userInfo['token'], "landing_page/get_all", $data);
		if (!empty($landing_pageData->status) && $landing_pageData->status == 200) {
			$this->data['landing_pageData'] = $landing_pageData->data;
		} else {
			$this->data['landing_pageData'] = array();
		}
		$this->data['template'] = 'page/landing_page/list_landing_page';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function doAddLanding_page()
	{
		
		
		$url = !empty($_POST['url']) ? $_POST['url'] : "";
		$province_id = !empty($_POST['province_id']) ? $_POST['province_id'] : "";
		$province_name = !empty($_POST['province_name']) ?  $_POST['province_name'] : "";
		$status = !empty($_POST['status']) ? $_POST['status'] : "";
		//var_dump($image); return;
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		
		
		$province = array(
            'id' => $province_id,
            "name" => $province_name
        );
	
		$data = array(
			"url" => $url,
			"province_id" => $province_id,
			"province" => $province,
			"status" => $status,
			"created_at" => $createdAt,
			"updated_at" => $createdAt,
			"created_by" => $this->userInfo['email'],
			"updated_by" => $this->userInfo['email'],

		);
       
		$return = $this->api->apiPost($this->userInfo['token'], "landing_page/create_landing_page", $data);
		
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('create_landing_page_success')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('create_landing_page_failed')
			];
			echo json_encode($response);
			return;
		}
	}

	public function createLanding_page()
	{
		$this->data["pageName"] = $this->lang->line('create_landing_page');
		$this->data['template'] = 'page/landing_page/add_landing_page';
		//get province
		$data = array(// "type_login" => 1
		);
		 $provinceData = $this->api->apiPost($this->userInfo['token'], "province/get_province", $data_pro);
        if(!empty($provinceData->status) && $provinceData->status == 200){
            $this->data['provinceData'] = $provinceData->data;
        }else{
            $this->data['provinceData'] = array();
        }
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
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
}


<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
class Area extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->api = new Api();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model("time_model");
		 $this->load->helper('lead_helper');
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

	public function deleteArea()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_area_selected_deletion')
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
		$return = $this->api->apiPost($this->userInfo['token'], "area/update_area", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_area')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Area_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}
    public function doUpdateStatusArea()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$status = ($status=='true') ? 'active' : 'deactive';
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_area_selected_deletion')
			];
			echo json_encode($response);
			return;
		}
			if (empty($status)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_area_selected_deletion')
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
		$return = $this->api->apiPost($this->userInfo['token'], "area/update_area", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_area')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Area_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}
	public function doUpdateArea()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		$title = !empty($_POST['title']) ? $_POST['title'] : "";
		$content = !empty($_POST['content']) ? $_POST['content'] : "";
		$code = !empty($_POST['code']) ? $_POST['code'] : "";
		$status = !empty($_POST['status']) ? $_POST['status'] : "";
		$code_domain = !empty($_POST['code_domain']) ? $_POST['code_domain'] : "";
		$text_domain = !empty($_POST['text_domain']) ? $_POST['text_domain'] : "";
		$code_region = !empty($_POST['code_region']) ? $_POST['code_region'] : "";
		$text_region = !empty($_POST['text_region']) ? $_POST['text_region'] : "";
	
		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		if (empty($title)) {
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Area_title_empty')
			];
			echo json_encode($response);
			return;
		}
		
		if (empty($content)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Area_content_empty')
			];
			echo json_encode($response);
			return;
		}
		$data = array(
			"title" => $title,
			
			"content" => $content,
			"code" => $code,
			"domain"=>array('code'=>$code_domain,'name'=>$text_domain),
			"region"=>array('code'=>$code_region,'name'=>$text_region),
			"status" => $status,
			"updated_at" => $updateAt,
			"updated_by" => $this->userInfo['email'],
			"id"=>$id

		);
		$return = $this->api->apiPost($this->userInfo['token'], "area/update_area", $data);
      // die;
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successful_area_update')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Failed_area_update'),
				'data'=>$image
			];
			echo json_encode($response);
			return;
		}
	}

	public function update()
	{
		$this->data["pageName"] = $this->lang->line('update_area');
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		// get area by id
		$data = array(
			"id" => $id,
			// "type_login" => 1
		);
		$area = $this->api->apiPost($this->userInfo['token'], "area/get_area", $data);
		if (!empty($area->status) && $area->status == 200) {
			$this->data['area'] = $area->data;
		} else {
			$this->data['area'] = array();
		}
	
		$this->data['template'] = 'page/area/update_area';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function listArea()
	{
		$this->data["pageName"] = $this->lang->line('Area_manager');
		$data = array(// "type_login" => 1
		);
		$areaData = $this->api->apiPost($this->userInfo['token'], "area/get_all", $data);
		if (!empty($areaData->status) && $areaData->status == 200) {
			$this->data['areaData'] = $areaData->data;
		} else {
			$this->data['areaData'] = array();
		}
		$this->data['template'] = 'page/area/list_area';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function doAddArea()
	{
		
		
		$title = !empty($_POST['title']) ? $_POST['title'] : "";
		$content = !empty($_POST['content']) ? $_POST['content'] : "";
		$status = !empty($_POST['status']) ? $_POST['status'] : "";
		$code = !empty($_POST['code']) ? $_POST['code'] : "";
		$code_domain = !empty($_POST['code_domain']) ? $_POST['code_domain'] : "";
		$text_domain = !empty($_POST['text_domain']) ? $_POST['text_domain'] : "";
		$code_region = !empty($_POST['code_region']) ? $_POST['code_region'] : "";
		$text_region = !empty($_POST['text_region']) ? $_POST['text_region'] : "";
		//var_dump($image); return;
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		
		if (empty($title)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Area_title_empty')
			];
			echo json_encode($response);
			return;
		}
		
		if (empty($code)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => 'Mã vùng không được để trống'
			];
			echo json_encode($response);
			return;
		}
		$data = array(
		
			"title" => $title,
		
			"content" => $content,
			"code" => $code,
			"domain"=>array('code'=>$code_domain,'name'=>$text_domain),
			"region"=>array('code'=>$code_region,'name'=>$text_region),
			"status" => $status,
			"created_at" => $createdAt,
			"updated_at" => $createdAt,
			"created_by" => $this->userInfo['email'],
			"updated_by" => $this->userInfo['email'],

		);
       
		$return = $this->api->apiPost($this->userInfo['token'], "area/create_area", $data);
		
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('create_area_success')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('create_area_failed')
			];
			echo json_encode($response);
			return;
		}
	}

	public function createArea()
	{
		$this->data["pageName"] = $this->lang->line('create_area');
		$this->data['template'] = 'page/area/add_area';
		//get province
		$data = array(// "type_login" => 1
		);
		
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


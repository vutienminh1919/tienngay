<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
class Faq extends MY_Controller
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

	public function deleteFaq()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_faq_selected_deletion')
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
		$return = $this->api->apiPost($this->userInfo['token'], "faq/update_faq", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_faq')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Faq_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}
    public function doUpdateStatusFaq()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$status = ($status=='true') ? 'active' : 'deactive';
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_faq_selected_deletion')
			];
			echo json_encode($response);
			return;
		}
			if (empty($status)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_faq_selected_deletion')
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
		$return = $this->api->apiPost($this->userInfo['token'], "faq/update_faq", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_faq')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Faq_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}
	public function doUpdateFaq()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		$title_vi = !empty($_POST['title_vi']) ? $_POST['title_vi'] : "";
		$content_vi = !empty($_POST['content_vi']) ? $_POST['content_vi'] : "";
		$title_en = !empty($_POST['title_en']) ? $_POST['title_en'] : "";
		$content_en = !empty($_POST['content_en']) ? $_POST['content_en'] : "";
		$type = !empty($_POST['type_faq']) ? $_POST['type_faq'] : "";
		$status = !empty($_POST['status']) ? $_POST['status'] : "";
	
		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		if (empty($title_vi)) {
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Faq_title_empty')
			];
			echo json_encode($response);
			return;
		}
		
		if (empty($content_vi)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Faq_content_empty')
			];
			echo json_encode($response);
			return;
		}
		$data = array(
			"title_vi" => $title_vi,
			"link" => slugify($title_vi),
			"content_vi" => $content_vi,
			"title_en" => $title_en,
			"content_en" => $content_en,
			"type_faq" => $type,
			"status" => $status,
			"updated_at" => $updateAt,
			"updated_by" => $this->userInfo['email'],
			"id"=>$id

		);
		$return = $this->api->apiPost($this->userInfo['token'], "faq/update_faq", $data);
      // die;
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successful_faq_update')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Failed_faq_update'),
				'data'=>$image
			];
			echo json_encode($response);
			return;
		}
	}

	public function update()
	{
		$this->data["pageName"] = $this->lang->line('update_faq');
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		// get faq by id
		$data = array(
			"id" => $id,
			// "type_login" => 1
		);
		$faq = $this->api->apiPost($this->userInfo['token'], "faq/get_faq", $data);
		if (!empty($faq->status) && $faq->status == 200) {
			$this->data['faq'] = $faq->data;
		} else {
			$this->data['faq'] = array();
		}
		if (empty($faq->data)) {
			echo "404";
			die;
			redirect('404');
		}
		
		$this->data['template'] = 'page/faq/update_faq';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function listFaq()
	{
		$this->data["pageName"] = $this->lang->line('Faq_manager');
		$data = array(// "type_login" => 1
		);
		$faqData = $this->api->apiPost($this->userInfo['token'], "faq/get_all", $data);
		if (!empty($faqData->status) && $faqData->status == 200) {
			$this->data['faqData'] = $faqData->data;
		} else {
			$this->data['faqData'] = array();
		}
		$this->data['template'] = 'page/faq/list_faq';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function doAddFaq()
	{
		
		$image = !empty($_FILES['image']) ? $_FILES['image'] : "";
		$title_vi = !empty($_POST['title_vi']) ? $_POST['title_vi'] : "";
		$content_vi = !empty($_POST['content_vi']) ? $_POST['content_vi'] : "";
		$title_en = !empty($_POST['title_en']) ? $_POST['title_en'] : "";
		$content_en = !empty($_POST['content_en']) ? $_POST['content_en'] : "";
		$type = !empty($_POST['type_faq']) ? $_POST['type_faq'] : "";
		$status = !empty($_POST['status']) ? $_POST['status'] : "";
		//var_dump($image); return;
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		
		if (empty($title_vi)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Faq_title_empty')
			];
			echo json_encode($response);
			return;
		}
		
		if (empty($content_vi)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Faq_content_empty')
			];
			echo json_encode($response);
			return;
		}
		$data = array(
			"image" => $image,
			"title_vi" => $title_vi,
			"link" => slugify($title_vi),
			"content_vi" => $content_vi,
			"title_en" => $title_en,
			"content_en" => $content_en,
			"type_faq" => $type,
			"status" => $status,
			"created_at" => $createdAt,
			"updated_at" => $createdAt,
			"created_by" => $this->userInfo['email'],
			"updated_by" => $this->userInfo['email'],

		);
       
		$return = $this->api->apiPost($this->userInfo['token'], "faq/create_faq", $data);
		
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('create_faq_success')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('create_faq_failed')
			];
			echo json_encode($response);
			return;
		}
	}

	public function createFaq()
	{
		$this->data["pageName"] = $this->lang->line('create_faq');
		$this->data['template'] = 'page/faq/add_faq';
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


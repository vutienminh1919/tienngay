<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
class Seo extends MY_Controller
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

	public function get_all_seo()
	{
		$this->data["pageName"] = $this->lang->line('seo_list');
		$data = array(// "type_login" => 1
		);
		$seoData = $this->api->apiPost($this->userInfo['token'], "seo/get_all", $data);
		if (!empty($seoData->status) && $seoData->status == 200) {
			echo json_encode($seoData->data);
			return;
		}

	}

	public function seo_list()
	{
		$this->data["pageName"] = $this->lang->line('seo_list');
		$data = array(// "type_login" => 1
		);
		$seoData = $this->api->apiPost($this->userInfo['token'], "seo/get_all", $data);
		if (!empty($seoData->status) && $seoData->status == 200) {
			$this->data['seoData'] = $seoData->data;
		}
		$this->data['template'] = 'page/seo/list_seo';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function create_seo()
	{
		$this->data["pageName"] = $this->lang->line('create_seo');
		$this->data['template'] = 'page/seo/add_seo';
		$data = array(// "type_login" => 1
		);

		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function do_add_seo()
	{
		$data = $this->input->post();
		$data['page_name_seo'] = $this->security->xss_clean($data['page_name_seo']);
		$data['page_title_seo'] = $this->security->xss_clean($data['page_title_seo']);
		$data['description_tag_seo'] = $this->security->xss_clean($data['description_tag_seo']);
		$data['keyword_tag_seo'] = $this->security->xss_clean($data['keyword_tag_seo']);
		$data['url_seo'] = $this->security->xss_clean($data['url_seo']);
		$data['status'] = $this->security->xss_clean($data['status']);
		
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());

		$dataPost = array(
			"page_name_seo" => $data['page_name_seo'],
			"link" => slugify($data['page_name_seo']),
			"page_title_seo" => $data['page_title_seo'],
			"description_tag_seo" => $data['description_tag_seo'],
			"keyword_tag_seo" => $data['keyword_tag_seo'],
			"url_seo" => $data['url_seo'],
			"status" => $data['status'],
			"created_at" => $createdAt,
			"updated_at" => $createdAt,
			"created_by" => $this->userInfo['email'],
			"updated_by" => $this->userInfo['email'],
		);

		$return = $this->api->apiPost($this->userInfo['token'], "seo/create_seo", $dataPost);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => 'Tạo dữ liệu SEO thành công!!'
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => 'Tạo dữ liệu SEO thất bại!'
			];
			echo json_encode($response);
			return;
		}
	}

	public function do_update_status_seo()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$status = ($status=='true') ? 'active' : 'deactive';
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => 'Không có dữ liệu được chọn!'
			];
			echo json_encode($response);
			return;
		}
		if (empty($status)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => 'Không có dữ liệu được chọn!'
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
		$return = $this->api->apiPost($this->userInfo['token'], "seo/update_seo", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_seo')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('seo_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}

	public function update()
	{
		$this->data["pageName"] = $this->lang->line('update_seo');
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		// get faq by id
		$data = array(
			"id" => $id,
			// "type_login" => 1
		);
		$seoData = $this->api->apiPost($this->userInfo['token'], "seo/get_seo", $data);
		if (!empty($seoData->status) && $seoData->status == 200) {
			$this->data['seo'] = $seoData->data;
		} else {
			$this->data['seo'] = array();
		}
		if (empty($seoData->data)) {
			echo "404";
			die;
			redirect('404');
		}

		$this->data['template'] = 'page/seo/update_seo';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function do_update_seo()
	{
		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['page_name_seo'] = $this->security->xss_clean($data['page_name_seo']);
		$data['page_title_seo'] = $this->security->xss_clean($data['page_title_seo']);
		$data['description_tag_seo'] = $this->security->xss_clean($data['description_tag_seo']);
		$data['keyword_tag_seo'] = $this->security->xss_clean($data['keyword_tag_seo']);
		$data['url_seo'] = $this->security->xss_clean($data['url_seo']);
		$data['status'] = $this->security->xss_clean($data['status']);
		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());

		$dataPost = array(
			"id"=> $data['id'],
			"page_name_seo" => $data['page_name_seo'],
			"link" => slugify($data['page_name_seo']),
			"page_title_seo" => $data['page_title_seo'],
			"description_tag_seo" => $data['description_tag_seo'],
			"keyword_tag_seo" => $data['keyword_tag_seo'],
			"url_seo" => $data['url_seo'],
			"status" => $data['status'],
			"updated_at" => $updateAt,
			"updated_by" => $this->userInfo['email'],
		);
		$seoDataUpdate = $this->api->apiPost($this->userInfo['token'], "seo/update_seo", $dataPost);
		// die;
		if (!empty($seoDataUpdate->status) && $seoDataUpdate->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => "Cập nhập trang SEO thành công!"
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Cập nhập trang SEO thất bại!",
			];
			echo json_encode($response);
			return;
		}
	}



}


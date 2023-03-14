<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
class FinancialHandbook extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->api = new Api();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model("time_model");
		$this->load->library('pagination');
		$this->load->helper('lead_helper');
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

	public function deleteHandbook()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_news_selected_deletion')
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
		$return = $this->api->apiPost($this->userInfo['token'], "news/update_news", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_news')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('News_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}
	public function doUpdateStatusHandbook()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$status = ($status=='true') ? 'active' : 'deactive';
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_news_selected_deletion')
			];
			echo json_encode($response);
			return;
		}
		if (empty($status)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_news_selected_deletion')
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
		$return = $this->api->apiPost($this->userInfo['token'], "handbook/update_handbook", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => "Disable bài viết thành công!"
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Disable bài viết lỗi!"
			];
			echo json_encode($response);
			return;
		}
	}
	public function doUpdateHandbook()
	{
		$data = $this->input->post();
		$image = !empty($_FILES['image']) ? $_FILES['image'] : "";
		$data['id'] = $this->security->xss_clean($data['id']);
		$data['title_vi'] = $this->security->xss_clean($data['title_vi']);
		$data['benefit_vi'] = $this->security->xss_clean($data['benefit_vi']);
		$data['fee_insurance_vi'] = $this->security->xss_clean($data['fee_insurance_vi']);
		$data['type_finance_vi'] = $this->security->xss_clean($data['type_finance_vi']);
		$data['summary_vi'] = $this->security->xss_clean($data['summary_vi']);
		$data['content_vi'] = $this->security->xss_clean($data['content_vi']);
		$data['title_en'] = $this->security->xss_clean($data['title_en']);
		$data['benefit_en'] = $this->security->xss_clean($data['benefit_en']);
		$data['fee_insurance_en'] = $this->security->xss_clean($data['fee_insurance_en']);
		$data['type_finance_en'] = $this->security->xss_clean($data['type_finance_en']);
		$data['summary_en'] = $this->security->xss_clean($data['summary_en']);
		$data['content_en'] = $this->security->xss_clean($data['content_en']);
		$data['level'] = $this->security->xss_clean($data['level']);
		$data['status'] = $this->security->xss_clean($data['status']);
		$data['period'] = $this->security->xss_clean($data['period']);
		$data['province'] = $this->security->xss_clean($data['province']);
		$data['limit'] = $this->security->xss_clean($data['limit']);
		$data['type_new'] = $this->security->xss_clean($data['type_new']);
		$data['province_text'] = $this->security->xss_clean($data['province_text']);
		$data['page_title_seo'] = $this->security->xss_clean($data['page_title_seo']);
		$data['description_tag_seo'] = $this->security->xss_clean($data['description_tag_seo']);
		$data['keyword_tag_seo'] = $this->security->xss_clean($data['keyword_tag_seo']);
		$data['url_seo'] = $this->security->xss_clean($data['url_seo']);

		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		if (!empty($image)) {
			//var_dump($image); 
			if(!in_array(pathinfo($_FILES['image']['name'])['extension'],["jpg", "jpeg", "jpe", "png", "gif"] ) )
			{
				$response = [
					'res' => false,
					'status' => "400",
					'message' => 'Chỉ chấp nhận ảnh "jpg", "jpeg", "jpe", "png", "gif" <1Mb'
				];
				echo json_encode($response);
				return;
			}
		}
		if (empty($data["title_vi"])) {

			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('News_title_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($data["summary_vi"])) {

			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('News_summary_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($data["content_vi"])) {

			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('News_content_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($data["page_title_seo"])) {

			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Tiêu đề trang SEO không được để trống!"
			];
			echo json_encode($response);
			return;
		}
		if (empty($data["description_tag_seo"])) {

			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Thẻ mô tả SEO không được để trống!"
			];
			echo json_encode($response);
			return;
		}
		if (empty($data["keyword_tag_seo"])) {

			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Thẻ từ khóa SEO không được để trống!"
			];
			echo json_encode($response);
			return;
		}
		$dataPost = array(
			"image" => $image,
			"title_vi" => $data["title_vi"],
			"link" => slugify($data["title_vi"]),
			"benefit_vi" => $data['benefit_vi'],
			"fee_insurance_vi" => $data['fee_insurance_vi'],
			"type_finance_vi" => $data['type_finance_vi'],
			"summary_vi" => $data["summary_vi"],
			"content_vi" => $data["content_vi"],
			"title_en" => $data["title_en"],
			"benefit_en" => $data['benefit_en'],
			"fee_insurance_en" => $data['fee_insurance_en'],
			"type_finance_en" => $data['type_finance_en'],
			"summary_en" => $data["summary_en"],
			"content_en" => $data["content_en"],
			"level" => $data["level"],
			"status" => $data["status"],
			"period" => $data["period"],
			"province" => $data["province"],
			"province_text"=>$data["province_text"],
			"page_title_seo" => $data["page_title_seo"],
			"description_tag_seo" => $data["description_tag_seo"],
			"keyword_tag_seo" => $data["keyword_tag_seo"],
			"url_seo" => $data["url_seo"],
			"sub_link" => slugify($data["url_seo"]),
			"limit" => $data["limit"],
			"type_new" => $data["type_new"],
			"updated_at" => $updateAt,
			"updated_by" => $this->userInfo['email'],
			"id"=>$data["id"]
		);

		$return = $this->api->apiPost($this->userInfo['token'], "handbook/update_handbook", $dataPost);
		// die;
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => "Cập nhật bài viết thành công!"
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Cập nhật bài viết thất bại!",
				'data'=>$image
			];
			echo json_encode($response);
			return;
		}
	}

	public function update()
	{
		$this->data["pageName"] = "Cập nhật bài viết";
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		// get news by id
		$data = array(
			"id" => $id,
			// "type_login" => 1
		);
		// var_dump($this->userInfo['token']); die;
		$handbook = $this->api->apiPost($this->userInfo['token'], "handbook/get_handbook", $data);
		if (!empty($handbook->status) && $handbook->status == 200) {
			$this->data['handbook'] = $handbook->data;
		} else {
			$this->data['handbook'] = array();
		}
		$provinceData = $this->api->apiPost($this->userInfo['token'], "province/get_province", $data);
		if(!empty($provinceData->status) && $provinceData->status == 200){
			$this->data['provinceData'] = $provinceData->data;
		}else{
			$this->data['provinceData'] = array();
		}
		if (empty($handbook->data)) {
			echo "404";
			die;
			redirect('404');
		}

		$this->data['template'] = 'page/financial_handbook/update_handbook.php';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function listHandbook()
	{
		$this->data["pageName"] = $this->lang->line('News_manager');
		$data = array(// "type_login" => 1
		);
		$handbookData = $this->api->apiPost($this->userInfo['token'], "handbook/get_all", $data);
		if (!empty($handbookData->status) && $handbookData->status == 200) {
			$this->data['handbookData'] = $handbookData->data;
		} else {
			$this->data['handbookData'] = array();
		}
		$this->data['template'] = 'page/financial_handbook/list_handbook';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function doAddHandbook()
	{
		$data = $this->input->post();
		$image = !empty($_FILES['image']) ? $_FILES['image'] : "";
		$data['title_vi'] = $this->security->xss_clean($data['title_vi']);
		$data['benefit_vi'] = $this->security->xss_clean($data['benefit_vi']);
		$data['fee_insurance_vi'] = $this->security->xss_clean($data['fee_insurance_vi']);
		$data['type_finance_vi'] = $this->security->xss_clean($data['type_finance_vi']);
		$data['summary_vi'] = $this->security->xss_clean($data['summary_vi']);
		$data['content_vi'] = $this->security->xss_clean($data['content_vi']);
		$data['title_en'] = $this->security->xss_clean($data['title_en']);
		$data['benefit_en'] = $this->security->xss_clean($data['benefit_en']);
		$data['fee_insurance_en'] = $this->security->xss_clean($data['fee_insurance_en']);
		$data['type_finance_en'] = $this->security->xss_clean($data['type_finance_en']);
		$data['summary_en'] = $this->security->xss_clean($data['summary_en']);
		$data['content_en'] = $this->security->xss_clean($data['content_en']);
		$data['level'] = $this->security->xss_clean($data['level']);
		$data['status'] = $this->security->xss_clean($data['status']);
		$data['period'] = $this->security->xss_clean($data['period']);
		$data['province'] = $this->security->xss_clean($data['province']);
		$data['limit'] = $this->security->xss_clean($data['limit']);
		$data['type_new'] = $this->security->xss_clean($data['type_new']);
		$data['province_text'] = $this->security->xss_clean($data['province_text']);
		$data['page_title_seo'] = $this->security->xss_clean($data['page_title_seo']);
		$data['description_tag_seo'] = $this->security->xss_clean($data['description_tag_seo']);
		$data['keyword_tag_seo'] = $this->security->xss_clean($data['keyword_tag_seo']);
		$data['url_seo'] = $this->security->xss_clean($data['url_seo']);

		//var_dump($image); return;
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		if (empty($image)) {

			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('News_image_empty')
			];
			echo json_encode($response);
			return;
		}
		if (!empty($image)) {
			//var_dump($_FILES['image']['size']); 
			if(!in_array(pathinfo($_FILES['image']['name'])['extension'],["jpg", "jpeg", "jpe", "png", "gif"] )  )
			{
				$response = [
					'res' => false,
					'status' => "400",
					'message' => $this->lang->line('News_image_empty')
				];
				echo json_encode($response);
				return;
			}
		}
		if (empty($data['title_vi'])) {

			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('News_title_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($data["summary_vi"])) {

			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('News_summary_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($data["content_vi"])) {

			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('News_content_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($data["page_title_seo"])) {

			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Tiêu đề trang SEO không được để trống!"
			];
			echo json_encode($response);
			return;
		}
		if (empty($data["description_tag_seo"])) {

			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Thẻ mô tả SEO không được để trống!"
			];
			echo json_encode($response);
			return;
		}
		if (empty($data["keyword_tag_seo"])) {

			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Thẻ từ khóa SEO không được để trống!"
			];
			echo json_encode($response);
			return;
		}

		$dataPost = array(
			"image" => $image,
			"title_vi" => $data['title_vi'],
			"link" => slugify($data['title_vi']),
			"benefit_vi" => $data['benefit_vi'],
			"fee_insurance_vi" => $data['fee_insurance_vi'],
			"type_finance_vi" => $data['type_finance_vi'],
			"summary_vi" => $data['summary_vi'],
			"content_vi" => $data['content_vi'],
			"title_en" => $data['title_en'],
			"benefit_en" => $data['benefit_en'],
			"fee_insurance_en" => $data['fee_insurance_en'],
			"type_finance_en" => $data['type_finance_en'],
			"summary_en" => $data['summary_en'],
			"content_en" => $data['content_en'],
			"level" => $data['level'],
			"status" => $data['status'],
			"period" => $data['period'],
			"province" => $data['province'],
			"province_text"=>$data['province_text'],
			"page_title_seo" => $data['page_title_seo'],
			"description_tag_seo" => $data['description_tag_seo'],
			"keyword_tag_seo" => $data['keyword_tag_seo'],
			"url_seo" => $data['url_seo'],
			"sub_link" => slugify($data['url_seo']),
			"limit" => $data['limit'],
			"type_new" => $data['type_new'],
			"created_at" => $createdAt,
			"updated_at" => $createdAt,
			"created_by" => $this->userInfo['email'],
			"updated_by" => $this->userInfo['email']
		);
		$return = $this->api->apiPost($this->userInfo['token'], "handbook/create_handbook", $dataPost);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => "Tạo mới bài viết thành công!"
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Tạo bài viết thất bại!"
			];
			echo json_encode($response);
			return;
		}
	}

	public function createHandbook()
	{
		$this->data["pageName"] = "Thêm mới bài viết";
		//get province
		$data = array(// "type_login" => 1
		);

		$provinceData = $this->api->apiPost($this->userInfo['token'], "province/get_province", $data);
		if(!empty($provinceData->status) && $provinceData->status == 200){
			$this->data['provinceData'] = $provinceData->data;
		}else{
			$this->data['provinceData'] = array();
		}
		$this->data['template'] = 'page/financial_handbook/add_handbook';
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


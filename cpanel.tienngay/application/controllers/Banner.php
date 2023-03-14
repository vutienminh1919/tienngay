<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
class Banner extends MY_Controller
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

	public function deleteBanner()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_banner_selected_deletion')
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
		$return = $this->api->apiPost($this->userInfo['token'], "banner/update_banner", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_banner')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Banner_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}
    public function doUpdateStatusBanner()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$status = ($status=='true') ? 'active' : 'deactive';
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_banner_selected_deletion')
			];
			echo json_encode($response);
			return;
		}
			if (empty($status)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_banner_selected_deletion')
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
		$return = $this->api->apiPost($this->userInfo['token'], "banner/update_banner", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_banner')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Banner_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}
	public function doUpdateBanner()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		$image = !empty($_FILES['image']) ? $_FILES['image'] : "";
		$image_mb = !empty($_FILES['image_mb']) ? $_FILES['image_mb'] : "";
		$title_vi = !empty($_POST['title_vi']) ? $_POST['title_vi'] : "";
		$summary_vi = !empty($_POST['summary_vi']) ? $_POST['summary_vi'] : "";
		$title_en = !empty($_POST['title_en']) ? $_POST['title_en'] : "";
		$summary_en = !empty($_POST['summary_en']) ? $_POST['summary_en'] : "";
		$link = !empty($_POST['link']) ? $_POST['link'] : "";
		$page = !empty($_POST['page']) ? $_POST['page'] : "";
		$category_name_banner = !empty($_POST['category_name_banner']) ? $_POST['category_name_banner'] : "";
		$level = !empty($_POST['level']) ? $_POST['level'] : "";
		$status = !empty($_POST['status']) ? $_POST['status'] : "";
	
		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		if (!empty($image)) {
			if($_FILES['image']['name']!="")
			{
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
		}
		if (!empty($image_mb)) {
			if($_FILES['image_mb']['name']!="")
			{
			if(!in_array(pathinfo($_FILES['image_mb']['name'])['extension'],["jpg", "jpeg", "jpe", "png", "gif"] ) )
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
		}
		if (empty($title_vi)) {
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Banner_title_empty')
			];
			echo json_encode($response);
			return;
		}
		
		
		$data = array(
			"image" => $image,
			"image_mb" => $image_mb,
			"title_vi" => $title_vi,
			"link" => $link,
			"summary_vi" => $summary_vi,
			"title_en" => $title_en,
			"summary_en" => $summary_en,
			"page" => $page,
			"category_name_banner" => $category_name_banner,
			"level" => $level,
			"status" => $status,
			"updated_at" => $updateAt,
			"updated_by" => $this->userInfo['email'],
			"id"=>$id

		);
		$return = $this->api->apiPost($this->userInfo['token'], "banner/update_banner", $data);
      // die;
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successful_banner_update')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Failed_banner_update'),
				'data'=>$image
			];
			echo json_encode($response);
			return;
		}
	}

	public function update()
	{
		$this->data["pageName"] = $this->lang->line('update_banner');
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		// get banner by id
		$data = array(
			"id" => $id,
			// "type_login" => 1
		);
		$categories = $this->api->apiPost($this->userInfo['token'], "PostCategories/get_banner_categories", array());
		if (isset($categories->status) && $categories->status == 200) {
			$this->data['categories'] = $categories->data;
		} else {
			$this->data['categories'] = array();
		}
		$banner = $this->api->apiPost($this->userInfo['token'], "banner/get_banner", $data);
		if (!empty($banner->status) && $banner->status == 200) {
			$this->data['banner'] = $banner->data;
		} else {
			$this->data['banner'] = array();
		}
		if (empty($banner->data)) {
			echo "404";
			die;
			redirect('404');
		}
		
		$this->data['template'] = 'page/banner/update_banner';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function listBanner()
	{
		$this->data["pageName"] = $this->lang->line('Banner_manager');
		$data = array(// "type_login" => 1
		);
		$bannerData = $this->api->apiPost($this->userInfo['token'], "banner/get_all", $data);
		if (!empty($bannerData->status) && $bannerData->status == 200) {
			$this->data['bannerData'] = $bannerData->data;
		} else {
			$this->data['bannerData'] = array();
		}
		$this->data['template'] = 'page/banner/list_banner';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function doAddBanner()
	{
		
		$image = !empty($_FILES['image']) ? $_FILES['image'] : "";
		$image_mb = !empty($_FILES['image_mb']) ? $_FILES['image_mb'] : "";
		$title_vi = !empty($_POST['title_vi']) ? $_POST['title_vi'] : "";
		$summary_vi = !empty($_POST['summary_vi']) ? $_POST['summary_vi'] : "";
		$title_en = !empty($_POST['title_en']) ? $_POST['title_en'] : "";
		$summary_en = !empty($_POST['summary_en']) ? $_POST['summary_en'] : "";
		$link = !empty($_POST['link']) ? $_POST['link'] : "";
		$page = !empty($_POST['page']) ? $_POST['page'] : "";
		$category_name_banner = !empty($_POST['category_name_banner']) ? $_POST['category_name_banner'] : "";
		$level = !empty($_POST['level']) ? $_POST['level'] : "";
		$status = !empty($_POST['status']) ? $_POST['status'] : "";
		//var_dump($image); return;
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		if (empty($image)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Banner_image_empty')
			];
			echo json_encode($response);
			return;
		}
		if (!empty($image)) {
			if(!in_array(pathinfo($_FILES['image']['name'])['extension'],["jpg", "jpeg", "jpe", "png", "gif"] )  )
            {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => 'Chỉ chấp nhận ảnh "jpg", "jpeg", "jpe", "png", "gif" < 1Mb'
			];
			echo json_encode($response);
			return;
		    }
		}
		if (!empty($image_mb)) {
			if(!in_array(pathinfo($_FILES['image_mb']['name'])['extension'],["jpg", "jpeg", "jpe", "png", "gif"] )  )
            {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => 'Chỉ chấp nhận ảnh "jpg", "jpeg", "jpe", "png", "gif" < 1Mb'
			];
			echo json_encode($response);
			return;
		    }
		}
		if (empty($title_vi)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Banner_title_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($page)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Banner_page_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($level)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Banner_level_empty')
			];
			echo json_encode($response);
			return;
		}
		
		$data = array(
			"image" => $image,
			"image_mb" => $image_mb,
			"title_vi" => $title_vi,
			"link" => $link,
			"summary_vi" => $summary_vi,
			"title_en" => $title_en,
			"summary_en" => $summary_en,
			"page" => $page,
			"category_name_banner" => $category_name_banner,
			"level" => $level,
			"status" => $status,
			"created_at" => $createdAt,
			"updated_at" => $createdAt,
			"created_by" => $this->userInfo['email'],
			"updated_by" => $this->userInfo['email'],

		);
       
		$return = $this->api->apiPost($this->userInfo['token'], "banner/create_banner", $data);
		
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('create_banner_success')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('create_banner_failed')
			];
			echo json_encode($response);
			return;
		}
	}

	public function createBanner()
	{
		$this->data["pageName"] = $this->lang->line('create_banner');
		$this->data['template'] = 'page/banner/add_banner';
		$categories = $this->api->apiPost($this->userInfo['token'], "PostCategories/get_banner_categories", array());
		if (isset($categories->status) && $categories->status == 200) {
			$this->data['categories'] = $categories->data;
		} else {
			$this->data['categories'] = array();
		}

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


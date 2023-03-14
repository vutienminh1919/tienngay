<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');

class PostCategories extends MY_Controller
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

	public function deleteCategory()
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
	public function doUpdateStatusCategory()
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

		$return = $this->api->apiPost($this->userInfo['token'], "PostCategories/update_category", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => "Disable danh mục thành công!"
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Disable danh mục lỗi!"
			];
			echo json_encode($response);
			return;
		}
	}

	public function doUpdateCategory()
	{
		$data = $this->input->post();
		$data['category_name_banner'] = $this->security->xss_clean($data['category_name_banner']);
		$data['category_name_post'] = $this->security->xss_clean($data['category_name_post']);
		$data['type_category'] = $this->security->xss_clean($data['type_category']);
		$data['status'] = $this->security->xss_clean($data['status']);
		$data['id'] = $this->security->xss_clean($data['id']);

		if ($data['type_category'] == 1) {
			if (empty($data['category_name_banner'])) {
				$response = [
					'res' => false,
					'status' => "400",
					'message' => "Bạn chưa nhập tên danh mục banner!"
				];
				echo json_encode($response);
				return;
			}
		}
		if ($data['type_category'] == 2) {
			if (empty($data['category_name_post'])) {
				$response = [
					'res' => false,
					'status' => "400",
					'message' => "Bạn chưa nhập tên danh mục bài viết!"
				];
				echo json_encode($response);
				return;
			}
		}
		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		if ($data["type_category"] == 1) {
			$dataPost = array(
				"id" => $data["id"],
				"category_name_banner" => $data["category_name_banner"],
				"type_category" => $data["type_category"],
				"status" => $data["status"],
				"updated_at" => $updateAt,
				"updated_by" => $this->userInfo['email'],
			);
		} else {
			$dataPost = array(
				"id" => $data["id"],
				"category_name_post" => $data["category_name_post"],
				"type_category" => $data["type_category"],
				"status" => $data["status"],
				"updated_at" => $updateAt,
				"updated_by" => $this->userInfo['email'],
			);
		}

		$return = $this->api->apiPost($this->userInfo['token'], "PostCategories/update_category", $dataPost);
		// die;
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => "Cập nhật danh mục thành công!"
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Cập nhật danh mục thất bại!"
			];
			echo json_encode($response);
			return;
		}
	}

	public function update()
	{
		$this->data["pageName"] = "Cập nhật danh mục";
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		// get category by id
		$data = array(
			"id" => $id,
			// "type_login" => 1
		);
		$category = $this->api->apiPost($this->userInfo['token'], "PostCategories/get_category", $data);
		if (!empty($category->status) && $category->status == 200) {
			$this->data['category'] = $category->data;
		} else {
			$this->data['category'] = array();
		}

		if (empty($category->data)) {
			echo "404";
			die;
			redirect('404');
		}

		$this->data['template'] = 'page/categories_post/update_category';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function listCategory()
	{
		$this->data["pageName"] = "Danh sách danh mục";
		$data = array(// "type_login" => 1
		);
		$categoriesData = $this->api->apiPost($this->userInfo['token'], "PostCategories/get_all", $data);
		if (!empty($categoriesData->status) && $categoriesData->status == 200) {
			$this->data['categoriesData'] = $categoriesData->data;
		} else {
			$this->data['categoriesData'] = array();
		}

		$this->data['template'] = 'page/categories_post/list_category';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function doAddCategory()
	{
		$data = $this->input->post();

		$data['category_name_banner'] = $this->security->xss_clean($data['category_name_banner']);
		$data['category_name_post'] = $this->security->xss_clean($data['category_name_post']);
		$data['type_category'] = $this->security->xss_clean($data['type_category']);
		$data['status'] = $this->security->xss_clean($data['status']);

		if ($data['type_category'] == 1) {
			if (empty($data['category_name_banner'])) {
				$response = [
					'res' => false,
					'status' => "400",
					'message' => "Bạn chưa nhập tên danh mục banner!"
				];
				echo json_encode($response);
				return;
			}
		}
		if ($data['type_category'] == 2) {
			if (empty($data['category_name_post'])) {
				$response = [
					'res' => false,
					'status' => "400",
					'message' => "Bạn chưa nhập tên danh mục bài viết!"
				];
				echo json_encode($response);
				return;
			}
		}

		$dataPost = array(
			"category_name_banner" => $data['category_name_banner'],
			"category_name_post" => $data['category_name_post'],
			"type_category" => $data['type_category'],
			"status" => $data['status']
		);

		$return = $this->api->apiPost($this->userInfo['token'], "PostCategories/create_category", $dataPost);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => "Tạo mới danh mục thành công!"
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Tạo danh mục thất bại!"
			];
			echo json_encode($response);
			return;
		}
	}

	public function createCategory()
	{
		$this->data["pageName"] = "Thêm mới danh mục";
		$this->data['template'] = 'page/categories_post/add_category';
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



<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
class Newspapers extends MY_Controller
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

	public function deleteNews()
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
		$return = $this->api->apiPost($this->userInfo['token'], "newspapers/update_news", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_news_papers')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('News_papers_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}
    public function doUpdateStatusNews()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$status = ($status=='true') ? 'active' : 'deactive';
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_news_papers_selected_deletion')
			];
			echo json_encode($response);
			return;
		}
			if (empty($status)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_news_papers_selected_deletion')
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
		$return = $this->api->apiPost($this->userInfo['token'], "newspapers/update_news", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_news_papers')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('News_papers_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}
	public function doUpdateNews()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		$image = !empty($_FILES['image']) ? $_FILES['image'] : "";
		$title_vi = !empty($_POST['title_vi']) ? $_POST['title_vi'] : "";
		$title_en = !empty($_POST['title_en']) ? $_POST['title_en'] : "";
		$link = !empty($_POST['link']) ? $_POST['link'] : "";
		$source = !empty($_POST['source']) ? $_POST['source'] : "";
		$status = !empty($_POST['status']) ? $_POST['status'] : "";
	
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
		if (empty($title_vi)) {
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('News_title_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($link)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('News_papers_link_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($source)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('News_papers_source_empty')
			];
			echo json_encode($response);
			return;
		}
		$data = array(
			"image" => $image,
			"title_vi" => $title_vi,
			"title_en" => $title_en,
			"link" => $link,
			"source" => $source,
			"status" => $status,
			"updated_at" => $updateAt,
			"updated_by" => $this->userInfo['email'],
			"id"=>$id

		);
		$return = $this->api->apiPost($this->userInfo['token'], "newspapers/update_news", $data);
      // die;
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successful_news_papers_update')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Failed_news_papers_update'),
				'data'=>$image
			];
			echo json_encode($response);
			return;
		}
	}

	public function update()
	{
		$this->data["pageName"] = $this->lang->line('update_news');
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		// get news by id
		$data = array(
			"id" => $id,
			// "type_login" => 1
		);
		$news = $this->api->apiPost($this->userInfo['token'], "newspapers/get_news", $data);
		if (!empty($news->status) && $news->status == 200) {
			$this->data['news'] = $news->data;
		} else {
			$this->data['news'] = array();
		}
		if (empty($news->data)) {
			echo "404";
			die;
			redirect('404');
		}
		
		$this->data['template'] = 'page/newspapers/update_news';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function listNews()
	{
		$this->data["pageName"] = $this->lang->line('News_manager');
		$data = array(// "type_login" => 1
		);
		$newsData = $this->api->apiPost($this->userInfo['token'], "newspapers/get_all", $data);
		if (!empty($newsData->status) && $newsData->status == 200) {
			$this->data['newsData'] = $newsData->data;
		} else {
			$this->data['newsData'] = array();
		}
		$this->data['template'] = 'page/newspapers/list_news';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function doAddNews()
	{
		
		$image = !empty($_FILES['image']) ? $_FILES['image'] : "";
		$title_vi = !empty($_POST['title_vi']) ? $_POST['title_vi'] : "";
		$title_en = !empty($_POST['title_en']) ? $_POST['title_en'] : "";
		$link = !empty($_POST['link']) ? $_POST['link'] : "";
		$source = !empty($_POST['source']) ? $_POST['source'] : "";
		$status = !empty($_POST['status']) ? $_POST['status'] : "";
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
		if (empty($title_vi)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('News_title_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($link)) {
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('News_papers_link_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($source)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('News_papers_source_empty')
			];
			echo json_encode($response);
			return;
		}
		$data = array(
			"image" => $image,
			"title_vi" => $title_vi,
			"title_en" => $title_en,
			"link" => $link,
			"source" => $source,
			"status" => $status,
			"created_at" => $createdAt,
			"updated_at" => $createdAt,
			"created_by" => $this->userInfo['email'],
			"updated_by" => $this->userInfo['email'],

		);
       
		$return = $this->api->apiPost($this->userInfo['token'], "newspapers/create_news", $data);
		
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('create_news_papers_success')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('create_news_papers_failed')
			];
			echo json_encode($response);
			return;
		}
	}

	public function createNews()
	{
		$this->data["pageName"] = $this->lang->line('create_news');
		$this->data['template'] = 'page/newspapers/add_news';
		//get province
		$data = array(// "type_login" => 1
		);
		
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	
}


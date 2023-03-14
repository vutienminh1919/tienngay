<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
class Recording extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->api = new Api();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model("time_model");
		$this->load->library('pagination');
		
			date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	public function deleteRecording()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_recording_selected_deletion')
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
		$return = $this->api->apiPost($this->userInfo['token'], "recording/update_recording", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_recording')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Recording_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}
    public function doUpdateStatusRecording()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$status = ($status=='true') ? 'active' : 'deactive';
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_recording_selected_deletion')
			];
			echo json_encode($response);
			return;
		}
			if (empty($status)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_recording_selected_deletion')
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
		$return = $this->api->apiPost($this->userInfo['token'], "recording/update_recording", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_recording')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Recording_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}
	public function doUpdateRecording()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		$title_vi = !empty($_POST['title_vi']) ? $_POST['title_vi'] : "";
		$content_vi = !empty($_POST['content_vi']) ? $_POST['content_vi'] : "";
		$title_en = !empty($_POST['title_en']) ? $_POST['title_en'] : "";
		$content_en = !empty($_POST['content_en']) ? $_POST['content_en'] : "";
		$type = !empty($_POST['type_recording']) ? $_POST['type_recording'] : "";
		$status = !empty($_POST['status']) ? $_POST['status'] : "";
	
		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		if (empty($title_vi)) {
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Recording_title_empty')
			];
			echo json_encode($response);
			return;
		}
		
		if (empty($content_vi)) {
			
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Recording_content_empty')
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
			"type_recording" => $type,
			"status" => $status,
			"updated_at" => $updateAt,
			"updated_by" => $this->userInfo['email'],
			"id"=>$id

		);
		$return = $this->api->apiPost($this->userInfo['token'], "recording/update_recording", $data);
      // die;
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successful_recording_update')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Failed_recording_update'),
				'data'=>$image
			];
			echo json_encode($response);
			return;
		}
	}

	public function update()
	{
		$this->data["pageName"] = $this->lang->line('update_recording');
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		// get recording by id
		$data = array(
			"id" => $id,
			// "type_login" => 1
		);
		$recording = $this->api->apiPost($this->userInfo['token'], "recording/get_recording", $data);
		if (!empty($recording->status) && $recording->status == 200) {
			$this->data['recording'] = $recording->data;
		} else {
			$this->data['recording'] = array();
		}
		if (empty($recording->data)) {
			echo "404";
			die;
			redirect('404');
		}
		
		$this->data['template'] = 'page/recording/update_recording';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function listRecording()
	{
		$this->data["pageName"] = $this->lang->line('Recording_manager');
		$data = array(// "type_login" => 1
		);
		$recordingData = $this->api->apiPost($this->userInfo['token'], "recording/get_all", $data);
		if (!empty($recordingData->status) && $recordingData->status == 200) {
			$this->data['recordingData'] = $recordingData->data;
		} else {
			$this->data['recordingData'] = array();
		}
		$this->data['template'] = 'page/recording/list_recording';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}



	public function createRecording()
	{
		$this->data["pageName"] = $this->lang->line('create_recording');
		$this->data['template'] = 'page/recording/add_recording';
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


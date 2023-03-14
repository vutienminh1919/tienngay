<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
class Config_gic extends MY_Controller
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

	public function deleteConfig_gic()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_config_gic_selected_deletion')
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
		$return = $this->api->apiPost($this->userInfo['token'], "config_gic/update_config_gic", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_config_gic')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Config_gic_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}
    public function doUpdateStatusConfig_gic()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$status = ($status=='true') ? 'active' : 'deactive';
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_config_gic_selected_deletion')
			];
			echo json_encode($response);
			return;
		}
			if (empty($status)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_config_gic_selected_deletion')
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
		$return = $this->api->apiPost($this->userInfo['token'], "config_gic/update_config_gic", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_config_gic')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Config_gic_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}
	public function doUpdateConfig_gic()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		$NhanVienId = !empty($_POST['NhanVienId']) ? $_POST['NhanVienId'] : "";
		$name = !empty($_POST['name']) ? $_POST['name'] : "";
		$code = !empty($_POST['code']) ? $_POST['code'] : "";
		$TyLePhi = !empty($_POST['TyLePhi']) ? $_POST['TyLePhi'] : "0";
		$id_config_gic = !empty($_POST['id_config_gic']) ? $_POST['id_config_gic'] : "";
		$ThongTinNguoiChoVay_HoTen = !empty($_POST['ThongTinNguoiChoVay_HoTen']) ? $_POST['ThongTinNguoiChoVay_HoTen'] : "";
		$ThongTinNguoiChoVay_CMND = !empty($_POST['ThongTinNguoiChoVay_CMND']) ? $_POST['ThongTinNguoiChoVay_CMND'] : "";
		$ThongTinNguoiChoVay_DienThoai = !empty($_POST['ThongTinNguoiChoVay_DienThoai']) ? $_POST['ThongTinNguoiChoVay_DienThoai'] : "";
		$ThongTinNguoiChoVay_Email = !empty($_POST['ThongTinNguoiChoVay_Email']) ? $_POST['ThongTinNguoiChoVay_Email'] : "";
		$ThongTinNguoiChoVay_DiaChi = !empty($_POST['ThongTinNguoiChoVay_DiaChi']) ? $_POST['ThongTinNguoiChoVay_DiaChi'] : "";
		$LoaiNguoiThuHuongId = !empty($_POST['LoaiNguoiThuHuongId']) ? $_POST['LoaiNguoiThuHuongId'] : "";
		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());


  //       $cityData = $this->api->apiPost($this->userInfo['token'], "config_gic/get_city",array());
		// if (!empty($cityData->status) && $cityData->status == 200) {
		// 	$city = $cityData->data->data;
		// } else {
		// 	$city = array();
		// }
  //       $districtData = $this->api->apiPost($this->userInfo['token'], "config_gic/get_district",array());
  //        //var_dump( $districtData->status); die;
		// if (!empty($districtData->status) && $districtData->status == 200) {
		// 	$district = $districtData->data->data;
		// } else {
		// 	$district = array();
		// }
      
		$data = array(
			'id'=>$id,
			'name'=>$name,
			'code'=>$code,
			'TyLePhi'=>$TyLePhi,
            'NhanVienId'=>$NhanVienId,
			'ThongTinNguoiChoVay_HoTen'=>$ThongTinNguoiChoVay_HoTen,
			'ThongTinNguoiChoVay_CMND'=>$ThongTinNguoiChoVay_CMND,
			'ThongTinNguoiChoVay_DienThoai'=>$ThongTinNguoiChoVay_DienThoai,
			'ThongTinNguoiChoVay_Email'=>$ThongTinNguoiChoVay_Email,
			'ThongTinNguoiChoVay_DiaChi'=>$ThongTinNguoiChoVay_DiaChi,
			'LoaiNguoiThuHuongId'=>$LoaiNguoiThuHuongId,
			"updated_at" => $updateAt,
			"updated_by" => $this->userInfo['email']
		

		);
		$return = $this->api->apiPost($this->userInfo['token'], "config_gic/update_config_gic", $data);
      // die;
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successful_config_gic_update')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Failed_config_gic_update'),
				'data'=>$return 
			];
			echo json_encode($response);
			return;
		}
	}

	public function update()
	{
		$this->data["pageName"] = $this->lang->line('update_config_gic');
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		// get config_gic by id
		$data = array(
			"id" => $id,
			// "type_login" => 1
		);
		$config_gic = $this->api->apiPost($this->userInfo['token'], "config_gic/get_config_gic", $data);
		if (!empty($config_gic->status) && $config_gic->status == 200) {
			$this->data['config_gic'] = $config_gic->data;
		} else {
			$this->data['config_gic'] = array();
		}
		//var_dump($this->data['config_gic']); die;
		if (empty($config_gic->data)) {
			echo "404";
			die;
			redirect('404');
		}
		
		$this->data['template'] = 'page/config_gic/update_config_gic';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function listConfig_gic()
	{
		$this->data["pageName"] = $this->lang->line('Config_gic_manager');
		$data = array(// "type_login" => 1
		);
		$config_gicData = $this->api->apiPost($this->userInfo['token'], "config_gic/get_all", $data);
		if (!empty($config_gicData->status) && $config_gicData->status == 200) {
			$this->data['config_gicData'] = $config_gicData->data;
		} else {
			$this->data['config_gicData'] = array();
		}
		$this->data['template'] = 'page/config_gic/list_config_gic';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function doAddConfig_gic()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		$NhanVienId = !empty($_POST['NhanVienId']) ? $_POST['NhanVienId'] : "";
		$name = !empty($_POST['name']) ? $_POST['name'] : "";
		$code = !empty($_POST['code']) ? $_POST['code'] : "";
		$TyLePhi = !empty($_POST['TyLePhi']) ? $_POST['TyLePhi'] : "0";
		$ThongTinNguoiChoVay_HoTen = !empty($_POST['ThongTinNguoiChoVay_HoTen']) ? $_POST['ThongTinNguoiChoVay_HoTen'] : "";
		$ThongTinNguoiChoVay_CMND = !empty($_POST['ThongTinNguoiChoVay_CMND']) ? $_POST['ThongTinNguoiChoVay_CMND'] : "";
		$ThongTinNguoiChoVay_DienThoai = !empty($_POST['ThongTinNguoiChoVay_DienThoai']) ? $_POST['ThongTinNguoiChoVay_DienThoai'] : "";
		$ThongTinNguoiChoVay_Email = !empty($_POST['ThongTinNguoiChoVay_Email']) ? $_POST['ThongTinNguoiChoVay_Email'] : "";
		$ThongTinNguoiChoVay_DiaChi = !empty($_POST['ThongTinNguoiChoVay_DiaChi']) ? $_POST['ThongTinNguoiChoVay_DiaChi'] : "";
	    $LoaiNguoiThuHuongId = !empty($_POST['LoaiNguoiThuHuongId']) ? $_POST['LoaiNguoiThuHuongId'] : "";
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		
		
		$data = array(
			'id'=>$id,
			'name'=>$name,
			'code'=>$code,
			'TyLePhi'=>$TyLePhi,
            'NhanVienId'=>$NhanVienId,
			'ThongTinNguoiChoVay_HoTen'=>$ThongTinNguoiChoVay_HoTen,
			'ThongTinNguoiChoVay_CMND'=>$ThongTinNguoiChoVay_CMND,
			'ThongTinNguoiChoVay_DienThoai'=>$ThongTinNguoiChoVay_DienThoai,
			'ThongTinNguoiChoVay_Email'=>$ThongTinNguoiChoVay_Email,
			'ThongTinNguoiChoVay_DiaChi'=>$ThongTinNguoiChoVay_DiaChi,
			'LoaiNguoiThuHuongId'=>$LoaiNguoiThuHuongId,
			"created_at" => $createdAt,
			"updated_at" => $createdAt,
			"created_by" => $this->userInfo['email'],
			"updated_by" => $this->userInfo['email'],

		);
       
		$return = $this->api->apiPost($this->userInfo['token'], "config_gic/create_config_gic", $data);
		
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('create_config_gic_success')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('create_config_gic_failed')
			];
			echo json_encode($response);
			return;
		}
	}

	public function createConfig_gic()
	{
		$this->data["pageName"] = $this->lang->line('create_config_gic');
		$this->data['template'] = 'page/config_gic/add_config_gic';
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


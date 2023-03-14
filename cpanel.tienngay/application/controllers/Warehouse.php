<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
class Warehouse extends MY_Controller
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

	public function deleteWarehouse()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_warehouse_selected_deletion')
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
		$return = $this->api->apiPost($this->userInfo['token'], "warehouse/update_warehouse", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_warehouse')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Warehouse_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}
    public function doUpdateStatusWarehouse()
	{
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		$status = !empty($_GET['status']) ? $_GET['status'] : "";
		$status = ($status=='true') ? 'active' : 'deactive';
		if (empty($id)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_warehouse_selected_deletion')
			];
			echo json_encode($response);
			return;
		}
			if (empty($status)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('No_warehouse_selected_deletion')
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
		$return = $this->api->apiPost($this->userInfo['token'], "warehouse/update_warehouse", $data);
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successfully_deleted_warehouse')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Warehouse_deletion_failed')
			];
			echo json_encode($response);
			return;
		}
	}
	  
	public function doUpdateWarehouse()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : "";
		$code = !empty($_POST['code']) ? $_POST['code'] : "";
		$name = !empty($_POST['name']) ? $_POST['name'] : "";
		$max_xe_may = !empty($_POST['max_xe_may']) ? $_POST['max_xe_may'] : "";
		$max_oto = !empty($_POST['max_oto']) ? $_POST['max_oto'] : "";
		$manager_id = !empty($_POST['manager_id']) ? $_POST['manager_id'] : "";
		$address = !empty($_POST['address']) ? $_POST['address'] : "";
		$status = !empty($_POST['status']) ? $_POST['status'] : "";
	
		$updateAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		if (empty($code)) {
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Warehouse_code_empty')
			];
			echo json_encode($response);
			return;
		}
			if (empty($name)) {
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Warehouse_name_empty')
			];
			echo json_encode($response);
			return;
		}
			if (empty($max_xe_may)) {
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Warehouse_max_xe_may_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($max_oto)) {
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Warehouse_max_oto_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($manager_id)) {
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Warehouse_manage_empty')
			];
			echo json_encode($response);
			return;
		}
       $userData = $this->api->apiPost($this->userInfo['token'], "user/get_user", ['id'=>$manager_id]);
		if (!empty($userData->status) && $userData->status == 200) {
			$userData= $userData->data;
		}else{
			$userData=[];
		}
		$data = array(
			"code" => $code,
			"name" => $name,
			"max_xe_may" => $max_xe_may,
			"max_oto" => $max_oto,
			"manager" => ['id_user'=>$userData->_id->{'$oid'},'email'=>$userData->email,'phone_number'=>$userData->phone_number,'full_name'=>$userData->full_name],
			"phone" => $phone,
			"address" => $address,
			"status" => $status,
			"updated_at" => $updateAt,
			"updated_by" => $this->userInfo['email'],
			"id"=>$id

		);
		$return = $this->api->apiPost($this->userInfo['token'], "warehouse/update_warehouse", $data);
      // die;
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('Successful_warehouse_update')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Failed_warehouse_update'),
				'data'=>$image
			];
			echo json_encode($response);
			return;
		}
	}
    public function doYeuCauNhap()
	{
		$ma_kho = !empty($_POST['ma_kho']) ? $_POST['ma_kho'] : "";
		$id_contract = !empty($_POST['id_contract']) ? $_POST['id_contract'] : "";
		$code_contract = !empty($_POST['code_contract']) ? $_POST['code_contract'] : "";
		$ten_tai_san = !empty($_POST['ten_tai_san']) ? $_POST['ten_tai_san'] : "";
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		if (empty($ma_kho)) {
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Warehouse_code_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($id_contract)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' =>"Thiếu mã hợp đồng"
			];
			echo json_encode($response);
			return;
		}
			if (empty($code_contract)) {
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Thiếu mã hợp đồng"
			];
			echo json_encode($response);
			return;
		}
		if (empty($ten_tai_san)) {
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Thiếu tên tài sản"
			];
			echo json_encode($response);
			return;
		}
		$warehouse = $this->api->apiPost($this->userInfo['token'], "warehouse/get_one",array('id'=>$ma_kho));
		if (!empty($warehouse->status) && $warehouse->status == 200) {
			$warehouse =$warehouse->data; 
		} else {
			$warehouse = array();
		}
  
		$data = array(
			'id_warehouse'=>$ma_kho,
			'code_warehouse'=>(!empty($warehouse->code )) ? $warehouse->code : '',
			'id_contract'=>$id_contract,
			"trang_thai_tai_san"=>"1",
			"trang_thai_trong_kho"=>"1",
			"yeucaunhapkho"=>["ngay_yeu_cau"=>$createdAt,"nguoi_yeu_cau"=>$this->userInfo['email'],'kho_yeu_cau'=>$ma_kho],
			"created_at" => $createdAt,
			"updated_at" => $createdAt,
			"created_by" => $this->userInfo['email'],
			"updated_by" => $this->userInfo['email'],
			"image"=>['anh_tai_san'=>" ",'chung_tu_nhapxuat_kho'=>" "]
		);
		$return = $this->api->apiPost($this->userInfo['token'], "warehouse/create_warehouse_asset", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => "Đã gửi yêu cầu nhập kho thành công"
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Đã gửi yêu cầu nhập kho",
				'data'=>$image
			];
			echo json_encode($response);
			return;
		}
	}
	public function doXacNhanNhap()
	{
		
		$id_contract = !empty($_POST['id_contract']) ? $_POST['id_contract'] : "";
		
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
	
		if (empty($id_contract)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' =>"Thiếu mã hợp đồng"
			];
			echo json_encode($response);
			return;
		}
		$data = array(
           'id_contract'=>$id_contract,
			"trang_thai_trong_kho"=>"2",
			"nhapkho"=>["ngay_duyet"=>$createdAt,"nguoi_duyet"=>$this->userInfo['email']],
			"updated_at" => $updateAt,
			"updated_by" => $this->userInfo['email']
			
		);
		$return = $this->api->apiPost($this->userInfo['token'], "warehouse/update_warehouse_asset", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => "Đã xác nhận nhập kho thành công"
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Đã xác nhận yêu cầu nhập kho",
				'data'=>$image
			];
			echo json_encode($response);
			return;
		}
	}
	public function doXacNhanXuat()
	{
		
		$id_contract = !empty($_POST['id_contract']) ? $_POST['id_contract'] : "";
		
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
	
		if (empty($id_contract)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' =>"Thiếu mã hợp đồng"
			];
			echo json_encode($response);
			return;
		}
		$data = array(
             'id_contract'=>$id_contract,
			"trang_thai_trong_kho"=>"4",
			"xuatkho"=>["ngay_duyet"=>$createdAt,"nguoi_duyet"=>$this->userInfo['email']],
			"updated_at" => $updateAt,
			"updated_by" => $this->userInfo['email']
			
		);
		$return = $this->api->apiPost($this->userInfo['token'], "warehouse/update_warehouse_asset", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => "Đã xác nhận xuất kho thành công"
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Đã xác nhận yêu cầu xuất kho",
				'data'=>$image
			];
			echo json_encode($response);
			return;
		}
	}
	public function doXacNhanTraKhach()
	{
		
		$id_contract = !empty($_POST['id_contract']) ? $_POST['id_contract'] : "";
		
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
	
		if (empty($id_contract)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' =>"Thiếu mã hợp đồng"
			];
			echo json_encode($response);
			return;
		}
		$data = array(
            'id_contract'=>$id_contract,
			"trang_thai_tai_san"=>"3",
			"updated_at" => $updateAt,
			"updated_by" => $this->userInfo['email']
			
		);
		$return = $this->api->apiPost($this->userInfo['token'], "warehouse/update_warehouse_asset", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => "Đã xác nhận trả khách thành công"
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Đã xác nhận yêu cầu trả khách",
				'data'=>$image
			];
			echo json_encode($response);
			return;
		}
	}
	public function doXacNhanThanhLy()
	{
		
		$id_contract = !empty($_POST['id_contract']) ? $_POST['id_contract'] : "";
		
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
	
		if (empty($id_contract)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' =>"Thiếu mã hợp đồng"
			];
			echo json_encode($response);
			return;
		}
		$data = array(
           'id_contract'=>$id_contract,
			"trang_thai_tai_san"=>"5",
			"updated_at" => $updateAt,
			"updated_by" => $this->userInfo['email']
			
		);
		$return = $this->api->apiPost($this->userInfo['token'], "warehouse/update_warehouse_asset", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => "Đã xác nhận thanh lý thành công"
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Đã xác nhận yêu cầu thanh lý",
				'data'=>$image
			];
			echo json_encode($response);
			return;
		}
	}
	public function doYeuCauXuat()
	{
		
		$id_contract = !empty($_POST['id_contract']) ? $_POST['id_contract'] : "";
		
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
	
		if (empty($id_contract)) {
			$response = [
				'res' => false,
				'status' => "400",
				'message' =>"Thiếu mã hợp đồng"
			];
			echo json_encode($response);
			return;
		}
		$data = array(
            'id_contract'=>$id_contract,
			"trang_thai_trong_kho"=>"3",
			"trang_thai_tai_san"=>"2",
			"yeucauxuatkho"=>["ngay_yeu_cau"=>$createdAt,"nguoi_yeu_cau"=>$this->userInfo['email']],
			"updated_at" => $createdAt,
			"updated_by" => $this->userInfo['email']
			
		);
		$return = $this->api->apiPost($this->userInfo['token'], "warehouse/update_warehouse_asset", $data);

		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => "Đã gửi yêu cầu xuất kho thành công"
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => "Đã gửi yêu cầu xuất kho",
				'data'=>$image
			];
			echo json_encode($response);
			return;
		}
	}
	  public function print_phieu_nhap() {
        $data = $this->input->get();
        $data['id'] = $this->security->xss_clean($data['id']);
        
		$asset = $this->api->apiPost($this->userInfo['token'], "warehouse/get_one_contract", ["id" => $data['id']]);
		if (!empty($asset->status) && $asset->status == 200) {
			$this->data['asset'] = $asset->data;
		} else {
			$this->data['asset'] = array();
		}
		$status_asset = $this->api->apiPost($this->userInfo['token'], "warehouse/get_status_asset",["id" => $data['id']]);
		
		if (!empty($status_asset->status) && $status_asset->status == 200) {
			$this->data['status_asset'] = $status_asset->data;
		} else {
			$this->data['status_asset'] = array();
		}

	    $warehouse = $this->api->apiPost($this->userInfo['token'], "warehouse/get_one",['id'=>$status_asset->data->id_warehouse]);
		if (!empty($warehouse->status) && $warehouse->status == 200) {
			$this->data['warehouse'] = $warehouse->data;
		} else {
			$this->data['warehouse'] = array();
		}
		//var_dump( $this->data['warehouse']); die;
   	  $this->load->view('page/warehouse/asset/print_import', isset($this->data)?$this->data:NULL);
		return;
    }
      public function print_phieu_xuat() {
        $data = $this->input->get();
        $data['id'] = $this->security->xss_clean($data['id']);
        
		$asset = $this->api->apiPost($this->userInfo['token'], "warehouse/get_one_contract", ["id" => $data['id']]);
		if (!empty($asset->status) && $asset->status == 200) {
			$this->data['asset'] = $asset->data;
		} else {
			$this->data['asset'] = array();
		}
		$status_asset = $this->api->apiPost($this->userInfo['token'], "warehouse/get_status_asset",["id" => $data['id']]);
		
		if (!empty($status_asset->status) && $status_asset->status == 200) {
			$this->data['status_asset'] = $status_asset->data;
		} else {
			$this->data['status_asset'] = array();
		}

	    $warehouse = $this->api->apiPost($this->userInfo['token'], "warehouse/get_one",['id'=>$status_asset->data->id_warehouse]);
		if (!empty($warehouse->status) && $warehouse->status == 200) {
			$this->data['warehouse'] = $warehouse->data;
		} else {
			$this->data['warehouse'] = array();
		}
		//var_dump( $this->data['warehouse']); die;
   	  $this->load->view('page/warehouse/asset/print_export', isset($this->data)?$this->data:NULL);
		return;
    }
     public function print_bb_ban_giao() {
        $data = $this->input->get();
        $data['id'] = $this->security->xss_clean($data['id']);
        
		$asset = $this->api->apiPost($this->userInfo['token'], "warehouse/get_one_contract", ["id" => $data['id']]);
		if (!empty($asset->status) && $asset->status == 200) {
			$this->data['asset'] = $asset->data;
		} else {
			$this->data['asset'] = array();
		}
		$status_asset = $this->api->apiPost($this->userInfo['token'], "warehouse/get_status_asset",["id" => $data['id']]);
		
		if (!empty($status_asset->status) && $status_asset->status == 200) {
			$this->data['status_asset'] = $status_asset->data;
		} else {
			$this->data['status_asset'] = array();
		}

	    $warehouse = $this->api->apiPost($this->userInfo['token'], "warehouse/get_one",['id'=>$status_asset->data->id_warehouse]);
		if (!empty($warehouse->status) && $warehouse->status == 200) {
			$this->data['warehouse'] = $warehouse->data;
		} else {
			$this->data['warehouse'] = array();
		}
		//var_dump( $this->data['warehouse']); die;
   	  $this->load->view('page/warehouse/asset/print_bien_ban_ban_giao', isset($this->data)?$this->data:NULL);
		return;
    }
	public function update()
	{
		$this->data["pageName"] = $this->lang->line('update_warehouse');
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		// get warehouse by id
		$data = array(
			"id" => $id,
			// "type_login" => 1
		);
		$warehouse = $this->api->apiPost($this->userInfo['token'], "warehouse/get_one", $data);
		if (!empty($warehouse->status) && $warehouse->status == 200) {
			$this->data['warehouse'] = $warehouse->data;
		} else {
			$this->data['warehouse'] = array();
		}
		$managerData = $this->api->apiPost($this->userInfo['token'], "user/get_all",array());
        if(!empty($managerData->status) && $managerData->status == 200){
            $this->data['managerData'] = $managerData->data;
        }else{
            $this->data['managerData'] = array();
        }
		if (empty($warehouse->data)) {
			echo "404";
			die;
			redirect('404');
		}
		
		$this->data['template'] = 'page/warehouse/update_warehouse';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function listWarehouse()
	{
        
		$this->data["pageName"] = $this->lang->line('Warehouse_manager');
		$data = array(// "type_login" => 1
		);
		$warehouseData = $this->api->apiPost($this->userInfo['token'], "warehouse/get_all", $data);
			//var_dump($this->userInfo['token']); die;
		if (!empty($warehouseData->status) && $warehouseData->status == 200) {
			$this->data['warehouseData'] = $warehouseData->data;
		} else {
			$this->data['warehouseData'] = array();
		}
        
		$this->data['template'] = 'page/warehouse/list_warehouse';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
	public function detailAsset()
	{
		//var_dump($this->userInfo['token']); die;
        	$this->data["pageName"] = $this->lang->line('warehouse_view_detail');
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		// get warehouse by id
		$data = array(
			"id" => $id,
			// "type_login" => 1
		);
		
		$asset = $this->api->apiPost($this->userInfo['token'], "warehouse/get_one_contract", $data);
		if (!empty($asset->status) && $asset->status == 200) {
			$this->data['asset'] = $asset->data;
		} else {
			$this->data['asset'] = array();
		}
		$status_asset = $this->api->apiPost($this->userInfo['token'], "warehouse/get_status_asset",$data);
		if (!empty($status_asset->status) && $status_asset->status == 200) {
			$this->data['status_asset'] = $status_asset->data;
		} else {
			$this->data['status_asset'] = array();
		}
		//var_dump($status_asset); die;
	    $warehouseData = $this->api->apiPost($this->userInfo['token'], "warehouse/get_all_home",$data);
		if (!empty($warehouseData->status) && $warehouseData->status == 200) {
			$this->data['warehouseData'] = $warehouseData->data;
		} else {
			$this->data['warehouseData'] = array();
		}
	    //var_dump($this->data['asset']->property_infor[0]->value); die;
		$this->data['template'] = 'page/warehouse/asset/detail_asset';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
	public function listAsset()
	{
		//echo $this->userInfo['token']; die;
		$this->data["pageName"] = $this->lang->line('Asset_manager');
		
		$assetData = $this->api->apiPost($this->userInfo['token'], "warehouse/get_asset_contract",array());
			//var_dump($this->userInfo['token']); die;
		if (!empty($assetData->status) && $assetData->status == 200) {
			$this->data['assetData'] = $assetData->data;
		} else {
			$this->data['assetData'] = array();
		}
      $warehouseData = $this->api->apiPost($this->userInfo['token'], "warehouse/get_all_home", array());
			//var_dump($this->userInfo['token']); die;
		if (!empty($warehouseData->status) && $warehouseData->status == 200) {
			$this->data['warehouseData'] = $warehouseData->data;
		} else {
			$this->data['warehouseData'] = array();
		}
		$warehouse_assetData = $this->api->apiPost($this->userInfo['token'], "warehouse/get_all_asset", array());
		//var_dump($warehouse_assetData->data[0]->id_contract); die;
		if (!empty($warehouse_assetData->status) && $warehouse_assetData->status == 200) {
			$this->data['warehouse_assetData'] = $warehouse_assetData->data;
		} else {
			$this->data['warehouse_assetData'] = array();
		}
		$this->data['template'] = 'page/warehouse/asset/list_asset';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
     public function view_detail()
	{
       	$this->data["pageName"] = $this->lang->line('warehouse_view_detail');
		$id = !empty($_GET['id']) ? $_GET['id'] : "";
		// get warehouse by id
		$data = array(
			"id" => $id,
			// "type_login" => 1
		);
		
		$warehouse = $this->api->apiPost($this->userInfo['token'], "warehouse/get_one", $data);
		if (!empty($warehouse->status) && $warehouse->status == 200) {
			$this->data['warehouse'] = $warehouse->data;
		} else {
			$this->data['warehouse'] = array();
		}
		$contractData = $this->api->apiPost($this->userInfo['token'], "warehouse/get_warehouse_in_contract",$data);
		//var_dump($this->userInfo['token']); die;
		if (!empty($contractData->status) && $contractData->status == 200) {
			$this->data['contractData'] = $contractData->data;
		} else {
			$this->data['contractData'] = array();
		}
		$this->data['template'] = 'page/warehouse/view_detail_warehouse';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}
	public function doAddWarehouse()
	{		
		$code = !empty($_POST['code']) ? $_POST['code'] : "";
		$name = !empty($_POST['name']) ? $_POST['name'] : "";
		$max_xe_may = !empty($_POST['max_xe_may']) ? $_POST['max_xe_may'] : "";
		$max_oto = !empty($_POST['max_oto']) ? $_POST['max_oto'] : "";
		$manager_id = !empty($_POST['manager_id']) ? $_POST['manager_id'] : "";
		$address = !empty($_POST['address']) ? $_POST['address'] : "";
		$status = !empty($_POST['status']) ? $_POST['status'] : "";
		$createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
		
		if (empty($code)) {
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Warehouse_code_empty')
			];
			echo json_encode($response);
			return;
		}
			if (empty($name)) {
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Warehouse_name_empty')
			];
			echo json_encode($response);
			return;
		}
			if (empty($max_xe_may)) {
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Warehouse_max_xe_may_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($max_oto)) {
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Warehouse_max_oto_empty')
			];
			echo json_encode($response);
			return;
		}
		if (empty($manager_id)) {
		
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('Warehouse_manage_empty')
			];
			echo json_encode($response);
			return;
		}
		$userData = $this->api->apiPost($this->userInfo['token'], "user/get_user", ['id'=>$manager_id]);
		if (!empty($userData->status) && $userData->status == 200) {
			$userData= $userData->data;
		}else{
			$userData=[];
		}
		
		$data = array(
			"code" => $code,
			"name" => $name,
			"max_xe_may" => $max_xe_may,
			"max_oto" => $max_oto,
			"manager" => ['id_user'=>$userData->_id->{'$oid'},'email'=>$userData->email,'phone_number'=>$userData->phone_number,'full_name'=>$userData->full_name],
			"address" => $address,
			"status" => $status,
			"created_at" => $createdAt,
			"updated_at" => $createdAt,
			"created_by" => $this->userInfo['email'],
			"updated_by" => $this->userInfo['email'],

		);
       
		$return = $this->api->apiPost($this->userInfo['token'], "warehouse/create_warehouse", $data);
		
		if (!empty($return->status) && $return->status == 200) {
			$response = [
				'res' => true,
				'status' => "200",
				'message' => $this->lang->line('create_warehouse_success')
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'res' => false,
				'status' => "400",
				'message' => $this->lang->line('create_warehouse_failed')
			];
			echo json_encode($response);
			return;
		}
	}
     public function doUploadImage(){
        $data = $this->input->post();
        $data['type_img'] = $this->security->xss_clean($data['type_img']);
        $data['contract_id'] = $this->security->xss_clean($data['contract_id']);
        $dataPost = array(
            "id" => $data['contract_id'],
            "type_img" => $data['type_img'],
            "file" => $_FILES['file']
        );
        $result = $this->api->apiPost($this->userInfo['token'], "warehouse/upload_image", $dataPost);  
         //echo $result; return;
        $this->pushJson('200', json_encode(array("code" => "200", "data" => $result)));
    }
    private function pushJson($code, $data) {
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($code)
            ->set_output($data);
    }
	public function createWarehouse()
	{
		$this->data["pageName"] = $this->lang->line('create_warehouse');
		$this->data['template'] = 'page/warehouse/add_warehouse';
		
		$managerData = $this->api->apiPost($this->userInfo['token'], "user/get_all",array());
        if(!empty($managerData->status) && $managerData->status == 200){
            $this->data['managerData'] = $managerData->data;
        }else{
            $this->data['managerData'] = array();
        }
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	
}


<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Asset_manager extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url', 'file'));
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
		$this->spreadsheet = new Spreadsheet();
		$this->sheet = $this->spreadsheet->getActiveSheet();
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	public function asset()
	{
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$text = !empty($_GET['text_search']) ? $_GET['text_search'] : "";
		$asset_code = !empty($_GET['asset_code']) ? $_GET['asset_code'] : "";
		$so_khung = !empty($_GET['so_khung']) ? $_GET['so_khung'] : "";
		$so_may = !empty($_GET['so_may']) ? $_GET['so_may'] : "";
		$type_asset = [];
		$url_type_asset = "";
		if (is_array($_GET['asset'])) {
			foreach ($_GET['asset'] as $value) {
				array_push($type_asset, $value);
				$url_type_asset .= '&asset[]=' . $value;
			}
		}
		if (!empty($customer_name)) {
			$data['customer_name'] = $customer_name;
		}
		if (!empty($text)) {
			$data['text'] = $text;
		}
		if (!empty($asset_code)) {
			$data['asset_code'] = $asset_code;
		}
		if (!empty($so_khung)) {
			$data['so_khung'] = $so_khung;
		}
		if (!empty($so_may)) {
			$data['so_may'] = $so_may;
		}
		if (!empty($type_asset)) {
			$data['type_asset'] = $type_asset;
		}
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('asset_manager/asset?customer_name=' . $customer_name . '&asset_code' . $asset_code . '&so_khung' . $so_khung . '&so_may' . $so_may . $url_type_asset . '&text_search' . $text);
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 30;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$data['per_page'] = $config['per_page'];
		$data['uriSegment'] = $config['uri_segment'];
		$asset = $this->api->apiPost($this->userInfo['token'], "asset_manager/get_all_asset", $data);
		if (!empty($asset->status) && $asset->status == 200) {
			$this->data['assets'] = $asset->data;
			$config['total_rows'] = $asset->total;
			$this->data['total_rows'] = $asset->total;
		} else {
			$this->data['assets'] = array();
		}
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['template'] = 'page/asset/list_asset';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	private function pushJson($code, $data)
	{
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}

	private function callLibExcel($filename)
	{
		// Redirect output to a client's web browser (Xlsx)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.
		ob_end_clean();
		$writer = IOFactory::createWriter($this->spreadsheet, 'Xlsx');
		$writer->save('php://output');
	}

	public function excel_asset()
	{
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$text = !empty($_GET['text_search']) ? $_GET['text_search'] : "";
		$asset_code = !empty($_GET['asset_code']) ? $_GET['asset_code'] : "";
		$so_khung = !empty($_GET['so_khung']) ? $_GET['so_khung'] : "";
		$so_may = !empty($_GET['so_may']) ? $_GET['so_may'] : "";
		$type_asset = [];
		$url_type_asset = "";
		if (is_array($_GET['asset'])) {
			foreach ($_GET['asset'] as $value) {
				array_push($type_asset, $value);
				$url_type_asset .= '&asset[]=' . $value;
			}
		}
		if (!empty($customer_name)) {
			$data['customer_name'] = $customer_name;
		}
		if (!empty($text)) {
			$data['text'] = $text;
		}
		if (!empty($asset_code)) {
			$data['asset_code'] = $asset_code;
		}
		if (!empty($so_khung)) {
			$data['so_khung'] = $so_khung;
		}
		if (!empty($so_may)) {
			$data['so_may'] = $so_may;
		}
		if (!empty($type_asset)) {
			$data['type_asset'] = $type_asset;
		}
		$data['per_page'] = 1000;
		$asset = $this->api->apiPost($this->userInfo['token'], "asset_manager/get_all_asset", $data);
		if (!empty($asset->status) && $asset->status == 200) {
			$this->exportAsset($asset->data);
			$this->callLibExcel('data-asset' . time() . '.xlsx');

		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
			redirect(base_url('asset_manager/asset'));
		}
	}

	public function exportAsset($data)
	{
		$this->sheet->setCellValue('A1', 'Mã tài sản');
		$this->sheet->setCellValue('B1', 'Tên khách hàng');
		$this->sheet->setCellValue('C1', 'Tên tài sản');
		$this->sheet->setCellValue('D1', 'Biển số xe');
		$this->sheet->setCellValue('E1', 'Số khung');
		$this->sheet->setCellValue('F1', 'Số máy');
		$this->sheet->setCellValue('G1', 'Ngày cấp');
		$this->sheet->setCellValue('H1', 'Số đăng kí');
		$this->sheet->setCellValue('I1', 'Mã hd liên quan');
		$i = 2;
		foreach ($data as $value) {
			$contract = $value->contract;
			$code_contract = [];
			foreach ($contract as $c) {
				array_push($code_contract, $c->code_contract);
			}
			$this->sheet->setCellValue('A' . $i, $value->asset_code ?? '');
			$this->sheet->setCellValue('B' . $i, $value->customer_name ?? '');
			$this->sheet->setCellValue('C' . $i, $value->product ?? '');
			$this->sheet->setCellValue('D' . $i, $value->bien_so_xe ?? '');
			$this->sheet->setCellValue('E' . $i, $value->so_khung ?? '');
			$this->sheet->setCellValue('F' . $i, $value->so_may ?? '');
			$this->sheet->setCellValue('G' . $i, !empty($value->ngay_cap) ? date('d/m/Y', $value->ngay_cap) : '');
			$this->sheet->setCellValue('H' . $i, $value->so_dang_ki ?? '');
			$this->sheet->setCellValue('I' . $i, !empty($value->contract) ? implode(", ", $code_contract) : '');
			$i++;
		}
	}

	public function viewImageAsset()
	{
		$this->data['template'] = 'page/asset/view_img';
		$dataGet = $this->input->get();
		$dataGet['id'] = $this->security->xss_clean($dataGet['id']);
		$dataPost = array(
			"id" => $dataGet['id']
		);
		$result = $this->api->apiPost($this->userInfo['token'], "asset_manager/get_image_asset", $dataPost);
		$this->data['images'] = $result->data;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function upload_img()
	{
		// $data = $this->input->post();
		if ($_FILES['file']['size'] > 20000000) {
			return $this->pushJson('200', json_encode(array(
				'code' => '201',
				'msg' => 'Kích cỡ max là 10MB'
			)));
		}
		$acceptFormat = array("jpeg", "png", "jpg", "mp3", "mp4");
		if (in_array($_FILES['file']['type'], $acceptFormat)) {
			return $this->pushJson('200', json_encode(array(
				'code' => '201',
				'msg' => 'Định dạng không cho phép',
				'type' => $_FILES['file']['type']
			)));
		}
		$serviceUpload = $this->config->item("url_service_upload");
		// $curlFile  = new CURLFile($_FILES["avatar"]["tmp_name"],$_FILES["avatar"]["type"],$_FILES["avatar"]["name"]);
		$cfile = new CURLFile($_FILES['file']["tmp_name"], $_FILES['file']["type"], $_FILES['file']["name"]);
		$post = array('avatar' => $cfile);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $serviceUpload);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		$result1 = json_decode($result);

		$random = sha1(substr(md5(rand()), 0, 8));

		if (empty($result1->path)) {
			return $this->pushJson('200', json_encode(array(
				'code' => '201',
				'msg' => 'File lỗi! Hệ thống không đọc được file (file ảnh bạn mở màn hình chụp lại rồi tạo ảnh mới upload lại)'
			)));
		} else {
			$response = array(
				'code' => 200,
				"msg" => "success",
				'path' => $result1->path,
				'key' => $random,
				'raw_name' => $_FILES['file']['name']
			);
			$push = json_encode($response);
			return $this->pushJson(200, $push);
		}
	}

	public function add_new_asset()
	{
		$loai_xe = !empty($_POST['loai_xe']) ? $_POST['loai_xe'] : '';
		$name_customer = !empty($_POST['name_customer']) ? $_POST['name_customer'] : '';
		$address = !empty($_POST['address']) ? $_POST['address'] : '';
		$product = !empty($_POST['product']) ? $_POST['product'] : '';
		$nhan_hieu = !empty($_POST['nhan_hieu']) ? $_POST['nhan_hieu'] : '';
		$model = !empty($_POST['model']) ? $_POST['model'] : '';
		$bien_so = !empty($_POST['bien_so']) ? $_POST['bien_so'] : '';
		$so_khung = !empty($_POST['so_khung']) ? $_POST['so_khung'] : '';
		$so_may = !empty($_POST['so_may']) ? $_POST['so_may'] : '';
		$so_dang_ki = !empty($_POST['so_dang_ki']) ? $_POST['so_dang_ki'] : '';
		$ngay_cap = !empty($_POST['ngay_cap']) ? $_POST['ngay_cap'] : '';
		$note = !empty($_POST['note']) ? $_POST['note'] : '';
		$image = !empty($_POST['image_asset']) ? $_POST['image_asset'] : '';
		if (!empty($loai_xe)) {
			$data['loai_xe'] = $loai_xe;
		}
		if (!empty($name_customer)) {
			$data['name_customer'] = $name_customer;
		}
		if (!empty($address)) {
			$data['address'] = $address;
		}
		if (!empty($product)) {
			$data['product'] = $product;
		}
		if (!empty($name_customer)) {
			$data['name_customer'] = $name_customer;
		}
		if (!empty($nhan_hieu)) {
			$data['nhan_hieu'] = $nhan_hieu;
		}
		if (!empty($model)) {
			$data['model'] = $model;
		}
		if (!empty($bien_so)) {
			$data['bien_so'] = $bien_so;
		}
		if (!empty($so_khung)) {
			$data['so_khung'] = $so_khung;
		}
		if (!empty($so_may)) {
			$data['so_may'] = $so_may;
		}
		if (!empty($so_dang_ki)) {
			$data['so_dang_ki'] = $so_dang_ki;
		}
		if (!empty($ngay_cap)) {
			$data['ngay_cap'] = $ngay_cap;
		}
		if (!empty($note)) {
			$data['note'] = $note;
		}
		if (!empty($image)) {
			$data['image'] = $image;
		}
		$res = $this->api->apiPost($this->userInfo['token'], "asset_manager/add_new_asset", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $res->message)));
			return;
		} elseif (!empty($res->status) && $res->status == 401) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $res->message)));
			return;

		}
	}

	public function add_nha_dat()
	{
		$ten_khach_hang = !empty($_POST['ten_khach_hang']) ? ($_POST['ten_khach_hang']) : '';
		$nam_sinh = !empty($_POST['nam_sinh']) ? trim($_POST['nam_sinh']) : '';
		$cmt = !empty($_POST['cmt']) ? trim($_POST['cmt']) : '';
		$dia_chi = !empty($_POST['dia_chi']) ? trim($_POST['dia_chi']) : '';
		$nguoi_lien_quan = !empty($_POST['nguoi_lien_quan']) ? trim($_POST['nguoi_lien_quan']) : '';
		$nam_sinh_nguoi_lien_quan = !empty($_POST['nam_sinh_nguoi_lien_quan']) ? trim($_POST['nam_sinh_nguoi_lien_quan']) : '';
		$cmt_nguoi_lien_quan = !empty($_POST['cmt_nguoi_lien_quan']) ? trim($_POST['cmt_nguoi_lien_quan']) : '';
		$dia_chi_nguoi_lien_quan = !empty($_POST['dia_chi_nguoi_lien_quan']) ? trim($_POST['dia_chi_nguoi_lien_quan']) : '';
		$thua_dat_so = !empty($_POST['thua_dat_so']) ? trim($_POST['thua_dat_so']) : '';
		$dia_chi_nha_dat = !empty($_POST['dia_chi_nha_dat']) ? trim($_POST['dia_chi_nha_dat']) : '';
		$dien_tich_nha_dat = !empty($_POST['dien_tich_nha_dat']) ? trim($_POST['dien_tich_nha_dat']) : '';
		$hinh_thuc_su_dung = !empty($_POST['hinh_thuc_su_dung']) ? trim($_POST['hinh_thuc_su_dung']) : '';
		$muc_dich_su_dung = !empty($_POST['muc_dich_su_dung']) ? trim($_POST['muc_dich_su_dung']) : '';
		$thoi_han_su_dung_dat = !empty($_POST['thoi_han_su_dung_dat']) ? trim($_POST['thoi_han_su_dung_dat']) : '';
		$loai_nha_o = !empty($_POST['loai_nha_o']) ? trim($_POST['loai_nha_o']) : '';
		$dien_tich_nha_o = !empty($_POST['dien_tich_nha_o']) ? trim($_POST['dien_tich_nha_o']) : '';
		$ket_cau_nha_o = !empty($_POST['ket_cau_nha_o']) ? trim($_POST['ket_cau_nha_o']) : '';
		$cap_nha_o = !empty($_POST['cap_nha_o']) ? trim($_POST['cap_nha_o']) : '';
		$so_tang_nha_o = !empty($_POST['so_tang_nha_o']) ? trim($_POST['so_tang_nha_o']) : '';
		$thoi_gian_song = !empty($_POST['thoi_gian_song']) ? trim($_POST['thoi_gian_song']) : '';
		$ten_cong_trinh_khac = !empty($_POST['ten_cong_trinh_khac']) ? trim($_POST['ten_cong_trinh_khac']) : '';
		$dien_tich_cong_trinh_khac = !empty($_POST['dien_tich_cong_trinh_khac']) ? trim($_POST['dien_tich_cong_trinh_khac']) : '';
		$hinh_thuc_so_huu = !empty($_POST['hinh_thuc_so_huu']) ? trim($_POST['hinh_thuc_so_huu']) : '';
		$cap_cong_trinh = !empty($_POST['cap_cong_trinh']) ? trim($_POST['cap_cong_trinh']) : '';
		$thoi_gian_su_huu = !empty($_POST['thoi_gian_su_huu']) ? trim($_POST['thoi_gian_su_huu']) : '';
		$image = !empty($_POST['image_sodo']) ? ($_POST['image_sodo']) : '';
		if (!empty($ten_khach_hang)) {
			$data['customer_name'] = $ten_khach_hang;
		}
		if (!empty($nam_sinh)) {
			$data['nam_sinh'] = (string)$nam_sinh;
		}
		if (!empty($cmt)) {
			$data['cmt'] = (string)$cmt;
		}
		if (!empty($dia_chi)) {
			$data['dia_chi'] = $dia_chi;
		}
		if (!empty($nguoi_lien_quan)) {
			$data['nguoi_lien_quan'] = $nguoi_lien_quan;
		}
		if (!empty($nam_sinh_nguoi_lien_quan)) {
			$data['nam_sinh_nguoi_lien_quan'] = (string)$nam_sinh_nguoi_lien_quan;
		}
		if (!empty($cmt_nguoi_lien_quan)) {
			$data['cmt_nguoi_lien_quan'] = (string)$cmt_nguoi_lien_quan;
		}
		if (!empty($dia_chi_nguoi_lien_quan)) {
			$data['dia_chi_nguoi_lien_quan'] = $dia_chi_nguoi_lien_quan;
		}
		if (!empty($thua_dat_so)) {
			$data['thua_dat_so'] = $thua_dat_so;
		}
		if (!empty($dia_chi_nha_dat)) {
			$data['dia_chi_nha_dat'] = $dia_chi_nha_dat;
		}
		if (!empty($hinh_thuc_su_dung)) {
			$data['hinh_thuc_su_dung'] = $hinh_thuc_su_dung;
		}
		if (!empty($muc_dich_su_dung)) {
			$data['muc_dich_su_dung'] = $muc_dich_su_dung;
		}
		if (!empty($thoi_han_su_dung_dat)) {
			$data['thoi_han_su_dung_dat'] = (string)$thoi_han_su_dung_dat;
		}
		if (!empty($loai_nha_o)) {
			$data['loai_nha_o'] = $loai_nha_o;
		}
		if (!empty($dien_tich_nha_o)) {
			$data['dien_tich_nha_o'] = (string)$dien_tich_nha_o;
		}
		if (!empty($ket_cau_nha_o)) {
			$data['ket_cau_nha_o'] = $ket_cau_nha_o;
		}
		if (!empty($cap_nha_o)) {
			$data['cap_nha_o'] = $cap_nha_o;
		}
		if (!empty($so_tang_nha_o)) {
			$data['so_tang_nha_o'] = (string)$so_tang_nha_o;
		}
		if (!empty($thoi_gian_song)) {
			$data['thoi_gian_song'] = (string)$thoi_gian_song;
		}
		if (!empty($ten_cong_trinh_khac)) {
			$data['ten_cong_trinh_khac'] = $ten_cong_trinh_khac;
		}
		if (!empty($dien_tich_cong_trinh_khac)) {
			$data['dien_tich_cong_trinh_khac'] = (string)$dien_tich_cong_trinh_khac;
		}
		if (!empty($hinh_thuc_so_huu)) {
			$data['hinh_thuc_so_huu'] = $hinh_thuc_so_huu;
		}
		if (!empty($cap_cong_trinh)) {
			$data['cap_cong_trinh'] = $cap_cong_trinh;
		}
		if (!empty($thoi_gian_su_huu)) {
			$data['thoi_gian_su_huu'] = (string)$thoi_gian_su_huu;
		}
		if (!empty($image)) {
			$data['image'] = $image;
		}
		$res = $this->api->apiPost($this->userInfo['token'], "asset_manager/add_tin_chap", $data);
		if (!empty($res->status) && $res->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "msg" => $res->message)));
			return;
		} elseif (!empty($res->status) && $res->status == 401) {
			$this->pushJson('200', json_encode(array("code" => "401", "msg" => $res->message)));
			return;
		}

	}
}

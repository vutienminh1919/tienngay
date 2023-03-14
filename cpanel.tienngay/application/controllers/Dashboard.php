<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Dashboard extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url', 'file'));
		$this->load->helper('lead_helper');
		$this->load->model("main_property_model");
		$this->load->model('config_gic_model');
		$this->load->model("time_model");
		$this->load->library('pagination');
		$this->config->load('config');

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

	public function index()
	{
		try {
			$this->data["pageName"] = "Dashboard";
			$this->data['template'] = 'page/report_kpi/kpi';
			$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
			$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

			$cond = array(
				"start" => $start,
				"end" => $end,
			);
			$res = $this->api->apiPost($this->user['token'], "report_kpi/kpi_domain", $cond);
			if (!empty($res->status) && $res->status == 200) {
				$this->data['data'] = $res->data;
			} else {
				$this->data['data'] = array();
			}

			$this->load->view('template', isset($this->data) ? $this->data : NULL);
		} catch (\Exception $exception) {
			$this->data['data'] = '';
			$this->load->view('template', isset($this->data) ? $this->data : NULL);
		}
	}

	public function baohiem()
	{
		try {
			$this->data["pageName"] = "Dashboard bảo hiểm";
			$this->data['template'] = 'page/dashboard/baohiem/baohiem';
			$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
			$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

			$cond = array(
				"start" => $start,
				"end" => $end,
			);
			$res = $this->api->apiPost($this->user['token'], "statistic/search", $cond);
			if (!empty($res->status) && $res->status == 200) {
				$this->data['data_total'] = $res->data;
				$this->data['data_kv'] = $res->data;
				$this->data['data_easy'] = $res->data;
				$this->data['data_plt'] = $res->data;
				$this->data['data_vbi'] = $res->data;
				$this->data['data_bn_vbi_utv'] = $res->data_bn_vbi_utv;
				$this->data['data_bn_vbi_sxh'] = $res->data_bn_vbi_sxh;
				$this->data['data_bn_mic_tnds'] = $res->data_bn_mic_tnds;
				$this->data['data_bn_vbi_oto'] = $res->data_bn_vbi_oto;
			} else {
				$this->data['data'] = array();
			}

			$this->load->view('template', isset($this->data) ? $this->data : NULL);
		} catch (\Exception $exception) {
			$this->data['data'] = '';
			$this->load->view('template', isset($this->data) ? $this->data : NULL);
		}
	}

	public function index_v2()
	{
		try {
			$this->data["pageName"] = "Dashboard";
			$this->data['template'] = 'page/dashboard_v2/manager.php';
			$start = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
			$end = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

			$cond = array(
				"start" => $start,
				"end" => $end,
			);
			$res = $this->api->apiPost($this->user['token'], "report_kpi/kpi_domain", $cond);
			if (!empty($res->status) && $res->status == 200) {
				$this->data['data'] = $res->data;
			} else {
				$this->data['data'] = array();
			}

			$this->load->view('template', isset($this->data) ? $this->data : NULL);
		} catch (\Exception $exception) {
			$this->data['data'] = '';
			$this->load->view('template', isset($this->data) ? $this->data : NULL);
		}
	}

	public function index_digital_mkt()
	{

		$data = [];
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : date('Y-m-d');
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : date('Y-m-d');
		$area_search = !empty($_GET['area_search']) ? $_GET['area_search'] : "";


		if (!empty($fdate)) {
			$data['fdate'] = $fdate;
		}
		if (!empty($tdate)) {
			$data['tdate'] = $tdate;
		}
		if (!empty($area_search)) {
			$data['area_search'] = $area_search;
		}


		$data = $this->api->apiPost($this->user['token'], "dashboard_telesale/report_digital_mkt", $data);
		if (!empty($data->status) && $data->status == 200) {
			$this->data['data'] = $data->data;
			$this->data['table_total'] = $data->table_total;
			$this->data['table_top'] = $data->table_top;
			$this->data['area'] = $data->area;
		} else {
			$this->data['data'] = array();
			$this->data['table_total'] = array();
			$this->data['table_top'] = array();
			$this->data['area'] = array();
		}


		$this->data['template'] = 'page/dashboard_telesale/index_digital_mkt.php';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function import_cost_mkt()
	{

		$this->data['template'] = 'page/dashboard_telesale/impport_cost_mkt.php';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function importCostFacebook()
	{

		if (empty($_FILES['upload_file']['name'])) {
			$this->session->set_flashdata('error', $this->lang->line('not_selected_file_import'));
			redirect('dashboard/import_cost_mkt');
		} else {
			$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
				$arr_file = explode('.', $_FILES['upload_file']['name']);
				$extension = end($arr_file);

				$create_at_import = explode('-', $_FILES['upload_file']['name']);
				$create_at_import = strtotime("$create_at_import[0]-$create_at_import[1]-$create_at_import[2]");

				if ('csv' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} elseif ('xlsx' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				} else {
					$this->session->set_flashdata('error', "File không đúng định dạng");
					return redirect('dashboard/import_cost_mkt');
				}

				$spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
				$sheetData = $spreadsheet->getActiveSheet()->toArray();

				if (count($sheetData[0]) != 14) {
					$this->session->set_flashdata('error', "File import không đúng nguồn");
					return redirect('dashboard/import_cost_mkt');
				}

				$pathFile = $this->upload_file_xlsx($_FILES);
				$cost = 0;
				$data = [];
				foreach ($sheetData as $key => $value) {
					if ($key >= 1) {
						$cost += !empty($value[12]) ? trim($value[12]) : 0;
						$data['cost'] = $cost;
					}
				}

				$data['start_day'] = !empty($sheetData[1][0]) ? strtotime(trim($sheetData[1][0])) : "";
				$data['end_day'] = !empty($sheetData[1][1]) ? strtotime(trim($sheetData[1][1])) : "";
				$data['file_name'] = $_FILES['upload_file']['name'];
				$data['path'] = $pathFile['path'];
				$data['key_excel'] = $pathFile['key'];
				$data['source'] = 'facebook';
				$data['created_at'] = $create_at_import;
				$data['created_by'] = $this->userInfo['email'];

				$result = $this->api->apiPost($this->user['token'], "dashboard_telesale/importCost", $data);

				if (!empty($result) && $result->status != 200) {
					$this->session->set_flashdata('error', $result->message);
					redirect('dashboard/import_cost_mkt');
				}

				try {
					$this->session->set_flashdata('success', $this->lang->line('import_success'));
					redirect('dashboard/import_cost_mkt');
				} catch (Exception $ex) {
					$this->session->set_flashdata('error', $this->lang->line('import_failed'));
					redirect('dashboard/import_cost_mkt');
				}
			} else {
				$this->session->set_flashdata('error', $this->lang->line('type_invalid'));
				redirect('dashboard/import_cost_mkt');
			}
		}

	}

	public function importCostGoogle()
	{
		if (empty($_FILES['upload_file']['name'])) {
			$this->session->set_flashdata('error', $this->lang->line('not_selected_file_import'));
			redirect('dashboard/import_cost_mkt');
		} else {
			$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
				$arr_file = explode('.', $_FILES['upload_file']['name']);
				$extension = end($arr_file);

				$create_at_import = explode('-', $_FILES['upload_file']['name']);
				$create_at_import = strtotime("$create_at_import[0]-$create_at_import[1]-$create_at_import[2]");

				if ('csv' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} elseif ('xlsx' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				} else {
					$this->session->set_flashdata('error', "File không đúng định dạng");
					return redirect('dashboard/import_cost_mkt');
				}

				$spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
				$sheetData = $spreadsheet->getActiveSheet()->toArray();

				if (count($sheetData[0]) != 21) {
					$this->session->set_flashdata('error', "File import không đúng nguồn");
					return redirect('dashboard/import_cost_mkt');
				}

				$pathFile = $this->upload_file_xlsx($_FILES);
				$cost = 0;
				$data = [];
				foreach ($sheetData as $key => $value) {
					if ($key >= 3) {
						$cost += !empty($value[8]) ? trim($value[8]) : 0;
						$data['cost'] = $cost;
					}
				}

				$data['file_name'] = $_FILES['upload_file']['name'];
				$data['path'] = $pathFile['path'];
				$data['key_excel'] = $pathFile['key'];
				$data['source'] = 'google';
				$data['created_at'] = $create_at_import;
				$data['created_by'] = $this->userInfo['email'];

				$result = $this->api->apiPost($this->user['token'], "dashboard_telesale/importCost", $data);

				if (!empty($result) && $result->status != 200) {
					$this->session->set_flashdata('error', $result->message);
					redirect('dashboard/import_cost_mkt');
				}

				try {
					$this->session->set_flashdata('success', $this->lang->line('import_success'));
					redirect('dashboard/import_cost_mkt');
				} catch (Exception $ex) {
					$this->session->set_flashdata('error', $this->lang->line('import_failed'));
					redirect('dashboard/import_cost_mkt');
				}
			} else {
				$this->session->set_flashdata('error', $this->lang->line('type_invalid'));
				redirect('dashboard/import_cost_mkt');
			}
		}
	}

	public function importCostTiktok()
	{
		if (empty($_FILES['upload_file']['name'])) {
			$this->session->set_flashdata('error', $this->lang->line('not_selected_file_import'));
			redirect('dashboard/import_cost_mkt');
		} else {
			$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
				$arr_file = explode('.', $_FILES['upload_file']['name']);
				$extension = end($arr_file);

				$create_at_import = explode('-', $_FILES['upload_file']['name']);
				$create_at_import = strtotime("$create_at_import[0]-$create_at_import[1]-$create_at_import[2]");

				if ('csv' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} elseif ('xlsx' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				} else {
					$this->session->set_flashdata('error', "File không đúng định dạng");
					return redirect('dashboard/import_cost_mkt');
				}

				$spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
				$sheetData = $spreadsheet->getActiveSheet()->toArray();

				if (count($sheetData[0]) != 15) {
					$this->session->set_flashdata('error', "File import không đúng nguồn");
					return redirect('dashboard/import_cost_mkt');
				}

				$pathFile = $this->upload_file_xlsx($_FILES);
				$cost = 0;
				$data = [];

				foreach ($sheetData as $key => $value) {
					if($key == count($sheetData) - 1){
						continue;
					}
					if ($key >= 1) {
						$cost += !empty($value[3]) ? trim($value[3]) : 0;
						$data['cost'] = $cost;
					}

				}

				$data['file_name'] = $_FILES['upload_file']['name'];
				$data['path'] = $pathFile['path'];
				$data['key_excel'] = $pathFile['key'];
				$data['source'] = 'tiktok';
				$data['created_at'] = $create_at_import;
				$data['created_by'] = $this->userInfo['email'];

				$result = $this->api->apiPost($this->user['token'], "dashboard_telesale/importCost", $data);

				if (!empty($result) && $result->status != 200) {
					$this->session->set_flashdata('error', $result->message);
					redirect('dashboard/import_cost_mkt');
				}

				try {
					$this->session->set_flashdata('success', $this->lang->line('import_success'));
					redirect('dashboard/import_cost_mkt');
				} catch (Exception $ex) {
					$this->session->set_flashdata('error', $this->lang->line('import_failed'));
					redirect('dashboard/import_cost_mkt');
				}
			} else {
				$this->session->set_flashdata('error', $this->lang->line('type_invalid'));
				redirect('dashboard/import_cost_mkt');
			}
		}
	}

	public function importOther(){
		if (empty($_FILES['upload_file']['name'])) {
			$this->session->set_flashdata('error', $this->lang->line('not_selected_file_import'));
			redirect('dashboard/import_cost_mkt');
		} else {
			$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
				$arr_file = explode('.', $_FILES['upload_file']['name']);
				$extension = end($arr_file);

				$create_at_import = explode('-', $_FILES['upload_file']['name']);
				$create_at_import = strtotime("$create_at_import[0]-$create_at_import[1]-$create_at_import[2]");

				if ('csv' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} elseif ('xlsx' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				} else {
					$this->session->set_flashdata('error', "File không đúng định dạng");
					return redirect('dashboard/import_cost_mkt');
				}

				$spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
				$sheetData = $spreadsheet->getActiveSheet()->toArray();

				if (count($sheetData[0]) != 2) {
					$this->session->set_flashdata('error', "File import không đúng nguồn");
					return redirect('dashboard/import_cost_mkt');
				}

				$pathFile = $this->upload_file_xlsx($_FILES);
				$data = [];

				$data['cost'] = $sheetData[1][1];
				$data['file_name'] = $_FILES['upload_file']['name'];
				$data['path'] = $pathFile['path'];
				$data['key_excel'] = $pathFile['key'];
				$data['source'] = 'khac';
				$data['created_at'] = $create_at_import;
				$data['created_by'] = $this->userInfo['email'];

				$result = $this->api->apiPost($this->user['token'], "dashboard_telesale/importCost", $data);

				if (!empty($result) && $result->status != 200) {
					$this->session->set_flashdata('error', $result->message);
					redirect('dashboard/import_cost_mkt');
				}

				try {
					$this->session->set_flashdata('success', $this->lang->line('import_success'));
					redirect('dashboard/import_cost_mkt');
				} catch (Exception $ex) {
					$this->session->set_flashdata('error', $this->lang->line('import_failed'));
					redirect('dashboard/import_cost_mkt');
				}
			} else {
				$this->session->set_flashdata('error', $this->lang->line('type_invalid'));
				redirect('dashboard/import_cost_mkt');
			}
		}
	}

	public function upload_file_xlsx($file)
	{
		if ($file['upload_file']['size'] > 20000000) {
			return;
		}
		$acceptFormat = array("jpeg", "png", "jpg", "mp3", "mp4", "pdf", 'docx', 'doc', 'xlxs');
		if (in_array($file['upload_file']['type'], $acceptFormat)) {
			return;
		}

		$serviceUpload = $this->config->item("url_service_upload");
		$cfile = new CURLFile($file['upload_file']["tmp_name"], $file['upload_file']["type"], $file['upload_file']["name"]);
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
			return;
		} else {
			$response = array(
				'code' => 200,
				"msg" => "success",
				'path' => $result1->path,
				'key' => $random,
			);
			return $response;
		}
	}

	public function showUpdate_image($id)
	{
		try {
			$id = $this->security->xss_clean($id);
			$condition = array("id" => $id);
			$content = $this->api->apiPost($this->userInfo['token'], "dashboard_telesale/get_one_image", $condition);

			if (!empty($content->data->fileReturn_img)){
				$content->data->image = (array)$content->data->fileReturn_img;
			}
			if (!empty($content->data)){
				$arr = [];
				foreach ((array)$content->data->fileReturn_img as $value) {
					array_push($arr, $value);
				}
			}
			$content->data->image = $arr;

			$this->pushJson('200', json_encode(array("code" => "200", "data" => $content->data)));
		} catch (\Exception $exception) {
			show_404();
		}
	}

	public function update_image_cost(){

		$data = $this->input->post();
		$data['id'] = $this->security->xss_clean($data['id']);

		$data['fileReturn_img'] = $this->security->xss_clean($data['fileReturn_img']);

		$sendApi = array(
			"id" => $data['id'],
			'fileReturn_img' => $data['fileReturn_img'],
			"created_by" => $this->userInfo,
		);

		$return = $this->api->apiPost($this->userInfo['token'], "dashboard_telesale/update_image_cost", $sendApi);

		if (!empty($return) && $return->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200", "data" => $return)));
		} else {

			$msg = !empty($return->data->message) ? $return->data->message : $return->message;
			$this->pushJson('200', json_encode(array("code" => "200", "data" => array("status" => "400", "message" => $msg, "return" => $return))));

		}

	}

	private function pushJson($code, $data) {
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}

	public function listHistory(){

		$data = [];
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		if (!empty($fdate)) {
			$data['fdate'] = $fdate;
		}
		if (!empty($tdate)) {
			$data['tdate'] = $tdate;
		}

		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$countFileReturn = $this->api->apiPost($this->userInfo['token'], "dashboard_telesale/count_list_import_cost", $data);

		$count = (int)$countFileReturn->data;

		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('dashboard/listHistory');
		$config['total_rows'] = $count;
		$config['per_page'] = 15;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $count;
		$data["per_page"] = $config['per_page'];
		$data["uriSegment"] = $config['uri_segment'];

		$getDataCost = $this->api->apiPost($this->user['token'], "dashboard_telesale/get_list_import_cost", $data);
		if (!empty($getDataCost->status) && $getDataCost->status == 200) {
			$this->data['getDataCost'] = $getDataCost->data;
		} else {
			$this->data['getDataCost'] = array();
		}

		$this->data['template'] = 'page/dashboard_telesale/lisHistoryCost.php';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);

	}


}

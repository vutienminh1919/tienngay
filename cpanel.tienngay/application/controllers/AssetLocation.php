<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AssetLocation extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url', 'file'));
		$this->load->model("time_model");
		$this->load->library('pagination');
		$this->load->helper('lead_helper');
		$this->config->load('config');
		$this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
		$this->spreadsheet = new Spreadsheet();
		$this->spreadsheet->setActiveSheetIndex(0);

		$this->sheet = $this->spreadsheet->getActiveSheet();
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	public function business()
	{
		$data = [];
		$data['start'] = !empty($_GET['start']) ? $_GET['start'] : "";
		$data['end'] = !empty($_GET['end']) ? $_GET['end'] : "";
		$data['code_contract_disbursement'] = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$data['customer_name'] = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$data['seri'] = !empty($_GET['seri']) ? $_GET['seri'] : "";
		$data['license'] = !empty($_GET['license']) ? $_GET['license'] : "";
		$data['location'] = !empty($_GET['location']) ? $_GET['location'] : "";
		$data['alarm'] = !empty($_GET['alarm']) ? $_GET['alarm'] : "";
		$data['email'] = !empty($_GET['email']) ? $_GET['email'] : "";
		$data['type_query'] = 'get';
		$data['store'] = !empty($_GET['store']) ? $_GET['store'] : "";
		$data['check'] = !empty($_GET['check']) ? $_GET['check'] : "";
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('assetLocation/business?fdate=' . $data['start'] . '&end=' . $data['end'] . '&code_contract_disbursement=' . $data['code_contract_disbursement'] . '&customer_name=' . $data['customer_name'] . '&seri=' . $data['seri'] . '&license=' . $data['license'] . '&location=' . $data['location'] . '&alarm=' . $data['alarm'] . '&email=' . $data['email'] . '&store=' . $data['store'] . '&check=' . $data['check']);
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 20;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;

		$data['limit'] = $config['per_page'];
		$data['offset'] = $config['uri_segment'];
		$response = $this->api->api_core_Post($this->user['token'], "assetLocation/contract/asset_by_user_business", $data);
		if (!empty($response->status) && $response->status == 200) {
			$this->data['contracts'] = $response->data->contract;
			$config['total_rows'] = $response->data->total;
			$this->data['total_active'] = $response->data->active;
			$this->data['total_deactive'] = $response->data->deactive;
			$this->data['total_rows'] = $response->data->total;
			$this->data['REMOVE'] = $response->data->REMOVE;
			$this->data['FENCEOUT'] = $response->data->FENCEOUT;
			$this->data['CRASH'] = $response->data->CRASH;
			$this->data['LOWVOT'] = $response->data->LOWVOT;
			$this->data['REMOVECONTINUOUSLY'] = $response->data->REMOVECONTINUOUSLY;
		} else {
			$this->data['contracts'] = array();
		}
		$stores = $this->api->api_core_Post($this->user['token'], "assetLocation/contract/get_store_by_asm");
		if (!empty($stores->status) && $stores->status == 200) {
			$this->data['stores'] = $stores->data;
		} else {
			$this->data['stores'] = [];
		}

		$city = $this->api->api_core_Post($this->user['token'], "assetLocation/address/city");
		if (!empty($city->status) && $city->status == 200) {
			$this->data['cities'] = $city->data;
		} else {
			$this->data['cities'] = [];
		}
		$groupRoles = $this->api->apiPost($this->session->userdata('user')['token'], "groupRole/getGroupRole", array("user_id" => $this->session->userdata('user')['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['group_role'] = $groupRoles->data;
			if (in_array('giao-dich-vien', $groupRoles->data) && !in_array('cua-hang-truong', $groupRoles->data)) {
				$this->data["pageName"] = 'Quản lý thiết bị định vị CVKD';
				$this->data['template'] = 'page/asset_location/business/cvkd';
			} elseif (in_array('cua-hang-truong', $groupRoles->data) && !in_array('quan-ly-khu-vuc', $groupRoles->data)) {
				$this->data["pageName"] = 'Quản lý thiết bị định vị TPGD';
				$this->data['template'] = 'page/asset_location/business/cht';
			} elseif (in_array('quan-ly-khu-vuc', $groupRoles->data)) {
				$this->data["pageName"] = 'Quản lý thiết bị định vị ASM/RSM';
				$this->data['template'] = 'page/asset_location/business/asm_asset';
			} elseif (in_array('van-hanh', $groupRoles->data)) {
				$this->data["pageName"] = 'Quản lý thiết bị định vị ASM/RSM';
				$this->data['template'] = 'page/asset_location/business/asm_asset';
			} elseif (in_array('ke-toan', $groupRoles->data)) {
				$this->data["pageName"] = 'Quản lý thiết bị định vị ASM/RSM';
				$this->data['template'] = 'page/asset_location/business/asm_asset';
			} else {
				redirect(base_url('app'));
			}
		} else {
			$this->data['group_role'] = [];
		}

		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function detail()
	{
		$seri = $_GET['seri'] ?? "";
		$response = $this->api->api_core_Post($this->user['token'], "assetLocation/device/detail", ['seri' => $seri]);
		if (!empty($response->status) && $response->status == 200) {
			$this->data['device'] = $response->data->device;
			$this->data['log_contract'] = $response->data->log_contract;
		} else {
			$this->data['device'] = [];
			$this->data['log_contract'] = [];
		}
		$this->data['template'] = 'page/asset_location/detail';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function import()
	{
		$warehouses = $this->api->api_core_Post($this->user['token'], "assetLocation/warehouse/list");
		if (!empty($warehouses->status) && $warehouses->status == 200) {
			$this->data['warehouses'] = $warehouses->data;
		} else {
			$this->data['warehouses'] = [];
		}

		$partners = $this->api->api_core_Post($this->user['token'], "assetLocation/partner/list");
		if (!empty($partners->status) && $partners->status == 200) {
			$this->data['partners'] = $partners->data;
		} else {
			$this->data['partners'] = [];
		}
		$this->data['template'] = 'page/asset_location/import';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function importAssetLocation()
	{
		if (empty($_FILES['upload_file'])) {
			$response = [
				'status' => 400,
				'message' => $this->lang->line('not_selected_file_import')
			];
			echo json_encode($response);
			return;
		} else {
			$partner = $_POST['partner'] ?? "";
			$type = $_POST['type'] ?? "";
			$warehouse_import = $_POST['warehouse_import'] ?? "";
			$warehouse_export = $_POST['warehouse_export'] ?? "";
			$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
				$arr_file = explode('.', $_FILES['upload_file']['name']);
				$extension = end($arr_file);
				if ('csv' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}
				$spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
				$sheetData = $spreadsheet->getActiveSheet()->toArray();
				$check = $this->validate_import($sheetData);
				if (count($check) > 0) {
					$response = [
						'status' => 400,
						'message' => $check[0]
					];
					echo json_encode($response);
					return;
				}
				$listFail = [];
				$total_import = 0;
				foreach ($sheetData as $key => $value) {
					if (empty($value[0]) && empty($value[1]) && empty($value[2]) && empty($value[3])) continue;
					if ($key >= 1) {
						$total_import++;
						$data = array(
							'key' => ++$key,
							"date_import" => !empty($value[0]) ? (trim($value[0])) : "",
							"seri" => !empty(trim($value[1])) ? (trim($value[1])) : "",
							"price" => !empty(trim($value[2])) ? (trim($value[2])) : "",
							"fees" => !empty(trim($value[3])) ? (trim($value[3])) : "",
							"number_sim" => !empty(trim($value[4])) ? (trim($value[4])) : "",
							"type" => $type,
							"warehouse_export" => $warehouse_export,
							"warehouse_import" => $warehouse_import,
							"partner" => $partner,
						);
						if ($type == 1) {
							$return = $this->api->api_core_Post($this->user['token'], "assetLocation/device/check_import_device", $data);
						} elseif ($type == 2) {
							$return = $this->api->api_core_Post($this->user['token'], "assetLocation/device/check_transfer", $data);
						}
						if (!empty($return->data)) {
							$push = [
								'key' => $return->data,
								'message' => $return->message
							];
							array_push($listFail, $push);
						}
					}
				}
				if (count($listFail) > 0) {
					$response = [
						'status' => 200,
						'message' => 'Danh sách import chưa đúng, vui lòng chỉnh sửa lại',
						'data' => $listFail,
					];
					echo json_encode($response);
					return;
				} else {
					$stock_price = 0;
					if ($type == 1) {
						$total_price = array_sum(array_column($sheetData, 2));
						$res = $this->api->api_core_Post($this->user['token'], "assetLocation/device/calculate_stock_price", ['total_import_new' => $total_import, 'total_price_import_new' => $total_price, 'warehouse_import' => $warehouse_import]);


						if (!empty($res->status) && $res->status == 200) {
							$stock_price = $res->data->stock_price;
							$total_new_stock = $res->data->total_new_stock;
							$stock_price_old = $res->data->stock_price_old;
							$total_all_new_stock = $res->data->total_all_new_stock;
						} else {
							$response = [
								'status' => 400,
								'message' => "Tính giá tồn không thành công"
							];
							echo json_encode($response);
							return;
						}
					}
					foreach ($sheetData as $key => $value) {
						if (empty($value[0]) && empty($value[1]) && empty($value[2]) && empty($value[3])) continue;
						if ($key >= 1) {
							$data = array(
								'key' => ++$key,
								"date_import" => !empty($value[0]) ? (trim($value[0])) : "",
								"seri" => !empty(trim($value[1])) ? (trim($value[1])) : "",
								"price" => !empty(trim($value[2])) ? (trim($value[2])) : "",
								"fees" => !empty(trim($value[3])) ? (trim($value[3])) : "",
								"number_sim" => !empty(trim($value[4])) ? (trim($value[4])) : "",
								"type" => $type,
								"warehouse_export" => $warehouse_export,
								"warehouse_import" => $warehouse_import,
								"partner" => $partner,
								"stock_price" => $stock_price,
								"total_new_stock" => $total_new_stock,
								"stock_price_old" => $stock_price_old,
								"total_all_new_stock" => $total_all_new_stock,
								'last' => $total_import + 1
							);
							if ($type == 1) {
								$return = $this->api->api_core_Post($this->user['token'], "assetLocation/device/import_device", $data);
							} elseif ($type == 2) {
								$return = $this->api->api_core_Post($this->user['token'], "assetLocation/device/transfer", $data);
							} elseif ($type == 3) {
								$return = $this->api->api_core_Post($this->user['token'], "assetLocation/device/import_old", $data);
							}
						}
					}
					$response = [
						'status' => 200,
						'message' => 'success',
						'data' => []
					];
					echo json_encode($response);
					return;
				}
			}
		}
	}

	public function location()
	{
		$imei = $_GET['imei'] ?? "";
		$res = $this->api->api_core_Post($this->user['token'], "assetLocation/device/location", ['imei' => $imei]);
		if (!empty($res->status) && $res->status == 200) {
			$response = [
				'status' => 200,
				'message' => 'success',
				'data' => $res->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'status' => 400,
				'message' => 'fail',
			];
			echo json_encode($response);
			return;
		}
	}

	public function recall()
	{
		$code_contract = $_GET['code_contract'] ?? "";
		$res = $this->api->api_core_Post($this->user['token'], "assetLocation/contract/recall_device", ['code_contract' => $code_contract]);
		if (!empty($res->status) && $res->status == 200) {
			$response = [
				'status' => 200,
				'message' => 'success',
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'status' => 400,
				'message' => !empty($res->message) ? $res->message : 'Thất bại',
			];
			echo json_encode($response);
			return;
		}
	}

	public function business_asm()
	{
		$data = [];
		$data['start'] = !empty($_GET['start']) ? $_GET['start'] : "";
		$data['end'] = !empty($_GET['end']) ? $_GET['end'] : "";
		$data['code_contract_disbursement'] = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$data['customer_name'] = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$data['seri'] = !empty($_GET['seri']) ? $_GET['seri'] : "";
		$data['license'] = !empty($_GET['license']) ? $_GET['license'] : "";
		$data['location'] = !empty($_GET['location']) ? $_GET['location'] : "";
		$data['alarm'] = !empty($_GET['alarm']) ? $_GET['alarm'] : "";
		$data['email'] = !empty($_GET['email']) ? $_GET['email'] : "";
		$data['type_query'] = 'get';
		$data['store'] = !empty($_GET['store']) ? $_GET['store'] : "";
		$data['check'] = !empty($_GET['check']) ? $_GET['check'] : "";
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('assetLocation/business?fdate=' . $data['start'] . '&end=' . $data['end'] . '&code_contract_disbursement=' . $data['code_contract_disbursement'] . '&customer_name=' . $data['customer_name'] . '&seri=' . $data['seri'] . '&license=' . $data['license'] . '&location=' . $data['location'] . '&alarm=' . $data['alarm'] . '&email=' . $data['email'] . '&store=' . $data['store'] . '&check=' . $data['check']);
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 20;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;

		$data['limit'] = $config['per_page'];
		$data['offset'] = $config['uri_segment'];

		$groupRoles = $this->api->apiPost($this->session->userdata('user')['token'], "groupRole/getGroupRole", array("user_id" => $this->session->userdata('user')['id']));
		$response = $this->api->api_core_Post($this->user['token'], "assetLocation/contract/asset_by_asm_business", $data);
		if (!empty($response->status) && $response->status == 200) {
			$this->data['stores'] = $response->data->store;
			$this->data['total'] = $response->data->total;
		} else {
			$this->data['stores'] = array();
			$this->data['total'] = array();
		}
		if (in_array('quan-ly-khu-vuc', $groupRoles->data)) {
			$this->data['template'] = 'page/asset_location/business/asm';
		} elseif (in_array('van-hanh', $groupRoles->data)) {
			$this->data['template'] = 'page/asset_location/business/asm';
		} else {
			redirect(base_url('app'));
		}

		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function check_importAssetLocation()
	{
		$partner = $_POST['partner'] ?? "";
		$type = $_POST['type'] ?? "";
		$warehouse_import = $_POST['warehouse_import'] ?? "";
		$warehouse_export = $_POST['warehouse_export'] ?? "";
		if (empty($_FILES['upload_file'])) {
			$response = [
				'status' => 400,
				'message' => $this->lang->line('not_selected_file_import')
			];
			echo json_encode($response);
			return;
		}

		if (empty($warehouse_import)) {
			$response = [
				'status' => 400,
				'message' => "Kho nhập không để trống"
			];
			echo json_encode($response);
			return;
		}

		if (empty($type)) {
			$response = [
				'status' => 400,
				'message' => "Loại giao dịch không để trống"
			];
			echo json_encode($response);
			return;
		} else {
			if ($type == 2) {
				if (empty($warehouse_export)) {
					$response = [
						'status' => 400,
						'message' => "Kho xuất không để trống"
					];
					echo json_encode($response);
					return;
				}
			} else {
				if (empty($partner)) {
					$response = [
						'status' => 400,
						'message' => "Đối tác không để trống"
					];
					echo json_encode($response);
					return;
				}
			}
		}

		$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
			$arr_file = explode('.', $_FILES['upload_file']['name']);
			$extension = end($arr_file);
			if ('csv' == $extension) {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			} else {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}
			$spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
			$sheetData = $spreadsheet->getActiveSheet()->toArray();
			$check = $this->validate_import($sheetData);
			if (count($check) > 0) {
				$response = [
					'status' => 400,
					'message' => $check[0]
				];
				echo json_encode($response);
				return;
			}
			$listFail = [];
			$total_import = 0;
			foreach ($sheetData as $key => $value) {
				if (empty($value[0]) && empty($value[1]) && empty($value[2]) && empty($value[3])) continue;
				if ($key >= 1) {
					$total_import++;
					$data = array(
						'key' => ++$key,
						"date_import" => !empty($value[0]) ? (trim($value[0])) : "",
						"seri" => !empty(trim($value[1])) ? (trim($value[1])) : "",
						"price" => !empty(trim($value[2])) ? (trim($value[2])) : "",
						"fees" => !empty(trim($value[3])) ? (trim($value[3])) : "",
						"number_sim" => !empty(trim($value[4])) ? (trim($value[4])) : "",
						"type" => $type,
						"warehouse_export" => $warehouse_export,
						"warehouse_import" => $warehouse_import,
						"partner" => $partner,
					);
					if ($type == 1) {
						$return = $this->api->api_core_Post($this->user['token'], "assetLocation/device/check_import_device", $data);
					} elseif ($type == 2) {
						$return = $this->api->api_core_Post($this->user['token'], "assetLocation/device/check_transfer", $data);
					} elseif ($type == 3) {
						$return = $this->api->api_core_Post($this->user['token'], "assetLocation/device/check_import_old", $data);
					}
					if (!empty($return->data)) {
						$push = [
							'key' => $return->data,
							'message' => $return->message
						];
						array_push($listFail, $push);
					}
				}
			}
			if (count($listFail) > 0) {
				$response = [
					'status' => 200,
					'message' => 'Danh sách import chưa đúng, vui lòng chỉnh sửa lại',
					'data' => $listFail,
				];
				echo json_encode($response);
				return;
			} else {
				if ($type == 1) {
					$total_price = array_sum(array_column($sheetData, 2));
					$res = $this->api->api_core_Post($this->user['token'], "assetLocation/device/calculate_stock_price", ['total_import_new' => $total_import, 'total_price_import_new' => $total_price, 'warehouse_import' => $warehouse_import]);

					$stock_price = 0;
					if (!empty($res->status) && $res->status == 200) {
						$stock_price = $res->data->stock_price;
						$total_new_stock = $res->data->total_new_stock;
						$stock_price_old = $res->data->stock_price_old;
						$total_all_new_stock = $res->data->total_all_new_stock;
						$response = [
							'status' => 200,
							'message' => "Tính giá tồn thành công",
							'stock_price' => number_format($stock_price),
							'total_new_stock' => number_format($total_new_stock),
							'stock_price_old' => number_format($stock_price_old),
							'total_all_new_stock' => number_format($total_all_new_stock),
							'total_import' => number_format($total_import),
							'total_price' => number_format($total_price),
							'data' => $listFail,
						];
						echo json_encode($response);
						return;
					} else {
						$response = [
							'status' => 400,
							'message' => "Tính giá tồn không thành công",
							'stock_price' => $stock_price,
							'data' => $listFail,
						];
						echo json_encode($response);
						return;
					}
				} elseif ($type == 2) {
					$response = [
						'status' => 200,
						'message' => "Thành công",
						'data' => $listFail,
					];
					echo json_encode($response);
					return;
				} elseif ($type == 3) {
					$response = [
						'status' => 200,
						'message' => "Thành công",
						'data' => $listFail,
					];
					echo json_encode($response);
					return;
				}
			}
		}

	}

	public function warehouse_manager()
	{
		$month = !empty($_GET['month']) ? $_GET['month'] : date('Y-m');

		$report_all = $this->api->api_core_Post($this->user['token'], "assetLocation/warehouse/report_all", ['month' => $month]);
		if (!empty($report_all->status) && $report_all->status == 200) {
			$this->data['report_all'] = $report_all->data;
		} else {
			$this->data['report_all'] = array();
		}

		$report_partial_ho = $this->api->api_core_Post($this->user['token'], "assetLocation/warehouse/report_partial", ['month' => $month, 'level' => 1]);
		if (!empty($report_partial_ho->status) && $report_partial_ho->status == 200) {
			$this->data['report_partial_ho'] = $report_partial_ho->data;

		} else {
			$this->data['report_partial_ho'] = array();
		}

		$report_partial_pgd = $this->api->api_core_Post($this->user['token'], "assetLocation/warehouse/report_partial", ['month' => $month, 'level' => 3]);
		if (!empty($report_partial_pgd->status) && $report_partial_pgd->status == 200) {
			$this->data['report_partial_pgd'] = $report_partial_pgd->data;

		} else {
			$this->data['report_partial_pgd'] = array();
		}

		$this->data["pageName"] = 'Quản lý chi tiết xuất nhập tồn - Thiết bị định vị';
		$this->data['template'] = 'page/asset_location/warehouse/manager';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function district()
	{
		$district = $this->api->api_core_Post($this->user['token'], "assetLocation/address/district", ['district' => $_GET['code']]);
		if (!empty($district->status) && $district->status == 200) {
			$response = [
				'status' => 200,
				'message' => "Thành công",
				'data' => $district->data,
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'status' => 400,
				'message' => "Thất bại",
			];
			echo json_encode($response);
			return;
		}
	}

	public function ward()
	{
		$ward = $this->api->api_core_Post($this->user['token'], "assetLocation/address/ward", ['ward' => $_GET['code']]);
		if (!empty($ward->status) && $ward->status == 200) {
			$response = [
				'status' => 200,
				'message' => "Thành công",
				'data' => $ward->data,
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'status' => 400,
				'message' => "Thất bại",
			];
			echo json_encode($response);
			return;
		}
	}

	public function update_address_contract()
	{
		$data = [];
		$data['code_contract'] = $_POST['code_contract'] ?? "";
		$data['province'] = $_POST['province'] ?? "";
		$data['district'] = $_POST['district'] ?? "";
		$data['ward'] = $_POST['ward'] ?? "";
		$data['current_stay'] = $_POST['current_stay'] ?? "";
		$res = $this->api->api_core_Post($this->user['token'], "assetLocation/contract/update_address_contract", $data);
		if (!empty($res->status) && $res->status == 200) {
			$response = [
				'status' => 200,
				'message' => 'success',
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'status' => 400,
				'message' => !empty($res->message) ? $res->message : 'Thất bại',
			];
			echo json_encode($response);
			return;
		}
	}

	public function update_note_contract()
	{
		$data = [];
		$data['code_contract'] = $_POST['code_contract'] ?? "";
		$data['note'] = $_POST['note'] ?? "";
		$res = $this->api->api_core_Post($this->user['token'], "assetLocation/contract/update_note_contract", $data);
		if (!empty($res->status) && $res->status == 200) {
			$response = [
				'status' => 200,
				'message' => 'success',
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'status' => 400,
				'message' => !empty($res->message) ? $res->message : 'Thất bại',
			];
			echo json_encode($response);
			return;
		}
	}

	public function warehouse_local()
	{
		$total = $this->api->api_core_Post($this->user['token'], "assetLocation/warehouse/view_all");
		if (!empty($total->status) && $total->status == 200) {
			$this->data['total'] = $total->data;
		} else {
			$this->data['total'] = [];
		}

		$data = $this->api->api_core_Post($this->user['token'], "assetLocation/warehouse/warehouse_local");
		if (!empty($data->status) && $data->status == 200) {
			$this->data['warehouses'] = $data->data;
		} else {
			$this->data['warehouses'] = [];
		}
		$this->data["pageName"] = 'Quản lý Kho - Thiết bị định vị';
		$this->data['template'] = 'page/asset_location/warehouse/local';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function warehouse_detail($id)
	{
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('assetLocation/detail/' . $id);
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 30;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;

		$data['limit'] = $config['per_page'];
		$data['offset'] = $config['uri_segment'];
		$data['id'] = $id;
		$result = $this->api->api_core_Post($this->user['token'], "assetLocation/warehouse/detail", ['id' => $id]);
		if (!empty($result->status) && $result->status == 200) {
			$this->data['warehouse'] = $result->data->warehouse;
			$this->data['devices'] = $result->data->devices;
		} else {
			$this->data['warehouse'] = [];
			$this->data['devices'] = [];
		}
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data["pageName"] = 'Chi tiết kho';
		$this->data['template'] = 'page/asset_location/warehouse/detail';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function history()
	{
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('assetLocation/history');
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 30;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;

		$data['limit'] = $config['per_page'];
		$data['offset'] = $config['uri_segment'];
		$data['type_query'] = 'get';
		$result = $this->api->api_core_Post($this->user['token'], "assetLocation/warehouse/history", $data);
		if (!empty($result->status) && $result->status == 200) {
			$this->data['history'] = $result->data->history;
			$config['total_rows'] = $result->data->total;
			$this->data['total_rows'] = $result->data->total;
		} else {
			$this->data['history'] = [];
			$this->data['total_rows'] = [];
		}
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data["pageName"] = 'Chi tiết xuất nhập tồn';
		$this->data['template'] = 'page/asset_location/warehouse/history';
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function example_import()
	{
		$this->sheet->setCellValue('A1', 'Ngày nhập');
		$this->sheet->setCellValue('B1', 'Seri');
		$this->sheet->setCellValue('C1', 'Giá tiền');
		$this->sheet->setCellValue('D1', 'Chi phí sim');
		$this->sheet->setCellValue('E1', 'Số sim');
		$this->callLibExcel('mau-import-thiet-bi-dinh-vi' . time() . '.xlsx');
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

	public function validate_import($sheetData)
	{
		$message = [];
		if (stripos("ngay-nhap", slugify(trim($sheetData[0][0]))) === false) {
			$message[] = "Tên ô A định dạng bắt buộc là Ngày nhập";
		}
		if (stripos("seri", slugify(trim($sheetData[0][1]))) === false) {
			$message[] = "Tên ô B định dạng bắt buộc là Seri";
		}
		if (stripos("gia-tien", slugify(trim($sheetData[0][2]))) === false) {
			$message[] = "Tên ô C định dạng bắt buộc là Giá tiền";
		}
		if (stripos("chi-phi-sim", slugify(trim($sheetData[0][3]))) === false) {
			$message[] = "Tên ô D định dạng bắt buộc là Chi phí sim";
		}
		if (stripos("so-sim", slugify(trim($sheetData[0][4]))) === false) {
			$message[] = "Tên ô E định dạng bắt buộc là Số sim";
		}
		return $message;
	}

	public function all_device()
	{
		$data = [];
		$devices = $this->api->api_core_Post($this->userInfo['token'], "assetLocation/device/all_device", $data);
		if (!empty($devices->data)) {
			$this->export_all_device($devices->data);
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	public function export_all_device($devices)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Seri');
		$this->sheet->setCellValue('C1', 'Giá trị thiết bị');
		$this->sheet->setCellValue('D1', 'Phí sim');
		$this->sheet->setCellValue('E1', 'Số HĐ đang SD');
		$this->sheet->setCellValue('F1', 'Ngày giải ngân');
		$this->sheet->setCellValue('G1', 'Biển số xe');
		$this->sheet->setCellValue('H1', 'Tên khách hàng');
		$this->sheet->setCellValue('I1', 'NCC');
		$this->sheet->setCellValue('J1', 'Phòng giao dịch');
		$this->sheet->setCellValue('K1', 'Trạng thái');

		$i = 2;
		foreach ($devices as $key => $device) {
			$this->sheet->setCellValue('A' . $i, ++$key);
			$this->sheet->setCellValue('B' . $i, !empty($device->code) ? $device->code . " " : "");
			$this->sheet->setCellValue('C' . $i, !empty($device->stock_price) ? number_format($device->stock_price) : "");
			$this->sheet->setCellValue('D' . $i, !empty($device->sim_card_fee) ? number_format($device->sim_card_fee) : "");
			$this->sheet->setCellValue('E' . $i, !empty($device->contract) ? $device->contract->code_contract_disbursement : "");
			$this->sheet->setCellValue('F' . $i, !empty($device->contract) ? date('d-m-Y', $device->contract->disbursement_date) : "");
			$this->sheet->setCellValue('G' . $i, !empty($device->contract) ? $device->contract->property_infor[2]->value : "");
			$this->sheet->setCellValue('H' . $i, !empty($device->contract) ? $device->contract->customer_infor->customer_name : "");
			$this->sheet->setCellValue('I' . $i, !empty($device->partner_asset_location->name) ? $device->partner_asset_location->name : "");
			$this->sheet->setCellValue('J' . $i, !empty($device->warehouse_asset_location->name) ? $device->warehouse_asset_location->name : "");
			$this->sheet->setCellValue('K' . $i, !empty($device->status) ? status_device($device->status) : "");
			$i++;
		}
		$this->callLibExcel('danh-sach-thiet-bi-dinh-vi-' . time() . '.csv');
	}

	public function excel_history()
	{
		$data = [];
		$data['type_query'] = 'excel';
		$response = $this->api->api_core_Post($this->userInfo['token'], "assetLocation/warehouse/history", $data);
		if (!empty($response->data->history)) {
			$this->export_history($response->data->history);
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	public function export_history($history)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Ngày giao dịch');
		$this->sheet->setCellValue('C1', 'Tên NCC');
		$this->sheet->setCellValue('D1', 'Tên kho');
		$this->sheet->setCellValue('E1', 'Loại giao dịch');
		$this->sheet->setCellValue('F1', 'SL nhập');
		$this->sheet->setCellValue('G1', 'Đơn giá nhập');
		$this->sheet->setCellValue('H1', 'SL xuất');
		$this->sheet->setCellValue('I1', 'Đơn giá xuất');
		$this->sheet->setCellValue('J1', 'SL chuyển');
		$this->sheet->setCellValue('K1', 'Đơn giá chuyển');
		$this->sheet->setCellValue('L1', 'SL nhận');
		$this->sheet->setCellValue('M1', 'Đơn giá nhận');
		$this->sheet->setCellValue('N1', 'SL tồn trước');
		$this->sheet->setCellValue('O1', 'Đơn giá tồn trước');
		$this->sheet->setCellValue('P1', 'SL tồn sau');
		$this->sheet->setCellValue('Q1', 'Đơn giá tồn sau');
		$this->sheet->setCellValue('R1', 'Mã hợp đồng');
		$this->sheet->setCellValue('S1', 'Imei');

		$i = 2;
		foreach ($history as $key => $value) {
			$this->sheet->setCellValue('A' . $i, ++$key);
			$this->sheet->setCellValue('B' . $i, date('d/m/Y', $value->created_at));
			$this->sheet->setCellValue('C' . $i, !empty($value->partner->name) ? $value->partner->name : '');
			$this->sheet->setCellValue('D' . $i, $value->warehouse->name);
			$this->sheet->setCellValue('E' . $i, type_xuat_nhap_ton($value->type));
			$this->sheet->setCellValue('F' . $i, $value->so_luong_nhap ?? 0);
			$this->sheet->setCellValue('G' . $i, !empty($value->don_gia_nhap) ? number_format($value->don_gia_nhap) : 0);
			$this->sheet->setCellValue('H' . $i, $value->so_luong_xuat ?? 0);
			$this->sheet->setCellValue('I' . $i, !empty($value->don_gia_xuat) ? number_format($value->don_gia_xuat) : 0);
			$this->sheet->setCellValue('J' . $i, $value->so_luong_chuyen ?? 0);
			$this->sheet->setCellValue('K' . $i, !empty($value->don_gia_chuyen) ? number_format($value->don_gia_chuyen) : 0);
			$this->sheet->setCellValue('L' . $i, $value->so_luong_nhan ?? 0);
			$this->sheet->setCellValue('M' . $i, !empty($value->don_gia_nhan) ? number_format($value->don_gia_nhan) : 0);
			$this->sheet->setCellValue('N' . $i, $value->so_luong_ton ?? 0);
			$this->sheet->setCellValue('O' . $i, !empty($value->don_gia_ton) ? number_format($value->don_gia_ton) : 0);
			$this->sheet->setCellValue('P' . $i, $value->so_luong_ton_moi ?? 0);
			$this->sheet->setCellValue('Q' . $i, !empty($value->don_gia_ton_moi) ? number_format($value->don_gia_ton_moi) : 0);
			$this->sheet->setCellValue('R' . $i, !empty($value->code_contract_disbursement) ? ($value->code_contract_disbursement) : '');
			$this->sheet->setCellValue('S' . $i, !empty($value->imei) ? ($value->imei) . " " : '');
			$i++;
		}
		$this->callLibExcel('chi-tiet-xuat-nhap-ton-' . time() . '.xlsx');
	}

	public function excel_warehouse_manager()
	{
		$month = !empty($_GET['month']) ? $_GET['month'] : date('Y-m');
		$type_excel = !empty($_GET['type_excel']) ? $_GET['type_excel'] : 'ho';
		if ($type_excel == 'ho') {
			$report_partial_ho = $this->api->api_core_Post($this->user['token'], "assetLocation/warehouse/report_partial", ['month' => $month, 'level' => 1]);
			if (!empty($report_partial_ho->data)) {
				$this->export_warehouse_manager($report_partial_ho->data);
			} else {
				$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
			}
		} else {
			$report_partial_pgd = $this->api->api_core_Post($this->user['token'], "assetLocation/warehouse/report_partial", ['month' => $month, 'level' => 3]);
			if (!empty($report_partial_pgd->data)) {
				$this->export_warehouse_manager($report_partial_pgd->data);
			} else {
				$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
			}
		}
	}

	public function export_warehouse_manager($report_partial)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Tên Kho');
		$this->sheet->setCellValue('C1', 'SL tồn đầu');
		$this->sheet->setCellValue('D1', 'Giá trị tồn đầu');
		$this->sheet->setCellValue('E1', 'SL nhập');
		$this->sheet->setCellValue('F1', 'Giá trị nhập');
		$this->sheet->setCellValue('G1', 'SL xuất');
		$this->sheet->setCellValue('H1', 'Giá trị xuất');
		$this->sheet->setCellValue('I1', 'SL tồn cuối');
		$this->sheet->setCellValue('J1', 'Giá trị tồn cuối');

		$i = 2;
		foreach ($report_partial as $key => $value) {
			$this->sheet->setCellValue('A' . $i, ++$key);
			$this->sheet->setCellValue('B' . $i, !empty($value->name) ? $value->name : '');
			$this->sheet->setCellValue('C' . $i, !empty($value->report) ? $value->report->so_luong_ton_dau_thang : 0);
			$this->sheet->setCellValue('D' . $i, !empty($value->report) ? number_format($value->report->tong_tien_ton_dau_thang) : 0);
			$this->sheet->setCellValue('E' . $i, !empty($value->report) ? $value->report->so_luong_nhap : 0);
			$this->sheet->setCellValue('F' . $i, !empty($value->report) ? number_format($value->report->tong_tien_nhap) : 0);
			$this->sheet->setCellValue('G' . $i, !empty($value->report) ? $value->report->so_luong_xuat : 0);
			$this->sheet->setCellValue('H' . $i, !empty($value->report) ? number_format($value->report->tong_tien_xuat) : 0);
			$this->sheet->setCellValue('I' . $i, !empty($value->report) ? $value->report->so_luong_ton_cuoi_thang : 0);
			$this->sheet->setCellValue('J' . $i, !empty($value->report) ? number_format($value->report->tong_tien_ton_cuoi_thang) : 0);
			$i++;
		}
		$this->callLibExcel('report-warehouse' . time() . '.xlsx');
	}

	public function collection()
	{
		$data = [];
		$data['start'] = !empty($_GET['start']) ? $_GET['start'] : "";
		$data['end'] = !empty($_GET['end']) ? $_GET['end'] : "";
		$data['code_contract_disbursement'] = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$data['customer_name'] = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$data['seri'] = !empty($_GET['seri']) ? $_GET['seri'] : "";
		$data['license'] = !empty($_GET['license']) ? $_GET['license'] : "";
		$data['location'] = !empty($_GET['location']) ? $_GET['location'] : "";
		$data['alarm'] = !empty($_GET['alarm']) ? $_GET['alarm'] : "";
		$data['email'] = !empty($_GET['email']) ? $_GET['email'] : "";
		$data['type_query'] = 'get';
		$data['store'] = !empty($_GET['store']) ? $_GET['store'] : "";
		$data['status'] = !empty($_GET['status']) ? $_GET['status'] : "";
		$data['check'] = !empty($_GET['check']) ? $_GET['check'] : "";
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('assetLocation/collection?fdate=' . $data['start'] . '&end=' . $data['end'] . '&code_contract_disbursement=' . $data['code_contract_disbursement'] . '&customer_name=' . $data['customer_name'] . '&seri=' . $data['seri'] . '&license=' . $data['license'] . '&location=' . $data['location'] . '&alarm=' . $data['alarm'] . '&email=' . $data['email'] . '&store=' . $data['store'] . '&check=' . $data['check'] . '&status=' . $data['status']);
		$config['uri_segment'] = $uriSegment;
		$config['per_page'] = 20;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;

		$data['limit'] = $config['per_page'];
		$data['offset'] = $config['uri_segment'];
		$response = $this->api->api_core_Post($this->user['token'], "assetLocation/contract/contract_by_collection", $data);

		if (!empty($response->status) && $response->status == 200) {
			$this->data['contracts'] = $response->data->contracts;
			$config['total_rows'] = $response->data->total;
			$this->data['total'] = $response->data->total;
		} else {
			$this->data['contracts'] = array();
		}

		$stores = $this->api->api_core_Post($this->user['token'], "assetLocation/contract/get_store_by_collection");
		if (!empty($stores->status) && $stores->status == 200) {
			$this->data['stores'] = $stores->data;
		} else {
			$this->data['stores'] = [];
		}

		$getWareHouseAssetLocation = $this->api->apiPost($this->user['token'], "report_kpi/getWareHouseAssetLocation");
		if (!empty($getWareHouseAssetLocation->status) && $getWareHouseAssetLocation->status == 200) {
			$this->data['getWareHouseAssetLocation'] = $getWareHouseAssetLocation->data;
		} else {
			$this->data['getWareHouseAssetLocation'] = array();
		}

		//Nhóm quyền
		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$this->data["pageName"] = 'Quản lý danh sách hợp đồng thiết bị định vị ';
		$this->data['template'] = 'page/asset_location/business/collection';
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->load->view('template', isset($this->data) ? $this->data : NULL);
	}

	public function get_warehouse()
	{
		$warehouses = $this->api->api_core_Post($this->user['token'], "assetLocation/warehouse/list");
		if (!empty($warehouses->status) && $warehouses->status == 200) {
			$response = [
				'status' => 200,
				'message' => 'success',
				'data' => $warehouses->data
			];
			echo json_encode($response);
			return;
		} else {
			$response = [
				'status' => 400,
				'message' => !empty($warehouses->message) ? $warehouses->message : 'Thất bại',
			];
			echo json_encode($response);
			return;
		}
	}

	public function excel_collection()
	{
		$data = [];
		$data = [];
		$data['start'] = !empty($_GET['start']) ? $_GET['start'] : "";
		$data['end'] = !empty($_GET['end']) ? $_GET['end'] : "";
		$data['code_contract_disbursement'] = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$data['customer_name'] = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$data['seri'] = !empty($_GET['seri']) ? $_GET['seri'] : "";
		$data['license'] = !empty($_GET['license']) ? $_GET['license'] : "";
		$data['location'] = !empty($_GET['location']) ? $_GET['location'] : "";
		$data['alarm'] = !empty($_GET['alarm']) ? $_GET['alarm'] : "";
		$data['email'] = !empty($_GET['email']) ? $_GET['email'] : "";
		$data['type_query'] = 'excel';
		$data['store'] = !empty($_GET['store']) ? $_GET['store'] : "";
		$data['status'] = !empty($_GET['status']) ? $_GET['status'] : "";
		$data['check'] = !empty($_GET['check']) ? $_GET['check'] : "";
		$response = $this->api->api_core_Post($this->user['token'], "assetLocation/contract/contract_by_collection", $data);
		if (!empty($response->data)) {
			$this->export_collection($response->data->contracts);
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	public function export_collection($contracts)
	{
		$this->sheet->setCellValue('A1', 'STT');
		$this->sheet->setCellValue('B1', 'Ngày tháng');
		$this->sheet->setCellValue('C1', 'Mã Seri');
		$this->sheet->setCellValue('D1', 'Số HĐ');
		$this->sheet->setCellValue('E1', 'Biển số xe');
		$this->sheet->setCellValue('F1', 'Tên khách hàng');
		$this->sheet->setCellValue('G1', 'Địa chỉ');
		$this->sheet->setCellValue('H1', 'CVKD');
		$this->sheet->setCellValue('I1', 'Phòng giao dịch');
		$this->sheet->setCellValue('J1', 'Tình trạng');
		$this->sheet->setCellValue('K1', 'Ngày trễ');
		$this->sheet->setCellValue('L1', 'Nhóm');

		$i = 2;
		foreach ($contracts as $key => $contract) {
			$this->sheet->setCellValue('A' . $i, ++$key);
			$this->sheet->setCellValue('B' . $i, !empty($contract->disbursement_date) ? date('d/m/Y', $contract->disbursement_date) : "");
			$this->sheet->setCellValue('C' . $i, !empty($contract->loan_infor->device_asset_location->code) ? $contract->loan_infor->device_asset_location->code . " " : "");
			$this->sheet->setCellValue('D' . $i, $contract->code_contract_disbursement);
			$this->sheet->setCellValue('E' . $i, $contract->property_infor[2]->value ?? "");
			$this->sheet->setCellValue('F' . $i, $contract->customer_infor->customer_name ?? "");
			$this->sheet->setCellValue('G' . $i, $contract->current_address->current_stay . ' - ' . $contract->current_address->ward_name . ' - ' . $contract->current_address->district_name . ' - ' . $contract->current_address->province_name);
			$this->sheet->setCellValue('H' . $i, $contract->created_by);
			$this->sheet->setCellValue('I' . $i, $contract->store->name);
			$this->sheet->setCellValue('J' . $i, contract_status($contract->status));
			$this->sheet->setCellValue('K' . $i, !empty($contract->debt->so_ngay_cham_tra) ? $contract->debt->so_ngay_cham_tra : '');
			$this->sheet->setCellValue('L' . $i, !empty($contract->debt->so_ngay_cham_tra) ? get_bucket($contract->debt->so_ngay_cham_tra) : '');
			$i++;
		}
		$this->callLibExcel('danh-sach-thiet-bi-dinh-vi-' . time() . '.csv');
	}

	public function excel_business()
	{
		$data = [];
		$data['start'] = !empty($_GET['start']) ? $_GET['start'] : "";
		$data['end'] = !empty($_GET['end']) ? $_GET['end'] : "";
		$data['code_contract_disbursement'] = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$data['customer_name'] = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
		$data['seri'] = !empty($_GET['seri']) ? $_GET['seri'] : "";
		$data['license'] = !empty($_GET['license']) ? $_GET['license'] : "";
		$data['location'] = !empty($_GET['location']) ? $_GET['location'] : "";
		$data['alarm'] = !empty($_GET['alarm']) ? $_GET['alarm'] : "";
		$data['email'] = !empty($_GET['email']) ? $_GET['email'] : "";
		$data['type_query'] = 'excel';
		$data['store'] = !empty($_GET['store']) ? $_GET['store'] : "";
		$data['check'] = !empty($_GET['check']) ? $_GET['check'] : "";
		$response = $this->api->api_core_Post($this->user['token'], "assetLocation/contract/excel_asset_by_user_business", $data);
		if (!empty($response->data)) {
			$this->export_collection($response->data);
		} else {
			$this->session->set_flashdata('error', "Không có dữ liệu để xuất excel");
		}
	}

	public function updateStatusHandOver(){

		$data = [];
		$data['code_contract'] = $this->security->xss_clean($_GET['code_contract']);
		$data['handOverImg'] = $this->security->xss_clean($_GET['handOverImg']);
		$data['noteHandOver'] = $this->security->xss_clean($_GET['noteHandOver']);
		$data['wareAssetLocation'] = $this->security->xss_clean($_GET['wareAssetLocation']);
		$data['wareAssetLocationName'] = $this->security->xss_clean($_GET['wareAssetLocationName']);

		$response = $this->api->apiPost($this->user['token'], "report_kpi/updateStatusHandOver", $data);

		if (!empty($response->status) && $response->status == 200) {
			$this->pushJson('200', json_encode(array("code" => "200")));
		}

	}

	private function pushJson($code, $data)
	{
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output($data);
	}

	public function indexManagerHandOver(){

		$data = [];
		$statusHandOver = !empty($_GET['statusHandOver']) ? $_GET['statusHandOver'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
		$code = !empty($_GET['code']) ? $_GET['code'] : "";

		if (!empty($statusHandOver)) {
			$data['statusHandOver'] = $statusHandOver;
		}
		if (!empty($code_contract_disbursement)) {
			$data['code_contract_disbursement'] = $code_contract_disbursement;
		}
		if (!empty($code)) {
			$data['code'] = $code;
		}

		//Nhóm quyền
		$groupRoles = $this->api->apiPost($this->userInfo['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
		if (!empty($groupRoles->status) && $groupRoles->status == 200) {
			$this->data['groupRoles'] = $groupRoles->data;
		} else {
			$this->data['groupRoles'] = array();
		}

		$contractData = $this->api->apiPost($this->userInfo['token'], "report_kpi/get_all_contract", $data);
		$uriSegment = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$config = $this->config->item('pagination');
		$config['base_url'] = base_url('assetLocation/indexManagerHandOver');
		$config['total_rows'] = $contractData->count;
		$config['per_page'] = 30;
		$config['page_query_string'] = true;
		$config['uri_segment'] = $uriSegment;
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['count'] = $contractData->count;
		$data["per_page"] = $config['per_page'];
		$data["uriSegment"] = $config['uriSegment'];

		//Lấy tất cả hợp đồng có thiết bị thn yêu cầu
		$contractData = $this->api->apiPost($this->userInfo['token'], "report_kpi/get_all_contract", $data);
		if (!empty($contractData) && $contractData->status == 200) {
			$this->data['contracts'] = $contractData->data;
		} else {
			$this->data['contracts'] = [];
		}

		$this->data['template'] = 'page/file_manager/manager_hand_over.php';
		$this->data['createdAt'] = $this->createdAt;
		$this->load->view('template', isset($this->data) ? $this->data : NULL);



	}




}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;


class ToolSendEmail extends MY_Controller
{

	public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        $this->load->model("store_model");
        $this->load->model("time_model");
        $this->load->model("contract_model");
        $this->load->helper('lead_helper');
        $this->load->library('pagination');
        $this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
        $this->spreadsheet = new Spreadsheet();
        $this->sheet = $this->spreadsheet->getActiveSheet();
        date_default_timezone_set('Asia/Ho_Chi_Minh');

    }

    public function index() {
		$cpanelV2 = $this->config->item("cpanel_v2_url");
		$token = $this->userInfo['token'];
	    $this->data['template'] = 'page/toolEmail/index';
	    if (!empty($_GET['target_url'])) {
			$this->data['url'] = $_GET['target_url'] . "?access_token=$token";
		} else {
			$this->data['url'] = $cpanelV2 . "cpanel/toolSendEmail/indexTempale?access_token=$token";
		}
		$this->load->view('template', $this->data);
		return;
	}
}

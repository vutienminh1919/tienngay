<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;


class BaoHiemPTI extends MY_Controller
{

	public function __construct(){
        parent::__construct();
        $this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
        date_default_timezone_set('Asia/Ho_Chi_Minh');

    }

    /**
    * Danh sách bảo hiểm tai nạn
    */
    public function bhtnIndex() {
		$cpanelV2 = $this->config->item("cpanel_v2_url");
		$token = $this->userInfo['token'];
	    $this->data['template'] = 'page/pti/bhtn/index';
	    if (!empty($_GET['target_url'])) {
			$this->data['url'] = $_GET['target_url'] . "?access_token=$token";
		} else {
			$this->data['url'] = $cpanelV2 . "cpanel/pti/bhtn?access_token=$token";
		}
		$this->load->view('template', $this->data);
		return;
	}

	/**
    * Order bảo hiểm tai nạn
    */
    public function bhtnOrder() {
		$cpanelV2 = $this->config->item("cpanel_v2_url");
		$token = $this->userInfo['token'];
	    $this->data['template'] = 'page/pti/bhtn/index';
	    if (!empty($_GET['target_url'])) {
			$this->data['url'] = $_GET['target_url'] . "?access_token=$token";
		} else {
			$this->data['url'] = $cpanelV2 . "cpanel/pti/bhtn/pgd-bn?access_token=$token";
		}
		$this->load->view('template', $this->data);
		return;
	}

	/**
    * Danh sách bảo hiểm tai nạn bán ngoài
    */
    public function bhtnBnIndex() {
		$cpanelV2 = $this->config->item("cpanel_v2_url");
		$token = $this->userInfo['token'];
	    $this->data['template'] = 'page/pti/bhtn/index';
	    if (!empty($_GET['target_url'])) {
			$this->data['url'] = $_GET['target_url'] . "?access_token=$token";
		} else {
			$this->data['url'] = $cpanelV2 . "cpanel/pti/bhtn/ban-ngoai?access_token=$token";
		}
		$this->load->view('template', $this->data);
		return;
	}

	/**
    * Danh sách bảo hiểm tai nạn bán ngoài
    */
    public function doiSoatIndex() {
		$cpanelV2 = $this->config->item("cpanel_v2_url");
		$token = $this->userInfo['token'];
	    $this->data['template'] = 'page/pti/bhtn/index';
	    if (!empty($_GET['target_url'])) {
			$this->data['url'] = $_GET['target_url'] . "?access_token=$token";
		} else {
			$this->data['url'] = $cpanelV2 . "cpanel/pti/bhtn/doi-soat?access_token=$token";
		}
		$this->load->view('template', $this->data);
		return;
	}
}

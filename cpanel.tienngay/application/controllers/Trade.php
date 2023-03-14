<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trade extends MY_Controller
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
    date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	/**
	 * index item view
	 * */
	public function item() {
		$cpanelV2 = $this->config->item("cpanel_v2_url");
		$token = $this->userInfo['token'];
	  $this->data['template'] = 'page/trade/item';
		if (!empty($_GET['target'])) {
			$this->data['url'] = $cpanelV2 . $_GET['target'] . "?iframe=1&access_token=$token";
		} else {
			$this->data['url'] = $cpanelV2 . "cpanel/trade/listItem?iframe=1&access_token=$token";
		}
		$this->data['iframeDomain'] = $cpanelV2;
		$this->load->view('page/trade/template', $this->data);
		return;
	}

	/**
	 * index trade's order view
	 * */
	public function requestIndex(){
		$cpanelV2 = $this->config->item("cpanel_v2_url");
		$token = $this->userInfo['token'];
		$this->data['template'] = 'page/trade/requestOrder';
		if (!empty($_GET['target'])) {
			$this->data['url'] = $cpanelV2 . $_GET['target'] . "?iframe=1&access_token=$token";
		} else {
			$this->data['url'] = $cpanelV2 . "cpanel/trade/trade-order/index?iframe=1&access_token=$token";
		}
		$this->data['iframeDomain'] = $cpanelV2;
		$this->load->view('page/trade/template', $this->data);
		return;
	}

	/**
	 * index inventory view
	 * */
	public function inventory(){
		$cpanelV2 = $this->config->item("cpanel_v2_url");
		$token = $this->userInfo['token'];
		$this->data['template'] = 'page/trade/inventory';
		if (!empty($_GET['target'])) {
			$this->data['url'] = $cpanelV2 . $_GET['target'] . "?iframe=1&access_token=$token";
		} else {
			$this->data['url'] = $cpanelV2 . "cpanel/trade/inventory?iframe=1&access_token=$token";
		}
		$this->data['iframeDomain'] = $cpanelV2;
		$this->load->view('page/trade/template', $this->data);
		return;
	}

	/**
	 * index report view store
	 * */
	public function reportList(){
		$cpanelV2 = $this->config->item("cpanel_v2_url");
		$token = $this->userInfo['token'];
		$this->data['template'] = 'page/trade/reportList';
		if (!empty($_GET['target'])) {
			$this->data['url'] = $cpanelV2 . $_GET['target'] . "?iframe=1&access_token=$token";
		} else {
			$this->data['url'] = $cpanelV2 . "cpanel/trade/inventory/reportList?iframe=1&access_token=$token";
		}
		$this->data['iframeDomain'] = $cpanelV2;
		$this->load->view('page/trade/template', $this->data);
		return;
	}

	/**
	 * Phiếu xuất kho
	 * */
	public function tradeDelivery($id = NULL) {
		$cpanelV2 = $this->config->item("cpanel_v2_url");
		$token = $this->userInfo['token'];
		$this->data['template'] = 'page/trade/delivery';
		if (!empty($_GET['target'])) {
			$this->data['url'] = $cpanelV2 . $_GET['target'] . "?iframe=1&access_token=$token";
		} else {
			$this->data['url'] = $cpanelV2 . "cpanel/trade/warehouse/pgd_index?iframe=1&access_token=$token&tab=delivery";
		}
		$this->data['iframeDomain'] = $cpanelV2;
		$this->load->view('page/trade/template', $this->data);
		return;
	}

	/**
	 * Phiếu điều chuyển
	 * */
	public function tradeTransfer($id = NULL) {
		$cpanelV2 = $this->config->item("cpanel_v2_url");
		$token = $this->userInfo['token'];
		$this->data['template'] = 'page/trade/transfer';
		if (!empty($_GET['target'])) {
			$this->data['url'] = $cpanelV2 . $_GET['target'] . "?iframe=1&access_token=$token";
		} else {
			$this->data['url'] = $cpanelV2 . "cpanel/trade/warehouse/pgd_index?iframe=1&access_token=$token&tab=transfer";
		}
		$this->data['iframeDomain'] = $cpanelV2;
		$this->load->view('page/trade/template', $this->data);
		return;
	}


	public function tradePublication()
  {
    $cpanelV2 = $this->config->item("cpanel_v2_url");
    $token = $this->userInfo['token'];
    $this->data['template'] = 'page/trade/index';
    if (!empty($_GET['target_url'])) {
      $this->data['url'] = $_GET['target_url'] . "?iframe=1&access_token=$token";
    } else {
      $this->data['url'] = $cpanelV2 . "cpanel/trade/publication/list_publications?iframe=1&access_token=$token";
    }
    $this->data['iframeDomain'] = $cpanelV2;
    $this->load->view('template', $this->data);
    return;
  }
}

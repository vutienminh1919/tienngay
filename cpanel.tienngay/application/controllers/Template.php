<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include('application/vendor/autoload.php');
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

class Template extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }

    public function login(){
        $this->load->view('template/login', isset($this->data)?$this->data:NULL);
    }
    public function login_forgotpass(){
        $this->load->view('template/login_forgotpass', isset($this->data)?$this->data:NULL);
    }
    public function login_resetpass(){
        $this->load->view('template/login_resetpass', isset($this->data)?$this->data:NULL);
    }

    public function resetpasswords(){
        $this->load->view('template/resetpasswords', isset($this->data)?$this->data:NULL);
    }
    public function createacc(){
        $this->load->view('template/createacc', isset($this->data)?$this->data:NULL);
    }

    public function general(){
        $this->data['template'] = 'template/general';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }

    public function draft(){
        $this->data['template'] = 'template/draft';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }

    public function imagegallery(){
        $this->data['template'] = 'template/imagegallery';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function imagegalleryv2(){
        $this->data['template'] = 'template/imagegalleryv2';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }

    public function dashboard(){
        $this->data['template'] = 'template/dashboard';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }

    public function fee_loan(){
        $this->data['template'] = 'template/fee_loan';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function list(){
        $this->data['template'] = 'template/list';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }

    public function profile(){
        $this->data['template'] = 'template/profile';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }

    public function notify_all(){
        $this->data['template'] = 'template/notify_all';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function wizard_verifyimages(){
        $this->data['template'] = 'template/wizard_verifyimages';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function wizard(){
        $this->data['template'] = 'template/wizard';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function wizard_mb(){
        $this->data['template'] = 'template/wizard_mb';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }


    public function menucontrol(){
        $this->data['template'] = 'template/menucontrol';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function menucontrol2(){
        $this->data['template'] = 'template/menucontrol2';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    // Add new
    public function feedback(){
        $this->data['template'] = 'template/feedback';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }

    public function addnew(){
        $this->data['template'] = 'template/addnew';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function addnewupload(){

        $this->load->view('template/addnewupload', isset($this->data)?$this->data:NULL);
    }
    public function addnewv2(){
        $this->data['template'] = 'template/addnew_v2';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function addnew_nhanvien(){
        $this->data['template'] = 'template/addnew_nhanvien';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function addnew_khachhang(){
        $this->data['template'] = 'template/addnew_khachhang';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function addnew_cuahang(){
        $this->data['template'] = 'template/addnew_cuahang';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    // Generals


    public function pawn(){
        $this->data['template'] = 'template/pawn';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function interestloans(){
        $this->data['template'] = 'template/interestloans';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function tontine(){
        $this->data['template'] = 'template/tontine';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function capitalmanagement(){
        $this->data['template'] = 'template/capitalmanagement';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    // Custommer
    public function custommer_list(){
        $this->data['template'] = 'template/custommer_list';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function custommer_needloans(){
        $this->data['template'] = 'template/custommer_needloans';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }

    // Revenue & expenditure
    public function revenueexpenditure_expenditure(){
        $this->data['template'] = 'template/revenueexpenditure_expenditure';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function revenueexpenditure_revenue(){
        $this->data['template'] = 'template/revenueexpenditure_revenue';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }


    // Shop management
    public function shopmanagament_summary(){
        $this->data['template'] = 'template/shopmanagament_summary';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function shopmanagament_detailinfos(){
        $this->data['template'] = 'template/shopmanagament_detailinfos';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function shopmanagament_shoplist(){
        $this->data['template'] = 'template/shopmanagament_shoplist';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function shopmanagament_goodssettings(){
        $this->data['template'] = 'template/shopmanagament_goodssettings';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function shopmanagament_fundsbeginday(){
        $this->data['template'] = 'template/shopmanagament_fundsbeginday';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }

    // Employees
    public function employees_list(){
        $this->data['template'] = 'template/employees_list';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function employees_delegation(){
        $this->data['template'] = 'template/employees_delegation';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }

    // Bad debts
    public function baddebt(){
        $this->data['template'] = 'template/baddebt';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function addfriends(){
        $this->data['template'] = 'template/addfriends';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function confirmfriends(){
        $this->data['template'] = 'template/confirmfriends';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    // Additionals
    public function additionals(){
        $this->data['template'] = 'template/additionals';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function additionals_history(){
        $this->data['template'] = 'template/additionals_history';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }

    // Report
    public function report_transactions_summary(){
        $this->data['template'] = 'template/report_transactions_summary';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function report_profit_summary(){
        $this->data['template'] = 'template/report_profit_summary';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }

    public function report_revenue(){
        $this->data['template'] = 'template/report_revenue';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }

    public function report_dailyrevenue(){
        $this->data['template'] = 'template/report_dailyrevenue';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function report_collection_statistics(){
        $this->data['template'] = 'template/report_collection_statistics';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function report_loanscontracts(){
        $this->data['template'] = 'template/report_loanscontracts';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function report_goodsliquidationscontracts(){
        $this->data['template'] = 'template/report_goodsliquidationscontracts';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function report_goodsredeemclosecontracts(){
        $this->data['template'] = 'template/report_goodsredeemclosecontracts';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function report_goodsliquidations(){
        $this->data['template'] = 'template/report_goodsliquidations';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function report_liquidations(){
        $this->data['template'] = 'template/report_liquidations';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function report_deletedcontracts(){
        $this->data['template'] = 'template/report_deletedcontracts';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function report_smsmessenger(){
        $this->data['template'] = 'template/report_smsmessenger';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }
    public function report_shifthandover(){
        $this->data['template'] = 'template/report_shifthandover';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }

    public function appraise(){
        $this->data['template'] = 'template/appraise';
        $this->load->view('template/template', isset($this->data)?$this->data:NULL);
    }

    // Billing
    public function billing(){
       $data['template'] = 'template/billing';
        $this->load->view('template/template', isset($data)?$data:NULL);
    }

    public function billing_phone_prepaid(){
       $data['template'] = 'template/billing_phone_prepaid';
        $this->load->view('template/template', isset($data)?$data:NULL);
    }
    public function billing_phone_afterpaid(){
       $data['template'] = 'template/billing_phone_afterpaid';
        $this->load->view('template/template', isset($data)?$data:NULL);
    }
    public function billing_phone_cardcode(){
       $data['template'] = 'template/billing_phone_cardcode';
        $this->load->view('template/template', isset($data)?$data:NULL);
    }

    public function billing_game_directly(){
       $data['template'] = 'template/billing_game_directly';
        $this->load->view('template/template', isset($data)?$data:NULL);
    }
    public function billing_game_buyingcode(){
       $data['template'] = 'template/billing_game_buyingcode';
        $this->load->view('template/template', isset($data)?$data:NULL);
    }

    public function billing_recipe_electric(){
       $data['template'] = 'template/billing_recipe_electric';
        $this->load->view('template/template', isset($data)?$data:NULL);
    }
    public function billing_recipe_water(){
       $data['template'] = 'template/billing_recipe_water';
        $this->load->view('template/template', isset($data)?$data:NULL);
    }
    public function billing_recipe_finance(){
       $data['template'] = 'template/billing_recipe_finance';
        $this->load->view('template/template', isset($data)?$data:NULL);
    }

    public function billing_order(){
       $data['template'] = 'template/billing_order';
        $this->load->view('template/template', isset($data)?$data:NULL);
    }

    public function billing_payment(){
       $data['template'] = 'template/billing_payment';
        $this->load->view('template/template', isset($data)?$data:NULL);
    }

    public function billing_transaction_detail(){
       $data['template'] = 'template/billing_transaction_detail';
        $this->load->view('template/template', isset($data)?$data:NULL);
    }

    public function billing_printed_1(){
        $this->load->view('template/billing_printed_1', isset($data)?$data:NULL);
    }
    public function billing_printed_2(){
        $this->load->view('template/billing_printed_2', isset($data)?$data:NULL);
    }
    public function confirm_disbursement(){
      $data['template'] = 'template/confirm_disbursement';
       $this->load->view('template/template', isset($data)?$data:NULL);
    }
    public function confirm_disbursement_v2(){
      $data['template'] = 'template/confirm_disbursement_v2';
       $this->load->view('template/template', isset($data)?$data:NULL);
    }

    public function quanlythuhoino(){
      $data['template'] = 'template/quanlythuhoino';
       $this->load->view('template/template', isset($data)?$data:NULL);
    }
    public function quanlythuhoino_detail(){
      $data['template'] = 'template/quanlythuhoino_detail';
       $this->load->view('template/template', isset($data)?$data:NULL);
    }

    public function quanlynhadautu(){
      $data['template'] = 'template/nhadautu_quanly';
       $this->load->view('template/template', isset($data)?$data:NULL);
    }
    public function themmoinhadautu(){
      $data['template'] = 'template/nhadautu_themmoi';
       $this->load->view('template/template', isset($data)?$data:NULL);
    }
    public function suanhadautu(){
      $data['template'] = 'template/nhadautu_sua';
       $this->load->view('template/template', isset($data)?$data:NULL);
    }
    public function chitietnhadautu(){
      $data['template'] = 'template/nhadautu_chitiet';
       $this->load->view('template/template', isset($data)?$data:NULL);
    }

    public function quanlykho_danhsachkho() {
      $data['template'] = 'template/quanlykho_danhsachkho';
       $this->load->view('template/template', isset($data)?$data:NULL);
    }
    public function quanlykho_taomoikho() {
      $data['template'] = 'template/quanlykho_taomoikho';
       $this->load->view('template/template', isset($data)?$data:NULL);
    }
    public function quanlykho_danhsachtaisan() {
      $data['template'] = 'template/quanlykho_danhsachtaisan';
       $this->load->view('template/template', isset($data)?$data:NULL);
    }
    public function quanlykho_capnhattaisan() {
      $data['template'] = 'template/quanlykho_capnhattaisan';
       $this->load->view('template/template', isset($data)?$data:NULL);
    }

    public function quanlyhopdong_chitietkithanhtoan() {
      $data['template'] = 'template/quanlyhopdong/chitietkithanhtoan';
       $this->load->view('template/template', isset($data)?$data:NULL);
    }
	public function quanlyhopdong_addnew()
	{
		$data['template'] = 'template/quanlyhopdong/quanlyhopdong_addnew';
		$this->load->view('template/template', isset($data) ? $data : NULL);
	}

	public function danhsachhopdong()
	{
		$data['template'] = 'template/quanlyhopdong/danhsachhopdong';
		$this->load->view('template/template', isset($data) ? $data : NULL);
	}
	public function danhsachhopdong_chitiet()
	{
		$data['template'] = 'template/quanlyhopdong/danhsachhopdong_chitiet';
		$this->load->view('template/template', isset($data) ? $data : NULL);
	}
	public function thongbaohopdong()
	{
		$data['template'] = 'template/quanlyhopdong/thongbaohopdong';
		$this->load->view('template/template', isset($data) ? $data : NULL);
	}
    public function baohiem()
    {
        $data['template'] = 'template/kpi/baohiem';
        $this->load->view('template/template', isset($data) ? $data : NULL);
    }
    public function dinhgia()
    {
        $data['template'] = 'template/dinhgiataisan/dinhgia';
        $this->load->view('template/template', isset($data) ? $data : NULL);
    }
    public function bieuphi()
    {
        $data['template'] = 'template/bieuphi/bieuphi';
        $this->load->view('template/template', isset($data) ? $data : NULL);
    }
    public function details()
    {
        $data['template'] = 'template/bieuphi/details';
        $this->load->view('template/template', isset($data) ? $data : NULL);
    }
	public function hoahong()
	{
		$data['template'] = 'template/hoahong/hoahong';
		$this->load->view('template/template', isset($data) ? $data : NULL);
	}
	public function baocao()
	{
		$data['template'] = 'template/BaocaoMkt/index';
		$this->load->view('template/template', isset($data) ? $data : NULL);
	}
	public function listbaocao()
	{
		$data['template'] = 'template/BaocaoMkt/list';
		$this->load->view('template/template', isset($data) ? $data : NULL);
	}
	public function dashboard_manager()
	{
		$data['template'] = 'template/dashboard_kd/manager';
		$this->load->view('template/template', isset($data) ? $data : NULL);
	}
	public function dashboard_asm()
	{
		$data['template'] = 'template/dashboard_kd/asm';
		$this->load->view('template/template', isset($data) ? $data : NULL);
	}
	public function dashboard_lead()
	{
		$data['template'] = 'template/dashboard_kd/lead';
		$this->load->view('template/template', isset($data) ? $data : NULL);
	}
	public function dashboard_nv()
	{
		$data['template'] = 'template/dashboard_kd/nhanvien';
		$this->load->view('template/template', isset($data) ? $data : NULL);
	}
    public function dashboard_thn_manager()
	{
		$data['template'] = 'template/dashboard_thn/manager';
		$this->load->view('template/template', isset($data) ? $data : NULL);
	}
	public function dashboard_thn_lead()
	{
		$data['template'] = 'template/dashboard_thn/lead';
		$this->load->view('template/template', isset($data) ? $data : NULL);
	}
	public function dashboard_hn_nv()
	{
		$data['template'] = 'template/dashboard_thn/nhanvien';
		$this->load->view('template/template', isset($data) ? $data : NULL);
	}
}
?>

<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class VimoBilling extends MY_Controller {
    public function __construct() {
        parent::__construct();
        // $this->api = new Api();
        $this->userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
		if (!$this->is_superadmin) {
			$paramController = $this->uri->segment(1);
			$param = strtolower($paramController);
			if (!in_array($param, $this->paramMenus)) {
				$this->session->set_flashdata('error', $this->lang->line('not_have_permission').' '.$paramController .'!');
				redirect(base_url('app'));
				return;
			}
		}
    }
    
    // private $api;

    public function index(){
        $this->data["pageName"] = $this->lang->line('Personal_multi_utility_financial_services');
        $this->data['template'] = 'page/billing/index';
        $this->load->view('template', isset($this->data)?$this->data:NULL);
    }

    // thanh toán hóa đơn điện
    public function billingElectric(){
        //Encrypt TripleDes
      
        $dataPost = array(
            "sevice_code" => "BILL_ELECTRIC",
        );
        $return = $this->api->apiPost($this->user['token'], "service/find_where", $dataPost);
        if(!empty($return->status) && $return->status == 200){
            $this->data["service"] = $return->data;
        }
        $this->data["pageName"] = $this->lang->line('Electric_bill_payment');
        $this->data['template'] = 'page/billing/billing_electric';
        $this->load->view('template', isset($this->data)?$this->data:NULL);
    }

    // thanh toán hóa đơn nước
    public function billingWater(){
        $dataPost = array(
            "sevice_code" => "BILL_WATER",
        );
        $return = $this->api->apiPost($this->user['token'], "service/find_where", $dataPost);
        if(!empty($return->status) && $return->status == 200){
            $this->data["service"] = $return->data;
        }
        $this->data["pageName"] = $this->lang->line('Water_bill_payment');
        $this->data['template'] = 'page/billing/billing_water';
        $this->load->view('template', isset($this->data)?$this->data:NULL);
    }

    // thanh toán hóa đơn tài chính
    public function billingFinance(){
        $dataPost = array(
            "sevice_code" => "BILL_FINANCE",
        );
        $return = $this->api->apiPost($this->user['token'], "service/find_where", $dataPost);
        if(!empty($return->status) && $return->status == 200){
            $this->data["service"] = $return->data;
        }
        $this->data["pageName"] = $this->lang->line('Financial_invoice_payment');
        $this->data['template'] = 'page/billing/billing_finance';
        $this->load->view('template', isset($this->data)?$this->data:NULL);
    }

    // nap thẻ điện thoại trả trước
    public function topupPhonePrepaid(){
        $dataPost = array(
            "sevice_code" => "TOPUP_TELCO_PREPAID",
        );
        $return = $this->api->apiPost($this->user['token'], "service/find_where", $dataPost);
        if(!empty($return->status) && $return->status == 200){
            $this->data["service"] = $return->data;
        }
        $this->data["pageName"] = $this->lang->line('Prepaid_phone_card_recharge_service');
        $this->data['template'] = 'page/billing/topup_phone_prepaid';
        $this->load->view('template', isset($this->data)?$this->data:NULL);
    }

    // nap thẻ điện thoại trả sau
    public function topupPhoneAfterpaid(){
        $dataPost = array(
            "sevice_code" => "TOPUP_TELCO_POSTPAID",
        );
        $return = $this->api->apiPost($this->user['token'], "service/find_where", $dataPost);
        if(!empty($return->status) && $return->status == 200){
            $this->data["service"] = $return->data;
        }
        $this->data["pageName"] = $this->lang->line('Postpaid_phone_card_recharge_service');
        $this->data['template'] = 'page/billing/topup_phone_afterpaid';
        $this->load->view('template', isset($this->data)?$this->data:NULL);
    }


    // nap mua thẻ điện thoại trả sau
    public function pincodePhoneCardcode(){
        $dataPost = array(
            "sevice_code" => "PINCODE_TELCO",
        );
        $return = $this->api->apiPost($this->user['token'], "service/find_where", $dataPost);
        if(!empty($return->status) && $return->status == 200){
            $this->data["service"] = $return->data;
        }
        $this->data["pageName"] = $this->lang->line('Phone_card_buying_service');
        $this->data['template'] = 'page/billing/pincode_phone_cardcode';
        $this->load->view('template', isset($this->data)?$this->data:NULL);
    }


    // nap tài khoản game
    public function topupGame(){
        $dataPost = array(
            "sevice_code" => "TOPUP_GAME",
        );
        $return = $this->api->apiPost($this->user['token'], "service/find_where", $dataPost);
        if(!empty($return->status) && $return->status == 200){
            $this->data["service"] = $return->data;
        }
        $this->data["pageName"] = $this->lang->line('Game_account_recharge_service');
        $this->data['template'] = 'page/billing/topup_game';
        $this->load->view('template', isset($this->data)?$this->data:NULL);
    }


    // mua thẻ game
    public function pincodeGame(){
        $dataPost = array(
            "sevice_code" => "PINCODE_GAME",
        );
        $return = $this->api->apiPost($this->user['token'], "service/find_where", $dataPost);
        if(!empty($return->status) && $return->status == 200){
            $this->data["service"] = $return->data;
        }
        $this->data["pageName"] = $this->lang->line('Game_card_buying_service');
        $this->data['template'] = 'page/billing/pincode_game';
        $this->load->view('template', isset($this->data)?$this->data:NULL);
    }

//	public function test() {
//		$order = array(
//			array( // mua the
//				'mc_request_id' => "MUA_THE_DT_01",
//				'service_code' => "PINCODE_TELCO",
//				'publisher' => "VTT",
//				'quantity' => 2,
//				'amount' => 500000,
//				'money' => 500000,
//			),
//			array( // nap the
//				'mc_request_id' => "NAP_THE_DT_01",
//				'service_code' => "TOPUP_TELCO_PREPAID",
//				'publisher' => "VTT",
//				'receiver' => '0123456789',
//				'amount' => 300000,
//				'money' => 300000,
//			),
//		);
//		$dataPost = array(
//			"total" => 1300000,
//			"payment_method" =>  "Tien mat",
//			"store" => array(
//				'id' => '5da6bb4661d07424ee55f843',
//				'name' => 'Hoang shop',
//			),
//			"customer_bill_name" => "Hoang",
//			"customer_bill_phone" => '123456789',
//			"order" => $order,
//		);
//		$return = $this->api->apiPost($this->user['token'], "transaction/create_transaction_order", $dataPost);
//		var_dump($return);die;
//	}
    //thanh toán bảo hiểm
     public function do_payment_gci()
     {
        $arr_post=[
            "productId"=>"00000000-0000-0000-0000-000000000000",
            "thongTinChung_NhanVienId"=>"00000000-0000-0000-0000-000000000000",
            "noiDungBaoHiem_TyLeHoaHong"=>0,
            "noiDungBaoHiem_TyLeHoTroDaiLy"=>0,
            "noiDungBaoHiem_TyLePhiDichVu"=>0,
            "noiDungBaoHiem_TyLeHoaHongTrucTiep"=>0,
            "noiDungBaoHiem_HoaHong"=>0,
            "noiDungBaoHiem_HoTroDaiLy"=>0,
            "noiDungBaoHiem_PhiDichVu"=>0,
            "noiDungBaoHiem_HoaHongTrucTiep"=>0,
            "noiDungBaoHiem_HoaHong_VAT"=>0,
            "noiDungBaoHiem_HoTroDaiLy_VAT"=>0,
            "noiDungBaoHiem_PhiDichVu_VAT"=>0,
            "noiDungBaoHiem_PhiNet"=>0,
            "thongTinNguoiDuocBaoHiem_CongTy_Ten"=>"string",
            "thongTinNguoiDuocBaoHiem_CongTy_DiaChiGiaoDich"=>"string",
            "thongTinNguoiDuocBaoHiem_CongTy_DiaChiGiaoDich_DistrictId"=>"00000000-0000-0000-0000-000000000000",
            "thongTinNguoiDuocBaoHiem_CongTy_DiaChiGiaoDich_ProvinceId"=>"00000000-0000-0000-0000-000000000000",
            "thongTinNguoiDuocBaoHiem_CongTy_MaSoThue"=>"string",
            "thongTinNguoiDuocBaoHiem_CongTy_DiaChiKhaiBaoThue"=>"string",
            "thongTinNguoiDuocBaoHiem_CongTy_DiaChiKhaiBaoThue_DistrictId"=>"00000000-0000-0000-0000-000000000000",
            "thongTinNguoiDuocBaoHiem_CongTy_DiaChiKhaiBaoThue_ProvinceId"=>"00000000-0000-0000-0000-000000000000",
            "thongTinNguoiDuocBaoHiem_CongTy_SoDienThoai"=>"string",
            "thongTinNguoiDuocBaoHiem_CongTy_Fax"=>"string",
            "thongTinNguoiDuocBaoHiem_CongTy_NguoiDaiDien"=>"string",
            "thongTinNguoiDuocBaoHiem_CongTy_ChucVuNguoiDaiDien"=>"string",
            "thongTinNguoiDuocBaoHiem_CongTy_EmailNguoiDaiDien"=>"string",
            "thongTinNguoiDuocBaoHiem_CongTy_SoDienThoaiNguoiDaiDien"=>"string",
            "thongTinNguoiDuocBaoHiem_CaNhan_Ten"=>"string",
            "thongTinNguoiDuocBaoHiem_CaNhan_NgaySinh"=>"2019-12-02T07:05:41.973Z",
            "thongTinNguoiDuocBaoHiem_CaNhan_GioiTinhId"=>"00000000-0000-0000-0000-000000000000",
            "thongTinNguoiDuocBaoHiem_CaNhan_SoCMND"=>"string",
            "thongTinNguoiDuocBaoHiem_CaNhan_Email"=>"string",
            "thongTinNguoiDuocBaoHiem_CaNhan_SoDienThoai"=>"string",
            "thongTinNguoiDuocBaoHiem_CaNhan_DiaChi"=>"string",
            "thongTinNguoiDuocBaoHiem_CaNhan_DiaChi_DistrictId"=>"00000000-0000-0000-0000-000000000000",
            "thongTinNguoiDuocBaoHiem_CaNhan_DiaChi_ProvinceId"=>"00000000-0000-0000-0000-000000000000",
            "thongTinNguoiDuocBaoHiem_LoaiKhachHangId"=>"00000000-0000-0000-0000-000000000000",
            "thongTinNguoiDuocBaoHiem_MaSoKH_CIF"=>"string",
            "thongTinNguoiDuocBaoHiem_MucDichVayId"=>"00000000-0000-0000-0000-000000000000",
            "thongTinNguoiDuocBaoHiem_MucDichKhac"=>"string",
            "thongTinNguoiDuocBaoHiem_CachNopPhiId"=>"00000000-0000-0000-0000-000000000000",
            "thongTinNguoiDuocBaoHiem_TongTienGiaiNgan"=>0,
            "thongTinNguoiDuocBaoHiem_KhoanVayThanhToan"=>0,
            "thongTinNguoiDuocBaoHiem_KhachHangVayTopUp"=>true,
            "thongTinNguoiDuocBaoHiem_DongYThamGiaTopUp"=>true,
            "thongTinNguoiDuocBaoHiem_SoTienVayMuaBH"=>0,
            "yeuCauBaoHiem_CongTy_Ten"=>"string",
            "yeuCauBaoHiem_CongTy_DiaChiGiaoDich"=>"string",
            "yeuCauBaoHiem_CongTy_DiaChiGiaoDich_DistrictId"=>"00000000-0000-0000-0000-000000000000",
            "yeuCauBaoHiem_CongTy_DiaChiGiaoDich_ProvinceId"=>"00000000-0000-0000-0000-000000000000",
            "yeuCauBaoHiem_CongTy_MaSoThue"=>"string",
            "yeuCauBaoHiem_CongTy_DiaChiKhaiBaoThue"=>"string",
            "yeuCauBaoHiem_CongTy_DiaChiKhaiBaoThue_DistrictId"=>"00000000-0000-0000-0000-000000000000",
            "yeuCauBaoHiem_CongTy_DiaChiKhaiBaoThue_ProvinceId"=>"00000000-0000-0000-0000-000000000000",
            "yeuCauBaoHiem_CongTy_SoDienThoai"=>"string",
            "yeuCauBaoHiem_CongTy_Fax"=>"string",
            "yeuCauBaoHiem_CongTy_NguoiDaiDien"=>"string",
            "yeuCauBaoHiem_CongTy_ChucVuNguoiDaiDien"=>"string",
            "yeuCauBaoHiem_CongTy_EmailNguoiDaiDien"=>"string",
            "yeuCauBaoHiem_CongTy_SoDienThoaiNguoiDaiDien"=>"string",
            "yeuCauBaoHiem_CongTy_Email"=>"string",
            "yeuCauBaoHiem_CaNhan_Ten"=>"string",
            "yeuCauBaoHiem_CaNhan_NgaySinh"=>"2019-12-02T07:05:41.973Z",
            "yeuCauBaoHiem_CaNhan_GioiTinhId"=>"00000000-0000-0000-0000-000000000000",
            "yeuCauBaoHiem_CaNhan_SoCMND"=>"string",
            "yeuCauBaoHiem_CaNhan_Email"=>"string",
            "yeuCauBaoHiem_CaNhan_SoDienThoai"=>"string",
            "yeuCauBaoHiem_CaNhan_DiaChi"=>"string",
            "yeuCauBaoHiem_CaNhan_DiaChi_DistrictId"=>"00000000-0000-0000-0000-000000000000",
            "yeuCauBaoHiem_CaNhan_DiaChi_ProvinceId"=>"00000000-0000-0000-0000-000000000000",
            "noiDungBaoHiem_MaSoKH_CIF"=>"string",
            "noiDungBaoHiem_SoHdTinDungKv"=>"string",
            "noiDungBaoHiem_GiaTriKhoanVay"=>0,
            "noiDungBaoHiem_SoTienBaoHiem"=>0,
            "noiDungBaoHiem_TyLePhi"=>0,
            "noiDungBaoHiem_TyLeKhoanVay"=>0,
            "noiDungBaoHiem_PhiBaoHiem"=>0,
            "noiDungBaoHiem_TongPhiBaoHiem1Nam"=>0,
            "noiDungBaoHiem_TongPhiBaoHiem2Nam"=>0,
            "noiDungBaoHiem_TongPhiBaoHiem3Nam"=>0,
            "noiDungBaoHiem_TongPhiBaoHiem4Nam"=>0,
            "noiDungBaoHiem_TongPhiBaoHiem5Nam"=>0,
            "noiDungBaoHiem_PhiBaoHiem_VAT"=>0,
            "noiDungBaoHiem_NgayYeuCauBh"=>"2019-12-02T07:05:41.973Z",
            "noiDungBaoHiem_NgayYeuCauHieuLucBH"=>"2019-12-02T07:05:41.973Z",
            "noiDungBaoHiem_NgayHieuLucBaoHiem"=>"2019-12-02T07:05:41.973Z",
            "noiDungBaoHiem_NgayHieuLucBaoHiemDen"=>"2019-12-02T07:05:41.973Z",
            "noiDungBaoHiem_SoThangThamGiaBh"=>0,
            "noiDungBaoHiem_NgayHuyHd"=>"2019-12-02T07:05:41.973Z",
            "noiDungBaoHiem_SoTienHoanKhach"=>0,
            "noiDungBaoHiem_NgayDuyet"=>"2019-12-02T07:05:41.973Z",
            "yeuCauBaoHiem_KemKhoanVay"=>true,
            "yeuCauBaoHiem_SoDonHangTinDung"=>"string",
            "yeuCauBaoHiem_LoaiXeId"=>"00000000-0000-0000-0000-000000000000",
            "yeuCauBaoHiem_LoaiKhachHangId"=>"00000000-0000-0000-0000-000000000000",
            "nguoiThuHuong_LoaiNguoiThuHuongId"=>"00000000-0000-0000-0000-000000000000",
            "nguoiThuHuong_LoaiNguoiThuHuongCode"=>"string",
            "nguoiThuHuong_LoaiNguoiThuHuongName"=>"string",
            "nguoiThuHuong_MoiQuanHeId"=>"00000000-0000-0000-0000-000000000000",
            "nguoiThuHuong_MoiQuanHeThuHuong"=>"string",
            "nguoiThuHuong_HoTen"=>"string",
            "nguoiThuHuong_SoCMND"=>"string",
            "nguoiThuHuong_TenChiNhanhNganHang"=>"string",
            "nguoiThuHuong_DiaChiChiNhanhNganHang"=>"string",
            "thongTinHoaDon_IBMS"=>"string",
            "thongTinHoaDon_Core"=>"string",
            "thongTinHoaDon_SoHoaDon"=>"string",
            "thongTinHoaDon_MaSoBiMat"=>"string",
            "thongTinHoaDon_TenSPTrenHopDong"=>"string",
            "thongTinHoaDon_MST"=>"string",
            "thongTinHoaDon_LinkHoaDon"=>"string",
            "thongTinHoaDon_NguoiNhanHoaDonKhacVoiNguoiBH"=>true,
            "thongTinHoaDon_TenNguoiNhanHD"=>"string",
            "thongTinHoaDon_EmailNhanHD"=>"string",
            "thongTinHoaDon_DienThoaiNhanHD"=>"string",
            "thongTinHoaDon_DiaChiNhanHD"=>"string",
            "tinhBieuPhi"=>true,
            "noiDungBaoHiem_DiaDiemBaoHiem_DiaChi_ProvinceId"=>"00000000-0000-0000-0000-000000000000",
            "noiDungBaoHiem_DiaDiemBaoHiem_DiaChi_DistrictId"=>"00000000-0000-0000-0000-000000000000",
            "noiDungBaoHiem_DiaDiemBaoHiem_DiaChi_WardId"=>"00000000-0000-0000-0000-000000000000",
            "noiDungBaoHiem_DiaDiemBaoHiem_DiaChi"=>"string",
            "noiDungBaoHiem_DiaDiemBaoHiem_LoaiNhaId"=>"00000000-0000-0000-0000-000000000000",
            "noiDungBaoHiem_DiaDiemBaoHiem_CapNhaId"=>"00000000-0000-0000-0000-000000000000",
            "noiDungBaoHiem_DiaDiemBaoHiem_TenChungCu"=>"string",
            "noiDungBaoHiem_DiaDiemBaoHiem_GiaTriBaoHiem"=>0,
            "noiDungBaoHiem_DiaDiemBaoHiem_MucDichSuDungId"=>"00000000-0000-0000-0000-000000000000",
            "noiDungBaoHiem_DiaDiemBaoHiem_MucDichSuDungKhac"=>"string",
            "noiDungBaoHiem_DiaDiemBaoHiem_SoGCNQSDD_QSDNO"=>"string",
            "noiDungBaoHiem_TaiSanTrongCanHo_TongTienThamGiaBH"=>0,
            "thongKeTaiSanVaPhamViDuocBH_DiaChi_DistrictId"=>"00000000-0000-0000-0000-000000000000",
            "thongKeTaiSanVaPhamViDuocBH_DiaChi_ProvinceId"=>"00000000-0000-0000-0000-000000000000",
            "thongKeTaiSanVaPhamViDuocBH_Ward"=>"string",
            "thongKeTaiSanVaPhamViDuocBH_DiaChi"=>"string",
            "thongKeTaiSanVaPhamViDuocBH_LoaiNhaId"=>"00000000-0000-0000-0000-000000000000",
            "thongKeTaiSanVaPhamViDuocBH_CapNhaId"=>"00000000-0000-0000-0000-000000000000",
            "thongKeTaiSanVaPhamViDuocBH_LoaiNhaO"=>true,
            "thongKeTaiSanVaPhamViDuocBH_LoaiNhaKhac"=>true,
            "thongKeTaiSanVaPhamViDuocBH_SoGCNQSDD_QSDNO"=>"string",
            "thongKeTaiSanVaPhamViDuocBH_LoaiNhaLyDoKhac"=>"string",
            "noiDungBaoHiem_DiaDiemBaoHiem_SoLuong"=>0,
            "noiDungBaoHiem_DiaDiemBaoHiem_GiaTriThucTe"=>0,
            "noiDungBaoHiem_DiaDiemBaoHiem_GiaTriThamGiaBH"=>0,
            "thongKeTaiSanVaPhamViDuocBH_NgayHieuLuc"=>"2019-12-02T07:05:41.973Z",
            "thongKeTaiSanVaPhamViDuocBH_SoNamThamGiaBH"=>0,
            "thongKeTaiSanVaPhamViDuocBH_PhiBaoHiem"=>0,
            "thongKeTaiSanVaPhamViDuocBH_TaiSan"=>"string",
            "noiDungBaoHiem_ThongTinXe_TheoBienKiemSoat"=>true,
            "noiDungBaoHiem_ThongTinXe_LoaiNghiepVuXeId"=>"00000000-0000-0000-0000-000000000000",
            "noiDungBaoHiem_ThongTinXe_MucDichSuDungId"=>"00000000-0000-0000-0000-000000000000",
            "noiDungBaoHiem_ThongTinXe_LoaiPhuongTienId"=>"00000000-0000-0000-0000-000000000000",
            "noiDungBaoHiem_ThongTinXe_BienKiemSoat"=>"string",
            "noiDungBaoHiem_ThongTinXe_SoKhung"=>"string",
            "noiDungBaoHiem_ThongTinXe_SoMay"=>"string",
            "noiDungBaoHiem_ThongTinXe_HangXeId"=>"00000000-0000-0000-0000-000000000000",
            "noiDungBaoHiem_ThongTinXe_KieuXeId"=>"00000000-0000-0000-0000-000000000000",
            "noiDungBaoHiem_ThongTinXe_NamSanXuat"=>0,
            "noiDungBaoHiem_ThongTinXe_NamDangKi"=>0,
            "noiDungBaoHiem_ThongTinXe_SoChoNgoi"=>0,
            "noiDungBaoHiem_ThongTinXe_SoChoNgoiTruMot"=>0,
            "noiDungBaoHiem_ThongTinXe_TrongTai"=>0,
            "noiDungBaoHiem_ThongTinXe_SoNamSuDung"=>0,
            "noiDungBaoHiem_ThongTinXe_GiaThiTruong"=>0,
            "noiDungBaoHiem_ThongTinXe_NhienLieuId"=>"00000000-0000-0000-0000-000000000000",
            "noiDungBaoHiem_ThongTinXe_HopSoId"=>"00000000-0000-0000-0000-000000000000",
            "noiDungBaoHiem_ThongTinXe_DungTich"=>0,
            "noiDungBaoHiem_ThongTinXe_LoaiXeNhaNuocId"=>"00000000-0000-0000-0000-000000000000",
            "noiDungBaoHiem_NgayBatDauHieuLuc"=>"2019-12-02T07:05:41.973Z",
            "noiDungBaoHiem_GoiBaoHiemId"=>"00000000-0000-0000-0000-000000000000",
            "noiDungBaoHiem_ThongTinChuXe_ChuXeLaNguoiYeuCauBaoHiem"=>true,
            "noiDungBaoHiem_ThongTinChuXe_HoTen"=>"string",
            "noiDungBaoHiem_ThongTinChuXe_SoCMND"=>"string",
            "noiDungBaoHiem_ThongTinChuXe_DiaChi"=>"string",
            "noiDungBaoHiem_ThongTinChuXe_KhacVoiNguoiBH"=>true,
            "noiDungBaoHiem_ThongTinChuXe_GioiTinhId"=>"00000000-0000-0000-0000-000000000000",
            "noiDungBaoHiem_ThongTinChuXe_SoDienThoai"=>"string",
            "noiDungBaoHiem_ThongTinChuXe_DiaChi_ProvinceId"=>"00000000-0000-0000-0000-000000000000",
            "noiDungBaoHiem_ThongTinChuXe_DiaChi_DistrictId"=>"00000000-0000-0000-0000-000000000000",
            "noiDungBaoHiem_ThongTinChuXe_BienKiemSoat"=>"string",
            "noiDungBaoHiem_ThongTinChuXe_SoKhung"=>"string",
            "noiDungBaoHiem_ThongTinChuXe_SoMay"=>"string",
            "noiDungBaoHiem_VatChatXe"=>true,
            "noiDungBaoHiem_VatChatXe_SoTienBh"=>0,
            "noiDungBaoHiem_VatChatXe_TyLePhi"=>0,
            "noiDungBaoHiem_VatChatXe_LoaiMienThuongId"=>"00000000-0000-0000-0000-000000000000",
            "noiDungBaoHiem_VatChatXe_SoTienMienThuongId"=>"00000000-0000-0000-0000-000000000000",
            "noiDungBaoHiem_VatChatXe_PhiBaoHiem_VAT"=>0,
            "noiDungBaoHiem_VatChatXe_PhiBaoHiem"=>0,
            "noiDungBaoHiem_VatChatXe_TyLePhiTang"=>0,
            "noiDungBaoHiem_VatChatXe_PhiBaoHiemSauTang_VAT"=>0,
            "noiDungBaoHiem_VatChatXe_PhiBaoHiemSauTang"=>0,
            "noiDungBaoHiem_VatChatXe_DieuKhoanBoSungMoiThayCu"=>true,
            "noiDungBaoHiem_VatChatXe_DieuKhoanBoSungSuaChuaChinhHang"=>true,
            "noiDungBaoHiem_VatChatXe_DieuKhoanBoSungThuyKich"=>true,
            "noiDungBaoHiem_VatChatXe_DieuKhoanBoSungMoiThayCu_Value"=>0,
            "noiDungBaoHiem_VatChatXe_DieuKhoanBoSungSuaChuaChinhHang_Value"=>0,
            "noiDungBaoHiem_VatChatXe_DieuKhoanBoSungThuyKich_Value"=>0,
            "noiDungBaoHiem_TNDSBB"=>true,
            "noiDungBaoHiem_TNDSBB_DonGia"=>0,
            "noiDungBaoHiem_TNDSBB_SoTienBH"=>0,
            "noiDungBaoHiem_TNDSBB_PhiBH_VAT"=>0,
            "noiDungBaoHiem_TNDSBB_SoThangThamGiaBaoHiem"=>0,
            "noiDungBaoHiem_TNDSBB_NgayHieuLucBaoHiem"=>"2019-12-02T07:05:41.973Z",
            "noiDungBaoHiem_TNDSBB_NgayHieuLucBaoHiemDen"=>"2019-12-02T07:05:41.973Z",
            "noiDungBaoHiem_TNDSBB_PhiMotNam"=>0,
            "noiDungBaoHiem_TNDSHH"=>true,
            "noiDungBaoHiem_TNDSHH_MucTrachNhiem_Tan"=>0,
            "noiDungBaoHiem_TNDSHH_SoTienBH"=>0,
            "noiDungBaoHiem_TNDSHH_NgayHieuLucBaoHiem"=>"2019-12-02T07:05:41.973Z",
            "noiDungBaoHiem_TNDSHH_SoThangThamGiaBaoHiem"=>0,
            "noiDungBaoHiem_TNDSHH_NgayHieuLucBaoHiemDen"=>"2019-12-02T07:05:41.973Z",
            "noiDungBaoHiem_TNDSHH_TyLePhi"=>0,
            "noiDungBaoHiem_TNDSHH_PhiBH_VAT"=>0,
            "noiDungBaoHiem_TNDSHH_PhiBH"=>0,
            "noiDungBaoHiem_TaiNanNguoiNgoi"=>true,
            "noiDungBaoHiem_TaiNanNguoiNgoi_SoTienBH"=>0,
            "noiDungBaoHiem_TaiNanNguoiNgoi_SoThangThamGiaBaoHiem"=>0,
            "noiDungBaoHiem_TaiNanNguoiNgoi_NgayHieuLucBaoHiem"=>"2019-12-02T07:05:41.973Z",
            "noiDungBaoHiem_TaiNanNguoiNgoi_NgayHieuLucBaoHiemDen"=>"2019-12-02T07:05:41.973Z",
            "noiDungBaoHiem_TaiNanNguoiNgoi_TyLePhi"=>0,
            "noiDungBaoHiem_TaiNanNguoiNgoi_PhiBH_VAT"=>0,
            "noiDungBaoHiem_TaiNanNguoiNgoi_PhiBH"=>0,
            "noiDungBaoHiem_TNDSTN_PhiBHVAT"=>0,
            "noiDungBaoHiem_TNDSTN_Thue_VAT"=>0,
            "noiDungBaoHiem_TNDSTN_PhiBH"=>0,
            "noiDungBaoHiem_TNDSTN"=>true,
            "noiDungBaoHiem_TNDSTN_NgayHieuLucBaoHiem"=>"2019-12-02T07:05:41.973Z",
            "noiDungBaoHiem_TNDSTN_SoThangThamGiaBaoHiem"=>0,
            "noiDungBaoHiem_TNDSTN_NgayHieuLucBaoHiemDen"=>"2019-12-02T07:05:41.973Z",
            "noiDungBaoHiem_TNDSTN_NguoiThu3VeNguoi"=>true,
            "noiDungBaoHiem_TNDSTN_NguoiThu3VeNguoi_SoTienBH"=>0,
            "noiDungBaoHiem_TNDSTN_NguoiThu3VeNguoi_TyLePhi"=>0,
            "noiDungBaoHiem_TNDSTN_NguoiThu3VeNguoi_PhiBHVAT"=>0,
            "noiDungBaoHiem_TNDSTN_NguoiThu3VeNguoi_PhiBH"=>0,
            "noiDungBaoHiem_TNDSTN_NguoiThu3VeTaiSan"=>true,
            "noiDungBaoHiem_TNDSTN_NguoiThu3VeTaiSan_SoTienBH"=>0,
            "noiDungBaoHiem_TNDSTN_NguoiThu3VeTaiSan_PhiMotNam"=>0,
            "noiDungBaoHiem_TNDSTN_NguoiThu3VeTaiSan_PhiBHVAT"=>0,
            "noiDungBaoHiem_TNDSTN_NguoiThu3VeTaiSan_PhiBH"=>0,
            "noiDungBaoHiem_TNDSTN_HanhKhachTrenXe"=>true,
            "noiDungBaoHiem_TNDSTN_HanhKhachTrenXe_SoTienBH"=>0,
            "noiDungBaoHiem_TNDSTN_HanhKhachTrenXe_TyLePhi"=>0,
            "noiDungBaoHiem_TNDSTN_HanhKhachTrenXe_PhiBHVAT"=>0,
            "noiDungBaoHiem_TNDSTN_HanhKhachTrenXe_PhiBH"=>0,
            "noiDungBaoHiem_VatChatXe_Thue_VAT"=>0,
            "noiDungBaoHiem_VatChatXe_ThueSauTang_VAT"=>0,
            "noiDungBaoHiem_VatChatXe_TyLeHoaHong"=>0,
            "noiDungBaoHiem_VatChatXe_TyLeHoTroDaiLy"=>0,
            "noiDungBaoHiem_VatChatXe_TyLePhiDichVu"=>0,
            "noiDungBaoHiem_VatChatXe_HoaHong"=>0,
            "noiDungBaoHiem_VatChatXe_HoTroDaiLy"=>0,
            "noiDungBaoHiem_VatChatXe_PhiDichVu"=>0,
            "noiDungBaoHiem_TNDSBB_Thue_VAT"=>0,
            "noiDungBaoHiem_TNDSBB_TyLeHoaHong"=>0,
            "noiDungBaoHiem_TNDSBB_TyLeHoTroDaiLy"=>0,
            "noiDungBaoHiem_TNDSBB_TyLePhiDichVu"=>0,
            "noiDungBaoHiem_TNDSBB_HoaHong"=>0,
            "noiDungBaoHiem_TNDSBB_HoTroDaiLy"=>0,
            "noiDungBaoHiem_TNDSBB_PhiDichVu"=>0,
            "noiDungBaoHiem_TaiNanNguoiNgoi_Thue_VAT"=>0,
            "noiDungBaoHiem_TaiNanNguoiNgoi_TyLeHoaHong"=>0,
            "noiDungBaoHiem_TaiNanNguoiNgoi_TyLeHoTroDaiLy"=>0,
            "noiDungBaoHiem_TaiNanNguoiNgoi_TyLePhiDichVu"=>0,
            "noiDungBaoHiem_TaiNanNguoiNgoi_HoaHong"=>0,
            "noiDungBaoHiem_TaiNanNguoiNgoi_HoTroDaiLy"=>0,
            "noiDungBaoHiem_TaiNanNguoiNgoi_PhiDichVu"=>0,
            "noiDungBaoHiem_TNDSHH_Thue_VAT"=>0,
            "noiDungBaoHiem_TNDSHH_TyLeHoaHong"=>0,
            "noiDungBaoHiem_TNDSHH_TyLeHoTroDaiLy"=>0,
            "noiDungBaoHiem_TNDSHH_TyLePhiDichVu"=>0,
            "noiDungBaoHiem_TNDSHH_HoaHong"=>0,
            "noiDungBaoHiem_TNDSHH_HoTroDaiLy"=>0,
            "noiDungBaoHiem_TNDSHH_PhiDichVu"=>0,
            "noiDungBaoHiem_TNDSTN_NguoiThu3VeNguoi_Thue_VAT"=>0,
            "noiDungBaoHiem_TNDSTN_NguoiThu3VeNguoi_TyLeHoaHong"=>0,
            "noiDungBaoHiem_TNDSTN_NguoiThu3VeNguoi_TyLeHoTroDaiLy"=>0,
            "noiDungBaoHiem_TNDSTN_NguoiThu3VeNguoi_TyLePhiDichVu"=>0,
            "noiDungBaoHiem_TNDSTN_NguoiThu3VeNguoi_HoaHong"=>0,
            "noiDungBaoHiem_TNDSTN_NguoiThu3VeNguoi_HoTroDaiLy"=>0,
            "noiDungBaoHiem_TNDSTN_NguoiThu3VeNguoi_PhiDichVu"=>0,
            "noiDungBaoHiem_TNDSTN_NguoiThu3VeTaiSan_Thue_VAT"=>0,
            "noiDungBaoHiem_TNDSTN_NguoiThu3VeTaiSan_TyLeHoaHong"=>0,
            "noiDungBaoHiem_TNDSTN_NguoiThu3VeTaiSan_TyLeHoTroDaiLy"=>0,
            "noiDungBaoHiem_TNDSTN_NguoiThu3VeTaiSan_TyLePhiDichVu"=>0,
            "noiDungBaoHiem_TNDSTN_NguoiThu3VeTaiSan_HoaHong"=>0,
            "noiDungBaoHiem_TNDSTN_NguoiThu3VeTaiSan_HoTroDaiLy"=>0,
            "noiDungBaoHiem_TNDSTN_NguoiThu3VeTaiSan_PhiDichVu"=>0,
            "noiDungBaoHiem_TNDSTN_HanhKhachTrenXe_Thue_VAT"=>0,
            "noiDungBaoHiem_TNDSTN_HanhKhachTrenXe_TyLeHoaHong"=>0,
            "noiDungBaoHiem_TNDSTN_HanhKhachTrenXe_TyLeHoTroDaiLy"=>0,
            "noiDungBaoHiem_TNDSTN_HanhKhachTrenXe_TyLePhiDichVu"=>0,
            "noiDungBaoHiem_TNDSTN_HanhKhachTrenXe_HoaHong"=>0,
            "noiDungBaoHiem_TNDSTN_HanhKhachTrenXe_HoTroDaiLy"=>0,
            "noiDungBaoHiem_TNDSTN_HanhKhachTrenXe_PhiDichVu"=>0,
            "noiDungBaoHiem_Thue_VAT"=>0,
            "noiDungBaoHiem_ThongTinChuCanHo_HoTen"=>"string",
            "noiDungBaoHiem_ThongTinChuCanHo_GioiTinhId"=>"00000000-0000-0000-0000-000000000000",
            "noiDungBaoHiem_ThongTinChuCanHo_SoDienThoai"=>"string",
            "noiDungBaoHiem_ThongTinChuCanHo_SoCMND"=>"string",
            "noiDungBaoHiem_ThongTinChuCanHo_CanSo"=>"string",
            "noiDungBaoHiem_ThongTinChuCanHo_TangSo"=>"string",
            "noiDungBaoHiem_ThongTinChuCanHo_TenToaNha"=>"string",
            "noiDungBaoHiem_ThongTinChuCanHo_TenChungCu"=>"string",
            "noiDungBaoHiem_ThongTinChuCanHo_DiaChi"=>"string",
            "noiDungBaoHiem_ThongTinChuCanHo_DiaChi_DistrictId"=>"00000000-0000-0000-0000-000000000000",
            "noiDungBaoHiem_ThongTinChuCanHo_DiaChi_ProvinceId"=>"00000000-0000-0000-0000-00000000000",
            "noiDungBaoHiem_ThongTinChuCanHo_GiaTriCanHo"=>"string",
            "noiDungBaoHiem_ThongTinChuCanHo_KhacVoiNguoiBH"=>"string",
            "thongTinTaiSanTrongNha"=>"string",
            "thongTinXeMayDuocBaoHiem"=>"string",
            "danhSachNguoiDuocBH"=>"string",
            "bankAccountBranch"=>"string",
            "transactionPaymentAmount"=>0,
            "thongTinChung_SoTienDaThanhToan"=>0 
        ];

      return $this->api->apiPost($this->userInfo['token'], "billingVimo/api_gci",$arr_post);
     }
      public function view_payment_gci()
    {
            //var_dump($status_asset); die;
        $payment= $this->do_payment_gci();
      var_dump($payment); die;
        if (!empty($payment->status) && $payment->status == 200) {
            $this->data['payment'] = $payment->data;
        } else {
            $this->data['payment'] = array();
        }
        //var_dump($this->data['asset']->property_infor[0]->value); die;
        $this->data['template'] = 'page/binding/billding_gci';
        $this->load->view('template', isset($this->data) ? $this->data : NULL);
    }
    // truy van hoa don
	public function getTransactionQueryBill() {
		$data = $this->input->post();
		$data['service_code'] = !empty($data['service_code']) ? $this->security->xss_clean($data['service_code']) : "";
		$data['publisher_code'] = !empty($data['publisher_code']) ? $this->security->xss_clean($data['publisher_code']) : "";
        $data['customer_code'] = !empty($data['customer_code']) ? $this->security->xss_clean(trim($data['customer_code'])) : "";
        if(empty( $data['customer_code'])){
            $this->pushJson('200', json_encode(array("status" => "400", "msg" => $this->lang->line('Customer_code_cannot_be_empty'))));
            return;
        }
		$mc_request_id = "TTHD_".$data['publisher_code']."_".uniqid();
		//Encrypt TripleDes
		$libTripleDes = new TripleDes();
		$secretKey = $libTripleDes->Encrypt(json_encode($data), $this->config->item("TRIPLEDES_KEY"));
		$dataPost = array(
			"mc_request_id" => $mc_request_id,
			"service_code" => !empty($data['service_code']) ? $data['service_code'] : "",
			"publisher" => !empty($data['publisher_code']) ? $data['publisher_code'] : "",
			"customer_code" => !empty($data['customer_code']) ? $data['customer_code'] : "",
			"created_by" => $this->user['email'],
			"secret_key" => $secretKey,

        );
        $return = $this->api->apiPost($this->user['token'], "billingVimo/query_bill", $dataPost);
		if(!empty($return->status) && $return->status == 200){
            $billDetail = !empty($return->data->data->billDetail) ?  $return->data->data->billDetail : array();
            $customerInfo = !empty($return->data->data->customerInfo) ?  $return->data->data->customerInfo : array();
            $data = array(
                "billDetail" =>  $billDetail,
                "customerInfo" =>  $customerInfo
            );
			
            $this->pushJson('200', json_encode(array("status" => "200", "data" => $data,"msg" => $return->data->error_message, "dataPost" => $dataPost)));
            return;

		}else{
            $error_code = !empty($return->data->error_code) ? $return->data->error_code : "01";
            if($error_code == '26'){
                $msg = $this->lang->line('bill_not_found');
            }else{
                $msg = $this->lang->line('Invoice_query_failed');
            }

            $this->pushJson('200', json_encode(array("status" => "400","return" => $return, "msg" => $msg, "dataPost" => $dataPost)));
            return;
		}
    }
    
    public function listCart(){
        $listCart = $this->cart->contents();
        $this->data["listCart"] = $listCart;
        $this->data["pageName"] = $this->lang->line('Information_line');
        $this->data['template'] = 'page/billing/order_cart';
        $this->load->view('template', isset($this->data)?$this->data:NULL);
    }

    public function addCart(){
        $data = $this->input->post();
        $data['service_code'] = !empty($data['service_code']) ? $this->security->xss_clean($data['service_code']) : "";
        $data['publisher_code'] = !empty($data['publisher_code']) ? $this->security->xss_clean($data['publisher_code']) : "";
        $data['customer_code'] = !empty($data['customer_code']) ? $this->security->xss_clean($data['customer_code']) : "";
        $data['service_name'] = !empty($data['sevice_name_vimo']) ? $this->security->xss_clean($data['sevice_name_vimo']) : "";
        $data['publisher_name'] = !empty($data['publisher_name']) ? $this->security->xss_clean($data['publisher_name']) : "";
        $data['total_amount_billing'] = !empty($data['total_amount_billing']) ? $this->security->xss_clean($data['total_amount_billing']) : "";
        $data['arrBillingDetaile'] = !empty($data['arrBillingDetaile']) ? $this->security->xss_clean($data['arrBillingDetaile']) : "";
        $data['arrCustomerInfor'] = !empty($data['arrCustomerInfor']) ? $this->security->xss_clean($data['arrCustomerInfor']) : "";
        $cart_id = "Cart_".$data['service_code']."_".$data['publisher_code']."_".uniqid();
        $data['qty'] = !empty($data['qty']) ? $this->security->xss_clean($data['qty']) : 1;

        if($data['service_code'] == 'TOPUP_TELCO_PREPAID' || $data['service_code'] == 'TOPUP_TELCO_POSTPAID'){
            if(empty($data['customer_code'])){
                $this->pushJson('200', json_encode(array("status" => "400", "msg" => $this->lang->line('Phone_number_cannot_empty'))));
                return;
            }
            if(!preg_match("/^[0-9]{9,11}$/", $data['customer_code'])) {
                $this->pushJson('200', json_encode(array("status" => "400", "msg" => $this->lang->line('phone_number_not_in_correct_format'))));
                return;
            }
        }
        if($data['service_code'] == 'TOPUP_GAME' ){
            if(empty($data['customer_code'])){
                $this->pushJson('200', json_encode(array("status" => "400", "msg" => $this->lang->line('account_cannot_empty'))));
                return;
            }
        }
     
        $cartData = array(
            'id' => $cart_id,
            'qty' => $data['qty'],
            'service_code' => $data['service_code'],
            'name' => $data['service_name'],
            'publisher_code' => $data['publisher_code'],
            'publisher_name' => $data['publisher_name'],
            'price' => $data['total_amount_billing'],
            'arrBillingDetaile' => $data['arrBillingDetaile'],
            'customer_code' => $data['customer_code'],
            'customer_infor' =>  $data['arrCustomerInfor'],
        
        );
        // var_dump($cartData);die;
        $this->cart->product_name_rules = '[:print:]';
        $this->cart->insert($cartData);
        $this->pushJson('200', json_encode(array("status" => "200", "msg" => "add cart thành công")));
        return;
    }
    
    public function paymentMethod(){
        $item = $this->cart->total_items();
        if($item == 0){
            redirect('VimoBilling');
        }
         $groupRoles = $this->api->apiPost($this->user['token'], "groupRole/getGroupRole", array("user_id" => $this->user['id']));
        if (!empty($groupRoles->status) && $groupRoles->status == 200) {
            $this->data['groupRoles'] = $groupRoles->data;
        } else {
            $this->data['groupRoles'] = array();
        }
        $storeData = $this->api->apiPost($this->userInfo['token'], "store/get_all", array());
        if (!empty($storeData->status) && $storeData->status == 200) {
            $this->data['storeData'] = $storeData->data;
        } else {
            $this->data['storeData'] = array();
        }
        $this->data["pageName"] = $this->lang->line('Information_line');
        $this->data['template'] = 'page/billing/payment_method';
        $this->load->view('template', isset($this->data)?$this->data:NULL);
    }

    public function doPayment(){
        $data = $this->input->post();
        $data['customer_bill_phone'] = !empty($data['customer_bill_phone']) ? $this->security->xss_clean($data['customer_bill_phone']) : "";
        $data['customer_bill_name'] = !empty($data['customer_bill_name']) ? $this->security->xss_clean($data['customer_bill_name']) : "";
        $store_id = !empty($data['store_id']) ? $this->security->xss_clean($data['store_id']) : "";
        $store_name = !empty($data['store_name']) ? $this->security->xss_clean($data['store_name']) : "";
        if(empty($data['customer_bill_phone'])){
            $this->pushJson('200', json_encode(array("status" => "400", "msg" => $this->lang->line('Phone_number_cannot_empty'))));
            return;
        }
        if(!preg_match("/^[0-9]{9,11}$/", $data['customer_bill_phone'])) {
            $this->pushJson('200', json_encode(array("status" => "400", "msg" => $this->lang->line('phone_number_not_in_correct_format'))));
            return;
        }
        if(empty($data['customer_bill_name'])){
            $this->pushJson('200', json_encode(array("status" => "400", "msg" => $this->lang->line('Your_name_must_empty'))));
            return;
        }
        $listCart = $this->cart->contents();
        $order = array();
        foreach($listCart as $key => $value){
           // hóa đơn điện
      
            if($value['service_code'] == 'BILL_ELECTRIC'){
                $arrBillingDetaile = !empty($value['arrBillingDetaile']) ? $value['arrBillingDetaile'] : array();
                $arrBillings = json_decode($arrBillingDetaile);
                $dataBill = array();
                foreach($arrBillings as $key1 => $bill){
                    $mc_request_bill = "TTHD_".uniqid();
                    $bill = array(
                        'mc_request_id' => $mc_request_bill,
                        'money' => $bill->amount,
                        'bill_payment' => array(
                            'billNumber' => $bill->billNumber,
							'period' => $bill->period,
							'amount' => $bill->amount,
							'billType' => $bill->billType,
							'otherInfo' => $bill->otherInfo,
                        )
                    );
                    array_push($dataBill, $bill);
                }
                $arrQueryBill = array(
                    'service_code' => $value['service_code'],
                    'publisher' =>  $value['publisher_code'],
                    'customer_code' =>  $value['customer_code'],
                    'data' => $dataBill,
                    'customer_infor' =>  json_decode($value['customer_infor']),
                );
                array_push($order, $arrQueryBill);
            }
         
            // hóa đơn nước 
            if($value['service_code'] == 'BILL_WATER' || $value['service_code'] == 'BILL_FINANCE'){
                $mc_request_id = "TTHD_".uniqid();
                $arrBillingDetaile =   json_decode($value['arrBillingDetaile'])[0];
                $arrQueryBill = array(
                    'mc_request_id' => $mc_request_id,
                    'service_code' => $value['service_code'],
                    'publisher' => $value['publisher_code'],
                    'customer_code' => $value['customer_code'],
                    'money' =>  $value['subtotal'],
                    'bill_payment' => array(
                        'billNumber' => $arrBillingDetaile->billNumber,
                        'period' => $arrBillingDetaile->period,
                        'amount' =>  $value['subtotal'],
                        'billType' => $arrBillingDetaile->billType,
                        'otherInfo' => $arrBillingDetaile->otherInfo,
                    ),
                    'customer_infor' => json_decode($value['customer_infor']),
                );
                array_push($order, $arrQueryBill);

            }

            // mua mã thẻ điện thoại, game 
            if($value['service_code'] == 'PINCODE_TELCO' || $value['service_code'] == 'PINCODE_GAME'){
                $mc_request_id = "MUA_THE_".uniqid();
                $arrQueryBill = array(
                    'mc_request_id' => $mc_request_id,
                    'service_code' => $value['service_code'],
                    'publisher' => $value['publisher_code'],
                    'quantity' => $value['qty'],
                    'amount' => $value['price'],
                    'money' =>  $value['subtotal'],
                );
                array_push($order, $arrQueryBill);
            }

            //nap the điện thoại, game
            if($value['service_code'] == 'TOPUP_TELCO_PREPAID' || $value['service_code'] == 'TOPUP_TELCO_POSTPAID' || $value['service_code'] == 'TOPUP_GAME'){
                $mc_request_id = "MUA_THE_".uniqid();
                $arrQueryBill = array(
                    'mc_request_id' => $mc_request_id,
                    'service_code' => $value['service_code'],
                    'publisher' => $value['publisher_code'],
                    'receiver' => $value['customer_code'],
                    'quantity' => $value['qty'],
                    'amount' => $value['price'],
                    'money' =>  $value['subtotal'],
                );
                array_push($order, $arrQueryBill);
            }
         
        }
       
        //Encrypt TripleDes
        $libTripleDes = new TripleDes();
        $secretKey = $libTripleDes->Encrypt(json_encode($data), $this->config->item("TRIPLEDES_KEY"));
        $dataPost = array(
            "total" => $this->cart->total(),
            "payment_method" => 1,// 1:tiền mặt
            "store" => array(
				'id' => $store_id,
				'name' => $store_name,
			),
            "customer_bill_name" => $data['customer_bill_name'],
            "customer_bill_phone" => $data['customer_bill_phone'],
            "order" => $order,
            "created_by" => $this->user['email'],
            "secret_key" => $secretKey,

        );
        $return = $this->api->apiPost($this->user['token'], "transaction/create_transaction_order", $dataPost);

        if(!empty($return->status) && $return->status == 200){
            $this->cart->destroy();
            $this->pushJson('200', json_encode(array("status" => "200", "msg" => $this->lang->line('Create_successful_transaction'), 'url' => $return->url, "dataPost" => $dataPost,  "return" => $return)));
            return;

        }else{
            $this->pushJson('200', json_encode(array("status" => "401", "msg" => $this->lang->line('Create_failed_transaction'), "return" => $return, "dataPost" => $dataPost)));
            return;
        }

    }

    public function deleteCart(){
        
        $id = !empty($_POST["id"]) ? $_POST["id"] : "";
        $rowid = !empty($_POST['rowid'])? $_POST['rowid'] : "";

        $id = $this->security->xss_clean($id);
        $rowid = $this->security->xss_clean($rowid);

        try {
            $this->cart->update(array('rowid' => $rowid, 'qty' => 0));
            $total = $this->cart->total();
            $data = array(
                'res' => true, 
                'status' => "200",
                'msg' =>$this->lang->line('detele_success'),
                "total_items" => $this->cart->total_items(),
                'total_cart' => number_format($this->cart->total())." vnđ",
            );
            return $this->pushJson('200', json_encode($data));
        } catch (Exception $exception) {
            $data = array(
                'res' => false, 
                'status' => "400",
                'msg' => $this->lang->line('detele_failed'),
              
            );
            return $this->pushJson('200', json_encode($data));
        }
    }


    public function deleteAll(){
        $this->cart->destroy();
        $data = array(
            'res' => true, 
            'status' => "200",
			'msg' => $this->lang->line('detele_success'),
        );
        return $this->pushJson('200', json_encode($data));
    }

    private function pushJson($code, $data) {
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($code)
            ->set_output($data);
    }
}

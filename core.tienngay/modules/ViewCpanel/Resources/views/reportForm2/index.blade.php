@extends('viewcpanel::layouts.master')

@section('title', 'Báo cáo lịch sử thu hồi')

@section('css')
<link href="{{ asset('viewcpanel/css/reportForm3/report.css') }}" rel="stylesheet"/>
<style type="text/css">
    .modal-backdrop {
        display: none !important;
    }
</style>
@endsection

@section('content')
<section class="main-content">
    <div id="loading" class="theloading" style="display: none;">
        <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    </div>
    <div class="container" style="max-width: 95% !important">
        <h5 class="tilte_top_tabs">
            Báo cáo lịch sử thu hồi ( Form 2 )
        </h5>

        <div class="row" style="align-items: right;">
            <div class="col-xs-12 col-12">
                @include("viewcpanel::reportForm2.filter")
            </div>
        </div>
        <div class="middle table_tabs">
            <p style="color: #047734"><strong>Total:</strong> <span id="total"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Page:</strong> <span id="page"></span></p>
            <div class="table-responsive" style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr style="text-align: center">
                            <th scope="col" style="text-align: center; min-width: 10px;">
                                <input id="select-all" type="checkbox" data-attr='selected_all' name="selected_all">
                            </th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Ngày thanh toán</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Mã giao dịch ngân hàng</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Ngân hàng</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Phòng giao dịch thu tiền</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Mã phiếu ghi</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Mã hợp đồng</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Mã hợp đồng gốc</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Mã người vay</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Tên người vay</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền gốc đã thu hồi (GH/CC)</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền lãi đã thu hồi (GH/CC)</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí đã thu hồi (GH/CC)</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền còn phải thu (GH/CC)</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền thừa khi (GH/CC)</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền gốc đã thu hồi thực tế</th>   
                            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền lãi đã thu hồi thực tế</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí đã thu hồi thực tế</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí gia hạn đã thu hồi thực tế</th>   
                            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí chậm trả đã thu hồi thực tế</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí trước hạn đã thu hồi thực tế</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí quá hạn đã thu hồi thực tế</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Tổng phí đã thu hồi</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Tiền thừa</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Tiền thừa lũy kế</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Tiền thừa (Tất toán - GH - CC)</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Tổng tiền thu hồi</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền gốc đã miễn giảm</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền lãi đã miễn giảm</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí đã miễn giảm</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí gia hạn đã miễn giảm</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí chậm trả đã miễn giảm</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí trước hạn đã miễn giảm</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí quá hạn đã miễn giảm</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Tổng tiền được miễn giảm</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Tổng gốc phải trả khi tất toán hợp đồng</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Tổng lãi phải trả khi tất toán hợp đồng</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Tổng phí phải trả khi tất toán hợp đồng</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Tổng phí chậm trả phải trả khi tất toán hợp đồng</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Tổng phí phát sinh phải trả khi tất toán hợp đồng</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Phương thức thanh toán</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Loại thanh toán</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Hình thức trả lãi</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Tổng thu hồi lũy kế</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Tình trạng thanh lý</th>
                        </tr>
                    </thead>
                    <tbody align="center" id="listingTable">

                    </tbody>
                </table>
            </div>
        </div>
        <nav aria-label="Page navigation" style="margin-top: 20px;">
          <ul class="pagination justify-content-end">
            <li id="btn_prev" class="page-item">
              <a href="javascript:void(0);"  class="page-link">Previous</a>
            </li>
            <li id="btn_next" class="page-item">
              <a href="javascript:void(0);"  class="page-link" >Next</a>
            </li>
          </ul>
        </nav>
    </div>
</section>
<!-- clone object -->
<table id="clone-object" class="table table-striped" hidden >
    <thead>
        <tr style="text-align: center">
            <th style="text-align: center;">STT</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Ngày thanh toán</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Mã giao dịch ngân hàng</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Ngân hàng</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Phòng giao dịch thu tiền</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Mã phiếu ghi</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Mã hợp đồng</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Mã hợp đồng gốc</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Mã người vay</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tên người vay</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền gốc đã thu hồi (GH/CC)</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền lãi đã thu hồi (GH/CC)</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí đã thu hồi (GH/CC)</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền còn phải thu (GH/CC)</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền thừa khi (GH/CC)</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền gốc đã thu hồi thực tế</th>   
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền lãi đã thu hồi thực tế</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí đã thu hồi thực tế</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí gia hạn đã thu hồi thực tế</th>   
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí chậm trả đã thu hồi thực tế</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí trước hạn đã thu hồi thực tế</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí quá hạn đã thu hồi thực tế</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tổng phí đã thu hồi</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tiền thừa</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tiền thừa lũy kế</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tiền thừa (Tất toán - GH - CC)</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tổng tiền thu hồi</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền gốc đã miễn giảm</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền lãi đã miễn giảm</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí đã miễn giảm</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí gia hạn đã miễn giảm</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí chậm trả đã miễn giảm</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí trước hạn đã miễn giảm</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí quá hạn đã miễn giảm</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tổng tiền được miễn giảm</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tổng gốc phải trả khi tất toán hợp đồng</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tổng lãi phải trả khi tất toán hợp đồng</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tổng phí phải trả khi tất toán hợp đồng</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tổng phí chậm trả phải trả khi tất toán hợp đồng</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tổng phí phát sinh phải trả khi tất toán hợp đồng</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Phương thức thanh toán</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Loại thanh toán</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Hình thức trả lãi</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tổng thu hồi lũy kế</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tình trạng thanh lý</th>
        </tr>
    </thead>
    <tbody align="center" id="table-rows">
        <tr id="clone-item" data-id="">
            <td id="transaction_no" style="text-align: left;">
                <input id="selected_item" type="checkbox" class="selected_item" name="selected_item[]">
            </td>
            <td data-attr='ngay_thanh_toan' timestamp='true'></td>
            <td data-attr='ma_giao_dich_ngan_hang'></td>
            <td data-attr='ngan_hang'></td>
            <td data-attr='phong_giao_dich.name'></td>
            <td data-attr='ma_phieu_ghi'></td>
            <td data-attr='ma_hop_dong'></td>
            <td data-attr='ma_hop_dong_goc'></td>
            <td data-attr='cmt_nguoi_vay'></td>
            <td data-attr='ten_nguoi_vay'></td>
            <td data-attr='tien_goc_ghcc_da_thu_hoi' format-number='true'></td>
            <td data-attr='tien_lai_ghcc_da_thu_hoi' format-number='true'></td>
            <td data-attr='tien_phi_ghcc_da_thu_hoi' format-number='true'></td>
            <td data-attr='tien_ghcc_con_phai_thu' format-number='true'></td>
            <td data-attr='tien_thua_khi_ghcc' format-number='true'></td>
            <td data-attr='tien_goc_da_thu_hoi' format-number='true'></td>   
            <td data-attr='tien_lai_da_thu_hoi' format-number='true'></td>
            <td data-attr='tien_phi_da_thu_hoi' format-number='true'></td>
            <td data-attr='tien_phi_gia_han_da_thu_hoi' format-number='true'></td>   
            <td data-attr='tien_phi_cham_tra_da_thu_hoi' format-number='true'></td>
            <td data-attr='tien_phi_truoc_han_da_thu_hoi' format-number='true'></td>
            <td data-attr='tien_phi_qua_han_da_thu_hoi' format-number='true'></td>
            <td data-attr='tong_phi_da_thu_hoi' format-number='true'></td>
            <td data-attr='tien_thua' format-number='true'></td>
            <td data-attr='tien_thua_luy_ke' format-number='true'></td>
            <td data-attr='tien_thua_tat_toan_gia_han_co_cau' format-number='true'></td>
            <td data-attr='tong_thu_hoi_thuc_te' format-number='true'></td>
            <td data-attr='tien_goc_duoc_mien_giam' format-number='true'></td>
            <td data-attr='tien_lai_duoc_mien_giam' format-number='true'></td>
            <td data-attr='tien_phi_duoc_mien_giam' format-number='true'></td>
            <td data-attr='tien_phi_gia_han_duoc_mien_giam' format-number='true'></td>
            <td data-attr='tien_phi_chan_tra_duoc_mien_giam' format-number='true'></td>
            <td data-attr='tien_phi_truoc_han_duoc_mien_giam' format-number='true'></td>
            <td data-attr='tien_phi_qua_han_duoc_mien_giam' format-number='true'></td>
            <td data-attr='tien_mien_giam' format-number='true'></td>
            <td data-attr='tong_goc_phai_tra_khi_tat_toan_hop_dong' format-number='true'></td>
            <td data-attr='tong_lai_phai_tra_khi_tat_toan_hop_dong' format-number='true'></td>
            <td data-attr='tong_phi_phai_tra_khi_tat_toan_hop_dong' format-number='true'></td>
            <td data-attr='tong_phi_cham_tra_phai_tra_khi_tat_toan_hop_dong' format-number='true'></td>
            <td data-attr='tong_phi_phat_sinh_phai_tra_khi_tat_toan_hop_dong' format-number='true'></td>
            <td data-attr='phuong_thuc_thanh_toan'></td>
            <td data-attr='loai_thanh_toan'></td>
            <td data-attr='hinh_thuc_tra_lai'></td>
            <td data-attr='tong_thu_hoi_luy_ke' format-number='true'></td>
            <td data-attr='tinh_trang_thanh_ly'></td>
        </tr>
    </tbody>
</table>

<!-- export object -->
<table id="export-object" class="table table-striped" hidden >
    <thead>
        <tr style="text-align: center">
            <th style="text-align: center;">STT</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Ngày thanh toán</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Mã giao dịch ngân hàng</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Ngân hàng</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Phòng giao dịch thu tiền</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Mã phiếu ghi</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Mã hợp đồng</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Mã hợp đồng gốc</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Mã người vay</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tên người vay</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền gốc đã thu hồi (GH/CC)</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền lãi đã thu hồi (GH/CC)</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí đã thu hồi (GH/CC)</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền còn phải thu (GH/CC)</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền thừa khi (GH/CC)</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền gốc đã thu hồi thực tế</th>   
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền lãi đã thu hồi thực tế</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí đã thu hồi thực tế</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí gia hạn đã thu hồi thực tế</th>   
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí chậm trả đã thu hồi thực tế</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí trước hạn đã thu hồi thực tế</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí quá hạn đã thu hồi thực tế</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tổng phí đã thu hồi</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tiền thừa</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tiền thừa lũy kế</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tiền thừa (Tất toán - GH - CC)</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tổng tiền thu hồi</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền gốc đã miễn giảm</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền lãi đã miễn giảm</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí đã miễn giảm</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí gia hạn đã miễn giảm</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí chậm trả đã miễn giảm</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí trước hạn đã miễn giảm</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền phí quá hạn đã miễn giảm</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tổng tiền được miễn giảm</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tổng gốc phải trả khi tất toán hợp đồng</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tổng lãi phải trả khi tất toán hợp đồng</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tổng phí phải trả khi tất toán hợp đồng</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tổng phí chậm trả phải trả khi tất toán hợp đồng</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tổng phí phát sinh phải trả khi tất toán hợp đồng</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Phương thức thanh toán</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Loại thanh toán</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Hình thức trả lãi</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tổng thu hồi lũy kế</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tình trạng thanh lý</th>
            <th scope="col" style="text-align: center; min-width: 100px;" no-export></th>
        </tr>
    </thead>
    <tbody align="center" id="table-rows">
        <tr id="clone-item" data-id="" style="background: #037734, color: #fff">
            <td id="transaction_no" style="text-align: left;">
                <input id="selected_item" type="checkbox" class="selected_item" name="selected_item[]">
            </td>
            <td data-attr='ngay_thanh_toan' timestamp='true'></td>
            <td data-attr='ma_giao_dich_ngan_hang'></td>
            <td data-attr='ngan_hang'></td>
            <td data-attr='phong_giao_dich.name'></td>
            <td data-attr='ma_phieu_ghi' zero-before='true'></td>
            <td data-attr='ma_hop_dong'></td>
            <td data-attr='ma_hop_dong_goc'></td>
            <td data-attr='cmt_nguoi_vay'></td>
            <td data-attr='ten_nguoi_vay'></td>
            <td data-attr='tien_goc_ghcc_da_thu_hoi'></td>
            <td data-attr='tien_lai_ghcc_da_thu_hoi'></td>
            <td data-attr='tien_phi_ghcc_da_thu_hoi'></td>
            <td data-attr='tien_ghcc_con_phai_thu'></td>
            <td data-attr='tien_thua_khi_ghcc'></td>
            <td data-attr='tien_goc_da_thu_hoi'></td>   
            <td data-attr='tien_lai_da_thu_hoi'></td>
            <td data-attr='tien_phi_da_thu_hoi'></td>
            <td data-attr='tien_phi_gia_han_da_thu_hoi'></td>   
            <td data-attr='tien_phi_cham_tra_da_thu_hoi'></td>
            <td data-attr='tien_phi_truoc_han_da_thu_hoi'></td>
            <td data-attr='tien_phi_qua_han_da_thu_hoi'></td>
            <td data-attr='tong_phi_da_thu_hoi'></td>
            <td data-attr='tien_thua'></td>
            <td data-attr='tien_thua_luy_ke'></td>
            <td data-attr='tien_thua_tat_toan_gia_han_co_cau'></td>
            <td data-attr='tong_thu_hoi_thuc_te'></td>
            <td data-attr='tien_goc_duoc_mien_giam'></td>
            <td data-attr='tien_lai_duoc_mien_giam'></td>
            <td data-attr='tien_phi_duoc_mien_giam'></td>
            <td data-attr='tien_phi_gia_han_duoc_mien_giam'></td>
            <td data-attr='tien_phi_chan_tra_duoc_mien_giam'></td>
            <td data-attr='tien_phi_truoc_han_duoc_mien_giam'></td>
            <td data-attr='tien_phi_qua_han_duoc_mien_giam'></td>
            <td data-attr='tien_mien_giam'></td>
            <td data-attr='tong_goc_phai_tra_khi_tat_toan_hop_dong'></td>
            <td data-attr='tong_lai_phai_tra_khi_tat_toan_hop_dong'></td>
            <td data-attr='tong_phi_phai_tra_khi_tat_toan_hop_dong'></td>
            <td data-attr='tong_phi_cham_tra_phai_tra_khi_tat_toan_hop_dong'></td>
            <td data-attr='tong_phi_phat_sinh_phai_tra_khi_tat_toan_hop_dong'></td>
            <td data-attr='phuong_thuc_thanh_toan'></td>
            <td data-attr='loai_thanh_toan'></td>
            <td data-attr='hinh_thuc_tra_lai'></td>
            <td data-attr='tong_thu_hoi_luy_ke'></td>
            <td data-attr='tinh_trang_thanh_ly'></td>
        </tr>
    </tbody>
</table>
<div class="modal fade" id="errorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Error</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="msg_error"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modal_import" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
   aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div>
          <h3 class="text-primary ten_oto" style="text-align: left">
            Import ngày dừng tính lãi
          </h3>
        </div>
      </div>
      <div class="modal-body ">
        <input type="file" id ="file_import" name="import" class="form-control" placeholder="chọn file">
        <button class="btn btn-secondary btn-success" type="button" aria-expanded="false" id="downdload_import" style="font-size:unset;background-color: #3b62df;border-color: #3b62df;margin-top: 25px;"><i class="fa fa-download"></i>
          Download biểu mẫu 
        </button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
        <a href="" title="Xác nhận" class="company_xn btn btn-success" id="import_submit">Xác nhận</a>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="successModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Thành công</h5>
          </div>
          <div class="modal-body">
            <p class="msg_success text-success"></p>
          </div>
          <div class="modal-footer">
           
          </div>
        </div>
      </div>
    </div>
@endsection

@section('script')
<script type="text/javascript">
    var transactions = @json($results["data"]);
    console.log(transactions);
    $("#fillter-button").on("click", function (event) {
        event.stopPropagation();
        $("#fillter-content").toggle();
    })
    function getStatusName($val) {
        let $value = "";
        switch($val) {
          case 17:
            $value = "Đang vay";
            break;
          case 19:
            $value = "Đã tất toán";
            break;
          case 33:
            $value = "Đã gia hạn";
            break;
          case 34:
            $value = "Đã cơ cấu";
            break;
          default:
            $value = "";
        }
        return $value;
    }
    function customDate ($value) {
        if ($value > 0) {
            var date = new Date($value * 1000).toLocaleString('vi-VN', { year: 'numeric', month: '2-digit', day: '2-digit'});
            return "'" + date.slice(3,10);
        }
        return "";
    }
    function customDate2 ($value) {
        if ($value > 0) {
            var date = new Date($value * 1000).toLocaleString('vi-VN', { year: 'numeric', month: '2-digit', day: '2-digit'});
            return date.slice(3,10);
        }
        return "";
    }
    var dp = $("#select-time-2").datepicker( {
        format: "yyyy-mm",
        startView: "months",
        minViewMode: "months",
        autoclose: true
    });
    $("#clear-search-form").on("click", function (event) {
        event.preventDefault();
        document.getElementById("search-form").reset();
    });
    $("#close-search-form").on("click", function (event) {
        event.preventDefault();
        $("#fillter-content").hide();
    });
    $('body').on('click', function(e){
        if (e.target.id == "fillter-content" || $(e.target).parents("#fillter-content").length) {
            //do nothing
        } else {
            $("#fillter-content").hide();
        }
    })
</script>
<script type="text/javascript">
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
<script type="text/javascript" src="{{ asset('viewcpanel/js/xlsx.js') }}"></script>
<script type="text/javascript" src="{{ asset('viewcpanel/js/reportForm2/report.js') }}"></script>
@endsection

@extends('viewcpanel::layouts.master')

@section('title', 'Báo Cáo Doanh Thu Form 2&3')

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
            Báo Cáo Doanh Thu Form 2&3
        </h5>

        <div class="row" style="align-items: right;">
            <div class="col-xs-12 col-12">
                @include("viewcpanel::reportForm23.filter")
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
                            <th scope="col" style="text-align: center; min-width: 100px;">Tháng tính lãi</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Mã phiếu ghi</th>
                            <th scope="col" style="text-align: center; min-width: 350px;">Mã hợp đồng vay</th>
                            <th scope="col" style="text-align: center; min-width: 350px;">Mã hợp đồng gốc</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Thời hạn vay (kỳ)</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Thời hạn vay (ngày)</th>
                            <th scope="col" style="text-align: center; min-width: 150px;">Ngày giải ngân</th>
                            <th scope="col" style="text-align: center; min-width: 150px;">Ngày gia hạn</th>
                            <th scope="col" style="text-align: center; min-width: 150px;">Ngày cơ cấu</th>
                            <th scope="col" style="text-align: center; min-width: 150px;">Ngày đáo hạn</th>
                            <th scope="col" style="text-align: center; min-width: 150px;">Ngày tất toán</th>
                            <th scope="col" style="text-align: center; min-width: 300px;">Tên người vay</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Tiền lãi kỳ</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Tổng lãi NĐT phát sinh</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Lãi NĐT trong hạn</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Lãi NĐT quá hạn</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Tổng phí phát sinh trong tháng</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Tổng phí trong hạn PS trong kỳ</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Tổng phí quá hạn PS trong kỳ</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Công ty</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Ghi chú</th>
                            <th scope="col" style="text-align: center; min-width: 50px;">Ngày chậm trả</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền lãi NĐT phải trả hàng kỳ trong hạn HĐ</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền lãi NĐT phải trả hàng kỳ quá hạn HĐ</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Số lãi thực thu</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Số hạch toán lãi NĐT</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Lãi NĐT ngoại bảng trong hạn HĐ</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Lãi NĐT ngoại bảng ngoài hạn HĐ</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Số phí thực thu</th>
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
            <th scope="col" style="text-align: center; min-width: 100px;">Tháng tính lãi</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Mã phiếu ghi</th>
            <th scope="col" style="text-align: center; min-width: 350px;">Mã hợp đồng vay</th>
            <th scope="col" style="text-align: center; min-width: 350px;">Mã hợp đồng gốc</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Thời hạn vay (kỳ)</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Thời hạn vay (ngày)</th>
            <th scope="col" style="text-align: center; min-width: 150px;">Ngày giải ngân</th>
            <th scope="col" style="text-align: center; min-width: 150px;">Ngày gia hạn</th>
            <th scope="col" style="text-align: center; min-width: 150px;">Ngày cơ cấu</th>
            <th scope="col" style="text-align: center; min-width: 150px;">Ngày đáo hạn</th>
            <th scope="col" style="text-align: center; min-width: 150px;">Ngày tất toán</th>
            <th scope="col" style="text-align: center; min-width: 300px;">Tên người vay</th>
            <th scope="col" style="text-align: center; min-width: 100;">Tiền lãi kỳ</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tổng lãi NĐT phát sinh</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Lãi NĐT trong hạn</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Lãi NĐT quá hạn</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tổng phí phát sinh trong tháng</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tổng phí trong hạn PS trong kỳ</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tổng phí quá hạn PS trong kỳ</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Công ty</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Ghi chú</th>
            <th scope="col" style="text-align: center; min-width: 50px;">Ngày chậm trả</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền lãi NĐT phải trả hàng kỳ trong hạn HĐ</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền lãi NĐT phải trả hàng kỳ quá hạn HĐ</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số lãi thực thu</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số hạch toán lãi NĐT</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Lãi NĐT ngoại bảng trong hạn HĐ</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Lãi NĐT ngoại bảng ngoài hạn HĐ</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số phí thực thu</th>
        </tr>
    </thead>
    <tbody align="center" id="table-rows">
        <tr id="clone-item" data-id="">
            <td id="transaction_no" style="text-align: left;">
                <input id="selected_item" type="checkbox" class="selected_item" name="selected_item[]">
            </td>
            <td data-attr='thang_bao_cao' func="customDate2"></td>
            <td data-attr='ma_phieu_ghi'></td>
            <td data-attr='ma_hop_dong'></td>
            <td data-attr='ma_hop_dong_goc'></td>
            <td data-attr='thoi_han_vay_thang'></td>
            <td data-attr='thoi_han_vay_ngay'></td>
            <td data-attr='ngay_giai_ngan' timestamp='true'></td>
            <td data-attr='ngay_gia_han' timestamp='true'></td>
            <td data-attr='ngay_co_cau' timestamp='true'></td>
            <td data-attr='ngay_dao_han' timestamp='true'></td>
            <td data-attr='ngay_tat_toan' timestamp='true'></td>
            <td data-attr='ten_nguoi_vay'></td>
            <td data-attr='tien_lai_ky' format-number='true'></td>
            <td data-attr='lai_phat_sinh_trong_thang' format-number='true'></td>
            <td data-attr='so_tien_lai_NDT_trong_han' format-number='true'></td>
            <td data-attr='lai_qua_han' format-number='true'></td>
            <td data-attr='tong_phi_phat_sinh' format-number='true'></td>
            <td data-attr='tong_phi_trong_han_ps_trong_ky' format-number='true'></td>
            <td data-attr='tong_phi_qua_han_ps_trong_ky' format-number='true'></td>
            <td data-attr='store_company' func="getCompanyName"></td>
            <td data-attr='ghi_chu'></td>
            <td data-attr='ngay_cham_tra' format-number='true'></td>
            <td data-attr='so_tien_lai_NDT_phai_tra_hang_ky' format-number='true'></td>
            <td data-attr='lai_qua_han' format-number='true'></td>
            <td data-attr='so_lai_thuc_thu' format-number='true'></td>
            <td data-attr='so_hach_toan_lai_ndt' format-number='true'></td>
            <td data-attr='lai_ndt_ngoai_bang_trong_han_hd' format-number='true'></td>
            <td data-attr='lai_ndt_ngoai_bang_ngoai_han_hd' format-number='true'></td>
            <td data-attr='so_phi_thuc_thu' format-number='true'></td>
        </tr>
    </tbody>
</table>

<!-- export object -->
<table id="export-object" class="table table-striped" hidden >
    <thead>
        <tr style="text-align: center">
            <th style="text-align: center;">STT</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tháng tính lãi</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Mã phiếu ghi</th>
            <th scope="col" style="text-align: center; min-width: 350px;">Mã hợp đồng vay</th>
            <th scope="col" style="text-align: center; min-width: 350px;">Mã hợp đồng gốc</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Thời hạn vay (kỳ)</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Thời hạn vay (ngày)</th>
            <th scope="col" style="text-align: center; min-width: 150px;">Ngày giải ngân</th>
            <th scope="col" style="text-align: center; min-width: 150px;">Ngày gia hạn</th>
            <th scope="col" style="text-align: center; min-width: 150px;">Ngày cơ cấu</th>
            <th scope="col" style="text-align: center; min-width: 150px;">Ngày đáo hạn</th>
            <th scope="col" style="text-align: center; min-width: 150px;">Ngày tất toán</th>
            <th scope="col" style="text-align: center; min-width: 300px;">Tên người vay</th>
            <th scope="col" style="text-align: center; min-width: 300px;">Tiền lãi kỳ</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tổng lãi NĐT phát sinh</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Lãi NĐT trong hạn</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Lãi NĐT quá hạn</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tổng phí phát sinh trong tháng</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tổng phí trong hạn PS trong kỳ</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tổng phí quá hạn PS trong kỳ</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Công ty</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Ghi chú</th>
            <th scope="col" style="text-align: center; min-width: 50px;">Ngày chậm trả</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền lãi NĐT phải trả hàng kỳ trong hạn HĐ</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số tiền lãi NĐT phải trả hàng kỳ quá hạn HĐ</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số lãi thực thu</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số hạch toán lãi NĐT</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Lãi NĐT ngoại bảng trong hạn HĐ</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Lãi NĐT ngoại bảng ngoài hạn HĐ</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số phí thực thu</th>
            <th scope="col" style="text-align: center; min-width: 100px;" no-export></th>
        </tr>
    </thead>
    <tbody align="center" id="table-rows">
        <tr id="clone-item" data-id="" style="background: #037734, color: #fff">
            <td id="transaction_no" style="text-align: left;">
                <input id="selected_item" type="checkbox" class="selected_item" name="selected_item[]">
            </td>
            <td data-attr='thang_bao_cao' func="customDate"></td>
            <td data-attr='ma_phieu_ghi' zero-before='true'></td>
            <td data-attr='ma_hop_dong'></td>
            <td data-attr='ma_hop_dong_goc'></td>
            <td data-attr='thoi_han_vay_thang'></td>
            <td data-attr='thoi_han_vay_ngay'></td>
            <td data-attr='ngay_giai_ngan' timestamp='true'></td>
            <td data-attr='ngay_gia_han' timestamp='true'></td>
            <td data-attr='ngay_co_cau' timestamp='true'></td>
            <td data-attr='ngay_dao_han' timestamp='true'></td>
            <td data-attr='ngay_tat_toan' timestamp='true'></td>
            <td data-attr='ten_nguoi_vay'></td>
            <td data-attr='tien_lai_ky' format-number='true'></td>
            <td data-attr='lai_phat_sinh_trong_thang' format-number='true'></td>
            <td data-attr='so_tien_lai_NDT_trong_han' format-number='true'></td>
            <td data-attr='lai_qua_han' format-number='true'></td>
            <td data-attr='tong_phi_phat_sinh' format-number='true'></td>
            <td data-attr='tong_phi_trong_han_ps_trong_ky' format-number='true'></td>
            <td data-attr='tong_phi_qua_han_ps_trong_ky' format-number='true'></td>
            <td data-attr='store_company' func="getCompanyName"></td>
            <td data-attr='ghi_chu'></td>
            <td data-attr='ngay_cham_tra' format-number='true'></td>
            <td data-attr='so_tien_lai_NDT_phai_tra_hang_ky' format-number='true'></td>
            <td data-attr='lai_qua_han' format-number='true'></td>
            <td data-attr='so_lai_thuc_thu' format-number='true'></td>
            <td data-attr='so_hach_toan_lai_ndt' format-number='true'></td>
            <td data-attr='lai_ndt_ngoai_bang_trong_han_hd' format-number='true'></td>
            <td data-attr='lai_ndt_ngoai_bang_ngoai_han_hd' format-number='true'></td>
            <td data-attr='so_phi_thuc_thu' format-number='true'></td>
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
    $('#import_record').on('click', function(e){
        $('#modal_import').modal('show');
        e.preventDefault();
    });
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
    });

    function getCompanyName(_value) {
        if (_value == 0 || _value == 1) {
            return "TCV";
        } else if ( _value == 2) {
            return "TCV DB";
        } else if (_value == 3) {
            return "TCV HCM";
        } else {
            return "";
        }
    }
</script>
<script type="text/javascript">
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
<script type="text/javascript" src="{{ asset('viewcpanel/js/xlsx.js') }}"></script>
<script type="text/javascript" src="{{ asset('viewcpanel/js/reportForm3/report.js') }}"></script>
@endsection

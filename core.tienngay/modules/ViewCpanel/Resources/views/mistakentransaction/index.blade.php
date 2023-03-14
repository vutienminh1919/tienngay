@extends('viewcpanel::layouts.master')

@section('title', 'Quản lý các lệnh phiếu thu duyệt định danh VPB lỗi')

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
            Quản lý các lệnh phiếu thu duyệt định danh VPB lỗi
        </h5>

        <div class="row" style="align-items: right;">
            <div class="col-xs-12 col-12">
                @include("viewcpanel::mistakentransaction.filter")
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
                            <th scope="col" style="text-align: center; min-width: 200px;">Mã HĐ</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Mã phiếu ghi</th>
                            <th scope="col" style="text-align: center; min-width: 200px;">Tên khách hàng</th>
                            <th scope="col" style="text-align: center; min-width: 200px;">Phòng giao dịch</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Mã giao dịch ngân hàng</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Phương thức thanh toán</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Ngân hàng</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Tiến trình xử lý</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Loại thanh toán</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Ngày khách thanh toán</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Ngày gạch nợ</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Tổng tiền thanh toán</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Mã phiếu thu</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Khu vực</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Note lý do fix ,Huỷ PT</th>
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
            <th scope="col" style="text-align: center; min-width: 100px;">Mã HĐ</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Mã phiếu ghi</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tên khách hàng</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Phòng giao dịch</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Mã giao dịch ngân hàng</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Phương thức thanh toán</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Ngân hàng</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tiến trình xử lý</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Loại thanh toán</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Ngày khách thanh toán</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Ngày gạch nợ</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tổng tiền thanh toán</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Mã phiếu thu</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Khu vực</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Note lý do fix ,Huỷ PT</th>
        </tr>
    </thead>
    <tbody align="center" id="table-rows">
        <tr id="clone-item" data-id="">
            <td id="transaction_no" style="text-align: left;">
                <input id="selected_item" type="checkbox" class="selected_item" name="selected_item[]">
            </td>
            <td data-attr='code_contract_disbursement'></td>
            <td data-attr='contract_code'></td>
            <td data-attr='customer_name'></td>
            <td data-attr='store_name'></td>
            <td data-attr='transactionId'></td>
            <td data-attr='payment_method'></td>
            <td data-attr='bank'></td>
            <td data-attr='status_text'></td>
            <td data-attr='type_payment_name'></td>
            <td data-attr='transactionDate'></td>
            <td data-attr='date_pay' func="customDate"></td>
            <td data-attr='amount' format-number='true'></td>
            <td data-attr='tn_trancode'></td>
            <td data-attr='store_code_area'></td>
            <td data-attr='approve_note'></td>
        </tr>
    </tbody>
</table>

<!-- export object -->
<table id="export-object" class="table table-striped" hidden >
    <thead>
        <tr style="text-align: center">
            <th style="text-align: center;">STT</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Mã HĐ</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Mã phiếu ghi</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tên khách hàng</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Phòng giao dịch</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Mã giao dịch ngân hàng</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Phương thức thanh toán</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Ngân hàng</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tiến trình xử lý</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Loại thanh toán</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Ngày khách thanh toán</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Ngày gạch nợ</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tổng tiền thanh toán</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Mã phiếu thu</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Khu vực</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Note lý do fix ,Huỷ PT</th>
            <th scope="col" style="text-align: center; min-width: 100px;" no-export></th>
        </tr>
    </thead>
    <tbody align="center" id="table-rows">
        <tr id="clone-item" data-id="" style="background: #037734, color: #fff">
            <td id="transaction_no" style="text-align: left;">
                <input id="selected_item" type="checkbox" class="selected_item" name="selected_item[]">
            </td>
            <td data-attr='code_contract_disbursement'></td>
            <td data-attr='contract_code' zero-before='true'></td>
            <td data-attr='customer_name'></td>
            <td data-attr='store_name'></td>
            <td data-attr='transactionId'></td>
            <td data-attr='payment_method'></td>
            <td data-attr='bank'></td>
            <td data-attr='status_text'></td>
            <td data-attr='type_payment_name'></td>
            <td data-attr='transactionDate'></td>
            <td data-attr='date_pay' func="customDate"></td>
            <td data-attr='amount' format-number='true'></td>
            <td data-attr='tn_trancode'></td>
            <td data-attr='store_code_area'></td>
            <td data-attr='approve_note'></td>
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
    var transactions = @json($transactions["data"]);
    console.log(transactions);
    $("#fillter-button").on("click", function (event) {
        event.stopPropagation();
        $("#fillter-content").toggle();
    })
    function customDate ($value) {
        $value = parseInt($value);
        if ($value > 0) {
            var options = {
                year: "numeric",
                month: "2-digit",
                day: "numeric"
            };
            var date = new Date($value * 1000);
            return date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
        }
        return "";
    }
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
    var dp = $("#start-date, #end-date").datepicker( {
        format: "yyyy-mm-dd",
        autoclose: true
    });
</script>
<script type="text/javascript" src="{{ asset('viewcpanel/js/xlsx.js') }}"></script>
<script type="text/javascript" src="{{ asset('viewcpanel/js/misstakenVPBTransaction/report.js') }}"></script>
@endsection

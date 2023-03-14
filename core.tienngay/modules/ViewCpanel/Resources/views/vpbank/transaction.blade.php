@extends('viewcpanel::layouts.master')

@section('title', 'Giao dịch VPBank')

@section('css')
<link href="{{ asset('viewcpanel/css/vpbank/transactions.css') }}" rel="stylesheet"/>
@endsection

@section('content')
<section class="main-content">
    <div id="loading" class="theloading" style="display: none;">
        <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    </div>
    <div class="container">
        <h5 class="tilte_top_tabs">
            Danh Sách Giao Dịch Từ VPBank
        </h5>
        <div class="top">
            <div class="row">
                <div class="title col-xs-4 col-4">
                    <div class="total-info">
                        <h6 class="total-transaction">
                            <span>Số GD: </span><span id="total_transaction">{{$transactions["totalTransaction"]}}</span>
                        </h6>
                        <h6 class="total-paid-amount" style="background: #EC1E24; border-color: #EC1E24">
                            <span>Tổng Tiền GD: </span><span id="total_paid_amount">{{$transactions["totalAmount"]}} VNĐ</span>
                        </h6>
                    </div>
                </div>
                <div class="col-xs-8 col-8">
                    <div class="row" style="margin-bottom: 15px;">
            <div class="col-md-6">
              <div class="box" style="width: 100%">
                <h6 class="tilte_top_tabs">
                    Báo Cáo VPBank - Tài Chính Việt
                </h6>
                <div class="box_content">
                    <div class="box_left">
                        <p style="text-align: left;font-weight: 600; font-size: 15px; color: #047734;">
                            Ngày
                        </p>
                    </div>
                    <div class="box_right">
                        <div class="button_functions btn-fitler">
                            <input style="height: 32px" type="text" class="form-control" name="tcv_report_date" id="tcv_report_date" placeholder="Tháng">

                        </div>
                        <button style="float: left; height: 32px" id="tcv_report_date_download" class="btn btn-secondary btn-success" type="button" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-download"></i>
                        </button>
                    </div>
                </div>

                <div class="box_content">

                    <div class="box_left">
                        <p style="text-align: left;font-weight: 600; font-size: 15px; color: #047734;">
                            Tháng
                        </p>
                    </div>
                    <div class="box_right">
                        <div class="button_functions btn-fitler" >
                            <input style="height: 32px" type="text" class="form-control" name="tcv_report_month" id="tcv_report_month" placeholder="Tháng">

                        </div>
                        <button style="float: left; height: 32px;" id="tcv_report_month_download" class="btn btn-secondary btn-success" type="button" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-download"></i>
                        </button>
                    </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="box" style="width: 100%">
                <h6 class="tilte_top_tabs">
                    Báo Cáo VPBank - Tài Chính Việt Đông Bắc
                </h6>
                <div class="box_content">
                    <div class="box_left">
                        <p style="text-align: left;font-weight: 600; font-size: 15px; color: #047734;">
                            Ngày
                        </p>
                    </div>
                    <div class="box_right">
                        <div class="button_functions btn-fitler">
                            <input style="height: 32px" type="text" class="form-control" name="tcvdb_report_date" id="tcvdb_report_date" placeholder="Tháng">

                        </div>
                        <button style="float: left; height: 32px" id="tcvdb_report_date_download" class="btn btn-secondary btn-success" type="button" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-download"></i>
                        </button>
                    </div>
                </div>

                <div class="box_content">

                    <div class="box_left">
                        <p style="text-align: left;font-weight: 600; font-size: 15px; color: #047734;">
                            Tháng
                        </p>
                    </div>
                    <div class="box_right">
                        <div class="button_functions btn-fitler" >
                            <input style="height: 32px" type="text" class="form-control" name="tcvdb_report_month" id="tcvdb_report_month" placeholder="Tháng">

                        </div>
                        <button style="float: left; height: 32px" id="tcvdb_report_month_download" class="btn btn-secondary btn-success" type="button" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-download"></i>
                        </button>
                    </div>
                </div>
              </div>
            </div>
        </div>
                </div>
            </div>
        </div>

        <div class="row" style="align-items: center;">
            <div class="col-3">
                <a href="{{$storeCodesUrl}}" style="margin-left: 5px" target="_blank">Danh Sách Phòng Giao Dịch</a>
            </div>
            <div class="col-xs-9 col-9">
                @include("viewcpanel::vpbank.filter")
            </div>
        </div>
        <div class="middle table_tabs">
            <p hidden>Page: <span id="page"></span></p>
            <div class="table-responsive" style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr style="text-align: center">
                            <th scope="col" style="text-align: center; min-width: 10px;">
                                <input id="select-all" type="checkbox" data-attr='selected_all' name="selected_all">
                            </th>
                            <th scope="col" style="text-align: center; min-width: 50px;">Mã GD <i data-bs-toggle="tooltip" title="" data-bs-original-title="Mã giao dịch của VPBank" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Tiền GD</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Số TK VAN <i data-bs-toggle="tooltip" title="" data-bs-original-title="Số tài khoản VPBank Vitual Account" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Tên TK VAN <i data-bs-toggle="tooltip" title="" data-bs-original-title="Tên tài khoản ảo thu hộ (Vitural Account Name)" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Mã Phiếu Ghi</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Thời Gian GD</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Trạng thái thanh toán</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Đối Soát</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">TT Giao dịch</th>
                            <th scope="col" style="text-align: center; min-width: 50px;">Chức Năng</th>
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
            <th scope="col" style="text-align: center;">Mã GD</th>
            <th scope="col" style="text-align: center">Số Tiền GD</th>
            <th scope="col" style="text-align: center">Số TK VAN</th>
            <th scope="col" style="text-align: center">Tên TK VAN</th>
            <th scope="col" style="text-align: center">Mã Phiếu Ghi</th>
            <th scope="col" style="text-align: center">Thời Gian Giao Dịch</th>
            <th scope="col" style="text-align: center">Trạng thái thanh toán</th>
            <th scope="col" style="text-align: center">Đối Soát</th>
            <th scope="col" style="text-align: center">TT Giao Dịch</th>
            <th scope="col" class="print-none no-export" style="text-align: center">Chức Năng</th>
        </tr>
    </thead>
    <tbody align="center" id="table-rows">
        <tr id="clone-item" data-id="">
            <td id="transaction_no" style="text-align: left;">
                <input id="selected_item" type="checkbox" class="selected_item" name="selected_item[]">
            </td>
            <td data-attr='transactionId'></td>
            <td data-attr='amount' format-number="true"></td>
            <td data-attr='virtualAccountNumber'></td>
            <td data-attr='van_name' style="min-width: 120px;"></td>
            <td data-attr='contract_code'></td>
            <td data-attr='transactionDate'></td>
            <td data-attr='status_text'></td>
            <td data-attr='daily_confirmed_text'></td>
            <td data-attr='tran_status_text'></td>
            <td class="print-none no-export" style="position: relative;">
                <button id="dropdownMenu2" style="min-height: 26px;" class="btn_bar" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="not_hover" src="{{ asset('menu-ico.svg') }}" alt="list">
                        <img class="hover" src="{{ asset('hover.svg') }}" alt="list">
                </button>
                <ul class="dropdown-menu dropdown-customer dropdown-item-detail" aria-labelledby="dropdownMenu2">
                    <li><a id="details-show-info__id__" data-id="" class="dropdown-item show_info_btn_chose" target="_blank" href="#">xem chi tiết</a></li>
                </ul>
            </td>
        </tr>
    </tbody>
</table>

<!-- export object -->
<table id="export-object" class="table table-striped" hidden >
    <thead>
        <tr style="text-align: center">
            <th style="text-align: center;">STT</th>
            <th scope="col"　style="text-align: center;">Mã GD</th>
            <th scope="col"　style="text-align: center;">Mã Phiếu Thu</th>
            <th scope="col"　style="text-align: center">Số Tiền GD</th>
            <th scope="col"　style="text-align: center">Số TK Chuyên Thu</th>
            <th scope="col"　style="text-align: center">Số TK VAN</th>
            <th scope="col"　style="text-align: center">Tên TK VAN</th>
            <th scope="col"　style="text-align: center">Mã Phiếu Ghi</th>
            <th scope="col"　style="text-align: center">Thời Gian Giao Dịch</th>

            <th scope="col"　style="text-align: center">Tên KH</th>
            <th scope="col"　style="text-align: center">Email</th>
            <th scope="col"　style="text-align: center">SĐT</th>
            <th scope="col"　style="text-align: center">CMND</th>
            <th scope="col"　style="text-align: center">Phòng GD</th>
            <th scope="col"　style="text-align: center">Mã PGD Quản Lý(VitualAltKey)</th>
            <th scope="col"　style="text-align: center">Tên PGD Quản Lý</th>

            <th scope="col"　style="text-align: center">Trạng thái thanh toán</th>
            <th scope="col"　style="text-align: center">Đối Soát</th>
            <th scope="col"　style="text-align: center">TT Giao Dịch</th>
            <th scope="col"　class="print-none no-export" style="text-align: center">Chức Năng</th>
        </tr>
    </thead>
    <tbody align="center" id="table-rows">
        <tr id="clone-item" data-id="">
            <td id="transaction_no" style="text-align: left;">
                <input id="selected_item" type="checkbox" class="selected_item" name="selected_item[]">
            </td>
            <td data-attr='transactionId'></td>
            <td data-attr='tn_trancode'></td>
            <td data-attr='amount'></td>
            <td data-attr='masterAccountNumber'></td>
            <td data-attr='virtualAccountNumber' zero-before='true'></td>
            <td data-attr='van_name'></td>
            <td data-attr='contract_code' zero-before='true'></td>
            <td data-attr='transactionDate'></td>

            <td data-attr='name'></td>
            <td data-attr='email'></td>
            <td data-attr='mobile' zero-before='true'></td>
            <td data-attr='identity_card' zero-before='true'></td>
            <td data-attr='store_name'></td>
            <td data-attr='vitualAltKeyCode' zero-before='true'></td>
            <td data-attr='vitualAltKeyName'></td>

            <td data-attr='status_text'></td>
            <td data-attr='daily_confirmed_text'></td>
            <td data-attr='tran_status_text'></td>
            <td class="print-none no-export" style="position: relative;">
                <button id="dropdownMenu2" style="min-height: 26px;" class="btn_bar" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="not_hover" src="{{ asset('menu-ico.svg') }}" alt="list">
                        <img class="hover" src="{{ asset('hover.svg') }}" alt="list">
                </button>
                <ul class="dropdown-menu dropdown-customer dropdown-item-detail" aria-labelledby="dropdownMenu2">
                    <li><a id="details-show-info__id__" data-id="" class="dropdown-item show_info_btn_chose" target="_blank" href="#">xem chi tiết</a></li>
                </ul>
            </td>
        </tr>
    </tbody>
</table>
<div id="errorModal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box danger">
                    <i class="fa fa-times"></i>
                </div>
                <h4 class="modal-title">Error</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <p class="msg_error"></p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $("#fillter-button").on("click", function (event) {
        event.stopPropagation();
        $("#fillter-content").toggle();
    })
    var dp = $("#start-date, #end-date").datepicker( {
        format: "yyyy-mm-dd",
        autoclose: true
    });
    var transactions = @json($transactions["data"]);
    var getListByMonthUrl = @json($getListByMonthUrl);
    var downloadReportUrl = @json($downloadReport);
    console.log(transactions);

    var dp2 = $("#tcv_report_date, #tcvdb_report_date").datepicker( {
        format: "yyyy-mm-dd",
        autoclose: true
    }).datepicker("setDate", new Date());

    var dp3 = $("#tcv_report_month, #tcvdb_report_month").datepicker( {
        format: "yyyy-mm",
        autoclose: true
    }).datepicker("setDate", new Date());

    $("#tcv_report_date_download").on("click", function (event) {
        event.preventDefault();
        $date = $("#tcv_report_date").val();
        window.open(downloadReportUrl + '?tcv_report_date=' + $date, '_blank');
    });
    $("#tcv_report_month_download").on("click", function (event) {
        event.preventDefault();
        $date = $("#tcv_report_month").val();
        window.open(downloadReportUrl + '?tcv_report_month=' + $date, '_blank');
    });
    $("#tcvdb_report_date_download").on("click", function (event) {
        event.preventDefault();
        $date = $("#tcvdb_report_date").val();
        window.open(downloadReportUrl + '?tcvdb_report_date=' + $date, '_blank');
    });
    $("#tcvdb_report_month_download").on("click", function (event) {
        event.preventDefault();
        $date = $("#tcvdb_report_month").val();
        window.open(downloadReportUrl + '?tcvdb_report_month=' + $date, '_blank');
    });
    $("#clear-search-form").on("click", function (event) {
        event.preventDefault();
        document.getElementById("search-form").reset();
    });
    $("#close-search-form").on("click", function (event) {
        event.preventDefault();
        $("#fillter-content").hide();
    });
</script>
<script type="text/javascript">
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
<script type="text/javascript" src="{{ asset('viewcpanel/js/xlsx.js') }}"></script>
<script type="text/javascript" src="{{ asset('viewcpanel/js/vpbank/transactions.js') }}"></script>
@endsection

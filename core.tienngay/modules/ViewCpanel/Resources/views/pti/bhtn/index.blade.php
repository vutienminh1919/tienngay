@extends('viewcpanel::layouts.master')

@section('title', 'PTI - Bảo Hiểm Tai Nạn Con Người')

@section('css')
<link href="{{ asset('viewcpanel/css/reportForm3/report.css') }}" rel="stylesheet"/>
@endsection

@section('content')
<section class="main-content">
    <div id="loading" class="theloading" style="display: none;">
        <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    </div>
    <div class="container" style="max-width: 95% !important">
        <h5 class="tilte_top_tabs">
            PTI - Bảo Hiểm Tai Nạn Con Người <span id="select-month">@if($export)({{$currentTime}})@endif</span>
        </h5>
        <div class="row" style="align-items: right;">
            <div class="col-xs-12 col-12">
                @include("viewcpanel::pti.bhtn.filter")
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
                            <th scope="col" style="text-align: center; min-width: 150px;">Tên KH</th>
                            @if (!$bn)
                            <th scope="col" style="text-align: center; min-width: 50px;">Mã Phiếu Ghi</th>
                            <th scope="col" style="text-align: center; min-width: 300px;">Mã HĐ</th>
                            <th scope="col" style="text-align: center; min-width: 70px;">Số Tiền Vay</th>
                            @endif
                            <th scope="col" style="text-align: center; min-width: 150px;">PGD</th>
                            <th scope="col" style="text-align: center; min-width: 150px;">Số CMT</th>
                            <th scope="col" style="text-align: center; min-width: 150px;">Email</th>
                            <th scope="col" style="text-align: center; min-width: 300px;">Địa chỉ</th>
                            <th scope="col" style="text-align: center; min-width: 50px;">Gói BH</th>
                            <th scope="col" style="text-align: center; min-width: 50px;">Giá Trị</th>
                            <th scope="col" style="text-align: center; min-width: 50px;">Phí</th>
                            <th scope="col" style="text-align: center; min-width: 50px;">Ngày HL</th>
                            <th scope="col" style="text-align: center; min-width: 50px;">Ngày KT</th>
                            <th scope="col" style="text-align: center; min-width: 300px;">Số HĐ PTI</th>
                            <th scope="col" style="text-align: center; min-width: 150px;">Số ID Kênh</th>
                            @if (!$bn)
                            <th scope="col" style="text-align: center; min-width: 50px;">Mã Phiếu Ghi</th>
                            <th scope="col" style="text-align: center; min-width: 300px;">Mã HĐ</th>
                            @endif
                            <th scope="col" style="text-align: center; min-width: 100px;">PGD</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Ngày Tạo</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Trạng Thái</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">Giấy CN</th>
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
            <th scope="col" style="text-align: center; min-width: 150px;">Tên KH</th>
            @if (!$bn)
            <th scope="col" style="text-align: center; min-width: 50px;">Mã Phiếu Ghi</th>
            <th scope="col" style="text-align: center; min-width: 300px;">Mã HĐ</th>
            <th scope="col" style="text-align: center; min-width: 70px;">Số Tiền Vay</th>
            @endif
            <th scope="col" style="text-align: center; min-width: 150px;">PGD</th>
            <th scope="col" style="text-align: center; min-width: 150px;">Số CMT</th>
            <th scope="col" style="text-align: center; min-width: 150px;">Email</th>
            <th scope="col" style="text-align: center; min-width: 300px;">Địa chỉ</th>
            <th scope="col" style="text-align: center; min-width: 50px;">Gói BH</th>
            <th scope="col" style="text-align: center; min-width: 50px;">Giá Trị</th>
            <th scope="col" style="text-align: center; min-width: 50px;">Phí</th>
            <th scope="col" style="text-align: center; min-width: 50px;">Ngày HL</th>
            <th scope="col" style="text-align: center; min-width: 50px;">Ngày KT</th>
            <th scope="col" style="text-align: center; min-width: 300px;">Số HĐ PTI</th>
            <th scope="col" style="text-align: center; min-width: 150px;">Số ID Kênh</th>
            @if (!$bn)
            <th scope="col" style="text-align: center; min-width: 50px;">Mã Phiếu Ghi</th>
            <th scope="col" style="text-align: center; min-width: 300px;">Mã HĐ</th>
            @endif
            <th scope="col" style="text-align: center; min-width: 100px;">PGD</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Ngày Tạo</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Trạng Thái</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Giấy CN</th>
        </tr>
    </thead>
    <tbody align="center" id="table-rows">
        <tr id="clone-item" data-id="">
            <td id="transaction_no" style="text-align: left;">
                <input id="selected_item" type="checkbox" class="selected_item" name="selected_item[]">
            </td>
            <td data-attr='pti_request.ten'></td>
            @if (!$bn)
            <td data-attr='code_contract'></td>
            <td data-attr='code_contract_disbursement'></td>
            <td data-attr='pti_request.contract_amount' format-number='true'></td>
            @endif
            <td data-attr='store.name'></td>
            <td data-attr='pti_request.so_cmt'></td>
            <td data-attr='pti_request.email'></td>
            <td data-attr='pti_request.dchi'></td>
            <td data-attr='pti_request.goi'></td>
            <td data-attr='pti_request.tien_bh' format-number='true'></td>
            <td data-attr='pti_request.phi' format-number='true'></td>
            <td data-attr='pti_request.ngay_hl' func="dateFormat"></td>
            <td data-attr='pti_request.ngay_kt' func="dateFormat"></td>
            <td data-attr='pti_info.so_hd_pti'></td>
            <td data-attr='pti_info.so_id_kenh'></td>
            @if (!$bn)
            <td data-attr='code_contract'></td>
            <td data-attr='code_contract_disbursement'></td>
            @endif
            <td data-attr='store.name'></td>
            <td data-attr='created_at' timestamp='true'></td>
            <td data-attr='pti_info.process' func="processLabel"></td>
            <td class="print-none no-export" data-attr='pti_info.so_id_pti' func="inGCN"></td>
        </tr>
    </tbody>
</table>

<!-- export object -->
<table id="export-object" class="table table-striped" hidden >
    <thead>
        <tr style="text-align: center">
            <th style="text-align: center;">STT</th>
            <th scope="col" style="text-align: center; min-width: 150px;">Tên KH</th>
            @if (!$bn)
            <th scope="col" style="text-align: center; min-width: 50px;">Mã Phiếu Ghi</th>
            <th scope="col" style="text-align: center; min-width: 300px;">Mã HĐ</th>
            <th scope="col" style="text-align: center; min-width: 70px;">Số Tiền Vay</th>
            @endif
            <th scope="col" style="text-align: center; min-width: 150px;">PGD</th>
            <th scope="col" style="text-align: center; min-width: 150px;">Số CMT</th>
            <th scope="col" style="text-align: center; min-width: 150px;">Email</th>
            <th scope="col" style="text-align: center; min-width: 300px;">Địa chỉ</th>
            <th scope="col" style="text-align: center; min-width: 50px;">Gói BH</th>
            <th scope="col" style="text-align: center; min-width: 50px;">Giá Trị</th>
            <th scope="col" style="text-align: center; min-width: 50px;">Phí</th>
            <th scope="col" style="text-align: center; min-width: 50px;">Ngày HL</th>
            <th scope="col" style="text-align: center; min-width: 50px;">Ngày KT</th>
            <th scope="col" style="text-align: center; min-width: 300px;">Số HĐ PTI</th>
            <th scope="col" style="text-align: center; min-width: 150px;">Số ID Kênh</th>
            @if (!$bn)
            <th scope="col" style="text-align: center; min-width: 50px;">Mã Phiếu Ghi</th>
            <th scope="col" style="text-align: center; min-width: 300px;">Mã HĐ</th>
            @endif
            <th scope="col" style="text-align: center; min-width: 100px;">PGD</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Ngày Tạo</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Trạng Thái</th>
            <th scope="col" style="text-align: center; min-width: 100px;" no-export></th>
        </tr>
    </thead>
    <tbody align="center" id="table-rows">
        <tr id="clone-item" data-id="" style="background: #037734; color: #fff">
            <td id="transaction_no" style="text-align: left;">
                <input id="selected_item" type="checkbox" class="selected_item" name="selected_item[]">
            </td>
            <td data-attr='pti_request.ten'></td>
            @if (!$bn)
            <td data-attr='code_contract' zero-before='true'></td>
            <td data-attr='code_contract_disbursement'></td>
            <td data-attr='pti_request.contract_amount' format-number='true'></td>
            @endif
            <td data-attr='store.name'></td>
            <td data-attr='pti_request.so_cmt'></td>
            <td data-attr='pti_request.email'></td>
            <td data-attr='pti_request.dchi'></td>
            <td data-attr='pti_request.goi'></td>
            <td data-attr='pti_request.tien_bh' format-number='true'></td>
            <td data-attr='pti_request.phi' format-number='true'></td>
            <td data-attr='pti_request.ngay_hl' func="dateFormat"></td>
            <td data-attr='pti_request.ngay_kt' func="dateFormat"></td>
            <td data-attr='pti_info.so_hd_pti'></td>
            <td data-attr='pti_info.so_id_kenh'></td>
            @if (!$bn)
            <td data-attr='code_contract' zero-before='true'></td>
            <td data-attr='code_contract_disbursement'></td>
            @endif
            <td data-attr='store.name'></td>
            <td data-attr='created_at' timestamp='true'></td>
            <td data-attr='pti_info.process' func="processLabel"></td>
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
@endsection

@section('script')
<script type="text/javascript">
    var transactions = @json($results);
    var tcvStores = @json($tcvStores);
    var tcvDbStores = @json($tcvDbStores);
    var tcvHcmStores = @json($tcvHcmStores);
    console.log(transactions);
    $("#fillter-button").on("click", function (event) {
        event.stopPropagation();
        $("#fillter-content").toggle();
    })
    var dp = $("#select-time-2").datepicker( {
        format: "yyyy-mm",
        startView: "months",
        minViewMode: "months",
        autoclose: true
    });
    var dp = $("#start-date, #end-date").datepicker( {
        format: "yyyy-mm-dd",
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
    function dateFormat(val, el) {
        return val.replace(/-/g, "/");
    }
    function inGCN(val, el) {
        var status = el.closest("tr").find("td[data-attr='pti_info.process']")[0].getAttribute('data-value');
        if (status == 'done' || status == 'confirmed') {
            el.append('<a class="" target="_blank" href="{{$exportGCN}}?so_id_pti='+val+'">xem</a>');
        }
    }
    function processLabel(val, el) {
        console.log(val);
        el.attr("data-value", val);
        if (val == 'done' || val == 'confirmed') {
            el.text("Thành công");
        } else {
            el.text(val);
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
<script type="text/javascript" src="{{ asset('viewcpanel/js/pti/index.js?v=20220824') }}"></script>
@endsection

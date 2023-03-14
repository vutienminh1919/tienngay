<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>DANH SÁCH ĐỐI SOÁT BỔ SUNG GIAO DỊCH TỪ MOMO</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}"/>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="{{ asset('viewcpanel/css/teacup.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('viewcpanel/css/paymentgateway/reconciliation-index.css') }}" rel="stylesheet"/>

    <!-- jQuery -->
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <!-- Bootstrap -->
    
</head>
<body>
<style type="text/css">
    .modal {
        top: 150px !important;
        bottom: auto !important;
        overflow: initial !important;
    }
</style>
<div class="right_col" role="main">
    <p hidden>Page: <span id="page"></span></p>
    <div id="loading" class="theloading" style="display: none;">
        <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    </div>
    <div class="col-xs-12 fix_to_col" id="fix_to_col">
        <div class="table_app_all">
            <div class="top">
                <div class="row">
                    <div class="title col-xs-9">
                        <h4 class="tilte_top_tabs">
                            DANH SÁCH ĐỐI SOÁT BỔ SUNG GIAO DỊCH MOMO
                        </h4>
                        <div class="total-info">
                            <h5 class="total-transaction">
                                <span>Tiền phải trả: </span><span id="totalPayAmount">{{$reconciliations["totalPayAmount"]}} VNĐ
                                </span>
                            </h5>
                            <h5 class="total-paid-amount">
                                <span>Tiền đã trả: </span><span id="totalPaidAmount">
                                {{$reconciliations["totalPaidAmount"]}} VNĐ</span>
                            </h5>
                            <h5 class="total-transaction-fee">
                                <span>Tiền còn lại: </span><span id="remainingAmount">
                                {{$reconciliations["remainingAmount"]}} VNĐ</span>
                            </h5>
                        </div>
                    </div>
                    <div class="col-xs-3 text-right">
                        @include('viewcpanel::transactionsReconciliation.filter')
                    </div>
                </div>
            </div>
            <div class="middle table_tabs">
                <div class="table-responsive">
                    <table id="data-table" class="table table-striped">
                        <thead>
                            <tr style="text-align: center">
                                <th style="text-align: center;">
                                    <input id="select-all" type="checkbox" data-attr='selected_all' name="selected_all">
                                </th>
                                <th style="text-align: center;">Mã ĐS</th>
                                <th style="text-align: center">Tiền phải trả</th>
                                <th style="text-align: center">Tiền đã trả</th>
                                <th style="text-align: center">Số tiền còn</th>
                                <th style="text-align: center">Thời gian tạo</th>
                                <th style="text-align: center">Ngày nhận tiền</th>
                                <th style="text-align: center">Trạng thái</th>
                                <th class="print-none no-export" style="text-align: center">Chức Năng</th>
                            </tr>
                        </thead>
                        <tbody align="center" id="listingTable">
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <nav aria-label="Page navigation example">
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
    </div>
</div>

<!-- clone object -->
<table id="clone-object" class="table table-striped" hidden >
    <thead>
        <tr style="text-align: center">
            <th style="text-align: center;">STT</th>
            <th style="text-align: center;">Mã ĐS</th>
            <th style="text-align: center">Tiền phải trả</th>
            <th style="text-align: center">Tiền đã trả</th>
            <th style="text-align: center">Số tiền còn</th>
            <th style="text-align: center">Thời gian tạo</th>
            <th style="text-align: center">Ngày nhận tiền</th>
            <th style="text-align: center">Trạng thái</th>
            <th class="print-none no-export" style="text-align: left">Chức Năng</th>
        </tr>
    </thead>
    <tbody align="center" id="listingTable">
        <tr id="reconciliation-item" data-id="">
            <td style="text-align: center;" data-attr="reconciliation_no">
                <input type="checkbox" class="selected_item" data-attr='selected_item' name="selected_item[]">
            </td>
            <td data-attr='code'></td>
            <td data-attr='pay_amount'></td>
            <td data-attr='paid_amount'></td>
            <td data-attr='remaining_amount'></td>
            <td data-attr='created_at'></td>
            <td data-attr='paid_date'></td>
            <td data-attr='status_text'></td>
            <td class="print-none no-export" style="position: relative;">
                <button style="min-height: 26px;" class="btn_bar dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <a id="details--" href="javascriptvoid:0">
                        <img class="not_hover" src="{{ asset('menu-ico.svg') }}" alt="list">
                        <img class="hover" src="{{ asset('hover.svg') }}" alt="list">
                    </a>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a id="details-show-info__id__" data-id="" class="dropdown-item show_info_btn_chose" target="_blank" href="#">xem chi tiết</a>
                </div>
            </td>
        </tr>
    </tbody>
</table>
<div id="successModal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content" style="border-top: 2px solid #2FB344;">
            <div class="modal-header">
                <div class="icon-box success">
                    <i class="fa fa-check"></i>
                </div>
                <h4 class="modal-title">Thành Công</h4>
                <p>Đã hoàn thành</p>
                <a style="min-height: auto;" href="javascript:(0)" class="btn btn-success modal_close" data-dismiss="modal">Đóng</a>
                </div>
            <div class="modal-body">
                <p class="msg_success"></p>
            </div>
        </div>
    </div>
</div>
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
<div id="modal-confirm" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-body">
                <p class="msg_success">Bạn có chắc chắn tạo đối soát không ?</p>
            </div>
            <div class="modal-footer">
                <button id="create-reconciliation" type="button" class="btn" data-dismiss="modal">Tạo</button>
                <button id="cancel" type="button" class="btn btn-primary" data-dismiss="modal">Huỷ</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('viewcpanel/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('viewcpanel/js/paymentgateway/reconciliation-index.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.list_items .items').click(function() {
            $('.dot_stick').removeClass('active');
            $(this).children().addClass('active');
            $('.list-source_data').animate({
                scrollTop: $(this).offset().top - 10
            }, 1000)
        })
    });
    $("#fillter-button").on("click", function (event) {
        event.stopPropagation();
        $("#fillter-content").toggle();
    })
    $(document).click(function() {
        var container = $("#fillter-content");
        if (!container.is(event.target) && !container.has(event.target).length) {
            container.hide();
        }
    });
    $('.modal_close').on('click', function(event) {
        $('.modal').hide();
    })
</script>
<script type="text/javascript">
    var reconciliations = {!! json_encode($reconciliations["data"]) !!};
    var getListByMonthUrl = {!! json_encode($getListByMonthUrl) !!};
    console.log(reconciliations);
</script>
</body>
</html>



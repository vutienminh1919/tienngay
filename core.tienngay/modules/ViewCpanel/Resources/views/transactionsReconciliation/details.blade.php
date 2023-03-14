<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>ĐỐI SOÁT CHI TIẾT</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}"/>
	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link href="{{ asset('viewcpanel/css/teacup.css') }}" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="{{ asset('viewcpanel/css/paymentgateway/reconciliation-details.css') }}" rel="stylesheet"/>

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
        @csrf
        <div class="table_app_all">
            <div class="top">
                <div class="row">
                    <div class="title col-xs-9 main-info">
                        <h4 class="tilte_top_tabs">
							<span>Mã Đối Soát: </span><span id="reconciliation-id">
                            {{ $result["details"]["code"] }}
                            </span>
						</h4>
                        <table class="table table-hover border-none">
                            <tbody>
                                <tr class="table-info">
                                    <td width="200px">Tiền phải trả:</td>
                                    <td>{{ number_format($result["details"]["pay_amount"]) }}</td>
                                    <td>Thời gian tạo:</td>
                                    <td>{{$result["details"]["created_at_fomated"]}}</td>

                                </tr>
                                <tr>
                                    <td>Tiền đã trả:</td>
                                    <td>{{ number_format($result["details"]["paid_amount"]) }}</td>

                                    <td>Ngày nhận tiền:</td>
                                    <td>{{$result["details"]["paid_date"]}}</td>
                                </tr>
                                <tr class="table-info">
                                    <td>Số tiền còn:</td>
                                    @if(($result["details"]["pay_amount"] - $result["details"]["paid_amount"] > 0))
                                    <td>{{ number_format($result["details"]["pay_amount"] - $result["details"]["paid_amount"]) }}</td>
                                    @else
                                    <td>0</td>
                                    @endif

                                    <td>Trạng thái:</td>
                                    <td>{{$result["details"]["status_text"]}}</td>
                                </tr>
                                <tr>
                                    <td id="action-group">
                                        @if($result["details"]["status"] == 1)
                                        <button style="background-color: #047734; color: #fff;" id="send-email" type="button" class="btn btn-primary">Gửi Email</button>
                                        <button style="color: #000000; margin-left: 10px;" id="cancel" type="button" class="btn">Huỷ ĐS</button>
                                        @else
                                        <button style="color: #000000;" type="button" class="btn" disabled="disabled">Đã Gửi Email</button>
                                        @endif
                                    </td>
                                    <td></td>
                                    <td>Người tạo:</td>
                                    <td>{{$result["details"]["created_by"]}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="total-info">
                        <h5 class="total-transaction">
                            <span>Số GD: </span><span id="total_transaction">{!! $result["transactions"]["totalTransaction"]; !!}</span>
                        </h5>
                        <h5 class="total-paid-amount">
                            <span>Tổng Tiền GD: </span><span id="total_paid_amount">{!! $result["transactions"]["totalPaidAmount"]; !!} VNĐ</span>
                        </h5>
                        <h5 class="total-transaction-fee">
                            <span>Hoa Hồng: </span><span id="total_transaction_fee">{!! $result["transactions"]["totalTransactionFee"]; !!} VNĐ</span>
                        </h5>
                    </div>

                </div>
            </div>
            <div class="middle table_tabs">
                <div class="table-responsive">
                    <table id="data-table" class="table table-striped">
                        <thead>
                            <tr style="text-align: center">
                                <th style="text-align: center;">STT</th>
                                <th style="text-align: center;">Mã GD</th>
                                <th style="text-align: center">Số Tiền GD</th>
                                <th style="text-align: center">Khách Hàng</th>
                                <th style="text-align: center">Mã HĐ</th>
                                <th style="text-align: center">Thời Gian GD</th>
                                <th style="text-align: center">Loại GD</th>
                                <th style="text-align: center">Phí GD</th>
                                <th style="text-align: center">Trạng thái thanh toán</th>
                                <th style="text-align: center">TT Thanh Toán</th>
                                <th style="text-align: center">TT Đối Soát</th>
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
            <th style="text-align: left;">Mã GD</th>
            <th style="text-align: left">Số Tiền GD</th>
            <th style="text-align: left">Khách Hàng</th>
            <th style="text-align: left">Mã HĐ</th>
            <th style="text-align: left">Thời Gian GD</th>
            <th style="text-align: left">Loại GD</th>
            <th style="text-align: left">Phí GD</th>
            <th style="text-align: left">Trạng thái thanh toán</th>
            <th style="text-align: left">TT Tất Toán</th>
            <th style="text-align: left">TT Đối Soát</th>
            <th class="print-none no-export" style="text-align: left">Chức Năng</th>
	    </tr>
	</thead>
	<tbody align="center" id="listingTable">
	    <tr id="transaction-item" data-id="">
		    <td style="text-align: left;" data-attr="transaction_no">
                <input type="checkbox" class="selected_item" data-attr='selected_item' name="selected_item[]">
            </td>
		    <td data-attr='transactionId'></td>
		    <td data-attr='paid_amount'></td>
		    <td data-attr='name'></td>
		    <td data-attr='contract_code_disbursement'></td>
            <td data-attr='paid_date'></td>
		    <td data-attr='payment_option'></td>
		    <td data-attr='transaction_fee'></td>
		    <td data-attr='contract_status'></td>
		    <td data-attr='status'></td>
            <td data-attr='confirmed'></td>
		    <td class="print-none no-export" style="position: relative;">
		        <button class="btn_bar dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
<script type="text/javascript" src="{{ asset('viewcpanel/js/paymentgateway/reconciliation-details.js') }}"></script>
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
var transactions = {!! json_encode($result["transactions"]["data"]) !!};
var deleteUrl = {!! json_encode($deleteUrl) !!};
var reconciliationId = {!! json_encode($reconciliationId) !!};
var sendEmail = {!! json_encode($sendEmail) !!};
</script>
</body>
</html>

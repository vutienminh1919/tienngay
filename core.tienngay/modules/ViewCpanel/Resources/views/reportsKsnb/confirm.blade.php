@extends('viewcpanel::layouts.master')

@section('title', 'Danh Sách Biên Bản Ghi Nhận Vi Phạm Chờ Xác Nhận')

@section('css')
	<link href="{{ asset('viewcpanel/css/vpbank/transactions.css') }}" rel="stylesheet"/>
@endsection

@section('content') 
@if(session('status'))
        <div class="alert alert-success">
            {{session('status')}}
    </div>
    @endif
<section class="main-content">
    <div id="loading" class="theloading" style="display: none;">
        <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    </div>
    <div class="container">
        <h3 class="tilte_top_tabs">
            Danh sách biên bản ghi nhận vi phạm chờ xác nhận
        </h3>
        
        <div class="row" style="align-items: center;">
        </div>
        <div class="middle table_tabs">
            <p hidden>Page: <span id="page"></span></p>
            <div class="table-responsive" style="overflow-x: auto;">
            <form method="post" action='{{url(("/cpanel/reportsKsnb/updateProcess/"))}}'>
                <table class="table">
                    <thead>
                        <tr style="text-align: center">
                            <th scope="col" style="text-align: center; min-width: 50px;">MÃ LỖI <i data-bs-toggle="tooltip" title="" data-bs-original-title="Mã lỗi vi phạm đã ban hành" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></th>
                            <th scope="col" style="text-align: center; min-width: 100px;">NHÓM VI PHẠM</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">CHẾ TÀI PHẠT <i data-bs-toggle="tooltip" title="" data-bs-original-title="Trừ theo %KPI trong tháng vi phạm/lỗi/lần" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></th>
                            <th scope="col" style="text-align: center; min-width: 100px;">HÌNH THỨC KỶ LUẬT</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">TÊN NHÂN VIÊN</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">EMAIL NHÂN VIÊN</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">TÊN PGD</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">NGƯỜI TẠO</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">NGÀY TẠO</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">TRẠNG THÁI</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">TIẾN TRÌNH</th>
                            <th scope="col" style="text-align: center; min-width: 50px;">CHỨC NĂNG</th>
                        </tr>
                    </thead>
                    <tbody align="center" id="listingTable">
                        @if(isset($search))
                        @foreach($search as $list) 
                        <tr id="clone-item" data-id="">
                            <td>{{$list['code_error']}}</td>
                            <td>
                                @if($list['type'] == 1)
                                    <p><span class="">Vi phạm nội quy công ty</span></p>
                                @endif
                                @if($list['type'] == 2)
                                    <p><span class="">Vi phạm liên quan khách hàng</span></p>
                                @endif
                                @if($list['type'] == 3)
                                    <p><span class="">Vi phạm liên quan PGD</span></p>
                                @endif
                                @if($list['type'] == 4)
                                    <p><span class="">Các vi phạm khác</span></p>
                                @endif
                            </td>
                            <td>{{$list['punishment']}}</td>
                            <td style="min-width: 120px;">
                                @if($list['discipline'] == 1)
                                    <p><span class="">Khiển trách</span></p>
                                @endif
                                @if($list['discipline'] == 2)
                                    <p><span class="">Kéo dài thời hạn tăng lương/Cách chức</span></p>
                                @endif
                                @if($list['discipline'] == 3)
                                    <p><span class="">Kéo dài thời hạn tăng lương/Sa thải</span></p>
                                @endif
                                @if($list['discipline'] == 4)
                                    <p><span class="">Sa thải</span></p>
                                @endif
                                @if($list['discipline'] == 5)
                                    <p><span class="">Từng sự vụ</span></p>
                                @endif
                            </td>
                            <td>{{$list['user_name']}}</td>
                            <td>{{$list['user_email']}}</td>
                            <td>{{$list['store_name']}}</td>
                            <td>{{$list['created_by']}}</td>
                            <td>{{$list['created_at']}}</td>
                            <td>
                                @if($list['status'] == 1) 
                                    <p><span class="text-info">New</span></p>
                                @endif
                                @if($list['status'] == 2) 
                                    <p><span class="text-success">Active</span></p>
                                @endif
                                @if($list['status'] == 3) 
                                    <p><span class="text-danger">Block</span></p>
                                @endif
                            </td>
                            <td>
                                @if($list['process'] == 1)
                                    <p><span class="text-info">Chờ Xác Nhận</span></p>
                                @endif
                            </td>
                            <td class="print-none no-export" style="position: relative;">
                                @if
                                <button disabled class="btn btn-success" hidden >DUYỆT</button>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </form>
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
<script>
    $("#fillter-button").on("click", function (event) {
        event.stopPropagation();
        $("#fillter-content").toggle();
    })
    var dp = $("#start-date, #end-date").datepicker( {
        format: "yyyy-mm-dd",
        autoclose: true
    });

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
@endsection

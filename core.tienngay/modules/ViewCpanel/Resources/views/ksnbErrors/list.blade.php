@extends('viewcpanel::layouts.master')

@section('title', 'Danh Sách Mã Lỗi')

@section('css')
<link href="{{ asset('viewcpanel/css/reportsKsnb/index.css') }}" rel="stylesheet"/>
@endsection

@section('content')
    @if(session('status'))
        <div class="alert alert-success">
            {{session('status')}}
    </div>
    @endif
    @if(session()->has('errors'))
        <div class="alert alert-danger" role="alert">
          {{session()->get('errors')}}
        </div>
    @endif
<section class="main-content">
    <div id="loading" class="theloading" style="display: none;">
        <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    </div>
    <div class="">
        <h3 class="tilte_top_tabs">
            DANH SÁCH MÃ LỖI
        </h3>

        <div class="row" style="align-items: center;">
            <div class="col-6">
               
            </div>
            <div class="col-6">
                @include("viewcpanel::ksnbErrors.filter")
            </div>
        </div>
        <br>
        <div class="middle table_tabs">
            <p style="color: #047734"><strong>Tổng số mã lỗi:</strong> <span id="total">{{$list->total()}}</span></p>
            <p hidden>Page: <span id="page"></span></p>
            <div class="table-responsive" style="overflow-x: auto;">
                <table class="table" style="margin-bottom: 100px">
                    <thead>
                        <tr style="text-align: center">
                             <th scope="col" style="text-align: center; min-width: 50px;">STT</th>
                            <th scope="col" style="text-align: center; min-width: 100px;">MÃ LỖI</th>
                            <th scope="col" style="text-align: center; min-width: 100px;width: 500px">MÔ TẢ MÃ LỖI</th>
                            <th scope="col" style="text-align: left; min-width: 100px;">NHÓM VI PHẠM </th>
                            <th scope="col" style="text-align: center; min-width: 140px;">CHẾ TÀI XỬ PHẠT(KPI)</th>
                            <th scope="col" style="text-align: center; min-width: 170px;">HÌNH THỨC KỶ LUẬT</th>
                            <th scope="col" style="text-align: center; min-width: 120px;">TRẠNG THÁI</th>
                            <th scope="col" style="text-align: center; min-width: 120px;">CHỨC NĂNG</th>
                        </tr>
                    </thead>
                    <tbody align="center" id="listingTable">
                        @if(isset($list))
                        @foreach($list as $key => $value)
                        <tr id="clone-item" data-id="">
                            <td>{{++$key}}</td>
                            <td>{{$value['code_error']}}</td>
                            <td style="text-align: center">
                               {{$value['description']}}
                            </td>
                            <td  style="text-align: center">
                                @if($value['type']=='1')
                                    Vi phạm nội quy công ty
                                @elseif($value['type']=='2')
                                    Vi phạm liên quan đến khách hàng
                                @elseif($value['type'] =='3')
                                    Vi phạm liên quan đến hoạt động phòng giao dịch
                                @elseif($value['type']=='4')
                                    Các vi phạm khác
                                @endif
                            </td>
                            <td  style="text-align: center">
                                {{$value['punishment_name']}}
                            </td>
                            <td style="text-align: center">
                                {{$value['discipline_name']}}
                            </td>
                            <td><label class=" form-switch toggle-status"
                                       data-id="{{ $value['id'] }} ">
                                    <input class="form-check-input"
                                           style="margin-top: 6px"
                                           type="checkbox" name="status"
                                           id="status" {{ ($value['status'] == 'active') ? 'checked' : '' }}>
                                </label>
                                @if($value['status'] == 'active')
                                    <label></label>
                                @else
                                    <label></label>
                                @endif
                            </td>
                            <td class="print-none no-export" style="position: relative;">
                                <button id="dropdownMenu2" style="min-height: 26px;" class="btn_bar" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img class="not_hover" src="{{ asset('menu-ico.svg') }}" alt="list">
                                        <img class="hover" src="{{ asset('hover.svg') }}" alt="list">
                                </button>
                                <ul class="dropdown-menu dropdown-customer dropdown-item-detail" aria-labelledby="dropdownMenu2">
                                    <li><a id="details-show-info__id__" class="dropdown-item show_info_btn_chose"  href='{{url("/cpanel/ksnb_erors/edit/$value->_id")}}'>Cập nhật</a></li>
                                    <li><a id="details-show-info__id__" class="dropdown-item show_info_btn_chose"  href='{{url("/cpanel/ksnb_erors/detail/$value->_id")}}'>Xem chi tiết</a></li>
                                </ul>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <br>
            @if(!empty($list))
                <nav aria-label="Page navigation" style="margin-top: 20px;">
                    {{$list->withQueryString()->links()}}
                </nav>
            @endif
        </div>
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
<script>

$(document).ready(function () {
    $('.toggle-status').click(function (event) {
        event.preventDefault();
        var id = $(this).attr('data-id');
        var status = $(this).prop('checked') == 'active' ? 'active' : 'block';
         var formData = new FormData();
         formData.append('status', status);
         formData.append('id', id);
         if (confirm("Bạn chắc chắn muốn thay đổi?")) {
            $.ajax({
                url: "<?= $updateStatusUrl ?>",
                type: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    console.log(data);
                    if (data.status == 200) {
                        $('#modal-success').modal('show')
                        $('.text_message_success').text(data.message)
                        setTimeout(function () {
                            window.location.reload();
                        }, 500)
                    } else {
                        $('#modal-danger').modal('show')
                        $('.text_message_fail').text(data.message)
                    }
                },
                error: function () {
                    $(".theloading").hide();
                    alert('error')
                    setTimeout(function () {
                        window.location.reload()
                    }, 500);
                }
            })
        }
    })
})

</script>
<script type="text/javascript">
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>

<script type="text/javascript">
    const element = document.getElementById("top-view");
    element.scrollIntoView();
    $("#fillter-button").on("click", function (event) {
        event.stopPropagation();
        $("#fillter-content").toggle();
    })
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
    var dp = $("#start-date, #end-date").datepicker( {
        format: "yyyy-mm-dd",
        autoclose: true
    });
</script>
<script type="text/javascript">
    var dataSearch = JSON.parse('{!! json_encode($dataSearch) !!}');
    console.log(dataSearch);
    for (const property in dataSearch) {
      if (dataSearch[property] == null) {
        continue;
      }
      console.log(property, ' ', dataSearch[property]);
      $('#search-form').find("[name='" + property + "']").val(dataSearch[property]);
    }
</script>

@endsection


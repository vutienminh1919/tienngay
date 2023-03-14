<?php 
    $tab = !empty($_GET['tab']) ? $_GET['tab'] : 'delivery' ;
?>
@extends('viewcpanel::layouts.master')
@section('css')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body{
        background-color: rgb(237, 237, 237);
    }

    .wrapper {
        width: 100%;
        padding: 0px 20px;
        background-color: rgb(237, 237, 237);
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header button {
        height: 40px;
    }

    .header-title h3 {
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 24px;
        color: #3B3B3B;
        margin: 10px 0 0 0;
    }

    .header-title a {
        font-style: normal;
        font-weight: 400;
        font-size: 12px;
        line-height: 14px;
        color: #676767;
    }

    .box-tab {
        margin: 34px 0px;
    }

    .box1,
    .box2 {
        width: 100%;
        background: #FFFFFF;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
        border-radius: 8px;
        position: relative;
        padding-bottom: 5%;

    }

    .box1-header,
    .box2-header {
        display: flex !important;
        justify-content: space-between;
        align-items: center;
        padding: 30px 16px;

    }

    .nav-footer {
        position: absolute;
        right: 0;
        bottom: 0;

    }


    .box1-header h3 {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: #3B3B3B;
        margin-bottom: 0;
    }

    .box2-header h3 {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: #3B3B3B;
        margin-bottom: 0;
    }

    th {
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 30px;
        color: #262626;
        border-bottom-width: 0px !important;
        white-space: nowrap;
        text-align: center !important;
    }

    td {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 30px;
        color: #676767;
        white-space: nowrap;
        text-align: center;
    }

    .dropstart i {
        color: #1D9752;
    }



    .form-date-btn input {
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        width: 100%;
        height: 40px;
        padding-left: 5px;
        outline: none;
    }

    .form-selects {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-top: 12px;
    }

    .form-selects select {
        width: 100%;
        height: 40px;
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        outline: none;
    }

    .form-date {
        margin-top: 12px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }



    /* ----------------------- */

    .tabs {
        display: flex;
        position: relative;
        gap: 15px;
        margin-top: 34px;
    }

    .tabs .line {
        position: absolute;
        left: 0;
        bottom: 0;
        width: 0;
        height: 6px;
        background-color: #FFFFFF;
        transition: all 0.2s ease;
    }

    .btn-success {
        font-size: 14px;
        display: flex;
        align-items: center;
    }

    .tab-item {
        min-width: 80px;
        height: 40px;
        color: #676767;
        cursor: pointer;
        transition: all 0.5s ease;
        padding: 0px 10px;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        display: flex;
        align-items: center;

    }

    .tab-item.active {
        opacity: 1;
        color: #1D9752;
        background: #D2EADC;
        border-radius: 8px;


    }

    .tab-content {
        padding: 24px 0;
    }

    .tab-pane {
        color: #333;
        display: none;
    }

    .tab-pane.active {
        display: block;
    }

    .tab-pane h2 {
        font-size: 24px;
        margin-bottom: 8px;
    }
    .page-link:focus{
        background-color: #1D9752 !important;
        color: #fff !important;
    }
    .page-link{
        color: #676767 !important;
    }

    @media screen and (max-width:48em) {
        .header {
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: self-start;
        }

        .box1-header,
        .box2-header {
            display: contents;
            /* flex-direction: column; */
        }

        .box1,
        .box2 {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding-bottom: 20%;
        }

        .form-date-btn {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .tab-item {
            font-size: 12px;
        }
    }

    @media only screen and (min-width:46.25em) and (max-width:63.9375em) {
        .box1,
        .box2 {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding-bottom: 10%;
        }
    }
    #fillter-button, .btn-func {
        font-size: 14px !important
    }

    #fillter-content {
        width: 300px;
        right: 175px !important
    }

    #fillter-content * {
        font-size: 12px !important
    }
    .btn_list_filter {
        text-align: right;
    }

    .btn_list_filter .btn-fitler {
        display: inline-block
    }

    .btn-fitler-transfer input {
        padding-top: 3.5px;
        padding-bottom: 8.5px
    }
    #fillter-button-transfer, .btn-func-transfer {
        font-size: 14px !important
    }

    #fillter-content-transfer {
        width: 300px;
        right: 175px !important
    }

    #fillter-content-transfer * {
        font-size: 12px !important
    }
    .btn_list_filter-transfer {
        text-align: right;
        height: 30px;
    }

    .btn_list_filter-transfer .btn-fitler-transfer {
        display: inline-block
    }

    .btn-fitler-transfer input {
        padding-top: 3.5px;
        padding-bottom: 8.5px
    }
    #date {
  width: 150px;
  outline: none;
  border: 1px solid #aaa;
  padding: 6px 10px;
  color: #aaa;
}

.date-container {
  position: relative;
  float: left;
}
  .date-text {
    position: absolute;
    top: 6px;
    left: 12px;
    color: #aaa;
  }

  .date-icon {
    position: absolute;
    top: 10px;
    right: 10px;
    /* pointer-events: none; */
    cursor: pointer;
    color: #aaa;
  }

  #date2, #dat3, #date4, #date5, #date6, #date7, #date8, #date9, #date10 {
  width: 150px;
  outline: none;
  border: 1px solid #aaa;
  padding: 6px 10px;
  color: #aaa;
}

.date-container2 {
  position: relative;
  float: left;
}
  .date-text2 {
    position: absolute;
    top: 6px;
    left: 12px;
    color: #aaa;
  }

  .date-icon2 {
    position: absolute;
    top: 10px;
    right: 10px;
    /* pointer-events: none; */
    cursor: pointer;
    color: #aaa;
  }
  .theloading {
        position: fixed;
        z-index: 999;
        display: block;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, .7);
        top: 0;
        right: 0;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center
    }
    
    .modal{
        top: -400px;
    }
    .modal-body {
        padding: 16px 24px;
    }

    .modal-body h5 {
        font-style: normal;
        font-weight: 600;
        font-size: 18px;
        line-height: 20px;
        color: #3B3B3B;
    }

    .modal-body p {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #676767;
    }

    .style-label label {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #3B3B3B;
    }

    .style-label span {
        color: #C70404;
    }

    .style-textarea textarea {
        padding: 16px;
        gap: 8px;
        width: 100%;
        height: 100px;
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        outline: none;
        font-size: 14px;
    }

    textarea::placeholder{
        font-size: 14px;
    }

    .btn-modal {
        display: flex;
        justify-content: space-between;
        margin-top: 24px;
    }

    .btn-accept {
        width: 200px;
        height: 40px;
        background: #E6E6E6;
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 16px;
        /* color: #C70404; */
        border-radius: 8px;
        border: none;
        color:#676767;
    }

    .btn-delete {
        width: 200px;
        height: 40px;
        background: #D8D8D8;
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 16px;
        color: #676767;
        border-radius: 8px;
        border: none;
    }
    .theloading {
        position: fixed;
        z-index: 999;
        display: block;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, .7);
        top: 0;
        right: 0;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center
    }
    .active a{
        font-weight: 600;
    }
    #fillter-button, #fillter-button-transfer{
        font-weight: 600;
        border: none;
    }

    .dropdown-item{
        color: #676767 !important;
        font-weight: 400;
        font-size: 14px;
    }
</style>
@endsection
@section('content')
<section class="xk_pgd">
    <div class="wrapper">
        <div id="loading" class="theloading" style="display: none;">
            <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
        </div>
        <div class="header">
            <div class="header-title">
                <h3>Danh sách phiếu xuất ấn phẩm</h3>
                <small>
                    @if ($tab == 'delivery')
                        <a class="redirect" style="text-decoration:none;" href="{{route('viewcpanel::warehouse.pgdIndex')}}"><i class="fa fa-home "></i> Home</a>
                    @endif
                    @if ($tab == 'transfer')
                        <a class="redirect" style="text-decoration:none;" href="{{route('viewcpanel::warehouse.pgdIndex').'&tab=transfer'}}"><i class="fa fa-home "></i> Home</a>
                    @endif
                </small>
            </div>
            @if ($tab == 'delivery')
            <a href="{{route('viewcpanel::warehouse.pgdCreate')}}" type="button" class="btn btn-success redirect" style="background-color:#1D9752; height: 40px;     font-weight: 600;">Thêm mới <i class="fa fa-plus" aria-hidden="true" style="margin-left: 5px;"></i></a>
            @endif
            @if ($tab == 'transfer')
            <a href="{{route('viewcpanel::transfer.create')}}" type="button" class="btn btn-success redirect" style="background-color:#1D9752;height: 40px;     font-weight: 600;">Thêm mới <i class="fa fa-plus" aria-hidden="true" style="margin-left: 5px;"></i></a>
            @endif
        </div>
        <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}">
        <div id="Tabs">
            <!-- Tab items -->
            <div class="tabs">
                <div class="tab-item deliveryTab <?= $tab == 'delivery' ? 'active' : ''?>">
                    <a target="_blank" class="" style="text-decoration: none;color:<?= $tab == 'delivery' ? '#1D9752' : '#676767' ?>" href="{{$cpanelIndexDelivery}}">Danh sách phiếu xuất kho</a>
                </div>
                <div class="tab-item transferTab <?= $tab == 'transfer' ? 'active' : ''?>">
                    <a target="_blank" class="" style="text-decoration: none;color:<?= $tab == 'transfer' ? '#1D9752' : '#676767' ?>" href="{{$cpanelIndexTransfer}}">Danh sách phiếu điều chuyển</a>
                </div>
                <div class="line"></div>
            </div>

            <!-- Tab content -->
            <div class="tab-content">
                <div class="tab-pane <?= $tab == 'delivery' ? 'active' : ''?>">
                    <div class="box1">
                        <div class="box1-header">
                            <h3>Danh sách phiếu xuất kho</h3>
                            @include("viewcpanel::trade.delivery.pgd.filter")
                        </div>
                        <div class="box1-table table-responsive">
                            <table class="table table-hover">
                                <thead class="table" style="background-color:#E8F4ED">
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Người tạo</th>
                                        <th scope="col">Phòng giao dịch</th>
                                        <th scope="col">Ngày tạo</th>
                                        <th scope="col">Số loại ấn phẩm</th>
                                        <th scope="col">Số lượng ấn phẩm</th>
                                        <th scope="col">Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($delivery)
                                        @if (count($delivery) == 0)
                                        <tr>
                                            <p class="text-danger" style="text-align:center">Không có dữ liệu</p>
                                        </tr>
                                        @endif

                                        @foreach($delivery as $key => $item)
                                        <tr>
                                            <td>{{++$key}}</td>
                                            <td>{{$item['created_by']}}</td>
                                            <td>{{$item['stores']['name']}}</td>
                                            <td>{{date('Y-m-d H:i:s', $item['created_at'])}}</td>
                                            <td>{{count($item['list'])}}</td>
                                            <td>
                                                @php
                                                    $count = 0;
                                                    foreach($item['list'] as $amount) {
                                                        $count+= $amount['amount'];
                                                    }
                                                @endphp
                                                {{$count}}
                                            </td>
                                            <td>
                                                <a type="button" class="btn-outline-success" style="font-style: 14px; border-radius: 5px"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-bars" aria-hidden="true"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    @if(!$statusSelect && !$pgdSelect && !$areaSelect && !$domainSelect)
                                                    <li style="font-size: 14px; "><a class="dropdown-item redirect" href='{{route("viewcpanel::warehouse.pgdDetail", ["id" => $item->_id])}}'>Xem chi tiết</a></li>
                                                    @else
                                                    <li style="font-size: 14px; "><a class="dropdown-item redirect" href='{{route("viewcpanel::warehouse.detail",["id" => $item->_id])}}'>Xem chi tiết</a></li>
                                                    @endif
                                                </ul>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @if(!empty($delivery))
                            <nav aria-label="Page navigation" style="margin-top: 20px;">
                                {{ $delivery->withQueryString()->render('viewcpanel::trade.paginate') }}
                            </nav>
                        @endif
                    </div>
                </div>
                <div class="tab-pane <?= $tab == 'transfer' ? 'active' : ''?>">
                    <div class="box2">
                        <div class="box2-header">
                            <h3>Danh sách phiếu điều chuyển</h3>
                            @include("viewcpanel::trade.delivery.pgd.filter_transfer")
                        </div>
                        <div class="box2-table table-responsive">
                            <table class="table table-hover">
                                <thead class="table" style="background-color:#E8F4ED">
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Ngày yêu cầu</th>
                                        <th scope="col">Phòng giao dịch xuất</th>
                                        <th scope="col">Ngày xuất</th>
                                        <th scope="col">Phòng giao dịch nhận</th>
                                        <th scope="col">Ngày nhận</th>
                                        <th scope="col">Số loại ấn phẩm nhận </th>
                                        <th scope="col">Tổng số lượng ấn phẩm xuất </th>
                                        <th scope="col">Trạng thái</th>
                                        @if (in_array($user['email'], $mkt) || $isAdmin)
                                        <th scope="col">Ngày tạo</th>
                                        <th scope="col">Người tạo</th>
                                        @endif
                                        <th scope="col">Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($transfer)
                                        @if (count($transfer) == 0)
                                            <tr>
                                                <p class="text-danger" style="text-align:center">Không có dữ liệu</p>
                                            </tr>
                                        @endif
                                        @foreach ($transfer as $key => $trans)
                                            <tr>
                                                <td>{{++$key}}</td>
                                                <td>
                                                    @if (!empty($trans['requested_at'])) {{date('Y-m-d H:i:s', $trans['requested_at'])}} @else @endif
                                                </td>
                                                <td>{{$trans['stores_export']['name']}}</td>
                                                <td>@if(!empty($trans['date_export']))  {{date('Y-m-d H:i:s', $trans['date_export'])}} @else  @endif</td>
                                                <td>{{$trans['stores_import']['name']}}</td>
                                                <td>@if(!empty($trans['date_export']))  {{date('Y-m-d H:i:s', $trans['date_import'])}} @else  @endif</td>
                                                <td>{{count($trans['list'])}}</td>
                                                <td>
                                                    @php
                                                        $arr = [];
                                                        foreach($trans['list'] as $k) {
                                                            $arr[] = $k['amount'];
                                                        }
                                                    @endphp
                                                    {{array_sum($arr)}}
                                                </td>
                                                <td>
                                                    @foreach($status_transfer as $k => $i)
                                                        @if ($k == $trans['status'])
                                                            {{$i}}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                @if (in_array($user['email'], $mkt) || $isAdmin)
                                                <td>{{date('Y-m-d H:i:s', $trans['created_at'])}}</td>
                                                <td>{{$trans['created_by']}}</td>
                                                @endif
                                                <td>
                                                    <div class="dropdown dropstart">
                                                        <i class="fa fa-bars" aria-hidden="true" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item redirect" href='{{route("viewcpanel::transfer.detail", ["id" => $trans->_id])}}'>Xem chi tiết </a></li>
                                                            @if ($trans['status'] == 1)
                                                                <li><a href='{{route("viewcpanel::transfer.edit",["id" => $trans->_id])}}' class="dropdown-item redirect">Chỉnh sửa </a></li>
                                                                <li><a id="button_delete" data-id="{{$trans['id']}}" data-bs-toggle="modal" data-bs-target="#delete"  class="dropdown-item" href="#">Xóa</a></li>
                                                            @endif
                                                            @if (($trans['status'] != 5 && $trans['status'] != 4) && ($isAdmin || in_array($user['email'], $tradeMkt)))
                                                                <li><a id="button_cancel" data-id="{{$trans['id']}}" data-bs-toggle="modal" data-bs-target="#accept"  class="dropdown-item" href="#">Hủy</a></li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>

                        </div>
                        <div class="nav-footer">
                            @if(!empty($transfer))
                                <nav aria-label="Page navigation" style="margin-top: 20px;">
                                    {{ $transfer->withQueryString()->render('viewcpanel::trade.paginate') }}
                                </nav>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="accept" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 style="text-align: center">Huỷ phiếu điều chuyển</h5>
                    <p style="text-align: center">Bạn có chắc chắn muốn huỷ phiếu điều chuyển này?</p>
                    <div class="style-label">
                        <label>Lý do huỷ <span>*</span></label>
                    </div>
                    <div class="style-textarea">
                        <textarea name="reason_cancel" id="reason_cancel" placeholder="Nhập lý do hủy"></textarea>
                    </div>

                    <div class="btn-modal">
                        <button disabled type="button" id="confirm_cancel" class="btn-accept">Đồng ý</button>
                        <button type="button" class="btn-delete" data-bs-dismiss="modal">Huỷ</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 style="text-align: center">Xóa phiếu điều chuyển</h5>
                    <p class="text-danger" style="text-align: center">Bạn có chắc chắn muốn xóa phiếu điều chuyển này?</p>

                    <div class="btn">
                        <button style="background-color:#F4CDCD; color:#C70404;" type="button" id="confirm_delete" class="btn-accept">Đồng ý</button>
                        <button class="btn-delete" data-bs-dismiss="modal">Huỷ</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script type="text/javascript">
  $(document).ajaxStart(function() {
    $("#loading").show();
    var loadingHeight = window.screen.height;
    $("#loading, .right-col iframe").css('height', loadingHeight);
    }).ajaxStop(function() {
        $("#loading").hide();
  });
</script>
<script type="text/javascript">
    $(function() {
        $('#date').datepicker({
            format: "yyyy-mm-dd",
            minDate: 1
        });

        $('#date2, #date3, #date4, #date5, #date6, #date7, #date8, #date9, #date10').datepicker({
            format: "yyyy-mm-dd",
            minDate: 1
        });

        $('#date').on('click', function() {
            $('#date').css('color', 'black');
        })

        $('.date-icon').on('click', function() {
            $('#date').css('color', 'black');
            $('#date').focus();
        })

        $('#date2, #date3, #date4, #date5, #date6, #date7, #date8, #date9, #date10').on('click', function() {
            $('#date2').css('color', 'black');
        })

        $('.date-icon2').on('click', function() {
            $('#date2, #date3, #date4, #date5, #date6, #date7, #date8,, #date9, #date10').css('color', 'black');
            $('#date2').focus();
        })
    });

</script>
<script type="text/javascript">
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    $("#fillter-button").on("click", function (event) {
        event.stopPropagation();
        $("#fillter-content").toggle();
    })
    $("#clear-search-form").on("click", function (event) {
        event.preventDefault();
        $("form#search-form")[0].reset();
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
    // var dp = $("#start-date, #end-date").datepicker( {
    //     format: "yyyy-mm-dd",
    //     autoclose: true
    // });
    $("#fillter-button-transfer").on("click", function (event) {
        event.stopPropagation();
        $("#fillter-content-transfer").toggle();
    })
    $("#clear-search-form-transfer").on("click", function (event) {
        event.preventDefault();
        document.getElementById("search-form-transfer").reset();
    });
    $("#close-search-form-transfer").on("click", function (event) {
        event.preventDefault();
        $("#fillter-content-transfer").hide();
    });
    $('body').on('click', function(e){
        if (e.target.id == "fillter-content-transfer" || $(e.target).parents("#fillter-content-transfer").length) {
            //do nothing
        } else {
            $("#fillter-content-transfer").hide();
        }
    });
</script>
<script>
    $(document).ready(function() {
        $("#domain").on('change', function() {
            let domain = $(this).val();
            let form = new FormData();
            form.append('domain', domain);
            form.append('_token', $('input[name="_token"]').val());
            $.ajax({
                dataType: 'json',
                enctype: 'multipart/form-data',
                url: '{{route("viewcpanel::warehouse.getAreaByDomain")}}',
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data['status'] == 200) {
                        $('#code_area').html("");
                        $('#code_area').append('<option  value=""  > ' + "--Chọn Khu Vực--" + ' </option>')
                        $.each(data.data, function(key, value) {
                            console.log(value);
                            $('#code_area').append('<option  value="' + value['code'] + '"  > ' + value['title'] + ' </option>')
                        });
                    } else if (typeof(data) == "string") {
                        $("#errorModal").find(".msg_error").text(data);
                        $("#errorModal").modal('show');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                $("#errorModal").find(".msg_error").text("Có lỗi xảy ra, vui lòng thử lại sau!");
                $("#errorModal").modal('show');
                }
            });
        })
        $("#code_area").on('change', function() {
            let code_area = $(this).val();
            let form = new FormData();
            form.append('code_area', code_area);
            form.append('_token', $('input[name="_token"]').val());
            $.ajax({
                dataType: 'json',
                enctype: 'multipart/form-data',
                url: '{{route("viewcpanel::warehouse.getStoreByArea")}}',
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data['status'] == 200) {
                        $('#stores').html("");
                        $('#stores').append('<option  value=""  > ' + "--Chọn Phòng Giao Dịch--" + ' </option>')
                        $.each(data.data, function(key, value) {
                            console.log(value);
                            $('#stores').append('<option  value="' + value['_id'] + '"  > ' + value['name'] + ' </option>')
                        });
                    } else if (typeof(data) == "string") {
                        $("#errorModal").find(".msg_error").text(data);
                        $("#errorModal").modal('show');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                $("#errorModal").find(".msg_error").text("Có lỗi xảy ra, vui lòng thử lại sau!");
                $("#errorModal").modal('show');
                }
            });
        })

        $('#confirm_cancel').on('click', function() {
            $('#accept').modal('hide');
            reason_cacel = $('#reason_cancel').val();
            let id = $('#button_cancel').attr('data-id');
            console.log(id);
            let form = new FormData();
            form.append('reason_cancel', reason_cacel);
            form.append('id', id);
            form.append('_token', $('input[name="_token"]').val());
            $.ajax({
                dataType: 'json',
                enctype: 'multipart/form-data',
                url: '{{route("viewcpanel::transfer.cancel")}}',
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function(data) {
                    $('#accept').modal('hide');
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Hủy phiếu điều chuyển thành công',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    $('#reason_cancel').val('');
                    $("#confirm_cancel").attr('disabled', true);
                    $("#confirm_cancel").css("background", "#E6E6E6");
                    $("#confirm_cancel").css("color", '#676767');
                    setTimeout(function(){
                    window.location.assign("{{route('viewcpanel::warehouse.pgdIndex').'?tab=transfer'}}");
                    }, 2000);
                    return ;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                $("#errorModal").find(".msg_error").text("Có lỗi xảy ra, vui lòng thử lại sau!");
                $("#errorModal").modal('show');
                }
            });
        });

        $('textarea[name="reason_cancel"]').keyup(function(){
            val = $('#reason_cancel').val().trim();
            console.log(val)
            if(val.length > 0){
                $("#confirm_cancel").attr("disabled", false);
                $("#confirm_cancel").css("background", '#F4CDCD');
                $("#confirm_cancel").css("color", '#C70404');
            } else {
                $("#confirm_cancel").attr('disabled', true);
                $("#confirm_cancel").css("background", "#E6E6E6");
                $("#confirm_cancel").css("color", '#676767');
            }
        });

        $('#confirm_delete').on('click', function() {
            let id = $('#button_delete').attr('data-id');
            let form = new FormData();
            form.append('_token', $('input[name="_token"]').val());
            form.append('id',id);
            $.ajax({
                dataType: 'json',
                enctype: 'multipart/form-data',
                url: '{{route("viewcpanel::transfer.delete")}}',
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function(data) {
                    $('#accept').modal('hide');
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Xóa phiếu điều chuyển thành công',
                        showConfirmButton: false,
                        timer: 2500
                    });
                    setTimeout(function(){
                    window.location.assign("{{route('viewcpanel::warehouse.pgdIndex').'?tab=transfer'}}");
                    }, 2000);
                    return ;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                $("#errorModal").find(".msg_error").text("Có lỗi xảy ra, vui lòng thử lại sau!");
                $("#errorModal").modal('show');
                }
            });
        });
    })
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

<script type="text/javascript">
    $('a.redirect').on('click', (e) => {
        e.preventDefault();
        let url = $(e.target).attr('href');
        Redirect(url, false);
    })
</script>
<script type="text/javascript">
    const iframeMode = "<?= (!empty($_GET['iframe']) && $_GET['iframe'] == 1) ?>";
    console.log(iframeMode)
    const Redirect = (_url, _timeout) => {
        if (parseInt(iframeMode) != 1) {
            if (!_timeout) {
                window.location.href = _url;
                // window.parent.postMessage({targetLink: _url}, "{{$cpanelPath}}");
            } else {
                setTimeout(function(){window.location.href = _url}, _timeout);
                // setTimeout(function () {window.parent.postMessage({targetLink: _url}, "{{$cpanelPath}}");}, _timeout);
            }
        } else {
            _url = _url.replace(window.location.origin + '/', "");
            if (!_timeout) {
                // window.location.href = _url;
                window.parent.postMessage({targetLink: _url}, "{{$cpanelPath}}");
            } else {
                // setTimeout(function(){window.location.href = _url}, _timeout);
                setTimeout(function () {window.parent.postMessage({targetLink: _url}, "{{$cpanelPath}}");}, _timeout);
            }
        }
    }
</script>
@endsection

@extends('viewcpanel::layouts.master')

@section('title', 'Danh sách báo cáo tồn kho')

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.14.0/css/selectize.bootstrap5.css" rel="stylesheet"/>

@endsection
<style>
    body {
        background-color: rgb(237, 237, 237) !important;
    }
    .detail {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #676767 !important;
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

    .form-container {
        width: 100%;
        padding: 24px 16px;
        gap: 24px;
        background: #FFFFFF;
        border: 1px solid #F0F0F0;
        border-radius: 8px;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .wrapper {
        width: 100%;
    }

    .form-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-title h3 {
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 24px;
        color: #3B3B3B;
    }

    .header-title a {
        font-style: normal;
        font-weight: 400;
        font-size: 12px;
        line-height: 14px;
        color: #676767;
        text-decoration: none;
    }

    .form-body {
        /* width: 100%; */
        background: #FFFFFF;
        /* background: linear-gradient(90deg, #015aad, #00b74f); */
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
        border-radius: 8px;
        position: relative;
        padding-bottom: 5%;
        margin-top: 34px;
    }


    .body-title {
        display: flex;
        justify-content: space-between;
    }

    .body-title h3 {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: #3B3B3B;
        padding: 22px 16px;
        margin: 0px;
    }

    .table th {
        font-weight: 600;
        font-size: 14px;
        line-height: 48px;
        color: #262626;
        text-align: center;
        vertical-align: baseline;
    }

    .table td {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 31px;
        color: #676767;
        vertical-align: middle;
        text-align: center;
        width: 150px !important;
    }

    .body-navigate {
        display: flex;
        justify-content: flex-end;
        position: absolute;
        bottom: 0;
        right: 5;
    }

    .form-modal {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .form-input {
        display: flex;
        flex-direction: column;
        gap: 8px;

    }

    .form-input label {
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        display: flex;
        align-items: center;
        color: #3B3B3B;

    }

    .form-input input {
        width: 100%;
        height: 40px;
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        outline: none;
        padding-left: 10px;
    }

    .form-input select {
        width: 100%;
        height: 40px;
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        outline: none;
        padding-left: 10px;
    }

    .nav {
        display: flex;
        flex-direction: column;
    }

    .nav > li {
        text-decoration: none;
    }

    .body-btn {
        display: flex;
        gap: 10px;
    }

    .table thead tr th {
        border: 1px;
    }

    .btn_list_filter {
        text-align: right;
        padding: 10px 0
    }

    .btn_list_filter .btn-fitler {
        display: inline-block
    }

    .btn-fitler input {
        padding-top: 3.5px;
        padding-bottom: 8.5px
    }

    #fillter-button, #select-time, .btn-func {
        font-size: 14px !important
    }

    #fillter-content {
        /*width: 400px;*/
        right: 175px !important
    }

    #fillter-content * {
        font-size: 14px !important
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

    #date2 {
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

    @media screen and (max-width: 48em) {
        .form-body {
            background: #FFFFFF;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
            border-radius: 8px;
            position: relative;
            padding-bottom: 15%;
            margin-top: 34px;
        }
    }

    #fillter-button{
        display: flex;
        align-items: center;
        gap: 5px;
        padding-bottom: 8px;
    }
</style>
<div class="wrapper">
    <div id="loading" class="theloading" style="display: none;">
        <i class="fa fa-cog fa-spin fa-3x fa-fw" style="margin-bottom: 800px"></i>
    </div>
    <div class="form-header" style="padding-left: 15px">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="header-title row">
            <h3 class="col-md-12 col-sm-12 col-xs-12">Báo cáo tồn kho</h3>
            <div style="display: flex; align-items: center;">
                <a href="https://lms.tienngay.vn/"><i class="fa fa-home"></i> Khác </a>  <i style="margin: 0 5px;" class="fa fa-angle-right" aria-hidden="true"></i> <a href="https://lms.tienngay.vn/pawn/contract"> báo cáo </a>
            </div>
        </div>
        <div class="header-btn">
            @if($reportCreateBtn)
            <a type="button" href="{{route('viewcpanel::trade.inventory.reportCreate')}}"
               class="btn btn-success create">Thêm mới &nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"></i></a>
            @endif
        </div>
    </div>
    <div class="form-body">
        <div class="body-title">
            <h3>Danh sách báo cáo tồn kho </h3>
            <div class="body-btn">
                <div class="row" style="align-items: right;">
                    <div class="col-xs-12 col-12">
                        @include("viewcpanel::trade.inventory.filterReport")
                    </div>
                </div>
            </div>
        </div>
        <div class="table-body ">
            <div class="table-responsive">
                <table class="table table-hover total_table"
                       style="text-align: center; vertical-align: middle;word-wrap: break-word;">
                    <thead style="background-color: #E8F4ED">
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Phòng giao dịch</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Người tạo</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Chức năng</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($listReport) && count($listReport) > 0)
                        @foreach($listReport as $key => $item)
                            <tr>
                                <td>{{$perPage + ++$key}}</td>
                                <td>{{$item['store_name']}}</td>
                                <td>{{date('d/m/Y H:i:s', $item['created_at'])}}</td>
                                <td>{{$item['created_by']}}</td>
                                @if($status)
                                    @foreach($status as $k => $st)
                                        @if($k == $item['status'])
                                            <td>{{$st}}</td>
                                        @endif
                                    @endforeach
                                @endif
                                <td>
                                    <div class="dropdown-center">
                                        <button class="btn" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                            <img
                                                src="https://service.tienngay.vn/uploads/avatar/1669274405-d140100df2f4852a97aab1ae7a0fe508.png"
                                                alt="">
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item detail"
                                                   href="{{route('viewcpanel::trade.inventory.reportDetail', ['id' => $item['_id']])}}">Xem chi tiết</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-danger" style="text-align: center">
                                Không có dữ liệu ( Không có kết quả nào được tìm thấy ! )
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            @if(!empty($listReport))
                <nav aria-label="Page navigation" style="margin-top: 20px;">
                    {{$listReport->withQueryString()->render('viewcpanel::trade.paginate')}}
                </nav>
            @endif
        </div>
    </div>

    <!-- Modal khu vuc ap dung-->
    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title item_header"></h5>
                </div>
                <div class="modal-body" style="max-height: 500px">
                    <ul class="nav">

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.14.0/js/selectize.min.js"></script>
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
    <script type="text/javascript">
        var store = $('#store');
        store.selectize({
            plugins: ["restore_on_backspace"],
            maxItems: 1,
            allowEmptyOption: true,
            emptyOptionLabel: ""
        });

        $('.create').click(function (event){
            event.preventDefault();
            let targetLink = $(event.target).attr('href');
            Redirect(targetLink, false);
        })

        $('.detail').click(function (event){
            event.preventDefault();
            let targetLink = $(event.target).attr('href');
            Redirect(targetLink, false);
        })

        $('#date').datepicker({
            orientation: "top",
            format: "dd-mm-yyyy",
            minDate: 1
        });

        $('#date2').datepicker({
            orientation: "top",
            format: "dd-mm-yyyy",
            minDate: 1
        });
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
        $('body').on('click', function (e) {
            if (e.target.id == "fillter-content" || $(e.target).parents("#fillter-content").length) {
                //do nothing
            } else {
                $("#fillter-content").hide();
            }
        });
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
    <script type="text/javascript" src="{{ asset('viewcpanel/js/xlsx.js') }}"></script>

@endsection

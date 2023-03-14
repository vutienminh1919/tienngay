@extends('viewcpanel::layouts.master')
@section('css')
@section('title', 'Chi tiết tồn kho PGD')
@endsection
<style>

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
        padding: 12px 0px;
    }

    .body-title h3 {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: #3B3B3B;
    }

    .table th {
        font-weight: 600;
        font-size: 14px;
        line-height: 40px;
        color: #262626;
        text-align: center;
        vertical-align: baseline;
        white-space: nowrap;
    }

    .table td {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
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
        padding: 6px 28px;
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
        padding: 6px 28px;
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

    .table td {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 30px;
        color: #676767;
        vertical-align: middle;
        text-align: center;
        width: 150px !important;
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
</style>
<div class="wrapper"  style="padding: 20px;">
    <div id="loading" class="theloading" style="display: none;">
        <i class="fa fa-cog fa-spin fa-3x fa-fw" style="margin-bottom: 800px"></i>
    </div>
    <div class="form-header">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="header-title row">
            <h3 class="col-md-12 col-sm-12 col-xs-12">Chi tiết tồn kho phòng {{$detail['store_name']}}</h3>
            <small>
                <a href="#" class="list">Quản lý tồn kho ấn phẩm</a> > <a href="#">Chi tiết tồn kho</a>
            </small>
        </div>
        <div class="header-btn">
            <button type="button" class="btn btn-outline-secondary back">Trở về <i class="fa fa-arrow-left" aria-hidden="true"></i></button>
        </div>
    </div>
    <div class="form-body">
        <div class="body-title">
            <h3>Danh sách ấn phẩm </h3>
            <div class="body-btn">
                <div class="row" style="align-items: right;">
                    <div class="col-xs-12 col-12">
                        <button type="button"
                        class="btn btn-outline-success excel_storage" onclick='excel_storage("xlsx", "danh_sach_an_phan_ton_kho_pgd_{{$detail['store_name']}}")'>Xuất excel <img
                            src="https://service.tienngay.vn/uploads/avatar/1669364070-d7a257cd601ea15a96b19fb403608675.png"
                            alt=""></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-body ">
            <div class="table-responsive">
                <table class="table total_table" id="excel_storage"
                       style="text-align: center; vertical-align: middle;word-wrap: break-word;">
                    <thead style="background-color: #E8F4ED">
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Mã ấn phẩm</th>
                        <th scope="col">Tên ấn phẩm</th>
                        <th scope="col">Loại ấn phẩm</th>
                        <th scope="col">Quy cách</th>
                        <th scope="col">Số lượng nhập</th>
                        <th scope="col">Số lượng xuất</th>
                        <th scope="col">Số lượng tồn</th>
                        <th scope="col">Chênh lệch điều chỉnh</th>
                        <th scope="col">Số lượng cũ/hủy</th>
                        <th scope="col">Số lượng hỏng</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if($items)
                            @foreach($items as $key => $item)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$item['code_item']}}</td>
                                    <td>{{$item['name']}}</td>
                                    <td>{{$item['type']}}</td>
                                    <td>{{str_replace(",", ", ",$item['specification'])}}</td>
                                     @php
                                        $quantity_import = isset($item['quantity_import']) ? $item['quantity_import'] : 0;
                                        $quantity_import_1 = isset($item['quantity_import_1']) ? $item['quantity_import_1'] : 0;
                                    @endphp
                                    <td>{{$quantity_import + $quantity_import_1}}</td>
                                    @php
                                        $quantity_export = isset($item['quantity_export']) ? $item['quantity_export'] : 0;
                                        $quantity_export_1 = isset($item['quantity_export_1']) ? $item['quantity_export_1'] : 0;
                                    @endphp
                                    <td>{{$quantity_export + $quantity_export_1 }}</td>
                                    <td>{{$item['quantity_stock'] ?? 0}}</td>
                                    <td>{{$item['quantity_diff'] ?? 0}}</td>
                                    <td>{{$item['quantity_old'] ?? 0}}</td>
                                    <td>{{$item['quantity_broken'] ?? 0}}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            @if(!empty($items))
                <nav aria-label="Page navigation" style="margin-top: 20px;">
                    {{$items->withQueryString()->render('viewcpanel::trade.paginate')}}
                </nav>
            @endif
        </div>

        <div class="body-title">
            <h3>Danh sách báo cáo tồn kho </h3>
            <div class="body-btn">
                <div class="row" style="align-items: right;">
                </div>
            </div>
        </div>
        <div class="table-body ">
            <div class="table-responsive">
                <table class="table total_table"
                       style="text-align: center; vertical-align: middle;word-wrap: break-word;">
                    <thead style="background-color: #E8F4ED">
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Người tạo</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Chức năng</th>

                    </tr>
                    </thead>
                    <tbody>
                        @if($report)
                            @foreach($report as $key => $r)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{date('d/m/Y H:i:s', $r['created_at'])}}</td>
                                    <td>{{$r['created_by']}}</td>
                                    @if($status)
                                        @foreach($status as $k => $st)
                                            @if($k == $r['status'])
                                    <td>{{$st}}</td>
                                            @endif
                                        @endforeach
                                    @endif

                                    <td><div class="dropdown-center">
                                        <button class="btn" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                            <img
                                                    src="https://service.tienngay.vn/uploads/avatar/1669274405-d140100df2f4852a97aab1ae7a0fe508.png"
                                                    alt="">
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item detail" href="{{route('viewcpanel::trade.inventory.reportDetail', ['id' => $r['_id']])}}">Chi tiết</a></li>
                                        </ul>
                                    </div></td>

                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            @if(!empty($report))
                <nav aria-label="Page navigation" style="margin-top: 20px;">
                    {{$report->withQueryString()->render('viewcpanel::trade.paginate')}}
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
    <script type="text/javascript" src="{{ asset('viewcpanel/js/xlsx.js') }}"></script>
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

        function excel_storage(fileExtension, fileName) {
            let el = document.getElementById("excel_storage");
            let wb = XLSX.utils.table_to_sheet(el, {sheet: 'Sheet1'});
            const ne = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(ne, wb, "Sheet1");
            return XLSX.writeFile(ne, fileName + "." + fileExtension || ('MySheetName.' + (fileExtension || 'xlsx')));
        }

        $('.back').click(function (event) {
            event.preventDefault();
            console.log('1')
            Redirect("{{route('viewcpanel::trade.inventory.index')}}", false);
        })

        $('.detail').click(function (e) {
            e.preventDefault();
            let targetLink = $(e.target).attr('href');
            console.log('1')
            Redirect(targetLink, false)
        })


        $('#date').datepicker({
            orientation: "top",
            format: "yyyy-mm-dd",
            minDate: 1
        });

        $('#date2').datepicker({
            orientation: "top",
            format: "yyyy-mm-dd",
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
    </script>

@endsection

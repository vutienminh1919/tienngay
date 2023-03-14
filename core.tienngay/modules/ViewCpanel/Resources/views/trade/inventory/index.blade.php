<?php $tab = !empty($_GET['tab']) ? $_GET['tab'] : "storage" ?>
<?php $area_search = !empty($_GET['area']) ? $_GET['area'] : "" ?>
<?php $store_search = !empty($_GET['store']) ? $_GET['store'] : "" ?>
<?php $domain_search = !empty($_GET['domain']) ? $_GET['domain'] : "" ?>
<?php $name_search = !empty($_GET['name']) ? $_GET['name'] : "" ?>
<?php $type_search = !empty($_GET['type']) ? $_GET['type'] : "" ?>


@extends('viewcpanel::layouts.master')

@section('title', 'Tồn kho ấn phẩm')

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background-color: rgb(237, 237, 237) !important;
    }

    .wrapper {
        width: 100%;
        padding: 0px 20px;
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

    }

    .box1-header,
    .box2-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 22px 16px;

    }

    .nav-footer {
        /* position: absolute; */
        right: 0;
        bottom: 0;

    }


    .box1-header h3 {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: #3B3B3B;
    }

    .box2-header h3 {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: #3B3B3B;
    }

    th {
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 35px;
        color: #262626;
        border-bottom-width: 0px !important;
        white-space: nowrap;
        text-align: center !important;
    }

    td {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #676767;
        white-space: nowrap;
        text-align: center;
    }


    thead {
        background-color: #E8F4ED;
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

    .form-select-modal select {
        width: 100%;
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        height: 40px;
        outline: none;
    }

    .form-select-modal label {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #3B3B3B;
    }

    .modal-body {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .modal h2 {
        font-style: normal;
        font-weight: 600;
        font-size: 16px !important;
        line-height: 20px;
        color: #3B3B3B;
    }

    .form-select-modal {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .modal-btn button {
        width: 100%;
    }

    .btn_list_filter {
        text-align: right;
    }

    .btn_list_filter1 {
        text-align: right;
    }

    .btn_list_filter2 {
        text-align: right;
    }

    .btn_list_filter .btn-fitler {
        display: inline-block
    }

    .btn_list_filter1 .btn-fitler1 {
        display: inline-block
    }

    .btn_list_filter2 .btn-fitler1 {
        display: inline-block
    }

    .btn-fitler input {
        padding-top: 3.5px;
        padding-bottom: 8.5px
    }

    .btn-fitler1 input {
        padding-top: 3.5px;
        padding-bottom: 8.5px
    }

    .btn-fitler2 input {
        padding-top: 3.5px;
        padding-bottom: 8.5px
    }

    #fillter-button, #select-time, .btn-func {
        font-size: 14px !important
    }

    #fillter-button1, #select-time, .btn-func {
        font-size: 14px !important
    }

    #fillter-button2, #select-time, .btn-func {
        font-size: 14px !important
    }

    #fillter-content {
        width: 300px;
        right: 175px !important
    }

    #fillter-content1 {
        width: 300px;
        right: 175px !important
    }

    #fillter-content2 {
        width: 350px;
        right: 175px !important
    }

    #fillter-content * {
        font-size: 14px !important
    }

    #fillter-content1 * {
        font-size: 14px !important
    }

    #fillter-content2 * {
        font-size: 14px !important
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

    .tab-item {
        min-width: 80px;
        height: 40px;
        color: #676767;
        cursor: pointer;
        transition: all 0.5s ease;
        padding-bottom: 10px;
        padding: 0px 10px;
        font-weight: 600;
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

    .page-link:focus {
        background-color: #1D9752 !important;
        color: #fff !important;
    }

    .page-link {
        color: #676767 !important;
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
        #fillter-content2 {
            width: 350px;
            right: 160px !important
        }

        .header {
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: self-start;
        }

        .box1-header,
        .box2-header {
            display: contents;
            flex-direction: column;
        }

        .box1,
        .box2 {
            display: flex;
            flex-direction: column;
            gap: 10px;
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

    @media only screen and (min-width: 46.25em) and (max-width: 63.9375em) {

        .box1,
        .box2 {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
    }
</style>
<section class="xk_pgd">
    <div class="wrapper">
        <div class="header">
            <div class="header-title">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <h3>Quản lý tồn kho ấn phẩm</h3>
                <small>
                    <a href="https://lms.tienngay.vn/"><i class="fa fa-home"></i> Khác</a> / <a
                        href="https://lms.tienngay.vn/pawn/contract">yêu cầu</a>
                </small>
            </div>
        </div>
        <div id="Tabs">
            <!-- Tab items -->
            <div class="tabs">
                <div class="tab-item <?= $tab == 'item' ? "active" : "" ?>">
                    <a style="text-decoration: none;color: <?= $tab == 'item' ? '#1D9752' : '#676767' ?>;"
                       class="tab_item_1"
                       href="{{route('viewcpanel::trade.inventory.index') . "?tab=item"}}">Danh sách tồn kho ấn phẩm</a>
                </div>
                <div class="tab-item <?= $tab == 'storage' ? "active" : "" ?>">
                    <a style="text-decoration: none;color: <?= $tab == 'storage' ? '#1D9752' : '#676767' ?>;"
                       class="tab_storage_1"
                       href="{{route('viewcpanel::trade.inventory.index') . "?tab=storage"}}"> Danh sách tồn kho theo
                        PGD</a>
                </div>

                <div class="tab-item <?= $tab == 'history_storage' ? "active" : "" ?>">
                    <a style="text-decoration: none;color: <?= $tab == 'history_storage' ? '#1D9752' : '#676767' ?>;"
                       class="tab_history_1"
                       href="{{route('viewcpanel::trade.inventory.index') . "?tab=history_storage"}}"> Lịch sử nhập xuất
                        tồn</a>
                </div>
                <div class="line"></div>
            </div>

            <!-- Tab content -->
            <div class="tab-content">
                {{--                tabs 1 - Danh sách tồn kho ấn phẩm --}}
                <div class="tab-pane <?= $tab == 'item' ? "active" : "" ?>">
                    <div class="box2">
                        <div class="box2-header">
                            <h3>Danh sách ấn phẩm</h3>
                            @include('viewcpanel::trade.inventory.filterItem')
                        </div>
                        <div class="box2-table table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Mã ấn phẩm</th>
                                    <th scope="col">Tên ấn phẩm</th>
                                    <th scope="col">Loại ấn phẩm</th>
                                    <th scope="col">Quy cách ấn phẩm</th>
                                    <th scope="col">Số lượng nhập</th>
                                    <th scope="col">Số lượng xuất</th>
                                    <th scope="col">Số lượng tồn</th>
                                    <th scope="col">Số lượng cũ/hủy</th>
                                    <th scope="col">Số lượng hỏng</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    @if($items)
                                        @foreach($items as $key => $item)
                                            <td>{{++$key}}</td>
                                            <td>{{$item['_id']}}</td>
                                            <td>{{$item['name'][0]}}</td>
                                            <td>{{$item['type'][0]}}</td>
                                            <td>{{str_replace(",", ", ",$item['specification'][0])}}</td>
                                            @php
                                                $quantity_export = $item['quantity_export'] ?? 0;
                                                $quantity_export_transfer = $item['quantity_export_transfer'] ?? 0;
                                                $quantity_import = $item['quantity_import'] ?? 0;
                                                $quantity_import_transfer = $item['quantity_import_transfer'] ?? 0;
                                            @endphp
                                            <td>{{$quantity_import}}</td>
                                            <td>{{$quantity_export}}</td>
                                            <td>{{$item['quantity_stock'] ?? 0}}</td>
                                            <td>{{$item['quantity_old'] ?? 0}}</td>
                                            <td>{{$item['quantity_broken'] ?? 0}}</td>
                                </tr>
                                @endforeach
                                @else
                                    <tr>
                                        <td class="text-danger" colspan="10">
                                            Không có dữ liệu ( Không có kết quả nào được tìm thấy ! )
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            @include('viewcpanel::trade.inventory.excelItem')

                        </div>
                        @if(!empty($items))
                            <nav aria-label="Page navigation" style="margin-top: 20px;">
                                {{$items->withQueryString()->render('viewcpanel::trade.paginate')}}
                            </nav>
                        @endif
                    </div>
                </div>
                {{--                tabs 2 -  danh sách tồn kho theo pgd--}}
                <div class="tab-pane <?= $tab == 'storage' ? "active" : "" ?>">
                    <div class="box1">
                        <div class="box1-header">
                            <h3>Danh sách tồn kho theo PGD</h3>
                            @include('viewcpanel::trade.inventory.filterStorage')
                        </div>
                        <div class="box1-table table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Phòng giao dịch</th>
                                    <th scope="col">Số loại ấn phẩm</th>
                                    <th scope="col">Số lượng nhập</th>
                                    <th scope="col">Số lượng xuất</th>
                                    <th scope="col">Số lượng tồn</th>
                                    <th scope="col">Số lượng cũ/hủy</th>
                                    <th scope="col">Số lượng hỏng</th>
                                    <th scope="col">Chức năng</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($storage)
                                    @foreach($storage as $key => $item)
                                        <tr style="background-color: <?= (!empty($item['alert']) && $item['alert'] == 1) ? "#F4CDCD" : ""?>">
                                            <td scope="row">{{++$key}}</td>
                                            <td>{{$item['store_name']}}</td>
                                            <td>{{count($item['items'])}}</td>
                                            @php
                                                $quantity_export = $item['quantity_export'] ?? 0;
                                                $quantity_export_transfer = $item['quantity_export_transfer'] ?? 0;
                                                $quantity_import = $item['quantity_import'] ?? 0;
                                                $quantity_import_transfer = $item['quantity_import_transfer'] ?? 0;
//                                            @endphp
                                            <td>{{$quantity_import + $quantity_import_transfer}}</td>
                                            <td>{{$quantity_export + $quantity_export_transfer}}</td>
                                            <td>{{array_sum(array_column($item['items'], 'quantity_stock'))}}</td>
                                            <td>{{array_sum(array_column($item['items'], 'quantity_old'))}}</td>
                                            <td>{{array_sum(array_column($item['items'], 'quantity_broken'))}}</td>
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
                                                               href="{{route('viewcpanel::trade.inventory.storageDetail', ['id' => $item['_id']])}}">Chi
                                                                tiết</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-danger" colspan="9">
                                            Không có dữ liệu ( Không có kết quả nào được tìm thấy ! )
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        @if(!empty($storage))
                            <nav aria-label="Page navigation" style="margin-top: 20px;">
                                {{$storage->withQueryString()->render('viewcpanel::trade.paginate')}}
                            </nav>
                        @endif
                    </div>
                </div>
                {{--                                    tabs 3 -  lịch sử xuất nhập tồn--}}
                <div class="tab-pane <?= $tab == 'history_storage' ? "active" : "" ?>">
                    <div class="box1">
                        <div class="box1-header">
                            <h3>Danh sách ấn phẩm</h3>
                            @include('viewcpanel::trade.inventory.filterHistoryStorage')
                        </div>
                        <div class="box1-table table-responsive">
                            <table class="table table-hover history_table" id="history_table">
                                <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Ngày</th>
                                    <th scope="col">Mã ấn phẩm</th>
                                    <th scope="col">Tên ấn phẩm</th>
                                    <th scope="col">Loại ấn phẩm</th>
                                    <th scope="col">Quy cách</th>
                                    <th scope="col">Loại giao dịch</th>
                                    <th scope="col">Nhà cung cấp</th>
                                    <th scope="col">Đơn giá</th>
                                    <th scope="col">Phòng giao dịch</th>
                                    <th scope="col">Số lượng nhập</th>
                                    <th scope="col">Thành tiền nhập</th>
                                    <th scope="col">Số lượng xuất</th>
                                    <th scope="col">Thành tiền xuất</th>
                                    <th scope="col">Số lượng tồn</th>
                                    <th scope="col">Thành tiền tồn</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="10" class="total">Tổng</td>
                                    <td>{{number_format($totalAmountBuy)}}</td>
                                    <td>{{number_format($totalPriceBuy)}}</td>
                                    <td>{{number_format($totalAmountDelivery)}}</td>
                                    <td>{{number_format($totalPriceDelivery)}}</td>
                                    <td>0</td>
                                    <td>0</td>
                                </tr>
                                @if (isset($historyTrade))
                                    @foreach ($historyTrade as $key => $item)
                                        <tr>
                                            <td>{{++ $key}}</td>
                                            <td>{{!empty($item['created_at']) ? date('d-m-Y', $item['created_at']) : ''}}</td>
                                            <td>{{$item['code_item']}}</td>
                                            <td>{{!empty($item['name']) ? $item['name'] : ''}}</td>
                                            <td>{{!empty($item['type']) ? $item['type'] : ''}}</td>
                                            <td>{{!empty($item['specification']) ? str_replace(",", ", ",$item['specification']) : ''}}</td>
                                            <td>
                                                @foreach ($transactionType as $k => $transaction)
                                                    @if ($k == $item['action'])
                                                        {{$transaction}}
                                                    @else
                                                        @continue;
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{!empty($item['ncc']) ? $item['ncc'] : ''}}</td>
                                            <td>
                                                {{$item['avg'] ?? 0}}
                                            </td>
                                            <td>{{!empty($item['store_name']) ? $item['store_name'] : ''}}</td>
                                            <td>
                                                @if ($item['action'] == 1 || ($item['action'] == 3 && $item['type_report'] == "import" ))
                                                    {{$item['amount']}}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item['action'] == 1 || ($item['action'] == 3 && $item['type_report'] == "import" ))
                                                    {{$item['amount']*$item['avg']}}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item['action'] == 2 || ($item['action'] == 3 && $item['type_report'] == "export")  || $item['action'] == 4)
                                                    {{$item['amount']}}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item['action'] == 2 || ($item['action'] == 3 && $item['type_report'] == "export") || $item['action'] == 4)
                                                    {{$item['amount']*$item['avg']}}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item['action'] == 5)
                                                    {{$item['amount']}}
                                                @endif
                                            </td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="nav-footer">
                            @if(!empty($historyTrade))
                                <nav aria-label="Page navigation" style="margin-top: 20px;">
                                    {{$historyTrade->withQueryString()->render('viewcpanel::trade.paginate')}}
                                </nav>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
        function export_item(fileExtension, fileName) {
            let el = document.getElementById("table-item");
            let wb = XLSX.utils.table_to_sheet(el, {sheet: 'Sheet1'});
            const ne = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(ne, wb, "Sheet1");
            return XLSX.writeFile(ne, fileName + "." + fileExtension || ('MySheetName.' + (fileExtension || 'xlsx')));
        }


        var dataSearch = JSON.parse('{!! json_encode($dataSearch) !!}');
        for (const property in dataSearch) {
            if (dataSearch[property] == null) {
                continue;
            }
            console.log(property, ' ', dataSearch[property]);
            $('#search-form').find("[name='" + property + "']").val(dataSearch[property]);
        }


        let name = '{!! json_encode($name) !!}'
        console.log(JSON.parse('{!! json_encode($name) !!}'));
        $('.name').change(function (event) {
            event.preventDefault();
            $('#type').html('');
            console.log($('#name').val())
            $.each(JSON.parse('{!! json_encode($name) !!}'), function (k, v) {
                if ($('#name').val() == v._id) {
                    console.log('1')
                    $('#type').append('<option value="">--Chọn loại--</option>')
                    $.each(v.type, function (key, value) {
                        console.log(value)

                        $('#type').append('<option value="' + value + '">' + value + '</option>')
                    })

                }
            })
        })


        $(".detail").on('click', function (e) {
            e.preventDefault();
            let targetLink = $(e.target).attr('href');
            Redirect(targetLink, false);
        });

        {{--$(".tab_item").on('click', function (e) {--}}
        {{--    e.preventDefault();--}}
        {{--    let targetLink = $(e.target).attr('href');--}}
        {{--    window.parent.postMessage({targetLink: targetLink}, "{{$cpanelPath}}");--}}
        {{--});--}}

        {{--$(".tab_storage").on('click', function (e) {--}}
        {{--    e.preventDefault();--}}
        {{--    let targetLink = $(e.target).attr('href');--}}
        {{--    window.parent.postMessage({targetLink: targetLink}, "{{$cpanelPath}}");--}}
        {{--});--}}

        {{--$(".tab_hsitory").on('click', function (e) {--}}
        {{--    e.preventDefault();--}}
        {{--    let targetLink = $(e.target).attr('href');--}}
        {{--    window.parent.postMessage({targetLink: targetLink}, "{{$cpanelPath}}");--}}
        {{--});--}}

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
        $(document).ready(function () {
            $('#domain').change(function (event) {
                event.preventDefault();
                let domain = $(this).val();
                let formData = new FormData();
                formData.append('domain', domain);
                $.ajax({
                    url: '{{route('viewcpanel::trade.inventory.getAreaByDomain')}}',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $('#area').attr('disabled', true);
                        $('#area').html('');
                        $('#store').attr('disabled', true);
                        $('#store').html('');
                    },
                    success: function (data) {
                        if (data.status == 200) {
                            $('#area').attr('disabled', false);
                            console.log(data);
                            $('#area').append('<option value="">--Chọn khu vực--</option>')
                            $.each(data.data, function (key, value) {
                                $('#area').append('<option value="' + value.code + '">' + value.title + '</option>')
                            })
                        } else {

                        }
                    },
                    error: function () {
                    }
                });
            })

            $('#area').change(function (event) {
                event.preventDefault();
                let code = $(this).val();
                let formData = new FormData();
                formData.append('code', code);
                $.ajax({
                    url: '{{route('viewcpanel::trade.inventory.getStoreByCodeArea')}}',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $('#store').attr('disabled', true);
                        $('#store').html('');
                    },
                    success: function (data) {
                        if (data.status == 200) {
                            $('#store').attr('disabled', false);
                            console.log(data);
                            $('#store').append('<option value="">--Chọn phòng giao dịch--</option>')
                            $.each(data.data, function (key, value) {
                                $('#store').append('<option value="' + value._id + '">' + value.name + '</option>')
                            })
                        } else {

                        }
                    },
                    error: function () {
                    }
                });
            })
        });


        $("#fillter-button").on("click", function (event) {
            event.stopPropagation();
            $("#fillter-content").toggle();
        })
        $("#fillter-button1").on("click", function (event) {
            event.stopPropagation();
            $("#fillter-content1").toggle();
        })
        $("#fillter-button2").on("click", function (event) {
            event.stopPropagation();
            $("#fillter-content2").toggle();
        })
        $("#clear-search-form").on("click", function (event) {
            event.preventDefault();
            $("#type option:selected").removeAttr("selected");
            $("#type option:first").attr('selected', 'selected');
            document.getElementById("search-form").reset();
        });
        $("#clear-search-form2").on("click", function (event) {
            event.preventDefault();
            document.getElementById("search-form2").reset();
        });
        $("#clear-search-form1").on("click", function (event) {
            event.preventDefault();
            $('#area').attr('disabled', true);
            $('#area').html('');
            $('#store').attr('disabled', true);
            $('#store').html('');
            $("#domain option:first").attr('selected', true);
            $("#domain option[value='MB']").removeAttr("selected");
            $("#domain option[value='MN']").removeAttr("selected");
            document.getElementById("search-form1").reset();
        });
        $("#close-search-form").on("click", function (event) {
            event.preventDefault();
            $("#fillter-content").hide();
        });
        $("#close-search-form1").on("click", function (event) {
            event.preventDefault();
            $("#fillter-content1").hide();
        });
        $("#close-search-form2").on("click", function (event) {
            event.preventDefault();
            $("#fillter-content2").hide();
        });
        $('body').on('click', function (e) {
            if (e.target.id == "fillter-content" || $(e.target).parents("#fillter-content").length) {
                //do nothing
            } else {
                $("#fillter-content").hide();
            }
        });
        $('body').on('click', function (e) {
            if (e.target.id == "fillter-content1" || $(e.target).parents("#fillter-content1").length) {
                //do nothing
            } else {
                $("#fillter-content1").hide();
            }
        });
        $('body').on('click', function (e) {
            if (e.target.id == "fillter-content2" || $(e.target).parents("#fillter-content2").length) {
                //do nothing
            } else {
                $("#fillter-content2").hide();
            }
        });
    </script>

    <script type="text/javascript">
        function export_history(fileExtension, fileName) {
            let el = document.getElementById("history_table");
            let wb = XLSX.utils.table_to_sheet(el, {sheet: 'Lịch sử xuất nhập tồn'});
            const ne = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(ne, wb, "Lịch sử xuất nhập tồn");
            return XLSX.writeFile(ne, fileName + "." + fileExtension || ('MySheetName.' + (fileExtension || 'xlsx')));
        }
    </script>
@endsection

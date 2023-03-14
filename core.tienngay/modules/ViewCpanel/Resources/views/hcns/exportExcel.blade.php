@extends('viewcpanel::layouts.master')

@section('title', 'Export Lead')

@section('css')
<link href="{{ asset('viewcpanel/css/exportExcel/export.css') }}" rel="stylesheet"/>
@endsection

@section('content')
<div id="loading" class="theloading" style="display: none;">
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
</div>
<section class="main-content" hidden>
    <div class="container" style="max-width: 95% !important">
        <h5 class="tilte_top_tabs">
            Export Lead
        </h5>
        <div class="row" style="align-items: right;">
            <div class="col-xs-12 col-12">
                <li><a id="export-excel" class="dropdown-item" file-name="blacklist-nhan-su" clone-table="export-object" href="javascriptvoid:0">Xuất báo cáo</a></li>
            </div>
        </div>
    </div>
</section>

<!-- export object -->
<table id="export-object" class="table table-striped" hidden >
    <thead>
        <tr style="text-align: center">
            <th style="text-align: center;">STT</th>
            <th scope="col" style="text-align: center; min-width: 200px;">HỌ VÀ TÊN</th>
            <th scope="col" style="text-align: center; min-width: 200px;">EMAIL CÁ NHÂN</th>
            <th scope="col" style="text-align: center; min-width: 200px;">SỐ ĐIỆN THOẠI<i data-bs-toggle="tooltip" title="" data-bs-original-title="" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></th>
            <th scope="col" style="text-align: center; min-width: 200px;">ĐỊA CHỈ<i data-bs-toggle="tooltip" title="" data-bs-original-title="Địa chỉ thường trú" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></th>
            <th scope="col" style="text-align: center; min-width: 200px;">SỐ CMND/CCCD/HỘ CHIẾU</th>
            <th scope="col" style="text-align: center; min-width: 200px;">NGÀY CẤP</th>
            <th scope="col" style="text-align: center; min-width: 200px;">NƠI CẤP</th>
            <th scope="col" style="text-align: center; min-width: 200px;">NGÀY BẮT ĐẦU</th>
            <th scope="col" style="text-align: center; min-width: 200px;">NGÀY NGHỈ VIỆC</th>
            <th scope="col" style="text-align: center; min-width: 200px;">ĐỊA ĐIỂM LÀM VIỆC</th>
            <th scope="col" style="text-align: center; min-width: 200px;">PHÒNG BAN</th>
            <th scope="col" style="text-align: center; min-width: 200px;">CHỨC VỤ</th>
            <th scope="col" style="text-align: center; min-width: 200px;">LÝ DO NGHỈ VIỆC</th>
            <th scope="col" style="text-align: center; min-width: 200px;">NGÀY TẠO</th>
            <th scope="col" style="text-align: center; min-width: 200px;">NGƯỜI TẠO</th>
            <th scope="col" style="text-align: center; min-width: 100px;" no-export></th>
        </tr>
    </thead>
    <tbody align="center" id="table-rows">
        <tr id="clone-item" data-id="" style="background: #037734, color: #fff">
            <td id="transaction_no" style="text-align: left;">
                <input id="selected_item" type="checkbox" class="selected_item" name="selected_item[]">
            </td>
            <td data-attr='user_name'></td>
            <td data-attr='user_email'></td>
            <td data-attr='user_phone' zero-before='true'></td>
            <td data-attr='permanent_address'></td>
            <td data-attr='user_identify' zero-before='true'></td>
            <td data-attr='date_range'></td>
            <td data-attr='issued_by'></td>
            <td data-attr='day_on'></td>
            <td data-attr='day_off'></td>
            <td data-attr='work_place'></td>
            <td data-attr='room'></td>
            <td data-attr='position'></td>
            <td data-attr='reason_for_leave' style="word-break: break-all;"></td>
            <td data-attr='created_at' timestampToDateWithTime='true'></td>
            <td data-attr='created_by'></td>
        </tr>
    </tbody>
</table>
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('viewcpanel/js/helper.js') }}"></script>
<script type="text/javascript">
    var transactions = @json($records);
</script>
<script type="text/javascript" src="{{ asset('viewcpanel/js/xlsx.js') }}"></script>
<script type="text/javascript" src="{{ asset('viewcpanel/js/exportExcel/export.js') }}"></script>
@endsection

@extends('viewcpanel::layouts.master')

@section('title', 'Export MIC TNDS')

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
            Export Bảo Hiểm MIC TNDS
        </h5>
        <div class="row" style="align-items: right;">
            <div class="col-xs-12 col-12">
                <li><a id="export-excel" class="dropdown-item" file-name="bh-mic-tnds" clone-table="export-object" href="javascriptvoid:0">Xuất báo cáo</a></li>
            </div>
        </div>
    </div>
</section>

<!-- export object -->
<table id="export-object" class="table table-striped" hidden >
    <thead>
        <tr style="text-align: center">
            <th style="text-align: center;">STT</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Tên khách hàng</th>
            <th scope="col" style="text-align: center; min-width: 150px;">Mã giao dịch</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Phí</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Ngày hiệu lực</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Ngày hết hạn</th>
            <th scope="col" style="text-align: center; min-width: 100px;">PGD</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số CMT</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Phone</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Email</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Địa chỉ</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Ngày tạo</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Người tạo</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Trạng thái</th>
            <th scope="col" style="text-align: center; min-width: 100px;" no-export></th>
        </tr>
    </thead>
    <tbody align="center" id="table-rows">
        <tr id="clone-item" data-id="" style="background: #037734, color: #fff">
            <td id="transaction_no" style="text-align: left;">
                <input id="selected_item" type="checkbox" class="selected_item" name="selected_item[]">
            </td>
            <td data-attr='customer_info.customer_name'></td>
            <td data-attr='mic_code'></td>
            <td data-attr='mic_fee'></td>
            <td data-attr='NGAY_HL'></td>
            <td data-attr='NGAY_KT'></td>
            <td data-attr='store.name'></td>
            <td data-attr='customer_info.card' zero-before='true'></td>
            <td data-attr='customer_info.customer_phone' zero-before='true'></td>
            <td data-attr='customer_info.email'></td>
            <td data-attr='customer_info.address'></td>
            <td data-attr='created_at' timestamp='true'></td>
            <td data-attr='created_by'></td>
            <td data-attr='status' func='statusBH'></td>
        </tr>
    </tbody>
</table>
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('viewcpanel/js/helper.js') }}"></script>
<script type="text/javascript">
    var transactions = @json($results['data']);
    console.log(transactions);
    var tcvStores = @json($tcvStores);
    var tcvDbStores = @json($tcvDbStores);
    var tcvHcmStores = @json($tcvHcmStores);

    function statusBH(val, el) {
        switch (val) {
            case 1:
                el.text("Kế toán đã duyệt");
                break;
            case 2:
                el.text("Chờ kế toán xác nhận");
                break;
            case 3:
                el.text("Kế toán hủy");
                break;
            case 10:
                el.text("PGD đã thu tiền");
                break;
            case 11:
                el.text("Kế toán trả về");
                break;
        }
    }

    function chanBH(val, el) {
        console.log(val);
        if (val == 1 || val == "1") {
            el.text("Chặn");
        } else {
            el.text("Không chặn");
        }
    }

</script>
<script type="text/javascript" src="{{ asset('viewcpanel/js/xlsx.js') }}"></script>
<script type="text/javascript" src="{{ asset('viewcpanel/js/exportExcel/exportBaoHiem.js') }}"></script>
@endsection

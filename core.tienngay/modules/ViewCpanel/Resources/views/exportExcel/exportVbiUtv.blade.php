@extends('viewcpanel::layouts.master')

@section('title', 'Export VBI UTV')

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
            Export Bảo Hiểm VBI Ung Thư Vú
        </h5>
        <div class="row" style="align-items: right;">
            <div class="col-xs-12 col-12">
                <li><a id="export-excel" class="dropdown-item" file-name="bh-vic-utv" clone-table="export-object" href="javascriptvoid:0">Xuất báo cáo</a></li>
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
            <th scope="col" style="text-align: center; min-width: 150px;">Mã BH</th>
            <th scope="col" style="text-align: center; min-width: 150px;">Mã HĐ</th>
            <th scope="col" style="text-align: center; min-width: 150px;">Số tiền vay</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Gói BH</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Phí BH</th>
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
            <th scope="col" style="text-align: center; min-width: 100px;">Chặn bảo hiểm</th>
            <th scope="col" style="text-align: center; min-width: 100px;" no-export></th>
        </tr>
    </thead>
    <tbody align="center" id="table-rows">
        <tr id="clone-item" data-id="" style="background: #037734, color: #fff">
            <td id="transaction_no" style="text-align: left;">
                <input id="selected_item" type="checkbox" class="selected_item" name="selected_item[]">
            </td>
            <td data-attr='contract_info.customer_infor.customer_name'></td>
            <td data-attr='vbi_utv.so_id_vbi' zero-before='true'></td>
            <td data-attr='contract_info.code_contract_disbursement'></td>
            <td data-attr='contract_info.loan_infor.amount_money'></td>
            <td data-attr='goi_bh'></td>
            <td data-attr='fee'></td>
            <td data-attr='NGAY_HL' func='cusTime'></td>
            <td data-attr='NGAY_KT' func='cusTime'></td>
            <td data-attr='contract_info.store.name'></td>
            <td data-attr='contract_info.customer_infor.customer_identify' zero-before='true'></td>
            <td data-attr='contract_info.customer_infor.customer_phone_number' zero-before='true'></td>
            <td data-attr='contract_info.customer_infor.customer_email'></td>
            <td data-attr='contract_info.current_address' func='addressFunc'></td>
            <td data-attr='created_at' timestamp='true'></td>
            <td data-attr='created_by'></td>
            <td data-attr='vbi_utv.response_code' func='statusBH'></td>
            <td data-attr='contract_info.chan_bao_hiem' func='chanBH'></td>
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
        console.log(val);
        if (val == "00") {
            el.text("Thành công");
        } else {
            el.text("Thất bại");
        }
    }

    function chanBH(val, el) {
        if (val == 1 || val == "1") {
            el.text("Chặn");
        }
    }

    function addressFunc(val, el) {
        el.text(val.current_stay + "/" + val.ward_name + "/" + val.district_name + "/" + val.province_name);
    }

    function cusTime(val, el) {
        let date = val.substring(0, 4) + '/' + val.substring(4, 6) + '/' + val.substring(6, 8);
        el.text(date);
    }

</script>
<script type="text/javascript" src="{{ asset('viewcpanel/js/xlsx.js') }}"></script>
<script type="text/javascript" src="{{ asset('viewcpanel/js/exportExcel/exportBaoHiem.js') }}"></script>
@endsection

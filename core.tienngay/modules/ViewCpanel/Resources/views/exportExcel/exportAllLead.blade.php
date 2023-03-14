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
                <li><a id="export-excel" class="dropdown-item" file-name="danh-sach-all-lead" clone-table="export-object" href="javascriptvoid:0">Xuất báo cáo</a></li>
            </div>
        </div>
    </div>
</section>

<!-- export object -->
<table id="export-object" class="table table-striped" hidden >
    <thead>
        <tr style="text-align: center">
            <th style="text-align: center;">STT</th>
            <th scope="col" style="text-align: center; min-width: 100px;">CSKH</th>
            <th scope="col" style="text-align: center; min-width: 350px;">NGÀY THÁNG</th>
            <th scope="col" style="text-align: center; min-width: 350px;">NGUỒN</th>
            <th scope="col" style="text-align: center; min-width: 100px;">UTM_SOURCE</th>
            <th scope="col" style="text-align: center; min-width: 100px;">UTM_CAMPAIGN</th>
            <th scope="col" style="text-align: center; min-width: 150px;">KHU VỰC</th>
            <th scope="col" style="text-align: center; min-width: 150px;">HỌ VÀ TÊN</th>
            <th scope="col" style="text-align: center; min-width: 150px;">SỐ ĐIỆN THOẠI</th>
            <th scope="col" style="text-align: center; min-width: 150px;">TRẠNG THÁI LEAD</th>
            <th scope="col" style="text-align: center; min-width: 150px;">LÝ DO HUỶ</th>
            <th scope="col" style="text-align: center; min-width: 300px;">CHUYỂN ĐẾN PGD</th>
            <th scope="col" style="text-align: center; min-width: 100px;">TRẠNG THÁI HỢP ĐỒNG GN</th>
            <th scope="col" style="text-align: center; min-width: 300px;">SỐ TIỀN GN</th>
            <th scope="col" style="text-align: center; min-width: 100px;">HK_XÃ</th>
            <th scope="col" style="text-align: center; min-width: 250px;">HK_HUYỆN</th>
            <th scope="col" style="text-align: center; min-width: 100px;">HK_TỈNH</th>
            <th scope="col" style="text-align: center; min-width: 100px;">NS_XÃ</th>
            <th scope="col" style="text-align: center; min-width: 250px;">NS_HUYỆN</th>
            <th scope="col" style="text-align: center; min-width: 100px;">NS_TỈNH</th>
            <th scope="col" style="text-align: center; min-width: 100px;">GHI CHÚ</th>
            <th scope="col" style="text-align: center; min-width: 300px;">SẢN PHẨM VAY</th>
            <th scope="col" style="text-align: center; min-width: 100px;">VỊ TRÍ/CHỨC VỤ</th>
            <th scope="col" style="text-align: center; min-width: 100px;">CMND/CCCD</th>
            <th scope="col" style="text-align: center; min-width: 100px;">CSKH TÁI VAY</th>
            <th scope="col" style="text-align: center; min-width: 100px;">TRANSACTION_ID</th>
            <th scope="col" style="text-align: center; min-width: 100px;">ĐỘ ƯU TIÊN</th>
            <th scope="col" style="text-align: center; min-width: 100px;" no-export></th>
        </tr>
    </thead>
    <tbody align="center" id="table-rows">
        <tr id="clone-item" data-id="" style="background: #037734, color: #fff">
            <td id="transaction_no" style="text-align: left;">
                <input id="selected_item" type="checkbox" class="selected_item" name="selected_item[]">
            </td>
            <td data-attr='cskh'></td>
            <td data-attr='created_at' timestampToDateWithTime='true'></td>
            <td data-attr='source' func="lead_nguon"></td>
            <td data-attr='utm_source'></td>
            <td data-attr='utm_campaign' style="word-break: break-all;"></td>
            <td data-attr='area' func='get_province_name_by_code'></td>
            <td data-attr='fullname'></td>
            <td data-attr='phone_number'></td>
            <td data-attr='status_sale' func="lead_status"></td>
            <td data-attr='reason_cancel' func="reason"></td>
            <td data-attr='id_PDG' func="getPGDName"></td>
            <td data-attr='contract_info.0.status' func="getStatusContract"></td>
            <td data-attr='contract_info.0.loan_infor.amount_loan'></td>
            <td data-attr='hk_ward' func="get_ward_name_by_code"></td>
            <td data-attr='hk_district' func="get_district_name_by_code"></td>
            <td data-attr='hk_province' func="get_province_name_by_code"></td>
            <td data-attr='ns_ward' func="get_ward_name_by_code"></td>
            <td data-attr='ns_district' func="get_district_name_by_code"></td>
            <td data-attr='ns_province' func="get_province_name_by_code"></td>
            <td data-attr='tls_note'></td>
            <td data-attr='type_finance' func="lead_type_finance"></td>
            <td data-attr='position'></td>
            <td data-attr='identify_lead'></td>
            <td data-attr='cskh_taivay'></td>
            <td data-attr='_id'></td>
            <td data-attr='priority' func="priorityName"></td>
        </tr>
    </tbody>
</table>
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('viewcpanel/js/helper.js') }}"></script>
<script type="text/javascript">
    var transactions = @json($results["data"]);
    $stores = @json($stores);
    var $storesArr = {};
    $stores.forEach(function(value, index) {
        let _key = value._id;
        $storesArr[_key] = value;
    });
    function lead_nguon($status) {
    if ($status == "" || (typeof $status == undefined) || (typeof $status == null) || (typeof $status == 'object')) {
        return "";
    }
    $leadstatus = @json($results["source"]);
    if ($leadstatus[$status] === "" || $leadstatus[$status] === undefined || $leadstatus[$status] === null) {
        return "";
    }
    return $leadstatus[$status];
}
    function getPGDName($id) {
        if ($id === "") return "";
        console.log($storesArr);
        if ($storesArr === "") return "";
        if ($storesArr[$id] === "" || $storesArr[$id] === undefined || $storesArr[$id] === null) {
            return "";
        }
        return $storesArr[$id]["name"];
    }

    function priorityName($priority) {
        var priority_name = "" ;
        if($priority == "1"){
            priority_name = "cao"
        }
        else if($priority == "2"){
             priority_name = "trung bình"
        }
        else{
            priority_name = "thấp"
        }
        return priority_name;
    }

</script>
<script type="text/javascript" src="{{ asset('viewcpanel/js/exportExcel/exportxls.js') }}"></script>
@endsection

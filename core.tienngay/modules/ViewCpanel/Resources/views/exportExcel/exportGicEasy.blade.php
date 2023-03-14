@extends('viewcpanel::layouts.master')

@section('title', 'Export Gic Easy')

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
            Export Bảo Hiểm GIC Easy
        </h5>
        <div class="row" style="align-items: right;">
            <div class="col-xs-12 col-12">
                <li><a id="export-excel" class="dropdown-item" file-name="bh-gic-easy" clone-table="export-object" href="javascriptvoid:0">Xuất báo cáo</a></li>
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
            <th scope="col" style="text-align: center; min-width: 150px;">Mã hợp đồng</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số Tiền Vay</th>
            <th scope="col" style="text-align: center; min-width: 100px;">PGD</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Số CMT</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Phone</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Email</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Địa chỉ</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Mã BH</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Gói bảo hiểm</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Phí bảo hiểm</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Ngày hiệu lực</th>
            <th scope="col" style="text-align: center; min-width: 100px;">Ngày hết hạn</th>
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
            <td data-attr='gic_info.thongTinNguoiDuocBaoHiem_CaNhan_Ten'></td>
            <td data-attr='contract_info.code_contract_disbursement'></td>
            <td data-attr='contract_info.loan_infor.amount_money'></td>
            <td data-attr='store.name'></td>
            <td data-attr='gic_info.thongTinNguoiDuocBaoHiem_CaNhan_SoCMND' zero-before='true'></td>
            <td data-attr='gic_info.thongTinNguoiDuocBaoHiem_CaNhan_SoDienThoai' zero-before='true'></td>
            <td data-attr='gic_info.thongTinNguoiDuocBaoHiem_CaNhan_Email'></td>
            <td data-attr='gic_info.thongTinNguoiDuocBaoHiem_CaNhan_DiaChi'></td>
            <td data-attr='gic_code'></td>
            <td data-attr='contract_info.loan_infor.code_GIC_easy'></td>
            <td data-attr='gic_info.noiDungBaoHiem_PhiBaoHiem_VAT'></td>
            <td data-attr='gic_info.noiDungBaoHiem_NgayHieuLucBaoHiem'></td>
            <td data-attr='gic_info.noiDungBaoHiem_NgayHieuLucBaoHiemDen'></td>
            <td data-attr='created_at' timestamp='true'></td>
            <td data-attr='contract_info.created_by'></td>
            <td data-attr='gic_info.thongTinChung_TrangThaiHdId' func='statusBH'></td>
            <td data-attr='contract_info.chan_bao_hiem' func='chanBH'>Không chặn</td>
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
            case '4e9eb09f-2834-409f-a987-9928d4d8eac9':
                el.text("Đã đính kèm chứng từ");
                break;
            case '566e72ce-fb1a-456e-b337-b968ae47f0cc':
                el.text("Đã duyệt");
                break;
            case '30fe988b-0e95-4ae9-a5cb-2cf3214f97e0':
                el.text("Hoàn tất");
                break;
            case 'acc31454-af61-4896-b9a6-7d79ac8f9e37':
                el.text("Tạo mới");
                break;
            case '817eaae4-46e3-41f9-befb-ac52c3c01933':
                el.text("Chấm dứt hợp đồng");
                break;
            case 'c2105d39-f3bd-4932-98d8-7c5766a96bb9':
                el.text("Từ chối duyệt");
                break;
            case '7c666d28-765d-413a-ab8e-6c39e937ea72':
                el.text("Thanh toán đủ");
                break;
            case '93fbe0b2-1bab-4915-84bf-4abdca935952':
                el.text("Thanh toán 1 phần");
                break;
            case '2f77342d-ddc2-4194-8b2a-48068237a5c2':
                el.text("Hết hiệu lực");
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

@extends('viewcpanel::layouts.master')

@section('title', 'VPBank - Chi tiết giao dịch')

@section('css')
<link href="{{ asset('viewcpanel/css/vpbank/detail.css') }}" rel="stylesheet"/>
<style type="text/css">

</style>
@endsection

@section('content')
<section class="main-content">
    <div id="loading" class="theloading" style="display: none;">
        <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    </div>
    <div class="container">
    <header>
        <h5 style="display: inline-block;" class="title tilte_top_tabs">CHI TIẾT GIAO DỊCH</h6>
        <h6 style="display: inline-block;"></h5>
    </header>
    <section>
        <div class="content-left boder-radius background-white width50 padding-bottom-50">
            <div style="position: relative;">
                <h6 class="title tilte_top_tabs">Thông tin khách hàng thụ hưởng:</h6>
                <table style="margin-left: 60px">
                    <tbody>
                        <tr>
                            <td>Tên KH:</td>
                            <td>{{$transaction["name"]}}</td>
                        </tr>
                        <tr>
                            <td width="200px">Số CMT/CCCD:</td>
                            <td>{{$transaction["identity_card"]}}</td>
                        </tr>
                        <tr>
                            <td>Hợp đồng:</td>
                            <td>{{$transaction["contract_code_disbursement"]}}</td>
                        </tr>
                        <tr>
                            <td>Mã phiếu ghi:</td>
                            <td>{{$transaction["contract_code"]}}</td>
                        </tr>
                        <tr>
                            <td>Phòng GD:</td>
                            <td>{{$transaction["store_name"]}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="content-left boder-radius background-white margin-top50 padding-bottom-150">
            <div class="width50" style="display: inline-block;">
                <h6 class="title tilte_top_tabs">Thông tin giao dịch:</h6>
                <table style="margin-left: 60px">
                    <tbody>
                        <tr>
                            <td width="200px">Mã giao dịch VPBank:</td>
                            <td>{{$transaction["transactionId"]}}</td>
                        </tr>
                        <tr>
                            <td width="200px">Mã Phiếu Thu:</td>
                            <td style="color: #EC1E24">{{$transaction["tn_trancode"]}}</td>
                        </tr>
                        <tr>
                            <td>Số tiền GD:</td>
                            <td>{{number_format($transaction["amount"])}} VNĐ</td>
                        </tr>
                        <tr>
                            <td>Nội dung chuyển khoản:</td>
                            <td><textarea disabled rows="3">{{$transaction["remark"]}}</textarea></td>
                        </tr>
                        <tr>
                            <td>Thời gian chuyển khoản:</td>
                            <td>{{$transaction["transactionDate"]}}</td>
                        </tr>
                        <tr>
                            <td>Thời gian ghi nhận giao dịch:</td>
                            <td>{{$transaction["created_at"]}}</td>
                        </tr>
                        <tr>
                            <td>Trạng thái thanh toán:</td>
                            <td style="color: #047734"><strong>{{$transaction["status_text"]}}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="right" style="position: relative; right: 50px;">
                <h6 class="title tilte_top_tabs">Thông tin tài khoản:</h6>
                <table style="margin-left: 60px">
                    <tbody>
                        <tr>
                            <td width="200px">Số TK Chuyên Thu <i data-bs-toggle="tooltip" title="" data-bs-original-title="Số tài khoản chuyên thu (Master account number)" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i>:</td>
                            <td>{{$transaction["masterAccountNumber"]}}</td>
                        </tr>
                        <tr>
                            <td width="200px">Số TK VAN <i data-bs-toggle="tooltip" title="" data-bs-original-title="Số tài khoản ảo thu hộ (Vitural Account Number)" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i>:</td>
                            <td>{{$transaction["virtualAccountNumber"]}}</td>
                        </tr>
                        <tr>
                            <td width="200px">Tên TK VAN <i data-bs-toggle="tooltip" title="" data-bs-original-title="Tên tài khoản ảo thu hộ (Vitural Account Name)" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i>:</td>
                            <td>{{$transaction["van_name"]}}</td>
                        </tr>
                        <tr>
                            <td width="200px">Mã PGD Quản Lý:</td>
                            <td>{{$store["vpb_store_code"]}}</td>
                        </tr>
                        <tr>
                            <td width="200px">Tên PGD Quản Lý:</td>
                            <td>{{$store["name"]}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
</section>
@endsection

@section('script')
<script type="text/javascript">
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endsection

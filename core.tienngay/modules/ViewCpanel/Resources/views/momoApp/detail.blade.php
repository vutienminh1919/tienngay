<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>CHI TIẾT GIAO DỊCH</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}"/>
	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<!-- Bootstrap -->
	
    <link rel="stylesheet" type="text/css" href="{{ asset('viewcpanel/css/paymentgateway/detail.css') }}">
</head>
<body>
<div class="container">
    <header>
        <h5 style="display: inline-block;" class="title">CHI TIẾT GIAO DỊCH <span style="color: #047734">{{$transaction["contract_code_disbursement"]}}</span></h5>
        <h6 style="display: inline-block;"></h6>
    </header>
    <section>
        <div class="content-left boder-radius background-white width50 padding-bottom-50">
            <div style="position: relative;">
                <h5 class="title">Thông tin khách hàng thụ hưởng:</h5>
                <table style="margin-left: 60px">
                    <tbody>
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
                            <td>Tên KH:</td>
                            <td>{{$transaction["name"]}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="content-left boder-radius background-white margin-top50 padding-bottom-150">
            <div class="width50" style="display: inline-block;">
                <h5 class="title">Thông tin giao dịch:</h5>
                <table style="margin-left: 60px">
                    <tbody>
                        <tr>
                            <td width="200px">Mã giao dịch:</td>
                            <td>{{$transaction["transactionId"]}}</td>
                        </tr>
                        <tr>
                            <td>Thời gian:</td>
                            <td>{{$transaction["paid_date"]}}</td>
                        </tr>
                        <tr>
                            <td>Trạng thái:</td>
                            <td>{{$transaction["contract_status_text"]}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="right" style="position: relative; right: 50px;">
                <h5 class="title">Thông tin thanh toán chi tiết:</h5>
                <table style="margin-left: 60px">
                    <tbody>
                        <tr>
                            <td width="200px">Tổng tiền thanh toán:</td>
                            <td>{{number_format($transaction["total_amount"])}}</td>
                        </tr>
                        @if($transaction["late_fee"] != 0)
                        <tr>
                            <td>Phí chậm trả:</td>
                            <td>{{number_format($transaction["late_fee"])}}</td>
                        </tr>
                        @endif
                        @if($transaction["early_repayment_charge"] != 0)
                        <tr>
                            <td>Phí tất toán trước hạn:</td>
                            <td>{{number_format($transaction["early_repayment_charge"])}}</td>
                        </tr>
                        @endif
                        @if($transaction["cost_incurred"] != 0)
                        <tr>
                            <td>Phí phát sinh:</td>
                            <td>{{number_format($transaction["cost_incurred"])}}</td>
                        </tr>
                        @endif
                        @if($transaction["unpaid_money"] != 0)
                        <tr>
                            <td>Tiền thiếu kỳ trước:</td>
                            <td>{{number_format($transaction["unpaid_money"])}}</td>
                        </tr>
                        @endif
                        @if($transaction["balance_prev_term"] != 0)
                        <tr>
                            <td>Tiền dư kỳ trước:</td>
                            <td>{{number_format($transaction["balance_prev_term"])}}</td>
                        </tr>
                        @endif
                        @if($transaction["excess_payment"] != 0)
                        <tr>
                            <td>Tiền dư thanh toán:</td>
                            <td>{{number_format($transaction["excess_payment"])}}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                <div class="bill_total">
                    <table style="margin-left: 60px">
                        <tbody>
                            <tr>
                                <td width="200px">Tổng tiền đã thanh toán:</td>
                                <td>{{number_format($transaction["paid_amount"])}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('viewcpanel/js/bootstrap.min.js') }}"></script>

</body>
</html>



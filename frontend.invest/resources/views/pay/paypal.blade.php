@extends('layout.master')
@section('page_name','Thanh toán lãi kỳ')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">VFC Investor</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="">Thanh toán</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="#" class="text-info">Chi tiết thanh toán</a>
                </li>
            </ol>
        </div>
    </div>
    @include('layout.alert_success')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Head --}}
                    <div class="row mb-2">
                        <div class="col-12">
                            <h1 class="d-inline-block">Chi tiết giao dịch</h1>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    {{-- Table --}}
                    <div class="row mb-4">
                        <div class="col-md-12 col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-nowrap table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Nhà đầu tư</th>
                                        <td>{{$pay['contract']['investor']['code']}}</td>
                                        <th>Mã hợp đồng</th>
                                        <td>{{$pay['contract']['code_contract_disbursement']}}</td>
                                    </tr>
                                    <tr>
                                        <th>Số tiền đầu tư</th>
                                        <td style="color: red">{{number_format($pay['contract']['amount_money'])}}
                                            VND
                                        </td>
                                        <th>Hình thức trả lãi</th>
                                        <td>{{type_interest($pay['contract']['type_interest'])}}</td>
                                    </tr>
                                    <tr>
                                        <th>Tổng lãi</th>
                                        <td style="color: red;">{{number_format($lai['tong_lai'])}}
                                            VND
                                        </td>
                                        <th>Tổng gốc lãi</th>
                                        <td style="color: red;">{{number_format($lai['tong_goc_lai'])}}
                                            VND
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Kì thanh toán</th>
                                        <td>Kỳ {{$pay['ky_tra']}}</td>
                                        <th>Ngày thanh toán</th>
                                        <td>{{date('d/m/Y')}}</td>
                                    </tr>
                                    <tr>
                                        <th>Số tiền thanh toán</th>
                                        <td style="color: red;">{{number_format(round($pay['goc_lai_1ky']))}}
                                            VND
                                        </td>
                                        <th>Loại thanh toán</th>
                                        <td>
                                            @if(!empty($pay['contract']['investor']['type_interest_receiving_account']))
                                                @if($pay['contract']['investor']['type_interest_receiving_account'] == 'vimo')
                                                    <span class="text-blue">Thanh toán qua Ví VIMO</span>
                                                @elseif($pay['contract']['investor']['type_interest_receiving_account'] == 'bank')
                                                    <span
                                                        class="text-yellow">Thanh toán chuyển khoản từ NGANLUONG</span>
                                                @endif
                                            @else
                                                <span class="text-danger">Chưa xác định</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if($pay['contract']['investor']['type_interest_receiving_account'] == 'bank')
                                        <tr>
                                            <th>Khách Hàng - Ngân Hàng</th>
                                            <td>{{$pay['contract']['investor']['name_bank_account'] .' - '.$pay['contract']['investor']['bank_name']}}</td>
                                            <th>{{$pay['contract']['investor']['type_card'] == 2 ? "Số thẻ ATM" : "Số tài khoản ngân hàng"}}</th>
                                            <td>{{$pay['contract']['investor']['interest_receiving_account']}}</td>
                                        </tr>
                                    @elseif($pay['contract']['investor']['type_interest_receiving_account'] == 'momo')
                                        <tr>
                                            <th>Khách Hàng</th>
                                            <td>{{$pay['contract']['investor']['name']}}</td>
                                            <th>Số tài khoản ví VIMO</th>
                                            <td>{{$pay['contract']['investor']['phone_vimo']}}</td>
                                        </tr>
                                    @endif
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 mt-2">
                            <label class="text-success text-bold">Ghi chú:</label>
                            <textarea class="form-control" name="note_paypal" rows="5"></textarea>
                        </div>
                        <div class="col-md-12 col-sm-12 mt-3">
                            <div class="row">
                                <div class="col-md-6 col-sx-12">
                                    <a class="btn btn-secondary d-inline-block float-right"
                                       href="{{route('pay.list')}}">Trở về</a>
                                </div>
                                <div class="col-md-6 col-sx-12">
                                    @if($pay['status'] !== 4)
                                        <button class="btn btn-success xac_nhan_thanh_toan" data-id="{{$pay['id']}}">
                                            Xác
                                            nhận
                                        </button>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('project_js/pay/paypal.js')}}"></script>
@endsection

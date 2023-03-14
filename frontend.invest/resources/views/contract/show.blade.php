@extends('layout.master')
@section('page_name','Chi tiết hợp đồng')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">VFC Investor</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('contract.list')}}">Quản lý hợp
                        đồng</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="#" class="text-info">Chi tiết hợp đồng</a></li>
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
                            <h1 class="d-inline-block">Chi tiết hợp đồng</h1>
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
                                        <th style="text-align: center">Nhà đầu tư</th>
                                        <td style="text-align: center">{{$contract['investor']['name']}}</td>
                                        <th style="text-align: center">Mã hợp đồng</th>
                                        <td style="text-align: center">{{$contract['code_contract_disbursement']}}</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: center">Số tiền đầu tư</th>
                                        <td style="text-align: center">{{number_format($contract['amount_money'])}}
                                            VND
                                        </td>
                                        <th style="text-align: center">Hình thức trả lãi</th>
                                        <th style="text-align: center">{{type_interest($contract['type_interest'])}}</th>
                                    </tr>
                                    <tr>
                                        <th style="text-align: center">Tổng lãi</th>
                                        <td style="color: red;text-align: center">{{number_format($contract['tong_lai'])}}
                                            VND
                                        </td>
                                        <th style="text-align: center">Tổng gốc lãi</th>
                                        <td style="color: red;text-align: center">{{number_format($contract['tong_goc_lai'])}}
                                            VND
                                        </td>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-nowrap table-striped">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center">Kì trả</th>
                                        <th style="text-align: center">Lãi kì</th>
                                        <th style="text-align: center">Tiền gốc trả</th>
                                        <th style="text-align: center">Tổng tiền trả</th>
                                        <th style="text-align: center">Lãi suất</th>
                                        <th style="text-align: center">Trạng thái</th>
                                        <th style="text-align: center">Ngày trả</th>
                                        @if($contract['type_contract'] == 'UQ')
                                            <th style="text-align: center">Kì trả lãi</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($contract['pays'] as $key => $item)
                                        <tr style="text-align: center">
                                            <td>Kì {{$item['ky_tra']}}</td>
                                            <td>{{number_format(round($item['lai_ky']))}} VND</td>
                                            <td>{{number_format(round($item['tien_goc_1ky']))}} VND</td>
                                            <td class="text-danger">{{number_format(round($item['goc_lai_1ky']))}}VND
                                            </td>
                                            <td>{{$item['interest']}} %</td>
                                            @if($item['status'] == 2)
                                                <td><span class="badge badge-success">Đã thanh toán</span></td>
                                            @else
                                                <td><span class="badge badge-danger">Chưa thanh toán</span></td>
                                            @endif
                                            <td>{{date('d/m/Y',$item['ngay_ky_tra'])}}</td>
                                            @if($contract['type_contract'] == 'UQ')
                                                <td>{{date('d/m/Y',$item['interest_period'])}}</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

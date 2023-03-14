@extends('layout.master')
@section('page_name','Quản lý hoa hồng nhà đầu tư')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">VFC Investor</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('commission')}}" class="text-info">Quản
                        lý hoa hồng nhà đầu tư</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="" class="text-success">Chi tiết hoa hồng</a>
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
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="float-right d-inline-block" id="filter-data">
                                @if(in_array(\App\Service\ActionInterface::EXCEL_COMMISSION, $action_global) || $is_admin == 1)
                                    <a class="btn btn-success"
                                       href="{{route('commission.excel_detail')}}?id={{request()->get('id')}}&month={{request()->get('month') ?? date('Y-m')}}"
                                       target="_blank">
                                        <i class="fas fa-file-excel"></i>&nbsp;
                                        Excel
                                    </a>
                                @endif
                                <a class="btn btn-primary" href="#" data-bs-toggle="dropdown">
                                    <i class="fas fa-filter"></i>&nbsp;
                                    Lọc dữ liệu
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-card" style="width: 500px;">
                                    <div class="card d-flex flex-column">
                                        <div class="card-body d-flex flex-column">
                                            <form method="get" action="{{route('commission.detail')}}">
                                                <div class="mb-3">
                                                    <div class="text-large">Thông tin tìm kiếm</div>
                                                    <hr class="mt-2 mb-0">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Tháng</label>
                                                    <div>
                                                        <input type="month" name="month" class="form-control"
                                                               value="{{ request()->get('month') }}"
                                                               autocomplete="off">
                                                    </div>
                                                    <div>
                                                        <input type="hidden" name="id" class="form-control"
                                                               value="{{ request()->get('id') }}"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="form-group text-right">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-search"></i>&nbsp; Tìm kiếm
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="table-responsive">
                                            <table
                                                class="table table-vcenter table-nowrap table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Người giới thiệu</th>
                                                    <td><strong
                                                            style="text-transform: uppercase">{{$data['total']['full_name'] ?? ""}}</strong>
                                                    </td>
                                                    <th>Số điện thoại</th>
                                                    <td>{{$data['total']['phone'] ?? ""}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Tháng</th>
                                                    <td>{{$data['total']['month'] ?? ""}}</td>
                                                    <th>Tổng tiền</th>
                                                    <td class="text-danger">{{!empty($data['total']['total_money']) ? number_format($data['total']['total_money']) : 0}}</td>
                                                </tr>
                                                <tr>
                                                    <th></th>
                                                    <td class="text-danger"></td>
                                                    <th>Tổng tiền thưởng</th>
                                                    <td class="text-danger">{{!empty($data['total']['money_commission']) ? number_format($data['total']['money_commission']) : 0}}</td>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- Table --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-nowrap table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center">STT</th>
                                        <th style="text-align: center">Tên nhà đầu tư</th>
                                        <th style="text-align: center">Mã hợp đồng</th>
                                        <th style="text-align: center">Số tiền đầu tư</th>
                                        <th style="text-align: center">Số tiền tính hoa hồng</th>
                                        <th style="text-align: center">Ngày giao dịch</th>
                                        <th style="text-align: center">Thời gian</th>
                                        <th style="text-align: center">Hình thức đầu tư</th>
                                        <th style="text-align: center">Tỉ lệ thưởng</th>
                                        <th style="text-align: center">Tiền thưởng</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($data['detail']) > 0)
                                        @foreach($data['detail'] as $key => $item)
                                            <tr style="text-align: center">
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $item['nha_dau_tu'] ?? "" }}</td>
                                                <td>{{ $item['ma_hop_dong'] ?? "" }}</td>
                                                <td>{{ !empty($item['so_tien_dau_tu']) ? number_format($item['so_tien_dau_tu']) : ''}}</td>
                                                <td class="text-danger">{{!empty($item['so_tien']) ?  number_format($item['so_tien']) : ""}}</td>
                                                <td>{{ !empty($item['ngay_giao_dich']) ? date('d-m-Y', strtotime($item['ngay_giao_dich'])) : "" }}</td>
                                                <td>{{ !empty($item['thoi_gian']) ? $item['thoi_gian'] . ' tháng': "" }}</td>
                                                <td>{{ !empty($item['hinh_thuc']) ? $item['hinh_thuc'] : "" }}</td>
                                                <td>{{ !empty($item['ti_le_thuong']) ? $item['ti_le_thuong'] . '%' : "" }}</td>
                                                <td class="text-success">{{ !empty($item['tien_thuong']) ?  number_format($item['tien_thuong']) : "" }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="20" class="text-danger" style="text-align: center">Không có dữ
                                                liệu
                                            </td>
                                        </tr>
                                    @endif
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

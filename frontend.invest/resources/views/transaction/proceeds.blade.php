@extends('layout.master')
@section('page_name','Quản lý tiền thu')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">VFC Investor</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('transaction.proceeds')}}"
                                                                   class="text-info">Quản
                        lý tiền thu</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="card" style="border-radius: 10px;">
                        <div class="card-body" style="background-color: #56B6F7;border-radius: 10px;">
                            <div class="d-flex align-items-center mt-3" style="color: white">
                                <div class="">Tổng tất cả</div>
                                <div class="ms-auto lh-1">
                                    <div class="">
                                        {{!empty($overview['tong_giao_dich']) ? $overview['tong_giao_dich'] : 0}}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mt-3">
                                <div class="ms-auto">
                                    <h2><span class="d-inline-flex align-items-center" style="color: white">
                                         {{!empty($overview['tong_tien_thu_duoc']) ? number_format($overview['tong_tien_thu_duoc']) : 0}}
                                    </span>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card" style="border-radius: 10px;">
                        <div class="card-body" style="background-color: #EBAB5D;border-radius: 10px;">
                            <div class="d-flex align-items-center mt-3" style="color: white">
                                <div class="">Tổng tiền (năm {{date('Y')}})</div>
                                <div class="ms-auto lh-1">
                                    <div class="">
                                        {{!empty($overview['tong_giao_dich_theo_nam']) ? $overview['tong_giao_dich_theo_nam'] : 0}}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mt-3">
                                <div class="ms-auto">
                                    <h2><span class="d-inline-flex align-items-center" style="color: white">
                                        {{!empty($overview['tong_tien_thu_duoc_theo_nam']) ? number_format($overview['tong_tien_thu_duoc_theo_nam']) : 0}}
                                    </span>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card" style="border-radius: 10px;">
                        <div class="card-body" style="background-color: #F1B8CC;border-radius: 10px;">
                            <div class="d-flex align-items-center mt-3" style="color: white">
                                <div class="">Tổng tiền (tháng {{date('m/Y')}})</div>
                                <div class="ms-auto lh-1">
                                    <div class="">
                                        {{!empty($overview['tong_giao_dich_theo_thang']) ? $overview['tong_giao_dich_theo_thang'] : 0}}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mt-3">
                                <div class="">
                                    <h2>
                                        @if($xu_the == 2)
                                            <span class="text-success">+{{$tang_truong}} <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="icon ms-1"
                                                    width="24" height="24"
                                                    viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor"
                                                    fill="none"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"><path
                                                        stroke="none" d="M0 0h24v24H0z" fill="none"></path><polyline
                                                        points="3 17 9 11 13 15 21 7"></polyline><polyline
                                                        points="14 7 21 7 21 14"></polyline></svg></span>
                                        @elseif($xu_the == 1)
                                            <span style="color: #D63939">-{{$tang_truong}} <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="icon ms-1" width="24"
                                                    height="24" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round"><path
                                                        stroke="none" d="M0 0h24v24H0z" fill="none"></path><polyline
                                                        points="3 7 9 13 13 9 21 17"></polyline><polyline
                                                        points="21 10 21 17 14 17"></polyline></svg></span>
                                        @else
                                            <span style="color: #F76707">{{$tang_truong}} <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="icon ms-1" width="24"
                                                    height="24" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round"><path
                                                        stroke="none" d="M0 0h24v24H0z" fill="none"></path><line x1="5"
                                                                                                                 y1="12"
                                                                                                                 x2="19"
                                                                                                                 y2="12"></line></svg>
                                            </span>
                                        @endif
                                    </h2>
                                </div>
                                <div class="ms-auto">
                                    <h2><span class="d-inline-flex align-items-center" style="color: white">
                                         {{!empty($overview['tong_tien_thu_duoc_theo_thang']) ? number_format($overview['tong_tien_thu_duoc_theo_thang']) : 0}}
                                    </span>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card" style="border-radius: 10px;">
                        <div class="card-body" style="background-color: #51B1B3;border-radius: 10px;">
                            <div class="d-flex align-items-center mt-3" style="color: white">
                                <div class="">Tổng tiền (ngày {{date('d/m/Y')}})</div>
                                <div class="ms-auto lh-1">
                                    <div class="">
                                        {{!empty($overview['tong_giao_dich_theo_ngay']) ? $overview['tong_giao_dich_theo_ngay'] : 0}}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mt-3">
                                <div class="ms-auto">
                                    <h2><span class="d-inline-flex align-items-center" style="color: white">
                                         {{!empty($overview['tong_tien_thu_duoc_theo_ngay']) ? number_format($overview['tong_tien_thu_duoc_theo_ngay']) : 0}}
                                    </span>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @include('layout.alert_success')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Head --}}
                    <div class="row mb-4">
                        <div class="col-12">
                            <h1 class="d-inline-block">Danh sách tiền thu</h1>
                            {{-- Search --}}
                            <div class="float-right d-inline-block" id="filter-data">
                                @if(in_array(\App\Service\ActionInterface::EXCEL_GIAO_DICH_DAU_TU, $action_global) || $is_admin == 1)
                                    <a class="btn btn-success"
                                       href="{{route('transaction.excelTransactionInvest')}}?fdate={{request()->get('fdate')}}&tdate={{request()->get('tdate')}}&order_code={{request()->get('order_code')}}&investor_code={{request()->get('investor_code')}}"
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
                                            <form method="get">
                                                <div class="mb-3">
                                                    <div class="text-large">Thông tin tìm kiếm</div>
                                                    <hr class="mt-2 mb-0">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Ngày bắt đầu</label>
                                                    <div>
                                                        <input type="date" name="fdate" class="form-control"
                                                               value="{{ request()->get('fdate') }}"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Ngày kết thúc</label>
                                                    <div>
                                                        <input type="date" name="tdate" class="form-control"
                                                               value="{{ request()->get('tdate') }}"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Mã giao dịch</label>
                                                    <div>
                                                        <input type="text" name="order_code" class="form-control"
                                                               placeholder="Mã giao dịch"
                                                               value="{{ request()->get('order_code') }}"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Tên nhà đầu tư</label>
                                                    <div>
                                                        <input type="text" name="full_name" class="form-control"
                                                               placeholder="Mã nhà đâu tư"
                                                               value="{{ request()->get('full_name') }}"
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
                    {{-- Table --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-nowrap table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center">STT</th>
                                        <th style="text-align: center">Ngày giao dịch</th>
                                        <th style="text-align: center">Mã hợp đồng</th>
                                        <th style="text-align: center">Loại giao dịch</th>
                                        <th style="text-align: center">Mã giao dịch</th>
                                        <th style="text-align: center">Tên nhà đầu tư</th>
                                        <th style="text-align: center">Số tiền</th>
                                        <th style="text-align: center">Lãi suất(/tháng)</th>
                                        <th style="text-align: center">Thời gian</th>
                                        <th style="text-align: center">Hình thức đầu tư</th>
                                        <th style="text-align: center">Trạng thái</th>
                                        @if(in_array('telesales', $roles))
                                            <th style="text-align: center">TLS</th>
                                        @endif
                                        <th class="w-1" style="text-align: center"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($data) >0 )
                                        @foreach($data as $key => $item)
                                            <tr style="text-align: center">
                                                <td>{{ ++$key + (($paginate->currentPage()-1)*$paginate->perPage()) }}</td>
                                                <td>{{ date('d/m/Y H:i:s',strtotime($item['created_at'])) }}</td>
                                                <td>{{ $item['code_contract_disbursement'] }}</td>
                                                <td>
                                                    @if(isset($item['payment_source']))
                                                        @if($item['payment_source'] == 'momo')
                                                            <span
                                                                class="badge bg-pink">{{$item['payment_source']}}</span>
                                                        @elseif($item['payment_source'] == 'nganluong')
                                                            <span
                                                                class="badge bg-yellow">{{$item['payment_source']}}</span>
                                                        @else
                                                            <span
                                                                class="badge bg-blue">{{$item['payment_source']}}</span>
                                                        @endif
                                                    @else
                                                        <span class="badge bg-blue">vimo</span>
                                                    @endif
                                                </td>
                                                <td>{{ $item['transaction_vimo'] ? $item['transaction_vimo'] : $item['trading_code']}}</td>
                                                <td>{{ $item['name'] }}</td>
                                                <td class="text-danger">{{ number_format($item['investment_amount']) }}</td>
                                                <td class="text-primary">{{ data_get(json_decode($item['interest'], true),'interest') }}
                                                    %
                                                </td>
                                                <td>{{ $item['number_day_loan']/30 }} tháng</td>

                                                <td>{{type_interest($item['type_interest'])}}</td>

                                                <td>
                                                    @if($item['status'] == 3)
                                                        <span class="text-yellow">Đang xác nhận</span>
                                                    @elseif($item['status'] == 2)
                                                        <span class="text-danger">Thất bại</span>
                                                    @else
                                                        <span class="text-success">Thành công</span>
                                                    @endif
                                                </td>
                                                @if(in_array('telesales', $roles))
                                                    <td>
                                                        {{!empty($item['user_call']) ? $item['user_call'] : ""}}
                                                    </td>
                                                @endif
                                                <td>
                                                    <div class="dropdown">
                                                        <div id="dropdownMenuButton1" data-bs-toggle="dropdown">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon"
                                                                 width="24"
                                                                 height="24" viewBox="0 0 24 24" stroke-width="2"
                                                                 stroke="currentColor" fill="none"
                                                                 stroke-linecap="round"
                                                                 stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                <circle cx="12" cy="12" r="1"/>
                                                                <circle cx="12" cy="19" r="1"/>
                                                                <circle cx="12" cy="5" r="1"/>
                                                            </svg>
                                                        </div>
                                                        @if(in_array(\App\Service\ActionInterface::CHI_TIET_HOP_DONG, $action_global) || $is_admin == 1)
                                                            <div class="dropdown-menu dropdown-menu-demo">
                                                                <a class="dropdown-item" target="_blank"
                                                                   href="{{route('contract.show',['code'=>$item['code_contract']])}}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon"
                                                                         width="24" height="24" viewBox="0 0 24 24"
                                                                         stroke-width="2" stroke="currentColor"
                                                                         fill="none"
                                                                         stroke-linecap="round" stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                              fill="none"/>
                                                                        <circle cx="12" cy="12" r="2"/>
                                                                        <path
                                                                            d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"/>
                                                                    </svg>&nbsp;
                                                                    Chi tiết
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="20" class="text-danger" style="text-align: center">
                                                Không có dữ liệu
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- Paginate --}}
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="d-inline-block float-right">
                                @if($paginate)
                                    {{ $paginate->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

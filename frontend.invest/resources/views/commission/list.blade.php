@extends('layout.master')
@section('page_name','Quản lý hoa hồng nhà đầu tư')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">VFC Investor</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('commission')}}" class="text-info">Quản
                        lý hoa hồng nhà đầu tư</a></li>
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
                            <h1 class="d-inline-block">Danh sách
                                tháng {{!empty(request()->get('month')) ? request()->get('month') : date('Y-m')}}</h1>
                            {{-- Search --}}
                            <div class="float-right d-inline-block" id="filter-data">
                                @if(in_array(\App\Service\ActionInterface::EXCEL_COMMISSION, $action_global) || $is_admin == 1)
                                    <a class="btn btn-success"
                                       href="{{route('commission.excel')}}?month={{request()->get('month') ?? date('Y-m')}}&name={{request()->get('name')}}"
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
                                            <form method="get" action="{{route('commission')}}">
                                                <div class="mb-3">
                                                    <div class="text-large">Thông tin tìm kiếm</div>
                                                    <hr class="mt-2 mb-0">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Tháng</label>
                                                    <div>
                                                        <input type="month" name="month" class="form-control"
                                                               value="{{ request()->get('month') ?? date('Y-m')}}"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
{{--                                                <div class="form-group mb-3">--}}
{{--                                                    <label class="form-label">Tên nhà đầu tư</label>--}}
{{--                                                    <div>--}}
{{--                                                        <input type="text" name="name" class="form-control"--}}
{{--                                                               placeholder="Tên nhà đầu tư"--}}
{{--                                                               value="{{ request()->get('name') }}"--}}
{{--                                                               autocomplete="off">--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
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
                                        <th style="text-align: center">Người giới thiệu</th>
                                        <th style="text-align: center">Số điện thoại</th>
                                        <th style="text-align: center">Tổng tiền</th>
                                        <th style="text-align: center">Tiền thưởng</th>
                                        <th class="w-1" style="text-align: center"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($data) > 0)
                                        @foreach($data as $key => $item)
                                            <tr style="text-align: center">
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $item['full_name'] ?? ""}}</td>
                                                <td>{{ $item['phone'] ?? "" }}</td>
                                                <td class="text-danger">{{!empty($item['total_money']) ?  number_format($item['total_money']) : ""}}</td>
                                                <td class="text-success">{{ !empty($item['money_commission']) ?  number_format($item['money_commission']) : "" }}</td>
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
                                                        <div class="dropdown-menu dropdown-menu-demo">
                                                            <a class="dropdown-item" target="_blank"
                                                               href="{{route('commission.detail')}}?id={{$item['user_id']}}&month={{request()->get('month') ?? date('Y-m')}}">
                                                                <!-- Download SVG icon from http://tabler-icons.io/i/calendar-stats -->
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon"
                                                                     width="24" height="24" viewBox="0 0 24 24"
                                                                     stroke-width="2" stroke="currentColor"
                                                                     fill="none"
                                                                     stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                          fill="none"/>
                                                                    <path
                                                                        d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4"/>
                                                                    <path d="M18 14v4h4"/>
                                                                    <circle cx="18" cy="18" r="4"/>
                                                                    <path d="M15 3v4"/>
                                                                    <path d="M7 3v4"/>
                                                                    <path d="M3 11h16"/>
                                                                </svg>&nbsp;
                                                                Chi tiết
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
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

@extends('layout.master')
@section('page_name','Danh sách hợp đồng')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">VFC Investor</a></li>
                <li class="breadcrumb-item"><a href="{{route('interest.list_general')}}">Quản lý lãi suất chung</a></li>
                <li class="breadcrumb-item" aria-current="page"><a
                        href="{{route('interest.detail_show',['id'=>request()->get('id')])}}" class="text-info">
                        @if($interest['type'] == 'all')
                            Danh sách HĐ theo lãi suất chung
                        @else
                            Danh sách HĐ theo kì hạn vay
                        @endif
                    </a></li>
            </ol>
        </div>
    </div>
    @include('layout.alert_success')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Head --}}
                    <div class="row mb-4">
                        <div class="col-12">
                            <h1 class="d-inline-block">@if($interest['type'] == 'all')
                                    Danh sách HĐ theo lãi suất chung
                                @else
                                    Danh sách HĐ theo kì hạn vay
                                @endif</h1>
                            {{-- Search --}}
                            {{--                            <div class="float-right d-inline-block" id="filter-data">--}}
                            {{--                                <a class="btn btn-primary" href="#" data-bs-toggle="dropdown">--}}
                            {{--                                    <i class="fas fa-filter"></i>&nbsp;--}}
                            {{--                                    Lọc dữ liệu--}}
                            {{--                                </a>--}}
                            {{--                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-card" style="width: 500px;">--}}
                            {{--                                    <div class="card d-flex flex-column">--}}
                            {{--                                        <div class="card-body d-flex flex-column">--}}
                            {{--                                            <form method="get" action="{{route('contract.list')}}">--}}
                            {{--                                                <div class="mb-3">--}}
                            {{--                                                    <div class="text-large">Thông tin tìm kiếm</div>--}}
                            {{--                                                    <hr class="mt-2 mb-0">--}}
                            {{--                                                </div>--}}
                            {{--                                                <div class="form-group mb-3">--}}
                            {{--                                                    <label class="form-label">Mã hợp đồng</label>--}}
                            {{--                                                    <div>--}}
                            {{--                                                        <input type="text" name="code_contract" class="form-control"--}}
                            {{--                                                               placeholder="Mã hợp đồng"--}}
                            {{--                                                               value="{{ request()->get('code_contract') }}"--}}
                            {{--                                                               autocomplete="off">--}}
                            {{--                                                    </div>--}}
                            {{--                                                </div>--}}
                            {{--                                                <div class="form-group mb-3">--}}
                            {{--                                                    <label class="form-label">Mã nhà đầu tư</label>--}}
                            {{--                                                    <div>--}}
                            {{--                                                        <input type="text" name="investor_code" class="form-control"--}}
                            {{--                                                               placeholder="Mã nhà đâu tư"--}}
                            {{--                                                               value="{{ request()->get('investor_code') }}"--}}
                            {{--                                                               autocomplete="off">--}}
                            {{--                                                    </div>--}}
                            {{--                                                </div>--}}
                            {{--                                                <div class="form-group text-right">--}}
                            {{--                                                    <button type="submit" class="btn btn-primary">--}}
                            {{--                                                        <i class="fas fa-search"></i>&nbsp; Tìm kiếm--}}
                            {{--                                                    </button>--}}
                            {{--                                                </div>--}}
                            {{--                                            </form>--}}
                            {{--                                        </div>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
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
                                        @if($interest['type'] == 'all')
                                            <th style="text-align: center">Lãi suất</th>
                                            <td style="text-align: center; color: red">{{$interest['interest']}} %</td>
                                        @else
                                            <th style="text-align: center">Kì hạn</th>
                                            <td style="text-align: center; color: red">{{$interest['period']}}tháng
                                            </td>
                                        @endif
                                        <th style="text-align: center">Tổng hợp đồng</th>
                                        <td style="text-align: center;color: red">{{count($interest['contracts'])}} hợp
                                            đồng
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
                                        <th>STT</th>
                                        <th>Mã hợp đồng</th>
                                        <th>Mã nhà đầu tư</th>
                                        <th>Số tiền đầu tư</th>
                                        <th>Lãi suất</th>
                                        <th>Hình thức trả lãi</th>
                                        <th>Ngày đầu tư</th>
                                        <th class="w-1"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($contracts) > 0)
                                        @foreach($contracts as $key => $item)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $item['code_contract_disbursement'] }}</td>
                                                <td>{{ $item['investor']['code'] }}</td>
                                                <td>{{ number_format($item['amount_money']) }}</td>
                                                <td>{{ $interest['interest'] }} %</td>
                                                <td>{{ type_interest($item['type_interest']) }} </td>
                                                <td>{{ date('d/m/Y H:i:s',($item['created_at'])) }}</td>
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
                                                               href="{{route('contract.show',['code'=>$item['code_contract']])}}">
                                                                <!-- Download SVG icon from http://tabler-icons.io/i/calendar-stats -->
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon"
                                                                     width="24" height="24" viewBox="0 0 24 24"
                                                                     stroke-width="2" stroke="currentColor" fill="none"
                                                                     stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                    <path
                                                                        d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4"/>
                                                                    <path d="M18 14v4h4"/>
                                                                    <circle cx="18" cy="18" r="4"/>
                                                                    <path d="M15 3v4"/>
                                                                    <path d="M7 3v4"/>
                                                                    <path d="M3 11h16"/>
                                                                </svg>&nbsp;
                                                                Lịch thanh toán
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

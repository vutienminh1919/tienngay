@extends('layout.master')
@section('page_name','Quản lý hợp đồng')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">VFC Investor</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('contract.list')}}" class="text-info">Quản
                        lý hợp
                        đồng</a></li>
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
                            <h1 class="d-inline-block">Danh sách hợp đồng</h1>
                            {{-- Search --}}
                            <div class="float-right d-inline-block" id="filter-data">
                                @if(in_array(\App\Service\ActionInterface::EXCEL_HOP_DONG, $action_global) || $is_admin == 1)
                                    <a class="btn btn-success"
                                       href="{{route('contract.excel')}}?fdate={{request()->get('fdate')}}&tdate={{request()->get('tdate')}}&code_contract={{request()->get('code_contract')}}&investor_code={{request()->get('investor_code')}}&status={{request()->get('status')}}"
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
                                            <form method="get" action="{{route('contract.list')}}">
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
                                                    <label class="form-label">Mã hợp đồng</label>
                                                    <div>
                                                        <input type="text" name="code_contract" class="form-control"
                                                               placeholder="Mã hợp đồng"
                                                               value="{{ request()->get('code_contract') }}"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Tên nhà đầu tư</label>
                                                    <div>
                                                        <input type="text" name="investor_code" class="form-control"
                                                               placeholder="Tên nhà đâu tư"
                                                               value="{{ request()->get('investor_code') }}"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Trạng thái</label>
                                                    <div>
                                                        <select type="text" name="status" class="form-control"
                                                                autocomplete="off">
                                                            <option value="">Chọn trạng thái</option>
                                                            @foreach(status_contract() as $s => $c)
                                                                <option
                                                                    value="{{$s}}" {{request()->get('status') == $s ? 'selected' : ''}}>{{$c}}</option>
                                                            @endforeach
                                                        </select>
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
                                        <th style="text-align: center">Mã hợp đồng</th>
                                        <th style="text-align: center">Nhà đầu tư</th>
                                        <th style="text-align: center">Số tiền đầu tư</th>
                                        <th style="text-align: center">Lãi suất(/năm)</th>
                                        <th style="text-align: center">Hình thức trả lãi</th>
                                        <th style="text-align: center">Thời gian đầu tư</th>
                                        <th style="text-align: center">Số kì đã trả</th>
                                        <th style="text-align: center">Số kì chưa trả</th>
                                        <th style="text-align: center">Gốc đã trả</th>
                                        <th style="text-align: center">Lãi đã trả</th>
                                        <th style="text-align: center">Tình trạng</th>
                                        <th style="text-align: center">Ngày đầu tư</th>
                                        <th class="w-1" style="text-align: center"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($data) > 0)
                                        @foreach($data as $key => $item)
                                            <tr style="text-align: center">
                                                <td>{{ ++$key + (($paginate->currentPage()-1)*$paginate->perPage()) }}</td>
                                                <td>{{ $item['code_contract_disbursement'] }}</td>
                                                <td>{{ $item['investor_name'] }}</td>
                                                <td class="text-danger">{{ number_format($item['amount_money']) }}</td>
                                                <td>{{ convert_interest(data_get(json_decode($item['interest'], true), 'interest')) }}%</td>
                                                <td>{{type_interest($item['type_interest'])}}</td>
                                                <td>{{$item['number_day_loan']/30}} tháng</td>
                                                <td class="@if($item['da_thanh_toan'] > 0) text-danger @endif ">{{ ($item['da_thanh_toan']) }}</td>
                                                <td>{{ $item['tong_ky_tra'] - $item['da_thanh_toan'] }}</td>
                                                <td>{{ number_format($item['goc_da_tra']) }}</td>
                                                <td>{{ number_format($item['lai_da_tra']) }}</td>
                                                <td>
                                                    @if($item['status'] == 'new')
                                                        <span class="badge badge-warning">Đang đối soát</span>
                                                    @else
                                                        @if($item['status_contract'] == 1)
                                                            <span class="badge badge-active">Đang đầu tư</span>
                                                        @else
                                                            <span class="badge badge-block">Đã đáo hạn</span>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>{{ date('d/m/Y H:i:s',(strtotime($item['created_at']))) }}</td>
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
                                                            @if(in_array(\App\Service\ActionInterface::CHI_TIET_HOP_DONG, $action_global) || $is_admin == 1)
                                                                <a class="dropdown-item" target="_blank"
                                                                   href="{{route('contract.show',['code'=>$item['code_contract']])}}">
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
                                                                    Lịch thanh toán
                                                                </a>
                                                            @endif
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

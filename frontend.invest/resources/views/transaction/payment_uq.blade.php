@extends('layout.master')
@inject('transaction', 'App\Http\Controllers\TransactionController')
@section('page_name','Quản lý tiền trả')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">VFC Investor</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="{{route('transaction.payment')}}">Quản
                        lý tiền trả</a></li>
            </ol>
        </div>
    </div>
    {{-- REPORT --}}
    <div class="row">
        <div class="col-12 mb-3">
            <div class="row">
            </div>
        </div>
    </div>
    {{-- MAIN --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Head --}}
                    <div class="row mb-3">
                        <div class="col-12">
                            <h1 class="d-inline-block">DANH SÁCH GIAO DỊCH TRẢ TIỀN NHÀ ĐẦU TƯ</h1>
                            {{-- Search --}}
                            <div class="float-right d-inline-block" id="filter-data">
                                {{--                                @if(in_array(\App\Service\ActionInterface::EXCEL_GIAO_DICH_TIEN_TRA, $action_global) || $is_admin == 1)--}}
                                {{--                                    <a class="btn btn-success"--}}
                                {{--                                       href="{{route('transaction.excelTransactionPayment')}}?fdate={{request()->get('fdate')}}&tdate={{request()->get('tdate')}}&code_contract={{request()->get('code_contract')}}&investor_code={{request()->get('investor_code')}}"--}}
                                {{--                                       target="_blank">--}}
                                {{--                                        <i class="fas fa-file-excel"></i>&nbsp;--}}
                                {{--                                        Excel--}}
                                {{--                                    </a>--}}
                                {{--                                @endif--}}
                                <a class="btn btn-primary btn-icon" href="#" data-bs-toggle="dropdown">
                                    <i class="fas fa-filter"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-card" style="width: 400px;">
                                    <div class="card d-flex flex-column">
                                        <div class="card-body d-flex flex-column">
                                            <form method="get" action="{{route('transaction.payment_uq')}}">
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
                                                        <input type="text" name="full_name" class="form-control"
                                                               placeholder="Nhà đâu tư"
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
                            {{-- Search --}}
                        </div>
                    </div>
                    {{-- Head --}}
                    {{-- Table --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-nowrap table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center">STT</th>
                                        <th style="text-align: center">Ngày cập nhật</th>
                                        <th style="text-align: center">Tên nhà đầu tư</th>
                                        <th style="text-align: center">Tiền gốc</th>
                                        <th style="text-align: center">Tiền lãi</th>
                                        <th style="text-align: center">Tổng tiền</th>
                                        <th style="text-align: center">Hình thức</th>
                                        <th style="text-align: center">Người thực hiện</th>
                                        <th class="w-1" style="text-align: center"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $key => $item)
                                        <tr style="text-align: center">
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ date('d/m/Y', strtotime($item['created_at'])) }}</td>
                                            <td>{{ $item['investor_name'] }}</td>
                                            <td>{{ number_format(round($item['tien_goc'])) }}</td>
                                            <td>{{ number_format(round($item['tien_lai'])) }}</td>
                                            <td class="text-danger">{{ number_format(round($item['investment_amount'])) }}</td>
                                            <td>
                                                @if($item['type_method'] == 1)
                                                    <span class="badge badge-success">Tự động</span>
                                                @else
                                                    <span class="badge badge-primary">Thủ công</span>
                                                @endif
                                            </td>
                                            <td>{{ $item['created_by'] }}</td>
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
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- Table --}}
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

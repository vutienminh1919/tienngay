@extends('layout.master')
@section('page_name','Danh sách kỳ trả tiền')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Dashboard</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('pay.list')}}"
                                                                   class="text-info">Danh sách kỳ trả</a></li>
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
                                <div class="">Tổng kỳ trả lãi</div>
                                <div class="ms-auto lh-1">
                                    <div class="">
                                        {{$overview['total_pay']}}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mt-3">
                                <div class="ms-auto">
                                    <h2><span class="d-inline-flex align-items-center" style="color: white">
                                    {{number_format(round($overview['total_money_pay']))}}
                                    </span>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card" style="border-radius: 10px;">
                        <div class="card-body" style="background-color: #E2B1DF;border-radius: 10px;">
                            <div class="d-flex align-items-center mt-3" style="color: white">
                                <div class="">Số kỳ chưa thanh toán</div>
                                <div class="ms-auto lh-1">
                                    <div class="">
                                        {{$overview['tong_ky_chua_tra']}}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mt-3">
                                <div class="ms-auto">
                                    <h2><span class="d-inline-flex align-items-center" style="color: white">
                                    {{number_format(round($overview['tong_tien_ki_chua_tra']))}}
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
                                <div class="">Số kỳ đã thanh toán</div>
                                <div class="ms-auto lh-1">
                                    <div class="">
                                        {{$overview['tong_ky_da_tra']}}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mt-3">
                                <div class="ms-auto">
                                    <h2><span class="d-inline-flex align-items-center" style="color: white">
                                    {{number_format(round($overview['tong_tien_ki_da_tra']))}}
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
                                <div class="">Đến kỳ</div>
                                <div class="ms-auto lh-1">
                                    <div class="">
                                        {{$overview['tong_ky_den_han_tra']}}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mt-3">
                                <div class="ms-auto">
                                    <h2><span class="d-inline-flex align-items-center" style="color: white">
                                    {{number_format(round($overview['tong_tien_ky_den_han_tra']))}}
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
    <div class="row mt-3">
        <div class="col-12">
            <div class="card" style="border-radius: 10px;">
                <div class="card-body">
                    {{-- Head --}}
                    <div class="row mb-4">
                        <div class="col-12">
                            <h1 class="d-inline-block">DANH SÁCH KỲ TRẢ TIỀN NHÀ ĐẦU TƯ</h1>

                            {{-- Search --}}
                            <div class="float-right d-inline-block" id="filter-data">
                                @if(in_array(\App\Service\ActionInterface::EXCEL_KI_TRA_LAI_NDT_APP, $action_global) || $is_admin == 1)
                                    <a class="btn btn-success"
                                       href="{{route('pay.excel_app')}}?fdate={{request()->get('fdate')}}&tdate={{request()->get('tdate')}}&code_contract={{request()->get('code_contract')}}&full_name={{request()->get('full_name')}}"
                                       target="_blank">
                                        <i class="fas fa-file-excel"></i>&nbsp;
                                        Excel
                                    </a>
                                @endif
                                <a class="btn btn-primary btn-icon" href="#" data-bs-toggle="dropdown">
                                    <i class="fas fa-filter"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-card" style="width: 400px;">
                                    <div class="card d-flex flex-column">
                                        <div class="card-body d-flex flex-column">
                                            <form method="get" action="{{route('pay.list')}}">
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
                                                               placeholder="Mã nhà đâu tư"
                                                               value="{{ request()->get('full_name') }}"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Trạng thái</label>
                                                    <div>
                                                        <select type="text" name="status" class="form-control">
                                                            <option value="">Chọn trạng thái</option>
                                                            <option
                                                                value="2" {{ request()->get('status')== 2 ? 'selected' : '' }}>
                                                                Đã thanh toán
                                                            </option>
                                                            <option
                                                                value="1" {{ request()->get('status')== 1 ? 'selected' : '' }}>
                                                                Chưa thanh toán
                                                            </option>
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
                                        <th style="text-align: center">Nhà đầu tư</th>
                                        <th style="text-align: center">Mã hợp đồng</th>
                                        <th style="text-align: center">Kỳ trả</th>
                                        <th style="text-align: center">Ngày trả</th>
                                        <th style="text-align: center">Tiền đầu tư</th>
                                        <th style="text-align: center">Tổng tiền trả</th>
                                        <th style="text-align: center">Hình thức trả lãi</th>
                                        <th style="text-align: center">Thời gian thanh toán</th>
                                        <th style="text-align: center">Trạng thái</th>
                                        <th class="w-1"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($data) > 0)
                                        @foreach($data as $key => $item)
                                            <tr style="text-align: center">
                                                <td>{{++$key + (($paginate->currentPage()-1)*$paginate->perPage())}}</td>
                                                <td>{{$item['name']}}</td>
                                                <td>{{$item['code_contract_disbursement']}}</td>
                                                <td>Kỳ {{$item['ky_tra']}}</td>
                                                <td>{{date('d/m/Y',$item['ngay_ky_tra'])}}</td>
                                                <td>{{number_format($item['investment_amount'])}}</td>
                                                <td class="text-danger">{{number_format(round($item['goc_lai_1ky']))}}</td>
                                                <td>
                                                    @if($item['type_interest_receiving_account'] == 'vimo')
                                                        <span class="badge badge-primary">Vimo</span>
                                                    @else
                                                        <span class="badge badge-warning">NganLuong</span>
                                                    @endif
                                                </td>
                                                <td>{{!empty($item['transaction_created_at']) ? date('d/m/Y H:i:s',strtotime($item['transaction_created_at'])) : ''}}</td>
                                                <td>
                                                    @if($item['status'] == 1)
                                                        <span class="badge badge-danger">Chưa thanh toán</span>
                                                    @elseif($item['status'] == 2)
                                                        <span class="badge badge-success">Đã thanh toán</span>
                                                    @elseif($item['status'] == 3)
                                                        <span class="badge bg-azure">Chờ xử lý với VIMO</span>
                                                        <br>
                                                        <span
                                                            class="text-danger">{{data_get(json_decode($item['log']['response']), 'error_description')}}</span>
                                                    @elseif($item['status'] == 4)
                                                        <span
                                                            class="badge badge-warning">Chờ xử lý với Ngân lượng</span>
                                                        <br>
                                                        <span
                                                            class="text-danger">{{data_get(json_decode($item['log']['response']), 'error_description')}}</span>
                                                        <br>
                                                        <span
                                                            class="text-success">Id giao dịch: {{data_get(json_decode($item['log']['response']), 'transaction_id') ?? ""}}</span>
                                                        <br>
                                                        @if(in_array(\App\Service\ActionInterface::XEM_THANH_TOAN, $action_global) || $is_admin == 1)
                                                            <a class="btn btn-primary btn-sm mt-1 update_payment"
                                                               style="border-radius: 5px"
                                                               data-id="{{$item['id']}}">Cập
                                                                nhật</a>
                                                        @endif
                                                    @elseif($item['status'] == 5)
                                                        <span class="badge badge-warning">GD Ngân lượng thất bại</span>
                                                        <br>
                                                        <span
                                                            class="text-danger">{{data_get(json_decode($item['log']['response']), 'error_description')}}</span>
                                                        <br>
                                                        <span
                                                            class="text-success">Id giao dịch: {{data_get(json_decode($item['log']['response']), 'transaction_id') ?? ""}}</span>
                                                    @elseif($item['status'] == 6)
                                                        <span class="badge badge-warning">Ngân lượng hoàn trả</span>
                                                        <br>
                                                        <span
                                                            class="text-success">Id giao dịch: {{data_get(json_decode($item['log']['response']), 'transaction_id') ?? ""}}</span>
                                                    @elseif($item['status'] == 8)
                                                        <span class="badge badge-secondary">Hủy</span>
                                                    @endif
                                                </td>
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
                                                            @endif
                                                            @if(time() >= $item['ngay_ky_tra'])
                                                                @if(in_array(\App\Service\ActionInterface::XEM_THANH_TOAN, $action_global) || $is_admin == 1)
                                                                    @if(in_array($item['status'], [1,3,5,6]))
                                                                        <a class="dropdown-item" target="_blank"
                                                                           href="{{route('pay.detail_paypal',['id'=>$item['id']])}}">
                                                                            <!-- Download SVG icon from http://tabler-icons.io/i/brand-paypal -->
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                 class="icon"
                                                                                 width="24" height="24"
                                                                                 viewBox="0 0 24 24"
                                                                                 stroke-width="2" stroke="currentColor"
                                                                                 fill="none"
                                                                                 stroke-linecap="round"
                                                                                 stroke-linejoin="round">
                                                                                <path stroke="none" d="M0 0h24v24H0z"
                                                                                      fill="none"/>
                                                                                <path
                                                                                    d="M10 13l2.5 0c2.5 0 5 -2.5 5 -5c0 -3 -1.9 -5 -5 -5h-5.5c-.5 0 -1 .5 -1 1l-2 14c0 .5 .5 1 1 1h2.8l1.2 -5c.1 -.6 .4 -1 1 -1zm7.5 -5.8c1.7 1 2.5 2.8 2.5 4.8c0 2.5 -2.5 4.5 -5 4.5h-2.6l-.6 3.6a1 1 0 0 1 -1 .8l-2.7 0a0.5 .5 0 0 1 -.5 -.6l.2 -1.4"/>
                                                                            </svg>
                                                                            Thanh toán
                                                                        </a>
                                                                    @endif
                                                                @endif
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
    <script src="{{asset('project_js/pay/paypal.js')}}"></script>
@endsection

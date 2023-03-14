@extends('layout.master')
@section('page_name','Danh sách kỳ trả tiền')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Dashboard</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('pay.list_uq')}}"
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
                                @if(in_array(\App\Service\ActionInterface::EXCEL_KI_TRA_LAI_NDT_UQ, $action_global) || $is_admin == 1)
                                    <a class="btn btn-success"
                                       href="{{route('pay.excel_uq')}}?fdate={{request()->get('fdate')}}&tdate={{request()->get('tdate')}}&code_contract={{request()->get('code_contract')}}&investor_code={{request()->get('investor_code')}}"
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
                                            <form method="get" action="{{route('pay.list_uq')}}">
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
                                                    <label class="form-label">Nhà đầu tư</label>
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
                                        <th style="text-align: center">Ngày cập nhật</th>
                                        <th style="text-align: center">Trạng thái</th>
                                        <th class="w-1"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($data) > 0)
                                        @foreach($data as $key => $item)
                                            <tr style="text-align: center">
                                                <td>{{++$key + (($paginate->currentPage()-1)*$paginate->perPage())}}</td>
                                                <td>{{!empty($item['name']) ? $item['name'] : ''}}</td>
                                                <td>{{$item['code_contract_disbursement'] ?? ""}}</td>
                                                <td>Kỳ {{$item['ky_tra']}}</td>
                                                <td>{{date('d/m/Y',$item['ngay_ky_tra'])}}</td>
                                                <td>{{number_format($item['investment_amount'])}}</td>
                                                <td class="text-danger">{{number_format(round($item['goc_lai_1ky']))}}</td>
                                                <td>{{!empty($item['transaction']) ? date('d/m/Y',$item['transaction']['created_at']) : ''}}</td>
                                                <td>
                                                    <span
                                                        class="badge {{color_status_pay($item['status'])}}">{{status_pay($item['status'])}}</span>
                                                    <br>
                                                    @if(!empty($item['log']))
                                                        <span
                                                            class="text-danger">{{data_get(json_decode($item['log']['response']), 'error_description')}}</span>
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
                                                            @if(time() >= $item['interest_period'])
                                                                @if(in_array(\App\Service\ActionInterface::CAP_NHAT_THANH_TOAN, $action_global) || $is_admin == 1)
                                                                    @if($item['ky_cuoi'] == true)
                                                                        @if($item['so_ky_thanh_toan'] == 1)
                                                                            <a class="dropdown-item cap_nhat_dao_han"
                                                                               data-bs-toggle="modal"
                                                                               data-bs-target="#cap_nhat_dao_han_ndt_uq"
                                                                               href="" data-id="{{$item['id']}}">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                     class="icon"
                                                                                     width="24" height="24"
                                                                                     viewBox="0 0 24 24"
                                                                                     stroke-width="2"
                                                                                     stroke="currentColor"
                                                                                     fill="none"
                                                                                     stroke-linecap="round"
                                                                                     stroke-linejoin="round">
                                                                                    <path stroke="none"
                                                                                          d="M0 0h24v24H0z"
                                                                                          fill="none"/>
                                                                                    <path
                                                                                        d="M10 13l2.5 0c2.5 0 5 -2.5 5 -5c0 -3 -1.9 -5 -5 -5h-5.5c-.5 0 -1 .5 -1 1l-2 14c0 .5 .5 1 1 1h2.8l1.2 -5c.1 -.6 .4 -1 1 -1zm7.5 -5.8c1.7 1 2.5 2.8 2.5 4.8c0 2.5 -2.5 4.5 -5 4.5h-2.6l-.6 3.6a1 1 0 0 1 -1 .8l-2.7 0a0.5 .5 0 0 1 -.5 -.6l.2 -1.4"/>
                                                                                </svg>
                                                                                Cập nhật đáo hạn
                                                                            </a>
                                                                        @endif
                                                                    @endif
                                                                    @if($item['status'] == 1 || $item['status'] == 3)
                                                                        <a class="dropdown-item cap_nhat_thanh_toan"
                                                                           data-bs-toggle="modal"
                                                                           data-bs-target="#cap_nhat_thanh_toan_ndt_uq"
                                                                           href="" data-id="{{$item['id']}}">
                                                                            <!-- Download SVG icon from http://tabler-icons.io/i/brand-paypal -->
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                 class="icon"
                                                                                 width="24" height="24"
                                                                                 viewBox="0 0 24 24"
                                                                                 stroke-width="2"
                                                                                 stroke="currentColor"
                                                                                 fill="none"
                                                                                 stroke-linecap="round"
                                                                                 stroke-linejoin="round">
                                                                                <path stroke="none"
                                                                                      d="M0 0h24v24H0z"
                                                                                      fill="none"/>
                                                                                <path
                                                                                    d="M10 13l2.5 0c2.5 0 5 -2.5 5 -5c0 -3 -1.9 -5 -5 -5h-5.5c-.5 0 -1 .5 -1 1l-2 14c0 .5 .5 1 1 1h2.8l1.2 -5c.1 -.6 .4 -1 1 -1zm7.5 -5.8c1.7 1 2.5 2.8 2.5 4.8c0 2.5 -2.5 4.5 -5 4.5h-2.6l-.6 3.6a1 1 0 0 1 -1 .8l-2.7 0a0.5 .5 0 0 1 -.5 -.6l.2 -1.4"/>
                                                                            </svg>
                                                                            {{$item['ky_cuoi'] == true && ($item['so_ky_thanh_toan'] == 1) ? "Cập nhật tất toán" : 'Cập nhật thanh toán'}}
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
    <div class="modal modal-blur" id="cap_nhat_thanh_toan_ndt_uq" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius: 10px">
                <div class="modal-header">
                    <h5 class="modal-title d-inline-block">Cập nhật thanh toán</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-bold">Tên nhà đầu tư :<span
                                class="text-danger">*</span></label>
                        <input class="form-control full_name text-danger" type="text"
                               name="full_name" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-bold">Mã hợp đồng :<span
                                class="text-danger">*</span></label>
                        <input class="form-control code_contract text-danger" type="text"
                               name="code_contract" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-bold">Kì trả :<span
                                class="text-danger">*</span></label>
                        <input class="form-control ky_tra text-danger" type="text"
                               name="ky_tra" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-bold">Tổng tiền :<span
                                class="text-danger">*</span></label>
                        <input class="form-control amount_money text-danger" type="text"
                               name="amount_money" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-bold">Tiền gốc :<span
                                class="text-danger">*</span></label>
                        <input class="form-control tien_goc text-danger" type="text"
                               name="tien_goc" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-bold">Tổng lãi:<span
                                class="text-danger">*</span></label>
                        <input class="form-control tien_lai text-danger" type="text"
                               name="tien_lai" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-bold">Ngày trả dự kiến:<span
                                class="text-danger">*</span></label>
                        <input class="form-control ngay_tra text-danger" type="text"
                               name="ngay_tra" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-bold">Ngày thanh toán :<span
                                class="text-danger">*</span></label>
                        <input class="form-control date_pay" type="date"
                               name="date_pay">
                    </div>
                    <input class="form-control id_pay" type="hidden"
                           name="id_pay">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary xac_nhan_cap_nhat_thanh_toan">
                        Xác
                        nhận
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="cap_nhat_dao_han_ndt_uq" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cập nhật đáo hạn hợp đồng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="mb-3">
                                <label class="form-label"><strong>Nhà đầu tư</strong><span class="text-danger">*</span></label>
                                <input type="text" class="form-control text-danger name_investor" id="name_investor"
                                       disabled>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="mb-3">
                                <label class="form-label"><strong>Mã phụ lục</strong><span class="text-danger">*</span></label>
                                <input type="text" class="form-control code_contract" placeholder="Nhập mã phụ lục"
                                       name="code_contract" disabled>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="mb-3">
                                <label class="form-label"><strong>Lãi suất(/năm)</strong><span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control interest" placeholder="Nhập lãi suất"
                                       name="interest" disabled>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="mb-3">
                                <label class="form-label"><strong>Số tiền đầu tư</strong><span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control amount_money" placeholder="Nhập số tiền đầu tư"
                                       name="amount_money" disabled>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="mb-3">
                                <label class="form-label"><strong>Lãi kỳ</strong><span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control money_interest" placeholder="Nhập số tiền đầu tư"
                                       name="money_interest" disabled>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="mb-3">
                                <label class="form-label"><strong>Thời gian đầu tư</strong><span
                                        class="text-danger">*</span></label>
                                <select type="text" class="form-control number_day_loan"
                                        name="number_day_loan" disabled>
                                    <option value="">Chọn</option>
                                    @foreach(month_investment() as $k => $v)
                                        <option value="{{$k}}">{{$v}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="mb-3">
                                <label class="form-label"><strong>Hình thức đầu tư</strong><span
                                        class="text-danger">*</span></label>
                                <select type="text" class="form-control type_interest"
                                        name="type_interest" disabled>
                                    <option value="">Chọn</option>
                                    @foreach(type_interest() as $t => $i)
                                        <option value="{{$t}}">{{$i}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="mb-3">
                                <label class="form-label"><strong>Phương thức đáo hạn</strong><span
                                        class="text-danger">*</span></label>
                                <select type="text" class="form-control option_expire"
                                        name="option_expire">
                                    <option value="">Chọn</option>
                                    <option value="4">Tái đầu tư gốc lãi</option>
                                    <option value="2">Tái đầu tư gốc</option>
                                    <option value="3">Tái đầu tư 1 phần gốc</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Mã phụ lục mới</strong><span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control text-danger code_contract_new"
                                                       id="code_contract_new" name="code_contract_new"
                                                       placeholder="Nhập mã phụ lục mới">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Lãi suất(/năm)</strong><span
                                                        class="text-danger">*</span></label>
                                                <input type="number" class="form-control interest_new"
                                                       placeholder="Nhập lãi suất mới"
                                                       name="interest_new">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 display_amount_money_new" style="display: none">
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Số tiền mới</strong><span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control amount_money_new"
                                                       placeholder="Nhập số tiền mới"
                                                       name="amount_money_new">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Thời gian đầu tư</strong><span
                                                        class="text-danger">*</span></label>
                                                <select type="text" class="form-control number_day_loan_new"
                                                        name="number_day_loan_new">
                                                    <option value="">Chọn</option>
                                                    @foreach(month_investment() as $k => $v)
                                                        <option value="{{$k}}">{{$v}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Hình thức đầu tư</strong><span
                                                        class="text-danger">*</span></label>
                                                <select type="text" class="form-control type_interest_new"
                                                        name="type_interest_new">
                                                    <option value="">Chọn</option>
                                                    @foreach(type_interest() as $t => $i)
                                                        <option value="{{$t}}">{{$i}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Ngày gia hạn</strong><span
                                                        class="text-danger">*</span></label>
                                                <input type="date" class="form-control created_at"
                                                       name="created_at">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="form-control text-danger pay_id" id="pay_id" name="pay_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn_cap_nhat_dao_han_ndt_uq">
                        Cập nhật
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('project_js/pay/uy_quyen.js')}}"></script>
@endsection

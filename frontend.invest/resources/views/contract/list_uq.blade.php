@extends('layout.master')
@section('page_name','Quản lý hợp đồng')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">VFC Investor</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('contract.list_uq')}}"
                                                                   class="text-info">Quản
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
                            <h1 class="d-inline-block">Danh sách hợp đồng Uỷ quyền</h1>
                            {{-- Search --}}
                            <div class="float-right d-inline-block" id="filter-data">
                                @if(in_array(\App\Service\ActionInterface::EXCEL_HOP_DONG_UQ, $action_global) || $is_admin == 1)
                                    <a class="btn btn-success"
                                       href="{{route('contract.excel')}}?fdate={{request()->get('fdate')}}&tdate={{request()->get('tdate')}}&code_contract={{request()->get('code_contract')}}&investor_code={{request()->get('investor_code')}}&type=UQ"
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
                                            <form method="get" action="{{route('contract.list_uq')}}">
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
                                @include('contract.modal-payment')
                                <table class="table table-vcenter table-nowrap table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        @if(in_array(\App\Service\ActionInterface::CAP_NHAT_THANH_TOAN_NHIEU_HOP_DONG_UQ, $action_global) || $is_admin == 1)
                                            <th style="text-align: center">
                                                <input type="checkbox" name="" value=""
                                                       class="form-check-input"
                                                       id="selectAll">
                                            </th>
                                        @endif
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
                                        <th style="text-align: center">Ngày đáo hạn dự kiến</th>
                                        <th style="text-align: center">Ngày đáo hạn thực tế</th>
                                        <th class="w-1" style="text-align: center"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($data) > 0)
                                        @foreach($data as $key => $item)
                                            <tr style="text-align: center">
                                                @if(in_array(\App\Service\ActionInterface::CAP_NHAT_THANH_TOAN_NHIEU_HOP_DONG_UQ, $action_global) || $is_admin == 1)
                                                    <td>
                                                        @if($item['status_contract'] != 2 )
                                                            <input class="form-check-input contractCheckBox checkbox"
                                                                   type="checkbox"
                                                                   name="contract_id[]"
                                                                   value="{{$item['id']}}" {{$item['status_contract'] == 2 ? 'disabled' : ''}} >
                                                        @endif
                                                    </td>
                                                @endif
                                                <td>{{ $item['code_contract_disbursement'] }}</td>
                                                <td>{{ $item['investor_name'] }}</td>
                                                <td class="text-danger">{{ number_format($item['amount_money']) }}</td>
                                                <td>{{ convert_interest(data_get(json_decode($item['interest'], true), 'interest')) }}
                                                    %
                                                </td>
                                                <td>{{type_interest($item['type_interest'])}}</td>
                                                <td>{{$item['number_day_loan']/30}} tháng</td>
                                                <td class="@if($item['da_thanh_toan'] > 0) text-danger @endif ">{{ ($item['da_thanh_toan']) }}</td>
                                                <td>{{ $item['tong_ky_tra'] - $item['da_thanh_toan'] }}</td>
                                                <td>{{ number_format($item['goc_da_tra']) }}</td>
                                                <td>{{ number_format($item['lai_da_tra']) }}</td>
                                                <td>
                                                    @if($item['status_contract'] == 2)
                                                        <span class="badge badge-block">Đã đáo hạn</span>
                                                    @else
                                                        <span class="badge badge-active">Đang đầu tư</span>
                                                    @endif
                                                </td>
                                                <td>{{!empty($item['start_date']) ? date('d-m-Y', $item['start_date']) : ''}}</td>
                                                <td>{{!empty($item['due_date']) ? date('d-m-Y', $item['due_date']) : ''}}</td>
                                                <td>{{!empty($item['date_expire']) ? date('d-m-Y', $item['date_expire']) : ''}}</td>
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
                                                            @if(in_array(\App\Service\ActionInterface::CAP_NHAT_THANH_TOAN, $action_global) || $is_admin == 1)
                                                                @if($item['status_contract'] != 2)
                                                                    <a class="dropdown-item cap_nhat_dao_han_som"
                                                                       data-bs-toggle="modal"
                                                                       data-bs-target="#cap_nhat_dao_han_som_ndt_uq"
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
                                                                        Cập nhật đáo hạn sớm
                                                                    </a>
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
    <div class="modal modal-blur fade" id="cap_nhat_dao_han_som_ndt_uq" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cập nhật đáo hạn sớm hợp đồng</h5>
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
                                <label class="form-label"><strong>Áp dụng lãi suất trước hạn</strong><span
                                        class="text-danger">*</span></label>
                                <select type="text" class="form-control punish"
                                        name="punish">
                                    <option value="0">Không</option>
                                    <option value="1">Có</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="mb-3">
                                <label class="form-label"><strong>Ngày đáo hạn</strong><span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control expire_date"
                                       name="expire_date">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 div_early_interest" style="display: none">
                            <div class="mb-3">
                                <label class="form-label"><strong>Lãi suất trước hạn(%/năm)</strong><span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control early_interest"
                                       name="early_interest" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 div-interest" style="display: none">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Lãi đã trả</strong><span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control text-danger interest_paid"
                                                       id="interest_paid" name="interest_paid"
                                                       placeholder="Nhập mã phụ lục mới" value="0" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label"><strong>lãi đáo sớm</strong><span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control text-danger interest_early"
                                                       id="interest_early" name="interest_early"
                                                       placeholder="Nhập mã phụ lục mới" value="0" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Lãi còn phải trả</strong><span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control text-danger interest_payable"
                                                       id="interest_payable" name="interest_payable"
                                                       placeholder="Nhập mã phụ lục mới" value="0" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Tổng gốc lãi phải trả </strong><span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control text-danger total_payable"
                                                       id="total_payable" name="total_payable"
                                                       placeholder="Nhập mã phụ lục mới" value="0" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="form-control text-danger contract_id" id="contract_id"
                           name="contract_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn_cap_nhat_dao_han_som_ndt_uq div-interest"
                            style="display: none">
                        Cập nhật
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('project_js/contract/list_uq.js')}}"></script>
@endsection

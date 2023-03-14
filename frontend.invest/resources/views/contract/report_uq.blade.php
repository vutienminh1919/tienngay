@extends('layout.master')
@section('page_name','Report')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">VFC Investor</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('contract.report_uq')}}"
                                                                   class="text-info">Báo cáo trích lãi</a></li>
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
                            <h1 class="d-inline-block">Report <span
                                    class="text-danger">{{ request()->get('month') ?? date('Y-m')}}</span></h1>
                            {{-- Search --}}
                            <div class="float-right d-inline-block" id="filter-data">
                                @if(in_array(\App\Service\ActionInterface::EXCEL_REPORT, $action_global) || $is_admin == 1)
                                    <a class="btn btn-success"
                                       href="{{route('contract.excel_report_uq')}}?month={{request()->get('month')}}&full_name={{request()->get('full_name')}}"
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
                                            <form method="get" action="{{route('contract.report_uq')}}">
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
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Tên nhà đầu tư</label>
                                                    <div>
                                                        <input type="text" name="full_name" class="form-control"
                                                               placeholder="Tên nhà đâu tư"
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
                                        <th style="text-align: center">Phụ lục</th>
                                        <th style="text-align: center">Số tiền đầu tư</th>
                                        <th style="text-align: center">Kỳ hạn</th>
                                        <th style="text-align: center">Lãi suất đúng hạn</th>
                                        <th style="text-align: center">Lãi suất trước hạn</th>
                                        <th style="text-align: center">Hình thức trả lãi</th>
                                        <th style="text-align: center">Ngày đầu tư</th>
                                        <th style="text-align: center">Ngày đáo dự kiến</th>
                                        <th style="text-align: center">Ngày đáo thực tế</th>
                                        <th style="text-align: center">Trạng thái</th>
                                        <th style="text-align: center">Số ngày tính lãi trong tháng</th>
                                        <th style="text-align: center">Lãi suất thực tế phải trả</th>
                                        <th style="text-align: center">Lãi tạm trích trước trong tháng</th>
                                        <th style="text-align: center">Gốc đã trả</th>
                                        <th style="text-align: center">Lãi đã trả</th>
                                        <th style="text-align: center">Lãi đã trả đến tháng báo cáo</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($data) > 0)
                                        @foreach($data as $key => $item)
                                            <tr style="text-align: center">
                                                <td>{{ ++$key + (($paginate->currentPage()-1)*$paginate->perPage()) }}</td>
                                                <td>{{$item['investor_name'] ?? ""}}</td>
                                                <td>{{$item['code_contract'] ?? ""}}</td>
                                                <td class="text-danger">{{ !empty($item['amount_money']) ? number_format($item['amount_money']) : ''}}</td>
                                                <td>{{$item['number_day_loan']/30 ?? ""}} tháng</td>
                                                <td class="text-primary">{{data_get(json_decode($item['interest'], true), 'interest_year')}}
                                                    %/năm
                                                </td>
                                                <td>0.2</td>
                                                <td>{{type_interest($item['type_interest'])}}</td>
                                                <td>{{!empty($item['start_date']) ? date('d-m-Y', $item['start_date']) : ''}}</td>
                                                <td>{{!empty($item['due_date']) ? date('d-m-Y', $item['due_date']) : ''}}</td>
                                                <td>{{!empty($item['date_expire']) ? date('d-m-Y', $item['date_expire']) : ''}}</td>
                                                <td><span
                                                        class="badge {{color_status_contract($item['status_contract'])}}">{{status_contract($item['status_contract'])}}</span>
                                                </td>
                                                <td>{{!empty($item['date_diff']) ? $item['date_diff'] : 0}}</td>
                                                <td class="text-danger">
                                                    @if($item['status_contract'] == 2)
                                                        {{!empty(data_get(json_decode($item['interest'], true), 'early_interest_year')) ? data_get(json_decode($item['interest'], true), 'early_interest_year') : data_get(json_decode($item['interest'], true), 'interest_year')}} %/năm
                                                    @endif
                                                </td>
                                                <td>{{!empty($item['interest_profit']) ? number_format($item['interest_profit']) : 0}}</td>
                                                <td>{{!empty($item['goc_da_tra']) ? number_format($item['goc_da_tra']) : 0}}</td>
                                                <td>{{!empty($item['lai_da_tra']) ? number_format($item['lai_da_tra']) : 0}}</td>
                                                <td>{{!empty($item['lai_da_tra_toi_ngay_bao_cao']) ? number_format($item['lai_da_tra_toi_ngay_bao_cao']) : 0}}</td>
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

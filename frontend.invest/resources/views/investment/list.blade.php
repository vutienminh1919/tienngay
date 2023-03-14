@extends('layout.master')
@section('page_name','Danh sách gói đầu tư')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">VFC Investor</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('investment.list')}}"
                                                                   class="text-info">Danh sách gói đầu tư</a></li>
            </ol>
        </div>
    </div>
    @include('layout.alert_success')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Head --}}
                    <div class="row mb-5">
                        <div class="col-12">
                            <h1 class="d-inline-block">Danh sách gói đầu tư</h1>
                            {{-- Search --}}
                            <div class="float-right d-inline-block" id="filter-data">
                                @if(in_array(\App\Service\ActionInterface::THEM_INVESTMENT, $action_global) || $is_admin == 1)
                                    <button data-bs-toggle="modal" data-bs-target="#add_new_investment"
                                            class="btn btn-primary">
                                        <i class="fas fa-plus"></i>&nbsp;
                                        Thêm mới
                                    </button>
                                @endif
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    {{-- Table --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-nowrap table-striped">
                                    <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã hợp đồng</th>
                                        <th>Số tiền</th>
                                        <th>Thời hạn</th>
                                        <th>Hình thức trả lãi</th>
                                        <th>Tình trạng</th>
                                        <th>Ngày tạo</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($data) > 0)
                                        @foreach($data as $key => $item)
                                            <tr>
                                                <td>{{ ++$key + (($paginate->currentPage()-1)*$paginate->perPage()) }}</td>
                                                <td>{{ $item['code_contract_disbursement'] }}</td>
                                                <td>{{ number_format($item['amount_money']) }}</td>
                                                <td>{{ $item['number_day_loan']/30 }} tháng</td>
                                                <td>
                                                    {{type_interest($item['type_interest'])}}
                                                </td>
                                                <td>
                                                    @if(!isset($item['investor_confirm']))
                                                        <span class="badge badge-secondary">Chưa có đầu tư</span>
                                                    @else
                                                        <span class="badge badge-success">Đã được đầu tư</span>
                                                    @endif
                                                </td>
                                                <td>{{ date('d/m/Y H:i:s',($item['created_at'])) }}</td>
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
    <div class="modal modal-blur" id="add_new_investment" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius: 10px">
                <div class="modal-header">
                    <h5 class="modal-title d-inline-block">Thêm gói đầu tư</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-bold">Số tiền :<span
                                class="text-danger">*</span></label>
                        <input class="form-control amount_money" type="text"
                               placeholder="Nhập số tiền"
                               name="amount_money">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-bold">Kì hạn :<span
                                class="text-danger">*</span></label>
                        <select class="form-control month" name="month">
                            <option value="">Chọn kì hạn</option>
                            <option value="1">1 tháng</option>
                            <option value="3">3 tháng</option>
                            <option value="6">6 tháng</option>
                            <option value="9">9 tháng</option>
                            <option value="12">12 tháng</option>
                            <option value="18">18 tháng</option>
                            <option value="24">24 tháng</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-bold">Hinh thức :<span
                                class="text-danger">*</span></label>
                        <select class="form-control type_interest" name="type_interest">
                            <option value="">Chọn hình thức</option>
                            @foreach(type_interest() as $t =>$ti)
                                @continue(in_array($t, [3,5]))
                                <option value="{{$t}}">{{$ti}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-bold">Số lượng gói đầu tư :<span
                                class="text-danger">*</span></label>
                        <input class="form-control quantity" type="number"
                               placeholder="Nhập số lượng"
                               name="quantity">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary " id="btn_add_investment"
                            data-bs-dismiss="modal">
                        Xác
                        nhận
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('project_js/investment/index.js')}}"></script>
@endsection

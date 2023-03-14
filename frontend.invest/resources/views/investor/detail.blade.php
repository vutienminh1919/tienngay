@extends('layout.master')
@inject('constract', 'App\Http\Controllers\ContractController')
@section('page_name','Chi tiết NDT')

@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">VFC appove</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">Chi tiết NĐT</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Head --}}
                    <div class="row mb-3">
                        <div class="col-12">
                            <h1 class="d-inline-block mb-3">Chi tiết NĐT: {{ $data['name'] ?? '' }}</h1>
                            <div class="float-right d-inline-block">
                                <a class="btn" style="border-style: none"
                                   id="click_edit_ndt"><i class="fa fa-edit"
                                                          style='font-size:25px;color:green'></i></a>
                                <a class="btn"
                                   style="border-style: none; display: none"
                                   id="edit_ndt"><i class="fa fa-save"
                                                    style='font-size:25px;color:green'></i></a>
                            </div>
                            <div class="hr mt-0 mb-0"></div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    {{-- Form --}}
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group mb-3 row">
                                <label class="form-label col-3 offset-3 col-form-label label-show-info">Mã NĐT: </label>
                                <div class="col-6">
                                    <div
                                        class="form-control-plaintext show-info-text">{{ substr($data['code'], 0, 4) . "****" . substr($data['code'], 7, 4) }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3 row">
                                <label class="form-label col-3 offset-3 col-form-label label-show-info">Tên
                                    NĐT: </label>
                                <div class="col-6">
                                    {{--                                    <div class="form-control-plaintext show-info-text">{{ $data['name'] }}</div>--}}
                                    <input class="form-control" name="name_ndt" id="name_ndt"
                                           value="{{ $data['name'] }}"
                                           disabled type="email">
                                    <input class="form-control" name="id_ndt" id="id_ndt" value="{{ $data['id'] }}"
                                           type="hidden">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3 row">
                                <label class="form-label col-3 offset-3 col-form-label label-show-info">SĐT: </label>
                                <div class="col-6">
                                    <div
                                        class="form-control-plaintext show-info-text">{{ hide_phone($data['phone_number']) }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3 row">
                                <label class="form-label col-3 offset-3 col-form-label label-show-info">Email: </label>
                                <div class="col-6">
                                    {{--                                    <div class="form-control-plaintext show-info-text">{{ $data['email'] }}</div>--}}
                                    <input class="form-control" name="email_ndt" id="email_ndt"
                                           value="{{ $data['email'] }}"
                                           disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3 row">
                                <label class="form-label col-3 offset-3 col-form-label label-show-info">Trạng
                                    thái: </label>
                                <div class="col-6">
                                    <div
                                        class="form-control-plaintext show-info-text">
                                        <span class="badge badge-success">Đã kích hoạt</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3 row">
                                <label class="form-label col-3 offset-3 col-form-label label-show-info">SĐT liên kết
                                    VIMO: </label>
                                <div class="col-6">
                                    <div
                                        class="form-control-plaintext show-info-text">{{ substr($data['phone_vimo'], 0, 4) . "****" . substr($data['phone_vimo'], 7, 4) }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3 row">
                                <label class="form-label col-3 offset-3 col-form-label label-show-info">Hạng người
                                    dùng: </label>
                                <div class="col-6">
                                    <div
                                        class="form-control-plaintext show-info-text">{{ $data['investor_reviews'] }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3 row">
                                <label class="form-label col-3 offset-3 col-form-label label-show-info">Số
                                    CMND/CCCD: </label>
                                <div class="col-6">
                                    <div
                                        class="form-control-plaintext show-info-text">{{ $data['identity'] ?? '' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Table --}}
                    <div class="row mb-3">
                        <div class="col-12">
                            <h3 class="d-inline-block mb-3">Danh sách hợp đồng (<span
                                    class="text-danger">{{count($data['constract'])}}</span>)</h3>
                            @if($data['type'] ==3)
                                <div class="float-right d-inline-block">
                                    @if(in_array(\App\Service\ActionInterface::THEM_PHU_LUC_NDT_UQ, $action_global) || $is_admin == 1)
                                        <a class="btn btn-primary them_phu_luc"
                                           href="" data-bs-toggle="modal"
                                           data-bs-target="#them_phu_luc_ndt"
                                           data-id="{{$data['id']}}"
                                           data-name="{{$data['name']}}">
                                            <i class="fas fa-credit-card"></i>&nbsp;
                                            Thêm phụ lục
                                        </a>
                                    @endif
                                </div>
                            @endif
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-nowrap table-striped">
                                    <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã hợp đồng</th>
                                        <th>Ngày đầu tư</th>
                                        <th>Số tiền đầu tư</th>
                                        <th>Lãi suất</th>
                                        <th>Phương thức đầu tư</th>
                                        <th class="w-1"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data['constract'] as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item['code_contract_disbursement'] }}</td>
                                            <td>{{ date('d/m/Y', $item['created_at']) }}</td>
                                            <td>{{ number_format($item['amount_money']) }}</td>
                                            <td>{{ data_get(json_decode($item['interest']), 'interest') }}</td>
                                            <td>
                                                {{type_interest($item['type_interest'])}}
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false"
                                                       aria-haspopup="false">
                                                        <svg style="width: 28px; height: 28px; color: #828282;"
                                                             xmlns="http://www.w3.org/2000/svg"
                                                             class="icon icon-tabler icon-tabler-dots-vertical"
                                                             width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                             stroke="currentColor" fill="none" stroke-linecap="round"
                                                             stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <circle cx="12" cy="12" r="1"></circle>
                                                            <circle cx="12" cy="19" r="1"></circle>
                                                            <circle cx="12" cy="5" r="1"></circle>
                                                        </svg>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end" data-bs-popper="none">
                                                        <a class="dropdown-item"
                                                           href="{{ route('contract.show', ['code'=>$item['code_contract']]) }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                 class="icon dropdown-item-icon" width="24" height="24"
                                                                 viewBox="0 0 24 24" stroke-width="2"
                                                                 stroke="currentColor" fill="none"
                                                                 stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z"
                                                                      fill="none"></path>
                                                                <path
                                                                    d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"></path>
                                                                <path
                                                                    d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"></path>
                                                                <line x1="16" y1="5" x2="19" y2="8"></line>
                                                            </svg>
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
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="them_phu_luc_ndt" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm phụ lục</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control text-danger" id="id_investor" name="id_investor">
                    <div class="mb-3">
                        <label class="form-label"><strong>Nhà đầu tư</strong><span class="text-danger">*</span></label>
                        <input type="text" class="form-control text-danger" id="name_investor" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Mã phụ lục</strong><span class="text-danger">*</span></label>
                        <input type="text" class="form-control code_contract" placeholder="Nhập mã phụ lục"
                               name="code_contract">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Lãi suất(/năm)</strong><span
                                class="text-danger">*</span></label>
                        <input type="number" class="form-control interest" placeholder="Nhập lãi suất" name="interest">
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label"><strong>Ngày đầu tư</strong><span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control ngay_dau_tu" name="ngay_dau_tu">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label"><strong>Số tiền đầu tư</strong><span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control amount_money" placeholder="Nhập số tiền đầu tư"
                                       name="amount_money">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <strong>Hình thức thanh toán</strong><span class="text-danger">*</span>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="radio" id="handmade" class="radio_check" value="1"
                                                   checked="checked" name="hinh_thuc_thanh_toan"/> Thủ công
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="radio" id="auto" class="radio_check" value=""
                                                   name="hinh_thuc_thanh_toan"/> Tự động
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <strong>Chu kỳ tính lãi</strong><span class="text-danger">*</span>
                                        </div>
                                        {{--                                        <div class="col-sm-4">--}}
                                        {{--                                            <input type="radio" id="360_date" class="radio_date_check" value="360"--}}
                                        {{--                                                   checked name="hinh_thuc_tinh_lai"/> 30 ngày/ 1kỳ--}}
                                        {{--                                        </div>--}}
                                        <div class="col-sm-4">
                                            <input type="radio" id="365_date" class="radio_date_check" value="365"
                                                   checked
                                                   name="hinh_thuc_tinh_lai"/> 1 tháng/ 1kỳ
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <strong>Thời gian đầu tư</strong><span class="text-danger">*</span>
                                        </div>
                                        <div class="col-sm-8">
                                            <select id="sl_invest_uyquyen" class="form-control" name="thoi_gian_dau_tu">
                                                <option value="">- Chọn thời gian đầu tư -</option>
                                                @foreach(month_investment() as $k => $v)
                                                    <option value="{{$k}}">{{$v}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <strong>Hình thức trả lãi</strong><span class="text-danger">*</span>
                                        </div>
                                        <div class="col-sm-8">
                                            <select id="hinh_thuc_uyquyen" class="form-control"
                                                    name="hinh_thuc_tra_lai">
                                                <option value="">- Chọn hình thức trả lãi -</option>
                                                <option value="2">Lãi hàng tháng, gốc cuối kỳ</option>
                                                <option value="4">Gốc lãi cuối kỳ</option>
                                                <option value="3">Lãi 3 tháng/ 1 lần</option>
                                                <option value="5">Lãi cuối tháng</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row chon-ngay-tra" style="display: none">
                                        <div class="col-sm-4">
                                            <label class="form-label"><strong>Chọn ngày trả
                                                    lãi</strong><span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="mb-3">
                                                <input type="number" class="form-control date_pay" name="date_pay"
                                                       placeholder="Chọn ngày trả lãi">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn_tao_phu_luc_ndt_uq" data-bs-dismiss="modal">Tạo mới
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('project_js/investor/detail.js')}}"></script>
@endsection

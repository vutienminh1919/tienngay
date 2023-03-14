@extends('layout.master')
@inject('investor', 'App\Http\Controllers\InvestorController')
@section('page_name','Danh sách nhà đầu tư Ủy Quyền')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">Bảng phân quyền</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('investor_list_uq')}}"
                                                                   class="text-info">Danh sách
                        nhà đầu tư Ủy Quyền</a></li>
            </ol>
        </div>
    </div>
    @include('layout.alert_success')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Search --}}
                    <div class="row mb-3">
                        <div class="col-12">
                            <h1 class="d-inline-block">Danh sách nhà đầu tư Ủy Quyền</h1>
                            <div class="float-right d-inline-block" id="filter-data">
                                @if(in_array(\App\Service\ActionInterface::THEM_MOI_NDT_UQ, $action_global) || $is_admin == 1)
                                    <button data-bs-toggle="modal" data-bs-target="#add_new_investor_uq"
                                            class="btn btn-primary btn_click_them_moi">
                                        <i class="fas fa-user-plus"></i>&nbsp;
                                        Thêm mới
                                    </button>
                                @endif
                                <a class="btn btn-primary" href="#" data-bs-toggle="dropdown">
                                    <i class="fas fa-filter"></i>&nbsp;
                                    Lọc dữ liệu
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-card" style="width: 500px;">
                                    <div class="card d-flex flex-column">
                                        <div class="card-body d-flex flex-column">
                                            <form method="get">
                                                <div class="mb-3">
                                                    <div class="text-large">Thông tin tìm kiếm</div>
                                                    <hr class="mt-2 mb-0">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Email</label>
                                                    <div>
                                                        <input type="email" name="email" class="form-control"
                                                               placeholder="Email" value="{{ request()->get('email') }}"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Số điện thoại</label>
                                                    <div>
                                                        <input type="text" name="phone" class="form-control"
                                                               placeholder="Số điện thoại"
                                                               value="{{ request()->get('phone') }}" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Tên nhà đầu tư</label>
                                                    <div>
                                                        <input type="text" name="name" class="form-control"
                                                               placeholder="Tên nhà đầu tư"
                                                               value="{{ request()->get('name') }}" autocomplete="off">
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
                                        <th>Nhà đầu tư</th>
                                        <th>Số điện thoại</th>
                                        <th>Ngày kích hoạt</th>
                                        <th>Trạng thái</th>
                                        <th>Xếp hạng</th>
                                        <th class="w-1"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item['name'] }}</td>
                                            <td>{{ substr($item['phone_number'], 0, 4) . "****" . substr($item['phone_number'], 7, 4) }}</td>
                                            <td>{{ isset($item['active_at']) ? date('d/m/Y H:i:s',  $item['active_at']) : date('d/m/Y H:i:s',  $item['created_at'])}}</td>
                                            <td>
                                                @if($item['status'] == $investor::STATUS_ACTIVE)
                                                    <span class="badge badge-active">Đang đầu tư</span>
                                                @endif
                                                @if($item['status'] == $investor::STATUS_DEACTIVE)
                                                    <span class="badge badge-block">Disactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item['investor_reviews'] == $investor::REVIEWS_MEMBER ||
                                                    is_null($item['investor_reviews'])
                                                )
                                                    <i class="fas fa-user"></i>&nbsp; Thành viên
                                                @elseif ($item['investor_reviews'] == $investor::REVIEWS_BRONZE)
                                                    <img src="{{ asset('images/icon-medal-bronze.svg') }}">&nbsp;
                                                    Bạc
                                                @elseif ($item['investor_reviews'] == $investor::REVIEWS_SILVER)
                                                    <img src="{{ asset('images/icon-medal-silver.svg') }}">&nbsp;
                                                    Bạc
                                                @elseif ($item['investor_reviews'] == $investor::REVIEWS_GOLD)
                                                    <img src="{{ asset('images/icon-medal-gold.svg') }}">&nbsp;
                                                    Vàng
                                                @elseif ($item['investor_reviews'] == $investor::REVIEWS_DIAMON)
                                                    <img src="{{ asset('images/icon-diamon.svg') }}">&nbsp;
                                                    Kim cương
                                                @endif
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
                                                        {{--                                                        @if(in_array(\App\Service\ActionInterface::CHI_TIET_NDT, $action_global) || $is_admin == 1)--}}
                                                        <a class="dropdown-item"
                                                           href="{{ route('investor_detail', $item['id']) }}">
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
                                                        {{--                                                        @endif--}}
                                                        @if(in_array(\App\Service\ActionInterface::THEM_PHU_LUC_NDT_UQ, $action_global) || $is_admin == 1)
                                                            <a class="dropdown-item them_phu_luc"
                                                               href="" data-bs-toggle="modal"
                                                               data-bs-target="#them_phu_luc_ndt"
                                                               data-id="{{$item['id']}}"
                                                               data-name="{{$item['name']}}">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                     class="icon dropdown-item-icon" width="24"
                                                                     height="24"
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
                                                                Thêm phụ lục
                                                            </a>
                                                        @endif
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
                    {{-- Paginate --}}
                    <div class="row">
                        <div class="col-6">
                        </div>
                        <div class="col-6">
                            <div class="float-right d-inline-block">
                                @if($paginate)
                                    {{ $paginate->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- Table --}}
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur" id="add_new_investor_uq" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius: 10px">
                <div class="modal-header">
                    <h5 class="modal-title d-inline-block">Thêm mới nhà đầu tư ủy quyền</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-bold">Tên nhà đầu tư :<span
                                class="text-danger">*</span></label>
                        <input class="form-control full_name" type="text"
                               placeholder="Nhập tên nhà đầu tư"
                               name="full_name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-bold">Số điện thoại :<span
                                class="text-danger">*</span></label>
                        <input class="form-control phone" type="number"
                               placeholder="Nhập số điện thoại"
                               name="phone_investor">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-bold">Số CMT/CCCD :<span
                                class="text-danger">*</span></label>
                        <input class="form-control cmt" type="number"
                               placeholder="Nhập CMT/CCCD"
                               name="cmt">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-bold">Email :<span
                                class="text-danger">*</span></label>
                        <input class="form-control email" type="email"
                               placeholder="Nhập email"
                               name="email_investor">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary " id="btn_add_investor_uq"
                            data-bs-dismiss="modal">
                        Xác
                        nhận
                    </button>
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
                                        {{--                                                   checked name="hinh_thuc_tinh_lai"/> 360--}}
                                        {{--                                        </div>--}}
                                        <div class="col-sm-4">
                                            <input type="radio" id="365_date" class="radio_date_check" value="365" checked
                                                   name="hinh_thuc_tinh_lai"/> 365
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <strong>Thời gian đầu tư</strong><span class="text-danger">*</span>
                                        </div>
                                        <div class="col-sm-8">
                                            <select id="sl_invest_uyquyen" class="form-control thoi_gian_dau_tu"
                                                    name="thoi_gian_dau_tu">
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
                                            <select id="hinh_thuc_uyquyen" class="form-control hinh_thuc_tra_lai"
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
                                                    lãi</strong></label>
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
    <script src="{{asset('project_js/investor/index.js')}}"></script>
@endsection

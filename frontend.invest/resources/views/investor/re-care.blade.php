@extends('layout.master')
@inject('investor', 'App\Http\Controllers\InvestorController')
@section('page_name','Danh sách nhà đầu tư APP')
@section('content')
    @php($tab = !empty(request()->get('tab')) ? request()->get('tab') : 'not-investment')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">VFC Approve</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('investor_re_care')}}"
                                                                   class="text-info">{{$tab == 'not-investment' ? "Danh sách chưa đầu tư" : "Danh sách đã đáo hạn"}}</a>
                </li>
            </ol>
        </div>
    </div>
    @include('layout.alert_success')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-12">
                        <h1 class="d-inline-block text-success">{{$tab == 'not-investment' ? "Danh sách chưa đầu tư" : "Danh sách đã đáo hạn"}}
                            <span
                                class="text-red">({{$count}})</span>
                        </h1>
                        <div class="float-right d-inline-block" id="filter-data">
                            <a class="btn btn-primary" href="#" data-bs-toggle="dropdown">
                                <i class="fas fa-filter"></i>&nbsp;
                                Lọc dữ liệu
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-card" style="width: 500px;">
                                <div class="card d-flex flex-column">
                                    <div class="card-body d-flex flex-column">
                                        <form method="get" action="{{route('investor_re_care')}}">
                                            {{--                                                <input type="hidden" name="per_page">--}}
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
                                            <div class="form-group mb-3">
                                                <label class="form-label">Trạng thái call</label>
                                                <div>
                                                    <select type="text" name="status_call"
                                                            class="form-control status_call">
                                                        <option value="">- Chọn trạng thái -</option>
                                                        <option
                                                            value="100" {{request()->get('status_call') == "100" ? "selected" : ''}}>
                                                            Mới
                                                        </option>
                                                        <option
                                                            value="1" {{request()->get('status_call') == "1" ? "selected" : ''}}>
                                                            Chờ gọi lại
                                                        </option>
                                                        <option
                                                            value="10" {{request()->get('status_call') == "10" ? "selected" : ''}}>
                                                            Đang suy nghĩ
                                                        </option>
                                                        <option
                                                            value="11" {{request()->get('status_call') == "11" ? "selected" : ''}}>
                                                            Kích hoạt thành công
                                                        </option>
                                                        <option
                                                            value="12" {{request()->get('status_call') == "12" ? "selected" : ''}}>
                                                            Chờ bổ sung
                                                        </option>
                                                        <option
                                                            value="13" {{request()->get('status_call') == "13" ? "selected" : ''}}>
                                                            Huỷ
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 note_delete" style="display: none">
                                                <label class="form-label">Lý do hủy</label>
                                                <div>
                                                    <select type="text" name="note_delete" class="form-control">
                                                        <option value="">- Chọn lý do -</option>
                                                        @foreach(note_delete() as $n => $d)
                                                            <option
                                                                value="{{$n}}" {{request()->get('note_delete') == $n ? "selected" : ''}}>{{$d}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label">Trạng thái</label>
                                                <div>
                                                    <select type="text" name='investment_status'
                                                            class="form-control">
                                                        <option value="">- Chọn trạng thái -</option>
                                                        <option
                                                            value="1" {{request()->get('investment_status') == "1" ? "selected" : ''}}>
                                                            Đang đầu tư
                                                        </option>
                                                        <option
                                                            value="2" {{request()->get('investment_status') == "2" ? "selected" : ''}}>
                                                            Chưa đầu tư
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label">Thời gian chăm sóc</label>
                                                <div>
                                                    <select type="text" name='time_care'
                                                            class="form-control">
                                                        <option value="">- Chọn thời gian -</option>
                                                        <option
                                                            value="7" {{request()->get('time_care') == "7" ? "selected" : ''}}>
                                                            Sau 7 ngày
                                                        </option>
                                                        <option
                                                            value="15" {{request()->get('time_care') == "15" ? "selected" : ''}}>
                                                            Sau 15 ngày
                                                        </option>
                                                        <option
                                                            value="30" {{request()->get('time_care') == "30" ? "selected" : ''}}>
                                                            Sau 30 ngày
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            @if(in_array(\App\Service\ActionInterface::CHANGE_CALL, $action_global) || $is_admin == 1)
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Nhân viên</label>
                                                    <div>
                                                        <select type="text" name="find_call_assign"
                                                                class="form-control">
                                                            <option value="">- Chọn nhân viên -</option>
                                                            @foreach($user_tls as $user)
                                                                <option
                                                                    value="{{$user['id']}}" {{request()->get('find_call_assign') == $user['id'] ? "selected" : ''}}>{{$user['email']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @endif
                                            <input type="hidden" name="tab" value="{{$tab}}">
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
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
                            <li class="nav-item">
                                <a href="{{route('investor_re_care')}}?tab=not-investment"
                                   class="btn nav-link {{$tab == 'not-investment' ? 'active text-success' : ''}}"><strong>Chưa
                                        đầu
                                        tư</strong></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('investor_re_care')}}?tab=expire"
                                   class="btn nav-link {{$tab == 'expire' ? 'active text-success' : ''}}"><strong>Đã đáo
                                        hạn</strong></a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane {{$tab == 'not-investment' ? 'active show' : ''}} ">
                                <div class="card-body">
                                    @include('investor.table_investor_active')
                                    {{-- Paginate --}}
                                    <div class="row">
                                        <div class="col-6">

                                        </div>
                                        <div class="col-6">
                                            <div class="float-right">
                                                @if($paginate)
                                                    {{ $paginate->links() }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Table --}}
                                </div>
                            </div>
                            <div class="tab-pane {{$tab == 'expire' ? 'active show' : ''}}">
                                <div class="card-body">
                                    @include('investor.table_investor_active')
                                    {{-- Paginate --}}
                                    <div class="row">
                                        <div class="col-6">

                                        </div>
                                        <div class="col-6">
                                            <div class="float-right">
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
                </div>

            </div>
        </div>
    </div>
    @include("investor.modal_update_investor")
    @include("investor.modal_history_call")
    <link rel="stylesheet" href="{{ asset('css/call/upload_image.css') }}">
    <script src="{{asset('project_js/investor/call.js')}}"></script>
@endsection

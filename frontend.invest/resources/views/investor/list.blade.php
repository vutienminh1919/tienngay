@extends('layout.master')
@inject('investor', 'App\Http\Controllers\InvestorController')
@section('page_name','Danh sách nhà đầu tư APP')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">VFC Approve</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('investor_list')}}"
                                                                   class="text-info">Danh sách nhà đầu tư APP</a></li>
            </ol>
        </div>
    </div>
    @include('layout.alert_success')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="d-inline-block text-success">Danh sách nhà đầu tư APP <span class="text-red">({{$count}})</span>
                            </h1>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {{-- Search --}}
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="float-right d-inline-block" id="filter-data">
                                @if(in_array(\App\Service\ActionInterface::EXCEL_NDT, $action_global) || $is_admin == 1)
                                    <a class="btn btn-primary" href="{{ route('excel_all_list_active') }}"
                                       target="_blank">
                                        <i class="fas fa-file-excel"></i>&nbsp;
                                        Xuất excel
                                    </a>
                                @endif
                                <a class="btn btn-primary" href="#" data-bs-toggle="dropdown">
                                    <i class="fas fa-filter"></i>&nbsp;
                                    Lọc dữ liệu
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-card" style="width: 500px;">
                                    <div class="card d-flex flex-column">
                                        <div class="card-body d-flex flex-column">
                                            <form method="get">
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
                                                            <option value="100">Mới</option>
                                                            <option value="1">Chờ gọi lại</option>
                                                            <option value="10">Đang suy nghĩ</option>
                                                            <option value="11">Kích hoạt thành công</option>
                                                            <option value="12">Chờ bổ sung</option>
                                                            <option value="13">Huỷ</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3 note_delete" style="display: none">
                                                    <label class="form-label">Lý do hủy</label>
                                                    <div>
                                                        <select type="text" name="note_delete" class="form-control">
                                                            <option value="">- Chọn lý do -</option>
                                                            @foreach(note_delete() as $n => $d)
                                                                <option value="{{$n}}">{{$d}}</option>
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
                                                            <option value="1">Đang đầu tư</option>
                                                            <option value="2">Chưa đầu tư</option>
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
                                                                        value="{{$user['id']}}">{{$user['email']}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endif
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
                    @include("investor.table_investor_active")
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
    @include("investor.modal_update_investor")
    @include("investor.modal_history_call")
    <link rel="stylesheet" href="{{ asset('css/call/upload_image.css') }}">
    <script src="{{asset('project_js/investor/call.js')}}"></script>
@endsection

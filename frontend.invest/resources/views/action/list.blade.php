@extends('layout.master')
@section('page_name','Quản lý action')

@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">Bảng phân quyền</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">Quản lý action</a></li>
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
                            <h1 class="d-inline-block">Danh sách Action</h1>
                            @if(in_array(\App\Service\ActionInterface::THEM_MOI_ACTION, $action_global) || $is_admin == 1)
                                <a class="float-right btn btn-primary d-inline-block"
                                   href="{{ route('action_create') }}">
                                    <i class="fas fa-plus"></i>&nbsp;
                                    Thêm mới
                                </a>
                            @endif
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    {{-- Search --}}
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="float-right d-inline-block" id="filter-data">
                                <a class="btn" href="{{ route('action_list') }}">
                                    Xóa filter
                                </a>
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
                                                    <label class="form-label">Tên menu</label>
                                                    <div>
                                                        <input type="text" name="name" class="form-control"
                                                               placeholder="Tên menu"
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
                                        <th>Tên action</th>
                                        <th>Đường dẫn</th>
                                        <th>Menu</th>
                                        <th class="w-1"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $item)
                                        <tr>
                                            <td>{{ $item['name'] }}</td>
                                            <td>{{ $item['url'] }}</td>
                                            @foreach ($menu as $menu_item)
                                                @if ($menu_item['id'] == $item['menu_id'])
                                                    <td>{{ $menu_item['name'] }}</td>
                                                @endif
                                            @endforeach
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
                                                    @if(in_array(\App\Service\ActionInterface::CAP_NHAT_ACTION, $action_global) || $is_admin == 1)
                                                        <div class="dropdown-menu dropdown-menu-end"
                                                             data-bs-popper="none">
                                                            <a class="dropdown-item"
                                                               href="{{ route('action_update', $item['id']) }}">
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
                                                                Chi tiết
                                                            </a>
                                                        </div>
                                                    @endif
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
                {{-- Table --}}
            </div>
        </div>
    </div>
@endsection

@extends('layout.master')
@section('page_name','Danh sách event')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">VFC Investor</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('event.list')}}"
                                                                   class="text-info">Danh sách event</a></li>
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
                            <h1 class="d-inline-block">Danh sách event</h1>
                            {{-- Search --}}
                            <div class="float-right d-inline-block" id="filter-data">
                                <a href="{{route('event.create')}}"
                                   class="btn btn-primary">
                                    <i class="fas fa-plus"></i>&nbsp;
                                    Thêm mới
                                </a>
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
                                        <th>Tên event</th>
                                        <th>Tiêu đề</th>
                                        <th>Lặp lại</th>
                                        <th>Số lần trong tháng</th>
                                        <th>Ngày trong tuần</th>
                                        <th>Ngày thông báo</th>
                                        <th>Khoảng thời gian</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày tạo</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($data) > 0)
                                        @foreach($data as $key => $item)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $item['event'] }}</td>
                                                <td>{{ ($item['title']) }}</td>
                                                <td>{{ !empty($item['repeat']) ? event_repeat($item['repeat'])  : ''}}</td>
                                                <td>{{ !empty($item['month']) ? event_month($item['month']) : ""}}</td>
                                                <td>{{ !empty($item['day']) ? event_day($item['day']) : ""}}</td>
                                                <td>{{ !empty($item['event_day']) ? $item['event_day'] : ""}}</td>
                                                <td>{{ !empty($item['hour']) ? event_hour($item['hour']) : ''}}</td>
                                                <td>
                                                    <label
                                                        class="form-check form-switch d-inline-block mb-0 toggle-status"
                                                        data-id="{{ $item['id'] }}">
                                                        <input class="form-check-input"
                                                               type="checkbox" {{ ($item['status'] == 'active') ? 'checked' : '' }}>
                                                    </label>
                                                </td>
                                                <td>{{ date('d/m/Y H:i:s',($item['created_at'])) }}</td>
                                                <td><a href="{{route('event.show', ['id'=>$item['id']])}}"><i
                                                            class='fas fa-edit'></i></a></td>
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

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('project_js/event/index.js')}}"></script>
@endsection

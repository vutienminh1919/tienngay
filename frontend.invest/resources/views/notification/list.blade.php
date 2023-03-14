@extends('layout.master')
@section('page_name','Danh sách thông báo')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">VFC Investor</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('notification.list')}}"
                                                                   class="text-info">Danh
                        sách thông báo</a></li>
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
                            <h1 class="d-inline-block">Danh sách thông báo</h1>
                            <div class="float-right d-inline-block">
                                <button class="btn btn-primary" id="read_all_noti">
                                    Đọc tất cả
                                </button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    {{-- Table --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-nowrap table-bordered">
                                    <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Thời gian</th>
                                        <th>Note</th>
                                        <th>Link</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $key => $item)
                                        <tr @if($item['status'] == 1) style="background-color: #00e5ff !important;" @endif>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ date('d/m/Y H:i:s',($item['created_at'])) }}</td>
                                            <td>{{ $item['note'] ? $item['note'] : ''}}</td>
                                            <td><a href="{{$item['link'] ? url($item['link']) : ''}}" target="_blank"
                                                   class="update_read_noti" data-id="{{$item['id']}}"><i
                                                        class="fas fa-eye" aria-hidden="true"></i></a></td>
                                        </tr>
                                    @endforeach
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

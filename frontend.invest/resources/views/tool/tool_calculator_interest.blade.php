@extends('layout.master')
@section('page_name','Tool tính lãi suất')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">Cấu hình</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('interest.list_general')}}"
                                                                   class="text-info">Tool tính lãi suất</a></li>
            </ol>
        </div>
    </div>
    @include('layout.alert_success')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="card" style="border-radius: 10px">
                        <div class="card-body">
                            {{-- Head --}}
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h1 class="d-inline-block">Tool tính lãi suất</h1>
                                    {{-- Search --}}
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            {{-- Table --}}
                            <div class="row flex justify-content-center">
                                <div class="col-xs-12  col-lg-8">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label text-bold">Số tiền :<span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control amount_money" type="text"
                                                       placeholder="Nhập số tiền"
                                                       name="amount_money">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-bold">Kì hạn (tháng) :<span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control" name="number_day_loan">
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
                                                <label class="form-label text-bold">Hình thức trả lãi :<span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control"
                                                        name="type_interest">
                                                    @foreach(type_interest() as $t => $ti)
                                                        @continue(in_array($t, [3,5]))
                                                        <option value="{{$t}}">{{$ti}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-bold">Ngày đầu tư :<span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" type="date"
                                                       name="created_at" value="{{date('Y-m-d')}}">
                                            </div>
                                            <button class="btn btn-primary calculator_interest">Tính lãi</button>
                                            <button class="btn btn-secondary clear_calculator_interest">Clear</button>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="table table-vcenter table-nowrap table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th style="text-align: center">Kì</th>
                                                <th style="text-align: center">Lãi suất /(tháng)</th>
                                                <th style="text-align: center">Tổng gốc lãi</th>
                                                <th style="text-align: center">Gốc trả</th>
                                                <th style="text-align: center">Lãi trả</th>
                                                <th style="text-align: center">Ngày trả</th>
                                            </tr>
                                            </thead>
                                            <tbody id="calculator-data">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('project_js/tool/index.js')}}"></script>
@endsection

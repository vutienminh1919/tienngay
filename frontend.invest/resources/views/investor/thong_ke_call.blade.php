@extends('layout.master')
@section('page_name','Thống kê CS Investor')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">VFC Approve</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('thong_ke_call')}}"
                                                                   class="text-info">Thống kê CS Investor</a>
                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="d-inline-block text-success"> Xuất báo cáo CSKH</h1>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card" style="margin-bottom: 30px">
                        <div class="card-header bg-info">
                            <div class="row">
                                <div class="col-12">
                                    <h1 class="d-inline-block text-white">Thống kê CS nhà đầu tư App </h1>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{route('excel_call')}}" method="get"
                                  style="width: 100%;">
                                <div class="row">
                                    <div class="col-md-3 col-sm-12">
                                        <label class="form-label">Từ ngày</label>
                                        <div>
                                            <input type="date" name="fdate" class="form-control fdate"
                                                   value="{{ request()->get('fdate') }}"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <label class="form-label">Đến ngày</label>
                                        <div>
                                            <input type="date" name="tdate" class="form-control tdate"
                                                   value="{{ request()->get('tdate') }}"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <label class="form-label">&nbsp;</label>
                                        <div>
                                            <button class="btn btn-info">Xuất excel &nbsp; <strong><span class="total"></span></strong></button>

                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-success">
                            <div class="row">
                                <div class="col-12">
                                    <h1 class="d-inline-block text-white">Thống kê CS Lead Import</h1>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{route('excel_call_lead')}}" method="get"
                                  style="width: 100%;">
                                <div class="row">
                                    <div class="col-md-3 col-sm-12">
                                        <label class="form-label">Từ ngày</label>
                                        <div>
                                            <input type="date" name="fdate_lead" class="form-control fdate_lead"
                                                   value="{{ request()->get('fdate_lead') }}"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <label class="form-label">Đến ngày</label>
                                        <div>
                                            <input type="date" name="tdate_lead" class="form-control tdate_lead"
                                                   value="{{ request()->get('tdate_lead') }}"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <label class="form-label">&nbsp;</label>
                                        <div>
                                            <button class="btn btn-success">Xuất excel &nbsp; <strong><span class="total_lead"></span></strong></button>

                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
    @include('layout.alert_success')
    <script src="{{asset('project_js/investor/thong_ke_call.js')}}"></script>
@endsection

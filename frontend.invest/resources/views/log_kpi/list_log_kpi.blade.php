@extends('layout.master')
@section('page_name','Log Setup KPIs')
@section('content')
    <div class="row mb-3">
        <div class="col-xs-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">Log Setup KPIs</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{ route('get_list_log_kpi') }}"
                                                                   class="text-info">Log Setup KPIs</a></li>
            </ol>
        </div>
    </div>
{{--    @if(in_array(\App\Service\ActionInterface::VIEW_LOG_KPI, $action_global) || $is_admin == 1)--}}
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <div class="row">
                        <div class="col-md-12 col-xs-12 text-top">
                            <h2>LOG SETUP KPIs HÀNG THÁNG</h2>
                        </div>
                        <hr>
                        <div class="col-xs-12">
                            <div class="row">
                                <form class="submit" action="{{ route('get_list_log_kpi') }}"
                                      method="get">
                                    <div class="col-xs-12">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-3">
                                                <label class="form-label text-bold">Từ ngày </label>
                                                <input class="form-control" type="date" name="from_date" id="fdate"
                                                       value="{{ request()->get('from_date') }}">
                                            </div>
                                            <br>
                                            <div class="col-xs-12 col-md-3">
                                                <label class="form-label text-bold">Đến ngày </label>
                                                <input class="form-control" type="date" name="to_date" id="tdate"
                                                       value="{{ request()->get('to_date') }}">
                                            </div>
                                            <div class="col-xs-12 col-lg-3">
                                                <label class="form-label text-bold">&nbsp;</label>
                                                <button class="btn btn-primary" type="submit"><span
                                                        class="fa fa-search"></span> Tìm kiếm
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
                <div>
                    <hr>
                </div>
                <div class="x_content">
                    {{-- Table --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-nowrap table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center">STT</th>
                                        <th style="text-align: center">ID_KPI</th>
                                        <th style="text-align: center">ACTION</th>
                                        <th style="text-align: center">TYPE</th>
                                        <th style="text-align: center">OLD DATA</th>
                                        <th style="text-align: center">NEW DATA</th>
                                        <th style="text-align: center">CREATED_BY</th>
                                        <th style="text-align: center">CREATED_AT</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($log_kpi_data as $key => $log_kpi)
                                        <tr>
                                            <td>{{ ++$key  }}</td>
                                            <td>{{ !empty($log_kpi['id_kpi']) ? $log_kpi['id_kpi'] : ''  }}</td>
                                            <td>{{ !empty($log_kpi['action']) ? $log_kpi['action'] : ''  }}</td>
                                            <td>{{ !empty($log_kpi['type']) ? $log_kpi['type'] : ''  }}</td>
                                            <td>{{ !empty($log_kpi['old']) ? $log_kpi['old'] : ''  }}</td>
                                            <td>{{ !empty($log_kpi['new']) ? $log_kpi['new'] : ''  }}</td>
                                            <td>{{ !empty($log_kpi['created_by']) ? $log_kpi['created_by'] : ''  }}</td>
                                            <td>{{ !empty($log_kpi['created_at']) ? date('d/m/Y H:i:s', $log_kpi['created_at']) : ''  }}</td>
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
@endsection

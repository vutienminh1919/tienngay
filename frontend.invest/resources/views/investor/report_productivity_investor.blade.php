@extends('layout.master')
@section('page_name','Báo cáo năng suất chăm sóc NĐT')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">VFC Approve</a></li>
                <li class="breadcrumb-item" aria-current="page">
                    <a href="{{route('report_productivity_investor')}}" class="text-info">Báo cáo năng suất chăm sóc
                        NĐT</a>
                </li>
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
                            <h1 class="d-inline-block text-success">Báo cáo năng suất chăm sóc NĐT<span
                                    class="text-red"></span></h1>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {{-- Search --}}
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="float-left hide" id="btn-group">
                                <button type="button" class="btn btn-no-border btn-color-green" id="show-confirm-btn">
                                    <i class="ti ti-circle-check" style="font-size: 21px"></i> &nbsp;
                                    Xác nhận
                                </button>
                                <button type="button" class="btn btn-no-border btn-color-red" id="show-block-btn">
                                    <i class="ti ti-circle-x" style="font-size: 21px"></i> &nbsp;
                                    Block
                                </button>
                            </div>
                            <div class="float-right d-inline-block" id="filter-data">
                                @if(in_array(\App\Service\ActionInterface::EXCEL_BCNS_CS_NDT, $action_global) || $is_admin == 1)
                                <a class="btn btn-success" href="" target="_blank" onclick="fnExcelReportInvestor();">
                                    <i class="fas fa-file-excel"></i>&nbsp;
                                    Excel
                                </a>
                                @endif
                                <a class="btn btn-primary" href="#" data-bs-toggle="dropdown">
                                    <i class="fas fa-filter"></i>&nbsp;
                                    Lọc dữ liệu
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-card" style="width: 500px;">
                                    <div class="card d-flex flex-column">
                                        <div class="card-body d-flex flex-column">
                                            <form method="get" action="{{route('report_productivity_investor')}}">
                                                <div class="mb-3">
                                                    <div class="text-large">Thông tin tìm kiếm</div>
                                                    <hr class="mt-2 mb-0">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Ngày bắt đầu</label>
                                                    <div>
                                                        <input type="datetime-local" name="start_date"
                                                               class="form-control"
                                                               value="{{ request()->get('start_date') }}"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Ngày kết thúc</label>
                                                    <div>
                                                        <input type="datetime-local" name="end_date"
                                                               class="form-control"
                                                               value="{{ request()->get('end_date') }}"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
                                                @if(in_array(\App\Service\ActionInterface::TIM_KIEM_TLS, $action_global) || $is_admin == 1)
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Nhân viên</label>
                                                        <div>
                                                            <select type="text" name="find_call_assign"
                                                                    class="form-control">
                                                                <option value="">- Chọn nhân viên -</option>
                                                                @foreach($user_tls as $tls)
                                                                    <option value="{{ $tls['id'] ? $tls['id'] : '' }}" {{ !empty(request()->get('find_call_assign')) && request()->get('find_call_assign') == $tls['id'] ? 'selected' : '' }}>{{ $tls['email'] ? $tls['email'] : '' }}</option>
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
                    {{-- Table --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="table_report_productivity"
                                       class="table table-vcenter table-nowrap table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center" rowspan="2">STT</th>
                                        <th style="text-align: center" rowspan="2">CSKH</th>
                                        <th style="text-align: center" colspan="3">Tổng lead phân bổ</th>
                                        <th style="text-align: center" colspan="3">Tổng lead xử lý</th>
                                        <th rowspan="2">Tỉ lệ xử lý</th>
                                        <th rowspan="2">Kích hoạt mới</th>
                                        <th rowspan="2">Tổng thu</th>
                                    </tr>
                                    <tr>
                                        <th>Trong ngày</th>
                                        <th>Tồn cũ chưa xử lý dứt điểm</th>
                                        <th>Tổng Lead</th>
                                        <th>Trong ngày</th>
                                        <th>Tồn cũ đã xử lý</th>
                                        <th>Tổng xử lý</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($data) > 0)
                                        @foreach($data as $key => $productivity)
                                            @continue($productivity['email_tls'] == 'ngochtm@tienngay.vn')
                                            <tr style="text-align: center">
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $productivity['email_tls'] ? $productivity['email_tls'] : '' }}</td>
                                                <td>{{ $productivity['lead_new_in_day'] ? $productivity['lead_new_in_day'] : 0 }}</td>
                                                <td style="color: red">{{ $productivity['backlog_old_not_yet'] ? $productivity['backlog_old_not_yet'] : 0 }}</td>
                                                <td>{{ $productivity['total_lead_divide'] ? $productivity['total_lead_divide'] : 0 }}</td>
                                                <td>{{ $productivity['lead_processed_in_day'] ? $productivity['lead_processed_in_day'] : 0 }}</td>
                                                <td style="color:green;">{{ ($productivity['lead_processed_old_realtime'] < 0) ? 0 : $productivity['lead_processed_old_realtime'] }}</td>
                                                <td>{{ $productivity['total_lead_processed'] ? $productivity['total_lead_processed'] : 0 }}</td>
                                                <td style="color: blue">{{ $productivity['percent_processed'] ? $productivity['percent_processed'] . ' %' : 0 }}</td>
                                                <td style="color: green">{{ ($productivity['lead_new_activated_realtime'] < 0) ? 0 : $productivity['lead_new_activated_realtime'] }}</td>
                                                <td style="color: red">{{ $productivity['sum_amount_investment'] ? number_format($productivity['sum_amount_investment']) . ' đ' : 0 }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr style="text-align: center; color: red">
                                            <td colspan="15">
                                                <span>Không có dữ liệu</span>
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function fnExcelReportInvestor(e) {
            var tab_text = "<table border='2px'><tr bgcolor='#87AFC6'>";
            var textRange;
            var j = 0;
            tab = document.getElementById('table_report_productivity'); // id of table

            for (j = 0; j < tab.rows.length; j++) {
                tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
                //tab_text=tab_text+"</tr>";
            }

            tab_text = tab_text + "</table>";
            tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
            tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
            tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

            var ua = window.navigator.userAgent;
            var msie = ua.indexOf("MSIE ");

            if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
            {
                txtArea1.document.open("txt/html", "replace");
                txtArea1.document.write(tab_text);
                txtArea1.document.close();
                txtArea1.focus();
                sa = txtArea1.document.execCommand("SaveAs", true, "data.xls");
            } else {
                var sa = document.createElement('a');
                var data_type = 'data:application/vnd.ms-excel';
                var table_html = encodeURIComponent(tab_text);
                sa.href = data_type + ', ' + table_html;
                let d = new Date();
                let ye = new Intl.DateTimeFormat('en', {year: 'numeric'}).format(d);
                let mo = new Intl.DateTimeFormat('en', {month: 'numeric'}).format(d);
                let da = new Intl.DateTimeFormat('en', {day: '2-digit'}).format(d);
                let str_date = `${da}_${mo}_${ye}`;
                sa.download = 'RP_CARE_INVESTOR_' + str_date + '.xls';
                sa.click();
                e.preventDefault();
            }
            return (sa);
        }
    </script>
@endsection

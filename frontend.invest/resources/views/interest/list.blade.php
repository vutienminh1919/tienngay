@extends('layout.master')
@section('page_name','Quản lý lãi suất chung')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">Cấu hình</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('interest.list_general')}}"
                                                                   class="text-info">Lãi suất chung</a></li>
            </ol>
        </div>
    </div>
    @include('layout.alert_success')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-lg-7 col-sm-12">
                    <div class="card" style="border-radius: 10px">
                        <div class="card-body">
                            {{-- Head --}}
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h1 class="d-inline-block">Lãi suất chung</h1>
                                    {{-- Search --}}
                                    <div class="float-right d-inline-block">
                                        <button data-bs-toggle="modal" data-bs-target="#timeline_interest"
                                                class="btn btn-primary">
                                            <i class="fas fa-chart-line"></i> &nbsp; Thống kê
                                        </button>
                                        @if(in_array(\App\Service\ActionInterface::THEM_LAI_SUAT_CHUNG, $action_global) || $is_admin == 1)
                                            <button data-bs-toggle="modal" data-bs-target="#add_interest_modal"
                                                    class="btn btn-primary" id="add_interest">
                                                <i class='fas fa-plus'></i> &nbsp;Thêm lãi suất
                                            </button>
                                        @endif
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
                                                <th>Lãi suất áp dụng</th>
                                                <th>Cập nhật lần cuối</th>
                                                <th>Ngày tạo</th>
                                                <th>Trạng thái</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count($data) > 0)
                                                @foreach($data as $key => $item)
                                                    <tr>
                                                        <td>{{++$key}}</td>
                                                        <td>{{$item['interest']}} %</td>
                                                        <td>{{date('d/m/Y H:i:s',$item['updated_at'])}}</td>
                                                        <td>{{date('d/m/Y H:i:s',$item['created_at'])}}</td>
                                                        <td>
                                                            @if(in_array(\App\Service\ActionInterface::THEM_LAI_SUAT_CHUNG, $action_global) || $is_admin == 1)
                                                                <label class="form-check form-switch toggle-status"
                                                                       data-id="{{ $item['id'] }} ">
                                                                    <input class="form-check-input"
                                                                           style="margin-top: 6px"
                                                                           type="checkbox" {{ ($item['status'] == 'active') ? 'checked' : '' }}>
                                                                </label>
                                                            @else
                                                                @if($item['status'] == 'active')
                                                                    <label class="badge badge-success">Active</label>
                                                                @else
                                                                    <label class="badge badge-block">Block</label>
                                                                @endif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="20" class="text-danger" style="text-align: center">
                                                        Không có dữ
                                                        liệu
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
                <div class="col-lg-5 col-sm-12">
                    <div class="card" style="border-radius: 10px">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h1 class="d-inline-block">Tổng hợp đồng theo lãi suất</h1>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <canvas id="myChart" width="200" height="100">
                            </canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col-lg-7 col-sm-12">
                    <div class="card" style="border-radius: 10px">
                        <div class="card-body">
                            {{-- Head --}}
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h1 class="d-inline-block">Lãi suất theo kì hạn</h1>
                                    {{-- Search --}}
                                    <div class="float-right d-inline-block">
                                        {{--                                        <button data-bs-toggle="modal" data-bs-target="#timeline_interest_period"--}}
                                        {{--                                                class="btn btn-primary">--}}
                                        {{--                                            <i class="fas fa-chart-line"></i> &nbsp; Thống kê--}}
                                        {{--                                        </button>--}}
                                        @if(in_array(\App\Service\ActionInterface::THEM_LAI_SUAT_CHUNG, $action_global) || $is_admin == 1)
                                            <button data-bs-toggle="modal" data-bs-target="#add_interest_period_modal"
                                                    class="btn btn-primary" id="add_interest_period">
                                                <i class='fas fa-plus'></i> &nbsp;Thêm kì hạn
                                            </button>
                                        @endif
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            {{-- Table --}}
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-vcenter table-nowrap table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th style="text-align: center">Hình thức</th>
                                                <th>Kì hạn</th>
                                                <th>Lãi suất(/tháng)</th>
                                                <th>Cập nhật cuối</th>
                                                <th>Trạng thái</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count($periods) > 0)
                                                @foreach($periods as $k => $period)
                                                    @foreach($period as $i => $v)
                                                        <tr>
                                                            @if ($i == 0)
                                                                <td rowspan="{{count($period)}}"
                                                                    style="text-align: center">
                                                                    @if($k ==1)
                                                                        Lãi hàng tháng, gốc hàng tháng
                                                                    @elseif($k ==2)
                                                                        Lãi hàng tháng, gốc cuối kỳ
                                                                    @elseif($k ==4)
                                                                        Gốc lãi cuối kỳ
                                                                    @else
                                                                        Áp dụng chung
                                                                    @endif
                                                                </td>
                                                            @endif
                                                            <td>{{$v['period'] . ' tháng'}}</td>
                                                            <td>{{$v['interest']}} %</td>
                                                            <td>{{date('d/m/Y H:i:s',$v['updated_at'])}}</td>
                                                            <td>
                                                                @if(in_array(\App\Service\ActionInterface::THEM_LAI_SUAT_CHUNG, $action_global) || $is_admin == 1)
                                                                    <label
                                                                        class="form-check form-switch toggle-status-period"
                                                                        data-id="{{ $v['id'] }} ">
                                                                        <input class="form-check-input"
                                                                               style="margin-top: 6px"
                                                                               type="checkbox" {{ ($v['status'] == 'active') ? 'checked' : '' }}>
                                                                    </label>
                                                                @else
                                                                    @if($v['status'] == 'active')
                                                                        <label
                                                                            class="badge badge-success">Active</label>
                                                                    @else
                                                                        <label class="badge badge-block">Block</label>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if(in_array(\App\Service\ActionInterface::THEM_LAI_SUAT_CHUNG, $action_global) || $is_admin == 1)
                                                                    <a class="btn update_new_interest_period"
                                                                       style="border-style: none;background: unset;padding: 0"
                                                                       data-bs-toggle="modal"
                                                                       data-bs-target="#update_interest_period_modal"
                                                                       data-id="{{$v['id']}}"
                                                                       data-period="{{$v['period']}}"
                                                                       data-type="{{$k}}">
                                                                        <i class="fa fa-edit"
                                                                           style="font-size:20px;color:cornflowerblue;"></i>
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="20" class="text-danger" style="text-align: center">
                                                        Không có dữ
                                                        liệu
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
        </div>
    </div>
    <div class="modal modal-blur" id="add_interest_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius: 10px">
                <div class="modal-header">
                    <h5 class="modal-title d-inline-block">THÊM MỚI LÃI SUẤT CHUNG</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-bold">Lãi suất áp dụng(%) :<span
                                class="text-danger">*</span></label>
                        <input class="form-control" type="number" placeholder="Nhập lãi suất áp dụng" name="interest">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn_add_interest" data-bs-dismiss="modal">Xác
                        nhận
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur" id="timeline_interest" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius: 10px">
                <div class="modal-header">
                    <h5 class="modal-title">Thống kê</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-nowrap table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center">STT</th>
                                        <th style="text-align: center">Lãi suất áp dụng</th>
                                        <th style="text-align: center">Số HĐ áp dụng</th>
                                        <th style="text-align: center">Danh sách HĐ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($thong_ke) > 0)
                                        @foreach($thong_ke as $key => $value)
                                            <tr style="text-align: center">
                                                <td>{{++$key}}</td>
                                                <td style="color: red">{{$value['interest']}} %</td>
                                                <td style="color: green">{{($value['total_contract'])}}</td>
                                                <td>
                                                    <a class="link-primary"
                                                       href="{{route('interest.detail_show',['id'=>$value['id']])}}"
                                                       target="_blank">Xem danh sách</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="20" class="text-danger" style="text-align: center">
                                                Không có dữ
                                                liệu
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur" id="add_interest_period_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius: 10px">
                <div class="modal-header">
                    <h5 class="modal-title d-inline-block">THÊM MỚI LÃI SUẤT KÌ HẠN VAY</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-bold">Hình thức trả lãi :<span
                                class="text-danger">*</span></label>
                        <select class="form-control"
                                name="type_interest_period">
                            <option value="">-- Chọn hình thức --</option>
                            @foreach(type_interest() as $t =>$ti)
                                @continue(in_array($t, [3,5]))
                                <option value="{{$t}}">{{$ti}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-bold">Kì hạn vay(tháng) :<span
                                class="text-danger">*</span></label>
                        <select class="form-control" name="period">
                            <option value="">-- Chọn kỳ hạn --</option>
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
                        <label class="form-label text-bold">Lãi suất áp dụng(%/tháng) :<span
                                class="text-danger">*</span></label>
                        <input class="form-control" type="number" placeholder="Nhập lãi suất áp dụng"
                               name="interest_period">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn_add_interest_period" data-bs-dismiss="modal">
                        Xác
                        nhận
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur" id="update_interest_period_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius: 10px">
                <div class="modal-header">
                    <h5 class="modal-title d-inline-block title-update-period"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-bold">Hình thức trả lãi :<span
                                class="text-danger">*</span></label>
                        <input class="form-control type_interest_period_now" type="text"
                               placeholder=""
                               name="" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-bold">Lãi suất hiện tại(%/tháng) :<span
                                class="text-danger">*</span></label>
                        <input class="form-control interest_period_now" type="number"
                               placeholder="Nhập lãi suất áp dụng"
                               name="interest_period_now" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-bold">Lãi suất mới(%/tháng) :<span
                                class="text-danger">*</span></label>
                        <input class="form-control interest_period_edit" type="number"
                               placeholder="Nhập lãi suất áp dụng"
                               name="interest_period_edit">
                    </div>
                    <input class="form-control interest_period_id" type="hidden"
                           name="interest_period_id">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary " id="btn_edit_add_interest_period"
                            data-bs-dismiss="modal">
                        Xác
                        nhận
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur" id="timeline_interest_period" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius: 10px">
                <div class="modal-header">
                    <h5 class="modal-title">Thống kê theo kì hạn</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-nowrap table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center">STT</th>
                                        <th style="text-align: center">Kì hạn</th>
                                        <th style="text-align: center">Số hợp đồng</th>
                                        <th style="text-align: center">Danh sách HĐ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($thong_ke1) > 0)
                                        @foreach($thong_ke1 as $i => $t)
                                            <tr style="text-align: center">
                                                <td>{{++$i}}</td>
                                                <td style="color: red">{{$t['period']}} tháng</td>
                                                <td style="color: green">{{($t['total_contract_period'])}}</td>
                                                <td>
                                                    <a class="link-primary"
                                                       href="{{route('interest.detail_show',['id'=>$t['id']])}}"
                                                       target="_blank">Xem danh sách</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="20" class="text-danger" style="text-align: center">
                                                Không có dữ
                                                liệu
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('project_js/interest/add_interest.js')}}"></script>
    <script>
            <?php
            $data_x = [];
            $data_y = [];
            $data_z = [];
            foreach ($bieu_do as $k => $v) {
                $data_x[] = "$k";
                $data_y[] = "$v";
            }
            //        foreach ($bieu_do as $k => $v) {
            //            $data_x[] = "$k";
            //        }
            //        foreach ($bieu_do2 as $k2 => $v2) {
            //            $data_x[] = "$k2";
            //        }
            //        $x = array_unique($data_x);
            //        asort($x);
            //        foreach ($x as $v3) {
            //            $data_y[] = !empty($bieu_do["$v3"]) ? $bieu_do["$v3"] : 0;
            //            $data_z[] = !empty($bieu_do2["$v3"]) ? $bieu_do2["$v3"] : 0;
            //        }
            //        $labels = implode(",", $x);
            $labels = implode(",", $data_x);
            $data1 = implode(",", $data_y);
            //        $data2 = implode(",", $data_z);
            ?>
        const labels = [<?php echo $labels; ?>];
        const data = {
            labels: labels,
            datasets: [
                {
                    label: 'Hợp đồng theo Lãi suất',
                    data: [<?php echo $data1; ?>],
                    borderColor: '#008000',
                    backgroundColor: 'rgb(255, 99, 132)',
                },
                {{--{--}}
                {{--    label: 'Lãi suất theo kì hạn',--}}
                {{--    data: [<?php echo $data2; ?>],--}}
                {{--    borderColor: '#0000FF',--}}
                {{--    backgroundColor: '#FF0000',--}}
                {{--}--}}
            ]
        };
        const config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                    }
                }
            },
        };
        var myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    </script>
@endsection

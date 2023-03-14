@extends('layout.master')
@section('page_name','Nhà đầu tư uỷ quyền')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">VFC Investor</a></li>
                <li class="breadcrumb-item"><a href="ndt_app">Yêu cầu vay và chấp nhận thực tế</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('contract.list')}}" class="text-info">Nhà
                        đầu tư uỷ quyền</a></li>
            </ol>
        </div>
    </div>
    @include('layout.alert_success')
    <div class="row mb-3">
        <div class="col-9">
            <div class="card">
                <div class="card-body">
                    {{-- Head --}}
                    <div class="row mb-3">
                        <div class="col-12">
                            <h1 class="d-inline-block">Tổng chi tiết - Nguyễn Văn A</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                           <div class="list_items">
                                <label>Mã nhà đầu tư</label>
                               <strong>KH0938995286</strong>
                           </div>
                        </div>
                        <div class="col-4">
                            <div class="list_items">
                                <label>Số hợp đồng</label>
                                <strong>8</strong>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="list_items">
                                <label>Tổng số tiền nhà đầu tư</label>
                                <strong class="text-color_default">30.000.000đ</strong>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="list_items">
                                <label>Tổng tiền đã trả</label>
                                <strong>KH0938995286</strong>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="list_items">
                                <label>Tổng tiền gốc đã trả</label>
                                <strong>8</strong>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="list_items">
                                <label>Tổng tiền gốc còn nợ</label>
                                <strong class="text-color_default">30.000.000đ</strong>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="list_items">
                                <label>Tổng lãi sẽ nhận được</label>
                                <strong>KH0938995286</strong>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="list_items">
                                <label>Tổng lãi đã trả</label>
                                <strong>8</strong>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="list_items">
                                <label>Tổng lãi còn nợ</label>
                                <strong class="text-color_default">30.000.000đ</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <div class="chart_body">
                        <div class="doughnut_middledata" style="color: #0e9549;">
                            10.000.000            </div>
                        <canvas id="chart" height="200" width="200"></canvas>
                        <div class="clear" style="clear: left"></div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="lai_ndt">
                                <span></span>
                                <div class="total_NDT">
                                    <label>Tiền lãi trả NĐT</label>
                                    <strong>7.500.000đ</strong>
                                </div>
                                <div class="clear" style="clear: left"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="lai_ndt">
                                <span style="background: #e0e0e0"></span>
                                <div class="total_NDT">
                                    <label>Tiền chênh lệch thu về</label>
                                    <strong>2.500.000đ</strong>
                                </div>
                                <div class="clear" style="clear: left"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="lai_ndt">
                                <span style="background: transparent"></span>
                                <div class="total_NDT">
                                    <label>Tổng tiền lãi cho khách hàng vay</label>
                                    <strong>2.500.000đ</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Head --}}
                    <div class="row mb-3">
                        <div class="col-12">
                            <h1 class="d-inline-block">Danh sách hợp đồng</h1>
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
                                        <th>Mã hợp đồng</th>
                                        <th>Số tiền đầu tư</th>
                                        <th>Ngày giải ngân</th>
                                        <th style="text-align: center">Số kỳ thanh toán</th>
                                        <th style="text-align: center">Lãi suất</th>
                                        <th>Tổng lãi nhận được</th>
                                        <th class="w-1"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th>1</th>
                                        <th>HĐCC/ĐKXM/QN398TP/2014/01</th>
                                        <th>10.000.000</th>
                                        <th>30-03-2021</th>
                                        <th style="text-align: center">3</th>
                                        <th style="text-align: center">1.5%</th>
                                        <th>500.000 VNĐ</th>
                                        <th class="w-1">
                                            <a class="" href="#" data-bs-toggle="dropdown" style="color: #000">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="list_id_invest">Xem chi tiết</a>
                                            </div>
                                        </th>


                                    </tr>
                                    <tr>
                                        <th>2</th>
                                        <th>HĐCC/ĐKXM/QN398TP/2014/01</th>
                                        <th>10.000.000</th>
                                        <th>30-03-2021</th>
                                        <th style="text-align: center"> 3</th>
                                        <th style="text-align: center">1.5%</th>
                                        <th>500.000 VNĐ</th>
                                        <th class="w-1">
                                            <a class="" href="#" data-bs-toggle="dropdown" style="color: #000">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="list_id_invest">Xem chi tiết</a>
                                            </div>
                                        </th>


                                    </tr>
                                    <tr>
                                        <th>3</th>
                                        <th>HĐCC/ĐKXM/QN398TP/2014/01</th>
                                        <th>10.000.000</th>
                                        <th>30-03-2021</th>
                                        <th style="text-align: center">3</th>
                                        <th style="text-align: center">1.5%</th>
                                        <th>500.000 VNĐ</th>
                                        <th class="w-1">
                                            <a class="" href="#" data-bs-toggle="dropdown" style="color: #000">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="list_id_invest">Xem chi tiết</a>
                                            </div>
                                        </th>


                                    </tr>
                                    <tr>
                                        <th>4</th>
                                        <th>HĐCC/ĐKXM/QN398TP/2014/01</th>
                                        <th>10.000.000</th>
                                        <th>30-03-2021</th>
                                        <th style="text-align: center">3</th>
                                        <th style="text-align: center">1.5%</th>
                                        <th>500.000 VNĐ</th>
                                        <th class="w-1">
                                            <a class="" href="#" data-bs-toggle="dropdown" style="color: #000">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="list_id_invest">Xem chi tiết</a>
                                            </div>
                                        </th>


                                    </tr>
                                    <tr>
                                        <th>5</th>
                                        <th>HĐCC/ĐKXM/QN398TP/2014/01</th>
                                        <th>10.000.000</th>
                                        <th>30-03-2021</th>
                                        <th style="text-align: center">3</th>
                                        <th style="text-align: center">1.5%</th>
                                        <th>500.000 VNĐ</th>
                                        <th class="w-1">
                                            <a class="" href="#" data-bs-toggle="dropdown" style="color: #000">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="list_id_invest">Xem chi tiết</a>
                                            </div>
                                        </th>


                                    </tr>

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
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            const red_min_hex = '45';
            const red_min_dec = parseInt(red_min_hex, 16);
            const red_max_hex = 'cc';
            const red_max_dec = parseInt(red_max_hex, 16);
            const green_min_hex = '35';
            const green_min_dec = parseInt(green_min_hex, 16);
            const green_max_hex = 'ac';
            const green_max_dec = parseInt(green_max_hex, 16);
            const blue_min_hex = '20';
            const blue_min_dec = parseInt(blue_min_hex, 16);
            const blue_max_hex = '78';
            const blue_max_dec = parseInt(blue_max_hex, 16);

            const pi = Math.PI;

            const animateArc = chart => {
                let arc = chart.getDatasetMeta(0).data[0];
                let angle = arc._view.endAngle + pi / 2;
                let angle_inverse = 2 * pi - angle;
                let blue = Math.round(
                    (angle / (2 * pi)) * blue_max_dec + (angle_inverse / (2 * pi)) * blue_min_dec
                ).toString(16);
                if (arc._view.endAngle < pi / 2) {
                    let green = Math.round(
                        (angle / pi) * green_max_dec + ((pi - angle) / pi) * green_min_dec
                    ).toString(16);
                    if (green.length < 2) green = '0' + green;
                    let color = `#${red_max_hex}${green}${blue}`;
                    arc.round.backgroundColor = "#0e9549";
                    drawArc(chart, arc, "#0e9549");
                } else {
                    let red = Math.round(
                        ((2 * pi - angle) / pi) * red_max_dec + ((angle - pi) / pi) * red_min_dec
                    ).toString(16);
                    if (red.length < 2) red = '0' + red;
                    if (red === '45') red = 50;
                    if (blue === '78') blue = 74;
                    let color = `#${red}${green_max_hex}${blue}`;
                    arc.round.backgroundColor = "#0e9549";
                    drawArc(chart, arc, "#0e9549");
                }
            }

            const drawArc = (chartm, arc, color) => {
                let x = (chart.chartArea.left + chart.chartArea.right) / 2;
                let y = (chart.chartArea.top + chart.chartArea.bottom) / 2;
                chart.ctx.fillStyle = color;
                chart.ctx.strokeStyle = color;
                chart.ctx.beginPath();
                if (arc != null) {
                    chart.ctx.arc(x, y, chart.outerRadius, arc._view.startAngle, arc._view.endAngle);
                    chart.ctx.arc(x, y, chart.innerRadius, arc._view.endAngle, arc._view.startAngle, true);
                } else {
                    chart.ctx.arc(x, y, chart.outerRadius, 0, 2 * pi);
                    chart.ctx.arc(x, y, chart.innerRadius, 0, 2 * pi, true);
                }
                chart.ctx.fill();
            }

            const addCenterTextAfterUpdate = chart => {

            }

            const roundCornersAfterUpdate = chart => {
                if (chart.config.options.elements.arc.roundCorners !== undefined) {
                    let arc = chart.getDatasetMeta(0).data[chart.config.options.elements.arc.roundCorners];
                    arc.round = {
                        x: (chart.chartArea.left + chart.chartArea.right) / 2,
                        y: (chart.chartArea.top + chart.chartArea.bottom) / 2,
                        radius: (chart.outerRadius + chart.innerRadius) / 2,
                        thickness: (chart.outerRadius - chart.innerRadius) / 2,
                        backgroundColor: "#0e9549",
                    };
                }
            };
            const roundCornersAfterDraw = chart => {
                if (chart.config.options.elements.arc.roundCorners !== undefined) {
                    var arc = chart.getDatasetMeta(0).data[chart.config.options.elements.arc.roundCorners];
                    var startAngle = pi / 2 - arc._view.startAngle;
                    var endAngle = pi / 2 - arc._view.endAngle;
                    chart.ctx.save();
                    chart.ctx.translate(arc.round.x, arc.round.y);
                    chart.ctx.fillStyle = "#0e9549";
                    chart.ctx.beginPath();
                    chart.ctx.arc(
                        arc.round.radius * Math.sin(startAngle),
                        arc.round.radius * Math.cos(startAngle),
                        arc.round.thickness,
                        0,
                        2 * pi
                    );
                    chart.ctx.arc(
                        arc.round.radius * Math.sin(endAngle),
                        arc.round.radius * Math.cos(endAngle),
                        arc.round.thickness,
                        0,
                        2 * pi
                    );
                    chart.ctx.fill();
                    chart.ctx.restore();
                }
            };

            var datasets = [{
                "data": [84, 16],
                "backgroundColor": [ "#e0e0e0", "#e0e0e0" ]
            }];
            var chartData = {
                type: 'doughnut',
                data: { datasets: datasets },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutoutPercentage: 90,
                    segmentShowStroke: false,
                    events: [],
                    elements: {
                        arc: {
                            roundCorners: 0,
                            borderWidth: 0
                        }
                    },
                    animation: {
                        onProgress: animation => {
                            animation.easing = 'linear';
                            animateArc(animation.chart)
                        }
                    }
                }
            }

            var ctx = document.getElementById('chart').getContext('2d');
            var chart = new Chart(ctx, {
                ...chartData,
                plugins: [{
                    beforeDraw: chart => {
                        drawArc(chart, null, '#e0e0e0');
                    },
                    afterUpdate: chart => {
                        addCenterTextAfterUpdate(chart);
                        roundCornersAfterUpdate(chart);
                    },
                    afterDraw: chart => {
                        roundCornersAfterDraw(chart);
                    },
                    resize: () => new Chart(ctx, {
                        ...chartData,
                        plugins: [{
                            beforeDraw: chart => {
                                drawArc(chart, null, '#e0e0e0');
                            },
                            afterUpdate: chart => {
                                addCenterTextAfterUpdate(chart);
                                roundCornersAfterUpdate(chart);
                            },
                            afterDraw: chart => {
                                roundCornersAfterDraw(chart);
                            },
                        }]
                    })
                }]
            });
        });
    </script>
@endsection
<style>
    .markdown > table > :not(caption) > * > *, .table > :not(caption) > * > * {
        padding: 15px 10px;
        font-weight: normal;
        font-size: 14px;
    }
    .list_items
    {
        padding: 20px 0;
    }
    .list_items label{
        display: block;
        font-size: 15px;
        margin-bottom: 3px;
        color: #8a8686;
        font-weight: normal;
    }
    .list_items strong
    {
        font-size: 20px;
    }
    .text-color_default
    {
        color: #0e9549;
    }
    .chart_body
    {
        position: relative;
    }
    #chart
    {
        transform: rotate(180deg);
    }
    .doughnut_middledata {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translateX(-50%)translateY(-50%);
        text-align: center;
        line-height: 1.2;
        font-size: 24px;
        color: #000;
        font-weight: bold;
    }
    canvas
    {
        margin-top: 12px;
    }
    .lai_ndt
    {
        margin-bottom: 15px;
    }
    .lai_ndt span{
        background: #0e9549;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        float: left;
        margin-top: 4px;
    }
    .lai_ndt label
    {
        font-size: 13px;
        margin-bottom: 5px;
        display: block;
    }
    .total_NDT
    {
        float: left;
        margin-left: 2px;
    }
    .total_NDT strong {
        font-weight: 600;
        font-size: 20px;
    }
    input[type="radio"]
    {
        filter: invert(1%) hue-rotate(
            290deg
        ) brightness(1);
    }
    #filter-data .btn-filter
    {
        height: 36px;
        width: 36px;
    }
</style>

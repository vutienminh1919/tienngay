@extends('layout.master')
@section('page_name','Dashboard')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard.index')}}"
                                                                   class="text-info">Dashboard</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="row flex justify-content-center">
                <div class="col-lg-6 col-sm-12">
                    @if(in_array(\App\Service\ActionInterface::XEM_CHART_INVEST, $action_global) || $is_admin == 1)
                        <div class="card" style="border-radius: 10px">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h1 class="d-inline-block">Tổng tiền đầu tư theo tháng trong
                                            năm {{date('Y')}}</h1>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <canvas id="chart_invest" width="200" height="100">
                                </canvas>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-lg-6 col-sm-12">
                    @if(in_array(\App\Service\ActionInterface::XEM_CHART_INVEST, $action_global) || $is_admin == 1)
                        <div class="card" style="border-radius: 10px">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h1 class="d-inline-block">Tổng tiền đầu tư theo ngày trong
                                            tháng {{date('m-Y')}}</h1>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <canvas id="chart_invest_by_day" width="200" height="100">
                                </canvas>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-lg-6 col-sm-12">
                    @if(in_array(\App\Service\ActionInterface::XEM_CHART_PAYMENT, $action_global) || $is_admin == 1)
                        <div class="card" style="border-radius: 10px">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h1 class="d-inline-block">Tổng tiền trả theo tháng trong
                                            năm {{date('Y')}}</h1>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <canvas id="chart_payment" width="200" height="100">
                                </canvas>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-lg-6 col-sm-12">
                    @if(in_array(\App\Service\ActionInterface::XEM_CHART_PAYMENT, $action_global) || $is_admin == 1)
                        <div class="card" style="border-radius: 10px">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h1 class="d-inline-block">Tổng tiền trả theo ngày trong
                                            tháng {{date('m-Y')}}</h1>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <canvas id="chart_payment_by_day" width="200" height="100">
                                </canvas>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
            <?php
            $labels = '';
            foreach ($month as $str) {
                $labels .= "'" . $str . "'" . ',';
            }
            $data_total_invest = implode(",", $chart_invest);
            ?>
        const labels = [<?php echo $labels; ?>];
        const data = {
            labels: labels,
            datasets: [{
                label: 'Tổng tiền nạp theo tháng',
                data: [<?php echo $data_total_invest; ?>],
                borderColor: '#09bf5d',
                backgroundColor: '#09bf5d',
            },]
        };
        const config = {
            type: 'bar',
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
            document.getElementById('chart_invest'),
            config
        );
    </script>
    <script>
            <?php
            $labels1 = '';
            foreach ($date as $da) {
                $labels1 .= "'" . $da . "'" . ',';
            }
            $data_total_invest_by_day = implode(",", $chart_invest_by_day);
            ?>
        const labels1 = [<?php echo $labels1; ?>];
        const data1 = {
            labels: labels1,
            datasets: [{
                label: 'Tổng tiền nạp theo ngày',
                data: [<?php echo $data_total_invest_by_day; ?>],
                borderColor: '#09bfb8',
                backgroundColor: '#09bfb8',
            },]
        };
        const config1 = {
            type: 'bar',
            data: data1,
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
            document.getElementById('chart_invest_by_day'),
            config1
        );
    </script>
    <script>
            <?php
            $labels2 = '';
            foreach ($date1 as $de) {
                $labels2 .= "'" . $de . "'" . ',';
            }
            $data_chart_payment_by_day_tong = implode(",", $chart_payment_by_day_tong);
            $data_chart_payment_by_day_goc = implode(",", $chart_payment_by_day_goc);
            $data_chart_payment_by_day_lai = implode(",", $chart_payment_by_day_lai);
            ?>
        const labels2 = [<?php echo $labels2; ?>];
        const data2 = {
            labels: labels2,
            datasets: [
                {
                    label: 'Tổng tiền trả',
                    data: [<?php echo $data_chart_payment_by_day_tong; ?>],
                    borderColor: '#29d5a7',
                    backgroundColor: '#29d5a7',
                },
                {
                    label: 'Tiền gốc trả',
                    data: [<?php echo $data_chart_payment_by_day_goc; ?>],
                    borderColor: '#ffd966',
                    backgroundColor: '#ffd966',
                },
                {
                    label: 'Tiền lãi trả',
                    data: [<?php echo $data_chart_payment_by_day_lai; ?>],
                    borderColor: '#0070a0',
                    backgroundColor: '#0070a0',
                },
            ]
        };
        const config2 = {
            type: 'bar',
            data: data2,
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
            document.getElementById('chart_payment_by_day'),
            config2
        );
    </script>
    <script>
            <?php
            $labels3 = '';
            foreach ($month1 as $m) {
                $labels3 .= "'" . $m . "'" . ',';
            }
            $data_chart_payment_tong = implode(",", $chart_payment_tong);
            $data_chart_payment_goc = implode(",", $chart_payment_goc);
            $data_chart_payment_lai = implode(",", $chart_payment_lai);
            ?>
        const labels3 = [<?php echo $labels3; ?>];
        const data3 = {
            labels: labels3,
            datasets: [
                {
                    label: 'Tổng tiền trả',
                    data: [<?php echo $data_chart_payment_tong; ?>],
                    borderColor: '#29d5a7',
                    backgroundColor: '#29d5a7',
                },
                {
                    label: 'Tiền gốc trả',
                    data: [<?php echo $data_chart_payment_goc; ?>],
                    borderColor: '#ffd966',
                    backgroundColor: '#ffd966',
                },
                {
                    label: 'Tiền lãi trả',
                    data: [<?php echo $data_chart_payment_lai; ?>],
                    borderColor: '#c98923',
                    backgroundColor: '#c98923',
                },
            ]
        };
        const config3 = {
            type: 'bar',
            data: data3,
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
            document.getElementById('chart_payment'),
            config3
        );
    </script>
@endsection

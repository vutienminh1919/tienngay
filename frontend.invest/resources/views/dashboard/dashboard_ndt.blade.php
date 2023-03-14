@extends('layout.master2')
@section('page_name','Dashboard Telesales')
@section('content')
    <div class="row mb-3">
        <div class="col-xs-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">Dashboard Telesales</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard_telesales')}}"
                                                                   class="text-info">Dashboard Telesales</a></li>
            </ol>
        </div>
    </div>
    @if(in_array(\App\Service\ActionInterface::VIEW_DASHBOARD_TELESALES, $action_global) || $is_admin == 1)
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <div class="row">
                        <div class="col-md-12 col-xs-12 text-top">
                            <h5>BÁO CÁO THÁNG</h5>
                        </div>
                        <div class="col-xs-12">
                            <div class="row">
                                <form class="submit" action="{{ route('dashboard_telesales') }}"
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
                            <div class="row">
                                <div class="col-xs-12 col-md-3">
                                    <label class="form-label text-bold">Thêm KPIs tháng<span
                                            class="text-danger">*</span> :</label>
                                    <input class="form-control" id="invest_target" type="text" name="invest_target"
                                           placeholder="Nhập KPIs tháng">
                                </div>
                                <div class="col-xs-12 col-md-3">
                                    <label class="form-label text-bold">&nbsp;</label>
                                    <button class="btn btn-info" id="add_invest_target">Thêm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <hr>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="row">
                                <div class="row col-md-12 col-xs-12 top-ip clearfix">
                                    <div class="col-12 col-md-2 col-xs-12 card_container">
                                        <div class="card_item" style="border: 1px solid #EC1E24;">
                                            <?php
                                                $from_date_data = date("d", strtotime(request()->get('from_date'))) ?? '';
                                                $to_date_data = date("d", strtotime(request()->get('to_date'))) ?? '';
                                            ?>
                                            <?php
                                                if ( (empty($from_date_data) && empty($to_date_data)) || ($from_date_data == $to_date_data)) :
                                            ?>
                                                <h5>Số tiền đầu tư trong ngày</h5>
                                            <?php
                                                else:
                                            ?>
                                                <h5>Số tiền đầu tư hàng tháng</h5>
                                            <?php
                                                endif;
                                            ?>
                                            <h2 style="color: #9B1919;"><?= !empty($dashboard_data['total_money_invest']) ? number_format($dashboard_data['total_money_invest']) : 0 ?></h2>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2 col-xs-12 card_container">
                                        <div class="card_item" style="border: 1px solid #0E9549;">
                                            <h5>Tổng NĐT kích hoạt mới</h5>
                                            <h2 style="color: #0E9549;"><?= !empty($dashboard_data['total_investor_new_active']) ? ($dashboard_data['total_investor_new_active']) : 0 ?></h2>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2 col-xs-12 card_container">
                                        <div class="card_item" style="border: 1px solid #0E9549;">
                                            <h5>Tổng NĐT kích hoạt đã đầu tư</h5>
                                            <h2 style="color: #0E9549;"><?= !empty($dashboard_data['total_investor_activated_invested']) ? ($dashboard_data['total_investor_activated_invested']) : 0 ?></h2>
                                            <p>
                                                (<?= !empty($dashboard_data['percentage_invested']) ? ($dashboard_data['percentage_invested']) : 0 ?>
                                                %)</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2 col-xs-12 card_container">
                                        <div class="card_item" style="border: 1px solid #EC1E24;">
                                            <h5>Tổng NĐT kích hoạt chưa đầu tư</h5>
                                            <h2 style="color: #9B1919;"><?= !empty($dashboard_data['total_investor_activated_not_invested_yet']) ? ($dashboard_data['total_investor_activated_not_invested_yet']) : 0 ?></h2>
                                            <p>
                                                (<?= !empty($dashboard_data['percentage_not_invested_yet']) ? ($dashboard_data['percentage_not_invested_yet']) : 0 ?>
                                                %)</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2 col-xs-12 card_container card-right" >
                                        <div class="card_item" style="border: 1px solid #0E9549;">
                                            <h5>KPIs target tháng</h5>
                                            <h2 style="color: #0E9549;"><?= !empty($dashboard_data['kpi_target_month']) ? number_format($dashboard_data['kpi_target_month']) : 0 ?></h2>
                                            <p>
                                                (<?= !empty($dashboard_data['percentage_kpi_completed']) ? ($dashboard_data['percentage_kpi_completed']) : 0 ?>
                                                %)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <script>
        $(document).ready(function () {
            $('#add_invest_target').click(function (event) {
                event.preventDefault();
                var invest_target = $("input[name='invest_target']").val();
                if (confirm("Xác nhận thêm KPIs tháng?")) {
                    $.ajax({
                        url: location.origin + '/add_kpi',
                        type: "POST",
                        data: {
                            invest_target: invest_target
                        },
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function () {
                            $('.theloading').show();
                        },
                        success: function (data) {
                            $('.theloading').hide();
                            if (data.status == 200) {
                                $('#modal-success').modal('show')
                                $('.text_message_success').text(data.message)
                                setTimeout(function () {
                                    window.location.reload();
                                }, 3000);
                            } else {
                                $('#modal-danger').modal('show')
                                $('.text_message_fail').text(data.message)
                                setTimeout(function () {
                                    window.location.reload();
                                }, 500);
                            }
                        },
                        error: function (data) {
                            $(".theloading").hide();
                            alert('Có lỗi xảy ra trong quá trình thêm dữ liệu...')
                            setTimeout(function () {
                                // window.location.reload();
                            }, 500);
                        }
                    })
                }
            });
            $('#invest_target').keyup(function (event) {
                // skip for arrow keys
                if (event.which >= 37 && event.which <= 40) return;
                // format number
                $(this).val(function (index, value) {
                    return value
                        .replace(/\D/g, "")
                        .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                });
            });

            function formatCurrency(number) {
                var n = number.split('').reverse().join("");
                var n2 = n.replace(/\d\d\d(?!$)/g, "$&,");
                return n2.split('').reverse().join('');
            }

            $('#invest_target').on('input', function (e) {
                $(this).val(formatCurrency(this.value.replace(/[.VNĐ]/g, '')));
            }).on('keypress', function (e) {
                if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
            }).on('paste', function (e) {
                var cb = e.originalEvent.clipboardData || window.clipboardData;
                if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
            });
        })
    </script>
    <style>
        .card-ip input {
            width: 100%;
            height: 32px;
            background: #FFFFFF;
            border: 1px solid #D9D9D9;
            border-radius: 5px;
            border-top: none;
            padding: 10px;
        }

        .text-top h5 {
            font-style: normal;
            font-weight: 600;
            font-size: 20px;
            line-height: 16px;
            display: flex;
            align-items: center;
            color: #0E4D20;
            padding-bottom: 10px;
        }

        .card_item {
            display: flex;
            flex-direction: column;
            /* align-items: center; */
            padding: 10px 4px;
            width: 100%;
            height: 120px;
            background: #FFFFFF;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
            border-radius: 8px;
            padding-left: 8px;
        }

        .card_item h5 {
            font-style: normal;
            font-weight: 600;
            font-size: 14px;
            line-height: 24px;
            color: #595959;

        }

        .card_item h2 {
            font-style: normal;
            font-weight: 600;
            font-size: 24px;
            line-height: 20px;
        }

        .right_wiget-bar h2 {
            color: #0E4D20;
            font-style: normal;
            font-weight: 600;
            font-size: 20px;
            line-height: 24px;
        }

        .col_text h5 {
            font-style: normal;
            font-weight: 600;
            font-size: 16px;
            line-height: 16px;
        }

        .right_wiget-bar h3 {
            font-style: normal;
            font-weight: 600;
            font-size: 20px;
            line-height: 24px;
        }


        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

    </style>
    <style>
        @media screen and (min-width: 100px) and (max-width: 599px) {
            .card_item h2 {
                font-style: normal;
                font-weight: 600;
                font-size: 16px !important;
                line-height: 20px;
            }

            .card_container {
                width: 100% !important;
            }
        }
    </style>
@endsection

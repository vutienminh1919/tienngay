@extends('viewcpanel::layouts.master')

@section('title', 'Lịch sử nhập hàng PGD Tienngay')

@section('css')
    <link href="{{ asset('viewcpanel/css/reportsKsnb/index.css') }}" rel="stylesheet"/>
    <style type="text/css">
        .alert {
            z-index: 999 !important;
        }

        /*.modal-backdrop {*/
        /*    display: none !important;*/
        /*}*/
        .main-content {
            font-family: 'Roboto';
            font-style: normal;
            color: #3B3B3B;
            line-height: 24px;
            background-color: #E5E5E5;
        }
        label.title-top, caption.title-top {
            font-size: 20px;
            font-weight: 600;
            color: #3B3B3B;
            margin-bottom: 16px;
        }
        .inline-block {
            display: inline-block;
        }
        .tbn-tab {
            font-size: 14px;
            font-weight: 600;
            color: #939393;
        }
        .tab-active {
            background-color: #95e9b8;
            font-size: 14px;
            font-weight: 600;
            color: #146c43;
            border-radius: 5px;
        }
        a {
            font-size: 12px;
            font-weight: 400;
        }
        td, td a {
            text-decoration: none;
            font-size: 14px;
            font-weight: 400;
        }
        @media (min-width: 1700px) {
            .container {
                max-width: 1600px;
            }
        }

    </style>
@endsection

@section('content')

    <section class="main-content">
        <div id="loading" class="theloading" style="display: none;">
            <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
        </div>

        <div id="top-view" class="container" style="max-width: 95% !important">
            @include("viewcpanel::heyu.store.detailByStore")
            <h4 class="tilte_top_tabs" style="color:black;margin-top: 10px">
                Lịch sử nhập đồng phục PGD {{$pgd}}
            </h4>

            <div class="row" style="align-items: right;">
                <div class="col-xs-12 col-12">
                    @include("viewcpanel::heyu.store.filterHistory")
                </div>
            </div>
            <div class="middle table_tabs">
                <div class="table-responsive" style="overflow-x: auto;">
                    <table class="table table-bordered history" style="margin-bottom: 100px">
                        <thead>
                        <tr style="text-align: center">
                            <th scope="col" rowspan="2" style="text-align: center;vertical-align: middle;
                                ;color:black">NGÀY NHẬP
                            </th>
                            <th scope="col" colspan="7" style="text-align: center; min-width: 200px;;color:black">ÁO KHOÁC</th>
                            <th scope="col" colspan="7" style="text-align: center; min-width: 200px;;color:black">ÁO PHÔNG</th>

                            <th scope="col" rowspan="2" style="text-align: center;vertical-align: middle;
                                ;color:black">NGƯỜI NHẬP
                            </th>
                        </tr>
                        <tr>
                            <th style="text-align: center">S</th>
                            <th style="text-align: center">M</th>
                            <th style="text-align: center">L</th>
                            <th style="text-align: center">XL</th>
                            <th style="text-align: center">XXL</th>
                            <th style="text-align: center">XXXL</th>
                            <th class="text-danger" style="text-align: center">TOTAL</th>
                            <th style="text-align: center">S</th>
                            <th style="text-align: center">M</th>
                            <th style="text-align: center">L</th>
                            <th style="text-align: center">XL</th>
                            <th style="text-align: center">XXL</th>
                            <th style="text-align: center">XXXL</th>
                            <th class="text-danger" style="text-align: center">TOTAL</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($history))
                            @for($i = count($history) -1; $i >= 0; $i--)
                                @if($history[$i]['action'] == 'Chỉnh sửa')
                                    @continue;
                                @else
                                    <tr>
                                        <td>{{date('d-m-Y', $history[$i]['created_at']) ?? ""}}</td>
                                        <td class="coat-s">{{$history[$i]['data']['coat']['s'] ?? 0}}</td>
                                        <td class="coat-m">{{$history[$i]['data']['coat']['m'] ?? 0}}</td>
                                        <td class="coat-l">{{$history[$i]['data']['coat']['l'] ?? 0}}</td>
                                        <td class="coat-xl">{{$history[$i]['data']['coat']['xl'] ?? 0}}</td>
                                        <td class="coat-xxl">{{$history[$i]['data']['coat']['xxl'] ?? 0}}</td>
                                        <td class="coat-xxxl">{{$history[$i]['data']['coat']['xxxl'] ?? 0}}</td>
                                        <td class="coat-total">{{$history[$i]['data']['total_coat'] ?? 0}}</td>
                                        <td class="shirt-s">{{$history[$i]['data']['shirt']['s'] ?? 0}}</td>
                                        <td class="shirt-m">{{$history[$i]['data']['shirt']['m'] ?? 0}}</td>
                                        <td class="shirt-l">{{$history[$i]['data']['shirt']['l'] ?? 0}}</td>
                                        <td class="shirt-xl">{{$history[$i]['data']['shirt']['xl'] ?? 0}}</td>
                                        <td class="shirt-xxl">{{$history[$i]['data']['shirt']['xxl'] ?? 0}}</td>
                                        <td class="shirt-xxxl">{{$history[$i]['data']['shirt']['xxxl'] ?? 0}}</td>
                                        <td class="shirt-total">{{$history[$i]['data']['total_shirt'] ?? 0}}</td>
                                        <td>{{$history[$i]['created_by'] ?? ""}}</td>
                                    </tr>
                                @endif
                            @endfor
                            <tr class="total table-primary">

                            </tr>
                        @endif
                        </tbody>
                    </table>

                    <div>
                        @include('viewcpanel::heyu.excel.history')
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal import nhân sự nghỉ việc -->
        <div class="modal fade" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div>
                            <h4 class="text-primary ten_oto" style="text-align: left">
                                Chi tiết số lượng và kích cỡ các loại áo
                            </h4>
                        </div>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="errorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Thất bại</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="msg_error text-danger"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="successModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Thành công</h5>
                    </div>
                    <div class="modal-body">
                        <p class="msg_success text-success"></p>
                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        $(".export").click(function () {
            console.log('1')
            $(".export_table").table2excel({
                name: "Worksheet Name",
                filename: "HistoryExportHeyu", // do include extension
                preserveColors: true // set to true if you want background colors and font colors preserved
            });

        });

        $(window).on('load', function () {
            let total_coat_s = 0;
            let total_coat_m = 0;
            let total_coat_l = 0;
            let total_coat_xl = 0;
            let total_coat_xxl = 0;
            let total_coat_xxxl = 0;
            let total_coat = 0;
            let total_shirt_s = 0;
            let total_shirt_m = 0;
            let total_shirt_l = 0;
            let total_shirt_xl = 0;
            let total_shirt_xxl = 0;
            let total_shirt_xxxl = 0;
            let total_shirt = 0;
            $(".coat-s").each(function (key, value) {
                total_coat_s += Number($(value).text())
            });
            $(".coat-m").each(function (key, value) {
                total_coat_m += Number($(value).text())
            })
            ;$(".coat-l").each(function (key, value) {
                total_coat_l += Number($(value).text())
            });
            $(".coat-xl").each(function (key, value) {
                total_coat_xl += Number($(value).text())
            });
            $(".coat-xxl").each(function (key, value) {
                total_coat_xxl += Number($(value).text())
            });
            $(".coat-xxxl").each(function (key, value) {
                total_coat_xxxl += Number($(value).text())
            });
            $(".coat-total").each(function (key, value) {
                total_coat += Number($(value).text())
            });

            $(".shirt-s").each(function (key, value) {
                total_shirt_s += Number($(value).text())
            });
            $(".shirt-m").each(function (key, value) {
                total_shirt_m += Number($(value).text())
            })
            ;$(".shirt-l").each(function (key, value) {
                total_shirt_l += Number($(value).text())
            });
            $(".shirt-xl").each(function (key, value) {
                total_shirt_xl += Number($(value).text())
            });
            $(".shirt-xxl").each(function (key, value) {
                total_shirt_xxl += Number($(value).text())
            });
            $(".shirt-xxxl").each(function (key, value) {
                total_shirt_xxxl += Number($(value).text())
            });
            $(".shirt-total").each(function (key, value) {
                total_shirt += Number($(value).text())
            });

            $('.total').append("<td>TỔNG</td> <td>"+total_coat_s+"</td> <td>"+total_coat_m+"</td> <td>"+total_coat_l+"</td> <td>"+total_coat_xl+"</td> <td>"+total_coat_xxl+"</td> <td>"+total_coat_xxxl+"</td> <td>"+total_coat+"</td> <td>"+total_shirt_s+"</td> <td>"+total_shirt_m+"</td> <td>"+total_shirt_l+"</td> <td>"+total_shirt_xl+"</td> <td>"+total_shirt_xxl+"</td> <td>"+total_shirt_xxxl+"</td> <td>"+total_shirt+"</td><td></td>")
        });

        var dp = $("#start-date, #end-date").datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
        const element = document.getElementById("top-view");
        element.scrollIntoView();
        $("#fillter-button").on("click", function (event) {
            event.stopPropagation();
            $("#fillter-content").toggle();
        })
        $("#clear-search-form").on("click", function (event) {
            event.preventDefault();
            document.getElementById("search-form").reset();
        });
        $("#close-search-form").on("click", function (event) {
            event.preventDefault();
            $("#fillter-content").hide();
        });
        $('body').on('click', function (e) {
            if (e.target.id == "fillter-content" || $(e.target).parents("#fillter-content").length) {
                //do nothing
            } else {
                $("#fillter-content").hide();
            }
        });

    </script>

@endsection

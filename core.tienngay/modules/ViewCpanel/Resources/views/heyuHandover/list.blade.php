@extends('viewcpanel::layouts.master')

@section('title', 'Danh Sách Đồng Phục Đã Cấp Phát')

@section('css')
    <link href="{{ asset('viewcpanel/css/reportsKsnb/index.css') }}" rel="stylesheet"/>
    <style type="text/css">
        .alert {
            z-index: 999 !important;
        }

        .modal-backdrop {
            display: none !important;
        }

        #fillter-content {
            right: 96px !important;
        }
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
    <section class="main-content" style="padding-bottom: 50px">
        <div id="loading" class="theloading" style="display: none;">
            <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
        </div>
        <div id="top-view" class="container">
            <div class="header">
                <div class="form-group row">
                    <div class="col-sm-8">
                        <label class="title-top">Quản lý cấp phát đồng phục HeyU</label>
                    </div>
                    <div class="col-sm-4" style="text-align: right;">
                        <a class="btn btn-success update"
                           href="{{url('/cpanel/heyu/update')}}" <?= $showStore ? "" : "hidden" ?>
                           style="
                                font-size: 12px;
                                font-weight: 400;
                            "
                           type="button">
                            Nhập kho&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"></i>
                        </a>
                        <a class="btn export" style="background: #997404;color: #FFFFFF; margin-left: 10px;font-size: 12px;font-weight: 400;" <?= $showHandover ? "" : "hidden" ?>
                           type="button">
                            Xuất kho&nbsp;&nbsp;<i class="fa fa-minus" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
            @include("viewcpanel::heyu.store.detailByStore")
            <div class="form-group" style="align-items: left; margin: 10px 10px;">
                <a class="btn inline-block tbn-tab tab-active" style="pointer-events: none;"
                   href="{{$cpanelURL.route('viewcpanel::heyu.handover.index')}}"
                   type="button">
                    Danh sách cấp phát
                </a>
                <a class="btn inline-block tbn-tab storage"
{{--                   target="_blank"--}}
{{--                   href="{{$cpanelURL.route('viewcpanel::heyu.handover.index')}}"--}}
                   type="button">
                    Kho đồng phục
                </a>
                <a target="_blank" class="btn inline-block searchDriver tbn-tab" type="button"
                   href="{{$cpanelURL.route('viewcpanel::heyu.searchDriver')}}">
                    Tra cứu đồng phục tài xế HeyU
                </a>
            </div>
            <div class="middle table_tabs">
                <p style="color: #047734"><strong>Tổng bản ghi:</strong>&nbsp;<span class="text-danger" id="total">{{$records->total()}}</span>
                </p>
                <div class="table-responsive" style="overflow-x: auto;padding: 0;">
                    <table class="table caption-top" style="margin-bottom: 30px">
                        <caption>
                            <label class="title-top inline-block" style="width: calc(100% - 170px); padding: 0 25px;">Danh sách cấp phát</label>
                            <a class="btn inline-block excel_handover"
                               href="#"
                               style="
                                    border: solid 1px #146c43;
                                    color: #146c43;
                                    font-size: 12px;
                                    font-weight: 600;
                                    margin-right: 10px;
                                "
                               type="button">
                                Xuất excel&nbsp;&nbsp;<i class="fa fa-file-excel-o" aria-hidden="true"></i>
                            </a>
                            @include("viewcpanel::heyuHandover.filter")
                        </caption>
                        <thead>
                        <tr style="text-align: center">
                            <th scope="col" style="text-align: center;color:black;max-width: 50px;">STT</th>
                            <th class="function" scope="col" style="text-align: center; max-width: 70px;color:black;">CHỨC NĂNG</th>
                            <th scope="col" style="text-align: center; max-width: 70px;color:black">MÃ TÀI XẾ</th>
                            <th scope="col" style="text-align: center;color:black">TÊN TÀI XẾ</th>
                            <th scope="col" style="text-align: center; max-width: 70px;color:black">SIZE ÁO KHOÁC</th>
                            <th scope="col" style="text-align: center; max-width: 70px;color:black">SIZE ÁO PHÔNG</th>
                            <th scope="col" style="text-align: center; max-width: 100px;;color:black">NGÀY GIAO ĐỒNG
                                PHỤC
                            </th>
                            <th scope="col" style="text-align: center;;color:black">NGƯỜI TẠO</th>
                            <th scope="col" style="text-align: center; max-width: 100px;color:black">NGÀY TẠO</th>
                            <th scope="col" style="text-align: center; max-width: 50px;color:black">TRẠNG THÁI</th>
                            <th scope="col" style="text-align: center; color:black">NGƯỜI DUYỆT</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            @if(isset($records))
                                @foreach ($records as $key => $record)
                                    <td style="text-align: center" scope="row">{{$perPage + ++$key}}</td>
                                    <td class="more funtion_detail" style="text-align: center">
                                        <div class="btn-group" style="text-align: center">
                                            <button type="button" class="btn btn-success"
                                                    style="font-style: 14px; border-radius: 5px"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                    class="fa fa-bars" aria-hidden="true" style="font-style: 14px"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" target='_blank'
                                                       href='{{$detailPath.$record->_id}}'>Chi
                                                        tiết</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td style="text-align: center">{{$record->driver_code ?? ""}}</td>
                                    <td style="text-align: center">{{$record->driver_name ?? ""}}</td>
                                    @foreach($record['coat'] as $key => $value)
                                        @if ($value > 0)
                                            <td style="text-align: center">{{strtoupper($key)}}</td>
                                            @break
                                        @endif
                                    @endforeach

                                    @foreach($record['shirt'] as $key => $value)
                                        @if ($value > 0)
                                            <td style="text-align: center">{{strtoupper($key)}}</td>
                                            @break
                                        @endif
                                    @endforeach
                                    <td style="text-align: center">{{date('d-m-Y', $record->delivery_date) ?? ""}}</td>
                                    <td style="text-align: center">{{$record->created_by}}</td>
                                    <td style="min-width: 160px;text-align: center">{{date('d-m-Y', $record->created_at) ?? ""}}</td>
                                    @if($record->status == 1)
                                        <td style="min-width: 160px;text-align: center;color:#997404">Chờ duyệt</td>
                                    @elseif($record->status == 2)
                                        <td style="min-width: 160px;text-align: center;color:#1D9752">Đã duyệt</td>
                                    @else
                                        <td style="min-width: 160px;text-align: center">Đã hủy</td>
                                    @endif
                                    <td class="more1" style="text-align: center">{{$record->approved_by ?? ""}}</td>
                        </tr>
                        @endforeach
                        @endif
                        </tbody>
                    </table>
                    <div>
                        @include('viewcpanel::heyu.excel.handover')
                    </div>
                </div>
            </div>
            @if(!empty($records))
                <nav aria-label="Page navigation" style="margin-top: 20px;">
                    {{$records->withQueryString()->links()}}
                </nav>
            @endif
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        $(".export").on('click', function (e) {
            e.preventDefault();
            console.log('1')
            window.parent.postMessage({targetLink: "{{$exportPath}}"}, "{{$cpanelPath}}");
        })
        $(".storage").on('click', function (e) {
            e.preventDefault();
            console.log('1')
            window.parent.postMessage({targetLink: "{{$storagePath}}"}, "{{$cpanelPath}}");
        })

        $(".excel_handover").click(function () {
            console.log('1')
            $(".handover_table").table2excel({
                exclude: ".function, .funtion_detail",
                name: "Worksheet Name",
                filename: "HandoverHeyu.xls", // do include extension
                preserveColors: false // set to true if you want background colors and font colors preserved
            });

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
            $("option:selected").removeAttr("selected");
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
        var dp = $("#start-date, #end-date").datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });

        $(".dropdown-item").on('click', function(e) {
            e.preventDefault();
            let targetLink = $(e.target).attr('href');
            window.parent.postMessage({targetLink: targetLink}, "{{$cpanelPath}}");
          });

    </script>


    <script type="text/javascript">
        var dataSearch = JSON.parse('{!! json_encode($dataSearch) !!}');
        console.log(dataSearch);
        for (const property in dataSearch) {
            if (dataSearch[property] == null || property == "store") {
                continue;
            }
            console.log(property, ' ', dataSearch[property]);
            $('#search-form').find("[name='" + property + "']").val(dataSearch[property]);
        }
    </script>
@endsection


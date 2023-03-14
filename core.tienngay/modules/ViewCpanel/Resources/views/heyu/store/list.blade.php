@extends('viewcpanel::layouts.master')

@section('title', 'Kho hàng đồng phục HEYU')

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
                        <a class="btn export" style="background: #997404;color: #FFFFFF; margin-left: 10px;font-size: 12px;font-weight: 400;" href="" <?= $showHandover ? "" : "hidden" ?>
                           type="button">
                            Xuất kho&nbsp;&nbsp;<i class="fa fa-minus" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
            @include("viewcpanel::heyu.store.detailByStore")
            <div class="form-group" style="align-items: left; margin: 10px 10px;">
                <a class="btn inline-block tbn-tab handover"
{{--                   target="_blank"--}}
{{--                   href="{{$cpanelURL.route('viewcpanel::heyu.handover.index')}}"--}}
                   type="button">
                    Danh sách cấp phát
                </a>
                <a class="btn inline-block tbn-tab tab-active" style="pointer-events: none;"
                   href="{{$cpanelURL.route('viewcpanel::heyu.index')}}"
                   type="button">
                    Kho đồng phục
                </a>
                <a target="_blank" class="btn inline-block searchDriver tbn-tab" type="button"
                   href="{{$cpanelURL.route('viewcpanel::heyu.searchDriver')}}">
                    Tra cứu đồng phục tài xế HeyU
                </a>
            </div>
            <div class="middle table_tabs">
                <p style="color: #047734"><strong>Tổng bản ghi:</strong>&nbsp;<span class="text-danger" id="total">{{$total}}</span>
                </p>
                <div class="table-responsive" style="overflow-x: auto; padding: 0;">
                    <table class="table caption-top" style="margin-bottom: 30px">
                        <caption>
                            <label class="title-top inline-block" style="width: calc(100% - 170px); padding: 0 25px;">Kho đồng phục</label>
                            <a class="btn inline-block export_excel_list"
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
                            @include("viewcpanel::heyu.store.filter")
                        </caption>
                        <thead style="background-color: #E8F4ED">
                        <tr style="text-align: center">
                            <th scope="col" rowspan="2" style="text-align: center;vertical-align: middle;color:black">STT
                            </th>
                            <th scope="col" rowspan="2" style="text-align: center;vertical-align: middle; min-width: 200px;color:black">Phòng giao dịch
                            </th>
                            <th scope="col" colspan="7" style="text-align: center; min-width: 200px;color:black">Áo khoác
                            </th>
                            <th scope="col" colspan="7" style="text-align: center; min-width: 200px;;color:black">Áo phông
                            </th>
                            <th scope="col" rowspan="2" style="text-align: center;vertical-align: middle;;color:black">
                                Chức năng
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
                        @if(isset($records))
                            @foreach ($records as $key => $record)
                                <tr>
                                    <td rowspan="2" style="text-align: center;vertical-align: middle;"
                                        scope="row">{{++$key}}</td>
                                    <td style="text-align: center;vertical-align: middle;"><a
                                            style="color:#1D9752" target="_blank"
                                            href="{{$cpanelURL.route("viewcpanel::heyu.history" , ["id" => $record['vfc']["_id"]])}}">{{$record['vfc']['store']['name']}}</a>
                                    </td>
                                    <td <?= ($record['vfc']['detail']['coat']['s'] == ((!empty($record['heyu']['detail']['coat']['s'])) ? $record['heyu']['detail']['coat']['s'] : 0 )) ? "" : 'class="text-danger"' ?> style="text-align: center;vertical-align: middle;">{{$record['vfc']['detail']['coat']['s']}}</td>
                                    <td <?= ($record['vfc']['detail']['coat']['m'] == ((!empty($record['heyu']['detail']['coat']['m'])) ? $record['heyu']['detail']['coat']['m'] : 0 )) ? "" : 'class="text-danger"' ?> style="text-align: center;vertical-align: middle;">{{$record['vfc']['detail']['coat']['m']}}</td>
                                    <td <?= ($record['vfc']['detail']['coat']['l'] == ((!empty($record['heyu']['detail']['coat']['l'])) ? $record['heyu']['detail']['coat']['l'] : 0 )) ? "" : 'class="text-danger"' ?> style="text-align: center;vertical-align: middle;">{{$record['vfc']['detail']['coat']['l']}}</td>
                                    <td <?= ($record['vfc']['detail']['coat']['xl'] == ((!empty($record['heyu']['detail']['coat']['xl'])) ? $record['heyu']['detail']['coat']['xl'] : 0 )) ? "" : 'class="text-danger"' ?> style="text-align: center;vertical-align: middle;">{{$record['vfc']['detail']['coat']['xl']}}</td>
                                    <td <?= ($record['vfc']['detail']['coat']['xxl'] == ((!empty($record['heyu']['detail']['coat']['xxl'])) ? $record['heyu']['detail']['coat']['xxl'] : 0 )) ? "" : 'class="text-danger"' ?> style="text-align: center;vertical-align: middle;">{{$record['vfc']['detail']['coat']['xxl']}}</td>
                                    <td <?= ($record['vfc']['detail']['coat']['xxxl'] == ((!empty($record['heyu']['detail']['coat']['xxxl'])) ? $record['heyu']['detail']['coat']['xxxl'] : 0 )) ? "" : 'class="text-danger"' ?> style="text-align: center;vertical-align: middle;">{{$record['vfc']['detail']['coat']['xxxl']}}</td>
                                    <td <?= ($record['vfc']['total_coat'] == ((!empty($record['heyu']['totalCoat'])) ? $record['heyu']['totalCoat'] : 0 )) ? "" : 'class="text-danger"' ?> style="text-align: center;vertical-align: middle;">{{$record['vfc']['total_coat']}}</td>
                                    <td <?= ($record['vfc']['detail']['shirt']['s'] == ((!empty($record['heyu']['detail']['shirt']['s'])) ? $record['heyu']['detail']['shirt']['s'] : 0 )) ? "" : 'class="text-danger"' ?> style="text-align: center;vertical-align: middle;">{{$record['vfc']['detail']['shirt']['s']}}</td>
                                    <td <?= ($record['vfc']['detail']['shirt']['m'] == ((!empty($record['heyu']['detail']['shirt']['m'])) ? $record['heyu']['detail']['shirt']['m'] : 0 )) ? "" : 'class="text-danger"' ?> style="text-align: center;vertical-align: middle;">{{$record['vfc']['detail']['shirt']['m']}}</td>
                                    <td <?= ($record['vfc']['detail']['shirt']['l'] == ((!empty($record['heyu']['detail']['shirt']['l'])) ? $record['heyu']['detail']['shirt']['l'] : 0 )) ? "" : 'class="text-danger"' ?> style="text-align: center;vertical-align: middle;">{{$record['vfc']['detail']['shirt']['l']}}</td>
                                    <td <?= ($record['vfc']['detail']['shirt']['xl'] == ((!empty($record['heyu']['detail']['shirt']['xl'])) ? $record['heyu']['detail']['shirt']['xl'] : 0 )) ? "" : 'class="text-danger"' ?> style="text-align: center;vertical-align: middle;">{{$record['vfc']['detail']['shirt']['xl']}}</td>
                                    <td <?= ($record['vfc']['detail']['shirt']['xxl'] == ((!empty($record['heyu']['detail']['shirt']['xxl'])) ? $record['heyu']['detail']['shirt']['xxl'] : 0 )) ? "" : 'class="text-danger"' ?> style="text-align: center;vertical-align: middle;">{{$record['vfc']['detail']['shirt']['xxl']}}</td>
                                    <td <?= ($record['vfc']['detail']['shirt']['xxxl'] == ((!empty($record['heyu']['detail']['shirt']['xxxl'])) ? $record['heyu']['detail']['shirt']['xxxl'] : 0 )) ? "" : 'class="text-danger"' ?> style="text-align: center;vertical-align: middle;">{{$record['vfc']['detail']['shirt']['xxxl']}}</td>
                                    <td <?= ($record['vfc']['total_shirt'] == ((!empty($record['heyu']['totalShirt'])) ? $record['heyu']['totalShirt'] : 0 )) ? "" : 'class="text-danger"' ?> style="text-align: center;vertical-align: middle;">{{$record['vfc']['total_shirt']}}</td>
                                    <td class="more" rowspan="2" style="text-align: center;vertical-align: middle;">
                                        <div class="btn-group" style="text-align: center">
                                            <button type="button" class="btn btn-success" <?= $showEdit ? "" : 'disabled' ?>
                                                    style="font-style: 14px; border-radius: 5px"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-bars" aria-hidden="true"
                                                   style="font-style: 14px"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item editStore" target="=_blank"
                                                       href='{{$cpanelURL.route("viewcpanel::heyu.edit" , ["id" => $record['vfc']["_id"]])}}'
                                                    >Chỉnh sửa</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;vertical-align: middle;color: #4299E1;">HeyU</td>
                                    <td style="text-align: center;vertical-align: middle;color: #4299E1;">{{$record['heyu']['detail']['coat']['s'] ?? 0}}</td>
                                    <td style="text-align: center;vertical-align: middle;color: #4299E1;">{{$record['heyu']['detail']['coat']['m'] ?? 0}}</td>
                                    <td style="text-align: center;vertical-align: middle;color: #4299E1;">{{$record['heyu']['detail']['coat']['l'] ?? 0}}</td>
                                    <td style="text-align: center;vertical-align: middle;color: #4299E1;">{{$record['heyu']['detail']['coat']['xl'] ?? 0}}</td>
                                    <td style="text-align: center;vertical-align: middle;color: #4299E1;">{{$record['heyu']['detail']['coat']['xxl'] ?? 0}}</td>
                                    <td style="text-align: center;vertical-align: middle;color: #4299E1;">{{$record['heyu']['detail']['coat']['xxxl'] ?? 0}}</td>
                                    <td style="text-align: center;vertical-align: middle;color: #4299E1;">{{$record['heyu']['totalCoat'] ?? 0}}</td>
                                    <td style="text-align: center;vertical-align: middle;color: #4299E1;">{{$record['heyu']['detail']['shirt']['s'] ?? 0}}</td>
                                    <td style="text-align: center;vertical-align: middle;color: #4299E1;">{{$record['heyu']['detail']['shirt']['m'] ?? 0}}</td>
                                    <td style="text-align: center;vertical-align: middle;color: #4299E1;">{{$record['heyu']['detail']['shirt']['l'] ?? 0}}</td>
                                    <td style="text-align: center;vertical-align: middle;color: #4299E1;">{{$record['heyu']['detail']['shirt']['xl'] ?? 0}}</td>
                                    <td style="text-align: center;vertical-align: middle;color: #4299E1;">{{$record['heyu']['detail']['shirt']['xxl'] ?? 0}}</td>
                                    <td style="text-align: center;vertical-align: middle;color: #4299E1;">{{$record['heyu']['detail']['shirt']['xxxl'] ?? 0}}</td>
                                    <td style="text-align: center;vertical-align: middle;color: #4299E1;">{{$record['heyu']['totalShirt'] ?? 0}}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
                        @if(!empty($records))
                            <nav aria-label="Page navigation" style="margin-top: 20px;">
                                {{$records->withQueryString()->links()}}
                            </nav>
                        @endif
        </div>

       <div>
           @include('viewcpanel::heyu.excel.list')
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
        $(".export_excel_list").on('click', function (e) {
            console.log('1')
            $(".excel_table_list_clone").table2excel({
                name: "Worksheet Name",
                filename: "ListStoreHeyu", // do include extension
                preserveColors: true // set to true if you want background colors and font colors preserved
            });
        });

        $(".export").on('click', function (e) {
            e.preventDefault();
            console.log('1')
            window.parent.postMessage({targetLink: "{{$exportPath}}"}, "{{$cpanelPath}}");
        })
        $(".handover").on('click', function (e) {
            e.preventDefault();
            console.log('1')
            window.parent.postMessage({targetLink: "{{$handoverPath}}"}, "{{$cpanelPath}}");
        })

        $('.update').on('mousedown', function (e) {
            if (e.which == 2) {
                e.preventDefault();
                return false;
            }
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


    <script type="text/javascript">
        $('.detail').click(function (event) {
            event.preventDefault();
            let id = $(this).attr('data-id');
            let formData = new FormData();
            formData.append('id', id)
            $.ajax({
                url: '{{$detailUrl}}',
                type: "POST",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $(".theloading").show();
                    $('.modal-body').html('');
                },
                success: function (data) {
                    $(".theloading").hide();
                    if (data.status == 200) {
                        console.log(data.data)
                        $('.modal-body').append(' <table class="table"> <tr> <td></td> <td>size s</td> <td>size m</td> <td>size l</td> <td>size xl</td> <td>size xxl</td> <td>size xxxl</td></tr> <tr> <td>COAT</td> <td>' + data.data.detail.coat.s + '</td> <td>' + data.data.detail.coat.m + '</td> <td>' + data.data.detail.coat.l + '</td> <td>' + data.data.detail.coat.xl + '</td> <td>' + data.data.detail.coat.xxl + '</td> <td>' + data.data.detail.coat.xxl + '</td> </tr> <tr> <td>SHIRT</td> <td>' + data.data.detail.shirt.s + '</td> <td>' + data.data.detail.shirt.m + '</td> <td>' + data.data.detail.shirt.l + '</td> <td>' + data.data.detail.shirt.xl + '</td> <td>' + data.data.detail.shirt.xxl + '</td> <td>' + data.data.detail.shirt.xxxl + '</td></tr> </table>')
                    } else {
                        $('#errorModal').modal('show')
                        $('.msg_error').text(data.message)
                    }
                },
                error: function () {
                    $(".theloading").hide();
                    $('#modal-danger').modal('show')
                    $('.msg_error').text("error")
                }
            });
        });
    </script>
    <script type="text/javascript" src="{{ asset('viewcpanel/js/xlsx.js') }}"></script>

@endsection

<?php $nameSearch = !empty($_GET['name']) ? $_GET['name'] : "" ?>

@extends('viewcpanel::layouts.master')
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/css/bootstrap-multiselect.css" rel="stylesheet"/>
      <link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.14.0/css/selectize.bootstrap5.css" rel="stylesheet"/>

@endsection
<style>
    body{
        background-color: rgb(237, 237, 237) !important;
    }
    .theloading {
        position: fixed;
        z-index: 999;
        display: block;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, .7);
        top: 0;
        right: 0;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .wrapper {
        width: 100%;
        background-color: rgb(237, 237, 237);
    }

    .form-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-title h3 {
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 24px;
        color: #3B3B3B;
    }

    .header-title a {
        font-style: normal;
        font-weight: 400;
        font-size: 12px;
        line-height: 14px;
        color: #676767;
        text-decoration: none;
    }

    .form-body {
        /* width: 100%; */
        background: #FFFFFF;
        /* background: linear-gradient(90deg, #015aad, #00b74f); */
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
        border-radius: 8px;
        position: relative;
        padding-bottom: 5%;
        margin-top: 34px;
    }


    .body-title {
        display: flex;
        justify-content: space-between;
        padding: 16px 0px;
        margin-right: 16px;
    }

    .body-title h3 {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: #3B3B3B;
        padding-left: 16px;
    }

    .table th {
        font-weight: 600;
        font-size: 14px;
        line-height: 16px;
        color: #262626;
        text-align: center;
        vertical-align: baseline;
    }

    .table td {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #676767;
        vertical-align: middle;
        text-align: center;
        width: 150px !important;
    }

    .body-navigate {
        display: flex;
        justify-content: flex-end;
        position: absolute;
        bottom: 0;
        right: 5;
    }

    .form-modal {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .form-input {
        display: flex;
        flex-direction: column;
        gap: 8px;

    }

    .form-input label {
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        display: flex;
        align-items: center;
        color: #3B3B3B;

    }

    .form-input input {
        width: 100%;
        height: 40px;
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        outline: none;
        padding-left: 10px;
    }

    .form-input select {
        width: 100%;
        height: 40px;
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        outline: none;
        padding-left: 10px;
    }

    .nav {
        display: flex;
        flex-direction: column;
    }

    .nav > li {
        text-decoration: none;
    }

    .body-btn {
        display: flex;
        gap: 10px;
    }

    .table thead tr th {
        border: 1px;
    }

    .swal2-confirm {
        width: 200px;
    }

    .swal2-cancel {
        width: 200px;
        color: #676767 !important;
    }

    .swal2-modal {
        top: 35% !important;
    }
    .dropdown-menu a {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #676767;
    }

    .btn{
        display: flex !important;
        align-items: center !important;
        font-size: 14px !important;
        height: 32px;
    }

    .btn-success{
        background-color: #1D9752 !important;
    }

    @media screen and (max-width: 48em) {
        .form-body {
            background: #FFFFFF;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
            border-radius: 8px;
            position: relative;
            padding-bottom: 15%;
            margin-top: 34px;
        }
    }
</style>
<div class="wrapper" style="padding: 16px;">
    <div id="loading" class="theloading" style="display: none;">
        <i class="fa fa-cog fa-spin fa-3x fa-fw" style="margin-bottom: 800px"></i>
    </div>
    <div class="form-header" style="padding: 10px 16px ;">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="header-title row">
            <h3 class="col-md-12 col-sm-12 col-xs-12">Quản lý danh mục ấn phẩm</h3>
        </div>
        <div class="header-btn">
            <button type="button" class="btn btn-success create">Thêm mới <i style="padding-left: 5px;" class="fa fa-plus" aria-hidden="true"></i></button>
        </div>
    </div>
    <div class="form-body">
        <div class="body-title">
            <h3>Danh sách ấn phẩm </h3>
            <div class="body-btn">
                <button type="button" onclick="export_item('xlsx', 'danh_sach_an_pham_trade')"
                        class="btn btn-outline-success">Xuất excel <img
                            src="https://service.tienngay.vn/uploads/avatar/1669364070-d7a257cd601ea15a96b19fb403608675.png" style="padding-left: 5px;"
                            alt=""></button>
                <div class="row" style="align-items: right;">
                    <div class="col-xs-12 col-12">
                        @include("viewcpanel::trade.item.filter")
                    </div>
                </div>
            </div>
        </div>
        <div class="table-body ">
            <div class="table-responsive">
                <table class="table table-hover total_table"
                       style="text-align: center; vertical-align: middle;word-wrap: break-word;">
                    <thead style="background-color: #E8F4ED">
                    <tr style="white-space: nowrap; height: 40px; vertical-align: middle;">  
                        <th style="vertical-align: middle;" scope="col">STT</th>
                        <th style="vertical-align: middle;" scope="col">Mã ấn phẩm</th>
                        <th style="vertical-align: middle;" scope="col">Tên loại ấn phẩm</th>
                        <th style="vertical-align: middle;" scope="col">Loại ấn phẩm</th>
                        <th style="vertical-align: middle;" scope="col">Quy cách</th>
                        <th style="vertical-align: middle;" scope="col">Hạng mục</th>
                        <th style="vertical-align: middle;" scope="col">Mục tiêu triển khai</th>
                        <th style="vertical-align: middle;" scope="col">Mục tiêu thúc đẩy</th>
                        <th style="vertical-align: middle;" scope="col">Ngày hết hạn</th>
                        <th style="vertical-align: middle;" scope="col">Đơn giá dự kiến</th>
                        <th style="vertical-align: middle;" scope="col">Khu vực áp dụng</th>
                        <th style="vertical-align: middle;" scope="col">Chức năng</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($listItem) && count($listItem) > 0)
                        @foreach($listItem as $key => $item)
                            <tr style="white-space: nowrap;">
                                <td>{{++$key}}</td>
                                <td>{{$item['item_id']}}</td>
                                <td>{{$item['detail']['name']}}</td>
                                <td>{{$item['detail']['type']}}</td>
                                <td>{{str_replace(",", ", ",$item['detail']['specification'])}}</td>
                                <td>{{$item['category']}}</td>
                                <td>{{$item['target_goal']}}</td>
                                <td>{{is_array($item['motivating_goal']) ? implode(', ', $item['motivating_goal']) : $item['motivating_goal']}}</td>
                                <td>{{!empty($item['date']) ? date('d/m/Y', $item['date']) : ""}}</td>
                                <td>{{number_format($item['detail']['price'])}}</td>
                                <td>
                                    <a type="button" class="list_store" style="border: none;color:#4299E1;text-decoration: none"
                                            data-bs-toggle="modal" data-store="{{json_encode($item['store'])}}"
                                            data-name="{{$item['item_id']}}" data-bs-target="#exampleModal1">Khu vực áp dụng
                                    </a>
                                </td>
                                <td>
                                    <div class="dropdown-center">
                                        <button class="btn" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                            <img
                                                    src="https://service.tienngay.vn/uploads/avatar/1669274405-d140100df2f4852a97aab1ae7a0fe508.png"
                                                    alt="">
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item detail" href="{{route('viewcpanel::trade.detailItem', ['id' => $item['_id']])}}">Chi
                                                    tiết</a></li>
                                            <li><a class="dropdown-item update" href="{{route('viewcpanel::trade.editItem', ['id' => $item['_id']])}}">Chỉnh
                                                    sửa</a></li>
                                            <li><a class="dropdown-item block_item" data-id="{{$item['_id']}}">Xóa</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="12" class="text-danger" style="text-align: center">
                                Không có dữ liệu ( Không có kết quả nào được tìm thấy ! )
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            @if(!empty($listItem))
                <nav aria-label="Page navigation" style="margin-top: 20px;">
                    {{$listItem->withQueryString()->render('viewcpanel::trade.paginate')}}
                </nav>
            @endif
            @include('viewcpanel::trade.item.export_list')
        </div>
    </div>

    <!-- Modal khu vuc ap dung-->
    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title item_header"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="max-height: 500px">
                    <ul class="nav">

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/js/bootstrap-multiselect.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.14.0/js/selectize.min.js"></script>
    <script type="text/javascript">
        const iframeMode = "<?= (!empty($_GET['iframe']) && $_GET['iframe'] == 1) ?>";
        console.log(iframeMode)
        const Redirect = (_url, _timeout) => {
            if (parseInt(iframeMode) != 1) {
                if (!_timeout) {
                    window.location.href = _url;
                    // window.parent.postMessage({targetLink: _url}, "{{$cpanelPath}}");
                } else {
                    setTimeout(function(){window.location.href = _url}, _timeout);
                    // setTimeout(function () {window.parent.postMessage({targetLink: _url}, "{{$cpanelPath}}");}, _timeout);
                }
            } else {
                _url = _url.replace(window.location.origin + '/', "");
                if (!_timeout) {
                    // window.location.href = _url;
                    window.parent.postMessage({targetLink: _url}, "{{$cpanelPath}}");
                } else {
                    // setTimeout(function(){window.location.href = _url}, _timeout);
                    setTimeout(function () {window.parent.postMessage({targetLink: _url}, "{{$cpanelPath}}");}, _timeout);
                }
            }
        }
    </script>
    <script type="text/javascript">
        var selectName = '';
        var selectStore = '';

        $('.motivating_goal').multiselect({
                enableClickableOptGroups: true,
                // includeSelectAllOption: true,
                buttonWidth: '100%',
                dropRight: true,
                maxHeight: 500,
                // selectAllText: 'Chọn tất cả',
                nSelectedText: 'Mục tiêu thúc đẩy',
                allSelectedText: 'Đăng ký xe máy, Đăng ký ô tô, Khác',
                nonSelectedText: 'Chọn mục tiêu thúc đẩy',
                templates: {
                    button: '<button style="height: 32px;background: #FFFFFF;border: 1px solid #D8D8D8;border-radius: 5px;outline: none;padding: 0px 5px;width: 100% !important;" type="button" class="multiselect dropdown-toggle button_motivating_goal" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span></button>'
                },

            });

        function export_item(fileExtension, fileName) {
            let el = document.getElementById("total_table");
            let wb = XLSX.utils.table_to_sheet(el, {sheet: 'Sheet1'});
            const ne = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(ne, wb, "Sheet1");
            return XLSX.writeFile(ne, fileName + "." + fileExtension || ('MySheetName.' + (fileExtension || 'xlsx')));
        }

        // $('a.redirect').on('click', (e) => {
        //     e.preventDefault();
        //     // let url = $(e.target).attr('href');
        //     Redirect(url, false);
        // })

        $(".create").on('click', function (e) {
            e.preventDefault();
            console.log('1')
            Redirect("{{$cpanelCreate}}", false);

        })

        $(".detail").on('click', function (e) {
            e.preventDefault();
            let targetLink = $(e.target).attr('href');
            Redirect(targetLink, false);
            {{--window.parent.postMessage({targetLink: targetLink}, "{{$cpanelPath}}");--}}
        });

        $(".update").on('click', function (e) {
            e.preventDefault();
            let targetLink = $(e.target).attr('href');
            Redirect(targetLink, false);
        });

        $("#fillter-button").on("click", function (event) {
            event.stopPropagation();
            $("#fillter-content").toggle();
        })

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
        $(document).ready(function () {
            var name = $("#name");
            var type = $("#type");
            var store = $("#store");
            var selectType = '';
            selectName = name.selectize({
                plugins: ["restore_on_backspace"],
                maxItems: 1,
                allowEmptyOption: true,
                emptyOptionLabel: ""
            });
            // selectName[0].selectize.addOption({value:"1",text:'--Tất cả--'});
            // selectName[0].selectize.addItem("");
            // selectName[0].selectize.refreshOptions();


             selectStore = store.selectize({
                plugins: ["restore_on_backspace"],
                maxItems: 1,
            });

            $('.list_store').click(function (event) {
                event.preventDefault();
                let store = $(this).attr('data-store');
                let name = $(this).attr('data-name');
                $('.item_header').html('Ấn phẩm: ' + name)
                let arr_store = JSON.parse(store);
                console.log(arr_store)
                $('.nav').html('');
                $.each(arr_store, function (key, value) {
                    $('.nav').append('<li>' + key + '</li>')
                    $.each(value, function (k, v) {
                        $('.nav').append('<ul><li>' + v.name + '</li></ul>')
                    })

                })
            })

            $('#name').change(function (event) {
                event.preventDefault();
                let name = $('#name').val();
                console.log(name);
                let form = new FormData();
                form.append('name', name);
                $.ajax({
                    dataType: 'json',
                    enctype: 'multipart/form-data',
                    url: '{{route("viewcpanel::trade.getTypeByName")}}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: form,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $('#type').html('');
                        $(".theloading").show();
                    },
                    success: function (data) {
                        $(".theloading").hide();
                        if (data['status'] == 200) {
                            console.log(data)
                            if (data.data.length == 0) {
                                $('#type').attr('disabled', true);
                                $('#type').append('<option value="">' + "--Tất cả--" + '</option>');
                                // selectType = type.selectize({
                                //     maxItems: 1,
                                //     plugins: ["autofill_disable"],
                                // })
                            } else {
                                $('#type').attr('disabled', false);
                                $('#type').append('<option value="">' + "--Tất cả--" + '</option>');
                                $.each(data.data, function (key, value) {
                                    $('#type').append('<option value="' + value + '">' + value + '</option>');
                                });
                                // type.selectize({
                                //     maxItems: 1,
                                // })
                            }
                        } else if (typeof (data) == "string") {
                            $(".theloading").hide();
                            Swal.fire({
                                icon: 'error',
                                title: 'Thông báo',
                                text: 'Có lỗi xảy ra, vui lòng thử lại sau!',
                                confirmButtonColor: '#3085d6',
                                timer: 3000,
                                position: 'top',
                            })
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $(".theloading").hide();
                        Swal.fire({
                            icon: 'error',
                            title: 'Thông báo',
                            text: 'Có lỗi xảy ra, vui lòng thử lại sau!',
                            confirmButtonColor: '#3085d6',
                            timer: 3000,
                            position: 'top',
                        })
                    }
                });
            })

            $('.block_item').click(function (event) {
                event.preventDefault();
                let id = $(this).attr('data-id');
                let formData = new FormData();
                formData.append('id', id)
                Swal.fire({
                    title: '<span style="font-size: 18px">Xóa</span>',
                    html: '<span style="font-size: 15px">Bạn có chắc chắn muốn xoá bản ghi này ?</span>',
                    showCancelButton: true,
                    confirmButtonColor: '#C70404',
                    cancelButtonColor: '#D8D8D8',
                    confirmButtonText: 'Đồng ý',
                    cancelButtonText: 'Hủy',
                    position: 'top',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            dataType: 'json',
                            enctype: 'multipart/form-data',
                            url: '{{$blockItemUrl}}',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: formData,
                            processData: false,
                            contentType: false,
                            beforeSend: function () {
                                $('#type').html('');
                                $(".theloading").show();
                            },
                            success: function (data) {
                                $(".theloading").hide();
                                if (data['status'] == 200) {
                                    console.log(data)
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Thông báo',
                                        text: data.message,
                                        confirmButtonColor: '#3085d6',
                                        timer: 3000,
                                        position: 'top',
                                    })

                                    Redirect(window.location.href, 2000);


                                } else if (typeof (data) == "string") {
                                    $(".theloading").hide();
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Thông báo',
                                        text: 'Có lỗi xảy ra, vui lòng thử lại sau!',
                                        confirmButtonColor: '#dc3545',
                                        timer: 3000,
                                        position: 'top',
                                    })
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                $(".theloading").hide();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Thông báo',
                                    text: 'Có lỗi xảy ra, vui lòng thử lại sau!',
                                    confirmButtonColor: '#dc3545',
                                    timer: 3000,
                                    position: 'top',
                                })
                            }
                        });
                    }
                })


            })
        })
        $("#clear-search-form").on("click", function (event) {
            event.preventDefault();
            document.getElementById("search-form").reset();
            selectName[0].selectize.clear();
            selectStore[0].selectize.clear();
        });
    </script>
    <script type="text/javascript">

        {{--var moti = JSON.parse('{!! json_encode($motivating_goal_search) !!}');--}}
        {{--// console.log(moti);--}}
        {{--$('.motivating_goal option').each(function () {--}}
        {{--    let a = $(this).val();--}}
        {{--    $.each(moti, function (k, v) {--}}
        {{--        if (a == v) {--}}
        {{--            $('.motivating_goal').val(a)--}}
        {{--        }--}}
        {{--    })--}}
        {{--})--}}

        var dataSearch = JSON.parse('{!! json_encode($dataSearch) !!}');
        console.log(dataSearch);
        for (const property in dataSearch) {
            if (dataSearch[property] == null) {
                continue;
            }
            console.log(property, ' ', dataSearch[property]);
            $('#search-form').find("[name='" + property + "']").val(dataSearch[property]);
        }
    </script>
    <script type="text/javascript" src="{{ asset('viewcpanel/js/xlsx.js') }}"></script>

@endsection

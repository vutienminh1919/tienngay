@extends('viewcpanel::layouts.master')

@section('title', 'Báo cáo lịch sử thu hồi')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.14.0/css/selectize.bootstrap5.css" rel="stylesheet"/>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /*.modal-backdrop {*/
        /*    display: none !important;*/
        /*}*/

        .is-animated {
            width: 100%;
            height: 1000px;
        }

        .wrapper {
            padding: 0px 20px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .header {
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

        .style-btn-header button {
            background: #D8D8D8;
            height: 40px;
            color: #676767;
            width: 100px;
            border: none;
            outline: none;
            border-radius: 8px;
        }

        .list-content,
        .note-content {
            width: 100%;
            background: #FFFFFF;
            border: 1px solid #F0F0F0;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            padding: 16px 24px;
            display: flex;
            flex-direction: column;
            gap: 24px;

        }

        .select-box-content,
        .input-box-content {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: 12px;
        }

        .select-box-content select,
        .input-box-content input {
            width: 100%;
            background: #FFFFFF;
            border: 1px solid #D8D8D8;
            border-radius: 5px;
            height: 40px;
            outline: none;
            padding-left: 5px;
            font-weight: 400;
            font-size: 14px;
            line-height: 16px;
            color: #676767;
        }

        .fanxyapp-custom {
            display: flex;
            gap: 103px;
            margin-top: 12px;
            align-items: flex-end;

        }

        .fanxyapp-custom img {
            width: 305px;
            height: 125px;
        }

        .fanxyapp-custom button {
            width: 150px;
            height: 40px;
            background: #F4CDCD;
            color: #C70404;
            font-style: normal;
            font-weight: 600;
            font-size: 14px;
            line-height: 16px;
            border: none;
            outline: none;
            border-radius: 8px;
            margin-left: -50px;
        }

        .box-content {
            background: #FFFFFF;
            border: 1px solid #F0F0F0;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            padding: 0px 12px 24px 12px;
        }

        .box-content-button {
            display: flex;
            justify-content: flex-end;
            margin-top: 12px;
        }

        .box-content-button button {
            width: 190px;
            height: 40px;
            border: 1px solid #1D9752;
            border-radius: 5px;
            font-style: normal;
            font-weight: 600;
            font-size: 14px;
            line-height: 16px;
            color: #1D9752;
            background-color: white;
        }

        .note-content h5,
        .list-content h5 {
            font-style: normal;
            font-weight: 600;
            font-size: 16px;
            line-height: 20px;

            color: #3B3B3B;
        }

        .note-content textarea {
            width: 100%;
            height: 100px;
            background: #FFFFFF;
            border: 1px solid #D8D8D8;
            border-radius: 5px;
            outline: none;
            padding: 5px;
            font-weight: 400;
            font-size: 14px;
            line-height: 16px;
            color: #676767;

        }

        .footer-btn {
            display: flex;
            justify-content: space-between;
            padding: 0px 24px;
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
            align-items: center;
        }

        .footer-btn button {
            width: 190px;
            height: 40px;
            border-radius: 5px;
            border: none;
            outline: none;
        }

        .form-box {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-modal {
            display: flex;
            flex-direction: column;
            gap: 8px;
            text-align: center;
        }

        .form-modal h5 {
            font-style: normal;
            font-weight: 600;
            font-size: 16px;
            line-height: 20px;
            color: #3B3B3B;
        }

        .form-modal p {
            font-style: normal;
            font-weight: 400;
            font-size: 14px;
            line-height: 16px;
            color: #676767;
        }

        .modal-btn {
            display: flex;
            justify-content: space-between;
        }

        .modal-btn button {
            width: 192.5px;
            height: 40px;
            border: none;
            outline: none;
            font-style: normal;
            font-weight: 600;
            font-size: 14px;
            line-height: 16px;
        }

        .form-box-img {
            position: relative;
        }

        .form-box-img h5 {
            position: absolute;
            top: 35%;
            left: 45%;
            font-weight: 600;
            font-size: 24px;
            line-height: 32px;
            color: #FFFFFF;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        @media screen and (min-width: 102px) and (max-width: 1440px) {
            .fanxyapp-custom {
                display: flex;
                flex-direction: row;
                gap: 35px;
            }

            .fanxyapp-custom img {
                width: 220px;
                height: 125px;
            }
        }

        @media screen and (min-width: 600px) and (max-width: 900px) {
            .fanxyapp-custom {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .fanxyapp-custom img {
                width: 170px;
                height: 125px;
            }

            .fanxyapp-custom button {
                width: 170px;
                margin-left: 0px;
            }
        }



        @media screen and (max-width: 48em) {
            .header {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .fanxyapp-custom {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .fanxyapp-custom img {
                width: 100%;
                height: 125px;
            }

            .fanxyapp-custom button {
                width: 100%;
                margin-left: 0px;
            }

            .form-box {
                width: 100%;
            }

            .footer-btn button {
                width: 150px;
            }
        }
    </style>
@endsection
@section('content')
    <section id="phieu_dieu_chinh">
        <div id="loading" class="theloading" style="display: none;">
            <i class="fa fa-cog fa-spin fa-3x fa-fw" style="margin-bottom: 800px"></i>
        </div>
        <div class="wrapper">
            <div class="header">
                <div class="header-title">
                    <h3>Phiếu điều chỉnh</h3>
                    <small>
                        <a href="#"> Quản lý tồn kho ấn phẩm</a> > <a href="#">Báo
                            cáo tồn kho</a> > <a href="#">Chi tiết tồn kho</a>
                    </small>
                </div>
                <div class="style-btn-header">
                    <a type="button" class="btn btn-outline-secondary back" href="{{route('viewcpanel::trade.inventory.reportDetail', ['id' => $id])}}">Trở về <i class="fa fa-arrow-left" aria-hidden="true"></i></a>

                </div>
            </div>
            <div class="list-content" id="adjustment-item">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <h5>Danh sách ấn phẩm</h5>
                <div class="box-content box1 items" data-id="0">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-xs-12">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12 select-box-content">
                                    <input hidden class="id" id="id" type="text" value="{{$detail['_id']}}">
                                    <label>Tên ấn phẩm <span class="text-danger">*</span></label>
                                    <select style='color:gray' oninput='style.color="black"' id="item" name="item"
                                            class="item">
                                        <option value="">Chọn</option>
                                        @if(isset($item))
                                            @foreach($item as $i)
                                                <option
                                                    value="{{$i['code']}}">{{$i['name'] . ' ' . $i['type'] . ' ' . $i['specification']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="text-danger item_error" hidden>Ấn phẩm không được để trống !</span>
                                </div>
                                <div class="col-lg-6 col-md-6 col-xs-12 input-box-content">
                                    <label>Số lượng tồn thực tế <span style="font-size: 13px">(Không bao gồm số lượng các ấn phẩm hỏng)</span> <span class="text-danger">*</span></label>
                                    <input type="number" value="" name="quantity_stock_storage"
                                           id="quantity_stock_storage" class="quantity_stock_storage"
                                           placeholder="Nhập">
                                    <span class="text-danger quantity_stock_storage_error" hidden>Số lượng tồn thực tế không được để trống !</span>
                                </div>
                                <div class="col-lg-6 col-md-6 col-xs-12 input-box-content">
                                    <label>Số lượng hỏng <span class="text-danger">*</span></label>
                                    <input type="number" value="" name="quantity_broken" id="quantity_broken" oninput="validity.valid||(value='')" onkeydown="return event.keyCode !== 69"
                                           class="quantity_broken" placeholder="Nhập">
                                    <span class="text-danger quantity_broken_error" oninput="validity.valid||(value='')" onkeydown="return event.keyCode !== 69"
                                          hidden>Số lượng hỏng không được để trống !</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-xs-12 fanxyapp-custom">
                            <div class="form-box">
                                <label>Ảnh mô tả</label>
                                <div class="form-box-img imgs">
                                    <img
                                        src="https://upload.tienvui.vn/uploads/avatar/1670989669-90c1884f975b32de3b276317bee81943.jpg"
                                        style="filter: brightness(50%);-webkit-filter: brightness(50%);" alt=""
                                        data-fancybox-trigger="gallery">
                                    <h5 class="countImg"></h5>
                                </div>
                                <div style="display:none" class="img-adjustment">

                                </div>
                            </div>
                            <button name="remove_block" type="button" onclick="myFunction(this)" hidden
                                    id="remove_block" class="remove_block">Xóa ấn phẩm
                            </button>
                        </div>

                    </div>
                </div>
                <div class="box-content-button">
                    <button type="button" onclick="addBlock(this)" id="add_block">Thêm ấn phẩm</button>
                </div>
            </div>
            <div class="note-content">
                <h5>Ghi chú</h5>
                <textarea placeholder="Nhập" class="note" id="note"></textarea>
            </div>
            <div class="footer-btn">
                <a href="{{route('viewcpanel::trade.inventory.reportDetail', ['id' => $id])}}" class="cancel" style="font-weight: bold;background: #F4CDCD; color: #C70404;    width: 190px;height: 40px;border-radius: 5px;border: none;outline: none;    text-decoration: none;text-align: center;padding-top: 8px;">Hủy</a>
                <button style="background: #1D9752;color: #FFFFFF;" class="send_adjustment"><strong>Gửi duyệt</strong>
                </button>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade modalAdjustment" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="top: -45%">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-modal">
                            <h5>Xác nhận</h5>
                            <p>Bạn chắc chắn muốn điều chỉnh phiếu này</p>
                            <div class="modal-btn">
                                <button class="create" id="create" style="background: #1D9752;color: #FFFFFF;border-radius: 5px">
                                    Đồng ý
                                </button>
                                <button data-bs-dismiss="modal" style="background: #D8D8D8;color: #676767;border-radius: 5px">
                                    Hủy
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
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

        // var item = $('#item')
        // item.selectize({
        //     maxItems: 1,
        // });
        // $('.quantity_stock_storage').keyup(function (event) {
        //     var value = $(this).val();
        //     value = value.replace(/^(0*)/, "");
        //     $(this).val(value);
        //     // skip for arrow keys
        //     if (event.which >= 37 && event.which <= 40) return;
        //     // format number
        //     $(this).val(function (index, value) {
        //         return value
        //             .replace(/\D/g, "")
        //             .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        //             ;
        //     });
        // });
        //
        // $('.quantity_broken').keyup(function (event) {
        //     var value = $(this).val();
        //     value = value.replace(/^(0*)/, "");
        //     $(this).val(value);
        //     // skip for arrow keys
        //     if (event.which >= 37 && event.which <= 40) return;
        //     // format number
        //     $(this).val(function (index, value) {
        //         return value
        //             .replace(/\D/g, "")
        //             .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        //             ;
        //     });
        // });

        Array.prototype.remove = function () {
            var what, a = arguments, L = a.length, ax;
            while (L && this.length) {
                what = a[--L];
                while ((ax = this.indexOf(what)) !== -1) {
                    this.splice(ax, 1);
                }
            }
            return this;
        };

        $('.back').click(function (event) {
            event.preventDefault();
            let targetLink = $(event.target).attr('href');
            console.log('1')
            Redirect(targetLink, false);
        })

        $('.cancel').click(function (event) {
            event.preventDefault();
            let targetLink = $(event.target).attr('href');
            console.log('1')
            Redirect(targetLink, false);
        })

        $(document).ready(function () {
            var items = JSON.parse('{!! json_encode($item ?? "") !!}');
            const showNameOptions = (e) => {
                let _el = $(e.target).closest(".items");
                let code = $(_el).find("#item");
                let option = '<option value="">Chọn</option>';
                var usedItems = [];
                $(".items").each(function (index, value) {
                    let usedItem = $(value).find('[name="item"]').val();
                    if (!usedItem) {
                        return;
                    }
                    usedItems.push(usedItem);
                });
                console.log(usedItems)
                let currentName = $(_el).find('[name="item"]').val();
                if (currentName) {
                    usedItems.remove(currentName);
                }
                $.each(items, function (key, value) {
                    if (!usedItems.includes(value['code'])) {
                        option += '<option value="' + value['code'] + '">' + value['name'] + '-' + value['type'] + '-' + value['specification']  + '</option>';
                        $(code).html(option)
                    } else {
                        $(code).html(option)
                    }
                });

            }

            $("#adjustment-item").on("focus", ".item", function (e) {
                showNameOptions(e);
            });
            $("#adjustment-item").on("change", ".item", function (e) {
                let _el = $(e.target).closest(".items");
                let code = $(_el).find("#item")
                let dataId = $(_el).attr('data-id');
                let option = '<option value="">Chọn</option>';
                let tradePathEl = $(_el).find(".imgs");
                $.each(items, function (key, value) {
                    console.log(code.val())
                    if (code.val() == value['code']) {
                        let optionPath = '<img style="filter: brightness(50%); -webkit-filter: brightness(50%);" src="' + value['path'][0] + '" alt="" data-fancybox-trigger="gallery-' + dataId + '" class="underline cursor-pointer">';
                        optionPath += '<div class="img-adjustment" style="display:none">';
                        for (let i = 0; i < value['path'].length; i++) {
                            optionPath += '<a  data-fancybox="gallery-' + dataId + '" href="' + value['path'][i] + '"><img class="rounded" src="' + value['path'][i] + '"/></a>';
                        }
                        optionPath += '</div><h5 data-fancybox-trigger="gallery-' + dataId + '" class="underline cursor-pointer xt">+' + value['path'].length + '</h5>';
                        $(tradePathEl).html(optionPath);
                    } else if (code.val() == "") {
                        $(_el).find(".imgs > img").attr('src', 'https://upload.tienvui.vn/uploads/avatar/1670989669-90c1884f975b32de3b276317bee81943.jpg');
                        $(_el).find(".imgs > .xt").remove();
                        $(_el).find(".img-adjustment").html('');

                    }
                });
            });

            $('.send_adjustment').click(function (event) {
                event.preventDefault();
                document.body.scrollIntoView();
                let error_adjustment = false;
                $('.items').each(function (key, value) {
                    let a = {};
                    code = $(value).find("#item").val();
                    quantity_stock_storage = ($(value).find('#quantity_stock_storage').val());
                    quantity_broken = ($(value).find('#quantity_broken').val());
                    if (code == "" || code == undefined) {
                        $(value).find('.item').css('border', 'red 1px solid');
                        $(value).find('.item_error').attr('hidden', false);
                        $('.wrapper').css('height', '100vh')
                        $('.wrapper').css('overflow-y', 'scroll')
                        error_adjustment = true
                        // $('.modal-backdrop').css('display', 'none')
                        // $('.modalAdjustment').hide();
                    } else {
                        $(value).find('.item').css('border', '1px solid #D8D8D8');
                        $(value).find('.item_error').attr('hidden', true)
                    }
                    if (quantity_stock_storage == "" || quantity_stock_storage == undefined) {
                        $(value).find('.quantity_stock_storage').css('border', 'red 1px solid');
                        $(value).find('.quantity_stock_storage_error').attr('hidden', false);
                        $('.wrapper').css('height', '100vh')
                        $('.wrapper').css('overflow-y', 'scroll')
                        error_adjustment = true
                        // $('.modal-backdrop').css('display', 'none')
                        // $('.modalAdjustment').hide();
                    } else {
                        $(value).find('.quantity_stock_storage').css('border', '1px solid #D8D8D8');
                        $(value).find('.quantity_stock_storage_error').attr('hidden', true)
                    }
                    if (quantity_broken == "" || quantity_broken == undefined) {
                        $(value).find('.quantity_broken').css('border', 'red 1px solid');
                        $(value).find('.quantity_broken_error').attr('hidden', false);
                        $('.wrapper').css('height', '100vh')
                        $('.wrapper').css('overflow-y', 'scroll')
                        error_adjustment = true
                        // $('.modal-backdrop').css('display', 'none')
                        // $('.modalAdjustment').hide();
                    } else {
                        $(value).find('.quantity_broken').css('border', '1px solid #D8D8D8');
                        $(value).find('.quantity_broken_error').attr('hidden', true)
                    }
                });

                console.log(error_adjustment)
                if (error_adjustment) {
                    // $('#exampleModal').modal('hide');
                    $('.modal-backdrop').css('display', 'none')
                    return;
                } else {
                    $('.modal-backdrop').css('display', '')
                     $('#exampleModal').modal('show');
                }

            })


            $('#create').click(function (event) {
                event.preventDefault();
                let id = $('#id').val();
                let note = $('#note').val();
                let code = ''
                let quantity_stock_storage = ''
                let quantity_broken = ''
                let arr = [];
                let error_adjustment = false;
                $('.items').each(function (key, value) {
                    let a = {};
                    code = $(value).find("#item").val();
                    quantity_stock_storage = ($(value).find('#quantity_stock_storage').val());
                    quantity_broken = ($(value).find('#quantity_broken').val());
                    // if (code == "") {
                    //     $(value).find('.item').css('border', 'red 1px solid');
                    //     $(value).find('.item_error').attr('hidden', false);
                    //     $('.wrapper').css('height', '100vh')
                    //     $('.wrapper').css('overflow-y', 'scroll')
                    //     error_adjustment = true
                    // } else {
                    //     $(value).find('.item').css('border', '1px solid #D8D8D8');
                    //     $(value).find('.item_error').attr('hidden', true)
                    // }
                    // if (quantity_stock_storage == "") {
                    //     $(value).find('.quantity_stock_storage').css('border', 'red 1px solid');
                    //     $(value).find('.quantity_stock_storage_error').attr('hidden', false);
                    //     $('.wrapper').css('height', '100vh')
                    //     $('.wrapper').css('overflow-y', 'scroll')
                    //     error_adjustment = true
                    // } else {
                    //     $(value).find('.quantity_stock_storage').css('border', '1px solid #D8D8D8');
                    //     $(value).find('.quantity_stock_storage_error').attr('hidden', true)
                    // }
                    // if (quantity_broken == "") {
                    //     $(value).find('.quantity_broken').css('border', 'red 1px solid');
                    //     $(value).find('.quantity_broken_error').attr('hidden', false);
                    //     $('.wrapper').css('height', '100vh')
                    //     $('.wrapper').css('overflow-y', 'scroll')
                    //     error_adjustment = true
                    // } else {
                    //     $(value).find('.quantity_broken').css('border', '1px solid #D8D8D8');
                    //     $(value).find('.quantity_broken_error').attr('hidden', true)
                    // }
                    a = {
                        'code': code,
                        'quantity_stock_storage': parseInt(quantity_stock_storage),
                        'quantity_broken': parseInt(quantity_broken),
                    }
                    arr.push(a);
                });
                console.log(arr)
                let formData = new FormData();
                formData.append('id_report', id)
                formData.append('note', note)
                formData.append('item', JSON.stringify(arr))
                $.ajax({
                    dataType: 'json',
                    enctype: 'multipart/form-data',
                    url: '{{route('viewcpanel::trade.inventory.adjustmentInsert')}}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $('#exampleModal').hide();
                        $(".theloading").show();
                    },
                    success: function (data) {
                        $(".theloading").hide();
                        if (data.status == 200) {
                            // $('#exampleModal').hide();
                            $(".theloading").hide();
                            Swal.fire({
                                icon: 'success',
                                title: 'Thông báo',
                                text: 'Tạo thành công',
                                confirmButtonColor: '#1D9752',
                                timer: 3000,
                                position: 'top',
                            })
                            setTimeout(function () {
                                setTimeout(function () {
                                    Redirect("{{route('viewcpanel::trade.inventory.reportDetail', ['id' => $id])}}" ,false);
                                }, 3000);
                            })
                        } else {
                            $(".theloading").hide();
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $(".theloading").hide();
                    }
                });

            })

        })
        var countBlock = 1;
        function addBlock(e) {
            let el = $('.box1:first').clone().insertAfter('.box1:last');
            $(el).find("#quantity_stock_storage").val("");
            $(el).find("#quantity_broken").val("");
            $(el).attr("data-id", countBlock++);
            let data_id = $(el).attr("data-id");
            $(el).find(".imgs > img").attr('src', 'https://upload.tienvui.vn/uploads/avatar/1670989669-90c1884f975b32de3b276317bee81943.jpg');
            $(el).find(".imgs > img").attr('data-fancybox-trigger', 'gallery-' + countBlock);
            $(el).find(".imgs > .xt").remove();
            $(el).find(".img-adjustment").html('');
            $(el).find(".imgs > button").attr('hidden', false);
            $(el).find('.item').css('border', '1px solid #D8D8D8');
            $(el).find('.item_error').attr('hidden', true);
            $(el).find('.quantity_stock_storage').css('border', '1px solid #D8D8D8');
            $(el).find('.quantity_stock_storage_error').attr('hidden', true);
            $(el).find('.quantity_broken').css('border', '1px solid #D8D8D8');
            $(el).find('.quantity_broken_error').attr('hidden', true);
            $('.remove_block').attr('hidden', false);
        }

        function myFunction(el) {
            $(el).parent().closest('.box1').remove();
            console.log($(".box1").length);
            if ($(".box1").length <= 1) {
                $('.remove_block').attr('hidden', true);
            }
        }
    </script>
@endsection

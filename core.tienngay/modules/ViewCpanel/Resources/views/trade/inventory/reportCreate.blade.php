@extends('viewcpanel::layouts.master')

@section('title', 'Báo cáo tồn kho PGD')

@section('css')
    <style>
        .selectize-input div.item + input {
            display: none;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        #main {
            width: 100%;
        }

        .header h3 {
            font-style: normal;
            font-weight: 600;
            font-size: 20px;
            line-height: 24px;
        }

        .header a {
            font-style: normal;
            font-weight: 400;
            font-size: 12px;
            line-height: 14px;
            text-decoration: none;
            color: #676767;
        }

        .form-container {
            width: 100%;
            padding: 24px 16px;
            gap: 24px;
            background: #FFFFFF;
            border: 1px solid #F0F0F0;
            border-radius: 8px;
        }

        .content-title {
            width: 100%;
        }

        .content-item {
            display: flex;
            flex-direction: column;
            margin-top: 12px;
        }

        select:invalid {
            color: gray;
        }

        label {
            font-style: normal;
            font-weight: 400;
            font-size: 14px;
            /*line-height: 16px;*/
            padding-bottom: 12px;
        }

        .content-item input,
        select {
            /* width: 100%; */
            height: 40px;
            background: #FFFFFF;
            border: 1px solid #D8D8D8;
            border-radius: 5px;
            outline: none;
            padding: 0px 5px;
        }

        .content-form-img {
            width: 100%;
            height: 288px;
            background: #FFFFFF;
            border: 1px solid #D8D8D8;
            border-radius: 5px;
            position: relative;
        }

        .content-form-img button {
            position: absolute;
            left: 10;
            bottom: 10px;
        }

        .content-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 12px;
        }

        .item-checkbox {
            display: flex;
            gap: 5px;
        }

        .item-checkbox input {
            height: 20px;
        }

        .multiselect-parent {
            width: 100%;
        }

        .multiselect-parent .dropdown-toggle {
            width: 100%;
        }

        .multiselect-parent .dropdown-menu {
            width: 100%;
        }

        .multiselect-container dropdown-menu show {
            width: 100%;
        }

        input[type="checkbox"] {
            accent-color: #1D9752;
        }

        .form-check-input {
            width: 20px !important;
            height: 20px !important;
        }

        .form-check-input:checked {
            width: 20px;
            height: 20px;
            background-color: #1D9752 !important;
            border-color: #1D9752 !important;
        }

        .form-check-label {
            margin-left: 5px;
            font-size: 14px !important;
            padding-top: 3px !important;
        }

        .items {
            height: 40px !important;
        }

        input:disabled {
            background-color: #EBEBE4 !important;
            cursor: not-allowed !important;
            pointer-events: none !important;
        }

        select:disabled {
            background-color: #EBEBE4 !important;
            cursor: not-allowed !important;
            pointer-events: none !important;
        }

        .upload-hidden {
            display: none;
        }

        #call-to-action {
            width: 80px;
            /*border: solid 1px #1D9752;*/
            font-size: 14px;
            color: #4299E1;
            border-radius: 5px;
            font-weight: 400;
            padding: 5px 0;
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

        .block {
            position: relative;
            display: inline-block;
            vertical-align: top;
            width: 100px;
            /*height: 150px;*/
            padding: 9px;
            margin-right: 15px;
            margin-bottom: 15px;
            background-color: #fff;
            border: 1px solid #ccc;
            margin-right: 10px;
            border-radius: 5px;
        }

        .block img, video {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            max-height: 100%;
        }

        .cancelButton {
            -moz-appearance: none;
            -webkit-appearance: none;
            position: absolute;
            top: -3px;
            right: 3px;
            color: #F00;
            text-align: center;
            font-weight: 700;
            background-color: transparent;
            padding: 0;
            margin: 0;
            border: 0;
            font-size: 25px;
            right: -8px;
            top: -8px;
            line-height: 15px;
            border-radius: 100%;
            background-color: #fff
        }

        .img {
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .modal-backdrop {
            display: none !important;
        }

        .img:hover {
            opacity: 0.7;
        }

        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0, 0, 0); /* Fallback color */
            background-color: rgba(0, 0, 0, 0.9); /* Black w/ opacity */
        }

        /* Modal Content (Image) */
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        /* Caption of Modal Image (Image Text) - Same Width as the Image */
        #caption {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            color: #ccc;
            padding: 10px 0;
            height: 150px;
        }

        /* Add Animation - Zoom in the Modal */
        .modal-content, #caption {
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        @keyframes zoom {
            from {
                transform: scale(0)
            }
            to {
                transform: scale(1)
            }
        }

        /* The Close Button */
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        .show {
            width: 100%;
        }

        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 700px) {
            .modal-content {
                width: 100%;
            }
        }

        .img-area {
            border: solid 1px #D8D8D8;
            border-radius: 5px;
            padding: 3px;
            /*margin-bottom: 10px;*/
            position: relative;
        }

        .submit {
            width: 150px;
            font-weight: 400;
            font-size: 14px;
        }

        #cancle {
            color: #676767;
            background-color: #D8D8D8;
            border-color: #D8D8D8;
        }

        #create {
            background-color: #1D9752;
            border-color: #1D9752;
        }

        .form-group {
            margin-top: 10px;
        }

        #delivery_time {
            border-radius: 5px;
            background-color: #377dff;
        }

        .fw-600 {
            font-weight: 600 !important;
        }

    </style>
@endsection

<div id="main">
    <div id="loading" class="theloading" style="display: none;">
        <i class="fa fa-cog fa-spin fa-3x fa-fw" style="margin-bottom: 800px"></i>
    </div>
    <div class="header row" style="padding-left: 30px">
        <h3 class="col-md-12 col-sm-12 col-xs-12">Báo cáo tồn kho</h3>
        <small class="col-md-12 col-sm-12 col-xs-12">
            <a href="" class="list">Danh mục ấn phẩm</a>/ <a href="#">Thêm mới</a>
        </small>
    </div>
    <div class="main">
        <div class="content-title">
        </div>
        <div class="content-body row" style="display: flex;flex-direction: column;gap: 24px;padding: 25px 30px;">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="form-container">
                <h5>Thông tin chung</h5>
                <div class="row" style="padding: 10px;">
                    <div class="col-sm-4 col-md-4">
                        <div class="form-group">
                            <label for="" class="col-form-label">Phòng giao dịch <span
                                    class="text-danger">*</span></label>
                            <select <?= (count($pgds) == 1) ? "disabled" : "" ?> class="form-select" style="width: 100%"
                                    name="store" id="store">
                                @if(count($pgds) == 1)
                                    <option selected value="{{$pgds[0]['_id']}}">{{$pgds[0]['name']}}</option>
                                @else
                                    <option value="">--Chọn phòng giao dịch--</option>
                                    @foreach($pgds as $item)
                                        <option value="{{$item['_id']}}">{{$item['name']}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="text-danger" id="store_error" hidden>Phòng giao dịch không được để trống !</span>
                        </div>

                    </div>
                    <div class="col-sm-4 col-md-4">
                        <div class="form-group">
                            <label for="upload" class="col-form-label">Chứng từ <span
                                    class="text-danger">*</span></label>
                            <div class="img-area">
                                <div id="imgInput"></div>
                                <a type="button" class="upload btn btn-default btn-lg" id="call-to-action"> Tải ảnh lên
                                </a>
                                <i style="position: absolute;right: 10px;top: 26%;" class="fa fa-upload"
                                   aria-hidden="true"></i>
                                <div id="drop">
                                    <input type="file" name="imgs" multiple multiple class="upload-hidden">
                                </div>
                            </div>
                            <span id="invalid-img" class="invalid"></span>
                            <span class="text-danger path" id="path_error" hidden>Chứng từ không được để trống !</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-container">
                <h5>Danh sách ấn phẩm</h5>
                <h6 class="text-danger">Báo cáo số lượng tồn thực tế không bao gồm số lượng các ẩn phẩm hỏng</h6>
                <div class="row" id="item-area">
                    @if(!empty($items) && count($pgds) == 1)
                        @foreach($items['items'] as $item)
                            <div class="col-sm-4 col-md-4">
                                <div class="item">
                                    <div class="content-item">
                                        <div class="form-item" style="padding-bottom: 10px;">
                                            <span id="name" style="font-size: 20px">{{$item['name']}}</span><span class="text-danger">*</span>
                                            <br>
                                            <span id="type" style="font-size: 12px">{{$item['type']}}</span>
                                            <br>
                                            <span
                                                id="specification"
                                                style="font-size: 12px">{{$item['specification']}}</span>
                                            <span hidden id="id" style="font-size: 12px">{{$item['item_id']}}</span>
                                            <span hidden id="code" style="font-size: 12px">{{$item['code_item']}}</span>
                                        </div>
                                        <input type="number" placeholder="Nhập số lượng" class="form-control amount"
                                               id="amount"
                                               name="amount[]" min="0" oninput="validity.valid||(value='')"
                                               onkeydown="return event.keyCode !== 69">
                                    </div>
                                    <span class="text-danger error" hidden>Số lượng tồn không được để trống !</span>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="form-container">
                <div class="form-group" style="margin-top: 0px !important;">
                    <label for="upload" class="col-form-label"><strong>Ghi chú</strong></label>
                    <div>
                        <textarea class="form-control" name="" id="description" placeholder="Nhập"></textarea>
                    </div>
                </div>
            </div>


            <div action="" class="col-md-12  col-xs-12">
                <div class="content-footer">
                    <button type="button" class="btn btn-secondary cancel"
                            style="font-weight: bold;width: 200px;background-color: #F4CDCD;color: #C70404;border: none">
                        Hủy
                    </button>
                    <button type="button" class="btn btn-success create" style="font-weight: bold;width: 200px">Báo cáo
                        tồn kho
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- The Modal -->
    <div id="imgModal" class="modal">
        <!-- The Close Button -->
        <span class="close" onclick="closeModal(this)">&times;</span>
        <!-- Modal Content (The Image) -->
        <img class="modal-content" id="img01">
        <!-- Modal Caption (Image Text) -->
    </div>
    <div id="videoModal" class="modal">
        <!-- The Close Button -->
        <span class="close" onclick="closeModal(this)">&times;</span>
        <!-- Modal Content (The Image) -->
        <iframe id="srcVideo" width="100%" height="100%" frameborder="0" allowfullscreen src=""></iframe>
    </div>


    <div class="modal fade" id="errorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Thông báo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="msg_error"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="successModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Thông báo</h5>
                </div>
                <div class="modal-body">
                    <p class="msg_success"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
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

        $(document).ready(function () {
            $('.cancel').click(function (e) {
                e.preventDefault();
                Redirect("{{route('viewcpanel::trade.inventory.reportList')}}")
            })

            $('.create').click(function (event) {
                document.body.scrollIntoView();
                let amount = '';
                let name = '';
                let type = '';
                let id = '';
                let specification = '';
                let arr = [];
                console.log(arr);
                let description = $('#description').val();
                let store = $('#store').val();

                Swal.fire({
                    title: 'Gửi báo cáo',
                    text: "Bạn có chắc chắn muốn gửi báo cáo này ?",
                    // icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#1D9752',
                    cancelButtonColor: '#D8D8D8',
                    confirmButtonText: 'Đồng ý',
                    cancelButtonText: 'Hủy',
                    position: 'top',
                }).then((result) => {
                    if (result.isConfirmed) {
                        let license = [];
                        $("input[name='url[]']").each(function () {
                            license.push($(this).val());
                        });
                        console.log(license)
                        if (Object.keys(license).length == 0) {
                            $('.img-area').css('border', 'red 1px solid');
                            $('#path_error').attr('hidden', false);
                        } else {
                            $('.img-area').css('border', '1px solid #D8D8D8');
                            $('#path_error').attr('hidden', true)
                        }
                        // if ($('.item').length != 0) {
                        $('.item').each(function (key, value) {
                            let a = {};
                            amount = ($(value).find('#amount').val());
                            if (amount == "") {
                                $(value).find('#amount').css('border', 'red 1px solid');
                                $(value).find('.error').attr('hidden', false);
                                return;
                            } else {
                                $(value).find('#amount').css('border', '1px solid #D8D8D8');
                                $(value).find('.error').attr('hidden', true);
                            }
                            id = ($(value).find('#id').text());
                            name = ($(value).find('#name').text());
                            type = ($(value).find('#type').text());
                            code = ($(value).find('#code').text());
                            specification = ($(value).find('#specification').text());
                            a = {
                                'id': id,
                                'name': name,
                                'type': type,
                                'code': code,
                                'specification': specification,
                                'quantity_stock': parseInt(amount)
                            };
                            arr.push(a);
                        });
                        console.log(license);

                        let formData = new FormData();
                        formData.append('item', JSON.stringify(arr));
                        formData.append('countItem', $('.item').length);
                        formData.append('description', description);
                        formData.append('store', store);
                        formData.append('license', JSON.stringify(license));
                        $.ajax({
                            dataType: 'json',
                            enctype: 'multipart/form-data',
                            url: '{{$urlInsert}}',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: formData,
                            processData: false,
                            contentType: false,
                            beforeSend: function () {
                                $(".theloading").show();
                            },
                            success: function (data) {
                                $(".theloading").hide();
                                if (data.status == 200) {
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
                                            Redirect("{{route('viewcpanel::trade.inventory.reportList')}}")
                                        }, 3000);
                                    })
                                } else {
                                    $(".theloading").hide();
                                    if (data.errors.store) {
                                        console.log(data.errors.store)
                                        $('#store').css('border', 'red 1px solid');
                                        $('#store_error').attr('hidden', false)
                                    } else {
                                        $('#store').css('border', '1px solid #D8D8D8');
                                        $('#store_error').attr('hidden', true)
                                    }
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                $(".theloading").hide();
                            }
                        });
                    }
                });
            })
            $('#store').change(function (event) {
                event.preventDefault();
                let store = $('#store').val();
                console.log(store);
                let form = new FormData();
                form.append('store_id', store);
                $.ajax({
                    dataType: 'json',
                    enctype: 'multipart/form-data',
                    url: '{{route('viewcpanel::trade.inventory.getItembyStoreId')}}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: form,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $('#item-area').html('');
                        $(".theloading").show();
                    },
                    success: function (data) {
                        $(".theloading").hide();
                        if (data.status == 200) {
                            $('.create').attr('disabled', false);
                            $.each(data.data.items, function (key, value) {
                                $('#item-area').append('<div class="col-sm-4 col-md-4"> <div class="item"> <div class="content-item"> <div class="form-item" style="padding-bottom: 10px;"> <span id="name" style="font-size: 20px">' + value.name + '&nbsp;<span class="text-danger">*</span></span><br> <span id="type" style="font-size: 12px">' + value.type + '</span><br> <span id="specification" style="font-size: 12px">' + value.specification + '</span> <span hidden id="id" style="font-size: 12px">' + value.item_id + '</span><span hidden id="code" style="font-size: 12px">' + value.code_item + '</span> </div> <input type="number" placeholder="Nhập số lượng" class="form-control amount" id="amount" name="amount[]" min="0" oninput="validity.valid||(value=null)" onkeydown="return event.keyCode !== 69"> </div> <span class="text-danger error" hidden>Số lượng tồn không được để trống !</span> </div> </div>')
                            })
                            console.log(data)
                        } else {
                            console.log('2')
                            $(".theloading").hide();
                            $('.create').attr('disabled', true);
                            Swal.fire({
                                icon: 'error',
                                title: 'Thông báo',
                                text: 'Phòng giao dịch không có ấn phẩm nào! Vui lòng thử lại',
                                confirmButtonColor: '#dc3545',
                                timer: 3000,
                                position: 'top',
                            });
                            return;
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

            });
        });

        const uploadImgs = async function (file) {
            var formData = new FormData();
            formData.append('file', file);
            console.log(file.type);
            var mine = ['image/jpeg', 'image/png', 'image/jpg'];
            if (mine.includes(file.type)) {
                //
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Có lỗi xảy ra...',
                    text: 'File upload sai định dạng!',
                    position: 'top',
                })
                return;
            }

            await $.ajax({
                dataType: 'json',
                enctype: 'multipart/form-data',
                url: '{{route('viewcpanel::trade.inventory.uploadImg')}}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                success: function (data) {
                    console.log(data);
                    if (data && data.code == 200) {
                        $('.fa-upload').attr('hidden', true);
                        if (file.type == 'image/jpeg' || file.type == 'image/png' || file.type == 'image/jpg') {
                            let block = `
                <div class="block" style="width:auto; border:none; ">
                  <a target="_blank" style="font-size:14px;text-decoration: none " href="` + data.path + `">` + data.raw_name + ` </a>
                  <input data-fileType ="` + file.type + `" data-fileName = "` + data.raw_name + `" type="hidden" name="url[]" value="` + data.path + `">
                  <button style="position: absolute;top: -3px;" type="button" onclick="deleteImage(this)" class="cancelButton">
                    <i style="font-size: 20px;margin-top: 12px;" class="fa fa-times"></i>
                  </button>
                </div>
                `;
                            $('#imgInput').before(block);
                        } else {
                            let block = `
                    <div class="block" style="width:auto; border:none; ">
                         <a style="font-size:14px;text-decoration: none " href="` + data.path + `">` + data.raw_name + ` </a>
                        <input data-fileType ="` + file.type + `" data-fileName = "` + data.raw_name + `" multiple type="hidden" name="url[]" id="url" value="` + data.path + `">
                        <button style="position: absolute;top: -3px;" type="button" onclick="deleteImage(this)" class="cancelButton">
                            <i style="font-size: 20px;margin-top: 12px;" class="fa fa-times"></i>
                        </button>
                    </div>
                    `;
                            $('#imgInput').before(block);
                        }

                    } else if (typeof (data) == "string") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Thông báo',
                            text: 'Có lỗi xảy ra, vui lòng thử lại sau!',
                            confirmButtonColor: '#dc3545',
                            timer: 3000,
                            position: 'top',
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Thông báo',
                            text: data.msg,
                            confirmButtonColor: '#dc3545',
                            timer: 3000,
                            position: 'top',
                        })
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
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

        $('.upload-hidden').on('change', function () {
            var files = $(this)[0].files;
            for (let i = 0; i < files.length; i++) {
                let file = files[i];
                uploadImgs(file);
            }
        });

        $('#call-to-action').click(function () {
            $('.upload-hidden').click();
        });

        function deleteImage(el) {
            if (confirm("Bạn có chắc chắn muốn xóa ?")) {
                let a = $(".img-area").find('.block').length;
                console.log(a);
                if (a == 1) {
                    $('.fa-upload').attr('hidden', false);
                }
                $(el).closest(".block").remove();
                $('#drop').find('[type="file"]').first().val('');
            }
        }

        function clickImg(el) {
            var modal = document.getElementById("imgModal");
            // Get the image and insert it inside the modal - use its "alt" text as a caption
            var modalImg = document.getElementById("img01");
            var captionText = document.getElementById("caption");
            modal.style.display = "block";
            modalImg.src = el.src;
        }

        const closeModal = function (el) {
            console.log("close");
            $(el).closest('.modal').hide();
        }


    </script>

@endsection

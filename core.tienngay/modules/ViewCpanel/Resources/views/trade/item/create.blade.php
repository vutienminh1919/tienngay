@extends('viewcpanel::layouts.master')

@section('title', 'Thêm mới ấn phẩm Trade Marketing')

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/css/bootstrap-multiselect.css"
          rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.14.0/css/selectize.bootstrap5.css"
          rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.4.2/css/all.min.css" rel="stylesheet"/>

    <style type="text/css">
        body {
            background-color: rgb(237, 237, 237) !important;
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
            width: 150px;
            border: solid 1px #1D9752;
            font-size: 14px;
            color: #1D9752;
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
            width: 150px;
            height: 150px;
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
            padding: 10px;
            margin-bottom: 10px;
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

<style>
    .selectize-input div.item + input {
        display: none;
    }

    .selectize-input > * {
        vertical-align: baseline;
        display: block;
        zoom: 1;
    }

    .selectize-input {
        position: relative;
    }

    .selectize-input input {
        /*height: 40px !important;*/
        position: absolute;
        top: 0;
    }

    #select_name-selectized {
        height: 100%;
    }
    #select_type-selectized {
        height: 100%;
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

    .form-item {
        display: flex;
        justify-content: space-between;
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

</style>

<div id="main">
    <div id="loading" class="theloading" style="display: none;">
        <i class="fa fa-cog fa-spin fa-3x fa-fw" style="margin-bottom: 800px"></i>
    </div>
    <div class="header row">
        <h3 class="col-md-12 col-sm-12 col-xs-12">Thêm mới ấn phẩm</h3>
        <small class="col-md-12 col-sm-12 col-xs-12">
            <a href="" class="list">Danh mục ấn phẩm</a>/ <a href="#">Thêm mới</a>
        </small>
    </div>
    <div class="form-container">
        <div class="content-title">
            <h5>Thông tin ấn phẩm</h5>
        </div>
        <div class="content-body row">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="row">
                <div class="col-sm-4">
                    <div>
                        <div class="content-item ">
                            <label for=""> Hạng mục <span class="text-danger">*</span></label>
                        </div>
                        <select id="category" name="category">
                            <option value="publication">Ấn phẩm</option>
                            <option value="item">Vật phẩm</option>
                        </select>
                        <p style="text-align: center;margin-bottom: -10px;" class="text-danger category" hidden></p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div>
                        <div class="content-item ">
                            <label for=""> Mục tiêu triển khai <span class="text-danger">*</span></label>
                        </div>
                        <select id="target_goal" name="target_goal">
                            <option value="direct">Trực tiếp</option>
                            <option value="indirect">Phủ nhận diện</option>
                        </select>
                        <p style="text-align: center;margin-bottom: -10px;" class="text-danger target_goal" hidden></p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div>
                        <div class="content-item ">
                            <label for=""> Mục tiêu thúc đẩy <span class="text-danger">*</span></label>
                        </div>
                        <select id="motivating_goal" name="motivating_goal[]" multiple>
                            <option value="DKXM">Đăng ký xe máy</option>
                            <option value="DKOTO">Đăng ký ô tô</option>
                            <option value="other">Khác</option>
                        </select>
                        <p style="text-align: center;margin-bottom: -10px;" class="text-danger motivating_goal"
                           hidden></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div>
                        <div class="content-item ">
                            <div class="form-item">
                                <label for="">Tên ấn phẩm <span class="text-danger">*</span></label>
                                <div class="item-checkbox">
                                    <label for="check_name">Nhập mới tên ấn phẩm</label>
                                    <input style="width: 20px;height:20px;border: 5px;" type="checkbox" id="check_name"
                                           name="check_name">
                                </div>
                            </div>
                            <select id="select_name">
                                <option value="">--Chọn tên sản phẩm--</option>
                                @foreach($name as $item)
                                    <option value="{{$item}}">{{$item}}</option>
                                @endforeach
                            </select>
                            <input hidden type="text" placeholder="Nhập" id="name" name="name">
                            <p style="text-align: center;margin-bottom: -10px;" class="text-danger name" hidden></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div>
                        <div class="content-item ">
                            <div class="form-item">
                                <label for=""> Loại ấn phẩm <span class="text-danger">*</span></label>
                                <div class="item-checkbox">
                                    <label for="check_type">Nhập mới loại ấn phẩm</label>
                                    <input style="width: 20px;height:20px;border: 5px;" type="checkbox" id="check_type"
                                           name="check_type">
                                </div>
                            </div>
                            <select id="select_type" disabled>
                                <option value="">--Chọn loại sản phẩm--</option>
                            </select>
                            <input hidden type="text" placeholder="Nhập" id="type" name="type">
                            <p style="text-align: center;margin-bottom: -10px;" class="text-danger type" hidden></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div>
                        <div class="content-item ">
                            <label for=""> Đơn giá dự kiến <span class="text-danger">*</span></label>
                            <input type="text" placeholder="Nhập" id="price" name="price">
                        </div>
                    </div>
                    <p style="text-align: center;margin-bottom: -10px;" class="text-danger price" hidden></p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div>
                        <div class="content-item ">
                            <label for=""> Kích thước <span class="text-danger">*</span></label>
                            <input type="text" placeholder="Nhập" id="size" name="size">
                        </div>
                        <p style="text-align: center;margin-bottom: -10px;" class="text-danger size" hidden></p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div>
                        <div class="content-item ">
                            <label for=""> Chất liệu <span class="text-danger">*</span></label>
                            <input type="text" placeholder="Nhập" id="material" name="material">
                        </div>
                        <p style="text-align: center;margin-bottom: -10px;" class="text-danger material" hidden></p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div>
                        <div class="content-item ">
                            <label for=""> Kĩ thuật <span class="text-danger">*</span></label>
                            <input type="text" placeholder="Nhập" id="tech" name="tech">
                        </div>
                        <p style="text-align: center;margin-bottom: -10px;" class="text-danger tech" hidden></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div>
                        <div class="content-item ">
                            <label for=""> Khu vực áp dụng <span class="text-danger">*</span></label>
                        </div>
                        <select id="multiple-checkboxes" name="store[]" multiple>
                            @foreach($arrStores as $key => $item)
                                <optgroup label="{{$key}}">
                                    @foreach($item as $value)
                                        <option value="{{$value['_id']}}">{{$value['name']}}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <p style="text-align: center;margin-bottom: -10px;" class="text-danger store" hidden></p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div>
                        <div class="item-checkbox" style="margin-top: 12px">
                            <input style="width: 20px;height:20px;border: 5px;" type="checkbox" id="check_date"
                                   name="check_date">
                            <label for="check_date">Sản phẩm có ngày hết hạn</label>
                        </div>
                        <input disabled
                               style="height: 40px;width: 100%;background: #FFFFFF;border: 1px solid #D8D8D8;border-radius: 5px;outline: none;padding: 0px 5px;"
                               type="text" placeholder="Chọn ngày hết hạn" id="date" name="date">
                        <p style="text-align: center;margin-bottom: -10px;" class="text-danger date" hidden></p>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="upload" class="col-form-label">Ảnh mô tả <span class="text-danger">*</span></label>
                <div class="img-area">
                    <div id="imgInput"></div>
                    <a type="button" class="upload btn btn-default btn-lg" id="call-to-action"> Thêm hình ảnh
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                             class="bi bi-plus" viewBox="0 1 10 15">
                            <path
                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
                        </svg>
                    </a>
                    <div id="drop">
                        <input type="file" name="imgs" multiple multiple class="upload-hidden">
                    </div>
                </div>
                <span id="invalid-img" class="invalid"></span>
                <p style="text-align: center;margin-bottom: -10px;" class="text-danger path" hidden></p>
            </div>

            <div action="" class="col-md-12  col-xs-12">
                <div class="content-footer">
                    <button type="button" class="btn btn-secondary cancel" style="width: 200px">Hủy</button>
                    <button type="button" class="btn btn-success create" style="width: 200px">Thêm mới</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/js/bootstrap-multiselect.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.4.2/js/all.min.js"></script>
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

         var select = $("#select_name");
         var select_type = $("#select_type");
         var selectType = '';
         var selectName =  select.selectize({
             plugins: ["restore_on_backspace"],
             maxItems: 1,
         });

        $(document).ready(function () {
            $('#price').keyup(function (event) {
                var value = $(this).val();
                value = value.replace(/^(0*)/, "");
                $(this).val(value);
                // skip for arrow keys
                if (event.which >= 37 && event.which <= 40) return;
                // format number
                $(this).val(function (index, value) {
                    return value
                        .replace(/\D/g, "")
                        .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                        ;
                });
            });

            $('.cancel').click(function (event) {
                event.preventDefault();
                console.log('1')
                Redirect("{{$cpanelUrl}}", false)
            })
            $('.list').click(function (event) {
                event.preventDefault();
                console.log('1')
                Redirect("{{$cpanelUrl}}", false)
            })
            var dateToday = new Date();
            $("#date").datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                startDate: dateToday,
            });
            $('#check_date').change(function (event) {
                event.preventDefault();
                if (this.checked) {
                    $('#date').removeAttr('disabled');
                } else {
                    $('#date').val("");
                    $('#date').attr('disabled', true);
                }
            });

            $('#multiple-checkboxes').multiselect({
                enableClickableOptGroups: true,
                enableFiltering: true,
                includeSelectAllOption: true,
                buttonWidth: '100%',
                dropRight: true,
                maxHeight: 450,
                selectAllText: 'Toàn quốc',
                nSelectedText: 'Phòng giao dịch đã chọn',
                nonSelectedText: 'Chọn khu vực áp dụng',
                allSelectedText: 'Đã chọn tất cả phòng giao dịch',
                filterPlaceholder: "Tìm kiếm",
                templates: {
                    button: '<button style="height: 40px;background: #FFFFFF;border: 1px solid #D8D8D8;border-radius: 5px;outline: none;padding: 0px 5px;width: 100% !important;" type="button" class="multiselect dropdown-toggle button_store" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span></button>'
                },
            });

            $('#motivating_goal').multiselect({
                enableClickableOptGroups: true,
                // includeSelectAllOption: true,
                buttonWidth: '100%',
                dropRight: true,
                maxHeight: 500,
                selectAllText: 'Chọn tất cả',
                nSelectedText: 'Mục tiêu thúc đẩy',
                allSelectedText: 'Đăng ký xe máy, Đăng ký ô tô, Khác',
                nonSelectedText: 'Chọn mục tiêu thúc đẩy',
                templates: {
                    button: '<button style="height: 40px;background: #FFFFFF;border: 1px solid #D8D8D8;border-radius: 5px;outline: none;padding: 0px 5px;width: 100% !important;" type="button" class="multiselect dropdown-toggle button_motivating_goal" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span></button>'
                },

            });

            $('#target_goal').multiselect({
                enableClickableOptGroups: true,
                includeSelectAllOption: true,
                buttonWidth: '100%',
                dropRight: true,
                maxHeight: 500,
                selectAllText: 'Chọn tất cả',
                nSelectedText: 'Mục tiêu triển khai',
                allSelectedText: 'Đã chọn tất cả mục tiêu triển khai',
                nonSelectedText: 'Chọn mục tiêu triển khai',
                templates: {
                    button: '<button style="height: 40px;background: #FFFFFF;border: 1px solid #D8D8D8;border-radius: 5px;outline: none;padding: 0px 5px;" type="button" class="multiselect dropdown-toggle button_target_goal" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span></button>'
                },

            });
            $('#category').multiselect({
                enableClickableOptGroups: true,
                includeSelectAllOption: true,
                buttonWidth: '100%',
                dropRight: true,
                maxHeight: 500,
                selectAllText: 'Chọn tất cả',
                nSelectedText: 'Hạng mục',
                allSelectedText: 'Đã chọn tất cả hạng mục',
                nonSelectedText: 'Chọn hạng mục',
                templates: {
                    button: '<button style="height: 40px;background: #FFFFFF;border: 1px solid #D8D8D8;border-radius: 5px;outline: none;padding: 0px 5px;width: 100% !important;" type="button" class="multiselect dropdown-toggle button_category" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span></button>'
                },

            });


            $('.upload-hidden').on('change', function () {
                var files = $(this)[0].files;
                for (let i = 0; i < files.length; i++) {
                    let file = files[i];
                    uploadImgs(file);
                }
            });

            $('#check_name').change(function (event) {
                event.preventDefault();
                if (this.checked) {
                   $('.plugin-restore_on_backspace').hide();
                   $('.plugin-autofill_disable').hide();
                    console.log('1');
                    $('#check_type').prop('checked', true);
                    $('#type').val('')
                    $('#type').attr('hidden', false)
                    $('#select_name').attr('hidden', true)
                    $('#select_name').css('border', '1px solid #D8D8D8');
                    $('#select_type').css('border', '1px solid #D8D8D8');
                    $('#name').css('border', '');
                    $('#type').css('border', '');
                    $("#select_name").val('');
                    $("#select_type").val($("#select_type option:first").val());
                    // $("#select_type").html('');
                    $("#select_type").attr('disabled', true);
                    $("#select_type").attr('hidden', true);
                    $('#name').val('')
                    $('#name').attr('hidden', false)
                } else {
                    $('.plugin-restore_on_backspace').show();
                    selectName[0].selectize.close();
                    $('#select_name').attr('hidden', false)
                    $('#select_name').css('border', '1px solid #D8D8D8');
                    $('#select_type').css('border', '1px solid #D8D8D8');
                    $('#name').css('border', '');
                    $('#type').css('border', '');
                    $('#select_name option').attr('disabled', false)
                    $('#name').val('')
                    $("#select_name").val($("#select_name option:first").val());
                    $('#name').attr('hidden', true)
                }
            })


            $('#select_name').change(function (event) {
                event.preventDefault();
                let name = $('#select_name').val();
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
                        $('#select_type').html('');
                        $(".theloading").show();
                    },
                    success: function (data) {
                        $(".theloading").hide();
                        if (data['status'] == 200) {
                            console.log(data.data)
                            if (data.data.length == 0) {
                                $('#select_type').attr('disabled', true);
                                $('#select_type').append('<option value="">' + "--Chọn loại sản phẩm--" + '</option>');
                                selectType = select_type.selectize({
                                    maxItems: 1,
                                    plugins: ["autofill_disable"],
                                });
                            } else {
                                $('#select_type').attr('disabled', false);
                                $('#select_type').append('<option value="">' + "--Chọn loại sản phẩm--" + '</option>');
                                $.each(data.data, function (key, value) {
                                    $('#select_type').append('<option value="' + value + '">' + value + '</option>');
                                });
                                selectType = select_type.selectize({
                                    maxItems: 1,
                                    plugins: ["autofill_disable"],
                                });
                            }

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
            })

            $('#check_type').change(function (event) {
                event.preventDefault();
                if (this.checked) {
                    $('.plugin-autofill_disable').hide();
                    $('#select_type').attr('hidden', true)
                    $('#type').val('')
                    $('#type').attr('hidden', false)
                } else {
                    console.log(selectType)
                    $('.plugin-autofill_disable').show();
                    // selectType[0].selectize.close();
                    $('#select_type').attr('hidden', false)
                    $('#type').val('')
                    $("#select_type").val($("#select_type option:first").val());
                    $('#type').attr('hidden', true)
                }
            })

            $('.create').click(function (event) {

                event.preventDefault();
                let category = $('select[name="category"]').val();
                let target_goal = $('select[name="target_goal"]').val();
                let motivating_goal = $('select[name="motivating_goal[]"]').val();
                let store = $('select[name="store[]"]').val()
                let date = $('#date').val();
                let name = "";
                if ($('#check_name').is(":checked")) {
                    name = $('#name').val();
                } else {
                    name = $('#select_name').val();
                }
                let type = "";
                if ($('#check_type').is(":checked")) {
                    type = $('#type').val();
                } else {
                    type = $('#select_type').val();
                }
                console.log(date);

                let price = $('#price').val();
                if (price.indexOf(',')) {
                    price = price.replace(/,/g, '');
                }
                console.log(price);
                let size = $('#size').val();
                let material = $('#material').val();
                let tech = $('#tech').val();

                let path = [];
                $("input[name='url[]']").each(function () {
                    path.push($(this).val());
                });

                // if (category == "") {
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Thông báo',
                //         text: 'Hãy chọn hạng mục',
                //         confirmButtonColor: '#dc3545',
                //         timer: 3000,
                //         position: 'top',
                //     })
                //     return;
                // } else if (target_goal == "") {
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Thông báo',
                //         text: 'Hãy chọn mục tiêu triển khai',
                //         confirmButtonColor: '#dc3545',
                //         timer: 3000,
                //         position: 'top',
                //     })
                //     return;
                // } else if (motivating_goal.length == 0) {
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Thông báo',
                //         text: 'Hãy chọn mục tiêu thúc đẩy',
                //         confirmButtonColor: '#dc3545',
                //         timer: 3000,
                //         position: 'top',
                //     })
                //     return;
                // } else if (name == "") {
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Thông báo',
                //         text: 'Hãy chọn hay nhập tên ấn phẩm',
                //         confirmButtonColor: '#dc3545',
                //         timer: 3000,
                //         position: 'top',
                //     })
                //     return;
                // } else if (type == "") {
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Thông báo',
                //         text: 'Hãy chọn hay nhập loại ấn phẩm',
                //         confirmButtonColor: '#dc3545',
                //         timer: 3000,
                //         position: 'top',
                //     })
                //     return;
                // } else if (price == "") {
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Thông báo',
                //         text: 'Hãy nhập đơn giá dự kiến',
                //         confirmButtonColor: '#dc3545',
                //         timer: 3000,
                //         position: 'top',
                //     })
                //     return;
                // } else if (size == "") {
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Thông báo',
                //         text: 'Hãy nhập kích cỡ ấn phẩm',
                //         confirmButtonColor: '#dc3545',
                //         timer: 3000,
                //         position: 'top',
                //     })
                //     return;
                // } else if (material == "") {
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Thông báo',
                //         text: 'Hãy nhập chất liệu ấn phẩm',
                //         confirmButtonColor: '#dc3545',
                //         timer: 3000,
                //         position: 'top',
                //     })
                //     return;
                // } else if (tech == "") {
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Thông báo',
                //         text: 'Hãy nhập kĩ thuật ấn phẩm',
                //         confirmButtonColor: '#dc3545',
                //         timer: 3000,
                //         position: 'top',
                //     })
                //     return;
                // } else if (store.length == 0) {
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Thông báo',
                //         text: 'Hãy chọn đầy đủ khu vực áp dụng',
                //         confirmButtonColor: '#dc3545',
                //         timer: 3000,
                //         position: 'top',
                //     })
                //     return;
                // } else if (path.length == 0) {
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Thông báo',
                //         text: 'Hãy chọn đầy đủ ảnh mô tả',
                //         confirmButtonColor: '#dc3545',
                //         timer: 3000,
                //         position: 'top',
                //     })
                //     return;
                // }

                let formData = new FormData();
                formData.append('category', category);
                formData.append('target_goal', target_goal);
                formData.append('motivating_goal', motivating_goal);
                formData.append('store', store);
                formData.append('date', date);
                formData.append('name', name);
                formData.append('type', type);
                formData.append('price', price);
                formData.append('size', size);
                formData.append('material', material);
                formData.append('tech', tech);
                formData.append('path', path);

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
                            console.log(data)
                            $(".theloading").hide();
                            Swal.fire({
                                title: 'Thông báo',
                                text: "Thêm mới thành công",
                                icon: 'success',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                cancelButtonText: 'Tiếp tục tạo',
                                confirmButtonText: 'Quay lại màn danh sách',
                                allowOutsideClick: false,
                                position: 'top',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    Redirect("{{$cpanelUrl}}", false)
                                } else if (result.dismiss === Swal.DismissReason.cancel) {
                                    window.location.reload();
                                }
                            })
                        } else if (data.status == 400) {
                            if (data.errors.target_goal) {
                                console.log(data.errors.target_goal);
                                $('.target_goal').attr('hidden', false);
                                $('.target_goal').html(data.errors.target_goal[0]);
                                $('.button_target_goal').css('border', '1px solid red');
                            } else {
                                $('.target_goal').attr('hidden', true);
                                $('.button_target_goal').css('border', '1px solid #D8D8D8');
                            }
                            if (data.errors.category) {
                                $('.category').attr('hidden', false);
                                $('.category').html(data.errors.category[0]);
                                $('.button_category').css('border', '1px solid red');
                            } else {
                                $('.category').attr('hidden', true);
                                $('.button_category').css('border', '1px solid #D8D8D8');
                            }
                            if (data.errors.motivating_goal) {
                                $('.motivating_goal').attr('hidden', false);
                                $('.motivating_goal').html(data.errors.motivating_goal[0]);
                                $('.button_motivating_goal').css('border', '1px solid red');
                            } else {
                                $('.motivating_goal').attr('hidden', true);
                                $('.button_motivating_goal').css('border', '1px solid #D8D8D8');
                            }
                            if (data.errors.name) {
                                $('.name').attr('hidden', false);
                                $('.name').html(data.errors.name[0]);
                                $('#name').css('border', '1px solid red');
                                $('#select_name').css('border', '1px solid red');
                            } else {
                                $('.name').attr('hidden', true);
                                $('#name').css('border', '');
                                $('#select_name').css('border', '1px solid #D8D8D8');
                            }
                            if (data.errors.type) {
                                $('.type').attr('hidden', false);
                                $('.type').html(data.errors.type[0]);
                                $('#type').css('border', '1px solid red');
                                $('#select_type').css('border', '1px solid red');
                            } else {
                                $('.type').attr('hidden', true);
                                $('#type').css('border', '');
                                $('#select_type').css('border', '1px solid #D8D8D8');
                            }
                            if (data.errors.price) {
                                $('.price').attr('hidden', false);
                                $('.price').html(data.errors.price[0]);
                                $('#price').css('border', '1px solid red');
                            } else {
                                $('.price').attr('hidden', true);
                                $('#price').css('border', '1px solid #D8D8D8');
                            }
                            if (data.errors.size) {
                                $('.size').attr('hidden', false);
                                $('.size').html(data.errors.size[0]);
                                $('#size').css('border', '1px solid red');
                            } else {
                                $('.size').attr('hidden', true);
                                $('#size').css('border', '1px solid #D8D8D8');
                            }
                            if (data.errors.material) {
                                console.log('1')
                                $('.material').attr('hidden', false);
                                $('.material').html(data.errors.material[0]);
                                $('#material').css('border', '1px solid red');
                            } else {
                                $('.material').attr('hidden', true);
                                $('#material').css('border', '1px solid #D8D8D8');
                            }
                            if (data.errors.tech) {
                                $('.tech').attr('hidden', false);
                                $('.tech').html(data.errors.tech[0]);
                                $('#tech').css('border', '1px solid red');
                            } else {
                                $('.tech').attr('hidden', true);
                                $('#tech').css('border', '1px solid #D8D8D8');
                            }
                            if (data.errors.store) {
                                $('.store').attr('hidden', false);
                                $('.store').html(data.errors.store[0]);
                                $('.button_store').css('border', '1px solid red');
                            } else {
                                $('.store').attr('hidden', true);
                                $('.button_store').css('border', '1px solid #D8D8D8');
                            }
                            if ($('#check_date').is(":checked") && date == "") {
                                console.log('1');
                                $('.date').attr('hidden', false);
                                $('.date').html('Ngày đến hạn của ấn phẩm không được để trống !');
                                $('#date').css('border', '1px solid red');
                            } else {
                                $('.date').attr('hidden', true);
                                $('#date').css('border', '1px solid #D8D8D8');
                            }
                            if (data.errors.path) {
                                $('.path').attr('hidden', false);
                                $('.path').html(data.errors.path[0]);
                                $('.img-area').css('border', '1px solid red');
                            } else {
                                $('.path').attr('hidden', true);
                                $('.img-area').css('border', '1px solid #D8D8D8');
                            }


                        } else {
                            console.log(data.message)
                            $(".theloading").hide();
                            Swal.fire({
                                icon: 'error',
                                title: 'Thông báo',
                                text: data.message,
                                confirmButtonColor: '#dc3545',
                                timer: 3000,
                                position: 'top',
                            })
                        }
                    },
                    error: function () {
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

        $('#call-to-action').click(function () {
            $('.upload-hidden').click();
        });

        function deleteImage(el) {
            if (confirm("Bạn có chắc chắn muốn xóa ?")) {
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

        const uploadImgs = async function (file) {
            var formData = new FormData();
            formData.append('file', file);
            console.log(file.type);
            if (file.type == 'image/jpeg' || file.type == 'image/png' || file.type == 'image/jpg') {
                //do nothing
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Thông báo',
                    text: 'File không đúng định dạng, vui lòng thử lại!',
                    confirmButtonColor: '#dc3545',
                    timer: 3000,
                    position: 'top',
                })
                return;
            }

            await $.ajax({
                dataType: 'json',
                enctype: 'multipart/form-data',
                url: '{{$urlUpload}}',
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
                        if (file.type == 'image/jpeg' || file.type == 'image/png' || file.type == 'image/jpg') {
                            let block = `
                <div class="block">
                  <img onclick="clickImg(this)" src="` + data.path + `">
                  <input type="hidden" name="url[]" value="` + data.path + `">
                  <button type="button" onclick="deleteImage(this)" class="cancelButton">
                    <i class="fa fa-times-circle"></i>
                  </button>
                </div>
                `;
                            $('#imgInput').before(block);
                        } else if (file.type == 'audio/mp3' || file.type == 'video/mp4') {
                            let block = `
                    <div class="block">
                        <video onclick="clickVideo(this)">
                            <source src="` + data.path + `">
                        </video>
                        <input type="hidden" name="url[]" value="` + data.path + `">
                        <button type="button" onclick="deleteImage(this)" class="cancelButton">
                            <i class="fa fa-times-circle"></i>
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

    </script>

@endsection

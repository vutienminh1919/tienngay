@extends('viewcpanel::layouts.master')

@section('title', 'Chỉnh sửa ấn phẩm Trade Marketing')

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/css/bootstrap-multiselect.css"
          rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.4.2/css/all.min.css" rel="stylesheet"/>
    <style type="text/css">

        input:disabled {
            background-color: #E6E6E6 !important;
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
            align-items: center
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

        .img:hover {
            opacity: 0.7;
        }

        .modal-header {
          border-bottom: none;
          margin: 0 auto;
          padding-bottom: 6px;
        }

        .modal-footer {
          border-top: none;
          padding: 0.75rem 0;
        }

        .modal-content {
          border: 1px solid #ccc;
        }
        /* moda btn */
        .modal-title {
          font-size: 1.25rem;
          font-weight: 600;
        }

        .modal-p {
          margin: 0 1rem;
          text-align: center;
        }

        .modal-body1 {
          padding-top: 0;
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


<style>
    body {
        overflow: hidden;
    }
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box !important;
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
        margin-top: 34px;
    }

    .content-title {
        width: 100%;
    }
    .content-title h5{
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 24px;
        color: #3B3B3B;
        margin: 0px;
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
        line-height: 16px;
        padding-bottom: 8px;
    }

    .content-item input,
    select {
        /*width: 100%;*/
        height: 40px;
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        outline: none;
        padding: 0px 5px;
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #676767;
    }

    .content-select {
        justify-content: flex-start;
        display: flex;
        align-items: center;
    }

    .show {
        width: 100%;
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

    .nav {
        display: flex;
        flex-direction: column;
    }

    .nav > li {
        text-decoration: none;
    }

    .multiselect-selected-text {
        color: #1D9752;
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
@endsection
@section('content')
<div id="main">
    <div id="loading" class="theloading" style="display: none;">
        <i class="fa fa-cog fa-spin fa-3x fa-fw" style="margin-bottom: 800px"></i>
    </div>
    <div class="header row">
        <h3 class="col-md-12 col-sm-12 col-xs-12">Chỉnh sửa ấn phẩm</h3>
        <small class="col-md-12 col-sm-12 col-xs-12">
            <a href="" class="list">Danh sách ẩn phẩm</a>/ <a href="#">Chỉnh sửa</a>
        </small>
    </div>
    <div class="form-container">
        <div class="content-title">
            <h5>Thông tin ấn phẩm</h5>
        </div>
        <div class="content-body row">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <div action="" class="col-lg-4 col-md-6  col-xs-12">
                <div class="content-item ">
                    <div class="form-item">
                        <label for=""> Hạng mục </label>
                    </div>
                    <input type="text" value="{{$detail['category']}}" disabled>
                </div>
            </div>
            <div action="" class="col-lg-4 col-md-6  col-xs-12">
                <div class="content-item ">
                    <div class="form-item">
                        <label for=""> Mục tiêu triển khai </label>
                    </div>
                    <input type="text" value="{{$detail['target_goal']}}" disabled>
                </div>
            </div>
            <div action="" class="col-lg-4 col-md-6  col-xs-12">
                <div class="content-item ">
                    <div class="form-item">
                        <label for=""> Mục tiêu thúc đẩy </label>
                    </div>
                    <input type="text" value="{{implode(', ',$detail['motivating_goal'])}}" disabled>
                </div>
            </div>
            <div action="" class="col-lg-4 col-md-6  col-xs-12">
                <div class="content-item ">
                    <div class="form-item">
                        <label for="">Tên sản phẩm </label>
                    </div>
                    <input type="text" id="name" name="name" disabled value="{{$detail['detail']['name']}}">
                </div>
            </div>
            <div action="" class="col-lg-4 col-md-6  col-xs-12">
                <div class="content-item ">
                    <div class="form-item">
                        <label for=""> Loại sản phẩm </label>
                    </div>
                    <input type="text" id="type" name="type" disabled value="{{$detail['detail']['type']}}">
                </div>
            </div>
            <div action="" class="col-lg-4 col-md-6  col-xs-12">
                <div class="content-item ">
                    <label for=""> Đơn giá dự kiến <span class="text-danger">*</span></label>
                    <input type="text" id="price" name="price" value="{{number_format($detail['detail']['price'])}}"
                           placeholder="Nhập đơn giá" min="0"
                           oninput="validity.valid||(value='')" onkeydown="return event.keyCode !== 69">
                </div>
                <p style="text-align: center;margin-bottom: -10px;" class="text-danger price" hidden></p>
            </div>
            <div action="" class="col-lg-4 col-md-6  col-xs-12">
                <div class="content-item ">
                    <label for=""> Kích thước </label>
                    <input type="text" id="size" name="size" disabled value="{{$detail['detail']['size']}}">
                </div>
            </div>
            <div action="" class="col-lg-4 col-md-6  col-xs-12">
                <div class="content-item ">
                    <label for=""> Chất liệu </label>
                    <input type="text" id="material" name="material" disabled value="{{$detail['detail']['material']}}">
                </div>
            </div>
            <div action="" class="col-lg-4 col-md-6  col-xs-12">
                <div class="content-item ">
                    <label for=""> Kĩ thuật </label>
                    <input type="text" id="tech" name="tech" disabled value="{{$detail['detail']['tech']}}">
                </div>
            </div>
            <div action="" class="col-lg-4 col-md-6  col-xs-12">
                <div class="content-item ">
                    <label for=""> Khu vực áp dụng <span class="text-danger">*</span></label>
                </div>
                <select id="multiple-checkboxes" name="store[]" multiple class="content-select">
                    @foreach($arrStores as $key => $item)
                        <optgroup label="{{$key}}">
                            @foreach($item as $value)
                                <option
                                    {{(in_array($value['_id'], $detail['store'])) ? "selected" : "" }} value="{{$value['_id']}}">{{$value['name']}}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                <p style="text-align: center;margin-bottom: -10px;" class="text-danger store" hidden></p>

            </div>

            <div action="" class="col-lg-4 col-md-6  col-xs-12">
                <div class="content-item" style="margin-top: 0px;">
                    <div class="item-checkbox" style="margin-top: 12px">
                        <input type="checkbox" id="check_date" style="width: 20px;height: 20px"
                               name="check_date" <?= !empty($detail['date']) ? "checked" : "" ?>>
                        <label for="check_date">Sản phẩm có ngày đến hạn</label>
                    </div>
                    <input
                        <?= !empty($detail['date']) ? "" : "disabled" ?> style="height: 40px;width: 100%;background: #FFFFFF;border: 1px solid #D8D8D8;border-radius: 5px;outline: none;padding: 0px 5px;"
                        type="text" placeholder="Chọn ngày hết hạn" id="date" name="date"
                        value="<?= !empty($detail['date']) ? date('Y-m-d', $detail['date']) : "" ?>">
                    <p style="text-align: center;margin-bottom: -10px;" class="text-danger date"></p>
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
                <p style="text-align: center;margin-bottom: -10px;" class="text-danger path" hidden></p>
            </div>

            <div action="" class="col-md-12  col-xs-12">
                <div class="content-footer">
                    <button type="button" class="btn btn-secondary cancel" style="width: 200px; background: #D8D8D8; border-color: #D8D8D8; color: #676767" href="">Hủy</button>
                    <button type="button" class="btn btn-success update" style="width: 200px; background: #1D9752;";>Lưu thông tin</button>
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


    <div class="modal fade" id="errorModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" style="height: auto !important;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Error</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p class="msg_error"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="successModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" style="height: auto !important;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Thành công</h5>
          </div>
          <div class="modal-body">
            <p class="msg_success" style="text-align: center;"></p>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection



@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/js/bootstrap-multiselect.min.js"></script>
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

            $('#price').keyup(function (event) {
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
                Redirect("{{$cpanelUrl}}", false);
            })
            $('.list').click(function (event) {
                event.preventDefault();
                console.log('1')
                Redirect("{{$cpanelUrl}}", false);
            })
            var dateToday = new Date()
            $("#date").datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                startDate: dateToday
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
                buttonWidth: '100%',
                enableFiltering: true,
                includeSelectAllOption: true,
                dropRight: true,
                selectAllText: 'Toàn quốc',
                maxHeight: 450,
                nSelectedText: 'Phòng giao dịch đã chọn',
                nonSelectedText: 'Chọn khu vực áp dụng',
                allSelectedText: 'Đã chọn tất cả phòng giao dịch',
                filterPlaceholder: "Tìm kiếm",
                templates: {
                    button: '<button style="height: 40px;background: #FFFFFF;border: 1px solid #D8D8D8;border-radius: 5px;outline: none;padding: 0px 5px; display: flex; align-items: center;" type="button" class="multiselect dropdown-toggle button_store" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span></button>'
                },
            });

            $('.upload-hidden').on('change', function () {
                var files = $(this)[0].files;
                for (let i = 0; i < files.length; i++) {
                    let file = files[i];
                    uploadImgs(file);
                }
            });

            $('.update').click(function (event) {
                event.preventDefault();
                let detail = JSON.parse('{!! json_encode($detail) !!}');
                let price = $('#price').val();
                if (price.indexOf(',')) {
                    price = price.replace(/,/g, '');
                }
                let store = $('select[name="store[]"]').val();
                let path = [];
                $("input[name='url[]']").each(function () {
                    path.push($(this).val());
                });
                let date = $('#date').val();
                console.log(date);
                if ($('#check_date').is(":checked")) {
                    if (date == "") {
                        $("#errorModal").find(".msg_error").text("Ngày đến hạn của ấn phẩm không được để trống ! ");
                        $("#errorModal").modal('show');
                        return
                    }
                } else {
                    $('#date').val("");
                    date = "";
                }
                let formData = new FormData();
                formData.append('price', price);
                formData.append('date', date);
                formData.append('store', store);
                formData.append('path', path);
                $.ajax({
                    dataType: 'json',
                    enctype: 'multipart/form-data',
                    url: '{{route('viewcpanel::trade.updateItem', ['id' => $detail['_id']])}}',
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
                            $("#successModal").find(".msg_success").text("Cập nhật thành công");
                            $("#successModal").modal('show');
                            let detailUrl = '{{$detailUrl}}';
                            Redirect(detailUrl, 2000);
                        } else {
                            console.log(data.message)
                            if (data.errors.price) {
                                $('.price').attr('hidden', false);
                                $('.price').html(data.errors.price[0]);
                                $('#price').css('border', '1px solid red');
                            } else {
                                $('.price').attr('hidden', true);
                                $('#price').css('border', '1px solid #D8D8D8');
                            }
                            if (data.errors.store) {
                                $('.store').attr('hidden', false);
                                $('.store').html(data.errors.store[0]);
                                $('.button_store').css('border', '1px solid red');
                            } else {
                                $('.store').attr('hidden', true);
                                $('.button_store').css('border', '1px solid #D8D8D8');
                            }
                            if (data.errors.path) {
                                $('.path').attr('hidden', false);
                                $('.path').html(data.errors.path[0]);
                                $('.img-area').css('border', '1px solid red');
                            } else {
                                $('.path').attr('hidden', true);
                                $('.img-area').css('border', '1px solid #D8D8D8');
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
                        }
                    },
                    error: function () {
                        $(".theloading").hide();
                        $("#errorModal").find(".msg_error").text('Cập nhật thất bại, vui lòng thử lại sau.');
                        $("#errorModal").modal('show');
                    }
                });

            })


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
                $("#errorModal").find(".msg_error").text("File không đúng định dạng, vui lòng thử lại!");
                $("#errorModal").modal('show');
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
                        $("#errorModal").find(".msg_error").text("Có lỗi xảy ra, vui lòng thử lại sau!");
                        $("#errorModal").modal('show');
                    } else {
                        $("#errorModal").find(".msg_error").text(data.msg);
                        $("#errorModal").modal('show');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $("#errorModal").find(".msg_error").text("Có lỗi xảy ra, vui lòng thử lại sau!");
                    $("#errorModal").modal('show');
                }
            });
        }

    </script>

    <script type="text/javascript">
        var imgs = JSON.parse('{!! json_encode($detail["path"]) !!}');
        const isImg = function (url) {
            return (url.match(/\.(jpeg|jpg|gif|png)$/) != null);
        }
        for (let i = 0; i < imgs.length; i++) {
            if (isImg(imgs[i].toLowerCase())) {
                let block = `
        <div class="block">
          <img onclick="clickImg(this)" src="` + imgs[i] + `">
          <input type="hidden" name="url[]" value="` + imgs[i] + `">
<button type="button" onclick="deleteImage(this)" class="cancelButton">
                    <i class="fa fa-times-circle"></i>
                  </button>
        </div>`;
                $('#imgInput').before(block);
            } else {
                let block = `
        <div class="block">
            <video onclick="clickVideo(this)">
                <source src="` + imgs[i] + `">
            </video>
            <input type="hidden" name="url[]" value="` + imgs[i] + `">
<button type="button" onclick="deleteImage(this)" class="cancelButton">
                    <i class="fa fa-times-circle"></i>
                  </button>
        </div>`;
                $('#imgInput').before(block);
            }
        }
    </script>

@endsection

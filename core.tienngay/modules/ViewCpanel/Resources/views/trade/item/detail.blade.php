@extends('viewcpanel::layouts.master')

@section('title', 'Chi tiết ấn phẩm Trade Marketing')

@section('css')
<style type="text/css">
    body {
        overflow: hidden;
    }

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

    .block img,
    video {
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
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        padding-top: 100px;
        /* Location of the box */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.9);
        /* Black w/ opacity */
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
    .modal-content,
    #caption {
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
</style>

@endsection

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    #main {
        width: 100%;
        padding: 16px;
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
        padding-bottom: 2px;
    }

    .content-item input,
    select {
        /* width: 100%; */
        height: 40px;
        background: #E6E6E6;
        ;
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

    .nav>li {
        text-decoration: none;
    }

    .pointer {
        cursor: pointer;
        text-decoration: none;
    }

    input[type="checkbox"] {
        accent-color: #1D9752;
    }

    .btn-secondary {
        background-color: #D8D8D8 !important;
        border-color: #D8D8D8 !important;
        font-style: normal;
        font-weight: 600 !important;
        font-size: 14px !important;
        line-height: 16px !important;
        color: #676767 !important;
        height: 40px;
    }

    .update {
        background-color: #1D9752 !important;
        font-style: normal;
        font-weight: 600 !important;
        font-size: 14px !important;
        line-height: 16px !important;
        height: 40px;
    }

    .btn-danger {
        background-color: #F4CDCD !important;
        border-color: #F4CDCD !important;
        font-style: normal;
        font-weight: 600 !important;
        font-size: 14px !important;
        line-height: 16px !important;
        color: #C70404 !important;
    }

    .content-title h5 {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: #3B3B3B;
    }
</style>

<div id="main">
    <div id="loading" class="theloading" style="display: none;">
        <i class="fa fa-cog fa-spin fa-3x fa-fw" style="margin-bottom: 800px"></i>
    </div>
    <div style="display: flex; margin-bottom: 34px;" class="header row">
        <div style="width: 30%; padding-right: 0;">
            <h3 style="margin-bottom: 0;" class="col-md-12 col-sm-12 col-xs-12">Xem chi tiết ấn phẩm</h3>
            <small class="col-md-12 col-sm-12 col-xs-12">
                <a href="" class="list">Danh sách ẩn phẩm</a>/ <a href="#">Chi tiết</a>
            </small>
        </div>
        <div class="header-btn" style="width: 68% ;display: flex; justify-content: right; margin-right: 16px; padding-right: 0;" >
            <button type="button" class="btn btn-secondary back" style="margin-right:5px; ">Trở về <i class="fa fa-arrow-left" aria-hidden="true"></i></button>
            <a type="button" class="btn btn-success update" href="{{route('viewcpanel::trade.editItem', ['id' => $detail['_id']])}}" style='margin-right:5px; padding: 12px 16px; color: #FFFFFF;'>Chỉnh sửa <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
            <button type="button" class="btn btn-danger" data-id="{{$detail['_id']}}" id="block" style=" padding: 12px 16px; height: 40px;">Xóa <i class="fa fa-trash-o" aria-hidden="true"></i></button>
        </div>
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
                        <label for="">Tên ấn phẩm </label>
                    </div>
                    <input type="text" id="name" name="name" disabled value="{{$detail['detail']['name']}}">
                </div>
            </div>
            <div action="" class="col-lg-4 col-md-6  col-xs-12">
                <div class="content-item ">
                    <div class="form-item">
                        <label for=""> Loại ấn phẩm </label>
                    </div>
                    <input type="text" id="type" name="type" disabled value="{{$detail['detail']['type']}}">
                </div>
            </div>
            <div action="" class="col-lg-4 col-md-6  col-xs-12">
                <div class="content-item ">
                    <label for=""> Đơn giá dự kiến </label>
                    <input type="text" id="price" name="price" disabled value="{{number_format($detail['detail']['price'])}}">
                </div>
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
                    <label for=""> Khu vực áp dụng </label>
                    <a class="pointer" style="height: 40px;background: #FFFFFF;border: 1px solid #D8D8D8;border-radius: 5px;outline: none;padding: 7px 5px;text-align: inherit;color: #1D9752
" data-bs-toggle="modal" data-bs-target="#exampleModal1">{{$countStore . " " . 'phòng giao dịch'}}</a>
                </div>

            </div>

            <div action="" class="col-lg-4 col-md-6  col-xs-12" <?= !empty($detail['date']) ? "" : 'style="display:none"' ?>>
                <div class="content-item ">
                    <label for="">Ngày hết hạn</label>
                    <input disabled type="text" id="date" name="date" value="{{!empty($detail['date']) ? date('d/m/Y', $detail['date']) : ""}}">
                </div>

            </div>

            <div class="form-group">
                <label for="upload" class="col-form-label">Ảnh mô tả </label>
                <div class="img-area">
                    <div id="imgInput"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ấn phẩm: {{$detail['item_id']}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="max-height: 500px">
                    <ul class="nav">
                        @foreach($detail['store'] as $key => $item)
                        <li id="">{{$key}}
                            <ul>
                                @foreach($item as $i)
                                <li>{{$i['name']}}</li>
                                @endforeach
                            </ul>
                        </li>
                        @endforeach
                    </ul>
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


    <div class="modal fade" id="errorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
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

    <div class="modal fade" id="successModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
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

    $('.back').click(function(event) {
        event.preventDefault();
        console.log('1')
        Redirect("{{$cpanelUrl}}", false);
    });
    $('.list').click(function(event) {
        event.preventDefault();
        console.log('1')
        Redirect("{{$cpanelUrl}}", false);
    });
    $(".update").on('click', function(e) {
        e.preventDefault();
        let targetLink = $(e.target).attr('href');
        Redirect(targetLink, false);
    });

    $(document).ready(function() {
        $('#block').click(function(event) {
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
                        beforeSend: function() {
                            $('#type').html('');
                            $(".theloading").show();
                        },
                        success: function(data) {
                            $(".theloading").hide();
                            if (data['status'] == 200) {
                                console.log(data)
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thông báo',
                                    text: "Xóa thành công",
                                    confirmButtonColor: '#3085d6',
                                    timer: 3000,
                                    position: 'top',
                                })
                                Redirect("{{$cpanelUrl}}", false);

                            } else if (typeof(data) == "string") {
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
                        error: function(jqXHR, textStatus, errorThrown) {
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
    });
    var imgs = JSON.parse('{!! json_encode($detail["path"]) !!}');
    const isImg = function(url) {
        return (url.match(/\.(jpeg|jpg|gif|png)$/) != null);
    }
    for (let i = 0; i < imgs.length; i++) {
        if (isImg(imgs[i].toLowerCase())) {
            let block = `
        <div class="block">
          <img onclick="clickImg(this)" src="` + imgs[i] + `">
          <input type="hidden" name="url[]" value="` + imgs[i] + `">
        </div>`;
            $('#imgInput').before(block);
        } else {
            let block = `
        <div class="block">
            <video onclick="clickVideo(this)">
                <source src="` + imgs[i] + `">
            </video>
            <input type="hidden" name="url[]" value="` + imgs[i] + `">
        </div>`;
            $('#imgInput').before(block);
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

    const closeModal = function(el) {
        console.log("close");
        $(el).closest('.modal').hide();
    }
</script>

@endsection
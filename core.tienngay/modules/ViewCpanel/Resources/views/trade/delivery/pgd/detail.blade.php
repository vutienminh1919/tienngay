@extends('viewcpanel::layouts.master')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" rel="stylesheet"/>
<style type="text/css">
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .wrapper {
        width: 100%;
    }

    .header-details {
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
    }

    .header-btn {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .body-box1 {
        width: 100%;
        background: #FFFFFF;
        border: 1px solid #F0F0F0;
        border-radius: 8px;
        padding: 24px;
        margin-top: 24px;
    }

    .box1-title h3 {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
    }

    .box1-form-ip {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-top: 6px;
    }

    .box1-form-ip label {
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        display: flex;
        align-items: center;
        color: #3B3B3B;
    }

    .box1-form-ip input {
        height: 40px;
        background: #E6E6E6;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        outline: none;
        padding: 5px;
        color: #676767;
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
    }

    .box1-form-img {
        width: 285px;
        height: 188px;
        display: flex;
        flex-direction: column;
        gap: 10px;

    }

    .box1-form-img img {
        width: 100%;
        height: 180px
    }



    .box1-form-img label {
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #676767;
    }

    .box1-form-textarea textarea {
        width: 100%;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        padding: 16px;
        height: 100px;
        background: #E6E6E6;
    }

    .box1-form-ip a {
        text-align:left;
    }

    .form-upload {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .modal-btn button {
        width: 100%;
    }

    .modal-form {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .modal-form h5 {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: #3B3B3B;
    }

    .form-upload label {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #3B3B3B;
    }



    @media screen and (max-width:45em) {
        .header-details {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 0px 24px;
        }

        .header-title {
            width: 100%;
        }

        .header-btn {
            width: 100%;
            display: flex;
            justify-content: flex-start;
        }

        .body-box1 {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .box1-form-img {
            width: 288px;
            height: 200px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 10px;
        }
    }

    /* table*/
    @media only screen and (min-width:46em) and (max-width:63.9375em) {
        .box1-form-img {
            width: 200px !important;
            height: 188px !important;
            display: flex;
            flex-direction: column;
            gap: 10px;

        }
    }
  
    .countImg {
        color: white;
        font-weight: bold;
        position: absolute;
        top: 55%;
        left: 45%;
        transform: translate(-50%, -50%);
        z-index: 2;
    }
    .img-area {
        border: solid 1px #D8D8D8;
        border-radius: 5px;
        padding: 3px;
        /*margin-bottom: 10px;*/
        position: relative;
        height: 205px;
    }
    .is-animated {
        width:100%;
        height:1000px;
    }
    .swal2-popup {
            bottom: 55%;
        }
    .modal-dialog {
        top: 10%;
    }
    .modal-dialog-centered {
        top: -30%;
    }
    .img-area {
        border: solid 1px #D8D8D8;
        border-radius: 5px;
        padding: 3px;
        /*margin-bottom: 10px;*/
        position: relative;
        height: auto;
    }
    .form-ip span {
        font-style: normal;
        font-weight: 400;
        font-size: 10px;
        line-height: 12px;
        color: #676767;
    }
    /* .form-ip {
        display: flex;
        flex-direction: column;
        gap: 8px;
        padding-top: 8px;
    } */
    .form-ip {
        display: flex;
        flex-direction: column;
        gap: 4px;
        padding-top: 10px;
    }
    .cancelButton {
          -moz-appearance: none;
          -webkit-appearance: none;
          top: -3px;
          right: 3px;
          color: #000;
          text-align: center;
          font-weight: 700;
          background-color: transparent;
          padding: 0;
          margin: 0;
          border: 0;
          font-size: 16px;
          right: -8px;
          top: -8px;
          line-height: 15px;
          border-radius: 100%;
          background-color: #fff;
          position: inherit;
      }
</style>
@endsection
@section('content')
<section id="xk_details">
    <div class="wrapper">
        <div class="header-details">
            <div class="header-title">
                <h3>Chi tiết xuất ấn phẩm</h3>
                <small>
                    <a class="redirect" style="text-decoration:none;" href="{{route('viewcpanel::warehouse.pgdIndex')}}"><i class="fa fa-home "></i> Home</a> / 
                    <a class="redirect" style="text-decoration:none;" href='{{route("viewcpanel::warehouse.pgdDetail", ["id" => $detail->_id])}}'>Chi tiết xuất ấn phẩm</a>
                </small>
            </div>
            <div class="header-btn">
                <a href="{{route('viewcpanel::warehouse.pgdIndex')}}" type="button" class="btn btn redirect" style="background-color:#D8D8D8; color:#676767">Trở về <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                <button type="button" class="btn btn" style="background-color:#1D9752; color:#FFFFFF" data-bs-toggle="modal" data-bs-target="#exampleModal">Upload chứng từ <i class="fa fa-upload" aria-hidden="true"></i></button>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="modal-form">
                                    <h5 style="text-align: center;">Upload chứng từ</h5>
                                    <div class="col-accept">
                                        <div class="col-md-12">
                                            <div class="form-ip">
                                                <p>Chứng từ <label for="" class="star">*</label></p>
                                                <div class="img-area">
                                                    <div id="imgInput"></div>
                                                    <span type="button" style="height:30px; color:#B8B8B8; width:100%;" class="upload btn btn-default btn-lg" id="call-to-action"></span>
                                                    <span class="file-button"><i style="position: absolute;right: 10px; padding-top:10px;"class="fa fa-upload upload" aria-hidden="true"></i></span>
                                                    <div id="drop">
                                                        <input type="file" name="imgs" hidden multiple multiple class="upload-hidden">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-btn row">
                                        <div class="col-lg-6 col-md-6 col-xs-12">
                                            <button id="confirm_upload_image" type="button" class="btn btn-success" data-bs-dismiss="modal">Xác nhận</button>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-xs-12">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="body-box1">
            <div class="box1-title">
                <h3>Thông tin chung</h3>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-xs-12">
                    <div class="box1-form-ip">
                        <label>Người tạo</label>
                        <input disabled type="text" value="{{$detail['created_by']}}" />
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-xs-12">
                    <div class="box1-form-ip">
                        <label>Ngày tạo</label>
                        <input style="color:#676767;" disabled type="text" value="{{date('Y-m-d H:i:s', $detail['created_at'])}}" />
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-xs-12">
                    <div class="box1-form-ip">
                        <label>Chứng từ</label>
                        @if (count($detail['license']) == 0)
                        <input style="background-color:#F4CDCD; color:#C70404; border:solid #D8D8D8; font-weight: bold;" disabled type="text" value="Thiếu chứng từ"/>
                        @else
                        <a data-bs-toggle="modal" 
                            data-bs-target="#staticBackdrop"
                            style="height:40px;border:1px solid #D8D8D8; background-color:#E6E6E6" href="" class="text-success btn btn lisence">Xem chứng từ</a>
                        @endif
                        <div id="imgInput" class="block">

                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-xs-12">
                    <div class="box1-form-ip">
                        <label>Phòng giao dịch</label>
                        <input style="color:#676767;" disabled type="text" value="{{$detail['stores']['name']}}" />
                    </div>
                </div>
            </div>
        </div>
        <div class="body-box1">
            <div class="box1-title">
                <h3>Danh sách ấn phẩm</h3>
            </div>
            @foreach($detail['list'] as $k => $item)
            <div class="body-box1">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-xs-12">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-xs-12">
                                <div class="box1-form-ip">
                                    <label>Hạng mục</label>
                                    @foreach ($category as $key => $i)
                                        @if ($key == $item['category'])
                                            <input type="text" value="{{$i}}"/>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-xs-12">
                                <div class="box1-form-ip">
                                    <label>Mục tiêu triển khai</label>
                                    @foreach ($tagets as $key => $i)
                                        @if ($key == $item['taget_goal'])
                                            <input type="text" value="{{$i}}"/>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-xs-12">
                                <div class="box1-form-ip">
                                    <label>Tên ấn phẩm</label>
                                    <input type="text" value="{{$item['name_item']}} - {{$item['type']}} - {{str_replace(',' ,', ' , $item['specification'])}}"/>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-xs-12">
                                <div class="box1-form-ip">
                                    <label>Số lượng</label>
                                    <input type="text" value="{{$item['amount']}}"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-xs-12">
                        <div class="box1-form-img">
                            <label>Ảnh mô tả</label>
                            @if (count($item['path']) > 0)
                            <div class="img-area">
                                <img style="filter: brightness(50%);-webkit-filter: brightness(50%);" src="{{$item['path'][0]}}" alt="" class="underline cursor-pointer" data-fancybox-trigger="gallery-{{$item['data_id']}}">
                                <div style="display:none">
                                    @foreach($item['path'] as $i)
                                        <a data-fancybox="gallery-{{$item['data_id']}}" href="{{$i}}"><img class="rounded" src="{{$i}}"></a>
                                    @endforeach
                                </div>
                                <h5 data-fancybox-trigger="gallery-{{$item['data_id']}}" class="underline cursor-pointer xt countImg">+{{count($item['path'])}}</h5>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="body-box1">
            <div class="box1-title">
                <h3>Ghi chú</h3>
            </div>
            <div class="box1-form-textarea">
                <textarea disabled>{{$detail['note']}}</textarea>
            </div>
        </div>
    </div>
<!-- Modal -->
<div class="modal fade" id="modalLisence" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Chứng từ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body show_pgd">
        @if (count($detail['license']) > 0)
            <img style="width: 100%; height: 200px; filter: brightness(50%);-webkit-filter: brightness(50%);" src="{{$detail['license'][0]}}" alt="" class="underline cursor-pointer" data-fancybox-trigger="gallery">
            <div style="display:none">
                @foreach($detail['license'] as $i)
                    <a data-fancybox="gallery" href="{{$i}}"><img class="rounded" src="{{$i}}"></a>
                @endforeach
            </div>
            <h5 style="top: 46%;position: absolute;left: 46%; color: white;font-weight: bold;" data-fancybox-trigger="gallery" class="underline cursor-pointer xt countImg">+{{count($detail['license'])}}</h5>
        @endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="errorModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
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
</section>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        const csrf = "{{ csrf_token() }}";
        $('input[type=file]').on('change', function () {
            var files = $(this)[0].files;
            for(let i = 0; i < files.length; i++) {
                let file = files[i];
                uploadImgs(file);
            }
          
        });
        const uploadImgs = async function (file) {
        var formData = new FormData();
        formData.append('file', file);
        formData.append('_token', csrf);
        var mine = ['image/jpeg', 'image/png', 'image/jpg'];
        if(mine.includes(file.type)) {

        } else {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Chứng từ chỉ upload sai định dạng, vui lòng thử lại!',
                    showConfirmButton: true,
                    timer: 2500
                });
                $("input[name='url[]']").val("");
                $('#confirm_upload_image').attr('disabled', false);
                console.log($("input[name='url[]']").val(""));
                return;
        }
        console.log("here");
        await $.ajax({
            dataType: 'json',
            enctype: 'multipart/form-data',
            url: '{{route("viewcpanel::warehouse.uploadLisence")}}',
            type: 'POST',
            data: formData,
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            success: function (data) {
                if (data && data.code == 200) {
                  console.log(data)
                  if (file.type == 'image/jpeg' || file.type == 'image/png' || file.type == 'image/jpg') {
                    let block = `
                    <div class="block" style="width:100%; border:none;">
                        <a target="_blank" style="font-size:14px;text-decoration: none " href="` + data.path + `">` + data.raw_name + ` </a>
                        <input data-fileType ="` + file.type +`" data-fileName = "`+ data.raw_name + `" multiple type="hidden" name="url[]" id="url" value="` + data.path + `">
                        <button type="button" onclick="deleteImage(this)" class="cancelButton">
                          <i class="fa fa-times-circle"></i>
                        </button>
                    </div>
                      `;
                    $('#imgInput').before(block);
                  }
                if (typeof(data) == "string") {
                  $("#errorModal").find(".msg_error").text(data);
                  $("#errorModal").modal('show');
                }
            }
          }
        });
      }
        $("#confirm_upload_image").on('click', function() {
                var inputimg = $('#lisence').val();
                if (inputimg == '') {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Không có chứng từ upload',
                        showConfirmButton: true,
                        // timer: 2500
                    });
                    return;
                }
                $(".modal-content").modal('hide');
                let type = {};
                console.log($("input[name='url[]']"));
                $("input[name='url[]']").each(function (key, value) {
                  let url = $(this).val();
                  type[key] = url;
                });
                var files = $("input[type=file]")[0].files.length;
                console.log(files);
                console.log( Object.keys(type).length)
                if (files !=  Object.keys(type).length) {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Vui lòng kiểm tra lại những file upload!',
                        showConfirmButton: true,
                        timer: 2500
                    });
                    return;
                }
                console.log(type);
                let formData = new FormData();
                formData.append('_token', csrf);
                formData.append('path', JSON.stringify(type));
                $.ajax({
                    dataType: 'json',
                    enctype: 'multipart/form-data',
                    url: '{{route("viewcpanel::warehouse.updateLisence", ["id" => $detail["_id"]])}}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        console.log(data);
                        if (data['status'] == 200) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Upload chứng từ thành công',
                                showConfirmButton: false,
                                timer: 2500
                            });
                            setTimeout(function(){
                                window.location.assign("{{route('viewcpanel::warehouse.pgdDetail', ['id' => $detail['id']])}}");
                            }, 2500);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $("#errorModal").find(".msg_error").text(jqXHR.responseText);
                        $("#errorModal").modal('show');
                    }
                });
            })
    });
</script>
<script>
    $(document).ready(function() {
        $(".lisence").click(function() {
            $("#modalLisence").modal('show');
        });
        $("img").click(function() {
            $("#modalLisence").modal('hide');
        });
        $("img").click(function() {
            $("#modalLisence").modal('hide');
        })
    });
    $('#call-to-action, .upload').click(function () {
            $('.upload-hidden').click();
        });
    const closeModal = function(el) {
        console.log("close");
        $(el).closest('.modal').hide();
    }

    function deleteImage(el) {
        if (confirm("Bạn có chắc chắn muốn xóa ?")){
        $(el).closest(".block").remove();
        $('#imgInput').find('[type="file"]').first().val('');
        }
    }
    $('a.redirect').on('click', (e) => {
        e.preventDefault();
        let url = $(e.target).attr('href');
        Redirect(url, false);
    })
</script>
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
@endsection
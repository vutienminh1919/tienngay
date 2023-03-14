@extends('viewcpanel::layouts.master')

@section('title', 'Phiếu Giao Đồng Phục Tài Xế HeyU')

@section('css')
<style type="text/css">
  .main-content {
    font-family: 'Roboto';
    font-style: normal;
    color: #3B3B3B;
  }
  .tilte_top {
    margin-top: 50px;
    font-size: 20px;
    font-weight: 600;
  }
  label, input, select, .time-value {
    color: #676767 !important;
    font-size: 14px !important;
    font-weight: 400 !important;
    display: block;
  }
  .inline-block {
    display: inline-block;
  }
  .invalid {
    color: red;
  }
  .invalid-input {
    border-color: red !important;
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

  .modal-backdrop {
      display: none !important;
  }

  .img:hover {opacity: 0.7;}

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
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
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
    from {transform:scale(0)}
    to {transform:scale(1)}
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
  @media only screen and (max-width: 700px){
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

@section('content')
<section class="main-content">
  <div id="loading" class="theloading" style="display: none;">
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
  </div>
  <div class="container">
    <h5 class="tilte_top">Tạo phiếu xuất kho</h5>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{$cancelPath}}">Quản lý kho</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tạo phiếu xuất kho</li>
      </ol>
    </nav>
    <form id="form-create" method="post" action="{{$createBill}}">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="form-group row">
        <div class="col-sm">
          <label for="pgd" class="col-form-label">Phòng giao dịch</label>
          <select id="pgd" name="pgd" class="form-control" is-require="require">
              <option value="">-- Chọn PGD --</option>
              @foreach ($stores as $store)
                  @if(!in_array($store['_id'], $pgd_active))
                      @continue;
                  @endif
                  <option value="{{ $store['_id'] }}">{{ $store['name'] }}</option>
              @endforeach
          </select>
        </div>
        <div class="col-sm">
          <label for="driver_code" class="col-form-label">Mã tài xế</label>
          <input id="driver_code" type="text" class="form-control" is-require="require"  name="driver_code" oninput="this.value = this.value.toUpperCase()" placeholder="Nhập...">
          <span id="driver_message" class="invalid"></span>
        </div>
        <div class="col-sm">
          <label for="driver_name" class="col-form-label">Tên tài xế</label>
          <input id="driver_name" type="text" class="form-control" is-require="require" name="driver_name" placeholder="..." disabled>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm col-sm-4">
          <label for="coat" class="col-form-label">Áo khoác</label>
          <select id="coat" class="form-control" name="coat" is-require="require">
            <option value="" selected>Chọn size</option>
            <option value="s">S</option>
            <option value="m">M</option>
            <option value="l">L</option>
            <option value="xl">XL</option>
            <option value="xxl">XXL</option>
            <option value="xxxl">XXXL</option>
          </select>
        </div>
        <div class="col-sm col-sm-4">
          <label for="shirt" class="col-form-label">Áo phông</label>
          <select id="shirt" class="form-control" name="shirt" is-require="require">
            <option value="" selected>Chọn size</option>
            <option value="s">S</option>
            <option value="m">M</option>
            <option value="l">L</option>
            <option value="xl">XL</option>
            <option value="xxl">XXL</option>
            <option value="xxxl">XXXL</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="upload" class="col-form-label">Upload chứng từ</label>
        <div class="img-area">
          <div id="imgInput"></div>
          <a type="button" class="upload btn btn-default btn-lg" id="call-to-action"> Thêm hình ảnh
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-plus" viewBox="0 1 10 15">
              <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
            </svg>
          </a>
          <div id="drop">
            <input type="file" name="imgs" multiple  multiple class="upload-hidden">
          </div>
        </div>
        <span id="invalid-img" class="invalid"></span>
      </div>
      <div class="form-group">
        <button id="cancel" type="submit" class="btn btn-primary inline-block submit">Hủy</button>
        <button id="create" type="submit" class="btn btn-primary inline-block submit">Tạo phiếu xuất kho</button>
      </div>
    </form>

    <div class="modal fade" id="confirm-form" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Xác nhận thông tin</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="form-group row">
              <div class="col-sm-4">
                <label class="col-form-label fw-600">Phòng Giao Dịch</label>
              </div>
              <div class="col-sm-8">
                <label class="col-form-label value-confirm" data-attr="pgd"></label>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-4">
                <label class="col-form-label fw-600">Mã Tài Xế</label>
              </div>
              <div class="col-sm-8">
                <label class="col-form-label value-confirm" data-attr="driver_code"></label>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-4">
                <label class=" col-form-label fw-600">Tên Tài Xế</label>
              </div>
              <div class="col-sm-8">
                <label class="col-form-label value-confirm" data-attr="driver_name"></label>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-4">
                <label class="col-form-label fw-600">Áo Phông</label>
              </div>
              <div class="col-sm-8">
                  <label class="col-form-label value-confirm" data-attr="shirt" style="text-transform: uppercase;"></label>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-4">
                <label class="col-form-label fw-600">Áo Khoác</label>
              </div>
              <div class="col-sm-8">
                <label class="col-form-label value-confirm" data-attr="coat" style="text-transform: uppercase;"></label>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button id="confirmed" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Xác nhận</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="errorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
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

  <div class="modal fade" id="successModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Thành công</h5>
        </div>
        <div class="modal-body">
          <p class="msg_success"></p>
        </div>
        <div class="modal-footer">
          <a id="redirect-url" class="btn btn-primary">Xem</a>
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

</section>
@endsection

@section('script')
<script type="text/javascript">

  $(document).ajaxStart(function() {
  $("#loading").show();
  var loadingHeight = window.screen.height;
  $("#loading, .right-col iframe").css('height', loadingHeight);
  }).ajaxStop(function() {
    $("#loading").hide();
  });

  var _token = $("[name='_token']").val();
  var dp = $('#delivery_date').datepicker( {
        format: "yyyy-mm-dd",
        startView: "days",
        minViewMode: "days",
        autoclose: true
    });

  $('#driver_code').on('change', function() {
    $('#driver_name').val("");
    $("#driver_message").text('');
    let url = "{!! $findDriverInfoUrl !!}";
    let code = $(this).val();
    $.ajax({
        type: "POST",
        url: url,
        data: {_token: _token, code : code}, // serializes the form's elements.
        success: function(data) {
            console.log(data);
            if (data['status'] != 200) {
              $("#driver_message").text(data['message']);
            }
            if (data['data']['name']) {
              $("#driver_name").val(data['data']['name']);
            }
        }
     });
  });

  $('#call-to-action').click(function() {
    $('.upload-hidden').click();
  });

  $(document).ready(function () {
    $('.upload-hidden').on('change', function () {
      var files = $(this)[0].files;
      for(let i = 0; i < files.length; i++) {
          let file = files[i];
          uploadImgs(file);
      }
    });
  });

  function deleteImage(el) {
    if (confirm("Bạn có chắc chắn muốn xóa ?")){
      $(el).closest(".block").remove();
      $('#drop').find('[type="file"]').first().val('');
    }
  }

  const uploadImgs = async function (file) {
    var formData = new FormData();
    formData.append('file', file);
    formData.append('_token', _token);
    console.log(file.type);
    if (file.type == 'image/jpeg' || file.type == 'image/png' || file.type == 'image/jpg' || file.type == 'audio/mp3' || file.type == 'video/mp4') {
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
                } else if(file.type == 'audio/mp3' || file.type == 'video/mp4'){
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

            } else if (typeof(data) == "string") {
              $("#errorModal").find(".msg_error").text(data);
              $("#errorModal").modal('show');
            } else {
              $("#errorModal").find(".msg_error").text(data.msg);
              $("#errorModal").modal('show');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          $("#errorModal").find(".msg_error").text("Có lỗi xảy ra, vui lòng thử lại sau!");
          $("#errorModal").modal('show');
        }
    });
  }

  function clickImg(el) {
    var modal = document.getElementById("imgModal");
    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    modal.style.display = "block";
    modalImg.src = el.src;
  }
  function clickVideo(el) {
    var targetLink = $(el).find("source").first().attr('src');
    window.open(targetLink);
  }
  // Get the <span> element that closes the modal
  // When the user clicks on <span> (x), close the modal
  const closeModal = function(el) {
    console.log("close");
    $(el).closest('.modal').hide();
  }
  const checkRequire = function (_form) {
    $(".invalid-input").removeClass("invalid-input");
    $(".invalid-message").remove();
    $("#invalid-time").text("");
    $("#invalid-img").text("");
    var form = $('#' + _form);
    let invalid = false;
    form.find('input, textarea, select').each(function(){
        let isRequire = $(this).attr("is-require");
        let val = $.trim($(this).val());
        if (isRequire && val == "") {
          $(this).addClass('invalid-input');
          $(this).after('<span class="invalid invalid-message">Trường này không được để trống.</span>');
          invalid = true;
        }
    });
    if ($("[name='url[]']").length < 1) {
      $("#invalid-img").text("Bắt buộc phải upload chứng từ");
      invalid = true;
    }
    return invalid;
  }

  const modalConfirm = function (modal) {
    $("#" + modal).find('.value-confirm').each(function(){
      let inputName = $(this).attr('data-attr');
      console.log(inputName);
      if (inputName == 'pgd') {
        $(this).text($("#" + inputName + " option:selected").text());
      }else {
        $(this).text($("#" + inputName).val());
      }

    })
  }
  $("#create").on('click', function(e) {
    e.preventDefault();
    $("#create").prop('disabled', true);
    let invalid = checkRequire('form-create');
    if (invalid) {
      $("#create").prop('disabled', false);
      return;
    }
    modalConfirm('confirm-form');
    $("#confirm-form").modal('show');
    $("#create").prop('disabled', false);
  });

  $("#cancel").on('click', function(e) {
    e.preventDefault();
    window.parent.postMessage({targetLink: "{{$cancelPath}}"}, "{{$cpanelPath}}");
  })

  $("#confirmed").on('click', function(e) {
    $("#driver_name").removeAttr('disabled');
    let form = $("#form-create");
    var url = form.attr('action');
    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(), // serializes the form's elements.
        success: function(data) {
            console.log(data);
            if (data['status'] == 200) {
              $("#successModal").find(".msg_success").text("Tạo phiếu xuất kho thành công.");
              $("#successModal").find("#redirect-url").attr("href", data['targetUrl']);
              $("#successModal").modal('show');
            } else {
              if (data && data['message']) {
                $("#errorModal").find(".msg_error").text(data['message']);
              } else {
                $("#errorModal").find(".msg_error").text("Có lỗi xảy ra, vui lòng thử lại sau!");
              }

              $("#errorModal").modal('show');
            }
        }
     }).done(function() {
      $("#driver_name").attr('disabled', 'disabled');
     });
  });

  $(".breadcrumb-item").on('click', function(e) {
    e.preventDefault();
    let targetLink = $(e.target).attr('href');
    if (targetLink == "" || targetLink == undefined) {
      return;
    }
    window.parent.postMessage({targetLink: targetLink}, "{{$cpanelPath}}");
  });

</script>
@endsection

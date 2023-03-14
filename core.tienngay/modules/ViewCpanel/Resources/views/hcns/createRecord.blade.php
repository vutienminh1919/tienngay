@extends('viewcpanel::layouts.master')
@section('title', 'Thêm Mới Thông Tin Nhân Sự Nghỉ Việc')
@section('css')
    <style type="text/css">
        /* Style the Image Used to Trigger the Modal */
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
        .box {
            display: inline-block;
            width: 55px;
            height: 55px;
            background-color: white;
            border: 3px dashed #B5B5B5;
            color: #B5B5B5;
            font-size: 30px;
            text-align: center;
        }
        .block {
            position: relative;
            display: inline-block;
            vertical-align: top;
            width: 75px;
            height: 75px;
            padding: 9px;
            margin-right: 15px;
            margin-bottom: 35px;
            background-color: #fff;
            border: 1px solid #ccc;
            margin-right: 10px;
        }
        .cancelButton {
          -moz-appearance: none;
          -webkit-appearance: none;
          position: absolute;
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
          background-color: #fff
      }
      .block img, video{
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 100%;
        max-height: 100%;
      }

      label {
        font-weight: 500;
      }
      .row div {
        margin-bottom: 25px;
      }
      .main-content {
        width: 90%;
        margin: 0 auto;
      }
      @media (min-width:768px) {
          #mainForm {
            padding-left:50px;
          }
      }

      legend {
        padding-bottom: 10px;
        border-bottom: 1px solid #dee2e6;
        margin-bottom: 50px;
        margin-top: 30px;
        color: #009535;
        font-weight: 500;
        text-shadow: rgba(17, 17, 26, 0.3) 0px 4px 16px, rgba(17, 17, 26, 0.1) 0px 8px 24px, rgba(17, 17, 26, 0.1) 0px 16px 56px;
      }
    </style>
@endsection
@section('content')
<section class="main-content">
  <div class="create_record">
    <div id="loading" class="theloading" style="display: none;">
      <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    </div>
    @if(session('status'))
    <div class="alert alert-success">
      {{session('status')}}
    </div>
  @endif
  </div>
  <legend class="col-md-6">
    Thêm Mới Thông Tin Nhân Sự Nghỉ Việc
  </legend>
  <div class="new_report">
  @if(session('status'))
  <div class="alert alert-success">
      {{session('status')}}
  </div>
  @endif
  </div>
  <form id="mainForm" action='{{$saveRecord}}' method="post" enctype="multipart/form-data">
    <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}">
    <div class="row col-md-12 col-lg-8">
      <div class="col-md-6 col-sm-6">
        <label for="user_name" class="form-label">Họ và tên&nbsp;<span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="user_name" name="user_name">
      </div>
      <div class="col-md-6 col-sm-6">
        <label for="user_phone" class="form-label">Số điện thoại&nbsp;</label>
        <input type="text" class="form-control" id="user_phone" name="user_phone">
      </div>
      <div class="col-md-6 col-sm-6">
        <label for="user_identify" class="form-label">Số Cmnd/cccd&nbsp;<span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="user_identify" name="user_identify">
      </div>
      <div class="col-md-6 col-sm-6">
        <label for="user_identify" class="form-label">Số hộ chiếu&nbsp;</label>
        <input type="text" class="form-control" id="user_passport" name="user_passport">
      </div>
      <div class="col-md-6 col-sm-6">
        <label for="date_range" class="form-label">Ngày cấp&nbsp;</label>
        <input type="text" class="form-control" id="date_range" name="date_range">
      </div>
      <div class="col-md-6 col-sm-6">
        <label for="issued_by" class="form-label">Nơi cấp&nbsp;</label>
        <input type="text" class="form-control" id="issued_by" name="issued_by">
      </div>
      <div class="col-md-6 col-sm-6">
        <label for="user_email" class="form-label">Email cá nhân&nbsp;</label>
        <input type="text" class="form-control" id="user_email" name="user_email">
      </div>
      <div class="col-md-6 col-sm-6">
        <label for="temporary_address" class="form-label">Địa chỉ tạm trú&nbsp;</label>
        <input type="text" class="form-control" id="temporary_address" name="temporary_address">
      </div>
      <div class="col-md-6 col-sm-6">
        <label for="permanent_address" class="form-label">Địa chỉ thường trú&nbsp;</label>
        <input type="text" class="form-control" id="permanent_address" name="permanent_address">
      </div>
      <div class="col-md-6 col-sm-6">
        <label for="day_on" class="form-label">Ngày bắt đầu&nbsp;</label>
        <input type="text" class="form-control" id="day_on" name="day_on">
      </div>
      <div class="col-md-6 col-sm-6">
        <label for="day_off" class="form-label">Ngày nghỉ việc&nbsp;</label>
        <input type="text" class="form-control" id="day_off" name="day_off">
      </div>
      <div class="col-md-6 col-sm-6">
        <label for="work_place" class="form-label">Địa điểm làm việc&nbsp;</label>
        <input type="text" class="form-control" id="work_place" name="work_place">
      </div>
      <div class="col-md-6 col-sm-6">
        <label for="room" class="form-label">Phòng ban&nbsp;</label>
        <input type="text" class="form-control" id="room" name="room">
      </div>
      <div class="col-md-6 col-sm-6">
        <label for="position" class="form-label">Chức vụ&nbsp;</label>
        <input type="text" class="form-control" id="position" name="position">
      </div>
      <div class="col-md-6 col-sm-6">
        <label for="reason_for_leave" class="form-label">Lý do nghỉ việc&nbsp;</label>
        <textarea type="text" class="form-control" id="reason_for_leave" name="reason_for_leave"></textarea>
      </div>
      <div class="row" id="url">
        <label  class="form-label" style="font-style: 18px">Đính kèm ảnh hoặc video</label>
        <div class="img" id="img">
          <div id="imgInput" class="block">
            <label for="file"><div class="box">+</div></label>
            <input type="file" id="file" name="file" style="display: none;" multiple="multiple">
          </div>
        </div>
      </div>
    </div>
  </form>
  <div class="modal-footer" style="border-top: 2px solid #dee2e6">
    <div style="margin-top:10px;">
      <button id="typeCreate" type="submit" class="btn btn-success">Tạo mới</button>
        <a class="btn btn-danger" href='{{url("/cpanel/hcns/listRecord")}}' style="margin-right: 50px">
          Quay lại
        </a>
    </div>
  </div>
  <div class="modal fade" id="errorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Có Lỗi Xảy Ra</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p class="msg_error"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
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
          <p class="msg_success text-success"></p>
        </div>
        <div class="modal-footer">
          <a id="redirect-url" class="btn btn-success">Xem</a>
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
<script type="text/javascript" src="{{ asset('viewcpanel/js/autocomplete.js') }}"></script>
<script type="text/javascript">
    $(document).ajaxStart(function() {
    $("#loading").show();
    var loadingHeight = window.screen.height;
    $("#loading, .right-col iframe").css('height', loadingHeight);
    }).ajaxStop(function() {
      $("#loading").hide();
    });
    var dp = $("#day_off").datepicker( {
        format: "yyyy-mm-dd",
        autoclose: true
    }).datepicker();
    var dp = $("#day_on").datepicker( {
        format: "yyyy-mm-dd",
        autoclose: true
    }).datepicker();
    var dp = $("#date_range").datepicker( {
        format: "yyyy-mm-dd",
        autoclose: true
    }).datepicker();
</script>
	<script type="text/javascript">
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
<script>
    function deleteImage(el) {
    if (confirm("Bạn có chắc chắn muốn xóa ?")){
      $(el).closest(".block").remove();
      $('#imgInput').find('[type="file"]').first().val('');
    }
  }

  const uploadImgs = async function (file) {
    var formData = new FormData();
    var token = $('[name="_token"]').val();
    formData.append('file', file);
    formData.append('_token', $('input[name="_token"]').val());
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
$(document).ready(function () {
  $('input[type=file]').on('change', function () {
    var files = $(this)[0].files;
    for(let i = 0; i < files.length; i++) {
        let file = files[i];
        uploadImgs(file);
    }
  });
});
</script>
<script type="text/javascript">
    // Get the modal

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
</script>
<script>
  $(document).ready(function () {
    $("#typeCreate").on('click', function(e) {
      e.preventDefault();
      $(".error-class").remove();
      $("#typeCreate").prop('disabled', true);
      var form = $("#mainForm");
      var url = form.attr('action');
      console.log(form.serialize());
      $.ajax({
          type: "POST",
          url: url,
          data: form.serialize(), // serializes the form's elements.
          success: function(data) {
              console.log(data);
              if (data['status'] == 200) {
                  $("#successModal").find(".msg_success").text(data['message']);
                  $("#successModal").find("#redirect-url").attr("href", data['data']['redirectURL']);
                  $("#successModal").modal('show');
              } else {
                  if (data["errors"]) {
                    for (var key in data["errors"]) {
                      $("[name='" + key + "']").after("<p class='text-danger error-class'>" + data["errors"][key][0] + "</p>")
                      if (key == "url") {
                        $("#imgInput").after("<p class='text-danger error-class'>" + data["errors"][key][0] + "</p>")
                      }
                    }
                  } else if (typeof(data) == "string") {
                    $("#errorModal").find(".msg_error").text(data);
                    $("#errorModal").modal('show');
                  }
              }
              $("#typeCreate").prop('disabled', false);
          },
          error: function(jqXHR, textStatus, errorThrown) {
            $("#errorModal").find(".msg_error").text("Có lỗi xảy ra, vui lòng thử lại sau!");
            $("#errorModal").modal('show');
            $("#typeCreate").prop('disabled', false);
          }
      });
    });
  });
</script>
@endsection

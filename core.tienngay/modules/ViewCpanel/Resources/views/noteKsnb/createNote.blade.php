@extends('viewcpanel::layouts.master')
@section('css')
    <link href="{{ asset('viewcpanel/css/report/report1.css') }}" rel="stylesheet"/>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" /> -->


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
            margin-top: 15px;
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
    .inner{
      height: 200px;
    }
    </style>
@endsection
@section('content')
    <div class="create_report">
      <div id="loading" class="theloading" style="display: none;">
        <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
      </div>

    @if(session('status'))
        <div class="alert alert-success">
            {{session('status')}}
    </div>
    @endif
        <legend class="col-md-6" style="padding-bottom: 10px; border-bottom: 1px solid #dee2e6;margin-bottom: 50px;margin-top: 30px;color: #009535;">Tạo Mới Phiếu Ghi Nhận Sự Việc</legend>
        <div class="new_report">
        @if(session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
        @endif
            <form id="mainForm" action='{{url("cpanel/reportsKsnb/saveNote")}}' method="post" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-6">
                    <legend style="color: #2dbbff; font-size: 20px;">Thông Tin Ghi Nhận Sự Việc</legend>
                    <div class="mb-3">
                        <label  class="form-label">Tìm kiếm email, tên nhân viên</span></label>
                        <input type="text" data-dropdown="true" data-tags="true" class="form-control" id="search-input" placeholder="Nhập tên, email nhân viên..." autocomplete="off">
                    </div>
                    <div class="mb-3">
                      <label  class="form-label">Email&nbsp;<span class="text-danger">*</span></label>
                      <div class="email_note" id="email_note">
                        <div class="form-check">
                          <input type="text" name="user_email_note" hidden/>

                        </div>
                        @if($errors->has('user_email_note'))
                        <p style="text-align: center" class="text-danger">{{ $errors->first('user_email_note') }}</p>
                        @endif
                      </div>
                    </div>
                    <div class="mb-3">
                      <label  class="form-label">Tên nhân viên &nbsp;<span class="text-danger">*</span></label>
                      <div class="name_note" id="name_note">
                      <div class="form-check">
                        <input type="text" name="user_name_note" hidden/>
                          

                          </div>
                          @if($errors->has('user_name_note'))
                          <p style="text-align: center" class="text-danger">{{ $errors->first('user_name_note') }}</p>
                          @endif
                      </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tiêu đề&nbsp;<span class="text-danger">*</span></label>
                        <input name="title" id="title" class="form-control" aria-describedby="basic-addon1" placeholder="Tiêu đề phiếu ghi nhận" value="{{old ('title','') }}"></textarea>
                        @if($errors->has('title'))
                          <p style="text-align: center" class="text-danger">{{ $errors->first('title') }}</p>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nội dung ghi nhận&nbsp;<span class="text-danger">*</span></label>
                        <textarea name="content" id="content" class="form-control" aria-describedby="basic-addon1" placeholder="Nội dung ghi nhận sự việc" value="{{old ('content','') }}"></textarea>
                        @if($errors->has('content'))
                          <p style="text-align: center" class="text-danger">{{ $errors->first('content') }}</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                  <legend style="color: #2dbbff; font-size: 20px;">Thông Tin Nhân Viên Vi Phạm Liên Quan</legend>
                    <div class="mb-3">
                      <label  class="form-label">Chọn phòng ban</label>
                      <select class="form-control" placeholder="Nhập phòng giao dịch" name="store_name"
                                 aria-describedby="basic-addon1" id="store_name" value="{{old ('store_name','') }}">
                        <option value="">-- Chọn Phòng Ban - Phòng Giao Dịch --</option>
                        @if(isset($stores))
                        @foreach($stores as $key => $store)
                            <option value="{{$store['id']}}">{{$store['name']}}</option>
                        @endforeach
                        @endif
                      </select>
                      @if($errors->has('store_name'))
                        <p style="text-align: center" class="text-danger">{{ $errors->first('store_name') }}</p>
                      @endif
                    </div>
                    <div class="mb-3">
                      <label  class="form-label">Email trưởng phòng</label>
                        <select type="email" class="form-control" placeholder="Nhập trưởng phòng giao dịch" name="email_tpgd"
                                   aria-describedby="basic-addon1" id="email_tpgd" value="{{old ('email_tpgd','') }}"></select>
                    @if($errors->has('email_tpgd'))
                    <p style="text-align: center" class="text-danger">{{ $errors->first('email_tpgd') }}</p>
                    @endif
                    </div>
                    <div class="mb-3">
                      <label  class="form-label">Email nhân viên</label>
                      <select type="email" class="form-control" placeholder="Nhập email nhân viên" name="user_email"
                                 aria-describedby="basic-addon1" id="user_email" value="{{old('user_email','') }}"></select>
                      @if($errors->has('user_email'))
                      <p style="text-align: center" class="text-danger">{{ $errors->first('user_email') }}</p>
                      @endif
                    </div>
                    <div class="mb-3">
                      <label  class="form-label">Tên nhân viên vi phạm</label>
                       <input type="text" class="form-control" name="user_name"
                                   aria-describedby="basic-addon1" id="user_name" value="{{old('user_name','')}}">
                        @if($errors->has('user_name'))
                        <p style="text-align: center" class="text-danger">{{ $errors->first('user_name') }}</p>
                        @endif
                    </div>
                    <div class="row mb-3" id="url_image">
                      <label  class="form-label" style="font-style: 18px">Ảnh/Video ghi nhận sự việc<span class="text-danger">*</span></label>
                      @if($errors->has('path'))
                      <p style="text-align: center" class="text-danger">{{ $errors->first('path') }}</p>
                      @endif
                      <div class="img" id="img">
                        <div id="imgInput" class="block">
                          <label for="file"><div class="box">+</div></label>
                          <input type="file" id="file" name="file" style="display: none;" multiple="multiple">
                        </div>
                      </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button id="typeCreate" type="submit" class="btn btn-success">Tạo phiếu ghi nhận</button>
                <a href='{{url("/cpanel/reportsKsnb/getAllNote")}}' style="margin-right: 50px">
                    <button type="button"
                            class="btn btn-danger">Quay lại
                    </button>
                </a>
              </div>
            </form>
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
</script>

	<script type="text/javascript">
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>

<script type="text/javascript">
  const searchInput = document.getElementById('search-input');
    let email = [];
    let name = [];
    const ac = new Autocomplete(searchInput, {
        data: [{}],
        maximumItems: 5,
        threshold: 1,
        onSelectItem: ({label, value}) => {
          console.log(value);
          if (!value) {
            return;
          }
          var formData = {user_email_note : value};
          let checkExist = $('[attremail="'+value+'"]');
          if (checkExist.length > 0) {
            return;
          }
          $.ajax({
            dataType: 'json', 
            enctype: 'multipart/form-data',
            url: '{{$getUserActive}}',
            type: 'POST',
            data: formData,
            success: function (data) {
              if (data['status'] == 200) {
                $('input[name="user_email_note"]').remove();
                $('input[name="user_name_note"]').remove();
                let el = `<div class="form-check">
                          <input class="form-check-input" name="email_note[]" type="checkbox" value='` + data.data[0].email + `' attrEmail="` + data.data[0].email + `" checked=true>
                          <label class="form-check-label" for="flexCheckDefault">
                            ` + data.data[0].email + `
                          </label>
                      </div>`;
                $("#email_note").append($(el));
                let ele = `<div class="form-check">
                          <input class="form-check-input" type="checkbox" name="name_note[]" value='` + data.data[0].full_name + `' attrName="` + data.data[0].full_name + `" checked=true>
                          <label class="form-check-label" for="flexCheckDefault">
                            ` + data.data[0].full_name + `
                          </label>
                      </div>`;
                $("#name_note").append($(ele));
              } else if (typeof(data) == "string") {
                $("#errorModal").find(".msg_error").text(data);
                $("#errorModal").modal('show');
              }
            }
          });
        }
    });

    ac.setData({!! json_encode($list) !!});

</script>

<script type="text/javascript">
  function deleteItem(el) {

  }
</script>

<script type="text/javascript">
  function deleteImage(el) {
    if (confirm("Bạn có chắc chắn muốn xóa ?")){
      $(el).closest(".block").remove();
      $('#imgInput').find('[type="file"]').first().val('');
    }
  }

  const uploadImgs = async function (file) {
    var formData = new FormData();
    formData.append('file', file);
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
</script>
<script>
$(document).ready(function () {
  $('input[type=file]').on('change', function () {
    var files = $(this)[0].files;
    for(let i = 0; i < files.length; i++) {
        let file = files[i];
        uploadImgs(file);
    }
  });
});


$(document).ready(function () {
  $("#store_name").on('change', function() {
    var store_name = $(this).val();
    var formData = {store_id : store_name };
    console.log(formData)
    $.ajax({
        dataType: 'json',
        enctype: 'multipart/form-data',
        url: '{{$getEmailCHTByStoreId}}',
        type: 'POST',
        data: formData,
        success: function (data) {
            console.log(data.data)
            $('#email_tpgd').html('');
            if (data['status'] == 200) {
                for(let i =0; i < data['data'].length; i++) {
                    $('#email_tpgd').append('<option value="' + data['data'][i] + '">' + data['data'][i] + '</option>');
                }
            } else if (typeof(data) == "string") {
              $("#errorModal").find(".msg_error").text(data);
              $("#errorModal").modal('show');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          $("#errorModal").find(".msg_error").text("Có lỗi xảy ra, vui lòng thử lại sau!");
          $("#errorModal").modal('show');
        }
    });
  });
  $("#store_name").on('change', function() {
    var store_name = $(this).val();
    var formData = {id_room : store_name };
    $.ajax({
        dataType: 'json',
        enctype: 'multipart/form-data',
        url: '{{$allMailRoll}}',
        type: 'POST',
        data: formData,
        success: function (data) {
            console.log(data.data)
            $('#user_email').html('');
            if (data['status'] == 200) {
                $('#user_email').append('<option value="">' + '--Chọn nhân viên--' + '</option>')
                for(let i =0; i < data['data'].length; i++) {
                    $('#user_email').append('<option value="' + data['data'][i] + '">' + data['data'][i] + '</option>');
                }
            } else if (typeof(data) == "string") {
              $("#errorModal").find(".msg_error").text(data);
              $("#errorModal").modal('show');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          $("#errorModal").find(".msg_error").text("Có lỗi xảy ra, vui lòng thử lại sau!");
          $("#errorModal").modal('show');
        }
    });
  });
  });
  $("#user_email").on('change', function() {
    var user_name = $(this).val();
    var formData = {user_email : user_name };
    $.ajax({
        dataType: 'json',
        enctype: 'multipart/form-data',
        url: '{{$getNameByEmail}}',
        type: 'POST',
        data: formData,
        success: function (data) {
            console.log(data.data)
            $('#user_name').html('');
            if (data['status'] == 200) {
                for(let i =0; i < data['data'].length; i++) {
                    $('#user_name').val(data['data'][i]['full_name']);
                }
            } else if (typeof(data) == "string") {
              $("#errorModal").find(".msg_error").text(data);
              $("#errorModal").modal('show');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          $("#errorModal").find(".msg_error").text("Có lỗi xảy ra, vui lòng thử lại sau!");
          $("#errorModal").modal('show');
        }
    });
  });

$(document).ready(function () {
  $("#typeCreate").on('click', function(e) {
    e.preventDefault();
    $(".error-class").remove();
    $("#typeCreate").prop('disabled', true);
    var form = $("#mainForm");
    var url = form.attr('action');
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
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#select_box').on('change', function () {
         $('#select_box').selectpicker();
        let email = [];
        let name = [];
        let pick = $('#select_box').val();
        $.each(pick, function(key, value) {
          email.push(value.split(" - ")[0])
          name.push(value.split(" - ")[1])
        })
        $('#xac_nhan').on('click', function(e) {
          var formData = {user_email_note : email};
          $('#user_email_note').html('');
          $('#user_name_note').html('');
          $.ajax({
            dataType: 'json',
            enctype: 'multipart/form-data',
            url: '{{$getUserActive}}',
            type: 'POST',
            data: formData,
            success: function (data) {
              if (data['status'] == 200) {
                $("input[name='user_email_note[]']").val(email.join(", "));
                $("input[name='user_name_note[]']").val(name.join(", "));
              }  else if (typeof(data) == "string") {
                $("#errorModal").find(".msg_error").text(data);
                $("#errorModal").modal('show');
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
              $("#errorModal").find(".msg_error").text(jqXHR.responseText);
              $("#errorModal").modal('show');
          }
        })

      });
  });
}) -->
</script>

@endsection

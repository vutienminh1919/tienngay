@extends('viewcpanel::layouts.master')
@section('css')
    <link href="{{ asset('viewcpanel/css/report/report1.css') }}" rel="stylesheet"/>
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
      .block img, video {
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 100%;
        max-height: 100%;
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
        <legend class="col-md-6" style="padding-bottom: 10px; border-bottom: 1px solid #dee2e6;margin-bottom: 50px;margin-top: 30px;color: #009535;">Tạo Mới Biên Bản Ghi Nhận Vi Phạm</legend>
        <div class="new_report">
        @if(session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
        @endif
            <form id="mainForm" action='{{url("cpanel/reportsKsnb/saveReport")}}' method="post" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-6">
                    <legend style="color: #2dbbff; font-size: 20px;">Thông Tin Lỗi Vi Phạm</legend>
                    <div class="mb-3">
                        <label  class="form-label">Tìm kiếm lỗi vi phạm</label>
                        <input type="text" class="form-control" id="search-input" placeholder="Nhập mô tả lỗi vi phạm..." autocomplete="off" value="{{old('code_error')}}">
                    </div>
                    <div class="mb-3">
                      <label  class="form-label">Nhóm lỗi vi phạm&nbsp; <span class="text-danger">*</span><i data-bs-toggle="tooltip" title="" data-bs-original-title="Nhóm vi phạm đã có trong quyết định ban hành" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></label>

                      <select id="select-type" @if($errors->has('type')) style="border: 1px solid red" @endif name="type" class="form-control type"  value="{{old ('type','')}}">
                            <option value="">Tất cả</option>
                            <option value="1" @if(old('type') == '1'){{ 'selected' }}@endif>Vi phạm nội quy công ty</option>
                            <option value="2" @if(old('type') == '2'){{ 'selected' }}@endif>Vi phạm liên quan đến khách hàng</option>
                            <option value="3" @if(old('type') == '3'){{ 'selected' }}@endif>Vi phạm liên quan đến hoạt động phòng giao dịch</option>
                            <option value="4" @if(old('type') == '4'){{ 'selected' }}@endif>Các vi phạm khác</option>
                      </select>
                      @if($errors->has('type'))
                        <p style="text-align: center" class="text-danger">{{ $errors->first('type') }}</p>
                      @endif
                    </div>
                    <div class="mb-3">
                      <label  class="form-label">Lỗi vi phạm&nbsp; <span class="text-danger">*</span><i data-bs-toggle="tooltip" title="" data-bs-original-title="Mã lỗi vi phạm đã có trong quyết định ban hành" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                      <select @if($errors->has('code_error')) style="border: 1px solid red" @endif name="code_error" class="form-control" id="code_error" value="{{old ('code_error','')}}">
                      </select>
                      @if($errors->has('code_error'))
                      <p style="text-align: center" class="text-danger">{{ $errors->first('code_error') }}</p>
                      @endif
                    </div>
                    <div class="mb-3">
                      <label  class="form-label">Hình thức kỷ luật&nbsp; <span class="text-danger">*</span></label>
                      <select @if($errors->has('discipline')) style="border: 1px solid red" @endif name="discipline" class="form-control" id="discipline" value="{{old('discipline','')}}">
                      </select>
                      @if($errors->has('discipline'))
                          <p style="text-align: center" class="text-danger">{{ $errors->first('discipline') }}</p>
                      @endif
                    </div>
                    <div class="mb-3">
                      <label  class="form-label">Chế tài phạt&nbsp; <span class="text-danger">*</span><i data-bs-toggle="tooltip" title="" data-bs-original-title="Trừ %KPI trong tháng vi phạm/lỗi/lần" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                      <select  @if($errors->has('punishment')) style="border: 1px solid red" @endif name="punishment" class="form-control" id="punishment" value="{{old('punishment','')}}">
                      </select>
                      @if($errors->has('punishment'))
                        <p style="text-align: center" class="text-danger">{{ $errors->first('punishment') }}</p>
                      @endif
                    </div>
                    <div class="mb-3">
                      <label  class="form-label">Mô tả mã lỗi&nbsp; <span class="text-danger">*</span></label>
                      <textarea  @if($errors->has('description')) style="border: 1px solid red" @endif type="text" name="description" class="form-control" id="description"></textarea>
                      @if($errors->has('description'))
                      <p style="text-align: center" class="text-danger">{{ $errors->first('description') }}</p>
                      @endif
                    </div>
                    <div class="mb-3">
                      <label  class="form-label">Quyết định&nbsp; <span class="text-danger">*</span><i data-bs-toggle="tooltip" title="" data-bs-original-title="Văn bản/Quyết định đã được phê duyệt" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                      <select @if($errors->has('quote_document')) style="border: 1px solid red" @endif name="quote_document" id="quote_document" class="form-control" id="quote_document" value="{{old ('quote_document','')}}">
                      </select>
                      @if($errors->has('quote_document'))
                      <p style="text-align: center" class="text-danger">{{ $errors->first('quote_document') }}</p>
                      @endif
                    </div>
                    <div class="mb-3">
                      <label  class="form-label">Số&nbsp; <span class="text-danger">*</span><i data-bs-toggle="tooltip" title="" data-bs-original-title="Văn bản/Quyết định số" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                      <select @if($errors->has('no')) style="border: 1px solid red" @endif name="no" id = "no" class="form-control" id="no" value="{{old ('no','')}}">
                      </select>
                      @if($errors->has('no'))
                      <p style="text-align: center" class="text-danger">{{ $errors->first('no') }}</p>
                      @endif
                    </div>
                    <div class="mb-3">
                      <label  class="form-label">Ngày ban hành&nbsp; <span class="text-danger">*</span><i data-bs-toggle="tooltip" title="" data-bs-original-title="Văn bản/Quyết định có hiệu lực từ ngày" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                      <select @if($errors->has('sign_day')) style="border: 1px solid red" @endif name="sign_day" class="form-control" id="sign_day" value="{{old ('sign_day','')}}">
                      </select>
                      @if($errors->has('sign_day'))
                      <p style="text-align: center" class="text-danger">{{ $errors->first('sign_day') }}</p>
                      @endif
                    </div>
                    <div class="mb-3">
                      <label  class="form-label">Ghi chú</label>
                      <textarea  @if($errors->has('description_error')) style="border: 1px solid red" @endif type="text" name="description_error" class="form-control" id="description_error" placeholder="Mô tả chi tiết lỗi của người vi phạm"></textarea>
                      @if($errors->has('description_error'))
                      <p style="text-align: center" class="text-danger">{{ $errors->first('description_error') }}</p>
                      @endif
                    </div>
                </div>
                <div class="col-md-6">
                  <legend style="color: #2dbbff; font-size: 20px;">Thông Tin Nhân Viên</legend>
                    <div class="mb-3">
                      <label  class="form-label">Chọn phòng ban&nbsp; <span class="text-danger">*</span></label>
                      <select @if($errors->has('store_name')) style="border: 1px solid red" @endif type="text" class="form-control" placeholder="Nhập phòng giao dịch" name="store_name"
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
                      <label  class="form-label">Email trưởng phòng&nbsp; <span class="text-danger">*</span></label>
                        <select @if($errors->has('email_tpgd')) style="border: 1px solid red" @endif type="email" class="form-control" placeholder="Nhập trưởng phòng giao dịch" name="email_tpgd"
                                   aria-describedby="basic-addon1" id="email_tpgd" value="{{old ('email_tpgd','') }}"></select>
                    @if($errors->has('email_tpgd'))
                    <p style="text-align: center" class="text-danger">{{ $errors->first('email_tpgd') }}</p>
                    @endif
                    </div>
                    <div class="mb-3">
                      <label  class="form-label">Email nhân viên&nbsp; <span class="text-danger">*</span></label>
                      <select @if($errors->has('user_email')) style="border: 1px solid red" @endif type="email" class="form-control" placeholder="Nhập email nhân viên" name="user_email"
                                 aria-describedby="basic-addon1" id="user_email" value="{{old('user_email','') }}"></select>
                      @if($errors->has('user_email'))
                      <p style="text-align: center" class="text-danger">{{ $errors->first('user_email') }}</p>
                      @endif
                    </div>
                    <div class="mb-3">
                      <label  class="form-label">Tên nhân viên vi phạm&nbsp; <span class="text-danger">*</span></label>
                       <input @if($errors->has('user_name')) style="border: 1px solid red" @endif type="text" class="form-control" name="user_name"
                                   aria-describedby="basic-addon1" id="user_name" value="{{old('user_name','')}}">
                        @if($errors->has('user_name'))
                        <p style="text-align: center" class="text-danger">{{ $errors->first('user_name') }}</p>
                        @endif
                    </div>
                    <div class="row mb-3" id="url_image">
                      <label  class="form-label" style="font-style: 18px">Ảnh vi phạm&nbsp; <span class="text-danger">*</span></label>
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
                <button id="typeCreate" type="submit" class="btn btn-primary">Tạo biên bản</button>
                <a href='{{url("/cpanel/reportsKsnb/list_users_ksnb")}}' style="margin-right: 50px">
                    <button type="button"
                            class="btn btn-success">Quay lại
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
  const searchInput = document.getElementById('search-input');
    const ac = new Autocomplete(searchInput, {
        data: [{}],
        maximumItems: 5,
        threshold: 1,
        onSelectItem: ({label, value}) => {
          var formData = {code_error : value};
          $('#discipline').html('');
          $('#description').val('');
          $('#punishment').html('');
          $('#code_error').html('');
          $('#quote_document').html('');
          $('#no').html('');
          $('#sign_day').html('');
          $.ajax({
            dataType: 'json',
            enctype: 'multipart/form-data',
            url: '{{$getErrorCodeInfoUrl}}',
            type: 'POST',
            data: formData,
            success: function (data) {
              console.log(data);
              if (data['status'] == 200) {
                $('#discipline').append('<option value="' + data['data']['item']['discipline'] + '">' + data['data']['item']['discipline_name'] + '</option>');
                $('#punishment').append('<option value="' + data['data']['item']['punishment'] + '">' + data['data']['item']['punishment_name'] + '</option>');
                $('#description').val(data['data']['item']['description']);
                $("#select-type").val(data['data']['item']['type']);
                $('#code_error').append('<option value="">' + '--Mã Lỗi--' + '</option>')
                for (let i = 0; i < data['data']['listCode'].length; i++) {
                    $('#code_error').append('<option value="' + data['data']['listCode'][i]['code_error'] + '">' + data['data']['listCode'][i]['code_error'] + '</option>')
                }
                $('#code_error').val(data['data']['item']['code_error']);
                $('#quote_document').append('<option value="' + data['data']['item']['quote_document'] + '">' + data['data']['item']['quote_document'] + '</option>');
                $('#no').append('<option value="' + data['data']['item']['no'] + '">' + data['data']['item']['no'] + '</option>');
                $('#sign_day').append('<option value="' + data['data']['item']['sign_day'] + '">' + data['data']['item']['sign_day'] + '</option>');
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
              $("#errorModal").find(".msg_error").text(jqXHR.responseText);
              $("#errorModal").modal('show');
            }
          });
        }
    });

    ac.setData({!! json_encode($errorCodes) !!});
</script>
	<script type="text/javascript">
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
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
    $(".type").on('change', function () {
        var type = $(this).val();
        var formData = {type : type};
        $.ajax({
          dataType: 'json',
          enctype: 'multipart/form-data',
          url: '{{$getCodeByType}}',
          type: 'POST',
          data: formData,
          success: function (data) {
          console.log(data)
              $('#code_error').html('');
              if (data['status'] == 200) {
                  $('#code_error').append('<option value="" > ' + '--Mã Lỗi--' + '</option>')
                  for (let i = 0; i < data['data'].length; i++) {
                      $('#code_error').append('<option  value="' + data['data'][i] + '"  > ' + data['data'][i] + ' </option>')
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
$(document).ready(function () {
  $("#code_error").on('change', function() {
    var discipline = $(this).val();
    var formData = {code_error : discipline};
    $('#discipline').html('');
    $('#description').val('');
    $('#punishment').html('');
    $.ajax({
      dataType: 'json',
      enctype: 'multipart/form-data',
      url: '{{$getErrorCodeInfoUrl}}',
      type: 'POST',
      data: formData,
      success: function (data) {
        console.log(data);
        if (data['status'] == 200) {
          $('#discipline').append('<option value="' + data['data']['item']['discipline'] + '">' + data['data']['item']['discipline_name'] + '</option>');
          $('#punishment').append('<option value="' + data['data']['item']['punishment'] + '">' + data['data']['item']['punishment_name'] + '</option>');
          $('#quote_document').append('<option value="' + data['data']['item']['quote_document'] + '">' + data['data']['item']['quote_document'] + '</option>');
          $('#no').append('<option value="' + data['data']['item']['no'] + '">' + data['data']['item']['no'] + '</option>');
          $('#sign_day').append('<option value="' + data['data']['item']['sign_day'] + '">' + data['data']['item']['sign_day'] + '</option>');
          $('#description').val(data['data']['item']['description']);
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
@endsection

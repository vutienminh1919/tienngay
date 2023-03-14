@extends('viewcpanel::layouts.master')
@section('title', 'Cập Nhật Template Email')
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
    <div id="loading" class="theloading" style="display: none;">
        <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    </div>
    <div id="top-view" class="container" style="max-width: 95% !important">
    <div class="card">
      <div class="card-header">
        <h3 class="tilte_top_tabs text-success">
            Cập Nhật Template Email 
        </h3>
      </div>
      <div class="card-body">
       <div class="middle table_tabs">
         <div class="row">
             <legend style="color: #2dbbff; font-size: 20px; padding-left:100px;">Thông Tin Chi Tiết Gửi Email</legend>
              <div class="row justify-content-center">
                <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}">
                <div class="row col-md-12 col-lg-8">

                  <div class="col-md-12 col-sm-12">
                      <label for="code" class="form-label" style="font-size:20px">Mã code&nbsp;<span class="text-danger">*</span></label>
                      <input style="font-size:15px" type="text" class="form-control" id="code" name="code" placeholder="example: truyen-thong-noi-bo" value="{{$detail->code}}">
                  </div>

                  <div class="col-md-12 col-sm-12">
                      <label for="subject" class="form-label" style="font-size:20px">Tiêu đề&nbsp;<span class="text-danger">*</span></label>
                      <input style="font-size:15px" type="text" class="form-control" id="subject" name="subject" placeholder="Tiêu đề email" value="{{$detail->subject}}">
                  </div>

                  <div class="col-md-12 col-sm-12">
                      <label for="subject" class="form-label" style="font-size:20px">Phòng ban&nbsp;<span class="text-danger">*</span></label>
                      <select style="font-size:15px" type="text" class="form-control" id="store" name="store" placeholder="Chọn phòng ban" value="{{$detail->store}}">
                          <option value="">--Chọn phòng ban--</option>
                          @if(isset($stores))
                              @foreach($stores as $key => $store)
                                  <option  value="{{$store['id']}}" @if($store['id'] == $detail['store']) selected @endif >{{$store['name']}}</option>
                              @endforeach
                          @endif
                      </select>
                  </div>

                  <div class="col-md-12 col-sm-12">
                      <label for="reason_for_leave" class="form-label" style="font-size:20px">Nội dung&nbsp;<span class="text-danger">*</span></label>
                      <textarea style="font-size:15px" rows="10" cols="50" type="text" class="form-control" id="message" name="message">{{$detail->message}}</textarea>
                  </div>

                  <div id="preview" hidden style="text-align:center;">
                    <a type="button" class="btn btn-info" id="preview_content">Xem nội dung</a>
                  </div>

                  <div id="show_content" hidden style="text-align:center;">

                  </div>

                  <div class="modal-footer" style="border-top: 2px solid #dee2e6" >
                      <button style="font-size:15px" id="typeUpdate" type="submit" class="btn btn-success">Cập nhật</button>
                      <a href="{{$listTempalte}}"class="btn btn-danger" type="button" style="font-size:15px">Quay lại</a>
                  </div>
                </div>
              </div>
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
        </div>
      </div>
    </div>

    <div class="modal fade" id="errorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Lỗi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p class="msg_error text-danger"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
          </div>
        </div>
      </div>
   </div>  

   <div class="modal fade" id="preview_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Preview Template</h5>
          </div>
          <div class="modal-body">
            <p class="msg_success"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
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

<script>
  $(document).ready(function () {
    $('#typeUpdate').on('click', function(event) {
            event.preventDefault();
            var token = $('[name="_token"]').val();
            let subject = $('[name="subject"]').val();
            let code = $('[name="code"]').val();
            let store = $('[name="store"]').val();
            let message = $('[name="message"]').val();
            var formData = new FormData();
            formData.append('_token', token);
            formData.append('subject', subject);
            formData.append('store', store);
            formData.append('message', message);
            formData.append('code', code);
            $.ajax({
              enctype: 'multipart/form-data',
              url: '{{$updateTemplate}}',
              type: "POST",
              data: formData,
              dataType: 'json',
              processData: false,
              contentType: false,
              beforeSend: function () {
                $('#modal_import').modal('hide');
                $(".theloading").show();
              },
              success: function (data) {
                $(".theloading").hide();
                $(".msg_error").empty();
                if (data.status == 200) {
                    $('#successModal').modal('show')
                    $('.msg_success').text("Cập nhật thành công")
                    setTimeout(function () {
                        window.location.assign(data['data']['redirectURL'])}, 2500);
                } else {
                  if(data['errors']) {
                        $.each(data['errors'], function(key, value) {
                          $(".msg_error").append('<li style="list-style:none"><p class="text-danger">' + value + '</p></li>');
                          $("#errorModal").modal('show');
                        });
                      }
                }
              },
              error: function () {
                $(".theloading").hide();
                $('#modal-danger').modal('show');
                $('.msg_error').text("error");
              }
          })
    });

    $('textarea[name="message"]').keyup(function(){
        val = $('#message').val().trim(); 
        console.log(val);
        if(val.length > 0){
          $('#show_content').attr('hidden', false);
          $('#preview').attr('hidden', false);
          $('#preview').html('<p>'+"Preview Template"+'</p>');
          $('#show_content').html("<div style='display: flex; text-align:center;justify-content: center;'>" + val + "</div>");
        } else {
          $('#preview').attr('hidden', true);
          $('#show_content').attr('hidden', true);
        }
      });

      var preview = $('#message').val().trim();
      if(preview.length > 0){
          $('#show_content').attr('hidden', false);
          $('#preview').attr('hidden', false);
          $('#preview').html('<p class="text-success">'+"Preview Template"+'</p>');
          $('#show_content').html("<div style='display: flex; text-align:center;justify-content: center;'>" + preview + "</div>");
        } else {
          $('#preview').attr('hidden', true);
          $('#show_content').attr('hidden', true);
        }

  });
</script>
@endsection

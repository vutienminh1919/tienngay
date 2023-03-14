@extends('viewcpanel::layouts.master')

@section('title', 'Tool Send Email')

@section('css')
<link href="{{ asset('viewcpanel/css/reportsKsnb/index.css') }}" rel="stylesheet"/>
<style type="text/css">
        .alert {
            z-index: 999 !important;
        }
        /* Style the Image Used to Trigger the Modal */
        .img {
          border-radius: 5px;
          cursor: pointer;
          transition: 0.3s;
        }

        .img:hover {opacity: 0.7;}
        .modal-backdrop {
            display: none !important;
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
        #overlay{
          position: absolute;
          width: 30px;
          height: 30px;
          top: 2px;
          z-index: 3;
          left: 32px;
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
      <h3 class="tilte_top_tabs">
            Tool Gửi Email Truyền Thông 
        </h3>
      </div>
      <div class="card-body">
       <div class="middle table_tabs">
         <div class="row">
             <legend style="color: #2dbbff; font-size: 20px; padding-left:100px;">Thông Tin Chi Tiết Gửi Email</legend>
           <div class="row justify-content-center">
             <div class="col-xs-12  col-lg-8">
             <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}">
                   <div class="row col-md-12 col-lg-12">
                       <div class="col-md-12 col-sm-12" style="padding-top:30px;">
                           <label for="store" class="form-label" style="font-size:20px">Phòng ban&nbsp;<span class="text-danger">*</span></label>
                           <select style="font-size:15px" type="text" class="form-control" id="store" name="store" placeholder="Chọn phòng ban">
                               <option value="">--Chọn phòng ban--</option>
                               @if(isset($stores))
                                 @foreach($stores as $key => $store)
                                     <option value="{{$store['id']}}">{{$store['name']}}</option>
                                 @endforeach
                               @endif  
                           </select>
                       </div>
                       <div class="col-md-12 col-sm-12" style="padding-top:30px;">
                           <label for="content_email" class="form-label" style="font-size:20px">Chương trình truyền thông&nbsp;<span class="text-danger">*</span></label>
                           <select style="font-size:15px" type="text" class="form-control" id="content_email" name="content_email" placeholder="Chọn phòng ban trước">
                             <option value="">--Chọn phòng ban trước tiên--</option>
                           </select>
                       </div>
                       <div class="col-md-12 col-sm-12" style="padding-top:30px;">
                           <label for="subject" class="form-label" style="font-size:20px">Tiêu đề&nbsp;<span class="text-danger">*</span></label>
                           <input style="font-size:15px" type="text" class="form-control" id="subject" name="subject" placeholder="Chọn chương trình truyền thông" disabled>
                       </div>
                       <div id="show_content" hidden style="text-align:center;">

                       </div>
                       <div class="col-md-12 col-sm-12" style="padding-top:30px;">
                               <label for="from" class="form-label" style="font-size:20px">Email gửi&nbsp;<span class="text-danger">*</span></label>
                                <select  style="font-size:15px" type="text" class="form-control" id="from" name="from" placeholder="Chọn phòng ban trước">
                                    <option value="">--Chọn phòng ban trước tiên--</option>
                                </select>
                       </div>
                       <div class="col-md-12 col-sm-12" style="padding-top:30px;">
                           <label for="list_email_kh" class="form-label" style="font-size:20px">Import danh sách khách hàng&nbsp;<span class="text-danger">*</span></label>
                           <input style="font-size:15px" type="file" class="form-control" id="list_email_kh" name="list_email_kh" placeholder="Chọn file excel">
                       </div>

                       <div class="modal-footer">
                           <a style="font-size:15px" href="{{$downloadFile}}" class="btn btn-info">Download biểu mẫu</a>
                           <button style="font-size:15px" class="btn btn-success" type="submit" id="submit_email">Xác nhận gửi email</button>
                           <a style="font-size:15px" href="{{$listTempalte}}" class="btn btn-danger" type="button">Quay lại</a>
                       </div>
                 </div>
             </div>
                  
           </div>
         </div>
         
       </div>
 
       <nav aria-label="Page navigation" style="margin-top: 20px;">
         
       </nav>
       
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

    <div class="modal fade" id="preview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
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

</section>

@endsection
@section('script')
<script type="text/javascript">
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    const element = document.getElementById("top-view");
    element.scrollIntoView();
</script>
<script type="text/javascript">
  $(document).ajaxStart(function() {
    $("#loading").show();
    var loadingHeight = window.screen.height;
    $("#loading, .right-col iframe").css('height', loadingHeight);
    }).ajaxStop(function() {
      $("#loading").hide();
  });
  $(document).ajaxStart(function() {
    $("#loading").show();
    var loadingHeight = window.screen.height;
    $("#loading, .right-col iframe").css('height', loadingHeight);
    }).ajaxStop(function() {
      $("#loading").hide();
  });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#submit_email').on('click', function(event) {
            event.preventDefault();
            var xls = [
                'application/vnd.ms-excel', 'application/msexcel', 'application/x-msexcel', 'application/x-ms-excel', 'application/x-excel', 
                'application/x-dos_ms_excel', 'application/xls', 'application/x-xls', 'application/excel', 'application/download', 'application/vnd.ms-office', 
                'application/msword','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip', 'application/vnd.ms-excel', 
                'application/msword', 'application/x-zip'
            ]; 
            var inputFile = $('input[name=list_email_kh]');
            if (inputFile.val() == '') {
              alert("Không có file để import");
            }
            var fileToUpload = inputFile[0].files[0];
            if(xls.includes(fileToUpload.type)) {
                //do nothing
            } else {
                alert("File import sai định dạng");
                return;
            }
            var token = $('[name="_token"]').val();
            let subject = $('[name="subject"]').val();
            let from = $('[name="from"]').val();
            let store = $('[name="store"]').val();
            let content_email = $('[name="content_email"]').val();
            var formData = new FormData();
            formData.append('upload_file', fileToUpload);
            formData.append('_token', token);
            formData.append('subject', subject);
            formData.append('from', from);
            formData.append('store', store);
            formData.append('content_email', content_email);
            console.log(fileToUpload.type);
            $.ajax({
              enctype: 'multipart/form-data',
              url: '{{$import}}',
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
                $('#file_import').val("");
                $(".msg_error").empty();
                if (data.status == 200) {
                    $('#successModal').modal('show')
                    $('.msg_success').text("Email đã được gửi thành công")
                    setTimeout(function () {
                        window.location.reload()}, 2500);
                } else {
                  if(data['errors']) {
                    console.log(data['errors'])
                        $.each(data['errors'], function(key, value) {
                        console.log($value);
                          $(".msg_error").append('<li style="list-style:none"><p class="text-danger">' + value + '</p></li>');
                          $("#errorModal").modal('show');
                        });
                      }
                  if (data['error']) {
                    $(".msg_error").append('<li style="list-style:none"><p class="text-danger">' + data['error'] + '</p></li>');
                    $("#errorModal").modal('show');
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

        $('#store').on('change', function() {
          var store = $(this).val();
          var formData = {code : store};
          $('#content_email').html('');
          $.ajax({
            dataType: 'json',
            enctype: 'multipart/form-data',
            url: '{{$getCodeEmail}}',
            type: 'POST',
            data: formData,
            success: function (data) {
              if (data['status'] == 200) {
                $('#subject').val('');
                $('#content_email').html('');
                $('#content_email').append('<option value="">' + "--Chọn nội dung--"+ '</option>');
                console.log(data['data']);
                $.each(data['data'], function (key, value) {
                  $('#content_email').append('<option value="' + key + '">' + value + '</option>');
                });
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

        $('#content_email').on('change', function() {
          var content_email = $(this).val();
          var formData = {code : content_email};
          $('#subject').html('');
          $.ajax({
            dataType: 'json',
            enctype: 'multipart/form-data',
            url: '{{$getSubject}}',
            type: 'POST',
            data: formData,
            success: function (data) {
              if (data['status'] == 200) {
                // $("#preview").modal('show');
                // // $("#preview").find(".msg_success").html(data.data.message);
                $('#show_content').attr('hidden', false);
                console.log(data.data);
                $('#subject').val(data.data.subject)
                $('#show_content').html("<div style='display: flex; text-align:center;justify-content: center;'>" + data.data.message+ "</div>");
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

        $('#store').on('change', function() {
          var name_email = JSON.parse('{!! json_encode($name_email) !!}');
          var store = $(this).val();
          var formData = {code : store};
          $('#from').html('');
          $.ajax({
            dataType: 'json',
            enctype: 'multipart/form-data',
            url: '{{$getSlug}}',
            type: 'POST',
            data: formData,
            success: function (data1) {
              if (data1['status'] == 200) {
                console.log(data1['data']);
                $('#from').html('');
                $('#from').append('<option value="">' + "--Chọn email gửi--"+ '</option>');
                $.each(name_email, function (key, value) {
                  if (key == data1['data']) {
                    $.each(value, function (k, v) {
                      $('#from').append('<option value="' + k + '">' + v + '</option>');
                    })
                  } else {
                    //do nothing;
                  }
                });
              } else if (typeof(data1) == "string") {
                $("#errorModal").find(".msg_error").text(data1);
                $("#errorModal").modal('show');
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
              $("#errorModal").find(".msg_error").text("Có lỗi xảy ra, vui lòng thử lại sau!");
              $("#errorModal").modal('show');
            }
          });
        });  
    })
</script>
@endsection
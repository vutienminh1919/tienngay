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
      .modal-backdrop { 
        display: none !important;
      }

    </style>
@endsection
@section('content')
<div id="loading" class="theloading" style="display: none;">
        <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
      </div>
    <div id="top-view" class="create_report" style="padding-top: 20px">
    @if(session('status'))
      <div class="alert alert-success">
        {{session('status')}}
      </div>
    @endif
    @if(session('success'))
    <div class="alert alert-success">
      {{session('success')}}
    </div>
    @endif
    @if ($errors && !empty($errors->first()))
    <div class="alert alert-danger">
      {{$errors->first()}}
    </div>
    @elseif(session('errors'))
    <div class="alert alert-danger">
      {{session('errors')}}
    </div>
    @endif
    <legend class="col-md-6" style="padding-bottom: 10px; border-bottom: 1px solid #dee2e6;margin-bottom: 50px;margin-top: 30px;color: #009535;">Phản Hồi Biên Bản Ghi Nhận Vi Phạm</legend>
        <div class="new_report">
        <form action='{{url("cpanel/reportsKsnb/sendfeedback/$detail->_id")}}' method="post" enctype="multipart/form-data" id="user_feedback">
          <div class="row" style="padding-top: 10px">
              <div class="col-md-6">
                <legend style="color: #2dbbff; font-size: 20px;">Thông Tin Lỗi Vi Phạm</legend>
                <div class="mb-3">
                  <label  class="form-label">Nhóm lỗi vi phạm&nbsp; <span class="text-danger">*</span><i data-bs-toggle="tooltip" title="" data-bs-original-title="Nhóm vi phạm đã có trong quyết định ban hành" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                  <select name="type" class="form-control type" disabled>
                    <option value="">Tất cả</option>
                    <option value="1" @if ($detail->type == 1) selected="selected" @endif>Vi phạm nội quy công ty</option>
                    <option value="2" @if ($detail->type == 2) selected="selected" @endif>Vi phạm liên quan đến khách hàng</option>
                    <option value="3" @if ($detail->type == 3) selected="selected" @endif> Vi phạm liên quan đến hoạt động phòng giao dịch</option>
                    <option value="4" @if ($detail->type == 4) selected="selected" @endif>Các vi phạm khác</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label  class="form-label">Lỗi vi phạm&nbsp; <span class="text-danger">*</span><i data-bs-toggle="tooltip" title="" data-bs-original-title="Mã lỗi vi phạm đã có trong quyết định ban hành" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                  <input type="text" name="code_error" class="form-control" id="code_error" value="{{$detail['code_error']}}" disabled>
                </div>
                <div class="mb-3">
                  <label  class="form-label">Hình thức kỷ luật&nbsp; <span class="text-danger">*</span></label>
                  <input type="text" name="discipline" class="form-control" id="discipline" value="{{$detail['discipline_name']}}" disabled>
                </div>
                <div class="mb-3">
                  <label  class="form-label">Chế tài phạt&nbsp; <span class="text-danger">*</span><i data-bs-toggle="tooltip" title="" data-bs-original-title="Trừ %KPI trong tháng vi phạm/lỗi/lần" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                  <input type="text" name="punishment" class="form-control" id="punishment" value="{{$detail['punishment_name']}}" disabled>
                </div>
                <div class="mb-3">
                  <label  class="form-label">Mô tả mã lỗi&nbsp; <span class="text-danger">*</span></label>
                  <textarea type="text" name="description" class="form-control" id="created_by" disabled>{{$detail['description']}}</textarea>
                </div>
                <div class="mb-3">
                  <label  class="form-label">Quyết định&nbsp; <span class="text-danger">*</span><i data-bs-toggle="tooltip" title="" data-bs-original-title="Văn bản/Quyết định đã được phê duyệt" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                  <input type="text" name="quote_document" class="form-control" id="quote_document" value="{{$detail['quote_document']}}" disabled>
                </div>
                <div class="mb-3">
                  <label  class="form-label">Số&nbsp; <span class="text-danger">*</span><i data-bs-toggle="tooltip" title="" data-bs-original-title="Văn bản/Quyết định số" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                  <a href={{$download}} name="no" target="_blank" class="form-control text-primary" id="no">{{$detail['no']}}</a>
                </div>
                <div class="mb-3">
                  <label  class="form-label">Ngày ban hành&nbsp; <span class="text-danger">*</span><i data-bs-toggle="tooltip" title="" data-bs-original-title="Văn bản/Quyết định có hiệu từ lực ngày" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                  <input type="text" name="sign_day" class="form-control" id="sign_day" value="{{$detail['sign_day']}}" disabled>
                </div>
                <div class="mb-3">
                  <label  class="form-label">Ghi chú</label>
                  <textarea type="text" name="description" class="form-control" id="created_by" disabled>{{$detail['description_error']}}</textarea>
                </div>
                <div class="mb-3">
                  <label  class="form-label">Ý kiến phản hồi&nbsp; <span class="text-danger">*</span></label >
                  <textarea type="text" @if($errors->has('comment')) style="border: 1px solid red" @endif name="comment" class="form-control" placeholder="Phản hồi tại đây"></textarea>
                  @if($errors->has('comment'))
                      <p style="text-align: center" class="text-danger">{{ $errors->first('comment') }}</p>
                  @endif
                </div>
                <!-- @if($detail->process == 5)
                <div class="mb-3">
                  <label class="form-label">Kết luận của TBP</label >
                  <textarea type="text" name="infer" class="form-control" placeholder="Kết luận của TBP"></textarea>
                </div>
                @endif -->
              </div>
              <div class="col-md-6">
                  <legend style="color: #2dbbff; font-size: 20px;">Thông Tin Nhân Viên</legend>
                  <div class="mb-3">
                      <label  class="form-label">Phòng ban&nbsp; <span class="text-danger">*</span></label>
                      <input type="text" name="store_name" class="form-control" id="store_name" value="{{$detail['store_name']}}" disabled>
                  </div>
                  <div class="mb-3">
                      <label  class="form-label">Email trưởng phòng&nbsp; <span class="text-danger">*</span></label>
                      <input type="text" name="email_tpgd" class="form-control" id="email_tpgd" value="{{$detail['email_tpgd']}}" disabled>
                  </div>
                  <div class="mb-3">
                      <label  class="form-label">Email nhân viên&nbsp; <span class="text-danger">*</span></label>
                      <input type="text" name="user_email" class="form-control" id="user_email" value="{{$detail['user_email']}}" disabled>
                  </div>
                  <div class="mb-3">
                      <label  class="form-label">Tên nhân viên vi phạm&nbsp; <span class="text-danger">*</span></label>
                      <input type="text" name="user_name" class="form-control" id="user_name" value="{{$detail['user_name']}}" disabled>
                  </div>
                  <div class="mb-3">
                    <label  class="form-label" style="font-style: 18px">Ảnh vi phạm&nbsp; <span class="text-danger">*</span></label>
                    <div class="img" id="img">
                      <div id="imgInput" class="block" style="display: none;">
                        <label for="file"><div class="box">+</div></label>
                        <input type="file" id="file" name="file" style="display: none;" multiple="multiple">
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
              @if(($detail->process == 2 || $detail->process == 9) && $detail->status != 5)
                @if($user == $detail['user_email'] || $user == $detail['email_tpgd'])
                <button type="submit" class="btn btn-success" id="userfeedback">Phản hồi</button>
                @endif
              @endif

              <a href='{{url("/cpanel/reportsKsnb/list_users_ksnb")}}' class="btn btn-success" style="margin-right: 50px"> Quay lại</a>
            </div>
            </form>
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

        <!-- modal thông báo gửi phản hồi của user -->
    <div class="modal fade" id="modal_user_feedback" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Ý kiến phản hồi</h5>
          </div>
          <div class="modal-body">
            <p class="msg_success text-primary">Phản hồi từ phía người vi phạm đã được gửi cho kiểm soát nội bộ</p>
          </div>
          <div class="modal-footer">
            <a id="redirect-url" href='{{url("/cpanel/reportsKsnb/detailReport/$detail->_id")}}' class="btn btn-danger">Đóng</a>
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
<section style="margin-top: 35px">
  <div class="create_report">
  <div class="row">
        <div class="col-md-3">

            <p class="h4" style="margin-bottom: 20px; border-bottom: 1px solid #dee2e6;">Ý kiến NV vi phạm:</p>
            @if(isset($detail->comment))
            <ul class="list-unstyled" style="width: 100%; height: 350px; overflow: auto;">
            <?php $comment = isset($detail->comment) ? $detail->comment:[]; ?>
              @for($i = count($comment) - 1; $i >= 0; $i--)
              <li>
              <figure>
                <p>Nhân viên: <span style="color: #383efbbf; font-weight: 300">{{$comment[$i]['created_by']}}</span></p>
                <figcaption class="blockquote-footer">
                  <p>{{$comment[$i]['comment']}}</p>
                  <p>Thời gian: {{date('d/m/Y H:i:s', $comment[$i]['created_at'])}}</p>
                </figcaption>
              </figure>
            </li>
              @endfor
            </ul>
            @else
            <p style="font-weight: 300">Chưa có</p>
            @endif
        </div>

        <div class="col-md-3">
            <p class="h4" style="margin-bottom: 20px; border-bottom: 1px solid #dee2e6; word-break: break-all;">Ý kiến của KSNB:</p>
            @if(isset($detail['ksnb_comment']))
            <ul class="list-unstyled" style="width: 100%; height: 350px; overflow: auto;">
            <?php $ksnb_comment = isset($detail->ksnb_comment) ? $detail->ksnb_comment:[]; ?>
              @for($i = count($ksnb_comment) - 1; $i >= 0; $i--)
              <li>
              <figure>
                <p>Nhân viên: <span style="color: #383efbbf; font-weight: 300">{{$ksnb_comment[$i]['created_by']}}</span></p>
                <figcaption class="blockquote-footer">
                  <p>{{$ksnb_comment[$i]['ksnb_comment']}}</p>
                  <p>Thời gian: {{date('d/m/Y H:i:s', $ksnb_comment[$i]['created_at'])}}</p>
                </figcaption>
              </figure>
              </li>
              @endfor
            </ul>
            @else
            <p style="font-weight: 300">Chưa có</p>
            @endif
        </div>


        <div class="col-md-3">
            <p class="h4" style="margin-bottom: 20px; border-bottom: 1px solid #dee2e6; word-break: break-all;">Kết luận của TBP:</p>
            <p style="font-weight: 300">Chưa có</p>
        </div>
        <div class="col-md-3">
          <p class="h4" style="margin-bottom: 20px; border-bottom: 1px solid #dee2e6;">Lịch sử</p>
          <ul class="list-unstyled" style="width: 100%; height: 350px; overflow: auto;">
            <?php $logs = isset($detail->logs) ? $detail->logs:[]; ?>
          @for($i = count($logs) - 1; $i >= 0; $i--)
            <li>
              <figure>
                <p>Nhân viên: <span style="color: #383efbbf; font-weight: 300">{{$logs[$i]['created_by']}}</span></p>
                <figcaption class="blockquote-footer">
                  <p>{{$logs[$i]['action']}}</p>
                  <p>Thời gian: {{date('d/m/Y H:i:s', $logs[$i]['created_at'])}}</p>
                </figcaption>
              </figure>
            </li>
          @endfor
          </ul>
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
<script type="text/javascript">
  var imgs = JSON.parse('{!! json_encode($detail->path) !!}');
  const isImg = function (url) {
      return(url.match(/\.(jpeg|jpg|gif|png)$/) != null);
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
</script>

<script type="text/javascript">
  $(document).ajaxStart(function() {
  $("#loading").show();
  var loadingHeight = window.screen.height;
  $("#loading, .right-col iframe").css('height', loadingHeight);
  }).ajaxStop(function() {
    $("#loading").hide();
  });
</script>
<script>
  $(document).ready(function() {
    $("#userfeedback").on('click', function(e) {
    e.preventDefault();
    $(".error-class").remove();
    $("#userfeedback").prop('disabled', true);
    var form = $("#user_feedback");
    var url = form.attr('action');
    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(), // serializes the form's elements.
        success: function(data) {
            console.log(data);
            if (data['status'] == 200) {
                $("#modal_user_feedback").modal('show');
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
            $("#userfeedback").prop('disabled', false);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          $("#errorModal").find(".msg_error").text("Có lỗi xảy ra, vui lòng thử lại sau!");
          $("#errorModal").modal('show');
          $("#userfeedback").prop('disabled', false);
        }
     });
  });
  });

</script>
@endsection

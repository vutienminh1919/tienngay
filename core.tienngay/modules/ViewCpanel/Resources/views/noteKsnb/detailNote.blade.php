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
    <div class="load"></div>
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
        <legend class="col-md-6" style="padding-bottom: 10px; border-bottom: 1px solid #dee2e6;margin-bottom: 50px;margin-top: 30px;color: #009535;">Chi Tiết Biên Bản Ghi Nhận Sự Việc</legend>
        <div>
        @if($detail->process == 8)
        <form action='{{url("/cpanel/reportsKsnb/waitConfirmNote/$detail->_id")}}' method="post" enctype="multipart/form-data" id ="waitConfirm">
        @elseif ($detail->process == 4)
        <form action='{{url("/cpanel/reportsKsnb/reConfirmNote/$detail->_id")}}' method="post" enctype="multipart/form-data" id ="reConfirm">
        @elseif ($detail->process == 5 || $detail->process == 6 || $detail->process == 9)
        <form action='{{url("/cpanel/reportsKsnb/ksnbFeedback/$detail->_id")}}' method="post" enctype="multipart/form-data" id ="ksnbFeedback">
        @elseif ($detail->process == 10) 
        <form action='{{url("/cpanel/reportsKsnb/inferNote/$detail->_id")}}' method="post" enctype="multipart/form-data" id ="inferNote">
        @else
        <form action='{{url("/cpanel/reportsKsnb/confirmNote/$detail->_id")}}' method="post" enctype="multipart/form-data" id ="confirm">
        @endif
            <div class="row" style="padding-top: 10px">
                <div class="col-md-6">
                    <legend style="color: #2dbbff; font-size: 20px;">Thông Tin Phiếu Ghi nhận</legend>
                    <div class="mb-3">
                        <div class="mb-3">
                            <label class="form-label">Email&nbsp;<span class="text-danger">*</span></label >
                            <input type="text" name="email_note[]" id="email_note" class="form-control" @if(is_array($detail->email_note)) value='{{implode(", ",$detail->email_note)}}' @else value="$detail->email_note" @endif disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tên nhân viên&nbsp;<span class="text-danger">*</span></label >
                            <input type="text" name="name_note[]" id="name_note" class="form-control" @if(is_array($detail->name_note)) value='{{implode(", ",$detail->name_note)}}'@else value="$detail->name_note" @endif disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tiêu đề</label >
                            <input type="text" name="title" class="form-control" placeholder="Tiêu đề phiếu ghi nhận sự việc" value="{{$detail->title}}" disabled>
                        </div>
                        <div class="mb-3" id="article">
                            <label class="form-label">Nội dung ghi nhận&nbsp;<span class="text-danger">*</span></label>
                            <textarea type="text" name="content" class="form-control" id="myID" placeholder="Nội dung ghi nhận" disabled>{{$detail->content}}</textarea>
                        </div>
                        @if ($detail->process == 5)
                        <div class="mb-3">
                            <label class="form-label">Ý kiến phản hồi&nbsp;<span class="text-danger">*</span></label >
                            <textarea type="text" name="ksnb_comment" class="form-control" placeholder="Ý kiến phản hồi từ kiểm soát nội bộ"></textarea>
                        </div>
                        @endif
                        @if ($detail->process == 10)
                        <div class="mb-3">
                            <label class="form-label">Kết luận&nbsp;<span class="text-danger">*</span></label >
                            <textarea type="text" name="infer" class="form-control" placeholder="Ý kiến kết luận từ TBP KSNB"></textarea>
                        </div>
                        @endif
                    </div>
               </div>

                <div class="col-md-6">
                  <legend style="color: #2dbbff; font-size: 20px;">Thông Tin Nhân Viên Vi Phạm Liên Quan</legend>
                  <div class="mb-3">
                      <label  class="form-label">Phòng ban</label>
                      <input type="text" name="store_name" class="form-control" id="store_name" value="{{$detail->store_name}}" disabled>
                  </div>
                  <div class="mb-3">
                      <label  class="form-label">Email trưởng phòng</label>
                      <input type="text" name="email_tpgd" class="form-control" id="email_tpgd" value="{{$detail->email_tpgd}}" disabled>
                  </div>
                  <div class="mb-3">
                      <label  class="form-label">Email nhân viên</label>
                      <input type="text" name="user_email" class="form-control" id="user_email" value="{{$detail->user_email}}" disabled>
                  </div>
                  <div class="mb-3">
                      <label  class="form-label">Tên nhân viên vi phạm</label>
                      <input type="text" name="user_name" class="form-control" id="user_name" value="{{$detail->user_name}}" disabled>
                  </div>
                  <div class="mb-3">
                    <label  class="form-label" style="font-style: 18px">Ảnh/Video ghi nhận sự việc&nbsp; <span class="text-danger">*</span></label>
                    <div class="img" id="img">
                      <div id="imgInput" class="block" style="display: none;">
                        <label for="file"><div class="box">+</div></label>
                        <input type="file" id="file" name="file" style="display: none;" multiple="multiple">
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="col-md-12" style="border-top: 1px solid #dee2e6">
                @if ($detail->process == 1)
                  @if (in_array($user, $ksnb))
                  <button type="submit" name="typeConfirm" id="typeConfirm" class="btn btn-success" style="margin-top: 10px">Duyệt phiếu ghi</button>
                  <a href='' name="typeNotConfirm" id="typeNotConfirm" class="btn btn-warning" style="margin-top: 10px; color:white">Trả về</a>
                  @endif
                @endif
                @if($detail->process == 8) 
                @if(in_array($user, $cancelReportNv))
                  <button type="submit" name="typeSendConfirm" id="typeSendConfirm" class="btn btn-success" style="margin-top: 10px">Gửi duyệt phiếu ghi</button>
                @endif
                @endif
                @if($detail->process == 4)
                  @if(in_array($user, $cancelReportNv))
                  <button type="submit" class="btn btn-success" name="typeReConfirm" id="typeReConfirm" style="margin-top: 10px">Gửi duyệt lại phiếu ghi</button>
                  @endif
                @endif
                @if($detail->process == 5)
                  @if (in_array($user, $cancelReportNv))
                  <button type="submit" class="btn btn-success" name="typeksnb" id="typeksnb" style="margin-top: 10px">Gửi phản hồi</button>
                  <a href='' id="typeWaitInfer" name="typeWaitInfer" class="btn btn-success" style="margin-top: 10px">
                    Chờ kết luận
                  </a>
                  @endif
                @endif
                @if($detail->process == 7)
                @if(in_array($user, $ksnb))
                  <button type="submit" class="btn btn-success" name="confirmAgain" id="confirmAgain" style="margin-top: 10px">Duyệt lại</button>
                  <a href='' name="typeNotConfirm" id="typeNotConfirm" class="btn btn-warning" style="margin-top: 10px; color:white">Trả về</a>
                @endif
                @endif
                @if($detail->process == 9)
                @if(in_array($user, $cancelReportNv))
                  <button type="submit" class="btn btn-success" name="typeWaitInfer" id="typeWaitInfer" style="margin-top: 10px">Chờ kết luận</button>
                @endif
                @endif

                @if($detail->process == 10)
                @if(in_array($user, $ksnb))
                  <button type="submit" class="btn btn-success" name="typeInfer" id="typeInfer" style="margin-top: 10px">Kết luận</button>
                @endif
                @endif
                <a href='{{url("/cpanel/reportsKsnb/getAllNote")}}' class="btn btn-danger" style="margin-top: 10px"> Quay lại</a>
            </div>
        </form>
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

  <div class="modal fade" id="modal_send_confirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Gửi yêu cầu duyệt thành công</h5>
          </div>
          <div class="modal-body">
            <p class="msg_success text-success">Phiếu ghi nhận đã được gửi cho trưởng bộ phận</p>
          </div>
          <div class="modal-footer">
            <a id="redirect-url" href='{{url("/cpanel/reportsKsnb/detailNote/$detail->_id")}}' class="btn btn-danger">Đóng</a>
          </div>
        </div>
      </div>
    </div>
  
    <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
    <div class="modal-dialog">
    <form action='{{url("cpanel/reportsKsnb/notConfirmNote/$detail->_id")}}' method="post" enctype="multipart/form-data" id="modal_not_confirm" >
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Phiếu ghi nhận sự việc chưa được duyệt</h5>
          <!-- <button type="button" class="btn-close" data-bs-dismiss="modal"></button> -->
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="message-text" class="col-form-label">Lý do trả về:</label>
            <textarea class="form-control" id="reason_not_confirm" name="reason_not_confirm"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="close">Đóng</button>
          <button id="submit_not_confirm" type="submit" class="btn btn-success" disabled>Gửi</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal_Reconfirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Phiếu ghi nhận đã được gửi duyệt lại</h5>
          </div>
          <div class="modal-body">
            <p class="msg_success text-success">Phiếu ghi nhận sự việc đã được gửi cho trưởng bộ phận</p>
          </div>
          <div class="modal-footer">
            <a id="redirect-url" href='{{url("/cpanel/reportsKsnb/detailNote/$detail->_id")}}' class="btn btn-danger">Đóng</a>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modalInfer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Kết luận cho phiếu ghi nhận</h5>
          </div>
          <div class="modal-body">
            <p class="msg_success text-success">Kết luận đã được gửi thành công</p>
          </div>
          <div class="modal-footer">
            <a id="redirect-url" href='{{url("/cpanel/reportsKsnb/detailNote/$detail->_id")}}' class="btn btn-danger">Đóng</a>
          </div>
        </div>
      </div>
    </div>


    <div class="modal fade" id="modalWaitInfer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
      <div class="modal-dialog">
      <form action='{{url("cpanel/reportsKsnb/waitInferNote/$detail->_id")}}' method="post" enctype="multipart/form-data" id="modal_wait_infer" >
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Gửi yêu cầu đưa ra kết luận</h5>
          </div>
          <div class="modal-body">
            <p class="msg_success text-success">Bạn có muốn kết thúc phiên phản hồi ?</p>
            <p class="msg_success text-success">Xác nhận để chờ trưởng bộ phận đưa ra kết luận ?</p>
          </div>
          <div class="modal-footer">
            <button  type="submit" class="btn btn-success" id="submit_wait_infer">Xác nhận</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="close">Đóng</button>
          </div>
        </div>
      </form>
      </div>
    </div>

    <div class="modal fade" id="modal_ksnb_feedback" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Phản hồi từ KSNB</h5>
          </div>
          <div class="modal-body">
            <p class="msg_success text-success">Ý kiến phản hồi từ phía kiểm soát nội bộ đã được gửi</p>
          </div>
          <div class="modal-footer">
            <a id="redirect-url" href='{{url("/cpanel/reportsKsnb/detailNote/$detail->_id")}}' class="btn btn-danger">Đóng</a>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal_confirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Phiếu ghi nhận đã được duyệt</h5>
          </div>
          <div class="modal-body">
            <p class="msg_success text-success">Phiếu ghi nhận sự việc đã gửi thành công</p>
          </div>
          <div class="modal-footer">
            <a id="redirect-url" href='{{url("/cpanel/reportsKsnb/detailNote/$detail->_id")}}' class="btn btn-danger">Đóng</a>
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

            <p class="h4" style="font-family: Times New Roman, Times, serif; margin-bottom: 20px; border-bottom: 1px solid #dee2e6;">Ý kiến NV:</p>
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
            <p class="h4" style="font-family: Times New Roman, Times, serif; margin-bottom: 20px; border-bottom: 1px solid #dee2e6; word-break: break-all;">Ý kiến của KSNB:</p>
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
            <p class="h4" style="font-family: Times New Roman, Times, serif; margin-bottom: 20px; border-bottom: 1px solid #dee2e6; word-break: break-all;">Kết luận của TBP:</p>
            @if(isset($detail['infer']))
            <ul class="list-unstyled" style="width: 100%; height: 350px; overflow: auto;">
            <?php $logs = isset($detail->logs) ? $detail->logs:[]; ?>
            @for($i = count($logs) - 1; $i >= 0; $i--)
              @if($logs[$i]['action'] == "Đưa ra kết luận")
            <li>
              <figure>
              <p>Trưởng Bộ Phận: <span style="color: #383efbbf; font-weight: 300">{{$logs[$i]['created_by']}}</span></p>
                <figcaption class="blockquote-footer">
                  <p>{{$detail->infer}}</p>
                  <p>Thời gian: {{date('d/m/Y H:i:s', $logs[$i]['created_at'])}}</p>
                </figcaption>
              </figure>
            </li>
              @break
            @endif
          @endfor
          </ul>
            @else
            <p style="font-weight: 300">Chưa có</p>
            @endif
        </div>

        <div class="col-md-3">
          <p class="h4" style="font-family: Times New Roman, Times, serif; margin-bottom: 20px; border-bottom: 1px solid #dee2e6;">Lịch sử</p>
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

  $('#typeNotConfirm').on('click', function (e) {
      $('#exampleModal').modal('show');
      e.preventDefault();
    });
    $('textarea[name="reason_not_confirm"]').keyup(function(){
        val = $('#reason_not_confirm').val().trim(); 
        if(val.length > 0){
            $("#submit_not_confirm").attr("disabled", false);
            $("#modal_not_confirm").submit( function (e) {
              $("#submit_not_confirm").html("Đang thực hiện...").prop('disabled',true); 
              $("#submit_not_confirm").prop('disabled', true);
              return true;
            });
        } else {
          $("#submit_not_confirm").prop('disabled', true);
        }
      });
</script>
<script>
  $(document).ready(function() {

    $('#typeSendConfirm').on('click', function(e) {
      e.preventDefault();
      $(".error-class").remove();
      $("#typeSendConfirm").prop('disabled', true);
      var form = $("#waitConfirm");
      var url = form.attr('action');
      $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(), // serializes the form's elements.
        success: function(data) {
              console.log(data);
              if (data['status'] == 200) {
                  $("#modal_send_confirm").modal('show');
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
              $("#typeSendConfirm").prop('disabled', false);
          },
      })
    });

    $('#typeConfirm').on('click', function(e) {
      e.preventDefault();
      $(".error-class").remove();
      $("#typeConfirm").prop('disabled', true);
      var form = $("#confirm");
      var url = form.attr('action');
      $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(), // serializes the form's elements.
        success: function(data) {
              console.log(data);
              if (data['status'] == 200) {
                  $("#modal_confirm").modal('show');
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
              $("#typeConfirm").prop('disabled', false);
          },
      })
    });

    $('#typeReConfirm').on('click', function(e) {
      e.preventDefault();
      $(".error-class").remove();
      $("#typeReConfirm").prop('disabled', true);
      var form = $("#reConfirm");
      var url = form.attr('action');
      $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(), // serializes the form's elements.
        success: function(data) {
              console.log(data);
              if (data['status'] == 200) {
                  $("#modal_Reconfirm").modal('show');
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
              $("#typeReConfirm").prop('disabled', false);
          },
      })
    });

    $('#typeksnb').on('click', function(e) {
      e.preventDefault();
      $(".error-class").remove();
      $("#typeksnb").prop('disabled', true);
      var form = $("#ksnbFeedback");
      var url = form.attr('action');
      $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(), // serializes the form's elements.
        success: function(data) {
              console.log(data);
              if (data['status'] == 200) {
                  $("#modal_ksnb_feedback").modal('show');
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
              $("#typeksnb").prop('disabled', false);
          },
      })
    });

    $('#confirmAgain').on('click', function(e) {
      e.preventDefault();
      $(".error-class").remove();
      $("#confirmAgain").prop('disabled', true);
      var form = $("#confirm");
      var url = form.attr('action');
      $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(), // serializes the form's elements.
        success: function(data) {
              console.log(data);
              if (data['status'] == 200) {
                  $("#modal_confirm").modal('show');
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
              $("#confirmAgain").prop('disabled', false);
          },
      })
    });

    $('#typeWaitInfer').on('click', function(e) {
      $('#modalWaitInfer').modal('show');
      e.preventDefault();
    });
    $("#modal_wait_infer").submit( function (e) {
      $("#submit_wait_infer").html("Đang thực hiện...").prop('disabled',true); 
      $("#submit_wait_infer").prop('disabled', true);
      return true;
    });

    $("#typeInfer").on('click', function(e) {
    e.preventDefault();
    $(".error-class").remove();
    $("#typeInfer").prop('disabled', true);
    var form = $("#inferNote");
    var url = form.attr('action');
    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(), // serializes the form's elements.
        success: function(data) {
            console.log(data);
            if (data['status'] == 200) {
                $("#modalInfer").modal('show');
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
            $("#typeInfer").prop('disabled', false);
        },
     })
  });
})
</script>
@endsection

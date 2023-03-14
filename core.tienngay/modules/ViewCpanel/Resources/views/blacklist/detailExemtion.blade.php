@extends('viewcpanel::layouts.master')
@section('title', 'Thông Tin Liên Quan Nợ Xấu và Miễn Giảm')
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
    Thông Tin Nợ Xấu và Miễn Giảm
  </legend>
  <div class="new_report">
  @if(session('status'))
  <div class="alert alert-success">
      {{session('status')}}
  </div>
  @endif
  </div>
  <form id="mainForm" action='' method="post" enctype="multipart/form-data">
    <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}">
    <div class="row col-md-12 col-lg-8">
      <div class="col-md-6 col-sm-6">
        <label for="user_name" class="form-label">Họ và tên&nbsp;<span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="user_name" name="user_name" value="{{$exemtion['customer_name']}}" disabled>
      </div>
      <div class="col-md-6 col-sm-6">
        <label for="user_phone" class="form-label">Số điện thoại&nbsp;</label>
        <input type="text" class="form-control" id="user_phone" name="user_phone" value="{{$exemtion['customer_phone_number']}}" disabled>
      </div>
      <div class="col-md-6 col-sm-6">
        <label for="user_identify" class="form-label">Số Cmnd/cccd/hộ chiếu&nbsp;<span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="user_identify" name="user_identify" value="{{$exemtion['customer_identify']}}" disabled>
      </div>
      <div class="col-md-6 col-sm-6">
        <label for="temporary_address" class="form-label">Ghi chú Lead&nbsp;</label>
        <textarea type="text" class="form-control" id="temporary_address" name="temporary_address" disabled>{{$exemtion['note_lead']}}</textarea>
      </div>
        <div class="col-md-6 col-sm-6">
        <label for="temporary_address" class="form-label">Ghi chú THN&nbsp;</label>
        <textarea type="text" class="form-control" id="temporary_address" name="temporary_address" disabled>{{$exemtion['note_tp_thn']}}</textarea>
      </div>
        <div class="col-md-6 col-sm-6">
            <label for="temporary_address" class="form-label">Chi tiết hợp đồng&nbsp;</label><br>

            <a class="btn btn-danger" target="_blank" href='{{$cpanelURL.'/pawn/detail?id='.$exemtion['id_contract']}}' style="">Liên kết đến chi tiết hợp đồng</a>
      </div>

      <div class="row" id="url">
        <label  class="form-label" style="font-style: 18px">Đính kèm ảnh hoặc video</label>
        <div class="img" id="img">
          <div id="imgInput"></div>
        </div>
      </div>
    </div>
  </form>
  <div class="modal-footer" style="border-top: 2px solid #dee2e6">
    <div style="margin-top:10px;">
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
  var imgs = JSON.parse('{!! json_encode($img['path']) !!}');
  const isImg = function (url) {
      return(url.match(/\.(jpeg|jpg|gif|png)$/) != null);
  }
  if (imgs.length == 0) {
    $('#imgInput').text("Không có");
  } else {
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
  }

  $('#notConfirm').on('click', function (e) {
    $('#exampleModal').modal('show');
    e.preventDefault();
  });

</script>
@endsection



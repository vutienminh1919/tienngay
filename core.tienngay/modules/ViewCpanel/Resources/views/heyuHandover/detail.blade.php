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
  label, input, select, textarea, .time-value {
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
  .form-group {
    margin-top: 10px;
  }
  #delivery_time {
    border-radius: 5px;
    background-color: #377dff;
  }
  .breadcrumb {
    font-size: 13px;
    font-weight: 400;
  }
</style>
@endsection

@section('content')
<section class="main-content">
  <div id="loading" class="theloading" style="display: none;">
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
  </div>
  <div class="container">
    <h5 class="tilte_top inline-block" style="margin-right: 25px;">Chi tiết phiếu xuất kho</h5>
    @if ($detail['status'] == 1)
    <h5 class="inline-block" style="background-color: #ffc107;border-radius: 3px; color: #fff;font-size: 14px;padding: 4px 32px;">Đang chờ duyệt</h5>
    @elseif ($detail['status'] == 2)
    <h5 class="inline-block" style="background-color: #1D9752;border-radius: 3px; color: #fff;font-size: 14px;padding: 4px 52px;">Đã duyệt</h5>
    @elseif ($detail['status'] == 3)
    <h5 class="inline-block" style="background-color: #23272b;border-radius: 3px; color: #fff;font-size: 14px;padding: 4px 54px;">Đã hủy</h5>
    @endif
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{$handoverPath}}">Quản lý cấp phát</a></li>
        <li class="breadcrumb-item active" aria-current="page">Chi tiết phiếu xuất kho</li>
      </ol>
    </nav>
    <form id="form-create" method="post" action="">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="form-group row">
        <div class="col-sm">
          <label for="pgd" class="col-form-label">Phòng giao dịch</label>
          <select id="pgd" name="pgd" class="form-control" is-require="require" disabled>
            <option value="{{ $detail['store_id'] }}">{{ $detail['store_name'] }}</option>
          </select>
        </div>
        <div class="col-sm">
          <label for="driver_code" class="col-form-label">Mã tài xế</label>
          <input id="driver_code" type="text" class="form-control" is-require="require"  name="driver_code"placeholder="Nhập..." value="{{$detail['driver_code']}}" disabled>
        </div>
        <div class="col-sm">
          <label for="driver_name" class="col-form-label">Tên tài xế</label>
          <input id="driver_name" type="text" class="form-control" is-require="require" name="driver_name" placeholder="..." value="{{$detail['driver_name']}}" disabled>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm">
          <label for="coat" class="col-form-label">Áo khoác</label>
          <select id="coat" class="form-control" name="coat" is-require="require" disabled>
            @foreach($detail['coat'] as $key => $value)
            @if ($value > 0)
            <option value="{{$key}}">{{strtoupper($key)}}</option>
            @break
            @endif
            @endforeach
          </select>
        </div>
        <div class="col-sm">
          <label for="shirt" class="col-form-label">Áo phông</label>
          <select id="shirt" class="form-control" name="shirt" is-require="require" disabled>
            @foreach($detail['shirt'] as $key => $value)
            @if ($value > 0)
            <option value="{{$key}}">{{strtoupper($key)}}</option>
            @break
            @endif
            @endforeach
          </select>
        </div>
        <div class="col-sm">
          <label for="delivery_date" class="col-form-label">Ngày giao đồng phục</label>
          <div>
            <input type="text" class="form-control inline-block" is-require="require" name="delivery_date" id="delivery_date" placeholder="Chọn ngày" value="{{ Carbon\Carbon::createFromTimestamp($detail['delivery_date'])->format('Y-m-d H:i') }}" disabled/>
          </div>
          <span id="invalid-time" class="invalid"></span>
        </div>
      </div>
      @if($detail['status'] == 3)
      <div class="form-group row">
        <label for="upload" class="col-form-label">Lý do hủy</label>
        <div class="col-sm">
           <textarea class="form-control" rows="3" disabled>{{$detail['cancel_note']}}</textarea>
        </div>
      </div>
      @endif
      <div class="form-group">
        <label for="upload" class="col-form-label">Chứng từ</label>
        <div class="img-area">
          <div id="imgInput"></div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm">
          <label class="col-form-label inline-block">Người tạo: </label>
          <label class="col-form-label inline-block">{{$detail['created_by']}}</label>
        </div>
        <div class="col-sm">
          <label for="created_at" class="col-form-label inline-block">Thời gian tạo: </label>
          <label class="col-form-label inline-block">{{ Carbon\Carbon::createFromTimestamp($detail['created_at'])->format('Y-m-d H:i') }}</label>
        </div>
      </div>
      @if($detail['status'] == 2 || $detail['status'] == 3)
      <div class="row">
        <div class="col-sm">
          <label for="approved_by" class="col-form-label inline-block">Người phê duyệt: </label>
          <label class="col-form-label inline-block">{{$detail['approved_by']}}</label>
        </div>
        <div class="col-sm">
          <label for="approved_at" class="col-form-label inline-block">Thời gian phê duyệt: </label>
          <label class="col-form-label inline-block">{{ Carbon\Carbon::createFromTimestamp($detail['approved_at'])->format('Y-m-d H:i') }}</label>
        </div>
      </div>
      @endif
      <div class="form-group" style="margin: 25px 0;">
        @if($detail['status'] == 1)
          @if ($roleCancel)
          <button id="cancel" class="btn btn-danger inline-block submit">Hủy phiếu xuất kho</button>
          @endif
          @if ($roleApprove)
          <button id="approve" class="btn btn-success inline-block submit" >Phê duyệt</button>
          @endif
        @endif
      </div>
    </form>
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
          <button type="button" class="btn btn-secondary submit" data-bs-dismiss="modal">Close</button>
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
          <button type="button" class="btn btn-secondary submit" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="confirm-form" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <label class="col-form-label">Nhập lý do hủy</label>
          <textarea class="form-control" rows="3" name="cancel-note"></textarea>
        </div>
        <div class="modal-footer">
          <button id="cancel-confirmed" type="button" class="btn btn-danger submit">Xác nhận hủy</button>
          <button type="button" class="btn btn-secondary submit" data-bs-dismiss="modal">Close</button>
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
  var imgs = JSON.parse('{!! json_encode($detail["evidence"]) !!}');
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


  $("#approve").on('click', function(e) {
    e.preventDefault();
    $("#approve").prop('disabled', true);
    $("#cancel").prop('disabled', true);
    let form = $("#form-create");
    let url = "{{$approve}}";
    let id = "{{$detail['_id']}}";
    $.ajax({
        type: "POST",
        url: url,
        data: {_token: _token, id:id}, // serializes the form's elements.
        success: function(data) {
            console.log(data);
            if (data['status'] == 200) {
              $("#successModal").find(".msg_success").text(data['message']);
              $("#successModal").modal('show');
              location.reload();
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
      $("#approve").prop('disabled', false);
      $("#cancel").prop('disabled', false);
     });
  });

  $("#cancel").on('click', function(e) {
    e.preventDefault();
    $(".invalid-message").remove();
    $("[name='cancel-note']").val("");
    $("#confirm-form").modal('show');
  });

  $("#cancel-confirmed").on('click', function(e) {
    e.preventDefault();
    $(".invalid-message").remove();
    $("#approve").prop('disabled', true);
    $("#cancel").prop('disabled', true);
    let form = $("#form-create");
    let url = "{{$cancel}}";
    let id = "{{$detail['_id']}}";
    let cancleNote = $("[name='cancel-note']").val();
    if (cancleNote == "") {
      $("[name='cancel-note']").after('<span class="invalid invalid-message">Không được để trống.</span>');
      $("#approve").prop('disabled', false);
      $("#cancel").prop('disabled', false);
      return;
    }
    $("#confirm-form").modal('hide');
    $.ajax({
        type: "POST",
        url: url,
        data: {_token: _token, id:id, cancleNote: cancleNote}, // serializes the form's elements.
        success: function(data) {
            console.log(data);
            if (data['status'] == 200) {
              $("#successModal").find(".msg_success").text(data['message']);
              $("#successModal").modal('show');
              location.reload();
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
      $("#approve").prop('disabled', false);
      $("#cancel").prop('disabled', false);
     });
  })

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

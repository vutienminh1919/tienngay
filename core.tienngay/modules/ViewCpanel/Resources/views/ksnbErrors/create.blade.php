@extends('viewcpanel::layouts.master')

@section('title', 'Tạo mới mã lỗi')

@section('css')
    <link href="{{ asset('viewcpanel/css/report/report1.css') }}" rel="stylesheet"/>
    <style type="text/css">
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

        /* Add Animation - Zoom in the Modal */
        .modal-content, #caption {
          animation-name: zoom;
          animation-duration: 0.6s;
        }
    </style>
@endsection

@section('content')
<div class="">
	@if(session()->has('success'))
        <div class="alert alert-success">
          {{ session()->get('success') }}
        </div>
    @endif
<div class="create_code_error">
      <div id="loading" class="theloading" style="display: none;">
        <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
      </div>
    <div class="">
        <div class="create_report">
        <div id="loading" class="theloading" style="display: none;">
            <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
        </div>

        @if(session('status'))
            <div class="alert alert-success">
                {{session('status')}}
        </div>
        @endif
        <legend class="col-md-6" style="padding-bottom: 10px; border-bottom: 1px solid #dee2e6;margin-bottom: 50px;margin-top: 30px;color: #009535;">Tạo Mới Mã Lỗi Vi Phạm</legend>
            <form id="mainForm" action='{{url("cpanel/ksnb_erors/save")}}' method="post" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-6" style="margin-left:100px">
                <legend class="text-info" style="font-size: 20px;">Thông Tin Mã Lỗi</legend>
                    <div class="mb-3">
                        <label  for="quote_document" class="form-label">Quyết định:&nbsp;<span class="text-danger">*</span><i data-bs-toggle="tooltip" title="" data-bs-original-title="Văn bản/Quyết định đã được phê duyệt" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                        <textarea placeholder= "Tên văn bản/quyết định" class="form-control" name="quote_document"
                                      aria-describedby="basic-addon1"id="quote_document" value="{{old ('quote_document','') }}"></textarea>

                    </div>
                    <div class="mb-3">
                        <label for="no" class="form-label">Số&nbsp;<span class="text-danger">*</span><i data-bs-toggle="tooltip" title="" data-bs-original-title="Văn bản/Quyết định số" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                        <input class="form-control" name="no" placeholder= "Số văn bản/quyết định"
                                   aria-describedby="basic-addon1" id="no" value="{{old ('no','') }}">

                    </div>
                    <div class="mb-3">
                        <label for="sign_day" class="form-label">Ngày ban hành&nbsp;<span class="text-danger">*</span><i data-bs-toggle="tooltip" title="" data-bs-original-title="Văn bản/Quyết định có hiệu lực từ ngày" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                        <input class="form-control" name="sign_day" placeholder= "Ngày văn bản/quyết định được ban hành"
                                   aria-describedby="basic-addon1" id="sign_day" value="{{old ('sign_day','') }}">

                    </div>
                    <div class="mb-3">
                        <label for="code_error" class="form-label">Mã Lỗi:&nbsp;<span class="text-danger">*</span><i data-bs-toggle="tooltip" title="" data-bs-original-title="Được quy định trong văn bản/quyết định" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                        <input  class="form-control" name="code_error" placeholder= "Mã lỗi được quy định trong văn bản/quyết định"
                                   aria-describedby="basic-addon1" id="code_error" value="{{old ('code_error','') }}">
                          @if($errors->has('code_error'))
                            <p>{{$errors->first('code_error')}}</p>
                          @endif
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Nhóm vi phạm:&nbsp;<span class="text-danger">*</span><i data-bs-toggle="tooltip" title="" data-bs-original-title="Được quy định trong văn bản/quyết định" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                        <select style="margin-top: 5px" name="type" id="type" class="form-control">
                            <option value="">-- Chọn loại vi phạm --</option>
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
                        <label for="discipline" class="form-label">Hình thức kỷ luật:&nbsp;<span class="text-danger">*</span><i data-bs-toggle="tooltip" title="" data-bs-original-title="Được quy định trong văn bản/quyết định" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                        <select @if($errors->has('discipline')) style="border: 1px solid red" @endif style="margin-top: 5px" name="discipline" id="discipline" class="form-control {{ isset($error['discipline']) ? 'is-invalid' : '' }}">
                            <option value="">-- Chọn hình thức kỷ luật --</option>
                            <option value="1" @if(old('discipline') == '1'){{ 'selected' }}@endif>Khiển trách</option>
                            <option value="2" @if(old('discipline') == '2'){{ 'selected' }}@endif>Kéo dài thời hạn tăng lương/Cách chức</option>
                            <option value="3" @if(old('discipline') == '3'){{ 'selected' }}@endif>Kéo dài thời hạn tăng lương/Sa thải</option>
                            <option value="4" @if(old('discipline') == '4'){{ 'selected' }}@endif>Sa thải(Chờ họp hội đồng kỷ luật)</option>
                            <option value="5" @if(old('discipline') == '5'){{ 'selected' }}@endif>Từng sự vụ</option>
                        </select>
                        @if($errors->has('discipline'))
                            <p style="text-align: center" class="text-danger">{{ $errors->first('discipline') }}</p>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="punishment" class="form-label">Chế tài phạt:&nbsp;<span class="text-danger">*</span><i data-bs-toggle="tooltip" title="" data-bs-original-title="Được quy định trong văn bản/quyết định" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                        <select @if($errors->has('punishment')) style="border: 1px solid red" @endif style="margin-top: 5px" name="punishment" id="punishment" class="form-control {{ isset($error['punishment']) ? 'is-invalid' : '' }}">
                            <option value="">-- Chọn chế tài phạt --</option>
                            <option value="1" @if(old('punishment') == '1'){{ 'selected' }}@endif>10% </option>
                            <option value="2" @if(old('punishment') == '2'){{ 'selected' }}@endif>20% </option>
                            <option value="3" @if(old('punishment') == '3'){{ 'selected' }}@endif>30% </option>
                            <option value="4" @if(old('punishment') == '4'){{ 'selected' }}@endif>Sa thải(Chờ họp hội đồng kỷ luật)</option>
                            <option value="5" @if(old('punishment') == '5'){{ 'selected' }}@endif>Từng sự vụ</option>
                        </select>
                        @if($errors->has('punishment'))
                            <p style="text-align: center" class="text-danger">{{ $errors->first('punishment') }}</p>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả mã lỗi vi phạm:&nbsp;<span class="text-danger">*</span></label>
                        <textarea class="form-control" name="description" placeholder= "Mô tả chi tiết mã lỗi"
                                aria-describedby="basic-addon1" id="description" value="{{old ('description','') }}"></textarea>
                        @if($errors->has('description'))
                            <p style="text-align: center" class="text-danger">{{ $errors->first('description') }}</p>
                        @endif
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button id="typeCreate" type="submit" class="btn btn-success">Tạo mã lỗi</button>
                <a href='{{url("/cpanel/ksnb_erors/list")}}' style="margin-right: 50px">
                    <button type="button"
                            class="btn btn-danger">Quay lại
                    </button>
                </a>
              </div>
            </form>
            </div>
        </div>
    </div>
</div>
</div>

<!-- modal success -->
<div class="modal fade" id="successModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-success" id="staticBackdropLabel">Thành công</h5>
          </div>
          <div class="modal-body">
            <p class="msg_success text-primary"></p>
          </div>
          <div class="modal-footer">
            <a id="redirect-url" class="btn btn-success">Xem</a>
          </div>
        </div>
      </div>
    </div>

    <!-- modal error -->
    <div class="modal fade" id="errorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-primary" id="staticBackdropLabel">Có lỗi xảy ra</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="msg_error"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
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
</script>
<script type="text/javascript">
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl){
      return new bootstrap.Tooltip(tooltipTriggerEl)
    });
    var dp = $("#sign_day").datepicker( {
        format: "dd-mm-yyyy",
        autoclose: true
    }).datepicker();
</script>
<script type="text/javascript">
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
                    console.log(data['errors']);
                    $(".msg_error").empty();
                    if (data['status'] == 200) {
                        $("#successModal").find(".msg_success").text(data['message']);
                        $("#successModal").find("#redirect-url").attr("href", data['data']['redirectURL']);
                        $("#successModal").modal('show');
                    } else {
                      if(data['errors']) {
                        $.each(data['errors'], function(key, value) {
                          $(".msg_error").append('<li style="list-style:none"><p class="text-danger">' + value + '</p></li>');
                          $("#errorModal").modal('show');
                        });
                      }
                    }
                    $("#typeCreate").prop('disabled', false);
                }
            });
        });
    });
</script>
@endsection

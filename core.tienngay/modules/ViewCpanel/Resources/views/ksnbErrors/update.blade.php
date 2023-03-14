@extends('viewcpanel::layouts.master')

@section('title', 'Cập nhật mã lỗi')

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
        <legend class="col-md-6" style="padding-bottom: 10px; border-bottom: 1px solid #dee2e6;margin-bottom: 50px;margin-top: 30px;color: #009535;">Cập Nhật Mã Lỗi</legend>
        <div class="new_report">
            <div class="row" style="padding-top: 10px">
              <div class="col-md-6" style="margin-left:100px">
                <legend style="color: #2dbbff; font-size: 20px;">Thông Tin Mã Lỗi</legend>
                <form id="mainForm" action='{{url("/cpanel/ksnb_erors/update/$detail->id")}}' method="post">
                    <div class="mb-3">
                        <label  class="form-label">Quyết định&nbsp;<span class="text-danger">*</span><i data-bs-toggle="tooltip" title="" data-bs-original-title="Văn bản/Quyết định đã được phê duyệt" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                        <input type="text" name="quote_document" class="form-control" id="quote_document" value="{{$detail['quote_document']}}">
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">Số&nbsp;<span class="text-danger">*</span><i data-bs-toggle="tooltip" title="" data-bs-original-title="Văn bản/Quyết định số" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                        <input name="no" target="_blank" class="form-control" id="no" value="{{$detail['no']}}">
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">Ngày ban hành&nbsp;<span class="text-danger">*</span><i data-bs-toggle="tooltip" title="" data-bs-original-title="Văn bản/Quyết định có hiệu từ lực ngày" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                        <input type="text" name="sign_day" class="form-control" id="sign_day" value="{{$detail['sign_day']}}" >
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">Nhóm lỗi vi phạm&nbsp; <span class="text-danger">*</span><i data-bs-toggle="tooltip" title="" data-bs-original-title="Nhóm vi phạm đã có trong quyết định ban hành" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                        <select @if($errors->has('type')) style="border: 1px solid red" @endif name="type" class="form-control type">
                            <option value="">Tất cả</option>
                            <option value="1" @if ($detail->type == 1) selected="selected" @endif>Vi phạm nội quy công ty</option>
                            <option value="2" @if ($detail->type == 2) selected="selected" @endif>Vi phạm liên quan đến khách hàng</option>
                            <option value="3" @if ($detail->type == 3) selected="selected" @endif> Vi phạm liên quan đến hoạt động phòng giao dịch</option>
                            <option value="4" @if ($detail->type == 4) selected="selected" @endif>Các vi phạm khác</option>
                        </select>
                        @if($errors->has('type'))
                            <p style="text-align: center" class="text-danger">{{ $errors->first('type') }}</p>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">Lỗi vi phạm&nbsp; <span class="text-danger">*</span><i data-bs-toggle="tooltip" title="" data-bs-original-title="Mã lỗi vi phạm đã có trong quyết định ban hành" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                        <input @if($errors->has('code_error')) style="border: 1px solid red" @endif type="text" name="code_error" class="form-control" id="code_error" value="{{$detail['code_error']}}" >
                        @if($errors->has('code_error'))
                            <p style="text-align: center" class="text-danger">{{ $errors->first('code_error') }}</p>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">Hình thức kỷ luật&nbsp; <span class="text-danger">*</span></label>
                        <select @if($errors->has('discipline')) style="border: 1px solid red" @endif name="discipline" class="form-control ">
                            <option value="">Tất cả</option>
                            <option value="1" {{ ($detail['discipline'] == '1') ? 'selected' : '' }}>Khiển trách</option>
                            <option value="2" {{ ($detail['discipline'] == '2') ? 'selected' : '' }}>Kéo dài thời hạn tăng lương/Cách chức</option>
                            <option value="3" {{ ($detail['discipline'] == '3') ? 'selected' : '' }}>Kéo dài thời hạn tăng lương/Sa thải</option>
                            <option value="4" {{ ($detail['discipline'] == '4') ? 'selected' : '' }}>Sa thải(Chờ họp hội đồng kỷ luật)</option>
                            <option value="5" {{ ($detail['discipline'] == '5') ? 'selected' : '' }}>Từng sự vụ</option>
                        </select>
                        @if($errors->has('discipline'))
                            <p style="text-align: center" class="text-danger">{{ $errors->first('discipline') }}</p>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">Chế tài phạt&nbsp; <span class="text-danger">*</span><i data-bs-toggle="tooltip" title="" data-bs-original-title="Trừ %KPI trong tháng vi phạm/lỗi/lần" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                        <select @if($errors->has('punishment')) style="border: 1px solid red" @endif name="punishment" class="form-control ">
                            <option value="">Tất cả</option>
                            <option value="1" {{ ($detail['punishment'] == '1') ? 'selected' : '' }}>10% kpi</option>
                            <option value="2" {{ ($detail['punishment'] == '2') ? 'selected' : '' }}>20% kpi</option>
                            <option value="3" {{ ($detail['punishment'] == '3') ? 'selected' : '' }}>30% kpi</option>
                            <option value="4" {{ ($detail['punishment'] == '4') ? 'selected' : '' }}>Sa thải(Chờ họp hội đồng kỷ luật)</option>
                            <option value="5" {{ ($detail['punishment'] == '5') ? 'selected' : '' }}>Từng sự vụ</option>

                        </select>
                        @if($errors->has('punishment'))
                            <p style="text-align: center" class="text-danger">{{ $errors->first('punishment') }}</p>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">Mô tả mã lỗi&nbsp; <span class="text-danger">*</span></label>
                        <textarea @if($errors->has('description')) style="border: 1px solid red" @endif type="text" name="description" class="form-control" id="description" >{{$detail['description']}}</textarea>
                        @if($errors->has('description'))
                            <p style="text-align: center" class="text-danger">{{ $errors->first('description') }}</p>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit" id = "typeUpdate">Cập nhật</button>
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
<script type="text/javascript" src="{{ asset('viewcpanel/js/autocomplete.js') }}"></script>
<script type="text/javascript">
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    var dp = $("#sign_day").datepicker( {
        format: "dd-mm-yyyy",
        autoclose: true
    }).datepicker();
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#typeUpdate").on('click', function(e) {
            e.preventDefault();
            $(".error-class").remove();
            $("#typeUpdate").prop('disabled', true);
            var form = $("#mainForm");
            var url = form.attr('action');
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                success: function(data) {
                    console.log(data);
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
                    $("#typeUpdate").prop('disabled', false);
                }
            });
        });
    });
</script>
@endsection



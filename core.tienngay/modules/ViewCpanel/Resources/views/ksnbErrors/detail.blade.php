@extends('viewcpanel::layouts.master')

@section('title', 'Chi tiết mã lỗi')

@section('css')
<link href="{{ asset('viewcpanel/css/report/report1.css') }}" rel="stylesheet"/>
<style type="text/css">

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
    @if ($errors && !empty($errors->first()))
    <div class="alert alert-danger">
      {{$errors->first()}}
    </div>
    @elseif(session('errors'))
    <div class="alert alert-danger">
      {{session('errors')}}
    </div>
    @endif
        <legend class="col-md-6" style="padding-bottom: 10px; border-bottom: 1px solid #dee2e6;margin-bottom: 50px;margin-top: 30px;color: #009535;">Chi Tiết Mã Lỗi</legend>
        <div class="new_report">
            <div class="row" style="padding-top: 10px">
              <div class="col-md-6" style="margin-left:100px">
                <legend style="color: #2dbbff; font-size: 20px;">Thông Tin Mã Lỗi</legend>
                <div class="mb-3">
                  <label  class="form-label">Quyết định&nbsp;<i data-bs-toggle="tooltip" title="" data-bs-original-title="Văn bản/Quyết định đã được phê duyệt" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                  <input type="text" name="quote_document" class="form-control" id="quote_document" value="{{$detail['quote_document']}}" disabled>
                </div>
                <div class="mb-3">
                  <label  class="form-label">Số&nbsp;<i data-bs-toggle="tooltip" title="" data-bs-original-title="Văn bản/Quyết định số" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                  <input name="no" target="_blank" class="form-control" id="no" value="{{$detail['no']}}" disabled>
                </div>
                <div class="mb-3">
                    <label  class="form-label">Ngày ban hành&nbsp;<i data-bs-toggle="tooltip" title="" data-bs-original-title="Văn bản/Quyết định có hiệu từ lực ngày" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                    <input type="text" name="sign_day" class="form-control" id="sign_day" value="{{$detail['sign_day']}}" disabled>
                </div>
                <div class="mb-3">
                    <label  class="form-label">Nhóm lỗi vi phạm&nbsp; <span class="text-danger">*</span><i data-bs-toggle="tooltip" title="" data-bs-original-title="Nhóm vi phạm đã có trong quyết định ban hành" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                    <input type="text" name="type" class="form-control" id="type" value="{{$detail['type_name']}}" disabled>
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
            </div>
            <div class="modal-footer">
                <a href='{{url("/cpanel/ksnb_erors/list")}}' style="margin-right: 50px">
                    <button type="button"
                            class="btn btn-danger">Quay lại
                    </button>
                </a>
              </div>
        </div>

@endsection

@section('script')
<script type="text/javascript">
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('viewcpanel/js/vpbank/transactions.js') }}"></script>
@endsection

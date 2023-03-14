@extends('viewcpanel::layouts.master')

@section('title', 'Chi tiết ngày nghỉ lễ')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/css/bootstrap-multiselect.min.css" integrity="sha512-fZNmykQ6RlCyzGl9he+ScLrlU0LWeaR6MO/Kq9lelfXOw54O63gizFMSD5fVgZvU1YfDIc6mxom5n60qJ1nCrQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
	body {
      font-family: Roboto;
      background: #f7f7f7;
      margin: 0 20px;
    }

    .content-body {
      padding: 22px 16px;
      margin-top: 34px;
    }

    .content-body1 {
      background: #ffffff;
    }

    /* content */
    .content {
      display: flex;
      justify-content: space-between;
    }

    .title-h1 {
      margin: 0;
      font-size: 20px;
      font-weight: 700;
    }

    .report {
      color: #676767;
      font-size: 12px;
      margin-bottom: 34px;
    }

    .btnn-prev {
      background-color: #d8d8d8;
      border: 1px solid #d2eadc;
      outline: none;
      color: #676767;
      border-radius: 5px;
      font-size: 14px;
      padding: 8px 16px;
      margin-right: 16px;
      margin-bottom: 10px;
    }

    /* content1 */
    .content1 {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .content1-title-h2 {
      font-size: 16px;
      font-weight: 700;
      margin-bottom: 0;
    }

    /* Search */
    .search {
      margin-left: 10px;
    }

    .btn-search {
      background-color: #d2eadc;
      border: 1px solid #d2eadc;
      outline: none;
      color: #1d9752;
      border-radius: 5px;
      font-size: 14px;
      padding: 6px;
      margin-right: 16px;
      white-space: nowrap;
      font-weight: 600;
    }

    .btn-cancel {
      background-color: #d8d8d8;
      outline: none;
      border: none;
      width: 49%;
      padding: 12px 0;
      font-size: 14px;
      border-radius: 5px;
    }
    th {
      border-bottom: none !important;
    }

    .btn-submit {
      background-color: #1d9752;
      outline: none;
      border: none;
      width: 49%;
      padding: 12px 0;
      color: #ffffff;
      font-size: 14px;
      border-radius: 5px;
    }

    .btn-search:hover {
      opacity: 0.8;
    }

    .date {
      display: flex;
      justify-content: space-between;
    }

    .date-input {
      width: 48%;
      border: 1px solid #ccc;
      outline: none;
      padding: 3px;
      border-radius: 5px;
    }

    .modal-header {
      border-bottom: none;
      margin: 0 auto;
      padding-bottom: 6px;
    }

    .modal-footer {
      border-top: none;
    }

    .modal-content {
      border: 1px solid #ccc;
    }
    /* moda btn */
    .modal-title {
      font-size: 1.25rem;
      font-weight: 600;
    }

    .modal-p {
      margin: 0 1rem;
      text-align: center;
    }

    .modal-body1 {
      padding-top: 0;
    }

    .start {
      color: red;
    }

    .action {
      color: #1d9752;
      cursor: pointer;
    }
    .note {
      margin-bottom: 0;
    }

    textarea {
      border: 1px solid #d8d8d8;
      padding: 5px 12px;
    }
    /* end modal */

    /* table */
    .background-tr {
      background-color: #e8f4ed;
    }

    .content1-table {
      margin-top: 16px;
    }

    th {
      font-size: 14px;
    }

    th,
    td {
      border-top: none;
      white-space: nowrap;
      text-align: center;
      font-size: 14px;
      border-bottom: 1px solid #dee2e6;
    }
    td {
      color: #676767;
    }

    .the-th {
      min-width: 200px;
    }

    .backgr-btn {
      background: none;
      border: none;
      color: #1d9752;
    }

    .pd-td {
      display: table-cell;
      vertical-align: inherit !important;
    }

    .total {
      border-bottom: 1px solid #dee2e6;
    }

    .table-p {
      margin-bottom: 0;
      font-size: 10px;
      font-weight: 400;
    }

    .stt {
      width: 30px;
    }

    .dropdown-menu {
      font-size: 14px;
    }
    /*  */
    .btn-success {
      font-size: 14px;
      font-weight: 600;
      background-color: #1d9752;
      margin-right: 20px;
      padding: 8px 12px;
    }
    .icon-add {
      margin-left: 11px;
    }

    .modal-footer button {
      width: 100%;
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
    .hidden {
        display: none !important;
    }
    .btn-group, .multiselect-native-select {
      width: 100%;
    }

    form label, .content2 label {
      font-size: 14px;
      margin-top: 10px;
      font-weight: 600;
    }
    .form-check-label {
      color: #000 !important;
      font-weight: 300;
      margin-top: 0;
    }
    form span, input {
      font-size: 14px !important;
      color: gray;
    }
    input.invalid, textarea.invalid {
      border-color: red;
    }
    .invalid {
      color: red;
      font-size: 14px;
    }
</style>
<style type="text/css">
.switch {
  position: relative;
  display: inline-block;
  width: 47px;
  height: 25px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 20px;
  width: 20px;
  left: 0px;
  bottom: 3px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
@endsection

@section('content')
<section id="content" style="margin-top: 20px;">
<div id="loading" class="theloading hidden">
  <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
</div>
<div class="content-title">
    <div class="content flex-column flex-sm-row">
      <div>
        <h1 class="title-h1">Chi tiết ngày nghỉ lễ</h1>
      </div>
      @if (!$edit)
      <div style="text-align: right;">
        <a href='{{route("viewcpanel::PaymentHolidays.index")}}' class="btn btn-secondary">
        Trở về <i class="fa fa-arrow-left" aria-hidden="true"></i>
        </a>
        <a id="edit-form" href="{{route('viewcpanel::PaymentHolidays.edit', ['id' => $holiday['_id']])}}" class="btn btn-warning">
          Chỉnh sửa <i class="fa fa-edit" aria-hidden="true"></i>
        </a>
      </div>
      @endif
    </div>
  </div>
  <div class="content-body1 shadow mb-5 bg-white rounded">
    <div class="content-body">
      <form id="update-form" action="#" method="get" style="width: 100%">
      <div class="content1">
        <h2 class="content1-title-h2">Trạng thái: 
          @if (!$edit)
            @if ($holiday['status'] == $model::STATUS_ENABLE)
            <span style="color: rgb(11, 223, 11);">ACTIVE</span>
            @elseif ($holiday['status'] == $model::STATUS_DISABLE)
            <span style="color: red;">DISABLED</span>
            @else
            <span style="color: red;">KHÔNG XÁC ĐỊNH</span>
            @endif
          @else
            <label class="switch">
              <input type="checkbox" name="status" data-id="{{$holiday['_id']}}" @if($holiday['status'] == $model::STATUS_ENABLE) checked @endif>
              <span class="slider round"></span>
            </label>
          @endif
        </h2>
      </div>
      <div class="content2">
        <div class="row">
          <div class="form-group col-md-6 col-sm-12">
            <label for="inputEmail4">Tên sự kiện</label>
            <input class="form-control" name="name" value="{{$holiday['name']}}" @if(!$edit) disabled @endif>
          </div>
          <div class="form-group col-md-3 col-sm-6">
            <label for="inputPassword4">Từ ngày</label>
            <input id="start-date" class="form-control" name="start_date" value="{{date('Y-m-d', $holiday['start_date'])}}" @if(!$edit) disabled @endif>
          </div>
          <div class="form-group col-md-3 col-sm-6">
            <label for="inputPassword4">Đến ngày</label>
            <input id="end-date" class="form-control" name="end_date" value="{{date('Y-m-d', $holiday['end_date'])}}" @if(!$edit) disabled @endif>
          </div>
        </div>
        <div class="form-group">
          <label for="inputAddress">Nội dung</label>
          <textarea class="form-control" name="description" rows="3" @if(!$edit) disabled @endif>{{$holiday['description']}}</textarea>
        </div>
        <div class="row">
          <div class="form-group col-md-6 col-sm-6">
            <label for="inputPassword4">Người tạo</label>
            <input class="form-control" value="{{$holiday['created_by']}}" disabled>
          </div>
          <div class="form-group col-md-6 col-sm-6">
            <label for="inputPassword4">Ngày tạo</label>
            <input class="form-control" value="{{date('Y-m-d', $holiday['created_at'])}}" disabled>
          </div>
          <div class="form-group col-md-6 col-sm-6">
            <label for="inputPassword4">Người cập nhật</label>
            <input class="form-control" value="{{$holiday['updated_by']}}" disabled>
          </div>
          <div class="form-group col-md-6 col-sm-6">
            <label for="inputPassword4">Ngày cập nhật</label>
            <input class="form-control" value="{{date('Y-m-d', $holiday['updated_at'])}}" disabled>
          </div>
        </div>
      </div>
    </div>
    @if ($edit)
    <div style="text-align: right; padding-bottom: 45px;">
      <a href='{{route("viewcpanel::PaymentHolidays.detail", ["id" => $id])}}' class="btn btn-danger">
        Huỷ <i class="fa fa-times" aria-hidden="true"></i>
      </a>
      <button type="submit" id="edit-form-submit" class="btn btn-success">
        Cập nhật <i class="fa fa-edit" aria-hidden="true"></i>
      </button>
    </div>
    @endif
    </form>
  </div>

<!-- Modal create -->
<div class="modal fade" id="create-form-modal" tabindex="-1" role="dialog" aria-labelledby="searchFormTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <form id="create-new" action="#" method="get" style="width: 100%">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="searchFormTitle">Tạo mới</h5>
        </div>
        <div class="modal-body">
            <div class="form-group">
              <label for="exampleInputEmail1">Tên sự kiện</label>
              <input name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nhập"/>
            </div>
            <div class="form-group">
              <label class="form-label">Ngày thanh toán muộn nhất:</label>
              <input type="text" class="form-control" name="end_date" id="end-date" placeholder="yyyy-mm-dd">
            </div>
            <div class="form-group mb-3">
              <label class="form-label" style="margin-top: 0px;">Từ ngày:</label>
              <input type="text" class="form-control" name="start_date" id="start-date" placeholder="yyyy-mm-dd">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Mô tả</label>
              <textarea name="description" style="width: 100%" rows="3"></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <div class="row" style="width: 100%">
            <div class="col-md-6 col-sm-6 col-xs-12 col-6">
              <button id="submit-search" type="submit" class="btn-submit ">Tạo mới</button>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 col-6">
              <button type="button" class="btn-cancel" data-bs-dismiss="modal">Hủy</button>
            </div>
          </div>
        </div>
      </div>
      </form>
  </div>
</div>

<!-- Modal search -->
<div class="modal fade" id="search-form" tabindex="-1" role="dialog" aria-labelledby="searchFormTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <form action="#" method="get" style="width: 100%">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="searchFormTitle">Tìm kiếm</h5>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label for="exampleInputEmail1">Tên sự kiện</label>
            <input
              name="plan_name"
              class="form-control"
              id="exampleInputEmail1"
              aria-describedby="emailHelp"
              placeholder="Nhập"
            />
          </div>
          <div class="form-group mb-3">
              <label class="form-label">Thời gian tạo</label>
              <div style="padding-left: 20px;">
                  <label class="form-label" style="margin-top: 0px;">Từ ngày:</label>
                  <input type="text" class="form-control" name="start_date" id="start-date" placeholder="yyyy-mm-dd"
                  >
                  <label class="form-label">Đến ngày:</label>
                  <input type="text" class="form-control" name="end_date" id="end-date" placeholder="yyyy-mm-dd"
                  >
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <div class="row" style="width: 100%">
          <div class="col-md-6 col-sm-6 col-xs-12 col-6">
            <button id="submit-search" type="submit" class="btn-submit ">Tìm kiếm</button>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12 col-6">
            <button type="button" class="btn-cancel" data-bs-dismiss="modal">Hủy</button>
          </div>
        </div>
      </div>
    </div>
    </form>
  </div>
</div>
<!-- Modal Hủy -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">
          Xoá đề xuất
        </h1>
      </div>
      <p class="modal-p">
        Bạn có chắc chắn muốn xoá đề xuất danh sách ấn phẩm này
      </p>

      <div class="modal-body">
        <p class="note">Lý do  <span class="start">*</span></p>
        <input id="trade-order-id" type="hidden" name="id">
        <input id="trade-order-url" type="hidden" name="url">
        <div class="modal-content">
          <textarea name="reason" 
            class="text"
            id=""
            cols="30"
            rows="4"
            placeholder="Nhập"
          ></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <div class="row" style="width: 100%">
          <div class="col-md-6 col-sm-6 col-xs-12 col-6">
            <button id="confirm-delete-modal" type="button" class="btn-submit ">Đồng ý</button>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12 col-6">
            <button type="button" class="btn-cancel" data-bs-dismiss="modal">Hủy</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="errorModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Error</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="text-align: center;">
        <p class="msg_error"></p>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="successModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Thành công</h5>
      </div>
      <div class="modal-body" style="text-align: center;">
        <p class="msg_success"></p>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
</section>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/js/bootstrap-multiselect.min.js" integrity="sha512-lxQ4VnKKW7foGFV6L9zlSe+6QppP9B2t+tMMaV4s4iqAv4iHIyXED7O+fke1VeLNaRdoVkVt8Hw/jmZ+XocsXQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#stores, #motivatingGoals, #status').multiselect({
        templates: {
            button: '<button style="background: #FFFFFF;border: 1px solid #D8D8D8;border-radius: 5px;width: 100%;height: 38px;text-align: left !important;padding-left: 12px;outline: none;" type="button" class="multiselect dropdown-toggle button_target_goal" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span></button>'
        },
        // enableFiltering: true,
    });

    var dp = $("#start-date, #end-date").datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });
  });
  const csrf = "{{ csrf_token() }}";

  const SaveData = async function (data, url, callback) {
    $("#loading").removeClass('hidden');
    const response = await fetch(url, {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'x-csrf-token': csrf,
            "Content-Type": "application/json",
            Accept: "application/json",
        }
    });
    const result = await response.json();
    callback(result, data);
    $("#loading").addClass('hidden');
  }
  $("#update-form").on("submit", function(e){
    e.preventDefault();
    $('span.invalid').remove()
    $('input.invalid, textarea.invalid').removeClass('invalid')
    let data = {
      id: '{{$id}}',
      status: $("#update-form").find('[name="status"]').is(":checked") ? 1 : 2,
      name: $("#update-form").find('[name="name"]').val(),
      description : $("#update-form").find('[name="description"]').val(),
      start_date : $("#update-form").find('[name="start_date"]').val(),
      end_date : $("#update-form").find('[name="end_date"]').val(),
    }
    function callback(response, _data) {
      if (response.status == 200) {
        $("#successModal").find(".msg_success").text("Cập nhật thành công");
        $("#successModal").modal('show');
        setTimeout(function(){location.href = '{{route("viewcpanel::PaymentHolidays.detail", ["id" => $id])}}'}, 2000); 
      } else {
        if (response.errors) {
          $.each(response.errors, function(index, value) {
            $("#update-form").find('[name="'+index+'"]').addClass('invalid')
            $("#update-form").find('[name="'+index+'"]').after('<span class="invalid">'+value+'</span>')
          })
        }
      }
    }
    SaveData(data, '{{$updateUrl}}', callback)
  })
</script>
@endsection
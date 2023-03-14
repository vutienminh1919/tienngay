@extends('viewcpanel::layouts.master')

@section('title', 'Danh Sách Nhân Sự Nghỉ Việc Ở VFC')

@section('css')
<link href="{{ asset('viewcpanel/css/reportsKsnb/index.css') }}" rel="stylesheet"/>
<style type="text/css">
    .alert {
        z-index: 999 !important;
    }

    .modal-backdrop {
            display: none !important;
        }

</style>
@endsection

@section('content')
<section class="main-content">
    <div id="loading" class="theloading" style="display: none;">
        <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    </div>
    <div id="top-view" class="container" style="max-width: 95% !important">
        <h3 class="tilte_top_tabs">
            Danh sách nhân sự nghỉ việc ở VFC
        </h3>

        <div class="row" style="align-items: right;">
            <div class="col-xs-12 col-12">
                @include("viewcpanel::hcns.filter")
            </div>
        </div>
        <div class="middle table_tabs">
            <p style="color: #047734"><strong>Tổng bản ghi:</strong>&nbsp;<span id="total">{{$records->total()}}</span></p>
            <div class="table-responsive" style="overflow-x: auto;">
                <table class="table" style="margin-bottom: 100px">
                    <thead>
                        <tr style="text-align: center">
                            <th scope="col" style="text-align: center;">STT</th>
                            <th scope="col" style="text-align: center; min-width: 200px;">CHỨC NĂNG</th>
                            <th scope="col" style="text-align: center; min-width: 200px;">HỌ VÀ TÊN</th>
                            <th scope="col" style="text-align: center; min-width: 200px;">EMAIL CÁ NHÂN</th>
                            <th scope="col" style="text-align: center; min-width: 200px;">SỐ ĐIỆN THOẠI</th>
                            <th scope="col" style="text-align: center; min-width: 200px;">ĐỊA CHỈ<i data-bs-toggle="tooltip" title="" data-bs-original-title="Địa chỉ thường trú" style="color: #047734" class="fa fa-question-circle-o" aria-hidden="true"></i></th>
                            <th scope="col" style="text-align: center; min-width: 200px;">SỐ CMND/CCCD</th>
                            <th scope="col" style="text-align: center; min-width: 200px;">SỐ HỘ CHIẾU</th>
                            <th scope="col" style="text-align: center; min-width: 200px;">NGÀY BẮT ĐẦU</th>
                            <th scope="col" style="text-align: center; min-width: 200px;">NGÀY NGHỈ VIỆC</th>
                            <th scope="col" style="text-align: center; min-width: 200px;">LÝ DO NGHỈ VIỆC</th>
                            <th scope="col" style="text-align: center; min-width: 200px;">NGÀY TẠO</th>
                            <th scope="col" style="text-align: center; min-width: 200px;">NGƯỜI TẠO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @if(isset($records))
                            @foreach ($records as $key => $record)
                            <td  style="text-align: center" scope="row">{{$key + 1}}</td>
                            <td class="more" style="text-align: center">
                                <div  class="btn-group"  style="text-align: center">
                                    <button type="button" class="btn btn-success" style="font-style: 14px; border-radius: 5px"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        Chức năng&nbsp;<i class="fa fa-bars" aria-hidden="true" style="font-style: 14px"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" target='_blank' href='{{$cpanelURL.route("viewcpanel::hcns.detailRecord" , ["id" => "$record->_id"])}}'>Chi tiết</a></li>
                                        <li><a class="dropdown-item" target='_blank' href='{{$cpanelURL.route("viewcpanel::hcns.editRecord" , ["id" => "$record->_id"])}}'>Cập nhật</a></li>
                                    </ul>
                                </div>
                            </td>
                            <td style="text-align: center">{{$record->user_name}}</td>
                            <td style="text-align: center">{{$record->user_email}}</td>
                            <td style="text-align: center">{{$record->user_phone}}</td>
                            <td style="min-width: 130px;text-align: center">{{$record->permanent_address}}</td>
                            <td style="text-align: center">{{$record->user_identify}}</td>
                            <td style="text-align: center">{{$record->user_passport}}</td>
                            <td style="min-width: 160px;text-align: center">{{$record->day_on}}</td>
                            <td style="min-width: 160px;text-align: center">{{$record->day_off}}</td>
                            <td class="more1" style="text-align: center">{{$record->reason_for_leave}}</td>
                            <td class="more1" style="text-align: center">{{date('Y-m-d', $record->created_at)}}</td>
                            <td class="more1" style="min-width: 130px;text-align: center">{{$record->created_by}}</td>
                        </tr>
                        @endforeach
                        @endif
                </tbody>
                </table>
            </div>
        </div>
        @if(!empty($records))
        <nav aria-label="Page navigation" style="margin-top: 20px;">
          {{$records->withQueryString()->links()}}
        </nav>
        @endif
    </div>

    <!-- Modal import nhân sự nghỉ việc -->
<div class="modal fade" id="modal_import" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
   aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div>
          <h3 class="text-primary ten_oto" style="text-align: left">
            Thêm danh sách nhân sự nghỉ việc 
          </h3>
        </div>
      </div>
      <div class="modal-body ">
        <input type="file" id ="file_import" name="import" class="form-control" placeholder="chọn file">
        <button class="btn btn-secondary btn-success" type="button" aria-expanded="false" id="downdload_import" style="font-size:unset;background-color: #3b62df;border-color: #3b62df;margin-top: 25px;"><i class="fa fa-download"></i>
          Download biểu mẫu 
        </button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
        <a href="" title="Xác nhận" class="company_xn btn btn-success" id="import_submit">Xác nhận</a>
      </div>
    </div>
  </div>
</div>

    <div class="modal fade" id="errorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 1000;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Thất bại</h5>
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
    $("#fillter-button").on("click", function (event) {
        event.stopPropagation();
        $("#fillter-content").toggle();
    })
    $("#clear-search-form").on("click", function (event) {
        event.preventDefault();
        document.getElementById("search-form").reset();
    });
    $("#close-search-form").on("click", function (event) {
        event.preventDefault();
        $("#fillter-content").hide();
    });
    $('body').on('click', function(e){
        if (e.target.id == "fillter-content" || $(e.target).parents("#fillter-content").length) {
            //do nothing
        } else {
            $("#fillter-content").hide();
        }
    });
    var dp = $("#start-date, #end-date").datepicker( {
        format: "yyyy-mm-dd",
        autoclose: true
    });
    $("#export_record").on('click', function() {
        var query = window.location.search;
        link = document.createElement("a")
        link.href = '{{$exportUrl}}' + query;
        link.target = "_blank"
        link.click()
        link.remove();
    })
    $("#downdload_import").on('click', function() {
      var query = window.location.search;
      link = document.createElement("a")
      link.href = '{{$downloadFile}}' + query;
      link.target = "_blank"
      link.click()
      link.remove();
    })
</script>
<script type="text/javascript">
    var dataSearch = JSON.parse('{!! json_encode($dataSearch) !!}');
    console.log(dataSearch);
    for (const property in dataSearch) {
      if (dataSearch[property] == null) {
        continue;
      }
      console.log(property, ' ', dataSearch[property]);
      $('#search-form').find("[name='" + property + "']").val(dataSearch[property]);
    }
</script>
<script>
$(document).ready(function () {
    $('#import_record').on('click', function(e){
        $('#modal_import').modal('show');
        e.preventDefault();
    });
    $("#import_submit").on('click', function (event) {
        event.preventDefault();
          var xls = ['application/vnd.ms-excel', 'application/msexcel', 'application/x-msexcel', 'application/x-ms-excel', 'application/x-excel', 'application/x-dos_ms_excel', 'application/xls', 'application/x-xls', 'application/excel', 'application/download', 'application/vnd.ms-office', 'application/msword','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip', 'application/vnd.ms-excel', 'application/msword', 'application/x-zip']; 
          var inputimg = $('input[name=import]');
          if (inputimg.val() == '') {
            alert("Không có file để import");
          }
          var fileToUpload = inputimg[0].files[0];
          var token = $('[name="_token"]').val();
          var formData = new FormData();
          formData.append('upload_file', fileToUpload);
          formData.append('_token', token);
          console.log(fileToUpload.type);
          if(xls.includes(fileToUpload.type)) {

          } else {
            alert("File import sai định dạng");
            return;
          }

          $.ajax({
              enctype: 'multipart/form-data',
              url: '{{$urlImport}}',
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
                console.log(data);
                  if (data.status == 200) {
                    $('#successModal').modal('show')
                    $('.msg_success').text("Import dữ liệu thành công")
                    setTimeout(function () {
                        window.location.reload()}, 2000);
                  } else {
                    $('#errorModal').modal('show')
                    $('.msg_error').text(data.message)
                  }
              },
              error: function () {
                  $(".theloading").hide();
                  $('#modal-danger').modal('show')
                  $('.msg_error').text("error")
              }
          });
    });
});
</script>
@endsection

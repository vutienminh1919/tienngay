@extends('viewcpanel::layouts.master')

@section('title', 'Danh sách yêu cầu ấn phẩm')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/css/bootstrap-multiselect.min.css" integrity="sha512-fZNmykQ6RlCyzGl9he+ScLrlU0LWeaR6MO/Kq9lelfXOw54O63gizFMSD5fVgZvU1YfDIc6mxom5n60qJ1nCrQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
	body {
      font-family: Roboto;
      /* background: #f7f7f7; */
      background: rgb(237, 237, 237);
      margin: 0 20px;
    }

    .content-body {
      padding: 22px 16px;
      margin-top: 24px;
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
      height: 32px;
      outline: none;
      color: #1d9752;
      display: flex;
      align-items: center;
      border-radius: 5px;
      font-size: 14px;
      padding: 6px;
      margin-right: 16px;
      white-space: nowrap;
      font-weight: 600;
    }

    .btn-cancel {
      background-color: #D8D8D8;
      color: #676767;
      outline: none;
      border: none;
      width: 49%;
      padding: 12px 0;
      font-size: 14px;
      border-radius: 5px;
      font-weight: 600;
    }
    th {
      border-bottom: none !important;
    }

    .btn-submit {
      background-color: #1d9752;
      color: #FFFFFF;
      outline: none;
      border: none;
      width: 49%;
      padding: 12px 0;
      color: #ffffff;
      font-size: 14px;
      border-radius: 5px;
      font-weight: 600;
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
      padding: 0.375rem;
      color: #676767
    }

    .modal-header {
      border-bottom: none;
      margin: 0 auto;
      padding-bottom: 6px;
    }

    .modal-footer {
      border-top: none;
      padding: 0.75rem 0;
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
    tr{
      height: 48px;
    }

    .background-tr {
      background-color: #e8f4ed;
      color: #262626;
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

    .inp input::placeholder {
      color: #B8B8B8;
    }

    .multiselect-selected-text{
      color: #676767;
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
      height: 40px
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

    form label {
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
    .nav-link {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 40px;
      max-width: 250px;
      color: #676767 !important;
      font-weight: 600 !important;
      font-size: 14px !important;
      border-radius: 8px;
      cursor: pointer;
    }
    .nav-link.active {
      color: #1D9752 !important;
      background-color: #D2EADC !important;
    }

    .text-label{
      color: #3B3B3B;
      font-weight: 400;
      line-height: 16px;
    }

    .colorText{
      color:#676767;
    }
    /* .dropdown-menu.show {
    display: block;
    } */
    .multiselect-container {
      overflow-y: scroll;
      height: 211px;
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
          <h1 class="title-h1">Danh sách yêu cầu ấn phẩm</h1>
        </div>
        <div>
          <a href="{{$requestOrderUrl}}" class="btn btn-success redirect">
            Thêm mới <i class="fa fa-plus icon-add" aria-hidden="true"></i>
          </a>
        </div>
      </div>
    </div>
    <div class="navigation" style="margin-top: 34px">
      <nav class="nav nav-pills nav-fill">
        <a class="nav-item nav-link active redirect" href="#">Danh sách yêu cầu của PGD</a>
        <a class="nav-item nav-link redirect" href="{{$tradeBEIndexUrl}}">Danh sách ngân sách dự toán</a>
        <a class="nav-item nav-link redirect" href="{{$shoppingUrl}}">Danh sách mua sắm ấn phẩm</a>
      </nav>
    </div>
    <div class="content-body1 shadow mb-5 bg-white rounded">
      <div class="content-body">
        <div class="content1">
          <h2 class="content1-title-h2">Danh sách yêu cầu ấn phẩm</h2>
          <button
            type="button"
            class="btn-search"
            data-bs-toggle="modal"
            data-bs-target="#search-form"
          >
            Tìm kiếm
            <i class="fa fa-search search" aria-hidden="true"></i>
          </button>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr class="background-tr" style="vertical-align: middle;">
              <th scope="col">STT</th>
              <th scope="col">Phòng giao dịch</th>
              <th scope="col">Tên kế hoạch</th>
              <th scope="col">Chi tiết</th>
              <th scope="col">Mục tiêu thúc đẩy</th>
              <th scope="col">Ngày tạo</th>
              <th scope="col">Trạng thái</th>
              <th scope="col">Chức năng</th>
            </tr>
          </thead>
          <tbody>
            @foreach($items as $key => $tradeOrder)

            <tr data-id="{{$tradeOrder['_id']}}" style="vertical-align: middle;">
              <td>{{($items->perPage() * ($items->currentPage() - 1 )) + $key + 1}}</td>
              <td>{{$tradeOrder['store_name']}}</td>
              <td>{{$tradeOrder['plan_name']}}</td>
              <td><a href="{{$tradeOrder['plan_file']}}">Download</a></td>
              <td>{{$model::$motivatingGoals[$tradeOrder['motivating_goal'][0]]}}</td>
              <td>{{date('d/m/Y', $tradeOrder['created_at'])}}</td>
              <td>{{$model::statusLabel($tradeOrder['status'], $tradeOrder['progress'])}}</td>
              <td>
                <button
                  class="backgr-btn"
                  type="button"
                  id="dropdownMenuButton1"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                  class="action"
                >
                  <i class="fa fa-bars" aria-hidden="true"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                  <li><a class="dropdown-item redirect colorText" href="{{route('viewcpanel::trade.tradeOrder.detailOrderView', ['id' => $tradeOrder['_id']])}}">Xem chi tiết</a></li>
                  <?php
                  if (
                    $editButton && (
                      ($tradeOrder['status'] == $model::STATUS_NEW && $tradeOrder['progress'] == $model::PROGRESS_PGD_CREATE && $user['isTPGD']) ||
                      ($tradeOrder['status'] == $model::STATUS_RETURNED && (
                        ($tradeOrder['progress'] == $model::PROGRESS_ASM && $user['isTPGD']) ||
                        ($tradeOrder['progress'] == $model::PROGRESS_RSM && $user['isASM']) ||
                        ($tradeOrder['progress'] == $model::PROGRESS_GDKD_MKT && $user['isRSM']) ||
                        ($tradeOrder['progress'] == $model::PROGRESS_CFO && $user['isTradeMKT'])
                      )) || ((int)$user['is_superadmin'] == 1)
                    ) && $tradeOrder['status'] != $model::STATUS_CANCLED
                    
                  ) {
                  ?>
                  <li><a class="dropdown-item redirect colorText" href="{{route('viewcpanel::trade.tradeOrder.editOrderView', ['id' => $tradeOrder['_id']])}}">Chỉnh sửa</a></li>
                  <?php } ?>
                  @if ($tradeOrder['status'] == $model::STATUS_NEW && $tradeOrder['progress'] == $model::PROGRESS_PGD_CREATE)
                  <li data-bs-toggle="modal" data-bs-target="#deleteModal"
                    data-id="{{$tradeOrder['_id']}}"
                    data-url="{{route('viewcpanel::trade.tradeOrder.deleteOrder', ['id' => $tradeOrder['_id']])}}"
                  >
                    <span class="dropdown-item delete-item">Xoá</span>
                  </li>
                  @endif
                </ul>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      {{ $items->withQueryString()->render('viewcpanel::trade.paginate') }}

      <!-- Modal search -->
      <div
        class="modal fade"
        id="search-form"
        tabindex="-1"
        role="dialog"
        aria-labelledby="searchFormTitle"
        aria-hidden="true" style="height: auto !important;"
      >
        <div class="modal-dialog modal-dialog-centered" role="document">
          <form action="#" method="get" style="width: 100%">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="searchFormTitle">Tìm kiếm</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="text-label">Thời gian tạo</label>
                    <div class="date">
                      <input type="date" class="date-input" name="start_date" id="start-date"
                      @if(!empty($formData['start_date']))
                        value="{{$formData['start_date']}}"
                      @endif
                      >
                      <input type="date" class="date-input" name="end_date" id="end-date"
                      @if(!empty($formData['end_date']))
                        value="{{$formData['end_date']}}"
                      @endif
                      >
                    </div>
                </div>
                <div class="form-group inp">
                  <label class="text-label" for="exampleInputEmail1">Tên kế hoạch</label>
                  <input
                    name="plan_name"
                    class="form-control"
                    id="exampleInputEmail1"
                    aria-describedby="emailHelp"
                    placeholder="Nhập"
                    @if(!empty($formData['plan_name'])) value="{{$formData['plan_name']}}" @endif
                  />
                </div>
                <div class="form-group" style="position:relative;">
                  <label class="text-label" for="stores">Phòng giao dịch</label>
                    <div class="content1-input d-flex justify-content-between align-items-center">
                      <select id="stores" multiple="multiple" name="store_id[]" style="overflow-y: scroll; height: 211px;">
                          @foreach($stores as $value)
                              <option style="overflow-y:scroll;" value="{{$value['_id']}}"
                              @if(!empty($formData['store_id']) && in_array($value['_id'], $formData['store_id']))

                              @endif >{{$value['name']}}</option>
                          @endforeach
                      </select>
                      <svg style="position:absolute; right:5%; top:51%; width:2.5%" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                      </svg>
                    </div>
                </div>
                <div class="form-group" style="position:relative">
                  <label class="text-label" for="status">Trạng thái</label>
                  <select id="status" class="form-control" name="status[]" multiple="multiple">
                      @foreach($statusAll as $key => $value)
                        <option value="{{$key}}"
                          @if(!empty($formData['status']) && in_array($key, $formData['status']))
                            selected
                          @endif
                        >{{$value}}</option>
                      @endforeach
                  </select>
                  <svg style="position:absolute; right:2%; top:61%; width:2.5%" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                  </svg>
                </div>
                <div class="form-group style="position:relative">
                  <label class="text-label" for="exampleInputPassword1">Mục tiêu thúc đẩy</label>
                  <select id="motivatingGoals" class="form-select motivatingGoals" name="motivating_goal[]" multiple="multiple">
                      @foreach($motivatingGoals as $key => $value)
                          <option value="{{$key}}"
                          @if(!empty($formData['motivating_goal']) && in_array($key, $formData['motivating_goal']))
                            selected
                          @endif
                          >{{$value}}</option>
                      @endforeach
                  </select>
                  <svg style="position:absolute; right:5%; top:88%; width:2.5%" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                  </svg>
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
            </form>
          </div>
        </div>
      </div>
      <!-- Modal Hủy -->
      <div
        class="modal fade"
        id="deleteModal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true" style="height: auto !important;"
      >
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
    </div>
<div class="modal fade" id="errorModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" style="height: auto !important;">
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
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="successModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" style="height: auto !important;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Thành công</h5>
      </div>
      <div class="modal-body">
        <p class="msg_success" style="text-align: center;"></p>
      </div>
    </div>
  </div>
</div>
</section>
@endsection

@section('script')
<script type="text/javascript">
    const iframeMode = "<?= (!empty($_GET['iframe']) && $_GET['iframe'] == 1) ?>";
    console.log(iframeMode)
    const Redirect = (_url, _timeout) => {
        if (parseInt(iframeMode) != 1) {
            if (!_timeout) {
                window.location.href = _url;
                // window.parent.postMessage({targetLink: _url}, "{{$cpanelPath}}");
            } else {
                setTimeout(function(){window.location.href = _url}, _timeout);
                // setTimeout(function () {window.parent.postMessage({targetLink: _url}, "{{$cpanelPath}}");}, _timeout);
            }
        } else {
            _url = _url.replace(window.location.origin + '/', "");
            if (!_timeout) {
                // window.location.href = _url;
                window.parent.postMessage({targetLink: _url}, "{{$cpanelPath}}");
            } else {
                // setTimeout(function(){window.location.href = _url}, _timeout);
                setTimeout(function () {window.parent.postMessage({targetLink: _url}, "{{$cpanelPath}}");}, _timeout);
            }
        }
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/js/bootstrap-multiselect.min.js" integrity="sha512-lxQ4VnKKW7foGFV6L9zlSe+6QppP9B2t+tMMaV4s4iqAv4iHIyXED7O+fke1VeLNaRdoVkVt8Hw/jmZ+XocsXQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#stores, #motivatingGoals, #status').multiselect({
        enableFiltering: true,
        includeSelectAllOption: true,
        selectAllText: 'Chọn tất cả',
        templates: {
            button: '<button style="background: #FFFFFF;border: 1px solid #D8D8D8;border-radius: 5px;width: 100%;height: 38px;text-align: left !important;padding-left: 12px;outline: none;" type="button" class="multiselect dropdown-toggle button_target_goal" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span></button>'
        },
        // enableFiltering: true,
    });

    // var dp = $("#start-date, #end-date").datepicker({
    //     format: "yyyy-mm-dd",
    //     autoclose: true
    // });
  });
</script>

<script type="text/javascript">
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

  $('#deleteModal').on('show.bs.modal', function (event) {
    const modal = $(this)
    modal.find('[name="reason"]').val("");
    modal.find('#trade-order-url').val("")
    modal.find('#trade-order-id').val("")
    const button = $(event.relatedTarget)
    let url = button.data('url')
    let id = button.data('id')
    modal.find('[name="reason"]').val("");
    modal.find('#trade-order-url').val(url)
    modal.find('#trade-order-id').val(id)
  })
  const deleteConfirm = document.getElementById('confirm-delete-modal');
  const deleteAction = (event) => {
    const _modal = event.target.closest(".modal");
    $(_modal).modal('hide')
    let url = _modal.querySelector('[name="url"]').value;
    let reason = _modal.querySelector('[name="reason"]').value;
    let id = _modal.querySelector('[name="id"]').value;
    let data = {
      id : id,
      reason : reason
    }
    function callback(response, _data) {
      if (response.status == 200) {
        $("#successModal").find(".msg_success").text("Xoá yêu cầu ấn phẩm thành công");
        $("#successModal").modal('show');
        let indexUrl = window.location.href;
        Redirect(indexUrl, 2000);
      } else {
        $("#errorModal").find(".msg_error").text(response.message);
        $("#errorModal").modal('show');
      }

    }
    SaveData(data, url, callback)
  }
  deleteConfirm.addEventListener('click', event => {deleteAction(event)});

  $('a.redirect').on('click', (e) => {
    e.preventDefault();
    let url = $(e.target).attr('href');
    Redirect(url, false);
  });

  $("#search-form .btn-cancel").on('click', function() {
    let indexUrl = window.location.href.split("?")[0];
    Redirect(indexUrl, false);
  });
</script>
@endsection

@extends('viewcpanel::layouts.master')

@section('title', 'Chi tiết dự toán ngân sách')

@section('css')
<style>
  body {
    font-family: Roboto;
    background: #f7f7f7;
    margin: 0 20px;
  }

  .content-body {
    padding: 22px 0px;
  }

  .content-body1 {
    background: #ffffff;
    margin-top: 24px;
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

  .btnn-submit {
    background-color: #1d9752;
    border: 1px solid #1d9752;
    outline: none;
    color: white;
    border-radius: 5px;
    font-size: 14px;
    padding: 8px 16px;
    margin-right: 16px;
    margin-bottom: 10px;
  }
  .btnn-prev {
    background-color: #d8d8d8;
    outline: none;
    color: #676767;
    border-radius: 5px;
    font-size: 14px;
    padding: 8px 16px;
    margin-right: 16px;
    margin-bottom: 10px;
  }

  .btnn-cancel {
    background-color: #f4cdcd;
    border: 1px solid #f4cdcd;
    outline: none;
    color: #c70404;
    border-radius: 5px;
    font-size: 14px;
    padding: 8px 16px;
    margin-right: 16px;
  }
  .btnn-submit:hover {
    background-color: #158445;
  }
  .btnn-cancel:hover {
    background-color: #f8baba;
  }
  .btnn-prev:hover {
    background-color: #c5c5c5;
  }

  .distance {
    padding-left: 4px;
  }
  @media screen and (max-width: 48rem) {
    .content-title {
      text-align: center;
    }

    .row {
      margin: 20px 0;
    }

    .content-btn {
      margin-top: 10px;
    }
  }
  /*  */

  /* content1 */
  .content1 {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: 0px 16px;
  }

  .content1-title-h2 {
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 0;
  }
  /* modal */

  .btn-excel {
    background: #ffffff;
    border-radius: 5px;
    border: 1px solid #1d9752;
    outline: none;
    padding: 4px 10px;
    font-size: 12px;
    color: #1d9752;
    font-weight: 600;
    height: 32px;
  }

  .btn-cancel {
    background-color: #D8D8D8;
    outline: none;
    border: none;
    width: 200px;
    padding: 12px 0;
    font-size: 14px;
    border-radius: 5px;
    margin: 0 auto;
  }

  .btn-submit {
    background-color: #1D9752;
    outline: none;
    border: none;
    width: 200px;
    padding: 12px 0;
    color: #FFFFFF;
    font-size: 14px;
    border-radius: 5px;
    margin: 0 auto;
  }
  .btn-submit:hover {
    background-color: #158445;
  }
  .btn-cancel:hover {
    background-color: #c5c5c5;
  }

  .modal-header {
    border-bottom: none;
    margin: 0 auto;
    padding-bottom: 6px;
  }

  .modal-footer {
    border-top: none;
    width: 100%;
  }

  .modal-content {
    border: 1px solid #ccc;
  }
  /* moda btn */
  .modal-title {
    font-size: 1.25rem;
    font-weight: 600;
  }
  /* end modal */

  .note {
    text-align: start;
    padding-top: 0;
    margin-bottom: 0px;
  }

  .text {
    outline: none;
    padding: 10px 16px;
  }

  /* table */
  .background-tr {
    background-color: #e8f4ed;
  }

  .content1-table {
    margin-top: 16px;
  }
  thead{
    border-style: hidden !important;
  }
  tr {
    height: 40px;
    border-style: ridge !important;
  }

  th {
    font-size: 14px;
  }

  th,
  td {
    border-top: none;
    white-space: nowrap;
    text-align: center;
  }
  td {
    color: #676767;
    font-size: 14px;
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
    color:#676767;
  }

  .stt {
    width: 30px;
  }
  /*  */
  /* content6 */
  .content6 {
    padding: 24px 16px 24px;
    margin-top: 22px;
  }

  .content6-div1 {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .content6-div1-btn {
    font-size: 12px;
    font-weight: 600;
    color: #1d9752;
  }

  .content6-div1-btn:hover {
    background-color: #1d9752;
  }

  .titleH3 {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 16px;
  }

  .event {
        display: flex;
        flex-direction: column;
    }

    .event h3 {
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 16px;
        color: #1D9752;
    }

    .event span {
        font-style: normal;
        font-weight: 400;
        font-size: 12px;
        line-height: 14px;
        color: #B8B8B8;
    }

    .event label {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #676767;
    }

    .timeline {
        border-left: 1px solid #D8D8D8;
        padding: 0px 50px;
        margin-left: 16px;
        list-style: none;
        text-align: left;
        max-width: 40%;
    }

    .timeline .event {
        margin-bottom: 0px !important;
    }

    @media (max-width: 767px) {
        .timeline {
            max-width: 98%;
            padding: 25px;
        }
    }

    .timeline .event {
        padding-bottom: 25px;
        margin-bottom: 25px;
        position: relative;
    }

    @media (max-width: 767px) {
        .timeline .event {
            padding-top: 30px;
        }
    }

    .timeline .event:after {
        position: absolute;
        display: block;
        top: 3px !important
    }

    .timeline .event:after {
        -webkit-box-shadow: 0 0 0 3px #D8D8D8;
        box-shadow: 0 0 0 3px #D8D8D8;
        left: -54.8px;
        background: #fff;
        border-radius: 50%;
        height: 9px;
        width: 9px;
        content: "";
        top: 5px;
    }

    @media (max-width: 767px) {
        .timeline .event:after {
            left: -31.8px;
        }
    }

  .content6-a {
    font-size: 14px;
    color: #1d9752;
    font-weight: bold;
  }

  .content6-a:hover {
    text-decoration: none;
    color: #078c41;
  }

  .content6-p {
    margin-bottom: 0;
    font-size: 14px;
  }

  .content6-p-time {
    margin-bottom: 0;
    font-size: 12px;
    color: #676767;
  }

  .note {
    font-size: 14px;
    font-weight: 400px;
  }

  .span-color {
    color: red;
  }

  .textarea {
    width: 100%;
    outline: none;
    border: 2px solid #d8d8d8;
    border-radius: 5px;
    padding: 5px 12px;
    margin-top: 4px;
  }
  .textarea::placeholder {
    font-size: 14px;
  }
  .textarea1 {
    background-color: #d8d8d8;
    width: 100%;
    font-size: 14px;
    border: 1px solid transparent;
    border-radius: 5px;
    padding-top: 10px;
    margin-top: 25px;
  }
  .modal-body {
    padding-bottom: 0;
  }
  /*  */
  /* date */
  .date {
    display: flex;
    justify-content: space-between;
  }

  .date-input {
    width: 48%;
    border: 1px solid #ccc;
    outline: none;
    border-radius: 5px;
    padding: 4px 15px;
    font-size: 14px;
  }
  /*  */
</style>
<style>
  .tabs {
    display: none;
  }
  .tabs.active {
    display: block;
  }
  .hidden {
      display: none !important;
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
  .invalid {
      font-size: 13px;
      color: red;
      font-weight: 500;
  }
  .border-red {
      border-color: red;
  }
  .comments {
    max-height: 250px;
    overflow-y: auto;
  }
  .logs {
    max-height: 550px;
    overflow-y: auto;
  }
  .status-label {
    padding: 4px 8px;
    background: #D2EADC;
    border-radius: 5px;
    font-weight: 600;
    font-size: 14px;
    color: #1D9752;
    line-height: 16px;
  }
  .nav-link {
    max-width: 180px;
    color: #676767 !important;
    font-weight: 600 !important;
    font-size: 14px !important;
    border-radius: 8px !important;
    cursor: pointer;
    height: 40px;
  }
  .nav-link.active {
    color: #1D9752 !important;
    background-color: #D2EADC !important;
  }

  thead {
    font-style: normal;
    font-weight: 600;
    font-size: 14px;
    line-height: 16px;
    color: #262626;
  }

  .table-responsive h5{
    padding: 22px 16px;
    font-style: normal;
    font-weight: 600;
    font-size: 16px;
    line-height: 20px;
    color: #3B3B3B;
    margin: 0px;
  }
  .dropdown-item {
    color: #676767;
    font-style: normal;
  font-weight: 400;
  font-size: 14px;
  line-height: 16px;
  }
</style>
@endsection

@section('content')
<section class="main-content" style="margin-top: 20px;">
  <div id="loading" class="theloading hidden">
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
  </div>
  <div class="">
      <div class="content-title">
        <div class="content flex-column flex-sm-row">
          <div>
            <h1 class="title-h1">{{$budgetEstimates['name']}}</h1>
          </div>
          <div class="content-btn text-center">
            <a id="back-page" class="btn redirect btnn-prev" href="{{$tradeBEIndexUrl}}" style="margin-top: 12px;">
                Trở về
                <i class="fa fa-arrow-left distance" aria-hidden="true"></i>
            </a>
            @if($cfoApprovedButton)
            <button id="approved-tradeOrder" type="button" class="btnn-submit update-status" data-action="approved"
            data-title="Duyệt ngân sách"
            data-confirm="Bạn có chắc chắn muốn 'Duyệt' ngân sách dự toán này không?"
            >
                CFO Duyệt
                <i class="fa fa-check distance" aria-hidden="true"></i>
            </button>
            @endif
            @if($ceoApprovedButton)
            <button id="approved-tradeOrder" type="button" class="btnn-submit update-status" data-action="approved"
            data-title="Duyệt ngân sách"
            data-confirm="Bạn có chắc chắn muốn 'Duyệt' ngân sách dự toán này không?"
            >
                Duyệt thay CEO
                <i class="fa fa-check distance" aria-hidden="true"></i>
            </button>
            @endif
            @if($ccoApprovedButton)
            <button id="approved-tradeOrder" type="button" class="btnn-submit update-status" data-action="ccoApproved"
            data-title="Duyệt ngân sách"
            data-confirm="Bạn có chắc chắn muốn 'Duyệt' ngân sách dự toán này không?"
            >
                CCO Duyệt
                <i class="fa fa-check distance" aria-hidden="true"></i>
            </button>
            @endif
            @if($mktApprovedButton)
            <button id="approved-tradeOrder" type="button" class="btnn-submit update-status" data-action="mktApproved"
            data-title="Duyệt ngân sách"
            data-confirm="Bạn có chắc chắn muốn 'Duyệt' ngân sách dự toán này không?"
            >
                MKT Duyệt
                <i class="fa fa-check distance" aria-hidden="true"></i>
            </button>
            @endif
            @if($sentApproveButton)
            <button id="sent-approve" type="button" class="btnn-submit update-status" data-action="sentApprove"
            data-title="Gửi duyệt"
            data-confirm="Bạn có chắc chắn muốn 'Gửi duyệt' ngân sách dự toán này không?"
            >
                Gửi duyệt
                <i class="fa fa-arrow-up distance" aria-hidden="true"></i>
            </button>
            @endif
            @if($returnedButton)
            <button id="returned-tradeOrder" type="button" class="btnn-prev update-status" data-action="returned"
            data-title="Trả về"
            data-confirm="Bạn có chắc chắn muốn 'Trả về' ngân sách dự toán này không?"
            data-note="1"
            >
                Trả về
                <i class="fa fa-undo distance" aria-hidden="true"></i>
            </button>
            @endif
            @if($cancelButton)
            <button id="canceled-tradeOrder" type="button" class="btnn-cancel update-status" data-action="canceled"
            data-title="Huỷ yêu cầu"
            data-confirm="Bạn có chắc chắn muốn 'Huỷ' ngân sách dự toán này không?"
            data-note="1"
            >
                Huỷ
                <i class="fa fa-times distance" aria-hidden="true"></i>
            </button>
            @endif
        </div>
        </div>
      </div>
    </div>
    <div class="navigation" style="margin-top: 14px">
      <nav class="nav nav-pills nav-fill">
        <a class="nav-item nav-link active" data-target="#tab1">Ngân sách dự toán</a>
        <a class="nav-item nav-link" data-target="#tab2">Danh sách đề xuất</a>
      </nav>
    </div>
    <div id="tab1" class="tabs active">
      <div class="content-body1">
      <div class="content-body bg-white shadow mb-2 bg-white rounded">
        <div class="content1">
          <h2 class="content1-title-h2">Ngân sách dự toán &nbsp;&nbsp;<span class="status-label">{{$statusLabel}}</span></h2>
          <div class="excel-search">
            <button id="export-excel" type="button" class="btn btn-success btn-excel">
              Xuất chi phí dự kiến
              <i class="fa fa-file-excel-o search" aria-hidden="true"></i>
            </button>
          </div>
        </div>
        <div class="content1-table table-responsive tabcontent">
          <table id="ngan-sach-vung" class="table">
            <thead>
              <tr class="background-tr">
                <th scope="col" class="the-th">Vùng</th>
                <th scope="col">Khu vực</th>
                <th scope="col">Số loại ấn phẩm</th>
                <th scope="col">Tổng số lượng ấn phẩm</th>
                <th scope="col">Tổng chi phí dự kiến</th>
                <th scope="col">Tổng chi phí theo Vùng</th>
              </tr>
            </thead>
            <tbody>
              @foreach($detail['groupKV'] as $region)
                @if(!empty($region['areas']))
                  <tr style="color:#676767; font-weight: 400;">
                    <th style="vertical-align: middle !important;" rowspan="{{count($region['areas'])}}" class="pd-td">{{$region['region_name']}}</th>
                    <td>{{$region['areas'][0]['kv_name']}}</td>
                    <td class="countItem" data-value="{{$region['areas'][0]['countItem']}}">
                    {{number_format($region['areas'][0]['countItem'], 0)}}
                    </td>
                    <td class="numberOfItem" data-value="{{$region['areas'][0]['numberOfItem']}}">{{number_format($region['areas'][0]['numberOfItem'], 0)}}</td>
                    <td class="totalExpecPrice" data-value="{{$region['areas'][0]['totalExpecPrice']}}">
                    {{number_format($region['areas'][0]['totalExpecPrice'], 0)}}</td>
                    <th 
                      style="vertical-align: middle !important; color:#676767;" 
                      rowspan="{{count($region['areas'])}}" 
                      class="pd-td areaTotalExpecPrice" data-value="{{$region['areaTotalExpecPrice']}}">
                      {{number_format($region['areaTotalExpecPrice'], 0)}}</th>
                  </tr>
                 @for($i = 1; $i < count($region['areas']); $i++)
                  <tr>
                    <td>{{$region['areas'][$i]['kv_name']}}</td>
                    <td class="countItem" data-value="{{$region['areas'][$i]['countItem']}}">
                    {{number_format($region['areas'][$i]['countItem'], 0)}}
                    </td>
                    <td class="numberOfItem" data-value="{{$region['areas'][$i]['numberOfItem']}}">{{number_format($region['areas'][$i]['numberOfItem'], 0)}}</td>
                    <td class="totalExpecPrice" data-value="{{$region['areas'][$i]['totalExpecPrice']}}">
                    {{number_format($region['areas'][$i]['totalExpecPrice'], 0)}}</td>
                  </tr>
                 @endfor
                @endif
              @endforeach
              <tr class="total" style="color:#676767;">
                <th colspan="2">Tổng</th>
                <th id="countItem">???</th>
                <th id="numberOfItem">???</th>
                <th id="totalExpecPrice">???</th>
                <th class="pd-td" id="areaTotalExpecPrice">???</th>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="content1-table table-responsive tabcontent">
          <table id="ngan-sach-pgd" class="table table-hover">
            <thead>
              <tr class="background-tr">
                <th rowspan="3" colspan="2" class="pd-td the-th" scope="col" style="padding-bottom: 65px;">
                  Phòng giao dịch
                </th>
                <th rowspan="3" class="pd-td the-th" scope="col" style="padding-bottom: 65px;">
                  Tổng chi PGD
                </th>
                <th 
                  @if ($detail['groupPgd']['publication']['count'] < 2)
                  colspan="2"
                  @else
                  colspan="{{$detail['groupPgd']['publication']['count']}}"
                  @endif
                  scope="col">{{$detail['groupPgd']['publication']['name']}}
                </th>
                <th 
                  @if ($detail['groupPgd']['item']['count'] < 2)
                  colspan="2"
                  @else
                  colspan="{{$detail['groupPgd']['item']['count']}}"
                  @endif
                  scope="col">
                {{$detail['groupPgd']['item']['name']}}
                </th>
              </tr>
              <tr class="background-tr">
                <th colspan="{{$detail['groupPgd']['publication']['items']['direct']['count']}}" 
                  @if ($detail['groupPgd']['publication']['items']['direct']['count'] < 1)
                  colspan="1"
                  @else
                  colspan="{{$detail['groupPgd']['publication']['items']['direct']['count']}}"
                  @endif
                  scope="col">
                {{$detail['groupPgd']['publication']['items']['direct']['name']}}
                </th>
                <th colspan="{{$detail['groupPgd']['publication']['items']['indirect']['count']}}"
                  @if ($detail['groupPgd']['publication']['items']['indirect']['count'] < 1)
                  colspan="1"
                  @else
                  colspan="{{$detail['groupPgd']['publication']['items']['indirect']['count']}}"
                  @endif
                  scope="col">
                {{$detail['groupPgd']['publication']['items']['indirect']['name']}}
                </th>
                <th 
                  @if ($detail['groupPgd']['item']['items']['direct']['count'] < 1)
                  colspan="1"
                  @else
                  colspan="{{$detail['groupPgd']['item']['items']['direct']['count']}}"
                  @endif
                  scope="col">
                {{$detail['groupPgd']['item']['items']['direct']['name']}}
                </th>
                <th 
                  @if ($detail['groupPgd']['item']['items']['indirect']['count'] < 1)
                  colspan="1"
                  @else
                  colspan="{{$detail['groupPgd']['item']['items']['indirect']['count']}}"
                  @endif
                scope="col">
                {{$detail['groupPgd']['item']['items']['indirect']['name']}}
                </th>
              </tr>
              <tr class="background-tr">
                @foreach($detail['items'] as $itemVal)
                  <th scope="col">
                    {{$itemVal['item_name'] . ' ' . $itemVal['item_type']}}
                    <p class="table-p">Mã: {{$itemVal['item_code']}}<br>Quy cách: {{$itemVal['item_specifications']}}<br>Đơn giá: {{number_format($itemVal['item_expec_price'], 0)}}</p>
                  </th>
                @endforeach
                <?php $countItems = count($detail['items']);?>
                @if ($countItems < 4)
                  @for($i = 0; $i < (4 - $countItems); $i++)
                  <th scope="col"></th>
                  @endfor
                @endif
              </tr>
            </thead>
            <tbody>
              <?php $count = 1; ?>
              @foreach($detail['groupPgd']['pgds'] as $pgd)
              <tr class="total">
                <td class="stt">{{$count++}}</td>
                <td>{{$pgd['store_name']}}</td>
                <td>{{number_format($pgd['totalExpecPrice'], 0)}}</td>
                @foreach($detail['items'] as $itemVal)
                  @if(isset($pgd['item_ids'][$itemVal['item_id']]))
                  <td>{{number_format($pgd['item_ids'][$itemVal['item_id']]['item_quantity'], 0)}}</td>
                  @else
                  <td>0</td>
                  @endif
                @endforeach
                @if ($countItems < 4)
                  @for($i = 0; $i < (4 - $countItems); $i++)
                  <td class="total"></td>
                  @endfor
                @endif
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="content6 shadow mb-4 bg-white rounded">
      <div class="content6-div1">
        <h2 class="titleH3">Khách hàng mục tiêu</h2>
        @if ($editCusGoalBtn)
        <button
          type="button"
          class="btn btn-outline-success content6-div1-btn"
          data-bs-toggle="modal"
          data-bs-target="#customerGoal"
        >
          Chỉnh sửa
          <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
        </button>
        @endif
      </div>
      <div>
        <textarea class="textarea1" id="customer-goal-current" cols="100" rows="5" disabled>{{$budgetEstimates['customer_goal']}}</textarea>
      </div>
    </div>
    <div class="content6 shadow mb-4 bg-white rounded">
      <div class="content6-div1">
        <h2 class="titleH3">Ghi chú</h2>
        @if ($addNoteBtn)
        <button
          type="button"
          class="btn btn-outline-success content6-div1-btn"
          data-bs-toggle="modal"
          data-bs-target="#add-note"
        >
          Thêm ghi chú <i class="fa fa-plus distance" aria-hidden="true"></i>
        </button>
        @endif
      </div>
      <div id="content" class="logs">
            <ul class="timeline">
                @for($i = count($budgetEstimates['logs']) - 1; $i >= 0; $i--)
                <li class="event">
                    <h6>{{$budgetEstimates['logs'][$i]['action_label']}}</h6>
                    <span>{{date('H:i:s d-m-Y', $budgetEstimates['logs'][$i]['created_at'])}}</span>
                    <label>{{$budgetEstimates['logs'][$i]['created_by'] }}</label>
                    <label>{{$budgetEstimates['logs'][$i]['status_label']}}</label>
                </li>
                @endfor
            </ul>
        </div>
    </div>
    </div>
    
    <div id="tab2" class="tabs content-body1">
      <div class="table-responsive">
        <h5>Danh sách yêu cầu ấn phẩm</h5>
        <table class="table table-hover">
          <thead>
            <tr class="background-tr">
              <th scope="col">STT</th>
              <th scope="col">Phòng giao dịch</th>
              <th scope="col">Tên kế hoạch</th>
              <th scope="col">Chi tiết</th>
              <th scope="col">Mục tiêu thúc đẩy</th>
              <th scope="col">Số loại ấn phẩm</th>
              <th scope="col">Tổng số lượng ấn phẩm</th>
              <th scope="col">Tổng chi phí dự kiến</th>
              <th scope="col">Ngày tạo</th>
              <th scope="col">Chức năng</th>
            </tr>
          </thead>
          <tbody>
            @foreach($items as $key => $tradeOrder)

            <tr data-id="{{$tradeOrder['_id']}}">
              <td>{{($key + 1)}}</td>
              <td>{{$tradeOrder['store_name']}}</td>
              <td>{{$tradeOrder['plan_name']}}</td>
              <td><a href="{{$tradeOrder['plan_file']}}">Download</a></td>
              <td>{{$tradeOrderModel::$motivatingGoals[$tradeOrder['motivating_goal'][0]]}}</td>
              <td>{{number_format(count($tradeOrder['items']), 0)}}</td>
              <td>{{number_format($tradeOrder['totalOfItem'], 0)}}</td>
              <td>{{number_format($tradeOrder['totalExpec_price'], 0)}}</td>
              <td>{{date('d/m/Y', $tradeOrder['created_at'])}}</td>
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
                  <li><a class="dropdown-item redirect" href="{{route('viewcpanel::trade.tradeOrder.detailOrderView', ['id' => $tradeOrder['_id']])}}">Xem chi tiết</a></li>
                </ul>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <!-- <Modal Xác nận gửi đề xuất -->
      
    <!-- Modal Thêm mục tiêu khách hàng-->
    <div
      class="modal fade"
      id="customerGoal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalCenterTitle"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">
              Khách hàng mục tiêu
            </h5>
          </div>
          <div class="modal-body">
            <h4 class="note">
              Khách hàng mục tiêu <span class="span-color">*</span>
            </h4>
            <textarea
              class="textarea"
              id="customer-goal-content"
              cols=""
              rows="5"
              placeholder="Nhập..."
            >{{$budgetEstimates['customer_goal']}}</textarea>
          </div>
          <div class="modal-footer">
            <div class="row" style="width: 100%;">
              <div class="col-xs-6 col-md-6 col-sm-6 col-6">
                <button id="updateCustomerGoal" type="button" class="btn-submit">Đồng ý</button>
              </div>
              <div class="col-xs-6 col-md-6 col-sm-6 col-6">
                <button type="button" class="btn-cancel" data-bs-dismiss="modal">Hủy</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @if($addNoteBtn)
    <!-- Modal Ghi chú-->
    <div
      class="modal fade"
      id="add-note"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalCenterTitle"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Ghi chú</h5>
          </div>
          <div class="modal-body">
            <h4 class="note">Thêm ghi chú <span class="span-color">*</span></h4>
            <textarea
              class="textarea"
              id="note-content"
              cols=""
              rows="5"
              placeholder="Nhập..."
            ></textarea>
            <div class="comments">
              @for($i = count($comments) - 1; $i >= 0; $i--)
              <div class="mt-3">
                <h4 class="note">{{$comments[$i]['created_by']}}</h4>
                <p class="content6-p-time">{{date('d/m/Y H:i', $comments[$i]['created_at'])}}</p>
                <h4 class="note">
                  {{$comments[$i]['status_label']}}
                </h4>
              </div>
              @endfor
            </div>
          </div>
          <div class="modal-footer">
            <div class="row" style="width: 100%;">
              <div class="col-xs-6 col-md-6 col-sm-6 col-6">
                <button id="submit-add-note" type="button" class="btn-submit">Thêm</button>
              </div>
              <div class="col-xs-6 col-md-6 col-sm-6 col-6">
                <button type="button" class="btn-cancel" data-bs-dismiss="modal">Hủy</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
<div class="modal fade" id="errorModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Error</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="msg_error" style="text-align: center;"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
        <div class="modal-body">
          <p class="msg_success" style="text-align: center;"></p>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="confirm-modal" tabindex="-1" role="dialog" aria-labelledby="confirm-modal" aria-hidden="true" style="height: auto !important;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Gửi đề xuất</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" name="action" value="">
                <p id="modal-content"></p>
                <textarea id="modal-note" class="hidden" style="width: 95%;" rows="3" placeholder=" Lý do ..."></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Hủy</button>
                <button type="button" id="confirmed" class="btn btn-submit">Đồng ý</button>
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
<script type="text/javascript" src="{{ asset('viewcpanel/js/xlsx.js') }}"></script>
<script type="text/javascript">
  const csrf = "{{ csrf_token() }}";
  const sumItem = (className) => {
    let total = 0;
    $(className).each(function(index, value) {
      total += parseInt($(value).attr('data-value'));
    });
    return total;
  }
  $("#countItem").text(sumItem('.countItem').toLocaleString());
  $("#numberOfItem").text(sumItem('.numberOfItem').toLocaleString());
  $("#totalExpecPrice").text(sumItem('.totalExpecPrice').toLocaleString());
  $("#areaTotalExpecPrice").text(sumItem('.areaTotalExpecPrice').toLocaleString());
</script>
<script type="text/javascript">
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
    callback(result);
    $("#loading").addClass('hidden');
}

const UpdateCustomerGoal = (event) => {
  event.preventDefault();
  $("#customerGoal").modal('hide');
  let data = {
    'customer_goal' : $("#customer-goal-content").val()
  }
  let Callback = (response) => {
    if (response.status == 200) {
        $("#customer-goal-content").val('');
        $("#successModal").find(".msg_success").text("Cập nhật khách hàng mục tiêu thành công");
        $("#successModal").modal('show');
        setTimeout(function(){window.location.reload()}, 2000); 
    } else {
        let message = 'Có lỗi xảy ra vui lòng thử lại sau.';
        if (response.message) {
            message = response.message;
        }
        $("#errorModal").find(".msg_error").text(message);
        $("#errorModal").modal('show');
    }
  }
  SaveData(data, '{{$updateCustomerGoalUrl}}', Callback);
}
document.getElementById("updateCustomerGoal").addEventListener("click", UpdateCustomerGoal);

const AddComment = (event) => {
  event.preventDefault();
  $("#add-note").modal('hide');
  let data = {
    'comment' : $("#note-content").val()
  }
  let Callback = (response) => {
    if (response.status == 200) {
        $("#note-content").val('')
        $("#successModal").find(".msg_success").text("Thêm ghi chú thành công");
        $("#successModal").modal('show');
        setTimeout(function(){window.location.reload()}, 2000); 
    } else {
        let message = 'Có lỗi xảy ra vui lòng thử lại sau.';
        if (response.message) {
            message = response.message;
        }
        $("#errorModal").find(".msg_error").text(message);
        $("#errorModal").modal('show');
    }
  }
  SaveData(data, '{{$addCommentUrl}}', Callback);
}
document.getElementById("submit-add-note").addEventListener("click", AddComment);

// const UpdateProgress = (event) => {
//   event.preventDefault();
//   let data = {
//     'action' : $(event.target).attr('data-action')
//   }
//   let Callback = (response) => {
//     if (response.status == 200) {
//         $("#successModal").find(".msg_success").text(response.message);
//         $("#successModal").modal('show');
//         setTimeout(function(){window.location.reload()}, 2000); 
//     } else {
//         let message = 'Có lỗi xảy ra vui lòng thử lại sau.';
//         if (response.message) {
//             message = response.message;
//         }
//         $("#errorModal").find(".msg_error").text(message);
//         $("#errorModal").modal('show');
//     }
//   }
//   SaveData(data, '{{$updateProgressUrl}}', Callback);
// }

$("#confirm-modal").on("click", "#confirmed", function(e) {
    $("#confirm-modal").modal('hide');
    let data = {
        'action': $("#confirm-modal").find("input[name='action']").val(),
        'note' : $("#confirm-modal").find("#modal-note").val()
    }
    console.log(data);
    let Callback = function(response) {
        if (response.status == 200) {
            $("#successModal").find(".msg_success").text(response.message);
            // $("#successModal").find("#redirect-url").attr("href", response.targetUrl);
            $("#successModal").modal('show');
            // setTimeout(function(){window.location.href = response.targetUrl;}, 2000);
            Redirect(window.location.href, 2000);
        } else {
            $(this).removeAttr("disabled");
            if (response.message) {
                $("#errorModal").find(".msg_error").text(response.message);
            } else {
                $("#errorModal").find(".msg_error").text("Có lỗi xảy ra, vui lòng thử lại sau!");
            }
            $("#errorModal").modal('show');
        }
    }
    SaveData(data, '{{$updateProgressUrl}}', Callback);
});

$(".update-status").on("click", function(e) {
  e.preventDefault();
  let action = $(this).attr('data-action');
  let title = $(this).attr('data-title');
  let content = $(this).attr('data-confirm');
  let note = $(this).attr('data-note');
  console.log(action, title, content);
  $("#confirm-modal").find("#modal-title").text(title);
  $("#confirm-modal").find("#modal-content").text(content);
  $("#confirm-modal").find("input[name='action']").val(action);
  $("#confirm-modal").find("#modal-note").val("");
  if (note) {
      $("#confirm-modal").find("#modal-note").removeClass('hidden');
  } else {
      $("#confirm-modal").find("#modal-note").addClass('hidden');
  }
  $("#confirm-modal").modal('show');
});
</script>
<script type="text/javascript">
  $( document ).ready(function() {
    const exportExcel = (event) => {
      event.preventDefault();
      // REPORT 1
      let _report1Export = document.getElementById('ngan-sach-vung').cloneNode(true);

      // REPORT 2
      let _report2Export = document.getElementById('ngan-sach-pgd').cloneNode(true);

      var tb1 = XLSX.utils.table_to_sheet(_report1Export);
      var tb2 = XLSX.utils.table_to_sheet(_report2Export);
      var wb = XLSX.utils.book_new();
      let tb1_tmp = XLSX.utils.sheet_to_json(tb1, { header: 1 })
      let tb2_tmp = XLSX.utils.sheet_to_json(tb2, { header: 1 });
      tb1_tmp = tb1_tmp.concat([""]).concat(tb2_tmp);
      let wb1 = XLSX.utils.json_to_sheet(tb1_tmp, { skipHeader: 1 })
      XLSX.utils.book_append_sheet(wb, tb1, "Dự toán theo vùng");
      XLSX.utils.book_append_sheet(wb, tb2, "Dự toán theo pgd");
      // XLSX.utils.book_append_sheet(wb, wb1, "Tổng hợp");
      return XLSX.writeFile(wb, '{{$budgetEstimates["name"]}}' + '.xlsx');
    }
    document.getElementById("export-excel").addEventListener("click", exportExcel);

    $('.nav-item').on('click', (e) => {
      $('.nav-item').removeClass('active');
      $('.tabs').removeClass('active');
      e.preventDefault();
      $(e.target).addClass('active');
      let targetId = $(e.target).attr('data-target');
      $(targetId).addClass('active');
    })
  });

  $('a.redirect').on('click', (e) => {
    e.preventDefault();
    let url = $(e.target).attr('href');
    Redirect(url, false);
  })
</script>
@endsection

@extends('viewcpanel::layouts.master')

@section('title', 'Danh sách phiếu mua ấn phẩm')

@section('css')

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .wrapper {
        width: 100%;
        padding: 0px 20px;
        /* background-color: rgb(237, 237, 237); */
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header button {
        height: 40px;
    }

    .header-title h3 {
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 24px;
        color: #3B3B3B;
    }

    .header-title a {
        font-style: normal;
        font-weight: 400;
        font-size: 12px;
        line-height: 14px;
        color: #676767;
    }

    .box-tab {
        margin: 34px 0px;
    }

    .box1 {
        width: 100%;
        background: #FFFFFF;
        /* box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06); */
        border-radius: 8px;
        position: relative;
    }

    .box1-header {
        display: flex;
        justify-content: space-between;
        padding: 30px 16px;

    }



    .box1-header h3 {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: #3B3B3B;
    }

    th {
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 16px;
        color: #262626;
        border-bottom-width: 0px !important;
        white-space: nowrap;
        text-align: center !important;
        background-color: #E8F4ED !important;
        vertical-align: middle;
    }

    tr{
        height: 48px !important;
    }

    .sxt tr{
        height: 48px;
        vertical-align: middle;
    }

    .border-th th {
        border-bottom: 1px solid #E8E8E8 !important;
    }

    th p {
        font-weight: 400;
        font-size: 10px;
        line-height: 12px;
        color: #676767;
        margin: 0px;
        padding: 3px;

    }

    th h6 {
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 16px;
        color: #262626;
    }

    td {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #676767;
        white-space: nowrap;
        text-align: center;
    }

    .dropstart i {
        color: #1D9752;
    }

    .form-date label {
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #3B3B3B;

    }

    .form-date-btn input::placeholder {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        display: flex;
        align-items: center;
        color: #B8B8B8;
    }

    .form-date-btn input {
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        width: 100%;
        height: 40px;
        padding-left: 5px;
        outline: none;
        font-size: 14px;
    }

    .form-select-btn select {
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        width: 100%;
        height: 40px;
        padding-left: 5px;
        outline: none;
        font-size: 14px;
    }

    .form-input-btn input {
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        width: 100%;
        height: 40px;
        padding-left: 5px;
        outline: none;
    }

    .form-input-btn input::placeholder {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #B8B8B8;
    }


    .form-selects {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-top: 12px;
    }

    .form-selects select {
        width: 100%;
        height: 40px;
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        outline: none;
    }

    .form-date {
        margin-top: 12px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    /* -------box3-------- */

    .box3 {
        width: 100%;
        background: #FFFFFF;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
        border-radius: 8px;
        padding-bottom: 5%;
        position: relative;
    }

    .nav-footer {
        position: absolute;
        bottom: 0;
        right: 0;
    }

    /* .box3-title {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        flex-wrap: wrap;
    } */

    .box3-title h5 {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: #3B3B3B;
        padding: 22px 0px;
        margin: 0px;

    }

    .btn-box3 {
        display: flex;
        gap: 15px;
        margin: 16px;
    }

    .btn-box3 .btn-box3-search {
        background: #D2EADC;
        height: 32px;
        border: none;
        padding: 0px 16px;
        color: #1D9752;
        font-weight: 600;
        font-size: 12px;
        line-height: 14px;
        border-radius: 5px;
    }

    .style {
        color: #1D9752;
        border-color: #1D9752;
        height: 32px;
        padding: 0px 16px;
        font-weight: 600;
        font-size: 12px;
        line-height: 14px;
    }

    .creat {
        background-color: #1D9752;
        border-color: #1D9752;
    }

    .form-ghichu {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .form-ghichu h5 {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: #3B3B3B;
    }

    .box-note {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .box-note label {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #3B3B3B;
    }

    .box-note textarea {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #3B3B3B;
        width: 100%;
        height: 100px;
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        padding: 16px;
    }

    .box-note textarea {
        border-radius: 5px;
    }

    .box-note-title {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin: 8px 0px;
    }

    .box-note-title p {
        margin: 0;
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #676767;
    }

    .box-note-title span {
        font-style: normal;
        font-weight: 400;
        font-size: 10px;
        line-height: 12px;
    }


    /* ----------------------- */

    .tabs {
        display: flex;
        position: relative;
        gap: 15px;
        margin-top: 24px;
    }

    .tabs .line {
        position: absolute;
        left: 0;
        bottom: 0;
        width: 0;
        height: 6px;
        background-color: #FFFFFF;
        transition: all 0.2s ease;
    }

    .tab-item {
        min-width: 80px;
        height: 40px;
        color: #676767;
        background-color: #fff;
        cursor: pointer;
        transition: all 0.5s ease;
        padding-bottom: 10px;
        padding: 0px 10px;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        display: flex;
        align-items: center;
    }

    .tab-item a {
        list-style: none;
        text-decoration: none;
        color: #676767 !important;
        font-weight: 650 !important;
        font-size: 14px !important;
    }

    .tab-item.active {
        opacity: 1;
        color: #1D9752;
        background: #D2EADC;
        border-radius: 8px;
        margin: 0px;
    }

    .active a {
        color: #1D9752 !important;
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
    }

    .tab-content {
        padding: 24px 0;
    }




    .tab-pane h2 {
        font-size: 24px;
        margin-bottom: 8px;
    }

    .page-link:focus {
        background-color: #1D9752 !important;
        color: #fff !important;
    }

    .page-link {
        color: #676767 !important;
    }

    .modal-btn {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .modal-btn button {
        width: 211.5px;
        height: 40px;

    }

    .modal-body h5 {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: #3B3B3B;
        text-align: center;
    }

    .modal-dialog {
        bottom: 35%;
    }

    #successModal .modal-dialog{
        bottom: -25%;
    }

    .search-modal {
        top: -310px;
    }

    .modal-note{
        top:-260px;
    }

    #errorModal .modal-dialog{
        bottom: -25%;
    }

    .btn-success {
        background-color: #1D9752;
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 16px;
        color: #FFFFFF;
    }
    .btn-secondary {
        background-color: #D8D8D8;
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 16px;
        color: #676767;
        border-color: #D8D8D8;
        height: 40px;
    }

    @media screen and (max-width:48em) {
        .header {
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: self-start;
        }

        .box1-header {
            display: contents;
            flex-direction: column;
        }

        .box1 {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding-bottom: 20%;
        }

        .form-date-btn {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .tab-item {
            font-size: 12px;
        }

        .box3 {
            padding-bottom: 15%;
        }

        .box3-title {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
    }

    @media only screen and (min-width:46.25em) and (max-width:63.9375em) {

        .box1 {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding-bottom: 10%;
        }
    }
</style>
@endsection
@section('content')
<section class="xk_pgd">
    <div class="wrapper">
        <div class="header">
            <div class="header-title">
                <h3>Danh sách mua sắm ấn phẩm</h3>
                <small>
                    <a href="https://lms.tienngay.vn/"><i class="fa fa-home"></i> Khác</a> / <a href="https://lms.tienngay.vn/pawn/contract">yêu cầu</a>
                </small>
            </div>
            @if(!empty($buttonCreatePublic))
            <a href="{{route('viewcpanel::trade.publication.create1')}}" type="button" class="btn btn-success creat" id="item">Thêm mới <i class="fa fa-plus" aria-hidden="true"></i></a>
            @else
            <a href="{{route('viewcpanel::trade.publication.create1')}}" type="button" class="btn btn-success" id="item" style="display: none">Thêm mới <i class="fa fa-plus" aria-hidden="true"></i></a>
            @endif
        </div>
        <div id="Tabs">
            <!-- Tab items -->
            <div class="tabs">
                <div class="tab-item hide">
                    <a href="{{$indexUrl}}" class="nav-item nav-link redirect">Danh sách yêu cầu của PGD</a>
                </div>
                <div class="tab-item hide">
                    <a href="{{$tradeBEIndexUrl}}" class="nav-item nav-link redirect">Danh sách ngân sách dự toán</a>
                </div>
                <div class="tab-item show active">
                    <a href="{{$listPB}}" class="nav-item nav-link redirect">Danh sách mua sắm ấn phẩm</a>
                </div>
                <div class="line"></div>
            </div>
            <!-- Tab content -->
            <div class="tab-content">
                <div class="tab-pane active">
                    <div class="box3-list_anpham">
                        <div class="box3">
                            <div class="box3-title">
                                <div class="btn-box3">
                                    <div style="display: flex; width: 100%; justify-content: space-between;">
                                        <h5>Danh sách mua sắm ấn phẩm({{$count_data_publications}})</h5>
                                        <div style="display: flex; align-items: center;">
                                            <button style="height: 31px; display: flex; align-items: center; margin-right: 16px; font-size: 12px; font-weight: 600;" type="button" onclick="export_item('xlsx', 'danh_sach_an_pham_trade')"
                                                    class="btn btn-outline-success">Xuất excel <i style="padding-left: 5px;" class="fa fa-file-excel-o" aria-hidden="true"></i>
                                            </button>
                                            <button class="btn-box3-search" data-bs-toggle="modal" data-bs-target="#exampleModal-search">Tìm kiếm <i style="padding-left: 3px;" class="fa fa-search" aria-hidden="true"></i></button>
                                        </div>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal-search" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered search-modal" style="margin-top: 200px;">
                                            <div class="modal-content">
                                                <form id="search-form" method="GET" action="{{$searchData}}">
                                                  <div class="modal-body" style="padding:24px">
                                                    <h5>Tìm kiếm</h5>
                                                      {{--ngày đặt hàng--}}
                                                      <div class="form-date">
                                                          <label>Ngày đặt hàng</label>
                                                          <div class="form-date-btn row">
                                                              <div class="col-md-12 col-lg-6">
                                                                  <input placeholder="Từ Ngày" name="date_order_start" value="{{$date_order_search_start}}"
                                                                         class="textbox-n" type="text"
                                                                         onfocus="(this.type='date')"
                                                                          id="date_order_start"/>
                                                              </div>
                                                              <div class="col-md-12 col-lg-6">
                                                                  <input placeholder="Đến Ngày" name="date_order_end" value="{{$date_order_search_end}}"
                                                                         class="textbox-n" type="text"
                                                                         onfocus="(this.type='date')"
                                                                          id="date_order_end"/>
                                                              </div>
                                                          </div>
                                                      </div>
                                                      {{--Ngày nghiệm thu dự kiến--}}
                                                      <div class="form-date">
                                                          <label>Ngày nghiệm thu dự kiến</label>
                                                          <div class="form-date-btn row">
                                                              <div class="col-md-12 col-lg-6">
                                                                  <input placeholder="Từ Ngày" name="startDate" value="{{$date_acceptance_search_start}}"
                                                                         class="textbox-n" type="text"
                                                                         onfocus="(this.type='date')"
                                                                          id="startDate"/>
                                                              </div>
                                                              <div class="col-md-12 col-lg-6">
                                                                  <input placeholder="Đến Ngày" name="endDate" value="{{$date_acceptance_search_end}}"
                                                                         class="textbox-n" type="text"
                                                                         onfocus="(this.type='date')"
                                                                          id="endDate"/>
                                                              </div>
                                                              <div>
                                                                  <input type='hidden' name="tab_tat_ca" value="tab2"/>
                                                              </div>
                                                          </div>
                                                      </div>
                                                      {{--Ngày nghiệm thu--}}
                                                      <div class="form-date">
                                                          <label>Ngày nghiệm thu</label>
                                                          <div class="form-date-btn row">
                                                              <div class="col-md-12 col-lg-6">
                                                                  <input placeholder="Từ Ngày" name="date_acceptance_complete_start" value="{{$date_acceptance_complete_search_start}}"
                                                                         class="textbox-n" type="text"
                                                                         onfocus="(this.type='date')"
                                                                          id="date_acceptance_complete_start"/>
                                                              </div>
                                                              <div class="col-md-12 col-lg-6">
                                                                  <input placeholder="Đến Ngày" name="date_acceptance_complete_end" value="{{$date_acceptance_complete_search_end}}"
                                                                         class="textbox-n" type="text"
                                                                         onfocus="(this.type='date')"
                                                                          id="date_acceptance_complete_end"/>
                                                              </div>
                                                          </div>
                                                      </div>
                                                    <div class="form-date">
                                                        <label>Nhà cung cấp</label>
                                                        <div class="form-input-btn row">
                                                            <div class="col-md-12 col-lg-12">
                                                                <input type="text" name="supplier" id="supplier" class="supplier" placeholder="Nhập"  value="{{$supplier_search}}"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-date">
                                                        <label>Trạng thái</label>
                                                        <div class="form-select-btn row">
                                                            <div class="col-md-12 col-lg-12">
                                                                <select name="status" id="status" style='color:gray' oninput='style.color="black"'>
                                                                    <option value="" >Tất cả</option>
                                                                    <option value="1" @if(!empty($_GET['status']) && ($_GET['status'] == "1")) selected @endif >Mới</option>
                                                                    <option value="2" @if(!empty($_GET['status']) && ($_GET['status'] == "2")) selected @endif >Đã đặt hàng</option>
                                                                    <option value="3" @if(!empty($_GET['status']) && ($_GET['status'] == "3")) selected @endif >Chờ nghiệm thu</option>
                                                                    <option value="4" @if(!empty($_GET['status']) && ($_GET['status'] == "4")) selected @endif>Đang nghiệm thu</option>
                                                                    <option value="5" @if(!empty($_GET['status']) && ($_GET['status'] == "5")) selected @endif>Nghiệm thu hoàn thành</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-btn">
                                                        <button type="button" class="btn btn-success" id="search_data" data-bs-dismiss="modal">Tìm kiếm</button>
                                                        <button type="button" class="btn btn-secondary" id="clearData" >Hủy</button>
                                                    </div>
                                                </div>
                                                  </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box3-table table-responsive" style="width: 100%">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">STT</th>
                                            <th scope="col">Nhà cung cấp</th>
                                            <th scope="col">Ngày đặt hàng</th>
                                            <th scope="col">Ngày nghiệm thu dự kiến </th>
                                            <th scope="col">Trạng thái </th>
                                            <th scope="col">Ngày hoàn thành nghiệm thu</th>
                                            <th scope="col">Số loại yêu cầu </th>
                                            <th scope="col">Số lượng yêu cầu </th>
                                            <th scope="col">Tổng chi phí</th>
                                            <th scope="col">Chức năng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($list_publications as $key => $value) : ?>
                                            <tr <?php echo $value ?> style="vertical-align: middle;">
                                                <td>{{++$key}}</td>
                                                <td>{{$value['supplier']}}</td>
                                                <td>{{date('d/m/Y',$value['date_order'])}}</td>
                                                <td>{{date('d/m/Y',$value['date_acceptance'])}}</td>
                                                <td>
                                                    @if($value['status'] == 1)
                                                    <span>Mới</span>
                                                    @elseif($value['status'] == 2)
                                                    <span>Đã đặt hàng</span>
                                                    @elseif($value['status'] == 3)
                                                    <span>Chờ nghiệm thu</span>
                                                    @elseif($value['status'] == 4)
                                                    <span>Đang nghiệm thu</span>
                                                    @elseif($value['status'] == 5)
                                                    <span>Nghiệm thu hoàn thành</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($value['date_acceptance_complete']))
                                                    {{date('d/m/Y',$value['date_acceptance_complete'])}}
                                                    @else

                                                    @endif
                                                </td>
                                                <td>{{!empty($value['sum_item_id']) ? ($value['sum_item_id']) : ''}}</td>
                                                <td>{{!empty($value['sum_total']) ? ($value['sum_total']) : ''}}</td>
                                                <td>{{!empty($value['sum_money_publications']) ? (number_format($value['sum_money_publications'])) : ''}}</td>
                                                <td>
                                                    <div class="dropdown dropstart">
                                                        <i class="fa fa-bars" aria-hidden="true" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="{{url('cpanel/trade/publication/detail_publics/'.$value['_id'])}}">Xem chi tiết </a></li>
                                                            @if(($value['status'] == 1 || $value['status'] == 2 || $value['status'] == 3) && $buttonUpdatePublic)
                                                                <li><a class="dropdown-item" href="{{url('cpanel/trade/publication/update_publics/'.$value['_id'])}}">Chỉnh sửa</a></li>
                                                            @else
                                                            <li><a class="dropdown-item" style="display: none" href="{{url('cpanel/trade/publication/update_publics/'.$value['_id'])}}">Chỉnh sửa</a></li>
                                                            @endif
                                                            @if($value['status'] == 1 && $buttonDeletePublic)
                                                            <li><a class="dropdown-item status_block" id="status_block" data-block="{{$value['_id']}}" href="#">Xóa</a></li>
                                                            @else
                                                            <li><a class="dropdown-item status_block" id="status_block" style="display: none" data-block="{{$value['_id']}}" href="#">Xóa</a></li>
                                                            @endif
                                                            @if($value['status'] == 1 && $buttonSaveOrder)
                                                            <li><a class="dropdown-item status_order" id="status_order" data-order="{{$value['_id']}}" href="#">Đặt Hàng</a></li>
                                                            @else
                                                            <li><a class="dropdown-item status_order" id="status_order" style="display: none" data-order="{{$value['_id']}}" href="#">Đặt Hàng</a></li>
                                                            @endif
                                                            <li><a class="notePuclication dropdown-item" href="#" data-id="{{$value['_id']}}" data-bs-toggle="modal" data-bs-target="#exampleModal-noel">Ghi chú</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                                {{ $list_publications->withQueryString()->render('viewcpanel::trade.paginate') }}
                                 @include('viewcpanel::trade.publications.export_publication')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal-noel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-note">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-ghichu">
                            <div class="row">
                                <h5 class="col-11">Ghi chú</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="box-note">
                                <input type="text" id="note_publics" class="note_publics"  name="note_publics" hidden>
                                <label hidden>Tiêu đề<span style="color: red;">*</span></label>
                                <input type="text" style="border-radius: 3px" name="title_note_publications" id="title_note_publications" class="title_note_publications" hidden>
                                <label>Thêm ghi chú <span style="color: red;">*</span></label>
                                <textarea placeholder="Nhập" class="description_note_publications" id="description_note_publications" name="description_note_publications"></textarea>
                            </div>
                            <div class="modal-btn">
                                <button type="button" class="btn btn-success" id="saveNotePuclication" >Thêm</button>
                                <button type="button" class="btn btn-secondary" id="clear_note" >Hủy</button>
                            </div>
                            <div class="note_title" style="max-height: 500px;overflow: auto"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- modal success -->
<div class="modal fade" id="successModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-success" id="staticBackdropLabel">Thành công</h5>
            </div>
            <div class="modal-body">
                <p class="msg_success text-primary"></p>
            </div>
            <div class="modal-footer">
                {{-- <a id="redirect-url" class="btn btn-success">Xem</a>--}}
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- modal error -->
<div class="modal fade" id="errorModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
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
<script type="text/javascript" src="{{ asset('viewcpanel/js/xlsx.js') }}"></script>
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

<script type="text/javascript">
const csrf = "{{ csrf_token() }}";
    $('.hide').click(function() {
        $('#item').hide();
    });
    $('.show').click(function() {
        $('#item').show();
    });


function export_item(fileExtension, fileName) {
    let el = document.getElementById("total_table");
    let wb = XLSX.utils.table_to_sheet(el, {sheet: 'Sheet1'});
    const ne = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(ne, wb, "Sheet1");
    return XLSX.writeFile(ne, fileName + "." + fileExtension || ('MySheetName.' + (fileExtension || 'xlsx')));
}


$(document).ready(function () {
    $('.notePuclication').click(function (event) {
        event.preventDefault();
        let id = $(this).attr('data-id');
        let formData = new FormData();
        formData.append('_id', id);
        $.ajax({
            url: '{{route('viewcpanel::trade.publication.detailPublication')}}',
            type: "POST",
            data: formData,
            dataType: 'json',
            headers: {
                'x-csrf-token': csrf
            },
            processData: false,
            contentType: false,
            beforeSend: function () {
                $(".theloading").show();
                $(".note_title").html("")
            },
            success: function (data) {
                $(".theloading").hide();
                if (data.status == 200) {
                    $('#note_publics').val(data.data._id)
                    //console.log((data.data.lead_note).length)
                    //console.log(arrLt)
                    if((data.data.lead_note)){
                    if (((data.data.lead_note).length) >= 1) {
                    var arrLt = ((data.data.lead_note).length) - 1;
                        for (let i = arrLt; 0 <= i; i--) {
                            data.data.lead_note[i]
                            var newDateFormat = new Date(data.data.lead_note[i].created_at * 1000)
                            var options = {year: 'numeric', month: 'short', day: 'numeric'};
                            var formattedDate = newDateFormat.toLocaleDateString('vi-VN', options);
                            $(".note_title").append(
                                ' <p  style="color: #676767;margin-bottom: 0">' + data.data.lead_note[i].created_by + '</p>' +
                                ' <p  style="color: #B8B8B8;margin-bottom: 0">' + formattedDate + '</p>' +
                                ' <p  style="color: #676767;margin-bottom: 0">' + data.data.lead_note[i].description_publications + '</p><br>'
                            );
                        }
                    }
                    }
                }
            }
        });
    });

     $('#saveNotePuclication').click(function (event) {
         event.preventDefault();
            // $('.note_title').removeClass();
            var id =  $("input[name='note_publics']").val();
            var title_note_publications =  $("input[name='title_note_publications']").val();
            var description_publications =  $("textarea[name='description_note_publications']").val();
            var formData = new FormData();
            formData.append('_id',id)
            formData.append('title_note_publications',title_note_publications)
            formData.append('description_publications',description_publications)
            //console.log(title_note_publications,id,description_publications)
             $.ajax({
                 url: '{{route('viewcpanel::trade.publication.notePublics')}}',
                 type: "POST",
                 data: formData,
                 dataType: 'json',
                 headers: {
                     'x-csrf-token': csrf
                 },
                 processData: false,
                 contentType: false,
                 beforeSend: function () {
                     $(".theloading").show();
                 },
                  success: function (data) {
                     if (data.status == 200){
                        $('#successModal').modal('show');
                        $('.msg_success').text(data.message);
                        console.log(data.data.data)
                         //console.log(data.data.data.idNote.lead_note)
                         $('#note_publics').val(data.data.data.idNote._id)
                         let modalContent = $($('#exampleModal-noel').find(".note_title")[0]);
                         //console.log(modalContent)
                         modalContent.html("");
                         let rows = "";
                         if ((data.data.data.idNote.lead_note)) {
                             for (let i = ((data.data.data.idNote.lead_note).length) - 1; 0 <= i; i--) {
                                 data.data.data.idNote.lead_note[i]
                                 var newDateFormat = new Date(data.data.data.idNote.lead_note[i].created_at * 1000)
                                 var options = {year: 'numeric', month: 'short', day: 'numeric'};
                                 var formattedDate = newDateFormat.toLocaleDateString('vi-VN', options);
                                 rows += ' <p  style="color: #676767;margin-bottom: 0">' + data.data.data.idNote.lead_note[i].created_by + '</p>' +
                                     ' <p  style="color: #B8B8B8;margin-bottom: 0">' + formattedDate + '</p>' +
                                     ' <p  style="color: #676767;margin-bottom: 0">' + data.data.data.idNote.lead_note[i].description_publications + '</p><br>'
                             }
                         }
                         modalContent.html(rows);
                         $('#description_note_publications').val('')
                     }else{
                        $('#errorModal').modal('show');
                        $('.msg_error').text(data.message);
                     }
                  },
                 error: function (data) {
                     console.log(data);
                     $(".theloading").hide();
                 }
             })
     });

    $('#search_data').click(function () {
        let startDateAcceptance = $("input[name='startDate']").val();
        let endDateAcceptance = $("input[name='endDate']").val();
        let date_order_start = $("input[name='date_order_start']").val();
        let date_order_end = $("input[name='date_order_end']").val();
        let date_acceptance_complete_start = $("input[name='date_acceptance_complete_start']").val();
        let date_acceptance_complete_end = $("input[name='date_acceptance_complete_end']").val();
        let supplier = $("input[name='supplier']").val()
        let tab = $("input[name='tab_tat_ca']").val()
        let status = $("select[name='status']").val()
        console.log(startDateAcceptance, supplier, endDateAcceptance)
        window.location.href = '{{route('viewcpanel::trade.publication.list')}}' + '?date_acceptance_start=' + startDateAcceptance +
            '&date_acceptance_end=' + endDateAcceptance + '&supplier=' + supplier + '&status=' + status + '&tab=' + tab + '&date_order_start=' + date_order_start + '&date_order_end=' + date_order_end
            + '&date_acceptance_complete_start=' + date_acceptance_complete_start + '&date_acceptance_complete_end=' + date_acceptance_complete_end;
    })

    $('.status_block').click(function (event) {
        event.preventDefault();
        let id = $(this).attr('data-block');
        let formData = new FormData();
        formData.append('_id', id);
        console.log(id)
        if (confirm("Bạn có chắc chắn muốn xoá bản ghi này?")) {
            $.ajax({
                url:"{{route('viewcpanel::trade.publication.update_status_block')}}",
                type: "POST",
                data: formData,
                dataType: 'json',
                headers: {
                    'x-csrf-token': csrf
                },
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $(".theloading").show();
                },
                success: function (data) {
                    $(".theloading").hide();
                    if (data.status == 200) {
                        console.log(data)
                        $('#successModal').modal('show');
                        $('.msg_success').text(data.message);
                        window.scrollTo(0, 0);
                        setTimeout(function () {
                            window.location.reload();
                        }, 500);
                    } else {
                        $('#errorModal').modal('show');
                        $('.msg_error').text(data.message);
                    }
                },
                error: function (data) {
                    console.log(data);
                    $(".theloading").hide();
                }
            })
        }
    })

    $('.status_order').click(function () {
        event.preventDefault();
        let id = $(this).attr('data-order');
        let formData = new FormData();
        formData.append('_id', id);
        console.log(id)
        if (confirm("Bạn chắc chắn muốn đặt hàng phiếu mua ấn phẩm?")) {
            $.ajax({
                url:"{{route('viewcpanel::trade.publication.update_status_order')}}",
                type: "POST",
                data: formData,
                dataType: 'json',
                headers: {
                    'x-csrf-token': csrf
                },
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $(".theloading").show();
                },
                success: function (data) {
                    $(".theloading").hide();
                    if (data.status == 200) {
                        console.log(data)
                        $('#successModal').modal('show');
                        $('.msg_success').text(data.message);
                        window.scrollTo(0, 0);
                        setTimeout(function () {
                            window.location.reload();
                        }, 500);
                    } else {
                        $('#errorModal').modal('show');
                        $('.msg_error').text(data.message);
                    }
                },
                error: function (data) {
                    console.log(data);
                    $(".theloading").hide();
                }
            })
        }
    })

    $('#clearData').click(function () {
        $('#supplier').val('');
        $('#date_order_start').val('');
        $('#date_order_end').val('');
        $('#startDate').val('');
        $('#endDate').val('');
        $('#date_acceptance_complete_start').val('');
        $('#date_acceptance_complete_end').val('');
        $('#status').val('');
    })

    $('#clear_note').click(function () {
        $('#title_note_publications').val('');
        $('#description_note_publications').val('');
    })
})
  $('a.redirect').on('click', (e) => {
    e.preventDefault();
    let url = $(e.target).attr('href');
    Redirect(url, false);
  })
</script>

@endsection

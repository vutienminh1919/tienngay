@extends('viewcpanel::layouts.master')

@section('title', 'Chi tiết phiếu mua ấn phẩm')

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
<style>

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .fancybox__content {
        top: -245px;
    }

    .wrapper {
        width: 100%;
        padding: 0px 20px;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .modal-backdrop {
        display: none !important;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
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
        text-decoration: none;
    }

    .btn-header{
        display: flex;
        gap: 10px;
    }

    .block_contract_info {
        width: 100%;
        background: #FFFFFF;
        border: 1px solid #F0F0F0;
        border-radius: 8px;
        padding: 16px 16px 24px;
    }
    .block_list_order,
    .block_history {
        width: 100%;
        background: #FFFFFF;
        border: 1px solid #F0F0F0;
        border-radius: 8px;
    }

    .block_contract_info h5 {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: #3B3B3B;
    }
    .block_list_order h5,
    .block_history h5 {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: #3B3B3B;
        margin: 0px;
    }

    .form-input {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-top: 12px;
    }

    .form-input label {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #3B3B3B;
    }

    .form-input input {
        width: 100%;
        height: 40px;
        background: #E6E6E6;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        outline: none;
        padding-left: 5px;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #676767;

    }
    .btn-outline-success {
        font-weight: 600;
        font-size: 12px;
        line-height: 14px;
        color: #1D9752;
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
    .header_list_order {
        display: flex;
        justify-content: space-between;
        padding: 16px;
    }
    thead {
        background: #E8F4ED;
    }

    th {
        white-space: nowrap;
        text-align: center;
        border-bottom-width: 0px !important;
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 16px;
        color: #262626;

    }

    td {
        white-space: nowrap;
        text-align: center;
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #676767;
    }

    td a {
        text-decoration: none;
        color: #4299E1;
    }

    /* ----------------------- */
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

    .form-modal-details {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .form-modal-details h5 {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: rgba(59, 59, 59, 1);
    }

    .form-input-label h5 {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #3B3B3B;
    }

    .form-input-label p {
        font-style: normal;
        font-weight: 400;
        font-size: 10px;
        line-height: 12px;
        color: rgba(103, 103, 103, 1);
        margin: 3px;
    }

    .img-area {
        border: solid 1px #D8D8D8;
        border-radius: 5px;
        padding: 3px;
        /*margin-bottom: 10px;*/
        position: relative;
    }

    .upload-hidden {
        display: none;
    }

    .cancelButton {
        -moz-appearance: none;
        -webkit-appearance: none;
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

    .modal-dialog {
        bottom: 32%;
    }

    .fixHeight {
        bottom: 32%;
    }

    /*#modal4 .modal-dialog {*/
    /*     bottom: -2%;*/
    /*}*/

    #successModal .modal-dialog{
        bottom: -12%;
    }

    #errorModal .modal-dialog {
        bottom: -12%;
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
        align-items: center;
    }

    .deleteModal{
        margin-bottom: 0rem !important;
    }

    .note-modal {
        top: -360px;
    }

    .btn-secondary {
        background-color: #D8D8D8;
        color: #676767;
        border-color: #D8D8D8;
    }

    .detail-acception{
        bottom: 245px;
    }

    .modal-image{
        bottom: -245px;
    }

    .invalid{
		border: 1px solid red !important;
	}


    @media screen and (max-width:48em) {
        .header {
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: flex-start;
        }

        .btn-header {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .btn-header button {
            width: 48%;
        }
        .header_list_order{
            display: flex;
            flex-direction: column;
        }

        table, tr{
            height: 48px;
        }

    }
</style>
@endsection
<div class="load"></div>
<div id="loading" class="theloading" style="display: none;">
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
</div>
@section('content')
<section id="hcns_oder_details">
    <div class="wrapper">
        <div class="header">
            <div class="header-title">
                <h3>Chi tiết đơn đặt hàng</h3>
                <small>
                    <a href="https://lms.tienngay.vn/"><i class="fa fa-home"></i> Khác</a> / <a
                        href="https://lms.tienngay.vn/pawn/contract">yêu cầu</a>
                </small>
            </div>
            <div class="btn-header">
                <a href="{{route('viewcpanel::trade.publication.list')}}">
                    <button type="button" class="btn" style="color: #676767;background: #D8D8D8;font-style: normal; font-weight: 600; font-size: 14px; line-height: 16px;">Trở về <i
                            class="fa fa-arrow-left" aria-hidden="true"></i></button>
                </a>
                @if($detail['status'] == 1 && $buttonSaveOrder)
                    <button type="button" id="saveOrder" data-order="{{$detail['_id']}}"
                            class="btn btn-success saveOrder">Đặt hàng <i class="fa fa-arrow-right"
                                                                          aria-hidden="true"></i></button>
                @else
                    <button type="button" style="display: none" id="saveOrder" class="btn btn-success saveOrder">Đặt
                        hàng <i
                            class="fa fa-arrow-right" aria-hidden="true"></i></button>
                @endif
                @if(($detail['status'] == 1 || $detail['status'] == 2 || $detail['status'] == 3) && $buttonUpdatePublic)
                    <a type="button" href="{{url('cpanel/trade/publication/update_publics/'.$detail['_id'])}}" id="updatePublic"
                       class="btn btn-success">Chỉnh sửa <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                @else
                    <a type="button" style="display: none"
                       href="{{url('cpanel/trade/publication/update_publics/'.$detail['_id'])}}"
                       class="btn btn-success">Chỉnh sửa <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                @endif
                @if(($detail['status'] == 3 || $detail['status'] == 4 || $detail['status'] == 2) && $buttonAcception)
                    <button type="button" class="btn btn-success" id="Acception" data-id="{{$detail['_id']}}"
                            data-bs-toggle="modal" data-bs-target="#modal3">Nghiệm thu <i class="fa fa-check"
                                                                                          aria-hidden="true"></i>
                    </button>
                @else
                    <button type="button" style="display: none" class="btn btn-success" id="Acception"
                            data-id="{{$detail['_id']}}" data-bs-toggle="modal" data-bs-target="#modal3">Nghiệm thu <i
                            class="fa fa-check" aria-hidden="true"></i></button>
                @endif
                @if($detail['status'] == 1 && $buttonDeletePublic)
                    <button  class="btn" data-block="{{$detail['_id']}}" id="blockPublic" data-bs-target="#cancelAdjustment" data-bs-toggle="modal"
                            style="background: #F4CDCD;color: rgb(199,4,4);">Xóa <i
                            class="fa fa-trash-o" aria-hidden="true"></i></button>
                @else
                     <button type="button" class="btn" data-block="{{$detail['_id']}}" id="blockPublic"
                            style="background: #F4CDCD;color: rgb(199,4,4);display: none">Xóa <i
                            class="fa fa-trash-o" aria-hidden="true"></i></button>
                @endif

                <!-- Modal -->
            </div>
        </div>
        <div class="block_contract_info">
            <h5>Thông tin chung </h5>
            <div class="form-contact-info row">
                <div class="form-input col-lg-4 col-md-4 col-xs-12">
                    <label>Nhà cung cấp</label>
                    <input type="text" disabled value="{{$detail->supplier}}"/>
                </div>
                <div class="form-input col-lg-4 col-md-4 col-xs-12">
                    <label>Chi phí khác</label>
                    <input type="text" disabled value="{{number_format($detail->other_costs)}}"/>
                </div>
                <div class="form-input col-lg-4 col-md-4 col-xs-12">
                    <label>Ngày nghiệm thu dự kiến</label>
                    <input type="text" disabled value="{{date('d/m/Y',$detail->date_acceptance)}}"/>
                </div>
                <div class="form-input col-lg-4 col-md-4 col-xs-12">
                    <label>Tổng số loại ấn phẩm</label>
                    <input type="text" disabled value="{{$detail->sum_item_id}}"/>
                </div>
                <div class="form-input col-lg-4 col-md-4 col-xs-12">
                    <label>Tổng số lượng ấn phẩm</label>
                    <input type="text" disabled value="{{$detail->sum_total}}"/>
                </div>
                <div class="form-input col-lg-4 col-md-4 col-xs-12">
                    <label>Tổng chi phí thực tế</label>
                    <input type="text" disabled value="{{number_format($detail->sum_money_publications)}}"/>
                </div>
                <div class="form-input col-lg-4 col-md-4 col-xs-12">
                    <label>Người tạo</label>
                    <input type="text" value="{{$detail['created_by']}}" disabled/>
                </div>
                <div class="form-input col-lg-4 col-md-4 col-xs-12">
                    <label>Ngày tạo</label>
                    <input type="text" disabled value="{{date('d/m/Y',$detail->created_at)}}"/>
                </div>
                <div class="form-input col-lg-4 col-md-4 col-xs-12">
                    <label>Ngày đặt hàng</label>
                    <input type="text" disabled value="{{date('d/m/Y',$detail->date_order)}}"/>
                </div>
                <div class="form-input col-lg-4 col-md-4 col-xs-12">
                    <label>Trạng thái</label>
                    <input type="text" style="color: green;" disabled
                           @switch($detail->status)
                           @case(1)
                           value="Mới"
                           @break
                           @case(2)
                           value="Đã đặt hàng"
                           @break
                           @case(3)
                           value="Chờ nghiệm thu"
                           @break
                           @case(4)
                           value="Đang nghiệm thu"
                           @break
                           @case(5)
                           value="Nghiệm thu hoàn thành"
                           @break
                           @default
                           Không xác định
                        @endswitch
                    />
                </div>
            </div>
        </div>
        <div class="block_list_order">
            <div class="header_list_order">
                <h5>Danh sách ấn phẩm đặt hàng</h5>
                <button type="button" onclick="export_item('xlsx', 'danh_sach_an_pham_trade')"
                        class="btn btn-outline-success">Xuất excel <img
                        src="https://service.tienngay.vn/uploads/avatar/1669364070-d7a257cd601ea15a96b19fb403608675.png"
                        alt=""></button>
            </div>
            <div class="table-list-order table-responsive">
                <table class="table table-hover total_table" id="total_table">
                    <thead>
                    <tr style="height: 48px; vertical-align: middle;">
                        <th scope="col">STT</th>
                        <th scope="col">Mã ấn phẩm</th>
                        <th scope="col">Tên ấn phẩm</th>
                        <th scope="col">Loại ấn phẩm</th>
                        <th scope="col">Quy cách</th>
                        <th scope="col">Số lượng đặt hàng</th>
                        <th scope="col">Đơn giá dự kiến</th>
                        <th scope="col">Đơn giá thực tế</th>
                        <th scope="col">Chi phí thực tế</th>
{{--                        <th scope="col">Trạng thái</th>--}}
                        <th scope="col">Số lượng đã nghiệm thu</th>
                        <th scope="col">Số lượng chờ nghiệm thu</th>
                        <th scope="col">Số lượng đã phân bổ</th>
                        <th scope="col">Chức năng</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($resultFindOne as $key => $value) : ?>
                    <?php foreach ($value as $k => $v) : ?>
                    <tr style="height: 48px; vertical-align: middle;">
                        <td>{{++$key}}</td>
                        <td>{{$v['item_id']}}</td>
                        <td>{{$v['name_publications']}}</td>
                        <td>{{$v['type']}}</td>
                        <td>{{$v['specification']}}</td>
                        <td>{{$v['total_clone']}}</td>
                        <td>{{number_format($v['price'])}}</td>
                        <td>{{number_format($v['money_publications'])}}</td>
                        <td>{{number_format($v['money_total'])}}</td>
{{--                        <td>--}}
{{--                            @if(!empty($v['total_acceptance']) && (($v['total']  > 0) && ($v['total'] < $v['total_clone']) ))--}}
{{--                                Đang nghiệm thu--}}
{{--                            @elseif(!empty($v['total_acceptance']) && ($v['total'] == '0'))--}}
{{--                                Nghiệm thu hoàn thành--}}
{{--                            @endif--}}
{{--                        </td>--}}
                        <td>{{!empty($v['total_acceptance']) ? $v['total_acceptance'] : ''}}</td>
                        <td>@if (!empty($v['total_acceptance'])) {{$v['total_clone'] - $v['total_acceptance']}}  @endif</td>
                        <td> <?= ($v['total_acceptance'] - $v['total_quantity_tested'])?></td>
                        <td>
                            <div class="dropdown dropstart">
                                <i class="fa fa-bars " aria-hidden="true" data-bs-toggle="dropdown"
                                   aria-expanded="false" style="color: #1D9752;"></i>
                                <ul class="dropdown-menu">
                                    <li data-bs-toggle="modal" data-bs-target="#Modal1">
                                        <a class="dropdown-item notePuclications" id="notePuclications" href="#"
                                           data-key="{{$k}}" data-id="{{$detail['_id']}}">Ghi chú</a></li>
                                    @if((!empty($v['total_acceptance'])) && $buttonDetailPuclic )
                                        @if((($v['total_acceptance'] - $v['total_quantity_tested']) < $v['total_clone']))
                                            <li data-bs-toggle="modal" data-bs-target="#">
                                                <a class="dropdown-item detailPuclic" id="detailPuclic"
                                                   href="{{route('viewcpanel::trade.publication.findOneKeyId',['id' => $detail['_id'],'key_id' => $k])}}">Phân
                                                    bổ</a></li>
                                        @else
                                            <li data-bs-toggle="modal" data-bs-target="#">
                                                <a class="dropdown-item detailPuclic" id="detailPuclic"
                                                   style="display: none"
                                                   href="{{route('viewcpanel::trade.publication.findOneKeyId',['id' => $detail['_id'],'key_id' => $k])}}">Phân
                                                    bổ</a></li>
                                        @endif
                                    @else
                                        <li data-bs-toggle="modal" data-bs-target="#">
                                            <a class="dropdown-item detailPuclic" id="detailPuclic"
                                               style="display: none"
                                               href="{{route('viewcpanel::trade.publication.findOneKeyId',['id' => $detail['_id'],'key_id' => $k])}}">Phân
                                                bổ</a></li>
                                    @endif

                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach ?>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="block_history">
            <h5 style="padding: 16px;">Lịch sử nghiệm thu</h5>
            <div class="table-history table-responsive">
                <table class="table table-hover" >
                    <thead>
                    <tr style="height: 48px; vertical-align: middle;">
                        {{--<th scope="col">id</th>--}}
                        <th scope="col">STT</th>
                        <th scope="col">Người nhận nghiệm thu</th>
                        <th scope="col">Ngày nhận</th>
                        <th scope="col">Tổng loại ấn phẩm</th>
                        <th scope="col">Tổng số lượng nghiệm thu</th>
                        <th scope="col">Chứng từ</th>
                        <th scope="col">Chi tiết</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($logAcception as $key => $value) : ?>
                    <tr style="height: 48px; vertical-align: middle;">
                        {{--<td>{{$value['_id']}}</td>--}}
                        <td>{{++$key}}</td>
                        <td>{{!empty($value['created_by']) ? $value['created_by'] : ""}}</td>
                        <td>{{date('d/m/Y',$value['created_at'])}}</td>
{{--                        <td>{{$value['sumTotal']}}</td>--}}
                        <td>{{!empty($value['arrTotalSumPb']) ? $value['arrTotalSumPb'] : ""}}</td>
                        <td>{{$value['sumTotalAcception']}}</td>
                        <td><a href="#" data-bs-toggle="modal" id="logLicense" class="logLicense"
                               data-bs-target="#modal4" data-id="{{$value['_id']}}"
                               data-license="{{!empty($value['image_acception']) ? json_encode($value['image_acception']) : ""}}">Chứng
                                từ</a></td>
                        <td><a href="#" data-bs-toggle="modal" id="logPublic" class="logPublic"
                               data-id="{{$value['_id']}}" data-bs-target="#modal2"> Chi tiết</a></td>

                    </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>

        </div>

        <!-- ----------modal ghi chú ------------ -->
        <div class="modal fade" id="Modal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered note-modal">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-ghichu">
                           <div class="row">
                               <h5 class="col-11" style="text-align: center">Ghi chú</h5>
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                           </div>
                            <div class="box-note">
                                <input type="text" id="notePublics" class="notePublics" value="" name="notePublics"
                                       hidden>
                                <input type="text" id="id_publication" class="id_publication" value=""
                                       name="id_publication" hidden>
                                <label hidden>Tiêu đề<span style="color: red;">*</span></label>
                                <input type="text" style="border-radius: 3px" name="titleNotePublications"
                                       id="titleNotePublications" class="titleNotePublications" hidden>
                                <label>Thêm ghi chú <span style="color: red;">*</span></label>
                                <textarea placeholder="Nhập" name="descriptionNote" id="descriptionNote"
                                          class="descriptionNote"></textarea>
                            </div>
                            <div class="modal-btn" style="display: flex; gap: 10px;">
                                <button type="button" id="saveNote" class="btn btn-success"
                                        style="width: 50%;">Thêm
                                </button>
                                <button type="button" class="btn btn-secondary" id="clear_note"
                                        style="width: 50%;">Hủy
                                </button>
                            </div>
                            <div class="note_title" style="max-height: 500px;overflow: auto"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- -----------------modalchitiết-------------------- -->
        <!-- Modal -->
        <div class="modal fade" id="modal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered detail-acception">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-modal-details">
                            <h5 style="text-align: center;">Chi tiết nghiệm thu</h5>
                            <div class="log_title" style="top:150px;overflow-y: auto;max-height: 600px;overflow-x: hidden">

                            </div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- -----------------modal nghiệm thu-------------------- -->
        <div class="modal fade" id="modal3" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered fixHeight">
                <div class="modal-content" style="top: 150px">
                    <div class="modal-body">
                        <div class="form-modal-details">
                            <h5 style="text-align: center;">Nghiệm thu ấn phẩm</h5>
                            <input type="text" class="idAccep form-input" id="idAccep" name="idAccep" hidden>
                            <div id="block_acceptions" class="block_acceptions" data-block="" style="top:150px;overflow-y: auto;max-height: 600px;overflow-x: hidden">
                                <div class="form-input-label row"></div>

                            </div>
                            <div class="img-area">
                                <div id="imgInput"></div>
                                <a type="button" class="upload btn btn-default btn-lg" id="call-to-action"> Tải ảnh lên
                                </a>
                                <i style="position: absolute;right: 10px;top: 20%;" class="fa fa-upload"
                                   aria-hidden="true"></i>
                                <div id="drop">
                                    <input type="file" name="imgs" multiple  class="upload-hidden">
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="button" id="saveAcception" class="btn btn-success accButton"   style="display: none">
                                Nghiệm thu
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- -----------------modal chứng từ nghiệm thu-------------------- -->
        <div class="modal fade" id="modal4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-image">
                <div class="modal-content" style="margin: 0px !important;width: 100% !important;">
                    <div class="modal-header">
{{--                        <h5 class="modal-title" id="exampleModalLabel">Chi tiết chứng từ</h5>--}}
                         <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12 col-md-12" style="text-align: center;">
                                    <h7>Hình ảnh</h7>
                                    <hr>
                                    <div id="imgPath">
                                    </div>
                                    <div style="display:none" class="imgP"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                {{--            <a id="redirect-url" class="btn btn-success">Xem</a>--}}
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- modal error -->
<div class="modal fade" id="errorModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modalError">
        <div class="modal-content ">
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
{{--        modal hủy duyệt pdc --}}
<div class="modal fade" id="cancelAdjustment" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="width: 100% !important">
            <div class="modal-body">
                <div class="form-modal">
                    <h5 style="text-align: center">Xóa</h5>
                    <input hidden type="text" class="id_adjustment_cancel">
                    <p style="text-align: center" class="deleteModal">Bạn có chắc chắn muốn xoá bản ghi này</p>
                    <div class="modal-btn" style="text-align: center;margin-left:4px;">
                        <button class="cancel-adjustment btn" id="cancel-adjustment" data-block="{{$detail['_id']}}"
                                style="background: #c50505;color: #ede1e1;border-radius: 5px;width:200px;margin: 20px;height: 45px">Đồng ý
                        </button>
                        <button data-bs-dismiss="modal" class="btn"
                                style="background: #e3e0e0;color: #7c7c83;border-radius: 5px;width:200px;height: 45px">Hủy
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script type="text/javascript" src="{{ asset('viewcpanel/js/xlsx.js') }}"></script>
<script>
    const csrf = "{{ csrf_token() }}";
    const rootId = '{{$id}}';
    $(document).ready(function () {
        $('.notePuclications').click(function (event) {
            var id = $(this).attr('data-id');
            var id_publication = $(this).attr('data-key');
            var formData = new FormData();
            formData.append('_id', id);
            formData.append('id_publication', id_publication);
            $.ajax({
                url: '{{route('viewcpanel::trade.publication.findPubl')}}',
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                type: "POST",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $(".theloading").show();
                    $(".note_title").html("")
                },
                success: function (data) {
                    $('.notePublics').val(rootId)
                    let item = data.data.data[0];
                    let itemNote = (data.data.data[0][id_publication].note_description)
                    $('.id_publication').val(id_publication)
                    if((data.data.data[0][id_publication].note_description)){
                        if (((data.data.data[0][id_publication].note_description).length) >= 1) {
                            var arrNote = ((data.data.data[0][id_publication].note_description).length) - 1;
                            for (let i = arrNote; 0 <= i; i--) {
                                data.data.data[0][id_publication].note_description[i]
                                //console.log(data.data.data[0][id_publication].note_description[i])
                                var newDateFormat = new Date(data.data.data[0][id_publication].note_description[i].created_at * 1000)
                                var options = {year: 'numeric', month: 'short', day: 'numeric'};
                                var formattedDate = newDateFormat.toLocaleDateString('vi-VN', options);
                                $(".note_title").append(
                                    ' <p style="color: #676767;margin-bottom: 0">' + data.data.data[0][id_publication].note_description[i].created_by + '</p>' +
                                    ' <p style="color: #B8B8B8;margin-bottom: 0">' + formattedDate + '</p>' +
                                    ' <p style="color: #676767;margin-bottom: 0">' + data.data.data[0][id_publication].note_description[i].description + '</p><br>'
                                );
                            }
                        }
                    }
                }
            });
        });

        $('#saveNote').click(function (event) {
            event.preventDefault();
            var id = $("input[name='notePublics']").val();
            var id_publication = $("input[name='id_publication']").val();
            var titleNotePublications = $("input[name='titleNotePublications']").val();
            var descriptionNote = $("textarea[name='descriptionNote']").val();
            var formData = new FormData();
            formData.append('_id', id)
            formData.append('id_publication', id_publication)
            //formData.append('note', titleNotePublications)
            formData.append('description', descriptionNote)
            console.log(id, id_publication, descriptionNote);
            $.ajax({
                url: '{{route('viewcpanel::trade.publication.notePuclication')}}',
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                type: "POST",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $(".theloading").show();
                },
                success: function (data) {

                    $(".theloading").hide();
                    $(".modal_missed_call").hide();
                    if (data.status == 200) {
                        $('#successModal').modal('show');
                        $('.msg_success').text(data.message);
                        let modalContent = $($('#Modal1').find(".note_title")[0]);
                        //console.log(modalContent)
                        modalContent.html("");
                        let rows = "";
                        //console.log(data.data.data.resultIdNote.note_description)
                        if (data.data.data.resultIdNote.note_description) {
                            var idNoteP = (data.data.data.resultIdNote.note_description).length;
                            for (let i = idNoteP - 1; 0 <= i; i--) {
                                data.data.data.resultIdNote.note_description[i]
                                var newDateFormat = new Date(data.data.data.resultIdNote.note_description[i].created_at * 1000)
                                var options = {year: 'numeric', month: 'short', day: 'numeric'};
                                var formattedDate = newDateFormat.toLocaleDateString('vi-VN', options);
                                rows += ' <p  style="color: #676767;margin-bottom: 0">' + data.data.data.resultIdNote.note_description[i].created_by + '</p>' +
                                    ' <p  style="color: #B8B8B8;margin-bottom: 0">' + formattedDate + '</p>' +
                                    ' <p  style="color: #676767;margin-bottom: 0">' + data.data.data.resultIdNote.note_description[i].description + '</p><br>'
                            }
                        }
                        modalContent.html(rows);
                        $('#descriptionNote').val('')
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

        });
//chi tiết từng lần nghiệm thu
        $('.logPublic').click(function (event) {
            var id = $(this).attr('data-id');
            var formData = new FormData();
            formData.append('_id', id);
            $.ajax({
                url: '{{route('viewcpanel::trade.publication.dtailLogAcception')}}',
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                type: "POST",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $(".theloading").show();
                    $(".log_title").html("")
                },
                success: function (data) {
                    //console.log(data.data.data)
                    $.each(data.data.data, function (k, v) {
                        console.log(v.total_acceptance)
                        if (v.total_acceptance > 0) {
                            $(".log_title").append(
                                '<div class="form-input-label row">' +
                                '<h5 class="col-lg-12 col-md-12 col-xs-12">' + v.name_publications + '</h5>' +
                                '<h5 class="col-lg-12 col-md-12 col-xs-12">' + v.type + '</h5>' +
                                ' <li style="list-style:none"><p class="col-lg-12 col-md-12 col-xs-12">' + v.specification + '</p></li>' +
                                '<div  class="col-lg-6 col-md-6 col-xs-12 form-input"><label>' + 'Số lượng cần nhận' + '</label><input value="' + v.total + '" disabled/></div>' +
                                '<div class="col-lg-6 col-md-6 col-xs-12 form-input"><label>' + 'số lượng nghiệm thu' + '</label><input value="' + v.total_acceptance + '"/></div>' +
                                '</div><br>'
                            );
                        }
                    })
                }
            });
        })

        $('#Acception').click(function (event) {
            var _el = $(event.target).closest(".block_acceptions");
            var id = $(this).attr('data-id');
            var formData = new FormData();
            formData.append('_id', id);
            $.ajax({
                url: '{{route('viewcpanel::trade.publication.detailPublication')}}',
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                type: "POST",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $(".theloading").show();
                    $(".acceptionPublic").html("")
                },
                success: function (data) {
                    $('#idAccep').val(data.data._id);
                    let block = "";
                    let block_acceptions = $("#block_acceptions")
                    $.each(data.data.lead_publications, function (key, value) {
                        block += `<div class="form-input-label row child-block">`
                        block += `<h5 class="col-lg-12 col-md-12 col-xs-12">` + value.name_publications + `</h5>`
                        block += `<p class="col-lg-12 col-md-12 col-xs-12">` + value.type + `</p>`
                        block += `<p class="col-lg-12 col-md-12 col-xs-12">` + value.specification + `</p>`
                        block += `<div class="col-lg-6 col-md-6 col-xs-12 form-input">`;
                        block += `<label>Số lượng cần nhận</label>`;
                        block += `<input type="text" value="` + value.total + `" name="total" disabled/>`;
                        block += `</div>`;
                        block += `<div class="col-lg-6 col-md-6 col-xs-12 form-input">`
                        block += `   <label>Số lượng nghiệm thu<span style="color: red">*</span></label>`
                        block += `  <input type="text" value="" name="total_acceptance" class="total_acceptance" id="" style="background-color:white"/>`
                        block += `</div>`
                        block += `<input value="` + value.key_id + `" name="key" class="key" hidden/>`
                        block += `<div class="acceptionPublic"></div></div><br>`;
                    })
                    $(block_acceptions).html(block)
                },
            });
        });
//nghiệm thu ấn phẩm
        $('#saveAcception').click(function (event) {
            $('.invalid-message').remove();
			$('.invalid').removeClass();
            var id = $("input[name='idAccep']").val();
            var countBlock = 0;
            var arrAcception = []
            var license = [];
            $("input[name='url[]']").each(function () {
                license.push($(this).val());
            });
            $('.block_acceptions .child-block').each(function (key, value) {
                var block = $(value)
                block.attr('data-block', countBlock)
                var key = block.find("[name='key']").val()
                var total_acceptance = block.find("[name='total_acceptance']").val()
                var total = block.find("[name='total']").val()
                var data = {
                    total:parseInt(total),
                    key: key,
                    total_acceptance: total_acceptance,
                }
                arrAcception.push(data);
                countBlock++
            })
            //console.log(arrAcception)
            $.ajax({
                url: '{{route('viewcpanel::trade.publication.acceptionPublic')}}',
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    'x-csrf-token': csrf
                },
                type: "POST",
                data: JSON.stringify({
                    "data": arrAcception,
                    "_id": id,
                    "image_acception": license
                }),
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $(".theloading").show();
                },
                success: function (data) {
                    $(".theloading").hide();
                    if (data.status == 200) {
                        $('#successModal').modal('show');
                        $('.msg_success').text(data.message);
                        window.scrollTo(0, 0);
                        setTimeout(function () {
                            window.location.reload();
                        }, 1500);
                    } else {
                        if(data.message){
                            $('#errorModal').modal('show');
                            $('.msg_error').text(data.message);
                        }
                        if (data.errors) {
                            $.each(data.errors, function (key, value) {
                                let splitKey = key.split(".");
                                let el = $("[name='" + splitKey[0] + "']");
                                if (splitKey.length > 2) {
                                let block = $('[data-block="' + splitKey[1] + '"]');
                                el = block.find("[name='" + splitKey[2] + "']");
                                 }
                                if(el.attr('name') == 'total_acceptance'){
                                    el.addClass('invalid');
                                    el.after('<span style="margin-top: -8px;color: red;font-size: 14px" class="invalid-message" >' + value[0] + '</span>');
                                }else{
                                    el.addClass('invalid');
                                    el.after('<span style="margin-top: -8px;color: red;font-size: 14px" class="invalid-message" >' + value[0] + '</span>');
                                }
                            })
                        }
                    }
                },
                error: function (data) {
                    console.log(data);
                    $(".theloading").hide();
                }
            })
        });

        $('#saveOrder').click(function () {
            event.preventDefault();
            let id = $(this).attr('data-order');
            let formData = new FormData();
            formData.append('_id', id);
            console.log(id)
            if (confirm("Bạn có chắc chắn muốn đặt hàng ấn phẩm này?")) {
                $.ajax({
                    url: "{{route('viewcpanel::trade.publication.update_status_order')}}",
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
                            }, 2500);
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


    })

    $('.upload-hidden').on('change', function () {
        var files = $(this)[0].files;
        for (let i = 0; i < files.length; i++) {
            let file = files[i];
            uploadImgs(file);
        }
        if(files != ""){
            $('.accButton').css('display','inline')
        }
    });

    $('#call-to-action').click(function () {
        $('.upload-hidden').click();
    });
//xóa từng ảnh
    function deleteImage(el) {
        if (confirm("Bạn có chắc chắn muốn xóa ?")) {
            let a = $(".img-area").find('.block').length;
            console.log(a);
            if (a == 1) {
                $('.fa-upload').attr('hidden', false);
                 $('.accButton').css('display','none')
            }
            $(el).closest(".block").remove();
            $('#drop').find('[type="file"]').first().val('');
        }

    }

    const uploadImgs = async function (file) {
        var formData = new FormData();
        formData.append('file', file);
        console.log(file.type);
        var mine = ['image/jpeg', 'image/png', 'image/jpg'];
        if (mine.includes(file.type)) {
            //
        } else {
            alert("File upload không đúng định dạng")
            return;
        }

        await $.ajax({
            dataType: 'json',
            enctype: 'multipart/form-data',
            url: '{{route('viewcpanel::trade.publication.uploadFile')}}',
            type: 'POST',
            headers: {
                'x-csrf-token': csrf
            },
            data: formData,
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            success: function (data) {
                console.log(data);
                if (data && data.code == 200) {
                    $('.fa-upload').attr('hidden', true);
                    if (file.type == 'image/jpeg' || file.type == 'image/png' || file.type == 'image/jpg') {
                        let block = `
                <div class="block" style="width:auto; border:none; ">
                  <a target="_blank" style="font-size:14px;text-decoration: none " href="` + data.path + `">` + data.raw_name + ` </a>
                  <input data-fileType ="` + file.type + `" data-fileName = "` + data.raw_name + `" type="hidden" name="url[]" value="` + data.path + `" class="fanxybox">
                  <button style="" type="button" onclick="deleteImage(this)" class="cancelButton">
                    <i style="font-size: 20px;margin-top: 12px;" class="fa fa-times"></i>
                  </button>
                </div>
                `;
                        $('#imgInput').before(block);
                    } else {
                        let block = `
                    <div class="block" style="width:auto; border:none; ">
                         <a style="font-size:14px;text-decoration: none " href="` + data.path + `">` + data.raw_name + ` </a>
                        <input data-fileType ="` + file.type + `" data-fileName = "` + data.raw_name + `" multiple type="hidden" name="url[]" id="url" value="` + data.path + `">
                        <button style="position: absolute;top: -3px;" type="button" onclick="deleteImage(this)" class="cancelButton">
                            <i style="font-size: 20px;margin-top: 12px;" class="fa fa-times"></i>
                        </button>
                    </div>
                    `;
                        $('#imgInput').before(block);
                    }

                } else if (typeof (data) == "string") {

                } else {

                }
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });

    }
//show ảnh chứng từ
    $('.logLicense').on('click',function (event) {
          event.preventDefault();
          var id_log = $(this).attr('data-id')
          var formData = new FormData();
          formData.append('_id',id_log)
        $.ajax({
            url: '{{route('viewcpanel::trade.publication.dtailLogAcception1')}}',
            type: 'POST',
            dataType: 'json',
            // headers: {
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            // },
            headers: {
                // "Content-Type": "application/json",
                // Accept: "application/json",
                'x-csrf-token': csrf
            },
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $(".theloading").hide();
                if (data.status == 200) {
                      $('#id_log').val(data.data.data.id_clone)
                      var imgbp = '';
                      var imgFind = $('#imgPath');
                          imgbp +=`<input type="text"  name="id_log" class="id_log" id="id_log" hidden value="`+data.data.data.id_clone+`">
                                   <img style="width: 50%; height: 200px;"
                                   src="` + data.data.data.image_acception[0] + `"
                                   alt=""
                                   class="underline cursor-pointer"
                                   data-fancybox-trigger="gallery-license" id="imgs">`
                             imgbp +='<h5>'+' + '+ data.data.data.image_acception.length +'</h5>'
                      $(imgFind).html(imgbp)
                        $('#imgs').on('click', function () {
                            $('#modal4').hide();
                        })
                }
            }
        })
    })

    $('.logLicense').on('click',function (event) {
        event.preventDefault();
        $('.removeImage').remove();
        let license = $(this).attr('data-license');
        license = JSON.parse(license);
        $('#documentPath').html('');
        $.each(license, function (key, value) {
            $('.imgP').append('<a data-fancybox="gallery-license" href="' + value + '" class="removeImage"><img class="rounded" src="' + value + '"></a></div>')
        })
    })

    function export_item(fileExtension, fileName) {
        let el = document.getElementById("total_table");
        let wb = XLSX.utils.table_to_sheet(el, {sheet: 'Sheet1'});
        const ne = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(ne, wb, "Sheet1");
        return XLSX.writeFile(ne, fileName + "." + fileExtension || ('MySheetName.' + (fileExtension || 'xlsx')));
    }


    // $('#blockPublic').on('click',function (e) {
    $('#cancel-adjustment').on('click',function (e) {
        e.preventDefault()
        var idBlock = $(this).attr('data-block')
        var formData = new FormData();
        formData.append('_id',idBlock)
        console.log(idBlock)
            $.ajax({
                url: "{{route('viewcpanel::trade.publication.update_status_block')}}",
                type: "POST",
                data: formData,
                dataType: 'json',
                headers: {
                    'x-csrf-token': csrf
                },
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('#cancelAdjustment').hide();
                    $(".theloading").show();
                },
                success: function (data) {
                    $(".theloading").hide();
                    //console.log(data.message)
                    if (data.status == 200) {
                        $('#successModal').modal('show');
                        $('.msg_success').text(data.message);
                        window.scrollTo(0, 0);
                        setTimeout(function () {
                            window.location.href='{{route('viewcpanel::trade.publication.list')}}';
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
    })

    $('#clear_note').click(function () {
        $('#titleNotePublications').val('');
        $('#descriptionNote').val('');
    })

    // $('.total_acceptance').on('change',function (e) {
    //     e.preventDefault()
    //
    // })

</script>
<script type="text/javascript">
  $(document).ajaxStart(function() {
    $("#loading").show();
    var loadingHeight = window.screen.height;
    $("#loading, .right-col iframe").css('height', loadingHeight);
    }).ajaxStop(function() {
      $("#loading").hide();
  });
</script>
@endsection


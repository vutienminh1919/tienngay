@extends('viewcpanel::layouts.master')

@section('title', 'Thêm mới đơn đặt hàng')

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .wrapper {
        width: 100%;
        padding: 0px 20px;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .header-details {
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

    .header-btn {
        display: flex;
        gap: 10px;
    }

    .block-information {
        width: 100%;
        background: #FFFFFF;
        border: 1px solid #F0F0F0;
        border-radius: 8px;
        padding: 24px 16px;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .block-information h5 {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: #3B3B3B;
    }

    .form-ip {
        display: flex;
        flex-direction: column;
        gap: 8px;
        padding-top: 10px;
    }

    .form-ip label {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        display: flex;
        align-items: center;
        color: #3B3B3B;
    }
    .label-img label {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #3B3B3B;
    }

    .form-ip span {
        color: red;
    }

    .form-ip input {
        width: 100%;
        height: 40px;
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        outline: none;
        padding-left: 5px;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #676767;
    }

    .form-ip input::placeholder {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #B8B8B8;
    }

    .form-select {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #B8B8B8;
        padding: 12px;
    }

    .box2 input {
        background: #E6E6E6;
    }

    .block-information-title {
        display: flex;
        justify-content: space-between;
    }

    .block-information-title h5 {
        margin: 0px;
    }

    .fancy-img img {
        width: 100%;
        height: 200px;
    }

    .btn-del button {
        width: 100%;
        height: 40px;
        background: #F4CDCD;
        font-weight: 600;
        font-size: 14px;
        line-height: 16px;
        color: #C70404;
        outline: none;
        border: none;
        border-radius: 8px;
        padding: 0px 12px;
    }

    .box-title-info {
        background: #FFFFFF;
        border: 1px solid #F0F0F0;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.05);
        border-radius: 8px;
        margin: 24px 0px;
        padding: 16px 0px;
    }

    .label-img {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .btn-more {
        display: flex;
        justify-content: flex-end;
    }

    .footer {
        display: flex;
        justify-content: space-between;
    }

    .btn-footer {
        padding: 8px 16px;
        gap: 8px;
        width: 190px;
        height: 40px;
        border: none;
        outline: none;
        border-radius: 6px;
        margin: 24px 0px;
    }

    .btn1,
    .btn3 {
        background: #1D9752;
        color: #FFFFFF;
    }

    .btn2 {
        background: #F4CDCD;
        color: #C70404;
    }

    .footer-left {
        display: flex;
        gap: 20px;
    }

    .modal-upload h5 {
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 24px;
        color: #3B3B3B;
    }
    .modal-upload input{
        padding: 5px ;

    }
    .modal-ip{
        display: flex;
        justify-content: space-between;
    }
    .modal-ip button{
       height: 35px;
    }

    .modal-dialog {
        bottom: 35%;
    }

    #successModal .modal-dialog{
        bottom: -10%;
    }

    #errorModal .modal-dialog{
        bottom: -10%;
    }

    @media screen and (max-width:48em) {
        .footer {
            display: flex;
            flex-direction: column;
            gap: 10px;

        }

        .footer-left {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .btn-footer {
            margin: 0px;
            width: 100%;
        }

        .header-details {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-del button {
            margin-top: 20px;
        }

    }
    .hidden {
        display: none !important;
    }

    .invalid {
        font-size: 13px;
        color: red;
        font-weight: 500;
    }

    .border-red {
        border-color: red !important;
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

    .modal-dialog {
        bottom: 35%;
    }

    .xt {
        position: absolute;
        top: 50%;
        left: 50%;
        color: #ffffff;
    }
</style>
@endsection
<div class="load"></div>
<div id="loading" class="theloading" style="display: none;">
	<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
</div>
{{--	<?php if ($this->session->flashdata('error')) { ?>--}}
{{--		<div class="alert alert-danger alert-result" id="hide_it">--}}
{{--			<?= $this->session->flashdata('error') ?>--}}
{{--		</div>--}}
{{--	<?php } ?>--}}

{{--	<?php if ($this->session->flashdata('success')) { ?>--}}
{{--		<div class="alert alert-success alert-result" id="hide_it2"><?= $this->session->flashdata('success') ?></div>--}}
{{--	<?php } ?>--}}

{{--	<?php if (!empty($this->session->flashdata('notify'))) {--}}
{{--		$notify = $this->session->flashdata('notify'); ?>--}}
{{--		<?php foreach ($notify as $key => $value) { ?>--}}
{{--			<div class="alert alert-danger alert-result" id="hide_it3"><?= $value ?></div>--}}
{{--		<?php } ?>--}}
{{--	<?php } ?>--}}
@section('content')
<section id="hcns_create">
    <div class="wrapper">
        <div class="header-details">
            <div class="header-title">
                <h3>Thêm mới đơn đặt hàng</h3>
                <small>
                    <a href="{{$listPb}}"><i class="fa fa-home"></i> Khác</a> / <a href="{{$listPb}}">Báo cáo</a>
                </small>
            </div>
            <div class="header-btn">
                <a type="button" href="https://upload.tienvui.vn/uploads/avatar/1675838616-3a84c4ddb175904c9b8d21d288f20bcd.xlsx" class="btn btn-success">Tải xuống file mẫu <i class="fa fa-download" aria-hidden="true"></i></a>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Import file
                    <i class="fa fa-upload" aria-hidden="true"></i>
                </button>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="modal-upload">
                                    <h5>Upload</h5>
                                    <form class="form-inline" id="form_transaction"
                                          action="{{route('viewcpanel::trade.publication.importExcel')}}"
                                          enctype="multipart/form-data"
                                          method="post">
                                        <div class="form-group">
                                            <input type="file"  name="upload_file" class="form-control"
                                                   placeholder="sothing">
                                        </div>
                                        <button type="submit" class="btn btn-primary" id="import_baddebt"
                                                style="margin:0" data-bs-dismiss="modal">Import file
                                                </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="block-information">
            <h5>Thông tin chung </h5>
            <div class="form-box1 row">
                <div class="form-ip col-lg-4 col-md-6 col-xs-12">
                    <label>Nhà cung cấp <span>*</span></label>

                    <input type="text" name="supplier" id="supplier" placeholder="Nhà cung cấp"/>
                </div>
                <div class="form-ip col-lg-4 col-md-6 col-xs-12">
                    <label>Chi phí khác <span>*</span></label>
                    <input type="text" name="other_costs" id="other_costs" class="other_costs" placeholder="Chi phí khác"/>
                </div>
                <div class="form-ip col-lg-4 col-md-6 col-xs-12">
                    <label>Ngày đặt hàng <span>*</span></label>
                    <input placeholder="Chọn" class="textbox-n" type="text" onfocus="(this.type='date')"  id="date_order" name="date_order" />
                </div>
                <div class="form-ip col-lg-4 col-md-6 col-xs-12">
                    <label>Ngày nghiệm thu dự kiến <span>*</span></label>
                    <input placeholder="Chọn" class="textbox-n" type="text" onfocus="(this.type='date')"  id="date_acceptance" name="date_acceptance"/>
                </div>
            </div>
            <div class="box2 row">
                <div class="form-ip col-lg-4 col-md-6 col-xs-12">
                    <label>Tổng số loại ấn phẩm </label>
                    <input type="text" disabled id="sum_item_id" class="sum_item_id" name="sum_item_id">
                </div>
                <div class="form-ip col-lg-4 col-md-6 col-xs-12">
                    <label>Tổng số lượng ấn phẩm</label>
                    <input type="text" disabled id="totals" name="totals" class="totals">
                </div>
                <div class="form-ip col-lg-4 col-md-6 col-xs-12">
                    <label>Tổng chi phí thực tế</label>
                    <input type="text" disabled id="sum_money_publications" class="sum_money_publications" name="sum_money_publications">
                </div>
            </div>
        </div>
        <div class="block-information">
            <div class="block-information-title">
                <h5>Danh sách ấn phẩm đặt hàng</h5>
                <i class="fa fa-angle-up" aria-hidden="true"></i>
            </div>
            <div id="public-items" class="content3-div public-items">
                <div class="row box-title-info rounded block" id="box-public" data-id="0">
                    <div class="col-lg-8 col-md-12 col-xs-12 " >
                        <div class="form-box1 row">
                            <div class="form-ip col-lg-6 col-md-6 col-xs-12">
                                <label>Mã ấn phẩm <span>*</span></label>
                                @if(!empty($result_trade))
                                    <select id="item_id" class="form-select" name="item_id">
                                        <option value="">-- Chọn mã ấn phẩm --</option>
                                        @foreach($result_trade as $key => $value)
                                            <option value="{{$value['item_id']}}">{{$value['item_id']}}</option>
                                        @endforeach
                                    </select>
                                @else
                                    "không tồn tại ấn phẩm nào hết"
                                @endif
                            </div>
                            <div class="form-ip col-lg-6 col-md-6 col-xs-12">
                                <label>Số lượng <span>*</span></label>
                                <input type="text" placeholder="Nhập" name="total" id="total" class="total"/>
                            </div>
                            <div class="form-ip col-lg-6 col-md-6 col-xs-12">
                                <label>Đơn giá thực tế <span>*</span></label>
                                <input type="text" placeholder="Nhập" name="money_publications" class="money_publications"
                                       id="money_publications"/>
                            </div>
                            <div class="form-ip col-lg-6 col-md-6 col-xs-12">
                                <label>Chi phí thực tế</label>
                                <input type="text" style="background: #E6E6E6;" readonly name="money_total"
                                       id="money_total"/>
                            </div>
                            <div class="form-ip col-lg-6 col-md-6 col-xs-12">
                                <label>Tên ấn phẩm</label>
                                <input type="text" style="background-color: #E6E6E6;" readonly name="name" id="name"/>
                            </div>
                            <div class="form-ip col-lg-6 col-md-6 col-xs-12">
                                <label>Loại ấn phẩm</label>
                                <input type="text" style="background-color: #E6E6E6;" readonly name="type" id="type"/>
                            </div>
                            <div class="form-ip col-lg-6 col-md-12 col-xs-12">
                                <label>Quy cách</label>
                                <input type="text" style="background-color: #E6E6E6;" readonly name="specification"
                                       id="specification"/>
                            </div>
                             <div class="form-ip col-lg-6 col-md-12 col-xs-12" hidden>
                                <label>Đơn giá dự kiến <span>*</span></label>
                                <input type="text"  style="background-color: #D8D8D8;" readonly name="price"
                                       id="price"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-8 col-xs-12">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-xs-12" style="padding-top: 12px;">
                                <div class="label-img">
                                    <label>Ảnh mô tả </label>
                                    <div class="fancy-img image_detail" id="image_detail" style="position: relative">
                                        <img
                                            style="margin-top:12px; filter: brightness(50%);-webkit-filter: brightness(50%);"
                                            src="https://upload.tienvui.vn/uploads/avatar/1670989669-90c1884f975b32de3b276317bee81943.jpg"
                                            alt="" onerror="this.style.display='none'">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-xs-12 btn-del"
                                 style="display: flex; align-items: flex-end; height: 300;">
                                <button id="removeButton" class="removeButton" hidden>Xóa ấn phẩm</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div  class="row box-title-info rounded hidden" id="appendEl">
                    <div class="col-lg-8 col-md-12 col-xs-12 ">
                        <div class="form-box1 row">
                            <div class="form-ip col-lg-6 col-md-6 col-xs-12">
                                <label>Mã ấn phẩm <span>*</span></label>
                                @if(!empty($result_trade))
                                    <select id="item_id" class="form-select" name="item_id">
                                        <option value="">-- Chọn mã ấn phẩm --</option>
                                        @foreach($result_trade as $key => $value)
                                            <option value="{{$value['item_id']}}">{{$value['item_id']}}</option>
                                        @endforeach
                                    </select>
                                @else
                                    "không tồn tại ấn phẩm nào hết"
                                @endif
                            </div>
                            <div class="form-ip col-lg-6 col-md-6 col-xs-12">
                                <label>Số lượng <span>*</span></label>
                                <input type="text" placeholder="Nhập" name="total" id="total" class="total"/>
                            </div>
                            <div class="form-ip col-lg-6 col-md-6 col-xs-12">
                                <label>Đơn giá thực tế <span>*</span></label>
                                <input type="text" placeholder="Nhập" name="money_publications" class="money_publications"
                                       id="money_publications"/>
                            </div>
                            <div class="form-ip col-lg-6 col-md-6 col-xs-12">
                                <label>Chi phí thực tế</label>
                                <input type="text" style="background: #E6E6E6;" readonly name="money_total"
                                       id="money_total"/>
                            </div>
                            <div class="form-ip col-lg-6 col-md-6 col-xs-12">
                                <label>Tên ấn phẩm</label>
                                <input type="text" style="background-color: #E6E6E6;" readonly name="name" id="name"/>
                            </div>
                            <div class="form-ip col-lg-6 col-md-6 col-xs-12">
                                <label>Loại ấn phẩm</label>
                                <input type="text" style="background-color: #E6E6E6;" readonly name="type" id="type"/>
                            </div>
                            <div class="form-ip col-lg-6 col-md-12 col-xs-12">
                                <label>Quy cách</label>
                                <input type="text" style="background-color: #E6E6E6;" readonly name="specification"
                                       id="specification"/>
                            </div>
                            <div class="form-ip col-lg-6 col-md-12 col-xs-12" hidden>
                                <label>Đơn giá dự kiến <span>*</span></label>
                                <input type="text"  style="background-color: #D8D8D8;" readonly name="price"
                                       id="price"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-8 col-xs-12">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-xs-12" style="padding-top: 12px;">
                                <div class="label-img">
                                    <label>Ảnh mô tả </label>
                                    <div class="fancy-img image_detail" id="image_detail" style="position: relative">
                                        <img
                                            style="margin-top:12px; filter: brightness(50%);-webkit-filter: brightness(50%);"
                                            src="https://upload.tienvui.vn/uploads/avatar/1670989669-90c1884f975b32de3b276317bee81943.jpg"
                                            alt="" onerror="this.style.display='none'">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-xs-12 btn-del"
                                 style="display: flex;align-items: flex-end; height: 300;">
                                <button id="removeButton" class="removeButton">Xóa ấn phẩm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn-more">
                <button type="button" class="btn btn-outline-success" id="moreButton">Thêm ấn phẩm</button>
            </div>
        </div>
        <div class="footer">
            <div class="footer-left">
                <button class="btn-footer btn1" id="save_publications">Lưu</button>
                <a href="{{route('viewcpanel::trade.publication.list')}}"><button class="btn-footer btn2" >Hủy</button></a>
            </div>
            <div class="footer-right">
                <button class="btn-footer btn3" id="save_public_status_order">Đặt hàng</button>
            </div>
        </div>
    </div>
</section>
<!-- modal success -->
<div class="modal fade" id="successModal"  data-bs-keyboard="false" tabindex="-1"  aria-hidden="true">
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
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script>
const csrf = "{{ csrf_token() }}";
$(document).ready(function () {
    Array.prototype.remove = function () {
        var what, a = arguments, L = a.length, ax;
        while (L && this.length) {
            what = a[--L];
            while ((ax = this.indexOf(what)) !== -1) {
                this.splice(ax, 1);
            }
        }
        return this;
    };

    var result_trade = JSON.parse('{!! json_encode($result_trade) !!}');
    $('#public-items').on('focus', '#item_id', function (e) {
        var usedItems = [];
        var _el = $(e.target).closest(".block");
        var item_id = $(_el).find("#item_id");
        var dataId = $(_el).attr('data-id');
        var option = '<option value="">-- Chọn mã ấn phẩm --</option>';
        $(".block").each(function (key, value) {
            var item_id_code = $(value).find('select#item_id option:selected').val();
            if (!item_id_code) {
                return;
            }
            usedItems.push(item_id_code);
            //console.log(usedItems)
        })
        var currentName = $(_el).find('[name="item_id"]').val();
        //console.log(currentName)
        if (currentName) {
            usedItems.remove(currentName);
        }
        //console.log(usedItems)
        $.each(result_trade, function (key, value) {
            if (!usedItems.includes(value['item_id'])) {
                option += '<option value="' + value['item_id'] + '">' + value['item_id'] + '</option>';
                $(item_id).html(option)
            }
        });
    });

    $('#public-items').on('change','#item_id', function (e) {
        var _el = $(e.target).closest(".block");
        var item_id = $(_el).find("#item_id").val()
        var formData = new FormData();
        formData.append('item_id', item_id)
        $.ajax({
            url: '{{route('viewcpanel::trade.publication.find_one_trade')}}',
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
                        $(_el).find("#specification").val(data.data.detail.specification)
                        $(_el).find("#name").val(data.data.detail.name)
                        $(_el).find("#type").val(data.data.detail.type)
                        $(_el).find("#price").val(data.data.detail.price)
                    if (data.data.path){
                        let imgs = $(_el).find("#image_detail");
                        let img = "";
                        let dataId = $(_el).attr('data-id');
                        let img_public = '<img style="filter: brightness(50%);" src="'+data.data.path[0]+'" alt="" data-fancybox-trigger="gallery-'+dataId+'" class="underline cursor-pointer">';
                        img_public+= '<div class="images" style="display:none">';
                        $.each(data.data.path,function (key,value) {
                            img_public += '<a data-fancybox="gallery-'+dataId+'" href="'+value+'">' +
                                          '<img class="rounded" src="'+value+'"/></a>';
                        });
                        img_public += '</div><h5 data-fancybox-trigger="gallery-' + dataId + '" class="underline cursor-pointer xt" style="color: white;font-weight: 500;font-size: 30px">' +
                                            data.data.path.length + '+' + '</h5>';
                        $(imgs).html(img_public);
                    }
                } else {
                    $('#errorModal').modal('show');
                    $('.msg_error').text(data.msg);
                }
            },
            error: function (data) {
                $(".theloading").hide();
            }
        })
    });

    $('#public-items').on('keyup','.total , .money_publications',function (e) {
        var _el = $(e.target).closest(".block");
        var total = $(_el).find("#total").val()
        var money_publications = $(_el).find("#money_publications").val()
        money_publications = Number(money_publications.replace(/[^0-9.-]+/g,""));
         let moneyTotal = _el.find('#money_total');
         var sum_money_publications = $("input[name='sum_money_publications']").val()
         var sum_money_public_and_total = total * parseInt(money_publications)
        console.log(sum_money_public_and_total)
        $(moneyTotal).val(addCommas(sum_money_public_and_total.toString()));
        var sum = 0;
        $("[name='money_total']").each(function (index, value) {
            console.log($(value).val())
            let money = $(value).val();
            if (money != 0)
            sum += parseInt(money.replace(/,/g, ""));
            console.log(sum)
        });
        $("#sum_money_publications").val(addCommas(sum.toString()))
    });
// const id = $id;
    $("#save_publications").click(function (event) {
        event.preventDefault();
        $('.invalid').remove();
        $('.border-red').removeClass('border-red');
        var data = {
            supplier: $(" input[name='supplier']").val(),
            other_costs: $("input[name='other_costs']").val(),
            date_acceptance: $("input[name='date_acceptance']").val(),
            date_order: $("input[name='date_order']").val(),
            sum_item_id: $("input[name='sum_item_id']").val(),
            sum_money_publications: $("input[name='sum_money_publications']").val(),
            sum_total: $("input[name='totals']").val(),
            lead_publications: []
        }
        var countBlock = 0;
        $(".block").each(function (key, value) {
            var block = $(value);
            block.attr('data-id', countBlock);
            var item_id = block.find("[name='item_id']").val()
            var money_publications = block.find("[name='money_publications']").val()
            var name_publications = block.find("[name='name']").val()
            var specification = block.find("[name='specification']").val()
            var total = block.find("[name='total']").val()
            var type = block.find("[name='type']").val();
            var price = block.find("[name='price']").val();
            var path = [];
            image = $(value).find('.images > a > img');
            $.each(image, function (k, v) {
                console.log(v);
                var url = $(v).attr('src');
                console.log(url);
                path.push(url);
            });
            var lead_publications = {
                item_id: item_id,
                money_publications: money_publications,
                name_publications: name_publications,
                specification: specification,
                total: total,
                type: type,
                price: price,
                image_detail: path
            }
            data.lead_publications[countBlock] = lead_publications;
            countBlock++;
        });
        //console.log(data)
        $.ajax({
            url: '{{route('viewcpanel::trade.publication.create')}}',
            headers: {
                "Content-Type": "application/json",
                 Accept: "application/json",
                'x-csrf-token': csrf
            },
            type: "POST",
            data: JSON.stringify(data),
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: function () {
                $(".theloading").show();
            },
            success: function (data) {
                $(".theloading").hide();
                if (data.status == 200) {
                    var idDetail = data.data.data._id
                    var url = '{{route('viewcpanel::trade.publication.detail_publication',['id' => ':id'])}}'
                    url = url.replace(':id', idDetail)
                    $('#successModal').modal('show');
                    $('.msg_success').text(data.message);
                    window.scrollTo(0, 0);
                    setTimeout(function () {
                         window.location.href=url;
                    }, 1000);
                } else {
                    //$('#errorModal').modal('show');
                    $('.msg_error').text(data.message);
                    if (data.errors) {
                        $.each(data.errors, function (key, value) {
                            let splitKey = key.split(".");
                            let el = $("[name='" + splitKey[0] + "']");
                            if (splitKey.length > 2) {
                                let block = $('[data-id="' + splitKey[1] + '"]');
                                el = block.find("[name='" + splitKey[2] + "']");
                            }
                            if (el.attr('name') == 'supplier' || el.attr('name') == 'other_costs' || el.attr('name') == 'date_acceptance' || el.attr('name') == 'date_order') {
                                el.addClass('border-red');
                                el.after('<span class="invalid">' + value[0] + '</span>');
                            } else {
                                el.addClass('border-red');
                                el.after('<span class="invalid">' + value[0] + '</span>');
                            }
                        });
                    }
                }
            },
            error: function (data) {
                console.log(data);
                $(".theloading").hide();
                alert('có lỗi xảy ra')
                window.scrollTo(0, 0);
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
            }
        })
    });

    var countBlock = 1;
    $("#moreButton").on("click",function () {
        let el = $("#appendEl").clone();
        el.removeClass("hidden");
        el.addClass("block");
        el.attr("id", "block");
        el.attr("data-id", countBlock++);
        $("#appendEl").before(el);
        var countRemo = $('.removeButton').length;
        console.log(countRemo)
        if(countRemo >= 2){
            $('.removeButton').attr('hidden',false);
        }
    });

    // function myFunction(el) {
    //     // $(el).parent().closest('.public-items').remove();
    // }

    $("#public-items").on("click", ".removeButton", function (e) {
        var countRemo = $('.removeButton').length;
        if(countRemo <= 3){
            $('.removeButton').attr('hidden',true);
        }
        let _el = $(e.target).closest(".block");
        $(_el).remove();
        var sum = 0
        var sum1 = 0
        if ($("[name='total']").empty()) {
            $("[name='total']").each(function (index, value) {
                if ($(value).val() != "")
                    sum += parseInt($(value).val());
            });
            $("#totals").val(sum)
        }
        if ($("[name='money_total']").empty()) {
            $("[name='money_total']").each(function (index, value) {
                var sumMoney = $(value).val();
                if (sumMoney != 0)
                    sum1 += parseInt(sumMoney.replace(/,/g, ""));
            });
            $("#sum_money_publications").val(addCommas(sum1.toString()))
        }
        if ($("[name = 'item_id']")){
            var sumItemId = $("[name='item_id']").length -1
            $("#sum_item_id").val(sumItemId)
        }
    });

    $("#public-items").on('keyup','.total , .money_publications,#item_id', function (e) {
        var _el = $(e.target).closest(".block");
        var total = $(_el).find("#total").val()
        var money_publications = $(_el).find("#money_publications").val()
        var totals = $("input[name='totals']").val()
        var sum_money_publications = $("input[name='sum_money_publications']").val()
        var sum_item_id = $("input[name='sum_item_id']").val()
        var sum = 0
        var sum1 = 0
        if ($("[name='total']").empty()) {
            $("[name='total']").each(function (index, value) {
                if ($(value).val() != "")
                    sum += parseInt($(value).val());
            });
            $("#totals").val(sum)
        }
        var sumItemId = $("[name='item_id']").length -1
        $("#sum_item_id").val(sumItemId)
    })

    function addCommas(str) {
        return str.replace(/^0+/, '').replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    $('#public-items').on('keyup', function (event) {
        var _el = $(event.target).closest(".block");
        var money_publications = $(_el).find("#money_publications").val();
        $(_el).find("#money_publications").val(addCommas(money_publications))
    })

    $('#other_costs').on('keyup', function (event) {
        var other_costs = $("input[name='other_costs']").val()
        $('#other_costs').val(addCommas(other_costs))
    })

    $("#save_public_status_order").click(function (event) {
        event.preventDefault();
        $('.invalid').remove();
        $('.border-red').removeClass('border-red');
        var data = {
            supplier: $(" input[name='supplier']").val(),
            other_costs: $("input[name='other_costs']").val(),
            date_acceptance: $("input[name='date_acceptance']").val(),
            date_order: $("input[name='date_order']").val(),
            sum_item_id: $("input[name='sum_item_id']").val(),
            sum_money_publications: $("input[name='sum_money_publications']").val(),
            sum_total: $("input[name='totals']").val(),
            lead_publications: []
        }
        var countBlock = 0;
        $(".block").each(function (key, value) {
            var block = $(value);
            block.attr('data-id', countBlock);
            var item_id = block.find("[name='item_id']").val()
            var money_publications = block.find("[name='money_publications']").val()
            var name_publications = block.find("[name='name']").val()
            var specification = block.find("[name='specification']").val()
            var total = block.find("[name='total']").val()
            var type = block.find("[name='type']").val();
            var price = block.find("[name='price']").val();
            var path = [];
            image = $(value).find('.images > a > img');
            $.each(image, function (k, v) {
                console.log(v);
                var url = $(v).attr('src');
                console.log(url);
                path.push(url);
            });
            var lead_publications = {
                item_id: item_id,
                money_publications: money_publications,
                name_publications: name_publications,
                specification: specification,
                total: total,
                type: type,
                price: price,
                image_detail: path
            }
            data.lead_publications[countBlock] = lead_publications;
            countBlock++;
        });
        console.log(data)
        $.ajax({
            url: '{{route('viewcpanel::trade.publication.create_public_status_order')}}',
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                'x-csrf-token': csrf
            },
            type: "POST",
            data: JSON.stringify(data),
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: function () {
                $(".theloading").show();
            },
            success: function (data) {
                $(".theloading").hide();
                if (data.status == 200) {
                    var idDetailOrder = data.data._id
                    var urlOrder = '{{route('viewcpanel::trade.publication.detail_publication',['id' => ':id'])}}'
                    urlOrder = urlOrder.replace(':id', idDetailOrder)
                    $('#successModal').modal('show');
                    $('.msg_success').text(data.message);
                    window.scrollTo(0, 0);
                    setTimeout(function () {
                       window.location.href= urlOrder;
                    }, 1000);
                } else {
                    //$('#errorModal').modal('show');
                    $('.msg_error').text(data.message);
                    if (data.errors) {
                        $.each(data.errors, function (key, value) {
                            let splitKey = key.split(".");
                            let el = $("[name='" + splitKey[0] + "']");
                            if (splitKey.length > 2) {
                                let block = $('[data-id="' + splitKey[1] + '"]');
                                el = block.find("[name='" + splitKey[2] + "']");
                            }
                            if (el.attr('name') == 'supplier' || el.attr('name') == 'other_costs' || el.attr('name') == 'date_acceptance' || el.attr('name') == 'date_order') {
                                el.addClass('border-red');
                                el.after('<span class="invalid">' + value[0] + '</span>');
                            } else {
                                el.addClass('border-red');
                                el.after('<span class="invalid">' + value[0] + '</span>');
                            }
                        });
                    }
                }
            },
            error: function (data) {
                console.log(data);
                $(".theloading").hide();
                alert('có lỗi xảy ra')
                window.scrollTo(0, 0);
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            }
        })
    });

    $('#import_baddebt').on('click',function (e) {
            e.preventDefault();
       let xls = ['application/vnd.ms-excel', 'application/msexcel', 'application/x-msexcel', 'application/x-ms-excel', 'application/x-excel', 'application/x-dos_ms_excel', 'application/xls', 'application/x-xls', 'application/excel', 'application/download', 'application/vnd.ms-office', 'application/msword','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip', 'application/vnd.ms-excel', 'application/msword', 'application/x-zip'];
       let upload_file = $("input[name='upload_file']");
       let fileToUpload = upload_file[0].files[0];
       let formData = new FormData();
       formData.append('upload_file' ,fileToUpload)
        console.log(upload_file)
        $.ajax({
            enctype: 'multipart/form-data',
            url: '{{route('viewcpanel::trade.publication.importExcel')}}',
            headers: {
                'x-csrf-token': csrf
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
                if (data.status == 200) {
                    $('#successModal').modal('show');
                    $('.msg_success').text(data.message);
                    window.scrollTo(0, 0);
                    setTimeout(function () {
                        window.location.href='{{route('viewcpanel::trade.publication.list')}}';
                    }, 1000);
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




});
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

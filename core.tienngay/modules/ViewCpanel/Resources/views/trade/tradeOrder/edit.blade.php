@extends('viewcpanel::layouts.master')

@section('title', 'Chỉnh sửa yêu cầu ấn phẩm')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/css/bootstrap-multiselect.min.css" integrity="sha512-fZNmykQ6RlCyzGl9he+ScLrlU0LWeaR6MO/Kq9lelfXOw54O63gizFMSD5fVgZvU1YfDIc6mxom5n60qJ1nCrQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
<style>
    body {
        font-family: Roboto;
        background-color: #EDEDED;
        margin: 0px 20px;
    }

    .row-content3 {
        border: 1px solid #F0F0F0;
        border-radius: 10px;
        margin: 0 0 16px 0;
    }

    .content {
        display: flex;
        justify-content: space-between;
    }

    .TitleH1 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
    }

    .report {
        color: #676767;
        font-size: 12px;
        margin-bottom: 34px;
    }

    /* content1 */
    .content1 {
        margin-top: 24px;
    }

    .titleH2 {
        font-size: 16px;
        font-weight: 600;
    }

    .label-text {
        font-size: 14px;
        margin: 6px 0 2px 0;
    }

    .span-color {
        color: red
    }

    .content1-input {
        padding: 9px 16px;
        border-radius: 5px;
        font-size: 14px;
        width: 100%;
        border: 1px solid #D8D8D8;
        padding-top: 8px;
        color: #676767;
    }

    /* .content1-input1 {
        background-color: #D8D8D8;
        padding: 5px 16px;
        border-radius: 5px;
        font-size: 14px;
        width: 100%;
        border: none;
        padding-top: 8px;
        color: #676767;
    } */

    .text-link {
        color: #4299E1
    }

    .text-color::placeholder {
        color: #1D9752;
        font-weight: bold;
    }

    .outline {
        outline: none;
    }

    .multiselect-selected-text{
        color: #676767
    }

    /* content3 */
    .content3 {
        margin-top: 24px;
    }

    .content1,
    .content3 {
        background: #FFFFFF;
        padding: 24px 16px;
        border-radius: 10px;
    }

    .content3-title {
        display: flex;
        justify-content: space-between;
    }

    .titleH3 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 16px;
    }

    .content3-div {
        color: #676767;
    }

    .content2-div-1 {
        width: 100%;
    }

    .content2-h4 {
        font-size: 14px;
        margin: 10px 0 6px 0 ;
    }

    .image img {
        max-width: 100%;
        height: 320px;
    }

    .content2-input {
        background-color: #D8D8D8;
        padding: 5px 16px 8px 16px;
        border-radius: 5px;
        font-size: 14px;
        width: 100%;
        border: none;
        padding-top: 8px
    }

    .height {
        min-height: 100px;
    }

    .input-text {
        width: 100%;
        border: none;
        outline: none;
    }

    .btn-width {
        height: 10%;
        white-space: nowrap;
        padding: 0 30px;
    }

    .tea {
        width: 100%;
        padding: 5px 16px;
        outline: none;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
        color: #676767
    }

    .content3-btn {
        display: flex;
        justify-content: end;
    }

    .content5 {
        display: flex;
        justify-content: space-between;
    }

    .btnnn {
        padding: 8px 50px;
        font-size: 14px;
        height:40px
    }

    .btn-danger{
        border: 1px solid #F4CDCD;
        background: #F4CDCD;
        color: #C70404;
        margin-left: 20px;
        font-weight: 600;
    }

    .bgr {
        background-color: #F4CDCD;
        color: #C70404;
        font-weight: 600;
    }

    .bgr:hover {
        background-color: #F4CDCD;
        color: #C70404;
    }

    .modal-header {
        border-bottom: none;
        margin: 0 auto;
        padding-bottom: 6px;
        font-weight: bold;
    }

    .modal-body {
        padding-top: 0px;
        text-align: center;
    }

    .modal-footer {
        border-top: none;
    }

    .modal-title {
        font-weight: bold;
    }

    .btn-cancel {
        background-color: #D8D8D8;
        outline: none;
        border: none;
        width: 49%;
        padding: 12px 0;
        font-size: 14px;
        border-radius: 5px;
    }

    .btn-submit {
        background-color: #1D9752;
        outline: none;
        border: none;
        width: 49%;
        padding: 12px 0;
        color: #FFFFFF;
        font-size: 14px;
        border-radius: 5px;
    }

    @media screen and (max-width:48em) {
        .btnnn {
            padding: 4px 12px
        }
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
    .image {
        position: relative;
        width: 285px;
        height: 315px;
    }
    .xt{
        color: black;
        position: absolute; 
        top: 50%;
        left: 50%;
        background-color: rgba(255, 255, 255, 0.2);
    }
     .card-body {
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
        border-radius: 8px;
    }

    .card-body h6 {
        color: #3B3B3B;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        padding: 16px;
        margin: 0px;
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
        .timeline .event {
            padding-top: 30px;
        }
        .timeline .event:after {
            left: -31.8px;
        }
    }

    .timeline .event {
        padding-bottom: 25px;
        margin-bottom: 25px;
        position: relative;
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
    .form-control:disabled, .form-select:disabled, textarea:disabled {
        background-color: #E6E6E6 !important;
        border: 1px solid #D8D8D8 !important;
        color: #676767 !important;
    }
    button:disabled {
        background-color: #f7f8f9 !important;
        color: #676767 !important;
    }
    .btnn-prev {
        background-color: #D8D8D8;
        border: 1px solid #D2EADC;
        outline: none;
        color: #676767;
        border-radius: 5px;
        font-size: 14px;
        padding: 8px 16px;
        margin-right: 16px;
        margin-bottom: 10px;
    }

    .btnn-submit {
        background-color: #1D9752;
        border: 1px solid #1D9752;
        outline: none;
        color: white;
        border-radius: 5px;
        font-size: 14px;
        padding: 8px 16px;
        margin-right: 16px;
    }

    .btnn-cancel {
        background-color: #F4CDCD;
        border: 1px solid #F4CDCD;
        outline: none;
        color: #C70404;
        border-radius: 5px;
        font-size: 14px;
        padding: 8px 16px;
        margin-right: 16px;
    }

    .distance {
        padding-left: 4px;
    }

    .height-input{
        height:40px;
        color: #676767;
        font-size: 14px;
    }
    .delete{
        font-size: 14px;
        color:#C70404;
        font-weight: 600;
        margin-bottom: 10px;
    }
    .btn-outline-success{
        color: #1D9752;
        border-color:#1D9752;
        font-weight: 600;
    }
    .btn-success{
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<div id="loading" class="theloading hidden">
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
</div>
<div class="content flex-column flex-sm-row" style="margin-top: 20px;">
    <div class="content-title">
        <h1 class="TitleH1">Chỉnh sửa yêu cầu ấn phẩm</h1>
        
    </div>
</div>
<div class="content1">
    <h2 class="titleH2">Thông tin chung </h2>
    <div class="row">
        <div class="col-md-4 col-xs-12 col-sm-6">
            <div class="content2-div-1">
                <label class="label-text">Tên kế hoạch <span class="span-color">*</span> </label>
                <input id="plan-name" class="form-control height-input" type="text"
                    placeholder="Nhập" name="plan_name" value="{{$tradeOrder['plan_name']}}">
            </div>
        </div>
        <div class="col-md-4 col-xs-12 col-sm-6">
            <div class="content2-div-1">
                <label class="label-text">Chi Tiết kế hoạch Trade MKT <span class="span-color">*</span> </label>
                <div class="content1-input d-flex justify-content-between align-items-center height-input">
                    <a id="rootupload" style="color: #000; width: 100%;">Tải file mới</a>
                    <input id="uploadPlan" style="width: 100%; display: none;" class="icon text-link" type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                    <i class="fa fa-upload icon" aria-hidden="true"></i>
                    <input class="icon text-link" value="{{$tradeOrder['plan_file']}}" type="hidden" name="plan_file">
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xs-12 col-sm-6">
            <div class="content2-div-1">
                <label class="label-text">Mục tiêu thúc đẩy <span class="span-color">*</span></label>
                <select id="motivating-goals" name="motivating_goal" class="form-select">
                    @foreach($motivatingGoals as $key => $value)
                        @if (in_array($key, $tradeOrder['motivating_goal']))
                        <option value="{{$key}}" selected>{{$value}}</option>
                        @else
                        <option value="{{$key}}">{{$value}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4 col-xs-12 col-sm-6">
            <div class="content2-div-1">
                <label class="label-text">Phòng giao dịch</label>
                <select id="stores" class="form-select height-input" name="store_id">
                    <option value="">-- Chọn phòng giao dịch --</option>
                    @foreach($stores as $key => $value)
                        @if ($tradeOrder['store_id'] == $value['_id'])
                        <option value="{{$value['_id']}}" selected>{{$value['name']}}</option>
                        @else
                        <option value="{{$value['_id']}}">{{$value['name']}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4 col-xs-12 col-sm-6">
            <div class="content2-div-1">
                <label class="label-text">Người tạo</label>
                <input id="created_by" class="form-control height-input" type="text"
                    placeholder="Nhập" name="created_by" value="{{$tradeOrder['created_by']}}" disabled>
            </div>
        </div>
        <div class="col-md-4 col-xs-12 col-sm-6">
            <div class="content2-div-1">
                <label class="label-text">Ngày tạo</label>
                <input id="created_at" class="form-control height-input" type="text"
                    placeholder="Nhập" name="created_at" value="{{date('d-m-Y', $tradeOrder['created_at'])}}" disabled>
            </div>
        </div>
        <div class="col-md-4 col-xs-12 col-sm-6">
            <div class="content2-div-1">
                <label class="label-text">Trạng thái</label>
                <input id="statusLabel" class="form-control height-input" type="text" style="color: #1D9752 !important; font-weight: 600;" 
                    placeholder="Nhập" name="statusLabel" value="{{$statusLabel}}" disabled>
            </div>
        </div>
    </div>
</div>
<div class="content3">
    <div class="content3-title">
        <h2 class="titleH3">Danh sách ấn phẩm yêu cầu </h2>
        <i class="fa fa-angle-up" aria-hidden="true"></i>
    </div>
    <div id="trade-items" class="content3-div">
        @foreach($tradeOrder['items'] as $key => $item)
        <div class="row row-content3 shadow-sm mb-4 bg-white rounded block" data-id="{{$item['key']}}">
            <div class="col-md-9 col-xs-12 col-sm-12">
                <div class="row">
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Hạng mục <span class="span-color">*</span></h4>
                        <select id="category" class="form-select category height-input" name="category">
                            <option value="">-- Chọn hạng mục --</option>
                            @foreach($categories as $key => $value)
                                @if ($item['category'] == $key)
                                <option value="{{$key}}" selected>{{$value}}</option>
                                @else
                                <option value="{{$key}}">{{$value}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Mục tiêu triển khai <span class="span-color">*</span></h4>
                        <select id="implementationGoals" class="form-select implementationGoals height-input" name="implementation_goal" >
                            <option value="">-- Chọn mục tiêu triển khai --</option>
                            @foreach($implementationGoals as $key => $value)
                                @if ($item['implementation_goal'] == $key)
                                <option value="{{$key}}" selected>{{$value}}</option>
                                @else
                                <option value="{{$key}}">{{$value}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <h4 class="content2-h4">Tên ấn phẩm <span class="span-color">*</span></h4>
                        <select id="trade-item-name" class="form-select trade-item-name height-input" name="item_id" >
                            <option value=""></option>
                            @foreach($items as $key => $tradeItem)
                            @if(in_array($item['category'], (array)$tradeItem['category']) && in_array($item['implementation_goal'], (array)$tradeItem['target_goal']))
                            <option data-type="{{$tradeItem['detail']['type']}}" data-spec="{{$tradeItem['detail']['specification']}}" data-path={{json_encode($tradeItem['path'])}} value="{{$tradeItem['_id']}}" 
                            @if($tradeItem['_id'] == $item['item_id']) selected @endif
                            >{{$tradeItem['detail']['name'] . ' - ' . $tradeItem['detail']['type'] . ' - ' . $tradeItem['detail']['specification']}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6 hidden">
                        <h4 class="content2-h4">Loại ấn phẩm <span class="span-color">*</span></h4>
                        <select id="trade-type" class="form-select trade-type height-input" name="item_type" >
                            <option value="">-- Chọn loại ấn phẩm --</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-12 col-sm-6 hidden">
                        <h4 class="content2-h4">Quy cách <span class="span-color">*</span></h4>
                        <select id="trade-spec" class="form-select trade-spec height-input" name="item_specifications" >
                            <option value="">-- Chọn quy cách --</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Số lượng <span class="span-color">*</span></h4>
                        <input type="text " class="form-control height-input" placeholder="1000" name="item_quantity" value="{{$item['item_quantity']}}" >
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Mục tiêu khách hàng <span class="span-color">*</span></h4>
                         <input type="text " class="form-control height-input" placeholder="Nhập" name="item_target_customers" value="{{$item['item_target_customers']}}" >
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <h4 class="content2-h4">Khu vực triển khai <span class="span-color">*</span></h4>
                        <textarea name="item_area" class="form-control tea" rows="4" placeholder="Khu vực chợ Nhổn" >{{$item['item_area']}}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 col-sm-12">
                <div class="">
                    <h4 class="content2-h4">Ảnh mô tả</h4>
                </div>
                <div class="d-flex image">
                    @if(count($item['item_path']) > 0)
                    <!-- <span data-fancybox-trigger="gallery" class="underline cursor-pointer">an example</span> -->
                    <img src="{{$item['item_path'][0]}}" alt="" data-fancybox-trigger="gallery-{{$item['key']}}" class="underline cursor-pointer">
                    <div style="display:none">
                        @foreach($item['item_path'] as $path)
                        <a data-fancybox="gallery-{{$item['key']}}" href="{{$path}}">
                            <img class="rounded" src="{{$path}}" />
                        </a>
                        @endforeach
                    </div>
                    <h5 data-fancybox-trigger="gallery-{{$item['key']}}" class="underline cursor-pointer xt">+5</h5>
                    @endif
                </div>
            </div>
            <div class="col-md-12 col-xs-12 col-sm-12" style="text-align: right;">
                <button id="removeBlock" type="button" class="btn removeBlock"><span style="display:flex; align-items: center" class="delete btn btn-danger btnnn" aria-hidden="true">Xóa ấn phẩm</span></button>
            </div>
        </div>
        @endforeach
        <div id="appendEl" class="row row-content3 shadow-sm p-3 mb-4 bg-white rounded hidden">
            <div class="col-md-9 col-xs-12 col-sm-12">
                <div class="row">
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Hạng mục <span class="span-color">*</span></h4>
                        <select id="category" class="form-select category height-input" name="category">
                            <option value="">-- Chọn hạng mục --</option>
                            @foreach($categories as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Mục tiêu triển khai <span class="span-color">*</span></h4>
                        <select id="implementationGoals" class="form-select implementationGoals height-input" name="implementation_goal">
                            <option value="">-- Chọn mục tiêu triển khai --</option>
                            @foreach($implementationGoals as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <h4 class="content2-h4">Tên ấn phẩm <span class="span-color">*</span></h4>
                        <select id="trade-item-name" class="form-select trade-item-name height-input" name="item_id">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6" hidden>
                        <h4 class="content2-h4">Loại ấn phẩm <span class="span-color">*</span></h4>
                        <select id="trade-type" class="form-select trade-type height-input" name="item_type">
                            <option value="">-- Chọn loại ấn phẩm --</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-12 col-sm-6" hidden>
                        <h4 class="content2-h4">Quy cách <span class="span-color">*</span></h4>
                        <select id="trade-spec" class="form-select trade-spec height-input" name="item_specifications">
                            <option value="">-- Chọn quy cách --</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Số lượng <span class="span-color">*</span></h4>
                        <input type="text " class="content1-input outline height-input" placeholder="Nhập" name="item_quantity">
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Mục tiêu khách hàng <span class="span-color">*</span></h4>
                        <input type="text " class="content1-input outline height-input" placeholder="Nhập" name="item_target_customers">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <h4 class="content2-h4">Khu vực triển khai <span class="span-color">*</span></h4>
                        <textarea class="tea" name="item_area" id="" cols="" rows="4" placeholder="Nhập"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 col-sm-12">
                <div class="">
                    <h4 class="content2-h4">Ảnh mô tả</h4>
                </div>
                <div class="d-flex image">
                    <img src="" alt="">
                </div>
            </div>
            <div class="col-md-12 col-xs-12 col-sm-12" style="text-align: right;">
                <button id="removeBlock" type="button" class="btn removeBlock"><span style="display:flex; align-items: center" class="delete btn btn-danger btnnn" aria-hidden="true">Xóa ấn phẩm</span></button>
            </div>
        </div>
    </div>
    <div class="content3-btn">
        <button id="appendBlock" type="button" class="btn btn-outline-success btnnn">Thêm ấn phẩm</button>
    </div>
</div>
<div class="content5 mt-4 mb-5">
    <div>
        <button id="saveRequest" type="button" class="btn btn-success btnnn mr-4">Lưu</button>
        <button id="cancelRequest" type="button" class="btn btn-danger btnnn">Hủy</button>
    </div>
    <button id="approveRequest" type="button" class="btn btn-success btnnn" data-toggle="modal" data-target="#exampleModal">Gửi duyệt</button>
</div>

<!-- Log view -->
<!-- <div class="history">
    <div class="card-body">
        <h6 class="card-title">Lịch sử</h6>
        <div id="content">
            <ul class="timeline">
                @for($i = count($tradeOrder['logs']) - 1; $i >= 0; $i--)
                <li class="event">
                    <h3>{{$tradeOrder['logs'][$i]['action_label']}}</h3>
                    <span>{{date('H:i:s d-m-Y', $tradeOrder['logs'][$i]['created_at'])}}</span>
                    <label>{{$tradeOrder['logs'][$i]['created_by'] }}</label>
                    <label>{{$tradeOrder['logs'][$i]['status_label']}}</label>
                </li>
                @endfor
            </ul>
        </div>
    </div>
</div> -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" style="height: auto !important;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Gửi đề xuất</h5>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn gửi đề xuất danh sách ấn phẩm này?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-submit">Đồng ý</button>
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
          <p class="msg_success"></p>
        </div>
        <div class="modal-footer">

        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
<script type="text/javascript">
Array.prototype.remove = function() {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};
</script>
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
<script type="text/javascript" src="{{ asset('viewcpanel/js/autocomplete.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script type="text/javascript">
    const csrf = "{{ csrf_token() }}";
    $(document).ready(function() {
        // $('#motivating-goals').multiselect({
        //     templates: {
        //         button: '<button style="background: #FFFFFF;border: 1px solid #D8D8D8;border-radius: 5px;outline: none;padding: 0px 5px;color:black;" type="button" class="multiselect dropdown-toggle button_target_goal" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span></button>'
        //     },
        //     // enableFiltering: true,
        // });
        var items = @json($items);
        // console.log(items);

        // Fetch trade item from api
        const getTradeItems = async (data) => {
            const response = await fetch('{{$getItemsByStoreId}}', {
                method: 'POST',
                body: JSON.stringify(data), // string or object
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    'x-csrf-token': csrf
                }
            });
            const responseJson = await response.json(); //extract JSON from the http response
            if (responseJson['status'] == 200) {
                let tradeItems = responseJson['data'];
                items = tradeItems;
                console.log(items);
            }
        }
        $("#stores").on('change', function(){
            const storeId = $(this).val();
            const formData = {store_id: storeId};
            console.log(formData);
            getTradeItems(formData);
            $(".trade-item-name").html('<option value=""></option>');
            $(".category").val("");
            $(".implementationGoals").val("");
        });

        const OptionItemNameHandle = (e) => {
            let _el = $(e.target).closest(".block");
            let categoryEl = $(_el).find("#category");
            let implementationGoalsEl = $(_el).find("#implementationGoals");
            let _category = $(categoryEl).val();
            let _implementationGoal = $(implementationGoalsEl).val();
            let _motivatingGoals = $("#motivating-goals").val();
            let targetEl = $(_el).find("#trade-item-name");
            let option = '<option value=""></option>';
            let usedItems = [];
            $(".block").each(function(index, value){
                let usedItem = $(value).find('#trade-item-name').find(":selected").val();
                if (!usedItem) {
                    return;
                }
                usedItems.push(usedItem);
            });
            let currentName = $(_el).find('#trade-item-name').find(":selected").val();
            if (currentName && usedItems.length > 0) {
                usedItems.remove(currentName);
            }
            for (let i = 0; i < items.length; i++) {
                let existsCategory = _category == items[i]['category'];
                let existsImplementationGoal = _implementationGoal == items[i]['target_goal'];
                let existsMotivatingGoals = items[i]['motivating_goal'].includes(_motivatingGoals);
                if ( existsCategory && existsImplementationGoal && !usedItems.includes(items[i]['_id']) && existsMotivatingGoals) {
                    let _tradeId = items[i]['_id'];
                    let _tradeType = items[i]['detail']['type'];
                    let _tradeName = items[i]['detail']['name'];
                    let _tradePath = JSON.stringify(items[i]['path']);
                    let _tradeSpec = items[i]['detail']['specification'];
                    option += '<option data-type="'+_tradeType+'" data-spec="'+_tradeSpec+'" data-path='+_tradePath+' value="' + _tradeId + '">' + _tradeName + ' - ' + _tradeType + ' - ' + _tradeSpec + '</option>';
                }

            }
            $(_el).find("#trade-type").html('<option value="">-- Chọn loại ấn phẩm --</option>');
            $(_el).find("#trade-spec").html('<option value="">-- Chọn quy cách --</option>');
            $(targetEl).html(option)
        }
        $("#trade-items").on("change", ".implementationGoals, .category", function(e){
            OptionItemNameHandle(e);
        });
        $("#trade-items").on("focus", ".trade-item-name", function(e){
            OptionItemNameHandle(e);
        });
        $("#motivating-goals").on("change", function(e){
            $(".implementationGoals").trigger('change');
        });

        $("#trade-items").on("change", ".trade-item-name", function(e) {
            let _el = $(e.target).closest(".block");
            if (_el == undefined || !_el || _el.length < 1) {
                return;
            }
            let tradeTypeEl = $(_el).find("#trade-type");
            let tradeSpecEl = $(_el).find("#trade-spec");
            let tradePathEl = $(_el).find(".image");

            let _tradeType = $(e.target).find(":selected").attr("data-type");
            let _tradeSpec = $(e.target).find(":selected").attr("data-spec");
            console.log($(e.target).find(":selected").attr("data-path"));
            let _tradePath = JSON.parse($(e.target).find(":selected").attr("data-path"));
            console.log(_tradePath);
            let optionType = '<option value="'+_tradeType+'" selected>'+_tradeType+'</option>';
            let optionSpec = '<option value="'+_tradeSpec+'" selected>'+_tradeSpec+'</option>';
            let dataId = $(_el).attr('data-id');
            let optionPath = '<img style="width: 100%; height: auto;" src="'+_tradePath[0]+'" alt="" data-fancybox-trigger="gallery-'+dataId+'" class="underline cursor-pointer">';
            optionPath+= '<div style="display:none">';
            for(let i = 0; i < _tradePath.length; i++) {
                optionPath += '<a data-fancybox="gallery-'+dataId+'" href="'+_tradePath[i]+'"><img class="rounded" src="'+_tradePath[i]+'"/></a>';
            }
            optionPath+= '</div><h5 data-fancybox-trigger="gallery-'+dataId+'" class="underline cursor-pointer xt">+'+_tradePath.length+'</h5>';
            $(tradePathEl).html(optionPath);
            if (_tradeType == undefined || _tradeType == '') {
                $(tradeTypeEl).html('<option value="">-- Chọn loại ấn phẩm --</option>');
            } else {
                $(tradeTypeEl).html(optionType);
            }
            if (_tradeSpec == undefined || _tradeSpec == '') {
                $(tradeSpecEl).html('<option value="">-- Chọn quy cách --</option>');
            } else {
                $(tradeSpecEl).html(optionSpec)
            }
        });
        $("#trade-items .trade-item-name").trigger('change');

        $("#appendBlock").on("click", function(){
            let el = $("#appendEl").clone();
            el.removeClass("hidden");
            el.addClass("block");
            el.attr("id", "block");
            $("#appendEl").before(el);
        });

        $("#trade-items").on("click", ".removeBlock", function(e){
            let _el = $(e.target).closest(".block");
            $(_el).remove();
        })
    });
</script>
<script type="text/javascript">
    $("#uploadPlan").on('change', function () {
        var file = $(this)[0].files[0];
        console.log(file);
        uploadPlan(file);
    });
    const uploadPlan = async function (file) {
        console.log(file.type);
        let extension = file.name.split('.').pop();
        if (extension !== 'xlsx' && extension !== 'xls') {
            $("#errorModal").find(".msg_error").text("File không đúng định dạng, vui lòng thử lại!");
            $("#errorModal").modal('show');
            return;
        }
        $("#rootupload").text(file.name);
        let formData = new FormData();   
        formData.append("file", file);
        const response = await fetch('{{$urlUpload}}', {
            method: 'POST',
            body: formData,
            headers: {
                'x-csrf-token': csrf
            }
        });
        const responseJson = await response.json(); //extract JSON from the http response
        console.log(responseJson);
        if (responseJson && responseJson.status == 200) {
            $('input[name="plan_file"]').val(responseJson.path);
        } else {
            $("#errorModal").find(".msg_error").text("Upload file thất bại, vui lòng thử lại!");
            $("#errorModal").modal('show');
            return;
        }

    }
</script>
<script type="text/javascript">
    const validateCallback = function(response) {
        $('span.invalid').remove();
        $('.border-red').removeClass('border-red');
        if (response.status == 200) {
            // $("#successModal").find("#redirect-url").attr("href", response.targetUrl);
            $("#successModal").find(".msg_success").text(response.message);
            $("#successModal").modal('show');
            // setTimeout(function(){window.location.href = response.targetUrl;}, 2000); 
            Redirect(response.targetUrl, 2000);
        } else {
            if (response.errors) {
                $.each(response.errors, function(key, value){
                    let splitKey = key.split(".");
                    let el = $("[name='"+splitKey[0]+"']");
                    if (splitKey.length > 2) {
                        let block = $('[data-id="' + splitKey[1] + '"]');
                        el = block.find("[name='"+splitKey[2]+"']");
                    }
                    if (el.attr('name') == 'motivating_goal' || el.attr('name') == 'plan_file') {
                        el.closest('div').addClass('border-red');
                        el.closest('div').after('<span class="invalid">'+value[0]+'</span>');
                    } else {
                        el.addClass('border-red');
                        el.after('<span class="invalid">'+value[0]+'</span>');
                    }
                });
                let itemType = $('.block [name="item_type"]');
                $.each(itemType, function(key, value) {
                    let el = $(itemType[key]);
                    if (el.val() == '' || el.val() == undefined) {
                        el.addClass('border-red');
                        el.after('<span class="invalid">Loại ấn phẩm hông được để trống</span>');
                    }
                });
                let itemSpec = $('.block [name="item_specifications"]');
                $.each(itemSpec, function(key, value) {
                    let el = $(itemSpec[key]);
                    if (el.val() == '' || el.val() == undefined) {
                        el.addClass('border-red');
                        el.after('<span class="invalid">Quy cách ấn phẩm hông được để trống</span>');
                    }
                });
            }
        }
    }
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
    const CollectData = function() {
        let data = {
            store_id : $("#stores").val(),
            plan_name: $("#plan-name").val(),
            motivating_goal: $("#motivating-goals").val() ? [$("#motivating-goals").val()] : [],
            plan_file : $("[name='plan_file']").val(),
            items : {}
        }
        let countBlock = 0;
        $(".block").each(function(index, value){
            let currentTime = Math.round(+new Date()/1000);
            let block = $(value);
            let blockId = block.attr('data-id');
            if (blockId == undefined) {
                block.attr('data-id', (currentTime +''+ countBlock));
                blockId = (currentTime +''+ countBlock);
            }
            let category = block.find("[name='category']").val();
            let implementation_goal = block.find("[name='implementation_goal']").val();
            let item_id = block.find("[name='item_id']").val();
            let item_quantity = block.find("[name='item_quantity']").val();
            let item_area = block.find("[name='item_area']").val();
            let item_target_customers = block.find("[name='item_target_customers']").val();
            let item = {
                data_id: blockId,
                category : category,
                implementation_goal : implementation_goal,
                item_id : item_id,
                item_quantity : item_quantity,
                item_area : item_area,
                item_target_customers : item_target_customers
            }
            console.log(blockId);
            data.items[blockId] = item;
            countBlock++;
        });
        return data;
    }

    $("#saveRequest").on("click", function(e){
        e.preventDefault();
        $("#saveRequest").attr("disabled", "disabled");
        let data = CollectData();
        SaveData(data, '{{$updateUrl}}', validateCallback);
        $("#saveRequest").removeAttr("disabled");
        
    });
    $("#approveRequest").on("click", function(e){
        e.preventDefault();
        $("#approveRequest").attr("disabled", "disabled");
        if (confirm("Hệ thống sẽ gửi yêu cầu đến quản lý trực tiếp để phê duyệt, bạn có muốn tiếp tục gửi duyệt ?")) {
            let data = CollectData();
            data['action'] = 'sentRequest';
            SaveData(data, '{{$updateUrl}}', validateCallback);
        }
        $("#approveRequest").removeAttr("disabled");
    });
    $("#cancelRequest").on("click", function(e){
        e.preventDefault();
        // window.location.href = '{{$indexUrl}}';
        Redirect('{{$indexUrl}}', false);
    });

    $("#rootupload").on("click", function(e) {
        $('#uploadPlan').trigger('click');
        return false;
    })
</script>
@endsection
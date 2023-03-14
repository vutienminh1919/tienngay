@extends('viewcpanel::layouts.master')

@section('title', 'Báo cáo tồn kho PGD')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" rel="stylesheet"/>
    <style>
        .selectize-input div.item + input {
            display: none;
        }

        .is-animated {
            width: 100%;
            height: 1000px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        #main {
            width: 100%;
        }

        .header h3 {
            font-style: normal;
            font-weight: 600;
            font-size: 20px;
            line-height: 24px;
        }

        .header a {
            font-style: normal;
            font-weight: 400;
            font-size: 12px;
            line-height: 14px;
            text-decoration: none;
            color: #676767;
        }

        .form-container {
            width: 100%;
            padding: 24px 16px;
            gap: 24px;
            background: #FFFFFF;
            border: 1px solid #F0F0F0;
            border-radius: 8px;
        }

        .content-title {
            width: 100%;
        }

        .content-item {
            display: flex;
            flex-direction: column;
            margin-top: 12px;
        }

        select:invalid {
            color: gray;
        }

        label {
            font-style: normal;
            font-weight: 400;
            font-size: 14px;
            /*line-height: 16px;*/
            padding-bottom: 12px;
        }

        .content-item input,
        select {
            /* width: 100%; */
            height: 40px;
            background: #FFFFFF;
            border: 1px solid #D8D8D8;
            border-radius: 5px;
            outline: none;
            padding: 0px 5px;
        }

        .content-form-img {
            width: 100%;
            height: 288px;
            background: #FFFFFF;
            border: 1px solid #D8D8D8;
            border-radius: 5px;
            position: relative;
        }

        .content-form-img button {
            position: absolute;
            left: 10;
            bottom: 10px;
        }

        .content-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 12px;
        }

        .item-checkbox {
            display: flex;
            gap: 5px;
        }

        .item-checkbox input {
            height: 20px;
        }

        .multiselect-parent {
            width: 100%;
        }

        .multiselect-parent .dropdown-toggle {
            width: 100%;
        }

        .multiselect-parent .dropdown-menu {
            width: 100%;
        }

        .multiselect-container dropdown-menu show {
            width: 100%;
        }

        input[type="checkbox"] {
            accent-color: #1D9752;
        }

        .form-check-input {
            width: 20px !important;
            height: 20px !important;
        }

        .form-check-input:checked {
            width: 20px;
            height: 20px;
            background-color: #1D9752 !important;
            border-color: #1D9752 !important;
        }

        .form-check-label {
            margin-left: 5px;
            font-size: 14px !important;
            padding-top: 3px !important;
        }

        /*.items {*/
        /*    height: 40px !important;*/
        /*}*/
        .back {
            background-color: #D8D8D8;
            border-color: #D8D8D8;
            color: #676767;
            font-style: normal;
            font-weight: 600;
            font-size: 14px;
            line-height: 16px;
            padding: 11px 16px;
            height: 40px;
        }

        .btn-danger {
            background-color: #C70404;
            font-style: normal;
            font-weight: 600;
            font-size: 14px;
            line-height: 25px;
        }
        input:disabled {
            background-color: #E6E6E6 !important;
            cursor: not-allowed !important;
            pointer-events: none !important;
        }

        select:disabled {
            background-color: #E6E6E6 !important;
            cursor: not-allowed !important;
            pointer-events: none !important;
        }

        textarea:disabled {
            background-color: #E6E6E6 !important;
            cursor: not-allowed !important;
            pointer-events: none !important;
        }

        .upload-hidden {
            display: none;
        }

        #call-to-action {
            width: 85px;
            /*border: solid 1px #1D9752;*/
            font-size: 14px;
            color: #4299E1;
            border-radius: 5px;
            font-weight: 400;
            padding: 5px 0;
        }

        #showLicense {
            width: 85px;
            /*border: solid 1px #1D9752;*/
            font-size: 14px;
            color: #4299E1;
            border-radius: 5px;
            font-weight: 400;
            padding: 5px 0;
        }

        #showLicenseExplanation {
            width: 85px;
            /*border: solid 1px #1D9752;*/
            font-size: 14px;
            color: #4299E1;
            border-radius: 5px;
            font-weight: 400;
            padding: 5px 0;
        }

        #showLicenseExplanation2 {
            width: 85px;
            /*border: solid 1px #1D9752;*/
            font-size: 14px;
            color: #4299E1;
            border-radius: 5px;
            font-weight: 400;
            padding: 5px 0;
        }

        #license {
            width: 120px;
            /*border: solid 1px #1D9752;*/
            font-size: 14px;
            color: #4299E1;
            border-radius: 5px;
            font-weight: 400;
            padding: 5px 0;
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

        .block {
            position: relative;
            display: inline-block;
            vertical-align: top;
            width: 100px;
            /*height: 150px;*/
            padding: 9px;
            margin-right: 15px;
            margin-bottom: 15px;
            background-color: #fff;
            border: 1px solid #ccc;
            margin-right: 10px;
            border-radius: 5px;
        }

        .block img, video {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            max-height: 100%;
        }

        .cancelButton {
            -moz-appearance: none;
            -webkit-appearance: none;
            position: absolute;
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

        .img {
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .modal-backdrop {
            display: none !important;
        }

        .img:hover {
            opacity: 0.7;
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
            background-color: rgb(0, 0, 0); /* Fallback color */
            background-color: rgba(0, 0, 0, 0.9); /* Black w/ opacity */
        }

        /* Modal Content (Image) */
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        /* Caption of Modal Image (Image Text) - Same Width as the Image */
        #caption {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            color: #ccc;
            padding: 10px 0;
            height: 150px;
        }

        /* Add Animation - Zoom in the Modal */
        .modal-content, #caption {
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        @keyframes zoom {
            from {
                transform: scale(0)
            }
            to {
                transform: scale(1)
            }
        }

        /* The Close Button */
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        .show {
            width: 100%;
        }

        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 700px) {
            .modal-content {
                width: 100%;
            }

            .tooltip_message {
                font-size: 10px;
            }
        }

        .modal-dialog-centered {
            display: block !important;
        }

        .img-area {
            border: solid 1px #D8D8D8;
            border-radius: 5px;
            padding: 3px;
            /*margin-bottom: 10px;*/
            position: relative;
        }

        .img-area-1 {
            border: solid 1px #D8D8D8;
            border-radius: 5px;
            padding: 3px;
            /*margin-bottom: 10px;*/
            position: relative;
        }

        .submit {
            width: 150px;
            font-weight: 400;
            font-size: 14px;
        }

        #cancle {
            color: #676767;
            background-color: #D8D8D8;
            border-color: #D8D8D8;
        }

        #create {
            background-color: #1D9752;
            border-color: #1D9752;
        }

        .form-group {
            margin-top: 10px;
        }

        #delivery_time {
            border-radius: 5px;
            background-color: #377dff;
        }

        .fw-600 {
            font-weight: 600 !important;
        }

        .background {

            /* Add the blur effect */
            filter: brightness(50%);
            -webkit-filter: brightness(50%);

            /* Full height */
            height: 100%;

            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .countImg {
            color: white;
            font-weight: bold;
            position: absolute;
            top: 58%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            padding: 20px;
            text-align: center;
        }

        .countImg-license {
            color: white;
            font-weight: bold;
            position: absolute;
            top: 58%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            padding: 20px;
            text-align: center;
        }

        .modal-btn {
            display: flex;
            justify-content: space-between;
        }

        .modal-btn button {
            width: 192.5px;
            height: 40px;
            border: none;
            outline: none;
            font-style: normal;
            font-weight: 600;
            font-size: 14px;
            line-height: 16px;
        }

        .form-modal {
            display: flex;
            flex-direction: column;
            gap: 8px;
            text-align: center;
        }

        .form-modal h5 {
            font-style: normal;
            font-weight: 600;
            font-size: 16px;
            line-height: 20px;
            color: #3B3B3B;
        }

        .form-modal p {
            font-style: normal;
            font-weight: 400;
            font-size: 14px;
            line-height: 16px;
            color: #676767;
        }

        .form-control{
            height: 40px;
            font-size: 14px;
            font-weight: 400;
            color: #676767;
        }

    </style>
@endsection

<div id="main" style="display: flex;flex-direction: column;gap: 24px;padding: 0px 20px;">
    <div id="loading" class="theloading" style="display: none;">
        <i class="fa fa-cog fa-spin fa-3x fa-fw" style="margin-bottom: 800px"></i>
    </div>
    <div class="form-header">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="header-title " style="display: flex; justify-content: space-between;align-items: center">
            <div>
                <h4>Báo cáo tồn kho</h4>
                <small>
                    <a style="text-decoration: none;color: #676767;" href="#" class="list">Quản lý tồn kho ấn phẩm</a> >
                    <a style="text-decoration: none;color: #676767;" href="#">Chi tiết tồn kho</a>
                </small>
            </div>
            <div class="header-btn">
                @if($reportDetailMkt)
                    <a href="{{route('viewcpanel::trade.inventory.storageDetail', ['id' => $storage['_id']])}}"
                       type="button" class="btn btn-outline-secondary back">Trở về <i class="fa fa-arrow-left"
                                                                                      aria-hidden="true"></i>
                    </a>
                @else
                    <a href="{{route('viewcpanel::trade.inventory.reportList')}}"
                       type="button" class="btn btn-outline-secondary back">Trở về <i class="fa fa-arrow-left"
                                                                                      aria-hidden="true"></i>
                    </a>
                @endif
                <button class="btn btn-danger" data-bs-toggle="modal"
                        {{ $create_explanation ? "" : "hidden" }} data-bs-target="#explanation">Tạo phiếu giải trình
                    <i class="fa fa-plus" aria-hidden="true"></i></button>
                <a class="btn btn-danger adjustmentCreate" {{ $create_adjustment ? "" : "hidden" }}
                href="{{route('viewcpanel::trade.inventory.adjustmentCreate', ['id' => $detail['_id']])}}">Tạo phiếu
                    điều chỉnh
                    <i class="fa fa-plus" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>

    {{--    <div class="form-container">--}}
    <div class="content-title">

    </div>
    {{--        <div>--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <h5 style="padding-bottom: 10px">Nội dung báo cáo tồn kho</h5>
    <div class="form-container">
        <h7><strong>Thông tin chung</strong></h7>
        <div class="row">
            <div class="col-sm-4 col-md-4">
                <label for="" class="col-form-label">Người tạo </label>
                <input type="text" class="form-control" value="{{$detail['created_by']}}" disabled>
            </div>
            <div class="col-sm-4 col-md-4">
                <label for="" class="col-form-label">Ngày tạo </label>
                <input type="text" class="form-control" value="{{date('d/m/Y H:i:s',$detail['created_at'])}}"
                       disabled>
            </div>
            <div class="col-sm-4 col-md-4">

            </div>
        </div>

        <div class="row" style="padding-top: 10px">
            <div class="col-sm-4 col-md-4">
                <label for="" class="col-form-label">Phòng giao dịch </label>
                {{--                <select disabled class="form-select" style="width: 100%" name="store" id="store">--}}
                <input name="store" disabled id="store" class="form-control" value="{{$detail['store_name']}}">
                {{--                </select>--}}
            </div>
            <div class="col-sm-4 col-md-4">
                <label for="upload" class="col-form-label">Chứng từ báo cáo tồn kho</label>
                <div class="img-area" style="background-color: #E6E6E6 !important; height: 40px;">
                    <div id="imgInput"></div>
                    <a type="button" class="upload btn btn-default btn-lg license"
                       data-license="{{json_encode($detail['license'])}}"
                       id="showLicense" data-bs-toggle="modal" data-bs-target="#exampleModal">Chứng từ</a>
                </div>
            </div>

            <div class="col-sm-4 col-md-4">
                <label for="" class="col-form-label">Trạng thái </label>
                @if($status)
                    @foreach($status as $key => $st)
                        @if($key == $detail['status'])
                            <input type="text" class="form-control" style="color: #1D9752;font-weight: bold; font-size: 16px;"
                                   value="{{$st}}" disabled>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
        @if(isset($explanation))
            <div class="row" style="padding-top: 10px;">
                <div class="col-sm-4 col-md-4">
                    <label for="" class="col-form-label">Người giải trình </label>
                    <input type="text" class="form-control" value="{{$explanation['created_by'] ?? ""}}"
                           disabled>
                </div>
                <div class="col-sm-4 col-md-4">
                    <label for="" class="col-form-label">Ngày giải trình </label>
                    <input type="text" class="form-control"
                           value="{{isset($explanation['created_at']) ? date('d/m/Y H:i:s', $explanation['created_at']) : ""}}"
                           disabled>
                </div>
                <div class="col-sm-4 col-md-4">
                </div>
            </div>
        @endif

        <div class="row" style="">
            <div class="col-sm-12 col-md-12">
                <label for="" class="col-form-label">Ghi chú báo cáo tồn kho</label>
                <textarea style="min-height: 100px;" class="form-control" disabled name="" id="">{{$detail['description'] ?? ""}}</textarea>
            </div>
        </div>
    </div>
    {{--            danh sách ấn phẩm ASM (giải trình mkt và asm)--}}
    @if(isset($explanation) && ($explanationItemListMKT || $explanationItemListASM))
        <div class="form-container">
            <div class="row">
                <h7 style="padding-bottom: 10px"><strong>Danh sách ấn phẩm</strong></h7>
                @foreach($explanation['item'] as $key => $ex)
                    @if(isset($ex['license']) && isset($ex['note_explanation']))
                        <div style="padding-bottom: 20px">
                            <div class="item">
                                <div>
                                    <div class="content-item">
                                        <div class="form-item" style="">
                                            <span id="name" style="font-size: 14px; font-weight:700">{{$ex['name']}}</span>
                                            <span id="type" style="font-size: 12px">{{$ex['type']}}</span>
                                            <span id="specification"
                                                  style="font-size: 12px">{{$ex['specification']}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 col-md-4">
                                    <label for="" class="col-form-label">Số lượng tồn báo cáo </label>
                                    <input disabled type="text" class="form-control "
                                           value="{{$ex['quantity_stock_report']}}">
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <label for="" class="col-form-label">Chứng từ giải trình</label>
                                    <div class="img-area" style="background-color: #EBEBE4 !important;">
                                        <div id="imgInput"></div>
                                        <a type="button"
                                           class="upload btn btn-default btn-lg explanationLicense2"
                                           data-explanation-license2="{{json_encode($ex['license'])}}"
                                           id="showLicenseExplanation2" data-bs-toggle="modal"
                                           data-bs-target="#exampleModal2">Chứng từ</a>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4">

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <label for="" class="col-form-label">Ghi chú giải trình </label>
                                    <textarea class="form-control" disabled name=""
                                              id="">{{$ex['note_explanation']}}</textarea>
                                </div>
                            </div>
                            <div class="row" style="<?= $showStockRealAndBroken ? "" : "display:none" ?>">
                                <div class="col-sm-4 col-md-4">
                                    <label for="" class="col-form-label">Số lượng tồn thực tế </label>
                                    <input disabled type="text" class="form-control"
                                           value="{{$ex['quantity_stock'] ?? ""}}">
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <label for="" class="col-form-label">Số lượng hỏng </label>
                                    <input disabled type="text" class="form-control"
                                           value="{{$ex['quantity_broken'] ?? ""}}">
                                </div>
                                <div class="col-sm-4 col-md-4">
                                </div>
                            </div>
                        </div>
                    @else
                        <div style="padding-bottom: 20px">
                            <div class="item">
                                <div>
                                    <div class="content-item">
                                        <div class="form-item" style="">
                                            <span id="name" style="font-size: 14px;font-weight: 700">{{$ex['name']}}</span>
                                            <span id="type" style="font-size: 12px">{{$ex['type']}}</span>
                                            <span id="specification"
                                                  style="font-size: 12px">{{$ex['specification']}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 col-md-4">
                                    <label for="" class="col-form-label">Số lượng tồn báo cáo </label>
                                    <input disabled type="text" class="form-control "
                                           value="{{$ex['quantity_stock_report'] ?? ""}}">
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <label for="" class="col-form-label">Số lượng tồn hệ thống </label>
                                    <input disabled type="text" class="form-control"
                                           value="{{$ex['quantity_stock_storage'] ?? ""}}">
                                </div>
                                <div class="col-sm-4 col-md-4">

                                </div>
                            </div>
                        </div>
                    @endif

                @endforeach

            </div>
        </div>
    @endif
    {{--        </div>--}}


    {{--            danh sách số lượng lệch MKT--}}
    @if(isset($item) && $itemDifferentMKT)
        <div class="form-container item_explanation">
            <h7 style="padding-bottom: 10px"><strong>Danh sách ấn phẩm</strong></h7>
            <div class="row" id="item-area" style="gap: 24px;">
                @if(!empty($item))
                    @foreach($item as $i)
                        <div class="col-sm-12 col-md-12" style="padding-bottom: 10px;">
                            <div class="form-container item"
                                 style="<?= ($i['quantity_stock_report'] != $i['quantity_stock_storage']) ? "border: red 1px solid;border-radius: 5px;padding: 0; !important;" : "padding: 0; !important;"  ?>">
                                <div style="padding: 10px; position: relative">
                                    <div id="tooltip_message"
                                         style="position: absolute; right: 50px ; top: 5px;display: none;">
                                        <span class="text-danger tooltip_message">Số lượng ấn phẩm thực tế đang lệch với hệ thống</span>
                                    </div>
                                    <div style="position: absolute; right: 10px ; top: 10px">
                                        <i style="color:red;font-size: 20px;<?= ($i['quantity_stock_report'] != $i['quantity_stock_storage']) ? "" : "display: none;" ?>"
                                           class="fa fa-exclamation-circle" id="tooltip" name="tooltip"
                                           aria-hidden="true"></i>
                                    </div>
                                    <div class="content-item">
                                        <div class="form-item" style="">
                                            <span id="name" style="font-size: 14px; font-weight: 700;">{{$i['name']}}</span>
                                            <span id="type" style="font-size: 12px">{{$i['type']}}</span>
                                            <span id="specification"
                                                  style="font-size: 12px">{{$i['specification']}}</span>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-bottom: 10px;">
                                        <div class="col-sm-4 col-md-4">
                                            <label for="" class="col-form-label">Số lượng tồn báo cáo </label>
                                            <input disabled type="text" class="form-control quantity_stock_report"
                                                   value="{{$i['quantity_stock_report']}}">
                                        </div>
                                        <div class="col-sm-4 col-md-4">
                                            <label for="" class="col-form-label">Số lượng tồn hệ thống </label>
                                            <input disabled type="text" class="form-control quantity_stock_storage"
                                                   value="{{$i['quantity_stock_storage']}}">
                                        </div>
                                        <div class="col-sm-4 col-md-4">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    @endif


    {{--             danh sách ân phẩm PGD--}}
    @if(isset($explanation) && $explanationItemListCVKD)
        <div class="form-container">
            <div class="row">
                <h7><strong>Danh sách ấn phẩm</strong></h7>
                @foreach($explanation['item'] as $k => $e)
                    @if(isset($e['license']) && isset($e['note_explanation']))
                        <div class="col-sm-4 col-md-4">
                            <div class="item">
                                <div style="padding: 10px">
                                    <div class="content-item">
                                        <div class="form-item" style="">
                                            <span id="name" style="font-size: 14px; font-weight:700">{{$e['name']}}</span>
                                            <span id="type" style="font-size: 12px">{{$e['type']}}</span>
                                            <span id="specification"
                                                  style="font-size: 12px">{{$e['specification']}}</span>
                                        </div>
                                    </div>
                                    <div style="padding-bottom: 10px;">
                                        <div>
                                            <label for="" class="col-form-label">Số lượng tồn báo cáo </label>
                                            <input disabled type="text" class="form-control quantity_stock_report"
                                                   value="{{$e['quantity_stock_report']}}">
                                        </div>
                                        <div>
                                            <label for="" class="col-form-label">Chứng từ giải trình </label>
                                            <div class="img-area" style="background-color: #EBEBE4 !important;">
                                                <div id="imgInput"></div>
                                                <a type="button"
                                                   class="upload btn btn-default btn-lg explanationLicense"
                                                   data-explanation-license="{{json_encode($e['license'])}}"
                                                   id="showLicenseExplanation" data-bs-toggle="modal"
                                                   data-bs-target="#exampleModal1">Chứng từ</a>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="" class="col-form-label">Ghi chú giải trình </label>
                                            <textarea class="form-control" disabled name=""
                                                      id="">{{$e['note_explanation']}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

            </div>
        </div>
    @else
        <div class="form-container">
            <div class="row">
                <h7><strong>Danh sách ấn phẩm</strong></h7>
                @foreach($detail['item'] as $k => $e)
                    <div class="col-sm-4 col-md-4">
                        <div class="item">
                            <div style="padding: 10px">
                                <div class="content-item">
                                    <div class="form-item" style="">
                                        <span id="name" style="font-size: 14px;font-weight: 700">{{$e['name']}}</span>
                                        <span id="type" style="font-size: 12px">{{$e['type']}}</span>
                                        <span id="specification"
                                              style="font-size: 12px">{{str_replace(",", ", ",$e['specification'])}}</span>
                                    </div>
                                </div>
                                <div style="padding-bottom: 10px;">
                                    <div>
                                        <label for="" class="col-form-label">Số lượng tồn báo cáo </label>
                                        <input disabled type="text" class="form-control quantity_stock_report"
                                               value="{{$e['quantity_stock']}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif



    {{--                    danh sách phiếu điều chinh ASM--}}
    @if(isset($adjustment) && $adjustmentDetail)
        <div class="form-container">
            @foreach($adjustment as $ad)
                <div style="padding-bottom: 15px;">
                    <div style="display: flex;justify-content: space-between; align-items: center">
                        <input type="text" hidden value="{{$detail['_id']}}" id="id_report_adjustment">
                        <h6 style="padding-bottom: 10px"><strong>Phiếu điều chỉnh
                                - {{date('d/m/Y H:i:s', $ad['created_at'])}}</strong></h6>
                        <div style="display: flex; gap: 24px; align-items: center">
                            <div style="{{($adjustmentDone || $adjustmentCancel) ? "" : "display: none"}}">
                                <button class="btn btn-success approve-adjustment-{{$ad['id']}}"
                                        <?= in_array($ad['status'], ['done', 'cancel']) ? "hidden" : "" ?>
                                        data-bs-target="#createAdjustment" data-id-create="{{$ad['id']}}"
                                        data-bs-toggle="modal">
                                    Duyệt điều chỉnh <i class="fa fa-check" aria-hidden="true"></i></button>
                                <button class="btn btn-danger cancel-adjustment-{{$ad['id']}}"
                                        <?= in_array($ad['status'], ['done', 'cancel']) ? "hidden" : "" ?>
                                        data-bs-target="#cancelAdjustment" data-id-cancel="{{$ad['id']}}"
                                        data-bs-toggle="modal">Hủy
                                    điều chỉnh <i class="fa fa-times" aria-hidden="true"></i></button>
                            </div>
                            <i class="fa fa-chevron-up" aria-hidden="true" style="cursor:pointer;"
                               id="up-{{$ad['id']}}"></i>
                            <i class="fa fa-chevron-down" aria-hidden="true" style="cursor:pointer;" hidden
                               id="down-{{$ad['id']}}"></i>
                        </div>
                    </div>
                    <div class="section-adjustment-{{$ad['id']}}">
                        <strong style="font-size: 14px">Thông tin chung</strong>

                        <div class="row" style="padding-bottom: 15px">
                            <div class="col-sm-4 col-md-4">
                                <label for="" class="col-form-label">Người tạo </label>
                                <input class="form-control" disabled name="" id="" value="{{$ad['created_by']}}">
                            </div>
                            <div class="col-sm-4 col-md-4">
                                <label for="" class="col-form-label">Ngày tạo </label>
                                <input class="form-control" disabled name="" id=""
                                       value="{{date('d/m/Y H:i:s', $ad['created_at'])}}">
                            </div>
                            <div class="col-sm-4 col-md-4">
                                <label for="" class="col-form-label">Trạng thái </label>
                                @foreach($status_adjustment as $key => $st)
                                    @if($key == $ad['status'])
                                        <input style="color:#1D9752;font-size: 16px;font-weight: bold;"
                                               class="form-control" disabled name="" id="" value="{{$st}}">
                                    @endif
                                @endforeach

                            </div>
                        </div>

                        <div class="row">
                            <strong style="font-size: 14px">Danh sách ấn phẩm</strong>
                            @foreach($ad['item'] as $adi)
                                <div class="col-sm-4 col-md-4">
                                    <div class="item">
                                        <div style="padding: 10px">
                                            <div class="content-item">
                                                <div class="form-item" style="">
                                                    <span id="name" style="font-size: 14px">{{$adi['name']}}</span>
                                                    <span id="type" style="font-size: 12px">{{$adi['type']}}</span>
                                                    <span id="specification"
                                                          style="font-size: 12px">{{$adi['specification']}}</span>
                                                </div>
                                            </div>
                                            <div style="padding-bottom: 10px;">
                                                <div>
                                                    <label for="" class="col-form-label">Số lượng tồn thực
                                                        tế </label>
                                                    <input disabled type="text"
                                                           class="form-control quantity_stock_report"
                                                           value="{{$adi['quantity_stock_storage']}}">
                                                </div>
                                                <div>
                                                    <label for="" class="col-form-label">Số lượng hỏng </label>
                                                    <input disabled type="text" class="form-control quantity_broken"
                                                           value="{{$adi['quantity_broken']}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <strong style="font-size: 14px">Ghi chú điều chỉnh</strong>
                        <div>
                            <textarea class="form-control" disabled name="" id="">{{$ad['note']}}</textarea>
                        </div>
                    </div>

                </div>
            @endforeach

        </div>
    @endif
    {{--    </div>--}}
</div>
{{--        modal chấp nhận duyệt pdc--}}
<div class="modal fade" id="createAdjustment" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="width: 100% !important">
            <div class="modal-body">
                <div class="form-modal">
                    <h5>Xác nhận</h5>
                    <input hidden type="text" class="id_adjustment">
                    <p>Bạn chắc chắn muốn duyệt phiếu điều chỉnh này</p>
                    <div class="modal-btn">
                        <button class="approve-adjustment" id="approve-adjustment"
                                style="background: #1D9752;color: #FFFFFF;border-radius: 5px">Đồng ý
                        </button>
                        <button data-bs-dismiss="modal"
                                style="background: #D8D8D8;color: #676767;border-radius: 5px">Hủy
                        </button>
                    </div>
                </div>
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
                    <h5>Xác nhận</h5>
                    <input hidden type="text" class="id_adjustment_cancel">
                    <p>Bạn chắc chắn muốn hủy phiếu điều chỉnh này</p>
                    <div class="modal-btn">
                        <button class="cancel-adjustment" id="cancel-adjustment"
                                style="background: #F4CDCD;color: #C70404;border-radius: 5px">Đồng ý
                        </button>
                        <button data-bs-dismiss="modal"
                                style="background: #D8D8D8;color: #676767;border-radius: 5px">Hủy
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- The Modal -->
<div id="imgModal" class="modal">
    <!-- The Close Button -->
    <span class="close" onclick="closeModal(this)">&times;</span>
    <!-- Modal Content (The Image) -->
    <img class="modal-content" id="img01">
    <!-- Modal Caption (Image Text) -->
</div>
<div id="videoModal" class="modal">
    <!-- The Close Button -->
    <span class="close" onclick="closeModal(this)">&times;</span>
    <!-- Modal Content (The Image) -->
    <iframe id="srcVideo" width="100%" height="100%" frameborder="0" allowfullscreen src=""></iframe>
</div>

{{--    modal license--}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="margin: 0px !important;width: 100% !important;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Chi tiết chứng từ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12 col-md-12" style="text-align: center;">
                            <div id="imgPath">
                                <img style="width: 100%; height: 200px;" src="{{$detail['license'][0]}}" alt=""
                                     class="underline cursor-pointer background"
                                     data-fancybox-trigger="gallery-license">
                                <div style="display:none" class="imgP">

                                </div>
                                <h5 data-fancybox-trigger="gallery"
                                    class="underline cursor-pointer xt countImg-license">{{'+' . count($detail['license'])}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
{{--    modal explanation PGD--}}
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="margin: 0px !important;width: 100% !important;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Chi tiết chứng từ giải trình</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12 col-md-12" style="text-align: center;">
                            <div id="imgPath">
                                <img style="width: 100%; height: 200px;" id="img-explanation"
                                     src="" alt=""
                                     class="underline cursor-pointer background img-explanation"
                                     data-fancybox-trigger="gallery">
                                <div style="display:none" class="imgExplanation">

                                </div>
                                <h5 data-fancybox-trigger="gallery"
                                    class="underline cursor-pointer xt countImg"></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng
                </button>
            </div>
        </div>
    </div>
</div>
{{--    modal explanation ASM--}}
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="margin: 0px !important;width: 100% !important;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Chi tiết chứng từ giải trình</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12 col-md-12" style="text-align: center;">
                            <div id="imgPath">
                                <img style="width: 100%; height: 200px;" id="img-explanation2"
                                     src="" alt=""
                                     class="underline cursor-pointer background img-explanation2"
                                     data-fancybox-trigger="gallery2">
                                <div style="display:none" class="imgExplanation2">

                                </div>
                                <h5 data-fancybox-trigger="gallery2"
                                    class="underline cursor-pointer xt countImg"></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng
                </button>
            </div>
        </div>
    </div>
</div>

{{--    modal explanation--}}
<div class="modal fade" id="explanation" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" style="width: 100%;margin: 0px; max-width: 100%">
            <div class="modal-header" style="border-bottom: 0px !important;">
                <h5 style="text-align: center" class="col-12 modal-title text-center" id="exampleModalLabel">Giải trình
                    tồn kho ấn phẩm</h5>
            </div>
            <div class="modal-body">
                <h6>Danh sách ấn phẩm</h6>
                <div class="row">
                    @if($item)
                        @foreach($item as $key => $i)
                            @if($i['quantity_stock_report'] != $i['quantity_stock_storage'])
                                <div class="col-sm-6 col-md-6" style="padding-bottom: 10px;">
                                    <div class="form-container">
                                        <div class="items">
                                            <div>
                                                <div class="content-item">
                                                    <div class="form-item" style="">
                                                        <input hidden type="text" class="id" value="{{$detail['_id']}}">
                                                        <span id="name"
                                                              style="font-size: 14px">{{$i['name']}}</span>
                                                        <span id="type"
                                                              style="font-size: 12px">{{$i['type']}}</span>
                                                        <span id="specification"
                                                              style="font-size: 12px">{{$i['specification']}}</span>
                                                        <span id="code" style="font-size: 12px"
                                                              hidden>{{$i['code']}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <label for="" class="col-form-label">Số lượng tồn báo cáo </label>
                                                <input disabled type="text"
                                                       class="form-control quantity_stock_report"
                                                       value="{{$i['quantity_stock_report']}}">
                                            </div>
                                            <div>
                                                <div class="form-group">
                                                    <label for="upload" class="col-form-label">Chứng từ giải
                                                        trình <span
                                                            class="text-danger">*</span></label>
                                                    <div class="img-area-1"
                                                         style="">
                                                        <div id="imgInput-{{$key}}"></div>
                                                        <a style="width: 85px;font-size: 14px; color: #4299E1; border-radius: 5px;font-weight: 400;padding: 5px 0;"
                                                           type="button" class="upload btn btn-default btn-lg"
                                                           id="call-to-action-{{$key}}"> Tải ảnh lên
                                                        </a>
                                                        <i style="position: absolute;right: 10px;top: 26%;"
                                                           class="fa fa-upload"
                                                           aria-hidden="true"></i>
                                                        <div id="drop">
                                                            <input type="file" name="imgs" multiple multiple
                                                                   style="display: none"
                                                                   class="upload-hidden-{{$key}}">
                                                        </div>
                                                    </div>
                                                    <span id="invalid-img" class="invalid"></span>
                                                    <span class="text-danger path" id="path_error" hidden>Chứng từ giải trình không được để trống !</span>
                                                </div>
                                            </div>
                                            <div>
                                                <label for="" class="col-form-label">Ghi chú giải trình <span
                                                        class="text-danger">*</span></label>
                                                <textarea class="form-control" name="" id="note_explanation"
                                                          placeholder="Nhập"></textarea>
                                                <span class="text-danger note" hidden>Ghi chú giải trình không được để trống !</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endif
                        @endforeach
                    @endif
                </div>
                <div class="modal-footerdff" style="padding-top: 20px;display: flex;justify-content: space-evenly;">
                    <button type="button" class="btn btn-primary create"
                            style="background-color: #1D9752;width: 20%">Gửi
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: 20%">
                        Hủy
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
</div>

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
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
    <script>
        $(document).ready(function () {
            $('.back').click(function (e) {
                e.preventDefault();
                let targetLink = $(e.target).attr('href');
                Redirect(targetLink, false);
            })

            $('.adjustmentCreate').click(function (e) {
                e.preventDefault();
                let targetLink = $(e.target).attr('href');
                Redirect(targetLink, false);
            })

            $('.item').each(function (k, v) {
                console.log(v)
                console.log($(v).find('#tooltip'));
                $(v).find('#tooltip').click(function (event) {
                    event.preventDefault();
                    console.log('1')
                    $(v).find('#tooltip_message').toggle('slide')
                })
            })

            $('.explanationLicense2').click(function (e) {
                e.preventDefault();
                document.body.scrollIntoView();
            })

            $('.explanationLicense').click(function (e) {
                e.preventDefault();
                document.body.scrollIntoView();
            })


            var adjustment = JSON.parse('{!! json_encode($adjustment ?? "") !!}');
            console.log(adjustment)
            $.each(adjustment, function (k, v) {
                $('#up-' + v.id).click(function (event) {
                    event.preventDefault();
                    $('.section-adjustment-' + v.id).toggle('slide');
                    $('#down-' + v.id).attr('hidden', false)
                    $(this).attr('hidden', true)
                    $('.approve-adjustment-' + v.id).attr('hidden', true)
                    $('.cancel-adjustment-' + v.id).attr('hidden', true)
                })
                $('#down-' + v.id).click(function (event) {
                    event.preventDefault();
                    $('.section-adjustment-' + v.id).toggle('slide');
                    $('#up-' + v.id).attr('hidden', false)
                    $(this).attr('hidden', true)
                    if (v.status == 'new') {
                        $('.approve-adjustment-' + v.id).attr('hidden', false)
                        $('.cancel-adjustment-' + v.id).attr('hidden', false)
                    }
                })

                $('.approve-adjustment-' + v.id).click(function () {
                    document.body.scrollIntoView();
                    console.log('1')
                    let id = $(this).attr('data-id-create');
                    console.log(id);
                    $('.id_adjustment').val(id);
                })
                $('.cancel-adjustment-' + v.id).click(function () {
                    document.body.scrollIntoView();
                    let id = $(this).attr('data-id-cancel');
                    console.log(id);
                    $('.id_adjustment_cancel').val(id);
                })

            })
            var items = JSON.parse('{!! json_encode($item) !!}');
            $.each(items, function (k, v) {
                $('#call-to-action-' + k).click(function () {
                    $('.upload-hidden-' + k).click();
                });

                $('.upload-hidden-' + k).on('change', function () {
                    var files = $(this)[0].files;
                    for (let i = 0; i < files.length; i++) {
                        let file = files[i];
                        uploadImgs(file);
                    }
                });
                const uploadImgs = async function (file) {
                    var formData = new FormData();
                    formData.append('file', file);
                    console.log(file.type);
                    if (file.type == 'image/jpeg' || file.type == 'image/png' || file.type == 'image/jpg') {
                        //do nothing
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Thông báo',
                            text: 'File không đúng định dạng, vui lòng thử lại!',
                            confirmButtonColor: '#dc3545',
                            timer: 3000,
                            position: 'top',
                        })
                        return;
                    }

                    await $.ajax({
                        dataType: 'json',
                        enctype: 'multipart/form-data',
                        url: '{{route('viewcpanel::trade.inventory.uploadImg')}}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: formData,
                        processData: false, // tell jQuery not to process the data
                        contentType: false, // tell jQuery not to set contentType
                        success: function (data) {
                            console.log(data);
                            if (data && data.code == 200) {
                                if (file.type == 'image/jpeg' || file.type == 'image/png' || file.type == 'image/jpg') {
                                    let block = `
                <div class="block" style="width:auto; border:none; ">
                  <a target="_blank" style="font-size:14px;text-decoration: none " href="` + data.path + `">` + data.raw_name + ` </a>
                  <input type="hidden" name="url[]" value="` + data.path + `">
                  <button style="position: absolute;top: -3px;" type="button" onclick="deleteImage(this)" class="cancelButton">
                    <i style="font-size: 20px;margin-top: 12px;" class="fa fa-times"></i>
                  </button>
                </div>
                `;
                                    $('#imgInput-' + k).before(block);
                                } else if (file.type == 'audio/mp3' || file.type == 'video/mp4') {
                                    let block = `
                    <div class="block">
                        <video onclick="clickVideo(this)">
                            <source src="` + data.path + `">
                        </video>
                        <input type="hidden" name="url[]" value="` + data.path + `">
                        <button type="button" onclick="deleteImage(this)" class="cancelButton">
                            <i class="fa fa-times-circle"></i>
                        </button>
                    </div>
                    `;
                                    $('#imgInput-' + k).before(block);
                                }

                            } else if (typeof (data) == "string") {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Thông báo',
                                    text: 'Có lỗi xảy ra, vui lòng thử lại sau!',
                                    confirmButtonColor: '#dc3545',
                                    timer: 3000,
                                    position: 'top',
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Thông báo',
                                    text: data.msg,
                                    confirmButtonColor: '#dc3545',
                                    timer: 3000,
                                    position: 'top',
                                })
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Thông báo',
                                text: 'Có lỗi xảy ra, vui lòng thử lại sau!',
                                confirmButtonColor: '#dc3545',
                                timer: 3000,
                                position: 'top',
                            })
                        }
                    });
                }
            })

            $('.create').click(function (event) {
                let name = '';
                let type = '';

                let specification = '';
                let quantity_stock_report = '';
                let note = '';
                let path = '';
                let note_explanation = '';
                let arr = [];
                Swal.fire({
                    title: 'Gửi giải trình',
                    text: "Bạn có chắc chắn muốn gửi giải trình này ?",
                    showCancelButton: true,
                    confirmButtonColor: '#1D9752',
                    cancelButtonColor: '#D8D8D8',
                    confirmButtonText: 'Đồng ý',
                    confirmCancelText: 'Hủy',
                    position: 'top',
                }).then((result) => {
                    if (result.isConfirmed) {
                        let id = $('.id').val();
                        let error_explanation = false;
                        $('.items').each(function (key, value) {
                            let license = [];
                            let a = {};
                            $(value).find("input[name='url[]']").each(function () {
                                license.push($(this).val());
                            });
                            name = ($(value).find('#name').text());
                            type = ($(value).find('#type').text());
                            code = ($(value).find('#code').text());
                            specification = ($(value).find('#specification').text());
                            quantity_stock_report = ($(value).find('.quantity_stock_report').val());
                            note_explanation = ($(value).find('#note_explanation').val());

                            if (license.length == 0) {
                                $(value).find('.img-area-1').css('border', 'red 1px solid');
                                $(value).find('#path_error').attr('hidden', false);
                                error_explanation = true
                            } else {
                                $(value).find('.img-area-1').css('border', '1px solid #D8D8D8');
                                $(value).find('#path_error').attr('hidden', true)
                            }
                            if (note_explanation == "") {
                                $(value).find('#note_explanation').css('border', 'red 1px solid');
                                $(value).find('.note').attr('hidden', false);
                                error_explanation = true;
                            } else {
                                $(value).find('#note_explanation').css('border', '1px solid #D8D8D8');
                                $(value).find('.note').attr('hidden', true);
                            }
                            a = {
                                'name': name,
                                'type': type,
                                'code': code,
                                'specification': specification,
                                'quantity_stock_report': parseInt(quantity_stock_report),
                                'note_explanation': note_explanation,
                                'license': JSON.stringify(license),
                            };
                            arr.push(a);
                        });
                        console.log(arr);
                        let formData = new FormData();
                        formData.append('item', JSON.stringify(arr));
                        formData.append('id', id);
                        if (error_explanation) {
                            return;
                        } else {
                            $.ajax({
                                dataType: 'json',
                                enctype: 'multipart/form-data',
                                url: '{{route('viewcpanel::trade.inventory.insertExplanation')}}',
                                type: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: formData,
                                processData: false,
                                contentType: false,
                                beforeSend: function () {

                                    $(".theloading").show();
                                },
                                success: function (data) {
                                    $(".theloading").hide();
                                    if (data.status == 200) {
                                        $(".theloading").hide();
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Thông báo',
                                            text: 'Tạo thành công',
                                            confirmButtonColor: '#1D9752',
                                            timer: 3000,
                                            position: 'top',
                                        })
                                        setTimeout(function () {
                                            setTimeout(function () {
                                                window.location.reload();
                                            }, 3000);
                                        })
                                    } else {
                                        $(".theloading").hide();
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    $(".theloading").hide();
                                }
                            });
                        }


                    }
                });
            });


            $('.toggle1').click(function (event) {
                event.preventDefault()
                $('.detail_explaination').toggle();
            })


            var mine = ['application/vnd.ms-excel', 'application/msexcel', 'application/x-msexcel',
                'application/x-ms-excel', 'application/x-excel', 'application/x-dos_ms_excel',
                'application/xls', 'application/x-xls', 'application/excel', 'application/download',
                'application/vnd.ms-office', 'application/msword', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/zip', 'application/vnd.ms-excel', 'application/msword', 'application/x-zip', 'application/octet-stream',
                'application/vnd.ms-office', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip',
                'application/msword', 'application/x-zip', 'application/pdf', 'application/force-download', 'application/x-download', 'binary/octet-stream'];
            $('.license').click(function (event) {
                event.preventDefault();
                let license = $(this).attr('data-license');
                license = JSON.parse(license);
                console.log(license);
                $('#documentPath').html('');
                $('.imgP').html('')
                $.each(license, function (key, value) {
                    $('.imgP').append('<a data-fancybox="gallery-license" href="' + value + '"><img class="rounded" src="' + value + '"></a></div>')
                })
            })

            $('.explanationLicense').click(function (event) {
                event.preventDefault();
                let explanationLicense = $(this).attr('data-explanation-license');
                license = JSON.parse(explanationLicense);
                console.log(license);
                $('.img-explanation').attr('src', license[0])
                $('.countImg').html('+' + license.length)
                $('.imgExplanation').html('')
                $.each(license, function (key, value) {
                    $('.imgExplanation').append('<a data-fancybox="gallery" href="' + value + '"><img class="rounded" src="' + value + '"></a></div>')

                })
            })

            $('.explanationLicense2').click(function (event) {
                event.preventDefault();
                let explanationLicense2 = $(this).attr('data-explanation-license2');
                license = JSON.parse(explanationLicense2);
                console.log(license);
                $('.img-explanation2').attr('src', license[0])
                $('.countImg').html('+' + license.length)
                $('.imgExplanation2').html('')
                $.each(license, function (key, value) {
                    $('.imgExplanation2').append('<a data-fancybox="gallery2" href="' + value + '"><img class="rounded" src="' + value + '"></a></div>')

                })
            })

            $('.create').click(function (event) {
                event.preventDefault();

            })


        });

        $('.approve-adjustment').click(function (event) {
            event.preventDefault();
            let id = $('.id_adjustment').val();
            let id_report = $('#id_report_adjustment').val();
            let formData = new FormData();
            formData.append('id', id);
            formData.append('id_report', id_report);
            $.ajax({
                dataType: 'json',
                enctype: 'multipart/form-data',
                url: '{{route('viewcpanel::trade.inventory.updateAdjustmentDone')}}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('#createAdjustment').hide();
                    $(".theloading").show();
                },
                success: function (data) {
                    $(".theloading").hide();
                    if (data.status == 200) {
                        $(".theloading").hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'Thông báo',
                            text: 'Tạo thành công',
                            confirmButtonColor: '#1D9752',
                            timer: 3000,
                            position: 'top',
                        })
                        setTimeout(function () {
                            setTimeout(function () {
                                window.location.reload();
                            }, 3000);
                        })
                    } else {
                        $(".theloading").hide();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $(".theloading").hide();
                }
            });
        })

        $('.cancel-adjustment').click(function (event) {
            event.preventDefault();
            let id = $('.id_adjustment_cancel').val();
            let id_report = $('#id_report_adjustment').val();
            let formData = new FormData();
            formData.append('id', id);
            formData.append('id_report', id_report);
            $.ajax({
                dataType: 'json',
                enctype: 'multipart/form-data',
                url: '{{route('viewcpanel::trade.inventory.updateAdjustmentCancel')}}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('#cancelAdjustment').hide();
                    $(".theloading").show();
                },
                success: function (data) {
                    $(".theloading").hide();
                    if (data.status == 200) {
                        $(".theloading").hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'Thông báo',
                            text: 'Tạo thành công',
                            confirmButtonColor: '#1D9752',
                            timer: 3000,
                            position: 'top',
                        })
                        setTimeout(function () {
                            setTimeout(function () {
                                window.location.reload();
                            }, 3000);
                        })
                    } else {
                        $(".theloading").hide();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $(".theloading").hide();
                }
            });
        })

        $('#call-to-action').click(function () {
            $('.upload-hidden').click();
        });


        function deleteImage(el) {
            if (confirm("Bạn có chắc chắn muốn xóa ?")) {
                $(el).closest(".block").remove();
                $('#drop').find('[type="file"]').first().val('');
            }
        }

        function clickImg(el) {
            var modal = document.getElementById("imgModal");
            // Get the image and insert it inside the modal - use its "alt" text as a caption
            var modalImg = document.getElementById("img01");
            var captionText = document.getElementById("caption");
            modal.style.display = "block";
            modalImg.src = el.src;
        }

        const closeModal = function (el) {
            console.log("close");
            $(el).closest('.modal').hide();
        }


    </script>
@endsection


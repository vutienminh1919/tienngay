@extends('viewcpanel::layouts.master')

@section('title', 'Chi tiết yêu cầu ấn phẩm')

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
        padding: 10px 0;
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
        margin-top: 10px
    }

    .span-color {
        color: red
    }

    .content1-input {
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 14px;
        width: 100%;
        border: 1px solid #D8D8D8;
        padding-top: 8px;
        color: #676767;
        background-color: #D8D8D8;
    }

    .content1-input1 {
        background-color: #D8D8D8;
        padding: 5px 16px;
        border-radius: 5px;
        font-size: 14px;
        width: 100%;
        border: none;
        padding-top: 8px;
        color: #676767;
    }

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

    /* content3 */
    .content3 {
        margin-top: 24px;
    }

    .content1{
        background: #FFFFFF;
        padding: 24px 16px;
        border-radius: 10px;
    }
    .content3 {
        background: #FFFFFF;
        padding: 24px 0px;
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
        margin-left: 16px;
    }

    .content3-div {
        color: #676767;
    }

    .content2-div-1 {
        width: 100%;
    }

    .content2-h4 {
        font-size: 14px;
        margin-top: 10px;
    }

    .image img {
        width: 285px;
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

    thead{
        border-style: hidden;
    }

    .input-text {
        width: 100%;
        border: none;
        outline: none;
    }

    .btn-width {
        height: 10%;
        /* max-width: 200px; */
        white-space: nowrap;
        padding: 0 30px;
    }

    .tea {
        width: 100%;
        padding: 5px 16px;
        outline: none;
        border: 1px solid #ccc;
        border-radius: 5px;
        min-height: 100px
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
        padding: 8px 60px;
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
        z-index: 9999;
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
    }

    .xt {
        color: black;
        position: absolute; 
        top: 25%;
        left: 25%;
        background-color: rgba(255, 255, 255, 0.2);
        color: #ffffff;
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

    .form-control:disabled,
    .form-select:disabled,
    textarea:disabled {
        background-color: #D8D8D8;
        color: #676767 !important;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        height: 40px;
    }

    button:disabled {
        background-color: #D8D8D8;
        color: #676767;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
    }
    .multiselect-selected-text{
        color: #676767 !important;
    }
    .btnn-prev {
        background-color: #D8D8D8;
        border: 1px solid #D8D8D8;
        outline: none;
        color: #676767;
        border-radius: 5px;
        font-size: 14px;
        padding: 8px 16px;
        height: 40px;
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
        height:40px;
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
        height:40px;
    }

    .budget-estimates-add {
        background-color: #1D9752;
        border: 1px solid #1D9752;
        outline: none;
        color: #FFFFFF;
        ;
        border-radius: 5px;
        font-size: 14px;
        padding: 8px 16px;
        margin-right: 16px;
    }

    .budget-estimates-remove {
        background-color: #f61c1c;
        border: 1px solid #cd0000;
        outline: none;
        color: #f8ff00;
        border-radius: 5px;
        font-size: 14px;
        padding: 8px 16px;
        margin-right: 16px;
    }

    .distance {
        padding-left: 4px;
    }
    
    .fancybox__container {
    height: 100%;
    position: fixed;
    top: 0;
    left: 0;
    bottom: auto !important;
    right: 0;
    direction: ltr;
    margin: 0;
    padding: env(safe-area-inset-top, 0px) env(safe-area-inset-right, 0px) env(safe-area-inset-bottom, 0px) env(safe-area-inset-left, 0px);
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    color: var(--fancybox-color, #fff);
    -webkit-tap-highlight-color: rgba(0,0,0,0);
    overflow: hidden;
    z-index: 1050;
    outline: none;
    transform-origin: top left;
    --carousel-button-width: 48px;
    --carousel-button-height: 48px;
    --carousel-button-svg-width: 24px;
    --carousel-button-svg-height: 24px;
    --carousel-button-svg-stroke-width: 2.5;
    --carousel-button-svg-filter: drop-shadow(1px 1px 1px rgba(0, 0, 0, 0.4));
}
</style>
<style>
    .steps {
        background: #fff;
        padding: 24px 16px;
        border-radius: 8px;
        /* margin: 24px 0px; */
    }

    .steps p {
        color: #3B3B3B;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        margin: 0px;
    }

    .step-content {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        width: 100%;
        margin: auto;
        padding-top: 16px;
    }

    .header-step {
        display: block;
        /* width: 1484px; */
        overflow-x: scroll
    }

    .cricle {
        width: 48px;
        height: 48px;
        border-radius: 33px;
        position: relative;
        border: 2px solid #D8D8D8;
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: #676767;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        align-content: space-around;
    }

    .cricle-green {
        width: 48px;
        height: 48px;
        border-radius: 33px;
        position: relative;
        border: 2px solid #1D9752;
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: #1D9752;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        align-content: space-around;
    }

    .cricle span {
        position: absolute;
        left: 50%;
        right: 50%;
        top: 120%;
    }

    .line-step {
        height: 1px;
        width: 100px;
        border-top: 2px solid #D8D8D8;
    }

    .line-step-green {
        height: 1px;
        width: 100px;
        border-top: 2px solid #1D9752;
    }

    .step-content-1 {
        width: 100%;
        margin: auto;
    }

    .step-content-2 {
        width: 1184px;
        height: 35px;
        margin: auto;
        display: flex;
        flex-direction: row;
    }

    .step-content-2 span {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #676767;
    }

    .child {
        display: flex;
        width: 150px;
        justify-content: center;
        align-items: center;
    }

    .header-content {
        margin-bottom: 35px;

    }

    .btn-green {
        padding: 8px 16px;
        margin-left: 16px;
        width: 130px;
        height: 40px;
        background: #1D9752;
    }


    @media screen and (max-width:500px) {
        .header-step {
            overflow-y: hidden;
            overflow-x: scroll;
        }

        .step-content {
            width: 1136px;
        }

        .cricle {
            width: 40px;
            height: 40px;
            font-size: 15px;
        }

        .cricle-green {
            width: 40px;
            height: 40px;
            font-size: 15px;
        }

        .step-content-2 {
            width: 1136px;
            height: 35px;
            margin: auto;
            display: flex;
            flex-direction: row;
        }

        .img-box img {
            height: 93%;
            width: 86%;
        }
    }

    @media screen and (min-width: 501px) and (max-width:1440px) {
        .header-step {
            overflow-y: hidden;
            overflow-x: scroll;
        }

        .step-content-2 {
            width: 1200px;
            height: 35px;
            margin: auto;
            display: flex;
            flex-direction: row;
        }

        .step-content {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            width: 1200px;
            margin: auto;
            padding-top: 16px;
        }

        .img-box img {
            width: 67%;
        }
    }

    @media screen and (min-width:1024px) and (max-width:1440px) {
        .header-step {
            overflow-y: hidden;
            overflow-x: scroll;
        }

    }

    @media screen and (min-width:1441px) {
        .steps {
            background: #fff;
            padding: 24px 16px;
            border-radius: 8px;
            margin: 24px 0px;
        }

        .steps p {
            color: #3B3B3B;
            font-weight: 600;
            font-size: 16px;
            line-height: 20px;
            margin: 0px;
        }

        .step-content {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            width: 90%;
            margin: auto;
            padding-top: 16px;
        }

        .header-step {
            display: block;
            width: 1500px;
            overflow-x: scroll;

        }

        .cricle {
            width: 59px;
            height: 48px;
            border-radius: 33px;
            position: relative;
            border: 2px solid #D8D8D8;
            font-style: normal;
            font-weight: 600;
            font-size: 16px;
            line-height: 20px;
            color: #676767;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-content: space-around;
        }

        .cricle-green {
            width: 59px;
            height: 48px;
            border-radius: 33px;
            position: relative;
            border: 2px solid #1D9752;
            font-style: normal;
            font-weight: 600;
            font-size: 16px;
            line-height: 20px;
            color: #1D9752;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-content: space-around;
        }

        .cricle span {
            position: absolute;
            left: 50%;
            right: 50%;
            top: 120%;
        }

        .line-step {
            height: 1px;
            width: 170px;
            border-top: 2px solid #D8D8D8;
        }

        .line-step-green {
            height: 1px;
            width: 170px;
            border-top: 2px solid #1D9752;
        }

        .step-content-1 {
            width: 100%;
            margin: auto;
        }

        .step-content-2 {
            width: 1498px;
            height: 35px;
            margin: auto;
            display: flex;
            flex-direction: row;
        }

        .step-content-2 span {
            font-style: normal;
            font-weight: 400;
            font-size: 14px;
            line-height: 16px;
            color: #676767;
        }

        .child {
            display: flex;
            width: 186px;
            justify-content: center;
            align-items: center;
        }
    }

    @media screen {}
</style>
<style type="text/css">
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

    tr{
        height: 40px;
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

    .allotment-confirmed {
        border: solid 1px #1D9752;
        color: #1D9752;
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 5px;
        font-size: 12px;
        cursor: pointer;
    }

    .allotment-confirmed:hover {
        color: white;
        background-color: #1D9752;
    }

    .history{
        margin-top:24px ;
    }

    .height-input{
        height:40px
    }

    .remove{
        background: #C70404 !important;
        color: #FFFFFF !important
    }

    .table-fixed{
        width: 100%;
    }
    .scroll1{
        height:200px;
        overflow-y:auto;
        width: 100%;
    }
    /* .scroll1,.scroll2,.scroll3{
        display:block;
    } */

    select {
  /* for Firefox */
  -moz-appearance: none;
  /* for Chrome */
  -webkit-appearance: none;
}
</style>
@endsection

@section('content')
<div id="loading" class="theloading hidden">
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
</div>
<div class="content flex-column flex-sm-row header-content" style="margin-top: 20px;">
    <div class="content-title">
        <h1 class="TitleH1">Chi tiết yêu cầu ấn phẩm</h1>
    </div>
    <div class="content-btn text-center">
        <button id="back-page" type="button" class="btnn-prev" style="margin-right: 16px;">
            Trở về
            <i class="fa fa-arrow-left distance" aria-hidden="true"></i>
        </button>
        @if($editButton)
        <button id="edit-tradeOrder" type="button" class="btnn-submit" action="edit">
            Chỉnh sửa
            <i class="fa fa-pencil-square-o distance" aria-hidden="true"></i>
        </button>
        @endif
        @if($approvedButton)
        <button id="approved-tradeOrder" type="button" class="btnn-submit update-status" action="approved"
        data-title="Duyệt yêu cầu"
        data-confirm="Bạn có chắc chắn muốn 'Duyệt' yêu cầu ấn phẩm này không ?"
        >
            Duyệt
            <i class="fa fa-check distance" aria-hidden="true"></i>
        </button>
        @endif
        @if($sentApproveButton)
        <button id="sent-approve-tradeOrder" type="button" class="btnn-submit update-status" action="sentApprove"
        data-title="Gửi duyệt"
        data-confirm="Bạn có chắc chắn muốn 'Gửi duyệt' yêu cầu ấn phẩm này không ?"
        >
            Gửi duyệt
            <i class="fa fa-arrow-up distance" aria-hidden="true"></i>
        </button>
        @endif
        @if($returnedButton)
        <button id="returned-tradeOrder" type="button" class="btnn-prev update-status" action="returned " style="margin-right: 15px"
        data-title="Trả về"
        data-confirm="Bạn có chắc chắn muốn 'Trả về' yêu cầu ấn phẩm này không ?"
        data-note="1"
        >
            Trả về
            <i class="fa fa-undo distance" aria-hidden="true"></i>
        </button>
        @endif
        @if($cancelButton)
        <button id="canceled-tradeOrder" type="button" class="btnn-cancel update-status" action="canceled"
        data-title="Huỷ yêu cầu"
        data-confirm="Bạn có chắc chắn muốn 'Huỷ' yêu cầu ấn phẩm này không ?"
        data-note="1"
        >
            Huỷ
            <i class="fa fa-times distance" aria-hidden="true"></i>
        </button>
        @endif
        @if($addBudgetEstimates)
        <button type="button" class="btnn-bugdet-estimates budget-estimates budget-estimates-add" action="add">
            Thêm vào ngân sách dự toán&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"></i>
        </button>
        @endif
        @if($removeBudgetEstimates)
        <button type="button" class="btnn-bugdet-estimates budget-estimates budget-estimates-remove height-input remove" action="remove">
            Bỏ khỏi dự toán ngân sách
            <i class="fa fa-minus" aria-hidden="true"></i>
        </button>
        @endif
    </div>
</div>
<div class="steps">
    <p>Tiến trình xử lý</p>
    <div class="header-step">
        <div class="step-content">
            <div class="@if($tradeOrder['progress'] >= 1) cricle-green @else cricle @endif">1
            </div>
            <div class="@if($tradeOrder['progress'] >= 1) line-step-green @else line-step @endif"></div>
            <div class="@if($tradeOrder['progress'] > 2) cricle-green @else cricle @endif">2
            </div>
            <div class="@if($tradeOrder['progress'] > 2) line-step-green @else line-step @endif"></div>
            <div class="@if($tradeOrder['progress'] > 3) cricle-green @else cricle @endif">3
            </div>
            <div class="@if($tradeOrder['progress'] > 3) line-step-green @else line-step @endif"></div>
            <div class="@if($tradeOrder['progress'] > 4) cricle-green @else cricle @endif">4
            </div>
            <div class="@if($tradeOrder['progress'] > 4) line-step-green @else line-step @endif"></div>
            <div class="@if($tradeOrder['progress'] > 5) cricle-green @else cricle @endif">5
            </div>
            <div class="@if($tradeOrder['progress'] > 5) line-step-green @else line-step @endif"></div>
            <div class="@if($tradeOrder['progress'] > 6) cricle-green @else cricle @endif">6
            </div>
            <div class="@if($tradeOrder['progress'] > 6) line-step-green @else line-step @endif"></div>
            <div class="@if($tradeOrder['progress'] > 7) cricle-green @else cricle @endif">7
            </div>
            <div class="@if($tradeOrder['progress'] > 7) line-step-green @else line-step @endif"></div>
            <div class="@if($tradeOrder['progress'] >= 8) cricle-green @else cricle @endif">8
            </div>
        </div>
        <div class="step-content-1">
            <div class="step-content-2">
                <div class="child">
                    <span>Tạo yêu cầu ấn phẩm</span>
                </div>
                <div class="child">
                    <span>ASM duyệt</span>
                </div>
                <div class="child">
                    <span>RSM duyệt</span>
                </div>
                <div class="child">
                    <span>GDKD, MKT duyệt</span>
                </div>
                <div class="child">
                    <span>CFO duyệt</span>
                </div>
                <div class="child">
                    <span>CEO duyệt</span>
                </div>
                <div class="child">
                    <span>Mua sắm</span>
                </div>
                <div class="child">
                    <span>PGD nghiệm thu</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content1">
    <h2 class="titleH2">Thông tin chung </h2>
    <div class="row">
        <div class="col-md-4 col-xs-12 col-sm-6">
            <div class="content2-div-1">
                <label class="label-text">Tên kế hoạch</label>
                <input id="plan-name" class="form-control" type="text" placeholder="Nhập" name="plan_name" value="{{$tradeOrder['plan_name']}}" disabled>
            </div>
        </div>
        <div class="col-md-4 col-xs-12 col-sm-6">
            <div class="content2-div-1">
                <label class="label-text">Chi Tiết kế hoạch Trade MKT</label>
                <div class="content1-input d-flex justify-content-between align-items-center height-input">
                    <a href="{{$tradeOrder['plan_file']}}">Download</a>
                    <input class="icon text-link form-control" type="hidden" name="plan_file">
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xs-12 col-sm-6">
            <div class="content2-div-1">
                <label class="label-text">Mục tiêu thúc đẩy</label>
                <div class="content1-input d-flex justify-content-between align-items-center height-input">
                    <select id="motivating-goals" multiple="multiple" name="motivating_goal" class="form-select" disabled>
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
        </div>
        <div class="col-md-4 col-xs-12 col-sm-6">
            <div class="content2-div-1">
                <label class="label-text">Phòng giao dịch</label>
                <input type="text" id="stores" class="form-control" name="store_id" disabled
                    value="{{$tradeOrder['store_name']}}"
                />
            </div>
        </div>
        <div class="col-md-4 col-xs-12 col-sm-6">
            <div class="content2-div-1">
                <label class="label-text">Người tạo</label>
                <input id="created_by" class="form-control" type="text" placeholder="Nhập" name="created_by" value="{{$tradeOrder['created_by']}}" disabled>
            </div>
        </div>
        <div class="col-md-4 col-xs-12 col-sm-6">
            <div class="content2-div-1">
                <label class="label-text">Ngày tạo</label>
                <input id="created_at" class="form-control" type="text" placeholder="Nhập" name="created_at" value="{{date('d-m-Y', $tradeOrder['created_at'])}}" disabled>
            </div>
        </div>
        <div class="col-md-4 col-xs-12 col-sm-6">
            <div class="content2-div-1">
                <label class="label-text">Trạng thái</label>
                <input id="statusLabel" class="form-control" type="text" style="color: #1D9752 !important; font-weight: 600; font-size: 16px;" placeholder="Nhập" name="statusLabel" value="{{$statusLabel}}" disabled>
            </div>
        </div>
    </div>
</div>
<div class="content3">
    <div class="content3-title">
        <h2 class="titleH3">Danh sách ấn phẩm yêu cầu </h2>
    </div>
    @if ($itemsTableView)
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr class="background-tr">
                    <th scope="col">STT</th>
                    <th scope="col">Mã ấn phẩm</th>
                    <th scope="col">Hạng mục</th>
                    <th scope="col">Mục tiêu triển khai</th>
                    <th scope="col">Tên ấn phẩm</th>
                    <th scope="col">Loại ấn phẩm</th>
                    <th scope="col">Quy cách</th>
                    <th scope="col">Ảnh mô tả</th>
                    <th scope="col">Số lượng</th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1; ?>
                @foreach($tradeOrder['items'] as $key => $tableItem)
                <tr data-id="{{$tradeOrder['key']}}">
                    <td>{{$count++}}</td>
                    <td>{{$tableItem['item_code']}}</td>
                    <td>
                        @foreach($categories as $key => $value)
                        @if ($tableItem['category'] == $key)
                        {{$value}}
                        @endif
                        @endforeach
                    </td>
                    <td>
                        @foreach($implementationGoals as $key => $value)
                        @if ($tableItem['implementation_goal'] == $key)
                        {{$value}}
                        @endif
                        @endforeach
                    </td>
                    <td>{{$tableItem['item_name']}}</td>
                    <td>{{$tableItem['item_type']}}</td>
                    <td>{{$tableItem['item_specifications']}}</td>
                    <td>
                        <a href="#" class="lisence" data-path={{json_encode($tableItem['item_path'])}}>Xem ảnh
                        </a>
                    </td>
                    <td>{{$tableItem['item_quantity']}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div id="trade-items" class="content3-div">
        @foreach($tradeOrder['items'] as $key => $item)
        <div class="row row-content3 shadow-sm mb-4 bg-white rounded block" data-id="{{$item['key']}}">
            <div class="col-md-12 col-xs-12 col-sm-12 hidden" style="text-align: right;">
                <button id="removeBlock" type="button" class="btn removeBlock" style="background: #F4CDCD"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="col-md-9 col-xs-12 col-sm-12">
                <div class="row">
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Hạng mục</h4>
                        <select id="category" class="form-select category" name="category" disabled>
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
                        <h4 class="content2-h4">Mục tiêu triển khai</h4>
                        <select id="implementationGoals" class="form-select implementationGoals" name="implementation_goal" disabled>
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
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Tên ấn phẩm</h4>
                        <select id="trade-item-name" class="form-select trade-item-name" name="item_id" disabled>
                            <option value=""></option>
                            @foreach($items as $key => $tradeItem)
                            @if(in_array($item['category'], (array)$tradeItem['category']) && in_array($item['implementation_goal'], (array)$tradeItem['target_goal']))
                            <option data-type="{{$tradeItem['detail']['type']}}" data-spec="{{$tradeItem['detail']['specification']}}" value="{{$tradeItem['_id']}}" data-path={{json_encode($tradeItem['path'])}} @if($tradeItem['_id']==$item['item_id']) selected @endif>{{$tradeItem['detail']['name']}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Loại ấn phẩm</h4>
                        <select id="trade-type" class="form-select trade-type" name="item_type" disabled>
                            <option value="">-- Chọn loại ấn phẩm --</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Quy cách</h4>
                        <select id="trade-spec" class="form-select trade-spec" name="item_specifications" disabled>
                            <option value="">-- Chọn quy cách --</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Số lượng</h4>
                        <input type="text " class="form-control" placeholder="1000" name="item_quantity" value="{{$item['item_quantity']}}" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Khu vực triển khai</h4>
                        <textarea class="tea" name="item_area" class="form-control" rows="4" placeholder="Khu vực chợ Nhổn" disabled>{{$item['item_area']}}</textarea>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Mục tiêu khách hàng</h4>
                        <textarea class="tea" name="item_target_customers" class="form-control" rows="4" placeholder="Tiểu thương" disabled>{{$item['item_target_customers']}}</textarea>
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
                    <h5 data-fancybox-trigger="gallery-{{$item['key']}}" class="underline cursor-pointer xt">+{{count($item['item_path'])}}
                    </h5>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
        <div id="appendEl" class="row row-content3 shadow-sm p-3 mb-4 bg-white rounded hidden">
            <div class="col-md-12 col-xs-12 col-sm-12" style="text-align: right;">
                <button id="removeBlock" type="button" class="btn removeBlock" style="background: #F4CDCD"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="col-md-9 col-xs-12 col-sm-12">
                <div class="row">
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Hạng mục</h4>
                        <select id="category" class="form-select category" name="category">
                            <option value="">-- Chọn hạng mục --</option>
                            @foreach($categories as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Mục tiêu triển khai</h4>
                        <select id="implementationGoals" class="form-select implementationGoals" name="implementation_goal">
                            <option value="">-- Chọn mục tiêu triển khai --</option>
                            @foreach($implementationGoals as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Tên ấn phẩm</h4>
                        <select id="trade-item-name" class="form-select trade-item-name" name="item_id">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Loại ấn phẩm</h4>
                        <select id="trade-type" class="form-select trade-type" name="item_type">
                            <option value="">-- Chọn loại ấn phẩm --</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Quy cách</h4>
                        <select id="trade-spec" class="form-select trade-spec" name="item_specifications">
                            <option value="">-- Chọn quy cách --</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Số lượng</h4>
                        <input type="text " class="form-control" placeholder="1000" name="item_quantity">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Khu vực triển khai</h4>
                        <textarea class="tea" name="item_area" class="form-control" rows="4" placeholder="Khu vực chợ Nhổn"></textarea>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <h4 class="content2-h4">Mục tiêu khách hàng</h4>
                        <textarea class="tea" name="item_target_customers" class="form-control" rows="4" placeholder="Tiểu thương"></textarea>
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
        </div>
    </div>
    <div class="content3-btn">
        <button id="appendBlock" type="button" class="btn btn-outline-success btnnn hidden">Thêm ấn phẩm</button>
    </div>
    @endif
</div>
@if ($itemsTableView)
<div class="content3">
    <div class="content3-title">
        <h2 class="titleH3">Danh sách ấn phẩm được phân bổ</h2>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr class="background-tr">
                    <th scope="col">STT</th>
                    <th scope="col">Tên ấn phẩm</th>
                    <th scope="col">Loại ấn phẩm</th>
                    <th scope="col">Quy cách</th>
                    <th scope="col">Số lượng yêu cầu</th>
                    <th scope="col">Số lượng đã nhập kho</th>
                    <th scope="col">Số lượng còn lại</th>
                </tr>
            </thead>
            <tbody>
                @if ($requestAllotment)
                <?php $count = 1; ?>
                @foreach($requestAllotment as $rAValue)
                @if(!$showAllAllotmentItems && (($rAValue['item_quantity'] - $rAValue['received_amount']) <= 0)) @continue @endif <tr>
                    <td>{{$count++}}</td>
                    <td>{{$rAValue['item_name']}}</td>
                    <td>{{$rAValue['item_type']}}</td>
                    <td>{{$rAValue['item_specifications']}}</td>
                    <td>{{number_format($rAValue['item_quantity'], 0)}}</td>
                    <td>{{number_format($rAValue['received_amount'], 0)}}</td>
                    <td>{{number_format(($rAValue['item_quantity'] - $rAValue['received_amount']), 0)}}</td>
                    </tr>
                    @endforeach
                    @endif
            </tbody>
        </table>
    </div>
</div>

<div class="content3">
    <div class="content3-title">
        <h2 class="titleH3">Lịch sử phân bổ và nhận hàng </h2>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr class="background-tr">
                    <th scope="col">STT</th>
                    <th scope="col">Ngày phân bổ</th>
                    <th scope="col">Tên ấn phẩm</th>
                    <th scope="col">Loại ấn phẩm</th>
                    <th scope="col">Quy cách</th>
                    <th scope="col">Số lượng</th>
                    <th scope="col">Chứng từ</th>
                    <th scope="col">Người nhận</th>
                    <th scope="col">Ngày nhận</th>
                    <th scope="col">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                @if ($logsAllotment)
                <?php $count = 1; ?>
                @for($allotmentKey = count($logsAllotment) - 1; $allotmentKey >= 0; $allotmentKey--)
                @if(!$showAllAllotmentItems && !empty($logsAllotment[$allotmentKey]['isConfirmed']))
                @continue
                @endif
                <tr data-id="{{$logsAllotment[$allotmentKey]['key']}}">
                    <td>{{$count++}}</td>
                    <td>{{date('d/m/Y', $logsAllotment[$allotmentKey]['created_at'])}}</td>
                    <td>{{$logsAllotment[$allotmentKey]['item_name']}}</td>
                    <td>{{$logsAllotment[$allotmentKey]['type']}}</td>
                    <td>{{$logsAllotment[$allotmentKey]['specification']}}</td>
                    <td>{{number_format($logsAllotment[$allotmentKey]['quantity_import'], 0)}}</td>
                    @if(!empty($logsAllotment[$allotmentKey]['path']))
                    <td><a class="show-img-action" href="#" data-value="{{$logsAllotment[$allotmentKey]['path']}}">Xem ảnh</a></td>
                    @else
                    <td></td>
                    @endif
                    @if(!empty($logsAllotment[$allotmentKey]['confirmed_by']))
                    <td>{{$logsAllotment[$allotmentKey]['confirmed_by']}}</td>
                    @else
                    <td></td>
                    @endif
                    @if(!empty($logsAllotment[$allotmentKey]['confirmed_at']))
                    <td>{{date('d/m/Y', $logsAllotment[$allotmentKey]['confirmed_at'])}}</td>
                    @else
                    <td></td>
                    @endif
                    @if(!empty($logsAllotment[$allotmentKey]['isConfirmed']))
                    <td>Đã nhập kho</td>
                    @else
                        @if($allotmentConfirmedBtn)
                        <td>
                            <a class="allotment-confirmed" data-id="{{$logsAllotment[$allotmentKey]['key']}}" data-name="{{$logsAllotment[$allotmentKey]['item_name']}}" data-type="{{$logsAllotment[$allotmentKey]['type']}}" data-specification="{{$logsAllotment[$allotmentKey]['specification']}}" data-quantity="{{$logsAllotment[$allotmentKey]['quantity_import']}}" data-target="#allotment-modal">
                                Nhập kho
                            </a>
                        </td>
                        @endif
                    @endif
                </tr>
                @endfor
                @endif
            </tbody>
        </table>
    </div>
</div>
@endif
<!-- <div class="content5 mt-4 mb-5">
    <div>
        <button id="saveRequest" type="button" class="btn btn-success btnnn mr-4 hidden">Lưu</button>
        <button id="cancelRequest" type="button" class="btn btn-danger btnnn hidden">Hủy</button>
    </div>
    <button id="approveRequest" type="button" class="btn btn-success btnnn hidden" data-toggle="modal" data-target="#exampleModal">Gửi duyệt</button>
</div> -->

<!-- Log view -->
<div class="history">
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
                <!-- <a id="redirect-url" class="btn btn-primary">Xem</a> -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="successModal2" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" style="height: auto !important;">
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
<div class="modal fade" id="show-img-modal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" style="height: auto !important;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div id="modal-content" class="modal-body">

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalLisence" data-bs-keyboard="true" tabindex="-1" aria-hidden="true" style="height: auto !important;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Ảnh</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body show_img">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addBudgetEstimatesModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" style="height: auto !important;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Thêm vào ngân sách dự toán</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6" style="text-align: left;">
                        <label>Ngân sách dự toán <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6" style="text-align: right;">
                        <label class="col-md-6 col-sm-6 col-xs-6">Ngân sách mới</label>
                        <input type="checkbox" class="form-check-input" name="add_new" style="float: right; margin-left: 5px;">
                    </div>
                </div>
                <select id="budget-estimates-select" name="budget_estimates" class="form-select">
                    @foreach($budgetEstimates as $value)
                    <option value="{{$value['_id']}}">{{$value['name']}}</option>
                    @endforeach
                </select>
                <input type="text" class="hidden form-control" name="new_item" placeholder="Nhập">
            </div>
            <div class="modal-footer">
                <div class="row" style="width: 100%">
                    <div class="col-md-6 col-sm-6 col-xs-6 col-6" style="text-align: left;">
                        <button type="button" class="btn btn-cancel" style="width: 100%; max-width: 200px;" data-bs-dismiss="modal">Hủy</button>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 col-6" style="text-align: right;">
                        <button type="button" class="btn btn-submit" style="width: 100%; max-width: 200px;">Thêm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="allotment-modal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" style="height: auto !important;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Nhập kho PGD</h5>
            </div>
            <div class="modal-body" style="text-align: left;">
                <p id="item-name" style="margin-bottom: 0; font-weight: 600; font-size: 14px;"></p>
                <p id="item-type" style="margin-bottom: 0; font-size: 10px;"></p>
                <p id="item-spec" style="margin-bottom: 0; font-size: 10px;"></p>
                <label style="margin-top: 7px; font-size: 14px;">Số lượng</label>
                <input id="quantity" type="text" class="form-control" name="quantity" disabled>
                <label style="margin-top: 7px; font-size: 14px;">Chứng từ <span class="text-danger">*</span></label>
                <div class="content1-input d-flex justify-content-between align-items-center">
                    <input id="upload" style="width: 100%" class="icon text-link" type="file" accept="image/*">
                    <i class="fa fa-upload icon" aria-hidden="true"></i>
                </div>
                <input id="allotment-path" class="icon text-link" type="hidden" name="allotment_path">
                <input id="allotment-id" type="hidden" class="form-control" name="item_id" disabled>
            </div>
            <div class="modal-footer">
                <div class="row" style="width: 100%">
                    <div class="col-md-6 col-sm-6 col-xs-6 col-6" style="text-align: left;">
                        <button type="button" class="btn btn-cancel" style="width: 100%; max-width: 200px;" data-bs-dismiss="modal">Hủy</button>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 col-6" style="text-align: right;">
                        <button type="button" id="allotment-submit" class="btn btn-submit" style="width: 100%; max-width: 200px;">Xác nhận</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
<script type="text/javascript" src="{{ asset('viewcpanel/js/autocomplete.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script type="text/javascript">
    const csrf = "{{ csrf_token() }}";
    $(document).ready(function() {
        $('#motivating-goals').multiselect({
            templates: {
                button: '<button style="border: 1px solid #D8D8D8;border-radius: 5px;outline: none;padding: 0px 5px;color:#676767;" type="button" class="multiselect dropdown-toggle button_target_goal" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span></button>'
            },
            // enableFiltering: true,
        });
        var items = @json($items);


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
        $("#stores").on('change', function() {
            const storeId = $(this).val();
            const formData = {
                store_id: storeId
            };
            console.log(formData);
            getTradeItems(formData);
            $(".trade-item-name").html('<option value=""></option>');
            $(".category").val("");
            $(".implementationGoals").val("");
        });

        $("#trade-items").on("change", ".implementationGoals, .category", function(e) {
            let _el = $(e.target).closest(".block");
            let categoryEl = $(_el).find("#category");
            let implementationGoalsEl = $(_el).find("#implementationGoals");
            let _category = $(categoryEl).val();
            let _implementationGoal = $(implementationGoalsEl).val();
            let targetEl = $(_el).find("#trade-item-name");
            let option = '<option value=""></option>';
            console.log(_category, _implementationGoal)
            for (let i = 0; i < items.length; i++) {
                let existsCategory = $.inArray(_category, items[i]['category']) > -1;
                let existsImplementationGoal = $.inArray(_implementationGoal, items[i]['target_goal']) > -1;
                if (existsCategory && existsImplementationGoal) {
                    let _tradeId = items[i]['_id'];
                    let _tradeType = items[i]['detail']['type'];
                    let _tradeName = items[i]['detail']['name'];
                    let _tradePath = JSON.stringify(items[i]['path']);
                    let _tradeSpec = items[i]['detail']['specification'];
                    option += '<option data-type="' + _tradeType + '" data-spec="' + _tradeSpec + '" data-path=' + _tradePath + ' value="' + _tradeId + '">' + _tradeName + ' - ' + _tradeType + ' - ' + _tradeSpec + '</option>';
                }

            }
            $(_el).find("#trade-type").html('<option value="">-- Chọn loại ấn phẩm --</option>');
            $(_el).find("#trade-spec").html('<option value="">-- Chọn quy cách --</option>');
            $(targetEl).html(option)
        });

        $("#trade-items").on("change", ".trade-item-name", function(e) {
            let _el = $(e.target).closest(".block");
            let tradeTypeEl = $(_el).find("#trade-type");
            let tradeSpecEl = $(_el).find("#trade-spec");
            let tradePathEl = $(_el).find(".image");

            let _tradeType = $(e.target).find(":selected").attr("data-type");
            let _tradeSpec = $(e.target).find(":selected").attr("data-spec");
            let __tradePath = [];
            if ($(e.target).find(":selected").val()) {
                _tradePath = JSON.parse($(e.target).find(":selected").attr("data-path"));
            }
            let optionType = '<option value="' + _tradeType + '" selected>' + _tradeType + '</option>';
            let optionSpec = '<option value="' + _tradeSpec + '" selected>' + _tradeSpec + '</option>';
            let dataId = $(_el).attr('data-id');
            let optionPath = '<img src="' + _tradePath[0] + '" alt="" data-fancybox-trigger="gallery-' + dataId + '" class="underline cursor-pointer">';
            optionPath += '<div style="display:none">';
            for (let i = 0; i < _tradePath.length; i++) {
                optionPath += '<a data-fancybox="gallery-' + dataId + '" href="' + _tradePath[i] + '"><img class="rounded" src="' + _tradePath[i] + '"/></a>';
            }
            optionPath += '</div><h5 data-fancybox-trigger="gallery-' + dataId + '" class="underline cursor-pointer xt">+' + _tradePath.length + '</h5>';
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

        $("#appendBlock").on("click", function() {
            let el = $("#appendEl").clone();
            el.removeClass("hidden");
            el.addClass("block");
            el.attr("id", "block");
            $("#appendEl").before(el);
        });

        $("#trade-items").on("click", ".removeBlock", function(e) {
            let _el = $(e.target).closest(".block");
            $(_el).remove();
        })
    });
</script>
<script type="text/javascript">
    $("#upload").on('change', function() {
        var file = $(this)[0].files[0];
        const fileType = file['type'];
        console.log(fileType);
        const validImageTypes = ['image/gif', 'image/jpeg', 'image/png'];
        if (!validImageTypes.includes(fileType)) {
            $("#errorModal").find(".msg_error").text("File không đúng định dạng ảnh, vui lòng thử lại!");
            $("#errorModal").modal('show');
            return;
        } else {
            let callback = (path) => {
                $('input[name="allotment_path"]').val(path);
            }
            uploadPlan(file, callback);
        }
    });
    $("#uploadPlan").on('change', function() {
        var file = $(this)[0].files[0];
        let extension = file.name.split('.').pop();
        if (extension !== 'xlsx' && extension !== 'xls') {
            $("#errorModal").find(".msg_error").text("File không đúng định dạng xlsx, xls. Vui lòng thử lại!");
            $("#errorModal").modal('show');
            return;
        } else {
            let callback = (path) => {
                $('input[name="plan_file"]').val(path);
            }
            uploadPlan(file, callback);

        }
    });
    /**
     * Service upload file
     * */
    const uploadPlan = async function(file, callback) {
        $("#loading").removeClass('hidden');
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
        $("#loading").addClass('hidden');
        console.log(responseJson);
        if (responseJson && responseJson.status == 200) {
            callback(responseJson.path)
        } else {
            let message = "Upload file thất bại, vui lòng thử lại!";
            if (responseJson.message) {
                message = responseJson.message;
            }
            $("#allotment-modal").modal('hide');
            $("#errorModal").find(".msg_error").text(message);
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

        } else {
            if (response.errors) {
                $.each(response.errors, function(key, value) {
                    let splitKey = key.split(".");
                    let el = $("[name='" + splitKey[0] + "']");
                    if (splitKey.length > 2) {
                        let block = $('[data-id="' + splitKey[1] + '"]');
                        el = block.find("[name='" + splitKey[2] + "']");
                    }
                    if (el.attr('name') == 'motivating_goal' || el.attr('name') == 'plan_file') {
                        el.closest('div').addClass('border-red');
                        el.closest('div').after('<span class="invalid">' + value[0] + '</span>');
                    } else {
                        el.addClass('border-red');
                        el.after('<span class="invalid">' + value[0] + '</span>');
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
    const SaveData = async function(data, url, callback) {
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
        $("#loading").addClass('hidden');
        callback(result);
    }
    const CollectData = function() {
        let data = {
            store_id: $("#stores").val(),
            plan_name: $("#plan-name").val(),
            motivating_goal: $("#motivating-goals").val(),
            plan_file: $("[name='plan_file']").val(),
            items: []
        }
        let countBlock = 0;
        $(".block").each(function(index, value) {
            let block = $(value);
            block.attr('data-id', countBlock);
            let category = block.find("[name='category']").val();
            let implementation_goal = block.find("[name='implementation_goal']").val();
            let item_id = block.find("[name='item_id']").val();
            let item_quantity = block.find("[name='item_quantity']").val();
            let item_area = block.find("[name='item_area']").val();
            let item_target_customers = block.find("[name='item_target_customers']").val();
            let item = {
                data_id: countBlock,
                category: category,
                implementation_goal: implementation_goal,
                item_id: item_id,
                item_quantity: item_quantity,
                item_area: item_area,
                item_target_customers: item_target_customers
            }
            data.items[countBlock] = item;
            countBlock++;
        });
        return data;
    }

    $("#saveRequest").on("click", function(e) {
        e.preventDefault();
        $("#saveRequest").attr("disabled", "disabled");
        let data = CollectData();
        SaveData(data, '{{$orderUrl}}', validateCallback);
        $("#saveRequest").removeAttr("disabled");

    });
    $("#approveRequest").on("click", function(e) {
        e.preventDefault();
        $("#approveRequest").attr("disabled", "disabled");
        let data = CollectData();
        SaveData(data, '{{$sentFirstApproveUrl}}', validateCallback);
        $("#approveRequest").removeAttr("disabled");
    });
</script>
<script type="text/javascript">
    const updateStatus = async function(data, url, callback) {
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
        $("#loading").addClass('hidden');
        callback(result);
    }

    $(".update-status").on("click", function(e) {
        e.preventDefault();
        let action = $(this).attr('action');
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

    $("#confirm-modal").on("click", "#confirmed", function(e) {
        $("#confirm-modal").modal('hide');
        let data = {
            'action': $("#confirm-modal").find("input[name='action']").val(),
            'note' : $("#confirm-modal").find("#modal-note").val()
        }
        console.log(data);
        let updateStatusCallback = function(response) {
            if (response.status == 200) {
                $("#successModal").find(".msg_success").text(response.message);
                // $("#successModal").find("#redirect-url").attr("href", response.targetUrl);
                $("#successModal").modal('show');
                // setTimeout(function(){window.location.href = response.targetUrl;}, 2000);
                Redirect(response.targetUrl, 2000);
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
        updateStatus(data, '{{$updateStatusUrl}}', updateStatusCallback);
    });
</script>
<script type="text/javascript">
    $("#edit-tradeOrder").on("click", function(e) {
        console.log("here");
        e.preventDefault();
        // window.location.href = '{{$editUrl}}';
        Redirect('{{$editUrl}}', false);
    });
    $("#back-page").on("click", function(e) {
        e.preventDefault();
        // window.location.href = '{{$indexUrl}}';
        Redirect('{{$indexUrl}}', false);
    });
    $(".lisence").click(function(e) {
        $("#modalLisence").find('.show_img').html('');
        e.preventDefault();
        let _el = $(e.target);
        let itemPath = JSON.parse($(_el).attr('data-path'));
        if (itemPath.length > 0) {
            let html = '<img style="width: 100%; height: auto;" src="' + itemPath[0] + '" alt="" class="underline cursor-pointer" data-fancybox-trigger="gallery-modal">';
            html += '<div style="display:none">';
            for (let i = 0; i < itemPath.length; i++) {
                html += '<a data-fancybox="gallery-modal" href="' + itemPath[i] + '"><img class="rounded" src="' + itemPath[i] + '"></a>';
            }

            html += '</div>';
            html += '<h5 data-fancybox-trigger="gallery-modal" class="underline cursor-pointer xt">+' + itemPath.length + '</h5>';
            $("#modalLisence").find('.show_img').html(html);
        } else {
            $("#modalLisence").find('.show_img').html('<span>Không có ảnh</span>');
        }

        $("#modalLisence").modal('show');
    });
    $(".show_img").click(function() {
        $("#modalLisence").modal('hide');
    });

    const callApi = async function(data, url, callback) {
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
        $("#loading").addClass('hidden');
        callback(result);
    }

    $(".budget-estimates").on("click", function(e) {
        e.preventDefault();
        let action = $(this).attr('action');
        let data = {
            'action': action
        }
        if (action == 'add') {
            $("#addBudgetEstimatesModal").modal("show");
            return;
        }

        const callback = function(response) {
            if (response.status == 200) {
                $("#successModal").find(".msg_success").text(response.message);
                // $("#successModal").find("#redirect-url").attr("href", response.targetUrl);
                $("#successModal").modal('show');
                // setTimeout(function(){window.location.href = response.targetUrl;}, 2000);
                Redirect(response.targetUrl, 2000);
            } else {
                if (response.message) {
                    $("#errorModal").find(".msg_error").text(response.message);
                } else {
                    $("#errorModal").find(".msg_error").text("Có lỗi xảy ra, vui lòng thử lại sau!");
                }
                $("#errorModal").modal('show');
            }
        }
        callApi(data, '{{$updateBudgetEstimateStatusUrl}}', callback)
    });
    $("[name='add_new']").on("change", function(e) {
        let checked = $(this).is(":checked");
        if (checked) {
            $("[name='new_item']").removeClass('hidden');
            $("[name='budget_estimates']").addClass('hidden');
        } else {
            $("[name='new_item']").addClass('hidden');
            $("[name='budget_estimates']").removeClass('hidden');
        }
    })
    $("#addBudgetEstimatesModal .btn-submit").on("click", function() {
        $("#addBudgetEstimatesModal").modal('hide');
        let checked = $("[name='add_new']").is(":checked");
        let data = {};
        if (checked) {
            data = {
                action: 'add',
                budget_estimates_id: "",
                budget_estimates_name: $("[name='new_item']").val()
            }
        } else {
            data = {
                action: 'add',
                budget_estimates_id: $("[name='budget_estimates']").find(":selected").val(),
                budget_estimates_name: $("[name='budget_estimates']").find(":selected").text()
            }
        }
        const callback = function(response) {
            if (response.status == 200) {
                $("#successModal").find(".msg_success").text(response.message);
                // $("#successModal").find("#redirect-url").attr("href", response.targetUrl);
                $("#successModal").modal('show');
                // setTimeout(function(){window.location.href = response.targetUrl;}, 2000);
                Redirect(response.targetUrl, 2000);
            } else {
                if (response.message) {
                    $("#errorModal").find(".msg_error").text(response.message);
                } else {
                    $("#errorModal").find(".msg_error").text("Có lỗi xảy ra, vui lòng thử lại sau!");
                }
                $("#errorModal").modal('show');
            }
        }
        callApi(data, '{{$updateBudgetEstimateStatusUrl}}', callback)
    })
</script>
<script type="text/javascript">
    $(".allotment-confirmed").on("click", function(e) {
        let modal = $(e.target).attr('data-target');
        let itemId = $(e.target).attr('data-id');
        let itemName = $(e.target).attr('data-name');
        let itemType = $(e.target).attr('data-type');
        let itemSpec = $(e.target).attr('data-specification');
        let itemQuantity = $(e.target).attr('data-quantity');
        $(modal).find("#item-name").text(itemName);
        $(modal).find("#item-type").text(itemType);
        $(modal).find("#item-spec").text(itemSpec);
        $(modal).find("#quantity").val(itemQuantity);
        $(modal).find("#allotment-id").val(itemId);
        $(modal).modal('show');
    });
    const allotmentModal = $("#allotment-modal");
    const allotmentSubmit = $("#allotment-submit");
    allotmentSubmit.on('click', () => {
        allotmentModal.modal('hide');
        let itemId = allotmentModal.find('#allotment-id').val();
        let itemPath = allotmentModal.find('#allotment-path').val();
        if (!itemId) {
            $("#errorModal").find(".msg_error").text("Không xác định được đối tượng cần nhập kho");
            $("#errorModal").modal('show');
            return;
        }
        if (!itemPath) {
            $("#errorModal").find(".msg_error").text("Vui lòng upload chứng từ");
            $("#errorModal").modal('show');
            return;
        }
        let data = {
            item_key: itemId,
            item_path: itemPath
        }
        console.log(data);
        let callback = function(response) {
            if (response.status == 200) {
                $("#successModal2").find(".msg_success").text('Nhập kho thành công');
                $("#successModal2").modal('show');
                setTimeout(function() {
                    window.location.reload()
                }, 2000);
                return;
            } else if (response.message) {
                $("#errorModal").find(".msg_error").text(response.message);
                $("#errorModal").modal('show');
                return;
            } else {
                $("#errorModal").find(".msg_error").text('Có lỗi xảy ra vui lòng thử lại sau');
                $("#errorModal").modal('show');
                return;
            }
        }
        confirmedAllotment(data, callback);
    });

    /**
     * Service upload file
     * */
    const confirmedAllotment = async function(data, callback) {
        $("#loading").removeClass('hidden');
        const response = await fetch('{{$confirmedAllotmentUrl}}', {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'x-csrf-token': csrf,
                "Content-Type": "application/json",
                Accept: "application/json",
            }
        });
        const responseJson = await response.json(); //extract JSON from the http response
        $("#loading").addClass('hidden');
        callback(responseJson);

    }

    $(".show-img-action").on('click', function(e) {
        e.preventDefault();
        let path = $(e.target).attr('data-value');
        $("#show-img-modal").find('#modal-content').html('<img style="width: 100%; height: auto;" src="' + path + '"></img>');
        $("#show-img-modal").modal('show');
    })
</script>
@endsection

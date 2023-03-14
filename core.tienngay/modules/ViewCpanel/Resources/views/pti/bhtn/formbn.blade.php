@extends('viewcpanel::layouts.master')

@section('title', 'PTI - Bảo Hiểm Tai Nạn Con Người')

@section('css')
<style type="text/css">

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

  .main-content {
    background-blend-mode: overlay;
    background-image: linear-gradient(to right, rgb(247 247 247), rgb(247 247 247));
    background-repeat: no-repeat;
    background-attachment: scroll;
    min-height: 100vh;
    padding: 50px 10px;
  }

  form {
    margin: 0 auto !important;
    max-width: 750px;
    background-image: linear-gradient(to right, rgb(255 255 255), rgb(255 255 255));
    /*background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);*/
    background-size: 400% 400%;
    animation: gradient 15s ease infinite;
    border-radius: 14px;
    padding: 50px 10px;
    box-shadow: rgb(38, 57, 77) 0px 20px 30px -10px;
  }
  @keyframes gradient {
    0% {
      background-position: 0% 50%;
    }
    50% {
      background-position: 100% 50%;
    }
    100% {
      background-position: 0% 50%;
    }
  }

  label {
    font-weight: 500;
  }

  input, select {
    background-color: rgb(247 247 247) !important;
    border-color: rgb(41 161 33);
    box-shadow: none !important;
    color: rgb(26 38 10) !important;
    border-radius: 7px;
  }
  .under-line {
    text-decoration: underline;
  }

  #progressbar {
    margin: 40px 0px;
    overflow: hidden;
    color: #cbcbcb;
  }
  #progressbar a {
    color: #e4ffe2;
  }

  #progressbar li {
    list-style-type: none;
    font-size: 12px;
    width: 25%;
    float: left;
    position: relative;
    text-align: center;
  }

  .grab {
    cursor: -webkit-grab; 
    cursor: grab;
  }

  #progressbar li:after {
    content: '';
    width: 100%;
    height: 2px;
    background: #cbcbcb;
    position: absolute;
    left: 0;
    top: 25px;
    z-index: -1;
  }

  #progressbar li:before {
    width: 50px;
    height: 50px;
    line-height: 45px;
    display: block;
    font-size: 18px;
    color: #212529;
    background: #cbcbcb;
    border-radius: 50%;
    margin: 0 auto 10px auto;
    padding: 2px;
  }
  #input:before {
    font-family: FontAwesome;
    content: "\f14b";
  }
  #confirm:before {
    font-family: FontAwesome;
    content: "\f14a";
  }
  #payment:before {
    font-family: FontAwesome;
    content: "\f09d";
  }
  #finish:before {
    font-family: FontAwesome;
    content: "\f00c";
  }
  .steps {
    position: relative;
    z-index: 0;
  }
  /*Color number of the step and the connector before it*/
  #progressbar li.active:before, #progressbar li.active:after {
    background: #212529;
    color: white;
  }
  #progressbar .active {
    color: #212529;
  }
  #progressbar a {
    text-decoration: none;
  }
  #progressbar .active a {
    color: #212529;
  }
  #step-input {
    width: 90%;
    margin: 20px auto;
  }
  .confirm-info div {
    padding: 15px 7px;
  }

  .hidden {
    display: none;
  }
  .text-white {
    color: #000;
  }
  .font-w7 {
    font-weight: 700;
  }

  .font-w5 {
    font-weight: 500;
  }

  .text-right {
    text-align: right;
  }
  .boder-bt {
    border-bottom: 1px dashed #b9b9b9;
    padding: 5px;
  }

  .bank-info, .confirm-info {
    border: 1px solid #b9b9b9;
    border-radius: 5px;
    width: 90%;
    margin: 0 auto;
    margin-top: 20px;
  }
  .bank-header, .finish-mes {
    width: 90%;
    margin: 0 auto;
    margin-top: 20px;
    text-align: center;
  }
  .bank-info div, #step-input div {
    padding: 7px 10px;
  }

  .bank-info .bank-val, .finish-mes {
    color: #e3020c;
  }
  #input-confirm, #input-order, #create-new {
    margin: 10px 10px;
    background-color: #212529;
    border-color: #212529;
    width: 45%;
    margin-top: 50px;
  }

  #input-confirm:hover, #input-order:hover {
    background-color: rgb(217 217 217);
    color: #212529;
    border-color: #e4ffe2;
    font-weight: 500;
  }

</style>
@endsection

@section('content')
<section class="main-content">
  <div id="loading" class="theloading" style="display: none;">
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
  </div>
  <form id="formIn" class="g-3">
    <header>
      <h2 class="text-center">Bảo Hiểm Bưu Điện PTI</h2>
      <h4 class="text-center under-line">Đăng Ký Mua Bảo Hiểm Tai Nạn Con Người</h4>
    </header>
    @include('viewcpanel::pti.bhtn.subFormbn.progress')
    @include('viewcpanel::pti.bhtn.subFormbn.stepInput')
    @include('viewcpanel::pti.bhtn.subFormbn.stepConfirm')
    @include('viewcpanel::pti.bhtn.subFormbn.stepPayment')
    @include('viewcpanel::pti.bhtn.subFormbn.stepFinish')
  </form>
  <div class="modal fade" id="errorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
</section>
@endsection

@section('script')
<script type="text/javascript">
  var dob = $("#dob").datepicker( {
      format: "yyyy-mm-dd",
      autoclose: true
  });
  var _token = "{{ csrf_token() }}";
  var orderUrl = "{{ $orderBhtnBN }}";
  var order = @json($order);
  var bankInfo = @json($bankInfo);
  var payment = "{{ $payment }}";
  var checkPaymentUrl = "{{ $checkPaymentUrl }}";
</script>
@if(!empty($stores))
<script type="text/javascript">
  var isPgdBN = true;
</script>
@else
<script type="text/javascript">
  var isPgdBN = false;
</script>
@endif
<script type="text/javascript" src="{{ asset('viewcpanel/js/pti/bhtn.js') }}"></script>
@endsection

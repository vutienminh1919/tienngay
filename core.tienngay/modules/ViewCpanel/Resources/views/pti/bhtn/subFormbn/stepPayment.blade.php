<div id="step-payment" class="step hidden">
  <div class="bank-header">
    <label>Thanh toán khoản vay bằng cách quét QRCode trên app của ngân hàng</label>
  </div>
  <div class="bank-header text-center">
    <img id="qr-final" class="copy-img" width="50%" src="">
  </div>
  <div class="bank-header">
    <label>Hoặc thanh toán khoản vay thông qua tài khoản ngân hàng với nội dung sau</label>
  </div>
  <div class="bank-info row">
    <div class="col-md-6 col-6 boder-bt">
      <label class="form-label">Ngân hàng:</label>
    </div>
    <div class="col-md-6 col-6 boder-bt">
      <label class="form-label bank-name"></label>
    </div>
    <div class="col-md-6 col-6 boder-bt">
      <label class="form-label">Số tài khoản:</label>
    </div>
    <div class="col-md-6 col-6 boder-bt">
      <label class="form-label bank-account"></label>
    </div>
    <div class="col-md-6 col-6 boder-bt">
      <label class="form-label">Chủ tài khoản:</label>
    </div>
    <div class="col-md-6 col-6 boder-bt">
      <label class="form-label bank-account-name"></label>
    </div>
    <div class="col-md-6 col-6 boder-bt">
      <label class="form-label">Số tiền:</label>
    </div>
    <div class="col-md-6 col-6 boder-bt">
      <label class="form-label bank-amount"></label>
    </div>
    <div class="col-md-6 col-6">
      <label class="form-label">Nội dung:</label>
    </div>
    <div class="col-md-6 col-6">
      <label class="form-label bank-description"></label>
    </div>
  </div>
  <div class="col-md-12 text-center">
    <a class="btn btn-primary" id="create-new" href="{{$creNewOrderUrl}}">Tạo đơn mới</a>
  </div>
</div>
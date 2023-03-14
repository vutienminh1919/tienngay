<div id="step-confirm" class="step row hidden">
  <div class="confirm-info row">
    <div class="col-md-6 col-6 boder-bt">
      <label for="name" class="form-label">Tên</label>
    </div>
    <div class="col-md-6 col-6 boder-bt">
      <label class="form-label name-val">Nguyen Van A</label>
    </div>
    <div class="col-md-6 col-6 boder-bt">
      <label for="dob" class="form-label">Năm sinh</label>
    </div>
    <div class="col-md-6 col-6 boder-bt">
      <label class="form-label dob-val">1993/02/31</label>
    </div>
    <div class="col-md-6 col-6 boder-bt">
      <label for="identity" class="form-label">Số cmt/cccd</label>
    </div>
    <div class="col-md-6 col-6 boder-bt">
      <label class="form-label identity-val">0987654321</label>
    </div>
    <div class="col-md-6 col-6 boder-bt">
      <label for="email" class="form-label">Email</label>
    </div>
    <div class="col-md-6 col-6 boder-bt">
      <label class="form-label email-val">example@tienngay.vn</label>
    </div>
    <div class="col-md-6 col-6 boder-bt">
      <label for="phone" class="form-label">Số điện thoại</label>
    </div>
    <div class="col-md-6 col-6 boder-bt">
      <label class="form-label phone-val">0987654321</label>
    </div>
    <div class="col-md-6 col-6 boder-bt">
      <label for="address" class="form-label">Địa chỉ</label>
    </div>
    <div class="col-md-6 col-6 boder-bt">
      <label class="form-label address-val">TienNgay building, ngõ 100 - Dịch Vọng Hậu - Cầu Giấy - Hà Nội</label>
    </div>
    <div class="col-md-6 col-6 boder-bt">
      <label for="address" class="form-label">Chọn gọi bảo hiểm</label>
    </div>
    <div class="col-md-6 col-6 boder-bt">
      <label class="form-label goi-val">GOI1 - 20,000,000</label>
    </div>
    <div class="col-md-6 col-6 boder-bt">
      <label for="address" class="form-label">Phí bảo hiểm</label>
    </div>
    <div class="col-md-6 col-6 boder-bt">
      <label class="form-label phi-val">220,000</label>
    </div>
    @if(!empty($stores))
    <div class="col-md-6 col-6 boder-bt">
      <label for="address" class="form-label">Phòng giao dịch</label>
    </div>
    <div class="col-md-6 col-6 boder-bt">
      <label class="form-label pgd-val">PGD</label>
    </div>
    @endif
    
    <div class="col-md-12">
    <input type="checkbox" id="confirm-1" name="dieu-khoan1" value="Xác nhận không bị động kinh, tâm thần, phong" disabled checked="checked">
    <label class="form-check-label" for="dieu-khoan">
      Xác nhận không bị động kinh, tâm thần, phong;
    </label>
  </div>
  <div class="col-md-12">
    <input type="checkbox" id="confirm-2" name="dieu-khoan2" value="Xác nhận không bị tàn phế hoặc thương tật vĩnh viễn từ 50% trở lên" disabled checked="checked">
    <label class="form-check-label" for="dieu-khoan">
      Xác nhận không bị tàn phế hoặc thương tật vĩnh viễn từ 50% trở lên;
    </label>
  </div>
  </div>
  <div class="col-md-12 text-center">
    <button type="button" id="input-order" class="btn btn-primary">Tạo đơn</button>
  </div>
</div>
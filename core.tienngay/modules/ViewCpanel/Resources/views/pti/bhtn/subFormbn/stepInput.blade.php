<div id="step-input" class="step row">
  <div class="col-md-5">
    <label for="name" class="form-label">Tên<span class="text-danger">*</span></label>
    <input type="text" class="form-control" id="name" name="name">
  </div>
  <div class="col-md-3">
    <label for="dob" class="form-label">Năm sinh<span class="text-danger">*</span></label>
    <input class="form-control" id="dob" name="dob">
  </div>
  <div class="col-md-4">
    <label for="identity" class="form-label">Số cmt/cccd<span class="text-danger">*</span></label>
    <input class="form-control" id="identity" name="identity">
  </div>
  <div class="col-5">
    <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
    <input type="text" class="form-control" id="email" name="email">
  </div>
  <div class="col-7">
    <label for="phone" class="form-label">Số điện thoại<span class="text-danger">*</span></label>
    <input type="text" class="form-control" id="phone" name="phone">
  </div>
  <div class="col-md-12">
    <label for="address" class="form-label">Địa chỉ<span class="text-danger">*</span></label>
    <input type="text" class="form-control" id="address" name="address" placeholder="Số nhà/Tên đường - Xã/Phường - Quận/Huyện - Thành Phố...">
  </div>
  <div class="col-md-5">
    <label for="goi-bh" class="form-label">Chọn gọi bảo hiểm<span class="text-danger">*</span></label>
    <select id="goi-bh" name="goi" class="form-control">
    </select>
  </div>
  <div class="col-md-7">
    <label for="phi-bh" class="form-label">Phí bảo hiểm<span class="text-danger">*</span></label>
    <input type="text" id="phi-bh" name="phi" class="form-control"/ disabled>
  </div>
  @if($stores)
  <div class="col-md-5">
    <label for="goi-bh" class="form-label">Chọn PGD<span class="text-danger">*</span></label>
    <select id="goi-bh" name="pgd" class="form-control">
      <option value="">-- Chọn PGD --</option>
      @foreach ($stores as $store)
      <option value="{{ $store['id'] }}">{{ $store['name'] }}</option>
      @endforeach
    </select>
  </div>
  @endif
  <div class="col-md-12">
    <input type="checkbox" id="confirm-1" name="dieu-khoan1" value="Xác nhận không bị động kinh, tâm thần, phong">
    <label class="form-check-label" for="dieu-khoan">
      Xác nhận không bị động kinh, tâm thần, phong;
    </label>
  </div>
  <div class="col-md-12">
    <input type="checkbox" id="confirm-2" name="dieu-khoan2" value="Xác nhận không bị tàn phế hoặc thương tật vĩnh viễn từ 50% trở lên">
    <label class="form-check-label" for="dieu-khoan">
      Xác nhận không bị tàn phế hoặc thương tật vĩnh viễn từ 50% trở lên;
    </label>
  </div>
  <div class="col-md-12 text-center">
    <button type="button" id="input-confirm" class="btn btn-primary" disabled>Xác nhận</button>
  </div>
</div>
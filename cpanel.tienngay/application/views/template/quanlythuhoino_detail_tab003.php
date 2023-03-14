<div class="row">
  <div class="col-xs-12">
    <br>
    <form class="form-horizontal form-label-left input_mask">
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Mã hợp đồng</label>
        <div class="col-md-6 col-sm-9 col-xs-12">
          <input type="text" class="form-control" value="HD_CHOVAY_OTO_000001" readonly>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Người thanh toán</label>
        <div class="col-md-6 col-sm-9 col-xs-12">
          <input type="text" class="form-control" value="Nguyễn Văn Thanh" >
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tổng tiền phải trả đến hạn</label>
        <div class="col-md-6 col-sm-9 col-xs-12">
          <input type="text" class="form-control" value="10,000,000" readonly>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tiền thanh toán</label>
        <div class="col-md-6 col-sm-9 col-xs-12">
          <input type="text" class="form-control" value="" >
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Phương thức</label>
        <div class="col-md-6 col-sm-9 col-xs-12">
          <div class="form-check" style="padding-top:8px;">
            <input class="form-check-input" type="radio" name="moneyoption" id="moneyoption_cast" value="option1" checked>
            <label class="form-check-label" for="moneyoption_cast">
              Tiền mặt
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="moneyoption" id="moneyoption_banktransfer" value="option2">
            <label class="form-check-label" for="moneyoption_banktransfer">
              Chuyển khoản
            </label>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Ghi chú</label>
        <div class="col-md-6 col-sm-9 col-xs-12">
          <textarea class="form-control" rows="8" cols="80"></textarea>
        </div>
      </div>

      <div class="ln_solid"></div>
      <div class="form-group">
        <div class="col-md-6 col-sm-9 col-xs-12 col-md-offset-3">
          <button type="button" class="btn btn-primary" style="min-width: 125px">Quay lại</button>
          <button type="submit" class="btn btn-success" style="min-width: 125px">Xác nhận thanh toán</button>
        </div>
      </div>
    </form>
  </div>
</div>

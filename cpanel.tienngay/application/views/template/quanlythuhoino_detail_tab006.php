<div class="row form-horizontal form-label-left input_mask">
  <div class="col-xs-12 ">
    <h4>Thông tin</h4>
  </div>
  <div class="col-xs-12 col-lg-6">
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Mã hợp đồng</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input type="text" class="form-control" value="HD_CHOVAY_OTO_000001" readonly>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Khách hàng</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input type="text" class="form-control" value="Nguyễn Văn Thanh" readonly>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Số tiền vay</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input type="text" class="form-control" value="10,000,000" readonly>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Phí phạt</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input type="text" class="form-control" value="10,000,000" >
        </div>
      </div>
  </div>
  <div class="col-xs-12 col-lg-6">
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Ngày giải ngân</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input type="text" class="form-control" value="15/10/2019" readonly>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Số lần gia hạn còn lại</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input type="text" class="form-control" value="1" readonly>
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Lý do</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <textarea class="form-control" rows="3" cols="80"></textarea>
        </div>
      </div>
  </div>


  <div class="col-xs-12">
    <div class="ln_solid"></div>
    <div class="form-group text-right">
      <button type="button" class="btn btn-primary" style="min-width: 125px">Hủy</button>
      <button type="submit" class="btn btn-success" style="min-width: 125px">Gửi yêu cầu</button>
    </div>
  </div>

  <div class="col-xs-12">
    <br>
    <table class="table table-striped thedatatable " style="width:100%">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Ngày gia hạn</th>
          <th scope="col">Lần gia hạn</th>
          <th scope="col">Lý do gia hạn</th>
          <th scope="col">Nhân viên gia hạn</th>
        </tr>
      </thead>
      <tbody>
        <?php for ($i=0; $i < 12; $i++) { ?>
          <tr>
            <th scope="row"><?php echo $i ?></th>
            <td>09/01/2019</td>
            <td>1</td>
            <td>Chưa đủ tiền</td>
            <td>giaodichvien@gmail.com</td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

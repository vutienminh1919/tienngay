<div class="row flex" style="justify-content: center;">
  <div class="col-xs-12  col-md-6">
    <div class="row">
      <div class="col-xs-6">
        Họ và tên
      </div>
      <div class="col-xs-6 text-right">
        <strong>Nguyễn Văn A</strong>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6">
        Khách hàng
      </div>
      <div class="col-xs-6 text-right">
        <strong>Nguyễn Văn An</strong>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6">
        Số CMND / CCCD
      </div>
      <div class="col-xs-6 text-right">
        <strong>123456789</strong>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6">
        Số điện thoại
      </div>
      <div class="col-xs-6 text-right">
        <strong>9876543210</strong>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6">
         Gốc còn lại
      </div>
      <div class="col-xs-6 text-right">
        <strong>100000000</strong>
      </div>
    </div>
  </div>

  <div class="col-xs-12  col-md-6">
    <div class="row">
      <div class="col-xs-6">
        Số tiền vay
      </div>
      <div class="col-xs-6 text-right">
        <strong>HD_CHOVAY_OTO_000001</strong>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6">
        Nhà đầu tư
      </div>
      <div class="col-xs-6 text-right">
        <strong>Vay muon</strong>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6">
        Tổng tiền phải trả đến hạn
      </div>
      <div class="col-xs-6 text-right">
        <strong>18750000</strong>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6">
        Gốc còn lại
      </div>
      <div class="col-xs-6 text-right">
        <strong>100000000</strong>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6">
        Gốc còn lại
      </div>
      <div class="col-xs-6 text-right">
        <strong>100000000</strong>
      </div>
    </div>
  </div>
</div>


<br>
<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Kỳ</th>
        <th>Ngày đến hạn</th>
        <th>Tiền gốc</th>
        <th>Tiền lãi</th>
        <th>Số tiền phải <br> trả hàng kỳ</th>
        <th>Phạt chậm trả</th>
        <th>Phí tất toán</th>
        <th>Số ngày quá hạn</th>
        <th>Tổng tiền trả <br> đến hạn</th>
        <th>Đã đóng</th>
        <th>Còn lại</th>
        <th>Tình trạng</th>
        <th>Chi tiết</th>
      </tr>
    </thead>
    <tbody>
    <?php for ($i=1; $i < 100; $i++) { ?>
      <tr>
        <td><?php echo $i ?></td>
        <td>09/01/2019</td>
        <td>1.500.000</td>
        <td>500.000</td>
        <td>2.000.000</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>2.500.000</td>
        <td>2.500.000</td>
        <td>0</td>
        <td>Đã thanh toán</td>
        <td>
          <a href="#" data-toggle="modal" data-target="#tab001_noteModal">Ghi chú</a>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>
</div>

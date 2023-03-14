<div class="row flex">
  <div class="col-xs-12 col-md-6">
    <h4>Thông tin khách hàng</h4>
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
        Số CMND/CCCD
      </div>
      <div class="col-xs-6 text-right">
        <strong>1234567890</strong>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6">
        Email
      </div>
      <div class="col-xs-6 text-right">
        <strong>abc@gmail.com</strong>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6">
        Số điện thoại
      </div>
      <div class="col-xs-6 text-right">
        <a href="tel:84347110955">
          <strong><i class="fa fa-lg fa-phone" style="color:#04B204"></i> 84347110955</strong>
        </a>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6">
        Địa chỉ đang ở
      </div>
      <div class="col-xs-6 text-right">
        <strong>Cầu Giấy, Hà Nội</strong>
      </div>
    </div>
  </div>

  <div class="col-xs-12 col-md-6">
    <h4>Thông tin người tham chiếu</h4>
    <div class="row">
      <div class="col-xs-6">
        Tên người tham chiếu 1
      </div>
      <div class="col-xs-6 text-right">
        <strong>Nguyễn Văn B</strong>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6">
        Mối quan hệ
      </div>
      <div class="col-xs-6 text-right">
        <strong>Bố</strong>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6">
        Số điện thoại
      </div>
      <div class="col-xs-6 text-right">
        <a href="tel:84347110955">
          <strong><i class="fa fa-lg fa-phone" style="color:#04B204"></i> 84347110955</strong>
        </a>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6">
        Tên người tham chiếu 2
      </div>
      <div class="col-xs-6 text-right">
        <strong>Nguyễn Thị Chiến</strong>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6">
        Mối quan hệ
      </div>
      <div class="col-xs-6 text-right">
        <strong>Mẹ</strong>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6">
        Số điện thoại
      </div>
      <div class="col-xs-6 text-right">
        <a href="tel:84347110955">
          <strong><i class="fa fa-lg fa-phone" style="color:#04B204"></i> 84347110955</strong>
        </a>
      </div>
    </div>
  </div>
</div>

<hr>
<h4>Lịch sử cuộc gọi</h4>
<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Người liên hệ</th>
        <th>Số điện thoại</th>
        <th>Kết quả</th>
        <th>Bắt đầu</th>
        <th>Kết thúc</th>
        <th>Ghi chú</th>
        <th>Chi tiết</th>
      </tr>
    </thead>

    <tbody>
      <!-- <tr>
      <td colspan="13" class="text-center">Không có dữ liệu</td>
    </tr> -->
    <?php for ($i=1; $i < 100; $i++) { ?>
      <tr>
        <td><?php echo $i ?></td>
        <td>Nguyễn Văn Quang</td>
        <td>01234567890</td>
        <td>Thất bại</td>
        <td>11:02:03 - 22/09/2019</td>
        <td>11:02:03 - 22/09/2019</td>
        <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</td>
        <td>
          <a href="#">
            <i class="fa fa-info-circle" ></i> Chi tiết
          </a>

        </td>
      </tr>
    <?php } ?>

  </tbody>
</table>
</div>

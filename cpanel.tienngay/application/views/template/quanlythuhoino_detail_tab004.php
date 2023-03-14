<div class="table-responsive">
  <table id="datatable-buttons" class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Ngày trả</th>
        <th>Kỳ thanh toán</th>
        <th>Số tiền trả</th>
        <th>Người cập nhật</th>
        <th>Phương thức</th>
        <th>Ghi chú</th>
      </tr>
    </thead>

    <tbody>
      <!-- <tr>
      <td colspan="13" class="text-center">Không có dữ liệu</td>
    </tr> -->
    <?php for ($i=1; $i < 100; $i++) { ?>
      <tr>
        <td><?php echo $i ?></td>
        <td>09/01/2019</td>
        <td>1</td>
        <td>1500000</td>
        <td>loannth@tienngay.vn</td>
        <td>Tiền mặt</td>
        <td>Chúng tôi cung cấp các khoản vay từ 5 triệu - 30 triệu và tư vấn các...</td>
      </tr>
    <?php } ?>

  </tbody>
</table>
</div>



<!-- page content -->
<div class="right_col" role="main">

  <div class="col-xs-12">
    <div class="page-title">
      <div class="title_left">
        <h3>
          Danh sách tài sản
          <br>
          <small>
            <a href="#"><i class="fa fa-home" ></i> Home</a> / <a href="#">Tier 1</a> / <a href="#">Tier 2</a> / <a href="#">Tier 3</a>
          </small>
        </h3>
      </div>
      <div class="title_right text-right">
        <a href="#" class="btn btn-info ">
          <i class="fa fa-plus" aria-hidden="true"></i> Tạo mới
        </a>
      </div>

    </div>
  </div>

  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

      <div class="x_content">
        <div class="row">


          <div class="col-xs-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Mã tài sản</th>
                    <th>Mã HĐ</th>
                    <th>Mã người vay <br> (Lấy CMND.CCCD)</th>
                    <th>Loại tài sản</th>
                    <th>Tên tài sản</th>
                    <th>Mã kho</th>
                    <th>Tình trạng tài sản</th>
                    <th>Trạng thái hồ sơ vay</th>
                    <th>Trạng thái tài sản</th>
                    <th>Trạng thái trong kho</th>
                    <th>Chức năng</th>
                  </tr>
                </thead>

                <tbody>
                  <!-- <tr>
                  <td colspan="13" class="text-center">Không có dữ liệu</td>
                </tr> -->
                <?php for ($i=1; $i < 100; $i++) { ?>
                  <tr>
                    <td>
                      <?php echo $i ?>
                    </td>
                    <td>187253519</td>
                    <td></td>
                    <td>
                      Ô tô
                    </td>
                    <td>
                      Mới
                    </td>
                    <td>

                    </td>
                    <td>

                    </td>
                    <td>123456</td>
                    <td>
                      Đang cầm cố
                    </td>
                    <td>Đã nhập kho</td>
                    <td>
                      <a href="#" class="toggleTheDetail btn btn-sm btn-primary" data-target="thedetail-<?php echo $i?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Chi tiết</a>

                      <a href="#" class="btn btn-sm btn-info">Chuyển kho</a>
                      <a href="#" class="btn btn-sm btn-info"  data-toggle="modal" data-target="#selectStorageModal">Yêu cầu xuất kho</a>
                    </td>
                  </tr>
                  <tr id="thedetail-<?php echo $i?>" class="d-none">
                    <td colspan="11">
                      <div class="row">
                        <div class="col-xs-6">
                          <h5>Thông tin tài sản</h5>
                          <table class="table table-striped table-bordered table-fixed">
                            <tbody>
                              <tr>
                                <td>Tên tài sản</td>
                                <td colspan="3">Xe máy 1234567890-1234567</td>
                              </tr>
                              <tr>
                                <td>Mã tài sản</td>
                                <td colspan="3">TS000001</td>
                              </tr>
                              <tr>
                                <td>Loại tài sản</td>
                                <td>Xe máy</td>

                                <td>Tình trạng tài sản</td>
                                <td>Mới</td>
                              </tr>
                              <tr>
                                <td>Phòng giao dịch</td>
                                <td colspan="3">494 Trần Cung</td>
                              </tr>
                              <tr>
                                <td>Nhãn hiệu</td>
                                <td>Honda</td>
                                <td>Model</td>
                                <td>Honda</td>
                              </tr>
                              <tr>
                                <td>Số khung</td>
                                <td>123</td>
                                <td>Số máy</td>
                                <td>456</td>
                              </tr>
                              <tr>
                                <td>Biển kiểm soát</td>
                                <td colspan="3">18B2 - 204.65</td>
                              </tr>
                              <tr>
                                <td>Giá trị xe hiện tại</td>
                                <td colspan="3"></td>
                              </tr>
                              <tr>
                                <td>Ảnh tài sản</td>
                                <td colspan="3"></td>
                              </tr>
                              <tr>
                                <td>Chứng từ nhập, xuất kho</td>
                                <td colspan="3"></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="col-xs-6">
                          <h5>Thông tin lưu kho</h5>
                          <table class="table table-striped table-bordered table-fixed">

                            <tbody>
                              <tr>
                                <td>Mã kho</td>
                                <td colspan="3">KHO_01</td>

                              </tr>
                              <tr>
                                <td>Tên tài sản</td>
                                <td colspan="3">Xe máy 1234567890-1234567</td>

                              </tr>
                              <tr>
                                <td>Thời hạn</td>
                                <td>13/11/2019</td>
                                <td>Trạng thái tài sản</td>
                                <td>Đang cầm cố</td>

                              </tr>
                              <tr>
                                <td>Trạng thái lưu kho</td>
                                <td colspan="3">Đã xuất kho</td>

                              </tr>
                              <tr>
                                <td>Ngày nhập</td>
                                <td></td>
                                <td>Người nhập</td>
                                <td></td>
                              </tr>
                              <tr>
                                <td>Ngày xuất</td>
                                <td></td>
                                <td>Người xuất</td>
                                <td></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>



                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>



<!-- Modal -->
<div class="modal fade" id="selectStorageModal" tabindex="-1" role="dialog" >
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title">Chọn kho</h5>

      </div>
      <div class="modal-body">
        <select class="form-control">
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
          <option>5</option>
        </select>
      </div>
      <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
       <button type="button" class="btn btn-primary">Xác nhận</button>
     </div>
    </div>
  </div>
</div>


<script>
$('.toggleTheDetail').click(function(event) {
  event.preventDefault();
  $('#' + $(this).data('target')).toggleClass('d-none');
});
</script>

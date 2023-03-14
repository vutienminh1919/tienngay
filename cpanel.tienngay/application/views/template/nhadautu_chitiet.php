<!-- page content -->
<div class="right_col" role="main">

  <div class="col-xs-12">
    <div class="page-title">
      <div class="title_left">
        <h3>
          Chi tiết nhà đầu tư
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
                    <th>#</th>
                    <th>Mã HĐ</th>
                    <th>Tên người vay</th>
                    <th>Khoản vay</th>
                    <th>Ngày giải ngân/Ngày đáo hạn</th>
                    <th>Hình thức trả cho NĐT</th>
                    <th>Ngày phải trả</th>
                    <th>% Lãi vay</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
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
                    <td>Tăng Thị Huyền</td>
                    <td>
                      Số tiền vay: 10.000.000
                      <br> Thời gian: 3 tháng
                      <br> Hình thức trả lãi: Lãi hàng tháng, gốc hàng tháng
                      <br>
                    </td>

                    <td>
                      Ngày giải ngân: 10/11/2019
                      <br> Ngày đáo hạn: 8/2/2020
                    </td>
                    <td>Tiền mặt</td>
                    <td>
                      22/33/4444
                    </td>
                    <td>1.5</td>
                    <td>Đã tất toán</td>
                    <td>
                      <a href="#" class="toggleTheDetail" data-target="thedetail-<?php echo $i?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Chi tiết</a>
                    </td>
                  </tr>
                  <tr id="thedetail-<?php echo $i?>" class="d-none">
                    <td colspan="10">
                      <table class="table">
                        <tbody>

                          <tr>
                            <td>
                              <strong>Mã HĐ:</strong> abc
                            </td>
                          </tr>
                          <tr>
                            <td>
                              Số gốc phải trả NĐT: <strong>100.000.000</strong>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              Số lãi phải trả NĐT: <strong>3.000.000</strong>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              Số còn lại phải trả NĐT đến thời điểm đáo hạn: <strong>3.000.000</strong>
                            </td>
                          </tr>
                          <tr>
                            <td class="p-0">
                              <!-- Child table 1 -->
                              <h5> Chi tiết thanh toán cho NĐT</h5>
                              <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Kỳ</th>
                                    <th>Nguồn tiền trả gốc vay</th>
                                    <th>Ngày cập nhật cuối cùng</th>
                                    <th>Hình thức trả</th>
                                    <th>Số tiền phải trả mỗi kỳ</th>
                                    <th>Số tiền đã trả</th>
                                    <th>Số còn lại phải trả NĐT</th>
                                    <th>Số còn lại phải trả NĐT đến thời điểm đáo hạn</th>
                                    <th>Thao tác</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>1</td>
                                    <td>1</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                      Tiền gốc:
                                      <br> Tiền lãi:
                                      <br> Tổng:
                                    </td>
                                    <td>
                                      Tiền gốc:
                                      <br> Tiền lãi:
                                      <br> Tổng:
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                      <a href="#" data-toggle="modal" data-target="#updateModal">
                                        Cập nhật
                                      </a>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </td>
                          </tr>

                          <tr>
                            <td class="p-0">

                              <!-- Child table 2 -->
                              <h5> Lịch sử trả lãi</h5>
                              <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Kỳ</th>
                                    <th>Nguồn tiền trả gốc vay</th>
                                    <th>Ngày cập nhật cuối cùng</th>
                                    <th>Hình thức trả</th>
                                    <th>Số tiền phải trả mỗi kỳ</th>
                                    <th>Số tiền đã trả</th>
                                    <th>Số còn lại phải trả NĐT</th>
                                    <th>Số còn lại phải trả NĐT đến thời điểm đáo hạn</th>
                                    <th>Thao tác</th>
                                  </tr>
                                </thead>
                                <tbody>

                                  <tr>
                                    <td>1</td>
                                    <td>1</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                      Tiền gốc:
                                      <br> Tiền lãi:
                                      <br> Tổng:
                                    </td>
                                    <td>
                                      Tiền gốc:
                                      <br> Tiền lãi:
                                      <br> Tổng:
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                      <a href="#" data-toggle="modal" data-target="#updateModal">
                                        Cập nhật
                                      </a>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </td>
                          </tr>
                        </tbody>
                      </table>

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
<!-- /page content -->

<!-- Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLabel">Cập nhật thanh toán lãi và gốc cho NĐT cho kì 01/2010</h5>

      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Nguồn tiền trả gốc vay:</label>
          <textarea class="form-control" rows="5"></textarea>
        </div>
        <div class="form-group">
          <label>Ngày trả:</label>
          <input type="date" class="form-control">
        </div>
        <div class="form-group">
          <label>Số tiền lãi đã trả:</label>
          <input type="number" class="form-control">
        </div>
        <div class="form-group">
          <label>Số tiền gốc đã trả:</label>
          <input type="number" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
        <button type="button" class="btn btn-primary">Cập nhật</button>
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

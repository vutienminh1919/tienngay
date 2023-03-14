<!-- page content -->
<div class="right_col" role="main">
  <div class="col-xs-12">
    <div class="page-title">
      <div class="title_left">
        <h3>
          <small>
            <a href="#"><i class="fa fa-home" ></i> Home</a> / <a href="#">Tier 1</a> / <a href="#">Tier 2</a> / <a href="#">Tier 3</a>
          </small>
        </h3>
      </div>

    </div>
  </div>
  <div class="col-xs-12">
    <div class="x_panel">
      <div class="x_content">
        <div class="" role="tabpanel" data-example-id="togglable-tabs">
          <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
            <li role="presentation" class="active"><a href="#tab_content1" id="tab001" role="tab" data-toggle="tab" aria-expanded="true">Chi tiết kỳ thanh toán</a>
            </li>
            <li role="presentation" class=""><a href="#tab_content2" role="tab" id="tab002" data-toggle="tab" aria-expanded="false">Thông tin khách hàng</a>
            </li>
            <li role="presentation" class=""><a href="#tab_content3" role="tab" id="tab003" data-toggle="tab" aria-expanded="false">Thanh toán</a>
            </li>
            <li role="presentation" class=""><a href="#tab_content4" role="tab" id="tab005" data-toggle="tab" aria-expanded="false">Lịch sử trả tiền</a>
            </li>
            <li role="presentation" class=""><a href="#tab_content5" role="tab" id="tab006" data-toggle="tab" aria-expanded="false">Tất toán</a>
            </li>
            <li role="presentation" class=""><a href="#tab_content6" role="tab" id="tab006" data-toggle="tab" aria-expanded="false">Gia hạn</a>
            </li>
          </ul>
          <div id="myTabContent" class="tab-content">
            <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="tab001">
              <?php $this->load->view('template/quanlythuhoino_detail_tab001');?>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="tab002">
              <?php $this->load->view('template/quanlythuhoino_detail_tab002');?>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="tab002">
              <?php $this->load->view('template/quanlythuhoino_detail_tab003');?>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="tab002">
              <?php $this->load->view('template/quanlythuhoino_detail_tab004');?>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="tab002">
              <?php $this->load->view('template/quanlythuhoino_detail_tab005');?>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="tab_content6" aria-labelledby="tab002">
              <?php $this->load->view('template/quanlythuhoino_detail_tab006');?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- /page content -->
<div class="modal fade" id="tab001_noteModal" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title">Ghi chú</h5>
        <hr>
        <div class="form-group">
          <textarea class="form-control" rows="5"></textarea>
        </div>
      </table>
      <p class="text-right">
        <button class="btn btn-danger">Xác nhận</button>
      </p>

      <table class="table">
        <thead>
          <tr>
            <th>Lịch sử ghi chú</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              Chúng tôi cung cấp các khoản vay từ 5 triệu - 30 triệu và tư vấn các khoản vay lớn hơn theo nhu cầu khách hàng.
            </td>
          </tr>
          <tr>
            <td>
              Chúng tôi cung cấp các khoản vay từ 5 triệu - 30 triệu và tư vấn các khoản vay lớn hơn theo nhu cầu khách hàng.
            </td>
          </tr>
          <tr>
            <td>
              Chúng tôi cung cấp các khoản vay từ 5 triệu - 30 triệu và tư vấn các khoản vay lớn hơn theo nhu cầu khách hàng.
            </td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
</div>
</div>

<!-- /page content -->
<div class="modal fade" id="tab002_phoneresultModal" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title">GỌI CHO SỐ: 0347110955</h5>
      <hr>
      <div class="row">
        <div class="col-xs-12 col-lg-6">
          <div class="form-group row">
            <label class="control-label col-md-4 col-sm-4 col-xs-12">Họ và tên</label>
            <div class="col-md-8 col-sm-8 col-xs-12">
              <input type="text" class="form-control" value="NGUYEN VAN AN" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-4 col-sm-4 col-xs-12">Số điện thoại</label>
            <div class="col-md-8 col-sm-8 col-xs-12">
              <input type="text" class="form-control" value="0347110955" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-4 col-sm-4 col-xs-12">Mối quan hệ</label>
            <div class="col-md-8 col-sm-8 col-xs-12">
              <input type="text" class="form-control" value="Khách hàng" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-4 col-sm-4 col-xs-12">Số điện thoại mới</label>
            <div class="col-md-8 col-sm-8 col-xs-12">
              <input type="text" class="form-control" value="" >
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-4 col-sm-4 col-xs-12">Kết quả</label>
            <div class="col-md-8 col-sm-8 col-xs-12">
              <input type="text" class="form-control" value="" >
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-lg-6">
          <div class="form-group row">
            <label class="control-label col-md-4 col-sm-4 col-xs-12">Số tiền hẹn thanh toán</label>
            <div class="col-md-8 col-sm-8 col-xs-12">
              <input type="text" class="form-control" value="" >
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-4 col-sm-4 col-xs-12">Ngày hẹn thanh toán</label>
            <div class="col-md-8 col-sm-8 col-xs-12">
              <input type="text" class="form-control" value="" >
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-4 col-sm-4 col-xs-12">Ghi chú</label>
            <div class="col-md-8 col-sm-8 col-xs-12">
              <textarea class="form-control" rows="3" cols="80"></textarea>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-xs-12">
              <h4>00:15:15</h4>
            </div>
          </div>
        </div>
      </div>
      <p class="text-center">
        <button class="btn btn-danger">Lưu và kết thúc</button>
      </p>

    </div>

  </div>
</div>
</div>

<script type="text/javascript">
    $(window).on('load',function(){
        $('#tab002_phoneresultModal').modal('show');
    });
</script>

<div class="right_col" role="main">

  <div class="row">
    <div class="col-xs-12">
      <div class="page-title">
        <h3>Thẻ game Online</h3>

      </div>
    </div>
    <div class="col-xs-12 col-lg-8">
      <div class="x_panel panel_phonecard" >
        <div class="x_content">
          <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab1" class="nav nav-tabs " role="tablist">
              <li role="presentation" class="active"><a href="#" ><i class="fa fa-credit-card" aria-hidden="true"></i> Trả trước</a>
              </li>
              <li role="presentation" class=""><a href="#" role="tab" ><i class="fa fa-barcode" aria-hidden="true"></i> Trả sau</a>
              </li>
            </ul>
            <div id="myTabContent2" class="tab-content">
              <div role="tabpanel" class="tab-pane fade active in" id="tab_directly" aria-labelledby="tab_directly">
                <div class="card-body">
                  <ul class="selecttype">
                    <li>
                      <input id="selecttype_1" type="radio" name="selecttype">
                      <label for="selecttype_1">
                        <img class="logo" src="<?php echo base_url();?>assets/imgs/logo/logo_zing.png" alt="">
                        <img class="checked" src="<?php echo base_url();?>assets/imgs/icon/icon_checked.png" alt="">
                      </label>

                    </li>
                    <li>
                      <input id="selecttype_2" type="radio" name="selecttype">
                      <label for="selecttype_2">
                        <img class="logo" src="<?php echo base_url();?>assets/imgs/logo/logo_garena.png" alt="">
                        <img class="checked" src="<?php echo base_url();?>assets/imgs/icon/icon_checked.png" alt="">
                      </label>

                    </li>
                    <li>
                      <input id="selecttype_3" type="radio" name="selecttype">
                      <label for="selecttype_3">
                        <img class="logo" src="<?php echo base_url();?>assets/imgs/logo/logo_vtc.png" alt="">
                        <img class="checked" src="<?php echo base_url();?>assets/imgs/icon/icon_checked.png" alt="">
                      </label>

                    </li>
                    <li>
                      <input id="selecttype_4" type="radio" name="selecttype">
                      <label for="selecttype_4">
                        <img class="logo" src="<?php echo base_url();?>assets/imgs/logo/logo_gate.png" alt="">
                        <img class="checked" src="<?php echo base_url();?>assets/imgs/icon/icon_checked.png" alt="">
                      </label>

                    </li>

                  </ul>
                </div>
                <div class="card-body">
                  <h5 class="card-title">Tài khoản game </h5>
                  <div class="form-group m-0 step2">
                    <input type="text" class="form-control" placeholder="Số điện thoại">
                  </div>
                </div>
                <div class="card-body">
                  <h5 class="card-title">Mệnh giá thẻ : </h5>
                  <div class="row selectmoney">
                    <div class="col-xs-3">
                      <input id="selectmoney_20000" type="radio" name="selectmoney">
                      <label for="selectmoney_20000" >20.000</label>
                    </div>
                    <div class="col-xs-3">
                      <input id="selectmoney_50000" type="radio" name="selectmoney">
                      <label for="selectmoney_50000">50.000</label>
                    </div>
                    <div class="col-xs-3">
                      <input id="selectmoney_100000" type="radio" name="selectmoney">
                      <label for="selectmoney_100000">100.000</label>
                    </div>
                    <div class="col-xs-3">
                      <input id="selectmoney_200000" type="radio" name="selectmoney">
                      <label for="selectmoney_200000">200.000</label>
                    </div>
                    <div class="col-xs-3">
                      <input id="selectmoney_300000" type="radio" name="selectmoney">
                      <label for="selectmoney_300000">300.000</label>
                    </div>

                    <div class="col-xs-3">
                      <input id="selectmoney_500000" type="radio" name="selectmoney">
                      <label for="selectmoney_500000">500.000</label>
                    </div>
                    <div class="col-xs-3">
                      <input id="selectmoney_1000000" type="radio" name="selectmoney">
                      <label for="selectmoney_1000000">1.000.000</label>
                    </div>
                    <div class="col-xs-3">
                      <input id="selectmoney_2000000" type="radio" name="selectmoney">
                      <label for="selectmoney_2000000">2.000.000</label>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <ul class="information">
                    <li>
                      Chiết khấu: 1,5%
                      <span>750đ</span>
                    </li>
                    <li>
                      Thanh toán
                      <span>49.250đ</span>
                    </li>
                  </ul>
                </div>
                <div class="card-body text-center">
                  <br>
                  <button class="btn btn-lg btn-primary" style="min-width: 225px"
                  data-toggle="modal" data-target="#resultModal">
                  Thanh toán
                </button>
              </div>

            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<!-- Modal -->
<div id="resultModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:400px">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="card card-phoneresult">
        <div class="card-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <img src="<?php echo base_url();?>assets/imgs/logo/logo_zing.png" alt="">
          <p class="thephone">nhatchimai2000hn</p>
          <p class="thetype">Nạp thẻ game online</p>
          <p class="themoney">50.000đ</p>
        </div>
        <div class="card-body">
          <ul>
            <li>
              Giá khuyến mại (750đ):
              <span>49.250đ</span>
            </li>
            <li>
              Phí gia dịch:
              <span>Miễn phí</span>
            </li>
            <li>
              Tổng tiền thanh toán:
              <strong>49.250đ</strong>
            </li>
          </ul>


        </div>

        <div class="card-footer">
          <button type="button" name="button" class="btn btn-primary" >
            Xác nhận giao dịch
          </button>
          <button type="button" name="button" class="btn btn-default"  data-dismiss="modal" aria-label="Close">
            Hủy giao dịch
          </button>
        </div>
      </div>

    </div>

  </div>
</div>
<script>
// $(window).load(function()
// {
//   $('#resultModal').modal('show');
// });
</script>

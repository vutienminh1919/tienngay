
<div class="right_col" role="main">
  <div class="row">
    <div class="col-xs-12">
      <div class="page-title">
        <h3>Thanh toán hóa đơn</h3>

      </div>
    </div>
    <div class="col-xs-12 col-lg-8">
      <div class="x_panel panel_phonecard" >
        <div class="x_content">
          <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab1" class="nav nav-tabs" role="tablist">
              <li role="presentation" >
                <a href="#" ><i class="fa fa-bolt" aria-hidden="true"></i> Điện EVN</a>
              </li>
              <li role="presentation"  >
                <a href="#" ><i class="fa fa-tint" aria-hidden="true"></i> Nước</a>
              </li>
              <li role="presentation" class="active">
                <a href="#" ><i class="fa fa-money" aria-hidden="true"></i> Tài chính</a>
              </li>
            </ul>
            <div id="myTabContent2" class="tab-content">
              <div role="tabpanel" class="tab-pane fade active in" id="tab_prepaid" aria-labelledby="tab_prepaid">
                <div class="card-body">
                  <div class="container">
                    <div class="stepwizard v2">
                      <div class="stepwizard-row noshadow setup-panel">
                        <div class="stepwizard-step col-xs-4">
                          <a href="#step-1" type="button" class="btn btn-default igniter btn-circle">1</a>
                          <p><small>Nhà cung cấp/ Mã khách hàng</small></p>
                        </div>
                        <div class="stepwizard-step col-xs-4">
                          <a href="#step-2" type="button" class="btn btn-default btn-circle disabled" disabled>2</a>
                          <p><small>Thông tin hóa đơn</small></p>
                        </div>
                        <div class="stepwizard-step col-xs-4">
                          <a href="#step-3" type="button" class="btn btn-default btn-circle disabled" disabled>3</a>
                          <p><small>Xác nhận giao dịch</small></p>
                        </div>

                      </div>
                    </div>


                    <div class="setup-content" id="step-1">

                      <div class="form-group">
                        <label class="control-label">Nhà cung cấp</label>
                        <div class="btn-group icon-select w-100 bg-transparent">
                          <a class="btn dropdown-toggle btn btn-default w-100" data-toggle="dropdown" href="#" style="text-align:left !important">
                            <img src="<?php echo base_url();?>assets/imgs/logo/logo_fecr.png" style="width:24px;margin-right: 5px">FE Credit (FECR)
                          </a>
                          <ul class="dropdown-menu" style="width: 100%;">
                            <li> <a href="#"><img src="<?php echo base_url();?>assets/imgs/logo/logo_mrc.png" style="width:24px;margin-right: 5px">Mcredit (MCR)</a> </li>
                            <li> <a href="#"><img src="<?php echo base_url();?>assets/imgs/logo/logo_acs.png" style="width:24px;margin-right: 5px">ACS (ACS)</a> </li>
                            <li> <a href="#"><img src="<?php echo base_url();?>assets/imgs/logo/logo_mra.png" style="width:24px;margin-right: 5px">Mirae Asset (MRA)</a> </li>
                            <li> <a href="#"><img src="<?php echo base_url();?>assets/imgs/logo/logo_hcr.png" style="width:24px;margin-right: 5px">Home Credit (HCR)</a> </li>
                            <li> <a href="#"><img src="<?php echo base_url();?>assets/imgs/logo/logo_fecr.png" style="width:24px;margin-right: 5px">FE Credit (FECR)</a> </li>
                            <li> <a href="#"><img src="<?php echo base_url();?>assets/imgs/logo/logo_ocb.png" style="width:24px;margin-right: 5px">Ngân hàng Phương Đông (OCB)</a> </li>
                            <li> <a href="#"><img src="<?php echo base_url();?>assets/imgs/logo/logo_msb.png" style="width:24px;margin-right: 5px">Ngân hàng Hàng Hải (MSB)</a> </li>
                            <li> <a href="#"><img src="<?php echo base_url();?>assets/imgs/logo/logo_pru.png" style="width:24px;margin-right: 5px">Prudential (PRU)</a> </li>
                          </ul>
                        </div>
                        <script>
                        $(".icon-select .dropdown-menu li a").click(function() {
                          var selText = $(this).html();
                          console.log(selText);
                          // var spanClass = $(this).find('span').attr('class');
                          // var span = '<span class="' + spanClass + '"/></span>';
                          $(this).parents('.btn-group').find('.dropdown-toggle').html(selText);
                        });
                        </script>
                      </div>
                      <div class="form-group">
                        <label class="control-label">Số ID thẻ / Số hợp đồng</label>
                        <input  type="text" required="required" class="form-control" placeholder="Mã khách hàng..." />
                      </div>
                      <button class="btn btn-primary nextBtn pull-right" type="button">Tiếp tục</button>

                    </div>

                    <div class="setup-content" id="step-2">
                      <div class="card card-billing-recipe-result">
                        <div class="card-header">
                          <div class="thelogo">
                            <img class="logo" src="<?php echo base_url();?>assets/imgs/logo/logo_fecr.png" alt="">
                          </div>
                          <p class="text-1">FE Credit (FECR)</p>
                          <p class="text-1"> PA01ND0000889</p>
                          <p class="text-2" style="margin:0"> Số tền phải trả đến hạn</p>
                          <p class="text-3">15.000.000 đ</p>
                          <ul>
                            <li>Họ tên
                              <span>Cong ty TNHH Hoang Long</span>
                            </li>
                            <li>
                              Kỳ thanh toán
                              <span>11/2019</span>
                            </li>
                            <li>
                              Ngày hết hạn
                              <span>20/11/2019</span>
                            </li>
                          </ul>
                        </div>
                        <div class="card-content">
                          <ul>
                            <li>
                              Phí dịch vụ: 0đ + 0%
                              <span>0đ</span>
                            </li>
                            <li>
                              Tổng tiền
                              <strong>500.000đ</strong>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <br>
                      <div class="text-center">
                        <button class="btn btn-danger backBtn" type="button">Trở lại</button>
                        <button class="btn btn-primary nextBtn" type="button">Tiếp tục</button>
                      </div>

                    </div>

                    <div class="setup-content" id="step-3">


                      <div class="card card-billing-recipe-result">
                        <div class="card-header">
                          <div class="thelogo">
                            <img class="logo" src="<?php echo base_url();?>assets/imgs/logo/logo_fecr.png" alt="">
                          </div>
                          <p class="text-1"> PA01ND0000889</p>
                          <p class="text-1">LÊ HOÀNG - Kỳ 11/2019</p>
                          <p class="text-3">500.000đ</p>

                        </div>
                        <div class="card-content">
                          <ul>
                            <li>
                              Giá khuyến mại:
                              <span>500.000đ</span>
                            </li>
                            <li>
                              Phí giao dịch:
                              <span>Miễn phí</span>
                            </li>
                            <li>
                              Tổng tiền
                              <strong>500.000đ</strong>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <br>
                      <div class="text-center">

                        <button class="btn btn-primary" type="button">Xác nhận giao dịch</button>
                        <button class="btn btn-danger" type="button">Hủy giao dịch</button>
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
          <img src="<?php echo base_url();?>assets/imgs/logo/logo_viettel.png" alt="">
          <p class="thephone">0868 2020 88</p>
          <p class="thetype">Nạp thẻ trả trước</p>
          <p class="themoney">50.000đ</p>
        </div>
        <div class="card-body">
          <ul>
            <li>
              Giá khuyến mại (0đ):
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

$(document).ready(function () {

  var navListItems = $('div.setup-panel div a'),
  allWells = $('.setup-content'),
  allNextBtn = $('.nextBtn');
  allBackBtn = $('.backBtn');

  allWells.hide();

  navListItems.click(function (e) {
    e.preventDefault();
    var $target = $($(this).attr('href')),
    $item = $(this);

    if (!$item.hasClass('disabled')) {
      navListItems.removeClass('active');
      $item.addClass('active');
      allWells.hide();
      $target.show();
      $target.find('input:eq(0)').focus();
    }
  });

  allNextBtn.click(function () {

    var curStep = $(this).closest(".setup-content"),
    curStepBtn = curStep.attr("id"),
    nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
    curInputs = curStep.find("input[required]"),
    isValid = true;
    $(".form-group").removeClass("has-error");
    for (var i = 0; i < curInputs.length; i++) {
      if (!curInputs[i].validity.valid) {
        isValid = false;
        $(curInputs[i]).closest(".form-group").addClass("has-error");
      }
    }

    if (isValid) nextStepWizard.removeAttr('disabled').removeClass('disabled').trigger('click');
  });

  allBackBtn.click(function () {
    var curStep = $(this).closest(".setup-content"),
    curStepBtn = curStep.attr("id"),
    prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");
    prevStepWizard.click();

  });

  $('div.setup-panel div .btn.igniter').trigger('click');
});
</script>


<style >

.stepwizard-step p {
  margin-top: 0px;
  color:#666;
}
.stepwizard-row {
  display: table-row;
  position: relative;
}
.stepwizard {
  display: table;
  width: 100%;
  position: relative;
}
.stepwizard.v2 .btn {
  font-weight: bold;
  font-size: 24px;
  color: #2a3f54;
  width: 40px;
  height: 40px;
  border-radius: 100%;
  line-height: 27px;

}
.stepwizard-step button[disabled] {
  /*opacity: 1 !important;
  filter: alpha(opacity=100) !important;*/
}
.stepwizard.v2 .btn.disabled, .stepwizard.v2 .btn[disabled], .stepwizard.v2 fieldset[disabled] .btn {
  opacity:1 !important;
  color:#bbb;
  background-color: #eee
}
.stepwizard-step > .btn.active {
  color: #fff;
  background-color: #2a3f54
}
.stepwizard-row:before {
  top:20px;
  position: absolute;
  content:" ";
  width: 100%;
  height: 1px;
  background-color: #ccc;
  z-index: 0;
}
.stepwizard-step {
  display: table-cell;
  text-align: center;
  position: relative;
}
.btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.428571429;
  border-radius: 15px;
}

</style>

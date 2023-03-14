
<div class="right_col" role="main">
  <div class="theloading" style="display:none">
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    <span ><?= $this->lang->line('Loading')?>...</span>
  </div>

  <div class="row">
    <div class="col-xs-12">
      <div class="page-title">
        <h3>Thanh toán hóa đơn nước 
        <br>
					<small>
					<a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="<?php echo base_url('VimoBilling')?>"><?= $this->lang->line('Pay_the_bill')?></a>/ <a href="#">Thanh toán hóa đơn nước</a>
					</small>
        </h3>

      </div>
    </div>
    <div class="col-xs-12  col-lg-8" style=" margin-top: 20px;">
      <div class="x_panel panel_phonecard" >
        <div class="x_content">
          <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab1" class="nav nav-tabs " role="tablist">
              <li role="presentation" ><a href="<?php echo base_url("VimoBilling/billingElectric")?>" ><i class="fa fa-bolt" aria-hidden="true"></i> <?= $this->lang->line('EVN_electricity_bill')?></a>
              </li>
              <li role="presentation" class="active"><a href="<?php echo base_url("VimoBilling/billingWater")?>" ><i class="fa fa-tint" aria-hidden="true"></i> <?= $this->lang->line('Water_bill')?></a>
              </li>
              <li role="presentation" class=""><a href="<?php echo base_url("VimoBilling/billingFinance")?> " ><i class="fa fa-money" aria-hidden="true"></i> <?= $this->lang->line('Finance_bill')?></a>
              </li>
            </ul>
            <div id="myTabContent2" class="tab-content">
              <div role="tabpanel" class="tab-pane fade active in" id="tab_prepaid" aria-labelledby="tab_prepaid">
                <div class="card-body">
                  <div class="container">
                    <div class="stepwizard v2">
                      <div class="stepwizard-row noshadow setup-panel">
                        <div class="stepwizard-step col-xs-6">
                          <a href="#step-1" type="button" class="btn btn-default igniter btn-circle">1</a>
                          <p><small><?= $this->lang->line('Supplier_customer_code')?></small></p>
                        </div>
                        <div class="stepwizard-step col-xs-6">
                          <a href="#step-2" type="button" class="btn btn-default btn-circle disabled" disabled>2</a>
                          <p><small><?= $this->lang->line('Invoice_information')?></small></p>
                        </div>


                      </div>
                    </div>


                    <div class="setup-content" id="step-1">

                      <div class="form-group">
                        <label class="control-label"><?= $this->lang->line('Supplier')?></label>
                        <div class="btn-group icon-select w-100 bg-transparent">
                        <?php
                            if(!empty($service)){
                              $publisher = $service->publisher;
                              $publisher_code =  $publisher[0]->code;
                              $publisher_name = $publisher[0]->name;
                            }
                          ?>
                          <a class="btn dropdown-toggle btn btn-default w-100" data-toggle="dropdown" href="#" style="text-align:left !important">
                            <!-- <img src="<?php echo base_url();?>assets/imgs/logo/logo_sawaco.png" style="width:24px;margin-right: 5px"> -->
                            <?= !empty($publisher_name) ? $publisher_name : "" ?>
                          </a>
                          <ul class="dropdown-menu" style="width: 100%;">
                          <?php
                            if(!empty($service)){
                              $publisher = $service->publisher;
                              $publisher_code =  $publisher[0]->code;
                              $publisher_name = $publisher[0]->name;
                              foreach($publisher as $key =>  $value){
                          ?>

                            <li  class='publisher' data-name="<?= !empty($value->name) ? $value->name : "" ?>" data-code="<?= !empty($value->code) ? $value->code : "" ?>"> <a href="#">
                            <!-- <img src="<?php echo base_url();?>assets/imgs/logo/logo_sawaco.png" style="width:24px;margin-right: 5px"> -->
                            <?= !empty($value->name) ? $value->name : "" ?>
                            </a> </li>
                            <?php }}?>

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
                        <label class="control-label"><?= $this->lang->line('CardID_Contract_number1')?></label>
                        <input  type="text" required="required" class="form-control" name="customer_code" placeholder="<?= $this->lang->line('Customer_code')?>..." />
                        <input  type="hidden" class="form-control " name="sevice_code_vimo" value="BILL_WATER"/>
                        <input  type="hidden" class="form-control " name="sevice_name_vimo" value="Thanh toán hóa đơn nước"/>
                        <input  type="hidden" class="form-control " name="publisher_code" value="<?= !empty($publisher_code) ?  $publisher_code : "" ?>"/>
                        <input  type="hidden" class="form-control " name="publisher_name" value="<?= !empty($publisher_name) ?  $publisher_name : "" ?>"/>
                        <input  type="hidden" class="form-control total_amount_billing" name="total_amount_billing" value="0"/>
                        <input  type="hidden" class="form-control arrBillingDetaile" name="arrBillingDetaile" value=""/>
                        <input  type="hidden" class="form-control arrCustomerInfor" name="arrCustomerInfor" value=""/>
                      </div>
                      <button class="btn btn-primary nextBtn pull-right nextBtnBill" type="button">Tiếp tục</button>

                    </div>

                    <div class="setup-content" id="step-2">
                      <div class="card card-billing-recipe-result">
                        <div class="card-header">
                          <!-- <div class="thelogo">
                            <img class="logo" src="<?php echo base_url();?>assets/imgs/logo/logo_sawaco.png" alt="">
                          </div> -->
                          <p class="text-1 publisher_name" style=' padding-top: 25px;'></p>
                          <p class="text-1 custumer_code"></p>
                          <p class="text-2"> <?= $this->lang->line('Customer_code')?></p>
                          <ul>
                            <li><?= $this->lang->line('Full_name')?>
                              <span class='customer_name'></span>
                            </li>
                            <li>
                            <?= $this->lang->line('Address')?>
                              <span class='customer_address'></span>
                            </li>
                          </ul>
                        </div>
                        <div class="card-content">
                        <ul class='billDetail'>

                            </ul>
                            <ul>
                              <li class="hrBillDetail">
                                <hr>
                              </li>
                              <li>
                                  <?= $this->lang->line('Total_payment')?>
                                <strong class='total_amount'></strong>
                              </li>
                            </ul>
                        </div>
                      </div>
                      <br>
                      <div class="text-center">
                        <button class="btn btn-danger backBtn" type="button">Trở lại</button>
                        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#billingConfirm"> <?= $this->lang->line('Confirm_transaction')?></button>
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
<?php $this->load->view('page/modal/billing_confirm');?>
<script src="<?php echo base_url();?>assets/js/numeral.min.js"></script>
<script src="<?php echo base_url();?>assets/js/billing/querybill.js"></script>
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

    // var curStep = $(this).closest(".setup-content"),
    // curStepBtn = curStep.attr("id"),
    // nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
    // curInputs = curStep.find("input[required]"),
    // isValid = true;
    // $(".form-group").removeClass("has-error");
    // for (var i = 0; i < curInputs.length; i++) {
    //   if (!curInputs[i].validity.valid) {
    //     isValid = false;
    //     $(curInputs[i]).closest(".form-group").addClass("has-error");
    //   }
    // }

    // if (isValid) nextStepWizard.removeAttr('disabled').removeClass('disabled').trigger('click');
  });

  allBackBtn.click(function () {
    var curStep = $(this).closest(".setup-content"),
    curStepBtn = curStep.attr("id"),
    prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");
    prevStepWizard.click();

  });

  $('div.setup-panel div .btn.igniter').trigger('click');


  $(".publisher").click(function(event) {
    event.preventDefault();
    let publisher_code = $(this).attr("data-code");
    let publisher_name = $(this).attr("data-name");
    $("input[name='publisher_code']").val(publisher_code);
    $("input[name='publisher_name']").val(publisher_name);

});
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

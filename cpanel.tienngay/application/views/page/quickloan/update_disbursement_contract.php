<!-- page content -->
<div class="right_col" role="main">

<div class="theloading" style="display:none" >
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    <span ><?= $this->lang->line('Loading')?>...</span>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="page-title">
        <h3>Sửa hợp đồng vay
            <br>
            <small>
                <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a>/ <a href="<?php echo base_url('pawn/contract')?>"><?php echo $this->lang->line('Contract_management')?></a> / <a href="#">Sửa hợp đồng vay</a>
            </small>
        </h3>
      </div>
    </div>
    <br>&nbsp;
    <div class="col-xs-12">
      <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
      
          <div class="stepwizard-step">
            <a href="#1" class="btn igniter" >Thông tin giải ngân</a>
          
          </div>
          <div class="stepwizard-step">  </div>
          <div class="stepwizard-step">  </div>
          <div class="stepwizard-step">  </div>
          <div class="stepwizard-step">  </div>
          <div class="stepwizard-step">  </div>
     
        </div>
      </div>
      <div class="alert alert-danger alert-dismissible text-center" style="display:none" id="div_error">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <span class='div_error'></span>
        </div>
        <input type="hidden" id="contract_id" value="<?= $_GET['id'] ? $_GET['id'] : ""?>">
      <form role="form" class="form-horizontal form-label-left">
    
      <div class="x_panel setup-content" id="1">
          <div class="x_content">
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Hình thức<span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" id="type_payout"  onchange="typePayout()">
                    <option value="2">Tài khoản ngân hàng</option>
                    <option value="3">Thẻ atm</option>
                    <!-- <option value="10">Chuyển nhanh 247</option> -->
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Ngân Hàng<span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" id="selectize_bank_vimo">
                    <option value="">Chọn ngân hàng</option>
                    <?php 
                    if(!empty($bankVimoData)){
                        foreach($bankVimoData as $key => $bank){
                    ?>
                        <option  value="<?= !empty($bank->bank_id) ? $bank->bank_id : "";?>" <?php if($contractInfor->receiver_infor->bank_id == $bank->bank_id) echo 'selected';?> ><?= !empty($bank->name) ? $bank->name : "";?> ( <?= !empty($bank->short_name) ? $bank->short_name : "";?> )</option>
                    <?php }}?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Chi nhánh<span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" required id="bank_branch" class="form-control identify-autocomplete" value="<?= !empty($contractInfor->receiver_infor->bank_branch) ? $contractInfor->receiver_infor->bank_branch : "" ?>" <?php if($contractInfor->receiver_infor->type_payout == "3") echo 'disabled';?>>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Số tài khoản<span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" required id="bank_account" class="form-control phone-autocomplete" value="<?= !empty($contractInfor->receiver_infor->bank_account) ? $contractInfor->receiver_infor->bank_account : "" ?>" <?php if($contractInfor->receiver_infor->type_payout == "3") echo 'disabled';?>>
              </div>
            </div>
            
         
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Chủ tài khoản<span class="text-danger">*</span>
              </label>
              <div class="col-lg-6 col-sm-12 col-12">
              <input type="text" required id="bank_account_holder" class="form-control identify-autocomplete"  value="<?= !empty($contractInfor->receiver_infor->bank_account_holder) ? $contractInfor->receiver_infor->bank_account_holder : "" ?>" <?php if($contractInfor->receiver_infor->type_payout == "3") echo 'disabled';?>>
              </div>
            </div>
           
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Số thẻ atm <span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="atm_card_number" type='text' class="form-control" value="<?= !empty($contractInfor->receiver_infor->atm_card_number) ? $contractInfor->receiver_infor->atm_card_number : "" ?>" <?php if($contractInfor->receiver_infor->type_payout == "2") echo 'disabled';?>>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Tên chủ thẻ atm<span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" required id="atm_card_holder" class="form-control" value="<?= !empty($contractInfor->receiver_infor->atm_card_holder) ? $contractInfor->receiver_infor->atm_card_holder : "" ?>" <?php if($contractInfor->receiver_infor->type_payout == "2") echo 'disabled';?>>
              </div>
            </div>     

            <div class="form-group row">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Phòng giao dịch<span class="text-danger">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control" id="stores">
                    <?php 
                        $userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
                        $stores = !empty($userInfo['stores']) ?  $userInfo['stores'] : array();
                        foreach($stores as $key =>  $value){
                    ?>
                        <option <?php if($contractInfor->store->id == $value->store_id) echo 'selected';?> data-address="<?= !empty($value->store_address) ? $value->store_address : ""?>" value="<?= !empty($value->store_id) ? $value->store_id : ""?>" selected><?= !empty($value->store_name) ? $value->store_name : ""?></option>
                        <?php }?>
                    </select>
                </div>
            </div>                    
            <button class="btn btn-primary nextBtn pull-right" type="button" data-toggle="modal" data-target="#saveContract">Cập nhật</button>
          </div>
        </div>


      </form>
      <input type="hidden" id="step_index"  class="form-control">
    </div>


  </div>
</div>
<!-- /page content -->

<!-- Modal HTML -->
<div id="saveContract" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
                <div class="icon-box success">
					<i class="fa fa-check"></i>
				</div>
				<h4 class="modal-title">Xác nhận lưu hợp đồng</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
            <input type="hidden" id="money" required class="form-control number"  value="<?= $contractInfor->loan_infor->amount_money ? number_format($contractInfor->loan_infor->amount_money) : "" ?>">
			<div class="modal-footer">
				<button type="button" class="btn btn-info"   data-dismiss="modal"><?= $this->lang->line('Cancel')?></button>
                <button type="button" class="btn btn-success update_disbursement_contract"><?= $this->lang->line('ok')?></button>
			</div>
		</div>
	</div>
</div>

<style>
  .x_content {
    display: inline-block;
    float: none
  }
</style>


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

  $(".save_contract").click(function (event) {
    event.preventDefault();
    var step = $(this).attr("data-step");
    $("#step_index").val(step);
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

<script src="<?php echo base_url("assets")?>/js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets")?>/js/numeral.min.js"></script>
<script src="<?php echo base_url();?>assets/js/pawn/contract.js"></script>
<script >
$('#money').keyup(function(event) {
        // skip for arrow keys
        if(event.which >= 37 && event.which <= 40) return;
    
        // format number
        $(this).val(function(index, value) {
            return value
            .replace(/\D/g, "")
            .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            ;
        });
    });
    // $('#amount_money').keyup(function(event) {
    //     $('.number').keypress(function(event) {
    //         if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
    //             event.preventDefault();
    //         }
    //     });
    // });
    $('.number').keypress(function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });</script>
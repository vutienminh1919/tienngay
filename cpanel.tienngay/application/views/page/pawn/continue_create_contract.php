<!-- page content -->
<div class="right_col" role="main">

<div class="theloading" style="display:none" >
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    <span ><?= $this->lang->line('Loading')?>...</span>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="page-title">
        <h3>Tạo mới hợp đồng vay
            <br>
            <small>
                <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a>/ <a href="<?php echo base_url('pawn/contract')?>"><?php echo $this->lang->line('Contract_management')?></a> / <a href="#">Tạo mới hợp đồng vay</a>
            </small>
        </h3>
      </div>
    </div>
    <br>&nbsp;
  <div class="col-xs-12">
        <div class="stepwizard hidden-xs hidden-sm">
        <div class="stepwizard-row setup-panel">
         
        <?php 
            $igniter2 = '';
            $disabled2 = 'disabled';
            $igniter3 = '';
            $disabled3 = 'disabled';
            $igniter4 = '';
            $disabled4 = 'disabled';
            $igniter5 = '';
            $disabled5 = 'disabled';
            $igniter6 = '';
            $disabled6 = 'disabled';
            if($contractInfor->step == 2){
                $igniter2 = 'igniter';
                $disabled2 = '';
            }
            if($contractInfor->step == 3){
                $igniter2 = 'igniter';
                $disabled2 = '';
                $igniter3 = 'igniter';
                $disabled3 = '';
            }
            if($contractInfor->step == 4){
                $igniter2 = 'igniter';
                $disabled2 = '';
                $igniter3 = 'igniter';
                $disabled3 = '';
                $igniter4 = 'igniter';
                $disabled4 = '';
            }
            if($contractInfor->step == 5){
                $igniter2 = 'igniter';
                $disabled2 = '';
                $igniter3 = 'igniter';
                $disabled3 = '';
                $igniter4 = 'igniter';
                $disabled4 = '';
                $igniter5 = 'igniter';
                $disabled5 = '';
            }
            if($contractInfor->step == 6){
                $igniter2 = 'igniter';
                $disabled2 = '';
                $igniter3 = 'igniter';
                $disabled3 = '';
                $igniter4 = 'igniter';
                $disabled4 = '';
                $igniter5 = 'igniter';
                $disabled5 = '';
                $igniter6 = 'igniter';
                $disabled6 = '';
            }
        ?>

          <div class="stepwizard-step">
            <a href="#step-1" class="btn igniter">Thông tin khách hàng</a>
          </div>
          <div class="stepwizard-step">
            <a href="#step-2" class="btn <?php echo $igniter2 ;?><?php echo $disabled2 ;?>" <?php echo $disabled2 ;?>>Thông tin việc làm</a>
          </div>
          <div class="stepwizard-step">
            <a href="#step-3" class="btn <?php echo $igniter3 ;?><?php echo $disabled3 ;?>" <?php echo $disabled3 ;?>>Thông tin người thân</a>
          </div>
          <div class="stepwizard-step">
            <a href="#step-4" class="btn <?php echo $igniter4 ;?><?php echo $disabled4 ;?>" <?php echo $disabled4 ;?>>Thông tin khoản vay</a>
          </div>
          <div class="stepwizard-step">
            <a href="#step-5" class="btn <?php echo $igniter5 ;?><?php echo $disabled5 ;?>" <?php echo $disabled5 ;?>>Thông tin giải ngân</a>
          </div>
          <div class="stepwizard-step">
            <a href="#step-6" class="btn <?php echo $igniter6 ;?><?php echo $disabled6 ;?>" <?php echo $disabled6 ;?>>Thông tin thẩm định</a>
          </div>
        </div>
      </div>
      <div class="alert alert-danger alert-dismissible text-center" style="display:none" id="div_error">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <span class='div_error'></span>
        </div>
        <input type="hidden" id="contract_id" value="<?= $_GET['id'] ? $_GET['id'] : ""?>">
      <form role="form" class="form-horizontal form-label-left">
          <a href="#step-1" class="btn btn-stepwizard-mb btn-warning btn-lg w-100 hidden-md hidden-lg" data-target="step-1">
          Thông tin khách hàng
        </a>
        <?php   $this->load->view('page/pawn/step_continue/step1', isset($this->data)?$this->data:NULL);?>
         <a href="#step-2" class="btn btn-stepwizard-mb btn-warning btn-lg w-100  hidden-md hidden-lg" data-target="step-2">
          Thông tin việc làm
        </a>
        <?php   $this->load->view('page/pawn/step_continue/step2', isset($this->data)?$this->data:NULL);?>
         <a href="#step-3" class="btn btn-stepwizard-mb btn-warning btn-lg w-100  hidden-md hidden-lg" data-target="step-3">
          Thông tin người thân
        </a>
        <?php   $this->load->view('page/pawn/step_continue/step3', isset($this->data)?$this->data:NULL);?>
         <a href="#step-4" class="btn btn-stepwizard-mb btn-warning btn-lg w-100  hidden-md hidden-lg" data-target="step-4">
          Thông tin khoản vay
        </a>
        <?php   $this->load->view('page/pawn/step_continue/step4', isset($this->data)?$this->data:NULL);?>
         <a href="#step-5" class="btn btn-stepwizard-mb btn-warning btn-lg w-100  hidden-md hidden-lg" data-target="step-5">
          Thông tin giải ngân
        </a>
        <?php   $this->load->view('page/pawn/step_continue/step5', isset($this->data)?$this->data:NULL);?>
          <a href="#step-6" class="btn btn-stepwizard-mb btn-warning btn-lg w-100  hidden-md hidden-lg" data-target="step-6">
          Thông tin thẩm định
        </a>
        <?php   $this->load->view('page/pawn/step_continue/step6', isset($this->data)?$this->data:NULL);?>
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
			
			<div class="modal-footer">
				<button type="button" class="btn btn-info"   data-dismiss="modal"><?= $this->lang->line('Cancel')?></button>
        <button type="button" class="btn btn-success btn-save-contract-continue"><?= $this->lang->line('ok')?></button>
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
  $('.btn-stepwizard-mb').click(function(event) {
    event.preventDefault();
    target = $(this).data('target');
    $('.stepwizard-step a[href="#' + target + '"]').click();
  });
  $('div.setup-panel div .btn.igniter').trigger('click');
});
</script>

<script src="<?php echo base_url("assets")?>/js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets")?>/js/numeral.min.js"></script>
<script src="<?php echo base_url();?>assets/js/pawn/index.js?rev=<?php echo time(); ?>"></script>
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
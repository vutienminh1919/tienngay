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
      <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
          <div class="stepwizard-step">
            <a href="#step-1" class="btn igniter">Thông tin khách hàng</a>
          </div>
          <div class="stepwizard-step">
            <a href="#step-2" class="btn disabled" disabled>Thông tin việc làm</a>
          </div>
          <div class="stepwizard-step">
            <a href="#step-3" class="btn disabled" disabled>Thông tin người thân</a>
          </div>
          <div class="stepwizard-step">
            <a href="#step-4" class="btn disabled" disabled>Thông tin khoản vay</a>
          </div>
          <div class="stepwizard-step">
            <a href="#step-5" class="btn disabled" disabled>Thông tin giải ngân</a>
          </div>
          <div class="stepwizard-step">
            <a href="#step-6" class="btn disabled" disabled>Thông tin thẩm định</a>
          </div>
        </div>
      </div>
      <div class="alert alert-danger alert-dismissible text-center" style="display:none" id="div_error">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <span class='div_error'></span>
        </div>
      <form role="form" class="form-horizontal form-label-left">
        <?php   $this->load->view('page/pawn/step_create/step1', isset($this->data)?$this->data:NULL);?>
        <?php   $this->load->view('page/pawn/step_create/step2', isset($this->data)?$this->data:NULL);?>
        <?php   $this->load->view('page/pawn/step_create/step3', isset($this->data)?$this->data:NULL);?>
        <?php   $this->load->view('page/pawn/step_create/step4', isset($this->data)?$this->data:NULL);?>
        <?php   $this->load->view('page/pawn/step_create/step5', isset($this->data)?$this->data:NULL);?>
        <?php   $this->load->view('page/pawn/step_create/step6', isset($this->data)?$this->data:NULL);?>
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
        <button type="button" class="btn btn-success btn-save-contract"><?= $this->lang->line('ok')?></button>
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
<script src="<?php echo base_url();?>assets/js/pawn/index.js"></script>
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
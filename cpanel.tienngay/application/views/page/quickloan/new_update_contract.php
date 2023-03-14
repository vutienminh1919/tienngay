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
            <a href="#step-1" class="btn igniter">Thông tin khách hàng</a>
          </div>
          <div class="stepwizard-step">
            <a href="#step-2" class="btn " >Thông tin việc làm</a>
          </div>
          <div class="stepwizard-step">
            <a href="#step-3" class="btn " >Thông tin người thân</a>
          </div>
          <div class="stepwizard-step">
            <a href="#step-4" class="btn " >Thông tin khoản vay</a>
          </div>
          <div class="stepwizard-step">
            <a href="#step-5" class="btn " >Thông tin giải ngân</a>
          </div>
          <div class="stepwizard-step">
            <a href="#step-6" class="btn " >Thông tin thẩm định</a>
          </div>
        </div>
      </div>
      <div class="alert alert-danger alert-dismissible text-center" style="display:none" id="div_error">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <span class='div_error'></span>
        </div>
        <input type="hidden" id="contract_id" value="<?= $_GET['id'] ? $_GET['id'] : ""?>">
      <form role="form" class="form-horizontal form-label-left">
        <?php   $this->load->view('page/pawn/step_update/step1', isset($this->data)?$this->data:NULL);?>
        <?php   $this->load->view('page/pawn/step_update/step2', isset($this->data)?$this->data:NULL);?>
        <?php   $this->load->view('page/pawn/step_update/step3', isset($this->data)?$this->data:NULL);?>
        <?php   $this->load->view('page/pawn/step_update/step4', isset($this->data)?$this->data:NULL);?>
        <?php   $this->load->view('page/pawn/step_update/step5', isset($this->data)?$this->data:NULL);?>
        <?php   $this->load->view('page/pawn/step_update/step6', isset($this->data)?$this->data:NULL);?>
      </form>
      <input type="hidden" id="step_index"  class="form-control">
    </div>












    <div class="col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Hoạt động</h2>

          <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <ul class="list-unstyled timeline workflow widget">
              <?php if(!empty($work_follow)){ 
                  foreach($work_follow as $key => $wl){
                ?>
                <li>
                  <img class="theavatar" src="<?php echo base_url("assets/imgs/avatar_none.png")?>" alt="">
                  <div class="block">
                    <div class="block_content">
                      <h2 class="title">
                        <a><?= !empty($wl->action) ? $wl->action : "";?></a>
                      </h2>
                      <div class="byline">
                        <p><strong><?php echo !empty($wl->created_at) ? date('d/m/Y H:i:s', intval($wl->created_at) + 7*60*60) : "" ?></strong> </p>
                        <p>By: <a><?php echo !empty($wl->created_by) ? $wl->created_by : ''?></a> </p>
                        <!-- <p>To: <a>Smith Jane</a></p> -->

                      </div>
                      <div class="excerpt">
                        <p><?php echo !empty($wl->new->note) ? $wl->new->note : ''?></p>
                        <?php if(!empty($wl->action) && $wl->action =='approve'){ 
                            $old_status = $wl->old->status;
                            $new_status = $wl->new->status;
                          ?>
                        <p>
                        <?php
                          if($old_status == 0){
                              echo "Nháp";
                          }else if($old_status == 1){
                            echo "Mới";
                          }else if($old_status == 2) {
                            echo "Chờ trưởng PGD duyệt";
                          }else if($old_status == 3) {
                              echo "Đã hủy";
                          }else if($old_status == 4) {
                              echo "Trưởng PGD không duyệt";
                          }else if($old_status == 5) {
                              echo "Chờ hội sở duyệt";
                          }else if($old_status == 6) {
                              echo "Đã duyệt";
                          }else if($old_status == 7) {
                              echo "Kế toán không duyệt";
                          }else if($old_status == 15) {
                              echo "Chờ giải ngân";
                          }else if($old_status == 16) {
                              echo "Tạo lệnh giải ngân thành công";
                          }else if($old_status == 17) {
                              echo "Giải ngân thành công";
                          }else if($old_status == 18) {
                              echo "Giải ngân thất bại";
                          }
                          ?>
                            =>   
                            <?php
                          if($new_status == 0){
                              echo "Nháp";
                          }else if($new_status == 1){
                            echo "Mới";
                          }else if($new_status == 2) {
                            echo "Chờ trưởng PGD duyệt";
                          }else if($new_status == 3) {
                              echo "Đã hủy";
                          }else if($new_status == 4) {
                              echo "Trưởng PGD không duyệt";
                          }else if($new_status == 5) {
                              echo "Chờ hội sở duyệt";
                          }else if($new_status == 6) {
                              echo "Đã duyệt";
                          }else if($new_status == 7) {
                              echo "Kế toán không duyệt";
                          }else if($new_status == 15) {
                              echo "Chờ giải ngân";
                          }else if($new_status == 16) {
                              echo "Tạo lệnh giải ngân thành công";
                          }else if($new_status == 17) {
                              echo "Giải ngân thành công";
                          }else if($new_status == 18) {
                              echo "Giải ngân thất bại";
                          }
                          ?>
                        </p>
                        <?php }?>
                        <!-- <ul>
                          <li>Một nội dung nào đó</li>
                          <li><strong>Tiêu đề:</strong> ghi chú một điều gì đó</li>
                          <li>123123</li>
                        </ul> -->
                      </div>
                    </div>
                  </div>
                </li>
              <?php } }?>
            </ul>

        </div>
      </div>
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
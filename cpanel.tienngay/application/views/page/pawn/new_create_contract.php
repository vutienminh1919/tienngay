
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
          <div class="stepwizard-step">
            <a href="#step-1" class="btn igniter">Thông tin khách hàng</a>
          </div>
          <div class="stepwizard-step">
            <a href="#step-2" class="btn  disabled" disabled>Thông tin việc làm</a>
          </div>
          <div class="stepwizard-step">
            <a href="#step-3" class="btn disabled" disabled>Thông tin người thân</a>
          </div>
          <div class="stepwizard-step">
            <a href="#step-4" class="btn <?=(isset($_GET['id_lead'])) ? '': 'disabled' ?>" disabled>Thông tin khoản vay</a>
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
         <a href="#step-1" class="btn btn-stepwizard-mb btn-warning btn-lg w-100 hidden-md hidden-lg" data-target="step-1">
          Thông tin khách hàng
        </a>
        <?php   $this->load->view('page/pawn/step_create/step1', isset($this->data)?$this->data:NULL);?>
      <a href="#step-2" class="btn btn-stepwizard-mb btn-warning btn-lg w-100  hidden-md hidden-lg" data-target="step-2">
          Thông tin việc làm
        </a>
        <?php   $this->load->view('page/pawn/step_create/step2', isset($this->data)?$this->data:NULL);?>
          <a href="#step-3" class="btn btn-stepwizard-mb btn-warning btn-lg w-100  hidden-md hidden-lg" data-target="step-3">
          Thông tin người thân
        </a>
        <?php   $this->load->view('page/pawn/step_create/step3', isset($this->data)?$this->data:NULL);?>
          <a href="#step-4" class="btn btn-stepwizard-mb btn-warning btn-lg w-100  hidden-md hidden-lg" data-target="step-4">
          Thông tin khoản vay
        </a>
        <?php   $this->load->view('page/pawn/step_create/step4', isset($this->data)?$this->data:NULL);?>
        <a href="#step-5" class="btn btn-stepwizard-mb btn-warning btn-lg w-100  hidden-md hidden-lg" data-target="step-5">
          Thông tin giải ngân
        </a>
        <?php   $this->load->view('page/pawn/step_create/step5', isset($this->data)?$this->data:NULL);?>
        <a href="#step-6" class="btn btn-stepwizard-mb btn-warning btn-lg w-100  hidden-md hidden-lg" data-target="step-6">
          Thông tin thẩm định
        </a>
        <?php   $this->load->view('page/pawn/step_create/step6', isset($this->data)?$this->data:NULL);?>
      </form>
      <input type="hidden" id="step_index"  class="form-control">
     
       <input type="hidden" id="id_war" value="">
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

<!--<div class="modal fade" id="checkIdentify" tabindex="-1" role="dialog">-->
<!--  <div class="modal-dialog" role="document">-->
<!--    <div class="modal-content">-->
<!--      <div class="modal-header">-->
<!--        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--        <h4 class="modal-title">Upload & xác thực CMND</h4>-->
<!--      </div>-->
<!--      <div class="modal-body">-->
<!--        <p>Các loại giấy tờ hỗ trợ: CMND cũ, CMND mới, Căn cước công dân</p>-->
<!---->
<!---->
<!--         <div class="row">-->
<!--          <div class="col-xs-12 col-md-6 text-center">-->
<!---->
<!---->
<!--            <img id="imgImg_mattruoc" class="w-100" src="https://via.placeholder.com/350x150" alt="">-->
<!--            Ảnh mặt trước-->
<!--          </div>-->
<!--          <div class="col-xs-12 col-md-6 text-center">-->
<!---->
<!--            <img id="imgImg_matsau" class="w-100" src="https://via.placeholder.com/350x150" alt="">-->
<!--            Ảnh mặt sau-->
<!--          </div>-->
<!--        </div>-->
<!--          <input type='file' id="imgInp_Identify" data-preview="imgInp002" style="visibility: hidden;"  />-->
<!---->
<!---->
<!--        <p class="text-center">-->
<!--          <button type="button" class="btn btn-default return_Identify">Chọn lại</button>-->
<!--          <button type="button" class="btn btn-primary identification_Identify">Nhận dạng</button>-->
<!--        </p>-->
<!--         <div class="alert alert-danger" role="alert">-->
<!---->
<!--        </div>-->
<!--        <div class="text-center" id="Identify_loading">-->
<!--       <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>-->
<!--       <div >Đang xử lý...</div>-->
<!--        </div>-->
<!---->
<!--        <table class="table table-bordered">-->
<!--          <tbody id='list_info_Identify'>-->
<!---->
<!--          </tbody>-->
<!--        </table>-->
<!--        <p class="text-center">-->
<!--          <button type="button" class="btn btn-primary btn-lg apply_info_Identify">Áp dụng</button>-->
<!--        </p>-->
<!--      </div>-->
<!---->
<!--    </div>-->
<!--  </div>-->
<!--</div>-->

<!--<div class="modal fade" id="checkFace_identify" tabindex="-1" role="dialog">-->
<!--  <div class="modal-dialog" role="document">-->
<!--    <div class="modal-content">-->
<!--      <div class="modal-header">-->
<!--        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--        <h4 class="modal-title">Xác thực giấy tờ</h4>-->
<!--      </div>-->
<!--      <div class="modal-body">-->
<!--        <p>Các loại giấy tờ hỗ trợ: Giấy tờ tùy thân, ảnh chân dung.</p>-->
<!---->
<!--        <div class="row">-->
<!--          <div class="col-xs-12 col-md-6 text-center">-->
<!--            <img id="imgImg_giayto" class="w-100" src="https://via.placeholder.com/350x150" alt="">-->
<!--            Ảnh giấy tờ tuỳ thân-->
<!--          </div>-->
<!--          <div class="col-xs-12 col-md-6 text-center">-->
<!--            <img id="imgImg_chandung" class="w-100" src="https://via.placeholder.com/350x150" alt="">-->
<!--            Ảnh chân dung-->
<!--          </div>-->
<!--        </div>-->
<!--        <input type='file' id="imgInp_Face" data-preview="imgInp002" style="visibility: hidden;"  />-->
<!--          <strong>Ảnh giấy tờ tuỳ thân:</strong>-->
<!--          <ul>-->
<!--            <li>Mặt trước rõ, đủ 4 góc.</li>-->
<!---->
<!--            <li>Không chụp giấy tờ tuỳ thân photo, chụp thông qua màn hình thiết bị điện tử.</li>-->
<!--          </ul>-->
<!--          <strong>  Ảnh chân dung chụp:</strong>-->
<!--          <ul>-->
<!--            <li>hụp cận mặt, rõ, thẳng góc, không bị che, không chụp quá xa.</li>-->
<!---->
<!--            <li>Không chụp chân dung từ ảnh, chụp thông qua màn hình thiết bị điện tử.</li>-->
<!--          </ul>-->
<!---->
<!--           <div class="alert alert-danger" role="alert">-->
<!--       -->
<!--        </div>-->
<!--          <p class="text-center">-->
<!--            <button type="button" class="btn btn-default return_Face_Identify">Chọn lại</button>-->
<!--            <button type="button" class="btn btn-primary identification_Face_Identify">Nhận dạng</button>-->
<!--          </p>-->
<!--          <div class="text-center" id="Face_Identify_loading">-->
<!--       <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>-->
<!--       <div >Đang xử lý...</div>-->
<!--        </div>-->
<!---->
<!--<h1 class="text-center text-primary face_identify_results" >  </h1>-->
<!---->
<!--        </div>-->
<!---->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->
<!--  <div class="modal fade" id="checkFace_search" tabindex="-1" role="dialog">-->
<!--  <div class="modal-dialog" role="document">-->
<!--    <div class="modal-content">-->
<!--      <div class="modal-header">-->
<!--        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--        <h4 class="modal-title">Tìm kiếm khuôn mặt</h4>-->
<!--      </div>-->
<!--      <div class="modal-body">-->
<!--        <p>Các loại giấy tờ hỗ trợ:  Ảnh chân dung.</p>-->
<!---->
<!--        <div class="row">-->
<!--        -->
<!--          <div class="col-xs-12 col-md-12 text-center">-->
<!--            <img id="imgImg_chandung_search" class="w-100" src="https://via.placeholder.com/350x150" alt="">-->
<!--            Ảnh chân dung-->
<!--          </div>-->
<!--        </div>-->
<!--        <input type='file' id="imgInp_Face_search" data-preview="imgInp002" style="visibility: hidden;"  />-->
<!--          -->
<!--          <strong>  Ảnh chân dung chụp:</strong>-->
<!--          <ul>-->
<!--            <li>hụp cận mặt, rõ, thẳng góc, không bị che, không chụp quá xa.</li>-->
<!---->
<!--            <li>Không chụp chân dung từ ảnh, chụp thông qua màn hình thiết bị điện tử.</li>-->
<!--          </ul>-->
<!---->
<!--           <div class="alert alert-danger" role="alert">-->
<!--       -->
<!--        </div>-->
<!--          <p class="text-center">-->
<!--            <button type="button" class="btn btn-default return_Face_search">Chọn lại</button>-->
<!--            <button type="button" class="btn btn-primary identification_Face_search">Nhận dạng</button>-->
<!--          </p>-->
<!--          <div class="text-center" id="Face_search_loading">-->
<!--       <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>-->
<!--       <div >Đang xử lý...</div>-->
<!--        </div>-->
<!---->
<!--        <table class="table table-bordered">-->
<!--                  <tbody id='list_info_Face_search'>-->
<!--                   -->
<!--                  </tbody>-->
<!--                </table>-->
<!---->
<!--        </div>-->
<!---->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->
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

    curStepNumb = parseInt(curStepBtn.replace("step-", ""));
    nextStepNumb = curStepNumb + 1;

    nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
    nextStepWizardMB =  $('a[data-target="step-' + nextStepNumb + '"]');


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

    if (isValid) nextStepWizardMB.removeAttr('disabled').removeClass('disabled').trigger('click');


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

	$('#code_vbi').selectize({
		create: false,
		valueField: 'code',
		labelField: 'name',
		searchField: 'name',
		maxItems: 100,
		sortField: {
			field: 'name',
			direction: 'asc'
		}
	});

});
</script>
 <script src="<?php echo base_url();?>assets/js/lead/index.js"></script> 
 <script type="text/javascript">
   <?php if(isset($_GET['id_lead'])){ ?>   
           
    new_contract('<?= $_GET['id_lead']  ?>');
  <?php } ?>
  </script>
<script src="<?php echo base_url("assets")?>/js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets")?>/js/numeral.min.js"></script>
<script src="<?php echo base_url();?>assets/js/pawn/index.js?rev=<?php echo time();?>"></script>

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




<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/template/validate.js"></script>
<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none" >
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span ><?= $this->lang->line('Loading')?>...</span>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<div class="page-title">
				<h3><a href="<?php echo base_url() ?>new_contract/quanlyhopdong">Quản lý hợp đồng</a><a>/Cập nhật hợp đồng vay</a></h3>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="stepwizard">
				<div class="stepwizard-row setup-panel">
					<div class="stepwizard-step">
						<a href="#step-1" class="btn igniter">Nhận dạng khách hàng</a>
					</div>
					<div class="stepwizard-step">
						<a href="#step-2" class="btn disabled" disabled>Thông tin KH và thông tin liên quan</a>
					</div>
					<div class="stepwizard-step">
						<a href="#step-3" class="btn disabled" disabled>Thông tin hồ sơ liên quan</a>
					</div>

				</div>
			</div>
			<form role="form" id="main_1" class="form-horizontal form-label-left" action="/example" method="post" novalidate>
				<!--      <form role="form" class="form-horizontal form-label-left">-->
				<div class="form-horizontal form-label-left">
					<div class="setup-content" id="step-1">
						<?php $this->load->view('page/pawn/new_contract/update/update_quanlyhopdong_addnew_1');?>

					</div>

					<div class="setup-content" id="step-2">

						<?php $this->load->view('page/pawn/new_contract/update/update_quanlyhopdong_addnew_2');?>
					</div>

					<div class="setup-content" id="step-3">

						<?php $this->load->view('page/pawn/new_contract/update/update_quanlyhopdong_addnew_3');?>
					</div>
				</div>
			</form>

		</div>

	</div>
</div>
<!-- /page content -->


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

		allBackBtn.click(function () {
			var curStep = $(this).closest(".setup-content"),
				curStepBtn = curStep.attr("id"),
				prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");
			prevStepWizard.click();

		});

		$('div.setup-panel div .btn.igniter').trigger('click');
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
<script src="<?php echo base_url() ?>assets/js/template/create_contract.js"></script>



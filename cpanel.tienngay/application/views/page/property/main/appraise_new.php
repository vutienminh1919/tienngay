<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3>Định giá tài sản
					<br>
					<small>
						<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a href="#">Định giá
							tài sản</a>
					</small>
				</h3>
			</div>
			<div class="title_right text-right">


				<a href="<?php echo base_url('property_main/listMainProperty') ?>" class="btn btn-info ">
					<i class="fa fa-arrow-left" aria-hidden="true"></i>
					<?= $this->lang->line('Come_back') ?>

				</a>
			</div>
		</div>
	</div>

	<br>&nbsp;
	<div class="row flex justify-content-center">
		<div class="col-xs-12  col-lg-8">
			<div class="card card-appraise">
				<div class="card-body">
					<h5 class="card-title text-danger"><?= $this->lang->line('CHOOSE_THE_TYPE_LOAN') ?></h5>
					<div class="form-group m-0 ">
						<select class="form-control formality appraise" id="type_finance" name="type_loan">
							<?php
							if ($configuration_formality) {
								foreach ($configuration_formality as $key => $cf) {
									if ($cf->status != "active") {
										continue;
									}

									?>
									<?php if ($cf->code == 'TC') continue; ?>
									<option value='<?= !empty($cf->code) ? $cf->code : "" ?>'><?= !empty($cf->name) ? $cf->name : "" ?></option>
								<?php }
							} ?>
						</select>
					</div>
				</div>
				<div class="card-body">
					<h5 class="card-title text-danger"> <?= $this->lang->line('SELECT_ASSETS_WANT_VALUATE') ?></h5>
					<div class="form-group m-0 step2">
						<select class="form-control main_property" id="" name="code_type_property">
							<option value="">Chọn tài sản</option>
							<?php foreach ($mainPropertyData as $main): ?>
								<?php if ($main->code == 'TC' || $main->code == 'NĐ') continue; ?>
								<?php if (!empty($main->_id->{'$oid'}) && $main->_id->{'$oid'} == "5f213c10d6612b465f4cb7b6") {
			                		continue;
			                	} ?>
								<option value="<?php echo $main->code ?>"><?php echo $main->name ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="card-body">
					<div class="form-group m-0 step2">
						<select class="form-control product_property" id="product_property" name="product_property">
							<option value="">Chọn sản phẩm vay</option>
						</select>
					</div>
				</div>
				<div class="card-body">
					<h5 class="card-title text-danger"><?= $this->lang->line('CHOOSE_PROPERTY_INFORMATION') ?> </h5>
					<div class="form-group m-0 step2">
						<select class="form-control car_company" id="car_company" name="car_company">
							<option value="">Chọn hãng xe</option>
						</select>
					</div>
				</div>
				<div class="card-body">
					<div class="form-group m-0 step2">
						<select class="form-control vehicles" id="vehicles" name="vehicles">
							<option value="">Chọn dòng xe</option>
						</select>
					</div>
				</div>
				<div class="card-body">
					<div class="form-group m-0 step2">
						<select class="form-control property_by_main" id="property_by_main" name="property_id">
							<option value="">Chọn thông tin xe</option>
						</select>
					</div>
				</div>
				<div class="card-body">
					<h5 class="card-title text-danger"><?= $this->lang->line('CHOOSE_WHOLESALE_PRODUCT') ?></h5>
					<div class="step3 depreciation_by_property"></div>
				</div>
				<div class="card-body ">
					<h5 class="card-title text-pawn1 text-primary"><?= $this->lang->line('VALUATION_RESULTS') ?>:</h5>
					<div class="result_appraise">
						<div class="card-text">
							<?= $this->lang->line('Your_car_worth') ?>: <span class='depreciation_price'
																			  style="font-weight: bold;color: red;"></span>
							<span style="font-weight: bold;color: red;"></span>
						</div>

						<div class="card-text">
							<?= $this->lang->line('amount_you_borrow') ?>: <span class='amount_money'
																				 style="font-weight: bold;color: red;"></span>
							<span style="font-weight: bold;color: red;"></span>
						</div>
					</div>
				</div>
			</div>

		</div>

	</div>

</div>
<style>
	.selectize-dropdown-content {
		max-height: initial !important;
		background-color: #fff;
	}

	.selecttype.step1 li:nth-child(3), .selecttype.step1 li:nth-child(4) {
		display: none !important;
	}
</style>
<!--<script src="--><?php //echo base_url(); ?><!--assets/js/property/index.js"></script>-->
<script src="<?php echo base_url(); ?>assets/js/property/index_new.js"></script>


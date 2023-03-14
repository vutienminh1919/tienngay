<!-- page content -->
<div class="right_col" role="main">

	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3>Cập nhập loại hình sản phẩm
					<br>
					<small>
						<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
								href="#">Cập nhập loại hình sản
							phẩm</a>
					</small>
				</h3>
			</div>
			<div class="title_right text-right">


				<a href="<?php echo base_url('WebsiteCTVTienNgay/product_list') ?>" class="btn btn-info ">
					<i class="fa fa-arrow-left" aria-hidden="true"></i>
					<?= $this->lang->line('Come_back') ?>

				</a>
			</div>
		</div>
	</div>

	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Thêm các sản phẩm con</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<form class="form-horizontal form-label-left"
					  action="<?php echo base_url("WebsiteCTVTienNgay/doUpdate") ?>" method="post">
					<?php if ($this->session->flashdata('error')) { ?>
						<div class="alert alert-danger alert-result">
							<?= $this->session->flashdata('error') ?>
						</div>
					<?php } ?>
					<?php if ($this->session->flashdata('success')) { ?>
						<div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
					<?php } ?>
					<input type="hidden" name="id_property_main" class="form-control "
						   value="<?= !empty($main_property->_id->{'$oid'}) ? $main_property->_id->{'$oid'} : "" ?>">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Loại tài sản <span
									class="red">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" name='name_product_type' required class="form-control col-md-7 col-xs-12"
								   value="<?= !empty($main_property->name) ? $main_property->name : "" ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12"
							   for="first-name"><?= $this->lang->line('Code') ?>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" name='code_product_type' class="form-control col-md-7 col-xs-12"
								   value="<?= !empty($main_property->code) ? $main_property->code : "" ?>">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Switch</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="radio-inline text-primary">
								<?php
								$status = !empty($main_property->status) ? $main_property->status : "";
								?>
								<label>
									<input type="radio" name="status"
										   value="active" <?php if ($status == "active") echo "checked" ?>> <?= $this->lang->line('Active') ?>
								</label>
							</div>
							<div class="radio-inline text-danger">
								<label>
									<input type="radio" name="status"
										   value="deactive" <?php if ($status == "deactive") echo "checked" ?>> <?= $this->lang->line('Pause') ?>
								</label>
							</div>
						</div>
					</div>
					<?php
					$check_parent_id = "";
					$parent_id = !empty($main_property->parent_id) ? $main_property->parent_id : "";
					if (!empty($parent_id)) {
						$check_parent_id = "style='display:none'";
					}
					?>
					<div id="addForm" <?php echo $check_parent_id ?>class="form-group">
						<div class="col-md-3 col-sm-3 col-xs-12">

						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<button type="button" class="btn btn-info propertiesEdit"><i
										class="fa fa-plus"></i> <?= $this->lang->line('Add_properties') ?></button>
						</div>
					</div>
					<div id="add_properties" <?php echo $check_parent_id ?>>

						<?php
						$properties = !empty($main_property->properties) ? $main_property->properties : "";
						if (!empty($properties)) {
							foreach ($properties as $key => $propertie) {
								?>
								<div id="form_<?php echo $key ?>" class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12"
										   for="first-name"> <?= $this->lang->line('properties') ?></label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<div class='input-group '>
											<input type='text' class="form-control"
												   name='properties[<?php echo $key ?>]'
												   value='<?= !empty($propertie->name) ? $propertie->name : ""; ?>'/>
											<span class="input-group-btn">
                                <a href="javascript:void(0);" class="btn btn-danger" data-id="form_<?php echo $key ?>"
								   onclick="remove_properties(this)"> <i
											class="fa fa-times"></i>  <?= $this->lang->line('Delete') ?></a>
                            </span>
										</div>

									</div>
								</div>
							<?php }
						} ?>
					</div>
					<div id="add_product_pricing">
						<?php
						$depreciations = !empty($main_property->depreciations) ? $main_property->depreciations : "";
						if (!empty($depreciations)) {
							foreach ($depreciations as $keys => $dep) {
								?>
								<div id="form_product_pricing_<?php echo $keys ?>" class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12"
										   for="first-name"><?= $this->lang->line('depreciation') ?>
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">

										<div class='input-group row'>
											<div class="col-xs-6">
												<select name="depreciation[<?php echo $keys ?>]" class="form-control">
													<?php
													if (!empty($depreciationData)) {
														foreach ($depreciationData as $key => $depreciation) {
															?>
															<option value="<?= !empty($depreciation->name) ? $depreciation->name : "" ?>" <?php if ($depreciation->name == $dep->name) echo "selected" ?>><?= !empty($depreciation->name) ? $depreciation->name : "" ?></option>
														<?php }
													} ?>
												</select>

											</div>
											<div class="col-xs-4"><input type='text' class="form-control" required
																		 name='price_depreciation[<?php echo $keys ?>]'
																		 value='<?= !empty($dep->price) ? $dep->price : ""; ?>'/>
											</div>

											<span class="input-group-btn">
                                <a href="javascript:void(0);" class="btn btn-danger"
								   data-id="form_product_pricing_<?php echo $keys ?>"
								   onclick="remove_product_pricing(this)">
                                <i class="fa fa-times"></i> <?= $this->lang->line('Delete') ?>
                                </a>
                            </span>
										</div>

									</div>
								</div>
							<?php }
						} ?>

					</div>


					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
							<button type="submit" class="btn btn-success">Thêm sản phẩm</button>
						</div>
					</div>
				</form>
				</ul>

			</div>
		</div>
	</div>
</div>
<!-- /page content -->
<script src="<?php echo base_url(); ?>assets/js/property/index.js"></script>
<script type="text/javascript">
	var select = $('#parent_package_create').selectize({
		create: false,
		valueField: '_id',
		labelField: 'name',
		searchField: 'name',
		maxItems: 1,
		sortField: {
			field: 'name',
			direction: 'asc'
		},
		onChange: function (value) {
			if (value.length == 0) {
				$('#addForm').show();
				$('#add_properties').show();
			} else {
				$('#addForm').hide();
				$('#add_properties').hide();
			}

		}
	});
</script>

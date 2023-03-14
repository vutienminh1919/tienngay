<!-- page content -->
<div class="right_col" role="main">
	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3>Cài đặt hoa hồng sản phẩm cho website CTV_TienNgay
					<br>
					<small>
						<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
								href="<?php echo base_url('WebsiteCTVTienNgay/product_list') ?>">Cài đặt hoa hồng sản
							phẩm
						</a>
					</small>
				</h3>
			</div>
		</div>
	</div>

	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel form-horizontal">
			<div class="x_title">
				<h2>Cài đặt hoa hồng</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="form-group row">
					<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Loại sản phẩm
						<span class="text-danger">*</span>
					</label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<select class="form-control" id="product_type">
							<option>--Chọn loại hình sản phẩm--</option>
							<?php
							if (!empty($mainPropertyData)) {
								foreach ($mainPropertyData as $key => $property_main) {
									if ($dataInit['main'] == getId($property_main->_id))
										$code_pro = !empty($property_main->code) ? $property_main->code : "";
									?>
									<option data-code="<?= !empty($property_main->code) ? $property_main->code : "" ?>"
											data-id="<?= !empty(getId($property_main->_id)) ? getId($property_main->_id) : "" ?>" <?= $dataInit['main'] == getId($property_main->_id) ? "selected" : "" ?>
											value="<?= !empty($property_main->_id->{'$oid'}) ? $property_main->_id->{'$oid'} : "" ?>"><?= !empty($property_main->name) ? $property_main->name : "" ?></option>
								<?php }
							} ?>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Tiêu đề<span
								class="text-danger">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="text" class="form-control" name="title_commission" id="title_commission" placeholder="Nhập tiêu đề"
							   value="<?php !empty($coupon->title_commission) ? print $coupon->title_commission : print "" ?>">
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Công ty áp dụng<span
								class="text-danger">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<select id="multi-select" class="multi-select" multiple="multiple">
							<?php if (!empty($groupCTV)) :
								foreach ($groupCTV as $group) : ?>
									<option value="<?= !empty($group->_id->{'$oid'}) ? $group->_id->{'$oid'} : ''; ?>"><?= !empty($group->ctv_name) ? $group->ctv_name : ''; ?></option>
								<?php endforeach;
							endif; ?>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						Áp dụng khách lẻ
					</label>
					<div class="col-lg-6 col-sm-12 col-xs-12 ">
						<div class="radio-inline text-primary">
							<label>
								<input type="radio" value="active"
									   name="application_ctv_individual" <?php ($coupon->set_by_coupon == "active") ? print "checked" : print "" ?> >
								Có
							</label>
						</div>
						<div class="radio-inline text-danger">
							<label>
								<input type="radio" name="application_ctv_individual"
									   value="deactive" <?php ($coupon->set_by_coupon == "deactive") ? print "checked" : print "" ?> <?php !isset($coupon->set_by_coupon) ? print "checked" : print "" ?>>
								Không
							</label>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						Ngày bắt đầu <span class="text-danger">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="date" name="start_date" class="form-control start_date"
							   value="<?php !empty($coupon->start_date) ? print date('Y-m-d', $coupon->start_date) : print "" ?>">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						Ngày kết thúc <span class="text-danger">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="date" class="form-control end_date" name="end_date"
							   value="<?php !empty($coupon->end_date) ? print date('Y-m-d', $coupon->end_date) : print "" ?>">
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						Mô tả chi tiết:
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<textarea name="note_commission" id="note" rows="4" cols="100" placeholder=""
								  class="form-control"><?php !empty($coupon->note) ? print $coupon->note : print "" ?></textarea>
					</div>
				</div>
				<!--Thông tin sản phẩm-->
				<div class="x_title">
					<strong><i class="fa fa-product-hunt"
							   aria-hidden="true"></i> Thông tin sản phẩm
					</strong>
					<div class="clearfix"></div>
				</div>
				<div class="properties">

				</div>
				<button class="btn btn-primary pull-right" id="save_commission">Lưu lại</button>
				<a href="<?php echo base_url('WebsiteCTVTienNgay/listCommission') ;?>" class="btn btn-danger pull-right">Quay lại</a>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/build/commission_ctv/bootstrap-multiselect.css">
<script src="<?php echo base_url(); ?>assets/js/website_ctv/index.js"></script>
<script src="<?php echo base_url(); ?>assets/js/website_ctv/bootstrap-multiselect.js"></script>
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

<script type="text/javascript">
	$(document).ready(function () {
		$('#multi-select').multiselect({
			nonSelectedText: '- Chọn Công ty áp dụng -',
			allSelectedText: 'Chọn tất cả',
		});
	});
</script>
<style>
	.discount_addon {
		position: absolute;
		top: 0;
		right: 10px;
		bottom: 0;
		text-align: center;
		padding: 0;
		width: 40px;
		line-height: 30px;
	}
</style>

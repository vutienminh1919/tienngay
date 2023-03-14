<!-- page content -->
<div class="right_col" role="main">
	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3>Cài đặt phí bảo hiểm PTI VTA
					<br>
					<small>
						<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
							href="<?php echo base_url('Pti_vta_fee/createPtiFee') ?>">Cài đặt phí bảo hiểm PTI VTA
						</a>
					</small>
				</h3>
			</div>
		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">

			<div class="x_content">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel form-horizontal">
						<div class="x_title">
							<h2>Cài đặt thông tin</h2>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">

							<div class="form-group row">
								<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Tiêu
									đề<span
										class="text-danger">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" class="form-control" name="title_fee"
										   placeholder="Nhập tiêu đề"
										   value="<?php !empty($coupon->title_commision) ? print $coupon->title_commision : print "" ?>">
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
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								Mô tả chi tiết:
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
						<textarea name="note_fee"  rows="4" cols="100" placeholder=""
								  class="form-control"><?php !empty($coupon->note_commission) ? print $coupon->note_commission : print "" ?></textarea>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div role="tabpanel" class="tab-pane" id="en">
					<br/>
					<div class="form-group row">
						<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Tên gói
							<span class="text-danger">*</span>
						</label>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<input type="text" name="packet"
								   value="<?php !empty($coupon->ptivta_commission_1) ? print $coupon->ptivta_commission_1 : print "" ?>"
								   class="form-control"
								   placeholder="Nhập tên gói. VD: G1, G2, G3">
						</div>
						<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Quỹ 1
							<span class="text-danger">*</span>
						</label>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<input type="text" name="quy_one" required=""
								   value="<?php !empty($coupon->ptivta_commission_2) ? print $coupon->ptivta_commission_2 : print "" ?>"
								   class="form-control only_number"
								   placeholder="Nhập số tiền">
							<span class="input-group-addon ptivta_commission_dv discount_addon">VNĐ</span>
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Quyền lợi tử vong do tai nạn<span
									class="text-danger">*</span>
						</label>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

							<input type="text" name="died_fee" required=""
								   class="form-control only_number" id=""
								   value="<?php !empty($coupon->sxh_commission_1) ? print $coupon->sxh_commission_1 : print "" ?>"
								   placeholder="Nhập số tiền">
							<span class="input-group-addon bhplt_commission_dv discount_addon">VNĐ</span>
						</div>
						<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Quỹ 2
							<span class="text-danger">*</span>
						</label>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<input type="text" name="quy_two" required=""
								   class="form-control only_number"
								   value="<?php !empty($coupon->sxh_commission_2) ? print $coupon->sxh_commission_2 : print "" ?>"
								   placeholder="Nhập số tiền">
							<span class="input-group-addon sxh_commission_dv discount_addon">VNĐ</span>
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Quyền lợi điều trị<span
									class="text-danger">*</span>
						</label>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

							<input type="text" name="therapy_fee" required=""
								   class="form-control only_number"
								   value="<?php !empty($coupon->utv_commission_1) ? print $coupon->utv_commission_1 : print "" ?>"
								   placeholder="Nhập số tiền">
							<span class="input-group-addon bhplt_commission_dv discount_addon">VNĐ</span>
						</div>
						<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Quỹ 3
							<span class="text-danger">*</span>
						</label>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<input type="text" name="quy_three" required=""
								   class="form-control only_number"
								   placeholder="Nhập số tiền"
								   value="<?php !empty($coupon->utv_commission_2) ? print $coupon->utv_commission_2 : print "" ?>"
							><span
									class="input-group-addon utv_commission_dv discount_addon">VNĐ</span>

						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"> 3 tháng<span
									class="text-danger">*</span>
						</label>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

							<input type="text" name="three_month" required=""
								   class="form-control only_number" id=""
								   value="<?php !empty($coupon->easy_commission_1) ? print $coupon->easy_commission_1 : print "" ?>"
								   placeholder="Nhập số tiền">
							<span class="input-group-addon bhplt_commission_dv discount_addon">VNĐ</span>
						</div>
						<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Quỹ 4
							<span class="text-danger">*</span>
						</label>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<input type="text" name="quy_four"
								   required=""
								   value="<?php !empty($coupon->easy_commission_2) ? print $coupon->easy_commission_2 : print "" ?>"
								   class="form-control only_number" placeholder="Nhập số tiền"><span
									class="input-group-addon easy_commission_dv discount_addon">VNĐ</span>
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">6 tháng<span
									class="text-danger">*</span>
						</label>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

							<input type="text" name="six_month" required=""
								   class="form-control only_number"
								   value="<?php !empty($coupon->easy_commission_2) ? print $coupon->easy_commission_2 : print "" ?>"
								   placeholder="Nhập số tiền">
							<span class="input-group-addon bhplt_commission_dv discount_addon">VNĐ</span>
						</div>
						<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Quỹ 5
							<span class="text-danger">*</span>
						</label>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<input type="text" name="quy_five" required=""
								   value="<?php !empty($coupon->bhtnds_commission_2) ? print $coupon->bhtnds_commission_2 : print "" ?>"
								   class="form-control only_number"  placeholder="Nhập số tiền">
							<span class="input-group-addon bhtnds_commission_dv discount_addon">VNĐ</span>
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">01 năm<span
									class="text-danger">*</span>
						</label>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

							<input type="text" name="twelve_month" required=""
								   class="form-control only_number"
								   value="<?php !empty($coupon->bhplt_commission_1) ? print $coupon->bhplt_commission_1 : print "" ?>"
								   placeholder="Nhập số tiền">
							<span class="input-group-addon bhplt_commission_dv discount_addon">VNĐ</span>
						</div>
						<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Quỹ 6
							<span class="text-danger">*</span>
						</label>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<input type="text" name="quy_six" required=""
								   value="<?php !empty($coupon->bhplt_commission_2) ? print $coupon->bhplt_commission_2 : print "" ?>"
								   class="form-control only_number"
								   placeholder="Nhập số tiền">
							<span class="input-group-addon bhplt_commission_dv discount_addon">VNĐ</span>
						</div>
					</div>
				</div>
				<br>
				<div class="form-group row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						<?php print $this->lang->line('status')?>
					</label>
					<div class="col-lg-6 col-sm-12 col-xs-12 ">
						<div class="radio-inline text-primary">
							<label>
								<input type="radio" name="status" value="active" <?php ($coupon->status=="active") ? print "checked" : print "" ?>  <?php !isset($coupon->status) ? print "checked" : print "" ?>> <?php print $this->lang->line('active')?>
							</label>
						</div>
						<div class="radio-inline text-danger">
							<label>
								<input type="radio"  name="status" value="deactive" <?php ($coupon->status=="deactive") ? print "checked" : print "" ?>> <?php print $this->lang->line('deactive')?>
							</label>
						</div>
					</div>
				</div>
				<button class="btn btn-primary pull-right" id="create_pti_fee">Tạo mới</button>
				<a href="<?php echo base_url('Pti_vta_fee'); ?>"
				   class="btn btn-danger pull-right">Quay lại
				</a>
			</div>
		</div>

	</div>

	<script src="<?php echo base_url(); ?>assets/js/pti_vta/pti_fee.js"></script>

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

		jQuery.fn.extend({
			toggleText: function (a, b){
				var isClicked = false;
				var that = this;
				this.click(function (){
					if (isClicked) { that.text(a); isClicked = false; }
					else { that.text(b); isClicked = true; }
				});
				return this;
			}
		});



		$(".fa-refresh").click(function () {
			if($(this).prev().text() === "%")
			{
				$(this).prev().text("VNĐ");
			}
			else {
				$(this).prev().text("%");
			}
		})
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
		i.fa.fa-refresh {
			position: absolute;
			top: 11px;
			right: -13px;
			cursor: pointer;
		}
		.tooltip {
			opacity: 1;
			position: absolute;
			right: -45px;
			top: 4px;
		}

		.tooltip .tooltiptext {
			visibility: visible;
			position: absolute;
			width: 120px;
			background-color: #555;
			color: #fff;
			text-align: center;
			padding: 5px 0;
			border-radius: 6px;
			z-index: 1;
			opacity: 1;
			transition: opacity 1s;
		}
		.tooltip-right {
			left: 110%;
			top: 7%;
		}
		.tooltip-right::after{
			content: "";
			position: absolute;
			top: 50%;
			right: 100%;
			margin-top: -5px;
			border-width: 5px;
			border-style: solid;
			border-color: transparent #555 transparent transparent;
		}
	</style>

<?php
$id = (isset($_GET['id']) && !empty($_GET['id'])) ? $_GET['id'] : '';
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span>Đang Xử Lý...</span>
	</div>
	<div class="row">


		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3><?php echo $this->lang->line('create_coupon') ?>
						<br/><br/>
						<small><a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
									href="<?php echo base_url('coupon/listCoupon') ?>"><?php echo $this->lang->line('coupon_list') ?></a>
							/
							<a href="#"><?= (empty($id)) ? $this->lang->line('create_coupon') : $this->lang->line('update_coupon') ?></a></small>
					</h3>
				</div>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">

				<div class="x_content">
					<div class="alert alert-danger alert-dismissible text-center" style="display:none" id="div_error">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<span class='div_error'></span>
					</div>
					<form class="form-horizontal form-label-left" id="form_coupon" enctype="multipart/form-data"
						  action="<?php echo base_url("coupon/doAddCoupon") ?>" method="post">
						<input type="hidden" name="id_coupon" class="form-control "
							   value="<?= !empty($coupon->_id->{'$oid'}) ? $coupon->_id->{'$oid'} : "" ?>">
						<div class="group-tabs">
							<!-- Nav tabs -->
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#vi" aria-controls="home" role="tab"
																		  data-toggle="tab">Cài đặt Thông tin</a></li>
								<li role="presentation"><a href="#en" aria-controls="profile" role="tab"
														   data-toggle="tab">Cài đặt phí giảm trừ</a></li>
							</ul>
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="vi">
									<br/>
									<div class="form-group">
										<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Mã coupon
											<span class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" class="form-control code" name="code"
												   value="<?php !empty($coupon->code) ? print $coupon->code : print "" ?>">
										</div>
									</div>
									<div class="form-group row">
										<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Hình thức
											vay<span class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select class="form-control formality" name="type_loan" id="type_loan">
												<option value=''> Chọn hình thức vay</option>
												<?php
												if ($configuration_formality) {
													foreach ($configuration_formality as $key => $cf) {
														?>
														<option <?= (isset($coupon->type_loan) && getId($cf->_id) == $coupon->type_loan) ? 'selected' : '' ?>
																value="<?= !empty(getId($cf->_id)) ? getId($cf->_id) : "" ?>"><?= !empty($cf->name) ? $cf->name : "" ?></option>
													<?php }
												} ?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Sản phẩm
											vay<span class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select class="form-control " name="loan_product[]" multiple="multiple"
													id="loan_product">
												<option value=''> Chọn sản phẩm vay</option>
												<?php

												foreach (loan_products() as $key => $value) {
													?>
													<option value="<?php echo $key; ?>" <?php if (!empty($coupon->loan_product) && in_array((string)$key, $coupon->loan_product)) {
														echo 'selected';
													} else {
														echo '';
													} ?> ><?= $value ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('Property_type') ?>
											<span class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select class="form-control" id="type_property" name="type_property">
												<option value=''> Chọn Loại tài sản</option>
												<?php
												if (!empty($mainPropertyData)) {
													foreach ($mainPropertyData as $key => $property_main) {
														?>
														<option <?= (isset($coupon->type_property) && getId($property_main->_id) == $coupon->type_property) ? 'selected' : '' ?>
																value="<?= !empty($property_main->_id->{'$oid'}) ? $property_main->_id->{'$oid'} : "" ?>"><?= !empty($property_main->name) ? $property_main->name : "" ?></option>
													<?php }
												} ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Thời gian vay
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select class="form-control" id="number_day_loan" name="number_day_loan[]"
													multiple="multiple">
												<?php
												$number_day_loan = (isset($coupon->number_day_loan) && is_array($coupon->number_day_loan)) ? $coupon->number_day_loan : array();
												// var_dump($number_day_loan); die;
												?>
												<option value=''> Chọn thời gian vay</option>
												<option value="30" <?= (is_array($number_day_loan) && in_array("30", $number_day_loan)) ? 'selected' : '' ?> >
													1 tháng
												</option>
												<option value="90" <?= (is_array($number_day_loan) && in_array("90", $number_day_loan)) ? 'selected' : '' ?>>
													3 tháng
												</option>
												<option value="180" <?= (is_array($number_day_loan) && in_array("180", $number_day_loan)) ? 'selected' : '' ?>>
													6 tháng
												</option>
												<option value="270" <?= (is_array($number_day_loan) && in_array("270", $number_day_loan)) ? 'selected' : '' ?>>
													9 tháng
												</option>
												<option value="360" <?= (is_array($number_day_loan) && in_array("360", $number_day_loan)) ? 'selected' : '' ?>>
													12 tháng
												</option>
												<option value="540" <?= (is_array($number_day_loan) && in_array("540", $number_day_loan)) ? 'selected' : '' ?>>
													18 tháng
												</option>
												<option value="720" <?= (is_array($number_day_loan) && in_array("720", $number_day_loan)) ? 'selected' : '' ?>>
													24 tháng
												</option>

											</select>
										</div>
									</div>

									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											<?php echo $this->lang->line('province') ?> <span
													class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select class="form-control" name="selectize_province"
													id="selectize_province">
												<option value="">Chọn tỉnh / thành phố</option>
												<?php
												if (!empty($provinceData)) {
													foreach ($provinceData as $key => $province) {
														?>
														<option <?= (isset($coupon->selectize_province) && $province->code == $coupon->selectize_province) ? 'selected' : '' ?>
																value="<?= !empty($province->code) ? $province->code : ""; ?>"><?= !empty($province->name) ? $province->name : ""; ?></option>
													<?php }
												} ?>
											</select>

										</div>
									</div>

									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											Vùng
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select class="form-control district_shop" name="code_area[]"
													multiple="multiple" id="code_area">
												<option value="">Chọn khu vực</option>

												<?php
												if (!empty($areaData)) {

													foreach ($areaData as $key => $area) {

														?>
														<option value="<?= !empty($area->code) ? $area->code : ""; ?>" <?php if (!empty($coupon->code_area) && in_array($area->code, $coupon->code_area)) {
															echo 'selected';
														} else {
															echo '';
														} ?>><?= !empty($area->title) ? $area->title : ""; ?></option>
													<?php }
												} ?>
											</select>

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
											Phòng giao dịch <span class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select id="code_store" class="form-control" name="code_store">
												<option value=""><?= $this->lang->line('All') ?></option>
												<?php foreach ($storeData as $p) {
													if (!empty($stores)) {
														if (!in_array($p->id, $stores))
															continue;
													}
													?>
													<option <?= (isset($coupon->code_store) && $p->id == $coupon->code_store) ? 'selected' : '' ?>
															value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											Tên sự kiện: <span class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" class="form-control event" name="event"
												   value="<?php !empty($coupon->event) ? print $coupon->event : print "" ?>">
										</div>
									</div>
									<div class="form-group row">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">
											Mô tả chi tiết: <span class="text-danger">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<textarea name="note" id="note" rows="4" cols="100" placeholder=""
													  class="form-control"><?php !empty($coupon->note) ? print $coupon->note : print "" ?></textarea>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="en">
									<br/>
									<input type="hidden" class="form-control contract_id_fee">
									<div class="col-md-6 col-sm-6 col-xs-12">
										<label>Lãi suất phải thu của người vay:</label>
										<input type="number" class="form-control percent_interest_customer"
											   name="percent_interest_customer"
											   value="<?php !empty($coupon->percent_interest_customer) ? print $coupon->percent_interest_customer : print "0" ?>">

										<label>Phí tư vấn quản lý:</label>
										<input type="number" class="form-control percent_advisory"
											   name="percent_advisory"
											   value="<?php !empty($coupon->percent_advisory) ? print $coupon->percent_advisory : print "0" ?>">

										<label>Phí thẩm định và lưu trữ tài sản đảm bảo:</label>
										<input type="number" class="form-control percent_expertise"
											   name="percent_expertise"
											   value="<?php !empty($coupon->percent_expertise) ? print $coupon->percent_expertise : print "0" ?>">

										<label>Phần trăm phí quản lý số tiền vay chậm trả:</label>
										<input type="number" class="form-control penalty_percent" name="penalty_percent"
											   value="<?php !empty($coupon->penalty_percent) ? print $coupon->penalty_percent : print "0" ?>"
											   disabled>

										<label>Số tiền quản lý số tiền vay chậm trả:</label>
										<input type="number" class="form-control penalty_amount" name="penalty_amount"
											   value="<?php !empty($coupon->penalty_amount) ? print $coupon->penalty_amount : print "0" ?>"
											   disabled>

										<label>Phí tư vấn gia hạn:</label>
										<input type="number" class="form-control extend" name="extend"
											   value="<?php !empty($coupon->extend) ? print $coupon->extend : print "0" ?>"
											   disabled>

										<label>Phí tất toán(trước 1/3):</label>
										<input type="number" class="form-control percent_prepay_phase_1"
											   name="percent_prepay_phase_1"
											   value="<?php !empty($coupon->percent_prepay_phase_1) ? print $coupon->percent_prepay_phase_1 : print "0" ?>"
											   disabled>

										<label>Phí tất toán(trước 2/3):</label>
										<input type="number" class="form-control percent_prepay_phase_2"
											   name="percent_prepay_phase_2"
											   value="<?php !empty($coupon->percent_prepay_phase_2) ? print $coupon->percent_prepay_phase_2 : print "0" ?>"
											   disabled>

										<label>Phí tất toán(sau 2/3):</label>
										<input type="number" class="form-control percent_prepay_phase_3"
											   name="percent_prepay_phase_3"
											   value="<?php !empty($coupon->percent_prepay_phase_3) ? print $coupon->percent_prepay_phase_3 : print "0" ?>"
											   disabled>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								Giảm lãi 1 tháng đầu
							</label>
							<div class="col-lg-6 col-sm-12 col-xs-12 ">
								<div class="radio-inline text-primary">
									<label>
										<input type="radio" value="active"
											   name="down_interest_on_month" <?php ($coupon->down_interest_on_month == "active") ? print "checked" : print "" ?> >
										Có
									</label>
								</div>
								<div class="radio-inline text-danger">
									<label>
										<input type="radio" name="down_interest_on_month"
											   value="deactive" <?php ($coupon->down_interest_on_month == "deactive") ? print "checked" : print "" ?> <?php !isset($coupon->down_interest_on_month) ? print "checked" : print "" ?>>
										Không
									</label>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								Giảm lãi 3 tháng đầu
							</label>
							<div class="col-lg-6 col-sm-12 col-xs-12 ">
								<div class="radio-inline text-primary">
									<label>
										<input type="radio" value="active"
											   name="reduction_interest" <?php ($coupon->is_reduction_interest == "active") ? print "checked" : print "" ?> >
										Có
									</label>
								</div>
								<div class="radio-inline text-danger">
									<label>
										<input type="radio" name="reduction_interest"
											   value="deactive" <?php ($coupon->is_reduction_interest == "deactive") ? print "checked" : print "" ?> <?php !isset($coupon->is_reduction_interest) ? print "checked" : print "" ?>>
										Không
									</label>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								Áp dụng giá trị coupon cho tất cả trường hợp
							</label>
							<div class="col-lg-6 col-sm-12 col-xs-12 ">
								<div class="radio-inline text-primary">
									<label>
										<input type="radio" value="active"
											   name="set_by_coupon" <?php ($coupon->set_by_coupon == "active") ? print "checked" : print "" ?> >
										Có
									</label>
								</div>
								<div class="radio-inline text-danger">
									<label>
										<input type="radio" name="set_by_coupon"
											   value="deactive" <?php ($coupon->set_by_coupon == "deactive") ? print "checked" : print "" ?> <?php !isset($coupon->set_by_coupon) ? print "checked" : print "" ?>>
										Không
									</label>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								Tự động chọn
							</label>
							<div class="col-lg-6 col-sm-12 col-xs-12 ">
								<div class="radio-inline text-primary">
									<label>
										<input type="radio" value="active"
											   name="chon_tu_dong" <?php ($coupon->chon_tu_dong == "active") ? print "checked" : print "" ?> >
										Có
									</label>
								</div>
								<div class="radio-inline text-danger">
									<label>
										<input type="radio" name="chon_tu_dong"
											   value="deactive" <?php ($coupon->chon_tu_dong == "deactive") ? print "checked" : print "" ?> <?php !isset($coupon->chon_tu_dong) ? print "checked" : print "" ?>>
										Không
									</label>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								<?php print $this->lang->line('status') ?>
							</label>
							<div class="col-lg-6 col-sm-12 col-xs-12 ">
								<div class="radio-inline text-primary">
									<label>
										<input type="radio" name="status"
											   value="active" <?php ($coupon->status == "active") ? print "checked" : print "" ?>  <?php !isset($coupon->status) ? print "checked" : print "" ?>> <?php print $this->lang->line('active') ?>
									</label>
								</div>
								<div class="radio-inline text-danger">
									<label>
										<input type="radio" name="status"
											   value="deactive" <?php ($coupon->status == "deactive") ? print "checked" : print "" ?>> <?php print $this->lang->line('deactive') ?>
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
								<button class="btn btn-success  create_coupon">
									<i class="fa fa-save"></i>
									<?php echo $this->lang->line('save') ?>
								</button>
								<a href="#" class="btn btn-info ">
									<i class="fa fa-arrow-left"
									   aria-hidden="true"></i> <?php echo $this->lang->line('back') ?>

								</a>
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->
<script src="<?php echo base_url(); ?>assets/js/coupon/index.js"></script>

<style type="text/css">
	textarea {

		white-space: pre;

		overflow-wrap: normal;

		overflow-x: scroll;

	}
</style>
<script>
	function readURL_all(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			var parent = $(input).closest('.form-group');
			//console.log(parent);
			reader.onload = function (e) {
				parent.find('.wrap').hide('fast');
				parent.find('.blah').attr('src', e.target.result);
				parent.find('.wrap').show('fast');
			}

			reader.readAsDataURL(input.files[0]);
		}
	}

	$(".x_content").on('change', '.imgInp', function () {

		readURL_all(this);
	});
</script>

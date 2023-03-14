<!-- page content -->
<div class="right_col" role="main">
	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3>Cài đặt hoa hồng khối Kinh Doanh
					<br>
					<small>
						<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
								href="<?php echo base_url('Commission_kpi/listCommission') ?>">Cài đặt hoa hồng khối kinh
							doanh
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
												<input type="text" class="form-control" name="title_commision"
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
						<textarea name="note_commission"  rows="4" cols="100" placeholder=""
								  class="form-control"><?php !empty($coupon->note_commission) ? print $coupon->note_commission : print "" ?></textarea>
										</div>
									</div>
								</div>
							</div>
				<div class="group-tabs">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#vi" aria-controls="home" role="tab"
						data-toggle="tab">Cài đặt hoa hồng khoản vay</a></li>
					<li role="presentation"><a href="#en" aria-controls="profile" role="tab" data-toggle="tab">
					Cài đặt hoa hồng bảo hiểm</a></li>
					</ul>
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="vi">
							<br/>
							<div class="form-group row">
								<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
								</label>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
								Nguồn lead	Hội sở + CTV
								</div>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
								Nguồn lead	Tự kiếm
								</div>
							</div>
							<div class="form-group row">
								<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
									Vay qua đăng ký xe máy (<12 HĐ)
									<span class="text-danger">*</span>
								</label>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

									<input type="text" name="dkxm_commission_1" required=""
										   class="form-control property-infor" value="<?php !empty($coupon->dkxm_commission_1) ? print $coupon->dkxm_commission_1 : print "" ?>" 
										   placeholder="Nhập phần trăm hoặc tiền hoa hồng">
								</div>


								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
									<input type="text" name="dkxm_commission_2"
									       value="<?php !empty($coupon->dkxm_commission_2) ? print $coupon->dkxm_commission_2 : print "" ?>" 
										   class="form-control property-infor"
										   placeholder="Nhập phần trăm hoặc tiền hoa hồng">
									<span class="input-group-addon dkxm_commission_dv discount_addon">%</span>

									<i class="fa fa-refresh" aria-hidden="true"></i>
									<div class="tooltip">
										<span class="tooltiptext tooltip-right">Thay đổi đơn vị</span>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
									Vay qua đăng ký xe máy (>=12 HĐ)
									<span class="text-danger">*</span>
								</label>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

									<input type="text" id="dkxm_commission_new_3" required=""
										   class="form-control property-infor" value="<?php !empty($coupon->dkxm_commission_new_3) ? print $coupon->dkxm_commission_new_3 : print "" ?>"
										   placeholder="Nhập phần trăm hoặc tiền hoa hồng">
								</div>


								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
									<input type="text" id="dkxm_commission_new_4"
										   value="<?php !empty($coupon->dkxm_commission_new_4) ? print $coupon->dkxm_commission_new_4 : print "" ?>"
										   class="form-control property-infor"
										   placeholder="Nhập phần trăm hoặc tiền hoa hồng">
									<span class="input-group-addon discount_addon">%</span>

									<i class="fa fa-refresh" aria-hidden="true"></i>
									<div class="tooltip">
										<span class="tooltiptext tooltip-right">Thay đổi đơn vị</span>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Vay nhanh lắp thiết bị định vị<span
											class="text-danger">*</span>
								</label>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

									<input type="text" name="vay_nhanh_lap_dinh_vi_new_1" required=""
										   class="form-control property-infor" 
										   value="<?php !empty($coupon->vay_nhanh_lap_dinh_vi_new_1) ? print $coupon->vay_nhanh_lap_dinh_vi_new_1 : print "" ?>"
										   placeholder="Nhập phần trăm hoặc tiền hoa hồng">
								</div>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
									<input type="text" name="vay_nhanh_lap_dinh_vi_new_2"
									  value="<?php !empty($coupon->vay_nhanh_lap_dinh_vi_new_2) ? print $coupon->vay_nhanh_lap_dinh_vi_new_2 : print "" ?>"
										   class="form-control property-infor" 
										   placeholder="Nhập phần trăm hoặc tiền hoa hồng">
									<span class="input-group-addon vay_nhanh_lap_dinh_vi_dv discount_addon">%</span>
									<i class="fa fa-refresh" aria-hidden="true"></i>
									<div class="tooltip">
										<span class="tooltiptext tooltip-right">Thay đổi đơn vị</span>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Topup<span
											class="text-danger">*</span>
								</label>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

									<input type="text" name="topup_commission"
								value="<?php !empty($coupon->topup_commission) ? print $coupon->topup_commission : print "" ?>"
										   class="form-control property-infor" id=""
										   data-slug="" data-name=""
										   placeholder="Nhập phần trăm hoặc tiền hoa hồng">
								</div>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
									<input type="text" name="topup_commission"
							value="<?php !empty($coupon->topup_commission) ? print $coupon->topup_commission : print "" ?>"
										   class="form-control property-infor"  placeholder="Nhập phần trăm hoặc tiền hoa hồng"><span
											class="input-group-addon topup_commission_dv discount_addon">%</span>
									<i class="fa fa-refresh" aria-hidden="true"></i>
									<div class="tooltip">
										<span class="tooltiptext tooltip-right">Thay đổi đơn vị</span>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Vay qua ĐKX ô tô (<2 HĐ)<span
										class="text-danger">*</span>
								</label>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

									<input type="text" name="dkoto_commission_1"
										   value="<?php !empty($coupon->dkoto_commission_1) ? print $coupon->dkoto_commission_1 : print "" ?>"
										   class="form-control property-infor" id=""
										   data-slug="" data-name=""
										   placeholder="Nhập phần trăm hoặc tiền hoa hồng">
								</div>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
									<input type="text" name="dkoto_commission_2"
										   value="<?php !empty($coupon->dkoto_commission_2) ? print $coupon->dkoto_commission_2 : print "" ?>"
										   class="form-control property-infor"  placeholder="Nhập phần trăm hoặc tiền hoa hồng"><span
										class="input-group-addon dkoto_commission_dv discount_addon">%</span>
									<i class="fa fa-refresh" aria-hidden="true"></i>
									<div class="tooltip">
										<span class="tooltiptext tooltip-right">Thay đổi đơn vị</span>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Vay qua ĐKX ô tô (>2 HĐ)<span
										class="text-danger">*</span>
								</label>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

									<input type="text" name="dkoto_commission_3"
										   value="<?php !empty($coupon->dkoto_commission_3) ? print $coupon->dkoto_commission_3 : print "" ?>"
										   class="form-control property-infor" id=""
										   data-slug="" data-name=""
										   placeholder="Nhập phần trăm hoặc tiền hoa hồng">
								</div>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
									<input type="text" name="dkoto_commission_4"
										   value="<?php !empty($coupon->dkoto_commission_4) ? print $coupon->dkoto_commission_4 : print "" ?>"
										   class="form-control property-infor"  placeholder="Nhập phần trăm hoặc tiền hoa hồng"><span
										class="input-group-addon discount_addon">%</span>
									<i class="fa fa-refresh" aria-hidden="true"></i>
									<div class="tooltip">
										<span class="tooltiptext tooltip-right">Thay đổi đơn vị</span>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
								</label>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
								Chi phí vay	Từ 4% trở lên
								</div>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
								Chi Phí vay	Dưới 4%
								</div>
							</div>
							<div class="form-group row">
								<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Vay qua BĐS<span
											class="text-danger">*</span>
								</label>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

								<input type="text" name="vqbds_commission_1" required=""
										   class="form-control property-infor"
										   value="<?php !empty($coupon->vqbds_commission_1) ? print $coupon->vqbds_commission_1 : print "" ?>"
										   placeholder="Nhập phần trăm hoặc tiền hoa hồng">
								</div>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
									<input type="text" name="vqbds_commission_2" 
									value="<?php !empty($coupon->vqbds_commission_2) ? print $coupon->vqbds_commission_2 : print "" ?>"
										   class="form-control property-infor"  placeholder="Nhập phần trăm hoặc tiền hoa hồng"><span
											class="input-group-addon vqbds_commission_dv discount_addon">%</span>
									<i class="fa fa-refresh" aria-hidden="true"></i>
									<div class="tooltip">
										<span class="tooltiptext tooltip-right">Thay đổi đơn vị</span>
									</div>
								</div>
							</div>
							
						</div>
						<div role="tabpanel" class="tab-pane" id="en">
							<br/>
                        <div class="form-group row">
								<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
								</label>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
								CBCNV tự bán
								</div>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
								Bán kèm HĐ vay

								</div>
							</div>
							<div class="form-group row">
								<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
									PTI Vững Tâm An
									<span class="text-danger">*</span>
								</label>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

									<input type="text" name="ptivta_commission_1" 
									value="<?php !empty($coupon->ptivta_commission_1) ? print $coupon->ptivta_commission_1 : print "" ?>"
										   class="form-control property-infor"
										   placeholder="Nhập phần trăm hoặc tiền hoa hồng">
								</div>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
									<input type="text" name="ptivta_commission_2" required=""
									value="<?php !empty($coupon->ptivta_commission_2) ? print $coupon->ptivta_commission_2 : print "" ?>"
										   class="form-control property-infor"
										   class="form-control property-infor"
										   placeholder="Nhập phần trăm hoặc tiền hoa hồng">
									<span class="input-group-addon ptivta_commission_dv discount_addon">%</span>

									<i class="fa fa-refresh" aria-hidden="true"></i>
									<div class="tooltip">
										<span class="tooltiptext tooltip-right">Thay đổi đơn vị</span>
									</div>


								</div>
							</div>
							<div class="form-group row">
								<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Sốt xuất huyết<span
											class="text-danger">*</span>
								</label>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

									<input type="text" name="sxh_commission_1" required=""
										   class="form-control property-infor" id=""
										  value="<?php !empty($coupon->sxh_commission_1) ? print $coupon->sxh_commission_1 : print "" ?>"
										   placeholder="Nhập phần trăm hoặc tiền hoa hồng">
								</div>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
									<input type="text" name="sxh_commission_2" required=""
										   class="form-control property-infor" 
										    value="<?php !empty($coupon->sxh_commission_2) ? print $coupon->sxh_commission_2 : print "" ?>"
										   placeholder="Nhập phần trăm hoặc tiền hoa hồng">
									<span class="input-group-addon sxh_commission_dv discount_addon">%</span>
									<i class="fa fa-refresh" aria-hidden="true"></i>
									<div class="tooltip">
										<span class="tooltiptext tooltip-right">Thay đổi đơn vị</span>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Ung thư vú<span
											class="text-danger">*</span>
								</label>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

									<input type="text" name="utv_commission_1" required=""
										   class="form-control property-infor" 
										   value="<?php !empty($coupon->utv_commission_1) ? print $coupon->utv_commission_1 : print "" ?>"
										   placeholder="Nhập phần trăm hoặc tiền hoa hồng">
								</div>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
									<input type="text" name="utv_commission_2" required=""
										   class="form-control property-infor" 
										   placeholder="Nhập phần trăm hoặc tiền hoa hồng"
										    value="<?php !empty($coupon->utv_commission_2) ? print $coupon->utv_commission_2 : print "" ?>"
										   ><span
											class="input-group-addon utv_commission_dv discount_addon">%</span>
									<i class="fa fa-refresh" aria-hidden="true"></i>
									<div class="tooltip">
										<span class="tooltiptext tooltip-right">Thay đổi đơn vị</span>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">GIC Easy<span
											class="text-danger">*</span>
								</label>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

									<input type="text" name="easy_commission_1" required=""
										   class="form-control property-infor" id=""
										    value="<?php !empty($coupon->easy_commission_1) ? print $coupon->easy_commission_1 : print "" ?>"
										   placeholder="Nhập phần trăm hoặc tiền hoa hồng">
								</div>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
									<input type="text" name="easy_commission_2" 
									       required=""
									       value="<?php !empty($coupon->easy_commission_2) ? print $coupon->easy_commission_2 : print "" ?>"
										   class="form-control property-infor" placeholder="Nhập phần trăm hoặc tiền hoa hồng"><span
											class="input-group-addon easy_commission_dv discount_addon">%</span>
									<i class="fa fa-refresh" aria-hidden="true"></i>
									<div class="tooltip">
										<span class="tooltiptext tooltip-right">Thay đổi đơn vị</span>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">BH TNDS(xe máy MIC)<span
											class="text-danger">*</span>
								</label>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

									<input type="text" name="bhtnds_commission_1" required=""
										   class="form-control property-infor" 
										    value="<?php !empty($coupon->easy_commission_2) ? print $coupon->easy_commission_2 : print "" ?>"
										   placeholder="Nhập phần trăm hoặc tiền hoa hồng">
								</div>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
									<input type="text" name="bhtnds_commission_2" required=""
									value="<?php !empty($coupon->bhtnds_commission_2) ? print $coupon->bhtnds_commission_2 : print "" ?>"
										   class="form-control property-infor"  placeholder="Nhập phần trăm hoặc tiền hoa hồng">
									<span class="input-group-addon bhtnds_commission_dv discount_addon">%</span>
									<i class="fa fa-refresh" aria-hidden="true"></i>
									<div class="tooltip">
										<span class="tooltiptext tooltip-right">Thay đổi đơn vị</span>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">BH Phúc Lộc Thọ<span
											class="text-danger">*</span>
								</label>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

									<input type="text" name="bhplt_commission_1" required=""
										   class="form-control property-infor" 
										   value="<?php !empty($coupon->bhplt_commission_1) ? print $coupon->bhplt_commission_1 : print "" ?>"
										   placeholder="Nhập phần trăm hoặc tiền hoa hồng">
								</div>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
									<input type="text" name="bhplt_commission_2" required=""
									value="<?php !empty($coupon->bhplt_commission_2) ? print $coupon->bhplt_commission_2 : print "" ?>"
										   class="form-control property-infor" 
										   placeholder="Nhập phần trăm hoặc tiền hoa hồng">
									<span class="input-group-addon bhplt_commission_dv discount_addon">%</span>
									<i class="fa fa-refresh" aria-hidden="true"></i>
									<div class="tooltip">
										<span class="tooltiptext tooltip-right">Thay đổi đơn vị</span>
									</div>
								</div>
							</div>
						</div>
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
                        <input type="radio"   name="status" value="deactive" <?php ($coupon->status=="deactive") ? print "checked" : print "" ?>> <?php print $this->lang->line('deactive')?>
                      </label>
                    </div>
                  </div>
                </div>
						<button class="btn btn-primary pull-right" id="save_commission">Lưu lại</button>
						<a href="<?php echo base_url('Commission_kpi/listCommission'); ?>"
						   class="btn btn-danger pull-right">Quay lại</a>
					</div>
				</div>
			</div>
		</div>

	</div>

	<script src="<?php echo base_url(); ?>assets/js/commission_kpi/index.js"></script>

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

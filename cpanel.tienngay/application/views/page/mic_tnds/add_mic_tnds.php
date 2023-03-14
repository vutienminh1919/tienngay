<link href="<?php echo base_url(); ?>assets/teacupplugin/magnify/css/jquery.magnify.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/teacupplugin/magnify/js/jquery.magnify.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>

<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span>Đang xử lý...</span>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>Thêm mới bảo hiểm TNDS
						<br>
						<small><a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
									href="<?php echo base_url('mic_tnds') ?>">Danh sách bảo hiểm TNDS</a>
							/ <a href="#">Bán mới</a></small>
					</h3>
				</div>
				<div class="title_right" style="text-align: right;">
					<button class="btn btn-warning" id="choose_date">Chọn ngày</button>
					<label for="">Lưu ý: <i>Áp dụng trong trường hợp khách hàng đã mua bảo hiểm MIC TNDS xe máy còn hiệu lực</i></label>
				</div>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<div class="row">
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
								<label class="control-label">
									Tên khách hàng <span class="text-danger">*</span>
								</label>
								<input type="text" name="ten_kh" class="form-control "
									   placeholder="Nhập tên khách hàng" required>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
								<label class="control-label">
									Biển số xe <span class="text-danger">*</span>
								</label>
								<input type="text" name="bien_xe" class="form-control "
									   placeholder="Nhập biển số xe" required>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
								<label class="control-label">
									Số điện thoại <span class="text-danger">*</span>
								</label>
								<input type="number" name="phone" class="form-control "
									   placeholder="Nhập số điện thoại" required>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
								<label class="control-label">
									Ngày sinh <span class="text-danger">*</span>
								</label>
								<input type="date" name="ngay_sinh" class="form-control" required>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
								<label class="control-label">
									Chứng minh thư <span class="text-danger">*</span>
								</label>
								<input type="number" name="cmt" class="form-control "
									   placeholder="Nhập CMT/CCCD" required>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
								<label class="control-label">
									Email <span class="text-danger">*</span>
								</label>
								<input type="email" name="mail" class="form-control "
									   placeholder="Nhập email khách hàng" required>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
								<label class="control-label">
									Địa chỉ <span class="text-danger">*</span>
								</label>
								<input type="text" name="address" class="form-control "
									   placeholder="Nhập địa chỉ" required>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
								<label class="control-label">
									Phòng giao dịch <span class="text-danger">*</span>
								</label>
								<select name="store" class="form-control">
									<?php foreach ($stores as $store) {
										if (in_array($store->_id->{'$oid'}, $storeDataCentral)) continue; ?>
										<option value="<?php echo $store->_id->{'$oid'}; ?>"><?php echo $store->name; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
								<label class="control-label">
									Hình thức xe
									<span class="text-danger">*</span>
								</label>
								<select name="vehicle" class="form-control" id="vehicle">
									<option value="K">Mua chính chủ xe</option>
									<option value="C">Mua hộ xe khác</option>
								</select>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
								<label class="control-label">
									Thời hạn hiệu lực
									<span class="text-danger">*</span>
								</label>
								<select name="thoi_han_hieu_luc" class="form-control text-danger" id="thoi_han_hieu_luc">
									<option value="1">1 năm</option>
									<option value="2">2 năm</option>
									<option value="3">3 năm</option>
								</select>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
								<label class="control-label">
									Ngày hiệu lực <span class="text-danger">*</span>
								</label>
								<input type="text" name="start_effect_date" id="start_effect_date" class="form-control text-danger"
									   placeholder="dd/mm/yyyy" disabled
									   value="<?php echo date('d/m/Y') ?>">
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
								<label class="control-label">
									Ngày kết thúc <span class="text-danger">*</span>
								</label>
								<input type="text" name="end_effect_date" class="form-control text-danger" id="endDateMic"
									   placeholder="dd/mm/yyyy" disabled
									   value="<?php echo date('d/m/Y', strtotime("+1 year")) ?>">
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
								<label class="control-label">
									Mức trách nhiệm
									<span class="text-danger">*</span>
								</label>
								<select name="muc_trach_nhiem" class="form-control text-danger" id="muc_trach_nhiem">
									<option value="0">0 VND</option>
									<option value="10000000">10,000,000 VND</option>
									<option value="15000000">15,000,000 VND</option>
									<option value="20000000">20,000,000 VND</option>
									<option value="25000000">25,000,000 VND</option>
									<option value="30000000">30,000,000 VND</option>
								</select>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group row">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">
									Dung tích xe<span class="text-danger">*</span>
								</label>
								<div class="col-lg-6 col-sm-12 col-xs-12 ">
									<div class="radio-inline text-primary">
										<label>
											<input type="radio" name="loai_xe" value="L" checked="checked"
												   id="loai_xe_L"> Trên 50m3
										</label>
									</div>
									<div class="radio-inline text-danger">
										<label>
											<input type="radio" name="loai_xe" value="N" id="loai_xe_N"> Dưới 50m3
										</label>
									</div>
								</div>
								<div class="col-lg-12  col-sm-12 col-xs-12">
									<div class="input-group">
										<span class="input-group-addon">Giá tiền</span>
										<input name="price" class="form-control text-danger"
											   placeholder="" disabled
											   value="<?php echo !empty($price) ? $price . " VND" : '' ?>">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row" style="display: none" id="xe_khong_chinh_chu">
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
								<label class="control-label">
									Tên người mua hộ <span class="text-danger">*</span>
								</label>
								<input type="text" name="ten_kh_ko_chinh_chu" class="form-control"
									   id="ten_kh_ko_chinh_chu"
									   placeholder="Nhập tên">
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
								<label class="control-label">
									CMT người mua hộ <span class="text-danger">*</span>
								</label>
								<input type="number" name="cmt_kh_ko_chinh_chu" class="form-control"
									   id="cmt_kh_ko_chinh_chu"
									   placeholder="Nhập cmt/cccd">
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
								<label class="control-label">
									SDT người mua hộ <span class="text-danger">*</span>
								</label>
								<input type="number" name="phone_khong_chinh_chu" class="form-control"
									   id="phone_khong_chinh_chu"
									   placeholder="Nhập sdt">
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
								<label class="control-label">
									Ngày sinh người mua hộ <span class="text-danger">*</span>
								</label>
								<input type="date" name="ngay_sinh_khong_chinh_chu" class="form-control"
									   id="ngay_sinh_khong_chinh_chu">
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
								<label class="control-label">
									Địa chỉ người mua hộ <span class="text-danger">*</span>
								</label>
								<input type="text" name="dia_chi_khong_chinh_chu" class="form-control"
									   id="dia_chi_khong_chinh_chu"
									   placeholder="Nhập địa chỉ">
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
								<label class="control-label">
									Email người mua hộ <span class="text-danger">*</span>
								</label>
								<input type="email" name="email_khong_chinh_chu" class="form-control"
									   id="email_khong_chinh_chu"
									   placeholder="Nhập email">
							</div>
						</div>
					</div>
				
					<div class="col-md-12 col-xs-12">
						<div class="" style="text-align: center">
							<a href="<?php echo base_url('mic_tnds') ?>" class="btn btn-dark">
								<?php echo $this->lang->line('back') ?>
							</a>
							<a class="btn btn-info" href="https://emic.vn/menuak.aspx#bhhd_egcn_xe" target="_blank">
								Tra cứu GCN
							</a>
							<button class="btn btn-success add_mic_tnds_btnSave">
								Bán mới
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->
<script src="<?php echo base_url(); ?>assets/js/mic_tnds/form_add.js"></script>
<script src="<?php echo base_url(); ?>assets/js/simpleUpload.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css"/>
<script>
	var delta = 0;
	$(document).on('click', '*[data-toggle="lightbox"]', function (event) {
		//$(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
		event.preventDefault();
		return $(this).ekkoLightbox({
			onShow: function (elem) {
				var html = '<button type="button" class="rotate btn btn-link" ><i class="fa fa-repeat"></i></button>';
				console.log(html);
				$(elem.currentTarget).find('.modal-header').prepend(html);
				var delta = 0;
			},
			onNavigate: function (direction, itemIndex) {
				var delta = 0;
				if (window.console) {
					return console.log('Navigating ' + direction + '. Current item: ' + itemIndex);
				}
			}
		});
	});
	$('body').on('click', 'button.rotate', function () {
		delta = delta + 90;
		$('.ekko-lightbox-item img').css({
			'-webkit-transform': 'translateX(-50%)translateY(-50%)rotate(' + delta + 'deg)',
			'-moz-transform': 'translateX(-50%)translateY(-50%)rotate(' + delta + 'deg)',
			'transform': 'translateX(-50%)translateY(-50%)rotate(' + delta + 'deg)'
		});
	});
</script>
<script>
	$(".magnifyitem").magnify({
		initMaximized: true
	});
</script>

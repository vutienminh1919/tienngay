<link href="<?php echo base_url(); ?>assets/teacupplugin/magnify/css/jquery.magnify.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/teacupplugin/magnify/js/jquery.magnify.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/vbi_tnds/validate.js"></script>
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span>Đang xử lý...</span>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>Thêm mới bảo hiểm VBI TNDS
						<br>
						<small><a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
									href="<?php echo base_url('vbi_tnds') ?>">Danh sách bảo hiểm VBI TNDS</a>
							/ <a href="#">Bán mới</a></small>
					</h3>
				</div>
				<div class="title_right" style="text-align: right;">
					<button class="btn btn-warning" id="choose_date">Chọn ngày</button>
					<label for="">Lưu ý: <i>Áp dụng trong trường hợp khách hàng đã mua bảo hiểm VBI TNDS ô tô còn hiệu lực</i></label>
				</div>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<form role="form" id="main_1" class="form-horizontal form-label-left" action="" method="post"
					  novalidate>
					<div class="x_content">
						<div class="panel panel-default">
							<div class="panel-heading text-danger">Thông tin người được bảo hiểm <span
										class="text-danger">*</span></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Tên khách hàng <span class="text-danger">*</span>
											</label>
											<input type="text" name="ten" class="form-control click_vbi"
												   placeholder="Nhập tên khách hàng" required id="ten">
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Email <span class="text-danger">*</span>
											</label>
											<input type="email" name="email" class="form-control click_vbi"
												   placeholder="Nhập email" required id="email">
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												CMT/CCCD <span class="text-danger">*</span>
											</label>
											<input type="text" name="cmt" class="form-control click_vbi"
												   placeholder="Nhập số cmt" required id="cmt">
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Số điện thoại <span class="text-danger">*</span>
											</label>
											<input type="text" name="sdt" class="form-control click_vbi"
												   placeholder="Nhập số điện thoại" required id="sdt">
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Ngày sinh <span class="text-danger">*</span>
											</label>
											<input type="date" name="ngaysinh" class="form-control click_vbi" required
												   id="ngaysinh">
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Giới tính <span class="text-danger">*</span>
											</label>
											<select name="gioi_tinh" class="form-control click_vbi" id="gioi_tinh">
												<option value="nam">Nam</option>
												<option value="nu">Nữ</option>
											</select>
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Địa chỉ <span class="text-danger">*</span>
											</label>
											<input type="text" name="diachi" class="form-control click_vbi"
												   placeholder="Nhập địa chỉ khách hàng"
												   required id="diachi">
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Biển số xe <span class="text-danger">*</span>
											</label>
											<input type="text" name="bien_xe" class="form-control click_vbi"
												   placeholder="Nhập biển số xe VD:30A8888" required id="bien_xe">
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Năm sản xuất <span class="text-danger">*</span>
											</label>
											<select name="nam_sx" class="form-control click_vbi" id="nam_sx">
												<?php foreach ($years as $key => $year) : ?>
													<option value="<?php echo $key ?>"><?php echo $year ?></option>
												<?php endforeach; ?>
											</select>
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Hãng xe <span class="text-danger">*</span>
											</label>
											<select name="hang_xe" class="form-control" id="click_vbi0">
												<?php foreach ($hang_xe as $h) : ?>
													<option value="<?php echo $h->Ma ?>"><?php echo $h->Ten ?></option>
												<?php endforeach; ?>
											</select>
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Hiệu xe <span class="text-danger">*</span>
											</label>
											<select name="hieu_xe" class="form-control" id="click_vbi1">
												<?php foreach ($hieu_xe as $h) : ?>
													<option value="<?php echo $h->Ma ?>"><?php echo $h->Ten ?></option>
												<?php endforeach; ?>
											</select>
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Nhóm xe <span class="text-danger">*</span>
											</label>
											<select name="nhom_xe" class="form-control" id="click_vbi2">
												<?php foreach ($nhom_xe as $h) : ?>
													<option value="<?php echo $h->Ma ?>"><?php echo $h->Ten ?></option>
												<?php endforeach; ?>
											</select>
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Số chỗ ngồi <span class="text-danger">*</span>
											</label>
											<input type="text" name="so_cho" class="form-control click_vbi"
												   placeholder="Nhập số chỗ"
												   required id="so_cho">
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Trọng tải (/Tấn) <span class="text-danger">*</span>
											</label>
											<input type="number" name="trong_tai" class="form-control click_vbi"
												   placeholder="Nhập trọng tải xe"
												   required id="trong_tai">
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Giá trị xe (VND)<span class="text-danger">*</span>
											</label>
											<input type="text" name="gia_tri_xe" class="form-control click_vbi"
												   placeholder="Nhập giá trị xe"
												   required id="gia_tri_xe">
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Phòng giao dịch <span class="text-danger">*</span>
											</label>
											<select name="store" class="form-control click_vbi" id="store">
												<?php foreach ($stores as $store) {
													if (in_array($store->_id->{'$oid'}, $storeDataCentral)) continue;?>
													<option value="<?php echo $store->_id->{'$oid'}; ?>"><?php echo $store->name; ?></option>
												<?php } ?>
											</select>
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Ngày hiệu lực <span class="text-danger">*</span>
											</label>
											<input type="text" name="start_effect_date" id="start_effect_date" class="form-control" placeholder="dd/mm/yyyy"
												   disabled value="<?php echo date('d/m/Y') ?>">
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Ngày kết thúc <span class="text-danger">*</span>
											</label>
											<input type="text" name="end_effect_date" id="end_effect_date" class="form-control" placeholder="dd/mm/yyyy"
												   disabled value="<?php echo date('d/m/Y', strtotime('+1 year')) ?>">
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">

									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group" id="price_vbi_tnds" style="display:none">
											<label class="control-label">
												Giá tiền (VND)<span class="text-danger">*</span>
											</label>
											<input type="text" name="price_vbi" id="price_vbi"
												   class="form-control text-danger"
												   placeholder=""
												   disabled value="">
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">

									</div>
								</div>
							</div>
						</div>

						<div class="col-md-12 col-xs-12">
							<div class="" style="text-align: center">
								<a href="<?php echo base_url('vbi_tnds') ?>" class="btn btn-dark">
									<?php echo $this->lang->line('back') ?>
								</a>
								<a class="btn btn-info" href="https://myvbi.vn/tra-cuu" target="_blank">
									Tra cứu GCN
								</a>
								<button class="btn btn-success tinh_phi_vbi_tnds_btn">
									Tính phí
								</button>
								<button class="btn btn-success ban_bao_hiem_vbi_tnds" style="display:none">
									Áp dụng Bán
								</button>
								<button class="btn btn-primary nhap_lai_vbi_tnds" style="display:none">
									Nhập lại
								</button>

							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->
<script src="<?php echo base_url(); ?>assets/js/vbi_tnds/form_add.js"></script>
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
<style>
	.help-block {
		display: inline-block !important;
		margin: 0px !important;
	}

	.has-error {
		border-color: #9f041b !important;
	}

	.has-success {
		border-color: #35DB00 !important;
	}
</style>

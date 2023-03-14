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
					<h3>Thêm mới bảo hiểm VBI SXH
						<br>
						<small><a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
									href="<?php echo base_url('baoHiemVbi/sxh') ?>">Danh sách bảo hiểm VBI SXH</a>
							/ <a href="#">Bán mới</a></small>
					</h3>
				</div>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="container">
				<div class="x_panel">
					<form role="form" id="main_1" class="form-horizontal form-label-left" action="" method="post"
						  novalidate>
						<div class="panel panel-danger">
							<div class="panel-heading">Thông tin chủ hợp đồng <span
										class="text-danger">*</span></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Tên khách hàng <span class="text-danger">*</span>
											</label>
											<input type="text" name="ten_chu_hd" class="form-control click_vbi"
												   placeholder="Nhập tên khách hàng" required id="ten_chu_hd">
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Email <span class="text-danger">*</span>
											</label>
											<input type="email" name="email_chu_hd" class="form-control click_vbi"
												   placeholder="Nhập email" required id="email_chu_hd">
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Số điện thoại <span class="text-danger">*</span>
											</label>
											<input type="text" name="sdt_chu_hd" class="form-control click_vbi"
												   placeholder="Nhập số điện thoại" required id="sdt_chu_hd">
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												CMT/CCCD <span class="text-danger">*</span>
											</label>
											<input type="text" name="cmt_chu_hd" class="form-control click_vbi"
												   placeholder="Nhập số cmt" required id="cmt_chu_hd">
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Địa chỉ <span class="text-danger">*</span>
											</label>
											<input type="text" name="diachi_chu_hd" class="form-control click_vbi"
												   placeholder="Nhập địa chỉ"
												   required id="diachi_chu_hd">
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Ngày sinh <span class="text-danger">*</span>
											</label>
											<input type="date" name="ngaysinh_chu_hd" class="form-control click_vbi"
												   required
												   id="ngaysinh_chu_hd">
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Giới tính <span class="text-danger">*</span>
											</label>
											<select name="gioi_tinh_chu_hd" class="form-control click_vbi"
													id="gioi_tinh_chu_hd">
												<option value="NAM">Nam</option>
												<option value="NU">Nữ</option>
											</select>
											<p class="messages"></p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="panel panel-danger">
							<div class="panel-heading">Thông tin người được bảo hiểm <span
										class="text-danger">*</span></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Tên người được bảo hiểm <span class="text-danger">*</span>
											</label>
											<input type="text" name="ten_nguoi_bh" class="form-control click_vbi"
												   placeholder="Nhập tên khách hàng" required id="ten_nguoi_bh">
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Email người được bảo hiểm<span class="text-danger">*</span>
											</label>
											<input type="email" name="email_nguoi_bh" class="form-control click_vbi"
												   placeholder="Nhập email" required id="email_nguoi_bh">
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Ngày sinh người được bảo hiểm<span class="text-danger">*</span>
											</label>
											<input type="date" name="ngaysinh_nguoi_bh" class="form-control click_vbi"
												   required
												   id="ngaysinh_nguoi_bh">
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Số điện thoại người được bảo hiểm<span class="text-danger">*</span>
											</label>
											<input type="text" name="sdt_nguoi_bh" class="form-control click_vbi"
												   placeholder="Nhập số điện thoại" required id="sdt_nguoi_bh">
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												CMT người được bảo hiểm
											</label>
											<input type="text" name="cmt_nguoi_bh" class="form-control click_vbi"
												   placeholder="Nhập số cmt" required id="cmt_nguoi_bh">
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Ngày cấp CMT người được bảo hiểm
											</label>
											<input type="date" name="cmt_ngay_cap_nguoi_bh"
												   class="form-control click_vbi"
												   placeholder="Nhập số cmt"  id="cmt_ngay_cap_nguoi_bh">
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Nơi cấp CMT người được bảo hiểm
											</label>
											<input type="text" name="cmt_noi_cap_nguoi_bh"
												   class="form-control click_vbi"
												   placeholder="Nhập số cmt"  id="cmt_noi_cap_nguoi_bh">
											<p class="messages"></p>
										</div>
									</div>

									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Địa chỉ người được bảo hiểm<span class="text-danger">*</span>
											</label>
											<input type="text" name="diachi_nguoi_bh" class="form-control click_vbi"
												   placeholder="Nhập địa chỉ"
												   required id="diachi_nguoi_bh">
											<p class="messages"></p>
										</div>
									</div>

									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Giới tính người được bảo hiểm<span class="text-danger">*</span>
											</label>
											<select name="gioi_tinh_nguoi_bh" class="form-control click_vbi"
													id="gioi_tinh_nguoi_bh">
												<option value="NAM">Nam</option>
												<option value="NU">Nữ</option>
											</select>
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Mối quan hệ với chủ hợp đồng<span class="text-danger">*</span>
											</label>
											<select name="moi_quan_he" class="form-control click_vbi" id="moi_quan_he">
												<option value="QH00000">Bản thân</option>
												<option value="QH00001">Bố/Mẹ</option>
												<option value="QH00002">Chồng/Vợ</option>
												<option value="QH00003">Anh/Chị/Em</option>
												<option value="QH00006">Khác</option>
												<option value="QH00007">Con</option>
											</select>
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Ngày hiệu lực <span class="text-danger">*</span>
											</label>
											<input type="text" name="" class="form-control" placeholder=""
												   disabled value="<?php echo date('d/m/Y') ?>">
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Ngày kết thúc <span class="text-danger">*</span>
											</label>
											<input type="text" name="" class="form-control"
												   placeholder="Nhập giá trị xe"
												   disabled value="<?php echo date('d/m/Y', strtotime('+1 year')) ?>">
											<p class="messages"></p>
										</div>
									</div>
									<div class="col-xs-12 col-md-4 error_messages">
										<div class="form-group ">
											<label class="control-label">
												Gói bảo hiểm <span class="text-danger">*</span>
											</label>
											<select name="goi_bao_hiem" class="form-control click_vbi"
													id="goi_bao_hiem">
												<option value="SXH_VFC_GOI1_CANHAN">VFC Gói Đồng Cá nhân</option>
												<option value="SXH_VFC_GOI2_CANHAN">VFC Gói Bạc Cá nhân</option>
												<option value="SXH_VFC_GOI3_CANHAN">VFC Gói Vàng Cá nhân</option>
												<option value="SXH_VFC_GOI1_GIADINH">VFC Gói Đồng Gia đình</option>
												<option value="SXH_VFC_GOI2_GIADINH">VFC Gói Bạc Gia đình</option>
												<option value="SXH_VFC_GOI3_GIADINH">VFC Gói Vàng Gia đình</option>
											</select>
											<p class="messages"></p>
										</div>
									</div>

								</div>
							</div>
						</div>
						<div class="panel panel-danger">
							<div class="panel-heading">Phòng giao dịch <span class="text-danger">*</span>
							</div>
							<div class="panel-body">
								<div class="row">
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
											<label class="control-label text-danger">
												Số tiền (VND)<span class="text-danger">*</span>
											</label>
											<input type="text" name="price" class="form-control text-danger" placeholder=""
												   disabled value="0" id="price">
											<p class="messages"></p>
										</div>
									</div>

								</div>
							</div>
						</div>
						<div class="x_content">
							<div class="col-md-12 col-xs-12">
								<div class="" style="text-align: center">
									<button class="btn btn-success ban_bao_hiem_vbi_sxh">
										Áp dụng Bán
									</button>
									<a href="<?php echo base_url('baoHiemVbi/sxh') ?>" class="btn btn-info ">
										<?php echo $this->lang->line('back') ?>
									</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>

		</div>
	</div>
</div>
<!-- /page content -->
<script src="<?php echo base_url(); ?>assets/js/bao_hiem_vbi/sxh/form_add.js"></script>
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

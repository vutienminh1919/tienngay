<!-- page content -->
<?php
$code_ref = !empty($_GET['code']) ? $_GET['code'] : "";
?>
<div class="right_col" role="main">
	<div class="theloading" id="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3><?= $this->lang->line('update_img_authentication') ?>
					<br>
					<small>
						<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>/
						<a href="<?php echo base_url('Exemptions/profile_exemption?tab=profile_origin') ?>">Danh sách hồ
							sơ miễn giảm</a> /
						<a href="#">Tải lên ảnh cho hồ sơ miễn giảm - <?= !empty($profile->profile_name) ? $profile->profile_name : "" ?></a>
					</small>
				</h3>
			</div>
			<div class="title_right text-right">
				<?php if ($profile->type_exception == 1) : ?>
					<a href="<?php echo base_url('Exemptions/profile_exemption?tab=profile_exception') ?>"
					   class="btn btn-info ">
						<i class="fa fa-hand-o-left" aria-hidden="true"></i> Quay lại
					</a>
				<?php elseif ($profile->type_exception == 2) : ?>
					<a href="<?php echo base_url('Exemptions/profile_exemption?tab=profile_asset') ?>"
					   class="btn btn-info ">
						<i class="fa fa-hand-o-left" aria-hidden="true"></i> Quay lại
					</a>
				<?php else : ?>
					<a href="<?php echo base_url('Exemptions/profile_exemption?tab=profile_normal') ?>"
					   class="btn btn-info ">
						<i class="fa fa-hand-o-left" aria-hidden="true"></i> Quay lại
					</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<input type="hidden" id="code_ref" value="<?= !empty($_GET['code']) ? $_GET['code'] : "" ?>">
			<input type="hidden" id="type_send"
				   value="<?= !empty($profile->type_send) ? $profile->type_send : "" ?>">
			<input type="hidden" id="type_exception"
				   value="<?= !empty($profile->type_exception) ? $profile->type_exception : "" ?>">
			<!--Start profile-->
			<div class="x_content">
				<form class="form-horizontal form-label-left">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Chứng từ <span
									class="red">*</span></label>
						<div class="col-md-9 col-sm-6 col-xs-12">
							<div id="SomeThing" class="simpleUploader">
								<div class="uploads" id="uploads_profile_exemp">
									<?php
									if (!empty($profile->img_profile)) {
										$key_profile = 0;
										foreach ((array)$profile->img_profile as $key => $value) {
											$key_profile++;
											if (empty($value)) continue;
											?>
											<div class="block">
												<!--Img-->
												<?php if ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg') { ?>
													<img name="img_contract"
														 class="w-100" src="<?= $value->path ?>"
														 alt="" data-type="profile"
														 data-key='<?= $key ?>'
														 data-filetype="<?= $value->file_type ?>"
														 data-filename="<?= $value->file_name ?>">
												<?php } ?>
												<!--Audio-->
												<?php if ($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg') { ?>
													<span
															class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
													<a href="<?= $value->path ?>" target="_blank"><span
																style="z-index: 9"><?= $value->file_name ?></span>
														<img
																style="width: 50%;transform: translateX(50%)translateY(-50%);"
																src="https://image.flaticon.com/icons/png/512/81/81281.png"
																alt="">
														<img
															 name="img_contract"
															 data-key="<?= $key ?>"
															 data-fileName="<?= $value->file_name ?>"
															 data-fileType="<?= $value->file_type ?>"
															 data-type='profile'
															 class="w-100"
															 src="<?= $value->path ?>" alt="">
													</a>
												<?php } ?>
												<!--Video-->
												<?php if ($value->file_type == 'video/mp4') { ?>
													<span
															class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
													<a href="<?= $value->path ?>" target="_blank"><span
																style="z-index: 9"><?= $value->file_name ?></span>
														<img
																style="width: 50%;transform: translateX(50%)translateY(-50%);"
																src="<?php echo base_url(); ?>assets/imgs/mp4.jpg"
																alt="">
														<img
															 name="img_contract"
															 data-key="<?= $key ?>"
															 data-fileName="<?= $value->file_name ?>"
															 data-fileType="<?= $value->file_type ?>"
															 data-type='profile'
															 class="w-100"
															 src="<?= $value->path ?>" alt="">
													</a>
												<?php } ?>
												<!--PDF-->
												<?php if (!empty($value->file_type) && ($value->file_type == 'application/pdf')) { ?>
													<span class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
													<a href="<?= $value->path ?>" target="_blank"><span
																style="z-index: 9"><?= $value->file_name ?></span>
														<img name="img_contract"
															 data-type="profile"
															 data-key='<?= $key ?>'
															 data-filetype="<?= $value->file_type ?>"
															 data-filename="<?= $value->file_name ?>"
															 style="width: 50%;transform: translateX(50%)translateY(-50%);"
															 src="<?= $value->path ?>"
															 alt="">
														<img style="width: 50%;transform: translateX(50%)translateY(-50%);"
															 src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png"
															 alt="">
													</a>
												<?php } ?>
												<?php if (in_array($profile->status, [2, 5])) : ?>
													<button
															type="button"
															id="delete_img_profile"
															onclick="deleteImage(this)"
															data-id="<?= !empty($_GET['code']) ? $_GET['code'] : "" ?>"
															data-type="profile"
															data-key='<?= $key ?>'
															class="cancelButton "><i class="fa fa-times-circle"></i>
													</button>
												<?php endif;; ?>
											</div>
										<?php }
									} ?>
								</div>
								<label for="upload_profile_exem">
									<div class="uploader">
										<span class="btn btn-primary btn-sm fa fa-upload"></span>
									</div>
								</label>
								<input id="upload_profile_exem"
									   class="focus"
									   type="file"
									   name="file"
									   data-contain="uploads_profile_exemp"
									   data-type="profile"
									   data-title="Ảnh hồ sơ miễn giảm"
									   multiple
								>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12 text-right">
							Mã bưu phẩm<span class="text-danger"> * </span>
						</label>
						<div class="col-md-9 col-sm-6 col-xs-12 error_messages">
							<input
									id="postal_code"
									class="form-control"
									type="text"
									name="postal_code"
									value="<?= $profile->postal_code ? $profile->postal_code : '' ?>"
									placeholder="Nhập mã bưu phẩm"
									required
							>
							<p class="messages"></p>
						</div>
					</div>
				</form>
			</div>
			<!--End-->
			<button id="submit_profile"
					class="btn btn-primary fa fa-paper-plane"
					style="float: right;"
					type="button">
				Gửi hồ sơ
			</button>
		</div>
	</div>
</div>
<!-- /page content -->
<script src="<?php echo base_url(); ?>assets/js/examptions/index.js"></script>
<script>
	let status = <?php echo $profile->status ?>;
	if (!in_array(status, [2, 9])) {
		$('#postal_code').prop('disabled', true);
		$('#submit_profile').prop('disabled', true);
	}
</script>

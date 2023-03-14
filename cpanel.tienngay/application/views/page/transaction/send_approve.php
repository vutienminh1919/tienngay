<!-- page content -->

<?php
$transaction_id = !empty($_GET['id']) ? $_GET['id'] : "";
?>
<div class="right_col" role="main">
	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3><?= $this->lang->line('update_img_authentication') ?>
					<br>
					<small>
						<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>/ <a
								href="<?php echo base_url('transaction') ?>">Danh sách phiếu thu</a> / <a
								href="#"><?php echo $this->lang->line('update_img_authentication') ?> và gửi duyệt</a>
					</small>
				</h3>
			</div>

		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_content">
				<?php if ($result->type_payment != 2 && $result->type_payment != 3) {
					?>
					<div class="container">
						<div class="row justify-content-center">
							<div class="col-xs-12 text-center">
								<div class="newstitleblock">
									<div class="col-xs-9 thetitle">
										Chứng từ gửi duyệt hợp lệ
									</div>
									<?php if ($result->payment_method == 1 && in_array($result->type,[3,4])) { ?>
									<div class="title_right text-right" <?= !empty($result->status_ksnb) ? 'style="display: none"' : "" ?>>
										<a href="<?php echo base_url('transaction/printed_billing_contract/') . $transaction_id; ?>"
										   class="btn btn-info"
										   target="_blank">IN BIÊN NHẬN
										</a>
									</div>
									<?php } ?>
								</div>
							</div>
							<div class="col-12 col-lg-10 mb-4" <?= !empty($result->status_ksnb) ? 'style="display: none"' : "" ?> >
								<div class="termwrapper">
									<h4 class="termtitle">
										<span style="color: red">* </span>Phiếu thu gửi duyệt cần upload:
									</h4>
									<div class="termcontent wysiwyg">
										<p> - Ảnh chụp màn hình chi tiết giao dịch chuyển khoản thành công trên ứng dụng
											chuyển tiền </p>
										<p>(rõ, nét thông tin khách hàng, số tiền, nội dung chuyển tiền và mã giao dịch
											chuyển khoản);</p>
										<p>+ Nội dung chuyển tiền mẫu nạp tiền tài xế HeyU: <i style="color: blue">HN44LN.nopHeyU.01042021</i>
										</p>
										<p>+ Nội dung chuyển tiền mẫu thanh toán kỳ hợp đồng: <i style="color: blue">HCM412CMT8.VoThiThuyDuong.ky7.12042021</i>
										</p>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-10 mb-4" <?= !empty($result->status_ksnb) ? 'style="display: none"' : "" ?>>
								<div class="termwrapper">
									<h4 class="termtitle">
										<span style="color: red">* </span>Đối với phiếu thu thanh, tất toán hợp đồng,
										khi khách nộp tiền mặt cần thêm:
									</h4>
									<div class="termcontent wysiwyg">
										<p> - Ảnh chụp Biên nhận thu tiền, được in từ hệ thống, có đầy đủ chữ ký của
											khách hàng, Trưởng phòng giao dịch, Chuyên viên kinh doanh và dấu đỏ của
											PGD.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<input type="hidden" id="transaction_id" value="<?= !empty($_GET['id']) ? $_GET['id'] : "" ?>">
			<!--Start expertise-->
			<div class="x_content">
				<?php if (in_array($result->status, [4, 11])) { ?>
					<form class="form-horizontal form-label-left">
						<div class="form-group ">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Chứng từ <span
										class="red">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div id="SomeThing" class="simpleUploader line">
									<div class="uploads" id="uploads_expertise">
										<?php
										if (!empty($result->image_banking->image_expertise)) {
											$key_expertise = 0;
											foreach ((array)$result->image_banking->image_expertise as $key => $value) {
												$key_expertise++;
												if (empty($value)) continue;
												?>
												<div class="block">
													<?php if ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg') { ?>

														<img name="img_transaction" class="w-100"
															 src="<?= $value->path ?>" alt="" data-type="expertise"
															 data-key='<?= $key ?>'
															 data-filetype="<?= $value->file_type ?>"
															 data-filename="<?= $value->file_name ?>">

													<?php } ?>
													<!--Audio-->
													<?php if ($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg') { ?>
														<a href="<?= $value->path ?>" target="_blank"><span
																	style="z-index: 9"><?= $value->file_name ?></span>
															<img style="width: 50%;transform: translateX(50%)translateY(-50%);"
																 src="https://image.flaticon.com/icons/png/512/81/81281.png"
																 alt="">
														</a>
														<!--                                                <audio controls>
                                                        <source src="<?= $value->path ?>" type="audio/mpeg">
                                                        <?= $value->file_name ?>
                                                    </audio>-->
													<?php } ?>
													<!--Video-->
													<?php if ($value->file_type == 'video/mp4') { ?>
														<a href="<?= $value->path ?>" target="_blank"><span
																	style="z-index: 9"><?= $value->file_name ?></span>
															<img style="width: 50%;transform: translateX(50%)translateY(-50%);"
																 src="<?php echo base_url(); ?>assets/imgs/mp4.jpg"
																 alt="">
														</a>
														<!--                                                <video width="320" height="240" controls>
                                                        <source src="<?= $value->path ?>" type="video/mp4">
                                                        <?= $value->file_name ?>
                                                    </video>-->
													<?php } ?>
													<button type="button" onclick="deleteImage(this)"
															data-id="<?= !empty($_GET['id']) ? $_GET['id'] : "" ?>"
															data-type="expertise" data-key='<?= $key ?>'
															class="cancelButton "><i class="fa fa-times-circle"></i>
													</button>
													<div class="description"><textarea rows="6" data-key="<?= $key ?>"
																					   name="description_img"><?= $value->description ?></textarea>
													</div>
												</div>
											<?php }
										} ?>
									</div>
									<label for="upload_expertise">
										<div class="block uploader">
											<span>+</span>
										</div>
									</label>
									<input id="upload_expertise" type="file" name="file"
										   data-contain="uploads_expertise" multiple data-type="expertise"
										   class="focus">
								</div>
							</div>
						</div>
					</form>
				<?php } ?>
			</div>

			<?php if ($result->type_payment == 2 && $result->contract_status == 17 && $result->status == 2) { ?>
				<button style="float: right;" type="button" class="btn btn-primary submit_send_approve_gh">Tạo gia hạn
				</button>
			<?php } ?>
			<?php if ($result->type_payment == 3 && $result->contract_status == 17 && $result->status == 2) { ?>
				<button style="float: right;" type="button" class="btn btn-primary submit_send_approve_cc">Tạo cơ cấu
				</button>
			<?php } ?>
			<!--End-->
			<?php if (in_array($result->status, [4, 11])) { ?>
				<button style="float: right;" type="button" class="btn btn-info submit_send_approve_img">GỬI KẾ TOÁN
					DUYỆT
				</button>
			<?php } ?>

			<!--Redirect page after send approve -->
			<div class="title_right text-right">
				<?php if (in_array($result->type, [3, 4])) { ?>
					<a href="<?php echo base_url('transaction') ?>" class="btn btn-info ">
						<i class="fa fa-arrow-left" aria-hidden="true"></i> <?= $this->lang->line('Come_back') ?>
					</a>
				<?php } elseif (in_array($result->type, [7])) { ?>
					<a href="<?php echo base_url('heyU?tab=transaction') ?>" class="btn btn-info ">
						<i class="fa fa-arrow-left" aria-hidden="true"></i> <?= $this->lang->line('Come_back') ?>
					</a>
				<?php } elseif (in_array($result->type, [8])) { ?>
					<a href="<?php echo base_url('mic_tnds?tab=transaction') ?>" class="btn btn-info ">
						<i class="fa fa-arrow-left" aria-hidden="true"></i> <?= $this->lang->line('Come_back') ?>
					</a>
				<?php } elseif (in_array($result->type, [10])) { ?>
					<a href="<?php echo base_url('vbi_tnds?tab=transaction') ?>" class="btn btn-info ">
						<i class="fa fa-arrow-left" aria-hidden="true"></i> <?= $this->lang->line('Come_back') ?>
					</a>
				<?php } elseif (in_array($result->type, [11])) { ?>
					<a href="<?php echo base_url('baoHiemVbi/utv?tab=transaction') ?>" class="btn btn-info ">
						<i class="fa fa-arrow-left" aria-hidden="true"></i> <?= $this->lang->line('Come_back') ?>
					</a>
				<?php } elseif (in_array($result->type, [12])) { ?>
					<a href="<?php echo base_url('baoHiemVbi/sxh?tab=transaction') ?>" class="btn btn-info ">
						<i class="fa fa-arrow-left" aria-hidden="true"></i> <?= $this->lang->line('Come_back') ?>
					</a>
				<?php } else { ?>
					<a href="<?php echo base_url('accountant') ?>" class="btn btn-info ">
						<i class="fa fa-arrow-left" aria-hidden="true"></i> <?= $this->lang->line('Come_back') ?>
					</a>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<input type="hidden" class="form-control input-sm" value="<?= $result->contract_id ?>" name="contract_id">
<input type="hidden" class="form-control input-sm" value="<?= $result->contract_status ?>" name="contract_status">
<?php $this->load->view('page/pawn/modal_contract', isset($this->data) ? $this->data : NULL); ?>
<!-- /page content -->
<script src="<?php echo base_url(); ?>assets/js/transaction/upload.js"></script>
<script src="<?php echo base_url(); ?>assets/js/simpleUpload.js"></script>
<script src="<?php echo base_url("assets") ?>/js/numeral.min.js"></script>

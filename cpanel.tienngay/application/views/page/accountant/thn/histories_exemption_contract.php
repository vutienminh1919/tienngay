<?php date_default_timezone_set('Asia/Ho_Chi_Minh');?>
<div class="detail-contract" role="main">

	<div class="page-title">
		<div class="title_left">
			<h3 class="page-title"><a href="<?php echo base_url("exemptions") ?>" style="color: blue">Danh sách hợp đồng miễn giảm -</a>
				&nbsp;<?php
				if ($exemption_contract->status == 1) {
					echo '<span class="label label-default" style="font-size: 13px; padding: 7px">Chờ Lead QLHĐV xử lý đơn miễn giảm</span>';
				} elseif ($exemption_contract->status == 2) {
					echo '<span class="label label-danger" style="font-size: 13px; padding: 7px;" >Đã hủy đơn miễn giảm</span>';
				} elseif ($exemption_contract->status == 3) {
					echo '<span class="label label-warning" style="font-size: 13px; padding: 7px;" >Lead QLHĐV yêu cầu bổ sung đơn miễn giảm</span>';
				} elseif ($exemption_contract->status == 4) {
					echo '<span class="label label-default" style="font-size: 13px; padding: 7px;" >Chờ TP QLHĐV xử lý đơn miễn giảm</span>';
				} elseif ($exemption_contract->status == 5) {
					echo '<span class="label label-success" style="font-size: 13px; padding: 7px;" >TP QLHĐV đã duyệt đơn miễn giảm</span>';
				} elseif ($exemption_contract->status == 6) {
					echo '<span class="label label-default" style="font-size: 13px; padding: 7px;" >Chờ quản lý cấp cao xử lý đơn miễn giảm</span>';
				} elseif ($exemption_contract->status == 7) {
					echo '<span class="label label-success" style="font-size: 13px; padding: 7px;" >Quản lý cấp cao đã duyệt đơn miễn giảm</span>';
				} elseif ($exemption_contract->status == 8) {
					echo '<span class="label label-warning" style="font-size: 13px; padding: 7px;" >TP QLHĐV yêu cầu bổ sung đơn miễn giảm</span>';
				} elseif ($exemption_contract->status == 9) {
					echo '<span class="label label-warning" style="font-size: 13px; padding: 7px;" >QLCC yêu cầu bổ sung đơn miễn giảm</span>';
				}
				?>
			</h3>
		</div>
		<div class="title_right text-right">
			<div class="btn-group">
				<?php if ($userSession['is_superadmin'] == 1 || in_array("lead-thn", $groupRoles)) { ?>
					<?php if (!empty($exemption_contract->status) && $exemption_contract->status == 1) { ?>
						<a class="btn btn-info"
						   onclick="showModal_lead_thn('<?= $exemption_contract->_id->{'$oid'} ?>')"
						   href="javascript:void(0)">
							Lead QLHĐV xử lý
						</a>
					<?php }
				} ?>

				<?php if ($userSession['is_superadmin'] == 1 || in_array("tbp-thu-hoi-no", $groupRoles)) { ?>
					<?php if (!empty($exemption_contract->status) && in_array($exemption_contract->status, [4, 5]) && $issetTransactionDiscount == false) { ?>
						<a class="btn btn-info"
						   onclick="tpthn_xu_ly('<?= $exemption_contract->_id->{'$oid'} ?>')"
						   href="javascript:void(0)">
							TP QLHĐV xử lý
						</a>
					<?php }
				} ?>

				<?php if ($userSession['is_superadmin'] == 1 || (isset($exemption_contract->user_receive_approve) && in_array($user_id_login, $exemption_contract->user_receive_approve))) { ?>
					<?php if (!empty($exemption_contract->status) && in_array($exemption_contract->status, [6])) { ?>
						<a class="btn btn-info"
						   onclick="qlcc_xu_ly('<?= $exemption_contract->_id->{'$oid'} ?>')"
						   href="javascript:void(0)">
							QLCC xử lý
						</a>
					<?php }
				} ?>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>
	<br>
	<?php if (!empty($exemption_contract) && $exemption_contract->ky_tra == $ky_tra_hien_tai) { ?>
	<div class="row">
		<span style="padding-bottom: 10px"><b style="color: black">THÔNG TIN MIỄN GIẢM</b></span>
	</div>
	<br>
	<div class="row">
		<label class="control-label col-md-2 col-xs-12 text-left" style="color: black; font-weight: unset">
			Hợp đồng đề nghị: &nbsp;&nbsp;
		</label>
		<div class="col-md-3 col-xs-12">
			<span style="color: black; font-weight: bold"><?php echo $contractDB->code_contract_disbursement ?></span>
		</div>

		<div class="col-md-3 col-xs-12"></div>
		<label class="control-label col-md-1 col-xs-12 text-left" style="color: black; font-weight: unset">
			Loại miễn giảm
		</label>
		<div class="col-md-3 col-xs-12 error_messages">
			<p class="messages text-danger"><?= ($exemption_contract->type_payment_exem && $exemption_contract->type_payment_exem==2) ? 'Tất toán' : 'Thanh toán' ?></p>
			<?php if (!empty($exemption_contract->type_payment_exem) && $exemption_contract->type_payment_exem == 1) : ?>
			<span> Kỳ miễn giảm: <b><?= $exemption_contract->ky_tra ? $exemption_contract->ky_tra : ""; ?></b></span>
			<?php endif; ?>
		</div>
	</div>
	<br>
	<div class="row">
		<label class="control-label col-md-2 col-xs-12 text-left" style="color: black; font-weight: unset">
			Số tiền KH đề nghị miễn giảm:
		</label>
		<div class="col-md-3 col-xs-12 error_messages">
			<p class="messages text-danger"><?= $exemption_contract->amount_customer_suggest ? number_format($exemption_contract->amount_customer_suggest) : 0 ?>
				đồng</p>
		</div>
		<div class="col-md-3 col-xs-12"></div>
		<label class="control-label col-md-1 col-xs-12 text-left" style="font-weight: lighter; color: black">
			Ngày đề nghị:
		</label>
		<div class="col-md-3 col-xs-12 error_messages">
			<p class="messages"
			   style="color: black"><?= $exemption_contract->date_suggest ? date('d/m/Y', $exemption_contract->date_suggest) : ""; ?></p>
		</div>
	</div>
	<br>
		<div class="row">
			<label class="control-label col-md-2 col-xs-12 text-left" style="color: black; font-weight: unset">
				Email CEO xác nhận:
			</label>
			<div class="col-md-3 col-xs-12 error_messages">
				<p class="messages" style="color: black;"><?= ($exemption_contract->confirm_email && $exemption_contract->confirm_email == 2) ? 'Không có' : 'Có' ?>
				</p>
			</div>
			<div class="col-md-3 col-xs-12"></div>
			<label class="control-label col-md-1 col-xs-12 text-left" style="color: black; font-weight: unset">
				Ngày khách hàng ký đơn:
			</label>
			<div class="col-md-3 col-xs-12 error_messages">
				<p class="messages" style="color: black;"><?= $exemption_contract->start_date_effect ? date('d/m/Y', $exemption_contract->start_date_effect) : ""; ?>
				</p>
			</div>
	</div>
	<br>
		<div class="row">
			<label class="control-label col-md-2 col-xs-12 text-left" style="color: black; font-weight: unset">
				Đơn miễn giảm (bản giấy):
			</label>
			<div class="col-md-3 col-xs-12 error_messages">
				<p class="messages" style="color: black;"><?= ($exemption_contract->is_exemption_paper && $exemption_contract->is_exemption_paper == 2) ? 'Không có' : 'Có' ?>
				</p>
			</div>
			<div class="col-md-3 col-xs-12"></div>
			<label class="control-label col-md-1 col-xs-12 text-left" style="color: black; font-weight: unset">
				Số ngày quá hạn:
			</label>
			<div class="col-md-3 col-xs-12 error_messages">
				<p class="messages" style="color: red;"><?= !empty($exemption_contract->number_date_late) ? $exemption_contract->number_date_late : '' ?>
				</p>
			</div>
		</div>
	<br>
	<?php if (isset($exemption_contract->amount_tp_thn_suggest)) { ?>
		<div class="row">
			<label class="control-label col-md-2 col-xs-12 text-left" style="color: black; font-weight: unset">
				Số tiền TP QLHĐV đề nghị miễn giảm:
			</label>
			<div class="col-md-3 col-xs-12 error_messages">
				<p class="messages text-danger"><?= $exemption_contract->amount_tp_thn_suggest ? number_format($exemption_contract->amount_tp_thn_suggest) : 0 ?>
					đồng</p>
			</div>
		</div>
		<br>
	<?php } ?>
	<div class="row">
		<label class="control-label col-md-2 col-xs-12 text-left" for=""
			   style="color: black; font-weight: unset">
			Hình ảnh hồ sơ miễn giảm:
		</label>
		<div class="col-md-10 col-xs-12 error_messages">
			<div id="SomeThing" class="simpleUploader error_messages">
				<div class="uploads" id="image_update">
					<?php
					$key_exemption_profile = 0;
					foreach ((array)$exemption_contract->image_exemption_profile as $key => $value) {
						$key_exemption_profile++;
						if (empty($value)) continue; ?>
						<div class="block">
							<!--//Image-->
							<?php if ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg') { ?>
								<span
										class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
								<a href="<?= $value->path ?>" class="magnifyitem" data-magnify="gallery" data-src=""
								   data-group="thegallery" data-toggle="lightbox" data-gallery="image_update"
								   data-max-width="992" data-type="image" data-title="Hồ sơ nhân thân">
									<img data-key="<?= $key ?>"
										 data-fileName="<?= $value->file_name ?>"
										 data-fileType="<?= $value->file_type ?>" data-type='exemption_profile'
										 class="w-100"
										 src="<?= $value->path ?>" alt="">
								</a>
							<?php } ?>
							<!--Audio-->
							<?php if ($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg') { ?>
								<span
										class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
								<a href="<?= $value->path ?>" target="_blank"><span
											style="z-index: 9"><?= $value->file_name ?></span>
									<img
											style="width: 50%;transform: translateX(50%)translateY(-50%);"
											src="https://image.flaticon.com/icons/png/512/81/81281.png" alt="">
									<img data-key="<?= $key ?>"
										 data-fileName="<?= $value->file_name ?>"
										 data-fileType="<?= $value->file_type ?>" data-type='exemption_profile'
										 class="w-100"
										 src="<?= $value->path ?>" alt="">
								</a>
								<!--                                                <audio controls>
                                                    <source src="<?= $value->path ?>" type="audio/mpeg">
                                                    <?= $value->file_name ?>
                                                </audio>-->
							<?php } ?>
							<!--Video-->
							<?php if ($value->file_type == 'video/mp4') { ?>
								<span
										class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
								<a href="<?= $value->path ?>" target="_blank"><span
											style="z-index: 9"><?= $value->file_name ?></span>
									<img
											style="width: 50%;transform: translateX(50%)translateY(-50%);"
											src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt="">
									<img data-key="<?= $key ?>"
										 data-fileName="<?= $value->file_name ?>"
										 data-fileType="<?= $value->file_type ?>" data-type='exemption_profile'
										 class="w-100"
										 src="<?= $value->path ?>" alt="">
								</a>
								<!--                                                <video width="320" height="240" controls>
                                                    <source src="<?= $value->path ?>" type="video/mp4">
                                                    <?= $value->file_name ?>
                                                </video>-->
							<?php } ?>
							<!--PDF-->
							<?php if(!empty($value->file_type) && ($value->file_type == 'application/pdf')) {?>
								<span class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path));?></span>
								<a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
									<img name="img_transaction" data-type="expertise" data-key='<?= $key?>' data-filetype="<?= $value->file_type?>" data-filename="<?= $value->file_name?>" style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?= $value->path ?>" alt="">
									<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt="">
								</a>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
			</div>

		</div>
	</div>
	<br>
	<div class="row">
		<label class="control-label col-md-2 col-xs-12 text-left"
			   style="color: black; font-weight: unset; padding-right: 10px"><span></span>
			Ghi chú/Note của NV tạo đơn: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
		<div class="col-md-10 col-xs-12 error_messages">
				<textarea class="form-control"
						  rows="1"
						  placeholder="Nhập lưu ý"
						  disabled><?= $exemption_contract->note ? $exemption_contract->note : ""; ?>
				</textarea>
			<input type="hidden" class="form-control">
			<p class="messages"></p>
		</div>
	</div>
	<br>
	<?php if (isset($exemption_contract->note_lead)) { ?>
		<div class="row">
			<label class="control-label col-md-2 col-xs-12 text-left"
				   style="color: black; font-weight: unset; padding-right: 10px"><span></span>
				Ghi chú/Note của Lead QLHĐV: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<div class="col-md-10 col-xs-12 error_messages">
				<textarea class="form-control" rows="1" disabled
						  placeholder=""><?= $exemption_contract->note_lead ? $exemption_contract->note_lead : ""; ?></textarea>
				<input type="hidden" class="form-control">
				<p class="messages"></p>
			</div>
		</div>
		<br>
	<?php } ?>
	<?php if (isset($exemption_contract->note_tp_thn)) { ?>
		<div class="row">
			<label class="control-label col-md-2 col-xs-12 text-left"
				   style="color: black; font-weight: unset; padding-right: 10px"><span></span>
				Ghi chú/Note của TP QLHĐV: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<div class="col-md-10 col-xs-12 error_messages">
				<textarea class="form-control" rows="1" disabled
						  placeholder=""><?= $exemption_contract->note_tp_thn ? $exemption_contract->note_tp_thn : ""; ?></textarea>
				<input type="hidden" class="form-control">
				<p class="messages"></p>
			</div>
		</div>
	<?php } ?>
	<br>
	<?php if (isset($exemption_contract->note_qlcc)) { ?>
		<div class="row">
			<label class="control-label col-md-2 col-xs-12 text-left"
				   style="color: black; font-weight: unset; padding-right: 10px"><span></span>
				Ghi chú/Note của QLCC: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<div class="col-md-10 col-xs-12 error_messages">
				<textarea class="form-control" rows="1" disabled
						  placeholder=""><?= $exemption_contract->note_qlcc ? $exemption_contract->note_qlcc : ""; ?></textarea>
				<input type="hidden" class="form-control">
				<p class="messages"></p>
			</div>
		</div>
	<?php } ?>
	<br>
	<?php } else if ($contractDB->status == 19) { ?>
			<p style="color: black; text-align: center; font-size: 18px;">Hợp đồng đã được Tất toán!</p>
		<br>
		<br>
		<br>
		<br>
		<?php } else { ?>
			<p style="color: black; text-align: center; font-size: 18px;">Chưa có dữ liệu miễn giảm của kỳ hiện tại <br>
			(Kỳ: <?= !empty($ky_tra_hien_tai) ? $ky_tra_hien_tai : "";?>, ngày đến hạn: <?= !empty($ngay_den_han) ? date("d/m/Y", $ngay_den_han) : "";?>)
			</p>
		<br>
		<br>
		<br>
		<br>
	<?php } ?>
</div>
<div class="row">
	<div class="col-md-12 col-xs-12">
		<div class="x_panel">
			<div class="x_content">
				<div role="tabpanel" class="tab-pane col-md-12 col-xs-12 nopadding" id="tab_content3"
					 aria-labelledby="tab_content3">
					<div class="col-md-12 col-xs-12">
						<h4 class="box__title" style="color: black; font-size: 24px;">LỊCH SỬ</h4>
					</div>
					<div class="col-md-12 col-xs-12 tab-content3">
						<ul class="list-unstyled timeline">
							<?php if (!empty($exemption_contract_log)): ?>
								<?php foreach ($exemption_contract_log as $item):
									$type_payment_exem = !empty($item->record_exemptions->type_payment_exem) ? $item->record_exemptions->type_payment_exem : $item->old->type_payment_exem;
									$amount_exem = !empty($item->new->amount_tp_thn_suggest) ? $item->new->amount_tp_thn_suggest : (!empty($item->old->amount_customer_suggest) ? $item->old->amount_customer_suggest : $item->record_exemptions->amount_customer_suggest);
									?>
									<li>
										<div class="block">
											<hr>
											<div class="tags">
												<a href="" class="tag">
													<span><?= !empty($item->created_at) ? date("d/m/y", $item->created_at) : "" ?></span>
												</a>
											</div>
											<div class="block_content col-md-12 col-xs-12">
												<div class="col-md-1 col-xs-12">
													<img
															src="<?php echo base_url(); ?>assets/imgs/icon/user-border.svg"
															alt="user approve">
												</div>
												<div class="col-md-10 col-xs-12">
													<p>
														<strong><?= !empty($item->action) ? $item->action : "" ?> (Kỳ: <?= !empty($item->ky_tra) ? $item->ky_tra : '' ?>)</strong>
														- <i
																style="color: #828282"><?= !empty($item->created_at) ? date("H:i:s", $item->created_at) : "" ?></i>
													</p>
													<p>
														<i><span
																	style="color: #828282">by: </span> <?= !empty($item->created_by) ? $item->created_by : "" ?>
														</i>
													</p>
													<p>
														<span
																	style="color: #828282">Loại miễn giảm: </span> <?= (!empty($type_payment_exem) && $type_payment_exem == 2) ? 'Tất toán' : "Thanh toán" ?>
														
													</p>
													<p>
														<span
																	style="color: #828282">Số tiền miễn giảm: </span> <?= !empty($amount_exem) ? number_format($amount_exem) : 0 ?>
														
													</p>
													<p><?= !empty($item->new->note) ? $item->new->note : (!empty($item->new->note_lead) ? $item->new->note_lead : (!empty($item->new->note_tp_thn) ? $item->new->note_tp_thn : (!empty($item->new->note_qlcc) ? $item->new->note_qlcc : ""))) ?></p>

													<?php if (!empty($item->new->image_exemption_profile)) { ?>
														<div class="row">
															<?php foreach ((array)$item->new->image_exemption_profile as $key => $value) { ?>

																<?php if ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg') { ?>
																	<div class="col-xs-12 col-md-6 col-lg-3"
																		 style="width: auto">
																		<a href="<?= $value->path ?>"
																		   class="magnify_item"
																		   data-magnify="gallery"
																		   data-src="" data-group="thegallery"
																		   data-gallery="uploads_agree"
																		   data-max-width="992" data-type="image"
																		   data-title="Ảnh hồ sơ bổ sung">
																			<img style="height: 75px"
																				 data-key="<?= $key ?>"
																				 data-fileName="<?= $value->file_name ?>"
																				 data-fileType="<?= $value->file_type ?>"
																				 data-type='agree'
																				 src="<?= $value->path ?>" alt="">
																		</a>
																	</div>

																<?php }
															} ?>
														</div>
													<?php } ?>
													<br>
													<p>
														<?php if (!empty($item->new)) {
															$old_status = exemptions_status($item->old->status);
															$new_status = exemptions_status($item->new->status);
															$old_status = is_array($old_status) ? '' : $old_status;
															$new_status = is_array($new_status) ? '' : ' => ' . $new_status;
															$status_detail = $old_status . $new_status;
														} else {
															$status_detail = "";
														}

														?>
														<span class="work__status"
															  style="background-color: #5a738e; padding: 6px; color: white">
																	<?= ($status_detail != "") ? $status_detail : "Mới" ?>
																</span>
													</p>
												</div>
											</div>
										</div>
									</li>
								<?php endforeach; ?>
							<?php else : ?>
								<li style="text-align: center">
									<p style="color: black; text-align: center; font-size: 18px;">Không có dữ liệu miễn giảm</p>
								</li>
							<?php endif; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<!--Modal Lead QLHĐV approve-->
<?php $this->load->view('page/accountant/thn/modal_leadqlhdv_approve_exemption.php'); ?>

<!--Modal TP QLHĐV approve-->
<?php $this->load->view('page/accountant/thn/modal_tpqlhdv_approve_exemption.php'); ?>

<!--Modal QLCC approve-->
<?php $this->load->view('page/accountant/thn/modal_qlcc_approve_exemption.php'); ?>

<div id='toTop'>
	<i class="fa fa-arrow-circle-up"></i>
</div>
<script>
	<!--	backto top-->
	$(window).scroll(function () {
		if ($(this).scrollTop()) {
			$('#toTop').fadeIn();
		} else {
			$('#toTop').fadeOut();
		}
	});

	$("#toTop").click(function () {
		$("html, body").animate({scrollTop: 0}, 500);
	});
</script>
<style>
	ul.timeline li {
		border-bottom: 1px solid #ffffff;
	}

	.timeline .block {
		border-left: 3px solid #5a738e;
	}

	hr {
		border-top: 1px solid #5a738e;
	}
</style>
<script>
	$(document).ready(function () {
		$("#data_send_high").hide();
		$("#tp_send_up").click(function () {
			$("#tp_send_up").prop('disabled', true);
			$("#data_send_high").show();
		})
	});
</script>
<style type="text/css">
	.checkcontainer {
		display: block;
		position: relative;
		padding-left: 35px;
		margin-bottom: 12px;
		cursor: pointer;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
	}

	.checkcontainer input[type="radio"] {
		display: none;
	}

	.checkcontainer input:checked ~ .radiobtn:after {
		display: block;
		left: 3px;
		top: 0px;
		width: 5px;
		height: 9px;
		border: solid white;
		border-width: 0 2px 2px 0;
		-webkit-transform: rotate(
				45deg
		);
		-ms-transform: rotate(45deg);
		transform: rotate(
				45deg
		);
	}

	.checkcontainer input:checked ~ .radiobtn {
		background-color: #0075ff;
	}

	.radiobtn {
		position: absolute;
		top: 2px;
		left: 0;
		height: 13px;
		width: 13px;
		background-color: #ffff;
		border: 1px solid #767676;
		border-radius: 3px;
	}

	.checkcontainer .radiobtn:after {
		content: "";
		position: absolute;
		display: none;
	}
</style>

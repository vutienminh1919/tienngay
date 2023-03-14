<!-- page content -->

<div class="right_col" role="main">
	<div class="theloading" id="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<div class="col-xs-12 col-lg-1">
					<h2>Chi tiết hồ sơ miễn giảm <span style="font-size: 24px; font-weight: bold; color: black;"><?php echo $profile->profile_name ?></span>
						<?php if ($profile->status == 1) : ?>
							<span class="label label-primary"
								  style="color: white;"><?= !empty($profile->status) ? status_exemption_profile($profile->status) : '' ?></span>
						<?php elseif ($profile->status == 2) : ?>
							<span class="label label-default"
								  style="color: white;"><?= !empty($profile->status) ? status_exemption_profile($profile->status) : '' ?></span>
						<?php elseif ($profile->status == 3) : ?>
							<span class="label label-info"
								  style="color: white;"><?= !empty($profile->status) ? status_exemption_profile($profile->status) : '' ?></span>
						<?php elseif ($profile->status == 4) : ?>
							<span class="label label-success"
								  style="color: white;"><?= !empty($profile->status) ? status_exemption_profile($profile->status) : '' ?></span>
						<?php elseif ($profile->status == 5) : ?>
							<span class="label label-warning"
								  style="color: white;"><?= !empty($profile->status) ? status_exemption_profile($profile->status) : '' ?></span>
						<?php elseif ($profile->status == 6) : ?>
							<span class="label label-warning"
								  style="color: white;"><?= !empty($profile->status) ? status_exemption_profile($profile->status) : '' ?></span>
						<?php elseif ($profile->status == 7) : ?>
							<span class="label label-warning"
								  style="color: white;"><?= !empty($profile->status) ? status_exemption_profile($profile->status) : '' ?></span>
						<?php elseif ($profile->status == 8) : ?>
							<span class="label label-primary"
								  style="color: white;"><?= !empty($profile->status) ? status_exemption_profile($profile->status) : '' ?></span>
						<?php elseif ($profile->status == 9) : ?>
							<span class="label label-default"
								  style="color: white;"><?= !empty($profile->status) ? status_exemption_profile($profile->status) : '' ?></span>
						<?php elseif ($profile->status == 10) : ?>
							<span class="label label-default"
								  style="color: white;"><?= !empty($profile->status) ? status_exemption_profile($profile->status) : '' ?></span>
						<?php endif; ?>
					</h2>


					<input type="hidden" id="profile_old_id" value="<?php echo $profile->_id->{'$oid'} ?>">
					<input type="hidden" id="status_profile_glob" value="<?= $profile->status ? $profile->status : 0 ?>">

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
				<hr>
				<div class="row">
					<div class="col-xs-6 col-md-6">
						<div class="table-responsive" style="overflow-y: auto">
							<table class="table table-borderless">
								<thead>
								<tr>
									<th style="color: #aab6aa;" scope="row">BÊN BÀN GIAO &nbsp;<i class="fa fa-rocket"></i></th>
									<th><?= $profile->user_send ? $profile->user_send : '' ?></th>
								</tr>
								<tr>
									<th style="color: #aab6aa;" scope="row">VỊ TRÍ/PHÒNG BAN</th>
									<th><?= $profile->position_user_send ? $profile->position_user_send : '' ?></th>
								</tr>
								</thead>
								<tbody>
								<tr>
									<th style="color: #aab6aa;" scope="col">NGÀY TẠO</th>
									<th scope="col"><?= $profile->created_at ? date('d/m/Y - H:i:s', $profile->created_at) : '' ?></th>
								</tr>
								<tr>
									<th style="color: #aab6aa;" scope="col">NGÀY BẮT ĐẦU</th>
									<th scope="col"><?= $profile->start_at ? date('d/m/Y - H:i:s', $profile->start_at) : '' ?></th>
								</tr>
								<tr>
									<th style="color: #aab6aa;" scope="col">NGÀY KẾT THÚC</th>
									<th scope="col"><?= $profile->end_at ? date('d/m/Y - H:i:s', $profile->end_at) : '' ?></th>
								</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-xs-6 col-md-6">
						<div class="table-responsive" style="overflow-y: auto">
							<table class="table table-borderless">
								<thead>
								<tr>
									<th style="color: #aab6aa;" scope="col">BÊN NHẬN BÀN GIAO &nbsp;<i class="fa fa-download"></i></th>
									<th scope="col"><?= $profile->user_receive ? $profile->user_receive : '' ?></th>
								</tr>
								</thead>
								<tbody>
								<tr>
									<th style="color: #aab6aa;" scope="row">VỊ TRÍ/PHÒNG BAN</th>
									<th><?= $profile->position_user_receive ? $profile->position_user_receive : '' ?></th>
								</tr>
								<tr>
									<th style="color: #aab6aa;" scope="row">ĐỊA CHỈ NHẬN</th>
									<th><?= $profile->address_receive ? $profile->address_receive : '' ?></th>
								</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="col-xs-12" style="padding-bottom: 5px;">
						<div class="row" id="feature_area">
							<div class="col-md-2 col-xs-12">
								<select class="form-control" id="choose_status_exemp">
									<option value="0">-- Chức năng --</option>
									<!--role Kế toán-->
									<?php if ($kt_ids) : ?>
										<option value="4">Hoàn tất lưu hồ sơ</option>
										<option value="5">Trả về hồ sơ</option>
										<option value="7">Thiếu hồ sơ</option>
									<?php endif; ?>
									<!-- role Thu hồi -->
									<?php if ( ($thn_ids && $profile->status == 6) || ($userSession['is_superadmin'] == 1)) : ?>
										<option value="8">Lưu kho trả</option>
									<?php endif; ?>
								</select>
							</div>
								<div class="col-md-3 col-xs-12">
									<a class="btn btn-info" style="-moz-border-radius-topleft: 18px"
									   onclick="choose_all_status(this)" data-tab="1">
										<i class="fa fa-check"></i>
										Chọn tất cả
									</a>
									<a class="btn btn-success"
									   onclick="save_status_profile(this)" data-tab="1">
										<i class="fa fa-save"></i>
										Lưu
									</a>
								</div>
								<div class="col-md-6 col-xs-12">
									&nbsp;
								</div>
								<div class="col-md-1 col-xs-12">
<!--									<a class="btn btn-success"-->
<!--									   onclick="sync_profile_exemption(this)" data-tab="1">-->
<!--										<i class="fa fa-refresh"></i>-->
<!--										Đồng bộ-->
<!--									</a>-->
									<input type="hidden" id="profile_code_ref" value="<?= $profile->code_ref ? $profile->code_ref : '' ?>">
									<input type="hidden" id="domain_profile" value="<?= $profile->domain_area ? $profile->domain_area : '' ?>">
									<input type="hidden" id="type_send" value="<?= $profile->type_send ? $profile->type_send : '' ?>">
									<input type="hidden" id="profile_status" value="<?= $profile->status ? $profile->status : '' ?>">
									<input type="hidden" id="type_exception" value="<?= $profile->type_exception ? $profile->type_exception : '' ?>">
								</div>
						</div>
						<?php if ( ($kt_ids && $profile->status == 9) || ($thn_ids && $profile->status == 2) ) : ?>
						<div class="row">
							<div class="col-md-10 col-xs-12">
								&nbsp;
							</div>
							<div class="col-md-2 col-xs-12" style="text-align: right;">
								<a class="btn btn-success"
								   onclick="addmore_exemption(this)" data-tab="1">
									<i class="fa fa-plus-circle"></i>
									Thêm đơn
								</a>
							</div>
						</div>
						<?php endif; ?>
					</div>
					<hr>
					<br>
					<div class="col-xs-12">
						<div class="table-responsive">
							<table id="table_detail_exemption"
								   class="table table-bordered m-table table-hover table-calendar table-report ">
								<thead style="background:#3f86c3; color: #ffffff;">
								<tr>
									<th>#</th>
									<th>Mã phiếu ghi</th>
									<th>Mã hợp đồng</th>
									<th>Tên khách hàng</th>
									<th>Số điện thoại</th>
									<th>Trạng thái</th>
									<th>Ghi chú</th>
									<th>Loại miễn giảm</th>
									<th>Kỳ miễn giảm</th>
									<th>Số tiền miễn giảm</th>
									<th>Phòng ban</th>
									<th>Xác thực CEO qua email</th>
									<?php if (!empty($profile->type_exception) && $profile->type_exception == 2) : ?>
									<th>BBBG xe</th>
									<?php endif; ?>
									<th>Đơn miễn giảm (bản giấy)</th>
									<th>Tài khoản tạo</th>
									<th>Ngày duyệt phiếu thu</th>
									<th>Chức năng</th>
								</tr>
								</thead>
								<tbody>
								<?php
								if (!empty($profiles)) :
									foreach ($profiles as $key => $profile) {
										?>
										<tr>
											<input type='hidden' id='exemptions_id' value='<?= $profile->_id->{'$oid'} ?>'>
											<td><?php echo $key + 1 ?></td>
											<td>
												<?php if ($profile->type_send == 1) : ?>
													<span class="label label-success" style="color: white;">GỬI</span>
												<?php elseif ($profile->type_send == 2) : ?>
													<span class="label label-warning" style="color: white;">TRẢ</span>
												<?php elseif ($profile->type_send == 3) : ?>
													<span class="label label-danger" style="color: white;">THIẾU</span>
												<?php endif; ?>
												<?= !empty($profile->code_contract) ? $profile->code_contract : "" ?>
											</td>
											<td><?= !empty($profile->code_contract_disbursement) ? $profile->code_contract_disbursement : "" ?>
												<br>
												<a class="btn btn-info"
												   href="javascript:void(0)"
												   onclick="history_exemption('<?= !empty($profile->_id->{'$oid'}) ? $profile->_id->{'$oid'} : "" ?>')">
													Log
												</a>
											</td>
											<td><?= !empty($profile->customer_name) ? $profile->customer_name : "" ?></td>
											<td><?= !empty($profile->customer_phone_number) ? hide_phone($profile->customer_phone_number) : "" ?></td>
											<td>
										<?php if ( ($kt_ids && $profile->status_profile != 3) || ($thn_ids && $profile->status_profile != 6) ) : ?>
												<?php if ($profile->status_profile == 1) : ?>
													<span class="label label-primary"
														  style="color: white;"><?= !empty($profile->status_profile) ? status_exemption_profile($profile->status_profile) : '' ?></span>
												<?php elseif ($profile->status_profile == 2) : ?>
													<span class="label label-default"
														  style="color: white;"><?= !empty($profile->status_profile) ? status_exemption_profile($profile->status_profile) : '' ?></span>
												<?php elseif ($profile->status_profile == 3) : ?>
													<span class="label label-info"
														  style="color: white;"><?= !empty($profile->status_profile) ? status_exemption_profile($profile->status_profile) : '' ?></span>
												<?php elseif ($profile->status_profile == 4) : ?>
													<span class="label label-success"
														  style="color: white;"><?= !empty($profile->status_profile) ? status_exemption_profile($profile->status_profile) : '' ?></span>
												<?php elseif ($profile->status_profile == 5) : ?>
													<span class="label label-warning"
														  style="color: white;"><?= !empty($profile->status_profile) ? status_exemption_profile($profile->status_profile) : '' ?></span>
												<?php elseif ($profile->status_profile == 6) : ?>
													<span class="label label-warning"
														  style="color: white;"><?= !empty($profile->status_profile) ? status_exemption_profile($profile->status_profile) : '' ?></span>
												<?php elseif ($profile->status_profile == 7) : ?>
													<span class="label label-danger"
														  style="color: white;"><?= !empty($profile->status_profile) ? status_exemption_profile($profile->status_profile) : '' ?></span>
												<?php elseif ($profile->status_profile == 8) : ?>
													<span class="label label-primary"
														  style="color: white;"><?= !empty($profile->status_profile) ? status_exemption_profile($profile->status_profile) : '' ?></span>
												<?php elseif ($profile->status_profile == 9) : ?>
													<span class="label label-default"
														  style="color: white;"><?= !empty($profile->status_profile) ? status_exemption_profile($profile->status_profile) : '' ?></span>
												<?php elseif ($profile->status_profile == 10) : ?>
													<span class="label label-default"
														  style="color: white;"><?= !empty($profile->status_profile) ? status_exemption_profile($profile->status_profile) : '' ?></span>
												<?php endif; ?>
										<?php endif; ?>
												<br>
										<?php if ($kt_ids && $profile->status_profile == 3) : ?>
												<div class="form-group">
													<?php if (in_array($profile->status_profile, [3, 6])) : ?>
													<select class="custom-select select_all_status"
															style="margin-top: 5px;"
															value='<?= !empty($profile->status_profile) ? $profile->status_profile : "" ?>'
															data-id='<?= !empty($profile->_id->{'$oid'}) ? $profile->_id->{'$oid'} : '' ?>'
															onchange="change_exemption_status(this)">
														<?php foreach (status_exemption_profile() as $key1 => $item) :
															if (!in_array($key1, [3,4,5,7,8])) continue;
															if ($kt_ids && $key1 == 8) continue;
															?>
															<option <?= $profile->status_profile == $key1 ? 'selected' : ''; ?>
																	value="<?= $key1 ?>"
																	data-id='<?= !empty($profile->_id->{'$oid'}) ? $profile->_id->{'$oid'} : '' ?>'>
																<?= $item ?>
															</option>
														<?php endforeach; ?>

													</select>
													<?php endif; ?>
												</div>
										<?php  elseif ($thn_ids && $profile->status_profile == 6) : ; ?>
											<div class="form-group">
													<select class="custom-select select_all_status"
															style="margin-top: 5px;"
															value='<?= !empty($profile->status_profile) ? $profile->status_profile : "" ?>'
															data-id='<?= !empty($profile->_id->{'$oid'}) ? $profile->_id->{'$oid'} : '' ?>'
															onchange="change_exemption_status(this)">
														<?php foreach (status_exemption_profile() as $key1 => $item) :
															if ($thn_ids && !in_array($key1, [6, 8])) continue;
															?>
															<option <?= $profile->status_profile == $key1 ? 'selected' : ''; ?>
																	value="<?= $key1 ?>"
																	data-id='<?= !empty($profile->_id->{'$oid'}) ? $profile->_id->{'$oid'} : '' ?>'>
																<?= $item ?>
															</option>
														<?php endforeach; ?>
													</select>
											</div>
										<?php endif; ?>

											</td>
											<td>
												<div class="edit_profile"
													 data-status='<?= !empty($profile->status_profile) ? $profile->status_profile : "" ?>'>
													<?= !empty($profile->profile_note) ? $profile->profile_note : "" ?>
												</div>
												<input type='text'
													   class='txtedit'
													   value='<?= !empty($profile->profile_note) ? $profile->profile_note : "" ?>'
													   id='profile_note_js-<?= !empty($profile->_id->{'$oid'}) ? $profile->_id->{'$oid'} : '' ?>'/>
											</td>
											<td>
												<?= (!empty($profile->type_payment_exem) && $profile->type_payment_exem == 1) ? 'Thanh toán' : "Tất toán" ?>
												-
												<?= (!empty($profile->type_exception) && $profile->type_exception == 1) ? 'Ngoại lệ' : ((!empty($profile->type_exception) && $profile->type_exception == 2) ? 'Thanh lý tài sản' : 'Loại thường') ?>
											</td>
											<td><?= !empty($profile->ky_tra) ? $profile->ky_tra : "-" ?></td>
											<td><?= !empty($profile->amount_tp_thn_suggest) ? number_format($profile->amount_tp_thn_suggest) :
														(!empty($profile->amount_exemptions) ? number_format($profile->amount_exemptions) : '-') ?>

											</td>
											<td><?= !empty($profile->domain_exemption) ? 'THN' . $profile->domain_exemption : "" ?></td>
											<td><?= (!empty($profile->confirm_email) && $profile->confirm_email == 1) ? 'Có' : 'Không có' ?></td>
										<?php if (!empty($profile->type_exception) && $profile->type_exception == 2) : ?>
											<td><?= (!empty($profile->bbbgx) && $profile->bbbgx == 1) ? 'Có' : 'Không có' ?></td>
										<?php endif; ?>
											<td><?= (!empty($profile->is_exemption_paper) && $profile->is_exemption_paper == 1) ? 'Có' : 'Không có' ?></td>

											<td><?= !empty($profile->created_profile_by) ? $profile->created_profile_by : (!empty($profile->created_by_profile) ? $profile->created_by_profile : '') ?></td>
											<td><?= !empty($profile->created_at_profile) ? date('d/m/Y H:i:s', $profile->created_at_profile) : "" ?></td>
										<?php if (in_array($profile->status_profile, [2, 9])) : ?>
											<td style="text-align: center">
												<span class="fa fa-times-circle-o remove_exemption"
													  style="color: lightskyblue"
													  onclick="remove_exemption(this)"
													  data-coderef="<?= !empty($profile->code_parent) ? $profile->code_parent : '' ?>"
													  data-id="<?= !empty($profile->_id->{'$oid'}) ? $profile->_id->{'$oid'} : '' ?>">

												</span>
											</td>
										<?php endif; ?>
										</tr>
									<?php } ?>
								<?php else : ?>
									<tr style="text-align: center">
										<td colspan="15">Không có dữ liệu</td>
									</tr>
								<?php endif; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--Modal Log đơn miễn giảm-->
<div class="modal fade" id="exemption_log_modal" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" style="width: 70%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center">Lịch sử xử lý đơn miễn giảm</h3>
			</div>
			<div class="modal-body ">
				<div class="x_panel">
					<div class="x_content">
						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
								<tr>
									<th>#</th>
									<th>Thời gian</th>
									<th>Người xử lý</th>
									<th>Mã phiếu ghi</th>
									<th>Mã hợp đồng</th>
									<th>Khách hàng</th>
									<th>Trạng thái</th>
									<th>Loại đơn gửi</th>
									<th>Ghi chú</th>
									<th>Thay đổi khác</th>
								</tr>
								</thead>
								<tbody id="tbody_exemption_log">

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>


<!--Modal Add thêm đơn miễn giảm -->
<div class="modal fade" id="addmore_exemption" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center">Thêm đơn miễn giảm</h3>
			</div>
			<div class="modal-body ">
				<div class="x_panel">
					<div class="x_content">
						<div class="table-responsive">
							<table id="tbl_add_exemption" class="table table-striped display" width="100%">
								<thead>
								<tr>
									<th>#</th>
									<th>Mã phiếu ghi</th>
									<th>Mã hợp đồng</th>
									<th>Khách hàng</th>
									<th>Trạng thái</th>
									<th>Loại đơn gửi</th>
									<th>
										<input type="checkbox" id="select_all_exemp"/>
									</th>
								</tr>
								</thead>
								<tbody id="tbody_addmore_exemption">

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger"  data-dismiss="modal">
					<i class="fa fa-close" aria-hidden="true"></i> Hủy
				</button>
				<button type="button" onclick="saveModalExemption(this)" class="btn btn-success">
					<i class="fa fa-save" aria-hidden="true"></i> Lưu lại
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<!-- /page content -->
<script src="<?php echo base_url('assets/js/examptions/index.js') ?>"></script>
<script type="text/javascript">
	var role_thn = <?php echo $thn_ids ? $thn_ids : 0;?>;
	var role_kt = <?php echo $kt_ids ? $kt_ids : 0;?>;
	var status_profile = $('#status_profile_glob').val();
	console.log(status_profile)
	if (role_thn && status_profile != 6) {
		$('#feature_area').hide();
		$('.select_all_status').prop('disabled', true);
	}
	if (role_kt && !in_array(status_profile, [3]) ) {
		$('#feature_area').hide();
		$('.select_all_status').prop('disabled', true);
	}
</script>
<script type="text/javascript">

	$(document).ready(function () {
		$('.edit_profile').click(function () {
			let status = $(this).data('status');
			console.log(status)
			$('.txtedit').hide();
			$(this).next('.txtedit').show().focus();
			$(this).hide();
		});
	});
	$(".txtedit").on('focusout', function () {

		// Get edit id, field name and value
		var self = this;
		var id = this.id;
		var split_id = id.split("-");
		var field_name = split_id[0];
		var edit_id = split_id[1];
		var profile_note = $(this).val();

		// Hide Input element
		$(this).hide();

		// Hide and Change Text of the container with input elmeent
		$(this).prev('.edit_profile').show();
		$(this).prev('.edit_profile').text(profile_note);
		var formData = {field: field_name, profile_note: profile_note, exemption_id: edit_id}
		console.log(formData)

		// Sending AJAX request
		if (confirm("Xác nhận thay đổi?")) {
			$.ajax({
				url: _url.base_url + 'Exemptions/update_exemption_spa',
				type: 'post',
				data: formData,
				success: function (response) {
					if (response.status == 200) {
						console.log('Save successfully');
					} else {

					}
				}
			});
		}
	});
</script>
<style type="text/css">
	.container {
		margin: 0 auto;
	}

	.edit_profile {
		width: 100%;
		height: 25px;
	}

	.txtedit {
		display: none;
		width: 99%;
		height: 30px;
	}

	.remove_exemption:hover {
		cursor: pointer;
	}
</style>


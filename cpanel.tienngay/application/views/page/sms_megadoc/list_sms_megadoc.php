<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$status = !empty($_GET['status']) ? $_GET['status'] : "";
	$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
	$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
	$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
	$customer_phone_number = !empty($_GET['customer_phone']) ? $_GET['customer_phone'] : "";
	$type_document = !empty($_GET['type_document']) ? $_GET['type_document'] : "";
	$type_sms = !empty($_GET['type_sms']) ? $_GET['type_sms'] : "";
	$status_sms = !empty($_GET['status_sms']) ? $_GET['status_sms'] : "";
	$store = !empty($_GET['store']) ? $_GET['store'] : "";
	?>
	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="row">
					<div class="col-xs-12">
						<h3>Danh sách tin nhắn SMS Hợp đồng điện tử
							<br>
							<small>
								<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
									href="<?php echo base_url() ?>pawn/contract">Danh sách tin nhắn SMS Hợp đồng điện tử</a>
							</small>
						</h3>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-xs-12">
							<div class="row">
								<div class="col-xs-12 col-md-3"></div>
								<div class="col-xs-12 col-md-3"></div>
								<div class="col-xs-12 col-md-6 text-right">
									<div class="dropdown" style="display:inline-block">
										<button class="btn btn-success dropdown-toggle"
												onclick="$('#lockdulieu').toggleClass('show');">
											<span class="fa fa-filter"></span>
											Lọc dữ liệu
										</button>
										<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
											style="padding:15px;width:550px;max-width: 85vw;">
											<div class="row">
												<form action="<?php echo base_url('SmsMegadoc') ?>" method="get"
													  style="width: 100%">
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label> Từ </label>
															<input type="date" name="fdate" class="form-control"
																   value="<?= !empty($fdate) ? $fdate : "" ?>">
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label> Đến </label>
															<input type="date" name="tdate" class="form-control"
																   value="<?= !empty($tdate) ? $tdate : "" ?>">
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label> Mã hợp đồng </label>
															<input type="text" name="code_contract_disbursement"
																   class="form-control"
																   value="<?= $code_contract_disbursement ?>"
																   placeholder="Nhập đầy đủ mã hợp đồng">
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label> Mã Phiếu ghi </label>
															<input type="text" name="code_contract" class="form-control"
																   value="<?= $code_contract ?>"
																   placeholder="Nhập đầy đủ mã phiếu ghi">
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label> Tên khách hàng </label>
															<input type="text" name="customer_name" class="form-control"
																   value="<?= $customer_name ?>"
																   placeholder="Nhập đầy đủ tên khách hàng">
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label> Số điện thoại </label>
															<input type="text" name="customer_phone" class="form-control"
																   value="<?= $customer_phone_number ?>"
																   placeholder="Nhập số điện thoại">
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label>Loại SMS</label>
															<select class="form-control" name="type_sms">
																<option value="">-- Tất cả --</option>
																<?php foreach (type_sms_megadoc() as $key => $sms) : ?>
																	<option <?php echo $type_sms == $key ? 'selected' : '' ?>
																			value="<?= $key ?>">
																		<?php echo $sms ?>
																	</option>
																<?php endforeach; ?>
															</select>
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label>Loại Văn bản</label>
															<select class="form-control" name="type_document">
																<option value="">-- Tất cả --</option>
																<?php foreach (type_document_sms() as $key => $item) : ?>
																	<option <?php echo $type_document == $key ? 'selected' : '' ?>
																			value="<?= $key ?>"><?= $item ?></option>
																<?php endforeach; ?>
															</select>
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label>Trạng thái SMS</label>
															<select class="form-control" name="status_sms">
																<option value="">-- Tất cả --</option>
																<?php foreach (status_sms_megadoc() as $key => $item) : ?>
																	<option <?php echo $status_sms == $key ? 'selected' : '' ?>
																			value="<?= $key ?>"><?= $item ?>
																	</option>
																<?php endforeach; ?>
															</select>
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label> Phòng giao dịch </label>
															<select id="province" class="form-control" name="store">
																<option value="">-- Tất cả --</option>
																<?php foreach ($stores as $key => $str) : ?>
																	<?php if (!in_array($key, $store_megadoc)) continue; ?>
																	<option <?php echo $store == $key ? 'selected' : '' ?>
																			value="<?php echo $key; ?>"><?php echo $str; ?>
																	</option>
																<?php endforeach; ?>
															</select>
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<label>&nbsp;</label>
														<button class="btn btn-primary w-100"><i class="fa fa-search"
																								 aria-hidden="true"></i>
															Tìm kiếm
														</button>
													</div>
												</form>
											</div>
											<script>
												$('.selectize').selectize({
													// sortField: 'text'
												});
											</script>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="x_content">
					<div class="row">
						<div class="col-xs-12">
							<div class="row"></div>
						</div>
						<div class="col-xs-12">
							<div>
								<h4>
									<?php if ($result_count != 0) : ?>
										<?php echo "Hiển thị (" . "<span class='text-danger'>$result_count</span>" . ") kết quả." ?>
									<?php endif; ?>
								</h4>
							</div>
							<div class="table-responsive" style="min-height: 500px; overflow-y: auto">
								<table class="table table-striped">
									<thead>
									<tr>
										<td>STT</td>
										<td>Mã hợp đồng</td>
										<td>Mã phiếu ghi</td>
										<td>Tên khách hàng</td>
										<td>Số điện thoại</td>
										<td>Loại SMS</td>
										<td>Loại văn bản</td>
										<td>Trạng thái SMS</td>
										<td>Phòng giao dịch</td>
										<td>Ngày gửi SMS</td>
										<td></td>
									</tr>
									</thead>
									<tbody>
									<?php
									if (!empty($sms_megadoc)) {
										foreach ($sms_megadoc as $key => $sms) {
											?>
											<tr>
												<td><?= ++$key;?></td>
												<td>
													<a target="_blank"
													   href="<?php echo base_url("pawn/detail?id=") . $sms->id_contract; ?>"
													   class="link" data-toggle="tooltip"
													   data-placement="top" title="Click để xem chi tiết"
													   style="color: #0ba1b5;text-decoration: underline;">
														<?= !empty($sms->code_contract_disbursement) ? $sms->code_contract_disbursement : '';?>
													</a>
												</td>
												<td><?= !empty($sms->code_contract) ? $sms->code_contract : '';?></td>
												<td><?= !empty($sms->customer_name) ? $sms->customer_name : '';?></td>
												<td><?= !empty($sms->customer_phone) ? $sms->customer_phone : '';?></td>
												<td><?= !empty($sms->type) ? $sms->type : '';?></td>
												<td>
													<?php
													$type_document = '';
													if (!empty($sms->type_document)) {
														if ($sms->type_document == 'ttbb') {
															$type_document = 'Thỏa thuận ba bên';
														} elseif ($sms->type_document == 'bbbgt') {
															$type_document = 'Biên bản bàn giao tài sản khi vay';
														} elseif ($sms->type_document == 'tb') {
															$type_document = 'Thông báo';
														} elseif ($sms->type_document == 'bbbgs') {
															$type_document = 'Biên bản bàn giao tài sản khi thanh lý';
														} else {
															$type_document = '';
														}
													}
													print $type_document;
													?>
												</td>
												<td>
													<?php if (!empty($sms->status)) { ?>
														<?php if ($sms->status == 'success') : ?>
															<span class="label label-success">Thành công</span>
														<?php  elseif ($sms->status == 'fail') : ?>
															<span class="label label-danger">Gửi lỗi</span>
													<?php if (in_array("626a182c4bee423dcc521205", $userRoles->role_access_rights) || $userSession['is_superadmin'] == 1) : ?>
															<a href="javascript:void(0)" class="btn btn-info btn-sm"
															   onclick="resend_sms_to_customer(this)"
															   data-codecontract='<?= isset($sms->code_contract) ? $sms->code_contract : '' ?>'
															   data-idsms='<?= isset($sms->_id->{'$oid'}) ? $sms->_id->{'$oid'} : '' ?>'>
																Gửi lại SMS
															</a>
													<?php endif; ?>
														<?php elseif ($sms->status == 'new') : ?>
															<span class="label label-info">Tạo mới</span>
															<?php if (in_array("626a182c4bee423dcc521205", $userRoles->role_access_rights) || $userSession['is_superadmin'] == 1) : ?>
																<a href="javascript:void(0)" class="btn btn-info btn-sm"
																   onclick="resend_sms_to_customer(this)"
																   data-codecontract='<?= isset($sms->code_contract) ? $sms->code_contract : '' ?>'
																   data-idsms='<?= isset($sms->_id->{'$oid'}) ? $sms->_id->{'$oid'} : '' ?>'>
																	Gửi lại SMS
																</a>
															<?php endif; ?>
														<?php endif; ?>
													<?php } ?>
												</td>
												<td><?= !empty($sms->store->name) ? $sms->store->name : '';?></td>
												<td><?= !empty($sms->send_time) ? date('d/m/Y H:i:s', $sms->send_time) : '';?></td>
											</tr>
										<?php }
									} else { ?>
										<tr>
											<td colspan="20">
												<h4>Không có dữ liệu</h4>
											</td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
								<div class="">
									<?php echo $pagination ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>assets/js/pawn/contract.js?rev=<?php echo time(); ?>"></script>
<script type="text/javascript">
	$(document).ready(function () {
		const $menu = $('.dropdown');
		$(document).mouseup(e => {
			if (!$menu.is(e.target)
					&& $menu.has(e.target).length === 0) {
				$menu.removeClass('is-active');
				$('.dropdown-menu').removeClass('show');
			}
		});
		$('.dropdown-toggle').on('click', () => {
			$menu.toggleClass('is-active');
		});
	});

</script>


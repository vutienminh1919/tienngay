<link href="<?php echo base_url(); ?>assets/teacupplugin/magnify/css/jquery.magnify.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/teacupplugin/magnify/js/jquery.magnify.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
<!-- page content -->
<?php
$tab = !empty($_GET['tab']) ? $_GET['tab'] : "exemption";
$from_date = !empty($_GET['from_date']) ? $_GET['from_date'] : "";
$to_date = !empty($_GET['to_date']) ? $_GET['to_date'] : "";
$store = !empty($_GET['store']) ? $_GET['store'] : "";
$status = !empty($_GET['status']) ? $_GET['status'] : "";
$type_send = !empty($_GET['type_send']) ? $_GET['type_send'] : "";
$postal_code = !empty($_GET['postal_code']) ? $_GET['postal_code'] : "";
$bbbg_code = !empty($_GET['bbbg_code']) ? $_GET['bbbg_code'] : "";
$domain_exemption = !empty($_GET['domain_exemption']) ? $_GET['domain_exemption'] : "";
$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";

?>
<?php if (in_array("63318191aa71cfa1010ebe94", $userRoles->role_access_rights)) : ?>
<div class="right_col" role="main">
	<div class="theloading" id="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>DANH SÁCH ĐƠN MIỄN GIẢM</h3>
				</div>
				<div class="title_right text-right">
					<?php if ( in_array($tab, ['normal', 'exception', 'asset']) ) : ?>
						<a class="btn btn-info"
						   onclick="create_profile_exemption(this)" data-tab="1">
							<i class="fa fa-plus" aria-hidden="true"></i>
							Tạo Hồ sơ miễn giảm
						</a>
					<?php endif; ?>
					<div class="dropdown" style="display:inline-block">
						<button class="btn btn-success dropdown-toggle"
								onclick="$('#lockdulieu').toggleClass('show');">
							<span class="fa fa-filter"></span>
							Lọc dữ liệu
						</button>
						<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
							style="padding:15px;width:430px;max-width: 85vw;">
							<div class="row">
								<form action="<?php echo base_url('Exemptions/profile_exemption') ?>" method="get"
									  style="width: 100%">
									<div class="col-xs-12 col-md-6">
										<div class="form-group">
											<label> Từ </label>
											<input type="date" name="from_date" class="form-control"
												   value="<?= !empty($from_date) ? $from_date : "" ?>">
										</div>
									</div>
									<div class="col-xs-12 col-md-6">
										<div class="form-group">
											<label> Đến </label>
											<input type="date" name="to_date" class="form-control"
												   value="<?= !empty($to_date) ? $to_date : "" ?>">
										</div>
									</div>
									<?php if ( in_array($tab, ['all', 'normal', 'exception', 'asset']) ) : ?>
									<div class="col-xs-12 col-md-6">
										<div class="form-group">
											<label> Mã phiếu ghi </label>
											<input type="text" name="code_contract" class="form-control">
										</div>
									</div>
									<div class="col-xs-12 col-md-6">
										<div class="form-group">
											<label> Mã hợp đồng </label>
											<input type="text" name="code_contract_disbursement" class="form-control">
										</div>
									</div>
									<div class="col-xs-12 col-md-6">
										<div class="form-group">
											<label> Tên khách hàng </label>
											<input type="text" name="customer_name" class="form-control">
										</div>
									</div>
										<?php if ($kt_role) : ; ?>
										<div class="col-xs-12 col-md-6">
											<div class="form-group">
												<label>Khu vực:</label>
												<select class="form-control"
														placeholder="Tất cả"
														name="domain_exemption">
													<option value="" selected>Tất cả</option>
													<?php foreach (domain() as $key => $domain) :
														if ($key == 'MT') continue;
														?>
														<option <?php echo $key == $domain_exemption ? 'selected' : '' ?>
																value="<?php echo $key; ?>"><?php echo $domain; ?>
														</option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
										<?php endif ; ?>
									<div class="col-xs-12 col-md-6">
										<div class="form-group">
											<label>PGD:</label>
											<select class="form-control"
													placeholder="Tất cả"
													name="store">
												<option value="" selected>Tất cả</option>
												<?php foreach ($stores as $sto) :
													if (in_array($sto->_id->{'$oid'},
														[
														  "5e593293d6612b26016acaae"
														, "5ecbda18d6612b0fd70b891f"
														, "5eb8f2ebd6612b350f5932e3"
														, "60f50af45324a7353636d565"
														])) continue;
													?>
													<option <?php echo $store == $sto->_id->{'$oid'} ? 'selected' : '' ?>
															value="<?php echo $sto->_id->{'$oid'}; ?>"><?php echo $sto->name; ?>
													</option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
									<?php endif; ?>
									<div class="col-xs-12 col-md-6">
										<div class="form-group">
											<label>Loại đơn gửi:</label>
											<select class="form-control"
													placeholder="Tất cả"
													name="type_send">
												<option value="" selected>Tất cả</option>
												<?php foreach (type_send() as $key => $send) :
													if ($kt_role && $key != 2 && in_array($tab, ['normal', 'exception', 'asset']) ) continue;
													?>
													<option <?php echo $key == $type_send ? 'selected' : '' ?>
															value="<?php echo $key; ?>"><?php echo $send; ?>
													</option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
									<div class="col-xs-12 col-md-6">
										<div class="form-group">
											<label>Trạng thái:</label>
											<select class="form-control"
													placeholder="Tất cả"
													name="status">
												<option value="" selected>Tất cả</option>
												<?php foreach (status_exemption_profile() as $key => $sta) :
													if ($tab == 'all' && $key == 10) continue;
													if ( in_array($tab, ['normal', 'exception', 'asset']) && !in_array($key, [5]) && $kt_role ) continue;
													if ( in_array($tab, ['normal', 'exception', 'asset']) && in_array($key, [2, 3, 4, 5, 6, 9, 10]) && $thn_role ) continue;
													if ( in_array($tab, ['profile_normal', 'profile_exception', 'profile_asset']) && in_array($key, [1]) ) continue;
													?>
													<option <?php echo $key == $status ? 'selected' : '' ?>
															value="<?php echo $key; ?>"><?php echo $sta; ?>
													</option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
									<?php if ( in_array($tab, ['profile_normal', 'profile_exception', 'profile_asset']) ) : ?>
									<div class="col-xs-12 col-md-6">
										<div class="form-group">
											<label> Mã bưu phẩm </label>
											<input type="text" name="postal_code" class="form-control">
										</div>
									</div>
									<div class="col-xs-12 col-md-6">
										<div class="form-group">
											<label> Mã BBBG </label>
											<input type="text" name="bbbg_code" class="form-control">
										</div>
									</div>
									<?php endif; ?>
									<div class="col-xs-12 col-md-6">
										<input type="hidden" name="tab" class="form-control"
											   value="<?= !empty($tab) ? $tab : "" ?>">
									</div>
									<div class="col-xs-12 col-md-6">
										<div class="form-group">
											<label>&nbsp;</label> <br>
											<button class="btn btn-primary w-100">Tìm kiếm</button>
										</div>
									</div>
								</form>
							</div>
						</ul>
					</div>
					<?php
					if ($userSession['is_superadmin'] == 1 || $kt_role || $thn_role) { ?>
						<a href="<?php echo base_url() ?>Exemptions/exportProfileExemptions?<?= 'tab='
						. $tab
						. '&from_date=' . $from_date
						. '&to_date=' . $to_date
						. '&store=' . $store
						. '&status=' . $status
						. '&type_send=' . $type_send
						. '&domain_exemption=' . $domain_exemption
						. '&code_contract=' . $code_contract
						. '&code_contract_disbursement=' . $code_contract_disbursement
						. '&customer_name=' . $customer_name
						. '&postal_code=' . $postal_code
						. '&bbbg_code=' . $bbbg_code ?>"
						   class="btn btn-success"
						   target="_blank">
							<i class="fa fa-save" aria-hidden="true"></i>
							Xuất Excel
						</a>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-xs-12 text-right">
							<ul id="myTab1" class="nav nav-pills bar_tabs left" role="tablist">
								<li role="presentation" class="<?= ($tab == 'all') ? 'active' : '' ?>">
									<a href="<?php echo base_url() ?>Exemptions/profile_exemption?tab=all"
									   id=""
									   aria-expanded="true">Tất cả đơn miễn giảm
									</a>
								</li>
								<li role="presentation" class="<?= ($tab == 'normal') ? 'active' : '' ?>">
									<a href="<?php echo base_url() ?>Exemptions/profile_exemption?tab=normal"
									   id=""
									   aria-expanded="true">Đơn miễn giảm (loại thường)
									</a>
								</li>
								<li role="presentation" class="<?= ($tab == 'exception') ? 'active' : '' ?>">
									<a href="<?php echo base_url() ?>Exemptions/profile_exemption?tab=exception"
									   id=""
									   aria-expanded="true">Đơn miễn giảm (ngoại lệ)
									</a>
								</li>
								<li role="presentation" class="<?= ($tab == 'asset') ? 'active' : '' ?>">
									<a href="<?php echo base_url() ?>Exemptions/profile_exemption?tab=asset"
									   id=""
									   aria-expanded="true">Đơn miễn giảm (thanh lý tài sản)
									</a>
								</li>
								<li role="presentation" class="<?= ($tab == 'profile_normal') ? 'active' : '' ?>">
									<a href="<?php echo base_url() ?>Exemptions/profile_exemption?tab=profile_normal"
											id=""
											aria-expanded="false">Hồ sơ miễn giảm (loại thường)
									</a>
								</li>
								<li role="presentation" class="<?= ($tab == 'profile_exception') ? 'active' : '' ?>">
									<a href="<?php echo base_url() ?>Exemptions/profile_exemption?tab=profile_exception"
											id=""
											aria-expanded="false">Hồ sơ miễn giảm (ngoại lệ)
									</a>
								</li>
								<li role="presentation" class="<?= ($tab == 'profile_asset') ? 'active' : '' ?>">
									<a href="<?php echo base_url() ?>Exemptions/profile_exemption?tab=profile_asset"
											id=""
											aria-expanded="false">Hồ sơ miễn giảm (thanh lý tài sản)
									</a>
								</li>
							</ul>
						</div>
					</div>
					<br>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="" role="tabpanel" data-example-id="togglable-tabs">
						<div id="myTabContent2" class="tab-content">
							<div role="tabpanel" class="tab-pane fade in <?= ($tab == 'all') ? 'active' : '' ?>">
								<?php if ($tab == 'all') { ?>
									<div class="row">
<!--										<div class="col-md-3 col-xs-12">-->
<!--											<select class="form-control" id="choose_option_email">-->
<!--												<option value="0">-- Email đơn miễn giảm --</option>-->
<!--												<option value="1">Có email CEO xác nhận</option>-->
<!--												<option value="2">Không có email CEO xác nhận</option>-->
<!--											</select>-->
<!--										</div>-->
<!--										<div class="col-md-3 col-xs-12">-->
<!--											<a class="btn btn-info fa fa-check"-->
<!--											   onclick="choose_all_email(this)" data-tab="1">-->
<!--												Chọn tất cả-->
<!--											</a>-->
<!--											<a class="btn btn-success"-->
<!--											   onclick="save_is_email(this)" data-tab="1">-->
<!--												<i class="fa fa-save"></i>-->
<!--												&nbsp;Lưu-->
<!--											</a>-->
<!--										</div>-->
										<div class="col-md-3 col-xs-12">
											<select class="form-control" id="choose_option_paper">
												<option value="0">-- Đơn miễn giảm (bản giấy) --</option>
												<option value="1">Có đơn miễn giảm (bản giấy)</option>
												<option value="2">Không có đơn miễn giảm (bản giấy)</option>
											</select>
										</div>
										<div class="col-md-3 col-xs-12">
											<a class="btn btn-info fa fa-check"
											   onclick="choose_all_paper(this)" data-tab="1">
												Chọn tất cả
											</a>
											<a class="btn btn-success"
											   onclick="save_is_paper(this)" data-tab="1">
												<i class="fa fa-save"></i>
												&nbsp;Lưu
											</a>
										</div>
									</div>
									<hr>
									<div>
										<h4>
											<?php if ($result_count != 0) : ?>
												<?php echo "Hiển thị (" . "<span class='text-danger'>$result_count</span>" . ') kết quả' ; ?>
											<?php endif; ?>
										</h4>
									</div>
									<div class="table-responsive" style="overflow-y: auto">
										<table
												class="table table-bordered m-table table-hover table-calendar table-report"
												id="table_exemptions">
											<thead style="background:#3f86c3; color: #ffffff;">
											<tr>
												<th style="text-align: center">#</th>
												<th style="text-align: center">Mã phiếu ghi</th>
												<th style="text-align: center">Mã hợp đồng</th>
												<th style="text-align: center">Tên khách hàng</th>
												<th style="text-align: center">SĐT</th>
												<th style="text-align: center">Khu vực</th>
												<th style="text-align: center">Loại miễn giảm</th>
												<th style="text-align: center">Kỳ miễn giảm</th>
												<th style="text-align: center">Số tiền miễn giảm</th>
												<th style="text-align: center">Trạng thái</th>
												<th style="text-align: center">Email CEO xác nhận</th>
												<th style="text-align: center">Đơn miễn giảm (bản giấy)</th>
												<th style="text-align: center">BBBG HSMG</th>
												<th style="text-align: center">Ngày duyệt phiếu thu</th>
											</tr>
											</thead>
											<tbody>
											<?php if (!empty($exemptions)) : ?>
												<?php foreach ($exemptions as $key => $exemption) { ?>
													<tr>
														<td><?= ++$key ?></td>
														<td><?php if ($exemption->type_send == 1) : ?>
																<span class="label label-success" style="color: white;">GỬI</span>
															<?php elseif ($exemption->type_send == 2) : ?>
																<span class="label label-warning" style="color: white;">TRẢ</span>
															<?php elseif ($exemption->type_send == 3) : ?>
																<span class="label label-danger" style="color: white;">THIẾU</span>
															<?php endif; ?>
															<?= !empty($exemption->code_contract) ? $exemption->code_contract : '' ?>
														</td>
														<td>
															<?php if (!empty($exemption->code_parent)) : ?>
																<a href="<?php echo base_url("Exemptions/detail_profile?code=") . $exemption->code_parent; ?>"
																   data-toggle="tooltip"
																   data-placement="top"
																   title="Click xem chi tiết hồ sơ"
																   target="_blank">
																	<?= !empty($exemption->code_contract_disbursement) ? $exemption->code_contract_disbursement : '' ?>
																</a>
															<?php else : ?>
																<?= !empty($exemption->code_contract_disbursement) ? $exemption->code_contract_disbursement : '' ?>
															<?php endif; ?>
															<br>
															<a class="btn btn-info"
															   href="javascript:void(0)"
															   onclick="history_exemption('<?= !empty($exemption->_id->{'$oid'}) ? $exemption->_id->{'$oid'} : "" ?>')">
																Log
															</a>
														</td>
														<td><?= !empty($exemption->customer_name) ? $exemption->customer_name : '' ?></td>
														<td><?= !empty($exemption->customer_phone_number) ? hide_phone($exemption->customer_phone_number) : '' ?></td>
														<td>
															<?php if ($exemption->domain_exemption == 'MB') : ?>
																<span class="label label-success" style="color: white;">Miền Bắc</span>
															<?php elseif ($exemption->domain_exemption == 'MN') : ?>
																<span class="label label-danger" style="color: white;">Miền Nam</span>
															<?php endif; ?>
														</td>
														<td>
															<?= (!empty($exemption->type_payment_exem) && $exemption->type_payment_exem == 1) ? 'Thanh toán kỳ' : 'Tất toán' ?>
															-
															<?= (!empty($exemption->type_exception) && $exemption->type_exception == 1) ? 'Ngoại lệ' : ((!empty($exemption->type_exception) && $exemption->type_exception == 2) ? 'Thanh lý tài sản' : 'Loại thường') ?>
														</td>
														<td><?= !empty($exemption->ky_tra) ? $exemption->ky_tra : '' ?></td>
														<td><?= !empty($exemption->amount_tp_thn_suggest) ? number_format($exemption->amount_tp_thn_suggest) : (!empty($exemption->amount_exemptions) ? number_format($exemption->amount_exemptions) : 0) ?></td>
														<td>
															<?php if ($exemption->status_profile == 1) : ?>
																<span class="label label-primary"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 2) : ?>
																<span class="label label-default"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 3) : ?>
																<span class="label label-info"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 4) : ?>
																<span class="label label-success"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 5) : ?>
																<span class="label label-warning"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 6) : ?>
																<span class="label label-warning"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 7) : ?>
																<span class="label label-danger"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 8) : ?>
																<span class="label label-info"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 9) : ?>
																<span class="label label-default"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 10) : ?>
																<span class="label label-default"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php endif; ?>
														</td>
														<td>
															<?= !empty($exemption->confirm_email) ? is_yes_or_no($exemption->confirm_email) : ''; ?>
														</td>
														<td>
															<?php if (in_array($exemption->status_profile, [1, 5, 8])) : ?>
																<select class="choose_is_paper"
																		value="<?= !empty($exemption->is_exemption_paper) ? $exemption->is_exemption_paper : ''; ?>"
																		data-id="<?= !empty($exemption->_id->{'$oid'}) ? $exemption->_id->{'$oid'} : ''; ?>"
																		onchange="change_one_exemption_paper(this)">
																	<?php foreach (is_yes_or_no() as $key2 => $paper) : ?>
																		<option <?= $exemption->is_exemption_paper == $key2 ? 'selected' : ''; ?>
																				value="<?= $key2 ?>"
																				data-id='<?= !empty($exemption->_id->{'$oid'}) ? $exemption->_id->{'$oid'} : '' ?>'>
																			<?= $paper ?>
																		</option>
																	<?php endforeach; ?>
																</select>
															<?php else : ?>
																<?= !empty($exemption->is_exemption_paper) ? is_yes_or_no($exemption->is_exemption_paper) : ''; ?>
															<?php endif; ?>
														</td>
														<td><?= !empty($exemption->is_bbbg_profile) ? is_yes_or_no($exemption->is_bbbg_profile) : ''; ?></td>
														<td><?= !empty($exemption->created_at_profile) ? date("d/m/Y H:i:s", $exemption->created_at_profile) : '' ?></td>
													</tr>
												<?php } ?>
											<?php else : ?>
												<tr style="text-align: center; color: red;">
													<td colspan="13">Không có dữ liệu</td>
												</tr>
											<?php endif; ?>
											</tbody>
										</table>
										<div>
											<nav class="text-left">
												<?php echo $pagination ?>
											</nav>
										</div>
									</div>
								<?php } ?>
							</div>
							<div role="tabpanel" class="tab-pane fade in <?= ($tab == 'normal') ? 'active' : '' ?>">
								<?php if ($tab == 'normal') { ?>
									<div class="row">
<!--										<div class="col-md-3 col-xs-12">-->
<!--											<select class="form-control" id="choose_option_email">-->
<!--												<option value="0">-- Email đơn miễn giảm --</option>-->
<!--												<option value="1">Có email CEO xác nhận</option>-->
<!--												<option value="2">Không có email CEO xác nhận</option>-->
<!--											</select>-->
<!--										</div>-->
<!--										<div class="col-md-3 col-xs-12">-->
<!--											<a class="btn btn-info fa fa-check"-->
<!--											   onclick="choose_all_email(this)" data-tab="1">-->
<!--												Chọn tất cả-->
<!--											</a>-->
<!--											<a class="btn btn-success"-->
<!--											   onclick="save_is_email(this)" data-tab="1">-->
<!--												<i class="fa fa-save"></i>-->
<!--												&nbsp;Lưu-->
<!--											</a>-->
<!--										</div>-->
										<div class="col-md-3 col-xs-12">
											<select class="form-control" id="choose_option_paper">
												<option value="0">-- Đơn miễn giảm (bản giấy) --</option>
												<option value="1">Có đơn miễn giảm (bản giấy)</option>
												<option value="2">Không có đơn miễn giảm (bản giấy)</option>
											</select>
										</div>
										<div class="col-md-3 col-xs-12">
											<a class="btn btn-info fa fa-check"
											   onclick="choose_all_paper(this)" data-tab="1">
												Chọn tất cả
											</a>
											<a class="btn btn-success"
											   onclick="save_is_paper(this)" data-tab="1">
												<i class="fa fa-save"></i>
												&nbsp;Lưu
											</a>
										</div>
									</div>
									<hr>
									<div>
										<h4>
											<?php if ($result_count != 0) : ?>
												<?php echo "Hiển thị (" . "<span class='text-danger'>$result_count</span>" . ') kết quả' ; ?>
											<?php endif; ?>
										</h4>
									</div>
									<div class="table-responsive" style="overflow-y: auto">
										<table
												class="table table-bordered m-table table-hover table-calendar table-report"
												id="table_exemption">
											<thead style="background:#3f86c3; color: #ffffff;">
											<tr>
												<th style="text-align: center">#</th>
												<th style="text-align: center">
													<input type="checkbox" name="all_exemption"
														   id="select_all_exemption">
												</th>
												<th style="text-align: center">Mã phiếu ghi</th>
												<th style="text-align: center">Mã hợp đồng</th>
												<th style="text-align: center">Tên khách hàng</th>
												<th style="text-align: center">SĐT</th>
												<th style="text-align: center">Khu vực</th>
												<th style="text-align: center">Loại miễn giảm</th>
												<th style="text-align: center">Kỳ miễn giảm</th>
												<th style="text-align: center">Số tiền miễn giảm</th>
												<th style="text-align: center">Trạng thái</th>
												<th style="text-align: center">Email CEO xác nhận</th>
												<th style="text-align: center">Đơn miễn giảm (bản giấy)</th>
												<th style="text-align: center">BBBG HSMG</th>
												<th style="text-align: center">Ngày duyệt phiếu thu</th>
											</tr>
											</thead>
											<tbody>
											<?php if (!empty($exemptions)) : ?>
												<?php foreach ($exemptions as $key => $exemption) { ?>
													<tr>
														<td><?= ++$key ?></td>
														<td>
															<input type="checkbox"
																   name="profile[]"
																   value="<?php echo $exemption->_id->{'$oid'}; ?>"
																   class="checkbox_process_exemp"
															>
															<input type="hidden" id="store_id"
																   value="<?= $exemption->store->id ? $exemption->store->id : '' ?>">
														</td>
														<td><?php if ($exemption->type_send == 1) : ?>
																<span class="label label-success" style="color: white;">GỬI</span>
															<?php elseif ($exemption->type_send == 2) : ?>
																<span class="label label-warning" style="color: white;">TRẢ</span>
															<?php elseif ($exemption->type_send == 3) : ?>
																<span class="label label-danger" style="color: white;">THIẾU</span>
															<?php endif; ?>
															<?= !empty($exemption->code_contract) ? $exemption->code_contract : '' ?>
														</td>
														<td><?= !empty($exemption->code_contract_disbursement) ? $exemption->code_contract_disbursement : '' ?>
															<br>
															<a class="btn btn-info"
															   href="javascript:void(0)"
															   onclick="history_exemption('<?= !empty($exemption->_id->{'$oid'}) ? $exemption->_id->{'$oid'} : "" ?>')">
																Log
															</a>
														</td>
														<td><?= !empty($exemption->customer_name) ? $exemption->customer_name : '' ?></td>
														<td><?= !empty($exemption->customer_phone_number) ? hide_phone($exemption->customer_phone_number) : '' ?></td>
														<td>
															<?php if ($exemption->domain_exemption == 'MB') : ?>
																<span class="label label-success" style="color: white;">Miền Bắc</span>
															<?php elseif ($exemption->domain_exemption == 'MN') : ?>
																<span class="label label-danger" style="color: white;">Miền Nam</span>
															<?php endif; ?>
														</td>
														<td>
															<?= (!empty($exemption->type_payment_exem) && $exemption->type_payment_exem == 1) ? 'Thanh toán kỳ' : 'Tất toán' ?>
															-
															<?= (!empty($exemption->type_exception) && $exemption->type_exception == 1) ? 'Ngoại lệ' : ((!empty($exemption->type_exception) && $exemption->type_exception == 2) ? 'Thanh lý tài sản' : ((!empty($exemption->type_exception) && $exemption->type_exception == 3) ? 'Loại thường' : '')) ?>
														</td>
														<td><?= !empty($exemption->ky_tra) ? $exemption->ky_tra : '' ?></td>
														<td><?= !empty($exemption->amount_tp_thn_suggest) ? number_format($exemption->amount_tp_thn_suggest) : (!empty($exemption->amount_exemptions) ? number_format($exemption->amount_exemptions) : 0) ?></td>
														<td>
															<?php if ($exemption->status_profile == 1) : ?>
																<span class="label label-primary"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 2) : ?>
																<span class="label label-default"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 3) : ?>
																<span class="label label-info"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 4) : ?>
																<span class="label label-success"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 5) : ?>
																<span class="label label-warning"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 6) : ?>
																<span class="label label-warning"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 7) : ?>
																<span class="label label-danger"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 8) : ?>
																<span class="label label-info"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 9) : ?>
																<span class="label label-default"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 10) : ?>
																<span class="label label-default"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php endif; ?>
														</td>
														<td>
															<?= !empty($exemption->confirm_email) ? is_yes_or_no($exemption->confirm_email) : ''; ?>
														</td>
														<td>
															<?php if (in_array($exemption->status_profile, [1, 5, 8])) : ?>
																<select class="choose_is_paper"
																		value="<?= !empty($exemption->is_exemption_paper) ? $exemption->is_exemption_paper : ''; ?>"
																		data-id="<?= !empty($exemption->_id->{'$oid'}) ? $exemption->_id->{'$oid'} : ''; ?>"
																		onchange="change_one_exemption_paper(this)">
																	<?php foreach (is_yes_or_no() as $key2 => $paper) : ?>
																		<option <?= $exemption->is_exemption_paper == $key2 ? 'selected' : ''; ?>
																				value="<?= $key2 ?>"
																				data-id='<?= !empty($exemption->_id->{'$oid'}) ? $exemption->_id->{'$oid'} : '' ?>'>
																			<?= $paper ?>
																		</option>
																	<?php endforeach; ?>
															<?php else : ?>
																<?= !empty($exemption->is_exemption_paper) ? is_yes_or_no($exemption->is_exemption_paper) : ''; ?></select>
															<?php endif; ?>
														</td>
														<td><?= !empty($exemption->is_bbbg_profile) ? is_yes_or_no($exemption->is_bbbg_profile) : ''; ?></td>
														<td><?= !empty($exemption->created_at_profile) ? date("d/m/Y H:i:s", $exemption->created_at_profile) : '' ?></td>
													</tr>
												<?php } ?>
											<?php else : ?>
												<tr style="text-align: center; color: red;">
													<td colspan="13">Không có dữ liệu</td>
												</tr>
											<?php endif; ?>
											</tbody>
										</table>
									</div>
								<?php } ?>
							</div>
							<div role="tabpanel" class="tab-pane fade in <?= ($tab == 'exception') ? 'active' : '' ?>">
								<?php if ($tab == 'exception') { ?>
									<div class="row">
<!--										<div class="col-md-3 col-xs-12">-->
<!--											<select class="form-control" id="choose_option_email">-->
<!--												<option value="0">-- Email đơn miễn giảm --</option>-->
<!--												<option value="1">Có email CEO xác nhận</option>-->
<!--												<option value="2">Không có email CEO xác nhận</option>-->
<!--											</select>-->
<!--										</div>-->
<!--										<div class="col-md-3 col-xs-12">-->
<!--											<a class="btn btn-info fa fa-check"-->
<!--											   onclick="choose_all_email(this)" data-tab="1">-->
<!--												Chọn tất cả-->
<!--											</a>-->
<!--											<a class="btn btn-success"-->
<!--											   onclick="save_is_email(this)" data-tab="1">-->
<!--												<i class="fa fa-save"></i>-->
<!--												&nbsp;Lưu-->
<!--											</a>-->
<!--										</div>-->
										<div class="col-md-3 col-xs-12">
											<select class="form-control" id="choose_option_paper">
												<option value="0">-- Đơn miễn giảm (bản giấy) --</option>
												<option value="1">Có đơn miễn giảm (bản giấy)</option>
												<option value="2">Không có đơn miễn giảm (bản giấy)</option>
											</select>
										</div>
										<div class="col-md-3 col-xs-12">
											<a class="btn btn-info fa fa-check"
											   onclick="choose_all_paper(this)" data-tab="1">
												Chọn tất cả
											</a>
											<a class="btn btn-success"
											   onclick="save_is_paper(this)" data-tab="1">
												<i class="fa fa-save"></i>
												&nbsp;Lưu
											</a>
										</div>
									</div>
									<hr>
									<div>
										<h4>
											<?php if ($result_count != 0) : ?>
												<?php echo "Hiển thị (" . "<span class='text-danger'>$result_count</span>" . ') kết quả' ; ?>
											<?php endif; ?>
										</h4>
									</div>
									<div class="table-responsive" style="overflow-y: auto">
										<table
												class="table table-bordered m-table table-hover table-calendar table-report"
												id="table_exemption">
											<thead style="background:#3f86c3; color: #ffffff;">
											<tr>
												<th style="text-align: center">#</th>
												<th style="text-align: center">
													<input type="checkbox" name="all_exemption"
														   id="select_all_exemption">
												</th>
												<th style="text-align: center">Mã phiếu ghi</th>
												<th style="text-align: center">Mã hợp đồng</th>
												<th style="text-align: center">Tên khách hàng</th>
												<th style="text-align: center">SĐT</th>
												<th style="text-align: center">Khu vực</th>
												<th style="text-align: center">Loại miễn giảm</th>
												<th style="text-align: center">Kỳ miễn giảm</th>
												<th style="text-align: center">Số tiền miễn giảm</th>
												<th style="text-align: center">Trạng thái</th>
												<th style="text-align: center">Email CEO xác nhận</th>
												<th style="text-align: center">Đơn miễn giảm (bản giấy)</th>
												<th style="text-align: center">BBBG HSMG</th>
												<th style="text-align: center">Ngày duyệt phiếu thu</th>
											</tr>
											</thead>
											<tbody>
											<?php if (!empty($exemptions)) : ?>
												<?php foreach ($exemptions as $key => $exemption) { ?>
													<tr>
														<td><?= ++$key ?></td>
														<td>
															<input type="checkbox"
																   name="profile[]"
																   value="<?php echo $exemption->_id->{'$oid'}; ?>"
																   class="checkbox_process_exemp"
															>
															<input type="hidden" id="store_id"
																   value="<?= $exemption->store->id ? $exemption->store->id : '' ?>">
														</td>
														<td><?php if ($exemption->type_send == 1) : ?>
																<span class="label label-success" style="color: white;">GỬI</span>
															<?php elseif ($exemption->type_send == 2) : ?>
																<span class="label label-warning" style="color: white;">TRẢ</span>
															<?php elseif ($exemption->type_send == 3) : ?>
																<span class="label label-danger" style="color: white;">THIẾU</span>
															<?php endif; ?>
															<?= !empty($exemption->code_contract) ? $exemption->code_contract : '' ?>
														</td>
														<td><?= !empty($exemption->code_contract_disbursement) ? $exemption->code_contract_disbursement : '' ?>
															<br>
															<a class="btn btn-info"
															   href="javascript:void(0)"
															   onclick="history_exemption('<?= !empty($exemption->_id->{'$oid'}) ? $exemption->_id->{'$oid'} : "" ?>')">
																Log
															</a>
														</td>
														<td><?= !empty($exemption->customer_name) ? $exemption->customer_name : '' ?></td>
														<td><?= !empty($exemption->customer_phone_number) ? hide_phone($exemption->customer_phone_number) : '' ?></td>
														<td>
															<?php if ($exemption->domain_exemption == 'MB') : ?>
																<span class="label label-success" style="color: white;">Miền Bắc</span>
															<?php elseif ($exemption->domain_exemption == 'MN') : ?>
																<span class="label label-danger" style="color: white;">Miền Nam</span>
															<?php endif; ?>
														</td>
														<td>
															<?= (!empty($exemption->type_payment_exem) && $exemption->type_payment_exem == 1) ? 'Thanh toán kỳ' : 'Tất toán' ?>
															-
															<?= (!empty($exemption->type_exception) && $exemption->type_exception == 1) ? 'Ngoại lệ' : ((!empty($exemption->type_exception) && $exemption->type_exception == 2) ? 'Thanh lý tài sản' : 'Loại thường') ?>
														</td>
														<td><?= !empty($exemption->ky_tra) ? $exemption->ky_tra : '' ?></td>
														<td><?= !empty($exemption->amount_tp_thn_suggest) ? number_format($exemption->amount_tp_thn_suggest) : (!empty($exemption->amount_exemptions) ? number_format($exemption->amount_exemptions) : 0) ?></td>
														<td>
															<?php if ($exemption->status_profile == 1) : ?>
																<span class="label label-primary"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 2) : ?>
																<span class="label label-default"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 3) : ?>
																<span class="label label-info"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 4) : ?>
																<span class="label label-success"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 5) : ?>
																<span class="label label-warning"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 6) : ?>
																<span class="label label-warning"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 7) : ?>
																<span class="label label-danger"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 8) : ?>
																<span class="label label-info"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 9) : ?>
																<span class="label label-default"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 10) : ?>
																<span class="label label-default"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php endif; ?>
														</td>
														<td>
															<?= !empty($exemption->confirm_email) ? is_yes_or_no($exemption->confirm_email) : ''; ?>
														</td>
														<td>
															<?php if (in_array($exemption->status_profile, [1, 5, 8])) : ?>
																<select class="choose_is_paper"
																		value="<?= !empty($exemption->is_exemption_paper) ? $exemption->is_exemption_paper : ''; ?>"
																		data-id="<?= !empty($exemption->_id->{'$oid'}) ? $exemption->_id->{'$oid'} : ''; ?>"
																		onchange="change_one_exemption_paper(this)">
																	<?php foreach (is_yes_or_no() as $key2 => $paper) : ?>
																		<option <?= $exemption->is_exemption_paper == $key2 ? 'selected' : ''; ?>
																				value="<?= $key2 ?>"
																				data-id='<?= !empty($exemption->_id->{'$oid'}) ? $exemption->_id->{'$oid'} : '' ?>'>
																			<?= $paper ?>
																		</option>
																	<?php endforeach; ?>
																</select>
															<?php else : ?>
																<?= !empty($exemption->is_exemption_paper) ? is_yes_or_no($exemption->is_exemption_paper) : ''; ?>
															<?php endif; ?>
														</td>
														<td><?= !empty($exemption->is_bbbg_profile) ? is_yes_or_no($exemption->is_bbbg_profile) : ''; ?></td>
														<td><?= !empty($exemption->created_at_profile) ? date("d/m/Y H:i:s", $exemption->created_at_profile) : '' ?></td>
													</tr>
												<?php } ?>
											<?php else : ?>
												<tr style="text-align: center; color: red;">
													<td colspan="13">Không có dữ liệu</td>
												</tr>
											<?php endif; ?>
											</tbody>
										</table>
									</div>
								<?php } ?>
							</div>
							<div role="tabpanel" class="tab-pane fade in <?= ($tab == 'asset') ? 'active' : '' ?>">
								<?php if ($tab == 'asset') { ?>
									<div class="row">
<!--										<div class="col-md-3 col-xs-12">-->
<!--											<select class="form-control" id="choose_option_email">-->
<!--												<option value="0">-- Email xác nhận --</option>-->
<!--												<option value="1">Có email CEO xác nhận</option>-->
<!--												<option value="2">Không có email CEO xác nhận</option>-->
<!--											</select>-->
<!--										</div>-->
<!--										<div class="col-md-3 col-xs-12">-->
<!--											<a class="btn btn-info fa fa-check"-->
<!--											   onclick="choose_all_email(this)" data-tab="1">-->
<!--												Chọn tất cả-->
<!--											</a>-->
<!--											<a class="btn btn-success"-->
<!--											   onclick="save_is_email(this)" data-tab="1">-->
<!--												<i class="fa fa-save"></i>-->
<!--												&nbsp;Lưu-->
<!--											</a>-->
<!--										</div>-->
										<div class="col-md-3 col-xs-12">
											<select class="form-control" id="choose_option_bbbgx">
												<option value="0">-- Biên bản bàn giao xe --</option>
												<option value="1">Có</option>
												<option value="2">Không có</option>
											</select>
										</div>
										<div class="col-md-3 col-xs-12">
											<a class="btn btn-info fa fa-check"
											   onclick="choose_all_bbbgx(this)" data-tab="1">
												Chọn tất cả
											</a>
											<a class="btn btn-success"
											   onclick="save_is_bbbgx(this)" data-tab="1">
												<i class="fa fa-save"></i>
												&nbsp;Lưu
											</a>
										</div>
									</div>
									<hr>
									<div>
										<h4>
											<?php if ($result_count != 0) : ?>
												<?php echo "Hiển thị (" . "<span class='text-danger'>$result_count</span>" . ') kết quả' ; ?>
											<?php endif; ?>
										</h4>
									</div>
									<div class="table-responsive" style="overflow-y: auto">
										<table
												class="table table-bordered m-table table-hover table-calendar table-report"
												id="table_exemption">
											<thead style="background:#3f86c3; color: #ffffff;">
											<tr>
												<th style="text-align: center">#</th>
												<th style="text-align: center">
													<input type="checkbox" name="all_exemption"
														   id="select_all_exemption">
												</th>
												<th style="text-align: center">Mã phiếu ghi</th>
												<th style="text-align: center">Mã hợp đồng</th>
												<th style="text-align: center">Tên khách hàng</th>
												<th style="text-align: center">SĐT</th>
												<th style="text-align: center">Khu vực</th>
												<th style="text-align: center">Loại miễn giảm</th>
												<th style="text-align: center">Kỳ miễn giảm</th>
												<th style="text-align: center">Số tiền miễn giảm</th>
												<th style="text-align: center">Trạng thái</th>
												<th style="text-align: center">Email CEO xác nhận</th>
												<th style="text-align: center">BBBG xe</th>
												<th style="text-align: center">Đơn miễn giảm (bản giấy)</th>
												<th style="text-align: center">BBBG HSMG</th>
												<th style="text-align: center">Ngày duyệt phiếu thu</th>
												<th style="text-align: center">Người duyệt phiếu thu</th>
											</tr>
											</thead>
											<tbody>
											<?php if (!empty($exemptions)) : ?>
												<?php foreach ($exemptions as $key => $exemption) { ?>
													<tr>
														<td><?= ++$key ?></td>
														<td>
															<input type="checkbox"
																   name="profile[]"
																   value="<?php echo $exemption->_id->{'$oid'}; ?>"
																   class="checkbox_process_exemp"
															>
															<input type="hidden" id="store_id"
																   value="<?= $exemption->store->id ? $exemption->store->id : '' ?>">
														</td>
														<td><?php if ($exemption->type_send == 1) : ?>
																<span class="label label-success" style="color: white;">GỬI</span>
															<?php elseif ($exemption->type_send == 2) : ?>
																<span class="label label-warning" style="color: white;">TRẢ</span>
															<?php elseif ($exemption->type_send == 3) : ?>
																<span class="label label-danger" style="color: white;">THIẾU</span>
															<?php endif; ?>
															<?= !empty($exemption->code_contract) ? $exemption->code_contract : '' ?>
														</td>
														<td><?= !empty($exemption->code_contract_disbursement) ? $exemption->code_contract_disbursement : '' ?>
															<br>
															<a class="btn btn-info"
															   href="javascript:void(0)"
															   onclick="history_exemption('<?= !empty($exemption->_id->{'$oid'}) ? $exemption->_id->{'$oid'} : "" ?>')">
																Log
															</a>
														</td>
														<td><?= !empty($exemption->customer_name) ? $exemption->customer_name : '' ?></td>
														<td><?= !empty($exemption->customer_phone_number) ? hide_phone($exemption->customer_phone_number) : '' ?></td>
														<td>
															<?php if ($exemption->domain_exemption == 'MB') : ?>
																<span class="label label-success" style="color: white;">Miền Bắc</span>
															<?php elseif ($exemption->domain_exemption == 'MN') : ?>
																<span class="label label-danger" style="color: white;">Miền Nam</span>
															<?php endif; ?>
														</td>
														<td>
															<?= (!empty($exemption->type_payment_exem) && $exemption->type_payment_exem == 1) ? 'Thanh toán kỳ' : 'Tất toán' ?>
															-
															<?= (!empty($exemption->type_exception) && $exemption->type_exception == 1) ? 'Ngoại lệ' : ((!empty($exemption->type_exception) && $exemption->type_exception == 2) ? 'Thanh lý tài sản' : 'Loại thường') ?>
														</td>
														<td><?= !empty($exemption->ky_tra) ? $exemption->ky_tra : '' ?></td>
														<td><?= !empty($exemption->amount_tp_thn_suggest) ? number_format($exemption->amount_tp_thn_suggest) : (!empty($exemption->amount_exemptions) ? number_format($exemption->amount_exemptions) : 0) ?></td>
														<td>
															<?php if ($exemption->status_profile == 1) : ?>
																<span class="label label-primary"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 2) : ?>
																<span class="label label-default"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 3) : ?>
																<span class="label label-info"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 4) : ?>
																<span class="label label-success"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 5) : ?>
																<span class="label label-warning"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 6) : ?>
																<span class="label label-warning"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 7) : ?>
																<span class="label label-danger"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 8) : ?>
																<span class="label label-info"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 9) : ?>
																<span class="label label-default"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php elseif ($exemption->status_profile == 10) : ?>
																<span class="label label-default"
																	  style="color: white;"><?= !empty($exemption->status_profile) ? status_exemption_profile($exemption->status_profile) : '' ?></span>
															<?php endif; ?>
														</td>
														<td>
															<?= !empty($exemption->confirm_email) ? is_yes_or_no($exemption->confirm_email) : ''; ?>
														</td>
														<td>
															<?php if (in_array($exemption->status_profile, [1, 5, 8])) : ?>
																<select class="choose_is_bbbgx"
																		value="<?= !empty($exemption->bbbgx) ? $exemption->bbbgx : ''; ?>"
																		data-id="<?= !empty($exemption->_id->{'$oid'}) ? $exemption->_id->{'$oid'} : ''; ?>"
																		onchange="change_one_bbbgx(this)">
																	<?php foreach (is_yes_or_no() as $key3 => $bbbgx) : ?>
																		<option <?= $exemption->bbbgx == $key3 ? 'selected' : ''; ?>
																				value="<?= $key3 ?>"
																				data-id='<?= !empty($exemption->_id->{'$oid'}) ? $exemption->_id->{'$oid'} : '' ?>'>
																			<?= $bbbgx ?>
																		</option>
																	<?php endforeach; ?>
																</select>
															<?php else : ?>
																<?= !empty($exemption->bbbgx) ? is_yes_or_no($exemption->bbbgx) : ''; ?>
															<?php endif; ?>
														</td>
														<td><?= !empty($exemption->is_exemption_paper) ? is_yes_or_no($exemption->is_exemption_paper) : '' ?></td>
														<td><?= !empty($exemption->is_bbbg_profile) ? is_yes_or_no($exemption->is_bbbg_profile) : ''; ?></td>
														<td><?= !empty($exemption->created_at_profile) ? date("d/m/Y H:i:s", $exemption->created_at_profile) : '' ?></td>
														<td><?= !empty($exemption->created_by_profile) ?  $exemption->created_by_profile : '' ?></td>
													</tr>
												<?php } ?>
											<?php else : ?>
												<tr style="text-align: center; color: red;">
													<td colspan="14">Không có dữ liệu</td>
												</tr>
											<?php endif; ?>
											</tbody>
										</table>
									</div>
								<?php } ?>
							</div>
							<div role="tabpanel" class="tab-pane fade in <?= ($tab == 'profile_normal') ? 'active' : '' ?>">
								<?php if ($tab == 'profile_normal') { ?>
									<div>
										<h4>
											<?php if ($result_count != 0) : ?>
												<?php echo "Hiển thị (" . "<span class='text-danger'>$result_count</span>" . ') kết quả' ; ?>
											<?php endif; ?>
										</h4>
									</div>
									<div class="table-responsive" style="overflow-y: auto">
										<table
												class="table table-bordered m-table table-hover table-calendar table-report ">
											<thead style="background:#3f86c3; color: #ffffff;">
											<tr>
												<th style="text-align: center">#</th>
												<th style="text-align: center">Thao tác</th>
												<th style="text-align: center">Mã hồ sơ</th>
												<th style="text-align: center">Mã bưu phẩm</th>
												<th style="text-align: center">BBBG</th>
												<th style="text-align: center">Bên bàn giao</th>
												<th style="text-align: center">Bên nhận bàn giao</th>
												<th style="text-align: center">Trạng thái</th>
												<th style="text-align: center">Tháng bàn giao</th>
												<th style="text-align: center">Ngày tạo</th>
												<th style="text-align: center">Người tạo</th>
											</tr>
											</thead>
											<tbody>
											<?php if (!empty($profiles)) : ?>
												<?php foreach ($profiles as $key => $prof) { ?>
													<tr>
														<td><?= ++$key; ?></td>
														<td>
															<div class="dropdown">
																<button class="btn btn-secondary dropdown-toggle"
																		type="button" id="dropdownMenuButton"
																		data-toggle="dropdown"
																		aria-haspopup="true"
																		aria-expanded="false"
																		style="text-align: center; background-color: #5bc0de; color: white">
																	Chức năng
																	<span class="caret"></span></button>
																<ul class="dropdown-menu"
																	style="z-index: 99999;">
																	<li>
																		<a href="<?php echo base_url('Exemptions/detail_profile?code=' . $prof->code_ref) ?>"
																		   class="fa fa-info-circle"
																		   target="_blank"
																		> Xem chi tiết
																		</a>
																	</li>
																	<?php
																	if ($value->status == 11) { ?>
																		<li>
																			<a class="dropdown-item"
																			   href="<?php echo base_url('transaction/sendApprove?id=' . $value->_id->{'$oid'}); ?>">
																				Gửi duyệt lại
																			</a>
																		</li>
																	<?php } ?>

																	<?php
																	if (($thn_role && $prof->status == 2) || ($kt_role && $prof->status == 9)) {
																		?>
																		<li>
																			<a href="<?php echo base_url("Exemptions/upload_img?code=" . $prof->code_ref); ?>"
																			   class="dropdown-item fa fa-paper-plane"
																			   target="_blank"> Gửi hồ sơ
																			</a>
																		</li>
																	<?php } ?>
																	<?php
																	if (($kt_role && $prof->status == 3)) {
																		?>
																		<li>
																			<a href="javascript:void(0)"
																			   onclick="kt_complete_profile(this)"
																			   data-coderef="<?= !empty($prof->code_ref) ? $prof->code_ref : '' ?>"
																			   class="dropdown-item fa fa-check"> Hoàn
																				tất hồ sơ
																			</a>
																		</li>
																	<?php } ?>
																	<li>
																		<a href="<?php echo base_url("Exemptions/view_img?code=" . $prof->code_ref); ?>"
																		   class="dropdown-item fa fa-eye"
																		   target="_blank"> Xem chứng từ
																		</a>
																	</li>
																</ul>
														</td>
														<td><?= !empty($prof->code_ref) ? $prof->code_ref : ""; ?>
															<br>
															<a class="btn btn-info"
															   href="javascript:void(0)"
															   onclick="history_profile('<?= !empty($prof->_id->{'$oid'}) ? $prof->_id->{'$oid'} : "" ?>')">
																Log
															</a>

														</td>
														<td><?= !empty($prof->postal_code) ? $prof->postal_code : "-"; ?></td>
														<td style="text-align: center">
															<?= !empty($prof->profile_name) ? $prof->profile_name : ""; ?>
															<br>
															<?php if (($thn_role && $prof->status == 2) || ($kt_role && $prof->status == 9)) : ?>
																<a href="<?php echo base_url("Exemptions/printed_profile_exemption/" . $prof->code_ref) ?>"
																   class="btn btn-primary fa fa-print"
																   target="_blank">
																	In BBBG
																</a>
															<?php endif; ?>
														</td>
														<td><?= !empty($prof->position_user_send) ? $prof->position_user_send : ""; ?></td>
														<td><?= !empty($prof->position_user_receive) ? $prof->position_user_receive : ""; ?></td>
														<td>
															<?php if ($prof->status == 1) : ?>
																<span class="label label-primary"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php elseif ($prof->status == 2) : ?>
																<span class="label label-default"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php elseif ($prof->status == 3) : ?>
																<span class="label label-info"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php elseif ($prof->status == 4) : ?>
																<span class="label label-success"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php elseif ($prof->status == 5) : ?>
																<span class="label label-warning"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php elseif ($prof->status == 6) : ?>
																<span class="label label-warning"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php elseif ($prof->status == 7) : ?>
																<span class="label label-danger"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php elseif ($prof->status == 8) : ?>
																<span class="label label-info"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php elseif ($prof->status == 9) : ?>
																<span class="label label-default"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php elseif ($prof->status == 10) : ?>
																<span class="label label-default"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php endif; ?>
														</td>
														<td><?= !empty($prof->month) ? $prof->month : ""; ?></td>
														<td><?php echo !empty($prof->created_at) ? date('d/m/Y H:i:s', $prof->created_at) : "" ?></td>
														<td><?php echo !empty($prof->created_by) ? $prof->created_by : "" ?></td>
													</tr>
												<?php } ?>
											<?php else : ?>
												<tr style="text-align: center; color: red;">
													<td colspan="13">Không có dữ liệu</td>
												</tr>
											<?php endif; ?>
											</tbody>
										</table>
									</div>
									<div>
										<nav class="text-right">
											<?php echo $pagination ?>
										</nav>
									</div>
								<?php } ?>
							</div>
							<div role="tabpanel" class="tab-pane fade in <?= ($tab == 'profile_exception') ? 'active' : '' ?>">
								<?php if ($tab == 'profile_exception') { ?>
									<div>
										<h4>
											<?php if ($result_count != 0) : ?>
												<?php echo "Hiển thị (" . "<span class='text-danger'>$result_count</span>" . ') kết quả' ; ?>
											<?php endif; ?>
										</h4>
									</div>
									<div class="table-responsive" style="overflow-y: auto">
										<table
												class="table table-bordered m-table table-hover table-calendar table-report ">
											<thead style="background:#3f86c3; color: #ffffff;">
											<tr>
												<th style="text-align: center">#</th>
												<th style="text-align: center">Thao tác</th>
												<th style="text-align: center">Mã hồ sơ</th>
												<th style="text-align: center">Mã bưu phẩm</th>
												<th style="text-align: center">BBBG</th>
												<th style="text-align: center">Bên bàn giao</th>
												<th style="text-align: center">Bên nhận bàn giao</th>
												<th style="text-align: center">Trạng thái</th>
												<th style="text-align: center">Tháng bàn giao</th>
												<th style="text-align: center">Ngày tạo</th>
												<th style="text-align: center">Người tạo</th>
											</tr>
											</thead>
											<tbody>
											<?php if (!empty($profiles)) : ?>
												<?php foreach ($profiles as $key => $prof) { ?>
													<tr>
														<td><?= ++$key; ?></td>
														<td>
															<div class="dropdown">
																<button class="btn btn-secondary dropdown-toggle"
																		type="button" id="dropdownMenuButton"
																		data-toggle="dropdown"
																		aria-haspopup="true"
																		aria-expanded="false"
																		style="text-align: center; background-color: #5bc0de; color: white">
																	Chức năng
																	<span class="caret"></span></button>
																<ul class="dropdown-menu"
																	style="z-index: 99999;">
																	<li>
																		<a href="<?php echo base_url('Exemptions/detail_profile?code=' . $prof->code_ref) ?>"
																		   class="fa fa-info-circle"
																		   target="_blank"
																		> Xem chi tiết
																		</a>
																	</li>
																	<?php
																	if ($value->status == 11) { ?>
																		<li>
																			<a class="dropdown-item"
																			   href="<?php echo base_url('transaction/sendApprove?id=' . $value->_id->{'$oid'}); ?>">
																				Gửi duyệt lại
																			</a>
																		</li>
																	<?php } ?>

																	<?php
																	if (($thn_role && $prof->status == 2) || ($kt_role && $prof->status == 9)) {
																		?>
																		<li>
																			<a href="<?php echo base_url("Exemptions/upload_img?code=" . $prof->code_ref); ?>"
																			   class="dropdown-item fa fa-paper-plane"
																			   target="_blank"> Gửi hồ sơ
																			</a>
																		</li>
																	<?php } ?>
																	<?php
																	if (($kt_role && $prof->status == 3)) {
																		?>
																		<li>
																			<a href="javascript:void(0)"
																			   onclick="kt_complete_profile(this)"
																			   data-coderef="<?= !empty($prof->code_ref) ? $prof->code_ref : '' ?>"
																			   class="dropdown-item fa fa-check"> Hoàn
																				tất hồ sơ
																			</a>
																		</li>
																	<?php } ?>
																	<li>
																		<a href="<?php echo base_url("Exemptions/view_img?code=" . $prof->code_ref); ?>"
																		   class="dropdown-item fa fa-eye"
																		   target="_blank"> Xem chứng từ
																		</a>
																	</li>
																</ul>
														</td>
														<td><?= !empty($prof->code_ref) ? $prof->code_ref : ""; ?>
															<br>
															<a class="btn btn-info"
															   href="javascript:void(0)"
															   onclick="history_profile('<?= !empty($prof->_id->{'$oid'}) ? $prof->_id->{'$oid'} : "" ?>')">
																Log
															</a>

														</td>
														<td><?= !empty($prof->postal_code) ? $prof->postal_code : "-"; ?></td>
														<td style="text-align: center">
															<?= !empty($prof->profile_name) ? $prof->profile_name : ""; ?>
															<br>
															<?php if (($thn_role && $prof->status == 2) || ($kt_role && $prof->status == 9)) : ?>
																<a href="<?php echo base_url("Exemptions/printed_profile_exemption/" . $prof->code_ref) ?>"
																   class="btn btn-primary fa fa-print"
																   target="_blank">
																	In BBBG
																</a>
															<?php endif; ?>
														</td>
														<td><?= !empty($prof->position_user_send) ? $prof->position_user_send : ""; ?></td>
														<td><?= !empty($prof->position_user_receive) ? $prof->position_user_receive : ""; ?></td>
														<td>
															<?php if ($prof->status == 1) : ?>
																<span class="label label-primary"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php elseif ($prof->status == 2) : ?>
																<span class="label label-default"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php elseif ($prof->status == 3) : ?>
																<span class="label label-info"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php elseif ($prof->status == 4) : ?>
																<span class="label label-success"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php elseif ($prof->status == 5) : ?>
																<span class="label label-warning"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php elseif ($prof->status == 6) : ?>
																<span class="label label-warning"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php elseif ($prof->status == 7) : ?>
																<span class="label label-danger"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php elseif ($prof->status == 8) : ?>
																<span class="label label-info"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php elseif ($prof->status == 9) : ?>
																<span class="label label-default"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php elseif ($prof->status == 10) : ?>
																<span class="label label-default"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php endif; ?>
														</td>
														<td><?= !empty($prof->month) ? $prof->month : ""; ?></td>
														<td><?php echo !empty($prof->created_at) ? date('d/m/Y H:i:s', $prof->created_at) : "" ?></td>
														<td><?php echo !empty($prof->created_by) ? $prof->created_by : "" ?></td>
													</tr>
												<?php } ?>
											<?php else : ?>
												<tr style="text-align: center; color: red;">
													<td colspan="13">Không có dữ liệu</td>
												</tr>
											<?php endif; ?>
											</tbody>
										</table>
									</div>
									<div>
										<nav class="text-right">
											<?php echo $pagination ?>
										</nav>
									</div>
								<?php } ?>
							</div>
							<div role="tabpanel" class="tab-pane fade in <?= ($tab == 'profile_asset') ? 'active' : '' ?>">
								<?php if ($tab == 'profile_asset') { ?>
									<div>
										<h4>
											<?php if ($result_count != 0) : ?>
												<?php echo "Hiển thị (" . "<span class='text-danger'>$result_count</span>" . ') kết quả' ; ?>
											<?php endif; ?>
										</h4>
									</div>
									<div class="table-responsive" style="overflow-y: auto">
										<table
												class="table table-bordered m-table table-hover table-calendar table-report ">
											<thead style="background:#3f86c3; color: #ffffff;">
											<tr>
												<th style="text-align: center">#</th>
												<th style="text-align: center">Thao tác</th>
												<th style="text-align: center">Mã hồ sơ</th>
												<th style="text-align: center">Mã bưu phẩm</th>
												<th style="text-align: center">BBBG</th>
												<th style="text-align: center">Bên bàn giao</th>
												<th style="text-align: center">Bên nhận bàn giao</th>
												<th style="text-align: center">Trạng thái</th>
												<th style="text-align: center">Tháng bàn giao</th>
												<th style="text-align: center">Ngày tạo</th>
												<th style="text-align: center">Người tạo</th>
											</tr>
											</thead>
											<tbody>
											<?php if (!empty($profiles)) : ?>
												<?php foreach ($profiles as $key => $prof) { ?>
													<tr>
														<td><?= ++$key; ?></td>
														<td>
															<div class="dropdown">
																<button class="btn btn-secondary dropdown-toggle"
																		type="button" id="dropdownMenuButton"
																		data-toggle="dropdown"
																		aria-haspopup="true"
																		aria-expanded="false"
																		style="text-align: center; background-color: #5bc0de; color: white">
																	Chức năng
																	<span class="caret"></span></button>
																<ul class="dropdown-menu"
																	style="z-index: 99999;">
																	<li>
																		<a href="<?php echo base_url('Exemptions/detail_profile?code=' . $prof->code_ref) ?>"
																		   class="fa fa-info-circle"
																		   target="_blank"
																		> Xem chi tiết
																		</a>
																	</li>
																	<?php
																	if ($value->status == 11) { ?>
																		<li>
																			<a class="dropdown-item"
																			   href="<?php echo base_url('transaction/sendApprove?id=' . $value->_id->{'$oid'}); ?>">
																				Gửi duyệt lại
																			</a>
																		</li>
																	<?php } ?>

																	<?php
																	if (($thn_role && $prof->status == 2) || ($kt_role && $prof->status == 9)) {
																		?>
																		<li>
																			<a href="<?php echo base_url("Exemptions/upload_img?code=" . $prof->code_ref); ?>"
																			   class="dropdown-item fa fa-paper-plane"
																			   target="_blank"> Gửi hồ sơ
																			</a>
																		</li>
																	<?php } ?>
																	<?php
																	if (($kt_role && $prof->status == 3)) {
																		?>
																		<li>
																			<a href="javascript:void(0)"
																			   onclick="kt_complete_profile(this)"
																			   data-coderef="<?= !empty($prof->code_ref) ? $prof->code_ref : '' ?>"
																			   class="dropdown-item fa fa-check">
																				Hoàn tất hồ sơ
																			</a>
																		</li>
																	<?php } ?>
																	<li>
																		<a href="<?php echo base_url("Exemptions/view_img?code=" . $prof->code_ref); ?>"
																		   class="dropdown-item fa fa-eye"
																		   target="_blank"> Xem chứng từ
																		</a>
																	</li>
																</ul>
														</td>
														<td><?= !empty($prof->code_ref) ? $prof->code_ref : ""; ?>
															<br>
															<a class="btn btn-info"
															   href="javascript:void(0)"
															   onclick="history_profile('<?= !empty($prof->_id->{'$oid'}) ? $prof->_id->{'$oid'} : "" ?>')">
																Log
															</a>

														</td>
														<td><?= !empty($prof->postal_code) ? $prof->postal_code : "-"; ?></td>
														<td style="text-align: center">
															<?= !empty($prof->profile_name) ? $prof->profile_name : ""; ?>
															<br>
															<?php if (($thn_role && $prof->status == 2) || ($kt_role && $prof->status == 9)) : ?>
																<a href="<?php echo base_url("Exemptions/printed_profile_exemption/" . $prof->code_ref) ?>"
																   class="btn btn-primary fa fa-print"
																   target="_blank">
																	In BBBG
																</a>
															<?php endif; ?>
														</td>
														<td><?= !empty($prof->position_user_send) ? $prof->position_user_send : ""; ?></td>
														<td><?= !empty($prof->position_user_receive) ? $prof->position_user_receive : ""; ?></td>
														<td>
															<?php if ($prof->status == 1) : ?>
																<span class="label label-info"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php elseif ($prof->status == 2) : ?>
																<span class="label label-default"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php elseif ($prof->status == 3) : ?>
																<span class="label label-info"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php elseif ($prof->status == 4) : ?>
																<span class="label label-success"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php elseif ($prof->status == 5) : ?>
																<span class="label label-warning"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php elseif ($prof->status == 6) : ?>
																<span class="label label-warning"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php elseif ($prof->status == 7) : ?>
																<span class="label label-warning"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php elseif ($prof->status == 8) : ?>
																<span class="label label-info"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php elseif ($prof->status == 9) : ?>
																<span class="label label-info"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php elseif ($prof->status == 10) : ?>
																<span class="label label-default"
																	  style="color: white;"><?= !empty($prof->status) ? status_exemption_profile($prof->status) : '' ?></span>
															<?php endif;; ?>
														</td>
														<td><?= !empty($prof->month) ? $prof->month : ""; ?></td>
														<td><?php echo !empty($prof->created_at) ? date('d/m/Y H:i:s', $prof->created_at) : "" ?></td>
														<td><?php echo !empty($prof->created_by) ? $prof->created_by : "" ?></td>
													</tr>
												<?php } ?>
											<?php else : ?>
												<tr style="text-align: center; color: red;">
													<td colspan="13">Không có dữ liệu</td>
												</tr>
											<?php endif; ?>
											</tbody>
										</table>
									</div>
									<div>
										<nav class="text-right">
											<?php echo $pagination ?>
										</nav>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--Modal Hoàn tất hồ sơ miễn giảm-->
<div class="modal fade" id="complete_profile_exemption" tabindex="-1" role="dialog" aria-labelledby="TransactionModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title modal-title-approve">Hoàn tất hồ sơ miễn giảm</h5>
				<hr>
				<div class="form-group">
					<label>Ghi chú:</label>
					<textarea class="form-control complete_note" rows="5"></textarea>
					<input type="hidden" class="form-control status_complete" value="4">
					<input type="hidden" class="form-control" id="code_ref">
				</div>
				<p class="text-right">
					<button class="btn btn-danger" id="complete_profile_exemptions">Xác nhận</button>
				</p>
			</div>

		</div>
	</div>
</div>

<!--Modal Lịch sử xử lý đơn miễn giảm con-->
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

<!--Modal Lịch sử xử lý hồ sơ miễn giảm cha-->
<div class="modal fade" id="profile_log_modal" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" style="width: 70%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center">Lịch sử xử lý hồ sơ miễn giảm</h3>
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
									<th>Tên hồ sơ</th>
									<th>Trạng thái</th>
									<th>Ghi chú</th>
									<th>Thay đổi khác</th>
								</tr>
								</thead>
								<tbody id="tbody_profile_log">

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<!-- /page content -->
<?php endif ; ?>
<script>
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

</script>
<script src="<?php echo base_url() ?>assets/js/examptions/index.js"></script>

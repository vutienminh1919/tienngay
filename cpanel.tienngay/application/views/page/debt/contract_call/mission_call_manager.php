<!-- page content -->
<style>
	a.link-caller:hover {
		color: blue;
	}
</style>
<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	?>
	<div class="row top_tiles">
		<div class="col-xs-12">
			<?php if ($this->session->flashdata('error')) { ?>
				<div class="alert alert-danger alert-result">
					<?= $this->session->flashdata('error') ?>
				</div>
			<?php } ?>
			<?php if ($this->session->flashdata('success')) { ?>
				<div class="alert alert-success alert-result">
					<?= $this->session->flashdata('success') ?>
				</div>
			<?php } ?>
		</div>
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>QUẢN LÝ CALL</h3>
				</div>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<div class="row">
						<div class="col-xs-12 col-md-6">
							<h2>TỔNG HỢP</h2>
							<i>(Các hợp đồng thuộc nhóm B0, B1)</i>
						</div>
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
										<form action="<?php echo base_url('DebtCall/mission_caller') ?>" method="get"
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
													<label>&nbsp;</label> <br>
													<button class="btn btn-primary w-100">Tìm kiếm</button>
												</div>
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
					<div class="clearfix"></div>
					<div class="table-responsive">
						<table id="summary-total"
							   class="table table-bordered m-table table-hover table-calendar table-report">
							<thead style="background:#3f86c3; color: #ffffff;">
							<tr>
								<th>Nhân viên</th>
								<th>Số hợp đồng tương ứng</th>
								<th>Gốc còn lại</th>
								<th>Số hợp đồng đã tác động</th>
								<th>Tổng số cuộc gọi</th>
							</tr>
							</thead>
							<tbody>
							<tr style="background: #8DEEEE; font-weight: bold">
								<td>Tổng</td>
								<td><?= !empty($tong_hop_dong_giao) ? $tong_hop_dong_giao : 0; ?></td>
								<td><?= !empty($tong_du_no_goc_con_lai) ? number_format($tong_du_no_goc_con_lai) . " đ" : 0; ?></td>
								<td><?= !empty($tong_hop_dong_da_tac_dong) ? $tong_hop_dong_da_tac_dong : 0; ?></td>
								<td><?= !empty($tong_so_cuoc_goi) ? $tong_so_cuoc_goi : 0; ?></td>
							</tr>
							<?php
							if (!empty($dataMissionCaller)) :
								foreach ($dataMissionCaller as $key => $caller) :
									?>
									<tr>
										<td style="font-weight: bold"><?= !empty($caller->user_name) ? $caller->user_name : ''; ?></td>
										<td style="font-weight: bold"><?= !empty($caller->tong_hop_dong_giao) ? $caller->tong_hop_dong_giao : 0; ?></td>
										<td style="font-weight: bold"><?= !empty($caller->du_no_goc_con_lai) ? number_format($caller->du_no_goc_con_lai) . " đ" : 0 ?></td>
										<td style="font-weight: bold"><?= !empty($caller->tong_hop_dong_da_tac_dong) ? $caller->tong_hop_dong_da_tac_dong : 0; ?></td>
										<td style="font-weight: bold"><?= !empty($caller->tong_so_cuoc_goi) ? $caller->tong_so_cuoc_goi : 0 ?></td>
									</tr>
								<?php
								endforeach;
							endif; ?>
							</tbody>
						</table>
					</div>
					<br>

					<div class="" role="tabpanel" data-example-id="togglable-tabs">
						<ul id="myTab" class="nav nav-pills" role="tablist">
							<li role="presentation" class="active"><a href="#tab_content8" role="tab" id="tab008"
																data-toggle="tab" aria-expanded="false">Danh sách Call
									phụ trách</a>
							</li>
							<li role="presentation" class=""><a href="#tab_content9" role="tab" id="tab009"
																data-toggle="tab" aria-expanded="false">Setup thời gian
									chuyển Field</a>
							</li>
						</ul>
						<div id="myTabContent" class="tab-content">
							<div role="tabpanel" class="tab-pane fade active in" id="tab_content8"
								 aria-labelledby="tab008">
								<br>
								<div class="table-responsive" style="overflow-y: auto">
									<table class="table table-bordered m-table table-hover table-calendar table-report ">
										<thead style="background:#3f86c3; color: #ffffff;">
										<tr>
											<th>STT</th>
											<th>Nhân viên</th>
											<th>PGD phụ trách</th>
											<th>Số hợp đồng tương ứng</th>
											<th>Chức năng</th>
										</tr>
										</thead>
										<tbody>
										<?php
										if (!empty($dataMissionCaller)) :
											foreach ($dataMissionCaller as $key => $caller) { ?>
												<tr>
													<td><?= ++$key; ?></td>
													<td><?= !empty($caller->user_name) ? $caller->user_name : ''; ?></td>
													<td>
														<?php foreach ($caller as $key1 => $call) {
															foreach ((array)$call as $key2 => $ca) {
																if ($key2 == 0) continue;
																echo $key2 . '<br>';
															}
														} ?>
													</td>
													<td>
														<?php foreach ($caller as $key1 => $call) {
															foreach ((array)$call as $key2 => $ca) {
																if ($key2 == 0) continue;
																if (count($ca) < 10) {
																	if (isset($ca)) {
																		echo '<a style="color: #0ba1b5;text-decoration: underline;" 
																	href="' . base_url('DebtCall/list_contract_call?store=') . $key1 . '&email_call=' . $ca[0]->debt_caller_email . '" 
																	class="link" 
														  			target="_blank" 
														   			data-toggle="tooltip"
														   			title="Click để xem chi tiết">' . '0' . count($ca) . ' hợp đồng' . '</a>' . '<br>';
																	} else {
																		echo " - ";
																	}

																} else {

																	if (isset($ca)) {
																		echo '<a style="color: #0ba1b5;text-decoration: underline;" 
																	href="' . base_url('DebtCall/list_contract_call?store=') . $key1 . '&email_call=' . $ca[0]->debt_caller_email . '" 
																	class="link" 
														   			target="_blank" 
														   			data-toggle="tooltip"
														   			title="Click để xem chi tiết">' . count($ca) . ' hợp đồng' . '</a>' . '<br>';
																	} else {
																		echo " - ";
																	}
																}
															}
														} ?>
													</td>
													<td></td>
												</tr>
											<?php } ?>
										<?php endif; ?>
										</tbody>
									</table>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane fade" id="tab_content9" aria-labelledby="tab009">
								<div class="detail-contract" role="main">
									<div class="clearfix"></div>
									<br>
									<br>
								</div>
								<div class="row">
									<div class="col-md-12 col-xs-12">
										<div class="x_panel">
											<div class="x_content">
												<div class="col-md-12 col-xs-12 nopadding">
													<div class="col-md-6 col-xs-12 setup-time-title">
														<h4 class="box__title"
															style="color: black;">THÔNG TIN SETUP THỜI GIAN CHUYỂN FIELD
														</h4>
													</div>
													<div class="col-md-3 col-xs-12">&nbsp;</div>
													<div class="col-md-3 col-xs-12 text-right">
<!--														<button class="btn btn-info" onclick="set_field(this)">Setup-->
<!--															Time chuyển Field-->
<!--														</button>-->
														<button class="btn btn-info" onclick="set_field(this)">Cập nhật</button>
													</div>
													<div class="col-md-12 col-xs-12">&nbsp;</div>
													<div class="col-md-12 col-xs-12">&nbsp;</div>
													<div class="col-md-12 col-xs-12">&nbsp;</div>
													<div class="col-md-6 col-xs-12 text-left"
														 style="padding-left: 60px;">
														<p style="color: black;">Thời gian bắt đầu: <?= !empty($start_time) ? date('d/m/Y H:i:s', $start_time) : '' ; ?></p>
														<br>
														<br>
														<p style="color: black;">Thời gian kết thúc: <?= !empty($end_time) ? date('d/m/Y H:i:s', $end_time) : '' ; ?></p>
													</div>
													<div class="col-md-12 col-xs-12">&nbsp;</div>
													<div class="col-md-12 col-xs-12">&nbsp;</div>
													<div class="col-md-12 col-xs-12">
														<h4 class="box__title" style="color: black;">
															Lịch sử update
														</h4>
													</div>
													<div class="col-md-12 col-xs-12">
														<ul class="list-unstyled timeline">
															<?php if (!empty($log_time_to_field)): ?>
																<?php foreach ($log_time_to_field as $item): ?>
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
																					<p><?= !empty($item->created_at) ? date("d/m/Y H:i:s", $item->created_at) : "" ?> - <?= !empty($item->created_by) ? $item->created_by : '' ?></p>
																					<p>
																						<?= !empty($item->old->start_time) ? date('d/m/Y', $item->old->start_time) : 'Setup mới'; ?> - <?= !empty($item->old->end_time) ? date('d/m/Y', $item->old->end_time) : 'Setup mới'; ?>
																						&nbsp;&nbsp;&nbsp; => &nbsp;&nbsp;&nbsp; <?= !empty($item->new->start_time) ? date('d/m/Y', $item->new->start_time) : ''; ?> - <?= !empty($item->new->end_time) ? date('d/m/Y', $item->new->end_time) : ''; ?>
																					</p>
																				</div>
																			</div>
																		</div>
																	</li>
																<?php endforeach; ?>
															<?php else : ?>
																<li style="text-align: center">
																	<p style="color: black; text-align: center;">
																		Không có dữ liệu setup thời gian chuyển Field</p>
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

							<!--Modal Lead THN approve-->

							<div id='toTop'>
								<i class="fa fa-arrow-circle-up"></i>
							</div>


						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
</div>

<!-- Modal Setup time chuyển Field HĐ-->
<div class="modal fade" id="time_to_field_modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<input type="hidden" name="contract_id" class="contract_id" value="">
				<h5 class="modal-title title_modal_contract_v2" style="color: black;">
					Setup thời gian chuyển Field cho hợp đồng vay
				</h5>
				<hr>
				<div class="row">
					<div class="col-md-8 col-xs-12" style="">
						<label class="control-label" style="color: black; font-weight: unset; margin-left: 20px;">
							Thời gian bắt đầu <span class="text-danger">*</span>
						</label>
						<input type="date"
							   name="start_time"
							   id="start_time"
							   required style="color: black; padding-left: 10px; margin-left: 30px;">
						<p class="messages"></p>
					</div>
					<div class="col-md-4 col-xs-12" style=""></div>
					<div class="col-md-8 col-xs-12" style="">
						<label class="control-label" style="color: black; font-weight: unset; margin-left: 20px;">
							Thời gian kết thúc <span class="text-danger">*</span>
						</label>
						<input type="date"
							   name="end_time"
							   id="end_time"
							   required style="color: black; margin-left: 27px;padding-left: 10px;">
						<p class="messages"></p>
					</div>
					<div class="col-md-4 col-xs-12" style=""></div>
					<div class="col-md-6 col-xs-12" style="">&nbsp;</div>
					<div class="col-md-4 col-xs-12" style="">&nbsp;</div>
					<div class="col-md-1 col-xs-12" style="">
						<button id="confirm_setup_time" class="btn btn-success" style="border-radius: 20px; font-size: 12px !important;">Xác nhận</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function () {
			$('#detail-total').hide();
			$('.show-hide-total-all').on('click', function () {
				$('#detail-total').show();
				$('#summary-total').hide();
			});
			$('.show-hide-total-top-ten').on('click', function () {
				$('#detail-total').hide();
				$('#summary-total').show();
			});

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
	<script src="<?php echo base_url("assets/") ?>js/jquery-ui.js"></script>
	<script src="<?php echo base_url("assets/") ?>js/numeral.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/debt/debt_call.js"></script>
	<script>
		$('#selectize_store').selectize({
			create: false,
			valueField: 'code_address_store',
			labelField: 'name',
			searchField: 'name',
			maxItems: 100,
			sortField: {
				field: 'name',
				direction: 'asc'
			}
		});
	</script>

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








<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$store_search = !empty($_GET['store_search']) ? $_GET['store_search'] : "";
	$status_pgd = !empty($_GET['status_pgd']) ? $_GET['status_pgd'] : "";
	?>

	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>BÁO CÁO ĐO THỜI GIAN XỬ LÝ LEAD PGD</h3>
				</div>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-xs-12">
							<?php if ($this->session->flashdata('error')) { ?>
								<div class="alert alert-danger alert-result">
									<?= $this->session->flashdata('error') ?>
								</div>
							<?php } ?>
							<?php if ($this->session->flashdata('success')) { ?>
								<div
									class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
							<?php } ?>
							<div class="row">
								<form action="<?php echo base_url('report_telesale/index_report_inhouse') ?>"
									  method="get"
									  style="width: 100%;">
									<div class="col-xs-12">
										<div class="row">
											<div class="col-xs-12 col-lg-2">
												<div class="form-group">
													<label>Từ</label>
													<input type="date" name="fdate" class="form-control"
														   value="<?= !empty($fdate) ? $fdate : "" ?>">
												</div>
											</div>
											<div class="col-xs-12 col-lg-2">
												<div class="form-group">
													<label>Đến</label>
													<input type="date" name="tdate" class="form-control"
														   value="<?= !empty($tdate) ? $tdate : "" ?>">
												</div>
											</div>
											<div class="col-xs-12 col-lg-2 ">
												<label>&nbsp;</label>
												<select class="form-control" name="store_search">
													<option value="">Chọn PGD</option>
													<?php foreach ($stores as $store) : ?>
														<option
															value="<?php echo $store->_id->{'$oid'}; ?>" <?= ($store_search == $store->_id->{'$oid'}) ? 'selected' : '' ?>><?php echo $store->name; ?></option>
													<?php endforeach; ?>

												</select>
											</div>
											<div class="col-xs-12 col-lg-2 ">
												<label>&nbsp;</label>
												<select class="form-control" name="status_pgd">
													<option value="">Chọn trạng thái lead PGD</option>
													<?php foreach (status_pgd() as $key => $stt_pgd) { ?>
														<option <?php echo $status_pgd == $key ? 'selected' : '' ?>
															value="<?php echo $key ?>"><?php echo $stt_pgd ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-xs-12 col-lg-2">
												<label>&nbsp;</label>
												<button type="submit" class="btn btn-primary w-100"><i
														class="fa fa-search"
														aria-hidden="true"></i> <?= $this->lang->line('search') ?>
												</button>
											</div>
											<div class="col-xs-12 col-lg-2 ">
												<label for="">&nbsp;</label>
												<a target="_blank" type="button" class="btn btn-primary w-100" href="<?= base_url() ?>excel/exportExcelReportTelesale?fdate=<?= $fdate . '&tdate=' . $tdate . '&store_search=' . $store_search . '&status_pgd=' . $status_pgd  ?>" >
													<span class="fa fa-file-excel-o" style="color: white"> Xuất excel </span>
												</a>
											</div>


										</div>
									</div>
								</form>
								<br>
							</div>
						</div>
					</div>
				</div>
				<div class="x_content">
					<h4>Tổng số: <?= !empty($count) ? number_format($count) : 0 ?></h4>
					<div class="table-responsive">
						<table id="summary-total"
							   class="table table-bordered m-table table-hover table-calendar table-report"
							   style="font-size: 14px;font-weight: 400;">
							<thead style="background:#5A738E; color: #ffffff;">
							<tr>
								<th style="text-align: center">STT</th>
								<th style="text-align: center">THAO TÁC</th>
								<th style="text-align: center">NGÀY THÁNG</th>
								<th style="text-align: center">CVKD</th>
								<th style="text-align: center">HỌ VÀ TÊN</th>
								<th style="text-align: center">SỐ ĐIỆN THOẠI</th>
								<th style="text-align: center">CHUYỂN ĐẾN PGD</th>
								<th style="text-align: center">TRẠNG THÁI PGD</th>
								<th style="text-align: center">TÌNH TRẠNG LEAD</th>
								<th style="text-align: center">TRẠNG THÁI HĐGN</th>
								<th style="text-align: center">SỐ TIỀN GN</th>
								<th style="text-align: center">NGUỒN</th>
								<th style="text-align: center">UTM_SOURCE</th>
								<th style="text-align: center">UTM_CAMPAIGN</th>
								<th style="text-align: center">VỊ TRÍ/CHỨC VỤ</th>
								<th style="text-align: center">CMND/CCCD</th>
							</tr>
							</thead>
							<tbody>
							<?php if (!empty($result)): ?>
								<?php foreach ($result as $key => $value): ?>
									<tr>
										<td><?= ++$key ?></td>
										<td>
											<div class="dropdown" style="display:inline-block">
												<button class="btn btn-primary btn-sm dropdown-toggle" type="button"
														data-toggle="dropdown">
													Xem thời gian xử lý
												</button>
												<ul class="dropdown-menu dropdown-menu-right"
													style="left: 0!important;width: 220px!important;">
													<li>
														<a href="javascript:void(0)"
														   onclick="thoi_gian_pgd_xu_ly_lan_dau('<?= $value->_id->{'$oid'} ?>','<?= hide_phone($value->phone_number) ?>','<?= $value->fullname ?>')"
														   class="dropdown-item">
															Thời gian PGD tương tác lần đầu
														</a>
													</li>
													<li>
														<a href="javascript:void(0)"
														   onclick="thoi_gian_xu_ly_pgd('<?= $value->_id->{'$oid'} ?>','<?= hide_phone($value->phone_number) ?>','<?= $value->fullname ?>')"
														   class="dropdown-item"
														>
															Thời gian xử lý PGD
														</a>
													</li>
													<li>
														<a href="javascript:void(0)"
														   onclick="thong_thoi_gian_xu_ly('<?= $value->_id->{'$oid'} ?>','<?= hide_phone($value->phone_number) ?>','<?= $value->fullname ?>')"
														   class="dropdown-item">
															Tổng thời gian xử lý PGD
														</a>
													</li>

												</ul>
											</div>
										</td>
										<td style="text-align: center"><?= !empty($value->office_at) ? date('d/m/Y H:i:s', $value->office_at) : '' ?></td>
										<td><?= !empty($value->cvkd) ? $value->cvkd : '' ?></td>
										<td><?= !empty($value->fullname) ? $value->fullname : '' ?></td>
										<td style="text-align: center"><?= !empty($value->phone_number) ? hide_phone($value->phone_number) : '' ?></td>
										<td><?= !empty($value->id_PDG) ? $value->id_PDG : '' ?></td>
										<td><?= !empty($value->status_pgd) ? status_pgd($value->status_pgd) : '' ?></td>
										<td><?= !empty($value->reason_process) ? reason_process($value->reason_process) : '' ?></td>
										<td><?= !empty($value->status_hd) ? contract_status($value->status_hd) : '' ?></td>
										<td style="text-align: center"><?= !empty($value->amount_money) ? number_format($value->amount_money) : '' ?></td>
										<td><?= !empty($value->source) ? lead_nguon_full($value->source) : '' ?></td>
										<td><?= !empty($value->utm_source) ? $value->utm_source : '' ?></td>
										<td><textarea
												style="width:500px; border: none"><?= !empty($value->utm_campaign) ? $value->utm_campaign : '' ?></textarea>
										</td>
										<td><?= !empty($value->position) ? $value->position : '' ?></td>
										<td><?= !empty($value->identify_lead) ? $value->identify_lead : (!empty($value->customer_identify) ? $value->customer_identify : "") ?></td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>

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


<script src="<?php echo base_url("assets/") ?>js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets/") ?>js/numeral.min.js"></script>

<style>
	.text_content {
		padding: 10px;
		border: 1px solid #ddd;
		font-size: 14px;
	}

	.text_content h4 {
		margin-top: 0;
		color: #ff0000;
		font-weight: 600;
	}
</style>

<div class="modal fade" id="thoi_gian_xu_ly_pgd" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" style="width: 80%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center"><span id="text_span_1"></span></h3>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
						<tr>
							<th style="text-align: center">#</th>
							<th style="text-align: center">Thời gian</th>
							<th style="text-align: center">Giao dịch viên</th>
							<th style="text-align: center">Tên khách hàng</th>
							<th style="text-align: center">Trạng thái trước</th>
							<th style="text-align: center">Trạng thái sau</th>
							<th style="text-align: center">Lý do hủy</th>
							<th style="text-align: center">Ghi chú</th>
						</tr>
						</thead>
						<tbody id="tbody_lead_log">

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="thoi_gian_pgd_xu_ly_lan_dau" tabindex="-1" role="dialog"
	 aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" style="width: 80%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center"><span id="text_span_2"></span></h3>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
						<tr>
							<th style="text-align: center">Thời điểm PGD nhận Lead Inhouse</th>
							<th style="text-align: center">Thời điểm PGD tác động lần đầu</th>
							<th style="text-align: center">Thời gian</th>
						</tr>
						</thead>
						<tbody id="tbody_lead_log_pgd">

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="tong_thoi_gian_xu_ly" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" style="width: 80%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center"><span id="text_span"></span></h3>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
						<tr>
							<th style="text-align: center">Thời điểm PGD nhận Lead Inhouse</th>
							<th style="text-align: center">Thời gian xử lý lần cuối</th>
							<th style="text-align: center">Thời gian</th>
						</tr>
						</thead>
						<tbody id="tbody_lead_tong_thoi_gian_xu_ly">

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script>

	function thoi_gian_xu_ly_pgd(id, phone, fullname) {
		$('#text_span_1').empty();
		let text_span = 'Thời gian xử lý PGD / (' + fullname + ' - ' + phone + ')'
		$('#text_span_1').append(text_span);
		$.ajax({
			url: _url.base_url + 'report_telesale/showLeadLogInfo/' + id,
			type: "GET",
			dataType: "JSON",
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (result) {
				$(".theloading").hide();
				$('#tbody_lead_log').empty();
				if ('undefined' != typeof result.data || null != result.data) {
					let html = "";
					let key = 0;
					for (let i = 0; i < result.data.length; i++) {
						key = i + 1;
						html += '<tr>';
						html += "<td style='text-align: center'>" + key + "</td>"
						html += "<td style='text-align: center'>" + result.data[i].updated_at + "</td>"
						html += "<td style='text-align: center'>" + result.data[i].old_data.cvkd + "</td>"
						html += "<td style='text-align: center'>" + result.data[i].lead_data.fullname + "</td>"
						html += "<td style='text-align: center'>" + result.data[i].status_old + "</td>"
						html += "<td style='text-align: center'>" + result.data[i].status_new + "</td>"
						html += "<td style='text-align: center'>" + result.data[i].code_reason + "</td>"
						html += "<td>" + result.data[i].lead_data.pgd_note + "</td>"
						html += '</tr>';
					}

					$('#tbody_lead_log').append(html);
				}
				$('#thoi_gian_xu_ly_pgd').modal('show');
			}
		});
	}

	function thoi_gian_pgd_xu_ly_lan_dau(id, phone, fullname) {
		$('#text_span_2').empty();
		let text_span = 'Thời gian PGD tương tác lần đầu / (' + fullname + ' - ' + phone + ')'
		$('#text_span_2').append(text_span);
		$.ajax({
			url: _url.base_url + 'report_telesale/showTimeHandle/' + id,
			type: "GET",
			dataType: "JSON",
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (result) {
				$(".theloading").hide();
				$('#tbody_lead_log_pgd').empty();
				let html = "";
				if ('undefined' != typeof result.data || null != result.data) {
					if ('undefined' == typeof result.data.office_at) {
						var office_at = ""
					} else {
						var office_at = result.data.office_at
					}
					if ('undefined' == typeof result.data.updated_at) {
						var updated_at = ""
					} else {
						var updated_at = result.data.updated_at
					}
					if ('undefined' == typeof result.data.time) {
						var time = ""
					} else {
						var time = result.data.time
					}

					html += '<tr>';
					html += "<td style='text-align: center'>" + office_at + "</td>"
					html += "<td style='text-align: center'>" + updated_at + "</td>"
					html += "<td style='text-align: center'>" + time + "</td>"
					html += '</tr>';
				}
				$('#tbody_lead_log_pgd').append(html);
				$('#thoi_gian_pgd_xu_ly_lan_dau').modal('show');
			}
		});
	}

	function thong_thoi_gian_xu_ly(id, phone, fullname) {
		$('#text_span').empty();
		let text_span = 'Tổng thời gian xử lý PGD (' + fullname + ' - ' + phone + ')'
		$('#text_span').append(text_span);
		$.ajax({
			url: _url.base_url + 'report_telesale/showTimeHandleTotal/' + id,
			type: "GET",
			dataType: "JSON",
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (result) {
				$(".theloading").hide();
				$('#tbody_lead_tong_thoi_gian_xu_ly').empty();
				let html = "";
				if ('undefined' != typeof result.data || null != result.data) {
					if ('undefined' == typeof result.data.office_at) {
						var office_at = ""
					} else {
						var office_at = result.data.office_at
					}
					if ('undefined' == typeof result.data.updated_at) {
						var updated_at = ""
					} else {
						var updated_at = result.data.updated_at
					}
					if ('undefined' == typeof result.data.time) {
						var time = ""
					} else {
						var time = result.data.time
					}
					html += '<tr>';
					html += "<td style='text-align: center'>" + office_at + "</td>"
					html += "<td style='text-align: center'>" + updated_at + "</td>"
					html += "<td style='text-align: center'>" + time + "</td>"
					html += '</tr>';
				}
				$('#tbody_lead_tong_thoi_gian_xu_ly').append(html);
				$('#tong_thoi_gian_xu_ly').modal('show');
			}
		});
	}

</script>









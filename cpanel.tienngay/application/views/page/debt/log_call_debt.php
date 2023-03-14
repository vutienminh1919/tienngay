<link href="<?php echo base_url(); ?>assets/js/switchery/switchery.min.css" rel="stylesheet">

<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span>Đang Xử lý...</span>
	</div>
	<div class="row top_tiles">
		<?php
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
		$user = !empty($_GET['email']) ? $_GET['email'] : "";
		?>
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>Lịch sử call THN
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
									href="<?php echo base_url('debt_manager_app/get_log_call_debt') ?>">Lịch sử call
								THN</a>
						</small>
					</h3>
				</div>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-xs-12 col-lg-12">
							<div class="row">
								<form action="<?php echo base_url('debt_manager_app/get_log_call_debt') ?>" method="get"
									  style="width: 100%;">
									<div class="col-lg-3">
										<label></label>
										<div class="input-group">
											<span class="input-group-addon"><?php echo $this->lang->line('from') ?></span>
											<input type="date" name="fdate" class="form-control"
												   value="<?= !empty($fdate) ? $fdate : "" ?>">
										</div>
									</div>
									<div class="col-lg-3">
										<label></label>
										<div class="input-group">
											<span class="input-group-addon"><?php echo $this->lang->line('to') ?></span>
											<input type="date" name="tdate" class="form-control"
												   value="<?= !empty($tdate) ? $tdate : "" ?>">
										</div>
									</div>
									<div class="col-lg-2">
										<label></label>
										<div class="">
											<select type="email" name="email" class="form-control"
													id="idUserDebtAssign">
												<option value="">Chọn nhân viên</option>
												<?php foreach ($debtEmploy as $value) { ?>
													<option <?php echo $user === $value->email ? 'selected' : '' ?>
															value="<?php echo $value->email; ?>"><?php echo $value->email; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-lg-2 text-right">
										<label></label>
										<button type="submit" class="btn btn-primary w-100"><i class="fa fa-search"
																							   aria-hidden="true"></i>
											Tìm kiếm
										</button>
									</div>
									<div class="col-lg-2 text-right">
										<label></label>
										<a style="background-color: #18d102; display: block"
										   href="<?= base_url() ?>debt_manager_app/excelLogCallDebt?fdate=<?= $fdate . '&tdate=' . $tdate . '&email=' . $user ?>"
										   class="btn btn-primary" target="_blank"><i
													class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
											Xuất excel
										</a>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="row">
						<div class="col-xs-12">
							<div class="alert alert-danger alert-dismissible text-center" style="display:none"
								 id="div_error">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<span class='div_error'></span>
							</div>
							<div class="table-responsive">
								<div>Hiển thị
									<span class="text-danger">
								<?php echo $total_rows > 0 ? $total_rows : 0; ?> </span>
									Kết quả
								</div>
								<table class="table table-striped table-hover table-bordered">
									<thead>
									<tr>
										<th style="text-align: center" rowspan="2">#</th>
										<th style="text-align: center" rowspan="2">Mã phiếu ghi</th>
										<th style="text-align: center" rowspan="2">Mã hợp đồng</th>
										<th style="text-align: center" rowspan="2">Tên khách hàng</th>
										<th colspan="4"
											style="text-align: center;color: #0D0A0A;background: wheat">Lịch sử
											gọi mới
										</th>
										<th style="text-align: center;color: #0D0A0A;background: cornflowerblue"
											colspan="4">Lịch
											sử gọi cũ
										</th>
									</tr>
									<tr>
										<th style="text-align: center;color: #0D0A0A;background: wheat">Kết quả nhắc HĐ vay
										</th>
										<th style="text-align: center;color: #0D0A0A;background: wheat">Ghi chú</th>
										<th style="text-align: center;color: #0D0A0A;background: wheat">Nhân viên thực
											hiện
										</th>
										<th style="text-align: center;color: #0D0A0A;background: wheat">Thời gian thực
											hiện
										</th>
										<th style="text-align: center;color: #0D0A0A;background: cornflowerblue">Kết quả
											nhắc HĐ vay
										</th>
										<th style="text-align: center;color: #0D0A0A;background: cornflowerblue">Ghi
											chú
										</th>
										<th style="text-align: center;color: #0D0A0A;background: cornflowerblue">Nhân
											viên thực hiện
										</th>
										<th style="text-align: center;color: #0D0A0A;background: cornflowerblue">Thời
											gian thực hiện
										</th>

									</tr>
									</thead>
									<tbody>
									<?php if (!empty($log_call)) : ?>
										<?php foreach ($log_call as $key => $value): ?>
											<tr style="text-align: center">
												<td><?php echo ++$key + $per_page ?></td>
												<td><?php echo $value->code_contract ?? '' ?>
													<br>
													<a class="btn btn-sm btn-success" target="_blank"
													   href="<?php echo base_url("accountant/view_v2?id=") . $value->_id->{'$oid'} ?>">
														Chi tiết</a>
												</td>
												<td><?php echo $value->code_contract_disbursement ?? '' ?></td>
												<td><?php echo $value->customer_name ?? '' ?>
												<td><?php echo !empty($value->new->note_reminder) ? note_renewal($value->new->note_reminder->reminder) : note_renewal($value->new->result_reminder) ?></td>
												<td><?php echo !empty($value->new->note_reminder) ? $value->new->note_reminder->note : $value->new->note ?></td>
												<td><?php echo $value->created_by ?? '' ?></td>
												<td><?php echo !empty($value->created_at) ? date('d/m/Y H:m:s', $value->created_at) : '' ?></td>
												<td><?php echo !empty($value->old->result_reminder) ? note_renewal($value->old->result_reminder[0]->reminder) : '' ?></td>
												<td><?php echo !empty($value->old->result_reminder) ? $value->old->result_reminder[0]->note : '' ?></td>
												<td><?php echo !empty($value->old->result_reminder) ? $value->old->result_reminder[0]->created_by : '' ?></td>
												<td><?php echo !empty($value->old->result_reminder) ? date('d/m/Y H:m:s', $value->old->result_reminder[0]->created_at) : '' ?></td>
											</tr>
										<?php endforeach; ?>
									<?php else : ?>
										<tr>
											<td colspan="20" class="text-center">Không có dữ liệu</td>
										</tr>
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
	</div>
</div>


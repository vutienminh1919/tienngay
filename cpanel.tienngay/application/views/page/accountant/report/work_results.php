<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="row">
					<div class="col-xs-12">
						<h3>Báo cáo kết quả làm việc
							<br>
							<small>
								<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>/ <a href="#">Quản lý HĐ vay</a> / <a href="#">Báo cáo kết quả làm việc</a>
							</small>
						</h3>
						<div class="alert alert-danger alert-result" id="div_error"
							 style="display:none; color:white;"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-xs-12 col-lg-12">
							<div class="row">
								<form action="<?php echo base_url('accountant/report_work_results') ?>" method="get"
									  style="width: 100%;">
									<div class="col-xs-12 col-lg-2">
										<div class="form-group">
											<label for="">Từ</label>
											<input type="date" name="fdate" class="form-control"
												   value="<?= isset($_GET['fdate']) ? $_GET['fdate'] : "" ?>">
										</div>
									</div>
									<div class="col-xs-12 col-lg-2">
										<div class="form-group">
											<label for="">Đến</label>
											<input type="date" name="tdate" class="form-control"
												   value="<?= isset($_GET['tdate']) ? $_GET['tdate'] : "" ?>">
										</div>
									</div>
									<div class="col-xs-12 col-lg-2">
										<label for="">Phòng giao dịch</label>
										<select class="form-control" name="code_store" id="selectize_store">
											<option value="">Chọn phòng giao dịch</option>
											<?php if (!empty($storeData)) {
												foreach ($storeData as $p) { ?>
													<option <?php echo $store == $p->_id->{'$oid'} ? 'selected' : '' ?>
															value="<?php echo $p->_id->{'$oid'}; ?>"><?php echo $p->name; ?></option>
												<?php }
											} ?>
										</select>
									</div>

									<div class="col-xs-12 col-lg-2 text-right">
										<label for="">&nbsp;</label>
										<button type="submit" class="btn btn-primary w-100"><i class="fa fa-search"
																							   aria-hidden="true"></i> <?= $this->lang->line('search') ?>
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="x_content">
					<div class="row">
						<div class="col-xs-12">
							<div class="table-responsive" style="width: 100%;">
								<table id="datatable-buttons" class="table table-striped datatable-buttons">
									<thead>
									<tr>
										<th>#</th>
										<th> Họ tên khách hàng</th>
										<th>Số hợp đồng</th>
										<th> Loại xe máy</th>
										<th> Số tiền vay</th>
										<th> Số ngày trễ</th>
										<th> Tình trạng Call xử lý</th>
										<th>Ngày bàn giao thực địa</th>
										<th> Ngày thực địa tác động</th>
										<th>Tình trạng thực địa xử lý</th>
										<th> Phương án tiếp theo của thực địa</th>

									</tr>
									</thead>
									<tbody name="list_lead">
									<?php

									if (!empty($reportData)) {
										echo $reportData;
										?>

									<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url("assets") ?>/js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets") ?>/js/numeral.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/lead/index.js"></script>

<script type="text/javascript">
	detail('<?=(isset($_GET['id'])) ? $_GET['id'] : '' ?>');


</script>

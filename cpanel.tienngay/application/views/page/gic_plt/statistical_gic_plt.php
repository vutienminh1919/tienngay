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

		?>
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>Thống kê GIC PLT
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a href="#">Thống
								kê GIC PLT</a>
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
								<form action="<?php echo base_url('gic_plt/statistical_gic_plt') ?>" method="get"
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

									<div class="col-lg-2 text-right">
										<label></label>
										<button type="submit" class="btn btn-primary w-100"><i class="fa fa-search"
																							   aria-hidden="true"></i>
											Tìm kiếm
										</button>
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
<!--								<div>Hiển thị-->
<!--									<span class="text-danger">--><?php //echo $total_rows > 0 ? $total_rows : 0; ?><!-- </span>-->
<!--									Kết quả-->
<!--								</div>-->
								<table class="table table-striped">
									<thead>
									<tr>
										<th style="text-align: center">#</th>
										<th style="text-align: center">Phòng giao dịch</th>
										<th style="text-align: center">Số giao dịch</th>
										<th style="text-align: center">Tổng tiền</th>
										<th style="text-align: center">Action</th>
									</tr>
									</thead>
									<tbody>
									<?php if (!empty($mics)) : ?>
										<?php foreach ($mics as $key => $mic): ?>
											<tr style="text-align: center">
												<td><?php echo ++$key ?></td>
												<td><?php echo !empty($mic->name) ? ($mic->name) : '' ?></td>
												<td><?php echo !empty($mic->total_transaction) ? ($mic->total_transaction) : 0 ?></td>
												<td><?php echo !empty($mic->price) ? number_format($mic->price) . ' VND' : 0 ?></td>
												<td>
													<a class="btn btn-success"
													   href="<?= base_url() ?>gic_plt/list_gic_plt?fdate=<?= $fdate . '&tdate=' . $tdate . '&store=' . $mic->_id->{'$oid'} ?>" target="_blank">
														Chi tiết
													</a>
												</td>
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


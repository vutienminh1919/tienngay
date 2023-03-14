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
					<h3>Báo cáo tháng ban phê duyệt
						<br>
					</h3>

				</div>

			</div>
		</div>


		<form action="<?php echo base_url('report_hs/listReport_hs') ?>" method="get" style="width: 100%;">
			<div class="row">
				<div class="col-lg-4">
					<div class="input-group">
						<span class="input-group-addon"><?php echo $this->lang->line('from') ?></span>
						<input type="date" name="fdate" class="form-control"
							   value="<?= !empty($fdate) ? $fdate : date('Y-m-01') ?>">
					</div>
				</div>
				<div class="col-lg-4">
					<div class="input-group">
						<span class="input-group-addon"><?php echo $this->lang->line('to') ?></span>
						<input type="date" name="tdate" class="form-control"
							   value="<?= !empty($tdate) ? $tdate : date('Y-m-d') ?>">
					</div>
				</div>
				<div class="col-lg-2 text-right">
					<button type="submit" class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i>
						Thống kê
					</button>
				</div>
			</div>
		</form>


		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">

					<div class="row">
						<div class="col-xs-12 col-lg-12">
							<div class="row">

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
								<table id="datatable-button" class="table table-striped">
									<thead>
									<tr>
										<th rowspan="2" style="text-align: center">Khu vực</th>
										<th rowspan="2" style="text-align: center">PGD</th>
										<th rowspan="2" style="text-align: center">Tổng hồ sơ</th>
										<th rowspan="2" style="text-align: center">Tổng giải ngân</th>
										<th colspan="3" style="text-align: center">Trạng thái</th>
										<th colspan="8" style="text-align: center">Ngoại lệ</th>
										<th rowspan="2" style="text-align: center">Giảm khoản vay</th>
									</tr>
									<tr>

										<th style="text-align: center; background-color: white; color: black">Trả về
										</th>
										<th style="text-align: center; background-color: white; color: black">Hủy</th>
										<th style="text-align: center; background-color: white; color: black">Phê
											duyệt
										</th>
										<th style="text-align: center; background-color: white; color: black">Tổng ngoại
											lệ
										</th>
										<th style="text-align: center; background-color: white; color: black">E1</th>
										<th style="text-align: center; background-color: white; color: black">E2</th>
										<th style="text-align: center; background-color: white; color: black">E3</th>
										<th style="text-align: center; background-color: white; color: black">E4</th>
										<th style="text-align: center; background-color: white; color: black">E5</th>
										<th style="text-align: center; background-color: white; color: black">E6</th>
										<th style="text-align: center; background-color: white; color: black">E7</th>
									</tr>
									</thead>
									<tbody>
									<tr>
										<td rowspan="30">Hà Nội</td>
										<td rowspan="2">71 Lê Thanh Nghị</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->LTN71) ? $data->total_hs->LTN71 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->LTN71) ? number_format($data->sum_tgn->LTN71) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->LTN71) ? $data->total_return->LTN71 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->LTN71) ? $data->total_cancel->LTN71 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->LTN71) ? $data->total_approval->LTN71 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->LTN71) ? $data->exception_e1->LTN71 : 0) + (!empty($data->exception_e2->LTN71) ? $data->exception_e2->LTN71 : 0) + (!empty($data->exception_e3->LTN71) ? $data->exception_e3->LTN71 : 0) + (!empty($data->exception_e4->LTN71) ? $data->exception_e4->LTN71 : 0) + (!empty($data->exception_e5->LTN71) ? $data->exception_e5->LTN71 : 0) + (!empty($data->exception_e6->LTN71) ? $data->exception_e6->LTN71 : 0) + (!empty($data->exception_e7->LTN71) ? $data->exception_e7->LTN71 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->LTN71) ? $data->exception_e1->LTN71 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->LTN71) ? $data->exception_e2->LTN71 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->LTN71) ? $data->exception_e3->LTN71 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->LTN71) ? $data->exception_e4->LTN71 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->LTN71) ? $data->exception_e5->LTN71 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->LTN71) ? $data->exception_e6->LTN71 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->LTN71) ? $data->exception_e7->LTN71 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->LTN71) ? $data->loan_increase->LTN71 : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->LTN71 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->LTN71) ? $data->total_return->LTN71 : 0) / (!empty($data->total_hs->LTN71) ? ($data->total_hs->LTN71) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->LTN71 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->LTN71) ? $data->total_cancel->LTN71 : 0) / (!empty($data->total_hs->LTN71) ? ($data->total_hs->LTN71) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->LTN71 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->LTN71) ? $data->total_approval->LTN71 : 0) / (!empty($data->total_hs->LTN71) ? ($data->total_hs->LTN71) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->LTN71) ? $data->exception_e1->LTN71 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->LTN71) ? $data->exception_e2->LTN71 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->LTN71) ? $data->exception_e3->LTN71 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->LTN71) ? $data->exception_e4->LTN71 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->LTN71) ? $data->exception_e5->LTN71 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->LTN71) ? $data->exception_e6->LTN71 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->LTN71) ? $data->exception_e7->LTN71 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if (((!empty($data->total_cancel->LTN71) ? $data->total_cancel->LTN71 : 0) + (!empty($data->total_approval->LTN71) ? $data->total_approval->LTN71 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->LTN71) ? $data->loan_increase->LTN71 : 0) / ((!empty($data->total_cancel->LTN71) ? $data->total_cancel->LTN71 : 0) + (!empty($data->total_approval->LTN71) ? $data->total_approval->LTN71 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>

									<tr>
										<td rowspan="2">26 Vạn Phúc</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->VP26) ? $data->total_hs->VP26 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->VP26) ? number_format($data->sum_tgn->VP26) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->VP26) ? $data->total_return->VP26 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->VP26) ? $data->total_cancel->VP26 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->VP26) ? $data->total_approval->VP26 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->VP26) ? $data->exception_e1->VP26 : 0) + (!empty($data->exception_e2->VP26) ? $data->exception_e2->VP26 : 0) + (!empty($data->exception_e3->VP26) ? $data->exception_e3->VP26 : 0) + (!empty($data->exception_e4->VP26) ? $data->exception_e4->VP26 : 0) + (!empty($data->exception_e5->VP26) ? $data->exception_e5->VP26 : 0) + (!empty($data->exception_e6->VP26) ? $data->exception_e6->VP26 : 0) + (!empty($data->exception_e7->VP26) ? $data->exception_e7->VP26 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->VP26) ? $data->exception_e1->VP26 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->VP26) ? $data->exception_e2->VP26 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->VP26) ? $data->exception_e3->VP26 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->VP26) ? $data->exception_e4->VP26 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->VP26) ? $data->exception_e5->VP26 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->VP26) ? $data->exception_e6->VP26 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->VP26) ? $data->exception_e7->VP26 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->VP26) ? $data->loan_increase->VP26 : 0 ?></td>
									</tr>

									<tr>
										<?php if ($data->total_hs->VP26 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->VP26) ? $data->total_return->VP26 : 0) / (!empty($data->total_hs->VP26) ? ($data->total_hs->VP26) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->VP26 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->VP26) ? $data->total_cancel->VP26 : 0) / (!empty($data->total_hs->VP26) ? ($data->total_hs->VP26) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->VP26 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->VP26) ? $data->total_approval->VP26 : 0) / (!empty($data->total_hs->VP26) ? ($data->total_hs->VP26) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->VP26) ? $data->exception_e1->VP26 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->VP26) ? $data->exception_e2->VP26 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->VP26) ? $data->exception_e3->VP26 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->VP26) ? $data->exception_e4->VP26 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->VP26) ? $data->exception_e5->VP26 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->VP26) ? $data->exception_e6->VP26 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->VP26) ? $data->exception_e7->VP26 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if (((!empty($data->total_cancel->VP26) ? $data->total_cancel->VP26 : 0) + (!empty($data->total_approval->VP26) ? $data->total_approval->VP26 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->VP26) ? $data->loan_increase->VP26 : 0) / ((!empty($data->total_cancel->VP26) ? $data->total_cancel->VP26 : 0) + (!empty($data->total_approval->VP26) ? $data->total_approval->VP26 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>

									<tr>
										<td rowspan="2">494 Trần Cung</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->TC494) ? $data->total_hs->TC494 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->TC494) ? number_format($data->sum_tgn->TC494) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->TC494) ? $data->total_return->TC494 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->TC494) ? $data->total_cancel->TC494 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->TC494) ? $data->total_approval->TC494 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->TC494) ? $data->exception_e1->TC494 : 0) + (!empty($data->exception_e2->TC494) ? $data->exception_e2->TC494 : 0) + (!empty($data->exception_e3->TC494) ? $data->exception_e3->TC494 : 0) + (!empty($data->exception_e4->VP26) ? $data->exception_e4->TC494 : 0) + (!empty($data->exception_e5->VP26) ? $data->exception_e5->TC494 : 0) + (!empty($data->exception_e6->TC494) ? $data->exception_e6->TC494 : 0) + (!empty($data->exception_e7->TC494) ? $data->exception_e7->TC494 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->TC494) ? $data->exception_e1->TC494 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->TC494) ? $data->exception_e2->TC494 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->TC494) ? $data->exception_e3->TC494 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->TC494) ? $data->exception_e4->TC494 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->TC494) ? $data->exception_e5->TC494 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->TC494) ? $data->exception_e6->TC494 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->TC494) ? $data->exception_e7->TC494 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->TC494) ? $data->loan_increase->TC494 : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->TC494 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->TC494) ? $data->total_return->TC494 : 0) / (!empty($data->total_hs->TC494) ? ($data->total_hs->TC494) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->TC494 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->TC494) ? $data->total_cancel->TC494 : 0) / (!empty($data->total_hs->TC494) ? ($data->total_hs->TC494) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->TC494 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->TC494) ? $data->total_approval->TC494 : 0) / (!empty($data->total_hs->TC494) ? ($data->total_hs->TC494) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->TC494) ? $data->exception_e1->TC494 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->TC494) ? $data->exception_e2->TC494 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->TC494) ? $data->exception_e3->TC494 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->TC494) ? $data->exception_e4->TC494 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->TC494) ? $data->exception_e5->TC494 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->TC494) ? $data->exception_e6->TC494 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->TC494) ? $data->exception_e7->TC494 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if (((!empty($data->total_cancel->TC494) ? $data->total_cancel->TC494 : 0) + (!empty($data->total_approval->TC494) ? $data->total_approval->TC494 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->TC494) ? $data->loan_increase->TC494 : 0) / ((!empty($data->total_cancel->TC494) ? $data->total_cancel->TC494 : 0) + (!empty($data->total_approval->TC494) ? $data->total_approval->TC494 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>


									<tr>
										<td rowspan="2">264 Xã Đàn</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->XĐ264) ? $data->total_hs->XĐ264 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->XĐ264) ? number_format($data->sum_tgn->XĐ264) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->XĐ264) ? $data->total_return->XĐ264 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->XĐ264) ? $data->total_cancel->XĐ264 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->XĐ264) ? $data->total_approval->XĐ264 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->XĐ264) ? $data->exception_e1->XĐ264 : 0) + (!empty($data->exception_e2->XĐ264) ? $data->exception_e2->XĐ264 : 0) + (!empty($data->exception_e3->XĐ264) ? $data->exception_e3->XĐ264 : 0) + (!empty($data->exception_e4->XĐ264) ? $data->exception_e4->XĐ264 : 0) + (!empty($data->exception_e5->XĐ264) ? $data->exception_e5->XĐ264 : 0) + (!empty($data->exception_e6->XĐ264) ? $data->exception_e6->XĐ264 : 0) + (!empty($data->exception_e7->XĐ264) ? $data->exception_e7->XĐ264 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->XĐ264) ? $data->exception_e1->XĐ264 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->XĐ264) ? $data->exception_e2->XĐ264 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->XĐ264) ? $data->exception_e3->XĐ264 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->XĐ264) ? $data->exception_e4->XĐ264 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->XĐ264) ? $data->exception_e5->XĐ264 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->XĐ264) ? $data->exception_e6->XĐ264 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->XĐ264) ? $data->exception_e7->XĐ264 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->XĐ264) ? $data->loan_increase->XĐ264 : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->XĐ264 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->XĐ264) ? $data->total_return->XĐ264 : 0) / (!empty($data->total_hs->XĐ264) ? ($data->total_hs->XĐ264) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->XĐ264 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->XĐ264) ? $data->total_cancel->XĐ264 : 0) / (!empty($data->total_hs->XĐ264) ? ($data->total_hs->XĐ264) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->XĐ264 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->XĐ264) ? $data->total_approval->XĐ264 : 0) / (!empty($data->total_hs->XĐ264) ? ($data->total_hs->XĐ264) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->XĐ264) ? $data->exception_e1->XĐ264 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->XĐ264) ? $data->exception_e2->XĐ264 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->XĐ264) ? $data->exception_e3->XĐ264 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->XĐ264) ? $data->exception_e4->XĐ264 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->XĐ264) ? $data->exception_e5->XĐ264 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->XĐ264) ? $data->exception_e6->XĐ264 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->XĐ264) ? $data->exception_e7->XĐ264 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if (((!empty($data->total_cancel->XĐ264) ? $data->total_cancel->XĐ264 : 0) + (!empty($data->total_approval->XĐ264) ? $data->total_approval->XĐ264 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->XĐ264) ? $data->loan_increase->XĐ264 : 0) / ((!empty($data->total_cancel->XĐ264) ? $data->total_cancel->XĐ264 : 0) + (!empty($data->total_approval->XĐ264) ? $data->total_approval->XĐ264 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>


									<tr>
										<td rowspan="2">28 Phan Huy Ích</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->PHI28) ? $data->total_hs->PHI28 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->PHI28) ? number_format($data->sum_tgn->PHI28) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->PHI28) ? $data->total_return->PHI28 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->PHI28) ? $data->total_cancel->PHI28 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->PHI28) ? $data->total_approval->PHI28 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->PHI28) ? $data->exception_e1->PHI28 : 0) + (!empty($data->exception_e2->PHI28) ? $data->exception_e2->PHI28 : 0) + (!empty($data->exception_e3->PHI28) ? $data->exception_e3->PHI28 : 0) + (!empty($data->exception_e4->PHI28) ? $data->exception_e4->PHI28 : 0) + (!empty($data->exception_e5->PHI28) ? $data->exception_e5->PHI28 : 0) + (!empty($data->exception_e6->PHI28) ? $data->exception_e6->PHI28 : 0) + (!empty($data->exception_e7->PHI28) ? $data->exception_e7->PHI28 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->PHI28) ? $data->exception_e1->PHI28 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->PHI28) ? $data->exception_e2->PHI28 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->PHI28) ? $data->exception_e3->PHI28 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->PHI28) ? $data->exception_e4->PHI28 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->PHI28) ? $data->exception_e5->PHI28 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->PHI28) ? $data->exception_e6->PHI28 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->PHI28) ? $data->exception_e7->PHI28 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->PHI28) ? $data->loan_increase->PHI28 : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->PHI28 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->PHI28) ? $data->total_return->PHI28 : 0) / (!empty($data->total_hs->PHI28) ? ($data->total_hs->PHI28) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->PHI28 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->PHI28) ? $data->total_cancel->PHI28 : 0) / (!empty($data->total_hs->PHI28) ? ($data->total_hs->PHI28) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->PHI28 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->PHI28) ? $data->total_approval->PHI28 : 0) / (!empty($data->total_hs->PHI28) ? ($data->total_hs->PHI28) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->PHI28) ? $data->exception_e1->PHI28 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->PHI28) ? $data->exception_e2->PHI28 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->PHI28) ? $data->exception_e3->PHI28 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->PHI28) ? $data->exception_e4->PHI28 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->PHI28) ? $data->exception_e5->PHI28 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->PHI28) ? $data->exception_e6->PHI28 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->PHI28) ? $data->exception_e7->PHI28 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if (((!empty($data->total_cancel->PHI28) ? $data->total_cancel->PHI28 : 0) + (!empty($data->total_approval->PHI28) ? $data->total_approval->PHI28 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->PHI28) ? $data->loan_increase->PHI28 : 0) / ((!empty($data->total_cancel->PHI28) ? $data->total_cancel->PHI28 : 0) + (!empty($data->total_approval->PHI28) ? $data->total_approval->PHI28 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>


									<tr>
										<td rowspan="2">01 Mỹ Đình</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->MĐ01) ? $data->total_hs->MĐ01 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->MĐ01) ? number_format($data->sum_tgn->MĐ01) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->MĐ01) ? $data->total_return->MĐ01 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->MĐ01) ? $data->total_cancel->MĐ01 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->MĐ01) ? $data->total_approval->MĐ01 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->MĐ01) ? $data->exception_e1->MĐ01 : 0) + (!empty($data->exception_e2->MĐ01) ? $data->exception_e2->MĐ01 : 0) + (!empty($data->exception_e3->MĐ01) ? $data->exception_e3->MĐ01 : 0) + (!empty($data->exception_e4->MĐ01) ? $data->exception_e4->MĐ01 : 0) + (!empty($data->exception_e5->MĐ01) ? $data->exception_e5->MĐ01 : 0) + (!empty($data->exception_e6->MĐ01) ? $data->exception_e6->MĐ01 : 0) + (!empty($data->exception_e7->MĐ01) ? $data->exception_e7->MĐ01 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->MĐ01) ? $data->exception_e1->MĐ01 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->MĐ01) ? $data->exception_e2->MĐ01 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->MĐ01) ? $data->exception_e3->MĐ01 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->MĐ01) ? $data->exception_e4->MĐ01 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->MĐ01) ? $data->exception_e5->MĐ01 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->MĐ01) ? $data->exception_e6->MĐ01 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->MĐ01) ? $data->exception_e7->MĐ01 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->MĐ01) ? $data->loan_increase->MĐ01 : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->MĐ01 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->MĐ01) ? $data->total_return->MĐ01 : 0) / (!empty($data->total_hs->MĐ01) ? ($data->total_hs->MĐ01) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->MĐ01 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->MĐ01) ? $data->total_cancel->MĐ01 : 0) / (!empty($data->total_hs->MĐ01) ? ($data->total_hs->MĐ01) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->MĐ01 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->MĐ01) ? $data->total_approval->MĐ01 : 0) / (!empty($data->total_hs->MĐ01) ? ($data->total_hs->MĐ01) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->MĐ01) ? $data->exception_e1->MĐ01 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->MĐ01) ? $data->exception_e2->MĐ01 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->MĐ01) ? $data->exception_e3->MĐ01 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->MĐ01) ? $data->exception_e4->MĐ01 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->MĐ01) ? $data->exception_e5->MĐ01 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->MĐ01) ? $data->exception_e6->MĐ01 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->MĐ01) ? $data->exception_e7->MĐ01 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if (((!empty($data->total_cancel->MĐ01) ? $data->total_cancel->MĐ01 : 0) + (!empty($data->total_approval->MĐ01) ? $data->total_approval->MĐ01 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->MĐ01) ? $data->loan_increase->MĐ01 : 0) / ((!empty($data->total_cancel->MĐ01) ? $data->total_cancel->MĐ01 : 0) + (!empty($data->total_approval->MĐ01) ? $data->total_approval->MĐ01 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>


									<tr>
										<td rowspan="2">48 La Thành</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->LT48) ? $data->total_hs->LT48 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->LT48) ? number_format($data->sum_tgn->LT48) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->LT48) ? $data->total_return->LT48 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->LT48) ? $data->total_cancel->LT48 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->LT48) ? $data->total_approval->LT48 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->LT48) ? $data->exception_e1->LT48 : 0) + (!empty($data->exception_e2->LT48) ? $data->exception_e2->LT48 : 0) + (!empty($data->exception_e3->LT48) ? $data->exception_e3->LT48 : 0) + (!empty($data->exception_e4->LT48) ? $data->exception_e4->LT48 : 0) + (!empty($data->exception_e5->LT48) ? $data->exception_e5->LT48 : 0) + (!empty($data->exception_e6->LT48) ? $data->exception_e6->LT48 : 0) + (!empty($data->exception_e7->LT48) ? $data->exception_e7->LT48 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->LT48) ? $data->exception_e1->LT48 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->LT48) ? $data->exception_e2->LT48 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->LT48) ? $data->exception_e3->LT48 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->LT48) ? $data->exception_e4->LT48 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->LT48) ? $data->exception_e5->LT48 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->LT48) ? $data->exception_e6->LT48 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->LT48) ? $data->exception_e7->LT48 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->LT48) ? $data->loan_increase->LT48 : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->LT48 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->LT48) ? $data->total_return->LT48 : 0) / (!empty($data->total_hs->LT48) ? ($data->total_hs->LT48) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->LT48 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->LT48) ? $data->total_cancel->LT48 : 0) / (!empty($data->total_hs->LT48) ? ($data->total_hs->LT48) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->LT48 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->LT48) ? $data->total_approval->LT48 : 0) / (!empty($data->total_hs->LT48) ? ($data->total_hs->LT48) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->LT48) ? $data->exception_e1->LT48 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->LT48) ? $data->exception_e2->LT48 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->LT48) ? $data->exception_e3->LT48 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->LT48) ? $data->exception_e4->LT48 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->LT48) ? $data->exception_e5->LT48 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->LT48) ? $data->exception_e6->LT48 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->LT48) ? $data->exception_e7->LT48 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if (((!empty($data->total_cancel->LT48) ? $data->total_cancel->LT48 : 0) + (!empty($data->total_approval->LT48) ? $data->total_approval->LT48 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->LT48) ? $data->loan_increase->LT48 : 0) / ((!empty($data->total_cancel->LT48) ? $data->total_cancel->LT48 : 0) + (!empty($data->total_approval->LT48) ? $data->total_approval->LT48 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>

									<tr>
										<td rowspan="2">310 Phan Trọng Tuệ</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->PTT310) ? $data->total_hs->PTT310 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->PTT310) ? number_format($data->sum_tgn->PTT310) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->PTT310) ? $data->total_return->PTT310 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->PTT310) ? $data->total_cancel->PTT310 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->PTT310) ? $data->total_approval->PTT310 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->PTT310) ? $data->exception_e1->PTT310 : 0) + (!empty($data->exception_e2->PTT310) ? $data->exception_e2->PTT310 : 0) + (!empty($data->exception_e3->PTT310) ? $data->exception_e3->PTT310 : 0) + (!empty($data->exception_e4->PTT310) ? $data->exception_e4->PTT310 : 0) + (!empty($data->exception_e5->PTT310) ? $data->exception_e5->PTT310 : 0) + (!empty($data->exception_e6->PTT310) ? $data->exception_e6->PTT310 : 0) + (!empty($data->exception_e7->PTT310) ? $data->exception_e7->PTT310 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->PTT310) ? $data->exception_e1->PTT310 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->PTT310) ? $data->exception_e2->PTT310 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->PTT310) ? $data->exception_e3->PTT310 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->PTT310) ? $data->exception_e4->PTT310 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->PTT310) ? $data->exception_e5->PTT310 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->PTT310) ? $data->exception_e6->PTT310 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->PTT310) ? $data->exception_e7->PTT310 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->PTT310) ? $data->loan_increase->PTT310 : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->PTT310 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->PTT310) ? $data->total_return->PTT310 : 0) / (!empty($data->total_hs->PTT310) ? ($data->total_hs->PTT310) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->PTT310 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->PTT310) ? $data->total_cancel->PTT310 : 0) / (!empty($data->total_hs->PTT310) ? ($data->total_hs->PTT310) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->PTT310 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->PTT310) ? $data->total_approval->PTT310 : 0) / (!empty($data->total_hs->PTT310) ? ($data->total_hs->PTT310) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->PTT310) ? $data->exception_e1->PTT310 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->PTT310) ? $data->exception_e2->PTT310 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->PTT310) ? $data->exception_e3->PTT310 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->PTT310) ? $data->exception_e4->PTT310 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->PTT310) ? $data->exception_e5->PTT310 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->PTT310) ? $data->exception_e6->PTT310 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->PTT310) ? $data->exception_e7->PTT310 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if (((!empty($data->total_cancel->PTT310) ? $data->total_cancel->PTT310 : 0) + (!empty($data->total_approval->PTT310) ? $data->total_approval->PTT310 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->PTT310) ? $data->loan_increase->PTT310 : 0) / ((!empty($data->total_cancel->PTT310) ? $data->total_cancel->PTT310 : 0) + (!empty($data->total_approval->PTT310) ? $data->total_approval->PTT310 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>


									<tr>
										<td rowspan="2">30 Nguyễn Thái Học</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->NTH30) ? $data->total_hs->NTH30 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->NTH30) ? number_format($data->sum_tgn->NTH30) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->NTH30) ? $data->total_return->NTH30 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->NTH30) ? $data->total_cancel->NTH30 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->NTH30) ? $data->total_approval->NTH30 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->NTH30) ? $data->exception_e1->NTH30 : 0) + (!empty($data->exception_e2->NTH30) ? $data->exception_e2->NTH30 : 0) + (!empty($data->exception_e3->NTH30) ? $data->exception_e3->NTH30 : 0) + (!empty($data->exception_e4->NTH30) ? $data->exception_e4->NTH30 : 0) + (!empty($data->exception_e5->NTH30) ? $data->exception_e5->NTH30 : 0) + (!empty($data->exception_e6->NTH30) ? $data->exception_e6->NTH30 : 0) + (!empty($data->exception_e7->NTH30) ? $data->exception_e7->NTH30 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->NTH30) ? $data->exception_e1->NTH30 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->NTH30) ? $data->exception_e2->NTH30 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->NTH30) ? $data->exception_e3->NTH30 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->NTH30) ? $data->exception_e4->NTH30 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->NTH30) ? $data->exception_e5->NTH30 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->NTH30) ? $data->exception_e6->NTH30 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->NTH30) ? $data->exception_e7->NTH30 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->NTH30) ? $data->loan_increase->NTH30 : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->NTH30 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->NTH30) ? $data->total_return->NTH30 : 0) / (!empty($data->total_hs->NTH30) ? ($data->total_hs->NTH30) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->NTH30 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->NTH30) ? $data->total_cancel->NTH30 : 0) / (!empty($data->total_hs->NTH30) ? ($data->total_hs->NTH30) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->NTH30 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->NTH30) ? $data->total_approval->NTH30 : 0) / (!empty($data->total_hs->NTH30) ? ($data->total_hs->NTH30) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->NTH30) ? $data->exception_e1->NTH30 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->NTH30) ? $data->exception_e2->NTH30 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->NTH30) ? $data->exception_e3->NTH30 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->NTH30) ? $data->exception_e4->NTH30 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->NTH30) ? $data->exception_e5->NTH30 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->NTH30) ? $data->exception_e6->NTH30 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->NTH30) ? $data->exception_e7->NTH30 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if (((!empty($data->total_cancel->NTH30) ? $data->total_cancel->NTH30 : 0) + (!empty($data->total_approval->NTH30) ? $data->total_approval->NTH30 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->NTH30) ? $data->loan_increase->NTH30 : 0) / ((!empty($data->total_cancel->NTH30) ? $data->total_cancel->NTH30 : 0) + (!empty($data->total_approval->NTH30) ? $data->total_approval->NTH30 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

									</tr>


									<tr>
										<td rowspan="2">81 Nguyễn Trãi</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->NT81) ? $data->total_hs->NT81 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->NT81) ? number_format($data->sum_tgn->NT81) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->NT81) ? $data->total_return->NT81 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->NT81) ? $data->total_cancel->NT81 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->NT81) ? $data->total_approval->NT81 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->NT81) ? $data->exception_e1->NT81 : 0) + (!empty($data->exception_e2->NT81) ? $data->exception_e2->NT81 : 0) + (!empty($data->exception_e3->NT81) ? $data->exception_e3->NT81 : 0) + (!empty($data->exception_e4->NT81) ? $data->exception_e4->NT81 : 0) + (!empty($data->exception_e5->NT81) ? $data->exception_e5->NT81 : 0) + (!empty($data->exception_e6->NT81) ? $data->exception_e6->NT81 : 0) + (!empty($data->exception_e7->NT81) ? $data->exception_e7->NT81 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->NT81) ? $data->exception_e1->NT81 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->NT81) ? $data->exception_e2->NT81 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->NT81) ? $data->exception_e3->NT81 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->NT81) ? $data->exception_e4->NT81 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->NT81) ? $data->exception_e5->NT81 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->NT81) ? $data->exception_e6->NT81 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->NT81) ? $data->exception_e7->NT81 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->NT81) ? $data->loan_increase->NT81 : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->NT81 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->NT81) ? $data->total_return->NT81 : 0) / (!empty($data->total_hs->NT81) ? ($data->total_hs->NT81) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->NT81 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->NT81) ? $data->total_cancel->NT81 : 0) / (!empty($data->total_hs->NT81) ? ($data->total_hs->NT81) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->NT81 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->NT81) ? $data->total_approval->NT81 : 0) / (!empty($data->total_hs->NT81) ? ($data->total_hs->NT81) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->NT81) ? $data->exception_e1->NT81 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->NT81) ? $data->exception_e2->NT81 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->NT81) ? $data->exception_e3->NT81 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->NT81) ? $data->exception_e4->NT81 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->NT81) ? $data->exception_e5->NT81 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->NT81) ? $data->exception_e6->NT81 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->NT81) ? $data->exception_e7->NT81 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if (((!empty($data->total_cancel->NT81) ? $data->total_cancel->NT81 : 0) + (!empty($data->total_approval->NT81) ? $data->total_approval->NT81 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->NT81) ? $data->loan_increase->NT81 : 0) / ((!empty($data->total_cancel->NT81) ? $data->total_cancel->NT81 : 0) + (!empty($data->total_approval->NT81) ? $data->total_approval->NT81 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>


									<tr>
										<td rowspan="2">518 Xã Đàn</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->XĐ519) ? $data->total_hs->XĐ519 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->XĐ519) ? number_format($data->sum_tgn->XĐ519) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->XĐ519) ? $data->total_return->XĐ519 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->XĐ519) ? $data->total_cancel->XĐ519 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->XĐ519) ? $data->total_approval->XĐ519 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->XĐ519) ? $data->exception_e1->XĐ519 : 0) + (!empty($data->exception_e2->XĐ519) ? $data->exception_e2->XĐ519 : 0) + (!empty($data->exception_e3->XĐ519) ? $data->exception_e3->XĐ519 : 0) + (!empty($data->exception_e4->XĐ519) ? $data->exception_e4->XĐ519 : 0) + (!empty($data->exception_e5->XĐ519) ? $data->exception_e5->XĐ519 : 0) + (!empty($data->exception_e6->XĐ519) ? $data->exception_e6->XĐ519 : 0) + (!empty($data->exception_e7->XĐ519) ? $data->exception_e7->XĐ519 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->XĐ519) ? $data->exception_e1->XĐ519 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->XĐ519) ? $data->exception_e2->XĐ519 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->XĐ519) ? $data->exception_e3->XĐ519 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->XĐ519) ? $data->exception_e4->XĐ519 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->XĐ519) ? $data->exception_e5->XĐ519 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->XĐ519) ? $data->exception_e6->XĐ519 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->XĐ519) ? $data->exception_e7->XĐ519 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->XĐ519) ? $data->loan_increase->XĐ519 : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->XĐ519 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->XĐ519) ? $data->total_return->XĐ519 : 0) / (!empty($data->total_hs->XĐ519) ? ($data->total_hs->XĐ519) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->XĐ519 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->XĐ519) ? $data->total_cancel->XĐ519 : 0) / (!empty($data->total_hs->XĐ519) ? ($data->total_hs->XĐ519) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->XĐ519 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->XĐ519) ? $data->total_approval->XĐ519 : 0) / (!empty($data->total_hs->XĐ519) ? ($data->total_hs->XĐ519) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->XĐ519) ? $data->exception_e1->XĐ519 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->XĐ519) ? $data->exception_e2->XĐ519 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->XĐ519) ? $data->exception_e3->XĐ519 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->XĐ519) ? $data->exception_e4->XĐ519 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->XĐ519) ? $data->exception_e5->XĐ519 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->XĐ519) ? $data->exception_e6->XĐ519 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->XĐ519) ? $data->exception_e7->XĐ519 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if (((!empty($data->total_cancel->XĐ519) ? $data->total_cancel->XĐ519 : 0) + (!empty($data->total_approval->XĐ519) ? $data->total_approval->XĐ519 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->XĐ519) ? $data->loan_increase->XĐ519 : 0) / ((!empty($data->total_cancel->XĐ519) ? $data->total_cancel->XĐ519 : 0) + (!empty($data->total_approval->XĐ519) ? $data->total_approval->XĐ519 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>


									<tr>
										<td rowspan="2">79 Hưng Đạo</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->HĐ79) ? $data->total_hs->HĐ79 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->HĐ79) ? number_format($data->sum_tgn->HĐ79) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->HĐ79) ? $data->total_return->HĐ79 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->HĐ79) ? $data->total_cancel->HĐ79 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->HĐ79) ? $data->total_approval->HĐ79 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->HĐ79) ? $data->exception_e1->HĐ79 : 0) + (!empty($data->exception_e2->HĐ79) ? $data->exception_e2->HĐ79 : 0) + (!empty($data->exception_e3->HĐ79) ? $data->exception_e3->HĐ79 : 0) + (!empty($data->exception_e4->HĐ79) ? $data->exception_e4->HĐ79 : 0) + (!empty($data->exception_e5->HĐ79) ? $data->exception_e5->HĐ79 : 0) + (!empty($data->exception_e6->HĐ79) ? $data->exception_e6->HĐ79 : 0) + (!empty($data->exception_e7->HĐ79) ? $data->exception_e7->HĐ79 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->HĐ79) ? $data->exception_e1->HĐ79 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->HĐ79) ? $data->exception_e2->HĐ79 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->HĐ79) ? $data->exception_e3->HĐ79 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->HĐ79) ? $data->exception_e4->HĐ79 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->HĐ79) ? $data->exception_e5->HĐ79 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->HĐ79) ? $data->exception_e6->HĐ79 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->HĐ79) ? $data->exception_e7->HĐ79 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->HĐ79) ? $data->loan_increase->HĐ79 : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->HĐ79 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->HĐ79) ? $data->total_return->HĐ79 : 0) / (!empty($data->total_hs->HĐ79) ? ($data->total_hs->HĐ79) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->HĐ79 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->HĐ79) ? $data->total_cancel->HĐ79 : 0) / (!empty($data->total_hs->HĐ79) ? ($data->total_hs->HĐ79) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->HĐ79 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->HĐ79) ? $data->total_approval->HĐ79 : 0) / (!empty($data->total_hs->HĐ79) ? ($data->total_hs->HĐ79) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->HĐ79) ? $data->exception_e1->HĐ79 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->HĐ79) ? $data->exception_e2->HĐ79 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->HĐ79) ? $data->exception_e3->HĐ79 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->HĐ79) ? $data->exception_e4->HĐ79 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->HĐ79) ? $data->exception_e5->HĐ79 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->HĐ79) ? $data->exception_e6->HĐ79 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->HĐ79) ? $data->exception_e7->HĐ79 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if (((!empty($data->total_cancel->HĐ79) ? $data->total_cancel->HĐ79 : 0) + (!empty($data->total_approval->HĐ79) ? $data->total_approval->HĐ79 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->HĐ79) ? $data->loan_increase->HĐ79 : 0) / ((!empty($data->total_cancel->HĐ79) ? $data->total_cancel->HĐ79 : 0) + (!empty($data->total_approval->HĐ79) ? $data->total_approval->HĐ79 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>


									<tr>
										<td rowspan="2">281 Ngô Gia Tự</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->NGT281) ? $data->total_hs->NGT281 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->NGT281) ? number_format($data->sum_tgn->NGT281) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->NGT281) ? $data->total_return->NGT281 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->NGT281) ? $data->total_cancel->NGT281 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->NGT281) ? $data->total_approval->NGT281 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->NGT281) ? $data->exception_e1->NGT281 : 0) + (!empty($data->exception_e2->NGT281) ? $data->exception_e2->NGT281 : 0) + (!empty($data->exception_e3->NGT281) ? $data->exception_e3->NGT281 : 0) + (!empty($data->exception_e4->NGT281) ? $data->exception_e4->NGT281 : 0) + (!empty($data->exception_e5->NGT281) ? $data->exception_e5->NGT281 : 0) + (!empty($data->exception_e6->NGT281) ? $data->exception_e6->NGT281 : 0) + (!empty($data->exception_e7->NGT281) ? $data->exception_e7->NGT281 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->NGT281) ? $data->exception_e1->NGT281 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->NGT281) ? $data->exception_e2->NGT281 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->NGT281) ? $data->exception_e3->NGT281 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->NGT281) ? $data->exception_e4->NGT281 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->NGT281) ? $data->exception_e5->NGT281 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->NGT281) ? $data->exception_e6->NGT281 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->NGT281) ? $data->exception_e7->NGT281 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->NGT281) ? $data->loan_increase->NGT281 : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->NGT281 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->NGT281) ? $data->total_return->NGT281 : 0) / (!empty($data->total_hs->NGT281) ? ($data->total_hs->NGT281) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->HĐ79 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->NGT281) ? $data->total_cancel->NGT281 : 0) / (!empty($data->total_hs->NGT281) ? ($data->total_hs->NGT281) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->HĐ79 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->NGT281) ? $data->total_approval->NGT281 : 0) / (!empty($data->total_hs->NGT281) ? ($data->total_hs->NGT281) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->NGT281) ? $data->exception_e1->NGT281 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->NGT281) ? $data->exception_e2->NGT281 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->NGT281) ? $data->exception_e3->NGT281 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->NGT281) ? $data->exception_e4->NGT281 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->NGT281) ? $data->exception_e5->NGT281 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->NGT281) ? $data->exception_e6->NGT281 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->NGT281) ? $data->exception_e7->NGT281 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if (((!empty($data->total_cancel->NGT281) ? $data->total_cancel->NGT281 : 0) + (!empty($data->total_approval->NGT281) ? $data->total_approval->NGT281 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->NGT281) ? $data->loan_increase->NGT281 : 0) / ((!empty($data->total_cancel->NGT281) ? $data->total_cancel->NGT281 : 0) + (!empty($data->total_approval->NGT281) ? $data->total_approval->NGT281 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>


									<tr>
										<td rowspan="2">901 Giải Phóng</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->GP901) ? $data->total_hs->GP901 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->GP901) ? number_format($data->sum_tgn->GP901) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->GP901) ? $data->total_return->GP901 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->GP901) ? $data->total_cancel->GP901 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->GP901) ? $data->total_approval->GP901 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->GP901) ? $data->exception_e1->GP901 : 0) + (!empty($data->exception_e2->GP901) ? $data->exception_e2->GP901 : 0) + (!empty($data->exception_e3->GP901) ? $data->exception_e3->GP901 : 0) + (!empty($data->exception_e4->GP901) ? $data->exception_e4->GP901 : 0) + (!empty($data->exception_e5->GP901) ? $data->exception_e5->GP901 : 0) + (!empty($data->exception_e6->GP901) ? $data->exception_e6->GP901 : 0) + (!empty($data->exception_e7->GP901) ? $data->exception_e7->GP901 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->GP901) ? $data->exception_e1->GP901 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->GP901) ? $data->exception_e2->GP901 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->GP901) ? $data->exception_e3->GP901 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->GP901) ? $data->exception_e4->GP901 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->GP901) ? $data->exception_e5->GP901 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->GP901) ? $data->exception_e6->GP901 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->GP901) ? $data->exception_e7->GP901 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->GP901) ? $data->loan_increase->GP901 : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->GP901 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->GP901) ? $data->total_return->GP901 : 0) / (!empty($data->total_hs->GP901) ? ($data->total_hs->GP901) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->GP901 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->GP901) ? $data->total_cancel->GP901 : 0) / (!empty($data->total_hs->GP901) ? ($data->total_hs->GP901) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->GP901 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->GP901) ? $data->total_approval->GP901 : 0) / (!empty($data->total_hs->GP901) ? ($data->total_hs->GP901) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->GP901) ? $data->exception_e1->GP901 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->GP901) ? $data->exception_e2->GP901 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->GP901) ? $data->exception_e3->GP901 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->GP901) ? $data->exception_e4->GP901 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->GP901) ? $data->exception_e5->GP901 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->GP901) ? $data->exception_e6->GP901 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->GP901) ? $data->exception_e7->GP901 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if (((!empty($data->total_cancel->GP901) ? $data->total_cancel->GP901 : 0) + (!empty($data->total_approval->GP901) ? $data->total_approval->GP901 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->GP901) ? $data->loan_increase->GP901 : 0) / ((!empty($data->total_cancel->GP901) ? $data->total_cancel->GP901 : 0) + (!empty($data->total_approval->GP901) ? $data->total_approval->GP901 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>


									<tr>
										<td rowspan="2">44 Lĩnh Nam</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->LN44) ? $data->total_hs->LN44 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->LN44) ? number_format($data->sum_tgn->LN44) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->LN44) ? $data->total_return->LN44 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->LN44) ? $data->total_cancel->LN44 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->LN44) ? $data->total_approval->LN44 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->LN44) ? $data->exception_e1->LN44 : 0) + (!empty($data->exception_e2->LN44) ? $data->exception_e2->LN44 : 0) + (!empty($data->exception_e3->LN44) ? $data->exception_e3->LN44 : 0) + (!empty($data->exception_e4->LN44) ? $data->exception_e4->LN44 : 0) + (!empty($data->exception_e5->LN44) ? $data->exception_e5->LN44 : 0) + (!empty($data->exception_e6->LN44) ? $data->exception_e6->LN44 : 0) + (!empty($data->exception_e7->LN44) ? $data->exception_e7->LN44 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->LN44) ? $data->exception_e1->LN44 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->LN44) ? $data->exception_e2->LN44 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->LN44) ? $data->exception_e3->LN44 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->LN44) ? $data->exception_e4->LN44 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->LN44) ? $data->exception_e5->LN44 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->LN44) ? $data->exception_e6->LN44 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->LN44) ? $data->exception_e7->LN44 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->LN44) ? $data->loan_increase->LN44 : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->LN44 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->LN44) ? $data->total_return->LN44 : 0) / (!empty($data->total_hs->LN44) ? ($data->total_hs->LN44) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->LN44 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->LN44) ? $data->total_cancel->LN44 : 0) / (!empty($data->total_hs->LN44) ? ($data->total_hs->LN44) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->LN44 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->LN44) ? $data->total_approval->LN44 : 0) / (!empty($data->total_hs->LN44) ? ($data->total_hs->LN44) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->LN44) ? $data->exception_e1->LN44 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->LN44) ? $data->exception_e2->LN44 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->LN44) ? $data->exception_e3->LN44 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->LN44) ? $data->exception_e4->LN44 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->LN44) ? $data->exception_e5->LN44 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->LN44) ? $data->exception_e6->LN44 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->LN44) ? $data->exception_e7->LN44 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if (((!empty($data->total_cancel->LN44) ? $data->total_cancel->LN44 : 0) + (!empty($data->total_approval->LN44) ? $data->total_approval->LN44 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->LN44) ? $data->loan_increase->LN44 : 0) / ((!empty($data->total_cancel->LN44) ? $data->total_cancel->LN44 : 0) + (!empty($data->total_approval->LN44) ? $data->total_approval->LN44 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>


									<tr>
										<td rowspan="26">Tp Hồ Chí Minh</td>
										<td rowspan="2">316 Nguyễn Sơn</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->NS316) ? $data->total_hs->NS316 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->NS316) ? number_format($data->sum_tgn->NS316) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->NS316) ? $data->total_return->NS316 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->NS316) ? $data->total_cancel->NS316 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->NS316) ? $data->total_approval->NS316 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->NS316) ? $data->exception_e1->NS316 : 0) + (!empty($data->exception_e2->NS316) ? $data->exception_e2->NS316 : 0) + (!empty($data->exception_e3->NS316) ? $data->exception_e3->NS316 : 0) + (!empty($data->exception_e4->NS316) ? $data->exception_e4->NS316 : 0) + (!empty($data->exception_e5->NS316) ? $data->exception_e5->NS316 : 0) + (!empty($data->exception_e6->NS316) ? $data->exception_e6->NS316 : 0) + (!empty($data->exception_e7->NS316) ? $data->exception_e7->NS316 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->NS316) ? $data->exception_e1->NS316 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->NS316) ? $data->exception_e2->NS316 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->NS316) ? $data->exception_e3->NS316 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->NS316) ? $data->exception_e4->NS316 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->NS316) ? $data->exception_e5->NS316 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->NS316) ? $data->exception_e6->NS316 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->NS316) ? $data->exception_e7->NS316 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->NS316) ? $data->loan_increase->NS316 : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->NS316 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->NS316) ? $data->total_return->NS316 : 0) / (!empty($data->total_hs->NS316) ? ($data->total_hs->NS316) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->NS316 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->NS316) ? $data->total_cancel->NS316 : 0) / (!empty($data->total_hs->NS316) ? ($data->total_hs->NS316) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->NS316 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->NS316) ? $data->total_approval->NS316 : 0) / (!empty($data->total_hs->NS316) ? ($data->total_hs->NS316) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->NS316) ? $data->exception_e1->NS316 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->NS316) ? $data->exception_e2->NS316 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->NS316) ? $data->exception_e3->NS316 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->NS316) ? $data->exception_e4->NS316 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->NS316) ? $data->exception_e5->NS316 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->NS316) ? $data->exception_e6->NS316 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->NS316) ? $data->exception_e7->NS316 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if (((!empty($data->total_cancel->NS316) ? $data->total_cancel->NS316 : 0) + (!empty($data->total_approval->NS316) ? $data->total_approval->NS316 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->NS316) ? $data->loan_increase->NS316 : 0) / ((!empty($data->total_cancel->NS316) ? $data->total_cancel->NS316 : 0) + (!empty($data->total_approval->NS316) ? $data->total_approval->NS316 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>


									<tr>
										<td rowspan="2">550 Nguyễn Văn Khối</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->NVK550) ? $data->total_hs->NVK550 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->NVK550) ? number_format($data->sum_tgn->NVK550) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->NVK550) ? $data->total_return->NVK550 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->NVK550) ? $data->total_cancel->NVK550 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->NVK550) ? $data->total_approval->NVK550 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->NVK550) ? $data->exception_e1->NVK550 : 0) + (!empty($data->exception_e2->NVK550) ? $data->exception_e2->NVK550 : 0) + (!empty($data->exception_e3->NVK550) ? $data->exception_e3->NVK550 : 0) + (!empty($data->exception_e4->NVK550) ? $data->exception_e4->NVK550 : 0) + (!empty($data->exception_e5->NVK550) ? $data->exception_e5->NVK550 : 0) + (!empty($data->exception_e6->NVK550) ? $data->exception_e6->NVK550 : 0) + (!empty($data->exception_e7->NVK550) ? $data->exception_e7->NVK550 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->NVK550) ? $data->exception_e1->NVK550 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->NVK550) ? $data->exception_e2->NVK550 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->NVK550) ? $data->exception_e3->NVK550 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->NVK550) ? $data->exception_e4->NVK550 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->NVK550) ? $data->exception_e5->NVK550 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->NVK550) ? $data->exception_e6->NVK550 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->NVK550) ? $data->exception_e7->NVK550 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->NVK550) ? $data->loan_increase->NVK550 : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->NVK550 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->NVK550) ? $data->total_return->NVK550 : 0) / (!empty($data->total_hs->NVK550) ? ($data->total_hs->NVK550) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->NVK550 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->NVK550) ? $data->total_cancel->NVK550 : 0) / (!empty($data->total_hs->NVK550) ? ($data->total_hs->NVK550) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->NVK550 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->NVK550) ? $data->total_approval->NVK550 : 0) / (!empty($data->total_hs->NVK550) ? ($data->total_hs->NVK550) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->NVK550) ? $data->exception_e1->NVK550 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->NVK550) ? $data->exception_e2->NVK550 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->NVK550) ? $data->exception_e3->NVK550 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->NVK550) ? $data->exception_e4->NVK550 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->NVK550) ? $data->exception_e5->NVK550 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->NVK550) ? $data->exception_e6->NVK550 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->NVK550) ? $data->exception_e7->NVK550 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if (((!empty($data->total_cancel->NVK550) ? $data->total_cancel->NVK550 : 0) + (!empty($data->total_approval->NVK550) ? $data->total_approval->NVK550 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->NVK550) ? $data->loan_increase->NVK550 : 0) / ((!empty($data->total_cancel->NVK550) ? $data->total_cancel->NVK550 : 0) + (!empty($data->total_approval->NVK550) ? $data->total_approval->NVK550 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>


									<tr>
										<td rowspan="2">138 Phan Đăng Lưu</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->PĐL138) ? $data->total_hs->PĐL138 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->PĐL138) ? number_format($data->sum_tgn->PĐL138) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->PĐL138) ? $data->total_return->PĐL138 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->PĐL138) ? $data->total_cancel->PĐL138 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->PĐL138) ? $data->total_approval->PĐL138 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->PĐL138) ? $data->exception_e1->PĐL138 : 0) + (!empty($data->exception_e2->PĐL138) ? $data->exception_e2->PĐL138 : 0) + (!empty($data->exception_e3->PĐL138) ? $data->exception_e3->PĐL138 : 0) + (!empty($data->exception_e4->PĐL138) ? $data->exception_e4->PĐL138 : 0) + (!empty($data->exception_e5->PĐL138) ? $data->exception_e5->PĐL138 : 0) + (!empty($data->exception_e6->PĐL138) ? $data->exception_e6->PĐL138 : 0) + (!empty($data->exception_e7->PĐL138) ? $data->exception_e7->PĐL138 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->PĐL138) ? $data->exception_e1->PĐL138 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->PĐL138) ? $data->exception_e2->PĐL138 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->PĐL138) ? $data->exception_e3->PĐL138 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->PĐL138) ? $data->exception_e4->PĐL138 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->PĐL138) ? $data->exception_e5->PĐL138 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->PĐL138) ? $data->exception_e6->PĐL138 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->PĐL138) ? $data->exception_e7->PĐL138 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->PĐL138) ? $data->loan_increase->PĐL138 : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->PĐL138 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->PĐL138) ? $data->total_return->PĐL138 : 0) / (!empty($data->total_hs->PĐL138) ? ($data->total_hs->PĐL138) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->PĐL138 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->PĐL138) ? $data->total_cancel->PĐL138 : 0) / (!empty($data->total_hs->PĐL138) ? ($data->total_hs->PĐL138) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->PĐL138 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->PĐL138) ? $data->total_approval->PĐL138 : 0) / (!empty($data->total_hs->PĐL138) ? ($data->total_hs->PĐL138) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->PĐL138) ? $data->exception_e1->PĐL138 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->PĐL138) ? $data->exception_e2->PĐL138 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->PĐL138) ? $data->exception_e3->PĐL138 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->PĐL138) ? $data->exception_e4->PĐL138 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->PĐL138) ? $data->exception_e5->PĐL138 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->PĐL138) ? $data->exception_e6->PĐL138 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->PĐL138) ? $data->exception_e7->PĐL138 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if (((!empty($data->total_cancel->PĐL138) ? $data->total_cancel->PĐL138 : 0) + (!empty($data->total_approval->PĐL138) ? $data->total_approval->PĐL138 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->PĐL138) ? $data->loan_increase->PĐL138 : 0) / ((!empty($data->total_cancel->PĐL138) ? $data->total_cancel->PĐL138 : 0) + (!empty($data->total_approval->PĐL138) ? $data->total_approval->PĐL138 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>


									<tr>
										<td rowspan="2">286 Bình Tiên</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->BT286) ? $data->total_hs->BT286 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->BT286) ? number_format($data->sum_tgn->BT286) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->BT286) ? $data->total_return->BT286 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->BT286) ? $data->total_cancel->BT286 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->BT286) ? $data->total_approval->BT286 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->BT286) ? $data->exception_e1->BT286 : 0) + (!empty($data->exception_e2->BT286) ? $data->exception_e2->BT286 : 0) + (!empty($data->exception_e3->BT286) ? $data->exception_e3->BT286 : 0) + (!empty($data->exception_e4->BT286) ? $data->exception_e4->BT286 : 0) + (!empty($data->exception_e5->BT286) ? $data->exception_e5->BT286 : 0) + (!empty($data->exception_e6->BT286) ? $data->exception_e6->BT286 : 0) + (!empty($data->exception_e7->BT286) ? $data->exception_e7->BT286 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->BT286) ? $data->exception_e1->BT286 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->BT286) ? $data->exception_e2->BT286 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->BT286) ? $data->exception_e3->BT286 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->BT286) ? $data->exception_e4->BT286 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->BT286) ? $data->exception_e5->BT286 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->BT286) ? $data->exception_e6->BT286 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->BT286) ? $data->exception_e7->BT286 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->BT286) ? $data->loan_increase->BT286 : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->BT286 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->BT286) ? $data->total_return->BT286 : 0) / (!empty($data->total_hs->BT286) ? ($data->total_hs->BT286) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->BT286 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->BT286) ? $data->total_cancel->BT286 : 0) / (!empty($data->total_hs->BT286) ? ($data->total_hs->BT286) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->BT286 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->BT286) ? $data->total_approval->BT286 : 0) / (!empty($data->total_hs->BT286) ? ($data->total_hs->BT286) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->BT286) ? $data->exception_e1->BT286 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->BT286) ? $data->exception_e2->BT286 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->BT286) ? $data->exception_e3->BT286 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->BT286) ? $data->exception_e4->BT286 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->BT286) ? $data->exception_e5->BT286 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->BT286) ? $data->exception_e6->BT286 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->BT286) ? $data->exception_e7->BT286 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if (((!empty($data->total_cancel->BT286) ? $data->total_cancel->BT286 : 0) + (!empty($data->total_approval->BT286) ? $data->total_approval->BT286 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->BT286) ? $data->loan_increase->BT286 : 0) / ((!empty($data->total_cancel->BT286) ? $data->total_cancel->BT286 : 0) + (!empty($data->total_approval->BT286) ? $data->total_approval->BT286 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>


									<tr>
										<td rowspan="2">267 Âu Cơ</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->AC267) ? $data->total_hs->AC267 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->AC267) ? number_format($data->sum_tgn->AC267) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->AC267) ? $data->total_return->AC267 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->AC267) ? $data->total_cancel->AC267 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->AC267) ? $data->total_approval->AC267 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->AC267) ? $data->exception_e1->AC267 : 0) + (!empty($data->exception_e2->AC267) ? $data->exception_e2->AC267 : 0) + (!empty($data->exception_e3->AC267) ? $data->exception_e3->AC267 : 0) + (!empty($data->exception_e4->AC267) ? $data->exception_e4->AC267 : 0) + (!empty($data->exception_e5->AC267) ? $data->exception_e5->AC267 : 0) + (!empty($data->exception_e6->AC267) ? $data->exception_e6->AC267 : 0) + (!empty($data->exception_e7->AC267) ? $data->exception_e7->AC267 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->AC267) ? $data->exception_e1->AC267 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->AC267) ? $data->exception_e2->AC267 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->AC267) ? $data->exception_e3->AC267 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->AC267) ? $data->exception_e4->AC267 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->AC267) ? $data->exception_e5->AC267 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->AC267) ? $data->exception_e6->AC267 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->AC267) ? $data->exception_e7->AC267 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->AC267) ? $data->loan_increase->AC267 : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->AC267 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->AC267) ? $data->total_return->AC267 : 0) / (!empty($data->total_hs->AC267) ? ($data->total_hs->AC267) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->AC267 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->AC267) ? $data->total_cancel->AC267 : 0) / (!empty($data->total_hs->AC267) ? ($data->total_hs->AC267) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->AC267 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->AC267) ? $data->total_approval->AC267 : 0) / (!empty($data->total_hs->AC267) ? ($data->total_hs->AC267) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->AC267) ? $data->exception_e1->AC267 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->AC267) ? $data->exception_e2->AC267 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->AC267) ? $data->exception_e3->AC267 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->AC267) ? $data->exception_e4->AC267 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->AC267) ? $data->exception_e5->AC267 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->AC267) ? $data->exception_e6->AC267 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->AC267) ? $data->exception_e7->AC267 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if (((!empty($data->total_cancel->AC267) ? $data->total_cancel->AC267 : 0) + (!empty($data->total_approval->AC267) ? $data->total_approval->AC267 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->AC267) ? $data->loan_increase->AC267 : 0) / ((!empty($data->total_cancel->AC267) ? $data->total_cancel->AC267 : 0) + (!empty($data->total_approval->AC267) ? $data->total_approval->AC267 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>


									<tr>
										<td rowspan="2">131 Hiệp Bình</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->HB131) ? $data->total_hs->HB131 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->HB131) ? number_format($data->sum_tgn->HB131) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->HB131) ? $data->total_return->HB131 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->HB131) ? $data->total_cancel->HB131 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->HB131) ? $data->total_approval->HB131 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->HB131) ? $data->exception_e1->HB131 : 0) + (!empty($data->exception_e2->HB131) ? $data->exception_e2->HB131 : 0) + (!empty($data->exception_e3->HB131) ? $data->exception_e3->HB131 : 0) + (!empty($data->exception_e4->HB131) ? $data->exception_e4->HB131 : 0) + (!empty($data->exception_e5->HB131) ? $data->exception_e5->HB131 : 0) + (!empty($data->exception_e6->HB131) ? $data->exception_e6->HB131 : 0) + (!empty($data->exception_e7->HB131) ? $data->exception_e7->HB131 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->HB131) ? $data->exception_e1->HB131 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->HB131) ? $data->exception_e2->HB131 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->HB131) ? $data->exception_e3->HB131 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->HB131) ? $data->exception_e4->HB131 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->HB131) ? $data->exception_e5->HB131 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->HB131) ? $data->exception_e6->HB131 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->HB131) ? $data->exception_e7->HB131 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->HB131) ? $data->loan_increase->HB131 : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->HB131 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->HB131) ? $data->total_return->HB131 : 0) / (!empty($data->total_hs->HB131) ? ($data->total_hs->HB131) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->HB131 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->HB131) ? $data->total_cancel->HB131 : 0) / (!empty($data->total_hs->HB131) ? ($data->total_hs->HB131) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->HB131 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->HB131) ? $data->total_approval->HB131 : 0) / (!empty($data->total_hs->HB131) ? ($data->total_hs->HB131) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->HB131) ? $data->exception_e1->HB131 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->HB131) ? $data->exception_e2->HB131 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->HB131) ? $data->exception_e3->HB131 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->HB131) ? $data->exception_e4->HB131 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->HB131) ? $data->exception_e5->HB131 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->HB131) ? $data->exception_e6->HB131 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->HB131) ? $data->exception_e7->HB131 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if (((!empty($data->total_cancel->HB131) ? $data->total_cancel->HB131 : 0) + (!empty($data->total_approval->HB131) ? $data->total_approval->HB131 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->HB131) ? $data->loan_increase->HB131 : 0) / ((!empty($data->total_cancel->HB131) ? $data->total_cancel->HB131 : 0) + (!empty($data->total_approval->HB131) ? $data->total_approval->HB131 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>


									<tr>
										<td rowspan="2">412 Cách Mạng Tháng 8</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->CMT8) ? $data->total_hs->CMT8 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->CMT8) ? number_format($data->sum_tgn->CMT8) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->CMT8) ? $data->total_return->CMT8 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->CMT8) ? $data->total_cancel->CMT8 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->CMT8) ? $data->total_approval->CMT8 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->CMT8) ? $data->exception_e1->CMT8 : 0) + (!empty($data->exception_e2->CMT8) ? $data->exception_e2->CMT8 : 0) + (!empty($data->exception_e3->CMT8) ? $data->exception_e3->CMT8 : 0) + (!empty($data->exception_e4->CMT8) ? $data->exception_e4->CMT8 : 0) + (!empty($data->exception_e5->CMT8) ? $data->exception_e5->CMT8 : 0) + (!empty($data->exception_e6->CMT8) ? $data->exception_e6->CMT8 : 0) + (!empty($data->exception_e7->CMT8) ? $data->exception_e7->CMT8 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->CMT8) ? $data->exception_e1->CMT8 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->CMT8) ? $data->exception_e2->CMT8 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->CMT8) ? $data->exception_e3->CMT8 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->CMT8) ? $data->exception_e4->CMT8 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->CMT8) ? $data->exception_e5->CMT8 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->CMT8) ? $data->exception_e6->CMT8 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->CMT8) ? $data->exception_e7->CMT8 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->CMT8) ? $data->loan_increase->CMT8 : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->CMT8 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->CMT8) ? $data->total_return->CMT8 : 0) / (!empty($data->total_hs->CMT8) ? ($data->total_hs->CMT8) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->CMT8 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->CMT8) ? $data->total_cancel->CMT8 : 0) / (!empty($data->total_hs->CMT8) ? ($data->total_hs->CMT8) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->CMT8 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->CMT8) ? $data->total_approval->CMT8 : 0) / (!empty($data->total_hs->CMT8) ? ($data->total_hs->CMT8) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->CMT8) ? $data->exception_e1->CMT8 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->CMT8) ? $data->exception_e2->CMT8 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->CMT8) ? $data->exception_e3->CMT8 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->CMT8) ? $data->exception_e4->CMT8 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->CMT8) ? $data->exception_e5->CMT8 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->CMT8) ? $data->exception_e6->CMT8 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->CMT8) ? $data->exception_e7->CMT8 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if (((!empty($data->total_cancel->CMT8) ? $data->total_cancel->CMT8 : 0) + (!empty($data->total_approval->CMT8) ? $data->total_approval->CMT8 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->CMT8) ? $data->loan_increase->CMT8 : 0) / ((!empty($data->total_cancel->CMT8) ? $data->total_cancel->CMT8 : 0) + (!empty($data->total_approval->CMT8) ? $data->total_approval->CMT8 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>


									<tr>
										<td rowspan="2">81 Liêu Bình Hương</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->LBH81) ? $data->total_hs->LBH81 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->LBH81) ? number_format($data->sum_tgn->LBH81) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->LBH81) ? $data->total_return->LBH81 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->LBH81) ? $data->total_cancel->LBH81 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->LBH81) ? $data->total_approval->LBH81 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->LBH81) ? $data->exception_e1->LBH81 : 0) + (!empty($data->exception_e2->LBH81) ? $data->exception_e2->LBH81 : 0) + (!empty($data->exception_e3->LBH81) ? $data->exception_e3->LBH81 : 0) + (!empty($data->exception_e4->LBH81) ? $data->exception_e4->LBH81 : 0) + (!empty($data->exception_e5->LBH81) ? $data->exception_e5->LBH81 : 0) + (!empty($data->exception_e6->LBH81) ? $data->exception_e6->LBH81 : 0) + (!empty($data->exception_e7->LBH81) ? $data->exception_e7->LBH81 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->LBH81) ? $data->exception_e1->LBH81 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->LBH81) ? $data->exception_e2->LBH81 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->LBH81) ? $data->exception_e3->LBH81 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->LBH81) ? $data->exception_e4->LBH81 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->LBH81) ? $data->exception_e5->LBH81 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->LBH81) ? $data->exception_e6->LBH81 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->LBH81) ? $data->exception_e7->LBH81 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->LBH81) ? $data->loan_increase->LBH81 : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->LBH81 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->LBH81) ? $data->total_return->LBH81 : 0) / (!empty($data->total_hs->LBH81) ? ($data->total_hs->LBH81) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->LBH81 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->LBH81) ? $data->total_cancel->LBH81 : 0) / (!empty($data->total_hs->LBH81) ? ($data->total_hs->LBH81) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->LBH81 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->LBH81) ? $data->total_approval->LBH81 : 0) / (!empty($data->total_hs->LBH81) ? ($data->total_hs->LBH81) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->LBH81) ? $data->exception_e1->LBH81 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->LBH81) ? $data->exception_e2->LBH81 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->LBH81) ? $data->exception_e3->LBH81 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->LBH81) ? $data->exception_e4->LBH81 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->LBH81) ? $data->exception_e5->LBH81 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->LBH81) ? $data->exception_e6->LBH81 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->LBH81) ? $data->exception_e7->LBH81 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if (((!empty($data->total_cancel->LBH81) ? $data->total_cancel->LBH81 : 0) + (!empty($data->total_approval->LBH81) ? $data->total_approval->LBH81 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->LBH81) ? $data->loan_increase->LBH81 : 0) / ((!empty($data->total_cancel->LBH81) ? $data->total_cancel->LBH81 : 0) + (!empty($data->total_approval->LBH81) ? $data->total_approval->LBH81 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>


									<tr>
										<td rowspan="2">28 Đỗ Xuân Hợp</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->ĐXH28) ? $data->total_hs->ĐXH28 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->ĐXH28) ? number_format($data->sum_tgn->ĐXH28) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->ĐXH28) ? $data->total_return->ĐXH28 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->ĐXH28) ? $data->total_cancel->ĐXH28 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->ĐXH28) ? $data->total_approval->ĐXH28 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->ĐXH28) ? $data->exception_e1->ĐXH28 : 0) + (!empty($data->exception_e2->ĐXH28) ? $data->exception_e2->ĐXH28 : 0) + (!empty($data->exception_e3->ĐXH28) ? $data->exception_e3->ĐXH28 : 0) + (!empty($data->exception_e4->ĐXH28) ? $data->exception_e4->ĐXH28 : 0) + (!empty($data->exception_e5->ĐXH28) ? $data->exception_e5->ĐXH28 : 0) + (!empty($data->exception_e6->ĐXH28) ? $data->exception_e6->ĐXH28 : 0) + (!empty($data->exception_e7->ĐXH28) ? $data->exception_e7->ĐXH28 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->ĐXH28) ? $data->exception_e1->ĐXH28 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->ĐXH28) ? $data->exception_e2->ĐXH28 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->ĐXH28) ? $data->exception_e3->ĐXH28 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->ĐXH28) ? $data->exception_e4->ĐXH28 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->ĐXH28) ? $data->exception_e5->ĐXH28 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->ĐXH28) ? $data->exception_e6->ĐXH28 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->ĐXH28) ? $data->exception_e7->ĐXH28 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->ĐXH28) ? $data->loan_increase->ĐXH28 : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->ĐXH28 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->ĐXH28) ? $data->total_return->ĐXH28 : 0) / (!empty($data->total_hs->ĐXH28) ? ($data->total_hs->ĐXH28) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->ĐXH28 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->ĐXH28) ? $data->total_cancel->ĐXH28 : 0) / (!empty($data->total_hs->ĐXH28) ? ($data->total_hs->ĐXH28) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->ĐXH28 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->ĐXH28) ? $data->total_approval->ĐXH28 : 0) / (!empty($data->total_hs->ĐXH28) ? ($data->total_hs->ĐXH28) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->ĐXH28) ? $data->exception_e1->ĐXH28 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->ĐXH28) ? $data->exception_e2->ĐXH28 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->ĐXH28) ? $data->exception_e3->ĐXH28 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->ĐXH28) ? $data->exception_e4->ĐXH28 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->ĐXH28) ? $data->exception_e5->ĐXH28 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->ĐXH28) ? $data->exception_e6->ĐXH28 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->ĐXH28) ? $data->exception_e7->ĐXH28 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if (((!empty($data->total_cancel->ĐXH28) ? $data->total_cancel->ĐXH28 : 0) + (!empty($data->total_approval->ĐXH28) ? $data->total_approval->ĐXH28 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->ĐXH28) ? $data->loan_increase->ĐXH28 : 0) / ((!empty($data->total_cancel->ĐXH28) ? $data->total_cancel->ĐXH28 : 0) + (!empty($data->total_approval->ĐXH28) ? $data->total_approval->ĐXH28 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>


									<tr>
										<td rowspan="2">246 Nguyễn An Ninh</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->NAN246) ? $data->total_hs->NAN246 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->NAN246) ? number_format($data->sum_tgn->NAN246) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->NAN246) ? $data->total_return->NAN246 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->NAN246) ? $data->total_cancel->NAN246 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->NAN246) ? $data->total_approval->NAN246 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->NAN246) ? $data->exception_e1->NAN246 : 0) + (!empty($data->exception_e2->NAN246) ? $data->exception_e2->NAN246 : 0) + (!empty($data->exception_e3->NAN246) ? $data->exception_e3->NAN246 : 0) + (!empty($data->exception_e4->NAN246) ? $data->exception_e4->NAN246 : 0) + (!empty($data->exception_e5->NAN246) ? $data->exception_e5->NAN246 : 0) + (!empty($data->exception_e6->NAN246) ? $data->exception_e6->NAN246 : 0) + (!empty($data->exception_e7->NAN246) ? $data->exception_e7->NAN246 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->NAN246) ? $data->exception_e1->NAN246 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->NAN246) ? $data->exception_e2->NAN246 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->NAN246) ? $data->exception_e3->NAN246 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->NAN246) ? $data->exception_e4->NAN246 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->NAN246) ? $data->exception_e5->NAN246 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->NAN246) ? $data->exception_e6->NAN246 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->NAN246) ? $data->exception_e7->NAN246 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->NAN246) ? $data->loan_increase->NAN246 : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->NAN246 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->NAN246) ? $data->total_return->NAN246 : 0) / (!empty($data->total_hs->NAN246) ? ($data->total_hs->NAN246) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->NAN246 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->NAN246) ? $data->total_cancel->NAN246 : 0) / (!empty($data->total_hs->NAN246) ? ($data->total_hs->NAN246) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->NAN246 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->NAN246) ? $data->total_approval->NAN246 : 0) / (!empty($data->total_hs->NAN246) ? ($data->total_hs->NAN246) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->NAN246) ? $data->exception_e1->NAN246 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->NAN246) ? $data->exception_e2->NAN246 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->NAN246) ? $data->exception_e3->NAN246 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->NAN246) ? $data->exception_e4->NAN246 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->NAN246) ? $data->exception_e5->NAN246 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->NAN246) ? $data->exception_e6->NAN246 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->NAN246) ? $data->exception_e7->NAN246 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if (((!empty($data->total_cancel->NAN246) ? $data->total_cancel->NAN246 : 0) + (!empty($data->total_approval->NAN246) ? $data->total_approval->NAN246 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->NAN246) ? $data->loan_increase->NAN246 : 0) / ((!empty($data->total_cancel->NAN246) ? $data->total_cancel->NAN246 : 0) + (!empty($data->total_approval->NAN246) ? $data->total_approval->NAN246 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>


									<tr>
										<td rowspan="2">133 Lê Văn Việt</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->LVV133) ? $data->total_hs->LVV133 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->LVV133) ? number_format($data->sum_tgn->LVV133) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->LVV133) ? $data->total_return->LVV133 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->LVV133) ? $data->total_cancel->LVV133 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->LVV133) ? $data->total_approval->LVV133 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->LVV133) ? $data->exception_e1->LVV133 : 0) + (!empty($data->exception_e2->LVV133) ? $data->exception_e2->LVV133 : 0) + (!empty($data->exception_e3->LVV133) ? $data->exception_e3->LVV133 : 0) + (!empty($data->exception_e4->LVV133) ? $data->exception_e4->LVV133 : 0) + (!empty($data->exception_e5->LVV133) ? $data->exception_e5->LVV133 : 0) + (!empty($data->exception_e6->LVV133) ? $data->exception_e6->LVV133 : 0) + (!empty($data->exception_e7->LVV133) ? $data->exception_e7->LVV133 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->LVV133) ? $data->exception_e1->LVV133 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->LVV133) ? $data->exception_e2->LVV133 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->LVV133) ? $data->exception_e3->LVV133 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->LVV133) ? $data->exception_e4->LVV133 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->LVV133) ? $data->exception_e5->LVV133 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->LVV133) ? $data->exception_e6->LVV133 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->LVV133) ? $data->exception_e7->LVV133 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->LVV133) ? $data->loan_increase->LVV133 : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->LVV133 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->LVV133) ? $data->total_return->LVV133 : 0) / (!empty($data->total_hs->LVV133) ? ($data->total_hs->LVV133) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->LVV133 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->LVV133) ? $data->total_cancel->LVV133 : 0) / (!empty($data->total_hs->LVV133) ? ($data->total_hs->LVV133) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->LVV133 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->LVV133) ? $data->total_approval->LVV133 : 0) / (!empty($data->total_hs->LVV133) ? ($data->total_hs->LVV133) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->LVV133) ? $data->exception_e1->LVV133 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->LVV133) ? $data->exception_e2->LVV133 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->LVV133) ? $data->exception_e3->LVV133 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->LVV133) ? $data->exception_e4->LVV133 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->LVV133) ? $data->exception_e5->LVV133 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->LVV133) ? $data->exception_e6->LVV133 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->LVV133) ? $data->exception_e7->LVV133 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if (((!empty($data->total_cancel->LVV133) ? $data->total_cancel->LVV133 : 0) + (!empty($data->total_approval->LVV133) ? $data->total_approval->LVV133 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->LVV133) ? $data->loan_increase->LVV133 : 0) / ((!empty($data->total_cancel->LVV133) ? $data->total_cancel->LVV133 : 0) + (!empty($data->total_approval->LVV133) ? $data->total_approval->LVV133 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>


									<tr>
										<td rowspan="2">662 Lê Văn Khương</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->LVK662) ? $data->total_hs->LVK662 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->LVK662) ? number_format($data->sum_tgn->LVK662) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->LVK662) ? $data->total_return->LVK662 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->LVK662) ? $data->total_cancel->LVK662 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->LVK662) ? $data->total_approval->LVK662 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->LVK662) ? $data->exception_e1->LVK662 : 0) + (!empty($data->exception_e2->LVK662) ? $data->exception_e2->LVK662 : 0) + (!empty($data->exception_e3->LVK662) ? $data->exception_e3->LVK662 : 0) + (!empty($data->exception_e4->LVK662) ? $data->exception_e4->LVK662 : 0) + (!empty($data->exception_e5->LVK662) ? $data->exception_e5->LVK662 : 0) + (!empty($data->exception_e6->LVK662) ? $data->exception_e6->LVK662 : 0) + (!empty($data->exception_e7->LVK662) ? $data->exception_e7->LVK662 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->LVK662) ? $data->exception_e1->LVK662 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->LVK662) ? $data->exception_e2->LVK662 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->LVK662) ? $data->exception_e3->LVK662 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->LVK662) ? $data->exception_e4->LVK662 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->LVK662) ? $data->exception_e5->LVK662 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->LVK662) ? $data->exception_e6->LVK662 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->LVK662) ? $data->exception_e7->LVK662 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->LVK662) ? $data->loan_increase->LVK662 : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->LVK662 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->LVK662) ? $data->total_return->LVK662 : 0) / (!empty($data->total_hs->LVK662) ? ($data->total_hs->LVK662) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->LVK662 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->LVK662) ? $data->total_cancel->LVK662 : 0) / (!empty($data->total_hs->LVK662) ? ($data->total_hs->LVK662) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->LVK662 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->LVK662) ? $data->total_approval->LVK662 : 0) / (!empty($data->total_hs->LVK662) ? ($data->total_hs->LVK662) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->LVK662) ? $data->exception_e1->LVK662 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->LVK662) ? $data->exception_e2->LVK662 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->LVK662) ? $data->exception_e3->LVK662 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->LVK662) ? $data->exception_e4->LVK662 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->LVK662) ? $data->exception_e5->LVK662 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->LVK662) ? $data->exception_e6->LVK662 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->LVK662) ? $data->exception_e7->LVK662 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if (((!empty($data->total_cancel->LVK662) ? $data->total_cancel->LVK662 : 0) + (!empty($data->total_approval->LVK662) ? $data->total_approval->LVK662 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->LVK662) ? $data->loan_increase->LVK662 : 0) / ((!empty($data->total_cancel->LVK662) ? $data->total_cancel->LVK662 : 0) + (!empty($data->total_approval->LVK662) ? $data->total_approval->LVK662 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>


									<tr>
										<td rowspan="2">2/1A Phan Văn Hớn</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->PVH21A) ? $data->total_hs->PVH21A : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->PVH21A) ? number_format($data->sum_tgn->PVH21A) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->PVH21A) ? $data->total_return->PVH21A : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->PVH21A) ? $data->total_cancel->PVH21A : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->PVH21A) ? $data->total_approval->PVH21A : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->PVH21A) ? $data->exception_e1->PVH21A : 0) + (!empty($data->exception_e2->PVH21A) ? $data->exception_e2->PVH21A : 0) + (!empty($data->exception_e3->PVH21A) ? $data->exception_e3->PVH21A : 0) + (!empty($data->exception_e4->PVH21A) ? $data->exception_e4->PVH21A : 0) + (!empty($data->exception_e5->PVH21A) ? $data->exception_e5->PVH21A : 0) + (!empty($data->exception_e6->PVH21A) ? $data->exception_e6->PVH21A : 0) + (!empty($data->exception_e7->PVH21A) ? $data->exception_e7->PVH21A : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->PVH21A) ? $data->exception_e1->PVH21A : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->PVH21A) ? $data->exception_e2->PVH21A : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->PVH21A) ? $data->exception_e3->PVH21A : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->PVH21A) ? $data->exception_e4->PVH21A : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->PVH21A) ? $data->exception_e5->PVH21A : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->PVH21A) ? $data->exception_e6->PVH21A : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->PVH21A) ? $data->exception_e7->PVH21A : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->PVH21A) ? $data->loan_increase->PVH21A : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->PVH21A != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->PVH21A) ? $data->total_return->PVH21A : 0) / (!empty($data->total_hs->PVH21A) ? ($data->total_hs->PVH21A) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->PVH21A != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->PVH21A) ? $data->total_cancel->PVH21A : 0) / (!empty($data->total_hs->PVH21A) ? ($data->total_hs->PVH21A) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->PVH21A != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->PVH21A) ? $data->total_approval->PVH21A : 0) / (!empty($data->total_hs->PVH21A) ? ($data->total_hs->PVH21A) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->PVH21A) ? $data->exception_e1->PVH21A : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->PVH21A) ? $data->exception_e2->PVH21A : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->PVH21A) ? $data->exception_e3->PVH21A : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->PVH21A) ? $data->exception_e4->PVH21A : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->PVH21A) ? $data->exception_e5->PVH21A : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->PVH21A) ? $data->exception_e6->PVH21A : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->PVH21A) ? $data->exception_e7->PVH21A : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if (((!empty($data->total_cancel->PVH21A) ? $data->total_cancel->PVH21A : 0) + (!empty($data->total_approval->PVH21A) ? $data->total_approval->PVH21A : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->PVH21A) ? $data->loan_increase->PVH21A : 0) / ((!empty($data->total_cancel->PVH21A) ? $data->total_cancel->PVH21A : 0) + (!empty($data->total_approval->PVH21A) ? $data->total_approval->PVH21A : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>


									<tr>
										<td rowspan="6">Mekong</td>
										<td rowspan="2">63 Đường 26 tháng 3</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->Đ26T3) ? $data->total_hs->Đ26T3 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->Đ26T3) ? number_format($data->sum_tgn->Đ26T3) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->Đ26T3) ? $data->total_return->Đ26T3 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->Đ26T3) ? $data->total_cancel->Đ26T3 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->Đ26T3) ? $data->total_approval->Đ26T3 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->Đ26T3) ? $data->exception_e1->Đ26T3 : 0) + (!empty($data->exception_e2->Đ26T3) ? $data->exception_e2->Đ26T3 : 0) + (!empty($data->exception_e3->Đ26T3) ? $data->exception_e3->Đ26T3 : 0) + (!empty($data->exception_e4->Đ26T3) ? $data->exception_e4->Đ26T3 : 0) + (!empty($data->exception_e5->Đ26T3) ? $data->exception_e5->Đ26T3 : 0) + (!empty($data->exception_e6->Đ26T3) ? $data->exception_e6->Đ26T3 : 0) + (!empty($data->exception_e7->Đ26T3) ? $data->exception_e7->Đ26T3 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->Đ26T3) ? $data->exception_e1->Đ26T3 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->Đ26T3) ? $data->exception_e2->Đ26T3 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->Đ26T3) ? $data->exception_e3->Đ26T3 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->Đ26T3) ? $data->exception_e4->Đ26T3 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->Đ26T3) ? $data->exception_e5->Đ26T3 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->Đ26T3) ? $data->exception_e6->Đ26T3 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->Đ26T3) ? $data->exception_e7->Đ26T3 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->Đ26T3) ? $data->loan_increase->Đ26T3 : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->Đ26T3 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->Đ26T3) ? $data->total_return->Đ26T3 : 0) / (!empty($data->total_hs->Đ26T3) ? ($data->total_hs->Đ26T3) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->Đ26T3 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->Đ26T3) ? $data->total_cancel->Đ26T3 : 0) / (!empty($data->total_hs->Đ26T3) ? ($data->total_hs->Đ26T3) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->Đ26T3 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->Đ26T3) ? $data->total_approval->Đ26T3 : 0) / (!empty($data->total_hs->Đ26T3) ? ($data->total_hs->Đ26T3) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->Đ26T3) ? $data->exception_e1->Đ26T3 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->Đ26T3) ? $data->exception_e2->Đ26T3 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->Đ26T3) ? $data->exception_e3->Đ26T3 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->Đ26T3) ? $data->exception_e4->Đ26T3 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->Đ26T3) ? $data->exception_e5->Đ26T3 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->Đ26T3) ? $data->exception_e6->Đ26T3 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->Đ26T3) ? $data->exception_e7->Đ26T3 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if (((!empty($data->total_cancel->Đ26T3) ? $data->total_cancel->Đ26T3 : 0) + (!empty($data->total_approval->Đ26T3) ? $data->total_approval->Đ26T3 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->Đ26T3) ? $data->loan_increase->Đ26T3 : 0) / ((!empty($data->total_cancel->Đ26T3) ? $data->total_cancel->Đ26T3 : 0) + (!empty($data->total_approval->Đ26T3) ? $data->total_approval->Đ26T3 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>

									<tr>
										<td rowspan="2">1797 Trần Hưng Đạo</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->THĐ1797) ? $data->total_hs->THĐ1797 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->THĐ1797) ? number_format($data->sum_tgn->THĐ1797) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->THĐ1797) ? $data->total_return->THĐ1797 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->THĐ1797) ? $data->total_cancel->THĐ1797 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->THĐ1797) ? $data->total_approval->THĐ1797 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->THĐ1797) ? $data->exception_e1->THĐ1797 : 0) + (!empty($data->exception_e2->THĐ1797) ? $data->exception_e2->THĐ1797 : 0) + (!empty($data->exception_e3->THĐ1797) ? $data->exception_e3->THĐ1797 : 0) + (!empty($data->exception_e4->THĐ1797) ? $data->exception_e4->THĐ1797 : 0) + (!empty($data->exception_e5->THĐ1797) ? $data->exception_e5->THĐ1797 : 0) + (!empty($data->exception_e6->THĐ1797) ? $data->exception_e6->THĐ1797 : 0) + (!empty($data->exception_e7->THĐ1797) ? $data->exception_e7->THĐ1797 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->THĐ1797) ? $data->exception_e1->THĐ1797 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->THĐ1797) ? $data->exception_e2->THĐ1797 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->THĐ1797) ? $data->exception_e3->THĐ1797 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->THĐ1797) ? $data->exception_e4->THĐ1797 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->THĐ1797) ? $data->exception_e5->THĐ1797 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->THĐ1797) ? $data->exception_e6->THĐ1797 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->THĐ1797) ? $data->exception_e7->THĐ1797 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->THĐ1797) ? $data->loan_increase->THĐ1797 : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->THĐ1797 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->THĐ1797) ? $data->total_return->THĐ1797 : 0) / (!empty($data->total_hs->THĐ1797) ? ($data->total_hs->THĐ1797) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->THĐ1797 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->THĐ1797) ? $data->total_cancel->THĐ1797 : 0) / (!empty($data->total_hs->THĐ1797) ? ($data->total_hs->THĐ1797) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->THĐ1797 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->THĐ1797) ? $data->total_approval->THĐ1797 : 0) / (!empty($data->total_hs->THĐ1797) ? ($data->total_hs->THĐ1797) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->THĐ1797) ? $data->exception_e1->THĐ1797 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->THĐ1797) ? $data->exception_e2->THĐ1797 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->THĐ1797) ? $data->exception_e3->THĐ1797 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->THĐ1797) ? $data->exception_e4->THĐ1797 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->THĐ1797) ? $data->exception_e5->THĐ1797 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->THĐ1797) ? $data->exception_e6->THĐ1797 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->THĐ1797) ? $data->exception_e7->THĐ1797 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if (((!empty($data->total_cancel->THĐ1797) ? $data->total_cancel->THĐ1797 : 0) + (!empty($data->total_approval->THĐ1797) ? $data->total_approval->THĐ1797 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->THĐ1797) ? $data->loan_increase->THĐ1797 : 0) / ((!empty($data->total_cancel->THĐ1797) ? $data->total_cancel->THĐ1797 : 0) + (!empty($data->total_approval->THĐ1797) ? $data->total_approval->THĐ1797 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>


									<tr>
										<td rowspan="2">308 Đường 30/4</td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->total_hs->Đ304308) ? $data->total_hs->Đ304308 : 0 ?></td>
										<td rowspan="2"
											style="text-align: center"><?= !empty($data->sum_tgn->Đ304308) ? number_format($data->sum_tgn->Đ304308) : 0 ?>
											đồng
										</td>
										<td style="text-align: center"><?= !empty($data->total_return->Đ304308) ? $data->total_return->Đ304308 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_cancel->Đ304308) ? $data->total_cancel->Đ304308 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->total_approval->Đ304308) ? $data->total_approval->Đ304308 : 0 ?></td>
										<td style="text-align: center"><?= $total_hs = (!empty($data->exception_e1->Đ304308) ? $data->exception_e1->Đ304308 : 0) + (!empty($data->exception_e2->Đ304308) ? $data->exception_e2->Đ304308 : 0) + (!empty($data->exception_e3->Đ304308) ? $data->exception_e3->Đ304308 : 0) + (!empty($data->exception_e4->Đ304308) ? $data->exception_e4->Đ304308 : 0) + (!empty($data->exception_e5->Đ304308) ? $data->exception_e5->Đ304308 : 0) + (!empty($data->exception_e6->Đ304308) ? $data->exception_e6->Đ304308 : 0) + (!empty($data->exception_e7->Đ304308) ? $data->exception_e7->Đ304308 : 0) ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e1->Đ304308) ? $data->exception_e1->Đ304308 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e2->Đ304308) ? $data->exception_e2->Đ304308 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e3->Đ304308) ? $data->exception_e3->Đ304308 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e4->Đ304308) ? $data->exception_e4->Đ304308 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e5->Đ304308) ? $data->exception_e5->Đ304308 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e6->Đ304308) ? $data->exception_e6->Đ304308 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->exception_e7->Đ304308) ? $data->exception_e7->Đ304308 : 0 ?></td>
										<td style="text-align: center"><?= !empty($data->loan_increase->Đ304308) ? $data->loan_increase->Đ304308 : 0 ?></td>

									</tr>

									<tr>
										<?php if ($data->total_hs->Đ304308 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_return->Đ304308) ? $data->total_return->Đ304308 : 0) / (!empty($data->total_hs->Đ304308) ? ($data->total_hs->Đ304308) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($data->total_hs->Đ304308 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_cancel->Đ304308) ? $data->total_cancel->Đ304308 : 0) / (!empty($data->total_hs->Đ304308) ? ($data->total_hs->Đ304308) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($data->total_hs->Đ304308 != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->total_approval->Đ304308) ? $data->total_approval->Đ304308 : 0) / (!empty($data->total_hs->Đ304308) ? ($data->total_hs->Đ304308) : 0)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<td></td>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e1->Đ304308) ? $data->exception_e1->Đ304308 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e2->Đ304308) ? $data->exception_e2->Đ304308 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e3->Đ304308) ? $data->exception_e3->Đ304308 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e4->Đ304308) ? $data->exception_e4->Đ304308 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e5->Đ304308) ? $data->exception_e5->Đ304308 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e6->Đ304308) ? $data->exception_e6->Đ304308 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>


										<?php if ($total_hs != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->exception_e7->Đ304308) ? $data->exception_e7->Đ304308 : 0) / ($total_hs)) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>

										<?php if (((!empty($data->total_cancel->Đ304308) ? $data->total_cancel->Đ304308 : 0) + (!empty($data->total_approval->Đ304308) ? $data->total_approval->Đ304308 : 0)) != 0): ?>
											<td style="text-align: center"><?= number_format((((!empty($data->loan_increase->Đ304308) ? $data->loan_increase->Đ304308 : 0) / ((!empty($data->total_cancel->Đ304308) ? $data->total_cancel->Đ304308 : 0) + (!empty($data->total_approval->Đ304308) ? $data->total_approval->Đ304308 : 0))) * 100), 2) ?>
												%
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									</tr>
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


<!-- /page content -->
<script src="<?php echo base_url(); ?>assets/js/gic/index.js"></script>
<script src="<?php echo base_url(); ?>assets/js/switchery/switchery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/activeit.min.js"></script>





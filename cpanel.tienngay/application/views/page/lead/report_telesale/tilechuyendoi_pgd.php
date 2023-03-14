<div class="right_col" role="main">

		<?php
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$area = !empty($_GET['area']) ? $_GET['area'] : "";
		$store = !empty($_GET['store']) ? trim($_GET['store']) : "";
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
					<h3>BÁO CÁO TỈ LỆ CHUYỂN ĐỔI GN PGD</h3>
				</div>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-xs-12 col-md-6">
							<h2>Danh sách phòng giao dịch</h2>
						</div>
						<div class="col-xs-12 col-md-6 text-right">

							<button class="show-hide-total-all btn btn-success dropdown-toggle"
									onclick="$('#lockdulieu').toggleClass('show');">
								<span class="fa fa-filter"></span>
								Lọc dữ liệu
							</button>
							<form action="<?php echo base_url('report_telesale/search_tilechuyendoi') ?>" method="get">
								<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
									style="padding:15px;min-width:400px;">

									<li class="form-group">
										<div class="row">
											<div class="col-xs-12 col-md-6">
												<div class="form-group">
													<label>Từ:</label>
													<input type="datetime-local" name="fdate" class="form-control"
														   value="<?= !empty($fdate) ? $fdate : "" ?>">
												</div>
											</div>
											<div class="col-xs-12 col-md-6">
												<div class="form-group">
													<label>Đến:</label>
													<input type="datetime-local" name="tdate" class="form-control"
														   value="<?= !empty($tdate) ? $tdate : "" ?>">
												</div>
											</div>
										</div>
									</li>


									<li class="form-group">
										<label>Khu vực: </label>
										<select class="form-control" name="area">
											<option value="">-- Chọn khu vực --</option>
											<?php foreach ($areaData as $item): ?>
												<option value="<?= ($item->code) ?>" <?= ($area == ($item->code)) ? "selected" : "" ?>><?= $item->title ?></option>
											<?php endforeach; ?>

										</select>
									</li>

									<li class="form-group">
										<label>Phòng giao dịch: </label>
										<select class="form-control" name="store">
											<option value="">-- Chọn phòng giao dịch --</option>
											<?php foreach ($stores as $value): ?>
												<option value="<?php echo trim($value->name)?> <?= (trim($store) == trim($value->name)) ? "selected" : "" ?>"><?= $value->name ?></option>
											<?php endforeach; ?>
										</select>
									</li>

									<li class="text-right">
										<button class="btn btn-info" type="submit">
											<i class="fa fa-search" aria-hidden="true"></i>
											Tìm Kiếm
										</button>
									</li>

								</ul>
							</form>

						</div>

						<div class="col-xs-12 col-md-6">
							<h2>Tổng số PGD: <?= !empty($result) ? count($result) : 0 ?></h2>
						</div>

					</div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="table-responsive">
						<table id="summary-total"
							   class="table table-bordered m-table table-hover table-calendar table-report"
							   style="font-size: 14px;font-weight: 400;">
							<thead style="background:#5A738E; color: #ffffff;">
							<tr>
								<th style="text-align: center">STT</th>
								<th style="text-align: center">Phòng giao dịch</th>
								<th style="text-align: center">Khu vực</th>
								<th style="text-align: center">Lead QLF</th>
								<th style="text-align: center">HĐ giải ngân</th>
								<th style="text-align: center">Tỉ lệ Lead QLF</th>
							</tr>
							</thead>
							<tbody>
							<?php if (!empty($result)): ?>
								<?php
								$total_lead_qlf = 0;
								$total_count_hd_giaingan = 0;
								?>
								<?php foreach ($result as $key => $value): ?>
									<tr>
										<td style="text-align: center"><?= ++$key ?></td>
										<td style="text-align: center"><?= !empty($value->name) ? $value->name : "" ?></td>
										<td style="text-align: center"><?= !empty($value->code_area) ? $value->code_area : "" ?></td>
										<td style="text-align: center"><?= !empty($value->lead_qlf) ? number_format($value->lead_qlf) : 0 ?></td>
										<td style="text-align: center"><?= !empty($value->count_hd_giaingan) ? number_format($value->count_hd_giaingan) : 0 ?></td>
										<td style="text-align: center">
											<?php
											if (!empty($value->lead_qlf) && !empty($value->count_hd_giaingan) && $value->lead_qlf != 0) {
												echo number_format((($value->count_hd_giaingan / $value->lead_qlf) * 100), 2) . "%";
											} else {
												echo 0 . "%";
											}
											?>
										</td>
									</tr>
									<?php
									$total_lead_qlf += $value->lead_qlf ;
									$total_count_hd_giaingan += $value->count_hd_giaingan ;
									?>
								<?php endforeach; ?>
								<tr style="background-color: #ffbbbb; color: red">
									<th style="text-align: center" colspan="3">TOTAL</th>
									<th style="text-align: center"><?= !empty($total_lead_qlf) ? number_format($total_lead_qlf) : 0 ?></th>
									<th style="text-align: center" ><?= !empty($total_count_hd_giaingan) ? number_format($total_count_hd_giaingan) : 0 ?></th>
									<th style="text-align: center" >
										<?php
										if (!empty($total_lead_qlf) && !empty($total_count_hd_giaingan) && $total_lead_qlf != 0) {
											echo number_format((($total_count_hd_giaingan / $total_lead_qlf) * 100), 2) . "%";
										} else {
											echo 0 . "%";
										}
										?>

									</th>


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


<!--Modal-->


<script src="<?php echo base_url("assets/") ?>js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets/") ?>js/numeral.min.js"></script>










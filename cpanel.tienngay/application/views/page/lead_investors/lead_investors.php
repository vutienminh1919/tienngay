<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

	?>
	<div class="row">
		<div class="col-xs-12">
			<div class="x_panel">
				<div class="">
					<h2>LEAD NHÀ ĐẦU TƯ / Tổng lead: <?= !empty($count) ? number_format($count) : 0 ?> </h2>
					<ul class="nav navbar-right panel_toolbox">

						<li>

							<div class="dropdown" style="display:inline-block">
								<button class="btn btn-success dropdown-toggle"
										onclick="$('#lockdulieu').toggleClass('show');">
									<span class="fa fa-filter"></span>
									Lọc dữ liệu
								</button>
								<form action="<?php echo base_url('lead_custom/search_investors') ?>" method="get">
									<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
										style="padding:15px;min-width:450px;">
										<li class="form-group">
											<div class="row">
												<div class="col-xs-12 col-md-6">
													<div class="form-group">
														<label>Từ:</label>
														<input type="date" name="fdate" class="form-control"
															   value="<?= !empty($fdate) ? $fdate : "" ?>">
													</div>
												</div>
												<div class="col-xs-12 col-md-6">
													<div class="form-group">
														<label>Đến:</label>
														<input type="date" name="tdate" class="form-control"
															   value="<?= !empty($tdate) ? $tdate : "" ?>">
													</div>
												</div>
											</div>
										</li>

										<li class="text-right">
											<button class="btn btn-info" type="submit">
												<i class="fa fa-search" aria-hidden="true"></i>
												Tìm Kiếm
											</button>
										</li>
								</form>
					</ul>
				</div>
			</div>
			<div class="x_content">

				<div class="row">

					<div class="col-xs-12 table-responsive">
						<!-- start project list -->
						<table class="table table-bordered m-table table-hover table-calendar table-report stacktable table-quanlytaisan">
							<thead style="background:#3f86c3; color: #ffffff;">
							<tr>
								<th style="width: 1%">#</th>
								<th>Ngày đăng ký</th>
								<th>Tên nhà đầu tư</th>
								<th>Số điện thoại</th>
								<th>Email</th>
								<th>Số tiền</th>
								<th>Khu vực</th>
								<th>Sđt người giới thiệu</th>
								<th>Utm_source</th>
								<th>Utm_campaign</th>
							</tr>
							</thead>
							<tbody>
							<?php if (!empty($lead_investors)): ?>
								<?php foreach ($lead_investors as $key => $value): ?>
									<tr>
										<td><?= ++$key ?></td>
										<td><?= !empty($value->created_at) ? date("d/m/y", $value->created_at) : "" ?></td>
										<td><?= !empty($value->fullname) ? $value->fullname : "" ?></td>
										<td><?= !empty($value->phone_number) ? $value->phone_number : "" ?></td>
										<td><?= !empty($value->email) ? $value->email : "" ?></td>
										<td><?= !empty($value->money) ? $value->money : "" ?></td>
										<td><?= !empty($value->area) ? $value->area : "" ?></td>
										<td><?= !empty($value->phone_ngt) ? $value->phone_ngt : "" ?></td>
										<td><?= !empty($value->utm_source) ? $value->utm_source : "" ?></td>
										<td><?= !empty($value->utm_campaign) ? $value->utm_campaign : "" ?></td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
							</tbody>
						</table>
						<!-- end project list -->
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


<script src="<?php echo base_url(); ?>assets/js/lead_investors/lead_investors.js"></script>


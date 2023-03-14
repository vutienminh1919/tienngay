<script src="https://code.highcharts.com/highcharts.src.js"></script>
<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
?>
<div class="right_col" role="main">
	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>
						Thống kê bảo hiểm
					</h3>
				</div>

			</div>
		</div>
	</div>
	<!-- 1st row -->
	<div class="row">
		<form action="<?php echo base_url('statistic/insurrance')?>" method="get" style="width: 100%;">
		<div class="row">
				<div class="col-lg-4">
					<div class="input-group">
						<span class="input-group-addon"><?php echo $this->lang->line('from')?></span>
						<input type="date" name="fdate" class="form-control" value="<?= !empty($fdate) ?  $fdate :  date('Y-m-01')?>" >
				</div>
			</div>
	<div class="col-lg-4">
					<div class="input-group">
<span class="input-group-addon"><?php echo $this->lang->line('to')?></span>
						<input type="date" name="tdate" class="form-control" value="<?= !empty($tdate) ?  $tdate : date('Y-m-d')?>" >
					</div>
				</div>
		<div class="col-lg-2 text-right">
					<button type="submit" class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i> Thống kê</button>
			</div>
			</div>
		</form>
	</div>
	<br/>
	<div class="row">
		<?php if ($this->session->flashdata('error')) { ?>
			<div class="col-xs-12">
				<div class="alert alert-danger alert-result">
					<?= $this->session->flashdata('error') ?>
				</div>
			</div>
		<?php } ?>

		<?php if ($this->session->flashdata('success')) { ?>
			<div class="col-xs-12">
				<div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
			</div>
		<?php } ?>
		<div class="col-xs-12 col-md-12">
			<div class="dashboarditem_line2 blue">
				<div class="thetitle">
					<i class="fa fa-file-text-o"></i> Tổng tất cả Bảo hiểm
				</div>
				<div class="panel panel-default">
					<table class="table table-borderless">
						<thead>
						<tr>
							<td>
								<p>Số lượng</p>
								<strong>ALL: <?= $data->insurrance->total ?></strong><br>
								<strong>GIC: <?= $data->insurrance->total_mic ?></strong><br>
								<strong>MIC: <?= $data->insurrance->total_gic ?></strong><br>
								<strong>VBI: <?= $data->insurrance->total_vbi ?></strong>
							</td>
						
							<td>
								<p>Tiền giải ngân</p>
								<strong>ALL: <?= formatNumber($data->insurrance->total_money) ?></strong><br>
								<strong>GIC: <?= formatNumber($data->insurrance->total_money_mic) ?></strong><br>
								<strong>MIC: <?= formatNumber($data->insurrance->total_money_gic) ?></strong><br>
								<strong>VBI: <?= formatNumber($data->insurrance->total_money_vbi) ?></strong>
							</td>
								<td>
								<p>Phí </p>
								<strong>ALL: <?= formatNumber($data->insurrance->total_fee) ?></strong><br>
								<strong>GIC: <?= formatNumber($data->insurrance->total_fee_mic) ?></strong><br>
								<strong>MIC: <?= formatNumber($data->insurrance->total_fee_gic) ?></strong><br>
								<strong>VBI: <?= formatNumber($data->insurrance->total_fee_vbi) ?></strong>
							</td>
						</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
		
	</div>

	<!-- 2nd row -->
	<div class="row">
		<div class="col-xs-12 col-md-6 col-lg-6">
			<div class="dashboarditem_line1 blue">
				<div class="thetitle">
					<i class="fa fa-user"></i> Bảo hiểm khoản vay
				</div>
				<div class="panel panel-default">
					<table class="table table-borderless">
						<thead>
						<tr>
							<td>
								<p>Số lượng </p>
								<strong>ALL: <?= $data->insurrance_kv->total ?></strong><br>
								<strong>MIC: <?= $data->insurrance_kv->total_mic ?></strong><br>
								<strong>GIC: <?= $data->insurrance_kv->total_gic ?></strong>
							</td>
							<td>
								<p>Tiền giải ngân </p>
							<strong>ALL: <?= formatNumber($data->insurrance_kv->total_money) ?></strong><br>
							<strong>MIC: <?= formatNumber($data->insurrance_kv->total_money_mic) ?></strong><br>
							<strong>GIC: <?= formatNumber($data->insurrance_kv->total_money_gic) ?></strong>
							</td>
							<td>
								<p>Phí </p>
								<strong>ALL: <?= formatNumber($data->insurrance_kv->total_fee) ?></strong><br>
								<strong>MIC: <?= formatNumber($data->insurrance_kv->total_fee_mic) ?></strong><br>
								<strong>GIC: <?= formatNumber($data->insurrance_kv->total_fee_gic) ?></strong>
							</td>
							
						</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
				<div class="col-xs-12 col-md-6 col-lg-6">
			<div class="dashboarditem_line1 orange">
				<div class="thetitle">
					<i class="fa fa-cubes"></i> Bảo hiểm xe máy
				</div>
				<div class="panel panel-default">
					<table class="table table-borderless">
						<thead>
						<tr>
							<td>
								<p>Số lượng </p>
								<strong>ALL: <?= $data->insurrance_easy->total ?></strong><br>
								<!-- <strong>MIC: <?= $data->insurrance_plt->total_mic ?></strong><br> -->
								<strong>GIC: <?= $data->insurrance_easy->total_gic ?></strong><br>
							</td>
							<td>
								<p>Tiền giải ngân </p>
							<strong>ALL: <?= formatNumber($data->insurrance_easy->total_money) ?></strong><br>
							<!-- <strong>MIC: <?= formatNumber($data->insurrance_plt->total_money_mic) ?></strong><br> -->
							<strong>GIC: <?= formatNumber($data->insurrance_easy->total_money_gic) ?></strong><br>
							</td>
							<td>
								<p>Phí </p>
								<strong>ALL: <?= formatNumber($data->insurrance_easy->total_fee) ?></strong><br>
								<!-- <strong>MIC: <?= formatNumber($data->insurrance_plt->total_fee_mic) ?></strong><br> -->
								<strong>GIC: <?= formatNumber($data->insurrance_easy->total_fee_gic) ?></strong>
							</td>
							
						</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
				<div class="col-xs-12 col-md-6 col-lg-6">
			<div class="dashboarditem_line1 orange">
				<div class="thetitle">
					<i class="fa fa-cubes"></i> Bảo hiểm phúc lộc thọ
				</div>
				<div class="panel panel-default">
					<table class="table table-borderless">
						<thead>
						<tr>
							<td>
								<p>Số lượng </p>
								<strong>ALL: <?= $data->insurrance_plt->total ?></strong><br>
								<!-- <strong>MIC: <?= $data->insurrance_plt->total_mic ?></strong><br> -->
								<strong>GIC: <?= $data->insurrance_plt->total_gic ?></strong><br>
							</td>
							<td>
								<p>Tiền giải ngân </p>
							<strong>ALL: <?= formatNumber($data->insurrance_plt->total_money) ?></strong><br>
							<!-- <strong>MIC: <?= formatNumber($data->insurrance_plt->total_money_mic) ?></strong><br> -->
							<strong>GIC: <?= formatNumber($data->insurrance_plt->total_money_gic) ?></strong><br>
							</td>
							<td>
								<p>Phí </p>
								<strong>ALL: <?= formatNumber($data->insurrance_plt->total_fee) ?></strong><br>
								<!-- <strong>MIC: <?= formatNumber($data->insurrance_plt->total_fee_mic) ?></strong><br> -->
								<strong>GIC: <?= formatNumber($data->insurrance_plt->total_fee_gic) ?></strong>
							</td>
							
						</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-md-6 col-lg-6">
			<div class="dashboarditem_line1 purple">
				<div class="thetitle">
					<i class="fa fa-files-o"></i> Bảo hiểm VBI
				</div>
				<div class="panel panel-default">
					<table class="table table-borderless">
						<thead>
						<tr>
							<td>
								<p>Số lượng </p>
								<strong>ALL: <?= $data->insurrance_vbi->total ?> </strong><br>
								<strong>VBI: <?= $data->insurrance_vbi->total_vbi ?></strong><br>
							</td>
							<td>
								<p>Tiền giải ngân </p>
								<strong>ALL: <?= formatNumber($data->insurrance_vbi->total_money) ?></strong><br>
								<strong>VBI: <?= formatNumber($data->insurrance_vbi->total_money_vbi) ?></strong><br>
							</td>
							<td>
								<p>Phí </p>
								<strong>ALL: <?= formatNumber($data->insurrance_vbi->total_fee) ?></strong><br>
								<strong>VBI: <?= formatNumber($data->insurrance_vbi->total_fee_vbi) ?></strong><br>
							</td>
						</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-md-6 col-lg-6">
			<div class="dashboarditem_line1 purple">
				<div class="thetitle">
					<i class="fa fa-files-o"></i> Bảo hiểm nhà đầu tư
				</div>
				<div class="panel panel-default">
					<table class="table table-borderless">
						<thead>
						<tr>
						<td>
								<p>Số lượng </p>
								<strong>ALL: <?= $data->insurrance_ndt->total ?></strong><br>
								<strong>MIC: <?= $data->insurrance_ndt->total_mic ?></strong><br>
								<!-- <strong>GIC: <?= $data->insurrance_ndt->total_gic ?></strong> -->
							</td>
							<td>
								<p>Tiền giải ngân </p>
								<strong>ALL: <?= formatNumber($data->insurrance_ndt->total_money) ?></strong><br>
								<strong>MIC: <?= formatNumber($data->insurrance_ndt->total_money_mic) ?></strong><br>
							<!-- 	<strong>GIC: <?= formatNumber($data->insurrance_ndt->total_money_gic) ?></strong> -->
							</td>
							<td>
								<p>Phí </p>
								<strong>ALL: <?= formatNumber($data->insurrance_ndt->total_fee) ?></strong><br>
								<strong>MIC: <?= formatNumber($data->insurrance_ndt->total_fee_mic) ?></strong><br>
								<!-- <strong>GIC: <?= formatNumber($data->insurrance_ndt->total_fee_gic) ?></strong> -->
							</td>
							
						</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>

		

		
	</div>

	<!-- 3rd row -->
	<div class="row">
		

	</div>

	<br>

	
</div>

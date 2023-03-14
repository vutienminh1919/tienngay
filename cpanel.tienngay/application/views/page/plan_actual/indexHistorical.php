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
						<h3>CF PLAN ACTUAL
						</h3>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="x_panel">
				<div class="x_title">
<!--					<div class="row">-->
<!--						<ul class="nav nav-tabs" style="margin-bottom: 20px">-->
<!--							<li role="presentation"><a href="--><?php //echo base_url() ?><!--plan_actual/indexPlanActual">CF</a>-->
<!--							</li>-->
<!--							<li role="presentation"><a href="--><?php //echo base_url() ?><!--plan_actual/indexBankBalance">Số dư-->
<!--									các TK NH</a></li>-->
<!--							<li role="presentation"><a-->
<!--									href="--><?php //echo base_url() ?><!--plan_actual/indexFollowVPS">Theo dõi VPS</a></li>-->
<!--							<li role="presentation"><a href="--><?php //echo base_url() ?><!--plan_actual/indexFollowDebt">Quản lý hợp đồng vay</a></li>-->
<!--							<li role="presentation"><a href="--><?php //echo base_url() ?><!--plan_actual/indexInvestor">Nhà đầu tư</a></li>-->
<!--							<li role="presentation"><a href="--><?php //echo base_url() ?><!--plan_actual/indexDisbursement">Giải-->
<!--									ngân Actual</a></li>-->
<!--							<li role="presentation" ><a href="--><?php //echo base_url() ?><!--plan_actual/indexCpWork">CP hoạt động</a></li>-->
<!--							<li role="presentation" class="active"><a-->
<!--									href="--><?php //echo base_url() ?><!--plan_actual/indexHistorical">Historical Data CP</a>-->
<!--							</li>-->
<!--						</ul>-->
<!--					</div>-->
				</div>

				<?php if ($this->session->flashdata('error')) { ?>
					<div class="alert alert-danger alert-result">
						<?= $this->session->flashdata('error') ?>
					</div>
				<?php } ?>

				<?php if ($this->session->flashdata('success')) { ?>
					<div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
				<?php } ?>

				<?php if (!empty($this->session->flashdata('notify'))) {
					$notify = $this->session->flashdata('notify'); ?>
					<?php foreach ($notify as $key => $value) { ?>
						<div class="alert alert-danger alert-result"><?= $value ?></div>
					<?php } ?>
				<?php } ?>
				<div class="clearfix"></div>

				<div class="row">
					<div class="col-xs-12 col-md-6">
						<div class="dashboarditem_line2 blue">
							<div class="thetitle">
								<i class="fa fa-upload"></i> Import Historical Data CP / <a target="_blank"
																							href="https://docs.google.com/spreadsheets/d/15zAVR_9wnNhupFmgh4XGCFgD2U6x_ZMrwhacQoD1QTQ/edit?usp=sharing"
																							download>Dowload File
									Mẫu </a>
							</div>
							<div class="panel panel-default">
								<form class="form-inline" id=""
									  action="<?php echo base_url('plan_actual/importHistorical') ?>"
									  enctype="multipart/form-data" method="post">
									<strong><?= $this->lang->line('Upload') ?>&nbsp;</strong>
									<div class="form-group">
										<input type="file" name="upload_file" class="form-control"
											   placeholder="sothing">
									</div>
									<button type="submit" class="btn btn-primary" id="on_loading"
											style="margin:0"><?= $this->lang->line('Upload') ?></button>
								</form>
							</div>
						</div>
					</div>

					<div class="col-xs-12 col-md-12" style="padding-top: 20px">
						<style>
							@media screen and (max-width: 1440px) {
								.flex-search{
									display: flex;
									gap: 7%;
									padding-left: 10px;
								}
							}
						</style>
						<form action="<?php echo base_url('plan_actual/indexHistorical') ?>" method="get"
							  style="width: 100%;">
							<div class="row flex-search">
								<div class="col-lg-2">
									<div class="input-group">
										<span class="input-group-addon">Tháng</span>
										<input type="month" name="month" class="form-control"
											   value="<?= isset($_GET['month']) ? $_GET['month'] : date('Y-m') ?>">
									</div>
								</div>

								<div class="col-lg-2" style="padding-left: 30px">
									<button type="submit" class="btn btn-primary w-100"><i class="fa fa-search"
																						   aria-hidden="true"></i> <?= $this->lang->line('search') ?>
									</button>
								</div>
							</div>
						</form>

					</div>

					<div class="table-responsive col-xs-12 col-md-12" style="overflow-y: auto; padding-top: 20px">
						<table
							class="table table-bordered m-table table-hover table-calendar table-report">

							<thead style="color: white;">
							<tr>
								<th style="text-align: center">STT</th>
								<th style="text-align: center">Code</th>
								<th style="text-align: center">Giả định thanh toán</th>
								<th style="text-align: center">Actual</th>
							</tr>
							</thead>
							<tbody>
							<?php if (!empty($data)): ?>
								<?php foreach($data as $key => $value): ?>
								<tr>
									<td style="text-align: center"><?= ++$key ?></td>
									<td style="text-align: center"><?= !empty($value->code) ? ($value->code) : '' ?></td>
									<td style="text-align: center"><?= !empty($value->gia_dinh_thanh_toan) ? number_format($value->gia_dinh_thanh_toan) : '' ?></td>
									<td style="text-align: center"><?= !empty($value->actual) ? number_format($value->actual) : '' ?></td>
								</tr>
									<?php endforeach; ?>
							<?php endif; ?>
							</tbody>
						</table>

					</div>

				</div>


			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url("assets") ?>/js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets") ?>/js/numeral.min.js"></script>

<style>
	.page-title {
		min-height: 0px;
		padding: 0px 0;
	}
</style>
<script>
	$("#on_loading").click(function (event) {
		$(".theloading").show()
	});
</script>

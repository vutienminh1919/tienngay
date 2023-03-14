<?php
$month = !empty($_GET['month']) ? $_GET['month'] : "";
?>
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
<!--							<li role="presentation"><a-->
<!--									href="--><?php //echo base_url() ?><!--plan_actual/indexFollowDebt">Quản lý hợp đồng vay</a></li>-->
<!--							<li role="presentation"><a href="--><?php //echo base_url() ?><!--plan_actual/indexInvestor">Nhà đầu tư</a></li>-->
<!--							<li role="presentation"><a href="--><?php //echo base_url() ?><!--plan_actual/indexDisbursement">Giải-->
<!--									ngân Actual</a></li>-->
<!--							<li role="presentation" class="active"><a-->
<!--									href="--><?php //echo base_url() ?><!--plan_actual/indexCpWork">CP hoạt động</a></li>-->
<!--							<li role="presentation"><a href="--><?php //echo base_url() ?><!--plan_actual/indexHistorical">Historical-->
<!--									Data CP</a></li>-->
<!--						</ul>-->
<!--					</div>-->
				</div>

				<style>
					@media screen and (max-width: 1440px) {
						.flex-search{
							display: flex;
							gap: 7%;
							padding-left: 10px;
						}
					}
				</style>

				<form action="<?php echo base_url('plan_actual/indexCpWork') ?>" method="get"
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

				<div class="row">

					<div class="col-xs-12 col-md-6">
					</div>


					<div class="table-responsive col-xs-12 col-md-12" style="overflow-y: auto; padding-top: 20px">
						<table
							class="table table-bordered m-table table-hover table-calendar table-report">

							<thead style="color: white;">
							<tr>
								<th style="text-align: center" colspan="2">BUDGET</th>
								<th style="text-align: center">Đợt 1 (Ngày 05)</th>
								<th style="text-align: center">Đợt 2 (Ngày 15)</th>
								<th style="text-align: center">Đợt 3 (Ngày 20)</th>
								<th style="text-align: center">Đợt 4 (Ngày 25)</th>
								<th style="text-align: center">Đợt 5 (Ngày cuối tháng)</th>
							</tr>
							</thead>
							<tbody>
							<tr style="background-color: #fbffba">
								<th style="text-align: center">Code</th>
								<th style="text-align: center">Đợt 1</th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
							</tr>
							<?php if (!empty($data_1)): ?>
								<?php foreach ($data_1 as $value): ?>
									<tr>
										<th style="text-align: center"><?= !empty($value->code) ? $value->code : '' ?></th>
										<th style="text-align: center"><?= !empty($value->code) ? name_code_data_cp($value->code) : '' ?></th>
										<th style="text-align: center"><?= !empty($value->gia_dinh_thanh_toan) ? number_format($value->gia_dinh_thanh_toan) : '' ?></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"></th>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
							<tr style="background-color: #fbffba">
								<th style="text-align: center">Code</th>
								<th style="text-align: center">Đợt 2</th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
							</tr>
							<?php if (!empty($data_2)): ?>
								<?php foreach ($data_2 as $value): ?>
									<tr>
										<th style="text-align: center"><?= !empty($value->code) ? $value->code : '' ?></th>
										<th style="text-align: center"><?= !empty($value->code) ? name_code_data_cp($value->code) : '' ?></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"><?= !empty($value->gia_dinh_thanh_toan) ? number_format($value->gia_dinh_thanh_toan) : '' ?></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"></th>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
							<tr style="background-color: #fbffba">
								<th style="text-align: center">Code</th>
								<th style="text-align: center">Đợt 3</th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
							</tr>
							<?php if (!empty($data_3)): ?>
								<?php foreach ($data_3 as $value): ?>
									<tr>
										<th style="text-align: center"><?= !empty($value->code) ? $value->code : '' ?></th>
										<th style="text-align: center"><?= !empty($value->code) ? name_code_data_cp($value->code) : '' ?></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"><?= !empty($value->gia_dinh_thanh_toan) ? number_format($value->gia_dinh_thanh_toan) : '' ?></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"></th>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
							<tr style="background-color: #fbffba">
								<th style="text-align: center">Code</th>
								<th style="text-align: center">Đợt 4</th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
							</tr>
							<?php if (!empty($data_4)): ?>
								<?php foreach ($data_4 as $value): ?>
									<tr>
										<th style="text-align: center"><?= !empty($value->code) ? $value->code : '' ?></th>
										<th style="text-align: center"><?= !empty($value->code) ? name_code_data_cp($value->code) : '' ?></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"><?= !empty($value->gia_dinh_thanh_toan) ? number_format($value->gia_dinh_thanh_toan) : '' ?></th>
										<th style="text-align: center"></th>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
							<tr style="background-color: #fbffba">
								<th style="text-align: center">Code</th>
								<th style="text-align: center">Đợt 5</th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
							</tr>
							<?php if (!empty($data_5)): ?>
								<?php foreach ($data_5 as $value): ?>
									<tr>
										<th style="text-align: center"><?= !empty($value->code) ? $value->code : '' ?></th>
										<th style="text-align: center"><?= !empty($value->code) ? name_code_data_cp($value->code) : '' ?></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"><?= !empty($value->gia_dinh_thanh_toan) ? number_format($value->gia_dinh_thanh_toan) : '' ?></th>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>


							</tbody>
						</table>
						<table
							class="table table-bordered m-table table-hover table-calendar table-report">

							<thead style="color: white;">
							<tr>
								<th style="text-align: center" colspan="2">ADJUST</th>
								<th style="text-align: center">Đợt 1 (Ngày 05)</th>
								<th style="text-align: center">Đợt 2 (Ngày 15)</th>
								<th style="text-align: center">Đợt 3 (Ngày 20)</th>
								<th style="text-align: center">Đợt 4 (Ngày 25)</th>
								<th style="text-align: center">Đợt 5 (Ngày cuối tháng)</th>
							</tr>
							</thead>
							<tbody>
							<tr style="background-color: #fbffba">
								<th style="text-align: center">Code</th>
								<th style="text-align: center">Đợt 1</th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
							</tr>
							<?php if (!empty($data_1)): ?>
								<?php foreach ($data_1 as $value): ?>
									<tr>
										<th style="text-align: center"><?= !empty($value->code) ? $value->code : '' ?></th>
										<th style="text-align: center"><?= !empty($value->code) ? name_code_data_cp($value->code) : '' ?></th>
										<th style="text-align: center"><?= !empty($value->actual) ? number_format($value->actual) : '' ?></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"></th>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
							<tr style="background-color: #fbffba">
								<th style="text-align: center">Code</th>
								<th style="text-align: center">Đợt 2</th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
							</tr>
							<?php if (!empty($data_2)): ?>
								<?php foreach ($data_2 as $value): ?>
									<tr>
										<th style="text-align: center"><?= !empty($value->code) ? $value->code : '' ?></th>
										<th style="text-align: center"><?= !empty($value->code) ? name_code_data_cp($value->code) : '' ?></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"><?= !empty($value->actual) ? number_format($value->actual) : '' ?></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"></th>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
							<tr style="background-color: #fbffba">
								<th style="text-align: center">Code</th>
								<th style="text-align: center">Đợt 3</th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
							</tr>
							<?php if (!empty($data_3)): ?>
								<?php foreach ($data_3 as $value): ?>
									<tr>
										<th style="text-align: center"><?= !empty($value->code) ? $value->code : '' ?></th>
										<th style="text-align: center"><?= !empty($value->code) ? name_code_data_cp($value->code) : '' ?></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"><?= !empty($value->actual) ? number_format($value->actual) : '' ?></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"></th>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
							<tr style="background-color: #fbffba">
								<th style="text-align: center">Code</th>
								<th style="text-align: center">Đợt 4</th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
							</tr>
							<?php if (!empty($data_4)): ?>
								<?php foreach ($data_4 as $value): ?>
									<tr>
										<th style="text-align: center"><?= !empty($value->code) ? $value->code : '' ?></th>
										<th style="text-align: center"><?= !empty($value->code) ? name_code_data_cp($value->code) : '' ?></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"><?= !empty($value->actual) ? number_format($value->actual) : '' ?></th>
										<th style="text-align: center"></th>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
							<tr style="background-color: #fbffba" >
								<th style="text-align: center">Code</th>
								<th style="text-align: center">Đợt 5</th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
								<th style="text-align: center"></th>
							</tr>
							<?php if (!empty($data_5)): ?>
								<?php foreach ($data_5 as $value): ?>
									<tr>
										<th style="text-align: center"><?= !empty($value->code) ? $value->code : '' ?></th>
										<th style="text-align: center"><?= !empty($value->code) ? name_code_data_cp($value->code) : '' ?></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"></th>
										<th style="text-align: center"><?= !empty($value->actual) ? number_format($value->actual) : '' ?></th>
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


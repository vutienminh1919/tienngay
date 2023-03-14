<?php
$day = !empty($_GET['day']) ? $_GET['day'] : date('Y-m-d');
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
<!--							<li role="presentation"><a href="--><?php //echo base_url() ?><!--plan_actual/indexPlanActual">CF</a></li>-->
<!--							<li role="presentation" class="active"><a-->
<!--									href="--><?php //echo base_url() ?><!--plan_actual/indexBankBalance">Số dư các TK NH</a></li>-->
<!--							<li role="presentation"><a href="--><?php //echo base_url() ?><!--plan_actual/indexFollowVPS">Theo dõi VPS</a></li>-->
<!--							<li role="presentation"><a href="--><?php //echo base_url() ?><!--plan_actual/indexFollowDebt">Quản lý hợp đồng vay</a></li>-->
<!--							<li role="presentation"><a href="--><?php //echo base_url() ?><!--plan_actual/indexInvestor">Nhà đầu tư</a></li>-->
<!--							<li role="presentation" ><a href="--><?php //echo base_url() ?><!--plan_actual/indexDisbursement">Giải ngân Actual</a></li>-->
<!--							<li role="presentation" ><a href="--><?php //echo base_url() ?><!--plan_actual/indexCpWork">CP hoạt động</a></li>-->
<!--							<li role="presentation"><a href="--><?php //echo base_url() ?><!--plan_actual/indexHistorical">Historical Data CP</a></li>-->
<!--						</ul>-->
<!--					</div>-->

					<div style="padding: 10px">
						<style>
							@media screen and (max-width: 1440px) {
								.flex-search{
									display: flex;
									gap: 7%;
									padding-left: 10px;
								}
							}
						</style>
						<form action="<?php echo base_url('plan_actual/indexBankBalance') ?>" method="get" style="width: 100%;">
							<div class="row flex-search">
								<div class="col-lg-2">
									<div class="input-group">
										<span class="input-group-addon">Ngày</span>
										<input type="date" name="day" class="form-control"
											   value="<?= isset($_GET['day']) ? $_GET['day'] : date('Y-m-d') ?>">
									</div>
								</div>

								<div class="col-lg-2 text-right">
									<button type="submit" class="btn btn-primary w-100"><i class="fa fa-search"
																						   aria-hidden="true"></i> <?= $this->lang->line('search') ?>
									</button>
								</div>
							</div>
						</form>

						<div class="row flex-search">
							<div class="col-lg-2">
								<div class="input-group">
									<span class="input-group-addon">Ngày</span>
									<input type="date" name="day_export" class="form-control" value="">
								</div>
							</div>

							<div class="col-lg-2 text-right">
								<a href="#" class="btn btn-primary w-100" id="add_one_day_accountant" ><i class="fa fa-plus" aria-hidden="true"></i> Thêm 1 ngày</a>
							</div>
						</div>

					</div>

					<div class="table-responsive" style="overflow-y: auto">
						<table
							class="table table-bordered m-table table-hover table-calendar table-report ">
							<thead style="background:#ff0000 !important; color: #ffffff;  font-weight: bold">
							<tr>
								<th style="text-align: center" rowspan="2">STT</th>
								<th style="text-align: center" rowspan="2">Nội dung</th>
								<th style="text-align: center" colspan="5"><?= !empty($day) ? date('d/m/Y', strtotime($day)) : date('d/m/Y') ?></th>
							</tr>
							<tr>
								<th style="text-align: center">Số dư đầu ngày</th>
								<th style="text-align: center">PS tăng</th>
								<th style="text-align: center">PS giảm</th>
								<th style="text-align: center">Số dư cuối ngày</th>
								<th style="text-align: center">Số dư KD</th>
							</tr>
							</thead>
							<tbody>
							<tr style="background:#ff0000 !important; color: #ffffff;">
								<td style="text-align: center">A</td>
								<td style="text-align: center; font-weight: bold">Tổng TK L1</td>
								<td style="text-align: center; font-weight: bold"><?= !empty($total_lk_l1) ? number_format($total_lk_l1) : 0 ?></td>
								<td style="text-align: center"></td>
								<td style="text-align: center"></td>
								<td style="text-align: center; font-weight: bold"><?= !empty($ducuoingay_tk_l1) ? number_format($ducuoingay_tk_l1) : 0 ?></td>
								<td style="text-align: center; font-weight: bold"><?= !empty($dukinhdoanh_l1) ? number_format($dukinhdoanh_l1) : 0 ?></td>
							</tr>
							<tr style="background:#0070c0 !important; color: #ffffff;  font-weight: bold">
								<td style="text-align: center">I</td>
								<td style="text-align: center; font-weight: bold">TK TCV</td>
								<td style="text-align: center; font-weight: bold"><?= !empty($total_lk_tcv) ? number_format($total_lk_tcv) : 0 ?></td>
								<td style="text-align: center"></td>
								<td style="text-align: center"></td>
								<td style="text-align: center; font-weight: bold"><?= !empty($ducuoingay_tcv) ? number_format($ducuoingay_tcv) : 0 ?></td>
								<td style="text-align: center; font-weight: bold"><?= !empty($dukinhdoanh_tcv) ? number_format($dukinhdoanh_tcv) : 0 ?></td>
							</tr>
							<?php if(!empty($data_tcv)): ?>
							<?php foreach ($data_tcv as $key => $value): ?>
								<tr style="background:#ffffff !important; color: #000000;">
									<td style="text-align: center"><?= ++$key ?></td>
									<td style="text-align: center"><?= !empty($value->noidung) ? $value->noidung : "" ?></td>
									<td style="text-align: center">
										<?= !empty($value->sodudaungay) ? number_format($value->sodudaungay) : '' ?>
									</td>
									<td style="text-align: center">
										<div class='edit'
											 data-status="<?= !empty($value->pstang) ? $value->pstang : 0 ?>"> <?= !empty($value->pstang) ? number_format($value->pstang) : 0 ?></div>
										<input hidden type='number' class='txtedit'
											   value='<?= !empty($value->pstang) ? $value->pstang : 0 ?>'
											   id='pstang-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->pstang) ? $value->pstang : 0 ?>'/>
									</td>
									<td style="text-align: center">
										<div class='edit'
											 data-status="<?= !empty($value->psgiam) ? $value->psgiam : 0 ?>"> <?= !empty($value->psgiam) ? number_format($value->psgiam) : 0 ?></div>
										<input hidden type='number' class='txtedit'
											   value='<?= !empty($value->psgiam) ? $value->psgiam : 0 ?>'
											   id='psgiam-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->psgiam) ? $value->psgiam : 0 ?>'/>
									</td>
									<td style="text-align: center">
										<?= number_format($value->soducuoingay) ?>
									</td>
									<td style="text-align: center">
										<div class='edit'
											 data-status="<?= !empty($value->sodukd) ? $value->sodukd : 0 ?>"> <?= !empty($value->sodukd) ? number_format($value->sodukd) : 0 ?></div>
										<input hidden type='number' class='txtedit'
											   value='<?= !empty($value->sodukd) ? $value->sodukd : 0 ?>'
											   id='sodukd-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->sodukd) ? $value->sodukd : 0 ?>'/>
									</td>
								</tr>
								<?php endforeach; ?>
							<?php endif; ?>

							<tr style="background:#0070c0 !important; color: #ffffff;font-weight: bold">
								<td style="text-align: center">II</td>
								<td style="text-align: center">TK TCV ĐB</td>
								<td style="text-align: center; font-weight: bold"><?= !empty($total_lk_tcv_db) ? number_format($total_lk_tcv_db) : 0 ?></td>
								<td style="text-align: center"></td>
								<td style="text-align: center"></td>
								<td style="text-align: center; font-weight: bold"><?= !empty($ducuoingay_tcv_db) ? number_format($ducuoingay_tcv_db) : 0 ?></td>
								<td style="text-align: center; font-weight: bold"><?= !empty($dukinhdoanh_tcv_db) ? number_format($dukinhdoanh_tcv_db) : 0 ?></td>
							</tr>
							<?php if(!empty($data_tcv_db)): ?>
								<?php foreach ($data_tcv_db as $key => $value): ?>
									<tr style="background:#ffffff !important; color: #000000;">
										<td style="text-align: center"><?= ++$key ?></td>
										<td style="text-align: center"><?= !empty($value->noidung) ? $value->noidung : "" ?></td>
										<td style="text-align: center">
											<?= !empty($value->sodudaungay) ? number_format($value->sodudaungay) : '' ?>
										</td>
										<td style="text-align: center">
											<div class='edit'
												 data-status="<?= !empty($value->pstang) ? $value->pstang : 0 ?>"> <?= !empty($value->pstang) ? number_format($value->pstang) : 0 ?></div>
											<input hidden type='number' class='txtedit'
												   value='<?= !empty($value->pstang) ? $value->pstang : 0 ?>'
												   id='pstang-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->pstang) ? $value->pstang : 0 ?>'/>
										</td>
										<td style="text-align: center">
											<div class='edit'
												 data-status="<?= !empty($value->psgiam) ? $value->psgiam : 0 ?>"> <?= !empty($value->psgiam) ? number_format($value->psgiam) : 0 ?></div>
											<input hidden type='number' class='txtedit'
												   value='<?= !empty($value->psgiam) ? $value->psgiam : 0 ?>'
												   id='psgiam-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->psgiam) ? $value->psgiam : 0 ?>'/>
										</td>
										<td style="text-align: center">
											<?= number_format($value->soducuoingay) ?>
										</td>
										<td style="text-align: center">
											<div class='edit'
												 data-status="<?= !empty($value->sodukd) ? $value->sodukd : 0 ?>"> <?= !empty($value->sodukd) ? number_format($value->sodukd) : 0 ?></div>
											<input hidden type='number' class='txtedit'
												   value='<?= !empty($value->sodukd) ? $value->sodukd : 0 ?>'
												   id='sodukd-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->sodukd) ? $value->sodukd : 0 ?>'/>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>

							<tr style="background:#00b050 !important; color: #ffffff;font-weight: bold">
								<td style="text-align: center">B</td>
								<td style="text-align: center;font-weight: bold">Tổng TK L2</td>
								<td style="text-align: center; font-weight: bold"><?= !empty($total_lk_l2) ? number_format($total_lk_l2) : 0 ?></td>
								<td style="text-align: center"></td>
								<td style="text-align: center"></td>
								<td style="text-align: center; font-weight: bold"><?= !empty($ducuoingay_tk_l2) ? number_format($ducuoingay_tk_l2) : 0 ?></td>
								<td style="text-align: center; font-weight: bold"><?= !empty($dukinhdoanh_l2) ? number_format($dukinhdoanh_l2) : 0 ?></td>
							</tr>
							<?php if(!empty($data_tk_l2)): ?>
								<?php foreach ($data_tk_l2 as $key => $value): ?>
									<tr style="background:#ffffff !important; color: #000000;">
										<td style="text-align: center"><?= ++$key ?></td>
										<td style="text-align: center"><?= !empty($value->noidung) ? $value->noidung : "" ?></td>
										<td style="text-align: center">
											<?= !empty($value->sodudaungay) ? number_format($value->sodudaungay) : '' ?>
										</td>
										<td style="text-align: center">
											<div class='edit'
												 data-status="<?= !empty($value->pstang) ? $value->pstang : 0 ?>"> <?= !empty($value->pstang) ? number_format($value->pstang) : 0 ?></div>
											<input hidden type='number' class='txtedit'
												   value='<?= !empty($value->pstang) ? $value->pstang : 0 ?>'
												   id='pstang-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->pstang) ? $value->pstang : 0 ?>'/>
										</td>
										<td style="text-align: center">
											<div class='edit'
												 data-status="<?= !empty($value->psgiam) ? $value->psgiam : 0 ?>"> <?= !empty($value->psgiam) ? number_format($value->psgiam) : 0 ?></div>
											<input hidden type='number' class='txtedit'
												   value='<?= !empty($value->psgiam) ? $value->psgiam : 0 ?>'
												   id='psgiam-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->psgiam) ? $value->psgiam : 0 ?>'/>
										</td>
										<td style="text-align: center">
											<?= number_format($value->soducuoingay) ?>
										</td>
										<td style="text-align: center">
											<div class='edit'
												 data-status="<?= !empty($value->sodukd) ? $value->sodukd : 0 ?>"> <?= !empty($value->sodukd) ? number_format($value->sodukd) : 0 ?></div>
											<input hidden type='number' class='txtedit'
												   value='<?= !empty($value->sodukd) ? $value->sodukd : 0 ?>'
												   id='sodukd-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->sodukd) ? $value->sodukd : 0 ?>'/>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>

							<tr style="background:#00b050 !important; color: #ffffff; font-weight: bold">
								<td style="text-align: center">C</td>
								<td style="text-align: center">Tổng TK khác</td>
								<td style="text-align: center; font-weight: bold"><?= !empty($total_lk_khac) ? number_format($total_lk_khac) : 0 ?></td>
								<td style="text-align: center"></td>
								<td style="text-align: center"></td>
								<td style="text-align: center; font-weight: bold"><?= !empty($ducuoingay_tk_khac) ? number_format($ducuoingay_tk_khac) : 0 ?></td>
								<td style="text-align: center"><?= !empty($dukinhdoanh_khac) ? number_format($dukinhdoanh_khac) : 0 ?></td>
							</tr>

							<?php if(!empty($dataBankBalance_tk_khac)): ?>
								<?php foreach ($dataBankBalance_tk_khac as $key => $value): ?>
									<tr style="background:#ffffff !important; color: #000000;">
										<td style="text-align: center"><?= ++$key ?></td>
										<td style="text-align: center"><?= !empty($value->noidung) ? $value->noidung : "" ?></td>
										<td style="text-align: center">
											<?= !empty($value->sodudaungay) ? number_format($value->sodudaungay) : '' ?>
										</td>
										<td style="text-align: center">
											<div class='edit'
												 data-status="<?= !empty($value->pstang) ? $value->pstang : 0 ?>"> <?= !empty($value->pstang) ? number_format($value->pstang) : 0 ?></div>
											<input hidden type='number' class='txtedit'
												   value='<?= !empty($value->pstang) ? $value->pstang : 0 ?>'
												   id='pstang-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->pstang) ? $value->pstang : 0 ?>'/>
										</td>
										<td style="text-align: center">
											<div class='edit'
												 data-status="<?= !empty($value->psgiam) ? $value->psgiam : 0 ?>"> <?= !empty($value->psgiam) ? number_format($value->psgiam) : 0 ?></div>
											<input hidden type='number' class='txtedit'
												   value='<?= !empty($value->psgiam) ? $value->psgiam : 0 ?>'
												   id='psgiam-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->psgiam) ? $value->psgiam : 0 ?>'/>
										</td>
										<td style="text-align: center">
											<?= number_format($value->soducuoingay) ?>
										</td>
										<td style="text-align: center">
											<div class='edit'
												 data-status="<?= !empty($value->sodukd) ? $value->sodukd : 0 ?>"> <?= !empty($value->sodukd) ? number_format($value->sodukd) : 0 ?></div>
											<input hidden type='number' class='txtedit'
												   value='<?= !empty($value->sodukd) ? $value->sodukd : 0 ?>'
												   id='sodukd-<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : '' ?>-<?= !empty($value->sodukd) ? $value->sodukd : 0 ?>'/>
										</td>
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
<script src="<?php echo base_url("assets") ?>/js/plan_actual/plan_actual.js"></script>



<style>
	.page-title {
		min-height: 0px;
		padding: 0px 0;
	}
</style>
<script type="text/javascript">
	$(document).ready(function () {
		// Show Input element
		$('.edit').click(function () {
			var status = $(this).data('status');

			$('.txtedit').hide();
			$(this).next('.txtedit').show().focus();
			$(this).hide();

		});

		// Save data
		$(".txtedit").on('focusout', function () {

			// Get edit id, field name and value
			var id = this.id;
			var split_id = id.split("-");
			var field_name = split_id[0];
			var edit_id = split_id[1];
			var value = $(this).val();

			// Hide Input element
			$(this).hide();

			// Hide and Change Text of the container with input elmeent
			$(this).prev('.edit').show();
			$(this).prev('.edit').text(numeral(value).format('0,0'));
			// Sending AJAX request
			$.ajax({
				url: _url.base_url + 'plan_actual/update_bank_balance',
				type: 'post',
				data: {field: field_name, value: value, id: edit_id},
				success: function (response) {
					console.log('Save successfully');
				}
			});
		});
	});
</script>
<script>
	$('ul.tabs li').click(function () {
		var tab_id = $(this).attr('data-tab');
		$('ul.tabs li').removeClass('active');
		$('.tab-panel').removeClass('active');
		$(this).addClass('active');
		$("#" + tab_id).addClass('active');
	})
</script>


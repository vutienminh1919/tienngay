<!-- page content -->
<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";


	?>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">

				<div class="row">
					<div class="col-xs-12 col-lg-1">
						<h2>KPI phòng giao dịch</h2>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="col-xs-12">
						<div class="row">
							<form class="form-inline" action="<?php echo base_url('kpi/listKPI_pgd') ?>"
								  method="get" style="width: 100%">
								<div class="col-xs-12">
									<div class="row">

										<div class="col-lg-3">
											<div class="input-group">
												<span class="input-group-addon">Tháng</span>
												<input type="month" name="fdate" class="form-control"
													   value="<?= !empty($fdate) ? $fdate : date('Y-m') ?>">
											</div>
										</div>


										<div class="col-lg-2 text-right">
											<button class="btn btn-primary w-100"><i class="fa fa-search"
																					 aria-hidden="true"></i> <?php echo $this->lang->line('search') ?>
											</button>
										</div>
										<!-- 	<div class="col-lg-2 text-right">
											<label></label>
											<a style="background-color: #18d102;"
											   href="<?= base_url() ?>excel/exportList_kpi?<?= 'fdate=' . $fdate . '&tdate=' . $tdate ?>"
											   class="btn btn-primary w-100" target="_blank"><i
														class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp; Xuất
												excel</a>
										</div> -->
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="col-xs-12">
						<div class="title_right text-right row">
							<div class="col-lg-2">
								<input type="month" name="fdate_export" class="form-control" value="">
							</div>

							<div class="col-lg-2">
								<a href="#" class="btn btn-info " id="add_one_month_pgd"><i class="fa fa-plus"
																							aria-hidden="true"></i> Thêm
									1 tháng</a>
							</div>
						</div>


						<br>


						<div class="table-responsive">
							<table id="datatable-button" class="table table-striped datatablebutton">
								<thead>
								<tr>
									<th rowspan="3" class="center">Tháng</th>
									<th rowspan="3" class="center">Phòng giao dịch</th>
									<th colspan="12" class="center">Tiêu chí đánh giá KPI</th>
								</tr>
								<tr role="row">
									<th colspan="2" class="center">Doanh số giải ngân (vnđ)</th>
									<th colspan="2" class="center">Gốc còn lại trong hạn tăng net(vnđ)</th>
									<th colspan="2" class="center">Bảo hiểm (vnđ)</th>
									<th colspan="2" class="center">Tỉ trọng giải ngân</th>
									<th colspan="2" class="center">Nhà đầu tư (vnđ)</th>
								</tr>
								<tr role="row">
									<th class="center">Chỉ tiêu (vnđ)</th>
									<th class="center">Tỉ trọng (%)</th>
									<th class="center">Chỉ tiêu (vnđ)</th>
									<th class="center">Tỉ trọng (%)</th>
									<th class="center">Chỉ tiêu (vnđ)</th>
									<th class="center">Tỉ trọng (%)</th>
									<th class="center">Xe máy (%)</th>
									<th class="center">Ô tô (%)</th>
									<th class="center">Chỉ tiêu (vnđ)</th>
									<th class="center">Tỉ trọng (%)</th>
								</tr>
								</thead>

								<tbody>

								<?php
								if (!empty($kpiData)) {
									$total = count($kpiData);
									foreach ($kpiData as $key => $tran) {
										if ($key > 0) $total = 0;
										?>
										<tr class="center">

											<?php if (!empty($total)) { ?>
												<td rowspan="<?= $total ?>"><?= !empty($tran->month) ? $tran->month . ' / ' . $tran->year : '' ?></td>
											<?php } ?>

											<td><?= !empty($tran->store->name) ? $tran->store->name : '' ?></td>

											<td>
												<div class='edit'
													 data-status="<?= !empty($tran->giai_ngan_CT) ? $tran->giai_ngan_CT : "" ?>"> <?= !empty($tran->giai_ngan_CT) ? number_format($tran->giai_ngan_CT) : "" ?></div>

												<input type='number' class='txtedit'
													   value='<?= !empty($tran->giai_ngan_CT) ? $tran->giai_ngan_CT : "" ?>'
													   id='giai_ngan_CT-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>
											</td>
											<td>
												<div class='edit'
													 data-status="<?= !empty($tran->giai_ngan_TT) ? $tran->giai_ngan_TT : "" ?>"> <?= !empty($tran->giai_ngan_TT) ? number_format($tran->giai_ngan_TT) : "" ?></div>

												<input type='number' class='txtedit'
													   value='<?= !empty($tran->giai_ngan_TT) ? $tran->giai_ngan_TT : "" ?>'
													   id='giai_ngan_TT-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>
											</td>

											<td>
												<div class='edit'
													 data-status="<?= !empty($tran->du_no_CT) ? $tran->du_no_CT : "" ?>"> <?= !empty($tran->du_no_CT) ? number_format($tran->du_no_CT) : "" ?></div>

												<input type='number' class='txtedit'
													   value='<?= !empty($tran->du_no_CT) ? $tran->du_no_CT : "" ?>'
													   id='du_no_CT-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>
											</td>
											<td>
												<div class='edit'
													 data-status="<?= !empty($tran->du_no_TT) ? $tran->du_no_TT : "" ?>"> <?= !empty($tran->du_no_TT) ? number_format($tran->du_no_TT) : "" ?></div>

												<input type='number' class='txtedit'
													   value='<?= !empty($tran->du_no_TT) ? $tran->du_no_TT : "" ?>'
													   id='du_no_TT-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>
											</td>

											<td>
												<div class='edit'
													 data-status="<?= !empty($tran->bao_hiem_CT) ? $tran->bao_hiem_CT : "" ?>"> <?= !empty($tran->bao_hiem_CT) ? number_format($tran->bao_hiem_CT) : "" ?></div>

												<input type='number' class='txtedit'
													   value='<?= !empty($tran->bao_hiem_CT) ? $tran->bao_hiem_CT : "" ?>'
													   id='bao_hiem_CT-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>
											</td>
											<td>
												<div class='edit'
													 data-status="<?= !empty($tran->bao_hiem_TT) ? $tran->bao_hiem_TT : "" ?>"> <?= !empty($tran->bao_hiem_TT) ? number_format($tran->bao_hiem_TT) : "" ?></div>

												<input type='number' class='txtedit'
													   value='<?= !empty($tran->bao_hiem_TT) ? $tran->bao_hiem_TT : "" ?>'
													   id='bao_hiem_TT-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>
											</td>

											<td>
												<div class='edit'
													 data-status="<?= !empty($tran->xe_may_TT) ? $tran->xe_may_TT : "" ?>"> <?= !empty($tran->xe_may_TT) ? number_format($tran->xe_may_TT) : "" ?></div>

												<input type='number' class='txtedit'
													   value='<?= !empty($tran->xe_may_TT) ? $tran->xe_may_TT : "" ?>'
													   id='xe_may_TT-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>
											</td>
											<td>
												<div class='edit'
													 data-status="<?= !empty($tran->oto_TT) ? $tran->oto_TT : "" ?>"> <?= !empty($tran->oto_TT) ? number_format($tran->oto_TT) : "" ?></div>

												<input type='number' class='txtedit'
													   value='<?= !empty($tran->oto_TT) ? $tran->oto_TT : "" ?>'
													   id='oto_TT-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>
											</td>


											<td>
												<div class='edit'
													 data-status="<?= !empty($tran->nha_dau_tu) ? $tran->nha_dau_tu : "" ?>"> <?= !empty($tran->nha_dau_tu) ? number_format($tran->nha_dau_tu) : "" ?></div>

												<input type='number' class='txtedit'
													   value='<?= !empty($tran->nha_dau_tu) ? $tran->nha_dau_tu : "" ?>'
													   id='nha_dau_tu-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>
											</td>
											<td>
												<div class='edit'
													 data-status="<?= !empty($tran->nha_dau_tu_TT) ? $tran->nha_dau_tu_TT : "" ?>"> <?= !empty($tran->nha_dau_tu_TT) ? number_format($tran->nha_dau_tu_TT) : "" ?></div>

												<input type='number' class='txtedit'
													   value='<?= !empty($tran->nha_dau_tu_TT) ? $tran->nha_dau_tu_TT : "" ?>'
													   id='nha_dau_tu_TT-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>
											</td>

										</tr>
									<?php }
								} ?>
								</tbody>
							</table>
							<div class="pagination pagination-sm">
								<!-- <?php echo $pagination ?> -->
							</div>
						</div>

					</div>


				</div>
			</div>
		</div>
	</div>
</div>

</div>


<script src="<?php echo base_url(); ?>assets/js/kpi/index.js"></script>
<script type="text/javascript">
	$(document).ready(function () {

		// Show Input element
		$('.edit').click(function () {
			var status = $(this).data('status');
			console.log(status);

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
			$(this).prev('.edit').text(value);

			// Sending AJAX request
			$.ajax({
				url: _url.base_url + 'kpi/update_pgd',
				type: 'post',
				data: {field: field_name, value: value, id: edit_id},
				success: function (response) {
					console.log('Save successfully');
				}
			});

		});

	});

</script>
<style type="text/css">
	.container {
		margin: 0 auto;
	}


	.edit {
		width: 100%;
		height: 25px;
	}

	.editMode {
		/*border: 1px solid black;*/

	}

	.txtedit {
		display: none;
		width: 99%;
		height: 30px;
	}


	table tr:nth-child(1) th {
		color: white;

	}


</style>

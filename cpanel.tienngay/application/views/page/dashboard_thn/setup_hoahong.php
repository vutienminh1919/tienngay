<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	?>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">

				<div class="row">
					<div class="col-xs-12 col-lg-1">
						<h2 style="font-weight: bold">Cài Đặt Hoa Hồng QUẢN LÝ HỢP ĐỒNG VAY</h2>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="col-xs-12">
					</div>

					<div class="col-xs-12">
						<div class="title_right  row">
						</div>
						<br>
						<div class="table-responsive">

							<div class="tab-contents">

									<table id="datatable-button" class="table table-striped datatablebutton">
										<thead>
										<tr>
											<th class="center">Mục</th>
											<th class="center">Call B0-B1</th>
											<th class="center">Call B1-B3</th>
											<th class="center">Field B1-B3</th>
											<th class="center">Field B4+</th>
											<th class="center">CHÚ THÍCH</th>
										</tr>
										</thead>
										<tbody>
											<tr>
												<td style="font-weight: bold">THU Ô TÔ</td>
												<?php if (!empty($data)): ?>
												<?php foreach ($data->commision->thu_oto as $key => $value): ?>
												<td style="text-align: center">
													<div class='edit'
														 data-status="<?= !empty($value) ? $value : 0 ?>"> <?= !empty($value) ? number_format($value) : 0 ?></div>
													<input hidden type='number' class='txtedit'
														   value='<?= !empty($value) ? $value : 0 ?>'
														   id='<?= $key ?>-<?= !empty($data->_id->{'$oid'}) ? $data->_id->{'$oid'} : '' ?>-thu_oto'/>
												</td>
												<?php endforeach; ?>
												<?php endif; ?>

												<td>Cho 1 chiếc xe  thu về
													<br>
													Áp dụng từ Bucket B2 trở lên</td>
											</tr>
											<tr>
												<td style="font-weight: bold">THU XE MÁY</td>
												<?php if (!empty($data)): ?>
													<?php foreach ($data->commision->thu_xemay as $key => $value): ?>
														<td style="text-align: center">
															<div class='edit'
																 data-status="<?= !empty($value) ? $value : 0 ?>"> <?= !empty($value) ? number_format($value) : 0 ?></div>
															<input hidden type='number' class='txtedit'
																   value='<?= !empty($value) ? $value : 0 ?>'
																   id='<?= $key ?>-<?= !empty($data->_id->{'$oid'}) ? $data->_id->{'$oid'} : '' ?>-thu_xemay'/>
														</td>
													<?php endforeach; ?>
												<?php endif; ?>
												<td>Cho 1 chiếc xe  thu về
													<br>
													Áp dụng từ Bucket B2 trở lên</td>
											</tr>
											<tr>
												<td style="font-weight: bold">THƯỞNG TẤT TOÁN HỢP ĐỒNG XE MÁY</td>
												<?php if (!empty($data)): ?>
													<?php foreach ($data->commision->tt_hd_xemay as $key => $value): ?>
														<td style="text-align: center">
															<div class='edit'
																 data-status="<?= !empty($value) ? $value : 0 ?>"> <?= !empty($value) ? number_format($value) : 0 ?></div>
															<input hidden type='number' class='txtedit'
																   value='<?= !empty($value) ? $value : 0 ?>'
																   id='<?= $key ?>-<?= !empty($data->_id->{'$oid'}) ? $data->_id->{'$oid'} : '' ?>-tt_hd_xemay'/>
														</td>
													<?php endforeach; ?>
												<?php endif; ?>
												<td>1. Áp dụng từ Bucket B2 trở lên;
													<br>
													2. Khoản vay tất toán nhưng không xin miễn giảm
												</td>
											</tr>
											<tr>
												<td style="font-weight: bold">THƯỞNG TẤT TOÁN HỢP ĐỒNG Ô TÔ</td>
												<?php if (!empty($data)): ?>
													<?php foreach ($data->commision->tt_hd_oto as $key => $value): ?>
														<td style="text-align: center">
															<div class='edit'
																 data-status="<?= !empty($value) ? $value : 0 ?>"> <?= !empty($value) ? number_format($value) : 0 ?></div>
															<input hidden type='number' class='txtedit'
																   value='<?= !empty($value) ? $value : 0 ?>'
																   id='<?= $key ?>-<?= !empty($data->_id->{'$oid'}) ? $data->_id->{'$oid'} : '' ?>-tt_hd_oto'/>
														</td>
													<?php endforeach; ?>
												<?php endif; ?>
												<td>1. Áp dụng từ Bucket B2 trở lên;
													<br>
													2. Khoản vay tất toán nhưng không xin miễn giảm
												</td>
											</tr>
											<tr>
												<td style="font-weight: bold">TỔNG PHÍ PHẠT (%)</td>
												<?php if (!empty($data)): ?>
													<?php foreach ($data->commision->tong_phi_phat as $key => $value): ?>
														<td style="text-align: center">
															<div class='edit'
																 data-status="<?= !empty($value) ? $value : 0 ?>"> <?= !empty($value) ? number_format($value) : 0 ?>%</div>
															<input hidden type='number' class='txtedit'
																   value='<?= !empty($value) ? $value : 0 ?>'
																   id='<?= $key ?>-<?= !empty($data->_id->{'$oid'}) ? $data->_id->{'$oid'} : '' ?>-tong_phi_phat'/>
														</td>
													<?php endforeach; ?>
												<?php endif; ?>
												<td>1. KH thuộc Call hoặc Field quản lý mà thu được phí phạt thì bộ phận đó được hưởng
												</td>
											</tr>
											<tr>
												<td style="font-weight: bold">BUCKET ROLLBACK</td>
												<?php if (!empty($data)): ?>
													<?php foreach ($data->commision->bucket_rollback as $key => $value): ?>
														<td style="text-align: center">
															<div class='edit'
																 data-status="<?= !empty($value) ? $value : 0 ?>"> <?= !empty($value) ? number_format($value) : 0 ?></div>
															<input hidden type='number' class='txtedit'
																   value='<?= !empty($value) ? $value : 0 ?>'
																   id='<?= $key ?>-<?= !empty($data->_id->{'$oid'}) ? $data->_id->{'$oid'} : '' ?>-bucket_rollback'/>
														</td>
													<?php endforeach; ?>
												<?php endif; ?>
												<td>N. Là số kỳ phí mà thu được của KH
												</td>
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


</div>


<script>

</script>
<script src="<?php echo base_url(); ?>assets/js/dashboard_thn/index.js"></script>
<script src="<?php echo base_url(); ?>assets/js/numeral.min.js"></script>
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
			var bucket = split_id[2];
			var value = $(this).val();

			// Hide Input element
			$(this).hide();

			// Hide and Change Text of the container with input elmeent
			$(this).prev('.edit').show();
			$(this).prev('.edit').text(numeral(value).format('0,0'));

			// Sending AJAX request
			$.ajax({
				// url: _url.base_url + 'kpi/update_gdv',
				url: _url.base_url + 'dashboard_thn/update_thn_hoahong',
				type: 'post',
				data: {field: field_name, value: value, id: edit_id, bucket: bucket},
				success: function (response) {
					console.log('Save successfully');
				}
			});

		});


	});

</script>
<style type="text/css">
	.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
		border-bottom: 1px solid #ddd;
	}

	tbody tr th {
		text-align: center;
		font-weight: 300 !important;
	}

	.table {
		margin-bottom: 0;
	}

	ul.nav.tabs {
		display: flex;
		align-items: center;
		justify-content: left;
		border: none;
		border-bottom: 1px solid #e5e5e5;
		padding: 0;
		width: calc(100% - 265px);
	}

	ul.nav.tabs li a {
		display: block;
		text-decoration: unset;
		text-align: center;
		margin: 0;
		padding: 10px 5px 0;
		margin-bottom: 15px;
		margin-right: 15px;
		cursor: pointer;
	}

	ul.nav.tabs li.active a {
		border-bottom: 1px solid #0e9549;
	}

	ul.nav.tabs li a h3 {
		font-size: 15px;
		color: #8c8c8c;
	}

	ul.nav.tabs li.active a h3 {
		color: #0e9549;
	}

	.tab-panel {
		display: none;
	}

	.tab-panel.active {
		display: block;
	}

	.trongso {
		background: #fff;
		padding: 10px;
		border-radius: 10px;
	}

	.box_b {
		display: flex;
		justify-content: space-between;
		margin: 8px 0;
		align-items: center;
	}

	.box_b input {
		text-align: center;
	}
	.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
		position: relative;
	}

	.flex{
		display: flex;
		align-items: center;
		height: 100%;
		position: absolute;
		justify-content: center;
		width: 100%;
	}

	@media (min-width: 768px) {
		.modal-dialog {
			width: 400px;
		}
	}
</style>
<script type="text/javascript">
	$('ul.tabs li').click(function () {
		var tab_id = $(this).attr('data-tab');
		$('ul.tabs li').removeClass('active');
		$('.tab-panel').removeClass('active');
		$(this).addClass('active');
		$("#" + tab_id).addClass('active');
	})
</script>

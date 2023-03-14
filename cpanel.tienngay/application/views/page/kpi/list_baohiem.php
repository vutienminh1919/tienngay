<!-- page content -->
<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";

	
	?>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">

				<div class="row">
					<div class="col-xs-12 col-lg-1">
						<h2>KPI</h2>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="col-xs-12">
						<div class="row">
							<form class="form-inline" action="<?php echo base_url('kpi/listKPI') ?>"
								  method="get" style="width: 100%">
								<div class="col-xs-12">
									<div class="row">
										
										<div class="col-lg-2">
											<div class="input-group">
												<span class="input-group-addon"><?php echo $this->lang->line('from') ?></span>
												<input type="date" name="fdate" class="form-control"
													   value="<?= !empty($fdate) ? $fdate : "" ?>">
											</div>
										</div>
										<div class="col-lg-2">
											<div class="input-group">
												<span class="input-group-addon"><?php echo $this->lang->line('to') ?></span>
												<input type="date" name="tdate" class="form-control"
													   value="<?= !empty($tdate) ? $tdate : "" ?>">

											</div>
										</div>
										

										<div class="col-lg-2 text-right">
											<button class="btn btn-primary w-100"><i class="fa fa-search"
																					 aria-hidden="true"></i> <?php echo $this->lang->line('search') ?>
											</button>
										</div>
									
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
         					 <a href="#" class="btn btn-info " id="add_one_month" ><i class="fa fa-plus" aria-hidden="true"></i>Thêm 1 tháng</a>
                           </div>
                       </div>

                                        
                                    
						<br>
						
								
										<div class="table-responsive">
											<div><?php //echo $result_count; ?></div>
											<table id="datatable-button" class="table table-striped datatablebutton">
												<thead>
												<tr>
													<th rowspan="3">Tháng</th>
													<th rowspan="3">PGD</th>
													<th colspan="8" class="center">Tiêu chí đánh giá KPI</th>
													
												</tr>
												<tr role="row">
													<th colspan="2" class="center">Giải ngân(Số tiền)</th>
													<th colspan="2" class="center">Bảo hiểm(Số tiền)</th>
													<th colspan="2" class="center">KH mới(Số lượng)</th>
													<th colspan="2" class="center">HĐ quá hạn(Số tiền)</th>
												</tr>
												<tr role="row">
													<th >Chỉ tiêu(vnđ)</th>
													<th>Tỉ trọng(%)</th>
													<th >Chỉ tiêu(vnđ)</th>
													<th>Tỉ trọng(%)</th>
													<th >Chỉ tiêu(vnđ)</th>
													<th>Tỉ trọng(%)</th>
													<th >Chỉ tiêu(vnđ)</th>
													<th>Tỉ trọng(%)</th>
												</tr>
												</thead>

												<tbody>

												<?php
												if (!empty($kpiData)) {
													$total=count($kpiData);
									foreach ($kpiData as $key => $tran) {
										if($key>0) $total=0;
														?>
					<tr class="center">	
					<?php if (!empty($total)) { ?>								
				   <td rowspan="<?=$total?>"><?= !empty($tran->month) ? $tran->month.' / '.$tran->year : '' ?></td>
				<?php } ?>	
					<td ><?= !empty($tran->store->name) ?$tran->store->name : '' ?></td>
					
					<td >
						<div class='edit' data-status="<?= !empty($tran->giai_ngan_CT) ? $tran->giai_ngan_CT : "" ?>"> <?= !empty($tran->giai_ngan_CT) ? number_format($tran->giai_ngan_CT) : "" ?></div>

						<input type='number' class='txtedit' value='<?= !empty($tran->giai_ngan_CT) ? $tran->giai_ngan_CT : "" ?>' id='giai_ngan_CT-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>
						</td>
					<td >
						<div class='edit' data-status="<?= !empty($tran->giai_ngan_TT) ? $tran->giai_ngan_TT : "" ?>"> <?= !empty($tran->giai_ngan_TT) ? number_format($tran->giai_ngan_TT) : "" ?></div>

						<input type='number' class='txtedit' value='<?= !empty($tran->giai_ngan_TT) ? $tran->giai_ngan_TT : "" ?>' id='giai_ngan_TT-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>
						</td>
					<td >
						<div class='edit' data-status="<?= !empty($tran->bao_hiem_CT) ? $tran->bao_hiem_CT : "" ?>"> <?= !empty($tran->bao_hiem_CT) ? number_format($tran->bao_hiem_CT) : "" ?></div>

						<input type='number' class='txtedit' value='<?= !empty($tran->bao_hiem_CT) ? $tran->bao_hiem_CT : "" ?>' id='bao_hiem_CT-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>
						</td>
					<td >
						<div class='edit' data-status="<?= !empty($tran->bao_hiem_TT) ? $tran->bao_hiem_TT : "" ?>"> <?= !empty($tran->bao_hiem_TT) ? number_format($tran->bao_hiem_TT) : "" ?></div>

						<input type='number' class='txtedit' value='<?= !empty($tran->bao_hiem_TT) ? $tran->bao_hiem_TT : "" ?>' id='bao_hiem_TT-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>
						</td>
					<td >
						<div class='edit' data-status="<?= !empty($tran->khach_hang_moi_CT) ? $tran->khach_hang_moi_CT : "" ?>"> <?= !empty($tran->khach_hang_moi_CT) ? number_format($tran->khach_hang_moi_CT) : "" ?></div>

						<input type='number' class='txtedit' value='<?= !empty($tran->khach_hang_moi_CT) ? $tran->khach_hang_moi_CT : "" ?>' id='khach_hang_moi_CT-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>
					</td>
					<td >
						<div class='edit' data-status="<?= !empty($tran->khach_hang_moi_TT) ? $tran->khach_hang_moi_TT : "" ?>"> <?= !empty($tran->khach_hang_moi_TT) ? number_format($tran->khach_hang_moi_TT) : "" ?></div>

						<input type='number' class='txtedit' value='<?= !empty($tran->khach_hang_moi_TT) ? $tran->khach_hang_moi_TT : "" ?>' id='khach_hang_moi_TT-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>
						</td>
					<td >
						<div class='edit' data-status="<?= !empty($tran->no_xau_CT) ? $tran->no_xau_CT : "" ?>"> <?= !empty($tran->no_xau_CT) ? number_format($tran->no_xau_CT) : "" ?></div>

						<input type='number' class='txtedit' value='<?= !empty($tran->no_xau_CT) ? $tran->no_xau_CT : "" ?>' id='no_xau_CT-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>
						</td>
					   <td >
						<div class='edit' data-status="<?= !empty($tran->no_xau_TT) ? $tran->no_xau_TT : "" ?>"> <?= !empty($tran->no_xau_TT) ? number_format($tran->no_xau_TT) : "" ?></div>

						<input type='number' class='txtedit' value='<?= !empty($tran->no_xau_TT) ? $tran->no_xau_TT : "" ?>' id='no_xau_TT-<?= !empty($tran->_id->{'$oid'}) ? $tran->_id->{'$oid'} : '' ?>'/>
						</td>
				    </tr>
														<?php }} ?>
												</tbody>
											</table>
											<div class="pagination pagination-sm">
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
				url: _url.base_url + 'kpi/update',
				type: 'post',
				data: {field: field_name, value: value, id: edit_id},
				success: function (response) {
					console.log('Save successfully');
				}
			});

		});

	});
	detail('<?=(isset($_GET['id'])) ? $_GET['id'] : '' ?>');
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

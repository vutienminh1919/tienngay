<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>

	<div class="page-title">
		<div class="title_left">
			<a href="<?php echo base_url() ?>transaction_print/reportPrintView"><h3 class="d-inline-block">Thống kê lượt in phiếu thu</h3></a>
		</div>
	</div>

	<div class="clearfix"></div>

	<div class="row">
		<div class="col-md-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Tổng phiếu thu đã in (<span
							class="text-danger"><?php echo $all; ?></span>)</h2>
					<form method="get">
						<ul class="nav navbar-right panel_toolbox">
							<li>
								<button class="btn btn-info" type="button">
									<a href="<?php echo base_url('transaction_print/reportPrintView') ?>">
										<span style="color: white">Xóa filter</span>
									</a>
								</button>
							</li>
							<li>
								<button class="btn btn-info" type="button">
									<a href="<?php echo base_url('transaction_print/exportExcelPrint').'?'.parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY) ?>"
									   target="_blank">
										<i class="fa fa-file-excel-o" aria-hidden="true"></i>
										<span style="color: white">Xuất file XLS</span>
									</a>
								</button>
							</li>

							<li>
								<div class="dropdown" style="display:inline-block">
									<button type="button" class="btn btn-success dropdown-toggle"
											onclick="$('#lockdulieu').toggleClass('show');">
										<span class="fa fa-filter"></span>
										Lọc dữ liệu
									</button>
									<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
										style="padding:15px;min-width:250px;">
										<li class="form-group">
											<div class="form-group">
												<label>Phòng giao dịch</label>
												<select id="store" class="form-control" multiple name="store[]">
													<option value=""></option>
													<?php foreach ($store_list as $item) {?>
														<option value="<?= $item->_id  ?>"><?= $item->name ?></option>
													<?php } ?>
												</select>
											</div>
											<script>
												var select = $('#store').selectize({
													sortField: 'text'
												});
												<?php
												$select = '[';
												if ( is_array($store_value) ) {
													foreach ($store_value as $key => $itemDept) {
														$select .= '"'.$itemDept.'",';
													}
												}
												$select .= ']';
												?>
												select[0].selectize.setValue(<?= $select ?>);
											</script>
										</li>
										<li class="form-group">
											<div class="form-group">
												<label>
													Từ ngày:</label>
												<input type="date" class="form-control" placeholder="Từ ngày"
													   name="fromdate" value="<?= $fromdate ?>">
											</div>
										</li>
										<li class="form-group">
											<div class="form-group">
												<label>
													Đến ngày:</label>
												<input type="date"	 class="form-control" placeholder="Đến ngày"
													   name="todate" value="<?= $todate ?>">
											</div>
										</li>
										<li class="form-group">
											<div class="form-group">
												<label>
													Mã hợp đồng:</label>
												<input type="text" class="form-control" placeholder="Mã hợp đồng"
													   name="code_contract_disbursement" value="<?=$code_contract_disbursement?>">
											</div>
										</li>
										<li class="form-group">
											<div class="form-group">
												<label>
													Mã phiếu ghi:</label>
												<input type="text" class="form-control" placeholder="Mã phiếu ghi"
													   name="code_contract" value="<?=$code_contract?>">
											</div>
										</li>
										<li class="form-group">
											<div class="form-group">
												<label>
													Mã phiếu thu:</label>
												<input type="text" class="form-control" placeholder="Mã phiếu thu"
													   name="code_transaction" value="<?=$code_transaction?>">
											</div>
										</li>
										<li class="form-group">
											<div style="float:left;">
												<a href="<?php echo base_url('transaction_print/exportExcelPrint').'?'.parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY) ?>"
									   target="_blank" class="btn btn-info">
													Xuất excel
												</a>
											</div>
											<div style="float:right;">
												<button class="btn btn-info">
													<i class="fa fa-search" aria-hidden="true"></i>
													Tìm Kiếm
												</button>
											</div>
										</li>
									</ul>
								</div>
							</li>
						</ul>
					</form>
					<div class="clearfix"></div>
				</div>
				<div class="x_content" style="overflow: auto;">
					<table class="table table-responsive stacktable table-quanlytaisan table-bordered">
					<thead>
						<tr style="background: #0a90eb; color: white">
							<th style="text-align: center">Tên phòng giao dịch</th>
							<th style="text-align: center">Tổng phiếu thu phòng giao dịch đã in</th>
							<th style="text-align: center"></th>
						</tr>
					</thead>
						<tbody>
							<?php foreach ($store as $key => $item) { ?>
								<tr style="text-align: center">
									<td>
										<?= $item->_id->name ?>
									</td>
									<td>
										<span style="color:red;"><?= $item->count ?></span>
									</td>
									<td>
										<button class="btn btn-info btn-sm" title="Xem Nhanh" onclick="$('.quanlytaisan_detail_<?=$item->_id->id?>').toggleClass('d-none');">
											<i class="fa fa-eye"></i>
										</button>
									</td>
								</tr>
								<tr id="quanlytaisan_detail_<?php echo $item->_id->id ?>"
									class="d-none quanlytaisan_detail quanlytaisan_detail_<?php echo $item->_id->id ?> table-responsive">
									<td colspan="3">
										<div class="col-xs-12">
											<div>
												<table class="table table-bordered table-responsive">
													<tr>
														<th scope="col">STT</th>
														<th scope="col">Mã hợp đồng</th>
														<th scope="col">Mã phiếu ghi</th>
														<th scope="col">Mã phiếu thu</th>
														<th scope="col">Số tiền thu</th>
														<th scope="col">Tên khách hàng</th>
														<th scope="col">Người thực hiện</th>
														<th scope="col">Phòng thu hộ</th>
														<th scope="col">Số phiếu thu đã in</th>
														<th></th>
													</tr>
													<?php
														$total = 0;
														foreach ($contract as $key => $item_contract) {
														if ( $item_contract->_id->store->id == $item->_id->id) {
															$total++;
														?>
															<tr>
																<td><?=$total?></td>
															<td>
																<?= $item_contract->code_contract_disbursement ?>
															</td>
															<td>
																<?= $item_contract->code_contract ?? '' ?>
															</td>
															<td>
																<?= $item_contract->code_transaction ?? '' ?>
															</td>
															<td>
																<?= number_format($item_contract->money) ?? '' ?>
															</td>
															<td>
																<?= $item_contract->customer_name ?? '' ?>
															</td>
															<td>
																<?= $item_contract->user_print ?? '' ?>
															</td>
															<?php if($item_contract->help_pgd_name) { ?>
																<td>
																	<?= $item_contract->help_pgd_name->name ?? '' ?>
																</td>
															<?php } else { ?>
																<td>Không</td>
															<?php } ?>
															<td>
																<?= $item_contract->count ?>
															</td>
															<td>
																<button class="btn btn-info btn-sm" title="Xem chi tiết" onclick="showTimePrint('<?= $item_contract->_id->store->id ?>', '<?= $item_contract->code_contract_disbursement ?>', '<?= $item_contract->user_print ?>')">
																	<span class="eye_<?php echo $item->_id->id ?>">Xem thời gian</span>
																	<i class="fa fa-spinner fa-spin spin_<?php echo $item->_id->id ?>" style="display: none;"></i>
																</button>
															</td>
															</tr>
													<?php }} ?>
												</table>
											</div>
										</div>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="modal_time_print" class="modal fade" role="dialog">
	<div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Thời gian thu</h4>
		</div>
		<div class="modal-body">
			<table class="table table-bordered table-responsive" id="tb_time_print"></table>
		</div>
	</div>

  </div>
</div>

<script type="text/javascript">
	function showTimePrint(store, code_contract_disbursement, user_print) {
		$('.eye_'+store).hide();
		$('.spin_'+store).show();
		var formData = {
			store: store,
			code_contract_disbursement: code_contract_disbursement,
			user_print: user_print
		};
		$.ajax({
			url: "/transaction_print/getDatePrint",
			type: "POST",
			data: formData,
			success: function (res) {
				data = JSON.parse(res);
				console.log(data);
				let html_add = data.data.map((item) => {
					return "<tr><td>"+ convertDate(item.time_print) +"</td></tr>";
				});
				$('#tb_time_print').html(html_add);
				$('#modal_time_print').modal('show');
				$('.eye_'+store).show();
				$('.spin_'+store).hide();
			},
			error: function (data) {
				console.log(data);
				$('.eye_'+store).show();
				$('.spin_'+store).hide();
			}
		});
	}

	function convertDate(time) {
		var date = new Date(time * 1000);
		var month = '' + (date.getMonth() + 1);
		var day = '' + date.getDate();
		var year = date.getFullYear();
		var hours = date.getHours();
		var minutes = "0" + date.getMinutes();
		var seconds = "0" + date.getSeconds();
		var formattedTime = hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2)

		if (month.length < 2) 
			month = '0' + month;
		if (day.length < 2) 
			day = '0' + day;

		return [day, month, year].join('/') + ' ' + formattedTime;
	}
</script>
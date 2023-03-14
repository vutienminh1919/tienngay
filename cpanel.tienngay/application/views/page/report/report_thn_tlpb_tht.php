<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>

	<div class="page-title">
		<div class="title_left">
			<a href="<?php echo base_url() ?>report_kt/report_thn_tlpb_tht"><h3 class="d-inline-block">Báo cáo tỉ lệ phân bổ các nhóm toàn hệ thống</h3></a>
		</div>
	</div>

	<div class="clearfix"></div>

	<div class="row">
		<div class="col-md-12">
			<div class="x_panel">
				<div class="x_title">
					<h2></h2>
					<form method="get">
						<ul class="nav navbar-right panel_toolbox">
							<li>
								<button class="btn btn-info" type="button">
									<a href="<?php echo base_url('report_kt/report_thn_tlpb_tht') ?>">
										<span style="color: white">Xóa filter</span>
									</a>
								</button>
							</li>
							<li>
								<button id="btnExport" class="btn btn-primary" onclick="fnExcelReport();"> Export </button>
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
												<label>Vùng</label>
												<select id="area" class="form-control" name="area">
													<option value=""></option>
													<option value="mb" <?= $area == 'mb' ? 'selected' : '' ?>>Miền bắc</option>
													<option value="mn" <?= $area == 'mn' ? 'selected' : '' ?>>Miền nam</option>
													<option value="vmc" <?= $area == 'vmc' ? 'selected' : '' ?>>Mekong</option>
												</select>
											</div>
										</li>
										<li class="form-group">
											<div class="form-group">
												<label>Phòng giao dịch</label>
												<select id="store" class="form-control" name="store">
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
												select[0].selectize.setValue(<?= '"'. $store .'"' ?>);
											</script>
										</li>
										<li class="form-group">
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
					<?php if ($type == 1) { ?>
						<table id="datatable-button" class="table table-responsive stacktable table-quanlytaisan table-bordered">
							<thead>
								<tr style="background: #0a90eb; color: white">
									<th style="text-align: center; width: 25%" colspan="4">VFC</th>
									<th style="text-align: center; width: 25%" colspan="2">Miền bắc</th>
									<th style="text-align: center; width: 25%" colspan="2">Miền nam</th>
									<th style="text-align: center; width: 25%" colspan="2">Mekong</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td style="text-align: left; font-weight: bold;" colspan="2">Tiền giải ngân</td>
									<td style="text-align: left; font-weight: bold;" colspan="2">Tiền đang cho vay</td>
									<td style="text-align: left; font-weight: bold;">Tiền giải ngân</td>
									<td style="text-align: left; font-weight: bold;">Tiền đang cho vay</td>
									<td style="text-align: left; font-weight: bold;">Tiền giải ngân</td>
									<td style="text-align: left; font-weight: bold;">Tiền đang cho vay</td>
									<td style="text-align: left; font-weight: bold;">Tiền giải ngân</td>
									<td style="text-align: left; font-weight: bold;">Tiền đang cho vay</td>
								</tr>
								<tr>
									<td style="text-align: right; font-weight: bold; color: red; font-size: 14px" colspan="2"><?= number_format($report->vfc->du_no_giai_ngan) ?? 0 ?></td>
									<td style="text-align: right; font-weight: bold; color: red; font-size: 14px" colspan="2"><?= number_format($report->vfc->du_no_cho_vay) ?? 0 ?></td>
									<td style="text-align: right; font-weight: bold; color: red; font-size: 14px"><?= number_format($report->mb->du_no_giai_ngan) ?? 0 ?></td>
									<td style="text-align: right; font-weight: bold; color: red; font-size: 14px"><?= number_format($report->mb->du_no_cho_vay) ?? 0 ?></td>
									<td style="text-align: right; font-weight: bold; color: red; font-size: 14px"><?= number_format($report->mn->du_no_giai_ngan) ?? 0 ?></td>
									<td style="text-align: right; font-weight: bold; color: red; font-size: 14px"><?= number_format($report->mn->du_no_cho_vay) ?? 0 ?></td>
									<td style="text-align: right; font-weight: bold; color: red; font-size: 14px"><?= number_format($report->vmc->du_no_giai_ngan) ?? 0 ?></td>
									<td style="text-align: right; font-weight: bold; color: red; font-size: 14px"><?= number_format($report->vmc->du_no_cho_vay) ?? 0 ?></td>
								</tr>
								<tr style="background: #0a90eb; color: white">
									<td style="text-align: left; font-weight: bold;">Nhóm </td>
									<td style="text-align: left; font-weight: bold;">Tổng gốc còn lại đang cho vay theo Bucket</td>
									<td style="text-align: left; font-weight: bold;">Tỷ lệ so với tổng giải ngân</td>
									<td style="text-align: left; font-weight: bold;">Tỷ lệ so với tổng đang cho vay</td>
									<td style="text-align: left; font-weight: bold;" colspan="2">Tổng đang cho vay theo Bucket</td>
									<td style="text-align: left; font-weight: bold;" colspan="2">Tổng đang cho vay theo Bucket</td>
									<td style="text-align: left; font-weight: bold;" colspan="2">Tổng đang cho vay theo Bucket</td>
								</tr>
								<?php 
									$nhom_no = (array) $report->vfc->nhom_no;
									$nhom_no_mb = (array) $report->mb->nhom_no;
									$nhom_no_mn = (array) $report->mn->nhom_no;
									$nhom_no_vmc = (array) $report->vmc->nhom_no;
									for ($i = 0; $i <= 8; $i++) { 
								?>
								<tr>
									<td style="text-align: left; font-weight: bold; color: red;">B<?=$i?></td>
									<td style="text-align: right;"><?= number_format($nhom_no['nhom_'.$i]) ?? 0 ?></td>
									<td style="text-align: right;"><?= ($report->vfc->du_no_giai_ngan != 0) ? round(($nhom_no['nhom_'.$i] / $report->vfc->du_no_giai_ngan) * 100, 2) : 0 ?>%</td>
									<td style="text-align: right;"><?= ($report->vfc->du_no_cho_vay != 0) ? round(($nhom_no['nhom_'.$i] / $report->vfc->du_no_cho_vay) * 100, 2) : 0 ?>%</td>
									<td style="text-align: right;" colspan="2"><?= number_format($nhom_no_mb['nhom_'.$i]) ?? 0 ?></td>
									<td style="text-align: right;" colspan="2"><?= number_format($nhom_no_mn['nhom_'.$i]) ?? 0 ?></td>
									<td style="text-align: right;" colspan="2"><?= number_format($nhom_no_vmc['nhom_'.$i]) ?? 0 ?></td>
								</tr>
								<?php } ?>
								<tr>
									<td style="text-align: left; font-weight: bold;">Tổng HĐ quá hạn</td>
									<td style="text-align: right; color: red; font-weight: bold;" colspan="3"><?= number_format($report->vfc->tong_du_no_xau) ?></td>
									<td style="text-align: right; color: red; font-weight: bold;" colspan="2"><?= number_format($report->mb->tong_du_no_xau) ?></td>
									<td style="text-align: right; color: red; font-weight: bold;" colspan="2"><?= number_format($report->mn->tong_du_no_xau) ?></td>
									<td style="text-align: right; color: red; font-weight: bold;" colspan="2"><?= number_format($report->vmc->tong_du_no_xau) ?></td>
								</tr>
								<tr>
									<td style="text-align: left; font-weight: bold;">Tỷ lệ tiền quá hạn theo tiền giải ngân</td>
									<td style="text-align: right; color: red; font-weight: bold;" colspan="3"><?= ($report->vfc->du_no_giai_ngan != 0) ? round(($report->vfc->tong_du_no_xau / $report->vfc->du_no_giai_ngan) * 100, 2) : 0 ?>%</td>
									<td style="text-align: right; color: red; font-weight: bold;" colspan="2"><?= ($report->mb->du_no_giai_ngan != 0) ? round(($report->mb->tong_du_no_xau / $report->mb->du_no_giai_ngan) * 100, 2) : 0 ?>%</td>
									<td style="text-align: right; color: red; font-weight: bold;" colspan="2"><?= ($report->mn->du_no_giai_ngan != 0) ? round(($report->mn->tong_du_no_xau / $report->mn->du_no_giai_ngan) * 100, 2) : 0 ?>%</td>
									<td style="text-align: right; color: red; font-weight: bold;" colspan="2"><?= ($report->vmc->du_no_giai_ngan != 0) ? round(($report->vmc->tong_du_no_xau / $report->vmc->du_no_giai_ngan) * 100, 2) : 0 ?>%</td>
								</tr>
								<tr>
									<td style="text-align: left; font-weight: bold;">Tỷ lệ tiền quá hạn theo tiền đang cho vay</td>
									<td style="text-align: right; color: red; font-weight: bold;" colspan="3"><?= ($report->vfc->du_no_cho_vay != 0) ? round(($report->vfc->tong_du_no_xau / $report->vfc->du_no_cho_vay) * 100, 2) : 0 ?>%</td>
									<td style="text-align: right; color: red; font-weight: bold;" colspan="2"><?= ($report->mb->du_no_cho_vay != 0) ? round(($report->mb->tong_du_no_xau / $report->mb->du_no_cho_vay) * 100, 2) : 0 ?>%</td>
									<td style="text-align: right; color: red; font-weight: bold;" colspan="2"><?= ($report->mn->du_no_cho_vay != 0) ? round(($report->mn->tong_du_no_xau / $report->mn->du_no_cho_vay) * 100, 2) : 0 ?>%</td>
									<td style="text-align: right; color: red; font-weight: bold;" colspan="2"><?= ($report->vmc->du_no_cho_vay != 0) ? round(($report->vmc->tong_du_no_xau / $report->vmc->du_no_cho_vay) * 100, 2) : 0 ?>%</td>
								</tr>
							</tbody>
						</table>
					<?php } ?>
					<?php if ($type == 2) { ?>
						<?php
							if ($area == 'mb') {
								$str_area = 'Miền bắc';
							}
							if ($area == 'mn') {
								$str_area = 'Miền nam';
							}
							if ($area == 'vmc') {
								$str_area = 'Mekong';
							}
						?>
						<table id="datatable-button" class="table table-responsive stacktable table-quanlytaisan table-bordered">
							<thead>
								<tr style="background: #0a90eb; color: white">
									<th style="text-align: center; width: 25%" colspan="10"><?= $str_area ?></th>
								</tr>
							</thead>
							<tr>
								<td style="text-align: left; font-weight: bold;">Tiền giải ngân</td>
								<td style="text-align: right; color: red; font-weight: bold; font-weight: 14px" colspan="9"><?= number_format($report->du_no_giai_ngan) ?></td>
							</tr>
							<tr>
								<td style="text-align: left; font-weight: bold;">Tiền cho vay</td>
								<td style="text-align: right; color: red; font-weight: bold; font-weight: 14px" colspan="9"><?= number_format($report->du_no_cho_vay) ?></td>
							</tr>
							<tr>
								<td style="text-align: left; font-weight: bold;">Tỷ lệ tiền đang cho vay so với tiền giải ngân</td>
								<td style="text-align: right; color: red; font-weight: bold; font-weight: 14px" colspan="9"><?= ($report->du_no_giai_ngan != 0) ? round(($report->du_no_cho_vay / $report->du_no_giai_ngan) * 100, 2) : 0 ?>%</td>
							</tr>
							<tr style="color: red;">
								<td style="text-align: left; font-weight: bold; color: red;">Nhóm </td>
								<?php for ($i = 0; $i <= 8; $i++) { ?>
								<td style="text-align: left; font-weight: bold; color: red;">B<?= $i ?></td>
								<?php } ?>
							</tr>
							<tr>
								<td style="text-align: left; font-weight: bold;">Tổng </td>
								<?php 
									$nhom_no = (array) $report->nhom_no;
									for ($i = 0; $i <= 8; $i++) { 
								?>
								<td style="text-align: right;"><?= number_format($nhom_no['nhom_'.$i]) ?? 0 ?></td>
								<?php } ?>
							</tr>
							<tr>
								<td style="text-align: left; color: red; font-weight: bold; font-weight: bold; font-size: 14px; ">Tỷ lệ so với tiền giải ngân</td>
								<?php
									for ($i = 0; $i <= 8; $i++) { 
								?>
								<td style="text-align: right; color: red; font-weight: bold; font-weight: bold; font-size: 14px;"><?= ($report->du_no_giai_ngan != 0) ? round(($nhom_no['nhom_'.$i] / $report->du_no_giai_ngan) * 100, 2) : 0 ?>%</td>
								<?php } ?>
							</tr>
							<tr>
								<td style="text-align: left; color: red; font-weight: bold; font-weight: bold; font-size: 14px;">Tỷ lệ so với tiền đang cho vay</td>
								<?php
									for ($i = 0; $i <= 8; $i++) { 
								?>
								<td style="text-align: right; color: red; font-weight: bold; font-size: 14px;"><?= ($report->du_no_cho_vay != 0) ? round(($nhom_no['nhom_'.$i] / $report->du_no_cho_vay) * 100, 2) : 0 ?>%</td>
								<?php } ?>
							</tr>
							<?php 
								if (isset($store_report)) {
								foreach($store_report as $store_item) { 
									$check = false;
									echo '<tr>';
									echo '<td style="text-align: left; font-weight: bold;">'. $store_item->name .'</td>';
									if (isset($report->store)) {
									foreach ($report->store as $key_store_data => $store_data) {
										$store_data = (array) $store_data;
										if ($key_store_data == $store_item->_id->{'$oid'}) {
											$check = true;
											for ($i = 0; $i <= 8; $i++) {
							?>
								<td style="text-align: right;"><?= number_format($store_data['nhom_'. $i]) ?? '0' ?></td>
							<?php 
											}
										}
									}
								}
									if (!$check) {
										for ($i = 0; $i <= 8; $i++) {
											echo '<td style="text-align: right;">0</td>';
										}
									}
									echo '</tr>';
								}
								}
							?>
						</table>
					<?php } ?>

					<?php if ($type == 3) { ?>
						<table id="datatable-button" class="table table-responsive stacktable table-quanlytaisan table-bordered">
							<thead>
								<tr style="background: #0a90eb; color: white">
									<th style="text-align: center; width: 25%" colspan="4"><?= $store_report['name'] ?></th>
								</tr>
							</thead>
							<tr>
								<td style="text-align: left; font-weight: bold;">Tiền giải ngân</td>
								<td style="text-align: right; color: red; font-weight: bold; font-weight: 14px" colspan="3"><?= number_format($report->du_no_giai_ngan) ?></td>
							</tr>
							<tr>
								<td style="text-align: left; font-weight: bold;">Tiền đang cho vay</td>
								<td style="text-align: right; color: red; font-weight: bold; font-weight: 14px" colspan="3"><?= number_format($report->du_no_cho_vay) ?></td>
							</tr>
							<tr>
								<td style="text-align: left; font-weight: bold;">Tỉ lệ tiền đang cho vay so với tiền giải ngân</td>
								<td style="text-align: right; color: red; font-weight: bold; font-weight: 14px" colspan="3"><?= ($report->du_no_giai_ngan != 0) ? round(($report->du_no_cho_vay / $report->du_no_giai_ngan) * 100, 2) : 0 ?>%</td>
							</tr>
							<tr>
								<td style="text-align: left; font-weight: bold; color: red;">Nhóm</td>
								<td style="text-align: left; font-weight: bold;">Tổng tiền đang cho vay theo Bucket</td>
								<td style="text-align: left; font-weight: bold;">Tỷ lệ so với Tổng tiền giải ngân</td>
								<td style="text-align: left; font-weight: bold;">Tỷ lệ so với Tổng tiền đang cho vay</td>
							</tr>
							<?php
								$nhom_no = (array) $report->nhom_no;
								for ($i = 0; $i <= 8; $i++) {
							?>
								<tr>
									<td style="text-align: left; font-weight: bold; color: red;">B<?= $i ?></td>
									<td style="text-align: right;"><?= number_format($nhom_no['nhom_'. $i]) ?? '0' ?></td>
									<td style="text-align: right;"><?= ($report->du_no_giai_ngan != 0) ? round(($nhom_no['nhom_'. $i] / $report->du_no_giai_ngan) * 100, 2) : 0 ?>%</td>
									<td style="text-align: right;"><?= ($report->du_no_cho_vay != 0) ? round(($nhom_no['nhom_'. $i] / $report->du_no_cho_vay) * 100, 2) : 0 ?>%</td>
								</tr>
							<?php } ?>
						</table>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		let area = $('#area').val();
		if (area) {
			select[0].selectize.clearOptions();
			var formData = {
				area: $('#area').val(),
			};
			$.ajax({
				url: "/report_kt/ajax_change_area",
				type: "POST",
				data: formData,
				success: function (res) {
					let data = JSON.parse(res);
					data.data.map(item => {
						select[0].selectize.addOption(item)
					})
				},
				error: function (res) {
					console.log(data);
				}
			});
		}

		$('#area').change(function() {
			select[0].selectize.clearOptions();
			var formData = {
				area: $('#area').val(),
			};
			$.ajax({
				url: "/report_kt/ajax_change_area",
				type: "POST",
				data: formData,
				success: function (res) {
					let data = JSON.parse(res);
					data.data.map(item => {
						select[0].selectize.addOption(item)
					})
				},
				error: function (res) {
					console.log(data);
				}
			});
		})
	});

	function fnExcelReport(e)
	{
		var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
		var textRange; var j=0;
		tab = document.getElementById('datatable-button'); // id of table

		for(j = 0 ; j < tab.rows.length ; j++)
		{
			tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
			//tab_text=tab_text+"</tr>";
		}

		tab_text=tab_text+"</table>";
		tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
		tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
		tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

		var ua = window.navigator.userAgent;
		var msie = ua.indexOf("MSIE ");

		if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
		{
			txtArea1.document.open("txt/html","replace");
			txtArea1.document.write(tab_text);
			txtArea1.document.close();
			txtArea1.focus();
			sa=txtArea1.document.execCommand("SaveAs",true,"data.xls");
		}
		else {
			var sa = document.createElement('a');
			var data_type = 'data:application/vnd.ms-excel';
			var table_html = encodeURIComponent(tab_text);
			sa.href = data_type + ', ' + table_html;
			let d = new Date();
			let ye = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(d);
			let mo = new Intl.DateTimeFormat('en', { month: 'numeric' }).format(d);
			let da = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(d);
			let str_date = `${da}_${mo}_${ye}`;
			<?php if ($type == 1) { ?>
				sa.download = 'BC_VFC_'+ str_date +'.xls';
			<?php } else if ($type == 2) { ?>
				sa.download = 'BC_<?=$str_area?>_'+ str_date +'.xls';
			<?php } else if ($type == 3) { ?>
				sa.download = 'BC_<?=$store_report['name']?>_'+ str_date +'.xls';
			<?php } ?>
			sa.click();
			e.preventDefault();
		}
		return (sa);
	}
</script>

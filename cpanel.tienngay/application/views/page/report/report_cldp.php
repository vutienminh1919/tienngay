<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="row top_tiles">
		<div class="col-xs-9">
			<div class="page-title">
				<div class="title_left" style="width: 100%">
					<h3> Báo cáo kế toán
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a href="#">
								Báo cáo trích lập dự phòng các khoản HĐ quá hạn khó đòi</a>
						</small>
					</h3>
					<div class="alert alert-danger alert-result" id="div_error"
						 style="display:none; color:white;"></div>
				</div>
			</div>
		</div>
		<div class="col-xs-3">

		</div>
		<div class="col-xs-12">
			<div class="row">
				<form action="<?php echo base_url('report_kt/report_tldp') ?>" method="get" style="width: 100%;">
					<div class="col-md-2">
						<label></label>
						<select class="form-control" name="store" id="store">
							<option value="">-- Chọn phòng giao dịch --</option>
							<?php foreach($store_list as $store_item) { ?>
								<option value="<?= $store_item->_id ?>" <?= ($store == $store_item->_id) ? "selected" : '' ?> ><?= $store_item->name ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-md-2">
						<label></label>
						<select class="form-control" name="dept[]" id="group_dept" multiple="multiple">
							<option value="">-- Chọn nhóm --</option>
							<?php for($i = 1; $i <= 8; $i++) { ?>
								<option value="<?= $i ?>" <?= ($dept == $i) ? "selected" : '' ?>>B<?= $i ?></option>
							<?php } ?>
						</select>
					</div>

					<div class="col-md-2 text-right">
						<label></label>
						<button type="submit" class="btn btn-primary w-100"><i class="fa fa-search"
																			   aria-hidden="true"></i> <?= $this->lang->line('search') ?>
						</button>
					</div>
					<div class="col-md-2 text-right">
						<label></label>
					<button id="btnExport" class="btn btn-primary w-100" onclick="fnExcelReport();"> EXPORT </button>
					</div>
				</form>
			</div>

			<div class="table-responsive">
				<table id="datatable-button" class="table table-striped">
					<thead>
					<tr>
						<th>Nhóm </th>
						<th>Phòng giao dịch</th>
						<th>Số lượng hợp đồng</th>
						<th>Tổng giá trị tài sản đảm bảo</th>

						<th>Tổng tiền giải ngân lũy kế</th>
						<th>Gốc còn lại</th>
						<th>Tỉ lệ HĐ quá hạn</th>
						<th>Số tiền cần trích lập</th>
					</tr>
					</thead>
					<tbody>
					<?php
						if (!empty($report)) {
							$totalTaiSanDamBao = 0;
							$totalLuyKeTienGiaiNgan = 0;
							$totalDuNoGocConLai = 0;
							$totalTienTrichLap = 0;
							$totalSoHopDong = 0;
							foreach($report as $key => $item) {
								$totalTaiSanDamBao += $item->tai_san_dam_bao;
								$totalLuyKeTienGiaiNgan += $item->luy_ke_tien_giai_ngan;
								$totalDuNoGocConLai += $item->du_no_goc_con_lai;
								$totalTienTrichLap += $item->so_tien_can_trich_lap;
								$totalSoHopDong += $item->so_hop_dong;
					?>
						<tr>
							<td><?= isset($item->group_dept) ? "B".$item->group_dept : ''; ?></td>
							<td><?= isset($item->store) ? $item->store->name : ''; ?></td>
							<td><?= isset($item->so_hop_dong) ? number_format($item->so_hop_dong) : 0; ?></td>
							<td><?= isset($item->tai_san_dam_bao) ? number_format($item->tai_san_dam_bao) : 0; ?></td>
							<td><?= isset($item->luy_ke_tien_giai_ngan) ? number_format($item->luy_ke_tien_giai_ngan) : 0; ?></td>
							<td><?= isset($item->du_no_goc_con_lai) ? number_format($item->du_no_goc_con_lai) : 0; ?></td>
							<td><?= isset($item->ti_le_du_no_xau) ? number_format($item->ti_le_du_no_xau, 2) : 0; ?>%</td>
							<td><?= isset($item->so_tien_can_trich_lap) ? number_format($item->so_tien_can_trich_lap) : 0; ?></td>
						</tr>
					<?php }} ?>
						<tr style="font-weight: bold">
							<td>Tổng</td>
							<td></td>
							<td><?= number_format($totalSoHopDong) ?></td>
							<td><?= number_format($totalTaiSanDamBao) ?></td>
							<td><?= number_format($totalLuyKeTienGiaiNgan) ?></td>
							<td><?= number_format($totalDuNoGocConLai) ?></td>
							<td></td>
							<td><?= number_format($totalTienTrichLap) ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	var selectStore = $('#store').selectize({
		create: false,
		valueField: 'code_vbi',
		labelField: 'name',
		searchField: 'name',
		sortField: {
			field: 'name',
			direction: 'asc'
		}
	});

	var select = $('#group_dept').selectize({
		create: false,
		valueField: 'code_vbi',
		labelField: 'name',
		searchField: 'name',
		sortField: {
			field: 'name',
			direction: 'asc'
		}
	});
	select[0].selectize.setValue(<?= $selectStore ?>);

	<?php
	$select = '[';
	if ( is_array($dept) ) {
		foreach ($dept as $key => $itemDept) {
			$select .= '"'.$itemDept.'",';
		}
	}
	$select .= ']';
	?>
	select[0].selectize.setValue(<?= $select ?>);

	function fnExcelReport()
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
			sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
		}
		else                 //other browser not tested on IE 11
			sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));

		return (sa);
	}
</script>

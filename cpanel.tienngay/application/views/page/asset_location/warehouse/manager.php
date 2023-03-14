<div class="right_col" role="main">
	<div class="container container-xt">
		<div class="wrapper-top">
			<div class="">
				<h3>Quản lý chi tiết xuất nhập tồn - thiết bị định vị</h3>
			</div>
			<div>
				<a href="<?php echo base_url("assetLocation/history") ?>" target="_blank">
					<button type="button" class="btn btn-success btn-top">Lịch sử thiết bị <img class="theavatar"
																								src="<?php echo base_url("assets/imgs/ql_xnt/time.svg") ?>"
																								alt=""></button>
				</a>
			</div>
		</div>
		<div class="content-cart">
			<h5>Báo cáo tháng <?php echo $_GET['month'] ?? date('Y-m') ?></h5>
			<div class="container-cart">
				<div class="cart-input">
					<p>Thời gian </p>
					<input class="textbox-n report-month" type="month" name="month"
						   value="<?php echo $_GET['month'] ?? date('Y-m') ?>">
				</div>
				<div class="cart-item">
					<p>Số lượng tồn đầu </p>
					<h5><?php echo $report_all->so_luong_ton_dau_thang ?? 0 ?></h5>
					<h6><?php echo !empty($report_all->tong_tien_ton_dau_thang) ? number_format($report_all->tong_tien_ton_dau_thang) : 0 ?>
						<span>&nbsp;vnđ</span></h6>
				</div>
				<div class="cart-item">
					<p>Số lượng nhập</p>
					<h5><?php echo $report_all->so_luong_nhap ?? 0 ?></h5>
					<h6><?php echo !empty($report_all->tong_tien_nhap) ? number_format($report_all->tong_tien_nhap) : 0 ?>
						<span>&nbsp;vnđ</span></h6>
				</div>
				<div class="cart-item">
					<p>Số lượng xuất</p>
					<h5><?php echo $report_all->so_luong_xuat ?? 0 ?></h5>
					<h6><?php echo !empty($report_all->tong_tien_xuat) ? number_format($report_all->tong_tien_xuat) : 0 ?>
						<span>&nbsp;vnđ</span></h6>
				</div>
				<div class="cart-item">
					<p>Số lượng tồn </p>
					<h5><?php echo $report_all->so_luong_ton_cuoi_thang ?? 0 ?></h5>
					<h6><?php echo !empty($report_all->tong_tien_ton_cuoi_thang) ? number_format($report_all->tong_tien_ton_cuoi_thang) : 0 ?>
						<span>&nbsp;vnđ</span></h6>
				</div>
			</div>
		</div>
		<div class="panel">
			<div class="panel-body">
				<div class="form-content">
					<div class="form-text">
						<h5>Danh sách các kho HO</h5>
						<div class="form-button">
							<!--					<button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#exampleModal">Tìm kiếm <img class="theavatar" src="-->
							<?php //echo base_url("assets/imgs/ql_xnt/search.svg") ?><!--" alt=""></button>-->
							<a type="button" class="btn btn-outline-success"
							   href="<?php echo base_url("assetLocation/excel_warehouse_manager?month=" . $_GET['month'] . '&type_excel=ho') ?>"
							   target="_blank">Xuất excel <img class="theavatar"
															   src="<?php echo base_url("assets/imgs/ql_xnt/excel.svg") ?>"
															   alt=""></a>
							<!-- Modal -->
							<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
								 aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<div class="modal-item">
												<p>Thời gian </p>
												<div class="modal-content11">
													<input placeholder="Từ ngày" class="textbox-n" type="text"
														   onfocus="(this.type='date')" id="date">
													<input placeholder="Đến ngày" class="textbox-n" type="text"
														   onfocus="(this.type='date')" id="date">
												</div>
											</div>
											<div class="modal-item">
												<p>SL tồn đầu</p>
												<div class="modal-content11">
													<input placeholder="Từ " type="number">
													<input placeholder="Đến" type="number">
												</div>
											</div>
											<div class="modal-item">
												<p>SL nhập</p>
												<div class="modal-content11">
													<input placeholder="Từ " type="number">
													<input placeholder="Đến" type="number">
												</div>
											</div>
											<div class="modal-item">
												<p>SL xuất</p>
												<div class="modal-content11">
													<input placeholder="Từ " type="number">
													<input placeholder="Đến" type="number">
												</div>
											</div>
											<div class="modal-item">
												<p>SL tồn cuối</p>
												<div class="modal-content11">
													<input placeholder="Từ " type="number">
													<input placeholder="Đến " type="number">
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy
											</button>
											<button type="button" class="btn btn-primary">Tìm kiếm</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-table table-responsive">
					<table class="table">
						<thead class="thead-light">
						<tr>
							<th scope="col" style="text-align: center">STT</th>
							<th scope="col" style="text-align: center">Tên Kho</th>
							<th scope="col" style="text-align: center">SL tồn đầu</th>
							<th scope="col" style="text-align: center">Giá trị tồn đầu</th>
							<th scope="col" style="text-align: center">SL nhập</th>
							<th scope="col" style="text-align: center">Giá trị nhập</th>
							<th scope="col" style="text-align: center">SL xuất</th>
							<th scope="col" style="text-align: center">Giá trị xuất</th>
							<th scope="col" style="text-align: center">SL tồn cuối</th>
							<th scope="col" style="text-align: center">Giá trị tồn cuối</th>
						</tr>
						</thead>
						<tbody class="tbody-light">
						<?php foreach ($report_partial_ho as $key => $value) : ?>
							<tr style="text-align: center">
								<td><?php echo ++$key ?></td>
								<td><?php echo !empty($value->name) ? $value->name : '' ?></td>
								<td><?php echo !empty($value->report) ? $value->report->so_luong_ton_dau_thang : 0 ?></td>
								<td><?php echo !empty($value->report) ? number_format($value->report->tong_tien_ton_dau_thang) : 0 ?></td>
								<td><?php echo !empty($value->report) ? $value->report->so_luong_nhap : 0 ?></td>
								<td><?php echo !empty($value->report) ? number_format($value->report->tong_tien_nhap) : 0 ?></td>
								<td><?php echo !empty($value->report) ? $value->report->so_luong_xuat : 0 ?></td>
								<td><?php echo !empty($value->report) ? number_format($value->report->tong_tien_xuat) : 0 ?></td>
								<td><?php echo !empty($value->report) ? $value->report->so_luong_ton_cuoi_thang : 0 ?></td>
								<td><?php echo !empty($value->report) ? number_format($value->report->tong_tien_ton_cuoi_thang) : 0 ?></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="panel">
			<div class="panel-body">
				<div class="form-content">
					<div class="form-text">
						<h5>Danh sách các kho PGD - VFC</h5>
						<!--						<div class="form-button">-->
						<a type="button" class="btn btn-outline-success"
						   href="<?php echo base_url("assetLocation/excel_warehouse_manager?month=" . $_GET['month'] . '&type_excel=pgd') ?>"
						   target="_blank">Xuất
							excel <img class="theavatar"
									   src="
						<?php echo base_url("assets/imgs/ql_xnt/excel.svg") ?>"
									   alt=""></a>
					</div>
				</div>
			</div>
			<div class="form-table table-responsive">
				<table class="table">
					<thead class="thead-light">
					<tr>
						<th scope="col" style="text-align: center">STT</th>
						<th scope="col" style="text-align: center">Tên PGD</th>
						<th scope="col" style="text-align: center">SL tồn đầu</th>
						<th scope="col" style="text-align: center">Giá trị tồn đầu</th>
						<th scope="col" style="text-align: center">SL nhập</th>
						<th scope="col" style="text-align: center">Giá trị nhập</th>
						<th scope="col" style="text-align: center">SL xuất</th>
						<th scope="col" style="text-align: center">Giá trị xuất</th>
						<th scope="col" style="text-align: center">SL tồn cuối</th>
						<th scope="col" style="text-align: center">Giá trị tồn cuối</th>
					</tr>
					</thead>
					<tbody class="tbody-light">
					<?php foreach ($report_partial_pgd as $k => $item) : ?>
						<tr style="text-align: center">
							<td><?php echo ++$k ?></td>
							<td><?php echo !empty($item->name) ? $item->name : '' ?></td>
							<td><?php echo !empty($item->report) ? $item->report->so_luong_ton_dau_thang : 0 ?></td>
							<td><?php echo !empty($item->report) ? number_format($item->report->tong_tien_ton_dau_thang) : 0 ?></td>
							<td><?php echo !empty($item->report) ? $item->report->so_luong_nhap : 0 ?></td>
							<td><?php echo !empty($item->report) ? number_format($item->report->tong_tien_nhap) : 0 ?></td>
							<td><?php echo !empty($item->report) ? $item->report->so_luong_xuat : 0 ?></td>
							<td><?php echo !empty($item->report) ? number_format($item->report->tong_tien_xuat) : 0 ?></td>
							<td><?php echo !empty($item->report) ? $item->report->so_luong_ton_cuoi_thang : 0 ?></td>
							<td><?php echo !empty($item->report) ? number_format($item->report->tong_tien_ton_cuoi_thang) : 0 ?></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</div>
<style>
	* {
		margin: 0;
		padding: 0;
		box-sizing: border-box;
	}

	.breadcrumb {
		padding: 0px;
	}

	.container-xt {
		width: 100%;
		display: flex;
		flex-direction: column;
		gap: 24px;
	}

	.wrapper-top {
		display: flex;
		justify-content: space-between;
	}

	.content-cart h5 {
		font-style: normal;
		font-weight: 600;
		font-size: 20px;
		line-height: 24px;
		color: rgba(103, 103, 103, 1);
	}

	.container-cart {
		display: flex;
		gap: 16px;
	}

	.cart-input {
		width: 307.4px;
		padding-left: 8px;
		height: 108px;
		display: flex;
		flex-direction: column;
		gap: 4px;
	}

	.cart-input p {
		font-style: normal;
		font-weight: 400;
		font-size: 14px;
		line-height: 16px;
		display: flex;
		align-items: center;
	}

	.cart-input input {
		width: 291px;
		height: 35px;
		background: #FFFFFF;
		border: 1px solid #D8D8D8;
		border-radius: 5px;
		padding: 16px;
	}


	.cart-item {
		padding: 16px;
		width: 307.4px;
		padding-left: 8px;
		height: 108px;
		background: #FFFFFF;
		border: 1px solid #D8D8D8;
		box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
		border-radius: 8px;
	}

	.cart-item p {
		font-style: normal;
		font-weight: 600;
		font-size: 16px;
		line-height: 20px;
		color: rgba(103, 103, 103, 1);
	}

	.cart-item h5 {
		font-style: normal;
		font-weight: 600;
		font-size: 20px;
		line-height: 24px;
		color: #1D9752;
	}

	.cart-item h6 {
		font-style: normal;
		font-weight: 600;
		font-size: 16px;
		line-height: 20px;
		color: #C70404;
	}

	.containerForm-warehouse {
		width: 100%;
		height: 352px;
		background: #FFFFFF;
		border: 1px solid #EBEBEB;
		box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
		border-radius: 8px;
	}

	.containerForm-warehouse h5 {
		font-style: normal;
		font-weight: 600;
		font-size: 20px;
		line-height: 24px;
		color: rgba(59, 59, 59, 1);
		/* padding: 16px; */
		padding-left: 16px;
	}

	.container-select {
		display: flex;
		gap: 8px;
	}

	.container-select select {
		gap: 8px;
		width: 295px;
		height: 40px;
		background: #FFFFFF;
		border: 1px solid #D8D8D8;
		border-radius: 5px;
	}

	.container-select option {
		font-style: normal;
		font-weight: 400;
		font-size: 14px;
		line-height: 16px;
		display: flex;
		align-items: center;
	}

	.container-select p {
		font-style: normal;
		font-weight: 400;
		font-size: 14px;
		line-height: 16px;
	}

	.containerForm-pgd {
		width: 100%;
		height: 640px;
		background: #FFFFFF;
		border: 1px solid #EBEBEB;
		box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
		border-radius: 8px;
	}

	.containerForm-pgd h5 {
		font-style: normal;
		font-weight: 600;
		font-size: 20px;
		line-height: 24px;
		color: rgba(59, 59, 59, 1);
		padding-left: 16px;
	}

	.form-text {
		display: flex;
		justify-content: space-between;
	}

	.modal-body {
		display: flex;
		flex-direction: column;
		gap: 20px;
	}

	.modal-item p {
		font-style: normal;
		font-weight: 400;
		font-size: 14px;
		line-height: 16px;
	}

	.modal-item input {
		padding: 16px;
		display: flex;
		gap: 8px;
		width: 290.5px;
		height: 40px;
		background: #FFFFFF;
		border: 1px solid #D8D8D8;
		border-radius: 5px;
		padding-left: 8px;
	}

	.modal-content11 {
		display: flex;
		gap: 16px;
	}

	.thead-light {
		background: #E8F4ED;
		font-style: normal;
		font-weight: 600;
		font-size: 14px;
		line-height: 16px;
		color: #262626;
	}

	.tbody-light {
		font-style: normal;
		font-weight: 400;
		font-size: 14px;
		line-height: 16px;
		color: rgba(103, 103, 103, 1);
	}
</style>
<script>
	$(document).ready(function () {
		$('.report-month').change(function () {
			let month = $("input[name='month']").val()
			window.location.href = _url.base_url + "assetLocation/warehouse_manager?month=" + month;
		})
	})
</script>

<?php $vehicles = !empty($_GET['vehicles']) ? $_GET['vehicles'] : "";
$name_property = !empty($_GET['name_property']) ? $_GET['name_property'] : ""; ?>
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="col-xs-12 fix_to_col" id="fix_to_col">
		<div class="table_app_all">
			<div class="top">
				<div class="row">
					<div class="col-xs-8">
						<div class="title">
                            <span class="tilte_top_tabs">
								Báo cáo tổng hợp đối tác Marketing
							</span>
						</div>
					</div>
				</div>
			</div>
			<div class="middle table_tabs">
				<div class="table-responsive">
					<div class="head">
						<div class="row">
							<div class="col-md-2">
								<h3>
									Danh sách
								</h3>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<div class="total_count btn">
											<span>Tổng list theo tháng</span><span>123</span>
										</div>
									</div>
									<div class="col-md-6">
										<div class="total_count btn">
											<span>Tổng list theo tháng</span><span>123</span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="row">
									<div class="col-md-4">
										<a href="">
											<img style="border-radius: 5px;" class="not_hover"
												 src="<?php echo base_url('assets/home/') ?>images/excel.png"
												 alt="list">
										</a>
									</div>
									<div class="col-md-8">
										<div class="search">
											<input style="float: left;width: 86%;margin-right: 8px;" type="text"
												   class="form-control" id="search" placeholder="Nhập tìm kiếm"
												   name="search">
											<button style="margin-right: 0" class="btn btn-success" type="button">
												<i class="fa fa-search"></i>
											</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<table id="" class="table table-striped">
						<thead>
						<tr style="text-align: center">
							<th style="text-align: left;">STT</th>
							<th style="text-align: center">ID</th>
							<th style="text-align: center">Ngày nhập</th>
							<th style="text-align: center">Tên khách hàng</th>
							<th style="text-align: center">SĐT</th>
							<th style="text-align: center">Trạng thái</th>
							<th style="text-align: center">Lý do huỷ</th>
							<th style="text-align: center">ST giải ngân</th>
						</tr>
						</thead>
						<tbody align="center">
						<tr id="propertyOto">
							<td style="text-align: left;">1</td>
							<td>12345678</td>
							<td>15/07/2021</td>
							<td>Lê Đức Mạnh</td>
							<td>0967283881</td>
							<td><strong style="color: red">Đã Huỷ</strong></td>
							<td>
								Bị huỷ
							</td>
							<td style="position: relative;">
								450.000.000đ
							</td>
						</tr>
						<tr id="propertyOto">
							<td style="text-align: left;">1</td>
							<td>12345678</td>
							<td>15/07/2021</td>
							<td>Lê Đức Mạnh</td>
							<td>0967283881</td>
							<td><strong style="color: red">Đã Huỷ</strong></td>
							<td>
								Bị huỷ
							</td>
							<td style="position: relative;">
								450.000.000đ
							</td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>

		</div>
	</div>
</div>
<style type="text/css">
	.head h3 {
		color: #0CA678;
	}

	.total_count {
		background: #E8E8E8;
		border: 1px solid #D9D9D9;
		width: 50%;
	}

	.total_count span:first-child {
		color: #595959;
		float: left;
	}

	.total_count span:last-child {
		color: #EC1E24;
		font-weight: 600;
		float: right;
	}

	@media (min-width: 768px) {
		.col-sm-1\.5 {
			width: 11.9%;
		}
	}

	.btn_select_radio, .btn_select_list_grade {
		display: none;
		clear: both;
	}

	.grade_level label {
		margin-top: 10px;
		margin-bottom: 10px;
		text-transform: uppercase;
		color: #000;
	}

	.box_list {
		margin-bottom: 10px;
	}

	.box_box {
		background: #fff;
		padding: 7px;
		color: #000;
	}

	.box_box .row {
		align-items: center;
	}

	.title_box_list {
		display: list-item;
		margin-left: 20px;
	}

	.box_box .x_box_list {
		width: 50%;
		margin: 0 auto;
	}

	.modal-content {
		overflow: unset;
	}

	.btn-group, .btn-group-vertical {
		display: block;
	}

	.multiselect {
		width: 100%;
		text-align: left;
		display: block;
		float: unset !important;
	}

	.multiselect-container {
		width: 100%;
	}

	.dropdown-menu > .active > a, .dropdown-menu > .active > a:focus, .dropdown-menu > .active > a:hover {
		background: unset;
	}

	.btn-success {
		background: #047734;
		border: 1px solid #047734;
	}

	.modal-title {
		color: #333;
	}

	label {
		color: #777171;
	}

	.table-responsive {
		overflow-x: unset;
		overflow: unset;
	}

	tr td .dropdown-menu {
		left: -125px;
	}

	.button_functions .dropdown-menu {
		left: -50px;
	}

	.btn-fitler .dropdown-menu {
		left: -140px;
		width: 300px;
	}

	.marquee {
		display: none;
	}

	.modal {
		opacity: 1;
	}

	.company_close.btn-secondary {
		background: #EFF0F1;
		color: #000;
		border: 1px solid;
	}

	.checkbox {
		filter: invert(1%) hue-rotate(290deg) brightness(1);
	}

	.btn_bar {
		border-style: none;
		background: unset;
		margin-bottom: 0;
	}

	.hover {
		display: none;
	}

	.btn_bar:hover .not_hover {
		display: none;
	}

	.btn_bar:hover .hover {
		display: block;
		margin-bottom: -4px;
	}

	.propertype {
		position: absolute;
		border-top: unset !important;
		padding: 6px !important;
	}

	.propertype .dropdown-menu {
		left: -105px;
	}

	#alert_delete_pro_choo .delete_property {
		position: fixed;
		width: 378px;
		height: 175px;
		background: #fff;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		margin: auto;
		display: flex;
		align-items: center;
		border-radius: 5px;
		border-top: 2px solid #D63939;
		padding: 0 25px;
		color: #000;
	}

	#alert_delete_pro_choo .delete_property .popup_content h2 {
		color: #000;
	}

	.caret {
		float: right;
		position: relative;
		top: 8px;
	}
</style>

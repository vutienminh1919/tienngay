<?php $fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
$status_sale = !empty($_GET['status_sale']) ? $_GET['status_sale'] : "";
$utm_source = !empty($_GET['utm_source']) ? $_GET['utm_source'] : "";
?>
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
                            <span class="tilte_top_tabs" style="font-size: 28px">
								Báo cáo lead đối tác MKT
							</span>
						</div>
					</div>
					<div class="col-md-4 text-right">
						<a href="<?php echo base_url('report_telesale/index_reportMkt') ?>" class="btn " style="background-color: #e8e8e8">Trở lại</a>
					</div>
				</div>
			</div>
			<br><br>
			<div class="middle table_tabs">

					<div class="head">
						<div class="row">
							<div class="col-md-2">
								<h3>
									Danh sách
								</h3>
							</div>
							<br>
							<div class="col-md-10">
								<div class="row" style="justify-content: flex-end">
									<div class="col-md-12">
										<form action="<?php echo base_url('report_telesale/search_accesstrade') ?>"  method="get">
										<div class="search">
											<div class="col-md-3">
												<input type="datetime-local" name="fdate" class="form-control" value="<?= !empty($fdate) ? $fdate : "" ?>" >
											</div>
											<div class="col-md-3">
												<input type="datetime-local" name="tdate" class="form-control" value="<?= !empty($tdate) ? $tdate : "" ?>">
											</div>
											<div class="col-md-2">
												<select class="form-control" name="status_sale">
													<option value="">-- Tất cả --</option>
													<?php
													foreach (lead_status() as $key => $value) {
														?>
														<option
															value="<?= $key ?>" <?= ($key == $status_sale) ? "selected" : "" ?>><?= $value ?></option>
													<?php } ?>
												</select>
											</div>
											<?php if (!$is_user_phan_nguyen) : ?>
												<div class="col-md-2">
													<select class="form-control" name="utm_source">
														<option value="">-- Tất cả nguồn --</option>
															<option value="accesstrade" <?= ($utm_source == "accesstrade") ? "selected" : "" ?>>Accesstrade</option>
															<option value="masoffer" <?= ($utm_source == "masoffer") ? "selected" : "" ?>>Masoffer</option>
															<option value="Toss" <?= ($utm_source == "Toss") ? "selected" : "" ?>>Toss</option>
															<option value="jeff" <?= ($utm_source == "jeff") ? "selected" : "" ?>>Jeff</option>
															<option value="Dinos" <?= ($utm_source == "Dinos") ? "selected" : "" ?>>Dinos</option>
															<option value="Crezu" <?= ($utm_source == "Crezu") ? "selected" : "" ?>>Crezu</option>
															<option value="phan_nguyen" <?= ($utm_source == "phan_nguyen") ? "selected" : "" ?>>Phan Nguyễn</option>
													</select>
												</div>
											<?php endif; ?>
											<div class="col-md-2 text-right">
												<button type="submit" class="btn btn-primary pull-left" style="width: 50px;"><i class="fa fa-search" aria-hidden="true"></i></button>
												<a style="width: 50px; text-align: center;" class="btn btn-success" target="_blank" href=<?= base_url() ?>excel/exportListMkt?fdate=<?= $fdate . '&tdate=' . $tdate  . '&utm_source=' . $utm_source . '&status_sale=' . $status_sale ?>>
													<i class="fa fa-file-excel-o" aria-hidden="true"></i>
												</a>
											</div>
										</div>
										</form>
									</div>

								</div>
							</div>

							<div class="col-md-6">
								<div class="row">
									<div class="col-md-3">
										<div class="total_count btn">
											<span>Tổng số:</span><span><?= !empty($count) ? number_format($count) : 0 ?></span>
										</div>
									</div>


								</div>
							</div>
							<br>
						<br><br>
					</div>
						<div class="table-responsive" style="overflow: auto; min-height: 500px;">
							<table id="" class="table table-striped">
								<thead>
								<tr style="text-align: center">
									<th style="text-align: left; font-size: 18px">STT</th>
									<th style="text-align: center; font-size: 18px">Transaction_id</th>
									<th style="text-align: center; font-size: 18px">Ngày tạo</th>
									<th style="text-align: center; font-size: 18px">Nguồn lead</th>
									<th style="text-align: center; font-size: 18px">Tên khách hàng</th>
									<th style="text-align: center; font-size: 18px">Số điện thoại</th>
									<th style="text-align: center; font-size: 18px">PGD</th>
									<th style="text-align: center; font-size: 18px">Trạng thái lead</th>
									<th style="text-align: center; font-size: 18px">Lý do huỷ</th>
									<th style="text-align: center; font-size: 18px">Trạng thái hợp đồng</th>
									<th style="text-align: center; font-size: 18px">Số tiền vay</th>
								</tr>
								</thead>
								<tbody align="center">
								<?php if (!empty($result)): ?>
								<?php foreach ($result as $key => $value): ?>
								<tr id="propertyOto">
									<td style="text-align: left;"><?= ++$key ?></td>
									<td><?= !empty($value->_id) ? (string)$value->_id->{'$oid'} : "" ?></td>
									<td><?= !empty($value->created_at) ? date("d/m/Y H:i:s", $value->created_at) : "" ?></td>
									<td><?= !empty($value->utm_source) ? $value->utm_source : "" ?></td>
									<td><?= !empty($value->fullname) ? $value->fullname : "" ?></td>
									<td><?= !empty($value->phone_number) ? hide_phone($value->phone_number) : "" ?></td>
									<td><?= !empty($value->store_name) ? $value->store_name : "" ?></td>
									<td><strong style="color: red"><?= !empty($value->status_sale) ? lead_status($value->status_sale) : "" ?></strong></td>
									<td>
										<?= !empty($value->reason_cancel) ? reason($value->reason_cancel) : "" ?>
									</td>
									<td style="position: relative;">
										<strong style="color: green"><?= !empty($value->status_hd) ? contract_status($value->status_hd) : "" ?></strong>
									</td>
									<td style="position: relative;">
										<strong><?= !empty($value->amount_money) ? number_format($value->amount_money) : "" ?></strong>
									</td>
								</tr>
								<?php endforeach; ?>
								<?php endif; ?>
								</tbody>
						</table>
						</div>
					<div class="">
						<?php echo $pagination ?>
					</div>
				</div>
		</div>
	</div>
</div>
<style type="text/css">
	.btn.btn-primary:not(:hover) {
		background-color: #616b89;
		border-color: #556080;
	}
	.exel {
		background-color: #0f7e12;
		border-color: #0f7e12;
		border-radius: 5px;
		height: 34px;
		display: flex;
		justify-content: center;
		align-items: center;
		font-size: 15px;
	}
	.exel a{
		color: #fff;
	}
	.head h3 {
		color: #0CA678;
	}

	.total_count {
		background: #E8E8E8;
		border: 1px solid #D9D9D9;
		width: 100%;
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

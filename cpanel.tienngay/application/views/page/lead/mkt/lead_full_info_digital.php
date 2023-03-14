<?php
$code_store = !empty($_GET['code_store']) ? $_GET['code_store'] : "";
$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
?>
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
					<h3>Thông tin lead - Full Info (Digital)
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>/ <a href="#">MKT</a>
							/ <a href="#">Thông tin lead - Full Info (Digital)</a>
						</small>
					</h3>
					<div class="alert alert-danger alert-result" id="div_error"
						 style="display:none; color:white;"></div>
				</div>
			</div>
		</div>
		<div class="col-xs-3">

		</div>


		<div class="row">

			<form action="<?php echo base_url('lead_custom/mkt_lead_full_info_digital') ?>" method="get"
				  style="width: 100%;">
				<div class="row">
					<div class="col-lg-3">
						<div class="input-group">
							<span class="input-group-addon"><?php echo $this->lang->line('from') ?></span>
							<input type="date" name="fdate" class="form-control"
								   value="<?= isset($_GET['fdate']) ? $_GET['fdate'] : date("Y-m-d") ?>">
						</div>
					</div>
					<div class="col-lg-3">
						<div class="input-group">
							<span class="input-group-addon"><?php echo $this->lang->line('to') ?></span>
							<input type="date" name="tdate" class="form-control"
								   value="<?= isset($_GET['tdate']) ? $_GET['tdate'] : date("Y-m-d") ?>">

						</div>
					</div>
					<div class="col-lg-2">
						<select class="form-control" name="source">
							<option value="">Chọn nguồn</option>
							<?php $source = isset($_GET['source']) ? $_GET['source'] : '-';
							$source = ($source == "") ? "-" : $source;
							foreach (lead_nguon() as $key => $item) { ?>
								<option <?php echo $source == $key ? 'selected' : '' ?>
										value="<?= $key ?>"><?= $item ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-lg-2">
						<?php $utm_source = isset($_GET['utm_source']) ? $_GET['utm_source'] : ''; ?>
						<input name="utm_source" placeholder="Nhập utm_source" value="<?= $utm_source ?>"
							   class="form-control" type="text">
					</div>
					<div class="col-lg-2">
						<?php $utm_campaign = isset($_GET['utm_campaign']) ? $_GET['utm_campaign'] : ''; ?>
						<input name="utm_campaign" placeholder="Nhập utm_campaign" value="<?= $utm_campaign ?>"
							   class="form-control" type="text">
					</div>
				</div>
				<div class="row">
					<div class="col-lg-2">
						<select class="form-control" name="area" id="selectize_area">
							<option value="">Chọn khu vực</option>
							<?php $area = isset($_GET['area']) ? $_GET['area'] : '';
							foreach ($provinces as $key => $item) { ?>
								<option <?php echo $area == $item->code ? 'selected' : '' ?>
										value="<?= $item->code ?>"><?= $item->name ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-lg-2">

						<select id="selectize_store" class="form-control" name="code_store[]" multiple="multiple">
							<option value="">Chọn phòng giao dịch</option>
							<?php foreach ($storeData as $p) { ?>
								<option <?php if (is_array($code_store)) {
									echo in_array($p->id, $code_store) ? 'selected' : '';
								} ?> value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
							<?php } ?>
						</select>
					</div>

					<div class="col-lg-2 text-right">
						<button type="submit" class="btn btn-primary w-100"><i class="fa fa-search"
																			   aria-hidden="true"></i> <?= $this->lang->line('search') ?>
						</button>
					</div>
					<div class="col-lg-2 text-right">
						<a style="background-color: #18d102;"
						   href="<?= base_url() ?>excel/exportLeadFullInfo?fdate=<?= $fdate . '&tdate=' . $tdate . '&code_store=' . $code_store . '&source=' . $source . '&utm_source=' . $utm_source . '&utm_campaign=' . $utm_campaign . '&area=' . $area . '&isExport=1' ?>"
						   class="btn btn-primary w-100" target="_blank"><i class="fa fa-file-excel-o"
																			aria-hidden="true"></i>&nbsp; Xuất excel</a>
					</div>

				</div>
			</form>

			<div class="table-responsive" style="width: 100%;">
				<table id="datatable-buttons" class="table table-striped ">
					<thead>
					<tr>
						<th>#</th>
						<th>Ngày giờ</th>
						<th>UTM Source</th>
						<th>UTM Campaign</th>
						<th>Họ Tên</th>
						<th>Email</th>
						<th>Số điện thoại</th>
						<th>Tình trạng KH</th>
						<th>Lý do hủy</th>
						<th>Địa chỉ hộ khẩu</th>
						<th>Nơi ở hiện tại</th>
						<th>Thông tin công việc</th>
						<th>Hình thức vay</th>
						<th>Gốc còn lại</th>
						<th>HÌnh thức thanh toán</th>
						<th>Kỳ hạn</th>
						<th>Số lần đăng ký</th>
					</tr>
					</thead>
					<tbody name="list_lead">
					<?php

					if (!empty($mktData)) {
						$n = 1;
						foreach ($mktData as $key => $mkt) {

							?>
							<tr>
								<td><?php echo $n++ ?></td>
								<td><?= !empty($mkt->created_at) ? date('d/m/Y H:i:s', $mkt->created_at) : "" ?></td>
								<td><?= ($mkt->utm_source) ? $mkt->utm_source : '' ?></td>
								<td><?= ($mkt->utm_campaign) ? $mkt->utm_campaign : '' ?></td>
								<td><?= ($mkt->fullname) ? $mkt->fullname : '' ?></td>
								<td><?= ($mkt->email) ? $mkt->email : '' ?></td>
								<td><?= ($mkt->phone_number) ? hide_phone($mkt->phone_number) : '' ?></td>
								<td><?= ($mkt->status_sale) ? lead_status($mkt->status_sale) : '' ?></td>
								<td><?= ($mkt->reason_cancel) ? reason($mkt->reason_cancel) : '' ?></td>
								<td><?= ($mkt->hk_ward) ? get_ward_name_by_code($mkt->hk_ward) : '' ?> -
									<?= ($mkt->hk_district) ? get_district_name_by_code($mkt->hk_district) : '' ?> -
									<?= ($mkt->hk_province) ? get_province_name_by_code($mkt->hk_province) : '' ?></td>
								<td><?= ($mkt->ns_ward) ? get_ward_name_by_code($mkt->ns_ward) : '' ?> -
									<?= ($mkt->ns_district) ? get_district_name_by_code($mkt->ns_district) : '' ?> -
									<?= ($mkt->ns_province) ? get_province_name_by_code($mkt->ns_province) : '' ?></td>

								<td><?= ($mkt->com) ? $mkt->com : '' ?>-<br>
									<?= ($mkt->position) ? $mkt->position : '' ?></td>
								<td><?= ($mkt->type_finance) ? lead_type_finance($mkt->type_finance) : '' ?></td>

								<td><?= ($mkt->debt) ? number_format($mkt->debt) : '0' ?></td>
								<td><?= ($mkt->type_repay) ? type_repay($mkt->type_repay) : '' ?></td>
								<td><?= ($mkt->loan_time) ? loan_time($mkt->loan_time) : '' ?></td>
								<td><?= ($mkt->sdt_trung) ? $mkt->sdt_trung : '0' ?></td>

							</tr>
						<?php }
					} ?>
					</tbody>
				</table>

			</div>
			<div class="">
				<?php echo $pagination ?>
			</div>
		</div>


	</div>

	<script src="<?php echo base_url("assets") ?>/js/jquery-ui.js"></script>
	<script src="<?php echo base_url("assets") ?>/js/numeral.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/lead/index.js"></script>

	<script type="text/javascript">
		detail('<?=(isset($_GET['id'])) ? $_GET['id'] : '' ?>');


	</script>

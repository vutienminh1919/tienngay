<link href="<?php echo base_url(); ?>assets/js/switchery/switchery.min.css" rel="stylesheet">
<!-- page content -->
<div class="right_col" role="main">
	<div class="loading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span>Đang Xử Lý...</span>
	</div>
	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3>
					Nơi cất giữ xe
					<br>
					<small>
						<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
								href="">Quản lý nơi cất giữ xe</a>
					</small>
				</h3>
			</div>
		</div>
	</div>
	<div class="col-xs-12">
		<div class="title_right text-right">
			<button class="btn btn-info modal_storage" data-toggle="modal" data-target="#addNewStorageModal"><i
						class="fa fa-plus" aria-hidden="true"></i> Thêm mới
			</button>
		</div>
		<br>
		<div>
			<?php if ($this->session->flashdata('error')) { ?>
				<div class="alert alert-danger alert-result">
					<?= $this->session->flashdata('error') ?>
				</div>
			<?php } ?>
			<?php if ($this->session->flashdata('success')) { ?>
				<div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
			<?php } ?>
		</div>
	</div>

	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_content">
				<div class="row">
					<div class="col-xs-12">

						<div class="table-responsive">
							<table id="datatable-buttons" class="table table-striped">
								<thead>
								<tr>
									<th style="text-align: center" rowspan="2">#</th>
									<th style="text-align: center" rowspan="2">Tên nơi cất giữ xe</th>
									<th style="text-align: center" rowspan="2">Địa chỉ cất giữ</th>
									<th style="text-align: center" colspan="4">Tiêu chí kiểm tra</th>
									<th style="text-align: center" rowspan="2">Người tạo</th>
								</tr>
								<tr>
									<th style="text-align: center; background-color: white; color: black">Trông xe 24/24 không?</th>
									<th style="text-align: center; background-color: white; color: black" >Có vé xe không?</th>
									<th style="text-align: center; background-color: white; color: black">Giá vé ngày?</th>
									<th style="text-align: center; background-color: white; color: black">Có mái che không?</th>
								</tr>

								</thead>
								<tbody>
								<?php
								if (!empty($list_storage)) {
									$stt = 0;
									foreach ($list_storage as $key => $storage) {
										if ($storage->status != 'block') {
											$stt++;

											?>
											<tr>
												<td ><?php echo $stt ?></td>
												<td ><?= !empty($storage->storage_name) ? $storage->storage_name : "" ?></td>
												<td ><?= !empty($storage->storage_address) ? $storage->storage_address : "" ?></td>
												<?php !empty($storage->car_park) ? $storage->car_park : "" ?>
												<td style="text-align: center"><?= !empty($storage->car_park == 1) ? "V" : "X" ?></td>
												<?php !empty($storage->storage_ticket) ? $storage->storage_ticket : "" ?>
												<td style="text-align: center"><?= !empty($storage->storage_ticket == 1) ? "V" : "X" ?></td>
												<td style="text-align: center"><?= !empty($storage->storage_price) ? $storage->storage_price : "" ?></td>
												<?php !empty($storage->storage_covered) ? $storage->storage_covered : "" ?>
												<td style="text-align: center"><?= !empty($storage->storage_covered == 1) ? "V" : "X" ?></td>
												<td ><?= !empty($storage->user->email) ? $storage->user->email : "" ?></td>
											</tr>
										<?php }
									}
								} ?>
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
<!-- /page content -->

<div class="modal fade" id="addNewStorageModal" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close storage_close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center">Thêm mới địa điểm </h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" value="" name="_id"/>
						<div class="form-group">
							<label class="control-label col-md-3">Tên nơi cất giữ xe <span class="text-danger">*</span>:</label>
							<div class="col-md-9">
								<input name="storage_name" placeholder="Nhập tên nơi cất giữ xe" class="form-control"
									   type="text">
								<span class="help-block"></span>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3">Địa chỉ <span class="text-danger">*</span>:</label>
							<div class="col-md-9">
								<input name="storage_address" placeholder="Nhập địa chỉ" class="form-control"
									   type="text">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Tiêu chí kiểm tra <span
										class="text-danger">*</span>:</label>
							<div class="col-lg-9 ">
								<div class="row">
									<div class="col-md-6">
										<span>Trông xe 24/24 không?</span>
									</div>
									<div class="col-md-6">
										<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
											<label><input name='car_park' value="1" type="radio"
														  checked>&nbsp;Có</label>
											<label><input name='car_park' value="2"
														  type="radio">&nbsp;Không</label>
										</div>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-md-6">
										<span>Có vé xe không?</span>
									</div>
									<div class="col-md-6">
										<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
											<label><input name='storage_ticket' value="1" type="radio"
														  checked>&nbsp;Có</label>
											<label><input name='storage_ticket' value="2"
														  type="radio">&nbsp;Không</label>
										</div>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-md-6">
										<span>Giá gửi xe 1 ngày?</span>
									</div>
									<div class="col-md-6">
										<div class="col-lg-12 col-md-6 col-sm-6 col-xs-12 ">
											<input name="storage_price" placeholder="Nhập giá gửi xe"
												   class="form-control"
												   type="text">
											<span class="help-block"></span>
										</div>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-md-6">
										<span>Có mái che không?</span>
									</div>
									<div class="col-md-6">
										<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
											<label><input name='storage_covered' value="1" type="radio"
														  checked>&nbsp;Có</label>
											<label><input name='storage_covered' value="2"
														  type="radio">&nbsp;Không</label>
										</div>
									</div>
								</div>
								<br>

								<div style="text-align: center" id="group-button">
									<button type="button" id="storage_btnSave" class="btn btn-info">Lưu</button>
									<button type="button" class="btn btn-primary storage_close" data-dismiss="modal"
											aria-label="Close" >
										Thoát
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script src="<?php echo base_url(); ?>assets/js/car_storage/car_storage.js"></script>
<script src="<?php echo base_url(); ?>assets/js/switchery/switchery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/activeit.min.js"></script>

<style type="text/css">
	.w-25 {
		width: 8% !important;
	}
</style>
<style type="text/css">
	.pagination-sm > a {
		padding: 5px 10px;
		font-size: 12px;
		line-height: 1.5;
	}
</style>


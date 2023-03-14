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
					Cộng tác viên
					<br>
					<small>
						<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
							href="">Quản lý cộng tác viên</a>
					</small>
				</h3>
			</div>
		</div>
	</div>
	<div class="col-xs-12">

		<div class="title_right text-right">
			<button class="btn btn-info modal_ctv" data-toggle="modal" data-target="#addNewCTVModal"><i
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
									<th style="text-align: center" >#</th>
									<th style="text-align: center" >Mã cộng tác viên</th>
									<th style="text-align: center" >Họ và tên cộng tác viên</th>
									<th style="text-align: center" >Số điện thoại</th>
									<th style="text-align: center" >Nguồn</th>
									<th style="text-align: center" >Nghề nghiệp</th>
									<th style="text-align: center" >Tên ngân hàng</th>
									<th style="text-align: center" >Số tài khoản ngân hàng</th>
									<th style="text-align: center" >Người tạo</th>
									<th style="text-align: center" >Ngày tạo</th>
									<?php
									if (in_array('giao-dich-vien', $groupRoles)) {
									?>
									<th style="text-align: center" ></th>
									<?php } ?>
								</tr>
								</thead>
								<tbody>
								<?php if (empty($list_ctv)): ?>
								<tr><td>No data</td></tr>
								<?php else:?>
								<?php foreach ($list_ctv as $key => $value): ?>

								<tr>
									<td style="text-align: center"><?php echo ++$key ?></td>
									<td><?php echo $value->ctv_code ?></td>
									<td><?php echo $value->ctv_name ?></td>
									<td ><?php echo $value->ctv_phone ?></td>
									<td ><?= empty($value->ctv_job) ? "Website_ctv" : "Cpanel" ?></td>
									<td><?php echo $value->ctv_job ?></td>
									<td><?php echo $value->ctv_bank_name ?></td>
									<td><?php echo $value->ctv_bank ?></td>
									<td><?php echo $value->created_by ?></td>
									<td><?php echo date('d/m/Y',$value->created_at) ?></td>
									<?php
									if (in_array('giao-dich-vien', $groupRoles)) {
									?>
									<td><a href="javascript:void(0)" data-toggle="modal"
										   type="button" class="btn" style="background-color: #2a3f54; color: white"
										   onclick="sua_thong_tin('<?= $value->_id->{'$oid'} ?>')">
											Sửa
										</a>
									</td>
									<?php } ?>
								</tr>
								<?php endforeach; ?>
								<?php endif; ?>
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
<!-- /page content -->

<div class="modal fade" id="addNewCTVModal" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close ctv_close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center">Thêm mới cộng tác viên </h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" value="" name="_id"/>
<!--						<div class="form-group">-->
<!--							<label class="control-label col-md-3">Mã cộng tác viên <span class="text-danger">*</span>:</label>-->
<!--							<div class="col-md-9">-->
<!--								<input id="ctv_code1" name="ctv_code" placeholder="Nhập mã cộng tác viên" class="form-control"-->
<!--									   type="text">-->
<!--								<span class="help-block"></span>-->
<!--							</div>-->
<!--						</div>-->

						<div class="form-group">
							<label class="control-label col-md-3">Họ tên cộng tác viên <span class="text-danger">*</span>:</label>
							<div class="col-md-9">
								<input name="ctv_name" placeholder="Nhập họ tên cộng tác viên" class="form-control"
									   type="text">
								<span class="help-block"></span>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3">Số điện thoại <span class="text-danger">*</span>:</label>
							<div class="col-md-9">
								<input id="ctv_phone" name="ctv_phone" placeholder="Nhập số điện thoại" class="form-control"
									   type="text">
								<span class="help-block"></span>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3">Nghề nghiệp <span class="text-danger">*</span>:</label>
							<div class="col-md-9">
								<input name="ctv_job" placeholder="Nhập nghề nghiệp" class="form-control"
									   type="text">
								<span class="help-block"></span>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3">Tên ngân hàng <span class="text-danger">*</span>:</label>
							<div class="col-md-9">
								<input name="ctv_bank_name" placeholder="Nhập tên ngân hàng" class="form-control"
									   type="text">
								<span class="help-block"></span>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3">Số tài khoản ngân hàng <span class="text-danger">*</span>:</label>
							<div class="col-md-9">
								<input id="ctv_bank" name="ctv_bank" placeholder="Nhập số tài khoản ngân hàng" class="form-control"
									   type="text">
								<span class="help-block"></span>
							</div>
						</div>

						<br>

						<div style="text-align: center" id="group-button">
							<button type="button" id="ctv_btnSave" class="btn btn-info">Lưu</button>
							<button type="button" class="btn btn-primary ctv_close" data-dismiss="modal"
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

<div id="edit_ctv" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close ctv_close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center">Sửa thông tin cộng tác viên </h3>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none"
				 id="div_errorCreate_1">
				<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
				<span class='div_errorCreate'></span>
			</div>
			<div class="modal-body " id="">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" value="" id="_id"/>
						<div class="form-group">
							<label class="control-label col-md-3">Mã cộng tác viên <span class="text-danger">*</span>:</label>
							<div class="col-md-9">
								<input id="ctv_code_update"  placeholder="Nhập mã cộng tác viên" class="form-control"
									   type="text">
								<span class="help-block"></span>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3">Họ tên cộng tác viên <span class="text-danger">*</span>:</label>
							<div class="col-md-9">
								<input id="ctv_name_update" placeholder="Nhập họ tên cộng tác viên" class="form-control"
									   type="text">
								<span class="help-block"></span>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3">Số điện thoại <span class="text-danger">*</span>:</label>
							<div class="col-md-9">
								<input id="ctv_phone_update"  placeholder="Nhập số điện thoại" class="form-control"
									   type="text">
								<span class="help-block"></span>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3">Nghề nghiệp <span class="text-danger">*</span>:</label>
							<div class="col-md-9">
								<input id="ctv_job_update" placeholder="Nhập nghề nghiệp" class="form-control"
									   type="text">
								<span class="help-block"></span>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3">Tên ngân hàng <span class="text-danger">*</span>:</label>
							<div class="col-md-9">
								<input id="ctv_bank_name_update" placeholder="Nhập tên ngân hàng" class="form-control"
									   type="text">
								<span class="help-block"></span>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3">Số tài khoản ngân hàng <span class="text-danger">*</span>:</label>
							<div class="col-md-9">
								<input id="ctv_bank_update" placeholder="Nhập số tài khoản ngân hàng" class="form-control"
									   type="text">
								<span class="help-block"></span>
							</div>
						</div>

						<br>

						<div style="text-align: center" id="group-button">
							<button type="button" id="ctv_btn_update" class="btn btn-info">Lưu</button>
							<button type="button" class="btn btn-primary" data-dismiss="modal"
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


<script src="<?php echo base_url(); ?>assets/js/collaborator/collaborator.js"></script>
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


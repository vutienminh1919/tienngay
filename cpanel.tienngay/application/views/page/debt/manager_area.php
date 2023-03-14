<?php
$getId = !empty($_GET['employ']) ? $_GET['employ'] : "";
?>
<div class="right_col" role="main">
	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3>Quản lý khu vực nhân viên THN
					<br>
					<small>
						<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
								href="<?php echo base_url('debt_manager_app/area_manager') ?>">Quản lý khu
							vực nhân viên THN</a>
					</small>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<!--Xuất excel-->
						<div class="row">
							<div class="col-xs-12">
								<?php if ($this->session->flashdata('error')) { ?>
									<div class="alert alert-danger alert-result">
										<?= $this->session->flashdata('error') ?>
									</div>
								<?php } ?>
								<?php if ($this->session->flashdata('success')) { ?>
									<div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
								<?php } ?>
								<div class="row">
									<form action="<?php echo base_url('debt_manager_app/get_area_user') ?>"
										  method="get"
										  style="width: 100%;">
										<div class="col-lg-3">
											<div class="">
												<select type="email" name="employ" class="form-control" id="idUserDebt"
														onchange="this.form.submit()">
													<option value="">Chọn nhân viên</option>
													<?php foreach ($debtEmploy as $value) { ?>
														<option <?php echo $getId === $value->id ? 'selected' : '' ?>
																value="<?php echo $value->id; ?>"><?php echo $value->email; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="col-lg-2 text-right">
											<button style="background-color: #18d102;" type="button"
													class="btn btn-primary w-100"><i
														aria-hidden="true"></i>&nbsp; Chọn nhân viên
											</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="table-responsive">
			<div class="title_right text-right">
				<button class="btn btn-info modal_area" data-toggle="modal" data-target="#addNewAreaEmploy"><i
							class="fa fa-plus" aria-hidden="true"></i> Thêm mới
				</button>
			</div>
			<table class="table table-striped table-hover">
				<thead>
				<tr>
					<th>#</th>
					<th>Tỉnh</th>
					<th>Quận/Huyện</th>
					<th>Thao tác</th>
				</tr>
				</thead>
				<tbody>
				<?php if (!empty($area)) : ?>
					<?php foreach ($area as $key => $value) : ?>
						<tr id="area-user-<?php echo $value->_id->{'$oid'} ?>">
							<td><?php echo ++$key ?></td>
							<td><?php echo !empty($value->province) ? get_province_name_by_code($value->province) : '' ?></td>
							<td><?php echo !empty($value->district) ? get_district_name_by_code($value->district) : '' ?></td>
							<td>
								<button class="btn btn-danger areaBlock"
										data-id="<?php echo $value->_id->{'$oid'} ?>">
									Block
								</button>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
			</table>
			<div class="">
				<?php echo $pagination ?>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="addNewAreaEmploy" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close company_close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center">Thêm khu vực </h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" value="" name=""/>
						<div class="form-group pb-5">
							<label class="control-label col-md-3">Chọn Thành Phố:
								<span class="text-danger"></span></label>
							<div class="col-md-9">
								<select class="form-control" name="province_debt" id="province_debt">
									<option class="text-center" value="">--Chọn Tỉnh--</option>
									<?php foreach ($provinces as $province): ?>
										<option class="text-center"
												value="<?php echo $province->code ?>"><?php echo $province->name_with_type ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<br>
						<br>
						<div class="form-group mt-5">
							<label class="control-label col-md-3">Chọn Quận/Huyện:
								<span class="text-danger"></span></label>
							<div class="col-md-9">
								<select class="form-control" name="district_debt" id="district_debt">
									<option class="text-center" value="">--Chọn Quận/Huyện--</option>
								</select>
							</div>
						</div>
						<br>
						<br>
						<div style="text-align: center" id="group-button">
							<!--							<button type="button" id="company_btnSave" class="btn btn-info">Lưu</button>-->
							<input type="button" id="area_btnSave" class="btn btn-info" value="Lưu">
							<button type="button" class="btn btn-primary company_close" data-dismiss="modal"
									aria-label="Close">
								Thoát
							</button>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>assets/js/debt/area.js"></script>



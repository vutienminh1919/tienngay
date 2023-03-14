<?php
$per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
$type_property = !empty($_GET['type_property']) ? $_GET['type_property'] : '';
$vehicles = !empty($_GET['vehicles']) ? $_GET['vehicles'] : '';

?>
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3>Quản lý danh sách khấu hao Xe Máy
					<br>
					<small>
						<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>/ <a
								href="<?php echo base_url('property_valuation/view_list_moto') ?>">Danh sách tài sản
							XM </a>/ <a
								href="<?php echo base_url('property_valuation/data_depreciations_moto') ?>">Danh sách
							khấu hao XM </a>
					</small>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">

						<?php if ($this->session->flashdata('error')) { ?>
							<div class="alert alert-danger alert-result">
								<?= $this->session->flashdata('error') ?>
							</div>
						<?php } ?>
						<?php if ($this->session->flashdata('success')) { ?>
							<div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
						<?php } ?>
						<div class="row">
							<div class="col-lg-9">
								<form class="row"
									  action="<?php echo base_url('property_valuation/data_depreciations_moto') ?>"
									  method="get"
									  style="width: 100%;">
									<div class="col-lg-3">
										<label>Chọn Hãng xe</label>
										<div class="">
											<select type="email" name="vehicles" class="form-control">
												<option value="">Chọn Hãng xe</option>
												<?php foreach ($main_property as $value) { ?>
													<option <?php echo $vehicles == $value ? 'selected' : '' ?>
															value="<?php echo $value; ?>"><?php echo $value; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-lg-3">
										<label>Chọn Dòng xe</label>
										<div class="">
											<select type="email" name="type_property" class="form-control">
												<option value="">Chọn Dòng xe</option>
												<?php foreach (type_property() as $key => $value) { ?>
													<option <?php echo $type_property == $key ? 'selected' : '' ?>
															value="<?php echo $key; ?>"><?php echo $value; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-lg-3 text-right">
										<label></label>
										<button type="submit"
												class="btn btn-primary w-100"><i
													aria-hidden="true"></i>&nbsp; Tìm kiếm
										</button>
									</div>
								</form>

							</div>
							<div class="col-lg-3 ">
								<div class="row">
									<div class="form-group col-lg-9">
										<label>Import khấu hao</label>
										<input type="file" name="upload_file_depreciation" class="form-control"
											   placeholder="sothing">
									</div>
									<div class="form-group col-lg-3">
										<label></label>
										<a class="btn btn-primary" id="import_depreciation" style="display: block"><i
													class="fa fa-upload"></i></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div>
			<div class="x_content">
				<div class="row">
					<div class="col-xs-12">
						<div class="table-responsive">
							<div>Hiển thị
								<span class="text-danger"><?php echo $total_rows > 0 ? $total_rows : 0; ?> </span>
								Kết quả
							</div>
							<table id="" class="table table-striped">
								<thead>
								<tr>
									<th style="text-align: center">#</th>
									<th style="text-align: center">Hãng xe</th>
									<th style="text-align: center">Dòng xe</th>
									<th style="text-align: center">Năm khấu hao</th>
									<th style="text-align: center">Khấu hao</th>
									<th style="text-align: center">Thao tác</th>
								</tr>
								</thead>
								<tbody>
								<?php if (!empty($depreciations)) : ?>
									<?php foreach ($depreciations as $key => $value): ?>
										<tr style="text-align: center">
											<td><?php echo ++$key ?></td>
											<td><?php echo !empty($value->main_property) ? $value->main_property : '++' ?></td>
											<td><?php echo !empty($value->type_property) ? type_property($value->type_property) : '++' ?> </td>
											<td><?php echo !empty($value->year) ? $value->year . ' năm' : '++' ?></td>
											<td><?php echo !empty($value->depreciation) ? $value->depreciation . '%' : 0 ?></td>
											<td>
												<button class="btn btn-primary depreciationUpdate"
														data-id="<?php echo $value->_id->{'$oid'} ?>"
														data-toggle="modal"
														data-target="#updateDepreciationModal">
													Sửa
												</button>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php else : ?>
									<tr>
										<td colspan="20" class="text-center">Không có dữ liệu</td>
									</tr>
								<?php endif; ?>
								</tbody>
							</table>
						</div>

					</div>
				</div>
			</div>
			<div class="">
				<?php echo $pagination; ?>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="updateDepreciationModal" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close company_close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title title_radio_update text-primary" style="text-align: center">Cập nhật </h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" value="" name="id_depreciation_update"/>
						<div class="row">
							<div class="col-xs-12">
								<div class="form-group">
									<label class="control-label col-md-6" style="text-align: center">Hãng xe:
										<span class="text-danger"></span></label>
									<div class="col-md-6">
										<input class="form-control hang_xe" disabled>
									</div>
								</div>
							</div>
							<br>
							<br>
							<div class="col-xs-12">
								<div class="form-group ">
									<label class="control-label col-md-6" style="text-align: center">Dòng xe:
										<span class="text-danger"></span></label>
									<div class="col-md-6">
										<input class="form-control dong_xe" disabled>

									</div>
								</div>
							</div>
							<br>
							<br>
							<div class="col-xs-12">
								<div class="form-group ">
									<label class="control-label col-md-6" style="text-align: center">Năm khấu hao:
										<span class="text-danger"></span></label>
									<div class="col-md-6">
										<input class="form-control nam_khau_hao" disabled>
									</div>
								</div>
							</div>
							<br>
							<br>
							<div class="col-xs-12">
								<div class="form-group ">
									<label class="control-label col-md-6" style="text-align: center">Khấu hao:
										<span class="text-danger"></span></label>
									<div class="col-md-6">
										<input class="form-control" name="khau_hao" id="khau_hao"
											   placeholder="nhập khấu hao" type="number">
									</div>
								</div>
							</div>
							<br>
							<br>
							<div class="col-xs-12">
								<div style="text-align: center" id="group-button">
									<input type="button" id="update_depreciation_btnSave" class="btn btn-info"
										   value="Lưu">
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
	</div>
</div>
<script src="<?php echo base_url(); ?>assets/js/property/khau_hao_moto.js"></script>





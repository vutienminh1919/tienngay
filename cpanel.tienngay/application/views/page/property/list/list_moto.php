<?php
$vehicles = !empty($_GET['vehicles']) ? $_GET['vehicles'] : "";
$name_property = !empty($_GET['name_property']) ? $_GET['name_property'] : "";
?>
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3>Quản lý danh sách tài sản Xe Máy
					<br>
					<small>
						<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
								href="<?php echo base_url('property_valuation/view_list_moto') ?>">Danh sách tài sản
							XM </a>
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
								<form class="row" action="<?php echo base_url('property_valuation/view_list_moto') ?>"
									  method="get"
									  style="width: 100%;">
									<div class="col-lg-3">
										<label>Chọn Hãng xe</label>
										<div class="">
											<select type="email" name="vehicles" class="form-control">
												<option value="">Chọn Hãng xe</option>
												<?php foreach ($main_property as $value) { ?>
													<option <?php echo $vehicles === $value->_id->{'$oid'} ? 'selected' : '' ?>
															value="<?php echo $value->_id->{'$oid'}; ?>"><?php echo $value->str_name; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-lg-3">
										<label>Tên xe</label>
										<input type="text" name="name_property" class="form-control"
											   placeholder="Nhập tên xe" value="<?php echo $name_property; ?>">
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
										<label>Import tài sản</label>
										<input type="file" name="upload_file_property" class="form-control"
											   placeholder="sothing">
									</div>
									<div class="form-group col-lg-3">
										<label></label>
										<a class="btn btn-primary" id="import_property" style="display: block"><i
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
							<div class="title_right text-right">
								<a class="btn btn-success"
								   href="<?php echo base_url('property_valuation/data_depreciations_moto') ?>">
									<i class="fa fa-bitcoin" aria-hidden="true"></i>

								</a>
								<a style="background-color: #18d102;"
								   href="<?= base_url() ?>property_valuation/excel_list_moto?vehicles=<?= $vehicles . '&name_property=' . $name_property ?>"
								   class="btn btn-primary" target="_blank"><i
											class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
								</a>
							</div>
							<div>Hiển thị
								<span class="text-danger"><?php echo $total_rows > 0 ? $total_rows : 0; ?> </span>
								Kết quả
							</div>
							<table id="" class="table table-striped">
								<thead>
								<tr>
									<th style="text-align: center">#</th>
									<th style="text-align: center">Tài sản</th>
									<th style="text-align: center">Hãng xe</th>
									<th style="text-align: center">Dòng xe</th>
									<th style="text-align: center">Tên đầy đủ</th>
									<th style="text-align: center">Năm sản xuất</th>
									<th style="text-align: center">Giá xe</th>
									<th style="text-align: center">Thao tác</th>
								</tr>
								</thead>
								<tbody>
								<?php if (!empty($property)) : ?>
									<?php foreach ($property as $key => $value): ?>
										<tr id="propertyXemay-<?php echo $value->_id->{'$oid'} ?>" style="text-align: center">
											<td><?php echo ++$key ?></td>
											<td><i class='fa fa-motorcycle'></i></td>
											<td><?php echo !empty($value->main_data) ? $value->main_data : '++' ?></td>
											<td><?php echo !empty($value->type_property) ? type_property($value->type_property) : '++' ?> </td>
											<td><?php echo !empty($value->str_name) ? $value->str_name : '++' ?></td>
											<td><?php echo !empty($value->year_property) ? $value->year_property : '++' ?></td>
											<td><?php echo !empty($value->price) ? number_format($value->price) . ' VND' : 0 ?></td>
											<td>
												<button class="btn btn-info detailMotoModal"
														data-toggle="modal"
														data-target="#detailMotoModal"
														data-id="<?php echo $value->_id->{'$oid'} ?>">
													<i class='fa fa-info-circle'></i>
												</button>
												<button class="btn btn-danger blockProperty_xm"
														data-id="<?php echo $value->_id->{'$oid'} ?>">
													<i class='fa fa-trash'></i>
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
<div class="modal fade" id="detailMotoModal" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close company_close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<div>
					<h3 class="text-primary ten_xe_may" style="text-align: center">
					</h3>
				</div>

			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12 col-md-6">
						<div class="form-group">
							<label class="control-label col-md-6">Hãng xe:</label>
							<div class="col-md-6 pos hang_xe">

							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6">
						<div class="form-group">
							<label class="control-label col-md-6">Dòng xe:</label>
							<div class="col-md-6 dong_xe">
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6">
						<div class="form-group">
							<label class="control-label col-md-6">Năm sản xuất:</label>
							<div class="col-md-6 nam_san_xuat">
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6">
						<div class="form-group">
							<label class="control-label col-md-6">Giá :</label>
							<div class="col-md-6 gia_xe">
							</div>
						</div>
					</div>
					<div class="col-xs-12">
						<hr>
					</div>
					<div class="col-xs-12">
						<table class="table">
							<thead>
							<tr>
								<th style="text-align: center">#</th>
								<th style="text-align: center">Số năm</th>
								<th style="text-align: center">Khấu hao</th>
							</tr>
							</thead>
							<tbody id="depreciations" style="text-align: center">

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>assets/js/property/moto.js"></script>



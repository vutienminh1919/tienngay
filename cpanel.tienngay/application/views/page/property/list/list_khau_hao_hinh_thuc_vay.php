<?php
?>
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3>Quản lý hình thức vay
					<br>
					<small>
						<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
								href="<?php echo base_url('property_valuation/get_configuration_formality') ?>">Quản lý
							hình thức vay </a>
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
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
		<div>
			<div class="x_content">
				<div class="row">
					<div class="col-xs-12">
						<div class="table-responsive">
							<!--							<div>Hiển thị-->
							<!--								<span class="text-danger">-->
							<?php //echo $total_rows > 0 ? $total_rows : 0; ?><!-- </span>-->
							<!--								Kết quả-->
							<!--							</div>-->
							<table id="" class="table table-striped table-bordered table-fixed table-hover">
								<thead>
								<tr style="text-align: center">
									<th style="text-align: center">Sản phẩm</th>
									<th style="text-align: center">Xe máy</th>
									<th style="text-align: center">Ô tô</th>
									<th style="text-align: center">Thao tác</th>
								</tr>
								</thead>
								<tbody>
								<?php if (!empty($formality)) : ?>
									<tr style="text-align: center">
										<td>Cầm cố tài sản</td>
										<td><?php echo !empty($formality->cc->percent->XM) ? $formality->cc->percent->XM . "%" : '' ?></td>
										<td><?php echo !empty($formality->cc->percent->OTO) ? $formality->cc->percent->OTO . "%" : '++' ?></td>
										<td>
											<button class="btn btn-success update_hinh_thuc_cam_co"
													data-id="<?php echo $formality->cc->_id->{'$oid'} ?>"
													data-toggle="modal"
													data-target="#update_hinh_thuc_cam_co_modal">
												<i class='fa fa-edit'></i>
											</button>
										</td>
									</tr>
									<tr style="text-align: center">
										<td>Cho vay tài sản</td>
										<td><?php echo !empty($formality->dkx->percent->XM) ? $formality->dkx->percent->XM . "%" : '' ?></td>
										<td><?php echo !empty($formality->dkx->percent->OTO) ? $formality->dkx->percent->OTO . "%" : '++' ?></td>
										<td>
											<button class="btn btn-success update_hinh_thuc_cho_vay"
													data-id="<?php echo $formality->dkx->_id->{'$oid'} ?>"
													data-toggle="modal"
													data-target="#update_hinh_thuc_cho_vay_modal">
												<i class='fa fa-edit'></i>
											</button>
										</td>
									</tr>
									<tr style="text-align: center">
										<td>Tín chấp</td>
										<td colspan="2"><?php echo !empty($formality->tc->percent->TC) ? $formality->tc->percent->TC . "%" : '' ?></td>
										<td>
											<button class="btn btn-success update_hinh_thuc_tin_chap"
													data-id="<?php echo $formality->tc->_id->{'$oid'} ?>"
													data-toggle="modal"
													data-target="#update_hinh_thuc_tin_chap_modal">
												<i class='fa fa-edit'></i>
											</button>
										</td>
									</tr>
									<tr style="text-align: center">
										<td>Kinh doanh online</td>
										<td colspan="2">90%</td>
										<td></td>
									</tr>
									<tr style="text-align: center">
										<td>Quyền sử dụng đất</td>
										<td colspan="2">100%</td>
										<td></td>
									</tr>
									<tr style="text-align: center">
										<td>Quyền khác</td>
										<td colspan="2">100%</td>
										<td></td>
									</tr>
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
<div class="modal fade" id="update_hinh_thuc_cam_co_modal" tabindex="-1" role="dialog"
	 aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close company_close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title title_radio_update text-primary" style="text-align: center">Cập nhật cầm cố tài
					sản</h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" value="" name="id_hinh_thuc_cc_update"/>
						<div class="row">
							<div class="col-xs-12">
								<div class="form-group">
									<label class="control-label col-md-6" style="text-align: center">Xe máy:
										<span class="text-danger"></span></label>
									<div class="col-md-6">
										<input class="form-control cc_xe_may" name="cc_xe_may" type="number">
									</div>
								</div>
							</div>
							<br>
							<br>
							<div class="col-xs-12">
								<div class="form-group ">
									<label class="control-label col-md-6" style="text-align: center">Ô tô:
										<span class="text-danger"></span></label>
									<div class="col-md-6">
										<input class="form-control cc_o_to" name="cc_o_to" type="number">

									</div>
								</div>
							</div>
							<br>
							<br>
							<div class="col-xs-12">
								<div style="text-align: center" id="group-button">
									<input type="button" id="update_cam_co_btnSave" class="btn btn-info"
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
<div class="modal fade" id="update_hinh_thuc_cho_vay_modal" tabindex="-1" role="dialog"
	 aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close company_close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title title_radio_update text-primary" style="text-align: center">Cập nhật cho vay tài
					sản </h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" value="" name="id_hinh_thuc_dkx_update"/>
						<div class="row">
							<div class="col-xs-12">
								<div class="form-group">
									<label class="control-label col-md-6" style="text-align: center">Xe máy:
										<span class="text-danger"></span></label>
									<div class="col-md-6">
										<input class="form-control dkx_xe_may" name="dkx_xe_may" type="number">
									</div>
								</div>
							</div>
							<br>
							<br>
							<div class="col-xs-12">
								<div class="form-group ">
									<label class="control-label col-md-6" style="text-align: center">Ô tô:
										<span class="text-danger"></span></label>
									<div class="col-md-6">
										<input class="form-control dkx_o_to" name="dkx_o_to" type="number">

									</div>
								</div>
							</div>
							<br>
							<br>
							<div class="col-xs-12">
								<div style="text-align: center" id="group-button">
									<input type="button" id="update_cho_vay_btnSave" class="btn btn-info"
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
<div class="modal fade" id="update_hinh_thuc_tin_chap_modal" tabindex="-1" role="dialog"
	 aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close company_close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title title_radio_update text-primary" style="text-align: center">Cập nhật Tín
					chấp </h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" value="" name="id_hinh_thuc_tc_update"/>
						<div class="row">
							<div class="col-xs-12">
								<div class="form-group ">
									<label class="control-label col-md-6" style="text-align: center">Tín chấp:
										<span class="text-danger"></span></label>
									<div class="col-md-6">
										<input class="form-control" name="tin_chap" id="tin_chap"
											   placeholder="nhập khấu hao" type="number">
									</div>
								</div>
							</div>
							<br>
							<br>
							<div class="col-xs-12">
								<div style="text-align: center" id="group-button">
									<input type="button" id="update_tin_chap_btnSave" class="btn btn-info"
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
<script src="<?php echo base_url(); ?>assets/js/property/hinh_thuc_vay.js"></script>




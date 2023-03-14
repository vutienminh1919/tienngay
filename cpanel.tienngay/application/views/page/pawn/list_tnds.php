<link href="<?php echo base_url(); ?>assets/js/switchery/switchery.min.css" rel="stylesheet">

<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span>Đang Xử lý...</span>
	</div>
	<div class="row top_tiles">
		<?php
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
		$type_tnds = !empty($_GET['type_tnds']) ? $_GET['type_tnds'] : '';
		$full_name = !empty($_GET['full_name']) ? $_GET['full_name'] : "";
		$phone = !empty($_GET['phone']) ? $_GET['phone'] : "";
		$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";

		?>
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>Danh sách HĐ bảo hiểm TNDS
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
								href="<?php echo base_url('pawn/list_tnds') ?>">Danh
								sách HĐ bảo hiểm TNDS</a>
						</small>
					</h3>
				</div>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">

					<div class="row">
								<form action="<?php echo base_url('pawn/list_tnds') ?>" method="get"
									  style="width: 100%;">
									  <div class="col-xs-12 ">
									<div class="col-lg-3">
										<label></label>
										<div class="input-group">
											<span
												class="input-group-addon"><?php echo $this->lang->line('from') ?></span>
											<input type="date" name="fdate" class="form-control"
												   value="<?= !empty($fdate) ? $fdate : "" ?>">
										</div>
									</div>
									<div class="col-lg-3">
										<label></label>
										<div class="input-group">
											<span class="input-group-addon"><?php echo $this->lang->line('to') ?></span>
											<input type="date" name="tdate" class="form-control"
												   value="<?= !empty($tdate) ? $tdate : "" ?>">
										</div>
									</div>
                                    <div class="col-lg-2">
												<label>Hãng bảo hiểm</label>
												<select class="form-control" name="type_tnds">
													<option    <?php echo $type_tnds == '' ? 'selected' : ''?> value="">Chọn hãng bảo hiểm</option>
													<option <?php echo $type_tnds == 'MIC_TNDS' ? 'selected' : ''?>  value="MIC_TNDS">MIC</option>
													<option <?php echo $type_tnds == 'VBI_TNDS' ? 'selected' : ''?>  value="VBI_TNDS">VBI</option>
												</select>
											</div>
									 <div class="col-lg-2">
												<label>Tên Khách hàng</label>
												<input type="text" name="full_name" class="form-control"
												   value="<?= !empty($full_name) ? $full_name : "" ?>">
											</div>
										</div>
									<div class="col-xs-12 ">
									 <div class="col-lg-2">
												<label>Mã hợp đồng </label>
												<input type="text" name="code_contract_disbursement" class="form-control"
												   value="<?= !empty($code_contract_disbursement) ? $code_contract_disbursement : "" ?>">
											</div>
									 <div class="col-lg-2">
												<label>Số điện thoại</label>
												<input type="text" name="phone" class="form-control"
												   value="<?= !empty($phone) ? $phone : "" ?>">
											</div>
									<div class="col-lg-2 text-right">
										<label></label>
										<button type="submit" class="btn btn-primary w-100"><i class="fa fa-search"
																							   aria-hidden="true"></i>
											Tìm kiếm
										</button>
									</div>
									<div class="col-lg-2 text-right">
										<label></label>
										<a style="background-color: #18d102;"
										   href="<?= base_url() ?>excel/exportListTnds?fdate=<?= $fdate . '&tdate=' . $tdate . '&type_tnds='.$type_tnds ?>"
										   class="btn btn-primary w-100" target="_blank"><i class="fa fa-file-excel-o"
																							aria-hidden="true"></i>&nbsp;
											Xuất excel</a>
									</div>
								</div>
									

								</form>
						

						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="row">
						<div class="col-xs-12">
							<div class="alert alert-danger alert-dismissible text-center" style="display:none"
								 id="div_error">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<span class='div_error'></span>
							</div>
							<div class="table-responsive">
								<div>Hiển thị (<span
										class="text-danger"><?php echo $result_count ? $result_count : 0 ?></span>)
									kết quả
								</div>
								<table id="datatable-button" class="table table-striped table-bordered table-hover">
									<thead>
									<tr>
										<th style="text-align: center">#</th>
										<th style="text-align: center">Mã Hợp đồng</th>
										<th style="text-align: center">Người được BH</th>
										<th style="text-align: center">Loại BH</th>
										<th style="text-align: center">Số tiền BH</th>
										<th style="text-align: center">Ngày hiệu lực</th>
										<th style="text-align: center">Ngày kết thúc</th>
										<th style="text-align: center">Ngày tạo</th>
										<th style="text-align: center">Người tạo</th>
										<th style="text-align: center">Trạng thái</th>
										<th style="text-align: center">Link GCN</th>
										<?php if ($userSession['is_superadmin'] == 1 || in_array('van-hanh', $groupRoles) || in_array('ke-toan', $groupRoles)) : ?>
										<th style="text-align: center">Chặn bảo hiểm</th>
										<?php endif ; ?>
									</tr>
									</thead>

									<tbody>
									<?php
									if (!empty($bao_hiem)) {
										foreach ($bao_hiem as $key => $bh) {
											$contract_info = $bh->contract_info;
											?>
											<tr style="text-align: center">
												<td><?php echo ++$key ?></td>
												<td>
													<a class="link" target="_blank" data-toggle="tooltip"
													   title="Click để xem chi tiết"
													   href="<?php echo base_url("pawn/detail?id=") . $contract_info->_id->{'$oid'} ?>"
													   style="color: #0ba1b5;text-decoration: underline;">
														<?= !empty($contract_info->code_contract_disbursement) ? $contract_info->code_contract_disbursement : "" ?>
													</a>
												<td>
													<?= !empty($contract_info->customer_infor->customer_name) ? $contract_info->customer_infor->customer_name : "" ?>
													<br>
													<?= !empty($contract_info->customer_infor->customer_BOD) ? $contract_info->customer_infor->customer_BOD : "" ?>
													<br>
													<?= !empty($contract_info->customer_infor->customer_email) ? $contract_info->customer_infor->customer_email : "" ?>
													<br>
													<?= !empty($contract_info->customer_infor->customer_phone_number) ? $contract_info->customer_infor->customer_phone_number : "" ?>
												</td>
												<td><?php echo !empty($contract_info->loan_infor->bao_hiem_tnds->type_tnds) ? $contract_info->loan_infor->bao_hiem_tnds->type_tnds : "" ?></td>
												<td><?php echo !empty($contract_info->loan_infor->bao_hiem_tnds->price_tnds) ? number_format($contract_info->loan_infor->bao_hiem_tnds->price_tnds) : 0 ?></td>
												<td><?php echo !empty($bh->data->NGAY_HL) ? $bh->data->NGAY_HL : "" ?></td>
												<td><?php echo !empty($bh->data->NGAY_KT) ? $bh->data->NGAY_KT : "" ?></td>
												<td><?php echo !empty($bh->created_at) ? date('d/m/Y', $bh->created_at) : "" ?></td>
												<td><?php echo !empty($bh->contract_info->created_by) ? $bh->contract_info->created_by : "" ?></td>
												<?php if ($contract_info->loan_infor->bao_hiem_tnds->type_tnds == "MIC_TNDS"): ?>
													<?php if ($bh->data->response->STATUS == "TRUE"): ?>
														<td><span class="label label-success">Thành công</span></td>
														<td><a class="btn btn-info btn-sm" target="_blank" href="<?php echo $bh->data->response->FILE?>">Link GCN</a></td>
													<?php else: ?>
														<td>
															<span class="label label-warning">Thất bại</span>
															<button class="btn btn-primary btn-sm"
																	id="gui_lai_tnds"
																	data-id="<?php echo $bh->contract_id ?>">Gửi lại
															</button>
													<?php if(empty($contract_info->chan_bao_hiem)){	?>	
															<button class="btn btn-primary btn-sm"
																	id="gui_lai_tnds"
																	data-id="<?php echo $bh->contract_id ?>">Gửi lại
															</button>
														<?php } ?>
														</td>
														<td><span class="label label-success"></span></td>
													<?php endif; ?>
												<?php else: ?>
													<?php if ($bh->data->response->response_code == "00"): ?>
														<td><span class="label label-success">Thành công</span></td>
														<td><span class="label label-success"></span></td>
													<?php else: ?>
														<td>

															<span class="label label-warning">Thất bại</span>
															<?php if(empty($contract_info->chan_bao_hiem) && $userSession['is_superadmin'] == 1){	?>	
															<button class="btn btn-primary btn-sm" id="gui_lai_tnds" data-id="<?php echo $bh->contract_id ?>">Gửi lại</button>
															<?php } ?>
														</td>

														<td><span class="label label-success"></span></td>
													<?php if ($userSession['is_superadmin'] == 1 || in_array('van-hanh', $groupRoles) || in_array('ke-toan', $groupRoles)) : ?>
														<td><?= !empty($contract_info->chan_bao_hiem) ? prevent_insurance($contract_info->chan_bao_hiem) : ""?></td>
													<?php endif; ?>
													<?php endif; ?>
												<?php endif; ?>
											</tr>
										<?php }
									} ?>

									</tbody>
								</table>
								<div class="">
									<?php echo $pagination ?>
								</div>

							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

</div>

<script src="<?php echo base_url(); ?>assets/js/switchery/switchery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/activeit.min.js"></script>

<script>
	$(document).ready(function () {
		$("#gui_lai_tnds").click(function (event) {
			event.preventDefault();
			var id = $(this).attr('data-id')
			if (confirm('Bạn có chắc chắn gửi lại không ?')) {
				var formData = new FormData();
				formData.append('id', id);
				$.ajax({
					url: _url.base_url + 'pawn/gui_lai_tnds',
					type: "POST",
					data: formData,
					dataType: 'json',
					processData: false,
					contentType: false,
					beforeSend: function () {
						$(".theloading").show();
					},
					success: function (data) {
						$(".theloading").hide();
						console.log(data)
						if (data.code == 200) {
							$("#successModal").modal("show");
							$(".msg_success").text(data.msg);
							setTimeout(function () {
								window.location.href = _url.base_url + "pawn/list_tnds";
							}, 5000);
						} else if (data.code == 401) {
							$("#errorModal").modal("show");
							$(".msg_error").text(data.msg);
							setTimeout(function () {
								window.location.href = _url.base_url + "pawn/list_tnds";
							}, 5000);
						}
					},
					error: function () {
						$(".theloading").hide();
						$("#errorModal").modal("show");
						$(".msg_error").text('Có lỗi xảy ra, liên hệ IT để được hỗ trợ!');
						setTimeout(function () {
							window.location.href = _url.base_url + "pawn/list_tnds";
						}, 5000);
					}
				});
			}

		})
	})
</script>



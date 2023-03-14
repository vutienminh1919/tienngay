<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span>Đang Xử Lý...</span>
	</div>
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$fdebt = isset($_GET['fdebt']) ? $_GET['fdebt'] : "";
	$tdebt = isset($_GET['tdebt']) ? $_GET['tdebt'] : "";
	$store_id = !empty($_GET['store']) ? $_GET['store'] : "";
	$status = !empty($_GET['status']) ? $_GET['status'] : "";
	$type_loan = !empty($_GET['type_loan']) ? $_GET['type_loan'] : "";
	$type_property = !empty($_GET['type_property']) ? $_GET['type_property'] : "";
	$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
	$customer_phone_number = !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
	$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
	$page = !empty($_GET['per_page']) ? $_GET['per_page'] : 0;
	$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : '';
	?>
	<div class="row top_tiles">

		<div class="col-xs-12">
			<?php if ($this->session->flashdata('error')) { ?>
				<div class="alert alert-danger alert-result" style="text-align: center">
					<?= $this->session->flashdata('error') ?>
				</div>
			<?php } ?>
			<?php if ($this->session->flashdata('success')) { ?>
				<div class="alert alert-success alert-result">
					<?= $this->session->flashdata('success') ?>
				</div>
			<?php } ?>
		</div>

		<div class="col-xs-12">
			<div class="page-title">
				<div class="row">
					<div class="col-xs-12">
						<h3>HỢP ĐỒNG CHƯA THANH TOÁN BẢO HIỂM
							<br>
							<small>
								<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
										href="<?php echo base_url() ?>accountant">HỢP ĐỒNG CHƯA THANH TOÁN BẢO HIỂM</a>
							</small>
						</h3>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<div class="row">
						<div class="col-xs-12 ">
							<div class="title_right text-right">
								<div class="col-xs-12 col-md-10">
								
														</div>
														<div class="col-xs-12 col-md-1">
															<a style="background-color: #18d102;"
												   href="<?= base_url() ?>excel/exportList_contract_money_300?<?= 'fdate=' . $fdate . '&tdate=' . $tdate . '&full_name=' . $full_name . '&code_contract_disbursement=' . $code_contract_disbursement . '&store=' . $store. '&code_contract=' . $code_contract  . '&tab=' . $tab. '&status=' . $status. '&type_transaction=' . $type_transaction . '&allocation=' . $allocation?>"
												   class="btn btn-primary w-100" target="_blank"><i
															class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;</a>
														</div>
														<div class="col-xs-12 col-md-1">
								<div class="dropdown" style="display:inline-block">
					
												
										
									<button class="btn btn-success dropdown-toggle"
											onclick="$('#lockdulieu').toggleClass('show');">
										<span class="fa fa-filter"></span>
										Lọc dữ liệu
									</button>
									<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
										style="padding:15px;width:430px;max-width: 85vw;">
										<div class="row">
											<form action="<?php echo base_url('contract/list_money_300') ?>" method="get"
												  style="width: 100%;">
												
												<div class="col-xs-12 col-md-6">
													<div class="form-group">
														<label> Mã phiếu ghi </label>
														<input type="text" name="code_contract"
															   class="form-control"
															   value="<?= !empty($code_contract) ? $code_contract : "" ?>">

													</div>
												</div>
												<div class="col-xs-12 col-md-6">
													<div class="form-group">
														<label> Mã hợp đồng </label>
														<input type="text" name="code_contract_disbursement"
															   class="form-control"
															   value="<?= !empty($code_contract_disbursement) ? $code_contract_disbursement : "" ?>">

													</div>
												</div>
												
												
												<div class="col-xs-12 col-md-6">
													<div class="form-group">
														<label>&nbsp;</label> <br>
														<button class="btn btn-primary w-100">Tìm kiếm</button>
													</div>
												</div>
											</form>
										</div>
									</ul>
								</div>
							</div>
							</div>
							<!--						<div class="clearfix"></div>-->
							<hr>
							<div>
								<div>
									<div class="table-responsive">
										<table class="table table-striped table-bordered">
											<tr>
											<td style="text-align: center">
												<span style="text-align: center;color: blue">Tổng số hợp đồng</span><br/>
												<span style="color: red"><?php echo $result_count ? $result_count . ' Hợp đồng' : 0; ?>
												</span>
											</td>
											<td style="text-align: center">
												<span style="text-align: center;color: blue">Tổng tiền cho vay</span><br/>
												<span style="color: red"><?php echo $tien_vay ? number_format($tien_vay) . ' VND' : 0; ?> </span>
											</td>
											<td style="text-align: center">
												<span style="text-align: center;color: blue">Tổng tiền bảo hiểm</span><br/>
												<span style="color: red"><?php echo $tien_bao_hiem ? number_format($tien_bao_hiem) . ' VND' : 0; ?> </span>
											</td>
										
										</tr>
										</table>
									</div>
								</div>

								<div class="row">
									<div class="col-xs-12">
										<div class="table-responsive">
											<table id="" class="table table-striped table-bordered">
												<thead>
												<tr style="background-color: #0e90d2">
													<th style="text-align: center">#</th>
													<th style="text-align: center"><?= $this->lang->line('Contract_code') ?></th>
													<th style="text-align: center">Mã phiếu ghi</th>
													<th style="text-align: center">Tiền vay</th>
													<th style="text-align: center">Tiền bảo hiểm tương ứng</th>
												   <th style="text-align: center">Ngày giải ngân</th>
												   <th style="text-align: center">Trạng thái</th>
													<th style="text-align: center">Chức năng</th>
													<th style="text-align: center">Thông tin chi tiết</th>
												</tr>
												</thead>

												<tbody>
												<?php
												if (!empty($contractData)) {
													foreach ($contractData as $key => $contract) {
														?>

														<tr>
															<td style="text-align: center"><?php echo ++$key + $page ?></td>
															<td style="text-align: center">
																<a class="link" target="_blank" data-toggle="tooltip"
																   title="Click để xem chi tiết"
																   href="<?php echo base_url("accountant/view?id=") . $contract->_id->{'$oid'} ?>"
																   style="color: #0ba1b5;text-decoration: underline;">
																	<?= !empty($contract->code_contract_disbursement) ? $contract->code_contract_disbursement : $contract->code_contract ?>
																</a>
															</td>
															<td style="text-align: center"><?= !empty($contract->code_contract) ? $contract->code_contract : "" ?></td>
															
															<td style="text-align: center"><?= !empty($contract->loan_infor->amount_money) ? number_format($contract->loan_infor->amount_money, 0, '.', '.') : "" ?></td>
															<td style="text-align: center"><?= !empty($contract->loan_infor->amount_money) ? number_format($contract->loan_infor->amount_money-$contract->loan_infor->amount_loan, 0, '.', '.') : "" ?></td>
															<td style="text-align: center"><?= !empty($contract->disbursement_date) ? date('d/m/Y', intval($contract->disbursement_date)) : "" ?></td>

															<td style="text-align: center">
																<?php if ($contract->status == 17) : ?>
																	<span class="label label-success"><?= !empty($contract->status) ? contract_status($contract->status) : "" ?></span>
																<?php elseif ($contract->status == 19): ?>
																	<span class="label"
																		  style="background-color: #5a0099"><?= !empty($contract->status) ? contract_status($contract->status) : "" ?></span>
																<?php else: ?>
																	<span class="label label-warning"><?= !empty($contract->status) ? contract_status($contract->status) : "" ?></span>
																<?php endif; ?>
															</td>
															<td style="text-align: center">
																<?php if ($contract->is_call_bao_hiem != 1){ ?>
																	<button class="btn btn-info" data-toggle="modal"
																		data-target="#popup_chageBH"
																		onclick="show_popup_chageBH('<?php echo $contract->_id->{'$oid'} ?>')"
																		data-code="<?php echo $contract->code_contract_disbursement ?>"
																		data-id="<?php echo $contract->_id->{'$oid'} ?>">
																	Chuyển BH
																</button>
															<?php } ?>
															</td>
															<td style="text-align: center">
																<a target="_blank" href="<?= base_url() ?>contract/list_processes_bao_hiem?id=<?php echo $contract->_id->{'$oid'} ?>" >
																	Chi tiết chuyển bảo hiểm
																</a>
															</td>
														</tr>
													<?php }
												} else { ?>
													<tr style="text-align: center;color: red">
														<td colspan="30">Không có dữ liệu</td>
													</tr>
												<?php } ?>
												</tbody>
											</table>
											<div class="text-right">
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
</div>

<div id="popup_chageBH" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title tittle_code text-center">
XÁC NHẬN TRẢ TIỀN BẢO HIỂM KHOẢN VAY</h4>
			</div>
			<div class="modal-body center">
			<p>	Bạn có chắc chắn trả tiền bảo hiểm cho Hợp đồng này không?</p>
			   <input type="hidden" name="id_contract">
		       <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
				<button type="button" class="btn btn-primary chage_bh_btnSave">Đồng ý</button>
			</div>
			
		</div>

	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/accountant/index.js"></script>
<script>
	$('.chage_bh_btnSave').click(function (event) {
		event.preventDefault();
		var id_contract = $("input[name='id_contract']").val()
	
		var formData = new FormData();
		formData.append('id_contract', id_contract);
	

		$.ajax({
			url: _url.base_url + 'contract/do_restore_bao_hiem',
			type: "POST",
			data: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			beforeSend: function () {
				$("#themgiaodienModal").hide();
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				if (data.code == 200) {
					$("#successModal").modal("show");
					$(".msg_success").text(data.msg);
					setTimeout(function () {
						window.location.reload();
					}, 2000);
				} else {
					$("#errorModal").modal("show");
					$(".msg_error").text(data.msg);
					setTimeout(function () {
						window.location.reload();
					}, 2000);
				}

			},
			error: function () {
				$(".theloading").hide();
				$("#errorModal").modal("show");
				$(".msg_error").text('Có lỗi xảy ra, liên hệ IT để được hỗ trợ!');
				setTimeout(function () {
					window.location.reload();
				}, 2000);
			}

		})
	});
</script>

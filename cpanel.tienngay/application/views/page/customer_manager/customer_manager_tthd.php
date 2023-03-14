<!-- page content -->
<style>
	.font-16 {
		font-style: normal;
		font-weight: 540;
		font-size: 18px;
		line-height: 20px;

	}

	.font-14 {
		font-size: 16px;
		padding-bottom: 5px;
	}

	.text-blue {
		color: #5A738E;
	}

	.text-gray {
		color: #828282;
	}

	.font-weight-600 {
		font-weight: 600;
	}

	.mb-30 {
		margin-bottom: 30px;
	}

	.mb-3 {
		margin-bottom: 10px;
		width: 378px;
		height: 50px;
		top: 402px;
		left: 271px;
		border-radius: 5px;
		background-color: #D5EBF8;
		border: none;

		font-weight: 550;
		color: #5a738e;

	}
</style>
<div class="right_col" role="main">

	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3>
					<a href="<?= base_url("customer_manager/index_customer_manager") ?>">Quản lý khách hàng</a>
					/ <?= !empty($customer_code) ? $customer_code : "" ?>
					<br>
				</h3>
			</div>


			<div class="title_right text-right">
				<div class="btn-group">
					<button type="button" class="btn btn-info">Chức năng</button>
					<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
							aria-expanded="false">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">

						<li>
							<a href="<?php echo base_url("customer_manager/detail_edit?id=") . $contract->_id->{'$oid'} . '&customer_code=' . $customer_code . '&customer_identify_name=' . $customer_identify_name ?>"
							   class="dropdown-item">
								Cập nhật CCCD
							</a>
						</li>
						<li>
							<a onclick="call_for_customer('<?= !empty($contract->customer_infor->customer_phone_number) ? encrypt($contract->customer_infor->customer_phone_number) : "" ?>' , '<?= !empty($contract->_id->{'$oid'}) ? $value->_id->{'$oid'} : "" ?>', 'customer')"
							   class="call_for_customer">Gọi điện</a>
						</li>

					</ul>
				</div>
			</div>

		</div>
	</div>

	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">

			<div class="x_content">
				<div class="row">
					<div class="col-md-3">
						<div class="text-center" style="margin-bottom: 45px;">
							<img
								src="https://service.egate.global/uploads/avatar/1624962474-aa91be45af455f8eb58eb995f3a1d8e4.png"
								class="img-circle">
						</div>
						<a class="btn btn-default btn-lg w-100 text-uppercase" type="button"
						   style="border: none; background-color: #F2F2F2; margin-bottom: 10px;"
						   href="<?= base_url('customer_manager/detail?id=') . $contract->_id->{'$oid'} . '&customer_code=' . $customer_code . '&customer_identify_name=' . $customer_identify_name ?>">Thông
							tin chính
						</a>
						<a class="btn btn-default btn-lg w-100 text-uppercase mb-3" type="button"

						   href="<?= base_url('customer_manager/detail_tthd?id=') . $contract->_id->{'$oid'} . '&customer_code=' . $customer_code . '&customer_identify_name=' . $customer_identify_name ?>">Thông
							tin hợp đồng
						</a>
						<a class="btn btn-default btn-lg w-100 text-uppercase " type="submit"
						   href="<?= base_url('customer_manager/detail_giaytotuythan?id=') . $contract->_id->{'$oid'} . '&customer_code=' . $customer_code . '&customer_identify_name=' . $customer_identify_name ?>"
						   style="border: none; background-color: #F2F2F2; margin-bottom: 10px;">Giấy tờ tùy thân
						</a>
					</div>
					<div class="col-md-9">

						<div class="text-uppercase mb-0 font-16 text-blue font-weight-600">Thông tin hợp đồng vay</div>
						<hr class="mt-1">
						<div class="table-responsive">
							<div class="table-responsive">
								<table id="summary-total"
									   class="table table-bordered m-table table-hover table-calendar table-report"
									   style="font-size: 14px;font-weight: 400;">
									<thead style="background:#5A738E; color: #ffffff;">
									<tr>
										<th style="text-align: center">STT</th>
										<th style="text-align: center">Mã hợp đồng</th>
										<th style="text-align: center">Tài sản vay</th>
										<th style="text-align: center">Số tiền vay</th>
										<th style="text-align: center">Trạng thái</th>
									</tr>
									</thead>
									<tbody>
									<?php
									if (!empty($contract_involve_phone)) {
										?>
										<tr>
											<th style="text-align: left" colspan="5">Số điện
												thoại: <?= !empty($contract->customer_infor->customer_phone_number) ? hide_phone_customer($contract->customer_infor->customer_phone_number) : "" ?></th>
										</tr>
										<?php
										foreach ($contract_involve_phone as $key => $value) {
											$status = contract_status($value->status);
											?>

											<tr>
												<td style="text-align: center"><?= ++$key ?></td>
												<td style="text-align: center"><a
														href="<?php echo base_url("pawn/detail?id=") . $value->_id->{'$oid'} ?>"><?= !empty($value->code_contract_disbursement) ? $value->code_contract_disbursement : "" ?></a>
												</td>
												<td style="text-align: center"><?= !empty($value->loan_infor->type_property->text) ? $value->loan_infor->type_property->text : "" ?></td>
												<td style="text-align: center"><?= !empty($value->loan_infor->amount_loan) ? number_format($value->loan_infor->amount_loan) : "" ?></td>
												<td style="text-align: center"><?= $status; ?></td>
											</tr>
										<?php }
									} ?>

									<?php
									if (!empty($contract_involve_identify)) {
										?>
										<tr>
											<th style="text-align: left" colspan="5">
												CMT/CCCD: <?= !empty($contract->customer_infor->customer_identify) ? $contract->customer_infor->customer_identify : "" ?></th>
										</tr>
										<?php
										foreach ($contract_involve_identify as $key => $value) {
											$status = contract_status($value->status);
											?>
											<tr>
												<td style="text-align: center"><?= ++$key ?></td>
												<td style="text-align: center"><a
														href="<?php echo base_url("pawn/detail?id=") . $value->_id->{'$oid'} ?>"><?= !empty($value->code_contract_disbursement) ? $value->code_contract_disbursement : "" ?></a>
												</td>
												<td style="text-align: center"><?= !empty($value->loan_infor->type_property->text) ? $value->loan_infor->type_property->text : "" ?></td>
												<td style="text-align: center"><?= !empty($value->loan_infor->amount_loan) ? number_format($value->loan_infor->amount_loan) : "" ?></td>
												<td style="text-align: center"><?= $status; ?></td>
											</tr>
										<?php }
									} ?>

									<?php
									if (!empty($contract_involve_identify_old)) {
										?>
										<tr>
											<th style="text-align: left" colspan="5">CMT/CCCD
												cũ: <?= !empty($contract->customer_infor->customer_identify_old) ? $contract->customer_infor->customer_identify_old : "" ?></th>
										</tr>
										<?php
										foreach ($contract_involve_identify_old as $key => $value) {
											$status = contract_status($value->status);
											?>

											<tr>
												<td style="text-align: center"><?= ++$key ?></td>
												<td style="text-align: center"><a
														href="<?php echo base_url("pawn/detail?id=") . $value->_id->{'$oid'} ?>"><?= !empty($value->code_contract_disbursement) ? $value->code_contract_disbursement : "" ?></a>
												</td>
												<td style="text-align: center"><?= !empty($value->loan_infor->type_property->text) ? $value->loan_infor->type_property->text : "" ?></td>
												<td style="text-align: center"><?= !empty($value->loan_infor->amount_loan) ? number_format($value->loan_infor->amount_loan) : "" ?></td>
												<td style="text-align: center"><?= $status; ?></td>
											</tr>
										<?php }
									} ?>

									<?php
									if (!empty($contract_involve_relative_1)) {
										?>
										<tr>
											<th style="text-align: left" colspan="5">Thông tin tham chiếu
												1: <?= !empty($contract->relative_infor->phone_number_relative_1) ? hide_phone_customer($contract->relative_infor->phone_number_relative_1) : "" ?></th>
										</tr>
										<?php
										foreach ($contract_involve_relative_1 as $key => $value) {
											$status = contract_status($value->status);
											?>
											<tr>
												<td style="text-align: center"><?= ++$key ?></td>
												<td style="text-align: center"><a
														href="<?php echo base_url("pawn/detail?id=") . $value->_id->{'$oid'} ?>"><?= !empty($value->code_contract_disbursement) ? $value->code_contract_disbursement : "" ?></a>
												</td>
												<td style="text-align: center"><?= !empty($value->loan_infor->type_property->text) ? $value->loan_infor->type_property->text : "" ?></td>
												<td style="text-align: center"><?= !empty($value->loan_infor->amount_loan) ? number_format($value->loan_infor->amount_loan) : "" ?></td>
												<td style="text-align: center"><?= $status; ?></td>
											</tr>
										<?php }
									} ?>

									<?php
									if (!empty($contract_involve_relative_2)) {
										?>
										<tr>
											<th style="text-align: left" colspan="5">Thông tin tham chiếu
												2: <?= !empty($contract->relative_infor->phone_number_relative_2) ? hide_phone_customer($contract->relative_infor->phone_number_relative_2) : "" ?></th>
										</tr>
										<?php
										foreach ($contract_involve_relative_2 as $key => $value) {
											$status = contract_status($value->status);
											?>
											<tr>
												<td style="text-align: center"><?= ++$key ?></td>
												<td style="text-align: center"><a
														href="<?php echo base_url("pawn/detail?id=") . $value->_id->{'$oid'} ?>"><?= !empty($value->code_contract_disbursement) ? $value->code_contract_disbursement : "" ?></a>
												</td>
												<td style="text-align: center"><?= !empty($value->loan_infor->type_property->text) ? $value->loan_infor->type_property->text : "" ?></td>
												<td style="text-align: center"><?= !empty($value->loan_infor->amount_loan) ? number_format($value->loan_infor->amount_loan) : "" ?></td>
												<td style="text-align: center"><?= $status; ?></td>
											</tr>
										<?php }
									} ?>


									</tbody>
								</table>

							</div>
						</div>
						<br>
						<div class="text-uppercase mb-0 font-16 text-blue font-weight-600">Thông tin bảo hiểm</div>
						<hr class="mt-1">
						<div class="table-responsive">
							<div class="table-responsive">
								<table id="summary-total"
									   class="table table-bordered m-table table-hover table-calendar table-report"
									   style="font-size: 14px;font-weight: 400;">
									<thead style="background:#5A738E; color: #ffffff;">
									<tr>
										<th style="text-align: center">Tên bảo hiểm</th>
										<th style="text-align: center">Ngày bán</th>
										<th style="text-align: center">PGD bán</th>
										<th style="text-align: center">Người bán</th>
										<th style="text-align: center">Giá tiền</th>
									</tr>
									</thead>
									<tbody>
									<?php
									$arr_bh = [];
									$arr_check_hd = [];
									if (!empty($contract_involve_phone)) {
										?>
										<?php
										foreach ($contract_involve_phone as $key => $value) {
											if (!in_array($value->code_contract, $arr_check_hd)) {
												array_push($arr_check_hd, $value->code_contract);
												array_push($arr_bh, $value);
											}

											?>
										<?php }
									} ?>
									<?php
									if (!empty($contract_involve_identify)) {
										?>
										<?php
										foreach ($contract_involve_identify as $key => $value) {
											if (!in_array($value->code_contract, $arr_check_hd)) {
												array_push($arr_check_hd, $value->code_contract);
												array_push($arr_bh, $value);
											}
											?>
										<?php }
									} ?>

									<?php if (count($arr_bh) >= 1): ?>
										<?php foreach ($arr_bh as $item): ?>
											<?php if ($item->loan_infor->loan_insurance != ""): ?>
												<tr>
													<td style="text-align: center"><?= !empty($item->loan_infor->amount_GIC) ? "Bảo hiểm khoản vay - GIC" : "Bảo hiểm khoản vay - MIC" ?></td>
													<td style="text-align: center"><?= !empty($item->updated_at) ? date("d/m/y H:i:s", $item->updated_at) : date("d/m/y H:i:s", $item->created_at) ?></td>
													<td style="text-align: center"><?= !empty($item->store->name) ? $item->store->name : "" ?></td>
													<td style="text-align: center"><?= !empty($item->created_by) ? $item->created_by : "" ?></td>
													<td style="text-align: center"><?= !empty($item->loan_infor->amount_GIC) ? number_format($item->loan_infor->amount_GIC) : number_format($item->loan_infor->amount_MIC) ?></td>
												</tr>
											<?php endif; ?>

											<?php if ($item->loan_infor->amount_GIC_easy != "0"): ?>
												<tr>
													<td style="text-align: center">Bảo hiểm xe máy(easy) GIC</td>
													<td style="text-align: center"><?= !empty($item->updated_at) ? date("d/m/y H:i:s", $item->updated_at) : date("d/m/y H:i:s", $item->created_at) ?></td>
													<td style="text-align: center"><?= !empty($item->store->name) ? $item->store->name : "" ?></td>
													<td style="text-align: center"><?= !empty($item->created_by) ? $item->created_by : "" ?></td>
													<td style="text-align: center"><?= !empty($item->loan_infor->amount_GIC_easy) ? number_format($item->loan_infor->amount_GIC_easy) : "" ?></td>
												</tr>
											<?php endif; ?>

											<?php if ($item->loan_infor->code_VBI_1 != ""): ?>
												<tr>
													<td style="text-align: center"><?= !empty($item->loan_infor->code_VBI_1) ? $item->loan_infor->code_VBI_1 : "" ?></td>
													<td style="text-align: center"><?= !empty($item->updated_at) ? date("d/m/y H:i:s", $item->updated_at) : date("d/m/y H:i:s", $item->created_at) ?></td>
													<td style="text-align: center"><?= !empty($item->store->name) ? $item->store->name : "" ?></td>
													<td style="text-align: center"><?= !empty($item->created_by) ? $item->created_by : "" ?></td>
													<td style="text-align: center"><?= !empty($item->loan_infor->amount_code_VBI_1) ? number_format($item->loan_infor->amount_code_VBI_1) : "" ?></td>
												</tr>
											<?php endif; ?>

											<?php if ($item->loan_infor->code_VBI_2 != ""): ?>
												<tr>
													<td style="text-align: center"><?= !empty($item->loan_infor->code_VBI_2) ? $item->loan_infor->code_VBI_2 : "" ?></td>
													<td style="text-align: center"><?= !empty($item->updated_at) ? date("d/m/y H:i:s", $item->updated_at) : date("d/m/y H:i:s", $item->created_at) ?></td>
													<td style="text-align: center"><?= !empty($item->store->name) ? $item->store->name : "" ?></td>
													<td style="text-align: center"><?= !empty($item->created_by) ? $item->created_by : "" ?></td>
													<td style="text-align: center"><?= !empty($item->loan_infor->amount_code_VBI_2) ? number_format($item->loan_infor->amount_code_VBI_2) : "" ?></td>
												</tr>
											<?php endif; ?>

											<?php if ($item->loan_infor->code_GIC_plt != ""): ?>
												<tr>
													<td style="text-align: center">Bảo hiểm phúc lộc thọ</td>
													<td style="text-align: center"><?= !empty($item->updated_at) ? date("d/m/y H:i:s", $item->updated_at) : date("d/m/y H:i:s", $item->created_at) ?></td>
													<td style="text-align: center"><?= !empty($item->store->name) ? $item->store->name : "" ?></td>
													<td style="text-align: center"><?= !empty($item->created_by) ? $item->created_by : "" ?></td>
													<td style="text-align: center"><?= !empty($item->loan_infor->amount_GIC_plt) ? number_format($item->loan_infor->amount_GIC_plt) : "" ?></td>
												</tr>
											<?php endif; ?>

											<?php if (!empty($arr_mic_tnds)): ?>
												<?php foreach ($arr_mic_tnds as $item1): ?>
													<tr>
														<td style="text-align: center"><?= !empty($item1->type_mic) ? $item1->type_mic : "" ?></td>
														<td style="text-align: center"><?= !empty($item1->updated_at) ? date("d/m/y H:i:s", $item1->updated_at) : date("d/m/y H:i:s", $item1->created_at) ?></td>
														<td style="text-align: center"><?= !empty($item1->store->name) ? $item1->store->name : "" ?></td>
														<td style="text-align: center"><?= !empty($item1->created_by) ? $item1->created_by : "" ?></td>
														<td style="text-align: center"><?= !empty($item1->mic_fee) ? number_format($item1->mic_fee) : 0 ?></td>
													</tr>
												<?php endforeach; ?>
											<?php endif; ?>

											<?php if (!empty($contract_tnds)): ?>
												<?php foreach ($contract_tnds as $item1): ?>
													<tr>
														<td style="text-align: center"><?= !empty($item1->contract_info->loan_infor->bao_hiem_tnds->type_tnds) ? $item1->contract_info->loan_infor->bao_hiem_tnds->type_tnds : "" ?></td>
														<td style="text-align: center"><?= !empty($item1->updated_at) ? date("d/m/y H:i:s", $item1->updated_at) : date("d/m/y H:i:s", $item1->created_at) ?></td>
														<td style="text-align: center"><?= !empty($item1->contract_info->store->name) ? $item1->contract_info->store->name : "" ?></td>
														<td style="text-align: center"><?= !empty($item1->contract_info->created_by) ? $item1->contract_info->created_by : "" ?></td>
														<td style="text-align: center"><?= !empty($item1->data->response->PHI) ? number_format($item1->data->response->PHI) : 0 ?></td>
													</tr>
												<?php endforeach; ?>
											<?php endif; ?>

											<?php if (!empty($vbi_sxh)): ?>
												<?php foreach ($vbi_sxh as $item1): ?>
													<tr>
														<td style="text-align: center"><?= !empty($item1->goi_bh) ? $item1->goi_bh : "" ?></td>
														<td style="text-align: center"><?= !empty($item1->created_at) ? date("d/m/y H:i:s", $item1->created_at) : "" ?></td>
														<td style="text-align: center"><?= !empty($item1->store->name) ? $item1->store->name : "" ?></td>
														<td style="text-align: center"><?= !empty($item1->created_by) ? $item1->created_by : "" ?></td>
														<td style="text-align: center"><?= !empty($item1->vbi_sxh->tong_phi) ? number_format($item1->vbi_sxh->tong_phi) : 0 ?></td>
													</tr>
												<?php endforeach; ?>
											<?php endif; ?>

											<?php if (!empty($vbi_tnds)): ?>
												<?php foreach ($vbi_tnds as $item1): ?>
													<tr>
														<td style="text-align: center"><?= !empty($item1->code) ? $item1->code : "" ?></td>
														<td style="text-align: center"><?= !empty($item1->created_at) ? date("d/m/y H:i:s", $item1->created_at) : "" ?></td>
														<td style="text-align: center"><?= !empty($item1->store->name) ? $item1->store->name : "" ?></td>
														<td style="text-align: center"><?= !empty($item1->created_by) ? $item1->created_by : "" ?></td>
														<td style="text-align: center"><?= !empty($item1->vbi_tnds->tong_phi) ? number_format($item1->vbi_tnds->tong_phi) : 0 ?></td>
													</tr>
												<?php endforeach; ?>
											<?php endif; ?>

											<?php if (!empty($vbi_utv)): ?>
												<?php foreach ($vbi_utv as $item1): ?>
													<tr>
														<td style="text-align: center"><?= !empty($item1->goi_bh) ? $item1->goi_bh : "" ?></td>
														<td style="text-align: center"><?= !empty($item1->created_at) ? date("d/m/y H:i:s", $item1->created_at) : "" ?></td>
														<td style="text-align: center"><?= !empty($item1->store->name) ? $item1->store->name : "" ?></td>
														<td style="text-align: center"><?= !empty($item1->created_by) ? $item1->created_by : "" ?></td>
														<td style="text-align: center"><?= !empty($item1->vbi_utv->tong_phi) ? number_format($item1->vbi_utv->tong_phi) : 0 ?></td>
													</tr>
												<?php endforeach; ?>
											<?php endif; ?>

										<?php endforeach; ?>
									<?php endif; ?>

									</tbody>
								</table>

							</div>
						</div>
						<br>
						<div class="text-uppercase mb-0 font-16 text-blue font-weight-600">Thông tin thanh toán dịch vụ</div>
						<hr class="mt-1">
						<div class="table-responsive">
							<div class="table-responsive">
								<table id="summary-total"
									   class="table table-bordered m-table table-hover table-calendar table-report"
									   style="font-size: 14px;font-weight: 400;">
									<thead style="background:#5A738E; color: #ffffff;">
									<tr>
										<th style="text-align: center">STT</th>
										<th style="text-align: center">Mã giao dịch</th>
										<th style="text-align: center">Dịch vụ</th>
										<th style="text-align: center">Số tiền thanh toán</th>
										<th style="text-align: center">Thời gian thanh toán</th>
									</tr>
									</thead>
									<tbody>
									<?php if (!empty($arr_order)): ?>
										<?php foreach ($arr_order as $key => $value): ?>
											<td style="text-align: center"><?= ++$key ?></td>
											<td style="text-align: center"><?= !empty($value->mc_request_id) ? $value->mc_request_id : "" ?></td>
											<td style="text-align: center"><?= !empty($value->service_name) ? $value->service_name : "" ?></td>
											<td style="text-align: center"><?= !empty($value->money) ? number_format($value->money) : 0 ?></td>
											<td style="text-align: center"><?= !empty($value->created_at) ? date("H:i:s d/m/y", $value->created_at) : "" ?></td>
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

<?php
function hide_phone_customer($phone, $role = "")
{
	$result = str_replace(substr($phone, 4, 4), stars($phone), $phone);
	if ($role != "") {
		return $phone;
	} else {
		return $result;
	}

}


?>
<div class="modal fade" id="approve_call" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title title_modal_approve text-center"></h3>
				<hr>
				<div style="text-align: center; font-size: 18px">
					<button id="call" class="btn btn-success"><i class="fa fa-phone" aria-hidden="true"></i>Gọi</button>
					<button id="end" class="btn btn-danger"><i class="fa fa-ban" aria-hidden="true"></i> Dừng</button>
					<input id="number" name="phone_number" type="hidden" value=""/>
					<p id="status" style="margin-left: 125px;"></p>
				</div>

				<div class="form-group">
					<input type="text" value="<?php echo $this->input->get('id') ?>" class="hidden"
						   class="form-control " id="contract_id">
				</div>
			</div>
		</div>
	</div>
</div>

<script>

	function call_for_customer(phone_number, contract_id, type) {
		console.log(phone_number);
		if (phone_number == undefined || phone_number == '') {
			alert("Không có số");
		} else {
			if (type == "customer") {
				$(".title_modal_approve").text("Gọi cho khách hàng");
			}
			if (type == "rel1") {
				$(".title_modal_approve").text("Gọi cho tham chiếu 1");
			}
			if (type == "rel2") {
				$(".title_modal_approve").text("Gọi cho tham chiếu 2");
			}
			$("#number").val(phone_number);
			$(".contract_id").val(contract_id);
			$("#approve_call").modal("show");
		}
	}
</script>

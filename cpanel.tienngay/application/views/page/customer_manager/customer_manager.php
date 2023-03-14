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
					<a href="<?= base_url("customer_manager/index_customer_manager") ?>" >Quản lý khách hàng</a> / <?= !empty($customer_code) ? $customer_code : "" ?>
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
						<a class="btn btn-default btn-lg w-100 text-uppercase mb-3" type="button"
						   href="<?= base_url('customer_manager/detail?id=') . $contract->_id->{'$oid'} . '&customer_code=' . $customer_code . '&customer_identify_name=' . $customer_identify_name ?>">Thông
							tin chính
						</a>
						<a class="btn btn-default btn-lg w-100 text-uppercase " type="button"
						   style="border: none; background-color: #F2F2F2; margin-bottom: 10px;"
						   href="<?= base_url('customer_manager/detail_tthd?id=') . $contract->_id->{'$oid'} . '&customer_code=' . $customer_code . '&customer_identify_name=' . $customer_identify_name ?>">Thông
							tin hợp đồng
						</a>
						<a class="btn btn-default btn-lg w-100 text-uppercase " type="submit"
						   href="<?= base_url('customer_manager/detail_giaytotuythan?id=') . $contract->_id->{'$oid'} . '&customer_code=' . $customer_code . '&customer_identify_name=' . $customer_identify_name ?>"
						   style="border: none; background-color: #F2F2F2; margin-bottom: 10px;">Giấy tờ tùy thân
						</a>
					</div>
					<div class="col-md-9">
						<div class="text-uppercase mb-0 font-16 text-blue font-weight-600">Thông tin cá nhân</div>
						<hr class="mt-1">
						<div class="row">
							<div class="col-md-4">
								<div class="mb-30">
									<div class="text-gray font-14">Mã khách hàng</div>
									<div
										class="font-16 text-blue"><?= !empty($customer_code) ? $customer_code : "" ?></div>
								</div>
								<div class="mb-30">
									<div class="text-gray font-14">Loại giấy tờ</div>
									<div
										class="font-16 text-blue"><?= !empty($customer_identify_name) ? $customer_identify_name : "" ?></div>
								</div>
								<?php
								$current_address = "";
								if ($contract->current_address->current_stay != "") {
									$current_address = $contract->current_address->current_stay;
								}
								if ($contract->current_address->ward_name != "") {
									$current_address = $contract->current_address->current_stay . ", " . $contract->current_address->ward_name;
								}
								if ($contract->current_address->district_name != "") {
									$current_address = $contract->current_address->current_stay . ", " . $contract->current_address->ward_name . ", " . $contract->current_address->district_name;
								}
								if ($contract->current_address->province_name != "") {
									$current_address = $contract->current_address->current_stay . ", " . $contract->current_address->ward_name . ", " . $contract->current_address->district_name . ", " . $contract->current_address->province_name;
								}

								$houseHold_address = "";
								if ($contract->houseHold_address->address_household != ""){
									$houseHold_address = $contract->houseHold_address->address_household;
								}
								if ($contract->houseHold_address->ward_name != ""){
									$houseHold_address = $contract->houseHold_address->address_household.", ". $contract->houseHold_address->ward_name;
								}
								if ($contract->houseHold_address->district_name != ""){
									$houseHold_address = $contract->houseHold_address->address_household.", ". $contract->houseHold_address->ward_name.", ". $contract->houseHold_address->district_name;
								}
								if ($contract->houseHold_address->province_name != ""){
									$houseHold_address = $contract->houseHold_address->address_household.", ". $contract->houseHold_address->ward_name.", ". $contract->houseHold_address->district_name.", ". $contract->houseHold_address->province_name;
								}
								?>
								<div class="mb-30">
									<div class="text-gray font-14">Địa chỉ thường trú</div>
									<div
										class="font-16 text-blue"><?= !empty($current_address) ? $current_address : "" ?></div>
								</div><div class="mb-30">
									<div class="text-gray font-14">Địa chỉ hộ khẩu</div>
									<div
										class="font-16 text-blue"><?= !empty($houseHold_address) ? $houseHold_address : "" ?></div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="mb-30">
									<div class="text-gray font-14">Tên khách hàng</div>
									<div
										class="font-16 text-blue"><?= !empty($contract->customer_infor->customer_name) ? $contract->customer_infor->customer_name : "" ?></div>
								</div>
								<div class="mb-30">
									<div class="text-gray font-14">Số</div>
									<div
										class="font-16 text-blue"><?= !empty($contract->customer_infor->customer_identify) ? $contract->customer_infor->customer_identify : "" ?></div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="mb-30">
									<div class="text-gray font-14">SĐT</div>
									<div
										class="font-16 text-blue"><?= !empty($contract->customer_infor->customer_phone_number) ? hide_phone_customer($contract->customer_infor->customer_phone_number) : "" ?></div>
								</div>
							</div>
						</div>

						<div class="text-uppercase mb-0 font-16 text-blue font-weight-600">Thông tin việc làm</div>
						<hr class="mt-1">
						<div class="row">
							<div class="col-md-4">
								<div class="mb-30">
									<div class="text-gray font-14">Công ty</div>
									<div
										class="font-16 text-blue"><?= !empty($contract->job_infor->name_company) ? $contract->job_infor->name_company : "" ?></div>
								</div>
								<div class="mb-30">
									<div class="text-gray font-14">Địa chỉ công ty</div>
									<div
										class="font-16 text-blue"><?= !empty($contract->job_infor->address_company) ? $contract->job_infor->address_company : "" ?></div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="mb-30">
									<div class="text-gray font-14">Nghề nghiệp</div>
									<div
										class="font-16 text-blue"><?= !empty($contract->job_infor->job) ? $contract->job_infor->job : "" ?></div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="mb-30">
									<div class="text-gray font-14">Chức vụ</div>
									<div
										class="font-16 text-blue"><?= !empty($contract->job_infor->job_position) ? $contract->job_infor->job_position : "" ?></div>
								</div>
								<div class="mb-30">
									<div class="text-gray font-14">SĐT công ty</div>
									<div
										class="font-16 text-blue"><?= !empty($contract->job_infor->phone_number_company) ? $contract->job_infor->phone_number_company : "" ?></div>
								</div>
							</div>
						</div>

						<div class="text-uppercase mb-0 font-16 text-blue font-weight-600">Thông tin tài khoản</div>
						<hr class="mt-1">
						<div class="row">
							<div class="col-md-4">
								<div class="mb-30">
									<div class="text-gray font-14">Tên ngân hàng</div>
									<div
										class="font-16 text-blue"><?= !empty($contract->receiver_infor->bank_name) ? $contract->receiver_infor->bank_name : "" ?></div>
								</div>

							</div>
							<div class="col-md-4">
								<div class="mb-30">
									<div class="text-gray font-14">Số tài khoản ngân hàng</div>
									<div
										class="font-16 text-blue"><?= !empty($contract->receiver_infor->bank_account) ? $contract->receiver_infor->bank_account : "" ?></div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="mb-30">
									<div class="text-gray font-14">Tên chủ tài khoản</div>
									<div
										class="font-16 text-blue"><?= !empty($contract->receiver_infor->bank_account_holder) ? $contract->receiver_infor->bank_account_holder : "" ?></div>
								</div>
							</div>

						</div>

						<div class="text-uppercase mb-0 font-16 text-blue font-weight-600">Thông tin tham chiếu</div>
						<hr class="mt-1">
						<div class="table-responsive">
							<div class="table-responsive">
								<table id="summary-total"
									   class="table table-bordered m-table table-hover table-calendar table-report"
									   style="font-size: 14px;font-weight: 400;">
									<thead style="background:#5A738E; color: #ffffff;">
									<tr>
										<th style="text-align: center">STT</th>
										<th style="text-align: center">Họ và tên</th>
										<th style="text-align: center">Quan hệ</th>
										<th style="text-align: center">Số điện thoại</th>
										<th style="text-align: center">Địa chỉ</th>
									</tr>
									</thead>
									<tbody>
									<?php if (!empty($contract->relative_infor->fullname_relative_1)): ?>
										<tr>
											<td style="text-align: center">1</td>
											<td style="text-align: center"><?= !empty($contract->relative_infor->fullname_relative_1) ? $contract->relative_infor->fullname_relative_1 : "" ?></td>
											<td style="text-align: center"><?= !empty($contract->relative_infor->type_relative_1) ? $contract->relative_infor->type_relative_1 : "" ?></td>
											<td style="text-align: center"><?= !empty($contract->relative_infor->phone_number_relative_1) ? hide_phone_customer($contract->relative_infor->phone_number_relative_1) : "" ?></td>
											<td style="text-align: center"><?= !empty($contract->relative_infor->hoursehold_relative_1) ? $contract->relative_infor->hoursehold_relative_1 : "" ?></td>
										</tr>
									<?php endif; ?>
									<?php if (!empty($contract->relative_infor->fullname_relative_2)): ?>
										<tr>
											<td style="text-align: center">2</td>
											<td style="text-align: center"><?= !empty($contract->relative_infor->fullname_relative_2) ? $contract->relative_infor->fullname_relative_2 : "" ?></td>
											<td style="text-align: center"><?= !empty($contract->relative_infor->type_relative_2) ? $contract->relative_infor->type_relative_2 : "" ?></td>
											<td style="text-align: center"><?= !empty($contract->relative_infor->phone_number_relative_2) ? hide_phone_customer($contract->relative_infor->phone_number_relative_2) : "" ?></td>
											<td style="text-align: center"><?= !empty($contract->relative_infor->hoursehold_relative_2) ? $contract->relative_infor->hoursehold_relative_2 : "" ?></td>
										</tr>
									<?php endif; ?>
									<?php if (!empty($contract->relative_infor->fullname_relative_3)): ?>
										<tr>
											<td style="text-align: center">3</td>
											<td style="text-align: center"><?= !empty($contract->relative_infor->fullname_relative_3) ? $contract->relative_infor->fullname_relative_3 : "" ?></td>
											<td style="text-align: center"><?= !empty($contract->relative_infor->type_relative_3) ? $contract->relative_infor->type_relative_3 : "" ?></td>
											<td style="text-align: center"><?= !empty($contract->relative_infor->phone_relative_3) ? hide_phone_customer($contract->relative_infor->phone_relative_3) : "" ?></td>
											<td style="text-align: center"><?= !empty($contract->relative_infor->address_relative_3) ? $contract->relative_infor->address_relative_3 : "" ?></td>
										</tr>
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

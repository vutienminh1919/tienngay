<div class="row">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="col-xs-12">
		<h3 class="text-danger">
			Thông tin KH và thông tin liên quan:
		</h3>
	</div>

	<div class="col-xs-12">
		<table class="table table-bordered table-fixed">
			<tbody>
			<tr>
				<th>Phòng giao dịch</th>
				<td colspan="3"><?= !empty($contractInfor->store->name) ? $contractInfor->store->name : "" ?></td>
			</tr>
			<tr>
				<th>Người tạo hợp đồng</th>
				<td colspan="3"><?= !empty($contractInfor->created_by) ? $contractInfor->created_by : "" ?></td>
			</tr>

			</tbody>
		</table>
	</div>

	<div class="col-xs-12">
		<p>
		<h4>Thông tin khách hàng:</h4>
		</p>

		<table class="table table-bordered">
			<thead>
			<tr>

				<th scope="col">Tên KH</th>
				<th scope="col">Ngày sinh</th>
				<th scope="col">CMT/CCCD</th>
				<th scope="col">SĐT</th>
				<th scope="col">Nguồn KH</th>
				<th scope="col">Tình trạng hôn nhân</th>
			</tr>
			</thead>
			<tbody>
			<tr>

				<td><?= $contractInfor->customer_infor->customer_name ? $contractInfor->customer_infor->customer_name : "" ?></td>
				<td><?= $contractInfor->customer_infor->customer_BOD ? date('d/m/Y', strtotime($contractInfor->customer_infor->customer_BOD)) : "" ?></td>
				<td><?= $contractInfor->customer_infor->customer_identify ? $contractInfor->customer_infor->customer_identify : "" ?></td>
				<td><?= $contractInfor->customer_infor->customer_phone_number ? hide_phone($contractInfor->customer_infor->customer_phone_number) : "" ?></td>
				<?php
				$customer_resources = !empty($contractInfor->customer_infor->customer_resources) ? $contractInfor->customer_infor->customer_resources : "";
				$resources = "";
				if ($customer_resources == '1') {
					$resources = "Digital";
				}
				if ($customer_resources == '2') {
					$resources = "TLS Tự kiếm";
				}
				if ($customer_resources == '3') {
					$resources = "Tổng đài";
				}
				if ($customer_resources == '4') {
					$resources = "Giới thiệu";
				}
				if ($customer_resources == '5') {
					$resources = "Đối tác";
				}
				if ($customer_resources == '6') {
					$resources = "Fanpage";
				}
				if ($customer_resources == '7') {
					$resources = "Nguồn khác";
				}
				if ($customer_resources == '8') {
					$resources = "KH vãng lai";
				}
				if ($customer_resources == '9') {
					$resources = "KH tự kiếm";
				}
				if ($customer_resources == '10') {
					$resources = "Cộng tác viên";
				}
				if ($customer_resources == '11') {
					$resources = "KH giới thiệu KH";
				}
				if ($customer_resources == '12') {
					$resources = "Nguồn App Mobile";
				}
				if ($customer_resources == 'VM') {
					$resources = "Nguồn vay mượn";
				}
				if ($customer_resources == 'hoiso') {
					$resources = "Nguồn hội sở";
				}
				if ($customer_resources == 'tukiem') {
					$resources = "Nguồn tự kiếm";
				}
				if ($customer_resources == 'vanglai') {
					$resources = "Nguồn vãng lai";
				}
				?>
				<td><?= !empty($resources) ? $resources : "" ?></td>
				<?php
				$customer_marriage = !empty($contractInfor->customer_infor->marriage) ? $contractInfor->customer_infor->marriage : "";
				$marriage = "";
				if ($customer_marriage == '1') {
					$marriage = "Đã kết hôn";
				}
				if ($customer_marriage == '2') {
					$marriage = "Chưa kết hôn";
				}
				if ($customer_marriage == '3') {
					$marriage = "Ly hôn";
				}
				?>
				<td><?= !empty($marriage) ? $marriage : "" ?></td>
			</tr>
			</tbody>
		</table>
	</div>


	<div class="col-xs-12">
		<p>
		<h4>Thông tin nơi ở:</h4>
		</p>
		<table class="table table-bordered table-fixed">
			<tbody>
			<tr>
				<th>Địa chỉ đang ở</th>
				<td colspan="3"><?= !empty($contractInfor->current_address->current_stay) ? $contractInfor->current_address->current_stay : "" ?><?= !empty($contractInfor->current_address->ward_name) ? ", " . $contractInfor->current_address->ward_name : "" ?><?= !empty($contractInfor->current_address->district_name) ? ", " . $contractInfor->current_address->district_name : "" ?><?= !empty($contractInfor->current_address->province_name) ? ", " . $contractInfor->current_address->province_name : "" ?> <?= !empty($contractInfor->current_address->time_life) ? " (" . $contractInfor->current_address->time_life . ")" : "" ?></td>
			</tr>
			<tr>
				<th>Địa chỉ hộ khẩu</th>
				<td colspan="3"><?= !empty($contractInfor->houseHold_address->address_household) ? $contractInfor->houseHold_address->address_household : "" ?><?= !empty($contractInfor->houseHold_address->ward_name) ? ", " . $contractInfor->houseHold_address->ward_name : "" ?><?= !empty($contractInfor->houseHold_address->district_name) ? ", " . $contractInfor->houseHold_address->district_name : "" ?><?= !empty($contractInfor->houseHold_address->province_name) ? ", " . $contractInfor->houseHold_address->province_name : "" ?></td>
			</tr>

			</tbody>
		</table>
	</div>


	<div class="col-xs-12">
		<p>
		<h4>Thông tin việc làm:</h4>
		</p>

		<table class="table table-bordered">
			<thead>
			<tr>
				<th scope="col">Tên công ty</th>
				<th scope="col">Địa chỉ công ty</th>
				<th scope="col">Số điện thoại công ty</th>
				<th scope="col">Vị trí/Chức vụ</th>
				<th scope="col">Thu nhập</th>
				<th scope="col">Hình thức nhận lương</th>
				<th scope="col">Nghề nghiệp</th>
			</tr>
			</thead>
			<tbody>
			<tr>

				<td><?= !empty($contractInfor->job_infor->name_company) ? $contractInfor->job_infor->name_company : "" ?></td>
				<td><?= !empty($contractInfor->job_infor->address_company) ? $contractInfor->job_infor->address_company : "" ?></td>
				<td><?= !empty($contractInfor->job_infor->phone_number_company) ? $contractInfor->job_infor->phone_number_company : "" ?></td>
				<td><?= !empty($contractInfor->job_infor->job_position) ? $contractInfor->job_infor->job_position : "" ?></td>
				<td><?= !empty($contractInfor->job_infor->salary) ? number_format($contractInfor->job_infor->salary) : "" ?></td>
				<?php
				$receive = !empty($contractInfor->job_infor->receive_salary_via) ? $contractInfor->job_infor->receive_salary_via : "";
				if (!empty($receive) && $receive == 1) {
					$receive_salary_via = 'Tiền mặt';
				} else if ($receive == 2) {
					$receive_salary_via = 'Chuyển khoản';
				} else {
					$receive_salary_via = '';
				}

				?>
				<td><?= !empty($receive_salary_via) ? $receive_salary_via : "" ?></td>
				<td><?= !empty($contractInfor->job_infor->job) ? $contractInfor->job_infor->job : "" ?></td>

			</tr>

			</tbody>
		</table>
	</div>

	<div class="col-xs-12">
		<p>
		<h4>Thông tin tham chiếu:</h4>
		</p>

		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Tên tham chiếu</th>
					<th scope="col">Mối quan hệ</th>
					<th scope="col">Số điện thoại</th>
					<th scope="col">Địa chỉ cư trú</th>
					<th scope="col">Ghi chú</th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<th scope="row">1</th>
					<td><?= !empty($contractInfor->relative_infor->fullname_relative_1) ? $contractInfor->relative_infor->fullname_relative_1 : "" ?></td>
					<td><?= !empty($contractInfor->relative_infor->type_relative_1) ? $contractInfor->relative_infor->type_relative_1 : "" ?></td>
					<td><?= !empty($contractInfor->relative_infor->phone_number_relative_1) ? $contractInfor->relative_infor->phone_number_relative_1 : "" ?></td>
					<td><?= !empty($contractInfor->relative_infor->hoursehold_relative_1) ? $contractInfor->relative_infor->hoursehold_relative_1 : "" ?></td>
					<td><?= !empty($contractInfor->relative_infor->confirm_relativeInfor_1) ? $contractInfor->relative_infor->confirm_relativeInfor_1 : "" ?></td>
				</tr>
				<tr>
					<th scope="row">2</th>
					<td><?= !empty($contractInfor->relative_infor->fullname_relative_2) ? $contractInfor->relative_infor->fullname_relative_2 : "" ?></td>
					<td><?= !empty($contractInfor->relative_infor->type_relative_2) ? $contractInfor->relative_infor->type_relative_2 : "" ?></td>
					<td><?= !empty($contractInfor->relative_infor->phone_number_relative_2) ? $contractInfor->relative_infor->phone_number_relative_2 : "" ?></td>
					<td><?= !empty($contractInfor->relative_infor->hoursehold_relative_2) ? $contractInfor->relative_infor->hoursehold_relative_2 : "" ?></td>
					<td><?= !empty($contractInfor->relative_infor->confirm_relativeInfor_2) ? $contractInfor->relative_infor->confirm_relativeInfor_2 : "" ?></td>
				</tr>
				<tr>
					<th scope="row">3</th>
					<td><?= !empty($contractInfor->relative_infor->fullname_relative_3) ? $contractInfor->relative_infor->fullname_relative_3 : "" ?></td>
					<td><?= !empty($contractInfor->relative_infor->type_relative_3) ? $contractInfor->relative_infor->type_relative_3 : "" ?></td>
					<td><?= !empty($contractInfor->relative_infor->phone_relative_3) ? $contractInfor->relative_infor->phone_relative_3 : "" ?></td>
					<td><?= !empty($contractInfor->relative_infor->hoursehold_relative_3) ? $contractInfor->relative_infor->hoursehold_relative_3 : "" ?></td>
					<td><?= !empty($contractInfor->relative_infor->confirm_relativeInfor3) ? $contractInfor->relative_infor->confirm_relativeInfor3 : "" ?></td>
				</tr>

				</tbody>
			</table>
		</div>
	</div>

	<div class="col-xs-12">
		<p>
		<h4>Thông tin tài khoản:</h4>
		</p>

		<div class="table-responsive">
			<table class="table table-bordered table-fixed">
				<thead>
				<tr>
					<th scope="col">Hình thức</th>
					<th scope="col">Ngân hàng</th>
					<th scope="col">Chi nhánh</th>
					<th scope="col">STK</th>
					<th scope="col">Chủ tài khoản</th>

				</tr>
				</thead>
				<tbody>
				<tr>
					<?php
					$type_payout = !empty($contractInfor->receiver_infor->type_payout) ? $contractInfor->receiver_infor->type_payout : "";
					if ($type_payout == 2) {
						$type_payout_c = 'Tài khoản ngân hàng';
					} else if ($type_payout == 3) {
						$type_payout_c = 'Thẻ atm';
					} else {
						$type_payout_c = '';
					}

					?>
					<td><?= !empty($type_payout_c) ? $type_payout_c : "" ?></td>
					<td><?= !empty($contractInfor->receiver_infor->bank_name) ? $contractInfor->receiver_infor->bank_name : "" ?></td>
					<td><?= !empty($contractInfor->receiver_infor->bank_branch) ? $contractInfor->receiver_infor->bank_branch : "" ?></td>
					<td><?= !empty($contractInfor->receiver_infor->bank_account) ? $contractInfor->receiver_infor->bank_account : "" ?></td>
					<td><?= !empty($contractInfor->receiver_infor->bank_account_holder) ? $contractInfor->receiver_infor->bank_account_holder : "" ?></td>
				</tr>

				</tbody>
			</table>
		</div>
	</div>
</div>


<div class="row">
	<div class="col-xs-12">
		<h3 class="text-danger">
			Thông tin khoản vay và tài sản liên quan
		</h3>
	</div>

	<div class="col-xs-12">
		<p>
		<h4>Thông tin khoản vay:</h4>
		</p>

		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
				<tr>
					<th scope="col">Hình thức vay</th>
					<th scope="col">Loại tài sản</th>
					<th scope="col">Sản phẩm vay</th>
					<th scope="col">Tài sản vay</th>
					<th scope="col">Khấu hao tài sản</th>
					<th scope="col">Định giá tài sản</th>
					<th scope="col">Số tiền được vay</th>

				</tr>
				</thead>
				<tbody>
				<tr>
					<td><?= !empty($contractInfor->loan_infor->type_loan->text) ? $contractInfor->loan_infor->type_loan->text : "" ?></td>
					<td><?= !empty($contractInfor->loan_infor->type_property->text) ? $contractInfor->loan_infor->type_property->text : "" ?></td>
					<td><?= !empty($contractInfor->loan_infor->loan_product->text) ? $contractInfor->loan_infor->loan_product->text : "" ?></td>
					<td><?= !empty($contractInfor->loan_infor->name_property->text) ? $contractInfor->loan_infor->name_property->text : "" ?></td>
					<td>

						<div class="depreciation_by_property">
							<?php
							$arrMinus = array();
							if (!empty($contractInfor->loan_infor->decreaseProperty)) {
								$decreaseProperty = $contractInfor->loan_infor->decreaseProperty;
								foreach ($decreaseProperty as $item) {
									$a = array();
									$a['checked'] = !empty($item->checked) ? $item->checked : '';
									$a['name'] = !empty($item->name) ? $item->name : '';
									$a['slug'] = !empty($item->slug) ? $item->slug : '';
									$a['price'] = !empty($item->value) ? $item->value : '';
									array_push($arrMinus, $a);
								}
							}
							?>

							<?php if ($contractInfor->loan_infor->type_property->code == "XM") { ?>
								<?php foreach ($arrMinus as $item) { ?>
									<div>
										<label><input disabled
													  data-name="<?= $item['name'] ?>"
													  data-slug="<?= $item['slug'] ?>"
													  onchange="appraise_property_XM(this)" <?= $item['checked'] == 1 ? "checked" : "" ?>
													  type="radio"
													  value="<?= $item['price'] ?>"><?= $item['name'] ?>

										</label>
									</div>
								<?php } ?>
							<?php } ?>
							<?php if ($contractInfor->loan_infor->type_property->code == "OTO") { ?>
								<?php foreach ($arrMinus as $item) { ?>
									<div>
										<label><input disabled
													  data-name="<?= $item['name'] ?>"
													  data-slug="<?= $item['slug'] ?>"
													  onchange="appraise_property(this)" <?= $item['checked'] == 1 ? "checked" : "" ?>
													  type="checkbox"
													  value="<?= $item['price'] ?>"><?= $item['name'] ?>
										</label>
									</div>
								<?php } ?>
							<?php } ?>
						</div>

					</td>
					<td><?= !empty($contractInfor->loan_infor->price_property) ? number_format($contractInfor->loan_infor->price_property) : "" ?></td>
					<td><?= !empty($contractInfor->loan_infor->amount_money_max) ? number_format($contractInfor->loan_infor->amount_money_max) : "" ?></td>
				</tr>

				</tbody>
			</table>
		</div>
	</div>
	<div class="col-xs-12">
		<p>
		<h4>Thông tin tiền:</h4>
		</p>

		<div class="table-responsive">
			<table class="table table-bordered table-fixed">
				<thead>
				<tr>
					<th scope="col">Số tiền vay</th>
					<th scope="col">Mục đích vay</th>
					<th scope="col">Thời gian vay</th>
					<th scope="col">Hình thức trả tiền</th>


				</tr>
				</thead>
				<tbody>
				<tr>
					<td><?= !empty($contractInfor->loan_infor->amount_loan) ? number_format($contractInfor->loan_infor->amount_loan) : "" ?></td>
					<td><?= !empty($contractInfor->loan_infor->loan_purpose) ? $contractInfor->loan_infor->loan_purpose : "" ?></td>
					<td><?= !empty($contractInfor->loan_infor->number_day_loan) ? $contractInfor->loan_infor->number_day_loan / 30 . " tháng" : "" ?></td>
					<?php
					$type_interest = !empty($contractInfor->loan_infor->type_interest) ? $contractInfor->loan_infor->type_interest : "";
					if ($type_interest == 1) {
						$type_interest_c = 'Lãi hàng tháng, gốc hàng tháng';
					} elseif ($type_interest == 2) {
						$type_interest_c = 'Lãi hàng tháng, gốc cuối kỳ';
					}
					?>
					<td><?= !empty($type_interest_c) ? $type_interest_c : "" ?></td>
				</tr>

				</tbody>
			</table>
		</div>
	</div>
	<div class="col-xs-12">
		<p>
		<h4>Thông tin bảo hiểm:</h4>
		</p>

		<div class="table-responsive">
			<table class="table table-bordered table-fixed">
				<thead>
				<tr>

					<th scope="col">Bảo hiểm khoản vay</th>
					<th scope="col">Bảo hiểm xe máy</th>
					<th scope="col">Bảo hiểm phúc lộc thọ</th>
					<th scope="col">Bảo hiểm VBI</th>


				</tr>
				</thead>
				<tbody>
				<?php
				$amount_insurrance = 0;
				$type_amount_insurrance = '';
				$number_day_loan = $contractInfor->loan_infor->number_day_loan ? $contractInfor->loan_infor->number_day_loan : 0;
				$amount_money = isset($contractInfor->loan_infor->amount_money) ? $contractInfor->loan_infor->amount_money : 0;
				if (isset($contractInfor->loan_infor->loan_insurance) && $contractInfor->loan_infor->loan_insurance == "1") {
					$amount_insurrance = isset($contractInfor->loan_infor->amount_GIC) ? $contractInfor->loan_infor->amount_GIC : 0;
					$type_amount_insurrance = "GIC";
				} else if (isset($contractInfor->loan_infor->loan_insurance) && $contractInfor->loan_infor->loan_insurance == "2") {
					$amount_insurrance = isset($contractInfor->loan_infor->amount_MIC) ? $contractInfor->loan_infor->amount_MIC : 0;
					$type_amount_insurrance = "MIC";
				}
				if ($type_amount_insurrance == "GIC")
					if (!checkBH($amount_money, $amount_insurrance, "GIC_KV", $number_day_loan)) {
						$message = "Hợp đồng sai số tiền bảo hiểm khoản vay GIC.";
						echo "<script type='text/javascript'>alert('$message');</script>";
					}
				if ($type_amount_insurrance == "MIC")
					if (!checkBH($amount_money, $amount_insurrance, "MIC_KV", $number_day_loan)) {
						$message = "Hợp đồng sai số tiền bảo hiểm khoản vay MIC.";
						echo "<script type='text/javascript'>alert('$message');</script>";
					}
				if (!checkBH($amount_money, $amount_insurrance, "GIC_EASY", $number_day_loan)) {
					$message = "Hợp đồng sai số tiền bảo hiểm xe máy GIC EASY.";
					echo "<script type='text/javascript'>alert('$message');</script>";
				}
				?>
				<tr>

					<td><?= !empty($type_amount_insurrance) ? $type_amount_insurrance : "&nbsp" ?></td>
					<td><?= (!empty($contractInfor->loan_infor->code_GIC_easy) && $contractInfor->loan_infor->code_GIC_easy != "-- Chọn gói bảo hiểm --") ? $contractInfor->loan_infor->code_GIC_easy : "&nbsp" ?></td>
					<td><?= !empty($contractInfor->loan_infor->code_GIC_plt) ? get_code_plt($contractInfor->loan_infor->code_GIC_plt) : "&nbsp" ?></td>
					<td><?= !empty($contractInfor->loan_infor->code_VBI_1) ? $contractInfor->loan_infor->code_VBI_1 : "&nbsp" ?><?= !empty($contractInfor->loan_infor->code_VBI_2) ? ", " . $contractInfor->loan_infor->code_VBI_2 : "&nbsp" ?> </td>

				</tr>
				<tr>
					<td><?= !empty($amount_insurrance) ? number_format($amount_insurrance) : 0 ?></td>
					<td><?= (isset($contractInfor->loan_infor->amount_GIC_easy)) ? number_format($contractInfor->loan_infor->amount_GIC_easy) : "0" ?></td>
					<td><?= !empty($contractInfor->loan_infor->amount_GIC_plt) ? number_format($contractInfor->loan_infor->amount_GIC_plt) : "0" ?></td>
					<td><?= (isset($contractInfor->loan_infor->amount_VBI)) ? number_format($contractInfor->loan_infor->amount_VBI) : 0 ?></td>

				</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-xs-12">
		<p>
		<h4>Thông tin tài sản:</h4>
		</p>

		<?php if (!empty($contractInfor->property_infor)): ?>

			<div class="table-responsive">
				<table class="table table-bordered table-fixed">
					<thead>
					<tr>
						<?php foreach ($contractInfor->property_infor as $item): ?>
							<th scope="col"><?= !empty($item->name) ? $item->name : "" ?></th>
						<?php endforeach; ?>
					</tr>
					</thead>
					<tbody>
					<tr>
						<?php foreach ($contractInfor->property_infor as $item): ?>
							<td><?= !empty($item->value) ? $item->value : "" ?></td>
						<?php endforeach; ?>
					</tr>
					</tbody>
				</table>
			</div>
		<?php endif; ?>

	</div>
</div>


<div class="row">
	<div class="col-xs-12">
		<h3 class="text-danger">
			Thông tin thẩm định
		</h3>
	</div>

	<div class="col-xs-12">
		<p>
		<h4>Thông tin quan hệ tín dụng:</h4>
		</p>

		<div class="table-responsive">
			<table class="table table-bordered table-fixed">
				<thead>
				<tr>
					<th scope="col">Tên tổ chức vay</th>
					<th scope="col">Gốc còn lại</th>
					<th scope="col">Đã tất toán</th>
					<th scope="col">Tiền phải trả hàng kỳ</th>
					<th scope="col">Tiền quá hạn</th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td><?= !empty($contractInfor->expertise_infor->company_name) ? $contractInfor->expertise_infor->company_name : "&nbsp" ?></td>
					<td><?= !empty($contractInfor->expertise_infor->company_debt) ? $contractInfor->expertise_infor->company_debt : "&nbsp" ?></td>
					<td><?= !empty($contractInfor->expertise_infor->company_finalization) ? $contractInfor->expertise_infor->company_finalization : "&nbsp" ?></td>
					<td><?= !empty($contractInfor->expertise_infor->company_borrowing) ? $contractInfor->expertise_infor->company_borrowing : "&nbsp" ?></td>
					<td><?= !empty($contractInfor->expertise_infor->company_out_of_date) ? $contractInfor->expertise_infor->company_out_of_date : "&nbsp" ?></td>

				</tr>

				</tbody>
			</table>
		</div>
	</div>

	<div class="col-xs-12 col-md-6">
		<p>
		<h4>Ghi chú thẩm định:</h4>
		</p>

		<div class="table-responsive">
			<table class="table table-bordered table-fixed">
				<tbody>
				<tr>
					<th>Thẩm định hồ sơ</th>
					<td colspan="2">
						<textarea disabled
								  style="width:100%;border:0"><?= !empty($contractInfor->expertise_infor->expertise_file) ? $contractInfor->expertise_infor->expertise_file : "" ?></textarea>
					</td>
				</tr>
				<tr>
					<th>Thẩm định thực địa</th>
					<td colspan="2">
						<textarea disabled
								  style="width:100%;border:0"><?= !empty($contractInfor->expertise_infor->expertise_field) ? $contractInfor->expertise_infor->expertise_field : "" ?></textarea>
					</td>
				</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div class="col-xs-12 col-md-6">
		<p>
		<h4
				<?php if (empty($contractInfor->expertise_infor->exception1_value[0]) && empty($contractInfor->expertise_infor->exception2_value[0]) && empty($contractInfor->expertise_infor->exception3_value[0]) && empty($contractInfor->expertise_infor->exception4_value[0]) && empty($contractInfor->expertise_infor->exception5_value[0]) && empty($contractInfor->expertise_infor->exception6_value[0]) && empty($contractInfor->expertise_infor->exception7_value[0])): ?> style="display: none" <?php endif; ?>
		>Ngoại lệ hồ sơ:</h4>
		</p>

		<div class="table-responsive">
			<table class="table table-bordered table-fixed">
				<tbody>
				<div id="exception1" <?php if (empty($contractInfor->expertise_infor->exception1_value[0])): ?> style="display: none" <?php endif; ?>>

					<?php
					$value1 = (isset($contractInfor->expertise_infor->exception1_value[0]) && is_array($contractInfor->expertise_infor->exception1_value[0])) ? $contractInfor->expertise_infor->exception1_value[0] : array();
					?>
					<tr <?= (is_array($value1) && in_array("1", $value1)) ? 'selected' : 'hidden' ?>>
						<td>
							E1.1: Ngoại lệ về tuổi vay
						</td>
					</tr>
					<tr <?= (is_array($value1) && in_array("2", $value1)) ? 'selected' : 'hidden' ?>>
						<td>
							E1.2: Ngoại lệ về giấy tờ định danh: CMND/CCCD mờ ảnh / mờ số không
							đủ điều kiện
						</td>
					</tr>

				</div>
				<div id="exception2" <?php if (empty($contractInfor->expertise_infor->exception2_value[0])): ?> style="display: none" <?php endif; ?>>

					<?php
					$value2 = (isset($contractInfor->expertise_infor->exception2_value[0]) && is_array($contractInfor->expertise_infor->exception2_value[0])) ? $contractInfor->expertise_infor->exception2_value[0] : array();
					?>

					<tr <?= (is_array($value2) && in_array("3", $value2)) ? 'selected' : 'hidden' ?>>
						<td>
							E2.1: Khách hàng KT3 tạm trú dưới 6 tháng
						</td>
					</tr>
					<tr <?= (is_array($value2) && in_array("4", $value2)) ? 'selected' : 'hidden' ?>>
						<td>
							E2.2: Khách hàng KT3 không có hợp đồng thuê nhà, sổ tạm trú, xác
							minh qua chủ nhà trọ
						</td>
					</tr>

				</div>
				<div id="exception3" <?php if (empty($contractInfor->expertise_infor->exception3_value[0])): ?> style="display: none" <?php endif; ?>>
					<?php
					$value3 = (isset($contractInfor->expertise_infor->exception3_value[0]) && is_array($contractInfor->expertise_infor->exception3_value[0])) ? $contractInfor->expertise_infor->exception3_value[0] : array();
					?>
					<tr <?= (is_array($value3) && in_array("5", $value3)) ? 'selected' : 'hidden' ?>>
						<td>
							E3.1: Khách hàng thiếu một trong những chứng từ chứng minh thu nhập
						</td>
					</tr>
				</div>
				<div id="exception4" <?php if (empty($contractInfor->expertise_infor->exception4_value[0])): ?> style="display: none" <?php endif; ?>>

					<?php
					$value4 = (isset($contractInfor->expertise_infor->exception4_value[0]) && is_array($contractInfor->expertise_infor->exception4_value[0])) ? $contractInfor->expertise_infor->exception4_value[0] : array();
					?>
					<tr <?= (is_array($value4) && in_array("6", $value4)) ? 'selected' : 'hidden' ?>>
						<td>
							E4.1: Ngoại lệ về TSĐB khác TSĐB trong quy định về SP hiện hành của
							công ty (đất, giấy tờ khác...)
						</td>
					</tr>
					<tr <?= (is_array($value4) && in_array("7", $value4)) ? 'selected' : 'hidden' ?>>
						<td>
							E4.2: Ngoại lệ về lãi suất sản phẩm
						</td>
					</tr>

				</div>
				<div id="exception5" <?php if (empty($contractInfor->expertise_infor->exception5_value[0])): ?> style="display: none" <?php endif; ?>>

					<?php
					$value5 = (isset($contractInfor->expertise_infor->exception5_value[0]) && is_array($contractInfor->expertise_infor->exception5_value[0])) ? $contractInfor->expertise_infor->exception5_value[0] : array();
					?>
					<tr <?= (is_array($value5) && in_array("8", $value5)) ? 'selected' : 'hidden' ?>>
						<td>
							E5.1: Ngoại lệ về điều kiện đối với người tham chiếu
						</td>
					</tr>
					<tr <?= (is_array($value5) && in_array("9", $value5)) ? 'selected' : 'hidden' ?>>
						<td>
							E5.2: Ngoại lệ PGD gọi điện cho tham chiếu không sử dụng hệ thống
							phonet
						</td>
					</tr>
				</div>
				<div id="exception6" <?php if (empty($contractInfor->expertise_infor->exception6_value[0])): ?> style="display: none" <?php endif; ?>>

					<?php
					$value6 = (isset($contractInfor->expertise_infor->exception6_value[0]) && is_array($contractInfor->expertise_infor->exception6_value[0])) ? $contractInfor->expertise_infor->exception6_value[0] : array();
					?>
					<tr <?= (is_array($value6) && in_array("10", $value6)) ? 'selected' : 'hidden' ?>>
						<td>
							E6.1: KH có nhiều hơn 3 KV ở các app hay tổ chức tín dụng, ngân hàng
							khác
						</td>
					</tr>
				</div>
				<div id="exception7" <?php if (empty($contractInfor->expertise_infor->exception7_value[0])): ?> style="display: none" <?php endif; ?>>

					<?php
					$value7 = (isset($contractInfor->expertise_infor->exception7_value[0]) && is_array($contractInfor->expertise_infor->exception7_value[0])) ? $contractInfor->expertise_infor->exception7_value[0] : array();
					?>
					<tr <?= (is_array($value7) && in_array("11", $value7)) ? 'selected' : "hidden" ?>>
						<td>
							E7.1: Khách hàng vay lại có lịch sử trả tiền tốt
						</td>
					</tr>
					<tr <?= (is_array($value7) && in_array("12", $value7)) ? 'selected' : "hidden" ?>>
						<td>
							E7.2: Thu nhập cao, gốc còn lại tại thời điểm hiện tại thấp
						</td>
					</tr>
					<tr <?= (is_array($value7) && in_array("13", $value7)) ? 'selected' : "hidden" ?>>
						<td>
							E7.3: KH làm việc tại các công ty là đối tác chiến lược
						</td>
					</tr>
					<tr <?= (is_array($value7) && in_array("14", $value7)) ? 'selected' : "hidden" ?>>
						<td>
							E7.4: Giá trị định giá tài sản cao
						</td>
					</tr>
				</div>
				</tbody>
			</table>
		</div>
	</div>
</div>

<hr class="mt-0">

<div class="row">

	<div class="col-xs-12 text-right">

		<?php
		$printed_detail = "";
		$contract_id = !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "";
		$type_property_code = strtoupper(trim($contractInfor->loan_infor->type_property->code));
		if ($contractInfor->loan_infor->type_property->code == "TC") {
			$printed_detail .= '<a  href="javascript:void(0)" onclick="show_popup_print_contract_mortgage(this)" data-id="' . $contract_id . '" class="btn btn-info"> Print</a>';
		} elseif ($contractInfor->loan_infor->type_loan->code == "CC" && $contractInfor->loan_infor->type_property->code != "TC") {
			$printed_detail .= '<a href="javascript:void(0)" onclick="show_popup_print_contract_pledge(this)" data-type_property_code="' . $type_property_code . '" data-id="' . $contract_id . '"  class="btn btn-info">Print</a>';
		} elseif ($contractInfor->loan_infor->type_loan->code == "DKX" && $contractInfor->loan_infor->type_property->code != "TC") {
			$printed_detail .= '<a href="javascript:void(0)" onclick="show_popup_print_contract_loan(this)" data-type_property_code="' . $type_property_code . '" data-id="' . $contract_id . '" class=" btn btn-info">Print</a>';
		}
		?>
		<?php
		if (in_array('giao-dich-vien', $groupRoles)) {
			?>
			<?php
			if (in_array($contractInfor->status, array(1, 4))
					&& in_array("5dedd24f68a3ff3100003649", $userRoles->role_access_rights)) { ?>
				<a href="javascript:void(0)"
				   onclick="gui_cht_duyet(this)"
				   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : '' ?>"
				   class="btn btn-primary gui_cht_duyet">
					Gửi duyệt</a>
			<?php } ?>

			<?php
			if (in_array($contractInfor->status, array(1, 4, 6, 7, 8)) && in_array("5db6b8c9d6612bceeb712375", $userRoles->role_access_rights)) { ?>
				<a href="javascript:void(0)"
				   onclick="huy_hop_dong(this)"
				   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : ""; ?>"
				   class="btn btn-danger huy_hop_dong">Hủy hợp
					đồng</a>
			<?php } ?>

			<?php
			if (in_array($contractInfor->status, array(6, 7))
					&& in_array("5dedd32468a3ff310000364d", $userRoles->role_access_rights)) { ?>
				<a href="javascript:void(0)"
				   onclick="yeu_cau_giai_ngan(this)"
				   data-codecontract="<?= !empty($contractInfor->code_contract_disbursement) ? $contractInfor->code_contract_disbursement : '' ?>"
				   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : '' ?>"
				   class="btn btn-primary yeu_cau_giai_ngan"> Yêu
					cầu giải ngân</a>
			<?php } ?>


			<?php
			if (in_array($contractInfor->status, array(17)) && $contractInfor->loan_infor->type_loan == "CC") { ?>
				<a href="<?php echo base_url("pawn/uploadsImageAccuracy?id=") . $contractInfor->_id->{'$oid'} ?>"
				   class="btn btn-primary">
					<?= $this->lang->line('Upload_documents') ?></a>
			<?php } ?>

			<?php
			if (in_array($contractInfor->status, array(1, 4, 6, 7, 8, 17))
					&& in_array("5def400868a3ff1204003ad9", $userRoles->role_access_rights)) { ?>
				<a href="<?php echo base_url("pawn/uploadsImageAccuracy?id=") . $contractInfor->_id->{'$oid'} ?>"
				   class="btn btn-primary">
					<?= $this->lang->line('Upload_documents') ?></a>
			<?php } ?>

			<?php
			if (!in_array($contractInfor->status, array(0))
					&& in_array("5def401068a3ff1204003ada", $userRoles->role_access_rights)) { ?>
				<?= $printed_detail ?>
			<?php } ?>


		<?php } ?>


		<?php
		if (in_array('cua-hang-truong', $groupRoles)) {
			?>
			<?php
			if (in_array($contractInfor->status, array(2, 8))
					&& in_array("5dedd2d868a3ff310000364b", $userRoles->role_access_rights)) { ?>
				<a href="javascript:void(0)"
				   onclick="chuyen_hoi_so(this)"
				   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>"
				   class="btn btn-primary chuyen_hoi_so">Gửi duyệt</a>
			<?php } ?>

			<?php
			if (in_array($contractInfor->status, array(2))
					&& in_array("5dedd2c868a3ff310000364a", $userRoles->role_access_rights)) { ?>
				<a href="javascript:void(0)"
				   onclick="cht_tu_choi(this)"
				   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>"
				   class="btn btn-warning cht_tu_choi"> Không
					duyệt</a>
			<?php } ?>

			<?php
			if (in_array($contractInfor->status, array(1, 2, 4, 6, 7, 8))
					&& in_array("5db6b8c9d6612bceeb712375", $userRoles->role_access_rights)) { ?>
				<a href="javascript:void(0)"
				   onclick="huy_hop_dong(this)"
				   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>"
				   class="btn btn-danger huy_hop_dong">Hủy hợp
					đồng</a>
			<?php } ?>

			<?php
			if (!in_array($contractInfor->status, array(0))
					&& in_array("5def401068a3ff1204003ada", $userRoles->role_access_rights)) { ?>
				<?= $printed_detail ?>
			<?php } ?>
		<?php } ?>

		<?php
		if ((in_array('hoi-so', $groupRoles)) || (in_array('hoi-so', $groupRoles) && ($contractInfor->loan_infor->amount_loan < 50000000) && ($contractInfor->loan_infor->type_property->code == "OTO")) || (in_array('hoi-so', $groupRoles) && ($contractInfor->loan_infor->amount_loan < 50000000) && ($contractInfor->loan_infor->type_property->code == "XM") && ($contractInfor->loan_infor->type_loan->code == "DKX"))) {
			?>


		<?php } ?>


		<?php
		if (in_array('ke-toan', $groupRoles)) {
			?>

			<?php if (in_array('tpb-ke-toan', $groupRoles)) { ?>
				<a href="javascript:void(0)"
				   onclick="capnhatmahopdong(this)"
				   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>"
				   data-code="<?= !empty($contractInfor->code_contract) ? $contractInfor->code_contract : "" ?>"
				   class="btn btn-primary duyet"> Sửa mã hợp
					đồng </a>

				<a href="<?php echo base_url("pawn/uploadsImageAccuracy?id=") . $contractInfor->_id->{'$oid'} ?>"
				   class="btn btn-primary">
					Sửa chứng từ</a>
			<?php } ?>


			<?php
			if (in_array($contractInfor->status, array(17))
					&& in_array("5def400868a3ff1204003ad9", $userRoles->role_access_rights)) { ?>
				<a href="<?php echo base_url("pawn/accountantUpload?id=") . $contractInfor->_id->{'$oid'} ?>"
				   class="btn btn-primary">
					<?= $this->lang->line('Upload_documents') ?></a>
			<?php } ?>
			<?php
			if (in_array($contractInfor->status, array(17))) { ?>
				<?php if ($contractInfor->loan_infor->amount_money > 300000000) { ?>
					<a href="<?php echo base_url("pawn/disbursement_nl_max/") ?><?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>"
					   class="btn btn-primary"> Xử lý lỗi giải
						ngân max</a>
				<?php }
			} ?>
			<?php
			if (in_array($contractInfor->status, array(15, 10))
					&& in_array("5def15a268a3ff1204003ad6", $userRoles->role_access_rights)) { ?>

				<a href="<?php echo base_url("pawn/disbursement/") ?><?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>"
				   class="btn btn-primary"> Giải ngân</a>
				<?php if ($contractInfor->loan_infor->amount_money <= 300000000) { ?>

					<a href="<?php echo base_url("pawn/disbursement_nl/") ?><?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>"
					   class="btn btn-primary"> Giải ngân ngân lượng</a>

				<?php } ?>
				<?php if ($contractInfor->loan_infor->amount_money > 300000000) { ?>

					<a href="<?php echo base_url("pawn/disbursement_nl_max/") ?><?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>"
					   class="btn btn-primary"> Giải ngân ngân lượng > 300tr</a>
				<?php }
			} ?>

			<?php

			if (in_array($contractInfor->status, array(15, 10))
					&& in_array("5def401b68a3ff1204003adb", $userRoles->role_access_rights)) { ?>
				<a href="javascript:void(0)"
				   onclick="ketoan_tu_choi(this)"
				   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>"
				   class="btn btn-warning ketoan_tu_choi"> Không duyệt</a>
			<?php } ?>

			<?php
			if (in_array($contractInfor->status, array(15, 10))
					&& in_array("5db6b8c9d6612bceeb712375", $userRoles->role_access_rights)) { ?>
				<a href="javascript:void(0)"
				   onclick="huy_hop_dong(this)"
				   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>"
				   class="btn btn-warning huy_hop_dong">Hủy hợp đồng</a>
			<?php } ?>

			<?php
			if (!in_array($contractInfor->status, array(0))
					&& in_array("5def401068a3ff1204003ada", $userRoles->role_access_rights)) { ?>
				<?= $printed_detail ?>
			<?php } ?>
		<?php } ?>
		<?php

		?>
		<?php
		if ($userSession['is_superadmin'] == 1 || in_array('van-hanh', $groupRoles)) { ?>

			<?php
			if (in_array($contractInfor->status, array(1, 4))) { ?>
				<a href="javascript:void(0)"
				   onclick="gui_cht_duyet(this)"
				   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>"
				   class="btn btn-primary gui_cht_duyet">
					Gửi duyệt</a>
			<?php } ?>


			<?php
			if (in_array($contractInfor->status, array(2, 8))) { ?>
				<a href="javascript:void(0)"
				   onclick="chuyen_hoi_so(this)"
				   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>"
				   class="btn btn-primary chuyen_hoi_so">Gửi duyệt</a>
			<?php } ?>

			<?php
			if (in_array($contractInfor->status, array(1, 2, 4, 6, 7, 8))) { ?>
				<a href="javascript:void(0)"
				   onclick="huy_hop_dong(this)"
				   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>"
				   class="btn btn-danger huy_hop_dong">Hủy hợp
					đồng</a>
			<?php } ?>

			<?php
			if (in_array($contractInfor->status, array(2))) { ?>
				<a href="javascript:void(0)"
				   onclick="cht_tu_choi(this)"
				   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>"
				   class="btn btn-warning cht_tu_choi"> Không
					duyệt</a>
			<?php } ?>

			<?php
			if (in_array($contractInfor->status, array(1, 4, 6, 7, 8))) { ?>
				<a href="javascript:void(0)"
				   onclick="huy_hop_dong(this)"
				   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : ""; ?>"
				   class="btn btn-danger huy_hop_dong">Hủy hợp
					đồng</a>
			<?php } ?>

			<?php
			if (in_array($contractInfor->status, array(6, 7))) { ?>
				<a href="javascript:void(0)"
				   onclick="yeu_cau_giai_ngan(this)"
				   data-codecontract="<?= !empty($contractInfor->code_contract_disbursement) ? $contractInfor->code_contract_disbursement : '' ?>"
				   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : '' ?>"
				   class="btn btn-primary yeu_cau_giai_ngan"> Yêu
					cầu giải ngân</a>
			<?php } ?>

			<?php
			if (!in_array($contractInfor->status, array(0))) { ?>
				<?= $printed_detail ?>
			<?php } ?>


		<?php } ?>


		<!--		<button type="button" name="button" class="btn btn-primary"-->
		<!--				data-toggle="modal" data-target="#quanlyduyetModal">-->
		<!--			Duyệt-->
		<!--		</button>-->
		<!--		<button type="button" name="button" class="btn btn-link">-->
		<!--			Bảng lãi kỳ-->
		<!--		</button>-->

		<a href="javascript:void(0)" class="btn btn-warning showModal"
		   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>">
			Xem lịch sử
		</a>

		<a href="javascript:void(0)"
		   onclick="edit_fee(this)"
		   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : '' ?>"
		   class="btn btn-primary yeu_cau_giai_ngan"> Xem Phí
			Thực Tính</a>

		<!--		<button type="button" name="button" class="btn btn-danger">-->
		<!--			Hủy-->
		<!--		</button>-->

		<button type="button" name="button" class="btn" onclick="$('.quanlytaisan_detail').addClass('d-none')">
			Đóng
		</button>
	</div>
</div>


<!--Modal-->


<script>
	function appraise_property_XM(thiz) {
		console.log('xxxx');
		var percent_type_loan = $("#percent_type_loan").val();
		var percent_property = $(thiz).val();
		var price_goc = getFloat($("input[name='price_goc']").val().replace(/,/g, ""));

		if (percent_property == 0) {
			console.log('xxxx_1');
			var priceProperty = price_goc;
		} else {
			console.log('xxxx_2');
			var priceProperty = price_goc - (parseInt(price_goc) * percent_property / 100);
		}

		console.log(percent_type_loan);
		$("input[name='price_property']").val(numeral(priceProperty).format('0,0'));
		var price = parseInt(priceProperty) * parseInt(percent_type_loan) / 100;

		var loan_product_result = $('#loan_product').val();

		if (loan_product_result == 14) {
			console.log("result");
			var price_kdol = priceProperty * 0.8;
			$("input[name='amount_money']").val(numeral(price_kdol).format('0,0'));
			return;
		}
		$("input[name='amount_money']").val(numeral(price).format('0,0'));
	}

	function appraise_property(thiz) {
		var percent_type_loan = $("#percent_type_loan").val();
		var check = $(thiz).is(":checked");
		var price_depreciations = $(thiz).val();
		var price_property = getFloat($("input[name='price_property']").val().replace(/,/g, ""));
		if (price_property == 0) return;
		if (check == true) {
			var priceProperty = parseInt(price_property) - parseInt(price_depreciations);
		} else {
			var priceProperty = parseInt(price_property) + parseInt(price_depreciations);
		}
		$("input[name='price_property']").val(numeral(priceProperty).format('0,0'));
		var price = parseInt(priceProperty) * parseInt(percent_type_loan) / 100;


		var loan_product_result = $('#loan_product').val();
		if (loan_product_result == 14) {
			var price_kdol = priceProperty * 0.8;
			$("input[name='amount_money']").val(numeral(price_kdol).format('0,0'));
			return;
		}

		$("input[name='amount_money']").val(numeral(price).format('0,0'));
	}
</script>

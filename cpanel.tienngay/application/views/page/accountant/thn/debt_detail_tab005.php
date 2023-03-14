<?php
date_default_timezone_set('UTC');
$du_no_con_lai_tt = 0;
$tien_lai_tt = 0;
$tien_phi_tt = 0;
$tong_tien_thanh_toan_tt = 0;
$phi_phat_cham_tra_tt = 0;
$tong_penalty_con_lai = 0;
$tien_giam_tru = 0;
$lai_suat_tru_vao_ky_cuoi = 0;
$tong_tien_tat_toan_sau_giam_tru = 0;
$du_no_con_lai_tt = !empty($dataTatToanPart1->du_no_con_lai) ? $dataTatToanPart1->du_no_con_lai : 0;
$tien_lai_tt = !empty($dataTatToanPart1->lai_chua_tra_den_thoi_diem_hien_tai) ? $dataTatToanPart1->lai_chua_tra_den_thoi_diem_hien_tai : 0;
$tien_phi_tt = !empty($dataTatToanPart1->phi_chua_tra_den_thoi_diem_hien_tai) ? $dataTatToanPart1->phi_chua_tra_den_thoi_diem_hien_tai : 0;
$phi_phat_sinh_tt = !empty($contractDB->phi_phat_sinh) ? $contractDB->phi_phat_sinh : 0;
$phi_phat_tat_toan_truoc_han = !empty($debtData->phi_thanh_toan_truoc_han) ? $debtData->phi_thanh_toan_truoc_han : 0;
$tong_penalty_con_lai = !empty($contractDB->tong_penalty_con_lai) ? $contractDB->tong_penalty_con_lai : 0;
$tien_du_ky_truoc = !empty($contractDB->tien_du_ky_truoc) ? $contractDB->tien_du_ky_truoc : 0;
$phi_phat_cham_tra_tt = !empty($contractDB->penalty_pay) ? $contractDB->penalty_pay : 0;
$tien_chua_tra_ky_thanh_toan = !empty($contractDB->tien_chua_tra_ky_thanh_toan) ? $contractDB->tien_chua_tra_ky_thanh_toan : 0;
$tien_thua_thanh_toan = !empty($contractDB->tien_thua_thanh_toan) ? $contractDB->tien_thua_thanh_toan : 0;
$tien_giam_tru_bhkv = !empty($contractDB->tien_giam_tru_bhkv) ? $contractDB->tien_giam_tru_bhkv : 0;
$tong_so_tien_thieu = !empty($contractDB->tong_so_tien_thieu) ? $contractDB->tong_so_tien_thieu : 0;
$tong_tien_thanh_toan_tt = $du_no_con_lai_tt + $phi_phat_cham_tra_tt + $phi_phat_tat_toan_truoc_han + $phi_phat_sinh_tt + $tien_chua_tra_ky_thanh_toan - $tien_du_ky_truoc - $tien_thua_thanh_toan + $tong_so_tien_thieu;
if ($contractDB->status == 19) {
	$tong_tien_thanh_toan_tt = 0;
}
if ($reduced_profit > 0) {
	$lai_suat_tru_vao_ky_cuoi = $reduced_profit;
}

$type_payment_exem = !empty($exemption_contract->type_payment_exem) ? $exemption_contract->type_payment_exem : 1;
if (($issetTransactionDiscount == false) && !empty($exemption_contract->status) && ($exemption_contract->status == 7 || $exemption_contract->status == 5) && ($exemption_contract->status != 6) && ($type_payment_exem == 2)) {
	$tien_giam_tru = !empty($exemption_contract->amount_tp_thn_suggest) ? $exemption_contract->amount_tp_thn_suggest : 0;
}
$tong_tien_tat_toan_sau_giam_tru = $tong_tien_thanh_toan_tt - $tien_giam_tru - $tien_giam_tru_bhkv - $lai_suat_tru_vao_ky_cuoi;


?>
<div class="row flex" style="justify-content: center;">
	<div class="col-xs-12  col-md-6">
		<table class="table table-borderless">
			<tbody>
			<tr>
				<th>Người tất toán:</th>
				<td class="text-right">
					<div class="form-group">
						<input type="text" class="form-control input-sm payment_name_finish" name="payment_name_finish"
							   id="event_fill_exemption_payment_finish">
					</div>

				</td>
			</tr>
			<tr>
				<th>Quan hệ với chủ hợp đồng:</th>
				<td class="text-right">
					<div class="form-group">
						<input type="text" class="form-control input-sm relative_with_contract_owner_finish"
							   name="relative_with_contract_owner_finish">
					</div>

				</td>
			</tr>
			<tr>
				<th>Ngày thực tế:</th>
				<td class="text-right"><?php echo date('d/m/Y', $contractDB->date_pay) ?></td>
			</tr>
			<tr>
				<th>Ngày khách hàng tất toán:</th>
				<td class="text-right">
					<input type="date" class="form-control input-sm" id='date_pay_finish'
						   value="<?php echo date('Y-m-d', $contractDB->date_pay) ?>">
				</td>
			</tr>
			<tr>
				<th>Số ngày chênh lệch thực tế và tất toán:</th>
				<td class="text-right"><p
							class="difference_day_payment_finish"><?php echo !empty($contractDB->difference_day_payment) ? $contractDB->difference_day_payment : '0' ?></p>
				</td>
			</tr>
			<tr>
				<th>Phí khấu trừ</th>
				<td class="text-right">
					<div class="form-group">
						<input type="text" class="form-control input-sm reduced_fee_finish" name="reduced_fee_finish"
							   placeholder="Phí ngân hàng" disabled>
					</div>
					<?php
					$type_payment_exem = !empty($exemption_contract->type_payment_exem) ? $exemption_contract->type_payment_exem : 1;
					if (($issetTransactionDiscount == false) && !empty($exemption_contract->status) && ($exemption_contract->status == 7 || $exemption_contract->status == 5) && ($exemption_contract->status != 6) && ($type_payment_exem == 2)) { ?>
						<div class="form-group">
							<input type="text" class="form-control input-sm discounted_fee_finish"
								   name="discounted_fee_finish"
								   value="<?= !empty($exemption_contract->amount_tp_thn_suggest) ? number_format($exemption_contract->amount_tp_thn_suggest) : 0; ?>"
								   placeholder="Phí giảm trừ" disabled>
							<input type="hidden" id="id_exemption_finish" name="id_exemption_finish" value="<?= !empty($exemption_contract->_id->{'$oid'}) ? $exemption_contract->_id->{'$oid'} : '' ?>">
						</div>
					<?php } else { ?>
						<div class="form-group">
							<input type="text" class="form-control input-sm discounted_fee_finish"
								   name="discounted_fee_finish" value="0" placeholder="Phí giảm trừ" disabled>
						</div>
					<?php } ?>
					<div class="form-group">
						<input type="text" class="form-control input-sm other_fee_finish" name="other_fee_finish"
							   value="<?= !empty($tien_giam_tru_bhkv) ? number_format($tien_giam_tru_bhkv) : 0; ?>"
							   placeholder="Phí khác" disabled>
					</div>
				</td>
			</tr>
			<tr>
				<th>Tổng tiền khẩu trừ:</th>
				<td class="text-right"><p
							id="total_deductible_finish"><?= !empty($tien_giam_tru_bhkv) ? number_format($tien_giam_tru_bhkv) : ''; ?></p>
				</td>
			</tr>
			<tr>
				<th>Tiền lãi:</th>
				<td class="text-right"><p
							id="interest_finish"><?php echo !empty($tien_lai_tt) ? number_format($tien_lai_tt) : '0' ?></p>
				</td>
			</tr>
			<tr>
				<th>Tiền hợp lệ tất toán:</th>
				<td class="text-right"><p
							class="valid_amount_payment_finish text-danger"><?php echo !empty($tong_tien_tat_toan_sau_giam_tru) ? number_format($tong_tien_tat_toan_sau_giam_tru) : '0' ?></p>
				</td>

			</tr>
			<tr>
				<th>Tiền khách hàng tất toán:</th>
				<td class="text-right">
					<div class="form-group">
						<input type="text" class="form-control input-sm payment_amount_finish"
							   name="payment_amount_finish">
					</div>

				</td>
			</tr>


			</tbody>
		</table>

	</div>

	<div class="col-xs-12  col-md-6">
		<table class="table table-borderless">
			<tbody>
			<tr>
				<th>Số điện thoại người tất toán:</th>
				<td class="text-right">
					<input type="number" name="payment_phone_finish" class="form-control input-sm"
						   id='payment_phone_finish' value="">
				</td>
			</tr>
			<tr>
				<th>Tổng tiền tất toán ngày thực tế:</th>
				<td class="text-right"><p
							class="total_money_paid_now_finish"><?php echo !empty($tong_tien_thanh_toan_tt) ? number_format($tong_tien_thanh_toan_tt) : '0' ?></p>
				</td>
			</tr>
			<tr>
				<th>Tổng tiền đến ngày tất toán:</th>
				<td class="text-right "><p
							class="total_money_paid_finish text-danger"><?php echo !empty($tong_tien_thanh_toan_tt) ? number_format($tong_tien_thanh_toan_tt) : '0' ?></p>
				</td>
			</tr>
			<tr>
				<th>Tiền chênh lệch thực tế và tất toán:</th>
				<td class="text-right"><p
							class="actual_difference_payment_finish"><?php echo !empty($contractDB->actual_difference_payment) ? number_format($contractDB->actual_difference_payment) : '0' ?></p>
				</td>
			</tr>
			<!-- <tr>
		  <th>Dư  còn lại:</th>

			<td class="text-right"> -->
			<input type="hidden"
				   id="balance_finish" <?php echo !empty($du_no_con_lai_tt) ? number_format($du_no_con_lai_tt) : '0' ?> >
			<!-- </td> -->
			<!-- </tr> -->

			<tr>
				<th>Phí tất toán trước hạn:</th>

				<td class="text-right"><p
							id="phi_phat_tat_toan_truoc_han_finish"><?php echo !empty($phi_phat_tat_toan_truoc_han) ? number_format($phi_phat_tat_toan_truoc_han) : '0' ?></p>
				</td>
			</tr>

			<tr>
				<th>Tiền phạt chậm trả:</th>
				<td class="text-right"><p
							id="penalty_pay_finish"><?php echo !empty($phi_phat_cham_tra_tt) ? number_format($phi_phat_cham_tra_tt) : '0' ?></p>
				</td>
			</tr>

			<tr>
				<th>Tiền quá hạn:</th>
				<td class="text-right"><p
							id="tien_qua_han_finish"><?php echo !empty($phi_phat_sinh_tt) ? number_format($phi_phat_sinh_tt) : '0' ?></p>
				</td>
			</tr>
			<tr>

			<tr>
				<th>Tiền phí:</th>
				<td class="text-right"><p
							id="fee_finish"><?php echo !empty($tien_phi_tt) ? number_format($tien_phi_tt) : '0' ?></p>
				</td>
			</tr>
			<tr>
				<th>Phương thức:</th>
				<td class="text-right">

					<input class="form-check-input" type="radio" name="payment_method_finish" value="1" checked>
					<label class="form-check-label" for="moneyoption_cast">
						Tiền mặt
					</label>

					<input class="form-check-input" type="radio" name="payment_method_finish" value="2">
					<label class="form-check-label" for="moneyoption_banktransfer">
						Chuyển khoản
					</label>

				</td>
			</tr>
			<tr>
				<th>Phòng giao dịch:</th>
				<td class="text-right">
					<select class="form-control" id="stores_finish">
						<?php
						$userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
						$stores = !empty($userInfo['stores']) ? $userInfo['stores'] : array();
						foreach ($stores as $key => $value) {
							?>
							<option value="<?= !empty($value->store_id) ? $value->store_id : "" ?>"
									selected><?= !empty($value->store_name) ? $value->store_name : "" ?></option>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<th>Nội dung thu:</th>
				<td>
					<select id="payment_note_finish" name="payment_note_finish[]" class="form-control"
							multiple="multiple" data-placeholder="Chọn nội dung thu tiền">
						<?php
						$value_full = 2;
						$value_part = 27;
						$value_slow = 52;
						?>
						<!--1.-->
						<option value="1">Thanh toán kỳ hợp đồng</option>
						<!--1.1-->
						<option value="2" data-parent="1">Thanh toán đủ kỳ</option>
						<?php if (!empty($contractData)) {
							foreach ($contractData as $key_contract => $contract) {
								?>
								<!--1.1.1-->
								<option value="<?= ++$value_full; ?>" data-parent="2">Thanh toán đủ
									kỳ <?= ($key_contract + 1); ?></option>
							<?php } ?>
							<!--1.2-->
							<option value="27" data-parent="1">Thanh toán một phần kỳ</option>
							<?php
							foreach ($contractData as $key_contract => $contract) { ?>
								<!--1.2.1-->
								<option value="<?= ++$value_part; ?>" data-parent="27">Thanh toán một phần
									kỳ <?= ($key_contract + 1); ?></option>
							<?php } ?>
							<!--2.-->
							<option value="52">Phí phạt chậm trả</option>
							<?php
							foreach ($contractData as $key_contract => $contract) { ?>
								<option value="<?= ++$value_slow; ?>" data-parent="52">Phí phạt chậm trả
									kỳ <?= ($key_contract + 1); ?></option>
							<?php }
						} ?>
						<!--3.-->
						<option value="77">Phí gia hạn</option>
						<!--4.-->
						<option value="78">Tất toán hợp đồng</option>
						<!--5.-->
						<option value="79">Phí cơ cấu</option>
					</select>
				</td>
			</tr>
			</tbody>
		</table>
	</div>

	<input type="hidden" class="form-control input-sm" name="penalty_pay_finish">
	<input type="hidden" class="form-control input-sm" name="penalty_now_finish"
		   value="<?php echo !empty($contractDB->penalty_now) ? $contractDB->penalty_now : '' ?>">
	<input type="hidden" class="form-control input-sm"
		   value="<?php echo !empty($contractDB->code_contract) ? $contractDB->code_contract : '' ?>"
		   name="code_contract_finish">
	<div class="col-xs-12 text-right">


		<?php
		if (($countGiaoDichTatToanChoDuyet == 0 && $contractDB->status != 19) && (strtotime(date('Y-m-d') . ' 23:59:59') > $contractDB->disbursement_date)) {
			?>
			<button id="confirm_finish_contract" class="btn btn-success" style="min-width: 125px">XÁC NHẬN TẤT TOÁN
			</button>
		<?php } else if ($countGiaoDichTatToanChoDuyet > 0) { ?>
			<div class="alert alert-warning center" role="alert">
				<h4> Đã tồn tại tất toán! Click vào <span class="text-danger"><a
								href="<?php echo base_url('transaction?tab=all&code_contract_disbursement=' . $contractDB->code_contract_disbursement) ?>"
								class="text-info" target="_blank">ĐÂY</a> </span> để đi tới phiếu thu, chọn Chức năng >>
					Gửi duyệt và báo bộ phận kế toán Duyệt hoặc Hủy tất toán</h4>
			</div>
		<?php } else if ($contractDB->status == 19) { ?>
			<div class="alert alert-warning center" role="alert">
				<h4> Đã tất toán</h4>
			</div>
		<?php } else if (strtotime(date('Y-m-d') . ' 23:59:59') <= $contractDB->disbursement_date) { ?>
			<div class="alert alert-warning center" role="alert">
				<h4> Chưa đến kỳ thanh toán</h4>
			</div>
		<?php } ?>
	</div>
</div>

<script type="text/javascript">
	function in_array(needle, haystack) {
		let length = haystack.length;
		for (let i = 0; i < length; i++) {
			if (haystack[i] == needle) {
				return true;
			}
		}
		return false;
	}

	$(function () {
		var dtToday = new Date();
		var month = dtToday.getMonth() + 1;
		var day = dtToday.getDate();
		var year = dtToday.getFullYear();
		if (day < 10) {
			day = '0' + day
		}
		if (month < 10) {
			month = '0' + month
		}
		var maxDate = year + '-' + month + '-' + day;
		if (!in_array('thu-hoi-no', role_thn_view_date_pay)) {
			$('#date_pay_finish').attr('max', maxDate);
		}
	});
	//$(document).ready(function() {
	$('#date_pay_finish').change(function () {
		var date_pay = $(this).val();
		var id_contract = $("#id_contract").val();

		var formData = {
			date_pay: date_pay,
			id_contract: id_contract
		};

		$.ajax({
			url: _url.base_url + 'accountant/check_date_pay_finish',
			type: "POST",
			data: formData,
			dataType: 'json',
			beforeSend: function () {
				$("#loading").show();
			},
			success: function (data) {
				$("#loading").hide();
				if (data.status == 200) {
					console.log(data);
					$(".reduced_fee_finish").val('0');

					var tien_giam_tru = getFloat_pay($(".discounted_fee_finish").val());
					var total_money_paid_now = parseInt($(".total_money_paid_now_finish").text().split(',').join(''));
					var du_no_con_lai = Math.round(data.data.dataTatToanPart1.du_no_con_lai);
					var tien_lai = Math.round(data.data.dataTatToanPart1.lai_chua_tra_den_thoi_diem_hien_tai);
					var tien_phi = Math.round(data.data.dataTatToanPart1.phi_chua_tra_den_thoi_diem_hien_tai);
					var da_thanhtoan = Math.round(data.data.contract.total_paid);
					var total_money_paid = Math.round(data.data.contract.total_money_paid);
					var tien_du_ky_truoc = Math.round(data.data.contract.tien_du_ky_truoc);
					var tien_thua_thanh_toan = Math.round(data.data.contract.tien_thua_thanh_toan);
					var tien_chua_tra_ky_thanh_toan = Math.round(data.data.contract.tien_chua_tra_ky_thanh_toan);
					var tien_giam_tru_bhkv = Math.round(data.data.contract.tien_giam_tru_bhkv);
					var lai_suat_tru_vao_ky_cuoi = 0;
					lai_suat_tru_vao_ky_cuoi = Math.round(data.data.reduced_profit_cal);
					var tong_so_tien_thieu = Math.round(data.data.contract.tong_so_tien_thieu);
					var phi_phat_tat_toan_truoc_han = Math.round(data.data.debtData.phi_thanh_toan_truoc_han);
					if (data.data.contract.status != 19)
						var phi_phat_cham_tra = Math.round(data.data.contract.penalty_pay);
					var phi_phat_sinh = Math.round(data.data.contract.phi_phat_sinh);
					var tong_tien_tat_toan = 0;
					var tong_tien_tat_toan_sau_giam_tru = 0;
					var newDate = new Date(date_pay);
					var date_pay_js = newDate.getTime();
					var ngay_ket_thuc_js = <?=strtotime(date('Y-m-d', $contractDB->ngay_ket_thuc) . ' 00:00:00') * 1000?>;
					console.log(date_pay_js);
					console.log(ngay_ket_thuc_js);

					if (isNaN(phi_phat_tat_toan_truoc_han)) {
						phi_phat_tat_toan_truoc_han = 0;
					}
					tong_tien_tat_toan = du_no_con_lai + phi_phat_cham_tra + phi_phat_tat_toan_truoc_han + phi_phat_sinh + tien_chua_tra_ky_thanh_toan - tien_du_ky_truoc - tien_thua_thanh_toan + tong_so_tien_thieu;
					console.log(tong_tien_tat_toan)
					console.log(tien_giam_tru_bhkv)
					tong_tien_tat_toan_sau_giam_tru = tong_tien_tat_toan - tien_giam_tru - tien_giam_tru_bhkv - lai_suat_tru_vao_ky_cuoi;
					console.log('du_no_con_lai: ' + du_no_con_lai + ' -phi_phat_cham_tra: ' + phi_phat_cham_tra + ' -tien_lai: ' + tien_lai + ' -tien_phi: ' + tien_phi + ' -phi_phat_tat_toan_truoc_han: ' + phi_phat_tat_toan_truoc_han + '-phi_phat_sinh: ' + phi_phat_sinh + '-tien_du_ky_truoc: ' + tien_du_ky_truoc);
					$(".total_money_paid_finish").text(numeral(tong_tien_tat_toan).format('0,0'));
					$(".valid_amount_payment_finish").text(numeral(tong_tien_tat_toan_sau_giam_tru).format('0,0'));
					$("input[name='other_fee_finish']").val(numeral(tien_giam_tru_bhkv).format('0,0'));
					$(".discounted_fee_finish").val(numeral(tien_giam_tru).format('0,0'));
					$("#total_deductible_finish").text(numeral(tien_giam_tru + tien_giam_tru_bhkv).format('0,0'));
					$("#phi_phat_tat_toan_truoc_han_finish").text(numeral(phi_phat_tat_toan_truoc_han).format('0,0'));
					$("#penalty_pay_finish").text(numeral(phi_phat_cham_tra).format('0,0'));
					$("#fee_finish").text(numeral(tien_phi).format('0,0'));
					$("#interest_finish").text(numeral(tien_lai).format('0,0'));
					$(".actual_difference_payment_finish").text(numeral(total_money_paid_now - tong_tien_tat_toan).format('0,0'));
					$(".difference_day_payment_finish").text(parseInt(data.data.contract.difference_day_payment));
					$("input[name='valid_amount_payment_finish']").text(numeral((tong_tien_tat_toan)).format('0,0'));
					$("#balance_finish").text(numeral(du_no_con_lai).format('0,0'));
					$(".ky_cham_tra_top").text(numeral(parseInt(data.data.contract.ky_cham_tra)).format('0,0'));
					$(".total_money_paid_pay_top").text(numeral(parseInt(data.data.total_money_paid)).format('0,0'));
					$(".penalty_top").text(numeral((phi_phat_cham_tra)).format('0,0'));
					// $(".tong_thanh_toan_top").text(numeral((tong_tien_thanh_toan)).format('0,0'));
					//  $(".tong_da_thanh_toan_top").text(numeral((da_thanhtoan)).format('0,0'));
					//  $(".tong_con_no_top").text(numeral((tong_tien_thanh_toan-da_thanhtoan)).format('0,0'));

					$(".so_tien_phat_sinh_top").text(numeral((phi_phat_sinh)).format('0,0'));
					$("#tien_qua_han_finish").text(numeral((phi_phat_sinh)).format('0,0'));
					$(".total_money_paid_pay_top").text(numeral(parseInt(data.data.contract.total_money_paid)).format('0,0'));
					$("#successModal").modal("show");
					$(".msg_success").text(data.msg);
					setTimeout(function () {
						$("#successModal").modal("hide");
					}, 3000);

				} else {
					$('#errorModal').modal('show');
					$('.msg_error').text(data.msg);
					$('#confirm_payment').hide();
					setTimeout(function () {
						location.reload();
					}, 3000);
				}
			},
			error: function (data) {
				console.log(data);
				$("#loading").hide();
			}
		});

	});
	//});
</script>

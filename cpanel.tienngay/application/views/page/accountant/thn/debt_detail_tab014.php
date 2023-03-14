<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
$du_no_con_lai_tt =0;
$tien_lai_tt = 0;
$tien_phi_tt =
$tong_tien_thanh_toan_tt = 0;
$phi_phat_cham_tra_tt = 0;
$tong_penalty_con_lai = 0;
$tien_thanh_ly_thuc_con = 0;
$tien_tat_toan_da_giam_tru = 0;
$tien_giam_tru= 0;
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
$tong_tien_thanh_toan_tt = $du_no_con_lai_tt + $phi_phat_cham_tra_tt + $phi_phat_tat_toan_truoc_han + $phi_phat_sinh_tt + $tien_chua_tra_ky_thanh_toan - $tien_du_ky_truoc - $tien_thua_thanh_toan + $tong_so_tien_thieu - $tien_giam_tru_bhkv;
$tien_thanh_ly_chua_co_chi_phi = !empty($contractDB->liquidation_info->price_real_sold) ? $contractDB->liquidation_info->price_real_sold : 0;
$chi_phi_thanh_ly = !empty($contractDB->liquidation_info->fee_sold) ? $contractDB->liquidation_info->fee_sold : 0;
$tien_thanh_ly_thuc_con = $tien_thanh_ly_chua_co_chi_phi - $chi_phi_thanh_ly;
if($contractDB->status == 19)
{
	$tong_tien_thanh_toan_tt =0;
}

$tien_thieu_thanh_ly = 0;
$amount_add_to_exemption = 0;
$tien_chenh_lech_thanh_ly = 0;
if ($contractDB->status == 40) {
	$tien_chenh_lech_thanh_ly = $tien_thanh_ly_thuc_con - $tong_tien_thanh_toan_tt ;
	$tien_thieu_thanh_ly = $tong_tien_thanh_toan_tt - $tien_thanh_ly_thuc_con;
}
if ($tien_thieu_thanh_ly > 0) {
	$amount_add_to_exemption = $tien_thieu_thanh_ly;
}
if ($tong_tien_thanh_toan_tt > $tien_thanh_ly_thuc_con) {
	$tien_giam_tru = $tong_tien_thanh_toan_tt - $tien_thanh_ly_thuc_con;
	$tien_tat_toan_da_giam_tru = $tong_tien_thanh_toan_tt - $tien_giam_tru;
} elseif ($tong_tien_thanh_toan_tt < $tien_thanh_ly_thuc_con) {
	$tien_tat_toan_da_giam_tru = $tong_tien_thanh_toan_tt;
}



?>

<div class="row flex"
	 style="justify-content: center;" <?= 'Gốc còn lại:' . $du_no_con_lai_tt . ' -  phi_phat_cham_tra: ' . $phi_phat_cham_tra_tt . ' -  tien_lai: ' . $tien_lai_tt . ' -  tien_phi: ' . $tien_phi_tt . ' -  phi_phat_tat_toan_truoc_han: ' . $phi_phat_tat_toan_truoc_han . ' -  phi_phat_sinh: ' . $phi_phat_sinh_tt . ' -  tong_penalty_con_lai: ' . $tong_penalty_con_lai . ' -  tien_du_ky_truoc: ' . $tien_du_ky_truoc ?> >
	<div class="col-xs-12  col-md-6">
		<table class="table table-borderless">
			<tbody>
			<tr>
				<th style="color:black;">PHIẾU THU THANH LÝ XE</th>
				<div class=""></div>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<div class=""></div>
			</tr>
			<tr>
				<th>Người thanh toán:</th>
				<td class="text-right">
					<div class="form-group">
						<input type="text" class="form-control input-sm payment_name_finish_liquidations" name="payment_name_finish_liquidations" placeholder="Nhập họ tên người thanh toán">
					</div>
				</td>
			</tr>
			<tr>
				<th>Ngày thanh toán:</th>
				<td class="text-right">
					<input type="date" class="form-control input-sm" id='date_pay_finish_liquidations'
						   value="<?php echo date('Y-m-d', $contractDB->date_pay) ?>">
				</td>
			</tr>
			<tr class="d-none">
				<th>Số ngày chênh lệch thực tế và tất toán:</th>
				<td class="text-right"><p
							class="difference_day_payment_finish_liquidations"><?php echo !empty($contractDB->difference_day_payment) ? $contractDB->difference_day_payment : '0' ?></p>
				</td>
			</tr>
			<tr>
				<th>Phí khấu trừ</th>
				<td class="text-right">
					<div class="form-group">
						<input type="text" class="form-control input-sm reduced_fee_finish_liquidations" name="reduced_fee_finish_liquidations"
							   placeholder="Phí ngân hàng" disabled>
					</div>
					<div class="form-group">
						<input type="text" value="<?= !empty($amount_add_to_exemption) ? number_format($amount_add_to_exemption) : 0;?>"
							   class="form-control input-sm discounted_fee_finish_liquidations"
							   name="discounted_fee_finish_liquidations"
							   placeholder="Phí giảm trừ" disabled>
					</div>
					<div class="!form-group">
						<input type="text" class="form-control input-sm other_fee_finish_liquidations" name="other_fee_finish_liquidations"
							   placeholder="Phí khác" disabled>
					</div>
				</td>
			</tr>
			<tr>
				<th>Tổng tiền khẩu trừ:</th>
				<td class="text-right"><p id="total_deductible_finish_liquidations">0</p></td>
			</tr>
			<tr class="d-none">
				<th>Tiền lãi:</th>
				<td class="text-right"><p
							id="interest_finish_liquidations"><?php echo !empty($tien_lai_tt) ? number_format($tien_lai_tt) : '0' ?></p>
				</td>
			</tr>
			<tr>
				<th>Tiền khách hàng tất toán:</th>
				<td class="text-right"><p class="" style="color: black"><?php echo !empty($tien_thanh_ly_thuc_con) ? number_format($tien_thanh_ly_thuc_con): '0';?> đồng </p>
				</td>
				<input type="hidden" class="payment_amount_finish_liquidations" name="payment_amount_finish_liquidations" value="<?php echo !empty($tien_thanh_ly_thuc_con) ? $tien_thanh_ly_thuc_con : 0;?>"/>
				<input type="hidden" class="valid_amount_payment_finish_liquidations" name="valid_amount_payment_finish_liquidations" value="<?php echo !empty($tien_tat_toan_da_giam_tru) ? $tien_tat_toan_da_giam_tru : 0;?>"/>
				<input type="hidden" class="amount_payment_finish_system" name="amount_payment_finish_system" value="<?php echo !empty($tong_tien_thanh_toan_tt) ? $tong_tien_thanh_toan_tt: 0;?>"/>
			</tr>
			
			</tbody>
		</table>
	</div>

	<div class="col-xs-12  col-md-6">
		<table class="table table-borderless">
			<tbody>
			<tr>
				<th>&nbsp;</th>
				<div class=""></div>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<div class=""></div>
			</tr>

			<tr class="d-none">
				<th>Tổng tiền tất toán ngày hiện tại:</th>
				<td class="text-right"><p
							class="total_money_paid_now_finish_liquidations"><?php echo !empty($tong_tien_thanh_toan_tt) ? number_format($tong_tien_thanh_toan_tt) : '0' ?></p>
				</td>
			</tr>
			<tr>
				<th>Ngày thanh lý tài sản:</th>
				<td class="text-right">
					<input type="date" class="form-control input-sm date_liquidations" id='date_liquidations'
						   value="<?php echo date('Y-m-d', $contractDB->liquidation_info->created_at_liquidations); ?>">
				</td>
			</tr>
			<tr>
				<th>Tổng tiền đến ngày tất toán:</th>
				<td class="text-right "><p
							class="total_money_paid_finish_liquidations text-danger"><?php echo !empty($tong_tien_thanh_toan_tt) ? number_format($tong_tien_thanh_toan_tt) : '0' ?></p>
				</td>
			</tr>
			<tr class="d-none">
				<th>Tiền chênh lệch thực tế và tất toán:</th>
				<td class="text-right"><p
							class="actual_difference_payment_finish_liquidations"><?php echo !empty($contractDB->actual_difference_payment) ? number_format($contractDB->actual_difference_payment) : '0' ?></p>
				</td>
			</tr>
			<!-- <tr>
		  <th>Dư  còn lại:</th>
		 
			<td class="text-right"> -->
			<input type="hidden"
				   id="balance_finish_liquidations" <?php echo !empty($du_no_con_lai_tt) ? number_format($du_no_con_lai_tt) : '0' ?> >
			<!-- </td> -->
			<!-- </tr> -->

			<tr class="d-none">
				<th>Phí tất toán trước hạn:</th>

				<td class="text-right"><p
							id="phi_phat_tat_toan_truoc_han_finish_liquidations"><?php echo !empty($phi_phat_tat_toan_truoc_han) ? number_format($phi_phat_tat_toan_truoc_han) : '0' ?></p>
				</td>
			</tr>

			<tr class="d-none">
				<th>Tiền phạt chậm trả:</th>
				<td class="text-right"><p
							id="penalty_pay_finish_liquidations"><?php echo !empty($phi_phat_cham_tra_tt) ? number_format($phi_phat_cham_tra_tt) : '0' ?></p>
				</td>
			</tr>
			<tr class="d-none">
				<th>Tiền quá hạn:</th>
				<td class="text-right"><p
							id="tien_qua_han_finish_liquidations"><?php echo !empty($phi_phat_sinh_tt) ? number_format($phi_phat_sinh_tt) : '0' ?></p>
				</td>
			</tr>
			<tr>

			<tr class="d-none">
				<th>Tiền phí:</th>
				<td class="text-right"><p
							id="fee_finish_liquidations"><?php echo !empty($tien_phi_tt) ? number_format($tien_phi_tt) : '0' ?></p>
				</td>
			</tr>
			<tr>
				<th>Tiền thanh lý tài sản:</th>
				<td class="text-right">
					<p class="amount_liq_not_yet_fee" style="color: black" disabled><?php echo !empty($tien_thanh_ly_chua_co_chi_phi) ? number_format($tien_thanh_ly_chua_co_chi_phi) : '0'; ?>
					</p>
				</td>
				<input type="hidden" name="amount_liq_real" value="<?php echo $tien_thanh_ly_thuc_con ?>"/>
			</tr>
			<tr>
				<th>Chi phí thanh lý (kho, bãi):</th>
				<td class="text-right">
					<p class="fee_sold_finish_liquidations text-danger" disabled><?php echo !empty($chi_phi_thanh_ly) ? number_format($chi_phi_thanh_ly) : '0'; ?>
					</p>
				</td>
				<input type="hidden" name="fee_sold_finish_liquidations" value="<?php echo $chi_phi_thanh_ly ?>"/>
			</tr>
			<tr>
				<th>Tiền chênh lệch khi thanh lý:</th>
				<td class="text-right">
					<p class="deviant_liquidation" id="deviant_liquidation" style="color: black" disabled><?php echo !empty($tien_chenh_lech_thanh_ly) ? number_format($tien_chenh_lech_thanh_ly) : '0'; ?>
					</p>
				</td>
			</tr>
			<tr>
				<th>Phương thức:</th>
				<td class="text-right">

					<input class="form-check-input" type="radio" name="payment_method_finish_liquidations" value="1" checked>
					<label class="form-check-label" for="moneyoption_cast">
						Tiền mặt
					</label>

					<input class="form-check-input" type="radio" name="payment_method_finish_liquidations" value="2" >
					<label class="form-check-label" for="moneyoption_banktransfer">
						Chuyển khoản
					</label>

				</td>
			</tr>
			<tr>
				<th>Phòng giao dịch:</th>
				<td class="text-right">
					<select class="form-control" id="stores_finish_liquidations">
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
				<td class="text-right">
					<div class="">
						<input type="text"
							   class="form-control input-sm payment_note_liquidations"
							   name="payment_note_liquidations"
							   id="payment_note_liquidations" placeholder="Nhập nội dung thu tiền">
					</div>
				</td>
			</tr>
			</tbody>
		</table>
	</div>

	<input type="hidden" class="form-control input-sm" name="penalty_pay_finish_liquidations">
	<input type="hidden" class="form-control input-sm" name="penalty_now_finish_liquidations"
		   value="<?php echo !empty($contractDB->penalty_now) ? $contractDB->penalty_now : '' ?>">
	<input type="hidden" class="form-control input-sm"
		   value="<?php echo !empty($contractDB->code_contract) ? $contractDB->code_contract : '' ?>"
		   name="code_contract_finish_liquidations">
	<input type="hidden" class="form-control input-sm" id="id_contract_liquidation" value="<?= !empty($_GET['id']) ? $_GET['id'] : "" ?>">
	<div class="col-xs-12 text-right">


		<?php
		if (($countGiaoDichTatToanChoDuyet == 0 && $contractDB->status != 19) && (strtotime(date('Y-m-d') . ' 23:59:59') > $contractDB->disbursement_date)) {
			?>
			<button id="confirm_finish_liquidations_contract" class="btn btn-success" style="min-width: 125px">XÁC NHẬN TẤT TOÁN</button>
		<?php } else if ($countGiaoDichTatToanChoDuyet > 0) { ?>
			<div class="alert alert-warning center" role="alert">
				<h4> Đã tồn tại tất toán! (Kiểm tra phiếu thu nếu Thất bại thì Gửi duyệt) và báo bộ phận kế toán duyệt
					tất toán.</h4>
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
		$('#date_pay_finish_liquidations').attr('max', maxDate);
	});

	$('.payment_amount_finish_liquidations').on('input', function (e) {
		$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
	}).on('keypress', function (e) {
		if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
	}).on('paste', function (e) {
		var cb = e.originalEvent.clipboardData || window.clipboardData;
		if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
	});

	function formatCurrency(number) {
		var n = number.split('').reverse().join("");
		var n2 = n.replace(/\d\d\d(?!$)/g, "$&,");
		return n2.split('').reverse().join('');
	}
	$('#date_liquidations').change(function () {
		var date_liquidations = $(this).val();
		var id_contract = $("#id_contract_liquidation").val();

		var formData = {
			date_liquidations: date_liquidations,
			id_contract: id_contract
		};

		$.ajax({
			url: _url.base_url + 'accountant/update_date_liquidations',
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

	//  $(document).ready(function() {
	$('#date_pay_finish_liquidations').change(function () {
		var date_pay = $(this).val();
		var id_contract = $("#id_contract").val();
		$(".discounted_fee_finish_liquidations").empty();
		$("#total_deductible_finish_liquidations").empty();
		$(".valid_amount_payment_finish_liquidations").empty();
		$(".payment_amount_finish_liquidations").empty();
		$(".amount_payment_finish_system").empty();
		$("#deviant_liquidation").empty();

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
					$(".reduced_fee_finish_liquidations").val('0');
					$(".other_fee_finish_liquidations").val('0');
					var tien_giam_tru = 0;
					var total_money_paid_now = $(".total_money_paid_now_finish_liquidations").text().split(',').join('');
					var du_no_con_lai = Math.round(data.data.dataTatToanPart1.du_no_con_lai);
					var tien_lai = Math.round(data.data.dataTatToanPart2.lai_con_no_thuc_te);
					var tien_phi = Math.round(data.data.dataTatToanPart2.phi_con_no_thuc_te);
					var da_thanhtoan = Math.round(data.data.contract.total_paid);
					var tien_du_ky_truoc = Math.round(data.data.contract.tien_du_ky_truoc);
					var tien_thua_thanh_toan = Math.round(data.data.contract.tien_thua_thanh_toan);
					var tien_chua_tra_ky_thanh_toan = Math.round(data.data.contract.tien_chua_tra_ky_thanh_toan);
					var tien_giam_tru_bhkv = Math.round(data.data.contract.tien_giam_tru_bhkv);
					var tong_so_tien_thieu = Math.round(data.data.contract.tong_so_tien_thieu);
					var phi_phat_tat_toan_truoc_han = Math.round(data.data.debtData.phi_thanh_toan_truoc_han);

					if (data.data.contract.status != 19)
						var phi_phat_cham_tra = Math.round(data.data.contract.penalty_pay);
					var phi_phat_sinh = Math.round(data.data.contract.phi_phat_sinh);
					var tong_tien_tat_toan = 0;
					var tien_thanh_ly_chua_co_chi_phi = 0;
					var tien_thanh_ly_thuc_con = 0;
					var tong_tien_tat_toan_sau_giam_tru = 0;
					var chi_phi_thanh_ly = 0;
					var tien_chenh_lech_thanh_ly = 0;
					var newDate = new Date(date_pay);
					var date_pay_js = newDate.getTime();
					var ngay_ket_thuc_js = <?=strtotime(date('Y-m-d', $contractDB->ngay_ket_thuc) . ' 00:00:00') * 1000?>;
					console.log(date_pay_js);
					console.log(ngay_ket_thuc_js);
					if (isNaN(phi_phat_tat_toan_truoc_han)) {
						phi_phat_tat_toan_truoc_han = 0;
					}
					tien_thanh_ly_chua_co_chi_phi = Math.round(data.data.contract.liquidation_info.price_real_sold);
					chi_phi_thanh_ly = Math.round(data.data.contract.liquidation_info.fee_sold);
					tien_thanh_ly_thuc_con = tien_thanh_ly_chua_co_chi_phi - chi_phi_thanh_ly;
					tong_tien_tat_toan = du_no_con_lai + phi_phat_cham_tra + phi_phat_tat_toan_truoc_han + phi_phat_sinh + tien_chua_tra_ky_thanh_toan - tien_du_ky_truoc - tien_thua_thanh_toan + tong_so_tien_thieu - tien_giam_tru_bhkv;
					tien_chenh_lech_thanh_ly = tien_thanh_ly_thuc_con - tong_tien_tat_toan;
					if (tong_tien_tat_toan - tien_thanh_ly_thuc_con > 0) {
						tien_giam_tru = tong_tien_tat_toan - tien_thanh_ly_thuc_con;
					} else {
						tien_giam_tru = 0;
					}
					if (tien_giam_tru > 0) {
						tong_tien_tat_toan_sau_giam_tru = tong_tien_tat_toan - tien_giam_tru;
						$(".discounted_fee_finish_liquidations").val(numeral(tien_giam_tru).format('0,0'));
						$("#total_deductible_finish_liquidations").text(numeral(tien_giam_tru).format('0,0'));
					} else {
						tong_tien_tat_toan_sau_giam_tru = tong_tien_tat_toan;
					}
					console.log(tong_tien_tat_toan)
					console.log(tien_thanh_ly_chua_co_chi_phi)
					console.log(tien_giam_tru)
					console.log(tong_tien_tat_toan_sau_giam_tru)
					console.log(du_no_con_lai + ' + ' + phi_phat_cham_tra + ' + ' + phi_phat_tat_toan_truoc_han + ' + ' + phi_phat_sinh + ' + ' + tien_chua_tra_ky_thanh_toan + ' - ' + tien_du_ky_truoc + ' - ' + tien_thua_thanh_toan + ' + ' + tong_so_tien_thieu + ' - ' + tien_giam_tru_bhkv+ ' - ' + tien_giam_tru);

					$("#deviant_liquidation").text(numeral(tien_chenh_lech_thanh_ly).format('0,0'));
					$(".total_money_paid_finish_liquidations").text(numeral(tong_tien_tat_toan).format('0,0'));
					$(".payment_amount_finish_liquidations").val(numeral(tien_thanh_ly_thuc_con).format('0,0'));
					$(".valid_amount_payment_finish_liquidations").val(numeral(tong_tien_tat_toan_sau_giam_tru).format('0,0'));
					$(".amount_payment_finish_system").val(tong_tien_tat_toan);
					$("#phi_phat_tat_toan_truoc_han_finish_liquidations").text(numeral(phi_phat_tat_toan_truoc_han).format('0,0'));
					$("#penalty_pay_finish_liquidations").text(numeral(phi_phat_cham_tra).format('0,0'));
					$("#fee_finish_liquidations").text(numeral(tien_phi).format('0,0'));
					$("#interest_finish_liquidations").text(numeral(tien_lai).format('0,0'));
					$(".actual_difference_payment_finish_liquidations").text(numeral(total_money_paid_now - tong_tien_tat_toan_sau_giam_tru).format('0,0'));
					$(".difference_day_payment_finish_liquidations").text(data.data.contract.difference_day_payment);
					// $("input[name='valid_amount_payment_finish_liquidations']").val(numeral((tong_tien_tat_toan_sau_giam_tru)).format('0,0'));
					$("#balance_finish_liquidations").text(numeral(du_no_con_lai).format('0,0'));
					$(".ky_cham_tra_top").text(numeral((data.data.contract.ky_cham_tra)).format('0,0'));
					$(".total_money_paid_pay_top").text(numeral((data.data.total_money_paid)).format('0,0'));
					$(".penalty_top").text(numeral((phi_phat_cham_tra)).format('0,0'));
					$(".so_tien_phat_sinh_top").text(numeral((phi_phat_sinh)).format('0,0'));
					$("#tien_qua_han_finish_liquidations").text(numeral((phi_phat_sinh)).format('0,0'));
					$(".total_money_paid_pay_top").text(numeral((data.data.contract.total_money_paid)).format('0,0'));
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

	// phí ngân hàng
	$('.reduced_fee_finish_liquidations').on('input', function(e){
		var total_money_paid = $(".total_money_paid_finish_liquidations").text();
		var other_fee = $(".other_fee_finish_liquidations").val();
		var discounted_fee = $(".discounted_fee_finish_liquidations").val();
		$("#total_deductible_finish_liquidations").text(numeral(getFloat_pay(this.value) + getFloat_pay(other_fee) + getFloat_pay(discounted_fee)).format('0,0'));
		var valid_amount_payment = getFloat_pay(total_money_paid) - getFloat_pay(this.value) - getFloat_pay(other_fee) - getFloat_pay(discounted_fee);
		if(valid_amount_payment<= 0 )
		{
			$("#errorModal").modal("show");
			$(".msg_error").text("Phí giảm trừ không được lớn hơn số tiền cần thanh toán");
			setTimeout(function(){
				location.reload();
			}, 3000);
		}
		$(".valid_amount_payment_finish_liquidations").text(numeral(valid_amount_payment).format('0,0'));
		$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
	}).on('keypress',function(e){

		if(!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
	}).on('paste', function(e){
		var cb = e.originalEvent.clipboardData || window.clipboardData;
		if(!$.isNumeric(cb.getData('text'))) e.preventDefault();
	});

	// phí giảm trừ
	$('.discounted_fee_finish_liquidations').on('input', function(e){
		var total_money_paid = $(".total_money_paid_finish_liquidations").text();
		var reduced_fee = $(".reduced_fee_finish_liquidations").val();
		var other_fee = $(".other_fee_finish_liquidations").val();
		$("#total_deductible_finish_liquidations").text(numeral(getFloat_pay(this.value) + getFloat_pay(reduced_fee) + getFloat_pay(other_fee)).format('0,0'));
		var valid_amount_payment = getFloat_pay(total_money_paid) - getFloat_pay(this.value) - getFloat_pay(reduced_fee) - getFloat_pay(other_fee);
		if(valid_amount_payment<= 0 )
		{
			$("#errorModal").modal("show");
			$(".msg_error").text("Phí giảm trừ không được lớn hơn số tiền cần thanh toán");
			setTimeout(function(){
				location.reload();
			}, 3000);
		}
		$(".valid_amount_payment_finish_liquidations").text(numeral(valid_amount_payment).format('0,0'));
		$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
	}).on('keypress',function(e){

		if(!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
	}).on('paste', function(e){
		var cb = e.originalEvent.clipboardData || window.clipboardData;
		if(!$.isNumeric(cb.getData('text'))) e.preventDefault();
	});
	// phí khác
	$('.other_fee_finish_liquidations').on('input', function(e){
		var total_money_paid = $(".total_money_paid_finish_liquidations").text().split(',').join('');
		var reduced_fee = $(".reduced_fee_finish_liquidations").val().split(',').join('');
		var discounted_fee = $(".discounted_fee_finish_liquidations").val().split(',').join('');
		$("#total_deductible_finish_liquidations").text(numeral(getFloat_pay(this.value) + getFloat_pay(reduced_fee) + getFloat_pay(discounted_fee)).format('0,0'));
		var valid_amount_payment = getFloat_pay(total_money_paid) - getFloat_pay(this.value) - getFloat_pay(reduced_fee) - getFloat_pay(discounted_fee);
		if(valid_amount_payment<= 0 )
		{
			$("#errorModal").modal("show");
			$(".msg_error").text("Phí giảm trừ không được lớn hơn số tiền cần thanh toán");
			setTimeout(function(){
				location.reload();
			}, 3000);
		}
		$(".valid_amount_payment_finish_liquidations").text(numeral(valid_amount_payment).format('0,0'));
		$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
	}).on('keypress',function(e){

		if(!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
	}).on('paste', function(e){
		var cb = e.originalEvent.clipboardData || window.clipboardData;
		if(!$.isNumeric(cb.getData('text'))) e.preventDefault();
	});
</script>

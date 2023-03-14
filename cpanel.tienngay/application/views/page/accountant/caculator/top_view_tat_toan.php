<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
$status_pay = "";
if ($contractDB->status == 17) {
	if ($contractDB->ky_cham_tra == 0) {
		$status_pay = "Chưa đến kỳ thanh toán";
	}
	if ($contractDB->ky_cham_tra > 0) {
		$status_pay = "Chậm trả";
	}
} else if ($contractDB->status == 19) {
	$status_pay = "Đã tất toán";
} else {
	$status_pay = "Không xác định";
}
$penalty = 0;
$tong_thanh_toan = 0;
$con_lai_chua_tra = 0;
$da_thanh_toan = 0;
$penalty_dathanhtoan = 0;
$tong_thanh_toan = (float)$contractDB->tong_thanh_toan;
$da_thanh_toan = (float)$contractDB->total_paid;
$con_lai_chua_tra = $tong_thanh_toan - $da_thanh_toan;
$phat_cham_tra = (float)$contractDB->penalty_now;


?>
<?php
$du_no_con_lai_tt = 0;
$tien_lai_tt = 0;
$tien_phi_tt = 0;
$tong_tien_thanh_toan_tt = 0;
$phi_phat_cham_tra_tt = 0;
$tong_penalty_con_lai = 0;

$tien_vay = 0;
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
$tien_vay = !empty($contractDB->loan_infor->amount_money) ? $contractDB->loan_infor->amount_money : 0;
$tien_chua_tra_ky_thanh_toan = !empty($contractDB->tien_chua_tra_ky_thanh_toan) ? $contractDB->tien_chua_tra_ky_thanh_toan : 0;
$tien_thua_thanh_toan = !empty($contractDB->tien_thua_thanh_toan) ? $contractDB->tien_thua_thanh_toan : 0;
$tien_giam_tru_bhkv = !empty($contractDB->tien_giam_tru_bhkv) ? $contractDB->tien_giam_tru_bhkv : 0;
$tong_so_tien_thieu = !empty($contractDB->tong_so_tien_thieu) ? $contractDB->tong_so_tien_thieu : 0;
$du_no_goc_con_lai = !empty($dataTatToanPart1->goc_chua_tra_den_thoi_diem_dao_han) ? $dataTatToanPart1->goc_chua_tra_den_thoi_diem_dao_han : 0;
$date_pay = (isset($_GET['date'])) ? strtotime($_GET['date'] . ' 00:00:00') : strtotime(date('m/d/Y') . ' 00:00:00');

$tong_tien_thanh_toan_tt = $du_no_con_lai_tt + $phi_phat_cham_tra_tt + $phi_phat_tat_toan_truoc_han + $phi_phat_sinh_tt + $tien_chua_tra_ky_thanh_toan - $tien_du_ky_truoc - $tien_thua_thanh_toan + $tong_so_tien_thieu;
if($contractDB->status == 19)
{
	$tong_tien_thanh_toan_tt = 0;
}
if ($reduced_profit > 0) {
	$lai_suat_tru_vao_ky_cuoi = $reduced_profit;
}

$type_payment_exem = !empty($exemption_contract->type_payment_exem) ? $exemption_contract->type_payment_exem : 1;
if ( ($issetTransactionDiscount == false) && !empty($exemption_contract->status) && ($exemption_contract->status == 7 || $exemption_contract->status == 5) && ($exemption_contract->status != 6) && ($type_payment_exem == 2)) {
	$tien_giam_tru = !empty($exemption_contract->amount_tp_thn_suggest)  ? $exemption_contract->amount_tp_thn_suggest : 0;
}
$tong_tien_tat_toan_sau_giam_tru = $tong_tien_thanh_toan_tt - $tien_giam_tru - $tien_giam_tru_bhkv - $lai_suat_tru_vao_ky_cuoi;
?>
<div class="row flex" style="justify-content: center;">
	<div class="col-xs-12  col-md-6">
		<table class="table table-borderless">
			<tbody>
			<tr>
				<th>Khách hàng</th>
				<td class="text-right text-danger">
					<strong><?php echo $contractDB->customer_infor->customer_name ?></strong></td>
			</tr>
			<tr>
				<th>Mã HĐ</th>
				<td class="text-right"><?php echo $contractDB->code_contract_disbursement ?></td>
			</tr>
			<tr>
				<th>Mã phiếu ghi</th>
				<td class="text-right"><?php echo $contractDB->code_contract ?></td>
			</tr>
			<tr>
				<th>Sản phẩm vay</th>
				<td class="text-right"><?php echo $contractDB->loan_infor->name_property->text ?></td>
			</tr>
			<tr>
				<th>Hình thức vay</th>
				<td class="text-right"><?php echo change_type_loan($contractDB->loan_infor->type_loan->text) ?></td>
			</tr>
			<tr>
				<th>Thời gian vay</th>
				<td class="text-right"><?= !empty($contractDB->disbursement_date) ? date('d/m/Y', intval($contractDB->disbursement_date)) : "" ?>
					- <?= !empty($contractDB->ngay_ket_thuc) ? date('d/m/Y', intval($contractDB->ngay_ket_thuc)) : "" ?>
					(<?= !empty($contractDB->tong_so_ngay_trong_ky) ? intval($contractDB->tong_so_ngay_trong_ky) : "" ?>
					ngày)
				</td>
			</tr>
			<tr>
				<th>Hình thức trả</th>
				<td class="text-right"><?php echo type_repay($contractDB->loan_infor->type_interest) ?></td>
			</tr>
			<tr>
				<th>Phí thực tính</th>
				<td class="text-right">
					<a href="javascript:void(0)" onclick="edit_fee(this)"
					   data-id="<?php echo $contractDB->_id->{'$oid'} ?>" class="dropdown-item yeu_cau_giai_ngan"> Xem
						Phí
						Thực Tính</a>

				</td>
			</tr>
			<tr>
				<th>Chi tiết hợp đồng</th>
				<td class="text-right">
					<a href="<?php echo base_url("/pawn/detail?id=") . $contractDB->_id->{'$oid'} ?>" target="_blank"
					   class="dropdown-item yeu_cau_giai_ngan"> Xem chi tiết</a>

				</td>
			</tr>

			</tbody>
		</table>
		<input type="hidden" class="form-control " name="id_contract" value="<?php echo $contractDB->_id->{'$oid'} ?>"
			   readonly>
	</div>

	<div class="col-xs-12  col-md-6">
		<table class="table table-borderless">
			<tbody>
			<tr>
				<th>Tiền vay</th>
				<td class="text-right"><?php echo number_format($contractDB->loan_infor->amount_money) ?></td>
			</tr>
			<tr>
				<th>Gốc còn lại</th>
				<td class="text-right tong_thanh_toan_top text-danger">
					<b><?php echo number_format($du_no_goc_con_lai) ?></b></td>
			</tr>
			<tr>
				<th>Tổng số tiền tất toán</th>
				<td class="text-right tong_thanh_toan_top text-danger">
					<b><?php echo number_format($tong_tien_tat_toan_sau_giam_tru) ?></b></td>
			</tr>


			<tr>
				<th>Tiền lãi</th>
				<td class="text-right text-danger so_tien_phat_sinh_top"><?php echo number_format($tien_lai_tt) ?></td>
			</tr>
			<tr>
				<th>Tiền phí</th>
				<td class="text-right text-danger so_tien_phat_sinh_top"><?php echo number_format($tien_phi_tt) ?></td>
			</tr>
			<tr>
				<th>Tiền phạt tất toán trước hạn</th>
				<td class="text-right penalty_top text-danger"><?php echo number_format($phi_phat_tat_toan_truoc_han); ?></td>
			</tr>
			<tr>
				<th>Tiền phạt chậm trả các kỳ</th>
				<td class="text-right penalty_top text-danger"><?php echo number_format($phi_phat_cham_tra_tt); ?></td>
			</tr>
			<tr>
				<th>Tiền phạt quá hạn hợp đồng</th>
				<td class="text-right text-danger so_tien_phat_sinh_top"><?php echo number_format($phi_phat_sinh_tt) ?></td>
			</tr>
			</tbody>
		</table>
	</div>
</div>

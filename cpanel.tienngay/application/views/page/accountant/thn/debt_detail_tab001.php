<div class="table-responsive">
	<table class="table table-striped table-bordered">
		<thead>
		<tr>
			<th>Kỳ</th>
			<th>Ngày đến hạn</th>
			<th>Số ngày</th>
			<th>Số ngày chậm trả</th>
			<th>Tiền phải <br> trả hàng kỳ</th>
			<th>Tiền gốc</th>
			<th>Tiền lãi</th>
			<th>Phí tư vấn quản lý <br>+ thẩm định lưu trữ tài sản</th>
			<th>Tổng tiền thanh toán</th>
			<th>Đã thanh toán</th>
			<th>Còn lại chưa trả</th>
			<th>Tình trạng</th>
			<th>Phạt chậm trả</th>

		</tr>
		</thead>
		<?php

		$data = array();
		$data['contractData'] = $contractData;
		$this->load->view("page/accountant/chi_tiet_thanh_toan", $data);

		?>
	</table>
</div>


<?php
function get_type($id_type, $type_payment)
{
	switch ($id_type) {
		case '1':
			return "Thanh toán hóa đơn";
			break;
		case '2':
			return "Phí phạt";
			break;
		case '3':
			return "Tất toán";
			break;
		case ($type_payment == 1 && $id_type == 4):
			return "Thanh toán - Kỳ";
			break;
		case ($type_payment == 2 && $id_type == 4):
			return "Thanh toán - Gia hạn";
			break;
		case ($type_payment == 3 && $id_type == 4):
			return "Thanh toán - Cơ cấu";
			break;
		case '5':
			return "Gia hạn";
			break;
		case '6':
			return "Thanh toán NĐT";
			break;
	}

}

?>

<br>
<div class="table-responsive">
	<h4><b> Lịch sử trả tiền</b></h4>
	<table id="datatable-buttos" class="table table-striped table-bordered" style="width: 100%">
		<thead>
		<tr>
			<th>#</th>
			<th>Lịch sử duyệt PT</th>
			<th>Mã phiếu thu</th>
			<th>Ngày tạo</th>
			<th>Ngày thanh toán</th>
			<th>Số tiền thanh toán</th>
			<th>Số tiền miễn giảm</th>
			<th>Phí quá hạn</th>
			<th>Ngày quá hạn</th>
			<th>Phí gia hạn</th>
			<th>Tiền thừa</th>
			<th>Người cập nhật</th>
			<th>Loại thanh toán</th>
			<th>Phương thức</th>
			<th>Trạng thái</th>
			<th>Ghi chú PGD</th>
			<th>Ghi chú Kế toán</th>
		</tr>
		</thead>

		<tbody>
		<?php
		$group_total = 0;
		$group_phat_sinh = 0;
		$group_tien_thua = 0;
		$group_tien_mien_giam = 0;
		if (!empty($historyData)) {
			foreach ($historyData as $key => $history) {
				if ($history->type == 2) continue;

				if ($history->status == 1) {
					$group_total += $history->total;
					$group_phat_sinh += $history->phi_phat_sinh;
					$group_tien_thua += $history->tien_thua_thanh_toan_con_lai;
					$group_tien_mien_giam += $history->total_deductible;
				}
				$type_payment = (!empty($history->type_payment)) ? $history->type_payment : 1;
				?>

				<tr>
					<td><?php echo $key + 1 ?></td>
					<td>
						<a href="<?php echo base_url("transaction/viewImg_kt?id=") . $history->_id->{'$oid'} ?>"
						   target="_blank"
						   class="dropdown-item btn btn-info">
							Lịch sử duyệt PT
						</a>
					</td>
					<td><?= !empty($history->code) ? $history->code : "" ?></td>
					<td><?= !empty($history->created_at) ? date('d/m/Y H:i:s', intval($history->created_at)) : "" ?></td>
					<td><?= !empty($history->date_pay) ? date('d/m/Y H:i:s', intval($history->date_pay)) : "" ?></td>
					<td><?= number_format(((int)$history->total)) ?></td>
					<td><?= !empty($history->total_deductible) ? number_format(((int)$history->total_deductible)) : number_format(((int)$history->discounted_fee)) ?></td>
					<td><?= number_format(((int)$history->phi_phat_sinh)) ?></td>
					<td><?= !empty($history->so_ngay_phat_sinh) ? $history->so_ngay_phat_sinh : "" ?></td>
					<td><?= !empty($history->so_tien_phi_gia_han_da_tra) ? number_format($history->so_tien_phi_gia_han_da_tra) : "" ?></td>
					<td><?= !empty($history->tien_thua_thanh_toan_con_lai) ? number_format($history->tien_thua_thanh_toan_con_lai) : "" ?></td>

					<td><?= !empty($history->created_by) ? $history->created_by : "" ?></td>
					<td> <?= !empty($history->type) ? get_type($history->type, $type_payment) : "" ?></td>
					<td><?php
						$method = '';
						if ($history->payment_method == 1) {
							$method = 'Tiền mặt';
						} elseif ($history->payment_method == 2) {
							$method = 'Chuyển khoản';
						} else {
							$method = !empty($history->payment_method) ? $history->payment_method : '';
						}
						echo $method;
						?>
					</td>
					<td>
						<?php
						$status = '';
						if ($history->status == 1) {
							$status = 'Thành công';
						} elseif ($history->status == 2) {
							$status = 'Chờ kế toán xác nhận';
						} elseif ($history->status == 3) {
							$status = 'Đã hủy';
						} elseif ($history->status == 4) {
							$status = 'Chưa gửi duyệt';
						} elseif ($history->status == 11) {
							$status = 'Kế toán trả về';
						} else {
							$status = !empty($history->status) ? $history->status : '';
						}
						echo $status;
						?>
					</td>
					<td>
						<?php
						$content_billing = '';
						$notes = !empty($history->note) ? $history->note : "";
						if (is_array($notes)) {
							foreach ($notes as $note) {
								$content_billing .= billing_content($note);
							}
							echo $content_billing;
						} else {
							echo $history->note;
						}
						?>
					</td>
					<td><?= !empty($history->approve_note) ? $history->approve_note : "" ?></td>
				</tr>
			<?php }
		} ?>
		<tr>
			<td>Tổng</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td><?= number_format(((int)$group_total)) ?></td>
			<td><?= number_format(((int)$group_tien_mien_giam)) ?></td>

			<td><?= number_format(((int)$group_phat_sinh)) ?></td>
			<td></td>
			<td></td>
			<td><?= number_format(((int)$group_tien_thua)) ?></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>

		</tr>
		</tbody>
	</table>
</div>

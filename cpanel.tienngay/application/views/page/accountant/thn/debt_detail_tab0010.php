<?php date_default_timezone_set('Asia/Ho_Chi_Minh'); ?>
<div class="col-xs-12">
	<br>

	<h3>
		Ghi chú <br>

	</h3>

</div>
<div class="col-xs-12">

	<div class="form-group">
		<label>Kết quả nhắc hợp đồng vay:</label>
		<select class="form-control result_reminder">
			<?php foreach (note_renewal() as $key => $value) { ?>
				<option value="<?= $key ?>"><?= $value ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="form-group">
		<label>Ngày hẹn thanh toán:</label>
		<input type="date" name="payment_date" class="form-control payment_date">
	</div>
	<div class="form-group">
		<label>Số tiền hẹn thanh toán:</label>
		<input type="text" class="form-control amount_payment_appointment">
	</div>
	<div class="form-group">
		<label>Ghi chú:</label>
		<textarea class="form-control contract_v2_note" rows="5"></textarea>
		<input type="hidden" value="<?= (isset($_GET['id'])) ? $_GET['id'] : "" ?>" class="form-control contract_id">
	</div>

	<p class="text-right">
		<button class="btn btn-danger note_contract_v2_submit">Lưu</button>
	</p>


	<div class="table-responsive">
		<table class="table table-striped table-bordered">
			<thead>
			<tr>
				<th>STT</th>
				<th>Thời gian</th>
				<th>Người thực hiện</th>
				<th>Kết quả</th>
				<th>Ngày hẹn thanh toán</th>
				<th>Số tiền hẹn thanh toán</th>
				<th>Ghi chú</th>
			</tr>
			</thead>
			<tbody>

			<?php
			if (!empty($reminder_contract)) {

				foreach ($reminder_contract as $key => $value) {
					//  var_dump( $value); die;
					?>
					<tr>
						<td><?php echo $key + 1 ?></td>
						<td><?= !empty($value->created_at) ? date('d/m/Y H:i:s', intval($value->created_at)) : "" ?></td>
						<td><?= !empty($value->created_by) ? $value->created_by : "" ?></td>
						<td>
							<?php if (!empty($value->new)): ?>
								<?php if (!empty($value->new->note_reminder)): ?>
									<?php echo !empty($value->new->note_reminder->reminder) ? note_renewal($value->new->note_reminder->reminder) : ""?>
								<?php else: ?>
									<?php echo !empty($value->new->result_reminder) ? note_renewal($value->new->result_reminder) : '' ?>
								<?php endif; ?>
							<?php else: ?>
								<?php echo note_renewal($value->status_debt) ?>
							<?php endif; ?>
						</td>
						<td>
							<?php if (!empty($value->new)): ?>
								<?php if (!empty($value->new->note_reminder)): ?>
									<?php echo !empty($value->new->note_reminder->payment_date) ? $value->new->note_reminder->payment_date : "" ?>
								<?php else: ?>
									<?php echo !empty($value->new->payment_date) ? $value->new->payment_date : '' ?>
								<?php endif; ?>
							<?php else: ?>
								<?php echo !empty($value->time_recovery) ? date('d/m/Y H:i:s', $value->time_recovery) : '' ?>
							<?php endif; ?>
						</td>
						<td>
							<?php if (!empty($value->new)): ?>
								<?php if (!empty($value->new->note_reminder)): ?>
									<?php echo !empty($value->new->note_reminder->amount_payment_appointment) ? $value->new->note_reminder->amount_payment_appointment : ''; ?>
								<?php else: ?>
									<?php echo !empty($value->new->amount_payment_appointment) ? $value->new->amount_payment_appointment : '' ?>
								<?php endif; ?>
							<?php else: ?>
								<?php echo !empty($value->amount_payment_appointment) ? $value->amount_payment_appointment : '' ?>
							<?php endif; ?>
						</td>
						<td>
							<?php if (!empty($value->new)): ?>
								<?php if (!empty($value->new->note_reminder)): ?>
									<?php echo !empty($value->new->note_reminder->note) ? note_renewal($value->new->note_reminder->note) : ""?>
								<?php else: ?>
									<?php echo !empty($value->new->note) ? $value->new->note : '' ?>
								<?php endif; ?>
							<?php else: ?>
								<?php echo $value->note ?>
							<?php endif; ?>
						</td>

					</tr>
				<?php }
			} ?>


			</tbody>
		</table>
	</div>
</div>
<div class="col-xs-12">
	<h3>Lịch sử cuộc gọi</h3>
	<div class="table-responsive">

		<table id="datatable-buttons" class="table table-striped ">
			<thead>
			<tr>
				<th>#</th>
				<th>Loại cuộc gọi</th>
				<th>Nhân viên</th>
				<th>Số gọi</th>
				<th>Số nghe</th>

				<th>Trạng thái cuộc gọi</th>
				<th>Chi tiết</th>
				<th>Thời lượng</th>


			</tr>
			</thead>
			<tbody name="list_lead">
			<?php

			if (!empty($recordingData)) {
				$n = 0;
				foreach ($recordingData as $key => $history) {


					?>
					<tr>
						<td><?php echo ++$n ?></td>
						<td><?php if ($history->direction == 'outbound')
								echo '<i class="fa fa-sign-out" aria-hidden="true"></i><br>Outbound call'; ?>
							<?php if ($history->direction == 'inbound')
								echo '<i class="fa fa-sign-in" aria-hidden="true"></i><br>Inbound call'; ?>
							<?php if ($history->direction == 'local')
								echo '<i class="fa fa-refresh" aria-hidden="true"></i><br>Internal'; ?>

						</td>
						<td><?= ($history->fromUser) ? $history->fromUser->email : '' ?><br>
							<?= ($history->toUser) ? $history->toUser->email : '' ?>
						</td>

						<td><?= ($history->fromNumber) ? $history->fromNumber : ''; ?><br>
							<?= ($history->fromUser) ? 'Nhánh: ' . $history->fromUser->ext : ''; ?>
						</td>
						<td><?= ($history->toNumber) ? hide_phone($history->toNumber) : ''; ?><br>
							<?= ($history->toUser) ? 'Nhánh: ' . $history->toUser->ext : ''; ?>
						</td>
						<td><?= !empty($history->hangupCause) ? recoding_status($history->hangupCause) : "" ?></td>
						<td>Bắt
							đầu: <?= !empty($history->startTime) ? date('d/m/Y H:i:s', $history->startTime / 1000) : "" ?>
							<br>
							Trả
							lời: <?= (!empty($history->answerTime) && (int)($history->answerTime) > 0) ? date("d/m/Y H:i:s", $history->answerTime / 1000) : "Không có"; ?>
							<br>
							Kết
							thúc: <?= !empty($history->endTime) ? date('d/m/Y H:i:s', $history->endTime / 1000) : "" ?>
							<br>
						</td>
						<td>Tổng time: <?= ($history->duration) ? $history->duration : '' ?><br>
							Tổng time tư vấn: <?= ($history->billDuration) ? $history->billDuration : '' ?><br>
						</td>
						<td class="text-right">
							<?php if ($history->billDuration) { ?>


							<?php } ?>

						</td>
					</tr>
				<?php }
			} ?>
			</tbody>
		</table>
	</div>

</div>


<script src="<?php echo base_url(); ?>assets/js/accountant/index.js"></script>

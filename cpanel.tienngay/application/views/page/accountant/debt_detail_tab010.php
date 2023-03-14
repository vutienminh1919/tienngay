<div class="col-xs-12">
	<div class="panel panel-default">
		<div class="panel-body">
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
					if (!empty($reminders)) {

						foreach ($reminders as $key => $value) {
							if(!empty($value->new) && !empty($value->new->result_reminder)) continue;
							?>
							<tr>
								<td><?php echo ++$key ?></td>
								<td><?= !empty($value->created_at) ? date('d/m/Y H:i:s', intval($value->created_at + 7 * 60 * 60)) : "" ?></td>
								<td><?= !empty($value->created_by) ? $value->created_by : "" ?></td>
								<?php if (!empty($value->new->note_reminder)): ?>
									<td><?php echo !empty($value->new->note_reminder->reminder) ? note_renewal($value->new->note_reminder->reminder) : '' ?></td>
								<?php else: ?>
									<td><?php echo !empty($value->new->result_reminder) ? note_renewal($value->new->result_reminder) : '' ?></td>
								<?php endif; ?>
								<td><?= !empty($value->new->payment_date) ? date('d/m/Y', strtotime($value->new->payment_date)) : "" ?></td>
								<td><?= !empty($value->new->amount_payment_appointment) ? $value->new->amount_payment_appointment : "" ?></td>
								<?php if (!empty($value->new->note_reminder)): ?>
									<td><?php echo !empty($value->new->note_reminder->note) ? ($value->new->note_reminder->note) : '' ?></td>
								<?php else: ?>
									<td><?= !empty($value->new->note) ? $value->new->note : "" ?></td>
								<?php endif; ?>
							</tr>
						<?php }
					} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/accountant/index.js"></script>

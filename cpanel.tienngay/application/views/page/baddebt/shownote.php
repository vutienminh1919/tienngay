<div class="right_col" role="main">
	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>Quản lý HĐ vay
						<br>
						<small><a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>/ <a href="#">Quản lý HĐ vay</a></small>
					</h3>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<div class="x_panel">
				<a href="<?php echo base_url('badDebt') ?>" class="btn btn-info "  style="float: right"><i class="fa fa-arrow-left"></i> Back</a>
			<br>
			<h3>
				Ghi chú <br>
			</h3>
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group">
						<label>Kết quả nhắc HĐ vay:</label>
						<select class="form-control result_reminder" name="note_renewal" id="note_renewal">
							<?php foreach (note_renewal() as $key => $value) { ?>
								<option value="<?= $key ?>"><?= $value ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label>Ngày hẹn thanh toán:</label>
						<input type="date" name="payment_date" class="form-control payment_date" name="payment_date">
					</div>
					<div class="form-group">
						<label>Số tiền hẹn thanh toán:</label>
						<input type="text" class="form-control amount_payment_appointment" name="amount_payment_appointment">
					</div>
					<div class="form-group">
						<label>Ghi chú:</label>
						<textarea class="form-control contract_v2_note" rows="5"></textarea>
						<input type="hidden" value="<?= (isset($_GET['id'])) ? $_GET['id'] : "" ?>"
							   class="form-control contract_id">
					</div>

					<p class="text-right">
						<button class="btn btn-danger approve_submit">Lưu</button>
					</p>
				</div>
			</div>
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
					if (!empty($contractDB->result_reminder)) {
						foreach ($contractDB->result_reminder as $key => $value) {
							?>
							<tr>
								<td><?php echo $key + 1 ?></td>
								<td><?= !empty($value->created_at) ? date('d/m/Y H:i:s', intval($value->created_at)) : "" ?></td>
								<td><?= !empty($value->created_by) ? $value->created_by : "" ?></td>
								<td><?php foreach (note_renewal() as $k => $v) { ?>
										<?php if($k == $value->reminder){echo $v;}?>
									<?php } ?>
								</td>
								<td><?= !empty($value->payment_date) ?gmdate("d-m-Y", $value->payment_date) : "" ?></td>
								<td><?= !empty($value->amount_payment_appointment) ? $value->amount_payment_appointment: "" ?></td>
								<td><?= !empty($value->note) ? $value->note : "" ?></td>
							</tr>
						<?php }
					} ?>
					</tbody>
				</table>
			</div>
		</div></div>
	</div>
</div>
<script src="<?php echo base_url(); ?>assets/js/baddebt/index.js"></script>

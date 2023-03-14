
<!-- page content -->
<div class="right_col" role="main">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<div class="col-xs-12 col-lg-1">
					<h2>Chi tiết giao dịch nạp tiền tài xế HeyU</h2>
				</div>
				<div class="title_right text-right">
					<a href="<?php echo base_url('transaction/approveTransactionHeyU?tab=all')?>" class="btn btn-info ">
						<i class="fa fa-hand-o-left" aria-hidden="true"></i> Quay lại
					</a>
				</div>

				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="col-xs-12">
						<div class="row">

						</div>
					</div>
					<div class="col-xs-12">
						<div class="table-responsive">
							<table class="table table-bordered m-table table-hover table-calendar table-report ">
								<thead style="background:#3f86c3; color: #ffffff;">
								<tr>
									<th>#</th>
									<th><?php echo $this->lang->line('transaction_code')?></th>
									<th><?php echo $this->lang->line('Service')?></th>
									<th><?php echo $this->lang->line('time')?></th>
									<th>Giao dịch viên</th>
									<th>Mã tài xế</th>
									<th>Tên tài xế</th>
									<th><?php echo $this->lang->line('status')?></th>
									<th><?php echo $this->lang->line('Amount_money')?></th>
									<th>Phòng giao dịch</th>
								</tr>
								</thead>
								<tbody>
								<?php
								if(!empty($heyUData)){
									foreach($heyUData as $key => $heyu){
										?>
										<tr class="<?php echo isset($heyu->error) && $heyu->error == 'true' ? 'warning-transaction' : ''?>">
											<td><?php echo $key + 1?></td>
											<td><?= !empty($heyu->transaction_code) ? $heyu->transaction_code : "" ?></td>
											<td>Nạp tiền tài xế HeyU</td>
											<td><?= !empty($heyu->created_at) ? date('d/m/Y H:i:s', intval($heyu->created_at) ) : "" ?></td>
											<td><?= !empty($heyu->created_by) ? $heyu->created_by : "" ?></td>
											<td><?= !empty($heyu->code_driver) ? $heyu->code_driver : "" ?></td>
											<td><?= !empty($heyu->name_driver) ? $heyu->name_driver : "" ?></td>
											<td>
												<?php if ($heyu->status == 10) : ?>
													<span class="label label-info">Khách hàng đã đóng</span>
												<?php elseif ($heyu->status == 2): ?>
													<span
															class="label label-default">Chờ kế toán xác nhận</span>
												<?php elseif ($heyu->status == 3): ?>
													<span
															class="label label-danger">Kế toán hủy</span>
												<?php elseif ($heyu->status == 1): ?>
													<span class="label label-success">Kế toán đã duyệt</span>
												<?php elseif ($heyu->status == 11): ?>
													<span class="label label-warning">Kế toán trả về</span>
												<?php endif; ?>
											</td>
											<td><?= !empty($heyu->money) ? number_format($heyu->money ,0 ,',' ,',') : ""?></td>
											<td><?= !empty($heyu->store->name) ? $heyu->store->name : "" ?></td>
										</tr>
									<?php }
								} ?>
								</tbody>
								<tfoot>
								<tr>
									<td colspan="7"></td>
									<td>
										<strong>
											<?php echo $this->lang->line('Total_money')?>
										</strong>
									</td>
									<td colspan="3">
										<strong>
											<?php echo number_format($transaction->total ,0 ,',' ,',')?> đ
										</strong>
									</td>
									
								</tr>
								</tfoot>
							</table>
						</div>
						<?php if($transaction->status != 1 && !empty($transaction->reasons)) {?>
				        <div class="row">
				            <div class="form-group">
				              <label>Lý do:</label>
								<?php foreach ($transaction->reasons as $value): ?>
									<div class="form-check">
				  					<input class="form-check-input" type="checkbox" name="reason" value="<?= $value->id ?>" id="reason<?= $value->id ?>" checked disabled>
									  <label class="form-check-label" for="reason<?= $value->id ?>" style="color: red;">
									    <?= $value->value ?>
									  </label>
									</div>
								<?php endforeach ?>
				            </div>
				        </div>
				        <?php } ?>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->


<!-- page content -->
<div class="right_col" role="main">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<div class="col-xs-12 col-lg-1">
					<h2>Chi tiết giao dịch bảo hiểm GIC Easy</h2>
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
									<th>Nhân viên nộp</th>
									<th>Tên khách hàng</th>
									<th>Biển số xe</th>
									<th><?php echo $this->lang->line('status')?></th>
									<th><?php echo $this->lang->line('Amount_money')?></th>
								</tr>
								</thead>
								<tbody>
								<?php
								if(!empty($gic_easy)){
									foreach($gic_easy as $key => $mic){
										?>
										<tr class="<?php echo isset($mic->error) && $mic->error == 'true' ? 'warning-transaction' : ''?>">
											<td><?php echo $key + 1?></td>
											<td><?= !empty($mic->gic_code) ? $mic->gic_code : "" ?></td>
											<td>Bảo hiểm Mic TNDS</td>
											<td><?= !empty($mic->created_at) ? date('d/m/Y H:i:s', intval($mic->created_at) ) : "" ?></td>
											<td><?= !empty($mic->created_by) ? $mic->created_by : "" ?></td>
											<td><?= !empty($mic->customer_info->customer_name) ? $mic->customer_info->customer_name : "" ?></td>
											<td><?= !empty($mic->license_plates) ? $mic->license_plates : "" ?></td>
											<td>
												<?php if ($mic->status == 10) : ?>
													<span class="label label-info">PGD đã thu tiền</span>
												<?php elseif ($mic->status == 2): ?>
													<span class="label label-default">Chờ kế toán xác nhận</span>
												<?php elseif ($mic->status == 1): ?>
													<span class="label label-success">Kế toán đã duyệt</span>
												<?php elseif ($mic->status == 11): ?>
													<span class="label label-warning">Kế toán trả về</span>
												<?php elseif ($mic->status == 3): ?>
													<span class="label label-danger">Kế toán hủy</span>
												<?php endif; ?>
											</td>
											<td><?= !empty($mic->price) ? number_format($mic->price ,0 ,',' ,',') : ""?></td>

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
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->

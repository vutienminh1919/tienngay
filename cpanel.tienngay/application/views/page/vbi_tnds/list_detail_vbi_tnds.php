
<!-- page content -->
<div class="right_col" role="main">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<div class="col-xs-12 col-lg-1">
					<h2>Chi tiết giao dịch bảo hiểm Vbi TNDS</h2>
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
								if(!empty($vbi_tnds)){
									foreach($vbi_tnds as $key => $vbi){
										?>
										<tr class="<?php echo isset($vbi->error) && $vbi->error == 'true' ? 'warning-transaction' : ''?>">
											<td><?php echo $key + 1?></td>
											<td><?= !empty($vbi->code) ? $vbi->code : "" ?></td>
											<td>Bảo hiểm Vbi TNDS</td>
											<td><?= !empty($vbi->created_at) ? date('d/m/Y H:i:s', intval($vbi->created_at) ) : "" ?></td>
											<td><?= !empty($vbi->created_by) ? $vbi->created_by : "" ?></td>
											<td><?= !empty($vbi->customer_info->customer_name) ? $vbi->customer_info->customer_name : "" ?></td>
											<td><?= !empty($vbi->customer_info->bien_xe) ? $vbi->customer_info->bien_xe : "" ?></td>
											<td>
												<?php if ($vbi->status == 10) : ?>
													<span class="label label-info">PGD đã thu tiền</span>
												<?php elseif ($vbi->status == 2): ?>
													<span
														class="label label-default">Chờ kế toán xác nhận</span>
												<?php elseif ($vbi->status == 1): ?>
													<span class="label label-success">Kế toán đã duyệt</span>
												<?php elseif ($vbi->status == 11): ?>
													<span class="label label-warning">Kế toán trả về</span>
												<?php endif; ?>
											</td>
											<td><?= !empty($vbi->fee) ? number_format($vbi->fee ,0 ,',' ,',') : ""?></td>

										</tr>
									<?php }
								} ?>
								</tbody>
								<tfoot>
								<tr>
									<td colspan="7">
										<strong>
											<?php 
											echo ($coupon_cash->note) ? $coupon_cash->note : "";
											?> 
										</strong>
									</td>
									<td>
										<strong>
											Mã giảm trừ
										</strong>
									</td>
									<td colspan="3">
										<strong>
											<?php 
											echo ($coupon_cash->code) ? $coupon_cash->code : "";
											?> 
										</strong>
									</td>
								</tr>
										<tr>
									<td colspan="7"></td>
									<td>
										<strong>
											Số tiền giảm trừ
										</strong>
									</td>
									<td colspan="3">
										<strong>
											<?php 
											$percent_reduction=($coupon_cash->percent_reduction) ? $coupon_cash->percent_reduction : 0;
											$gt=($transaction->total*(int)$percent_reduction)/100;
											$total=$transaction->total-$gt;
											echo number_format($gt ,0 ,',' ,',');
											?> đ
										</strong>
									</td>
								</tr>
								<tr>
									<td colspan="7"></td>
									<td>
										<strong>
											<?php echo $this->lang->line('Total_money')?>
										</strong>
									</td>
									<td colspan="3">
										<strong>
											<?php echo number_format( $total,0 ,',' ,',')?> đ
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
<style type="text/css">
	.table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
    border: 1px solid #ddd;
    white-space: initial;
}
</style>
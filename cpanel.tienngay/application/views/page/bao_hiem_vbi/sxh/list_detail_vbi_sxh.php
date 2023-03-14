<!-- page content -->
<div class="right_col" role="main">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<div class="col-xs-12 col-lg-1">
					<h2>Chi tiết giao dịch bảo hiểm Vbi Sốt xuất huyết</h2>
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
									<th><?php echo $this->lang->line('time')?></th>
									<th>Số hợp đồng bảo hiểm</th>
									<th><?php echo $this->lang->line('Service')?></th>
									<th>Nhân viên nộp</th>
									<th>Tên khách hàng</th>
									<th>Gói bảo hiểm</th>
									<th><?php echo $this->lang->line('status')?></th>
									<th><?php echo $this->lang->line('Amount_money')?></th>
									<th>Ngày hiệu lực/Ngày hết hạn</th>
								</tr>
								</thead>
								<tbody>
								<?php
								if(!empty($vbi_sxh)){
									foreach($vbi_sxh as $key => $vbi){
										?>
										<tr class="<?php echo isset($vbi->error) && $vbi->error == 'true' ? 'warning-transaction' : ''?>">
											<td><?php echo $key + 1?></td>
											<td><?= !empty($vbi->code) ? $vbi->code : "" ?></td>
											<td><?= !empty($vbi->created_at) ? date('d/m/Y H:i:s', intval($vbi->created_at) ) : "" ?></td>
											<td><?= !empty($vbi->vbi_sxh) ? $vbi->vbi_sxh->so_hd : "" ?></td>
											<td>Bảo hiểm Vbi Sốt xuất huyết</td>
											<td><?= !empty($vbi->created_by) ? $vbi->created_by : "" ?></td>
											<td><?= !empty($vbi->customer_info->customer_name) ? $vbi->customer_info->customer_name : "" ?></td>
											<td><?= !empty($vbi->goi_bh) ? $vbi->goi_bh : "" ?></td>
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
											<td><?php if (!empty($vbi->NGAY_HL) && !empty($vbi->NGAY_KT)) {
													$date_start = strtotime($vbi->NGAY_HL);
													$date_end = strtotime($vbi->NGAY_KT);
													echo date('d/m/Y', $date_start) . ' - ' . date('d/m/Y', $date_end);
												}?>
											</td>
										</tr>
									<?php }
								} ?>
								</tbody>
								<tfoot>
								<tr>
									<td colspan="9"></td>
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

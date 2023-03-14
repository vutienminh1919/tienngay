<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="row">
		<div class="col-xs-12">

			<div class="page-title">
				<div class="title_left">
					<h3>Thêm mới giao dịch đóng tiền</h3>
				</div>
				<div class="title_right text-right">
					<a href="<?php echo base_url() ?>vbi_tnds/index?tab=transaction" class="btn btn-info">
						<i class="fa fa-chevron-left" aria-hidden="true"></i>
						Trở lại
					</a>
				</div>
			</div>
		</div>


		<div class="col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<div class="" role="tabpanel" data-example-id="togglable-tabs">
						<!--						<form method="post" action="-->
						<?php //echo base_url() ?><!--heyU/create_transaction">-->
						<div class="table-responsive" style="overflow-y: auto">
							<table class="table table-bordered m-table table-hover table-calendar table-report ">
								<thead style="background:#3f86c3; color: #ffffff;">
								<tr>
									<th style="width:32px"><input type="checkbox" name="all_vbi_tnds" value=""
																  id="selectAll"></th>
									<th style="text-align: center">Mã giao dịch</th>
									<th style="text-align: center">Tên khách hàng</th>
									<th style="text-align: center">Thời gian nộp tiền</th>
									<th style="text-align: center">Số điện thoại</th>
									<th style="text-align: center">Mệnh giá</th>
									<th style="text-align: center">Người giao dịch</th>
									<th style="text-align: center">Địa điểm giao dịch</th>
									<th style="text-align: center">Trạng thái</th>
								</tr>
								</thead>

								<tbody>
								<?php foreach ($vbi_tnds as $key => $value) { ?>
									<tr style="text-align: center">
										<th style="width:32px"><input type="checkbox" name="vbi_tnds[]"
																	  value="<?php echo $value->code ?>"
																	  class="vbiCheckBox"></th>
										<td><?= !empty($value->code) ? $value->code : "" ?></td>
										<td><?= !empty($value->customer_info->customer_name) ? $value->customer_info->customer_name : "" ?></td>
										<td><?= !empty($value->created_at) ? date('d/m/Y H:i:s', $value->created_at) : "" ?></td>
										<td><?= !empty($value->customer_info->customer_phone) ? $value->customer_info->customer_phone : "" ?></td>
										<td><?= !empty($value->fee) ? number_format($value->fee) . " VND" : 0?></td>
										<td><?= !empty($value->created_by) ? $value->created_by : "" ?></td>
										<td><?= !empty($value->store->name) ? $value->store->name : "" ?></td>
										<td><?php if ($value->status == 10) : ?>
												<span class="label label-info">PGD đã thu tiền</span>
											<?php elseif ($value->status == 11) : ?>
												<span class="label label-warning">Kế toán trả về</span>
											<?php endif; ?>

										</td>
									</tr>
								<?php } ?>
								</tbody>
								<tfooter>
									<tr>
										<th colspan="2" style="text-align: center">
											Tổng cộng:
										</th>
										<td colspan="7" class="text-center" style="text-align: center">
											<div class="text-danger"><?php echo number_format($total_money) . " VND" ?></div>
										</td>
									</tr>
									<tr>
										<th colspan="2" style="text-align: center">
											Tổng tiền chuyển KT:
										</th>
										<td colspan="7" class="text-center" style="text-align: center">
											<div class="text-danger" id="total_money">0 VND</div>
										</td>
									</tr>
								</tfooter>
							</table>
						</div>

						<div>
							<nav class="text-right">
								<div class="row">
										
						<div class="form-group col-lg-6">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">
									Loại khách<span class="text-danger">*</span>
								</label>
								<div class="col-lg-6 col-sm-12 col-xs-12 ">
									<div class="radio-inline text-primary">
										<label>
											<input type="radio" name="loai_khach" value="BN" checked="checked"
												   > Bán ngoài
										</label>
									</div>
									<div class="radio-inline text-danger">
										<label>
											<input type="radio" name="loai_khach" value="NB" > Nội bộ
										</label>
									</div>
								</div>
							</div>
					
									<div class="col-xs-12 col-md-2">
										<label class="control-label text-danger">Phòng giao dịch:</label>
										<select name="store" class="form-control">
											<?php foreach ($stores as $store) :
												if (in_array($store->_id->{'$oid'}, $storeDataCentral)) continue;?>
												<option value="<?php echo $store->_id->{'$oid'} ?>"><?php echo $store->name ?></option>
											<?php endforeach; ?>
										</select>


									</div>
								</div>
								<hr>
								<button class="btn btn-success" id="submit_payment">
									<i class="fa fa-save"></i>
									Gửi yêu cầu
								</button>
							</nav>
						</div>
						<!--						</form>-->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->
<script src="<?php echo base_url() ?>assets/js/vbi_tnds/sendKT.js"></script>


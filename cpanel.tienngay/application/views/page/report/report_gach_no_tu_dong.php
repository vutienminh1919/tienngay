<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="row top_tiles">
		<div class="col-xs-9">
			<div class="page-title">
				<div class="title_left" style="width: 100%">
					<h3> Báo cáo
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a href="#">
								Báo cáo gạch thanh toán tự động</a>
						</small>
					</h3>
					<div class="alert alert-danger alert-result" id="div_error"
						 style="display:none; color:white;"></div>
				</div>
			</div>
		</div>
		<div class="col-xs-3">

		</div>
		<div class="col-xs-12">
			<div class="row mb-3">
				<form action="<?php echo base_url('report_kt/report_gach_no_tu_dong') ?>" method="get" style="width: 100%;">
					<div class="col-md-2">
						<label>Ngân hàng</label>
						<select class="form-control" name="bank">
							<option value="">-- Chọn ngân hàng --</option>
							<option value="VCB" <?=$bank == 'VCB' ? 'selected' : ''?>>Vietcombank</option>
							<option value="TCB" <?=$bank == 'TCB' ? 'selected' : ''?>>Techcombank</option>
						</select>
					</div>
					<div class="col-md-2">
						<label>Mã giao dịch</label>
						<input class="form-control" placeholder="Mã giao dịch" name="code" value="<?=$code?>">
					</div>
					<div class="col-md-2">
						<label>Mã phiếu thu</label>
						<input class="form-control" placeholder="Mã phiếu thu" name="contract_code" value="<?=$contract_code?>">
					</div>
					<div class="col-md-2">
						<label>Trạng thái</label>
						<select class="form-control" name="status">
							<option value="">-- Trạng thái --</option>
							<option value="1" <?=$status == '1' ? 'selected' : ''?>>Gạch thành công</option>
							<option value="0" <?=$status == '0' ? 'selected' : ''?>>Thất bại</option>
						</select>
					</div>
					<div class="col-md-2">
						<label>Ngày thanh toán từ ngày</label>
						<input type="date" class="form-control" placeholder="Từ ngày" name="fromdate" value="<?=$fromdate?>">
					</div>

					<div class="col-md-2">
						<label>Ngày thanh toán đến ngày</label>
						<input type="date" class="form-control" placeholder="Đến ngày" name="todate" value="<?=$todate?>">
					</div>
					<div class="col-lg-2 text-right">
						<label></label>
						<button type="submit" class="btn btn-primary w-100"><i class="fa fa-search"
																			   aria-hidden="true"></i> <?= $this->lang->line('search') ?>
						</button>
					</div>
					<div class="col-lg-2 text-right">
						<label></label>
						<a href="report_gach_no_tu_dong_excel?<?=$_SERVER['QUERY_STRING']?>" class="btn btn-primary w-100">Export
						</a>
					</div>
				</form>
			</div>
			<div class="table-responsive">
				<table id="datatable-button" class="table table-striped">
					<thead>
					<tr>
						<th>Ngân hàng</th>
						<th>Mã phiếu ghi</th>
						<th>Mã phiếu thu</th>
						<th>Mã giao dịch</th>
						<th>Số tiền thanh toán</th>
						<th>Nội dung giao dịch</th>
						<th>Ngày thanh toán</th>
						<th>Trạng thái</th>
						<th>Ghi chú</th>
						<th></th>
					</tr>
					</thead>
					<tbody>
					<?php foreach($report as $key => $item) { ?>
						<tr>
							<td><?=$item->bank?></td>
							<td><?=$item->contract_code?></td>
							<td><?=$item->transaction->code?></td>
							<td><?=$item->code?></td>
							<td><?=number_format($item->money)?></td>
							<td><?=$item->content?></td>
							<td><?=date('d/m/Y',$item->date)?></td>
							<td>
								<?php
									if ( $item->status == 1 ) {
										echo "Gạch Thành công";
										if ( $item->transaction->status == 1 ) {
											echo " - Kế toán đã duyệt";
										} else if ( $item->transaction->status == 2 ) {
											echo " - Kế toán chờ duyệt";
										} else if ( $item->transaction->status == 3 ) {
											echo " - Kế toán đã hủy";
										} else if ( $item->transaction->status == 4 ) {
											echo " - Chưa gửi Kế toán duyệt";
										} else if ( $item->transaction->status == 11 ) {
											echo " - Kế toán trả về";
										}
									} else {
										if ( $item->transaction->status == 1 ) {
											echo "Kế toán đã duyệt";
										} else if ( $item->transaction->status == 2 ) {
											echo "Kế toán chờ duyệt";
										} else if ( $item->transaction->status == 3 ) {
											echo "Kế toán đã hủy";
										} else if ( $item->transaction->status == 4 ) {
											echo "Chưa gửi Kế toán duyệt";
										} else if ( $item->transaction->status == 11 ) {
											echo "Kế toán trả về";
										} else {
											echo "Cập nhật sao kê";
										}
									}
								?>
							</td>
							<td><?=$item->ghi_chu?></td>
							<td>
								<?php if ( !isset($item->transaction) && (in_array('thu-hoi-no', $groupRoles) || in_array('giao-dich-vien', $groupRoles)) ) { ?>
									<a class="btn btn-primary show-model" data-id="<?= $item->_id->{'$oid'} ?>" href="javascript:void(0);">Cập nhật sao kê</a>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
				<?= $pagination ?>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Cập nhật sao kê</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" id="id_update">
				<input class="form-control mb-3" placeholder="Mã phiếu ghi" id="ma_phieu_ghi">
				<input class="form-control mb-3" placeholder="Ghi chú" id="ghi_chu">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary transaction-change">Cập nhật</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	$('.show-model').on('click', function () {
		$('#myModal').modal('show');
		$('#id_update').val($(this).data('id'));
		$('#ma_phieu_ghi').val('');
		$('#ghi_chu').val('');
	});

	$('.transaction-change').on('click', function(){
		var formData = {
			id: $('#id_update').val(),
			ma_phieu_ghi: $('#ma_phieu_ghi').val(),
			ghi_chu: $('#ghi_chu').val(),
		};
		$.ajax({
			url: "/report_kt/action_transaction_change",
			type: "POST",
			data: formData,
			success: function (res) {
				res = JSON.parse(res);
				console.log(res);
				if (res.status == 200) {
					alert("Tạo sao kê thành công")
					window.open('<?= base_url('transaction/sendApprove'). '?view=QLHDV&id=' ?>' + res.data);
					window.location.reload();
				} else {
					alert(res.message)
				}
			},
			error: function (res) {
				alert("Lỗi hệ thống");
			}
		});
	});
</script>

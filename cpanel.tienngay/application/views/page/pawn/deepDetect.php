<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"/>
<div class="modal-contract-deepDetect">
	<div id="contract_deepDetect" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg">
			<!-- Modal content-->
			<span class="loading-modal-contract-deepDetect" style="display: none">
		 			<i class="fa fa-cog  fa-spin fa-3x fa-fw"></i> Đang tìm kiếm
	 		</span>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Hợp đồng có thể liên quan <span class="text-danger">Thử nghiệm</span></h4>
				</div>
				<div class="modal-body">
					<h4 class="modal-title">Thông tin nhận dạng</h4>
					<table class="table table-bordered">
						<thead>
						<tr>
							<th>Hình ảnh</th>
							<th>Họ tên</th>
							<th>Mã Hợp Đồng</th>
							<th>Số Tiền Vay</th>
							<th>Phòng Giao Dịch</th>
							<th>Trạng Thái</th>
						</tr>
						</thead>
						<tbody>
						<tr style="text-align: center">
							<td>
								<a href="<?php echo $contractInfor->customer_infor->img_portrait ?? '' ?>"
								   data-fancybox='gallery'>
									<img src="<?php echo $contractInfor->customer_infor->img_portrait ?? '' ?>"
										 style="width: 100px;height: 100px">
								</a>
							</td>
							<td><?php echo $contractInfor->customer_infor->customer_name ?? '' ?></td>
							<td><?php echo $contractInfor->code_contract_disbursement ?? '' ?></td>
							<td><?php echo !empty($contractInfor->loan_infor->amount_money) ? number_format($contractInfor->loan_infor->amount_money) : '' ?></td>
							<td><?php echo $contractInfor->store->name ?? '' ?></td>
							<td><?php echo contract_status($contractInfor->status) ?></td>
						</tr>
						</tbody>
					</table>
					<hr>
					<h4 class="modal-title">Kết quả tìm kiếm</h4>
					<table class="table table-bordered">
						<thead>
						<tr>
							<th>Hình ảnh</th>
							<th>Tỉ lệ</th>
							<th>Họ tên</th>
							<th>Mã Hợp Đồng</th>
							<th>Số Tiền Vay</th>
							<th>Phòng Giao Dịch</th>
							<th>Trạng Thái</th>
						</tr>
						</thead>
						<tbody class="data_deepDetect" id="data_deepDetect">

						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>
</div>
<style>
	.modal-contract-deepDetect .loading-modal-contract-deepDetect {
		position: absolute;
		z-index: 10;
		background-color: rgba(0, 0, 0, 0.5);
		display: flex;
		justify-content: center;
		align-items: center;
		color: white;
		width: 100%;
		height: 100%;
	}

	.modal-contract-deepDetect .loading-modal-contract-deepDetect i.fa {
		width: 38px;
		height: 38px;
		text-align: center;
	}

</style>

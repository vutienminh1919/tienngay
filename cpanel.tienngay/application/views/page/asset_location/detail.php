<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"/>

<div class="right_col" role="main">
	<div class="container container-xt">
		<div class="containerTop">
			<h3>Chi tiết thiết bị</h3>
		</div>
		<div class="containerForm-text">
			<h3>Thông tin thiết bị</h3>
			<div class="content">
				<div class="row">
					<div class="col-md-2 bol">
						<p> Mã Seri </p>
					</div>
					<div class="col-md-10 bol"><span><?php echo $device->code ?? "" ?></span></div>
				</div>
				<div class="row">
					<div class="col-md-2 bol">
						<p>Trạng thái </p>
					</div>
					<div class="col-md-10 bol">
						<span style="color:#1D9752 ;">
							<?php if ($device->status == 1): ?>
								Thiết bị mới
							<?php elseif ($device->status == 2) : ?>
								Thiết bị cũ
							<?php elseif ($device->status == 3) : ?>
								Thiết bị đang sử dụng
							<?php else : ?>
								Trạng thái khác
							<?php endif; ?>
						</span>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2 bol">
						<p>Ngày mua mới </p>
					</div>
					<div class="col-md-10 bol">
						<span><?php echo date('d/m/Y', $device->storage_date) ?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2 bol">
						<p>Thời hạn bảo hành </p>
					</div>
					<div class="col-md-10 bol">
						<span>12 tháng</span>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2 bol">
						<p>Giá trị mua mới </p>
					</div>
					<div class="col-md-10 bol">
						<span><?php echo number_format($device->import_price) ?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2 bol">
						<p>Chi phí sử dụng </p>
					</div>
					<div class="col-md-10 bol">
						<span>0</span>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2 bol">
						<p>Tổng giá trị sử dụng </p>
					</div>
					<div class="col-md-10 bol">
						<span><?php echo number_format($device->import_price) ?></span>
					</div>
				</div>

			</div>
		</div>
	</div>
	<div class="panel">
		<h3>Lịch sử sử dụng</h3>
		<div class="form-table table-responsive">
			<table class="table">
				<thead class="thead-light">
				<tr>
					<th scope="col">STT</th>
					<th scope="col">Ngày sử dụng</th>
					<th scope="col">Ngày thu hồi</th>
					<th scope="col">HĐSD</th>
					<th scope="col">Biển số xe</th>
					<!--					<th scope="col">Chi phí sử dụng</th>-->
					<th scope="col">Tên khách hàng</th>
					<th scope="col">Phòng giao dịch</th>
					<th scope="col">Ảnh đính kèm</th>
				</tr>
				</thead>
				<tbody class="tbody-line">
				<?php foreach ($log_contract as $k => $v): ?>
					<tr>
						<th scope="row"><?php echo ++$key ?></th>
						<td><?php echo date('d/m/Y', $v->created_at) ?></td>
						<td><?php echo !empty($v->recall_date) ? date('d/m/Y', $v->recall_date) : "" ?></td>
						<td>
							<a href="<?php echo base_url("pawn/detail?id=") . $v->contract->_id ?>"
							   target="_blank"><?php echo $v->code_contract_disbursement ?? "" ?></a>
						</td>
						<td><?php echo $v->license_plates ?? "" ?></td>
						<!--						<td>600000</td>-->
						<td><?php echo $v->customer_name ?? "" ?></td>
						<td><?php echo $v->store->name ?? "" ?></td>
						<td>
							<a data-fancybox="gallery"
							   href="<?php echo $v->device_asset_location->imgInpDevice_show ?? "" ?>">
								Xem ảnh
							</a>
							<img class="theavatar" src="<?php echo base_url("assets/imgs/ql_xnt/eys.svg") ?>" alt="">
						</td>
					</tr>
				<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
</div>
<style>
	* {
		margin: 0;
		padding: 0;
		box-sizing: border-box;
	}

	.container-xt {
		width: 100%;
		display: flex;
		flex-direction: column;
		gap: 24px;
	}

	.containerForm-text {
		padding: 0px 0px 16px;
		width: 100%;
		height: 352px;
		background: #FFFFFF;
		border: 1px solid #EBEBEB;
		box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
		border-radius: 8px;
		padding-left: 16px;

	}

	.containerForm-text h3 {
		font-style: normal;
		font-weight: 600;
		font-size: 20px;
		line-height: 24px;
	}

	.containerForm-text p {
		font-style: normal;
		font-weight: 400;
		font-size: 14px;
		line-height: 16px;
		display: flex;
		align-items: center;
		color: #8C8C8C;
	}

	.containerForm-text span {
		font-style: normal;
		font-weight: 600;
		font-size: 14px;
		line-height: 16px;
		display: flex;
		align-items: center;
		color: rgba(103, 103, 103, 1);
	}

	.content {
		display: flex;
		flex-direction: column;
		gap: 16px;
	}

	.bol {
		border-bottom: 1px solid rgba(232, 232, 232, 1);
	}

	.containerForm-table {
		padding: 0px 0px 16px;
		width: 100%;
		height: 352px;
		background: #FFFFFF;
		border: 1px solid #EBEBEB;
		box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
		border-radius: 8px;
	}

	.containerForm-table h3 {
		padding-left: 16px;
		font-style: normal;
		font-weight: 600;
		font-size: 20px;
		line-height: 24px;
		color: rgba(59, 59, 59, 1);
	}

	.thead-light {
		font-style: normal;
		font-weight: 500;
		font-size: 14px;
		line-height: 16px;
		color: #262626;
	}

	.tbody-line {
		font-style: normal;
		font-weight: 500;
		font-size: 14px;
		line-height: 16px;
		color: rgba(103, 103, 103, 1);
	}
</style>

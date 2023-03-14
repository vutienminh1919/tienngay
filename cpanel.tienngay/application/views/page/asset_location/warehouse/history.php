<div class="right_col" role="main">
	<div class="container container-xt">
		<div class="wrapper-top">
			<div class="">
				<h3>Quản lý chi tiết xuất nhập tồn - Thiết bị định vị</h3>
			</div>
		</div>
		<div class="content-cart">
			<!--			<h5>Báo cáo tháng 8</h5>-->
			<!--			<div class="container-cart">-->
			<!--				<div class="cart-input">-->
			<!--					<p>Thời gian </p>-->
			<!--					<input placeholder="Từ ngày" class="textbox-n" type="text" onfocus="(this.type='date')" id="date">-->
			<!--					<input placeholder="Từ ngày" class="textbox-n" type="text" onfocus="(this.type='date')" id="date">-->
			<!--				</div>-->
			<!--				<div class="cart-item">-->
			<!--					<p>Số lượng nhập</p>-->
			<!--					<h5>169</h5>-->
			<!--					<h6 class="cardItem-text">Đơn giá <span>200000 vnđ</span></h6>-->
			<!--					<h6 class="cardItem-text">Thành tiền <span>200000 vnđ</span></h6>-->
			<!--				</div>-->
			<!--				<div class="cart-item">-->
			<!--					<p>Số lượng xuất</p>-->
			<!--					<h5>169</h5>-->
			<!--					<h6 class="cardItem-text">Đơn giá <span>200000 vnđ</span></h6>-->
			<!--					<h6 class="cardItem-text">Thành tiền <span>200000 vnđ</span></h6>-->
			<!--				</div>-->
			<!--				<div class="cart-item">-->
			<!--					<p>Số lượng tồn </p>-->
			<!--					<h5>169</h5>-->
			<!--					<h6 class="cardItem-text">Đơn giá <span>200000 vnđ</span></h6>-->
			<!--					<h6 class="cardItem-text">Thành tiền <span>200000 vnđ</span></h6>-->
			<!--				</div>-->
			<!--			</div>-->
		</div>
		<div class="panel">
			<div class="form-text">
				<h5>Chi tiết xuất nhập tồn</h5>
				<div class="form-button">
					<!--					<button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#exampleModal">Tìm kiếm <img class="theavatar" src="-->
					<?php //echo base_url("assets/imgs/ql_xnt/search.svg") ?><!--" alt=""></button>-->
					<a type="button" class="btn btn-outline-success"
					   href="<?php echo base_url("assetLocation/excel_history") ?>" target="_blank">Xuất excel <img
								class="theavatar" src="
					<?php echo base_url("assets/imgs/ql_xnt/excel.svg") ?>" alt=""></a>

					<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
						 aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Tìm kiếm</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<div class="modal-item">
										<p>Thời gian </p>
										<div class="modal-content11">
											<input placeholder="Từ ngày" class="textbox-n" type="text"
												   onfocus="(this.type='date')" id="date">
											<input placeholder="Đến ngày" class="textbox-n" type="text"
												   onfocus="(this.type='date')" id="date">
										</div>
									</div>
									<div class="modal-item">
										<p>Loại giao dịch</p>
										<select required>
											<option value="" disabled selected hidden>Loại giao dịch</option>
											<option value="0">Phòng giao dịch 1</option>
											<option value="1">Phòng giao dịch 2</option>
										</select>
									</div>
									<div class="modal-item">
										<p>Công ty</p>
										<select required>
											<option value="" disabled selected hidden>Chọn công ty</option>
											<option value="0">Phòng giao dịch 1</option>
											<option value="1">Phòng giao dịch 2</option>
										</select>
									</div>
									<div class="modal-item">
										<p>Kho khu vực</p>
										<select required>
											<option value="" disabled selected hidden>Chọn kho</option>
											<option value="0">Phòng giao dịch 1</option>
											<option value="1">Phòng giao dịch 2</option>
										</select>
									</div>
									<div class="modal-item">
										<p>Phòng giao dịch</p>
										<select required>
											<option value="" disabled selected hidden>Chọn phòng giao dịch</option>
											<option value="0">Phòng giao dịch 1</option>
											<option value="1">Phòng giao dịch 2</option>
										</select>
									</div>
									<div class="modal-item">
										<p>Mã giao dịch </p>
										<input type="text" placeholder="Nhập mã giao dịch">
									</div>
									<div class="modal-item">
										<p>Nhà cung cấp</p>
										<select required>
											<option value="" disabled selected hidden>Chọn nhà cung cấp</option>
											<option value="0">Phòng giao dịch 1</option>
											<option value="1">Phòng giao dịch 2</option>
										</select>
									</div>

									<div class="modal-item">
										<p>SL nhập</p>
										<div class="modal-content11">
											<input placeholder="Từ " type="number">
											<input placeholder="Đến" type="number">
										</div>
									</div>
									<div class="modal-item">
										<p>SL xuất</p>
										<div class="modal-content11">
											<input placeholder="Từ " type="number">
											<input placeholder="Đến" type="number">
										</div>
									</div>
									<div class="modal-item">
										<p>SL tồn cuối</p>
										<div class="modal-content11">
											<input placeholder="Từ " type="number">
											<input placeholder="Đến" type="number">
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
									<button type="button" class="btn btn-primary" data-dismiss="modal">Tìm kiếm</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="form-table table-responsive">
				<table class="table">
					<thead class="thead-light">
					<tr>
						<th scope="col" style="text-align: center">STT</th>
						<th scope="col" style="text-align: center">Ngày giao dịch</th>
						<th scope="col" style="text-align: center">Tên NCC</th>
						<th scope="col" style="text-align: center">Tên kho</th>
						<th scope="col" style="text-align: center">Loại giao dịch</th>
						<th scope="col" style="text-align: center">SL nhập</th>
						<th scope="col" style="text-align: center">Đơn giá nhập</th>
						<th scope="col" style="text-align: center">SL xuất</th>
						<th scope="col" style="text-align: center">Đơn giá xuất</th>
						<th scope="col" style="text-align: center">SL chuyển</th>
						<th scope="col" style="text-align: center">Đơn giá chuyển</th>
						<th scope="col" style="text-align: center">SL nhận</th>
						<th scope="col" style="text-align: center">Đơn giá nhận</th>
						<th scope="col" style="text-align: center">SL tồn trước</th>
						<th scope="col" style="text-align: center">Đơn giá tồn trước</th>
						<th scope="col" style="text-align: center">SL tồn sau</th>
						<th scope="col" style="text-align: center">Đơn giá tồn sau</th>
					</tr>
					</thead>
					<tbody class="tbody-light">
					<?php foreach ($history as $key => $value) : ?>
						<tr style="text-align: center">
							<td><?php echo ++$key ?></td>
							<td><?php echo date('d/m/Y', $value->created_at) ?></td>
							<td><?php echo !empty($value->partner->name) ? $value->partner->name : '' ?></td>
							<td><?php echo $value->warehouse->name ?></td>
							<td><span
										class="label <?php echo color_type_xuat_nhap_ton($value->type) ?> "><?php echo type_xuat_nhap_ton($value->type) ?></span>
							</td>
							<td><?php echo $value->so_luong_nhap ?? 0 ?></td>
							<td><?php echo !empty($value->don_gia_nhap) ? number_format($value->don_gia_nhap) : 0 ?></td>
							<td><?php echo $value->so_luong_xuat ?? 0 ?></td>
							<td><?php echo !empty($value->don_gia_xuat) ? number_format($value->don_gia_xuat) : 0 ?></td>
							<td><?php echo $value->so_luong_chuyen ?? 0 ?></td>
							<td><?php echo !empty($value->don_gia_chuyen) ? number_format($value->don_gia_chuyen) : 0 ?></td>
							<td><?php echo $value->so_luong_nhan ?? 0 ?></td>
							<td><?php echo !empty($value->don_gia_nhan) ? number_format($value->don_gia_nhan) : 0 ?></td>
							<td><?php echo $value->so_luong_ton ?? 0 ?></td>
							<td><?php echo !empty($value->don_gia_ton) ? number_format($value->don_gia_ton) : 0 ?></td>
							<td><?php echo $value->so_luong_ton_moi ?? 0 ?></td>
							<td><?php echo !empty($value->don_gia_ton_moi) ? number_format($value->don_gia_ton_moi) : 0 ?></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
				<div class="paginate" style="padding-left: 10px;">
					<?php echo $pagination; ?>
				</div>
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

	.breadcrumb {
		padding: 0px;
	}

	.container-xt {
		width: 100%;
		display: flex;
		flex-direction: column;
		gap: 24px;
	}

	.wrapper-top {
		display: flex;
		justify-content: space-between;
	}

	.content-cart h5 {
		font-style: normal;
		font-weight: 600;
		font-size: 20px;
		line-height: 24px;
		color: rgba(103, 103, 103, 1);
	}

	.container-cart {
		display: flex;
		gap: 16px;
	}

	.cart-input {
		width: 307.4px;
		padding-left: 8px;
		height: 108px;
		display: flex;
		flex-direction: column;
		gap: 4px;
	}

	.cart-input p {
		font-style: normal;
		font-weight: 400;
		font-size: 14px;
		line-height: 16px;
		display: flex;
		align-items: center;
	}

	.cart-input input {
		width: 291px;
		height: 35px;
		background: #FFFFFF;
		border: 1px solid #D8D8D8;
		border-radius: 5px;
		padding: 16px;
	}

	.cart-item {
		padding: 16px;
		width: 307.4px;
		padding-left: 8px;
		height: 136px;
		background: #FFFFFF;
		border: 1px solid #D8D8D8;
		box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
		border-radius: 8px;
	}

	.cart-item p {
		font-style: normal;
		font-weight: 600;
		font-size: 16px;
		line-height: 20px;
		color: rgba(103, 103, 103, 1);
	}

	.cart-item h5 {
		font-style: normal;
		font-weight: 600;
		font-size: 20px;
		line-height: 24px;
		color: #1D9752;
	}

	.containerForm-warehouse {
		width: 100%;
		height: 352px;
		background: #FFFFFF;
		border: 1px solid #EBEBEB;
		box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
		border-radius: 8px;
	}

	.containerForm-warehouse h5 {
		font-style: normal;
		font-weight: 600;
		font-size: 20px;
		line-height: 24px;
		color: rgba(59, 59, 59, 1);
		/* padding: 16px; */
		padding-left: 16px;
	}

	.form-text {
		display: flex;
		justify-content: space-between;
	}

	.modal-body {
		display: flex;
		flex-direction: column;
		gap: 16px;
	}

	.modal-item p {
		font-style: normal;
		font-weight: 400;
		font-size: 14px;
		line-height: 16px;
	}

	.modal-item input {
		padding: 16px;
		display: flex;
		gap: 8px;
		width: 100%;
		height: 35px;
		background: #FFFFFF;
		border: 1px solid #D8D8D8;
		border-radius: 5px;
	}

	.modal-item select {
		gap: 8px;
		width: 100%;
		height: 35px;
		border: 1px solid #D8D8D8;
		border-radius: 5px;

	}

	.modal-content11 {
		display: flex;
		gap: 16px;
	}

	.thead-light {
		background: #E8F4ED;
		font-style: normal;
		font-weight: 600;
		font-size: 14px;
		line-height: 16px;
		color: #262626;
	}

	.tbody-light {
		font-style: normal;
		font-weight: 400;
		font-size: 14px;
		line-height: 16px;
		color: rgba(103, 103, 103, 1);
	}

	.cart-item h6 {
		font-style: normal;
		font-weight: 400;
		font-size: 14px;
		line-height: 16px;
	}

	.cart-item span {
		color: red;
		font-weight: 600;
		font-size: 16px;
		line-height: 20px;
		line-height: 16px;
	}
</style>

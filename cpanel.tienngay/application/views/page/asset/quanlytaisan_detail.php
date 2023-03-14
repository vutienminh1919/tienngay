<div class="row form-horizontal">
	<div class="col-xs-12">
		<h4>
			Thông tin Tài sản
		</h4>
	</div>
	<div class="form-group col-xs-12">
		<div class="row">
			<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Người tạo tài sản: </label>
			<div class="col-md-9 col-sm-8 col-xs-12">
				<input type="text" class="form-control" readonly
					   value="<?php echo !empty($asset->updated_by) ? $asset->updated_by : $asset->created_by ?>">
			</div>
		</div>
	</div>
	<div class="form-group col-xs-12">
		<div class="row">
			<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Số hợp đồng liên quan:</label>
			<div class="col-md-9 col-sm-8 col-xs-12">
				<input type="text" class="form-control" readonly value="<?php echo $asset->so_hd_lien_quan ?>">
			</div>
		</div>
	</div>
	<div class="col-xs-12">
		<p>
		<h4>
			Thông tin chủ tài sản:
		</h4>
		</p>
	</div>
	<div class="form-group col-xs-12">
		<div class="row">
			<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Họ tên chủ tài sản:</label>
			<div class="col-md-9 col-sm-8 col-xs-12">
				<input type="text" class="form-control" readonly
					   value="<?php echo !empty($asset->customer_name) ? $asset->customer_name : '' ?>">
			</div>
		</div>
	</div>
	<div class="form-group col-xs-12">
		<div class="row">
			<label class="control-label col-md-3 col-sm-4 col-xs-12 text-left">Địa chỉ hộ khẩu:</label>
			<div class="col-md-9 col-sm-8 col-xs-12">
				<?php
				$address_household = !empty($asset->contract[0]->houseHold_address->address_household) ? $asset->contract[0]->houseHold_address->address_household : '';
				$ward_name = !empty($asset->contract[0]->houseHold_address->ward_name) ? $asset->contract[0]->houseHold_address->ward_name : '';
				$district_name = !empty($asset->contract[0]->houseHold_address->district_name) ? $asset->contract[0]->houseHold_address->district_name : '';
				$province_name = !empty($asset->contract[0]->houseHold_address->province_name) ? $asset->contract[0]->houseHold_address->province_name : '';
				$address = $address_household . ', ' . $ward_name . ', ' . $district_name . ', ' . $province_name;
				?>
				<input type="text" class="form-control" readonly
					   value="<?php echo !empty($asset->dia_chi) ? $asset->dia_chi : $address ?>">
			</div>
		</div>
	</div>

	<div class="col-xs-12">
		<p>
		<h4>
			Thông tin tài sản:
		</h4>
		</p>
		<?php if ($asset->type == 'NĐ') { ?>
			<div class="row flex no-gutter">
				<div class="form-group col-xs-12 col-lg ">
					<label class="control-label text-left">Thửa đất số:</label>
					<input type="text" class="form-control" readonly
						   value="<?php echo !empty($asset->thua_dat_so) ? $asset->thua_dat_so : '' ?>">
				</div>
				<div class="form-group col-xs-12 col-lg ">
					<label class="control-label text-left">Tờ bản đồ số:</label>
					<input type="text" class="form-control" readonly
						   value="<?php echo !empty($asset->to_ban_do_so) ? $asset->to_ban_do_so : '' ?>">
				</div>
				<div class="form-group col-xs-12 col-lg ">
					<label class="control-label text-left">Địa chỉ thửa đất:</label>
					<input type="text" class="form-control" readonly
						   value="<?php echo !empty($asset->dia_chi_thua_dat) ? $asset->dia_chi_thua_dat : '' ?>">
				</div>
				<div class="form-group col-xs-12 col-lg ">
					<label class="control-label text-left">Diện tích:</label>
					<input type="text" class="form-control" readonly
						   value="<?php echo !empty($asset->dien_tich) ? $asset->dien_tich : '' ?>">
				</div>
				<div class="form-group col-xs-12 col-lg ">
					<label class="control-label text-left">Hình thức sử dụng riêng:</label>
					<input type="text" class="form-control" readonly
						   value="<?php echo !empty($asset->hinh_thuc_su_dung_rieng) ? $asset->hinh_thuc_su_dung_rieng : '' ?>">
				</div>
				<div class="form-group col-xs-12 col-lg ">
					<label class="control-label text-left">Hình thức sử dụng chung:</label>
					<input type="text" class="form-control" readonly
						   value="<?php echo !empty($asset->hinh_thuc_su_dung_chung) ? $asset->hinh_thuc_su_dung_chung : '' ?>">
				</div>
				<div class="form-group col-xs-12 col-lg ">
					<label class="control-label text-left">Mục đích sử dụng:</label>
					<input type="text" class="form-control" readonly
						   value="<?php echo !empty($asset->muc_dich_su_dung) ? $asset->muc_dich_su_dung : '' ?>">
				</div>
			</div>
			<div class="row flex no-gutter">
				<div class="form-group col-xs-12 col-lg ">
					<label class="control-label text-left">Thời hạn sử dụng:</label>
					<input type="text" class="form-control" readonly
						   value="<?php echo !empty($asset->thoi_han_su_dung) ? $asset->thoi_han_su_dung : '' ?>">
				</div>
				<div class="form-group col-xs-12 col-lg ">
					<label class="control-label text-left">Nhà ở nếu có:</label>
					<input type="text" class="form-control" readonly
						   value="<?php echo !empty($asset->nha_o_neu_co) ? $asset->nha_o_neu_co : '' ?>">
				</div>
				<div class="form-group col-xs-12 col-lg ">
					<label class="control-label text-left">Giấy chứng nhận số:</label>
					<input type="text" class="form-control" readonly
						   value="<?php echo !empty($asset->giay_chung_nhan_so) ? $asset->giay_chung_nhan_so : '' ?>">
				</div>
				<div class="form-group col-xs-12 col-lg ">
					<label class="control-label text-left">Nhà ở nếu có:</label>
					<input type="text" class="form-control" readonly
						   value="<?php echo !empty($asset->nha_o_neu_co) ? $asset->nha_o_neu_co : '' ?>">
				</div>
				<div class="form-group col-xs-12 col-lg ">
					<label class="control-label text-left">Giấy chứng nhận số:</label>
					<input type="text" class="form-control" readonly
						   value="<?php echo !empty($asset->giay_chung_nhan_so) ? $asset->giay_chung_nhan_so : '' ?>">
				</div>
				<div class="form-group col-xs-12 col-lg ">
					<label class="control-label text-left">Nơi cấp:</label>
					<input type="text" class="form-control" readonly
						   value="<?php echo !empty($asset->noi_cap) ? $asset->noi_cap : '' ?>">
				</div>
				<div class="form-group col-xs-12 col-lg ">
					<label class="control-label text-left">Ngày cấp:</label>
					<input type="text" class="form-control" readonly
						   value="<?php echo !empty($asset->ngay_cap) ? date('d/m/Y', $asset->ngay_cap) : '' ?>">
				</div>
				<div class="form-group col-xs-12 col-lg ">
					<label class="control-label text-left">Số vào sổ:</label>
					<input type="text" class="form-control" readonly
						   value="<?php echo !empty($asset->so_vao_so) ? $asset->so_vao_so : '' ?>">
				</div>
			</div>
		<?php } else if ($asset->type != 'TC') : ?>
			<div class="row flex no-gutter">

				<div class="form-group col-xs-12 col-lg ">
					<label class="control-label text-left">Nhãn hiệu:</label>

					<input type="text" class="form-control" readonly
						   value="<?php echo !empty($asset->nhan_hieu) ? $asset->nhan_hieu : '' ?>">

				</div>
				<div class="form-group col-xs-6 col-lg">
					<label class="control-label text-left">Model:</label>

					<input type="text" class="form-control" readonly
						   value="<?php echo !empty($asset->model) ? $asset->model : '' ?>">

				</div>
				<div class="form-group col-xs-6 col-lg">
					<label class="control-label text-left">Biển số xe:</label>

					<input type="text" class="form-control" readonly
						   value="<?php echo !empty($asset->bien_so_xe) ? $asset->bien_so_xe : '' ?>">

				</div>
				<div class="form-group col-xs-6 col-lg">
					<label class="control-label text-left">Số khung:</label>

					<input type="text" class="form-control" readonly
						   value="<?php echo !empty($asset->so_khung) ? $asset->so_khung : '' ?>">

				</div>
				<div class="form-group col-xs-6 col-lg">
					<label class="control-label text-left">Số máy:</label>

					<input type="text" class="form-control" readonly
						   value="<?php echo !empty($asset->so_may) ? $asset->so_may : '' ?>">

				</div>
				<div class="form-group col-xs-6 col-lg">
					<label class="control-label text-left">Số đăng ký:</label>

					<input type="text" class="form-control" readonly
						   value="<?php echo !empty($asset->so_dang_ki) ? $asset->so_dang_ki : '' ?>">

				</div>
				<div class="form-group col-xs-6 col-lg">
					<label class="control-label text-left">Ngày cấp:</label>
					<?php if ($asset->type == "XM"): ?>
						<?php if (!empty($asset->ngay_cap)) : ?>
							<?php if (!filter_var($asset->ngay_cap, FILTER_VALIDATE_INT)) : ?>
								<?php $ngay_cap = date('d/m/Y', strtotime($asset->ngay_cap)) ?>
							<?php else: ?>
								<?php $ngay_cap = date('d/m/Y', $asset->ngay_cap) ?>
							<?php endif; ?>
						<?php else: ?>
							<?php $ngay_cap = '' ?>
						<?php endif; ?>
					<?php elseif ($asset->type == "OTO"): ?>
						<?php if (!empty($asset->ngay_cap)) : ?>
							<?php if (!filter_var($asset->ngay_cap, FILTER_VALIDATE_INT)) : ?>
								<?php $ngay_cap = $asset->ngay_cap ?>
							<?php else: ?>
								<?php $ngay_cap = date('d/m/Y', $asset->ngay_cap) ?>
							<?php endif; ?>
						<?php else: ?>
							<?php $ngay_cap = '' ?>
						<?php endif; ?>
					<?php else: ?>
						<?php $ngay_cap = !empty($asset->ngay_cap) ? $asset->ngay_cap : '' ?>
					<?php endif; ?>
					<input type="text" class="form-control" readonly
						   value="<?php echo $ngay_cap ?>">

				</div>

			</div>
		<?php else: ?>
			<div class="row flex no-gutter">

				<div class="form-group col-xs-12 col-lg ">
					<label class="control-label text-left">Loại tài sản:</label>

					<input type="text" class="form-control" readonly
						   value="Tín chấp">

				</div>
				<div class="form-group col-xs-6 col-lg">
					<label class="control-label text-left">Tên tài sản:</label>

					<input type="text" class="form-control" readonly
						   value="<?php echo !empty($asset->product) ? $asset->product : '' ?>">

				</div>
			</div>
		<?php endif; ?>
	</div>

	<div class="col-xs-12">
		<p>
		<h4>
			Thông tin Hợp đồng liên quan:
		</h4>
		</p>
		<div class="table-responsive">
			<table class="table table-bordered">
				<tbody>
				<tr>
					<th scope="col">STT</th>
					<th scope="col">Mã hợp đồng</th>
					<th scope="col">Thời gian</th>
					<th scope="col">Trạng thái</th>
					<th scope="col">Số tiền</th>

				</tr>
				<?php if (!empty($asset->contract)): ?>
					<?php $contract = $asset->contract ?>
					<?php foreach ($contract as $k => $value) : ?>
						<?php $leadstatus = [
								1 => "Mới",
								2 => "Chờ trưởng PGD duyệt",
								3 => "Đã hủy",
								4 => "Trưởng PGD không duyệt",
								5 => "Chờ hội sở duyệt",
								6 => "Đã duyệt",
								7 => "Kế toán không duyệt",
								8 => "Hội sở không duyệt",
								9 => "Chờ ngân lượng xử lý",
								10 => "Giải ngân ngân lượng thất bại",
								15 => "Chờ giải ngân",
								16 => "Đã tạo lệnh giải ngân thành công",
								17 => "Đang vay",
								18 => "Giải ngân thất bại",
								19 => "Đã tất toán",
								20 => "Đã quá hạn",
								21 => "Chờ hội sở duyệt gia hạn",
								22 => "Chờ kế toán duyệt gia hạn",
								23 => "Đã gia hạn",
								24 => "Chờ kế toán xác nhận gia hạn",
								25 => "Hội sở đã duyệt gia hạn",
								26 => "Chờ hội sở duyệt cơ cấu",
								27 => "Chờ kế toán duyệt cơ cấu",
								28 => "Đã cơ cấu",
								29 => "Chờ kế toán xác nhận cơ cấu",
								30 => "Hội sở duyệt cơ cấu",
						];
						foreach ($leadstatus as $key => $item) {
							if ($key == $value->status) {
								$status = $item;
							}
						} ?>
						<tr>
							<td><?php echo ++$k ?></td>
							<td>
								<a class="btn btn-success btn-sm" target="_blank"
								   href="<?php echo base_url("pawn/detail?id=") . $value->contract_id ?>">
									<?php echo !empty($value->code_contract) ? $value->code_contract : '' ?>
								</a>
							</td>
							<td>
								<?php echo !empty($value->loan_infor->number_day_loan) ? ($value->loan_infor->number_day_loan / 30) . ' tháng' : '' ?></td>
							<td>
								<?php echo !empty($value->status) ? $status : '' ?></td>
							<td>
								<?php echo !empty($value->loan_infor->amount_money) ? number_format($value->loan_infor->amount_money) . ' VND' : '' ?></td>
						</tr>
					<?php endforeach; ?>
				<?php else: ?>
					<tr>
						<td colspan="10">Không có dữ liệu</td>
					</tr>
				<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

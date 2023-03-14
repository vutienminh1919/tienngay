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
								Báo cáo lịch sử hợp đồng</a>
						</small>
					</h3>
					<div class="alert alert-danger alert-result" id="div_error"
						 style="display:none; color:white;"></div>
				</div>
			</div>
		</div>
		<div class="col-xs-3"></div>
		<div class="col-xs-12">
			<div class="row mb-3">
				<form action="<?php echo base_url('report_kt/report_history_contract') ?>" method="get" style="width: 100%;">
					<div class="col-md-2">
						<label>Chọn ngày bắt đầu</label>
						<input type="date" class="form-control" placeholder="Từ ngày" name="fromdate" value="<?=$fromdate?>">
					</div>
					<div class="col-md-2">
						<label>Chọn ngày kết thúc</label>
						<input type="date" class="form-control" placeholder="Đến ngày" name="todate" value="<?=$todate?>">
					</div>
					<div class="col-md-2">
						<label>Mã phiếu ghi</label>
						<input type="text" class="form-control" placeholder="Mã phiếu ghi" name="ma_phieu_ghi" value="<?=$ma_phieu_ghi?>">
					</div>
					<div class="col-md-2">
						<label>Mã hợp đồng</label>
						<input type="text" class="form-control" placeholder="Mã hợp đồng" name="ma_hop_dong" value="<?=$ma_hop_dong?>">
					</div>
					<div class="col-md-2">
						<label>Tên khách hàng</label>
						<input type="text" class="form-control" placeholder="Tên khách hàng" name="ten_khach_hang" value="<?=$ten_khach_hang?>">
					</div>
					<!--<div class="col-md-2">
						<label>Số điện thoại</label>
						<input type="text" class="form-control" placeholder="Số điện thoại" name="so_dien_thoai" value="<?/*=$so_dien_thoai*/?>">
					</div>-->
					<div class="col-md-2">
						<label>Hình thức vay</label>
						<select class="form-control" placeholder="Hình thức vay" name="hinh_thuc_vay" value="<?=$hinh_thuc_vay?>">
							<option value="">Chọn hình thức vay</option>
							<option <?= $hinh_thuc_vay == "Dư nợ giảm dần" ? 'selected' : '' ?> value="Dư nợ giảm dần">Lãi hàng tháng, gốc hàng tháng</option>
							<option <?= $hinh_thuc_vay == "Lãi hàng tháng, gốc cuối kỳ" ? 'selected' : '' ?> value="Lãi hàng tháng, gốc cuối kỳ">Lãi hàng tháng, gốc cuối kỳ</option>
						</select>
					</div>
					<!--<div class="col-md-2">
						<label>Sản phẩm vay</label>
						<input type="text" class="form-control" placeholder="Sản phẩm vay" name="san_pham_vay" value="<?/*=$san_pham_vay*/?>">
					</div>-->
					<div class="col-md-2">
						<label>Phòng giao dịch</label>
						<select type="text" class="form-control" placeholder="Phòng giao dịch" name="phong_giao_dich" value="<?=$phong_giao_dich?>">
							<option value="" >Chọn phòng giao dịch</option>
							<?php foreach ($store_list as $store_item) { ?>
							<option <?= $phong_giao_dich == $store_item->_id ? 'selected' : '' ?> value="<?= $store_item->_id ?>" ><?= $store_item->name ?></option>
							<?php } ?>
						</select>
					</div>
					<!--<div class="col-md-2">
						<label>Trạng thái</label>
						<input type="text" class="form-control" placeholder="Hình thức vay" name="trang_thai" value="<?/*=$todate*/?>">
					</div>-->
					<div class="col-lg-2 text-right">
						<label></label>
						<button type="submit" class="btn btn-primary w-100"><i class="fa fa-search"
																			   aria-hidden="true"></i> <?= $this->lang->line('search') ?>
						</button>
					</div>
					<div class="col-lg-2 text-right">
						<label></label>
						<a href="<?php echo base_url('report_kt/report_history_contract_excel') ?>?<?=$_SERVER['QUERY_STRING']?>" class="btn btn-primary w-100"> Export </a>
					</div>
				</form>
			</div>
		</div>
		<div class="col-xs-12 mt-3 mb-3">
			<h4>
				Hiển thị (<span class="text-danger"><?= $count ?></span>) kết quả.
			</h4>
		</div>
		<div class="table-responsive">
			<table id="datatable-button" class="table table-striped">
				<thead>
				<tr>
					<th>STT</th>
					<th>Mã giao dịch giải ngân</th>
					<th>Mã phiếu ghi</th>
					<th>Mã hợp đồng vay</th>
					<th>Mã hợp đồng gốc</th>
					<th>Kỳ hạn cho vay<br>(Kỳ hạn)</th>
					<th>Thời hạn cho vay<br>(Ngày)</th>
					<th>Ngày giải ngân</th>
					<th>Ngày gia hạn</th>
					<th>Ngày cơ cấu</th>
					<th>Ngày đáo hạn</th>
					<th>Ngày tất toán</th>
					<th>Tên người cho vay</th>
					<th>Mã người cho vay</th>
					<th>CMT/CCCD người cho vay</th>
					<th>Tên nhà đầu tư</th>
					<th>Mã nhà đầu tư</th>
					<th>Phòng giao dịch giải ngân</th>
					<th>Phân khu vực</th>
					<th>Phân vùng</th>
					<th>Phân miền</th>
					<th>Hình thức cầm cố</th>
					<th>Mã tài sản thế chấp</th>
					<th>Tên tài sản thế chấp</th>
					<th>Định vị</th>
					<th>Vị trí</th>
					<th>Giá trị tài sản thế chấp</th>
					<th>Giá trị thị trường khi thẩm định</th>
					<th>Giá trị tài sản khi chuẩn bị thanh lý</th>
					<th>Giá trị thực khi thanh lý</th>
					<th>Tiền cho vay</th>
					<th>Tiền bảo hiểm</th>
					<th>Tiền khách hàng thực nhận</th>
					<th>Số tài khoản giải ngân</th>
					<th>Tên chủ tài khoản</th>
					<th>Ngân hàng</th>
					<th>Chi nhánh</th>
					<th>Số thẻ ATM</th>
					<th>Tên chủ thẻ ATM</th>
					<th>Trạng thái hợp đồng</th>
					<th>Trạng thái hiện tại</th>
					<th>Hình thức trả lãi</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach($report as $key => $item) { ?>
					<tr>
						<td><?= $key + 1 ?></td>
						<td><?= $item->ma_giao_dich_giai_ngan ?></td>
						<td><?= $item->ma_phieu_ghi ?></td>
						<td><?= $item->ma_hop_dong ?></td>
						<td><?= $item->ma_hop_dong_goc ?></td>
						<td><?= $item->thoi_han_vay_thang ?></td>
						<td><?= $item->thoi_han_vay_ngay ?></td>
						<td><?= $item->ngay_giai_ngan ? date('d/m/Y', $item->ngay_giai_ngan) : '' ?></td>
						<td><?= $item->ngay_gia_han ? date('d/m/Y', $item->ngay_gia_han) : '' ?></td>
						<td><?= $item->ngay_co_cau ? date('d/m/Y', $item->ngay_co_cau) : '' ?></td>
						<td><?= $item->ngay_dao_han ? date('d/m/Y', $item->ngay_dao_han) : '' ?></td>
						<td><?= $item->ngay_tat_toan ? date('d/m/Y', $item->ngay_tat_toan) : '' ?></td>
						<td><?= $item->ten_nguoi_vay ?></td>
						<td><?= $item->ma_nguoi_vay ?></td>
						<td><?= $item->cmt_nguoi_vay ?></td>
						<td><?= $item->ten_ndt ?></td>
						<td><?= $item->ma_ndt ?></td>
						<td><?= $item->store->name ?></td>
						<td><?= $item->store->khu_vuc ?></td>
						<td><?= $item->store->vung ?></td>
						<td><?= $item->store->mien ?></td>
						<td><?= $item->hinh_thuc_cam_co ?></td>
						<td><?= $item->ma_tai_san_the_chap ?></td>
						<td><?= $item->ten_tai_san_the_chap ?></td>
						<td><?= $item->dinh_vi_tai_san_the_chap ?></td>
						<td><?= $item->vi_tri_tai_san_the_chap ?? "Người vay giữ" ?></td>
						<td><?= number_format($item->gia_tri_tai_san_the_chap) ?></td>
						<td><?= number_format($item->gia_tri_tai_san_khi_tham_dinh) ?></td>
						<td><?= number_format($item->gia_tri_tai_san_truoc_thanh_ly) ?></td>
						<td><?= number_format($item->gia_tri_tai_san_khi_thanh_ly) ?></td>
						<td><?= number_format($item->so_tien_vay) ?></td>
						<td><?= number_format($item->so_tien_bao_hiem) ?></td>
						<td><?= number_format($item->so_tien_thuc_nhan) ?></td>
						<td><?= $item->bank_info->so_tai_khoan ?></td>
						<td><?= $item->bank_info->ten_chu_tk ?></td>
						<td><?= $item->bank_info->bank_name ?></td>
						<td><?= $item->bank_info->ten_chi_nhanh ?></td>
						<td><?= $item->bank_info->so_the_atm ?></td>
						<td><?= $item->bank_info->ten_chu_atm ?></td>
						<?php
							$reportDataGoc = $api->apiPost($this->userInfo['token'], "report_kt/report_history_contract", [
								'ma_hop_dong' => $item->ma_hop_dong_goc
							]);
							if (!empty($reportDataGoc->status) && $reportDataGoc->status == 200) {
								$reportGoc = $reportDataGoc->data[0];
								if( (int) $reportGoc->ngay_tat_toan <= strtotime(date('Y-m-d 00:00:00')) && (int) $reportGoc->ngay_tat_toan != 0) {
									$trang_thai = "Đã tất toán";
								} else {
									if ( (int) $reportGoc->ngay_hop_dong_goc_co_cau > 0 && $reportGoc->ngay_hop_dong_goc_co_cau <= strtotime(date('Y-m-d 00:00:00')) ) {
										$trang_thai = "Đã cơ cấu";
									} elseif ( (int) $reportGoc->ngay_hop_dong_goc_gia_han > 0 && $reportGoc->ngay_hop_dong_goc_gia_han <= strtotime(date('Y-m-d 00:00:00')) ) {
										$trang_thai = "Đã gia hạn";
									} else {
										// Hợp đồng con đang gia hạn
										if ($reportGoc->danh_sach_hop_dong_gia_han != null) {
											if (end($reportGoc->danh_sach_hop_dong_gia_han) == $reportGoc->ma_hop_dong) {
												$trang_thai = "Đang vay";
											} else {
												$trang_thai = "Đã gia hạn";
											}
										} elseif ($reportGoc->danh_sach_hop_dong_co_cau != null) {
											if (end($reportGoc->danh_sach_hop_dong_co_cau) == $reportGoc->ma_hop_dong) {
												$trang_thai = "Đang vay";
											} else {
												$trang_thai = "Đã cơ cấu";
											}
										} else {
											$trang_thai = "Đang vay";
										}
									}
								}
							} else {
								$trang_thai = "";
							}

						?>
						<td><?= $trang_thai ?></td>
						<?php
							if( (int) $item->ngay_tat_toan <= strtotime(date('Y-m-d 00:00:00')) && (int) $item->ngay_tat_toan != 0) {
								$trang_thai_hien_tai = "Đã tất toán";
							} else {
								if ( (int) $item->ngay_hop_dong_goc_co_cau > 0 && $item->ngay_hop_dong_goc_co_cau <= strtotime(date('Y-m-d 00:00:00')) ) {
									$trang_thai_hien_tai = "Đã cơ cấu";
								} elseif ( (int) $item->ngay_hop_dong_goc_gia_han > 0 && $item->ngay_hop_dong_goc_gia_han <= strtotime(date('Y-m-d 00:00:00')) ) {
									$trang_thai_hien_tai = "Đã gia hạn";
								} else {
									// Hợp đồng con đang gia hạn
									if ($item->danh_sach_hop_dong_gia_han != null) {
										if (end($item->danh_sach_hop_dong_gia_han) == $item->ma_hop_dong) {
											$trang_thai_hien_tai = "Đang vay";
										} else {
											$trang_thai_hien_tai = "Đã gia hạn";
										}
									} elseif ($item->danh_sach_hop_dong_co_cau != null) {
										if (end($item->danh_sach_hop_dong_co_cau) == $item->ma_hop_dong) {
											$trang_thai_hien_tai = "Đang vay";
										} else {
											$trang_thai_hien_tai = "Đã cơ cấu";
										}
									} else {
										$trang_thai_hien_tai = "Đang vay";
									}
								}
							}
						?>
						<td><?= $trang_thai_hien_tai ?></td>
						<td><?= $item->hinh_thuc_tra_lai ?></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
			<?= $pagination ?>
		</div>
	</div>
</div>

<script>
	// $(".theloading").show();
</script>

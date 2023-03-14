<!-- page content -->
<?php
$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
$ctv_name = !empty($_GET['ctv_name']) ? $_GET['ctv_name'] : "";
$ctv_phone = !empty($_GET['ctv_phone']) ? $_GET['ctv_phone'] : "";
$lead_name = !empty($_GET['lead_name']) ? $_GET['lead_name'] : "";
$lead_phone = !empty($_GET['lead_phone']) ? $_GET['lead_phone'] : "";
$status = !empty($_GET['status']) ? $_GET['status'] : "";

?>
<div class="right_col" role="main">
	<div class="theloading" id="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="row top_tiles">
		<div class="col-xs-12">
			<?php if ($this->session->flashdata('error')) { ?>
				<div class="alert alert-danger alert-result">
					<?= $this->session->flashdata('error') ?>
				</div>
			<?php } ?>
			<?php if ($this->session->flashdata('success')) { ?>
				<div class="alert alert-success alert-result">
					<?= $this->session->flashdata('success') ?>
				</div>
			<?php } ?>
		</div>
		<div class="col-xs-12">
			<div class="page-title">
				<div class="row">
					<div class="col-xs-12">
						<h3>Danh sách đơn bán
							<br>
							<small>
								<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
										href="<?php echo base_url('WebsiteCTVTienNgay/get_list_order') ?>">Danh sách
									đơn bán
								</a>
							</small>
						</h3>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-xs-12">
							<div class="row">
								<div class="col-xs-12 col-md-3">
								</div>
								<div class="col-xs-12 col-md-3"></div>
								<div class="col-xs-12 col-md-6 text-right">
									<div class="dropdown" style="display:inline-block">
										<button class="btn btn-success dropdown-toggle"
												onclick="$('#lockdulieu').toggleClass('show');">
											<span class="fa fa-filter"></span>
											Lọc dữ liệu
										</button>
										<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
											style="padding:15px;width:550px;max-width: 85vw;">
											<div class="row">
												<form
														action="<?php echo base_url('WebsiteCTVTienNgay/get_list_order') ?>"
														method="get"
														style="width: 100%;">
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label> Từ </label>
															<input type="date" name="fdate" class="form-control"
																   value="<?= !empty($fdate) ? $fdate : "" ?>">
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label> Đến </label>
															<input type="date" name="tdate" class="form-control"
																   value="<?= !empty($tdate) ? $tdate : "" ?>">
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label>Họ và tên Lead</label>
															<input type="text" name="lead_name"
																   class="form-control"
																   placeholder="Tên Cộng tác viên"
																   value="<?php echo $lead_name; ?>">
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label>Số điện thoại Lead</label>
															<input type="text" name="lead_phone"
																   class="form-control"
																   placeholder="Số điện thoại"
																   value="<?php echo $lead_phone; ?>">
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label>Họ và tên CTV</label>
															<input type="text" name="ctv_name"
																   class="form-control"
																   placeholder="Tên Cộng tác viên"
																   value="<?php echo $ctv_name; ?>">
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label>Số điện thoại CTV</label>
															<input type="text" name="ctv_phone"
																   class="form-control"
																   placeholder="Số điện thoại"
																   value="<?php echo $ctv_phone; ?>">
														</div>
													</div>
													<div class="col-xs-12 col-md-6 ">
														<label>Trạng thái</label>
														<select class="form-control" name="status">
															<option value="">Chọn trạng thái</option>
															<option value="Thành công" <?php echo ($status == 'Thành công') ? 'selected' : '' ?>>
																Thành công
															</option>
															<option value="Đang xử lý" <?php echo ($status == 'Đang xử lý') ? 'selected' : '' ?>>
																Đang xử lý
															</option>
															<option value="Thất bại" <?php echo ($status == 'Thất bại') ? 'selected' : '' ?>>
																Thất bại
															</option>
															<option value="Chưa tạo sản phẩm" <?php echo ($status == 'Chưa tạo sản phẩm') ? 'selected' : '' ?>>
																Chưa tạo sản phẩm
															</option>
														</select>
													</div>
													<div class="col-xs-12 col-md-6">
														<label>&nbsp;</label>
														<button type="submit" class="btn btn-primary w-100"><i
																	class="fa fa-search"
																	aria-hidden="true"></i> <?= $this->lang->line('search') ?>
														</button>
													</div>
												</form>
											</div>
											<script>
												$('.selectize').selectize({
													// sortField: 'text'
												});
											</script>
										</ul>
									</div>
									<?php
									if ($userSession['is_superadmin'] == 1 || in_array('van-hanh', $groupRoles)) { ?>
										<a href="<?php echo base_url() ?>excel/exportCtvOrder?<?= 'fdate=' . $fdate . '&tdate=' . $tdate . '&status=' . $status . '&ctv_name=' . $ctv_name . '&ctv_phone=' . $ctv_phone . '&lead_name=' . $lead_name . '&lead_phone=' . $lead_phone?>"
										   class="btn btn-success"
										   target="_blank">
											<i class="fa fa-save" aria-hidden="true"></i>
											Xuất Excel
										</a>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>

				<div class="x_content">
					<div class="row">
						<div class="col-xs-12">
							<div>Hiển thị <span class="text-danger">
									<?php echo $result_count > 0 ? $result_count : 0; ?> </span>Kết quả
							</div>
							<div class="table-responsive">
								<table
										class="table table-bordered m-table table-hover table-calendar table-report datatablebutton">
									<thead style="background:#3f86c3; color: #ffffff;">
									<tr>
										<th>STT</th>
										<th>Loại bán</th>
										<th>Thời gian giao dịch</th>
										<th>Loại CTV</th>
										<th>Tên CTV</th>
										<th>Số điện thoại CTV</th>
										<th>Tên lead</th>
										<th>Số điện thoại lead</th>
										<th>Trạng thái</th>
										<th>Số tiền giao dịch</th>
										<th>Hoa hồng</th>
									</tr>
									</thead>
									<tbody>
									<?php if (!empty($order_list)) {
										$n = 1;
										foreach ($order_list as $key => $ctv) {
											?>
											<tr>
												<td><?= $n++; ?></td>
												<td><?= !empty($ctv->dichvusanpham) ? $ctv->dichvusanpham : ''; ?></td>
												<td><?= !empty($ctv->created_at) ? date('d/m/Y H:i:s', $ctv->created_at) : ''; ?></td>
												<td><?php if (!empty($ctv->ctv_type) && $ctv->ctv_type == 1) {
														echo "CTV cá nhân";
													} else {
														echo "CTV đội nhóm";
													}; ?></td>
												<td><?= !empty($ctv->ctv_name) ? $ctv->ctv_name : '';; ?></td>
												<td><?= !empty($ctv->ctv_phone) ? $ctv->ctv_phone : '';; ?></td>
												<td><?= !empty($ctv->fullname) ? $ctv->fullname : '';; ?></td>
												<td><?= !empty($ctv->phone_number) ? $ctv->phone_number : '';; ?></td>
												<td>
													<?php
													if (!empty($ctv->status_web) && $ctv->status_web == 'Đang xử lý') { ?>
														<span class="table_load">Đang xử lý</span>
													<?php } elseif (!empty($ctv->status_web) && $ctv->status_web == 'Thành công') { ?>
														<span class="table_success">Thành công</span>
													<?php } else if (!empty($ctv->status_web) && $ctv->status_web == 'Thất bại') { ?>
														<span class="table_fail">Thất bại</span>
													<?php } else { ?>
														<span class="table_fail">Chưa tạo sản phẩm</span>
													<?php } ?>
												</td>
												<td><?= !empty($ctv->price) ? number_format($ctv->price). " VND" : 0; ?></td>
												<td><?= !empty($ctv->tien_hoa_hong) ? number_format($ctv->tien_hoa_hong). " VND" : 0; ?></td>
											</tr>
										<?php }
									} ?>
									</tbody>
								</table>
								<div class="">
									<?php echo $pagination ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	const $menu = $('.dropdown');
	$(document).mouseup(e => {
		if (!$menu.is(e.target)
				&& $menu.has(e.target).length === 0) {
			$menu.removeClass('is-active');
			$('.dropdown-menu').removeClass('show');
		}
	});
	$('.dropdown-toggle').on('click', () => {
		$menu.toggleClass('is-active');
	});

</script>



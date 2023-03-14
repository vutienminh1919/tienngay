<!-- page content -->
<?php
$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
$ctv_name = !empty($_GET['ctv_name']) ? $_GET['ctv_name'] : "";
$ctv_phone = !empty($_GET['ctv_phone']) ? $_GET['ctv_phone'] : "";
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
						<h3>Danh sách Công tác viên được giới thiệu
							<br>
							<small>
								<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
										href="<?php echo base_url('WebsiteCTVTienNgay/get_list_ctv_intro') ?>">Danh sách Công tác
									viên
									được giới thiệu
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
														action="<?php echo base_url('WebsiteCTVTienNgay/get_list_ctv_intro') ?>"
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

													<div class="col-xs-12 col-md-6 ">
														<label>Trạng thái</label>
														<select class="form-control" name="status">
															<option value="">Chọn trạng thái</option>
															<option value="active" <?php echo ($status == 'new') ? 'selected' : '' ?>>
																Chờ xác nhận
															</option>
															<option value="active" <?php echo ($status == 'active') ? 'selected' : '' ?>>
																Đã xác nhận
															</option>
														</select>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label>Họ và tên</label>
															<input type="text" name="ctv_name"
																   class="form-control"
																   placeholder="Tên Cộng tác viên"
																   value="<?php echo $ctv_name; ?>">
														</div>
													</div>
													<div class="col-xs-12 col-md-6">
														<div class="form-group">
															<label>Số điện thoại</label>
															<input type="text" name="ctv_phone"
																   class="form-control"
																   placeholder="Số điện thoại"
																   value="<?php echo $ctv_phone; ?>">
														</div>
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
										<a href="<?php echo base_url() ?>excel/exportCtvIntro?<?= 'fdate=' . $fdate . '&tdate=' . $tdate . '&status=' . $status . '&ctv_name=' . $ctv_name . '&ctv_phone=' . $ctv_phone ?>"
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
										<th>SĐT người giới thiệu</th>
										<th>SĐT người được giới thiệu</th>
										<th>Thời gian giới thiệu</th>
										<th>Loại Cộng tác viên</th>
										<th>Tên Cộng tác viên</th>
										<th>Trạng thái</th>
										<th style="text-align: center">Trạng thái xác thực</th>
									</tr>
									</thead>
									<tbody>
									<?php if (!empty($ctv_intro_data)) {
										$n = 1;
										foreach ($ctv_intro_data as $key => $ctv) {
											?>
											<tr>
												<td><?= $n++; ?></td>
												<td><?= !empty($ctv->phone_introduce) ? $ctv->phone_introduce : ''; ?></td>
												<td><?= !empty($ctv->ctv_phone) ? $ctv->ctv_phone : ''; ?></td>
												<td><?= !empty($ctv->created_at) ? date('d/m/Y H:i:s', $ctv->created_at) : ''; ?></td>
												<td><?php print "CTV được giới thiệu"; ?></td>
												<td><?= !empty($ctv->ctv_name) ? $ctv->ctv_name : '';; ?></td>
												<td>
													<?php
													if (!empty($ctv->status) && $ctv->status == 'new') {
														print "Chờ xác nhận";
													} else if (!empty($ctv->status) && $ctv->status == 'active') {
														print "Đã xác nhận";
													} else {
														print "Đã hủy";
													}; ?>
												</td>
												<?php if (!empty($ctv->status_verified) && ($ctv->status_verified == "1")): ?>
													<td style="text-align: center">
														<span class="label label-danger"><?= status_verified_ctv($ctv->status_verified) ?></span>
													</td>
												<?php elseif (!empty($ctv->status_verified) && ($ctv->status_verified == "2")): ?>
													<td style="text-align: center">
														<span class="label label-warning"><?= status_verified_ctv($ctv->status_verified) ?></span>
													</td>
												<?php elseif (!empty($ctv->status_verified) && ($ctv->status_verified == "3")): ?>
													<td style="text-align: center">
														<span class="label label-success"><?= status_verified_ctv($ctv->status_verified) ?></span>
													</td>
												<?php else: ?>
													<td style="text-align: center">
														<span class="label label-info"><?= status_verified_ctv($ctv->status_verified) ?></span>
													</td>
												<?php endif; ?>
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





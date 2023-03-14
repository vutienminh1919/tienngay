<!-- page content -->
<?php
$start_date = !empty($_GET['start_date_contract_uni']) ? $_GET['start_date_contract_uni'] : '';
$end_date = !empty($_GET['end_date_contract_uni']) ? $_GET['end_date_contract_uni'] : '';
$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : '';
$code_contract1 = !empty($_GET['code_contract_tat_ca']) ? $_GET['code_contract_tat_ca'] : '';
$code_contract_qua_han = !empty($_GET['code_contract_qua_han']) ? $_GET['code_contract_qua_han'] : '';
$code_contract_toi_han = !empty($_GET['code_contract_toi_han']) ? $_GET['code_contract_toi_han'] : '';
$status = !empty(($_GET['status'])) ? $_GET['status'] : "";
?>
<div class="load"></div>
<div id="loading" class="theloading" style="display: none;">
	<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
</div>
<div id="successModal" class="modal fade">
  <div class="modal-dialog modal-confirm">
    <div class="modal-content" style="border-top: 2px solid #2FB344;">
      <div class="modal-header">
                <div class="icon-box success">
          <i class="fa fa-check"></i>
        </div>
        <h4 class="modal-title">Thành Công</h4>
        <p>Đã hoàn thành</p>
        <a style="min-height: auto;" href="javascript:(0)" class="btn btn-success company_close" data-dismiss="modal">Đóng</a>
        </div>
      <div class="modal-body">
        <p class='msg_success'></p>
      </div>
    </div>
  </div>
</div>
<div id="errorModal" class="modal fade">
  <div class="modal-dialog modal-confirm">
    <div class="modal-content">
      <div class="modal-header">
        <div class="icon-box danger">
          <i class="fa fa-times"></i>
        </div>
        <h4 class="modal-title">Thất bại</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        <p class='msg_error'></p>
      </div>
    </div>
  </div>
</div>
<div class="right_col" role="main">
	<?php if ($this->session->flashdata('error')) { ?>
		<div class="alert alert-danger alert-result" id="hide_it">
			<?= $this->session->flashdata('error') ?>
		</div>
	<?php } ?>

	<?php if ($this->session->flashdata('success')) { ?>
		<div class="alert alert-success alert-result" id="hide_it2"><?= $this->session->flashdata('success') ?></div>
	<?php } ?>

	<?php if (!empty($this->session->flashdata('notify'))) {
		$notify = $this->session->flashdata('notify'); ?>
		<?php foreach ($notify as $key => $value) { ?>
			<div class="alert alert-danger alert-result" id="hide_it3"><?= $value ?></div>
		<?php } ?>
	<?php } ?>
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="contract-list">
		<h3>Danh sách hợp đồng thuê mặt bằng</h3>
		<div class="btn-top">
			<small>
				<a href="<?php echo base_url("tenancy/listTenancy"); ?>"><i class="fa fa-home"></i>Danh sách hợp đồng</a>
			</small>
			<div>
			<?php if (in_array('ke-toan',$groupRoles)): ?>
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal1">
					<span>Cài đặt thông báo</span>
				</button>
			<?php endif; ?>
				<!-- Modal -->
				<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel"
					 aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Form Nhập thông báo</h5>
							</div>
							<div class="modal-body">
								<div class="ip1">
									<p>Số hợp đồng</p>
									<select name="code_contract" id="code_contract" class="form-control">
									<option value="">-- Chọn hợp đồng --</option>
									<?php foreach ($notification_tenancy as $item): ?>
										<option value="<?= $item->code_contract ?>"><?= $item->code_contract ?></option>
									<?php endforeach; ?>
									</select>
								</div>
								<div class="ip1">
									<p>Ngày thanh toán</p>
									<select name="ngay_thanh_toan" id="ngay_thanh_toan" class="form-control"></select>

								</div>
								<div class="ip1">
									<p>Ngày thanh toán thực tế</p>
									<input type="text" placeholder="Ngày thanh toán thực tế"
										   onfocus="(this.type='date')" name="ngay_thanh_toan_tt">
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
								<button type="button" class="btn btn-primary" id="saveNotification" data-dismiss="modal">Lưu</button>
							</div>
						</div>
					</div>
				</div>
				<?php if (in_array('ke-toan',$groupRoles)): ?>
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal2">
					<span>Danh sách thông báo</span>
				</button>
				<?php endif; ?>
				<!-- Modal -->
				<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel"
					 aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Danh sách thông báo</h5>
							</div>
							<div class="modal-body">
								<table class="table table-hover bg-light">
									<thead>
									<tr>
										<th scope="col" style="color: #0a5a2c;text-align: center">STT</th>
										<th scope="col" style="color: #0a5a2c;text-align: center">Số hợp đồng</th>
										<th scope="col" style="color: #0a5a2c;text-align: center">Hợp đồng số	</th>
										<th scope="col" style="color: #0a5a2c;text-align: center">Tiền thanh toán</th>
										<th scope="col" style="color: #0a5a2c;text-align: center">Ngày thanh toán</th>
										<th scope="col" style="color: #0a5a2c;text-align: center">Ngày thanh toán thực tế</th>
										<th scope="col" style="color: #0a5a2c;text-align: center">Trạng thái</th>
									</tr>
									</thead>
									<tbody>
									<?php if ($notification): ?>
										<?php foreach ($notification as $key => $val) : ?>
											<tr>
												<td style="text-align: center;padding: 8px !important;"><?php echo ++$key ?></td>
												<td style="text-align: center;padding: 8px !important;"><?php echo $val->code_contract ?></td>
												<td style="text-align: center;padding: 8px !important;"><?php echo $val->hop_dong_so ?></td>
												<td style="text-align: center;padding: 8px !important;"><?php echo number_format($val->one_month_rent) ?></td>
												<td style="text-align: center;padding: 8px !important;"><?php echo (($val->ngay_thanh_toan)) ?></td>
												<td style="text-align: center;padding: 8px !important;"><?php echo date('d/m/Y',($val->ngay_thanh_toan_tt)) ?></td>
												<td>
													<?php if ($val->status_notification == '1' || $val->status_notification == '2') { ?>
														<label class="switch_notification " data-id=<?= $val->_id ?>>
															<input class="form-check-input"
																   name="status_notification"
																   type="checkbox"
																   id="status_notification"
																	<?= $val->status_notification == '1' ? 'checked' : '' ?>
															>
															<span class="slider round"></span>
														</label>
													<?php } ?>
												</td>
											</tr>
										<?php endforeach; ?>
									<?php endif; ?>
									</tbody>
								</table>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Quay lại</button>
							</div>
						</div>
					</div>
				</div>
				<?php if (in_array('ke-toan',$groupRoles) || in_array('phat-trien-mat-bang',$groupRoles)): ?>
				<button type="button" class="btn btn-success"><a style="color:white;"
																 href="<?php echo base_url("tenancy/createTenancy"); ?>">Thêm
						mới hợp đồng</a> <img src="<?php echo base_url(); ?>assets/imgs/icon/ic_plus.svg" alt="">
				</button>
				<?php endif; ?>
			</div>

		</div>
		<div class="contract-tab">
			<div>
				<div>
					<!-- Tab items -->
					<div class="tabs">
						<?php if (in_array('ke-toan', $groupRoles) || in_array('phat-trien-mat-bang', $groupRoles)): ?>
							<div class="tab-item <?php echo $_GET['tab'] == 'tat-ca' || empty($_GET['tab']) ? 'active' : '' ?>">
								Tất cả hợp đồng
							</div>
						<?php endif; ?>
						<?php if (in_array('ke-toan', $groupRoles)): ?>
							<div class="tab-item <?php echo $_GET['tab'] == 'toi-han' ? 'active' : '' ?>">
								Đến hạn thanh toán
							</div>
						<?php endif; ?>
						<?php if (in_array('ke-toan', $groupRoles)): ?>
							<div class="tab-item <?php echo $_GET['tab'] == 'qua-han' ? 'active' : '' ?>">
								Quá hạn thanh toán
							</div>
						<?php endif; ?>
						<div class="line"></div>
					</div>
					<div class="tab-content">
						<?php if (in_array('ke-toan', $groupRoles) || in_array('phat-trien-mat-bang',$groupRoles) ||  $userSession['is_superadmin'] == 1): ?>
						<div class="tab-pane form-xt  form-xt <?php echo $_GET['tab'] == 'tat-ca' || empty($_GET['tab']) ? 'active' : '' ?>">
							<div class="form-container">
								<h3>Danh sách hợp đồng</h3>
								<div class="form-btn">
								<?php if (in_array('ke-toan', $groupRoles) || in_array('phat-trien-mat-bang',$groupRoles)): ?>
									<a type="button" class="btn btn-color"
									   href="<?= base_url() ?>tenancy/excel_tmb?start_date_contract_uni=<?= $start_date . '&end_date_contract_uni=' . $end_date . '&code_contract=' . $code_contract .'&tab=tat-ca'?> "
									   target="_blank">Xuất excel</a>
									<button type="button" class="btn btn-color1" data-toggle="modal"
											data-target="#exampleModal">Tìm kiếm<img
												src="<?php echo base_url(); ?>assets/imgs/icon/ic_search.svg" alt="">
									</button>
								<?php endif; ?>
									<!-- Modal -->
									<div class="modal fade" id="exampleModal" tabindex="-1"
										 aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Tìm kiếm</h5>
												</div>
												<div class="modal-body">
													<div>
														<div class="row">
															<div class="col-md-12">
																<label>Số hợp đồng</label>
															</div>
															<div class="col-md-12">
																<div class="form-input">
																	<input type='text' placeholder="Nhập số hợp đồng"
																		   name="code_contract_tat_ca"
																		   value="<?= $code_contract1 ?>"/>
																</div>
															</div>
														</div>
													</div>
													<div>
														<div class="row">
															<div class="col-md-6">
																<div >
																<label>Ngày bắt đầu hợp đồng</label>
															</div>
															<div class="col-md-12">
																<div class="form-input">
																	<input type='text' onfocus="(this.type='date')"
																		   name="start_date_contract_uni"
																		   placeholder="Từ ngày"
																		   value="<?= $start_date ?>"/>
																</div>
															</div>
															</div>
															<div class="col-md-6">
																<div>
																<label>Ngày kết thúc hợp đồng</label>
															</div>
															<div class="col-md-12">
																<div class="form-input">
																	<input	 type='text' onfocus="(this.type='date')"
																		   name="end_date_contract_uni"
																		   placeholder="Đến ngày"
																		   value="<?= $end_date ?>"/>
																</div>
															</div>
															</div>
														</div>
													</div>
													<div>
														<div class="row">
															<div class="col-md-12">
																<label>Trạng thái</label>
															</div>
															<div class="col-md-12">
																<div class="form-input">
																	<select name="status"  >
																		<option value="" >-- Tất cả trạng thái --</option>
																		<option value="block" <?php  echo $_GET['status'] == 'block' ? 'selected' : ''?>>Chưa thuê</option>
																		<option value="active" <?php  echo $_GET['status'] == 'active' ? 'selected' : ''?> >Đang thuê</option>
																		<option value="hop_dong_thanh_ly" <?php  echo $_GET['status'] == 'hop_dong_thanh_ly' ? 'selected' : ''?> >Hợp đồng đã thanh lý</option>
																	</select>
																</div>
															</div>
														</div>
													</div>
													<div>
														<input type='hidden'
															   name="tab_tat_ca" value="tat-ca"/>

													</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary"
															data-dismiss="modal">Hủy
													</button>
													<button type="button" id="search_all" class="btn btn-primary"
															data-dismiss="modal">Tìm kiếm
													</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div>
								<div class="table-responsive contract-table">
									<table class="table table-dark">
										<thead style="position: sticky;top: 0;z-index: 1">
										<tr>
											<th scope="col">STT</th>
											<th scope="col">Chức năng</th>
											<th scope="col">Số hợp đồng</th>
											<th scope="col">Ngày kí hợp đồng</th>
											<th scope="col">Ngày bắt đầu tính tiền</th>
											<th scope="col">Ngày hết hạn</th>
											<th scope="col">Khu vực</th>
											<th scope="col">Tên phòng giao dịch</th>
											<th scope="col">Tên công ty</th>
											<th scope="col">Giá thuê/Tháng</th>
											<th scope="col">Tiền đặt cọc</th>
											<th scope="col">Diện tích thuê</th>
											<th scope="col">Trạng thái</th>
											<th scope="col">Nv phụ trách</th>
										</tr>
										</thead>
										<tbody>
										<?php $c = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10); ?>
										<?php foreach ($contract as $key => $value) : ?>
											<tr>
												<td><?php echo ++$key ?></td>
												<td style="padding-right: 10px !important;padding-left: 10px !important;">
													<div class="dropdown">
														<a class="btn text-success dropdown-toggle " href="#"
														   data-toggle="dropdown" aria-expanded="false">
															Chức năng <img
																	src="<?php echo base_url(); ?>assets/imgs/icon/ic_menu.svg"
																	alt="">
														</a>
														<div class="dropdown-menu ">
														<?php if (in_array('ke-toan',$groupRoles) || in_array('is_superadmin', $groupRoles)): ?>
															<a class="dropdown-item"
															   href="<?php echo base_url("tenancy/detail_tenancy?id=" . $value->_id); ?>"><i class="fa fa-caret-right" aria-hidden="true"></i>
Xem
																chi tiết hợp đồng</a>
														<?php else:?>
															<a class="dropdown-item"
															   href="#">bạn không có quyền xem chi tiết</a>
														<?php endif; ?>
															<?php if (in_array('ke-toan',$groupRoles) || in_array('phat-trien-mat-bang',$groupRoles) ):?>
															<?php if ($value->status == 'block'){ ?>
																<a class="dropdown-item update_id_tenancy"
																   id="update_id_tenancy" data-toggle="modal"
																   data-target="#modal1" data-id="<?= $value->_id ?>"
																   href="#"> <i class="fa fa-caret-right" aria-hidden="true"></i>
Sửa hợp đồng</a>
															<?php }?>
															<?php endif; ?>
														</div>
												</td>
												<td><?php echo $value->code_contract ?? "" ?></td>
												<td><?php echo date("d/m/Y",($value->date_contract)) ?? "" ?></td>
												<td><?php echo date("d/m/Y",$value->start_date_contract_uni) ?? "" ?></td>
												<td><?php echo date("d/m/Y",$value->end_date_contract_uni) ?? "" ?></td>
												<td><?php echo $value->name_address ?? "" ?></td>
												<td><?php echo $value->store->store_name ?? "" ?></td>
												<td><?php echo $value->name_cty ?? "" ?></td>
												<td><?php echo number_format($value->one_month_rent) ?? "" ?></td>
												<td><?php echo number_format($value->tien_coc) ?? "" ?></td>
												<td><?php echo $value->dien_tich ?? "" ?></td>
												<td>
													<?php if ($value->status == 'active' || $value->status == 'block') { ?>
														<label class="switch " data-id= <?= $value->_id ?>>
															<input class="form-check-input"
																   name="status"
																   type="checkbox"
																   id="status"
																	<?= $value->status == 'active' ? 'checked' : '' ?>
															>
															<span class="slider round"></span>
														</label>
													<?php } elseif ($value->status == "hop_dong_thanh_ly") {
														echo "<span class='label label-success'>Hợp đồng thanh lý</span>";
													} ?>
												</td>
												<td><?php echo $value->staff_ptmb ?></td>
											</tr>
										<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							<div>
							<style>

							</style>
								<nav class="text-right">
									<?php echo $pagination1; ?>
								</nav>

							</div>
							</div>
						</div>
						<?php endif; ?>
						<div class="tab-pane form-xt form-xt <?php echo $_GET['tab'] == 'toi-han' ? 'active' : '' ?>">
							<div class="form-container">
								<h3>Lịch đến hạn thanh toán</h3>
								<div class="form-btn">
									<?php if (in_array('ke-toan',$groupRoles)): ?>
									<button type="button" class="btn btn-color1" data-toggle="modal"
											data-target="#exampleModal4">Tìm kiếm <img
												src="<?php echo base_url(); ?>assets/imgs/icon/ic_search.svg" alt="">
									</button>
									<?php endif; ?>
									<!-- Modal -->
									<div class="modal fade" id="exampleModal4" tabindex="-1"
										 aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Tìm kiếm</h5>
												</div>
												<div class="modal-body">
													<div>
														<div class="row">
															<div class="col-md-12">
																<label>Số hợp đồng</label>
															</div>
															<div class="col-md-12">
																<div class="form-input">
																	<input type='text' placeholder="Nhập số hợp đồng" name="code_contract_toi_han"
																	value="<?php echo $code_contract_toi_han ?>"/>
																</div>
															</div>
														</div>
													</div>
													<div>
														<div class="row">
															<div class="col-md-12">
																<label>Trạng thái thanh toán</label>
															</div>
															<div class="col-md-12">
																<div class="form-input">
																	<select name="status_toi_han">
																		<option value="">-- Tất cả trạng thái --
																		</option>
																		<option value="chua_thanh_toan" <?php echo $_GET['status_toi_han'] == 'chua_thanh_toan' ? 'selected' : '' ?>>
																			Chưa thanh toán
																		</option>
																		<option value="da_thanh_toan" <?php echo $_GET['status_toi_han'] == 'da_thanh_toan' ? 'selected' : '' ?> >
																			Đã thanh toán
																		</option>
<!--																		<option value="hop_dong_thanh_ly" --><?php //echo $_GET['status_toi_han'] == 'hop_dong_thanh_ly' ? 'selected' : '' ?><!-- >-->
<!--																			Hợp đồng đã thanh lý-->
<!--																		</option>-->
																	</select>
																</div>
															</div>
														</div>
													</div>
													<div>
														<div class="row">
															<div class="col-md-12">
																<label>Trạng thái thuế</label>
															</div>
															<div class="col-md-12">
																<div class="form-input">
																	<select name="status_thue_toi_han">
																		<option value="">-- Tất cả trạng thái --
																		</option>
																		<option value="chua_thanh_toan" <?php echo $_GET['status_thue_toi_han'] == 'chua_thanh_toan' ? 'selected' : '' ?>>
																			Chưa thanh toán thuế
																		</option>
																		<option value="da_thanh_toan" <?php echo $_GET['status_thue_toi_han'] == 'da_thanh_toan' ? 'selected' : '' ?> >
																			Đã thanh toán thuế
																		</option>
<!--																		<option value="hop_dong_thanh_ly" --><?php //echo $_GET['status_thue_toi_han'] == 'hop_dong_thanh_ly' ? 'selected' : '' ?><!-- >-->
<!--																			Hợp đồng đã thanh lý-->
<!--																		</option>-->
																	</select>
																</div>
															</div>
														</div>
													</div>
													<div>
														<input type='hidden'
															   name="tab_toi_han" value="toi-han"/>
													</div>
												</div>

												<div class="modal-footer">
													<button type="button" class="btn btn-secondary"
															data-dismiss="modal">Hủy
													</button>
													<button type="button" id="toi_han_search" class="btn btn-primary">Tìm kiếm</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div>
								<div class="table-responsive contract-table">
									<table class="table table-dark">
										<thead style="position: sticky;top: 0;z-index: 1">
										<tr>
											<th scope="col">STT</th>
											<th scope="col">Chức năng</th>
											<th scope="col">Số hợp đồng</th>
											<th scope="col">Ngày đến hạn thanh toán</th>
											<th scope="col">Giá thuê/tháng</th>
											<th scope="col">Kì hạn thanh toán</th>
											<th scope="col">Tổng tiền trả</th>
											<th scope="col">Trạng thái thanh toán</th>
											<th scope="col">Tiền thuế</th>
											<th scope="col">Trạng thái nôp thuế</th>
										</tr>
										</thead>
										<tbody>
										<?php $c = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10); ?>
										<?php foreach ($toi_han as $k => $v) : ?>
											<tr>
												<td><?php echo ++$k ?></td>
												<td style="padding-right: 10px !important;padding-left: 10px !important;">
													<div class="dropdown">
														<a class="btn text-success dropdown-toggle " href="#"
														   data-toggle="dropdown" aria-expanded="false">
															Chức năng <img
																	src="<?php echo base_url(); ?>assets/imgs/icon/ic_menu.svg"
																	alt="">
														</a>
														<div class="dropdown-menu ">
														<?php if (in_array('ke-toan',$groupRoles)): ?>
															<a class="dropdown-item"
															   href="<?php echo base_url("tenancy/detail_tenancy?id=" . $v->contract_id); ?>"> <i class="fa fa-caret-right" aria-hidden="true"></i>
Chi
																tiết hợp đồng</a>
														<?php else: ?>
															<a class="dropdown-item"
															   href="#">bạn không có quyền xem chi tiết</a>
														<?php endif; ?>
														</div>
												</td>
												<td><?php echo $v->code_contract ?? "" ?></td>
												<td><?php echo date("d/m/Y",$v->ngay_thanh_toan_unix) ?? "" ?></td>
												<td><?php echo number_format($v->one_month_rent / $v->ky_tra) ?></td>
												<td><?php echo $v->ky_tra ?? "" ?></td>
												<td><?php echo number_format($v->one_month_rent) ?? "" ?></td>
												<td><?php if ($v->status == "da_thanh_toan") {
														echo "<span class='label label-success'> đã thanh toán</span>";
													} elseif ($v->status == "chua_thanh_toan") {
														echo "<span class='label label-danger'>chưa thanh toán</span>";
													}
													?>
												</td>
												<td><?php echo number_format($v->tien_thue) ?? "" ?></td>
												<td><?php if ($v->status_thue == "da_thanh_toan") {
														echo "<span class='label label-success'> đã thanh toán</span>";
													} elseif ($v->status_thue == "chua_thanh_toan") {
														echo "<span class='label label-danger'>chưa thanh toán</span>";
													}
													?>
												</td>
											</tr>
										<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="tab-pane form-xt <?php echo $_GET['tab'] == 'qua-han' ? 'active' : '' ?>">
							<div class="form-container">
								<h3>Quá hạn thanh toán</h3>
								<div class="form-btn">
									<?php if (in_array('ke-toan', $groupRoles)): ?>
										<a type="button" class="btn btn-color"
										   href="<?= base_url("tenancy/quaHanExcel") . '?tab=qua-han' ?>"
										   target="_blank">Xuất excel</a>
									<?php endif; ?>
									<?php if (in_array('ke-toan', $groupRoles)): ?>
										<button type="button" class="btn  btn-color1" data-toggle="modal"
												data-target="#exampleModal3">Tìm kiếm <img
													src="<?php echo base_url(); ?>assets/imgs/icon/ic_search.svg"
													alt="">
										</button>
									<?php endif; ?>
									<!-- Modal -->
									<div class="modal fade" id="exampleModal3" tabindex="-1"
										 aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Tìm kiếm</h5>
												</div>
												<div class="modal-body">
													<div>
														<div class="row">
															<div class="col-md-12">
																<label>Số hợp đồng</label>
															</div>
															<div class="col-md-12">
																<div class="form-input">
																	<input type='text' placeholder="Nhập số hợp đồng"
																		   name="code_contract_qua_han"
																		   value="<?php echo $code_contract_qua_han ?>"/>
																</div>
															</div>
														</div>
													</div>
													<div>
														<div class="row">
															<div class="col-md-12">
																<label>Trạng thái</label>
															</div>
															<div class="col-md-12">
																<div class="form-input">
																	<select name="status_qua_han">
																		<option value="" >-- Tất cả trạng thái --</option>
																		<option value="chua_thanh_toan" <?php  echo $_GET['status_qua_han'] == 'chua_thanh_toan' ? 'selected' : ''?>>Chưa thanh toán</option>
																		<option value="da_thanh_toan" <?php  echo $_GET['status_qua_han'] == 'da_thanh_toan' ? 'selected' : ''?> >Đã thanh toán</option>
<!--																		<option value="hop_dong_thanh_ly" --><?php // echo $_GET['status_qua_han'] == 'hop_dong_thanh_ly' ? 'selected' : ''?><!-- >Hợp đồng đã thanh lý</option>-->
																	</select>
																</div>
															</div>
														</div>
													</div>
													<div>
														<div class="row">
															<div class="col-md-12">
																<label>Trạng thái thuế</label>
															</div>
															<div class="col-md-12">
																<div class="form-input">
																	<select name="status_thue_qua_han">
																		<option value="">-- Tất cả trạng thái --
																		</option>
																		<option value="chua_thanh_toan" <?php echo $_GET['status_thue_qua_han'] == 'chua_thanh_toan' ? 'selected' : '' ?>>
																			Chưa thanh toán thuế
																		</option>
																		<option value="da_thanh_toan" <?php echo $_GET['status_thue_qua_han'] == 'da_thanh_toan' ? 'selected' : '' ?> >
																			Đã thanh toán thuế
																		</option>
<!--																		<option value="hop_dong_thanh_ly" --><?php //echo $_GET['status_thue_qua_han'] == 'hop_dong_thanh_ly' ? 'selected' : '' ?><!-- >-->
<!--																			Hợp đồng đã thanh lý-->
<!--																		</option>-->
																	</select>
																</div>
															</div>
														</div>
													</div>
													<div>
														<input type='hidden'
															   name="tab_qua_han" value="qua-han"/>
													</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary"
															data-dismiss="modal">Hủy
													</button>
													<button type="button" id="qua_han_search" class="btn btn-primary">
														Tìm kiếm
													</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div>
								<div class="table-responsive contract-table">
									<table class="table table-dark">
										<thead  style="position: sticky;top: 0;z-index: 1">
										<tr>
											<th scope="col">STT</th>
											<th scope="col">Chức năng</th>
											<th scope="col">Số hợp đồng</th>
											<th scope="col">Giá thuê/tháng</th>
											<th scope="col">Kì hạn thanh toán</th>
											<th scope="col">Tổng tiền trả</th>
											<th scope="col">Trạng thái thanh toán</th>
											<th scope="col">Ngày đến hạn thanh toán</th>
											<th scope="col">Thuế GTGT +thuế TNCN</th>
											<th scope="col">Trạng thái nộp thuế</th>
											<th scope="col">Trách nhiệm kê khai nộp thuế</th>
										</tr>
										</thead>
										<tbody>
										<?php $c = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10); ?>
										<?php foreach ($qua_han as $ke => $va) : ?>
											<tr>
												<td><?php echo ++$ke ?></td>
												<td style="padding-right: 10px !important;padding-left: 10px !important;">
													<div class="dropdown">
														<a class="btn text-success dropdown-toggle " href="#"
														   data-toggle="dropdown" aria-expanded="false">
															Chức năng <img
																	src="<?php echo base_url(); ?>assets/imgs/icon/ic_menu.svg"
																	alt="">
														</a>
														<div class="dropdown-menu ">
															<a class="dropdown-item"
															   href="<?php echo base_url("tenancy/detail_tenancy?id=" . $va->contract_id) ?>"><i class="fa fa-caret-right" aria-hidden="true"></i>
Chi
																tiết hợp đồng</a>
														</div>
												</td>
												<td><?php echo $va->code_contract ?? "" ?></td>
												<td><?php echo number_format($va->one_month_rent / $va->ky_tra) ?? "" ?></td>
												<td><?php echo $va->ky_tra ?? "" ?></td>
												<td><?php echo number_format($va->one_month_rent) ?? "" ?></td>
												<td><?php if ($va->status == "da_thanh_toan") {
														echo "<span class='label label-success'> đã thanh toán</span>";
													} elseif ($va->status == "chua_thanh_toan") {
														echo "<span class='label label-danger'>chưa thanh toán</span>";
													}
													?>
												</td>
												<td><?php echo date("d/m/Y",$va->ngay_thanh_toan_unix) ?? "" ?></td>
												<td><?php echo number_format($va->tien_thue) ?? "" ?></td>
												<td><?php if ($va->status_thue == "da_thanh_toan") {
														echo "<span class='label label-success'> đã thanh toán</span>";
													} elseif ($va->status_thue == "chua_thanh_toan") {
														echo "<span class='label label-danger'>chưa thanh toán</span>";
													}
													?>
												</td>
												<td>
													<?php
													if ($va->nguoi_nop_thue == "1") {
														echo "Công ty";
													} elseif ($va->nguoi_nop_thue == "2") {
														echo "Chủ nhà";
													}
													?>
												</td>
											</tr>
										<?php endforeach; ?>
										</tbody>
									</table>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="color: #0a5a2c;font-size: 30px;padding-left: 8%;margin-top:15px">
        	<span>Cập nhật hợp đồng thuê nhà</span>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
		<div class="modal-body">
			<div class="container">
				<div class="row">
					<input type='text' placeholder="Nhập" name="id_update_tenancy" id="id_update_tenancy"
						   value="<?= $id ?>" hidden/>
					<div class="col-sm-4 form-group">
						<label>Số hợp đồng<span>*</span></label>
						<input type='text' placeholder=" Nhập mã hợp đồng" class="form-control"
							   name="code_contract"
							   id="code_contract_tenancy" />

					</div>
					<div class="col-sm-4 form-group">
						<label>Ngày ký hợp đồng<span>*</span></label>
						<input type='date' placeholder=" Nhập ngày thanh toán" class="form-control"
							   name="date_contract"
							   id="date_contract_tenancy"/>
					</div>
					<div class="col-sm-4 form-group">
						<label>Thời hạn thuê<span>*</span></label>
						<select name="contract_expiry_date" id="contract_expiry_date_tenancy"
								class="form-control">
							<option value="">-- chọn thời hạn thuê --</option>
							<option value="1">1 năm</option>
							<option value="2">2 năm</option>
							<option value="3">3 năm</option>
							<option value="4">4 năm</option>
							<option value="5">5 năm</option>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-4 form-group">
						<label>Ngày bắt đầu tính tiền<span>*</span></label>
						<input type='date' placeholder=" Nhập ngày thanh toán" class="form-control"
							   name="start_date_contract_uni"
							   id="start_date_contract_uni_tenancy"/>
					</div>

					<div class="col-sm-4 form-group">
						<label>Ngày kết thúc hợp đồng<span>*</span></label>
						<input type='date' placeholder=" Nhập ngày thanh toán" class="form-control"
							   name="end_date_contract_uni"
							   id="end_date_contract_uni_tenancy"/>
					</div>

					<div class="col-sm-4 form-group">
						<label>Phòng giao dịch<span>*</span></label>
						<input type='text' placeholder=" Nhập phòng giao dịch" class="form-control"
							   name="store_name"
							   id="store_name_tenancy"/>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-4 form-group">
						<label>Khu vực<span>*</span></label>
						<select name="address" id="address_tenancy" class="form-control">
							<option value="">-- Chọn tỉnh/Tp --</option>
							<?php foreach ($result_district as $e): ?>
								<option value="<?= $e->code ?>"><?php echo $e->name ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="col-sm-4 form-group">
						<label>Tên công ty<span>*</span></label>
						<input type='text' placeholder=" Nhập tên công ty" class="form-control"
							   name="name_cty"
							   id="name_cty_tenancy"/>
					</div>
					<div class="col-sm-4 form-group">
						<label>Diện tích<span>*</span></label>
						<input type='text' placeholder=" Nhập diện tích" class="form-control"
							   name="dien_tich"
							   id="dien_tich_tenancy"/>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-4 form-group">
						<label>Tên chủ nhà<span>*</span></label>
						<input type='text' placeholder=" Nhập tên chủ nhà" class="form-control"
							   name="ten_chu_nha"
							   id="ten_chu_nha_tenancy"/>
					</div>
					<div class="col-sm-4 form-group">
						<label>Số điện thoại chủ nhà<span>*</span></label>
						<input type='text' placeholder=" Nhập số điện thoại" class="form-control"
							   name="sdt_chu_nha"
							   id="sdt_chu_nha_tenancy"/>
					</div>
					<div class="col-sm-4 form-group">
						<label>Chủ tài khoản<span>*</span></label>
						<input type='text' placeholder=" Nhập tên chủ tài khoản" class="form-control"
							   name="ten_tk_chu_nha"
							   id="ten_tk_chu_nha_tenancy"/>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-4 form-group">
						<label>Số tài khoản<span>*</span></label>
						<input type='text' placeholder=" Nhập số tài khoản" class="form-control"
							   name="so_tk_chu_nha"
							   id="so_tk_chu_nha_tenancy"/>
					</div>
					<div class="col-sm-4 form-group">
						<label>Ngân hàng<span>*</span></label>
						<select name="bank_name" id="bank_name_tenancy" class="form-control">
							<option value="">-- Chọn Ngân Hàng --</option>
							<?php foreach ($result_bank_name as $i): ?>
								<option value="<?= $i->bank_code ?>"><?php echo $i->name ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="col-sm-4 form-group">
						<label>Số tiền đặt cọc<span>*</span></label>
						<input type='text' placeholder=" Nhập số tiền cọc" class="form-control"
							   name="tien_coc"
							   id="tien_coc_tenancy"/>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-4 form-group">
						<label>Ngày đặt cọc<span>*</span></label>
						<input type='date' placeholder=" Nhập ngày đặt cọc" class="form-control"
							   name="ngay_dat_coc"
							   id="ngay_dat_coc_tenancy"/>
					</div>
					<div class="col-sm-4 form-group">
						<label>Giá thuê/tháng<span>*</span></label>
						<input type='text' placeholder=" Nhập số tiền" class="form-control"
							   name="one_month_rent"
							   id="one_month_rent_tenancy"/>
					</div>
					<div class="col-sm-4 form-group">
						<label>Kỳ hạn thanh toán<span>*</span></label>
						<select name="ky_tra" id="ky_tra_tenancy" class="form-control">
							<option value="">chọn kỳ thanh toán</option>
							<option value="1">1 tháng</option>
							<option value="2">2 tháng</option>
							<option value="3">3 tháng</option>
							<option value="6">6 tháng</option>
							<option value="12">12 tháng</option>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-4 form-group">
						<label>Mã số thuế<span>*</span></label>
						<input type='text' placeholder=" Nhập mã số thuế" class="form-control"
							   name="ma_so_thue"
							   id="ma_so_thue_tenancy"/>
					</div>
					<div class="col-sm-4 form-group">
						<label>Trách nhiệm kê khai<span>*</span></label>
						<select name="nguoi_nop_thue" id="nguoi_nop_thue_tenancy" class="form-control">
							<option value="1">Công Ty
							</option>
							<option value="2">Chủ Nhà
							</option>
						</select>
					</div>
					<div class="col-sm-4 form-group">
						<label>Nhân viên phụ trách<span>*</span></label>
						<input type='text' placeholder=" Nhập nhân tên nhân viên" class="form-control"
							   name="staff_ptmb"
							   id="staff_ptmb_tenancy"/>
					</div>
				</div>

			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary"
					data-dismiss="modal">Hủy
			</button>
			<button type="button" id="btnSaveUpdateTenancy" class="btn btn-primary"
					data-id="<?= $resutl->_id ?>"
					>Thêm
			</button>

			<div class="update_tenancy"></div>
		</div>
		<div class="update_tenancy"></div>
    </div>
  </div>
</div>
<style>
	* {
		margin: 0;
		padding: 0;
		box-sizing: border-box;
	}

	.form-group label {
		font-style: normal;
		font-weight: 400;
		font-size: 14px;
		line-height: 16px;
		/* identical to box height, or 114% */

		display: flex;
		align-items: center;

		/* Text/Body */

		color: #676767;


	}

	.ip1 input {
		width: 100%;
		height: 40px;
		background: #FFFFFF;
		border: 1px solid #D8D8D8;
		border-radius: 5px;
		padding-left: 10px;
	}

	.btn-top {
		display: flex;
		justify-content: space-between;
	}

	.contract-form {
		padding: 16px;
		width: 100%;
		height: 600px;
		background: #FFFFFF;
		border: 1px solid #D8D8D8;
		box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
		border-radius: 8px;
	}


	.form-xt {
		width: 100%;
		background: #FFFFFF;
		border: 1px solid #D8D8D8;
		box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
		border-radius: 8px;
		padding: 16px;
	}

	.btn-color {
		background-color: white;
		color: #1D9752;
		border: 1px solid #1D9752;
	}

	.modal-header h5 {
		font-style: normal;
		font-weight: 600;
		font-size: 16px;
		line-height: 20px;
		text-align: center;
	}

	.btn-color1 {
		background-color: #D2EADC;
		color: #1D9752;

	}

	.dropdown-color {
		background-color: transparent;
		color: #1D9752;
	}

	.form-container {
		display: flex;
		justify-content: space-between;
	}

	.contract-form-top {
		display: flex;
		justify-content: space-between;
		align-items: center;
	}

	.form-container h3 {
		font-style: normal;
		font-weight: 600;
		font-size: 20px;
		line-height: 24px;
		color: #3B3B3B;
	}

	.tabs {
		display: flex;
		position: relative;
	}

	.tab-item {
		min-width: 80px;
		padding: 10px 10px;
		font-size: 14px;
		font-weight: 600;
		text-align: center;
		color: #676767;
		border-radius: 8px;
		border-bottom: 5px solid transparent;
		cursor: pointer;
		transition: all 0.5s ease;
	}

	.tab-item:hover {
		opacity: 1;
		color: #1D9752;
	}

	.tab-item.active {
		opacity: 1;
		color: #1D9752;
		background-color: #D2EADC;
	}

	.tab-content {
		padding: 24px 0;
	}

	.tab-pane {
		display: none;
	}

	.tab-pane.active {
		display: block;
	}

	.tab-pane h2 {
		font-size: 24px;
		margin-bottom: 8px;
	}

	/* -----table------- */
	/*.contract-table {*/
	/*	height: 480px;*/
	/*}*/

	.dropdown-menu {
		padding: 0px;
		background: #FFFFFF;
		left: 80%;
		top: 0%;
	}

	th {
		text-align: center;
		background: #E8F4ED;

	}

	td {
		text-align: center;
		padding: 0px !important;
	}

	.dropdown-menu a {
		padding: 10px;
	}

	.dropdown-menu a:hover {
		background-color: #1D9752;
	}

	/* -------------- */
	.drop-btn {
		border: none;
		background-color: transparent;
		margin: 0px;
		color: #1D9752;
	}

	.dropdown-xt {
		position: relative;
		display: inline-block;
	}

	.dropdown-content {
		display: none;
		position: absolute;
		background-color: while;
		/* min-width: 160px; */
		padding: 5px 10px;
		box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
		top: 100%;
	}

	.dropdown-content a {
		color: black;
		padding: 8px 16px;
		text-decoration: none;
		display: block;
		text-align: left;
	}

	.dropdown-content a:hover {
		/* background-color: #DCCAE9; */
		color: green;
	}

	.dropdown-xt:hover .dropdown-content {
		display: block;
		background-color: white;
	}

	/* ------------------------ */
	label {
		font-style: normal;
		font-weight: 400;
		font-size: 14px;
		line-height: 16px;
		display: flex;
		align-items: center;
	}

	.form-input input {
		padding: 16px;
		width: 100%;
		height: 35px;
		background: #FFFFFF;
		border: 1px solid #D8D8D8;
		border-radius: 5px;
	}

	.form-input select {
		width: 100%;
		height: 35px;
		background: #FFFFFF;
		border: 1px solid #D8D8D8;
		border-radius: 5px;
		padding-left: 10px;
	}

	.form-input select option {
		background: #FFFFFF;
		border: 1px solid #D8D8D8;
		height: 35px;
		width: 100%;
	}

	.modal-body {
		display: flex;
		flex-direction: column;
		gap: 10px
	}

	.pagination li a {
		color: black;

	}

	.pagination {
		float: right;
		margin: 0px;
		margin-top: 1%;

	}

	/* ------------------------- */
	/* The switch - the box around the slider */
	.switch {
		position: relative;
		display: inline-block;
		width: 45px;
		height: 20px;
	}

	/* Hide default HTML checkbox */
	.switch input {
		opacity: 0;
		width: 0;
		height: 0;
	}

	/* The slider */
	.slider {
		position: absolute;
		cursor: pointer;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: #ccc;
		-webkit-transition: .4s;
		transition: .4s;
	}

	.slider:before {
		position: absolute;
		content: "";
		height: 16px;
		width: 16px;
		top: 2px;
		left: 4px;
		bottom: 4px;
		background-color: white;
		-webkit-transition: .4s;
		transition: .4s;
	}

	input:checked + .slider {
		background-color: #2196F3;
	}

	input:focus + .slider {
		box-shadow: 0 0 1px #2196F3;
	}

	input:checked + .slider:before {
		-webkit-transform: translateX(16px);
		-ms-transform: translateX(16px);
		transform: translateX(16px);
	}

	.slider.round {
		border-radius: 34px;
	}

	.slider.round:before {
		border-radius: 50%;
	}

	.text-right {
		margin-top: .5rem;
		margin-bottom: .5rem;
		display: flex;
		padding-left: 0;
		list-style: none;
		border-radius: .25rem;
	}

	.text-right a, .text-right strong {
		position: relative;
		display: block;
		padding: .5rem .75rem;
		margin-left: -1px;
		line-height: 1.25;
		color: #007bff;
		background-color: #fff;
		border: 1px solid #dee2e6;
		margin-left: 0;
		border-top-left-radius: .25rem;
		border-bottom-left-radius: .25rem;
	}

	.switch_notification {
		position: relative;
		display: inline-block;
		width: 45px;
		height: 20px;
	}

	/* Hide default HTML checkbox */
	.switch_notification input {
		opacity: 0;
		width: 0;
		height: 0;
	}

	.theloading {
		position: fixed;
		z-index: 999;
		display: block;
		width: 100vw;
		height: 100vh;
		background-color: rgba(0, 0, 0, .7);
		top: 0;
		right: 0;
		color: #fff;
		display: flex;
		justify-content: center;
		align-items: center;
		z-index: 9999;

	}

	.invalid {
		border: 1px solid red !important;
	}

	@media screen and (min-width:1020px) and (max-width: 1440px) {
		.dropdown-menu {
			padding: 0px;
			background: #FFFFFF;
			left: 100%;
			top: 0%;
		}
	}

</style>
<script>
	const a = document.querySelector.bind(document);
	const b = document.querySelectorAll.bind(document);

	const tabs = b(".tab-item");
	const panes = b(".tab-pane");

	const tabActive = a(".tab-item.active");
	const line = a(".tabs .line");

	let requestIdleCallback = () => {
		line.style.left = tabActive.offsetLeft + "px";
		line.style.width = tabActive.offsetWidth + "px";
	}

	tabs.forEach((tab, index) => {
		const pane = panes[index];

		tab.onclick = function () {
			a(".tab-item.active").classList.remove("active");
			a(".tab-pane.active").classList.remove("active");

			line.style.left = this.offsetLeft + "px";
			line.style.width = this.offsetWidth + "px";

			this.classList.add("active");
			pane.classList.add("active");
		};
	});

</script>

<script>
	$(document).ready(function () {
		$('.switch').click(function (event) {
			event.preventDefault();
			let id = $(this).attr('data-id');
			let formData = new FormData();
			formData.append('id', id);
			if (confirm("Bạn chắc chắn muốn thay đổi?")) {
				$.ajax({
					url: _url.base_url + 'tenancy/update_status',
					type: 'POST',
					dataType: 'json',
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: formData,
					processData: false,
					contentType: false,
					beforeSend: function () {
						$(".theloading").show();
					},
					success: function (data) {
						$(".theloading").hide();
						if (data.data.status == 200) {
							$('#successModal').modal('show');
							$('.msg_success').text(data.message);
							setTimeout(function () {
								window.location.reload();
							}, 500)
						} else {
							$('#errorModal').modal('show');
							$('.msg_error').text(data.data.message);
						}
					},
					error: function () {
						$(".theloading").hide();
						alert('error')
						setTimeout(function () {
							window.location.reload()
						}, 500);
					}
				})
			}
		});

		$('#search_all').click(function () {
			let start_date = $("input[name='start_date_contract_uni']").val()
			let end_date = $("input[name='end_date_contract_uni']").val()
			let code_contract = $("input[name='code_contract_tat_ca']").val()
			let tab = $("input[name='tab_tat_ca']").val()
			let status = $("select[name='status']").val()
			console.log(start_date, end_date, code_contract)
			window.location.href = _url.base_url + 'tenancy/listTenancy' + '?start_date_contract_uni=' + start_date +
					'&end_date_contract_uni=' + end_date + '&code_contract_tat_ca=' + code_contract + '&tab=' + tab + '&status=' + status;
		})

		$('#qua_han_search').click(function () {
			let code_contract = $("input[name='code_contract_qua_han']").val()
			let tab = $("input[name='tab_qua_han']").val()
			let status = $("select[name='status_qua_han']").val()
			let status_thue = $("select[name='status_thue_qua_han']").val()
			console.log(code_contract)
			window.location.href = _url.base_url + 'tenancy/listTenancy' + '?code_contract_qua_han=' + code_contract + '&tab=' + tab
			+ '&status_qua_han=' + status + '&status_thue_qua_han=' + status_thue ;
		})

		$('#toi_han_search').click(function () {
			let code_contract = $("input[name='code_contract_toi_han']").val()
			let tab = $("input[name='tab_toi_han']").val()
			let status = $("select[name='status_toi_han']").val()
			let status_thue = $("select[name='status_thue_toi_han']").val()
			console.log(code_contract)
			window.location.href = _url.base_url + 'tenancy/listTenancy' + '?code_contract_toi_han=' + code_contract + '&tab=' + tab
			+ '&status_toi_han=' + status + '&status_thue_toi_han=' + status_thue;
		})

		$(function () {
			var timeout = 10000; // in miliseconds (10*1000)
			$('#hide_it').delay(timeout).fadeOut(300);

		});

		$(function () {
			var timeout = 10000; // in miliseconds (10*1000)
			$('#hide_it2').delay(timeout).fadeOut(300);

		});

		$(function () {
			var timeout = 10000; // in miliseconds (10*1000)
			$('#hide_it3').delay(timeout).fadeOut(300);

		});

		$("#saveNotification").click(function (event) {
			event.preventDefault();
			var code_contract = $("select[name='code_contract']").val();
			var ngay_thanh_toan = $("select[name='ngay_thanh_toan']").val();
			var ngay_thanh_toan_tt = $("input[name='ngay_thanh_toan_tt']").val();
			var formData = new FormData();
			formData.append('code_contract', code_contract)
			formData.append('ngay_thanh_toan', ngay_thanh_toan)
			formData.append('ngay_thanh_toan_tt', ngay_thanh_toan_tt)
			console.log(code_contract, ngay_thanh_toan, ngay_thanh_toan_tt);
			$.ajax({
				url: _url.base_url + 'tenancy/notificationTenancy',
				type: "POST",
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				beforeSend: function () {
					$(".theloading").show();
				},
				success: function (data) {
					$(".theloading").hide();
					$(".modal_missed_call").hide();
					if (data.status == 200) {
						$('#successModal').modal('show');
						$('.msg_success').text(data.msg);
						window.scrollTo(0, 0);
						setTimeout(function () {
							window.location.reload();
						}, 500);
					} else {
						$('#errorModal').modal('show');
						$('.msg_error').text(data.msg);
						window.scrollTo(0, 0);
						setTimeout(function () {
							window.location.reload();
						}, 500);
					}
				},
				error: function (data) {
					console.log(data);
					$(".theloading").hide();
				}
			})
		})

		$('.switch_notification').click(function (event) {
			event.preventDefault();
			let id = $(this).attr('data-id');
			let formData = new FormData();
			formData.append('id', id);
			if (confirm("Bạn chắc chắn muốn thay đổi?")) {
				$.ajax({
					url: _url.base_url + 'tenancy/update_notification',
					type: 'POST',
					dataType: 'json',
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: formData,
					processData: false,
					contentType: false,
					beforeSend: function () {
						$(".theloading").show();
					},
					success: function (data) {
						$(".theloading").hide();
						if (data.data.status == 200) {
							$('#successModal').modal('show');
							$('.msg_success').text(data.message);
							setTimeout(function () {
								window.location.reload();
							}, 500)
						} else {
							$('#errorModal').modal('show');
							$('.msg_error').text(data.data.message);
						}
					},
					error: function () {
						$(".theloading").hide();
						alert('error')
						setTimeout(function () {
							window.location.reload()
						}, 500);
					}
				})
			}
		})

		$('.update_id_tenancy').click(function (event) {
			event.preventDefault();
			let id = $(this).attr('data-id');
			console.log(id)
			let formData = new FormData();
			formData.append('id', id);
			$.ajax({
				url: _url.base_url + 'tenancy/findOneByIdTenancy',
				type: 'POST',
				dataType: 'json',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: formData,
				processData: false,
				contentType: false,
				beforeSend: function () {
					$(".theloading").show();
					$('#code_contract_tenancy').val("")
					$('#date_contract_tenancy').val("")
					$('#contract_expiry_date_tenancy').val("")
					$('#start_date_contract_uni_tenancy').val("")
					$('#end_date_contract_uni_tenancy').val("")
					$('#store_name_tenancy').val("")
					$('#address_tenancy').val("")
					$('#name_cty_tenancy').val("")
					$('#dien_tich_tenancy').val("")
					$('#ten_chu_nha_tenancy').val("")
					$('#sdt_chu_nha_tenancy').val("")
					$('#ten_tk_chu_nha_tenancy').val("")
					$('#so_tk_chu_nha_tenancy').val("")
					$('#bank_name_tenancy').val("")
					$('#tien_coc_tenancy').val("")
					$('#ngay_dat_coc_tenancy').val("")
					$('#one_month_rent_tenancy').val("")
					$('#ky_tra_tenancy').val("")
					$('#ma_so_thue_tenancy').val("")
					$('#nguoi_nop_thue_tenancy').val("")
					$('#staff_ptmb_tenancy').val("")
				},
				success: function (data) {
					$(".theloading").hide();
					if (data.status == 200) {
						console.log(data.data)
						$('#id_update_tenancy').val(data.data._id)
						$('#code_contract_tenancy').val(data.data.code_contract)
						$('#date_contract_tenancy').val(data.data.date_contract)
						$('#contract_expiry_date_tenancy').val(data.data.contract_expiry_date)
						$('#start_date_contract_uni_tenancy').val(data.data.start_date_contract_uni)
						$('#end_date_contract_uni_tenancy').val(data.data.end_date_contract_uni)
						$('#store_name_tenancy').val(data.data.store.store_name)
						$('#address_tenancy').val(data.data.store.address)
						$('#name_cty_tenancy').val(data.data.name_cty)
						$('#dien_tich_tenancy').val(data.data.dien_tich)
						$('#ten_chu_nha_tenancy').val(data.data.customer_infor.ten_chu_nha)
						$('#sdt_chu_nha_tenancy').val(data.data.customer_infor.sdt_chu_nha)
						$('#ten_tk_chu_nha_tenancy').val(data.data.customer_infor.ten_tk_chu_nha)
						$('#so_tk_chu_nha_tenancy').val(data.data.customer_infor.so_tk_chu_nha)
						$('#bank_name_tenancy').val(data.data.customer_infor.bank_name)
						$('#tien_coc_tenancy').val(addCommas(data.data.tien_coc.toString()))
						$('#ngay_dat_coc_tenancy').val(data.data.ngay_dat_coc)
						$('#one_month_rent_tenancy').val(addCommas(data.data.one_month_rent.toString()))
						$('#ky_tra_tenancy').val(data.data.ky_tra)
						$('#ma_so_thue_tenancy').val(data.data.ma_so_thue)
						$('#nguoi_nop_thue_tenancy').val(data.data.nguoi_nop_thue)
						$('#staff_ptmb_tenancy').val(data.data.staff_ptmb)
					}
				}
			})
		})

		$("#btnSaveUpdateTenancy").click(function (event) {
			event.preventDefault();
			$('.invalid-message').remove();
			$('.invalid').removeClass('invalid');
			var id = $("input[name='id_update_tenancy']").val();
			let code_contract = $("#modal1 input[name='code_contract']").val();
			let date_contract = $("#modal1 input[name='date_contract']").val();
			let contract_expiry_date = $("#modal1 select[name='contract_expiry_date']").val();
			let start_date_contract_uni = $("#modal1 input[name='start_date_contract_uni']").val();
			let end_date_contract_uni = $("#modal1 input[name='end_date_contract_uni']").val();
			let store_name = $("#modal1 input[name='store_name']").val();
			let address = $("#modal1 select[name='address']").val();
			let name_cty = $("#modal1 input[name='name_cty']").val();
			let dien_tich = $("#modal1 input[name='dien_tich']").val();
			let ten_chu_nha = $("#modal1 input[name='ten_chu_nha']").val();
			let sdt_chu_nha = $("#modal1 input[name='sdt_chu_nha']").val();
			let ten_tk_chu_nha = $("#modal1 input[name='ten_tk_chu_nha']").val();
			let so_tk_chu_nha = $("#modal1 input[name='so_tk_chu_nha']").val();
			let bank_name = $("#modal1 select[name='bank_name']").val();
			let tien_coc = $("#modal1 input[name='tien_coc']").val();
			let ngay_dat_coc = $("#modal1 input[name='ngay_dat_coc']").val();
			let one_month_rent = $("#modal1 input[name='one_month_rent']").val();
			let ky_tra = $("#modal1 select[name='ky_tra']").val();
			let ma_so_thue = $("#modal1 input[name='ma_so_thue']").val();
			let nguoi_nop_thue = $("#modal1 select[name='nguoi_nop_thue']").val();
			let staff_ptmb = $("#modal1 input[name='staff_ptmb']").val();
			let formData = new FormData();
			formData.append('id', id);
			formData.append('code_contract', code_contract);
			formData.append('date_contract', date_contract);
			formData.append('contract_expiry_date', contract_expiry_date);
			formData.append('start_date_contract_uni', start_date_contract_uni);
			formData.append('end_date_contract_uni', end_date_contract_uni);
			formData.append('store_name', store_name);
			formData.append('address', address);
			formData.append('name_cty', name_cty);
			formData.append('dien_tich', dien_tich);
			formData.append('ten_chu_nha', ten_chu_nha);
			formData.append('sdt_chu_nha', sdt_chu_nha);
			formData.append('ten_tk_chu_nha', ten_tk_chu_nha);
			formData.append('so_tk_chu_nha', so_tk_chu_nha);
			formData.append('bank_name', bank_name);
			formData.append('tien_coc', tien_coc);
			formData.append('ngay_dat_coc', ngay_dat_coc);
			formData.append('one_month_rent', one_month_rent);
			formData.append('ky_tra', ky_tra);
			formData.append('ma_so_thue', ma_so_thue);
			formData.append('nguoi_nop_thue', nguoi_nop_thue);
			formData.append('staff_ptmb', staff_ptmb);
			if (confirm("Bạn chắc chắn muốn cập nhật hợp đồng?")) {
				$.ajax({
					url: _url.base_url + 'tenancy/update_tenancy_status_block',
					type: "POST",
					data: formData,
					dataType: 'json',
					processData: false,
					contentType: false,
					success: function (data) {
						$(".theloading").hide();
						$(".modal_missed_call").hide();
						if (data.status == 200) {
							$('#modal1').modal('hide');
							$('#successModal').modal('show');
							$('.msg_success').text(data.msg);
							window.scrollTo(0, 0);
							setTimeout(function () {
								window.location.reload();
							}, 500);
						} else {
							if (data.msg) {
								$(".msg_error").html("");
								$.each(data.msg, function (i) {
									console.log(data.msg)
									console.log(data.msg[i][0]);
									$('#modal1 [name=' + i + ']').after("<span class='invalid-message' style='margin-top: 5px;color: red'>" + data.msg[i][0] + "</span>");
									$('#modal1 [name=' + i + ']').addClass("invalid")
								});
							}
						}
					},
					error: function (data) {
						console.log(data);
						$(".theloading").hide();
					}
				})
			}
		})

		function addCommas(str) {
			return str.replace(/^0+/, '').replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		}

		$('#one_month_rent_tenancy').on('keyup', function (event) {
			var one_month_rent = $("#modal1 input[name='one_month_rent']").val()
			$('#one_month_rent_tenancy').val(addCommas(one_month_rent))
		})

		$('#tien_coc_tenancy').on('keyup', function (event) {
			var tien_coc = $("#modal1 input[name='tien_coc']").val()
			$('#tien_coc_tenancy').val(addCommas(tien_coc))
		})

		$('#code_contract').on('change', function (event) {
			var code_contract = $(" select[name='code_contract']").val()
			var formData = new FormData();
			formData.append('code_contract', code_contract)
			$.ajax({
				url: _url.base_url + 'tenancy/get_all_contract_payment',
				type: "POST",
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				beforeSend: function () {
					$(".theloading").show();
					$("#ngay_thanh_toan").html('')
				},
				success: function (data) {
					console.log(data)
					$(".theloading").hide();
					$(".modal_missed_call").hide();
					if (data.status == 200) {
						$.each(data.data, function (key, value) {
							$("#ngay_thanh_toan").append('<option value="'+ value.ngay_thanh_toan +'">'+ value.ngay_thanh_toan +'</option>')
						})
					} else {
						$('#errorModal').modal('show');
						$('.msg_error').text(data.msg);
					}
				},
				error: function (data) {
					console.log(data);
					$(".theloading").hide();
				}
			})
		})


	});
</script>
<script type="text/javascript">
	$(document).ajaxStart(function () {
		$("#loading").show();
		var loadingHeight = window.screen.height;
		$("#loading, .right-col iframe").css('height', loadingHeight);
	}).ajaxStop(function () {
		$("#loading").hide();
	});

</script>

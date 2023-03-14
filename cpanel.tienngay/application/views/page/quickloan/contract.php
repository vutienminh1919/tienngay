<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	?>
	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3> Quản lý hợp đồng online
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
								href="#">Quản lý hợp đồng online</a>
						</small>
					</h3>
				</div>

				<div class="title_right text-right">
					<?php if ($userSession['is_superadmin'] == 1 || in_array("5da98b8568a3ff2f10001b06", $userRoles->role_access_rights) || in_array('van-hanh', $groupRoles)) { ?>
						<a href="<?php echo base_url("pawn/createContract") ?>" class="btn btn-info "><i class="fa fa-plus" aria-hidden="true"></i> <?= $this->lang->line('create') ?></a>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-xs-12">
							<?php if ($this->session->flashdata('error')) { ?>
								<div class="alert alert-danger alert-result">
									<?= $this->session->flashdata('error') ?>
								</div>
							<?php } ?>
							<?php if ($this->session->flashdata('success')) { ?>
								<div
									class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
							<?php } ?>
							<div class="row">
								<form action="<?php echo base_url('QuickLoan/search') ?>" method="get" style="width: 100%;">
									<div class="col-lg-3">
										<div class="input-group">
											<span class="input-group-addon"><?php echo $this->lang->line('from') ?></span>
											<input type="date" name="fdate" class="form-control" value="<?= !empty($fdate) ? $fdate : "" ?>">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="input-group">
											<span class="input-group-addon"><?php echo $this->lang->line('to') ?></span>
											<input type="date" name="tdate" class="form-control" value="<?= !empty($tdate) ? $tdate : "" ?>">
										</div>
									</div>
									<div class="col-lg-2">
										<select class="form-control" name="status">
											<option value=""><?= $this->lang->line('All_status')?></option>
											<option <?php echo $status == 5 ? 'selected' : ''?> value="5" >Chờ hội sở duyệt</option>
											<option <?php echo $status == 6 ? 'selected' : ''?> value="6" >Đã duyệt</option>
											<option <?php echo $status == 7 ? 'selected' : ''?> value="7" >Kế toán không duyệt</option>
											<option <?php echo $status == 8 ? 'selected' : ''?> value="8" >Hội sở không duyệt</option>
											<option <?php echo $status == 15 ? 'selected' : ''?> value="15" >Chờ giải ngân</option>
											<option <?php echo $status == 16 ? 'selected' : ''?> value="16" >Đã tạo lệnh giải ngân thành công</option>
											<option <?php echo $status == 17 ? 'selected' : ''?> value="17" >Đang vay</option>
											<option <?php echo $status == 18 ? 'selected' : ''?> value="18" >Giải ngân thất bại</option>
											<option <?php echo $status == 19 ? 'selected' : ''?> value="19" >Đã tất toán</option>
										</select>
									</div>
									<div class="col-lg-2 text-right">
										<button type="submit" class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i> <?= $this->lang->line('search') ?>
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="row">
						<div class="col-xs-12">
							<div class="row"></div>
						</div>
						<div class="col-xs-12">
							<div class="table-responsive">
								<table id="datatable-buttons" class="table table-striped">
									<thead>
									<tr>
										<th>#</th>
										<th><?= $this->lang->line('Contract_Code') ?></th>
										<th>Mã phiếu ghi</th>
										<th><?= $this->lang->line('Customer') ?></th>
										<th><?= $this->lang->line('phone_number') ?></th>
										<th><?= $this->lang->line('CMT1') ?></th>
										<th><?= $this->lang->line('Asset') ?></th>
										<th><?= $this->lang->line('amount_loan') ?></th>
										<th><?= $this->lang->line('status') ?></th>
										<th> <?= $this->lang->line('interest_payment') ?></th>
										<th><?= $this->lang->line('Number_loan_days') ?></th>
										<th><?= $this->lang->line('Interest_payment_period') ?></th>
										<th>Ngày tạo</th>
										<th>Ngày giải ngân</th>
										<th><?= $this->lang->line('Function') ?></th>
									</tr>
									</thead>
									<tbody>
									<?php
									if (!empty($contractData)) {
										foreach ($contractData as $key => $contract) {
											?>
											<tr>
												<td><?php echo $key + 1 ?></td>
												<td><?= !empty($contract->code_contract_disbursement) ? $contract->code_contract_disbursement : "" ?></td>
												<td><?= !empty($contract->code_contract) ? $contract->code_contract : "" ?></td>
												<td><?= !empty($contract->customer_infor->customer_name) ? $contract->customer_infor->customer_name : "" ?></td>
												<td><?= !empty($contract->customer_infor->customer_phone_number) ? $contract->customer_infor->customer_phone_number : "" ?></td>
												<td><?= !empty($contract->customer_infor->customer_identify) ? $contract->customer_infor->customer_identify : "" ?></td>
												<td><?= !empty($contract->loan_infor->name_property->text) ? $contract->loan_infor->name_property->text : "" ?></td>
												<?php $amount_money = !empty($contract->loan_infor->amount_money) ? number_format((float)$contract->loan_infor->amount_money) : 0; ?>
												<td><?= !empty($amount_money) ? $amount_money : "" ?></td>
												<td>
													<?php
													$status = !empty($contract->status) ? $contract->status : "";
													if ($status == 0) {
														echo "Nháp";
													} else if ($status == 1) {
														echo "Mới";
													} else if ($status == 2) {
														echo "Chờ trưởng PGD duyệt";
													} else if ($status == 3) {
														echo "Đã hủy";
													} else if ($status == 4) {
														echo "Trưởng PGD không duyệt";
													} else if ($status == 5) {
														echo "Chờ hội sở duyệt";
													} else if ($status == 6) {
														echo "Đã duyệt";
													} else if ($status == 7) {
														echo "Kế toán không duyệt";
													} else if ($status == 8) {
														echo "Hội sở không duyệt";
													} else if ($status == 15) {
														echo "Chờ giải ngân";
													} else if ($status == 16) {
														echo "Tạo lệnh giải ngân thành công";
													} else if ($status == 17) {
														echo "Đang vay";
													} else if ($status == 18) {
														echo "Giải ngân thất bại";
													} else if ($status == 19) {
														echo "Đã tất toán";
													} else if ($status == 20) {
														echo "Đã quá hạn ";
													} else if ($status == 21) {
														echo "Chờ hội sở duyệt gia hạn";
													} else if ($status == 22) {
														echo "Chờ kế toán duyệt gia hạn ";
													} else if ($status == 23) {
														echo "Đã gia hạn ";
													} else if ($status == 24) {
														echo "chờ kế toán xác nhận phiếu thu gia hạn";
													}
													?>
												</td>

												<td>
													<?php $type_interest = !empty($contract->loan_infor->type_interest) ? $contract->loan_infor->type_interest : "";
													if ($type_interest == 1) {
														echo "Lãi hàng tháng, gốc hàng tháng";
													} else {
														echo "Lãi hàng tháng, gốc cuối kỳ";
													} ?>
												</td>
												<td><?= !empty($contract->loan_infor->number_day_loan) ? $contract->loan_infor->number_day_loan : "" ?></td>
												<td><?= !empty($contract->loan_infor->period_pay_interest) ? $contract->loan_infor->period_pay_interest : "" ?></td>
												<td><?= !empty($contract->created_at) ? date('m/d/Y', $contract->created_at) : "" ?></td>
												<td><?= !empty($contract->disbursement_date) ? date('m/d/Y', $contract->disbursement_date) : "" ?></td>
												<td>
													<?php if ($contract->status != 0) { ?>
														<a href="<?php echo base_url("QuickLoan/detail?id=") . $contract->_id->{'$oid'} ?>" class="btn btn-info "> Chi tiết </a>
														<a href="<?php echo base_url("pawn/viewImageAccuracy?id=") . $contract->_id->{'$oid'} ?>" class="btn btn-info ">Xem chứng từ</a>
														<a href="javascript:void(0)" onclick="edit_fee(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>" class="btn btn-info yeu_cau_giai_ngan"> Sửa Phí</a>
													<?php } ?>
													<!--check accessright  vận hành theo trạng thái  -->
													<?php
													// check accessright của vận hành theo trạng thái
													if (in_array('giao-dich-vien', $groupRoles)) {?>
														<?php
														// buttom edit fee
														if (in_array($contract->status, array(1, 4, 7, 8)) && in_array("5def17f668a3ff1204003ad7", $userRoles->role_access_rights)) { ?>
															<a href="javascript:void(0)" onclick="edit_fee(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>" class="btn btn-info yeu_cau_giai_ngan"> Sửa Phí</a>
														<?php } ?>
														<?php
														// buttom edit khi bị kế toán từ chối  status = 7 chỉ cho sửa phần thông tin chuyển khoản
														if (in_array($contract->status, array(7)) && in_array("5def17f668a3ff1204003ad7", $userRoles->role_access_rights)) { ?>
															<a href="<?php echo base_url("pawn/updateDisbursement?id=") . $contract->_id->{'$oid'} ?>" class="btn btn-info ">
																<?= $this->lang->line('Edit') ?>
															</a>
														<?php } ?>
														<?php
														// buttom edit tiếp tục tạo hợp đồng = 0
														if ($contract->status == 0) { ?>
															<a href="<?php echo base_url("pawn/continueCreate?id=") . $contract->_id->{'$oid'} ?>" class="btn btn-info ">
																Tạo lại
															</a>
														<?php } ?>
														<?php
														// buttom edit status = 1,4,8
														if (in_array($contract->status, array(1, 4, 8)) && in_array("5def17f668a3ff1204003ad7", $userRoles->role_access_rights)) { ?>
															<a href="<?php echo base_url("pawn/update?id=") . $contract->_id->{'$oid'} ?>" class="btn btn-info ">
																<?= $this->lang->line('Edit') ?>
															</a>
														<?php } ?>
														<?php
														// buttom upload
														if (in_array($contract->status, array(1, 4, 6, 7, 8)) && in_array("5def400868a3ff1204003ad9", $userRoles->role_access_rights)) { ?>
															<a href="<?php echo base_url("pawn/uploadsImageAccuracy?id=") . $contract->_id->{'$oid'} ?>" class="btn btn-info ">
																<?= $this->lang->line('Upload_documents') ?>
															</a>
														<?php } ?>
														<?php
														// buttom gửi cht duyệt
														if (in_array($contract->status, array(1, 4))
															&& in_array("5dedd24f68a3ff3100003649", $userRoles->role_access_rights)) { ?>
															<a href="javascript:void(0)" onclick="gui_cht_duyet(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>" class="btn btn-info gui_cht_duyet">Gửi duyệt
															</a>
														<?php } ?>
														<!-- <?php
														// buttom tạo lại hợp đồng
														if (in_array($contract->status, array(3))&& in_array("5da98b8568a3ff2f10001b06", $userRoles->role_access_rights)) { ?>
                                                        <a href="#" data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>  class="btn btn-info "> Tạo lại </a>
                                                    <?php } ?> -->
														<?php
														// buttom tạo yêu cầu giải ngân
														if (in_array($contract->status, array(6, 7))
															&& in_array("5dedd32468a3ff310000364d", $userRoles->role_access_rights)) { ?>
															<a href="javascript:void(0)" onclick="yeu_cau_giai_ngan(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>" class="btn btn-info yeu_cau_giai_ngan"> Yêu cầu giải
																ngân </a>
														<?php } ?>
														<?php
														// buttom in hợp đồng
														if (in_array($contract->status, array(6, 7, 15, 16, 17)) && in_array("5def401068a3ff1204003ada", $userRoles->role_access_rights)) { ?>
															<a href="<?php echo base_url("pawn/printed?id=") . $contract->_id->{'$oid'} ?>" target="_blank" class="btn btn-info "> In hợp đồng </a>
														<?php } ?>
														<?php
														// buttom hủy hợp đồng
														if (in_array($contract->status, array(1, 4, 6, 7, 8)) && in_array("5db6b8c9d6612bceeb712375", $userRoles->role_access_rights)) { ?>
															<a href="javascript:void(0)" onclick="huy_hop_dong(this)" data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>  class="btn btn-info huy_hop_dong">Hủy hợp đồng </a>
														<?php } ?>
													<?php } ?>
													<!--check accessright hàng trưởng theo trạng thái  -->
													<?php
													// check accessright của của hàng trưởng theo trạng thái
													if (in_array('cua-hang-truong', $groupRoles)) {?>
														<?php
														// buttom edit fee
														if (in_array($contract->status, array(2, 6, 7, 8)) && in_array("5def17f668a3ff1204003ad7", $userRoles->role_access_rights)) { ?>
															<a href="javascript:void(0)" onclick="edit_fee(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>" class="btn btn-info yeu_cau_giai_ngan"> Sửa Phí</a>
														<?php } ?>
														<?php
														// buttom edit status = 8
														if (in_array($contract->status, array(8)) && in_array("5def17f668a3ff1204003ad7", $userRoles->role_access_rights)) { ?>
															<a href="<?php echo base_url("pawn/update?id=") . $contract->_id->{'$oid'} ?>" class="btn btn-info ">
																<?= $this->lang->line('Edit') ?>
															</a>
														<?php } ?>
														<?php
														// buttom upload
														if (in_array($contract->status, array(8))
															&& in_array("5def400868a3ff1204003ad9", $userRoles->role_access_rights)) { ?>
															<a href="<?php echo base_url("pawn/uploadsImageAccuracy?id=") . $contract->_id->{'$oid'} ?>" class="btn btn-info ">
																<?= $this->lang->line('Upload_documents') ?>
															</a>
														<?php } ?>
														<?php
														// buttom Của hàng trưởng từ chối hợp đồng
														if (in_array($contract->status, array(2))
															&& in_array("5dedd2c868a3ff310000364a", $userRoles->role_access_rights)) { ?>
															<a href="javascript:void(0)" onclick="cht_tu_choi(this)" data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>  class="btn btn-info cht_tu_choi" > Không duyệt </a>
														<?php } ?>
														<?php
														// buttom chuyển lên hội sở
														if (in_array($contract->status, array(2, 8)) && in_array("5dedd2d868a3ff310000364b", $userRoles->role_access_rights)) { ?>
															<a href="javascript:void(0)" onclick="chuyen_hoi_so(this)" data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>  class="btn btn-info chuyen_hoi_so" > Duyệt </a>
														<?php } ?>

														<!-- <?php
														// buttom tạo lại hợp đồng
														if (in_array($contract->status, array(3))&& in_array("5da98b8568a3ff2f10001b06", $userRoles->role_access_rights)) { ?>
                                                        <a href="#" class="btn btn-info "> Tạo lại </a>
                                                    <?php } ?> -->
														<?php
														// buttom in hợp đồng
														if (in_array($contract->status, array(6, 7, 15, 16, 17))
															&& in_array("5def401068a3ff1204003ada", $userRoles->role_access_rights)) { ?>
															<a href="<?php echo base_url("pawn/printed?id=") . $contract->_id->{'$oid'} ?>" target="_blank" class="btn btn-info "> In hợp đồng </a>
														<?php } ?>
														<?php
														// buttom hủy hợp đồng
														if (in_array($contract->status, array(1, 2, 4, 6, 7, 8))
															&& in_array("5db6b8c9d6612bceeb712375", $userRoles->role_access_rights)) { ?>
															<a href="javascript:void(0)" onclick="huy_hop_dong(this)" data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>  class="btn btn-info huy_hop_dong" >Hủy hợp đồng </a>
														<?php } ?>
													<?php } ?>

													<!--check accessright của hội sở theo trạng thái -->
													<?php
													// check accessright của hội sở theo trạng thái
													if (in_array('hoi-so', $groupRoles)) {?>
														<?php
														// buttom edit fee
														if (in_array($contract->status, array(5)) && in_array("5def17f668a3ff1204003ad7", $userRoles->role_access_rights)) { ?>
															<a href="javascript:void(0)" onclick="edit_fee(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>" class="btn btn-info yeu_cau_giai_ngan"> Sửa Phí</a>
														<?php } ?>
														<?php
														// buttom duyet hợp đồng
														if (in_array($contract->status, array(5)) && in_array("5dedd2e668a3ff310000364c", $userRoles->role_access_rights)) { ?>
															<a href="javascript:void(0)" onclick="hsduyet(this)" data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>  class="btn btn-info duyet"> Duyệt </a>
														<?php } ?>
														<?php
														// buttom hủy hợp đồng
														if (in_array($contract->status, array(5)) && in_array("5db6b8c9d6612bceeb712375", $userRoles->role_access_rights)) { ?>
															<a href="javascript:void(0)" onclick="huy_hop_dong(this)" data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>  class="btn btn-info huy_hop_dong" >Hủy hợp đồng </a>
														<?php } ?>
														<?php
														// buttom hủy hợp đồng
														if (in_array($contract->status, array(5))
															&& in_array("5e65a5c33894ad25f051b756", $userRoles->role_access_rights)) { ?>
															<a href="javascript:void(0)" onclick="hoi_so_khong_duyet(this)" data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>  class="btn btn-info huy_hop_dong" >HS không duyệt </a>
														<?php } ?>
														<?php
														// buttom duyet gia hạn hợp đồng
														if (in_array($contract->status, array(21))
															&& in_array("5e1ededd93bb0772bd3adb3fa", $userRoles->role_access_rights)) { ?>
															<a href="javascript:void(0)" onclick="hsduyetgiahan(this)" data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>  class="btn btn-info duyet"> Duyệt gia hạn </a>
														<?php } ?>
														<?php
														// buttom hủy gia hạn hợp đồng
														if (in_array($contract->status, array(21))
															&& in_array("5e1ededd93bb072bd3adb3fa", $userRoles->role_access_rights)) { ?>
															<a href="javascript:void(0)" onclick="hshuygiahan(this)" data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>  class="btn btn-info duyet"> Hủy gia hạn </a>
														<?php } ?>
													<?php } ?>

													<!--check accessright của kế toán theo trạng thái -->
													<?php
													if (in_array('ke-toan', $groupRoles)) {?>
														<?php
														// buttom duyet gia hạn hợp đồng
														if (in_array($contract->status, array(22))
															&& in_array("5e1edf2293bb072bd3adb3fb", $userRoles->role_access_rights)) { ?>
															<a href="javascript:void(0)" onclick="ktduyetgiahan(this)"
															   data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>  class="btn
															   btn-info duyet"> Duyệt gia hạn </a>
														<?php } ?>
														<?php
														// buttom huy gia hạn hợp đồng
														if (in_array($contract->status, array(22))
															&& in_array("5e1edf2293bb072bd3adb3fb", $userRoles->role_access_rights)) { ?>
															<a href="javascript:void(0)" onclick="kthuygiahan(this)"
															   data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>  class="btn
															   btn-info duyet"> Hủy gia hạn </a>
														<?php } ?>
														<?php
														// buttom upload
														if (in_array($contract->status, array(17))
															&& in_array("5def400868a3ff1204003ad9", $userRoles->role_access_rights)) { ?>
															<a href="<?php echo base_url("pawn/accountantUpload?id=") . $contract->_id->{'$oid'} ?>"
															   class="btn btn-info ">
																<?= $this->lang->line('Upload_documents') ?>
															</a>
														<?php } ?>

														<?php
														// buttom giải ngân gọi lệnh giải ngân sang vimo
														if (in_array($contract->status, array(15))
															&& in_array("5def15a268a3ff1204003ad6", $userRoles->role_access_rights)) { ?>
															<a href="<?php echo base_url("pawn/disbursement/") ?><?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
															   class="btn btn-info "> Giải ngân </a>
														<?php } ?>

														<?php
														// buttom kế toán ko duyệt hợp đồng
														if (in_array($contract->status, array(15))
															&& in_array("5def401b68a3ff1204003adb", $userRoles->role_access_rights)) { ?>
															<a href="javascript:void(0)" onclick="ketoan_tu_choi(this)"
															   data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>  class="btn
															   btn-info ketoan_tu_choi" > Không duyệt </a>
														<?php } ?>
														<?php
														// buttom in hợp đồng
														if (in_array($contract->status, array(6, 7, 15, 16, 17))
															&& in_array("5def401068a3ff1204003ada", $userRoles->role_access_rights)) { ?>
															<a href="<?php echo base_url("pawn/printed?id=") . $contract->_id->{'$oid'} ?>"
															   target="_blank" class="btn btn-info "> In hợp đồng </a>
														<?php } ?>
														<?php
														// buttom hủy hợp đồng
														if (in_array($contract->status, array(15))
															&& in_array("5db6b8c9d6612bceeb712375", $userRoles->role_access_rights)) { ?>
															<a href="javascript:void(0)" onclick="huy_hop_dong(this)"
															   data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>  class="btn
															   btn-info huy_hop_dong">Hủy hợp đồng </a>
														<?php } ?>

													<?php } ?>
													<!--check accessright  supper admin  và vận hành theo trạng thái  -->
													<!-- gdv -->
													<?php
													//check accessright của  supper admin theo trạng thái
													if ($userSession['is_superadmin'] == 1 || in_array('van-hanh', $groupRoles)) { ?>
														<?php
														// buttom edit fee
														if (in_array($contract->status, array(1, 2, 4, 5, 6, 7, 8))) { ?>
															<a href="javascript:void(0)" onclick="edit_fee(this)"
															   data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : '' ?>"
															   class="btn btn-info yeu_cau_giai_ngan"> Sửa Phí</a>
														<?php } ?>

														<?php
														// buttom edit khi bị kế toán từ chối  status = 7 chỉ cho sửa phần thông tin chuyển khoản
														if (in_array($contract->status, array(7)) && in_array("5def17f668a3ff1204003ad7", $userRoles->role_access_rights)) { ?>
															<a href="<?php echo base_url("pawn/updateDisbursement?id=") . $contract->_id->{'$oid'} ?>"
															   class="btn btn-info ">
																<?= $this->lang->line('Edit') ?>
															</a>
														<?php } ?>
														<?php
														// buttom không duyệt trả về của hàng trưởng hợp đồng
														if (in_array($contract->status, array(5))) { ?>
															<a href="javascript:void(0)"
															   onclick="hoi_so_khong_duyet(this)"
															   data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>  class="btn
															   btn-info huy_hop_dong" >HS không duyệt </a>
														<?php } ?>
														<?php
														// buttom hủy gia hạn hợp đồng
														if (in_array($contract->status, array(21, 22))) { ?>
															<a href="javascript:void(0)" onclick="hshuygiahan(this)"
															   data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>  class="btn
															   btn-info duyet"> Hủy gia hạn </a>
														<?php } ?>
														<?php
														// buttom duyet gia hạn hợp đồng
														if (in_array($contract->status, array(22))) { ?>
															<a href="javascript:void(0)" onclick="ktduyetgiahan(this)"
															   data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>  class="btn
															   btn-info duyet"> Gia hạn </a>
														<?php } ?>
														<?php
														// buttom duyet gia hạn hợp đồng
														if (in_array($contract->status, array(21))) { ?>
															<a href="javascript:void(0)" onclick="hsduyetgiahan(this)"
															   data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>  class="btn
															   btn-info duyet"> Duyệt gia hạn </a>
														<?php } ?>
														<?php
														// buttom upload
														if (in_array($contract->status, array(17))) { ?>
															<a href="<?php echo base_url("pawn/accountantUpload?id=") . $contract->_id->{'$oid'} ?>"
															   class="btn btn-info ">
																<?= $this->lang->line('Upload_documents') ?>
															</a>
														<?php } ?>
														<?php
														// buttom edit tiếp tục tạo hợp đồng = 0
														if ($contract->status == 0) { ?>
															<a href="<?php echo base_url("pawn/continueCreate?id=") . $contract->_id->{'$oid'} ?>"
															   class="btn btn-info ">
																Tạo lại
															</a>
														<?php } ?>
														<?php
														// buttom edit status = 1,4,7
														if (in_array($contract->status, array(1, 4, 8))) { ?>
															<a href="<?php echo base_url("pawn/update?id=") . $contract->_id->{'$oid'} ?>"
															   class="btn btn-info ">
																<?= $this->lang->line('Edit') ?>
															</a>
														<?php } ?>

														<?php
														// buttom upload
														if (in_array($contract->status, array(1, 4, 6, 7, 8))) { ?>
															<a href="<?php echo base_url("pawn/uploadsImageAccuracy?id=") . $contract->_id->{'$oid'} ?>"
															   class="btn btn-info ">
																<?= $this->lang->line('Upload_documents') ?>
															</a>
														<?php } ?>
														<?php
														// buttom gửi cht duyệt
														if (in_array($contract->status, array(1, 4))) { ?>
															<a href="javascript:void(0)" onclick="gui_cht_duyet(this)"
															   data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>  class="btn
															   btn-info gui_cht_duyet">
																					 Gửi duyệt
															</a>
														<?php } ?>

														<!-- <?php
														// buttom tạo lại hợp đồng
														if (in_array($contract->status, array(3))) { ?>
                                                        <a href="#" data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>  class="btn btn-info "> Tạo lại </a>
                                                    <?php } ?> -->

														<?php
														// buttom tạo yêu cầu giải ngân
														if (in_array($contract->status, array(6, 7))) { ?>
															<a href="javascript:void(0)"
															   onclick="yeu_cau_giai_ngan(this)"
															   data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>  class="btn
															   btn-info yeu_cau_giai_ngan" > Yêu cầu giải ngân </a>
														<?php } ?>
														<?php
														// buttom in hợp đồng
														if (in_array($contract->status, array(6, 7, 15, 16, 17))) { ?>
															<a href="<?php echo base_url("pawn/printed?id=") . $contract->_id->{'$oid'} ?>"
															   target="_blank" class="btn btn-info "> In hợp đồng </a>
														<?php } ?>
														<!-- Cht -->
														<?php
														// buttom Của hàng trưởng từ chối hợp đồng
														if (in_array($contract->status, array(2, 8))) { ?>
															<a href="javascript:void(0)" onclick="cht_tu_choi(this)"
															   data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>  class="btn
															   btn-info cht_tu_choi" > CHT Không duyệt </a>
														<?php } ?>
														<?php
														// buttom chuyển lên hội sở
														if (in_array($contract->status, array(2, 8))) { ?>
															<a href="javascript:void(0)" onclick="chuyen_hoi_so(this)"
															   data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>  class="btn
															   btn-info chuyen_hoi_so" > CHT Duyệt </a>
														<?php } ?>
														<!-- hội sở -->
														<?php
														// buttom duyet hợp đồng
														if (in_array($contract->status, array(5))) { ?>
															<a href="javascript:void(0)" onclick="hsduyet(this)"
															   data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>  class="btn
															   btn-info duyet">Hội sở Duyệt </a>
														<?php } ?>
														<!-- kế toán -->
														<?php
														// buttom giải ngân gọi lệnh giải ngân sang vimo
														if (in_array($contract->status, array(15))) { ?>
															<a href="<?php echo base_url("pawn/disbursement/") ?><?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>"
															   class="btn btn-info "> Giải ngân </a>
														<?php } ?>

														<?php
														// buttom kế toán ko duyệt hợp đồng
														if (in_array($contract->status, array(15))) { ?>
															<a href="javascript:void(0)" onclick="ketoan_tu_choi(this)"
															   data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>  class="btn
															   btn-info ketoan_tu_choi" >KT Không duyệt </a>
														<?php } ?>

														<?php
														// buttom kế toán ko duyệt hợp đồng
														if (in_array($contract->status, array(1, 2, 4, 5, 6, 7, 15))) { ?>
															<a href="javascript:void(0)" onclick="huy_hop_dong(this)"
															   data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "" ?>  class="btn
															   btn-info huy_hop_dong" >Hủy hợp đồng </a>
														<?php } ?>
													<?php } ?>

												</td>


											</tr>
										<?php }
									} ?>
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

<div class="modal fade" id="extension" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title title_modal_approve">Duyệt gia hạn hợp đồng</h5>
				<hr>
				<div class="form-group">
					<label>Ghi chú:</label>
					<textarea class="form-control approve_note_extension" rows="5"></textarea>
					<input type="hidden" class="form-control status_approve_extension" value="23">
					<input type="hidden" class="form-control contract_id_extension">
				</div>
				</table>
				<p class="text-right">
					<button class="btn btn-danger approve_submit_extension">Xác nhận</button>
				</p>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="approve" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title title_modal_approve"></h5>
				<hr>
				<div class="form-group">
					<label>Ghi chú:</label>
					<textarea class="form-control approve_note" rows="5"></textarea>
					<input type="hidden" class="form-control status_approve">
					<input type="hidden" class="form-control contract_id">
				</div>
				</table>
				<p class="text-right">
					<button class="btn btn-danger approve_submit">Xác nhận</button>
				</p>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="hsduyet" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title title_modal_approve"></h5>
				<hr>
				<div class="form-group">
					<label>Số tiền được vay:</label>
					<input type="text" class="form-control amount_money_max" disabled>
					<label>Số tiền vay:</label>
					<input type="text" class="form-control amount_money" disabled>
					<label>Phí bảo hiểm (VAT):</label>
					<input type="text" class="form-control fee_gic" disabled>
					<input type="hidden" id="insurrance_contract" name="insurrance_contract">
					<label>Số tiền giải ngân:</label>
					<input type="text" class="form-control amount_loan" disabled>
					<label>Ghi chú:</label>
					<textarea class="form-control approve_note_hs" rows="5"></textarea>
					<input type="hidden" class="form-control status_approve">
					<input type="hidden" class="form-control contract_id">
					<input type="hidden" class="tilekhoanvay" value="<?= $tilekhoanvay ?>">
				</div>
				</table>
				<p class="text-right">
					<button class="btn btn-primary edit_amount_money">Sửa</button>
					<button class="btn btn-danger approve_submit">Xác nhận</button>
				</p>
			</div>

		</div>
	</div>
</div>


<div class="modal fade" id="editFee" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title title_modal_approve">Sửa Biểu Phí</h5>
				<hr>
				<div class="form-group">
					<input type="hidden" class="form-control contract_id_fee">
					<label>Lãi suất phải thu của người vay:</label>
					<input type="text" class="form-control percent_interest_customer" disabled value="">

					<label>Phí tư vấn quản lý:</label>
					<input type="text" class="form-control percent_advisory" value="">

					<label>Phí thẩm định và lưu trữ tài sản đảm bảo:</label>
					<input type="text" class="form-control percent_expertise" value="">

					<label>Phần trăm phí quản lý số tiền vay chậm trả:</label>
					<input type="text" class="form-control penalty_percent" disabled value="">

					<label>Số tiền quản lý số tiền vay chậm trả:</label>
					<input type="text" class="form-control penalty_amount" disabled value="">

					<label>Phí tư vấn gia hạn:</label>
					<input type="text" class="form-control extend" disabled value="">

					<label>Phí tất toán(trước 1/3):</label>
					<input type="text" class="form-control percent_prepay_phase_1" disabled value="">

					<label>Phí tất toán(trước 2/3):</label>
					<input type="text" class="form-control percent_prepay_phase_2" disabled value="">

					<label>Phí tất toán(sau 2/3):</label>
					<input type="text" class="form-control percent_prepay_phase_3" disabled value="">

					<!-- <label>Ghi chú:</label>
					<textarea class="form-control fee_note" rows="5" ></textarea>
				 -->
				</div>
				</table>
				<p class="text-right">
					<button class="btn btn-danger submit_edit_fee">Xác nhận</button>
				</p>
			</div>

		</div>
	</div>
</div>

<!-- /page content -->
<?php $this->load->view('page/modal/create_pawn'); ?>
<script src="<?php echo base_url(); ?>assets/js/pawn/quickloan.js"></script>
<script src="<?php echo base_url(); ?>assets/js/numeral.min.js"></script>
<script>
    // $(document).ready(function(){
    $('#reservation').change(function (event) {
        var date_range = $('#reservation').val();
        var dates = date_range.split(" - ");
        var start = dates[0];
        var end = dates[1];
        var start = moment(dates[0], 'D MMMM YY');
        var end = moment(dates[1], 'D MMMM YY');
    });
    // });
</script>

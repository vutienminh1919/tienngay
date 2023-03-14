<!-- page content -->
<link href="<?php echo base_url(); ?>assets/teacupplugin/magnify/css/jquery.magnify.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/teacupplugin/magnify/js/jquery.magnify.js"></script>
<style>
	.modal-content {
		margin: auto;
	}

</style>
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="row top_tiles">
		<div class="col-xs-12 col-md-9">
			<div class="page-title">

				<div class="title_left" style="width: 100%">
					<h3><?= $this->lang->line('detail_loan_contract') ?> : <?= $contractInfor->code_contract ?>
						- <?= $contractInfor->code_contract_disbursement ?>
						- <?= contract_status($contractInfor->status) ?>

						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>/ <a
									href="<?php echo base_url('pawn/contract') ?>"><?php echo $this->lang->line('Contract_management') ?></a>
							/ <a href="#"><?php echo $this->lang->line('detail_loan_contract') ?></a>
						</small>
					</h3>
					<div class="alert alert-danger alert-result" id="div_error"
						 style="display:none; color:white;"></div>
				</div>
			</div>
			<?php
			if ($identify == true) {
				?>
				<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#contractExempted">
					Cảnh báo HĐ quá hạn
				</button>
			<?php } ?>

			<?php
			if ($property == true) {
				?>
				<a target="_blank" href="<?= base_url('property/blacklistDetail?id=' . $property_id) ?>"
				   class="btn btn-danger">
					Cảnh báo gian lận tài sản
				</a>
			<?php } ?>

		</div>

		<div class="col-xs-12 col-md-3">
			<div class="page-title">
				<div class="text-right">
					<?php
					if (in_array('quan-ly-khu-vuc', $groupRoles) || in_array('cua-hang-truong', $groupRoles)) {
						?>
						<div id="nav-main-menu">
							<nav class="main-nav text-center">
								<ul class="level0 clearfix">
									<li class="nav1 has-sub level0 ">
										<a class="menu-link" title="Sản phẩm" href="javascript:void(0)">Chuyển người
											theo dõi hợp đồng <i class="fa fa-chevron-down" aria-hidden="true"></i>
										</a>
										<ul class="sub_menu level1">
											<?php if (!empty($get_store)): ?>
												<?php foreach ($get_store as $key => $value): ?>
													<li class="nav2 has-sub level1"><a class=""
																					   href="javascript:void(0)"><?= !empty($value->store_name) ? $value->store_name : "" ?>
															<i
																	class="fa fa-chevron-right" aria-hidden="true"></i></a>
														<ul class="sub_menu level2">
															<?php if (!empty($value->user_store)): ?>
																<?php foreach ($value->user_store as $key1 => $item): ?>
																	<li class=""><a href="javascript:void(0)"
																					onclick="follow_contract(this)"
																					data-store="<?= !empty($key) ? $key : ""; ?>"
																					data-id="<?= !empty($key1) ? $key1 : ""; ?>"
																					data-email="<?= !empty($item->email) ? $item->email : ""; ?>"><?= !empty($item->email) ? $item->email : "" ?></a>
																	</li>
																<?php endforeach; ?>
															<?php endif; ?>
														</ul>
													</li>
												<?php endforeach; ?>
											<?php endif; ?>
										</ul>
									</li>

								</ul>
							</nav>
						</div>
					<?php } ?>

					<button type="button" class="btn btn-info" data-toggle="modal" data-target="#contract_involve">Hợp
						đồng liên quan
					</button>
					<?php if (in_array('van-hanh', $groupRoles) || in_array('hoi-so', $groupRoles)) : ?>
						<button type="button" class="btn btn-info contract_deepDetect" data-toggle="modal"
								data-target="#contract_deepDetect"
								data-avatar="<?php echo $contractInfor->customer_infor->img_portrait ?? '' ?>">Nhận dạng
							khuôn mặt<sup class="text-danger">Beta</sup>
						</button>
					<?php endif; ?>
					<a href="<?php echo base_url('pawn/contract') ?>" class="btn btn-info "> Quay lại </a>
					<a href="javascript:void(0)" onclick="showModal()" class="btn btn-info "> Lịch sử </a>
					<!--  <a href="javascript:void(0)" onclick="showModalVerifyCVS()" class="btn btn-info "> Xác thực CVS </a> -->
					<?php
					if ($contractInfor->status != 0) { ?>
						<a href="<?php echo base_url("pawn/viewImageAccuracy?id=") . $contractInfor->_id->{'$oid'} ?>"
						   class="btn btn-info ">
							Xem chứng từ
						</a>
					<?php } ?>
					<!--check accessright  vận hành theo trạng thái  -->
					<?php
					// check accessright của vận hành theo trạng thái
					if (in_array('giao-dich-vien', $groupRoles)) {
						?>

						<!-- gia hạn -->
						<?php if (in_array($contractInfor->status, array(13))) { ?>
							<a href="javascript:void(0)"
							   onclick="gui_thn_duyet_gia_han(this,true)"
							   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>"
							   class="btn btn-info duyet">Gửi TP QLHDV duyệt
								gia hạn</a>
							</a>
						<?php } ?>

						<!-- gia hạn -->
						<?php if (in_array($contractInfor->status, array(17, 24)) && (strtotime(date('Y-m-d') . ' 00:00:00') >= $contractInfor->disbursement_date)) { ?>
							<a href="javascript:void(0)"
							   onclick="gui_tpgd_duyet_co_cau(this,true)"
							   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>"
							   class="btn btn-info duyet">Gửi TP GD duyệt
								cơ cấu</a>
							</a>
						<?php } ?>
						<?php
						// buttom duyet gia hạn hợp đồng
						if (in_array($contractInfor->status, array(26))) { ?>
							<a href="javascript:void(0)"
							   onclick="gui_hs_duyet_gia_han(this,true)"
							   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : '' ?>"
							   class="btn btn-info">
								Gửi HS duyệt gia hạn
							</a>
						<?php } ?>
						<?php
						// buttom duyet gia hạn hợp đồng
						if (in_array($contractInfor->status, array(41))) { ?>
							<a href="javascript:void(0)"
							   onclick="gui_asm_duyet_gia_han(this,true)"
							   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : '' ?>"
							   class="btn btn-info">
								Gửi ASM duyệt gia hạn
							</a>
						<?php } ?>
						<?php
						// buttom duyet gia hạn hợp đồng
						if (in_array($contractInfor->status, array(42))) { ?>
							<a href="javascript:void(0)"
							   onclick="gui_asm_duyet_co_cau(this,true)"
							   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : '' ?>"
							   class="btn btn-info">
								Gửi ASM duyệt cơ cấu
							</a>
						<?php } ?>

						<?php
						// buttom gửi hội sở duyệt gia hạn
						if (in_array($contractInfor->status, array(17, 22)) && $contractInfor->debt->check_gia_han == 1) { ?>
							<a href="javascript:void(0)"
							   onclick="gui_tpgd_duyet_gia_han(this)"
							   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : '' ?>"
							   class="btn btn-info">
								Gửi TPGD duyệt gia hạn
							</a>
						<?php } ?>

						<!--     cơ cấu  -->
						<?php if (in_array($contractInfor->status, array(14))) { ?>
							<a href="javascript:void(0)"
							   onclick="gui_thn_duyet_co_cau(this,true)"
							   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>"
							   class="btn btn-info duyet">Gửi TP QLHDV duyệt
								cơ cấu</a>
							</a>
						<?php } ?>


						<?php
						// buttom duyet gia hạn hợp đồng
						if (in_array($contractInfor->status, array(28))) { ?>
							<a href="javascript:void(0)"
							   onclick="gui_hs_duyet_co_cau(this,true)"
							   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : '' ?>"
							   class="btn btn-info">
								Gửi HS duyệt cơ cấu
							</a>
						<?php } ?>
						<?php
						// buttom gửi cht duyệt
						if (in_array($contractInfor->status, array(1, 4))
								&& in_array("5dedd24f68a3ff3100003649", $userRoles->role_access_rights)) { ?>
							<a href="javascript:void(0)" onclick="gui_cht_duyet(this)"
							   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : '' ?>"
							   class="btn btn-info gui_cht_duyet">
								Gửi duyệt
							</a>
						<?php } ?>
						<?php
						// buttom hủy hợp đồng
						if (in_array($contractInfor->status, array(1, 4, 6, 7)) && in_array("5db6b8c9d6612bceeb712375", $userRoles->role_access_rights)) { ?>
							<a href="javascript:void(0)" onclick="huy_hop_dong(this)"
							   data-id='<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>'
							   class="btn btn-info huy_hop_dong">Hủy hợp đồng </a>
						<?php } ?>

						<?php
						// buttom edit status = 1,4,8,36
						if (in_array($contractInfor->status, array(1, 4, 8, 36)) && in_array("5def17f668a3ff1204003ad7", $userRoles->role_access_rights)) { ?>

							<a href="<?php echo base_url("pawn/update?id=") . $contractInfor->_id->{'$oid'} ?>"
							   class="btn btn-info">
								<?= $this->lang->line('Edit') ?></a>
						<?php } ?>
					<?php } ?>
					<!--check accessright hàng trưởng theo trạng thái  -->
					<?php
					// check accessright của của hàng trưởng theo trạng thái
					if (in_array('cua-hang-truong', $groupRoles)) {
						?>

						<?php
						// buttom duyet gia hạn hợp đồng
						if (in_array($contractInfor->status, array(21, 17, 41, 13, 26)) && $contractInfor->debt->check_gia_han == 1) { ?>
							<a href="javascript:void(0)"
							   onclick="tpgd_gui_duyet_gia_han(this,false)"
							   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : '' ?>"
							   class="btn btn-info">
								Gửi duyệt gia hạn
							</a>
						<?php } ?>
						<?php
						// buttom duyet gia hạn hợp đồng
						if (in_array($contractInfor->status, array(23, 17, 42, 14, 28))) { ?>
							<a href="javascript:void(0)"
							   onclick="tpgd_gui_duyet_co_cau(this,false)"
							   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : '' ?>"
							   class="btn btn-info">
								Gửi duyệt cơ cấu
							</a>
						<?php } ?>


					<?php } ?>
					<?php
					// buttom Của hàng trưởng từ chối hợp đồng
					if (in_array($contractInfor->status, array(2))
							&& in_array("5dedd2c868a3ff310000364a", $userRoles->role_access_rights)) { ?>
						<a href="javascript:void(0)" onclick="cht_tu_choi(this)"
						   data-id='<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>'
						   class="btn btn-info cht_tu_choi"> CHT Không
							duyệt </a>
					<?php } ?>


					<!-- <?php
					// buttom tạo lại hợp đồng
					if (in_array($contractInfor->status, array(3))
							&& in_array("5da98b8568a3ff2f10001b06", $userRoles->role_access_rights)) { ?>
                  <a href="#" class="btn btn-info "> Tạo lại </a>
                  <?php } ?> -->
					<?php
					// buttom hủy hợp đồng
					if (in_array($contractInfor->status, array(1, 2, 4, 6, 7))
							&& in_array("5db6b8c9d6612bceeb712375", $userRoles->role_access_rights)) { ?>
						<a href="javascript:void(0)" onclick="huy_hop_dong(this)"
						   data-id='<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>'
						   class="btn btn-info huy_hop_dong">Hủy hợp đồng </a>
					<?php } ?>

					<?php
					// buttom edit status = 8
					if (in_array($contractInfor->status, array(8)) && in_array("5def17f668a3ff1204003ad7", $userRoles->role_access_rights)) { ?>
						<a href="<?php echo base_url("pawn/update?id=") . $contractInfor->_id->{'$oid'} ?>"
						   class="btn btn-info">
							<?= $this->lang->line('Edit') ?>
						</a>
					<?php } ?>


					<!--								// button asm duyet va khong duyet -->
					<?php if (in_array('quan-ly-khu-vuc', $groupRoles)): ?>

						<?php if (in_array($contractInfor->status, array(35))) : ?>
							<a href="javascript:void(0)"
							   onclick="asm_khong_duyet(this)"
							   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>"
							   class="btn btn-info asm_khong_duyet"> ASM không duyệt</a>
							<a href="javascript:void(0)"
							   onclick="asm_duyet(this)"
							   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>"
							   class="dropdown-item asm_duyet btn btn-info"> Gửi hội sở duyệt</a>
						<?php endif; ?>

						<?php

						if (in_array($contractInfor->status, array(30))) { ?>
							<a href="javascript:void(0)"
							   onclick="asm_duyet_gia_han(this)"
							   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : '' ?>"
							   class="btn btn-info">
								Gửi duyệt gia hạn
							</a>
						<?php } ?>
						<?php

						if (in_array($contractInfor->status, array(32))) { ?>
							<a href="javascript:void(0)"
							   onclick="asm_duyet_co_cau(this)"
							   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : '' ?>"
							   class="btn btn-info">
								Gửi duyệt cơ cấu
							</a>
						<?php } ?>
					<?php endif; ?>
					<!--check accessright của kế toán theo trạng thái -->
					<?php
					if (in_array("tbp-thu-hoi-no", $groupRoles)) { ?>

						<!-- gia hạn	 -->
						<?php
						// buttom gửi hội sở duyệt gia hạn
						if (in_array($contractInfor->status, array(11))) { ?>
							<a href="javascript:void(0)"
							   onclick="tp_thn_duyet_gia_han(this)"
							   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : '' ?>"
							   class="btn btn-info">
								Gửi duyệt gia hạn
							</a>
						<?php } ?>

						<!-- 	cơ cấu		 -->
						<?php
						// buttom gửi hội sở duyệt gia hạn
						if (in_array($contractInfor->status, array(12))) { ?>
							<a href="javascript:void(0)"
							   onclick="tp_thn_duyet_co_cau(this)"
							   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : '' ?>"
							   class="btn btn-info">
								Gửi duyệt cơ cấu
							</a>
						<?php } ?>


						<?php if (in_array($contractInfor->status, array(37))) { ?>
							<a href="javascript:void(0)"
							   onclick="tpthn_de_xuat_gia_thanh_ly('<?= $contractInfor->_id->{'$oid'} ?>')"
							   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : '' ?>"
							   class="btn btn-info">
								TP QLHDV đề xuất giá bán
							</a>
						<?php } ?>
						<?php if (in_array($contractInfor->status, array(37))) { ?>
							<a href="javascript:void(0)"
							   onclick="tpthn_huy_yeu_cau(this)"
							   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : '' ?>"
							   class="btn btn-info">
								TP QLHDV hủy duyệt yêu cầu thanh lý
							</a>
						<?php } ?>
						<?php if (in_array($contractInfor->status, array(39))) { ?>
							<a href="javascript:void(0)"
							   onclick="tpthn_xac_nhan_thanh_ly(this)"
							   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : '' ?>"
							   class="btn btn-info">
								TP QLHDV xác nhận thanh lý
							</a>
						<?php } ?>
						<?php if (in_array($contractInfor->status, array(43))) { ?>
							<a href="javascript:void(0)"
							   onclick="tpthn_gui_lai_ceo('<?= $contractInfor->_id->{'$oid'} ?>')"
							   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : '' ?>"
							   class="btn btn-info">
								TP QLHDV gửi duyệt lại
							</a>
						<?php } ?>
					<?php } ?>
					<?php if (in_array("quan-ly-cap-cao", $groupRoles)) { ?>
						<?php if (in_array($contractInfor->status, array(38))) { ?>
							<a href="javascript:void(0)"
							   onclick="ceo_duyet_thanh_ly('<?= $contractInfor->_id->{'$oid'} ?>')"
							   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>"
							   class="btn btn-info">
								CEO duyệt đề xuất thanh lý
							</a>
						<?php } ?>
					<?php } ?>
					<?php
					if (in_array('ke-toan', $groupRoles)) {
						?>

						<?php
						// buttom kế toán ko duyệt hợp đồng
						if (in_array($contractInfor->status, array(15))
								&& in_array("5def401b68a3ff1204003adb", $userRoles->role_access_rights)) { ?>
							<a href="javascript:void(0)" onclick="ketoan_tu_choi(this)"
							   data-id='<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>'
							   class="btn btn-info ketoan_tu_choi"> Không duyệt </a>
						<?php } ?>
						<?php
						// buttom hủy hợp đồng
						if (in_array($contractInfor->status, array(15))
								&& in_array("5db6b8c9d6612bceeb712375", $userRoles->role_access_rights)) { ?>
							<a href="javascript:void(0)" onclick="huy_hop_dong(this)"
							   data-id='<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>'
							   class="btn btn-info huy_hop_dong">Hủy hợp đồng </a>
						<?php } ?>


					<?php } ?>
					<!--check accessright  supper admin  và vận hành theo trạng thái  -->
					<?php if (in_array('hoi-so', $groupRoles)) { ?>
						<?php

						if (in_array($contractInfor->status, array(25))) { ?>
							<a href="javascript:void(0)"
							   onclick="hoi_so_duyet_gia_han(this)"
							   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : '' ?>"
							   class="btn btn-info">
								Duyệt gia hạn
							</a>
						<?php } ?>
						<?php

						if (in_array($contractInfor->status, array(27))) { ?>
							<a href="javascript:void(0)"
							   onclick="hoi_so_duyet_co_cau(this)"
							   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : '' ?>"
							   class="btn btn-info">
								Duyệt cơ cấu
							</a>
						<?php } ?>

						<a href="javascript:void(0)" onclick="showModalEditCodeContractDisbursement()"
						   class="btn btn-info ">Sửa mã hợp đồng</a>
					<?php } ?>
					<?php if (in_array('thu-hoi-no', $groupRoles)): ?>
						<?php
						// buttom gửi hội sở duyệt gia hạn
						if (in_array($contractInfor->status, array(17, 13)) && $contractInfor->debt->check_gia_han == 1) { ?>
							<a href="javascript:void(0)"
							   onclick="thn_duyet_gia_han(this)"
							   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : '' ?>"
							   class="btn btn-info">
								Gửi duyệt gia hạn</a>

						<?php } ?>

						<!-- 	cơ cấu		 -->
						<?php
						// buttom gửi hội sở duyệt gia hạn
						if (in_array($contractInfor->status, array(17, 14))) { ?>
							<a href="javascript:void(0)"
							   onclick="thn_duyet_co_cau(this)"
							   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : '' ?>"
							   class="btn btn-info">
								Gửi duyệt cơ cấu</a>

						<?php } ?>
					<?php endif; ?>
					<!-- gdv -->
					<?php
					//check accessright của  supper admin theo trạng thái
					if ($userSession['is_superadmin'] == 1 || in_array('van-hanh', $groupRoles)) { ?>
						<?php
						// buttom edit status = 1,4,7
						if (in_array($contractInfor->status, array(1, 4, 8))) { ?>

							<a href="<?php echo base_url("pawn/update?id=") . $contractInfor->_id->{'$oid'} ?>"
							   class="btn btn-info">
								<?= $this->lang->line('Edit') ?></a>

						<?php } ?>
						<?php
						// buttom gửi cht duyệt
						if (in_array($contractInfor->status, array(1, 4))) { ?>
							<a href="javascript:void(0)" onclick="gui_cht_duyet(this)"
							   data-id='<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>'
							   class="btn btn-info gui_cht_duyet">
								Gửi duyệt
							</a>
						<?php } ?>
						<!-- Cht -->
						<?php
						// buttom Của hàng trưởng từ chối hợp đồng
						if (in_array($contractInfor->status, array(2))) { ?>
							<a href="javascript:void(0)" onclick="cht_tu_choi(this)"
							   data-id='<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>'
							   class="btn btn-info cht_tu_choi"> CHT Không duyệt </a>
						<?php } ?>
						<?php
						// buttom chuyển lên hội sở
						if (in_array($contractInfor->status, array(2, 8, 36))) { ?>
							<a href="javascript:void(0)" onclick="chuyen_asm_duyet(this)"
							   data-id='<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>'
							   class="btn btn-info chuyen_asm_duyet"> CHT Duyệt </a>
						<?php } ?>
						<!-- hội sở -->
						<?php
						// buttom duyet hợp đồng
						if (in_array($contractInfor->status, array(5))) { ?>
							<a href="javascript:void(0)" onclick="hsduyet(this)"
							   data-id='<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>'
							   class="btn btn-info duyet">Hội sở Duyệt </a>
						<?php } ?>
						<?php
						// buttom hủy hợp đồng
						if (in_array($contractInfor->status, array(5))) { ?>
							<a href="javascript:void(0)" onclick="hoi_so_khong_duyet(this)"
							   data-id='<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>'
							   class="btn btn-info huy_hop_dong">HS không duyệt </a>
						<?php } ?>

						<!-- kế toán -->
						<?php
						// buttom kế toán ko duyệt hợp đồng
						if (in_array($contractInfor->status, array(15))) { ?>
							<a href="javascript:void(0)" onclick="ketoan_tu_choi(this)"
							   data-id='<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>'
							   class="btn btn-info ketoan_tu_choi">KT Không duyệt </a>
						<?php } ?>
						<?php
						// buttom kế toán ko duyệt hợp đồng
						if (in_array($contractInfor->status, array(1, 2, 4, 5, 6, 7, 15))) { ?>
							<a href="javascript:void(0)" onclick="huy_hop_dong(this)"
							   data-id='<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>'
							   class="btn btn-info huy_hop_dong">Hủy hợp đồng </a>
						<?php } ?>

					<?php } ?>

					<?php
					// check accessright của vận hành theo trạng thái
					if (in_array('tpb-ke-toan', $groupRoles)) {
						?>
						<a href="javascript:void(0)" onclick="huy_hop_dong(this)"
						   data-id='<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>'
						   class="btn btn-info huy_hop_dong">Hủy hợp đồng </a>
					<?php } ?>

					<?php
					// Đổi nguồn TBP telesale
					if (in_array('tbp-cskh', $groupRoles)) {
						?>
						<a href="javascript:void(0)" onclick="showModalChangeSource()" class="btn btn-info ">Đồi nguồn
							KH</a>
						<a href="javascript:void(0)" onclick="showModalHistorySource()" class="btn btn-info "> Lịch sử
							nguồn KH </a>
					<?php } ?>

					<?php
					// check accessright của asm theo trạng thái
					if (in_array('quan-ly-khu-vuc', $groupRoles) && ($contractInfor->loan_infor->amount_loan < 50000000) && ($contractInfor->loan_infor->type_property->code == "XM") && ($contractInfor->loan_infor->type_loan->code == "CC")) {
						?>

						<?php
						// buttom edit status = 8 7 6
						if (in_array($contractInfor->status, array(6, 8, 7))) { ?>

							<a href="<?php echo base_url("pawn/update?id=") . $contractInfor->_id->{'$oid'} ?>"
							   class="dropdown-item">
								<?= $this->lang->line('Edit') ?>
							</a>
						<?php } ?>

					<?php } ?>

					<!--					Đồi nguồn khách hàng, quyền admin-->
					<?php if ($userSession['is_superadmin'] == 1): ?>
						<a href="javascript:void(0)" onclick="showModalChangeSource()" class="btn btn-info ">Đồi nguồn
							KH</a>
						<a href="javascript:void(0)" onclick="showModalHistorySource()" class="btn btn-info "> Lịch sử
							nguồn KH </a>
						<?php if ($store_digital == 1) { ?>
							<a href="javascript:void(0)" onclick="status_contract_megadoc(this)"
							   data-codecontract="<?= $contractInfor->code_contract ? $contractInfor->code_contract : '' ?>"
							   class="btn btn-info">Status Detail Megadoc</a>
							<a href="javascript:void(0)" onclick="cancel_contract_megadoc(this)"
							   class="btn btn-info">Hủy HĐ Điện tử
							</a>
						<?php } ?>
					<?php endif; ?>
					<!--					access_right: Sửa mã hợp đồng vay-->
					<?php if (in_array("61f0fd8b96c0440a710d0424", $userRoles->role_access_rights)) : ?>
						<a href="javascript:void(0)" onclick="showModalEditCodeContractDisbursement()"
						   class="btn btn-info ">Sửa mã hợp đồng</a>
					<?php endif; ?>
					<?php if ($store_digital == 1) { ?>
						<a href="javascript:void(0)" onclick="view_status_contract_megadoc(this)"
						   data-id='<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>'
						   class="btn btn-info">Trạng thái HĐ Điện tử
						</a>
					<?php } ?>

					<!--BP Định giá, định giá tài sản thanh lý (TSTL) => START-->
					<?php if (in_array('bo-phan-dinh-gia', $groupRoles)) { ?>
						<?php if (in_array($contractInfor->status, array(44))) : ?>
							<a href="javascript:void(0)"
							   onclick="bp_dinh_gia_xu_ly('<?= $contractInfor->_id->{'$oid'} ?>')"
							   data-id='<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>'
							   class="btn btn-info">BPĐG Xử lý </a>
						<?php endif; ?>
						<?php if (in_array($contractInfor->status, array(49))) : ?>
							<a href="javascript:void(0)"
							   onclick="bp_dinh_gia_lai('<?= $contractInfor->_id->{'$oid'} ?>')"
							   data-id='<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>'
							   class="btn btn-info">BPĐG định giá lại </a>
						<?php endif; ?>
					<?php } ?>
					<!--BP Định giá, định giá tài sản thanh lý => END-->

					<!--THN, Gửi lại YC định giá TSTL => START-->
					<?php if ($userSession['is_superadmin'] == 1 || in_array($userSession['email'], $role_liq)) { ?>
						<?php if (in_array($contractInfor->status, array(45))) : ?>
							<a href="javascript:void(0)"
							   onclick="thn_tao_lai_thanh_ly('<?= $contractInfor->_id->{'$oid'} ?>')"
							   data-id='<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>'
							   class="btn btn-info">Tạo lại yêu cầu định giá tài sản thanh lý </a>
						<?php endif; ?>
						<!--THN, Tạo phiếu thu thanh lý tài sản => START-->
						<?php if (in_array($contractInfor->status, array(40))) : ?>
							<a href="<?php echo base_url("accountant/view_v2?id=") . $contractInfor->_id->{'$oid'} . '#tab_content14' ?>"
							   class="btn btn-info" target="_blank">Tạo phiếu thu thanh lý tài sản </a>
						<?php endif; ?>
					<?php } ?>
					<!--THN, Gửi lại YC định giá TSTL => END-->

					<!--THN, Cập nhật giá tham khảo TSTL => START-->
					<?php if ($userSession['is_superadmin'] == 1 || in_array('tbp-thu-hoi-no', $groupRoles)) { ?>
						<?php if (in_array($contractInfor->status, array(46))) : ?>
							<a href="javascript:void(0)"
							   onclick="tpthn_update_refer('<?= $contractInfor->_id->{'$oid'} ?>')"
							   data-id='<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>'
							   class="btn btn-info">TP QLHDV cập nhật giá tham khảo </a>
						<?php endif; ?>
						<!--THN, Duyệt thay CEO TSTL-->
						<?php if (in_array($contractInfor->status, array(47))) : ?>
							<a href="javascript:void(0)"
							   onclick="tpthn_approve_rep('<?= $contractInfor->_id->{'$oid'} ?>')"
							   data-id='<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>'
							   class="btn btn-info">TP QLHDV duyệt thanh lý thay CEO </a>
						<?php endif; ?>
						<!--THN, Bán TSTL-->
						<?php if (in_array($contractInfor->status, array(48))) : ?>
							<a href="javascript:void(0)"
							   onclick="tpthn_sell_asset_liquidation('<?= $contractInfor->_id->{'$oid'} ?>')"
							   data-id='<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>'
							   class="btn btn-info">TP QLHDV bán tài sản thanh lý </a>
						<?php endif; ?>
					<?php } ?>
					<!--THN, Cập nhật giá tham khảo TSTL => END-->


				</div>
			</div>
		</div>

		<div class="col-xs-12 col-lg-12">
			<div class="x_panel ">
				<div class="x_content ">
					<div class="form-horizontal form-label-left">
						<div class="row">
							<div class="col-xs-12 col-md-6">
								<!--thông tin cá nhân-->
								<div class="x_title">
									<strong><i class="fa fa-user"
											   aria-hidden="true"></i> <?= $this->lang->line('Customer_information') ?>
									</strong>
									<div class="clearfix"></div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Email<span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="email" required id="customer_email"
											   value="<?= $contractInfor->customer_infor->customer_name ? $contractInfor->customer_infor->customer_email : "" ?>"
											   class="form-control email-autocomplete">
										<div id="results" class="smartsearchresult "></div>
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('Customer_name') ?><span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="customer_name" required
											   value="<?= $contractInfor->customer_infor->customer_name ? $contractInfor->customer_infor->customer_name : "" ?>"
											   class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('identify_current') ?><span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" required id="customer_identify"
											   value="<?= $contractInfor->customer_infor->customer_identify ? $contractInfor->customer_infor->customer_identify : "" ?>"
											   class="form-control identify-autocomplete">
										<div id="resultsIdentify" class="smartsearchresult "></div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('date_range') ?><span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" required id="date_range"
											   value="<?= $contractInfor->customer_infor->date_range ? date('d/m/Y', strtotime($contractInfor->customer_infor->date_range)) : "" ?>"
											   class="form-control">
										<div class="smartsearchresult "></div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('issued_by') ?><span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" required id="issued_by"
											   value="<?= $contractInfor->customer_infor->issued_by ? $contractInfor->customer_infor->issued_by : "" ?>"
											   class="form-control">
										<div class="smartsearchresult "></div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('identify_old') ?><span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" required id="customer_identify"
											   value="<?= $contractInfor->customer_infor->customer_identify_old ? $contractInfor->customer_infor->customer_identify_old : "" ?>"
											   class="form-control identify-new-autocomplete">
										<div id="resultsIdentifyOld" class="smartsearchresult "></div>
									</div>
								</div>

								<hr>

								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Số hộ chiếu:<span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" required id="customer_identify"
											   value="<?= $contractInfor->customer_infor->passport_number ? $contractInfor->customer_infor->passport_number : "" ?>"
											   class="form-control identify-autocomplete">
										<div id="resultsIdentify" class="smartsearchresult "></div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Nơi cấp hộ chiếu:<span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" required id="date_range"
											   value="<?= $contractInfor->customer_infor->passport_address ? $contractInfor->customer_infor->passport_address : "" ?>"
											   class="form-control">
										<div class="smartsearchresult "></div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Ngày cấp hộ chiếu:<span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" required id="issued_by"
											   value="<?= $contractInfor->customer_infor->passport_date ? date('d/m/Y', strtotime($contractInfor->customer_infor->passport_date)) : "" ?>"
											   class="form-control">
										<div class="smartsearchresult "></div>
									</div>
								</div>

								<hr>


								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('Sex') ?>
										<span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
										<label><input disabled name='customer_gender'
													  value="1" <?= $contractInfor->customer_infor->customer_gender == 1 ? "checked" : "" ?>
													  type="radio">&nbsp;<?= $this->lang->line('male') ?></label>
										<label><input disabled name='customer_gender'
													  value="2" <?= $contractInfor->customer_infor->customer_gender == 2 ? "checked" : "" ?>
													  type="radio">&nbsp;<?= $this->lang->line('Female') ?></label>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('Birthday') ?> <span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled id="customer_BOD" type='text'
											   value="<?= $contractInfor->customer_infor->customer_BOD ? date('d/m/Y', strtotime($contractInfor->customer_infor->customer_BOD)) : "" ?>"
											   class="form-control"/>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('phone_number') ?><span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<div class="input-group ">
											<input disabled type="text" required id="customer_phone_number"
												   value="<?= $contractInfor->customer_infor->customer_phone_number ? hide_phone($contractInfor->customer_infor->customer_phone_number) : "" ?>"
												   class="form-control phone-autocomplete">

											<a class="input-group-addon" href="javascript:void(0)"
											   onclick="call_for_customer('<?= !empty($contractInfor->customer_infor->customer_phone_number) ? encrypt($contractInfor->customer_infor->customer_phone_number) : "" ?>' , '<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>', 'customer')"
											   class="call_for_customer"><i class="fa fa-phone blue size18"
																			aria-hidden="true"></i>
											</a>
											<?php if (in_array('hoi-so', $groupRoles)): ?>

											<?php else: ?>
												<?php if (!in_array('cua-hang-truong', $groupRoles) && !in_array('giao-dich-vien', $groupRoles)) : ?>

												<?php endif; ?>
											<?php endif; ?>

										</div>
										<div id="resultsPhone" class="smartsearchresult "></div>
									</div>
								</div>
								<?php if (!empty($store_digital) && $store_digital == 1) : ?>
									<?php if (!empty($contractInfor->customer_infor->type_contract_sign)) { ?>
										<div class="form-group">
											<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Loại hợp
												đồng
												<span class="text-danger"> *</span>
											</label>
											<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
												<label class="text-danger"><input disabled name='type_contract_sign'
																				  value="1" <?= $contractInfor->customer_infor->type_contract_sign == 1 ? "checked" : ""; ?>
																				  type="radio">&nbsp;Hợp đồng điện
													tử</label>
												<label><input disabled name='type_contract_sign'
															  value="2" <?= $contractInfor->customer_infor->type_contract_sign == 2 ? "checked" : ""; ?>
															  type="radio">&nbsp;Hợp đồng giấy</label>
											</div>
										</div>
										<?php if (!empty($contractInfor->customer_infor->status_email) && !empty($contractInfor->customer_infor->type_contract_sign) && $contractInfor->customer_infor->type_contract_sign == 1) : ?>
											<div class="form-group">
												<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Nhận
													thông báo ký hợp đồng điện tử qua
													<span class="text-danger"> *</span>
												</label>
												<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
													<label><input disabled name='status_email'
																  value="1" <?= $contractInfor->customer_infor->status_email == 1 ? "checked" : "" ?>
																  type="radio">&nbsp;Email</label>
													<label><input disabled name='status_email'
																  value="2" <?= $contractInfor->customer_infor->status_email == 2 ? "checked" : "" ?>
																  type="radio">&nbsp;Tin nhắn SMS</label>
												</div>
											</div>
										<?php endif; ?>
									<?php } ?>
								<?php endif; ?>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Nguồn khách hàng
										<span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
										<?php
										$customer_resources = !empty($contractInfor->customer_infor->customer_resources) ? $contractInfor->customer_infor->customer_resources : "";
										$resources = "";
										if ($customer_resources == '1') {
											$resources = "Digital";
										}
										if ($customer_resources == '2') {
											$resources = "TLS Tự kiếm";
										}
										if ($customer_resources == '3') {
											$resources = "Tổng đài";
										}
										if ($customer_resources == '4') {
											$resources = "Giới thiệu";
										}
										if ($customer_resources == '5') {
											$resources = "Đối tác";
										}
										if ($customer_resources == '6') {
											$resources = "Fanpage";
										}
										if ($customer_resources == '7') {
											$resources = "Nguồn khác";
										}
										if ($customer_resources == '8') {
											$resources = "KH vãng lai";
										}
										if ($customer_resources == '9') {
											$resources = "KH tự kiếm";
										}
										if ($customer_resources == '10') {
											$resources = "Cộng tác viên";
										}
										if ($customer_resources == '11') {
											$resources = "KH giới thiệu KH";
										}
										if ($customer_resources == '12') {
											$resources = "Nguồn App Mobile";
										}
										if ($customer_resources == 'VM') {
											$resources = "Nguồn vay mượn";
										}
										if ($customer_resources == 'hoiso') {
											$resources = "Nguồn hội sở";
										}
										if ($customer_resources == 'tukiem') {
											$resources = "Nguồn tự kiếm";
										}
										if ($customer_resources == 'vanglai') {
											$resources = "Nguồn vãng lai";
										}
										if ($customer_resources == 'VPS') {
											$resources = "VPS";
										}
										if ($customer_resources == 'MB') {
											$resources = "MB";
										}
										if ($customer_resources == '14') {
											$resources = "Tool FB";
										}
										if ($customer_resources == '15') {
											$resources = "Tiktok";
										}
										if ($customer_resources == '16') {
											$resources = "Remarketing";
										}
										if ($customer_resources == 'Homedy') {
											$resources = "Homedy";
										}
										if ($customer_resources == 'Merchant') {
											$resources = "Merchant";
										}
										if ($customer_resources == '17') {
											$resources = "Nguồn ngoài";
										}
										?>

										<input disabled type="text" id="job" value="<?php echo $resources ?>" required
											   class="form-control">
									</div>
								</div>

								<?php
								if (!empty($list_ctv)) {
									foreach ($list_ctv as $key => $value) {
										if ($value->ctv_code == $contractInfor->customer_infor->list_ctv) {
											$name_ctv = $value->ctv_name;
										}
									}
								}

								?>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Cộng tác viên <span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type='text'
											   value="<?= !empty($contractInfor->customer_infor->list_ctv) ? $contractInfor->customer_infor->list_ctv . " - " . $name_ctv : "" ?>"
											   class="form-control"/>
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('Marital_status') ?>
										<span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
										<label><input disabled name='marriage'
													  value="1" <?= $contractInfor->customer_infor->marriage == 1 ? "checked" : "" ?>
													  type="radio">&nbsp;Đã kết hôn</label>
										<label><input disabled name='marriage'
													  value="2" <?= $contractInfor->customer_infor->marriage == 2 ? "checked" : "" ?>
													  type="radio">&nbsp;Chưa kết hôn</label>
										<label><input disabled name='marriage'
													  value="3" <?= $contractInfor->customer_infor->marriage == 3 ? "checked" : "" ?>
													  type="radio">&nbsp;Ly hôn</label>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Blacklist <span
												class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
										<label><input disabled name='is_blacklist'
													  value="1" <?= $contractInfor->customer_infor->is_blacklist == 1 ? "checked" : "" ?>
													  type="radio">&nbsp;Có</label>
										<label><input disabled name='is_blacklist'
													  value="0" <?= empty($contractInfor->customer_infor->is_blacklist) || $contractInfor->customer_infor->is_blacklist == 0 ? "checked" : "" ?>
													  type="radio">&nbsp;Không</label>
									</div>
								</div>
								<!-- <div class="form-group">
                           <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <?= $this->lang->line('Facebook') ?><span class="text-danger"> *</span>
                           </label>
                           <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                               <input type="text" required id="customer_fb" value="<?= $contractInfor->customer_infor->customer_fb ? $contractInfor->customer_infor->customer_fb : "" ?>" class="form-control">
                           </div>
                           </div>
                           <div class="form-group">
                           <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <?= $this->lang->line('Number_household') ?> <span class="text-danger"> *</span>
                           </label>
                           <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                               <input type="text" required id="customer_household" value="<?= $contractInfor->customer_infor->customer_household ? $contractInfor->customer_infor->customer_household : "" ?>" class="form-control">
                           </div>
                           </div>
                           <div class="form-group">
                           <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <?= $this->lang->line('Passport') ?> <span class="text-danger"> *</span>
                           </label>
                           <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                               <input type="text" id="customer_passport" value="<?= $contractInfor->customer_infor->customer_passport ? $contractInfor->customer_infor->customer_passport : "" ?>" class="form-control">
                           </div>
                           </div>

                           <div class="form-group">
                           <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                           <?= $this->lang->line('Insurance_book') ?><span class="text-danger"> *</span>
                           </label>
                           <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                               <input type="text" required id="customer_insurance" value="<?= $contractInfor->customer_infor->customer_insurance ? $contractInfor->customer_infor->customer_insurance : "" ?>" class="form-control">
                           </div>
                           </div> -->
								<!--end thông tin cá nhân-->
								<!-- địa chỉ đang ở-->
								<div class="x_title">
									<strong><i class="fa fa-user"
											   aria-hidden="true"></i> <?= $this->lang->line('The_address') ?></strong>
									<div class="clearfix"></div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('Province_City1') ?><span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<select class="form-control" id="selectize_province_current_address" disabled>
											<option value=""><?= $this->lang->line('Province_City2') ?></option>
											<?php
											if (!empty($provinceData)) {
												foreach ($provinceData as $key => $province) {
													?>
													<option <?= $contractInfor->current_address->province == $province->code ? "selected" : "" ?>
															value="<?= !empty($province->code) ? $province->code : ""; ?>"><?= !empty($province->name) ? $province->name : ""; ?></option>
												<?php }
											} ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('District') ?> <span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<select class="form-control" id="selectize_district_current_address" disabled>
											<option value=""><?= $this->lang->line('District1') ?></option>
											<?php
											if (!empty($districtData)) {
												foreach ($districtData as $key => $district) {
													?>
													<option <?= $contractInfor->current_address->district == $district->code ? "selected" : "" ?>
															value="<?= !empty($district->code) ? $district->code : ""; ?>"><?= !empty($district->name) ? $district->name : ""; ?></option>
												<?php }
											} ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('Wards') ?>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<select disabled class="form-control" id="selectize_ward_current_address">
											<option value=""><?= $this->lang->line('Wards1') ?></option>
											<?php
											if (!empty($wardData)) {
												foreach ($wardData as $key => $ward) {
													?>
													<option <?= $contractInfor->current_address->ward == $ward->code ? "selected" : "" ?>
															value="<?= !empty($ward->code) ? $ward->code : ""; ?>"><?= !empty($ward->name) ? $ward->name : ""; ?></option>
												<?php }
											} ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('Residence_form') ?> <span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input type="text" id="form_residence_current_address" disabled
											   value="<?= $contractInfor->current_address->form_residence ? $contractInfor->current_address->form_residence : "" ?>"
											   required class="form-control">
										<!-- <select disabled class="form-control" id="form_residence_current_address">
                                 <option  <?= $contractInfor->current_address->form_residence == 'Tạm trú' ? "selected" : "" ?>  value="Tạm trú"> Tạm trú</option>
                                 <option <?= $contractInfor->current_address->form_residence == 'Thường trú' ? "selected" : "" ?>  value="Thường trú"> Thường trú</option>
                                 </select> -->
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('Time_live') ?> <span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="time_life_current_address"
											   value="<?= $contractInfor->current_address->time_life ? $contractInfor->current_address->time_life : "" ?>"
											   required class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('address_is_in') ?> <span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="current_stay_current_address"
											   value="<?= $contractInfor->current_address->current_stay ? $contractInfor->current_address->current_stay : "" ?>"
											   required class="form-control">
									</div>
								</div>
								<!--end địa chỉ đang ở-->
								<!--địa chỉ hộ khẩu-->
								<div class="x_title">
									<strong><i class="fa fa-user"
											   aria-hidden="true"></i> <?= $this->lang->line('Household_address') ?>
									</strong>
									<div class="clearfix"></div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('Province_City1') ?><span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<select disabled class="form-control" id="selectize_province_household">
											<option value=""><?= $this->lang->line('Province_City2') ?></option>
											<?php
											if (!empty($provinceData_)) {
												foreach ($provinceData_ as $key => $province) {
													?>
													<option <?= $contractInfor->houseHold_address->province == $province->code ? "selected" : "" ?>
															value="<?= !empty($province->code) ? $province->code : ""; ?>"><?= !empty($province->name) ? $province->name : ""; ?></option>
												<?php }
											} ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('District') ?> <span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<select disabled class="form-control" id="selectize_district_household">
											<option value=""><?= $this->lang->line('District1') ?> </option>
											<?php
											if (!empty($districtData_)) {
												foreach ($districtData_ as $key => $district) {
													?>
													<option <?= $contractInfor->houseHold_address->district == $district->code ? "selected" : "" ?>
															value="<?= !empty($district->code) ? $district->code : ""; ?>"><?= !empty($district->name) ? $district->name : ""; ?></option>
												<?php }
											} ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('Wards') ?>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<select disabled class="form-control" id="selectize_ward_household">
											<option value=""><?= $this->lang->line('Wards1') ?></option>
											<?php
											if (!empty($wardData_)) {
												foreach ($wardData_ as $key => $ward) {
													?>
													<option <?= $contractInfor->houseHold_address->ward == $ward->code ? "selected" : "" ?>
															value="<?= !empty($ward->code) ? $ward->code : ""; ?>"><?= !empty($ward->name) ? $ward->name : ""; ?></option>
												<?php }
											} ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('address_is_in') ?><span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="address_household"
											   value="<?= $contractInfor->houseHold_address->address_household ? $contractInfor->houseHold_address->address_household : "" ?>"
											   required class="form-control">
									</div>
								</div>
								<!--end địa chỉ hộ khẩu-->
								<!--Thông tin việc làm-->
								<div class="x_title">
									<strong><i class="fa fa-user"
											   aria-hidden="true"></i> <?= $this->lang->line('Employment_information') ?>
									</strong>
									<div class="clearfix"></div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('Company_name') ?><span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="name_company"
											   value="<?= $contractInfor->job_infor->name_company ? $contractInfor->job_infor->name_company : "" ?>"
											   required class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('Company_address') ?><span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="address_company"
											   value="<?= $contractInfor->job_infor->address_company ? $contractInfor->job_infor->address_company : "" ?>"
											   required class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('Company_phone_number') ?><span
												class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input type="number" disabled id="phone_number_company"
											   value="<?= $contractInfor->job_infor->phone_number_company ? $contractInfor->job_infor->phone_number_company : "" ?>"
											   required class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('Job_position') ?><span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input type="text" disabled id="job_position"
											   value="<?= $contractInfor->job_infor->job_position ? $contractInfor->job_infor->job_position : "" ?>"
											   required class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Thời gian làm việc<span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input type="text" disabled id="job_position"
											   value="<?= $contractInfor->job_infor->work_year ? $contractInfor->job_infor->work_year : "" ?>"
											   required class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('Income') ?><span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="salary"
											   value="<?= $contractInfor->job_infor->salary ? $contractInfor->job_infor->salary : "" ?>"
											   required class="form-control">
									</div>
								</div>
								<!-- <div class="form-group">
                           <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                           <?= $this->lang->line('job') ?><span class="text-danger"> *</span>
                           </label>
                           <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                               <input disabled type="text" id="name_job" value="<?= $contractInfor->job_infor->name_job ? $contractInfor->job_infor->name_job : "" ?>" required class="form-control">
                           </div>
                           </div> -->
								<!--
                           <div class="form-group">
                               <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                               <?= $this->lang->line('Tax_code') ?><span class="text-danger"> *</span>
                               </label>
                               <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                   <input type="text" id="number_tax_company" value="<?= $contractInfor->job_infor->number_tax_company ? $contractInfor->job_infor->number_tax_company : "" ?>" required class="form-control">
                               </div>
                           </div> -->
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('Form_payment_wages') ?><span
												class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<?php
										$receive = !empty($contractInfor->job_infor->receive_salary_via) ? $contractInfor->job_infor->receive_salary_via : "";
										if (!empty($receive) && $receive == 1) {
											$receive_salary_via = 'Tiền mặt';
										} else if ($receive == 2) {
											$receive_salary_via = 'Chuyển khoản';
										} else {
											$receive_salary_via = '';
										}

										?>
										<input disabled type="text" id="receive_salary_via"
											   value="<?= !empty($receive_salary_via) ? $receive_salary_via : "" ?>"
											   required class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Nghề Nghiệp<span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="job"
											   value="<?= $contractInfor->job_infor->job ? $contractInfor->job_infor->job : "" ?>"
											   required class="form-control">
									</div>
								</div>
								<!--end Thông tin việc làm-->
								<!--Thông tin người thân-->
								<div class="x_title">
									<strong><i class="fa fa-user"
											   aria-hidden="true"></i> <?= $this->lang->line('Information_relatives') ?>
									</strong>
									<div class="clearfix"></div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Tên người tham chiếu 1<span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="fullname_relative_1"
											   value="<?= $contractInfor->relative_infor->fullname_relative_1 ? $contractInfor->relative_infor->fullname_relative_1 : "" ?>"
											   required class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Mối quan hệ<span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="type_relative_1"
											   value="<?= $contractInfor->relative_infor->type_relative_1 ? $contractInfor->relative_infor->type_relative_1 : "" ?>"
											   required class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('Telephone_number_relative') ?><span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<div class="input-group ">
											<input disabled type="text" id="phone_number_relative_1"
												   value="<?= $contractInfor->relative_infor->phone_number_relative_1 ? hide_phone($contractInfor->relative_infor->phone_number_relative_1) : "" ?>"
												   required class="form-control phone-autocomplete">
											<a class="input-group-addon" href="javascript:void(0)"
											   onclick="call_for_customer('<?= $log_contract_thn->phone_number_relative_1 ? encrypt($log_contract_thn->phone_number_relative_1) : encrypt($contractInfor->relative_infor->phone_number_relative_1) ?>' , '<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>', 'rel1')"
											   class="call_for_customer"><i class="fa fa-phone blue size18"
																			aria-hidden="true"></i>
											</a>
											<?php if (in_array('hoi-so', $groupRoles)): ?>

											<?php else: ?>
												<?php if (!in_array('cua-hang-truong', $groupRoles) && !in_array('giao-dich-vien', $groupRoles)) : ?>

												<?php endif; ?>
											<?php endif; ?>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Bảo mật khoản vay tham chiếu 1
										<span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
										<label><input disabled name='loan_security_one'
													  value="1" <?= $contractInfor->relative_infor->loan_security_1 == 1 ? "checked" : "" ?>
													  type="radio">&nbsp;Công khai</label>
										<label><input disabled name='loan_security_one'
													  value="2" <?= $contractInfor->relative_infor->loan_security_1 == 2 ? "checked" : "" ?>
													  type="radio">&nbsp;Bảo mật</label>
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('Residential_address') ?><span
												class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="hoursehold_relative_1"
											   value="<?= $contractInfor->relative_infor->hoursehold_relative_1 ? $contractInfor->relative_infor->hoursehold_relative_1 : "" ?>"
											   required class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Phản hồi <span class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<textarea disabled type="text" id="confirm_relativeInfor1" required=""
												  class="form-control"><?= !empty($contractInfor->relative_infor->confirm_relativeInfor_1) ? $contractInfor->relative_infor->confirm_relativeInfor_1 : "" ?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Tên người tham chiếu 2<span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="fullname_relative_2"
											   value="<?= $contractInfor->relative_infor->fullname_relative_2 ? $contractInfor->relative_infor->fullname_relative_2 : "" ?>"
											   required class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Mối quan hệ<span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="type_relative_2"
											   value="<?= $contractInfor->relative_infor->type_relative_2 ? $contractInfor->relative_infor->type_relative_2 : "" ?>"
											   required class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('Telephone_number_relative') ?><span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<div class="input-group ">
											<input disabled type="text" id="phone_number_relative_2"
												   value="<?= $contractInfor->relative_infor->phone_number_relative_2 ? hide_phone($contractInfor->relative_infor->phone_number_relative_2) : "" ?>"
												   required class="form-control phone-autocomplete">
											<a class="input-group-addon" href="javascript:void(0)"
											   onclick="call_for_customer('<?= $log_contract_thn->phone_number_relative_2 ? encrypt($log_contract_thn->phone_number_relative_2) : encrypt($contractInfor->relative_infor->phone_number_relative_2) ?>' , '<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>', 'rel2')"
											   class="call_for_customer"><i class="fa fa-phone blue size18"
																			aria-hidden="true"></i>
											</a>
											<?php if (in_array('hoi-so', $groupRoles)): ?>

											<?php else: ?>
												<?php if (!in_array('cua-hang-truong', $groupRoles) && !in_array('giao-dich-vien', $groupRoles)) : ?>

												<?php endif; ?>
											<?php endif; ?>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Bảo mật khoản vay tham chiếu 2
										<span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
										<label><input disabled name='loan_security_two'
													  value="1" <?= $contractInfor->relative_infor->loan_security_2 == 1 ? "checked" : "" ?>
													  type="radio">&nbsp;Công khai</label>
										<label><input disabled name='loan_security_two'
													  value="2" <?= $contractInfor->relative_infor->loan_security_2 == 2 ? "checked" : "" ?>
													  type="radio">&nbsp;Bảo mật</label>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('Residential_address') ?><span
												class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="hoursehold_relative_2"
											   value="<?= $contractInfor->relative_infor->hoursehold_relative_2 ? $contractInfor->relative_infor->hoursehold_relative_2 : "" ?>"
											   required class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Phản hồi <span class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<textarea disabled type="text" id="confirm_relativeInfor2" required=""
												  class="form-control"><?= !empty($contractInfor->relative_infor->confirm_relativeInfor_2) ? $contractInfor->relative_infor->confirm_relativeInfor_2 : "" ?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Tên người tham chiếu 3<span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="fullname_relative_2"
											   value="<?= $contractInfor->relative_infor->fullname_relative_3 ? $contractInfor->relative_infor->fullname_relative_3 : "" ?>"
											   required class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Địa chỉ<span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="address_relative_3"
											   value="<?= $contractInfor->relative_infor->address_relative_3 ? $contractInfor->relative_infor->address_relative_3 : "" ?>"
											   required class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('Telephone_number_relative') ?><span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<div class="input-group ">
											<input disabled type="text" id="phone_relative_3"
												   value="<?= $contractInfor->relative_infor->phone_relative_3 ? hide_phone($contractInfor->relative_infor->phone_relative_3) : "" ?>"
												   required class="form-control phone-autocomplete">
											<a class="input-group-addon" href="javascript:void(0)"
											   onclick="call_for_customer('<?= $log_contract_thn->phone_relative_3 ? encrypt($log_contract_thn->phone_relative_3) : encrypt($contractInfor->relative_infor->phone_relative_3) ?>' , '<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>', 'rel2')"
											   class="call_for_customer"><i class="fa fa-phone blue size18"
																			aria-hidden="true"></i>
											</a>
											<?php
											if (!in_array('cua-hang-truong', $groupRoles) && !in_array('giao-dich-vien', $groupRoles)) {
												?>

											<?php } ?>

										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Bảo mật khoản vay tham chiếu 3
										<span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
										<label><input disabled name='loan_security_three'
													  value="1" <?= $contractInfor->relative_infor->loan_security_3 == 1 ? "checked" : "" ?>
													  type="radio">&nbsp;Công khai</label>
										<label><input disabled name='loan_security_three'
													  value="2" <?= $contractInfor->relative_infor->loan_security_3 == 2 ? "checked" : "" ?>
													  type="radio">&nbsp;Bảo mật</label>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Mục đích tham chiếu<span
												class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="hoursehold_relative_2"
											   value="<?= $contractInfor->relative_infor->type_relative_3 ? $contractInfor->relative_infor->type_relative_3 : "" ?>"
											   required class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Phản hồi <span class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<textarea disabled type="text" id="confirm_relativeInfor3" required=""
												  class="form-control"><?= !empty($contractInfor->relative_infor->confirm_relativeInfor3) ? $contractInfor->relative_infor->confirm_relativeInfor3 : "" ?></textarea>
									</div>
								</div>
								<!-- <div class="form-group">
                           <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('Who_you_living_with') ?> <span class="text-danger"> *</span>
                           </label>
                           <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 " >
                               <label><input name='stay_with' value="1" <?= $contractInfor->customer_infor->stay_with == 1 ? "checked" : "" ?> type="radio">&nbsp; <?= $this->lang->line('Parents') ?></label>
                               <label><input name="stay_with" value="2" <?= $contractInfor->customer_infor->stay_with == 2 ? "checked" : "" ?> type="radio">&nbsp;<?= $this->lang->line('Wife_children') ?></label>
                               <label><input name="stay_with" value="3" <?= $contractInfor->customer_infor->stay_with == 3 ? "checked" : "" ?> type="radio">&nbsp;<?= $this->lang->line('Alone') ?></label>
                           </div>
                           </div>
                           <div class="form-group">
                           <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('How_many_grandchildren') ?> <span class="text-danger"> *</span>
                           </label>
                           <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 " >
                               <label><input name='number_children' value="1" <?= $contractInfor->customer_infor->number_children == 1 ? "checked" : "" ?> type="radio">&nbsp;<?= $this->lang->line('Not_yet1') ?></label>
                               <label><input name='number_children' value="2" <?= $contractInfor->customer_infor->number_children == 2 ? "checked" : "" ?> type="radio">&nbsp;1 <?= $this->lang->line('grandchildren') ?></label>
                               <label><input name='number_children' value="3" <?= $contractInfor->customer_infor->number_children == 3 ? "checked" : "" ?> type="radio">&nbsp;2 <?= $this->lang->line('grandchildren') ?></label>
                               <label><input name='number_children' value="4" <?= $contractInfor->customer_infor->number_children == 4 ? "checked" : "" ?> type="radio"> &nbsp;> 2 <?= $this->lang->line('grandchildren') ?></label>
                           </div>
                           </div> -->
								<!--end Thông tin người thân-->
								<!--Hình thức thanh toán khoản vay-->
								<div class="x_title">
									<strong><i class="fa fa-user"
											   aria-hidden="true"></i> <?= $this->lang->line('Payment_Debt_Method_Infor') ?>
									</strong>
									<div class="clearfix"></div>
								</div>


								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Ngân hàng
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" value="<?= $contractInfor->vpbank_van->bank_name ?>"
											   required class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Số tài khoản
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="type_relative_1"
											   value="<?= $contractInfor->vpbank_van->van ?>" required
											   class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Chủ tài khoản
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="type_relative_1"
											   value="<?= $contractInfor->vpbank_van->master_account_name ?>" required
											   class="form-control">
									</div>
								</div>
								<!--end Hình thức thanh toán khoản vay-->
							</div>
							<div class="col-xs-12 col-md-6">
								<!-- Thông tin khoản vay-->
								<div class="x_title">
									<strong><i class="fa fa-money"
											   aria-hidden="true"></i> <?= $this->lang->line('Loan_information') ?>
									</strong>
									<div class="clearfix"></div>
								</div>
								<?php if (empty($dataInit['type_finance']) && empty($dataInit['main'])) { ?>
									<?php
									$data['configuration_formality'] = $configuration_formality;
									$data['mainPropertyData'] = $mainPropertyData;
									$this->load->view("page/property/template/loan_infor_no_init", $data)
									?>
								<?php } ?>
								<!--Init from định giá tài sản-->
								<?php if (!empty($dataInit['type_finance']) && !empty($dataInit['main'])) { ?>
									<?php
									$data['configuration_formality'] = $configuration_formality;
									$data['mainPropertyData'] = $mainPropertyData;
									$data['dataInit'] = $dataInit;
									$this->load->view("page/property/template/loan_infor_have_init.php", $data);
									?>
								<?php } ?>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Số tiền vay<span class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="money" required class="form-control number"
											   value="<?= $contractInfor->loan_infor->amount_money ? number_format($contractInfor->loan_infor->amount_money) : "" ?>">
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Số tiền giải ngân<span class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="money_gn" required class="form-control number"
											   value="<?= $contractInfor->loan_infor->amount_loan ? number_format($contractInfor->loan_infor->amount_loan) : "" ?>">
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Mục đích vay <span
												class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
										<input disabled type="text" id="loan_purpose" required class="form-control"
											   value="<?= !empty($contractInfor->loan_infor->loan_purpose) ? $contractInfor->loan_infor->loan_purpose : "" ?>">
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('Number_loan_days') ?><span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="number_day_loan"
											   value="<?= $contractInfor->loan_infor->number_day_loan ? $contractInfor->loan_infor->number_day_loan : "" ?>"
											   required class="form-control">
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<?= $this->lang->line('Interest_payment_period') ?> <span
												class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="period_pay_interest"
											   value="<?= $contractInfor->loan_infor->period_pay_interest ? $contractInfor->loan_infor->period_pay_interest : "" ?>"
											   required class="form-control">
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"> <?= $this->lang->line('formality2') ?>
										<span class="text-danger"> *</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<select disabled class="form-control" id="type_interest">
											<option value="1" <?= $contractInfor->loan_infor->type_interest == 1 ? "selected='selected'" : "" ?>><?= $this->lang->line('Outstanding_descending') ?></option>
											<option value="2" <?= $contractInfor->loan_infor->type_interest == 2 ? "selected='selected'" : "" ?>><?= $this->lang->line('Monthly_interest_principal_maturity') ?></option>
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Gói phí <span
												class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
										<select class="form-control" name="fee_id" disabled>

											<?php
											foreach ($fee_data as $key => $item) { ?>
												<option <?= $contractInfor->fee_id == $item->_id->{'$oid'} ? "selected" : "" ?>><?= $item->title ?></option>
											<?php } ?>
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Bảo hiểm khoản vay
										<span class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
										<label><input disabled name='insurrance' checked=""
													  value="1" <?= $contractInfor->loan_infor->insurrance_contract == 1 ? "checked" : "" ?>
													  type="radio">&nbsp;<?= $this->lang->line('have') ?></label>
										<label><input disabled
													  name='insurrance' <?= $contractInfor->loan_infor->insurrance_contract == 2 ? "checked" : "" ?>
													  value="2" type="radio">&nbsp;Không</label>
									</div>
								</div>

								<?php

								$amount_insurrance = 0;
								$type_amount_insurrance = '';
								$number_day_loan = $contractInfor->loan_infor->number_day_loan ? $contractInfor->loan_infor->number_day_loan : 0;
								$amount_money = isset($contractInfor->loan_infor->amount_money) ? $contractInfor->loan_infor->amount_money : 0;
								if (isset($contractInfor->loan_infor->loan_insurance) && $contractInfor->loan_infor->loan_insurance == "1") {
									$amount_insurrance = isset($contractInfor->loan_infor->amount_GIC) ? $contractInfor->loan_infor->amount_GIC : 0;
									$type_amount_insurrance = "GIC";
								} else if (isset($contractInfor->loan_infor->loan_insurance) && $contractInfor->loan_infor->loan_insurance == "2") {
									$amount_insurrance = isset($contractInfor->loan_infor->amount_MIC) ? $contractInfor->loan_infor->amount_MIC : 0;
									$type_amount_insurrance = "MIC";

								}
								if ($type_amount_insurrance == "GIC")
									if (!checkBH($amount_money, $amount_insurrance, "GIC_KV", $number_day_loan, $contractInfor->created_at)) {
										$message = "Hợp đồng sai số tiền bảo hiểm khoản vay GIC.";
										echo "<script type='text/javascript'>alert('$message');</script>";

									}
								if ($type_amount_insurrance == "MIC")
									if (!checkBH($amount_money, $amount_insurrance, "MIC_KV", $number_day_loan, $contractInfor->created_at)) {
										$message = "Hợp đồng sai số tiền bảo hiểm khoản vay MIC.";
										echo "<script type='text/javascript'>alert('$message');</script>";

									}
								if (!checkBH($amount_money, $amount_insurrance, "GIC_EASY", $number_day_loan, $contractInfor->created_at)) {
									$message = "Hợp đồng sai số tiền bảo hiểm xe máy GIC EASY.";
									echo "<script type='text/javascript'>alert('$message');</script>";

								}
								?>

								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Loại bảo hiểm khoản vay<span class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="fee_gic" required class="form-control number"
											   value="<?= $type_amount_insurrance ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Phí bảo hiểm khoản vay<span class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="fee_gic" required class="form-control number"
											   value="<?= $amount_insurrance ?>">
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Phí bảo hiểm xe<span class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="fee_gic" required class="form-control number"
											   value="<?= (isset($contractInfor->loan_infor->amount_GIC_easy)) ? number_format($contractInfor->loan_infor->amount_GIC_easy) : "" ?>">
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Bảo hiểm phúc lộc
										thọ<span class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
										<input disabled type="text" id="code_GIC_plt" required class="form-control"
											   value="<?= !empty($contractInfor->loan_infor->code_GIC_plt) ? get_code_plt($contractInfor->loan_infor->code_GIC_plt) : "" ?>">
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Phí bảo hiểm phúc
										lộc thọ<span class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
										<input disabled type="text" id="amount_GIC_plt" required class="form-control"
											   value="<?= !empty($contractInfor->loan_infor->amount_GIC_plt) ? $contractInfor->loan_infor->amount_GIC_plt : "0" ?>">
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Bảo hiểm VBI<span
												class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
										<select class="form-control" name="code_vbi2" disabled>
											<option value=""></option>
											<?php foreach (lead_VBI() as $key => $item) { ?>
												<option <?php echo $contractInfor->loan_infor->code_VBI_1 == $item ? 'selected' : '' ?>
														value="<?= $key ?>"><?= $item ?></option>
											<?php } ?>
										</select>

									</div>

								</div>

								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"><span
												class="text-danger"></span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">

										<select class="form-control" name="code_vbi2" disabled>
											<option value=""></option>
											<?php foreach (lead_VBI() as $key => $item) { ?>
												<option <?php echo $contractInfor->loan_infor->code_VBI_2 == $item ? 'selected' : '' ?>
														value="<?= $key ?>"><?= $item ?></option>
											<?php } ?>
										</select>

									</div>
								</div>


								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Phí bảo hiểm VBI
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">

										<input type="text" id="fee_vbi" class="form-control number"
											   value="<?= (isset($contractInfor->loan_infor->amount_VBI)) ? number_format($contractInfor->loan_infor->amount_VBI) : 0 ?>"
											   disabled>

									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Phí bảo hiểm TNDS
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">

										<input type="text" id="fee_tnds" class="form-control number"
											   value="<?= (isset($contractInfor->loan_infor->bao_hiem_tnds->price_tnds)) ? number_format($contractInfor->loan_infor->bao_hiem_tnds->price_tnds) : 0 ?>"
											   disabled>

									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Phí bảo hiểm PTI
										Vững Tâm An
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">

										<input type="text" id="fee_tnds" class="form-control number"
											   value="<?= (isset($contractInfor->loan_infor->bao_hiem_pti_vta->price_pti_vta)) ? number_format($contractInfor->loan_infor->bao_hiem_pti_vta->price_pti_vta) : 0 ?>"
											   disabled>

									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">PTI Gói
										BHTN</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
										<?php
										$ptiBhtnGoi = isset($contractInfor->loan_infor->pti_bhtn->goi) ? $contractInfor->loan_infor->pti_bhtn->goi : '';
										$ptiBhtnPhi = isset($contractInfor->loan_infor->pti_bhtn->phi) ? number_format($contractInfor->loan_infor->pti_bhtn->phi) : '';
										$ptiBhtnPrice = isset($contractInfor->loan_infor->pti_bhtn->price) ? number_format($contractInfor->loan_infor->pti_bhtn->price) : '';
										if ($ptiBhtnGoi && $ptiBhtnPhi && $ptiBhtnPrice) {
											?>
											<input type="text" id="pti_bhtn_goi" class="form-control number"
												   value="<?= $ptiBhtnGoi . '-' . $ptiBhtnPrice; ?>" disabled>
										<?php } else { ?>
											<input type="text" id="pti_bhtn_goi" class="form-control number" value=""
												   disabled>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">PTI Phí
										BHTN</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
										<?php
										$ptiBhtnGoi = isset($contractInfor->loan_infor->pti_bhtn->goi) ? $contractInfor->loan_infor->pti_bhtn->goi : '';
										$ptiBhtnGoi = isset($contractInfor->loan_infor->pti_bhtn->goi) ? $contractInfor->loan_infor->pti_bhtn->goi : '';
										$ptiBhtnPhi = isset($contractInfor->loan_infor->pti_bhtn->phi) ? number_format($contractInfor->loan_infor->pti_bhtn->phi) : '';
										$ptiBhtnPrice = isset($contractInfor->loan_infor->pti_bhtn->price) ? number_format($contractInfor->loan_infor->pti_bhtn->price) : '';
										if ($ptiBhtnGoi && $ptiBhtnPhi && $ptiBhtnPrice) {
											?>
											<input type="text" id="pti_bhtn_fee" class="form-control number"
												   value="<?= $ptiBhtnPhi; ?>" disabled>
										<?php } else { ?>
											<input type="text" id="pti_bhtn_fee" class="form-control number" value="0"
												   disabled>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Mã coupon <span
												class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
										<input disabled type="text" id="code_coupon" required class="form-control"
											   value="<?= !empty($contractInfor->loan_infor->code_coupon) ? $contractInfor->loan_infor->code_coupon : "" ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Mã giảm bảo hiểm
										khoản vay <span
												class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
										<input disabled type="text" id="code_coupon_bhkv" required class="form-control"
											   value="<?= !empty($contractInfor->code_coupon_bhkv) ? $contractInfor->code_coupon_bhkv : "" ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Số tiền giảm bảo
										hiểm khoản vay <span
												class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
										<input disabled type="text" id="tien_giam_tru_bhkv" required
											   class="form-control"
											   value="<?= !empty($contractInfor->tien_giam_tru_bhkv) ? number_format($contractInfor->tien_giam_tru_bhkv) : 0 ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('note') ?>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<textarea disabled type="text" id="note" required
												  value="<?= !empty($contractInfor->loan_infor->note) ? $contractInfor->loan_infor->note : "" ?>"
												  class="form-control"><?= !empty($contractInfor->loan_infor->note) ? $contractInfor->loan_infor->note : "" ?></textarea>
									</div>
								</div>
								<!--End Thông tin khoản vay-->
								<!--Thông tin tài sản-->
								<div class="x_title">
									<strong><i class="fa fa-motorcycle"
											   aria-hidden="true"></i> <?= $this->lang->line('Property_information') ?>
									</strong>
									<div class="clearfix"></div>
								</div>
								<div class='properties'>
									<?php if (!empty($contractInfor->property_infor)) {
										foreach ($contractInfor->property_infor as $item) { ?>
											<div class="form-group"></div>
											<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"><?= $item->name ?>
												<span class="text-danger"> *</span></label>
											<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
												<input disabled type="text" name="property_infor" required
													   value="<?= $item->value ?>" class="form-control property-infor"
													   data-slug="<?= $item->slug ?>" data-name="<?= $item->name ?>"
													   placeholder="<?= $item->name ?>">
											</div>
										<?php }
									} ?>
									<div class="form-group"></div>
									<?php if (!empty($asset)) : ?>
										<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
											HD có tài sản đang vay<span class="text-danger">*</span>
										</label>
										<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
											<?php foreach ($asset as $as): ?>
												<?php if ($contractInfor->code_contract == $as->code_contract): ?>
													<?php continue; ?>
												<?php endif; ?>
												<a class="btn btn-success"
												   href="<?php echo base_url("pawn/detail?id=") . $as->id ?>"><?php echo $as->code_contract ?></a>
											<?php endforeach; ?>
										</div>
									<?php endif; ?>
									<?php if ($contractInfor->loan_infor->type_property->code == 'OTO' || $contractInfor->loan_infor->loan_product->code == "19") { ?>
										<div class="form-group">
											<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Gắn định
												vị
												<span class="text-danger">*</span>
											</label>
											<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
												<label><input disabled name='gan_dinh_vi' checked=""
															  value="1" <?= $contractInfor->loan_infor->gan_dinh_vi == 1 ? "checked" : "" ?>
															  type="radio">&nbsp;<?= $this->lang->line('have') ?>
												</label>
												<label><input disabled
															  name='gan_dinh_vi' <?= $contractInfor->loan_infor->gan_dinh_vi == 2 ? "checked" : "" ?>
															  value="2" type="radio">&nbsp;Không</label>
											</div>
										</div>
									<?php } ?>
									<?php if ($contractInfor->loan_infor->type_property->code == 'OTO' && $contractInfor->loan_infor->type_loan->code == 'CC') { ?>
										<div class="form-group">
											<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Ô tô ngân
												hàng
												<span class="text-danger">*</span>
											</label>
											<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
												<label><input disabled name='o_to_ngan_hang' checked=""
															  value="1" <?= $contractInfor->loan_infor->o_to_ngan_hang == 1 ? "checked" : "" ?>
															  type="radio">&nbsp;<?= $this->lang->line('have') ?>
												</label>
												<label><input disabled
															  name='o_to_ngan_hang' <?= $contractInfor->loan_infor->o_to_ngan_hang == 2 ? "checked" : "" ?>
															  value="2" type="radio">&nbsp;Không</label>
											</div>
										</div>
									<?php } ?>
								</div>
								<div class="form-group"></div>
								<!--thông tin giai ngan-->
								<div class="x_title">
									<strong><i class="fa fa-user" aria-hidden="true"></i> Thông tin giải ngân</strong>
									<div class="clearfix"></div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Hình thức<span class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<select disabled class="form-control" id="type_payout">
											<option value="2" <?php if ($contractInfor->receiver_infor->type_payout == "2") echo 'selected'; ?> >
												Tài khoản ngân hàng
											</option>
											<option value="3" <?php if ($contractInfor->receiver_infor->type_payout == "3") echo 'selected'; ?>>
												Thẻ atm
											</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Ngân Hàng<span class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" required id="bank_account"
											   class="form-control phone-autocomplete"
											   value="<?= !empty($contractInfor->receiver_infor->bank_name) ? $contractInfor->receiver_infor->bank_name : "" ?>"
											   disabled>
										<div id="resultsIdentify" class="smartsearchresult "></div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Chi nhánh<span class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" required id="bank_branch"
											   class="form-control identify-autocomplete"
											   value="<?= !empty($contractInfor->receiver_infor->bank_branch) ? $contractInfor->receiver_infor->bank_branch : "" ?>" <?php if ($contractInfor->receiver_infor->type_payout == "3") echo 'disabled'; ?>>
										<div id="resultsIdentify" class="smartsearchresult "></div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Số tài khoản<span class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" required id="bank_account"
											   class="form-control phone-autocomplete"
											   value="<?= !empty($contractInfor->receiver_infor->bank_account) ? $contractInfor->receiver_infor->bank_account : "" ?>" <?php if ($contractInfor->receiver_infor->type_payout == "3") echo 'disabled'; ?>>
										<div id="resultsPhone" class="smartsearchresult "></div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Chủ tài khoản<span class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" required id="bank_account_holder"
											   class="form-control identify-autocomplete"
											   value="<?= !empty($contractInfor->receiver_infor->bank_account_holder) ? $contractInfor->receiver_infor->bank_account_holder : "" ?>" <?php if ($contractInfor->receiver_infor->type_payout == "3") echo 'disabled'; ?>>
										<div id="resultsIdentify" class="smartsearchresult "></div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Số thẻ atm <span class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" id="atm_card_number" type='text'
											   class="form-control"
											   value="<?= !empty($contractInfor->receiver_infor->atm_card_number) ? $contractInfor->receiver_infor->atm_card_number : "" ?>" <?php if ($contractInfor->receiver_infor->type_payout == "2") echo 'disabled'; ?>>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Tên chủ thẻ atm<span class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" required id="atm_card_holder" class="form-control"
											   value="<?= !empty($contractInfor->receiver_infor->atm_card_holder) ? $contractInfor->receiver_infor->atm_card_holder : "" ?>" <?php if ($contractInfor->receiver_infor->type_payout == "2") echo 'disabled'; ?>>
									</div>
								</div>
								<!-- <div class="form-group">
                           <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                               Nội dung <span class="text-danger">*</span>
                           </label>
                           <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                               <input type="text" required id="description_bank" class="form-control" value="<?= !empty($contractInfor->receiver_infor->description) ? $contractInfor->receiver_infor->description : "" ?>">
                           </div>
                           </div> -->
								<!--end thông tin giai ngan-->
								<!--thông tin giai ngan-->
								<div class="x_title">
									<strong><i class="fa fa-user" aria-hidden="true"></i> Thông tin thẩm định</strong>
									<div class="clearfix"></div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Thẩm định hồ sơ<span class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<textarea disabled type="text" id="expertise_file" required=""
												  class="form-control"><?= !empty($contractInfor->expertise_infor->expertise_file) ? $contractInfor->expertise_infor->expertise_file : "" ?></textarea>
										<div id="resultsPhone" class="smartsearchresult "></div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Thẩm định thực địa<span class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<textarea disabled type="text" id="expertise_field" required=""
												  class="form-control"><?= !empty($contractInfor->expertise_infor->expertise_field) ? $contractInfor->expertise_infor->expertise_field : "" ?></textarea>
										<div id="resultsIdentify" class="smartsearchresult "></div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Nơi cất giữ xe<span class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<textarea disabled type="text" id="expertise_field" required=""
												  class="form-control"><?= !empty($contractInfor->expertise_infor->car_storage) ? $contractInfor->expertise_infor->car_storage : "" ?></textarea>
										<div id="resultsIdentify" class="smartsearchresult "></div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Thông tin quan hệ tín dụng<span class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<div class="table-responsive">
											<table class="table ">
												<thead>
												<tr>
													<th>Tên tổ chức vay</th>
													<th>Gốc còn lại </th>
													<th>Đã tất toán</th>
													<th>Tiền phải trả hàng kỳ</th>
													<th>Quá hạn</th>
												</tr>
												</thead>
												<tbody>
												<?php if (empty($company_storage)): ?>
													<tr>
														<td></td>
													<tr>
												<?php else: ?>
													<?php foreach ($company_storage as $value): ?>
														<td><?= !empty($value->company_name != "khac") ? $value->company_name : $value->company_name_other ?></td>
														<td><?= !empty($value->company_debt) ? $value->company_debt : "" ?></td>
														<td><?= !empty($value->company_finalization) ? $value->company_finalization : "" ?></td>
														<td><?= !empty($value->company_borrowing) ? $value->company_borrowing : "" ?></td>
														<td><?= !empty($value->company_out_of_date) ? $value->company_out_of_date : "" ?></td>

														</tr>
													<?php endforeach; ?>
												<?php endif; ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Ngoại lệ hồ sơ: <span class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<div id="exception1" <?php if (empty($contractInfor->expertise_infor->exception1_value[0])): ?> style="display: none" <?php endif; ?>>
											<select disabled id="lead_exception_E1" class="form-control"
													name="lead_exception_E1[]" multiple="multiple"
													data-placeholder="Các lý do ngoại lệ E1">
												<?php
												$value1 = (isset($contractInfor->expertise_infor->exception1_value[0]) && is_array($contractInfor->expertise_infor->exception1_value[0])) ? $contractInfor->expertise_infor->exception1_value[0] : array();
												?>
												<option value="1" <?= (is_array($value1) && in_array("1", $value1)) ? 'selected' : 'hidden' ?> >
													E1.1: Ngoại lệ về tuổi vay
												</option>
												<option value="2" <?= (is_array($value1) && in_array("2", $value1)) ? 'selected' : 'hidden' ?> >
													E1.2: Ngoại lệ về giấy tờ định danh: CMND/CCCD mờ ảnh / mờ số không
													đủ điều kiện
												</option>
											</select>
										</div>
										<div id="exception2" <?php if (empty($contractInfor->expertise_infor->exception2_value[0])): ?> style="display: none" <?php endif; ?>>
											<select disabled id="lead_exception_E2" class="form-control"
													name="lead_exception_E2[]" multiple="multiple"
													data-placeholder="Các lý do ngoại lệ E2">
												<?php
												$value2 = (isset($contractInfor->expertise_infor->exception2_value[0]) && is_array($contractInfor->expertise_infor->exception2_value[0])) ? $contractInfor->expertise_infor->exception2_value[0] : array();
												?>
												<option value="3" <?= (is_array($value2) && in_array("3", $value2)) ? 'selected' : 'hidden' ?> >
													E2.1: Khách hàng KT3 tạm trú dưới 6 tháng
												</option>
												<option value="4" <?= (is_array($value2) && in_array("4", $value2)) ? 'selected' : 'hidden' ?> >
													E2.2: Khách hàng KT3 không có hợp đồng thuê nhà, sổ tạm trú, xác
													minh qua chủ nhà trọ
												</option>
											</select>
										</div>
										<div id="exception3" <?php if (empty($contractInfor->expertise_infor->exception3_value[0])): ?> style="display: none" <?php endif; ?>>
											<select disabled id="lead_exception_E3" class="form-control"
													name="lead_exception_E3[]" multiple="multiple"
													data-placeholder="Các lý do ngoại lệ E3">
												<?php
												$value3 = (isset($contractInfor->expertise_infor->exception3_value[0]) && is_array($contractInfor->expertise_infor->exception3_value[0])) ? $contractInfor->expertise_infor->exception3_value[0] : array();
												?>
												<option value="5" <?= (is_array($value3) && in_array("5", $value3)) ? 'selected' : 'hidden' ?> >
													E3.1: Khách hàng thiếu một trong những chứng từ chứng minh thu nhập
												</option>

											</select>
										</div>
										<div id="exception4" <?php if (empty($contractInfor->expertise_infor->exception4_value[0])): ?> style="display: none" <?php endif; ?>>
											<select disabled id="lead_exception_E4" class="form-control"
													name="lead_exception_E4[]" multiple="multiple"
													data-placeholder="Các lý do ngoại lệ E4">
												<?php
												$value4 = (isset($contractInfor->expertise_infor->exception4_value[0]) && is_array($contractInfor->expertise_infor->exception4_value[0])) ? $contractInfor->expertise_infor->exception4_value[0] : array();
												?>
												<option value="6" <?= (is_array($value4) && in_array("6", $value4)) ? 'selected' : 'hidden' ?> >
													E4.1: Ngoại lệ về TSĐB khác TSĐB trong quy định về SP hiện hành của
													công ty (đất, giấy tờ khác...)
												</option>
												<option value="7" <?= (is_array($value4) && in_array("7", $value4)) ? 'selected' : 'hidden' ?> >
													E4.2: Ngoại lệ về lãi suất sản phẩm
												</option>

											</select>
										</div>
										<div id="exception5" <?php if (empty($contractInfor->expertise_infor->exception5_value[0])): ?> style="display: none" <?php endif; ?>>
											<select disabled id="lead_exception_E5" class="form-control"
													name="lead_exception_E5[]" multiple="multiple"
													data-placeholder="Các lý do ngoại lệ E5">
												<?php
												$value5 = (isset($contractInfor->expertise_infor->exception5_value[0]) && is_array($contractInfor->expertise_infor->exception5_value[0])) ? $contractInfor->expertise_infor->exception5_value[0] : array();
												?>
												<option value="8" <?= (is_array($value5) && in_array("8", $value5)) ? 'selected' : 'hidden' ?> >
													E5.1: Ngoại lệ về điều kiện đối với người tham chiếu
												</option>
												<option value="9" <?= (is_array($value5) && in_array("9", $value5)) ? 'selected' : 'hidden' ?> >
													E5.2: Ngoại lệ PGD gọi điện cho tham chiếu không sử dụng hệ thống
													phonet
												</option>

											</select>
										</div>
										<div id="exception6" <?php if (empty($contractInfor->expertise_infor->exception6_value[0])): ?> style="display: none" <?php endif; ?>>
											<select disabled id="lead_exception_E6" class="form-control"
													name="lead_exception_E6[]" multiple="multiple"
													data-placeholder="Các lý do ngoại lệ E6">
												<?php
												$value6 = (isset($contractInfor->expertise_infor->exception6_value[0]) && is_array($contractInfor->expertise_infor->exception6_value[0])) ? $contractInfor->expertise_infor->exception6_value[0] : array();
												?>
												<option value="10" <?= (is_array($value6) && in_array("10", $value6)) ? 'selected' : 'hidden' ?> >
													E6.1: KH có nhiều hơn 3 KV ở các app hay tổ chức tín dụng, ngân hàng
													khác
												</option>
											</select>
										</div>
										<div id="exception7" <?php if (empty($contractInfor->expertise_infor->exception7_value[0])): ?> style="display: none" <?php endif; ?>>
											<select disabled id="lead_exception_E7" class="form-control"
													name="lead_exception_E7[]" multiple="multiple"
													data-placeholder="Các lý do ngoại lệ E7">
												<?php
												$value7 = (isset($contractInfor->expertise_infor->exception7_value[0]) && is_array($contractInfor->expertise_infor->exception7_value[0])) ? $contractInfor->expertise_infor->exception7_value[0] : array();
												?>
												<option value="11" <?= (is_array($value7) && in_array("11", $value7)) ? 'selected' : "hidden" ?> >
													E7.1: Khách hàng vay lại có lịch sử trả tiền tốt
												</option>
												<option value="12" <?= (is_array($value7) && in_array("12", $value7)) ? 'selected' : "hidden" ?> >
													E7.2: Thu nhập cao, gốc còn lại tại thời điểm hiện tại thấp
												</option>
												<option value="13" <?= (is_array($value7) && in_array("13", $value7)) ? 'selected' : 'hidden' ?> >
													E7.3: KH làm việc tại các công ty là đối tác chiến lược
												</option>
												<option value="14" <?= (is_array($value7) && in_array("14", $value7)) ? 'selected' : 'hidden' ?> >
													E7.4: Giá trị định giá tài sản cao
												</option>
											</select>
										</div>

									</div>
								</div>

								<!--end thông tin giai ngan-->
								<!--thông tin phong giao dich-->
								<div class="x_title">
									<strong><i class="fa fa-user" aria-hidden="true"></i> Thông tin phòng giao
										dịch</strong>
									<div class="clearfix"></div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Phòng giao dịch<span class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<select disabled class="form-control" id="stores">
											<option><?= !empty($contractInfor->store->name) ? $contractInfor->store->name : "" ?></option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Người tạo<span class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" class="form-control"
											   value="<?= !empty($contractInfor->created_by) ? $contractInfor->created_by : "" ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
										Người tiếp nhận quản lý hợp đồng<span class="text-danger">*</span>
									</label>
									<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
										<input disabled type="text" class="form-control"
											   value="<?= !empty($contractInfor->follow_contract) ? $contractInfor->follow_contract : "" ?>">
									</div>
								</div>
								<!--end thông tin phong giao dich-->


							</div>
							<!--End Thông tin tài sản-->
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php if (!empty($data_hs)): ?>
			<?php foreach ($data_hs as $item): ?>
				<?php if ($item->id_oid == $contractInfor->_id->{'$oid'}): ?>
					<?php $customer_name_hs = $item->user->email; ?>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>


		<input id="id_oid" style="display: none" value="<?php echo $contractInfor->_id->{'$oid'} ?>">
		<!--check accessright của hội sở theo trạng thái -->
		<?php
		// check accessright của hội sở theo trạng thái
		if (((in_array('hoi-so', $groupRoles)) || (in_array('hoi-so', $groupRoles) && ($contractInfor->loan_infor->amount_loan < 50000000) && ($contractInfor->loan_infor->type_property->code == "OTO")) || (in_array('hoi-so', $groupRoles) && ($contractInfor->loan_infor->amount_loan < 50000000) && ($contractInfor->loan_infor->type_property->code == "XM") && ($contractInfor->loan_infor->type_loan->code == "DKX")))) {
			?>
			<?php
			// buttom duyet hợp đồng
			if (in_array($contractInfor->status, array(5))
					&& in_array("5dedd2e668a3ff310000364c", $userRoles->role_access_rights)) { ?>
				<a href="javascript:void(0)" onclick="hsduyet(this)"
				   data-id='<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>'
				   class="btn btn-info duyet"> Duyệt </a>
			<?php } ?>

			<?php
			// buttom hủy hợp đồng
			if (in_array($contractInfor->status, array(5))
					&& in_array("5e65a5c33894ad25f051b756", $userRoles->role_access_rights)) { ?>
				<a href="javascript:void(0)" onclick="hoi_so_khong_duyet(this)"
				   data-id='<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>'
				   class="btn huy_hop_dong btn-danger">Không duyệt </a>
			<?php } ?>

			<?php
			// buttom hủy hợp đồng
			if (in_array($contractInfor->status, array(5))
					&& in_array("5db6b8c9d6612bceeb712375", $userRoles->role_access_rights)) { ?>
				<a href="javascript:void(0)" onclick="huy_hop_dong(this)"
				   data-id='<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>'
				   class="btn btn-dark huy_hop_dong">Hủy hợp đồng</a>
			<?php } ?>
		<?php } ?>

		<?php if (in_array('quan-ly-khu-vuc', $groupRoles)): ?>
			<?php if (($contractInfor->loan_infor->amount_loan < 50000000) && ($contractInfor->loan_infor->type_property->code == "XM") && ($contractInfor->loan_infor->type_loan->code == "CC")): ?>
				<?php
				// buttom duyet hợp đồng
				if (in_array($contractInfor->status, array(5))) { ?>
					<a href="javascript:void(0)" onclick="hsduyet(this)"
					   data-id='<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>'
					   class="btn btn-info duyet"> Duyệt </a>
				<?php } ?>
				<?php
				// buttom hủy hợp đồng
				if (in_array($contractInfor->status, array(5))) { ?>
					<a href="javascript:void(0)" onclick="hoi_so_khong_duyet(this)"
					   data-id='<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>'
					   class="btn huy_hop_dong btn-danger">Không duyệt </a>
				<?php } ?>
				<?php
				// buttom hủy hợp đồng
				if (in_array($contractInfor->status, array(5))) { ?>
					<a href="javascript:void(0)" onclick="huy_hop_dong(this)"
					   data-id='<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>'
					   class="btn btn-dark huy_hop_dong">Hủy hợp đồng</a>
				<?php } ?>
			<?php else: ?>
				<?php if (in_array($contractInfor->status, array(35))) : ?>
					<a href="javascript:void(0)"
					   onclick="asm_duyet(this)"
					   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>"
					   class="btn btn-info asm_duyet"> Gửi hội sở duyệt</a>
				<?php endif; ?>
			<?php endif; ?>
		<?php endif; ?>



		<?php
		// $userSession['email']
		// check phat-trien-san-pham
		if (in_array('phat-trien-san-pham', $groupRoles) || in_array('hoi-so', $groupRoles)) {
			?>
			<?php
			// buttom comment
			if (in_array($contractInfor->status, array(1, 2, 3, 4, 5, 6, 8, 35, 36))
			) { ?>
				<div class="row">
					<div class="col-md-2">
						<a href="javascript:void(0)" onclick="comment(this)"
						   data-id='<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>'
						   class="btn btn-warning">Comment</a>
					</div>
				</div>
			<?php } ?>
		<?php } ?>


		<?php
		if (in_array('quan-ly-cap-cao', $groupRoles)) {
			?>
			<?php
			// buttom comment
			if (in_array($contractInfor->status, array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 15, 16, 35, 36))
			) { ?>
				<div class="row">
					<div class="col-md-2">
						<a href="javascript:void(0)" onclick="comment(this)"
						   data-id='<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>'
						   class="btn btn-warning">Comment</a>
					</div>
				</div>
			<?php } ?>
		<?php } ?>


		<div class="modal fade" id="addComment" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
			 aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close close-PGD" data-dismiss="modal" aria-label="Close"><span
									aria-hidden="true">&times;</span></button>
						<h3 class="modal-title" style="text-align: center">Comment</h3>
					</div>
					<div class="modal-body ">
						<div class="row">
							<div class="col-xs-12">
								<input style="display: none" value="" id="comment_id"/>

								<div class="form-group">
									<label class="control-label col-md-3">Ghi chú<span
												class="text-danger"></span></label>
									<div class="col-md-9">
										<textarea id="add_comment" class="form-control"></textarea>
										<span class="help-block"></span>
									</div>
								</div>

								<div style="text-align: center">
									<button type="button" id="customer_comment" class="btn btn-info">Lưu</button>
									<button type="button" class="btn btn-primary close-Comment" data-dismiss="modal"
											aria-label="Close">
										Thoát
									</button>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
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

						<div class="form-group code_contract_approve" style="display:none">
							<label>Mã hợp đồng:</label>
							<input type="text" class="form-control " name="code_contract_disbursement_approve" value="">
						</div>
						<div class="form-group so_tien_vay_asm_de_xuat" style="display: none">
							<label>Số tiền vay: <span class="text-danger">*</span></label>
							<input type="text" id="so_tien_vay_asm_de_xuat" placeholder="Số tiền được vay ASM đề xuất"
								   class="form-control"
								   name="so_tien_vay_asm_de_xuat">
						</div>
						<div class="form-group ki_han_vay_asm_de_xuat" style="display: none">
							<label>Kì hạn vay: <span class="text-danger">*</span></label>
							<input type="number" id="ki_han_vay_asm_de_xuat" placeholder="Kì hạn vay ASM đề xuất"
								   class="form-control"
								   name="ki_han_vay_asm_de_xuat">
						</div>
						<div class="form-group error_code_contract" style="display:none">
							<label>Trường hợp vi phạm:</label>
							<select class="form-control " name="error_code[]" style="width: 75%" id="error_code"
									multiple="multiple" data-placeholder="Choose option">
								<?php foreach (lead_return() as $key => $value) { ?>
									<option value="<?= $key ?>"><?= $key . ' - ' . $value ?></option>
								<?php } ?>
							</select>
						</div>
						<input id="error_code1" style="display: none">

						<div class="form-group img_return_file">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ảnh hồ sơ bổ
								sung/trả về<span class="red"></span></label>
							<div class="col-md-9 col-sm-6 col-xs-12">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="uploads_img_file">

									</div>
									<label for="uploadinput">
										<div class="block uploader">
											<span>+</span>
										</div>
									</label>
									<input id="uploadinput" type="file" name="file" data-contain="uploads_img_file"
										   data-title="Hồ sơ trả về" multiple data-type="img_file" class="focus">
								</div>
							</div>
						</div>

						<div class="form-group">

							<label class="cancel-C" style="display: none">Lý do từ chối,hủy:</label>
							<div class="row cancel-C" style="display: none">
								<div class="col-md-6">
									<select class="form-control" id="change_cancel"
											data-placeholder="Các lý do từ chối, hủy">
										<option value="">-- Các lý do từ chối, hủy --</option>
										<option value="C1">C1: Lý do về hồ sơ nhân thân</option>
										<option value="C2">C2: Lý do về thông tin nơi ở</option>
										<option value="C3">C3: Lý do về thông tin thu nhập</option>
										<option value="C4">C4: Lý do về thông tin tài sản</option>
										<option value="C5">C5: Lý do về thông tin tham chiếu</option>
										<option value="C6">C6: Lý do về thông tin lịch sử tín dụng</option>
										<option value="C7">C7: Lý do khác</option>
									</select>
								</div>
								<div class="col-md-6">
									<div style="display: none" id="cancel1">
										<div class="row">
											<div class="col-md-10">
												<select id="lead_cancel_C1" class="form-control" name="lead_cancel_C1[]"
														multiple="multiple"
														data-placeholder="Các lý do từ chối, hủy C1">
													<?php foreach (lead_cancel_C1() as $key => $item) { ?>
														<option value="<?= $key ?>" <?= ($lead_cancel_C1 == $key) ? 'selected' : '' ?>><?= $item ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-md-2">
												<i id="lead_cancel_C1_detail" class="fa fa-ban text-danger"
												   aria-hidden="true"></i>
											</div>
										</div>
									</div>
									<div style="display: none" id="cancel2">
										<div class="row">
											<div class="col-md-10">
												<select id="lead_cancel_C2" class="form-control" name="lead_cancel_C2[]"
														multiple="multiple"
														data-placeholder="Các lý do từ chối, hủy C2">
													<?php foreach (lead_cancel_C2() as $key => $item) { ?>
														<option value="<?= $key ?>" <?= ($lead_cancel_C2 == $key) ? 'selected' : '' ?>><?= $item ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-md-2">
												<i id="lead_cancel_C2_detail" class="fa fa-ban text-danger"
												   aria-hidden="true"></i>
											</div>
										</div>
									</div>
									<div style="display: none" id="cancel3">
										<div class="row">
											<div class="col-md-10">
												<select id="lead_cancel_C3" class="form-control" name="lead_cancel_C3[]"
														multiple="multiple"
														data-placeholder="Các lý do từ chối, hủy C3">
													<?php foreach (lead_cancel_C3() as $key => $item) { ?>
														<option value="<?= $key ?>" <?= ($lead_cancel_C3 == $key) ? 'selected' : '' ?>><?= $item ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-md-2">
												<i id="lead_cancel_C3_detail" class="fa fa-ban text-danger"
												   aria-hidden="true"></i>
											</div>
										</div>
									</div>
									<div style="display: none" id="cancel4">
										<div class="row">
											<div class="col-md-10">
												<select id="lead_cancel_C4" class="form-control" name="lead_cancel_C4[]"
														multiple="multiple"
														data-placeholder="Các lý do từ chối, hủy C4">
													<?php foreach (lead_cancel_C4() as $key => $item) { ?>
														<option value="<?= $key ?>" <?= ($lead_cancel_C4 == $key) ? 'selected' : '' ?>><?= $item ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-md-2">
												<i id="lead_cancel_C4_detail" class="fa fa-ban text-danger"
												   aria-hidden="true"></i>
											</div>
										</div>
									</div>
									<div style="display: none" id="cancel5">
										<div class="row">
											<div class="col-md-10">
												<select id="lead_cancel_C5" class="form-control" name="lead_cancel_C5[]"
														multiple="multiple"
														data-placeholder="Các lý do từ chối, hủy C5">
													<?php foreach (lead_cancel_C5() as $key => $item) { ?>
														<option value="<?= $key ?>" <?= ($lead_cancel_C5 == $key) ? 'selected' : '' ?>><?= $item ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-md-2">
												<i id="lead_cancel_C5_detail" class="fa fa-ban text-danger"
												   aria-hidden="true"></i>
											</div>
										</div>
									</div>
									<div style="display: none" id="cancel6">
										<div class="row">
											<div class="col-md-10">
												<select id="lead_cancel_C6" class="form-control" name="lead_cancel_C6[]"
														multiple="multiple"
														data-placeholder="Các lý do từ chối, hủy C6">
													<?php foreach (lead_cancel_C6() as $key => $item) { ?>
														<option value="<?= $key ?>" <?= ($lead_cancel_C6 == $key) ? 'selected' : '' ?>><?= $item ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-md-2">
												<i id="lead_cancel_C6_detail" class="fa fa-ban text-danger"
												   aria-hidden="true"></i>
											</div>
										</div>
									</div>
									<div style="display: none" id="cancel7">
										<div class="row">
											<div class="col-md-10">
												<select id="lead_cancel_C7" class="form-control" name="lead_cancel_C7[]"
														multiple="multiple"
														data-placeholder="Các lý do từ chối, hủy C7">
													<?php foreach (lead_cancel_C7() as $key => $item) { ?>
														<option value="<?= $key ?>" <?= ($lead_cancel_C7 == $key) ? 'selected' : '' ?>><?= $item ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-md-2">
												<i id="lead_cancel_C7_detail" class="fa fa-ban text-danger"
												   aria-hidden="true"></i>
											</div>
										</div>
									</div>
								</div>
							</div>
							<input id="lead_cancel1_C1" style="display: none">
							<input id="lead_cancel1_C2" style="display: none">
							<input id="lead_cancel1_C3" style="display: none">
							<input id="lead_cancel1_C4" style="display: none">
							<input id="lead_cancel1_C5" style="display: none">
							<input id="lead_cancel1_C6" style="display: none">
							<input id="lead_cancel1_C7" style="display: none">

							<label>Ghi chú:</label>
							<textarea class="form-control approve_note" rows="5"
									  placeholder="Nhập ghi chú, lưu ý"></textarea>


							<input type="hidden" class="form-control status_approve">
							<input type="hidden" class="form-control code_contract_disbursement_type" value="0">

							<input type="hidden" class="form-control contract_id">
						</div>
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
							<input type="text" class="form-control"
								   value="<?= $contractInfor->loan_infor->amount_money ? number_format($contractInfor->loan_infor->amount_money) : "" ?>"
								   disabled>
							<label>Kỳ hạn:</label>
							<input type="text" class="form-control"
								   value="<?= $contractInfor->loan_infor->number_day_loan ? $contractInfor->loan_infor->number_day_loan : "" ?>"
								   disabled>
							<label>Hình thức vay:</label>
							<input type="text" class="form-control"
								   value="<?= $contractInfor->loan_infor->type_loan->text ? $contractInfor->loan_infor->type_loan->text : "" ?>"
								   disabled>
							<label style="display: none">Số tiền vay ASM đề xuất:</label>
							<input style="display: none" type="text" id="" placeholder="Số tiền được vay ASM đề xuất"
								   class="form-control"
								   name="" disabled
								   value="<?= $contractInfor->asm->so_tien_vay_asm_de_xuat ? $contractInfor->asm->so_tien_vay_asm_de_xuat . " VND" : "" ?>">

							<label style="display: none">Kì hạn vay ASM đề xuất:</label>
							<input style="display: none" type="number" id="" placeholder="Kì hạn vay ASM đề xuất"
								   class="form-control"
								   name="" disabled
								   value="<?= $contractInfor->asm->ki_han_vay_asm_de_xuat ? $contractInfor->asm->ki_han_vay_asm_de_xuat : "" ?>">
							<label style="display: none">ASM ghi chú:</label>
							<textarea style="display: none" type="number" id=""
									  class="form-control"
									  name=""
									  disabled><?= $contractInfor->asm->note ? $contractInfor->asm->note : "" ?></textarea>
							<label>Số tiền được phê duyệt:</label>
							<input type="text" class="form-control amount_money" disabled>
							<br>
							<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Ngoại lệ hồ sơ:
							</label>
							<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
								<div id="exception1" <?php if (empty($contractInfor->expertise_infor->exception1_value[0])): ?> style="display: none" <?php endif; ?>>
									<select disabled id="lead_exception_E1" class="form-control"
											name="lead_exception_E1[]" multiple="multiple"
											data-placeholder="Các lý do ngoại lệ E1">
										<?php
										$value1 = (isset($contractInfor->expertise_infor->exception1_value[0]) && is_array($contractInfor->expertise_infor->exception1_value[0])) ? $contractInfor->expertise_infor->exception1_value[0] : array();
										?>
										<option value="1" <?= (is_array($value1) && in_array("1", $value1)) ? 'selected' : 'hidden' ?> >
											E1.1: Ngoại lệ về tuổi vay
										</option>
										<option value="2" <?= (is_array($value1) && in_array("2", $value1)) ? 'selected' : 'hidden' ?> >
											E1.2: Ngoại lệ về giấy tờ định danh: CMND/CCCD mờ ảnh / mờ số không đủ điều
											kiện
										</option>
									</select>
								</div>
								<div id="exception2" <?php if (empty($contractInfor->expertise_infor->exception2_value[0])): ?> style="display: none" <?php endif; ?>>
									<select disabled id="lead_exception_E2" class="form-control"
											name="lead_exception_E2[]" multiple="multiple"
											data-placeholder="Các lý do ngoại lệ E2">
										<?php
										$value2 = (isset($contractInfor->expertise_infor->exception2_value[0]) && is_array($contractInfor->expertise_infor->exception2_value[0])) ? $contractInfor->expertise_infor->exception2_value[0] : array();
										?>
										<option value="3" <?= (is_array($value2) && in_array("3", $value2)) ? 'selected' : 'hidden' ?> >
											E2.1: Khách hàng KT3 tạm trú dưới 6 tháng
										</option>
										<option value="4" <?= (is_array($value2) && in_array("4", $value2)) ? 'selected' : 'hidden' ?> >
											E2.2: Khách hàng KT3 không có hợp đồng thuê nhà, sổ tạm trú, xác minh qua
											chủ nhà trọ
										</option>
									</select>
								</div>
								<div id="exception3" <?php if (empty($contractInfor->expertise_infor->exception3_value[0])): ?> style="display: none" <?php endif; ?>>
									<select disabled id="lead_exception_E3" class="form-control"
											name="lead_exception_E3[]" multiple="multiple"
											data-placeholder="Các lý do ngoại lệ E3">
										<?php
										$value3 = (isset($contractInfor->expertise_infor->exception3_value[0]) && is_array($contractInfor->expertise_infor->exception3_value[0])) ? $contractInfor->expertise_infor->exception3_value[0] : array();
										?>
										<option value="5" <?= (is_array($value3) && in_array("5", $value3)) ? 'selected' : 'hidden' ?> >
											E3.1: Khách hàng thiếu một trong những chứng từ chứng minh thu nhập
										</option>

									</select>
								</div>
								<div id="exception4" <?php if (empty($contractInfor->expertise_infor->exception4_value[0])): ?> style="display: none" <?php endif; ?>>
									<select disabled id="lead_exception_E4" class="form-control"
											name="lead_exception_E4[]" multiple="multiple"
											data-placeholder="Các lý do ngoại lệ E4">
										<?php
										$value4 = (isset($contractInfor->expertise_infor->exception4_value[0]) && is_array($contractInfor->expertise_infor->exception4_value[0])) ? $contractInfor->expertise_infor->exception4_value[0] : array();
										?>
										<option value="6" <?= (is_array($value4) && in_array("6", $value4)) ? 'selected' : 'hidden' ?> >
											E4.1: Ngoại lệ về TSĐB khác TSĐB trong quy định về SP hiện hành của công ty
											(đất, giấy tờ khác...)
										</option>
										<option value="7" <?= (is_array($value4) && in_array("7", $value4)) ? 'selected' : 'hidden' ?> >
											E4.2: Ngoại lệ về lãi suất sản phẩm
										</option>

									</select>
								</div>
								<div id="exception5" <?php if (empty($contractInfor->expertise_infor->exception5_value[0])): ?> style="display: none" <?php endif; ?>>
									<select disabled id="lead_exception_E5" class="form-control"
											name="lead_exception_E5[]" multiple="multiple"
											data-placeholder="Các lý do ngoại lệ E5">
										<?php
										$value5 = (isset($contractInfor->expertise_infor->exception5_value[0]) && is_array($contractInfor->expertise_infor->exception5_value[0])) ? $contractInfor->expertise_infor->exception5_value[0] : array();
										?>
										<option value="8" <?= (is_array($value5) && in_array("8", $value5)) ? 'selected' : 'hidden' ?> >
											E5.1: Ngoại lệ về điều kiện đối với người tham chiếu
										</option>
										<option value="9" <?= (is_array($value5) && in_array("9", $value5)) ? 'selected' : 'hidden' ?> >
											E5.2: Ngoại lệ PGD gọi điện cho tham chiếu không sử dụng hệ thống phonet
										</option>

									</select>
								</div>
								<div id="exception6" <?php if (empty($contractInfor->expertise_infor->exception6_value[0])): ?> style="display: none" <?php endif; ?>>
									<select disabled id="lead_exception_E6" class="form-control"
											name="lead_exception_E6[]" multiple="multiple"
											data-placeholder="Các lý do ngoại lệ E6">
										<?php
										$value6 = (isset($contractInfor->expertise_infor->exception6_value[0]) && is_array($contractInfor->expertise_infor->exception6_value[0])) ? $contractInfor->expertise_infor->exception6_value[0] : array();
										?>
										<option value="10" <?= (is_array($value6) && in_array("10", $value6)) ? 'selected' : 'hidden' ?> >
											E6.1: KH có nhiều hơn 3 KV ở các app hay tổ chức tín dụng, ngân hàng khác
										</option>
									</select>
								</div>
								<div id="exception7" <?php if (empty($contractInfor->expertise_infor->exception7_value[0])): ?> style="display: none" <?php endif; ?>>
									<select disabled id="lead_exception_E7" class="form-control"
											name="lead_exception_E7[]" multiple="multiple"
											data-placeholder="Các lý do ngoại lệ E7">
										<?php
										$value7 = (isset($contractInfor->expertise_infor->exception7_value[0]) && is_array($contractInfor->expertise_infor->exception7_value[0])) ? $contractInfor->expertise_infor->exception7_value[0] : array();
										?>
										<option value="11" <?= (is_array($value7) && in_array("11", $value7)) ? 'selected' : "hidden" ?> >
											E7.1: Khách hàng vay lại có lịch sử trả tiền tốt
										</option>
										<option value="12" <?= (is_array($value7) && in_array("12", $value7)) ? 'selected' : "hidden" ?> >
											E7.2: Thu nhập cao, gốc còn lại tại thời điểm hiện tại thấp
										</option>
										<option value="13" <?= (is_array($value7) && in_array("13", $value7)) ? 'selected' : 'hidden' ?> >
											E7.3: KH làm việc tại các công ty là đối tác chiến lược
										</option>
										<option value="14" <?= (is_array($value7) && in_array("14", $value7)) ? 'selected' : 'hidden' ?> >
											E7.4: Giá trị định giá tài sản cao
										</option>
									</select>
								</div>
								</select>
							</div>
							<br><br>
							<label>Lý do xử lý:</label>
							<select class="form-control approve_reason_hs">
								<option value="">- Chọn lý do xử lý -</option>
								<option value="1">Đầy đủ điều kiện theo quy định</option>
								<option value="2">Đáp ứng được điều kiện ngoại lệ</option>
							</select>

							<label>Thêm ngoại lệ hồ sơ bổ sung:</label>
							<div class="row">
								<div class="col-md-6">
									<select id="change_exception_detail" class="form-control"
											name="change_exception_detail"
											data-placeholder="Các lý do ngoại lệ">
										<option value="">-- Các lý do ngoại lệ --</option>
										<option value="E1">E1: Ngoại lệ về hồ sơ nhân thân</option>
										<option value="E2">E2: Ngoại lệ về thông tin nơi ở</option>
										<option value="E3">E3: Ngoại lệ về thông tin thu nhập</option>
										<option value="E4">E4: Ngoại lệ về thông tin sản phẩm</option>
										<option value="E5">E5: Ngoại lệ về thông tin tham chiếu</option>
										<option value="E6">E6: Ngoại lệ về thông tin lịch sử tín dụng</option>
										<option value="E7">E7: Ngoại lệ tăng giá trị khoản vay</option>
									</select>
								</div>
								<div class="col-md-6">
									<div id="exception1_detail" <?php if (empty($contractInfor->expertise_infor->exception1_value[0])): ?> style="display: none" <?php endif; ?>>
										<div class="row">
											<div class="col-md-10">
												<select id="lead_exception_E1_detail" class="form-control"
														name="lead_exception_E1[]_detail" multiple="multiple"
														data-placeholder="Các lý do ngoại lệ E1">
													<?php
													$value1 = (isset($contractInfor->expertise_infor->exception1_value[0]) && is_array($contractInfor->expertise_infor->exception1_value[0])) ? $contractInfor->expertise_infor->exception1_value[0] : array();
													?>
													<option value="1" <?= (is_array($value1) && in_array("1", $value1)) ? 'selected' : '' ?> >
														E1.1: Ngoại lệ về tuổi vay
													</option>
													<option value="2" <?= (is_array($value1) && in_array("2", $value1)) ? 'selected' : '' ?> >
														E1.2: Ngoại lệ về giấy tờ định danh: CMND/CCCD mờ ảnh / mờ số
														không đủ điều kiện
													</option>
												</select>
											</div>
											<div class="col-md-2">
												<i id="exception1_del_detail" class="fa fa-ban text-danger"
												   aria-hidden="true"></i>
											</div>
										</div>
									</div>
									<div id="exception2_detail" <?php if (empty($contractInfor->expertise_infor->exception2_value[0])): ?> style="display: none" <?php endif; ?>>
										<div class="row">
											<div class="col-md-10">
												<select id="lead_exception_E2_detail" class="form-control"
														name="lead_exception_E2[]_detail" multiple="multiple"
														data-placeholder="Các lý do ngoại lệ E2">
													<?php
													$value2 = (isset($contractInfor->expertise_infor->exception2_value[0]) && is_array($contractInfor->expertise_infor->exception2_value[0])) ? $contractInfor->expertise_infor->exception2_value[0] : array();
													?>
													<option value="3" <?= (is_array($value2) && in_array("3", $value2)) ? 'selected' : '' ?> >
														E2.1: Khách hàng KT3 tạm trú dưới 6 tháng
													</option>
													<option value="4" <?= (is_array($value2) && in_array("4", $value2)) ? 'selected' : '' ?> >
														E2.2: Khách hàng KT3 không có hợp đồng thuê nhà, sổ tạm trú, xác
														minh qua chủ nhà trọ
													</option>
												</select>
											</div>
											<div class="col-md-2">
												<i id="exception2_del_detail" class="fa fa-ban text-danger"
												   aria-hidden="true"></i>
											</div>
										</div>
									</div>
									<div id="exception3_detail" <?php if (empty($contractInfor->expertise_infor->exception3_value[0])): ?> style="display: none" <?php endif; ?>>
										<div class="row">
											<div class="col-md-10">
												<select id="lead_exception_E3_detail" class="form-control"
														name="lead_exception_E3_detail[]" multiple="multiple"
														data-placeholder="Các lý do ngoại lệ E3">
													<?php
													$value3 = (isset($contractInfor->expertise_infor->exception3_value[0]) && is_array($contractInfor->expertise_infor->exception3_value[0])) ? $contractInfor->expertise_infor->exception3_value[0] : array();
													?>
													<option value="5" <?= (is_array($value3) && in_array("5", $value3)) ? 'selected' : '' ?> >
														E3.1: Khách hàng thiếu một trong những chứng từ chứng minh thu
														nhập
													</option>

												</select>
											</div>
											<div class="col-md-2">
												<i id="exception3_del_detail" class="fa fa-ban text-danger"
												   aria-hidden="true"></i>
											</div>
										</div>
									</div>
									<div id="exception4_detail" <?php if (empty($contractInfor->expertise_infor->exception4_value[0])): ?> style="display: none" <?php endif; ?>>
										<div class="row">
											<div class="col-md-10">
												<select id="lead_exception_E4_detail" class="form-control"
														name="lead_exception_E4_detail[]" multiple="multiple"
														data-placeholder="Các lý do ngoại lệ E4">
													<?php
													$value4 = (isset($contractInfor->expertise_infor->exception4_value[0]) && is_array($contractInfor->expertise_infor->exception4_value[0])) ? $contractInfor->expertise_infor->exception4_value[0] : array();
													?>
													<option value="6" <?= (is_array($value4) && in_array("6", $value4)) ? 'selected' : '' ?> >
														E4.1: Ngoại lệ về TSĐB khác TSĐB trong quy định về SP hiện hành
														của công ty (đất, giấy tờ khác...)
													</option>
													<option value="7" <?= (is_array($value4) && in_array("7", $value4)) ? 'selected' : '' ?> >
														E4.2: Ngoại lệ về lãi suất sản phẩm
													</option>

												</select>
											</div>
											<div class="col-md-2">
												<i id="exception4_del_detail" class="fa fa-ban text-danger"
												   aria-hidden="true"></i>
											</div>
										</div>
									</div>
									<div id="exception5_detail" <?php if (empty($contractInfor->expertise_infor->exception5_value[0])): ?> style="display: none" <?php endif; ?>>
										<div class="row">
											<div class="col-md-10">
												<select id="lead_exception_E5_detail" class="form-control"
														name="lead_exception_E5_detail[]" multiple="multiple"
														data-placeholder="Các lý do ngoại lệ E5">
													<?php
													$value5 = (isset($contractInfor->expertise_infor->exception5_value[0]) && is_array($contractInfor->expertise_infor->exception5_value[0])) ? $contractInfor->expertise_infor->exception5_value[0] : array();
													?>
													<option value="8" <?= (is_array($value5) && in_array("8", $value5)) ? 'selected' : '' ?> >
														E5.1: Ngoại lệ về điều kiện đối với người tham chiếu
													</option>
													<option value="9" <?= (is_array($value5) && in_array("9", $value5)) ? 'selected' : '' ?> >
														E5.2: Ngoại lệ PGD gọi điện cho tham chiếu không sử dụng hệ
														thống phonet
													</option>

												</select>
											</div>
											<div class="col-md-2">
												<i id="exception5_del_detail" class="fa fa-ban text-danger"
												   aria-hidden="true"></i>
											</div>
										</div>
									</div>
									<div id="exception6_detail" <?php if (empty($contractInfor->expertise_infor->exception6_value[0])): ?> style="display: none" <?php endif; ?>>
										<div class="row">
											<div class="col-md-10">
												<select id="lead_exception_E6_detail" class="form-control"
														name="lead_exception_E6_detail[]" multiple="multiple"
														data-placeholder="Các lý do ngoại lệ E6">
													<?php
													$value6 = (isset($contractInfor->expertise_infor->exception6_value[0]) && is_array($contractInfor->expertise_infor->exception6_value[0])) ? $contractInfor->expertise_infor->exception6_value[0] : array();
													?>
													<option value="10" <?= (is_array($value6) && in_array("10", $value6)) ? 'selected' : '' ?> >
														E6.1: KH có nhiều hơn 3 KV ở các app hay tổ chức tín dụng, ngân
														hàng khác
													</option>
												</select>
											</div>
											<div class="col-md-2">
												<i id="exception6_del_detail" class="fa fa-ban text-danger"
												   aria-hidden="true"></i>
											</div>
										</div>
									</div>
									<div id="exception7_detail" <?php if (empty($contractInfor->expertise_infor->exception7_value[0])): ?> style="display: none" <?php endif; ?>>
										<div class="row">
											<div class="col-md-10">
												<select id="lead_exception_E7_detail" class="form-control"
														name="lead_exception_E7_detail[]" multiple="multiple"
														data-placeholder="Các lý do ngoại lệ E7">
													<?php
													$value7 = (isset($contractInfor->expertise_infor->exception7_value[0]) && is_array($contractInfor->expertise_infor->exception7_value[0])) ? $contractInfor->expertise_infor->exception7_value[0] : array();
													?>
													<option value="11" <?= (is_array($value7) && in_array("11", $value7)) ? 'selected' : '' ?> >
														E7.1: Khách hàng vay lại có lịch sử trả tiền tốt
													</option>
													<option value="12" <?= (is_array($value7) && in_array("12", $value7)) ? 'selected' : '' ?> >
														E7.2: Thu nhập cao, gốc còn lại tại thời điểm hiện tại thấp
													</option>
													<option value="13" <?= (is_array($value7) && in_array("13", $value7)) ? 'selected' : '' ?> >
														E7.3: KH làm việc tại các công ty là đối tác chiến lược
													</option>
													<option value="14" <?= (is_array($value7) && in_array("14", $value7)) ? 'selected' : '' ?> >
														E7.4: Giá trị định giá tài sản cao
													</option>
												</select>
											</div>
											<div class="col-md-2">
												<i id="exception7_del_detail" class="fa fa-ban text-danger"
												   aria-hidden="true"></i>
											</div>
										</div>
									</div>
								</div>
							</div>
							<input id="exception1_value_detail" style="display: none"
								   value="<?= !empty($contractInfor->expertise_infor->exception1_value[0]) ? "[[" . implode(',', $contractInfor->expertise_infor->exception1_value[0]) . "]]" : "" ?>">
							<input id="exception2_value_detail" style="display: none"
								   value="<?= !empty($contractInfor->expertise_infor->exception2_value[0]) ? "[[" . implode(',', $contractInfor->expertise_infor->exception2_value[0]) . "]]" : "" ?>">
							<input id="exception3_value_detail" style="display: none"
								   value="<?= !empty($contractInfor->expertise_infor->exception3_value[0]) ? "[[" . implode(',', $contractInfor->expertise_infor->exception3_value[0]) . "]]" : "" ?>">
							<input id="exception4_value_detail" style="display: none"
								   value="<?= !empty($contractInfor->expertise_infor->exception4_value[0]) ? "[[" . implode(',', $contractInfor->expertise_infor->exception4_value[0]) . "]]" : "" ?>">
							<input id="exception5_value_detail" style="display: none"
								   value="<?= !empty($contractInfor->expertise_infor->exception5_value[0]) ? "[[" . implode(',', $contractInfor->expertise_infor->exception5_value[0]) . "]]" : "" ?>">
							<input id="exception6_value_detail" style="display: none"
								   value="<?= !empty($contractInfor->expertise_infor->exception6_value[0]) ? "[[" . implode(',', $contractInfor->expertise_infor->exception6_value[0]) . "]]" : "" ?>">
							<input id="exception7_value_detail" style="display: none"
								   value="<?= !empty($contractInfor->expertise_infor->exception7_value[0]) ? "[[" . implode(',', $contractInfor->expertise_infor->exception7_value[0]) . "]]" : "" ?>">

							<label hidden>Phí bảo hiểm khoản vay:</label>
							<input style="display: none" type="text" class="form-control fee_gic" disabled>
							<label hidden>Phí bảo hiểm xe:</label>
							<input style="display: none" type="text" class="form-control fee_gic_easy" disabled>
							<label hidden>Phí bảo hiểm phúc lộc thọ:</label>
							<input style="display: none" type="text" class="form-control fee_gic_plt" disabled>
							<label hidden>Phí bảo hiểm Vbi:</label>
							<input style="display: none" type="text" class="form-control fee_vbi" disabled>
							<label hidden>Phí bảo hiểm TNDS:</label>
							<input style="display: none" type="text" class="form-control phi_tnds" disabled>
							<label hidden>Phí bảo hiểm PTI VTA:</label>
							<input style="display: none" type="text" class="form-control phi_pti_vta" disabled>
							<label>Số tiền giải ngân:</label>
							<input type="text" class="form-control amount_loan" disabled>
							<label>Ghi chú:</label>
							<textarea class="form-control approve_note_hs" rows="5"></textarea>
							<input type="hidden" class="form-control status_approve">
							<input type="hidden" class="form-control contract_id">
							<input type="hidden" class="form-control" name="number_month_loan" id="number_month_loan">
							<input type="hidden" id="insurrance_contract" name="insurrance_contract">
							<input type="hidden" class="tilekhoanvay" value="<?= $tilekhoanvay ?>">
							<input type="hidden" id="loan_insurance" name="loan_insurance">
							<input type="hidden" id="user_nextpay" name="user_nextpay"
								   value="<?php echo $user_nextpay ?>">
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
		<div class="col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Kỳ thanh toán (Dự kiến)</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="table-responsive">
						<table class="table table-striped ">
							<thead>
							<tr>
								<th>#</th>
								<th>Kỳ trả</th>
								<th>Ngày kỳ trả</th>
								<th>Tổng số tiền<br> phải trả hàng kì</th>
								<th>Tổng lãi, phí</th>
								<th>Tiền lãi</th>
								<th>Phí thẩm định <br>và lưu trữ tài sản</th>
								<th>Phí tư vấn quản lý</th>


							</tr>
							</thead>
							<tbody name="list_lead">
							<?php

							if (!empty($calucatorData)) {
								echo $calucatorData;
								?>
							<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="" role="tabpanel" data-example-id="togglable-tabs">
				<ul id="myTab" class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#tab_content1" role="tab" id="tab001"
															  data-toggle="tab" aria-expanded="false">Hoạt động</a>
					</li>

					<li role="presentation" class=""><a href="#tab_content2" role="tab" id="tab002" data-toggle="tab"
														aria-expanded="false">Gia hạn liên quan</a>
					</li>

					<li role="presentation" class=""><a href="#tab_content3" role="tab" id="tab003" data-toggle="tab"
														aria-expanded="false">Cơ cấu liên quan</a>
					</li>
					<li role="presentation" class=""><a href="#tab_content4" role="tab" id="tab004" data-toggle="tab"
														aria-expanded="false">Lịch sử quản lý hợp đồng</a>
					</li>

				</ul>
				<div id="myTabContent" class="tab-content">
					<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="tab001">
						<?php $this->load->view('page/pawn/tab_detail/tab_hoat_dong'); ?>
					</div>
					<div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="tab002">
						<?php $this->load->view('page/pawn/tab_detail/tab_gia_han'); ?>
					</div>
					<div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="tab003">
						<?php $this->load->view('page/pawn/tab_detail/tab_co_cau'); ?>
					</div>
					<div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="tab004">
						<?php $this->load->view('page/pawn/tab_detail/tab_lich_su_qlhd'); ?>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="showhistory" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document" style="width: max-content;margin: auto">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title title_modal_history"></h5>
				<div class="x_panel">
					<div class="x_content">
						<table id="" class="table table-striped">
							<thead>
							<tr>
								<th>#</th>
								<th>Nhân viên</th>
								<th>Số gọi</th>
								<th>Trạng thái cuộc gọi</th>
								<th>Chi tiết</th>
								<th>Thời lượng</th>
								<th>File ghi âm</th>
							</tr>
							</thead>
							<tbody name="list_lead" id="list_lead">
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="listentoRecord" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Nghe ghi âm</h4>
			</div>

			<div class="modal-body">
				<audio controls class="w-100" id="player">

					<source src="" type="audio/mp3" id="audio">

				</audio>
			</div>
			<div class="modal-footer">
				<!--     <button type="button" class="btn btn-default" >
						<i class="fa fa-download"></i> Download
					  </button> -->
				<button type="button" class="btn btn-primary" onclick="closemedia()" data-dismiss="modal">OK
				</button>

			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="ContractHistoryModal" tabindex="-1" role="dialog" aria-labelledby="ContractHistoryModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document" style="width: 978px;max-width:95vw;">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title">Lịch sử Hợp đồng</h5>
				<hr>
				<div class="table-responsive">
					<table id="datatable-buttons" class="table table-striped" style="width: 100%">
						<thead>
						<tr>
							<th>#</th>
							<th><?php echo $this->lang->line('action') ?></th>
							<th><?php echo $this->lang->line('time') ?></th>
							<th><?php echo $this->lang->line('change_by') ?></th>
							<th><?php echo $this->lang->line('status') ?></th>
							<th><?php echo $this->lang->line('note') ?></th>
						</tr>
						</thead>
						<tbody>
						<?php
						if (!empty($logs)) {
							foreach ($logs as $key => $log) {
								?>
								<tr>
									<td><?php echo $key + 1 ?></td>
									<td><?php echo !empty($log->action) ? $log->action : '' ?></td>
									<td><?php echo !empty($log->created_at) ? date('d/m/Y H:i:s', intval($log->created_at) + 7 * 60 * 60) : "" ?></td>
									<td><?php echo !empty($log->created_by) ? ($log->created_by) : '' ?></td>
									<td><?php
										$status = '';
										$id_status = '';
										if (!empty($log->new->status)) {
											$id_status = $log->new->status;
										} elseif (!empty($log->old->status)) {
											$id_status = $log->old->status;
										}
										if (!empty($id_status)) {
											echo contract_status($id_status);
										}
										?>
									</td>
									<td><?php echo !empty($log->new->note) ? $log->new->note : '' ?></td>
								</tr>
							<?php }
						}

						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="ContractVerifyCVS" tabindex="-1" role="dialog" aria-labelledby="ContractVerifyCVS"
	 aria-hidden="true">
	<div class="modal-dialog" role="document" style="width: 978px;max-width:95vw;">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title">Xác thực CVS</h5>
				<hr>
				<div class="table-responsive">
					<table id="datatable-buttons" class="table table-striped"
						   style="width: 100%; white-space: normal">
						<h4 class="text-center">Tìm kiểm ảnh trong blacklist</h4>
						<thead>
						<tr>
							<th>Ảnh</th>
							<th>Tên</th>
							<th>Số ĐT</th>
							<th>Số CMTND</th>
							<th>Ghi chú</th>
						</tr>
						</thead>
						<tbody>
						<?php if (!empty($verify_identify) && !empty($verify_identify->data_Face_search)) { ?>
							<?php foreach ($verify_identify->data_Face_search as $value) { ?>
								<tr>
									<td>
										<image style="width: 200px"
											   src="<?php echo !empty($value->url) ? $value->url : '' ?>"></image>
									</td>
									<td><?php echo !empty($value->metadata->name) ? $value->metadata->name : '' ?></td>
									<td><?php echo !empty($value->metadata->phone) ? $value->metadata->phone : '' ?></td>
									<td><?php echo !empty($value->metadata->identify) ? $value->metadata->identify : '' ?></td>
									<td><?php echo !empty($value->metadata->note) ? $value->metadata->note : '' ?></td>
								</tr>
							<?php } ?>
						<?php } ?>
						</tbody>
					</table>
				</div>
				<hr>
				<div class="table-responsive">
					<table id="datatable-buttons" class="table table-striped" style="width: 100%;">
						<h4 class="text-center">So khớp ảnh</h4>
						<thead>
						<tr>
							<th>Ảnh giấy tờ tùy thân</th>
							<th>Ảnh chân dung</th>
						</tr>
						</thead>
						<tbody>
						<?php if (!empty($verify_identify) && !empty($verify_identify->data_Face_Identify)) { ?>
							<tr>
								<td>
									<image style="width: 200px"
										   src="<?php echo $verify_identify->data_Face_Identify->img_person ?>"></image>
								</td>
								<td>
									<image style="width: 200px"
										   src="<?php echo $verify_identify->data_Face_Identify->backside ?>"></image>
								</td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
					<?php if (!empty($verify_identify->data_Face_Identify->matching)) { ?>
						<h4 class="text-center">
							Matching <?php echo round($verify_identify->data_Face_Identify->matching) ?>%</h4>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="approve_call" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>

				<button id="call" class="btn btn-success"><i class="fa fa-phone" aria-hidden="true"></i>Gọi</button>
				<button id="end" class="btn btn-danger"><i class="fa fa-ban" aria-hidden="true"></i> Dừng</button>
				<input id="number" name="phone_number" type="hidden" value=""/>
				<p id="status" style="margin-left: 125px;"></p>
				<h3 class="modal-title title_modal_approve"></h3>
				<hr>
				<div class="form-group">
					<input type="text" value="<?php echo $this->input->get('id') ?>" class="hidden"
						   class="form-control " id="contract_id">
				</div>
				<div class="form-group">
					<label>Kết quả nhắc HĐ vay:</label>
					<select class="form-control " style="width: 70%" id="result_reminder">
						<?php foreach (note_renewal() as $key => $value) { ?>
							<option value="<?= $key ?>"><?= $value ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label>Ngày hẹn thanh toán:</label>
					<input type="date" name="payment_date" class="form-control " id="payment_date" required>
				</div>
				<div class="form-group">
					<label>Số tiền hẹn thanh toán:</label>
					<input type="text" class="form-control " id="amount_payment_appointment" required>
				</div>
				<div class="form-group">
					<label>Ghi chú:</label>
					<textarea class="form-control " id="contract_v2_note" rows="5" required></textarea>
					<input type="hidden" class="form-control contract_id">
				</div>
				<p class="text-right">
					<button class="btn btn-danger " id="approve_call_submit">Xác nhận</button>
				</p>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div id="contract_involve" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Hợp đồng liên quan</h4>
			</div>
			<div class="modal-body">


				<table class="table table-bordered">
					<thead>
					<tr>
						<th>Mã Hợp Đồng</th>
						<th>Mã Phiếu ghi</th>
						<th>Số Tiền Vay</th>
						<th>Thời Hạn</th>
						<th>Phòng Giao Dịch</th>
						<th>Trạng Thái</th>
					</tr>
					</thead>
					<tbody>
					<?php
					if (!empty($contract_involve_phone)) {
						?>
						<tr>
							<th colspan="5">
								Số điện
								thoại: <?= $contractInfor->customer_infor->customer_phone_number ? hide_phone($contractInfor->customer_infor->customer_phone_number) : "" ?>
							</th>
						</tr>
						<?php
						foreach ($contract_involve_phone as $key => $value) {
							$status = contract_status($value->status);
							?>
							<tr>
								<td><a target="_blank"
									   href="<?php echo base_url("accountant/view?id=") . $value->_id->{'$oid'} ?>"><?= $value->code_contract_disbursement; ?></a>
								</td>
								<td><a target="_blank"
									   href="<?php echo base_url("accountant/view?id=") . $value->_id->{'$oid'} ?>"><?= $value->code_contract; ?></a>
								</td>
								<td><?= number_format($value->loan_infor->amount_money) . " vnđ"; ?></td>
								<td><?= ($value->loan_infor->number_day_loan / 30) . " tháng"; ?></td>
								<td><?= $value->store->name; ?></td>
								<td><?= $status; ?></td>
							</tr>
						<?php }
					} ?>

					<?php
					if (!empty($contract_involve_identify)) {
						?>
						<tr>
							<th colspan="5">
								Số
								CMND: <?= $contractInfor->customer_infor->customer_identify ? $contractInfor->customer_infor->customer_identify : "" ?>
							</th>
						</tr>
						<?php
						foreach ($contract_involve_identify as $key => $value) {
							$status = contract_status($value->status);
							?>
							<tr>
								<td><a target="_blank"
									   href="<?php echo base_url("accountant/view?id=") . $value->_id->{'$oid'} ?>"><?= $value->code_contract_disbursement; ?></a>
								</td>
								<td><a target="_blank"
									   href="<?php echo base_url("accountant/view?id=") . $value->_id->{'$oid'} ?>"><?= $value->code_contract; ?></a>
								</td>
								<td><?= number_format($value->loan_infor->amount_money) . " vnđ"; ?></td>
								<td><?= ($value->loan_infor->number_day_loan / 30) . " tháng"; ?></td>
								<td><?= $value->store->name; ?></td>
								<td><?= $status; ?></td>
							</tr>
						<?php }
					} ?>

					<?php
					if (!empty($contract_involve_identify_old)) {
						?>
						<tr>
							<th colspan="5">
								Số
								CCCD: <?= $contractInfor->customer_infor->customer_identify_old ? $contractInfor->customer_infor->customer_identify_old : "" ?>
							</th>
						</tr>
						<?php
						foreach ($contract_involve_identify_old as $key => $value) {
							$status = contract_status($value->status);
							?>
							<tr>
								<td><a target="_blank"
									   href="<?php echo base_url("accountant/view?id=") . $value->_id->{'$oid'} ?>"><?= $value->code_contract_disbursement; ?></a>
								</td>
								<td><a target="_blank"
									   href="<?php echo base_url("accountant/view?id=") . $value->_id->{'$oid'} ?>"><?= $value->code_contract; ?></a>
								</td>
								<td><?= number_format($value->loan_infor->amount_money) . " vnđ"; ?></td>
								<td><?= ($value->loan_infor->number_day_loan / 30) . " tháng"; ?></td>
								<td><?= $value->store->name; ?></td>
								<td><?= $status; ?></td>
							</tr>
						<?php }
					} ?>

					<?php
					if (!empty($contract_involve_relative_1)) {
						?>
						<tr>
							<th colspan="5">
								Số tham chiếu
								1: <?= $contractInfor->relative_infor->phone_number_relative_1 ? hide_phone($contractInfor->relative_infor->phone_number_relative_1) : "" ?>
							</th>
						</tr>
						<?php
						foreach ($contract_involve_relative_1 as $key => $value) {
							$status = contract_status($value->status);
							?>
							<tr>
								<td><a target="_blank"
									   href="<?php echo base_url("accountant/view?id=") . $value->_id->{'$oid'} ?>"><?= $value->code_contract_disbursement; ?></a>
								</td>
								<td><a target="_blank"
									   href="<?php echo base_url("accountant/view?id=") . $value->_id->{'$oid'} ?>"><?= $value->code_contract; ?></a>
								</td>
								<td><?= number_format($value->loan_infor->amount_money) . " vnđ"; ?></td>
								<td><?= ($value->loan_infor->number_day_loan / 30) . " tháng"; ?></td>
								<td><?= $value->store->name; ?></td>
								<td><?= $status; ?></td>
							</tr>
						<?php }
					} ?>
					<?php
					if (!empty($contract_involve_relative_2)) {
						?>
						<tr>
							<th colspan="5">
								Số tham chiếu
								2: <?= $contractInfor->relative_infor->phone_number_relative_2 ? hide_phone($contractInfor->relative_infor->phone_number_relative_2) : "" ?>
							</th>
						</tr>
						<?php
						foreach ($contract_involve_relative_2 as $key => $value) {
							$status = contract_status($value->status);

							?>
							<tr>
								<td><a target="_blank"
									   href="<?php echo base_url("accountant/view?id=") . $value->_id->{'$oid'} ?>"><?= $value->code_contract_disbursement; ?></a>
								</td>
								<td><a target="_blank"
									   href="<?php echo base_url("accountant/view?id=") . $value->_id->{'$oid'} ?>"><?= $value->code_contract; ?></a>
								</td>
								<td><?= number_format($value->loan_infor->amount_money) . " vnđ"; ?></td>
								<td><?= ($value->loan_infor->number_day_loan / 30) . " tháng"; ?></td>
								<td><?= $value->store->name; ?></td>
								<td><?= $status; ?></td>
							</tr>
						<?php }
					} ?>


					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<?php $this->load->view('page/pawn/deepDetect', isset($this->data) ? $this->data : NULL); ?>

<!--Modal tạo tài sản thanh lý B01-->
<?php $this->load->view('page/pawn/asset_liquidation/modal_create_request_liquidation_asset.php'); ?>

<!--Modal bộ phận định giá tài sản xử lý B02-->
<?php $this->load->view('page/pawn/asset_liquidation/modal_bp_dinh_gia_xu_ly.php'); ?>

<!--Modal THN gửi lại YC định giá tài sản B01a-->
<?php $this->load->view('page/pawn/asset_liquidation/modal_thn_send_to_bpdg_again.php'); ?>

<!--Modal THN cập nhật thông tin định giá B03-->
<?php $this->load->view('page/pawn/asset_liquidation/modal_tpthn_cap_nhat_gia_ban.php'); ?>

<!--Modal THN duyệt thay CEO  B03-->
<?php $this->load->view('page/pawn/asset_liquidation/modal_tpthn_approve_instate_ceo.php'); ?>

<!--Modal BP Định giá xử lý lại  B04-->
<?php $this->load->view('page/pawn/asset_liquidation/modal_bp_dinh_gia_approve_again.php'); ?>

<!--Modal TP THN bán tài sản thanh lý  B05-->
<?php $this->load->view('page/pawn/asset_liquidation/modal_thn_sell_asset_liquidation.php'); ?>

<div class="modal fade" id="follow_contract" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_send_file"></h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<input type="hidden" id="follow_email">
					<input type="hidden" id="follow_idStore">
					<input type="hidden" id="follow_idEmail">
					<div class="col-xs-12">
						<div style="text-align: center">
							<button type="button" id="submit_follow_contract" class="btn btn-info">Xác nhận</button>
							<button type="button" class="btn btn-primary close-hs" data-dismiss="modal"
									aria-label="Close">
								Hủy
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--Modal Tool đổi nguồn khách hàng-->
<div class="modal fade" id="change_customer_source" tabindex="-1" role="dialog" aria-labelledby="change_customer_source"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-PGD" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center">Đồi nguồn khách hàng</h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">Đổi nguồn khách hàng
								<span class="text-danger">*</span>
							</label>
							<div class="col-md-9 col-xs-12 error_messages">
								<select class="form-control" name="customer_resource_convert"
										id="customer_resource_convert">
									<option value="" <?php echo $status == '-' ? 'selected' : '' ?>>-- Tất cả nguồn --
									</option>
									<?php foreach (lead_nguon_full() as $key => $value) : ?>
										<option <?php echo $contractInfor->customer_infor->customer_resources == $key ? 'selected' : '' ?>
												value="<?= $key ?>"> <?= $value ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12"><span></span>
								Ghi chú:</label>
							<div class="col-md-9 col-xs-12 error_messages">
								<textarea class="form-control note_change_source" name="note_change_source"
										  rows="5"></textarea>
								<input type="hidden" class="form-control contract_id">
								<p class="messages"></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-md-8 col-xs-12"></div>
					<div class="col-md-4 col-xs-12">
						<button type="button" class="btn btn-danger close-hs" data-dismiss="modal"
								aria-label="Close">Đóng
						</button>
						<button type="button" class="btn btn-info " id="change_source">Xác nhận</button>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<!--Modal Lịch sử đổi nguồn khách hàng-->
<div class="modal fade" id="historyChangeSource" tabindex="-1" role="dialog" aria-labelledby="historyChangeSource"
	 aria-hidden="true">
	<div class="modal-dialog" role="document" style="width: 978px;max-width:95vw;">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title">Lịch sử đổi nguồn khách hàng</h5>
				<hr>
				<div class="table-responsive">
					<table id="datatable-buttons" class="table table-striped" style="width: 100%">
						<thead>
						<tr>
							<th>#</th>
							<th>Thời gian</th>
							<th>Nguồn cũ</th>
							<th>Nguồn mới</th>
							<th>Ghi chú</th>
							<th>Người cập nhập</th>

						</tr>
						</thead>
						<tbody>
						<?php
						if (!empty($logs_change_source)) {
							foreach ($logs_change_source as $key => $log) {
								?>
								<tr>
									<td><?php echo $key + 1 ?></td>
									<td><?php echo !empty($log->created_at) ? date('d/m/Y H:i:s', $log->created_at) : "" ?></td>
									<td><?php
										$customer_source_old = '';
										$customer_source_old = $log->old->customer_infor->customer_resources;
										if (!empty($customer_source_old)) {
											echo lead_nguon_full($customer_source_old);
										}
										?>
									</td>
									<td><?php
										$customer_source_new = '';
										$customer_source_new = $log->new->customer_resource;
										if (!empty($customer_source_new)) {
											echo lead_nguon_full($customer_source_new);
										}
										?>
									</td>
									<td><?php echo !empty($log->new->note) ? $log->new->note : '' ?></td>
									<td><?php echo !empty($log->created_by) ? $log->created_by : '' ?></td>
								</tr>
							<?php }
						}

						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


<!--Modal Tool sửa mã hợp đồng (code_contract_disbursement đồng bộ mã HĐ bảng temporary_plan_contract-->
<div class="modal fade" id="edit_code_contract_disbursement" tabindex="-1" role="dialog"
	 aria-labelledby="edit_code_contract_disbursement"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-PGD" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center">Sửa mã hợp đồng với mã phiếu
					ghi: <?= $contractInfor->code_contract ? $contractInfor->code_contract : '' ?></h3>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12">
						<div class="row">
							<label class="control-label col-md-3 col-xs-12">Mã hợp đồng cũ</label>
							<div class="col-md-9 col-xs-12 error_messages">
								<input type="text"
									   class="form-control"
									   name="old_code_contract_disbursement"
									   value="<?= $contractInfor->code_contract_disbursement ? $contractInfor->code_contract_disbursement : '' ?>"
									   disabled>
								<input type="hidden"
									   id="code_contract_d_edit"
									   class="form-control"
									   name="code_contract_d_edit"
									   value="<?= $contractInfor->code_contract ? $contractInfor->code_contract : '' ?>"
									   disabled>
								<input type="hidden"
									   id="contract_id_d_edit"
									   class="form-control"
									   name="contract_id_d_edit"
									   value="<?= $contractInfor->_id->{'$oid'} ? $contractInfor->_id->{'$oid'} : '' ?>"
									   disabled>
							</div>
						</div>
						<br>
						<div class="row">
							<label class="control-label col-md-3 col-xs-12">Mã hợp đồng mới
								<span class="text-danger">*</span>
							</label>
							<div class="col-md-9 col-xs-12 error_messages">
								<input type="text"
									   class="form-control new_code_contract_disbursement"
									   name="new_code_contract_disbursement"
									   id="new_code_contract_disbursement">
							</div>
						</div>
						<br>
						<div class="row">
							<label class="control-label col-md-3 col-xs-12"><span></span>
								Ghi chú:</label>
							<div class="col-md-9 col-xs-12 error_messages">
								<textarea class="form-control note_edit_code_contract_disbursement"
										  name="note_edit_code_contract_disbursement"
										  rows="3"></textarea>
								<input type="hidden" class="form-control contract_id">
								<p class="messages"></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-md-8 col-xs-12"></div>
					<div class="col-md-4 col-xs-12">
						<button type="button" class="btn btn-danger close-hs" data-dismiss="modal"
								aria-label="Close">Đóng
						</button>
						<button type="button" class="btn btn-info " id="confirm_edit">Xác nhận</button>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<!--Modal Option Status loại hợp đồng điện tử Megadoc -->
<div class="modal fade" id="checkStatusContractMegadoc" tabindex="-1" role="dialog"
	 aria-labelledby="checkStatusContractMegadoc"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-PGD" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center">Kiểm tra trạng thái hợp đồng điện tử Megadoc</h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" id="code_contract_searchkey"
							   value="<?= isset($contractInfor->code_contract) ? $contractInfor->code_contract : '' ?>">
						<div class="row">
							<label class="control-label col-md-6 col-xs-12">
								Thỏa thuận ba bên:<span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-xs-12">
								<input type="radio"
									   class="ttbb_status"
									   name="searchkey_document"
									   value="<?= $contractInfor->megadoc->ttbb->searchkey ? $contractInfor->megadoc->ttbb->searchkey : '' ?>"
									   checked>
							</div>
						</div>
						<br>
						<div class="row">
							<label class="control-label col-md-6 col-xs-12">
								BBBG sau khi ký TTBB:<span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-xs-12">
								<input type="radio"
									   class="bbbg_after_sign"
									   name="searchkey_document"
									   value="<?= $contractInfor->megadoc->bbbg_before_sign->searchkey ? $contractInfor->megadoc->bbbg_before_sign->searchkey : '' ?>">
							</div>
						</div>
						<br>
						<?php if (!empty($contractInfor->loan_infor->type_property->code) && $contractInfor->loan_infor->type_property->code != 'NĐ') : ?>
							<div class="row">
								<label class="control-label col-md-6 col-xs-12">
									Thông báo:<span class="text-danger">*</span>
								</label>
								<div class="col-md-6 col-xs-12">
									<input type="radio"
										   class="tb"
										   name="searchkey_document"
										   value="<?= $contractInfor->megadoc->tb->searchkey ? $contractInfor->megadoc->tb->searchkey : '' ?>">
								</div>
							</div>
							<br>
						<?php endif; ?>
						<div class="row">
							<label class="control-label col-md-6 col-xs-12">
								BBBG sau khi thanh lý TTBB:<span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-xs-12">
								<input type="radio"
									   class="bbbg_after_final"
									   name="searchkey_document"
									   value="<?= $contractInfor->megadoc->bbbg_after_sign->searchkey ? $contractInfor->megadoc->bbbg_after_sign->searchkey : '' ?>">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-md-8 col-xs-12"></div>
					<div class="col-md-4 col-xs-12">
						<button type="button" class="btn btn-danger close-hs" data-dismiss="modal"
								aria-label="Close">Đóng
						</button>
						<button type="button" class="btn btn-info " id="confirm_check_status">Xác nhận</button>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<!--Modal Result Trạng thái hợp đồng điện tử Megadoc-->
<div class="modal fade" id="statusContractMegadoc" tabindex="-1" role="dialog" aria-labelledby="statusContractMegadoc"
	 aria-hidden="true">
	<div class="modal-dialog" role="document" style="width: 978px;max-width:95vw;">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title">Trạng thái hợp đồng điện tử Megadoc</h5>
				<hr>
				<div class="table-responsive">
					<table id="datatable-buttons" class="table table-striped" style="width: 100%">
						<thead>
						<tr>
							<th>Mã phiếu ghi văn bản</th>
							<th>Mã tra cứu</th>
							<th>Ngày lập hợp đồng</th>
							<th>Ngày ký hợp đồng</th>
							<th>Ngày hoàn thành hợp đồng</th>
							<th>Trạng thái hợp đồng</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td id="fkey_resp"></td>
							<td id="searchkey_resp"></td>
							<td id="createdate_resp"></td>
							<td id="signdate_resp"></td>
							<td id="completedate_resp"></td>
							<td id="status_resp"></td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!--Modal hủy hợp đồng điện tử Megadoc-->
<div class="modal fade" id="cancel_contract_megadoc" tabindex="-1" role="dialog"
	 aria-labelledby="cancel_contract_megadoc"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-PGD" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center">Hủy hợp đồng điện tử Megadoc</h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<div class="row">
							<label class="control-label col-md-6 col-xs-12">
								Thỏa thuận ba bên:<span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-xs-12">
								<input type="radio"
									   class="ttbb_status"
									   name="fkey_document"
									   data-fkey="<?= $contractInfor->megadoc->ttbb->fkey ? $contractInfor->megadoc->ttbb->fkey : '' ?>"
									   data-contractno="<?= $contractInfor->megadoc->ttbb->contract_no ? $contractInfor->megadoc->ttbb->contract_no : '' ?>"
									   checked
								>
							</div>
						</div>
						<br>
						<div class="row">
							<label class="control-label col-md-6 col-xs-12">
								BBBG sau khi ký TTBB:<span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-xs-12">
								<input type="radio"
									   class="bbbg_after_sign"
									   name="fkey_document"
									   data-fkey="<?= $contractInfor->megadoc->bbbg_before_sign->fkey ? $contractInfor->megadoc->bbbg_before_sign->fkey : '' ?>"
									   data-contractno="<?= $contractInfor->megadoc->bbbg_before_sign->contract_no ? $contractInfor->megadoc->bbbg_before_sign->contract_no : '' ?>"
								>
							</div>
						</div>
						<br>
						<?php if (!empty($contractInfor->loan_infor->type_property->code) && $contractInfor->loan_infor->type_property->code != 'NĐ') : ?>
							<div class="row">
								<label class="control-label col-md-6 col-xs-12">
									Thông báo:<span class="text-danger">*</span>
								</label>
								<div class="col-md-6 col-xs-12">
									<input type="radio"
										   class="tb"
										   name="fkey_document"
										   data-fkey="<?= $contractInfor->megadoc->tb->fkey ? $contractInfor->megadoc->tb->fkey : '' ?>"
										   data-contractno="<?= $contractInfor->megadoc->tb->contract_no ? $contractInfor->megadoc->tb->contract_no : '' ?>"
									>
								</div>
							</div>
							<br>
						<?php endif; ?>
						<div class="row">
							<label class="control-label col-md-6 col-xs-12">
								BBBG sau khi thanh lý TTBB:<span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-xs-12">
								<input type="radio"
									   class="bbbg_after_final"
									   name="fkey_document"
									   data-fkey="<?= $contractInfor->megadoc->bbbg_after_sign->fkey ? $contractInfor->megadoc->bbbg_after_sign->fkey : '' ?>"
									   data-contractno="<?= $contractInfor->megadoc->bbbg_after_sign->contract_no ? $contractInfor->megadoc->bbbg_after_sign->contract_no : '' ?>"
								>
							</div>
						</div>
						<br>
						<div class="row">
							<label class="control-label col-md-2 col-xs-12">
								Lý do hủy:<span class="text-danger">*</span>
							</label>
							<div class="col-md-9 col-xs-12 error_messages">
								<textarea class="form-control reason_cancel_megadoc" name="reason_cancel_megadoc"
										  rows="3"></textarea>
								<input type="hidden" class="form-control" id="contract_no_cancel">
								<p class="messages"></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-md-8 col-xs-12"></div>
					<div class="col-md-4 col-xs-12">
						<button type="button" class="btn btn-danger close-hs" data-dismiss="modal"
								aria-label="Close">Đóng
						</button>
						<button type="button" class="btn btn-info " id="confirm_cancel_megadoc">Xác nhận</button>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<!-- Modal view Status loại hợp đồng điện tử Megadoc -->
<div class="modal fade" id="viewStatusContractMegadoc" tabindex="-1" role="dialog"
	 aria-labelledby="viewStatusContractMegadoc"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-PGD" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center">Hợp đồng điện tử Megadoc</h3>
			</div>
			<div class="modal-body ">
				<div class="table-responsive">
					<input type="hidden" id="">
					<table id="datatable-buttons" class="table table-striped" style="width: 100%">
						<thead>
						<tr>
							<th>Thỏa thuận ba bên</th>
							<th>BBBG Tài sản trước khi ký TTBB</th>
							<?php if (!empty($contractInfor->loan_infor->type_property->code) && $contractInfor->loan_infor->type_property->code != 'NĐ') : ?>
								<th>Thông báo</th>
							<?php endif; ?>
							<th>BBBG Tài sản sau khi thanh lý hợp đồng vay</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td class="text-center">
								<span id="status_ttbb"></span>
								<span id="download_ttbb"></span>
								<?php if (!empty($contractInfor->status) && in_array($contractInfor->status, [6])) : ?>
									<?php if (!empty($contractInfor->megadoc->ttbb->status) && $contractInfor->megadoc->ttbb->status == 99) { ?>
										<span id="recall_ttbb">Lỗi kết nối tới Megadoc</span>
										<a href="javascript:void(0)"
										   class="btn btn-info btn-sm"
										   onclick="resend_file_to_megadoc(this)"
										   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>"
										   data-statusapprove="6"
										   data-createtype="one">
											Tạo lại
										</a>
									<?php } ?>
									<?php if (in_array("6247e79554b42a30910dc976", $userRoles->role_access_rights) || $userSession['is_superadmin'] == 1) : ?>
										<span id="update_ttbb"></span>
									<?php endif; ?>
								<?php endif; ?>
								<!-- gửi lại SMS cho khách hàng ký số -->
								<?php if (in_array("626a182c4bee423dcc521205", $userRoles->role_access_rights) || $userSession['is_superadmin'] == 1) { ?>
									<?php if (!empty($sms_megadoc) && $sms_megadoc->searchkey == $contractInfor->megadoc->ttbb->searchkey && $sms_megadoc->status != "success" && $sms_megadoc->type == 'ky_so') : ?>
										<a href="javascript:void(0)" class="btn btn-info btn-sm"
										   onclick="resend_sms_to_customer(this)"
										   data-codecontract='<?= isset($contractInfor->code_contract) ? $contractInfor->code_contract : '' ?>'
										   data-idsms='<?= isset($sms_megadoc->_id->{'$oid'}) ? $sms_megadoc->_id->{'$oid'} : '' ?>'>
											Gửi lại SMS
										</a>
									<?php endif; ?>
								<?php } ?>

							</td>
							<td class="text-center">
								<span id="status_bbbgt"></span>
								<span id="download_bbbgt"></span>
								<?php if (!empty($contractInfor->status) && in_array($contractInfor->status, [6])) : ?>
									<?php if (!empty($contractInfor->megadoc->bbbg_before_sign->status) && $contractInfor->megadoc->bbbg_before_sign->status == 99) { ?>
										<span id="recall_bbbgt">Lỗi kết nối tới Megadoc</span>
										<a href="javascript:void(0)"
										   class="btn btn-info btn-sm"
										   onclick="resend_file_to_megadoc(this)"
										   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>"
										   data-statusapprove="15"
										   data-createtype="one">
											Tạo lại
										</a>
									<?php } ?>
									<?php if (in_array("6247e79554b42a30910dc976", $userRoles->role_access_rights) || $userSession['is_superadmin'] == 1) : ?>
										<span id="update_bbbgt"></span>
									<?php endif; ?>
								<?php endif; ?>
								<!-- gửi lại SMS cho khách hàng ký số -->
								<?php if (in_array("626a182c4bee423dcc521205", $userRoles->role_access_rights) || $userSession['is_superadmin'] == 1) { ?>
									<?php if (!empty($sms_megadoc) && $sms_megadoc->searchkey == $contractInfor->megadoc->bbbg_before_sign->searchkey && $sms_megadoc->status != "success" && $sms_megadoc->type == 'ky_so') : ?>
										<a href="javascript:void(0)" class="btn btn-info btn-sm"
										   onclick="resend_sms_to_customer(this)"
										   data-codecontract='<?= isset($contractInfor->code_contract) ? $contractInfor->code_contract : '' ?>'
										   data-idsms='<?= isset($sms_megadoc->_id->{'$oid'}) ? $sms_megadoc->_id->{'$oid'} : '' ?>'>
											Gửi lại SMS
										</a>
									<?php endif; ?>
								<?php } ?>
							</td>
							<!--							Nếu Hình thức vay có tài sản đảm bảo sẽ hiện văn bản thông báo-->
							<?php if (!empty($contractInfor->loan_infor->type_property->code) && $contractInfor->loan_infor->type_property->code != 'NĐ') : ?>
								<td class="text-center">
									<span id="status_tb"></span>
									<span id="download_tb"></span>
									<?php if (!empty($contractInfor->status) && in_array($contractInfor->status, [6])) : ?>
										<?php if (!empty($contractInfor->megadoc->tb->status) && $contractInfor->megadoc->tb->status == 99) { ?>
											<span id="recall_tb">Lỗi kết nối tới Megadoc</span>
											<a href="javascript:void(0)"
											   class="btn btn-info btn-sm"
											   onclick="resend_file_to_megadoc(this)"
											   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>"
											   data-statusapprove="16"
											   data-createtype="one">
												Tạo lại
											</a>
										<?php } ?>
										<?php if (in_array("6247e79554b42a30910dc976", $userRoles->role_access_rights) || $userSession['is_superadmin'] == 1) : ?>
											<span id="update_tb"></span>
										<?php endif; ?>
									<?php endif; ?>
									<!-- gửi lại SMS cho khách hàng ký số -->
									<?php if (in_array("626a182c4bee423dcc521205", $userRoles->role_access_rights) || $userSession['is_superadmin'] == 1) { ?>
										<?php if (!empty($sms_megadoc) && $sms_megadoc->searchkey == $contractInfor->megadoc->tb->searchkey && $sms_megadoc->status != "success" && $sms_megadoc->type == 'ky_so') : ?>
											<a href="javascript:void(0)" class="btn btn-info btn-sm"
											   onclick="resend_sms_to_customer(this)"
											   Gửi lại SMS
											</a>
										<?php endif; ?>
									<?php } ?>
								</td>
							<?php endif; ?>
							<!--							kết thúc hiển thị văn bản thông báo-->
							<td class="text-center">
								<span id="status_bbbgs"></span>
								<span id="download_bbbgs"></span>
								<?php if (!empty($contractInfor->megadoc->bbbg_after_sign->status) && $contractInfor->megadoc->bbbg_after_sign->status == 99) { ?>
									<span id="recall_bbbgs">Lỗi kết nối tới Megadoc</span>
									<a href="javascript:void(0)"
									   class="btn btn-info btn-sm"
									   onclick="resend_file_to_megadoc(this)"
									   data-id="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>"
									   data-statusapprove="19"
									   data-createtype="one">
										Tạo lại
									</a>
								<?php } ?>
								<!-- gửi lại SMS cho khách hàng ký số -->
								<?php if (in_array("626a182c4bee423dcc521205", $userRoles->role_access_rights) || $userSession['is_superadmin'] == 1) { ?>
									<?php if (!empty($sms_megadoc) && $sms_megadoc->searchkey == $contractInfor->megadoc->bbbg_after_sign->searchkey && $sms_megadoc->status != "success" && $sms_megadoc->type == 'ky_so') : ?>
										<a href="javascript:void(0)" class="btn btn-info btn-sm"
										   onclick="resend_sms_to_customer(this)"
										   data-codecontract='<?= isset($contractInfor->code_contract) ? $contractInfor->code_contract : '' ?>'
										   data-idsms='<?= isset($sms_megadoc->_id->{'$oid'}) ? $sms_megadoc->_id->{'$oid'} : '' ?>'>
											Gửi lại SMS
										</a>
									<?php endif; ?>
								<?php } ?>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<!-- Modal cảnh báo  xấu -->
<div id="contractExempted" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Hợp đồng liên quan</h4>
			</div>
			<div class="modal-body">

				<table class="table table-bordered">
					<thead>
					<tr>
						<th>Mã Hợp Đồng</th>
						<th>Mã Phiếu ghi</th>
						<th>Số Tiền Miễn Giảm</th>
						<th>Ngày Bắt Đầu</th>
						<th>Phòng Giao Dịch</th>
						<th>Trạng Thái</th>
					</tr>
					</thead>
					<tbody>
					<?php
					if (!empty($contractExempted)) {
						?>
						<tr>
							<th colspan="5">
								Hợp đồng được miễn
								giảm: <?= $contractExempted->customer_phone_number ? $contractExempted->customer_phone_number : "" ?>
							</th>
						</tr>
						<?php
						foreach ($contractExempted as $key => $value) {
							$status = contract_status($value->status);
							?>
							<tr>
								<td><a target="_blank"
									   href="<?php echo base_url("accountant/view?id=") . $value->id_contract . "#tab_content_history_exemption_contract" ?>"><?= $value->code_contract_disbursement; ?></a>
								</td>
								<td><a target="_blank"
									   href="<?php echo base_url("accountant/view?id=") . $value->id_contract . "#tab_content_history_exemption_contract" ?>"><?= $value->code_contract; ?></a>
								</td>
								<td><?= number_format($value->amount_customer_suggest) . " vnđ"; ?></td>
								<td><?= date("d/m/y", $value->date_suggest) ?></td>
								<td><?= $value->store->name; ?></td>
								<td><?= $status; ?></td>
							</tr>
						<?php }
					} ?>
				</table>
				<table class="table table-bordered">
					<thead>
					<tr>
						<th>Mã Hợp Đồng</th>
						<th>Mã Phiếu ghi</th>
						<th>Số Tiền Vay</th>
						<th>Thời Hạn</th>
						<th>Phòng Giao Dịch</th>
						<th>Trạng Thái</th>
					</tr>
					</thead>
					<tbody>
					<?php
					if (!empty($contract_involve_phone)) {
						?>
						<tr>
							<th colspan="5">
								Số
								Điện
								Thoại: <?= $contractInfor->customer_infor->customer_phone_number ? $contractInfor->customer_infor->customer_phone_number : "" ?>
							</th>
						</tr>
						<?php
						foreach ($contract_involve_phone as $key => $value) {
							$status = contract_status($value->status);
							?>
							<tr>
								<td><a target="_blank"
									   href="<?php echo base_url("accountant/view?id=") . $value->_id->{'$oid'} ?>"><?= $value->code_contract_disbursement; ?></a>
								</td>
								<td><a target="_blank"
									   href="<?php echo base_url("accountant/view?id=") . $value->_id->{'$oid'} ?>"><?= $value->code_contract; ?></a>
								</td>
								<td><?= number_format($value->loan_infor->amount_money) . " vnđ"; ?></td>
								<td><?= ($value->loan_infor->number_day_loan / 30) . " tháng"; ?></td>
								<td><?= $value->store->name; ?></td>
								<td><?= $status; ?></td>
							</tr>
						<?php }
					} ?>

					<?php
					if (!empty($contract_involve_identify)) {
						?>
						<tr>
							<th colspan="5">
								Số
								CMND: <?= $contractInfor->customer_infor->customer_identify ? $contractInfor->customer_infor->customer_identify : "" ?>
							</th>
						</tr>
						<?php
						foreach ($contract_involve_identify as $key => $value) {
							$status = contract_status($value->status);
							?>
							<tr>
								<td><a target="_blank"
									   href="<?php echo base_url("accountant/view?id=") . $value->_id->{'$oid'} ?>"><?= $value->code_contract_disbursement; ?></a>
								</td>
								<td><a target="_blank"
									   href="<?php echo base_url("accountant/view?id=") . $value->_id->{'$oid'} ?>"><?= $value->code_contract; ?></a>
								</td>
								<td><?= number_format($value->loan_infor->amount_money) . " vnđ"; ?></td>
								<td><?= ($value->loan_infor->number_day_loan / 30) . " tháng"; ?></td>
								<td><?= $value->store->name; ?></td>
								<td><?= $status; ?></td>
							</tr>
						<?php }
					} ?>

					<?php
					if (!empty($contract_involve_identify_old)) {
						?>
						<tr>
							<th colspan="5">
								Số
								CCCD: <?= $contractInfor->customer_infor->customer_identify_old ? $contractInfor->customer_infor->customer_identify_old : "" ?>
							</th>
						</tr>
						<?php
						foreach ($contract_involve_identify_old as $key => $value) {
							$status = contract_status($value->status);
							?>
							<tr>
								<td><a target="_blank"
									   href="<?php echo base_url("accountant/view?id=") . $value->_id->{'$oid'} ?>"><?= $value->code_contract_disbursement; ?></a>
								</td>
								<td><a target="_blank"
									   href="<?php echo base_url("accountant/view?id=") . $value->_id->{'$oid'} ?>"><?= $value->code_contract; ?></a>
								</td>
								<td><?= number_format($value->loan_infor->amount_money) . " vnđ"; ?></td>
								<td><?= ($value->loan_infor->number_day_loan / 30) . " tháng"; ?></td>
								<td><?= $value->store->name; ?></td>
								<td><?= $status; ?></td>
							</tr>
						<?php }
					} ?>

					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>


<style>
	#nav-main-menu {
		float: left;
	}

	#nav-main-menu .main-nav {
		-webkit-backface-visibility: hidden;
		-moz-backface-visibility: hidden;
		-o-backface-visibility: hidden;
		backface-visibility: hidden;
	}

	#nav-main-menu .main-nav ul {
		padding-left: 0;
		margin: 0;
		list-style: none;
	}

	#nav-main-menu .main-nav > ul > li {
		position: relative;
		display: inline-block;
		background: #ea1e24b5;
		z-index: 10;
		border-radius: 5px;
	}

	#nav-main-menu .main-nav ul.level0 li a {
		color: #fff;
		display: block;
		font-size: 14px;
		padding: 6px 12px;
		margin: 0 15px;
		position: relative;
	}

	#nav-main-menu .main-nav .sub_menu {
		background: #12884a;
		position: absolute;
		border-radius: 5px;
		z-index: 999;
		min-width: 200px;
		margin-top: 30px;
		opacity: 0;
		visibility: hidden;
		-webkit-box-shadow: 0px 2px 20px rgb(0 0 0 / 20%);
		-moz-box-shadow: 0px 2px 20px rgba(0, 0, 0, 0.20);
		-o-box-shadow: 0px 2px 20px rgba(0, 0, 0, 0.20);
		-ms-box-shadow: 0px 2px 20px rgba(0, 0, 0, 0.20);
		box-shadow: 0px 2px 20px rgb(0 0 0 / 20%);
		-webkit-transform-origin: 0 0 0;
		-moz-transform-origin: 0 0 0;
		-o-transform-origin: 0 0 0;
		-ms-transform-origin: 0 0 0;
		transform-origin: 0 0 0;
		-webkit-transition: all .5s ease;
		-moz-transition: all .5s ease;
		-o-transition: all .5s ease;
		transition: all .5s ease;
	}

	#nav-main-menu .main-nav ul li .sub_menu li {
		position: relative;
	}

	#nav-main-menu .main-nav .sub_menu a {
		padding: 9px 18px;
		white-space: nowrap;
		text-align: left;
		display: block;
		font-size: 14px;
	}

	#nav-main-menu .main-nav ul > li a i {
		display: flex;
		vertical-align: middle;
		font-size: 9px;
		position: absolute;
		right: 0;
		top: 0;
		bottom: 0;
		margin: auto;
		align-items: center;
	}

	#nav-main-menu .main-nav .sub_menu.level2 {
		left: 130%;
		top: 0;
		margin-top: 0;
		opacity: 0;
		background: #423f3f;
		visibility: hidden;
	}

	#nav-main-menu .main-nav li:hover > .sub_menu {
		opacity: 1;
		visibility: visible;
		margin-top: 0;
	}

	#nav-main-menu .main-nav li:hover > .sub_menu.level2 {
		left: 100%;
		opacity: 1;
		visibility: visible;
	}

	#nav-main-menu .main-nav ul > li:hover > a i {
		-webkit-transform: rotate(
				180deg);
		-moz-transform: rotate(180deg);
		-ms-transform: rotate(180deg);
		-o-transform: rotate(180deg);
		transform: rotate(
				180deg);
		margin-bottom: 0;
	}

	#nav-main-menu .main-nav ul > li:hover > a i {
		-webkit-transform: rotate(
				180deg);
		-moz-transform: rotate(180deg);
		-ms-transform: rotate(180deg);
		-o-transform: rotate(180deg);
		transform: rotate(
				180deg);
		margin-bottom: 0;
	}

	.termtitle {
		color: #00a35b;
		font-size: 20px;
		font-weight: 700;
		line-height: 30px;
		margin-bottom: 16px;
		text-align: justify;
	}
</style>
<?php $this->load->view('page/pawn/modal_contract', isset($this->data) ? $this->data : NULL); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment-with-locales.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/pawn/contract.js?rev=<?php echo time(); ?>"></script>
<script src="<?php echo base_url("assets") ?>/js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets") ?>/js/numeral.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/accountant/index.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css"/>
<!-- <script src="<?php echo base_url(); ?>assets/js/pawn/index.js"></script> -->
<script src="<?php echo base_url(); ?>assets/js/deepDetect/deepDetect.js"></script>

<script type="text/javascript">
	function showModal() {
		$('#ContractHistoryModal').modal('show');
	}

	function showModalVerifyCVS() {
		$('#ContractVerifyCVS').modal('show');
	}

	function showModalChangeSource() {
		$('#change_customer_source').modal('show');
	}

	function showModalHistorySource() {
		$('#historyChangeSource').modal('show');
	}

	function showModalEditCodeContractDisbursement() {
		$('#edit_code_contract_disbursement').modal('show');
	}

	function status_contract_megadoc(thiz) {
		$("#checkStatusContractMegadoc").modal('show');
	}

	function view_status_contract_megadoc(thiz) {
		var id_contract = $(thiz).data('id');
		var formData = {
			id_contract: id_contract
		}

		$.ajax({
			url: _url.base_url + "Pawn/sync_status_megadoc",
			method: "POST",
			data: formData,
			success: function (data) {
				$('#status_ttbb').empty();
				$('#status_bbbgt').empty();
				$('#status_tb').empty();
				$('#status_bbbgs').empty();
				$('#recall_ttbb').empty();
				$('#update_ttbb').empty();
				$('#download_ttbb').empty();
				$('#recall_bbbgt').empty();
				$('#update_bbbgt').empty();
				$('#download_bbbgt').empty();
				$('#recall_tb').empty();
				$('#update_tb').empty();
				$('#download_tb').empty();
				$('#recall_bbbgs').empty();
				$('#update_bbbgs').empty();
				$('#download_bbbgs').empty();
				let status_fail_megadoc = 'Lỗi kết nối tới Megadoc';
				let status_not_send_megadoc = 'Chưa gửi';
				let status_sended_megadoc = 'Đã gửi';
				let status_one_sign_megadoc = 'Hợp đồng có một chữ ký';
				let status_finish_megadoc = 'Hợp đồng hoàn thành';
				let status_cancel_megadoc = 'Đã hủy';
				$.each(data, function (i, megadoc) {
					// Check trạng thái ttbb để sinh ra button tương ứng
					if (megadoc.status_ttbb == "") {
						$('#status_ttbb').append(status_not_send_megadoc);
					}
					if (!isEmpty(megadoc.status_ttbb) && megadoc.status_ttbb == 1) {
						$('#status_ttbb').append(status_sended_megadoc);
					}
					if (!isEmpty(megadoc.status_ttbb) && megadoc.status_ttbb == 1 && megadoc.status_contract == 6) {
						$('#update_ttbb').html('<a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="resend_file_to_megadoc(this)" data-id="' + megadoc.contract_id + '" data-statusapprove="6" data-createtype="1">Cập nhật</a>');
					}
					if (!isEmpty(megadoc.status_ttbb) && megadoc.status_ttbb == 2) {
						$('#status_ttbb').append(status_one_sign_megadoc);
					}
					if (!isEmpty(megadoc.status_ttbb) && megadoc.status_ttbb == 3) {
						$('#status_ttbb').append(status_finish_megadoc);
						$('#download_ttbb').html('<a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="download_file_to_megadoc(this)" data-id="' + megadoc.contract_id + '" data-searchkey="' + megadoc.searchkey_ttbb + '" data-codecontract="' + megadoc.code_contract + '" data-createtype="ttbb">Tải về</a>');
					}
					if (!isEmpty(megadoc.status_ttbb) && megadoc.status_ttbb == 7) {
						$('#status_ttbb').append(status_cancel_megadoc);
					}
					// Check trạng thái bbbgt để sinh ra button tương ứng
					if (megadoc.status_bbbgt == "") {
						$('#status_bbbgt').append(status_not_send_megadoc);
					}
					if (!isEmpty(megadoc.status_bbbgt) && megadoc.status_bbbgt == 1) {
						$('#status_bbbgt').append(status_sended_megadoc);
					}
					if (!isEmpty(megadoc.status_bbbgt) && megadoc.status_bbbgt == 1 && megadoc.status_contract == 6) {
						$('#update_bbbgt').html('<a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="resend_file_to_megadoc(this)" data-id="' + megadoc.contract_id + '" data-statusapprove="15" data-createtype="1">Cập nhật</a>');
					}
					if (!isEmpty(megadoc.status_bbbgt) && megadoc.status_bbbgt == 2) {
						$('#status_bbbgt').append(status_one_sign_megadoc);
					}
					if (!isEmpty(megadoc.status_bbbgt) && megadoc.status_bbbgt == 3) {
						$('#status_bbbgt').append(status_finish_megadoc);
						$('#download_bbbgt').html('<a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="download_file_to_megadoc(this)" data-id="' + megadoc.contract_id + '" data-searchkey="' + megadoc.searchkey_bbbgt + '" data-codecontract="' + megadoc.code_contract + '" data-createtype="bbbgt">Tải về</a>');
					}
					if (!isEmpty(megadoc.status_bbbgt) && megadoc.status_bbbgt == 7) {
						$('#status_bbbgt').append(status_cancel_megadoc);
					}
					// Check trạng thái văn bản thông báo để sinh ra button tương ứng
					if (megadoc.status_tb == "") {
						$('#status_tb').append(status_not_send_megadoc);
					}
					if (!isEmpty(megadoc.status_tb) && megadoc.status_tb == 1 && megadoc.status_contract == 6) {
						$('#status_tb').append(status_sended_megadoc);
					}
					if (!isEmpty(megadoc.status_tb) && megadoc.status_tb == 2) {
						$('#status_tb').append(status_one_sign_megadoc);
						$('#download_tb').html('<a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="download_file_to_megadoc(this)" data-id="' + megadoc.contract_id + '" data-searchkey="' + megadoc.searchkey_tb + '" data-codecontract="' + megadoc.code_contract + '" data-createtype="tb">Tải về</a>');
					}
					if (!isEmpty(megadoc.status_tb) && megadoc.status_tb == 3) {
						$('#status_tb').append(status_finish_megadoc);
						$('#download_tb').html('<a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="download_file_to_megadoc(this)" data-id="' + megadoc.contract_id + '" data-searchkey="' + megadoc.searchkey_tb + '" data-codecontract="' + megadoc.code_contract + '" data-createtype="tb">Tải về</a>');
					}
					if (!isEmpty(megadoc.status_tb) && megadoc.status_tb == 7) {
						$('#status_tb').append(status_cancel_megadoc);
					}
					// Check trạng thái bbbgs để sinh ra button tương ứng
					if (megadoc.status_bbbgs == "") {
						$('#status_bbbgs').append(status_not_send_megadoc);
					}
					if (!isEmpty(megadoc.status_bbbgs) && megadoc.status_bbbgs == 1 && megadoc.status_contract == 19) {
						$('#status_bbbgs').append(status_sended_megadoc);
					}
					if (!isEmpty(megadoc.status_bbbgs) && megadoc.status_bbbgs == 2) {
						$('#status_bbbgs').append(status_one_sign_megadoc);
					}
					if (!isEmpty(megadoc.status_bbbgs) && megadoc.status_bbbgs == 3) {
						$('#status_bbbgs').append(status_finish_megadoc);
						$('#download_bbbgs').html('<a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="download_file_to_megadoc(this)" data-id="' + megadoc.contract_id + '" data-searchkey="' + megadoc.searchkey_bbbgs + '" data-codecontract="' + megadoc.code_contract + '" data-createtype="bbbgs">Tải về</a>');
					}
					if (!isEmpty(megadoc.status_bbbgs) && megadoc.status_bbbgs == 7) {
						$('#status_bbbgs').append(status_cancel_megadoc);
					}
				});
			},
			error: function (data) {
				console.log(data)
			}
		});
		$("#viewStatusContractMegadoc").modal('show');
	}

</script>

<script>
	var delta = 0;
	$(document).on('click', '*[data-toggle="lightbox"]', function (event) {
		event.preventDefault();
		return $(this).ekkoLightbox({
			onShow: function (elem) {
				var html = '<button type="button" class="rotate btn btn-link" ><i class="fa fa-repeat"></i></button>';
				console.log(html);
				$(elem.currentTarget).find('.modal-header').prepend(html);
				var delta = 0;
			},
			onNavigate: function (direction, itemIndex) {
				var delta = 0;
				if (window.console) {
					return console.log('Navigating ' + direction + '. Current item: ' + itemIndex);
				}
			}
		});
	});
	$('body').on('click', 'button.rotate', function () {
		delta = delta + 90;
		$('.ekko-lightbox-item img').css({
			'-webkit-transform': 'translateX(-50%)translateY(-50%)rotate(' + delta + 'deg)',
			'-moz-transform': 'translateX(-50%)translateY(-50%)rotate(' + delta + 'deg)',
			'transform': 'translateX(-50%)translateY(-50%)rotate(' + delta + 'deg)'
		});
	});
</script>

<script>

	function formatCurrency(number) {
		var n = number.split('').reverse().join("");
		var n2 = n.replace(/\d\d\d(?!$)/g, "$&,");
		return n2.split('').reverse().join('');
	}

	$(".magnifyitem").magnify({
		initMaximized: true
	});
	$('#amount_money_cc').on('input', function (e) {
		$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
	}).on('keypress', function (e) {
		if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
	}).on('paste', function (e) {
		var cb = e.originalEvent.clipboardData || window.clipboardData;
		if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
	});
	$('#approve_submit_gh').on('input', function (e) {
		$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
	}).on('keypress', function (e) {
		if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
	}).on('paste', function (e) {
		var cb = e.originalEvent.clipboardData || window.clipboardData;
		if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
	});


</script>
<script>
	$(document).ready(function () {
		$("#confirm_liquidation_event").on("click", function () {
			$("#confirm_liquidation_event").prop("checked", true);
			$("#disagree").prop("checked", false);
		});
		$("#disagree").on("click", function () {
			$("#confirm_liquidation_event").prop("checked", false);
			$("#disagree").prop("checked", true);
		});
	});

	function follow_contract(thiz) {

		let follow_email = $(thiz).data("email");
		let follow_idStore = $(thiz).data("store");
		let follow_idEmail = $(thiz).data("id");

		$("#title_send_file").text("Bạn có chắc chắn muốn chuyển " + follow_email + " theo dõi hợp đồng này?");
		$('#follow_email').val(follow_email);
		$('#follow_idStore').val(follow_idStore);
		$('#follow_idEmail').val(follow_idEmail);

		$("#follow_contract").modal("show");
	}

	$('#submit_follow_contract').click(function () {

		var follow_email = $('#follow_email').val();
		var follow_idStore = $('#follow_idStore').val();
		var follow_idEmail = $('#follow_idEmail').val();

		let url = window.location.href
		let id = getUrlParameter('id', url);

		var formData = new FormData();
		formData.append('follow_email', follow_email);
		formData.append('follow_idStore', follow_idStore);
		formData.append('follow_idEmail', follow_idEmail);
		formData.append('id', id);

		$("#follow_contract").modal("hide");

		$.ajax({
			url: _url.base_url + 'pawn/update_follow_contract',
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
				console.log(data.status == 200)
				if (data.status == 200) {
					$("#successModal").modal("show");
					$(".msg_success").text('Thành công');
					setTimeout(function () {
						window.location.reload();
					}, 3000);
				} else {
					$("#errorModal").modal("show");
					$(".msg_error").text("Nhân viên không thuộc PGD được cơ cấu");
					setTimeout(function () {
						window.location.reload();
					}, 3000);
				}

			},
			error: function (data) {
				console.log(data)
				$(".theloading").hide();
			}
		});


	});

	function getUrlParameter(name, urlweb) {
		name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
		var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
		var results = regex.exec(urlweb);
		return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
	}

	var isEmpty = function (data) {
		if (typeof (data) === 'object') {
			if (JSON.stringify(data) === '{}' || JSON.stringify(data) === '[]') {
				return true;
			} else if (!data) {
				return true;
			}
			return false;
		} else if (typeof (data) === 'string') {
			if (!data.trim()) {
				return true;
			}
			return false;
		} else if (typeof (data) === 'undefined') {
			return true;
		} else {
			return false;
		}
	}
</script>

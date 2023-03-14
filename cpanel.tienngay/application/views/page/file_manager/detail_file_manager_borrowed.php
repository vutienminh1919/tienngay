<?php
$id_user = $userSession['id'];
;?>
<div class="detail-contract right_col" role="main">

	<div class="page-title" style="min-height: 30px; padding: 0px">
		<div class="title_left" style="width: 100%">
			<h3 class="page-title" style="min-height: 30px"><a href="<?php echo base_url("file_manager/index_borrowed") ?>">MƯỢN TRẢ HỒ SƠ - <?= !empty($borrowed->code_contract_disbursement_text) ? $borrowed->code_contract_disbursement_text : "" ?></a>
				&nbsp;<?php
				if ($borrowed->status == "1") {
					echo '-&nbsp <span class="label label-success" style="font-size: 13px; background-color: #2A3F54; padding: 7px">Mới</span>';
				} elseif ($borrowed->status == "2") {
					echo '-&nbsp <span class="label label-success" style="font-size: 13px; background-color: #f2f2f2; padding: 7px; color: #828282" >Hủy yêu cầu</span>';
				} elseif ($borrowed->status == "3") {
					echo '-&nbsp <span class="label label-success" style="font-size: 13px; background-color: #c6e1ee; padding: 7px; color: #199bdc" >PGD YC mượn HS giải ngân</span>';
				} elseif ($borrowed->status == "4") {
					echo '-&nbsp <span class="label label-success" style="font-size: 13px; background-color: #c6e1ee; padding: 7px; color: #199bdc" >Yêu cầu mượn HS</span>';
				} elseif ($borrowed->status == "5") {
					echo '-&nbsp <span class="label label-success" style="font-size: 13px; background-color: #eaca4a; padding: 7px; color: #ffffff" >QLHS trả về yêu cầu mượn</span>';
				} elseif ($borrowed->status == "6") {
					echo '-&nbsp <span class="label label-success" style="font-size: 13px; background-color: #eaca4a; padding: 7px; color: #ffffff" >Chờ nhận hồ sơ</span>';
				} elseif ($borrowed->status == "7") {
					echo '-&nbsp <span class="label label-success" style="font-size: 13px; background-color: #4fbe87; padding: 7px; color: #ffffff" >Đang mượn hồ sơ</span>';
				} elseif ($borrowed->status == "8") {
					echo '-&nbsp <span class="label label-success" style="font-size: 13px; background-color: #eaca4a; padding: 7px; color: #199bdc" >Chưa nhận đủ HS mượn</span>';
				} elseif ($borrowed->status == "9") {
					echo '-&nbsp <span class="label label-success" style="font-size: 13px; background-color: #4fbe87; padding: 7px; color: #ffffff" >Trả HS mượn về HO</span>';
				} elseif ($borrowed->status == "10") {
					echo '-&nbsp <span class="label label-success" style="font-size: 13px; background-color: #e88df2; padding: 7px; color: #ffffff" >Lưu kho</span>';
				} elseif ($borrowed->status == "11") {
					echo '-&nbsp <span class="label label-success" style="font-size: 13px; background-color: #eaca4a; padding: 7px; color: #ffffff" >Chưa trả đủ HS đã mượn</span>';
				} elseif ($borrowed->status == "12") {
					echo '-&nbsp <span class="label label-success" style="font-size: 13px; background-color: #f3616d; padding: 7px; color: #ffffff" >Quá hạn mượn HS</span>';
				} elseif ($borrowed->status == "13") {
					echo '-&nbsp <span class="label label-success" style="font-size: 13px; background-color: #035927; padding: 7px; color: #ffffff" >Trả hồ sơ cho KH tất toán</span>';
				} elseif ($borrowed->status == "14") {
					echo '-&nbsp <span class="label label-success" style="font-size: 13px; background-color: #7070d7; padding: 7px; color: #ffffff" >QLHS xác nhận KH đã tất toán</span>';
				} elseif ($borrowed->status == "15") {
					echo '-&nbsp <span class="label label-success" style="font-size: 13px; background-color: #7070d7; padding: 7px; color: #ffffff" >Yêu cầu gia hạn mượn hồ sơ</span>';
				} elseif ($borrowed->status == "16") {
					echo '-&nbsp <span class="label label-success" style="font-size: 13px; background-color: #c6e1ee; padding: 7px; color: #199bdc" >Chờ TP QLKV duyệt YC mượn hồ sơ</span>';
				} elseif ($borrowed->status == "17") {
					echo '-&nbsp <span class="label label-success" style="font-size: 13px; background-color: #c6e1ee; padding: 7px; color: #199bdc" >Chờ TP QLKV duyệt YC gia hạn mượn hồ sơ</span>';
				}
				?></h3>
		</div>
	</div>
	<div class="title_right text-left" style="margin-bottom: 20px">
		<?php
		if ((in_array("giao-dich-vien", $groupRoles) || in_array("cua-hang-truong", $groupRoles))) { ?>
			<?php
			if ($borrowed->status == 1) { ?>
					<a href="javascript:void(0)" class="btn btn-info"
					   onclick="gui_yc_len_asm(this)"
					   data-id="<?= !empty($borrowed->_id->{'$oid'}) ? $borrowed->_id->{'$oid'} : ""; ?>"
					   data-mhd="<?= !empty($borrowed->code_contract_disbursement_text) ? $borrowed->code_contract_disbursement_text : ""; ?>"
					>
						Gửi YC lên ASM
					</a>
					<a href="javascript:void(0)" class="btn btn-info"  data-toggle="modal"
					   onclick="sua_yeu_cau_muon_hs('<?= $borrowed->_id->{'$oid'} ?>')">
						Sửa yêu cầu
					</a>

					<a href="javascript:void(0)" class="btn btn-danger"
					   onclick="huy_yc_muon_hs(this)"
					   data-id="<?= !empty($borrowed->_id->{'$oid'}) ? $borrowed->_id->{'$oid'} : ""; ?>"
					   data-mhd="<?= !empty($borrowed->code_contract_disbursement_text) ? $borrowed->code_contract_disbursement_text : ""; ?>"
					>
						Hủy yêu cầu
					</a>
			<?php } ?>
			<?php
			if ($borrowed->status == 5) { ?>
					<a href="javascript:void(0)" class="btn btn-info"
					   onclick="gui_yc_len_asm(this)"
					   data-id="<?= !empty($borrowed->_id->{'$oid'}) ? $borrowed->_id->{'$oid'} : ""; ?>"
					   data-mhd="<?= !empty($borrowed->code_contract_disbursement_text) ? $borrowed->code_contract_disbursement_text : ""; ?>"
					>
						Gửi YC lên ASM
					</a>
					<a href="javascript:void(0)" class="btn btn-info"  data-toggle="modal"
					   onclick="sua_yeu_cau_muon_hs('<?= $borrowed->_id->{'$oid'} ?>')">
						Sửa yêu cầu
					</a>
					<a href="javascript:void(0)" class="btn btn-danger"
					   onclick="huy_yc_muon_hs(this)"
					   data-id="<?= !empty($borrowed->_id->{'$oid'}) ? $borrowed->_id->{'$oid'} : ""; ?>"
					   data-mhd="<?= !empty($borrowed->code_contract_disbursement_text) ? $borrowed->code_contract_disbursement_text : ""; ?>"
					>
						Hủy yêu cầu
					</a>
			<?php } ?>
			<?php
			if ($borrowed->status == 6) { ?>
					<a href="javascript:void(0)" class="btn btn-info"
					   onclick="user_da_nhan_hs(this)"
					   data-id="<?= !empty($borrowed->_id->{'$oid'}) ? $borrowed->_id->{'$oid'} : ""; ?>"
					   data-mhd="<?= !empty($borrowed->code_contract_disbursement_text) ? $borrowed->code_contract_disbursement_text : ""; ?>"
					>
						Đã nhận hồ sơ
					</a>
					<a href="javascript:void(0)" class="btn btn-info"  data-toggle="modal"
					   onclick="chua_nhan_du_ho_so('<?= $borrowed->_id->{'$oid'} ?>')">
						Chưa nhận đủ hồ sơ mượn
					</a>
			<?php } ?>
			<?php
			if ($borrowed->status == 8) { ?>
					<a href="javascript:void(0)" class="btn btn-info"
					   onclick="user_da_nhan_hs(this)"
					   data-id="<?= !empty($borrowed->_id->{'$oid'}) ? $borrowed->_id->{'$oid'} : ""; ?>"
					   data-mhd="<?= !empty($borrowed->code_contract_disbursement_text) ? $borrowed->code_contract_disbursement_text : ""; ?>"
					>
						Đã nhận hồ sơ
					</a>
			<?php } ?>
			<?php
			if ($borrowed->status == 7 || $borrowed->status == 12) { ?>
					<a href="javascript:void(0)" class="btn btn-info"
					   onclick="tra_hs_da_muon(this)"
					   data-id="<?= !empty($borrowed->_id->{'$oid'}) ? $borrowed->_id->{'$oid'} : ""; ?>"
					   data-mhd="<?= !empty($borrowed->code_contract_disbursement_text) ? $borrowed->code_contract_disbursement_text : ""; ?>"
					>
						Trả HS đã mượn
					</a>
				<?php if ($borrowed->status_hd == 19) : ;?>
					<a href="javascript:void(0)" class="btn btn-info"
					   onclick="tra_hs_cho_kh_tat_toan(this)"
					   data-id="<?= !empty($borrowed->_id->{'$oid'}) ? $borrowed->_id->{'$oid'} : ""; ?>"
					   data-mhd="<?= !empty($borrowed->code_contract_disbursement_text) ? $borrowed->code_contract_disbursement_text : ""; ?>"
					>
						Trả HS cho KH tất toán
					</a>
				<?php endif ;?>
			<?php } ?>
		<?php } ?>

		<?php
		if (in_array("quan-ly-khu-vuc", $groupRoles)) { ?>
			<?php
			if ($borrowed->status == 3) { ?>
					<a href="javascript:void(0)" class="btn btn-info"
					   onclick="gui_yc_len_qlhs(this)"
					   data-id="<?= !empty($borrowed->_id->{'$oid'}) ? $borrowed->_id->{'$oid'} : ""; ?>"
					   data-mhd="<?= !empty($borrowed->code_contract_disbursement_text) ? $borrowed->code_contract_disbursement_text : ""; ?>"
					>
						Gửi YC lên QLHS
					</a>
					<a href="javascript:void(0)" class="btn btn-danger"
					   onclick="huy_yc_muon_hs(this)"
					   data-id="<?= !empty($borrowed->_id->{'$oid'}) ? $borrowed->_id->{'$oid'} : ""; ?>"
					   data-mhd="<?= !empty($borrowed->code_contract_disbursement_text) ? $borrowed->code_contract_disbursement_text : ""; ?>"
					>
						Hủy yêu cầu
					</a>
			<?php } ?>
		<?php } ?>

		<?php
		if (in_array("an-ninh-dieu-tra", $groupRoles) || in_array("kiem-soat-noi-bo", $groupRoles) || in_array("thu-hoi-no", $groupRoles)) { ?>
			<?php
			if ($borrowed->status == 1) { ?>
					<a href="javascript:void(0)" class="btn btn-info"  data-toggle="modal"
					   onclick="sua_yeu_cau_muon_hs('<?= $borrowed->_id->{'$oid'} ?>')">
						Sửa yêu cầu
					</a>

				<!--Nếu là nhân sự phòng quản lý khoản vay thì phải gửi yêu cầu tới trưởng phòng để duyệt-->
				<?php if (in_array($id_user, $role_nv_qlkv)) : ;?>
						<a href="javascript:void(0)" class="btn btn-info"
						   onclick="gui_yc_len_tp_qlkv(this)"
						   data-id="<?= !empty($borrowed->_id->{'$oid'}) ? $borrowed->_id->{'$oid'} : ""; ?>"
						   data-mhd="<?= !empty($borrowed->code_contract_disbursement_text) ? $borrowed->code_contract_disbursement_text : ""; ?>">
							Gửi trưởng phòng duyệt
						</a>
				<?php else: ;?>
						<a href="javascript:void(0)" class="btn btn-info"
						   onclick="gui_yc_len_qlhs(this)"
						   data-id="<?= !empty($borrowed->_id->{'$oid'}) ? $borrowed->_id->{'$oid'} : ""; ?>"
						   data-mhd="<?= !empty($borrowed->code_contract_disbursement_text) ? $borrowed->code_contract_disbursement_text : ""; ?>"
						>
							Gửi YC lên QLHS
						</a>
				<?php endif;?>
					<a href="javascript:void(0)" class="btn btn-danger"
					   onclick="huy_yc_muon_hs(this)"
					   data-id="<?= !empty($borrowed->_id->{'$oid'}) ? $borrowed->_id->{'$oid'} : ""; ?>"
					   data-mhd="<?= !empty($borrowed->code_contract_disbursement_text) ? $borrowed->code_contract_disbursement_text : ""; ?>"
					>
						Hủy yêu cầu
					</a>
			<?php } ?>

			<?php
			if ($borrowed->status == 5) { ?>
					<a href="javascript:void(0)" class="btn btn-info"
					   onclick="gui_yc_len_qlhs(this)"
					   data-id="<?= !empty($borrowed->_id->{'$oid'}) ? $borrowed->_id->{'$oid'} : ""; ?>"
					   data-mhd="<?= !empty($borrowed->code_contract_disbursement_text) ? $borrowed->code_contract_disbursement_text : ""; ?>"
					>
						Gửi YC lên QLHS
					</a>
					<a href="javascript:void(0)" class="btn btn-info"  data-toggle="modal"
					   onclick="sua_yeu_cau_muon_hs('<?= $borrowed->_id->{'$oid'} ?>')">
						Sửa yêu cầu
					</a>
			<?php } ?>

			<?php
			if ($borrowed->status == 6) { ?>
					<a href="javascript:void(0)" class="btn btn-info"
					   onclick="user_da_nhan_hs(this)"
					   data-id="<?= !empty($borrowed->_id->{'$oid'}) ? $borrowed->_id->{'$oid'} : ""; ?>"
					   data-mhd="<?= !empty($borrowed->code_contract_disbursement_text) ? $borrowed->code_contract_disbursement_text : ""; ?>"
					>
						Đã nhận hồ sơ
					</a>
					<a href="javascript:void(0)" class="btn btn-info"  data-toggle="modal"
					   onclick="chua_nhan_du_ho_so('<?= $borrowed->_id->{'$oid'} ?>')">
						Chưa nhận đủ hồ sơ mượn
					</a>
			<?php } ?>
			<?php
			if ($borrowed->status == 8) { ?>
					<a href="javascript:void(0)" class="btn btn-info"
					   onclick="user_da_nhan_hs(this)"
					   data-id="<?= !empty($borrowed->_id->{'$oid'}) ? $borrowed->_id->{'$oid'} : ""; ?>"
					   data-mhd="<?= !empty($borrowed->code_contract_disbursement_text) ? $borrowed->code_contract_disbursement_text : ""; ?>"
					>
						Đã nhận hồ sơ
					</a>
			<?php } ?>
			<?php
			if ($borrowed->status == 7 || $borrowed->status == 12) { ?>
					<a href="javascript:void(0)" class="btn btn-info"
					   onclick="tra_hs_da_muon(this)"
					   data-id="<?= !empty($borrowed->_id->{'$oid'}) ? $borrowed->_id->{'$oid'} : ""; ?>"
					   data-mhd="<?= !empty($borrowed->code_contract_disbursement_text) ? $borrowed->code_contract_disbursement_text : ""; ?>"
					>
						Trả HS đã mượn
					</a>
				<?php if ($borrowed->status_hd == 19) : ;?>
					<a href="javascript:void(0)" class="btn btn-info"
					   onclick="tra_hs_cho_kh_tat_toan(this)"
					   data-id="<?= !empty($borrowed->_id->{'$oid'}) ? $borrowed->_id->{'$oid'} : ""; ?>"
					   data-mhd="<?= !empty($borrowed->code_contract_disbursement_text) ? $borrowed->code_contract_disbursement_text : ""; ?>"
					>
						Trả HS cho KH tất toán
					</a>
				<?php endif;?>
			<?php } ?>
			<?php
			if ($borrowed->status == 12) { ?>
				<?php if (in_array($id_user, $role_nv_qlkv)) : ;?>
						<a href="javascript:void(0)" class="btn btn-info"
						   onclick="send_request_approve_extend(this)"
						   data-id="<?= !empty($borrowed->_id->{'$oid'}) ? $borrowed->_id->{'$oid'} : ""; ?>"
						   data-mhd="<?= !empty($borrowed->code_contract_disbursement_text) ? $borrowed->code_contract_disbursement_text : ""; ?>">
							Gửi YC duyệt gia hạn mượn hồ sơ
						</a>
				<?php else: ?>
						<a href="javascript:void(0)" class="btn btn-info"
						   onclick="gia_han_thoi_gian_muon(this)"
						   data-id="<?= !empty($borrowed->_id->{'$oid'}) ? $borrowed->_id->{'$oid'} : ""; ?>"
						   data-mhd="<?= !empty($borrowed->code_contract_disbursement_text) ? $borrowed->code_contract_disbursement_text : ""; ?>">
							Gia hạn thời gian mượn
						</a>
				<?php endif;?>

			<?php } ?>
		<?php } ?>

		<?php if (in_array('tbp-thu-hoi-no', $groupRoles)) : ?>
			<?php if ($borrowed->status == 16) { ?>
					<a href="javascript:void(0)" class="btn btn-info"
					   onclick="tp_qlkv_duyet_yeu_cau(this)"
					   data-id="<?= !empty($borrowed->_id->{'$oid'}) ? $borrowed->_id->{'$oid'} : ""; ?>"
					   data-mhd="<?= !empty($borrowed->code_contract_disbursement_text) ? $borrowed->code_contract_disbursement_text : ""; ?>"
					   data-note="<?= !empty($borrowed->ghichu) ? $borrowed->ghichu : ""; ?>">
						Gửi yêu cầu lên quản lý hồ sơ
					</a>
					<a href="javascript:void(0)" class="btn btn-danger"
					   onclick="huy_yc_muon_hs(this)"
					   data-id="<?= !empty($borrowed->_id->{'$oid'}) ? $borrowed->_id->{'$oid'} : ""; ?>"
					   data-mhd="<?= !empty($borrowed->code_contract_disbursement_text) ? $borrowed->code_contract_disbursement_text : ""; ?>">
						Hủy yêu cầu
					</a>
			<?php } ?>

			<?php if ($borrowed->status == 17) { ?>
					<a href="javascript:void(0)" class="btn btn-info"
					   onclick="tp_qlkv_duyet_yeu_cau_gh_muon(this)"
					   data-id="<?= !empty($borrowed->_id->{'$oid'}) ? $borrowed->_id->{'$oid'} : ""; ?>"
					   data-mhd="<?= !empty($borrowed->code_contract_disbursement_text) ? $borrowed->code_contract_disbursement_text : ""; ?>"
					   data-note="<?= !empty($borrowed->ghichu) ? $borrowed->ghichu : ""; ?>"
					   data-extend="<?= !empty($borrowed->time_extend_suggest) ? date('d-m-Y', $borrowed->time_extend_suggest) : ""; ?>">
						Gửi yêu cầu gia hạn mượn lên QLHS
					</a>
			<?php } ?>
		<?php endif;?>

		<?php
		if (in_array("quan-ly-ho-so", $groupRoles)) { ?>
			<?php
			if ($borrowed->status == 4) { ?>
					<a href="javascript:void(0)" class="btn btn-info"  data-toggle="modal"
					   onclick="xac_nhan_yeu_cau_qlhs('<?= $borrowed->_id->{'$oid'} ?>')">
						Xác nhận yêu cầu
					</a>
					<a href="javascript:void(0)" class="btn btn-info"  data-toggle="modal"
					   onclick="tra_yc_muon_qlhs('<?= $borrowed->_id->{'$oid'} ?>')">
						Trả yêu cầu
					</a>
					<a href="javascript:void(0)" class="btn btn-danger"
					   onclick="huy_yc_muon_hs(this)"
					   data-id="<?= !empty($borrowed->_id->{'$oid'}) ? $borrowed->_id->{'$oid'} : ""; ?>"
					   data-mhd="<?= !empty($borrowed->code_contract_disbursement_text) ? $borrowed->code_contract_disbursement_text : ""; ?>"
					>
						Hủy yêu cầu
					</a>
			<?php } ?>
			<?php
			if ($borrowed->status == 9 || $borrowed->status == 12) { ?>
					<a href="javascript:void(0)" class="btn btn-info"
					   onclick="luu_kho(this)"
					   data-id="<?= !empty($borrowed->_id->{'$oid'}) ? $borrowed->_id->{'$oid'} : ""; ?>"
					   data-mhd="<?= !empty($borrowed->code_contract_disbursement_text) ? $borrowed->code_contract_disbursement_text : ""; ?>"
					>
						Hoàn tất lưu kho
					</a>
					<a href="javascript:void(0)" class="btn btn-info"  data-toggle="modal"
					   onclick="chua_tra_du_hs('<?= $borrowed->_id->{'$oid'} ?>')">
						Chưa trả đủ hs đã mượn
					</a>
			<?php } ?>
			<?php
			if ($borrowed->status == 11) { ?>
					<a href="javascript:void(0)" class="btn btn-info"
					   onclick="luu_kho(this)"
					   data-id="<?= !empty($borrowed->_id->{'$oid'}) ? $borrowed->_id->{'$oid'} : ""; ?>"
					   data-mhd="<?= !empty($borrowed->code_contract_disbursement_text) ? $borrowed->code_contract_disbursement_text : ""; ?>"
					>
						Hoàn tất lưu kho
					</a>
			<?php } ?>
			<?php
			if ($borrowed->status == 13) { ?>
					<a href="javascript:void(0)" class="btn btn-info"
					   onclick="qlhs_xac_nhan_kh_da_tat_toan(this)"
					   data-id="<?= !empty($borrowed->_id->{'$oid'}) ? $borrowed->_id->{'$oid'} : ""; ?>"
					   data-mhd="<?= !empty($borrowed->code_contract_disbursement_text) ? $borrowed->code_contract_disbursement_text : ""; ?>"
					>
						QLHS xác nhận KH đã tất toán
					</a>
			<?php } ?>
			<?php
			if ($borrowed->status == 15) { ?>
					<a href="javascript:void(0)" class="btn btn-info"  data-toggle="modal"
					   onclick="qlhs_xac_nhan_gia_han_muon_hs('<?= $borrowed->_id->{'$oid'} ?>')">
						QLHS xác nhận gia hạn mượn HS
					</a>
			<?php } ?>
		<?php } ?>
	</div>

	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">

					<div id="myTabContent" class="tab-content col-md-12 col-xs-12 ">
						<div role="tabpanel" class="tab-pane fade active in col-md-12 col-xs-12 "
							 id="tab_content1" aria-labelledby="tab_content1">
							<div class="col-md-12 col-xs-12">
								<div class="col-md-12 col-xs-12">
									<h3 class="box__title">THÔNG TIN HỒ SƠ MƯỢN</h3>
								</div>
							</div>
							<br>
							<div class="col-md-12 col-xs-12">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<h4 class="box__title">DANH SÁCH HỒ SƠ MƯỢN</h4>
									<?php if (!empty($borrowed->file)) { ?>
										<?php foreach ($borrowed->file as $key1 => $item) { ?>
											<?php if ($key1 == 0) { ?>
												<div class="col-md-12 col-xs-12">
													<div class="box__detail">
														<p class="box--p">- <?php echo $item ?></p>
													</div>
												</div>
											<?php } ?>
											<?php if ($key1 > 0) { ?>
												<div class="col-md-12 col-xs-12">
													<div class="box__detail">
														<p class="box--p">- <?php echo $item ?></p>
													</div>
												</div>
											<?php } ?>

										<?php } ?>
										<?php if (!empty($borrowed->giay_to_khac)) { ?>
											<div class="col-md-12 col-xs-12">
												<div class="box__detail">
													<p class="box--p">- <?php echo $borrowed->giay_to_khac ?></p>
												</div>
											</div>
										<?php } ?>
									<?php } else { ?>
										<?php if (!empty($borrowed->giay_to_khac)) { ?>
											<div class="col-md-12 col-xs-12">
												<div class="box__detail">
													<p class="box--p">- <?php echo $borrowed->giay_to_khac ?></p>
												</div>
											</div>
										<?php } ?>
									<?php } ?>
								</div>
							</div>
							<div class="col-md-12 col-xs-12 table-responsive">
								<div class="col-md-12 col-xs-12">
									<h4 class="box__title">LÝ DO MƯỢN</h4>
									<div class="col-md-12 col-xs-12">
										<?php if (!empty($borrowed->lydomuon)) { ?>
											<div class="col-md-12 col-xs-12">
												<div class="box__detail">
													<p class="box--p">- <?php echo $borrowed->lydomuon ?></p>
												</div>
											</div>
										<?php } ?>

									</div>
								</div>
							</div>
							<div class="col-md-12 col-xs-12 table-responsive">
								<div class="col-md-12 col-xs-12">
									<h4 class="box__title">THÔNG TIN HỒ SƠ</h4>
									<div class="col-md-12 col-xs-12">
										<?php if (!empty($borrowed->fileApprove_img)): ?>
											<div id="SomeThing" class="simpleUploader">
												<div class="uploads " id="uploads_identify">
													<?php
													$key_identify = 0;
													foreach ((array)$borrowed->fileApprove_img as $key => $value) {
														$key_identify++;
														if (empty($value)) continue; ?>
														<div class="block">
															<!--//Image-->
															<?php if (!empty($value->file_type) && ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg')) { ?>
																<span
																	class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
																<a href="<?= $value->path ?>"
																   class="magnifyitem" data-magnify="gallery"
																   data-src=""
																   data-group="thegallery"
																   data-caption="Hồ sơ nhân thân <?php echo $key_identify ?>">
																	<img class="w-100" src="<?= $value->path ?>" alt="">
																</a>

															<?php } ?>
															<!--Audio-->
															<?php if (!empty($value->file_type) && ($value->file_type == 'audio/mp3' || $value->file_type == 'audio/mpeg')) { ?>
																<span
																	class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
																<a href="<?= $value->path ?>" target="_blank"><span
																		style="z-index: 9"><?= $value->file_name ?></span>
																	<img
																		style="width: 50%;transform: translateX(50%)translateY(-50%);"
																		src="https://image.flaticon.com/icons/png/512/81/81281.png"
																		alt="">
																</a>

															<?php } ?>
															<!--Video-->
															<?php if (!empty($value->file_type) && ($value->file_type == 'video/mp4')) { ?>
																<span
																	class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path)); ?></span>
																<a href="<?= $value->path ?>" target="_blank"><span
																		style="z-index: 9"><?= $value->file_name ?></span>
																	<img
																		style="width: 50%;transform: translateX(50%)translateY(-50%);"
																		src="<?php echo base_url(); ?>assets/imgs/mp4.jpg"
																		alt="">
																</a>

															<?php } ?>
														</div>
													<?php } ?>
												</div>
											</div>
										<?php endif; ?>

									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
		<br><br><br>

		<div class="col-md-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<div role="tabpanel" class="tab-pane col-md-12 col-xs-12 nopadding" id="tab_content3"
						 aria-labelledby="tab_content3">
						<div class="col-md-12 col-xs-12">
							<h4 class="box__title">LỊCH SỬ</h4>
						</div>
						<div class="col-md-12 col-xs-12 tab-content3">

							<ul class="list-unstyled timeline">
								<?php if (!empty($borrowed_log)): ?>
									<?php foreach ($borrowed_log as $item): ?>
										<li>
											<div class="block">
												<hr>
												<div class="tags">
													<a href="" class="tag">
														<span><?= !empty($item->created_at) ? date("d/m/y", $item->created_at) : "" ?></span>
													</a>
												</div>
												<div class="block_content col-md-12 col-xs-12">
													<div class="col-md-1 col-xs-12">
														<img
															src="<?php echo base_url(); ?>assets/imgs/icon/user-border.svg"
															alt="user approve">
													</div>
													<div class="col-md-10 col-xs-12">
														<p>
															<i
																style="color: #828282"><?= !empty($item->created_at) ? date("H:i:s", $item->created_at) : "" ?></i>
														</p>
														<p>
															<i><span
																	style="color: #828282">by: </span> <?= !empty($item->created_by) ? $item->created_by : "" ?>
															</i>
														</p>
														<p>
															<?= !empty($item->borrowed->ghichu) ? $item->borrowed->ghichu : "" ?>
															<?= !empty($item->new->ghichu) ? $item->new->ghichu : "" ?>
															<?= !empty($item->new->ghichu_qlhs) ? $item->new->ghichu_qlhs : "" ?>
														</p>


														<?php if (!empty($item->new->fileApprove_img)) { ?>
															<div class="row">
																<?php foreach ((array)$item->new->fileApprove_img as $key => $value) { ?>

																	<?php if ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg') { ?>
																		<div class="col-xs-12 col-md-6 col-lg-3"
																			 style="width: auto">
																			<a href="<?= $value->path ?>"
																			   class="magnify_item"
																			   data-magnify="gallery"
																			   data-src="" data-group="thegallery"
																			   data-gallery="uploads_agree"
																			   data-max-width="992" data-type="image"
																			   data-title="Hồ sơ bổ sung/trả về">
																				<img style="height: 75px"
																					 name="img_contract"
																					 data-key="<?= $key ?>"
																					 data-fileName="<?= $value->file_name ?>"
																					 data-fileType="<?= $value->file_type ?>"
																					 data-type='agree'
																					 src="<?= $value->path ?>" alt="">
																			</a>
																		</div>

																	<?php }
																} ?>
															</div>
														<?php } ?>
														<?php if (!empty($item->new->fileReturn_img)) { ?>
															<div class="row">
																<?php foreach ((array)$item->new->fileReturn_img as $key => $value) { ?>

																	<?php if ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg') { ?>
																		<div class="col-xs-12 col-md-6 col-lg-3"
																			 style="width: auto">
																			<a href="<?= $value->path ?>"
																			   class="magnify_item"
																			   data-magnify="gallery"
																			   data-src="" data-group="thegallery"
																			   data-gallery="uploads_agree"
																			   data-max-width="992" data-type="image"
																			   data-title="Hồ sơ bổ sung/trả về">
																				<img style="height: 75px"
																					 name="img_contract"
																					 data-key="<?= $key ?>"
																					 data-fileName="<?= $value->file_name ?>"
																					 data-fileType="<?= $value->file_type ?>"
																					 data-type='agree'
																					 src="<?= $value->path ?>" alt="">
																			</a>
																		</div>

																	<?php }
																} ?>
															</div>
														<?php } ?>
														<?php if (!empty($item->new->fileReturn_qlhs_img)) { ?>
															<div class="row">
																<?php foreach ((array)$item->new->fileReturn_qlhs_img as $key => $value) { ?>

																	<?php if ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg') { ?>
																		<div class="col-xs-12 col-md-6 col-lg-3"
																			 style="width: auto">
																			<a href="<?= $value->path ?>"
																			   class="magnify_item"
																			   data-magnify="gallery"
																			   data-src="" data-group="thegallery"
																			   data-gallery="uploads_agree"
																			   data-max-width="992" data-type="image"
																			   data-title="Hồ sơ bổ sung/trả về">
																				<img style="height: 75px"
																					 name="img_contract"
																					 data-key="<?= $key ?>"
																					 data-fileName="<?= $value->file_name ?>"
																					 data-fileType="<?= $value->file_type ?>"
																					 data-type='agree'
																					 src="<?= $value->path ?>" alt="">
																			</a>
																		</div>

																	<?php }
																} ?>
															</div>
														<?php } ?>
														<?php if (!empty($item->new->file_img_approve)) { ?>
															<div class="row">
																<?php foreach ((array)$item->new->file_img_approve as $key => $value) { ?>

																	<?php if ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg') { ?>
																		<div class="col-xs-12 col-md-6 col-lg-3"
																			 style="width: auto">
																			<a href="<?= $value->path ?>"
																			   class="magnify_item"
																			   data-magnify="gallery"
																			   data-src="" data-group="thegallery"
																			   data-gallery="uploads_agree"
																			   data-max-width="992" data-type="image"
																			   data-title="Hồ sơ bổ sung/trả về">
																				<img style="height: 75px"
																					 name="img_contract"
																					 data-key="<?= $key ?>"
																					 data-fileName="<?= $value->file_name ?>"
																					 data-fileType="<?= $value->file_type ?>"
																					 data-type='agree'
																					 src="<?= $value->path ?>" alt="">
																			</a>
																		</div>

																	<?php }
																} ?>
															</div>
														<?php } ?>
														<br>
														<p>
															<?php if (!empty($item->action)) {
																$old_status = file_manager_borrowed_status($item->old->status);
																$new_status = file_manager_borrowed_status($item->new->status);
																$old_status = is_array($old_status) ? '' : $old_status;
																$new_status = is_array($new_status) ? '' : ' => ' . $new_status;
																$status_detail = $old_status . $new_status;
															}
															?>
															<span class="work__status"
																  style="background-color: #5a738e; padding: 6px; color: white">
																	<?= ($status_detail != "") ? $status_detail : "Mới" ?>
																</span>
														</p>
													</div>
												</div>
											</div>
										</li>
									<?php endforeach; ?>
								<?php endif; ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--Modal-->

<script src="<?php echo base_url("assets/") ?>js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets/") ?>js/numeral.min.js"></script>
<script src="<?php echo base_url("assets/") ?>js/File_manager/borrowed.js?v=20230210"></script>


<div id='toTop'>
	<i class="fa fa-arrow-circle-up"></i>
</div>
<script>
	<!--	backto top-->
	$(window).scroll(function () {
		if ($(this).scrollTop()) {
			$('#toTop').fadeIn();
		} else {
			$('#toTop').fadeOut();
		}
	});

	$("#toTop").click(function () {
		$("html, body").animate({scrollTop: 0}, 500);
	});
</script>
<style>
	ul.timeline li {
		border-bottom: 1px solid #ffffff;
	}

	.timeline .block {
		border-left: 3px solid #5a738e;
	}

	hr {
		border-top: 1px solid #5a738e;
	}
</style>


<!--Modal-->
<div id="addnewModal_muonhoso" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Yêu cầu mượn hồ sơ</h3>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none"
				 id="div_errorCreate">
				<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
				<span class='div_errorCreate'></span>
			</div>
			<div class="modal-body">
				<div class="form-group row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						Mã hợp đồng
						<span class="text-danger">*</span> :
					</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<select class="form-control" id="code_contract_disbursement"
								name="code_contract_disbursement[]"
								multiple="multiple">
							<?php if (!empty($code_contract_disbursement)) {
								foreach ($code_contract_disbursement as $key => $obj) { ?>
									<option class="form-control"
											value="<?= $key ?>"><?= $obj ?></option>
								<?php }
							} ?>
						</select>
						<input id="code_contract_disbursement_value" style="display: none">
						<input id="code_contract_disbursement_text" style="display: none">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						Phòng ban
						<span class="text-danger">*</span> :
					</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<select class="form-control" id="groupRoles_store" name="groupRoles_store"
								data-placeholder="">
							<?php
							if (!empty($groupRoles_store)) {
								foreach ($groupRoles_store as $key => $role) {
									if ($role->status == "deactive") {
										continue;
									}
									?>
									<?php if ($role->name == "Cửa hàng trưởng" || $role->name == "Thu hồi nợ" || $role->name == "Kiểm soát nội bộ" ||  $role->name == "An ninh điều tra"): ?>

										<option
											value="<?= !empty($role->name) ? $role->name : ""; ?>"><?= !empty($role->name) ? $role->name : ""; ?></option>
									<?php endif; ?>
								<?php }
							} ?>
						</select>
					</div>
				</div>


				<div class="form-group">
					<div class="row">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Danh sách hồ sơ <span
								class="text-danger">*</span> :</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="checkbox m-0">
								<label>
									<input type="checkbox" value="" id="selectAll_file" name="all_file"> Tất cả
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Thỏa thuận 3 bên" name="file[]"
										   class="fileCheckBox" id="file6_1">
									Thỏa thuận 3 bên
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Văn bản bàn giao tài sản" name="file[]"
										   class="fileCheckBox" id="file6_2"> Văn bản bàn giao tài sản
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Thông báo" name="file[]" class="fileCheckBox" id="file6_3">
									Thông
									báo
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Đăng ký xe/Cà vẹt" name="file[]"
										   class="fileCheckBox" id="file6_4">
									Đăng ký xe/Cà vẹt
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Hợp đồng mua bán" name="file[]"
										   class="fileCheckBox" id="file6_5">
									Hợp đồng mua bán
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Đăng kiểm" name="file[]" class="fileCheckBox" id="file6_6">
									Đăng
									kiểm
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Giấy cam kết" name="file[]" class="fileCheckBox" id="file6_7">
									Giấy
									cam kết
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Ủy quyền" name="file[]" class="fileCheckBox" id="file6_8"> Ủy
									quyền
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Chìa khóa" name="file[]" class="fileCheckBox" id="file6_9">
									Chìa
									khóa
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Sổ đỏ" name="file[]" class="fileCheckBox" id="file6_10"> Sổ đỏ
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Giấy tờ khác:</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="giay_to_khac">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Lý do mượn: <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="lydomuon">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Thời gian mượn: <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="" class="form-control" placeholder="dd/mm/yyyy" id="borrowed_start">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Thời gian trả: <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="" class="form-control" placeholder="dd/mm/yyyy" id="borrowed_end">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea type="text" class="form-control" id="ghichu"></textarea>
					</div>
				</div>


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary" id="submit_borrowed">Xác nhận</button>
			</div>
		</div>
	</div>
</div>


<div id="editModal_muonhoso" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Sửa yêu cầu</h3>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none"
				 id="div_errorCreate_2">
				<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
				<span class='div_errorCreate'></span>
			</div>
			<input type="hidden" id="fileReturn_id" value="" name="fileReturn_id">
			<div class="modal-body">
				<div class="form-group row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						Mã hợp đồng
						<span class="text-danger">*</span> :
					</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<select class="form-control" id="code_contract_disbursement_1"
								name="code_contract_disbursement_1[]"
								multiple="multiple" disabled>
							<?php if (!empty($code_contract_disbursement)) {
								foreach ($code_contract_disbursement as $key => $obj) { ?>
									<option class="form-control"
											value="<?= $key ?>"><?= $obj ?></option>
								<?php }
							} ?>
						</select>
						<input id="code_contract_disbursement_value_1" style="display: none">
						<input id="code_contract_disbursement_text_1" style="display: none">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						Phòng ban
						<span class="text-danger">*</span> :
					</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<select class="form-control" id="groupRoles_store_1" name="groupRoles_store_1"
								data-placeholder="" disabled>
							<?php
							if (!empty($groupRoles_store)) {
								foreach ($groupRoles_store as $key => $role) {
									if ($role->status == "deactive") {
										continue;
									}
									?>
									<?php if ($role->name == "Cửa hàng trưởng" || $role->name == "Thu hồi nợ" || $role->name == "Kiểm soát nội bộ" ||  $role->name == "An ninh điều tra"): ?>

										<option
											value="<?= !empty($role->name) ? $role->name : ""; ?>"><?= !empty($role->name) ? $role->name : ""; ?></option>
									<?php endif; ?>
								<?php }
							} ?>
						</select>
					</div>
				</div>


				<div class="form-group">
					<div class="row">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Danh sách hồ sơ <span
								class="text-danger">*</span> :</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="checkbox m-0">
								<label>
									<input type="checkbox" value="" id="selectAll_file_1" name="all_file_1"> Tất cả
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Thỏa thuận 3 bên" name="file_1[]"
										   class="fileCheckBox_1" id="file_1">
									Thỏa thuận 3 bên
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Văn bản bàn giao tài sản" name="file_1[]"
										   class="fileCheckBox_1" id="file_2"> Văn bản bàn giao tài sản
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Thông báo" name="file_1[]" class="fileCheckBox_1"
										   id="file_3"> Thông
									báo
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Đăng ký xe/Cà vẹt" name="file_1[]"
										   class="fileCheckBox_1" id="file_4">
									Đăng ký xe/Cà vẹt
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Hợp đồng mua bán" name="file_1[]"
										   class="fileCheckBox_1" id="file_5">
									Hợp đồng mua bán
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Đăng kiểm" name="file_1[]" class="fileCheckBox_1"
										   id="file_6"> Đăng
									kiểm
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Giấy cam kết" name="file_1[]"
										   class="fileCheckBox_1"
										   id="file_7">
									Giấy
									cam kết
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Ủy quyền" name="file_1[]" class="fileCheckBox_1"
										   id="file_8"> Ủy
									quyền
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Chìa khóa" name="file_1[]" class="fileCheckBox_1"
										   id="file_9"> Chìa
									khóa
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Sổ đỏ" name="file_1[]" class="fileCheckBox_1"
										   id="file_10"> Sổ đỏ
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Giấy tờ khác:</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="giay_to_khac_1" name="giay_to_khac_1">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Lý do mượn:  <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="lydomuon_1" name="lydomuon_1">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Thời gian mượn: <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="" class="form-control" placeholder="dd/mm/yyyy" id="borrowed_start_1" name="borrowed_start_1">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Thời gian trả: <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="" class="form-control" placeholder="dd/mm/yyyy" id="borrowed_end_1" name="borrowed_end_1">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea type="text" class="form-control" id="ghichu_1" name="ghichu_1"></textarea>
					</div>
				</div>


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary" id="submit_edit_borrowed">Xác nhận</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="cancel_borrowed" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_cancel_borrowed"></h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" id="fileReturn_id">
						<div style="text-align: center">
							<button type="button" id="borrowed_cancel" class="btn btn-info">Xác nhận</button>
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

<div class="modal fade" id="asm_borrowed" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_asm_borrowed"></h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" id="fileReturn_id">
						<div style="text-align: center">
							<button type="button" id="borrowed_asm_borrowed" class="btn btn-info">Xác nhận</button>
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

<div class="modal fade" id="qlhs_borrowed" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_qlhs_borrowed"></h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" id="fileReturn_id">

						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<textarea type="text" class="form-control" id="ghichu_approve_1"
										  name="ghichu_approve_1"></textarea>
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Upload ảnh </label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="uploads_fileReturn_11"></div>
									<label for="uploadinput_11">
										<div class="block uploader">
											<span>+</span>
										</div>
									</label>
									<input id="uploadinput_11" type="file" name="file"
										   data-contain="uploads_fileReturn_11" data-title="Hồ sơ nhân thân" multiple
										   data-type="fileReturn" class="focus">
								</div>
							</div>
						</div>

						<div style="text-align: right">
							<button type="button" id="borrowed_qlhs_borrowed" class="btn btn-info">Xác nhận</button>
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


<div id="qlhs_trahoso" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Yêu cầu trả</h3>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none"
				 id="div_errorCreate_3">
				<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
				<span class='div_errorCreate'></span>
			</div>
			<input type="hidden" id="fileReturn_id" value="" name="fileReturn_id">
			<div class="modal-body">

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Ghi chú <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea type="text" class="form-control" id="ghichu_3"></textarea>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary" id="submit_qlhs_trahoso">Xác nhận</button>
			</div>
		</div>
	</div>
</div>


<div id="approve_borrowed" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Xác nhận cho mượn hồ sơ</h3>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none"
				 id="div_errorCreate_4">
				<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
				<span class='div_errorCreate'></span>
			</div>
			<input type="hidden" id="fileReturn_id" value="" name="fileReturn_id">
			<div class="modal-body">

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea type="text" class="form-control" id="ghichu_4"></textarea>
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Upload ảnh <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div id="SomeThing" class="simpleUploader">
							<div class="uploads" id="uploads_borrowed"></div>
							<label for="uploadinput_1">
								<div class="block uploader">
									<span>+</span>
								</div>
							</label>
							<input id="uploadinput_1" type="file" name="file"
								   data-contain="uploads_borrowed" data-title="Hồ sơ nhân thân" multiple
								   data-type="fileReturn" class="focus">
						</div>
					</div>
				</div>


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary" id="submit_approve_borrowed">Xác nhận</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="danhanhoso" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_danhanhoso"></h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" id="fileReturn_id">

						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<textarea type="text" class="form-control" id="ghichu_approve_2"
										  name="ghichu_approve_2"></textarea>
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Upload ảnh </label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="uploads_fileReturn_12"></div>
									<label for="uploadinput_12">
										<div class="block uploader">
											<span>+</span>
										</div>
									</label>
									<input id="uploadinput_12" type="file" name="file"
										   data-contain="uploads_fileReturn_12" data-title="Hồ sơ nhân thân" multiple
										   data-type="fileReturn" class="focus">
								</div>
							</div>
						</div>

						<div style="text-align: right">
							<button type="button" id="borrowed_danhanhoso" class="btn btn-info">Xác nhận</button>
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


<div id="return_borrowed" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Chưa nhận đủ hồ sơ mượn</h3>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none"
				 id="div_errorCreate_5">
				<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
				<span class='div_errorCreate'></span>
			</div>
			<input type="hidden" id="fileReturn_id" value="" name="fileReturn_id">
			<div class="modal-body">

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Ghi chú: <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea type="text" class="form-control" id="ghichu_5"></textarea>
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Upload ảnh <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div id="SomeThing" class="simpleUploader">
							<div class="uploads" id="uploads_borrowed_1"></div>
							<label for="uploadinput_2">
								<div class="block uploader">
									<span>+</span>
								</div>
							</label>
							<input id="uploadinput_2" type="file" name="file"
								   data-contain="uploads_borrowed_1" data-title="Hồ sơ nhân thân" multiple
								   data-type="fileReturn" class="focus">
						</div>
					</div>
				</div>


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary" id="submit_return_borrowed">Xác nhận</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="trahsdamuon" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_trahsdamuon"></h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" id="fileReturn_id">

						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<textarea type="text" class="form-control" id="ghichu_approve_3"
										  name="ghichu_approve_3"></textarea>
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Upload ảnh </label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="uploads_fileReturn_13"></div>
									<label for="uploadinput_13">
										<div class="block uploader">
											<span>+</span>
										</div>
									</label>
									<input id="uploadinput_13" type="file" name="file"
										   data-contain="uploads_fileReturn_13" data-title="Hồ sơ nhân thân" multiple
										   data-type="fileReturn" class="focus">
								</div>
							</div>
						</div>

						<div style="text-align: right">
							<button type="button" id="borrowed_trahsdamuon" class="btn btn-info">Xác nhận</button>
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

<div class="modal fade" id="luukho" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_luukho"></h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" id="fileReturn_id">
						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<textarea type="text" class="form-control" id="ghichu_approve_4"
										  name="ghichu_approve_4"></textarea>
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Upload ảnh </label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="uploads_fileReturn_14"></div>
									<label for="uploadinput_14">
										<div class="block uploader">
											<span>+</span>
										</div>
									</label>
									<input id="uploadinput_14" type="file" name="file"
										   data-contain="uploads_fileReturn_14" data-title="Hồ sơ nhân thân" multiple
										   data-type="fileReturn" class="focus">
								</div>
							</div>
						</div>
						<div style="text-align: right">

							<button type="button" id="borrowed_luukho" class="btn btn-info">Xác nhận</button>
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

<div class="modal fade" id="trahskhachhangtattoan" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_trahskhachhangtattoan"></h3>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none"
				 id="div_errorCreate_20">
				<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
				<span class='div_errorCreate'></span>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" id="fileReturn_id">

						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Ghi chú <span
									class="text-danger">*</span></label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<textarea type="text" class="form-control" id="ghichu_approve_20"
										  name="ghichu_approve_20"></textarea>
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Upload ảnh <span
									class="text-danger">*</span></label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="uploads_fileReturn_20"></div>
									<label for="uploadinput_20">
										<div class="block uploader">
											<span>+</span>
										</div>
									</label>
									<input id="uploadinput_20" type="file" name="file"
										   data-contain="uploads_fileReturn_20" data-title="Hồ sơ nhân thân" multiple
										   data-type="fileReturn" class="focus">
								</div>
							</div>
						</div>

						<div style="text-align: right">
							<button type="button" id="borrowed_trahskhachhangtattoan" class="btn btn-info">Xác nhận</button>
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

<!--Start Template input document-->
<?php $this->load->view('page/file_manager/records_modal/confirm_customer_finish_modal.php') ; ?>
<!--End Template input document-->

<div id="chua_tra_hs_da_muon" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Chưa nhận đủ hồ sơ mượn</h3>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none"
				 id="div_errorCreate_6">
				<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
				<span class='div_errorCreate'></span>
			</div>
			<input type="hidden" id="fileReturn_id" value="" name="fileReturn_id">
			<div class="modal-body">

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Ghi chú: <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea type="text" class="form-control" id="ghichu_6"></textarea>
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Upload ảnh <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div id="SomeThing" class="simpleUploader">
							<div class="uploads" id="uploads_borrowed_2"></div>
							<label for="uploadinput_3">
								<div class="block uploader">
									<span>+</span>
								</div>
							</label>
							<input id="uploadinput_3" type="file" name="file"
								   data-contain="uploads_borrowed_2" data-title="Hồ sơ nhân thân" multiple
								   data-type="fileReturn" class="focus">
						</div>
					</div>
				</div>


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary" id="submit_chua_tra_hs_da_muon">Xác nhận</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="giahanthoigianmuon" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_giahanthoigianmuon"></h3>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none"
				 id="div_errorCreate_25">
				<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
				<span class='div_errorCreate'></span>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" id="fileReturn_id">

						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Thời gian trả:<span
									class="text-danger">*</span></label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="" class="form-control" placeholder="dd/mm/yyyy" id="update_time_borrowed">
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Lý do mượn <span
									class="text-danger">*</span></label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<textarea type="text" class="form-control" id="ghichu_approve_25"
										  name="ghichu_approve_25"></textarea>
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Upload ảnh tình trạng ĐKX hiện tại <span
									class="text-danger">*</span></label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="uploads_fileReturn_25"></div>
									<label for="uploadinput_25">
										<div class="block uploader">
											<span>+</span>
										</div>
									</label>
									<input id="uploadinput_25" type="file" name="file"
										   data-contain="uploads_fileReturn_25" data-title="Hồ sơ nhân thân" multiple
										   data-type="fileReturn" class="focus">
								</div>
							</div>
						</div>

						<div style="text-align: right">
							<button type="button" id="borrowed_giahanthoigianmuon" class="btn btn-info">Xác nhận</button>
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
<div id="approve_extend_borrowed" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Xác nhận yêu cầu gia hạn hồ sơ</h3>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none"
				 id="div_errorCreate_2">
				<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
				<span class='div_errorCreate'></span>
			</div>
			<input type="hidden" id="fileReturn_id_25" value="" name="fileReturn_id_25">
			<div class="modal-body">

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Thời gian gia hạn mượn: <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="" class="form-control" placeholder="dd/mm/yyyy" id="update_time_borrowed_approve" name="update_time_borrowed_approve" readonly>
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Lý do mượn: <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="lydomuon_25" name="lydomuon_25" readonly>
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Hình ảnh: <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div id="" class="simpleUploader">
							<div class="uploads" id="">
								<div id="file_img_approve"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary" id="approveExtendBorrowed">Xác nhận</button>
			</div>
		</div>
	</div>
</div>

<!--Start modal NV QLKV gửi yêu cầu mượn lên TP quản lý khoản vay-->
<?php $this->load->view('page/file_manager/borrowed_modal/send_request_borrow_to_tp_qlkv_modal.php') ; ?>
<!--End modal NV QLKV gửi yêu cầu mượn lên TP quản lý khoản vay-->

<!--Start modal TP QLKV gửi yêu cầu mượn lên QLHS-->
<?php $this->load->view('page/file_manager/borrowed_modal/send_request_borrow_to_qlhs_modal.php') ; ?>
<!--End modal TP QLKV gửi yêu cầu mượn lên QLHS-->

<!--Start modal NV QLKV gửi yêu cầu duyệt gia hạn mượn-->
<?php $this->load->view('page/file_manager/borrowed_modal/send_request_approve_extend_time_borrow_modal.php') ; ?>
<!--End modal NV QLKV gửi yêu cầu duyệt gia hạn mượn-->

<!--Start modal TP QLKV gửi yêu cầu duyệt gia hạn mượn lên QLHS-->
<?php $this->load->view('page/file_manager/borrowed_modal/send_request_extend_borrow_to_qlhs_modal.php') ; ?>
<!--End modal TP QLKV gửi yêu cầu duyệt gia hạn mượn lên QLHS-->
<script src="<?php echo base_url("assets/") ?>js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets/") ?>js/numeral.min.js"></script>
<script src="<?php echo base_url("assets/") ?>js/File_manager/borrowed.js"></script>

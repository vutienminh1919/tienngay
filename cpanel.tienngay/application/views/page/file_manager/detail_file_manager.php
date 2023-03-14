<div class="detail-contract right_col" role="main">
	<div class="page-title">
		<div class="title_left" style="width: 100%">
			<h3 class="page-title"><a href="<?php echo base_url("file_manager/index_file_manager") ?>">QUẢN LÝ HỒ SƠ - <?= !empty($file_manager->code_contract_disbursement_text) ? $file_manager->code_contract_disbursement_text : "" ?></a>
				&nbsp;<?php
				if ($file_manager->status == "1") {
					echo '-&nbsp <span class="label label-success" style="font-size: 13px; background-color: #2A3F54; padding: 7px">Mới</span>';
				} elseif ($file_manager->status == "2") {
					echo '-&nbsp <span class="label label-success" style="font-size: 13px; background-color: #f2f2f2; padding: 7px; color: #828282" >Hủy yêu cầu</span>';
				} elseif ($file_manager->status == "3") {
					echo '-&nbsp <span class="label label-success" style="font-size: 13px; background-color: #c6e1ee; padding: 7px; color: #199bdc" >YC gửi HS giải ngân</span>';
				} elseif ($file_manager->status == "4") {
					echo '-&nbsp <span class="label label-success" style="font-size: 13px; background-color: #fff2b5; padding: 7px; color: #f08532" >QLHS YC bổ sung</span>';
				} elseif ($file_manager->status == "5") {
					echo '-&nbsp <span class="label label-success" style="font-size: 13px; background-color: #4fbe87; padding: 7px; color: #ffffff" >Đã XN YC gửi HS</span>';
				} elseif ($file_manager->status == "6") {
					echo '-&nbsp <span class="label label-success" style="font-size: 13px; background-color: #e88df2; padding: 7px; color: #ffffff" >Hoàn tất lưu kho</span>';
				} elseif ($file_manager->status == "7") {
					echo '-&nbsp <span class="label label-success" style="font-size: 13px; background-color: #f3616d; padding: 7px; color: #ffffff" >QLHS chưa nhận HS</span>';
				} elseif ($file_manager->status == "8") {
					echo '-&nbsp <span class="label label-success" style="font-size: 13px; background-color: #c6e1ee; padding: 7px; color: #199bdc" >YC trả HS sau tất toán</span>';
				} elseif ($file_manager->status == "9") {
					echo '-&nbsp <span class="label label-success" style="font-size: 13px; background-color: #4fbe87; padding: 7px; color: #ffffff" >QLHS đã xác nhận YC trả HS</span>';
				} elseif ($file_manager->status == "10") {
					echo '-&nbsp <span class="label label-success" style="font-size: 13px; background-color: #fff2b5; padding: 7px; color: #f08532" >YC bổ sung HS</span>';
				} elseif ($file_manager->status == "11") {
					echo '-&nbsp <span class="label label-success" style="font-size: 13px; background-color: #4fbe87; padding: 7px; color: #ffffff" >Đã trả HS sau tất toán</span>';
				} elseif ($file_manager->status == "13") {
					echo '-&nbsp <span class="label label-success" style="font-size: 13px; background-color: #eaca4a; padding: 7px; color: #ffffff" >Trả về yêu cầu</span>';
				}
				?></h3>
		</div>
		<div class="title_right text-right">
			<div class="btn-group">
				<button type="button" class="btn btn-primary">Chức năng</button>
				<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu dropdown-menu-right xt">
					<?php
					if (in_array("giao-dich-vien", $groupRoles) || in_array("cua-hang-truong", $groupRoles)) { ?>

						<?php
						if ($file_manager->status == 1) { ?>
							<li>
								<a href="javascript:void(0)"
								   onclick="gui_ho_so(this)"
								   data-id="<?= !empty($file_manager->_id->{'$oid'}) ? $file_manager->_id->{'$oid'} : ""; ?>"
								   data-mhd="<?= !empty($file_manager->code_contract_disbursement_text) ? $file_manager->code_contract_disbursement_text : ""; ?>"
								>
									Gửi hồ sơ lên HO
								</a>
							</li>

							<li>
								<a href="javascript:void(0)" data-toggle="modal"
								   onclick="sua_yeu_cau('<?= $file_manager->_id->{'$oid'} ?>')">
									Sửa yêu cầu
								</a>
							</li>
							<li>
								<a href="javascript:void(0)"
								   onclick="huy_ho_so_gui(this)"
								   data-id="<?= !empty($file_manager->_id->{'$oid'}) ? $file_manager->_id->{'$oid'} : ""; ?>"
								   data-mhd="<?= !empty($file_manager->code_contract_disbursement_text) ? $file_manager->code_contract_disbursement_text : ""; ?>"
								>
									Hủy yêu cầu
								</a>
							</li>
						<?php } ?>
						<?php
						if ($file_manager->status == 4) { ?>
							<li>
								<a href="javascript:void(0)" data-toggle="modal"
								   onclick="gui_bo_sung_ho_so('<?= $file_manager->_id->{'$oid'} ?>')">
									Gửi bổ sung hồ sơ
								</a>
							</li>
							<li>
								<a href="javascript:void(0)"
								   onclick="huy_ho_so_gui(this)"
								   data-id="<?= !empty($file_manager->_id->{'$oid'}) ? $file_manager->_id->{'$oid'} : ""; ?>"
								   data-mhd="<?= !empty($file_manager->code_contract_disbursement_text) ? $file_manager->code_contract_disbursement_text : ""; ?>">
									Hủy yêu cầu
								</a>
							</li>
						<?php } ?>

						<?php
						if ($file_manager->status == 6 && $file_manager->status_hd == 19 && $file_manager->is_dkx_origin == true) { ?>
							<li>
								<a href="javascript:void(0)"
								   onclick="yc_tra_hs_sau_tat_toan(this)"
								   data-id="<?= !empty($file_manager->_id->{'$oid'}) ? $file_manager->_id->{'$oid'} : ""; ?>"
								   data-mhd="<?= !empty($file_manager->code_contract_disbursement_text) ? $file_manager->code_contract_disbursement_text : ""; ?>">
									Trả HS sau tất toán
								</a>
							</li>
						<?php } ?>
						<?php
						if ($file_manager->status == 9) { ?>
							<li>
								<a href="javascript:void(0)"
								   onclick="da_tra_hs_sau_tat_toan(this)"
								   data-id="<?= !empty($file_manager->_id->{'$oid'}) ? $file_manager->_id->{'$oid'} : ""; ?>"
								   data-mhd="<?= !empty($file_manager->code_contract_disbursement_text) ? $file_manager->code_contract_disbursement_text : ""; ?>">
									Đã nhận hồ sơ
								</a>
							</li>
							<li>
								<a href="javascript:void(0)" data-toggle="modal"
								   onclick="yeu_cau_bo_sung_ho_so('<?= $file_manager->_id->{'$oid'} ?>')">
									Yêu cầu bổ sung HS
								</a>
							</li>
						<?php } ?>
						<?php
						if ($file_manager->status == 10) { ?>
							<li>
								<a href="javascript:void(0)"
								   onclick="da_tra_hs_sau_tat_toan(this)"
								   data-id="<?= !empty($file_manager->_id->{'$oid'}) ? $file_manager->_id->{'$oid'} : ""; ?>"
								   data-mhd="<?= !empty($file_manager->code_contract_disbursement_text) ? $file_manager->code_contract_disbursement_text : ""; ?>">
									Đã nhận hồ sơ
								</a>
							</li>
						<?php } ?>
						<?php
						if ($file_manager->status == 13) { ?>
							<li>
								<a href="javascript:void(0)"
								   onclick="yc_tra_hs_sau_tat_toan(this)"
								   data-id="<?= !empty($file_manager->_id->{'$oid'}) ? $file_manager->_id->{'$oid'} : ""; ?>"
								   data-mhd="<?= !empty($file_manager->code_contract_disbursement_text) ? $file_manager->code_contract_disbursement_text : ""; ?>">
									Yêu cầu trả HS sau tất toán
								</a>
							</li>
						<?php } ?>
					<?php } ?>

					<?php
					if (in_array("quan-ly-ho-so", $groupRoles)) { ?>
						<?php
						if ($file_manager->status == 3) { ?>
							<li>
								<a href="javascript:void(0)"
								   onclick="hoan_tat_luu_kho(this)"
								   data-id="<?= !empty($file_manager->_id->{'$oid'}) ? $file_manager->_id->{'$oid'} : ""; ?>"
								   data-mhd="<?= !empty($file_manager->code_contract_disbursement_text) ? $file_manager->code_contract_disbursement_text : ""; ?>"
								>
									Hoàn tất lưu kho
								</a>
							</li>
							<li>
								<a href="javascript:void(0)" data-toggle="modal"
								   onclick="yeu_cau_bo_sung('<?= $file_manager->_id->{'$oid'} ?>')">
									Yêu cầu bổ sung
								</a>
							</li>
							<li>
								<a href="javascript:void(0)"
								   onclick="huy_ho_so_gui(this)"
								   data-id="<?= !empty($file_manager->_id->{'$oid'}) ? $file_manager->_id->{'$oid'} : ""; ?>"
								   data-mhd="<?= !empty($file_manager->code_contract_disbursement_text) ? $file_manager->code_contract_disbursement_text : ""; ?>"
								>
									Hủy yêu cầu
								</a>
							</li>
						<?php } ?>
						<?php
						if ($file_manager->status == 4) { ?>
							<li>
								<a href="javascript:void(0)"
								   onclick="hoan_tat_luu_kho(this)"
								   data-id="<?= !empty($file_manager->_id->{'$oid'}) ? $file_manager->_id->{'$oid'} : ""; ?>"
								   data-mhd="<?= !empty($file_manager->code_contract_disbursement_text) ? $file_manager->code_contract_disbursement_text : ""; ?>"
								>
									Hoàn tất lưu kho
								</a>
							</li>
							<li>
								<a href="javascript:void(0)"
								   onclick="huy_ho_so_gui(this)"
								   data-id="<?= !empty($file_manager->_id->{'$oid'}) ? $file_manager->_id->{'$oid'} : ""; ?>"
								   data-mhd="<?= !empty($file_manager->code_contract_disbursement_text) ? $file_manager->code_contract_disbursement_text : ""; ?>"
								>
									Hủy yêu cầu
								</a>
							</li>
						<?php } ?>
						<?php
						if ($file_manager->status == 5) { ?>
							<li>
								<a href="javascript:void(0)"
								   onclick="hoan_tat_luu_kho(this)"
								   data-id="<?= !empty($file_manager->_id->{'$oid'}) ? $file_manager->_id->{'$oid'} : ""; ?>"
								   data-mhd="<?= !empty($file_manager->code_contract_disbursement_text) ? $file_manager->code_contract_disbursement_text : ""; ?>"
								>
									Hoàn tất lưu kho
								</a>
							</li>
							<li>
								<a href="javascript:void(0)"
								   onclick="qlhs_chua_nhan_hs(this)"
								   data-id="<?= !empty($file_manager->_id->{'$oid'}) ? $file_manager->_id->{'$oid'} : ""; ?>"
								   data-mhd="<?= !empty($file_manager->code_contract_disbursement_text) ? $file_manager->code_contract_disbursement_text : ""; ?>"
								>
									QLHS chưa nhận HS
								</a>
							</li>
						<?php } ?>
						<?php
						if ($file_manager->status == 7) { ?>
							<li>
								<a href="javascript:void(0)"
								   onclick="hoan_tat_luu_kho(this)"
								   data-id="<?= !empty($file_manager->_id->{'$oid'}) ? $file_manager->_id->{'$oid'} : ""; ?>"
								   data-mhd="<?= !empty($file_manager->code_contract_disbursement_text) ? $file_manager->code_contract_disbursement_text : ""; ?>"
								>
									Hoàn tất lưu kho
								</a>
							</li>
						<?php } ?>
						<?php
						if ($file_manager->status == 8) { ?>
							<li>
								<a href="javascript:void(0)" data-toggle="modal"
								   onclick="xac_nhan_yeu_cau_tra('<?= $file_manager->_id->{'$oid'} ?>')">
									Xác nhận yêu cầu trả
								</a>
							</li>
							<li>
								<a href="javascript:void(0)"
								   onclick="tra_ve_yeu_cau_qlhs(this)"
								   data-id="<?= !empty($file_manager->_id->{'$oid'}) ? $file_manager->_id->{'$oid'} : ""; ?>"
								   data-mhd="<?= !empty($file_manager->code_contract_disbursement_text) ? $file_manager->code_contract_disbursement_text : ""; ?>"
								>
									Trả về yêu cầu
								</a>
							</li>

						<?php } ?>
						<?php if ($file_manager->status == 6) : ?>
							<li>
								<a href="javascript:void(0)" data-toggle="modal"
								   onclick="update_quantity_records('<?= $file_manager->_id->{'$oid'} ?>')">
									Cật nhật số lượng hồ sơ
								</a>
							</li>
						<?php endif; ?>
					<?php } ?>
				</ul>
			</div>
		</div>

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
									<h3 class="box__title">THÔNG TIN HỒ SƠ GỬI LÊN SAU GIẢI NGÂN</h3>
								</div>
							</div>
							<br>
							<div class="col-md- col-xs-12">
								<div class="col-md-4 col-sm-4 col-xs-12">
									<h4 class="box__title">DANH SÁCH HỒ SƠ GỬI LÊN</h4>
									<?php if (!empty($file_manager->file) && $file_manager->status > 5) { ?>
										<?php foreach ($file_manager->file as $key1 => $item) { ?>
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
										<?php if (!empty($file_manager->giay_to_khac)) { ?>
											<div class="col-md-12 col-xs-12">
												<div class="box__detail">
													<p class="box--p">- <?php echo $file_manager->giay_to_khac ?></p>
												</div>
											</div>
										<?php } ?>
									<?php } else { ?>
										<?php if (!empty($file_manager->giay_to_khac)) { ?>
											<div class="col-md-12 col-xs-12">
												<div class="box__detail">
													<p class="box--p">- <?php echo $file_manager->giay_to_khac ?></p>
												</div>
											</div>
										<?php } ?>
									<?php } ?>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<h4 class="box__title">HỒ SƠ THỰC NHẬN</h4>
									<?php if (!empty($file_manager->records_receive)) : ?>
										<?php foreach ($file_manager->records_receive as $key => $record) : ?>
											<?php
											if ($record->quantity == 0) continue;
											$quantity = 0;
											if ($record->quantity > 0 && $record->quantity < 10) {
												$quantity = '0' . $record->quantity;
											} else {
												$quantity = $record->quantity;
											}
											?>
											<div class="col-md-12 col-xs-12">
												<div class="box__detail">
													<p class="box--p">
														<?php print '- ' . $record->text . ': ' . '<span style="color: red; font-weight: 700;">' . $quantity . '</span>' . ' bản.' . '<br>'; ?>
													</p>
												</div>
											</div>
										<?php endforeach;?>
									<?php endif; ?>

								</div>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<h4 class="box__title">TÀI SẢN ĐI KÈM</h4>
									<div class="col-md-12 col-xs-12">
										<div class="box__detail">
											<p class="box--p"><?= !empty($file_manager->taisandikem) ? "- " . $file_manager->taisandikem : "" ?></p>
										</div>
									</div>

								</div>
							</div>
							<div class="col-md-12 col-xs-12 table-responsive">
								<div class="col-md-12 col-xs-12">
									<h4 class="box__title">THÔNG TIN HỒ SƠ</h4>
									<div class="col-md-12 col-xs-12">
										<?php if (!empty($file_manager->fileReturn_img)): ?>
											<div id="SomeThing" class="simpleUploader">
												<div class="uploads " id="uploads_identify">
													<?php
													$key_identify = 0;
													foreach ((array)$file_manager->fileReturn_img as $key => $value) {
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
									<div class="col-md-12 col-xs-12">
										<?php if (!empty($file_manager->file_pdf)): ?>
											<div id="SomeThing" class="simpleUploader">
												<div class="uploads " id="uploads_identify">
													<?php
													$key_identify = 0;
													foreach ((array)$file_manager->file_pdf as $key => $value) {
														$key_identify++;
														if (empty($value) || $value->file_type != 'application/pdf') continue; ?>
														<div class="block">
															<!--Video-->
															<?php if (!empty($value->file_type) && ($value->file_type == 'application/pdf')) { ?>
																<span class="timestamp"><?php echo date('d/m/Y H:i:s', basename($value->path));?></span>
																<a href="<?= $value->path ?>" target="_blank"><span style="z-index: 9"><?= $value->file_name?></span>
																	<img name="img_transaction" data-type="expertise" data-key='<?= $key?>' data-filetype="<?= $value->file_type?>" data-filename="<?= $value->file_name?>" style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?= $value->path ?>" alt="">
																	<img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt="">
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

					<div id="myTabContent" class="tab-content col-md-12 col-xs-12 ">
						<div role="tabpanel" class="tab-pane fade active in col-md-12 col-xs-12 "
							 id="tab_content1" aria-labelledby="tab_content1">
							<div class="col-md-12 col-xs-12">
								<div class="col-md-12 col-xs-12">
									<h3 class="box__title">THÔNG TIN HỒ SƠ TRẢ VỀ SAU TẤT TOÁN</h3>
								</div>
							</div>
							<br>
							<div class="col-md-12 col-xs-12">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<h4 class="box__title">DANH SÁCH HỒ SƠ TRẢ VỀ</h4>
									<div class="col-md-12 col-xs-12">
										<?php if (in_array($file_manager->status, [9,11])) : ?>
											<!--Hồ sơ gốc-->
											<?php if (!empty($file_manager->records_return)) : ?>
												<?php foreach ($file_manager->records_return as $key => $record) : ?>
													<?php
													if ($record->quantity == 0) continue;
													$quantity = 0;
													if ($record->quantity > 0 && $record->quantity < 10) {
														$quantity = '0' . $record->quantity;
													} else {
														$quantity = $record->quantity;
													}
													?>
													<div class="col-md-12 col-xs-12">
														<div class="box__detail">
															<p class="box--p">
																<?php print '- ' . $record->text . ': ' . '<span style="color: blue; font-weight: 700;">' . $quantity . '</span>' . ' bản.' . '<br>'; ?>
															</p>
														</div>
													</div>
												<?php endforeach;?>
											<?php endif; ?>
											<!--Giấy tờ khác-->
											<?php if (!empty($file_manager->giay_to_khac)) { ?>
												<div class="col-md-12 col-xs-12">
													<div class="box__detail">
														<p class="box--p">
															- <?php echo $file_manager->giay_to_khac ?></p>
													</div>
												</div>
											<?php } ?>
										<?php endif; ?>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<h4 class="box__title">TÀI SẢN ĐI KÈM</h4>
									<div class="col-md-12 col-xs-12">
										<?php if ($file_manager->status == 11): ?>
											<?php if (!empty($file_manager->taisandikem)) { ?>
												<div class="box__detail">
													<p class="box--p"><?= !empty($file_manager->taisandikem) ? "- " . $file_manager->taisandikem : "" ?></p>
												</div>
											<?php } ?>
										<?php else: ?>
											<?php if (!empty($file_manager->taisandikem_v2)) { ?>
												<div class="box__detail">
													<p class="box--p"><?= !empty($file_manager->taisandikem_v2) ? "- " . $file_manager->taisandikem_v2 : "" ?></p>
												</div>
											<?php } ?>
										<?php endif; ?>

									</div>

								</div>
							</div>
							<div class="col-md-12 col-xs-12 table-responsive">
								<div class="col-md-12 col-xs-12">
									<h4 class="box__title">THÔNG TIN HỒ SƠ</h4>
									<div class="col-md-12 col-xs-12">
										<?php if (!empty($file_manager->fileReturn_img_v2)): ?>
											<div id="SomeThing" class="simpleUploader">
												<div class="uploads " id="uploads_identify">
													<?php
													$key_identify = 0;
													foreach ((array)$file_manager->fileReturn_img_v2 as $key => $value) {
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

		<div class="col-md-12 col-xs-12">
			<!--Start Panel-->
			<div class="" role="tabpanel" data-example-id="togglable-tabs">
				<ul id="myTab" class="nav nav-pills" role="tablist">
					<li role="presentation" class="active"><a href="#tab_history" id="tab_histo" role="tab" data-toggle="tab" aria-expanded="true">Lịch sử</a></li>
					<?php if ($userSession['is_superadmin'] == 1) : ?>
						<li role="presentation" class=""><a href="#tab_log" role="tab" id="tab_logs" data-toggle="tab" aria-expanded="false">Log</a></li>
					<?php endif; ?>
				</ul>
				<br>
				<div id="myTabContent" class="tab-content">
					<div role="tabpanel" class="tab-pane fade active in" id="tab_history" aria-labelledby="tab_histo">
						<div class="col-md-12 col-xs-12 tab-content3">
							<ul class="list-unstyled timeline">
								<?php if (!empty($file_manager_log)): ?>
									<?php foreach ($file_manager_log as $item): ?>
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
															<?= !empty($item->fileReturn->ghichu) ? $item->fileReturn->ghichu : "" ?>
															<?= !empty($item->new->ghichu) ? $item->new->ghichu : "" ?>
															<?= !empty($item->new->ghichu_qlhs) ? $item->new->ghichu_qlhs : "" ?>
														</p>

														<?php if (!empty($item->new->fileReturn_img)) { ?>
															<div class="row">
																<?php foreach ((array)$item->new->fileReturn_img as $key => $value) { ?>

																	<?php if ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg') { ?>
																		<div class="col-xs-12 col-md-6 col-lg-3" style="width: auto">
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
														<?php if (!empty($item->new->fileReturn_img_v2)) { ?>
															<div class="row">
																<?php foreach ((array)$item->new->fileReturn_img_v2 as $key => $value) { ?>

																	<?php if ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg') { ?>
																		<div class="col-xs-12 col-md-6 col-lg-3" style="width: auto">
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
														<?php if (!empty($item->fileReturn->fileReturn_img)) { ?>
															<div class="row">
																<?php foreach ((array)$item->fileReturn->fileReturn_img as $key => $value) { ?>

																	<?php if ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg') { ?>
																		<div class="col-xs-12 col-md-6 col-lg-3" style="width: auto">
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
																		<div class="col-xs-12 col-md-6 col-lg-3" style="width: auto">
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
																$old_status = file_manager_status($item->old->status);
																$new_status = file_manager_status($item->new->status);
																$old_status = is_array($old_status) ? '' : $old_status;
																$new_status = is_array($new_status) ? '' : ' => ' . $new_status;
																$status_detail = $old_status . $new_status;
															}
															?>
															<?php if ($item->action == 'update_records') : ?>
																<span class="work__status" style="background-color: #5a738e; padding: 6px; color: white">Cập nhật số lượng hồ sơ</span>
															<?php else :  ?>
																<span class="work__status" style="background-color: #5a738e; padding: 6px; color: white">
																	<?= ($status_detail != "") ? $status_detail : "Mới" ?>
															</span>
															<?php endif; ?>
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
					<?php if ($userSession['is_superadmin'] == 1) : ?>
						<div role="tabpanel" class="tab-pane fade" id="tab_log" aria-labelledby="tab_logs">
							<?php $this->load->view('page/file_manager/log_records.php');?>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<!--End Panel-->
		</div>

	</div>
</div>

<!--Modal-->
<div id="addnewModal_guihoso" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">CVKD yêu cầu gửi hồ sơ về HO</h3>
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
						<select class="form-control" id="code_contract_disbursement" name="code_contract_disbursement[]"
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
									<input type="checkbox" value="Thỏa thuận 3 bên" name="file[]" class="fileCheckBox">
									Thỏa thuận 3 bên
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Văn bản bàn giao tài sản" name="file[]"
										   class="fileCheckBox"> Văn bản bàn giao tài sản
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Thông báo" name="file[]" class="fileCheckBox"> Thông
									báo
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Đăng ký xe/Cà vẹt" name="file[]" class="fileCheckBox">
									Đăng ký xe/Cà vẹt
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Hợp đồng mua bán" name="file[]" class="fileCheckBox">
									Hợp đồng mua bán
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Đăng kiểm" name="file[]" class="fileCheckBox"> Đăng
									kiểm
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Giấy cam kết" name="file[]" class="fileCheckBox"> Giấy
									cam kết
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Ủy quyền" name="file[]" class="fileCheckBox"> Ủy quyền
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Chìa khóa" name="file[]" class="fileCheckBox"> Chìa
									khóa
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Sổ đỏ" name="file[]" class="fileCheckBox"> Sổ đỏ
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
					<label class="control-label col-md-3 col-xs-12">Tài sản đi kèm </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="taisandikem">
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea type="text" class="form-control" id="ghichu"></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Upload ảnh <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div id="SomeThing" class="simpleUploader">
							<div class="uploads" id="uploads_fileReturn"></div>
							<label for="uploadinput">
								<div class="block uploader">
									<span>+</span>
								</div>
							</label>
							<input id="uploadinput" type="file" name="file"
								   data-contain="uploads_fileReturn" data-title="Hồ sơ nhân thân" multiple
								   data-type="fileReturn" class="focus">
						</div>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary" id="submit_fileReturn">Xác nhận</button>
			</div>
		</div>
	</div>
</div>

<div id="editFileReturn" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<input type="hidden" id="fileReturn_id" value="" name="fileReturn_id">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Sửa</h4>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none"
				 id="div_errorCreate_1">
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
				<div class="form-group">
					<div class="row">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Hồ sơ <span
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
									<input type="checkbox" value="Văn bản bàn giao tài sản" name="file_1[]" id="file_2"
										   class="fileCheckBox_1"> Văn bản bàn giao tài sản
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
									<input type="checkbox" value="Giấy cam kết" name="file_1[]" class="fileCheckBox_1"
										   id="file_7"> Giấy
									cam kết
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Ủy quyền" name="file_1[]" class="fileCheckBox_1"
										   id="file_8"> Ủy quyền
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
					<label class="control-label col-md-3 col-xs-12">Tài sản đi kèm </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="taisandikem_1" name="taisandikem_1">
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea type="text" class="form-control" id="ghichu_1" name="ghichu_1"></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Upload ảnh <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div id="SomeThing" class="simpleUploader">
							<div class="uploads" id="uploads_fileReturn_edit"></div>
							<label for="uploadinput_1">
								<div class="block uploader">
									<span>+</span>
								</div>
							</label>
							<input id="uploadinput_1" type="file" name="file"
								   data-contain="uploads_fileReturn_edit" data-title="Hồ sơ nhân thân" multiple
								   data-type="fileReturn" class="focus">
						</div>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
				<button type="button" class="btn btn-primary" id="edit_fileReturn">Sửa</button>
			</div>
		</div>
	</div>
</div>


<div id="bosunghoso" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<input type="hidden" id="fileReturn_id" value="" name="fileReturn_id">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">QLHS yêu cầu bổ sung hồ sơ</h4>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none"
				 id="div_errorCreate_1">
				<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
				<span class='div_errorCreate'></span>
			</div>
			<div class="modal-body">

				<div class="form-group">
					<div class="row">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Danh sách hồ sơ <span
								class="text-danger">*</span> :</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="checkbox m-0">
								<label>
									<input type="checkbox" value="" id="selectAll_file_2" name="all_file_2"
										   disabled> Tất
									cả
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Thỏa thuận 3 bên" name="file_2[]"
										   class="fileCheckBox_2" id="file1_1" disabled>
									Thỏa thuận 3 bên
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Văn bản bàn giao tài sản" name="file_2[]"
										   id="file1_2"
										   class="fileCheckBox_2" disabled> Văn bản bàn giao tài sản
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Thông báo" name="file_2[]"
										   class="fileCheckBox_2"
										   id="file1_3" disabled> Thông
									báo
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Đăng ký xe/Cà vẹt" name="file_2[]"
										   class="fileCheckBox_2" id="file1_4" disabled>
									Đăng ký xe/Cà vẹt
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Hợp đồng mua bán" name="file_2[]"
										   class="fileCheckBox_2" id="file1_5" disabled>
									Hợp đồng mua bán
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Đăng kiểm" name="file_2[]"
										   class="fileCheckBox_2"
										   id="file1_6" disabled> Đăng
									kiểm
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Giấy cam kết" name="file_2[]"
										   class="fileCheckBox_2"
										   id="file1_7" disabled> Giấy
									cam kết
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Ủy quyền" name="file_2[]"
										   class="fileCheckBox_2"
										   id="file1_8" disabled> Ủy quyền
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Chìa khóa" name="file_2[]"
										   class="fileCheckBox_2"
										   id="file1_9" disabled> Chìa
									khóa
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Sổ đỏ" name="file_2[]" class="fileCheckBox_2"
										   id="file1_10" disabled> Sổ đỏ
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Giấy tờ khác:</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="giay_to_khac_2" name="giay_to_khac_2" disabled>
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Tài sản đi kèm </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="taisandikem_2" name="taisandikem_2" disabled>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea type="text" class="form-control" id="ghichu_qlhs" name="ghichu_qlhs"></textarea>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary" id="submit_bosunghoso">Xác nhận</button>
			</div>
		</div>
	</div>
</div>

<div id="guibosunghoso" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<input type="hidden" id="fileReturn_id" value="" name="fileReturn_id">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">QLHS yêu cầu bổ sung hồ sơ</h4>
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
			<div class="modal-body">

				<div class="form-group">
					<div class="row">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Danh sách hồ sơ <span
								class="text-danger">*</span> :</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="checkbox m-0">
								<label>
									<input type="checkbox" value="" id="selectAll_file_3" name="all_file_3"
										   disabled> Tất
									cả
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Thỏa thuận 3 bên" name="file_3[]"
										   class="fileCheckBox_3" id="file3_1">
									Thỏa thuận 3 bên
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Văn bản bàn giao tài sản" name="file_3[]"
										   id="file3_2"
										   class="fileCheckBox_3"> Văn bản bàn giao tài sản
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Thông báo" name="file_3[]"
										   class="fileCheckBox_3"
										   id="file3_3"> Thông
									báo
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Đăng ký xe/Cà vẹt" name="file_3[]"
										   class="fileCheckBox_3" id="file3_4">
									Đăng ký xe/Cà vẹt
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Hợp đồng mua bán" name="file_3[]"
										   class="fileCheckBox_3" id="file3_5">
									Hợp đồng mua bán
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Đăng kiểm" name="file_3[]"
										   class="fileCheckBox_3"
										   id="file3_6"> Đăng
									kiểm
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Giấy cam kết" name="file_3[]"
										   class="fileCheckBox_3"
										   id="file3_7"> Giấy
									cam kết
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Ủy quyền" name="file_3[]"
										   class="fileCheckBox_3"
										   id="file3_8"> Ủy quyền
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Chìa khóa" name="file_3[]"
										   class="fileCheckBox_3"
										   id="file3_9"> Chìa
									khóa
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Sổ đỏ" name="file_3[]" class="fileCheckBox_3"
										   id="file3_10"> Sổ đỏ
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Giấy tờ khác:</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="giay_to_khac_3" name="giay_to_khac_3">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Tài sản đi kèm </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="taisandikem_3" name="taisandikem_3">
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea type="text" class="form-control" id="ghichu_3" name="ghichu_3"></textarea>
					</div>
				</div>


				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Upload ảnh <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div id="SomeThing" class="simpleUploader">
							<div class="uploads" id="uploads_fileReturn_3"></div>
							<label for="uploadinput_2">
								<div class="block uploader">
									<span>+</span>
								</div>
							</label>
							<input id="uploadinput_2" type="file" name="file"
								   data-contain="uploads_fileReturn_3" data-title="Hồ sơ nhân thân" multiple
								   data-type="fileReturn" class="focus">
						</div>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary" id="submit_guibosunghoso">Xác nhận</button>
			</div>
		</div>
	</div>
</div>


<div id="yeucaubosunghs" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<input type="hidden" id="fileReturn_id" value="" name="fileReturn_id">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">CVKD yêu cầu bổ sung hồ sơ</h4>
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
			<div class="modal-body">

				<div class="form-group">
					<div class="row">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Danh sách hồ sơ <span
								class="text-danger">*</span> :</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="checkbox m-0">
								<label>
									<input type="checkbox" value="" id="selectAll_file_4" name="all_file_4"
										   disabled> Tất
									cả
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Thỏa thuận 3 bên" name="file_4[]"
										   class="fileCheckBox_4" id="file4_1">
									Thỏa thuận 3 bên
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Văn bản bàn giao tài sản" name="file_4[]"
										   id="file4_2"
										   class="fileCheckBox_4"> Văn bản bàn giao tài sản
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Thông báo" name="file_4[]"
										   class="fileCheckBox_4"
										   id="file4_3"> Thông
									báo
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Đăng ký xe/Cà vẹt" name="file_4[]"
										   class="fileCheckBox_4" id="file4_4">
									Đăng ký xe/Cà vẹt
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Hợp đồng mua bán" name="file_4[]"
										   class="fileCheckBox_4" id="file4_5">
									Hợp đồng mua bán
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Đăng kiểm" name="file_4[]"
										   class="fileCheckBox_4"
										   id="file4_6"> Đăng
									kiểm
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Giấy cam kết" name="file_4[]"
										   class="fileCheckBox_4"
										   id="file4_7"> Giấy
									cam kết
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Ủy quyền" name="file_4[]"
										   class="fileCheckBox_4"
										   id="file4_8"> Ủy quyền
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Chìa khóa" name="file_4[]"
										   class="fileCheckBox_4"
										   id="file4_9"> Chìa
									khóa
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="Sổ đỏ" name="file_4[]" class="fileCheckBox_4"
										   id="file4_10"> Sổ đỏ
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Giấy tờ khác:</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="giay_to_khac_4" name="giay_to_khac_4">
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Tài sản đi kèm </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="taisandikem_4" name="taisandikem_4">
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea type="text" class="form-control" id="ghichu_4" name="ghichu_4"></textarea>
					</div>
				</div>


				<div class="form-group row">
					<label class="control-label col-md-3 col-xs-12">Upload ảnh <span
							class="text-danger">*</span></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div id="SomeThing" class="simpleUploader">
							<div class="uploads" id="uploads_fileReturn_4"></div>
							<label for="uploadinput_3">
								<div class="block uploader">
									<span>+</span>
								</div>
							</label>
							<input id="uploadinput_3" type="file" name="file"
								   data-contain="uploads_fileReturn_4" data-title="Hồ sơ nhân thân" multiple
								   data-type="fileReturn" class="focus">
						</div>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary" id="submit_yeucaubosunghs">Xác nhận</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="cancel_fileReturn" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_cancel"></h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" id="fileReturn_id">
						<div style="text-align: center">
							<button type="button" id="fileReturn_cancel" class="btn btn-info">Xác nhận</button>
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

<div class="modal fade" id="manager_send_file" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
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
					<div class="col-xs-12">
						<input type="hidden" id="fileReturn_id">
						<div style="text-align: center">
							<button type="button" id="fileReturn_send_file" class="btn btn-info">Xác nhận</button>
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

<div class="modal fade" id="approve_file" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_approve_file"></h3>
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
									<div class="uploads" id="uploads_fileReturn_10"></div>
									<label for="uploadinput_10">
										<div class="block uploader">
											<span>+</span>
										</div>
									</label>
									<input id="uploadinput_10" type="file" name="file"
										   data-contain="uploads_fileReturn_10" data-title="Hồ sơ nhân thân" multiple
										   data-type="fileReturn" class="focus">
								</div>
							</div>
						</div>

						<div style="text-align: right">
							<button type="button" id="fileReturn_approve_file" class="btn btn-info">Xác nhận</button>
							<button type="button" class="btn btn-primary close-hs" data-dismiss="modal"
									aria-label="Close">
								Hủy
							</button>
							<div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="save_file" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal"
						aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_save_file"></h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" id="fileReturn_id">
						<!--Start Template input document-->
						<?php $this->load->view('page/file_manager/list_input_document.php') ; ?>
						<!--End Template input document-->
						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Mã lưu trữ hồ sơ</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" id="code_store_rc" class="form-control" placeholder="Nhập mã lưu trữ hồ sơ">
							</div>
						</div>
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
							<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
							<button type="button" id="fileReturn_save_file" class="btn btn-success">Xác nhận</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="not_received_file" tabindex="-1" role="dialog"
	 aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal"
						aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_not_received_file"></h3>
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
							<button type="button" id="fileReturn_not_received_file"
									class="btn btn-info">Xác nhận
							</button>
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

<div class="modal fade" id="return_file_v2" tabindex="-1" role="dialog"
	 aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal"
						aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_return_file_v2"></h3>
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
							<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
							<button type="button" id="fileReturn_return_file_v2" class="btn btn-success">Xác nhận</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--Start Modal return records finish records-->
<?php $this->load->view('page/file_manager/records_modal/return_records_finish_modal.php') ; ?>
<!--End Modal return records finish -->

<!--Start Modal Request return records-->
<?php $this->load->view('page/file_manager/records_modal/request_return_modal.php') ; ?>
<!--End Modal Request return records-->


<div class="modal fade" id="traveyeucautattoan" tabindex="-1" role="dialog"
	 aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal"
						aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center" id="title_traveyeucautattoan"></h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" id="fileReturn_id">

						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Ghi chú </label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<textarea type="text" class="form-control" id="ghichu_approve_5"
										  name="ghichu_approve_5"></textarea>
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3 col-xs-12">Upload ảnh </label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div id="SomeThing" class="simpleUploader">
									<div class="uploads" id="uploads_fileReturn_15"></div>
									<label for="uploadinput_15">
										<div class="block uploader">
											<span>+</span>
										</div>
									</label>
									<input id="uploadinput_15" type="file" name="file"
										   data-contain="uploads_fileReturn_15" data-title="Hồ sơ nhân thân" multiple
										   data-type="fileReturn" class="focus">
								</div>
							</div>
						</div>

						<div style="text-align: right">
							<button type="button" id="fileReturn_traveyeucautattoan"
									class="btn btn-info">Xác nhận
							</button>
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
<?php $this->load->view('page/file_manager/records_modal/update_quantity_records_modal.php') ; ?>
<!--End Template input document-->


<script src="<?php echo base_url("assets/") ?>js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets/") ?>js/numeral.min.js"></script>
<script src="<?php echo base_url("assets/") ?>js/File_manager/file_manager.js"></script>


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
	hr{
		border-top: 1px solid #5a738e;
	}

	.xt{
		padding:8px 8px;
	}

	.xt button{
		border: none;
		outline: none;
		background-color: white;
		white-space: nowrap;
		margin: 0px;
		font-size: 12px;
		font-weight: 400;
		line-height: 1.4;
	}

	.xt button:hover{
		background-color: lightskyblue;
	}
</style>


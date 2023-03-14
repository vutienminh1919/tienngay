<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span>Đang Xử Lý...</span>
	</div>
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$code_store = !empty($_GET['code_store']) ? $_GET['code_store'] : array();
	$status_sale = !empty($_GET['status_sale']) ? $_GET['status_sale'] : "";
	$status_pgd = !empty($_GET['tt_pgd']) ? $_GET['tt_pgd'] : "";
	$cvkd = !empty($_GET['cvkd']) ? $_GET['cvkd'] : "";
	$source_pgd = !empty($_GET['source_pgd']) ? $_GET['source_pgd'] : "";

	?>
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
						<h3>Danh sách lead chuyển về PGD
							<br>
							<small>
								<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a href="#>">Danh
									sách lead chuyển về PGD</a>
							</small>
						</h3>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="title_right text-right">
					<button class="btn btn-info modal_PGD" data-toggle="modal" data-target="#addNewPGDModal"><i
								class="fa fa-plus" aria-hidden="true"></i> Thêm mới
					</button>
				</div>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<div class="row">
						<div class="col-xs-12">
							<div class="row">
								<form action="<?php echo base_url('lead_custom/list_transfe_office') ?>" method="get"
									  style="width: 100%;">
									<div class="col-xs-12">
										<div class="row">
											<div class="col-xs-12 col-lg-2">
												<div class="form-group">
													<label for="">Từ</label>
													<input type="date" name="fdate" class="form-control"
														   value="<?= !empty($fdate) ? $fdate : "" ?>">
												</div>
											</div>
											<div class="col-xs-12 col-lg-2">
												<div class="form-group">
													<label for="">Đến</label>
													<input type="date" name="tdate" class="form-control"
														   value="<?= !empty($tdate) ? $tdate : "" ?>">
												</div>
											</div>
                                            <div class="col-xs-12 col-lg-2">
                                            	<label for="">CVKD</label>
												<input type="text" name="cvkd" class="form-control"
													   value="<?= isset($_GET['cvkd']) ? $_GET['cvkd'] : "" ?>" placeholder="">
											</div>
											<div class="col-xs-12 col-lg-2">
												<label for="">Chọn PGD</label>
												<select id="selectize_store" class="form-control" name="code_store[]"
														multiple="multiple">
													<option value="">Chọn PGD</option>
													<?php foreach ($storeData as $p) {
														if (!empty($stores) && is_array($stores)) {
															if (!in_array($p->id, $stores))
																continue;
														}
														?>
														<option <?php
														if (is_array($code_store)) {
															echo in_array($p->id, $code_store) ? 'selected' : '';
														} ?>
																value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-xs-12 col-lg-2">
												<label for="">Chọn trạng thái</label>
												<select class="form-control status_pgd" name="tt_pgd">
													<option value="">--Chọn trạng thái--</option>
													<?php foreach (status_pgd() as $key => $item) { ?>
														<option value="<?= $key ?>" <?= ($status_pgd == $key) ? 'selected' : '' ?>><?= $item ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-xs-12 col-lg-2">
												<label for="">Chọn nguồn</label>
												<select class="form-control " name="source_pgd">
													<option value="">-- Tất cả --</option>
													<?php foreach (lead_nguon_pgd() as $key1 => $item1) { ?>
														<option value="<?= $key1 ?>" <?= ($source_pgd == $key1) ? 'selected' : '' ?>><?= $item1 ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-xs-12 col-lg-2">
												<label for="">&nbsp;</label>
												<button type="submit" class="btn btn-primary w-100">
													<i class="fa fa-search"
													   aria-hidden="true"></i> <?= $this->lang->line('search') ?>
												</button>
											</div>
											<div class="col-xs-12 col-lg-2">
												<label>&nbsp;</label>
												<a style="background-color: #18d102;"
												   href="<?= base_url() ?>excel/doLead_hoiso?fdate=<?= $fdate . '&tdate=' . $tdate. '&cvkd=' . $cvkd . '&pgd_status=' . $status_pgd . '&source_pgd='. $source_pgd .'&'. http_build_query($code_store,'code_store[]') ?>"
												   class="btn btn-primary w-100" target="_blank"><i
															class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
													Xuất
													excel</a>
											</div>
										</div>
									</div>
								</form>
								<div class="col-xs-12 col-lg-2">
									<div>&nbsp;</div>
									<button class="btn btn-primary dropdown-toggle" type="button"
											data-toggle="dropdown"
											aria-haspopup="true" aria-expanded="false">Ẩn/Hiện cột
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input"
													   data-control-column="1" checked="checked">
												<label class="custom-control-label">STT</label>
											</div>
										</a>
										<a class="dropdown-item">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input"
													   data-control-column="2" checked="checked">
												<label class="custom-control-label">THAO TÁC</label>
											</div>
										</a>
										<a class="dropdown-item">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input"
													   data-control-column="3" checked="checked">
												<label class="custom-control-label">NGÀY THÁNG</label>
											</div>
										</a>
										<a class="dropdown-item" href="#">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input"
													   data-control-column="4" checked="checked">
												<label class="custom-control-label">HỌ VÀ TÊN</label>
											</div>
										</a>
										<a class="dropdown-item">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input"
													   data-control-column="5" checked="checked">
												<label class="custom-control-label">SỐ ĐIỆN THOẠI</label>
											</div>
										</a>
										<a class="dropdown-item">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input"
													   data-control-column="6" checked="checked">
												<label class="custom-control-label">CHUYỂN ĐẾN PGD</label>
											</div>
										</a>
										<a class="dropdown-item">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input"
													   data-control-column="7" checked="checked">
												<label class="custom-control-label">TRẠNG THÁI PGD</label>
											</div>
										</a>
										<a class="dropdown-item">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input"
													   data-control-column="8" checked="checked">
												<label class="custom-control-label">TÌNH TRẠNG LEAD</label>
											</div>
										</a>
										<a class="dropdown-item" href="#">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input"
													   data-control-column="9" checked="checked">
												<label class="custom-control-label">TRẠNG THÁI HĐ</label>
											</div>
										</a>
										<a class="dropdown-item">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input"
													   data-control-column="10" checked="checked">
												<label class="custom-control-label">NGUỒN</label>
											</div>
										</a>
										<a class="dropdown-item">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input"
													   data-control-column="11" checked="checked">
												<label class="custom-control-label">UTM SOURCE</label>
											</div>
										</a>
										<a class="dropdown-item">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input"
													   data-control-column="12" checked="checked">
												<label class="custom-control-label">UTM CAMPAIGN</label>
											</div>
										</a>
										<a class="dropdown-item">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input"
													   data-control-column="13" checked="checked">
												<label class="custom-control-label">XÁC NHẬN</label>
											</div>
										</a>
										<a class="dropdown-item" href="#">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input"
													   data-control-column="14" checked="checked">
												<label class="custom-control-label">TRẢ CSKH</label>
											</div>
										</a>
										<a class="dropdown-item" href="#">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input"
													   id="show-hide-loan-products" data-control-column="18"
													   checked="checked">
												<label class="custom-control-label">SẢN PHẨM VAY</label>
											</div>
										</a>
										<a class="dropdown-item" href="#">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input"
													   id="show-hide-position" data-control-column="19"
													   checked="checked">
												<label class="custom-control-label">VỊ TRÍ/CHỨC VỤ</label>
											</div>
										</a>
										<a class="dropdown-item" href="#">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input"
													   id="show-hide-identify" data-control-column="20"
													   checked="checked">
												<label class="custom-control-label">CMND/CCCD</label>
											</div>
										</a>
										<div class="dropdown-divider"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12">
							<div class="table-responsive">
								<div><?php echo $result_count; ?></div>

								<table class="table table-striped hide-show-column" id="datatable-button">
									<thead>
									<tr>
										<th>#</th>
										<th>THAO TÁC</th>
										<th>NGÀY THÁNG</th>
										<th>CVKD</th>
										<th>HỌ VÀ TÊN</th>
										<th>SỐ ĐIỆN THOẠI</th>
										<th>CHUYỂN ĐẾN PGD</th>
										<th>TRẠNG THÁI PGD</th>
										<th>TÌNH TRẠNG LEAD</th>
										<th>TRẠNG THÁI HĐ</th>

										<th>NGUỒN</th>
										<th>UTM SOURCE</th>
										<th>UTM CAMPAIGN</th>
										<th>CMND</th>
										<th>THẺ CĂN CƯỚC</th>
										<th>SĐT KH GIỚI THIỆU</th>
										<th>XÁC NHẬN</th>
										<th>TRẢ CSKH</th>
										<th>SẢN PHẨM VAY</th>
										<th>VỊ TRÍ/CHỨC VỤ</th>
										<th class="show-hide-identify">CMND/CCCD</th>
									</tr>
									</thead>
									<tbody name="list_lead">
									<?php
									if (!empty($leadsData)) {
										$n = 1;
										foreach ($leadsData as $key => $lead) {

											$cskh_one = ($lead->cskh) ? $lead->cskh : '';
											$reason_cancel_pgd = "";
											if (!empty($reasonData))
												foreach ($reasonData as $reason) {
													if ($lead->reason_cancel_pgd == $reason->code_reason) {
														$reason_cancel_pgd = $reason->reason_name;
													}
												}
											?>
											<tr>
												<td><?php echo $n++ ?></td>
												<td class="text-right">
													<a href="javascript:void(0)"
													   onclick="showModal_office('<?= $lead->_id->{'$oid'} ?>')"
													   class="btn btn-info callmodal">
														Gọi
													</a>

													<a class="btn btn-success " target="_blank"
													   href="<?php echo base_url(); ?>pawn/createContract?id_lead=<?= $lead->_id->{'$oid'} ?>">
														<i class="fa fa-plus" aria-hidden="true"></i> Tạo hợp đồng
													</a>
													<?php if(in_array('cua-hang-truong', $groupRoles) ){ ?>
														<a href="javascript:void(0)"
													   onclick="showModal_chage_cvkd('<?= $lead->_id->{'$oid'} ?>')"
													   class="btn btn-info callmodal">
														Đổi CVKD
													</a>
												     <?php } ?>
												</td>
												<td><?= !empty($lead->office_at) ? date('d/m/Y H:i:s', $lead->office_at) : date('d/m/Y H:i:s', $lead->updated_at) ?></td>
                                               <td><?= !empty($lead->cvkd) ? $lead->cvkd : '' ?></td>
												<td><?= !empty($lead->fullname) ? $lead->fullname : '' ?></td>
												<td class="callmodal"
													id="<?= $lead->_id->{'$oid'} ?>"><?= !empty($lead->phone_number) ? hide_phone($lead->phone_number) : "" ?></td>
												<td><?php if (!empty($lead->id_PDG)) {
														foreach ($storeData as $key => $value) {
															if ($value->_id->{'$oid'} == $lead->id_PDG) {
																echo $value->name;
															}
														}
													} else {
														echo "";
													}
													?></td>
												<td><?= !empty($lead->status_pgd) ? status_pgd((int)$lead->status_pgd, false) : status_pgd_old((int)$lead->status_pgd) ?></td>
												<td><?php

													if (!empty($lead->status_pgd)) {

														if ($lead->status_pgd == 16 && !empty($lead->reason_cancel_pgd)) {
															echo $reason_cancel_pgd;
														} else if ($lead->status_pgd == 17 && !empty($lead->reason_process)) {
															echo reason_process((int)$lead->reason_process);
														} else if ($lead->status_pgd == 8 && !empty($lead->reason_return)) {
															echo reason_return((int)$lead->reason_return);
														} else {
															echo '';
														}
													} else {
														echo '';
													}
													?></td>
												<td><?= !empty($lead->status_contract) ? contract_status((int)$lead->status_contract, false) : (!empty($lead->status_lead) ? $lead->status_lead : "");
													if (!empty($lead->id_contract) || !empty($lead->id_contract_1)) {
														?><br>
														<a href="
												    <?php if (!empty($lead->id_contract)) {
															echo base_url("/pawn/detail?id=") . $lead->id_contract;
														} elseif (!empty($lead->id_contract_1)) {
															echo base_url("/pawn/detail?id=") . $lead->id_contract_1;
														}

														?>" target="_blank" class="dropdown-item yeu_cau_giai_ngan"> Xem
															chi tiết</a>
													<?php } ?>
												</td>


												<?php (!empty($lead->source)) ? $nguon = lead_nguon($lead->source) : $nguon = "" ?>

												<?php
												if ($nguon == ""){
													$nguon = lead_nguon_pgd($lead->source);
												}
												?>
												<td><?= (!empty($nguon)) ? $nguon : "" ?></td>


												<td><?= !empty($lead->utm_source) ? $lead->utm_source : "" ?></td>
												<td><?= !empty($lead->utm_campaign) ? implode("<br>", str_split($lead->utm_campaign, 20)) : '' ?></td>
												<td><?= (!empty($lead->customer_identity_card)) ? $lead->customer_identity_card : "" ?></td>
												<td><?= (!empty($lead->customer_card)) ? $lead->customer_card : "" ?></td>
												<td><?= (!empty($lead->customer_phone_introduce)) ? $lead->customer_phone_introduce : "" ?></td>
												<td><?= !empty($lead->confirm) ? $lead->confirm : "" ?></td>
												<td class="text-right">
													<a href="javascript:void(0)"
													   onclick="return_cskh('<?= $lead->_id->{'$oid'} ?>')"
													   class="btn btn-info callmodal">
														Trả lại CSKH
													</a></td>
												<td class="hide-show-loan-products"><?= !empty($lead->type_finance) ? lead_type_finance($lead->type_finance) : '' ?></td>
												<td class="hide-show-position"><?= !empty($lead->position) ? ($lead->position) : '' ?></td>
												<td class="hide-show-identify"><?= !empty($lead->identify_lead) ? $lead->identify_lead : '' ?></td>
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

<div class="modal fade" id="tab001_noteModal_office" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<?php $this->load->view('page/lead/modal_call_office'); ?>
</div>
<?php $this->load->view('page/lead/modal_chage_cvkd_pgd'); ?>
<div class="modal fade" id="addNewPGDModal" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-PGD" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center">Thêm mới khách hàng</h3>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" value="" name="_id"/>
						<div class="form-group">
							<label class="control-label col-md-3">Họ và Tên <span class="text-danger">*</span></label>
							<div class="col-xs-12 col-md-9">
								<input name="customer_fullname" placeholder="Họ và tên khách hàng" class="form-control"
									   type="text">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Số điện thoại <span
										class="text-danger">*</span></label>
							<div class="col-xs-12 col-md-9">
								<input maxlength="10" name="customer_phone" placeholder="Số điện thoại"
									   class="form-control"
									   type="text">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">CMND </label>
							<div class="col-xs-12 col-md-9">
								<input maxlength="9" name="customer_identity_card" placeholder="Số chứng minh nhân dân"
									   class="form-control"
									   type="text">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Thẻ căn cước </label>
							<div class="col-xs-12 col-md-9">
								<input maxlength="12" name="customer_card" placeholder="Số thẻ căn cước"
									   class="form-control"
									   type="text">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Giới tính <span class="text-danger">*</span></label>

							<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 ">
								<label><input name='customer_gender' value="1" type="radio"
											  checked>&nbsp;<?= $this->lang->line('male') ?></label>
								<label><input name='customer_gender' value="2"
											  type="radio">&nbsp;<?= $this->lang->line('Female') ?></label>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3">Nguồn</label>
							<div class="col-xs-12 col-md-9">
								<div class="row">
									<div class="col-md-8">
										<select name="customer_source" class="form-control" id="change_source">
											<?php
											foreach (lead_nguon_pgd() as $key => $obj) { ?>
												<option id="option_change" class="form-control"
														value="<?= $key ?>"><?= $obj ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-xs-12 col-md-4">
										<input style="display: none" id="11" maxlength="10"
											   name="customer_phone_introduce" placeholder="SĐT khách giới thiệu"
											   class="form-control"
											   type="text">
									</div>
								</div>
								<span class="help-block"></span>
							</div>
						</div>
						<div class="row ">
							<div style="text-align: center" id="group-button" class="col-xs-12 col-md-12">
								<button type="button" id="customer_pgdSave" class="btn btn-info">Lưu</button>
								<button type="button" class="btn btn-primary close-PGD" data-dismiss="modal"
										aria-label="Close">
									Thoát
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<script src="<?php echo base_url(); ?>assets/js/lead/index.js?v=" <?php echo time();?>></script>
<script type="text/javascript">

</script>

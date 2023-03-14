<!-- page content -->
<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	//	$code_store = !empty($_GET['code_store']) ? $_GET['code_store'] : array();
	$status_sale = !empty($_GET['status_sale']) ? $_GET['status_sale'] : "";
	$area = !empty($_GET['area']) ? $_GET['area'] : "";
	$phone_number = !empty($_GET['phone_number']) ? $_GET['phone_number'] : "";
	$tab = !empty($_GET['tab']) ? $_GET['tab'] : "lead";
	//	var_dump($code_store); die;
	$code_store = array();
	$url_code_store = "";
	$status_pgd = !empty($_GET['status_pgd']) ? $_GET['status_pgd'] : "";
	if (is_array($_GET['code_store'])) {
		foreach ($_GET['code_store'] as $code) {
			array_push($code_store, $code);
			$url_code_store .= '&code_store[]=' . $code;
		}
	}
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
						<h3>Danh sách lead chuyển về PGD(MKT)
							<br>
							<small>
								<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a href="#>">Danh
									sách lead chuyển về PGD(MKT)</a>
							</small>
						</h3>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="clearfix"></div>
				<div class="x_content">
					<div class="row">
						<div class="col-xs-12">
							<div class="row">
								<form action="<?php echo base_url('lead_custom/mkt_list_transfe_office') ?>"
									  method="get" style="width: 100%;">
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
										<label>Khu vực</label>
										<select class="form-control" name="area_search" id="">
											<option value="">Chọn khu vực</option>
											<?php $area_search = isset($_GET['area_search']) ? $_GET['area_search'] : '';
											foreach ($getArea as $key => $item) { ?>
												<?php if($item->code == 'Priority'){
													continue;
												} ?>
												<option <?php echo $area_search == $item->code ? 'selected' : '' ?>
													value="<?= $item->code ?>"><?= $item->title ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-xs-12 col-lg-2">
										<label>Tỉnh/Thành Phố</label>
										<select class="form-control" name="area" id="selectize_area">
											<option value="">Chọn tỉnh/thành phố</option>
											<?php $area = isset($_GET['area']) ? $_GET['area'] : '';
											foreach ($provinces as $key => $item) { ?>
												<option <?php echo $area == $item->code ? 'selected' : '' ?>
														value="<?= $item->code ?>"><?= $item->name ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-xs-12 col-lg-2">
										<div class="form-group">
											<label>UTM source</label>
											<?php $utm_source = isset($_GET['utm_source']) ? $_GET['utm_source'] : ''; ?>
											<input name="utm_source" placeholder="Nhập utm_source"
												   value="<?= $utm_source ?>" class="form-control" type="text">
										</div>
									</div>
									<div class="col-xs-12 col-lg-2">
										<div class="form-group">
											<label>UTM campaign</label>
											<?php $utm_campaign = isset($_GET['utm_campaign']) ? $_GET['utm_campaign'] : ''; ?>
											<input name="utm_campaign" placeholder="Nhập utm_campaign"
												   value="<?= $utm_campaign ?>" class="form-control" type="text">
										</div>
									</div>
									<div class="col-xs-12 col-lg-2">
										<div class="form-group">
											<label>Số điện thoại</label>
											<?php $phone_number = isset($_GET['phone_number']) ? $_GET['phone_number'] : ''; ?>
											<input name="phone_number" placeholder="Nhập phone"
												   value="<?= $phone_number ?>"
												   class="form-control" type="text">
										</div>
									</div>
									<div class="col-xs-12 col-lg-2">
										<label>Chọn phòng giao dịch</label>
										<select id="selectize_store" class="form-control" name="code_store[]"
												multiple="multiple">
											<option value="">Chọn PGD</option>
											<?php foreach ($storeData as $p) {
												if (is_array($stores) && !empty($stores)) {
													if (!in_array($p->id, $stores))
														continue;
												}

												?>
												<option <?php if (is_array($code_store)) {
													echo in_array($p->id, $code_store) ? 'selected' : '';
												} ?> value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-xs-12 col-lg-2">
										<label>Chọn trạng thái lead</label>
										<select class="form-control" name="status_pgd">
											<option value="">Chọn trạng thái lead</option>
											<option value="18">Lead có HĐ</option>
										</select>
									</div>

									<div class="col-xs-12 col-lg-1">
										<label>&nbsp;</label>
										<button type="submit" class="btn btn-primary w-100"><i class="fa fa-search"
																							   aria-hidden="true"></i> <?= $this->lang->line('search') ?>
										</button>
									</div>
									<div class="col-xs-12 col-lg-1">
										<label>&nbsp;</label>
										<a style="background-color: #18d102;"
										   href="<?= base_url() ?>excel/exportListLeadMKT?fdate=<?= $fdate . '&tdate=' . $tdate . $url_code_store . '&phone_number=' . $phone_number . '&area=' . $area . '&area_search=' . $area_search?>"
										   class="btn btn-primary w-100" target="_blank"><i class="fa fa-file-excel-o"
																							aria-hidden="true"></i>&nbsp;
											Xuất excel</a>
									</div>
								</form>
								<div class="col-xs-12 col-lg-2">
									<div>&nbsp;</div>
									<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"
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
												<label class="custom-control-label">NGÀY THÁNG</label>
											</div>
										</a>
										<a class="dropdown-item">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input"
													   data-control-column="3" checked="checked">
												<label class="custom-control-label">CSKH</label>
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
												<label class="custom-control-label">LÝ DO HỦY</label>
											</div>
										</a>
										<a class="dropdown-item">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input"
													   data-control-column="10" checked="checked">
												<label class="custom-control-label">PGD GHI CHÚ</label>
											</div>
										</a>
										<a class="dropdown-item" href="#">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input"
													   data-control-column="11" checked="checked">
												<label class="custom-control-label">NGUỒN</label>
											</div>
										</a>
										<a class="dropdown-item">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input"
													   data-control-column="12" checked="checked">
												<label class="custom-control-label">UTM SOURCE</label>
											</div>
										</a>
										<a class="dropdown-item">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input"
													   data-control-column="13" checked="checked">
												<label class="custom-control-label">UTM CAMPAIGN</label>
											</div>
										</a>
										<a class="dropdown-item">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input"
													   data-control-column="14" checked="checked">
												<label class="custom-control-label">TRẠNG THÁI HỢP ĐỒNG GN</label>
											</div>
										</a>
										<a class="dropdown-item" href="#">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input"
													   data-control-column="15" checked="checked">
												<label class="custom-control-label">SỐ TIỀN GN</label>
											</div>
										</a>
										<a class="dropdown-item" href="#">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input"
													   id="show-hide-loan-products" data-control-column="17"
													   checked="checked">
												<label class="custom-control-label">SẢN PHẨM VAY</label>
											</div>
										</a>
										<a class="dropdown-item" href="#">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input"
													   id="show-hide-position" data-control-column="18"
													   checked="checked">
												<label class="custom-control-label">VỊ TRÍ/CHỨC VỤ</label>
											</div>
										</a>
										<a class="dropdown-item" href="#">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input"
													   id="show-hide-identify" data-control-column="19"
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
										<th>NGÀY THÁNG</th>
										<th>CSKH</th>
										<th>HỌ VÀ TÊN</th>
										<th>SỐ ĐIỆN THOẠI</th>
										<th>CHUYỂN ĐẾN PGD</th>
										<th>TRẠNG THÁI PGD</th>
										<th>TÌNH TRẠNG LEAD</th>
										<th>TRẠNG THÁI SALE</th>
										<th>LÝ DO HỦY</th>
										<th>PGD GHI CHÚ</th>
										<th>NGUỒN</th>
										<th>UTM SOURCE</th>
										<th>UTM CAMPAIGN</th>
										<th>TRẠNG THÁI HỢP ĐỒNG GN</th>
										<th>SỐ TIỀN GN</th>
										<th>SẢN PHẨM VAY</th>
										<th>VỊ TRÍ/CHỨC VỤ</th>
										<th class="show-hide-identify">CMND/CCCD</th>
										<th>CVKD</th>

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

												<td><?= !empty($lead->office_at) ? date('d/m/Y H:i:s', $lead->office_at) : date('d/m/Y H:i:s', $lead->updated_at) ?></td>
												<td><?= ($lead->cskh) ? $lead->cskh : '' ?></td>
												<td><?= ($lead->fullname) ? wordwrap($lead->fullname, 27, "<br>\n") : '' ?></td>
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
												<td><?= ($lead->status_pgd) ? status_pgd((int)$lead->status_pgd) : status_pgd(0) ?></td>
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
												<td><?= ($lead->status_sale) ? lead_status((int)$lead->status_sale, false) : "" ?></td>
												<td><?= ($lead->reason_cancel) ? reason((int)$lead->reason_cancel, false) : "" ?></td>
												<td><?= ($lead->pgd_note) ? (wordwrap($lead->pgd_note, 30, "<br>\n")) : "" ?></td>
												<td><?= ($lead->source) ? lead_nguon($lead->source) : '' ?></td>
												<td><?= ($lead->utm_source) ? $lead->utm_source : "" ?></td>
												<td><?= !empty($lead->utm_campaign) ? implode("<br>", str_split($lead->utm_campaign, 20)) : '' ?></td>

												<td class="hide-show-contract-status">
													<?= !empty($lead->status_contract) ? contract_status((int)$lead->status_contract, false) : (!empty($lead->status_lead) ? $lead->status_lead : "");
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

												<td><?= (!empty($lead->contractInfo->loan_infor->amount_loan) && (!empty($lead->contractInfo->status) && $lead->contractInfo->status > 16)) ? $lead->contractInfo->loan_infor->amount_loan : '' ?></td>
												<td class="hide-show-loan-products"><?= !empty($lead->type_finance) ? lead_type_finance($lead->type_finance) : '' ?></td>
												<td class="hide-show-position"><?= !empty($lead->position) ? ($lead->position) : '' ?></td>
												<td class="hide-show-identify"><?= !empty($lead->identify_lead) ? $lead->identify_lead : '' ?></td>
												<td><?= !empty($lead->cvkd) ? $lead->cvkd : '' ?></td>
											</tr>


										<?php }
									} ?>
									</tbody>
									<?php echo "Tổng tiền giải ngân: " . number_format($leadTotalMkt) . "<br>" ?>
									<?php echo "Tiền giải ngân: " . number_format($leadTotalMkt1) ?>
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

<script src="<?php echo base_url(); ?>assets/js/lead/index.js"></script>
<script type="text/javascript">

</script>

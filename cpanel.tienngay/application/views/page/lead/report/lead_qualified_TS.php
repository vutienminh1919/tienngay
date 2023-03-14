<!-- page content -->
<?php if ($userSession['is_superadmin'] == 1 || in_array("60d4247f5324a7370d5e4cc3", $userRoles->role_access_rights)) { ?> ?>
<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$reason_cancel = !empty($_GET['reason_cancel']) ? $_GET['reason_cancel'] : "";
	$status = !empty($_GET['status']) ? $_GET['status'] : "";
	$store = !empty($_GET['store']) ? $_GET['store'] : "";
	$sdt = !empty($_GET['sdt']) ? $_GET['sdt'] : "";
	$tab = !empty($_GET['tab']) ? $_GET['tab'] : "not_qualified";

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
						<h3>Báo cáo Lead TS
							<br>
							<small>
								<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
										href="#>">Báo cáo Lead TS</a>
							</small>
						</h3>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<div class="row">
						<div class="col-xs-12">
							<div class="row">
								<div class="col-xs-12 col-md-3"></div>
								<div class="col-xs-12 col-md-3"></div>
								<div class="col-xs-12 col-md-6 text-right">
									<div class="dropdown" style="display:inline-block">
										<?php if (in_array($tab, ["not_qualified", "qualified"])) { ?>
										<button id="btnExport" class="btn btn-primary" onclick="fnExcelReportTS();"> Export </button>
										<?php } else {?>
											<a href="<?= base_url() ?>excel/exportLeadTS?<?= 'fdate=' . $fdate . '&tdate=' . $tdate . '&sdt=' . $sdt . '&fullname=' . $fullname . '&source_s=' . $source . '&status=' . $status . '&reason_cancel=' . $reason_cancel . '&tab=' . $tab ?>"
											   class="btn btn-info" target="_blank">
												Xuất Excel
											</a>
										<?php } ?>
										<button class="btn btn-success dropdown-toggle"
												onclick="$('#lockdulieu').toggleClass('show');">
											<span class="fa fa-filter"></span>
											Lọc dữ liệu
										</button>
										<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
											style="padding:15px;width:550px;max-width: 85vw;">
											<div class="row">
												<form action="<?php echo base_url('lead_custom/lead_qualified_TS') ?>" method="get"
													  style="width: 100%">
													<div class="col-xs-12 col-md-6">
														<input type="hidden" name="tab" class="form-control"
															   value="<?= !empty($tab) ? $tab : "" ?>">
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
													<?php if (in_array($tab, ["not_qualified", "list_not_qualified"])) { ?>
														<div class="col-xs-12 col-md-6">
															<label>Lý do Hủy</label>
															<select class="form-control" name="reason_cancel">
																<option value=""><?= $this->lang->line('All') ?></option>
																<?php  $reason_cancel = isset($_GET['reason_cancel']) ? $_GET['reason_cancel'] : '-';
                    													$reason_cancel = ($reason_cancel == "") ? "-" : $reason_cancel;?>
																<?php foreach (reason() as $key => $item) {
																	if (!in_array($key, [5, 7, 8, 9, 10, 12, 13, 15, 34, 41, 50])) continue; ?>
																	<option <?php echo $reason_cancel == $key ? 'selected' : '' ?>
																			value="<?= $key ?>"><?= $item ?></option>
																<?php } ?>
															</select>
														</div>
													<?php } ?>
													<?php if (in_array($tab,["qualified","list_qualified"])) { ?>
														<div class="col-xs-12 col-md-6">
															<label>Trạng thái lead</label>
															<select class="form-control" name="status">
																<option value=""><?= $this->lang->line('All') ?></option>
																<?php foreach (lead_status() as $key => $item) {
																	if (in_array($key, [1])) continue;
																	?>
																	<option <?php echo $status == $key ? 'selected' : '' ?>
																			value="<?= $key ?>"><?= $item ?></option>
																<?php } ?>
															</select>
														</div>
														<div class="col-xs-12 col-md-6">
															<label>Lý do Hủy</label>
															<select class="form-control" name="reason_cancel">
																<option value=""><?= $this->lang->line('All') ?></option>
																<?php foreach (reason() as $key => $item) {
																	if (in_array($key, [5, 7, 8, 9, 10, 12, 13, 15, 34, 41, 50])) continue;
																	?>
																	<option <?php echo $reason_cancel == $key ? 'selected' : '' ?>
																			value="<?= $key ?>"><?= $item ?></option>
																<?php } ?>
															</select>
														</div>
													<?php } ?>
													<div class="col-xs-12 col-md-6">
														<label>&nbsp;</label>
														<button class="btn btn-primary w-100"><i class="fa fa-search"
																								 aria-hidden="true"></i>
															Tìm kiếm
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
								</div>
							</div>
						</div>
						<div class="col-xs-12">
							<div class="group-tabs" style="width: 100%;">
								<ul class="nav nav-pills">
									<li class="<?= ($tab == 'not_qualified') ? 'active' : '' ?>">
										<a href="<?php echo base_url(); ?>lead_custom/lead_qualified_TS?tab=not_qualified">BC Lead không đủ ĐK</a>
									</li>
									<li class="<?= ($tab == 'qualified') ? 'active' : '' ?>">
										<a href="<?php echo base_url(); ?>lead_custom/lead_qualified_TS?tab=qualified">BC Lead TS Qualified</a>
									</li>
									<li class="<?= ($tab == 'list_not_qualified') ? 'active' : '' ?>">
										<a href="<?php echo base_url(); ?>lead_custom/lead_qualified_TS?tab=list_not_qualified">DS Lead không đủ ĐK</a>
									</li>
									<li class="<?= ($tab == 'list_qualified') ? 'active' : '' ?>">
										<a href="<?php echo base_url(); ?>lead_custom/lead_qualified_TS?tab=list_qualified">DS Lead TS Qualified</a>
									</li>
								</ul>
								<div class="tab-content">
									<div role="tabpanel"
										 class="tab-pane <?= ($tab == 'not_qualified') ? 'active' : '' ?>"
										 id="vi">
										<br/>
										<?php if ($tab == 'not_qualified') { ?>
											<div class="table-responsive" style="width: 100%">
												<table id="datatable-button" class="table table-bordered m-table table-hover table-calendar table-report ">
													<thead style="background:#3f86c3; color: #ffffff;">
													<tr>
														<th>STT</th>
														<th>Lý do hủy</th>
														<th>Số lượng Lead</th>
														<th>Tỷ lệ</th>
														<th>Danh sách Lead</th>
													</tr>

													</thead>
													<tbody>
													<?php if (!empty($leadTSData)) : ?>
														<?php $n = 0; ?>
														<?php foreach ($leadTSData as $key => $value) { ?>
															<tr>
																<td><?php echo ++$n;?></td>
																<td><?= !empty($value->reason) ? $value->reason : "";?></td>
																<td><?= !empty($value->lead_cancel) ? $value->lead_cancel : 0;?></td>
																<td><?= ($value->total_lead_cancel == '0') ? 0 : round((($value->lead_cancel / $value->total_lead_cancel) * 100), 2) . " %";?></td>
																<td>
																	<a href="<?php echo base_url("lead_custom/lead_qualified_TS?tab=list_not_qualified&fdate=&tdate=&reason_cancel="). $value->key_reason?>" 
																	   target="_blank"
																	   style="color: blue">Xem chi tiết
																	</a>
																</td>
															</tr>
														<?php } ?>
													<?php endif; ?>
													</tbody>
													<tfoot>
													<tr>
														<th colspan="2" style="text-align: center">Tổng</th>
														<td><?php foreach ($leadTSData as $leadTSDatum) {
																echo "<span class='text-danger'>$leadTSDatum->total_lead</span>" ; break;
															} ;?>
														</td>
														<td><?php
															$total_percent_not_qualified = 0;
															foreach ($leadTSData as $leadTSDatum) {
																$total_percent_not_qualified += round((($leadTSDatum->lead_cancel / $leadTSDatum->total_lead_cancel) * 100),2);
															}
															$total_percent_not_qualified = round($total_percent_not_qualified);
															echo "<span class='text-danger'>$total_percent_not_qualified  % </span>";
															?>
														</td>
													</tr>
													</tfoot>
												</table>
											</div>
										<?php } ?>
									</div>
									<div role="tabpanel" class="tab-pane <?= ($tab == 'qualified') ? 'active' : '' ?>"
										 id="vi">
										<br/>
										<?php if ($tab == 'qualified') { ?>
											<div class="row">
												<div class="col-xs-12 col-md-10 ">
													&nbsp;
												</div>
												<div class="col-xs-12 col-md-2">
													<?php
													$money = 0;
													foreach ($leadTSData as $key => $value) {
														$money = $value->total_lead * 100000;
														echo "<b>TỔNG TIỀN PHẢI TRẢ:  </b> ". number_format($money) . ' đồng' ; break;
													}
													?>
												</div>
											</div>
											<br>
											<div class="table-responsive" style="width: 100%">
												<table id="datatable-button" class="table table-bordered m-table table-hover table-calendar table-report datatable-buttons">
													<thead style="background:#3f86c3; color: #ffffff;">
													<tr>
														<th>STT</th>
														<th></th>
														<th>Trạng thái</th>
														<th>Lý do Hủy</th>
														<th>Số lượng Lead</th>
														<th>Tỷ lệ</th>
														<th>Danh sách Lead</th>
													</tr>
													</thead>
													<tbody>
													<?php $m = 1; $o = 1; $y = 1; ?>
													<?php if (!empty($leadTSData)) : ?>
														<?php $n = 0; ?>
														<?php foreach ($leadTSData as $key => $value) { ?>
															<tr data-id="<?= $m++;?>" data-parent="0">
																<td><?php echo ++$n;?></td>
																<td data-column="name"></td>
																<td><?= !empty($value->status) ? $value->status : "";?></td>
																<td></td>
																<td><?= !empty($value->status_sale) ? $value->status_sale : "";?></td>
																<td><?= ($value->total_lead == '0') ? 0 : round((($value->status_sale / $value->total_lead) * 100),2) . " %";?></td>
																<td>
																	<a href="<?php echo base_url("lead_custom/lead_qualified_TS?tab=list_qualified&fdate=&tdate=&status="). $value->key_status;?>"
																	   target="_blank"
																	   style="color: blue">Xem chi tiết
																	</a>
																</td>
															</tr>
															<?php $y = $m; $n1 = 0;?>
															<?php if ($value->status == "Hủy") {
																foreach ($qualified_cancel as $key1 => $item) { ?>
															<tr data-id="<?= (int)$m++;?>" data-parent="<?= (int)($y-1);?>">
																<td></td>
																<td data-column="name"></td>
																<td></td>
																<td><span class="size_col_mkt">
																		<?= !empty($item->reason) ? $item->reason : "";?>
																	</span>
																</td>
																<td><?=!empty($item->lead_cancel) ? $item->lead_cancel : "";?></td>
																<td><?= ($item->total_lead == '0') ? 0 : round((($item->lead_cancel / $item->total_lead) * 100),2) . " %";?></td>
																<td>
																	<a href="<?php echo base_url("lead_custom/lead_qualified_TS?tab=list_qualified&fdate=&tdate=&status="). $item->key_status . "&reason_cancel=" . $item->key_reason;?>" 
																	   target="_blank"
																	   style="color: blue">Xem chi tiết
																	</a>
																</td>
															</tr>
														<?php } } }?>
													<?php endif; ?>
													</tbody>
													<tfoot>
													<tr>
														<th colspan="4" style="text-align: center">Tổng</th>
														<td><?php foreach ($leadTSData as $leadTSDatum) {
																echo "<span class='text-danger'>$leadTSDatum->total_lead</span>"; break;
														} ;?>
														</td>
														<td><?php
															$total_percent = 0;
															foreach ($leadTSData as $leadTSDatum) {
																$total_percent += round((($leadTSDatum->status_sale / $leadTSDatum->total_lead) * 100),2);
															}
															$total_percent = round($total_percent);
															echo  "<span class='text-danger'>$total_percent %</span>";
															?>
														</td>
													</tr>
													</tfoot>
												</table>
											</div>
										<?php } ?>
									</div>

									<div role="tabpanel"
										 class="tab-pane <?= ($tab == 'list_not_qualified') ? 'active' : '' ?>"
										 id="vi">
										<br/>
										<?php if ($tab == 'list_not_qualified') { ?>
											<div class="table-responsive" style="width: 100%">
												<div><?php echo $result_count; ?></div>
												<table id="datatable-button" class="table table-bordered m-table table-hover table-calendar table-report ">
													<thead style="background:#3f86c3; color: #ffffff;">
													<tr>
														<th>#</th>
														<th>THAO TÁC</th>
														<th class="hide-show-date-lead">NGÀY THÁNG</th>
														<th>HỌ VÀ TÊN</th>
														<th>SỐ ĐIỆN THOẠI</th>
														<th>SĐT NGƯỜI GIỚI THIỆU</th>
														<th class="hide-show-source">NGUỒN</th>
														<th class="hide-show-utm-source">UTM_Source</th>
														<th class="hide-show-utm-campaign">UTM_Campaign</th>
														<th class="hide-show-lead-status-all">TRẠNG THÁI LEAD</th>
														<th class="hide-show-reason-cancel">LÝ DO HỦY</th>
														<th class="hide-show-store">CHUYỂN ĐẾN PGD</th>
														<th class="hide-show-status-store">TRẠNG THÁI PGD</th>
														<th>TÌNH TRẠNG LEAD PGD</th>
														<th>SẢN PHẨM VAY</th>
														<th class="show-hide-identify">CMND/CCCD</th>
													</tr>
													</thead>
													<tbody name="list_lead">
													<?php
													if (!empty($leadsData)) {
														$n = 1;
														$userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
														foreach ($leadsData as $key => $lead) {
															$cskh_one = !empty($lead->cskh) ? $lead->cskh : '';
															$reason_cancel_pgd ="";
															if (!empty($reasonData))
																foreach ($reasonData as $reason) {
																	if ( $lead->reason_cancel_pgd == $reason->code_reason) {
																		$reason_cancel_pgd = $reason->reason_name;
																	}
																}
															?>
																<tr>
																	<td><?php echo $n++ ?></td>
																	<td class="text-right">
																		<a href="javascript:void(0)" onclick="showModal('<?= $lead->id;?>')"
																		   class="btn btn-info btn-sm callmodal">
																			Gọi
																		</a>
																		<!--        <a class="btn btn-info "
                onclick="window.location.href='<?= base_url("lead_custom/displayUpdate?id=") . getId($lead->_id) ?>'">
               Chi Tiết
            </a>  -->
																		<!--  <a class="btn btn-success " target="_blank" href="<?php echo base_url(); ?>pawn/createContract?id_lead=<?= $lead->_id->{'$oid'} ?>" >
              <i class="fa fa-plus" aria-hidden="true"></i> Tạo hợp đồng
            </a>   -->
																	</td>
																	<td class="hide-show-date-lead"><?= !empty($lead->created_at) ? date('d/m/Y H:i:s', $lead->created_at) : "" ?></td>
																	<td><?= ($lead->fullname) ? wordwrap($lead->fullname, 27, "<br>\n") : '' ?></td>
																	<td><?= !empty($lead->phone_number) ? hide_phone($lead->phone_number) : "" ?><br>
																		<a href="javascript:void(0)" onclick="showLeadLog('<?= $lead->id;?>')"
																		   class="btn btn-info btn-sm">
																			LeadLog
																		</a>
																	</td>
																	<td class=""><?= !empty($lead->customer_phone_introduce) ? $lead->customer_phone_introduce : ""  ?></td>
																	<td class="hide-show-source"><?= !empty($lead->source) ? lead_nguon($lead->source) : '' ?></td>
																	<td class="hide-show-utm-source"><?= !empty($lead->utm_source) ? $lead->utm_source : "" ?></td>
																	<td class="hide-show-utm-campaign"><?= !empty($lead->utm_campaign) ? implode("<br>", str_split($lead->utm_campaign, 20)) : '' ?></td>
																	<td class="hide-show-lead-status-all"><?= !empty($lead->status_sale) ? lead_status((int)$lead->status_sale, false) : lead_status(0) ?></td>
																	<td class="hide-show-reason-cancel"><?= !empty($lead->reason_cancel) ? reason($lead->reason_cancel, false) : '' ?></td>
																	<td class="hide-show-store"><?php if (!empty($lead->id_PDG)) {
																			foreach ($storeData as $key => $value) {
																				if ($value->_id->{'$oid'} == $lead->id_PDG) {
																					echo $value->name;
																				}
																			}
																		} else {
																			echo "";
																		}
																		?></td>
																	<td class="hide-show-status-store"><?= !empty($lead->status_pgd) ? status_pgd($lead->status_pgd) : "" ?></td>
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
																	<td class="hide-show-loan-products"><?= !empty($lead->type_finance) ? lead_type_finance($lead->type_finance) : '' ?></td>
																	<td class="hide-show-identify"><?= !empty($lead->identify_lead) ? $lead->identify_lead : '' ?></td>
																</tr>
															<?php 
														} ?>
													<?php } ?>
													</tbody>
												</table>
												<div class="pagination pagination-sm">
													<?php echo $pagination ?>
												</div>
											</div>
										<?php } ?>
									</div>
									<div role="tabpanel" class="tab-pane <?= ($tab == 'list_qualified') ? 'active' : '' ?>"
										 id="vi">
										<br/>
										<?php if ($tab == 'list_qualified') { ?>
											<div class="table-responsive" style="width: 100%">
												<div><?php echo $result_count; ?></div>
												<table id="datatable-button" class="table table-bordered m-table table-hover table-calendar table-report datatable-buttons">
													<thead style="background:#3f86c3; color: #ffffff;">
													<tr>
														<th>#</th>
														<th>THAO TÁC</th>
														<th class="hide-show-date-lead">NGÀY THÁNG</th>
														<th>HỌ VÀ TÊN</th>
														<th>SỐ ĐIỆN THOẠI</th>
														<th>SĐT NGƯỜI GIỚI THIỆU</th>
														<th class="hide-show-source">NGUỒN</th>
														<th class="hide-show-utm-source">UTM_Source</th>
														<th class="hide-show-utm-campaign">UTM_Campaign</th>
														<th class="hide-show-lead-status-all">TRẠNG THÁI LEAD</th>
														<th class="hide-show-reason-cancel">LÝ DO HỦY</th>
														<th class="hide-show-store">CHUYỂN ĐẾN PGD</th>
														<th class="hide-show-status-store">TRẠNG THÁI PGD</th>
														<th>TÌNH TRẠNG LEAD PGD</th>
														<th>SẢN PHẨM VAY</th>
														<th class="show-hide-identify">CMND/CCCD</th>
													</tr>
													</thead>
													<tbody name="list_lead">
													<?php
													if (!empty($leadsData)) {
														$n = 1;
														$userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
														foreach ($leadsData as $key => $lead) {
															$cskh_one = !empty($lead->cskh) ? $lead->cskh : '';
															$reason_cancel_pgd ="";
															if (!empty($reasonData))
																foreach ($reasonData as $reason) {
																	if ( $lead->reason_cancel_pgd == $reason->code_reason) {
																		$reason_cancel_pgd = $reason->reason_name;
																	}
																}
															?>
															<tr>
																<td><?php echo $n++ ?></td>
																<td class="text-right">
																	<a href="javascript:void(0)" onclick="showModal('<?= $lead->id; ?>')"
																	   class="btn btn-info btn-sm callmodal">
																		Gọi
																	</a>
																	<!--        <a class="btn btn-info "
                onclick="window.location.href='<?= base_url("lead_custom/displayUpdate?id=") . getId($lead->_id) ?>'">
               Chi Tiết
            </a>  -->
																	<!--  <a class="btn btn-success " target="_blank" href="<?php echo base_url(); ?>pawn/createContract?id_lead=<?= $lead->_id->{'$oid'} ?>" >
              <i class="fa fa-plus" aria-hidden="true"></i> Tạo hợp đồng
            </a>   -->
																</td>
																<td class="hide-show-date-lead"><?= !empty($lead->created_at) ? date('d/m/Y H:i:s', $lead->created_at) : "" ?></td>
																<td><?= ($lead->fullname) ? wordwrap($lead->fullname, 27, "<br>\n") : '' ?></td>
																<td><?= !empty($lead->phone_number) ? hide_phone($lead->phone_number) : "" ?><br>
																	<a href="javascript:void(0)" onclick="showLeadLog('<?= $lead->id; ?>')"
																	   class="btn btn-info btn-sm">
																		LeadLog
																	</a>
																</td>
																<td class=""><?= !empty($lead->customer_phone_introduce) ? $lead->customer_phone_introduce : ""  ?></td>
																<td class="hide-show-source"><?= !empty($lead->source) ? lead_nguon($lead->source) : '' ?></td>
																<td class="hide-show-utm-source"><?= !empty($lead->utm_source) ? $lead->utm_source : "" ?></td>
																<td class="hide-show-utm-campaign"><?= !empty($lead->utm_campaign) ? implode("<br>", str_split($lead->utm_campaign, 20)) : '' ?></td>
																<td class="hide-show-lead-status-all"><?= !empty($lead->status_sale) ? lead_status((int)$lead->status_sale, false) : lead_status(0) ?></td>
																<td class="hide-show-reason-cancel"><?= !empty($lead->reason_cancel) ? reason($lead->reason_cancel, false) : '' ?></td>
																<td class="hide-show-store"><?php if (!empty($lead->id_PDG)) {
																		foreach ($storeData as $key => $value) {
																			if ($value->_id->{'$oid'} == $lead->id_PDG) {
																				echo $value->name;
																			}
																		}
																	} else {
																		echo "";
																	}
																	?></td>
																<td class="hide-show-status-store"><?= !empty($lead->status_pgd) ? status_pgd($lead->status_pgd) : "" ?></td>
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
																<td class="hide-show-loan-products"><?= !empty($lead->type_finance) ? lead_type_finance($lead->type_finance) : '' ?></td>
																<td class="hide-show-identify"><?= !empty($lead->identify_lead) ? $lead->identify_lead : '' ?></td>
															</tr>
															<?php
														} ?>
													<?php } ?>
													</tbody>
												</table>
												<div class="pagination pagination-sm">
													<?php echo $pagination ?>
												</div>
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /page content -->

			</div>
		</div>
	</div>
	<div class="modal fade" id="tab001_lead_log" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
		 aria-hidden="true">
		<?php $this->load->view('page/lead/modal_lead_log'); ?>
	</div>
	<div class="modal fade" id="tab001_noteModal" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
		 aria-hidden="true">
		<?php $this->load->view('page/lead/modal_call'); ?>
	</div>
	<div class="modal fade" id="tab006_recording" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
		 aria-hidden="true">
		<?php $this->load->view('page/lead/modal_recording'); ?>
	</div>
	<script src="<?php echo base_url(); ?>assets/js/lead/index.js"></script>
	<script type="text/javascript">
		$(document).ready(function () {
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
		});

		function fnExcelReportTS(e) {
			var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
			var textRange; var j=0;
			tab = document.getElementById('datatable-button'); // id of table

			for(j = 0 ; j < tab.rows.length ; j++)
			{
				tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
				//tab_text=tab_text+"</tr>";
			}

			tab_text=tab_text+"</table>";
			tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
			tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
			tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

			var ua = window.navigator.userAgent;
			var msie = ua.indexOf("MSIE ");

			if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
			{
				txtArea1.document.open("txt/html","replace");
				txtArea1.document.write(tab_text);
				txtArea1.document.close();
				txtArea1.focus();
				sa=txtArea1.document.execCommand("SaveAs",true,"data.xls");
			}
			else {
				var sa = document.createElement('a');
				var data_type = 'data:application/vnd.ms-excel';
				var table_html = encodeURIComponent(tab_text);
				sa.href = data_type + ', ' + table_html;
				let d = new Date();
				let ye = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(d);
				let mo = new Intl.DateTimeFormat('en', { month: 'numeric' }).format(d);
				let da = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(d);
				let str_date = `${da}_${mo}_${ye}`;
				<?php if ($tab == "not_qualified") { ?>
				sa.download = 'BC_LEAD_TS_NOT_QUALIFIED_'+ str_date +'.xls';
				<?php } else if ($tab == "qualified") { ?>
				sa.download = 'BC_LEAD_TS_QUALIFIED_'+ str_date +'.xls';
				<?php } ?>
				sa.click();
				e.preventDefault();
			}
			return (sa);
		}
	</script>


<?php } ?>

<br>
<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$sdt = !empty($_GET['sdt']) ? $_GET['sdt'] : "";
	$fullname = !empty($_GET['fullname']) ? $_GET['fullname'] : "";
	$cskh = !empty($_GET['cskh']) ? $_GET['cskh'] : "";
	$status_sale = !empty($_GET['status_sale_1']) ? $_GET['status_sale_1'] : "";
	$source = !empty($_GET['source_s']) ? $_GET['source_s'] : "";
	$priority = !empty($_GET['priority']) ? $_GET['priority'] : "";
	?>
<div class="row">
	<?php
		if (in_array("tbp-cskh", $groupRoles)) { ?>
			<div class="col-lg-2 text-right">
				<a style="background-color: #18d102;"
				target="_blank"
				href="<?= base_url() ?>excel/exportLeadPGDCancel?fdate=<?= $fdate . '&tdate=' . $tdate . '&fullname=' .$fullname . '&source_s=' .$source. "&cskh=" .$cskh. '&status_sale_1='.$status_sale. '&priority=' .$priority. '&sdt=' .$sdt?>"
				class="btn btn-primary w-100"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
					Xuất excel</a>
			</div>
		<?php }
	?>

	<div>
		<?php if ($this->session->flashdata('error')) { ?>
			<div class="alert alert-danger alert-result">
				<?= $this->session->flashdata('error') ?>
			</div>
		<?php } ?>
		<?php if ($this->session->flashdata('success')) { ?>
			<div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
		<?php } ?>
	</div>

	<div class="col-lg-2">
		<button class="btn btn-primary dropdown-toggle mr-4" type="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">Ẩn/Hiện cột
		</button>

		<div class="dropdown-menu">
			<a class="dropdown-item">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" data-control-column="1" checked="checked">
					<label class="custom-control-label" >STT</label>
				</div>
			</a>
			<a class="dropdown-item">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" data-control-column="2" checked="checked">
					<label class="custom-control-label" >CSKH</label>
				</div>
			</a>
			<a class="dropdown-item">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" data-control-column="3" checked="checked">
					<label class="custom-control-label" >NGÀY THÁNG</label>
				</div>
			</a>
			<a class="dropdown-item">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" data-control-column="4" checked="checked">
					<label class="custom-control-label" >NGUỒN</label>
				</div>
			</a>
			<a class="dropdown-item">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" data-control-column="5" checked="checked">
					<label class="custom-control-label" >UTM_Source</label>
				</div>
			</a>
			<a class="dropdown-item" href="#">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" data-control-column="6" checked="checked">
					<label class="custom-control-label">UTM_Campaign</label>
				</div>
			</a>
			<a class="dropdown-item">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" data-control-column="7" checked="checked">
					<label class="custom-control-label" >HỌ VÀ TÊN</label>
				</div>
			</a>
			<a class="dropdown-item" href="#">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" data-control-column="8" checked="checked">
					<label class="custom-control-label">SỐ ĐIỆN THOẠI</label>
				</div>
			</a>
			<a class="dropdown-item">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" data-control-column="9" checked="checked">
					<label class="custom-control-label" >TRẠNG THÁI LEAD</label>
				</div>
			</a>
			<a class="dropdown-item">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" data-control-column="10" checked="checked">
					<label class="custom-control-label" >LÝ DO HỦY TLS</label>
				</div>
			</a>
			<a class="dropdown-item" href="#">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-loan-products" data-control-column="12" checked="checked">
					<label class="custom-control-label">SẢN PHẨM VAY</label>
				</div>
			</a>
			<a class="dropdown-item" href="#">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-identify" data-control-column="18" checked="checked">
					<label class="custom-control-label">CMND/CCCD</label>
				</div>
			</a>
			<div class="dropdown-divider"></div>
		</div>
	</div>
</div>
<div class="table-responsive">
	<div><?php echo $result_count11; ?></div>
	<table class="table table-striped thedatatabl hide-show-column">
		<thead>
		<tr>
			<th>#</th>
			<!--  <th>THAO TÁC</th> -->
			<th>CSKH</th>
			<th class="hide-show-date-lead">NGÀY THÁNG</th>
			<th class="hide-show-source">NGUỒN</th>
			<th class="hide-show-utm-source">UTM_Source</th>
			<th class="hide-show-utm-campaign">UTM_Campaign</th>
			<th>HỌ VÀ TÊN</th>
			<th>SỐ ĐIỆN THOẠI</th>
			<th>SĐT NGƯỜI GIỚI THIỆU</th>
			<th class="hide-show-lead-status-all">TRẠNG THÁI LEAD</th>
			<th class="hide-show-reason-cancel">LÝ DO HỦY TLS</th>
			<th class="hide-show-note">GHI CHÚ PGD</th>
			<th class="hide-show-store">PGD LÝ DO HỦY</th>
			<th>SẢN PHẨM VAY</th>
			<th class="show-hide-identify">CMND/CCCD</th>
		</tr>
		</thead>
		<tbody name="list_lead">
		<?php
		$email_cskh = $userInfo['email'];
		if (!empty($leadsData11)) {
			$n = 1;
			$userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
			foreach ($leadsData11 as $key => $lead) {
				$cskh_one = !empty($lead->cskh) ? $lead->cskh : '';
				$reason_cancel_pgd = "";
				if (!empty($reasonData))
					foreach ($reasonData as $reason) {
						if ($lead->reason_cancel_pgd == $reason->code_reason) {
							$reason_cancel_pgd = $reason->reason_name;
						}
					}
				?>
				<?php if ($cskh_one == $userInfo["email"] ||  in_array('supper-admin', $groupRoles) || in_array("tbp-cskh", $groupRoles) || in_array("van-hanh", $groupRoles)) { ?>
				<tr>
					<td><?php echo $n++ ?></td>
					<!--   <td class="text-right">

             <a class="btn btn-info "
                 onclick="take_cskh(this)" data-email="<?= $email_cskh ?>" data-id="<?= $lead->_id->{'$oid'} ?>" >
               Nhận
            </a>
          </td> -->
					<td>
						<?php if (in_array('tbp-cskh', $groupRoles)) {
							?>
							<select class="form-control email_cskh" id="<?= $lead->_id->{'$oid'} ?>"
									data-id="<?= $lead->_id->{'$oid'} ?>" onchange="change_cskh(this)"
									style="min-width: 150px;">
								<option value="">Chọn CSKH</option>

								<?php if (!empty($cskhData)) {
									foreach ($cskhData as $key => $cskh) {
										foreach ($cskh as $key => $val) {
											?>
											<option <?= ($cskh_one == $val->email) ? "selected" : "" ?>
													value="<?= !empty($val->email) ? $val->email : ""; ?>"><?= !empty($val) ? $val->email : ""; ?></option>
										<?php }
									}
								} ?>
							</select>
						<?php } else { ?>

							<input id="<?= $lead->_id->{'$oid'} ?>" value="<?= $cskh_one; ?>" disabled></input>
						<?php } ?>
					</td>
					<td class="hide-show-date-lead"><?= !empty($lead->created_at) ? date('d/m/Y H:i:s', $lead->created_at) : "" ?></td>
					<td class="hide-show-source"><?= ($lead->source) ? lead_nguon($lead->source) : '' ?></td>
					<td class="hide-show-utm-source"><?= !empty($lead->utm_source) ? $lead->utm_source : '' ?></td>
					<td class="hide-show-utm-campaign"><?= !empty($lead->utm_campaign) ? implode("<br>", str_split($lead->utm_campaign, 20)) : '' ?></td>
					<td><?= !empty($lead->fullname) ? wordwrap($lead->fullname, 27, "<br>\n") : '' ?>
						<br>

					</td>
					<td><?= !empty($lead->phone_number) ? hide_phone($lead->phone_number) : "" ?></td>
					<td class=""><?= !empty($lead->customer_phone_introduce) ? $lead->customer_phone_introduce : ""  ?></td>
					<td class="hide-show-lead-status-all"><?= !empty($lead->status_sale) ? lead_status((int)$lead->status_sale, false) : lead_status(0) ?></td>
					<td class="hide-show-reason-cancel"><?= !empty($lead->reason_cancel) ? reason($lead->reason_cancel, false) : '' ?></td>
					<td class="hide-show-note"><?= !empty($lead->pgd_note) ? wordwrap($lead->pgd_note, 100, "<br>\n") : "" ?></td>
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
			<?php }
		} } ?>
		</tbody>
	</table>
	<div class="pagination pagination-sm">
		<?php echo $pagination11 ?>
	</div>
</div>


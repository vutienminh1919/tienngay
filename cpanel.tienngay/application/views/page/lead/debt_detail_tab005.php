<br>
<div class="row">
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
					<label class="custom-control-label" >THAO TÁC</label>
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
					<label class="custom-control-label" >HỌ VÀ TÊN</label>
				</div>
			</a>
			<a class="dropdown-item" href="#">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" data-control-column="5" checked="checked">
					<label class="custom-control-label">SỐ ĐIỆN THOẠI</label>
				</div>
			</a>
			<a class="dropdown-item">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" data-control-column="6" checked="checked">
					<label class="custom-control-label" >NGUỒN</label>
				</div>
			</a>
			<a class="dropdown-item">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" data-control-column="7" checked="checked">
					<label class="custom-control-label" >UTM_Source</label>
				</div>
			</a>
			<a class="dropdown-item" href="#">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" data-control-column="8" checked="checked">
					<label class="custom-control-label">UTM_Campaign</label>
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
					<label class="custom-control-label" >LÝ DO HỦY</label>
				</div>
			</a>
			<a class="dropdown-item">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" data-control-column="11" checked="checked">
					<label class="custom-control-label" >CHUYỂN ĐẾN PGD</label>
				</div>
			</a>
			<a class="dropdown-item" href="#">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" data-control-column="12" checked="checked">
					<label class="custom-control-label">TRẠNG THÁI PGD</label>
				</div>
			</a>
			<a class="dropdown-item" href="#">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" data-control-column="13" checked="checked">
					<label class="custom-control-label">TÌNH TRẠNG LEAD PGD</label>
				</div>
			</a>
			<a class="dropdown-item" href="#">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-loan-products" data-control-column="14" checked="checked">
					<label class="custom-control-label">SẢN PHẨM VAY</label>
				</div>
			</a>
			<a class="dropdown-item" href="#">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-identify" data-control-column="15" checked="checked">
					<label class="custom-control-label">CMND/CCCD</label>
				</div>
			</a>
			<div class="dropdown-divider"></div>
		</div>
	</div>
</div>
<div class="table-responsive">
	<div><?php echo $result_count5; ?></div>
	<table class="table table-striped thedatatabl hide-show-column">
		<thead>
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
		if (!empty($leadsData5)) {
			$n = 1;
			$userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
			foreach ($leadsData5 as $key => $lead) {
				$cskh_one = !empty($lead->cskh) ? $lead->cskh : '';
				$reason_cancel_pgd ="";
				if (!empty($reasonData))
					foreach ($reasonData as $reason) {
						if ( $lead->reason_cancel_pgd == $reason->code_reason) {
							$reason_cancel_pgd = $reason->reason_name;
						}
					}
				?>
				<?php if ($cskh_one == $userInfo["email"] ||  in_array('supper-admin', $groupRoles) || in_array("tbp-cskh", $groupRoles) || in_array("van-hanh", $groupRoles)) { ?>
				<tr>
					<td><?php echo $n++ ?></td>
					<td class="text-right">
						<a href="javascript:void(0)" onclick="showModal('<?= $lead->_id->{'$oid'} ?>')"
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
			<?php }
		} ?>
		<?php } ?>
		</tbody>
	</table>
	<div class="pagination pagination-sm">
		<?php echo $pagination5 ?>
	</div>
</div>


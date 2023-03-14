<br>
<div class="row">
	<div class="col-lg-2">
		<button class="btn btn-primary dropdown-toggle mr-4" type="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">Ẩn/Hiện cột
		</button>

		<div class="dropdown-menu">
			<a class="dropdown-item">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-date-lead" data-control-column="1" checked="checked">
					<label class="custom-control-label" >STT</label>
				</div>
			</a>
			<a class="dropdown-item">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-utm-source" data-control-column="2" checked="checked">
					<label class="custom-control-label" >THAO TÁC</label>
				</div>
			</a>
			<a class="dropdown-item" href="#">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-utm-campaign" data-control-column="3" checked="checked">
					<label class="custom-control-label">CSKH</label>
				</div>
			</a>
			<a class="dropdown-item">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-date-lead" data-control-column="4" checked="checked">
					<label class="custom-control-label" >Ngày tháng</label>
				</div>
			</a>
			<a class="dropdown-item">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-source" data-control-column="5" checked="checked">
					<label class="custom-control-label" >NGUỒN</label>
				</div>
			</a>
			<a class="dropdown-item">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-utm-source" data-control-column="6" checked="checked">
					<label class="custom-control-label" >UTM_Source</label>
				</div>
			</a>
			<a class="dropdown-item" href="#">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-utm-campaign" data-control-column="7" checked="checked">
					<label class="custom-control-label">UTM_Campaign</label>
				</div>
			</a>
			<a class="dropdown-item">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-utm-source" data-control-column="8" checked="checked">
					<label class="custom-control-label" >HỌ VÀ TÊN</label>
				</div>
			</a>
			<a class="dropdown-item" href="#">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-utm-campaign" data-control-column="9" checked="checked">
					<label class="custom-control-label">SỐ ĐIỆN THOẠI</label>
				</div>
			</a>
			<a class="dropdown-item">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-lead-status" data-control-column="10" checked="checked">
					<label class="custom-control-label" >TRẠNG THÁI LEAD</label>
				</div>
			</a>

			<a class="dropdown-item">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-lead-status" data-control-column="10" checked="checked">
					<label class="custom-control-label" >ĐỘ ƯU TIÊN</label>
				</div>
			</a>

			<a class="dropdown-item">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-reason-cancel" data-control-column="11" checked="checked">
					<label class="custom-control-label" >LÝ DO HỦY</label>
				</div>
			</a>
			<a class="dropdown-item">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-store" data-control-column="12" checked="checked">
					<label class="custom-control-label" >CHUYỂN ĐẾN PGD</label>
				</div>
			</a>
			<a class="dropdown-item" href="#">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-confirm" data-control-column="13" checked="checked">
					<label class="custom-control-label">XÁC NHẬN</label>
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
	<div><?php echo $result_count3; ?></div>
	<table class="table table-striped thedatatabl hide-show-column">
		<thead>
		<tr>
			<th>#</th>
			<th>THAO TÁC</th>
			<th style="width: 25%">CSKH</th>
			<th class="hide-show-date-lead">NGÀY THÁNG</th>
			<th class="hide-show-source">NGUỒN</th>
			<th class="hide-show-utm-source">UTM_Source</th>
			<th class="hide-show-utm-campaign">UTM_Campaign</th>
			<th>HỌ VÀ TÊN</th>
			<th>SỐ ĐIỆN THOẠI</th>
			<th>SĐT NGƯỜI GIỚI THIỆU</th>
			<th class="hide-show-lead-status-all">TRẠNG THÁI LEAD</th>
			<th class="hide-show-lead-status-all">ĐỘ ƯU TIÊN</th>
			<th class="hide-show-reason-cancel">LÝ DO HỦY</th>
			<th class="hide-show-store">CHUYỂN ĐẾN PGD</th>
			<th class="hide-show-confirm">XÁC NHẬN</th>
			<th>SẢN PHẨM VAY</th>
			<th>CMND/CCCD</th>
		</tr>
		</thead>
		<tbody name="list_lead">
		<?php
		if (!empty($leadsData3)) {
			$n = 1;
			$userInfo = !empty($this->session->userdata('user')) ? $this->session->userdata('user') : "";
			foreach ($leadsData3 as $key => $lead) {
				$cskh_one = !empty($lead->cskh) ? $lead->cskh : '';
				?>
				<tr>
					<td><?php echo $n++ ?></td>
					<td class="text-right">
						<a href="javascript:void(0)" onclick="showModal('<?= $lead->_id->{'$oid'} ?>')"
						   class="btn btn-info btn-sm callmodal">
							Gọi
						</a>
					</td>
					<td> <?= $cskh_one ?></td>
					<td class="hide-show-date-lead"><?= !empty($lead->created_at) ? date('d/m/Y H:i:s', $lead->created_at) : "" ?></td>
					<td class="hide-show-source"><?= !empty($lead->source) ? lead_nguon($lead->source) : '' ?></td>
					<td class="hide-show-utm-source"><?= !empty($lead->utm_source) ? $lead->utm_source : '' ?></td>
					<td class="hide-show-utm-campaign"><?= !empty($lead->utm_campaign) ? implode("<br>", str_split($lead->utm_campaign, 20)) : '' ?></td>
					<td><?= !empty($lead->fullname) ? wordwrap($lead->fullname, 27, "<br>\n") : '' ?></td>
					<td><?= !empty($lead->phone_number) ? hide_phone($lead->phone_number) : "" ?><br>

					</td>
					<td class=""><?= !empty($lead->customer_phone_introduce) ? $lead->customer_phone_introduce : ""  ?></td>
					<td class="hide-show-lead-status-all"><?= !empty($lead->status_sale) ? lead_status((int)$lead->status_sale, false) : lead_status(0) ?>
						<br>
				<?php if ($userSession['is_superadmin'] == 1 || in_array("60d4327c5324a71d1f2fd6ff", $userRoles->role_access_rights) || in_array('van-hanh', $groupRoles)) { ?>
						<?php if ($lead->status_sale == 19) { ?>
							<a href="javascript:void(0)" onclick="restoreLead(this)" data-id="<?= $lead->_id->{'$oid'};?>" data-tab="<?= !empty($_GET['tab']) ? $_GET['tab'] : '';?>"
							   class="btn btn-info btn-sm">
								Khôi phục Lead
							</a>
						<?php } ?>
				<?php } ?>
					</td>
					<!--					//priority-->
					<td class="hide-show-lead-status-all" style="text-align: center">
						<?= !empty($lead->priority) ? lead_priority((int)$lead->priority) : lead_priority(0) ?>
					</td>

					<!--					//priority-->

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
					<td class="hide-show-confirm"><?= !empty($lead->confirm) ? $lead->confirm : "" ?></td>
					<td class="hide-show-loan-products"><?= !empty($lead->type_finance) ? lead_type_finance($lead->type_finance) : '' ?></td>
					<td class="hide-show-identify"><?= !empty($lead->identify_lead) ? $lead->identify_lead : '' ?></td>
				</tr>
			<?php }
		} ?>
		</tbody>
	</table>
	<div class="pagination pagination-sm">
		<?php echo $pagination3 ?>
	</div>
</div>


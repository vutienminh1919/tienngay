<br>
<div class="row">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$sdt = !empty($_GET['sdt']) ? $_GET['sdt'] : "";
	$fullname = !empty($_GET['fullname']) ? $_GET['fullname'] : "";
	$cskh = !empty($_GET['cskh']) ? $_GET['cskh'] : "";
	$status_sale = !empty($_GET['status_sale_1']) ? $_GET['status_sale_1'] : "";
	?>
	<?php if (in_array('tbp-cskh', $groupRoles) || in_array('supper-admin', $groupRoles) || in_array('van-hanh', $groupRoles)) {
	?>
	<div class="col-lg-2">
		<select class="form-control" id="cskh_tab1">
			<option value="">Chọn CSKH</option>
			<?php
			if (!empty($cskhData)) {
				foreach ($cskhData as $key => $cskh1) {
					foreach ($cskh1 as $key => $val) {
						?>
						<option value="<?= !empty($val->email) ? $val->email : ""; ?>"><?= !empty($val) ? $val->email : ""; ?></option>
					<?php }
				}
			} ?>
		</select>
	</div>
	<div class="col-lg-1">
		<a class="btn btn-info "
		   onclick="check_all_cskh(this)" data-tab="1">
			Chọn
		</a>
	</div>
	<div class="col-lg-1">
		<input type="number" id="quantityInput" class="form-control" min="1" max="30" placeholder="Nhập số">
	</div>
	<div class="col-lg-1">
		<button class="btn btn-success " id="btnQty">
			Chọn
		</button>
	</div>
	<?php } ?>
	<div class="col-lg-2 text-right">
		<a style="background-color: #18d102;"
		   target="_blank"
		   href="<?= base_url() ?>excel/exportAllLead?fdate=<?= $fdate . '&tdate=' . $tdate?>"
		   class="btn btn-primary w-100"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
			Xuất excel</a>
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
			<a class="dropdown-item" href="#">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-all" data-control-column="1" checked="checked">
					<label class="custom-control-label">#</label>
				</div>
			</a>
			<a class="dropdown-item" href="#">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-all" data-control-column="2" checked="checked">
					<label class="custom-control-label">CHỌN</label>
				</div>
			</a>
			<a class="dropdown-item" href="#">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-all" data-control-column="3" checked="checked">
					<label class="custom-control-label">THAO TÁC</label>
				</div>
			</a>
			<a class="dropdown-item" href="#">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-all" data-control-column="4" checked="checked">
					<label class="custom-control-label">CSKH</label>
				</div>
			</a>
			<a class="dropdown-item">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-date-lead" data-control-column="5" checked="checked">
					<label class="custom-control-label" >NGÀY THÁNG</label>
				</div>
			</a>
			<a class="dropdown-item">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-source" data-control-column="6" checked="checked">
					<label class="custom-control-label" >NGUỒN</label>
				</div>
			</a>
			<a class="dropdown-item">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-utm-source" data-control-column="7" checked="checked">
					<label class="custom-control-label" >UTM_Source</label>
				</div>
			</a>
			<a class="dropdown-item" href="#">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-utm-campaign" data-control-column="8" checked="checked">
					<label class="custom-control-label">UTM_Campaign</label>
				</div>
			</a>
			<a class="dropdown-item" href="#">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-area-lead" data-control-column="9" checked="checked">
					<label class="custom-control-label">KHU VỰC</label>
				</div>
			</a>
			<a class="dropdown-item" href="#">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-all" data-control-column="10" checked="checked">
					<label class="custom-control-label">HỌ VÀ TÊN</label>
				</div>
			</a>
			<a class="dropdown-item" href="#">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-all" data-control-column="11" checked="checked">
					<label class="custom-control-label">SỐ ĐIỆN THOẠI</label>
				</div>
			</a>
			<a class="dropdown-item">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-lead-status" data-control-column="12" checked="checked">
					<label class="custom-control-label" >TRẠNG THÁI LEAD</label>
				</div>
			</a>

			<a class="dropdown-item">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-lead-status" data-control-column="12" checked="checked">
					<label class="custom-control-label" >Độ ưu tiên</label>
				</div>
			</a>


			<a class="dropdown-item">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-reason-cancel" data-control-column="13" checked="checked">
					<label class="custom-control-label" >LÝ DO HỦY</label>
				</div>
			</a>
			<a class="dropdown-item">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-store" data-control-column="14" checked="checked">
					<label class="custom-control-label" >CHUYỂN ĐẾN PGD</label>
				</div>
			</a>
			<a class="dropdown-item" href="#">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-contract-status" data-control-column="15" checked="checked">
					<label class="custom-control-label">TRẠNG THÁI HỢP ĐỒNG GN</label>
				</div>
			</a>
			<a class="dropdown-item" href="#">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-money-disbursement" data-control-column="16" checked="checked">
					<label class="custom-control-label">SỐ TIỀN GN</label>
				</div>
			</a>
			<a class="dropdown-item" href="#">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="show-hide-loan-products" data-control-column="17" checked="checked">
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
	<div><?php echo $result_count1; ?></div>
	<table id="datatablebutton" class="table table-striped datatablebutton hide-show-column">
		<thead>
		<tr>
			<th>#</th>
			<th>CHỌN</th>
			<th>THAO TÁC</th>
			<th>CSKH</th>
			<th class="hide-show-date-lead">NGÀY THÁNG</th>
			<th class="hide-show-source">NGUỒN</th>
			<th class="hide-show-utm-source">UTM_Source</th>
			<th class="hide-show-utm-campaign">UTM_Campaign</th>
			<th class="hide-show-area-lead">KHU VỰC</th>
			<th>HỌ VÀ TÊN</th>
			<th>SỐ ĐIỆN THOẠI</th>
			<th>SĐT NGƯỜI GIỚI THIỆU</th>
			<th class="hide-show-lead-status-all">TRẠNG THÁI LEAD</th>
			<th class="hide-show-lead-status-all">ĐỘ ƯU TIÊN</th>
			<th class="hide-show-reason-cancel">LÝ DO HỦY</th>
			<th class="hide-show-store">CHUYỂN ĐẾN PGD</th>
			<th class="hide-show-contract-status">TRẠNG THÁI HỢP ĐỒNG GN</th>
			<th class="hide-show-money-disbursement">SỐ TIỀN GN</th>
			<th>SẢN PHẨM VAY</th>
			<th class="show-hide-identify">CMND/CCCD</th>
			<!-- <th>XÁC NHẬN</th> -->

		</tr>
		</thead>
		<tbody name="list_lead">
		<?php
		if (!empty($leadsData1)) {
			$n = 1;
			foreach ($leadsData1 as $key => $lead) {
				$cskh_one = !empty($lead->cskh) ? $lead->cskh : '';
				// if(isset($lead->status_sale))
				// {
				// 	if($lead->status_sale==2)
				// 		continue;
				// }
				?>
				<tr>
					<td><?php echo $n++ ?></td>
					<td><input type="checkbox" value="<?= $lead->_id->{'$oid'} ?>" class="checkbox_cskh_all"
							data-email="<?= $cskh_one ?>"   name="checkQuantity"/></td>
					<td class="text-right">
						<a href="javascript:void(0)" onclick="showModal('<?= $lead->_id->{'$oid'} ?>')"
						   class="btn btn-info btn-sm callmodal">
							Gọi
						</a>
					</td>
					<td class="col-md-2">
						<?php if(in_array('tbp-cskh', $groupRoles)) { ?>
						<select class="form-control email_cskh" data-id="<?= $lead->_id->{'$oid'} ?>"
								onchange="change_cskh(this)" style="min-width: 150px;">
							<option value="">Chọn CSKH</option>
							<?php
							if (!empty($cskhData)) {
								foreach ($cskhData as $key => $cskh) {
									foreach ($cskh as $key => $val) {
										?>
										<option <?= ($cskh_one == $val->email) ? "selected" : "" ?>
												value="<?= !empty($val->email) ? $val->email : ""; ?>"><?= !empty($val) ? $val->email : ""; ?></option>
									<?php }
								}
							} ?>
						</select>
						<?php }else{ ?>
						<?= $cskh_one ?>
					<?php }?>
					</td>
					<td class="hide-show-date-lead"><?= !empty($lead->created_at) ? date('d/m/Y H:i:s', $lead->created_at) : "" ?></td>
					<td class="hide-show-source"><?= !empty($lead->source) ? lead_nguon($lead->source) : '' ?></td>
					<td class="hide-show-utm-source"><?= !empty($lead->utm_source) ? $lead->utm_source : '' ?></td>
					<td class="hide-show-utm-campaign"><?= !empty($lead->utm_campaign) ? implode("<br>", str_split($lead->utm_campaign, 20)) : '' ?></td>
					<td class="hide-show-area-lead"><?= !empty($lead->area) ? get_province_name_by_code($lead->area) : '' ?></td>
					<td><?= !empty($lead->fullname) ? wordwrap($lead->fullname, 25, "<br>\n") : '' ?><br>
						<a href="javascript:void(0)" onclick="showLeadLog('<?= $lead->_id->{'$oid'} ?>')"
						   class="btn btn-info btn-sm">
							LeadLog
						</a>
					</td>
					<td><?= !empty($lead->phone_number) ? hide_phone($lead->phone_number) : "" ?></td>
					<td class=""><?= !empty($lead->customer_phone_introduce) ? $lead->customer_phone_introduce : ""  ?></td>
					<td class="hide-show-lead-status-all" style="text-align: center"><?= !empty($lead->status_sale) ? lead_status((int)$lead->status_sale, false) : lead_status(0) ?>
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

					<td class="hide-show-lead-status-all" style="text-align: center">
						<?= !empty($lead->priority) ? lead_priority((int)$lead->priority): lead_priority(0) ?>
					</td>


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
					<td class="hide-show-money-disbursement"><?= (!empty($lead->contractInfo->loan_infor->amount_loan) && (!empty($lead->contractInfo->status) && $lead->contractInfo->status > 16)) ? $lead->contractInfo->loan_infor->amount_loan : '' ?></td>
					<td class="hide-show-loan-products"><?= !empty($lead->type_finance) ? lead_type_finance($lead->type_finance) : '' ?></td>
					<td class="hide-show-identify"><?= !empty($lead->identify_lead) ? $lead->identify_lead : '' ?></td>
				</tr>
			<?php }
		} ?>
		</tbody>
	</table>
	<div class="pagination pagination-sm">
		<?php echo $pagination1 ?>
	</div>
</div>
<script>
	$(document).ready(function () {
		$("#btnQty").on('click', function () {

			let quantity = document.getElementById('quantityInput').value;
			let checkboxes = document.getElementsByName('checkQuantity');
		
			for (let i = 0; i < checkboxes.length; i++) {
				checkboxes[i].checked = false;

			}
			$('.datatablebutton input').each(function(item){
				if($(this).data('email')=="" && quantity >0)
				{
			     quantity--;
			     $(this).prop('checked', true);
				}

			   

			});
		})
	});
</script>

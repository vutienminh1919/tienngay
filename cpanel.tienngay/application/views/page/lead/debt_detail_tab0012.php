<br>
<div class="row">
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

			<div class="dropdown-divider"></div>
		</div>
	</div>
</div>
<div class="table-responsive">
<!--	<div>--><?php //echo $result_count12; ?><!--</div>-->
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
			<th class="hide-show-reason-cancel">LÝ DO HỦY</th>
			<th class="hide-show-store">CHUYỂN ĐẾN PGD</th>
			<th class="hide-show-contract-status">TRẠNG THÁI HỢP ĐỒNG GN</th>
			<th class="hide-show-money-disbursement">SỐ TIỀN GN</th>
			<th>SẢN PHẨM VAY</th>
			<!-- <th>XÁC NHẬN</th> -->

		</tr>
		</thead>
		<tbody name="list_lead">
		<?php
		if (!empty($leadsData12)) {
			$n = 1;
			foreach ($leadsData12 as $key => $lead) {
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
						<?php if (in_array("tbp-cskh", $groupRoles)) { ?>
							<select class="form-control email_cskh" data-id="<?= $lead->_id->{'$oid'} ?>"
								onchange="change_cskh(this)" style="min-width: 150px;">
							<option value="">Chọn CSKH</option>
							<?php

								if (!empty($cskhData)) {
									foreach ($cskhData as $key => $cskh) {
										foreach ($cskh as $key => $val) {
											?>
											<option style="width:30px;" <?= ($cskh_one == $val->email) ? "selected" : "" ?>
											value="<?= !empty($val->email) ? $val->email : ""; ?>"><?= !empty($val) ? $val->email : ""; ?></option>
										<?php }
									}
								}
						} else { ?>
							<select disabled class="form-control email_cskh" data-id="<?= $lead->_id->{'$oid'} ?>"
								onchange="change_cskh(this)" style="min-width: 150px;">
							<?php 
							if (!empty($cskhData)) {
									foreach ($cskhData as $key => $cskh) {
										foreach ($cskh as $key => $val) {
											?>
											<option <?= (!empty($cskh_one)) ? "selected" : "" ?>
												value="<?= !empty($cskh_one) ? $cskh_one : ""; ?>"><?= !empty($cskh_one) ? $cskh_one : ""; ?></option>
									<?php }
									}
								}
						} ?>
					</td>
					<td class="hide-show-date-lead"><?= !empty($lead->created_at) ? date('d/m/Y H:i:s', $lead->created_at) : "" ?></td>
					<td class="hide-show-source"><?= !empty($lead->source) ? lead_nguon($lead->source) : '' ?></td>
					<td class="hide-show-utm-source"><?= !empty($lead->utm_source) ? $lead->utm_source : '' ?></td>
					<td class="hide-show-utm-campaign"><?= !empty($lead->utm_campaign) ? implode("<br>", str_split($lead->utm_campaign, 20)) : '' ?></td>
					<td class="hide-show-area-lead"><?= !empty($lead->area) ? get_province_name_by_code($lead->area) : '' ?></td>
					<td><?= !empty($lead->fullname) ? wordwrap($lead->fullname, 25, "<br>\n") : '' ?><br>

					</td>
					<td><?= !empty($lead->phone_number) ? hide_phone($lead->phone_number) : "" ?></td>
					<td class=""><?= !empty($lead->customer_phone_introduce) ? $lead->customer_phone_introduce : ""  ?></td>
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
					<td class="hide-show-contract-status">
						<?php
						$status = (!empty($lead->contractInfo->status) && $lead->contractInfo->status > 16) ? $lead->contractInfo->status : "";
						if ($status == 17) {
							echo "Đang vay";
						} else if ($status == 18) {
							echo "Giải ngân thất bại";
						} else if ($status == 19) {
							echo "Đã tất toán";
						} else if ($status == 20) {
							echo "Đã quá hạn ";
						} else if ($status == 21) {
							echo "Chờ hội sở duyệt gia hạn";
						} else if ($status == 22) {
							echo "Chờ kế toán duyệt gia hạn ";
						} else if ($status == 23) {
							echo "Đã gia hạn ";
						} else if ($status == 24) {
							echo "chờ kế toán xác nhận phiếu thu gia hạn";
						} else if ($status == 25) {
							echo "đã duyệt gia hạn";
						}
						?>
					</td>
					<td class="hide-show-money-disbursement"><?= (!empty($lead->contractInfo->loan_infor->amount_loan) && (!empty($lead->contractInfo->status) && $lead->contractInfo->status > 16)) ? $lead->contractInfo->loan_infor->amount_loan : '' ?></td>
					<td class="hide-show-loan-products"><?= !empty($lead->type_finance) ? lead_type_finance($lead->type_finance) : '' ?></td>
				</tr>
			<?php }
		} ?>
		</tbody>
	</table>
<!--	<div class="pagination pagination-sm">-->
<!--		--><?php //echo $pagination12 ?>
<!--	</div>-->
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

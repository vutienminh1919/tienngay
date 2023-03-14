<div class="x_panel setup-content" id="step-4">
	<div class="x_content">
		<!--Thông tin khoản vay-->
		<div class="x_title">
			<strong><i class="fa fa-user" aria-hidden="true"></i> <?= $this->lang->line('Loan_information') ?></strong>
			<div class="clearfix"></div>
		</div>

		<input type="hidden" name="user_nextpay" id="user_nextpay"
			   value="<?php echo $user_nextpay ?>">
		<?php
		$type_finance = ($lead_info->type_finance) ? $lead_info->type_finance : '';

		if (empty($dataInit['type_finance']) && empty($dataInit['main'])) { ?>
			<?php
			$data['configuration_formality'] = $configuration_formality;
			$data['mainPropertyData'] = $mainPropertyData;
			$data['type_finance'] = $type_finance;
			$this->load->view("page/property/template/loan_infor_no_init", $data)
			?>
		<?php } ?>

		<!--Init from định giá tài sản-->
		<?php if (!empty($dataInit['type_finance']) && !empty($dataInit['main'])) { ?>
			<?php
			$data['configuration_formality'] = $configuration_formality;
			$data['mainPropertyData'] = $mainPropertyData;
			$data['dataInit'] = $dataInit;
			$this->load->view("page/property/template/loan_infor_have_init.php", $data);
			?>
		<?php } ?>


		<div class="form-group row">
			<!-- <label class="control-label col-md-3 col-sm-3 col-xs-12"> -->
			<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
				Số tiền vay<span class="text-danger">*</span>
			</label>
			<!-- <div class="col-md-6 col-sm-6 col-xs-12"> -->
			<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
				<input type="text" id="money" required class="form-control number" value="0">
			</div>
		</div>

		<div class="form-group row">
			<!-- <label class="control-label col-md-3 col-sm-3 col-xs-12"> -->
			<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
				Mục đích vay <span class="text-danger">*</span>
			</label>
			<!-- <div class="col-md-6 col-sm-6 col-xs-12"> -->
			<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
				<!-- <input type="text" id="loan_purpose" required class="form-control">-->
				<select class="form-control" id="loan_purpose">
					<option value="Tiêu dùng cá nhân">Tiêu dùng cá nhân</option>
					<option value="Đóng học phí">Đóng học phí</option>
					<option value="Đóng viện phí">Đóng viện phí</option>
					<option value="Du lịch">Du lịch</option>
					<option value="Kinh doanh">Kinh doanh</option>
					<option value="Mua đồ điện tử">Mua đồ điện tử</option>
					<option value="Mua đồ nội thất"> Mua đồ nội thất</option>
					<option value="Mua xe máy"> Mua xe máy</option>
					<option value="Sửa chữa nhà ở">Sửa chữa nhà ở</option>
					<option value="Các mục đich khác không vi phạm Quy định của pháp luật">Các mục đich khác không vi
						phạm Quy định của pháp luật
					</option>
					<option value="Vay bổ sung vốn kinh doanh Online" id="kdol_v" hidden>Vay bổ sung vốn kinh doanh
						Online
					</option>
				</select>
			</div>
		</div>

		<div class="form-group row tra_lai">
			<!-- <label class="control-label col-md-3 col-sm-3 col-xs-12"> -->
			<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<?= $this->lang->line('formality2') ?> <span class="text-danger">*</span>
			</label>
			<!-- <div class="col-md-6 col-sm-6 col-xs-12"> -->
			<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
				<?php $type_repay = ($lead_info->type_repay) ? $lead_info->type_repay : ''; ?>
				<select class="form-control" id="type_interest">
					<option value="">-- Chọn hình thức trả lãi --</option>
					<option value="1" <?= ($type_repay == '1') ? "selected" : "" ?>><?= $this->lang->line('Outstanding_descending') ?></option>
					<option id="type_interest_motobike"
							value="2" <?= ($type_repay == '2') ? "selected" : "" ?>><?= $this->lang->line('Monthly_interest_principal_maturity') ?></option>
				</select>
			</div>
		</div>

		<div class="form-group row thoi_gian_vay">
			<!-- <label class="control-label col-md-3 col-sm-3 col-xs-12"> -->
			<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<?= $this->lang->line('Number_loan_days') ?><span class="text-danger">*</span>
			</label>
			<!-- <div class="col-md-6 col-sm-6 col-xs-12"> -->
			<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12" id="cc" style='display:none'>
				<select class="form-control number_day_loan">
					<option value="1">1 tháng</option>
				</select>
			</div>

			<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12" id="dkx">
				<select class="form-control " id="number_day_loan">
					<option value="">-- Chọn thời gian vay --</option>
					<option id="number_day_loan_motobike"
							value="1" <?= ($lead_info->loan_time && $lead_info->loan_time == 1) ? "selected" : ''; ?> >1
						tháng
					</option>
					<option id="value3"
							value="3" <?= ($lead_info->loan_time && $lead_info->loan_time == 3) ? "selected" : ''; ?>>3
						tháng
					</option>
					<option id="value6"
							value="6" <?= ($lead_info->loan_time && $lead_info->loan_time == 6) ? "selected" : ''; ?>>6
						tháng
					</option>
					<option id="value9"
							value="9" <?= ($lead_info->loan_time && $lead_info->loan_time == 9) ? "selected" : ''; ?>>9
						tháng
					</option>
					<option id="value12"
							value="12" <?= ($lead_info->loan_time && $lead_info->loan_time == 12) ? "selected" : ''; ?>>
						12 tháng
					</option>
					<option id="value18"
							value="18" <?= ($lead_info->loan_time && $lead_info->loan_time == 18) ? "selected" : ''; ?>>
						18 tháng
					</option>
					<option id="value24"
							value="24" <?= ($lead_info->loan_time && $lead_info->loan_time == 24) ? "selected" : ''; ?>>
						24 tháng
					</option>
				</select>
			</div>
		</div>

		<div class="form-group row" style="display:none;">
			<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<?= $this->lang->line('Interest_payment_period') ?> (ngày)<span class="text-danger">*</span>
			</label>
			<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
				<input type="text" id="period_pay_interest" class="form-control" value="30" disabled>
			</div>
		</div>


		<div class="form-group row">

			<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
				Bảo hiểm khoản vay <span class="text-danger">*</span>
			</label>
			<input type="hidden" id="tilekhoanvay" name="tilekhoanvay" value="<?= $tilekhoanvay ?>">
			<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
				<div class="radio-inline text-primary">
					<label><input name='insurrance' value="1" checked id="insurrance" type="checkbox"></label>
				</div>

			</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
				Loại bảo hiểm khoản vay<span class="text-danger">*</span>
			</label>
			<div class="col-lg-6 col-sm-12 col-12">
				<select class="form-control" name="loan_insurance">
					<option value="0">-- Chọn bảo hiểm khoản vay --</option>
					<?php $loan_insurance = isset($contractInfor->loan_infor->loan_insurance) ? $contractInfor->loan_infor->loan_insurance : '';
					foreach (loan_insurance() as $key => $item) {
						if ($code_domain == 'MB' && $key == '1') continue;
						if ($code_domain != 'MB' && $key == '2') continue;
						?>
						<option <?php echo $loan_insurance == $key ? 'selected' : '' ?>
								value="<?= $key ?>"><?= $item ?></option>
					<?php } ?>
				</select>
			</div>
		</div>

		<div class="form-group row">
			<!-- <label class="control-label col-md-3 col-sm-3 col-xs-12"> -->
			<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
				Phí bảo hiểm khoản vay
			</label>
			<!-- <div class="col-md-6 col-sm-6 col-xs-12"> -->
			<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
				<input type="text" id="fee_gic" class="form-control number" value="0" disabled>

			</div>
		</div>

		<div class="form-group row" id="fee_gic_easy_hide">

			<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
				Bảo hiểm xe máy(easy) GIC <span class="text-danger"></span>
			</label>
			<div class="col-lg-6 col-sm-12 col-12">

				<select class="form-control" name="gic_easy" id="gic_easy">
					<option value="0">-- Chọn gói bảo hiểm --</option>
					<?php $easy = isset($contractInfor->loan_infor->code_GIC_easy) ? $contractInfor->loan_infor->code_GIC_easy : '';
					foreach (gic_easy() as $key => $item) { ?>
						<option <?php echo $easy == $item ? 'selected' : '' ?> value="<?= $key ?>"><?= $item ?></option>
					<?php } ?>
				</select>
			</div>
		</div>

		<div class="form-group row" id="fee_gic_easy_hide_1">

			<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
				Phí bảo hiểm xe máy (easy) GIC
			</label>

			<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
				<input type="text" id="fee_gic_easy" class="form-control number"
					   value="<?= (isset($contractInfor->loan_infor->amount_GIC_easy)) ? number_format($contractInfor->loan_infor->amount_GIC_easy) : 0 ?>"
					   disabled>

			</div>
		</div>

		<div class="form-group row" id="fee_mic_xe_may_hide">

			<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
				Bảo hiểm xe máy MIC <span class="text-danger"></span>
			</label>
			<div class="col-lg-6 col-sm-12 col-12">

				<select class="form-control" name="mic_xe_may" id="mic_xe_may">
					<option value="0">-- Chọn gói bảo hiểm --</option>
					<option value="66000">BH xe</option>
				</select>
			</div>
		</div>

		<div class="form-group row" id="fee_mic_xe_may_hide_1">

			<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
				Phí bảo hiểm xe máy MIC
			</label>

			<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
				<input type="text" id="fee_mic_xe_may" class="form-control number" value="0" disabled>
			</div>
		</div>

		<div class="form-group row">

			<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
				Bảo hiểm VBI
			</label>
			<div class="col-lg-6 col-sm-12 col-12">

				<select id="selectize_vbi" class="form-control" name="code_vbi[]" multiple="multiple"
						data-placeholder="Chọn bảo hiểm VBI">
					<?php foreach (lead_VBI() as $key => $item) { ?>
						<option value="<?= $key ?>" <?= ($lead_VBI == $key) ? 'selected' : '' ?>><?= $item ?></option>
					<?php } ?>
				</select>
			</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
				Phí bảo hiểm VIB
			</label>
			<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
				<input type="text" id="fee_vbi" class="form-control number" value="0" disabled>
			</div>
		</div>
		<input type="text" id="fee_vbi1" class="form-control number" value="0" style="display: none">
		<input type="text" id="fee_vbi2" class="form-control number" value="0" style="display: none">
		<input type="text" id="code_VBI_1" class="form-control number" style="display: none">
		<input type="text" id="code_VBI_2" class="form-control number" style="display: none">
		<input type="text" id="maVBI_1" class="form-control number" value="0" style="display: none">
		<input type="text" id="maVBI_2" class="form-control number" value="0" style="display: none">

		<div class="form-group row">

			<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
				Bảo hiểm phúc lộc thọ
			</label>
			<div class="col-lg-6 col-sm-12 col-12">
				<select class="form-control" name="gic_plt">
					<option value="0">-- Chọn gói bảo hiểm --</option>
					<?php $plt = isset($contractInfor->loan_infor->code_GIC_plt) ? $contractInfor->loan_infor->code_GIC_plt : '';
					foreach (gic_plt() as $key => $item) { ?>
						<option <?php echo $plt == $item ? 'selected' : '' ?> value="<?= $key ?>"><?= $item ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-lg-3 col-sm-12 col-12">
				<div class="radio-inline text-primary">

					<label><input disabled
								  name='is_free_gic_plt' <?= ($contractInfor->loan_infor->is_free_gic_plt == 1) ? "checked" : "" ?>
								  id="is_free_gic_plt" type="checkbox">
						Miễn phí
					</label>
				</div>
			</div>
		</div>


		<div class="form-group row">

			<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
				Phí bảo hiểm phúc lộc thọ
			</label>

			<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
				<input type="text" id="fee_gic_plt" class="form-control number"
					   value="<?= (isset($contractInfor->loan_infor->amount_GIC_plt)) ? number_format($contractInfor->loan_infor->amount_GIC_plt) : 0 ?>"
					   disabled>

			</div>
		</div>
		<?php $type_tnds = $contractInfor->loan_infor->bao_hiem_tnds->type_tnds ? $contractInfor->loan_infor->bao_hiem_tnds->type_tnds : '' ?>
		<div class="form-group row">
			<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
				Bảo Hiểm TNDS
			</label>
			<div class="col-lg-6 col-sm-12 col-12">
				<select class="form-control" id="type_tnds" name="type_tnds">
					<option value="">-- Chọn bảo hiểm --</option>
					<option id="mic_tnds_select" <?php echo $type_tnds == 'MIC_TNDS' ? 'selected' : '' ?>
							value="MIC_TNDS">Bảo hiểm TNDS xe
						máy
					</option>
					<!--					<option -->
					<?php //echo $type_tnds == 'VBI_TNDS' ? 'selected' : '' ?><!-- value="VBI_TNDS">Bảo hiểm TNDS ô-->
					<!--						tô-->
					<!--					</option>-->
				</select>
			</div>
		</div>
		<div class="mic_tnds" <?= ($type_tnds == 'MIC_TNDS') ? "" : "style='display: none'" ?>>
			<div class="form-group row">
				<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
					Dung tích xe
				</label>
				<div class="col-lg-6 col-sm-12 col-12">
					<?php $mic_dung_tich_xe = $contractInfor->loan_infor->bao_hiem_tnds->dung_tich_xe ? $contractInfor->loan_infor->bao_hiem_tnds->dung_tich_xe : '' ?>
					<select class="form-control" id="mic_dung_tich_xe" name="mic_dung_tich_xe">
						<option <?php echo $mic_dung_tich_xe == 'L' ? 'selected' : '' ?> value="L">Trên 50m3</option>
						<option <?php echo $mic_dung_tich_xe == 'N' ? 'selected' : '' ?> value="N">Dưới 50m3</option>
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
					Mức trách nhiệm
				</label>
				<div class="col-lg-6 col-sm-12 col-12">
					<?php $mic_muc_trach_nhiem = $contractInfor->loan_infor->bao_hiem_tnds->muc_trach_nhiem ? $contractInfor->loan_infor->bao_hiem_tnds->muc_trach_nhiem : '0' ?>
					<select class="form-control" id="mic_muc_trach_nhiem" name="mic_muc_trach_nhiem">
						<option <?php echo $mic_muc_trach_nhiem == '0' ? 'selected' : '' ?> value="0">0 VND</option>
						<option <?php echo $mic_muc_trach_nhiem == '10000000' ? 'selected' : '' ?> value="10000000">
							10,000,000 VND
						</option>
						<option <?php echo $mic_muc_trach_nhiem == '15000000' ? 'selected' : '' ?> value="15000000">
							15,000,000 VND
						</option>
						<option <?php echo $mic_muc_trach_nhiem == '20000000' ? 'selected' : '' ?> value="20000000">
							20,000,000 VND
						</option>
						<option <?php echo $mic_muc_trach_nhiem == '25000000' ? 'selected' : '' ?> value="25000000">
							25,000,000 VND
						</option>
						<option <?php echo $mic_muc_trach_nhiem == '30000000' ? 'selected' : '' ?> value="30000000">
							30,000,000 VND
						</option>
					</select>
				</div>
			</div>
		</div>
		<div class="vbi_tnds" <?= ($type_tnds == 'VBI_TNDS') ? "" : "style='display: none'" ?>>
			<div class="form-group row">
				<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
					Nhóm xe
				</label>
				<div class="col-lg-6 col-sm-12 col-12">
					<?php $nhomXe = $contractInfor->loan_infor->bao_hiem_tnds->nhom_xe ? $contractInfor->loan_infor->bao_hiem_tnds->nhom_xe : '' ?>
					<select class="form-control" id="nhom_xe" name="nhom_xe">
						<?php foreach ($nhom_xe as $nhom) : ?>
							<option <?php echo $nhomXe == $nhom->Ma ? 'selected' : '' ?>
									value="<?php echo $nhom->Ma ?>"><?php echo $nhom->Ten ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
					Hiệu xe
				</label>
				<div class="col-lg-6 col-sm-12 col-12">
					<?php $hieuXe = $contractInfor->loan_infor->bao_hiem_tnds->hieu_xe ? $contractInfor->loan_infor->bao_hiem_tnds->hieu_xe : '' ?>
					<select class="form-control" id="hieu_xe" name="hieu_xe">
						<?php foreach ($hieu_xe as $hieu) : ?>
							<option <?php echo $hieuXe == $hieu->Ma ? 'selected' : '' ?>
									value="<?php echo $hieu->Ma ?>"><?php echo $hieu->Ten ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
					Hãng xe
				</label>
				<div class="col-lg-6 col-sm-12 col-12">
					<?php $hangXe = $contractInfor->loan_infor->bao_hiem_tnds->hang_xe ? $contractInfor->loan_infor->bao_hiem_tnds->hang_xe : '' ?>
					<select class="form-control" id="hang_xe" name="hang_xe">
						<?php foreach ($hang_xe as $hang) : ?>
							<option <?php echo $hangXe == $hang->Ma ? 'selected' : '' ?>
									value="<?php echo $hang->Ma ?>"><?php echo $hang->Ten ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
				Phí BH TNDS
			</label>
			<div class="col-lg-6 col-md-6 col-sm-12">
				<input type="text" id="phi_tnds" class="form-control number" name="phi_tnds"
					   value="<?php echo $contractInfor->loan_infor->bao_hiem_tnds->price_tnds ? number_format($contractInfor->loan_infor->bao_hiem_tnds->price_tnds) : '0' ?>"
					   disabled>
			</div>
		</div>
		<?php $type_pti = $contractInfor->loan_infor->bao_hiem_pti_vta->type_pti ? $contractInfor->loan_infor->bao_hiem_pti_vta->type_pti : '' ?>
		<div class="form-group row">
			<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
				Bảo Hiểm Tai Nạn Con Người (PTI)
			</label>
			<div class="col-lg-6 col-sm-12 col-12">
				<?php $pti_bhtn = isset($contractInfor->loan_infor->pti_bhtn->goi) ? $contractInfor->loan_infor->pti_bhtn->goi : null ?>
				<select class="form-control" id="pti_bhtn" name="pti_bhtn">
				</select>
			</div>
		</div>
		<div class="form-group row">
			<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
				Phí Bảo Hiểm Tai Nạn Con Người (PTI)
			</label>
			<div class="col-lg-6 col-md-6 col-sm-12">
				<input type="text" id="phi_pti_bhtn" class="form-control number" name="phi_pti_bhtn" value="" disabled>
			</div>
		</div>
		<div class="form-group row d-none">

			<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
				Bảo hiểm PTI - Vững Tâm An
			</label>
			<div class="col-lg-3 col-sm-12 col-12">
				<select class="form-control" name="code_pti_vta" id="code_pti_vta">
					<option value="">-- Chọn gói bảo hiểm --</option>
					<?php if (in_array('hoi-so', $groupRoles) || in_array('van-hanh', $groupRoles)) $user_nextpay = 0;?>
					<?php $code_pti_vta = isset($contractInfor->loan_infor->bao_hiem_pti_vta->code_pti_vta) ? $contractInfor->loan_infor->bao_hiem_pti_vta->code_pti_vta : '';
					if (!empty($pti_vta_fee)) :
						foreach ($pti_vta_fee as $fee) :
							?>
							<?php if ($user_nextpay == 1 && ($fee->packet == "G1" || $fee->packet == "G3" || $fee->packet == "GOI1" || $fee->packet == "GOI3")) continue; ?>
							<option <?php echo $code_pti_vta == $fee->packet ? 'selected' : '' ?>
									value="<?= !empty($fee->packet) ? $fee->packet : ''; ?>">
								Gói <?= !empty($fee->number_packet) ? $fee->number_packet : ''; ?>
								- <?= !empty($fee->died_fee) ? $fee->died_fee : ''; ?></option>
						<?php endforeach;
					endif; ?>
				</select>
			</div>
			<div class="col-lg-3 col-sm-12 col-12">
				<select class="form-control" name="year_pti_vta" id="year_pti_vta">
					<option value="">-- Chọn năm --</option>
					<?php $year_pti_vta = isset($contractInfor->loan_infor->bao_hiem_pti_vta->year_pti_vta) ? $contractInfor->loan_infor->bao_hiem_pti_vta->year_pti_vta : ''; ?>
					<?php if ($user_nextpay == 1) : ?>
						<option <?php echo $year_pti_vta == '3M' ? 'selected' : '' ?> value="3M">3 Tháng</option>
					<?php else: ?>
						<option <?php echo $year_pti_vta == '3M' ? 'selected' : '' ?> value="3M">3 Tháng</option>
						<option <?php echo $year_pti_vta == '6M' ? 'selected' : '' ?> value="6M">6 Tháng</option>
						<option <?php echo $year_pti_vta == '1Y' ? 'selected' : '' ?> value="1Y">1 năm</option>
					<?php endif; ?>
				</select>
			</div>
		</div>

		<div class="form-group row d-none">

			<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
				Phí bảo hiểm PTI - Vững Tâm An
			</label>

			<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
				<input type="hidden" name="code_fee" id="code_fee" value="<?= (isset($contractInfor->loan_infor->bao_hiem_pti_vta->code_fee)) ? ($contractInfor->loan_infor->bao_hiem_pti_vta->code_fee) : '' ?>">
				<input type="text" id="price_pti_vta" class="form-control number"
					   value="<?= (isset($contractInfor->loan_infor->bao_hiem_pti_vta->price_pti_vta)) ? number_format($contractInfor->loan_infor->bao_hiem_pti_vta->price_pti_vta) : 0 ?>"
					   disabled>
			</div>
		</div>
		<div class="form-group row">
			<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
				Chương trình ưu đãi <span class="text-danger">*</span>
			</label>
			<div class="col-lg-6 col-sm-12 col-12">
				<select class="form-control" id="code_coupon">
					<option value="">-- Chọn Chương trình ưu đãi --</option>
					<?php
					$coupon = isset($contractInfor->loan_infor->code_coupon) ? $contractInfor->loan_infor->code_coupon : '';
					foreach ($couponData as $key => $item) { ?>
						<option <?php echo $item->code == $coupon ? 'selected' : '' ?>
								value="<?= $item->code ?>"><?= $item->code ?></option>
					<?php } ?>
				</select>
			</div>
		</div>

		<div class="form-group row">
			<!-- <label class="control-label col-md-3 col-sm-3 col-xs-12"> -->
			<label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<?= $this->lang->line('note') ?>
			</label>
			<!-- <div class="col-md-6 col-sm-6 col-xs-12"> -->
			<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
				<textarea type="text" id="note" required class="form-control"></textarea>
			</div>
		</div>
		<div class="image-tai-san">
			<div class="x_title">
				<strong><i class="fa fa-user" aria-hidden="true"></i>
					Ảnh đăng kí xe
				</strong>
				<div class="clearfix"></div>
			</div>
			<div class="">
				<div class="row">
					<div class="col-xs-12 col-md-3 text-right">

					</div>
					<div class="col-xs-12 col-md-3" style="text-align: center">
						<label>
							<div class="wait">
							<span class="loading" style="display: none">
							<i class="fa fa-cog  fa-spin fa-3x fa-fw"></i>
								</span>
								<img id="img_dkx_mat_truoc" style="width: 350px; height: 250px;"
									 alt=""
									 src="<?php echo !empty($contractInfor->loan_infor->image_property->image_front) ? $contractInfor->loan_infor->image_property->image_front : 'https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png' ?>">
							</div>
							<p class="text-center text-danger">Mặt trước DKX (*)</p>
							<h3 class="text-center text-success phan_tram_mt"></h3>
							<input class="form-control pt-2" type="file" id="dkx_mat_truoc" style="visibility: hidden ;"
								   value="<?php echo !empty($contractInfor->loan_infor->image_property->image_front) ? $contractInfor->loan_infor->image_property->image_front : '' ?>"
								   data-preview="img_truoc" name="img_dkx_mat_truoc">
						</label>
					</div>
					<div class="col-xs-12 col-md-3 " style="text-align: center">
						<label>
							<div class="wait1">
							<span class="loading1" style="display: none">
							<i class="fa fa-cog  fa-spin fa-3x fa-fw"></i>
								</span>
								<img id="img_dkx_mat_sau" style="width: 350px; height: 250px;" alt=""
									 src="<?php echo !empty($contractInfor->loan_infor->image_property->image_back) ? $contractInfor->loan_infor->image_property->image_back : 'https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png' ?>">
							</div>
							<p class="text-center text-danger">Mặt sau DKX (*)</p>
							<h3 class="text-center text-success phan_tram_ms"></h3>
							<input class="form-control pt-2" type='file' id="dkx_mat_sau" style="visibility: hidden ;"
								   value="<?php echo !empty($contractInfor->loan_infor->image_property->image_back) ? $contractInfor->loan_infor->image_property->image_back : '	' ?>"
								   data-preview="img_truoc" name="img_dkx_mat_sau">
						</label>
					</div>
					<div class="col-xs-12 col-md-3 text-right">

					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-7">

					</div>
					<div class="col-xs-12 col-md-2 text-right">
						<button class="btn btn-primary nhap_lai_dkx">Nhập lại</button>
						<button class="btn btn-info nhan_dang_dkx">Nhận dạng</button>
					</div>
					<div class="col-xs-12 col-md-3">

					</div>

				</div>
			</div>
		</div>
		<!--Thông tin tài sản-->
		<div class="x_title">
			<strong><i class="fa fa-user" aria-hidden="true"></i> <?= $this->lang->line('Property_information') ?>
			</strong>
			<div class="clearfix"></div>
		</div>
		<div class="properties">

		</div>

		<div class="form-group row form_gan_dinh_vi" style="display: none;">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				Gắn định vị<span class="text-danger">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="radio-inline text-primary">
					<label><input name='gan_dinh_vi'
								  value="1" <?= $contractInfor->loan_infor->gan_dinh_vi == 1 ? "checked" : "" ?>
								  type="radio">&nbsp;Có</label>
				</div>
				<div class="radio-inline text-danger">
					<label><input name='gan_dinh_vi'
								  value="2" <?= $contractInfor->loan_infor->gan_dinh_vi == 2 ? "checked" : "" ?>
								  type="radio">&nbsp;Không</label>
				</div>
			</div>
		</div>
		<div class="form-group row form_o_to_ngan_hang" style="display: none;">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">
				Ô tô ngân hàng<span class="text-danger">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="radio-inline text-primary">
					<label><input name='o_to_ngan_hang'
								  value="1" <?= $contractInfor->loan_infor->o_to_ngan_hang == 1 ? "checked" : "" ?>
								  type="radio">&nbsp;Có</label>
				</div>
				<div class="radio-inline text-danger">
					<label><input name='o_to_ngan_hang'
								  value="2" <?= $contractInfor->loan_infor->o_to_ngan_hang == 2 ? "checked" : "" ?>
								  type="radio">&nbsp;Không</label>
				</div>
			</div>
		</div>

		<button class="btn btn-primary nextBtnCreate pull-right btn_check_dkx" data-step="4" type="button">Tiếp tục
		</button>
		<button class="btn btn-primary  pull-right save_contract" type="button" data-toggle="modal" data-step="4"
				data-target="#saveContract">Lưu lại
		</button>
		<button class="btn btn-danger backBtn pull-right" type="button">Quay lại</button>
	</div>
</div>

<style>
	.wait {
		position: relative;
	}

	.wait .loading {
		position: absolute;
		z-index: 10;
		background-color: rgba(0, 0, 0, 0.5);
		display: flex;
		justify-content: center;
		align-items: center;
		color: white;
		width: 100%;
		height: 100%;
	}

	.wait .loading i.fa {
		width: 38px;
		height: 38px;
		text-align: center;
	}

	.wait1 {
		position: relative;
	}

	.wait1 .loading1 {
		position: absolute;
		z-index: 10;
		background-color: rgba(0, 0, 0, 0.5);
		display: flex;
		justify-content: center;
		align-items: center;
		color: white;
		width: 100%;
		height: 100%;
	}

	.wait1 .loading1 i.fa {
		width: 38px;
		height: 38px;
		text-align: center;
	}
</style>
<script src="<?php echo base_url(); ?>assets/js/pawn/check_dkx.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pawn/check_bh_tnds.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pawn/pti_bhtn.js?v=20220714"></script>
<script type="text/javascript">
	$(document).ready(function () {
		pti_bhtn($("#pti_bhtn"), $("#phi_pti_bhtn"), "<?= $pti_bhtn ?>");
	});
</script>

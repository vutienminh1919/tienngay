<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/css/detail_kt/disbursement_new_nl.css">
<!-- -------------- -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span>Đang Tải...</span>
	</div>
	<h2>Giải ngân hợp đồng <?= $contractInfor->code_contract ?> - <?= $contractInfor->code_contract_disbursement ?></h2>
	<div class="giaingan">
		<h2>Giải ngân</h2>
		<div class="giaingan_line">
			<div class="c">
				<img src="<?php echo base_url(); ?>assets/imgs/icon/people.png" alt="" width="100%">
			</div>
			<?php
			$type_payout = !empty($contractInfor->receiver_infor->type_payout) ? $contractInfor->receiver_infor->type_payout : "";
			$amount_GIC = (isset($contractInfor->loan_infor->amount_GIC)) ? $contractInfor->loan_infor->amount_GIC : 0;
			// hình thức chuyển khoản tài khoản ngân hàng
			if ($type_payout == 2) {
				?>
				<h5>Thông tin tài khoản</h5>
			<?php } else if ($type_payout == 3) { ?>
				<h5>Theo số thẻ ATM</h5>
			<?php } ?>
		</div>
		<div class="giaingan-form">
			<div class="giaingan-left">
				<div>
					<p>Mã hợp đồng</p>
					<input type="text" class="form" value="<?= !empty($contractInfor->code_contract_disbursement) ? $contractInfor->code_contract_disbursement : $contractInfor->code_contract; ?>" readonly>
				</div>
				<div>
					<p>Tên người vay</p>
					<input type="text" class="form" value="<?= !empty($contractInfor->customer_infor->customer_name) ? $contractInfor->customer_infor->customer_name : ""; ?>" readonly>
				</div>
				<div>
					<p>Số tiền vay</p>
					<input type="text" class="form"  value="<?= !empty($contractInfor->receiver_infor->amount) ? number_format($contractInfor->receiver_infor->amount) : "" ?>" readonly>
				</div>
				<?php
				$amount_insurrance = 0;
				$type_amount_insurrance = '';
				if (isset($contractInfor->loan_infor->loan_insurance) && $contractInfor->loan_infor->loan_insurance == "1") {
					$amount_insurrance = isset($contractInfor->loan_infor->amount_GIC) ? $contractInfor->loan_infor->amount_GIC : 0;
					$type_amount_insurrance = "GIC";
				} else if (isset($contractInfor->loan_infor->loan_insurance) && $contractInfor->loan_infor->loan_insurance == "2") {
					$amount_insurrance = isset($contractInfor->loan_infor->amount_MIC) ? $contractInfor->loan_infor->amount_MIC : 0;
					$type_amount_insurrance = "MIC";
				}
				?>
				<div style="display: none">
					<p>Loại bảo hiểm khoản vay</p>
					<input type="text" class="form" value="<?= $type_amount_insurrance ?>" readonly>
				</div>
				<div style="display: none">
					<p>Phí bảo hiểm khoản vay</p>
					<input type="text" class="form" value="<?= !empty($amount_insurrance) ? number_format($amount_insurrance) : "" ?>" readonly>
				</div>
				<div style="display: none">
					<p>Phí bảo hiểm xe </p>
					<input type="text" class="form" value="<?= !empty($contractInfor->loan_infor->amount_GIC_easy) ? number_format($contractInfor->loan_infor->amount_GIC_easy) : "" ?>" readonly>
				</div>
				<div style="display: none">
					<p>Mã giao dịch ngân hàng </p>
					<input type="text" class="form form-color" id="code_transaction_bank_disbursement">
				</div>
				<div style="display: none">
					<p>Ngân hàng</p>
					<input type="text" class="form form-color" id="bank_name">
				</div>
				<?php
				if ($company_code == "2"){
					$note_content_transfer = "TCV giải ngân cho KH " . $contractInfor->customer_infor->customer_name;
				} else {
					$note_content_transfer = "TCVĐB giải ngân cho KH " . $contractInfor->customer_infor->customer_name;
				}
				?>
				<div style="display: none">
					<p>Nội dung chuyển khoản</p>
					<textarea class="form-text description" id="content_transfer"><?php echo $note_content_transfer ?></textarea>
				</div>
			</div>
			<div class="giaingan-right" >
				<div style="display: none">
					<p>Phí bảo hiểm phúc lộc thọ</p>
					<input type="text" class="form" value="<?= !empty($contractInfor->loan_infor->amount_GIC_plt) ? number_format($contractInfor->loan_infor->amount_GIC_plt) : "" ?>" readonly>
				</div>
				<div style="display: none">
					<p>Phí bảo hiểm VBI</p>
					<input type="text" class="form" value="<?= !empty($contractInfor->loan_infor->amount_VBI) ? number_format($contractInfor->loan_infor->amount_VBI) : "" ?>" readonly>
				</div>
				<div style="display: none">
					<p>Phí bảo hiểm TNDS</p>
					<input type="text" class="form" value="<?= !empty($contractInfor->loan_infor->bao_hiem_tnds->price_tnds) ? number_format($contractInfor->loan_infor->bao_hiem_tnds->price_tnds) : "0" ?>" readonly>
				</div>
				<div style="display: none">
					<p>Phí bảo hiểm PTI- Vững Tâm An</p>
					<input type="text" class="form" value="<?= !empty($contractInfor->loan_infor->bao_hiem_pti_vta->price_pti_vta) ? number_format($contractInfor->loan_infor->bao_hiem_pti_vta->price_pti_vta) : "0" ?>" readonly>
				</div>
				<div class="form_pti" style="display: none">
					<div class="form1">
						<p>PTI Gói BHTN</p>
						<input type="text" class="form" value="<?= !empty($contractInfor->loan_infor->pti_bhtn->goi) ? $contractInfor->loan_infor->pti_bhtn->goi : "" ?>" readonly>
					</div>
					<div class="form2">
						<p>PTI Phí BHTN</p>
						<input type="text" class="form" value="<?= !empty($contractInfor->loan_infor->pti_bhtn->phi) ? number_format($contractInfor->loan_infor->pti_bhtn->phi) : "0" ?>" readonly>
					</div>
				</div>
				<div>
					<p>Số tiền giải ngân</p>
					<input type="text" class="form" style="color: red;" value="<?= !empty($contractInfor->loan_infor->amount_loan) ? number_format($contractInfor->loan_infor->amount_loan) : "" ?>" readonly>
				</div>
				<?php
				// hình thức chuyển khoản tài khoản ngân hàng
				if ($type_payout == 2) {
					?>
					<div>
						<p>Số tài khoản</p>
						<input type="text" class="form bank_account" value="<?= !empty($contractInfor->receiver_infor->bank_account) ? $contractInfor->receiver_infor->bank_account : "" ?>" readonly>
					</div>
					<div>
						<p>Chủ tài khoản</p>
						<input type="text" class="form bank_account_holder"  value="<?= !empty($contractInfor->receiver_infor->bank_account_holder) ? $contractInfor->receiver_infor->bank_account_holder : "" ?>" readonly>
					</div>
					<div>
						<p>Ngân hàng</p>
						<input type="text" class="form" value="<?= !empty($contractInfor->receiver_infor->bank_name) ? $contractInfor->receiver_infor->bank_name : "" ?>" readonly>
					</div>
					<div>
						<p>Chi nhánh </p>
						<input type="text" class="form bank_branch"  value="<?= !empty($contractInfor->receiver_infor->bank_branch) ? $contractInfor->receiver_infor->bank_branch : "" ?>" readonly>
					</div>
				<?php } else if ($type_payout == 3) { ?>
					<div>
						<p>Số thẻ</p>
						<input type="text" class="form atm_card_number"  value="<?= !empty($contractInfor->receiver_infor->atm_card_number) ? $contractInfor->receiver_infor->atm_card_number : "" ?>" readonly>
					</div>
					<div>
						<p>Chủ thẻ</p>
						<input type="text" class="form atm_card_holder" value="<?= !empty($contractInfor->receiver_infor->atm_card_holder) ? $contractInfor->receiver_infor->atm_card_holder : "" ?>" readonly>
					</div>
				<?php } ?>

				<?php if (!empty($user_nextpay) && $user_nextpay == 1) : ?>
					<div class="ip-check">
						<input type="checkbox" id="vehicle1" name="chan_bao_hiem" value="1" checked disabled>
						<label for="vehicle1"> Chặn bảo hiểm</label><br>
					</div>
				<?php else: ?>
					<div class="ip-check">
						<input type="checkbox" id="vehicle1" name="chan_bao_hiem" value="1" <?= ($contractInfor->loan_infor->amount_money >= 100000000) ? "checked" : "" ?> >
						<label for="vehicle1"> Chặn bảo hiểm</label><br>
					</div>
				<?php endif; ?>

			</div>
		</div>
	</div>
	<div class="nhadautu">
		<div class="nhadautu-top">
			<h2>Nhà đầu tư </h2>
		</div>
		<div class="select_giaingan">
			<select id='investor'>
				<option value=''>Chọn nhà đầu tư</option>
				<?php
				if (!empty($listInvestor)) {
					foreach ($listInvestor as $key => $investor) {
						if (!in_array($investor->code, array('vimo', 'vfc'))) {
							?>
							<option value='<?= !empty($investor->_id->{'$oid'}) ? $investor->_id->{'$oid'} : ""; ?>'><?= !empty($investor->name) ? $investor->name : ""; ?></option>
						<?php }
					}
				} ?>
			</select>
		</div>
	</div>
	<div class="giaingan-ft">
		<a type="button" class="btn btn-secondary" href="<?php echo base_url('pawn/contract') ?>" style="background:#EBEBEB;width: 211px; ">Quay lại</a>

		<?php if (!isset($contractInfor->response_get_transaction_withdrawal_status_nl)) { ?>
			<button class="btn btn-success disbursement" data-toggle="modal" data-target="#approve_disbursement">
				Giải ngân hợp đồng
			</button>
		<?php } ?>
		<?php if (isset($contractInfor->response_get_transaction_withdrawal_status_nl) && in_array('tpb-ke-toan', $groupRoles)) { ?>
			<button class="btn btn-success disbursement" data-toggle="modal" data-target="#approve_disbursement">
				Giải ngân hợp đồng
			</button>
		<?php } ?>
		<button type="button" class="btn btn-success disbursement_disabled" data-toggle="modal" data-target="#approve_disbursement" style="display:none" disabled>Giải ngân hợp đồng</button>
		<input type="hidden" required name='contract_id' class="form-control "
			   value="<?= !empty($contractInfor->_id->{'$oid'}) ? $contractInfor->_id->{'$oid'} : "" ?>">
		<input type="hidden" required name='code_contract' class="form-control "
			   value="<?= !empty($contractInfor->code_contract) ? $contractInfor->code_contract : "" ?>">
		<input type="hidden" required name='type_payout' class="form-control "
			   value="<?= !empty($contractInfor->receiver_infor->type_payout) ? $contractInfor->receiver_infor->type_payout : "" ?>">
		<input type="hidden" required name='amount' class="form-control "
			   value="<?= !empty($contractInfor->receiver_infor->amount) ? $contractInfor->receiver_infor->amount : "" ?>">
		<input type="hidden" required name='bank_id' class="form-control "
			   value="<?= !empty($contractInfor->receiver_infor->bank_id) ? $contractInfor->receiver_infor->bank_id : "" ?>">
	</div>
</div>

<script>
	$(document).ready(function () {
		$('#vfc').click(function (event) {
			if (this.checked) {
				$('.ip-1').show()
				$('.ip-2').hide()
				$('.ip-3').hide()
			}
		})
		$('#vimo').click(function (event) {
			if (this.checked) {
				$('.ip-2').show()
				$('.ip-1').hide()
				$('.ip-3').hide()
			}
		})
		$('#self').click(function (event) {
			if (this.checked) {
				$('.ip-1').show()
				$('.ip-2').show()
				$('.ip-3').hide()
			}
		})

	});
</script>

<?php
if (!empty($listInvestor)) {
	foreach ($listInvestor as $key => $investor) {
		if ($investor->code == 'vimo') {
			?>
			<input type="hidden" required name='percent_interest_investor_vimo'
				   value="<?= !empty($investor->percent_interest_investor) ? $investor->percent_interest_investor : "" ?>">
		<?php } else if ($investor->code == 'vfc') { ?>
			<input type="hidden" required name='percent_interest_investor_vfc'
				   value="<?= !empty($investor->percent_interest_investor) ? $investor->percent_interest_investor : "" ?>">
		<?php }
	}
} ?>
<script>
	$('.selectinvestor').click(function (event) {
		var thetarget = $(this).data('target');
		$('.selectinvestor_action').addClass('d-none');
		$('#' + thetarget).removeClass('d-none')
	});
</script>
<div class="modal fade" id="approve_disbursement" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title title_modal_approve">Xác nhận giải ngân</h5>
				<hr>
				<div class="form-group">
					<p>Bạn có chắc chắn muốn giải ngân hợp đồng này ?</p>
				</div>
				<p class="text-right">
					<button class="btn btn-danger investors_disbursement_nl_submit">Xác nhận</button>
				</p>
			</div>

		</div>
	</div>
</div>

<script>
	$(function () {
		'use strict';
		var nowTemp = new Date();
		var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
		var checkin = $('#timeCheckIn').datepicker({
			onRender: function (date) {
				return (date.valueOf() < (nowTemp.valueOf() - 60 * 60 * 24 * 4 * 1000) || date.valueOf() > now.valueOf()) ? 'disabled' : '';
			}
		}).on('changeDate', function (ev) {
			var newDate = new Date(ev.date)
			newDate.setDate(newDate.getDate() + 1);
			checkin.hide();
		}).data('datepicker');
		var checkin1 = $('#timeCheckIn1').datepicker({
			onRender: function (date) {
				return (date.valueOf() < (nowTemp.valueOf() - 60 * 60 * 24 * 4 * 1000) || date.valueOf() > now.valueOf()) ? 'disabled' : '';
			}
		}).on('changeDate', function (ev) {
			var newDate = new Date(ev.date)
			newDate.setDate(newDate.getDate() + 1);
			checkin1.hide();
		}).data('datepicker');
	});
</script>

<script src="<?php echo base_url(); ?>assets/js/pawn/contract.js"></script>
<script src="<?php echo base_url(); ?>assets/datepicker/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datepicker/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datepicker/js/bootstrap-datepicker.js"></script>

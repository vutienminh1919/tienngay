<?php
$name = !empty($_GET['name']) ? $_GET['name'] : "";
$number_phone = !empty($_GET['number_phone']) ? $_GET['number_phone'] : "";
$identify = !empty($_GET['identify']) ? $_GET['identify'] : "";
$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
?>
<!-- page content -->
<style>
	.size18{
		font-size: 18px;
	}
</style>
<div class="right_col" role="main">
	<div class="theloading" style="display:none" >
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span ><?= $this->lang->line('Loading')?>...</span>
	</div>
	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>Quản lý HĐ quá hạn
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>/ <a href="#">Quản lý
								HĐ quá hạn</a></small>
					</h3>
				</div>

				<div class="title_right text-right">
					<form class="form-inline" id="form_baddebt" action="<?php echo base_url('badDebt/importBadDebt') ?>"
						  enctype="multipart/form-data" method="post">
						<strong><?= $this->lang->line('Upload') ?>&nbsp;</strong>
						<div class="form-group">
							<input type="file" name="upload_file" class="form-control" placeholder="sothing">
						</div>
						<button type="submit" class="btn btn-primary" id="import_baddebt"
								style="margin:0"><?= $this->lang->line('Upload') ?></button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12">
		<div class="x_panel">
			<div class="x_content">
				<?php if ($this->session->flashdata('error')) { ?>
					<div class="alert alert-danger alert-result">
						<?= $this->session->flashdata('error') ?>
					</div>
				<?php } ?>
				<?php if ($this->session->flashdata('success')) { ?>
					<div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
				<?php } ?>
				<div class="clearfix"></div>
			</div>
			<div class="x_title">
				<div class="row">
					<div class="col-xs-12">
						<div class="row">
							<form action="<?php echo base_url('badDebt')?>" method="get" style="width: 100%;">
								<div class="row">
									<div class="col-lg-2">
										<input type="text" name="code_contract" class="form-control" placeholder="Mã hợp đồng" value="<?= !empty($code_contract) ?  $code_contract : ""?>" >
									</div>
									<div class="col-lg-2">
										<input type="text" name="name" class="form-control" placeholder="Tên khách hàng" value="<?= !empty($name) ?  $name : ""?>" >
									</div>
									<div class="col-lg-2">
										<input type="text" name="number_phone" class="form-control" placeholder="Số điện thoại" value="<?= !empty($number_phone) ?  $number_phone : ""?>" >
									</div>
									<div class="col-lg-2">
										<input type="text" name="identify" class="form-control" placeholder="Số chứng minh" value="<?= !empty($identify) ?  $identify : ""?>" >
									</div>
									<div class="col-lg-2 text-right ">
										<button type="submit" class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i> <?= $this->lang->line('search')?></button>
									</div>
								</div>
								<br/>
								<div class="row">
									<div class="col-lg-2">
										<div class="input-group">
											<span class="input-group-addon"><?php echo $this->lang->line('from')?></span>
											<input type="date" name="fdate" class="form-control" value="<?= !empty($fdate) ?  $fdate : ""?>" >
										</div>
									</div>
									<div class="col-lg-2">
										<div class="input-group">
											<span class="input-group-addon"><?php echo $this->lang->line('to')?></span>
											<input type="date" name="tdate" class="form-control" value="<?= !empty($tdate) ?  $tdate : ""?>" >
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="col-xs-12">

						<div class="table-responsive">
							<table id="" class="table table-striped">
								<thead>
								<tr>
									<th>#</th>
									<th>Action</th>
									<th>ID người vay</th>
									<th><?= $this->lang->line('Contract_Code') ?></th>
									<th>Mã khách hàng</th>
									<th>Họ và tên</th>
									<th>Ngày sinh</th>
									<th>Giới tính</th>
									<th>Số điện thoại</th>
									<th>Số tham chiếu 1</th>
									<th>Số tham chiếu 2</th>
									<th>Chứng minh nhân dân</th>
									<th>Địa chỉ tạm chú</th>
									<th>Quận/Huyện tạm trú</th>
									<th>Tỉnh/Thành tạm trú</th>
									<th>Địa chỉ Thường trú</th>
									<th>Quận/Huyện thường trú</th>
									<th>Tỉnh/Thành thường trú</th>
									<th>Ngày kí hợp đồng</th>
									<th>Ngày đến hạn</th>
									<th>Số tiền vốn</th>
									<th>Lãi</th>
									<th>Phí liên kết khoản vay</th>
									<th>Số tiền cuối kì khách hàng<br/> phải thanh toán</th>
									<th>Số tiền khách hàng <br/>đã thanh toán</th>
									<th>Gốc còn lại cuối kì</th>
									<th>Kì hạn</th>
									<th>Mục đích vay</th>
									<th>Lịch sử thanh toán</th>
									<th>Số lần vay</th>
									<th>Thông tin gói vay</th>
									<th>Ngày bàn giao</th>
									<th>DPD</th>
									<th>Kết quả nhắc HĐV</th>
									<th>Ngày hẹn thanh toán</th>
									<th>Số tiền hẹn thanh toán</th>
									<th>Ghi chú</th>
								</tr>
								</thead>

								<tbody>
								<!-- <tr>
                                <td colspan="13" class="text-center">Không có dữ liệu</td>
                              </tr> -->
								<?php
								if (!empty($baddebt)) {
									foreach ($baddebt as $key => $value) {
										?>
										<tr>
											<td><?php echo $key + 1 ?></td>
											<td>
												<a href="<?php echo base_url('badDebt/viewNote?id='.$value->_id->{'$oid'}) ?>" class="btn btn-info">Xem ghi chú</a>
											</td>
											<td><?= !empty($value->id) ? $value->id : "" ?></td>
											<td><?= !empty($value->code_contract) ? (string)$value->code_contract : "" ?></td>
											<td><?= !empty($value->code_customer) ? $value->code_customer : "" ?></td>
											<td><?= !empty($value->name) ? $value->name : "" ?></td>
											<td><?= !empty($value->DOB) ? $value->DOB : "" ?></td>
											<td><?= !empty($value->sex) ? $value->sex : "" ?></td>
											<td><?= !empty($value->number_phone) ? "0".substr($value->number_phone,0,3)."***". substr($value->number_phone,6,12) : "" ?>
												<a href="javascript:void(0)"
												   onclick="call_for_customer(<?= !empty($value->number_phone) ? encrypt($value->number_phone) : "" ?> , '<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : "" ?>', 'customer')"
												   class="call_for_customer"><i class="fa fa-phone blue size18" aria-hidden="true"></i></a></td>
											<td><?= !empty($value->relative_phone_1) ? "0".substr($value->relative_phone_1,0,3)."***". substr($value->relative_phone_1,6,12) : "" ?>
												<a href="javascript:void(0)"
												   onclick="call_for_customer(<?= !empty($value->relative_phone_1) ? encrypt($value->relative_phone_1) : "" ?> , '<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : "" ?>', 'rel1')"
												   class="call_for_customer"><i class="fa fa-phone blue size18" aria-hidden="true"></i></a></td>
											<td><?= !empty($value->relative_phone_2) ? "0".substr($value->relative_phone_2,0,3)."***". substr($value->relative_phone_2,6,12) : "" ?>
												<a href="javascript:void(0)"
												   onclick="call_for_customer(<?= !empty($value->relative_phone_2) ? encrypt($value->relative_phone_2) : "" ?> , '<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : "" ?>', 'rel2')"
												   class="call_for_customer"><i class="fa fa-phone blue size18" aria-hidden="true"></i></a></td>
											<td><?= !empty($value->identify) ? "0".substr($value->identify,0,3)."***". substr($value->identify,6,12) : "" ?></td>
											<td><?= !empty($value->current_address) ? $value->current_address : "" ?></td>
											<td><?= !empty($value->current_district) ? $value->current_district : "" ?></td>
											<td><?= !empty($value->current_province) ? $value->current_province : "" ?></td>
											<td><?= !empty($value->household_address) ? $value->household_address : "" ?></td>
											<td><?= !empty($value->household_district) ? $value->household_district : "" ?></td>
											<td><?= !empty($value->household_province) ? $value->household_province : "" ?></td>
											<td><?= !empty($value->date_sign_contract) ? $value->date_sign_contract : "" ?></td>
											<td><?= !empty($value->date_maturity) ? date('d/m/Y', $value->date_maturity) : "" ?></td>
											<td><?= !empty($value->amount) ? $value->amount : "" ?></td>
											<td><?= !empty($value->amount_interest) ? $value->amount_interest : "" ?></td>
											<td><?= !empty($value->loan_fee) ? $value->loan_fee : "" ?></td>
											<td><?= !empty($value->closing_amount) ? $value->closing_amount : "" ?></td>
											<td><?= !empty($value->amount_customer_paid) ? $value->amount_customer_paid : "" ?></td>
											<td><?= !empty($value->closing_balance) ? $value->closing_balance : "" ?></td>
											<td><?= !empty($value->period) ? $value->period : "" ?></td>
											<td><?= !empty($value->loan_purpose) ? $value->loan_purpose : "" ?></td>
											<td><?= !empty($value->pay_history) ? $value->pay_history : "" ?></td>
											<td><?= !empty($value->number_of_loan) ? $value->number_of_loan : "" ?></td>
											<td><?= !empty($value->loan_info_package) ? $value->loan_info_package : "" ?></td>
											<td><?= !empty($value->data_of_delivery) ? $value->data_of_delivery : "" ?></td>
											<td><?= !empty($value->DPD) ? $value->DPD : "" ?></td>
											<td>
												<?php foreach (note_renewal() as $k => $v) { ?>
													<?php if($k == $value->result_remind_baddebt){echo $v;}?>
												<?php } ?>
											</td>
											<td><?= !empty($value->payment_date) ? gmdate("d-m-Y", $value->payment_date) : "" ?></td>
											<td><?= !empty($value->amount_payment_appointment) ? $value->amount_payment_appointment : "" ?></td>
											<td><?= !empty($value->note) ? $value->note : "" ?></td></td>
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

<!-- /page content -->
<div class="modal fade" id="approve" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>

				<button id="call" class="btn btn-success"><i class="fa fa-phone" aria-hidden="true"></i>Gọi</button>
				<button id="end" class="btn btn-danger"><i class="fa fa-ban" aria-hidden="true"></i> Dừng</button>
				<input id="number" name="phone_number" type="hidden" value=""/>
				<p id="status" style="margin-left: 125px;"></p>
				<h3 class="modal-title title_modal_approve"></h3>
				<hr>
				<div class="form-group">
					<label>Kết quả nhắc HĐV:</label>
					<select class="form-control result_reminder" name="note_renewal">
						<?php foreach (note_renewal() as $key => $value) { ?>
							<option value="<?= $key ?>"><?= $value ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label>Ngày hẹn thanh toán:</label>
					<input type="date" name="payment_date" class="form-control payment_date" >
				</div>
				<div class="form-group">
					<label>Số tiền hẹn thanh toán:</label>
					<input type="text" class="form-control amount_payment_appointment">
				</div>
				<div class="form-group">
					<label>Ghi chú:</label>
					<textarea class="form-control contract_v2_note" rows="5"></textarea>
					<input type="hidden" class="form-control contract_id">
				</div>
				</table>
				<p class="text-right">
					<button  class="btn btn-danger approve_submit">Xác nhận</button>
				</p>
			</div>

		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>assets/js/baddebt/index.js"></script>
<script>
	$('.result_reminder').selectize();
</script>




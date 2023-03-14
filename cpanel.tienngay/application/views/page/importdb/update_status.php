
<!-- page content -->
<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$type = !empty($_GET['type']) ? $_GET['type'] : "";
	$group_debt = !empty($_GET['group_debt']) ? $_GET['group_debt'] : "";
    	$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
	$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
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
				<div class="title_left">
					<h3>Danh sách hợp đồng import <?=($type=="dangvay") ? "đang vay" : 'tất toán' ?>
						<br>
						<small>
							<a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#>">Danh sách hợp đồng </a>
						</small>
					</h3>
				</div>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">

					<div class="row">
						<div class="col-xs-12 col-lg-12">
							<div class="row">
								<form action="<?php echo base_url('importDatabase/import_change_status')?>" method="get" style="width: 100%;">
									<div class="col-lg-3">
										<label></label>
										<div class="input-group">
											<span class="input-group-addon"><?php echo $this->lang->line('from')?></span>
											<input type="date" name="fdate" class="form-control" value="<?= !empty($fdate) ?  $fdate : ""?>" >
										</div>
									</div>
									<div class="col-lg-3">
										<label></label>
										<div class="input-group">
											<span class="input-group-addon"><?php echo $this->lang->line('to')?></span>
											<input type="date" name="tdate" class="form-control" value="<?= !empty($tdate) ?  $tdate : ""?>" >

										</div>
									</div>
							<input type="hidden" name="type" class="form-control" value="<?= !empty($type) ?  $type : ""?>" >
						<div class="col-lg-2">
										<label>Họ và tên</label>
										<input type="text" name="customer_name" class="form-control" placeholder="Tên khách hàng" value="<?php echo $customer_name; ?>">
									</div>

									<div class="col-lg-2">
										<label>Mã hợp đồng</label>
										<input type="text" name="code_contract_disbursement" class="form-control" placeholder="Mã hợp đồng" value="<?php echo $code_contract_disbursement; ?>">
									</div>
									<div class="col-lg-2 text-right">
										<label></label>
										<button type="submit" class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i> <?= $this->lang->line('search')?></button>
									</div>
								</form>
							</div>

						</div>
					</div>
<!--					<div class="col-lg-2 text-right">-->
<!--						<label></label>-->
<!--						<a style="background-color: #18d102;"-->
<!--						   href="--><?//= base_url() ?><!--excel/exportAllRemindDebt?fdate=--><?//= $fdate . '&tdate=' . $tdate . '&code_contract_disbursement=' . $code_contract_disbursement . '&customer_name=' . $customer_name?><!--"-->
<!--						   class="btn btn-primary w-100" target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;-->
<!--							Xuất excel</a>									</div>-->
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="row">
						<div class="col-xs-12">
							<div ><?php echo $result_count;?></div>
							<div class="table-responsive">
								<table id="datatable-button" class="table table-striped">
									<thead>
									<tr>
										<th>#</th>
										
										<th><?= $this->lang->line('Contract_code')?></th>
										<th>Mã phiếu ghi</th>
										<th><?= $this->lang->line('Customer')?></th>
										<th>Mã nhà đầu tư</th>
										<th>Ngày giải ngân</th>
										<th>Trạng thái</th>
                                       <th>Chi tiết</th>
										
									</tr>
									</thead>

									<tbody>
									<?php
									if(!empty($contractData)){
//										echo "<pre>";
//										print_r($contractData);
//										echo "</pre>";
//										die();
										$time=0;
										foreach($contractData as $key => $contract){
										

											?>

											<tr>
												<td><?php echo $key+1?></td>
											
												
												<td><?= !empty($contract->code_contract_disbursement) ? $contract->code_contract_disbursement : "" ?></td>
											 <td><?= !empty($contract->code_contract) ? $contract->code_contract : "" ?></td> 
												<td><?= !empty($contract->customer_infor->customer_name) ? $contract->customer_infor->customer_name : ""?></td>
												<td><?= !empty($contract->investor_code) ? $contract->investor_code : ""?></td>
                                            <td><?= !empty($contract->disbursement_date) ? date('d/m/Y', $contract->disbursement_date) : "" ?></td>
                                              <td>
													<?php
													$status = !empty($contract->status) ? $contract->status : "";
													if ($status == 0) {
														echo "Nháp";
													} else if ($status == 1) {
														echo "Mới";
													} else if ($status == 2) {
														echo "Chờ trưởng PGD duyệt";
													} else if ($status == 3) {
														echo "Đã hủy";
													} else if ($status == 4) {
														echo "Trưởng PGD không duyệt";
													} else if ($status == 5) {
														echo "Chờ hội sở duyệt";
													} else if ($status == 6) {
														echo "Đã duyệt";
													} else if ($status == 7) {
														echo "Kế toán không duyệt";
													} else if ($status == 8) {
														echo "Hội sở không duyệt";
													} else if ($status == 9) {
														echo "Chờ ngân lượng xử lý";
													} else if ($status == 10) {
														echo "Ngân lượng giải ngân thất bại";
													} else if ($status == 15) {
														echo "Chờ giải ngân";
													} else if ($status == 16) {
														echo "Tạo lệnh giải ngân thành công";
													} else if ($status == 17) {
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
												
                                            <td> <a class="btn btn-primary" target="_blank"  href="<?php echo base_url("accountant/view_v2?id=").$contract->_id->{'$oid'}?>" >
							                 Chi tiết 
							              </a> </td>
												
											</tr>
										<?php }} ?>

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
</div>

<div class="modal fade" id="note_contract_v2" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<h4 class="modal-title title_modal_contract_v2"><b>Ghi chú</b></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			<button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">Thoát</button>
			<button id="call" class="btn btn-success"><i class="fa fa-phone" aria-hidden="true"></i>Gọi</button>
			<button id="end" class="btn btn-danger"><i class="fa fa-ban" aria-hidden="true"></i> Dừng</button>

			<input id="number" name="phone_number" type="hidden" value=""/>
			<p id="status" style="margin-left: 125px;"></p>
				
				<input type="hidden"   class="form-control contract_id">
				
				<hr>
				<div class="form-group">
					<label>Kết quả nhắc HĐ vay:</label>
					<select class="form-control result_reminder" name="" style="width: 70%">
						<?php foreach(note_renewal() as $key => $value){ ?>
							<option  value="<?=$key?>"><?= $value ?></option>
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
					<textarea class="form-control contract_v2_note" rows="5" ></textarea>
					<input type="hidden"   class="form-control contract_id">
				</div>
				</table>
				<p class="text-right">
					<button  class="btn btn-danger note_contract_v2_submit">Xác nhận</button>
				</p>
			</div>

		</div>
	</div>
</div>

<script src="<?php echo base_url();?>assets/js/accountant/index.js"></script>

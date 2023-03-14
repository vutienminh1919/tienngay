<style>
	.label{
		font-size: 100%;
	}
</style>
<div class="right_col" role="main">

	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$store = !empty($_GET['store']) ? $_GET['store'] : "";
	$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
	$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
	$code_contract_disbursement_search = !empty($_GET['code_contract_disbursement_search']) ? $_GET['code_contract_disbursement_search'] : "";
	$status = !empty($_GET['status']) ? $_GET['status'] : "";
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
					<h3>DANH SÁCH PHIẾU THU HỢP ĐỒNG KIỂM SOÁT NỘI BỘ</h3>
				</div>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-xs-12 col-md-6">
							<h2>Tổng số phiếu thu: <?= !empty($total_rows) ? $total_rows : 0 ?></h2>
						</div>
						<div class="col-xs-12 col-md-6 text-right">

							<button class="show-hide-total-all btn btn-success dropdown-toggle"
									onclick="$('#lockdulieu').toggleClass('show');">
								<span class="fa fa-filter"></span>
								Lọc dữ liệu
							</button>
							<form action="<?php echo base_url('contract_ksnb/search_list_transaction') ?>" method="get">
								<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
									style="padding:15px;min-width:400px;">

									<li class="form-group">
										<div class="row">
											<div class="col-xs-12 col-md-6">
												<div class="form-group">
													<label>Từ:</label>
													<input type="date" name="fdate" class="form-control"
														   value="<?= !empty($fdate) ? $fdate : "" ?>">
												</div>
											</div>
											<div class="col-xs-12 col-md-6">
												<div class="form-group">
													<label>Đến:</label>
													<input type="date" name="tdate" class="form-control"
														   value="<?= !empty($tdate) ? $tdate : "" ?>">
												</div>
											</div>
										</div>
									</li>

									<li class="form-group">
										<label>Phòng giao dịch: </label>
										<select class="form-control" name="store">
											<option value="">-- Tất cả --</option>
											<?php foreach ($stores as $key => $item): ?>
												<?php if ($item->status != "active") {
													continue;
												}
												$check = $item->_id->{'$oid'};
												?>
												<option value="<?= $item->_id->{'$oid'} ?>" <?= (!empty($store) && $store == "$check") ? "selected" : "" ?>><?= $item->name ?></option>
											<?php endforeach; ?>
										</select>
									</li>
									<li class="form-group">
										<label>Họ và tên: </label>
										<input type="text" name="customer_name" class="form-control"
											   value="<?= !empty($customer_name) ? $customer_name : "" ?>">
									</li>
									<li class="form-group">
										<label>Mã phiếu ghi: </label>
										<input type="text" name="code_contract" class="form-control"
											   value="<?= !empty($code_contract) ? $code_contract : "" ?>">
									</li>
									<li class="form-group">
										<label>Mã hợp đồng: </label>
										<input type="text" name="code_contract_disbursement_search" class="form-control"
											   value="<?= !empty($code_contract_disbursement_search) ? $code_contract_disbursement_search : "" ?>">
									</li>
									<li class="form-group">
										<label>Trạng thái: </label>
										<select class="form-control" name="status">
											<option value="" <?= ($status == "") ? "selected" : "" ?>>-- Tất cả --</option>
											<option value="4" <?= ($status == "4") ? "selected" : "" ?>>Chưa gửi duyệt</option>
											<option value="2" <?= ($status == "2") ? "selected" : "" ?>>Chờ xác nhận</option>
											<option value="1" <?= ($status == "1") ? "selected" : "" ?>>Đã duyệt</option>
											<option value="3" <?= ($status == "3") ? "selected" : "" ?>>Hủy</option>
											<option value="11" <?= ($status == "11") ? "selected" : "" ?>>Trả về</option>
											<option value="5" <?= ($status == "5") ? "selected" : "" ?>>Chờ chuyển tiền về công ty</option>

										</select>
									</li>


									<li class="text-right">
										<button class="btn btn-info" type="submit">
											<i class="fa fa-search" aria-hidden="true"></i>
											Tìm Kiếm
										</button>
									</li>

								</ul>
							</form>

						</div>


					</div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="table-responsive">
						<table id="summary-total"
							   class="table table-bordered m-table table-hover table-calendar table-report" style="font-size: 14px;font-weight: 400;">
							<thead style="background:#5A738E; color: #ffffff;">
							<tr>
								<th style="text-align: center">STT</th>
								<th style="text-align: center">Mã hợp đồng</th>
								<th style="text-align: center">Tên khách hàng</th>
								<th style="text-align: center">Mã phiếu ghi</th>
								<th style="text-align: center">Phòng giao dịch</th>
								<th style="text-align: center">Ngày thanh toán</th>
								<th style="text-align: center">Số tiền thu</th>
								<th style="text-align: center">Người thanh toán</th>
								<th style="text-align: center">Hình thức trả</th>
								<th style="text-align: center">Nội dung thu</th>
								<th style="text-align: center">Ngân hàng</th>
								<th style="text-align: center">Mã giao dịch</th>
								<th style="text-align: center">Số tiền thực nhận</th>
								<th style="text-align: center">Ngày bank nhận</th>
								<th style="text-align: center">Phí giảm trừ</th>
								<th style="text-align: center">Kế toán ghi chú</th>
								<th style="text-align: center">Người tạo</th>
								<th style="text-align: center">Trạng thái</th>
								<th style="text-align: center">Chức năng</th>
							</tr>
							</thead>
							<tbody>
							<?php if (!empty($transactionData)): ?>
								<?php foreach ($transactionData as $key => $value): ?>
								<tr>
									<td style="text-align: center"><?= ++$key ?></td>
									<td style="text-align: center"><?= !empty($value->code_contract_disbursement) ? $value->code_contract_disbursement : "" ?></td>
									<td style="text-align: center"><?= !empty($value->customer_name) ? $value->customer_name : "" ?></td>
									<td style="text-align: center"><?= !empty($value->code_contract) ? $value->code_contract : "" ?></td>
									<td style="text-align: center"><?= !empty($value->store->name) ? $value->store->name : "" ?></td>
									<td style="text-align: center"><?= !empty($value->date_pay) ? date("d/m/y", $value->date_pay) : "" ?></td>
									<td style="text-align: center"><?= !empty($value->total) ? number_format($value->total) : "" ?></td>
									<td style="text-align: center"><?= !empty($value->customer_bill_name) ? $value->customer_bill_name : "" ?></td>
									<td style="text-align: center">
										<?php
										$method = '';
										if (intval($value->payment_method) == 0) {
											$method = $value->payment_method;
										} else {
											if (intval($value->payment_method) == 1) {
												$method = $this->lang->line('Cash');
											} else if (intval($value->payment_method) == 2) {
												$method = 'Chuyển khoản';
											}
										}
										echo $method;
										?>
									</td>
									<td style="text-align: center">
										<?php
										$content_billing = '';
										$notes = !empty($value->note) ? $value->note : "";
										if (is_array($notes)) {
											foreach ($notes as $note) {
												$content_billing .= billing_content($note);
											}
											echo $content_billing;
										} else {
											echo $value->note;
										}
										?>
									</td>
									<td style="text-align: center"><?= !empty($value->bank) ? $value->bank : "" ?></td>
									<td style="text-align: center"><?= !empty($value->code_transaction_bank) ? $value->code_transaction_bank : "" ?></td>
									<td style="text-align: center"><?= !empty($value->amount_actually_received) ? number_format($value->amount_actually_received) : "" ?></td>
									<td style="text-align: center"><?= !empty($value->date_bank) ? date("d/m/y", $value->date_bank) : "" ?></td>
									<td style="text-align: center"><?= !empty($value->discounted_fee) ? number_format($value->discounted_fee) : "" ?></td>
									<td style="text-align: center"><?= !empty($value->approve_note) ? ($value->approve_note) : "" ?></td>
									<td style="text-align: center"><?= !empty($value->created_by) ? $value->created_by : "" ?></td>
									<td style="text-align: center">
										<?php if ($value->status == 1) : ?>
											<span class="label label-success">Kế toán đã duyệt</span>
										<?php elseif ($value->status == 2): ?>
											<span class="label label-default">Chờ kế toán xác nhận</span>
										<?php elseif ($value->status == 3): ?>
											<span class="label label-danger">Kế toán Hủy</span>
										<?php elseif ($value->status == 4): ?>
											<span class="label label-warning">Chưa gửi duyệt</span>
										<?php elseif ($value->status == 11): ?>
											<span class="label label-primary">Kế toán trả lại</span>
										<?php elseif ($value->status == 5): ?>
											<span class="label label-info">Chờ nạp tiền về cty</span>
										<?php endif; ?>
									</td>
									<td class="text-center">
										<div class="dropdown" style="display:inline-block">
											<button class="btn btn-primary btn-sm dropdown-toggle" type="button"
													data-toggle="dropdown">
												<i class="fa fa-cogs"></i>
												<span class="caret"></span></button>
											<ul class="dropdown-menu dropdown-menu-right">
												<?php
												if (in_array($value->status, [4, 11]) && in_array($value->type, [3, 4, 5])) { ?>
													<li><a class="dropdown-item"
														   href="<?php echo base_url('transaction/sendApprove?id=' . $value->id) . '&view=QLHDV'; ?>">
															<i class="fa fa-paper-plane-o"> <?php echo "Gửi duyệt" ?></i>
														</a>
													</li>
												<?php } ?>
												<?php
												if (!in_array($value->status, [1, 3])) {
													?>
													<li>
														<a href="<?php echo base_url("transaction/upload?id=") . $value->id ?>"
														   class="dropdown-item"><i class="fa fa-upload"></i>&nbsp;&nbsp;Tải lên chứng từ
														</a></li>
												<?php } ?>
												<li>
													<a href="<?php echo base_url("transaction/viewImg?id=") . $value->id ?>"
													   class="dropdown-item "><i class="fa fa-address-card-o"></i>&nbsp;&nbsp;Xem chứng từ
													</a></li>

												<li>
													<a href="javascript:void(0)"
													   onclick="note_ksnb(this)"
													   data-id="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""; ?>">
														<i class="fa fa-sticky-note-o"></i> Ghi chú
													</a>
												</li>
												<li>
													<a href="<?php echo base_url("contract_ksnb/history?id=") . $value->id  ?>"
													   class="dropdown-item "><i class="fa fa-history"></i>&nbsp;&nbsp;Lịch sử xử lý
													</a></li>

												<li>


											</ul>
										</div>
									</td>
								</tr>
								<?php endforeach; ?>
							<?php endif; ?>
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


<!--Modal-->
<div class="modal fade" id="note_contract" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-hs" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center">Thêm Ghi Chú</h3>
			</div>
			<div class="theloading" style="display:none;">
				<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
				<span><?= $this->lang->line('Loading') ?>...</span>
			</div>
			<div class="alert alert-danger alert-dismissible text-center" style="display:none"
				 id="div_errorCreate_3">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<span class='div_errorCreate'></span>
			</div>
			<div class="modal-body ">
				<div class="row">
					<div class="col-xs-12">
						<input type="hidden" id="contract_ksnb_id">
						<div class="modal-body">
							<div class="form-group row">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" style="font-size: 15px">
									Ghi chú
									<span class="text-danger">*</span> :
								</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<textarea class="form-control" id="note_ksnb" name="note_ksnb" rows="4"></textarea>
								</div>
							</div>

						</div>
						<div style="text-align: center">
							<button type="button" id="submit_contract_ksnb" class="btn btn-info">Đồng ý</button>
							<button type="button" class="btn btn-primary close-hs" data-dismiss="modal"
									aria-label="Close">
								Thoát
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>


<script src="<?php echo base_url("assets/") ?>js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets/") ?>js/numeral.min.js"></script>

<script>
	function note_ksnb(thiz) {
		let _id = $(thiz).data("id");

		$("#contract_ksnb_id").val(_id);

		$("#note_contract").modal("show");
	}
	$(document).ready(function () {

		$('#submit_contract_ksnb').click(function (event) {
			event.preventDefault();

			var contract_ksnb_id = $('#contract_ksnb_id').val();
			var note_ksnb = $('#note_ksnb').val();

			$.ajax({
				url: _url.base_url + '/contract_ksnb/approve_note',
				method: "POST",
				data: {
					id: contract_ksnb_id,
					note: note_ksnb,
				},

				beforeSend: function () {
					$(".theloading").show();
				},
				success: function (data) {
					console.log(data)
					$(".theloading").hide();
					if (data.data.status == 200) {
						$("#successModal").modal("show");
						$(".msg_success").text('Xác nhận thành công');

						setTimeout(function () {
							window.location.href = _url.base_url + 'contract_ksnb/list_transaction';
						}, 3000);
					} else {

						$("#div_errorCreate_3").css("display", "block");
						$(".div_errorCreate").text(data.data.message);

						setTimeout(function () {
							$("#div_errorCreate_3").css("display", "none");
						}, 4000);
					}
				},
				error: function (data) {
					console.log(data);
					$(".theloading").hide();
				}
			});

		});
	});

</script>








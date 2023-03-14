<?php
$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
$id_card = !empty($_GET['id_card']) ? $_GET['id_card'] : "";
$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
$code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
$store_id = !empty($_GET['store']) ? $_GET['store'] : "";
$status = !empty($_GET['status']) ? $_GET['status'] : "17";
$loan_product = !empty($_GET['loan_product']) ? $_GET['loan_product'] : "";
?>
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3>Quản lý hợp đồng đang vay
					<br>
					<small>
						<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
								href="<?php echo base_url('debt_manager_app/view_contract') ?>">Quản lý hợp đồng đang
							vay</a>
					</small>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<!--Xuất excel-->
						<div class="row">
							<div class="col-xs-12 col-12">
								<?php if ($this->session->flashdata('error')) { ?>
									<div class="alert alert-danger alert-result">
										<?= $this->session->flashdata('error') ?>
									</div>
								<?php } ?>
								<?php if ($this->session->flashdata('success')) { ?>
									<div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
								<?php } ?>
								<div class="row">
									<form action="<?php echo base_url('debt_manager_app/view_contract') ?>"
										  method="get"
										  style="width: 100%;">
										<div class="col-lg-2">
											<div class="form-group">
												<label>Từ</label>
												<input type="date" name="fdate" class="form-control"
													   value="<?= !empty($fdate) ? $fdate : "" ?>">
											</div>
										</div>
										<div class="col-lg-2">
											<div class="form-group">
												<label>Đến</label>
												<input type="date" name="tdate" class="form-control"
													   value="<?= !empty($tdate) ? $tdate : "" ?>">
											</div>
										</div>
										<div class="col-lg-2">
											<div class="form-group">
												<label>Mã phiếu ghi</label>
												<input type="text" name="code_contract" class="form-control"
													   placeholder="Mã phiếu ghi" value="<?php echo $code_contract; ?>">
											</div>
										</div>
										<div class="col-lg-2">
											<div class="form-group">
												<label>Mã hợp đồng</label>
												<input type="text" name="code_contract_disbursement"
													   class="form-control"
													   placeholder="Mã hợp đồng"
													   value="<?php echo $code_contract_disbursement; ?>">
											</div>
										</div>
										<div class="col-lg-2">
											<div class="form-group">
												<label>Họ và tên</label>
												<input type="text" name="customer_name" class="form-control"
													   placeholder="Tên khách hàng"
													   value="<?php echo $customer_name; ?>">
											</div>
										</div>
										<div class="col-lg-2">
											<div class="form-group">
												<label>CMND</label>
												<input type="text" name="id_card" class="form-control"
													   placeholder="CMND" value="<?php echo $id_card; ?>">
											</div>
										</div>
										<div class="col-lg-2">
											<div class="form-group">
												<label> Phòng giao dịch </label>
												<select name="store"
														class="form-control">
													<option value="">Tất cả</option>
													<?php foreach ($stores as $key => $store) : ?>
														<option <?php echo $store_id == $key ? 'selected' : '' ?>
																value="<?php echo $key ?>"><?php echo $store ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
										<div class="col-lg-2">
											<div class="form-group">
												<label> Trạng thái hợp đồng </label>
												<select name="status"
														class="form-control">
													<option value="">Tất cả</option>
													<?php foreach (contract_status() as $k => $s) : ?>
														<option <?php echo $status == $k ? 'selected' : '' ?>
																value="<?php echo $k ?>"><?php echo $s ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
										<div class="col-lg-2">
											<div class="form-group">
												<label> Sản phẩm vay </label>
												<select name="loan_product"
														class="form-control">
													<option value="">Tất cả</option>
													<?php foreach (loan_product() as $k => $s) : ?>
														<option <?php echo $loan_product == $k ? 'selected' : '' ?>
																value="<?php echo $k ?>"><?php echo $s ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
										<div class="col-lg-2">
											<div class="form-group">
												<label>&nbsp;</label>
												<button type="submit"
														class="btn btn-primary w-100"><i
															aria-hidden="true"></i>&nbsp; Tìm kiếm
												</button>
											</div>
										</div>
										<div class="col-lg-2">
											<div>
												<label for="">&nbsp;</label>
												<a style="background-color: #18d102;"
												   href="<?= base_url() ?>excel/excel_contract_ho?code_contract_disbursement=<?= $code_contract_disbursement . '&fdate=' . $fdate . '&tdate=' . $tdate . '&code_contract=' . $code_contract . '&customer_name=' . $customer_name . '&id_card=' . $id_card . '&store=' . $store_id . '&status=' . $status?>"
												   class="btn btn-primary w-100" target="_blank"><i
															class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
													Xuất excel
												</a>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="table-responsive">
			<div>Hiển thị
				<span class="text-danger"><?php echo $total_rows > 0 ? $total_rows : 0; ?> </span>
				Kết quả
			</div>
			<table class="table table-striped table-hover table-bordered">
				<thead>
				<tr>
					<th style="text-align: center">#</th>
					<th style="text-align: center">Mã phiếu ghi</th>
					<th style="text-align: center">Mã hợp đồng</th>
					<th style="text-align: center">Khách hàng</th>
					<th style="text-align: center">Tiền giải ngân</th>
					<th style="text-align: center">Hình thức vay</th>
					<th style="text-align: center">Sản phẩm vay</th>
					<th style="text-align: center">Kì hạn vay</th>
					<th style="text-align: center">Số ngày trễ</th>
					<th style="text-align: center">Nhóm </th>
					<th style="text-align: center">Số kì thanh toán</th>
					<th style="text-align: center">Gốc còn lại</th>
					<th style="text-align: center">PGD</th>
					<th style="text-align: center">CMND/CCCD</th>
					<th style="text-align: center">Tỉnh hộ khẩu</th>
					<th style="text-align: center">Ngày giải ngân</th>
					<th style="text-align: center">Người phê duyệt</th>
					<th style="text-align: center">Ngoại lệ</th>
				</tr>
				</thead>
				<tbody>
				<?php if (!empty($contract)) : ?>
					<?php foreach ($contract as $key => $value) : ?>
						<?php
						$district = !empty($value->current_address->district) ? get_district_name_by_code($value->current_address->district) : '';
						$province = !empty($value->current_address->province) ? get_province_name_by_code($value->current_address->province) : '';
						?>
						<tr id="contract-user-<?php echo $value->_id->{'$oid'} ?>" style="text-align: center">
							<td><?php echo ++$key ?></td>
							<td>
								<?php echo !empty($value->code_contract) ? $value->code_contract : '' ?>
								<br>
								<a class="btn btn-success btn-sm" target="_blank"
								   href="<?php echo base_url("pawn/detail?id=") . $value->_id->{'$oid'} ?>">Chi
									tiết</a>
							</td>
							<td>
								<?php echo !empty($value->code_contract_disbursement) ? $value->code_contract_disbursement : '' ?>
							</td>
							<td><?php echo !empty($value->customer_infor->customer_name) ? $value->customer_infor->customer_name : '' ?></td>
							<td><?php echo !empty($value->loan_infor->amount_money) ? number_format($value->loan_infor->amount_money) : '' ?></td>
							<td><?php echo ($value->loan_infor->type_interest == 1) ? "Lãi hàng tháng, gốc hàng tháng" : "Lãi hàng tháng, gốc cuối kỳ" ?></td>
							<td><?php echo !empty($value->loan_infor->loan_product->text) ? ($value->loan_infor->loan_product->text) : '' ?></td>
							<td><?php echo !empty($value->loan_infor->number_day_loan) ? $value->loan_infor->number_day_loan / 30 . ' tháng' : '' ?></td>
							<td><?php echo !empty($value->debt) ? ($value->debt->so_ngay_cham_tra) : '' ?></td>
							<td><?php echo !empty($value->debt) ? get_bucket($value->debt->so_ngay_cham_tra) : '' ?></td>
							<td><?php echo !empty($value->so_ki_thanh_toan) ? ($value->so_ki_thanh_toan) : 0 ?></td>
							<td><?php echo $value->status == 17 && !empty($value->original_debt) ? number_format($value->original_debt->du_no_goc_con_lai) : '' ?></td>
							<td><?php echo !empty($value->store) ? ($value->store->name) : '' ?></td>
							<td><?php echo !empty($value->customer_infor) ? ($value->customer_infor->customer_identify) : '' ?></td>
							<td><?php echo $district . '/' . $province ?></td>
							<td><?php echo !empty($value->disbursement_date) ? date('d-m-Y', $value->disbursement_date) : '' ?></td>
							<td><?php echo !empty($value->nguoi_duyet) ? $value->nguoi_duyet : '' ?></td>
							<td>
								<?php foreach ($value->ngoai_le as $item): ?>
									<?php echo lead_exception($item) . '<br>' ?>
								<?php endforeach; ?>

							</td>
						</tr>
					<?php endforeach; ?>
				<?php else : ?>
					<tr>
						<td colspan="20" class="text-center">Không có dữ liệu</td>
					</tr>
				<?php endif; ?>
				</tbody>
			</table>
			<div class="">
				<?php echo $pagination; ?>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/debt/contract.js"></script>




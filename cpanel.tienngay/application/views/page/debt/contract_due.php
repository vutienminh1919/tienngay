<?php
$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
$id_store = !empty($_GET['store']) ? $_GET['store'] : "";
$customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
$code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
?>
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="col-xs-12">
		<div class="page-title">
			<div class="title_left">
				<h3>Danh sách HD đến hạn
					<br>
					<small>
						<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
								href="<?php echo base_url('debt_manager_app/contract_is_due') ?>">Danh sách HD đến
							hạn</a>
					</small>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">

						<?php if ($this->session->flashdata('error')) { ?>
							<div class="alert alert-danger alert-result">
								<?= $this->session->flashdata('error') ?>
							</div>
						<?php } ?>
						<?php if ($this->session->flashdata('success')) { ?>
							<div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
						<?php } ?>
						<div class="row">
							<div class="col-sx-12 col-md-12">
								<form class="row" action="<?php echo base_url('debt_manager_app/contract_is_due') ?>"
									  method="get"
									  style="width: 100%;">
									<div class="col-lg-2">
										<label></label>
										<div class="input-group">
											<span class="input-group-addon"><?php echo $this->lang->line('from') ?></span>
											<input type="date" name="fdate" class="form-control"
												   value="<?= !empty($fdate) ? $fdate : "" ?>">
										</div>
									</div>
									<div class="col-lg-2">
										<label></label>
										<div class="input-group">
											<span class="input-group-addon"><?php echo $this->lang->line('to') ?></span>
											<input type="date" name="tdate" class="form-control"
												   value="<?= !empty($tdate) ? $tdate : "" ?>">
										</div>
									</div>
									<div class="col-lg-2">
										<label></label>
										<input type="text" name="customer_name" class="form-control"
											   placeholder="Tên khách hàng" value="<?php echo $customer_name; ?>">
									</div>
									<div class="col-lg-2">
										<label></label>
										<input type="text" name="code_contract_disbursement" class="form-control"
											   placeholder="Mã hợp đồng"
											   value="<?php echo $code_contract_disbursement; ?>">
									</div>
									<div class="col-lg-2">
										<label></label>
										<select name="store" class="form-control">
											<option value="">Chọn PGD</option>
											<?php foreach ($stores as $store) { ?>
												<option <?php echo $id_store === $store->_id->{'$oid'} ? 'selected' : '' ?>
														value="<?php echo $store->_id->{'$oid'}; ?>"><?php echo $store->name; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-lg-2">
										<label></label>
										<button type="submit"
												class="btn btn-primary w-100"><i class="fa fa-search-plus"
																				 aria-hidden="true"></i>&nbsp; Tìm kiếm
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div>
			<div class="x_content">
				<div class="row">
					<div class="col-xs-12">
						<div class="table-responsive">
							<div class="title_right text-right">
							</div>
							<div>Hiển thị
								<span class="text-danger"><?php echo $total_rows > 0 ? $total_rows : 0; ?> </span>
								Kết quả
							</div>
							<table id="" class="table table-striped">
								<thead>
								<tr>
									<th style="text-align: center">#</th>
									<th style="text-align: center">Mã phiếu ghi</th>
									<th style="text-align: center">Mã hợp đồng</th>
									<th style="text-align: center">Khách hàng</th>
									<th style="text-align: center">Hình thức vay</th>
									<th style="text-align: center">Thời hạn vay</th>
									<th style="text-align: center">Tiền giải ngân</th>
									<th style="text-align: center">Ngày giải ngân</th>
									<th style="text-align: center">Phòng giao dịch</th>
									<th style="text-align: center">Ngày T</th>
									<th style="text-align: center">Ngày đến hạn kỳ gần nhất</th>
								</tr>
								</thead>
								<tbody>
								<?php if (!empty($contracts)) : ?>
									<?php foreach ($contracts as $key => $contract): ?>
										<tr style="text-align: center">
											<td><?php echo ++$key ?></td>
											<td>
												<?php echo !empty($contract->code_contract) ? $contract->code_contract : "" ?>
												<br>
												<a class="btn btn-success btn-sm" target="_blank"
												   href="<?php echo base_url("accountant/view_v2?id=") . $contract->_id->{'$oid'} ?>">Chi
													tiết</a>
											</td>
											<td><?php echo !empty($contract->code_contract_disbursement) ? $contract->code_contract_disbursement : '' ?></td>
											<td><?php echo !empty($contract->customer_infor->customer_name) ? $contract->customer_infor->customer_name : "" ?></td>
											<td><?php echo !empty($contract->loan_infor->type_loan->text) ? change_type_loan($contract->loan_infor->type_loan->text) . ' - ' . $contract->loan_infor->type_property->text : " " ?></td>
											<td><?php echo !empty($contract->loan_infor->number_day_loan) ? ($contract->loan_infor->number_day_loan / 30) . ' tháng' : "" ?></td>
											<td><?php echo !empty($contract->loan_infor->amount_money) ? number_format($contract->loan_infor->amount_money, 0, '.', '.') : "" ?></td>
											<td><?php echo !empty($contract->disbursement_date) ? date('d/m/Y', intval($contract->disbursement_date)) : "" ?></td>
											<td><?php echo !empty($contract->store->name) ? $contract->store->name : "" ?></td>
											<td><?php echo !empty($contract->debt->so_ngay_cham_tra) ? $contract->debt->so_ngay_cham_tra : $contract->time ?></td>
											<td><?php echo !empty($contract->detail->ngay_ky_tra) ? date('d/m/Y', $contract->detail->ngay_ky_tra) : "" ?></td>
										</tr>
									<?php endforeach; ?>
								<?php else : ?>
									<tr>
										<td colspan="20" class="text-center text-danger">Không có dữ liệu</td>
									</tr>
								<?php endif; ?>
								</tbody>
							</table>
						</div>

					</div>
				</div>
			</div>
			<div class="">
				<?php echo $pagination; ?>
			</div>
		</div>
	</div>
</div>
<script>
	$('select[name="store"]').selectize({
		create: false,
		valueField: 'code',
		labelField: 'name',
		searchField: 'name',
		maxItems: 1,
		sortField: {
			field: 'name',
			direction: 'asc'
		}
	});
</script>


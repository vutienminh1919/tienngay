<!-- page content -->
<link href="<?php echo base_url(); ?>assets/teacupplugin/magnify/css/jquery.magnify.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/teacupplugin/magnify/js/jquery.magnify.js"></script>
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<?php
	$store = !empty($_GET['store']) ? $_GET['store'] : "";
	$month = !empty($_GET['month']) ? $_GET['month'] : "";
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	?>

	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="row">
					<div class="col-xs-12">
						<h3><?= $this->lang->line('Contract_management') ?>
							<br>
							<small>
								<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a
									href="<?php echo base_url() ?>pawn/contract"><?php echo $this->lang->line('Contract_management') ?></a>
							</small>
						</h3>
					</div>
					<div class="clearfix"></div>
				</div>


			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-xs-12">
							<?php if ($this->session->flashdata('error')) { ?>
								<div class="alert alert-danger alert-result">
									<?= $this->session->flashdata('error') ?>
								</div>
							<?php } ?>
							<?php if ($this->session->flashdata('success')) { ?>
								<div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
							<?php } ?>
							<div class="row">
								<form action="<?php echo base_url('contract/index_cvkd_search') ?>" method="get" style="width: 100%;">
									<div class="col-xs-12">
										<div class="row">
											<div class="col-xs-12 col-lg-2 ">
												<label for="">Chọn PGD</label>
													<select class="form-control" name="store">
														<option value="">-- Tất cả --</option>
														<?php foreach ($stores as $key => $item): ?>
															<?php
															$check = $item->_id->{'$oid'};
															?>
															<option
																value="<?= $item->_id->{'$oid'} ?>" <?= (!empty($store) && $store == "$check") ? "selected" : "" ?>><?= $item->name ?></option>
														<?php endforeach; ?>
													</select>
											</div>
											<div class="col-xs-12 col-lg-2 ">
												<label>&nbsp;</label>
												<input type="date" name="fdate" class="form-control"
													   value="<?= !empty($fdate) ? $fdate : "" ?>">
											</div>
											<div class="col-xs-12 col-lg-2 ">
												<label>&nbsp;</label>
												<input type="date" name="tdate" class="form-control"
													   value="<?= !empty($tdate) ? $tdate : "" ?>">
											</div>
											<div class="col-xs-12 col-lg-2">
												<label>&nbsp;</label>
												<button type="submit" class="btn btn-primary w-100"><i
														class="fa fa-search"
														aria-hidden="true"></i> <?= $this->lang->line('search') ?>
												</button>
											</div>
											<div class="col-xs-12 col-lg-2">
													<label>&nbsp;</label>

													<a style="background-color: #18d102;"
													   href="<?= base_url() ?>excel/exportContract_bucket?store=<?= $store . "&fdate=" . $fdate . "&tdate=" . $tdate ?>"
													   class="btn btn-primary w-100" target="_blank"><i
															class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
														Xuất excel
													</a>
											</div>
										</div>
									</div>
								</form>
								<div class="col-xs-12">
									<div class="row">


										<div class="col-xs-12 col-lg-2">
											<div class="text_content">
												<label>Tổng gốc còn lại cho vay</label>
												<h4><?= !empty($total_du_no_dang_cho_vay) ? number_format($total_du_no_dang_cho_vay) : 0 ?></h4>
											</div>

										</div>
										<div class="col-xs-12 col-lg-2">
											<div class="text_content">
												<label>Gốc còn lại quá hạn T+10</label>

												<h4><?= !empty($total_du_no_qua_han_t10) ? number_format($total_du_no_qua_han_t10) : 0 ?></h4>
											</div>

										</div>
										<div class="col-xs-12 col-lg-2">
											<div class="text_content">
												<label>Gốc còn lại trong hạn T+10</label>

												<h4><?= (!empty($total_du_no_qua_han_t10) && !empty($total_du_no_dang_cho_vay)) ? number_format($total_du_no_dang_cho_vay - $total_du_no_qua_han_t10) : 0 ?></h4>
											</div>

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="x_content">
					<div class="table-responsive">
						<table id="summary-total"
							   class="table table-bordered m-table table-hover table-calendar table-report"
							   style="font-size: 14px;font-weight: 400;">
							<thead style="background:#5A738E; color: #ffffff;">
							<tr>
								<th style="text-align: center">STT</th>
								<th style="text-align: center">Mã phiếu ghi </th>
								<th style="text-align: center">Mã hợp đồng</th>
								<th style="text-align: center">PGD</th>
								<th style="text-align: center">Ngày giải ngân</th>
								<th  style="text-align: center">Trạng thái</th>
								<th  style="text-align: center">Bucket / Số ngày chậm trả</th>
								<th  style="text-align: center">Tổng gốc còn lại</th>
								<th  style="text-align: center">Người tạo</th>
								<th  style="text-align: center">Người tiếp quản hợp đồng</th>
								<th  style="text-align: center">Ngày tạo</th>

							</tr>
							</thead>
							<tbody>
						<?php if (!empty($contractData)): ?>
						<?php foreach ($contractData as $key => $value): ?>
							<tr>
								<td><?= ++$key ?></td>
								<td><?= !empty($value->code_contract) ? $value->code_contract : "" ?></td>
								<td><?= !empty($value->code_contract_disbursement) ? $value->code_contract_disbursement : "" ?></td>
								<td><?= !empty($value->store->name) ? $value->store->name : "" ?></td>
								<td><?= !empty($value->disbursement_date) ? date("d/m/Y H:i:s", $value->disbursement_date) : "" ?></td>
								<td><?= !empty($value->status) ? contract_status($value->status) : "" ?></td>
								<td><?= !empty($value->debt->so_ngay_cham_tra) ? get_bucket($value->debt->so_ngay_cham_tra) ." (". number_format($value->debt->so_ngay_cham_tra) .")" : "" ?></td>
								<td><?= !empty($value->debt->tong_tien_goc_con) ? number_format($value->debt->tong_tien_goc_con) : "" ?></td>
								<td><?= !empty($value->created_by) ? $value->created_by : "" ?></td>
								<td><?= !empty($value->follow_contract) ? $value->follow_contract : "" ?></td>
								<td><?= !empty($value->created_at) ? date("d/m/Y H:i:s", $value->created_at) : "" ?></td>
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


<style>
	.text_content {
		padding: 10px;
		border: 1px solid #ddd;
		font-size: 14px;
	}
	.text_content h4{
		margin-top: 0;
		color: #ff0000;
		font-weight: 600;
	}
</style>





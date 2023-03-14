<div class="right_col" role="main">

	<?php
	$fdate_month = !empty($_GET['fdate_month']) ? $_GET['fdate_month'] : date('Y-m');
	$email_user = !empty($_GET['email_user']) ? $_GET['email_user'] : "";
	$getStore = !empty($_GET['store']) ? $_GET['store'] : "";
	?>

	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>CHI TIẾT LƯƠNG THƯỞNG CHO VAY</h3>
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
								<form action="<?php echo base_url('view_payroll/index_payroll') ?>" method="get" style="width: 100%;">
									<div class="col-xs-12">
										<div class="row">

											<div class="col-xs-12 col-lg-2 ">
												<label>&nbsp;</label>
												<input type="month" name="fdate_month" class="form-control" value="<?= !empty($fdate_month) ? $fdate_month : "" ?>">
											</div>
											<?php if (in_array('cua-hang-truong', $groupRoles) && !in_array('quan-ly-khu-vuc', $groupRoles)): ?>
												<div class="col-xs-12 col-lg-2 ">
													<label>&nbsp;</label>
													<input type="text" name="email_user" class="form-control" value="<?= !empty($email_user) ? $email_user : "" ?>" placeholder="Email CVKD">
												</div>
											<?php endif; ?>
											<?php if (in_array('quan-ly-khu-vuc', $groupRoles) && !in_array('giam-doc-kinh-doanh', $groupRoles)): ?>
												<div class="col-xs-12 col-lg-2 ">
													<label>&nbsp;</label>
													<input type="text" name="email_user" class="form-control" value="<?= !empty($email_user) ? $email_user : "" ?>" placeholder="Email CVKD">
												</div>

											<?php endif; ?>

											<div class="col-xs-12 col-lg-2">
												<label>&nbsp;</label>
												<button type="submit" class="btn btn-primary w-100"><i
														class="fa fa-search"
														aria-hidden="true"></i> <?= $this->lang->line('search') ?>
												</button>
											</div>
											<?php if (in_array('giao-dich-vien', $groupRoles) && !in_array('cua-hang-truong', $groupRoles)): ?>
												<div class="col-xs-12 col-lg-2">
													<label>&nbsp;</label>
													<a style="background-color: #18d102;"
													   href="<?= base_url() ?>excel/view_payroll_cvkd?fdate_month=<?= $fdate_month  ?>"
													   class="btn btn-primary w-100" ><i
															class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
														Excel Kpi GDV
													</a>
												</div>
											<?php endif; ?>
											<?php if (in_array('cua-hang-truong', $groupRoles) || in_array('quan-ly-khu-vuc', $groupRoles)): ?>
												<div class="col-xs-12 col-lg-2">
													<label>&nbsp;</label>
													<a style="background-color: #18d102;"
													   href="<?= base_url() ?>excel/view_payroll_cvkd_list?fdate_month=<?= $fdate_month  ?>"
													   class="btn btn-primary w-100" ><i
															class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
														Excel Kpi GDV
													</a>
												</div>
												<div class="col-xs-12 col-lg-2">
													<label>&nbsp;</label>
													<a style="background-color: #18d102;"
													   href="<?= base_url() ?>excel/view_payroll_store?fdate_month=<?= $fdate_month  ?>"
													   class="btn btn-primary w-100" ><i
															class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
														Excel Kpi PGD
													</a>
												</div>
											<?php endif; ?>

										</div>
									</div>
								</form>
								<br>
								<div class="col-xs-12">
									<div class="row">
										<?php if (in_array('giao-dich-vien', $groupRoles) && !in_array('cua-hang-truong', $groupRoles)): ?>
										<div class="col-xs-12 col-lg-2">
											<div class="text_content">
												<label>
														Tổng tiền hoa hồng
														<h4><?= !empty($tong_tien_hoa_hong) ? number_format($tong_tien_hoa_hong) : 0 ?></h4>
												</label>
											</div>
										</div>
										<?php endif; ?>


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
								<th style="text-align: center">Tháng/Năm</th>
								<th style="text-align: center">Thông tin tham chiếu</th>
								<th style="text-align: center">Sản phẩm</th>
								<th style="text-align: center">Loại sản phẩm</th>
								<th style="text-align: center">Loại tài sản</th>
								<th style="text-align: center">Nguồn</th>
								<th style="text-align: center">Doanh số</th>
								<th style="text-align: center">Tiền hoa hồng</th>

							</tr>
							</thead>
							<tbody>
							<?php if (!empty($getData)): ?>
							<?php foreach ($getData as $key => $value): ?>
							<tr>
								<td style="text-align: center"><?= ++$key ?></td>
								<td style="text-align: center"><?= $value->month . "/" . $value->year ?></td>
								<td>
									<?php if ($value->commision->san_pham == "HDV"): ?>
									<a target="_blank" href="<?php echo base_url("pawn/detail?id=") . $value->id_san_pham  ?>">
										<?= !empty($value->ma_san_pham) ? $value->ma_san_pham : "" ?>
									</a>
									<?php else: ?>
									<?= !empty($value->ma_san_pham) ? $value->ma_san_pham : "" ?>
									<?php endif; ?>
								</td>
								<td>
									<?php
									$san_pham = "";
									if (!empty($value->commision->san_pham)){
										if ($value->commision->san_pham == "BH"){
											$san_pham = "Bảo hiểm";
										} elseif ($value->commision->san_pham == "HDV"){
											$san_pham = "Hợp đồng vay";
										} else {
											$san_pham = "";
										}
									}
									?>
									<?= $san_pham ?>
								</td>
								<td><?= (!empty($value->commision->loai_san_pham) && $san_pham == "Hợp đồng vay") ? loan_products($value->commision->loai_san_pham) : $value->commision->loai_san_pham ?></td>
								<td>
									<?php
									$loai_tai_san = "";
									if (!empty($value->commision->loai_tai_san)){
										if ($value->commision->loai_tai_san == "OTO"){
											$loai_tai_san = "Ô tô";
										} elseif ($value->commision->loai_tai_san == "XM"){
											$loai_tai_san = "Xe máy";
										} else {
											$loai_tai_san = "";
										}
									}
									?>
									<?= $loai_tai_san ?>
								</td>
								<td><?= !empty($value->commision->nguon) ? lead_nguon_check($value->commision->nguon) : "" ?></td>
								<td style="text-align: center"><?= !empty($value->commision->doanh_so) ? number_format($value->commision->doanh_so) : "" ?></td>
								<td style="text-align: center"><?= !empty($value->commision->tien_hoa_hong) ? number_format($value->commision->tien_hoa_hong) : 0 ?></td>
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




<script src="<?php echo base_url("assets/") ?>js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets/") ?>js/numeral.min.js"></script>
<script src="<?php echo base_url("assets/") ?>js/payroll/payroll.js"></script>

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








